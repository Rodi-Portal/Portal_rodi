<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_esolutions_model extends CI_Model{

  function getTotal(){
    $this->db
    ->select("id")
    ->from("candidatos_esolutions");

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getCandidatos(){
    $this->db
    ->select("*")
    ->from("candidatos_esolutions");

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getCandidatosX(){
    $this->db
    ->select("c.id,c.subproyecto,c.fecha_alta,c.tiempo_parcial,c.cancelado,c.fecha_contestado,c.tipo_formulario,c.fecha_documentos,c.status,c.status_bgc,CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, bgc.id as idBGC, bgc.creacion as fecha_final, bgc.tiempo, bgc.credito_check, pru.antidoping, pru.medico, pru.socioeconomico, med.archivo_examen_medico, CONCAT(us.nombre,' ',us.paterno) as usuario,c.puesto as puesto_ingles, CS.secciones, CS.lleva_identidad, CS.lleva_empleos, CS.lleva_criminal, CS.lleva_estudios, CS.lleva_credito, CS.tiempo_empleos, CS.tiempo_criminales, CS.tiempo_domicilios, CS.tiempo_credito, CS.id_seccion_global_search,CS.lleva_gaps, CS.cantidad_ref_profesionales, CS.id_seccion_verificacion_docs, CS.lleva_domicilios, CS.id_seccion_datos_generales, CS.proyecto, CS.id_seccion_historial_domicilios, CS.cantidad_ref_personales")
    ->from('candidato as c')
    ->join('doping as dop','dop.id_candidato = c.id','left')
    ->join('candidato_bgc as bgc','bgc.id_candidato = c.id',"left")
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id',"left")
    ->join('medico as med','med.id_candidato = c.id',"left")
    ->join('usuario as us','us.id = c.id_usuario',"left")
    ->join('candidato_seccion as CS','CS.id_candidato = c.id',"left")
    ->where('c.id_cliente',205)
    ->where('c.eliminado', 0)
    ->order_by('c.id', 'DESC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getTotalPanel(){
    $this->db
    ->select('*')
    ->from('cliente_esolutions_panel');

    $query = $this->db->get();
    return $query->num_rows();
  }
  
  function getCandidatosPanel(){
    $this->db
    ->select('*')
    ->from('cliente_esolutions_panel');
    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }

  function repetidoCandidato($nombre, $paterno, $materno, $id_cliente){
    $this->db
    ->select('C.id')
    ->from('candidato as C')
    ->join('candidato_pruebas as P','P.id_candidato = C.id')
    ->where('C.nombre', $nombre)
    ->where('C.paterno', $paterno)
    ->where('C.materno', $materno)
    ->where('C.id_cliente', $id_cliente)
    ->where_in('C.status', [0,1])
    ->where('P.socioeconomico', 1)
    ->where('C.eliminado', 0);

    $query = $this->db->get();
    return $query->num_rows();
  }
}