<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends Custom_Controller{

	function __construct(){
		parent::__construct();
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
  function update(){
    $id_candidato = $this->input->post('id_candidato');
    $candidato = $this->candidato_model->getDetalles($id_candidato);
    $fail = 0;
    if($this->input->post('source') !== null && $this->input->post('source') == 'candidato'){
      $data['campos'] = $this->formulario_model->getBySeccionAndAutor($this->input->post('id_seccion'), 'orden_front', 'candidato');
    }else{
      $data['campos'] = $this->formulario_model->getBySeccion($this->input->post('id_seccion'), 'orden_front');
    }
    if($data['campos']){
      foreach($data['campos'] as $campo){
        $label = ($candidato->ingles == 0)? $campo->backend_label : $campo->backend_label_ingles;
        $this->form_validation->set_rules($campo->name,$label,$campo->backend_rule);
        if($candidato->ingles == 0){
          $this->form_validation->set_message('required','El campo {field} es obligatorio');
          $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');
          $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
          $this->form_validation->set_message('greater_than_equal_to', 'El campo {field} debe ser mínimo de {param}');
          $this->form_validation->set_message('less_than_equal_to', 'El campo {field} debe ser máximo {param}');
        }
        if ($this->form_validation->run() == FALSE) {
          $fail++;
          break;
        } 
      }
      if($fail > 0){
        $msj = array(
          'codigo' => 0,
          'msg' => validation_errors()
        );
      }
      else{
        $date = date('Y-m-d H:i:s');
        $id_usuario = $this->session->userdata('id');
  
        foreach($data['campos'] as $c){
          if($c->referencia == 'fecha_nacimiento'){
            $edicion = array(
              'edad' => calculaEdad($this->input->post($c->name))
            );
            $this->candidato_model->edit($edicion, $id_candidato);
          }
          $edicion = array(
            'edicion' => $date,
            //'id_usuario' => $id_usuario,
            $c->referencia => $this->input->post($c->name)
          );
          $this->candidato_model->edit($edicion, $id_candidato);
        }
        $mensaje = ($candidato->ingles == 0)? 'Datos Generales actualizados correctamente' : 'General data updated successfully';
        $msj = array(
          'codigo' => 1,
          'msg' => $mensaje
        );
        //* Mensaje automatico de avance
        $mensajeAvance = ($candidato->ingles == 0)? '[System] Los datos generales del candidato han sido registrados' : '[System] The general data of the candidate has been recorded';
        $this->registrar_mensaje_avance($id_candidato, $mensajeAvance);
      }
      //* Si el usuario actual es un candidato (tipo 3), se registra su avance en el llenado del formulario de su acceso
      if($this->session->userdata('tipo') == 3 && $msj['codigo'] == 1){
        $this->registrar_avance_candidato($id_usuario, 'general');
      }
    }
    else{
      $msj = array(
        'codigo' => 0,
        'msg' => 'Error en el formulario'
      );
    }
    echo json_encode($msj);
  }
}