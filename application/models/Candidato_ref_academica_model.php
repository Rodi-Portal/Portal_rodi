<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_ref_academica_model extends CI_Model{

  function getById($id_candidato){
    $this->db 
    ->select('*')
    ->from('referencia_academica')
    ->where('id_candidato', $id_candidato)
    ->order_by('number','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }

  function countByIdCandidato($id_candidato){
    $this->db
    ->select('id')
    ->from('referencia_academica')
    ->where('id_candidato', $id_candidato);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function add($data){
    $this->db->insert('referencia_academica', $data);
    return $this->db->insert_id();
  }
  function edit($data, $id){
    $this->db
    ->where('id', $id)
    ->update('referencia_academica', $data);
  }

}