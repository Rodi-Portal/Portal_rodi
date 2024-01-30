<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rol_model extends CI_Model{

  function getMenu($id_rol){
    $this->db
    ->select('*')
    ->from('rol_menu')
    ->where('id_rol', $id_rol)
    ->order_by('id','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }

}