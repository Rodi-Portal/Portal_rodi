<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Covid_model extends CI_Model{
  /*----------------------------------------*/
  /*  CRUD de pruebas
  /*----------------------------------------*/
  function getPruebas(){
    $this->db
    ->select(" c.*, c.nombre as paciente, CONCAT(u.nombre,' ',u.paterno) as usuario")
    ->from('covid as c')
    ->join('usuario as u','u.id = c.id_usuario');
    $query = $this->db->get();
    if($query->num_rows() > 0){
        return $query->result();
    }else{
        return FALSE;
    }
  }
  function getTotalPruebas(){
    $this->db
    ->select("c.id")
    ->from('covid as c')
    ->join('usuario as u','u.id = c.id_usuario');
    $query = $this->db->get();
    return $query->num_rows();
  }
  function registrar($registro){
    $this->db->insert('covid', $registro);
  }
  function actualizar($registro, $id_prueba){
    $this->db
    ->where('id', $id_prueba)
    ->update('covid', $registro);
  }
  function getDatosPrueba($id_prueba){
    $this->db
    ->select("c.*, CONCAT(US.nombre,' ',US.paterno,' ',US.materno) as responsable,A.profesion_responsable, A.firma, A.cedula")
    ->from('covid as c')
    ->join('usuario as u','u.id = c.id_usuario')
    ->join('area as A','A.id = c.id_area')
    ->join('usuario as US','US.id = A.usuario_responsable')
    ->where('c.id', $id_prueba);
    $consulta = $this->db->get();
    return $consulta->row();
  }
  function getConfiguracion(){
    $this->db
    ->select("c.*")
    ->from('configuracion as c');
    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  /*----------------------------------------*/
  /*  Numero de Orden
  /*----------------------------------------*/
  function getUltimaOrden($dia_actual){
    $this->db
    ->select("c.orden")
    ->from('covid as c')
    ->where('c.dia_orden', $dia_actual)
    ->where('c.tipo_prueba', "Nasofaringea")
    ->order_by('c.id','DESC')
    ->limit(1);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getUltimoSanguineo(){
    $this->db
    ->select("c.orden")
    ->from('covid as c')
    ->where('c.tipo_prueba', "Sanguinea")
    ->order_by('c.id','DESC')
    ->limit(1);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getUltimoPCR(){
    $this->db
    ->select("c.id")
    ->from('covid as c')
    ->where('c.tipo_prueba', "PCR");

    $query = $this->db->get();
    return $query->num_rows();
  }
}