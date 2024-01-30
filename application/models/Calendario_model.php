<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendario_model extends CI_Model{

    function getRequisicionesTotal(){
        $this->db
        ->select("*")
        ->from("requisicion")
        //->where("status", 1)
        ->where("eliminado", 0);

        $query = $this->db->get();
        return $query->num_rows();
    }
    function getVisitas(){
        $this->db
        ->select("v.*")
        ->from('visita as v');
        /*->join('cliente as cliente','cliente.id = r.id_cliente')
        ->join('tipo_pago as pago','pago.id = r.id_tipo_pago',"left")
        ->join('tipo_escolaridad as escolaridad','escolaridad.id = r.id_tipo_escolaridad',"left")
        ->join('tipo_nivel_escolar as nivel','nivel.id = r.id_tipo_nivel_escolar',"left")
        ->join('genero as genero','genero.id = r.id_genero',"left")
        ->join('tipo_licencia as licencia','licencia.id = r.id_tipo_licencia',"left")
        ->join('tipo_discapacidad as discapacidad','discapacidad.id = r.id_tipo_discapacidad',"left")
        ->join('tipo_causa_vacante as causa','causa.id = r.id_tipo_causa_vacante',"left")
        ->join('tipo_jornada as jornada','jornada.id = r.id_tipo_jornada',"left")
        ->join('tipo_sueldo as sueldo','sueldo.id = r.id_tipo_sueldo',"left")
        ->join('subtipo_sueldo as subtipo','subtipo.id = r.sueldo_variable',"left")
        ->join('tipo_prestaciones as prestaciones','prestaciones.id = r.id_tipo_prestaciones',"left")*/
        //->where('c.eliminado', 0)
        //->order_by('v.status','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getTiposPago(){
        $this->db
        ->select('*')
        ->from('tipo_pago')
        ->order_by('nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getEscolaridades(){
        $this->db
        ->select('*')
        ->from('tipo_escolaridad')
        ->order_by('id','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getNivelesEscolares(){
        $this->db
        ->select('*')
        ->from('tipo_nivel_escolar')
        ->order_by('id','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getGeneros(){
        $this->db
        ->select('*')
        ->from('genero')
        ->order_by('id','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getCiviles(){
        $this->db
        ->select('*')
        ->from('estado_civil')
        ->order_by('nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getLicencias(){
        $this->db
        ->select('*')
        ->from('tipo_licencia')
        ->order_by('nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getDiscapacidades(){
        $this->db
        ->select('*')
        ->from('tipo_discapacidad')
        ->order_by('nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getCausas(){
        $this->db
        ->select('*')
        ->from('tipo_causa_vacante')
        ->order_by('nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getJornadas(){
        $this->db
        ->select('*')
        ->from('tipo_jornada')
        ->order_by('nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getSueldos(){
        $this->db
        ->select('*')
        ->from('tipo_sueldo')
        ->order_by('nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getSueldoVariables($sueldo){
        $this->db
        ->select('*')
        ->from('subtipo_sueldo')
        ->where('id_tipo_sueldo', $sueldo)
        ->order_by('nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getPrestaciones(){
        $this->db
        ->select('*')
        ->from('tipo_prestaciones')
        ->order_by('id','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function matchCliente($term){
        $this->db
        ->select('id, nombre')
        ->from('cliente')
        ->where("status", 1)
        ->where("eliminado", 0)
        ->like("nombre", $term, 'after')
        ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
              $new_row['value'] = $row['id'];
              $new_row['label'] = $row['nombre'];
              $row_set[] = $new_row; //build an array
            }
            return $row_set; //format the array into json data
        }
    }
    function getCompetencias(){
        $this->db
        ->select('*')
        ->from('tipo_competencia')
        ->order_by('id','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getDatosCliente($id_cliente){
        $this->db
        ->select('*')
        ->from('cliente')
        ->where('id', $id_cliente);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function updateCliente($cliente, $id_cliente){
        $this->db
        ->where('id', $id_cliente)
        ->update('cliente', $cliente);
    }
    function crearRequisicion($requisicion){
        $this->db->insert('requisicion', $requisicion);
        $id = $this->db->insert_id();
        return  $id;
    }
    function insertRequisito($requisito){
        $this->db->insert('requisicion_requisito', $item);
    }
    function insertHabilidades($item){
        $this->db->insert('requisicion_habilidades', $item);
    }
    function insertIdiomas($item){
        $this->db->insert('requisicion_idiomas', $item);
    }
    function insertCompetencia($numero, $id_requisicion){
        $this->db
        ->set('id_requisicion',$id_requisicion)
        ->set('id_tipo_competencia',$numero)
        ->insert('requisicion_competencias');
    }
}