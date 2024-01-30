<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_control_model extends CI_Model{

  function getById($id_cliente){
    $this->db 
    ->select("CC.*")
    ->from('cliente_control as CC')
    ->where('CC.id_cliente', $id_cliente);

    $query = $this->db->get();
    return $query->row();
  }

  function get_by_cliente_proyecto($id_cliente, $id_proyecto){
    $this->db 
    ->select('*')
    ->from('cliente_control')
    ->where('acceso_proceso', $id_proyecto)
    ->where('id_cliente', $id_cliente);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  
}