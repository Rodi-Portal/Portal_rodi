<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcliente extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
    
    
    
    
    
    
    
    
    function getSubclientesEliminados(){
        $salida = "";
        $data['clientes'] = $this->subcliente_model->getSubclientesEliminados();
        if($data['clientes']){
            $salida .= '<table class="table table-striped">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th scope="col">Cliente</th>';
            $salida .= '<th scope="col">Fecha</th>';
            $salida .= '<th scope="col" width="40%">Motivo</th>';
            $salida .= '<th scope="col">Usuario</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';
            foreach($data['clientes'] as $c){
                $fecha = fecha_sinhora_espanol_bd($c->fecha_eliminado);
                $salida .= "<tr><th>".$c->nombre."</th><th>".$fecha."</th><th>".$c->motivo."</th><th>".$c->usuario."</th></tr>";
            }
            $salida .= '</tbody>';
            $salida .= '</table>';
            echo $salida;
        }
        else{
            echo $salida .= '<p style="text-align:center">No hay registros eliminados</p>';
        }
    }


	function getCandidatosSubclientes(){
		$sub['recordsTotal'] = $this->subcliente_model->getCandidatosSubclientesTotal($this->session->userdata('idcliente'));
		$sub['recordsFiltered'] = $this->subcliente_model->getCandidatosSubclientesTotal($this->session->userdata('idcliente'));
		$sub['data'] = $this->subcliente_model->getCandidatosSubclientes($this->session->userdata('idcliente'));
		$this->output->set_output( json_encode( $sub ) );
	}
	function getCandidatosSubcliente(){
		$id_subcliente = $_GET['id_subcliente'];
		$sub['recordsTotal'] = $this->subcliente_model->getCandidatosSubclienteTotal($this->session->userdata('idcliente'), $id_subcliente);
		$sub['recordsFiltered'] = $this->subcliente_model->getCandidatosSubclienteTotal($this->session->userdata('idcliente'), $id_subcliente);
		$sub['data'] = $this->subcliente_model->getCandidatosSubcliente($this->session->userdata('idcliente'), $id_subcliente);
		$this->output->set_output( json_encode( $sub ) );
	}
	function getCandidatos(){
        $cand['recordsTotal'] = $this->subcliente_model->getTotalCandidatos($this->session->userdata('idsubcliente'));
        $cand['recordsFiltered'] = $this->subcliente_model->getTotalCandidatos($this->session->userdata('idsubcliente'));
        $cand['data'] = $this->subcliente_model->getCandidatos($this->session->userdata('idsubcliente'));
        $this->output->set_output( json_encode( $cand ) );
    }
	function addCandidate(){
        $this->form_validation->set_rules('nombre', 'Name', 'required|trim|callback_alpha_space_only_english');
        $this->form_validation->set_rules('paterno', 'First lastname', 'required|trim|callback_alpha_space_only_english');
        //$this->form_validation->set_rules('materno', 'Second lastname', 'required|trim|callback_alpha_space_only_english');
        $this->form_validation->set_rules('correo', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('celular', 'Cell phone number', 'required|numeric|max_length[10]|min_length[10]');
        $this->form_validation->set_rules('fijo', 'Home number', 'numeric|max_length[10]|min_length[10]');
        $this->form_validation->set_rules('proyecto', 'Project', 'required|numeric');
        $this->form_validation->set_rules('examen', 'Drug test', 'required|numeric');

        $this->form_validation->set_message('required','The field %s is required');
        $this->form_validation->set_message('valid_email','The field %s must be an valid email');
        $this->form_validation->set_message('numeric','The field %s must be a number');
        $this->form_validation->set_message('min_length','The field %s is not valid');
        $this->form_validation->set_message('max_length','The field %s is not valid');
        $this->form_validation->set_message('less_than','The field %s is not valid');
        $this->form_validation->set_message('greater_than','The field %s is not valid');
        if($this->form_validation->run() != TRUE){ 
            echo validation_errors();
        }
        if($this->form_validation->run() == TRUE){
            $id_cliente = $this->session->userdata('idcliente');
            $id_subcliente = $this->session->userdata('idsubcliente');
            $nombre = strtoupper($this->input->post('nombre'));
            $paterno = strtoupper($this->input->post('paterno'));
            $materno = strtoupper($this->input->post('materno'));
            $cel = $this->input->post('celular');
            $tel = $this->input->post('fijo');
            $correo = strtolower($this->input->post('correo'));
            $fecha_nacimiento = $this->input->post('fecha_nacimiento');
            $proyecto = $this->input->post('proyecto');
            $examen = $this->input->post('examen');
            $existeCandidato = $this->candidato_model->repetidoCandidato($nombre, $paterno, $materno, $correo, $id_cliente);
            if($existeCandidato > 0){
                echo $res = 0;
            }
            else{
                date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
                $id_usuario = $this->session->userdata('id');
                $last = $this->candidato_model->lastIdCandidato();
                $last = ($last == null || $last == "")? 0 : $last;
                if($fecha_nacimiento != "" && $fecha_nacimiento != null){
                    $fnacimiento = fecha_espanol_bd($fecha_nacimiento);
                }
                else{
                    $fnacimiento = NULL;
                }

                if($proyecto != 25){
                    $base = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
                    $aux = substr( md5(microtime()), 1, 8);
                    $token = md5($aux.$base);
                    $socioeconomico = 1;
                }
                if($proyecto == 25){
                    $token = "completo";
                    $socioeconomico = 0;
                }
                $tipo_antidoping = ($examen == 0)? 0:1;
                $antidoping = ($examen == 0)? NULL:$examen;
                $data = array(
                    'creacion' => $date,
                    'edicion' => $date,
                    'id_usuario_subcliente' => $id_usuario,
                    'fecha_alta' => $date,
                    'nombre' => $nombre,
                    'paterno' => $paterno,
                    'materno' => $materno,
                    'correo' => $correo,
                    'fecha_nacimiento' => $fnacimiento,
                    'token' => $token,
                    'id_cliente' => $id_cliente,
                    'id_subcliente' => $id_subcliente,
                    'celular' => $cel,
                    'telefono_casa' => $tel,
                    'id_proyecto' => $proyecto
                );
                $this->candidato_model->nuevoCandidato($data);

                //$doping = $this->candidato_model->getPaqueteAntidopingCandidato($id_cliente, $proyecto);
                $pruebas = array(
                    'creacion' => $date,
                    'edicion' => $date,
                    'id_usuario_subcliente' => $id_usuario,
                    'id_candidato' => ($last->id + 1),
                    'id_cliente' => $id_cliente,
                    'socioeconomico' => $socioeconomico,
                    'tipo_antidoping' => $tipo_antidoping,
                    'antidoping' => $antidoping
                    
                );
                $this->candidato_model->insertPruebasCandidato($pruebas);
                if($proyecto != 25){
                    $from = $this->config->item('smtp_user');
                    $to = $correo;
                    $subject = strtolower($this->session->userdata('cliente'))." - credentials for register form";
                    $datos['password'] = $aux;
                    $datos['cliente'] = strtoupper($this->session->userdata('cliente'));
                    $datos['email'] = $correo;
                    $message = $this->load->view('login/mail_view',$datos,TRUE);
                    $this->load->library('phpmailer_lib');
                    $mail = $this->phpmailer_lib->load();
                    $mail->isSMTP();
                    $mail->Host     = 'mail.rodicontrol.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'rodicontrol@rodicontrol.com';
                    $mail->Password = 'r49o*&rUm%91';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port     = 465;
                    
                    $mail->setFrom('rodicontrol@rodicontrol.com', 'Rodi');
                    $mail->addAddress($to);
                    $mail->Subject = $subject;
                    $mail->isHTML(true);
                    $mailContent = $message;
                    $mail->Body = $mailContent;

                    if(!$mail->send()){
                        //echo 'Message could not be sent.';
                        //echo 'Mailer Error: ' . $mail->ErrorInfo;
                        echo "No sent@@";
                    }else{
                        //echo 'Message has been sent';
                        echo "Sent@@".$aux;
                    }
                }
                else{
                    echo "creado";
                }
            }
        }          
	}
    function getPaqueteSubclienteProyecto(){
        $id_cliente = $this->session->userdata('idcliente');
        $id_subcliente = $this->session->userdata('idsubcliente');
        $id_proyecto = $_POST['id_proyecto'];
        $data['paquetes'] = $this->subcliente_model->getPaqueteSubclienteProyecto($id_cliente, $id_proyecto, $id_subcliente);
        $salida = "<option value=''>Select</option>";
        if($data['paquetes']){
            foreach ($data['paquetes'] as $row){
                $salida .= "<option value='".$row->id."'>".$row->nombre."</option>";
            } 
            echo $salida;
        }
        else{
            $salida .= " <option value='0'>N/A</option>";
            echo $salida;
        }
    }


    /************************************************ Rules Validate Form ************************************************/

    //Regla para nombres con espacios
    function alpha_space_only($str){
        if (!preg_match("/^[a-zA-Z ]+$/",$str)){
            $this->form_validation->set_message('alpha_space_only', 'The field %s does not must be alfanumeric and not be empty');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    function alpha_space_only_english($str){
        if (!preg_match("/^[a-zA-Z ]+$/",$str)){
            $this->form_validation->set_message('alpha_space_only_english', '%s does not must be alfanumeric and not be empty');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    function required_file(){
        $this->form_validation->set_message('required_file', 'Carga el CV o solicitud de empleo del candidato');
        if (empty($_FILES['cv']['name'])) {
                return FALSE;
            }else{
                return TRUE;
            }
    }
    function string_values($str){
        if (!preg_match("/^\d+$|^[\d,\d]+$/",$str)){
            //$this->form_validation->set_message('string_values', 'El campo %s no es válido');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    function date_format_es($str){
        if (!preg_match("/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/i",$str)){
            $this->form_validation->set_message('date_format_es', 'El campo %s no es una fecha válida');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }    
}