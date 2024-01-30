<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Domicilio_model extends CI_Model{

  function __construct(){
		parent::__construct();
    
	}

  function getById($id){
    $this->db 
    ->select('D.*,E.nombre as estado,M.nombre as municipio')
    ->from('candidato_domicilio as D')
    ->join('estado as E','E.id = D.id_estado','left')
    ->join('municipio as M','M.id = D.id_municipio','left')
    ->where('D.id_candidato', $id)
    ->order_by('id','DESC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function countByIdCandidato($id){
    $this->db
    ->select('id')
    ->from('candidato_domicilio')
    ->where('id_candidato', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function check($id){
    $this->db
    ->select('id')
    ->from('candidato_domicilio')
    ->where('id_candidato', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function add($data){
    $this->db->insert('candidato_domicilio', $data);
    $id = $this->db->insert_id();
    return  $id;
  }
  function edit($data, $id_persona){
    $this->db
    ->where('id', $id_persona)
    ->update('candidato_domicilio', $data);
  }
  function delete($id){
    $this->db
    ->where('id', $id)
    ->delete('candidato_domicilio');
  }
  function getIntegrantesDomicilio($id){
    $this->db 
    ->select('CP.*,P.nombre as parentesco,ESC.nombre as escolaridad')
    ->from('candidato_domicilio as CP')
    ->join('tipo_parentesco as P','P.id = CP.id_tipo_parentesco')
    ->join('tipo_escolaridad as ESC','ESC.id = CP.id_grado_estudio')
    ->where('P.eliminado', 0)
    ->where('CP.misma_vivienda', 1)
    ->where('CP.id_candidato', $id)
    ->group_by('CP.id_tipo_parentesco');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
}