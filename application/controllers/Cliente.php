<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller{

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
	
   
		function getCandidatosCliente(){
			$id_usuario = $this->session->userdata('id');
			$id_cliente = $this->session->userdata('idcliente');
			$res = $this->cliente_model->getUsuario($id_usuario);

			if($res->privacidad == 0){
				$privacidad_candidato = [0];
			}
			if($res->privacidad == 1){
				$privacidad_candidato = array();
				$data['privacidades'] = $this->candidato_model->getAllPrivacidad();
				foreach($data['privacidades'] as $row){
					array_push($privacidad_candidato, $row->privacidad);
				}
			}
			if($res->privacidad > 1){
				$privacidad_candidato = [$res->privacidad];
			}
			$cand['recordsTotal'] = $this->cliente_model->getTotalCandidatosCliente($id_cliente);
			$cand['recordsFiltered'] = $this->cliente_model->getTotalCandidatosCliente($id_cliente);
			$cand['data'] = $this->cliente_model->getCandidatosCliente($id_cliente,$privacidad_candidato);
			$this->output->set_output( json_encode( $cand ) );
		}
    
	function getCandidatosSubclientes(){
		$sub['recordsTotal'] = $this->cliente_model->getCandidatosSubclientesTotal(3);
		$sub['recordsFiltered'] = $this->cliente_model->getCandidatosSubclientesTotal(3);
		$sub['data'] = $this->cliente_model->getCandidatosSubclientes(3);
		$this->output->set_output( json_encode( $sub ) );
	}
	function getCandidatosSubcliente(){
		$id_subcliente = $_GET['id_subcliente'];
		$sub['recordsTotal'] = $this->subcliente_model->getCandidatosSubclienteTotal(3, $id_subcliente);
		$sub['recordsFiltered'] = $this->subcliente_model->getCandidatosSubclienteTotal(3, $id_subcliente);
		$sub['data'] = $this->subcliente_model->getCandidatosSubcliente(3, $id_subcliente);
		$this->output->set_output( json_encode( $sub ) );
	}
	
	function addCandidate(){
		$this->form_validation->set_rules('nombre', 'Name', 'required|trim|callback_alpha_space_only_english');
		$this->form_validation->set_rules('paterno', 'First lastname', 'required|trim|callback_alpha_space_only_english');
		//$this->form_validation->set_rules('materno', 'Second lastname', 'required|trim|callback_alpha_space_only_english');
		$this->form_validation->set_rules('correo', 'Email', 'valid_email');
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
			if($this->session->userdata('idcliente') != null){
				$id_cliente = $this->session->userdata('idcliente');
			}
			else{
				$id_cliente = $this->input->post('id_cliente');
			}
				
				//$id_subcliente = $this->session->userdata('idsubcliente');
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
								$fnacimiento = fecha_ingles_bd($fecha_nacimiento);
						}
						else{
								$fnacimiento = NULL;
						}

						if($proyecto != 25 && $proyecto != 128 && $proyecto != 135 && $proyecto != 136 && $proyecto != 137 && $proyecto != 138 && $proyecto != 140 && $proyecto != 147 && $proyecto != 148){
								$base = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
								$aux = substr( md5(microtime()), 1, 8);
								$token = md5($aux.$base);
								$socioeconomico = 1;
						}
						if($proyecto == 25 || $proyecto == 128 || $proyecto == 135 || $proyecto == 136 || $proyecto == 137 || $proyecto == 138 || $proyecto == 140 || $proyecto == 147 || $proyecto == 148){
								$token = "completo";
								$socioeconomico = 0;
						}
						$tipo_antidoping = ($examen == 0)? 0:1;
						$antidoping = ($examen == 0)? NULL:$examen;
						$data = array(
								'creacion' => $date,
								'edicion' => $date,
								'id_usuario_cliente' => $id_usuario,
								'fecha_alta' => $date,
								'nombre' => $nombre,
								'paterno' => $paterno,
								'materno' => $materno,
								'correo' => $correo,
								'fecha_nacimiento' => $fnacimiento,
								'token' => $token,
								'id_cliente' => $id_cliente,
								'celular' => $cel,
								'telefono_casa' => $tel,
								'id_proyecto' => $proyecto
						);
						$this->candidato_model->nuevoCandidato($data);

						//$doping = $this->candidato_model->getPaqueteAntidopingCandidato($id_cliente, $proyecto);
						$pruebas = array(
								'creacion' => $date,
								'edicion' => $date,
								'id_usuario_cliente' => $id_usuario,
								'id_candidato' => ($last->id + 1),
								'id_cliente' => $id_cliente,
								'socioeconomico' => $socioeconomico,
								'tipo_antidoping' => $tipo_antidoping,
								'antidoping' => $antidoping
								
						);
						$this->candidato_model->insertPruebasCandidato($pruebas);
						if($proyecto != 25 && $proyecto != 128 && $proyecto != 135 && $proyecto != 136 && $proyecto != 137 && $proyecto != 138 && $proyecto != 140 && $proyecto != 147 && $proyecto != 148){
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
	function guardarCandidatoExpress(){
        $id_cliente = $this->input->post('id_cliente');
        $nombre = strtoupper($this->input->post('nombre'));
        $cel = $this->input->post('celular');
        $correo = strtolower($this->input->post('correo'));
        $proyecto = $this->input->post('proyecto');
        $accion = $this->input->post('accion');
        $id_candidato = $this->input->post('id_candidato');
        $id_subcliente = ($this->input->post('subcliente') !== null)? $this->input->post('subcliente'):0;
        $idempresa = ($this->input->post('idempresa') !== null)? $this->input->post('idempresa'):'';
        $fecha_actual = ($this->input->post('fecha_actual') !== null)? $this->input->post('fecha_actual'):'';

        if($id_cliente != 77){
        	if($accion == "nuevo"){
	        	$existeCandidato = $this->candidato_model->existeCandidatoCancelado($nombre, $proyecto, $id_cliente);
		        if($existeCandidato > 0){
		            echo $res = 0;
		        }
		        else{
		            date_default_timezone_set('America/Mexico_City');
		            $date = date('Y-m-d H:i:s');
		            $id_usuario = $this->session->userdata('id');
		            $last = $this->candidato_model->lastIdCandidato();
		            $last = ($last == null || $last == "")? 0 : $last;
		            
		            $data = array(
		                'creacion' => $date,
		                'edicion' => $date,
		                'id_usuario' => $id_usuario,
		                'fecha_alta' => $date,
		                'nombre' => $nombre,
		                'paterno' => '',
		                'materno' => '',
		                'correo' => $correo,
		                'token' => "completo",
		                'id_cliente' => $id_cliente,
		                'celular' => $cel,
		                'id_proyecto' => $proyecto,
		                'id_tipo_proceso' => 1
		            );
		            $this->candidato_model->nuevoCandidato($data);

		            $pruebas = array(
		                'creacion' => $date,
		                'edicion' => $date,
		                'id_usuario' => $id_usuario,
		                'id_candidato' => ($last->id + 1),
		                'id_cliente' => $id_cliente,
		                'socioeconomico' => 1,
		                'tipo_antidoping' => 0,
		                
		            );
		            $this->candidato_model->insertPruebasCandidato($pruebas);
		            echo "guardado";
		        }
	        }
	        if($accion == "editar"){
	        	date_default_timezone_set('America/Mexico_City');
	            $date = date('Y-m-d H:i:s');
	            $id_usuario = $this->session->userdata('id');
	            
	            $data = array(
	                'edicion' => $date,
	                'id_usuario' => $id_usuario,
	                'nombre' => $nombre,
	                'correo' => $correo,
	                'celular' => $cel,
	                'id_proyecto' => $proyecto
	            );
	            $this->candidato_model->updateCandidato($data, $id_candidato);
	            echo "guardado";
	        }
        }
        else{
        	if($accion == "nuevo"){
	        	$existeCandidato = $this->candidato_model->existeCandidatoCancelado($nombre, $proyecto, $id_cliente);
		        if($existeCandidato > 0){
		            echo $res = 0;
		        }
		        else{
		            date_default_timezone_set('America/Mexico_City');
		            $date = date('Y-m-d H:i:s');
		            $id_usuario = $this->session->userdata('id');
		            $last = $this->candidato_model->lastIdCandidato();
		            $last = ($last == null || $last == "")? 0 : $last;
		            
		            $data = array(
		                'creacion' => $date,
		                'edicion' => $date,
		                'id_usuario' => $id_usuario,
		                'fecha_alta' => $date,
		                'nombre' => $nombre,
		                'paterno' => '',
		                'materno' => '',
		                'correo' => '',
		                'token' => "completo",
		                'id_cliente' => $id_cliente,
		                'id_subcliente' => $id_subcliente,
		                'celular' => '',
		                'id_proyecto' => $proyecto,
		                'id_tipo_proceso' => 1,
		                'idempresa' => $idempresa
		            );
		            $this->candidato_model->nuevoCandidato($data);

		            $pruebas = array(
		                'creacion' => $date,
		                'edicion' => $date,
		                'id_usuario' => $id_usuario,
		                'id_candidato' => ($last->id + 1),
		                'id_cliente' => $id_cliente,
		                'socioeconomico' => 1,
		                'tipo_antidoping' => 0,
		                
		            );
		            $this->candidato_model->insertPruebasCandidato($pruebas);
		            echo "guardado";
		        }
	        }
	        if($accion == "editar"){
	        	date_default_timezone_set('America/Mexico_City');
	            $date = date('Y-m-d H:i:s');
	            $id_usuario = $this->session->userdata('id');
	            $fecha_alta = fecha_hora_espanol_bd($fecha_actual);
	            $data = array(
	                'edicion' => $date,
	                'id_usuario' => $id_usuario,
	                'nombre' => $nombre,
	                'id_subcliente' => $id_subcliente,
	                'id_proyecto' => $proyecto,
		            'fecha_alta' => $fecha_alta,
	                'idempresa' => $idempresa
	            );
	            $this->candidato_model->updateCandidato($data, $id_candidato);
	            echo "guardado";
	        }
        }
        
	}
  function getControlesById(){
    $res = $this->cliente_control_model->getById($this->input->post('id_cliente'));
    echo json_encode($res);
  }

  //* Datatable
  function get_data(){
    $ingles = $this->session->userdata('ingles');
    $idioma = ($ingles == 1)? 'ingles':'espanol';
    $data = $row = array();
    $candidatosData = $this->cliente_model->get_rows($_POST);
    
    $i = $_POST['start'];
    foreach($candidatosData as $c){
      $i++;
			$nombreProceso = '<div class="text-center">'.$c->proyecto.'</div>';
      $fecha_alta = '<div class="text-center">'.fechaTexto($c->fecha_alta, $idioma).'</div>';
      $icono_mensajes = '<div class="text-center"><a href="javascript:void(0)" data-toggle="tooltip" title="Progress messages" onclick="verMensajes('.$c->id.')" class="fa-tooltip icono_datatable fondo-azul-claro"><i class="fas fa-comment-dots"></i></a></div>';
      //* Doping
      if (!empty($c->examenDoping)) {
        if ($c->doping_hecho == 1) {
          if (!empty($c->fecha_resultado)) {
            $colorResultado = ($c->resultado_doping == 1)? 'fondo-rojo': 'fondo-verde';
						$doping = '<div style="float:left;width:33%;text-align:center"><small><b>'.$c->examenDoping.':</b></small><br><a href="'.site_url('Doping/createPDF?id='.$c->idDoping).'" data-toggle="tooltip" title="Download result" class="fa-tooltip icono_datatable '.$colorResultado.'"><i class="fas fa-file-pdf"></i></a></div>';
          } else {
						$doping = '<div style="float:left;width:33%;text-align:center"><small><b>'.$c->examenDoping.':</b></small><br>Waiting for results</div>';
          }
        } else {
					$doping = '<div style="float:left;width:33%;text-align:center"><small><b>'.$c->examenDoping.':</b></small><br>Pending</div>';
        }
      }
      if (empty($c->tipo_antidoping)) {
        // $doping = '<span class="badge badge-light">Drug test: NA</span>';
        $doping = '<div style="float:left;width:33%;text-align:center"><small><b>Drugs:</b></small><br>NA</div>';
      }
			//* Medico
      if ($c->medico == 1) {
				if(!empty($c->idMedico)){
					if(!empty($c->archivo_examen_medico) && empty($c->conclusionMedica)){
						$carpetaExamen = base_url().'_clinico/';
          	$medico = '<div style="float:left;width:33%;text-align:center"><small><b>Medical:</b></small><br><a href="' . $carpetaExamen . $c->archivo_examen_medico . '" target="_blank" data-toggle="tooltip" title="Download result" class="fa-tooltip icono_datatable fondo-azul-claro"><i class="fas fa-file-medical"></i></a></div>';
					}
					if(empty($c->archivo_examen_medico) && !empty($c->conclusionMedica)){
            $medico = '<div style="float:left;width:33%;text-align:center"><small><b>Medical:</b></small><br><a href="'.site_url('Medico/crearPDF?id='.$c->idMedico).'" data-toggle="tooltip" title="Download result" class="fa-tooltip icono_datatable fondo-azul-claro"><i class="fas fa-file-pdf"></i></a></div>';
					}
					if(empty($c->archivo_examen_medico) && empty($c->conclusionMedica)){
            $medico = '<div style="float:left;width:33%;text-align:center"><small><b>Medical:</b></small><br>Waiting for results</div>';
					}
				}
				else{
          $medico = '<div style="float:left;width:33%;text-align:center"><small><b>Medical:</b></small><br>Pending</div>';
				}
			}
			else{
        $medico = '<div style="float:left;width:33%;text-align:center"><small><b>Medical:</b></small><br>NA</div>';
			}
			//* Psicometria
			if ($c->psicometrico == 1) {
				if(!empty($c->idPsicometrio) && !empty($c->psicometria)){
					$carpetaExamen = base_url().'_psicometria/';
					$psicometrico = '<div style="float:left;width:33%;text-align:center"><small><b>Psychometric:</b></small><br><a href="' . $carpetaExamen . $c->psicometria . '" target="_blank" data-toggle="tooltip" title="Download result" class="fa-tooltip icono_datatable fondo-morado"><i class="fas fa-file-powerpoint text-white"></i></a></div>';
				}
				else{
          $psicometrico = '<div style="float:left;width:33%;text-align:center"><small><b>Psychometric:</b></small><br>Pending</div>';
				}
			}
			else{
        $psicometrico = '<div style="float:left;width:33%;text-align:center"><small><b>Psychometric:</b></small><br>NA</div>';
			}

			$examenes = $doping.$medico.$psicometrico;



      $data[] = array($c->candidato, $nombreProceso, $fecha_alta, $icono_mensajes, $examenes, $c->status_bgc);
    }
    
    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->cliente_model->count_all(),
      "recordsFiltered" => $this->cliente_model->count_filtered($_POST),
      "data" => $data,
    );
    
    // Output to JSON format
    echo json_encode($output);
  }
    /*----------------------------------------*/
    /*  Reglas de validacion
    /*----------------------------------------*/
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
            $this->form_validation->set_message('string_values', 'El campo %s no es válido');
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