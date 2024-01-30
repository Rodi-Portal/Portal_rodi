<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_general_model extends CI_Model{

  function getSubclientes($id_cliente){
    $data['subclientes'] = $this->getSubclientesOmitidos($id_cliente);
    $subclientes[] = -1;
    if($data['subclientes']){
      foreach($data['subclientes'] as $sub){
        $subclientes[] = $sub->id_subcliente;
      }
    }
    $this->db
    ->select('id, nombre, empresa, razon_social')
    ->from('subcliente')
    ->where('id_cliente', $id_cliente)
    ->where('status', 1)
    ->where('eliminado', 0)
    ->where_not_in('id', $subclientes)
    ->order_by('nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getDatosCliente($id_cliente){
    $this->db
    ->select('cl.*')
    ->from('cliente as cl')
    ->where('cl.id',$id_cliente);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function checkCandidatoRepetidoSubcliente($nombre, $paterno, $materno, $id_cliente, $id_subcliente){
    $this->db
   ->select('c.id')
   ->from('candidato as c')
   ->join("candidato_pruebas as pr","pr.id_candidato = c.id")
   ->where('c.nombre', $nombre)
   ->where('c.paterno', $paterno)
   ->where('c.materno', $materno)
   ->where('c.id_cliente', $id_cliente)
   ->where('c.id_subcliente', $id_subcliente)
   ->where('pr.socioeconomico', 1)
   ->where('c.eliminado', 0);

   $query = $this->db->get();
   return $query->num_rows();
  }
  function getCandidatosCliente($id_cliente){
    $this->db
    ->select("c.id, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato")
    ->from('candidato as c')
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->where('c.id_cliente', $id_cliente)
    ->where('c.eliminado', 0)
    ->where('pru.socioeconomico', 1)
    ->order_by('c.nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getTotal($id_cliente, $id_rol, $id_usuario, $statusBGC){
    $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario):array('c.id_usuario >' => 0);
    $this->db
    ->select("c.id")
    ->from("candidato as c")
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    //->where("c.id_cliente", $id_cliente)
    ->where("c.eliminado", 0)
    ->where_in('c.status_bgc', $statusBGC)
    ->where('pru.socioeconomico', 1)
    ->where('c.id_cliente', $id_cliente);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getCandidatos($id_cliente, $id_rol, $id_usuario, $statusBGC){
    //$usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario):array('c.id_usuario >=' => 0);
    $this->db
    ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.fecha_domicilio as fecha_doc_domicilio, cl.nombre as cliente, sub.nombre as subcliente, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, dop.status as statusDoping, pru.status_doping as doping_hecho, pru.tipo_antidoping, pru.medico, pru.psicometrico, pru.socioeconomico, p.nombre as puesto,estado.nombre as estado, mun.nombre as municipio, g.nombre as grado, m.id as idMedico, m.imagen_historia_clinica as imagen, m.conclusion, m.descripcion, m.archivo_examen_medico, psi.id as idPsicometrico, psi.archivo, c.religion as personales_religion, f.creacion as fecha_final, f.tiempo, f.descripcion_personal1, f.descripcion_personal2, f.descripcion_personal3, f.descripcion_personal4, f.descripcion_laboral1, f.descripcion_laboral2, f.descripcion_socio1, f.descripcion_socio2, f.descripcion_visita1, f.descripcion_visita2, f.conclusion_investigacion, f.recomendable, f.id as idFinalizado, c.puesto as puesto_ingles, CONCAT(us.nombre,' ',us.paterno) as usuario, CS.secciones, CS.visita as seccion_visita,CS.tipo_conclusion,CS.proyecto as proyectoCandidato, CS.cantidad_ref_personales,vis.comentarios as visita_comentarios,CS.id_seccion_datos_generales,CS.id_seccion_social,CS.id_ref_personales,CS.id_empleos,CS.id_seccion_verificacion_docs,CS.id_finanzas,CS.cantidad_ref_vecinales, CS.lleva_gaps, CS.id_estudios, CS.lleva_salud, CS.id_salud,CS.id_vivienda,CS.id_servicio,CS.id_ref_vecinal,CS.lleva_empleos,CS.lleva_estudios,CS.lleva_criminal,CS.id_investigacion, CS.id_extra_laboral,CS.id_seccion_global_search,CONCAT(REC.nombre,' ',REC.paterno) as reclutadorAspirante,CS.id_no_mencionados,BECA.id as idBeca, BECA.archivo as archivoBeca,CS.id_referencia_cliente,CS.id_candidato_empresa, CS.cantidad_ref_clientes,bgc.creacion as fecha_bgc,bgc.id as idBGC,cl.ingles, CS.id_seccion_historial_domicilios, CS.cantidad_ref_profesionales, CS.id_ref_profesional, CS.cantidad_ref_academicas, CS.id_ref_academica")
    ->from('candidato as c')
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join("subcliente as sub","sub.id = c.id_subcliente","left")
    ->join("grado_estudio as g","g.id = c.id_grado_estudio","left")
    ->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left')
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->join('puesto as p','p.id = c.id_puesto','left')
    ->join('estado','estado.id = c.id_estado','left')
    ->join('municipio as mun','mun.id = c.id_municipio','left')
    ->join('medico as m','c.id = m.id_candidato','left')
    ->join('psicometrico as psi','c.id = psi.id_candidato','left')
    ->join('candidato_finalizado as f','c.id = f.id_candidato','left')
    ->join('candidato_bgc as bgc','c.id = bgc.id_candidato','left')
    ->join('usuario as us','us.id = c.id_usuario',"left")
    ->join('candidato_seccion as CS','CS.id_candidato = c.id',"left")
    ->join('visita as vis','c.id = vis.id_candidato','left')
    ->join('requisicion_aspirante as ASP','c.id_aspirante = ASP.id','left')
    ->join('usuario as REC','REC.id = ASP.id_usuario',"left")
    ->join('beca as BECA','c.id = BECA.id_candidato','left')
    ->where('c.id_cliente', $id_cliente)
    ->where('c.eliminado', 0)
    ->where_in('c.status_bgc', $statusBGC)
    ->where('pru.socioeconomico', 1)
    ->group_by('c.id');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getCandidatosFinalizados($id_cliente, $id_rol, $id_usuario){
    $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario):array('c.id_usuario >=' => 0);
    $data['subclientes'] = $this->getSubclientesOmitidos($id_cliente);
    $subclientes[] = -1;
    if($data['subclientes']){
      foreach($data['subclientes'] as $sub){
        $subclientes[] = $sub->id_subcliente;
      }
    }
    $this->db
    ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.fecha_domicilio as fecha_doc_domicilio, cl.nombre as cliente, sub.nombre as subcliente, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, dop.status as statusDoping, pru.status_doping as doping_hecho, pru.tipo_antidoping, pru.medico, pru.psicometrico, pru.socioeconomico, p.nombre as puesto,estado.nombre as estado, mun.nombre as municipio, g.nombre as grado, m.id as idMedico, m.imagen_historia_clinica as imagen, m.conclusion, m.descripcion, psi.id as idPsicometrico, psi.archivo, c.religion as personales_religion, f.creacion as fecha_final, f.tiempo, f.descripcion_personal1, f.descripcion_personal2, f.descripcion_personal3, f.descripcion_personal4, f.descripcion_laboral1, f.descripcion_laboral2, f.descripcion_socio1, f.descripcion_socio2, f.descripcion_visita1, f.descripcion_visita2, f.conclusion_investigacion, f.recomendable, f.id as idFinalizado, c.puesto as puesto_ingles, CONCAT(us.nombre,' ',us.paterno) as usuario, CS.secciones, CS.visita as seccion_visita,CS.tipo_conclusion,CS.proyecto as proyectoCandidato, CS.cantidad_ref_personales,vis.comentarios as visita_comentarios,CS.id_seccion_datos_generales,CS.id_seccion_social,CS.id_ref_personales,CS.id_empleos,CS.id_seccion_verificacion_docs,CS.id_finanzas,CS.cantidad_ref_vecinales, CS.lleva_gaps, CS.id_estudios, CS.lleva_salud, CS.id_salud,CS.id_vivienda,CS.id_servicio,CS.id_ref_vecinal,CS.lleva_empleos,CS.lleva_estudios,CS.lleva_criminal,CS.id_investigacion, CS.id_extra_laboral,CS.id_seccion_global_search,CONCAT(REC.nombre,' ',REC.paterno) as reclutadorAspirante,CS.id_no_mencionados,BECA.id as idBeca, BECA.archivo as archivoBeca,CS.id_referencia_cliente,CS.id_candidato_empresa, CS.cantidad_ref_clientes,bgc.creacion as fecha_bgc,bgc.id as idBGC,cl.ingles, CS.id_seccion_historial_domicilios")
    ->from('candidato as c')
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join("subcliente as sub","sub.id = c.id_subcliente","left")
    ->join("grado_estudio as g","g.id = c.id_grado_estudio","left")
    ->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left')
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->join('puesto as p','p.id = c.id_puesto','left')
    ->join('estado','estado.id = c.id_estado','left')
    ->join('municipio as mun','mun.id = c.id_municipio','left')
    ->join('medico as m','c.id = m.id_candidato','left')
    ->join('psicometrico as psi','c.id = psi.id_candidato','left')
    ->join('candidato_finalizado as f','c.id = f.id_candidato','left')
    ->join('candidato_bgc as bgc','c.id = bgc.id_candidato','left')
    ->join('usuario as us','us.id = c.id_usuario',"left")
    ->join('candidato_seccion as CS','CS.id_candidato = c.id',"left")
    ->join('visita as vis','c.id = vis.id_candidato','left')
    ->join('requisicion_aspirante as ASP','c.id_aspirante = ASP.id','left')
    ->join('usuario as REC','REC.id = ASP.id_usuario',"left")
    ->join('beca as BECA','c.id = BECA.id_candidato','left')
    ->where('c.id_cliente', $id_cliente)
    //->where('c.creacion >=', '2023-01-01 00:00:00')
    //->where_not_in('c.id_subcliente', $subclientes)  
    ->where('c.eliminado', 0)
    ->where('c.status_bgc !=', 0)
    ->where('pru.socioeconomico', 1)
    //->where($usuario)
    ->group_by('c.id');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getFinalizadosTotal($id_cliente, $id_rol, $id_usuario){
    $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario):array('c.id_usuario >' => 0);
    $this->db
    ->select("c.id")
    ->from("candidato as c")
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    //->where("c.id_cliente", $id_cliente)
    ->where("c.eliminado", 0)
    ->where('c.status_bgc !=', 0)
    ->where('pru.socioeconomico', 1)
    ->where('c.id_cliente', $id_cliente);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getCandidatosUltimosFinalizados($id_cliente, $id_rol, $id_usuario){
    $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario):array('c.id_usuario >=' => 0);
    $data['subclientes'] = $this->getSubclientesOmitidos($id_cliente);
    $subclientes[] = -1;
    if($data['subclientes']){
      foreach($data['subclientes'] as $sub){
        $subclientes[] = $sub->id_subcliente;
      }
    }
    $this->db
    ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.fecha_domicilio as fecha_doc_domicilio, cl.nombre as cliente, sub.nombre as subcliente, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, dop.status as statusDoping, pru.status_doping as doping_hecho, pru.tipo_antidoping, pru.medico, pru.psicometrico, pru.socioeconomico, p.nombre as puesto,estado.nombre as estado, mun.nombre as municipio, g.nombre as grado, m.id as idMedico, m.imagen_historia_clinica as imagen, m.conclusion, m.descripcion, psi.id as idPsicometrico, psi.archivo, c.religion as personales_religion, f.creacion as fecha_final, f.tiempo, f.descripcion_personal1, f.descripcion_personal2, f.descripcion_personal3, f.descripcion_personal4, f.descripcion_laboral1, f.descripcion_laboral2, f.descripcion_socio1, f.descripcion_socio2, f.descripcion_visita1, f.descripcion_visita2, f.conclusion_investigacion, f.recomendable, f.id as idFinalizado, c.puesto as puesto_ingles, CONCAT(us.nombre,' ',us.paterno) as usuario, CS.secciones, CS.visita as seccion_visita,CS.tipo_conclusion,CS.proyecto as proyectoCandidato, CS.cantidad_ref_personales,vis.comentarios as visita_comentarios,CS.id_seccion_datos_generales,CS.id_seccion_social,CS.id_ref_personales,CS.id_empleos,CS.id_seccion_verificacion_docs,CS.id_finanzas, CS.cantidad_ref_vecinales, CS.lleva_gaps, CS.id_estudios, CS.lleva_salud, CS.id_salud,CS.id_vivienda,CS.id_servicio,CS.id_ref_vecinal,CS.lleva_empleos,CS.lleva_estudios,CS.lleva_criminal,CS.id_investigacion, CS.id_extra_laboral,CS.id_seccion_global_search,CONCAT(REC.nombre,' ',REC.paterno) as reclutadorAspirante,CS.id_no_mencionados,BECA.id as idBeca, BECA.archivo as archivoBeca,CS.id_referencia_cliente,CS.id_candidato_empresa, CS.cantidad_ref_clientes,bgc.creacion as fecha_bgc,bgc.id as idBGC,cl.ingles, CS.id_seccion_historial_domicilios")
    ->from('candidato as c')
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join("subcliente as sub","sub.id = c.id_subcliente","left")
    ->join("grado_estudio as g","g.id = c.id_grado_estudio","left")
    ->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left')
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->join('puesto as p','p.id = c.id_puesto','left')
    ->join('estado','estado.id = c.id_estado','left')
    ->join('municipio as mun','mun.id = c.id_municipio','left')
    ->join('medico as m','c.id = m.id_candidato','left')
    ->join('psicometrico as psi','c.id = psi.id_candidato','left')
    ->join('candidato_finalizado as f','c.id = f.id_candidato','left')
    ->join('candidato_bgc as bgc','c.id = bgc.id_candidato','left')
    ->join('usuario as us','us.id = c.id_usuario',"left")
    ->join('candidato_seccion as CS','CS.id_candidato = c.id',"left")
    ->join('visita as vis','c.id = vis.id_candidato','left')
    ->join('requisicion_aspirante as ASP','c.id_aspirante = ASP.id','left')
    ->join('usuario as REC','REC.id = ASP.id_usuario',"left")
    ->join('beca as BECA','c.id = BECA.id_candidato','left')
    ->where('c.id_cliente', $id_cliente)
    //->where('c.creacion >=', '2023-01-01 00:00:00')
    //->where_not_in('c.id_subcliente', $subclientes)  
    ->where('c.eliminado', 0)
    ->where('c.status_bgc !=', 0)
    ->where('pru.socioeconomico', 1)
    //->where($usuario)
    ->order_by('id','desc')
    ->group_by('c.id')
    ->limit(25);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getUltimosFinalizadosTotal($id_cliente, $id_rol, $id_usuario){
    $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario):array('c.id_usuario >' => 0);
    $this->db
    ->select("c.id")
    ->from("candidato as c")
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    //->where("c.id_cliente", $id_cliente)
    ->where("c.eliminado", 0)
    ->where('c.status_bgc !=', 0)
    ->where('pru.socioeconomico', 1)
    ->where('c.id_cliente', $id_cliente)
    ->limit(25);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getSubclientesOmitidos($id_cliente){
    $this->db
    ->select("id_subcliente")
    ->from('subclientes_omitidos')
    ->where('id_cliente', $id_cliente);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }

  function getSubclientesPanel($id_cliente){
    $this->db
    ->select('id, nombre, empresa, razon_social')
    ->from('subcliente')
    ->where('id_cliente', $id_cliente)
    ->where('status', 1)
    ->where('eliminado', 0)
    ->order_by('razon_social','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
        return $query->result();
    }else{
        return FALSE;
    }
  }

  function count_candidates(){
    $id_usuario = $this->session->userdata('id');
    $id_rol = $this->session->userdata('idrol');
    $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario) : array('c.id_usuario !=' => null);
    if($id_rol == 2){
      $clientes = $this->getClientesByUsuario($id_usuario);
      $clientesFiltrados = $this->db->where_in('c.id_cliente', $clientes);
    }
    else{
      $clientes = $this->getClientesByCondicion();
      $clientesFiltrados = $this->db->where_in('candidato as c');
    }
    $this->db->select("c.id");
    $this->db->from("candidato as c");
    $this->db->join('candidato_pruebas as pru','pru.id_candidato = c.id');
    $this->db->where("c.eliminado", 0);
    $this->db->where('pru.socioeconomico', 1);
    $clientesFiltrados;
    $this->db->where($usuario);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function get_paginated_data($limit, $offset){
    $id_usuario = $this->session->userdata('id');
    $id_rol = $this->session->userdata('idrol');
    $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario) : array('c.id_usuario !=' => null);
    if($id_rol == 2){
      $clientes = $this->getClientesByUsuario($id_usuario);
      $clientesFiltrados = $this->db->where_in('c.id_cliente', $clientes);
    }
    else{
      $clientes = $this->getClientesByCondicion();
      $clientesFiltrados = $this->db->where_in('candidato as c');
    }
    
    $this->db->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.fecha_domicilio as fecha_doc_domicilio, cl.nombre as cliente, sub.nombre as subcliente, dop.id as idDoping, dop.;fecha_resultado, dop.resultado as resultado_doping, dop.status as statusDoping, pru.status_doping as doping_hecho, pru.tipo_antidoping, pru.medico, pru.psicometrico, pru.socioeconomico, p.nombre as puesto,estado.nombre as estado, mun.nombre as municipio, g.nombre as grado, m.id as idMedico, m.imagen_historia_clinica as imagen, m.conclusion, m.descripcion, psi.id as idPsicometrico, psi.archivo, c.religion as personales_religion, f.creacion as fecha_final, f.tiempo, f.descripcion_personal1, f.descripcion_personal2, f.descripcion_personal3, f.descripcion_personal4, f.descripcion_laboral1, f.descripcion_laboral2, f.descripcion_socio1, f.descripcion_socio2, f.descripcion_visita1, f.descripcion_visita2, f.conclusion_investigacion, f.recomendable, f.id as idFinalizado, c.puesto as puesto_ingles, CONCAT(us.nombre,' ',us.paterno) as usuario, CS.secciones, CS.visita as seccion_visita,CS.tipo_conclusion,CS.proyecto as proyectoCandidato, CS.cantidad_ref_personales,vis.comentarios as visita_comentarios,CS.id_seccion_datos_generales,CS.id_seccion_social,CS.id_ref_personales,CS.id_empleos,CS.id_seccion_verificacion_docs,CS.id_finanzas, CS.cantidad_ref_vecinales, CS.lleva_gaps, CS.id_estudios, CS.lleva_salud, CS.id_salud,CS.id_vivienda,CS.id_servicio,CS.id_ref_vecinal,CS.lleva_empleos,CS.lleva_estudios,CS.lleva_criminal,CS.id_investigacion, CS.id_extra_laboral,CS.id_seccion_global_search,CONCAT(REC.nombre,' ',REC.paterno) as reclutadorAspirante,CS.id_no_mencionados,BECA.id as idBeca, BECA.archivo as archivoBeca,CS.id_referencia_cliente,CS.id_candidato_empresa, CS.cantidad_ref_clientes,bgc.creacion as fecha_bgc,cl.ingles");
    $this->db->from('candidato as c');
    $this->db->join("cliente as cl","cl.id = c.id_cliente");
    $this->db->join("subcliente as sub","sub.id = c.id_subcliente","left");
    $this->db->join("grado_estudio as g","g.id = c.id_grado_estudio","left");
    $this->db->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left');
    $this->db->join('candidato_pruebas as pru','pru.id_candidato = c.id');
    $this->db->join('puesto as p','p.id = c.id_puesto','left');
    $this->db->join('estado','estado.id = c.id_estado','left');
    $this->db->join('municipio as mun','mun.id = c.id_municipio','left');
    $this->db->join('medico as m','c.id = m.id_candidato','left');
    $this->db->join('psicometrico as psi','c.id = psi.id_candidato','left');
    $this->db->join('candidato_finalizado as f','c.id = f.id_candidato','left');
    $this->db->join('candidato_bgc as bgc','c.id = bgc.id_candidato','left');
    $this->db->join('usuario as us','us.id = c.id_usuario',"left");
    $this->db->join('candidato_seccion as CS','CS.id_candidato = c.id',"left");
    $this->db->join('visita as vis','c.id = vis.id_candidato','left');
    $this->db->join('requisicion_aspirante as ASP','c.id_aspirante = ASP.id','left');
    $this->db->join('usuario as REC','REC.id = ASP.id_usuario',"left");
    $this->db->join('beca as BECA','c.id = BECA.id_candidato','left');
    $this->db->where('c.id_cliente', $id_cliente);
    //->where_not_in('c.id_subcliente', $subclientes)
    $this->db->where('c.eliminado', 0);
    $this->db->where('pru.socioeconomico', 1);
    $this->db->where($usuario);
    $clientesFiltrados;
    $this->db->group_by('c.id');
    $this->db->limit($limit, $offset);

    $query = $this->db->get();
    return $query->result();
  }
  

  function getCandidatosUltimos100($id_cliente, $id_rol, $id_usuario, $statusBGC){
    //$usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario):array('c.id_usuario >=' => 0);
    $this->db
    ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.fecha_domicilio as fecha_doc_domicilio, cl.nombre as cliente, sub.nombre as subcliente, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, dop.status as statusDoping, pru.status_doping as doping_hecho, pru.tipo_antidoping, pru.medico, pru.psicometrico, pru.socioeconomico, p.nombre as puesto,estado.nombre as estado, mun.nombre as municipio, g.nombre as grado, m.id as idMedico, m.imagen_historia_clinica as imagen, m.conclusion, m.descripcion, psi.id as idPsicometrico, psi.archivo, c.religion as personales_religion, f.creacion as fecha_final, f.tiempo, f.descripcion_personal1, f.descripcion_personal2, f.descripcion_personal3, f.descripcion_personal4, f.descripcion_laboral1, f.descripcion_laboral2, f.descripcion_socio1, f.descripcion_socio2, f.descripcion_visita1, f.descripcion_visita2, f.conclusion_investigacion, f.recomendable, f.id as idFinalizado, c.puesto as puesto_ingles, CONCAT(us.nombre,' ',us.paterno) as usuario, CS.secciones, CS.visita as seccion_visita,CS.tipo_conclusion,CS.proyecto as proyectoCandidato, CS.cantidad_ref_personales,vis.comentarios as visita_comentarios,CS.id_seccion_datos_generales,CS.id_seccion_social,CS.id_ref_personales,CS.id_empleos,CS.id_seccion_verificacion_docs,CS.id_finanzas, CS.cantidad_ref_vecinales, CS.lleva_gaps, CS.id_estudios, CS.lleva_salud, CS.id_salud,CS.id_vivienda,CS.id_servicio,CS.id_ref_vecinal,CS.lleva_empleos,CS.lleva_estudios,CS.lleva_criminal,CS.id_investigacion, CS.id_extra_laboral,CS.id_seccion_global_search,CONCAT(REC.nombre,' ',REC.paterno) as reclutadorAspirante,CS.id_no_mencionados,BECA.id as idBeca, BECA.archivo as archivoBeca,CS.id_referencia_cliente,CS.id_candidato_empresa, CS.cantidad_ref_clientes,bgc.creacion as fecha_bgc,bgc.id as idBGC,cl.ingles, CS.id_seccion_historial_domicilios, CS.cantidad_ref_profesionales, CS.id_ref_profesional, CS.cantidad_ref_academicas, CS.id_ref_academica")
    ->from('candidato as c')
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join("subcliente as sub","sub.id = c.id_subcliente","left")
    ->join("grado_estudio as g","g.id = c.id_grado_estudio","left")
    ->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left')
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->join('puesto as p','p.id = c.id_puesto','left')
    ->join('estado','estado.id = c.id_estado','left')
    ->join('municipio as mun','mun.id = c.id_municipio','left')
    ->join('medico as m','c.id = m.id_candidato','left')
    ->join('psicometrico as psi','c.id = psi.id_candidato','left')
    ->join('candidato_finalizado as f','c.id = f.id_candidato','left')
    ->join('candidato_bgc as bgc','c.id = bgc.id_candidato','left')
    ->join('usuario as us','us.id = c.id_usuario',"left")
    ->join('candidato_seccion as CS','CS.id_candidato = c.id',"left")
    ->join('visita as vis','c.id = vis.id_candidato','left')
    ->join('requisicion_aspirante as ASP','c.id_aspirante = ASP.id','left')
    ->join('usuario as REC','REC.id = ASP.id_usuario',"left")
    ->join('beca as BECA','c.id = BECA.id_candidato','left')
    ->where('c.id_cliente', $id_cliente)
    ->where('c.eliminado', 0)
    ->where_in('c.status_bgc', $statusBGC)
    ->where('pru.socioeconomico', 1)
    ->group_by('c.id')
    ->limit(10);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  
  function getTotalUltimos100($id_cliente, $id_rol, $id_usuario, $statusBGC){
    $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario):array('c.id_usuario >' => 0);
    $this->db
    ->select("c.id")
    ->from("candidato as c")
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    //->where("c.id_cliente", $id_cliente)
    ->where("c.eliminado", 0)
    ->where_in('c.status_bgc', $statusBGC)
    ->where('pru.socioeconomico', 1)
    ->where('c.id_cliente', $id_cliente);

    $query = $this->db->get();
    return $query->num_rows();
  }
 
  public function get_candidates($start, $length, $search, $id_cliente){
    $this->db
    ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.fecha_domicilio as fecha_doc_domicilio, cl.nombre as cliente, sub.nombre as subcliente, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, dop.status as statusDoping, pru.status_doping as doping_hecho, pru.tipo_antidoping, pru.medico, pru.psicometrico, pru.socioeconomico, p.nombre as puesto,estado.nombre as estado, mun.nombre as municipio, g.nombre as grado, m.id as idMedico, m.imagen_historia_clinica as imagen, m.conclusion, m.descripcion, m.archivo_examen_medico, psi.id as idPsicometrico, psi.archivo, c.religion as personales_religion, f.creacion as fecha_final, f.tiempo, f.descripcion_personal1, f.descripcion_personal2, f.descripcion_personal3, f.descripcion_personal4, f.descripcion_laboral1, f.descripcion_laboral2, f.descripcion_socio1, f.descripcion_socio2, f.descripcion_visita1, f.descripcion_visita2, f.conclusion_investigacion, f.recomendable, f.id as idFinalizado, c.puesto as puesto_ingles, CONCAT(us.nombre,' ',us.paterno) as usuario, CS.secciones, CS.visita as seccion_visita,CS.tipo_conclusion,CS.proyecto as proyectoCandidato, CS.cantidad_ref_personales,vis.comentarios as visita_comentarios,CS.id_seccion_datos_generales,CS.id_seccion_social,CS.id_ref_personales,CS.id_empleos,CS.id_seccion_verificacion_docs,CS.id_finanzas,CS.cantidad_ref_vecinales, CS.lleva_gaps, CS.id_estudios, CS.lleva_salud, CS.id_salud,CS.id_vivienda,CS.id_servicio,CS.id_ref_vecinal,CS.lleva_empleos,CS.lleva_estudios,CS.lleva_criminal,CS.id_investigacion, CS.id_extra_laboral,CS.id_seccion_global_search,CONCAT(REC.nombre,' ',REC.paterno) as reclutadorAspirante,CS.id_no_mencionados,BECA.id as idBeca, BECA.archivo as archivoBeca,CS.id_referencia_cliente,CS.id_candidato_empresa, CS.cantidad_ref_clientes,bgc.creacion as fecha_bgc,bgc.id as idBGC,cl.ingles, CS.id_seccion_historial_domicilios, CS.cantidad_ref_profesionales, CS.id_ref_profesional, CS.cantidad_ref_academicas, CS.id_ref_academica")
    ->from('candidato as c')
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join("subcliente as sub","sub.id = c.id_subcliente","left")
    ->join("grado_estudio as g","g.id = c.id_grado_estudio","left")
    ->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left')
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->join('puesto as p','p.id = c.id_puesto','left')
    ->join('estado','estado.id = c.id_estado','left')
    ->join('municipio as mun','mun.id = c.id_municipio','left')
    ->join('medico as m','c.id = m.id_candidato','left')
    ->join('psicometrico as psi','c.id = psi.id_candidato','left')
    ->join('candidato_finalizado as f','c.id = f.id_candidato','left')
    ->join('candidato_bgc as bgc','c.id = bgc.id_candidato','left')
    ->join('usuario as us','us.id = c.id_usuario',"left")
    ->join('candidato_seccion as CS','CS.id_candidato = c.id',"left")
    ->join('visita as vis','c.id = vis.id_candidato','left')
    ->join('requisicion_aspirante as ASP','c.id_aspirante = ASP.id','left')
    ->join('usuario as REC','REC.id = ASP.id_usuario',"left")
    ->join('beca as BECA','c.id = BECA.id_candidato','left')
    ->where('c.id_cliente', $id_cliente)
    ->where('c.eliminado', 0)
    //->where_in('c.status_bgc', $statusBGC)
    ->where('pru.socioeconomico', 1)
    ->group_start()
      ->like('c.id', $search)
      ->or_like('c.nombre', $search)
      ->or_like('c.paterno', $search)
      ->or_like('c.materno', $search)
      ->or_like('CS.proyecto', $search)
    ->group_end()
    
    ->limit($length, $start);
    
  
    $query = $this->db->get();
  
    return $query->result();
  }
  public function get_total($search, $id_cliente){
    $this->db
    ->select("c.id")
    ->from('candidato as c')
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->where('c.id_cliente', $id_cliente)
    ->where('c.eliminado', 0)
    //->where_in('c.status_bgc', $statusBGC)
    ->where('pru.socioeconomico', 1)
    ->group_start()
      ->like('c.id', $search)
      ->or_like('c.nombre', $search)
      ->or_like('c.paterno', $search)
      ->or_like('c.materno', $search)
      ->or_like('CS.proyecto', $search)
    ->group_end();
    $query = $this->db->get();
    return $query->num_rows();
  }
  
}