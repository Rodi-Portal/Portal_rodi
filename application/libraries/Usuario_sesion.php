<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_sesion{

  function checkStatusBD(){
    $CI =& get_instance();
    if($CI->session->userdata('id') !== NULL){
      $CI->load->model('usuario_model');
      $result = $CI->usuario_model->checkUsuarioActivo($CI->session->userdata('id') !== null);
      if($result->status == 0 || $result->eliminado == 1){
        $CI->session->sess_destroy();
        redirect('Login/index');
      }
    }
  }

}