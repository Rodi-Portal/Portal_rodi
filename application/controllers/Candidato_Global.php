<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_Global extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

  function getById(){
    $res = $this->candidato_global_model->getById($this->input->post('id'));
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
    if($seccion->id_seccion_global_search == 4){
      $this->form_validation->set_rules('sanctions', 'Global compliance & Sanctions database', 'required|trim');
      $this->form_validation->set_rules('media_searches', 'Global media searches', 'required|trim');
      $this->form_validation->set_rules('oig', 'Office of the Inspector General', 'required|trim');
      $this->form_validation->set_rules('interpol', 'Interpol check', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_global_search == 5){
      $this->form_validation->set_rules('sanctions', 'Global compliance & Sanctions database', 'required|trim');
      $this->form_validation->set_rules('oig', 'Office of the Inspector General', 'required|trim');
      $this->form_validation->set_rules('facis', 'FACIS Sanction Search', 'required|trim');
      $this->form_validation->set_rules('bureau', 'Bureau of Industry and Security List of Denied Persons', 'required|trim');
      $this->form_validation->set_rules('european_financial', 'EU Freeze List Maintained by the European Union (financial sanctions)', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_global_search == 6){
      $this->form_validation->set_rules('oig', 'Office of the Inspector General', 'required|trim');
      $this->form_validation->set_rules('sam', 'SAM', 'required|trim');
      $this->form_validation->set_rules('ofac', 'OFAC', 'required|trim');
      $this->form_validation->set_rules('interpol', 'Interpol check', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_global_search == 7){
      $this->form_validation->set_rules('law_enforcement', 'Law enforcement', 'required|trim');
      $this->form_validation->set_rules('regulatory', 'Regulatory', 'required|trim');
      $this->form_validation->set_rules('sanctions', 'Sanctions', 'required|trim');
      $this->form_validation->set_rules('other_bodies', 'Other bodies', 'required|trim');
      $this->form_validation->set_rules('media_searches', 'Global media searches', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_global_search == 8){
      $this->form_validation->set_rules('usa_sanctions', 'USA sanctions', 'required|trim');
      $this->form_validation->set_rules('sanctions', 'Sanctions', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_global_search == 9){
      $this->form_validation->set_rules('ofac', 'OFAC', 'required|trim');
      $this->form_validation->set_rules('sam', 'SAM', 'required|trim');
      $this->form_validation->set_rules('fda', 'FDA department search', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_global_search == 21){
      $this->form_validation->set_rules('law_enforcement', 'Law enforcement', 'required|trim');
      $this->form_validation->set_rules('regulatory', 'Regulatory', 'required|trim');
      $this->form_validation->set_rules('sanctions', 'Sanctions', 'required|trim');
      $this->form_validation->set_rules('other_bodies', 'Other bodies', 'required|trim');
      $this->form_validation->set_rules('media_searches', 'Global media searches', 'required|trim');
      $this->form_validation->set_rules('sdn', 'SDN', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_global_search == 45){
      $this->form_validation->set_rules('law_enforcement', 'Law enforcement', 'required|trim');
      $this->form_validation->set_rules('regulatory', 'Regulatory', 'required|trim');
      $this->form_validation->set_rules('sanctions', 'Sanctions', 'required|trim');
      $this->form_validation->set_rules('other_bodies', 'Other bodies', 'required|trim');
      $this->form_validation->set_rules('media_searches', 'Global media searches', 'required|trim');
      $this->form_validation->set_rules('oig', 'Office of the Inspector General', 'required|trim');
      $this->form_validation->set_rules('ofac', 'OFAC', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_global_search == 65){
      $this->form_validation->set_rules('ofac', 'OFAC', 'required|trim');
      $this->form_validation->set_rules('sam', 'SAM', 'required|trim');
      $this->form_validation->set_rules('fda', 'FDA department search', 'required|trim');
      $this->form_validation->set_rules('oig', 'Office of the Inspector General', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_global_search == 66){
      $this->form_validation->set_rules('law_enforcement', 'Law enforcement', 'required|trim');
      $this->form_validation->set_rules('regulatory', 'Regulatory', 'required|trim');
      $this->form_validation->set_rules('ofac', 'OFAC', 'required|trim');
      $this->form_validation->set_rules('sam', 'SAM', 'required|trim');
      $this->form_validation->set_rules('oig', 'Office of the Inspector General', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_global_search == 67){
      $this->form_validation->set_rules('media_searches', 'Global media searches', 'required|trim');
      $this->form_validation->set_rules('sanctions', 'Sanctions', 'required|trim');
      $this->form_validation->set_rules('ofac', 'OFAC', 'required|trim');
      $this->form_validation->set_rules('sam', 'SAM', 'required|trim');
      $this->form_validation->set_rules('fda', 'FDA department search', 'required|trim');
      $this->form_validation->set_rules('oig', 'Office of the Inspector General', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_global_search == 86){
      $this->form_validation->set_rules('media_searches', 'Global media searches', 'required|trim');
      $this->form_validation->set_rules('sanctions', 'Sanctions', 'required|trim');
      $this->form_validation->set_rules('oig', 'Office of the Inspector General', 'required|trim');
      $this->form_validation->set_rules('sam', 'SAM', 'required|trim');
      $this->form_validation->set_rules('ofac', 'OFAC', 'required|trim');
      $this->form_validation->set_rules('interpol', 'Interpol check', 'required|trim');
      $this->form_validation->set_rules('mvr', 'MVR (Motor Vehicle Records)', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    if($seccion->id_seccion_global_search == 102){
      $this->form_validation->set_rules('law_enforcement', 'Law enforcement', 'required|trim');
      $this->form_validation->set_rules('regulatory', 'Regulatory', 'required|trim');
      $this->form_validation->set_rules('sanctions', 'Sanctions', 'required|trim');
      $this->form_validation->set_rules('other_bodies', 'Other bodies', 'required|trim');
      $this->form_validation->set_rules('media_searches', 'Global media searches', 'required|trim');
      $this->form_validation->set_rules('mvr', 'MVR (Motor Vehicle Records)', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios', 'required|trim');
    }
    
    $this->form_validation->set_message('required','El campo {field} es obligatorio');

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

      $hayId = $this->candidato_global_model->check($id_candidato);
      if($hayId > 0){
        $candidato = array(
          'id_usuario' => $id_usuario
        );
        $this->candidato_model->editarCandidato($candidato, $id_candidato);
        $global = array(
          'id_usuario' => $id_usuario,
          'sanctions' => $this->input->post('sanctions'),
          'media_searches' => $this->input->post('media_searches'),
          'oig' => $this->input->post('oig'),
          'interpol' => $this->input->post('interpol'),
          'facis' => $this->input->post('facis'),
          'bureau' => $this->input->post('bureau'),
          'european_financial' => $this->input->post('european_financial'),
          'sam' => $this->input->post('sam'),
          'ofac' => $this->input->post('ofac'),
          'regulatory' => $this->input->post('regulatory'),
          'law_enforcement' => $this->input->post('law_enforcement'),
          'other_bodies' => $this->input->post('other_bodies'),
          'usa_sanctions' => $this->input->post('usa_sanctions'),
          'fda' => $this->input->post('fda'),
          'sdn' => $this->input->post('sdn'),
          'motor_vehicle_records' => $this->input->post('mvr'),
          'global_comentarios' => $this->input->post('comentarios')
        );
        $this->candidato_global_model->edit($global, $id_candidato);
      }
      else{
        $candidato = array(
          'id_usuario' => $id_usuario
        );
        $this->candidato_model->editarCandidato($candidato, $id_candidato);
        $global = array(
          'creacion' => $date,
          'id_usuario' => $id_usuario,
          'id_candidato' => $id_candidato,
          'sanctions' => $this->input->post('sanctions'),
          'media_searches' => $this->input->post('media_searches'),
          'oig' => $this->input->post('oig'),
          'interpol' => $this->input->post('interpol'),
          'facis' => $this->input->post('facis'),
          'bureau' => $this->input->post('bureau'),
          'european_financial' => $this->input->post('european_financial'),
          'sam' => $this->input->post('sam'),
          'ofac' => $this->input->post('ofac'),
          'regulatory' => $this->input->post('regulatory'),
          'law_enforcement' => $this->input->post('law_enforcement'),
          'other_bodies' => $this->input->post('other_bodies'),
          'usa_sanctions' => $this->input->post('usa_sanctions'),
          'fda' => $this->input->post('fda'),
          'sdn' => $this->input->post('sdn'),
          'motor_vehicle_records' => $this->input->post('mvr'),
          'global_comentarios' => $this->input->post('comentarios')
        );
        $this->candidato_global_model->add($global);
      }
      $msj = array(
        'codigo' => 1,
        'msg' => 'success'
      );
    }
    echo json_encode($msj);
  }

}