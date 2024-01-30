<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_finanzas_model extends CI_Model{

  function __construct(){
		parent::__construct();
    
	}

  function getById($id){
    $this->db 
    ->select('E.*, C.muebles, C.adeudo_muebles, C.comentario, C.ingresos, C.ingresos_extra')
    ->from('candidato_egresos as E')
    ->join('candidato as C','C.id = E.id_candidato')
    ->where('E.id_candidato', $id);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function countByIdCandidato($id){
    $this->db
    ->select('id')
    ->from('candidato_egresos')
    ->where('id_candidato', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function check($id){
    $this->db
    ->select('id')
    ->from('candidato_egresos')
    ->where('id_candidato', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function add($data){
    $this->db->insert('candidato_egresos', $data);
  }
  function edit($data, $id_candidato){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->update('candidato_egresos', $data);
  }

}