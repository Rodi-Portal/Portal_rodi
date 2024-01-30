<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_estudio_model extends CI_Model{

  function __construct(){
		parent::__construct();
    
	}
  /*----------------------------------------*/
  /*  #Historial 
  /*----------------------------------------*/
  function getHistorialById($id){
    $this->db 
    ->select('*')
    ->from('candidato_estudios')
    ->where('id_candidato', $id);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function checkHistorial($id){
    $this->db
    ->select('id')
    ->from('candidato_estudios')
    ->where('id_candidato', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function addHistorial($data){
    $this->db->insert('candidato_estudios', $data);
  }
  function editHistorial($data, $id_candidato){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->update('candidato_estudios', $data);
  }
  function countByIdCandidatoEstudio($id_candidato){
    $this->db
    ->select('id')
    ->from('candidato_estudios')
    ->where('id_candidato', $id_candidato);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  /*----------------------------------------*/
  /*  #Mayores 
  /*----------------------------------------*/
  function getMayorById($id){
    $this->db 
    ->select('V.*,C.id_grado_estudio,C.estudios_periodo,C.estudios_escuela,C.estudios_ciudad,C.estudios_certificado,GR.nombre as grado_estudio')
    ->from('candidato as C')
    ->join('verificacion_mayores_estudios as V','C.id = V.id_candidato','left')
		->join('grado_estudio as GR','GR.id = V.id_tipo_studies','left')
    ->where('C.id', $id);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function countByIdCandidato($id_candidato){
    $this->db
    ->select('id')
    ->from('verificacion_mayores_estudios')
    ->where('id_candidato', $id_candidato);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function checkMayor($id){
    $this->db
    ->select('id')
    ->from('verificacion_mayores_estudios')
    ->where('id_candidato', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function addMayor($data){
    $this->db->insert('verificacion_mayores_estudios', $data);
  }
  function editMayor($data, $id_candidato){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->update('verificacion_mayores_estudios', $data);
  }
  /*----------------------------------------*/
  /*  #Verificacion Documento Estudios 
  /*----------------------------------------*/
  function getVerificacion($id_candidato){
    $this->db
    ->select('*')
    ->from('verificacion_estudios')
    ->where('id_candidato',$id_candidato);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getDetalleVerificacion($id_candidato){
    $this->db
    ->select('D.*')
    ->from('verificacion_estudios_detalle as D')
    ->join('verificacion_estudios as V','V.id = D.id_verificacion_estudio')
    ->where('V.id_candidato',$id_candidato);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
}