<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion_model extends CI_Model{

	function getPaquetesAntidoping(){
		$this->db
	    ->select('*')
	    ->from('antidoping_paquete')
	    ->order_by('nombre','ASC');

	    $query = $this->db->get();
	    if($query->num_rows() > 0){
	    	return $query->result();
	    }else{
	      	return FALSE;
	    }
	}
	function getSustanciasAntidoping(){
		$this->db
	    ->select('*')
	    ->from('antidoping_sustancia')
	    ->order_by('id','ASC');

	    $query = $this->db->get();
	    if($query->num_rows() > 0){
	    	return $query->result();
	    }else{
	      	return FALSE;
	    }
	}
	
	function getBateriaPsicometrica($puesto){
		$this->db
	    ->select('bateria.*')
	    ->from('psicometrico_bateria as bateria')
	    ->join('puesto as pu','pu.id = bateria.id_puesto')
	    ->where('pu.id', $puesto);

	    $query = $this->db->get();
	    if($query->num_rows() > 0){
	    	return $query->result();
	    }else{
	      	return FALSE;
	    }
	}
	function getPruebasPsicometricas(){
		$this->db
	    ->select('*')
	    ->from('psicometrico_prueba')
	    ->order_by('id','ASC');

	    $query = $this->db->get();
	    if($query->num_rows() > 0){
	    	return $query->result();
	    }else{
	      	return FALSE;
	    }
	}
	function getDatosBuroCredito(){
		$this->db
	    ->select('*')
	    ->from('tipo_buro_credito')
	    ->order_by('id','ASC');

	    $query = $this->db->get();
	    if($query->num_rows() > 0){
	    	return $query->result();
	    }else{
	      	return FALSE;
	    }
	}
	function countPaquetesAntidoping(){
		$this->db
	    ->select('*')
	    ->from('antidoping_paquete')
	    ->where('status', 1)
	    ->where('eliminado', 0);

	    $query = $this->db->get();
	    return $query->num_rows();
	}
	function countSustanciasAntidoping(){
		$this->db
	    ->select('*')
	    ->from('antidoping_sustancia')
	    ->where('status', 1)
	    ->where('eliminado', 0);

	    $query = $this->db->get();
	    return $query->num_rows();
	}
	function countBateriasPsicometrico(){
		$this->db
	    ->select('*')
	    ->from('psicometrico_bateria')
	    ->where('status', 1)
	    ->where('eliminado', 0);

	    $query = $this->db->get();
	    return $query->num_rows();
	}
	function countPruebasPsicometrico(){
		$this->db
	    ->select('*')
	    ->from('psicometrico_prueba')
	    ->where('status', 1)
	    ->where('eliminado', 0);

	    $query = $this->db->get();
	    return $query->num_rows();
	}
	function countBuroCredito(){
		$this->db
	    ->select('*')
	    ->from('tipo_buro_credito')
	    ->where('status', 1)
	    ->where('eliminado', 0);

	    $query = $this->db->get();
	    return $query->num_rows();
	}
}