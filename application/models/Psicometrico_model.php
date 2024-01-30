<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Psicometrico_model extends CI_Model{

    
    
    function getAnalisis($id_candidato){
        $this->db
        ->select('m.*, c.fecha_nacimiento, c.genero')
        ->from('medico as m')
        ->join("candidato as c","m.id_candidato = c.id")
        ->where('m.id_candidato', $id_candidato);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    
}