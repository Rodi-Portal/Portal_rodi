<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Gap_model extends CI_Model{

  function getById($id){
    $this->db 
    ->select('*')
    ->from('candidato_gaps')
    ->where('id_candidato', $id);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function store($data){
    $this->db->insert('candidato_gaps', $data);
  }
  function delete($id){
    $this->db
    ->where('id', $id)
    ->delete('candidato_gaps');
  }
}