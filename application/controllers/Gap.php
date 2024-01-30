<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gap extends Custom_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

  function getById(){
    $res = $this->gap_model->getById($this->input->post('id'));
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function store(){
    $id_candidato = $this->input->post('id_candidato');
    $this->form_validation->set_rules('fi', 'Fecha inicio', 'required|trim');
    $this->form_validation->set_rules('ff', 'Fecha fin', 'required|trim');
    $this->form_validation->set_rules('razon', 'Razón', 'required|trim');
    $this->form_validation->set_message('required','El campo {field} es obligatorio');

    if ($this->form_validation->run() == FALSE) {
      $msj = array(
        'codigo' => 0,
        'msg' => validation_errors()
      );
    }
    else{
      $date = date('Y-m-d H:i:s');
      $candidato = $this->candidato_model->getDetalles($id_candidato);
      if($this->session->userdata('tipo') == 1 || $this->session->userdata('tipo') == 3){
        $id_usuario = $this->session->userdata('id');
      }
      else{
        $id_usuario = 0;
      }
      $gap = array(
        'creacion' => $date,
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'id_candidato' => $id_candidato,
        'fecha_inicio' => $this->input->post('fi'),
        'fecha_fin' => $this->input->post('ff'),
        'razon' => $this->input->post('razon'),
      );
      $this->gap_model->store($gap);
      $msj = array(
        'codigo' => 1,
        'msg' => 'Gap saved successfully'
      );
      //* Mensaje automatico de avance
      $mensajeAvance = ($candidato->ingles == 0)? '[System] Se ha registrado un periodo inactivo o GAP del candidato' : '[System] A candidate\'s gap has been added';
      $this->registrar_mensaje_avance($id_candidato, $mensajeAvance);

      //* Si el usuario actual es un candidato (tipo 3), se registra su avance en el llenado del formulario de su acceso
      if($this->session->userdata('tipo') == 3 && $msj['codigo'] == 1){
        $this->registrar_avance_candidato($id_usuario, 'gaps');
      }
    }
    echo json_encode($msj);
  }
  function delete(){
    $id = $this->input->post('id_gap');
    $this->gap_model->delete($id);
    $msj = array(
      'codigo' => 1,
      'msg' => 'success'
    );
    echo json_encode($msj);
  }
}