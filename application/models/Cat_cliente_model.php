<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cat_cliente_model extends CI_Model{

  function getTotal(){
    $this->db
    ->select("c.id")
    ->from('cliente as c')
    ->where('c.ingles', 0)
    ->where('c.eliminado', 0);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function get(){
    $this->db
    ->select("c.*, CONCAT(uc.nombre,' ',uc.paterno) as referente, uc.correo as ref_correo, uc.nombre as nombreCliente, uc.paterno as paternoCliente, uc.id as idUsuarioCliente, uc.status as statusUsuario, COUNT(uc.id) as numero_accesos")
    ->from('cliente as c')
    ->join('usuario as u','u.id = c.id_usuario',"left")
    ->join('usuario_cliente as uc','uc.id_cliente = c.id',"left")
    ->where('c.eliminado', 0)
    ->order_by('c.creacion','ASC')
    ->group_by('c.id');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function existe($nombre, $clave, $id){
    $this->db
    ->select('id')
    ->from('cliente')
    ->or_where('nombre', $nombre)
    ->or_where('clave', $clave)
    ->where_not_in('id',$id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function check($id){
    $this->db
    ->select('id')
    ->from('cliente')
    ->where('id', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }

  function add($cliente){
    $this->db->insert("cliente", $cliente);
    return $this->db->insert_id();
  }
  function addPermiso($permiso){
    $this->db->insert("permiso", $permiso);
  }
  function edit($cliente, $id){
    $this->db
    ->where('id', $id)
    ->update('cliente', $cliente);
  }
  function editPermiso($permiso, $id_cliente){
    $this->db
    ->where('id_cliente', $id_cliente)
    ->update('permiso', $permiso);
  }
  function getById($idCliente){
    $this->db
    ->select('*')
    ->from('cliente')
    ->where('id',$idCliente);

    $query = $this->db->get();
    return $query->row();
  }
  function checkPermisosByCliente($id_cliente){
    $this->db
    ->select("id")
    ->from('permiso')
    ->where('id_cliente', $id_cliente);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getAccesos($id_cliente){
    $this->db
    ->select("c.*,CONCAT(u.nombre,' ',u.paterno) as usuario, CONCAT(uc.nombre,' ',uc.paterno) as usuario_cliente, uc.correo as correo_usuario, uc.creacion as alta, uc.id as idUsuarioCliente, uc.privacidad")
    ->from("cliente as c")
    ->join("usuario_cliente as uc","uc.id_cliente = c.id")
    ->join("usuario as u","u.id = uc.id_usuario")
    ->where("c.id", $id_cliente)
    ->order_by("uc.id", 'desc');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function editAccesoUsuarioCliente($usuario, $idCliente){
    $this->db
    ->where('id_cliente', $idCliente)
    ->update('usuario_cliente', $usuario);
  }
  function editAccesoUsuarioSubcliente($usuario, $idCliente){
    $this->db
    ->where('id_cliente', $idCliente)
    ->update('usuario_subcliente', $usuario);
  }
  function addUsuario($usuario){
    $this->db->insert("usuario_cliente", $usuario);
  }
  function deleteAccesoUsuarioCliente($idUsuarioCliente){
    $this->db
    ->where('id', $idUsuarioCliente)
    ->delete('usuario_cliente');
  }

  
  
  
  function getActivos(){
    $this->db
    ->select("c.*")
    ->from('cliente as c')
    ->where('c.status', 1)
    ->where('c.eliminado', 0)
    ->order_by('c.nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }

  function getUsuariosClientePorCandidato($id_candidato){
    $this->db
    ->select("cl.correo, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.privacidad as privacidadCandidato, cl.privacidad as privacidadCliente")
    ->from('candidato as c')
    ->join("usuario_cliente as cl","cl.id_cliente = c.id_cliente")
    ->where('c.id', $id_candidato);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function addHistorialBloqueos($data){
    $this->db->insert("bloqueo_historial", $data);
  }
  function editHistorialBloqueos($dataBloqueos, $idCliente){
    $this->db
    ->where('id_cliente', $idCliente)
    ->update('bloqueo_historial', $dataBloqueos);
  }
  function getBloqueoHistorial($id_cliente){
    $this->db
    ->select("*")
    ->from('bloqueo_historial')
    ->where('status', 1)
    ->where('id_cliente', $id_cliente);

    $consulta = $this->db->get();
    return $consulta->row();
  }
}