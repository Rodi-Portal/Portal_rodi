<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visita_model extends CI_Model{

  function getCandidato($id){
    $this->db
    ->select(" c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, mun.nombre as municipio,v.comentarios as comentarioVisitador, CS.id_vivienda,CS.id_servicio,CS.id_salud,CS.id_finanzas,CS.id_seccion_verificacion_docs,CS.id_ref_vecinal,CS.cantidad_ref_vecinales")
    ->from('visita as v')
    ->join("candidato as c","v.id_candidato = c.id")
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join("subcliente as sub","sub.id = c.id_subcliente","left")
    ->join("municipio as mun","mun.id = c.id_municipio","left")
    ->join("candidato_seccion as CS","CS.id_candidato = c.id")
    ->where_in('c.id', $id);

    $query = $this->db->get();
    return $query->row();
  }
  function get_by_candidato($id){
    $this->db
    ->select(" c.id, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, v.comentarios as comentarioVisitador")
    ->from('visita as v')
    ->join("candidato as c","v.id_candidato = c.id")
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join("subcliente as sub","sub.id = c.id_subcliente","left")
    ->where_in('v.id_candidato', $id);

    $query = $this->db->get();
    return $query->row();
  }
  
}