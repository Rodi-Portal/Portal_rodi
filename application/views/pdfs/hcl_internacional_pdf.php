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
			if(isset($fecha_ver_estudios)){
				$e = new DateTime($fecha_ver_estudios->fecha_finalizado);
				$fecha_ver_estudios = $e->format('m/d/Y');
			}
			else{
				$fecha_ver_estudios = 'NA';
			}
			if(isset($fecha_ver_laboral)){
				$e = new DateTime($fecha_ver_laboral->fecha_finalizado);
				$fecha_ver_laboral = $e->format('m/d/Y');
			}
			else{
				$fecha_ver_laboral = 'NA';
			}


		}
		
		if($ver_documento){
			foreach($ver_documento as $item){
				if($item->licencia == ''){
					$lic = "Not provided";
					$lic_institucion = "Not provided";
				}
				else{
					$lic = $item->licencia;
					$lic_institucion = $item->licencia_institucion;
				}

				if($item->ine == ''){
					$ine_completo = "Not provided";
					$ine_institucion = "Not provided";
				}
				else{
					$ine_completo = "ID: ".$item->ine;
					$ine_institucion = $item->ine_institucion;
				}

				if($item->pasaporte == ''){
					$pasaporte_completo = "Not provided";
					$pasaporte_fecha = "Not provided";
				}
				else{
					$pasaporte_completo = "Document Number:<br>".$item->pasaporte;
					$pasaporte_fecha = $item->pasaporte_fecha;
				}

				if($item->penales == ''){
					$penales_completo = "Not provided";
					$penales_institucion = "Not provided";
				}
				else{
					$penales_completo = "Document Number:<br>".$item->penales;
					$penales_institucion = $item->penales_institucion;
				}

				if($item->militar == ''){
					$militar = "Not provided";
					$militar_fecha = "Not provided";
				}
				else{
					$militar = "Document Number:<br>".$item->militar;
					$militar_fecha = $item->militar_fecha;
				}

				if($item->domicilio == ''){
					$domicilio = "Not provided";
					$domicilio_fecha = "Not provided";
				}
				else{
					$domicilio = "Document Number:<br>".$item->domicilio;
					$domicilio_fecha = $item->fecha_domicilio;
				}
				$comentario_ver_documento = $item->comentarios;
			}
			
			if($docs){
				foreach($docs as $d){
					$doc[] = $d->id_tipo_documento;
				}
				if(in_array(10, $doc)){
					$comprobante_estudios = "Professional License";
				}
				elseif(in_array(7, $doc)){
					$comprobante_estudios = "School Certificate";
					
				}
				else{
					$comprobante_estudios = "School Certificate";
				}
			}
			else{
					$comprobante_estudios = "School Certificate";
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
				$id_proyecto = $d->id_proyecto;
				$status_bgc = $d->status_bgc;
				$fecha_nacimiento = $d->fecha_nacimiento;
				$edad = $d->edad;
				$puesto = $d->puesto;
				$nacionalidad = $d->nacionalidad;
				$genero = $d->genero;
				$domicilio_internacional = $d->domicilio_internacional;
				$estado_civil = $d->estado_civil;
				$pais = $d->pais;
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
			$estudios = $this->candidato_model->getTipoStudies($id_grado_estudio);
			$ver_tipo_estudio = $this->candidato_model->getTipoStudies($ver_mayor_estudio->id_tipo_studies);
		}


	?>
	<!-- HOJA 1 -->
	<div>
		<div class="col-md-4 borde-derecho">
			<img src="<?php echo base_url().'img/logo.png' ?>" width="190px" >
		</div>
		<div class="col-md-6">
			<span class="f-16 color-rodi margen-top"><b><?php echo $cliente.' - '.$proyecto; ?></span></b><br>
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
		    	<td class="<?php echo $f_empleo; ?>"><p class="f-14"><?php echo $s_empleo; ?></p></td>
		    	<td><?php echo $fecha_ver_laboral; ?></td>
		  	</tr>
		  	<tr>
		  		<td class="left">Academic History check</td>
		    	<td class="<?php echo $f_estudios; ?>"><p class="f-14"><?php echo $s_estudios; ?></p></td>
		    	<td><?php echo $fecha_ver_estudios; ?></td>
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
	    	<td class="left" width="80%"><p class="f-11"><?php echo $checklist->education; ?></p></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Employment</b></p></td>
	    	<td class="left" width="80%"><p class="f-11"><?php echo $checklist->employment; ?></p></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Address</b></p></td>
	    	<td class="left" width="80%"><p class="f-11"><?php echo $checklist->address; ?></p></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Criminal</b></p></td>
	    	<td class="left" width="80%"><p class="f-11"><?php echo $checklist->criminal; ?></p></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Database</b></p></td>
	    	<td class="left" width="80%"><p class="f-11"><?php echo $checklist->global_database; ?></p></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Identity</b></p></td>
	    	<td class="left" width="80%"><p class="f-11"><?php echo $checklist->identity; ?></p></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Military</b></p></td>
	    	<td class="left" width="80%"><p class="f-11"><?php echo $checklist->military; ?></p></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Drug test</b></p></td>
	    	<?php
	    	if(isset($doping)){
	    		$parametros = explode('x', $doping->drogas); ?>
	    		<td class="left" width="80%"><p class="f-11"><?php echo $parametros[0]." Panel Drug Test"; ?></p></td>
	    	<?php
	    	}else{ ?>
	    		<td class="left" width="80%"><p class="f-11">Pending</p></td>
	    	<?php
	    	}
    	  	?>
	  	</tr>
	  	<tr>
	    	<td class="encabezado center" width="20%"><p class="f-12"><b>Other</b></p></td>
	    	<td class="left" width="80%"><p class="f-11"><?php echo $checklist->other; ?></p></td>
	  	</tr>
	</table><br>
	<div class="centrado sin-flotar" style="border: 4px dashed #b8bfe6; height: 220px; width: 28%;">
		<p class="center" style="float: right;">FIRMA AUTORIZADA</p>
		<img class="firma" style="border: none;" src="<?php echo base_url().'img/firmaEstudios.jpg'; ?>">
	</div>
	
	<pagebreak>
	<!-- Datos Personales -->
	<div class="div_datos">
		<p class="center f-18">Personal Data</p>
		<table class="">
		  	<tr>
		    	<td class="encabezado">Name:</td>
		    	<td class="center" colspan="5"><p class="f-12"><?php echo $nombre." ".$pat." ".$mat; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">Date of birth:</td>
		    	<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
		    	<td class="encabezado">Age:</td>
		    	<td class="center"><p class="f-12"><?php echo $edad; ?></p></td>
		    	<td class="encabezado w-17">Job Position Requested:</td>
		    	<td class="center"><p class="f-12"><?php echo $puesto; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">Nationality:</td>
		    	<td class="center"><p class="f-12"><?php echo $nacionalidad; ?></p></td>
		    	<td class="encabezado">Gender:</td>
		    	<td class="center"><p class="f-12"><?php echo $genero; ?></p></td>
		  		<td class="encabezado">Marital Status:</td>
		    	<td class="center"><p class="f-12"><?php echo $estado_civil; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">Address:</td>
		    	<td class="center" colspan="5"><p class="f-12"><?php echo $domicilio_internacional; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">Country:</td>
		  		<td class="center"><p class="f-12"><?php echo $pais; ?></p></td>
		  		<td class="encabezado">Mobile Num:</td>
		  		<td class="center"><p class="f-12"><?php echo $celular; ?></p></td>
		  		<td class="encabezado">Home Num:</td>
		  		<td class="center"><p class="f-12"><?php echo $telefono_casa; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">Number to leave Messages:</td>
		  		<td class="center"><p class="f-12"><?php echo $telefono_otro; ?></p></td>
		  		<td class="encabezado">E-mail:</td>
		  		<td class="center" colspan="3"><p class="f-12"><?php echo $correo; ?></p></td>
		  	</tr>
		</table>
	</div>
	<!-- Documentos -->
	<div class="div_datos">
		<p class="center f-18">Documents</p>
		<table class="">
		  	<tr>
		    	<th class="encabezado">Document</th>
		    	<th class="encabezado">Number of Document</th>
		    	<th class="encabezado">Date / Institution</th>
		  	</tr>
		  	<tr>
		  		<td class="encabezado center"><p class="f-12"><?php echo $comprobante_estudios; ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $lic; ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $lic_institucion; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">ID (IFE, INE or Passport)</p></td>
		    	<td class="center"><p class="f-12"><?php echo $ine_completo; ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $ine_institucion; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Non-criminal background letter</p></td>
		    	<td class="center"><p class="f-12"><?php echo $penales_completo; ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $penales_institucion; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Passport</p></td>
		    	<td class="center"><p class="f-12"><?php echo $pasaporte_completo; ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $pasaporte_fecha; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Current proof of address</p></td>
		    	<td class="center"><p class="f-12"><?php echo $domicilio; ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $domicilio_fecha; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Military service (Mexico)</p></td>
		    	<td class="center"><p class="f-12"><?php echo $militar; ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $militar_fecha; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Comments</p></td>
		    	<td class="center" colspan="2"><p class="f-12"><?php echo $comentario_ver_documento; ?></p></td>
		  	</tr>
		</table>
	</div>
	<!-- Estudios -->
	<div class="div_datos">
		<p class="center f-18">Education</p>
		<table class="">
			<tr>
		    	<th class="encabezado"></th>
		    	<th class="encabezado">Candidate</th>
		    	<th class="encabezado">Analist</th>
		  	</tr>
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Highest education</p></td>
		    	<td class="center"><p class="f-12"><?php echo $estudios->nombre; ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $ver_tipo_estudio->nombre; ?></p></td>
		  	</tr>
			
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Period</p></td>
		    	<td class="center"><p class="f-12"><?php echo $estudios_periodo; ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $ver_mayor_estudio->periodo; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Institute</p></td>
		    	<td class="center"><p class="f-12"><?php echo $estudios_escuela; ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $ver_mayor_estudio->escuela; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">City</p></td>
		    	<td class="center"><p class="f-12"><?php echo $estudios_ciudad; ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $ver_mayor_estudio->ciudad; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Certificate Obtained</p></td>
		    	<td class="center"><p class="f-12"><?php echo $estudios_certificado; ?></p></td>
		    	<td class="center"><p class="f-12"><?php echo $ver_mayor_estudio->certificado; ?></p></td>
		  	</tr>
		</table>
	</div><br>
	<div class="div_datos">
		<table class="">
		  	<tr>
		  		<td class="center"><p class="f-12"><?php echo $ver_mayor_estudio->comentarios; ?></p></td>
	  		</tr>
		</table>
	</div><br>
	<div class="div_datos">
		<p class="center f-18">School Verification</p>
		<table class="">
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Studies verification requested</p></td>
		    	<td class="center"><p class="f-12"><?php echo $f_requested; ?></p></td>
		    	<td class="center" rowspan="2"><p class="f-12">Validated</p></td>

		  	</tr>
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Verification completed</p></td>
		    	<td class="center"><p class="f-12"><?php echo $fecha_ver_estudios; ?></p></td>
		  	</tr>
		</table>
	</div><br>
	<div class="div_datos">
		<table>
			<?php 
		  	foreach($det_estudio as $det){
		  		$a = new DateTime($det->fecha);
				$f_det = $a->format('m/d/Y');
		  		echo '<tr>';
		  		echo '<td class="center w-17"><p class="f-12">'.$f_det.'</p></td>';
		  		echo '<td class="center"><p class="f-12">'.$det->comentarios.'</p></td>';
		  		echo '</tr>';
		  	}
		  	?>
		</table>
	</div><br><br>
	<pagebreak>
	<!-- Domicilios -->
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
					    	<td class="center"><p class="f-12">'.$dom->domicilio_internacional.'</p></td>
					    </tr>
					    <tr>
					    	<td class="encabezado w-17">Zip Code:</td>
					    	<td class="center"><p class="f-12">'.$dom->pais.'</p></td>
					  	</tr>
					</table>
					<br><br>';
			}
			echo '<table class="">
					<tr>
				    	<td class="encabezado">Comments:</td>
				    	<td class="center" colspan="5"><p class="f-12">'.$ver_domicilios->comentario.'</p></td>
				  	</tr>
				</table><br><br><br>';
			?>
		</div>
	<?php 
	}
	?>
	<!-- Referencias Profesionales -->
	<?php 
	if($ref_profesional){ 
		$num = 0; ?>
		<pagebreak>
		<div class="div_datos">
			<p class="center f-18">Professional References</p>
			<?php 
			foreach($ref_profesional as $p){
				$num++;  ?>
				<table class="">
					<tr>
				  		<th class="encabezado center" colspan="3"><p class="f-12">Reference #<?php echo $num; ?> </p></th>
				  	</tr>
					<tr>
				  		<td class="encabezado center" width="10%"><p class="f-12">Name:</p></td>
				    	<td class="center" colspan="2"><p class="f-12"><?php echo $p->nombre; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center" width="10%"><p class="f-12">Phone:</p></td>
				    	<td class="center" colspan="2"><p class="f-12"><?php echo $p->telefono; ?></p></td>
				  	</tr>
					<tr>
				    	<th class="encabezado"></th>
				    	<th class="encabezado">Candidate</th>
				    	<th class="encabezado">Analist</th>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center" width="25%"><p class="f-12">Time to know her/him?</p></td>
				    	<td class="center"><p class="f-12"><?php echo $p->tiempo_conocerlo; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $p->verificacion_tiempo; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center" width="25%"><p class="f-12">Why do you know her/him?</p></td>
				    	<td class="center"><p class="f-12"><?php echo $p->donde_conocerlo; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $p->verificacion_conocerlo; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center" width="25%"><p class="f-12">What position had her/him?</p></td>
				    	<td class="center"><p class="f-12"><?php echo $p->puesto; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $p->verificacion_puesto; ?></p></td>
				  	</tr>
			  	</table>
				<br>
				<table class="">
					<tr>
				  		<td class="encabezado center" width="25%"><p class="f-12">Candidate's qualities</p></td>
				    	<td class="center"><p class="f-12"><?php echo $p->cualidades; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center" width="25%"><p class="f-12">Candidate's performance</p></td>
				    	<td class="center"><p class="f-12"><?php echo $p->desempeno; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center" width="25%"><p class="f-12">Does the professional reference recommend the candidate?</p></td>
				    	<td class="center"><p class="f-12"><?php echo $p->recomienda; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center" width="25%"><p class="f-12">Comments</p></td>
				    	<td class="center"><p class="f-12"><?php echo $p->comentarios; ?></p></td>
				  	</tr>
				</table>
				<br><br>
			<?php
			}
			?>
		</div>
		<pagebreak>
	<?php 
	}
	?>
	<!-- Referencias laborales -->
	<p class="center f-18">Labor References </p>
	<?php 
	if(isset($ref_laboral)){
		$cont = 1;
		foreach($ref_laboral as $ref){
			$ver_laboral = $this->candidato_model->getVerificacionLaboral($cont, $id_candidato);
	 		?>
			<div class="div_datos">
				<table class="">
					<?php 
					 ?>
				  	<tr>
				    	<th class="encabezado"></th>
				    	<th class="encabezado">Candidate</th>
				    	<th class="encabezado">Company</th>
				    	<th class="encabezado">Notes</th>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Company</p></td>
				    	<td class="center"><p class="f-12"><?php echo $ref->empresa; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $ver_laboral->empresa; ?></p></td>
				    	<td class="left w-30" rowspan="12"><p class="f-12"><?php echo $ver_laboral->notas; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Address</p></td>
				    	<td class="center"><p class="f-12"><?php echo $ref->direccion; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $ver_laboral->direccion; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Entry Date</p></td>
				    	<td class="center"><p class="f-12"><?php echo $entrada_laboral = formatoEspecialFecha($ref->fecha_entrada); ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $entrada_verifica = formatoEspecialFecha($ver_laboral->fecha_entrada); ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Exit Date</p></td>
				    	<td class="center"><p class="f-12"><?php echo $salida_laboral = formatoEspecialFecha($ref->fecha_salida); ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $salida_verifica = formatoEspecialFecha($ver_laboral->fecha_salida); ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Phone</p></td>
				    	<td class="center"><p class="f-12"><?php echo $ref->telefono; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $ver_laboral->telefono; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Initial Job Position</p></td>
				    	<td class="center"><p class="f-12"><?php echo $ref->puesto1; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $ver_laboral->puesto1; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Last Job Position</p></td>
				    	<td class="center"><p class="f-12"><?php echo $ref->puesto2; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $ver_laboral->puesto2; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Initial Salary</p></td>
				    	<td class="center"><p class="f-12"><?php echo $ref->salario1; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $ver_laboral->salario1; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Last Salary</p></td>
				    	<td class="center"><p class="f-12"><?php echo $ref->salario2; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $ver_laboral->salario2; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Immediate Boss</p></td>
				    	<td class="center"><p class="f-12"><?php echo $ref->jefe_nombre."<br>".$ref->jefe_correo; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $ver_laboral->jefe_nombre."<br>".$ver_laboral->jefe_correo; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Boss’s Job Position</p></td>
				    	<td class="center"><p class="f-12"><?php echo $ref->jefe_puesto; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $ver_laboral->jefe_puesto; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Cause of Separation</p></td>
				    	<td class="center"><p class="f-12"><?php echo $ref->causa_separacion; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $ver_laboral->causa_separacion; ?></p></td>
				  	</tr>
				</table>
			</div><br>
			<p class="f-14 center">Candidate Performance</p><br>
			<div class="div_datos">
				<table class="">
				  	<tr>
				    	<th class="encabezado w-60">Area</th>
				    	<th class="encabezado">Calification</th>
				  	</tr>
				  	<?php 
				  	if($ver_laboral->responsabilidad == "Not provided" && $ver_laboral->iniciativa == "Not provided" && $ver_laboral->eficiencia == "Not provided" && $ver_laboral->disciplina == "Not provided" && $ver_laboral->puntualidad == "Not provided" && $ver_laboral->limpieza == "Not provided" && $ver_laboral->estabilidad == "Not provided" && $ver_laboral->emocional == "Not provided" && $ver_laboral->honestidad == "Not provided" && $ver_laboral->rendimiento == "Not provided" && $ver_laboral->actitud == "Not provided"){
				  		echo '<tr>
				  				<td class="encabezado center"><p class="f-12">Responsability</p></td>
				    			<td class="center" rowspan="11"><p class="f-12">Not provided</p></td>
			  				</tr>
			  				<tr>
				  				<td class="encabezado center"><p class="f-12">Initiative</p></td>
			  				</tr>
			  				<tr>
				  				<td class="encabezado center"><p class="f-12">Work efficiency</p></td>
			  				</tr>
			  				<tr>
				  				<td class="encabezado center"><p class="f-12">Discipline</p></td>
			  				</tr>
			  				<tr>
				  				<td class="encabezado center"><p class="f-12">Punctuality and assistance</p></td>
			  				</tr>
			  				<tr>
				  				<td class="encabezado center"><p class="f-12">Cleanliness and order</p></td>
			  				</tr>
			  				<tr>
				  				<td class="encabezado center"><p class="f-12">Stability</p></td>
			  				</tr>
			  				<tr>
				  				<td class="encabezado center"><p class="f-12">Emotional Stability</p></td>
			  				</tr>
			  				<tr>
				  				<td class="encabezado center"><p class="f-12">Honesty</p></td>
			  				</tr>
			  				<tr>
				  				<td class="encabezado center"><p class="f-12">Performance</p></td>
			  				</tr>
			  				<tr>
				  				<td class="encabezado center"><p class="f-12">Attitude with coworkers, bosses and subordinates</p></td>
			  				</tr>';
				  	}
				  	else{
				  		if($ver_laboral->responsabilidad == "Excellent" && $ver_laboral->iniciativa == "Excellent" && $ver_laboral->eficiencia == "Excellent" && $ver_laboral->disciplina == "Excellent" && $ver_laboral->puntualidad == "Excellent" && $ver_laboral->limpieza == "Excellent" && $ver_laboral->estabilidad == "Excellent" && $ver_laboral->emocional == "Excellent" && $ver_laboral->honestidad == "Excellent" && $ver_laboral->rendimiento == "Excellent" && $ver_laboral->actitud == "Excellent"){
					  		echo '<tr>
					  				<td class="encabezado center"><p class="f-12">Responsability</p></td>
					    			<td class="center" rowspan="11"><p class="f-12">Excellent</p></td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center"><p class="f-12">Initiative</p></td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center"><p class="f-12">Work efficiency</p></td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center"><p class="f-12">Discipline</p></td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center"><p class="f-12">Punctuality and assistance</p></td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center"><p class="f-12">Cleanliness and order</p></td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center"><p class="f-12">Stability</p></td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center"><p class="f-12">Emotional Stability</p></td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center"><p class="f-12">Honesty</p></td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center"><p class="f-12">Performance</p></td>
				  				</tr>
				  				<tr>
					  				<td class="encabezado center"><p class="f-12">Attitude with coworkers, bosses and subordinates</p></td>
				  				</tr>';
					  	}
					  	else{
					  		if($ver_laboral->responsabilidad == "Good" && $ver_laboral->iniciativa == "Good" && $ver_laboral->eficiencia == "Good" && $ver_laboral->disciplina == "Good" && $ver_laboral->puntualidad == "Good" && $ver_laboral->limpieza == "Good" && $ver_laboral->estabilidad == "Good" && $ver_laboral->emocional == "Good" && $ver_laboral->honestidad == "Good" && $ver_laboral->rendimiento == "Good" && $ver_laboral->actitud == "Good"){
						  		echo '<tr>
						  				<td class="encabezado center"><p class="f-12">Responsability</p></td>
						    			<td class="center" rowspan="11"><p class="f-12">Good</p></td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center"><p class="f-12">Initiative</p></td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center"><p class="f-12">Work efficiency</p></td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center"><p class="f-12">Discipline</p></td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center"><p class="f-12">Punctuality and assistance</p></td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center"><p class="f-12">Cleanliness and order</p></td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center"><p class="f-12">Stability</p></td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center"><p class="f-12">Emotional Stability</p></td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center"><p class="f-12">Honesty</p></td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center"><p class="f-12">Performance</p></td>
					  				</tr>
					  				<tr>
						  				<td class="encabezado center"><p class="f-12">Attitude with coworkers, bosses and subordinates</p></td>
					  				</tr>';
						  	}
						  	else{
						  		if($ver_laboral->responsabilidad == "Regular" && $ver_laboral->iniciativa == "Regular" && $ver_laboral->eficiencia == "Regular" && $ver_laboral->disciplina == "Regular" && $ver_laboral->puntualidad == "Regular" && $ver_laboral->limpieza == "Regular" && $ver_laboral->estabilidad == "Regular" && $ver_laboral->emocional == "Regular" && $ver_laboral->honestidad == "Regular" && $ver_laboral->rendimiento == "Regular" && $ver_laboral->actitud == "Regular"){
							  		echo '<tr>
							  				<td class="encabezado center"><p class="f-12">Responsability</p></td>
							    			<td class="center" rowspan="11"><p class="f-12">Regular</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Initiative</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Work efficiency</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Discipline</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Punctuality and assistance</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Cleanliness and order</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Stability</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Emotional Stability</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Honesty</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Performance</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Attitude with coworkers, bosses and subordinates</p></td>
						  				</tr>';
							  	}
							  	else{
							  		if($ver_laboral->responsabilidad == "Bad" && $ver_laboral->iniciativa == "Bad" && $ver_laboral->eficiencia == "Bad" && $ver_laboral->disciplina == "Bad" && $ver_laboral->puntualidad == "Bad" && $ver_laboral->limpieza == "Bad" && $ver_laboral->estabilidad == "Bad" && $ver_laboral->emocional == "Bad" && $ver_laboral->honestidad == "Bad" && $ver_laboral->rendimiento == "Bad" && $ver_laboral->actitud == "Bad"){
								  		echo '<tr>
								  				<td class="encabezado center"><p class="f-12">Responsability</p></td>
								    			<td class="center" rowspan="11"><p class="f-12">Bad</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Initiative</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Work efficiency</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Discipline</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Punctuality and assistance</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Cleanliness and order</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Stability</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Emotional Stability</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Honesty</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Performance</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Attitude with coworkers, bosses and subordinates</p></td>
							  				</tr>';
								  	}
								  	else{
								  		if($ver_laboral->responsabilidad == "Very Bad" && $ver_laboral->iniciativa == "Very Bad" && $ver_laboral->eficiencia == "Very Bad" && $ver_laboral->disciplina == "Very Bad" && $ver_laboral->puntualidad == "Very Bad" && $ver_laboral->limpieza == "Very Bad" && $ver_laboral->estabilidad == "Very Bad" && $ver_laboral->emocional == "Very Bad" && $ver_laboral->honestidad == "Very Bad" && $ver_laboral->rendimiento == "Very Bad" && $ver_laboral->actitud == "Very Bad"){
									  		echo '<tr>
									  				<td class="encabezado center"><p class="f-12">Responsability</p></td>
									    			<td class="center" rowspan="11"><p class="f-12">Very Bad</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Initiative</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Work efficiency</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Discipline</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Punctuality and assistance</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Cleanliness and order</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Stability</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Emotional Stability</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Honesty</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Performance</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Attitude with coworkers, bosses and subordinates</p></td>
								  				</tr>';
									  	}
									  	else{
									  		echo '<tr>
									  				<td class="encabezado center"><p class="f-12">Responsability</p></td>
									    			<td class="center"><p class="f-12">'.$ver_laboral->responsabilidad.'</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Initiative</p></td>
									  				<td class="center"><p class="f-12">'.$ver_laboral->iniciativa.'</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Work efficiency</p></td>
									  				<td class="center"><p class="f-12">'.$ver_laboral->eficiencia.'</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Discipline</p></td>
									  				<td class="center"><p class="f-12">'.$ver_laboral->disciplina.'</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Punctuality and assistance</p></td>
									  				<td class="center"><p class="f-12">'.$ver_laboral->puntualidad.'</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Cleanliness and order</p></td>
									  				<td class="center"><p class="f-12">'.$ver_laboral->limpieza.'</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Stability</p></td>
									  				<td class="center"><p class="f-12">'.$ver_laboral->estabilidad.'</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Emotional Stability</p></td>
									  				<td class="center"><p class="f-12">'.$ver_laboral->emocional.'</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Honesty</p></td>
									  				<td class="center"><p class="f-12">'.$ver_laboral->honestidad.'</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Performance</p></td>
									  				<td class="center"><p class="f-12">'.$ver_laboral->rendimiento.'</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Attitude with coworkers, bosses and subordinates</p></td>
									  				<td class="center"><p class="f-12">'.$ver_laboral->actitud.'</p></td>
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
				    	<td class="center"><?php echo $d1 = ($ver_laboral->recontratacion == 1)?'Yes':'No'; ?></td>
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
		}
	} ?>
	<div class="div_datos">
		<p class="center f-18">Employment references verification</p>
		<table class="">
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Labor verification requested</p></td>
		    	<td class="center"><p class="f-12"><?php echo $f_requested; ?></p></td>
		    	<td class="center" rowspan="2"><p class="f-12">Validated</p></td>

		  	</tr>
		  	<tr>
		  		<td class="encabezado center"><p class="f-12">Verification completed</p></td>
		    	<td class="center"><p class="f-12"><?php echo $fecha_ver_laboral; ?></p></td>
		  	</tr>
		</table>
	</div><br>
	<div class="div_datos">
		<table>
			<?php 
		  	foreach($det_empleo as $det){
		  		$a = new DateTime($det->fecha);
				$f_det = $a->format('m/d/Y');
		  		echo '<tr>';
		  		echo '<td class="center w-17"><p class="f-12">'.$f_det.'</p></td>';
		  		echo '<td class="center"><p class="f-12">'.$det->comentarios.'</p></td>';
		  		echo '</tr>';
		  	}
		  	?>
		</table>
	</div><br>
	<!-- GAPS -->
	<div class="div_datos">
		<p class="center f-18">Employment Gaps</p>
		<table class="">
			<tr>
		    	<th class="encabezado">From</th>
		    	<th class="encabezado">To</th>
		    	<th class="encabezado" width="40%">Reason</th>
		  	</tr>
			<?php 
			if($gaps){
		  		foreach($gaps as $g){ ?>
				  	<tr>
				    	<td class="center"><p class="f-12"><?php echo $g->fecha_inicio; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $g->fecha_fin; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $g->razon; ?></p></td>

				  	</tr>
		  	<?php
		  		}
		  	}
		  	?>
		</table>
	</div><br>
	<!-- Global Database searches -->
	
		<div class="div_datos">
			<p class="center f-18">Global Data Searches</p>
			<table class="">
				<?php 
				if($id_proyecto == 150 || $id_proyecto == 151 || $id_proyecto == 152 || $id_proyecto == 153 || $id_proyecto == 154 || $id_proyecto == 155 || $id_proyecto == 156 || $id_proyecto == 161 || $id_proyecto == 162 || $id_proyecto == 164){ ?>
				  	<tr>
				    	<td class="encabezado" width="20%">Law enforcement:</td>
				    	<td class="center"><p class="f-12"><?php echo $global_searches->law_enforcement; ?></p></td>
				  	</tr>
				  	<tr>
				    	<td class="encabezado" width="20%">Regulatory:</td>
				    	<td class="center"><p class="f-12"><?php echo $global_searches->regulatory; ?></p></td>
				  	</tr>
				  	<tr>
				    	<td class="encabezado" width="20%">Sanctions:</td>
				    	<td class="center"><p class="f-12"><?php echo $global_searches->sanctions; ?></p></td>
				  	</tr>
				  	<tr>
				    	<td class="encabezado" width="20%">Web and media searches:</td>
				    	<td class="center"><p class="f-12"><?php echo $global_searches->media_searches; ?></p></td>
				  	</tr>
				  	<tr>
				    	<td class="encabezado" width="20%">Other bodies:</td>
				    	<td class="center"><p class="f-12"><?php echo $global_searches->other_bodies; ?></p></td>
				  	</tr>
				  	<tr>
				    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
				  	</tr>
				<?php
				}
				if($id_proyecto == 157){ ?>
					<tr>
				    	<td class="encabezado" width="20%">OFAC</td>
				    	<td class="center"><p class="f-12"><?php echo $global_searches->ofac; ?></p></td>
				  	</tr>
				  	<tr>
				    	<td class="encabezado" width="20%">GSA/SAM</td>
				    	<td class="center"><p class="f-12"><?php echo $global_searches->sam; ?></p></td>
				  	</tr>
				  	<tr>
				    	<td class="encabezado" width="20%">FDA department search</td>
				    	<td class="center"><p class="f-12"><?php echo $global_searches->fda; ?></p></td>
				  	</tr>
				  	<tr>
				    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
				  	</tr>
				<?php 
				} ?>
			</table>
		</div><br>

	<!-- Examen Antidoping -->
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
		</div><br><br><br>
	<?php 
	} ?>

	<?php 
	if($fecha_ver_penales != 'NA'){ ?>
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
	</div><br>
	<?php 
	} ?>

	<?php 
	if($credito){ ?>
		<div class="div_datos">
			<p class="center f-18">Credit History</p>
			<table class="">
				<tr>
			    	<th class="encabezado">From</th>
			    	<th class="encabezado">To</th>
			    	<th class="encabezado" width="40%">Comment</th>
			  	</tr>
				<?php 
		  		foreach($credito as $c){ ?>
				  	<tr>
				    	<td class="center"><p class="f-12"><?php echo $c->fecha_inicio; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $c->fecha_fin; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $c->comentario; ?></p></td>

				  	</tr>
			  	<?php
		  		}
			  	?>
			</table>
		</div><br>
	<?php 
	} ?>
	<pagebreak>

	<?php 
	if($docs){
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 3){ ?>
				<div class="center sin-flotar margen-top">
					<p class="f-20">ID issued by government </p>
				</div>
				<div class="center">
					<?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="650" height="600"><br><br>'; ?>
				</div>
				<pagebreak>
	<?php
			}
		}
	}
	?>


	<?php 
	if($docs){
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 14){ ?>
				<div class="center sin-flotar margen-top">
					<p class="f-20">Passport </p>
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
	if($docs){
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 2){ ?>
				<div class="center sin-flotar margen-top">
					<p class="f-20">Current proof of address </p>
				</div>
				<div class="center">
					<?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="550" height="750"><br><br>'; ?>
				</div>
				<pagebreak>
	<?php
			}
		}
	}
	?>

	<?php 
	if($docs){
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 7){ ?>
				<div class="center sin-flotar margen-top">
					<p class="f-20">Studies certificate </p>
				</div>
				<div class="center">
					<?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="550" height="750"><br><br>'; ?>
				</div>
				<pagebreak>
	<?php
			}
		}
	}
	?>

	<?php 
	if($docs){
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 12){ ?>
				<div class="center sin-flotar margen-top">
					<p class="f-20">Criminal Records </p>
				</div>
				<div class="center">
					<?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="650" height="500"><br><br>'; ?>
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
			if($doc->id_tipo_documento == 17){ ?>
				<div class="center sin-flotar margen-top">
					<p class="f-20">OIG </p>
				</div>
				<div class="center">
					<?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="650" height="500"><br><br>'; ?>
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
			if($doc->id_tipo_documento == 21){ ?>
				<div class="center sin-flotar margen-top">
					<p class="f-20">SAM </p>
				</div>
				<div class="center">
					<?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="650" height="450"><br><br>'; ?>
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
	if($docs){
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 18){ ?>
				<div class="center sin-flotar margen-top">
					<p class="f-20">Database Check </p>
				</div>
				<div class="center">
					<?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="650" height="750"><br><br>'; ?>
				</div>
				<pagebreak>
	<?php
			}
		}
	}
	?>

	<?php 
	if($docs){
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 28){ ?>
				<div class="center sin-flotar margen-top">
					<p class="f-20">Credit History </p>
				</div>
				<div class="center">
					<?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="650" height="750"><br><br>'; ?>
				</div>
				<pagebreak>
	<?php
			}
		}
	}
	?>

	<?php 
	if($docs){
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 8){ ?>
				<div class="center sin-flotar margen-top">
					<p class="f-20">Non-disclosure agreement </p>
				</div>
				<div class="center">
					<?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="550" height="750"><br><br>'; ?>
				</div>
				<pagebreak>
	<?php
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