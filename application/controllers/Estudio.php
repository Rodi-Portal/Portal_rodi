<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estudio extends Custom_Controller{

	function __construct(){
		parent::__construct();
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
  function setMayor(){
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
        $label = ($candidato_detalle->ingles == 0)? $campo->backend_label : $campo->backend_label_ingles;
        $this->form_validation->set_rules($campo->name,$label,$campo->backend_rule);
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
        $date = date('Y-m-d H:i:s');
        $id_usuario = $this->session->userdata('id');
  
        $hayId = $this->candidato_estudio_model->countByIdCandidato($id_candidato);
        if($hayId == 0){
          //* candidato
          foreach($data['campos'] as $c){
            if($c->autor == 'candidato'){
              $candidato = array(
                'edicion' => $date,
                // 'id_usuario' => $id_usuario,
                $c->referencia => $this->input->post($c->name)
              );
              $this->candidato_model->edit($candidato, $id_candidato);
            }
          }
          //* verificacion_mayores_estudios
          if(($this->input->post('source') !== null && $this->input->post('source') != 'candidato') || $this->input->post('source') === null){
            $creacion = array(
              'creacion' => $date,
              'edicion' => $date,
              // 'id_usuario' => $id_usuario,
              'id_candidato' => $id_candidato,
            );
            $this->candidato_estudio_model->addMayor($creacion);
            foreach($data['campos'] as $c){
              if($c->autor == 'analista'){
                $analista = array(
                  'edicion' => $date,
                  // 'id_usuario' => $id_usuario,
                  $c->referencia => $this->input->post($c->name)
                );
                $this->candidato_estudio_model->editMayor($analista, $id_candidato);
              }
            }
            //* Mensaje automatico de avance
            $mensajeAvance = ($candidato_detalle->ingles == 0)? '[System] Los estudios del candidato han sido verificados' : '[System] The educational background of the candidate has been verified';
            $this->registrar_mensaje_avance($id_candidato, $mensajeAvance);
          }
        }
        else{
          //* candidato
          foreach($data['campos'] as $c){
            if($c->autor == 'candidato'){
              $candidato = array(
                'edicion' => $date,
                // 'id_usuario' => $id_usuario,
                $c->referencia => $this->input->post($c->name)
              );
              $this->candidato_model->edit($candidato, $id_candidato);
            }
          }
          //* verificacion_mayores_estudios
          if(($this->input->post('source') !== null && $this->input->post('source') != 'candidato') || $this->input->post('source') === null){
            foreach($data['campos'] as $c){
              if($c->autor == 'analista'){
                $analista = array(
                  'edicion' => $date,
                  // 'id_usuario' => $id_usuario,
                  $c->referencia => $this->input->post($c->name)
                );
                $this->candidato_estudio_model->editMayor($analista, $id_candidato);
              }
            }
            //* Mensaje automatico de avance
            $mensajeAvance = ($candidato_detalle->ingles == 0)? '[System] Los estudios del candidato han sido verificados' : '[System] The educational background of the candidate has been verified';
            $this->registrar_mensaje_avance($id_candidato, $mensajeAvance);
          }
        }
        $mensaje = ($candidato_detalle->ingles == 0)? 'Estudios actualizados correctamente' : 'Highest studies updated successfully';
        $msj = array(
          'codigo' => 1,
          'msg' => $mensaje
        );
      }
      //* Si el usuario actual es un candidato (tipo 3), se registra su avance en el llenado del formulario de su acceso
      if($this->session->userdata('tipo') == 3 && $msj['codigo'] == 1){
        $this->registrar_avance_candidato($id_usuario, 'estudio');
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
  function setHistorial(){
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
          $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} caracteres');
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
        $seccion = $this->candidato_seccion_model->getSecciones($id_candidato);
        
        if($seccion->id_estudios != 79){
          $hayId = $this->candidato_estudio_model->countByIdCandidatoEstudio($id_candidato);
          if($hayId == 0){
            $creacion = array(
              'creacion' => $date,
              'edicion' => $date,
              // 'id_usuario' => $id_usuario,
              'id_candidato' => $id_candidato,
            );
            $this->candidato_estudio_model->addHistorial($creacion);
            foreach($data['campos'] as $c){
              $edicion = array(
                'edicion' => $date,
                // 'id_usuario' => $id_usuario,
                $c->referencia => $this->input->post($c->name)
              );
              $this->candidato_estudio_model->editHistorial($edicion, $id_candidato);
            }
            //* Mensaje automatico de avance
            $mensajeAvance = ($candidato->ingles == 0)? '[System] Los estudios del candidato han sido verificados' : '[System] The educational background of the candidate has been verified';
            $this->registrar_mensaje_avance($id_candidato, $mensajeAvance);
          }
          else{
            foreach($data['campos'] as $c){
              $edicion = array(
                'edicion' => $date,
                // 'id_usuario' => $id_usuario,
                $c->referencia => $this->input->post($c->name)
              );
              $this->candidato_estudio_model->editHistorial($edicion, $id_candidato);
            }
          }
        }
        if($seccion->id_estudios == 79){
          $hayId = $this->candidato_estudio_model->countByIdCandidatoEstudio($id_candidato);
          if($hayId == 0){
            $creacion = array(
              'creacion' => $date,
              'edicion' => $date,
              // 'id_usuario' => $id_usuario,
              'id_candidato' => $id_candidato,
            );
            $this->candidato_estudio_model->addHistorial($creacion);
            $primaria_periodo = $this->input->post('prim_inicio').'-'.$this->input->post('prim_fin');
            $secundaria_periodo = $this->input->post('secu_inicio').'-'.$this->input->post('secu_fin');
            $preparatoria_periodo = $this->input->post('prep_inicio').'-'.$this->input->post('prep_fin');
            $licenciatura_periodo = $this->input->post('lic_inicio').'-'.$this->input->post('lic_fin');
            $edicion = array(
              'edicion' => $date,
              // 'id_usuario' => $id_usuario,
              'primaria_periodo' => $primaria_periodo,
              'primaria_escuela' => $this->input->post('prim_escuela'),
              'primaria_ciudad' => $this->input->post('prim_ciudad'),
              'primaria_certificado' => $this->input->post('prim_certificado'),
              'secundaria_periodo' => $secundaria_periodo,
              'secundaria_escuela' => $this->input->post('secu_escuela'),
              'secundaria_ciudad' => $this->input->post('secu_ciudad'),
              'secundaria_certificado' => $this->input->post('secu_certificado'),
              'preparatoria_periodo' => $preparatoria_periodo,
              'preparatoria_escuela' => $this->input->post('prep_escuela'),
              'preparatoria_ciudad' => $this->input->post('prep_ciudad'),
              'preparatoria_certificado' => $this->input->post('prep_certificado'),
              'licenciatura_periodo' => $licenciatura_periodo,
              'licenciatura_escuela' => $this->input->post('lic_escuela'),
              'licenciatura_ciudad' => $this->input->post('lic_ciudad'),
              'licenciatura_certificado' => $this->input->post('lic_certificado'),
            );
            $this->candidato_estudio_model->editHistorial($edicion, $id_candidato);
            //* Mensaje automatico de avance
            $mensajeAvance = ($candidato->ingles == 0)? '[System] Los estudios del candidato han sido verificados' : '[System] The educational background of the candidate has been verified';
            $this->registrar_mensaje_avance($id_candidato, $mensajeAvance);
          }
          else{
            $primaria_periodo = $this->input->post('prim_inicio').'-'.$this->input->post('prim_fin');
            $secundaria_periodo = $this->input->post('secu_inicio').'-'.$this->input->post('secu_fin');
            $preparatoria_periodo = $this->input->post('prep_inicio').'-'.$this->input->post('prep_fin');
            $licenciatura_periodo = $this->input->post('lic_inicio').'-'.$this->input->post('lic_fin');
            $edicion = array(
              'edicion' => $date,
              // 'id_usuario' => $id_usuario,
              'primaria_periodo' => $primaria_periodo,
              'primaria_escuela' => $this->input->post('prim_escuela'),
              'primaria_ciudad' => $this->input->post('prim_ciudad'),
              'primaria_certificado' => $this->input->post('prim_certificado'),
              'secundaria_periodo' => $secundaria_periodo,
              'secundaria_escuela' => $this->input->post('secu_escuela'),
              'secundaria_ciudad' => $this->input->post('secu_ciudad'),
              'secundaria_certificado' => $this->input->post('secu_certificado'),
              'preparatoria_periodo' => $preparatoria_periodo,
              'preparatoria_escuela' => $this->input->post('prep_escuela'),
              'preparatoria_ciudad' => $this->input->post('prep_ciudad'),
              'preparatoria_certificado' => $this->input->post('prep_certificado'),
              'licenciatura_periodo' => $licenciatura_periodo,
              'licenciatura_escuela' => $this->input->post('lic_escuela'),
              'licenciatura_ciudad' => $this->input->post('lic_ciudad'),
              'licenciatura_certificado' => $this->input->post('lic_certificado'),
            );
            $this->candidato_estudio_model->editHistorial($edicion, $id_candidato);
          }
        }
        $mensaje = ($candidato->ingles == 0)? 'Historial de estudios actualizados correctamente' : 'Studies record updated successfully';
        $msj = array(
          'codigo' => 1,
          'msg' => $mensaje
        );
      }
      //* Si el usuario actual es un candidato (tipo 3), se registra su avance en el llenado del formulario de su acceso
      if($this->session->userdata('tipo') == 3 && $msj['codigo'] == 1){
        $this->registrar_avance_candidato($id_usuario, 'estudio');
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