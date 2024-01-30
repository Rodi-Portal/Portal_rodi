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
	.f-12 { font-size: 12px; }
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
	.separador{ padding-top: 10px; }
	.bb{ border-bottom: 1px solid #e5e5e5; }
	.personal{ padding-left: 5%; padding-top: 20px;}
	.top{padding-top: 60px;}
	.pl{ padding-left: 6%; padding-top: 20px;}
	.pr{ padding-right: 2%; }
	.separador{ padding-bottom: 20px; }
	.sin-flotar{ clear: both; }
	table, th, td { border: 1px solid black; border-collapse: collapse;}
	.tabla { margin: 0 auto; width:80%; }
	th, td { padding: 5px; text-align: center; }
	.media-tabla { width: 90%; }
	.encabezado { background: #d9dadb; }
	.comentario { width: 80%; border: 1px solid gray; }
	.margen-top { margin-top: 10px; }
	.firma{ border: 2px dotted #a8a8a7; width: 60%; height: 120px; }
	.firma p { float: right !important; }
	.div_datos { margin: 0 auto; width: 100%; }
	.div_datos table { margin: 0 auto; width: 100%;}
	.div_final { margin: 0 auto; width: 80%; }
	.div_final table { margin: 0 auto; width: 100%;}
	.div-azul { background: #154c6e;  width: 100%; height: 20px; color: white; padding-left: 10px;} 
	.w-17 { width: 17%; }
	.w-30 { width: 30%; }
	.w-60 { width: 60%; }
	.img-penales { width: 370px; height: 420px; }
	.img-ife { width: 400px; height: 380px; }
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
		  	$nombreMes = str_replace($meses_ES, $meses_EN, $mes);

		  	$f_alta = $nombreMes." ".$numeroDia.", ".$anio;
		  	return $f_alta;
	  	}
		if($docs){
			foreach($docs as $d){
				$doc[] = $d->id_tipo_documento;
			}
			$doc_ofac = (in_array(11, $doc)) ? "YES" : "NO";
			$doc_oig = (in_array(17, $doc)) ? "YES" : "NO";
			$doc_ine = (in_array(3, $doc) || in_array(14, $doc) || in_array(15, $doc)) ? "YES" : "NO";
		}
		if($bgc){
			foreach($bgc as $row){
				$identidad = $row->identidad_check;
				$empleo = $row->empleo_check;
				$estudios = $row->estudios_check;
				$visita = $row->visita_check;
				$penales = $row->penales_check;
				$ofac = $row->ofac_check;
				$lab = $row->laboratorio_check;
				$medico = $row->medico_check;
				$comentario_final = $row->comentario_final;
			}
		}
		if($datos){
			foreach($datos as $d){
				$f = $d->fecha_alta;
				$f_alta = formatoEspecialFecha($f);
				$nombre = $d->nombre;
				$pat = $d->paterno;
				$mat = $d->materno;
				$status_bgc = $d->status_bgc;
				$fecha_nacimiento = $d->fecha_nacimiento;
				$edad = $d->edad;
				$celular = $d->celular;
				$telefono_casa = ($d->telefono_casa == "" || $d->telefono_casa == null) ? "N/A":$d->telefono_casa;
				$correo = $d->correo;
			}

			$e = new DateTime($f);
			$f_requested = $e->format('m/d/Y');

			//Estatus BGC y otros
			switch ($status_bgc) {
				case 0:
					$fondo = "fondo0";
					$icono = "img/iconos/bgc0.png";
					$s_bgc = "UNDEFINED";
					break;
				case 1:
					$fondo = "fondo1";
					$icono = "img/iconos/bgc1.png";
					$s_bgc = "POSITIVE";
					break;
				case 2:
					$fondo = "fondo2";
					$icono = "img/iconos/bgc2.png";
					$s_bgc = "NEGATIVE";
					break;
				case 3:
					$fondo = "fondo3";
					$icono = "img/iconos/bgc3.png";
					$s_bgc = "UNDER REVISION";
					break;
			}
		}

		if($pruebas->ofac != null && $pruebas->ofac != ''){
      $ofacTexto = $pruebas->ofac;
			$status_ofac = ($pruebas->resultado_ofac == 1)? 'Positive' : 'Negative';
			$color_ofac = ($pruebas->resultado_ofac == 1)? 'fondo1' : 'fondo2';
			$e = new DateTime($pruebas->creacion);
			$fecha_ofac = $e->format('m/d/Y'); 
		}
		else{
      $ofacTexto = '';
			$status_ofac = 'NA';
			$fecha_ofac = 'NA';
			$color_ofac = '';
		}
		if($pruebas->oig != null && $pruebas->oig != ''){
      $oigTexto = $pruebas->oig;
			$status_oig = ($pruebas->resultado_oig == 1)? 'Positive' : 'Negative';
			$color_oig = ($pruebas->resultado_oig == 1)? 'fondo1' : 'fondo2';
			$e = new DateTime($pruebas->creacion);
			$fecha_oig = $e->format('m/d/Y'); 
		}
		else{
      $oigTexto = '';
			$status_oig = 'NA';
			$fecha_oig = 'NA';
			$color_oig = '';
		}
		if($pruebas->sam != null && $pruebas->sam != ''){
      $samTexto = $pruebas->sam;
			$status_sam = ($pruebas->resultado_sam == 1)? 'Positive' : 'Negative';
			$color_sam = ($pruebas->resultado_sam == 1)? 'fondo1' : 'fondo2';
			$e = new DateTime($pruebas->creacion);
			$fecha_sam = $e->format('m/d/Y'); 
		}
		else{
      $samTexto = '';
			$status_sam = 'NA';
			$fecha_sam = 'NA';
			$color_sam = '';
		}
		if($pruebas->data_juridica != null && $pruebas->data_juridica != ''){
      $data_juridicaTexto = $pruebas->data_juridica;
			$status_data_juridica = ($pruebas->res_data_juridica == 1)? 'Positive' : 'Negative';
			$color_data_juridica = ($pruebas->res_data_juridica == 1)? 'fondo1' : 'fondo2';
			$e = new DateTime($pruebas->creacion);
			$fecha_data_juridica = $e->format('m/d/Y'); 
		}
		else{
      $data_juridicaTexto = '';
			$status_data_juridica = 'NA';
			$fecha_data_juridica = 'NA';
			$color_data_juridica = '';
		}
    if($pruebas->new_york_restricted != null && $pruebas->new_york_restricted != ''){
      $new_york_restrictedTexto = $pruebas->new_york_restricted;
			$status_new_york_restricted = ($pruebas->res_new_york_restricted == 1)? 'Positive' : 'Negative';
			$color_new_york_restricted = ($pruebas->res_new_york_restricted == 1)? 'fondo1' : 'fondo2';
			$e = new DateTime($pruebas->creacion);
			$fecha_new_york_restricted = $e->format('m/d/Y'); 
		}
		else{
      $new_york_restrictedTexto = '';
			$status_new_york_restricted = 'NA';
			$fecha_new_york_restricted = 'NA';
			$color_new_york_restricted = '';
		}
	?>
	<!-- HOJA 1 -->
	<div class="center sin-flotar">
		<p class="f-20">Background Check Report - Checklist</p>
	</div>
	<table class="tabla">
	  	<tr>
	    	<th class="encabezado" width="30%">Full Candidate Name</th>
	    	<td class="center"><p class="f-14"><b><?php echo $nombre." ".$pat." ".$mat; ?></b></p></td>
	  	</tr>
	  	<tr>
	    	<th class="encabezado" width="30%">Final BGC Status</th>
	    	<td class="center <?php echo $fondo; ?>"><p class="f-14"><?php echo $s_bgc; ?></p></td>
	  	</tr>
	</table><br><br>
	<div class="div_datos">
		<table class="media-tabla">
		  	<tr>
		    	<th class="encabezado">Check Item</th>
		    	<th class="encabezado">Status</th>
		    	<th class="encabezado">Delivery Date</th>
		  	</tr>
		  	<tr>
		  		<td>Criminal Records – OFAC</td>
		    	<td class="<?php echo $color_ofac; ?>"><p class="f-14"><?php echo $status_ofac; ?></p></td>
		    	<td><?php echo $fecha_ofac; ?></td>
		  	</tr>
	  	 	<tr>
		  		<td>Office of Inspector General – OIG</td>
		    	<td class="<?php echo $color_oig; ?>"><p class="f-14"><?php echo $status_oig; ?></p></td>
		    	<td><?php echo $fecha_oig; ?></td>
		  	</tr>
		  	<tr>
		  		<td>System for Award Management – SAM</td>
		    	<td class="<?php echo $color_sam; ?>"><p class="f-14"><?php echo $status_sam; ?></p></td>
		    	<td><?php echo $fecha_sam; ?></td>
		  	</tr>
		  	<tr>
		  		<td>Legal Information</td>
		    	<td class="<?php echo $color_data_juridica; ?>"><p class="f-14"><?php echo $status_data_juridica; ?></p></td>
		    	<td><?php echo $fecha_data_juridica; ?></td>
		  	</tr>
        <tr>
		  		<td>New York OMIG Restricted or Terminated of Excluded list</td>
		    	<td class="<?php echo $color_new_york_restricted; ?>"><p class="f-14"><?php echo $status_new_york_restricted; ?></p></td>
		    	<td><?php echo $fecha_new_york_restricted; ?></td>
		  	</tr>
		</table>	
	</div>
	<div class="center sin-flotar margen-top">
		<p class="f-20">FINAL STATEMENT</p>
	</div>
	<div class="center">
		<textarea class="comentario" rows="11"><?php echo $ofacTexto.$oigTexto.$samTexto.$data_juridicaTexto.$new_york_restrictedTexto; ?></textarea>
	</div><br><br>
	<div class="center firma centrado">
		<p class="">AUTHORIZED SIGNATURE</p>
	</div><br><br>

	<!-- HOJA 2 -->
	<div class="div_datos">
		<p class="center f-18">Personal Data</p>
		<table class="">
		  	<tr>
		    	<td class="encabezado">Name:</td>
		    	<td class="center" colspan="3"><p class="f-12"><?php echo $nombre." ".$pat." ".$mat; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">Mobile Num:</td>
		  		<td class="center"><p class="f-12">Not provided</p></td>
		  		<td class="encabezado">Home Num:</td>
		  		<td class="center"><p class="f-12">Not provided</p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">E-mail:</td>
		  		<td class="center" colspan="3"><p class="f-12">Not provided</p></td>
		  	</tr>
		</table>
	</div>
	<pagebreak>

	<?php 
	if($docs){
		foreach($docs as $d){
			if($d->id_tipo_documento == 11){
				echo '<div class="center sin-flotar margen-top">
						<p class="f-20">OFAC Verification</p>
					</div>';
				echo '<div class="center">';
				echo '<img src="'.base_url().'_docs/'.$d->archivo.'">';
			}
		}
		echo '</div>';
	}
	?>
	<div class="div_datos">
		<table class="">
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Date</p></td>
		  		<td class="encabezado center"><p class="f-12">Final Statement</p></td>
		  	</tr>
		  	<tr>
		  		<td class="center"><p class="f-12"><?php echo $fprueba = formatoEspecialFecha($pruebas->creacion); ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $pruebas->ofac; ?></p></td>
		  	</tr>
		</table>
	</div>
	<pagebreak>

	<div class="center sin-flotar margen-top">
		<p class="f-20">OIG Verification</p>
	</div>
	<?php 
	if($docs){
		echo '<div class="center">';
		foreach($docs as $d){
			if($d->id_tipo_documento == 17){
				echo '<img src="'.base_url().'_docs/'.$d->archivo.'">';
			}
		}
		echo '</div>';
	}
	?>
	<br><br>
	<div class="div_datos">
		<table class="">
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Date</p></td>
		  		<td class="encabezado center"><p class="f-12">Final Statement</p></td>
		  	</tr>
		  	<tr>
		  		<td class="center"><p class="f-12"><?php echo $fprueba = formatoEspecialFecha($pruebas->creacion); ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $pruebas->oig; ?></p></td>
		  	</tr>
		</table>
	</div>
	<pagebreak>
	<?php 
	if($docs){
		foreach($docs as $d){
			if($d->id_tipo_documento == 21){
				echo '<div class="center sin-flotar margen-top"><p class="f-20">SAM Verification</p></div>';
				echo '<div class="center">';
				echo '<img src="'.base_url().'_docs/'.$d->archivo.'">';
				echo '</div><br><br>';
				echo '<div class="div_datos">';
				echo '<table class=""><tr>';
				echo '<td class="encabezado center"><p class="f-12">Date</p></td>';  	
				echo '<td class="encabezado center"><p class="f-12">Final Statement</p></td></tr>';  	
				echo '<tr><td class="center"><p class="f-12">'.$fprueba = formatoEspecialFecha($pruebas->creacion).'</p></td>';  		
				echo '<td class="center"><p class="f-12">'.$pruebas->sam.'</p></td></tr>';  		
				echo '</table></div><pagebreak>'; 		
			}
			if($d->id_tipo_documento == 26){
				echo '<div class="center sin-flotar margen-top"><p class="f-20">Legal Information</p></div>';
				echo '<div class="center">';
				echo '<img src="'.base_url().'_docs/'.$d->archivo.'">';
				echo '</div><br><br>';
				echo '<div class="div_datos">';
				echo '<table class=""><tr>';
				echo '<td class="encabezado center"><p class="f-12">Date</p></td>';  	
				echo '<td class="encabezado center"><p class="f-12">Final Statement</p></td></tr>';  	
				echo '<tr><td class="center"><p class="f-12">'.$fprueba = formatoEspecialFecha($pruebas->creacion).'</p></td>';  		
				echo '<td class="center"><p class="f-12">'.$pruebas->data_juridica.'</p></td></tr>';  		
				echo '</table></div><br><br><br><br><br><br>'; 		
			}
      if($d->id_tipo_documento == 49){
				echo '<div class="center sin-flotar margen-top"><p class="f-20">New York OMIG Restricted or Terminated of Excluded list</p></div>';
				echo '<div class="center">';
				echo '<img src="'.base_url().'_docs/'.$d->archivo.'">';
				echo '</div><br><br>';
				echo '<div class="div_datos">';
				echo '<table class=""><tr>';
				echo '<td class="encabezado center"><p class="f-12">Date</p></td>';  	
				echo '<td class="encabezado center"><p class="f-12">Final Statement</p></td></tr>';  	
				echo '<tr><td class="center"><p class="f-12">'.$fprueba = formatoEspecialFecha($pruebas->creacion).'</p></td>';  		
				echo '<td class="center"><p class="f-12">'.$pruebas->new_york_restricted.'</p></td></tr>';  		
				echo '</table></div><br><br><br><br><br><br>'; 		
			}
		}
	}
	?>
	<div class="div_final">
		<div class="div-azul"><p class="f-10 left">VENDOR INFORMATION</p></div>
		<table class="">
		  	<tr>
		  		<td class="center"><p class="f-12"><br>
		    	<?php echo $analista->nombre; ?><br>
		    	ANALYST</p></td>
		    	<td class="center"><p class="f-12"><br>
		    	<?php echo $coordinadora->nombre; ?><br>
		    	COORDINATOR</p></td>
		    	<td class="center"><p class="f-12">RODI</td>
		  	</tr>
		</table>
	</div>
</body>
</html>