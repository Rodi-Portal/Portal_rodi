<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laboratorio_model extends CI_Model{
  function getExamenesGrupoSanguineoTotal(){
    $this->db
    ->select("L.*, CONCAT(P.nombre,' ',P.paterno,' ',P.materno) as paciente, P.edad, P.genero")
    ->from("laboratorio as L")
    ->join("paciente as P","L.id_paciente = P.id")
    ->where('L.tipo_examen', 'Grupo sanguineo')
    ->where("L.status", 1)
    ->where("L.eliminado", 0);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getExamenesGrupoSanguineo(){
    $this->db
    ->select("L.*, CONCAT(P.nombre,' ',P.paterno,' ',P.materno) as paciente, P.edad, P.genero, P.nombre, P.paterno, P.materno, P.fecha_nacimiento")
    ->from("laboratorio as L")
    ->join("paciente as P","L.id_paciente = P.id")
    ->where('L.tipo_examen', 'Grupo sanguineo')
    ->where("L.status", 1)
    ->where("L.eliminado", 0)
    ->order_by('L.id','DESC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function guardarPaciente($paciente){
    $this->db->insert('paciente', $paciente);

    $id = $this->db->insert_id();
    return  $id;
  }
  function guardarAnalisis($analisis){
    $this->db->insert('laboratorio', $analisis);
  }
  function editarPaciente($paciente, $id_paciente){
    $this->db 
    ->where('id', $id_paciente)
    ->update('paciente', $paciente);
  }
  function editarAnalisis($analisis, $id_analisis){
    $this->db 
    ->where('id', $id_analisis)
    ->update('laboratorio', $analisis);
  }
  function getDatosExamen($id_analisis){
    $this->db
    ->select("L.*, CONCAT(P.nombre,' ',P.paterno,' ',P.materno) as paciente, P.edad, P.genero")
    ->from("laboratorio as L")
    ->join("paciente as P","L.id_paciente = P.id")
    ->where('L.id', $id_analisis);

    $query = $this->db->get();
    return $query->row();
  }
}