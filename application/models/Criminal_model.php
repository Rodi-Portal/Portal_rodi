<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Criminal_model extends CI_Model{

  function __construct(){
		parent::__construct();
    
	}
  function getVerificacion($id_candidato){
    $this->db
    ->select('*')
    ->from('verificacion_penales')
    ->where('id_candidato',$id_candidato);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getDetalleVerificacion($id_candidato){
    $this->db
    ->select('D.*')
    ->from('verificacion_penales_detalle as D')
    ->join('verificacion_penales as V','V.id = D.id_verificacion_penales')
    ->where('V.id_candidato',$id_candidato);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
}