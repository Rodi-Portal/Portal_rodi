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

  


  function getRequisicionesFinalizadasPorMes(){
    date_default_timezone_set('America/Mexico_City');
    $year = date('Y');
    $cantidades = array(); // Array para almacenar la cantidad de requisiciones por mes

    for($i = 1; $i <= 12; $i++){
        $cantidad = $this->estadistica_model->getRequisicionesFinalizadasPorMeses($year, $i);
        $cantidades[] = $cantidad; // Almacena la cantidad de requisiciones finalizadas para el mes $i
    }

    echo json_encode($cantidades); // Devuelve el array en formato JSON
}



function getEstadisticaReclutadoras(){
  date_default_timezone_set('America/Mexico_City');
  $year = date('Y');
  $reclutadores = $this->estadistica_model->obtenerReclutadores();

  // Agrega más datos a cada reclutador
  foreach ($reclutadores as &$reclutador) {
   
      // Aquí puedes agregar más datos a cada reclutador
      $fechaInicio = $this->input->get('fechaInicio');
      $fechaFin = $this->input->get('fechaFin');
        
        // Si no se especificaron fechas, establecer un rango predeterminado
        if (empty($fechaInicio) || empty($fechaFin)) {
            // Establecer el rango predeterminado (por ejemplo, los últimos 30 días)
            $fechaFin = date('Y-m-d H:i:s'); // Fecha actual con horas, minutos y segundos
            $fechaInicio = date('Y-m-d H:i:s', strtotime('-30 days', strtotime($fechaFin)));
          }


          /*----------------------------------------*/
        /* Requisiciones  canceladas grafica
        /*----------------------------------------*/
        $requisicionCanceladaPorUsuario = $this->estadistica_model->obtenerRequisicionesCanceladasPorUsuario($fechaInicio, $fechaFin, $reclutador->id);

        $reclutador->requisicionesCanceladas = $requisicionCanceladaPorUsuario;
         /*----------------------------------------*/
        /* Requisiciones  Asignadas a  reclutador grafica
        /*----------------------------------------*/
        // Llamar al método del modelo con las fechas seleccionadas
        $requisicionesPorUsuario = $this->estadistica_model->obtenerRequisicionesPorUsuario($fechaInicio, $fechaFin, $reclutador->id);

      $reclutador->requisicionesAsignadas = $requisicionesPorUsuario;

     
         /*----------------------------------------*/
        /* Requisiciones  Finalizadas grafica
        /*----------------------------------------*/
        $requisicionFinalizadaPorUsuario = $this->estadistica_model->obtenerRequisicionesFinalizadasPorUsuario($fechaInicio, $fechaFin, $reclutador->id);

      $reclutador->requisicionesFinalizadas = $requisicionFinalizadaPorUsuario;

   


      /*----------------------------------------*/
        /* Requisiciones  SLA grafica
        /*----------------------------------------*/
        $slaPorUsuario = $this->estadistica_model->obtenerPromedioSLAPorUsuarioYFecha($fechaInicio, $fechaFin, $reclutador->id);

      $reclutador->sla = $slaPorUsuario;
     
      // Agrega tantos datos como necesites
  }

  // Devuelve la respuesta como JSON
  header('Content-Type: application/json');
  echo json_encode($reclutadores);
}

public function contarMediosContacto() {
  // Verificar si se han proporcionado fechas


  // Si no se proporciona ninguna fecha, obtener todos los aspirante
  $fechaInicio = $this->input->get('fechaInicio');
  $fechaFin = $this->input->get('fechaFin');
    
    // Si no se especificaron fechas, establecer un rango predeterminado
    if (empty($fechaInicio) || empty($fechaFin)) {
        // Establecer el rango predeterminado (por ejemplo, los últimos 30 días)
        $fechaFin = date('Y-m-d H:i:s'); // Fecha actual con horas, minutos y segundos
        $fechaInicio = date('Y-m-d H:i:s', strtotime('-30 days', strtotime($fechaFin)));
      }
      $aspirantes = $this->estadistica_model->obtenerAspirantesPorRangoFecha($fechaInicio, $fechaFin);

  // Inicializa un array para almacenar la frecuencia de cada medio de contacto
  $frecuencia_medios = array();

  // Itera sobre los aspirantes para contar la frecuencia de cada medio de contacto
  foreach ($aspirantes as $aspirante) {
      $medio_contacto = $aspirante->medio_contacto;
      // Incrementa la frecuencia del medio de contacto
      if (isset($frecuencia_medios[$medio_contacto])) {
          $frecuencia_medios[$medio_contacto]++;
      } else {
          $frecuencia_medios[$medio_contacto] = 1;
      }
  }

  // Prepara los datos para la gráfica
  $labels = array_keys($frecuencia_medios);
  $data = array_values($frecuencia_medios);

  // Prepara la respuesta como un array asociativo
  $response = array(
      'labels' => $labels,
      'data' => $data
  );

  // Envía la respuesta como JSON
  header('Content-Type: application/json');
  echo json_encode($response);
}

function getRequisicionesProcesoPorMes(){
  date_default_timezone_set('America/Mexico_City');
  $year = date('Y');
  $cantidades = array(); // Array para almacenar la cantidad de requisiciones por mes

  for($i = 1; $i <= 12; $i++){
      $cantidad = $this->estadistica_model->getRequisicionesProcesoPorMes($year, $i);
      $cantidades[] = $cantidad; // Almacena la cantidad de requisiciones finalizadas para el mes $i
  }

  echo json_encode($cantidades); // Devuelve el array en formato JSON
}

function getAspirantesProcesoPorMes(){
  date_default_timezone_set('America/Mexico_City');
  $year = date('Y');
  $cantidades = array(); // Array para almacenar la cantidad de requisiciones por mes

  for($i = 1; $i <= 12; $i++){
      $cantidad = $this->estadistica_model->getAspirantesProcesoPorMes($year, $i);
      $cantidades[] = $cantidad; // Almacena la cantidad de requisiciones finalizadas para el mes $i
  }

  echo json_encode($cantidades); // Devuelve el array en formato JSON
}


function getRequisicionesCanceladasPorMes(){
  date_default_timezone_set('America/Mexico_City');
  $year = date('Y');
  $cantidades = array(); // Array para almacenar la cantidad de requisiciones por mes

  for($i = 1; $i <= 12; $i++){
      $cantidad = $this->estadistica_model->getRequisicionesCanceladasPorMeses($year, $i);
      $cantidades[] = $cantidad; // Almacena la cantidad de requisiciones finalizadas para el mes $i
  }

  echo json_encode($cantidades); // Devuelve el array en formato JSON
}


function getRequisicionesenProcesoPorMes(){
  date_default_timezone_set('America/Mexico_City');
  $year = date('Y');
  $cantidades = array(); // Array para almacenar la cantidad de requisiciones por mes

  for($i = 1; $i <= 12; $i++){
      $cantidad = $this->estadistica_model->getRequisicionesFinalizadasPorMeses($year, $i);
      $cantidades[] = $cantidad; // Almacena la cantidad de requisiciones finalizadas para el mes $i
  }

  echo json_encode($cantidades); // Devuelve el array en formato JSON
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