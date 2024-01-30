<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_Documentacion extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

  function getById(){
    $res = $this->candidato_documentacion_model->getById($this->input->post('id'));
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function set(){
    $id_candidato = $this->input->post('id_candidato');
    $seccion = $this->candidato_seccion_model->getSecciones($id_candidato);
    if($seccion->id_seccion_verificacion_docs == 34){
      $this->form_validation->set_rules('imss', 'Número de documento de la Afiliación al IMSS', 'required|trim');
      $this->form_validation->set_rules('imss_institucion', 'Dato / Institución de la Afiliación al IMSS', 'required|trim');
      $this->form_validation->set_rules('comprobante', 'Número de documento del comprobante del domicilio', 'required|trim');
      $this->form_validation->set_rules('comprobante_institucion', 'Dato / Institución del comprobante del domicilio', 'required|trim');
      $this->form_validation->set_rules('ine', 'Número de documento de la Credencial de elector', 'required|trim');
      $this->form_validation->set_rules('ine_institucion', 'Dato / Institución de la Credencial de elector', 'required|trim');
      $this->form_validation->set_rules('curp', 'Número de documento del CURP', 'required|trim');
      $this->form_validation->set_rules('curp_institucion', 'Dato / Institución del CURP', 'required|trim');
      $this->form_validation->set_rules('rfc', 'Número de documento del RFC', 'required|trim');
      $this->form_validation->set_rules('rfc_institucion', 'Dato / Institución del RFC', 'required|trim');
      $this->form_validation->set_rules('licencia', 'Número de documento de la Licencia para conducir', 'required|trim');
      $this->form_validation->set_rules('licencia_institucion', 'Dato / Institución de la Licencia para conducir', 'required|trim');
      $this->form_validation->set_rules('cartas', 'Número de documento de las Cartas de recomendación', 'required|trim');
      $this->form_validation->set_rules('cartas_institucion', 'Dato / Institución de las Cartas de recomendación', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_verificacion_docs == 80){
      $this->form_validation->set_rules('ine', 'ID o clave', 'required|trim');
      $this->form_validation->set_rules('ine_ano', 'Año de registro', 'required|trim|numeric|max_length[4]');
      $this->form_validation->set_rules('ine_vertical', 'Número vertical', 'required|trim');
      $this->form_validation->set_rules('ine_institucion', 'Fecha / Institución', 'required|trim');
      $this->form_validation->set_rules('licencia', 'Número de documento', 'required|trim');
      $this->form_validation->set_rules('licencia_institucion', 'Fecha / Institución', 'required|trim');
      $this->form_validation->set_rules('penales', 'Número de documento', 'required|trim');
      $this->form_validation->set_rules('penales_institucion', 'Fecha / Institución', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_verificacion_docs == 58){
      $this->form_validation->set_rules('ine', 'ID o clave', 'required|trim');
      $this->form_validation->set_rules('ine_institucion', 'Fecha / Institución', 'required|trim');
      $this->form_validation->set_rules('penales', 'Número de documento', 'required|trim');
      $this->form_validation->set_rules('penales_institucion', 'Fecha / Institución', 'required|trim');
      $this->form_validation->set_rules('migracion', 'Número de documento', 'required|trim');
      $this->form_validation->set_rules('migracion_institucion', 'Fecha / Institución', 'required|trim');
      $this->form_validation->set_rules('pasaporte', 'Número de documento', 'required|trim');
      $this->form_validation->set_rules('pasaporte_institucion', 'Fecha / Institución', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_verificacion_docs == 48){
      $this->form_validation->set_rules('ine', 'ID o clave', 'required|trim');
      $this->form_validation->set_rules('ine_ano', 'Año de registro', 'required|trim|numeric|max_length[4]');
      $this->form_validation->set_rules('ine_institucion', 'Fecha / Institución', 'required|trim');
      $this->form_validation->set_rules('licencia', 'Número de documento', 'required|trim');
      $this->form_validation->set_rules('licencia_institucion', 'Fecha / Institución', 'required|trim');
      $this->form_validation->set_rules('penales', 'Número de documento', 'required|trim');
      $this->form_validation->set_rules('penales_institucion', 'Fecha / Institución', 'required|trim');
      $this->form_validation->set_rules('migracion', 'Número de documento', 'required|trim');
      $this->form_validation->set_rules('migracion_institucion', 'Fecha / Institución', 'required|trim');
      $this->form_validation->set_rules('pasaporte', 'Número de documento', 'required|trim');
      $this->form_validation->set_rules('pasaporte_institucion', 'Fecha / Institución', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_verificacion_docs == 87){
      $this->form_validation->set_rules('penales', 'Número de documento', 'required|trim');
      $this->form_validation->set_rules('penales_institucion', 'Fecha / Institución', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
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
      $id_candidato = $this->input->post('id_candidato');
      $id_usuario = $this->session->userdata('id');
      
      $hayId = $this->candidato_documentacion_model->check($id_candidato);
      if($hayId > 0){
        $documentacion = array(
          'creacion' => $date,
          'edicion' => $date,
          'id_candidato' => $id_candidato,
          'id_usuario' => $id_usuario,
          'imss' => $this->input->post('imss'),
          'imss_institucion' => $this->input->post('imss_institucion'),
          'domicilio' => $this->input->post('comprobante'),
          'fecha_domicilio' => $this->input->post('comprobante_institucion'),
          'ine' => $this->input->post('ine'),
          'ine_ano' => $this->input->post('ine_ano'),
          'ine_vertical' => $this->input->post('ine_vertical'),
          'ine_institucion' => $this->input->post('ine_institucion'),
          'curp' => $this->input->post('curp'),
          'curp_institucion' => $this->input->post('curp_institucion'),
          'rfc' => $this->input->post('rfc'),
          'rfc_institucion' => $this->input->post('rfc_institucion'),
          'licencia' => $this->input->post('licencia'),
          'licencia_institucion' => $this->input->post('licencia_institucion'),
          'penales' => $this->input->post('penales'),
          'penales_institucion' => $this->input->post('penales_institucion'),
          'carta_recomendacion' => $this->input->post('cartas'),
          'carta_recomendacion_institucion' => $this->input->post('cartas_institucion'),
          'comentarios' => $this->input->post('comentarios'),
          'pasaporte' => $this->input->post('pasaporte'),
          'pasaporte_fecha' => $this->input->post('pasaporte_institucion'),
          'forma_migratoria' => $this->input->post('migracion'),
          'forma_migratoria_fecha' => $this->input->post('migracion_institucion'),
        );
        $this->candidato_documentacion_model->edit($documentacion, $id_candidato);
      }
      else{
        $documentacion = array(
          'creacion' => $date,
          'edicion' => $date,
          'id_candidato' => $id_candidato,
          'id_usuario' => $id_usuario,
          'imss' => $this->input->post('imss'),
          'imss_institucion' => $this->input->post('imss_institucion'),
          'domicilio' => $this->input->post('comprobante'),
          'fecha_domicilio' => $this->input->post('comprobante_institucion'),
          'ine' => $this->input->post('ine'),
          'ine_ano' => $this->input->post('ine_ano'),
          'ine_vertical' => $this->input->post('ine_vertical'),
          'ine_institucion' => $this->input->post('ine_institucion'),
          'curp' => $this->input->post('curp'),
          'curp_institucion' => $this->input->post('curp_institucion'),
          'rfc' => $this->input->post('rfc'),
          'rfc_institucion' => $this->input->post('rfc_institucion'),
          'licencia' => $this->input->post('licencia'),
          'licencia_institucion' => $this->input->post('licencia_institucion'),
          'penales' => $this->input->post('penales'),
          'penales_institucion' => $this->input->post('penales_institucion'),
          'carta_recomendacion' => $this->input->post('cartas'),
          'carta_recomendacion_institucion' => $this->input->post('cartas_institucion'),
          'comentarios' => $this->input->post('comentarios'),
          'pasaporte' => $this->input->post('pasaporte'),
          'pasaporte_fecha' => $this->input->post('pasaporte_institucion'),
          'forma_migratoria' => $this->input->post('migracion'),
          'forma_migratoria_fecha' => $this->input->post('migracion_institucion'),
        );
        $this->candidato_documentacion_model->add($documentacion);
      }
      $msj = array(
        'codigo' => 1,
        'msg' => 'success'
      );
    } 
    echo json_encode($msj);
  }
  function getDocumentosExtraRequeridos(){
    $data['docs_extra'] = $this->candidato_documentacion_model->getDocumentosExtraRequeridos($this->input->post('id'));
    if($data['docs_extra']){
      echo json_encode($data['docs_extra']);
    }
    else{
      echo $res = 0;
    }
  }
}