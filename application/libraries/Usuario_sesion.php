<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_sesion{

  function checkStatusBD(){
    $CI =& get_instance();

    $idUsuario = (int) $CI->session->userdata('id');

    if($idUsuario > 0){
      $CI->load->model('usuario_model');

      $result = $CI->usuario_model->checkUsuarioActivo($idUsuario);

      if(
        !$result ||
        (int) $result->status === 0 ||
        (int) $result->eliminado === 1
      ){
        $CI->session->sess_destroy();
        redirect('Login/index');
        exit;
      }
    }
  }

}
