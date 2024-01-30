<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadistica_model extends CI_Model{

  /*----------------------------------------*/
	/* Estadisticas para altos cargos
	/*----------------------------------------*/ 
    function countESEFinalizados(){
      $this->db
      ->select("COUNT(c.id) as total")
      ->from('candidato as c')
      ->where('c.status', 2)
      ->where('c.eliminado', 0);

      $consulta = $this->db->get();
      $resultado = $consulta->row();
      return $resultado;
    }
    function countDopingFinalizados(){
      $this->db
      ->select("COUNT(dop.id) as total")
      ->from('doping as dop')
      ->where('dop.resultado !=', -1)
      ->where('dop.fecha_resultado !=', NULL);

      $consulta = $this->db->get();
      $resultado = $consulta->row();
      return $resultado;
    }
    function countCovidFinalizados(){
      $this->db
      ->select("COUNT(c.id) as total")
      ->from('covid as c')
      ->where('c.status', 1)
      ->where('c.resultado !=', NULL);

      $consulta = $this->db->get();
      $resultado = $consulta->row();
      return $resultado;
    }
    function countMedicoFinalizados(){
      $this->db
      ->select("COUNT(m.id) as total")
      ->from('medico as m')
      ->where('m.conclusion !=', NULL);

      $consulta = $this->db->get();
      $resultado = $consulta->row();
      return $resultado;
    }
    function getCandidatosFinalizadosporMeses($year, $month){
      $this->db
      ->select("c.creacion")
      ->from('candidato as c')
      ->where('c.status', 2)
      ->where('c.id_tipo_proceso !=', 2)
      ->where('c.cancelado', 0)
      ->where('c.eliminado', 0)
      ->where('YEAR(c.edicion)', $year)
      ->where('MONTH(c.edicion)', $month);

      $query = $this->db->get();
      return $query->num_rows();
    }
    function getHistorialCandidatos(){
      $this->db
      ->select("c.fecha_alta, c.tiempo_proceso")
      ->from('candidato_historial as c');

      $query = $this->db->get();
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return FALSE;
      }
    }
  /*----------------------------------------*/
	/* Estadisticas para analistas
	/*----------------------------------------*/
  function getCandidatosFinalizadosEspanol($year, $month, $id_usuario){
    $this->db
    ->select("C.id")
    ->from('candidato as C')
    ->join('candidato_finalizado as F','F.id_candidato = C.id')
    ->where('C.status', 2)
    ->where('C.id_tipo_proceso !=', 2)
    ->where('C.cancelado', 0)
    ->where('C.eliminado', 0)
    ->where('C.id_usuario', $id_usuario)
    ->where('YEAR(F.creacion)', $year)
    ->where('MONTH(F.creacion)', $month);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getCandidatosFinalizadosIngles($year, $month, $id_usuario){
    $this->db
    ->select("C.id")
    ->from('candidato as C')
    ->join('candidato_bgc as F','F.id_candidato = C.id')
    ->where('C.status', 2)
    ->where('C.id_tipo_proceso !=', 2)
    ->where('C.cancelado', 0)
    ->where('C.eliminado', 0)
    ->where('C.id_usuario', $id_usuario)
    ->where('YEAR(F.creacion)', $year)
    ->where('MONTH(F.creacion)', $month);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getHistorialCandidatosPorAnalista($id_usuario){
    $this->db
    ->select("c.fecha_alta, c.tiempo_proceso")
    ->from('candidato_historial as c')
    ->where('id_usuario',$id_usuario);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getCantidadEstatusCandidatos($id_usuario, $estatus){
    $this->db
    ->select("C.id")
    ->from('candidato as C')
    ->where('C.id_tipo_proceso !=', 2)
    ->where('C.cancelado', 0)
    ->where('C.eliminado', 0)
    ->where('C.id_usuario', $id_usuario)
    ->where('C.status_bgc', $estatus);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getCantidadEstatusCandidatosHistorial($id_usuario, $estatus){
    $this->db
    ->select("c.fecha_alta, c.tiempo_proceso")
    ->from('candidato_historial as c')
    ->where('id_usuario', $id_usuario)
    ->where('status_bgc', $estatus);

    $query = $this->db->get();
    return $query->num_rows();
  }

  function countCandidatos(){
    $this->db
    ->select("COUNT(bgc.id) as total")
    ->from('candidato as c')
    ->join('candidato_bgc as bgc','bgc.id_candidato = c.id')
    ->where('c.cancelado', 0)
    ->where('c.eliminado', 0);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function countCandidatosCancelados(){
    $this->db
    ->select("COUNT(c.id) as total")
    ->from('candidato as c')
    ->where('c.cancelado', 1)
    ->where('c.eliminado', 0);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function countCandidatosEliminados(){
    $this->db
    ->select("COUNT(c.id) as total")
    ->from('candidato as c')
    ->where('c.eliminado', 1);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function countCandidatosAnalista($id_candidato){
    $this->db
    ->select("COUNT(bgc.id) as total")
    ->from('candidato as c')
    ->join('candidato_bgc as bgc','bgc.id_candidato = c.id')
    ->where('c.id_usuario', $id_candidato)
    ->where('c.cancelado', 0)
    ->where('c.eliminado', 0);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function countCandidatosSinFormulario($id_usuario){
    $this->db
    ->select("COUNT(c.id) as total")
    ->from('candidato as c')
    //->where('c.id_usuario', $id_usuario)
    ->where('c.id_cliente', 1)
    ->where('c.fecha_contestado', NULL)
    ->where('c.cancelado', 0)
    ->where('c.eliminado', 0);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function countCandidatosSinDocumentos($id_usuario){
    $this->db
    ->select("COUNT(c.id) as total")
    ->from('candidato as c')
    //->where('c.id_usuario', $id_usuario)
    ->where('c.id_cliente', 1)
    ->where('c.fecha_documentos', NULL)
    ->where('c.cancelado', 0)
    ->where('c.eliminado', 0);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
}