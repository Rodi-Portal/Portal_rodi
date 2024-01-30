<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_investigacion_model extends CI_Model{

  function getInvestigacionesById($id){
    $this->db 
    ->select('*')
    ->from('candidato_pruebas')
    ->where('id_candidato', $id);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function getById($id_candidato, $tabla_origen){
    $this->db 
    ->select('*')
    ->from($tabla_origen)
    ->where('id_candidato', $id_candidato);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function countByIdCandidato($id_candidato, $tabla_origen){
    $this->db
    ->select('id')
    ->from($tabla_origen)
    ->where('id_candidato', $id_candidato);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function add($data, $tabla_origen){
    $this->db->insert($tabla_origen, $data);
  }
  function edit($edicion, $id_candidato, $tabla_origen){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->update($tabla_origen, $edicion);
  }

}