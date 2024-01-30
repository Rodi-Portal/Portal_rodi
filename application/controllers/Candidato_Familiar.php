<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_Familiar extends Custom_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
  
  function getById(){
    $res = $this->candidato_familiar_model->getById($this->input->post('id'));
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function set(){
    $id_candidato = $this->input->post('id_candidato');
    $candidato_detalle = $this->candidato_model->getDetalles($id_candidato);

    $fail = 0;
    if($this->input->post('source') !== null && $this->input->post('source') == 'candidato'){
      $data['campos'] = $this->formulario_model->getBySeccionAndAutor($this->input->post('id_seccion'), 'orden_front', 'candidato');
    }else{
      $data['campos'] = $this->formulario_model->getBySeccion($this->input->post('id_seccion'), 'orden_front');
    }
    if($data['campos']){
      foreach($data['campos'] as $campo){
        //$referencia = $campo->atr_id.'['.$index.']';
        $label = ($candidato_detalle->ingles == 0)? $campo->backend_label : $campo->backend_label_ingles;
        $this->form_validation->set_rules($campo->atr_id,$label,$campo->backend_rule);
        if($candidato_detalle->ingles == 0){
          $this->form_validation->set_message('required','El campo {field} es obligatorio');
          $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');
          $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
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
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_familiar = $this->input->post('id_familiar');
        $id_usuario = $this->session->userdata('id');
        //$number = $this->input->post('num');
  
        $hayId = $this->candidato_familiar_model->countByIdCandidato($id_candidato);
        if($hayId == 0){
          $creacion = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_candidato' => $id_candidato,
          );
          $id_familiar = $this->candidato_familiar_model->add($creacion);
          foreach($data['campos'] as $c){
            $edicion = array(
              'edicion' => $date,
              $c->referencia => $this->input->post($c->atr_id)
            );
            $this->candidato_familiar_model->edit($edicion, $id_familiar);
          }
        }
        else{
          if($id_familiar != 0){
            foreach($data['campos'] as $c){
              $edicion = array(
                'edicion' => $date,
                $c->referencia => $this->input->post($c->atr_id)
              );
              $this->candidato_familiar_model->edit($edicion, $id_familiar);
            }
          }
          else{
            $creacion = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_candidato' => $id_candidato,
            );
            $id_familiar = $this->candidato_familiar_model->add($creacion);
            foreach($data['campos'] as $c){
              $edicion = array(
                'edicion' => $date,
                $c->referencia => $this->input->post($c->atr_id)
              );
              $this->candidato_familiar_model->edit($edicion, $id_familiar);
            }
          }
        }
        $mensaje = ($candidato_detalle->ingles == 0)? 'Integrante familiar guardado correctamente' : 'Family member updated successfully';
        $msj = array(
          'codigo' => 1,
          'msg' => $mensaje
        );
        //* Mensaje automatico de avance
        $mensajeAvance = ($candidato_detalle->ingles == 0)? '[System] Actualización del grupo familiar del candidato' : '[System] The family group of the candidate has been updated';
        $this->registrar_mensaje_avance($id_candidato, $mensajeAvance);
      }
      //* Si el usuario actual es un candidato (tipo 3), se registra su avance en el llenado del formulario de su acceso
      if($this->session->userdata('tipo') == 3 && $msj['codigo'] == 1){
        $this->registrar_avance_candidato($id_usuario, 'familiares');
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
  function delete(){
    $id = $this->input->post('id_familiar');
    $this->candidato_familiar_model->delete($id);
    $msj = array(
      'codigo' => 1,
      'msg' => 'success'
    );
    echo json_encode($msj);
  }
  function getIntegrantesDomicilio(){
    $salida = '';
    $data['personas'] = $this->candidato_familiar_model->getIntegrantesDomicilio($this->input->post('id'));
    if($data['personas']){
      $salida .= 'con su ';
      foreach($data['personas'] as $row){
        $salida .= $row->parentesco.', ';
      }
      echo $salida;
    }
    else{
      $salida = 'solo, ';
      echo $salida;
    }
  }
}