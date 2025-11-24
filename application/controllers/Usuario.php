<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
    
  function getData(){
    $id_usuario = $this->session->userdata('id');
    $tipo_usuario = $this->session->userdata('tipo');
    if($tipo_usuario == 1){
      $res = $this->usuario_model->getDatosUsuarioInterno($id_usuario);
    }
    if($tipo_usuario == 2){
      $res = $this->usuario_model->getDatosUsuarioCliente($id_usuario);
    }
    if($tipo_usuario == 4){
      $res = $this->usuario_model->getDatosUsuarioSubcliente($id_usuario);
    }
    echo json_encode($res);
  }

  function checkPasswordActual(){
    date_default_timezone_set('America/Mexico_City');
    $date = date('Y-m-d H:i:s');
    $id_usuario = $this->session->userdata('id');
    $tipo_usuario = $this->session->userdata('tipo');
    $base = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
    $pass = md5($base . $this->input->post('password'));
    $key = ($this->input->post('key') != '')? $this->input->post('key') : NULL;
    if($tipo_usuario == 1){
      $usuario = $this->usuario_model->checkPasswordUsuarioInterno($id_usuario, $pass);
    }
    if($tipo_usuario == 2){
      $usuario = $this->usuario_model->checkPasswordUsuarioCliente($id_usuario, $pass);
    }
    if($tipo_usuario == 4){
      $usuario = $this->usuario_model->checkPasswordUsuarioSubcliente($id_usuario, $pass);
    }
    
    if($usuario != null){
      $nuevo_pass = ($this->input->post('nuevo_password') != '')? md5($base . $this->input->post('nuevo_password')) : '';
      if($nuevo_pass != ''){
        $datos = array(
          'edicion' => $date,
          'nombre' => $this->input->post('nombre'),
          'paterno' => $this->input->post('paterno'),
          'correo' => $this->input->post('correo'),
          'password' => $nuevo_pass,
          'clave' => $key
        );
      }
      else{
        $datos = array(
          'edicion' => $date,
          'nombre' => $this->input->post('nombre'),
          'paterno' => $this->input->post('paterno'),
          'correo' => $this->input->post('correo'),
          'clave' => $key
        );
      }
      if($tipo_usuario == 1){
        $this->usuario_model->editarUsuarioInterno($datos, $id_usuario);
      }
      if($tipo_usuario == 2){
        $this->usuario_model->editarUsuarioCliente($datos, $id_usuario);
      }
      if($tipo_usuario == 4){
        $this->usuario_model->editarUsuarioSubcliente($datos, $id_usuario);
      }
      $msj = array(
        'codigo' => 1,
        'msg' => 'Your data has been updated successfully. Your session will close to apply the changes'
      );
    }
    else{
      $msj = array(
        'codigo' => 0,
        'msg' => 'Password incorrect'
      );
    }
    echo json_encode($msj);
  }

  function getAnalistasActivos(){
    $data['usuarios'] = $this->usuario_model->getAnalistasActivos();
    if($data['usuarios']){
      $salida = '<option>Selecciona</option>';
      foreach($data['usuarios'] as $row){
        $salida .= '<option value="'.$row->id.'">'.$row->usuario.'</option>';
      }
      echo $salida;
    }
    else{
      echo $res = 0;
    }
  }

  public function cambiar_idioma()
    {
        // Opcional: solo aceptar AJAX
        if ( ! $this->input->is_ajax_request()) {
            show_404();
        }

        // Idioma recibido
        $lang = $this->input->post('lang', true);   // 'es' o 'en'
        $permitidos = ['es', 'en'];

        if ( ! in_array($lang, $permitidos, true)) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'ok'      => false,
                    'message' => 'Idioma inválido'
                ]));
        }

        // Usuario logueado
        $idUsuario = $this->session->userdata('id');
        if ( ! $idUsuario) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'ok'      => false,
                    'message' => 'Sesión no válida'
                ]));
        }

        // Actualizar en BD
        $actualizado = $this->usuario_model->update($idUsuario, [
            'lang' => $lang
        ]);

        if ( ! $actualizado) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'ok'      => false,
                    'message' => 'No se pudo guardar en BD'
                ]));
        }

        // Actualizar sesión
        $this->session->set_userdata('lang', $lang);

        // Respuesta OK
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'ok'      => true,
                'lang'    => $lang,
                'message' => 'Idioma actualizado'
            ]));
    }
}