<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends CI_Controller{

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}


  function external(){
    $info['estados'] = $this->funciones_model->getEstados();
    $info['civiles'] = $this->funciones_model->getEstadosCiviles();
    $info['puestos'] = $this->funciones_model->getPuestos();
    $info['grados'] = $this->funciones_model->getGradosEstudio();
    $info['drogas'] = $this->funciones_model->getPaquetesAntidoping();
    $info['zonas'] = $this->funciones_model->getNivelesZona();
    $info['viviendas'] = $this->funciones_model->getTiposVivienda();
    $info['condiciones'] = $this->funciones_model->getTiposCondiciones();
    $info['studies'] = $this->funciones_model->getTiposEstudios();
    $info['tipos_docs'] = $this->funciones_model->getTiposDocumentos();
    $info['paises'] = $this->funciones_model->getPaises();
    $info['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
    $info['sanguineos'] = $this->funciones_model->getGruposSanguineos();
    $info['parentescos'] = $this->funciones_model->getParentescos();
    $info['civiles'] = $this->funciones_model->getEstadosCiviles();
    $info['escolaridades'] = $this->funciones_model->getEscolaridades();
    $info['grados_estudios'] = $this->funciones_model->getGradosEstudio();
    $this->load->view('candidato/external_form', $info);
  }

}