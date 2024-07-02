</html><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
</head>
<style>
	body { font-family: 'Arial'; font-size: 12px; }
	.col-md-2 { width: 16%; float: left; }
	.col-md-4 { width: 33%; float: left; }
	.col-md-4-2 { width: 33%; float: right; }
	.col-md-3 { width: 25%; float: left; }
	.col-md-6 { width: 48%; margin-left: 25px; float: left; }
	.col-md-6-2 { width: 48%; float: right; }
	.f-10 { font-size: 10px; }
	.f-11 { font-size: 11px; }
	.f-12 { font-size: 12px; }
	.f-13 { font-size: 13px; }
	.f-14 { font-size: 14px; }
	.f-16 { font-size: 16px; }
	.f-18 { font-size: 18px; }
	.f-20 { font-size: 20px; }
	.f-white { color: white; }
	.fondo0 { background: #b0b0b0; }
	.fondo1 { background: #78f26d; }
	.fondo2 { background: #eb4034; }
	.fondo3 { background: #f2d56d; }
	.col-ext { width: 40%; float: left; padding-left: 12%;}
	.row{ width: 100%; }
	.first{ height: 50px; border-bottom: 1px solid #081e26; }
	.firstSecond{ height: 50px; border-bottom: 1px solid #081e26; padding-top:1px;}
	.firstTitle{border-bottom: 1px solid #e5e5e5; padding-top: 0px; height: 20px;}
	.datos{ margin-left: 10px; margin-right: 10px;}
	.logo{ height: 50px; }
	.icono { height: 15px; padding-right: 5px; }
	.right{text-align: right;}
	.center{ text-align: center; }
	.left { text-align: left !important; }
	.centrado { margin: 0px auto; }
	.head{ padding-top: 0px;  }
	.title{ border-bottom: 1px solid #e5e5e5; padding-top: 5px; height: 5px; }
	h3{ font-size: 12px; }
	p{ padding-bottom: 2px; }
	.cita{ height: 60px; border-bottom: 1px dotted #000; }
	.padding_top_4{ padding-top: 4px; }
	.bb{ border-bottom: 1px solid #e5e5e5; }
	.personal{ padding-left: 5%; padding-top: 20px;}
	.top{padding-top: 60px;}
	.pl{ padding-left: 6%; padding-top: 20px;}
	.pr{ padding-right: 2%; }
	.sin-flotar{ clear: both; }
	table, th, td { border: 1px solid black; border-collapse: collapse;}
	.tabla { margin: 0 auto; width:80%; }
	th, td { padding: 3px; text-align: center; }
	.media-tabla { width: 40%; }
	.encabezado { background: #f2f2f2; }
	.comentario { width: 80%; border: 1px solid gray; }
	.margen-top { margin-top: 10px; }
	.div_datos { margin: 0 auto; width: 100%; }
	.div_datos table { margin: 0 auto; width: 100%;}
	.div_final { margin: 0 auto; width: 80%; }
	.div_final table { margin: 0 auto; width: 100%;}
	.div-azul { background: #154c6e;  width: 100%; height: 20px; color: white; padding-left: 10px;} 
	.w-5 { width: 5%; }
	.w-10 { width: 10%; }
	.w-15 { width: 15%; }
	.w-17 { width: 17%; }
	.w-20 { width: 20%; }
	.w-25 { width: 25%;}
	.w-30 { width: 30%; }
	.w-40 { width: 40%; }
	.w-50 { width: 50%; }
	.w-60 { width: 60%; }
	.w-70 { width: 70%; }
	.w-75 { width: 75%; }
	.w-80 { width: 80%; }
	.w-90 { width: 90% !important; }
	.w-100 { width: 100% !important; }
	.img-penales { width: 370px; height: 420px; }
	.img-aviso { width: 500px; height: 720px; }
	.foto { width: 400px; height: 330px;padding-top: 10px; }
	.borde-derecho { border-right: 1px solid black; }
	.color-rodi { color: #255880; }
	.margen-50 {margin-left: 50% !important;}
	.flotar-derecha { float: right !important; }
	.flotar-izquierda { float: left; }
	.bordes { border-top: 1px solid gray;border-bottom: 1px solid gray; }
	.padding { padding: 7px; }
	.margin-left { margin-left: 10px !important; }
	.firma{ width: 127px; height: 200px; padding-left: 25px;}
	.img-foto-rostro { width: 150px; height: 160px; }
	.bordes-img{border: 1px solid black;}
	.negrita { font-weight: bold; }
</style>
<body>

<?php 
//* Procesamiento de variables
$numFamiliares = 0;
if($familia){
	$numFamiliares = count($familia);
}
$numVecinales = 0;
if($refVecinal){
	$numVecinales = count($refVecinal);
}
$numGaps = 0;
if($gaps){
  $numGaps = count($gaps);
}
$numObservacionesLaborales = 0;
if($contactos != null){
  $numObservacionesLaborales = count($contactos);
}

$numFamiliaresMismaVivienda = 0;
$numFamiliaresOrigen = 0;
$sumFamiliares = 0;
if($familia != null){
  foreach($familia as $row){
    if($row['misma_vivienda'] == 1){
      $numFamiliaresMismaVivienda++;
    }
    if($row['id_tipo_parentesco'] == 1 || $row['id_tipo_parentesco']  == 2 || $row['id_tipo_parentesco']  == 6){
      $numFamiliaresOrigen++;
    }
  }
  $sumFamiliares = $numFamiliaresMismaVivienda + $numFamiliaresOrigen;
}

//* Se define que tipo de estudio se llevó a cabo
if($secciones['proyecto'] == 'General Nacional' || $secciones['proyecto'] == 'General Internacional' || $secciones['proyecto'] == 'General' || $secciones['proyecto'] == 'General Alternativo' || $secciones['proyecto'] == 'Socioeconómico Completo' || $secciones['proyecto'] == 'Socioeconómico' || $secciones['proyecto'] == 'Standard' || $secciones['proyecto'] == 'Background Check' || $secciones['proyecto'] == 'Criminal check' || $secciones['proyecto'] == 'Investigacion empresarial'){
  $tipoProceso = 1;
  $nombreProceso = 'Estudio Socioeconómico - Checklist';
  $subtituloProceso = 'Estudio Socioeconómico';
}
if($secciones['proyecto'] == 'Laborales Nacional' || $secciones['proyecto'] == 'Laborales'){
  $tipoProceso = 2;
  $nombreProceso = 'Laborales - Checklist';
  $subtituloProceso = 'Laborales';
}
if($secciones['proyecto'] == 'Demandas e IMSS'){
  $tipoProceso = 3;
  $nombreProceso = 'Demandas e IMSS - Checklist';
  $subtituloProceso = 'Demandas e IMSS';
}
if($secciones['proyecto'] == 'Demandas e IMSS + Referencias Laborales'){
  $tipoProceso = 4;
  $nombreProceso = 'Demandas e IMSS + Referencias Laborales - Checklist';
  $subtituloProceso = 'Demandas e IMSS + Referencias Laborales';
}
if($secciones['proyecto'] == 'Buro de Crédito'){
  $tipoProceso = 5;
  $nombreProceso = 'Buró de Crédito - Checklist';
  $subtituloProceso = 'Buró de Crédito';
}
if($secciones['proyecto'] == 'Solo Referencias laborales'){
  $tipoProceso = 6;
  $nombreProceso = 'Reporte de Solo Referencias laborales - Checklist';
  $subtituloProceso = 'Reporte de Solo Referencias laborales';
}
if($secciones['proyecto'] == 'OIG-SAM Verification'){
  $tipoProceso = 7;
  $nombreProceso = 'Report of OIG-SAM - Checklist';
  $subtituloProceso = 'Report of OIG-SAM Verification';
}
if($secciones['proyecto'] == 'National Verification'){
  $tipoProceso = 8;
  $nombreProceso = 'National Verification - Checklist';
  $subtituloProceso = 'National Verification';
}
if($secciones['proyecto'] == 'International Verification'){
  $tipoProceso = 9;
  $nombreProceso = 'International Verification - Checklist';
  $subtituloProceso = 'International Verification';
}
if($secciones['proyecto'] == 'Identity and Criminal Verification'){
  $tipoProceso = 10;
  $nombreProceso = 'Identity and Criminal Verification - Checklist';
  $subtituloProceso = 'Identity and Criminal Verification';
}
if($secciones['proyecto'] == 'Visita (Solo fotos)'){
  $nombreProceso = 'Visita (Solo Fotografías)';
}
if($secciones['proyecto'] == 'International Check'){
  $tipoProceso = 12;
  $nombreProceso = 'International check - Checklist';
  $subtituloProceso = 'International check';
}
if($secciones['proyecto'] == 'FACIS Level 3'){
  $tipoProceso = 13;
  $nombreProceso = 'FACIS Level 3 check - Checklist';
  $subtituloProceso = 'FACIS Level 3 check';
}
if($secciones['proyecto'] == 'International Criminal'){
  $tipoProceso = 14;
  $nombreProceso = 'International Criminal check - Checklist';
  $subtituloProceso = 'International Criminal check';
}
if($secciones['proyecto'] == 'Standard'){
  $tipoProceso = 15;
  $nombreProceso = 'Standard check - Checklist';
  $subtituloProceso = 'Standard check';
}
if($secciones['proyecto'] == 'Background Check'){
  $tipoProceso = 16;
  $nombreProceso = 'Background check - Checklist';
  $subtituloProceso = 'Background check';
}
if($secciones['proyecto'] == 'Criminal check'){
  $tipoProceso = 17;
  $nombreProceso = 'Criminal check - Checklist';
  $subtituloProceso = 'Criminal check';
}
if($secciones['proyecto'] == 'Investigacion empresarial'){
  $tipoProceso = 18;
  $nombreProceso = 'Investigacion empresarial - Checklist';
  $subtituloProceso = 'Investigacion empresarial';
}else{
	$nombreProceso = $secciones['proyecto'];
	$subtituloProceso = 'Estudio Socioeconómico';
}

//* Conversión de fechas
if($info['fecha_fin'] != null){
  $e = new DateTime($info['fecha_fin']);
}
if($info['fecha_bgc']!= null){
  $e = new DateTime($info['fecha_bgc']);
}
if($info['ingles'] == 0){
  if($info['fecha_fin'] != null){
    $fecha_fin = $e->format('d/m/Y');
  }
  else{
    $fecha_fin = 'En proceso';
  }
}
if ($info['ingles'] == 1) {
	// Aquí revisa el nombre de la clave sin espacios adicionales
	if (isset($info['fecha_bgc'])) {
			if ($info['fecha_bgc'] != null) {
					$fecha_fin = $e->format('m/d/Y');
			} else {
					$fecha_fin = 'In process';
			}
	}
}

$e = new DateTime($info['fecha_nacimiento']);
if($info['ingles'] == 0){
  $fecha_nacimiento = $e->format('d/m/Y');
}
if($info['ingles'] == 1){
  $fecha_nacimiento = $e->format('m/d/Y');
}

$e = new DateTime($info['fecha_alta']);
if($info['ingles'] == 0){
  $fecha_alta = $e->format('d/m/Y');
}
if($info['ingles'] == 1){
  $fecha_alta = $e->format('m/d/Y');
}

function fechaPorIdioma($fecha, $idioma){
  if($idioma == 'espanol'){
    $f = new DateTime($fecha);
    $fechaConvertida = $f->format('d/m/Y');
  }
  if($idioma == 'ingles'){
    $f = new DateTime($fecha);
    $fechaConvertida = $f->format('m/d/Y');
  }
  return $fechaConvertida;
}


$e = new DateTime($info['fecha_acta']);
$fecha_acta = $e->format('d/m/Y');

$e = new DateTime($info['fecha_domicilio']);
$fecha_domicilio = $e->format('d/m/Y');

$e = new DateTime($info['emision_curp']);
$emision_curp = $e->format('d/m/Y');

if($info['emision_nss'] != "0000-00-00" && $info['emision_nss'] != NULL){
	$e = new DateTime($info['emision_nss']);
	$emision_nss = $e->format('d/m/Y');
}
else{
	$emision_nss = "No proporciona";
}

if($info['fecha_retencion_impuestos'] != "0000-00-00" && $info['fecha_retencion_impuestos'] != NULL){
	$e = new DateTime($info['fecha_retencion_impuestos']);
	$fecha_retencion_impuestos = $e->format('d/m/Y');
}
else{
	$fecha_retencion_impuestos = "No proporciona";
}

$e = new DateTime($info['emision_rfc']);
$emision_rfc = $e->format('d/m/Y');

if($info['fecha_licencia'] != "0000-00-00"){
	$e = new DateTime($info['fecha_licencia']);
	$fecha_licencia = $e->format('d/m/Y');
}
else{
	$fecha_licencia = "No proporciona";
}

if($info['vigencia_migratoria'] != "0000-00-00" && $info['vigencia_migratoria'] != NULL){
	$e = new DateTime($info['vigencia_migratoria']);
	$vigencia_migratoria = $e->format('d/m/Y');
}
else{
	$vigencia_migratoria = "No proporciona";
}

if($info['fecha_visa'] != "0000-00-00" && $info['fecha_visa'] != NULL){
	$e = new DateTime($info['fecha_visa']);
	$fecha_visa = $e->format('d/m/Y');
}
else{
	$fecha_visa = "No proporciona";
}

//* Conversiones de texto a ingles (provenientes de option de select)
if($info['ingles'] == 1){
  if($info['estado_civil'] == 'Casado(a)' && $info['estado_civil'] == 'Soltero(a)' && $info['estado_civil'] == 'Divorciado(a)' && $info['estado_civil'] == 'Unión Libre' && $info['estado_civil'] == 'Viudo(a)' && $info['estado_civil'] == 'Separado(a)' && $info['estado_civil'] == 'Concubino(a)' && $info['estado_civil'] == 'Pareja'  && $info['estado_civil'] == 'Comprometido(a)'){
    switch($info['estado_civil']){
      case 'Casado(a)':
        $estado_civil_ingles = 'Married'; break;
      case 'Soltero(a)':
        $estado_civil_ingles = 'Single'; break;
      case 'Divorciado(a)':
        $estado_civil_ingles = 'Divorced'; break;
      case 'Unión Libre':
        $estado_civil_ingles = 'Free union'; break;
      case 'Viudo(a)':
        $estado_civil_ingles = 'Widowed'; break;
      case 'Separado(a)':
        $estado_civil_ingles = 'Separated'; break;
      case 'Concubino(a)':
        $estado_civil_ingles = 'Cohabitant'; break;
      case 'Pareja':
        $estado_civil_ingles = 'Couple'; break;
      case 'Comprometido(a)':
        $estado_civil_ingles = 'Compromised'; break;
    }
  }
  else{
    $estado_civil_ingles = $info['estado_civil'];
  }
  if($info['genero'] != 'Male' && $info['genero'] != 'Female'){
    switch($info['genero']){
      case 'Masculino':
        $genero_ingles = 'Male'; break;
      case 'Femenino':
        $genero_ingles = 'Female'; break;
    }
  }
  else{
    $genero_ingles = $info['genero'];
  }
}
function nombreFamiliarIngles($familiar){
  switch($familiar){
    case 'Padre':
      $fam = 'Father'; break;
    case 'Madre':
      $fam = 'Mother'; break;
    case 'Hijo(a)':
      $fam = 'Child'; break;
    case 'Cónyuge':
    case 'Pareja':
      $fam = 'Couple'; break;
    case 'Abuelo(a)':
      $fam = 'Grandparent'; break;
    case 'Hermano(a)':
      $fam = 'Sibling'; break;
    case 'Nieto(a)':
      $fam = 'Grandchild'; break;
    case 'Suegro(a)':
      $fam = 'Mother/Father in law'; break;
    case 'Yerno/Nuera':
      $fam = 'Daughter/Son in law'; break;
    case 'Cuñado(a)':
      $fam = 'Sibling in law'; break;
    case 'Roomie':
      $fam = 'Roomite'; break;
    case 'Sobrino(a)':
      $fam = 'Niece/Nephew'; break;
    case 'Candidato':
      $fam = 'Candidate'; break;
    case 'Tío(a)':
     $fam = 'Uncle/Aunt'; break;
    case 'Primo(a)':
      $fam = 'Cousin'; break;
    case 'Padrastro':
    case 'Madrastra':
      $fam = 'Stepparent'; break;
    case 'Hijastro(a)':
      $fam = 'Stepchild'; break;
    case 'Tutor(a)':
      $fam = 'Tutor'; break;
  }
  return $fam;
}

//* Información de Doping
// if(!empty($doping)){
// 	$res_doping = ($pruebas['resultado'] == 0)? "Approved":"Not approved";
// 	if($pruebas['resultado'] == 0){ $f_doping = "fondo1"; }
// 	if($pruebas['resultado'] == 1){ $f_doping = "fondo2"; }
// 	$a = new DateTime($doping['fecha_resultado']);
// 	$fecha_doping_res = $a->format('m/d/Y');
// 	$examenDoping = $this->doping_model->getPaqueteCandidato($doping->id_antidoping_paquete);
// }
// else{
// 	if($pruebas['tipo_antidoping'] != 0 && $pruebas['antidoping'] != 0){
// 		$examenDoping = $this->doping_model->getPaqueteCandidato($pruebas['antidoping']);
// 		$res_doping = "Pending";
// 		$fecha_doping_res = ' - ';
// 	}
// 	else{
// 		$res_doping = "NA";
// 		$fecha_doping_res = 'NA';
// 	}
// }
//* Se obtienen los documentos cargados del candidato
$documentosCandidato = array();
if($docs){
	//$archivos['documentos'] = $this->documentacion_model->getArchivosCandidato($id_candidato);
	//if($archivos['documentos']){
		foreach($docs as $doc){
			//if(stripos($doc['archivo'], '.pdf') === false){
				$documentosCandidato[] = $doc['id_tipo_documento'];
			//}
		}
	//}
}

//* Se verifica fecha y examen de doping
if(!empty($doping)){
	$e = new DateTime($doping['fecha_resultado']);
  $fecha_res_doping = $e->format('d/m/Y');
	$examenDoping = $this->doping_model->getPaqueteCandidato($doping['id_antidoping_paquete']);
}
else{
  $fecha_res_doping = "N/A";
}
//* Variables para Scope of Verification
// Iteracion de veirificacion de documentos para formar el texto de identificacion en el scope
if(!empty($verDoc)){
	$identificaciones = 'ID not provided';
	if(!empty($verDoc['ine']) && in_array(3, $documentosCandidato)){
		$identificaciones = "ID: ".$verDoc['ine'];
	}
	else{
		if(!empty($verDoc['pasaporte']) && in_array(14, $documentosCandidato)){
			$identificaciones = 'Passport: '.$verDoc['pasaporte'].' '.$verDoc['pasaporte_fecha'];
		}
	}
}
else{
	$identificaciones = 'N/A';
}

//* Consultas a tabla seccion para obtener los detalles de las secciones que se requieran
$detallesSeccionGlobal = $this->candidato_model->getSeccion($secciones['id_seccion_global_search']);

//* Estatus del reporte del candidato
//TODO: Corregir el estatus de los clientes que cuentan con mas de los 3 estatus que se trabajan en general
if($info['id_cliente'] != 159 && $info['ingles'] == 0){
  switch ($info['status_bgc']) {
    case 1:
      $estatus_portada = '<td class="center fondo1"><p class="f-11"><b>Positivo</b></p></td><td class="center"><p class="f-11"><b>Negativo</b></p></td><td class="center"><p class="f-11"><b>Con reservas</b></p></td>';
      $icono = "img/iconos/bgc1.png";
      $s_bgc = "Positive";
      $num_columnas_estatus = 3;
      $estatus_final = 'Positivo';
      break;
    case 2:
      $estatus_portada = '<td class="center"><p class="f-11"><b>Positivo</b></p></td><td class="center fondo2"><p class="f-11"><b>Negativo</b></p></td><td class="center"><p class="f-11"><b>Con reservas</b></p></td>';
      $icono = "img/iconos/bgc2.png";
      $s_bgc = "Negative";
      $num_columnas_estatus = 3;
      $estatus_final = 'Negativo';
      break;
    case 3:
      $estatus_portada = '<td class="center"><p class="f-11"><b>Positivo</b></p></td><td class="center"><p class="f-11"><b>Negativo</b></p></td><td class="center fondo3"><p class="f-11"><b>Con reservas</b></p></td>';
      $icono = "img/iconos/bgc3.png";
      $s_bgc = "Under Revision";
      $num_columnas_estatus = 3;
      $estatus_final = 'Con reservas';
      break;
			default:
      $estatus_portada = '<td class="center" colspan="5"><b>Se define al terminar el estudio</b></td>';
      $estatus_final = 'Se define al terminar el estudio';
      $num_columnas_estatus = 5;
      break;
  }
}
if($info['id_cliente'] != 159 && $info['ingles'] == 1){
  switch ($info['status_bgc']) {
    case 1:
      $estatus_portada = '<td class="center fondo1"><p class="f-11"><b>Positive</b></p></td><td class="center"><p class="f-11"><b>Negative</b></p></td><td class="center"><p class="f-11"><b>With reservations</b></p></td>';
      $icono = "img/iconos/bgc1.png";
      $s_bgc = "Positive";
      $num_columnas_estatus = 3;
      $estatus_final = 'Positive';
      break;
    case 2:
      $estatus_portada = '<td class="center"><p class="f-11"><b>Positive</b></p></td><td class="center fondo2"><p class="f-11"><b>Negative</b></p></td><td class="center"><p class="f-11"><b>With reservations</b></p></td>';
      $icono = "img/iconos/bgc2.png";
      $s_bgc = "Negative";
      $num_columnas_estatus = 3;
      $estatus_final = 'Negative';
      break;
    case 3:
      $estatus_portada = '<td class="center"><p class="f-11"><b>Positive</b></p></td><td class="center"><p class="f-11"><b>Negative</b></p></td><td class="center fondo3"><p class="f-11"><b>With reservations</b></p></td>';
      $icono = "img/iconos/bgc3.png";
      $s_bgc = "With reservations";
      $num_columnas_estatus = 3;
      $estatus_final = 'With reservations';
      break;
			default:
      $estatus_portada = '<td class="center" colspan="5"><b>Se define al terminar el estudio</b></td>';
      $estatus_final = 'Se define al terminar el estudio';
      $num_columnas_estatus = 5;
      break;
  }
}
if($info['id_cliente'] == 159 && $info['ingles'] == 0){
  $estatus_final = '';
  switch ($info['status_bgc']) {
    case 1:
      $estatus_portada = '<td class="center fondo1"><b>R</b></td><td class="center"><b>NR</b></td><td class="center"><b>CR</b></td><td class="center"><b>RV</b></td><td class="center"><b>RCI</b></td>';
      $icono = "img/iconos/bgc1.png";
      $s_bgc = "Positive";
      $num_columnas_estatus = 5;
      $estatus_final = 'Positivo';
      break;
    case 2:
      $estatus_portada = '<td class="center"><b>R</b></td><td class="center fondo2"><b>NR</b></td><td class="center"><b>CR</b></td><td class="center"><b>RV</b></td><td class="center"><b>RCI</b></td>';
      $icono = "img/iconos/bgc2.png";
      $s_bgc = "Negative";
      $num_columnas_estatus = 5;
      $estatus_final = 'Negativo';
      break;
    case 3:
      $estatus_portada = '<td class="center"><b>R</b></td><td class="center"><b>NR</b></td><td class="center fondo3"><b>CR</b></td><td class="center"><b>RV</b></td><td class="center"><b>RCI</b></td>';
      $icono = "img/iconos/bgc3.png";
      $s_bgc = "Under Revision";
      $num_columnas_estatus = 5;
      $estatus_final = 'Con reservas';
      break;
    case 4:
      $estatus_portada = '<td class="center"><b>R</b></td><td class="center"><b>NR</b></td><td class="center"><b>CR</b></td><td class="center fondo1"><b>RV</b></td><td class="center"><b>RCI</b></td>';
      $icono = "img/iconos/bgc1.png";
      $s_bgc = "Positive";
      $num_columnas_estatus = 5;
      $estatus_final = 'Referencias validadas';
      break;
    case 5:
      $estatus_portada = '<td class="center"><b>R</b></td><td class="center"><b>NR</b></td><td class="center"><b>CR</b></td><td class="center"><b>RV</b></td><td class="center fondo3"><b>RCI</b></td>';
      $icono = "img/iconos/bgc1.png";
      $s_bgc = "Positive";
      $num_columnas_estatus = 5;
      $estatus_final = 'Referencias con inconsistencias';
      break;
    default:
      $estatus_portada = '<td class="center" colspan="5"><b>Se define al terminar el estudio</b></td>';
      $estatus_final = 'Se define al terminar el estudio';
      $num_columnas_estatus = 5;
      break;
  }
}

//* Examenes asignados al candidato
if(isset($pruebas)){
  if($info['ingles'] == 0){
    $socioeconomico = ($pruebas['socioeconomico'] == 1)? "Sí":"No";
    $antidoping = ($pruebas['tipo_antidoping'] == 1)? "Sí":"No";
    $psicometrico = ($pruebas['psicometrico'] == 1)? "Sí":"No";
    $medico = ($pruebas['medico']== 1)? "Sí":"No";
    $buro_credito = ($pruebas['buro_credito'] == 1)? "Sí":"No";
    $sociolaboral = ($pruebas['sociolaboral'] == 1)? "Sí":"No";
    $visita_domicilio = $info['visitador'];

    if($medico == "Sí"){
      if($pruebas['conclusion_medico'] != null && $pruebas['conclusion_medico'] != ""){
        $e = new DateTime($pruebas['fecha_medico']);
        $f_medico = $e->format('d/m/Y');
      }
      else{
        $f_medico = "Pendiente";
      }
    }
    else{
      $f_medico = "NA";
    }
    if($psicometrico == "Sí"){
      if($pruebas['archivo']!= null && $pruebas['archivo']!= ""){
        $e = new DateTime($pruebas['fecha_psicometrico']);
        $f_psicometrico = $e->format('d/m/Y');
      }
      else{
        $f_psicometrico = "Pendiente";
      }
    }
    else{
      $f_psicometrico = "NA";
    }
  }
  if($info['ingles'] == 1){
    $socioeconomico = ($pruebas['socioeconomico'] == 1)? "Yes":"No";
    $antidoping = ($pruebas['tipo_antidoping'] == 1)? "Yes":"No";
    $psicometrico = ($pruebas['psicometrico'] == 1)? "Yes":"No";
    $medico = ($pruebas['medico']== 1)? "Yes":"No";
    $buro_credito = ($pruebas['buro_credito']== 1)? "Yes":"No";
    $sociolaboral = ($pruebas['sociolaboral']== 1)? "Yes":"No";
    $visita_domicilio = $info['visitador'];

    if($medico == "Yes"){
      if($pruebas['conclusion_medico'] != null && $pruebas['conclusion_medico'] != ""){
        $e = new DateTime($pruebas['fecha_medico']);
        $f_medico = $e->format('d/m/Y');
      }
      else{
        $f_medico = "Pending";
      }
    }
    else{
      $f_medico = "NA";
    }
    if($psicometrico == "Yes"){
      if($pruebas['archivo']!= null && $pruebas['archivo']!= ""){
        $e = new DateTime($pruebas['fecha_psicometrico']);
        $f_psicometrico = $e->format('d/m/Y');
      }
      else{
        $f_psicometrico = "Pending";
      }
    }
    else{
      $f_psicometrico = "NA";
    }
		if($pruebas['antidoping'] > 0){
			$examenDoping = $this->doping_model->getPaqueteCandidato($pruebas['antidoping']);
			if(!empty($doping) && $pruebas['status_doping'] == 1){
				$descripcion_doping = ($pruebas['resultado'] == 0)? "".$examenDoping['nombre']." Panel Drug Test Passed":"".$examenDoping['nombre']." Panel Drug Test Not Passed";
			}
			else{
				$descripcion_doping = ($pruebas['resultado'] == 0)? "".$examenDoping['nombre']." Panel Drug Test":"".$examenDoping['nombre']." Panel Drug Test Not";
			}
		}
  }
}

//* Estatus BGC del checklist del candidato
if(!empty($conclusion)){
	if($conclusion['professional_accreditation_check'] == 0){ $f_professional_acreditation = "fondo2"; $s_professional_acreditation = "Negative"; }
	if($conclusion['professional_accreditation_check'] == 1){ $f_professional_acreditation = "fondo1"; $s_professional_acreditation = "Positive"; }
	if($conclusion['professional_accreditation_check'] == 2){ $f_professional_acreditation = "fondo3"; $s_professional_acreditation = "FC"; }
	if($conclusion['professional_accreditation_check'] == 3 || $conclusion['professional_accreditation_check'] == -1){ $f_professional_acreditation=''; $s_professional_acreditation = "NA"; }
}
?>
<!-- Portada -->
  <?php 
  if($info['ingles'] == 0){
    if(isset($finalizado)){ ?>
      <div>
        <div class="col-md-4 borde-derecho">
       
            <img src="<?php echo base_url().'img/logo.png' ?>" width="190px" >
      
        </div>
        <div class="col-md-6">
          <?php 
					//TODO: Cambiar el nombre del cliente de acuerdo a lo que se solicite
          //* Se checa si posee subcliente para nombrarlo
					$nombreCliente = ($info['id_cliente'] != 244) ? $info['cliente'] : 'Talink';
          //$subcliente = ($info['subcliente'] != null)? ' - '.$info['subcliente'] : ''; ?>
          <!--span class="f-16 color-rodi margen-top"><b>< ?php echo $nombreCliente.$subcliente; ?></span --></b><br>
          <span class="f-16 color-rodi"><b><?php echo $nombreProceso; ?></span></b>
        </div>
      </div>

      <div class="margen-50 margen-top">
        <table class="tabla w-100">
          <tr>
            <td class="encabezado right" width="25%"><p class="f-11"><b>Fecha de Elaboración</b></p></td>
            <td class="right"><p class="f-11"><b><?php echo $fecha_finalizado; ?></b></p></td>
          </tr>
        </table>
      </div>
      <br>
      <?php 
      //* Se muestra foto imagen de frente del candidato en caso de que exista
      //TODO: Controlar por cliente si se solicitó este aspecto o no mediante BD u otra alternativa
      if($docs){
        $band = 0;
        if($info['id_cliente'] != 159){
          echo '<div class="center margen-bottom">';
          foreach($docs as $doc){
            if($doc['id_tipo_documento'] == 22){
              echo '<img class="img-foto-rostro padding bordes-img " src="'.base_url().'_docs/'.$doc['archivo'].'">';
              $band = 1;
              break;
            }
          }
          if($info['id_cliente'] == 16 || $info['id_cliente'] == 51){
            if($band == 0){
              echo '<img class="img-foto-rostro padding bordes-img " src="'.base_url().'img/user.png">';
            }
          }
          echo '</div>';
        }
      }
      ?>

      <?php 
      if($secciones['tipo_conclusion'] > 0){ ?>
        <table class="tabla w-100">
          <?php 
          //TODO: Manejar este campo de reclutador de forma que sea automatica dependiendo del cliente
          if($info['id_cliente'] == 159){ 
            echo '<tr>';
            echo '<td class="encabezado right" width="30%"><p class="f-12"><b>Reclutador</b></p></td>';
            echo '<td class="center" colspan="'.$num_columnas_estatus.'"><p class="f-11"><b>'.$info['subcliente'].'</b></p></td>';
            echo '</tr>';
          } ?>
          <tr>
            <td class="encabezado right" width="30%"><p class="f-12"><b>Nombre completo del candidato</b></p></td>
            <td class="center" colspan="<?php echo $num_columnas_estatus; ?>"><p class="f-11"><b><?php echo $info['candidato']; ?></b></p></td>
          </tr>
          <tr>
            <td class="encabezado right" width="30%"><p class="f-12"><b>Estatus del Candidato</b></p></td>
            <?php 
              echo $estatus_portada;
            ?>
          </tr>
          <?php 
          //TODO: Manejar este campo de conclusiones de forma que sea automatica dependiendo del cliente
          if($info['id_cliente'] == 159 && $finalizado != null){ 
            echo '<tr>';
            echo '<td class="encabezado right" width="30%"><p class="f-12"><b>Conclusión</b></p></td>';
            echo '<td class="center" colspan="'.$num_columnas_estatus.'"><p class="f-11"><b>'.$finalizado['comentario'].'</b></p></td>';
            echo '</tr>';
          } ?>
        </table>
        <br>
        <?php 
        if($estatus_final != 'Se define al terminar el estudio'){ ?>
          <div class="flotar-izquierda w-70">
            <table class="w-90">
              <tr>
                <th class="encabezado">Estudios</th>
                <th class="encabezado">Requerido</th>
                <th class="encabezado">Fecha realizado</th>
              </tr>
              <?php 
              //TODO: tabla de checklist pendiente de cómo hacerla dinámica dependiendo del cliente
              if($info['id_cliente'] != 159){  ?>
                <tr>
                  <td class="left">Estudio Socioeconómico</td>
                  <td><p class="f-14"><?php echo $procesoSocioeconomico = ($tipoProceso == 1)? 'Sí' : 'No'; ?></p></td>
                  <td><?php echo $fechaProcesoSocioeconomico = ($tipoProceso == 1)? $fecha_fin : 'N/A'; ?></td>
                </tr>
                <tr>
                  <td class="left">Investigación Empresarial</td>
                  <td><p class="f-14"><?php echo $procesoSocioeconomico = ($tipoProceso == 18)? 'Sí' : 'No'; ?></p></td>
                  <td><?php echo $fechaProcesoInvestigacionEmpresarial = ($tipoProceso == 18)? $fecha_fin : 'N/A'; ?></td>
                </tr>
                <tr>
                  <td class="left">Estudio Laboral</td>
                  <td><p class="f-14"><?php echo $procesoLaboral = ($tipoProceso == 2)? 'Sí' : 'No'; ?></p></td>
                  <td><?php echo $fechaProcesoLaboral = ($tipoProceso == 2)? $fecha_fin : 'N/A'; ?></td>
                </tr>
                <tr>
                  <td class="left">Reporte Demandas e IMSS</td>
                  <td><p class="f-14"><?php echo $procesoInvestigacion = ($tipoProceso == 3)? 'Sí' : 'No'; ?></p></td>
                  <td><?php echo $fechaProcesoInvestigacion = ($tipoProceso == 3)? $fecha_fin : 'N/A'; ?></td>
                </tr>
                <tr>
                  <td class="left">Estudio Sociolaboral</td>
                  <td><p class="f-14"><?php echo $procesoSociolaboral = ($tipoProceso == 4)? 'Sí' : 'No'; ?></p></td>
                  <td><?php echo $fechaProcesoSociolaboral = ($tipoProceso == 4)? $fecha_fin : 'N/A'; ?></td>
                </tr>
                <tr>
                  <td class="left">Reporte de Referencias Laborales</td>
                  <td><p class="f-14"><?php echo $procesoSociolaboral = ($tipoProceso == 6)? 'Sí' : 'No'; ?></p></td>
                  <td><?php echo $fechaProcesoSociolaboral = ($tipoProceso == 6)? $fecha_fin : 'N/A'; ?></td>
                </tr>
                <tr>
                  <td class="left">Verificación de Buró de Crédito</td>
                  <td><p class="f-14"><?php echo $buroCredito = ($pruebas['buro_credito']== 1)? 'Sí' : 'No'; ?></p></td>
                  <td><?php echo $fechaBuroCredito = ($pruebas['buro_credito']== 1)? $fecha_fin : 'N/A'; ?></td>
                </tr>
                <tr>
                  <td class="left">Examen Antidoping</td>
                  <td><p class="f-14"><?php echo $antidoping; ?></p></td>
                  <td><?php echo $fecha_res_doping; ?></td>
                </tr>
                <tr>
                  <td class="left">Examen Psicométrico</td>
                  <td><p class="f-14"><?php echo $psicometrico; ?></p></td>
                  <td><?php echo $f_psicometrico; ?></td>
                </tr>
                <tr>
                  <td class="left">Examen Médico</td>
                  <td><p class="f-14"><?php echo $medico; ?></p></td>
                  <td><?php echo $f_medico; ?></td>
                </tr>
              <?php 
              }
              else{  ?>
                <tr>
                  <td class="left"><?php echo $subtituloProceso; ?></td>
                  <td><p class="f-14">Sí</p></td>
                  <td><?php echo $fecha_fin; ?></td>
                </tr>
              <?php 
              }
              ?>
            </table>	
          </div>
          <div class="w-30 flotar-izquierda">
            <div class="bordes">
              <h5 class="center">INDICADORES	</h5>
            </div>
            <?php 
            //TODO: Corregir el mostrar estatus dependiendo de si el cliente posee mas estatus de los comunes
            if($info['id_cliente'] != 159){ ?>
              <div>
                <div class="w-30 flotar-izquierda">
                  <p class="fondo1 padding f-11 center">Positivo</p>
                  <p  class="fondo2 padding f-11 center">Negativo</p>
                  <p  class="fondo3 padding f-11 center">CR</p>
                  <p  class="padding f-11 center">NA</p>
                </div>
                <div class="w-60">
                  <p class="f-11 margin-left"> Recomendable para contratación</p>
                  <p class="f-11 margin-left"> No recomendable para contratación</p>
                  <p class="f-11 margin-left"> Con reservas</p>
                  <p class="f-11 margin-left"> Criterio No Aplica</p>
                </div>
              </div>
            <?php 
            }
            else{ ?>
              <table style="float:left;border: none;border-collapse: collapse;margin-top: 10px;">
                <tr>
                  <td class="w-20 fondo1">RV / R</td>
                  <td class="left">Referencias validadas /<br>Recomendable</td>
                </tr>
                <tr>
                  <td class="fondo2">NR</td>
                  <td class="left">No recomendable</td>
                </tr>
                <tr>
                  <td class="fondo3">RCI / CR</td>
                  <td class="left">Referencias con inconsistencias /<br>Con reservas</td>
                </tr>
              </table>
            <?php 
            } ?>
          </div>
          <br><br>
          <div class="centrado sin-flotar" style="border: 4px dashed #b8bfe6; height: 220px; width: 28%;">
            <p class="center" style="float: right;">FIRMA AUTORIZADA</p>
            <img class="firma" style="border: none;" src="<?php echo base_url().'img/firmaEstudios.jpg'; ?>">
          </div>
          <pagebreak>
        <?php 
        }
      }
    }
		if(isset($conclusion)&& $conclusion != null ){ ?>
      <div>
        <div class="col-md-4 borde-derecho">
          
            <img src="<?php echo base_url().'img/logo.png' ?>" width="190px" >
         
        </div>
        <div class="col-md-6">
          <?php 
          //* Se checa si posee subcliente para nombrarlo
          //$subcliente = ($info['subcliente'] != null)? ' - '.$info['subcliente'] : ''; ?>
          <!--span class="f-16 color-rodi margen-top"><b>< ?php echo $info['cliente'].$subcliente; ?></span--></b><br>
          <span class="f-16 color-rodi"><b><?php echo $nombreProceso; ?></span></b>
        </div>
      </div>

      <div class="margen-50 margen-top">
        <table class="tabla w-100">
          <tr>
            <td class="encabezado right" width="25%"><p class="f-11"><b>Fecha de finalización</b></p></td>
            <td class="right"><p class="f-11"><b><?php echo $fecha_finalizado; ?></b></p></td>
          </tr>
        </table>
      </div>
      <br>
      <?php 
      //* Se muestra foto imagen de frente del candidato en caso de que exista
      //TODO: Controlar por cliente si se solicitó este aspecto o no mediante BD u otra alternativa
      if($docs){
        $band = 0;
        if($info['id_cliente'] != 159){
          echo '<div class="center margen-bottom">';
          foreach($docs as $doc){
            if($doc['id_tipo_documento'] == 22){
              echo '<img class="img-foto-rostro padding bordes-img " src="'.base_url().'_docs/'.$doc['archivo'].'">';
              $band = 1;
              break;
            }
          }
          if($info['id_cliente'] == 16){
            if($band == 0){
              echo '<img class="img-foto-rostro padding bordes-img " src="'.base_url().'img/user.png">';
            }
          }
          echo '</div>';
        }
      }
      ?>

      <?php 
      if($secciones['tipo_conclusion'] > 0){ ?>
        <table class="tabla w-100">
          <?php 
          //TODO: Manejar este campo de reclutador de forma que sea automatica dependiendo del cliente
          if($info['id_cliente'] == 159){ 
            echo '<tr>';
            echo '<td class="encabezado right" width="30%"><p class="f-12"><b>Reclutador</b></p></td>';
            echo '<td class="center" colspan="'.$num_columnas_estatus.'"><p class="f-11"><b>'.$info['subcliente'].'</b></p></td>';
            echo '</tr>';
          } ?>
          <tr>
            <td class="encabezado right" width="30%"><p class="f-12"><b>Nombre del candidato</b></p></td>
            <td class="center" colspan="<?php echo $num_columnas_estatus; ?>"><p class="f-11"><b><?php echo $info['candidato']; ?></b></p></td>
          </tr>
          <tr>
            <td class="encabezado right" width="30%"><p class="f-12"><b>Estatus del candidato</b></p></td>
            <?php 
              echo $estatus_portada;
            ?>
          </tr>
          <?php 
          //TODO: Manejar este campo de conclusiones de forma que sea automatica dependiendo del cliente
          if($conclusion != null){ 
            echo '<tr>';
            echo '<td class="encabezado right" width="30%"><p class="f-12"><b>Declaración final</b></p></td>';
            echo '<td class="center" colspan="'.$num_columnas_estatus.'"><p class="f-11"><b>'.$conclusion->comentario_final.'</b></p></td>';
            echo '</tr>';
          } ?>
        </table>
        <br>
        <?php 
        if($estatus_final != 'Se define al terminar el estudio'){ ?>
          <div class="flotar-izquierda w-70">
            <table class="w-90">
              <tr>
                <th class="encabezado">Verificación</th>
                <th class="encabezado">Solicitado</th>
                <th class="encabezado">Fecha final</th>
              </tr>
              <tr>
                <td class="left"><?php echo $subtituloProceso; ?></td>
                <td><p class="f-14">Sí</p></td>
                <td><?php echo $fecha_fin; ?></td>
              </tr>
              <tr>
                <td class="left">Examen antidoping</td>
                <td><p class="f-14"><?php echo $antidoping; ?></p></td>
                <?php 
                if($info['id_cliente'] != 178){ ?>
                  <td><?php echo $fecha_res_doping; ?></td>
                <?php 
                }
                else{ ?>
                  <td>-</td>
                <?php 
                } ?>
              </tr>
              <tr>
                <td class="left">Examen psicométrico</td>
                <td><p class="f-14"><?php echo $psicometrico; ?></p></td>
                <td><?php echo $f_psicometrico; ?></td>
              </tr>
              <tr>
                <td class="left">Examen médico</td>
                <td><p class="f-14"><?php echo $medico; ?></p></td>
                <td><?php echo $f_medico; ?></td>
              </tr>
            </table>	
          </div>
          <div class="w-30 flotar-izquierda">
            <div class="bordes">
              <h5 class="center">INDICADORES	</h5>
            </div>
            <div>
              <div class="w-30 flotar-izquierda">
                <p class="fondo1 padding f-11 center">Positivo</p>
                <p  class="fondo2 padding f-11 center">Negativo</p>
                <p  class="fondo3 padding f-11 center">AC</p>
                <p  class="padding f-11 center">NA</p>
              </div>
              <div class="w-60">
                <p class="f-11 margin-left" style="padding-top: 3px;"> Recomendable para contratación</p>
                <p class="f-11 margin-left" style="padding-top: 3px;"> No recomendable para contratación</p>
                <p class="f-11 margin-left" style="padding-top: 3px;"> A consideración de ser contratado</p>
                <p class="f-11 margin-left" style="padding-top: 3px;"> No aplica</p>
              </div>
            </div>
          </div>
          <br><br>
          <div class="centrado sin-flotar" style="border: 4px dashed #b8bfe6; height: 220px; width: 28%;">
            <p class="center" style="float: right;">FIRMA DE AUTORIZACIÓN</p>
            <img class="firma" style="border: none;" src="<?php echo base_url().'img/firmaEstudios.jpg'; ?>">
          </div>
          <pagebreak>
        <?php 
        }
      }
    }
  }
  if($info['ingles'] == 1){
    if(isset($conclusion)){ ?>
      <div>
        <div class="col-md-4 borde-derecho">
          <?php 
          //TODO: asignar por BD el logo del cliente
          if($info['id_cliente'] == 39){  ?>
            <img src="<?php echo base_url().'img/logo_talink.png' ?>" width="140px" >
          <?php
          }
          if($info['id_cliente'] == 7){  ?>
            <img src="<?php echo base_url().'img/logo_gentex.png' ?>" width="140px" >
          <?php 
          }
          if($info['id_cliente'] == 159){  ?>
            <img src="<?php echo base_url().'img/logo_pisa.png' ?>" width="160px" height="130px" >
          <?php 
          }
          if($info['id_cliente'] != 39 && $info['id_cliente'] != 7 && $info['id_cliente'] != 159){  ?>
            <img src="<?php echo base_url().'img/logo.png' ?>" width="190px" >
          <?php
          } ?>
        </div>
        <div class="col-md-6">
          <?php 
          //* Se checa si posee subcliente para nombrarlo
          //$subcliente = ($info['subcliente'] != null)? ' - '.$info['subcliente'] : ''; ?>
          <!--span class="f-16 color-rodi margen-top"><b>< ?php echo $info['cliente'].$subcliente; ?></span--></b><br>
          <span class="f-16 color-rodi"><b><?php echo $nombreProceso; ?></span></b>
        </div>
      </div>

      <div class="margen-50 margen-top">
        <table class="tabla w-100">
          <tr>
            <td class="encabezado right" width="25%"><p class="f-11"><b>Release Date</b></p></td>
            <td class="right"><p class="f-11"><b><?php echo $fecha_finalizado; ?></b></p></td>
          </tr>
        </table>
      </div>
      <br>
      <?php 
      //* Se muestra foto imagen de frente del candidato en caso de que exista
      //TODO: Controlar por cliente si se solicitó este aspecto o no mediante BD u otra alternativa
      if($docs){
        $band = 0;
        if($info['id_cliente'] != 159){
          echo '<div class="center margen-bottom">';
          foreach($docs as $doc){
            if($doc['id_tipo_documento'] == 22){
              echo '<img class="img-foto-rostro padding bordes-img " src="'.base_url().'_docs/'.$doc['archivo'].'">';
              $band = 1;
              break;
            }
          }
          if($info['id_cliente'] == 16){
            if($band == 0){
              echo '<img class="img-foto-rostro padding bordes-img " src="'.base_url().'img/user.png">';
            }
          }
          echo '</div>';
        }
      }
      ?>

      <?php 
      if($secciones['tipo_conclusion'] > 0){ ?>
        <table class="tabla w-100">
          <?php 
          //TODO: Manejar este campo de reclutador de forma que sea automatica dependiendo del cliente
          if($info['id_cliente'] == 159){ 
            echo '<tr>';
            echo '<td class="encabezado right" width="30%"><p class="f-12"><b>Reclutador</b></p></td>';
            echo '<td class="center" colspan="'.$num_columnas_estatus.'"><p class="f-11"><b>'.$info['subcliente'].'</b></p></td>';
            echo '</tr>';
          } ?>
          <tr>
            <td class="encabezado right" width="30%"><p class="f-12"><b>Fullname of the candidate</b></p></td>
            <td class="center" colspan="<?php echo $num_columnas_estatus; ?>"><p class="f-11"><b><?php echo $info['candidato']; ?></b></p></td>
          </tr>
          <tr>
            <td class="encabezado right" width="30%"><p class="f-12"><b>Status of the candidate</b></p></td>
            <?php 
              echo $estatus_portada;
            ?>
          </tr>
          <?php 
          //TODO: Manejar este campo de conclusiones de forma que sea automatica dependiendo del cliente
          if($conclusion != null){ 
            echo '<tr>';
            echo '<td class="encabezado right" width="30%"><p class="f-12"><b>Final Statement</b></p></td>';
            echo '<td class="center" colspan="'.$num_columnas_estatus.'"><p class="f-11"><b>'.$conclusion->comentario_final.'</b></p></td>';
            echo '</tr>';
          } ?>
        </table>
        <br>
        <?php 
        if($estatus_final != 'Se define al terminar el estudio'){ ?>
          <div class="flotar-izquierda w-70">
            <table class="w-90">
              <tr>
                <th class="encabezado">Check Item</th>
                <th class="encabezado">Required</th>
                <th class="encabezado">Release date</th>
              </tr>
              <tr>
                <td class="left"><?php echo $subtituloProceso; ?></td>
                <td><p class="f-14">Yes</p></td>
                <td><?php echo $fecha_fin; ?></td>
              </tr>
              <tr>
                <td class="left">Doping test</td>
                <td><p class="f-14"><?php echo $antidoping; ?></p></td>
                <?php 
                if($info['id_cliente'] != 178){ ?>
                  <td><?php echo $fecha_res_doping; ?></td>
                <?php 
                }
                else{ ?>
                  <td>-</td>
                <?php 
                } ?>
              </tr>
              <tr>
                <td class="left">Psicometric test</td>
                <td><p class="f-14"><?php echo $psicometrico; ?></p></td>
                <td><?php echo $f_psicometrico; ?></td>
              </tr>
              <tr>
                <td class="left">Medic test</td>
                <td><p class="f-14"><?php echo $medico; ?></p></td>
                <td><?php echo $f_medico; ?></td>
              </tr>
            </table>	
          </div>
          <div class="w-30 flotar-izquierda">
            <div class="bordes">
              <h5 class="center">INDICATORS	</h5>
            </div>
            <div>
              <div class="w-30 flotar-izquierda">
                <p class="fondo1 padding f-11 center">Positive</p>
                <p  class="fondo2 padding f-11 center">Negative</p>
                <p  class="fondo3 padding f-11 center">UR</p>
                <p  class="padding f-11 center">NA</p>
              </div>
              <div class="w-60">
                <p class="f-11 margin-left padding_top_4"> Recommended to hire</p>
                <p class="f-11 margin-left padding_top_4"> Not recommended to hire</p>
                <p class="f-11 margin-left padding_top_4"> With reservations to hire</p>
                <p class="f-11 margin-left padding_top_4"> No apply</p>
              </div>
            </div>
          </div>
					<!-- Scope of verification -->
					<?php
					if($secciones['tipo_pdf'] == 26){ ?>
						<table class="centrado w-100" style='margin-bottom: 10px;'>
							<tr>
								<th class="encabezado" colspan="2">Scope of Verification</th>
							</tr>
							<?php
							if($secciones['lleva_identidad'] == 1){ ?>
								<tr>
									<td class="encabezado center"><b>Identity</b></td>
									<td class="left"><?php echo $identificaciones; ?></td>
								</tr>
							<?php 
							}
							if($secciones['lleva_empleos'] == 1){ ?>
								<tr>
									<td class="encabezado center"><b>Employment</b></td>
									<?php $tiempoEmpleos = $secciones['tiempo_empleos'] == 'All' ? 'Full history' : $secciones['tiempo_empleos']; ?>
									<td class="left"><?php echo $tiempoEmpleos; ?></td>
								</tr>
							<?php 
							}
							if($secciones['lleva_estudios'] == 1){ ?>
								<tr>
									<td class="encabezado center"><b>Education</b></td>
									<td class="left"><?php echo 'Academic history'; ?></td>
								</tr>
							<?php 
							}
							if($secciones->lleva_criminal == 1){ ?>
								<tr>
									<td class="encabezado center"><b>Criminal</b></td>
									<?php $tiempoCriminales = $secciones['tiempo_criminales'] == 'All' ? 'Full history' : $secciones['tiempo_criminales']; ?>
									<td class="left"><?php echo $tiempoCriminales; ?></td>
								</tr>
							<?php 
							}
							if(in_array(11, $documentosCandidato)){ ?>
								<tr>
									<td class="encabezado center"><b>OFAC</b></td>
									<td class="left">No record found</td>
								</tr>
							<?php 
							}
							if($secciones['id_seccion_global_search'] != NULL){ ?>
								<tr>
									<td class="encabezado center"><b>Global database</b></td>
									<td class="left"><?php echo $detallesSeccionGlobal['descripcion_ingles']; ?></td>
								</tr>
							<?php 
							}
							if($pruebas['antidoping'] > 0){ ?>
								<tr>
									<td class="encabezado center"><b>Drug test</b></td>
									<td class="left"><?php echo $descripcion_doping; ?></td>
								</tr>
							<?php 
							}
							if($pruebas['medico']== 1){ ?>
								<tr>
									<td class="encabezado center"><b>Medical test</b></td>
									<td class="left"><?php echo 'Required'; ?></td>
								</tr>
							<?php 
							}
							if($secciones['id_seccion_historial_domicilios'] != NULL){ ?>
								<tr>
									<td class="encabezado center"><b>Address</b></td>
									<?php $tiempoDomicilios = $secciones['tiempo_domicilios']== 'All' ? 'Full history' : $secciones['tiempo_domicilios']; ?>
									<td class="left"><?php echo $tiempoDomicilios; ?></td>
								</tr>
							<?php 
							}
							if($secciones->lleva_credito == 1 && $info['status_bgc'] > 0){ ?>
								<tr>
									<td class="encabezado center"><b>Credit</b></td>
									<td class="left">Checked</td>
								</tr>
							<?php 
							}
							if(in_array(10, $documentosCandidato) && !empty($conclusion) && $verDoc->licencia !== NULL){ ?>
								<tr>
									<td class="encabezado center"><b>Professional accreditation</b></td>
									<td class="left"><?php echo 'Verified with document: '.$s_professional_acreditation; ?></td>
								</tr>
							<?php 
							}
							if(in_array(48, $documentosCandidato) && $info['status_bgc'] > 0){ ?>
								<tr>
									<td class="encabezado center"><b>Academic credential</b></td>
									<td class="left">Checked</td>
								</tr>
							<?php 
							}
							if(in_array(42, $documentosCandidato) && $info['status_bgc'] > 0){ ?>
								<tr>
									<td class="encabezado center"><b>Sex offender</b></td>
									<td class="left">No record found</td>
								</tr>
							<?php 
							}
							if(!empty($refPersonal) && $info['status_bgc'] > 0){ ?>
								<tr>
									<td class="encabezado center"><b>Personal references</b></td>
									<td class="left">Checked</td>
								</tr>
							<?php 
							}
							if(!empty($refAcademicas) && $info['status_bgc'] > 0){ ?>
								<tr>
									<td class="encabezado center"><b>Academic references</b></td>
									<td class="left">Checked</td>
								</tr>
							<?php 
							}
							if(($conclusion->nss_check == 1 || $conclusion->nss_check == 2) && $verDoc->imss !== NULL){ ?>
								<tr>
									<td class="encabezado center"><b>SSN</b></td>
									<td class="left"><?php echo $verDoc->imss; ?></td>
								</tr>
							<?php 
							}
							if(($conclusion->ciudadania_check == 1 || $conclusion->ciudadania_check == 2) && $verDoc['pasaporte'] !== NULL){ ?>
								<tr>
									<td class="encabezado center"><b>Citizenship</b></td>
									<td class="left"><?php echo 'Validated with Passport '.$verDoc['pasaporte'] ?></td>
								</tr>
							<?php
							} 
							if($secciones->lleva_motor_vehicle_records == 1 && $verDoc->motor_vehicle_records !== NULL){ ?>
								<tr>
									<td class="encabezado center"><b>MVR check</b></td>
									<td class="left"><?php echo $verDoc->motor_vehicle_records; ?></td>
								</tr>
							<?php 
							}
							if($secciones->lleva_prohibited_parties_list == 1 && in_array(30, $documentosCandidato)){ ?>
								<tr>
									<td class="encabezado center"><b>Prohibited Parties List</b></td>
									<td class="left">No record found</td>
								</tr>
							<?php 
							}
							if(($conclusion->militar_check == 1 || $conclusion->militar_check == 2) && $verDoc->militar !== NULL){ ?>
								<tr>
									<td class="encabezado center"><b>Military</b></td>
									<td class="left"><?php echo $verDoc->militar.' '.$verDoc->militar_fecha; ?></p></td>
								</tr>
							<?php 
							}
							if(!empty($refProfesionales) && $info['status_bgc'] > 0){ ?>
								<tr>
									<td class="encabezado center"><b>Professional references</b></td>
									<td class="left">Checked</td>
								</tr>
							<?php 
							}
							if($info['edad']<= 16 && $secciones['id_seccion_datos_generales'] != NULL){ ?>
								<tr>
									<td class="encabezado center"><b>Age check</b></td>
									<td class="left"><?php echo $info->edad.' years old'; ?></p></td>
								</tr>
							<?php
							}
							if($secciones->lleva_curp == 1 && (in_array(3, $documentosCandidato) || in_array(5, $documentosCandidato))){ ?>
								<tr>
									<td class="encabezado center">CURP check</td>
									<td class="left">Checked</td>
								</tr>
							<?php 
							}
							?>
						</table>

						<div class="centrado sin-flotar" style="width: 120px; height: 100px; border: 2px dashed #b8bfe6; padding: 3px; text-align: center; position: relative;">
							<span style='position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);'>AUTHORIZED SIGNATURE</span>
            	<img class="" style="display: block; margin: 0 auto; max-width: 100%; max-height: 100%;" src="<?php echo base_url().'img/firmaEstudios.jpg'; ?>">
          	</div>
					<?php
					}
					else{ ?>
						<div class="centrado sin-flotar" style="border: 4px dashed #b8bfe6; height: 220px; width: 28%;">
							<p class="center" style="float: right;">FIRMA DE AUTORIZACIÓN</p>
							<img class="firma" style="border: none;" src="<?php echo base_url().'img/firmaEstudios.jpg'; ?>">
						</div>
					<?php 
					} ?>
          <pagebreak>
        <?php 
        }
      }
    }
  } ?>
<!-- Fin Portada -->

<!-- Tipo PDF 26 -->
<?php 
	if($secciones['tipo_pdf'] == 26){ 
    //* Datos Generales 
    if($secciones['id_seccion_datos_generales'] == 82){ ?>
      <p class="center f-18">Personal Data </p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 encabezado">Name:</td>
            <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Date of birth:</td>
            <td class="center"><?php echo $fecha_nacimiento; ?></td>
            <td class="encabezado">Age:</td>
            <td class="center"><?php echo $info['edad'] ?></td>
            <td class="encabezado w-17">Job Position Requested:</td>
            <td class="center"><?php echo $info['puesto']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Nationality:</td>
            <td class="center"><?php echo $info['nacionalidad']; ?></td>
            <td class="encabezado">Gender:</td>
            <td class="center"><?php echo $genero_ingles; ?></td>
            <td class="encabezado">Marital Status:</td>
            <td class="center"><?php echo $estado_civil_ingles; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Address:</td>
            <td class="center"><?php echo $info['calle']; ?></td>
            <td class="encabezado">Ext. Num:</td>
            <td class="center"><?php echo $info['exterior']; ?></td>
            <td class="encabezado">Int. Num:</td>
            <?php $interior = ($info['interior'] != null && $info['interior'] != '')? $info['interior'] : 'Not provided'; ?>
            <td class="center"><?php echo $interior; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Neighborhood:</td>
            <td class="center"><?php echo $info['colonia'] ?></td>
            <td class="encabezado">State:</td>
            <td class="center"><?php echo $info['estado']; ?></td>
            <td class="encabezado">City:</td>
            <td class="center"><?php echo$info['municipio']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Zip Code:</td>
            <td class="center"><?php echo $info['cp']; ?></td>
            <td class="encabezado">Mobile Num:</td>
            <td class="center"><?php echo $info['celular']; ?></td>
            <td class="encabezado">Home Num:</td>
            <?php $telefono_casa = ($info['telefono_casa'] != null && $info['telefono_casa'] != '')? $info['telefono_casa'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_casa; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Number to leave Messages:</td>
            <?php $telefono_otro = ($info['telefono_otro'] != null && $info['telefono_otro'] != '')? $info['telefono_otro'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_otro; ?></td>
            <td class="encabezado">E-mail:</td>
            <td class="center" colspan="3"><?php echo $info['correo']; ?></td>
          </tr>
        </table>
      </div>
    <?php  
    }
    if($secciones['id_seccion_datos_generales'] == 83){ ?>
      <p class="center f-18">Personal Data </p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 encabezado">Name:</td>
            <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Date of birth:</td>
            <td class="center"><?php echo $fecha_nacimiento; ?></td>
            <td class="encabezado">Age:</td>
            <td class="center"><?php echo $info['edad'] ?></td>
            <td class="encabezado w-17">Job Position Requested:</td>
            <td class="center"><?php echo $info['puesto']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Nationality:</td>
            <td class="center"><?php echo $info['nacionalidad']; ?></td>
            <td class="encabezado">Gender:</td>
            <td class="center"><?php echo $genero_ingles; ?></td>
            <td class="encabezado">Marital Status:</td>
            <td class="center"><?php echo $estado_civil_ingles; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Address:</td>
            <td class="center" colspan="5"><?php echo $info['domicilio_internacional']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Mobile Num:</td>
            <td class="center"><?php echo $info['celular']; ?></td>
            <td class="encabezado">Home Num:</td>
            <?php $telefono_casa = ($info['telefono_casa'] != null && $info['telefono_casa'] != '')? $info['telefono_casa'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_casa; ?></td>
            <td class="encabezado">Number to leave Messages:</td>
            <?php $telefono_otro = ($info['telefono_otro'] != null && $info['telefono_otro'] != '')? $info['telefono_otro'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_otro; ?></td>
          </tr>
          <tr>
            <td class="encabezado">E-mail:</td>
            <td class="center" colspan="5"><?php echo $info['correo']; ?></td>
          </tr>
        </table>
      </div>
    <?php  
    }
    //* Documentacion
    if($secciones['id_seccion_verificacion_docs'] == 48 && $verDoc != null){ ?>
		  <p class="center f-18">Documents</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-30 encabezado">Document</th>
            <th class="w-40 encabezado">Number</th>
            <th class="w-30 encabezado">Date/Institution</th>
          </tr>
          <tr>
            <td class="encabezado center">School Certificate / Professional License</td>
            <td class="center"><?php echo $verDoc['licencia'] ?></td>
            <td class="center"><?php echo $verDoc['licencia_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">ID</td>
            <?php $ine_completo = "ID:<br>".$verDoc['ine']."<br>Register Date:<br>".$verDoc['ine_ano'].''; ?>
            <td class="center"><?php echo $ine_completo; ?></td>
            <td class="center"><?php echo $verDoc['ine_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Passport</td>
            <td class="center"><?php echo $verDoc['pasaporte'] ?></td>
            <td class="center"><?php echo $verDoc['pasaporte_fecha']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Non-criminal background letter</td>
            <td class="center"><?php echo $verDoc['penales']; ?></td>
            <td class="center"><?php echo $verDoc['penales_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Migration Form</td>
            <td class="center"><?php echo $verDoc['forma_migratoria']; ?></td>
            <td class="center"><?php echo $verDoc['forma_migratoria_fecha']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comments</td>
            <td class="center" colspan="2"><?php echo $verDoc['comentarios']; ?></td>
          </tr>
        </table>
      </div>
      <pagebreak>
    <?php
    }
    //* Estudios
    if($secciones['id_estudios'] == 29 && $academico != null){ ?>
		  <p class="center f-18">Studies Record</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-10 encabezado">Level</th>
            <th class="w-15 encabezado">Period</th>
            <th class="w-20 encabezado">Institute</th>
            <th class="w-20 encabezado">City</th>
            <th class="w-20 encabezado">Certificate Obtained</th>
            <th class="w-15 encabezado">Validated</th>
          </tr>
          <tr>
            <td class="encabezado center">Elementary School</td>
            <td class="center"><?php echo $academico['primaria_periodo']; ?></td>
            <td class="center"><?php echo $academico['primaria_escuela']; ?></td>
            <td class="center"><?php echo $academico['primaria_ciudad']; ?></td>
            <td class="center"><?php echo $academico['primaria_certificado']; ?></td>
            <td class="center"><?php echo $valid = ($academico->primaria_validada == 1)?'Yes':'No'; ?></td>
          </tr>
          <?php 
          if($academico['secundaria_periodo'] != null && $academico['secundaria_periodo'] != ''){ ?>
            <tr>
              <td class="encabezado center">Middle School</td>
              <td class="center"><?php echo $academico['secundaria_periodo']; ?></td>
              <td class="center"><?php echo $academico['secundaria_escuela']; ?></td>
              <td class="center"><?php echo $academico['secundaria_ciudad']; ?></td>
              <td class="center"><?php echo $academico['secundaria_certificado']; ?></td>
              <td class="center"><?php echo $valid = ($academico->secundaria_validada == 1)?'Yes':'No'; ?></td>
            </tr>
          <?php 
          }
          if($academico['preparatoria_periodo'] != null && $academico['preparatoria_periodo'] != ''){ ?>
            <tr>
              <td class="encabezado center">High School</td>
              <td class="center"><?php echo $academico['preparatoria_periodo']; ?></td>
              <td class="center"><?php echo $academico['preparatoria_escuela']; ?></td>
              <td class="center"><?php echo $academico['preparatoria_ciudad']; ?></td>
              <td class="center"><?php echo $academico['preparatoria_certificado']; ?></td>
              <td class="center"><?php echo $valid = ($academico->preparatoria_validada == 1)?'Yes':'No'; ?></td>
            </tr>
          <?php 
          }
          if($academico['licenciatura_periodo'] != null && $academico['licenciatura_periodo'] != ''){ ?>
            <tr>
              <td class="encabezado center">College</td>
              <td class="center"><?php echo $academico['licenciatura_periodo']; ?></td>
              <td class="center"><?php echo $academico['licenciatura_escuela']; ?></td>
              <td class="center"><?php echo $academico['licenciatura_ciudad']; ?></td>
              <td class="center"><?php echo $academico['licenciatura_certificado']; ?></td>
              <td class="center"><?php echo $valid = ($academico->licenciatura_validada == 1)?'Yes':'No'; ?></td>
            </tr>
          <?php 
          } ?>
          <tr>
            <td class="encabezado center" colspan="6"><b>Seminaries/Courses Certificates:</b></td>
          </tr>
          <tr>
            <td class="left" colspan="6"><?php echo $academico['otros_certificados']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comments</td>
            <td class="center" colspan="5"><?php echo $academico['comentarios']; ?></td>
          </tr>
        </table>
      </div><br>
		  <p class="center f-18">Break(s) in Studies</p>
      <div class="center">
        <textarea class="comentario" rows="3"><?php echo $academico['carrera_inactivo']; ?></textarea>
      </div><br>
      <div class="div_datos">
        <p class="center f-18">School Document Verification</p>
        <table class="">
          <tr>
            <td class="encabezado center">Studies verification requested</td>
            <td class="center"><?php echo $fecha_alta; ?></td>
            <td class="center" rowspan="2"><?php echo $verificacionEstudios->status; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Verification completed</td>
            <td class="center"><?php echo $fechaVerificacionEstudios = fechaPorIdioma($verificacionEstudios->edicion, 'ingles'); ?></td>
          </tr>
        </table>
      </div><br>
      <div class="div_datos">
        <table>
          <?php 
          if($verificacionDetallesEstudios){
            foreach($verificacionDetallesEstudios as $row){
              $fecha_detalle = fechaPorIdioma($row['fecha'], 'ingles');
              echo '<tr>';
              echo '<td class="center w-17">'.$fecha_detalle.'</td>';
              echo '<td class="center">'.$row->comentarios.'</td>';
              echo '</tr>';
            }
          } ?>
        </table>
      </div>
      <pagebreak>
    <?php
    }
    //* Laborales
    if($secciones['id_empleos'] == 16 || $secciones['id_empleos'] == 59 && $empleos != NULL){ 
			$cont = 1;
			foreach($empleos as $ref){
				$ver_laboral = $this->candidato_laboral_model->getVerificacionLaboralByNumber($cont, $info['id']); ?>
				<p class="center f-18">Employment History </p>
				<div class="div_datos">
					<table class="">
            <tr>
              <th class="encabezado"></th>
              <th class="encabezado">Candidate</th>
              <th class="encabezado">Company</th>
              <th class="encabezado">Notes</th>
            </tr>
            <tr>
              <td class="encabezado center">Company</td>
              <td class="center"><?php echo $ref['empresa']; ?></td>
              <td class="center"><?php echo $vivienda['empresa'] ?></td>
              <td class="left w-30" rowspan="12"><?php echo $vivienda['notas']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Address</td>
              <td class="center"><?php echo $ref['direccion']; ?></td>
              <td class="center"><?php echo $ver_laboral['direccion']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Entry Date</td>
              <td class="center"><?php echo $ref['fecha_entrada_txt']; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_entrada_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Exit Date</td>
              <td class="center"><?php echo $ref->fecha_salida_txt; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_salida_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Phone</td>
              <td class="center"><?php echo $ref['telefono']; ?></td>
              <td class="center"><?php echo $ver_laboral['telefono']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Initial Job Position</td>
              <td class="center"><?php echo $ref['puesto1']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto1']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Last Job Position</td>
              <td class="center"><?php echo $ref['puesto2']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto2']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Immediate Boss</td>
              <?php  
              $jefe_nombre = ($ref['jefe_nombre'] != null)? $ref['jefe_nombre'] : 'Not provided'; 
              $jefe_correo = ($ref['jefe_correo'] != null)? $ref['jefe_correo'] : 'Not provided'; ?>
              <td class="center"><?php echo $jefe_nombre."<br>".$jefe_correo; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_nombre']."<br>".$ver_laboral['jefe_correo']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Boss’s Job Position</td>
              <td class="center"><?php echo $ref['jefe_puesto']; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_puesto']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Cause of Separation</td>
              <td class="center"><?php echo $ref->causa_separacion; ?></td>
              <td class="center"><?php echo $ver_laboral['causa_separacion']; ?></td>
            </tr>
					</table>
				</div><br>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<td class="encabezado w-60">Did the candidate sue the company:</td>
					    	<td class="center"><?php echo $demanda = ($ver_laboral->demanda == 1)?'Yes':'No'; ?></td>
					  	</tr>
					</table>
				</div><br>
				<p class="f-14 center">Candidate Performance<br>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<th class="encabezado w-60">Area</th>
					    	<th class="encabezado">Calification</th>
					  	</tr>
					  	<?php 
					  	if($ver_laboral->responsabilidad == "Not provided" && $ver_laboral->iniciativa == "Not provided" && $ver_laboral->eficiencia == "Not provided" && $ver_laboral->disciplina == "Not provided" && $ver_laboral->puntualidad == "Not provided" && $ver_laboral->limpieza == "Not provided" && $ver_laboral->estabilidad == "Not provided" && $ver_laboral->emocional == "Not provided" && $ver_laboral->honestidad == "Not provided" && $ver_laboral->rendimiento == "Not provided" && $ver_laboral->actitud == "Not provided"){
					  		echo '<tr>
					  				<td class="encabezado center">Responsability</td>
					    			<td class="center" rowspan="11">Not provided</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Initiative</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Work efficiency</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Discipline</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Punctuality and assistance</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Cleanliness and order</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Stability</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Emotional Stability</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Honesty</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Performance</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
				  				</tr>';
					  	}
					  	else{
					  		if($ver_laboral->responsabilidad == "Excellent" && $ver_laboral->iniciativa == "Excellent" && $ver_laboral->eficiencia == "Excellent" && $ver_laboral->disciplina == "Excellent" && $ver_laboral->puntualidad == "Excellent" && $ver_laboral->limpieza == "Excellent" && $ver_laboral->estabilidad == "Excellent" && $ver_laboral->emocional == "Excellent" && $ver_laboral->honestidad == "Excellent" && $ver_laboral->rendimiento == "Excellent" && $ver_laboral->actitud == "Excellent"){
						  		echo '<tr>
						  				<td class="encabezado center">Responsability</td>
						    			<td class="center" rowspan="11">Excellent</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Initiative</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Work efficiency</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Discipline</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Punctuality and assistance</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Cleanliness and order</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Stability</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Emotional Stability</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Honesty</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Performance</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
					  				</tr>';
						  	}
						  	else{
						  		if($ver_laboral->responsabilidad == "Good" && $ver_laboral->iniciativa == "Good" && $ver_laboral->eficiencia == "Good" && $ver_laboral->disciplina == "Good" && $ver_laboral->puntualidad == "Good" && $ver_laboral->limpieza == "Good" && $ver_laboral->estabilidad == "Good" && $ver_laboral->emocional == "Good" && $ver_laboral->honestidad == "Good" && $ver_laboral->rendimiento == "Good" && $ver_laboral->actitud == "Good"){
							  		echo '<tr>
							  				<td class="encabezado center">Responsability</td>
							    			<td class="center" rowspan="11">Good</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Initiative</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Work efficiency</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Discipline</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Punctuality and assistance</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Cleanliness and order</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Stability</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Emotional Stability</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Honesty</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Performance</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
						  				</tr>';
							  	}
							  	else{
							  		if($ver_laboral->responsabilidad == "Regular" && $ver_laboral->iniciativa == "Regular" && $ver_laboral->eficiencia == "Regular" && $ver_laboral->disciplina == "Regular" && $ver_laboral->puntualidad == "Regular" && $ver_laboral->limpieza == "Regular" && $ver_laboral->estabilidad == "Regular" && $ver_laboral->emocional == "Regular" && $ver_laboral->honestidad == "Regular" && $ver_laboral->rendimiento == "Regular" && $ver_laboral->actitud == "Regular"){
								  		echo '<tr>
								  				<td class="encabezado center">Responsability</td>
								    			<td class="center" rowspan="11">Regular</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Initiative</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Work efficiency</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Discipline</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Punctuality and assistance</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Cleanliness and order</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Stability</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Emotional Stability</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Honesty</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Performance</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
							  				</tr>';
								  	}
								  	else{
								  		if($ver_laboral->responsabilidad == "Bad" && $ver_laboral->iniciativa == "Bad" && $ver_laboral->eficiencia == "Bad" && $ver_laboral->disciplina == "Bad" && $ver_laboral->puntualidad == "Bad" && $ver_laboral->limpieza == "Bad" && $ver_laboral->estabilidad == "Bad" && $ver_laboral->emocional == "Bad" && $ver_laboral->honestidad == "Bad" && $ver_laboral->rendimiento == "Bad" && $ver_laboral->actitud == "Bad"){
									  		echo '<tr>
									  				<td class="encabezado center">Responsability</td>
									    			<td class="center" rowspan="11">Bad</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Initiative</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Work efficiency</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Discipline</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Punctuality and assistance</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Cleanliness and order</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Stability</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Emotional Stability</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Honesty</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Performance</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
								  				</tr>';
									  	}
									  	else{
									  		if($ver_laboral->responsabilidad == "Very Bad" && $ver_laboral->iniciativa == "Very Bad" && $ver_laboral->eficiencia == "Very Bad" && $ver_laboral->disciplina == "Very Bad" && $ver_laboral->puntualidad == "Very Bad" && $ver_laboral->limpieza == "Very Bad" && $ver_laboral->estabilidad == "Very Bad" && $ver_laboral->emocional == "Very Bad" && $ver_laboral->honestidad == "Very Bad" && $ver_laboral->rendimiento == "Very Bad" && $ver_laboral->actitud == "Very Bad"){
										  		echo '<tr>
										  				<td class="encabezado center">Responsability</td>
										    			<td class="center" rowspan="11">Very Bad</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Initiative</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Work efficiency</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Discipline</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Punctuality and assistance</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Cleanliness and order</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Stability</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Emotional Stability</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Honesty</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Performance</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
									  				</tr>';
										  	}
										  	else{
										  		echo '<tr>
										  				<td class="encabezado center">Responsability</td>
										    			<td class="center">'.$ver_laboral->responsabilidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Initiative</td>
										  				<td class="center">'.$ver_laboral->iniciativa.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Work efficiency</td>
										  				<td class="center">'.$ver_laboral->eficiencia.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Discipline</td>
										  				<td class="center">'.$ver_laboral->disciplina.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Punctuality and assistance</td>
										  				<td class="center">'.$ver_laboral->puntualidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Cleanliness and order</td>
										  				<td class="center">'.$ver_laboral->limpieza.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Stability</td>
										  				<td class="center">'.$ver_laboral->estabilidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Emotional Stability</td>
										  				<td class="center">'.$ver_laboral->emocional.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Honesty</td>
										  				<td class="center">'.$ver_laboral->honestidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Performance</td>
										  				<td class="center">'.$ver_laboral->rendimiento.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
										  				<td class="center">'.$ver_laboral->actitud.'</td>
									  				</tr>';
										  	}
									  	}
								  	}
							  	}
						  	}
					  	}
					  	?>
					</table>
				</div>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<td class="encabezado w-60">In case of vacancy would you hire her/him again?</td>
                <?php 
                if($ver_laboral->recontratacion == 0){
                  $recontratacion ='No';
                }
                if($ver_laboral->recontratacion == 2){
                  $recontratacion ='N/A';
                }
                if($ver_laboral->recontratacion == 1){
                  $recontratacion ='Yes';
                } ?>
					    	<td class="center"><?php echo $recontratacion; ?></td>
					  	</tr>
					  	<tr>
					    	<td class="encabezado w-60">Why?</td>
					    	<td class="center"><?php echo $ver_laboral->motivo_recontratacion; ?></td>
					  	</tr>
					</table>
				</div>
        <pagebreak>
				<?php
				$cont++;
      } ?>

      <p class="center f-18">Break(s) in Employment</p>
      <div class="center">
        <textarea class="comentario" rows="3"><?php echo $info->trabajo_inactivo; ?></textarea>
      </div><br>
      <div class="center">
        <p class="center f-18">Has he worked in any government entity, Politic Party or NGO?</p>
      </div>
      <div class="center">
        <textarea class="comentario" rows="3"><?php echo $info['trabajo_gobierno'] ; ?></textarea>
      </div>
      <div class="div_datos">
        <p class="center f-18">Employment history verification</p>
        <table class="">
          <tr>
            <td class="encabezado center">Labor verification requested</td>
            <td class="center"><?php echo $fecha_alta; ?></td>
            <!--td class="center" rowspan="2"><?php //echo $verificacionEmpleos->status; ?></!--td-->
          </tr>
          <tr>
            <td class="encabezado center">Verification completed</td>
            <td class="center"><?php echo $fechaVerificacionEmpleos = fechaPorIdioma($verificacionEmpleos['edicion'] , 'ingles'); ?></td>
          </tr>
        </table>
      </div><br>
      <div class="div_datos">
        <table>
          <?php 
          if($verificacionDetallesEmpleos){
            foreach($verificacionDetallesEmpleos as $row){
              $fecha_detalle = fechaPorIdioma($row['fecha'], 'ingles');
              echo '<tr>';
              echo '<td class="center w-17">'.$fecha_detalle.'</p></td>';
              echo '<td class="center">'.$row->comentarios.'</p></td>';
              echo '</tr>';
            }
          }
          ?>
        </table>
      </div><br>
      <pagebreak>

      <?php
		}
    //* Referencias personales
    if($secciones['cantidad_ref_personales']> 0 && $secciones['id_ref_personales'] == 31 && $refPersonal != null){ ?>
      <p class="center f-18">Personal References</p>
      <div class="div_datos">
        <?php $salida2 = '';
        foreach($refPersonal as $refper){
          if($refper['sabe_trabajo'] == 0 || $refper['sabe_vive'] == 0){
            $sabe_trabajo = "No";
            $sabe_vive = "No";
          }
          if($refper['sabe_trabajo'] == 1 || $refper['sabe_vive'] == 1){
            $sabe_trabajo = "Yes";
            $sabe_vive = "Yes";
          }
          if($refper['sabe_trabajo'] == 2 || $refper['sabe_vive'] == 2){
            $sabe_trabajo = "NA";
            $sabe_vive = "NA";
          }
          $salida2 .= '<table class=""><tr>';
          $salida2 .= '<td class="w-30 encabezado left">Name</td>';
          $salida2 .= '<td class="w-30 center">'.$refper['nombre'].'</td>';
          $salida2 .= '<td class="w-20 encabezado left">Phone</td>';
          $salida2 .= '<td class="w-20 center">'.$refper['telefono'].'</td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">Time to know her/him</td>';
          $salida2 .= '<td class="center">'.$refper['tiempo_conocerlo'].'</td>';
          $salida2 .= '<td class="encabezado left">Why do you know her/him</td>';
          $salida2 .= '<td class="center">'.$refper['donde_conocerlo'].'</td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">Does she/he know where the candidate works/worked?</td>';
          $salida2 .= '<td class="center">'.$sabe_trabajo.'</td>';
          $salida2 .= '<td class="encabezado left">Does she/he know where the candidate lives?</td>';
          $salida2 .= '<td class="center">'.$sabe_vive.'</td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">Does she/he recommend to candidate?</td>';
          $salida2 .= '<td class="center">'.$recomienda = ($refper['recomienda'] == 1)? "Yes, she/he does" : "No, she/he does not".'</td>';
          $salida2 .= '<td class="encabezado left"></td>';
          $salida2 .= '<td class="center"></td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">Comentario</td>';
          $salida2 .= '<td class="center" colspan="3">'.$refper['comentario'].'</td>';
          $salida2 .= '</tr></table><br>';
        }
        echo $salida2;
        ?>		  	
      </div><br>
      <pagebreak>
    <?php 
    }
    //* Global searches
    if($secciones['id_seccion_global_search'] == 86 && $secciones['id_seccion_global_search'] != null){ ?>
			<p class="center f-18">Global Searches</p>
      <div class="div_datos">
        <table class="">
          <tr>
			    	<td class="w-20 encabezado left">Global compliance & Sanctions database</td>
			    	<td class="w-80 center"><?php echo $global_searches['sanctions']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">Global media searches</td>
			    	<td class="center"><?php echo $global_searches['media_searches']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">OIG</td>
			    	<td class="center"><?php echo $global_searches['oig']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">SAM</td>
			    	<td class="center"><?php echo $global_searches['sam'] ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">OFAC</td>
			    	<td class="center"><?php echo $global_searches['ofac']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">INTERPOL</td>
			    	<td class="center"><?php echo $global_searches['interpol']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">MVR</td>
			    	<td class="center"><?php echo $global_searches['motor_vehicle_records']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><?php echo $global_searches['global_comentarios']; ?></td>
			  	</tr>
        </table>
      </div>
    <?php
    }
    
    //* Documentos
    if($docs){
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Privacy Notice </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 3){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>ID </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 12){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Criminal Records </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 11){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OFAC </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 17){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OIG </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 21){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>SAM </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 29){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>INTERPOL </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 44){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Motor Vehicle Records </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 18){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Global Search Check </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 42){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Sex Offender </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 7){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Studies Certificate </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 10){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Professional Licence </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 9){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Employment History (SSN) </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 13){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Employment Letter </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
		foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 37){
							echo '<pagebreak>';
							echo '<div class="center">';
							echo '<h2>Driver licence </h2>';
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
							echo '</div>';
						}
					}
    }
  }
	?>
<!-- Tipo PDF 26 -->

<!-- Tipo PDF 25 Copia del 14 -->
<?php 
	if($secciones['tipo_pdf'] == 25){ 
    //* Datos Generales 
    if($secciones['id_seccion_datos_generales'] == 82){ ?>
      <p class="center f-18">Datos Generales </p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 encabezado">Nombre:</td>
            <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Fecha de nacimiento:</td>
            <td class="center"><?php echo $fecha_nacimiento; ?></td>
            <td class="encabezado">Edad:</td>
            <td class="center"><?php echo $info['edad'] ?></td>
            <td class="encabezado w-17">Puesto:</td>
            <td class="center"><?php echo $info['puesto']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Nacionalidad:</td>
            <td class="center"><?php echo $info['nacionalidad']; ?></td>
            <td class="encabezado">Género:</td>
            <td class="center"><?php echo $info['genero']; ?></td>
            <td class="encabezado">Estado civil:</td>
            <td class="center"><?php echo $info['estado_civil']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Calle:</td>
            <td class="center"><?php echo $info['calle']; ?></td>
            <td class="encabezado">No. Exterior:</td>
            <td class="center"><?php echo $info['exterior']; ?></td>
            <td class="encabezado">No. Interior:</td>
            <?php $interior = ($info['interior'] != null && $info['interior'] != '')? $info['interior'] : 'No proporcionado'; ?>
            <td class="center"><?php echo $interior; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Colonia:</td>
            <td class="center"><?php echo $info['colonia'] ?></td>
            <td class="encabezado">Estado:</td>
            <td class="center"><?php echo $info['estado']; ?></td>
            <td class="encabezado">Ciudad:</td>
            <td class="center"><?php echo$info['municipio']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">CP:</td>
            <td class="center"><?php echo $info['cp']; ?></td>
            <td class="encabezado">Tel. Celular:</td>
            <td class="center"><?php echo $info['celular']; ?></td>
            <td class="encabezado">Tel. Casa:</td>
            <?php $telefono_casa = ($info['telefono_casa'] != null && $info['telefono_casa'] != '')? $info['telefono_casa'] : 'No proporcionado'; ?>
            <td class="center"><?php echo $telefono_casa; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Otro teléfono:</td>
            <?php $telefono_otro = ($info['telefono_otro'] != null && $info['telefono_otro'] != '')? $info['telefono_otro'] : 'No proporcionado'; ?>
            <td class="center"><?php echo $telefono_otro; ?></td>
            <td class="encabezado">Correo electrónico:</td>
            <td class="center" colspan="3"><?php echo $info['correo']; ?></td>
          </tr>
        </table>
      </div>
    <?php  
    }
    if($secciones['id_seccion_datos_generales'] == 83){ ?>
      <p class="center f-18">Datos Generales </p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 encabezado">Nombre:</td>
            <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
					<td class="encabezado">Fecha de nacimiento:</td>
            <td class="center"><?php echo $fecha_nacimiento; ?></td>
            <td class="encabezado">Edad:</td>
            <td class="center"><?php echo $info['edad'] ?></td>
            <td class="encabezado w-17">Puesto:</td>
            <td class="center"><?php echo $info['puesto']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Nacionalidad:</td>
            <td class="center"><?php echo $info['nacionalidad']; ?></td>
            <td class="encabezado">Género:</td>
            <td class="center"><?php echo $info['genero']; ?></td>
            <td class="encabezado">Estado civil:</td>
            <td class="center"><?php echo $info['estado_civil']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Domicilio:</td>
            <td class="center" colspan="5"><?php echo $info['domicilio_internacional']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Tel. Celular:</td>
            <td class="center"><?php echo $info['celular']; ?></td>
            <td class="encabezado">Tel. Casa:</td>
            <?php $telefono_casa = ($info['telefono_casa'] != null && $info['telefono_casa'] != '')? $info['telefono_casa'] : 'No proporcionado'; ?>
            <td class="center"><?php echo $telefono_casa; ?></td>
            <td class="encabezado">Otro teléfono:</td>
            <?php $telefono_otro = ($info['telefono_otro'] != null && $info['telefono_otro'] != '')? $info['telefono_otro'] : 'No proporcionado'; ?>
            <td class="center"><?php echo $telefono_otro; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Correo electrónico:</td>
            <td class="center" colspan="5"><?php echo $info['correo']; ?></td>
          </tr>
        </table>
      </div>
    <?php  
    }
    //* Documentacion
    if($secciones['id_seccion_verificacion_docs'] == 48 && $verDoc != null){ ?>
		  <p class="center f-18">Documentación</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-30 encabezado">Documento</th>
            <th class="w-40 encabezado">Número</th>
            <th class="w-30 encabezado">Fecha/Institución</th>
          </tr>
          <tr>
            <td class="encabezado center">Certificado de estudios</td>
            <td class="center"><?php echo $verDoc['licencia'] ?></td>
            <td class="center"><?php echo $verDoc['licencia_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">ID</td>
            <?php $ine_completo = "ID:<br>".$verDoc['ine']."<br>Fecha de registro:<br>".$verDoc['ine_ano'].''; ?>
            <td class="center"><?php echo $ine_completo; ?></td>
            <td class="center"><?php echo $verDoc['ine_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Pasaporte</td>
            <td class="center"><?php echo $verDoc['pasaporte'] ?></td>
            <td class="center"><?php echo $verDoc['pasaporte_fecha']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Carta de antecedentes no penales</td>
            <td class="center"><?php echo $verDoc['penales']; ?></td>
            <td class="center"><?php echo $verDoc['penales_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Formulario de migración</td>
            <td class="center"><?php echo $verDoc['forma_migratoria']; ?></td>
            <td class="center"><?php echo $verDoc['forma_migratoria_fecha']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comentarios</td>
            <td class="center" colspan="2"><?php echo $verDoc['comentarios']; ?></td>
          </tr>
        </table>
      </div>
      <pagebreak>
    <?php
    }
    //* Estudios
    if($secciones['id_estudios'] == 29 && $academico != null){ ?>
		  <p class="center f-18">Historial de Estudios</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-10 encabezado">Nivel</th>
            <th class="w-15 encabezado">Periodo</th>
            <th class="w-20 encabezado">Instituto</th>
            <th class="w-20 encabezado">Ciudad</th>
            <th class="w-20 encabezado">Documento obtenido</th>
            <th class="w-15 encabezado">Validado</th>
          </tr>
          <tr>
            <td class="encabezado center">Primaria</td>
            <td class="center"><?php echo $academico['primaria_periodo']; ?></td>
            <td class="center"><?php echo $academico['primaria_escuela']; ?></td>
            <td class="center"><?php echo $academico['primaria_ciudad']; ?></td>
            <td class="center"><?php echo $academico['primaria_certificado']; ?></td>
            <td class="center"><?php echo $valid = ($academico->primaria_validada == 1)?'Yes':'No'; ?></td>
          </tr>
          <?php 
          if($academico['secundaria_periodo'] != null && $academico['secundaria_periodo'] != ''){ ?>
            <tr>
              <td class="encabezado center">Secundaria</td>
              <td class="center"><?php echo $academico['secundaria_periodo']; ?></td>
              <td class="center"><?php echo $academico['secundaria_escuela']; ?></td>
              <td class="center"><?php echo $academico['secundaria_ciudad']; ?></td>
              <td class="center"><?php echo $academico['secundaria_certificado']; ?></td>
              <td class="center"><?php echo $valid = ($academico->secundaria_validada == 1)?'Yes':'No'; ?></td>
            </tr>
          <?php 
          }
          if($academico['preparatoria_periodo'] != null && $academico['preparatoria_periodo'] != ''){ ?>
            <tr>
              <td class="encabezado center">Preparatorial/Bachillerato</td>
              <td class="center"><?php echo $academico['preparatoria_periodo']; ?></td>
              <td class="center"><?php echo $academico['preparatoria_escuela']; ?></td>
              <td class="center"><?php echo $academico['preparatoria_ciudad']; ?></td>
              <td class="center"><?php echo $academico['preparatoria_certificado']; ?></td>
              <td class="center"><?php echo $valid = ($academico->preparatoria_validada == 1)?'Yes':'No'; ?></td>
            </tr>
          <?php 
          }
          if($academico['licenciatura_periodo'] != null && $academico['licenciatura_periodo'] != ''){ ?>
            <tr>
              <td class="encabezado center">Licenciatura</td>
              <td class="center"><?php echo $academico['licenciatura_periodo']; ?></td>
              <td class="center"><?php echo $academico['licenciatura_escuela']; ?></td>
              <td class="center"><?php echo $academico['licenciatura_ciudad']; ?></td>
              <td class="center"><?php echo $academico['licenciatura_certificado']; ?></td>
              <td class="center"><?php echo $valid = ($academico->licenciatura_validada == 1)?'Yes':'No'; ?></td>
            </tr>
          <?php 
          } ?>
          <tr>
            <td class="encabezado center" colspan="6"><b>Seminarios/Cursos o Certificaciones:</b></td>
          </tr>
          <tr>
            <td class="left" colspan="6"><?php echo $academico['otros_certificados']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comentarios</td>
            <td class="center" colspan="5"><?php echo $academico['comentarios']; ?></td>
          </tr>
        </table>
      </div><br>
		  <p class="center f-18">Periodos inactivos</p>
      <div class="center">
        <textarea class="comentario" rows="3"><?php echo $academico['carrera_inactivo']; ?></textarea>
      </div><br>
      <div class="div_datos">
        <p class="center f-18">Verificación escolar</p>
        <table class="">
          <tr>
            <td class="encabezado center">Solicitud de verificación</td>
            <td class="center"><?php echo $fecha_alta; ?></td>
            <td class="center" rowspan="2"><?php echo $verificacionEstudios->status; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Verificación completa</td>
            <td class="center"><?php echo $fechaVerificacionEstudios = fechaPorIdioma($verificacionEstudios->edicion, 'ingles'); ?></td>
          </tr>
        </table>
      </div><br>
      <div class="div_datos">
        <table>
          <?php 
          if($verificacionDetallesEstudios){
            foreach($verificacionDetallesEstudios as $row){
              $fecha_detalle = fechaPorIdioma($row['fecha'], 'ingles');
              echo '<tr>';
              echo '<td class="center w-17">'.$fecha_detalle.'</td>';
              echo '<td class="center">'.$row->comentarios.'</td>';
              echo '</tr>';
            }
          } ?>
        </table>
      </div>
      <pagebreak>
    <?php
    }
    //* Laborales
    if($secciones['id_empleos'] == 16 || $secciones['id_empleos'] == 59 && $empleos != NULL){ 
			$cont = 1;
			foreach($empleos as $ref){
				$ver_laboral = $this->candidato_laboral_model->getVerificacionLaboralByNumber($cont, $info['id']); ?>
				<p class="center f-18">Historial de Empleos </p>
				<div class="div_datos">
					<table class="">
            <tr>
              <th class="encabezado"></th>
              <th class="encabezado">Candidato</th>
              <th class="encabezado">Empresa</th>
              <th class="encabezado">Notas</th>
            </tr>
            <tr>
              <td class="encabezado center">Empresa</td>
              <td class="center"><?php echo $ref['empresa']; ?></td>
              <td class="center"><?php echo $vivienda['empresa'] ?></td>
              <td class="left w-30" rowspan="12"><?php echo $vivienda['notas']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Domicilio</td>
              <td class="center"><?php echo $ref['direccion']; ?></td>
              <td class="center"><?php echo $ver_laboral['direccion']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Fecha ingreso</td>
              <td class="center"><?php echo $ref['fecha_entrada_txt']; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_entrada_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Fecha salida</td>
              <td class="center"><?php echo $ref->fecha_salida_txt; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_salida_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Teléfono</td>
              <td class="center"><?php echo $ref['telefono']; ?></td>
              <td class="center"><?php echo $ver_laboral['telefono']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Puesto inicial</td>
              <td class="center"><?php echo $ref['puesto1']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto1']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Puesto final</td>
              <td class="center"><?php echo $ref['puesto2']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto2']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Jefe inmediato</td>
              <?php  
              $jefe_nombre = ($ref['jefe_nombre'] != null)? $ref['jefe_nombre'] : 'Not provided'; 
              $jefe_correo = ($ref['jefe_correo'] != null)? $ref['jefe_correo'] : 'Not provided'; ?>
              <td class="center"><?php echo $jefe_nombre."<br>".$jefe_correo; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_nombre']."<br>".$ver_laboral['jefe_correo']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Puesto del jefe inmediato</td>
              <td class="center"><?php echo $ref['jefe_puesto']; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_puesto']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Causa de separación</td>
              <td class="center"><?php echo $ref->causa_separacion; ?></td>
              <td class="center"><?php echo $ver_laboral['causa_separacion']; ?></td>
            </tr>
					</table>
				</div><br>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<td class="encabezado w-60">¿El candidato demandó a la empresa?:</td>
					    	<td class="center"><?php echo $demanda = ($ver_laboral->demanda == 1)?'Yes':'No'; ?></td>
					  	</tr>
					</table>
				</div><br>
				<p class="f-14 center">Rendimiento del candidato<br>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<th class="encabezado w-60">Área</th>
					    	<th class="encabezado">Calificación</th>
					  	</tr>
					  	<?php 
					  	if($ver_laboral->responsabilidad == "Not provided" && $ver_laboral->iniciativa == "Not provided" && $ver_laboral->eficiencia == "Not provided" && $ver_laboral->disciplina == "Not provided" && $ver_laboral->puntualidad == "Not provided" && $ver_laboral->limpieza == "Not provided" && $ver_laboral->estabilidad == "Not provided" && $ver_laboral->emocional == "Not provided" && $ver_laboral->honestidad == "Not provided" && $ver_laboral->rendimiento == "Not provided" && $ver_laboral->actitud == "Not provided"){
					  		echo '<tr>
					  				<td class="encabezado center">Responsabilidad</td>
					    			<td class="center" rowspan="11">No proporcionada</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Iniciativa</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Eficiencia del trabajo</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Disciplina</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Puntualidad y asistencia</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Limpieza y orden</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Estabilidad</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Estabilidad emocional</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Honestidad</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Rendimiento</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Actitud con colaboradores, jefes y subordinados</td>
				  				</tr>';
					  	}
					  	else{
					  		if($ver_laboral->responsabilidad == "Excellent" && $ver_laboral->iniciativa == "Excellent" && $ver_laboral->eficiencia == "Excellent" && $ver_laboral->disciplina == "Excellent" && $ver_laboral->puntualidad == "Excellent" && $ver_laboral->limpieza == "Excellent" && $ver_laboral->estabilidad == "Excellent" && $ver_laboral->emocional == "Excellent" && $ver_laboral->honestidad == "Excellent" && $ver_laboral->rendimiento == "Excellent" && $ver_laboral->actitud == "Excellent"){
						  		echo '<tr>
						  				<td class="encabezado center">Responsabilidad</td>
						    			<td class="center" rowspan="11">Excelente</td>
					  				</tr>
									<tr>
					  				<td class="encabezado center">Iniciativa</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Eficiencia del trabajo</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Disciplina</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Puntualidad y asistencia</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Limpieza y orden</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Estabilidad</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Estabilidad emocional</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Honestidad</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Rendimiento</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Actitud con colaboradores, jefes y subordinados</td>
				  				</tr>';
						  	}
						  	else{
						  		if($ver_laboral->responsabilidad == "Good" && $ver_laboral->iniciativa == "Good" && $ver_laboral->eficiencia == "Good" && $ver_laboral->disciplina == "Good" && $ver_laboral->puntualidad == "Good" && $ver_laboral->limpieza == "Good" && $ver_laboral->estabilidad == "Good" && $ver_laboral->emocional == "Good" && $ver_laboral->honestidad == "Good" && $ver_laboral->rendimiento == "Good" && $ver_laboral->actitud == "Good"){
							  		echo '<tr>
							  				<td class="encabezado center">Responsabilidad</td>
							    			<td class="center" rowspan="11">Buena</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Initiative</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Work efficiency</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Discipline</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Punctuality and assistance</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Cleanliness and order</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Stability</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Emotional Stability</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Honestidad</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Performance</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
						  				</tr>';
							  	}
							  	else{
							  		if($ver_laboral->responsabilidad == "Regular" && $ver_laboral->iniciativa == "Regular" && $ver_laboral->eficiencia == "Regular" && $ver_laboral->disciplina == "Regular" && $ver_laboral->puntualidad == "Regular" && $ver_laboral->limpieza == "Regular" && $ver_laboral->estabilidad == "Regular" && $ver_laboral->emocional == "Regular" && $ver_laboral->honestidad == "Regular" && $ver_laboral->rendimiento == "Regular" && $ver_laboral->actitud == "Regular"){
								  		echo '<tr>
								  				<td class="encabezado center">Responsabilidad</td>
								    			<td class="center" rowspan="11">Regular</td>
							  				</tr>
											<tr>
												<td class="encabezado center">Iniciativa</td>
											</tr>
											<tr>
												<td class="encabezado center">Eficiencia del trabajo</td>
											</tr>
											<tr>
												<td class="encabezado center">Disciplina</td>
											</tr>
											<tr>
												<td class="encabezado center">Puntualidad y asistencia</td>
											</tr>
											<tr>
												<td class="encabezado center">Limpieza y orden</td>
											</tr>
											<tr>
												<td class="encabezado center">Estabilidad</td>
											</tr>
											<tr>
												<td class="encabezado center">Estabilidad emocional</td>
											</tr>
											<tr>
												<td class="encabezado center">Honestidad</td>
											</tr>
											<tr>
												<td class="encabezado center">Rendimiento</td>
											</tr>
											<tr>
												<td class="encabezado center">Actitud con colaboradores, jefes y subordinados</td>
											</tr>';
								  	}
								  	else{
								  		if($ver_laboral->responsabilidad == "Bad" && $ver_laboral->iniciativa == "Bad" && $ver_laboral->eficiencia == "Bad" && $ver_laboral->disciplina == "Bad" && $ver_laboral->puntualidad == "Bad" && $ver_laboral->limpieza == "Bad" && $ver_laboral->estabilidad == "Bad" && $ver_laboral->emocional == "Bad" && $ver_laboral->honestidad == "Bad" && $ver_laboral->rendimiento == "Bad" && $ver_laboral->actitud == "Bad"){
									  		echo '<tr>
									  				<td class="encabezado center">Responsabilidad</td>
									    			<td class="center" rowspan="11">Mala</td>
								  				</tr>
								  				<tr>
														<td class="encabezado center">Iniciativa</td>
													</tr>
													<tr>
														<td class="encabezado center">Eficiencia del trabajo</td>
													</tr>
													<tr>
														<td class="encabezado center">Disciplina</td>
													</tr>
													<tr>
														<td class="encabezado center">Puntualidad y asistencia</td>
													</tr>
													<tr>
														<td class="encabezado center">Limpieza y orden</td>
													</tr>
													<tr>
														<td class="encabezado center">Estabilidad</td>
													</tr>
													<tr>
														<td class="encabezado center">Estabilidad emocional</td>
													</tr>
													<tr>
														<td class="encabezado center">Honestidad</td>
													</tr>
													<tr>
														<td class="encabezado center">Rendimiento</td>
													</tr>
													<tr>
														<td class="encabezado center">Actitud con colaboradores, jefes y subordinados</td>
													</tr>';
									  	}
									  	else{
									  		if($ver_laboral->responsabilidad == "Very Bad" && $ver_laboral->iniciativa == "Very Bad" && $ver_laboral->eficiencia == "Very Bad" && $ver_laboral->disciplina == "Very Bad" && $ver_laboral->puntualidad == "Very Bad" && $ver_laboral->limpieza == "Very Bad" && $ver_laboral->estabilidad == "Very Bad" && $ver_laboral->emocional == "Very Bad" && $ver_laboral->honestidad == "Very Bad" && $ver_laboral->rendimiento == "Very Bad" && $ver_laboral->actitud == "Very Bad"){
										  		echo '<tr>
										  				<td class="encabezado center">Responsabilidad</td>
										    			<td class="center" rowspan="11">Very Bad</td>
									  				</tr>
									  				<tr>
															<td class="encabezado center">Iniciativa</td>
														</tr>
														<tr>
															<td class="encabezado center">Eficiencia del trabajo</td>
														</tr>
														<tr>
															<td class="encabezado center">Disciplina</td>
														</tr>
														<tr>
															<td class="encabezado center">Puntualidad y asistencia</td>
														</tr>
														<tr>
															<td class="encabezado center">Limpieza y orden</td>
														</tr>
														<tr>
															<td class="encabezado center">Estabilidad</td>
														</tr>
														<tr>
															<td class="encabezado center">Estabilidad emocional</td>
														</tr>
														<tr>
															<td class="encabezado center">Honestidad</td>
														</tr>
														<tr>
															<td class="encabezado center">Rendimiento</td>
														</tr>
														<tr>
															<td class="encabezado center">Actitud con colaboradores, jefes y subordinados</td>
														</tr>';
										  	}
										  	else{
										  		echo '<tr>
										  				<td class="encabezado center">Responsabilidad</td>
										    			<td class="center">'.$ver_laboral->responsabilidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Iniciativa</td>
										  				<td class="center">'.$ver_laboral->iniciativa.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Eficiencia del trabajo</td>
										  				<td class="center">'.$ver_laboral->eficiencia.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Disciplina</td>
										  				<td class="center">'.$ver_laboral->disciplina.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Puntualidad y asistencia</td>
										  				<td class="center">'.$ver_laboral->puntualidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Limpieza y orden</td>
										  				<td class="center">'.$ver_laboral->limpieza.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Estabilidad</td>
										  				<td class="center">'.$ver_laboral->estabilidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Estabilidad emocional</td>
										  				<td class="center">'.$ver_laboral->emocional.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Honestidad</td>
										  				<td class="center">'.$ver_laboral->honestidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Rendimiento</td>
										  				<td class="center">'.$ver_laboral->rendimiento.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Actitud con colaboradores, jefes y subordinados</td>
										  				<td class="center">'.$ver_laboral->actitud.'</td>
									  				</tr>';
										  	}
									  	}
								  	}
							  	}
						  	}
					  	}
					  	?>
					</table>
				</div>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<td class="encabezado w-60">¿En caso de alguna vacante lo(a) contrataría nuevamente?</td>
                <?php 
                if($ver_laboral->recontratacion == 0){
                  $recontratacion ='No';
                }
                if($ver_laboral->recontratacion == 2){
                  $recontratacion ='N/A';
                }
                if($ver_laboral->recontratacion == 1){
                  $recontratacion ='Sí';
                } ?>
					    	<td class="center"><?php echo $recontratacion; ?></td>
					  	</tr>
					  	<tr>
					    	<td class="encabezado w-60">Razón</td>
					    	<td class="center"><?php echo $ver_laboral->motivo_recontratacion; ?></td>
					  	</tr>
					</table>
				</div>
        <pagebreak>
				<?php
				$cont++;
      } ?>

			<?php 
			if(!empty($info->trabajo_inactivo)){ ?>
				<p class="center f-18">Periodos inactivos en empleos</p>
				<div class="center">
					<textarea class="comentario" rows="3"><?php echo $info->trabajo_inactivo; ?></textarea>
				</div><br>
			<?php 
			} ?>
			<?php 
			if(!empty($info['trabajo_gobierno'] )){ ?>
				<div class="center">
					<p class="center f-18">¿Ha trabajado en alguna entidad de gobierno, partido político u ONG?</p>
				</div>
				<div class="center">
					<textarea class="comentario" rows="3"><?php echo $info['trabajo_gobierno'] ; ?></textarea>
				</div>
			<?php 
			} ?>
      <div class="div_datos">
        <p class="center f-18">Verificación de empleos</p>
        <table class="">
          <tr>
            <td class="encabezado center">Solicitud de verificación</td>
            <td class="center"><?php echo $fecha_alta; ?></td>
            <!--td class="center" rowspan="2"><?php //echo $verificacionEmpleos->status; ?></!--td-->
          </tr>
          <tr>
            <td class="encabezado center">Verificación completa</td>
            <td class="center"><?php echo $fechaVerificacionEmpleos = fechaPorIdioma($verificacionEmpleos['edicion'] , 'ingles'); ?></td>
          </tr>
        </table>
      </div><br>
      <div class="div_datos">
        <table>
          <?php 
          if($verificacionDetallesEmpleos){
            foreach($verificacionDetallesEmpleos as $row){
              $fecha_detalle = fechaPorIdioma($row['fecha'], 'ingles');
              echo '<tr>';
              echo '<td class="center w-17">'.$fecha_detalle.'</p></td>';
              echo '<td class="center">'.$row->comentarios.'</p></td>';
              echo '</tr>';
            }
          }
          ?>
        </table>
      </div><br>
      <pagebreak>

      <?php
		}
    //* Referencias personales
    if($secciones['cantidad_ref_personales']> 0 && $secciones['id_ref_personales'] == 31 && $refPersonal != null){ ?>
      <p class="center f-18">Referencias personales</p>
      <div class="div_datos">
        <?php $salida2 = '';
        foreach($refPersonal as $refper){
          if($refper['sabe_trabajo'] == 0 || $refper['sabe_vive'] == 0){
            $sabe_trabajo = "No";
            $sabe_vive = "No";
          }
          if($refper['sabe_trabajo'] == 1 || $refper['sabe_vive'] == 1){
            $sabe_trabajo = "Yes";
            $sabe_vive = "Yes";
          }
          if($refper['sabe_trabajo'] == 2 || $refper['sabe_vive'] == 2){
            $sabe_trabajo = "NA";
            $sabe_vive = "NA";
          }
          $salida2 .= '<table class=""><tr>';
          $salida2 .= '<td class="w-30 encabezado left">Nombre</td>';
          $salida2 .= '<td class="w-30 center">'.$refper['nombre'].'</td>';
          $salida2 .= '<td class="w-20 encabezado left">Teléfono</td>';
          $salida2 .= '<td class="w-20 center">'.$refper['telefono'].'</td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">Tiempo de conocerlo(a)</td>';
          $salida2 .= '<td class="center">'.$refper['tiempo_conocerlo'].'</td>';
          $salida2 .= '<td class="encabezado left">¿De dónde lo(a) conoce?</td>';
          $salida2 .= '<td class="center">'.$refper['donde_conocerlo'].'</td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">¿Sabe dónde trabaja el(la) candidato(a)?</td>';
          $salida2 .= '<td class="center">'.$sabe_trabajo.'</td>';
          $salida2 .= '<td class="encabezado left">¿Sabe dónde vive el(la) candidato(a)?</td>';
          $salida2 .= '<td class="center">'.$sabe_vive.'</td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">¿Lo(La) recomienda?</td>';
          $salida2 .= '<td class="center">'.$recomienda = ($refper['recomienda'] == 1)? "Sí" : "No".'</td>';
          $salida2 .= '<td class="encabezado left"></td>';
          $salida2 .= '<td class="center"></td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">Comentario</td>';
          $salida2 .= '<td class="center" colspan="3">'.$refper['comentario'].'</td>';
          $salida2 .= '</tr></table><br>';
        }
        echo $salida2;
        ?>		  	
      </div><br>
      <pagebreak>
    <?php 
    }
    //* Global searches
    if($secciones['id_seccion_global_search'] == 86 && $secciones['id_seccion_global_search'] != null){ ?>
			<p class="center f-18">Búsquedas Globales</p>
      <div class="div_datos">
        <table class="">
          <tr>
			    	<td class="w-20 encabezado left">Sanciones</td>
			    	<td class="w-80 center"><?php echo $global_searches['sanctions']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">Búsqueda de medios globales</td>
			    	<td class="center"><?php echo $global_searches['media_searches']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">OIG</td>
			    	<td class="center"><?php echo $global_searches['oig']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">SAM</td>
			    	<td class="center"><?php echo $global_searches['sam'] ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">OFAC</td>
			    	<td class="center"><?php echo $global_searches['ofac']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">INTERPOL</td>
			    	<td class="center"><?php echo $global_searches['interpol']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">MVR</td>
			    	<td class="center"><?php echo $global_searches['motor_vehicle_records']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><?php echo $global_searches['global_comentarios']; ?></td>
			  	</tr>
        </table>
      </div>
    <?php
    }
    
    //* Documentos
    if($docs){
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Aviso de privacidad </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 3){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Documento de identificación </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 12){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Antecedentes criminales </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 11){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OFAC </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 17){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OIG </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 21){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>SAM </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 29){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>INTERPOL </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 44){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Registro vehicular </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 18){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Verificación de búsqueda global </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 42){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Agresión sexual </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 7){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Certificado de estudios </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 10){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Licencia profesional </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 9){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Historial de empleos </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 13){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Carta laboral </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
    }
  }
	?>
<!-- Tipo PDF 25 -->


<!-- Tipo PDF 24 -->
	<?php
	if($secciones['tipo_pdf'] == 24){
		//* Datos Generales
		if($secciones['id_seccion_datos_generales'] == 82 && $info['edad']!= null){ ?>
			 <div class="div_datos">
					<p class="center f-18">Personal Data</p>
					<table class="">
							<tr>
								<td class="encabezado">Name:</td>
								<td class="center" colspan="5"><?php echo $info['nombre']." ".$info['paterno']." ".$info['materno']; ?></td>
							</tr>
							<tr>
								<td class="encabezado">Date of birth:</td>
								<td class="center"><?php echo $fecha_nacimiento; ?></td>
								<td class="encabezado">Age:</td>
								<td class="center"><?php echo $info['edad'] ?></td>
								<td class="encabezado w-17">Job Position Requested:</td>
								<td class="center"><?php echo $info['puesto']; ?></td>
							</tr>
							<tr>
								<td class="encabezado">Nationality:</td>
								<td class="center"><?php echo $info['nacionalidad']; ?></td>
								<td class="encabezado">Gender:</td>
								<td class="center"><?php echo $genero_ingles; ?></td>
								<td class="encabezado">Marital Status:</td>
								<td class="center"><?php echo $estado_civil_ingles; ?></td>
							</tr>
							<tr>
								<td class="encabezado">Address:</td>
								<td class="center"><?php echo $info['calle']; ?></td>
								<td class="encabezado">Ext. Num:</td>
								<td class="center"><?php echo $info['exterior']; ?></td>
								<td class="encabezado">Int. Num:</td>
								<td class="center"><?php echo $info['interior']; ?></td>
							</tr>
							<tr>
								<td class="encabezado">Neighborhood:</td>
								<td class="center"><?php echo $info['colonia'] ?></td>
								<td class="encabezado">State:</td>
								<td class="center"><?php echo $info['estado']; ?></td>
								<td class="encabezado">City:</td>
								<td class="center"><?php echo$info['municipio']; ?></td>
							</tr>
							<tr>
								<td class="encabezado">Zip Code:</td>
								<td class="center"><?php echo $info['cp']; ?></td>
								<td class="encabezado">Mobile Num:</td>
								<td class="center"><?php echo $info['celular']; ?></td>
								<td class="encabezado">Home Num:</td>
								<?php $tel_casa = (!empty($info['telefono_casa']))? $info['telefono_casa'] : 'Not provided'; ?>
								<td class="center"><?php echo $tel_casa; ?></td>
							</tr>
							<tr>
								<td class="encabezado">Another Number Phone:</td>
								<?php $tel_otro = (!empty($info['telefono_otro']))? $info['telefono_otro'] : 'Not provided'; ?>
								<td class="center"><?php echo $tel_otro; ?></td>
								<td class="encabezado">E-mail:</td>
								<td class="center" colspan="3"><?php echo $info['correo']; ?></td>
							</tr>
					</table>
				</div>
		<?php
		}
		//* Documentacion
		if($secciones['id_seccion_verificacion_docs'] == 58 && $verDoc != null){ ?>
		  <p class="center f-18">Documents</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-30 encabezado">Document</th>
            <th class="w-40 encabezado">Number</th>
            <th class="w-30 encabezado">Date/Institution</th>
          </tr>
          <tr>
            <td class="encabezado center">ID</td>
            <td class="center"><?php echo $verDoc['ine']; ?></td>
            <?php echo $ine_extra = (empty($verDoc['ine_ano']))? $verDoc['ine_institucion'] : $verDoc['ine_ano']; ?>
            <td class="center"><?php echo $ine_extra; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Passport</td>
            <?php echo $pasaporte = ($verDoc['pasaporte'] != null && $verDoc['pasaporte'] != '')? $verDoc['pasaporte'] : 'Not provided'; ?>
            <td class="center"><?php echo $pasaporte; ?></td>
            <?php echo $pasaporte_institucion = ($verDoc['pasaporte_fecha'] != null && $verDoc['pasaporte_fecha'] != '')? $verDoc['pasaporte_fecha'] : 'Not provided'; ?>
            <td class="center"><?php echo $pasaporte_institucion; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Non-criminal background letter</td>
            <td class="center"><?php echo $verDoc['penales']; ?></td>
            <td class="center"><?php echo $verDoc['penales_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Migration document</td>
            <?php echo $forma_migratoria = ($verDoc['forma_migratoria'] != null && $verDoc['forma_migratoria'] != '')? $verDoc['forma_migratoria'] : 'Not provided'; ?>
            <td class="center"><?php echo $pasaporte; ?></td>
            <?php echo $forma_migratoria_institucion = ($verDoc['forma_migratoria_fecha'] != null && $verDoc['forma_migratoria_fecha'] != '')? $verDoc['forma_migratoria_fecha'] : 'Not provided'; ?>
            <td class="center"><?php echo $forma_migratoria_institucion; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comments</td>
            <td class="center" colspan="2"><?php echo $verDoc['comentarios']; ?></td>
          </tr>
        </table>
      </div>
    <?php
    }
		//* Estudios
		if($secciones['id_estudios'] == 3 && $verMayoresEstudios != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Highest studies</p>
				<table class="">
					<tr>
						<th class="encabezado"></th>
						<th class="encabezado">Candidate</th>
						<th class="encabezado">Analyst</th>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Academic level</p></td>
						<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->grado_estudio; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Period</p></td>
						<td class="center"><p class="f-12"><?php echo $info->estudios_periodo; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->periodo; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">School/Institute</p></td>
						<td class="center"><p class="f-12"><?php echo $info->estudios_escuela; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->escuela; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">City</p></td>
						<td class="center"><p class="f-12"><?php echo $info->estudios_ciudad; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->ciudad; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Certificate Obtained</p></td>
						<td class="center"><p class="f-12"><?php echo $info->estudios_certificado; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->certificado; ?></p></td>
					</tr>
				</table>
			</div><br>
			<div class="div_datos">
				<table class="">
					<tr>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->comentarios; ?></p></td>
					</tr>
				</table>
			</div><br>
		<?php 
		} ?>

		<pagebreak>

		<?php
		//* Empleos
		if($secciones['lleva_empleos'] == 1 && !empty($empleos)){
			if($secciones['id_empleos'] == 32){
				$cont = 1; ?>
				<div class="div_datos">
					<p class="center f-18">Employment history </p>
					<?php
					foreach($empleos as $row){
						$ver_laboral = $this->candidato_laboral_model->getVerificacionLaboralByNumber($cont, $info['id']); ?>
						<table class="">
							<tr>
								<th class="encabezado"></th>
								<th class="encabezado">Candidate</th>
								<th class="encabezado">Compnay</th>
								<th class="encabezado">References</th>
							</tr>
							<tr>
								<td class="encabezado center">Company</td>
								<td class="center"><?php echo $row['empresa']; ?></td>
								<td class="center"><?php echo $vivienda['empresa'] ?></td>
								<td class="left w-30" rowspan="12"><?php echo $vivienda['notas']; ?></td>
							</tr>
							<tr>
								<td class="encabezado center">Address</td>
								<td class="center"><?php echo $row['direccion'] ?></td>
								<td class="center"><?php echo $ver_laboral['direccion']; ?></td>
							</tr>
							<tr>
								<td class="encabezado center">Date of entry</td>
								<td class="center"><?php echo $entrada_laboral = $row['fecha_entrada_txt']; ?></td>
								<td class="center"><?php echo $entrada_verifica = $ver_laboral['fecha_entrada_txt']; ?></td>
							</tr>
							<tr>
								<td class="encabezado center">Departure date</td>
								<td class="center"><?php echo $salida_laboral = $row['fecha_salida_txt']; ?></td>
								<td class="center"><?php echo $salida_verifica = $ver_laboral['fecha_salida_txt']; ?></td>
							</tr>
							<tr>
								<td class="encabezado center">Phone</td>
								<td class="center"><?php echo $row['telefono']; ?></td>
								<td class="center"><?php echo $ver_laboral['telefono']; ?></td>
							</tr>
							<tr>
								<td class="encabezado center">Starting position</td>
								<td class="center"><?php echo $row['puesto1']; ?></td>
								<td class="center"><?php echo $ver_laboral['puesto1']; ?></td>
							</tr>
							<tr>
								<td class="encabezado center">Final position</td>
								<td class="center"><?php echo $row['puesto2'];?></td>
								<td class="center"><?php echo $ver_laboral['puesto2']; ?></td>
							</tr>
							<tr>
								<td class="encabezado center">Starting salary</td>
								<td class="center"><?php echo $row['salario1_txt']; ?></td>
								<td class="center"><?php echo $ver_laboral['salario1_txt']; ?></td>
							</tr>
							<tr>
								<td class="encabezado center">Final salary</td>
								<td class="center"><?php echo $row['salario2_txt']; ?></td>
								<td class="center"><?php echo $ver_laboral['salario2_txt']; ?></td>
							</tr>
							<tr>
								<td class="encabezado center">Immediate superior</td>
								<td class="center"><?php echo $row['jefe_nombre']."<br>".$row['jefe_correo']; ?></td>
								<td class="center"><?php echo $ver_laboral['jefe_nombre']."<br>".$ver_laboral['jefe_correo']; ?></td>
							</tr>
							<tr>
								<td class="encabezado center">Position of immediate superior</td>
								<td class="center"><?php echo $row['jefe_puesto']; ?></td>
								<td class="center"><?php echo $ver_laboral['jefe_puesto']; ?></td>
							</tr>
							<tr>
								<td class="encabezado center">Cause for separation</td>
								<td class="center"><?php echo $row['causa_separacion']; ?></td>
								<td class="center"><?php echo $ver_laboral['causa_separacion']; ?></td>
							</tr>
						</table>
						<p class="f-14 center">Candidate Characteristics<br>
						<div class="div_datos">
							<table class="">
								<tr>
									<td class="encabezado right" width="35%"><b>Strengths or qualities of the candidate</b></td>
									<td class="center" colspan="3"><b><?php echo $ver_laboral['cualidades']; ?></b></td>
								</tr>
								<tr>
									<td class="encabezado right" width="35%"><b>Candidate's areas for improvement</b></td>
									<td class="center" colspan="3"><b><?php echo $ver_laboral['mejoras']; ?></b></td>
								</tr>
							</table>
						</div>
						<pagebreak>
						<?php
						$cont++; 
					} ?>
				</div><br>
			<?php
			}
		}
		//* GAPS
		if($secciones['lleva_gaps']== 1){
			if($gaps){ ?>
				<div class="div_datos">
					<p class="center f-18">Employment gaps</p>
					<table class="">
						<tr>
								<th class="encabezado">From</th>
								<th class="encabezado">To</th>
								<th class="encabezado" width="40%">Reason</th>
							</tr>
						<?php 
						foreach($gaps as $g){ ?>
							<tr>
								<td class="center"><?php echo $g['fecha_inicio']; ?></td>
								<td class="center"><?php echo $g['fecha_fin']; ?></td>
								<td class="center"><?php echo $g['razon']; ?></td>
							</tr>
						<?php
							}
						?>
					</table>
				</div><br>
			<?php 
			}
		}
		if($secciones->lleva_credito == 1 && !empty($credito)){ ?>
			<div class="div_datos">
				<p class="center f-18">Credit History</p>
				<table class="">
					<thead>
						<tr>
							<th class="encabezado">From</th>
							<th class="encabezado">To</th>
							<th class="encabezado" width="40%">Comment</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					foreach($credito as $row){ ?>
						<tr>
							<td class="center"><p class="f-12"><?php echo $row->fecha_inicio; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $row->fecha_fin; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $row->comentario; ?></p></td>
						</tr>
					<?php
						}
					?>
					</tbody>
				</table>
			</div>
		<?php 
		}
		//* Doping
		if(!empty($doping)) { ?>
			<div class="div_datos">
				<p class="center f-18">Drug Test Verification</p>
				<table class="">
						<tr>
							<?php 
							$a = new DateTime($doping->fecha_doping);
							$fecha_doping = $a->format('m/d/Y');
							$res_doping = ($pruebas['resultado'] == 0)? "Passed":"Not passed";
							$a = new DateTime($doping['fecha_resultado']);
							$fecha_doping_res = $a->format('m/d/Y');
							$descripcion_doping = ($pruebas['resultado'] == 0)? "".$examenDoping['nombre']." Panel Drug Test Passed":"".$examenDoping['nombre']." Panel Drug Test Not Passed";
							?>
							<td class="encabezado center"><p class="f-12">Date of Drug Test</p></td>
							<td class="center"><p class="f-12"><?php echo $fecha_doping; ?></p></td>
							<td class="center" rowspan="2"><p class="f-12"><?php echo $res_doping; ?></p></td>

						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Date of Drug Test Result </p></td>
							<td class="center"><p class="f-12"><?php echo $fecha_doping_res; ?></p></td>
						</tr>
				</table>
			</div><br>
			<div class="div_datos">
				<table>
					<tr>
						<td class="center"><p class="f-12"><?php echo $descripcion_doping; ?></p></td>
					</tr>
				</table>
			</div>
			<pagebreak>
		<?php 
		}
		//* Documentos
    if($docs){
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Privacy Notice </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 3){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>ID </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 14){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Passport </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 7){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Studies Certificate </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 12 || $doc['id_tipo_documento'] == 25){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Criminal Records </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 11){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OFAC </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 17){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OIG </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 21){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>SAM </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 18){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Global Search Check </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 9){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Employment History (NSS) </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
    }
	} ?>
<!-- Tipo PDF 24 -->

<!-- Tipo PDF 23 -->
	<?php 
	if($secciones['tipo_pdf'] == 23){
		//* Datos Generales
		//TODO: Checar como integrar el tipo sanguineo dentro de los procesos
		if($secciones['id_seccion_datos_generales'] == 103 && $info['edad']!= null){ ?>
			<div class="div_datos">
				<p class="center f-18">Datos Personales</p>
				<table class="">
						<tr>
							<td class="encabezado negrita">Nombre del aspirante:</td>
							<td class="center" colspan="5"><?php echo $info['nombre']." ".$info['paterno']." ".$info['materno']; ?></td>
						</tr>
						<tr>
							<td class="encabezado negrita">Puesto que solicita:</td>
							<td class="center" colspan="2"><?php echo $info['puestoSeleccionado']; ?></td>
							<td class="encabezado negrita" colspan="2">Fecha de Nacimiento:</td>
							<td class="center"><?php echo $fecha_nacimiento; ?></td>
						</tr>
						<tr>
              <td class="encabezado negrita">Edad:</td>
							<td class="center"><?php echo $info['edad'] ?> años</td>
							<td class="encabezado negrita">Nacionalidad:</td>
							<td class="center" colspan="3"><?php echo $info['nacionalidad']; ?></td>
						</tr>
						<tr>
							<td class="encabezado negrita">Género:</td>
							<td class="center"><?php echo $info['genero']; ?></td>
							<td class="encabezado negrita">Estado civil:</td>
							<td class="center" colspan="3"><?php echo $info['estado_civil']; ?></td>
						</tr>
						<tr>
							<td class="encabezado negrita" colspan="2">Domicilio (calle, número exterior e interior):</td>
							<td class="center" colspan="4"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior']; ?></td>
						</tr>
						<tr>
							<td class="encabezado negrita">Colonia:</td>
							<td class="center" colspan="2"><?php echo $info['colonia'] ?></td>
							<td class="encabezado negrita">Ciudad:</td>
							<td class="center" colspan="2"><?php echo$info['municipio']; ?></td>
						</tr>
						<tr>
							<td class="encabezado negrita">Estado:</td>
							<td class="center" colspan="2"><?php echo $info['estado']; ?></td>
							<td class="encabezado negrita">Código postal:</td>
							<td class="center" colspan="2"><?php echo $info['cp']; ?></td>
						</tr>
						<tr>
							<td class="encabezado negrita">Tel. Celular:</td>
							<td class="center"><?php echo $info['celular']; ?></td>
							<td class="encabezado negrita">Tel. Casa:</td>
							<td class="center"><?php echo $tel_casa = ($info['telefono_casa'] == "")? "No proporciona":$info['telefono_casa']; ?></td>
              <td class="encabezado negrita">Otro teléfono:</td>
						  <td class="center"><?php echo $tel_otro = ($info['telefono_otro'] == "")? "No proporciona":$info['telefono_otro']; ?></td>
						</tr>
						<tr>
							<td class="encabezado negrita">Correo:</td>
							<td class="center" colspan="5"><?php echo $correo = ($info['correo']= "")? "No proporciona":$info['correo']; ?></td>
						</tr>
            <tr>
              <td class="encabezado negrita" colspan="2">Antigüedad de residencia en su actual domicilio:</td>
						  <td class="center" colspan="4"><?php echo $info['tiempo_dom_actual']; ?></td>
						</tr>
						<tr>
							<td class="encabezado negrita" colspan="2">Tiempo que hace para llegar a la oficina:</td>
              <td class="center" colspan="4"><?php echo $info['tiempo_traslado']; ?></td>
						</tr>
            <tr>
              <td class="encabezado negrita" colspan="2">Medio de transporte:</td>
              <td class="center" colspan="4"><?php echo $info['tipo_transporte']; ?></td>
            </tr>
				</table>
			</div>
    <?php  
    }
    //* Familiar
		if($secciones['lleva_familiares'] == 1 && $familia){ ?>
			<div class="div_datos">
				<p class="center f-18">Datos del Grupo Familiar</p>
				<table class="">
					<tr>
						<th class="encabezado" width="30%">NOMBRE</th>
						<th class="encabezado" width="20%">PARENTESCO</th>
						<th class="encabezado" width="10%">EDAD</th>
						<th class="encabezado" width="15%">OCUPACIÓN</th>
						<th class="encabezado" width="15%">CIUDAD/COMPAÑÍA</th>
						<th class="encabezado" width="10%">VIVE CON ÉL/ELLA</th>
					</tr>
					<?php $salida = '';
					if($familia){
						foreach($familia as $f){
              $salida .= '<tr>';
              $salida .= '<td class="center">'.$f['nombre'].'</td>';
              $salida .= '<td class="center">'.$f['parentesco'].'</td>';
              $salida .= '<td class="center">'.$f['edad'].'</td>';
              $salida .= '<td class="center">'.$f['puesto'].'</td>';
              $salida .= '<td class="center">'.$f['escolaridad'].'</td>';
              $salida .= ($f['misma_vivienda'] == 1) ? '<td class="center">Sí</td>' : '<td class="center">No</td>';
              $salida .= '</tr>';
						}
					}
					else{
						$salida2 .= '<tr>';
						$salida2 .= '<td class="center" colspan="6">El candidato vive solo</td>';
						$salida2 .= '</tr>';
					}
					echo $salida;
					?>
				</table>
			</div><br>
      <pagebreak>
		  <?php 
		}
		//* Estudios
		if($secciones['id_estudios'] == 104 && $academico != null){  ?>
			<div class="div_datos">
				<p class="center f-18">Historial Académico</p>
				<table class="">
          <tr>
            <th class="encabezado" width="10%">NIVEL ESCOLAR</th>
            <th class="encabezado" width="15%">PERIODO</th>
            <th class="encabezado" width="25%">ESCUELA</th>
            <th class="encabezado" width="20%">CIUDAD</th>
            <th class="encabezado" width="15%">CERTIFICADO</th>
            <th class="encabezado" width="15%">DOCUMENTOS ENTREGADOS</th>
          </tr>
          <tr>
            <td class="encabezado center"><p class="f-12">Primaria</p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_periodo']; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_escuela']; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_ciudad']; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_certificado']; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $res = ($academico->primaria_validada == 1)? 'Sí' : 'No'; ?></p></td>
          </tr>
          <?php 
          if($academico['secundaria_periodo'] != null && $academico['secundaria_periodo'] != ''){
          ?>
            <tr>
              <td class="encabezado center"><p class="f-12">Secundaria</p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_periodo']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_escuela']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_ciudad']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_certificado']; ?></p></td>
            	<td class="center"><p class="f-12"><?php echo $res = ($academico->secundaria_validada == 1)? 'Sí' : 'No'; ?></p></td>
            </tr>
          <?php 
          } ?>
          <?php 
          if($academico['preparatoria_periodo'] != null && $academico['preparatoria_periodo'] != ''){
          ?>
            <tr>
              <td class="encabezado center"><p class="f-12">Bachillerato</p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_periodo']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_escuela']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_ciudad']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_certificado']; ?></p></td>
            	<td class="center"><p class="f-12"><?php echo $res = ($academico->preparatoria_validada == 1)? 'Sí' : 'No'; ?></p></td>
            </tr>
          <?php 
          } ?>
          <?php 
          if($academico['licenciatura_periodo'] != null && $academico['licenciatura_periodo'] != ''){
          ?>
            <tr>
              <td class="encabezado center"><p class="f-12">Licenciatura</p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_periodo']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_escuela']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_ciudad']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_certificado']; ?></p></td>
            	<td class="center"><p class="f-12"><?php echo $res = ($academico->licenciatura_validada == 1)? 'Sí' : 'No'; ?></p></td>
            </tr>
          <?php 
          } ?>
					<?php 
          if($academico->posgrado_periodo != null && $academico->posgrado_periodo != ''){
          ?>
            <tr>
              <td class="encabezado center"><p class="f-12">Posgrado</p></td>
              <td class="center"><p class="f-12"><?php echo $academico->posgrado_periodo; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico->posgrado_escuela; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico->posgrado_ciudad; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico->posgrado_certificado; ?></p></td>
            	<td class="center"><p class="f-12"><?php echo $res = ($academico->posgrado_validada == 1)? 'Sí' : 'No'; ?></p></td>
            </tr>
          <?php 
          } ?>
          <tr>
            <td class="encabezado center"><p class="f-12">Seminarios / Cursos</p></td>
            <td class="center" colspan="5"><p class="f-12"><?php echo $academico['otros_certificados']; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center"><p class="f-12">Comentarios</p></td>
            <td class="center" colspan="5"><p class="f-12"><?php echo $academico['comentarios']; ?></p></td>
          </tr>
				</table>
			</div><br>
			<div class="div_datos">
				<p class="center f-18">Periodos escolares inactivos</p>
				<table>
					<tr>
            <td class="center"><p class="f-12"><?php echo $academico['carrera_inactivo']; ?></p></td>
          </tr>
				</table>
			</div><br>
		<?php 
		} 
		//* Social
		if($secciones['lleva_sociales'] == 1){
			if($secciones['id_seccion_social'] == 108 && $sociales != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Antecedentes Sociales</p>
					<table class="">
						<tr>
							<td class="encabezado negrita" width="25%">¿Ingiere bebidas alcohólicas? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($secciones['bebidas'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado negrita" width="25%">¿Con qué frecuencia? </td>
							<td class="center"><p class="f-12"><?php echo $secciones['bebidas_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado negrita" width="25%">¿Acostumbra fumar?  </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['fumar'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado negrita" width="25%">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['fumar_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado negrita" width="25%">¿Ha tenido alguna intervención quirúrgica? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['cirugia']; ?></p></td>
							<td class="encabezado negrita" width="25%">¿Antecedentes de enfermedades en su familia directa? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['enfermedades']; ?></p></td>
						</tr>
					</table>
				</div>
        <pagebreak>
			<?php 
			} 
		}   
		//* Finanzas
		if($secciones['lleva_familiares'] == 1 && $secciones['lleva_egresos']== 1 && $secciones['id_finanzas'] == 105 && $finanzas != null){ ?>
			<p class="center f-18">Situación Económica</p>
			<div style="width:60%;float:left;">
				<table class="" style="width:100%;">
					<tr>
						<th class="encabezado" colspan="3">INGRESOS MENSUALES</th>
					</tr>
					<tr>
						<th class="encabezado">NOMBRE</th>
						<th class="encabezado">SUELDO</th>
						<th class="encabezado">APORTACIÓN</th>
					</tr>
					<?php $salida2 = '';
          if($finanzas['unico_solvente'] == 0){
            if($familia){
              foreach($familia as $f){
                $salida2 .= '<tr>';
                $salida2 .= '<td class="center">'.$f['nombre'].'</td>';
                $salida2 .= '<td class="center">$'.$f['sueldo'].'</td>';
                $salida2 .= '<td class="center">$'.$f['monto_aporta'].'</td>';
                $salida2 .= '</tr>';
              }
              //TODO: Se puede agregar el campo de aportacion del candidato en la seccion
              $salida2 .= '<tr>';
              $salida2 .= '<td class="center">'.$info['candidato'].'</td>';
              $salida2 .= '<td class="center">$'.$finanzas->sueldo.'</td>';
              $salida2 .= '<td class="center">$'.$finanzas->aportacion.'</td>';
              $salida2 .= '</tr>';
            }
            else{
              //TODO: Se puede agregar el campo de aportacion del candidato en la seccion
              $salida2 .= '<tr>';
              $salida2 .= '<td class="center">'.$info['candidato'].'</td>';
              $salida2 .= '<td class="center">$'.$finanzas->sueldo.'</td>';
              $salida2 .= '<td class="center">$'.$finanzas->aportacion.'</td>';
              $salida2 .= '</tr>';
              $salida2 .= '<tr>';
              $salida2 .= '<td class="center" colspan="3">El candidato es independiente en cuestión a los gastos generados en el hogar</td>';
              $salida2 .= '</tr>';
            }
          }
          else{
            //TODO: Se puede agregar el campo de aportacion del candidato en la seccion
            $salida2 .= '<tr>';
            $salida2 .= '<td class="center">'.$info['candidato'].'</td>';
            $salida2 .= '<td class="center">$'.$finanzas->sueldo.'</td>';
            $salida2 .= '<td class="center">$'.$finanzas->aportacion.'</td>';
            $salida2 .= '</tr>';
            $salida2 .= '<tr>';
            $salida2 .= '<td class="center" colspan="3">El candidato es independiente en cuestión a los gastos generados en el hogar</td>';
            $salida2 .= '</tr>';
          }
					echo $salida2;
					?>
				</table>
			</div>
			<div style="width:40%;float:left;">
				<table class="" style="width:100%;">
					<tr>
						<th class="encabezado" colspan="2">EGRESOS MENSUALES</th>
					</tr>
					<tr>
						<th class="encabezado">CONCEPTOS</th>
						<th class="encabezado">MONTOS</th>
					</tr>
					<?php 
					$totalGastos = $finanzas['alimentos'] + $finanzas['servicios'] + $finanzas['transporte'] + $finanzas['renta'] + $finanzas['otros']; ?>
					<tr>
						<td class="encabezado">Alimentos</td>
						<td class="center">$<?php echo $finanzas['alimentos'] ?></td>
					</tr>
					<tr>
						<td class="encabezado">Servicios</td>
						<td class="center">$<?php echo $finanzas['servicios'] ?></td>
					</tr>
					<tr>
						<td class="encabezado">Transporte</td>
						<td class="center">$<?php echo $finanzas['transporte'] ?></td>
					</tr>
					<tr>
						<td class="encabezado">Renta de casa</td>
						<td class="center">$<?php echo $finanzas['renta'] ?></td>
					</tr>
					<tr>
						<td class="encabezado">Otros</td>
						<td class="center">$<?php echo $finanzas['otros'] ?></td>
					</tr>
					<tr>
						<td class="encabezado"><b>Total</b></td>
						<td class="center"><b>$<?php echo $totalGastos ?></b></td>
					</tr>
				</table>
			</div>
			<div class="div_datos">
				<table>
					<tr>
            <td class="encabezado negrita" width="40%">¿Cuenta con algún bien propio? ¿Cuál(es)?</td>
            <td class="center"><?php echo $finanzas->bienes; ?></td>
          </tr>
					<tr>
            <td class="encabezado negrita" width="40%">¿Cuenta con deudas? ¿Cuál(es)?</td>
            <td class="center"><?php echo $finanzas->deudas; ?></td>
          </tr>
				</table>
			</div><br>
		<?php 
		}

    //* Brinco de hoja en caso de exceder numero de familiares y si el candidato es el unico solvente de los gastos
    if($numFamiliares >= 20){
      echo '<pagebreak>';
    }

    //* Vivienda
		if($secciones['lleva_vivienda'] == 1 && $vivienda != null){  ?>
			<div class="div_datos">
				<p class="center f-18">Vivienda</p>
				<table class="">
					<tr>
						<th class="encabezado">CONDICIÓN</th>
						<th class="encabezado">TIPO DE VIVIENDA</th>
					</tr>
          <tr>
						<td class="center"><?php echo $vivienda->tipo_propiedad; ?></td>
            <td class="center"><?php echo $vivienda['vivienda']; ?></td>
					</tr>
          <tr>
						<?php
							if($vivienda['tamanio_vivienda'] == 1){
								$tamano = "amplios";
							}
							if($vivienda['tamanio_vivienda'] == 2){
								$tamano = "suficientes";
							}
							if($vivienda['tamanio_vivienda'] == 3){
								$tamano = "reducidos";
							}

							if($vivienda->id_tipo_condiciones == 1){
								$condiciones = "orden y limpieza";
							}
							if($vivienda->id_tipo_condiciones == 2){
								$condiciones = "desorden y limpieza";
							}
							if($vivienda->id_tipo_condiciones == 3){
								$condiciones = "orden y un poco de limpieza";
							}
							if($vivienda->id_tipo_condiciones == 4){
								$condiciones = "desorden y un poco de limpieza";
							}
							if($vivienda->id_tipo_condiciones == 5){
								$condiciones = "orden pero sin limpieza";
							}
							if($vivienda->id_tipo_condiciones == 6){
								$condiciones = "desorden y sin limpieza";
							}

							if($vivienda['calidad_mobiliario'] == 1){
								$calidad = "buena";
							}
							if($vivienda['calidad_mobiliario'] == 2){
								$calidad = "media";
							}
							if($vivienda['calidad_mobiliario'] == 3){
								$calidad = "mala";
							}

							if($vivienda->mantenimiento_inmueble == 1){
								$mantenimiento = "bueno";
							}
							if($vivienda->mantenimiento_inmueble == 2){
								$mantenimiento = "regular";
							}
							if($vivienda->mantenimiento_inmueble == 3){
								$mantenimiento = "malo";
							}
						?>
						<td class="center" colspan="2">La vivienda en su interior se observa <?php echo strtolower($refper['estado_vivienda']); ?>, se pudo percatar <?php echo $condiciones; ?>. Los espacios son <?php echo $tamano; ?>, el mobiliario es de calidad <?php echo $calidad; ?> <?php echo $res = ($vivienda['mobiliario'] == 1)? "y completa":" e incompleta"; ?>. El mantenimiento del inmueble es <?php echo $mantenimiento; ?>.</td>
					</tr>
				</table>
			</div><br>
      <pagebreak>
		<?php 
		}
		//* Laborales
    if($secciones['id_empleos'] == 90 && $empleos != NULL){ 
			$cont = 1;
			foreach($empleos as $ref){
				$ver_laboral = $this->candidato_laboral_model->getVerificacionLaboralByNumber($cont, $info['id']); ?>
				<p class="center f-18">Referencias laborales </p>
				<div class="div_datos">
					<table class="">
            <tr>
              <th class="encabezado" width="20%"></th>
              <th class="encabezado" width="25%">CANDIDATO</th>
              <th class="encabezado" width="25%">COMPAÑÍA</th>
              <th class="encabezado" width="30%">REFERENCIAS</th>
            </tr>
            <tr>
              <td class="encabezado negrita">Compañía</td>
              <td class="center"><?php echo $ref['empresa']; ?></td>
              <td class="center"><?php echo $vivienda['empresa'] ?></td>
              <td class="left w-30" rowspan="12"><?php echo $vivienda['notas']; ?></td>
            </tr>
            <tr>
              <td class="encabezado negrita">Domicilio</td>
              <td class="center"><?php echo $ref['direccion']; ?></td>
              <td class="center"><?php echo $ver_laboral['direccion']; ?></td>
            </tr>
            <tr>
              <td class="encabezado negrita">Fecha de ingreso</td>
              <td class="center"><?php echo $ref['fecha_entrada_txt']; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_entrada_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado negrita">Fecha de salida</td>
              <td class="center"><?php echo $ref->fecha_salida_txt; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_salida_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado negrita">Teléfono</td>
              <td class="center"><?php echo $ref['telefono']; ?></td>
              <td class="center"><?php echo $ver_laboral['telefono']; ?></td>
            </tr>
            <tr>
              <td class="encabezado negrita">Puesto inicial</td>
              <td class="center"><?php echo $ref['puesto1']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto1']; ?></td>
            </tr>
            <tr>
              <td class="encabezado negrita">Puesto final</td>
              <td class="center"><?php echo $ref['puesto2']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto2']; ?></td>
            </tr>
            <tr>
              <td class="encabezado negrita">Sueldo inicial</td>
              <td class="center">$<?php echo $ref['salario1_txt']; ?></td>
              <td class="center">$<?php echo $ver_laboral['salario1_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado negrita">Sueldo final</td>
              <td class="center">$<?php echo $ref->salario2_txt; ?></td>
              <td class="center">$<?php echo $ver_laboral['salario2_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado negrita">Jefe inmediato</td>
              <?php  
              $jefe_nombre = ($ref['jefe_nombre'] != null)? $ref['jefe_nombre'] : 'Nombre no proporcionado'; 
              $jefe_correo = ($ref['jefe_correo'] != null)? $ref['jefe_correo'] : ';correo no proporcionado'; ?>
              <td class="center"><?php echo $jefe_nombre."<br>".$jefe_correo; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_nombre']."<br>".$ver_laboral['jefe_correo']; ?></td>
            </tr>
            <tr>
              <td class="encabezado negrita">Puesto del jefe inmediato</td>
              <td class="center"><?php echo $ref['jefe_puesto']; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_puesto']; ?></td>
            </tr>
            <tr>
              <td class="encabezado negrita">Causa de separación</td>
              <td class="center"><?php echo $ref->causa_separacion; ?></td>
              <td class="center"><?php echo $ver_laboral['causa_separacion']; ?></td>
            </tr>
					</table>
				</div><br>
        <pagebreak>
				<?php
				$cont++;
      } 
      //* GAPS
      if($secciones['lleva_gaps']== 1){ ?>
        <div class="div_datos">
          <p class="center f-18">Periodos inactivos laborales</p>
          <table class="">
            <tr>
              <th class="encabezado">DESDE</th>
              <th class="encabezado">HASTA</th>
              <th class="encabezado" width="40%">MOTIVO/RAZÓN</th>
            </tr>
            <?php 
            if($gaps){
              foreach($gaps as $g){ ?>
                <tr>
                  <td class="center"><?php echo $g['fecha_inicio']; ?></td>
                  <td class="center"><?php echo $g['fecha_fin']; ?></td>
                  <td class="center"><?php echo $g['razon']; ?></td>
                </tr>
            <?php
              }
            }
            else{ ?>
              <tr>
                <td class="center" colspan="3">No cuenta con periodos inactivos en su historial laboral</td>
              </tr>
            <?php 
            } ?>
          </table><br>
        </div>
      <?php 
      } ?>
      <div class="center">
        <p class="center f-18">¿Ha trabajado en alguna entidad de gobierno, partido político u ONG? ?</p>
      </div>
      <div class="center">
        <textarea class="comentario" rows="3"><?php echo $info['trabajo_gobierno'] ; ?></textarea>
      </div><br>
    <?php
		}
    
    //* Referencias personales
    if($secciones['cantidad_ref_personales']> 0 && $refPersonal != null){
      if($secciones['id_ref_personales'] == 107){ ?>
        <div class="div_datos">
          <p class="center f-18">Referencias Personales</p>
          <?php $salida2 = '';
          foreach($refPersonal as $refper){ ?>
            <table class="">
            	<tr>
								<td class="encabezado negrita" width="25%"><p class="f-12">Nombre</td>
								<td class="center" colspan="3"><?php echo $refper->nombre ?></td>
            	</tr>
							<tr>
								<td class="encabezado negrita">Teléfono</td>
								<td class="center"><?php echo $refper->telefono ?></td>
								<td class="encabezado negrita">Tiempo de conocerlo</td>
								<td class="center"><?php echo $refper->tiempo_conocerlo ?></td>
							</tr>
            	<tr>
								<td class="encabezado negrita">¿De qué lugar lo(a) conoce?</td>
								<td class="center" colspan="3"><?php echo $refper->donde_conocerlo ?></td>
            	</tr>
            </table>
						<?php
						} ?>
        </div><br>
        <pagebreak>
      <?php 
      }
    }
		//* Conclusion
		if($secciones['tipo_conclusion'] == 21 && isset($finalizado)){ ?>
			<div class="div_datos">
				<p class="center f-18">Conclusión</p><br>
				<table class="">
					<tr>
						<td class="left"><?php echo $finalizado['descripcion_personal1']; ?></td>
					</tr>
					<tr>
						<td class="left"><?php echo $finalizado['descripcion_personal2']; ?></td>		    	
					</tr>
					<tr>
						<td class="left"><?php echo $finalizado['descripcion_socio2']; ?></td>		    	
					</tr>
          <tr>
						<td class="left"><?php echo $finalizado['descripcion_laboral2']; ?></td>		    	
					</tr>
          <tr>
						<td class="left"><?php echo $finalizado->conclusion_investigacion; ?></td>		    	
					</tr>
				</table>
			</div><br>
		<?php 
		}
		//* Documentos
    $pagebreak = 0;
    if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 19){
          if($pagebreak == 0){ 
            echo '<pagebreak>';
            $pagebreak = 1;
          } ?>
          <div class="center sin-flotar margen-top">
            <p class="f-20">Fotos </p><br>
          </div>
					<div class="center">
          <?php 
          echo '<img class="foto" src="'.base_url().'_docs/'.$doc['archivo'].'">';
          ?>
					</div>
		<?php 
        }
      }
		} 
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 3){ ?>
          <pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Comprobante de identificación </p>
					</div>
					<div class="center">
						<?php 
            echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750">';
						?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 46){ ?>
          <pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Reporte de INFONAVIT </p>
					</div>
					<div class="center">
						<?php 
            echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750">';
						?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 11){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">OFAC </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750"><br><br>'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 8){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Aviso de privacidad </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750">'; ?>
					</div>
				<?php
				}
			}
			//* Anexos
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 9){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Comprobante de historial laboral </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 7){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Comprobante de estudios </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 12){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Constancia de no antecedentes</p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 13){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Carta laboral </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 23){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Evidencia de correo </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 24){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Evidencia de chat </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
		}
	}
	?>

<!-- Tipo PDF 23 -->

<!-- Tipo PDF 22 -->
  <?php
  if($secciones['tipo_pdf'] == 22){
    //* Datos Generales
    if($secciones['id_seccion_datos_generales'] == 83){ ?>
      <p class="center f-18">Personal Data </p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 encabezado">Name:</td>
            <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Date of birth:</td>
            <td class="center"><?php echo $fecha_nacimiento; ?></td>
            <td class="encabezado">Age:</td>
            <td class="center"><?php echo $info['edad'] ?></td>
            <td class="encabezado w-17">Job Position Requested:</td>
            <td class="center"><?php echo $info['puesto']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Nationality:</td>
            <td class="center"><?php echo $info['nacionalidad']; ?></td>
            <td class="encabezado">Gender:</td>
            <td class="center"><?php echo $genero_ingles; ?></td>
            <td class="encabezado">Marital Status:</td>
            <td class="center"><?php echo $estado_civil_ingles; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Address:</td>
            <td class="center" colspan="5"><?php echo $info['domicilio_internacional']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Mobile Num:</td>
            <td class="center"><?php echo $info['celular']; ?></td>
            <td class="encabezado">Home Num:</td>
            <?php $telefono_casa = ($info['telefono_casa'] != null && $info['telefono_casa'] != '')? $info['telefono_casa'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_casa; ?></td>
            <td class="encabezado">Number to leave Messages:</td>
            <?php $telefono_otro = ($info['telefono_otro'] != null && $info['telefono_otro'] != '')? $info['telefono_otro'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_otro; ?></td>
          </tr>
          <tr>
            <td class="encabezado">E-mail:</td>
            <td class="center" colspan="5"><?php echo $info['correo']; ?></td>
          </tr>
        </table>
      </div>
    <?php  
    }
    //* Documentacion
    if($secciones['id_seccion_verificacion_docs'] == 39 && $verDoc != null){ ?>
      <p class="center f-18">Documents</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-30 encabezado">Document</th>
            <th class="w-40 encabezado">Number</th>
            <th class="w-30 encabezado">Validity</th>
          </tr>
          <tr>
            <td class="encabezado center">ID</td>
            <td class="center"><?php echo $verDoc['ine']; ?></td>
            <td class="center"><?php echo $verDoc['ine_ano']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Passport</td>
            <td class="center"><?php echo $verDoc['pasaporte'] ?></td>
            <td class="center"><?php echo $verDoc['pasaporte_fecha']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Non-criminal background</td>
            <td class="center"><?php echo $verDoc['penales']; ?></td>
            <td class="center"><?php echo $verDoc['penales_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comments</td>
            <td class="center" colspan="2"><?php echo $verDoc['comentarios']; ?></td>
          </tr>
        </table>
      </div><br>
      <pagebreak>
    <?php
    }
    //* Global searches
    if($secciones['id_seccion_global_search'] == 67 && $secciones['id_seccion_global_search'] != null){ ?>
			<p class="center f-18">Global Searches</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 encabezado left">Global compliance & Sanctions database</td>
			    	<td class="w-80 center"><?php echo $global_searches['sanctions']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">Global media searches</td>
			    	<td class="center"><?php echo $global_searches['media_searches']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">OIG</td>
			    	<td class="center"><?php echo $global_searches['oig']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">SAM</td>
			    	<td class="center"><?php echo $global_searches['sam'] ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">OFAC</td>
			    	<td class="center"><?php echo $global_searches['ofac']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">FDA Department Search</td>
			    	<td class="center"><?php echo $global_searches->fda; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><?php echo $global_searches['global_comentarios']; ?></td>
			  	</tr>
        </table>
      </div>
    <?php
    }
    //* Documentos
    if($docs){
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Privacy Notice </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 3){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>ID </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 14){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Passport </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 7){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Studies Certificate </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 12 || $doc['id_tipo_documento'] == 25){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Criminal Records </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 11){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OFAC </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 17){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OIG </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 21){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>SAM </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 18){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Global Search Check </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 9){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Employment History (NSS) </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
    }
  }
  ?>
<!-- Fin PDF 22 -->

<!-- Tipo PDF 21 -->
  <?php
  if($secciones['tipo_pdf'] == 21){
    //* Datos Generales
    if($secciones['id_seccion_datos_generales'] == 83){ ?>
      <p class="center f-18">Personal Data </p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 encabezado">Name:</td>
            <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Date of birth:</td>
            <td class="center"><?php echo $fecha_nacimiento; ?></td>
            <td class="encabezado">Age:</td>
            <td class="center"><?php echo $info['edad'] ?></td>
            <td class="encabezado w-17">Job Position Requested:</td>
            <td class="center"><?php echo $info['puesto']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Nationality:</td>
            <td class="center"><?php echo $info['nacionalidad']; ?></td>
            <td class="encabezado">Gender:</td>
            <td class="center"><?php echo $genero_ingles; ?></td>
            <td class="encabezado">Marital Status:</td>
            <td class="center"><?php echo $estado_civil_ingles; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Address:</td>
            <td class="center" colspan="5"><?php echo $info['domicilio_internacional']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Mobile Num:</td>
            <td class="center"><?php echo $info['celular']; ?></td>
            <td class="encabezado">Home Num:</td>
            <?php $telefono_casa = ($info['telefono_casa'] != null && $info['telefono_casa'] != '')? $info['telefono_casa'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_casa; ?></td>
            <td class="encabezado">Number to leave Messages:</td>
            <?php $telefono_otro = ($info['telefono_otro'] != null && $info['telefono_otro'] != '')? $info['telefono_otro'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_otro; ?></td>
          </tr>
          <tr>
            <td class="encabezado">E-mail:</td>
            <td class="center" colspan="5"><?php echo $info['correo']; ?></td>
          </tr>
        </table>
      </div>
    <?php  
    }
    //* Estudios
		if($secciones['id_estudios'] == 3 && $verMayoresEstudios != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Mayores estudios del candidato</p>
				<table class="">
					<tr>
						<th class="encabezado"></th>
						<th class="encabezado">Candidato</th>
						<th class="encabezado">Analista</th>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Nivel académico</p></td>
						<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->grado_estudio; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Periodo</p></td>
						<td class="center"><p class="f-12"><?php echo $info->estudios_periodo; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->periodo; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Escuela</p></td>
						<td class="center"><p class="f-12"><?php echo $info->estudios_escuela; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->escuela; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Ciudad</p></td>
						<td class="center"><p class="f-12"><?php echo $info->estudios_ciudad; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->ciudad; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Certificate Obtained</p></td>
						<td class="center"><p class="f-12"><?php echo $info->estudios_certificado; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->certificado; ?></p></td>
					</tr>
				</table>
			</div><br>
      <div class="div_datos">
				<table class="">
					<tr>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->comentarios; ?></p></td>
					</tr>
				</table>
      </div><br>
		<?php 
		} 
    //* Documentacion
    if($secciones['id_seccion_verificacion_docs'] == 13 && $verDoc != null){ ?>
      <p class="center f-18">Documents</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-30 encabezado">Document</th>
            <th class="w-40 encabezado">Number</th>
            <th class="w-30 encabezado">Validity</th>
          </tr>
          <tr>
            <td class="encabezado center">ID</td>
            <td class="center"><?php echo $verDoc['ine']; ?></td>
            <td class="center"><?php echo $verDoc['ine_ano']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Passport</td>
            <td class="center"><?php echo $verDoc['pasaporte'] ?></td>
            <td class="center"><?php echo $verDoc['pasaporte_fecha']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">School Certificate</td>
            <td class="center"><?php echo $verDoc['licencia'] ?></td>
            <td class="center"><?php echo $verDoc['licencia_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Non-criminal background</td>
            <td class="center"><?php echo $verDoc['penales']; ?></td>
            <td class="center"><?php echo $verDoc['penales_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comments</td>
            <td class="center" colspan="2"><?php echo $verDoc['comentarios']; ?></td>
          </tr>
        </table>
      </div><br>
      <pagebreak>
    <?php
    }
    //* Global searches
    if($secciones['id_seccion_global_search'] == 67 && $secciones['id_seccion_global_search'] != null){ ?>
			<p class="center f-18">Global Searches</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 encabezado left">Global compliance & Sanctions database</td>
			    	<td class="w-80 center"><?php echo $global_searches['sanctions']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">Global media searches</td>
			    	<td class="center"><?php echo $global_searches['media_searches']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">OIG</td>
			    	<td class="center"><?php echo $global_searches['oig']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">SAM</td>
			    	<td class="center"><?php echo $global_searches['sam'] ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">OFAC</td>
			    	<td class="center"><?php echo $global_searches['ofac']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">FDA Department Search</td>
			    	<td class="center"><?php echo $global_searches->fda; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><?php echo $global_searches['global_comentarios']; ?></td>
			  	</tr>
        </table>
      </div>
    <?php
    }
    //* Laborales
    if($secciones['id_empleos'] == 16 && $empleos != NULL){ 
			$cont = 1;
			foreach($empleos as $ref){
				$ver_laboral = $this->candidato_laboral_model->getVerificacionLaboralByNumber($cont, $info['id']); ?>
				<p class="center f-18">Employment History </p>
				<div class="div_datos">
					<table class="">
            <tr>
              <th class="encabezado"></th>
              <th class="encabezado">Candidate</th>
              <th class="encabezado">Company</th>
              <th class="encabezado">Notes</th>
            </tr>
            <tr>
              <td class="encabezado center">Company</td>
              <td class="center"><?php echo $ref['empresa']; ?></td>
              <td class="center"><?php echo $vivienda['empresa'] ?></td>
              <td class="left w-30" rowspan="12"><?php echo $vivienda['notas']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Address</td>
              <td class="center"><?php echo $ref['direccion'];?></td>
              <td class="center"><?php echo $ver_laboral['direccion']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Entry Date</td>
              <td class="center"><?php echo $ref['fecha_entrada_txt']; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_entrada_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Exit Date</td>
              <td class="center"><?php echo $ref->fecha_salida_txt; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_salida_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Phone</td>
              <td class="center"><?php echo $ref['telefono']; ?></td>
              <td class="center"><?php echo $ver_laboral['telefono']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Initial Job Position</td>
              <td class="center"><?php echo $ref['puesto1']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto1']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Last Job Position</td>
              <td class="center"><?php echo $ref['puesto2']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto2']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Immediate Boss</td>
              <?php  
              $jefe_nombre = ($ref['jefe_nombre'] != null)? $ref['jefe_nombre'] : 'Not provided'; 
              $jefe_correo = ($ref['jefe_correo'] != null)? $ref['jefe_correo'] : 'Not provided'; ?>
              <td class="center"><?php echo $jefe_nombre."<br>".$jefe_correo; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_nombre']."<br>".$ver_laboral['jefe_correo']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Boss’s Job Position</td>
              <td class="center"><?php echo $ref['jefe_puesto']; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_puesto']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Cause of Separation</td>
              <td class="center"><?php echo $ref->causa_separacion; ?></td>
              <td class="center"><?php echo $ver_laboral['causa_separacion']; ?></td>
            </tr>
					</table>
				</div><br>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<td class="encabezado w-60">Did the candidate sue the company:</td>
					    	<td class="center"><?php echo $demanda = ($ver_laboral->demanda == 1)?'Yes':'No'; ?></td>
					  	</tr>
					</table>
				</div><br>
				<p class="f-14 center">Candidate Performance<br>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<th class="encabezado w-60">Area</th>
					    	<th class="encabezado">Calification</th>
					  	</tr>
					  	<?php 
					  	if($ver_laboral->responsabilidad == "Not provided" && $ver_laboral->iniciativa == "Not provided" && $ver_laboral->eficiencia == "Not provided" && $ver_laboral->disciplina == "Not provided" && $ver_laboral->puntualidad == "Not provided" && $ver_laboral->limpieza == "Not provided" && $ver_laboral->estabilidad == "Not provided" && $ver_laboral->emocional == "Not provided" && $ver_laboral->honestidad == "Not provided" && $ver_laboral->rendimiento == "Not provided" && $ver_laboral->actitud == "Not provided"){
					  		echo '<tr>
					  				<td class="encabezado center">Responsability</td>
					    			<td class="center" rowspan="11">Not provided</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Initiative</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Work efficiency</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Discipline</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Punctuality and assistance</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Cleanliness and order</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Stability</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Emotional Stability</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Honesty</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Performance</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
				  				</tr>';
					  	}
					  	else{
					  		if($ver_laboral->responsabilidad == "Excellent" && $ver_laboral->iniciativa == "Excellent" && $ver_laboral->eficiencia == "Excellent" && $ver_laboral->disciplina == "Excellent" && $ver_laboral->puntualidad == "Excellent" && $ver_laboral->limpieza == "Excellent" && $ver_laboral->estabilidad == "Excellent" && $ver_laboral->emocional == "Excellent" && $ver_laboral->honestidad == "Excellent" && $ver_laboral->rendimiento == "Excellent" && $ver_laboral->actitud == "Excellent"){
						  		echo '<tr>
						  				<td class="encabezado center">Responsability</td>
						    			<td class="center" rowspan="11">Excellent</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Initiative</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Work efficiency</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Discipline</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Punctuality and assistance</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Cleanliness and order</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Stability</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Emotional Stability</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Honesty</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Performance</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
					  				</tr>';
						  	}
						  	else{
						  		if($ver_laboral->responsabilidad == "Good" && $ver_laboral->iniciativa == "Good" && $ver_laboral->eficiencia == "Good" && $ver_laboral->disciplina == "Good" && $ver_laboral->puntualidad == "Good" && $ver_laboral->limpieza == "Good" && $ver_laboral->estabilidad == "Good" && $ver_laboral->emocional == "Good" && $ver_laboral->honestidad == "Good" && $ver_laboral->rendimiento == "Good" && $ver_laboral->actitud == "Good"){
							  		echo '<tr>
							  				<td class="encabezado center">Responsability</td>
							    			<td class="center" rowspan="11">Good</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Initiative</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Work efficiency</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Discipline</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Punctuality and assistance</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Cleanliness and order</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Stability</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Emotional Stability</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Honesty</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Performance</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
						  				</tr>';
							  	}
							  	else{
							  		if($ver_laboral->responsabilidad == "Regular" && $ver_laboral->iniciativa == "Regular" && $ver_laboral->eficiencia == "Regular" && $ver_laboral->disciplina == "Regular" && $ver_laboral->puntualidad == "Regular" && $ver_laboral->limpieza == "Regular" && $ver_laboral->estabilidad == "Regular" && $ver_laboral->emocional == "Regular" && $ver_laboral->honestidad == "Regular" && $ver_laboral->rendimiento == "Regular" && $ver_laboral->actitud == "Regular"){
								  		echo '<tr>
								  				<td class="encabezado center">Responsability</td>
								    			<td class="center" rowspan="11">Regular</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Initiative</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Work efficiency</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Discipline</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Punctuality and assistance</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Cleanliness and order</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Stability</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Emotional Stability</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Honesty</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Performance</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
							  				</tr>';
								  	}
								  	else{
								  		if($ver_laboral->responsabilidad == "Bad" && $ver_laboral->iniciativa == "Bad" && $ver_laboral->eficiencia == "Bad" && $ver_laboral->disciplina == "Bad" && $ver_laboral->puntualidad == "Bad" && $ver_laboral->limpieza == "Bad" && $ver_laboral->estabilidad == "Bad" && $ver_laboral->emocional == "Bad" && $ver_laboral->honestidad == "Bad" && $ver_laboral->rendimiento == "Bad" && $ver_laboral->actitud == "Bad"){
									  		echo '<tr>
									  				<td class="encabezado center">Responsability</td>
									    			<td class="center" rowspan="11">Bad</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Initiative</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Work efficiency</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Discipline</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Punctuality and assistance</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Cleanliness and order</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Stability</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Emotional Stability</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Honesty</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Performance</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
								  				</tr>';
									  	}
									  	else{
									  		if($ver_laboral->responsabilidad == "Very Bad" && $ver_laboral->iniciativa == "Very Bad" && $ver_laboral->eficiencia == "Very Bad" && $ver_laboral->disciplina == "Very Bad" && $ver_laboral->puntualidad == "Very Bad" && $ver_laboral->limpieza == "Very Bad" && $ver_laboral->estabilidad == "Very Bad" && $ver_laboral->emocional == "Very Bad" && $ver_laboral->honestidad == "Very Bad" && $ver_laboral->rendimiento == "Very Bad" && $ver_laboral->actitud == "Very Bad"){
										  		echo '<tr>
										  				<td class="encabezado center">Responsability</td>
										    			<td class="center" rowspan="11">Very Bad</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Initiative</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Work efficiency</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Discipline</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Punctuality and assistance</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Cleanliness and order</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Stability</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Emotional Stability</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Honesty</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Performance</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
									  				</tr>';
										  	}
										  	else{
										  		echo '<tr>
										  				<td class="encabezado center">Responsability</td>
										    			<td class="center">'.$ver_laboral->responsabilidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Initiative</td>
										  				<td class="center">'.$ver_laboral->iniciativa.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Work efficiency</td>
										  				<td class="center">'.$ver_laboral->eficiencia.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Discipline</td>
										  				<td class="center">'.$ver_laboral->disciplina.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Punctuality and assistance</td>
										  				<td class="center">'.$ver_laboral->puntualidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Cleanliness and order</td>
										  				<td class="center">'.$ver_laboral->limpieza.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Stability</td>
										  				<td class="center">'.$ver_laboral->estabilidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Emotional Stability</td>
										  				<td class="center">'.$ver_laboral->emocional.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Honesty</td>
										  				<td class="center">'.$ver_laboral->honestidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Performance</td>
										  				<td class="center">'.$ver_laboral->rendimiento.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
										  				<td class="center">'.$ver_laboral->actitud.'</td>
									  				</tr>';
										  	}
									  	}
								  	}
							  	}
						  	}
					  	}
					  	?>
					</table>
				</div>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<td class="encabezado w-60">In case of vacancy would you hire her/him again?</td>
                <?php 
                if($ver_laboral->recontratacion == 0){
                  $recontratacion ='No';
                }
                if($ver_laboral->recontratacion == 2){
                  $recontratacion ='N/A';
                }
                if($ver_laboral->recontratacion == 1){
                  $recontratacion ='Yes';
                } ?>
					    	<td class="center"><?php echo $recontratacion; ?></td>
					  	</tr>
					  	<tr>
					    	<td class="encabezado w-60">Why?</td>
					    	<td class="center"><?php echo $ver_laboral->motivo_recontratacion; ?></td>
					  	</tr>
					</table>
				</div>
        <pagebreak>
				<?php
				$cont++;
      } ?>

      <!-- <p class="center f-18">Break(s) in Employment</p>
      <div class="center">
        <textarea class="comentario" rows="3"><?php //echo $info->trabajo_inactivo; ?></textarea>
      </div><br>
      <div class="center">
        <p class="center f-18">Has he worked in any government entity, Politic Party or NGO?</p>
      </div>
      <div class="center">
        <textarea class="comentario" rows="3"><?php //echo $info->trabajo_gobierno; ?></textarea>
      </div> -->
      <div class="div_datos">
        <p class="center f-18">Employment history verification</p>
        <table class="">
          <tr>
            <td class="encabezado center">Labor verification requested</td>
            <td class="center"><?php echo $fecha_alta; ?></td>
            <!--td class="center" rowspan="2"><?php //echo $verificacionEmpleos->status; ?></!--td-->
          </tr>
          <tr>
            <td class="encabezado center">Verification completed</td>
            <td class="center"><?php echo $fechaVerificacionEmpleos = fechaPorIdioma($verificacionEmpleos['edicion'] , 'ingles'); ?></td>
          </tr>
        </table>
      </div><br>
      <div class="div_datos">
        <table>
          <?php 
          if($verificacionDetallesEmpleos){
            foreach($verificacionDetallesEmpleos as $row){
              $fecha_detalle = fechaPorIdioma($row['fecha'], 'ingles');
              echo '<tr>';
              echo '<td class="center w-17">'.$fecha_detalle.'</p></td>';
              echo '<td class="center">'.$row->comentarios.'</p></td>';
              echo '</tr>';
            }
          }
          ?>
        </table>
      </div><br>
      <pagebreak>
      <?php
		}
    //* Documentos
    if($docs){
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Privacy Notice </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 3){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>ID </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 14){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Passport </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 7){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Studies Certificate </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 12 || $doc['id_tipo_documento'] == 25){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Criminal Records </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 11){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OFAC </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 17){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OIG </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 21){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>SAM </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 18){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Global Search Check </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 9){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Employment History (NSS) </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
    }
  }
  ?>
<!-- Fin PDF 21 -->

<!-- Tipo PDF 20 -->
<?php 
	if($secciones['tipo_pdf'] == 20){
		//* Datos Generales
		if($secciones['id_seccion_datos_generales'] == 97 && $info['edad']!= null){ ?>
			<div class="div_datos">
				<p class="center f-18">Generales</p>
				<table class="">
						<tr>
							<td class="encabezado">Nombre:</td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $info['nombre']." ".$info['paterno']." ".$info['materno']; ?></p></td>
						</tr>
						<tr>
              <td class="encabezado">Lugar de Nacimiento:</td>
              <td class="center"><p class="f-12"><?php echo $info['lugar_nacimiento']; ?></p></td>
							<td class="encabezado w-17">Fecha de Nacimiento:</td>
							<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
              <td class="encabezado">Edad:</td>
							<td class="center"><p class="f-12"><?php echo $info['edad'] ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Género:</td>
							<td class="center"><p class="f-12"><?php echo $info['genero']; ?></p></td>
							<td class="encabezado">Estado civil:</td>
							<td class="center" colspan="3"><p class="f-12"><?php echo $info['estado_civil']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Domicilio (calle, número exterior e interior):</td>
							<td class="center"><p class="f-12"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior']; ?></p></td>
              <td class="encabezado">Colonia:</td>
							<td class="center"><p class="f-12"><?php echo $info['colonia'] ?></p></td>
              <td class="encabezado">Delegación:</td>
							<td class="center"><p class="f-12"><?php echo$info['municipio']; ?></p></td>
						</tr>
						<tr>
              <td class="encabezado">Código postal:</td>
							<td class="center"><p class="f-12"><?php echo $info['cp']; ?></p></td>
              <td class="encabezado">Estado:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado']; ?></p></td>
              <td class="encabezado">Entre la calle de:</td>
							<td class="center"><p class="f-12"><?php echo $entre = ($info['entre_calles'] == "")? "No proporciona":$info['entre_calles']; ?></p></td>
						</tr>
						<tr>
              <td class="encabezado">Grado máximo de estudios:</td>
							<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
              <td class="encabezado">Correo:</td>
							<td class="center"><p class="f-12"><?php echo $correo = ($info['correo']= "")? "No proporciona":$info['correo']; ?></p></td>
							<td class="encabezado">Teléfono celular:</td>
							<td class="center"><p class="f-12"><?php echo $info['celular']; ?></p></td>
						</tr>
				</table>
			</div><br>
    <?php  
    }
    //* Informacion de empresa
		if($secciones->id_candidato_empresa == 101 && $empresa != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Información de la Compañía</p>
				<table class="">
						<tr>
							<td class="encabezado">Nombre de la empresa:</td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $empresa->nombre; ?></p></td>
						</tr>
            <tr>
							<td class="encabezado">Domicilio, calle y número:</td>
							<td class="center"><p class="f-12"><?php echo $empresa->calle; ?></p></td>
              <td class="encabezado">Colonia:</td>
							<td class="center"><p class="f-12"><?php echo $empresa->colonia; ?></p></td>
              <td class="encabezado">Código postal:</td>
							<td class="center"><p class="f-12"><?php echo $empresa->cp; ?></p></td>
						</tr>
						<tr>
              <td class="encabezado">Teléfono:</td>
							<td class="center"><p class="f-12"><?php echo $empresa->telefono; ?></p></td>
							<td class="encabezado w-17">Tipo de empresa:</td>
							<td class="center"><p class="f-12"><?php echo $empresa->tipo; ?></p></td>
              <td class="encabezado">Antigüedad de la empresa:</td>
							<td class="center"><p class="f-12"><?php echo $empresa->antiguedad; ?></p></td>
						</tr>
				</table>
			</div>
    <?php  
    }
		//* Documentacion
		if($secciones['id_seccion_verificacion_docs'] == 98){
			if($verDoc != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Documentos Comprobatorios</p>
					<table class="">
						<tr>
							<th class="encabezado">CONCEPTO</th>
							<th class="encabezado">NÚMERO Y/O VIGENCIA</th>
							<th class="encabezado">FECHA / INSTITUCIÓN</th>
						</tr>
            <tr>
							<td class="encabezado center"><p class="f-12">Comprobante de domicilio</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->domicilio; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->fecha_domicilio; ?></p></td>
						</tr>
            <tr>
							<td class="encabezado center"><p class="f-12">Credencial de elector</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc['ine']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc['ine_institucion']; ?></p></td>
						</tr>
            <tr>
							<td class="encabezado center"><p class="f-12">Constancia Fiscal</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->constancia_fiscal; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->constancia_fiscal_fecha; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Acta Constitutiva</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->acta_constitutiva; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->acta_constitutiva_fecha; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Cédula Profesional</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->cedula; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->cedula_fecha; ?></p></td>
						</tr>
					</table>
				</div>
				<pagebreak>
			<?php 
			}
		}
		//* Referencias de clientes
    if($secciones['cantidad_ref_clientes'] > 0 && $refClientes != null){
      if($secciones['id_referencia_cliente'] == 99){ ?>
        <div class="div_datos">
          <p class="center f-18">Referencias de Clientes</p>
          <?php $salida2 = '';
          foreach($refClientes as $ref){            
            $salida2 .= '<table class=""><tr>';
            $salida2 .= '<td class="encabezado w-25"><p class="f-12">Nombre de la empresa</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$ref['empresa'].'</p></td>';
            $salida2 .= '<td class="encabezado w-25"><p class="f-12">Giro de la empresa</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$ref['tipo_empresa'].'</p></td>';
            $salida2 .= '</tr>';
            $salida2 .= '<tr>';
            $salida2 .= '<td class="encabezado w-25"><p class="f-12">Nombre</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$ref['nombre'].'</p></td>';
            $salida2 .= '<td class="encabezado w-25"><p class="f-12">Tiempo de conocerlo</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$ref['tiempo_conocerlo'].'</p></td>';
            $salida2 .= '</tr>';
            $salida2 .= '<tr>';
            $salida2 .= '<td class="encabezado"><p class="f-12">Teléfono</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$ref['telefono'].'</p></td>';
            $salida2 .= '<td class="encabezado w-25"><p class="f-12">Lo(a) recomienda</p></td>';
            $salida2 .= '<td class="center" colspan="3"><p class="f-12">'.$ref['recomienda'].'</p></td>';
            $salida2 .= '</tr>';
            $salida2 .= '<tr>';
            $salida2 .= '<td class="encabezado"><p class="f-12">Comentario</p></td>';
            $salida2 .= '<td class="encabezado" colspan="3"><p class="f-12">'.$ref['comentarios'].'</p></td>';
            $salida2 .= '</tr></table><br><br>';
          }
          echo $salida2;
          ?>		  	
        </div><br>
      <?php 
      }
    }
    //* Referencias vecinales
		if($secciones['cantidad_ref_vecinales'] > 0 && $refVecinal){
			if($refVecinal){ ?>
				<div class="div_datos">
					<p class="center f-18">Referencias Vecinales</p>
					<?php $salida4 = '';
					foreach($refVecinal as $refvec){
						$salida4 .= '<table class=""><tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">Nombre</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['nombre'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">Tiempo de conocerlo(a)</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['tiempo_conocerlo'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">Teléfono</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['telefono'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">Lo(a) recomienda</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['recomienda'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">Comentario</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['notas'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '</table><br>';
					}
					echo $salida4;
					?>		  	
				</div><br>
				<pagebreak>
			<?php 
			}
			else{
				$salida4 = '';
				$salida4 .= '<div class="div_datos">';
				$salida4 .= '<p class="center f-18">Referencias Vecinales</p>;';
				$salida4 .= '<table class=""><tr>';
				$salida4 .= '<td class="center"><p class="f-12">No posee referencias vecinales</p></td>';
				$salida4 .= '</tr></table><br><br>';
				$salida4 .= '</div><br>';
				$salida4 .= '<pagebreak>';
				echo $salida4;
			}
		}
    //* Investigación legal
		if($secciones['lleva_investigacion'] == 1 && $legal){ ?>
			<div class="div_datos">
				<p class="center f-18">Investigación Legal</p>
				<table class="">
					<tr>
						<td class="center w-20">Penal </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['penal']; ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['penal_notas']; ?></p></td>		    	
					</tr>
				</table><br><br>
				<table class="">
					<tr>
						<td class="center w-20">Civil </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['civil'];?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['civil_notas']; ?></p></td>		    	
					</tr>
				</table><br><br>
				<table class="">
					<tr>
						<td class="center w-20">Laboral </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['laboral']; ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['laboral_notas']; ?></p></td>		    	
					</tr>
				</table>
			</div><br>
		<?php 
		}
		//* Conclusion
		if($secciones['tipo_conclusion'] == 17 && $finalizado != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Conclusión de la Investigación</p><br>
			</div>
			<p class="left f-12"><?php echo $comentario_final = ($finalizado['comentario'] != null && $finalizado['comentario'] != '')? ' <b>'.$finalizado['comentario'].'</b>' : ''; ?></p>
		<?php 
		}
		//* Documentos
		if($secciones['visita'] != NULL && $docs){ ?>
      <pagebreak>
			<div class="center sin-flotar margen-top">
				<h2>Fotos </h2>
			</div>
			<?php 
			if($docs){
				foreach($docs as $doc){
					if($doc['id_tipo_documento'] == 19){
						echo '<div class="center margen-top">';
						echo '<img class="foto" src="'.base_url().'_docs/'.$doc['archivo'].'">';
						echo '</div>';
					}
				}
			}
		} ?>
		<?php 
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
          echo '<div class="center sin-flotar margen-top"><h2>Documentación </h2></div>';
					echo '<div class="center">';
					//echo '<h2>Aviso de privacidad</h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 3){
					echo '<pagebreak>';
					echo '<div class="center">';
					//echo '<h2>ID </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 2){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 4){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 10){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 45){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 47){
					echo '<pagebreak>';
					echo '<div class="center">';
					//echo '<h2>ID </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 9){
					echo '<pagebreak>';
					echo '<div class="center">';
					//echo '<h2>Semanas laborales cotizadas </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 25){
					echo '<pagebreak>';
					echo '<div class="center">';
					//echo '<h2>Comprobante de demanda </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 41){
					echo '<pagebreak>';
					echo '<div class="center">';
					//echo '<h2>Buró de crédito </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
		}    
	}?>
<!-- Fin Tipo PDF 20 -->

<!-- Tipo PDF 19 -->
<?php 
	if($secciones['tipo_pdf'] == 19){ 
    //* Datos Generales 
    ?>
    <p class="center f-18">Personal Data </p>
    <div class="div_datos">
      <table class="">
        <tr>
          <td class="w-20 encabezado">Name:</td>
          <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
        </tr>
        <tr>
          <td class="encabezado">Date of birth:</td>
          <td class="center"><?php echo $fecha_nacimiento; ?></td>
          <td class="encabezado">Age:</td>
          <td class="center"><?php echo $info['edad'] ?></td>
          <td class="encabezado w-17">Job Position Requested:</td>
          <td class="center"><?php echo $info['puesto']; ?></td>
        </tr>
        <tr>
          <td class="encabezado">Nationality:</td>
          <td class="center"><?php echo $info['nacionalidad']; ?></td>
          <td class="encabezado">Gender:</td>
          <td class="center"><?php echo $genero_ingles; ?></td>
          <td class="encabezado">Marital Status:</td>
          <td class="center"><?php echo $estado_civil_ingles; ?></td>
        </tr>
        <tr>
          <td class="encabezado">Country of residence:</td>
          <td class="center"><?php echo $info['nacionalidad']; ?></td>
          <td class="encabezado">Address:</td>
          <td class="center" colspan="3"><?php echo $info['domicilio_internacional']; ?></td>
        </tr>
        <tr>
          <td class="encabezado">Mobile Num:</td>
          <td class="center"><?php echo $info['celular']; ?></td>
          <td class="encabezado">Home Num:</td>
          <?php $telefono_casa = ($info['telefono_casa'] != null && $info['telefono_casa'] != '')? $info['telefono_casa'] : 'Not provided'; ?>
          <td class="center"><?php echo $telefono_casa; ?></td>
          <td class="encabezado">Number to leave Messages:</td>
          <?php $telefono_otro = ($info['telefono_otro'] != null && $info['telefono_otro'] != '')? $info['telefono_otro'] : 'Not provided'; ?>
          <td class="center"><?php echo $telefono_otro; ?></td>
        </tr>
        <tr>
          <td class="encabezado">E-mail:</td>
          <td class="center" colspan="5"><?php echo $info['correo']; ?></td>
        </tr>
      </table>
    </div><br>
    <?php
    //* Documentacion
    if($secciones['id_seccion_verificacion_docs'] == 39 && $verDoc != null){ ?>
		  <p class="center f-18">Documents</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-30 encabezado">Document</th>
            <th class="w-40 encabezado">Number</th>
            <th class="w-30 encabezado">Validity</th>
          </tr>
          <tr>
            <td class="encabezado center">ID</td>
            <td class="center"><?php echo $verDoc['ine']; ?></td>
            <td class="center"><?php echo $verDoc['ine_ano']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Passport</td>
            <td class="center"><?php echo $verDoc['pasaporte'] ?></td>
            <td class="center"><?php echo $verDoc['pasaporte_fecha']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Non-criminal background</td>
            <td class="center"><?php echo $verDoc['penales']; ?></td>
            <td class="center"><?php echo $verDoc['penales_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comments</td>
            <td class="center" colspan="2"><?php echo $verDoc['comentarios']; ?></td>
          </tr>
        </table>
      </div><br>
      <pagebreak>
    <?php
    }
    //* Global searches
    if($secciones['id_seccion_global_search'] == 6 && $secciones['id_seccion_global_search'] != null){ ?>
			<p class="center f-18">Global Searches</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="encabezado left">OIG</td>
			    	<td class="center"><?php echo $global_searches['oig']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">SAM</td>
			    	<td class="center"><?php echo $global_searches['sam'] ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">OFAC</td>
			    	<td class="center"><?php echo $global_searches['ofac']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">INTERPOL</td>
			    	<td class="center"><?php echo $global_searches['interpol']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><?php echo $global_searches['global_comentarios']; ?></td>
			  	</tr>
        </table>
      </div>
    <?php
    }
    //* Registros Verificacion Criminal
    if($secciones->lleva_criminal == 1){ ?>
      <div class="div_datos">
        <p class="center f-18">Criminal Verification</p>
        <table class="">
          <tr>
            <td class="encabezado center">Criminal verification requested</td>
            <td class="center"><?php echo $fecha_alta; ?></td>
            <td class="center" rowspan="2"><?php echo $verificacionCriminal->status; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Verification completed</td>
            <td class="center"><?php echo $fechaVerificacionCriminal = fechaPorIdioma($verificacionCriminal->edicion, 'ingles'); ?></td>
          </tr>
        </table>
      </div><br>
      <div class="div_datos">
        <table>
          <?php 
          if($verificacionDetallesCriminal){
            foreach($verificacionDetallesCriminal as $row){
              $fecha_detalle = fechaPorIdioma($row['fecha'], 'ingles');
              echo '<tr>';
              echo '<td class="center w-17">'.$fecha_detalle.'</td>';
              echo '<td class="center">'.$row->comentarios.'</td>';
              echo '</tr>';
            }
          } ?>
        </table>
      </div>
    <?php 
    }
    //* Documentos
    if($docs){
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Privacy Notice </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 3){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>ID </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 14){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Passport </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 12 || $doc['id_tipo_documento'] == 25){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Criminal Records </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 11){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OFAC </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 17){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OIG </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 21){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>SAM </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 18){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Global Search Check </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 9){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Employment History (NSS) </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
    }
  }
	?>
<!-- Tipo PDF 19 -->

<!-- Tipo PDF 18 -->
  <?php 
	if($secciones['tipo_pdf'] == 18){ 
    //* Datos Generales 
    ?>
    <p class="center f-18">Personal Data </p>
    <div class="div_datos">
      <table class="">
        <tr>
          <td class="w-20 encabezado">Name:</td>
          <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
        </tr>
        <tr>
          <td class="encabezado">Date of birth:</td>
          <td class="center"><?php echo $fecha_nacimiento; ?></td>
          <td class="encabezado">Age:</td>
          <td class="center"><?php echo $info['edad'] ?></td>
          <td class="encabezado w-17">Job Position Requested:</td>
          <td class="center"><?php echo $info['puesto']; ?></td>
        </tr>
        <tr>
          <td class="encabezado">Gender:</td>
          <td class="center"><?php echo $genero_ingles; ?></td>
          <td class="encabezado">Nationality:</td>
          <td class="center"><?php echo $info['nacionalidad']; ?></td>
          <td class="encabezado">Country of residence:</td>
          <td class="center"><?php echo $info['nacionalidad']; ?></td>
        </tr>
        <tr>
          <td class="encabezado">CURP:</td>
          <td class="center"><?php echo $info['curp']; ?></td>
          <td class="encabezado">SSN:</td>
          <td class="center"><?php echo $info['nss']; ?></td>
          <td class="encabezado">Mobile Num:</td>
          <td class="center"><?php echo $info['celular']; ?></td>
        </tr>
      </table>
    </div><br>
    <?php
    //* Documentacion
    if($secciones['id_seccion_verificacion_docs'] == 39 && $verDoc != null){ ?>
		  <p class="center f-18">Documents</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-30 encabezado">Document</th>
            <th class="w-40 encabezado">Number</th>
            <th class="w-30 encabezado">Validity</th>
          </tr>
          <tr>
            <td class="encabezado center">ID</td>
            <td class="center"><?php echo $verDoc['ine']; ?></td>
            <td class="center"><?php echo $verDoc['ine_ano']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Passport</td>
            <td class="center"><?php echo $verDoc['pasaporte'] ?></td>
            <td class="center"><?php echo $verDoc['pasaporte_fecha']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Non-criminal background</td>
            <td class="center"><?php echo $verDoc['penales']; ?></td>
            <td class="center"><?php echo $verDoc['penales_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comments</td>
            <td class="center" colspan="2"><?php echo $verDoc['comentarios']; ?></td>
          </tr>
        </table>
      </div><br>
    <?php
    }
    //* Global searches
    if($secciones['id_seccion_global_search'] == 94 && $secciones['id_seccion_global_search'] != null){ ?>
			<p class="center f-18">Global Searches</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="encabezado left">OIG</td>
			    	<td class="center"><?php echo $global_searches['oig']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">SAM</td>
			    	<td class="center"><?php echo $global_searches['sam'] ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">OFAC</td>
			    	<td class="center"><?php echo $global_searches['ofac']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><?php echo $global_searches['global_comentarios']; ?></td>
			  	</tr>
        </table>
      </div>
    <?php
    }
    //* Documentos
    if($docs){
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Privacy Notice </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 12){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Criminal Records </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 11){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OFAC </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 17){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OIG </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 21){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>SAM </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 18){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Global Search Check </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 9){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Employment History (NSS) </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
    }
  }
	?>
<!-- Tipo PDF 18 -->

<!-- Tipo PDF 17 -->
  <?php 
	if($secciones['tipo_pdf'] == 17){
		//* Datos Generales
		//TODO: Checar como integrar el tipo sanguineo dentro de los procesos
		if($secciones['id_seccion_datos_generales'] == 28 && $info['edad']!= null){ ?>
			<div class="div_datos">
				<p class="center f-18">Datos Personales</p>
				<table class="">
						<tr>
							<td class="encabezado">Nombre del aspirante:</td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $info['nombre']." ".$info['paterno']." ".$info['materno']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Puesto que solicita:</td>
							<td class="center"><p class="f-12"><?php echo $info['puestoSeleccionado'] ; ?></p></td>
							<td class="encabezado w-17">Fecha de Nacimiento:</td>
							<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
              <td class="encabezado">Edad:</td>
							<td class="center"><p class="f-12"><?php echo $info['edad'] ?></p></td>
						</tr>
						<tr>
              <td class="encabezado">Nacionalidad:</td>
							<td class="center"><p class="f-12"><?php echo $info['nacionalidad']; ?></p></td>
							<td class="encabezado">Género:</td>
							<td class="center"><p class="f-12"><?php echo $info['genero']; ?></p></td>
							<td class="encabezado">Estado civil:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado_civil']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Domicilio (calle, número exterior e interior):</td>
							<td class="center"><p class="f-12"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior']; ?></p></td>
							<td class="encabezado">Entre la calle de:</td>
							<td class="center"><p class="f-12"><?php echo $entre = ($info['entre_calles'] == "")? "No proporciona":$info['entre_calles']; ?></p></td>
							<td class="encabezado">Colonia:</td>
							<td class="center"><p class="f-12"><?php echo $info['colonia'] ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Ciudad:</td>
							<td class="center"><p class="f-12"><?php echo$info['municipio']; ?></p></td>
							<td class="encabezado">Estado:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado']; ?></p></td>
							<td class="encabezado">Código postal:</td>
							<td class="center"><p class="f-12"><?php echo $info['cp']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Teléfono de casa:</td>
							<td class="center"><p class="f-12"><?php echo $tel_casa = ($info['telefono_casa'] == "")? "No proporciona":$info['telefono_casa']; ?></p></td>
              <td class="encabezado">Otro teléfono:</td>
						  <td class="center"><p class="f-12"><?php echo $tel_otro = ($info['telefono_otro'] == "")? "No proporciona":$info['telefono_otro']; ?></p></td>
							<td class="encabezado">Teléfono celular:</td>
							<td class="center"><p class="f-12"><?php echo $info['celular']; ?></p></td>
						</tr>
            <tr>
              <td class="encabezado">Grado máximo de estudios:</td>
							<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
							<td class="encabezado">Correo:</td>
							<td class="center"><p class="f-12"><?php echo $correo = ($info['correo']= "")? "No proporciona":$info['correo']; ?></p></td>
              <td class="encabezado">Tiempo en el domicilio actual:</td>
						  <td class="center"><p class="f-12"><?php echo $info['tiempo_dom_actual']; ?></p></td>
						</tr>
            <tr>
              <td class="encabezado">Tiempo de traslado a la oficina:</td>
              <td class="center"><p class="f-12"><?php echo $info['tiempo_traslado']; ?></p></td>
              <td class="encabezado">Medio de transporte:</td>
              <td class="center"><p class="f-12"><?php echo $info['tipo_transporte']; ?></p></td>
							<?php 
							if($info['tipo_sanguineo'] != NULL && $info['tipo_sanguineo'] != ''){ ?>
								<td class="encabezado">Tipo sanguíneo:</td>
								<td class="center"><p class="f-12"><?php echo $info['tipo_sanguineo']; ?></p></td>
							<?php 
							} ?>
            </tr>
				</table>
			</div>
    <?php  
    }
		//* Estudios
		if($secciones['id_estudios'] == 29 && $academico != null){  ?>
			<div class="div_datos">
				<p class="center f-18">Historial Académico</p>
				<table class="">
          <tr>
            <th class="encabezado">NIVEL ESCOLAR</th>
            <th class="encabezado">PERIDO</th>
            <th class="encabezado">ESCUELA</th>
            <th class="encabezado">CIUDAD</th>
            <th class="encabezado">CERTIFICADO</th>
            
          </tr>
          <tr>
            <td class="encabezado center"><p class="f-12">Primaria</p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_periodo']; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_escuela']; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_ciudad']; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $res = ($academico['primaria_certificado'] == 1)? "Sí":"No"; ?></p></td>
          </tr>
          <?php 
          if($academico['secundaria_periodo'] != null && $academico['secundaria_periodo'] != ''){
          ?>
            <tr>
              <td class="encabezado center"><p class="f-12">Secundaria</p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_periodo']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_escuela']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_ciudad']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $res = ($academico['secundaria_certificado'] == 1)? "Sí":"No"; ?></p></td>
            </tr>
          <?php 
          } ?>
          <?php 
          if($academico['preparatoria_periodo'] != null && $academico['preparatoria_periodo'] != ''){
          ?>
            <tr>
              <td class="encabezado center"><p class="f-12">Bachillerato</p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_periodo']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_escuela']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_ciudad']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $res = ($academico['preparatoria_certificado'] == 1)? "Sí":"No"; ?></p></td>
            </tr>
          <?php 
          } ?>
          <?php 
          if($academico['licenciatura_periodo'] != null && $academico['licenciatura_periodo'] != ''){
          ?>
            <tr>
              <td class="encabezado center"><p class="f-12">Licenciatura</p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_periodo']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_escuela']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_ciudad']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $res = ($academico['licenciatura_certificado'] == 1)? "Sí":"No"; ?></p></td>
            </tr>
          <?php 
          } ?>
          <tr>
            <td class="encabezado center"><p class="f-12">Seminarios / Cursos</p></td>
            <td class="center" colspan="5"><p class="f-12"><?php echo $academico['otros_certificados']; ?></p></td>
          </tr>
          
          <tr>
            <td class="encabezado center"><p class="f-12">Comentarios</p></td>
            <td class="center" colspan="5"><p class="f-12"><?php echo $academico['comentarios']; ?></p></td>
          </tr>
				</table>
			</div><br>
			<div class="div_datos">
				<p class="center f-18">Periodos escolares inactivos</p>
				<table>
					<tr>
            <td class="center"><p class="f-12"><?php echo $academico['carrera_inactivo']; ?></p></td>
          </tr>
				</table>
			</div><br>
		<?php 
		} 
		//* Social
		if($secciones['lleva_sociales'] == 1){
			if($secciones['id_seccion_social'] == 30 && $sociales != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Antecedentes Sociales</p>
					<table class="">
						<tr>
							<td class="encabezado w-25">¿Qué religión profesa?  </td>
							<td class="center"><p class="f-12"><?php echo $secciones['religion']; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $secciones['religion_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Ingiere bebidas alcohólicas? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($secciones['bebidas'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia? </td>
							<td class="center"><p class="f-12"><?php echo $secciones['bebidas_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Acostumbra fumar?  </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['fumar'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['fumar_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Ha tenido alguna intervención quirúrgica? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['cirugia']; ?></p></td>
							<td class="encabezado w-25">¿Antecedentes de enfermedades en su familia directa? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['enfermedades']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Cuáles son sus planes a corto plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['corto_plazo']; ?></p></td>
							<td class="encabezado w-25">¿Cuáles son sus planes a mediano plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['mediano_plazo']; ?></p></td>
						</tr>
					</table>
				</div>
        <pagebreak>
			<?php 
			} 
		}   
		//* Laborales
    if($secciones['id_empleos'] == 90 && $empleos != NULL){ 
			$cont = 1;
			foreach($empleos as $ref){
				$ver_laboral = $this->candidato_laboral_model->getVerificacionLaboralByNumber($cont, $info['id']); ?>
				<p class="center f-18">Referencias laborales </p>
				<div class="div_datos">
					<table class="">
            <tr>
              <th class="encabezado"></th>
              <th class="encabezado">Candidato</th>
              <th class="encabezado">Compañía</th>
              <th class="encabezado">Notas</th>
            </tr>
            <tr>
              <td class="encabezado center">Compañía</td>
              <td class="center"><?php echo $ref['empresa']; ?></td>
              <td class="center"><?php echo $vivienda['empresa'] ?></td>
              <td class="left w-30" rowspan="12"><?php echo $vivienda['notas']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Domicilio</td>
              <td class="center"><?php echo $ref['direccion'];?></td>
              <td class="center"><?php echo $ver_laboral['direccion']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Fecha de ingreso</td>
              <td class="center"><?php echo $ref['fecha_entrada_txt']; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_entrada_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Fecha de salida</td>
              <td class="center"><?php echo $ref->fecha_salida_txt; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_salida_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Teléfono</td>
              <td class="center"><?php echo $ref['telefono']; ?></td>
              <td class="center"><?php echo $ver_laboral['telefono']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Puesto inicial</td>
              <td class="center"><?php echo $ref['puesto1']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto1']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Puesto final</td>
              <td class="center"><?php echo ver_laboral; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto2']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Sueldo inicial</td>
              <td class="center"><?php echo $ref['salario1_txt']; ?></td>
              <td class="center"><?php echo $ver_laboral['salario1_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Sueldo final</td>
              <td class="center"><?php echo $ref->salario2_txt; ?></td>
              <td class="center"><?php echo $ver_laboral['salario2_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Jefe inmediato</td>
              <?php  
              $jefe_nombre = ($ref['jefe_nombre'] != null)? $ref['jefe_nombre'] : 'Nombre no proporcionado'; 
              $jefe_correo = ($ref['jefe_correo'] != null)? $ref['jefe_correo'] : ';correo no proporcionado'; ?>
              <td class="center"><?php echo $jefe_nombre."<br>".$jefe_correo; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_nombre']."<br>".$ver_laboral['jefe_correo']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Puesto del jefe inmediato</td>
              <td class="center"><?php echo $ref['jefe_puesto']; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_puesto']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Causa de separación</td>
              <td class="center"><?php echo $ref->causa_separacion; ?></td>
              <td class="center"><?php echo $ver_laboral['causa_separacion']; ?></td>
            </tr>
					</table>
				</div><br>
        <pagebreak>
				<?php
				$cont++;
      } 
      //* GAPS
      if($secciones['lleva_gaps']== 1){ ?>
        <div class="div_datos">
          <p class="center f-18">Periodos inactivos laborales</p>
          <table class="">
            <tr>
              <th class="encabezado">Desde</th>
              <th class="encabezado">Hasta</th>
              <th class="encabezado" width="40%">Motivo/Razón</th>
            </tr>
            <?php 
            if($gaps){
              foreach($gaps as $g){ ?>
                <tr>
                  <td class="center"><p class="f-12"><?php echo $g['fecha_inicio']; ?></p></td>
                  <td class="center"><p class="f-12"><?php echo $g['fecha_fin']; ?></p></td>
                  <td class="center"><p class="f-12"><?php echo $g['razon']; ?></p></td>
                </tr>
            <?php
              }
            }
            else{ ?>
              <tr>
                <td class="center" colspan="3">No cuenta con periodos inactivos en su historial laboral</td>
              </tr>
            <?php 
            } ?>
          </table><br>
        </div>
      <?php 
      } ?>
      <div class="center">
        <p class="center f-18">Has he worked in any government entity, Politic Party or NGO?</p>
      </div>
      <div class="center">
        <textarea class="comentario" rows="3"><?php echo $info['trabajo_gobierno'] ; ?></textarea>
      </div><br>
    <?php
		}
		//* Conclusion
		if($secciones['tipo_conclusion'] == 15 && isset($finalizado)){ ?>
			<div class="div_datos">
				<p class="center f-18">Conclusión</p><br>
				<table class="">
					<tr>
						<td class="left"><?php echo $finalizado['descripcion_personal1']; ?></td>
					</tr>
					<tr>
						<td class="left"><?php echo $finalizado['descripcion_personal2']; ?></td>		    	
					</tr>
          <tr>
						<td class="left"><?php echo $finalizado['descripcion_laboral2']; ?></td>		    	
					</tr>
          <tr>
						<td class="left"><?php echo $finalizado->conclusion_investigacion; ?></td>		    	
					</tr>
				</table>
			</div><br>
		<?php 
		}
		//* Documentos
    $pagebreak = 0;
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 46){ ?>
          <pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Reporte de INFONAVIT </p>
					</div>
					<div class="center">
						<?php 
            echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750">';
						?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 11){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">OFAC </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750"><br><br>'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 8){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Aviso de privacidad </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750">'; ?>
					</div>
				<?php
				}
			}
			//* Anexos
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 9){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Comprobante de historial laboral </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 13){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Carta laboral </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 23){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Evidencia de correo </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 24){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Evidencia de chat </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
		}
	}
	?>
<!-- Tipo PDF 17 -->

<!-- Tipo PDF 16 -->
  <?php 
	if($secciones['tipo_pdf'] == 16){
		//* Datos Generales
		//TODO: Checar como integrar el tipo sanguineo dentro de los procesos
		if($secciones['id_seccion_datos_generales'] == 28 && $info['edad']!= null){ ?>
			<div class="div_datos">
				<p class="center f-18">Datos Personales</p>
				<table class="">
						<tr>
							<td class="encabezado">Nombre del aspirante:</td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $info['nombre']." ".$info['paterno']." ".$info['materno']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Puesto que solicita:</td>
							<td class="center"><p class="f-12"><?php echo $info['puestoSeleccionado']; ?></p></td>
							<td class="encabezado w-17">Fecha de Nacimiento:</td>
							<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
              <td class="encabezado">Edad:</td>
							<td class="center"><p class="f-12"><?php echo $info['edad'] ?></p></td>
						</tr>
						<tr>
              <td class="encabezado">Nacionalidad:</td>
							<td class="center"><p class="f-12"><?php echo $info['nacionalidad']; ?></p></td>
							<td class="encabezado">Género:</td>
							<td class="center"><p class="f-12"><?php echo $info['genero']; ?></p></td>
							<td class="encabezado">Estado civil:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado_civil']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Domicilio (calle, número exterior e interior):</td>
							<td class="center"><p class="f-12"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior']; ?></p></td>
							<td class="encabezado">Entre la calle de:</td>
							<td class="center"><p class="f-12"><?php echo $entre = ($info['entre_calles'] == "")? "No proporciona":$info['entre_calles']; ?></p></td>
							<td class="encabezado">Colonia:</td>
							<td class="center"><p class="f-12"><?php echo $info['colonia'] ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Ciudad:</td>
							<td class="center"><p class="f-12"><?php echo$info['municipio']; ?></p></td>
							<td class="encabezado">Estado:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado']; ?></p></td>
							<td class="encabezado">Código postal:</td>
							<td class="center"><p class="f-12"><?php echo $info['cp']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Teléfono de casa:</td>
							<td class="center"><p class="f-12"><?php echo $tel_casa = ($info['telefono_casa'] == "")? "No proporciona":$info['telefono_casa']; ?></p></td>
              <td class="encabezado">Otro teléfono:</td>
						  <td class="center"><p class="f-12"><?php echo $tel_otro = ($info['telefono_otro'] == "")? "No proporciona":$info['telefono_otro']; ?></p></td>
							<td class="encabezado">Teléfono celular:</td>
							<td class="center"><p class="f-12"><?php echo $info['celular']; ?></p></td>
						</tr>
            <tr>
              <td class="encabezado">Grado máximo de estudios:</td>
							<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
							<td class="encabezado">Correo:</td>
							<td class="center"><p class="f-12"><?php echo $correo = ($info['correo']= "")? "No proporciona":$info['correo']; ?></p></td>
              <td class="encabezado">Tiempo en el domicilio actual:</td>
						  <td class="center"><p class="f-12"><?php echo $info['tiempo_dom_actual']; ?></p></td>
						</tr>
            <tr>
              <td class="encabezado">Tiempo de traslado a la oficina:</td>
              <td class="center"><p class="f-12"><?php echo $info['tiempo_traslado']; ?></p></td>
              <td class="encabezado">Medio de transporte:</td>
              <td class="center"><p class="f-12"><?php echo $info['tipo_transporte']; ?></p></td>
							<?php 
							if($info['tipo_sanguineo'] != NULL && $info['tipo_sanguineo'] != ''){ ?>
								<td class="encabezado">Tipo sanguíneo:</td>
								<td class="center"><p class="f-12"><?php echo $info['tipo_sanguineo']; ?></p></td>
							<?php 
							} ?>
            </tr>
				</table>
			</div>
    <?php  
    }
    //* Familiar
		if($secciones['lleva_familiares'] == 1 && $familia){ ?>
			<div class="div_datos">
				<p class="center f-18">Datos del Grupo Familiar</p>
				<table class="">
					<tr>
						<th class="encabezado">NOMBRE</th>
						<th class="encabezado">PARENTESCO</th>
						<th class="encabezado">EDAD</th>
						<th class="encabezado">OCUPACIÓN</th>
						<th class="encabezado">CIUDAD/COMPAÑÍA</th>
						<th class="encabezado">VIVE CON USTED</th>
					</tr>
					<?php $salida = '';
					if($familia){
						foreach($familia as $f){
              $salida .= '<tr>';
              $salida .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
              $salida .= '<td class="center"><p class="f-12">'.$f['parentesco'].'</p></td>';
              $salida .= '<td class="center"><p class="f-12">'.$f['edad'].'</p></td>';
              $salida .= '<td class="center"><p class="f-12">'.$f['puesto'].'</p></td>';
              $salida .= '<td class="center"><p class="f-12">'.$f['escolaridad'].'</p></td>';
              $salida .= ($f['misma_vivienda'] == 1) ? '<td class="center"><p class="f-12">Sí</p></td>' : '<td class="center"><p class="f-12">No</p></td>';
              $salida .= '</tr>';
						}
					}
					else{
						$salida2 .= '<tr>';
						$salida2 .= '<td class="center" colspan="6"><p class="f-12">El candidato vive solo</p></td>';
						$salida2 .= '</tr>';
					}
					echo $salida;
					?>
				</table>
			</div><br>
      <pagebreak>
		  <?php 
		}
		//* Estudios
		if($secciones['id_estudios'] == 29 && $academico != null){  ?>
			<div class="div_datos">
				<p class="center f-18">Historial Académico</p>
				<table class="">
          <tr>
            <th class="encabezado">NIVEL ESCOLAR</th>
            <th class="encabezado">PERIDO</th>
            <th class="encabezado">ESCUELA</th>
            <th class="encabezado">CIUDAD</th>
            <th class="encabezado">CERTIFICADO</th>
            
          </tr>
          <tr>
            <td class="encabezado center"><p class="f-12">Primaria</p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_periodo']; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_escuela']; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_ciudad']; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $res = ($academico['primaria_certificado'] == 1)? "Sí":"No"; ?></p></td>
          </tr>
          <?php 
          if($academico['secundaria_periodo'] != null && $academico['secundaria_periodo'] != ''){
          ?>
            <tr>
              <td class="encabezado center"><p class="f-12">Secundaria</p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_periodo']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_escuela']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_ciudad']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $res = ($academico['secundaria_certificado'] == 1)? "Sí":"No"; ?></p></td>
            </tr>
          <?php 
          } ?>
          <?php 
          if($academico['preparatoria_periodo'] != null && $academico['preparatoria_periodo'] != ''){
          ?>
            <tr>
              <td class="encabezado center"><p class="f-12">Bachillerato</p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_periodo']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_escuela']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_ciudad']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $res = ($academico['preparatoria_certificado'] == 1)? "Sí":"No"; ?></p></td>
            </tr>
          <?php 
          } ?>
          <?php 
          if($academico['licenciatura_periodo'] != null && $academico['licenciatura_periodo'] != ''){
          ?>
            <tr>
              <td class="encabezado center"><p class="f-12">Licenciatura</p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_periodo']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_escuela']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_ciudad']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $res = ($academico['licenciatura_certificado'] == 1)? "Sí":"No"; ?></p></td>
            </tr>
          <?php 
          } ?>
          <tr>
            <td class="encabezado center"><p class="f-12">Seminarios / Cursos</p></td>
            <td class="center" colspan="5"><p class="f-12"><?php echo $academico['otros_certificados']; ?></p></td>
          </tr>
          
          <tr>
            <td class="encabezado center"><p class="f-12">Comentarios</p></td>
            <td class="center" colspan="5"><p class="f-12"><?php echo $academico['comentarios']; ?></p></td>
          </tr>
				</table>
			</div><br>
			<div class="div_datos">
				<p class="center f-18">Periodos escolares inactivos</p>
				<table>
					<tr>
            <td class="center"><p class="f-12"><?php echo $academico['carrera_inactivo']; ?></p></td>
          </tr>
				</table>
			</div><br>
		<?php 
		} 
		//* Social
		if($secciones['lleva_sociales'] == 1){
			if($secciones['id_seccion_social'] == 30 && $sociales != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Antecedentes Sociales</p>
					<table class="">
						<tr>
							<td class="encabezado w-25">¿Qué religión profesa?  </td>
							<td class="center"><p class="f-12"><?php echo $secciones['religion']; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $secciones['religion_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Ingiere bebidas alcohólicas? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($secciones['bebidas'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia? </td>
							<td class="center"><p class="f-12"><?php echo $secciones['bebidas_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Acostumbra fumar?  </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['fumar'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['fumar_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Ha tenido alguna intervención quirúrgica? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['cirugia']; ?></p></td>
							<td class="encabezado w-25">¿Antecedentes de enfermedades en su familia directa? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['enfermedades']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Cuáles son sus planes a corto plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['corto_plazo']; ?></p></td>
							<td class="encabezado w-25">¿Cuáles son sus planes a mediano plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['mediano_plazo']; ?></p></td>
						</tr>
					</table>
				</div>
        <pagebreak>
			<?php 
			} 
		}   
		//* Finanzas
		if($secciones['lleva_familiares'] == 1 && $secciones['lleva_egresos']== 1 && $secciones['id_finanzas'] == 88 && $finanzas != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Situación Económica</p>
				<table class="">
					<tr>
						<th class="encabezado" colspan="3">INGRESOS MENSUALES</th>
					</tr>
					<tr>
						<th class="encabezado">NOMBRE</th>
						<th class="encabezado">SUELDO</th>
						<th class="encabezado">APORTACIÓN</th>
					</tr>
					<?php $salida2 = '';
          if($finanzas['unico_solvente'] == 0){
            if($familia){
              foreach($familia as $f){
                $salida2 .= '<tr>';
                $salida2 .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
                $salida2 .= '<td class="center"><p class="f-12">'.$f['sueldo'].'</p></td>';
                $salida2 .= '<td class="center"><p class="f-12">'.$f['monto_aporta'].'</p></td>';
                $salida2 .= '</tr>';
              }
              //TODO: Se puede agregar el campo de aportacion del candidato en la seccion
              $salida2 .= '<tr>';
              $salida2 .= '<td class="center"><p class="f-12">'.$info['candidato'].'</p></td>';
              $salida2 .= '<td class="center"><p class="f-12">'.$info->ingresos.'</p></td>';
              $salida2 .= '<td class="center"><p class="f-12">'.$info->ingresos.'</p></td>';
              $salida2 .= '</tr>';
            }
            else{
              //TODO: Se puede agregar el campo de aportacion del candidato en la seccion
              $salida2 .= '<tr>';
              $salida2 .= '<td class="center"><p class="f-12">'.$info['candidato'].'</p></td>';
              $salida2 .= '<td class="center"><p class="f-12">'.$info->ingresos.'</p></td>';
              $salida2 .= '<td class="center"><p class="f-12">'.$info->ingresos.'</p></td>';
              $salida2 .= '</tr>';
              $salida2 .= '<tr>';
              $salida2 .= '<td class="center" colspan="3">El candidato es independiente en cuestión a los gastos generados en el hogar</td>';
              $salida2 .= '</tr>';
            }
          }
          else{
            //TODO: Se puede agregar el campo de aportacion del candidato en la seccion
            $salida2 .= '<tr>';
            $salida2 .= '<td class="center"><p class="f-12">'.$info['candidato'].'</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$info->ingresos.'</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$info->ingresos.'</p></td>';
            $salida2 .= '</tr>';
            $salida2 .= '<tr>';
            $salida2 .= '<td class="center">El candidato es independiente en cuestión a los gastos generados en el hogar</td>';
            $salida2 .= '</tr>';
          }
					echo $salida2;
					?>
				</table>
				<?php 
				//* Brinco de hoja en caso de exceder numero de familiares
				if($numFamiliares >= 12){
					echo '<pagebreak>';
				}
				?>
				<table class="">
					<tr>
						<th class="encabezado" colspan="2">EGRESOS MENSUALES</th>
					</tr>
					<tr>
						<th class="encabezado w-25">CONCEPTOS</th>
						<th class="encabezado">MONTOS</th>
					</tr>
					<tr>
						<td class="encabezado w-40">Renta </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['renta']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">Alimentos </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['alimentos']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">Servicios </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['servicios']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">Transporte </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['transporte']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">Otros </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['otros']; ?></p></td>
						<?php $total = $finanzas['renta'] + $finanzas['alimentos'] + $finanzas['servicios'] + $finanzas['transporte'] + $finanzas['otros']; ?>
					</tr>
					<tr>
						<td class="encabezado w-40">Total </td>
						<td class="encabezado"><p class="f-12"><?php echo "$ ".$total; ?></p></td>
					</tr>
				</table>
			</div><br>	
		<?php 
		}

    //* Brinco de hoja en caso de exceder numero de familiares y si el candidato es el unico solvente de los gastos
    if($numFamiliares >= 5 && $finanzas['unico_solvente'] == 0){
      echo '<pagebreak>';
    }

    //* Vivienda
		if($secciones['lleva_vivienda'] == 1 && $vivienda != null){  ?>
			<div class="div_datos">
				<p class="center f-18">Vivienda</p>
				<table class="">
          <tr>
						<td class="encabezado center w-40"><p class="f-12">Condición</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda->tipo_propiedad; ?></p></td>
					</tr>
          <tr>
            <td class="encabezado center w-40"><p class="f-12">Tipo de vivienda</p></td>
            <td class="center"><p class="f-12"><?php echo $vivienda['vivienda']; ?></p></td>
          </tr>
          <tr>
						<td class="encabezado center w-40"><p class="f-12">Tamaño de la vivienda</p></td>
						<?php
						if($vivienda['tamanio_vivienda'] == 1){
							$tamano = "Amplia";
						}
						if($vivienda['tamanio_vivienda'] == 2){
							$tamano = "Media";
						}
						if($vivienda['tamanio_vivienda'] == 3){
							$tamano = "Reducida";
						}
						?>
						<td class="center"><p class="f-12"><?php echo $tamano; ?></p></td>
					</tr>
          <tr>
            <td class="encabezado center w-40"><p class="f-12">Distribución</p></td>
            <?php $distribucion = '';
            $cocina = ($vivienda['cocina'] == 'Sí')? 'cocina, ' : '';
            $comedor = ($vivienda['comedor'] == 'Sí')? 'comedor, ' : '';
            $sala = ($vivienda['sala'] == 'Sí')? 'sala, ' : '';
            $cochera = ($vivienda['cochera'] == 'Sí')? 'cochera, ' : '';
            $patio = ($vivienda['patio']== 'Sí')? 'patio, ' : '';
            $cuarto_servicio = ($vivienda['cuarto_servicio'] == 'Sí')? 'cuarto_servicio, ' : '';
            $jardin = ($vivienda['jardin'] == 'Sí')? 'jardín, ' : '';
            $recamaras = ($vivienda['recamaras'] != null)? $vivienda['recamaras'].' recámaras, ' : '';
            $banios = ($vivienda['banios'] != null)? $vivienda['banios'].' baños' : '';
            $distribucion = $cocina.$comedor.$sala.$cochera.$patio.$cuarto_servicio.$jardin.$recamaras.$banios; ?>
            <td class="center"><p class="f-12"><?php echo ucfirst($distribucion); ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center w-40"><p class="f-12">Enseres domésticos</p></td>
            <?php $enseres = '';
            $estufa = ($vivienda['estufa'] == 1)? 'estufa, ' : '';
            $refrigerador = ($vivienda['refrigerador'] == 1)? 'refrigerador, ' : '';
            $lavadora = ($vivienda['lavadora'] == 1)? 'lavadora, ' : '';
            $plancha_ropa = ($vivienda['plancha_ropa'] == 1)? 'plancha de ropa, ' : '';
            $tv = ($vivienda['tv'] == 1)? 'TV, ' : '';
            $dvd = ($vivienda['dvd'] == 1)? 'DVD/Blue-ray, ' : '';
            $microondas = ($vivienda['microondas'] == 1)? 'microondas, ' : '';
            $equipo_musica = ($vivienda['equipo_musica'] == 1)? 'equipos de música, ' : '';
            $computadora = ($vivienda['computadora'] == 1)? 'computadora, ' : '';
            $licuadora = ($vivienda['licuadora'] == 1)? 'licuadora, ' : '';
            $secadora_ropa = ($vivienda['secadora_ropa'] == 1)? 'secadora de ropa, ' : '';
            $tel_fijo = ($vivienda['tel_fijo'] == 1)? 'teléfono fijo, ' : '';
            $ventilador = ($vivienda['ventilador'] == 1)? 'ventilador, ' : '';
            $tostadora = ($vivienda['tostadora'] == 1)? 'tostadora' : '';
            $enseres = $estufa.$refrigerador.$lavadora.$plancha_ropa.$tv.$dvd.$microondas.$equipo_musica.$computadora.$licuadora.$secadora_ropa.$tel_fijo.$ventilador.$tostadora; ?>
            <td class="center"><p class="f-12"><?php echo ucfirst($enseres); ?></p></td>
          </tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">Calidad del mobiliario</p></td>
						<?php
						if($vivienda['calidad_mobiliario'] == 1){
							$calidad = "Buena";
						}
						if($vivienda['calidad_mobiliario'] == 2){
							$calidad = "Regular";
						}
						if($vivienda['calidad_mobiliario'] == 3){
							$calidad = "Mala";
						}
						?>
						<td class="center"><p class="f-12"><?php echo $calidad; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">El mobiliario esta</p></td>
						<td class="center"><p class="f-12"><?php echo $res = ($vivienda['mobiliario'] == 1)? "Completo":"Incompleto"; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">Condiciones de la vivienda</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['condiciones']; ?></p></td>
					</tr>
          <?php 
          //* Servicios públicos
		      if($secciones['id_servicio']== 92 && $servicios != null){ ?>
            <tr>
              <td class="encabezado center w-40"><p class="f-12">¿Posee los servicios básicos municipales?</p></td>
              <td class="center"><p class="f-12"><?php echo $servicios['servicios_basicos']; ?></p></td>
            </tr>
            <tr>
              <td class="encabezado center w-40"><p class="f-12">¿Cuenta con vías de acceso?</p></td>
              <td class="center"><p class="f-12"><?php echo $servicios['vias_acceso']; ?></p></td>
            </tr>
            <tr>
              <td class="encabezado center w-40"><p class="f-12">¿Existen rutas de transporte público cercanas?</p></td>
              <td class="center"><p class="f-12"><?php echo $servicios['rutas_transporte']; ?></p></td>
            </tr>
            <?php 
          } ?>
				</table>
			</div><br>
      <pagebreak>
		<?php 
		}
		//* Laborales
    if($secciones['id_empleos'] == 90 && $empleos != NULL){ 
			$cont = 1;
			foreach($empleos as $ref){
				$ver_laboral = $this->candidato_laboral_model->getVerificacionLaboralByNumber($cont, $info['id']); ?>
				<p class="center f-18">Referencias laborales </p>
				<div class="div_datos">
					<table class="">
            <tr>
              <th class="encabezado"></th>
              <th class="encabezado">Candidato</th>
              <th class="encabezado">Compañía</th>
              <th class="encabezado">Notas</th>
            </tr>
            <tr>
              <td class="encabezado center">Compañía</td>
              <td class="center"><?php echo $ref['empresa']; ?></td>
              <td class="center"><?php echo $vivienda['empresa'] ?></td>
              <td class="left w-30" rowspan="12"><?php echo $vivienda['notas']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Domicilio</td>
              <td class="center"><?php echo $ref['direccion'];?></td>
              <td class="center"><?php echo $ver_laboral['direccion']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Fecha de ingreso</td>
              <td class="center"><?php echo $ref['fecha_entrada_txt']; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_entrada_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Fecha de salida</td>
              <td class="center"><?php echo $ref->fecha_salida_txt; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_salida_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Teléfono</td>
              <td class="center"><?php echo $ref['telefono']; ?></td>
              <td class="center"><?php echo $ver_laboral['telefono']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Puesto inicial</td>
              <td class="center"><?php echo $ref['puesto1']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto1']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Puesto final</td>
              <td class="center"><?php echo $ref['puesto2']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto2']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Sueldo inicial</td>
              <td class="center"><?php echo $ref['salario1_txt']; ?></td>
              <td class="center"><?php echo $ver_laboral['salario1_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Sueldo final</td>
              <td class="center"><?php echo $ref->salario2_txt; ?></td>
              <td class="center"><?php echo $ver_laboral['salario2_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Jefe inmediato</td>
              <?php  
              $jefe_nombre = ($ref['jefe_nombre'] != null)? $ref['jefe_nombre'] : 'Nombre no proporcionado'; 
              $jefe_correo = ($ref['jefe_correo'] != null)? $ref['jefe_correo'] : ';correo no proporcionado'; ?>
              <td class="center"><?php echo $jefe_nombre."<br>".$jefe_correo; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_nombre']."<br>".$ver_laboral['jefe_correo']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Puesto del jefe inmediato</td>
              <td class="center"><?php echo $ref['jefe_puesto']; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_puesto']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Causa de separación</td>
              <td class="center"><?php echo $ref->causa_separacion; ?></td>
              <td class="center"><?php echo $ver_laboral['causa_separacion']; ?></td>
            </tr>
					</table>
				</div><br>
        <pagebreak>
				<?php
				$cont++;
      } 
      //* GAPS
      if($secciones['lleva_gaps']== 1){ ?>
        <div class="div_datos">
          <p class="center f-18">Periodos inactivos laborales</p>
          <table class="">
            <tr>
              <th class="encabezado">Desde</th>
              <th class="encabezado">Hasta</th>
              <th class="encabezado" width="40%">Motivo/Razón</th>
            </tr>
            <?php 
            if($gaps){
              foreach($gaps as $g){ ?>
                <tr>
                  <td class="center"><p class="f-12"><?php echo $g['fecha_inicio']; ?></p></td>
                  <td class="center"><p class="f-12"><?php echo $g['fecha_fin']; ?></p></td>
                  <td class="center"><p class="f-12"><?php echo $g['razon']; ?></p></td>
                </tr>
            <?php
              }
            }
            else{ ?>
              <tr>
                <td class="center" colspan="3">No cuenta con periodos inactivos en su historial laboral</td>
              </tr>
            <?php 
            } ?>
          </table><br>
        </div>
      <?php 
      } ?>
      <div class="center">
        <p class="center f-18">Has he worked in any government entity, Politic Party or NGO?</p>
      </div>
      <div class="center">
        <textarea class="comentario" rows="3"><?php echo $info['trabajo_gobierno'] ; ?></textarea>
      </div><br>
    <?php
		}
    //* Referencias vecinales
		if($secciones['cantidad_ref_vecinales'] > 0 && $refVecinal){
			if($refVecinal){ ?>
				<div class="div_datos">
					<p class="center f-18">Referencias Vecinales</p>
					<?php $salida4 = '';
					foreach($refVecinal as $refvec){
						$salida4 .= '<table class=""><tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">Nombre</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['nombre'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">Domicilio</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['domicilio'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Qué concepto tiene del aspirante?</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['concepto_candidato'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿En qué concepto tiene a la familia como vecinos?</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['concepto_familia'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Conoce el estado civil del aspirante? ¿Cuál es?</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['civil_candidato'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Tiene hijos?</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['hijos_candidato'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '</table><br>';
					}
					echo $salida4;
					?>		  	
				</div><br>
				<pagebreak>
			<?php 
			}
			else{
				$salida4 = '';
				$salida4 .= '<div class="div_datos">';
				$salida4 .= '<p class="center f-18">Referencias Vecinales</p>;';
				$salida4 .= '<table class=""><tr>';
				$salida4 .= '<td class="center"><p class="f-12">No posee referencias vecinales</p></td>';
				$salida4 .= '</tr></table><br><br>';
				$salida4 .= '</div><br>';
				$salida4 .= '<pagebreak>';
				echo $salida4;
			}
		}
    //* Referencias personales
    if($secciones['cantidad_ref_personales']> 0 && $refPersonal != null){
      if($secciones['id_ref_personales'] == 26){ ?>
        <div class="div_datos">
          <p class="center f-18">Referencias Personales</p>
          <?php $salida2 = '';
          foreach($refPersonal as $refper){
            if($refper['recomienda'] == 0){
              $recomienda = "No";
            }
            if($refper['recomienda'] == 1){
              $recomienda = "Sí";
            }
            if($refper['recomienda'] == 2){
              $recomienda = "NA";
            }
            $sabe_donde = ($refper['sabe_trabajo'] == 1)? "Sí":"No";
            $sabe_vive = ($refper['sabe_vive'] == 1)? "Sí":"No";
            
            $salida2 .= '<table class=""><tr>';
            $salida2 .= '<td class="encabezado w-25"><p class="f-12">Nombre</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$refper['nombre'].'</p></td>';
            $salida2 .= '<td class="encabezado w-25"><p class="f-12">Teléfono</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$refper['telefono'].'</p></td>';
            $salida2 .= '</tr>';
            $salida2 .= '<tr>';
            $salida2 .= '<td class="encabezado w-25"><p class="f-12">Tiempo de conocerlo</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$refper['tiempo_conocerlo'].'</p></td>';
            $salida2 .= '<td class="encabezado w-25"><p class="f-12">De qué lugar conoce al candidato</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$refper['donde_conocerlo'].'</p></td>';
            $salida2 .= '</tr>';
            $salida2 .= '<tr>';
            $salida2 .= '<td class="encabezado"><p class="f-12">Sabe dónde trabaja el candidato</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$sabe_donde.'</p></td>';
            $salida2 .= '<td class="encabezado"><p class="f-12">Sabe dónde vive el candidato</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$sabe_vive.'</p></td>';
            $salida2 .= '</tr>';
            $salida2 .= '<tr>';
            $salida2 .= '<td class="encabezado w-25"><p class="f-12">La recomienda</p></td>';
            $salida2 .= '<td class="center" colspan="3"><p class="f-12">'.$recomienda.'</p></td>';
            $salida2 .= '</tr>';
            $salida2 .= '<tr>';
            $salida2 .= '<td class="encabezado"><p class="f-12">Comentario</p></td>';
            $salida2 .= '<td class="encabezado" colspan="3"><p class="f-12">'.$refper['comentario'].'</p></td>';
            $salida2 .= '</tr></table><br><br>';
          }
          echo $salida2;
          ?>		  	
        </div><br>
        <pagebreak>
      <?php 
      }
    }
		//* Conclusion
		if($secciones['tipo_conclusion'] == 14 && isset($finalizado)){ ?>
			<div class="div_datos">
				<p class="center f-18">Conclusión</p><br>
				<table class="">
					<tr>
						<td class="left"><?php echo $finalizado['descripcion_personal1']; ?></td>
					</tr>
					<tr>
						<td class="left"><?php echo $finalizado['descripcion_personal2']; ?></td>		    	
					</tr>
          <tr>
						<td class="left"><?php echo $finalizado['descripcion_personal3']; ?></td>		    	
					</tr>
          <tr>
						<td class="left"><?php echo $finalizado['descripcion_socio1']; ?></td>
					</tr>
					<tr>
						<td class="left"><?php echo $finalizado['descripcion_socio2']; ?></td>		    	
					</tr>
          <tr>
						<td class="left"><?php echo $finalizado['descripcion_laboral2']; ?></td>		    	
					</tr>
          <tr>
						<td class="left"><?php echo $finalizado->descripcion_visita2; ?></td>		    	
					</tr>
          <tr>
						<td class="left"><?php echo $finalizado['descripcion_visita1']; ?></td>		    	
					</tr>
          <tr>
						<td class="left"><?php echo $finalizado->conclusion_investigacion; ?></td>		    	
					</tr>
				</table>
			</div><br>
		<?php 
		}
		//* Documentos
    $pagebreak = 0;
    if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 19){
          if($pagebreak == 0){ 
            echo '<pagebreak>';
            $pagebreak = 1;
          } ?>
          <div class="center sin-flotar margen-top">
            <p class="f-20">Fotos </p><br>
          </div>
					<div class="center">
          <?php 
          echo '<img class="foto" src="'.base_url().'_docs/'.$doc['archivo'].'">';
          ?>
					</div>
		<?php 
        }
      }
		} 
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 46){ ?>
          <pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Reporte de INFONAVIT </p>
					</div>
					<div class="center">
						<?php 
            echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750">';
						?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 32){ ?>
          <pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Ubicación del domicilio </p>
						<?php 
						if($info['pais'] == 'México' || $info['pais'] == '' || $info['pais'] == NULL){ ?>
							<p class="center"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior'].', '.$info['colonia'].' '.$info['cp'].', '.$info->municipio.', '.$info['estado']; ?></p>
						<?php 
						}
						else{ ?>
							<p class="center"><?php echo $domicilio_internacional; ?></p>
						<?php 
						} ?>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="800" height="500"><br><br>'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 11){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">OFAC </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750"><br><br>'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 8){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Aviso de privacidad </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750">'; ?>
					</div>
				<?php
				}
			}
			//* Anexos
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 9){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Comprobante de historial laboral </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 13){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Carta laboral </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 23){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Evidencia de correo </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 24){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Evidencia de chat </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
		}
	}
	?>
	
<!-- Tipo PDF 16 -->

<!-- Tipo PDF 15 -->
  <?php 
	if($secciones['tipo_pdf'] == 15){ 
    //* Datos Generales 
    ?>
    <p class="center f-18">Personal Data </p>
    <div class="div_datos">
      <table class="">
        <tr>
          <td class="w-20 encabezado">Name:</td>
          <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
        </tr>
      </table>
    </div>
    <?php
    //* Documentacion
    if($secciones['id_seccion_verificacion_docs'] == 87 && $verDoc != null){ ?>
		  <p class="center f-18">Documents</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-30 encabezado">Document</th>
            <th class="w-40 encabezado">Number</th>
            <th class="w-30 encabezado">Date/Institution</th>
          </tr>
          <tr>
            <td class="encabezado center">Non-criminal background letter</td>
            <td class="center"><?php echo $verDoc['penales']; ?></td>
            <td class="center"><?php echo $verDoc['penales_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comments</td>
            <td class="center" colspan="2"><?php echo $verDoc['comentarios']; ?></td>
          </tr>
        </table>
      </div>
    <?php
    }
    //* Global searches
    if($secciones['id_seccion_global_search'] == 65 && $secciones['id_seccion_global_search'] != null){ ?>
			<p class="center f-18">Global Searches</p>
      <div class="div_datos">
        <table class="">
          <tr>
			    	<td class="encabezado left">OIG</td>
			    	<td class="center"><?php echo $global_searches['oig']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">SAM</td>
			    	<td class="center"><?php echo $global_searches['sam'] ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">OFAC</td>
			    	<td class="center"><?php echo $global_searches['ofac']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">FDA Department Search</td>
			    	<td class="center"><?php echo $global_searches['interpol']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><?php echo $global_searches['global_comentarios']; ?></td>
			  	</tr>
        </table>
      </div>
    <?php
    }
    //* Documentos
    if($docs){
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Privacy Notice </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 12){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Criminal Records </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 11){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OFAC </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 17){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OIG </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 21){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>SAM </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 18){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Global Search Check </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 42){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Sex Offender </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
    }
  }
	?>
	
<!-- Tipo PDF 15 -->

<!-- Tipo PDF 14 -->
  <?php 
	if($secciones['tipo_pdf'] == 14){ 
    //* Datos Generales 
    if($secciones['id_seccion_datos_generales'] == 82){ ?>
      <p class="center f-18">Personal Data </p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 encabezado">Name:</td>
            <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Date of birth:</td>
            <td class="center"><?php echo $fecha_nacimiento; ?></td>
            <td class="encabezado">Age:</td>
            <td class="center"><?php echo $info['edad'] ?></td>
            <td class="encabezado w-17">Job Position Requested:</td>
            <td class="center"><?php echo $info['puesto']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Nationality:</td>
            <td class="center"><?php echo $info['nacionalidad']; ?></td>
            <td class="encabezado">Gender:</td>
            <td class="center"><?php echo $genero_ingles; ?></td>
            <td class="encabezado">Marital Status:</td>
            <td class="center"><?php echo $estado_civil_ingles; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Address:</td>
            <td class="center"><?php echo $info['calle']; ?></td>
            <td class="encabezado">Ext. Num:</td>
            <td class="center"><?php echo $info['exterior']; ?></td>
            <td class="encabezado">Int. Num:</td>
            <?php $interior = ($info['interior'] != null && $info['interior'] != '')? $info['interior'] : 'Not provided'; ?>
            <td class="center"><?php echo $interior; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Neighborhood:</td>
            <td class="center"><?php echo $info['colonia'] ?></td>
            <td class="encabezado">State:</td>
            <td class="center"><?php echo $info['estado']; ?></td>
            <td class="encabezado">City:</td>
            <td class="center"><?php echo$info['municipio']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Zip Code:</td>
            <td class="center"><?php echo $info['cp']; ?></td>
            <td class="encabezado">Mobile Num:</td>
            <td class="center"><?php echo $info['celular']; ?></td>
            <td class="encabezado">Home Num:</td>
            <?php $telefono_casa = ($info['telefono_casa'] != null && $info['telefono_casa'] != '')? $info['telefono_casa'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_casa; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Number to leave Messages:</td>
            <?php $telefono_otro = ($info['telefono_otro'] != null && $info['telefono_otro'] != '')? $info['telefono_otro'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_otro; ?></td>
            <td class="encabezado">E-mail:</td>
            <td class="center" colspan="3"><?php echo $info['correo']; ?></td>
          </tr>
        </table>
      </div>
    <?php  
    }
    if($secciones['id_seccion_datos_generales'] == 83){ ?>
      <p class="center f-18">Personal Data </p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 encabezado">Name:</td>
            <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Date of birth:</td>
            <td class="center"><?php echo $fecha_nacimiento; ?></td>
            <td class="encabezado">Age:</td>
            <td class="center"><?php echo $info['edad'] ?></td>
            <td class="encabezado w-17">Job Position Requested:</td>
            <td class="center"><?php echo $info['puesto']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Nationality:</td>
            <td class="center"><?php echo $info['nacionalidad']; ?></td>
            <td class="encabezado">Gender:</td>
            <td class="center"><?php echo $genero_ingles; ?></td>
            <td class="encabezado">Marital Status:</td>
            <td class="center"><?php echo $estado_civil_ingles; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Address:</td>
            <td class="center" colspan="5"><?php echo $info['domicilio_internacional']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Mobile Num:</td>
            <td class="center"><?php echo $info['celular']; ?></td>
            <td class="encabezado">Home Num:</td>
            <?php $telefono_casa = ($info['telefono_casa'] != null && $info['telefono_casa'] != '')? $info['telefono_casa'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_casa; ?></td>
            <td class="encabezado">Number to leave Messages:</td>
            <?php $telefono_otro = ($info['telefono_otro'] != null && $info['telefono_otro'] != '')? $info['telefono_otro'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_otro; ?></td>
          </tr>
          <tr>
            <td class="encabezado">E-mail:</td>
            <td class="center" colspan="5"><?php echo $info['correo']; ?></td>
          </tr>
        </table>
      </div>
    <?php  
    }
    //* Documentacion
    if($secciones['id_seccion_verificacion_docs'] == 48 && $verDoc != null){ ?>
		  <p class="center f-18">Documents</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-30 encabezado">Document</th>
            <th class="w-40 encabezado">Number</th>
            <th class="w-30 encabezado">Date/Institution</th>
          </tr>
          <tr>
            <td class="encabezado center">School Certificate / Professional License</td>
            <td class="center"><?php echo $verDoc['licencia'] ?></td>
            <td class="center"><?php echo $verDoc['licencia_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">ID</td>
            <?php $ine_completo = "ID:<br>".$verDoc['ine']."<br>Register Date:<br>".$verDoc['ine_ano'].''; ?>
            <td class="center"><?php echo $ine_completo; ?></td>
            <td class="center"><?php echo $verDoc['ine_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Passport</td>
            <td class="center"><?php echo $verDoc['pasaporte'] ?></td>
            <td class="center"><?php echo $verDoc['pasaporte_fecha']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Non-criminal background letter</td>
            <td class="center"><?php echo $verDoc['penales']; ?></td>
            <td class="center"><?php echo $verDoc['penales_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Migration Form</td>
            <td class="center"><?php echo $verDoc['forma_migratoria']; ?></td>
            <td class="center"><?php echo $verDoc['forma_migratoria_fecha']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comments</td>
            <td class="center" colspan="2"><?php echo $verDoc['comentarios']; ?></td>
          </tr>
        </table>
      </div>
      <pagebreak>
    <?php
    }
    //* Estudios
    if($secciones['id_estudios'] == 29 && $academico != null){ ?>
		  <p class="center f-18">Studies Record</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-10 encabezado">Level</th>
            <th class="w-15 encabezado">Period</th>
            <th class="w-20 encabezado">Institute</th>
            <th class="w-20 encabezado">City</th>
            <th class="w-20 encabezado">Certificate Obtained</th>
            <th class="w-15 encabezado">Validated</th>
          </tr>
          <tr>
            <td class="encabezado center">Elementary School</td>
            <td class="center"><?php echo $academico['primaria_periodo']; ?></td>
            <td class="center"><?php echo $academico['primaria_escuela']; ?></td>
            <td class="center"><?php echo $academico['primaria_ciudad']; ?></td>
            <td class="center"><?php echo $academico['primaria_certificado']; ?></td>
            <td class="center"><?php echo $valid = ($academico->primaria_validada == 1)?'Yes':'No'; ?></td>
          </tr>
          <?php 
          if($academico['secundaria_periodo'] != null && $academico['secundaria_periodo'] != ''){ ?>
            <tr>
              <td class="encabezado center">Middle School</td>
              <td class="center"><?php echo $academico['secundaria_periodo']; ?></td>
              <td class="center"><?php echo $academico['secundaria_escuela']; ?></td>
              <td class="center"><?php echo $academico['secundaria_ciudad']; ?></td>
              <td class="center"><?php echo $academico['secundaria_certificado']; ?></td>
              <td class="center"><?php echo $valid = ($academico->secundaria_validada == 1)?'Yes':'No'; ?></td>
            </tr>
          <?php 
          }
          if($academico['preparatoria_periodo'] != null && $academico['preparatoria_periodo'] != ''){ ?>
            <tr>
              <td class="encabezado center">High School</td>
              <td class="center"><?php echo $academico['preparatoria_periodo']; ?></td>
              <td class="center"><?php echo $academico['preparatoria_escuela']; ?></td>
              <td class="center"><?php echo $academico['preparatoria_ciudad']; ?></td>
              <td class="center"><?php echo $academico['preparatoria_certificado']; ?></td>
              <td class="center"><?php echo $valid = ($academico->preparatoria_validada == 1)?'Yes':'No'; ?></td>
            </tr>
          <?php 
          }
          if($academico['licenciatura_periodo'] != null && $academico['licenciatura_periodo'] != ''){ ?>
            <tr>
              <td class="encabezado center">College</td>
              <td class="center"><?php echo $academico['licenciatura_periodo']; ?></td>
              <td class="center"><?php echo $academico['licenciatura_escuela']; ?></td>
              <td class="center"><?php echo $academico['licenciatura_ciudad']; ?></td>
              <td class="center"><?php echo $academico['licenciatura_certificado']; ?></td>
              <td class="center"><?php echo $valid = ($academico->licenciatura_validada == 1)?'Yes':'No'; ?></td>
            </tr>
          <?php 
          } ?>
          <tr>
            <td class="encabezado center" colspan="6"><b>Seminaries/Courses Certificates:</b></td>
          </tr>
          <tr>
            <td class="left" colspan="6"><?php echo $academico['otros_certificados']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comments</td>
            <td class="center" colspan="5"><?php echo $academico['comentarios']; ?></td>
          </tr>
        </table>
      </div><br>
		  <p class="center f-18">Break(s) in Studies</p>
      <div class="center">
        <textarea class="comentario" rows="3"><?php echo $academico['carrera_inactivo']; ?></textarea>
      </div><br>
      <div class="div_datos">
        <p class="center f-18">School Document Verification</p>
        <table class="">
          <tr>
            <td class="encabezado center">Studies verification requested</td>
            <td class="center"><?php echo $fecha_alta; ?></td>
            <td class="center" rowspan="2"><?php echo $verificacionEstudios->status; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Verification completed</td>
            <td class="center"><?php echo $fechaVerificacionEstudios = fechaPorIdioma($verificacionEstudios->edicion, 'ingles'); ?></td>
          </tr>
        </table>
      </div><br>
      <div class="div_datos">
        <table>
          <?php 
          if($verificacionDetallesEstudios){
            foreach($verificacionDetallesEstudios as $row){
              $fecha_detalle = fechaPorIdioma($row['fecha'], 'ingles');
              echo '<tr>';
              echo '<td class="center w-17">'.$fecha_detalle.'</td>';
              echo '<td class="center">'.$row->comentarios.'</td>';
              echo '</tr>';
            }
          } ?>
        </table>
      </div>
      <pagebreak>
    <?php
    }
    //* Laborales
    if($secciones['id_empleos'] == 16 || $secciones['id_empleos'] == 59 && $empleos != NULL){ 
			$cont = 1;
			foreach($empleos as $ref){
				$ver_laboral = $this->candidato_laboral_model->getVerificacionLaboralByNumber($cont, $info['id']); ?>
				<p class="center f-18">Employment History </p>
				<div class="div_datos">
					<table class="">
            <tr>
              <th class="encabezado"></th>
              <th class="encabezado">Candidate</th>
              <th class="encabezado">Company</th>
              <th class="encabezado">Notes</th>
            </tr>
            <tr>
              <td class="encabezado center">Company</td>
              <td class="center"><?php echo $ref['empresa']; ?></td>
              <td class="center"><?php echo $vivienda['empresa'] ?></td>
              <td class="left w-30" rowspan="12"><?php echo $vivienda['notas']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Address</td>
              <td class="center"><?php echo $ref['direccion'];?></td>
              <td class="center"><?php echo $ver_laboral['direccion']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Entry Date</td>
              <td class="center"><?php echo $ref['fecha_entrada_txt']; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_entrada_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Exit Date</td>
              <td class="center"><?php echo $ref->fecha_salida_txt; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_salida_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Phone</td>
              <td class="center"><?php echo $ref['telefono']; ?></td>
              <td class="center"><?php echo $ver_laboral['telefono']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Initial Job Position</td>
              <td class="center"><?php echo $ref['puesto1']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto1']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Last Job Position</td>
              <td class="center"><?php echo $ref['puesto2']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto2']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Immediate Boss</td>
              <?php  
              $jefe_nombre = ($ref['jefe_nombre'] != null)? $ref['jefe_nombre'] : 'Not provided'; 
              $jefe_correo = ($ref['jefe_correo'] != null)? $ref['jefe_correo'] : 'Not provided'; ?>
              <td class="center"><?php echo $jefe_nombre."<br>".$jefe_correo; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_nombre']."<br>".$ver_laboral['jefe_correo']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Boss’s Job Position</td>
              <td class="center"><?php echo $ref['jefe_puesto']; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_puesto']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Cause of Separation</td>
              <td class="center"><?php echo $ref->causa_separacion; ?></td>
              <td class="center"><?php echo $ver_laboral['causa_separacion']; ?></td>
            </tr>
					</table>
				</div><br>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<td class="encabezado w-60">Did the candidate sue the company:</td>
					    	<td class="center"><?php echo $demanda = ($ver_laboral->demanda == 1)?'Yes':'No'; ?></td>
					  	</tr>
					</table>
				</div><br>
				<p class="f-14 center">Candidate Performance<br>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<th class="encabezado w-60">Area</th>
					    	<th class="encabezado">Calification</th>
					  	</tr>
					  	<?php 
					  	if($ver_laboral->responsabilidad == "Not provided" && $ver_laboral->iniciativa == "Not provided" && $ver_laboral->eficiencia == "Not provided" && $ver_laboral->disciplina == "Not provided" && $ver_laboral->puntualidad == "Not provided" && $ver_laboral->limpieza == "Not provided" && $ver_laboral->estabilidad == "Not provided" && $ver_laboral->emocional == "Not provided" && $ver_laboral->honestidad == "Not provided" && $ver_laboral->rendimiento == "Not provided" && $ver_laboral->actitud == "Not provided"){
					  		echo '<tr>
					  				<td class="encabezado center">Responsability</td>
					    			<td class="center" rowspan="11">Not provided</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Initiative</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Work efficiency</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Discipline</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Punctuality and assistance</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Cleanliness and order</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Stability</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Emotional Stability</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Honesty</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Performance</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
				  				</tr>';
					  	}
					  	else{
					  		if($ver_laboral->responsabilidad == "Excellent" && $ver_laboral->iniciativa == "Excellent" && $ver_laboral->eficiencia == "Excellent" && $ver_laboral->disciplina == "Excellent" && $ver_laboral->puntualidad == "Excellent" && $ver_laboral->limpieza == "Excellent" && $ver_laboral->estabilidad == "Excellent" && $ver_laboral->emocional == "Excellent" && $ver_laboral->honestidad == "Excellent" && $ver_laboral->rendimiento == "Excellent" && $ver_laboral->actitud == "Excellent"){
						  		echo '<tr>
						  				<td class="encabezado center">Responsability</td>
						    			<td class="center" rowspan="11">Excellent</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Initiative</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Work efficiency</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Discipline</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Punctuality and assistance</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Cleanliness and order</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Stability</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Emotional Stability</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Honesty</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Performance</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
					  				</tr>';
						  	}
						  	else{
						  		if($ver_laboral->responsabilidad == "Good" && $ver_laboral->iniciativa == "Good" && $ver_laboral->eficiencia == "Good" && $ver_laboral->disciplina == "Good" && $ver_laboral->puntualidad == "Good" && $ver_laboral->limpieza == "Good" && $ver_laboral->estabilidad == "Good" && $ver_laboral->emocional == "Good" && $ver_laboral->honestidad == "Good" && $ver_laboral->rendimiento == "Good" && $ver_laboral->actitud == "Good"){
							  		echo '<tr>
							  				<td class="encabezado center">Responsability</td>
							    			<td class="center" rowspan="11">Good</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Initiative</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Work efficiency</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Discipline</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Punctuality and assistance</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Cleanliness and order</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Stability</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Emotional Stability</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Honesty</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Performance</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
						  				</tr>';
							  	}
							  	else{
							  		if($ver_laboral->responsabilidad == "Regular" && $ver_laboral->iniciativa == "Regular" && $ver_laboral->eficiencia == "Regular" && $ver_laboral->disciplina == "Regular" && $ver_laboral->puntualidad == "Regular" && $ver_laboral->limpieza == "Regular" && $ver_laboral->estabilidad == "Regular" && $ver_laboral->emocional == "Regular" && $ver_laboral->honestidad == "Regular" && $ver_laboral->rendimiento == "Regular" && $ver_laboral->actitud == "Regular"){
								  		echo '<tr>
								  				<td class="encabezado center">Responsability</td>
								    			<td class="center" rowspan="11">Regular</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Initiative</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Work efficiency</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Discipline</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Punctuality and assistance</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Cleanliness and order</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Stability</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Emotional Stability</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Honesty</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Performance</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
							  				</tr>';
								  	}
								  	else{
								  		if($ver_laboral->responsabilidad == "Bad" && $ver_laboral->iniciativa == "Bad" && $ver_laboral->eficiencia == "Bad" && $ver_laboral->disciplina == "Bad" && $ver_laboral->puntualidad == "Bad" && $ver_laboral->limpieza == "Bad" && $ver_laboral->estabilidad == "Bad" && $ver_laboral->emocional == "Bad" && $ver_laboral->honestidad == "Bad" && $ver_laboral->rendimiento == "Bad" && $ver_laboral->actitud == "Bad"){
									  		echo '<tr>
									  				<td class="encabezado center">Responsability</td>
									    			<td class="center" rowspan="11">Bad</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Initiative</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Work efficiency</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Discipline</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Punctuality and assistance</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Cleanliness and order</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Stability</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Emotional Stability</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Honesty</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Performance</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
								  				</tr>';
									  	}
									  	else{
									  		if($ver_laboral->responsabilidad == "Very Bad" && $ver_laboral->iniciativa == "Very Bad" && $ver_laboral->eficiencia == "Very Bad" && $ver_laboral->disciplina == "Very Bad" && $ver_laboral->puntualidad == "Very Bad" && $ver_laboral->limpieza == "Very Bad" && $ver_laboral->estabilidad == "Very Bad" && $ver_laboral->emocional == "Very Bad" && $ver_laboral->honestidad == "Very Bad" && $ver_laboral->rendimiento == "Very Bad" && $ver_laboral->actitud == "Very Bad"){
										  		echo '<tr>
										  				<td class="encabezado center">Responsability</td>
										    			<td class="center" rowspan="11">Very Bad</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Initiative</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Work efficiency</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Discipline</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Punctuality and assistance</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Cleanliness and order</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Stability</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Emotional Stability</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Honesty</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Performance</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
									  				</tr>';
										  	}
										  	else{
										  		echo '<tr>
										  				<td class="encabezado center">Responsability</td>
										    			<td class="center">'.$ver_laboral->responsabilidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Initiative</td>
										  				<td class="center">'.$ver_laboral->iniciativa.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Work efficiency</td>
										  				<td class="center">'.$ver_laboral->eficiencia.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Discipline</td>
										  				<td class="center">'.$ver_laboral->disciplina.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Punctuality and assistance</td>
										  				<td class="center">'.$ver_laboral->puntualidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Cleanliness and order</td>
										  				<td class="center">'.$ver_laboral->limpieza.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Stability</td>
										  				<td class="center">'.$ver_laboral->estabilidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Emotional Stability</td>
										  				<td class="center">'.$ver_laboral->emocional.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Honesty</td>
										  				<td class="center">'.$ver_laboral->honestidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Performance</td>
										  				<td class="center">'.$ver_laboral->rendimiento.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
										  				<td class="center">'.$ver_laboral->actitud.'</td>
									  				</tr>';
										  	}
									  	}
								  	}
							  	}
						  	}
					  	}
					  	?>
					</table>
				</div>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<td class="encabezado w-60">In case of vacancy would you hire her/him again?</td>
                <?php 
                if($ver_laboral->recontratacion == 0){
                  $recontratacion ='No';
                }
                if($ver_laboral->recontratacion == 2){
                  $recontratacion ='N/A';
                }
                if($ver_laboral->recontratacion == 1){
                  $recontratacion ='Yes';
                } ?>
					    	<td class="center"><?php echo $recontratacion; ?></td>
					  	</tr>
					  	<tr>
					    	<td class="encabezado w-60">Why?</td>
					    	<td class="center"><?php echo $ver_laboral->motivo_recontratacion; ?></td>
					  	</tr>
					</table>
				</div>
        <pagebreak>
				<?php
				$cont++;
      } ?>

      <p class="center f-18">Break(s) in Employment</p>
      <div class="center">
        <textarea class="comentario" rows="3"><?php echo $info->trabajo_inactivo; ?></textarea>
      </div><br>
      <div class="center">
        <p class="center f-18">Has he worked in any government entity, Politic Party or NGO?</p>
      </div>
      <div class="center">
        <textarea class="comentario" rows="3"><?php echo $info['trabajo_gobierno'] ; ?></textarea>
      </div>
      <div class="div_datos">
        <p class="center f-18">Employment history verification</p>
        <table class="">
          <tr>
            <td class="encabezado center">Labor verification requested</td>
            <td class="center"><?php echo $fecha_alta; ?></td>
            <!--td class="center" rowspan="2"><?php //echo $verificacionEmpleos->status; ?></!--td-->
          </tr>
          <tr>
            <td class="encabezado center">Verification completed</td>
            <td class="center"><?php echo $fechaVerificacionEmpleos = fechaPorIdioma($verificacionEmpleos['edicion'] , 'ingles'); ?></td>
          </tr>
        </table>
      </div><br>
      <div class="div_datos">
        <table>
          <?php 
          if($verificacionDetallesEmpleos){
            foreach($verificacionDetallesEmpleos as $row){
              $fecha_detalle = fechaPorIdioma($row['fecha'], 'ingles');
              echo '<tr>';
              echo '<td class="center w-17">'.$fecha_detalle.'</p></td>';
              echo '<td class="center">'.$row->comentarios.'</p></td>';
              echo '</tr>';
            }
          }
          ?>
        </table>
      </div><br>
      <pagebreak>

      <?php
		}
    //* Referencias personales
    if($secciones['cantidad_ref_personales']> 0 && $secciones['id_ref_personales'] == 31 && $refPersonal != null){ ?>
      <p class="center f-18">Personal References</p>
      <div class="div_datos">
        <?php $salida2 = '';
        foreach($refPersonal as $refper){
          if($refper['sabe_trabajo'] == 0 || $refper['sabe_vive'] == 0){
            $sabe_trabajo = "No";
            $sabe_vive = "No";
          }
          if($refper['sabe_trabajo'] == 1 || $refper['sabe_vive'] == 1){
            $sabe_trabajo = "Yes";
            $sabe_vive = "Yes";
          }
          if($refper['sabe_trabajo'] == 2 || $refper['sabe_vive'] == 2){
            $sabe_trabajo = "NA";
            $sabe_vive = "NA";
          }
          $salida2 .= '<table class=""><tr>';
          $salida2 .= '<td class="w-30 encabezado left">Name</td>';
          $salida2 .= '<td class="w-30 center">'.$refper['nombre'].'</td>';
          $salida2 .= '<td class="w-20 encabezado left">Phone</td>';
          $salida2 .= '<td class="w-20 center">'.$refper['telefono'].'</td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">Time to know her/him</td>';
          $salida2 .= '<td class="center">'.$refper['tiempo_conocerlo'].'</td>';
          $salida2 .= '<td class="encabezado left">Why do you know her/him</td>';
          $salida2 .= '<td class="center">'.$refper['donde_conocerlo'].'</td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">Does she/he know where the candidate works/worked?</td>';
          $salida2 .= '<td class="center">'.$sabe_trabajo.'</td>';
          $salida2 .= '<td class="encabezado left">Does she/he know where the candidate lives?</td>';
          $salida2 .= '<td class="center">'.$sabe_vive.'</td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">Does she/he recommend to candidate?</td>';
          $salida2 .= '<td class="center">'.$recomienda = ($refper['recomienda'] == 1)? "Yes, she/he does" : "No, she/he does not".'</td>';
          $salida2 .= '<td class="encabezado left"></td>';
          $salida2 .= '<td class="center"></td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">Comentario</td>';
          $salida2 .= '<td class="center" colspan="3">'.$refper['comentario'].'</td>';
          $salida2 .= '</tr></table><br>';
        }
        echo $salida2;
        ?>		  	
      </div><br>
      <pagebreak>
    <?php 
    }
    //* Global searches
    if($secciones['id_seccion_global_search'] == 86 && $secciones['id_seccion_global_search'] != null){ ?>
			<p class="center f-18">Global Searches</p>
      <div class="div_datos">
        <table class="">
          <tr>
			    	<td class="w-20 encabezado left">Global compliance & Sanctions database</td>
			    	<td class="w-80 center"><?php echo $global_searches['sanctions']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">Global media searches</td>
			    	<td class="center"><?php echo $global_searches['media_searches']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">OIG</td>
			    	<td class="center"><?php echo $global_searches['oig']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">SAM</td>
			    	<td class="center"><?php echo $global_searches['sam'] ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">OFAC</td>
			    	<td class="center"><?php echo $global_searches['ofac']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado left">INTERPOL</td>
			    	<td class="center"><?php echo $global_searches['interpol']; ?></td>
			  	</tr>
          <tr>
			    	<td class="encabezado left">MVR</td>
			    	<td class="center"><?php echo $global_searches['motor_vehicle_records']; ?></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><?php echo $global_searches['global_comentarios']; ?></td>
			  	</tr>
        </table>
      </div>
    <?php
    }
    
    //* Documentos
    if($docs){
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Privacy Notice </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 3){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>ID </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 12){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Criminal Records </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 11){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OFAC </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 17){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OIG </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 21){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>SAM </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 29){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>INTERPOL </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 44){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Motor Vehicle Records </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 18){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Global Search Check </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 42){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Sex Offender </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 7){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Studies Certificate </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 10){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Professional Licence </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 9){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Employment History (SSN) </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 13){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Employment Letter </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
		foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 37){
							echo '<pagebreak>';
							echo '<div class="center">';
							echo '<h2>Driver licence </h2>';
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
							echo '</div>';
						}
					}
    }
  }
	?>
<!-- Tipo PDF 14 -->


<!-- Tipo PDF 13 -->
  <?php 
	if($secciones['tipo_pdf'] == 13){
		//* Datos Generales
		//TODO: Checar como integrar el tipo sanguineo dentro de los procesos
		if($secciones['id_seccion_datos_generales'] != NULL){
			if($secciones['id_seccion_datos_generales'] == 50 && $info['edad']!= null){ ?>
				<div class="div_datos">
					<p class="center f-18">Datos Personales</p>
					<table class="">
							<tr>
								<td class="encabezado">Nombre del aspirante:</td>
								<td class="center" colspan="5"><p class="f-12"><?php echo $info['candidato']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Puesto que solicita:</td>
								<td class="center"><p class="f-12"><?php echo $info['puestoSeleccionado']; ?></p></td>
								<td class="encabezado w-17">Fecha de Nacimiento:</td>
								<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
								<td class="encabezado">Lugar de Nacimiento:</td>
								<td class="center"><p class="f-12"><?php echo $info['lugar_nacimiento']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Edad:</td>
								<td class="center"><p class="f-12"><?php echo $info['edad'] ?></p></td>
								<td class="encabezado">Género:</td>
								<td class="center"><p class="f-12"><?php echo $info['genero']; ?></p></td>
								<td class="encabezado">Estado civil:</td>
								<td class="center"><p class="f-12"><?php echo $info['estado_civil']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Domicilio (calle, número exterior e interior):</td>
								<td class="center"><p class="f-12"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior']; ?></p></td>
								<td class="encabezado">Entre la calle de:</td>
								<td class="center"><p class="f-12"><?php echo $entre = ($info['entre_calles'] == "")? "No proporciona":$info['entre_calles']; ?></p></td>
								<td class="encabezado">Colonia:</td>
								<td class="center"><p class="f-12"><?php echo $info['colonia'] ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Ciudad:</td>
								<td class="center"><p class="f-12"><?php echo$info['municipio']; ?></p></td>
								<td class="encabezado">Estado:</td>
								<td class="center"><p class="f-12"><?php echo $info['estado']; ?></p></td>
								<td class="encabezado">Código postal:</td>
								<td class="center"><p class="f-12"><?php echo $info['cp']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Grado máximo de estudios:</td>
								<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
								<td class="encabezado">Teléfono local:</td>
								<td class="center"><p class="f-12"><?php echo $tel_casa = ($info['telefono_casa'] == "")? "No proporciona":$info['telefono_casa']; ?></p></td>
								<td class="encabezado">Teléfono celular:</td>
								<td class="center"><p class="f-12"><?php echo $info['celular']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Correo:</td>
								<td class="center"><p class="f-12"><?php echo $correo = ($info['correo']= "")? "No proporciona":$info['correo']; ?></p></td>
								<?php 
								if($info['tipo_sanguineo'] != NULL && $info['tipo_sanguineo'] != ''){ ?>
									<td class="encabezado">Tipo sanguíneo:</td>
									<td class="center"><p class="f-12"><?php echo $info['tipo_sanguineo']; ?></p></td>
								<?php 
								} ?>
							</tr>
					</table>
				</div>
			<?php 
			} 
			if($secciones['id_seccion_datos_generales'] == 51 && $info['edad']!= null){ ?>
				<div class="div_datos">
					<p class="center f-18">Datos Personales</p>
					<table class="">
						<tr>
							<td class="encabezado">Nombre del aspirante:</td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $info['candidato']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Puesto que solicita:</td>
							<td class="center"><p class="f-12"><?php echo $info['puestoSeleccionado']; ?></p></td>
							<td class="encabezado w-17">Fecha de Nacimiento:</td>
							<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
							<td class="encabezado">Lugar de Nacimiento:</td>
							<td class="center"><p class="f-12"><?php echo $info['lugar_nacimiento']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Edad:</td>
							<td class="center"><p class="f-12"><?php echo $info['edad'] ?></p></td>
							<td class="encabezado">Sexo:</td>
							<td class="center"><p class="f-12"><?php echo $info['genero']; ?></p></td>
							<td class="encabezado">Estado civil:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado_civil']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">País donde reside:</td>
							<td class="center" colspan="2"><p class="f-12"><?php echo $info['pais']; ?></p></td>
							<td class="encabezado">Domicilio:</td>
							<td class="center" colspan="2"><p class="f-12"><?php echo $info['domicilio_internacional']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Grado máximo de estudios:</td>
							<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
							<td class="encabezado">Teléfono local:</td>
							<td class="center"><p class="f-12"><?php echo $tel_casa = ($info['telefono_casa'] == "")? "No proporciona":$info['telefono_casa']; ?></p></td>
							<td class="encabezado">Teléfono celular:</td>
							<td class="center"><p class="f-12"><?php echo $info['celular']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Correo:</td>
							<td class="center"><p class="f-12"><?php echo $correo = ($info['correo']= "")? "No proporciona":$info['correo']; ?></p></td>
							<?php 
							if($info['tipo_sanguineo'] != NULL && $info['tipo_sanguineo'] != ''){ ?>
								<td class="encabezado">Tipo sanguíneo:</td>
								<td class="center"><p class="f-12"><?php echo $info['tipo_sanguineo']; ?></p></td>
							<?php 
							} ?>
						</tr>
					</table>
				</div>
			<?php 
			}
		} 
		else{ ?>
			<div class="div_datos">
				<p class="center f-18">Datos Personales</p>
				<table class="">
					<tr>
						<td class="encabezado">Nombre del aspirante:</td>
						<td class="center" colspan="5"><p class="f-12"><?php echo $info['candidato']; ?></p></td>
					</tr>
				</table>
			</div><br><br>
		<?php
		} 
		//* Documentacion
		if($secciones['id_seccion_verificacion_docs'] != NULL){ 
			if($secciones['id_seccion_verificacion_docs'] == 57 && $info['acta'] != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Documentos Comprobatorios</p>
					<table class="">
						<tr>
							<th class="encabezado">CONCEPTO</th>
							<th class="encabezado">NÚMERO Y/O VIGENCIA</th>
							<th class="encabezado">FECHA DE EXPEDICIÓN</th>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Acta de nacimiento</p></td>
							<td class="center"><p class="f-12"><?php echo $info['acta']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $fecha_acta; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Comprobante de domicilio</p></td>
							<td class="center"><p class="f-12"><?php echo $info['cuenta_domicilio']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $fecha_domicilio; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Credencial de elector</p></td>
							<td class="center"><p class="f-12"><?php echo $info['ine']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $emision_ine = ($info['emision_ine'] == "")? "No proporciona":$info['emision_ine']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">CURP</p></td>
							<td class="center"><p class="f-12"><?php echo $info['curp']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $emision_curp; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Afiliación al IMSS</p></td>
							<td class="center"><p class="f-12"><?php echo $nss = ($info['nss'] == "")? "No proporciona":$info['nss']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $emision_nss; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Comprobante retención de impuestos</p></td>
							<td class="center"><p class="f-12"><?php echo $retencion_impuestos = ($info['retencion_impuestos'] == "")? "No proporciona" : $info['retencion_impuestos']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $fecha_retencion_impuestos; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">RFC</p></td>
							<td class="center"><p class="f-12"><?php echo $info['rfc']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $emision_rfc; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Licencia para conducir</p></td>
							<td class="center"><p class="f-12"><?php echo $licencia = ($info['licencia'] == "")? "No proporciona":$info['licencia']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $fecha_licencia; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Vigencia migratoria (extranjeros)</p></td>
							<td class="center"><p class="f-12"><?php echo $vigencia_migratoria; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $numero_migratorio = ($info['numero_migratorio'] == "")? "No proporciona" : $info['numero_migratorio']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">VISA Norteamericana</p></td>
							<td class="center"><p class="f-12"><?php echo $visa = ($info['visa'] == "")? "No proporciona":$info['visa']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $fecha_visa; ?></p></td>
						</tr>
					</table>
				</div>
				<pagebreak>
			<?php 
			}
		}
		//* Social
		if($secciones['lleva_sociales'] == 1){
			if($secciones['id_seccion_social'] == 53 && $sociales != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Antecedentes Sociales</p>
					<table class="">
						<tr>
							<td class="encabezado">¿Perteneció algún puesto sindical? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['sindical']  == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado">¿A cuál? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['sindical_nombre']; ?></p></td>
							<td class="encabezado">¿Cargo? </td>
							<td class="center" colspan="3"><p class="f-12"><?php echo $sociales[0]['sindical_cargo'] ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">¿Pertenece algún partido político? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['partido'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado">¿A cuál? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['partido_nombre']; ?></p></td>
							<td class="encabezado">¿Cargo? </td>
							<td class="center" colspan="3"><p class="f-12"><?php echo $sociales[0]['partido_cargo']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">¿Pertenece algún club deportivo? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['club'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado">¿Qué deporte practica? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['deporte']; ?></p></td>
							<td class="encabezado">¿Qué religión profesa?  </td>
							<td class="center"><p class="f-12"><?php echo $secciones['religion']; ?></p></td>
							<td class="encabezado">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $secciones['religion_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">¿Ingiere bebidas alcohólicas? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($secciones['bebidas'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado">¿Con qué frecuencia? </td>
							<td class="center"><p class="f-12"><?php echo $secciones['bebidas_frecuencia']; ?></p></td>
							<td class="encabezado">¿Acostumbra fumar?  </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['fumar'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['fumar_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">¿Ha tenido alguna intervención quirúrgica? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['cirugia']; ?></p></td>
							<td class="encabezado">¿Antecedentes de enfermedades en su familia directa? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['enfermedades']; ?></p></td>
							<td class="encabezado">¿Cuáles son sus planes a corto plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['corto_plazo']; ?></p></td>
							<td class="encabezado">¿Cuáles son sus planes a mediano plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['mediano_plazo']; ?></p></td>
						</tr>
					</table>
				</div>
			<?php 
			}
		} 
		//* Familiar
		if($secciones['lleva_familiares'] == 1 && $familia){ ?>
			<div class="div_datos">
				<p class="center f-18">Datos del Grupo Familiar</p>
				<table class="">
					<tr>
						<th class="encabezado">NOMBRE</th>
						<th class="encabezado">PARENTESCO</th>
						<th class="encabezado">EDAD</th>
						<th class="encabezado">ESTADO CIVIL</th>
						<th class="encabezado">ESCOLARIDAD</th>
						<th class="encabezado">VIVE CON USTED</th>
					</tr>
					<?php $salida = '';
					if($familia){
						foreach($familia as $f){
							$salida .= '<tr>';
							$salida .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['parentesco'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['edad'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['estado_civil'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['escolaridad'].'</p></td>';
							$salida .= ($f['misma_vivienda'] == 1) ? '<td class="center"><p class="f-12">Sí</p></td>' : '<td class="center"><p class="f-12">No</p></td>';
							$salida .= '</tr>';
						}
					}
					else{
						$salida2 .= '<tr>';
						$salida2 .= '<td class="center" colspan="6"><p class="f-12">El candidato vive solo</p></td>';
						$salida2 .= '</tr>';
					}
					echo $salida;
					?>
				</table>
			</div><br>
			<div class="div_datos">
				<p class="center f-18">Antecedentes Laborales del Grupo Familiar</p>
				<table class="">
					<tr>
						<th class="encabezado">NOMBRE</th>
						<th class="encabezado">EMPRESA</th>
						<th class="encabezado">PUESTO</th>
						<th class="encabezado">ANTIGÜEDAD</th>
					</tr>
					<?php $salida = '';
					if($familia){
						foreach($familia as $f){
							$salida .= '<tr>';
							$salida .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['empresa'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['puesto'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['antiguedad'].'</p></td>';
							$salida .= '</tr>';
						}
					}
					else{
						$salida2 .= '<tr>';
						$salida2 .= '<td class="center" colspan="4"><p class="f-12">El candidato vive solo</p></td>';
						$salida2 .= '</tr>';
					}
					echo $salida;
					?>
				</table>
			</div><br>
      <pagebreak>
		  <?php 
		}
		//* Finanzas
		if($secciones['lleva_familiares'] == 1 && $secciones['lleva_egresos']== 1 && $secciones['id_finanzas'] == 36 && $familia){ ?>
			<div class="div_datos">
				<p class="center f-18">Situación Económica</p>
				<table class="">
					<tr>
						<th class="encabezado" colspan="3">INGRESOS MENSUALES</th>
					</tr>
					<tr>
						<th class="encabezado">NOMBRE</th>
						<th class="encabezado">SUELDO</th>
						<th class="encabezado">APORTACIÓN</th>
					</tr>
					<?php $salida2 = '';
					if($familia){
						foreach($familia as $f){
							$salida2 .= '<tr>';
							$salida2 .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
							$salida2 .= '<td class="center"><p class="f-12">'.$f['sueldo'].'</p></td>';
							$salida2 .= '<td class="center"><p class="f-12">'.$f['monto_aporta'].'</p></td>';
							$salida2 .= '</tr>';
						}
					}
					else{
						$salida2 .= '<tr>';
						$salida2 .= '<td class="center" colspan="3"><p class="f-12">El candidato vive solo</p></td>';
						$salida2 .= '</tr>';
					}
					echo $salida2;
					?>
				</table>
				<table class="">
					<tr>
						<th class="encabezado" colspan="2">EGRESOS MENSUALES</th>
					</tr>
					<tr>
						<th class="encabezado w-25">CONCEPTOS</th>
						<th class="encabezado">MONTOS</th>
					</tr>
					<tr>
						<td class="encabezado w-40">Renta </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['renta']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">Alimentos </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['alimentos']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">Servicios </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['servicios']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">Transporte </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['transporte']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">Otros </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['otros']; ?></p></td>
						<?php $total = $finanzas['renta'] + $finanzas['alimentos'] + $finanzas['servicios'] + $finanzas['transporte'] + $finanzas['otros']; ?>
					</tr>
					<tr>
						<td class="encabezado w-40">Total </td>
						<td class="encabezado"><p class="f-12"><?php echo "$ ".$total; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">¿Cuándo los egresos son mayores a los ingresos, cómo los solventa? </td>
						<td class="center"><p class="f-12"><?php echo $finanzas['solvencia']; ?></p></td>
					</tr>
				</table>
			</div><br>	
		<?php 
		}
    //* Brinco de hoja en caso de exceder numero de familiares
    if($numFamiliares >= 6){
      echo '<pagebreak>';
    }
		//* Bienes
		if($secciones['lleva_familiares'] == 1 && $secciones['id_finanzas'] == 36 && $familia){ ?>
			<div class="div_datos">
				<p class="center f-18">Bienes Inmuebles</p>
				<table class="">
					<tr>
						<th class="encabezado">NOMBRE DEL PROPIETARIO</th>
						<th class="encabezado">MUEBLES E INMUEBLES</th>
						<th class="encabezado">ADEUDO</th>
					</tr>
					<?php 
					if($familia){
						$salida3 = '';
						foreach($familia as $f){
							$salida3 .= '<tr>';
							$salida3 .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
							$salida3 .= '<td class="center"><p class="f-12">'.$f['muebles'].'</p></td>';
							$salida3 .= '<td class="center"><p class="f-12">'.$res = ($f['adeudo'] == 1)? "Sí":"No".'</p></td>';
							$salida3 .= '</tr>';
						}
						if($info['muebles'] != null && $info['muebles'] != ""){
							$salida3 .= '<tr>';
							$salida3 .= '<td class="center"><p class="f-12">'.$info['candidato'].'</p></td>';
							$salida3 .= '<td class="center"><p class="f-12">'.$info['muebles'].'</p></td>';
							$salida3 .= '<td class="center"><p class="f-12">'.$res = ($info['adeudo_muebles']== 1)? "Sí":"No".'</p></td>';
						}
					}
					else{
						if($info['muebles'] != null && $info['muebles'] != ""){
							$salida3 .= '<tr>';
							$salida3 .= '<td class="center"><p class="f-12">'.$info['candidato'].'</p></td>';
							$salida3 .= '<td class="center"><p class="f-12">'.$info['muebles'].'</p></td>';
							$salida3 .= '<td class="center"><p class="f-12">'.$res = ($info['adeudo_muebles']== 1)? "Sí":"No".'</p></td>';
						}
					}
					echo $salida3;
					?>
				</table>
			</div><br>
		<?php 
		}
    //* Brinco de hoja en caso de exceder numero de familiares
    if($numFamiliares >= 5){
      echo '<pagebreak>';
    }
		//* Vivienda
		if($secciones['lleva_vivienda'] == 1 && $vivienda != null){  ?>
			<div class="div_datos">
				<p class="center f-18">Habitación y Medio Ambiente</p>
				<table class="">
					<tr>
						<td class="encabezado center w-40"><p class="f-12">TIEMPO DE RESIDENCIA EN EL DOMICILIO ACTUAL</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['tiempo_residencia']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">NIVEL DE ZONA</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['zona']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">TIPO DE VIVIENDA</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['vivienda']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">RECÁMARAS</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['recamaras']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">BAÑOS</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['banios']; ?></p></td>		  
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">DISTRIBUCIÓN</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['distribucion']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">EL MOBILIARIO ES</p></td>
						<?php
						if($vivienda['calidad_mobiliario'] == 1){
							$calidad = "Buena";
						}
						if($vivienda['calidad_mobiliario'] == 2){
							$calidad = "Regular";
						}
						if($vivienda['calidad_mobiliario'] == 3){
							$calidad = "Mala";
						}
						?>
						<td class="center"><p class="f-12"><?php echo $calidad; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">EL MOBILIARIO ESTÁ</p></td>
						<td class="center"><p class="f-12"><?php echo $res = ($vivienda['mobiliario'] == 1)? "Completo":"Incompleto"; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">LA VIVIENDA ES</p></td>
						<?php
						if($vivienda['tamanio_vivienda'] == 1){
							$tamano = "Amplia";
						}
						if($vivienda['tamanio_vivienda'] == 2){
							$tamano = "Media";
						}
						if($vivienda['tamanio_vivienda'] == 3){
							$tamano = "Reducida";
						}
						?>
						<td class="center"><p class="f-12"><?php echo $tamano; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">CONDICIONES</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['condiciones']; ?></p></td>
					</tr>
				</table>
			</div><br>
      <pagebreak>
		<?php 
		}
		//* Referencias vecinales
		if($secciones['cantidad_ref_vecinales'] > 0 && $refVecinal){
			if($refVecinal){ ?>
				<div class="div_datos">
					<p class="center f-18">Referencias Vecinales</p>
					<?php $salida4 = '';
					foreach($refVecinal as $refvec){
						$salida4 .= '<table class=""><tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">Nombre</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['nombre'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">Domicilio y Teléfono</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['domicilio'].' / '.$refvec['telefono'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Qué concepto tiene del aspirante?</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['concepto_candidato'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿En qué concepto tiene a la familia como vecinos?</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['concepto_familia'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Conoce el estado civil del aspirante? ¿Cuál es?</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['civil_candidato'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Tiene hijos?</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['hijos_candidato'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Sabe en dónde trabaja? </p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['sabe_trabaja'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">Notas</p></td>';
						$salida4 .= '<td class="encabezado"><p class="f-12">'.$refvec['notas'].'</p></td>';
						$salida4 .= '</tr></table><br>';
					}
					echo $salida4;
					?>		  	
				</div><br>
				<pagebreak>
			<?php 
			}
			else{
				$salida4 = '';
				$salida4 .= '<div class="div_datos">';
				$salida4 .= '<p class="center f-18">Referencias Vecinales</p>;';
				$salida4 .= '<table class=""><tr>';
				$salida4 .= '<td class="center"><p class="f-12">No posee referencias vecinales</p></td>';
				$salida4 .= '</tr></table><br><br>';
				$salida4 .= '</div><br>';
				echo $salida4;
			}
		}
		//* Investigación legal
		if($secciones['lleva_investigacion'] == 1 && $legal){ ?>
			<div class="div_datos">
				<p class="center f-18">Investigación Legal</p>
				<table class="">
					<tr>
						<td class="center w-20">Penal </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['penal']; ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['penal_notas']; ?></p></td>		    	
					</tr>
				</table><br><br>
				<table class="">
					<tr>
						<td class="center w-20">Civil </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['civil'];?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['civil_notas']; ?></p></td>		    	
					</tr>
				</table><br><br>
				<table class="">
					<tr>
						<td class="center w-20">Laboral </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['laboral']; ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['laboral_notas']; ?></p></td>		    	
					</tr>
				</table>
			</div><br>
      <pagebreak>
		<?php 
		}
		//* Conclusion
		if($secciones['tipo_conclusion'] == 10 && isset($finalizado)){ ?>
			<div class="div_datos">
				<p class="center f-18">Conclusión</p><br>
				<p class="f-14 center">Personal</p><br>
				<table class="">
					<tr>
						<td class="center"><p class="f-12"><?php echo $finalizado['descripcion_personal1']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado"><p class="f-12"><?php echo $finalizado['descripcion_personal2']; ?></p></td>		    	
					</tr>
				</table><br><br>
				<p class="f-14 center">Laboral</p><br>
				<table class="">
					<tr>
						<td class="encabezado"><p class="f-12"><?php echo $finalizado['descripcion_laboral2']; ?></p></td>		    	
					</tr>
				</table><br><br>
				<p class="f-14 center">Socioeconómica</p><br>
				<table class="">
					<tr>
						<td class="center"><p class="f-12"><?php echo $finalizado['descripcion_socio1']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado"><p class="f-12"><?php echo $finalizado['descripcion_socio2']; ?></p></td>		    	
					</tr>
				</table>
			</div>
			<pagebreak>
		<?php 
		}
		//* Documentos
		if(!empty($docs)){
			$id_tipo_documento_values = array_column($docs, 'id_tipo_documento');

			if($secciones['visita'] != NULL && $docs){ ?>
				<div class="center sin-flotar margen-top">
					<p class="f-20">Fotos </p><br>
				</div>
				<?php 
				echo '<div class="center margen-top">';
				foreach($docs as $doc){
					if($doc['id_tipo_documento'] == 19){
						echo '<img class="foto" src="'.base_url().'_docs/'.$doc['archivo'].'">';
					}
				}
				echo '</div>';
				?>
			<?php 
			} 
			if($secciones['visita'] != NULL){ 
				if (in_array(34, $id_tipo_documento_values) || in_array(39, $id_tipo_documento_values)){
					echo '<pagebreak>';
				}
				foreach($docs as $doc){
					if($doc['id_tipo_documento'] == 34 || $doc['id_tipo_documento'] == 39){ ?>
						<pagebreak>
						<div class="center sin-flotar margen-top">
							<p class="f-20">Foto grupal de los integrantes de la vivienda del candidato </p><br>
						</div>
						<div class="center margen-top">
							<?php 
							if($doc['id_tipo_documento'] == 34){ 
								echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="300" height="600">';
							}
							if($doc['id_tipo_documento'] == 39){ 
								echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="700" height="400">';
							} ?>
						</div>
				<?php
					}
				} 
			}
			if (in_array(35, $id_tipo_documento_values) || in_array(40, $id_tipo_documento_values)){
				echo '<pagebreak>';
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 35 || $doc['id_tipo_documento'] == 40){ ?>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Fotos de vehículos </p>
					</div>
					<div class="center">
						<?php 
						if($doc['id_tipo_documento'] == 35){ 
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="300" height="600">';
						}
						if($doc['id_tipo_documento'] == 40){ 
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="700" height="400">';
						} ?>
					</div>
				<?php
				}
			}
			
			if (in_array(33, $id_tipo_documento_values) || in_array(38, $id_tipo_documento_values)){
				echo '<pagebreak>';
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 33 || $doc['id_tipo_documento'] == 38){ ?>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Fotos de referencias vecinales </p>
					</div>
					<div class="center">
						<?php 
						if($doc['id_tipo_documento'] == 33){ 
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="300" height="600">';
						}
						if($doc['id_tipo_documento'] == 38){ 
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="700" height="400">';
						} ?>
					</div>
				<?php
				}
			}
			
			if (in_array(32, $id_tipo_documento_values)){
				echo '<pagebreak>';
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 32){ ?>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Ubicación del domicilio </p>
						<?php 
						if($info['pais'] == 'México' || $info['pais'] == '' || $info['pais'] == NULL){ ?>
							<p class="center"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior'].', '.$info['colonia'].' '.$info['cp'].', '.$info->municipio.', '.$info['estado']; ?></p>
						<?php 
						}
						else{ ?>
							<p class="center"><?php echo $domicilio_internacional; ?></p>
						<?php 
						} ?>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="800" height="500"><br><br>'; ?>
					</div>
				<?php
				}
			}
			
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 11){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Records criminales – OFAC </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750"><br><br>'; ?>
					</div>
				<?php
					break;
				}
			}
			
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 36){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Comprobante de investigación legal </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="600" height="750"><br><br>'; ?>
					</div>
				<?php
				}
			}
			
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 8){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Aviso de privacidad </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750">'; ?>
					</div>
				<?php
				}
			}
			
			//* Anexos
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 9){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Comprobante de historial laboral </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750">'; ?>
					</div>
				<?php
				}
			}
			
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 13){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Carta laboral </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 23){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Evidencia de correo </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 24){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Evidencia de chat </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 25){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Comprobante de demanda </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 41){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Buró de crédito </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
		}
	}
	?>
	
<!-- Tipo PDF 13 -->


<!-- Tipo PDF 12 -->
  <?php 
	if($secciones['tipo_pdf'] == 12){ 
    //* Datos Generales 
    if($secciones['id_seccion_datos_generales'] == 83){ ?>
      <p class="center f-18">Personal Data </p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 encabezado">Name:</td>
            <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Date of birth:</td>
            <td class="center"><?php echo $fecha_nacimiento; ?></td>
            <td class="encabezado">Age:</td>
            <td class="center"><?php echo $info['edad'] ?></td>
            <td class="encabezado w-17">Job Position Requested:</td>
            <td class="center"><?php echo $info['puesto']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Nationality:</td>
            <td class="center"><?php echo $info['nacionalidad']; ?></td>
            <td class="encabezado">Gender:</td>
            <td class="center"><?php echo $genero_ingles; ?></td>
            <td class="encabezado">Marital Status:</td>
            <td class="center"><?php echo $estado_civil_ingles; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Address:</td>
            <td class="center" colspan="5"><?php echo $info['domicilio_internacional']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Mobile Num:</td>
            <td class="center"><?php echo $info['celular']; ?></td>
            <td class="encabezado">Home Num:</td>
            <?php $telefono_casa = ($info['telefono_casa'] != null && $info['telefono_casa'] != '')? $info['telefono_casa'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_casa; ?></td>
            <td class="encabezado">Number to leave Messages:</td>
            <?php $telefono_otro = ($info['telefono_otro'] != null && $info['telefono_otro'] != '')? $info['telefono_otro'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_otro; ?></td>
          </tr>
          <tr>
            <td class="encabezado">E-mail:</td>
            <td class="center" colspan="5"><?php echo $info['correo']; ?></td>
          </tr>
        </table>
      </div>
    <?php  
    }
    //* Documentacion
    if($secciones['id_seccion_verificacion_docs'] == 58 && $verDoc != null){ ?>
		  <p class="center f-18">Documents</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-30 encabezado">Document</th>
            <th class="w-40 encabezado">Number</th>
            <th class="w-30 encabezado">Date/Institution</th>
          </tr>
          <tr>
            <td class="encabezado center">ID</td>
            <td class="center"><?php echo $verDoc['ine']; ?></td>
            <?php echo $ine_extra = (empty($verDoc['ine_ano']))? $verDoc['ine_institucion'] : $verDoc['ine_ano']; ?>
            <td class="center"><?php echo $ine_extra; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Passport</td>
            <?php echo $pasaporte = ($verDoc['pasaporte'] != null && $verDoc['pasaporte'] != '')? $verDoc['pasaporte'] : 'Not provided'; ?>
            <td class="center"><?php echo $pasaporte; ?></td>
            <?php echo $pasaporte_institucion = ($verDoc['pasaporte_fecha'] != null && $verDoc['pasaporte_fecha'] != '')? $verDoc['pasaporte_fecha'] : 'Not provided'; ?>
            <td class="center"><?php echo $pasaporte_institucion; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Non-criminal background letter</td>
            <td class="center"><?php echo $verDoc['penales']; ?></td>
            <td class="center"><?php echo $verDoc['penales_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Migration document</td>
            <?php echo $forma_migratoria = ($verDoc['forma_migratoria'] != null && $verDoc['forma_migratoria'] != '')? $verDoc['forma_migratoria'] : 'Not provided'; ?>
            <td class="center"><?php echo $pasaporte; ?></td>
            <?php echo $forma_migratoria_institucion = ($verDoc['forma_migratoria_fecha'] != null && $verDoc['forma_migratoria_fecha'] != '')? $verDoc['forma_migratoria_fecha'] : 'Not provided'; ?>
            <td class="center"><?php echo $forma_migratoria_institucion; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comments</td>
            <td class="center" colspan="2"><?php echo $verDoc['comentarios']; ?></td>
          </tr>
        </table>
      </div>
    <?php
    }
    //* Documentos
    if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 11){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OFAC </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="650px" height="750px" >';
					echo '</div>';
				}
        if($doc['id_tipo_documento'] == 12){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Criminal Records </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="650px" height="750px" >';
					echo '</div>';
				}
        if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Privacy Notice </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="650px" height="750px" >';
					echo '</div>';
				}
			}
    }
  }?>
<!-- Fin Tipo PDF 12 -->

<!-- Tipo PDF 11 -->
  <?php 
	if($secciones['tipo_pdf'] == 11){ 
    //* Datos Generales 
    if($secciones['id_seccion_datos_generales'] == 82){ ?>
      <p class="center f-18">Personal Data </p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 encabezado">Name:</td>
            <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Date of birth:</td>
            <td class="center"><?php echo $fecha_nacimiento; ?></td>
            <td class="encabezado">Age:</td>
            <td class="center"><?php echo $info['edad'] ?></td>
            <td class="encabezado w-17">Job Position Requested:</td>
            <td class="center"><?php echo $info['puesto']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Nationality:</td>
            <td class="center"><?php echo $info['nacionalidad']; ?></td>
            <td class="encabezado">Gender:</td>
            <td class="center"><?php echo $genero_ingles; ?></td>
            <td class="encabezado">Marital Status:</td>
            <td class="center"><?php echo $estado_civil_ingles; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Address:</td>
            <td class="center"><?php echo $info['calle']; ?></td>
            <td class="encabezado">Ext. Num:</td>
            <td class="center"><?php echo $info['exterior']; ?></td>
            <td class="encabezado">Int. Num:</td>
            <?php $interior = ($info['interior'] != null && $info['interior'] != '')? $info['interior'] : 'Not provided'; ?>
            <td class="center"><?php echo $interior; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Neighborhood:</td>
            <td class="center"><?php echo $info['colonia'] ?></td>
            <td class="encabezado">State:</td>
            <td class="center"><?php echo $info['estado']; ?></td>
            <td class="encabezado">City:</td>
            <td class="center"><?php echo$info['municipio']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Zip Code:</td>
            <td class="center"><?php echo $info['cp']; ?></td>
            <td class="encabezado">Mobile Num:</td>
            <td class="center"><?php echo $info['celular']; ?></td>
            <td class="encabezado">Home Num:</td>
            <?php $telefono_casa = ($info['telefono_casa'] != null && $info['telefono_casa'] != '')? $info['telefono_casa'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_casa; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Number to leave Messages:</td>
            <?php $telefono_otro = ($info['telefono_otro'] != null && $info['telefono_otro'] != '')? $info['telefono_otro'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_otro; ?></td>
            <td class="encabezado">E-mail:</td>
            <td class="center" colspan="3"><?php echo $info['correo']; ?></td>
          </tr>
        </table>
      </div>
    <?php  
    }
    if($secciones['id_seccion_datos_generales'] == 83){ ?>
      <p class="center f-18">Personal Data </p>
      <div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 encabezado">Name:</td>
            <td class="w-80 center" colspan="5"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Date of birth:</td>
            <td class="center"><?php echo $fecha_nacimiento; ?></td>
            <td class="encabezado">Age:</td>
            <td class="center"><?php echo $info['edad'] ?></td>
            <td class="encabezado w-17">Job Position Requested:</td>
            <td class="center"><?php echo $info['puesto']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Nationality:</td>
            <td class="center"><?php echo $info['nacionalidad']; ?></td>
            <td class="encabezado">Gender:</td>
            <td class="center"><?php echo $genero_ingles; ?></td>
            <td class="encabezado">Marital Status:</td>
            <td class="center"><?php echo $estado_civil_ingles; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Address:</td>
            <td class="center" colspan="5"><?php echo $info['domicilio_internacional']; ?></td>
          </tr>
          <tr>
            <td class="encabezado">Mobile Num:</td>
            <td class="center"><?php echo $info['celular']; ?></td>
            <td class="encabezado">Home Num:</td>
            <?php $telefono_casa = ($info['telefono_casa'] != null && $info['telefono_casa'] != '')? $info['telefono_casa'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_casa; ?></td>
            <td class="encabezado">Number to leave Messages:</td>
            <?php $telefono_otro = ($info['telefono_otro'] != null && $info['telefono_otro'] != '')? $info['telefono_otro'] : 'Not provided'; ?>
            <td class="center"><?php echo $telefono_otro; ?></td>
          </tr>
          <tr>
            <td class="encabezado">E-mail:</td>
            <td class="center" colspan="5"><?php echo $info['correo']; ?></td>
          </tr>
        </table>
      </div>
    <?php  
    }
    //* Documentacion
    if($secciones['id_seccion_verificacion_docs'] == 80 && $verDoc != null){ ?>
		  <p class="center f-18">Documents</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-30 encabezado">Document</th>
            <th class="w-40 encabezado">Number</th>
            <th class="w-30 encabezado">Date/Institution</th>
          </tr>
          <tr>
            <td class="encabezado center">School Certificate / Professional License</td>
            <td class="center"><?php echo $verDoc['licencia'] ?></td>
            <td class="center"><?php echo $verDoc['licencia_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">ID</td>
            <td class="center"><?php echo $verDoc['ine']; ?></td>
            <td class="center"><?php echo $verDoc['ine_ano']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Non-criminal background letter</td>
            <td class="center"><?php echo $verDoc['penales']; ?></td>
            <td class="center"><?php echo $verDoc['penales_institucion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comments</td>
            <td class="center" colspan="2"><?php echo $verDoc['comentarios']; ?></td>
          </tr>
        </table>
      </div>
    <?php
    }
    //* Grupo familiar
    if($secciones['lleva_familiares'] == 1 && $familia){ ?>
			<p class="center f-18">Family Environment</p>
			<div class="div_datos">
				<table class="">
					<tr>
						<th class="w-15 encabezado">Relationship</th>
						<th class="w-25 encabezado">Name</th>
            <th class="w-10 encabezado">Age</th>
						<th class="w-20 encabezado">Ocupation</th>
						<th class="w-20 encabezado">Company/School</th>
						<th class="w-10 encabezado">Live with her/him</th>
					</tr>
					<?php 
					if($familia){
						foreach($familia as $f){  ?>
              <tr>
                <?php $parentesco = nombreFamiliarIngles($f['parentesco']); ?>
                <td class="center f-12"><?php echo $parentesco ?></td>
                <td class="center f-12"><?php echo $f['nombre'] ?></td>
                <td class="center f-12"><?php echo $f['edad'] ?></td>
                <td class="center f-12"><?php echo $f['puesto'] ?></td>
                <td class="center f-12"><?php echo $f['empresa'] ?></td>
                <?php $misma_vivienda = ($f['misma_vivienda'] == 1) ? 'Yes' : 'No'; ?>
                <td class="center f-12"><?php echo $misma_vivienda ?></td>
              </tr>
            <?php
						}
					}
					else{ ?>
						<tr>
						<td class="center" colspan="6"><p class="f-12">Not provided</p></td>
						</tr>
          <?php
					}
					?>
				</table>
			</div>
      <pagebreak>
		<?php
		}
    //* Estudios
    if($secciones['id_estudios'] == 29 && $academico != null){ ?>
		  <p class="center f-18">Studies Record</p>
      <div class="div_datos">
        <table class="">
          <tr>
            <th class="w-10 encabezado">Level</th>
            <th class="w-15 encabezado">Period</th>
            <th class="w-20 encabezado">Institute</th>
            <th class="w-20 encabezado">City</th>
            <th class="w-20 encabezado">Certificate Obtained</th>
            <th class="w-15 encabezado">Validated</th>
          </tr>
          <tr>
            <td class="encabezado center">Elementary School</td>
            <td class="center"><?php echo $academico['primaria_periodo']; ?></td>
            <td class="center"><?php echo $academico['primaria_escuela']; ?></td>
            <td class="center"><?php echo $academico['primaria_ciudad']; ?></td>
            <td class="center"><?php echo $academico['primaria_certificado']; ?></td>
            <td class="center"><?php echo $valid = ($academico->primaria_validada == 1)?'Yes':'No'; ?></td>
          </tr>
          <?php 
          if($academico['secundaria_periodo'] != null && $academico['secundaria_periodo'] != ''){ ?>
            <tr>
              <td class="encabezado center">Middle School</td>
              <td class="center"><?php echo $academico['secundaria_periodo']; ?></td>
              <td class="center"><?php echo $academico['secundaria_escuela']; ?></td>
              <td class="center"><?php echo $academico['secundaria_ciudad']; ?></td>
              <td class="center"><?php echo $academico['secundaria_certificado']; ?></td>
              <td class="center"><?php echo $valid = ($academico->secundaria_validada == 1)?'Yes':'No'; ?></td>
            </tr>
          <?php 
          }
          if($academico['preparatoria_periodo'] != null && $academico['preparatoria_periodo'] != ''){ ?>
            <tr>
              <td class="encabezado center">High School</td>
              <td class="center"><?php echo $academico['preparatoria_periodo']; ?></td>
              <td class="center"><?php echo $academico['preparatoria_escuela']; ?></td>
              <td class="center"><?php echo $academico['preparatoria_ciudad']; ?></td>
              <td class="center"><?php echo $academico['preparatoria_certificado']; ?></td>
              <td class="center"><?php echo $valid = ($academico->preparatoria_validada == 1)?'Yes':'No'; ?></td>
            </tr>
          <?php 
          }
          if($academico['licenciatura_periodo'] != null && $academico['licenciatura_periodo'] != ''){ ?>
            <tr>
              <td class="encabezado center">College</td>
              <td class="center"><?php echo $academico['licenciatura_periodo']; ?></td>
              <td class="center"><?php echo $academico['licenciatura_escuela']; ?></td>
              <td class="center"><?php echo $academico['licenciatura_ciudad']; ?></td>
              <td class="center"><?php echo $academico['licenciatura_certificado']; ?></td>
              <td class="center"><?php echo $valid = ($academico->licenciatura_validada == 1)?'Yes':'No'; ?></td>
            </tr>
          <?php 
          } ?>
          <tr>
            <td class="encabezado center" colspan="6"><b>Seminaries/Courses Certificates:</b></td>
          </tr>
          <tr>
            <td class="left" colspan="6"><?php echo $academico['otros_certificados']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Comments</td>
            <td class="center" colspan="5"><?php echo $academico['comentarios']; ?></td>
          </tr>
        </table>
      </div><br>
		  <p class="center f-18">Break(s) in Studies</p>
      <div class="center">
        <textarea class="comentario" rows="3"><?php echo $academico['carrera_inactivo']; ?></textarea>
      </div><br>
      <div class="div_datos">
        <p class="center f-18">School Document Verification</p>
        <table class="">
          <tr>
            <td class="encabezado center">Studies verification requested</td>
            <td class="center"><?php echo $fecha_alta; ?></td>
            <td class="center" rowspan="2"><?php echo $verificacionEstudios->status; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">Verification completed</td>
            <td class="center"><?php echo $fechaVerificacionEstudios = fechaPorIdioma($verificacionEstudios->edicion, 'ingles'); ?></td>
          </tr>
        </table>
      </div><br>
      <div class="div_datos">
        <table>
          <?php 
          if($verificacionDetallesEstudios){
            foreach($verificacionDetallesEstudios as $row){
              $fecha_detalle = fechaPorIdioma($row['fecha'], 'ingles');
              echo '<tr>';
              echo '<td class="center w-17">'.$fecha_detalle.'</td>';
              echo '<td class="center">'.$row->comentarios.'</td>';
              echo '</tr>';
            }
          } ?>
        </table>
      </div>
      <pagebreak>
    <?php
    }
    //* Laborales
    if($secciones['id_empleos'] == 16 && $empleos != NULL){ 
			$cont = 1;
			foreach($empleos as $ref){
				$ver_laboral = $this->candidato_laboral_model->getVerificacionLaboralByNumber($cont, $info['id']); ?>
				<p class="center f-18">Employment History </p>
				<div class="div_datos">
					<table class="">
            <tr>
              <th class="encabezado"></th>
              <th class="encabezado">Candidate</th>
              <th class="encabezado">Company</th>
              <th class="encabezado">Notes</th>
            </tr>
            <tr>
              <td class="encabezado center">Company</td>
              <td class="center"><?php echo $ref['empresa']; ?></td>
              <td class="center"><?php echo $vivienda['empresa'] ?></td>
              <td class="left w-30" rowspan="12"><?php echo $vivienda['notas']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Address</td>
              <td class="center"><?php echo $ref['direccion'];?></td>
              <td class="center"><?php echo $ver_laboral['direccion']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Entry Date</td>
              <td class="center"><?php echo $ref['fecha_entrada_txt']; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_entrada_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Exit Date</td>
              <td class="center"><?php echo $ref->fecha_salida_txt; ?></td>
              <td class="center"><?php echo $ver_laboral['fecha_salida_txt']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Phone</td>
              <td class="center"><?php echo $ref['telefono']; ?></td>
              <td class="center"><?php echo $ver_laboral['telefono']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Initial Job Position</td>
              <td class="center"><?php echo $ref['puesto1']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto1']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Last Job Position</td>
              <td class="center"><?php echo $ref['puesto2']; ?></td>
              <td class="center"><?php echo $ver_laboral['puesto2']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Immediate Boss</td>
              <?php  
              $jefe_nombre = ($ref['jefe_nombre'] != null)? $ref['jefe_nombre'] : 'Not provided'; 
              $jefe_correo = ($ref['jefe_correo'] != null)? $ref['jefe_correo'] : 'Not provided'; ?>
              <td class="center"><?php echo $jefe_nombre."<br>".$jefe_correo; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_nombre']."<br>".$ver_laboral['jefe_correo']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Boss’s Job Position</td>
              <td class="center"><?php echo $ref['jefe_puesto']; ?></td>
              <td class="center"><?php echo $ver_laboral['jefe_puesto']; ?></td>
            </tr>
            <tr>
              <td class="encabezado center">Cause of Separation</td>
              <td class="center"><?php echo $ref->causa_separacion; ?></td>
              <td class="center"><?php echo $ver_laboral['causa_separacion']; ?></td>
            </tr>
					</table>
				</div><br>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<td class="encabezado w-60">Did the candidate sue the company:</td>
					    	<td class="center"><?php echo $demanda = ($ver_laboral->demanda == 1)?'Yes':'No'; ?></td>
					  	</tr>
					</table>
				</div><br>
				<p class="f-14 center">Candidate Performance<br>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<th class="encabezado w-60">Area</th>
					    	<th class="encabezado">Calification</th>
					  	</tr>
					  	<?php 
					  	if($ver_laboral->responsabilidad == "Not provided" && $ver_laboral->iniciativa == "Not provided" && $ver_laboral->eficiencia == "Not provided" && $ver_laboral->disciplina == "Not provided" && $ver_laboral->puntualidad == "Not provided" && $ver_laboral->limpieza == "Not provided" && $ver_laboral->estabilidad == "Not provided" && $ver_laboral->emocional == "Not provided" && $ver_laboral->honestidad == "Not provided" && $ver_laboral->rendimiento == "Not provided" && $ver_laboral->actitud == "Not provided"){
					  		echo '<tr>
					  				<td class="encabezado center">Responsability</td>
					    			<td class="center" rowspan="11">Not provided</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Initiative</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Work efficiency</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Discipline</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Punctuality and assistance</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Cleanliness and order</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Stability</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Emotional Stability</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Honesty</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Performance</td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
				  				</tr>';
					  	}
					  	else{
					  		if($ver_laboral->responsabilidad == "Excellent" && $ver_laboral->iniciativa == "Excellent" && $ver_laboral->eficiencia == "Excellent" && $ver_laboral->disciplina == "Excellent" && $ver_laboral->puntualidad == "Excellent" && $ver_laboral->limpieza == "Excellent" && $ver_laboral->estabilidad == "Excellent" && $ver_laboral->emocional == "Excellent" && $ver_laboral->honestidad == "Excellent" && $ver_laboral->rendimiento == "Excellent" && $ver_laboral->actitud == "Excellent"){
						  		echo '<tr>
						  				<td class="encabezado center">Responsability</td>
						    			<td class="center" rowspan="11">Excellent</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Initiative</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Work efficiency</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Discipline</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Punctuality and assistance</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Cleanliness and order</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Stability</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Emotional Stability</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Honesty</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Performance</td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
					  				</tr>';
						  	}
						  	else{
						  		if($ver_laboral->responsabilidad == "Good" && $ver_laboral->iniciativa == "Good" && $ver_laboral->eficiencia == "Good" && $ver_laboral->disciplina == "Good" && $ver_laboral->puntualidad == "Good" && $ver_laboral->limpieza == "Good" && $ver_laboral->estabilidad == "Good" && $ver_laboral->emocional == "Good" && $ver_laboral->honestidad == "Good" && $ver_laboral->rendimiento == "Good" && $ver_laboral->actitud == "Good"){
							  		echo '<tr>
							  				<td class="encabezado center">Responsability</td>
							    			<td class="center" rowspan="11">Good</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Initiative</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Work efficiency</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Discipline</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Punctuality and assistance</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Cleanliness and order</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Stability</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Emotional Stability</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Honesty</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Performance</td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
						  				</tr>';
							  	}
							  	else{
							  		if($ver_laboral->responsabilidad == "Regular" && $ver_laboral->iniciativa == "Regular" && $ver_laboral->eficiencia == "Regular" && $ver_laboral->disciplina == "Regular" && $ver_laboral->puntualidad == "Regular" && $ver_laboral->limpieza == "Regular" && $ver_laboral->estabilidad == "Regular" && $ver_laboral->emocional == "Regular" && $ver_laboral->honestidad == "Regular" && $ver_laboral->rendimiento == "Regular" && $ver_laboral->actitud == "Regular"){
								  		echo '<tr>
								  				<td class="encabezado center">Responsability</td>
								    			<td class="center" rowspan="11">Regular</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Initiative</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Work efficiency</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Discipline</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Punctuality and assistance</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Cleanliness and order</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Stability</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Emotional Stability</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Honesty</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Performance</td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
							  				</tr>';
								  	}
								  	else{
								  		if($ver_laboral->responsabilidad == "Bad" && $ver_laboral->iniciativa == "Bad" && $ver_laboral->eficiencia == "Bad" && $ver_laboral->disciplina == "Bad" && $ver_laboral->puntualidad == "Bad" && $ver_laboral->limpieza == "Bad" && $ver_laboral->estabilidad == "Bad" && $ver_laboral->emocional == "Bad" && $ver_laboral->honestidad == "Bad" && $ver_laboral->rendimiento == "Bad" && $ver_laboral->actitud == "Bad"){
									  		echo '<tr>
									  				<td class="encabezado center">Responsability</td>
									    			<td class="center" rowspan="11">Bad</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Initiative</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Work efficiency</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Discipline</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Punctuality and assistance</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Cleanliness and order</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Stability</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Emotional Stability</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Honesty</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Performance</td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
								  				</tr>';
									  	}
									  	else{
									  		if($ver_laboral->responsabilidad == "Very Bad" && $ver_laboral->iniciativa == "Very Bad" && $ver_laboral->eficiencia == "Very Bad" && $ver_laboral->disciplina == "Very Bad" && $ver_laboral->puntualidad == "Very Bad" && $ver_laboral->limpieza == "Very Bad" && $ver_laboral->estabilidad == "Very Bad" && $ver_laboral->emocional == "Very Bad" && $ver_laboral->honestidad == "Very Bad" && $ver_laboral->rendimiento == "Very Bad" && $ver_laboral->actitud == "Very Bad"){
										  		echo '<tr>
										  				<td class="encabezado center">Responsability</td>
										    			<td class="center" rowspan="11">Very Bad</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Initiative</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Work efficiency</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Discipline</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Punctuality and assistance</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Cleanliness and order</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Stability</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Emotional Stability</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Honesty</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Performance</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
									  				</tr>';
										  	}
										  	else{
										  		echo '<tr>
										  				<td class="encabezado center">Responsability</td>
										    			<td class="center">'.$ver_laboral->responsabilidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Initiative</td>
										  				<td class="center">'.$ver_laboral->iniciativa.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Work efficiency</td>
										  				<td class="center">'.$ver_laboral->eficiencia.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Discipline</td>
										  				<td class="center">'.$ver_laboral->disciplina.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Punctuality and assistance</td>
										  				<td class="center">'.$ver_laboral->puntualidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Cleanliness and order</td>
										  				<td class="center">'.$ver_laboral->limpieza.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Stability</td>
										  				<td class="center">'.$ver_laboral->estabilidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Emotional Stability</td>
										  				<td class="center">'.$ver_laboral->emocional.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Honesty</td>
										  				<td class="center">'.$ver_laboral->honestidad.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Performance</td>
										  				<td class="center">'.$ver_laboral->rendimiento.'</td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center">Attitude with coworkers, bosses and subordinates</td>
										  				<td class="center">'.$ver_laboral->actitud.'</td>
									  				</tr>';
										  	}
									  	}
								  	}
							  	}
						  	}
					  	}
					  	?>
					</table>
				</div>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<td class="encabezado w-60">In case of vacancy would you hire her/him again?</td>
					    	<?php 
                if($ver_laboral->recontratacion == 0){
                  $recontratacion ='No';
                }
                if($ver_laboral->recontratacion == 2){
                  $recontratacion ='N/A';
                }
                if($ver_laboral->recontratacion == 1){
                  $recontratacion ='Yes';
                } ?>
					    	<td class="center"><?php echo $recontratacion; ?></td>
					  	</tr>
					  	<tr>
					    	<td class="encabezado w-60">Why?</td>
					    	<td class="center"><?php echo $ver_laboral->motivo_recontratacion; ?></td>
					  	</tr>
					</table>
				</div>
        <pagebreak>
				<?php
				$cont++;
      } ?>

      <p class="center f-18">Break(s) in Employment</p>
      <div class="center">
        <textarea class="comentario" rows="3"><?php echo $info->trabajo_inactivo; ?></textarea>
      </div><br>
      <div class="center">
        <p class="center f-18">Has he worked in any government entity, Politic Party or NGO?</p>
      </div>
      <div class="center">
        <textarea class="comentario" rows="3"><?php echo $info['trabajo_gobierno'] ; ?></textarea>
      </div>
      <div class="div_datos">
        <p class="center f-18">Employment history verification</p>
        <table class="">
          <tr>
            <td class="encabezado center">Labor verification requested</td>
            <td class="center"><?php echo $fecha_alta; ?></td>
            <!--td class="center" rowspan="2"><?php //echo $verificacionEmpleos->status; ?></!--td-->
          </tr>
          <tr>
            <td class="encabezado center">Verification completed</td>
            <td class="center"><?php echo $fechaVerificacionEmpleos = fechaPorIdioma($verificacionEmpleos['edicion'] , 'ingles'); ?></td>
          </tr>
        </table>
      </div><br>
      <div class="div_datos">
        <table>
          <?php 
          if($verificacionDetallesEmpleos){
            foreach($verificacionDetallesEmpleos as $row){
              $fecha_detalle = fechaPorIdioma($row['fecha'], 'ingles');
              echo '<tr>';
              echo '<td class="center w-17">'.$fecha_detalle.'</p></td>';
              echo '<td class="center">'.$row->comentarios.'</p></td>';
              echo '</tr>';
            }
          }
          ?>
        </table>
      </div><br>
      <pagebreak>

      <?php
		}
    //* Referencias personales
    if($secciones['cantidad_ref_personales']> 0 && $secciones['id_ref_personales'] == 31 && $refPersonal != null){ ?>
      <p class="center f-18">Personal References</p>
      <div class="div_datos">
        <?php $salida2 = '';
        foreach($refPersonal as $refper){
          if($refper['sabe_trabajo'] == 0 || $refper['sabe_vive'] == 0){
            $sabe_trabajo = "No";
            $sabe_vive = "No";
          }
          if($refper['sabe_trabajo'] == 1 || $refper['sabe_vive'] == 1){
            $sabe_trabajo = "Yes";
            $sabe_vive = "Yes";
          }
          if($refper['sabe_trabajo'] == 2 || $refper['sabe_vive'] == 2){
            $sabe_trabajo = "NA";
            $sabe_vive = "NA";
          }
          $salida2 .= '<table class=""><tr>';
          $salida2 .= '<td class="w-30 encabezado left">Name</td>';
          $salida2 .= '<td class="w-30 center">'.$refper['nombre'].'</td>';
          $salida2 .= '<td class="w-20 encabezado left">Phone</td>';
          $salida2 .= '<td class="w-20 center">'.$refper['telefono'].'</td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">Time to know her/him</td>';
          $salida2 .= '<td class="center">'.$refper['tiempo_conocerlo'].'</td>';
          $salida2 .= '<td class="encabezado left">Why do you know her/him</td>';
          $salida2 .= '<td class="center">'.$refper['donde_conocerlo'].'</td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">Does she/he know where the candidate works/worked?</td>';
          $salida2 .= '<td class="center">'.$sabe_trabajo.'</td>';
          $salida2 .= '<td class="encabezado left">Does she/he know where the candidate lives?</td>';
          $salida2 .= '<td class="center">'.$sabe_vive.'</td>';
          $salida2 .= '</tr>';
          $salida2 .= '<tr>';
          $salida2 .= '<td class="encabezado left">Comentario</td>';
          $salida2 .= '<td class="center" colspan="3">'.$refper['comentario'].'</td>';
          $salida2 .= '</tr></table><br>';
        }
        echo $salida2;
        ?>		  	
      </div><br>
    <?php 
    }
    //* Documentos
    if($docs){
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Privacy Notice </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="650px" height="750px" >';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 12){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Criminal Records </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="650px" height="550px" >';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 11){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>OFAC </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="650px" height="750px" >';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 18){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Global Search Check </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="650px" height="750px" >';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 7){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Studies Certificate </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="650px" height="750px" >';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 10){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Professional Licence </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="650px" height="750px" >';
					echo '</div>';
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 13){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Employment Letter </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="650px" height="750px" >';
					echo '</div>';
				}
			}
    }
  }?>
<!-- Fin Tipo PDF 11 -->

<!-- Tipo PDF 10 -->
  <?php 
	if($secciones['tipo_pdf'] == 10){ 
    //* Datos Generales 
    ?>
    <p class="center f-18">Personal Data </p>
    <div class="div_datos">
      <table class="">
        <tr>
          <td class="w-20 left encabezado">Fullname:</td>
          <td class="w-80 center" colspan="3"><?php echo $info['candidato']; ?></td>
        </tr>
        <tr>
          <td class="left encabezado">Country:</td>
          <td class="center"><?php echo $info['pais']; ?></td>
          <td class="left encabezado">Mobile Num.:</td>
          <td class="center"><?php echo $info['celular']; ?></td>
        </tr>
        <tr>
          <td class="left encabezado">Email:</td>
          <?php
          $correo = ($info['correo']!= null)? $info['correo']: 'Not provided';  ?>
          <td class="center" colspan="3"><?php echo $info['correo']; ?></td>
        </tr>
      </table><br><br><br>
    </div>
    <?php  
    //* Verificaciones 
    if($pruebas != null){ 
      if($secciones->id_investigacion == 81){ ?>
        <p class="center f-18">OIG Verification </p>
        <div class="div_datos">
          <table class="">
            <tr>
              <td class="w-20 center encabezado">Date:</td>
              <td class="w-80 center encabezado">Final statement:</td>
            </tr>
            <tr>
              <td class="center"><?php echo $fprueba = fechaTexto($pruebas->creacion,'ingles'); ?></td>
		    	    <td class="center"><?php echo $pruebas->oig; ?></td>
            </tr>
          </table>
        </div>
        <br><br><br>
        <p class="center f-18">SAM Verification </p>
        <div class="div_datos">
          <table class="">
            <tr>
              <td class="w-20 center encabezado">Date:</td>
              <td class="w-80 center encabezado">Final statement:</td>
            </tr>
            <tr>
              <td class="center"><?php echo $fprueba = fechaTexto($pruebas->creacion,'ingles'); ?></td>
		    	    <td class="center"><?php echo $pruebas->sam; ?></td>
            </tr>
          </table>
        </div>
        <pagebreak>
      <?php
      }
    } 
    //* Documentos
    if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 17){
					echo '<div class="center">';
					echo '<h2>OIG </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="650px" height="750px" >';
					echo '</div>';
				}
        if($doc['id_tipo_documento'] == 21){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>SAM </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="650px" height="750px" >';
					echo '</div>';
				}
			}
    }
  }?>
<!-- Fin Tipo PDF 10 -->

<!-- Tipo PDF 9  -->
  <?php 
	if($secciones['tipo_pdf'] == 9){ 
    //* Datos Generales
		if($secciones['id_seccion_datos_generales'] == 78){ ?>
      <p class="center f-18">1. Datos generales del candidato </p>
			<div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 left encabezado">Nombre del candidato:</td>
            <td class="w-80 center" colspan="3"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
            <td class="left encabezado">CURP:</td>
            <td class="center"><?php echo $info['curp']; ?></td>
            <td class="left encabezado">NSS:</td>
            <td class="center"><?php echo $info['nss']; ?></td>
          </tr>
          <tr>
            <td class="left encabezado">Puesto:</td>
            <td class="center"><?php echo $info['puestoSeleccionado']; ?></td>
            <td class="left encabezado">Centro de costo:</td>
            <td class="center"><?php echo $info->centro_costo; ?></td>
          </tr>
        </table>
			</div>
      <pagebreak>
    <?php  
    }
    //* Empleos
		if($secciones['lleva_empleos'] == 1){
			if($secciones['id_empleos'] == 77){
				if($empleos){ 
					$cont = 1; ?>
					<div class="div_datos">
						<p class="center f-18">2. Referencias laborales </p>
						<?php
						foreach($empleos as $row){
							$contacto = $this->candidato_laboral_model->getContactoLaboralByNumber($cont, $info['id']); ?>
              <p class="center f-13">Versión del candidato:</p>
							<table class="">
								<tr>
                  <td class="w-10 encabezado left">Empresa:</td>
									<td class="w-80 center"><?php echo strtoupper($row['empresa']); ?></td>
                </tr>
                <tr>
									<td class="encabezado left">Giro:</td>
									<td class="center"><?php echo $row['tipo_empresa']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Dirección:</td>
									<td class="center"><?php echo $row['direccion'] ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Teléfono</td>
									<td class="center"><?php echo $row['telefono']; ?></td>
								</tr>
              </table>
              <table class="">
                <tr>
									<td class="w-20 encabezado left">Puesto inicial</td>
									<td class="w-30 center"><?php echo $row['puesto1']; ?></td>
                  <td class="w-20 encabezado left">Puesto final</td>
									<td class="w-30 center"><?php echo $row['puesto2'];?></td>
								</tr>
                <tr>
									<td class="encabezado left">Sueldo inicial</td>
									<td class="center"><?php echo $row['salario1_txt']; ?></td>
                  <td class="encabezado left">Sueldo final</td>
									<td class="center"><?php echo $row['salario2_txt']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Fecha de ingreso</td>
									<td class="center"><?php echo $row['fecha_entrada_txt']; ?></td>
                  <td class="encabezado left">Fecha de baja</td>
									<td class="center"><?php echo $row['fecha_salida_txt']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Sindicalizado?</td>
									<td class="center"><?php echo $sind = ($row['sindicato_puesto']== 'NA' || $row['sindicato_puesto']== 'N/A' || $row['sindicato_puesto']== 'No tiene' || $row['sindicato_puesto']== 'No aplica' || $row['sindicato_puesto']== 'NO APLICA' || $row['sindicato_puesto']== 'No esta sindicalizado' || $row['sindicato_puesto']== 'No tiene sindicato' || $row['sindicato_puesto']== 'Sin sindicato')? 'Sí':'No' ; ?></td>
                  <td class="encabezado left">Puesto en Sindicato</td>
									<td class="center"><?php echo $row['sindicato_puesto']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Motivo de baja</td>
									<td class="center"><?php echo $row['causa_separacion']; ?></td>
                  <td class="encabezado left">Especificar</td>
									<td class="center"><?php echo $row->detalle_separacion; ?></td>
								</tr>
                <tr>
									<td class="encabezado center" colspan="4">¿Le gustaría trabajar de nuevo en la empresa? ¿Por qué?</td>
								</tr>
                <tr>
									<td class="center" colspan="4"><?php echo $row->reingresar; ?></td>
								</tr>
              </table>
              <p class="center f-13">Informante:
							<table class="">
								<tr>
                  <td class="w-20 encabezado left">Nombre:</td>
									<td class="w-30 center"><?php echo $contacto['nombre']; ?></td>
                  <td class="w-20 encabezado left">Puesto:</td>
									<td class="w-30 center"><?php echo $contacto['puesto']; ?></td>
                </tr>
                <tr>
									<td class="encabezado left">Puesto inicial</td>
									<td class="center"><?php echo $contacto['puesto_inicio'];?></td>
                  <td class="encabezado left">Puesto final</td>
									<td class="center"><?php echo $contacto['puesto_fin']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Sueldo inicial</td>
									<td class="center"><?php echo $contacto['sueldo_inicio']; ?></td>
                  <td class="encabezado left">Sueldo final</td>
									<td class="center"><?php echo $contacto['sueldo_fin']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Fecha de ingreso</td>
									<td class="center"><?php echo $contacto['fecha_entrada'];?></td>
                  <td class="encabezado left">Fecha de baja</td>
									<td class="center"><?php echo $contacto['fecha_salida']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Teléfono</td>
									<td class="center"><?php echo $contacto['telefono']; ?></td>
                  <td class="encabezado left">Correo</td>
									<td class="center"><?php echo $contacto['correo']; ?></td>
								</tr>
              </table>
              <table class="">
                <tr>
									<td class="w-40 encabezado left">Actividades que realizaba:</td>
									<td class="w-60 center"><?php echo $contacto['actividades']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Conocimientos y Habilidades sobresalientes</td>
									<td class="center"><?php echo $contacto['habilidades']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Qué tal hacia su trabajo? (Eficiencia, logros) ¿Presentó bajo desempeño?</td>
									<td class="center"><?php echo $contacto['desempeno']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Presentó ausentismos?</td>
									<td class="center"><?php echo $contacto['ausencia']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Realizó violaciones al reglamento interior de trabajo?</td>
									<td class="center"><?php echo $contacto['cumplimiento']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Presentó incapacidades y/o problemas de salud?</td>
									<td class="center"><?php echo $contacto['salud']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Presentó conflictos con sus jefes? Especifique</td>
									<td class="center"><?php echo $contacto['conflicto']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Motivo de baja</td>
									<td class="center"><?php echo $contacto['causa_separacion']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Le gustaría trabajar de nuevo con el candidato? ¿Por qué?</td>
									<td class="center"><?php echo $contacto['recontratar']; ?></td>
								</tr>
              </table>
              <table>
                <tr>
									<td class="encabezado center">Observaciones</td>
									<td class="left"><?php echo $contacto['observacion']; ?></td>
								</tr>
              </table>
							<pagebreak>
							<?php
							$cont++; 
						} ?>
					</div><br>
				<?php
				}
			}
		}
    //* Documentos
    if($docs){
      //* Semanas cotizadas 
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 9){
					echo '<div class="center">';
					echo '<h2>3. Registro de IMSS </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="650px" height="820px" >';
					echo '</div>';
				}
			}
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 25){
          echo '<pagebreak>';
          echo '<div class="center">';
					echo '<h2>4. Demanda </h2>';
          echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
          echo '</div>';
        }
      }
    }
	}?>
<!-- Fin Tipo PDF 9  -->

<!-- Tipo PDF 8 -->
  <?php 
	if($secciones['tipo_pdf'] == 8){ 
    //* Datos Generales
    //TODO: No entra la seccion en PDF porque no se registra la fecha de nacimiento ni la edad
		if($secciones['id_seccion_datos_generales'] == 78){ ?>
      <p class="center f-18">1. Datos generales del candidato </p>
			<div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 left encabezado">Nombre del candidato:</td>
            <td class="w-80 center" colspan="3"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
            <td class="left encabezado">CURP:</td>
            <td class="center"><?php echo $info['curp']; ?></td>
            <td class="left encabezado">NSS:</td>
            <td class="center"><?php echo $info['nss']; ?></td>
          </tr>
          <tr>
            <td class="left encabezado">Puesto:</td>
            <td class="center"><?php echo $info['puestoSeleccionado']; ?></td>
            <td class="left encabezado">Centro de costo:</td>
            <td class="center"><?php echo $info->centro_costo; ?></td>
          </tr>
        </table>
			</div>
    <?php  
    }
    //* Investigación legal
		if($secciones['lleva_investigacion'] == 1 && $legal){ ?>
			<div class="div_datos">
				<p class="center f-18">2. Demandas</p>
				<table class="">
					<tr>
						<td class="center w-20">Demanda penal </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['penal']; ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['penal_notas']; ?></p></td>		    	
					</tr>
				</table><br>
				<table class="">
					<tr>
						<td class="center w-20">Demanda civil </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['civil'];?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['civil_notas']; ?></p></td>		    	
					</tr>
				</table><br>
				<table class="">
					<tr>
						<td class="center w-20">Demanda laboral </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['laboral']; ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['laboral_notas']; ?></p></td>		    	
					</tr>
				</table>
			</div>
		<?php 
		}
    //* Documentos
    if($docs){
      //* Semanas cotizadas 
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 9){
          echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>3. Registro de IMSS </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 36){
          echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>4. Investigación legal </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 11){
          echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>5. OFAC </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
			foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 25){
          echo '<pagebreak>';
          echo '<div class="center">';
					echo '<h2>6. Demanda </h2>';
          echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
          echo '</div>';
        }
      }
    }
	}?>
<!-- Fin Tipo PDF 8 -->

<!-- Tipo PDF 7 -->
  <?php 
	if($secciones['tipo_pdf'] == 7){ 
    //* Datos Generales
		if($secciones['id_seccion_datos_generales'] == 78){ ?>
      <p class="center f-18">1. Datos generales del candidato </p>
			<div class="div_datos">
        <table class="">
          <tr>
            <td class="w-20 left encabezado">Nombre del candidato:</td>
            <td class="w-80 center" colspan="3"><?php echo $info['candidato']; ?></td>
          </tr>
          <tr>
            <td class="left encabezado">CURP:</td>
            <td class="center"><?php echo $info['curp']; ?></td>
            <td class="left encabezado">NSS:</td>
            <td class="center"><?php echo $info['nss']; ?></td>
          </tr>
          <tr>
            <td class="left encabezado">Puesto:</td>
            <td class="center"><?php echo $info['puestoSeleccionado']; ?></td>
            <td class="left encabezado">Centro de costo:</td>
            <td class="center"><?php echo $info->centro_costo; ?></td>
          </tr>
          <tr>
            <td class="left encabezado">Teléfono:</td>
            <td class="center"><?php echo $info['celular']; ?></td>
            <td></td>
            <td></td>
          </tr>
        </table>
			</div>
    <?php  
    }
    //* Investigación legal
		if($secciones['lleva_investigacion'] == 1 && $legal){ ?>
			<div class="div_datos">
				<p class="center f-18">2. Demandas</p>
				<table class="">
					<tr>
						<td class="center w-20">Demanda penal </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['penal']; ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['penal_notas']; ?></p></td>		    	
					</tr>
				</table><br>
				<table class="">
					<tr>
						<td class="center w-20">Demanda civil </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['civil'];?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['civil_notas']; ?></p></td>		    	
					</tr>
				</table><br>
				<table class="">
					<tr>
						<td class="center w-20">Demanda laboral </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['laboral']; ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['laboral_notas']; ?></p></td>		    	
					</tr>
				</table>
			</div>
      <pagebreak>
		<?php 
		}
    //* Empleos
		if($secciones['lleva_empleos'] == 1){
			if($secciones['id_empleos'] == 77){
				if($empleos){ 
					$cont = 1; ?>
					<div class="div_datos">
						<p class="center f-18">3. Referencias laborales </p>
						<?php
						foreach($empleos as $row){
							$contacto = $this->candidato_laboral_model->getContactoLaboralByNumber($cont, $info['id']); ?>
              <p class="center f-13">Versión del candidato:</p>
							<table class="">
								<tr>
                  <td class="w-10 encabezado left">Empresa:</td>
									<td class="w-80 center"><?php echo strtoupper($row['empresa']); ?></td>
                </tr>
                <tr>
									<td class="encabezado left">Giro:</td>
									<td class="center"><?php echo $row['tipo_empresa']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Dirección:</td>
									<td class="center"><?php echo $row['direccion'] ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Teléfono</td>
									<td class="center"><?php echo $row['telefono']; ?></td>
								</tr>
              </table>
              <table class="">
                <tr>
									<td class="w-20 encabezado left">Puesto inicial</td>
									<td class="w-30 center"><?php echo $row['puesto1']; ?></td>
                  <td class="w-20 encabezado left">Puesto final</td>
									<td class="w-30 center"><?php echo $row['puesto2'];?></td>
								</tr>
                <tr>
									<td class="encabezado left">Sueldo inicial</td>
									<td class="center"><?php echo $row['salario1_txt']; ?></td>
                  <td class="encabezado left">Sueldo final</td>
									<td class="center"><?php echo $row['salario2_txt']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Fecha de ingreso</td>
									<td class="center"><?php echo $row['fecha_entrada_txt']; ?></td>
                  <td class="encabezado left">Fecha de baja</td>
									<td class="center"><?php echo $row['fecha_salida_txt']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Sindicalizado?</td>
									<td class="center"><?php echo $sind = ($row['sindicato_puesto']== 'NA' || $row['sindicato_puesto']== 'N/A' || $row['sindicato_puesto']== 'No tiene' || $row['sindicato_puesto']== 'No aplica' || $row['sindicato_puesto']== 'NO APLICA' || $row['sindicato_puesto']== 'No esta sindicalizado' || $row['sindicato_puesto']== 'No tiene sindicato' || $row['sindicato_puesto']== 'Sin sindicato')? 'Sí':'No' ; ?></td>
                  <td class="encabezado left">Puesto en Sindicato</td>
									<td class="center"><?php echo $row['sindicato_puesto']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Motivo de baja</td>
									<td class="center"><?php echo $row['causa_separacion']; ?></td>
                  <td class="encabezado left">Especificar</td>
									<td class="center"><?php echo $row->detalle_separacion; ?></td>
								</tr>
                <tr>
									<td class="encabezado center" colspan="4">¿Le gustaría trabajar de nuevo en la empresa? ¿Por qué?</td>
								</tr>
                <tr>
									<td class="center" colspan="4"><?php echo $row->reingresar; ?></td>
								</tr>
              </table>
              <p class="center f-13">Informante:
							<table class="">
								<tr>
                  <td class="w-20 encabezado left">Nombre:</td>
									<td class="w-30 center"><?php echo $contacto['nombre']; ?></td>
                  <td class="w-20 encabezado left">Puesto:</td>
									<td class="w-30 center"><?php echo $contacto['puesto']; ?></td>
                </tr>
                <tr>
									<td class="encabezado left">Puesto inicial</td>
									<td class="center"><?php echo $contacto['puesto_inicio'];?></td>
                  <td class="encabezado left">Puesto final</td>
									<td class="center"><?php echo $contacto['puesto_fin']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Sueldo inicial</td>
									<td class="center"><?php echo $contacto['sueldo_inicio']; ?></td>
                  <td class="encabezado left">Sueldo final</td>
									<td class="center"><?php echo $contacto['sueldo_fin']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Fecha de ingreso</td>
									<td class="center"><?php echo $contacto['fecha_entrada'];?></td>
                  <td class="encabezado left">Fecha de baja</td>
									<td class="center"><?php echo $contacto['fecha_salida']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Teléfono</td>
									<td class="center"><?php echo $contacto['telefono']; ?></td>
                  <td class="encabezado left">Correo</td>
									<td class="center"><?php echo $contacto['correo']; ?></td>
								</tr>
              </table>
              <table class="">
                <tr>
									<td class="w-40 encabezado left">Actividades que realizaba:</td>
									<td class="w-60 center"><?php echo $contacto['actividades']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Conocimientos y Habilidades sobresalientes</td>
									<td class="center"><?php echo $contacto['habilidades']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Qué tal hacia su trabajo? (Eficiencia, logros) ¿Presentó bajo desempeño?</td>
									<td class="center"><?php echo $contacto['desempeno']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Presentó ausentismos?</td>
									<td class="center"><?php echo $contacto['ausencia']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Realizó violaciones al reglamento interior de trabajo?</td>
									<td class="center"><?php echo $contacto['cumplimiento']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Presentó incapacidades y/o problemas de salud?</td>
									<td class="center"><?php echo $contacto['salud']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Presentó conflictos con sus jefes? Especifique</td>
									<td class="center"><?php echo $contacto['conflicto']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Motivo de baja</td>
									<td class="center"><?php echo $contacto['causa_separacion']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Le gustaría trabajar de nuevo con el candidato? ¿Por qué?</td>
									<td class="center"><?php echo $contacto['recontratar']; ?></td>
								</tr>
              </table>
              <table>
                <tr>
									<td class="encabezado center">Observaciones</td>
									<td class="left"><?php echo $contacto['observacion']; ?></td>
								</tr>
              </table>
              <pagebreak>
							<?php
							$cont++; 
						} ?>
					</div><br>
				<?php
				}
			}
		}
    //* Documentos
    if($docs){
      $idsArchivos = array();
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 9 || $doc['id_tipo_documento'] == 25 || $doc['id_tipo_documento'] == 13){
          array_push($idsArchivos, $doc['id_tipo_documento']);
        }
      }
      $contadorArchivos = array_count_values($idsArchivos);
      $numeroSemanas = array_key_exists(9,$contadorArchivos)? $contadorArchivos[9] : 0;
      $numeroDemandas = array_key_exists(25,$contadorArchivos)? $contadorArchivos[25] : 0;
      $numeroCartas = array_key_exists(13,$contadorArchivos)? $contadorArchivos[13] : 0;
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 9){
          echo '<div class="center">';
          echo '<h2>4. Registro de IMSS </h2>';
          echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
          echo '</div>';
          if($numeroSemanas > 1){
            echo '<pagebreak>';
            $numeroSemanas--;
          }else{
            if($numeroDemandas >= 1 || $numeroCartas >= 1){
              echo '<pagebreak>';
            }
          }
        }
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 25){
					echo '<div class="center">';
					echo '<h2>5. Demandas </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
          if($numeroDemandas > 1){
            echo '<pagebreak>';
            $numeroDemandas--;
          }else{
            if($numeroCartas >= 1){
              echo '<pagebreak>';
            }
          }
				}
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 13){
					echo '<div class="center">';
					echo '<h2>6. Carta laboral </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
          if($numeroCartas > 1){
            echo '<pagebreak>';
            $numeroCartas--;
          }
				}
			}
    }
	}?>
<!-- Fin Tipo PDF 7 -->

<!-- Tipo PDF 6 -->
  <?php 
	if($secciones['tipo_pdf'] == 6){ 
    //* Conclusion 
    if($finalizado != null && $estatus_final != 'Se define al terminar el estudio'){ ?>
      <div class="w-70 div_datos flotar-izquierda">
        <p class="center f-16"><?php echo $subtituloProceso; ?></p>
        <table class="">
          <tr>
            <td class="encabezado">Nombre</td>
            <td class="center"><p class="f-12"><?php echo $info['candidato']; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado">Puesto</td>
            <td class="center"><p class="f-12"><?php echo $info['puestoSeleccionado']; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado">Conclusión</td>
            <td class="center"><p class="f-12"><?php echo $estatus_final; ?></p></td>
          </tr>
        </table>
      </div>
    <?php 
    }
    //* Se muestra foto imagen de frente del candidato en caso de que exista
    //TODO: Controlar por cliente si se solicitó este aspecto o no mediante BD u otra alternativa
    if($docs){
      $band = 0;
      echo '<div class=" flotar-izquierda right margen-bottom" style="margin-left: 5px;">';
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 22){
          echo '<img width="110" height="120" class="padding" src="'.base_url().'_docs/'.$doc['archivo'].'">';
          break;
        }
      }
      echo '</div>';
    }
		if($secciones['tipo_conclusion'] == 2 && $finalizado != null && $estatus_final != 'Se define al terminar el estudio'){
      $comentario_final = ($finalizado['comentario'] != null && $finalizado['comentario'] != '')? ' <b>'.$finalizado['comentario'].'</b>' : '';  ?>
			<div class="w-80 div_datos" style="border: 1px solid black;padding: 10px;font-size: 14px;">
        <p class="left">Resumen:</p>
        <p class="left"><?php echo $finalizado['descripcion_personal1']; ?></p>
        <p class="left"><?php echo $finalizado['descripcion_personal4']; ?></p>
        <p class="left"><?php echo $finalizado['descripcion_personal2']; ?></p>
        <p class="left"><?php echo $finalizado['descripcion_socio1']; ?></p>
        <p class="left"><?php echo $finalizado['descripcion_socio2']; ?></p>
        <p class="left"><?php echo $finalizado['descripcion_laboral2']; ?></p>
        <p class="left">Con base a lo anterior descrito, el estudio se finaliza con estatus <?php echo $estatus_final.$comentario_final; ?></p>
        <p class="left">NOTA: "Recuerda verificar tu comparativo de sueldo, según las políticas de contratación de PISA"</p>
      </div>
      <pagebreak>

		<?php 
		} 
    //* Comentarios referencias laborales 
    if($secciones['id_empleos'] == 77){
      if($contactos != null){
        $cont_contactos = 0; ?>
        <div class="div_datos">
          <p class="left f-14">Comentarios de referencias laborales:</p>
          <?php 
          foreach($contactos as $contacto){ 
            $cont_contactos++; ?>
            <p class="left f-14"><?php echo '<b>'.$cont_contactos.' '.$contacto->empresa.'</b><br>'. $contacto['observacion']; ?></p>
          <?php 
          } ?>
        </div>
    <?php 
      }
    }
    //* Brinco de hoja en caso de no exceder numero de observaciones de referencias laborales
		if($numObservacionesLaborales >= 5){
			echo '<pagebreak>';
		}	
    //* Datos Generales
		if($secciones['id_seccion_datos_generales'] == 68 && $info['edad']!= null){ ?>
			<div class="div_datos">
        <table class="">
          <tr>
            <td class="encabezado">Nombre del candidato:</td>
            <td class="center" ><p class="f-12"><?php echo $info['candidato']; ?></p></td>
            <td class="encabezado">Fecha entrevista:</td>
          </tr>
          <tr>
            <td class="encabezado">Puesto:</td>
            <td class="center" ><p class="f-12"><?php echo $info['puestoSeleccionado']; ?></p></td>
            <td class="center"><?php echo $info->fecha_entrevista; ?></td>
          </tr>
        </table>
				<p class="center f-18">1. Datos generales del candidato</p>
				<table class="">
						<tr>
              <td class="w-17 left encabezado">Entidad federativa:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado']; ?></p></td>
              <td class="w-17 left encabezado">Edad:</td>
							<td class="center"><p class="f-12"><?php echo $info->edad.' años'; ?></p></td>
						</tr>
						<tr>
              <td class="left encabezado">Domicilio:</td>
							<td class="center"><p class="f-12"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior']; ?></p></td>
							<td class="left encabezado w-17">Fecha de Nacimiento:</td>
							<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
						</tr>
						<tr>
              <td class="left encabezado">Colonia:</td>
              <td class="center"><p class="f-12"><?php echo $info['colonia'] ?></p></td>
              <td class="left encabezado">Originario de:</td>
              <td class="center"><p class="f-12"><?php echo $info['lugar_nacimiento']; ?></p></td>
						</tr>
						<tr>
              <td class="left encabezado">Código postal:</td>
              <td class="center"><p class="f-12"><?php echo $info['cp']; ?></p></td>
              <td class="left encabezado">Estado civil:</td>
              <td class="center"><p class="f-12"><?php echo $info['estado_civil']; ?></p></td>
						</tr>
						<tr>
							<td class="left encabezado">Municipio:</td>
							<td class="center"><p class="f-12"><?php echo$info['municipio']; ?></p></td>
              <td class="left encabezado">Religión:</td>
							<td class="center"><p class="f-12"><?php echo $info->religion; ?></p></td>
						</tr>
						<tr>
							<td class="left encabezado">Teléfono:</td>
							<td class="center"><p class="f-12"><?php echo $tel_casa = ($info['telefono_casa'] == "")? "No proporciona":$info['telefono_casa']; ?></p></td>
              <td class="left encabezado">Tiempo de radicar en la ciudad:</td>
              <td class="center"><p class="f-12"><?php echo $info->tiempo_radica; ?></p></td>
						</tr>
            <tr>
              <td class="left encabezado">Celular:</td>
              <td class="center"><p class="f-12"><?php echo $info['celular']; ?></p></td>
              <td class="left encabezado">Tiempo de habitar en el domicilio:</td>
              <td class="center"><p class="f-12"><?php echo $info['tiempo_dom_actual']; ?></p></td>
						</tr>
            <tr>
              <td class="left encabezado">IMSS:</td>
              <td class="center"><p class="f-12"><?php echo $info['nss']; ?></p></td>
              <td class="left encabezado">AFORE:</td>
              <td class="center"><p class="f-12"><?php echo $info['afore']; ?></p></td>
            </tr>
            <tr>
              <td class="left encabezado">CURP:</td>
              <td class="center"><p class="f-12"><?php echo $info['curp']; ?></p></td>
              <td class="left encabezado">Se identifica con:</td>
              <td class="center"><p class="f-12"><?php echo $info['tipo_identificacion']; ?></p></td>
            </tr>
				</table>
			</div>
    <?php  
    }
    //* Familiar
		if($secciones['lleva_familiares'] == 1 && $familia){
      $salida = ''; $tieneFamiliaOrigen = 0; ?>
			<div class="div_datos">
				<p class="center f-18">2. Composición familiar</p>
        <p class="left f-14">Familia con quien vive</p>
				<table class="">
					<tr>
            <th class="w-10 encabezado">Edad</th>
						<th class="w-20 encabezado">Nombre</th>
						<th class="w-15 encabezado">Parentesco</th>
						<th class="w-15 encabezado">E. Civil</th>
						<th class="w-15 encabezado">Escolaridad</th>
						<th class="w-10 encabezado">Ocupación</th>
						<th class="w-15 encabezado">Empresa/Escuela</th>
					</tr>
					<?php 
					if($familia){
						foreach($familia as $f){
              if($f['misma_vivienda'] == 1){ ?>
               <tr>
               <td class="center f-12"><?php echo $f['edad'] ?></td>
               <td class="center f-12"><?php echo $f['nombre'] ?></td>
               <td class="center f-12"><?php echo $f['parentesco'] ?></td>
               <td class="center f-12"><?php echo $f['estado_civil'] ?></td>
               <td class="center f-12"><?php echo $f['escolaridad'] ?></td>
               <td class="center f-12"><?php echo $f['puesto']?></td>
               <td class="center f-12"><?php echo $f['empresa'] ?></td>
               </tr>
              <?php
              }
						}
					}
					else{
						echo '<tr>';
						echo '<td class="center" colspan="7"><p class="f-12">El candidato vive solo</p></td>';
						echo '</tr>';
					}
					?>
				</table>
        <p class="left f-14">Familia de origen (padres y hermanos)</p>
        <table class="">
					<tr>
            <th class="w-10 encabezado">Edad</th>
						<th class="w-20 encabezado">Nombre</th>
						<th class="w-15 encabezado">Parentesco</th>
						<th class="w-15 encabezado">E. Civil</th>
						<th class="w-15 encabezado">Escolaridad</th>
						<th class="w-10 encabezado">Ocupación</th>
						<th class="w-15 encabezado">Empresa/Escuela</th>
					</tr>
					<?php 
					if($familia){
						foreach($familia as $f){
              if($f->id_tipo_parentesco == 1 || $f->id_tipo_parentesco == 2 || $f->id_tipo_parentesco == 6){ ?>
                <tr>
                <td class="center f-12"><?php echo $f['edad'] ?></td>
                <td class="center f-12"><?php echo $f['nombre'] ?></td>
                <td class="center f-12"><?php echo $f['parentesco'] ?></td>
                <td class="center f-12"><?php echo $f['estado_civil'] ?></td>
                <td class="center f-12"><?php echo $f['escolaridad'] ?></td>
                <td class="center f-12"><?php echo $f['puesto']?></td>
                <td class="center f-12"><?php echo $f['empresa'] ?></td>
                </tr>
              <?php
                $tieneFamiliaOrigen++;
              }
						}
            if($tieneFamiliaOrigen == 0){
              echo '<tr>';
              echo '<td class="center" colspan="7"><p class="f-12">No se proporcionó la familia de origen</p></td>';
              echo '</tr>';
            }
					}
					else{
						echo '<tr>';
						echo '<td class="center" colspan="7"><p class="f-12">El candidato vive solo</p></td>';
						echo '</tr>';
					}
					?>
				</table>
			</div>
		<?php
		} 
    //* Brinco de hoja en caso de exceder numero de integrantes familiares
		if($sumFamiliares >= 3){
			echo '<pagebreak>';
		}	
    //* Estudios
		if($secciones['lleva_estudios'] == 1){
			if($secciones['id_estudios'] == 79 && $academico != null){ ?>
				<div class="div_datos">
					<p class="center f-18">3. Estudios</p>
					<table class="">
            <?php 
            if($academico['primaria_periodo'] != null && $academico['primaria_periodo'] != ''){
              $periodo = explode('-',$academico['primaria_periodo']); ?>
              <tr>
                <td class="encabezado">Primaria/Nombre de la institución</td>
                <td class="encabezado">De</td>
                <td class=""><?php echo $periodo[0]; ?></td>
                <td class="encabezado">Municipio</td>
                <td class="encabezado">Comprobante</td>
              </tr>
              <tr>
                <td class=""><?php echo $academico['primaria_escuela']; ?></td>
                <td class="encabezado">A</td>
                <td class=""><?php echo $periodo[1]; ?></td>
                <td class=""><?php echo $academico['primaria_ciudad']; ?></td>
                <td class=""><?php echo $academico['primaria_certificado']; ?></td>
              </tr>
						<?php 
            }
            if($academico['secundaria_periodo'] != null && $academico['secundaria_periodo'] != ''){
              $periodo = explode('-',$academico['secundaria_periodo']); ?>
              <tr>
                <td class="encabezado">Secundaria/Nombre de la institución</td>
                <td class="encabezado">De</td>
                <td class=""><?php echo $periodo[0]; ?></td>
                <td class="encabezado">Municipio</td>
                <td class="encabezado">Comprobante</td>
              </tr>
              <tr>
                <td class=""><?php echo $academico['secundaria_escuela']; ?></td>
                <td class="encabezado">A</td>
                <td class=""><?php echo $periodo[1]; ?></td>
                <td class=""><?php echo $academico['secundaria_ciudad']; ?></td>
                <td class=""><?php echo $academico['secundaria_certificado']; ?></td>
              </tr>
						<?php 
            }
            if($academico['preparatoria_periodo'] != null && $academico['preparatoria_periodo'] != ''){
              $periodo = explode('-',$academico['preparatoria_periodo']); ?>
              <tr>
                <td class="encabezado">Preparatoria/Nombre de la institución</td>
                <td class="encabezado">De</td>
                <td class=""><?php echo $periodo[0]; ?></td>
                <td class="encabezado">Municipio</td>
                <td class="encabezado">Comprobante</td>
              </tr>
              <tr>
                <td class=""><?php echo $academico['preparatoria_escuela']; ?></td>
                <td class="encabezado">A</td>
                <td class=""><?php echo $periodo[1]; ?></td>
                <td class=""><?php echo $academico['preparatoria_ciudad']; ?></td>
                <td class=""><?php echo $academico['preparatoria_certificado']; ?></td>
              </tr>
						<?php 
            }
            if($academico['licenciatura_periodo'] != null && $academico['licenciatura_periodo'] != ''){
              $periodo = explode('-',$academico['licenciatura_periodo']); ?>
              <tr>
                <td class="encabezado">Licenciatura/Nombre de la institución</td>
                <td class="encabezado">De</td>
                <td class=""><?php echo $periodo[0]; ?></td>
                <td class="encabezado">Municipio</td>
                <td class="encabezado">Comprobante</td>
              </tr>
              <tr>
                <td class=""><?php echo $academico['licenciatura_escuela']; ?></td>
                <td class="encabezado">A</td>
                <td class=""><?php echo $periodo[1]; ?></td>
                <td class=""><?php echo $academico['licenciatura_ciudad']; ?></td>
                <td class=""><?php echo $academico['licenciatura_certificado']; ?></td>
              </tr>
						<?php 
            } ?>
					</table>
				</div>
        <pagebreak>
			<?php 
			}
		} 
    //* Social
		if($secciones['lleva_sociales'] == 1){
			if($secciones['id_seccion_social'] == 69 && $sociales != null){ ?>
				<div class="div_datos">
					<p class="center f-18">4. Antecedentes</p>
					<p class="left f-13">¿Tiene algún familiar con antecedentes penales?</p>
					<table class="">
						<tr>
							<td class="w-5 encabezado">Sí</td>
							<td class="w-5 encabezado">No</td>
							<td class="w-70 encabezado">Nombre</td>
							<td class="w-20 encabezado">Parentesco</p></td>
						</tr>
						<tr>
              <?php 
              echo $marca = ($sociales['tiene_familiar_penal'] == 1)? '<td class="center"><b>X</b></td><td class="center"> </td>': '<td class="center"></td> <td class="center"><b>X</b></td>'; ?>
							<td class="center"><?php echo $sociales['familiar_nombre_penal']; ?></td>
							<td class="center"><?php echo $sociales['familiar_parentesco_penal']; ?></td>
						</tr>
						<tr>
							<td class="encabezado" colspan="2">Motivo</td>
							<td class="center" colspan="2"><?php echo $sociales['familiar_motivo_penal']; ?></td>
						</tr>
					</table>
          <p class="left f-13">¿Tiene algún amigo dentro de la empresa?</p>
					<table class="">
						<tr>
							<td class="w-5 encabezado">Sí</td>
							<td class="w-5 encabezado">No</td>
							<td class="w-70 encabezado">Nombre</td>
							<td class="w-20 encabezado">Puesto</p></td>
						</tr>
						<tr>
              <?php 
              echo $marca = ($sociales['tiene_persona_empresa'] == 1)? '<td class="center"><b>X</b></td><td class="center"> </td>': '<td class="center"></td> <td class="center"><b>X</b></td>'; ?>
							<td class="center"><?php echo $sociales['persona_nombre_empresa']; ?></td>
							<td class="center"><?php echo $sociales['persona_puesto_empresa']; ?></td>
						</tr>
					</table>
          <p class="left f-13">¿Tiene algún familiar laborando dentro de alguna corporación policiaca?</p>
					<table class="">
						<tr>
							<td class="w-5 encabezado">Sí</td>
							<td class="w-5 encabezado">No</td>
							<td class="w-70 encabezado">Nombre</td>
							<td class="w-20 encabezado">Corporación</p></td>
						</tr>
						<tr>
              <?php 
              echo $marca = ($sociales['tiene_familiar_policia'] == 1)? '<td class="center"><b>X</b></td><td class="center"> </td>': '<td class="center"></td> <td class="center"><b>X</b></td>'; ?>
							<td class="center"><?php echo $sociales['familiar_nombre_policia']; ?></td>
							<td class="center"><?php echo $sociales['familiar_corporacion_policia']; ?></td>
						</tr>
					</table>
          <p class="left f-13">¿Ha estado afiliado a algún sindicato?</p>
					<table class="">
						<tr>
							<td class="w-5 encabezado">Sí</td>
							<td class="w-5 encabezado">No</td>
							<td class="w-70 encabezado">Nombre</td>
							<td class="w-20 encabezado">Corporación</p></td>
						</tr>
						<tr>
              <?php 
              echo $marca = ($sociales[0]['sindical'] == 1)? '<td class="center"><b>X</b></td><td class="center"> </td>': '<td class="center"></td> <td class="center"><b>X</b></td>'; ?>
							<td class="center"><?php echo $sociales[0]['sindical_nombre']; ?></td>
							<td class="center"><?php echo $sociales[0]['sindical_corporacion']; ?></td>
						</tr>
            <tr>
							<td class="encabezado" colspan="2">Puesto</td>
							<td class="center" colspan="2"><?php echo $sociales[0]['sindical_cargo'] ?></td>
						</tr>
					</table>
          <p class="left f-13">¿Realiza otra actividad o tiene otro trabajo?</p>
					<table class="">
						<tr>
							<td class="w-10 encabezado">Sí</td>
							<td class="w-10 encabezado">No</td>
							<td class="w-70 encabezado">Empresa</td>
							<td class="w-20 encabezado">Puesto</p></td>
						</tr>
						<tr>
              <?php 
              echo $marca = ($sociales['tiene_otro_trabajo'] == 1)? '<td class="center"><b>X</b></td><td class="center"> </td>': '<td class="center"></td> <td class="center"><b>X</b></td>'; ?>
							<td class="center"><?php echo $sociales['otro_trabajo_empresa']; ?></td>
							<td class="center"><?php echo $sociales['otro_trabajo_puesto']; ?></td>
						</tr>
            <tr>
							<td class="encabezado" colspan="2">Actividades a realizar</td>
							<td class="center" colspan="2"><?php echo $sociales['otro_trabajo_actividades']; ?></td>
						</tr>
          </table>
          <p class="left f-13">¿Tiempo de traslado del domicilio a la ruta de transporte de <?php echo $info['cliente']; ?> ?</p>
          <table>
            <tr>
              <?php $tiempo_traslado = $info['tiempo_traslado'] ?? 'No proporciona'; ?>
              <td class="center" colspan="2"><?php echo $tiempo_traslado; ?></td>
            </tr>
          </table>
          <div class="div_datos">
            <div class="w-70 flotar-izquierda">
              <p class="left f-13">¿Qué tipo de transporte utiliza?</p>
              <?php 
              if($info['tipo_transporte'] == 'Transporte público'){ ?>
                <span style="display:inline-block;">Público </span>
              <?php
              }
              if($info['tipo_transporte'] == 'Plataforma'){ ?>
                <span>Plataforma </span>
              <?php
              }
              if($info['tipo_transporte'] == 'Carro propio' || $info['tipo_transporte'] == 'Motocicleta' || $info['tipo_transporte'] == 'Bicicleta' || $info['tipo_transporte'] == 'Patineta'){ ?>
                <span>Propio </span>
              <?php
              }
              if($info['tipo_transporte'] == 'Empresarial'){ ?>
                <span>Empresarial </span>
              <?php
              }
              if($info['tipo_transporte'] == '' || $info['tipo_transporte'] == null){ ?>
                <span>No proporciona </span>
              <?php
              } ?>
            </div>
            <div class="w-20 center flotar-izquierda">
              <p class="left f-13">¿Cuánto gasta al día?</p>
              <?php $transporte_diario = ($finanzas != null)? '$'.$finanzas['transporte_diario'] : 'No proporciona'; ?>
              <div style="border: 1px solid black;"><?php echo $transporte_diario ?></div>
            </div>
          </div>
          <p class="left f-13">¿Planes para cambiar de residencia en los próximos 12 meses?</p>
          <table>
            <tr>
              <td class="center" colspan="2"><?php echo $sociales['plan_residencia']; ?></td>
            </tr>
          </table>  
          <p class="left f-13">¿Planes para viajar en los próximos 12 meses?</p>
          <table>
            <tr>
              <td class="center" colspan="2"><?php echo $sociales['plan_viaje']; ?></td>
            </tr>
          </table>
          <p class="left f-13">¿Planes para casarse o tener hijos ?</p>
          <table>
            <tr>
							<td class="center" colspan="2"><?php echo $sociales['plan_familia']; ?></td>
						</tr>
          </table>
				</div>
        <pagebreak>
			<?php 
			} ?>
		<?php
		} 
    //* Salud
		if($secciones['id_salud'] == 70 && $salud != null){ ?>
			<div class="div_datos">
        <p class="center f-18">5. Salud</p>
        <table class="">
          <tr>
            <td class="w-10 encabezado">Estatura:</td>
            <td class="w-10 encabezado">Peso:</p></td>
            <td class="w-10 encabezado">Comp. Física:</td>
            <td class="w-10 encabezado">Color ojos:</td>
            <td class="w-30 encabezado">Tez:</td>
            <td class="w-30 encabezado">Señales particulares:</td>
          </tr>
          <tr>
            <td class="center"><?php echo $salud['estatura'].' m'; ?></td>
            <td class="center"><?php echo $salud['peso'].' kg'; ?></td>
            <td class="center"><?php echo $salud['composicion_fisica']; ?></td>
            <td class="center"><?php echo $salud['color_ojos']; ?></td>
            <td class="center"><?php echo $salud['color_piel']; ?></td>
            <td class="center"><?php echo $salud['particularidades']; ?></td>
          </tr>
        </table>
				<table class="">
          <tr>
            <td class="w-40 left encabezado">Entidad federativa:</td>
            <td class="w-60 center"><?php echo $salud['enfermedad_cronica']; ?></td>
          </tr>
          <tr>
            <td class="left encabezado">Accidentes:</td>
            <td class="center"><?php echo $salud['accidentes']; ?></td>
          </tr>
          <tr>
            <td class="left encabezado">Intervenciones_quirúrgicas:</td>
            <td class="center"><?php echo $salud['intervencion_quirurgica']; ?></td>
          </tr>
          <tr>
            <td class="left encabezado">Enfermedades actuales:</td>
            <td class="center"><?php echo $salud['enfermedad_actual']; ?></td>
          </tr>
          <tr>
            <td class="left encabezado">Tipo de sangre:</td>
            <td class="center"><?php echo $salud['tipo_sangre']; ?></td>
          </tr>
					<tr>
            <td class="left encabezado">Alergias:</td>
            <td class="center"><?php echo $salud['alergias']; ?></td>
          </tr>
				</table>
        <table class="">
          <tr>
            <td class="w-20 left encabezado">Practica algún deporte:</td>
            <td class="w-10 center encabezado">Sí</td>
            <td class="w-10 center encabezado">No</td>
            <td class="w-40 center encabezado">Cuál</td>
            <td class="w-20 center encabezado">Frecuencia</td>
          </tr>
          <tr>
            <td class="center"></td>
            <?php echo $marca = ($salud->practica_deporte == 1)? '<td class="center"><b>X</b></td><td class="center"> </td>': '<td class="center"></td> <td class="center"><b>X</b></td>'; ?>
            <td class="center"><?php echo $salud['deporte']; ?></td>
            <td class="center"><?php echo $salud['deporte_frecuencia']; ?></td>
          </tr>
				</table>
        <table class="">
          <tr>
            <td class="w-20 left encabezado">Adicciones:</td>
            <td class="w-20 center encabezado">Tabaquismo</td>
            <td class="w-20 center encabezado">Alcohol</td>
            <td class="w-20 center encabezado">Drogas</td>
            <td class="w-40 left encabezado">Medicamentos bajo prescripción médica</td>
          </tr>
          <tr>
            <td class="left encabezado">Sí</td>
            <?php echo $marca = ($salud['tabaco'] == 'SI')? '<td class="center"><b>X</b></td>': '<td class="center"></td>'; ?>
            <?php echo $marca = ($salud['alcohol'] == 'SI')? '<td class="center"><b>X</b></td>': '<td class="center"></td>'; ?>
            <?php echo $marca = ($salud['droga'] == 'SI')? '<td class="center"><b>X</b></td>': '<td class="center"></td>'; ?>
            <td class="center" rowspan="2"><?php echo $salud['medicamento_prescrito']; ?></td>
          </tr>
          <tr>
            <td class="left encabezado">No</td>
            <?php echo $marca = ($salud['tabaco'] == 'NO')? '<td class="center"><b>X</b></td>': '<td class="center"></td>'; ?>
            <?php echo $marca = ($salud['alcohol'] == 'NO')? '<td class="center"><b>X</b></td>': '<td class="center"></td>'; ?>
            <?php echo $marca = ($salud['droga'] == 'NO')? '<td class="center"><b>X</b></td>': '<td class="center"></td>'; ?>
          </tr>
          <tr>
            <td class="left encabezado">Ocasional</td>
            <?php echo $marca = ($salud['tabaco_frecuencia']== 'De vez en cuando' || $salud['tabaco_frecuencia']== 'Ocasionalmente' || $salud['tabaco_frecuencia']== 'Días festivos')? '<td class="center"><b>X</b></td>': '<td class="center"></td>'; ?>
            <?php echo $marca = ($salud['alcohol_frecuencia'] == 'De vez en cuando' || $salud['alcohol_frecuencia'] == 'Ocasionalmente' || $salud['alcohol_frecuencia'] == 'Días festivos')? '<td class="center"><b>X</b></td>': '<td class="center"></td>'; ?>
            <?php echo $marca = ($salud['droga_frecuencia'] == 'De vez en cuando' || $salud['droga_frecuencia'] == 'Ocasionalmente' || $salud['droga_frecuencia'] == 'Días festivos')? '<td class="center"><b>X</b></td>': '<td class="center"></td>'; ?>
            <td class="encabezado">Comentarios y observaciones</td>
          </tr>
          <tr>
            <td class="left encabezado">Frecuencia</td>
            <td class="center"><?php echo $salud['tabacofrecuencia']; ?></td>
            <td class="center"><?php echo $salud['alcoholfrecuencia']; ?></td>
            <td class="center"><?php echo $salud['drogafrecuencia']; ?></td>
            <td class="center"><?php echo $salud['conclusion']; ?></td>
          </tr>
				</table>
			</div>
    <?php  
    }
    //* Vivienda
		if($secciones['id_vivienda'] == 71 && $vivienda != null){ ?>
			<div class="div_datos">
        <p class="center f-18">6. Condiciones de la vivienda</p>
        <table class="">
          <tr>
            <td class="w-20 encabezado center">Propia</td>
            <td class="w-20 encabezado center">Pagando hipoteca</td>
            <td class="w-20 encabezado center">Rentada</td>
            <td class="w-20 encabezado center">Prestada</td>
            <td class="w-20 encabezado center">INFONAVIT</td>
          </tr>
          <tr>
            <?php
            if($vivienda->tipo_propiedad == 'Propia'){
              echo $marca = '<td class="center"><b>X</b></td><td class="center"> </td><td class="center"> </td><td class="center"> </td><td class="center"> </td>';
            }
            if($vivienda->tipo_propiedad == 'Pagando hipoteca'){
              echo $marca = '<td class="center"></td><td class="center"><b>X</b></td><td class="center"> </td><td class="center"> </td><td class="center"> </td>';
            } 
            if($vivienda->tipo_propiedad == 'Rentada'){
              echo $marca = '<td class="center"> </td><td class="center"> </td><td class="center"><b>X</b></td><td class="center"> </td><td class="center"> </td>';
            }
            if($vivienda->tipo_propiedad == 'Prestada'){
              echo $marca = '<td class="center"> </td><td class="center"> </td><td class="center"> </td><td class="center"><b>X</b></td><td class="center"> </td>';
            }
            if($vivienda->tipo_propiedad == 'INFONAVIT'){
              echo $marca = '<td class="center"> </td><td class="center"> </td><td class="center"> </td><td class="center"> </td><td class="center"><b>X</b></td>';
            } ?>
          </tr>
        </table>
        <table>
          <tr>
            <td class="w-30 encabezado"></td>
            <td class="w-10 encabezado">Sí</td>
            <td class="w-10 encabezado">No</td>
            <td class="w-15 encabezado"></td>
            <td class="w-5 encabezado">Sí</td>
            <td class="w-5 encabezado">No</td>
            <td class="w-15 encabezado"></td>
            <td class="w-10 encabezado">Cantidad</td>
          </tr>
          <tr>
            <td class="encabezado left">Construcción de lujo:</td>
            <?php echo $marca = ($vivienda['calidad_construccion'] == 'Lujo')? '<td class="center"><b>X</b></td><td class="center"> </td>':'<td class="center"></td><td class="center"><b>X</b></td>'; ?>
            <td class="encabezado left">Sala:</td>
            <?php echo $marca = ($vivienda['sala'] == 'Sí')? '<td class="center"><b>X</b></td><td class="center"> </td>':'<td class="center"></td><td class="center"><b>X</b></td>'; ?>
            <td class="encabezado left">No. de baños:</td>
            <td class="center"><?php echo $vivienda['banios']; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Buenas condiciones:</td>
            <?php echo $marca = ($refper['estado_vivienda'] == 'En excelentes condiciones' || $refper['estado_vivienda'] == 'En buenas condiciones')? '<td class="center"><b>X</b></td><td class="center"> </td>':'<td class="center"></td><td class="center"><b>X</b></td>'; ?>
            <td class="encabezado left">Comedor:</td>
            <?php echo $marca = ($vivienda['comedor'] == 'Sí')? '<td class="center"><b>X</b></td><td class="center"> </td>':'<td class="center"></td><td class="center"><b>X</b></td>'; ?>
            <td class="encabezado left">No. de recámaras:</td>
            <td class="center"><?php echo $vivienda['recamaras']; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Superficie (mts cuadrados):</td>
            <td class="center" colspan="2"><?php echo $vivienda['superficie']; ?></td>
            <td class="encabezado left">Cocina:</td>
            <?php echo $marca = ($vivienda['cocina'] == 'Sí')? '<td class="center"><b>X</b></td><td class="center"> </td>':'<td class="center"></td><td class="center"><b>X</b></td>'; ?>
          </tr>
          <tr>
            <td class="encabezado left">Pisos:</td>
            <td class="center" colspan="2"><?php echo $vivienda['num_piso']; ?></td>
            <td class="encabezado left">Patio:</td>
            <?php echo $marca = ($vivienda['patio']== 'Sí')? '<td class="center"><b>X</b></td><td class="center"> </td>':'<td class="center"></td><td class="center"><b>X</b></td>'; ?>
          </tr>
          <tr>
            <td class="encabezado left">Tipo de piso:</td>
            <td class="center" colspan="2"><?php echo $vivienda['tipo_piso']; ?></td>
            <td class="encabezado left">Cochera:</td>
            <?php echo $marca = ($vivienda['cochera'] == 'Sí')? '<td class="center"><b>X</b></td><td class="center"> </td>':'<td class="center"></td><td class="center"><b>X</b></td>'; ?>
          </tr>
          <!-- <tr>
            <td class="encabezado" colspan="8">Observaciones:</td>
          </tr>
          <tr>
            <td class="center" colspan="8"><?php //echo $vivienda->observacion; ?></td>
          </tr> -->
        </table>
        <p class="center f-13">Tipo de zona y clase social en la que habita</p>
        <table class="">
          <tr>
            <td class="center"><?php echo $combinado = 'Zona: '.$vivienda['tipo_zona'].' / Clase: '.$vivienda['zona']; ?></td>
          </tr>
        </table>
        <p class="center f-13">Tipo de habitación</p>
        <table class="">
          <tr>
            <td class="encabezado center">Casa</td>
            <td class="encabezado center">Departamento</td>
            <td class="encabezado center">Condominio</td>
            <td class="encabezado center">Unidad habitacional</td>
          </tr>
          <tr>
          <?php
          if($vivienda['vivienda'] == 'Casa' || $vivienda['vivienda'] == 'Duplex'){
            echo $marca = '<td class="center"><b>X</b></td><td class="center"> </td><td class="center"> </td><td class="center"> </td>';
          }
          if($vivienda['vivienda'] == 'Departamento'){
            echo $marca = '<td class="center"></td><td class="center"><b>X</b></td><td class="center"> </td><td class="center"> </td>';
          } 
          if($vivienda['vivienda'] == 'Condominio' || $vivienda['vivienda'] == 'Residencia'){
            echo $marca = '<td class="center"> </td><td class="center"> </td><td class="center"><b>X</b></td><td class="center"> </td>';
          }
          if($vivienda['vivienda'] == 'Unidad habitacional'){
            echo $marca = '<td class="center"> </td><td class="center"> </td><td class="center"> </td><td class="center"><b>X</b></td>';
          } ?>
          </tr>
        </table>
        <p class="center f-13">Observaciones dentro de la vivienda</p>
        <table class="">
          <tr>
            <td class="encabezado center">Limpieza y Orden</td>
            <td class="encabezado center">Mobiliario y su Aspecto</td>
          </tr>
          <tr>
            <td class="center"><?php echo $vivienda['condiciones']; ?></td>
            <?php 
            if($vivienda['calidad_mobiliario'] == 1){ ?>
              <td class="center">Bueno</td>
            <?php
            }
            if($vivienda['calidad_mobiliario'] == 2){ ?>
              <td class="center">Regular</td>
            <?php
            }
            if($vivienda['calidad_mobiliario'] == 3){ ?>
              <td class="center">Deficiente</td>
            <?php
            } ?>
          </tr>
        </table>
      </div>
      <pagebreak>
    <?php 
    }
    //* Servicios públicos
		if($secciones['id_servicio']== 73 && $servicios != null){ ?>
			<div class="div_datos">
        <p class="center f-18">7. Servicios públicos</p>
        <table class="">
          <tr>
            <td class="w-20 encabezado center">Servicios</td>
            <td class="w-30 encabezado center">Notas</td>
            <td class="w-20 encabezado center">Servicios</td>
            <td class="w-30 encabezado center">Notas</td>
          </tr>
          <tr>
            <td class="encabezado left">Agua</td>
            <td class="center"><?php echo $servicios->agua; ?></td>
            <td class="encabezado left">Hospital</td>
            <td class="center"><?php echo $servicios['hospital']; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Drenaje</td>
            <td class="center"><?php echo $servicios['drenaje']; ?></td>
            <td class="encabezado left">Policia</td>
            <td class="center"><?php echo $servicios['policia']; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Electricidad</td>
            <td class="center"><?php echo $servicios['electricidad']; ?></td>
            <td class="encabezado left">Mercado</td>
            <td class="center"><?php echo $servicios['mercado']; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Alumbrado</td>
            <td class="center"><?php echo $servicios['alumbrado']; ?></td>
            <td class="encabezado left">Plaza comercial</td>
            <td class="center"><?php echo $servicios['plaza_comercial']; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Iglesia</td>
            <td class="center"><?php echo $servicios['iglesia']; ?></td>
            <td class="encabezado left">Aseo público</td>
            <td class="center"><?php echo $servicios['aseo_publico']; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Transporte</td>
            <td class="center"><?php echo $servicios['transporte']; ?></td>
            <td class="encabezado left">Áreas verdes</td>
            <td class="center"><?php echo $servicios['areas_verdes']; ?></td>
          </tr>
          <tr>
            <td class="encabezado left" colspan="2">Otros</td>
            <td class="center" colspan="2"><?php echo $servicios['otros']; ?></td>
          </tr>
        </table>
      </div>
      <p class="center f-13">Ubicación del domicilio (Mapa):</p>
      <?php  
      if($docs){
        foreach($docs as $doc){
          if($doc['id_tipo_documento'] == 32){ ?>
            <div class="center">
              <?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="700" height="300"><br><br>'; ?>
            </div>
          <?php
          }
        }
        foreach($docs as $doc){
          if($doc['id_tipo_documento'] == 43){ ?>
            <div class="center">
              <?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="600" height="300"><br><br>'; ?>
            </div>
          <?php
          }
        }
      } ?>
      <pagebreak>
    <?php
    }
    //* Economía
		if($secciones['id_finanzas'] == 74 && $finanzas != null){ ?>
      <p class="center f-18">8. Aspectos económicos</p>
			<div class="w-30 flotar-izquierda">
        <table class="div_datos">
          <tr>
            <td class="encabezado center" colspan="2">Egresos mensuales familiares:</td>
          </tr>
          <tr>
            <td class="encabezado center">Fuente:</td>
            <td class="encabezado center">Cantidad:</td>
          </tr>
          <tr>
            <td class="encabezado left">Alimentos</td>
            <td class="center"><?php echo '$'.$finanzas['alimentos']; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Renta</td>
            <td class="center"><?php echo '$'.$finanzas['renta']; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">luz</td>
            <td class="center"><?php echo '$'.$finanzas->luz; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Telefono</td>
            <td class="center"><?php echo '$'.$finanzas->telefono; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Gas</td>
            <td class="center"><?php echo '$'.$finanzas->gas; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Transporte</td>
            <td class="center"><?php echo '$'.$finanzas['transporte']; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Gasolina</td>
            <td class="center"><?php echo '$'.$finanzas->gasolina; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Agua</td>
            <td class="center"><?php echo '$'.$finanzas->agua; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Educación</td>
            <td class="center"><?php echo '$'.$finanzas->educacion; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Vestimenta</td>
            <td class="center"><?php echo '$'.$finanzas->vestimenta; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Medicamentos</td>
            <td class="center"><?php echo '$'.$finanzas->medicamento; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Diversiones</td>
            <td class="center"><?php echo '$'.$finanzas->diversion; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Cable</td>
            <td class="center"><?php echo '$'.$finanzas->cable; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Internet</td>
            <td class="center"><?php echo '$'.$finanzas->internet; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Tarjetas de crédito</td>
            <td class="center"><?php echo '$'.$finanzas->tarjeta_credito; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Celular</td>
            <td class="center"><?php echo '$'.$finanzas->celular; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">INFONAVIT</td>
            <td class="center"><?php echo '$'.$finanzas->infonavit; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Otros</td>
            <td class="center"><?php echo '$'.$finanzas['otros']; ?></td>
          </tr>
          <tr>
            <?php 
            $total_gastos = $finanzas['alimentos'] + $finanzas['renta'] + $finanzas->luz + $finanzas->telefono + $finanzas->gas + $finanzas['transporte'] + $finanzas->gasolina + $finanzas->agua + $finanzas->educacion + $finanzas->vestimenta + $finanzas->medicamento + $finanzas->diversion + $finanzas->cable + $finanzas->internet + $finanzas->tarjeta_credito + $finanzas->celular + $finanzas->infonavit + $finanzas['otros']; ?>
            <td class="encabezado center">TOTAL</td>
            <td class="center"><?php echo '<b>$'.$total_gastos.'</b>'; ?></td>
          </tr>
        </table>
      </div>
      <div class="w-70 flotar-izquierda">
        <table class="">
          <tr>
            <td class="encabezado left">Ingresos familiares</td>
            <td class="encabezado left">Solo personas que viven con el o la candidato(a)</td>
          </tr>
          <tr>
            <td class="encabezado left">Ingresos del candidato</td>
            <td class="center"><?php echo '$'.$info->ingresos; ?></td>
          </tr>
          <?php 
          $total_ingresos = 0;$ingreso_conyuge = 0;$ingreso_hijos = 0;$ingreso_padre = 0;$ingreso_madre = 0;$ingreso_hermano = 0;
          if($familia){
            foreach($familia as $fam){
              if($fam->id_tipo_parentesco == 4 && $fam->misma_vivienda == 1){ //Conyuge
                $ingreso_conyuge += $fam->sueldo;
              }
              if($fam->id_tipo_parentesco == 3 && $fam->misma_vivienda == 1){ //Hijo
                $ingreso_hijos += $fam->sueldo;
              }
              if($fam->id_tipo_parentesco == 1 && $fam->misma_vivienda == 1){ //Padre
                $ingreso_padre += $fam->sueldo;
              }
              if($fam->id_tipo_parentesco == 2 && $fam->misma_vivienda == 1){ //Madre
                $ingreso_madre += $fam->sueldo;
              }
              if($fam->id_tipo_parentesco == 6 && $fam->misma_vivienda == 1){ //Hermano
                $ingreso_hermano += $fam->sueldo;
              }
            }
          }
          $total_ingresos = $info->ingresos + $ingreso_conyuge + $ingreso_hijos + $ingreso_padre + $ingreso_madre + $ingreso_hermano + $info['ingresos_extra']; ?>
          <tr>
            <td class="encabezado left">Ingresos del cónyuge</td>
            <td class="center"><?php echo '$'.$ingreso_conyuge; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Ingresos de los hijos</td>
            <td class="center"><?php echo '$'.$ingreso_hijos; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Ingresos de los padres</td>
            <td class="center"><?php echo '$'.$total_padres = $ingreso_padre + $ingreso_madre; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Ingresos de los hermanos</td>
            <td class="center"><?php echo '$'.$ingreso_hermano; ?></td>
          </tr>
          <tr>
            <td class="encabezado left">Otros ingresos</td>
            <td class="center"><?php echo '$'.$info['ingresos_extra']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center" colspan="2">Observaciones</td>
          </tr>
          <tr>
            <td class="center" colspan="2"><?php echo $finanzas['observacion']; ?></td>
          </tr>
          <tr>
            <td class="encabezado center">TOTAL</td>
            <td class="center"><?php echo '<b>$'.$total_ingresos.'</b>'; ?></td>
          </tr>
        </table>
      </div><br>
      <div class="div_datos">
        <table>
          <tr>
            <td class="encabezado center" colspan="5">CRÉDITOS</td>
          </tr>
          <tr>
            <td class="w-30 encabezado center">¿Tiene adeudos en Banamex o Bancomer?</td>
            <td class="w-10 encabezado center">Sí / No</td>
            <td class="w-15 encabezado center">Cuánto</td>
            <td class="w-15 encabezado center">Saldo</td>
            <td class="w-30 encabezado center">Estatus</td>
          </tr>
          <tr>
            <td class="left"></td>
            <?php echo $tiene_credito = ($finanzas['tiene_credito_banco'] == 1)? '<td class="center"><b>Sí</b></td>': '<td class="center"><b>No</b></td>'; ?>
            <td class="center"><?php echo $importe = ($finanzas['credito_banco_importe'] != 'No aplica')? '$'.$finanzas['credito_banco_importe'] : $finanzas['credito_banco_importe']; ?></td>
            <td class="center"><?php echo '$'.$finanzas['credito_banco_saldo']; ?></td>
            <td class="center"><?php echo $finanzas['credito_banco_estatus']; ?></td>
          </tr>
          <tr>
            <td class="left">INFONAVIT</td>
            <?php echo $tiene_credito = ($finanzas->tiene_credito_infonavit == 1)? '<td class="center"><b>Sí</b></td>': '<td class="center"><b>No</b></td>'; ?>
            <td class="center"><?php echo $importe = ($finanzas->credito_infonavit_importe != 'No aplica')? '$'.$finanzas->credito_infonavit_importe : $finanzas->credito_infonavit_importe; ?></td>
            <td class="center"><?php echo '$'.$finanzas->credito_infonavit_saldo; ?></td>
            <td class="center"><?php echo $finanzas->credito_infonavit_estatus; ?></td>
          </tr>
          <tr>
            <td class="left">Otro</td>
            <?php echo $tiene_credito = ($finanzas->tiene_otro_credito== 1)? '<td class="center"><b>Sí</b></td>': '<td class="center"><b>No</b></td>'; ?>
            <td class="center"><?php echo $importe = ($finanzas->credito_otro_importe != 'No aplica')? '$'.$finanzas->credito_otro_importe : $finanzas->credito_otro_importe; ?></td>
            <td class="center"><?php echo '$'.$finanzas->credito_otro_saldo; ?></td>
            <td class="center"><?php echo $finanzas->credito_otro_estatus; ?></td>
          </tr>
        </table>
      </div><br>
      <div class="div_datos">
        <table>
          <tr>
            <td class="encabezado center" colspan="5">PROPIEDADES</td>
          </tr>
          <tr>
            <td class="w-20 encabezado center"></td>
            <td class="w-40 encabezado center">Ubicación/Características</td>
            <td class="w-10 encabezado center">Valor estimado</td>
            <td class="w-30 encabezado center">A nombre de</td>
          </tr>
          <tr>
            <td class="left">Casa</td>
            <td class="center"><?php echo $finanzas->casa_ubicacion; ?></td>
            <td class="center"><?php echo $es_valor = ($finanzas->casa_valor != 'No aplica')? '$'.$finanzas->casa_valor : $finanzas->casa_valor; ?></td>
            <td class="center"><?php echo $finanzas->casa_titular; ?></td>
          </tr>
          <tr>
            <td class="left">Automóvil (marca y modelo)</td>
            <td class="center"><?php echo $finanzas->automovil; ?></td>
            <td class="center"><?php echo $es_valor = ($finanzas['automovil_valor'] != 'No aplica')? '$'.$finanzas['automovil_valor'] : $finanzas['automovil_valor']; ?></td>
            <td class="center"><?php echo $finanzas->automovil_titular; ?></td>
          </tr>
        </table>
      </div>
      <pagebreak>
    <?php 
    }
    //* Referencias personales
		if($secciones['cantidad_ref_personales']> 0 && $refPersonal != null){
			if($secciones['id_ref_personales'] == 75){ ?>
				<div class="div_datos">
					<p class="center f-18">9. Referencias personales</p>
					<?php $salida2 = '';
					foreach($refPersonal as $refper){ ?>
						<table class="">
              <tr>
                <td class="w-10 encabezado left">Informante</td>
                <td class="w-40 center"><?php echo $refper->nombre;?></td>
                <td class="w-10 encabezado left">Fecha</td>
                <td class="w-40 center"><?php echo $f_edicion = formatoFechaEspanolPDF($refper->edicion);?></td>
						  </tr>
              <tr>
                <td class="encabezado left">Domicilio</td>
                <td class="center"><?php echo $refper->domicilio;?></td>
                <td class="encabezado left">Teléfono</td>
                <td class="center"><?php echo $refper->telefono;?></td>
						  </tr>
              <tr>
                <td class="encabezado left" colspan="2">Tiempo de conocer al candidato:</td>
                <td class="center" colspan="2"><?php echo $refper->tiempo_conocerlo;?></td>
						  </tr>
              <tr>
                <td class="encabezado left" colspan="2">¿En donde ha trabajado el candidato?:</td>
                <td class="center" colspan="2"><?php echo $refper->candidato_trabajo;?></td>
						  </tr>
              <tr>
                <td class="encabezado left" colspan="2">¿Qué opinión tiene como persona?:</td>
                <td class="center" colspan="2"><?php echo $refper->opinion_persona;?></td>
						  </tr>
              <tr>
                <td class="encabezado left" colspan="2">¿Qué opinión tiene como trabajador?:</td>
                <td class="center" colspan="2"><?php echo $refper->opinion_trabajador;?></td>
						  </tr>
              <tr>
                <td class="encabezado center" colspan="2">¿Lo recomendaría?</td>
                <td class="encabezado center" colspan="2">¿Sabe de problemas de cobro o drogas?</td>
						  </tr>
              <tr>
                <?php 
                if($refper['recomienda'] == 1)
                  $recomienda = 'Sí lo recomienda';
                if($refper['recomienda'] == 0)
                  $recomienda = 'No lo recomienda';
                if($refper['recomienda'] == 2)
                  $recomienda = 'No aplica'; ?>
                <td class="center" colspan="2"><?php echo $recomienda; ?></td>
                <td class="center" colspan="2"><?php echo $refper['candidato_problemas'];?></td>
						  </tr>
            </table>
          <?php
					} ?>		  	
				</div>
		<?php 
			}
		}
    //* Referencias vecinales
		if($secciones['cantidad_ref_vecinales'] > 0 && $refVecinal != null){
			if($secciones['id_ref_vecinal'] == 76){ ?>
				<div class="div_datos">
					<p class="center f-18">10. Referencias vecinales</p>
					<?php $salida2 = '';
					foreach($refVecinal as $refVec){ ?>
						<table class="">
              <tr>
                <td class="w-10 encabezado left">Informante</td>
                <td class="w-40 center"><?php echo $refVec->nombre;?></td>
                <td class="w-10 encabezado left">Fecha</td>
                <td class="w-40 center"><?php echo $f_edicion = formatoFechaEspanolPDF($refVec['edicion']);?></td>
						  </tr>
              <tr>
                <td class="encabezado left">Domicilio</td>
                <td class="center"><?php echo $refVec['domicilio'];?></td>
                <td class="encabezado left">Teléfono</td>
                <td class="center"><?php echo $refVec['telefono'];?></td>
						  </tr>
              <tr>
                <td class="encabezado left" colspan="2">Observaciones del referente:</td>
                <td class="center" colspan="2"><?php echo $refVec['notas'];?></td>
						  </tr>
              <tr>
                <td class="encabezado left" colspan="2">Tiempo de conocer al candidato:</td>
                <td class="center" colspan="2"><?php echo $refVec['tiempo_conocerlo'];?></td>
						  </tr>
              <tr>
                <td class="encabezado left" colspan="2">¿En donde ha trabajado el candidato?:</td>
                <td class="center" colspan="2"><?php echo $refVec['sabe_trabaja'];?></td>
						  </tr>
              <tr>
                <td class="encabezado left" colspan="2">¿Qué opinión tiene como persona?:</td>
                <td class="center" colspan="2"><?php echo $refVec['concepto_candidato'];?></td>
						  </tr>
              <tr>
                <td class="encabezado left" colspan="2">¿Qué opinión tiene como trabajador?:</td>
                <td class="center" colspan="2"><?php echo $refVec['opinion_trabajador'];?></td>
						  </tr>
              <tr>
                <td class="encabezado center" colspan="2">¿Lo recomendaría?</td>
                <td class="encabezado center" colspan="2">¿Sabe de problemas de cobro o drogas?</td>
						  </tr>
              <tr>
                <td class="center" colspan="2"><?php echo $refVec['recomienda']; ?></td>
                <td class="center" colspan="2"><?php echo $refVec['candidato_problemas'];?></td>
						  </tr>
            </table>
          <?php
					} ?>		  	
				</div>
        <pagebreak>
		<?php 
			}
		}
    //* Preguntas laborales
		if($secciones['lleva_empleos'] == 1 && $info['trabajo_razon'] != null && $info['trabajo_razon'] != '' && $info['trabajo_expectativa'] != null && $info['trabajo_expectativa'] != ''){ ?>
      <div class="div_datos">
        <p class="center f-18">11. Expectativas hacia la empresa</p>
				<table>
          <tr>
						<td class="encabezado center">¿Por qué te gustaría trabajar en <?php echo $info['cliente']; ?> ?</td>
					</tr>
					<tr>
						<td class="center"><?php echo $info['trabajo_razon']; ?></td>
					</tr>
				</table>
			</div><br>
			<div class="div_datos">
				<table>
          <tr>
						<td class="encabezado center">¿Qué esperas de la empresa en <?php echo $info['cliente']; ?> ?</td>
					</tr>
					<tr>
						<td class="center"><?php echo $info['trabajo_expectativa']; ?></td>
					</tr>
				</table>
			</div>
    <?php 
		}
    //* Empleos
		if($secciones['lleva_empleos'] == 1){
			if($secciones['id_empleos'] == 77){
				if($empleos){ 
					$cont = 1; ?>
          <pagebreak>
					<div class="div_datos">
						<p class="center f-18">12. Referencias laborales </p>
						<?php
						foreach($empleos as $row){
							$contacto = $this->candidato_laboral_model->getContactoLaboralByNumber($cont, $info['id']); ?>
              <p class="center f-13">Versión del candidato:</p>
							<table class="">
								<tr>
                  <td class="w-10 encabezado left">Empresa:</td>
									<td class="w-80 center"><?php echo strtoupper($row['empresa']); ?></td>
                </tr>
                <tr>
									<td class="encabezado left">Giro:</td>
									<td class="center"><?php echo $row['tipo_empresa']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Dirección:</td>
									<td class="center"><?php echo $row['direccion'] ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Teléfono</td>
									<td class="center"><?php echo $row['telefono']; ?></td>
								</tr>
              </table>
              <table class="">
                <tr>
									<td class="w-20 encabezado left">Puesto inicial</td>
									<td class="w-30 center"><?php echo $row['puesto1']; ?></td>
                  <td class="w-20 encabezado left">Puesto final</td>
									<td class="w-30 center"><?php echo $row['puesto2'];?></td>
								</tr>
                <tr>
									<td class="encabezado left">Sueldo inicial</td>
									<td class="center"><?php echo $row['salario1_txt']; ?></td>
                  <td class="encabezado left">Sueldo final</td>
									<td class="center"><?php echo $row['salario2_txt']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Fecha de ingreso</td>
									<td class="center"><?php echo $row['fecha_entrada_txt']; ?></td>
                  <td class="encabezado left">Fecha de baja</td>
									<td class="center"><?php echo $row['fecha_salida_txt']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Sindicalizado?</td>
									<td class="center"><?php echo $sind = ($row['sindicato_puesto']== 'NA' || $row['sindicato_puesto']== 'N/A' || $row['sindicato_puesto']== 'No tiene' || $row['sindicato_puesto']== 'No aplica' || $row['sindicato_puesto']== 'NO APLICA' || $row['sindicato_puesto']== 'No esta sindicalizado' || $row['sindicato_puesto']== 'No tiene sindicato' || $row['sindicato_puesto']== 'Sin sindicato')? 'Sí':'No' ; ?></td>
                  <td class="encabezado left">Puesto en Sindicato</td>
									<td class="center"><?php echo $row['sindicato_puesto']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Motivo de baja</td>
									<td class="center"><?php echo $row['causa_separacion']; ?></td>
                  <td class="encabezado left">Especificar</td>
									<td class="center"><?php echo $row->detalle_separacion; ?></td>
								</tr>
                <tr>
									<td class="encabezado center" colspan="4">¿Le gustaría trabajar de nuevo en la empresa? ¿Por qué?</td>
								</tr>
                <tr>
									<td class="center" colspan="4"><?php echo $row->reingresar; ?></td>
								</tr>
              </table>
              <p class="center f-13">Informante:
							<table class="">
								<tr>
                  <td class="w-20 encabezado left">Nombre:</td>
									<td class="w-30 center"><?php echo $contacto['nombre']; ?></td>
                  <td class="w-20 encabezado left">Puesto:</td>
									<td class="w-30 center"><?php echo $contacto['puesto']; ?></td>
                </tr>
                <tr>
									<td class="encabezado left">Puesto inicial</td>
									<td class="center"><?php echo $contacto['puesto_inicio'];?></td>
                  <td class="encabezado left">Puesto final</td>
									<td class="center"><?php echo $contacto['puesto_fin']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Sueldo inicial</td>
									<td class="center"><?php echo $contacto['sueldo_inicio']; ?></td>
                  <td class="encabezado left">Sueldo final</td>
									<td class="center"><?php echo $contacto['sueldo_fin']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Fecha de ingreso</td>
									<td class="center"><?php echo $contacto['fecha_entrada'];?></td>
                  <td class="encabezado left">Fecha de baja</td>
									<td class="center"><?php echo $contacto['fecha_salida']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Teléfono</td>
									<td class="center"><?php echo $contacto['telefono']; ?></td>
                  <td class="encabezado left">Correo</td>
									<td class="center"><?php echo $contacto['correo']; ?></td>
								</tr>
              </table>
              <table class="">
                <tr>
									<td class="w-40 encabezado left">Actividades que realizaba:</td>
									<td class="w-60 center"><?php echo $contacto['actividades']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Conocimientos y Habilidades sobresalientes</td>
									<td class="center"><?php echo $contacto['habilidades']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Qué tal hacia su trabajo? (Eficiencia, logros) ¿Presentó bajo desempeño?</td>
									<td class="center"><?php echo $contacto['desempeno']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Presentó ausentismos?</td>
									<td class="center"><?php echo $contacto['ausencia']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Realizó violaciones al reglamento interior de trabajo?</td>
									<td class="center"><?php echo $contacto['cumplimiento']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Presentó incapacidades y/o problemas de salud?</td>
									<td class="center"><?php echo $contacto['salud']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Presentó conflictos con sus jefes? Especifique</td>
									<td class="center"><?php echo $contacto['conflicto']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">Motivo de baja</td>
									<td class="center"><?php echo $contacto['causa_separacion']; ?></td>
								</tr>
                <tr>
									<td class="encabezado left">¿Le gustaría trabajar de nuevo con el candidato? ¿Por qué?</td>
									<td class="center"><?php echo $contacto['recontratar']; ?></td>
								</tr>
              </table>
              <table>
                <tr>
									<td class="encabezado center">Observaciones</td>
									<td class="left"><?php echo $contacto['observacion']; ?></td>
								</tr>
              </table>
							<pagebreak>
							<?php
							$cont++; 
						} ?>
					</div><br>
				<?php
				}
			}
		}
    //* Documentos
    if($docs){
      //* Semanas cotizadas 
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 9){
					echo '<div class="center">';
					echo '<h2>13. Registro de IMSS </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
          echo '<pagebreak>';
				}
			}
      if($doc['id_tipo_documento'] == 19){
        echo '<h2 class="center">14. Fotografías </h2>';
        echo '<div class="center margen-top">';
        foreach($docs as $doc){
          echo '<img class="foto" src="'.base_url().'_docs/'.$doc['archivo'].'">';
        }
        echo '</div>';
        echo '<pagebreak>';
      }

      echo '<h2 class="center">15. Otros documentos </h2>';
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 3){
          echo '<div class="center margen-top">';
          echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
          echo '</div>';
          echo '<pagebreak>';
        }
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 7 || $doc['id_tipo_documento'] == 10){
          echo '<div class="center margen-top">';
          echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
          echo '</div>';
          echo '<pagebreak>';
        }
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 13){
          echo '<div class="center margen-top">';
          echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
          echo '</div>';
          echo '<pagebreak>';
        }
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 25){
          echo '<div class="center margen-top">';
          echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
          echo '</div>';
          echo '<pagebreak>';
        }
      }
      foreach($docs as $doc){
        if($doc['id_tipo_documento'] == 8){
          echo '<div class="center margen-top">';
          echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
          echo '</div>';
        }
      }
    }
	}?>
<!-- Fin Tipo PDF 6 -->


<!-- Tipo PDF 1 -->
  <?php 
	if($secciones['tipo_pdf'] == 1){
		//* Datos Generales
		//TODO: Checar como integrar el tipo sanguineo dentro de los procesos
		if($secciones['id_seccion_datos_generales'] != NULL){
			if($secciones['id_seccion_datos_generales'] == 50 && $info['edad'] != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Datos Personales</p>
					<table class="">
							<tr>
								<td class="encabezado">Nombre del aspirante:</td>
								<td class="center" colspan="5"><p class="f-12"><?php echo $info['candidato']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Puesto que solicita:</td>
								<td class="center"><p class="f-12"><?php echo $info['puestoSeleccionado']; ?></p></td>
								<td class="encabezado w-17">Fecha de Nacimiento:</td>
								<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
								<td class="encabezado">Lugar de Nacimiento:</td>
								<td class="center"><p class="f-12"><?php echo $info['lugar_nacimiento']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Edad:</td>
								<td class="center"><p class="f-12"><?php echo $info['edad'] ?></p></td>
								<td class="encabezado">Género:</td>
								<td class="center"><p class="f-12"><?php echo $info['genero']; ?></p></td>
								<td class="encabezado">Estado civil:</td>
								<td class="center"><p class="f-12"><?php echo $info['estado_civil']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Domicilio (calle, número exterior e interior):</td>
								<td class="center"><p class="f-12"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior']; ?></p></td>
								<td class="encabezado">Entre la calle de:</td>
								<td class="center"><p class="f-12"><?php echo $entre = ($info['entre_calles'] == "")? "No proporciona":$info['entre_calles']; ?></p></td>
								<td class="encabezado">Colonia:</td>
								<td class="center"><p class="f-12"><?php echo $info['colonia'] ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Ciudad:</td>
								<td class="center"><p class="f-12"><?php echo$info['municipio']; ?></p></td>
								<td class="encabezado">Estado:</td>
								<td class="center"><p class="f-12"><?php echo $info['estado']; ?></p></td>
								<td class="encabezado">Código postal:</td>
								<td class="center"><p class="f-12"><?php echo $info['cp']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Grado máximo de estudios:</td>
								<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
								<td class="encabezado">Teléfono local:</td>
								<td class="center"><p class="f-12"><?php echo $tel_casa = ($info['telefono_casa'] == "")? "No proporciona":$info['telefono_casa']; ?></p></td>
								<td class="encabezado">Teléfono celular:</td>
								<td class="center"><p class="f-12"><?php echo $info['celular']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Correo:</td>
								<td class="center"><p class="f-12"><?php echo $correo = ($info['correo']= "")? "No proporciona":$info['correo']; ?></p></td>
								<?php 
								if($info['tipo_sanguineo'] != NULL && $info['tipo_sanguineo'] != ''){ ?>
									<td class="encabezado">Tipo sanguíneo:</td>
									<td class="center"><p class="f-12"><?php echo $info['tipo_sanguineo']; ?></p></td>
								<?php 
								} ?>
							</tr>
              <?php 
              if(($info['curp'] != NULL && $info['curp'] != '') || ($info['nss'] != NULL && $info['nss'] != '')){ ?>
                <tr>
                  <?php
                  if($info['curp'] != NULL && $info['curp'] != ''){ ?>
                    <td class="encabezado">CURP:</td>
                    <td class="center"><p class="f-12"><?php echo $info['curp']; ?></p></td>
                  <?php
                  }
                  if($info['nss'] != NULL && $info['nss'] != ''){ ?>
                    <td class="encabezado">NSS:</td>
                    <td class="center"><p class="f-12"><?php echo $info['nss']; ?></p></td>
                  <?php
                  } ?>
                </tr>
              <?php 
              } ?>
					</table>
				</div>
			<?php 
			} 
			if($secciones['id_seccion_datos_generales'] == 51 && $info['edad']!= null){ ?>
				<div class="div_datos">
					<p class="center f-18">Datos Personales</p>
					<table class="">
						<tr>
							<td class="encabezado">Nombre del aspirante:</td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $info['candidato']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Puesto que solicita:</td>
							<td class="center"><p class="f-12"><?php echo $info['puestoSeleccionado']; ?></p></td>
							<td class="encabezado w-17">Fecha de Nacimiento:</td>
							<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
							<td class="encabezado">Lugar de Nacimiento:</td>
							<td class="center"><p class="f-12"><?php echo $info['lugar_nacimiento']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Edad:</td>
							<td class="center"><p class="f-12"><?php echo $info['edad'] ?></p></td>
							<td class="encabezado">Sexo:</td>
							<td class="center"><p class="f-12"><?php echo $info['genero']; ?></p></td>
							<td class="encabezado">Estado civil:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado_civil']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">País donde reside:</td>
							<td class="center" colspan="2"><p class="f-12"><?php echo $info['pais']; ?></p></td>
							<td class="encabezado">Domicilio:</td>
							<td class="center" colspan="2"><p class="f-12"><?php echo $info['domicilio_internacional']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Grado máximo de estudios:</td>
							<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
							<td class="encabezado">Teléfono local:</td>
							<td class="center"><p class="f-12"><?php echo $tel_casa = ($info['telefono_casa'] == "")? "No proporciona":$info['telefono_casa']; ?></p></td>
							<td class="encabezado">Teléfono celular:</td>
							<td class="center"><p class="f-12"><?php echo $info['celular']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Correo:</td>
							<td class="center"><p class="f-12"><?php echo $correo = ($info['correo']= "")? "No proporciona":$info['correo']; ?></p></td>
							<?php 
							if($info['tipo_sanguineo'] != NULL && $info['tipo_sanguineo'] != ''){ ?>
								<td class="encabezado">Tipo sanguíneo:</td>
								<td class="center"><p class="f-12"><?php echo $info['tipo_sanguineo']; ?></p></td>
							<?php 
							} ?>
						</tr>
            <?php 
            if(($info['curp'] != NULL && $info['curp'] != '') || ($info['nss'] != NULL && $info['nss'] != '')){ ?>
              <tr>
                <?php
                if($info['curp'] != NULL && $info['curp'] != ''){ ?>
                  <td class="encabezado">CURP:</td>
                  <td class="center"><p class="f-12"><?php echo $info['curp']; ?></p></td>
                <?php
                }
                if($info['nss'] != NULL && $info['nss'] != ''){ ?>
                  <td class="encabezado">NSS:</td>
                  <td class="center"><p class="f-12"><?php echo $info['nss']; ?></p></td>
                <?php
                } ?>
              </tr>
            <?php 
            } ?>
					</table>
				</div>
			<?php 
			}
		} 
		else{ ?>
			<div class="div_datos">
				<p class="center f-18">Datos Personales</p>
				<table class="">
					<tr>
						<td class="encabezado">Nombre del aspirante:</td>
						<td class="center" colspan="5"><p class="f-12"><?php echo $info['candidato']; ?></p></td>
					</tr>
				</table>
			</div><br><br>
		<?php
		} 
		//* Documentacion
		if($secciones['id_seccion_verificacion_docs'] != NULL){ 
			if($secciones['id_seccion_verificacion_docs'] == 57 && $info['acta'] != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Documentos Comprobatorios</p>
					<table class="">
						<tr>
							<th class="encabezado">CONCEPTO</th>
							<th class="encabezado">NÚMERO Y/O VIGENCIA</th>
							<th class="encabezado">FECHA DE EXPEDICIÓN</th>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Acta de nacimiento</p></td>
							<td class="center"><p class="f-12"><?php echo $info['acta']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $fecha_acta; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Comprobante de domicilio</p></td>
							<td class="center"><p class="f-12"><?php echo $info['cuenta_domicilio']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $fecha_domicilio; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Credencial de elector</p></td>
							<td class="center"><p class="f-12"><?php echo $info['ine']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $emision_ine = ($info['emision_ine'] == "")? "No proporciona":$info['emision_ine']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">CURP</p></td>
							<td class="center"><p class="f-12"><?php echo $info['curp']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $emision_curp; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Afiliación al IMSS</p></td>
							<td class="center"><p class="f-12"><?php echo $nss = ($info['nss'] == "")? "No proporciona":$info['nss']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $emision_nss; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Comprobante retención de impuestos</p></td>
							<td class="center"><p class="f-12"><?php echo $retencion_impuestos = ($info['retencion_impuestos'] == "")? "No proporciona" : $info['retencion_impuestos']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $fecha_retencion_impuestos; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">RFC</p></td>
							<td class="center"><p class="f-12"><?php echo $info['rfc']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $emision_rfc; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Licencia para conducir</p></td>
							<td class="center"><p class="f-12"><?php echo $licencia = ($info['licencia'] == "")? "No proporciona":$info['licencia']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $fecha_licencia; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Vigencia migratoria (extranjeros)</p></td>
							<td class="center"><p class="f-12"><?php echo $vigencia_migratoria; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $numero_migratorio = ($info['numero_migratorio'] == "")? "No proporciona" : $info['numero_migratorio']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">VISA Norteamericana</p></td>
							<td class="center"><p class="f-12"><?php echo $visa = ($info['visa'] == "")? "No proporciona":$info['visa']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $fecha_visa; ?></p></td>
						</tr>
					</table>
				</div>
				<pagebreak>
			<?php 
			}
		}
		//* Estudios
		if($secciones['lleva_estudios'] == 1){
			if($secciones['id_estudios'] == 52 && $academico != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Historial Académico</p>
					<table class="">
						<tr>
							<th class="encabezado">NIVEL ESCOLAR</th>
							<th class="encabezado">PERIDO</th>
							<th class="encabezado">ESCUELA</th>
							<th class="encabezado">CIUDAD</th>
							<th class="encabezado">CERTIFICADO</th>
							<th class="encabezado">PROMEDIO</th>
						</tr>
						<?php 
						if($academico['primaria_periodo'] != null && $academico['primaria_periodo'] != ''){ ?>
							<tr>
								<td class="encabezado center"><p class="f-12">Primaria</p></td>
								<td class="center"><p class="f-12"><?php echo $academico['primaria_periodo']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['primaria_escuela']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['primaria_ciudad']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $res = ($academico['primaria_certificado'] == 1)? "Sí":"No"; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['primaria_promedio']; ?></p></td>
							</tr>
						<?php 
						} ?>
						<?php 
						if($academico['secundaria_periodo'] != null && $academico['secundaria_periodo'] != ''){ ?>
							<tr>
								<td class="encabezado center"><p class="f-12">Secundaria</p></td>
								<td class="center"><p class="f-12"><?php echo $academico['secundaria_periodo']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['secundaria_escuela']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['secundaria_ciudad']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $res = ($academico['secundaria_certificado'] == 1)? "Sí":"No"; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['secundaria_promedio']; ?></p></td>
							</tr>
						<?php 
						} ?>
						<?php 
						if($academico['comercial_periodo'] != null && $academico['comercial_periodo'] != ''){ ?>
							<tr>
								<td class="encabezado center"><p class="f-12">Carrera comercial</p></td>
								<td class="center"><p class="f-12"><?php echo $academico['comercial_periodo']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['comercial_escuela']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['comercial_ciudad']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $res = ($academico['comercial_certificado'] == 1)? "Sí":"No"; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['comercial_promedio']; ?></p></td>
							</tr>
						<?php 
						} ?>
						<?php 
						if($academico['preparatoria_periodo'] != null && $academico['preparatoria_periodo'] != ''){ ?>
							<tr>
								<td class="encabezado center"><p class="f-12">Bachillerato</p></td>
								<td class="center"><p class="f-12"><?php echo $academico['preparatoria_periodo']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['preparatoria_escuela']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['preparatoria_ciudad']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $res = ($academico['preparatoria_certificado'] == 1)? "Sí":"No"; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['preparatoria_promedio']; ?></p></td>
							</tr>
						<?php 
						} ?>
						<?php 
						if($academico['licenciatura_periodo'] != null && $academico['licenciatura_periodo'] != ''){ ?>
							<tr>
								<td class="encabezado center"><p class="f-12">Licenciatura</p></td>
								<td class="center"><p class="f-12"><?php echo $academico['licenciatura_periodo']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['licenciatura_escuela']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['licenciatura_ciudad']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $res = ($academico['licenciatura_certificado'] == 1)? "Sí":"No"; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['licenciatura_promedio']; ?></p></td>
							</tr>
						<?php 
						} ?>
						<?php 
						if($academico['actual_periodo'] != null && $academico['actual_periodo'] != ''){ ?>
							<tr>
								<td class="encabezado center"><p class="f-12">Estudios actuales</p></td>
								<td class="center"><p class="f-12"><?php echo $academico['actual_periodo']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['actual_escuela']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['actual_ciudad']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $res = ($academico['actual_certificado'] == 1)? "Sí":"No"; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico['actual_promedio']; ?></p></td>
							</tr>
						<?php 
						} ?>
						<tr>
							<td class="encabezado center"><p class="f-12">Cédula profesional</p></td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $academico['cedula_profesional']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Otros estudios</p></td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $academico['otros_certificados']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Periodos inactivos</p></td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $academico['carrera_inactivo']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Comentarios</p></td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $academico['comentarios']; ?></p></td>
						</tr>
					</table>
				</div>
				<pagebreak>
			<?php 
			}
		} 
		//* Social
		if($secciones['lleva_sociales'] == 1){
			if($secciones['id_seccion_social'] == 53 && $sociales != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Antecedentes Sociales</p>
					<table class="">
						<tr>
							<td class="encabezado">¿Perteneció algún puesto sindical? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['sindical']  == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado">¿A cuál? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['sindical_nombre']; ?></p></td>
							<td class="encabezado">¿Cargo? </td>
							<td class="center" colspan="3"><p class="f-12"><?php echo $sociales[0]['sindical_cargo'] ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">¿Pertenece algún partido político? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['partido'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado">¿A cuál? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['partido_nombre']; ?></p></td>
							<td class="encabezado">¿Cargo? </td>
							<td class="center" colspan="3"><p class="f-12"><?php echo $sociales[0]['partido_cargo']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">¿Pertenece algún club deportivo? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['club'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado">¿Qué deporte practica? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['deporte']; ?></p></td>
							<td class="encabezado">¿Qué religión profesa?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['religion']; ?></p></td>
							<td class="encabezado">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['religion_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">¿Ingiere bebidas alcohólicas? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['bebidas'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado">¿Con qué frecuencia? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['bebidas_frecuencia']; ?></p></td>
							<td class="encabezado">¿Acostumbra fumar?  </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['fumar'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['fumar_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">¿Ha tenido alguna intervención quirúrgica? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['cirugia']; ?></p></td>
							<td class="encabezado">¿Antecedentes de enfermedades en su familia directa? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['enfermedades']; ?></p></td>
							<td class="encabezado">¿Cuáles son sus planes a corto plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['corto_plazo']; ?></p></td>
							<td class="encabezado">¿Cuáles son sus planes a mediano plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['mediano_plazo']; ?></p></td>
						</tr>
					</table>
				</div>
				<pagebreak>
			<?php 
			}
		} 
		//* Familiar
		if($secciones['lleva_familiares'] == 1 && $familia){ ?>
			<div class="div_datos">
				<p class="center f-18">Datos del Grupo Familiar</p>
				<table class="">
					<tr>
						<th class="encabezado">NOMBRE</th>
						<th class="encabezado">PARENTESCO</th>
						<th class="encabezado">EDAD</th>
						<th class="encabezado">ESTADO CIVIL</th>
						<th class="encabezado">ESCOLARIDAD</th>
						<th class="encabezado">VIVE CON USTED</th>
					</tr>
					<?php $salida = '';
					if($familia){
						foreach($familia as $f){
							$salida .= '<tr>';
							$salida .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['parentesco'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['edad'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['estado_civil'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['escolaridad'].'</p></td>';
							$salida .= ($f['misma_vivienda'] == 1) ? '<td class="center"><p class="f-12">Sí</p></td>' : '<td class="center"><p class="f-12">No</p></td>';
							$salida .= '</tr>';
						}
					}
					else{
						$salida2 .= '<tr>';
						$salida2 .= '<td class="center" colspan="6"><p class="f-12">El candidato vive solo</p></td>';
						$salida2 .= '</tr>';
					}
					echo $salida;
					?>
				</table>
			</div><br>
			<div class="div_datos">
				<p class="center f-18">Antecedentes Laborales del Grupo Familiar</p>
				<table class="">
					<tr>
						<th class="encabezado">NOMBRE</th>
						<th class="encabezado">EMPRESA</th>
						<th class="encabezado">PUESTO</th>
						<th class="encabezado">ANTIGÜEDAD</th>
					</tr>
					<?php $salida = '';
					if($familia){
						foreach($familia as $f){
							$salida .= '<tr>';
							$salida .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['empresa'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['puesto'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['antiguedad'].'</p></td>';
							$salida .= '</tr>';
						}
					}
					else{
						$salida2 .= '<tr>';
						$salida2 .= '<td class="center" colspan="4"><p class="f-12">El candidato vive solo</p></td>';
						$salida2 .= '</tr>';
					}
					echo $salida;
					?>
				</table>
			</div><br>
		  <?php 
		}
		//* Brinco de hoja en caso de exceder numero de familiares
		if($numFamiliares > 6){
			echo '<pagebreak>';
		}
		//* Finanzas
		if($secciones['lleva_familiares'] == 1 && $secciones['lleva_egresos']== 1 && $secciones['id_finanzas'] == 36 && $familia){ ?>
			<div class="div_datos">
				<p class="center f-18">Situación Económica</p>
				<table class="">
					<tr>
						<th class="encabezado" colspan="3">INGRESOS MENSUALES</th>
					</tr>
					<tr>
						<th class="encabezado">NOMBRE</th>
						<th class="encabezado">SUELDO</th>
						<th class="encabezado">APORTACIÓN</th>
					</tr>
					<?php $salida2 = '';
					if($familia){
						foreach($familia as $f){
              if($f['sueldo'] != 0){
                $salida2 .= '<tr>';
                $salida2 .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
                $salida2 .= '<td class="center"><p class="f-12">'.$f['sueldo'].'</p></td>';
                $salida2 .= '<td class="center"><p class="f-12">'.$f['monto_aporta'].'</p></td>';
                $salida2 .= '</tr>';
              }
              else{
                $salida2 .= '<tr>';
                $salida2 .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
                $salida2 .= '<td class="center"><p class="f-12">0</p></td>';
                $salida2 .= '<td class="center"><p class="f-12">0</p></td>';
                $salida2 .= '</tr>';
              }
						}
					}
					else{
						$salida2 .= '<tr>';
						$salida2 .= '<td class="center" colspan="3"><p class="f-12">El candidato vive solo</p></td>';
						$salida2 .= '</tr>';
					}
					echo $salida2;
					?>
				</table>
				<?php 
				//* Brinco de hoja en caso de exceder numero de familiares
				if($numFamiliares >= 5){
					echo '<pagebreak>';
				}
				?>
				<table class="">
					<tr>
						<th class="encabezado" colspan="2">EGRESOS MENSUALES</th>
					</tr>
					<tr>
						<th class="encabezado w-25">CONCEPTOS</th>
						<th class="encabezado">MONTOS</th>
					</tr>
					<tr>
						<td class="encabezado w-40">Renta </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['renta']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">Alimentos </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['alimentos']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">Servicios </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['servicios']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">Transporte </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['transporte']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">Otros </td>
						<td class="center"><p class="f-12"><?php echo "$ ".$finanzas['otros']; ?></p></td>
						<?php $total = $finanzas['renta'] + $finanzas['alimentos'] + $finanzas['servicios'] + $finanzas['transporte'] + $finanzas['otros']; ?>
					</tr>
					<tr>
						<td class="encabezado w-40">Total </td>
						<td class="encabezado"><p class="f-12"><?php echo "$ ".$total; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado w-40">¿Cuándo los egresos son mayores a los ingresos, cómo los solventa? </td>
						<td class="center"><p class="f-12"><?php echo $finanzas['solvencia']; ?></p></td>
					</tr>
				</table>
			</div><br>	
		<?php 
		}
		//* Brinco de hoja en caso de no exceder numero de familiares
		if($numFamiliares <= 4 && !empty($familia) && $secciones['lleva_familiares'] == 1){
			echo '<pagebreak>';
		}
		//* Bienes
		if($secciones['lleva_familiares'] == 1 && $secciones['id_finanzas'] == 36 && $familia){ ?>
			<div class="div_datos">
				<p class="center f-18">Bienes Inmuebles</p>
				<table class="">
					<tr>
						<th class="encabezado">NOMBRE DEL PROPIETARIO</th>
						<th class="encabezado">MUEBLES E INMUEBLES</th>
						<th class="encabezado">ADEUDO</th>
					</tr>
					<?php 
					if($familia){
						$salida3 = '';
						foreach($familia as $f){
							$salida3 .= '<tr>';
							$salida3 .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
							$salida3 .= '<td class="center"><p class="f-12">'.$f['muebles'].'</p></td>';
							$salida3 .= '<td class="center"><p class="f-12">'.$res = ($f['adeudo'] == 1)? "Sí":"No".'</p></td>';
							$salida3 .= '</tr>';
						}
						if($info['muebles'] != null && $info['muebles'] != ""){
							$salida3 .= '<tr>';
							$salida3 .= '<td class="center"><p class="f-12">'.$info['candidato'].'</p></td>';
							$salida3 .= '<td class="center"><p class="f-12">'.$info['muebles'].'</p></td>';
							$salida3 .= '<td class="center"><p class="f-12">'.$res = ($info['adeudo_muebles']== 1)? "Sí":"No".'</p></td>';
						}
					}
					else{
						if($info['muebles'] != null && $info['muebles'] != ""){
							$salida3 .= '<tr>';
							$salida3 .= '<td class="center"><p class="f-12">'.$info['candidato'].'</p></td>';
							$salida3 .= '<td class="center"><p class="f-12">'.$info['muebles'].'</p></td>';
							$salida3 .= '<td class="center"><p class="f-12">'.$res = ($info['adeudo_muebles']== 1)? "Sí":"No".'</p></td>';
						}
					}
					echo $salida3;
					?>
				</table>
			</div><br>
		<?php 
		}
		//* Vivienda
		if($secciones['lleva_vivienda'] == 1 && $vivienda != null){  ?>
			<div class="div_datos">
				<p class="center f-18">Habitación y Medio Ambiente</p>
				<table class="">
					<tr>
						<td class="encabezado center w-40"><p class="f-12">TIEMPO DE RESIDENCIA EN EL DOMICILIO ACTUAL</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['tiempo_residencia']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">NIVEL DE ZONA</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['zona']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">TIPO DE VIVIENDA</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['vivienda']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">RECÁMARAS</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['recamaras']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">BAÑOS</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['banios']; ?></p></td>		  
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">DISTRIBUCIÓN</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['distribucion']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">EL MOBILIARIO ES</p></td>
						<?php
						if($vivienda['calidad_mobiliario'] == 1){
							$calidad = "Buena";
						}
						if($vivienda['calidad_mobiliario'] == 2){
							$calidad = "Regular";
						}
						if($vivienda['calidad_mobiliario'] == 3){
							$calidad = "Mala";
						}
						?>
						<td class="center"><p class="f-12"><?php echo $calidad; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">EL MOBILIARIO ESTÁ</p></td>
						<td class="center"><p class="f-12"><?php echo $res = ($vivienda['mobiliario'] == 1)? "Completo":"Incompleto"; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">LA VIVIENDA ES</p></td>
						<?php
						if($vivienda['tamanio_vivienda'] == 1){
							$tamano = "Amplia";
						}
						if($vivienda['tamanio_vivienda'] == 2){
							$tamano = "Media";
						}
						if($vivienda['tamanio_vivienda'] == 3){
							$tamano = "Reducida";
						}
						?>
						<td class="center"><p class="f-12"><?php echo $tamano; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center w-40"><p class="f-12">CONDICIONES</p></td>
						<td class="center"><p class="f-12"><?php echo $vivienda['condiciones']; ?></p></td>
					</tr>
				</table>
			</div><br>
		<?php 
		}
		//* Brinco de hoja en caso de exceder numero de familiares
		if($numFamiliares >= 5){
			echo '<pagebreak>';
		}
		if ($secciones['cantidad_ref_personales'] > 0 && $refPersonal) {
			if ($secciones['id_ref_personales'] == 54) { ?>
					<div class="div_datos">
							<p class="center f-18">Referencias Personales</p>
							<?php 
							$salida2 = '';
							// Verifica si es una lista de referencias o una sola referencia
							if (isset($refPersonal[0]) && is_array($refPersonal[0])) {
									// Es una lista de referencias
									foreach ($refPersonal as $refper) {
											if ($refper['recomienda'] == 0) {
													$recomienda = "No";
											} elseif ($refper['recomienda'] == 1) {
													$recomienda = "Sí";
											} elseif ($refper['recomienda'] == 2) {
													$recomienda = "NA";
											}
											$salida2 .= '<table class=""><tr>';
											$salida2 .= '<td class="encabezado"><p class="f-12">Nombre</p></td>';
											$salida2 .= '<td class="center"><p class="f-12">' . $refper['nombre'] . '</p></td>';
											$salida2 .= '<td class="encabezado"><p class="f-12">Tiempo de conocerlo</p></td>';
											$salida2 .= '<td class="center"><p class="f-12">' . $refper['tiempo_conocerlo'] . '</p></td>';
											$salida2 .= '</tr>';
											$salida2 .= '<tr>';
											$salida2 .= '<td class="encabezado"><p class="f-12">Teléfono</p></td>';
											$salida2 .= '<td class="center"><p class="f-12">' . $refper['telefono'] . '</p></td>';
											$salida2 .= '<td class="encabezado"><p class="f-12">La recomienda</p></td>';
											$salida2 .= '<td class="center"><p class="f-12">' . $recomienda . '</p></td>';
											$salida2 .= '</tr>';
											$salida2 .= '<tr>';
											$salida2 .= '<td class="encabezado"><p class="f-12">Comentario</p></td>';
											$salida2 .= '<td class="encabezado" colspan="3"><p class="f-12">' . $refper['comentario'] . '</p></td>';
											$salida2 .= '</tr></table><br>';
									}
							} else {
									// Es una sola referencia
									$refper = $refPersonal; // Directamente asignas el array asociativo
	
									if ($refper['recomienda'] == 0) {
											$recomienda = "No";
									} elseif ($refper['recomienda'] == 1) {
											$recomienda = "Sí";
									} elseif ($refper['recomienda'] == 2) {
											$recomienda = "NA";
									}
									$salida2 .= '<table class=""><tr>';
									$salida2 .= '<td class="encabezado"><p class="f-12">Nombre</p></td>';
									$salida2 .= '<td class="center"><p class="f-12">' . $refper['nombre'] . '</p></td>';
									$salida2 .= '<td class="encabezado"><p class="f-12">Tiempo de conocerlo</p></td>';
									$salida2 .= '<td class="center"><p class="f-12">' . $refper['tiempo_conocerlo'] . '</p></td>';
									$salida2 .= '</tr>';
									$salida2 .= '<tr>';
									$salida2 .= '<td class="encabezado"><p class="f-12">Teléfono</p></td>';
									$salida2 .= '<td class="center"><p class="f-12">' . $refper['telefono'] . '</p></td>';
									$salida2 .= '<td class="encabezado"><p class="f-12">La recomienda</p></td>';
									$salida2 .= '<td class="center"><p class="f-12">' . $recomienda . '</p></td>';
									$salida2 .= '</tr>';
									$salida2 .= '<tr>';
									$salida2 .= '<td class="encabezado"><p class="f-12">Comentario</p></td>';
									$salida2 .= '<td class="encabezado" colspan="3"><p class="f-12">' . $refper['comentario'] . '</p></td>';
									$salida2 .= '</tr></table><br>';
							}
							echo $salida2;
							?>		  
					</div>
					<pagebreak>
		<?php 
			}
		}
		
		//* Referencias vecinales
		if($secciones['cantidad_ref_vecinales'] > 0 && $refVecinal){
			if($refVecinal){ ?>
				<div class="div_datos">
					<p class="center f-18">Referencias Vecinales</p>
					<?php $salida4 = '';
					foreach($refVecinal as $refvec){
						$salida4 .= '<table class=""><tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">Nombre</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['nombre'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">Domicilio y Teléfono</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['domicilio'].' / '.$refvec['telefono'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Qué concepto tiene del aspirante?</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['concepto_candidato'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿En qué concepto tiene a la familia como vecinos?</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['concepto_familia'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Conoce el estado civil del aspirante? ¿Cuál es?</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['civil_candidato'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Tiene hijos?</p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['hijos_candidato'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Sabe en dónde trabaja? </p></td>';
						$salida4 .= '<td class="center"><p class="f-12">'.$refvec['sabe_trabaja'].'</p></td>';
						$salida4 .= '</tr>';
						$salida4 .= '<tr>';
						$salida4 .= '<td class="encabezado w-40"><p class="f-12">Notas</p></td>';
						$salida4 .= '<td class="encabezado"><p class="f-12">'.$refvec['notas'].'</p></td>';
						$salida4 .= '</tr></table>';
					}
					echo $salida4;
					?>		  	
				</div>
        <?php 
        if($secciones['cantidad_ref_vecinales'] > 1 || $numVecinales > 1){
          echo '<pagebreak>';
        }
			}
			else{
				$salida4 = '';
				$salida4 .= '<div class="div_datos">';
				$salida4 .= '<p class="center f-18">Referencias Vecinales</p>;';
				$salida4 .= '<table class=""><tr>';
				$salida4 .= '<td class="center"><p class="f-12">No posee referencias vecinales</p></td>';
				$salida4 .= '</tr></table><br><br>';
				$salida4 .= '</div><br>';
				echo $salida4;
				echo '<pagebreak>';
			}
		}
		//* Brinco de hoja en caso de exceder numero de familiares
		if($numFamiliares < 5 && empty($refPersonal) && empty($refVecinal)){
			echo '<pagebreak>';
		}
		//* Empleos
		if($secciones['lleva_empleos'] == 1 && $laborales){
			if($secciones['id_empleos'] == 55){
				if($laborales){ ?>
					<p class="center f-18">Antecedentes Laborales </p>
					<?php 
					foreach($laborales as $ref){ ?>
						<div class="div_datos">
							<table class="">
								<tr>
									<td class="encabezado center"><p class="f-12">Nombre de la empresa</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['empresa']; ?></p></td>
									<td class="encabezado center"><p class="f-12">Área o Departamento</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['area']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Domicilio, calle y número</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['calle']; ?></p></td>
									<td class="encabezado center"><p class="f-12">Colonia</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['colonia']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Código postal</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['cp']; ?></p></td>
									<td class="encabezado center"><p class="f-12">Teléfono</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['telefono']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Tipo de empresa</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['tipo_empresa']; ?></p></td>
									<td class="encabezado center"><p class="f-12">Puesto desempeñado</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['puesto']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Periodo trabajado, mes y año</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['periodo']; ?></p></td>
									<td class="encabezado center"><p class="f-12">Nombre del último jefe</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['jefe_nombre']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Puesto del último jefe</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['jefe_puesto']; ?></p></td>
									<td class="encabezado center"><p class="f-12">Sueldo mensual inicial</p></td>
									<td class="center"><p class="f-12"><?php echo "$ ".$ref['sueldo_inicial']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Sueldo mensual final</p></td>
									<td class="center"><p class="f-12"><?php echo "$ ".$ref['sueldo_final']; ?></p></td>
									<td class="encabezado center"><p class="f-12">¿En qué consistía su trabajo?</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['actividades']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Causa de separación</p></td>
									<td class="center" colspan="3"><p class="f-12"><?php echo $ref['causa_separacion']; ?></p></td>
								</tr>
							</table>
						</div>
						<p class="f-14 center">Tabla de Rendimiento</p>
						<div class="div_datos">
							<table class="">
								<tr>
									<th class="encabezado w-60">Características Analizadas</th>
									<th class="encabezado">Calificación</th>
								</tr>
								<?php 
								if($ref['trabajo_calidad'] == "No proporciona" && $ref['trabajo_puntualidad'] == "No proporciona" && $ref['trabajo_honesto'] == "No proporciona" && $ref['trabajo_responsabilidad'] == "No proporciona" && $ref['trabajo_adaptacion'] == "No proporciona" && $ref['trabajo_actitud_jefes'] == "No proporciona" && $ref['trabajo_actitud_companeros'] == "No proporciona"){
									echo '<tr>
												<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
												<td class="center" rowspan="7"><p class="f-12">No proporciona</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
											</tr>';
								}
								else{
									if($ref['trabajo_calidad'] == "Excelente" && $ref['trabajo_puntualidad'] == "Excelente" && $ref['trabajo_honesto'] == "Excelente" && $ref['trabajo_responsabilidad'] == "Excelente" && $ref['trabajo_adaptacion'] == "Excelente" && $ref['trabajo_actitud_jefes'] == "Excelente" && $ref['trabajo_actitud_companeros'] == "Excelente"){
										echo '<tr>
												<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
												<td class="center" rowspan="7"><p class="f-12">Excelente</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
											</tr>';
									}
									else{
										if($ref['trabajo_calidad'] == "Bueno" && $ref['trabajo_puntualidad'] == "Bueno" && $ref['trabajo_honesto'] == "Bueno" && $ref['trabajo_responsabilidad'] == "Bueno" && $ref['trabajo_adaptacion'] == "Bueno" && $ref['trabajo_actitud_jefes'] == "Bueno" && $ref['trabajo_actitud_companeros'] == "Bueno"){
											echo '<tr>
													<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
													<td class="center" rowspan="7"><p class="f-12">Bueno</p></td>
												</tr>
												<tr>
													<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
												</tr>
												<tr>
													<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
												</tr>
												<tr>
													<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
												</tr>
												<tr>
													<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
												</tr>
												<tr>
													<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
												</tr>
												<tr>
													<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
												</tr>';
										}
										else{
											if($ref['trabajo_calidad'] == "Regular" && $ref['trabajo_puntualidad'] == "Regular" && $ref['trabajo_honesto'] == "Regular" && $ref['trabajo_responsabilidad'] == "Regular" && $ref['trabajo_adaptacion'] == "Regular" && $ref['trabajo_actitud_jefes'] == "Regular" && $ref['trabajo_actitud_companeros'] == "Regular"){
												echo '<tr>
														<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
														<td class="center" rowspan="7"><p class="f-12">Regular</p></td>
													</tr>
													<tr>
														<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
													</tr>
													<tr>
														<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
													</tr>
													<tr>
														<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
													</tr>
													<tr>
														<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
													</tr>
													<tr>
														<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
													</tr>
													<tr>
														<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
													</tr>';
											}
											else{
												if($ref['trabajo_calidad'] == "Insuficiente" && $ref['trabajo_puntualidad'] == "Insuficiente" && $ref['trabajo_honesto'] == "Insuficiente" && $ref['trabajo_responsabilidad'] == "Insuficiente" && $ref['trabajo_adaptacion'] == "Insuficiente" && $ref['trabajo_actitud_jefes'] == "Insuficiente" && $ref['trabajo_actitud_companeros'] == "Insuficiente"){
													echo '<tr>
															<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
															<td class="center" rowspan="7"><p class="f-12">Insuficiente</p></td>
														</tr>
														<tr>
															<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
														</tr>
														<tr>
															<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
														</tr>
														<tr>
															<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
														</tr>
														<tr>
															<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
														</tr>
														<tr>
															<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
														</tr>
														<tr>
															<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
														</tr>';
												}
												else{
													if($ref['trabajo_calidad'] == "Muy mal" && $ref['trabajo_puntualidad'] == "Muy mal" && $ref['trabajo_honesto'] == "Muy mal" && $ref['trabajo_responsabilidad'] == "Muy mal" && $ref['trabajo_adaptacion'] == "Muy mal" && $ref['trabajo_actitud_jefes'] == "Muy mal" && $ref['trabajo_actitud_companeros'] == "Muy mal"){
														echo '<tr>
																<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
																<td class="center" rowspan="7"><p class="f-12">Muy mal</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
															</tr>';
													}
													else{
														echo '<tr>
																<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_calidad'].'</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_puntualidad'].'</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_honesto'].'</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_responsabilidad'].'</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_adaptacion'].'</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_actitud_jefes'].'</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_actitud_companeros'].'</p></td>
															</tr>';
													}
												}
											}
										}
									}
								}
								?>
							</table>
						</div>
						<div class="div_datos">
							<table class="">
								<tr>
									<td class="encabezado w-60">Comentarios y Observaciones</td>
									<td class="center"><?php echo $ref['comentarios']; ?></td>
								</tr>
							</table>
						</div>
						<pagebreak>
				  <?php
					}
				}
			}
		}
		//* Investigación legal
		if($secciones['lleva_investigacion'] == 1 && $legal){ ?>
			<div class="div_datos">
				<p class="center f-18">Investigación Legal</p>
				<table class="">
					<tr>
						<td class="center w-20">Penal </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['penal']; ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['penal_notas']; ?></p></td>		    	
					</tr>
				</table><br><br>
				<table class="">
					<tr>
						<td class="center w-20">Civil </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['civil'];?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['civil_notas']; ?></p></td>		    	
					</tr>
				</table><br><br>
				<table class="">
					<tr>
						<td class="center w-20">Laboral </td>
						<td class="encabezado"><p class="f-12"><?php echo $legal['laboral']; ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Notas </td>
						<td class="center"><p class="f-12"><?php echo $legal['laboral_notas']; ?></p></td>		    	
					</tr>
				</table>
			</div><br><br><br>
		<?php 
		}

		//* Trabajos no mencionados
		if($secciones['lleva_no_mencionados'] == 1 && $nom){
      if(str_word_count($nom[0]['resultado_no_mencionados']) > 600){
        echo '<pagebreak>'; 
        $longitud = strlen($nom[0]['resultado_no_mencionados']);
        $puntoMedio = $longitud / 2;
        $mitad1 = substr($nom[0]['resultado_no_mencionados'], 0, $puntoMedio);
        $mitad2 = substr($nom[0]['resultado_no_mencionados'], $puntoMedio); ?>
        <div class="div_datos">
          <p class="center f-18">Trabajos No Mencionados</p>
          <table class="">
            <tr>
              <td class="center w-20">No Mencionados </td>
              <td class="encabezado"><p class="f-12"><?php echo $nom[0]['no_mencionados'] ?></p></td>
            </tr>
            <tr>
              <td class="center w-20">Resultado (Parte 1) </td>
              <td class="left"><p class="f-12"><?php echo $mitad1.'...'; ?></p></td>		    	
            </tr>
          </table>
          <pagebreak>
          <table class="">
            <tr>
              <td class="center w-20">Resultado (Parte 2) </td>
              <td class="left"><p class="f-12"><?php echo $mitad2; ?></p></td>		    	
            </tr>
          </table><br>
          <table class="">
            <tr>
              <td class="center w-20">Notas </td>
              <td class="encabezado" colspan="2"><p class="f-12"><?php echo $nom[0]['notas_no_mencionados']; ?></p></td>
            </tr>
          </table><br>
        </div>
        <pagebreak>
      <?php
      }
      else{ ?>
        <div class="div_datos">
          <p class="center f-18">Trabajos No Mencionados</p>
          <table class="">
            <tr>
              <td class="center w-20">No Mencionados </td>
              <td class="encabezado"><p class="f-12"><?php echo $nom[0]['no_mencionados'] ?></p></td>
            </tr>
            <tr>
              <td class="center w-20">Resultado </td>
              <td class="left"><p class="f-12"><?php echo $nom[0]['resultado_no_mencionados']; ?></p></td>		    	
            </tr>
          </table><br>
          <table class="">
            <tr>
              <td class="center w-20">Notas </td>
              <td class="encabezado" colspan="2"><p class="f-12"><?php echo $nom[0]['notas_no_mencionados']; ?></p></td>
            </tr>
          </table><br>
        </div>
        <pagebreak>
		<?php 
      }
		}
		//* Conclusion
		if($secciones['tipo_conclusion'] == 7 && isset($finalizado)){ ?>
			<div class="div_datos">
				<p class="center f-18">Conclusión</p><br>
				<p class="f-14 center">Personal</p><br>
				<table class="">
					<tr>
						<td class="center"><p class="f-12"><?php echo $finalizado['descripcion_personal1']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado"><p class="f-12"><?php echo $finalizado['descripcion_personal2']; ?></p></td>		    	
					</tr>
				</table><br>
				<p class="f-14 center">Laboral</p><br>
				<table class="">
					<tr>
						<td class="center"><p class="f-12"><?php echo $finalizado['descripcion_laboral1']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado"><p class="f-12"><?php echo $finalizado['descripcion_laboral2']; ?></p></td>		    	
					</tr>
				</table><br>
				<?php
				if(str_word_count($finalizado['descripcion_laboral2']) > 400){
					echo '<pagebreak>';
				} ?>
				<p class="f-14 center">Socioeconómica</p><br>
				<table class="">
					<tr>
						<td class="center"><p class="f-12"><?php echo $finalizado['descripcion_socio1']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado"><p class="f-12"><?php echo $finalizado['descripcion_socio2']; ?></p></td>		    	
					</tr>
				</table>
			</div><br><br>
		<?php 
		}
    if($secciones['tipo_conclusion'] == 19 && isset($finalizado)){ ?>
			<div class="div_datos">
				<p class="center f-18">Conclusión</p><br>
				<p class="f-14 center">Personal</p><br>
				<table class="">
					<tr>
						<td class="center"><p class="f-12"><?php echo $finalizado['descripcion_personal1']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado"><p class="f-12"><?php echo $finalizado['descripcion_personal2']; ?></p></td>		    	
					</tr>
				</table><br>
				<p class="f-14 center">Laboral</p><br>
				<table class="">
					<tr>
						<td class="center"><p class="f-12"><?php echo $finalizado['descripcion_laboral1']; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado"><p class="f-12"><?php echo $finalizado['descripcion_laboral2']; ?></p></td>		    	
					</tr>
				</table><br>
				<?php
				if(str_word_count($finalizado['descripcion_laboral2']) > 400){
					echo '<pagebreak>';
				} ?>
				<p class="f-14 center">Socioeconómica</p><br>
				<table class="">
					<tr>
						<td class="center"><p class="f-12"><?php echo $finalizado['descripcion_socio1']; ?></p></td>
					</tr>
				</table>
			</div><br><br><br>
		<?php 
		}
		//* Documentos
		if($docs){
			$id_tipo_documento_values = array_column($docs, 'id_tipo_documento');
			if(in_array(19, $id_tipo_documento_values)){?>
				<pagebreak>
				<div class="center sin-flotar margen-top">
					<p class="f-20">Fotos </p><br>
				</div>
				<?php 
				echo '<div class="center margen-top">';
				foreach($docs as $doc){
					if($doc['id_tipo_documento'] == 19){
						echo '<img class="foto" src="'.base_url().'_docs/'.$doc['archivo'].'">';
					}
				}
				echo '</div>';
			}
			?>
		<?php 
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 34 || $doc['id_tipo_documento'] == 39){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Foto grupal de los integrantes de la vivienda del candidato </p><br>
					</div>
					<div class="center margen-top">
						<?php 
						if($doc['id_tipo_documento'] == 34){ 
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="300" height="600">';
						}
						if($doc['id_tipo_documento'] == 39){ 
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="700" height="400">';
						} ?>
					</div>
			<?php
				}
			} 
		} 
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 35 || $doc['id_tipo_documento'] == 40){ ?>
          <pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Fotos de vehículos </p>
					</div>
					<div class="center">
						<?php 
						if($doc['id_tipo_documento'] == 35){ 
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="300" height="600">';
						}
						if($doc['id_tipo_documento'] == 40){ 
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="700" height="400">';
						} ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 33 || $doc['id_tipo_documento'] == 38){ ?>
          <pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Fotos de referencias vecinales </p>
					</div>
					<div class="center">
						<?php 
						if($doc['id_tipo_documento'] == 33){ 
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="300" height="600">';
						}
						if($doc['id_tipo_documento'] == 38){ 
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="700" height="400">';
						} ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 32){ ?>
          <pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Ubicación del domicilio </p>
						<?php 
						if($info['pais'] == 'México' || $info['pais'] == '' || $info['pais'] == NULL){ ?>
							<p class="center"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior'].', '.$info['colonia'].' '.$info['cp'].', '.$info->municipio.', '.$info['estado']; ?></p>
						<?php 
						}
						else{ ?>
							<p class="center"><?php echo $domicilio_internacional; ?></p>
						<?php 
						} ?>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="800" height="500"><br><br>'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 11){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Records criminales – OFAC </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'"><br><br>'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 36){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Comprobante de investigación legal </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'"><br><br>'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 8){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Aviso de privacidad </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			//* Anexos
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 9){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Comprobante de historial laboral </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
      foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 7 || $doc['id_tipo_documento'] == 10){ ?>
          <pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Comprobante de estudios </p>
					</div>
					<div class="center">
						<?php 
						if($doc['id_tipo_documento'] == 7){ 
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
						}
						if($doc['id_tipo_documento'] == 10){ 
							echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
						} ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 13){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Carta laboral </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 23){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Evidencia de correo </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 24){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Evidencia de chat </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 25){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Comprobante de demanda </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 41){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Buró de crédito </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
		}
	}
	?>
<!-- Tipo PDF 1 -->


<!-- Tipo PDF 2 -->
	<?php 
	if($secciones['tipo_pdf'] == 2){
		//* Datos Generales
		if($secciones['id_seccion_datos_generales'] == 28 && $info['edad']!= null){ ?>
			<div class="div_datos">
				<p class="center f-18">Datos Personales</p>
				<table class="">
						<tr>
							<td class="encabezado">Nombre del aspirante:</td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $info['nombre']." ".$info['paterno']." ".$info['materno']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Puesto que solicita:</td>
							<td class="center"><p class="f-12"><?php echo $info['puestoSeleccionado']; ?></p></td>
							<td class="encabezado w-17">Fecha de Nacimiento:</td>
							<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
              <td class="encabezado">Edad:</td>
							<td class="center"><p class="f-12"><?php echo $info['edad'] ?></p></td>
						</tr>
						<tr>
              <td class="encabezado">Nacionalidad:</td>
							<td class="center"><p class="f-12"><?php echo $info['nacionalidad']; ?></p></td>
							<td class="encabezado">Género:</td>
							<td class="center"><p class="f-12"><?php echo $info['genero']; ?></p></td>
							<td class="encabezado">Estado civil:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado_civil']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Domicilio (calle, número exterior e interior):</td>
							<td class="center"><p class="f-12"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior']; ?></p></td>
							<td class="encabezado">Entre la calle de:</td>
							<td class="center"><p class="f-12"><?php echo $entre = ($info['entre_calles'] == "")? "No proporciona":$info['entre_calles']; ?></p></td>
							<td class="encabezado">Colonia:</td>
							<td class="center"><p class="f-12"><?php echo $info['colonia'] ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Ciudad:</td>
							<td class="center"><p class="f-12"><?php echo$info['municipio']; ?></p></td>
							<td class="encabezado">Estado:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado']; ?></p></td>
							<td class="encabezado">Código postal:</td>
							<td class="center"><p class="f-12"><?php echo $info['cp']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Teléfono de casa:</td>
							<td class="center"><p class="f-12"><?php echo $tel_casa = ($info['telefono_casa'] == "")? "No proporciona":$info['telefono_casa']; ?></p></td>
              <td class="encabezado">Otro teléfono:</td>
						  <td class="center"><p class="f-12"><?php echo $tel_otro = ($info['telefono_otro'] == "")? "No proporciona":$info['telefono_otro']; ?></p></td>
							<td class="encabezado">Teléfono celular:</td>
							<td class="center"><p class="f-12"><?php echo $info['celular']; ?></p></td>
						</tr>
            <tr>
              <td class="encabezado">Grado máximo de estudios:</td>
							<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
							<td class="encabezado">Correo:</td>
							<td class="center"><p class="f-12"><?php echo $correo = ($info['correo']= "")? "No proporciona":$info['correo']; ?></p></td>
              <td class="encabezado">Tiempo en el domicilio actual:</td>
						  <td class="center"><p class="f-12"><?php echo $info['tiempo_dom_actual']; ?></p></td>
						</tr>
            <tr>
              <td class="encabezado">Tiempo de traslado a la oficina:</td>
              <td class="center"><p class="f-12"><?php echo $info['tiempo_traslado']; ?></p></td>
              <td class="encabezado">Medio de transporte:</td>
              <td class="center"><p class="f-12"><?php echo $info['tipo_transporte']; ?></p></td>
							<?php 
							if($info['tipo_sanguineo'] != NULL && $info['tipo_sanguineo'] != ''){ ?>
								<td class="encabezado">Tipo sanguíneo:</td>
								<td class="center"><p class="f-12"><?php echo $info['tipo_sanguineo']; ?></p></td>
							<?php 
							} ?>
            </tr>
				</table>
			</div>
    <?php  
    }
		//* Documentacion
		if($secciones['id_seccion_verificacion_docs'] == 34){
			if($verDoc != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Documentos</p>
					<table class="">
						<tr>
							<th class="encabezado">CONCEPTO</th>
							<th class="encabezado">NÚMERO DE DOCUMENTO</th>
							<th class="encabezado">DATO / INSTITUCIÓN</th>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Número de Seguridad Social (NSS)</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->imss; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->imss_institucion; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Comprobante de domicilio</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->domicilio; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->fecha_domicilio; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">RFC con homoclave</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->rfc; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->rfc_institucion; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">ID (INE, IFE o pasaporte)</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc['ine']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc['ine_institucion']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">CURP</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->curp; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->curp_institucion; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Licencia para conducir</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc['licencia'] ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc['licencia_institucion']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Carta de recomendación</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->carta_recomendacion; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->carta_recomendacion_institucion; ?></p></td>
						</tr>
					</table>
				</div>
				<pagebreak>
			<?php 
			}
		}
		//* Social
		if($secciones['lleva_sociales'] == 1){
			if($secciones['id_seccion_social'] == 64 && $sociales != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Antecedentes Sociales</p>
					<table class="">
						<tr>
							<td class="encabezado w-25">¿Ingiere bebidas alcohólicas? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($secciones['bebidas'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia? </td>
							<td class="center"><p class="f-12"><?php echo $secciones['bebidas_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Acostumbra fumar?  </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['fumar'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['fumar_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Ha tenido alguna intervención quirúrgica? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['cirugia']; ?></p></td>
							<td class="encabezado w-25">¿Antecedentes de enfermedades en su familia directa? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['enfermedades']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Cuáles son sus planes a corto plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['corto_plazo']; ?></p></td>
							<td class="encabezado w-25">¿Cuáles son sus planes a mediano plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['mediano_plazo']; ?></p></td>
						</tr>
					</table>
				</div>
			<?php 
			} ?>
		<?php
		}  
		//* Familiar
		if($secciones['lleva_familiares'] == 1 && $familia){ ?>
			<div class="div_datos">
				<p class="center f-18">Datos del Grupo Familiar</p>
				<table class="">
					<tr>
						<th class="encabezado">NOMBRE</th>
						<th class="encabezado">PARENTESCO</th>
						<th class="encabezado">EDAD</th>
						<th class="encabezado">ESTADO CIVIL</th>
						<th class="encabezado">ESCOLARIDAD</th>
						<th class="encabezado">VIVE CON USTED</th>
					</tr>
					<?php $salida = '';
					if($familia){
						foreach($familia as $f){
							$salida .= '<tr>';
							$salida .= '<td class="center w-40"><p class="f-12">'.$f['nombre'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['parentesco'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['edad'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['estado_civil'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['escolaridad'].'</p></td>';
							$salida .= ($f['misma_vivienda'] == 1) ? '<td class="center"><p class="f-12">Sí</p></td>' : '<td class="center"><p class="f-12">No</p></td>';
							$salida .= '</tr>';
						}
					}
					else{
						$salida2 .= '<tr>';
						$salida2 .= '<td class="center" colspan="4"><p class="f-12">El candidato vive solo</p></td>';
						$salida2 .= '</tr>';
					}
					echo $salida;
					?>
				</table>
			</div>
			<div class="div_datos">
				<p class="center f-18">Antecedentes Laborales del Grupo Familiar</p>
				<table class="">
					<tr>
						<th class="encabezado">NOMBRE</th>
						<th class="encabezado">EMPRESA / CIUDAD</th>
						<th class="encabezado">PUESTO</th>
						<th class="encabezado">ANTIGÜEDAD</th>
					</tr>
					<?php $salida = '';
					if($familia){
						foreach($familia as $f){
							$salida .= '<tr>';
							$salida .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['empresa'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['puesto'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['antiguedad'].'</p></td>';
							$salida .= '</tr>';
						}
					}
					else{
						$salida2 .= '<tr>';
						$salida2 .= '<td class="center" colspan="4"><p class="f-12">El candidato vive solo</p></td>';
						$salida2 .= '</tr>';
					}
					echo $salida;
					?>
				</table>
			</div>
		<?php
		} 
		//* Contactos del mismo trabajo
		if($secciones['lleva_empleos'] == 1){
			if($secciones['id_empleos'] == 32 && $contacto_trabajo != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Familiares o amigos trabajando en <?php echo $info['cliente']; ?></p>
					<?php 
					if($contacto_trabajo){ 
						foreach($contacto_trabajo as $row){ ?>
							<table class="">
								<tr>
									<th class="encabezado">Nombre</th>
									<th class="encabezado">Puesto</th>
								</tr>
								<tr>
									<td class="center"><p class="f-12"><?php echo $row['nombre'];?></p></td>
									<td class="center"><p class="f-12"><?php echo $row['puesto']; ?></p></td>
								</tr>
							</table>
						<?php
						} ?>
					<?php
					}
					else{ ?>
						<table>
							<tr>
								<td class="center"><p class="f-12">El candidato no tiene familiares, amigos o conocidos en <?php echo $info['cliente']; ?></p></td>
							</tr>
						</table>
					<?php
					} ?>
				</div><br>
		  <?php
			} 
		} 
		//* Brinco de hoja en caso de exceder numero de familiares
		if($numFamiliares > 4){
			echo '<pagebreak>';
		}
		//* Finanzas y bienes
		if($secciones['id_finanzas'] == 43 && $finanzas != null){ ?>
			<table class="">
				<tr>
					<th class="encabezado" colspan="2">BIENES, INGRESOS Y EGRESOS</th>
				</tr>
				<tr>
					<th class="encabezado w-25">CONCEPTOS</th>
					<th class="encabezado">MONTOS</th>
				</tr>
				<tr>
					<td class="encabezado w-40">Muebles y/o inmuebles </td>
					<td class="center"><p class="f-12"><?php echo $info['muebles']; ?></p></td>
				</tr>
				<tr>
					<td class="encabezado w-40">Adeudo en muebles e inmuebles </td>
					<td class="center"><p class="f-12"><?php echo $res = ($info['adeudo_muebles']== 1)? "Sí":"No"; ?></p></td>
				</tr>
				<tr>
					<td class="encabezado w-40">Ingresos fijos </td>
					<td class="center"><p class="f-12"><?php echo $info['ingresos']; ?></p></td>
				</tr>
				<tr>
					<td class="encabezado w-40">Ingresos extra </td>
					<td class="center"><p class="f-12"><?php echo $info['ingresos_extra']; ?></p></td>
				</tr>
				<tr>
					<td class="encabezado w-40">Gastos/Egresos generales </td>
					<td class="center"><p class="f-12"><?php echo $finanzas['otros']; ?></p></td>
				</tr>
				<tr>
					<td class="encabezado w-40">¿Cuándo los egresos son mayores a los ingresos, cómo los solventa? </td>
					<td class="center"><p class="f-12"><?php echo $finanzas['solvencia']; ?></p></td>
				</tr>
				<tr>
					<td class="encabezado w-40">Notas </td>
					<td class="center"><p class="f-12"><?php echo $info->comentario; ?></p></td>
				</tr>
			</table>
		<?php 
		}
		//* Brinco de hoja en caso de no exceder numero de familiares
		if($numFamiliares <= 4){
			echo '<pagebreak>';
		}
		//* Estudios
		if($secciones['id_estudios'] == 3 && $verMayoresEstudios != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Mayores estudios del candidato</p>
				<table class="">
					<tr>
						<th class="encabezado"></th>
						<th class="encabezado">Candidato</th>
						<th class="encabezado">Analista</th>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Nivel académico</p></td>
						<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->grado_estudio; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Periodo</p></td>
						<td class="center"><p class="f-12"><?php echo $info->estudios_periodo; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->periodo; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Escuela</p></td>
						<td class="center"><p class="f-12"><?php echo $info->estudios_escuela; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->escuela; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Ciudad</p></td>
						<td class="center"><p class="f-12"><?php echo $info->estudios_ciudad; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->ciudad; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Certificate Obtained</p></td>
						<td class="center"><p class="f-12"><?php echo $info->estudios_certificado; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->certificado; ?></p></td>
					</tr>
				</table>
			</div><br>
		 	<div class="div_datos">
				<table class="">
					<tr>
						<td class="center"><p class="f-12"><?php echo $verMayoresEstudios->comentarios; ?></p></td>
					</tr>
				</table>
		 	</div><br>
		<?php 
		} 
    //* Brinco de hoja en caso de no exceder numero de familiares
		if($numFamiliares > 4){
			echo '<pagebreak>';
		}
		//* Empleos
		if($secciones['lleva_empleos'] == 1){
			if($secciones['id_empleos'] == 32){
				if($empleos){ 
					$cont = 1; ?>
					<div class="div_datos">
						<p class="center f-18">Referencias laborales </p>
						<?php
						foreach($empleos as $row){
							$ver_laboral = $this->candidato_laboral_model->getVerificacionLaboralByNumber($cont, $info['id']); ?>
							<table class="">
								<tr>
									<th class="encabezado"></th>
									<th class="encabezado">Candidato</th>
									<th class="encabezado">Compañía</th>
									<th class="encabezado">Referencias</th>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Compañía</p></td>
									<td class="center"><p class="f-12"><?php echo $row['empresa']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $vivienda['empresa'] ?></p></td>
									<td class="left w-30" rowspan="12"><p class="f-12"><?php echo $vivienda['notas']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Dirección</p></td>
									<td class="center"><p class="f-12"><?php echo $row['direccion'] ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['direccion']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Fecha de entrada</p></td>
									<td class="center"><p class="f-12"><?php echo $entrada_laboral = $row['fecha_entrada_txt']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $entrada_verifica = $ver_laboral['fecha_entrada_txt']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Fecha de salida</p></td>
									<td class="center"><p class="f-12"><?php echo $salida_laboral = $row['fecha_salida_txt']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $salida_verifica = $ver_laboral['fecha_salida_txt']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Teléfono</p></td>
									<td class="center"><p class="f-12"><?php echo $row['telefono']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['telefono']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Puesto inicial</p></td>
									<td class="center"><p class="f-12"><?php echo $row['puesto1']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['puesto1']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Puesto final</p></td>
									<td class="center"><p class="f-12"><?php echo $row['puesto2'];?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['puesto2']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Salario inicial</p></td>
									<td class="center"><p class="f-12"><?php echo $row['salario1_txt']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['salario1_txt']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Salario final</p></td>
									<td class="center"><p class="f-12"><?php echo $row['salario2_txt']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['salario2_txt']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Jefe inmediato</p></td>
									<td class="center"><p class="f-12"><?php echo $row['jefe_nombre']."<br>".$row['jefe_correo']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['jefe_nombre']."<br>".$ver_laboral['jefe_correo']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Puesto del jefe inmediato</p></td>
									<td class="center"><p class="f-12"><?php echo $row['jefe_puesto']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['jefe_puesto']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Motivo de separación</p></td>
									<td class="center"><p class="f-12"><?php echo $row['causa_separacion']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['causa_separacion']; ?></p></td>
								</tr>
							</table>
							<p class="f-14 center">Características del candidato</p><br>
							<div class="div_datos">
								<table class="">
									<tr>
										<td class="encabezado right" width="35%"><p class="f-12"><b>Fortalezas o cualidades del candidato</b></p></td>
										<td class="center" colspan="3"><p class="f-11"><b><?php echo $ver_laboral['cualidades']; ?></b></p></td>
									</tr>
									<tr>
										<td class="encabezado right" width="35%"><p class="f-12"><b>Áreas a mejorar del candidato</b></p></td>
										<td class="center" colspan="3"><p class="f-11"><b><?php echo $ver_laboral['mejoras']; ?></b></p></td>
									</tr>
								</table>
							</div>
							<pagebreak>
							<?php
							$cont++; 
						} ?>
					</div><br>
				<?php
				}
			}
		}
		//* GAPS
		if($secciones['lleva_gaps']== 1 && $gaps != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Periodos inactivos laborales</p>
				<table class="">
					<tr>
						<th class="encabezado">Desde</th>
						<th class="encabezado">Hasta</th>
						<th class="encabezado" width="40%">Motivo/Razón</th>
					</tr>
					<?php 
					if($gaps){
						foreach($gaps as $g){ ?>
							<tr>
								<td class="center"><p class="f-12"><?php echo $g['fecha_inicio']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $g['fecha_fin']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $g['razon']; ?></p></td>

							</tr>
					<?php
						}
					} ?>
				</table>
			</div>
		<?php 
		}
		//* Trabajos no mencionados
		if($secciones['lleva_no_mencionados'] == 1 && $nom != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Trabajos No Mencionados</p>
				<table class="">
					<tr>
						<td class="center w-20">No Mencionados </td>
						<td class="encabezado"><p class="f-12"><?php echo $nom[0]['no_mencionados'] ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Resultado </td>
						<td class="center"><p class="f-12"><?php echo $nom[0]['resultado_no_mencionados']; ?></p></td>		    	
					</tr>
				</table><br>
				<table class="">
					<tr>
						<td class="center w-20">Notas </td>
						<td class="encabezado" colspan="2"><p class="f-12"><?php echo $nom[0]['notas_no_mencionados']; ?></p></td>
					</tr>
				</table>
			</div>
		<?php 
		}
		//* Preguntas laborales
		if($secciones['lleva_empleos'] == 1 && $info['trabajo_enterado']  != null && $info['trabajo_enterado']  != '' && $info['trabajo_gobierno']  != null && $info['trabajo_gobierno']  != ''){ ?>
			<div class="div_datos">
				<p class="center f-18">¿Cómo se enteró del trabajo en <?php echo $info['cliente']; ?> </p>
				<table>
					<tr>
						<td class="center"><p class="f-12"><?php echo $info['trabajo_enterado'] ; ?></p></td>
					</tr>
				</table>
			</div><br>
			<div class="div_datos">
				<p class="center f-18">¿El candidato ha trabajado en alguna entidad de gobierno, partido político u ONG? </p>
				<table>
					<tr>
						<td class="center"><p class="f-12"><?php echo $info['trabajo_gobierno'] ; ?></p></td>
					</tr>
				</table>
			</div>
		<?php 
		}
    //* Brinco de hoja en caso de exceder numero de GAPS
		if($numGaps > 1){
			echo '<pagebreak>';
		}
		//* Referencias personales
		if($secciones['cantidad_ref_personales']> 0 && $refPersonal != null){
			if($secciones['id_ref_personales'] == 31){ ?>
				<div class="div_datos">
					<p class="center f-18">Referencias Personales</p>
					<?php $salida2 = '';
					foreach($refPersonal as $refper){
						if($refper['recomienda'] == 0){
							$recomienda = "No";
						}
						if($refper['recomienda'] == 1){
							$recomienda = "Sí";
						}
						if($refper['recomienda'] == 2){
							$recomienda = "NA";
						}
						$sabe_donde = ($refper['sabe_trabajo'] == 1)? "Sí":"No";
						$sabe_vive = ($refper['sabe_vive'] == 1)? "Sí":"No";
						
						$salida2 .= '<table class=""><tr>';
						$salida2 .= '<td class="encabezado w-25"><p class="f-12">Nombre</p></td>';
						$salida2 .= '<td class="center"><p class="f-12">'.$refper['nombre'].'</p></td>';
						$salida2 .= '<td class="encabezado w-25"><p class="f-12">Teléfono</p></td>';
						$salida2 .= '<td class="center"><p class="f-12">'.$refper['telefono'].'</p></td>';
						$salida2 .= '</tr>';
						$salida2 .= '<tr>';
						$salida2 .= '<td class="encabezado w-25"><p class="f-12">Tiempo de conocerlo</p></td>';
						$salida2 .= '<td class="center"><p class="f-12">'.$refper['tiempo_conocerlo'].'</p></td>';
						$salida2 .= '<td class="encabezado w-25"><p class="f-12">De qué lugar conoce al candidato</p></td>';
						$salida2 .= '<td class="center"><p class="f-12">'.$refper['donde_conocerlo'].'</p></td>';
						$salida2 .= '</tr>';
						$salida2 .= '<tr>';
						$salida2 .= '<td class="encabezado"><p class="f-12">Sabe dónde trabaja el candidato</p></td>';
						$salida2 .= '<td class="center"><p class="f-12">'.$sabe_donde.'</p></td>';
						$salida2 .= '<td class="encabezado"><p class="f-12">Sabe dónde vive el candidato</p></td>';
						$salida2 .= '<td class="center"><p class="f-12">'.$sabe_vive.'</p></td>';
						$salida2 .= '</tr>';
						$salida2 .= '<tr>';
						$salida2 .= '<td class="encabezado w-25"><p class="f-12">La recomienda</p></td>';
						$salida2 .= '<td class="center" colspan="3"><p class="f-12">'.$recomienda.'</p></td>';
						$salida2 .= '</tr>';
						$salida2 .= '<tr>';
						$salida2 .= '<td class="encabezado"><p class="f-12">Comentario</p></td>';
						$salida2 .= '<td class="encabezado" colspan="3"><p class="f-12">'.$refper['comentario'].'</p></td>';
						$salida2 .= '</tr></table><br><br>';
					}
					echo $salida2;
					?>		  	
				</div><br>
				<pagebreak>
		  <?php 
			}
		}
		//* Conclusion
		if($secciones['tipo_conclusion'] == 5 && $finalizado != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Conclusión de la Investigación</p><br>
			</div>
			<p class="left f-12"><?php echo $finalizado['descripcion_personal1']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_personal2']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_personal3']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_personal4']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_socio2']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_laboral1']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_laboral2']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_visita1']; ?></p>
		<?php 
		}
		//* Documentos
		if($secciones['visita'] != NULL && $docs){ ?>
      <pagebreak>
			<div class="center sin-flotar margen-top">
				<h2>Fotos </h2>
			</div>
			<?php 
			if($docs){
				foreach($docs as $doc){
					if($doc['id_tipo_documento'] == 19){
						echo '<div class="center margen-top">';
						echo '<img class="foto" src="'.base_url().'_docs/'.$doc['archivo'].'">';
						echo '</div>';
					}
				}
			}
		} ?>
		<!-- Aviso de privacidad -->
		<?php 
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Aviso de privacidad</h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
		}
		?>
		<!-- Semanas cotizadas -->
		<?php 
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 9){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Semanas laborales cotizadas </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
		}
		?>
    <?php 
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 23){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Evidencia de correo </h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
		}
		?>
		<!-- Carta de recomendacion -->
		<?php 
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 13){
          echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Carta de recomendación</h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'"><br><br><br><br><br>';
					echo '</div>';
				}
			}
		}
	}?>
<!-- Fin Tipo PDF 2 -->


<!-- Tipo PDF 3 -->
  <?php 
	if($secciones['tipo_pdf'] == 3){
		//* Datos Generales
		//TODO: Checar como integrar el tipo sanguineo dentro de los procesos
		if($secciones['id_seccion_datos_generales'] != NULL){
			if($secciones['id_seccion_datos_generales'] == 50 && $info['edad']!= null){ ?>
				<div class="div_datos">
					<p class="center f-18">Datos Personales</p>
					<table class="">
							<tr>
								<td class="encabezado">Nombre del aspirante:</td>
								<td class="center" colspan="5"><p class="f-12"><?php echo $info['candidato']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Puesto que solicita:</td>
								<td class="center"><p class="f-12"><?php echo $info['puestoSeleccionado']; ?></p></td>
								<td class="encabezado w-17">Fecha de Nacimiento:</td>
								<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
								<td class="encabezado">Lugar de Nacimiento:</td>
								<td class="center"><p class="f-12"><?php echo $info['lugar_nacimiento']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Edad:</td>
								<td class="center"><p class="f-12"><?php echo $info['edad'] ?></p></td>
								<td class="encabezado">Género:</td>
								<td class="center"><p class="f-12"><?php echo $info['genero']; ?></p></td>
								<td class="encabezado">Estado civil:</td>
								<td class="center"><p class="f-12"><?php echo $info['estado_civil']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Domicilio (calle, número exterior e interior):</td>
								<td class="center"><p class="f-12"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior']; ?></p></td>
								<td class="encabezado">Entre la calle de:</td>
								<td class="center"><p class="f-12"><?php echo $entre = ($info['entre_calles'] == "")? "No proporciona":$info['entre_calles']; ?></p></td>
								<td class="encabezado">Colonia:</td>
								<td class="center"><p class="f-12"><?php echo $info['colonia'] ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Ciudad:</td>
								<td class="center"><p class="f-12"><?php echo$info['municipio']; ?></p></td>
								<td class="encabezado">Estado:</td>
								<td class="center"><p class="f-12"><?php echo $info['estado']; ?></p></td>
								<td class="encabezado">Código postal:</td>
								<td class="center"><p class="f-12"><?php echo $info['cp']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Grado máximo de estudios:</td>
								<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
								<td class="encabezado">Teléfono local:</td>
								<td class="center"><p class="f-12"><?php echo $tel_casa = ($info['telefono_casa'] == "")? "No proporciona":$info['telefono_casa']; ?></p></td>
								<td class="encabezado">Teléfono celular:</td>
								<td class="center"><p class="f-12"><?php echo $info['celular']; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado">Correo:</td>
								<td class="center"><p class="f-12"><?php echo $correo = ($info['correo']= "")? "No proporciona":$info['correo']; ?></p></td>
								<?php 
								if($info['tipo_sanguineo'] != NULL && $info['tipo_sanguineo'] != ''){ ?>
									<td class="encabezado">Tipo sanguíneo:</td>
									<td class="center"><p class="f-12"><?php echo $info['tipo_sanguineo']; ?></p></td>
								<?php 
								} ?>
							</tr>
					</table>
				</div>
				<pagebreak>
			<?php 
			} 
		} 
		else{ ?>
			<div class="div_datos">
				<p class="center f-18">Datos Personales</p>
				<table class="">
					<tr>
						<td class="encabezado">Nombre del aspirante:</td>
						<td class="center" colspan="5"><p class="f-12"><?php echo $info['nombre']." ".$info['paterno']." ".$info['materno']; ?></p></td>
					</tr>
				</table>
			</div><br><br>
		<?php
		} 
		//* Empleos
		if($secciones['lleva_empleos'] == 1){
			if($secciones['id_empleos'] == 55){
				if($laborales){ ?>
					<p class="center f-18">Antecedentes Laborales </p>
					<?php 
					foreach($laborales as $ref){ ?>
						<div class="div_datos">
							<table class="">
								<tr>
									<td class="encabezado center"><p class="f-12">Nombre de la empresa</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['empresa']; ?></p></td>
									<td class="encabezado center"><p class="f-12">Área o Departamento</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['area']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Domicilio, calle y número</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['calle']; ?></p></td>
									<td class="encabezado center"><p class="f-12">Colonia</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['colonia']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Código postal</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['cp']; ?></p></td>
									<td class="encabezado center"><p class="f-12">Teléfono</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['telefono']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Tipo de empresa</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['tipo_empresa']; ?></p></td>
									<td class="encabezado center"><p class="f-12">Puesto desempeñado</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['puesto']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Periodo trabajado, mes y año</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['periodo']; ?></p></td>
									<td class="encabezado center"><p class="f-12">Nombre del último jefe</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['jefe_nombre']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Puesto del último jefe</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['jefe_puesto']; ?></p></td>
									<td class="encabezado center"><p class="f-12">Sueldo mensual inicial</p></td>
									<td class="center"><p class="f-12"><?php echo "$ ".$ref['sueldo_inicial']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Sueldo mensual final</p></td>
									<td class="center"><p class="f-12"><?php echo "$ ".$ref['sueldo_final']; ?></p></td>
									<td class="encabezado center"><p class="f-12">¿En qué consistía su trabajo?</p></td>
									<td class="center"><p class="f-12"><?php echo $ref['actividades']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Causa de separación</p></td>
									<td class="center" colspan="3"><p class="f-12"><?php echo $ref['causa_separacion']; ?></p></td>
								</tr>
							</table>
						</div><br>
						<p class="f-14 center">Tabla de Rendimiento</p><br>
						<div class="div_datos">
							<table class="">
								<tr>
									<th class="encabezado w-60">Características Analizadas</th>
									<th class="encabezado">Calificación</th>
								</tr>
								<?php 
								if($ref['trabajo_calidad'] == "No proporciona" && $ref['trabajo_puntualidad'] == "No proporciona" && $ref['trabajo_honesto'] == "No proporciona" && $ref['trabajo_responsabilidad'] == "No proporciona" && $ref['trabajo_adaptacion'] == "No proporciona" && $ref['trabajo_actitud_jefes'] == "No proporciona" && $ref['trabajo_actitud_companeros'] == "No proporciona"){
									echo '<tr>
												<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
												<td class="center" rowspan="7"><p class="f-12">No proporciona</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
											</tr>';
								}
								else{
									if($ref['trabajo_calidad'] == "Excelente" && $ref['trabajo_puntualidad'] == "Excelente" && $ref['trabajo_honesto'] == "Excelente" && $ref['trabajo_responsabilidad'] == "Excelente" && $ref['trabajo_adaptacion'] == "Excelente" && $ref['trabajo_actitud_jefes'] == "Excelente" && $ref['trabajo_actitud_companeros'] == "Excelente"){
										echo '<tr>
												<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
												<td class="center" rowspan="7"><p class="f-12">Excelente</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
											</tr>
											<tr>
												<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
											</tr>';
									}
									else{
										if($ref['trabajo_calidad'] == "Bueno" && $ref['trabajo_puntualidad'] == "Bueno" && $ref['trabajo_honesto'] == "Bueno" && $ref['trabajo_responsabilidad'] == "Bueno" && $ref['trabajo_adaptacion'] == "Bueno" && $ref['trabajo_actitud_jefes'] == "Bueno" && $ref['trabajo_actitud_companeros'] == "Bueno"){
											echo '<tr>
													<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
													<td class="center" rowspan="7"><p class="f-12">Bueno</p></td>
												</tr>
												<tr>
													<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
												</tr>
												<tr>
													<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
												</tr>
												<tr>
													<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
												</tr>
												<tr>
													<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
												</tr>
												<tr>
													<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
												</tr>
												<tr>
													<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
												</tr>';
										}
										else{
											if($ref['trabajo_calidad'] == "Regular" && $ref['trabajo_puntualidad'] == "Regular" && $ref['trabajo_honesto'] == "Regular" && $ref['trabajo_responsabilidad'] == "Regular" && $ref['trabajo_adaptacion'] == "Regular" && $ref['trabajo_actitud_jefes'] == "Regular" && $ref['trabajo_actitud_companeros'] == "Regular"){
												echo '<tr>
														<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
														<td class="center" rowspan="7"><p class="f-12">Regular</p></td>
													</tr>
													<tr>
														<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
													</tr>
													<tr>
														<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
													</tr>
													<tr>
														<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
													</tr>
													<tr>
														<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
													</tr>
													<tr>
														<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
													</tr>
													<tr>
														<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
													</tr>';
											}
											else{
												if($ref['trabajo_calidad'] == "Insuficiente" && $ref['trabajo_puntualidad'] == "Insuficiente" && $ref['trabajo_honesto'] == "Insuficiente" && $ref['trabajo_responsabilidad'] == "Insuficiente" && $ref['trabajo_adaptacion'] == "Insuficiente" && $ref['trabajo_actitud_jefes'] == "Insuficiente" && $ref['trabajo_actitud_companeros'] == "Insuficiente"){
													echo '<tr>
															<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
															<td class="center" rowspan="7"><p class="f-12">Insuficiente</p></td>
														</tr>
														<tr>
															<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
														</tr>
														<tr>
															<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
														</tr>
														<tr>
															<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
														</tr>
														<tr>
															<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
														</tr>
														<tr>
															<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
														</tr>
														<tr>
															<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
														</tr>';
												}
												else{
													if($ref['trabajo_calidad'] == "Muy mal" && $ref['trabajo_puntualidad'] == "Muy mal" && $ref['trabajo_honesto'] == "Muy mal" && $ref['trabajo_responsabilidad'] == "Muy mal" && $ref['trabajo_adaptacion'] == "Muy mal" && $ref['trabajo_actitud_jefes'] == "Muy mal" && $ref['trabajo_actitud_companeros'] == "Muy mal"){
														echo '<tr>
																<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
																<td class="center" rowspan="7"><p class="f-12">Muy mal</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
															</tr>';
													}
													else{
														echo '<tr>
																<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_calidad'].'</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_puntualidad'].'</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_honesto'].'</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_responsabilidad'].'</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_adaptacion'].'</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_actitud_jefes'].'</p></td>
															</tr>
															<tr>
																<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
																<td class="center"><p class="f-12">'.$ref['trabajo_actitud_companeros'].'</p></td>
															</tr>';
													}
												}
											}
										}
									}
								}
								?>
							</table>
						</div>
						<div class="div_datos">
							<table class="">
								<tr>
									<td class="encabezado w-60">Comentarios y Observaciones</td>
									<td class="center"><?php echo $ref['comentarios']; ?></td>
								</tr>
							</table>
						</div>
						<pagebreak>
				<?php
					}
				}
			}
		}
		//* Trabajos no mencionados
		if($secciones['lleva_no_mencionados']== 1 && $nom != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Trabajos No Mencionados</p>
				<table class="">
					<tr>
						<td class="center w-20">No Mencionados </td>
						<td class="encabezado"><p class="f-12"><?php echo $nom[0]['no_mencionados'] ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Resultado </td>
						<td class="center"><p class="f-12"><?php echo $nom[0]['resultado_no_mencionados']; ?></p></td>		    	
					</tr>
				</table><br><br>
				<table class="">
					<tr>
						<td class="center w-20">Notas </td>
						<td class="encabezado" colspan="2"><p class="f-12"><?php echo $nom[0]['notas_no_mencionados']; ?></p></td>
					</tr>
				</table><br><br>
			</div>
		<?php 
		}
    //* Salto de pagina si no hay laborales
    if(empty($laborales) || (!empty($nom) && str_word_count($nom[0]['resultado_no_mencionados']) > 400)){
      echo '<pagebreak>';
    }
		//* Conclusion
		if($secciones['tipo_conclusion'] == 4 && $finalizado != null){ ?>
      <div class="div_datos">
        <p class="center f-18">Conclusión</p>
        <p class="f-14 center">Personal</p>
        <table class="">
          <tr>
            <td class="center"><p class="f-12"><?php echo $finalizado['descripcion_personal1']; ?></p></td>
          </tr>
        </table>
        <p class="f-14 center">Laboral</p>
        <table class="">
          <tr>
            <td class="center"><p class="f-12"><?php echo $finalizado['descripcion_laboral1']; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado"><p class="f-12"><?php echo $finalizado['descripcion_laboral2']; ?></p></td>		    	
          </tr>
        </table>
      </div>
    <?php 
    }
		//* Documentos
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 8){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Aviso de privacidad </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="750">'; ?>
					</div>
				<?php
				}
			}
			//* Anexos
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 9){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Comprobante de historial laboral </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 13){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Carta laboral </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 23){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Evidencia de correo </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 24){ ?>
					<pagebreak>
					<div class="center sin-flotar margen-top">
						<p class="f-20">Evidencia de chat </p>
					</div>
					<div class="center">
						<?php echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'">'; ?>
					</div>
				<?php
				}
			}
		}
	}
	?>
<!-- Tipo PDF 3 -->


<!-- Tipo PDF 4 -->
  <?php 
	if($secciones['tipo_pdf'] == 4){
		//* Datos Generales
		if($secciones['id_seccion_datos_generales'] == 28 && $info['edad']!= null){ ?>
			<div class="div_datos">
				<p class="center f-18">Datos Personales</p>
				<table class="">
						<tr>
							<td class="encabezado">Nombre del aspirante:</td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $info['nombre']." ".$info['paterno']." ".$info['materno']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Puesto que solicita:</td>
							<td class="center"><p class="f-12"><?php echo $info['puestoSeleccionado']; ?></p></td>
							<td class="encabezado w-17">Fecha de Nacimiento:</td>
							<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
              <td class="encabezado">Edad:</td>
							<td class="center"><p class="f-12"><?php echo $info['edad'] ?></p></td>
						</tr>
						<tr>
              <td class="encabezado">Nacionalidad:</td>
							<td class="center"><p class="f-12"><?php echo $info['nacionalidad']; ?></p></td>
							<td class="encabezado">Género:</td>
							<td class="center"><p class="f-12"><?php echo $info['genero']; ?></p></td>
							<td class="encabezado">Estado civil:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado_civil']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Domicilio (calle, número exterior e interior):</td>
							<td class="center"><p class="f-12"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior']; ?></p></td>
							<td class="encabezado">Entre la calle de:</td>
							<td class="center"><p class="f-12"><?php echo $entre = ($info['entre_calles'] == "")? "No proporciona":$info['entre_calles']; ?></p></td>
							<td class="encabezado">Colonia:</td>
							<td class="center"><p class="f-12"><?php echo $info['colonia'] ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Ciudad:</td>
							<td class="center"><p class="f-12"><?php echo$info['municipio']; ?></p></td>
							<td class="encabezado">Estado:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado']; ?></p></td>
							<td class="encabezado">Código postal:</td>
							<td class="center"><p class="f-12"><?php echo $info['cp']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Teléfono de casa:</td>
							<td class="center"><p class="f-12"><?php echo $tel_casa = ($info['telefono_casa'] == "")? "No proporciona":$info['telefono_casa']; ?></p></td>
              <td class="encabezado">Otro teléfono:</td>
						  <td class="center"><p class="f-12"><?php echo $tel_otro = ($info['telefono_otro'] == "")? "No proporciona":$info['telefono_otro']; ?></p></td>
							<td class="encabezado">Teléfono celular:</td>
							<td class="center"><p class="f-12"><?php echo $info['celular']; ?></p></td>
						</tr>
            <tr>
              <td class="encabezado">Grado máximo de estudios:</td>
							<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
							<td class="encabezado">Correo:</td>
							<td class="center"><p class="f-12"><?php echo $correo = ($info['correo']= "")? "No proporciona":$info['correo']; ?></p></td>
              <td class="encabezado">Tiempo en el domicilio actual:</td>
						  <td class="center"><p class="f-12"><?php echo $info['tiempo_dom_actual']; ?></p></td>
						</tr>
            <tr>
              <td class="encabezado">Tiempo de traslado a la oficina:</td>
              <td class="center"><p class="f-12"><?php echo $info['tiempo_traslado']; ?></p></td>
              <td class="encabezado">Medio de transporte:</td>
              <td class="center"><p class="f-12"><?php echo $info['tipo_transporte']; ?></p></td>
							<?php 
							if($info['tipo_sanguineo'] != NULL && $info['tipo_sanguineo'] != ''){ ?>
								<td class="encabezado">Tipo sanguíneo:</td>
								<td class="center"><p class="f-12"><?php echo $info['tipo_sanguineo']; ?></p></td>
							<?php 
							} ?>
            </tr>
				</table>
			</div>
    <?php  
    }
    //* Contactos del mismo trabajo
		if($secciones['lleva_empleos'] == 1 && $contacto_trabajo != null){
			if($secciones['id_empleos'] == 32){ ?>
				<div class="div_datos">
					<p class="center f-18">Familiares o amigos trabajando en <?php echo $info['cliente']; ?></p>
					<?php 
					if($contacto_trabajo){ 
						foreach($contacto_trabajo as $row){ ?>
							<table class="">
								<tr>
									<th class="encabezado">Nombre</th>
									<th class="encabezado">Puesto</th>
								</tr>
								<tr>
									<td class="center"><p class="f-12"><?php echo $row['nombre'];?></p></td>
									<td class="center"><p class="f-12"><?php echo $row['puesto']; ?></p></td>
								</tr>
							</table>
						<?php
						} ?>
					<?php
					}
					else{ ?>
						<table>
							<tr>
								<td class="center"><p class="f-12">El candidato no tiene familiares, amigos o conocidos en <?php echo $info['cliente']; ?></p></td>
							</tr>
						</table>
					<?php
					} ?>
				</div><br>
        <pagebreak>
		<?php
			} 
		} 
		//* Empleos
		if($secciones['lleva_empleos'] == 1){
			if($secciones['id_empleos'] == 32){
				if($empleos){ 
					$cont = 1; ?>
					<div class="div_datos">
						<p class="center f-18">Referencias laborales </p>
						<?php
						foreach($empleos as $row){
							$ver_laboral = $this->candidato_laboral_model->getVerificacionLaboralByNumber($cont, $info['id']); ?>
							<table class="">
								<tr>
									<th class="encabezado"></th>
									<th class="encabezado">Candidato</th>
									<th class="encabezado">Compañía</th>
									<th class="encabezado">Referencias</th>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Compañía</p></td>
									<td class="center"><p class="f-12"><?php echo $row['empresa']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $vivienda['empresa'] ?></p></td>
									<td class="left w-30" rowspan="12"><p class="f-12"><?php echo $vivienda['notas']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Dirección</p></td>
									<td class="center"><p class="f-12"><?php echo $row['direccion'] ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['direccion']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Fecha de entrada</p></td>
									<td class="center"><p class="f-12"><?php echo $entrada_laboral = $row['fecha_entrada_txt']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $entrada_verifica = $ver_laboral['fecha_entrada_txt']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Fecha de salida</p></td>
									<td class="center"><p class="f-12"><?php echo $salida_laboral = $row['fecha_salida_txt']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $salida_verifica = $ver_laboral['fecha_salida_txt']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Teléfono</p></td>
									<td class="center"><p class="f-12"><?php echo $row['telefono']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['telefono']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Puesto inicial</p></td>
									<td class="center"><p class="f-12"><?php echo $row['puesto1']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['puesto1']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Puesto final</p></td>
									<td class="center"><p class="f-12"><?php echo $row['puesto2'];?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['puesto2']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Salario inicial</p></td>
									<td class="center"><p class="f-12"><?php echo $row['salario1_txt']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['salario1_txt']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Salario final</p></td>
									<td class="center"><p class="f-12"><?php echo $row['salario2_txt']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['salario2_txt']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Jefe inmediato</p></td>
									<td class="center"><p class="f-12"><?php echo $row['jefe_nombre']."<br>".$row['jefe_correo']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['jefe_nombre']."<br>".$ver_laboral['jefe_correo']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Puesto del jefe inmediato</p></td>
									<td class="center"><p class="f-12"><?php echo $row['jefe_puesto']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['jefe_puesto']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Motivo de separación</p></td>
									<td class="center"><p class="f-12"><?php echo $row['causa_separacion']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['causa_separacion']; ?></p></td>
								</tr>
							</table>
							<p class="f-14 center">Características del candidato</p><br>
							<div class="div_datos">
								<table class="">
									<tr>
										<td class="encabezado right" width="35%"><p class="f-12"><b>Fortalezas o cualidades del candidato</b></p></td>
										<td class="center" colspan="3"><p class="f-11"><b><?php echo $ver_laboral['cualidades']; ?></b></p></td>
									</tr>
									<tr>
										<td class="encabezado right" width="35%"><p class="f-12"><b>Áreas a mejorar del candidato</b></p></td>
										<td class="center" colspan="3"><p class="f-11"><b><?php echo $ver_laboral['mejoras']; ?></b></p></td>
									</tr>
								</table>
							</div>
							<pagebreak>
							<?php
							$cont++; 
						} ?>
					</div><br>
				<?php
				}
			}
		}
		//* GAPS
		if($secciones['lleva_gaps']== 1 && $gaps != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Periodos inactivos laborales</p>
				<table class="">
					<tr>
						<th class="encabezado">Desde</th>
						<th class="encabezado">Hasta</th>
						<th class="encabezado" width="40%">Motivo/Razón</th>
					</tr>
					<?php 
					if($gaps){
						foreach($gaps as $g){ ?>
							<tr>
								<td class="center"><p class="f-12"><?php echo $g['fecha_inicio']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $g['fecha_fin']; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $g['razon']; ?></p></td>

							</tr>
					<?php
						}
					} ?>
				</table>
			</div>
		<?php 
		}
		//* Trabajos no mencionados
		if($secciones['lleva_no_mencionados']== 1 && $nom != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Trabajos No Mencionados</p>
				<table class="">
					<tr>
						<td class="center w-20">No Mencionados </td>
						<td class="encabezado"><p class="f-12"><?php echo $nom[0]['no_mencionados'] ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Resultado </td>
						<td class="center"><p class="f-12"><?php echo $nom[0]['resultado_no_mencionados']; ?></p></td>		    	
					</tr>
				</table><br>
				<table class="">
					<tr>
						<td class="center w-20">Notas </td>
						<td class="encabezado" colspan="2"><p class="f-12"><?php echo $nom[0]['notas_no_mencionados']; ?></p></td>
					</tr>
				</table>
			</div>
		<?php 
		}
		//* Preguntas laborales
		if($secciones['lleva_empleos'] == 1 && $info['trabajo_enterado']  != null && $info['trabajo_enterado']  != '' && $info['trabajo_gobierno']  != null && $info['trabajo_gobierno']  != ''){ ?>
			<div class="div_datos">
				<p class="center f-18">¿Cómo se enteró del trabajo en <?php echo $info['cliente']; ?> </p>
				<table>
					<tr>
						<td class="center"><p class="f-12"><?php echo $info['trabajo_enterado'] ; ?></p></td>
					</tr>
				</table>
			</div><br>
			<div class="div_datos">
				<p class="center f-18">¿El candidato ha trabajado en alguna entidad de gobierno, partido político u ONG? </p>
				<table>
					<tr>
						<td class="center"><p class="f-12"><?php echo $info['trabajo_gobierno'] ; ?></p></td>
					</tr>
				</table>
			</div>
      <pagebreak>
		<?php 
		}
		//* Conclusion
		if($secciones['tipo_conclusion'] == 6 && $finalizado != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Conclusión de la Investigación</p><br>
			</div>
			<p class="left f-12"><?php echo $finalizado['descripcion_personal1']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_personal2']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_personal3']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_personal4']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_laboral1']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_laboral2']; ?></p>
	  <?php 
		}  
    //* Documentos
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Aviso de privacidad</h2>';
					echo '<img class="img-aviso" src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
		}
		?>
		<?php 
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 9){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Semanas laborales cotizadas </h2>';
					echo '<img class="img-aviso" src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
		}
		?>
		<?php 
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 13){
          echo '<pagebreak>';
          echo '<div class="center">';
					echo '<h2>Carta de recomendación</h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="770"><br><br><br><br><br>';
					echo '</div>';
				}
			}
		}
	} ?>
<!-- Fin Tipo PDF 4 -->


<!-- Tipo PDF 5 -->
  <?php 
	if($secciones['tipo_pdf'] == 5){
		//* Datos Generales
		if($secciones['id_seccion_datos_generales'] == 28 && $info['edad']!= null){ ?>
			<div class="div_datos">
				<p class="center f-18">Datos Personales</p>
				<table class="">
						<tr>
							<td class="encabezado">Nombre del aspirante:</td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $info['nombre']." ".$info['paterno']." ".$info['materno']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Puesto que solicita:</td>
							<td class="center"><p class="f-12"><?php echo $info['puestoSeleccionado']; ?></p></td>
							<td class="encabezado w-17">Fecha de Nacimiento:</td>
							<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
              <td class="encabezado">Edad:</td>
							<td class="center"><p class="f-12"><?php echo $info['edad'] ?></p></td>
						</tr>
						<tr>
              <td class="encabezado">Nacionalidad:</td>
							<td class="center"><p class="f-12"><?php echo $info['nacionalidad']; ?></p></td>
							<td class="encabezado">Género:</td>
							<td class="center"><p class="f-12"><?php echo $info['genero']; ?></p></td>
							<td class="encabezado">Estado civil:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado_civil']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Domicilio (calle, número exterior e interior):</td>
							<td class="center"><p class="f-12"><?php echo $info['calle'].' '.$info['exterior'].' '.$info['interior']; ?></p></td>
							<td class="encabezado">Entre la calle de:</td>
							<td class="center"><p class="f-12"><?php echo $entre = ($info['entre_calles'] == "")? "No proporciona":$info['entre_calles']; ?></p></td>
							<td class="encabezado">Colonia:</td>
							<td class="center"><p class="f-12"><?php echo $info['colonia'] ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Ciudad:</td>
							<td class="center"><p class="f-12"><?php echo$info['municipio']; ?></p></td>
							<td class="encabezado">Estado:</td>
							<td class="center"><p class="f-12"><?php echo $info['estado']; ?></p></td>
							<td class="encabezado">Código postal:</td>
							<td class="center"><p class="f-12"><?php echo $info['cp']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Teléfono de casa:</td>
							<td class="center"><p class="f-12"><?php echo $tel_casa = ($info['telefono_casa'] == "")? "No proporciona":$info['telefono_casa']; ?></p></td>
              <td class="encabezado">Otro teléfono:</td>
						  <td class="center"><p class="f-12"><?php echo $tel_otro = ($info['telefono_otro'] == "")? "No proporciona":$info['telefono_otro']; ?></p></td>
							<td class="encabezado">Teléfono celular:</td>
							<td class="center"><p class="f-12"><?php echo $info['celular']; ?></p></td>
						</tr>
            <tr>
              <td class="encabezado">Grado máximo de estudios:</td>
							<td class="center"><p class="f-12"><?php echo $info['grado_estudio']; ?></p></td>
							<td class="encabezado">Correo:</td>
							<td class="center"><p class="f-12"><?php echo $correo = ($info['correo']= "")? "No proporciona":$info['correo']; ?></p></td>
              <td class="encabezado">Tiempo en el domicilio actual:</td>
						  <td class="center"><p class="f-12"><?php echo $info['tiempo_dom_actual']; ?></p></td>
						</tr>
            <tr>
              <td class="encabezado">Tiempo de traslado a la oficina:</td>
              <td class="center"><p class="f-12"><?php echo $info['tiempo_traslado']; ?></p></td>
              <td class="encabezado">Medio de transporte:</td>
              <td class="center"><p class="f-12"><?php echo $info['tipo_transporte']; ?></p></td>
							<?php 
							if($info['tipo_sanguineo'] != NULL && $info['tipo_sanguineo'] != ''){ ?>
								<td class="encabezado">Tipo sanguíneo:</td>
								<td class="center"><p class="f-12"><?php echo $info['tipo_sanguineo']; ?></p></td>
							<?php 
							} ?>
            </tr>
				</table>
			</div>
    <?php  
    }
		//* Documentacion
		if($secciones['id_seccion_verificacion_docs'] == 34){
			if($verDoc != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Documentos</p>
					<table class="">
						<tr>
							<th class="encabezado">CONCEPTO</th>
							<th class="encabezado">NÚMERO DE DOCUMENTO</th>
							<th class="encabezado">DATO / INSTITUCIÓN</th>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Número de Seguridad Social (NSS)</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->imss; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->imss_institucion; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Comprobante de domicilio</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->domicilio; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->fecha_domicilio; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">RFC con homoclave</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->rfc; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->rfc_institucion; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">ID (INE, IFE o pasaporte)</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc['ine']; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc['ine_institucion']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">CURP</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->curp; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->curp_institucion; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Licencia para conducir</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc['licencia'] ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc['licencia_institucion']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Carta de recomendación</p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->carta_recomendacion; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $verDoc->carta_recomendacion_institucion; ?></p></td>
						</tr>
					</table>
				</div>
				<pagebreak>
			<?php 
			}
		}
		//* Social
		if($secciones['lleva_sociales'] == 1){
			if($secciones['id_seccion_social'] == 30 && $sociales != null){ ?>
				<div class="div_datos">
					<p class="center f-18">Antecedentes Sociales</p>
					<table class="">
						<tr>
							<td class="encabezado w-25">¿Qué religión profesa?  </td>
							<td class="center"><p class="f-12"><?php echo $secciones['religion']; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $secciones['religion_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Ingiere bebidas alcohólicas? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($secciones['bebidas'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia? </td>
							<td class="center"><p class="f-12"><?php echo $secciones['bebidas_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Acostumbra fumar?  </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales[0]['fumar'] == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['fumar_frecuencia']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Ha tenido alguna intervención quirúrgica? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['cirugia']; ?></p></td>
							<td class="encabezado w-25">¿Antecedentes de enfermedades en su familia directa? </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['enfermedades']; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Cuáles son sus planes a corto plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['corto_plazo']; ?></p></td>
							<td class="encabezado w-25">¿Cuáles son sus planes a mediano plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales[0]['mediano_plazo']; ?></p></td>
						</tr>
					</table>
				</div>
			<?php 
			} 
		}  
		//* Familiar
		if($secciones['lleva_familiares'] == 1 && $familia != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Datos del Grupo Familiar</p>
				<table class="">
					<tr>
						<th class="encabezado">NOMBRE</th>
						<th class="encabezado">PARENTESCO</th>
						<th class="encabezado">EDAD</th>
						<th class="encabezado">ESTADO CIVIL</th>
						<th class="encabezado">ESCOLARIDAD</th>
						<th class="encabezado">VIVE CON USTED</th>
					</tr>
					<?php $salida = '';
					if($familia){
						foreach($familia as $f){
							$salida .= '<tr>';
							$salida .= '<td class="center w-40"><p class="f-12">'.$f['nombre'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['parentesco'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['edad'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['estado_civil'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['escolaridad'].'</p></td>';
							$salida .= ($f['misma_vivienda'] == 1) ? '<td class="center"><p class="f-12">Sí</p></td>' : '<td class="center"><p class="f-12">No</p></td>';
							$salida .= '</tr>';
						}
					}
					else{
						$salida2 .= '<tr>';
						$salida2 .= '<td class="center" colspan="4"><p class="f-12">El candidato vive solo</p></td>';
						$salida2 .= '</tr>';
					}
					echo $salida;
					?>
				</table>
			</div>
			<div class="div_datos">
				<p class="center f-18">Antecedentes Laborales del Grupo Familiar</p>
				<table class="">
					<tr>
						<th class="encabezado">NOMBRE</th>
						<th class="encabezado">EMPRESA / CIUDAD</th>
						<th class="encabezado">PUESTO</th>
						<th class="encabezado">ANTIGÜEDAD</th>
					</tr>
					<?php $salida = '';
					if($familia){
						foreach($familia as $f){
							$salida .= '<tr>';
							$salida .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['empresa'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['puesto'].'</p></td>';
							$salida .= '<td class="center"><p class="f-12">'.$f['antiguedad'].'</p></td>';
							$salida .= '</tr>';
						}
					}
					else{
						$salida2 .= '<tr>';
						$salida2 .= '<td class="center" colspan="4"><p class="f-12">El candidato vive solo</p></td>';
						$salida2 .= '</tr>';
					}
					echo $salida;
					?>
				</table>
			</div>
		<?php
		} 
		//* Contactos del mismo trabajo
		if($secciones['lleva_empleos'] == 1 && $contacto_trabajo != null){
			if($secciones['id_empleos'] == 32){ ?>
				<div class="div_datos">
					<p class="center f-18">Familiares o amigos trabajando en <?php echo $info['cliente']; ?></p>
					<?php 
					if($contacto_trabajo){ 
						foreach($contacto_trabajo as $row){ ?>
							<table class="">
								<tr>
									<th class="encabezado">Nombre</th>
									<th class="encabezado">Puesto</th>
								</tr>
								<tr>
									<td class="center"><p class="f-12"><?php echo $row['nombre'];?></p></td>
									<td class="center"><p class="f-12"><?php echo $row['puesto']; ?></p></td>
								</tr>
							</table>
						<?php
						} ?>
					<?php
					}
					else{ ?>
						<table>
							<tr>
								<td class="center"><p class="f-12">El candidato no tiene familiares, amigos o conocidos en <?php echo $info['cliente']; ?></p></td>
							</tr>
						</table>
					<?php
					} ?>
				</div><br>
        <pagebreak>
		<?php
			} 
		} 
		//* Finanzas y bienes
    if($secciones['lleva_familiares'] == 1 && $secciones['lleva_egresos']== 1 && $secciones['id_finanzas'] == 36 && $familia != null){ ?>
      <div class="div_datos">
        <p class="center f-18">Situación Económica</p>
        <table class="">
          <tr>
            <th class="encabezado" colspan="3">INGRESOS MENSUALES</th>
          </tr>
          <tr>
            <th class="encabezado">NOMBRE</th>
            <th class="encabezado">SUELDO</th>
            <th class="encabezado">APORTACIÓN</th>
          </tr>
          <?php $salida2 = '';
          if($familia){
            if($numFamiliares > 1){
              foreach($familia as $f){
                $salida2 .= '<tr>';
                $salida2 .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
                $salida2 .= '<td class="center"><p class="f-12">'.$f['sueldo'].'</p></td>';
                $salida2 .= '<td class="center"><p class="f-12">'.$f['monto_aporta'].'</p></td>';
                $salida2 .= '</tr>';
              }
            }
            if($numFamiliares == 1){
              $salida2 .= '<tr>';
              $salida2 .= '<td class="center"><p class="f-12">'.$info['candidato'].'</p></td>';
              $salida2 .= '<td class="center"><p class="f-12">'.$info->ingresos.'</p></td>';
              $salida2 .= '<td class="center"><p class="f-12">'.$info->aporte.'</p></td>';
              $salida2 .= '</tr>';
            }
          }
          else{
            $salida2 .= '<tr>';
            $salida2 .= '<td class="center"><p class="f-12">'.$info['candidato'].'</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$info->ingresos.'</p></td>';
            $salida2 .= '<td class="center"><p class="f-12">'.$info->aporte.'</p></td>';
            $salida2 .= '</tr>';
            $salida2 .= '<tr>';
            $salida2 .= '<td class="center" colspan="3"><p class="f-12">El candidato vive solo</p></td>';
            $salida2 .= '</tr>';
          }
          echo $salida2;
          ?>
        </table>
        <table class="">
          <tr>
            <th class="encabezado" colspan="2">EGRESOS MENSUALES</th>
          </tr>
          <tr>
            <th class="encabezado w-25">CONCEPTOS</th>
            <th class="encabezado">MONTOS</th>
          </tr>
          <tr>
            <td class="encabezado w-40">Renta </td>
            <td class="center"><p class="f-12"><?php echo "$ ".$finanzas['renta']; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado w-40">Alimentos </td>
            <td class="center"><p class="f-12"><?php echo "$ ".$finanzas['alimentos']; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado w-40">Servicios </td>
            <td class="center"><p class="f-12"><?php echo "$ ".$finanzas['servicios']; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado w-40">Transporte </td>
            <td class="center"><p class="f-12"><?php echo "$ ".$finanzas['transporte']; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado w-40">Otros </td>
            <td class="center"><p class="f-12"><?php echo "$ ".$finanzas['otros']; ?></p></td>
            <?php $total = $finanzas['renta'] + $finanzas['alimentos'] + $finanzas['servicios'] + $finanzas['transporte'] + $finanzas['otros']; ?>
          </tr>
          <tr>
            <td class="encabezado w-40">Total </td>
            <td class="encabezado"><p class="f-12"><?php echo "$ ".$total; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado w-40">¿Cuándo los egresos son mayores a los ingresos, cómo los solventa? </td>
            <td class="center"><p class="f-12"><?php echo $finanzas['solvencia']; ?></p></td>
          </tr>
        </table>
      </div><br>
      <div class="div_datos">
        <p class="center f-18">Bienes (Muebles e Inmuebles)</p>
        <table class="">
          <tr>
            <th class="encabezado">NOMBRE DEL PROPIETARIO</th>
            <th class="encabezado">MUEBLES E INMUEBLES</th>
            <th class="encabezado">ADEUDO</th>
          </tr>
          <?php $salida3 = '';
          if($familia){
            foreach($familia as $f){
              $salida3 .= '<tr>';
              $salida3 .= '<td class="center"><p class="f-12">'.$f['nombre'].'</p></td>';
              $salida3 .= '<td class="center"><p class="f-12">'.$f['muebles'].'</p></td>';
              $salida3 .= '<td class="center"><p class="f-12">'.$res = ($f['adeudo'] == 1)? "Sí":"No".'</p></td>';
              $salida3 .= '</tr>';
            }
            if($info['muebles'] != null && $info['muebles'] != ""){
              $salida3 .= '<tr>';
              $salida3 .= '<td class="center"><p class="f-12">'.$info['candidato'].'</p></td>';
              $salida3 .= '<td class="center"><p class="f-12">'.$info['muebles'].'</p></td>';
              $salida3 .= '<td class="center"><p class="f-12">'.$res = ($info['adeudo_muebles']== 1)? "Sí":"No".'</p></td>';
            }
          }
          else{
            if($info['muebles'] != null && $info['muebles'] != ""){
              $salida3 .= '<tr>';
              $salida3 .= '<td class="center"><p class="f-12">'.$info['candidato'].'</p></td>';
              $salida3 .= '<td class="center"><p class="f-12">'.$info['muebles'].'</p></td>';
              $salida3 .= '<td class="center"><p class="f-12">'.$res = ($info['adeudo_muebles']== 1)? "Sí":"No".'</p></td>';
            }
          }
          echo $salida3;
          ?>
        </table>
      </div><br>
    <?php 
    }
    //* Brinco de hoja en caso de exceder numero de familiares
		if($numFamiliares > 3){
			echo '<pagebreak>';
		}
    //* Vivienda
    if($secciones['lleva_vivienda'] == 1 && $vivienda != null){  ?>
      <div class="div_datos">
        <p class="center f-18">Vivienda</p>
        <table class="">
          <tr>
            <td class="encabezado center w-40"><p class="f-12">TIEMPO DE RESIDENCIA EN EL DOMICILIO ACTUAL</p></td>
            <td class="center"><p class="f-12"><?php echo $vivienda['tiempo_residencia']; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center w-40"><p class="f-12">NIVEL DE ZONA</p></td>
            <td class="center"><p class="f-12"><?php echo $vivienda['zona']; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center w-40"><p class="f-12">TIPO DE VIVIENDA</p></td>
            <td class="center"><p class="f-12"><?php echo $vivienda['vivienda']; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center w-40"><p class="f-12">RECÁMARAS</p></td>
            <td class="center"><p class="f-12"><?php echo $vivienda['recamaras']; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center w-40"><p class="f-12">BAÑOS</p></td>
            <td class="center"><p class="f-12"><?php echo $vivienda['banios']; ?></p></td>		  
          </tr>
          <tr>
            <td class="encabezado center w-40"><p class="f-12">DISTRIBUCIÓN</p></td>
            <td class="center"><p class="f-12"><?php echo $vivienda['distribucion']; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center w-40"><p class="f-12">EL MOBILIARIO ES</p></td>
            <?php
            if($vivienda['calidad_mobiliario'] == 1){
              $calidad = "Buena";
              
            }
            if($vivienda['calidad_mobiliario'] == 2){
              $calidad = "Regular";
              
            }
            if($vivienda['calidad_mobiliario'] == 3){
              $calidad = "Mala";
              
            }
            ?>
            <td class="center"><p class="f-12"><?php echo $calidad; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center w-40"><p class="f-12">EL MOBILIARIO ESTÁ</p></td>
            <td class="center"><p class="f-12"><?php echo $res = ($vivienda['mobiliario'] == 1)? "Completo":"Incompleto"; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center w-40"><p class="f-12">LA VIVIENDA ES</p></td>
            <?php
            if($vivienda['tamanio_vivienda'] == 1){
              $tamano = "Amplia";
              
            }
            if($vivienda['tamanio_vivienda'] == 2){
              $tamano = "Media";
              
            }
            if($vivienda['tamanio_vivienda'] == 3){
              $tamano = "Reducida";
              
            }
            ?>
            <td class="center"><p class="f-12"><?php echo $tamano; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center w-40"><p class="f-12">CONDICIONES</p></td>
            <td class="center"><p class="f-12"><?php echo $vivienda['condiciones']; ?></p></td>
          </tr>
        </table>
      </div><br>
      <pagebreak>
    <?php 
    }
		//* Estudios
		if($secciones['id_estudios'] == 29 && $academico != null){  ?>
			<div class="div_datos">
				<p class="center f-18">Historial Académico</p>
				<table class="">
          <tr>
            <th class="encabezado">NIVEL ESCOLAR</th>
            <th class="encabezado">PERIDO</th>
            <th class="encabezado">ESCUELA</th>
            <th class="encabezado">CIUDAD</th>
            <th class="encabezado">CERTIFICADO</th>
            <th class="encabezado">PROMEDIO</th>
            
          </tr>
          <tr>
            <td class="encabezado center"><p class="f-12">Primaria</p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_periodo']; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_escuela']; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_ciudad']; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $res = ($academico['primaria_certificado'] == 1)? "Sí":"No"; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $academico['primaria_promedio']; ?></p></td>
          </tr>
          <?php 
          if($academico['secundaria_periodo'] != null && $academico['secundaria_periodo'] != ''){
          ?>
            <tr>
              <td class="encabezado center"><p class="f-12">Secundaria</p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_periodo']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_escuela']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_ciudad']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $res = ($academico['secundaria_certificado'] == 1)? "Sí":"No"; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['secundaria_promedio']; ?></p></td>
            </tr>
          <?php 
          } ?>
          <?php 
          if($academico['preparatoria_periodo'] != null && $academico['preparatoria_periodo'] != ''){
          ?>
            <tr>
              <td class="encabezado center"><p class="f-12">Bachillerato</p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_periodo']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_escuela']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_ciudad']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $res = ($academico['preparatoria_certificado'] == 1)? "Sí":"No"; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['preparatoria_promedio']; ?></p></td>
            </tr>
          <?php 
          } ?>
          <?php 
          if($academico['licenciatura_periodo'] != null && $academico['licenciatura_periodo'] != ''){
          ?>
            <tr>
              <td class="encabezado center"><p class="f-12">Licenciatura</p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_periodo']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_escuela']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_ciudad']; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $res = ($academico['licenciatura_certificado'] == 1)? "Sí":"No"; ?></p></td>
              <td class="center"><p class="f-12"><?php echo $academico['licenciatura_promedio']; ?></p></td>
            </tr>
          <?php 
          } ?>
          <tr>
            <td class="encabezado center"><p class="f-12">Seminarios / Cursos</p></td>
            <td class="center" colspan="5"><p class="f-12"><?php echo $academico['otros_certificados']; ?></p></td>
          </tr>
          
          <tr>
            <td class="encabezado center"><p class="f-12">Comentarios</p></td>
            <td class="center" colspan="5"><p class="f-12"><?php echo $academico['comentarios']; ?></p></td>
          </tr>
				</table>
			</div><br>
			<div class="div_datos">
				<p class="center f-18">Periodos escolares inactivos</p>
				<table>
					<tr>
            <td class="center"><p class="f-12"><?php echo $academico['carrera_inactivo']; ?></p></td>
          </tr>
				</table>
			</div>
      <pagebreak>
		<?php 
		} 
		//* Empleos
		if($secciones['lleva_empleos'] == 1){
			if($secciones['id_empleos'] == 32){
				if($empleos){ 
					$cont = 1; ?>
					<div class="div_datos">
						<p class="center f-18">Referencias laborales </p>
						<?php
						foreach($empleos as $row){
							$ver_laboral = $this->candidato_laboral_model->getVerificacionLaboralByNumber($cont, $info['id']); ?>
							<table class="">
								<tr>
									<th class="encabezado"></th>
									<th class="encabezado">Candidato</th>
									<th class="encabezado">Compañía</th>
									<th class="encabezado">Referencias</th>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Compañía</p></td>
									<td class="center"><p class="f-12"><?php echo $row['empresa']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $vivienda['empresa'] ?></p></td>
									<td class="left w-30" rowspan="12"><p class="f-12"><?php echo $vivienda['notas']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Dirección</p></td>
									<td class="center"><p class="f-12"><?php echo $row['direccion'] ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['direccion']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Fecha de entrada</p></td>
									<td class="center"><p class="f-12"><?php echo $entrada_laboral = $row['fecha_entrada_txt']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $entrada_verifica = $ver_laboral['fecha_entrada_txt']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Fecha de salida</p></td>
									<td class="center"><p class="f-12"><?php echo $salida_laboral = $row['fecha_salida_txt']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $salida_verifica = $ver_laboral['fecha_salida_txt']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Teléfono</p></td>
									<td class="center"><p class="f-12"><?php echo $row['telefono']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['telefono']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Puesto inicial</p></td>
									<td class="center"><p class="f-12"><?php echo $row['puesto1']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['puesto1']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Puesto final</p></td>
									<td class="center"><p class="f-12"><?php echo $row['puesto2'];?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['puesto2']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Salario inicial</p></td>
									<td class="center"><p class="f-12"><?php echo $row['salario1_txt']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['salario1_txt']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Salario final</p></td>
									<td class="center"><p class="f-12"><?php echo $row['salario2_txt']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['salario2_txt']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Jefe inmediato</p></td>
									<td class="center"><p class="f-12"><?php echo $row['jefe_nombre']."<br>".$row['jefe_correo']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['jefe_nombre']."<br>".$ver_laboral['jefe_correo']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Puesto del jefe inmediato</p></td>
									<td class="center"><p class="f-12"><?php echo $row['jefe_puesto'] ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['jefe_puesto']; ?></p></td>
								</tr>
								<tr>
									<td class="encabezado center"><p class="f-12">Motivo de separación</p></td>
									<td class="center"><p class="f-12"><?php echo $row['causa_separacion']; ?></p></td>
									<td class="center"><p class="f-12"><?php echo $ver_laboral['causa_separacion']; ?></p></td>
								</tr>
							</table>
							<p class="f-14 center">Características del candidato</p><br>
							<div class="div_datos">
								<table class="">
									<tr>
										<td class="encabezado right" width="35%"><p class="f-12"><b>Fortalezas o cualidades del candidato</b></p></td>
										<td class="center" colspan="3"><p class="f-11"><b><?php echo $ver_laboral['cualidades']; ?></b></p></td>
									</tr>
									<tr>
										<td class="encabezado right" width="35%"><p class="f-12"><b>Áreas a mejorar del candidato</b></p></td>
										<td class="center" colspan="3"><p class="f-11"><b><?php echo $ver_laboral['mejoras']; ?></b></p></td>
									</tr>
								</table>
							</div>
							<pagebreak>
							<?php
							$cont++; 
						} ?>
					</div><br>
				<?php
				}
			}
		}
		//* Trabajos no mencionados
		if($secciones['lleva_no_mencionados'] == 1 && $nom != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Trabajos No Mencionados</p>
				<table class="">
					<tr>
						<td class="center w-20">No Mencionados </td>
						<td class="encabezado"><p class="f-12"><?php echo $nom[0]['no_mencionados'] ?></p></td>
					</tr>
					<tr>
						<td class="center w-20">Resultado </td>
						<td class="center"><p class="f-12"><?php echo $nom[0]['resultado_no_mencionados']; ?></p></td>		    	
					</tr>
				</table><br>
				<table class="">
					<tr>
						<td class="center w-20">Notas </td>
						<td class="encabezado" colspan="2"><p class="f-12"><?php echo $nom[0]['notas_no_mencionados']; ?></p></td>
					</tr>
				</table>
			</div>
		<?php 
		}
		//* Preguntas laborales
		if($secciones['lleva_empleos'] == 1 && $info['trabajo_enterado']  != null && $info['trabajo_enterado']  != '' && $info['trabajo_gobierno']  != null && $info['trabajo_gobierno']  != ''){ ?>
			<div class="div_datos">
				<p class="center f-18">¿Cómo se enteró del trabajo en <?php echo $info['cliente']; ?> </p>
				<table>
					<tr>
						<td class="center"><p class="f-12"><?php echo $info['trabajo_enterado'] ; ?></p></td>
					</tr>
				</table>
			</div><br>
			<div class="div_datos">
				<p class="center f-18">¿El candidato ha trabajado en alguna entidad de gobierno, partido político u ONG? </p>
				<table>
					<tr>
						<td class="center"><p class="f-12"><?php echo $info['trabajo_gobierno'] ; ?></p></td>
					</tr>
				</table>
			</div>
		<?php 
		}
    //* Brinco de hoja en caso de exceder numero de vecinales
		if($numFamiliares >= 3){
			echo '<pagebreak>';
		}
    //* Referencias vecinales
    if($secciones['cantidad_ref_vecinales'] > 0 && $refVecinal != null){ ?>
      <div class="div_datos">
        <p class="center f-18">Referencias Vecinales</p>
          <?php $salida4 = '';
          if($refVecinal){
            foreach($refVecinal as $refvec){
              $salida4 .= '<table class=""><tr>';
              $salida4 .= '<td class="encabezado w-40"><p class="f-12">Nombre</p></td>';
              $salida4 .= '<td class="center"><p class="f-12">'.$refvec['nombre'].'</p></td>';
              $salida4 .= '</tr>';
              $salida4 .= '<tr>';
              $salida4 .= '<td class="encabezado w-40"><p class="f-12">Domicilio y Teléfono</p></td>';
              $salida4 .= '<td class="center"><p class="f-12">'.$refvec['domicilio'].' / '.$refvec['telefono'].'</p></td>';
              $salida4 .= '</tr>';
              $salida4 .= '<tr>';
              $salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Qué concepto tiene del aspirante?</p></td>';
              $salida4 .= '<td class="center"><p class="f-12">'.$refvec['concepto_candidato'].'</p></td>';
              $salida4 .= '</tr>';
              $salida4 .= '<tr>';
              $salida4 .= '<td class="encabezado w-40"><p class="f-12">¿En qué concepto tiene a la familia como vecinos?</p></td>';
              $salida4 .= '<td class="center"><p class="f-12">'.$refvec['concepto_familia'].'</p></td>';
              $salida4 .= '</tr>';
              $salida4 .= '<tr>';
              $salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Conoce el estado civil del aspirante? ¿Cuál es?</p></td>';
              $salida4 .= '<td class="center"><p class="f-12">'.$refvec['civil_candidato'].'</p></td>';
              $salida4 .= '</tr>';
              $salida4 .= '<tr>';
              $salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Tiene hijos?</p></td>';
              $salida4 .= '<td class="center"><p class="f-12">'.$refvec['hijos_candidato'].'</p></td>';
              $salida4 .= '</tr>';
              $salida4 .= '<tr>';
              $salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Sabe en dónde trabaja? </p></td>';
              $salida4 .= '<td class="center"><p class="f-12">'.$refvec['sabe_trabaja'].'</p></td>';
              $salida4 .= '</tr>';
              $salida4 .= '<tr>';
              $salida4 .= '<td class="encabezado w-40"><p class="f-12">Notas</p></td>';
              $salida4 .= '<td class="encabezado"><p class="f-12">'.$refvec['notas'].'</p></td>';
              $salida4 .= '</tr></table><br><br>';
            }
          }
          else{
            $salida4 .= '<table class=""><tr>';
            $salida4 .= '<td class="encabezado"><p class="f-12">Sin referencias vecinales</p></td>';
            $salida4 .= '</tr></table><br><br>';
          }
          echo $salida4;
          ?>		  	
      </div><br>
      <pagebreak>
      <?php 
    }
		//* Referencias personales
		if($secciones['cantidad_ref_personales']> 0 && $refPersonal != null){
			if($secciones['id_ref_personales'] == 31){ ?>
				<div class="div_datos">
					<p class="center f-18">Referencias Personales</p>
					<?php $salida2 = '';
					foreach($refPersonal as $refper){
						if($refper['recomienda'] == 0){
							$recomienda = "No";
						}
						if($refper['recomienda'] == 1){
							$recomienda = "Sí";
						}
						if($refper['recomienda'] == 2){
							$recomienda = "NA";
						}
						$sabe_donde = ($refper['sabe_trabajo'] == 1)? "Sí":"No";
						$sabe_vive = ($refper['sabe_vive'] == 1)? "Sí":"No";
						
						$salida2 .= '<table class=""><tr>';
						$salida2 .= '<td class="encabezado w-25"><p class="f-12">Nombre</p></td>';
						$salida2 .= '<td class="center"><p class="f-12">'.$refper['nombre'].'</p></td>';
						$salida2 .= '<td class="encabezado w-25"><p class="f-12">Teléfono</p></td>';
						$salida2 .= '<td class="center"><p class="f-12">'.$refper['telefono'].'</p></td>';
						$salida2 .= '</tr>';
						$salida2 .= '<tr>';
						$salida2 .= '<td class="encabezado w-25"><p class="f-12">Tiempo de conocerlo</p></td>';
						$salida2 .= '<td class="center"><p class="f-12">'.$refper['tiempo_conocerlo'].'</p></td>';
						$salida2 .= '<td class="encabezado w-25"><p class="f-12">De qué lugar conoce al candidato</p></td>';
						$salida2 .= '<td class="center"><p class="f-12">'.$refper['donde_conocerlo'].'</p></td>';
						$salida2 .= '</tr>';
						$salida2 .= '<tr>';
						$salida2 .= '<td class="encabezado"><p class="f-12">Sabe dónde trabaja el candidato</p></td>';
						$salida2 .= '<td class="center"><p class="f-12">'.$sabe_donde.'</p></td>';
						$salida2 .= '<td class="encabezado"><p class="f-12">Sabe dónde vive el candidato</p></td>';
						$salida2 .= '<td class="center"><p class="f-12">'.$sabe_vive.'</p></td>';
						$salida2 .= '</tr>';
						$salida2 .= '<tr>';
						$salida2 .= '<td class="encabezado w-25"><p class="f-12">La recomienda</p></td>';
						$salida2 .= '<td class="center" colspan="3"><p class="f-12">'.$recomienda.'</p></td>';
						$salida2 .= '</tr>';
						$salida2 .= '<tr>';
						$salida2 .= '<td class="encabezado"><p class="f-12">Comentario</p></td>';
						$salida2 .= '<td class="encabezado" colspan="3"><p class="f-12">'.$refper['comentario'].'</p></td>';
						$salida2 .= '</tr></table><br><br>';
					}
					echo $salida2;
					?>		  	
				</div><br>
				<pagebreak>
		  <?php 
			}
		}
		//* Conclusion
		if($secciones['tipo_conclusion'] == 1 && $finalizado != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Conclusión de la Investigación</p><br>
			</div>
			<p class="left f-12"><?php echo $finalizado['descripcion_personal1']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_personal2']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_personal3']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_personal4']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_socio1']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_socio2']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_laboral1']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_laboral2']; ?></p>
			<p class="left f-12"><?php echo $finalizado['descripcion_visita1']; ?></p>
	  <?php 
		}
		//* Documentos
		if($secciones['visita'] != NULL && $docs){ ?>
      <pagebreak>
			<div class="center sin-flotar margen-top">
        <h2>Fotos </h2>
			</div>
			<?php 
			if($docs){
				foreach($docs as $doc){
					if($doc['id_tipo_documento'] == 19){
						echo '<div class="center margen-top">';
						echo '<img class="foto" src="'.base_url().'_docs/'.$doc['archivo'].'">';
						echo '</div>';
					}
				}
			}
		} ?>
		<!-- Aviso de privacidad -->
		<?php 
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 8){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Aviso de privacidad</h2>';
					echo '<img class="img-aviso" src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
		}
		?>
		<!-- Semanas cotizadas -->
		<?php 
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 9){
					echo '<pagebreak>';
					echo '<div class="center">';
					echo '<h2>Semanas laborales cotizadas </h2>';
					echo '<img class="img-aviso" src="'.base_url().'_docs/'.$doc['archivo'].'">';
					echo '</div>';
				}
			}
		}
		?>
		<!-- Carta de recomendacion -->
		<?php 
		if($docs){
			foreach($docs as $doc){
				if($doc['id_tipo_documento'] == 13){
					echo '<div class="center">';
					echo '<h2>Carta de recomendación</h2>';
					echo '<img src="'.base_url().'_docs/'.$doc['archivo'].'" width="550" height="770"><br><br><br><br><br>';
					echo '</div>';
				}
			}
		}
	}?>
<!-- Fin Tipo PDF 5 -->




</body>
</html>