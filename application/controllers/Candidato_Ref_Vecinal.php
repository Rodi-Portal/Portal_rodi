<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_Ref_Vecinal extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

  function getById(){
    $res = $this->candidato_ref_vecinal_model->getById($this->input->post('id'));
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getComentarios(){
    $id_candidato = $this->input->post('id_candidato');
    $salida = "";
    $data['ref'] = $this->candidato_ref_vecinal_model->getComentarios($id_candidato);
    if($data['ref']){
      foreach($data['ref'] as $ref){
        $salida .= $ref->concepto_candidato.", ";
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
    $index = ($this->input->post('num') - 1);
    $fail = 0;
    $data['campos'] = $this->formulario_model->getBySeccion($this->input->post('id_seccion'), 'orden_front');
    if($data['campos']){
      foreach($data['campos'] as $campo){
        $referencia = $campo->atr_id.'['.$index.']';
        //var_dump($referencia.'-'.$this->input->post($campo->name)[$number]);
        $this->form_validation->set_rules($referencia,$campo->backend_label,$campo->backend_rule);

        $this->form_validation->set_message('required','El campo {field} es obligatorio');
        $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
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
  
        $hayId = $this->candidato_ref_vecinal_model->countByIdCandidato($id_candidato);
        if($hayId == 0){
          $creacion = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'id_candidato' => $id_candidato,
          );
          $id_ref = $this->candidato_ref_vecinal_model->add($creacion);
          foreach($data['campos'] as $c){
            $edicion = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              $c->referencia => $this->input->post($c->name)[$index]
            );
            $this->candidato_ref_vecinal_model->edit($edicion, $id_ref);
          }
          $msj = array(
            'codigo' => 1,
            'msg' => 'Referencia vecinal #'.$this->input->post('num').' actualizada correctamente',
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
              $this->candidato_ref_vecinal_model->edit($edicion, $this->input->post('id_ref'));
            }
            $msj = array(
              'codigo' => 1,
              'msg' => 'Referencia vecinal #'.$this->input->post('num').' actualizada correctamente',
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
            $id_ref = $this->candidato_ref_vecinal_model->add($creacion);
            foreach($data['campos'] as $c){
              $edicion = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                $c->referencia => $this->input->post($c->name)[$index]
              );
              $this->candidato_ref_vecinal_model->edit($edicion, $id_ref);
            }
            $msj = array(
              'codigo' => 1,
              'msg' => 'Referencia vecinal #'.$this->input->post('num').' actualizada correctamente',
              'nuevo_id' => $id_ref
            );
          }
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
    $id = $this->input->post('id');
    $this->candidato_ref_vecinal_model->delete($id);
    $msj = array(
      'codigo' => 1,
      'msg' => 'Referencia vecinal eliminada correctamente'
    );
    echo json_encode($msj);
  }
}