<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requisicion_model extends CI_Model{
	function guardar($req){
		$this->db->insert('requisicion', $req);
	}
}