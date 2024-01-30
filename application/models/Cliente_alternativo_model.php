<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_alternativo_model extends CI_Model{

  function getTotal($id_cliente, $id_rol, $id_usuario){
    $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario):array('c.id_usuario >' => 0);
    $this->db
    ->select("c.id")
    ->from("candidato as c")
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->where("c.id_cliente", $id_cliente)
    ->where("c.eliminado", 0)
    ->where('pru.socioeconomico', 1)
    ->where($usuario);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getCandidatos($id_cliente, $id_rol, $id_usuario){
    $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario):array('c.id_usuario >' => 0);
    $this->db
    ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, pru.tipo_antidoping, pru.medico, pru.psicometrico, pru.socioeconomico, p.nombre as puesto,estado.nombre as estado, mun.nombre as municipio, g.nombre as grado, m.id as idMedico, m.imagen_historia_clinica as imagen, m.conclusion, psi.id as idPsicometrico, psi.archivo, c.religion as personales_religion, vis.comentarios as visita_comentarios, f.creacion as fecha_final, f.tiempo, f.id as idFinalizado, c.puesto as puesto_ingles, CONCAT(us.nombre,' ',us.paterno) as usuario, pru.status_doping as doping_hecho, c.fecha_domicilio as fecha_doc_domicilio, CS.secciones, CS.visita as seccion_visita, CS.lleva_gaps, CS.proyecto as proyectoSeccion,CS.id_seccion_social, CS.tipo_conclusion")
    ->from('candidato as c')
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join("subcliente as sub","sub.id = c.id_subcliente","left")
    ->join("grado_estudio as g","g.id = c.id_grado_estudio","left")
    ->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left')
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->join('puesto as p','p.id = c.id_puesto')
    ->join('estado','estado.id = c.id_estado','left')
    ->join('municipio as mun','mun.id = c.id_municipio','left')
    ->join('medico as m','c.id = m.id_candidato','left')
    ->join('psicometrico as psi','c.id = psi.id_candidato','left')
    ->join('visita as vis','c.id = vis.id_candidato','left')
    ->join('candidato_finalizado as f','c.id = f.id_candidato','left')
    ->join('usuario as us','us.id = c.id_usuario',"left")
    ->join('candidato_seccion as CS','CS.id_candidato = c.id',"left")
    ->where('c.id_cliente', $id_cliente)
    ->where('c.eliminado', 0)
    ->where('pru.socioeconomico', 1)
    ->where($usuario)
    ->order_by('c.id','DESC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
}