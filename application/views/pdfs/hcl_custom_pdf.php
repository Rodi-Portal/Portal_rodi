n</html><!DOCTYPE html>
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
	.w-17 { width: 17%; }
	.w-20 { width: 20%; }
	.w-30 { width: 30%; }
	.w-40 { width: 40%; }
	.w-50 { width: 50%; }
	.w-60 { width: 60%; }
	.w-70 { width: 70%; }
	.w-80 { width: 80%; }
	.w-90 { width: 90% !important; }
	.w-100 { width: 100% !important; }
	.img-penales { width: 370px; height: 420px; }
	.borde-derecho { border-right: 1px solid black; }
	.color-rodi { color: #255880; }
	.margen-50 {margin-left: 50% !important;}
	.flotar-derecha { float: right !important; }
	.flotar-izquierda { float: left; }
	.bordes { border-top: 1px solid gray;border-bottom: 1px solid gray; }
	.padding { padding: 3px; }
	.margin-left { margin-left: 10px !important; }
	.firma{ width: 127px; height: 200px; padding-left: 25px;}
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
				$global = $row->global_searches_check;
				$domicilios_check = $row->domicilios_check;
				$comentario_final = $row->comentario_final;
			}
			if($identidad == 0){ $f_identidad = "fondo2"; $s_identidad = "Negative"; }
			if($identidad == 1){ $f_identidad = "fondo1"; $s_identidad = "Positive"; }
			if($identidad == 2){ $f_identidad = "fondo3"; $s_identidad = "FC"; }
			if($identidad == 3){ $s_identidad = "NA"; }

			if($empleo == 0){ $f_empleo = "fondo2"; $s_empleo = "Negative"; }
			if($empleo == 1){ $f_empleo = "fondo1"; $s_empleo = "Positive"; }
			if($empleo == 2){ $f_empleo = "fondo3"; $s_empleo = "FC"; }
			if($empleo == 3){ $s_empleo = "NA"; }

			if($estudios == 0){ $f_estudios = "fondo2"; $s_estudios = "Negative"; }
			if($estudios == 1){ $f_estudios = "fondo1"; $s_estudios = "Positive"; }
			if($estudios == 2){ $f_estudios = "fondo3"; $s_estudios = "FC"; }
			if($estudios == 3){ $s_estudios = "NA"; }

			if($visita == 0){ $f_visita = "fondo2"; $s_visita = "Negative"; }
			if($visita == 1){ $f_visita = "fondo1"; $s_visita = "Positive"; }
			if($visita == 2){ $f_visita = "fondo3"; $s_visita = "FC"; }
			if($visita == 3){ $s_visita = "NA"; }

			if($penales == 0){ $f_penales = "fondo2"; $s_penales = "Negative"; }
			if($penales == 1){ $f_penales = "fondo1"; $s_penales = "Positive"; }
			if($penales == 2){ $f_penales = "fondo3"; $s_penales = "FC"; }
			if($penales == 3){ $s_penales = "NA"; }

			if($ofac == 0){ $f_ofac = "fondo2"; $s_ofac = "Negative"; }
			if($ofac == 1){ $f_ofac = "fondo1"; $s_ofac = "Positive"; }
			if($ofac == 2){ $f_ofac = "fondo3"; $s_ofac = "FC"; }
			if($ofac == 3){ $s_ofac = "NA"; }

			if($lab == 0){ $f_lab = "fondo2"; $s_lab = "Not approved"; }
			if($lab == 1){ $f_lab = "fondo1"; $s_lab = "Approved"; }
			if($lab == 2){ $f_lab = "fondo3"; $s_lab = "FC"; }
			if($lab == 3){ $s_lab = "NA"; }

			if($medico == 0){ $f_medico = "fondo2"; $s_medico = "Negative"; }
			if($medico == 1){ $f_medico = "fondo1"; $s_medico = "Positive"; }
			if($medico == 2){ $f_medico = "fondo3"; $s_medico = "FC"; }
			if($medico == 3){ $s_medico = "NA"; }

			if($global == 0){ $f_global = "fondo2"; $s_global = "Negative"; }
			if($global == 1){ $f_global = "fondo1"; $s_global = "Positive"; }
			if($global == 2){ $f_global = "fondo3"; $s_global = "FC"; }
			if($global == 3){ $s_global = "NA"; }

			if($domicilios_check == 0){ $f_dom = "fondo2"; $s_dom = "Negative"; }
			if($domicilios_check == 1){ $f_dom = "fondo1"; $s_dom = "Positive"; }
			if($domicilios_check == 2){ $f_dom = "fondo3"; $s_dom = "FC"; }
			if($domicilios_check == 3){ $s_dom = "NA"; }

			if(isset($doping)){
				$res_doping = ($doping->resultado == 0)? "Approved":"Not approved";
				if($doping->resultado == 0){ $f_doping = "fondo1"; }
				if($doping->resultado == 1){ $f_doping = "fondo2"; }
				$a = new DateTime($doping->fecha_resultado);
				$fecha_doping_res = $a->format('m/d/Y');
			}
			else{
				if($pruebas->tipo_antidoping != 0 && $pruebas->antidoping != 0){
					$res_doping = "Pending";
					$fecha_doping_res = ' - ';
				}
				else{
					$res_doping = "NA";
					$fecha_doping_res = 'NA';
				}
			}
			if(isset($fecha_ver_penales)){
				$e = new DateTime($fecha_ver_penales->fecha_finalizado);
				$fecha_ver_penales = $e->format('m/d/Y');
			}
			else{
				$fecha_ver_penales = 'NA';
			}
			if(isset($fecha_ver_documentos)){
				$e = new DateTime($fecha_ver_documentos->creacion);
				$fecha_ver_documentos = $e->format('m/d/Y');
			}
			else{
				$fecha_ver_documentos = 'NA';
			}
			if(isset($global_searches)){
				$e = new DateTime($global_searches->creacion);
				$fecha_global = $e->format('m/d/Y');
			}
			else{
				$fecha_global = 'NA';
			}

		}
		if($ver_documento){
			foreach($ver_documento as $item){
				$ine = $item->ine;
				$ine_ano = $item->ine_ano;
				$ine_vertical = $item->ine_vertical;
				$ine_institucion = $item->ine_institucion;
				$pasaporte = $item->pasaporte;
				$pasaporte_fecha = $item->pasaporte_fecha;
				$militar = $item->militar;
				$militar_fecha = $item->militar_fecha;
				$comentario_identidad = $item->comentarios;
			}
		}
		if($datos){
			foreach($datos as $d){
				$id_candidato = $d->id;
				$f = $d->fecha_alta;
				$f_alta = formatoEspecialFecha($f);
				$nombre = $d->nombre;
				$pat = $d->paterno;
				$mat = $d->materno;
				$status_bgc = $d->status_bgc;
				$fecha_nacimiento = $d->fecha_nacimiento;
				$edad = $d->edad;
				$puesto = $d->puesto;
				$nacionalidad = $d->nacionalidad;
				$genero = $d->genero;
				$calle = $d->calle;
				$ext = $d->exterior;
				$int = $d->interior;
				$colonia = $d->colonia;
				$id_estado = $d->id_estado;
				$id_municipio = $d->id_municipio;
				$cp = $d->cp;
				$celular = $d->celular;
				$telefono_casa = $d->telefono_casa;
				$telefono_otro = $d->telefono_otro;
				$correo = $d->correo;
				$id_grado_estudio = $d->id_grado_estudio;
				$estudios_periodo = $d->estudios_periodo;
				$estudios_escuela = $d->estudios_escuela;
				$estudios_ciudad = $d->estudios_ciudad;
				$estudios_certificado = $d->estudios_certificado;
				$trabajo_inactivo = $d->trabajo_inactivo;
				$trabajo_gobierno = $d->trabajo_gobierno;
			}
			//Fechas
			$hoy = formatoEspecialFecha($hoy);
			$e = new DateTime($hoy);
			$hoy2 = $e->format('m/d/Y');

			$e = new DateTime($f);
			$f_requested = $e->format('m/d/Y');

			

			//Estatus BGC y otros
			switch ($status_bgc) {
				case 0:
					$fondo = "fondo0";
					$icono = "img/iconos/bgc0.png";
					$s_bgc = "Undefined";
					break;
				case 1:
					$fondo = "fondo1";
					$icono = "img/iconos/bgc1.png";
					$s_bgc = "Positive";
					break;
				case 2:
					$fondo = "fondo2";
					$icono = "img/iconos/bgc2.png";
					$s_bgc = "Negative";
					break;
				case 3:
					$fondo = "fondo3";
					$icono = "img/iconos/bgc3.png";
					$s_bgc = "For Consideration";
					break;
			}
			
		}

	?>
	<!-- HOJA 1 -->
	<div>
		<div class="col-md-4 borde-derecho">
			<img src="<?php echo base_url().'img/logo.png' ?>" width="190px" >
		</div>
		<div class="col-md-6">
			<?php $proy = explode('Custom: ', $proyecto); ?>
			<span class="f-16 color-rodi margen-top"><b><?php echo $cliente.' - '.$proy[1]; ?></span></b><br>
			<span class="f-16 color-rodi"><b>Background Check Report - Checklist</span></b>
		</div>
	</div>
	<div class="margen-50 margen-top">
		<table class="tabla w-100">
		  	<tr>
		    	<td class="encabezado right" width="20%"><p class="f-11"><b>Release Date</b></p></td>
		    	<td class="right"><p class="f-11"><b><?php echo $fecha_bgc; ?></b></p></td>
		  	</tr>
		</table>
	</div>
	<br>
	<table class="tabla w-100">
	  	<tr>
	    	<td class="encabezado right" width="30%"><p class="f-12"><b>Full Candidate Name</b></p></td>
	    	<td class="center" colspan="3"><p class="f-11"><b><?php echo $nombre." ".$pat." ".$mat; ?></b></p></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado right" width="30%"><p class="f-12"><b>Final BGC Status</b></p></td>
	    	<?php 
	    		if($status_bgc == 1){
	    			echo '<td class="center '.$fondo.'"><p class="f-11"><b>Positive</b></p></td>';
	    			echo '<td class="center"><p class="f-11"><b>Negative</b></p></td>';
	    			echo '<td class="center"><p class="f-11"><b>For Consideration</b></p></td>';
	    		}
	    		if($status_bgc == 2){
	    			echo '<td class="center"><p class="f-11"><b>Positive</b></p></td>';
	    			echo '<td class="center '.$fondo.'"><p class="f-11"><b>Negative</b></p></td>';
	    			echo '<td class="center"><p class="f-11"><b>For Consideration</b></p></td>';
	    		}
	    		if($status_bgc == 3){
	    			echo '<td class="center"><p class="f-11"><b>Positive</b></p></td>';
	    			echo '<td class="center"><p class="f-11"><b>Negative</b></p></td>';
	    			echo '<td class="center '.$fondo.'"><p class="f-11"><b>For Consideration</b></p></td>';
	    		}
	    	?>
	  	</tr>
	  	<tr>
	    	<td class="encabezado right" width="30%"><p class="f-12"><b>Remarks</b></p></td>
	    	<td class="center" colspan="3"><p class="f-11"><?php echo $comentario_final; ?></p></td>
	  	</tr>
	</table><br>
	<div class="flotar-izquierda w-70">
		<table class="w-90">
		  	<tr>
		    	<th class="encabezado">Check Item</th>
		    	<th class="encabezado">Status</th>
		    	<th class="encabezado">Delivery Date</th>
		  	</tr>
		  	<tr>
		  		<td class="left">Identity check</td>
		    	<td class="<?php echo $f_identidad; ?>"><p class="f-14"><?php echo $s_identidad; ?></p></td>
		    	<td><?php echo $fecha_ver_documentos ?></td>
		  	</tr>
		  	<tr>
		  		<td class="left">Employment History check</td>
		    	<td class="<?php echo $f_empleo; ?>"><p class="f-14">NA</p></td>
		    	<td>NA</td>
		  	</tr>
		  	<tr>
		  		<td class="left">Academic History check</td>
		    	<td class="<?php echo $f_estudios; ?>"><p class="f-14">NA</p></td>
		    	<td>NA</td>
		  	</tr>
		  	<tr>
		  		<td class="left">Home Visit (If Applicable)</td>
		    	<td class="<?php echo $f_visita; ?>"><p class="f-14">NA</p></td>
		    	<td>NA</td>
		  	</tr>
		  	<tr>
		  		<td class="left">Criminal Records – Mexican</td>
		    	<td class="<?php echo $f_penales; ?>"><p class="f-14"><?php echo $s_penales; ?></p></td>
		    	<td><?php echo $fecha_ver_penales; ?></td>
		  	</tr>
		  	<tr>
		  		<td class="left">Criminal Records – OFAC</td>
		    	<td class="<?php echo $f_ofac; ?>"><p class="f-14"><?php echo $s_ofac; ?></p></td>
		    	<td><?php echo $fecha_ver_penales; ?></td>
		  	</tr>
		  	<tr>
		  		<td class="left">Global Database check</td>
		    	<td class="<?php echo $f_global; ?>"><p class="f-14"><?php echo $s_global; ?></p></td>
		    	<td><?php echo $fecha_global; ?></td>
		  	</tr>
		  	<tr>
		  		<td class="left">Laboratory Test (If Applicable)</td>
		    	<td class="<?php echo $f_doping; ?>"><p class="f-14"><?php echo $res_doping; ?></p></td>
		    	<td><?php echo $fecha_doping_res; ?></td>
		  	</tr>
		  	<tr>
		  		<td class="left">Medical Check Up (If Applicable)</td>
		    	<td class="<?php echo $f_medico; ?>"><p class="f-14">NA</p></td>
		    	<td>NA</td>
		  	</tr>	  	
		</table>	
	</div>
	<div class="w-30 flotar-izquierda">
		<div class="bordes">
			<h5 class="center">STATUS REPORT KEY</h5>
		</div>
		<div>
			<div class="w-30 flotar-izquierda">
				<p class="fondo1 padding f-11 center">Positive</p>
				<p  class="fondo2 padding f-11 center">Negative</p>
				<p  class="fondo3 padding f-11 center">FC</p>
				<p  class="padding f-11 center">NA</p>
			</div>
			<div class="w-60">
				<p class="f-11 margin-left"> SUITABLE FOR HIRING</p>
				<p class="f-11 margin-left"> NOT SUITABLE FOR HIRING</p>
				<p class="f-11 margin-left"> FOR CONSIDERATION</p>
				<p class="f-11 margin-left"> CRITERIA DOES NOT APPLY</p>
			</div>
		</div>
	</div>
	<br><br>
	<table class="tabla w-100">
		<tr>
	    	<th class="encabezado" colspan="2">Scope of Verification</th>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Education</b></p></td>
	    	<td class="left" width="80%"><p class="f-11">NA</p></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Employment</b></p></td>
	    	<td class="left" width="80%"><p class="f-11">NA</p></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Address</b></p></td>
	    	<?php 
			if($domicilios != null){ ?>
	    		<td class="left" width="80%"><p class="f-11">Last 7 years</p></td>
	    	<?php 
	    	}else{ ?>
	    		<td class="left" width="80%"><p class="f-11">NA</p></td>
	    	<?php
	    	}
	    	?>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Criminal</b></p></td>
	    	<?php 
			if($det_penales != null){ ?>
	    		<td class="left" width="80%"><p class="f-11">Last 7 years</p></td>
	    	<?php 
	    	}else{ ?>
	    		<td class="left" width="80%"><p class="f-11">NA</p></td>
	    	<?php
	    	}
	    	?>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Database</b></p></td>
	    	<?php 
			if($global_searches != null){ ?>
	    		<td class="left" width="80%"><p class="f-11">Database check (including SDN)</p></td>
	    	<?php 
	    	}else{ ?>
	    		<td class="left" width="80%"><p class="f-11">NA</p></td>
	    	<?php
	    	}
	    	?>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Identity</b></p></td>
	    	<?php 
			if($ver_documento != null){ ?>
	    		<td class="left" width="80%"><p class="f-11">Goverment issued ID check (Strong ID)</p></td>
	    	<?php 
	    	}else{ ?>
	    		<td class="left" width="80%"><p class="f-11">NA</p></td>
	    	<?php
	    	}
	    	?>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Military</b></p></td>
	    	<td class="left" width="80%"><p class="f-11">NA</p></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Drug test</b></p></td>
	    	<?php
	    	if(isset($doping)){
	    		$parametros = explode('x', $doping->drogas); ?>
	    		<td class="left" width="80%"><p class="f-11"><?php echo $parametros[0]." Panel Drug Test"; ?></p></td>
	    	<?php
	    	}else{ ?>
	    		<td class="left" width="80%"><p class="f-11">NA</p></td>
	    	<?php
	    	}
    	  	?>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Other</b></p></td>
	    	<td class="left" width="80%"><p class="f-11">NA</p></td>
	  	</tr>
	</table><br>
	<div class="centrado sin-flotar" style="border: 4px dashed #b8bfe6; height: 220px; width: 28%;">
		<p class="center" style="float: right;">FIRMA AUTORIZADA</p>
		<img class="firma" style="border: none;" src="<?php echo base_url().'img/firmaEstudios.jpg'; ?>">
	</div>
	
	<pagebreak>
	<!-- HOJA 2 -->
	<div class="div_datos">
		<p class="center f-18">Personal Data</p>
		<table class="">
		  	<tr>
		    	<td class="encabezado">Name:</td>
		    	<td class="center" colspan="5"><p class="f-12"><?php echo $nombre." ".$pat." ".$mat; ?></p></td>
		  	</tr>
		</table>
	</div><br><br>
	
	<?php 
	if($global_searches != null){ ?>
		<div class="div_datos">
			<p class="center f-18">Global Data Searches</p>
			<table class="">
			  	<tr>
			    	<td class="encabezado w-20">Law enforcement:</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->law_enforcement; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado w-20">Regulatory:</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->regulatory; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado w-20">Sanctions:</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->sanctions; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado w-20">Web and media searches:</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->media_searches; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado w-20">Other bodies:</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->other_bodies; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado w-20">SDN:</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->sdn; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
			  	</tr>
			</table>
		</div><br><br>
	<?php
	}
	?>
	

	<?php 
	if($ver_documento != null){ ?>
		<div class="div_datos">
			<p class="center f-18">ID check</p>
			<table class="">
			  	<tr>
			    	<th class="encabezado">Document</th>
			    	<th class="encabezado">Details</th>
			  	</tr>
			  	<?php 
			  	if($ine != ''){ ?>
			  		<tr>
				  		<td class="encabezado center w-20"><p class="f-12">ID (IFE or INE)</p></td>
				    	<td class="center"><p class="f-12"><?php echo "ID: ".$ine."<br>Register date: ".$ine_ano."<br>Vertical number: ".$ine_vertical."<br>Institution: ".$ine_institucion; ?></p></td>
				  	</tr>
			  	<?php
			  	}
			  	if($pasaporte != '' && $pasaporte_fecha != ''){ ?>
			  		<tr>
				  		<td class="encabezado center w-20"><p class="f-12">Passport</p></td>
				    	<td class="center"><p class="f-12"><?php echo "ID: ".$pasaporte."<br>Register date / Institution: ".$pasaporte_fecha; ?></p></td>
				  	</tr>
			  	<?php
			  	}
			  	if($militar != '' && $militar_fecha != ''){ ?>
			  		<tr>
				  		<td class="encabezado center w-20"><p class="f-12">Military card</p></td>
				    	<td class="center"><p class="f-12"><?php echo "ID: ".$militar."<br>Register date / Institution: ".$militar_fecha; ?></p></td>
				  	</tr>
			  	<?php
			  	}
			  	?>
			  	<tr>
			  		<td class="encabezado center"><p class="f-12">Comments</p></td>
			    	<td class="center" colspan="1"><p class="f-12"><?php echo $comentario_identidad; ?></p></td>
			  	</tr>
			</table>
		</div>
	<?php
	}
	?>


	<?php 
	if($det_penales != null){ ?>
		<div class="div_datos">
			<p class="center f-18">Criminal Records Verification</p>
			<table class="">
			  	<tr>
			  		<td class="encabezado center"><p class="f-12">Criminal Record Document requested</p></td>
			    	<td class="center"><p class="f-12"><?php echo $f_requested; ?></p></td>
			    	<td class="center" rowspan="2"><p class="f-12">Validated</p></td>

			  	</tr>
			  	<tr>
			  		<td class="encabezado center"><p class="f-12">Verification completed</p></td>
			    	<td class="center"><p class="f-12"><?php echo $fecha_ver_penales; ?></p></td>
			  	</tr>
			</table>
		</div><br>
		<div class="div_datos">
			<table>
				<?php 
			  	foreach($det_penales as $pen){
			  		$a = new DateTime($pen->fecha);
					$f_det = $a->format('m/d/Y');
			  		echo '<tr>';
			  		echo '<td class="center w-17"><p class="f-12">'.$f_det.'</p></td>';
			  		echo '<td class="center"><p class="f-12">'.$pen->comentarios.'</p></td>';
			  		echo '</tr>';
			  	}
			  	?>
			</table>
		</div>
	<?php
	}
	?>

	<?php 
	if(isset($doping)) { ?>
		<div class="div_datos">
			<p class="center f-18">Drug Test Verification</p>
			<table class="">
			  	<tr>
			  		<?php 
			  			$a = new DateTime($doping->fecha_doping);
						$fecha_doping = $a->format('m/d/Y');
						$res_doping = ($doping->resultado == 0)? "Passed":"Not passed";
						$a = new DateTime($doping->fecha_resultado);
						$fecha_doping_res = $a->format('m/d/Y');
						$parametros = explode('x', $doping->drogas);
						$descripcion_doping = ($doping->resultado == 0)? "".$parametros[0]." Panel Drug Test Passed":"".$parametros[0]." Panel Drug Test Not Passed";
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
	<?php 
	} ?>

	<?php 
	if($domicilios){ ?>
		<pagebreak>
		<div class="div_datos">
			<p class="center f-18">Address History</p>
			<?php 
			foreach($domicilios as $dom){ 
				echo '<table class="">
						<tr>
					  		<td class="encabezado">Period:</td>
					    	<td class="center"><p class="f-12">'.$dom->periodo.'</p></td>
						</tr>
						<tr>
					    	<td class="encabezado">Cause of departure:</td>
					    	<td class="center"><p class="f-12">'.$dom->causa.'</p></td>
					    </tr>
					    <tr>
					    	<td class="encabezado w-17">Address:</td>
					    	<td class="center"><p class="f-12">'.$dom->calle.'</p></td>
					    </tr>
					    <tr>
					    	<td class="encabezado w-17">Ext. Num.:</td>
					    	<td class="center"><p class="f-12">'.$dom->exterior.'</p></td>
					   	</tr>
					   	<tr>
					    	<td class="encabezado w-17">Int. Num.:</td>
					    	<td class="center"><p class="f-12">'.$dom->interior.'</p></td>
					   	</tr>
					    <tr>
					    	<td class="encabezado w-17">Neighborhood:</td>
					    	<td class="center"><p class="f-12">'.$dom->colonia.'</p></td>
					    </tr>
					    <tr>
					    	<td class="encabezado w-17">State:</td>
					    	<td class="center"><p class="f-12">'.$dom->estado.'</p></td>
					    </tr>
					    <tr>
					    	<td class="encabezado w-17">City:</td>
					    	<td class="center"><p class="f-12">'.$dom->municipio.'</p></td>
					    </tr>
					    <tr>
					    	<td class="encabezado w-17">Zip Code:</td>
					    	<td class="center"><p class="f-12">'.$dom->cp.'</p></td>
					  	</tr>
					</table>
					<br><br>';
			}
			echo '<table class="">
					<tr>
				    	<td class="encabezado">Comments:</td>
				    	<td class="center" colspan="5"><p class="f-12">'.$ver_domicilios->comentario.'</p></td>
				  	</tr>
				</table>';
			?>
		</div>
	<?php 
	}
	?>
	<pagebreak>
	<?php 
	if($docs){
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 12){ ?>
				<div class="center sin-flotar margen-top">
					<p class="f-20">VALIDATED Criminal Records – Mexican </p>
				</div>
				<div class="center">
					<?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="650" height="750"><br><br>'; ?>
				</div>
				<pagebreak>
	<?php
				break;
			}
		}
	}
	?>

	<?php 
	if($docs){
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 11){ ?>
				<div class="center sin-flotar margen-top">
					<p class="f-20">OFAC </p>
				</div>
				<div class="center">
					<?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="550" height="750"><br><br>'; ?>
				</div>
				<pagebreak>
	<?php
				break;
			}
		}
	}
	?>

	<?php 
	if($ver_documento){ ?>
		<div class="center sin-flotar margen-top">
			<p class="f-20">ID Documents</p>
		</div>
		<?php 
		if($docs){
			echo '<div class="center">';
			foreach($docs as $doc){
				if($doc->id_tipo_documento == 3){
					echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="450" height="300"><br>';
				}
				if($doc->id_tipo_documento == 14){
					echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="750" height="850"><br><br>';
				}
				if($doc->id_tipo_documento == 15){
					echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="400" height="450"><br><br>';
				}
			}
			echo '</div>';
		}
		?>
		<pagebreak>

	<?php
	}
	?>
	
	<?php 
	if(isset($global_searches)){ ?>
		<div class="center sin-flotar margen-top">
			<p class="f-20">VALIDATED Database Check</p>
		</div>
		<?php 
		if($docs){
			echo '<div class="center">';
			foreach($docs as $doc){
				if($doc->id_tipo_documento == 18){
					echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="650" height="750"><br><br>';
				}
			}
			echo '</div>';
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