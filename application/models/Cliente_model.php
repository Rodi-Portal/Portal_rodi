<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model{


  // function get_data(){
    
  //   $this->db
    
    
  //   //->where('pru.socioeconomico', 1)
  //   ->group_by('c.id');

  //   $query = $this->db->get();
  //   if($query->num_rows() > 0){
  //     return $query->result();
  //   }else{
  //     return FALSE;
  //   }
  // }

  public function get_rows($postData){
    $this->_get_datatables_query($postData);
    if($postData['length'] != -1){
      $this->db->limit($postData['length'], $postData['start']);
    }
    $query = $this->db->get();
    return $query->result();
  }

  public function count_all(){
    $idCliente = $this->session->userdata('idcliente');
    $this->db
    ->from('candidato as c')
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join("subcliente as sub","sub.id = c.id_subcliente","left")
    ->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left')
    ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
    ->join('candidato_bgc as bgc','c.id = bgc.id_candidato','left')
    ->join('usuario as us','us.id = c.id_usuario',"left")
    ->join('candidato_seccion as S','S.id_candidato = c.id',"left")
    ->where('c.id_cliente', $idCliente)
    ->where('c.eliminado', 0);
    return $this->db->count_all_results();
  }

  public function count_filtered($postData){
    $this->_get_datatables_query($postData);
    $query = $this->db->get();
    return $query->num_rows();
  }

  private function _get_datatables_query($postData){
    $idCliente = $this->session->userdata('idcliente');
    $column_search = array('c.nombre','c.paterno','c.materno','S.proyecto','c.fecha_alta');
    $order = array('c.nombre' => 'asc');
    $this->db
    ->select("c.id, c.nombre, c.paterno, c.materno, c.fecha_alta, c.status, c.status_bgc, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, PRU.tipo_antidoping, PRU.medico, PRU.psicometrico,  c.puesto as puesto_ingles, bgc.id as idBGC, bgc.creacion as fecha_final_ingles, bgc.tiempo as tiempo_ingles, CONCAT(us.nombre,' ',us.paterno) as usuario, PRU.status_doping as doping_hecho, c.fecha_domicilio as fecha_doc_domicilio, S.secciones, PRU.socioeconomico, S.lleva_gaps, S.lleva_criminal, S.proyecto, AP.nombre as examenDoping, MED.id as idMedico, MED.archivo_examen_medico, MED.conclusion as conclusionMedica, PSI.id as idPsicometrio, PSI.archivo as psicometria ")
    ->from('candidato as c')
    ->join("cliente as cl","cl.id = c.id_cliente")
    ->join("subcliente as sub","sub.id = c.id_subcliente","left")
    ->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left')
    ->join('medico as MED','MED.id_candidato = c.id','left')
    ->join('psicometrico as PSI','c.id = PSI.id_candidato','left')
    ->join('candidato_pruebas as PRU','PRU.id_candidato = c.id')
    ->join('candidato_bgc as bgc','c.id = bgc.id_candidato','left')
    ->join('usuario as us','us.id = c.id_usuario',"left")
    ->join('candidato_seccion as S','S.id_candidato = c.id',"left")
    ->join('antidoping_paquete as AP','AP.id = pru.antidoping',"left")
    ->where('c.id_cliente', $idCliente)
    ->where('c.eliminado', 0);

    $i = 0;
    // loop searchable columns 
    foreach($column_search as $item){
      // if datatable send POST for search
      if($postData['search']['value']){
        // first loop
        if($i===0){
          // open bracket
          $this->db->group_start();
          $this->db->like($item, $postData['search']['value']);
        }else{
          $this->db->or_like($item, $postData['search']['value']);
        }
        // last loop
        if(count($column_search) - 1 == $i){
          // close bracket
          $this->db->group_end();
        }
      }
      $i++;
    }
    if(isset($postData['order'])){
      $this->db->order_by($column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
    }else if(isset($order)){
      $order = $order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

    /*----------------------------------------*/
    /*  UST GLOBAL
    /*----------------------------------------*/
    
    
    
    
    /*----------------------------------------*/
    /*  Metodos Generales
    /*----------------------------------------*/
    
    
    
    
    
    
    function actualizarUsuarioCliente($usuario, $id_usuario_cliente){
        $this->db
        ->where('id', $id_usuario_cliente)
        ->update('usuario_cliente', $usuario);
    }
    function verificarMismoUsuarioCliente($correo, $id_usuario_cliente){
        $this->db
        ->select("id")
        ->from("usuario_cliente")
        ->where("id", $id_usuario_cliente)
        ->where("correo", $correo);

        $query = $this->db->get();
        return $query->num_rows();
    }
    
       
    function getEscuelasTotal($id_cliente){
        $this->db
        ->select("*")
        ->from("alumno")
        ->where("status", 1)
        ->where("id_cliente", $id_cliente)
        ->where("eliminado", 0);

        $query = $this->db->get();
        return $query->num_rows();
    }
    function getEscuelas($id_cliente){
        $this->db
        ->select("al.*, CONCAT(al.nombre,' ',al.paterno,' ',al.materno) as alumno, cl.nombre as cliente, sub.nombre as subcliente")
        ->from('alumno as al')
        //->join('candidato_estudios as est','est.id_candidato = c.id',"left")
        //->join('candidato_pruebas as pr','pr.id_candidato = c.id',"left")
        //->join('visita as v','v.id_candidato = c.id',"left")
        ->join("cliente as cl","cl.id = al.id_cliente")
        ->join("subcliente as sub","sub.id = al.id_subcliente","left")
        ->where('al.id_cliente', $id_cliente)
        //->where('al.eliminado', 0)
        ->order_by('al.id','DESC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    
    
    function getIntelaTotal($id_cliente){
        $this->db
        ->select("*")
        ->from("candidato")
        ->where("status", 1)
        ->where("id_cliente", $id_cliente)
        ->where("eliminado", 0);

        $query = $this->db->get();
        return $query->num_rows();
    }
    function getIntela($id_cliente){
        $this->db
        ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as nombreCompleto, est.id as idEstudios,est.primaria_periodo, est.primaria_escuela, est.primaria_ciudad, est.primaria_certificado, est.primaria_validada, est.secundaria_periodo, est.secundaria_escuela, est.secundaria_ciudad, est.secundaria_certificado, est.secundaria_validada, est.preparatoria_periodo, est.preparatoria_escuela, est.preparatoria_ciudad, est.preparatoria_certificado, est.preparatoria_validada, est.licenciatura_periodo, est.licenciatura_escuela, est.licenciatura_ciudad, est.licenciatura_certificado, est.licenciatura_validada, est.otros_certificados, est.comentarios, est.carrera_inactivo, pr.socioeconomico, pr.tipo_antidoping, pr.antidoping, pr.tipo_psicometrico, pr.psicometrico,  pr.buro_credito, pr.sociolaboral, pr.otro_requerimiento, cl.nombre as cliente, v.fecha_visita, v.hora_inicio, v.hora_fin")
        ->from('candidato as c')
        ->join('candidato_estudios as est','est.id_candidato = c.id',"left")
        ->join('candidato_pruebas as pr','pr.id_candidato = c.id',"left")
        ->join('visita as v','v.id_candidato = c.id',"left")
        ->join("cliente as cl","cl.id = c.id_cliente")
        ->join("subcliente as sub","sub.id = c.id_subcliente","left")
        ->where('c.id_cliente', $id_cliente)
        //->where('c.eliminado', 0)
        ->order_by('c.fecha_alta','DESC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    function getHclTotal(){
        $this->db
        ->select("*")
        ->from("candidato")
        //->where("status", 1)
        ->where("id_cliente", 2)
        ->where("eliminado", 0);

        $query = $this->db->get();
        return $query->num_rows();
    }
    function getHcl(){
        $this->db
        ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, est.id as idEstudios,est.primaria_periodo, est.primaria_escuela, est.primaria_ciudad, est.primaria_certificado, est.primaria_validada, est.secundaria_periodo, est.secundaria_escuela, est.secundaria_ciudad, est.secundaria_certificado, est.secundaria_validada, est.preparatoria_periodo, est.preparatoria_escuela, est.preparatoria_ciudad, est.preparatoria_certificado, est.preparatoria_validada, est.licenciatura_periodo, est.licenciatura_escuela, est.licenciatura_ciudad, est.licenciatura_certificado, est.licenciatura_validada, est.otros_certificados, est.comentarios, est.carrera_inactivo, global.law_enforcement, global.regulatory, global.sanctions, global.other_bodies, global.media_searches, global.usa_sanctions, global.oig, global.interpol, global.facis, global.bureau, global.european_financial, global.fda, global.sdn, global.global_comentarios, pro.nombre as proyecto,st.nombre as estudios, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, may.id as idMayores, may.id_tipo_studies, may.periodo, may.escuela, may.ciudad, may.certificado, may.comentarios as estudios_comentarios, check.id as idCheck, check.education, check.employment, check.address, check.criminal, check.global_database, check.identity, check.military, check.other, bgc.identidad_check, bgc.empleo_check, bgc.estudios_check, bgc.visita_check, bgc.penales_check, bgc.ofac_check, bgc.laboratorio_check, bgc.medico_check, bgc.oig_check, bgc.global_searches_check, bgc.domicilios_check, bgc.comentario_final, bgc.id as idBGC, verdoc.ine as custom_ine, verdoc.ine_ano as custom_ine_ano, verdoc.ine_vertical as custom_ine_vertical, verdoc.ine_institucion as custom_ine_institucion, verdoc.pasaporte as custom_pasaporte, verdoc.pasaporte_fecha as custom_pasaporte_fecha, verdoc.militar as custom_militar, verdoc.militar_fecha as custom_militar_fecha, verdoc.comentarios as custom_comentarios, bgc.creacion as fecha_final, bgc.tiempo, bgc.credito_check ")
        ->from('candidato as c')
        ->join('candidato_estudios as est','est.id_candidato = c.id',"left")
        ->join('candidato_global_searches as global','global.id_candidato = c.id',"left")
        ->join('tipo_studies as st','st.id = c.id_grado_estudio',"left")
        ->join('proyecto as pro','pro.id = c.id_proyecto')
        ->join('doping as dop','dop.id_candidato = c.id','left')
        ->join('verificacion_mayores_estudios as may','may.id_candidato = c.id',"left")
        ->join('verificacion_checklist as check','check.id_candidato = c.id',"left")
        ->join('candidato_bgc as bgc','bgc.id_candidato = c.id',"left")
        ->join('verificacion_documento as verdoc','verdoc.id_candidato = c.id',"left")
        ->where('c.id_cliente',2)
        ->where('c.eliminado', 0)
        ->order_by('c.status','ASC')
        ->order_by('c.nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    function getTataTotal(){
        $this->db
        ->select("c.id")
        ->from('candidato as c')
        ->join('candidato_pruebas as pru','pru.id_candidato = c.id',"left")
        ->where('c.id_cliente',3)
        ->where('c.eliminado', 0)
        ->where('c.status !=', 2)
        ->where('pru.socioeconomico', 1);

        $query = $this->db->get();
        return $query->num_rows();
    }
    function getTata(){
        $this->db
        ->select("c.*, c.nombre as candidato, pro.nombre as proyecto, CONCAT(u.nombre,' ',u.paterno) as analista, bgc.creacion as fecha_final, bgc.tiempo, bgc.id as idFinalizado")
        ->from('candidato as c')
        ->join('candidato_pruebas as pru','pru.id_candidato = c.id',"left")
        ->join('usuario as u','u.id = c.id_usuario',"left")
        ->join('proyecto as pro','pro.id = c.id_proyecto')
        ->join('candidato_bgc as bgc','bgc.id_candidato = c.id','left')
        ->where('c.id_cliente',3)
        ->where('c.eliminado', 0)
        ->where('c.status !=', 2)
        ->where('pru.socioeconomico', 1)
        ->where('c.fecha_alta >', '2020-11-11 00:00:00');
        
        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    function getWiproTotal(){
        $this->db
        ->select("c.*")
        ->from("candidato as c")
        ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
        //->where("status", 1)
        ->where("c.id_cliente", 77)
        ->where('pru.socioeconomico', 1)
        ->where("c.eliminado", 0);

        $query = $this->db->get();
        return $query->num_rows();
    }
    function getWipro(){
        $this->db
        ->select("c.*, c.nombre as candidato, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, pro.nombre as proyecto, pru.tipo_antidoping, v.id as idVisita, CONCAT(u.nombre,' ',u.paterno) as analista, sub.nombre as subcliente, bgc.comentario_final")
        ->from('candidato as c')
        ->join('candidato_pruebas as pru','pru.id_candidato = c.id')
        ->join('visita as v','v.id_candidato = c.id',"left")
        ->join('usuario as u','u.id = c.id_usuario',"left")
        ->join('proyecto as pro','pro.id = c.id_proyecto')
        ->join('doping as dop','dop.id_candidato = c.id','left')
        ->join('subcliente as sub','sub.id = c.id_subcliente','left')
        ->join('candidato_bgc as bgc','bgc.id_candidato = c.id','left')
        ->where('c.id_cliente',77)
        ->where('c.eliminado', 0)
        ->where('pru.socioeconomico', 1);

        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    function getClientesEspanol(){
        $this->db
        ->select("*")
        ->from('cliente')
        ->where('ingles', 0);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getEstados(){
        $this->db
        ->select('*')
        ->from('estado')
        ->order_by('nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    function getMunicipios($id_estado){
        $this->db
        ->select('id, nombre')
        ->from('municipio')
        ->where('id_estado', $id_estado)
        ->order_by('nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    
    
    
    function getSubclientes($id_cliente){
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
    function checkIngles($id_cliente){
        $this->db
        ->select("ingles")
        ->from('cliente')
        ->where('id',$id_cliente);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
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
        ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as nombreCompleto, est.id as idEstudios,est.primaria_periodo, est.primaria_escuela, est.primaria_ciudad, est.primaria_certificado, est.primaria_validada, est.secundaria_periodo, est.secundaria_escuela, est.secundaria_ciudad, est.secundaria_certificado, est.secundaria_validada, est.preparatoria_periodo, est.preparatoria_escuela, est.preparatoria_ciudad, est.preparatoria_certificado, est.preparatoria_validada, est.licenciatura_periodo, est.licenciatura_escuela, est.licenciatura_ciudad, est.licenciatura_certificado, est.licenciatura_validada, est.otros_certificados, est.comentarios, est.carrera_inactivo, sub.empresa as subcliente, bgc.creacion as fecha_bgc")
        ->from('candidato as c')
        ->join("subcliente as sub","sub.id = c.id_subcliente")
        ->join('candidato_estudios as est','est.id_candidato = c.id',"left")
        ->join('candidato_bgc as bgc','bgc.id_candidato = c.id','left')
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
        ->from("candidato as c")
        ->join("subcliente as sub","sub.id = c.id_subcliente")
        ->where("sub.id_cliente", $id_cliente)
        ->where('sub.id', $id_subcliente)
        ->where("c.eliminado", 0);

        $query = $this->db->get();
        return $query->num_rows();
    }
    function getCandidatosSubcliente($id_cliente, $id_subcliente){
        $this->db
        ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as nombreCompleto, est.id as idEstudios,est.primaria_periodo, est.primaria_escuela, est.primaria_ciudad, est.primaria_certificado, est.primaria_validada, est.secundaria_periodo, est.secundaria_escuela, est.secundaria_ciudad, est.secundaria_certificado, est.secundaria_validada, est.preparatoria_periodo, est.preparatoria_escuela, est.preparatoria_ciudad, est.preparatoria_certificado, est.preparatoria_validada, est.licenciatura_periodo, est.licenciatura_escuela, est.licenciatura_ciudad, est.licenciatura_certificado, est.licenciatura_validada, est.otros_certificados, est.comentarios, est.carrera_inactivo, sub.empresa as subcliente, bgc.creacion as fecha_bgc")
        ->from('candidato as c')
        ->join("subcliente as sub","sub.id = c.id_subcliente")
        ->join('candidato_estudios as est','est.id_candidato = c.id',"left")
        ->join('candidato_bgc as bgc','bgc.id_candidato = c.id','left')
        ->where('sub.id_cliente', $id_cliente)
        ->where('sub.id', $id_subcliente)
        ->order_by('c.status','ASC')
        ->order_by('c.nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    function getCandidatosCliente($id_cliente, $privacidad_candidato){
			
			$this->db
			->select(" c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as nombreCompleto, dop.fecha_resultado, dop.id as idDoping, dop.resultado as resultado_doping,sub.nombre as subcliente, pru.tipo_antidoping, sub.nombre as subcliente, pru.psicometrico, pru.medico, psi.id as idPsicometrico, psi.archivo, m.id as idMedico, m.imagen_historia_clinica as imagen, m.conclusion, m.descripcion,CS.proyecto, CS.tipo_conclusion,BECA.id as idBeca, BECA.archivo as archivoBeca ")
			->from('candidato as c')
			->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left')
			->join('subcliente as sub','sub.id = c.id_subcliente','left')
			->join('candidato_pruebas as pru','pru.id_candidato = c.id')
			->join('psicometrico as psi','c.id = psi.id_candidato','left')
			->join('medico as m','c.id = m.id_candidato','left')
      ->join('candidato_seccion as CS','c.id = CS.id_candidato','left')
      ->join('beca as BECA','c.id = BECA.id_candidato','left')
      ->where('c.id_cliente', $id_cliente)
			->where('c.eliminado', 0)
			->where('c.cancelado', 0)
      ->where('pru.socioeconomico', 1)
			->where_in('c.privacidad', $privacidad_candidato)
			->group_by('c.id');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
    function getTotalCandidatosCliente($id_cliente){
        $this->db
        ->select(" c.id")
        ->from('candidato as c')
        ->join('proyecto as pro','pro.id = c.id_proyecto','left')
        ->join('doping as dop','dop.id_candidato = c.id','left')
        ->join('candidato_estudios as est','est.id_candidato = c.id','left')
        ->join('candidato_antecedentes_sociales as soc','soc.id_candidato = c.id','left')
        ->join('candidato_ref_personal as per','per.id_candidato = c.id','left')
        ->join('candidato_antecedente_laboral as lab','lab.id_candidato = c.id','left')
        ->join('verificacion_legal as leg','leg.id_candidato = c.id','left')
        ->join('puesto as p','p.id = c.id_puesto')
        ->join('subcliente as sub','sub.id = c.id_subcliente')
        ->join('candidato_seccion as CS','c.id = CS.id_candidato','left')
        ->where('c.id_cliente', $id_cliente)
        ->where('c.eliminado', 0)
        ->where('c.cancelado', 0);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getUsuario($id){
			$this->db
			->select('privacidad')
			->from('usuario_cliente')
			->where('id', $id);

			$consulta = $this->db->get();
			$resultado = $consulta->row();
			return $resultado;
    }
    
    function getPaqueteSubclienteProyecto($id_cliente, $id_proyecto){
        $this->db
        ->select('paq.*')
        ->from('cliente_doping as cl')
        ->join('antidoping_paquete as paq','paq.id = cl.id_antidoping_paquete')
        ->where('cl.id_cliente', $id_cliente)
        ->where('cl.id_subcliente', 0)
        ->where('cl.id_proyecto', $id_proyecto)
        ->where('cl.status', 1);

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
        ->where('cl.id', $id_cliente);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function getTiposStudies(){
        $this->db
        ->select('*')
        ->from('tipo_studies');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getClientByName($name){
      $this->db
      ->select('*')
      ->from('cliente')
      ->where('nombre', $name)
      ->or_where('razon_social', $name);

      $consulta = $this->db->get();
      return $consulta->row();
    }
    

    /*********************************************************** ESCUELAS ***************************************************************/
    
       
  
}