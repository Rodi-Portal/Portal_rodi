<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subclientes_Panel extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
    
  function registrar(){
    ///if($this->input->post('previo') != 0){
      $this->form_validation->set_rules('nombre', 'Nombre(s)', 'required|trim');
      $this->form_validation->set_rules('paterno', 'Apellido paterno', 'required|trim');
      $this->form_validation->set_rules('materno', 'Apellido materno', 'trim');
      $this->form_validation->set_rules('puesto', 'Puesto', 'required');
      $this->form_validation->set_rules('celular', 'Teléfono', 'required|trim|max_length[16]');
      $this->form_validation->set_rules('previo', 'Tipo de estudio', 'required');
      $this->form_validation->set_rules('examen', 'Examen antidoping', 'required');
      $this->form_validation->set_rules('medico', 'Examen Médico', 'required');
      $this->form_validation->set_rules('psicometrico', 'Examen Psicométrico', 'required');

      $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
      $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');
      
      $msj = array();
      if ($this->form_validation->run() == FALSE) {
        $msj = array(
          'codigo' => 0,
          'msg' => validation_errors()
        );
      }
      else{
        if($this->session->userdata('idcliente') != null){
          $id_cliente = $this->session->userdata('idcliente');
        }
        else{
          $id_cliente = $this->input->post('id_cliente');
        }
        $nombre = strtoupper($this->input->post('nombre'));
        $paterno = strtoupper($this->input->post('paterno'));
        $materno = strtoupper($this->input->post('materno'));
        $celular = $this->input->post('celular');
        $id_subcliente = $this->session->userdata('idsubcliente');
        $id_puesto = $this->input->post('puesto');
        $pais = $this->input->post('pais');
        $previo = $this->input->post('previo');
        $examen = $this->input->post('examen');
        $medico = $this->input->post('medico');
        $psicometrico = $this->input->post('psicometrico');
        $existeCandidato = $this->subcliente_panel_model->existeCandidato($nombre, $paterno, $materno, $id_cliente, $id_subcliente);
        if($existeCandidato > 0){
          $msj = array(
            'codigo' => 2,
            'msg' => 'El candidato ya existe'
          );
        }
        else{
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $usuario = $this->input->post('usuario');
          switch ($usuario) {
            case 1:
              $tipo_usuario = "id_usuario";
              break;
            case 2:
              $tipo_usuario = "id_usuario_cliente";
              break;
            case 3:
              $tipo_usuario = "id_usuario_subcliente";
              break;
          }
          $id_usuario = $this->session->userdata('id');
          if($previo != 0){
            if($pais == 'México'){
              if($previo == 1){
                $id_proyecto_previo = 81;
              }
              if($previo == 2){
                $id_proyecto_previo = 83;
              }
            }
            else{
              if($previo == 1){
                $id_proyecto_previo = 82;
              }
              if($previo == 2){
                $id_proyecto_previo = 83;
              }
            }

            $seccion = $this->candidato_model->getProyectoPrevio($id_proyecto_previo);

            if ($usuario == 2 || $usuario == 3) {
              $configuracion = $this->funciones_model->getConfiguraciones();
              $data = array(
                'creacion' => $date,
                'edicion' => $date,
                $tipo_usuario => $id_usuario,
                'id_usuario' => $configuracion->usuario_lider_espanol,
                'id_cliente' => $id_cliente,
                'id_subcliente' => $id_subcliente,
                'id_tipo_proceso' => 1,
                'id_puesto' => $id_puesto,
                'fecha_alta' => $date,
                'nombre' => strtoupper($nombre),
                'paterno' => strtoupper($paterno),
                'materno' => strtoupper($materno),
                'celular' => $celular,
                'subproyecto' => $seccion->proyecto,
                'pais' => $pais
              );
            } 
            else {
              $data = array(
                'creacion' => $date,
                'edicion' => $date,
                $tipo_usuario => $id_usuario,
                'id_cliente' => $id_cliente,
                'id_subcliente' => $id_subcliente,
                'id_tipo_proceso' => 1,
                'id_puesto' => $id_puesto,
                'fecha_alta' => $date,
                'nombre' => strtoupper($nombre),
                'paterno' => strtoupper($paterno),
                'materno' => strtoupper($materno),
                'celular' => $celular,
                'subproyecto' => $seccion->proyecto,
                'pais' => $pais
              );
            }
            $id_candidato = $this->candidato_model->registrarRetornaCandidato($data);
            //Subida y Registro de CV
            if ($this->input->post('hay_cvs') == 1) {
              $countfiles = count($_FILES['cvs']['name']);

              for ($i = 0; $i < $countfiles; $i++) {
                if (!empty($_FILES['cvs']['name'][$i])) {
                  // Define new $_FILES array - $_FILES['file']
                  $_FILES['file']['name'] = $_FILES['cvs']['name'][$i];
                  $_FILES['file']['type'] = $_FILES['cvs']['type'][$i];
                  $_FILES['file']['tmp_name'] = $_FILES['cvs']['tmp_name'][$i];
                  $_FILES['file']['error'] = $_FILES['cvs']['error'][$i];
                  $_FILES['file']['size'] = $_FILES['cvs']['size'][$i];
                  $temp = str_replace(' ', '', $_FILES['cvs']['name'][$i]);
                  $extension = pathinfo($_FILES['cvs']['name'][$i], PATHINFO_EXTENSION);

                  $nombre_cv = $id_candidato . "_CV_" . $i . '.' . $extension;
                  // Set preference
                  $config['upload_path'] = './_docs/';
                  $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                  //$config['max_size'] = '15000'; // max_size in kb
                  $config['file_name'] = $nombre_cv;
                  //Load upload library
                  $this->load->library('upload', $config);
                  $this->upload->initialize($config);
                  // File upload
                  if ($this->upload->do_upload('file')) {
                    $data = $this->upload->data();
                    //$salida = 1; 
                  }
                  $documento = array(
                    'creacion' => $date,
                    'edicion' => $date,
                    'id_candidato' => $id_candidato,
                    'id_tipo_documento' => 16,
                    'archivo' => $nombre_cv
                  );
                  $this->candidato_model->registrarDocumento($documento);
                }
              }
            }

            $candidato_secciones = array(
              'creacion' => $date,
              $tipo_usuario => $id_usuario,
              'id_candidato' => $id_candidato,
              'proyecto' => $seccion->proyecto,
              'secciones' => $seccion->secciones,
              'lleva_empleos' => $seccion->lleva_empleos,
              'lleva_estudios' => $seccion->lleva_estudios,
              'lleva_gaps' => 0,
              'lleva_sociales' => $seccion->lleva_sociales,
              'lleva_investigacion' => $seccion->lleva_investigacion,
              'lleva_no_mencionados' => $seccion->lleva_no_mencionados,
              'lleva_familiares' => $seccion->lleva_familiares,
              'lleva_egresos' => $seccion->lleva_egresos,
              'lleva_vivienda' => $seccion->lleva_vivienda,
              'id_seccion_datos_generales' => $seccion->id_seccion_datos_generales,
              'id_seccion_verificacion_docs' => $seccion->id_seccion_verificacion_docs,
              'id_finanzas' => $seccion->id_finanzas,
              'tiempo_empleos' => $seccion->tiempo_empleos,
              'cantidad_ref_personales' => $seccion->cantidad_ref_personales,
              'cantidad_ref_vecinales' => $seccion->cantidad_ref_vecinales,
              'visita' => $seccion->visita
            );
            $this->candidato_model->guardarSeccionCandidato($candidato_secciones);
  
            $tipo_antidoping = ($examen == 0)? 0:1;
            $antidoping = ($examen == 0)? NULL:$examen;
            $pruebas = array(
              'creacion' => $date,
              'edicion' => $date,
              $tipo_usuario => $id_usuario,
              'id_candidato' => $id_candidato,
              'id_cliente' => $id_cliente,
              'socioeconomico' => 1,
              'tipo_antidoping' => $tipo_antidoping,
              'antidoping' => $antidoping,
              'tipo_psicometrico' => $psicometrico,
              'psicometrico' => $psicometrico,
              'medico' => $medico,
              'buro_credito' => 0,
              'sociolaboral' => 0
            );
            $this->candidato_model->crearPruebas($pruebas);
              
            if($seccion->visita != NULL){
              $visita = array(
                'creacion' => $date,
                'edicion' => $date,
                $tipo_usuario => $id_usuario,
                'id_cliente' => $id_cliente,
                'id_subcliente' => $id_subcliente,
                'id_candidato' => $id_candidato,
                'id_tipo_formulario' => 4
              );
              $this->candidato_model->crearVisita($visita);
            }
  
            if ($usuario == 2 || $usuario == 3) {
              $from = $this->config->item('smtp_user');
              $info_cliente = $this->cliente_general_model->getDatosCliente($id_cliente);
              $to = "bjimenez@rodicontrol.com";
              $subject = " Nuevo candidato en la plataforma del cliente " . $info_cliente->nombre;
              $message = "Se ha agregado a " . strtoupper($this->input->post('nombre')) . " " . strtoupper($this->input->post('paterno')) . " " . strtoupper($this->input->post('materno')) . " del cliente " . $info_cliente->nombre . " en la plataforma";
              $this->load->library('phpmailer_lib');
              $mail = $this->phpmailer_lib->load();
              $mail->isSMTP();
              $mail->Host     = 'mail.rodicontrol.com';
              $mail->SMTPAuth = true;
              $mail->Username = 'rodicontrol@rodicontrol.com';
              $mail->Password = 'r49o*&rUm%91';
              $mail->SMTPSecure = 'ssl';
              $mail->Port     = 465;
              $mail->setFrom('rodicontrol@rodicontrol.com', 'Mensaje automático de RODICONTROL');
              $mail->addAddress($to);
              $mail->Subject = $subject;
              $mail->isHTML(true);
              $mailContent = $message;
              $mail->Body = $mailContent;
  
              if (!$mail->send()) {
                $enviado = 1;
              } else {
                $enviado = 0;
              }
            }
          }
          else{
            if ($usuario == 2 || $usuario == 3) {
              $configuracion = $this->funciones_model->getConfiguraciones();
              $data = array(
                'creacion' => $date,
                'edicion' => $date,
                $tipo_usuario => $id_usuario,
                'id_usuario' => $configuracion->usuario_lider_espanol,
                'id_cliente' => $id_cliente,
                'id_subcliente' => $id_subcliente,
                'id_tipo_proceso' => 1,
                'id_puesto' => $id_puesto,
                'fecha_alta' => $date,
                'nombre' => strtoupper($nombre),
                'paterno' => strtoupper($paterno),
                'materno' => strtoupper($materno),
                'celular' => $celular,
                'pais' => $pais
              );
            } 
            else {
              $data = array(
                'creacion' => $date,
                'edicion' => $date,
                $tipo_usuario => $id_usuario,
                'id_cliente' => $id_cliente,
                'id_subcliente' => $id_subcliente,
                'id_tipo_proceso' => 1,
                'id_puesto' => $id_puesto,
                'fecha_alta' => $date,
                'nombre' => strtoupper($nombre),
                'paterno' => strtoupper($paterno),
                'materno' => strtoupper($materno),
                'celular' => $celular,
                'pais' => $pais
              );
            }
            $id_candidato = $this->candidato_model->registrarRetornaCandidato($data);
  
            $tipo_antidoping = ($examen == 0)? 0:1;
            $antidoping = ($examen == 0)? NULL:$examen;
            $pruebas = array(
              'creacion' => $date,
              'edicion' => $date,
              $tipo_usuario => $id_usuario,
              'id_candidato' => $id_candidato,
              'id_cliente' => $id_cliente,
              'socioeconomico' => 0,
              'tipo_antidoping' => $tipo_antidoping,
              'antidoping' => $antidoping,
              'tipo_psicometrico' => $psicometrico,
              'psicometrico' => $psicometrico,
              'medico' => $medico,
              'buro_credito' => 0,
              'sociolaboral' => 0
            );
            $this->candidato_model->crearPruebas($pruebas);
          }
          $msj = array(
            'codigo' => 1,
            'msg' => 'Success'
          );
        }
      } 
    echo json_encode($msj);
  }

}
    