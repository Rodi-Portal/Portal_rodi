<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcliente_rts_model extends CI_Model{

  function getTotal($id_cliente, $id_rol, $id_usuario){
    $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario):array('c.id_usuario >' => 0);
    $this->db
    ->select("c.*")
    ->from("candidato as c")
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->where("c.id_cliente", $id_cliente)
    ->where("c.eliminado", 0)
    ->where('pru.socioeconomico', 1);
    //->where($usuario);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getCandidatos($id_cliente, $id_rol, $id_usuario){
    $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario):array('c.id_usuario >' => 0);
    $this->db
    ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, pru.tipo_antidoping, pru.medico, pru.psicometrico, m.id as idMedico, m.imagen_historia_clinica as imagen, m.conclusion, psi.id as idPsicometrico, psi.archivo, c.religion as personales_religion, verdoc.id as idVerDoc, verdoc.licencia as ver_licencia, verdoc.licencia_institucion, verdoc.ine as ver_ine, verdoc.ine_ano, verdoc.ine_vertical, verdoc.ine_institucion, verdoc.domicilio, verdoc.fecha_domicilio, verdoc.imss as ver_imss, verdoc.imss_institucion, verdoc.rfc as ver_rfc, verdoc.rfc_institucion, verdoc.curp as ver_curp, verdoc.curp_institucion, verdoc.carta_recomendacion, verdoc.carta_recomendacion_institucion, verdoc.comentarios as ver_comentarios, c.puesto as puesto_ingles, gl.id as idGlobal, gl.regulatory, gl.sanctions, gl.media_searches, gl.other_bodies, gl.global_comentarios, gl.law_enforcement, verdoc.penales as ver_penales, verdoc.penales_institucion, verdoc.pasaporte, verdoc.pasaporte_fecha, verdoc.forma_migratoria, verdoc.forma_migratoria_fecha, bgc.id as idBGC, bgc.identidad_check, bgc.global_searches_check, bgc.comentario_final, bgc.penales_check, bgc.ofac_check, bgc.empleo_check, bgc.estudios_check, bgc.creacion as fecha_final_ingles, bgc.tiempo as tiempo_ingles, CONCAT(us.nombre,' ',us.paterno) as usuario, pru.status_doping as doping_hecho, c.fecha_domicilio as fecha_doc_domicilio, S.secciones, pru.socioeconomico, S.lleva_gaps, S.lleva_criminal, S.proyecto as proyectoSeccion, S.lleva_estudios, S.lleva_empleos, S.id_seccion_verificacion_docs, S.lleva_gaps, S.id_seccion_global_search,S.id_seccion_datos_generales,bgc.credito_check ")
    ->from('candidato as c')
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join("subcliente as sub","sub.id = c.id_subcliente","left")
    ->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left')
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->join('medico as m','c.id = m.id_candidato','left')
    ->join('psicometrico as psi','c.id = psi.id_candidato','left')
    ->join('verificacion_documento as verdoc','c.id = verdoc.id_candidato','left')
    ->join('candidato_global_searches as gl','c.id = gl.id_candidato','left')
    ->join('candidato_bgc as bgc','c.id = bgc.id_candidato','left')
    ->join('usuario as us','us.id = c.id_usuario',"left")
    ->join('candidato_seccion as S','S.id_candidato = c.id',"left")
    ->where('c.id_cliente', $id_cliente)
    ->where('c.eliminado', 0)
    ->where('pru.socioeconomico', 1)
    ->group_by('c.id')
    ->where($usuario);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getTotalPanelSubcliente($id_cliente){
    $this->db
    ->select("c.*")
    ->from("candidato as c")
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->where("c.id_cliente", $id_cliente)
    ->where("c.eliminado", 0)
    ->where('pru.socioeconomico', 1);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getCandidatosPanelSubcliente($id_cliente){
    $this->db
    ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, pru.tipo_antidoping, pru.medico, pru.psicometrico, c.puesto as puesto_ingles, bgc.id as idBGC, may.id as idMayores, bgc.creacion as fecha_final_ingles, bgc.tiempo as tiempo_ingles, CONCAT(us.nombre,' ',us.paterno) as usuario, pru.status_doping as doping_hecho, c.fecha_domicilio as fecha_doc_domicilio, verlab.id as idVerLab, gl.id as idGlobales, verpen.id as idVerificacionPenales, verdoc.id as idVerificacionDocumentos, S.secciones, pru.socioeconomico, S.lleva_gaps, S.lleva_criminal, S.proyecto as proyectoSeccion ")
    ->from('candidato as c')
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join("subcliente as sub","sub.id = c.id_subcliente","left")
    ->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left')
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->join('verificacion_documento as verdoc','c.id = verdoc.id_candidato','left')
    ->join('candidato_global_searches as gl','c.id = gl.id_candidato','left')
    ->join('candidato_bgc as bgc','c.id = bgc.id_candidato','left')
    ->join('verificacion_mayores_estudios as may','may.id_candidato = c.id',"left")
    ->join('usuario as us','us.id = c.id_usuario',"left")
    ->join('verificacion_ref_laboral as verlab','verlab.id_candidato = c.id',"left")
    ->join('verificacion_penales as verpen','verpen.id_candidato = c.id',"left")
    ->join('candidato_seccion as S','S.id_candidato = c.id',"left")
    ->where('c.id_cliente', $id_cliente)
    ->where('c.eliminado', 0)
    ->where('pru.socioeconomico', 1)
    ->group_by('c.id');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getCandidatosSubcliente($id_subcliente){
    $this->db
    ->select("c.id, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato")
    ->from('candidato as c')
    ->join("subcliente as sub","sub.id = c.id_subcliente")
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->where('c.id_subcliente', $id_subcliente)
    ->where('c.eliminado', 0)
    ->where('pru.socioeconomico', 1)
    ->order_by('c.id','DESC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
}