<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_ust_model extends CI_Model{

  /*----------------------------------------*/
  /*  Proceso ESE
  /*----------------------------------------*/
    function getTotalESE(){
      $this->db
      ->select("c.id,dop.id,")
      ->from("candidato as c")
      ->join('candidato_seccion as CS','c.id = CS.id_candidato','left')
      ->join('doping as dop','c.id = dop.id_candidato','left')
      ->where_in('CS.proyecto',['ESE','WORLD CHECK'])
      ->where("c.id_cliente", 1)
      ->where('dop.id', null)
      ->where("c.eliminado", 0);

      $query = $this->db->get();
      return $query->num_rows();
    }
    function getCandidatosESE(){
      $this->db
      ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, est.id as idEstudios,est.primaria_periodo, est.primaria_escuela, est.primaria_ciudad, est.primaria_certificado, est.primaria_validada, est.secundaria_periodo, est.secundaria_escuela, est.secundaria_ciudad, est.secundaria_certificado, est.secundaria_validada, est.preparatoria_periodo, est.preparatoria_escuela, est.preparatoria_ciudad, est.preparatoria_certificado, est.preparatoria_validada, est.licenciatura_periodo, est.licenciatura_escuela, est.licenciatura_ciudad, est.licenciatura_certificado, est.licenciatura_validada, est.otros_certificados, est.comentarios, est.carrera_inactivo, f.creacion as fecha_final, f.tiempo, f.identidad_check, f.empleo_check, f.estudios_check, f.visita_check, f.penales_check, f.ofac_check, f.laboratorio_check, f.medico_check, f.comentario_final, f.global_searches_check, dop.id as idDoping, CONCAT(u.nombre,' ',u.paterno) as usuario, CS.secciones,CS.lleva_empleos,CS.lleva_criminal,CS.lleva_estudios,CS.proyecto,CS.id_seccion_datos_generales,CS.id_seccion_global_search,CS.lleva_prohibited_parties_list")
      ->from('candidato as c')
      ->join('candidato_estudios as est','est.id_candidato = c.id',"left")
      ->join('candidato_bgc as f','c.id = f.id_candidato','left')
      ->join('candidato_seccion as CS','c.id = CS.id_candidato','left')
      ->join('doping as dop','c.id = dop.id_candidato','left')
      ->join('usuario as u','c.id_usuario = u.id','left')
      ->where_in('CS.proyecto',['ESE', 'WORLD CHECK', 'ESE International', 'ESE-WORLD CHECK']) 
      ->where('dop.id', null)
      ->where('c.id_cliente',1)
      ->where('c.eliminado', 0);

      $query = $this->db->get();
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return FALSE;
      }
    }

  /*----------------------------------------*/
  /*  Proceso FACIS
  /*----------------------------------------*/
    function getTotalFACIS(){
      $this->db
      ->select("*")
      ->from("candidato")
      ->where('id_tipo_proceso',2)
      ->where("id_cliente", 1)
      ->where("eliminado", 0);

      $query = $this->db->get();
      return $query->num_rows();
    }
    function getCandidatosFACIS(){
      $this->db
      ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, pr.ofac, pr.oig, pr.sam, pr.data_juridica, pr.edicion as fecha_final")
      ->from('candidato as c')
      ->join('candidato_pruebas as pr','pr.id_candidato = c.id',"left")
      ->where('c.id_tipo_proceso',2)
      ->where('c.id_cliente',1)
      ->where('c.eliminado', 0);

      $query = $this->db->get();
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return FALSE;
      }
    }
    /*----------------------------------------*/
    /*  Panel Cliente
    /*----------------------------------------*/
    function getTotalPanelCliente($id_cliente){
      $this->db
      ->select("c.id")
      ->from('candidato as c')
      ->join('doping as dop','c.id = dop.id_candidato','left')
      ->where('dop.id', null)
      ->where('c.id_cliente',$id_cliente)
      ->where('c.eliminado', 0);

      $query = $this->db->get();
      return $query->num_rows();
    }
    function getCandidatosPanelCliente($id_cliente){
      $this->db
      ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, est.id as idEstudios, f.creacion as fecha_final, f.tiempo, dop.id as idDoping, CONCAT(u.nombre,' ',u.paterno) as usuario")
      ->from('candidato as c')
      ->join('candidato_estudios as est','est.id_candidato = c.id',"left")
      ->join('candidato_bgc as f','c.id = f.id_candidato','left')
      /*->join('verificacion_documento as verdoc','c.id = verdoc.id_candidato','left')
      ->join('candidato_persona as pers','pers.id_candidato = c.id',"left")
      ->join('candidato_ref_personal as refper','refper.id_candidato = c.id',"left")
      ->join('verificacion_ref_laboral as verlab','verlab.id_candidato = c.id',"left")
      ->join('verificacion_penales as penal','penal.id_candidato = c.id','left')
      ->join('candidato_pruebas as pru','pru.id_candidato = c.id','left')
      ->join('avance_porcentaje as avance','c.id = avance.id_candidato','left')*/
      ->join('doping as dop','c.id = dop.id_candidato','left')
      ->join('usuario as u','c.id_usuario = u.id','left')
      ->where('dop.id', null)
      ->where('c.id_cliente',$id_cliente)
      ->where('c.eliminado', 0)
      ->group_by('c.id','verdoc.id','pers.id','refper.id','verlab.id','penal.id');

      $query = $this->db->get();
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return FALSE;
      }
    }
  /*----------------------------------------*/
	/*  Porcentaje de Avances
	/*----------------------------------------*/
    function getSeccionesRequeridas($id_candidato){
			$this->db
	    ->select('c.id as idCandidato, c.fecha_contestado, est.comentarios as estudios_comentarios, verdoc.comentarios as docs_comentarios, persona.id as idFamiliar, refper.id as idRefPer, verlab.id as idVerLaboral, verest.id as idVerEstudios, estatuslab.id as idEstatusLaboral, verpenal.id as idVerPenal, doc.id as idDocumento')
      ->from('candidato as c')
      ->join('candidato_estudios as est','est.id_candidato = c.id',"left")
      ->join('verificacion_documento as verdoc','verdoc.id_candidato = c.id',"left")
      ->join('candidato_persona as persona','persona.id_candidato = c.id',"left")
      ->join('candidato_ref_personal as refper','refper.id_candidato = c.id',"left")
      ->join('verificacion_ref_laboral as verlab','verlab.id_candidato = c.id',"left")
      ->join('verificacion_estudios as verest','verest.id_candidato = c.id',"left")
      ->join('status_ref_laboral as estatuslab','estatuslab.id_candidato = c.id',"left")
      ->join('verificacion_penales as verpenal','verpenal.id_candidato = c.id',"left")
      ->join('candidato_documento as doc','doc.id_candidato = c.id','left')
      ->join('cliente as cl','cl.id = c.id_cliente')
	    ->where('cl.id', 1)
	    ->where('c.id_tipo_proceso', 1)
	    ->where('c.eliminado', 0)
	    ->where('c.id', $id_candidato)
			->group_by('c.id');

	    $consulta = $this->db->get();
      $resultado = $consulta->row();
      return $resultado;
		}
}