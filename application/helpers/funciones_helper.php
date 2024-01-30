<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function fecha_ingles_bd($date){
	$aux = explode('/', $date);
	$fecha = $aux[2].'-'.$aux[0].'-'.$aux[1];
	return $fecha;
}
function fecha_espanol_bd($date){
	$aux = explode('/', $date);
    $fecha = $aux[2].'-'.$aux[1].'-'.$aux[0];
    return $fecha;
}
function fecha_espanol_frontend($date){
    $aux = explode('-', $date);
    $fecha = $aux[2].'/'.$aux[1].'/'.$aux[0];
    return $fecha;
}
function fecha_ingles_usuario($date){
  $aux = explode('-', $date);
  $fecha = $aux[1].'/'.$aux[2].'/'.$aux[0];
  return $fecha;
}
function fecha_sinhora_espanol_bd($date){
    $f = explode(' ', $date);
    $aux = explode('-', $f[0]);
    $fecha = $aux[2].'/'.$aux[1].'/'.$aux[0];
    return $fecha;
}
function fecha_hora_espanol_bd($date){
    $time = explode(' ', $date);
    $aux = explode('/', $time[0]);
    $fecha = $aux[2].'-'.$aux[1].'-'.$aux[0].' '.$time[1].':00';
    return $fecha;
}
function fecha_hora_ingles_front($date){
    $time = explode(' ', $date);
    $aux = explode('-', $time[0]);
    $fecha = $aux[1].'/'.$aux[2].'/'.$aux[0].' '.$time[1].':00';
    return $fecha;
}
function fecha_h_i_ingles($date){
    $time = explode(' ', $date);
    $aux = explode('-', $time[0]);
    $aux2 = explode(':', $time[1]);
    $fecha = $aux[1].'/'.$aux[2].'/'.$aux[0].' '.$aux2[0].':'.$aux2[1];
    return $fecha;
}
function fecha_sinhora_ingles_front($date){
    $f = explode(' ', $date);
    $aux = explode('-', $f[0]);
    $fecha = $aux[1].'/'.$aux[2].'/'.$aux[0];
    return $fecha;
}
function calculaEdad($fechanacimiento){
    list($ano,$mes,$dia) = explode("-",$fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($mes_diferencia < 0 || ($mes_diferencia == 0 && $dia_diferencia < 0 || $mes_diferencia < 0))
      $ano_diferencia--;
    return $ano_diferencia;
}
function formatoFecha($f){
    date_default_timezone_set('America/Mexico_City');
    $numeroDia = date('d', strtotime($f));
    $mes = date('F', strtotime($f));
    $anio = date('Y', strtotime($f));
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_ES, $meses_EN, $mes);

    return $nombreMes." ".$numeroDia.", ".$anio;
}
function fecha_sinhora_espanol_front($date){
    $f = explode(' ', $date);
    $aux = explode('-', $f[0]);
    $fecha = $aux[2].'/'.$aux[1].'/'.$aux[0];
    return $fecha;
}
function formatoFechaEspanol($f){
    date_default_timezone_set('America/Mexico_City');
    $numeroDia = date('d', strtotime($f));
    $mes = date('F', strtotime($f));
    $anio = date('Y', strtotime($f));
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);

    return $nombreMes." ".$numeroDia.", ".$anio;
}
function formatoFechaEspanolPDF($f){
	date_default_timezone_set('America/Mexico_City');
	$numeroDia = date('d', strtotime($f));
	$mes = date('F', strtotime($f));
	$anio = date('Y', strtotime($f));
	$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	$nombreMes = str_replace($meses_EN, $meses_ES, $mes);

	return $numeroDia." de ".$nombreMes." de ".$anio;
}
function formatoFechaDescripcion($f){
  $numeroDia = date('d', strtotime($f));
  $dia = date('l', strtotime($f));
  $mes = date('F', strtotime($f));
  $anio = date('Y', strtotime($f));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
  $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_ES, $meses_EN, $mes);

  $f_alta = $nombreMes." ".$numeroDia.", ".$anio;
  return $f_alta;
}
function generarPassword(){
	//Se define una cadena de caractares.
	//Os recomiendo desordenar las minúsculas, mayúsculas y números para mejorar la probabilidad.
	$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	//Obtenemos la longitud de la cadena de caracteres
	$longitudCadena=strlen($cadena);

	//Definimos la variable que va a contener la contraseña
	$pass = "";
	//Se define la longitud de la contraseña, puedes poner la longitud que necesites
	//Se debe tener en cuenta que cuanto más larga sea más segura será.
	$longitudPass=12;

	//Creamos la contraseña recorriendo la cadena tantas veces como hayamos indicado
	for($i=1 ; $i<=$longitudPass ; $i++){
			//Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
			$pos=rand(0,$longitudCadena-1);

			//Vamos formando la contraseña con cada carácter aleatorio.
			$pass .= substr($cadena,$pos,1);
	}

	return $pass;
}
//* Formato fecha en texto
function fechaTexto($f,$idioma){
  $numeroDia = date('d', strtotime($f));
  $dia = date('l', strtotime($f));
  $mes = date('F', strtotime($f));
  $anio = date('Y', strtotime($f));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
  $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  if($idioma == 'ingles'){
    $nombreMes = str_replace($meses_ES, $meses_EN, $mes);
    $f_alta = $nombreMes." ".$numeroDia.", ".$anio;
    return $f_alta;
  }
  if($idioma == 'espanol'){
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    $f_alta = $numeroDia." de ".$nombreMes." de ".$anio;
    return $f_alta;
  }
}
//* Validar fecha (sin hora) en calendario en espanol
function validar_fecha_espanol($fecha){
	$valores = explode('/', $fecha);
	if(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])){
		return true;
    }
	return false;
}