<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcliente_model extends CI_Model{
	/*----------------------------------------*/
    /*  Subclientes
    /*----------------------------------------*/
    
    
    
    
    
    function verificarMismoUsuarioSubcliente($correo, $id_usuario_subcliente){
        $this->db
        ->select("id")
        ->from("usuario_subcliente")
        ->where("id", $id_usuario_subcliente)
        ->where("correo", $correo);

        $query = $this->db->get();
        return $query->num_rows();
    }
    function actualizarUsuarioSubcliente($usuario, $id_usuario_subcliente){
        $this->db
        ->where('id', $id_usuario_subcliente)
        ->update('usuario_subcliente', $usuario);
    }
    function checkUsuarioSubcliente($correo){
        $this->db
        ->select("id")
        ->from("usuario_subcliente")
        ->where("correo", $correo);

        $query = $this->db->get();
        return $query->num_rows();
    }
    
    
    
    

	function getCandidatosSubclientesTotal($id_cliente){
	    $this->db
	    ->select("c.id")
	    ->from("candidato as c")
	    ->join("subcliente as sub","sub.id = c.id_subcliente")
	    //->where("status", 1)
	    ->where("sub.id_cliente", $id_cliente)
	    ->where("c.eliminado", 0);

	    $query = $this->db->get();
	    return $query->num_rows();
	}
  	function getCandidatosSubclientes($id_cliente){
	    $this->db
	    ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as nombreCompleto, est.id as idEstudios,est.primaria_periodo, est.primaria_escuela, est.primaria_ciudad, est.primaria_certificado, est.primaria_validada, est.secundaria_periodo, est.secundaria_escuela, est.secundaria_ciudad, est.secundaria_certificado, est.secundaria_validada, est.preparatoria_periodo, est.preparatoria_escuela, est.preparatoria_ciudad, est.preparatoria_certificado, est.preparatoria_validada, est.licenciatura_periodo, est.licenciatura_escuela, est.licenciatura_ciudad, est.licenciatura_certificado, est.licenciatura_validada, est.otros_certificados, est.comentarios, est.carrera_inactivo, sub.empresa as subcliente, bgc.creacion as fecha_bgc, pro.nombre as proyecto")
	    ->from('candidato as c')
	    ->join("subcliente as sub","sub.id = c.id_subcliente")
	    ->join('candidato_estudios as est','est.id_candidato = c.id',"left")
	    ->join('candidato_bgc as bgc','bgc.id_candidato = c.id','left')
	    ->join('proyecto as pro','pro.id = c.id_proyecto','left')
	    ->where('sub.id_cliente', $id_cliente)
	    //->where('c.eliminado', 0)
	    ->order_by('c.status','ASC')
	    ->order_by('c.nombre','ASC');

	    $query = $this->db->get();
	    if($query->num_rows() > 0){
	      return $query->result();
	    }else{
	      return FALSE;
	    }
  	}
  	function getCandidatosSubclienteTotal($id_cliente, $id_subcliente){
	    $this->db
        ->select("c.id")
        ->from('candidato as c')
        ->join("cliente as cl","cl.id = c.id_cliente")
        ->join("subcliente as sub","sub.id = c.id_subcliente","left")
        ->join("grado_estudio as g","g.id = c.id_grado_estudio","left")
        ->join('candidato_estudios as est','est.id_candidato = c.id',"left")
        ->join('candidato_antecedentes_sociales as soc','soc.id_candidato = c.id',"left")
        ->join('verificacion_legal as inv','inv.id_candidato = c.id',"left")
        ->join('verificacion_no_mencionados as nomen','nomen.id_candidato = c.id',"left")
        ->join('doping as dop','dop.id_candidato = c.id','left')
        ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
        ->join('puesto as p','p.id = c.id_puesto')
        ->where('c.id_cliente', $id_cliente)
        ->where('c.id_subcliente', $id_subcliente)
        ->where('c.eliminado', 0)
        ->where('c.cancelado', 0)
        ->where('pru.socioeconomico', 1);

	    $query = $this->db->get();
	    return $query->num_rows();
	}
  	function getCandidatosSubcliente($id_cliente, $id_subcliente){
	    $this->db
        ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, est.id as idEstudios, est.primaria_periodo, est.primaria_escuela, est.primaria_ciudad, est.primaria_certificado, est.primaria_promedio, est.secundaria_periodo, est.secundaria_escuela, est.secundaria_ciudad, est.secundaria_certificado, est.secundaria_promedio, est.preparatoria_periodo, est.preparatoria_escuela, est.preparatoria_ciudad, est.preparatoria_certificado, est.preparatoria_promedio, est.licenciatura_periodo, est.licenciatura_escuela, est.licenciatura_ciudad, est.licenciatura_certificado, est.licenciatura_promedio, est.comercial_periodo, est.comercial_escuela, est.comercial_ciudad, est.comercial_certificado, est.comercial_promedio, est.actual_periodo, est.actual_escuela, est.actual_ciudad, est.actual_certificado, est.actual_promedio,est.otros_certificados, est.cedula_profesional ,est.comentarios, est.carrera_inactivo, soc.id as idSociales, soc.sindical, soc.sindical_nombre, soc.sindical_cargo, soc.partido, soc.partido_nombre, soc.partido_cargo, soc.club, soc.deporte, soc.religion, soc.religion_frecuencia, soc.bebidas, soc.bebidas_frecuencia, soc.fumar, soc.fumar_frecuencia, soc.cirugia, soc.enfermedades, soc.corto_plazo, soc.mediano_plazo, inv.penal, inv.penal_notas, inv.civil as inv_civil, inv.civil_notas, inv.laboral as inv_laboral, inv.laboral_notas, inv.id as idInv, nomen.id as idNomen, nomen.no_mencionados, nomen.resultado_no_mencionados, nomen.notas_no_mencionados, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, pru.tipo_antidoping, p.nombre as puesto, pro.nombre as proyecto, pru.psicometrico, pru.medico, psi.id as idPsicometrico, psi.archivo, m.id as idMedico, m.imagen_historia_clinica as imagen, m.conclusion, reflab.id as idRefLaboral  ")
        ->from('candidato as c')
        ->join("cliente as cl","cl.id = c.id_cliente")
        ->join("subcliente as sub","sub.id = c.id_subcliente","left")
        ->join("grado_estudio as g","g.id = c.id_grado_estudio","left")
        ->join('candidato_estudios as est','est.id_candidato = c.id',"left")
        ->join('candidato_antecedentes_sociales as soc','soc.id_candidato = c.id',"left")
        ->join('verificacion_legal as inv','inv.id_candidato = c.id',"left")
        ->join('verificacion_no_mencionados as nomen','nomen.id_candidato = c.id',"left")
        ->join('doping as dop','dop.id_candidato = c.id','left')
        ->join('candidato_pruebas as pru','pru.id_candidato = c.id','left')
        ->join('puesto as p','p.id = c.id_puesto','left')
        ->join('proyecto as pro','pro.id = c.id_proyecto','left')
        ->join('psicometrico as psi','c.id = psi.id_candidato','left')
        ->join('medico as m','c.id = m.id_candidato','left')
        ->join('candidato_ref_laboral as reflab','c.id = reflab.id_candidato','left')
        ->where('c.id_cliente', $id_cliente)
        ->where('c.id_subcliente', $id_subcliente)
        ->where('c.eliminado', 0)
        ->where('c.cancelado', 0)
        ->where('pru.socioeconomico', 1)
        ->order_by('c.status','ASC')
        ->order_by('c.id','DESC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
  	}
  	function repetidoCandidato($nombre, $paterno, $materno, $correo, $id_cliente){
	    $this->db
	    ->select('id')
	    ->from('candidato')
	    ->where('nombre', $nombre)
	    ->where('paterno', $paterno)
	    ->where('materno', $materno)
	    ->where('id_cliente', $id_cliente)
	    ->or_where('correo', $correo);

	    $query = $this->db->get();
	    return $query->num_rows();
	}
	function getTotalCandidatos($id_subcliente){
	    $this->db
	    ->select("*")
	    ->from("candidato")
	    ->where('id_subcliente',$id_subcliente)
	    //->where("status", 1)
	    ->where("eliminado", 0);

	    $query = $this->db->get();
	    return $query->num_rows();
  	}
  	function getCandidatos($id_subcliente){
	    $this->db
	    ->select(" c.id, c.fecha_alta, c.status, c.status_bgc, c.visitador, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.cancelado, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, est.id as idEstudios, soc.id as idSociales, per.id as idPersonales, lab.id as idLaborales, leg.id as idLegales, pb.tipo_antidoping, pb.psicometrico, psi.id as idPsicometrico, psi.archivo, cl.nombre as cliente, sub.nombre as subcliente, ava.id as idAvance, pb.socioeconomico, pb.status_doping as doping_hecho, pb.medico, m.id as idMedico, m.conclusion, m.descripcion,c.liberado,c.subproyecto,c.id_cliente,c.fecha_nacimiento,c.centro_costo")
	    ->from('candidato as c')
			->join('cliente as cl','cl.id = c.id_cliente','left')
			->join('subcliente as sub','sub.id = c.id_subcliente','left')
			->join('candidato_pruebas as pb','pb.id_candidato = c.id')
	   	->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left')
	   	->join('candidato_estudios as est','est.id_candidato = c.id','left')
	   	->join('candidato_antecedentes_sociales as soc','soc.id_candidato = c.id','left')
	   	->join('candidato_ref_personal as per','per.id_candidato = c.id','left')
	   	->join('candidato_antecedente_laboral as lab','lab.id_candidato = c.id','left')
	   	->join('verificacion_legal as leg','leg.id_candidato = c.id','left')
			->join('psicometrico as psi','c.id = psi.id_candidato','left')
			->join('medico as m','c.id = m.id_candidato','left')
			->join('avance as ava','c.id = ava.id_candidato','left')
	    ->where('c.id_subcliente', $id_subcliente)
	    ->where('c.eliminado', 0)
	    ->where('c.cancelado', 0)
	    //->where('pb.socioeconomico', 1)
			->order_by('c.id','DESC')
	    ->group_by('c.id');

	    $query = $this->db->get();
	    if($query->num_rows() > 0){
	      	return $query->result();
	    }else{
	      	return FALSE;
	    }
		}
	function getPaqueteSubclienteProyecto($id_cliente, $id_proyecto, $id_subcliente){
        $this->db
        ->select('paq.*')
        ->from('cliente_doping as cl')
        ->join('antidoping_paquete as paq','paq.id = cl.id_antidoping_paquete')
        ->where('cl.id_cliente', $id_cliente)
        ->where('cl.id_subcliente', $id_subcliente)
        ->where('cl.id_proyecto', $id_proyecto)
        ->where('cl.status', 1);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
  function getSubclientesByIdCliente($id_cliente){
    $this->db
    ->select("*")
    ->from('subcliente')
    ->where('id_cliente',$id_cliente)
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
  function addSubclient($data){
    $this->db->insert('subcliente', $data);
  }
}