<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_Estudio extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
  /*----------------------------------------*/
  /*  #Historial 
  /*----------------------------------------*/
  function getHistorialById(){
    $res = $this->candidato_estudio_model->getHistorialById($this->input->post('id'));
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function setHistorial(){
    $id_candidato = $this->input->post('id_candidato');
    $seccion = $this->candidato_seccion_model->getSecciones($id_candidato);
    if($seccion->id_estudios == 51){
      $this->form_validation->set_rules('actual_promedio', 'Promedio de Estudios actuales', 'numeric|trim');
      $this->form_validation->set_rules('cedula', 'Cédula profesional', 'required|trim');
    }
    if($seccion->id_estudios == 29){
      $this->form_validation->set_rules('otro_certificado', 'Otros certificados/cursos', 'required|trim');
      $this->form_validation->set_rules('carrera_inactivo', 'Periodos inactivos', 'required|trim');
      $this->form_validation->set_rules('estudios_comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_estudios == 52){
      $this->form_validation->set_rules('prim_promedio', 'Promedio de Primaria', 'numeric|trim');
      $this->form_validation->set_rules('sec_promedio', 'Promedio de Secundaria', 'numeric|trim');
      $this->form_validation->set_rules('prep_promedio', 'Promedio de Bachillerato', 'numeric|trim');
      $this->form_validation->set_rules('lic_promedio', 'Promedio de Licenciatura', 'numeric|trim');
      $this->form_validation->set_rules('otro_certificado', 'Otros certificados/cursos', 'required|trim');
      $this->form_validation->set_rules('carrera_inactivo', 'Periodos inactivos', 'required|trim');
      $this->form_validation->set_rules('estudios_comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_estudios == 69){
      $this->form_validation->set_rules('prim_inicio', 'Año inicio de Primaria', 'required|numeric|max_length[4]');
      $this->form_validation->set_rules('prim_fin', 'Año fin de Primaria', 'required|numeric|max_length[4]');
      $this->form_validation->set_rules('prim_escuela', 'Escuela o Institución de Primaria', 'required|trim');
      $this->form_validation->set_rules('prim_ciudad', 'Ciudad/Municipio de Primaria', 'required|trim');
      $this->form_validation->set_rules('prim_certificado', 'Certificado/Comprobante de Primaria', 'required');
      
      $this->form_validation->set_rules('sec_inicio', 'Año inicio de Secundaria', 'numeric|max_length[4]');
      $this->form_validation->set_rules('sec_fin', 'Año fin de Secundaria', 'numeric|max_length[4]');
      $this->form_validation->set_rules('sec_escuela', 'Escuela o Institución de Secundaria', 'trim');
      $this->form_validation->set_rules('sec_ciudad', 'Ciudad/Municipio de Secundaria', 'trim');
      $this->form_validation->set_rules('sec_certificado', 'Certificado/Comprobante de Secundaria', 'required');

      $this->form_validation->set_rules('prep_inicio', 'Año inicio de Bachillerato', 'numeric|max_length[4]');
      $this->form_validation->set_rules('prep_fin', 'Año fin de Bachillerato', 'numeric|max_length[4]');
      $this->form_validation->set_rules('prep_escuela', 'Escuela o Institución de Bachillerato', 'trim');
      $this->form_validation->set_rules('prep_ciudad', 'Ciudad/Municipio de Bachillerato', 'trim');
      $this->form_validation->set_rules('prep_certificado', 'Certificado/Comprobante de Bachillerato', 'required');

      $this->form_validation->set_rules('lic_inicio', 'Año inicio de Licenciatura', 'numeric|max_length[4]');
      $this->form_validation->set_rules('lic_fin', 'Año fin de Licenciatura', 'numeric|max_length[4]');
      $this->form_validation->set_rules('lic_escuela', 'Escuela o Institución de Licenciatura', 'trim');
      $this->form_validation->set_rules('lic_ciudad', 'Ciudad/Municipio de Licenciatura', 'trim');
      $this->form_validation->set_rules('lic_certificado', 'Certificado/Comprobante de Licenciatura', 'required');
    }
    $this->form_validation->set_message('required','El campo {field} es obligatorio');
    $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');
    $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');

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
      if($seccion->id_estudios == 69){
        $prim_periodo = $this->input->post('prim_inicio').'-'.$this->input->post('prim_fin');
        $sec_periodo = $this->input->post('sec_inicio').'-'.$this->input->post('sec_fin');
        $prep_periodo = $this->input->post('prep_inicio').'-'.$this->input->post('prep_fin');
        $lic_periodo = $this->input->post('lic_inicio').'-'.$this->input->post('lic_fin');
      }
      else{
        $prim_periodo = $this->input->post('prim_periodo');
        $sec_periodo = $this->input->post('sec_periodo');
        $prep_periodo = $this->input->post('prep_periodo');
        $lic_periodo = $this->input->post('lic_periodo');
      }

      $hayId = $this->candidato_estudio_model->checkHistorial($id_candidato);
      if($hayId > 0){
        $estudios = array(
          'edicion' => $date,
          'id_usuario' => $id_usuario,
          'primaria_periodo' => $prim_periodo,
          'primaria_escuela' => $this->input->post('prim_escuela'),
          'primaria_ciudad' => $this->input->post('prim_ciudad'),
          'primaria_certificado' => $this->input->post('prim_certificado'),
          'primaria_promedio' => $this->input->post('prim_promedio'),
          'secundaria_periodo' => $sec_periodo,
          'secundaria_escuela' => $this->input->post('sec_escuela'),
          'secundaria_ciudad' => $this->input->post('sec_ciudad'),
          'secundaria_certificado' => $this->input->post('sec_certificado'),
          'secundaria_promedio' => $this->input->post('sec_promedio'),
          'preparatoria_periodo' => $prep_periodo,
          'preparatoria_escuela' => $this->input->post('prep_escuela'),
          'preparatoria_ciudad' => $this->input->post('prep_ciudad'),
          'preparatoria_certificado' => $this->input->post('prep_certificado'),
          'preparatoria_promedio' => $this->input->post('prep_promedio'),
          'licenciatura_periodo' => $lic_periodo,
          'licenciatura_escuela' => $this->input->post('lic_escuela'),
          'licenciatura_ciudad' => $this->input->post('lic_ciudad'),
          'licenciatura_certificado' => $this->input->post('lic_certificado'),
          'licenciatura_promedio' => $this->input->post('lic_promedio'),
          'actual_periodo' => $this->input->post('actual_periodo'),
          'actual_escuela' => $this->input->post('actual_escuela'),
          'actual_ciudad' => $this->input->post('actual_ciudad'),
          'actual_certificado' => $this->input->post('actual_certificado'),
          'actual_promedio' => $this->input->post('actual_promedio'),
          'cedula_profesional' => $this->input->post('cedula'),
          'otros_certificados' => $this->input->post('otro_certificado'),
          'comentarios' => $this->input->post('estudios_comentarios'),
          'carrera_inactivo' => $this->input->post('carrera_inactivo')
        );
        $this->candidato_estudio_model->editHistorial($estudios, $id_candidato);
      }
      else{
        $estudios = array(
          'creacion' => $date,
          'edicion' => $date,
          'id_usuario' => $id_usuario,
          'id_candidato' => $id_candidato,
          'primaria_periodo' => $prim_periodo,
          'primaria_escuela' => $this->input->post('prim_escuela'),
          'primaria_ciudad' => $this->input->post('prim_ciudad'),
          'primaria_certificado' => $this->input->post('prim_certificado'),
          'primaria_promedio' => $this->input->post('prim_promedio'),
          'secundaria_periodo' => $sec_periodo,
          'secundaria_escuela' => $this->input->post('sec_escuela'),
          'secundaria_ciudad' => $this->input->post('sec_ciudad'),
          'secundaria_certificado' => $this->input->post('sec_certificado'),
          'secundaria_promedio' => $this->input->post('sec_promedio'),
          'preparatoria_periodo' => $prep_periodo,
          'preparatoria_escuela' => $this->input->post('prep_escuela'),
          'preparatoria_ciudad' => $this->input->post('prep_ciudad'),
          'preparatoria_certificado' => $this->input->post('prep_certificado'),
          'preparatoria_promedio' => $this->input->post('prep_promedio'),
          'licenciatura_periodo' => $lic_periodo,
          'licenciatura_escuela' => $this->input->post('lic_escuela'),
          'licenciatura_ciudad' => $this->input->post('lic_ciudad'),
          'licenciatura_certificado' => $this->input->post('lic_certificado'),
          'licenciatura_promedio' => $this->input->post('lic_promedio'),
          'actual_periodo' => $this->input->post('actual_periodo'),
          'actual_escuela' => $this->input->post('actual_escuela'),
          'actual_ciudad' => $this->input->post('actual_ciudad'),
          'actual_certificado' => $this->input->post('actual_certificado'),
          'actual_promedio' => $this->input->post('actual_promedio'),
          'cedula_profesional' => $this->input->post('cedula'),
          'otros_certificados' => $this->input->post('otro_certificado'),
          'comentarios' => $this->input->post('estudios_comentarios'),
          'carrera_inactivo' => $this->input->post('carrera_inactivo')
        );
        $this->candidato_estudio_model->addHistorial($estudios);
      }
      $msj = array(
        'codigo' => 1,
        'msg' => 'success'
      );
    }
    echo json_encode($msj);
  }
  function getMaximoEstudio(){
    $res = $this->candidato_estudio_model->getHistorialById($this->input->post('id'));
    if($res != null){
      if($res->licenciatura_periodo != null || $res->licenciatura_periodo != ''){
        $periodo = explode('-',$res->licenciatura_periodo);
        echo 'Licenciatura, el cual curso de '.$periodo[0].' a '.$periodo[1].';';
      }
      else{
        if($res->preparatoria_periodo != null || $res->preparatoria_periodo != ''){
          $periodo = explode('-',$res->preparatoria_periodo);
          echo 'Bachillerato, el cual curso de '.$periodo[0].' a '.$periodo[1].';';
        }
        else{
          if($res->secundaria_periodo != null || $res->secundaria_periodo != ''){
            $periodo = explode('-',$res->secundaria_periodo);
            echo 'Secundaria, el cual curso de '.$periodo[0].' a '.$periodo[1].';';
          }
          else{
            if($res->primaria_periodo != null || $res->primaria_periodo != ''){
              $periodo = explode('-',$res->primaria_periodo);
              echo 'Primaria, el cual curso de '.$periodo[0].' a '.$periodo[1].';';
            }
          }
        }
      }
    }
    else{
      echo $res = 'sin estudios; ';
    }
  }
  /*----------------------------------------*/
  /*  #Mayores 
  /*----------------------------------------*/
  function getMayorById(){
    $res = $this->candidato_estudio_model->getMayorById($this->input->post('id'));
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function setMayor(){
    $this->form_validation->set_rules('mayor_estudios_candidato', 'Nivel escolar del Candidato', 'required|trim');
    $this->form_validation->set_rules('periodo_candidato', 'Periodo del Candidato', 'required|trim');
    $this->form_validation->set_rules('escuela_candidato', 'Escuela del Candidato', 'required|trim');
    $this->form_validation->set_rules('ciudad_candidato', 'Ciudad del Candidato', 'required|trim');
    $this->form_validation->set_rules('certificado_candidato', 'Certificado del Candidato', 'required|trim');
    $this->form_validation->set_rules('mayor_estudios_analista', 'Nivel escolar revisado por Analista', 'required|trim');
    $this->form_validation->set_rules('periodo_analista', 'Periodo revisado por Analista', 'required|trim');
    $this->form_validation->set_rules('escuela_analista', 'Escuela revisado por Analista', 'required|trim');
    $this->form_validation->set_rules('ciudad_analista', 'Ciudad revisado por Analista', 'required|trim');
    $this->form_validation->set_rules('certificado_analista', 'Certificado obtenido revisado por Analista', 'required|trim');
    $this->form_validation->set_rules('comentarios', 'Comentarios de la analista', 'required|trim');

    $this->form_validation->set_message('required','El campo {field} es obligatorio');
    $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
    $this->form_validation->set_message('alpha','El campo {field} debe contener solo carácteres alfabéticos y sin acentos');
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
      $id_candidato = $this->input->post('id_candidato');
      $id_usuario = $this->session->userdata('id');

      $hayId = $this->candidato_estudio_model->checkMayor($id_candidato);
      if($hayId > 0){
        $candidato = array(
          'edicion' => $date,
          'id_usuario' => $id_usuario,
          'id_grado_estudio' => $this->input->post('mayor_estudios_candidato'),
          'estudios_periodo' => $this->input->post('periodo_candidato'),
          'estudios_escuela' => $this->input->post('escuela_candidato'),
          'estudios_ciudad' => $this->input->post('ciudad_candidato'),
          'estudios_certificado' => $this->input->post('certificado_candidato')
        );
        $this->candidato_model->editarCandidato($candidato, $id_candidato);
        $verificacion = array(
          'edicion' => $date,
          'id_usuario' => $id_usuario,
          'id_tipo_studies' => $this->input->post('mayor_estudios_analista'),
          'periodo' => $this->input->post('periodo_analista'),
          'escuela' => $this->input->post('escuela_analista'),
          'ciudad' => $this->input->post('ciudad_analista'),
          'certificado' => $this->input->post('certificado_analista'),
          'comentarios' => $this->input->post('comentarios')
        );
        $this->candidato_estudio_model->editMayor($verificacion, $id_candidato);
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
      }
      else{
        $candidato = array(
          'edicion' => $date,
          'id_usuario' => $id_usuario,
          'id_grado_estudio' => $this->input->post('mayor_estudios_candidato'),
          'estudios_periodo' => $this->input->post('periodo_candidato'),
          'estudios_escuela' => $this->input->post('escuela_candidato'),
          'estudios_ciudad' => $this->input->post('ciudad_candidato'),
          'estudios_certificado' => $this->input->post('certificado_candidato')
        );
        $this->candidato_model->editarCandidato($candidato, $id_candidato);
        $verificacion = array(
          'creacion' => $date,
          'edicion' => $date,
          'id_usuario' => $id_usuario,
          'id_candidato' => $id_candidato,
          'id_tipo_studies' => $this->input->post('mayor_estudios_analista'),
          'periodo' => $this->input->post('periodo_analista'),
          'escuela' => $this->input->post('escuela_analista'),
          'ciudad' => $this->input->post('ciudad_analista'),
          'certificado' => $this->input->post('certificado_analista'),
          'comentarios' => $this->input->post('comentarios')
        );
        $this->candidato_estudio_model->addMayor($verificacion);
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
      }
    }
    echo json_encode($msj);
  }

 
}