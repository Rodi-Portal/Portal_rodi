<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Formulario extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
  function getBySeccion(){
    $tabla_referencia = $this->formulario_model->getTableReference($this->input->post('id_seccion'));
    $res = $this->formulario_model->getBySeccion($this->input->post('id_seccion'), $this->input->post('tipo_orden'));
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getBySeccionAndAutor(){
    $res = $this->formulario_model->getBySeccionAndAutor($this->input->post('id_seccion'), $this->input->post('tipo_orden'), $this->input->post('autor'));
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getSeccionByAutor(){
    $autor = ($this->input->post('autor') !== null)? $this->input->post('autor') : ['analista','candidato'];
    $tabla_referencia = $this->formulario_model->getTableReference($this->input->post('id_seccion'));
    $res = $this->formulario_model->getSeccionByAutor($this->input->post('id_seccion'), $this->input->post('tipo_orden'), $autor);
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
}