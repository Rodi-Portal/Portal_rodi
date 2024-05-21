<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadistica_model extends CI_Model{

  /*----------------------------------------*/
	/* Estadisticas para altos cargos
	/*----------------------------------------*/ 
      function countReqEnProceso(){
         $id_portal = $this->session->userdata('idPortal');
        $this->db
        ->select("COUNT(R.id) as total")
        ->from('requisicion as R')
        ->where('R.id_portal', $id_portal)
        ->where('R.status', 2)
        ->where('R.comentario_final IS NULL') // Corrección aquí
        ->where('R.eliminado', 0);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }

    

    function countReqFinalizadas(){
      $id_portal = $this->session->userdata('idPortal');
      $this->db
      ->select("COUNT(R.id) as total")
      ->from('requisicion as R')
      ->where('R.status', 3)
      ->where('R.comentario_final IS NOT NULL') // Corrección aquí
      ->where('R.eliminado', 0)
      ->where('R.id_portal ', $id_portal);
    
      $consulta = $this->db->get();
      $resultado = $consulta->row();
      return $resultado;
    }

    function countReqCanceladas(){
      $id_portal = $this->session->userdata('idPortal');

      $this->db
      ->select("COUNT(R.id) as total")
      ->from('requisicion as R')
      ->where('R.status', 0)
      ->where('R.id_portal ', $id_portal)
      ->where('R.comentario_final IS NOT NULL') // Corrección aquí
      ->where('R.eliminado', 0);
    
      $consulta = $this->db->get();
      $resultado = $consulta->row();
      return $resultado;
    }

    function countBolsaTrabajo(){
      $id_portal = $this->session->userdata('idPortal');
      $this->db
      ->select("COUNT(B.id) as total")
      ->from('bolsa_trabajo as B')
      ->where('B.status !=', 0)
      ->where('B.id_portal ', $id_portal);
  // Corrección aquí
     
    
      $consulta = $this->db->get();
      $resultado = $consulta->row();
      return $resultado;
    }

    /*
    
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
    
    */

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

    function getRequisicionesFinalizadasPorMeses($year, $month){
      $id_portal = $this->session->userdata('idPortal');
      $this->db
      ->select("R.creacion")
      ->from('requisicion as R')
      ->where('R.status', 3)
      ->where('R.comentario_final IS NOT NULL') 
      ->where('R.eliminado', 0)
      ->where('R.id_portal', $id_portal)
      ->where('YEAR(R.edicion)', $year)
      ->where('MONTH(R.edicion)', $month);

      $query = $this->db->get();
      return $query->num_rows();
    }


    
    function getRequisicionesProcesoPorMes($year, $month){
      $id_portal = $this->session->userdata('idPortal');
      $this->db
      ->select("R.creacion")
      ->from('requisicion as R')
      ->where('R.status', 2)
      ->where('R.comentario_final IS  NULL') 
      ->where('R.eliminado', 0)
      ->where('R.id_portal', $id_portal)
      ->where('YEAR(R.edicion)', $year)
      ->where('MONTH(R.edicion)', $month);

      $query = $this->db->get();
      return $query->num_rows();
    }

    function getAspirantesProcesoPorMes($year, $month){
      $id_portal = $this->session->userdata('idPortal');
      $this->db
      ->select("B.creacion")
      ->from('requisicion_aspirante  as B')
      ->join('requisicion as R','R.id = B.id_requisicion')
      ->where('B.eliminado', 0)
      ->where('R.id_portal', $id_portal)
      ->where('B.status_final IS  NULL') 
      ->where('YEAR(B.edicion)', $year)
      ->where('MONTH(B.edicion)', $month);

      $query = $this->db->get();
      return $query->num_rows();
    }

    function getRequisicionesCanceladasPorMeses($year, $month){
      $id_portal = $this->session->userdata('idPortal');

      $this->db
      ->select("R.creacion")
      ->from('requisicion as R')
      ->where('R.status', 0)
      ->where('R.id_portal', $id_portal)
      ->where('R.comentario_final IS NOT NULL') 
      ->where('R.eliminado', 0)
      ->where('YEAR(R.edicion)', $year)
      ->where('MONTH(R.edicion)', $month);

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
	/* Estadisticas para Reclutadores
	/*----------------------------------------*/
  public function obtenerReclutadores() {
    // Consulta para obtener los reclutadores
    $id_portal = $this->session->userdata('idPortal');
    $this->db->select('UP.id, DGR.nombre, DGR.paterno')
    ->from('usuarios_portal as UP')
    ->join('datos_generales as DGR', 'UP.id_datos_generales = DGR.id')
    ->where_in('UP.id_rol', [4,11])
    ->where('UP.id_portal', $id_portal);
    $query = $this->db->get();

    return $query->result();
}

public function obtenerRequisicionesPorUsuario($fechaInicio, $fechaFin, $id_usuario) {
  $id_portal = $this->session->userdata('idPortal');

  // Contar las filas para el usuario especificado dentro del rango de fechas
  $this->db->select('COUNT(RU.id_requisicion) as total_requisiciones')
           ->from('requisicion_usuario as RU')
           ->join('requisicion as R', 'R.id = RU.id_requisicion')
           ->where('R.id_portal', $id_portal)
           ->where('RU.id_usuario', $id_usuario)
           ->where('RU.creacion >=', $fechaInicio)
           ->where('R.edicion <=', $fechaFin);
  $query = $this->db->get();
  // Retornar el resultado como un objeto
  $resultado = $query->row();
  return $resultado->total_requisiciones;
}

public function obtenerRequisicionesCanceladasPorUsuario($fechaInicio, $fechaFin, $id_usuario) {
 $id_portal = $this->session->userdata('idPortal');

  // Contar las filas para el usuario especificado dentro del rango de fechas
  $this->db->select('COUNT(id) as total_canceladas')
           ->from('requisicion')
           ->where('id_usuario', $id_usuario)
           ->where('comentario_final IS NOT NULL')
           ->where('id_portal', $id_portal)
           ->where('status', 0)
           ->where('creacion >=', $fechaInicio)
           ->where('edicion <=', $fechaFin);
  $query = $this->db->get();
  // Retornar el resultado como un objeto
  $resultado = $query->row();
  return $resultado->total_canceladas;
}

public function obtenerRequisicionesFinalizadasPorUsuario($fechaInicio, $fechaFin, $id_usuario) {
  $id_portal = $this->session->userdata('idPortal');

  // Contar las filas para el usuario especificado dentro del rango de fechas
  $this->db->select('COUNT(id) as total_finalizadas')
           ->from('requisicion')
           ->where('id_usuario', $id_usuario)
           ->where('comentario_final IS NOT NULL')
           ->where('id_portal', $id_portal)
           ->where('status', 3)
           ->where('creacion >=', $fechaInicio)
           ->where('edicion <=', $fechaFin);
  $query = $this->db->get();
  // Retornar el resultado como un objeto
  $resultado = $query->row();
  return $resultado->total_finalizadas;
}
public function obtenerPromedioSLAPorUsuarioYFecha($fecha_inicio, $fecha_fin, $id_usuario) {
  // Convertir las fechas a formato MySQL
  $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
  $fecha_fin = date('Y-m-d', strtotime($fecha_fin));

  // Consulta para obtener las requisiciones asignadas al usuario en el rango de fechas especificado
  $this->db->select('R.creacion, R.edicion')
      ->from('requisicion as R')
      ->where('comentario_final IS NOT NULL')
      ->where('R.id_usuario', $id_usuario)
      ->where('R.status', 3)
      ->where('R.eliminado', 0)
      ->where('R.creacion >=', $fecha_inicio)
      ->where('R.edicion <=', $fecha_fin);

  $query = $this->db->get();
  $requisiciones = $query->result();

  // Calcular el SLA para cada requisición y sumarlos para obtener el total de días
  $total_sla = 0;
  foreach ($requisiciones as $requisicion) {
      $creacion = new DateTime($requisicion->creacion);
      $edicion = new DateTime($requisicion->edicion);
      $sla = $edicion->diff($creacion)->days; // Calcular la diferencia en días entre las fechas
      $total_sla += $sla; // Sumar el SLA de esta requisición al total
  }

  // Calcular el promedio de SLA en días
  $num_requisiciones = count($requisiciones);
  $promedio_sla = $num_requisiciones > 0 ? $total_sla / $num_requisiciones : 0;

  return $promedio_sla;
}
public function obtenerAspirantesPorRangoFecha($fechaInicio, $fechaFin) {
  $id_portal = $this->session->userdata('idPortal');

  // Active Record
  return $this->db
      ->where('creacion >=', $fechaInicio)
      ->where('creacion <=', $fechaFin)
      ->where('id_portal', $id_portal)
      ->get('bolsa_trabajo')
      ->result();
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