<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cat_puestos_model extends CI_Model{
  
  function getTotal(){
    $this->db
    ->select("id")
    ->from("puesto")
    ->where("eliminado", 0);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getPuestosActivos(){
    $portal = $this->session->userdata('idPortal');
    $this->db
    
    ->select("P.*,CONCAT(GEN.nombre,' ',GEN.paterno) as usuario")
    ->from("puesto as P")
    ->join('portal as POR','POR.id = P.id_portal')
    ->join("usuarios_portal as U","U.id = P.id_usuario")
    ->join("datos_generales as GEN","U.id_datos_generales = GEN.id")
    ->where("P.eliminado", 0)
    ->where("P.id_portal", $portal)
    ->order_by("P.nombre", 'ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
        return $query->result();
    }else{
        return FALSE;
    }
  }
  function registrar($puesto){
    $this->db->insert("puesto", $puesto);
  }
  function editar($puesto, $idPuesto){
    $this->db
    ->where('id', $idPuesto)
    ->update('puesto', $puesto);
  }   
  function check($puesto){
    $this->db
    ->select("id")
    ->from("puesto")
    ->where("nombre", $puesto)
    ->where('eliminado', 0);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getPositionByName($name){
    $this->db
    ->select('*')
    ->from('puesto')
    ->where('eliminado', 0)
    ->where('nombre', $name);

    $query = $this->db->get();
    return $query->row();
  }
  function addPositionWithIdReturned($puesto){
    $this->db->insert("puesto", $puesto);
    return $this->db->insert_id();
  }
  function getAllPositions(){
    $this->db
    ->select('*')
    ->from('puesto')
    ->where('status', 1)
    ->where('eliminado', 0)
    ->order_by('nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getAll(){
    $this->db
    ->select("*")
    ->from("puesto")
    ->where("status", 1)
    ->where("eliminado", 0)
    ->order_by("nombre", 'ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
}