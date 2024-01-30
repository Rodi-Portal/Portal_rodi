<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_Servicio extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

  function getById(){
    $res = $this->candidato_servicio_model->getById($this->input->post('id'));
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function set(){
    $id_candidato = $this->input->post('id_candidato');
    $fail = 0;
    $data['campos'] = $this->formulario_model->getBySeccion($this->input->post('id_seccion'), 'orden_front');
    if($data['campos']){
      foreach($data['campos'] as $campo){
        $this->form_validation->set_rules($campo->name,$campo->backend_label,$campo->backend_rule);

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
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_usuario = $this->session->userdata('id');
  
        $hayId = $this->candidato_servicio_model->countByIdCandidato($id_candidato);
        if($hayId == 0){
          $creacion = array(
            'creacion' => $date,
            'edicion' => $date,
            // 'id_usuario' => $id_usuario,
            'id_candidato' => $id_candidato,
          );
          $this->candidato_servicio_model->add($creacion);
          foreach($data['campos'] as $c){
            $edicion = array(
              'edicion' => $date,
              // 'id_usuario' => $id_usuario,
              $c->referencia => $this->input->post($c->name)
            );
            $this->candidato_servicio_model->edit($edicion, $id_candidato);
          }
        }
        else{
          foreach($data['campos'] as $c){
            $edicion = array(
              'edicion' => $date,
              // 'id_usuario' => $id_usuario,
              $c->referencia => $this->input->post($c->name)
            );
            $this->candidato_servicio_model->edit($edicion, $id_candidato);
          }
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'Servicios públicos actualizados correctamente'
        );
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