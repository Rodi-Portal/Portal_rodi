<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avance extends CI_Controller{

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
  
  function editar(){
    $id = $this->input->post('id');
    $nombre_archivo = '';
    $avanceDetalle = $this->avance_model->get_detalles($id);
    if(isset($_FILES['archivo']['name'])){
      $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
      $cadena = substr(md5(time()), 0, 16);
      $nombre_archivo = $cadena.".".$extension;
      $config['upload_path'] = './_adjuntos/';  
      $config['allowed_types'] = 'jpg|jpeg|png';
      $config['overwrite'] = TRUE;
      $config['file_name'] = $nombre_archivo;

      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      if($this->upload->do_upload('archivo')){
        if(!empty($avanceDetalle->adjunto)){
          unlink('./_adjuntos/'.$avanceDetalle->adjunto);
        }
      }
    }else{
      if(!empty($avanceDetalle->adjunto)){
        unlink('./_adjuntos/'.$avanceDetalle->adjunto);
      }
    }
    $data = array(
      'comentarios' => $this->input->post('msj'),
      'adjunto' => $nombre_archivo
    );
    $this->avance_model->update_detalle($data, $id);
    $msj = array(
      'codigo' => 1,
      'msg' => 'Mensaje de avance modificado correctamente'
    );
    echo json_encode($msj);
  }
  function eliminar(){
    $id = $this->input->post('id');
    $avanceDetalle = $this->avance_model->get_detalles($id);
    if(!empty($avanceDetalle->adjunto)){
      unlink('./_adjuntos/'.$avanceDetalle->adjunto);
    }
    $this->avance_model->delete_detalle($id);
    $msj = array(
      'codigo' => 1,
      'msg' => 'Mensaje de avance eliminado correctamente'
    );
    echo json_encode($msj);
  } 
  function get(){
    $id_candidato = $this->input->post('id_candidato');
    $idioma = ($this->input->post('espanol') == 1)? 'espanol':'ingles';
    $tituloArchivo = ($this->input->post('espanol') == 1)? 'Ver imagen':'View file';
    $data = array();
    $src = '';
    $mensajes = $this->avance_model->get_detalles_by_candidato($id_candidato);
    if($mensajes){
      foreach($mensajes as $row){
        if(!empty($row->adjunto)){
          $src = base_url()."_adjuntos/".$row->adjunto;
        }
        $fecha = fechaTexto($row->fecha,$idioma);
        $data[] = [
          'fecha' => $fecha,
          'tituloArchivo' => $tituloArchivo,
          'mensaje' => $row->comentarios,
          'archivo' => $src
        ];
        //$salida .= ( != "")? "<a href='".base_url()."_adjuntos/".$row->adjunto."' target='_blank' style='margin-bottom: 10px;text-align:center;'>".$txt_imagen."</a><hr>" : "<hr>";
      }
    }
    echo json_encode($data);
  }
}