<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacion_model extends CI_Model{

  function get_by_usuario($idUsuario, $visto){
    $this->db
    ->select("N.*,CONCAT(dat.nombre,' ',dat.paterno) as usuario")
    ->from("notificacion as N")
    ->join("usuarios_portal as U","U.id = N.usuario_destino")
    ->join("datos_generales as dat","U.id_usuario = N.usuario_destino")
    ->where_in("N.visto", $visto)
    ->where("N.usuario_destino", $idUsuario)
    ->order_by("N.id", 'desc');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function update($data, $id){
    $this->db 
    ->where('id', $id)
    ->update('notificacion', $data);
  }
  function store($data){
    $this->db->insert('notificacion', $data);
  }

}