<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcliente_panel_model extends CI_Model{

  function existeCandidato($nombre, $paterno, $materno, $id_cliente, $id_subcliente){
    $this->db
    ->select('C.id')
    ->from('candidato as C')
    ->join('candidato_pruebas as P','P.id_candidato = C.id')
    ->where('C.nombre', $nombre)
    ->where('C.paterno', $paterno)
    ->where('C.materno', $materno)
    ->where('C.id_cliente', $id_cliente)
    ->where('C.id_subcliente', $id_subcliente)
    ->where_in('C.status', [0,1])
    ->where('P.socioeconomico', 1)
    ->where('C.eliminado', 0);

    $query = $this->db->get();
    return $query->num_rows();
  }
}