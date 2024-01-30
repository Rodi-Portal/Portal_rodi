<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Referencia_cliente_model extends CI_Model{

  function getById($id_candidato){
    $this->db
    ->select('*')
    ->from('referencia_cliente')
    ->where('id_candidato', $id_candidato)
    ->order_by('numero_referencia','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{ 
      return FALSE;
    }
  }
  function countByIdCandidato($id_candidato){
    $this->db
    ->select('id')
    ->from('referencia_cliente')
    ->where('id_candidato', $id_candidato);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function store($data){
    $this->db->insert('referencia_cliente', $data);
    $id = $this->db->insert_id();
    return  $id;
  }
  function update($data, $id_ref){
    $this->db
    ->where('id', $id_ref)
    ->update('referencia_cliente', $data);
  }
  function delete($id){
    $this->db
    ->where('id', $id)
    ->delete('referencia_cliente');
  }
  function updateByNumero($id_candidato, $numeroActual, $nuevoNumero){
    $this->db
    ->set('numero_referencia', $nuevoNumero)
    ->where('numero_referencia', $numeroActual)
    ->where('id_candidato', $id_candidato)
    ->update('referencia_cliente');
  }
}