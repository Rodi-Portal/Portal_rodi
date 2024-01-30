<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cat_subclientes_model extends CI_Model{

  function getTotal(){
    $this->db
    ->select("sub.id")
    ->from('subcliente as sub')
    ->where('sub.eliminado', 0);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getSubclientes(){
    $this->db
    ->select("sub.*, CONCAT(us.nombre,' ',us.paterno) as referente, us.correo as ref_correo, us.nombre as nombreSubcliente, us.paterno as paternoSubcliente, us.id as idUsuarioSubcliente, us.status as statusUsuario, cl.nombre as cliente, COUNT(us.id) as numero_accesos")
    ->from('subcliente as sub')
    ->join('cliente as cl','cl.id = sub.id_cliente')
    ->join('usuario as u','u.id = sub.id_usuario',"left")
    ->join('usuario_subcliente as us','us.id_subcliente = sub.id',"left")
    ->where('sub.eliminado', 0)
    ->where('cl.eliminado', 0)
    ->order_by('sub.creacion','ASC')
    ->group_by('sub.id');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getAccesos($id_subcliente){
    $this->db
    ->select("sub.*,CONCAT(u.nombre,' ',u.paterno) as usuario, CONCAT(usub.nombre,' ',usub.paterno) as usuario_subcliente, usub.correo as correo_usuario, usub.creacion as alta, usub.id as idUsuarioSubcliente, cl.nombre as cliente")
    ->from("subcliente as sub")
    ->join("cliente as cl","cl.id = sub.id_cliente")
    ->join("usuario_subcliente as usub","usub.id_subcliente = sub.id")
    ->join("usuario as u","u.id = usub.id_usuario")
    ->where("sub.id", $id_subcliente)
    ->order_by("usub.id", 'desc');

    $query = $this->db->get();
    if($query->num_rows() > 0){
        return $query->result();
    }else{
        return FALSE;
    }
  }
  function registrar($subcliente){
    $this->db->insert("subcliente", $subcliente);
  }
  function editar($subcliente, $idSubcliente){
    $this->db
    ->where('id', $idSubcliente)
    ->update('subcliente', $subcliente);
  }
  function registrarUsuario($usuario){
    $this->db->insert("usuario_subcliente", $usuario);
  }
  function getOpcionesSubclientes($id_cliente){
    $this->db
    ->select('*')
    ->from('subcliente')
    ->where('id_cliente', $id_cliente)
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
  function editarAcceso($usuario, $idUsuarioSubcliente){
    $this->db
    ->where('id', $idUsuarioSubcliente)
    ->update('usuario_subcliente', $usuario);
  }
  function deleteAcceso($idUsuarioSubcliente){
    $this->db
    ->where('id', $idUsuarioSubcliente)
    ->delete('usuario_subcliente');
  }
  function getUsuariosSubclientePorCandidato($id_candidato){
    $this->db
    ->select("sub.correo, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato")
    ->from('candidato as c')
    ->join("usuario_subcliente as sub","sub.id_subcliente = c.id_subcliente")
    ->where('c.id', $id_candidato);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }

  function getSubclientesByIdCliente($id_cliente){
    $this->db
    ->select("id")
    ->from('subcliente as c')
    ->where('id_cliente', $id_cliente);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
}