<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_Investigacion extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

  function getById(){
    $seccion = $this->candidato_seccion_model->getSecciones($this->input->post('id'));
    if($seccion->id_investigacion != 81 && $seccion->id_investigacion != 110){
      $tabla_origen = 'verificacion_legal';
      $res = $this->candidato_investigacion_model->getById($this->input->post('id'), $tabla_origen);
      if($res != null){
        echo json_encode($res);
      }
      else{
        echo $res = 0;
      }
    }
    if($seccion->id_investigacion == 81 || $seccion->id_investigacion == 110){
      $tabla_origen = 'candidato_pruebas';
      $res = $this->candidato_investigacion_model->getById($this->input->post('id'), $tabla_origen);
      if($res != null){
        echo json_encode($res);
      }
      else{
        echo $res = 0;
      }
    }
  }

  function setInvestigaciones(){
    $this->form_validation->set_rules('oig', 'Estatus OIG', 'required|trim');
    $this->form_validation->set_rules('res_oig', 'Resultado OIG', 'required|trim');
    $this->form_validation->set_rules('sam', 'Estatus SAM', 'required|trim');
    $this->form_validation->set_rules('res_sam', 'Resultado SAM', 'required|trim');

    $this->form_validation->set_message('required','El campo {field} es obligatorio');

    $msj = array();
    if ($this->form_validation->run() == FALSE) {
      $msj = array(
        'codigo' => 0,
        'msg' => validation_errors()
      );
    } 
    else{
      $id_candidato = $this->input->post('id_candidato');
      $id_usuario = $this->session->userdata('id');
      date_default_timezone_set('America/Mexico_City');
      $date = date('Y-m-d H:i:s');

      $datos = array(
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'ofac' => $this->input->post('ofac'),
        'resultado_ofac' => $this->input->post('res_ofac'),
        'oig' => $this->input->post('oig'),
        'resultado_oig' => $this->input->post('res_oig'),
        'sam' => $this->input->post('sam'),
        'resultado_sam' => $this->input->post('res_sam'),
        'data_juridica' => $this->input->post('juridica'),
        'res_data_juridica' => $this->input->post('res_juridica')
      );
      $this->candidato_investigacion_model->edit($datos, $id_candidato);

      $msj = array(
        'codigo' => 1,
        'msg' => 'success'
      );
    }
    echo json_encode($msj);
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
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} caracteres');
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
        $seccion = $this->candidato_seccion_model->getSecciones($id_candidato);
        
        if($seccion->id_investigacion != 81 && $seccion->id_investigacion != 110){
          $tabla_origen = 'verificacion_legal';
        }
        if($seccion->id_investigacion == 81 || $seccion->id_investigacion == 110){
          $tabla_origen = 'candidato_pruebas';
        }
        $hayId = $this->candidato_investigacion_model->countByIdCandidato($id_candidato, $tabla_origen);
        if($hayId == 0){
          $creacion = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'id_candidato' => $id_candidato,
          );
          $this->candidato_investigacion_model->add($creacion, $tabla_origen);
          foreach($data['campos'] as $c){
            $edicion = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              $c->referencia => $this->input->post($c->name)
            );
            $this->candidato_investigacion_model->edit($edicion, $id_candidato, $tabla_origen);
          }
        }
        else{
          foreach($data['campos'] as $c){
            $edicion = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              $c->referencia => $this->input->post($c->name)
            );
            $this->candidato_investigacion_model->edit($edicion, $id_candidato, $tabla_origen);
          }
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'Investigación registrada correctamente'
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
?>