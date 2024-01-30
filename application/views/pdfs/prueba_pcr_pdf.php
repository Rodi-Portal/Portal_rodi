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
	.left { text-align: left; }
	.centrado { margin: 0px auto; }
	.head{ padding-top: 0px;  }
	.title{ border-bottom: 1px solid #e5e5e5; padding-top: 5px; height: 5px; }
	h3{ font-size: 12px; }
	p{ padding-bottom: 2px; font-size: 11px; }
	.tabla { width: 100%; border: 2px solid #a3a3a3; padding: 10px; margin: 0 auto; font-size: 14px;}
	.tabla_texto { width:90%; border: none; padding: 5px; margin: 0 auto; font-size: 14px;border-collapse: collapse;}
	.borde-inferior { border-bottom: 1px solid gray; padding: 5px; }
	/*th, td { padding: 5px;}*/
	.media-tabla { width: 90%; }
	.encabezado { background: #d9dadb; }
	.comentario { width: 80%; border: 1px solid gray; }
	.margen-top { margin-top: 20px !important; }
	.margen-bottom { margin-bottom: 20px !important; }
	.w-10 { width: 10%; }
	.w-20 { width: 20%; }
	.w-30 { width: 30%; }
	.w-60 { width: 60%; }
  .w-80 { width: 80%; }
  .w-90 { width: 90%; }
	.w-100 { width: 100%; }
	.padding-5 { padding: 5px; }
	.padding-3 { padding: 3px; }
  .dato{margin-left: 3px !important;}
  .justificado{text-align: justify;}
  td{padding-top: 8px;}
</style>
<body>
  <?php
  $f = explode('-', $covid->dia_orden);
  $fecha_toma = $f[2].'/'.$f[1].'/'.$f[0];

  $aux = explode(' ', $covid->creacion);
  $f2 = explode('-', $aux[0]);
  $fecha_registro = $f2[2].'/'.$f2[1].'/'.$f2[0].' '.$aux[1];

  $aux = explode(' ', $covid->edicion);
  $f3 = explode('-', $aux[0]);
  $fecha_resultado = $f3[2].'/'.$f3[1].'/'.$f3[0].' '.$aux[1];

  $significa = ($covid->resultado == 'NO DETECTADO')? 'NO':'SÍ';

  $longitud = strlen($covid->nombre);
  $fuente = ($longitud > 40)? 'f-10':'f-12';

  $firma = base_url().'img/'.$covid->firma;
  $qr_consulta = base_url().'_covid/'.$qr;

  ?>
	
  <br><br>
		<table class="tabla">
		  	<tr>
		    	<td width="25%" colspan="2">Paciente:&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior <?php echo $fuente;?> "><b> <?php echo $covid->nombre; ?> </b></span></td>
		    	<td width="40%">No. De Orden:&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->orden; ?> </b></span></td>
        </tr>
        <tr>
		    	<td width="40%">Edad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->edad; ?> </b></span></td>
		    	<td>Género:   <span class="dato left borde-inferior f-12"><b> <?php echo $covid->genero; ?> </b></span></td>
		    	<td>Médico:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->medico; ?> </b></span></td>
		  	</tr>
		  	<tr>
		    	<td colspan="2">Télefono:&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->telefono; ?> </b></span></td>
		    	<td>Pasaporte:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->pasaporte; ?> </b></span></td>
        </tr>
        <tr>
		    	<td colspan="2">Fecha de nacimiento:   <span class="dato left borde-inferior f-12"><b> <?php echo $covid->fecha_nacimiento; ?> </b></span></td>
		    	<td>Fecha de toma:&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $fecha_toma; ?> </b></span></td>
		  	</tr>
    </table>
    <br><br>

    <table class="tabla_texto">
      <tr>
        <td class="center" colspan="3"><span style="border-bottom: 1px solid gray;">SARS-COV-2 (COVID19) por qRT-PCR (Detección ORF1ab/N)</span></td>
      </tr>
      <tr>
        <td class="center" colspan="3"><span>PRUEBA DE REACCIÓN EN CADENA DE LA POLIMERASA (PCR)</span></td>
      </tr>
      <tr>
        <td class="center" colspan="3"><span><b>Resultado: </b></span><b><span class="f-14"> <?php echo $covid->resultado; ?> <br></span></b></td>
      </tr>
      <tr>
        <td class="center" colspan="3"><span><b>Control interno: </b></span><span class="f-14">Válido </span></td>
      </tr>
      <tr>
        <td class="left" colspan="3"><span>A partir del día 17 de abril de 2020, ya no es necesario contar con el reconocimiento del InDRE para realizar las pruebas para detección del COVID19.</span></td>
      </tr>
      <tr>
        <td class="left" colspan="3"><span>La detección del virus COVID-19 por técnicas moleculares esta condicionado al momento clínico de la enfermedad, cantidad de virus presente al instante de la detección, manejo de muestra y correcta toma, por lo que:</span></td>
      </tr>
      <tr>
        <td class="left" colspan="3"><span>Un resultado emitido como "NO DETECTADO" no es excluyente de la presencia del virus COVID-19.</span></td>
      </tr>
      <tr>
        <td class="left" colspan="3"><span>De esta manera, el médico responsable debe correlacionar la sintomatología clínica, epidemiológica y otros contextos que él (ella) indique. Esta prueba NO debe usarse como conclusiva y única para el diagnóstico, manejo o tratamiento para infección por COVID19. Todos los casos positivos a COVID19 serán notificados a la Secretaría de Salud Jalisco, para el acompañamiento epidemiológico necesario que considere la autoridad.</span></td>
      </tr>
      <tr>
        <td class="left" colspan="3"><span>La muestra examinada con folio <b><?php echo $covid->folio ?></b>, tomada el <b><?php echo $fecha_toma ?></b> con el nombre de <b><?php echo $covid->nombre ?></b> y fecha de nacimiento <b><?php echo $covid->fecha_nacimiento ?></b> fue determinada como ( <b><?php echo $covid->resultado ?></b> ), lo que significa que en la muestra examinada <b><?php echo $significa ?></b> hay evidencia de material de ARN que coincida con las secuencias de SARS-Cov-2 (COVID19) según el método de Detección ORF1ab/N </span></td>
      </tr>
    </table>
    <br><br><br><br><br><br>

    <div style="width: 100%;">
      <div style="float:left; width:30%; margin-left: 25px; padding-top:33px;">
        <img width="100px" src="<?php echo base_url().'img/qr_municipal.jpeg' ?>">
      </div>
      <div class="f-12" style="float:left; width:35%; margin-top: 45px;">
      	<span style="border-top: 1px solid gray;"><?php echo $covid->profesion_responsable.' '.$covid->responsable; ?></span><br><span>Cédula Profesional: <?php echo $covid->cedula; ?></span><br>
        <span>Laboratorio de Análisis</span><br><span>PERINTEX SC.</span><br><span>Cédula de licencia municipal: 580386</span><br><span>REG. SSA COFEPRIS: 21040912</span>
      </div>
      <div style="text-align:center; width:30%; ">
        <img width="100px" src="<?php echo $qr_consulta; ?>">
      </div>
    </div>
</body>
</html>