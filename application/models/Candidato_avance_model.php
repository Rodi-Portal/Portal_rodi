<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_avance_model extends CI_Model{

  function getBySeccion($id_candidato, $seccion){
    $this->db 
    ->select("CA.*")
    ->from('candidato_avance as CA')
    ->where('CA.seccion', $seccion)
    ->where('CA.id_candidato', $id_candidato);

    $query = $this->db->get();
    return $query->row();
  }

  function store($data){
    $this->db->insert('candidato_avance', $data);
  }

  function update($data, $id_candidato, $seccion){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->where('seccion', $seccion)
    ->update('candidato_avance', $data);
  }

  function getAllById($id_candidato){
    $this->db 
    ->select("CA.*")
    ->from('candidato_avance as CA')
    ->where('CA.id_candidato', $id_candidato);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
}