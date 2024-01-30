<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_Ust extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
  function index(){
		if (
			$this->session->userdata('logueado') &&
			$this->session->userdata('tipo') == 1 &&
			$this->session->userdata('idrol') == 1 || $this->session->userdata('idrol') == 2 || $this->session->userdata('idrol') == 6 || $this->session->userdata('idrol') == 9
		) 
        {
			$data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
			$data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
      foreach($data['submodulos'] as $row) {
        $items[] = $row->id_submodulo;
      }
      $data['submenus'] = $items;
			$info['estados'] = $this->funciones_model->getEstados();
			$info['tipos_docs'] = $this->funciones_model->getTiposDocumentos();
			$datos['modals'] = $this->load->view('modals/mdl_ust',$info, TRUE);
			$config = $this->funciones_model->getConfiguraciones();
			$data['version'] = $config->version_sistema;

      //Modals
      $modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);

      $notificaciones = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0,1]);
      if(!empty($notificaciones)){
        $contador = 0;
        foreach($notificaciones as $row){
          if($row->visto == 0){
            $contador++;
          }
        }
        $data['contadorNotificaciones'] = $contador;
      }
      
			$this->load
			->view('adminpanel/header', $data)
			->view('adminpanel/scripts', $modales)
			->view('analista/ust_index', $datos)
			->view('adminpanel/footer');
		} else {
			redirect('Login/index');
		}
	}
  /*----------------------------------------*/
	/*  Consultas
	/*----------------------------------------*/
    function geCandidatosESE(){
      $cand['recordsTotal'] = $this->cliente_ust_model->getTotalESE();
      $cand['recordsFiltered'] = $this->cliente_ust_model->getTotalESE();
      $cand['data'] = $this->cliente_ust_model->getCandidatosESE();
      $this->output->set_output(json_encode($cand));
    }
    function getCandidatosFACIS(){
      $cand['recordsTotal'] = $this->cliente_ust_model->getTotalFACIS();
      $cand['recordsFiltered'] = $this->cliente_ust_model->getTotalFACIS();
      $cand['data'] = $this->cliente_ust_model->getCandidatosFACIS();
      $this->output->set_output(json_encode($cand));
    }
		function getCandidatosPanelCliente(){
			$cand['recordsTotal'] = $this->cliente_ust_model->getTotalPanelCliente($this->session->userdata('idcliente'));
			$cand['recordsFiltered'] = $this->cliente_ust_model->getTotalPanelCliente($this->session->userdata('idcliente'));
			$cand['data'] = $this->cliente_ust_model->getCandidatosPanelCliente($this->session->userdata('idcliente'));
			$this->output->set_output( json_encode( $cand ) );
		}
    function getReferenciasPersonales(){
      $id_candidato = $this->input->post('id_candidato');
      $salida = "";
      $data['refs'] = $this->candidato_model->getReferenciasPersonales($id_candidato);
      if($data['refs']){
				foreach($data['refs'] as $ref){
					$salida .= $ref->nombre."@@";
					$salida .= $ref->telefono."@@";
					$salida .= $ref->tiempo_conocerlo."@@";
					$salida .= $ref->donde_conocerlo."@@";
					$salida .= $ref->sabe_trabajo."@@";
					$salida .= $ref->sabe_vive."@@";
					$salida .= $ref->id."@@";
					$salida .= $ref->comentario."###";
				}
				echo $salida;
      }
      else{
				echo $salida = 0;
      }
    }
    function getReferenciasLaborales(){
      $id_candidato = $this->input->post('id_candidato');
      $salida = "";
      $data['referencias'] = $this->candidato_model->getReferenciasLaborales($id_candidato);
      if($data['referencias']){
				foreach($data['referencias'] as $ref){
					$salida .= $ref->empresa."@@";
					$salida .= $ref->direccion."@@";
					$salida .= $ref->fecha_entrada."@@";
					$salida .= $ref->fecha_salida."@@";
					$salida .= $ref->telefono."@@";
					$salida .= $ref->puesto1."@@";
					$salida .= $ref->puesto2."@@";
					$salida .= $ref->salario1."@@";
					$salida .= $ref->salario2."@@";
					$salida .= $ref->jefe_nombre."@@";
					$salida .= $ref->jefe_correo."@@";
					$salida .= $ref->jefe_puesto."@@";
					$salida .= $ref->causa_separacion."@@";
					$salida .= $ref->id."###";
				}
      }
      echo $salida;
    }
    function getVerificacionesLaborales(){
      $id_candidato = $this->input->post('id_candidato');
      $salida = "";
      $data['referencias'] = $this->candidato_model->getVerificacionReferencias($id_candidato);
      if($data['referencias']){
          foreach($data['referencias'] as $ref){
              $salida .= $ref->empresa."@@";
              $salida .= $ref->direccion."@@";
              $salida .= $ref->fecha_entrada."@@";
              $salida .= $ref->fecha_salida."@@";
              $salida .= $ref->telefono."@@";
              $salida .= $ref->puesto1."@@";
              $salida .= $ref->puesto2."@@";
              $salida .= $ref->salario1."@@";
              $salida .= $ref->salario2."@@";
              $salida .= $ref->jefe_nombre."@@";
              $salida .= $ref->jefe_correo."@@";
              $salida .= $ref->jefe_puesto."@@";
              $salida .= $ref->causa_separacion."@@";
              $salida .= $ref->notas."@@";
              $salida .= $ref->demanda."@@";
              $salida .= $ref->responsabilidad."@@";
              $salida .= $ref->iniciativa."@@";
              $salida .= $ref->eficiencia."@@";
              $salida .= $ref->disciplina."@@";
              $salida .= $ref->puntualidad."@@";
              $salida .= $ref->limpieza."@@";
              $salida .= $ref->estabilidad."@@";
              $salida .= $ref->emocional."@@";
              $salida .= $ref->honestidad."@@";
              $salida .= $ref->rendimiento."@@";
              $salida .= $ref->actitud."@@";
              $salida .= $ref->recontratacion."@@";
              $salida .= $ref->motivo_recontratacion."@@";
              $salida .= $ref->id."@@";
              $salida .= $ref->numero_referencia."###";
          }
          
      }
      echo $salida;
    }
    function checkVerificacionDocumentos(){
      $id_candidato = $this->input->post('id_candidato');
      $salida = "";
      $data['docs'] = $this->candidato_model->checkVerificacionDocumentos($id_candidato);
      if($data['docs']){
          foreach($data['docs'] as $doc){
              $salida .= $doc->licencia.'@@';
              $salida .= $doc->licencia_institucion.'@@';
              $salida .= $doc->ine.'@@';
              $salida .= $doc->ine_ano.'@@';
              $salida .= $doc->ine_vertical.'@@';
              $salida .= $doc->ine_institucion.'@@';
              $salida .= $doc->penales.'@@';
              $salida .= $doc->penales_institucion.'@@';
              $salida .= $doc->comentarios.'@@';
              $salida .= $doc->pasaporte.'@@';
              $salida .= $doc->pasaporte_fecha.'@@';
              $salida .= $doc->forma_migratoria.'@@';
              $salida .= $doc->forma_migratoria_fecha;
          }
          echo $salida;
      }
      else{
          echo $salida = 0;
      }
    }
    function getFamiliares(){
      $id_candidato = $this->input->post('id_candidato');
      $salida = '';
      $data['familia'] = $this->candidato_model->getFamiliaresCandidato($id_candidato);
      if(isset($data['familia'])){
          foreach($data['familia'] as $f){
              $salida .= $f->id_tipo_parentesco.'@@';
              $salida .= $f->nombre.'@@';
              $salida .= $f->edad.'@@';
              $salida .= $f->puesto.'@@';
              $salida .= $f->ciudad.'@@';
              $salida .= $f->empresa.'@@';
              $salida .= $f->misma_vivienda.'@@';
              $salida .= $f->id.'###';
          }
          echo $salida;
      }
      else{
          echo $salida = 0;
      }
    }
  /*----------------------------------------*/
	/*  Proceso ESE
	/*----------------------------------------*/
    function registrarCandidato(){
      $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
      $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
      $this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
      $this->form_validation->set_rules('celular', 'Tel. Celular', 'trim|max_length[16]');
      $this->form_validation->set_rules('fijo', 'Tel. Casa', 'trim|max_length[16]');
      $this->form_validation->set_rules('proceso', 'Tipo de proceso', 'required');

      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('valid_email','El campo {field} debe ser un correo válido');
      $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('alpha','El campo {field} debe contener solo carácteres alfabéticos y sin acentos');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
        $msj = array(
          'codigo' => 0,
          'msg' => validation_errors()
        );
      } 
      else{
        $id_cliente = $this->input->post('id_cliente');
        $nombre = ucwords(strtolower($this->input->post('nombre')));
        $paterno = ucwords(strtolower($this->input->post('paterno')));
        $materno = ucwords(strtolower($this->input->post('materno')));
        $cel = $this->input->post('celular');
        $tel = $this->input->post('fijo');
        $correo = strtolower($this->input->post('correo'));
        $fecha_nacimiento = $this->input->post('fecha_nacimiento');
        $proceso = $this->input->post('proceso');
        $existeCandidato = $this->candidato_model->repetidoCandidatoUST($nombre, $paterno, $materno, $correo, $id_cliente, $proceso);
        if($existeCandidato > 0){
          $msj = array(
            'codigo' => 2,
            'msg' => 'El candidato ya existe'
          );
        }
        else{
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $id_usuario = $this->session->userdata('id');
          //$last = $this->candidato_model->lastIdCandidato();
          if($fecha_nacimiento != ""){
            $fnacimiento = fecha_ingles_bd($fecha_nacimiento);
          }
          else{
            $fnacimiento = NULL;
          }
          if($proceso == 1 || $proceso == 6 || $proceso == 7 || $proceso == 8){
            if($correo != ''){
              $base = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
              $aux = substr( md5(microtime()), 1, 8);
              $token = md5($aux.$base);
              $data = array(
                'creacion' => $date,
                'edicion' => $date,
                'tipo_formulario' => 1,
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
                'id_tipo_proceso' => $proceso
              );
              //$this->candidato_model->guardarCandidato($data);
              $id_candidato = $this->candidato_model->registrarRetornaCandidato($data);
              $datos_generales = 1;
              if($proceso == 1){
                $proyecto = 'ESE';
              }
              if($proceso == 6){
                $proyecto = 'WORLD CHECK';
              }
              if($proceso == 7){
                $proyecto = 'ESE International';
                $datos_generales = 2;
              }
              if($proceso == 8){
                $proyecto = 'ESE-WORLD CHECK';
                $datos_generales = 2;
              }
              $seccion = $this->candidato_seccion_model->getProyectoHistorial($proyecto);

              $candidato_secciones = array(
                'creacion' => $date,
                'id_usuario_cliente' => $id_usuario,
                'id_candidato' => $id_candidato,
                'proyecto' => $seccion->proyecto,
                'secciones' => $seccion->secciones,
                'lleva_identidad' => $seccion->lleva_identidad,
                'lleva_empleos' => $seccion->lleva_empleos,
                'lleva_criminal' => $seccion->lleva_criminal,
                'lleva_estudios' => $seccion->lleva_estudios,
                //'lleva_domicilios' => $seccion->lleva_domicilios,
                'lleva_gaps' => 0,
                'lleva_familiares' => $seccion->lleva_familiares,
                'lleva_credito' => $seccion->lleva_credito,
                'lleva_prohibited_parties_list' => $seccion->lleva_prohibited_parties_list,
                'id_seccion_datos_generales' => $datos_generales,
                'id_estudios' => $seccion->id_estudios,
                'id_seccion_verificacion_docs' => $seccion->id_seccion_verificacion_docs,
                'id_seccion_global_search' => $seccion->id_seccion_global_search,
                'tiempo_empleos' => $seccion->tiempo_empleos,
                'tiempo_criminales' => $seccion->tiempo_criminales,
                //'tiempo_domicilios' => $seccion->tiempo_domicilios,
                //'tiempo_credito' => $seccion->tiempo_credito,
                //'cantidad_ref_profesionales' => $seccion->cantidad_ref_profesionales,
                'cantidad_ref_personales' => $seccion->cantidad_ref_personales
              );
              $this->candidato_model->guardarSeccionCandidato($candidato_secciones);

              $info_cliente = $this->cliente_general_model->getDatosCliente($id_cliente);
              $from = $this->config->item('smtp_user');
              $to = $correo;
              $subject = strtolower($info_cliente->nombre)." - credentials for register form";
              $datos['password'] = $aux;
              $datos['cliente'] = strtoupper($info_cliente->nombre);
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
              
              $mail->setFrom('rodicontrol@rodicontrol.com', 'Process of the candidate on RODI platform');
              $mail->addAddress($to);
              $mail->Subject = $subject;
              $mail->isHTML(true);
              $mailContent = $message;
              $mail->Body = $mailContent;
              if(!$mail->send()){
                $msj = array(
                  'codigo' => 3,
                  'msg' => 'Correo no enviado'
                );
              }
              else{
                $msj = array(
                  'codigo' => 1,
                  'msg' => $aux
                );
              }
            }
            else{
              $msj = array(
                'codigo' => 4,
                'msg' => 'El correo es necesario para este proceso'
              );
            }
          }
          if($proceso == 2){
            $data = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_usuario_cliente' => $id_usuario,
              'fecha_alta' => $date,
              'nombre' => strtoupper($nombre),
              'paterno' => strtoupper($paterno),
              'materno' => strtoupper($materno),
              'correo' => $correo,
              'fecha_nacimiento' => $fnacimiento,
              'id_cliente' => $id_cliente,
              'celular' => $cel,
              'telefono_casa' => $tel,
              'id_tipo_proceso' => $proceso
            );
            $this->candidato_model->guardarCandidato($data);
            $msj = array(
              'codigo' => 1,
              'msg' => 'Success'
            );
          }
        }
      }
      echo json_encode($msj);
    }
    function guardarDatosGenerales(){
      $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
      $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
      $this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
      $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required|trim');
      $this->form_validation->set_rules('nacionalidad', 'Nacionalidad', 'required|trim');
      $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
      $this->form_validation->set_rules('genero', 'Género', 'required|trim');
      $this->form_validation->set_rules('calle', 'Calle', 'required|trim');
      $this->form_validation->set_rules('exterior', 'No. Exterior', 'required|trim|max_length[8]');
      $this->form_validation->set_rules('interior', 'No. Interior', 'trim|max_length[8]');
      $this->form_validation->set_rules('colonia', 'Colonia', 'required|trim');
      $this->form_validation->set_rules('estado', 'Estado', 'required|trim|numeric');
      $this->form_validation->set_rules('municipio', 'Municipio', 'required|trim|numeric');
      $this->form_validation->set_rules('cp', 'Código postal', 'required|trim|numeric|max_length[5]');
      $this->form_validation->set_rules('civil', 'Civil', 'required|trim');
      $this->form_validation->set_rules('celular_general', 'Tel. Celular', 'required|trim|max_length[16]');
      $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
      $this->form_validation->set_rules('tel_oficina', 'Tel. Otro', 'trim|max_length[16]');
      $this->form_validation->set_rules('personales_correo', 'Correo', 'required|trim|valid_email');

      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('valid_email','El campo {field} debe ser un correo válido');
      $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('alpha','El campo {field} debe contener solo carácteres alfabéticos y sin acentos');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');


      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $id_candidato = $this->input->post('id_candidato');
          $id_usuario = $this->session->userdata('id');
          $fecha = fecha_ingles_bd($this->input->post('fecha_nacimiento'));
          $edad = calculaEdad($fecha);

          $candidato = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              'nombre' => $this->input->post('nombre'),
              'paterno' => $this->input->post('paterno'),
              'materno' => $this->input->post('materno'),
              'fecha_nacimiento' => $fecha,
              'edad' => $edad,
              'puesto' => $this->input->post('puesto'),
              'nacionalidad' => $this->input->post('nacionalidad'),
              'genero' => $this->input->post('genero'),
              'calle' => $this->input->post('calle'),
              'exterior' => $this->input->post('exterior'),
              'interior' => $this->input->post('interior'),
              'colonia' => $this->input->post('colonia'),
              'id_estado' => $this->input->post('estado'),
              'id_municipio' => $this->input->post('municipio'),
              'cp' => $this->input->post('cp'),
              'estado_civil' => $this->input->post('civil'),
              'celular' => $this->input->post('celular_general'),
              'telefono_casa' => $this->input->post('tel_casa'),
              'telefono_otro' => $this->input->post('tel_oficina'),
              'correo' => $this->input->post('personales_correo')
          );
          $this->candidato_model->editarCandidato($candidato, $id_candidato);
          $msj = array(
              'codigo' => 1,
              'msg' => 'success'
          );
      }
      echo json_encode($msj);
    }
    function guardarDatosGenerales2(){
      $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
      $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
      $this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
      $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required|trim');
      $this->form_validation->set_rules('nacionalidad', 'Nacionalidad', 'required|trim');
      $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
      $this->form_validation->set_rules('genero', 'Género', 'required|trim');
      $this->form_validation->set_rules('domicilio_internacional', 'Domicilio completo', 'required|trim');
      $this->form_validation->set_rules('civil', 'Civil', 'required|trim');
      $this->form_validation->set_rules('celular_general', 'Tel. Celular', 'required|trim|max_length[16]');
      $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
      $this->form_validation->set_rules('tel_oficina', 'Tel. Otro', 'trim|max_length[16]');
      $this->form_validation->set_rules('personales_correo', 'Correo', 'required|trim|valid_email');

      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('valid_email','El campo {field} debe ser un correo válido');
      $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('alpha','El campo {field} debe contener solo carácteres alfabéticos y sin acentos');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');


      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $id_candidato = $this->input->post('id_candidato');
          $id_usuario = $this->session->userdata('id');
          $fecha = fecha_ingles_bd($this->input->post('fecha_nacimiento'));
          $edad = calculaEdad($fecha);

          $candidato = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              'nombre' => $this->input->post('nombre'),
              'paterno' => $this->input->post('paterno'),
              'materno' => $this->input->post('materno'),
              'fecha_nacimiento' => $fecha,
              'edad' => $edad,
              'puesto' => $this->input->post('puesto'),
              'nacionalidad' => $this->input->post('nacionalidad'),
              'genero' => $this->input->post('genero'),
              'domicilio_internacional' => $this->input->post('domicilio_internacional'),
              'estado_civil' => $this->input->post('civil'),
              'celular' => $this->input->post('celular_general'),
              'telefono_casa' => $this->input->post('tel_casa'),
              'telefono_otro' => $this->input->post('tel_oficina'),
              'correo' => $this->input->post('personales_correo')
          );
          $this->candidato_model->editarCandidato($candidato, $id_candidato);
          $msj = array(
              'codigo' => 1,
              'msg' => 'success'
          );
      }
      echo json_encode($msj);
    }
    function guardarHistorialAcademico(){
      $this->form_validation->set_rules('prim_periodo', 'Primaria periodo', 'required|trim');
      $this->form_validation->set_rules('prim_escuela', 'Primaria escuela', 'required|trim');
      $this->form_validation->set_rules('prim_ciudad', 'Primaria ciudad', 'required|trim');
      $this->form_validation->set_rules('prim_certificado', 'Primaria certificado', 'required|trim');
      $this->form_validation->set_rules('prim_validado', 'Primaria validada', 'required|trim');
      $this->form_validation->set_rules('sec_periodo', 'Secundaria periodo', 'required|trim');
      $this->form_validation->set_rules('sec_escuela', 'Secundaria escuela', 'required|trim');
      $this->form_validation->set_rules('sec_ciudad', 'Secundaria ciudad', 'required|trim');
      $this->form_validation->set_rules('sec_certificado', 'Secundaria certificado', 'required|trim');
      $this->form_validation->set_rules('sec_validado', 'Secundaria validada', 'required|trim');
      $this->form_validation->set_rules('prep_periodo', 'Bachillerato periodo', 'required|trim');
      $this->form_validation->set_rules('prep_escuela', 'Bachillerato escuela', 'required|trim');
      $this->form_validation->set_rules('prep_ciudad', 'Bachillerato ciudad', 'required|trim');
      $this->form_validation->set_rules('prep_certificado', 'Bachillerato certificado', 'required|trim');
      $this->form_validation->set_rules('prep_validado', 'Bachillerato validada', 'required|trim');
      $this->form_validation->set_rules('lic_periodo', 'Licenciatura periodo', 'required|trim');
      $this->form_validation->set_rules('lic_escuela', 'Licenciatura escuela', 'required|trim');
      $this->form_validation->set_rules('lic_ciudad', 'Licenciatura ciudad', 'required|trim');
      $this->form_validation->set_rules('lic_certificado', 'Licenciatura certificado', 'required|trim');
      $this->form_validation->set_rules('lic_validado', 'Licenciatura validada', 'required|trim');
      $this->form_validation->set_rules('otro_certificado', 'Otros certificados/cursos', 'required|trim');
      $this->form_validation->set_rules('carrera_inactivo', 'Periodos inactivos', 'required|trim');
      $this->form_validation->set_rules('estudios_comentarios', 'Comentarios', 'required|trim');

      $this->form_validation->set_message('required','El campo {field} es obligatorio');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $id_candidato = $this->input->post('id_candidato');
          $id_usuario = $this->session->userdata('id');

          $comercial_periodo = ($this->input->post('comercial_periodo') !== null)? $this->input->post('comercial_periodo'):'';
          $comercial_escuela = ($this->input->post('comercial_escuela') !== null)? $this->input->post('comercial_escuela'):'';
          $comercial_ciudad = ($this->input->post('comercial_ciudad') !== null)? $this->input->post('comercial_ciudad'):'';
          $comercial_certificado = ($this->input->post('comercial_certificado') !== null)? $this->input->post('comercial_certificado'):'';
          $comercial_promedio = ($this->input->post('comercial_promedio') !== null)? $this->input->post('comercial_promedio'):'';
          $actual_periodo = ($this->input->post('actual_periodo') !== null)? $this->input->post('actual_periodo'):'';
          $actual_escuela = ($this->input->post('actual_escuela') !== null)? $this->input->post('actual_escuela'):'';
          $actual_ciudad = ($this->input->post('actual_ciudad') !== null)? $this->input->post('actual_ciudad'):'';
          $actual_certificado = ($this->input->post('actual_certificado') !== null)? $this->input->post('actual_certificado'):'';
          $actual_promedio = ($this->input->post('actual_promedio') !== null)? $this->input->post('actual_promedio'):'';
          $cedula = ($this->input->post('cedula') !== null)? $this->input->post('cedula'):'';
          $prim_validado = ($this->input->post('prim_validado') !== null)? $this->input->post('prim_validado'):0;
          $prim_promedio = ($this->input->post('prim_promedio') !== null)? $this->input->post('prim_promedio'):'';
          $sec_validado = ($this->input->post('sec_validado') !== null)? $this->input->post('sec_validado'):0;
          $sec_promedio = ($this->input->post('sec_promedio') !== null)? $this->input->post('sec_promedio'):'';
          $prep_validado = ($this->input->post('prep_validado') !== null)? $this->input->post('prep_validado'):0;
          $prep_promedio = ($this->input->post('prep_promedio') !== null)? $this->input->post('prep_promedio'):'';
          $lic_validado = ($this->input->post('lic_validado') !== null)? $this->input->post('lic_validado'):0;
          $lic_promedio = ($this->input->post('lic_promedio') !== null)? $this->input->post('lic_promedio'):'';

          $data['estudios'] = $this->candidato_model->revisionEstudios($id_candidato);
          if($data['estudios']){
              $estudios = array(
                  'edicion' => $date,
                  'id_usuario' => $id_usuario,
                  'primaria_periodo' => $this->input->post('prim_periodo'),
                  'primaria_escuela' => $this->input->post('prim_escuela'),
                  'primaria_ciudad' => $this->input->post('prim_ciudad'),
                  'primaria_certificado' => $this->input->post('prim_certificado'),
                  'primaria_promedio' => $prim_promedio,
                  'primaria_validada' => $prim_validado,
                  'secundaria_periodo' => $this->input->post('sec_periodo'),
                  'secundaria_escuela' => $this->input->post('sec_escuela'),
                  'secundaria_ciudad' => $this->input->post('sec_ciudad'),
                  'secundaria_certificado' => $this->input->post('sec_certificado'),
                  'secundaria_promedio' => $sec_promedio,
                  'secundaria_validada' => $sec_validado,
                  'comercial_periodo' => $comercial_periodo,
                  'comercial_escuela' => $comercial_escuela,
                  'comercial_ciudad' => $comercial_ciudad,
                  'comercial_certificado' => $comercial_certificado,
                  'comercial_promedio' => $comercial_promedio,
                  'preparatoria_periodo' => $this->input->post('prep_periodo'),
                  'preparatoria_escuela' => $this->input->post('prep_escuela'),
                  'preparatoria_ciudad' => $this->input->post('prep_ciudad'),
                  'preparatoria_certificado' => $this->input->post('prep_certificado'),
                  'preparatoria_promedio' => $prep_promedio,
                  'preparatoria_validada' => $prep_validado,
                  'licenciatura_periodo' => $this->input->post('lic_periodo'),
                  'licenciatura_escuela' => $this->input->post('lic_escuela'),
                  'licenciatura_ciudad' => $this->input->post('lic_ciudad'),
                  'licenciatura_certificado' => $this->input->post('lic_certificado'),
                  'licenciatura_promedio' => $lic_promedio,
                  'licenciatura_validada' => $lic_validado,
                  'actual_periodo' => $actual_periodo,
                  'actual_escuela' => $actual_escuela,
                  'actual_ciudad' => $actual_ciudad,
                  'actual_certificado' => $actual_certificado,
                  'actual_promedio' => $actual_promedio,
                  'cedula_profesional' => $cedula,
                  'otros_certificados' => $this->input->post('otro_certificado'),
                  'comentarios' => $this->input->post('estudios_comentarios'),
                  'carrera_inactivo' => $this->input->post('carrera_inactivo')
              );
              $this->candidato_model->editarEstudios($estudios, $id_candidato);
          }
          else{
              $estudios = array(
                  'creacion' => $date,
                  'edicion' => $date,
                  'id_usuario' => $id_usuario,
                  'id_candidato' => $id_candidato,
                  'primaria_periodo' => $this->input->post('prim_periodo'),
                  'primaria_escuela' => $this->input->post('prim_escuela'),
                  'primaria_ciudad' => $this->input->post('prim_ciudad'),
                  'primaria_certificado' => $this->input->post('prim_certificado'),
                  'primaria_promedio' => $prim_promedio,
                  'primaria_validada' => $prim_validado,
                  'secundaria_periodo' => $this->input->post('sec_periodo'),
                  'secundaria_escuela' => $this->input->post('sec_escuela'),
                  'secundaria_ciudad' => $this->input->post('sec_ciudad'),
                  'secundaria_certificado' => $this->input->post('sec_certificado'),
                  'secundaria_promedio' => $sec_promedio,
                  'secundaria_validada' => $sec_validado,
                  'comercial_periodo' => $comercial_periodo,
                  'comercial_escuela' => $comercial_escuela,
                  'comercial_ciudad' => $comercial_ciudad,
                  'comercial_certificado' => $comercial_certificado,
                  'comercial_promedio' => $comercial_promedio,
                  'preparatoria_periodo' => $this->input->post('prep_periodo'),
                  'preparatoria_escuela' => $this->input->post('prep_escuela'),
                  'preparatoria_ciudad' => $this->input->post('prep_ciudad'),
                  'preparatoria_certificado' => $this->input->post('prep_certificado'),
                  'preparatoria_promedio' => $prep_promedio,
                  'preparatoria_validada' => $prep_validado,
                  'licenciatura_periodo' => $this->input->post('lic_periodo'),
                  'licenciatura_escuela' => $this->input->post('lic_escuela'),
                  'licenciatura_ciudad' => $this->input->post('lic_ciudad'),
                  'licenciatura_certificado' => $this->input->post('lic_certificado'),
                  'licenciatura_promedio' => $lic_promedio,
                  'licenciatura_validada' => $lic_validado,
                  'actual_periodo' => $actual_periodo,
                  'actual_escuela' => $actual_escuela,
                  'actual_ciudad' => $actual_ciudad,
                  'actual_certificado' => $actual_certificado,
                  'actual_promedio' => $actual_promedio,
                  'cedula_profesional' => $cedula,
                  'otros_certificados' => $this->input->post('otro_certificado'),
                  'comentarios' => $this->input->post('estudios_comentarios'),
                  'carrera_inactivo' => $this->input->post('carrera_inactivo')
              );
              $this->candidato_model->guardarEstudios($estudios);
          }
          //$this->generarAvancesUST($id_candidato);
          $msj = array(
              'codigo' => 1,
              'msg' => 'success'
          );
      }
      echo json_encode($msj);
    }
    function guardarVerificacionDocumentos(){
      $this->form_validation->set_rules('lic_profesional', 'No. Documento del comprobante estudios', 'required|trim');
      $this->form_validation->set_rules('lic_institucion', 'Fecha y/o institución del comprobante de estudios', 'required|trim');
      $this->form_validation->set_rules('ine_clave', 'ID o clave', 'required|trim|max_length[18]');
      $this->form_validation->set_rules('ine_registro', 'Año de registro del ID', 'required|trim|max_length[4]|numeric');
      $this->form_validation->set_rules('ine_vertical', 'No. vertical del ID', 'required|trim|max_length[13]|numeric');
      $this->form_validation->set_rules('ine_institucion', 'Fecha y/o institución del ID', 'required|trim');
      $this->form_validation->set_rules('doc_comentarios', 'Comentarios', 'required|trim');
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $id_candidato = $this->input->post('id_candidato');
          $id_usuario = $this->session->userdata('id');
          $candidato = array(
              'id_usuario' => $id_usuario
          );
          $this->candidato_model->editarCandidato($candidato, $id_candidato);

          $domicilio = ($this->input->post('domicilio_numero') !== null)? $this->input->post('domicilio_numero'):"";
          $domicilio_fecha = ($this->input->post('domicilio_fecha') !== null)? $this->input->post('domicilio_fecha'):"";
          $militar = ($this->input->post('militar_numero') !== null)? $this->input->post('militar_numero'):"";
          $militar_fecha = ($this->input->post('militar_fecha') !== null)? $this->input->post('militar_fecha'):"";
          $pasaporte = ($this->input->post('pasaporte_numero') !== null)? $this->input->post('pasaporte_numero'):"";
          $pasaporte_fecha = ($this->input->post('pasaporte_institucion') !== null)? $this->input->post('pasaporte_institucion'):"";

          $verificacion_documento = array(
						'creacion' => $date,
						'id_usuario' => $id_usuario,
						'id_candidato' => $id_candidato,
						'licencia' => $this->input->post('lic_profesional'),
						'licencia_institucion' => $this->input->post('lic_institucion'),
						'ine' => strtoupper($this->input->post('ine_clave')),
						'ine_ano' => $this->input->post('ine_registro'),
						'ine_vertical' => $this->input->post('ine_vertical'),
						'ine_institucion' => $this->input->post('ine_institucion'),
						'penales' => $this->input->post('penales_numero'),
						'penales_institucion' => $this->input->post('penales_institucion'),
						'pasaporte' => $pasaporte,
						'pasaporte_fecha' => $pasaporte_fecha,
						'domicilio' => $domicilio,
						'fecha_domicilio' => $domicilio_fecha,
						'militar' => $militar,
						'militar_fecha' => $militar_fecha,
						'comentarios' => $this->input->post('doc_comentarios')
          );      
          $this->candidato_model->eliminarVerificacionDocumentos($id_candidato);
          $this->candidato_model->guardarVerificacionDocumento($verificacion_documento);
          //$this->generarAvancesUST($id_candidato);
          $msj = array(
              'codigo' => 1,
              'msg' => 'success'
          );
      }
      echo json_encode($msj);
    }
    function guardarInformacionFamiliar(){
      $this->form_validation->set_rules('parentesco', 'Parentesco', 'required|trim');
      $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
      $this->form_validation->set_rules('edad', 'Edad', 'required|trim|numeric|max_length[2]');
      $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
      $this->form_validation->set_rules('ciudad', 'Ciudad', 'required|trim');
      $this->form_validation->set_rules('empresa', 'Empresa', 'required|trim');
      $this->form_validation->set_rules('misma_vivienda', '¿Vive con ella/él?', 'required|trim');
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('alpha','El campo {field} debe contener solo carácteres alfabéticos y sin acentos');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
				date_default_timezone_set('America/Mexico_City');
				$date = date('Y-m-d H:i:s');
				$id_candidato = $this->input->post('id_candidato');
				$id_familiar = $this->input->post('id_familiar');
				$this->candidato_model->eliminarFamiliar($id_familiar);
				$familiar = array(
						'creacion' => $date,
						'edicion' => $date,
						'id_candidato' => $id_candidato,
						'nombre' => $this->input->post('nombre'),
						'id_tipo_parentesco' => $this->input->post('parentesco'),
						'edad' =>  $this->input->post('edad'),
						'ciudad' => $this->input->post('ciudad'),
						'puesto' => $this->input->post('puesto'),
						'empresa' => $this->input->post('empresa'),
						'misma_vivienda' =>  $this->input->post('misma_vivienda')
				);
				$this->candidato_model->guardarFamiliar($familiar);
				$msj = array(
						'codigo' => 1,
						'msg' => 'success'
				);
      }
      echo json_encode($msj);
    }
    function guardarReferenciaPersonal(){
        for($i = 1; $i <= 3; $i++){
            $this->form_validation->set_rules('nombre'.$i, 'Nombre de la referencia #'.$i, 'required|trim');
            $this->form_validation->set_rules('tiempo'.$i, 'Tiempo de conocerlo de la referencia #'.$i, 'required|trim|numeric|max_length[3]');
            $this->form_validation->set_rules('lugar'.$i, 'Lugar donde lo conoció de la referencia #'.$i, 'required|trim');
            $this->form_validation->set_rules('telefono'.$i, 'Teléfono de la referencia #'.$i, 'required|trim|max_length[12]');
            $this->form_validation->set_rules('trabaja'.$i, '¿Sabe dónde trabaja? de la referencia #'.$i, 'required|trim');
            $this->form_validation->set_rules('vive'.$i, '¿Sabe dónde vive? de la referencia #'.$i, 'required|trim');
            $this->form_validation->set_rules('comentario'.$i, 'Comentarios de la referencia #'.$i, 'required|trim');
        }
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
        $msj = array(
            'codigo' => 0,
            'msg' => validation_errors()
        );
      } 
      else{
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $id_usuario = $this->session->userdata('id');

        $this->candidato_model->eliminarReferenciasPersonales($id_candidato);
        for($i = 1; $i <= 3; $i++){
            $data_refper = array(
                'creacion' => $date,
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_candidato' => $id_candidato,
                'nombre' => $this->input->post('nombre'.$i),
                'telefono' => $this->input->post('telefono'.$i),
                'tiempo_conocerlo' => $this->input->post('tiempo'.$i),
                'donde_conocerlo' => $this->input->post('lugar'.$i),
                'sabe_trabajo' => $this->input->post('trabaja'.$i),
                'sabe_vive' => $this->input->post('vive'.$i),
                'comentario' => $this->input->post('comentario'.$i)
            );
            $this->candidato_model->saveRefPer($data_refper);
        }
        $msj = array(
            'codigo' => 1,
            'msg' => 'success'
        );
      }
      echo json_encode($msj);
    }
    function guardarTrabajoGobierno(){
      if($this->input->post('caso') == 1){//Para UST
          $this->form_validation->set_rules('trabajo', 'Has the candidate worked in any government entity...', 'required|trim');
          $this->form_validation->set_rules('inactivo', 'Break(s) in Employment', 'required|trim');
          
          $this->form_validation->set_message('required','El campo {field} es obligatorio');

          $msj = array();
          if ($this->form_validation->run() == FALSE) {
              $msj = array(
                  'codigo' => 0,
                  'msg' => validation_errors()
              );
          }
          else{
              date_default_timezone_set('America/Mexico_City');
              $date = date('Y-m-d H:i:s');
              $id_candidato = $this->input->post('id_candidato');
              $trabajo = ($this->input->post('trabajo')  !== null)? $this->input->post('trabajo'):'';
              $enterado = ($this->input->post('enterado') !== null)? $this->input->post('enterado'):'';
              $inactivo = ($this->input->post('inactivo')  !== null)? $this->input->post('inactivo'):'';
              $id_usuario = $this->session->userdata('id');
              $candidato = array(
                  'edicion' => $date,
                  'id_usuario' => $id_usuario,
                  'trabajo_gobierno' => $trabajo,
                  'trabajo_enterado' => $enterado,
                  'trabajo_inactivo' => $inactivo
              );
              $this->candidato_model->editarCandidato($candidato, $id_candidato);
              $msj = array(
                  'codigo' => 1,
                  'msg' => 'success'
              );
          }
          echo json_encode($msj);
      }
    }
    function guardarReferenciaLaboralCandidato(){
      $this->form_validation->set_rules('empresa', 'Empresa', 'required|trim');
      $this->form_validation->set_rules('direccion', 'Direccion', 'required|trim');
      $this->form_validation->set_rules('entrada', 'Fecha de entrada', 'required|trim');
      $this->form_validation->set_rules('salida', 'Fecha de salida', 'required|trim');
      $this->form_validation->set_rules('telefono', 'Teléfono', 'required|trim|max_length[16]');
      $this->form_validation->set_rules('puesto1', 'Puesto inicial', 'required|trim');
      $this->form_validation->set_rules('puesto2', 'Puesto final', 'required|trim');
      $this->form_validation->set_rules('salario1', 'Salario inicial', 'required|trim|numeric');
      $this->form_validation->set_rules('salario2', 'Salario final', 'required|trim|numeric');
      $this->form_validation->set_rules('jefenombre', 'Jefe inmediato', 'required|trim');
      $this->form_validation->set_rules('jefecorreo', 'Correo del jefe inmediato', 'required|trim');
      $this->form_validation->set_rules('jefepuesto', 'Puesto del jefe inmediato', 'required|trim');
      $this->form_validation->set_rules('separacion', 'Causa de separación', 'required|trim');
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $id_candidato = $this->input->post('id_candidato');
          $num = $this->input->post('num');
          $idref = $this->input->post('idref');
          $id_usuario = $this->session->userdata('id');

          $data['refs'] = $this->candidato_model->revisionReferenciaLaboral($idref);
          if($data['refs']){
              $entrada = fecha_ingles_bd($this->input->post('entrada'));
              $salida = fecha_ingles_bd($this->input->post('salida'));
              $datos = array(
                  'edicion' => $date,
                  'empresa' => ucwords(mb_strtolower( $this->input->post('empresa'))),
                  'direccion' => $this->input->post('direccion'),
                  'fecha_entrada' => $entrada,
                  'fecha_salida' => $salida,
                  'telefono' => $this->input->post('telefono'),
                  'puesto1' => $this->input->post('puesto1'),
                  'puesto2' => $this->input->post('puesto2'),
                  'salario1' => $this->input->post('salario1'),
                  'salario2' => $this->input->post('salario2'),
                  'jefe_nombre' => $this->input->post('jefenombre'),
                  'jefe_correo' => mb_strtolower($this->input->post('jefecorreo')),
                  'jefe_puesto' => $this->input->post('jefepuesto'),
                  'causa_separacion' => $this->input->post('separacion')
              );
              $this->candidato_model->editarReferenciaLaboral($datos, $idref);
              $msj = array(
                  'codigo' => 1,
                  'msg' => 'success'
              );
          }
          else{
              $entrada = fecha_ingles_bd($this->input->post('entrada'));
              $salida = fecha_ingles_bd($this->input->post('salida'));
              $datos = array(
                  'creacion' => $date,
                  'edicion' => $date,
                  'id_candidato' => $id_candidato,
                  'empresa' => ucwords(mb_strtolower( $this->input->post('empresa'))),
                  'direccion' => $this->input->post('direccion'),
                  'fecha_entrada' => $entrada,
                  'fecha_salida' => $salida,
                  'telefono' => $this->input->post('telefono'),
                  'puesto1' => $this->input->post('puesto1'),
                  'puesto2' => $this->input->post('puesto2'),
                  'salario1' => $this->input->post('salario1'),
                  'salario2' => $this->input->post('salario2'),
                  'jefe_nombre' => $this->input->post('jefenombre'),
                  'jefe_correo' => mb_strtolower($this->input->post('jefecorreo')),
                  'jefe_puesto' => $this->input->post('jefepuesto'),
                  'causa_separacion' => $this->input->post('separacion')
              );
              $id_nuevo = $this->candidato_model->guardarReferenciaLaboral($datos);
              $msj = array(
                  'codigo' => 2,
                  'msg' => $id_nuevo
              );
          }
      }
      echo json_encode($msj);
    }
    function guardarVerificacionLaboralCandidato(){
      $this->form_validation->set_rules('empresa', 'Empresa', 'required|trim');
      $this->form_validation->set_rules('direccion', 'Direccion', 'required|trim');
      $this->form_validation->set_rules('entrada', 'Fecha de entrada', 'required|trim');
      $this->form_validation->set_rules('salida', 'Fecha de salida', 'required|trim');
      $this->form_validation->set_rules('telefono', 'Teléfono', 'required|trim|max_length[16]');
      $this->form_validation->set_rules('puesto1', 'Puesto inicial', 'required|trim');
      $this->form_validation->set_rules('puesto2', 'Puesto final', 'required|trim');
      $this->form_validation->set_rules('salario1', 'Salario inicial', 'required|trim|numeric');
      $this->form_validation->set_rules('salario2', 'Salario final', 'required|trim|numeric');
      $this->form_validation->set_rules('jefenombre', 'Jefe inmediato', 'required|trim');
      $this->form_validation->set_rules('jefecorreo', 'Correo del jefe inmediato', 'required|trim');
      $this->form_validation->set_rules('jefepuesto', 'Puesto del jefe inmediato', 'required|trim');
      $this->form_validation->set_rules('separacion', 'Causa de separación', 'required|trim');
      $this->form_validation->set_rules('notas', 'Notas', 'required|trim');
      $this->form_validation->set_rules('demanda', '¿El candidato demandó a la empresa?', 'required|trim');
      $this->form_validation->set_rules('responsabilidad', 'Responsabilidad', 'required|trim');
      $this->form_validation->set_rules('iniciativa', 'Iniciativa', 'required|trim');
      $this->form_validation->set_rules('eficiencia', 'Eficiencia', 'required|trim');
      $this->form_validation->set_rules('disciplina', 'Disciplina', 'required|trim');
      $this->form_validation->set_rules('puntualidad', 'Puntualidad y asistencia', 'required|trim');
      $this->form_validation->set_rules('limpieza', 'Limpieza y orden', 'required|trim');
      $this->form_validation->set_rules('estabilidad', 'Estabilidad laboral', 'required|trim');
      $this->form_validation->set_rules('emocional', 'Estabilidad emocional', 'required|trim');
      $this->form_validation->set_rules('honesto', 'Honesto', 'required|trim');
      $this->form_validation->set_rules('rendimiento', 'Rendimiento', 'required|trim');
      $this->form_validation->set_rules('actitud', 'Actitud', 'required|trim');
      $this->form_validation->set_rules('recontratacion', '¿Lo(a) contrataría de nuevo?', 'required|trim');
      $this->form_validation->set_rules('motivo', '¿Por qué?', 'required|trim');
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $id_candidato = $this->input->post('id_candidato');
          $num = $this->input->post('num');
          $idverlab = $this->input->post('idverlab');
          $id_usuario = $this->session->userdata('id');

          $this->candidato_model->eliminarVerificacionLaboral($id_candidato, $num);
          $fentrada = fecha_ingles_bd($this->input->post('entrada'));
          $fsalida = fecha_ingles_bd($this->input->post('salida'));
          $demanda = ($this->input->post('demanda') !== null)? $this->input->post('demanda'):'';
          $verificacion_reflab = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              'id_candidato' => $id_candidato,
              'numero_referencia' => $num,
              'empresa' => $this->input->post('empresa'), 
              'direccion' => $this->input->post('direccion'),
              'fecha_entrada' => $fentrada, 
              'fecha_salida' => $fsalida,
              'telefono' => $this->input->post('telefono'),
              'puesto1' => $this->input->post('puesto1'), 
              'puesto2' => $this->input->post('puesto2'),
              'salario1' => $this->input->post('salario1'), 
              'salario2' => $this->input->post('salario2'), 
              'jefe_nombre' => $this->input->post('jefenombre'), 
              'jefe_correo' => $this->input->post('jefecorreo'),
              'jefe_puesto' => $this->input->post('jefepuesto'), 
              'causa_separacion' => $this->input->post('separacion'), 
              'notas' => $this->input->post('notas'), 
              'demanda' => $demanda, 
              'responsabilidad' => $this->input->post('responsabilidad'),
              'iniciativa' => $this->input->post('iniciativa'), 
              'eficiencia' => $this->input->post('eficiencia'), 
              'disciplina' => $this->input->post('disciplina'), 
              'puntualidad' => $this->input->post('puntualidad'),
              'limpieza' => $this->input->post('limpieza'), 
              'estabilidad' => $this->input->post('estabilidad'),
              'emocional' => $this->input->post('emocional'),
              'honestidad' => $this->input->post('honesto'),
              'rendimiento' => $this->input->post('rendimiento'),
              'actitud' => $this->input->post('actitud'),
              'recontratacion' => $this->input->post('recontratacion'),
              'motivo_recontratacion' => $this->input->post('motivo')
          );
          $this->candidato_model->guardarVerificacionLaboral($verificacion_reflab);
          //$this->generarAvancesUST($id_candidato);
          $msj = array(
              'codigo' => 1,
              'msg' => 'success'
          );
      }
      echo json_encode($msj);
    }
    function regenerarPassword(){
      $this->load->config('email');
      date_default_timezone_set('America/Mexico_City');
      $date = date('Y-m-d H:i:s');
      $id_candidato = $this->input->post('id_candidato');
      $correo = $this->input->post('correo');
      $info = $this->funciones_model->getDatosCandidato($id_candidato);
      $base = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
      $aux = substr( md5(microtime()), 1, 8);
      $token = md5($aux.$base);
      $this->candidato_model->regenerarPassword($id_candidato, $date, $token);
      $from = $this->config->item('smtp_user');
      $to = $correo;
      $subject = strtolower($info->cliente)." - credentials for register form";
      $datos['password'] = $aux;
      $datos['cliente'] = strtoupper($info->cliente);
      $datos['email'] = $correo;
      $message = $this->load->view('mails/mail_view',$datos,TRUE);
      $this->load->library('phpmailer_lib');
      $mail = $this->phpmailer_lib->load();
      $mail->isSMTP();
      $mail->Host     = 'mail.rodicontrol.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'rodicontrol@rodicontrol.com';
      $mail->Password = 'r49o*&rUm%91';
      $mail->SMTPSecure = 'ssl';
      $mail->Port     = 465;
      
      $mail->setFrom('rodicontrol@rodicontrol.com', 'Process of the candidate on RODI platform');
      $mail->addAddress($to);
      $mail->Subject = $subject;
      $mail->isHTML(true);
      $mailContent = $message;
      $mail->Body = $mailContent;
      if(!$mail->send()){
          $msj = array(
              'codigo' => 3,
              'msg' => 'No sent'
          );
      }else{
          $msj = array(
              'codigo' => 1,
              'msg' => $aux
          );
      }
      echo json_encode($msj);
    }
    function finalizarProcesoESE(){
      $this->form_validation->set_rules('check_identidad', 'Estatus identidad', 'required|trim');
      $this->form_validation->set_rules('check_laboral', 'Estatus laboral', 'required|trim');
      $this->form_validation->set_rules('check_estudios', 'Estatus estudios', 'required|trim');
      $this->form_validation->set_rules('check_penales', 'Estatus penal', 'required|trim');
      $this->form_validation->set_rules('check_ofac', 'Estatus OFAC', 'required|trim');
      $this->form_validation->set_rules('check_global', 'World Check', 'required|trim');
      //$this->form_validation->set_rules('comentario_final', 'Comentario final', 'required|trim');
      $this->form_validation->set_rules('comentario_final', 'Comentario final', 'trim');
      $this->form_validation->set_rules('bgc_status', 'Estatus final', 'required|trim');

      $this->form_validation->set_message('required','El campo {field} es obligatorio');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $id_candidato = $this->input->post('id_candidato');
          $id_usuario = $this->session->userdata('id');

          $check_visita = ($this->input->post('check_visita') !== null)? $this->input->post('check_visita'):3;
          $check_laboratorio = ($this->input->post('check_laboratorio') !== null)? $this->input->post('check_laboratorio'):3;
          $check_medico = ($this->input->post('check_medico') !== null)? $this->input->post('check_medico'):3;

          $this->candidato_model->eliminarBGC($id_candidato);
          $bgc = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              'id_candidato' => $id_candidato,
              'identidad_check' => $this->input->post('check_identidad'),
              'empleo_check' => $this->input->post('check_laboral'),
              'estudios_check' => $this->input->post('check_estudios'),
              'visita_check' => $check_visita,
              'penales_check' => $this->input->post('check_penales'),
              'ofac_check' => $this->input->post('check_ofac'),
              'laboratorio_check' => $check_laboratorio,
              'medico_check' => $check_medico,
              'global_searches_check' => $this->input->post('check_global'),
              'credito_check' => $this->input->post('check_credito'),
              'sex_offender_check' => $this->input->post('check_sex_offender'),
              'comentario_final' => $this->input->post('comentario_final')
          );
          $this->candidato_model->guardarBGC($bgc);
          $this->candidato_model->statusBGCCandidato($this->input->post('bgc_status'), $id_candidato);
          $msj = array(
              'codigo' => 1,
              'msg' => 'success'
          );
      }
      echo json_encode($msj);
    }
    function crearPDFProcesoESE(){
      $mpdf = new \Mpdf\Mpdf();
      date_default_timezone_set('America/Mexico_City');
      $data['hoy'] = date("d-m-Y");
      $hoy = date("d-m-Y");
      $id_candidato = $_POST['idCandidatoESE'];
      $data['datos'] = $this->candidato_model->getDatosCandidato($id_candidato);
      $id_usuario = $this->session->userdata('id');
      $tipo_usuario = $this->session->userdata('tipo');
      if($tipo_usuario == 1){
        $usuario = $this->usuario_model->getDatosUsuarioInterno($id_usuario);
      }
      if($tipo_usuario == 2){
        $usuario = $this->usuario_model->getDatosUsuarioCliente($id_usuario);
      }
      if($tipo_usuario == 4){
        $usuario = $this->usuario_model->getDatosUsuarioSubcliente($id_usuario);
      }
      foreach($data['datos'] as $row){
          $f = $row->fecha_alta;
          $fform = $row->fecha_contestado;
          $fdocs = $row->fecha_documentos;
          $fbgc = $row->fecha_bgc;
          $nombreCandidato = $row->nombre." ".$row->paterno." ".$row->materno;
          $cliente = $row->cliente;
          $proceso = $row->id_tipo_proceso;
      }
      $fecha_bgc = DateTime::createFromFormat('Y-m-d H:i:s', $fbgc);
      $fecha_bgc = $fecha_bgc->format('F d, Y');
      $f_alta = formatoFecha($f);
      $fform = formatoFecha($fform);
      $fdocs = formatoFecha($fdocs);
      $fbgc = formatoFecha($fbgc);
      $hoy = formatoFecha($hoy);
      $data['fecha_final'] = $fbgc;
      $data['bgc'] = $this->candidato_model->getBGC($id_candidato);
      $data['fecha_ver_laboral'] = $this->candidato_model->getFechaVerificacionLaboral($id_candidato);
      $data['fecha_ver_estudios'] = $this->candidato_model->getFechaVerificacionEstudios($id_candidato);
      $data['fecha_ver_penales'] = $this->candidato_model->getFechaVerificacionPenales($id_candidato);
      $data['fecha_ver_ofac'] = $this->candidato_model->getFechaVerificacionOfac($id_candidato);
      $data['docs'] = $this->candidato_model->getDocumentacionCandidato($id_candidato);
      $data['ver_documento'] = $this->candidato_model->getVerificacionDocumentosCandidato($id_candidato);
      $data['familia'] = $this->candidato_model->getFamiliaresCandidato($id_candidato);
      $data['estudio'] = $this->candidato_model->getEstudiosCandidato($id_candidato);
      $data['det_estudio'] = $this->candidato_model->getStatusVerificacionEstudios($id_candidato);
      $data['ref_laboral'] = $this->candidato_model->getReferenciasLaborales($id_candidato);
      $data['ver_laboral'] = $this->candidato_model->getVerificacionReferencias($id_candidato);
      $data['det_empleo'] = $this->candidato_model->getStatusVerificacionEmpleo($id_candidato);
      $data['ref_personal'] = $this->candidato_model->getReferenciasPersonales($id_candidato);
      $data['det_penales'] = $this->candidato_model->getStatusVerificacionPenales($id_candidato);
      $data['analista'] = $this->candidato_model->getAnalista($id_candidato);
      $data['coordinadora'] = $this->candidato_model->getCoordinadora($id_candidato);
      $data['estatus_estudios'] = $this->candidato_model->getEstatusEstudios($id_candidato);
			$data['estatus_laborales'] = $this->candidato_model->getEstatusLaborales($id_candidato);
			$data['estatus_penales'] = $this->candidato_model->getEstatusPenales($id_candidato);$data['cliente'] = $cliente;
      $data['global_searches'] = $this->candidato_global_model->getById($id_candidato);
      $data['fecha_bgc'] = $fecha_bgc;
      $data['secciones'] = $this->candidato_seccion_model->getSecciones($id_candidato);
      if($proceso != 6){
        $html = $this->load->view('pdfs/ust_pdf',$data,TRUE);
      }
      if($proceso == 6){
        $html = $this->load->view('pdfs/ust_world_check_pdf',$data,TRUE);
      }
      $mpdf->setAutoTopMargin = 'stretch';
      $mpdf->AddPage();
      $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="'.base_url().'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Request Date: '.$f_alta.'<br>Release Date: '.$fbgc.'</div>');
      $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="'.base_url().'img/logo_pie.png"></div>');
      //Cifrar pdf
      $nombreArchivo = substr( md5(microtime()), 1, 12);
      /*$claveAleatoria = substr( md5(microtime()), 1, 8);
      $clave = ($usuario->clave != null)? $usuario->clave:$claveAleatoria;
      $mpdf->SetProtection(array(), $clave, 'r0d1@');*/

      $mpdf->autoPageBreak = false;
      $mpdf->WriteHTML($html);
      $mpdf->Output(''.$nombreArchivo.'.pdf','D'); // opens in browser
    }
    function crearPrevio(){
      $mpdf = new \Mpdf\Mpdf();
      date_default_timezone_set('America/Mexico_City');
      $data['hoy'] = date("d-m-Y");
      $hoy = date("d-m-Y");
      $id_candidato = $_POST['idCandidatoESE'];
      $data['datos'] = $this->candidato_model->getDatosCandidato($id_candidato);
      $id_usuario = $this->session->userdata('id');
      $tipo_usuario = $this->session->userdata('tipo');
      if($tipo_usuario == 1){
        $usuario = $this->usuario_model->getDatosUsuarioInterno($id_usuario);
      }
      if($tipo_usuario == 2){
        $usuario = $this->usuario_model->getDatosUsuarioCliente($id_usuario);
      }
      if($tipo_usuario == 4){
        $usuario = $this->usuario_model->getDatosUsuarioSubcliente($id_usuario);
      }
      foreach($data['datos'] as $row){
          $f = $row->fecha_alta;
          $fform = $row->fecha_contestado;
          $fdocs = $row->fecha_documentos;
          $fbgc = $row->fecha_bgc;
          $nombreCandidato = $row->nombre." ".$row->paterno." ".$row->materno;
          $cliente = $row->cliente;
          $proceso = $row->id_tipo_proceso;
      }
      if(!empty($fbgc)){
        $fecha_bgc = DateTime::createFromFormat('Y-m-d H:i:s', $fbgc);
      }
      else{
        $fbgc = date('Y-m-d H:i:s');
        $fecha_bgc = new DateTime();
      }
      $fecha_bgc = $fecha_bgc->format('F d, Y');
      $f_alta = formatoFecha($f);
      $fform = formatoFecha($fform);
      $fdocs = formatoFecha($fdocs);
      $fbgc = formatoFecha($fbgc);
      $hoy = formatoFecha($hoy);
      $data['fecha_final'] = $fbgc;
      $data['bgc'] = $this->candidato_model->getBGC($id_candidato);
      $data['fecha_ver_laboral'] = $this->candidato_model->getFechaVerificacionLaboral($id_candidato);
      $data['fecha_ver_estudios'] = $this->candidato_model->getFechaVerificacionEstudios($id_candidato);
      $data['fecha_ver_penales'] = $this->candidato_model->getFechaVerificacionPenales($id_candidato);
      $data['fecha_ver_ofac'] = $this->candidato_model->getFechaVerificacionOfac($id_candidato);
      $data['docs'] = $this->candidato_model->getDocumentacionCandidato($id_candidato);
      $data['ver_documento'] = $this->candidato_model->getVerificacionDocumentosCandidato($id_candidato);
      $data['familia'] = $this->candidato_model->getFamiliaresCandidato($id_candidato);
      $data['estudio'] = $this->candidato_model->getEstudiosCandidato($id_candidato);
      $data['det_estudio'] = $this->candidato_model->getStatusVerificacionEstudios($id_candidato);
      $data['ref_laboral'] = $this->candidato_model->getReferenciasLaborales($id_candidato);
      $data['ver_laboral'] = $this->candidato_model->getVerificacionReferencias($id_candidato);
      $data['det_empleo'] = $this->candidato_model->getStatusVerificacionEmpleo($id_candidato);
      $data['ref_personal'] = $this->candidato_model->getReferenciasPersonales($id_candidato);
      $data['det_penales'] = $this->candidato_model->getStatusVerificacionPenales($id_candidato);
      $data['analista'] = $this->candidato_model->getAnalista($id_candidato);
      $data['coordinadora'] = $this->candidato_model->getCoordinadora($id_candidato);
      $data['estatus_estudios'] = $this->candidato_model->getEstatusEstudios($id_candidato);
			$data['estatus_laborales'] = $this->candidato_model->getEstatusLaborales($id_candidato);
			$data['estatus_penales'] = $this->candidato_model->getEstatusPenales($id_candidato);$data['cliente'] = $cliente;
      $data['global_searches'] = $this->candidato_global_model->getById($id_candidato);
      $data['fecha_bgc'] = $fecha_bgc;
      $data['secciones'] = $this->candidato_seccion_model->getSecciones($id_candidato);
      if($proceso != 6){
        $html = $this->load->view('pdfs/ust_previo_pdf',$data,TRUE);
      }
      if($proceso == 6){
        $html = $this->load->view('pdfs/ust_world_check_pdf',$data,TRUE);
      }
      $mpdf->setAutoTopMargin = 'stretch';
      $mpdf->AddPage();
      $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="'.base_url().'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Request Date: '.$f_alta.'<br>Release Date: '.$fbgc.'</div>');
      $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="'.base_url().'img/logo_pie.png"></div>');
      //Cifrar pdf
      $nombreArchivo = substr( md5(microtime()), 1, 12);
      /*$claveAleatoria = substr( md5(microtime()), 1, 8);
      $clave = ($usuario->clave != null)? $usuario->clave:$claveAleatoria;
      $mpdf->SetProtection(array(), $clave, 'r0d1@');*/

      $mpdf->autoPageBreak = false;
      $mpdf->WriteHTML($html);
      $mpdf->Output(''.$nombreArchivo.'.pdf','D'); // opens in browser
    }
  /*----------------------------------------*/
	/*  Proceso FACIS
	/*----------------------------------------*/
    function getDatosFACIS(){
      $id_candidato = $this->input->post('id_candidato');
      $salida = "";
      $data['estatus'] = $this->candidato_model->checkPruebas($id_candidato);
      if($data['estatus']){
          foreach($data['estatus'] as $l){
              $parte = explode(' ', $l->edicion);
              $aux = explode('-', $parte[0]);
              $h = explode(':', $parte[1]);
              $fecha_estatus = $aux[2].'/'.$aux[1].'/'.$aux[0].' '.$h[0].':'.$h[1];
              $res_ofac = ($l->ofac == '')? '':$l->resultado_ofac;
              $res_oig = ($l->oig == '')? '':$l->resultado_oig;
              $res_sam = ($l->sam == '')? '':$l->resultado_sam;
              $res_juridica = ($l->data_juridica == '')? '':$l->res_data_juridica;
              $res_new_york_restricted = (empty($l->new_york_restricted))? '':$l->res_new_york_restricted;
              $salida .= $fecha_estatus.'@@'.$l->ofac.'@@'.$res_ofac.'@@'.$l->oig.'@@'.$res_oig.'@@'.$l->sam.'@@'.$res_sam.'@@'.$l->data_juridica.'@@'.$res_juridica.'@@'.$l->new_york_restricted.'@@'.$res_new_york_restricted;
          }
          $msj = array(
              'codigo' => 1,
              'msg' => $salida
          );
      }
      else{
          $msj = array(
              'codigo' => 0,
              'msg' => 'error'
          );
      }
      echo json_encode($msj);
    }
    function guardarFACIS(){
      $this->form_validation->set_rules('ofac', 'Estatus OFAC', 'required|trim');
      $this->form_validation->set_rules('res_ofac', 'Resultado OFAC', 'required|trim');
      $this->form_validation->set_rules('oig', 'Estatus OIG', 'required|trim');
      $this->form_validation->set_rules('res_oig', 'Resultado OIG', 'required|trim');
      

      $this->form_validation->set_message('required','El campo {field} es obligatorio');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
          $id_candidato = $this->input->post('id_candidato');
          $id_cliente = $_POST['id_cliente'];
          $id_usuario = $this->session->userdata('id');
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $data['estatus'] = $this->candidato_model->checkPruebas($id_candidato);
          if($data['estatus']){
              $datos = array(
                  'edicion' => $date,
                  'id_usuario' => $id_usuario,
                  'ofac' => $this->input->post('ofac'),
                  'resultado_ofac' => $this->input->post('res_ofac'),
                  'oig' => $this->input->post('oig'),
                  'resultado_oig' => $this->input->post('res_oig'),
                  'sam' => $this->input->post('sam'),
                  'resultado_sam' => $this->input->post('res_sam'),
                  'data_juridica' => $this->input->post('juridica'),
                  'res_data_juridica' => $this->input->post('res_juridica'),
                  'new_york_restricted' => $this->input->post('new_york'),
                  'res_new_york_restricted' => $this->input->post('res_new_york')
              );
              $this->candidato_model->editarPruebas($datos, $id_candidato);
          }
          else{
              $datos = array(
                  'creacion' => $date,
                  'edicion' => $date,
                  'id_usuario' => $id_usuario,
                  'id_cliente' => $id_cliente,
                  'id_candidato' => $id_candidato,
                  'psicometrico' => 0,
                  'ofac' => $this->input->post('ofac'),
                  'resultado_ofac' => $this->input->post('res_ofac'),
                  'oig' => $this->input->post('oig'),
                  'resultado_oig' => $this->input->post('res_oig'),
                  'sam' => $this->input->post('sam'),
                  'resultado_sam' => $this->input->post('res_sam'),
                  'data_juridica' => $this->input->post('juridica'),
                  'res_data_juridica' => $this->input->post('res_juridica'),
                  'new_york_restricted' => $this->input->post('new_york'),
                  'res_new_york_restricted' => $this->input->post('res_new_york')
              );
              $this->candidato_model->crearPruebas($datos);
              $candidato = array(
                  'edicion' => $date,
                  'id_usuario' => $id_usuario
              );
              $this->candidato_model->editarCandidato($candidato, $id_candidato);
          }
          $msj = array(
              'codigo' => 1,
              'msg' => 'success'
          );
      }
      echo json_encode($msj);
    }
    function cambiarFechaFACIS(){
			$this->form_validation->set_rules('fecha_alta', 'Nueva fecha de solicitud o alta', 'required|trim');
			$this->form_validation->set_rules('fecha_fin', 'Nueva fecha de finalización', 'required|trim');

      $this->form_validation->set_message('required','El campo {field} es obligatorio');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
				$msj = array(
					'codigo' => 0,
					'msg' => validation_errors()
				);
      } 
      else{
				$id_candidato = $this->input->post('id_candidato');
				$alta = $this->input->post('fecha_alta');
				$fin = $this->input->post('fecha_fin');
				$id_usuario = $this->session->userdata('id');
				date_default_timezone_set('America/Mexico_City');
				$hora = date('H:i:s');
				$aux = explode('/',$alta);
				$fecha_alta = $aux[2].'-'.$aux[1].'-'.$aux[0].' '.$hora;
				$aux = explode('/',$fin);
				$fecha_fin = $aux[2].'-'.$aux[1].'-'.$aux[0].' '.$hora;
				$candidato = array(
					'edicion' => $fecha_alta,
					'id_usuario' => $id_usuario,
					'fecha_alta' => $fecha_alta
				);
				$this->candidato_model->editarCandidato($candidato, $id_candidato);
				$pruebas = array(
					'creacion' => $fecha_fin,
					'edicion' => $fecha_fin
				);
				$this->candidato_model->editarPruebas($pruebas, $id_candidato);
				$bgc = array(
					'creacion' => $fecha_fin,
					'edicion' => $fecha_fin,
					'id_usuario' => $id_usuario
				);
				$this->candidato_model->editarBGC($bgc, $id_candidato);
				$msj = array(
					'codigo' => 1,
					'msg' => 'success'
				);
      }
      echo json_encode($msj);
    }
    function finalizarProcesoFACIS(){
      //$this->form_validation->set_rules('comentario', 'Informa final', 'required|trim');
      $this->form_validation->set_rules('estatus', 'Estatus final', 'required|trim');

      $this->form_validation->set_message('required','El campo {field} es obligatorio');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $id_candidato = $this->input->post('id_candidato');
          $id_usuario = $this->session->userdata('id');
          $bgc = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              'id_candidato' => $id_candidato,
              //'comentario_final' => $this->input->post('comentario')
          );
          $this->candidato_model->guardarBGC($bgc);
          $this->candidato_model->statusBGCCandidato($this->input->post('estatus'), $id_candidato);
          $msj = array(
              'codigo' => 1,
              'msg' => 'success'
          );
      }
      echo json_encode($msj);
    }
    function crearPDFProcesoFACIS(){
      $mpdf = new \Mpdf\Mpdf();
      date_default_timezone_set('America/Mexico_City');
      $data['hoy'] = date("d-m-Y");
      $hoy = date("d-m-Y");
      $id_candidato = $_POST['idCandidatoFACIS'];
      $data['datos'] = $this->candidato_model->getDatosCandidato($id_candidato);
      $id_usuario = $this->session->userdata('id');
      $tipo_usuario = $this->session->userdata('tipo');
      if($tipo_usuario == 1){
        $usuario = $this->usuario_model->getDatosUsuarioInterno($id_usuario);
      }
      if($tipo_usuario == 2){
        $usuario = $this->usuario_model->getDatosUsuarioCliente($id_usuario);
      }
      if($tipo_usuario == 4){
        $usuario = $this->usuario_model->getDatosUsuarioSubcliente($id_usuario);
      }
      foreach($data['datos'] as $row){
          $f = $row->fecha_alta;
          $fform = $row->fecha_contestado;
          $fdocs = $row->fecha_documentos;
          $fbgc = $row->fecha_bgc;
          $nombreCandidato = $row->nombre." ".$row->paterno." ".$row->materno;
      }
      $f_alta = formatoFecha($f);
      $fform = formatoFecha($fform);
      $fdocs = formatoFecha($fdocs);
      $fbgc = formatoFecha($fbgc);
      $hoy = formatoFecha($hoy);
      $data['bgc'] = $this->candidato_model->getBGC($id_candidato);
      $data['pruebas'] = $this->candidato_model->getPruebasFACIS($id_candidato);
      $data['docs'] = $this->candidato_model->getDocumentacionCandidato($id_candidato);
      $data['analista'] = $this->candidato_model->getAnalista($id_candidato);
      $data['coordinadora'] = $this->candidato_model->getCoordinadora($id_candidato);
      $html = $this->load->view('pdfs/ofac_oig_pdf',$data,TRUE);
      $mpdf->setAutoTopMargin = 'stretch';
      $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="'.base_url().'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Request Date: '.$f_alta.'<br>Release Date: '.$fbgc.'</div>');
      $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="'.base_url().'img/logo_pie.png"></div>');
      //Cifrar pdf
      $nombreArchivo = substr( md5(microtime()), 1, 12);
      /*$claveAleatoria = substr( md5(microtime()), 1, 8);
      $clave = ($usuario->clave != null)? $usuario->clave:$claveAleatoria;
      $mpdf->SetProtection(array(), $clave, 'r0d1@');*/
      $mpdf->autoPageBreak = false;
			$mpdf->WriteHTML($html);
      $mpdf->Output(''.$nombreArchivo.'.pdf','D'); // opens in browser
    }
  /*----------------------------------------*/
	/*  Creacion de Porcentaje de Avances
	/*----------------------------------------*/
  function generarAvancesUST($id_candidato){
    $c = $this->cliente_ust_model->getSeccionesRequeridas($id_candidato);
      $porcentaje = 0;
    if($c->estudios_comentarios != '' && $c->estudios_comentarios != null){//Comentarios historial academico
      $porcentaje += 10;
    }
    if($c->docs_comentarios != '' && $c->docs_comentarios != null){//Comentarios verificacion documentos
      $porcentaje += 10;
    }
    if($c->idRefPer != null){//minimo un id de candidato_ref_personal
      $porcentaje += 20;
    }
    if($c->idVerLaboral != null){//minimo un id de verificacion_ref_laboral
      $porcentaje += 20;
    }
    if($c->idVerEstudios != null){//minimo un id de verificacion de estudios
      $porcentaje += 10;
    }
    if($c->idEstatusLaboral != null){//minimo un id de verificacion laboral
      $porcentaje += 10;
    }
    if($c->idVerPenal != null){//minimo un id de verificacion penal
      $porcentaje += 10;
    }
    //Se checa el porcentaje en caso de que tenga los documentos obligatorios, los demas puede que no se tengan por alguna razon
    $data['docs'] = $this->cronjobs_model->getDocumentosObligatoriosUST($id_candidato);
    if($data['docs']){
      $aviso = 0;
      $ofac = 0;
      foreach ($data['docs'] as $doc) {
        if ($doc->id_tipo_documento == 8) { // Si tiene cargado el aviso de privacidad
          $aviso = 1;
        }
        if ($doc->id_tipo_documento == 11) { //Si tiene cargado el OFAC
          $ofac = 1;
        }
      }
      $p = ($aviso == 1) ? 5 : 0;
      $porcentaje += $p;
      $p2 = ($ofac == 1) ? 5 : 0;
      $porcentaje += $p2;
    }
    $this->cronjobs_model->cleanAvance($id_candidato);
    $this->cronjobs_model->actualizarAvance($porcentaje, $id_candidato);
  }
  
}