<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Formulario_model extends CI_Model{

  function __construct(){
		parent::__construct();
    
	}
  function getTableReference($id_seccion){
    $this->db 
    ->select('table_reference')
    ->from('seccion')
    ->where('id', $id_seccion);

    $query = $this->db->get();
    return $query->row();
  }
  function getBySeccion($id_seccion, $tipo_orden){
    $this->db 
    ->select('*')
    ->from('formulario')
    ->where('id_seccion', $id_seccion)
    ->where('status', 1)
    ->order_by($tipo_orden, 'ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getSeccionByAutor($id_seccion, $tipo_orden, $autor = ['candidato']){
    $this->db 
    ->select('*')
    ->from('formulario')
    ->where('id_seccion', $id_seccion)
    ->where('status', 1)
    ->where_in('autor', $autor)
    ->order_by($tipo_orden, 'ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getBySeccionAndAutor($id_seccion, $tipo_orden, $autor){
    $this->db 
    ->select('*')
    ->from('formulario')
    ->where('id_seccion', $id_seccion)
    ->where('autor', $autor)
    ->where('status', 1)
    ->order_by($tipo_orden, 'ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }

}