<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_seccion_model extends CI_Model{

  function getSecciones($id){
    $this->db 
    ->select('*')
    ->from('candidato_seccion')
    ->where('id_candidato', $id);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function deleteProyectosPrevios($proyecto, $id_cliente){
    $this->db 
    ->set('status',0)
    ->where('proyecto', $proyecto)
    ->where('id_cliente', $id_cliente)
    ->update('proyectos_historial');
  }
  function getProyectoHistorial($proyecto){
    $this->db 
    ->select('*')
    ->from('proyectos_historial')
    ->where('proyecto', $proyecto);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function getProyectoHistorialByIdProyecto($id){
    $this->db 
    ->select('*')
    ->from('proyectos_historial')
    ->where('id', $id);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function getHistorialProyectosByCliente($id_cliente){
    $this->db
    ->select('id, proyecto')
    ->from('proyectos_historial')
    ->where('proyecto !=', NULL)
    ->where('id_cliente', $id_cliente)
    ->where('status', 1)
    ->order_by('proyecto','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function store_secciones_candidato($data){
    $this->db->insert('candidato_seccion', $data);
  }
}