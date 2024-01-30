<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_documentacion_model extends CI_Model{

  function __construct(){
		parent::__construct();
    
	}

  function getById($id){
    $this->db 
    ->select('*')
    ->from('verificacion_documento')
    ->where('id_candidato', $id);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function check($id){
    $this->db
    ->select('id')
    ->from('verificacion_documento')
    ->where('id_candidato', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function add($data){
    $this->db->insert('verificacion_documento', $data);
  }
  function edit($data, $id_candidato){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->update('verificacion_documento', $data);
  }
  function getDocumentosExtraRequeridos($id){
    $this->db
    ->select('*')
    ->from('candidato_documento_requerido')
    ->where('id_candidato', $id);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }

}