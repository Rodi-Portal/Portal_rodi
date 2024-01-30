<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_hcl_model extends CI_Model{

  function getTotal($id_cliente){
    $this->db->select("c.id")
    ->from('candidato as c ')
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->where('c.id_cliente', $id_cliente)
    ->where('c.eliminado', 0);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getCandidatos($id_cliente){
    $this->db->select("c.id,c.subproyecto,c.fecha_alta,c.tiempo_parcial,c.cancelado,c.fecha_contestado,c.tipo_formulario,c.fecha_documentos,c.status,c.status_bgc,CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.pais, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, bgc.id as idBGC, bgc.creacion as fecha_final, bgc.tiempo, bgc.credito_check, pru.tipo_antidoping, pru.antidoping, pru.medico, pru.socioeconomico, med.archivo_examen_medico, CONCAT(us.nombre,' ',us.paterno) as usuario,c.puesto as puesto_ingles, CS.secciones, CS.lleva_identidad, CS.lleva_empleos, CS.lleva_criminal, CS.lleva_estudios, CS.lleva_credito, CS.tiempo_empleos, CS.tiempo_criminales, CS.tiempo_domicilios, CS.tiempo_credito, CS.id_seccion_global_search, CS.lleva_gaps, CS.cantidad_ref_profesionales, CS.id_seccion_verificacion_docs, CS.lleva_domicilios, CS.id_seccion_datos_generales, CS.proyecto, CS.id_seccion_historial_domicilios, CS.cantidad_ref_personales, CS.lleva_prohibited_parties_list,c.id_grado_estudio,c.estudios_periodo,c.estudios_escuela,c.estudios_ciudad,c.estudios_certificado,CS.id_ref_academica,CS.cantidad_ref_academicas,CS.id_ref_profesional")
    ->from('candidato as c ')
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->join('medico as med','med.id_candidato = c.id','left')
    ->join('candidato_seccion as CS','CS.id_candidato = c.id','left')
    ->join('doping as dop','dop.id_candidato = c.id','left')
    ->join('candidato_bgc as bgc','bgc.id_candidato = c.id','left')
    ->join('usuario as us','us.id = c.id_usuario','left')
    ->where('c.id_cliente', $id_cliente)
    ->where('c.eliminado', 0)
    ->where('c.creacion >=', '2023-01-01 00:00:00')
    ->order_by('id','DESC');

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
    ->where('c.id_cliente',2)
    ->where('c.eliminado', 0)
    ->order_by('c.id', 'DESC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getTotalPanel($id_cliente){
    $privacidad = $this->session->userdata('privacidad');
    if($privacidad == 0 || $privacidad == 1){
      $condicionPrivacidad = 'c.privacidad >=';
      $nivelPrivacidad = 0;
    }
    else{
      $condicionPrivacidad = 'c.privacidad';
      $nivelPrivacidad = $privacidad;
    }
    $this->db
    ->select("c.id,")
    ->from('candidato as c')
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->where('c.id_cliente', $id_cliente)
    ->where($condicionPrivacidad, $nivelPrivacidad)
    ->where('c.eliminado', 0)
    ->where('c.cancelado', 0);

    $query = $this->db->get();
    return $query->num_rows();
  }
  
  function getCandidatosPanel($id_cliente){
    $privacidad = $this->session->userdata('privacidad');
    if($privacidad == 0 || $privacidad == 1){
      $condicionPrivacidad = 'c.privacidad >=';
      $nivelPrivacidad = 0;
    }
    else{
      $condicionPrivacidad = 'c.privacidad';
      $nivelPrivacidad = $privacidad;
    }
    $this->db
    ->select("c.id, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato,c.id_cliente,c.subproyecto,c.fecha_alta,c.fecha_contestado,c.fecha_documentos,c.status,c.status_bgc,c.tipo_formulario,c.liberado,pru.tipo_antidoping, pru.antidoping, pru.medico, pru.status_doping as doping_hecho, pru.socioeconomico, med.archivo_examen_medico,dop.id as idDoping,dop.resultado as resultado_doping,dop.fecha_resultado,CS.proyecto, CS.id_ref_academica, BGC.id as idBGC ")
    ->from('candidato as c')
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->join('medico as med','med.id_candidato = c.id','left')
    ->join('candidato_seccion as CS','CS.id_candidato = c.id','left')
    ->join('doping as dop','dop.id_candidato = c.id','left')
    ->join('candidato_bgc as BGC','BGC.id_candidato = c.id','left')
    ->where('c.id_cliente', $id_cliente)
    ->where($condicionPrivacidad, $nivelPrivacidad)
    ->where('c.eliminado', 0)
    ->where('c.cancelado', 0)
    ->order_by('id','DESC');

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