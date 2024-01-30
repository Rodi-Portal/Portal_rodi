<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_model extends CI_Model{

  function getArea($nombre){
    $this->db 
    ->select("A.*, CONCAT(U.nombre,' ',U.paterno,' ',U.materno) as responsable")
    ->from('area as A')
    ->join('usuario as U','U.id = A.usuario_responsable')
    ->where('A.nombre', $nombre)
    ->where('A.status', 1);

    $query = $this->db->get();
    return $query->row();
  }
  function getAreaById($id){
    $this->db 
    ->select("A.*, CONCAT(U.nombre,' ',U.paterno,' ',U.materno) as responsable")
    ->from('area as A')
    ->join('usuario as U','U.id = A.usuario_responsable')
    ->where('A.id', $id);

    $query = $this->db->get();
    return $query->row();
  }
}