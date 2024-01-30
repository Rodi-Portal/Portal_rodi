<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_Laboral extends Custom_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

  /*----------------------------------------*/
  /*  #NoMencionados 
  /*----------------------------------------*/
  function getNoMencionadosById(){
    $res = $this->candidato_laboral_model->getNoMencionadosById($this->input->post('id'));
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function setNoMencionados(){
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
        $date = date('Y-m-d H:i:s');
        $id_usuario = $this->session->userdata('id');
  
        $hayId = $this->candidato_laboral_model->checkNoMencionados($id_candidato);
        if($hayId == 0){
          $creacion = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'id_candidato' => $id_candidato,
          );
          $this->candidato_laboral_model->addNoMencionados($creacion);
          foreach($data['campos'] as $c){
            $edicion = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              $c->referencia => $this->input->post($c->name)
            );
            $this->candidato_laboral_model->editNoMencionados($edicion, $id_candidato);
          }
        }
        else{
          foreach($data['campos'] as $c){
            $edicion = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              $c->referencia => $this->input->post($c->name)
            );
            $this->candidato_laboral_model->editNoMencionados($edicion, $id_candidato);
          }
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'Laborales no mencionadas actualizadas correctamente'
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
  /*----------------------------------------*/
  /*  #AntecedentelLaboral 
  /*----------------------------------------*/
  function getAntecedentesLaboralesById(){
    $data['laborales'] = $this->candidato_laboral_model->getAntecedentesLaboralesById($this->input->post('id'));
    if($data['laborales']){
      echo json_encode($data['laborales']);
    }
    else{
      echo $res = 0;
    }
  }
  function setAntecedentesLaborales(){
    $id_candidato = $this->input->post('id_candidato');
    $candidato_detalle = $this->candidato_model->getDetalles($id_candidato);
    $fail = 0;
    $data['campos'] = $this->formulario_model->getBySeccionAndAutor($this->input->post('id_seccion'), 'orden_front', $this->input->post('autor'));
    if($data['campos']){
      foreach($data['campos'] as $campo){
        $label = ($candidato_detalle->ingles == 0)? $campo->backend_label : $campo->backend_label_ingles;
        $referencia = explode('ana_',$campo->atr_id);
        $this->form_validation->set_rules($referencia[1],$label,$campo->backend_rule);
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
        $id_laboral = $this->input->post('id');
        $id_usuario = $this->session->userdata('id');
        $number = ($this->input->post('num') + 1);
  
        $hayId = $this->candidato_laboral_model->countAntecedentesLaboralesByIdCandidato($id_candidato);
        if($hayId == 0){
          $creacion = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_candidato' => $id_candidato,
            'id_usuario' => $id_usuario,
            'numero_referencia' => $number
          );
          $id_laboral = $this->candidato_laboral_model->addAntecedenteLaboral($creacion);
          foreach($data['campos'] as $c){
            $valor = explode('ana_',$c->atr_id);
            $edicion = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              $c->referencia => $this->input->post($valor[1])
            );
            $this->candidato_laboral_model->editAntecedenteLaboral($edicion, $id_candidato, $id_laboral);
          }
        }
        else{
          if($id_laboral != 0){
            foreach($data['campos'] as $c){
              $valor = explode('ana_',$c->atr_id);
              $edicion = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                $c->referencia => $this->input->post($valor[1])
              );
              $this->candidato_laboral_model->editAntecedenteLaboral($edicion, $id_candidato, $id_laboral);
            }
          }
          else{
            $creacion = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_candidato' => $id_candidato,
              'id_usuario' => $id_usuario,
              'numero_referencia' => $number
            );
            $id_laboral = $this->candidato_laboral_model->addAntecedenteLaboral($creacion);
            foreach($data['campos'] as $c){
              $valor = explode('ana_',$c->atr_id);
              $edicion = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                $c->referencia => $this->input->post($valor[1])
              );
              $this->candidato_laboral_model->editAntecedenteLaboral($edicion, $id_candidato, $id_laboral);
            }
          }
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
        //* Mensaje automatico de avance
        $mensajeAvance = ($candidato_detalle->ingles == 0)? '[System] El historial laboral del candidato se ha actualizado' : '[System] The candidate\'s employment history has been updated';
        $this->registrar_mensaje_avance($id_candidato, $mensajeAvance);
      }
      //* Si el usuario actual es un candidato (tipo 3), se registra su avance en el llenado del formulario de su acceso
      if($this->session->userdata('tipo') == 3 && $msj['codigo'] == 1){
        $this->registrar_avance_candidato($id_usuario, 'laborales');
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
  function deleteAntecedenteLaboral(){
    $id = $this->input->post('id');
    $id_candidato = $this->input->post('id_candidato');
    $this->candidato_laboral_model->deleteAntecedenteLaboral($id, $id_candidato);
    $msj = array(
      'codigo' => 1,
      'msg' => 'success'
    );
    echo json_encode($msj);
  }
  /*----------------------------------------*/
  /*  #HistorialLaboral 
  /*----------------------------------------*/
  function getHistorialLaboralById(){
    $data['laborales'] = $this->candidato_laboral_model->getHistorialLaboralById($this->input->post('id'));
    if($data['laborales']){
      echo json_encode($data['laborales']);
    }
    else{
      echo $res = 0;
    }
  }
  function getVerificacionLaboralById(){
    $data['verificaciones'] = $this->candidato_laboral_model->getVerificacionLaboralById($this->input->post('id'));
    if($data['verificaciones']){
      echo json_encode($data['verificaciones']);
    }
    else{
      echo $res = 0;
    }
  }
  function setHistorialLaboral(){
    $id_candidato = $this->input->post('id_candidato');
    $candidato_detalle = $this->candidato_model->getDetalles($id_candidato);
    $fail = 0;
    $data['campos'] = $this->formulario_model->getBySeccionAndAutor($this->input->post('id_seccion'), 'orden_front', $this->input->post('autor'));
    if($data['campos']){
      foreach($data['campos'] as $campo){
        $label = ($candidato_detalle->ingles == 0)? $campo->backend_label : $campo->backend_label_ingles;
        $referencia = explode('cand_',$campo->atr_id);
        $this->form_validation->set_rules($referencia[1],$label,$campo->backend_rule);
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
        $id_laboral = $this->input->post('id');
        $id_usuario = $this->session->userdata('id');
        //$number = $this->input->post('num');
  
        $hayId = $this->candidato_laboral_model->countLaboralesByIdCandidato($id_candidato);
        if($hayId == 0){
          $creacion = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_candidato' => $id_candidato,
          );
          $id_laboral = $this->candidato_laboral_model->addLaboral($creacion);
          foreach($data['campos'] as $c){
            $valor = explode('cand_',$c->atr_id);
            $edicion = array(
              'edicion' => $date,
              $c->referencia => $this->input->post($valor[1])
            );
            $this->candidato_laboral_model->editLaboral($edicion, $id_candidato, $id_laboral);
          }
          //* Mensaje automatico de avance
          $mensajeAvance = ($candidato_detalle->ingles == 0)? '[System] El historial laboral del candidato se ha actualizado' : '[System] The candidate\'s employment history has been updated';
          $this->registrar_mensaje_avance($id_candidato, $mensajeAvance);
        }
        else{
          if($id_laboral != 0){
            foreach($data['campos'] as $c){
              $valor = explode('cand_',$c->atr_id);
              $edicion = array(
                'edicion' => $date,
                $c->referencia => $this->input->post($valor[1])
              );
              $this->candidato_laboral_model->editLaboral($edicion, $id_candidato, $id_laboral);
            }
          }
          else{
            $creacion = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_candidato' => $id_candidato,
            );
            $id_laboral = $this->candidato_laboral_model->addLaboral($creacion);
            foreach($data['campos'] as $c){
              $valor = explode('cand_',$c->atr_id);
              $edicion = array(
                'edicion' => $date,
                $c->referencia => $this->input->post($valor[1])
              );
              $this->candidato_laboral_model->editLaboral($edicion, $id_candidato, $id_laboral);
            }
            //* Mensaje automatico de avance
            $mensajeAvance = ($candidato_detalle->ingles == 0)? '[System] El historial laboral del candidato se ha actualizado' : '[System] The candidate\'s employment history has been updated';
            $this->registrar_mensaje_avance($id_candidato, $mensajeAvance);
          }
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
      }
      //* Si el usuario actual es un candidato (tipo 3), se registra su avance en el llenado del formulario de su acceso
      if($this->session->userdata('tipo') == 3 && $msj['codigo'] == 1){
        $this->registrar_avance_candidato($id_usuario, 'laborales');
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
  function setVerificacionLaboral(){
    $id_candidato = $this->input->post('id_candidato');
    $candidato_detalle = $this->candidato_model->getDetalles($id_candidato);
    $fail = 0;
    $data['campos'] = $this->formulario_model->getBySeccionAndAutor($this->input->post('id_seccion'), 'orden_front', $this->input->post('autor'));
    if($data['campos']){
      foreach($data['campos'] as $campo){
        $referencia = explode('ana_',$campo->atr_id);
        $this->form_validation->set_rules($referencia[1],$campo->backend_label,$campo->backend_rule);

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
        $id_verificacion = $this->input->post('id');
        $number = $this->input->post('num');
        //$id_usuario = $this->session->userdata('id');
  
        $hayId = $this->candidato_laboral_model->countVerificacionesByIdCandidato($id_candidato);
        if($hayId == 0){
          $creacion = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_candidato' => $id_candidato,
            'numero_referencia' => ($number+1)
          );
          $id_verificacion = $this->candidato_laboral_model->addVerificacion($creacion);
          foreach($data['campos'] as $c){
            $valor = explode('ana_',$c->atr_id);
            $edicion = array(
              'edicion' => $date,
              $c->referencia => $this->input->post($valor[1])
            );
            $this->candidato_laboral_model->editVerificacion($edicion, $id_candidato, $id_verificacion);
          }
          //* Mensaje automatico de avance
          $mensajeAvance = ($candidato_detalle->ingles == 0)? '[System] La verificación del historial laboral del candidato se ha actualizado' : '[System] The candidate\'s employment history verification has been updated';
          $this->registrar_mensaje_avance($id_candidato, $mensajeAvance);
        }
        else{
          if($id_verificacion != 0){
            foreach($data['campos'] as $c){
              $valor = explode('ana_',$c->atr_id);
              $edicion = array(
                'edicion' => $date,
                $c->referencia => $this->input->post($valor[1]),
                'numero_referencia' => ($number+1)
              );
              $this->candidato_laboral_model->editVerificacion($edicion, $id_candidato, $id_verificacion);
            }
          }
          else{
            $creacion = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_candidato' => $id_candidato,
              'numero_referencia' => ($number+1)
            );
            $id_verificacion = $this->candidato_laboral_model->addVerificacion($creacion);
            foreach($data['campos'] as $c){
              $valor = explode('ana_',$c->atr_id);
              $edicion = array(
                'edicion' => $date,
                $c->referencia => $this->input->post($valor[1])
              );
              $this->candidato_laboral_model->editVerificacion($edicion, $id_candidato, $id_verificacion);
            }
            //* Mensaje automatico de avance
            $mensajeAvance = ($candidato_detalle->ingles == 0)? '[System] La verificación del historial laboral del candidato se ha actualizado' : '[System] The candidate\'s employment history verification has been updated';
            $this->registrar_mensaje_avance($id_candidato, $mensajeAvance);
          }
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
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
  function deleteLaboral(){
    $id = $this->input->post('id');
    $numero = $this->input->post('numero');
    $id_candidato = $this->input->post('id_candidato');
    $this->candidato_laboral_model->deleteLaboral($id, $id_candidato);
    //* Elimina Verificacion laboral y actualiza la numeracion de las verificaciones
    $this->candidato_laboral_model->deleteVerificacionLaboralByNumero($numero, $id_candidato);
    $data['verificaciones'] = $this->candidato_laboral_model->getVerificacionLaboralById($id_candidato);
    if($data['verificaciones']){
      foreach($data['verificaciones'] as $row){
        if($row->numero_referencia > $numero){
          $numeroActual = $row->numero_referencia;
          $numeroNuevo = $row->numero_referencia - 1;
          $this->candidato_laboral_model->editVerificacionByNumero($id_candidato, $numeroActual, $numeroNuevo);
        }
      }
    }
    //* Elimina contacto laboral y actualiza numeracion de los contactos
    $this->candidato_laboral_model->deleteContactoLaboralByNumero($numero, $id_candidato);
    $data['contactos'] = $this->candidato_laboral_model->getContactoLaboralById($id_candidato);
    if($data['contactos']){
      foreach($data['contactos'] as $row){
        if($row->numero_referencia > $numero){
          $numeroActual = $row->numero_referencia;
          $numeroNuevo = $row->numero_referencia - 1;
          $this->candidato_laboral_model->editContactoByNumero($id_candidato, $numeroActual, $numeroNuevo);
        }
      }
    }

    $msj = array(
      'codigo' => 1,
      'msg' => 'success'
    );
    echo json_encode($msj);
  }
  function deleteVerificacion(){
    $id = $this->input->post('id');
    $id_candidato = $this->input->post('id_candidato');
    $this->candidato_laboral_model->deleteVerificacion($id, $id_candidato);
    $msj = array(
      'codigo' => 1,
      'msg' => 'success'
    );
    echo json_encode($msj);
  }
  function countAntecedentesLaborales(){
    $id_candidato = $this->input->post('id_candidato');
    $numero = $this->candidato_laboral_model->countAntecedentesLaborales($id_candidato);
    echo $numero;
  }
  function getComentarios(){
    $id_candidato = $this->input->post('id_candidato');
    $salida = "";
    $data['ref'] = $this->candidato_laboral_model->getComentarios($id_candidato);
    if($data['ref']){
      foreach($data['ref'] as $ref){
        $salida .= $ref->notas.", ";
      }
      $res = trim($salida, ", ");
      echo $res;
    }
    else{
      echo $salida;
    }
  }
  function getHistorialPuestos(){
    $data['puestos'] = $this->candidato_laboral_model->getHistorialPuestos($this->input->post('id'));
    $salida = "";
    if($data['puestos']){
      foreach($data['puestos'] as $ref){
        $salida .= $ref->puesto1.', '.$ref->puesto2.', ';
      }
      $res = trim($salida, ", ");
      echo $res;
    }
    else{
      $salida = 'sin puestos registrados';
      echo $salida;
    }
  }
  function getHistorialIncidencias(){
    $data['laborales'] = $this->candidato_laboral_model->getHistorialIncidencias($this->input->post('id'));
    $salida = "";
    if($data['laborales']){
      foreach($data['laborales'] as $ref){
        $salida .= strtoupper($ref->empresa).', ';

        if($ref->cumplimiento != 'No proporciona' || $ref->cumplimiento != 'No aplica' || $ref->cumplimiento != 'NA' || $ref->cumplimiento != 'N/A'){
          $salida .= 'donde '.$ref->contacto.' lo reporta con incidencias de '.$ref->cumplimiento.', ';
          if($ref->conflicto != 'No proporciona' || $ref->conflicto != 'No aplica' || $ref->conflicto != 'NA' || $ref->conflicto != 'N/A'){
            $salida .= $ref->conflicto.'; ';
          }
          else{
            $salida .= '; ';
          }
        }
        else{
          if($ref->conflicto != 'No proporciona' || $ref->conflicto != 'No aplica' || $ref->conflicto != 'NA' || $ref->conflicto != 'N/A'){
            $salida .= 'donde '.$ref->contacto.' lo reporta con incidencias de '.$ref->conflicto.'; ';
          }
          else{
            $salida .= 'donde '.$ref->contacto.' lo reporta sin incidencias ni notas negativas; ';
          }
        }
      }
      $res = trim($salida, "; ");
      echo $res;
    }
    else{
      echo $salida;
    }
  }
  function getContactoById(){
    $data['laborales'] = $this->candidato_laboral_model->getContactoById($this->input->post('id'));
    if($data['laborales']){
      echo json_encode($data['laborales']);
    }
    else{
      echo $res = 0;
    }
  }
  function getContactoLaboralById(){
    $data['contactos'] = $this->candidato_laboral_model->getContactoLaboralById($this->input->post('id'));
    if($data['contactos']){
      echo json_encode($data['contactos']);
    }
    else{
      echo $res = 0;
    }
  }
  function setContactoLaboral(){
    $id_candidato = $this->input->post('id_candidato');
    $fail = 0;
    $data['campos'] = $this->formulario_model->getBySeccionAndAutor($this->input->post('id_seccion'), 'orden_front', $this->input->post('autor'));
    if($data['campos']){
      foreach($data['campos'] as $campo){
        $referencia = explode('ana_',$campo->atr_id);
        $this->form_validation->set_rules($referencia[1],$campo->backend_label,$campo->backend_rule);

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
        $id_verificacion = $this->input->post('id');
        $number = $this->input->post('num');
        //$id_usuario = $this->session->userdata('id');
  
        $hayId = $this->candidato_laboral_model->countContactosByIdCandidato($id_candidato);
        if($hayId == 0){
          $creacion = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_candidato' => $id_candidato,
            'numero_referencia' => ($number+1)
          );
          $id_verificacion = $this->candidato_laboral_model->addContacto($creacion);
          foreach($data['campos'] as $c){
            $valor = explode('ana_',$c->atr_id);
            $edicion = array(
              'edicion' => $date,
              $c->referencia => $this->input->post($valor[1])
            );
            $this->candidato_laboral_model->editContacto($edicion, $id_candidato, $id_verificacion);
          }
        }
        else{
          if($id_verificacion != 0){
            foreach($data['campos'] as $c){
              $valor = explode('ana_',$c->atr_id);
              $edicion = array(
                'edicion' => $date,
                $c->referencia => $this->input->post($valor[1]),
                'numero_referencia' => ($number+1)
              );
              $this->candidato_laboral_model->editContacto($edicion, $id_candidato, $id_verificacion);
            }
          }
          else{
            $creacion = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_candidato' => $id_candidato,
              'numero_referencia' => ($number+1)
            );
            $id_verificacion = $this->candidato_laboral_model->addContacto($creacion);
            foreach($data['campos'] as $c){
              $valor = explode('ana_',$c->atr_id);
              $edicion = array(
                'edicion' => $date,
                $c->referencia => $this->input->post($valor[1])
              );
              $this->candidato_laboral_model->editContacto($edicion, $id_candidato, $id_verificacion);
            }
          }
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
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
  function deleteContacto(){
    $id = $this->input->post('id');
    $id_candidato = $this->input->post('id_candidato');
    $this->candidato_laboral_model->deleteContacto($id, $id_candidato);
    $msj = array(
      'codigo' => 1,
      'msg' => 'success'
    );
    echo json_encode($msj);
  }
  /*----------------------------------------*/
  /*  #Cuestioneslaborales 
  /*----------------------------------------*/
  function setCuestiones(){
    $id_candidato = $this->input->post('id_candidato');
    $seccion = $this->candidato_seccion_model->getSecciones($id_candidato);
    if($seccion->id_empleos == 32){
      $this->form_validation->set_rules('trabajo_inactivo', '¿Qué esperas de la empresa en...', 'required|trim');
    }
    if($seccion->id_empleos == 59 || $seccion->id_empleos == 16){
      $this->form_validation->set_rules('trabajo_gobierno', '¿Has trabajado en alguna entidad de gobierno, partido político u ONG?', 'required|trim');
      $this->form_validation->set_rules('trabajo_inactivo', '¿Qué esperas de la empresa en...', 'required|trim');
    }
    if($seccion->id_empleos == 77){
      $this->form_validation->set_rules('trabajo_razon', '¿Por qué te gustaría trabajar...', 'required|trim');
      $this->form_validation->set_rules('trabajo_expectativa', 'Periodos inactivos laborales', 'required|trim');
    }
    if($seccion->id_empleos == 90){
      $this->form_validation->set_rules('trabajo_gobierno', '¿Has trabajado en alguna entidad de gobierno, partido político u ONG?', 'required|trim');
    }
    $this->form_validation->set_message('required','El campo {field} es obligatorio');
    $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
    $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

    $msj = array();
    if ($this->form_validation->run() == FALSE) {
      $msj = array(
        'codigo' => 0,
        'msg' => validation_errors()
      );
    } 
    else{
      date_default_timezone_set('America/Mexico_City');
      $date = date('Y-m-d H:i:s');
      $id_usuario = $this->session->userdata('id');

      $candidato = array(
        'edicion' => $date,
        //'id_usuario' => $id_usuario,
        'trabajo_razon' => $this->input->post('trabajo_razon'),
        'trabajo_expectativa' => $this->input->post('trabajo_expectativa'),
        'trabajo_gobierno' => $this->input->post('trabajo_gobierno'),
        'trabajo_inactivo' => $this->input->post('trabajo_inactivo')
        //'visitador' => 1
      );
      $this->candidato_model->edit($candidato, $id_candidato);
      $msj = array(
        'codigo' => 1,
        'msg' => 'success'
      );
    }
    echo json_encode($msj);
  }
  /*----------------------------------------*/
  /*  #Extralaborales 
  /*----------------------------------------*/
  function getExtrasById(){
    $res = $this->candidato_laboral_model->getExtrasById($this->input->post('id'));
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function setExtras(){
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
  
        $hayId = $this->candidato_laboral_model->countByIdCandidato($id_candidato);
        if($hayId == 0){
          $creacion = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'id_candidato' => $id_candidato,
          );
          $this->candidato_laboral_model->add($creacion);
          foreach($data['campos'] as $c){
            $edicion = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              $c->referencia => $this->input->post($c->name)
            );
            $this->candidato_laboral_model->edit($edicion, $id_candidato);
          }
        }
        else{
          foreach($data['campos'] as $c){
            $edicion = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              $c->referencia => $this->input->post($c->name)
            );
            $this->candidato_laboral_model->edit($edicion, $id_candidato);
          }
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
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