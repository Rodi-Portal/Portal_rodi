<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
</head>
<style>
	html, body{ height: 100%; }
	body { font-family: 'Arial'; font-size: 12px; }
	.col-md-2 { width: 16%; float: left; }
	.col-md-4 { width: 33%; float: left; }
	.col-md-4-2 { width: 33%; float: right; }
	.col-md-3 { width: 25%; float: left; }
	.col-md-6 { width: 48%; margin-left: 25px; float: left; }
	.col-md-6-2 { width: 48%; float: right; }
	.f-10 { font-size: 10px; }
	.f-12 { font-size: 12px; }
	.f-14 { font-size: 14px; }
	.f-16 { font-size: 16px; }
	.f-18 { font-size: 18px; }
	.f-20 { font-size: 20px; }
	.f-white { color: white; }
	.first{ height: 50px; border-bottom: 1px solid #081e26; }
	.firstSecond{ height: 50px; border-bottom: 1px solid #081e26; padding-top:1px;}
	.firstTitle{border-bottom: 1px solid #e5e5e5; padding-top: 0px; height: 20px;}
	.datos{ margin-left: 10px; margin-right: 10px;}
	.logo{ height: 50px; }
	.right{text-align: right;}
	.center{ text-align: center; }
	.left { text-align: left !important; }
	.centrado { margin: 0px auto; }
	.head{ padding-top: 0px;  }
	.title{ border-bottom: 1px solid #e5e5e5; padding-top: 5px; height: 5px; }
	h3{ font-size: 12px; }
	p{ padding-bottom: 2px; font-size: 11px; }
	.sin-flotar{ clear: both; }
	.flotar{ float: left; }
	.flotar_derecha{ float: right; }
	th, td { border: 1px solid black; border-collapse: collapse;}
	.tabla { width:100%; border: 1px solid black; border-collapse: collapse;}
	/*th { text-transform: none; }*/
	.borde-inferior { border-bottom: 1px solid gray; padding: 5px; }
	/*th, td { padding: 5px;}*/
	.media-tabla { width: 90%; }
	.encabezado { background: #d9dadb; }
	.comentario { width: 80%; border: 1px solid gray; }
	.margen-top { margin-top: 50px; }
	.firma{ border: 2px dotted #a8a8a7; width: 60%; height: 170px; }
	.firma p { float: right !important; }
	.div_datos { margin: 0 auto; width: 100%; }
	.div_datos table { margin: 0 auto; width: 100%;}
	.div_final { margin: 0 auto; width: 80%; }
	.div_final table { margin: 0 auto; width: 100%;}
	.div-azul { background: #154c6e;  width: 100%; height: 20px; color: white; padding-left: 10px;} 
	.w-10 { width: 10%; }
	.w-20 { width: 20%; }
	.w-30 { width: 30%; }
	.w-60 { width: 60%; }
	.w-80 { width: 80%; }
	.w-100 { width: 100%; }
	.foto { margin-left:-20px; }
	.texto-centrado { text-align: center;}
	.padding-5 { padding: 5px; }
  .padding-3 { padding: 3px; }
  .padding_top {padding-top: 30px;}
	
</style>
<body>
  <?php
  function formatoEspecialFecha($f){
    $numeroDia = date('d', strtotime($f));
    $dia = date('l', strtotime($f));
    $mes = date('F', strtotime($f));
    $anio = date('Y', strtotime($f));
    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);

    $f_alta = $numeroDia." de ".$nombreMes." de ".$anio;
    return $f_alta;
  }
  //Firma
  $firma = base_url().'img/'.$covid->firma;
  $qr_consulta = base_url().'_covid/'.$qr;
  ?>
  <br><br>
	<div class="right">
    <p class="f-14">ZAPOPAN, JALISCO <?php echo formatoEspecialFecha($covid->dia_orden); ?></p>
  </div>
	<div class="center">
    <p class="f-14">PRUEBA RÁPIDA DE DETECCIÓN DE ANTICUERPOS PARA <br> SARS CoV2 IgG/IgM </p>
  </div>
  <div class="left">
    <p class="f-12">Prueba rápida para la detección cualitativa de anticuerpos IgG e IgM en sangre. <br><br>Folio: <span class="borde-inferior"><?php echo $covid->orden; ?></span> <br><br>Paciente: <span  class="borde-inferior"> <?php echo $covid->nombre; ?></span> </p>
  </div>
  <br>
	<table class="tabla centrado">
		<tr>
			<th class="padding-3">RESULTADO</th>
			<th class="padding-3">IgM</th>
			<th class="padding-3">IgG</th>
			<th class="padding-3">INTERPRETACIÓN</th>
			<th class="padding-3">RECOMENDACIÓN</th>
		</tr>
    <tr>
      <td width="20%" class="texto-centrado padding-5 f-18" ><?php echo $res = ($covid->resultado == "NEGATIVO - NEGATIVO")? "<span>X</span>":""; ?> </td>
      <td width="15%" class="texto-centrado padding-5">(-) Negativo</td>
      <td width="15%" class="texto-centrado padding-5">(-) Negativo</td>
      <td class="texto-centrado padding-5">No hay evidencia de infección</td>
      <td class="texto-centrado padding-5">Continuar con cuidados generales</td>
    </tr>
    <tr>
      <td width="20%" class="texto-centrado padding-5 f-18" ><?php echo $res = ($covid->resultado == "POSITIVO - NEGATIVO")? "<span>X</span>":""; ?></td>
      <td width="15%" class="texto-centrado padding-5">(+) Positivo</td>
      <td width="15%" class="texto-centrado padding-5">(-) Negativo</td>
      <td class="texto-centrado padding-5">Infección reciente SIN anticuerpos protectores</td>
      <td class="texto-centrado padding-5">Se deberá aislar en casa 14 días y vigilar datos de oxigenación</td>
    </tr>
    <tr>
      <td width="20%" class="texto-centrado padding-5 f-18" ><?php echo $res = ($covid->resultado == "POSITIVO - POSITIVO")? "<span>X</span>":""; ?></td>
      <td width="15%" class="texto-centrado padding-5">(+) Positivo</td>
      <td width="15%" class="texto-centrado padding-5">(+) Positivo</td>
      <td class="texto-centrado padding-5">Infección reciente CON anticuerpos protectores pero todavía contagia</td>
      <td class="texto-centrado padding-5">Se deberá aislar en casa 7 días y vigilar datos de oxigenación</td>
    </tr>
    <tr>
      <td width="20%" class="texto-centrado padding-5 f-18" ><?php echo $res = ($covid->resultado == "NEGATIVO - POSITIVO")? "<span>X</span>":""; ?></td>
      <td width="15%" class="texto-centrado padding-5">(-) Negativo</td>
      <td width="15%" class="texto-centrado padding-5">(+) Positivo</td>
      <td class="texto-centrado padding-5">Infección pasada ya con anticuerpos protectores</td>
      <td class="texto-centrado padding-5">No amerita aislamiento ni tratamiento médico</td>
    </tr>
  </table>
  <br>

  <?php 
  echo $saltos = ($tipo == 'membretado')? '<br><br><br>' : ''; ?>

  <div style="width: 100%;">
    <div class="f-12" style="text-align:center; float: left; width:70%; margin-left: 60px;">
    	<?php 
    	if($tipo != 'membretado'){ ?>
    		<img width="210px" src="<?php echo $firma; ?>"><br
    	<?php 
    	} ?>
      <span><?php echo $covid->profesion_responsable.' '.$covid->responsable; ?></span><br><span>Cédula Profesional: <?php echo $covid->cedula; ?></span><br><span>Laboratorio de Análisis</span><br><span>PERINTEX SC.</span><br><span>Cédula de licencia municipal: 580386</span><br><span>REG. SSA COFEPRIS: 21040912</span><br><img width="130px" src="<?php echo base_url().'img/qr_municipal.jpeg' ?>">
    </div>
    <div style="float: left; width:20%; margin-top: 70px;">
      <img src="<?php echo $qr_consulta; ?>">
    </div>
  </div>
  <ul>
    <li>Se entrega resultados a solicitud del interesado, en caso de tener un resultado negativo, la posibilidad de contraer la infección permanece.</li>
    <li>Seguir con los cuidados de higiene, portar cubre bocas en todo momento.</li>
    <li>Lavar manos con agua y jabón constantemente.</li>
    <li>No tocas la cara ni los ojos con las manos.</li>
  </ul>
</body>
</html>