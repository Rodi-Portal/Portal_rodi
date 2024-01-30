<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_conclusion_model extends CI_Model{

  function __construct(){
		parent::__construct();
	}

  /*----------------------------------------*/
  /*  #Finalizado 
  /*----------------------------------------*/
  function getFinalizadoById($id){
    $this->db 
    ->select('*')
    ->from('candidato_finalizado')
    ->where('id_candidato', $id);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function checkFinalizado($id){
    $this->db
    ->select('id')
    ->from('candidato_finalizado')
    ->where('id_candidato', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function addFinalizado($data){
    $this->db->insert('candidato_finalizado', $data);
  }
  function editFinalizado($data, $id_candidato){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->update('candidato_finalizado', $data);
  }
  /*----------------------------------------*/
  /*  #BGC/BGV 
  /*----------------------------------------*/
  function getBGCById($id){
    $this->db 
    ->select('C.id,C.status_bgc,BGC.*')
    ->from('candidato as C')
    ->join('candidato_bgc as BGC','BGC.id_candidato = C.id')
    ->where('id_candidato', $id);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function checkBGC($id){
    $this->db
    ->select('id')
    ->from('candidato_bgc')
    ->where('id_candidato', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function addBGC($data){
    $this->db->insert('candidato_bgc', $data);
  }
  function editBGC($data, $id_candidato){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->update('candidato_bgc', $data);
  }
  function setBGC($status_bgc, $id_candidato){
    $this->db
    ->set('status',2)
    ->set('status_bgc',$status_bgc)
    ->where('id', $id_candidato)
    ->update('candidato');
  }
}