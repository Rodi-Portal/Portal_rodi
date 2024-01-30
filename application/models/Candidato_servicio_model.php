<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_servicio_model extends CI_Model{

  function __construct(){
		parent::__construct();
    
	}

  function getById($id){
    $this->db 
    ->select('*')
    ->from('candidato_servicio')
    ->where('id_candidato', $id);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function countByIdCandidato($id_candidato){
    $this->db
    ->select('id')
    ->from('candidato_servicio')
    ->where('id_candidato', $id_candidato);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function check($id){
    $this->db
    ->select('id')
    ->from('candidato_servicio')
    ->where('id_candidato', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function add($data){
    $this->db->insert('candidato_servicio', $data);
  }
  function edit($data, $id_candidato){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->update('candidato_servicio', $data);
  }

}