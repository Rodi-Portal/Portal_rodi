<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Estadistica extends CI_Controller{

	function __construct(){
		parent::__construct();
	}

  function getCandidatosFinalizadosPorMeses(){
    date_default_timezone_set('America/Mexico_City');
    $year = date('Y');
    //ESE Finalizados actualmente
    for($i = 1; $i <= 12; $i++){
      $cantidad = $this->estadistica_model->getCandidatosFinalizadosporMeses($year, $i);
      //$cantidades[] = $cantidad;
      $acum = 0;
      //ESE historial, indicando que se tuvo finalizados y regresaron su estatus
      $data['historial'] = $this->estadistica_model->getHistorialCandidatos();
      if($data['historial']){
        foreach($data['historial'] as $row){
          $aux = explode('/', $row->fecha_alta);
          $alta = $aux[2].'-'.$aux[1].'-'.$aux[0];
          $nueva_fecha = date("Y-m-d",strtotime($alta."+ ".$row->tiempo_proceso." days")); 
          $numMes = date("n", strtotime($nueva_fecha));
          $numAnio = date("Y", strtotime($nueva_fecha));
          if($year == $numAnio){
            if($i == $numMes){
              $acum++;
            }
          }
        }
      }
      $cantidades[] = $cantidad + $acum;
    }
    echo json_encode($cantidades);
  }
  function getCandidatosFinalizadosPorMesesPorAnalista(){
    date_default_timezone_set('America/Mexico_City');
    $year = date('Y');
    $id_usuario = $this->session->userdata('id');
    $usuario = $this->funciones_model->getTipoAnalista($id_usuario);
    if($usuario->tipo_analista == 1){
      //ESE Finalizados actualmente
      for($i = 1; $i <= 12; $i++){
        $cantidad = $this->estadistica_model->getCandidatosFinalizadosEspanol($year, $i, $id_usuario);
        //$cantidades[] = $cantidad;
        $acum = 0;
        //ESE historial, indicando que se tuvo finalizados y regresaron su estatus
        $data['historial'] = $this->estadistica_model->getHistorialCandidatosPorAnalista($id_usuario);
        if($data['historial']){
          foreach($data['historial'] as $row){
            $aux = explode('/', $row->fecha_alta);
            $alta = $aux[2].'-'.$aux[1].'-'.$aux[0];
            $nueva_fecha = date("Y-m-d",strtotime($alta."+ ".$row->tiempo_proceso." days")); 
            $numMes = date("n", strtotime($nueva_fecha));
            $numAnio = date("Y", strtotime($nueva_fecha));
            if($year == $numAnio){
              if($i == $numMes){
                $acum++;
              }
            }
          }
        }
        $cantidades[] = $cantidad + $acum;
      }
    }
    if($usuario->tipo_analista == 2){
      //ESE Finalizados actualmente
      for($i = 1; $i <= 12; $i++){
        $cantidad = $this->estadistica_model->getCandidatosFinalizadosIngles($year, $i, $id_usuario);
        $cantidades[] = $cantidad;
      }
    }
    if($usuario->tipo_analista == 3){
      //ESE Finalizados actualmente en Español
      for($i = 1; $i <= 12; $i++){
        $cantidad = $this->estadistica_model->getCandidatosFinalizadosEspanol($year, $i, $id_usuario);
        //$cantidades[] = $cantidad;
        $acum = 0;
        //ESE historial, indicando que se tuvo finalizados y regresaron su estatus
        $data['historial'] = $this->estadistica_model->getHistorialCandidatosPorAnalista($id_usuario);
        if($data['historial']){
          foreach($data['historial'] as $row){
            $aux = explode('/', $row->fecha_alta);
            $alta = $aux[2].'-'.$aux[1].'-'.$aux[0];
            $nueva_fecha = date("Y-m-d",strtotime($alta."+ ".$row->tiempo_proceso." days")); 
            $numMes = date("n", strtotime($nueva_fecha));
            $numAnio = date("Y", strtotime($nueva_fecha));
            if($year == $numAnio){
              if($i == $numMes){
                $acum++;
              }
            }
          }
        }
        //ESE Finalizados actualmente Ingles
        $cantidad2 = $this->estadistica_model->getCandidatosFinalizadosIngles($year, $i, $id_usuario);

        //Sumatoria
        $cantidades[] = $cantidad + $acum + $cantidad2;
      }
    }
    echo json_encode($cantidades);
  }
  function getEstatusCandidatosPorAnalista(){
    date_default_timezone_set('America/Mexico_City');
    $id_usuario = $this->session->userdata('id');
    $usuario = $this->funciones_model->getTipoAnalista($id_usuario);
    //Candidatos actuales en tabla candidato
    $positivos = $this->estadistica_model->getCantidadEstatusCandidatos($id_usuario, 1);
    $negativos = $this->estadistica_model->getCantidadEstatusCandidatos($id_usuario, 2);
    $consideracion = $this->estadistica_model->getCantidadEstatusCandidatos($id_usuario, 3);
    $extra_positivos = $this->estadistica_model->getCantidadEstatusCandidatosHistorial($id_usuario, 'POSITIVO');
    $extra_negativos = $this->estadistica_model->getCantidadEstatusCandidatosHistorial($id_usuario, 'NEGATIVO');
    $extra_consideracion = $this->estadistica_model->getCantidadEstatusCandidatosHistorial($id_usuario, 'A CONSIDERACION');
    $total_positivos = $positivos + $extra_positivos;
    $totales[] = $total_positivos;
    $total_negativos = $negativos + $extra_negativos;
    $totales[] = $total_negativos;
    $total_considerados = $consideracion  + $extra_consideracion;
    $totales[] = $total_considerados;
    echo json_encode($totales);
  }
}