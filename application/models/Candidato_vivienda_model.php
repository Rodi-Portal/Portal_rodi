<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_vivienda_model extends CI_Model{

  function __construct(){
		parent::__construct();
    
	}

  function getById($id){
    $this->db 
    ->select('H.*,V.nombre as vivienda,Z.nombre as zona,CO.nombre as condiciones')
    ->from('candidato_habitacion as H')
    ->join('tipo_vivienda as V','V.id = H.id_tipo_vivienda','left')
    ->join('tipo_nivel_zona as Z','Z.id = H.id_tipo_nivel_zona','left')
    ->join('tipo_condiciones as CO','CO.id = H.id_tipo_condiciones','left')
    ->where('H.id_candidato', $id);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function countByIdCandidato($id){
    $this->db
    ->select('id')
    ->from('candidato_habitacion')
    ->where('id_candidato', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function check($id){
    $this->db
    ->select('id')
    ->from('candidato_habitacion')
    ->where('id_candidato', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function add($data){
    $this->db->insert('candidato_habitacion', $data);
  }
  function edit($data, $id_candidato){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->update('candidato_habitacion', $data);
  }

}