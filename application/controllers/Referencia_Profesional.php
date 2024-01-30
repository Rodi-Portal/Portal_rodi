<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referencia_Profesional extends Custom_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

  function getById(){
    $res = $this->referencia_profesional_model->getById($this->input->post('id'));
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getComentarios(){
    $salida = "";
    $data['ref'] = $this->referencia_profesional_model->getComentarios($this->input->post('id'));
    if($data['ref']){
      foreach($data['ref'] as $ref){
        if($ref->comentario != null){
          $salida .= $ref->comentario.", ";
        }
        else{
          if($ref->opinion_persona != null && $ref->opinion_trabajador != null){
            $salida .= $ref->opinion_persona.', '.$ref->opinion_trabajador.', ';
          }
          else{
            $salida .= 'sin opinión registrada de las referencias profesionales';
          }
        }
      }
      $res = trim($salida, ", ");
      echo $res;
    }
    else{
      echo $salida;
    }
  }
  function set(){
    $id_candidato = $this->input->post('id_candidato');
    $candidato = $this->candidato_model->getDetalles($id_candidato);
    $index = ($this->input->post('num') - 1);
    $fail = 0;
    if($this->input->post('source') !== null && $this->input->post('source') == 'candidato'){
      $data['campos'] = $this->formulario_model->getBySeccionAndAutor($this->input->post('id_seccion'), 'orden_front', 'candidato');
    }else{
      $data['campos'] = $this->formulario_model->getBySeccion($this->input->post('id_seccion'), 'orden_front');
    }
    if($data['campos']){
      foreach($data['campos'] as $campo){
        $referencia = $campo->atr_id.'['.$index.']';
        //var_dump($referencia.'-'.$this->input->post($campo->name)[$number]);
        $label = ($candidato->ingles == 0)? $campo->backend_label : $campo->backend_label_ingles;
        $this->form_validation->set_rules($referencia,$campo->backend_label,$campo->backend_rule);
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
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_usuario = $this->session->userdata('id');
  
        $hayId = $this->referencia_profesional_model->countByIdCandidato($id_candidato);
        if($hayId == 0){
          $creacion = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'id_candidato' => $id_candidato,
          );
          $id_ref = $this->referencia_profesional_model->add($creacion);
          foreach($data['campos'] as $c){
            $edicion = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              $c->referencia => $this->input->post($c->name)[$index]
            );
            $this->referencia_profesional_model->edit($edicion, $id_ref);
          }
          $mensaje = ($candidato->ingles == 0)? 'Referencia profesional #'.$this->input->post('num').' actualizada correctamente' : 'Professional reference #'.$this->input->post('num').' updated successfully';
          $msj = array(
            'codigo' => 1,
            'msg' => $mensaje,
            'nuevo_id' => $id_ref
          );
        }
        else{
          if($this->input->post('id_ref') != 0){
            $id_ref = $this->input->post('id_ref');
            foreach($data['campos'] as $c){
              $edicion = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                $c->referencia => $this->input->post($c->name)[$index]
              );
              $this->referencia_profesional_model->edit($edicion, $this->input->post('id_ref'));
            }
            $mensaje = ($candidato->ingles == 0)? 'Referencia profesional #'.$this->input->post('num').' actualizada correctamente' : 'Professional reference #'.$this->input->post('num').' updated successfully';
            $msj = array(
              'codigo' => 1,
              'msg' => $mensaje,
              'nuevo_id' => $id_ref
            );
          }
          else{
            $creacion = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              'id_candidato' => $id_candidato,
            );
            $id_ref = $this->referencia_profesional_model->add($creacion);
            foreach($data['campos'] as $c){
              $edicion = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                $c->referencia => $this->input->post($c->name)[$index]
              );
              $this->referencia_profesional_model->edit($edicion, $id_ref);
            }
            $mensaje = ($candidato->ingles == 0)? 'Referencia profesional #'.$this->input->post('num').' actualizada correctamente' : 'Professional reference #'.$this->input->post('num').' updated successfully';
            $msj = array(
              'codigo' => 1,
              'msg' => $mensaje,
              'nuevo_id' => $id_ref
            );
            //* Mensaje automatico de avance
            $mensajeAvance = ($candidato->ingles == 0)? '[System] Se han actualizado las referencias profesionales del candidato' : '[System] The candidate\'s professional references have been updated';
            $this->registrar_mensaje_avance($id_candidato, $mensajeAvance);
          }
        }
        //* Si el usuario actual es un candidato (tipo 3), se registra su avance en el llenado del formulario de su acceso
        if($this->session->userdata('tipo') == 3 && $msj['codigo'] == 1){
          $this->registrar_avance_candidato($id_usuario, 'profesionales');
        }
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
    $candidato = $this->candidato_model->getDetalles($this->input->post('id_candidato'));
    $id = $this->input->post('id');
    $this->referencia_profesional_model->delete($id);
    $mensaje = ($candidato->ingles == 0)? 'Referencia profesional eliminada correctamente' : 'Professional reference deleted successfully';
    $msj = array(
      'codigo' => 1,
      'msg' => $mensaje
    );
    echo json_encode($msj);
  }
}