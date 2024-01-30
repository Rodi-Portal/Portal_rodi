<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Candidato_Seccion extends CI_Controller{

  function __construct(){
    parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
  }

  function getSeccion($id){
    $id = $this->input->post('id');
    $res = $this->candidato_seccion_model->getSecciones($id);
    if($res != null){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }
  function getHistorialProyectosByCliente(){
    // //TODO: Cambiar la restriccion de los procesos previos para el registro de candidatos con respecto al id_cliente
    // if($this->input->post('id_cliente') == 16){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') == 159){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') == 172){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') == 5){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') == 178){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') == 51){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') == 201){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') == 205){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') == 33){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') == 211){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') == 221){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') == 229){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') == 232){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') == 96){
    //   $id_cliente = $this->input->post('id_cliente');
    // }
    // if($this->input->post('id_cliente') != 16 && $this->input->post('id_cliente') != 159 && $this->input->post('id_cliente') != 172 && $this->input->post('id_cliente') != 5 && $this->input->post('id_cliente') != 178 && $this->input->post('id_cliente') != 51 && $this->input->post('id_cliente') != 201 && $this->input->post('id_cliente') != 205 && $this->input->post('id_cliente') != 33 && $this->input->post('id_cliente') != 211 && $this->input->post('id_cliente') != 221 && $this->input->post('id_cliente') != 229 && $this->input->post('id_cliente') != 232 && $this->input->post('id_cliente') != 96){
    //   $id_cliente = 0;
    // }
    $previos = $this->candidato_seccion_model->getHistorialProyectosByCliente($this->input->post('id_cliente'));
    if(!empty($previos)){
      $salida = "<option value='0'>Select</option>";
      foreach($previos as $prev){
        $salida .= '<option value="'.$prev->id.'">'.$prev->proyecto.'</option>';
      }
    }
    else{
      //$salida = "<option value='0'>N/A</option>";
      $previos = $this->candidato_seccion_model->getHistorialProyectosByCliente(0);
      $salida = "<option value='0'>Select</option>";
      foreach($previos as $prev){
        $salida .= '<option value="'.$prev->id.'">'.$prev->proyecto.'</option>';
      }
    }
    echo $salida;
  }
  function getDetallesProyectoPrevio(){
    $id_previo = $this->input->post('id_previo');
    $seccion = $this->candidato_model->getProyectoPrevio($id_previo);
    $res = '<ul>';
    $res .= ($seccion->id_seccion_datos_generales != NULL || $seccion->lleva_identidad == 1)? '<li>Datos generales / Verificación de identidad</li>':'';
    $res .= ($seccion->lleva_estudios == 1)? '<li>Verificación de estudios académicos</li>':'';
    $res .= ($seccion->lleva_sociales == 1)? '<li>Antecedentes sociales</li>':'';
    $res .= ($seccion->cantidad_ref_personales > 0)? '<li>Referencias personales: '.$seccion->cantidad_ref_personales.'</li>':'';
    $res .= ($seccion->lleva_empleos == 1)? '<li>Referencias laborales</li>':'';
    $res .= ($seccion->id_referencia_cliente != 0)? '<li>Referencias de clientes</li>':'';
    $res .= ($seccion->lleva_gaps == 1)? '<li>GAPS (periodos inactivos)</li>':'';
    $res .= ($seccion->cantidad_ref_profesionales > 0)? '<li>Referencias profesionales: '.$seccion->cantidad_ref_profesionales.'</li>':'';
    $res .= ($seccion->lleva_investigacion == 1)? '<li>Investigación legal</li>':'';
    $res .= ($seccion->lleva_no_mencionados == 1)? '<li>Trabajos no mencionados</li>':'';
    $res .= ($seccion->id_seccion_verificacion_docs != null)? '<li>Documentación</li>':'';
    $res .= ($seccion->lleva_familiares == 1)? '<li>Grupo familiar</li>':'';
    $res .= ($seccion->lleva_egresos == 1)? '<li>Ingresos y egresos</li>':'';
    $res .= ($seccion->lleva_vivienda == 1)? '<li>Habitación y medio ambiente</li>':'';
    $res .= ($seccion->cantidad_ref_vecinales > 0)? '<li>Referencias vecinales: '.$seccion->cantidad_ref_vecinales.'</li>':'';
    $res .= ($seccion->lleva_criminal == 1)? '<li>Verificación criminal</li>':'';
    $res .= ($seccion->lleva_domicilios == 1)? '<li>Historial de domicilios</li>':'';
    $res .= ($seccion->lleva_credito == 1)? '<li>Historial crediticio</li>':'';
    $res .= ($seccion->lleva_prohibited_parties_list == 1)? '<li>Verificación Prohibited Parties List</li>':'';
    $res .= '</ul>';
    echo $res;
  }
  
}