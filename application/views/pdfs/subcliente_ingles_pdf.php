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
				$f_bgc = $row->creacion;
				$identidad = $row->identidad_check;
				$empleo = $row->empleo_check;
				$estudios = $row->estudios_check;
				$visita = $row->visita_check;
				$penales = $row->penales_check;
				$ofac = $row->ofac_check;
				$medico = $row->medico_check;
				$global = $row->global_searches_check;
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

			if($medico == 0){ $f_medico = "fondo2"; $s_medico = "Negative"; }
			if($medico == 1){ $f_medico = "fondo1"; $s_medico = "Positive"; }
			if($medico == 2){ $f_medico = "fondo3"; $s_medico = "FC"; }
			if($medico == 3){ $s_medico = "NA"; }

			if($global == 0){ $f_global = "fondo2"; $s_global = "Negative"; }
			if($global == 1){ $f_global = "fondo1"; $s_global = "Positive"; }
			if($global == 2){ $f_global = "fondo3"; $s_global = "FC"; }
			if($global == 3){ $s_global = "NA"; }

			if(isset($doping)){
				if($doping->fecha_resultado != null && $doping->resultado != -1){
					$res_doping = ($doping->resultado == 0)? "Approved":"Not approved";
					if($doping->resultado == 0){ $f_doping = "fondo1"; }
					if($doping->resultado == 1){ $f_doping = "fondo2"; }
					$a = new DateTime($doping->fecha_resultado);
					$fecha_doping_res = $a->format('m/d/Y');
				}
				else{
					$res_doping = "Waiting results";
					$fecha_doping_res = ' - ';
				}
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
			if($fecha_ver_laboral){
				if($fecha_ver_laboral != null){
					$e = new DateTime($fecha_ver_laboral->fecha_finalizado);
					$fecha_ver_laboral = $e->format('m/d/Y');
				}
				else{
					$fecha_ver_laboral = "Pending";
				}
			}
			else{
				$fecha_ver_laboral = "NA";
			}
			if($ver_mayor_estudio){
				$e = new DateTime($ver_mayor_estudio->creacion);
				$fecha_ver_estudios = $e->format('m/d/Y');
				$ver_tipo_estudio = $this->candidato_model->getTipoStudies($ver_mayor_estudio->id_tipo_studies);

			}
			else{
				$fecha_ver_estudios = "NA";
				$ver_tipo_estudio = '';
			}
			if($fecha_ver_penales != null){
				$e = new DateTime($fecha_ver_penales->fecha_finalizado);
				$fecha_ver_penales = $e->format('m/d/Y');
			}
			else{
				$fecha_ver_penales = "NA";
			}
			if($fecha_ver_documentos != null){
				$e = new DateTime($fecha_ver_documentos->creacion);
				$fecha_ver_documentos = $e->format('m/d/Y');
			}
			else{
				$fecha_ver_documentos = "NA";
			}
		}
		if($docs){
			foreach($docs as $d){
				$doc[] = $d->id_tipo_documento;
			}
			$doc_acta = (in_array(1, $doc)) ? "YES" : "NO";
			$doc_ine = (in_array(3, $doc) || in_array(14, $doc) || in_array(15, $doc)) ? "YES" : "NO";
			$doc_rfc = (in_array(4, $doc)) ? "YES" : "NO";
			$doc_curp = (in_array(5, $doc)) ? "YES" : "NO";
			$doc_imss = (in_array(6, $doc) || in_array(9, $doc)) ? "YES" : "NO";
			$doc_estudio = (in_array(7, $doc) || in_array(10, $doc)) ? "YES" : "NO";
			$doc_dom = (in_array(2, $doc)) ? "YES" : "NO";
			$doc_penal = (in_array(12, $doc)) ? "YES" : "NO";

			if(in_array(10, $doc)){
				$document = "Professional License";
			}
			else{
				if(in_array(7, $doc)){
					$document = "School Certificate";
				}
			}

		}
		if($ver_documento){
			foreach($ver_documento as $item){
				$lic = $item->licencia;
				$lic_institucion = $item->licencia_institucion;
				$ine = $item->ine;
				$ine_ano = $item->ine_ano;
				$ine_vertical = $item->ine_vertical;
				$ine_institucion = $item->ine_institucion;
				$ver_penales = $item->penales;
				$ver_penales_institucion = $item->penales_institucion;
				$comentario_ver_documento = $item->comentarios;
				$pasaporte = $item->pasaporte;
				$pasaporte_fecha = $item->pasaporte_fecha;
				$forma_migratoria = $item->forma_migratoria;
				$forma_migratoria_fecha = $item->forma_migratoria_fecha;
			}
			if($ine == "" || $ine_ano == "" || $ine_vertical == "" || $ine_institucion == ""){
				$ine_completo = "Not provided";
				$ine_institucion = "Not provided";
			}
			else{
				$ine_completo = "Code:".$ine."<br>register date: ".$ine_ano."<br>Vertical number:<br>".$ine_vertical;
			}

			if($ver_penales == "" || $ver_penales_institucion == ""){
				$penales_completo = "Not provided";
				$ver_penales_institucion = "Not provided";
			}
			else{
				$penales_completo = "Document number:".$ver_penales;
			}

			$pasaporte_id = ($pasaporte != "" || $pasaporte != null)? $pasaporte:"Not provided";
			$pasaporte_date = ($pasaporte_fecha != "" || $pasaporte_fecha != null)? $pasaporte_fecha:"Not provided";
			$forma_migratoria_id = ($forma_migratoria != "" || $forma_migratoria != null)? $forma_migratoria:"Not provided";
			$forma_migratoria_date = ($forma_migratoria_fecha != "" || $forma_migratoria_fecha != null)? $forma_migratoria_fecha:"Not provided";
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
				$estado_civil = $d->estado_civil;
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
				$proceso = $d->id_tipo_proceso;
			}
			//Fechas
			$hoy = formatoEspecialFecha($hoy);
			$e = new DateTime($hoy);
			$hoy2 = $e->format('m/d/Y');

			$e = new DateTime($f);
			$f_requested = $e->format('m/d/Y');

			$e = new DateTime($fecha_nacimiento);
			$fecha_nacimiento = $e->format('m/d/Y');

			$e = new DateTime($global_searches->creacion);
			$fecha_global = $e->format('m/d/Y');

			$e = new DateTime($f_bgc);
			$fecha_final = $e->format('m/d/Y');


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
			//Indicadores
			$estado = $this->candidato_model->getEstado($id_estado);
			$municipio = $this->candidato_model->getMunicipio($id_municipio);
			$estudios = $this->candidato_model->getTipoStudies($id_grado_estudio);
			
		}

		/*
		<td class="center"><p class="f-14"><img class="icono" src="<?php echo base_url()."".$icono; ?>"><?php echo $bgc; ?></p></td>
	*/
	?>
	<!-- HOJA 1 -->
	<div>
		<div class="col-md-4 borde-derecho">
			<img src="<?php echo base_url().'img/rts_logo.jpg' ?>" width="190px" >
		</div>
		<div class="col-md-6">
			<span class="f-16 color-rodi margen-top"><b><?php echo $subcliente; ?></span></b><br>
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
		    	<?php 
		    	if($proceso == 3 || $proceso == 4){
		    		$fecha_empleos = ($s_empleo != "NA")? $fecha_final:"NA"; ?>
	    			<td><?php echo $fecha_empleos; ?></td>
		    	<?php 
		    	}
		    	if($proceso == 5){ ?>
		    		<td>NA</td>
		    	<?php 
		    	} ?>
		  	</tr>
		  	<tr>
		  		<td class="left">Academic History check</td>
		    	<td class="<?php echo $f_estudios; ?>"><p class="f-14"><?php echo $s_estudios; ?></p></td>
		    	<?php $fecha_estudios = ($s_estudios != "NA")? $fecha_ver_estudios:"NA"; ?>
		    	<td><?php echo $fecha_estudios; ?></td>
		  	</tr>
		  	<tr>
		  		<td class="left">Home Visit (If Applicable)</td>
		    	<td class="<?php echo $f_visita; ?>"><p class="f-14"><?php echo $s_visita; ?></p></td>
		    	<td>NA</td>
		  	</tr>
		  	<tr>
		  		<td class="left">Criminal Records – Mexican</td>
		    	<td class=""><p class="f-14"><?php echo 'NA';//$s_penales; ?></p></td>
		    	<td><?php echo 'NA';//$fecha_ver_penales; ?></td>
		  	</tr>
		  	<tr>
		  		<td class="left">Criminal Records – OFAC</td>
		    	<td class="<?php echo $f_ofac; ?>"><p class="f-14"><?php echo $s_ofac; ?></p></td>
		    	<td><?php echo $hoy2; ?></td>
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
		    	<td class="<?php echo $f_medico; ?>"><p class="f-14"><?php echo $s_medico; ?></p></td>
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
	<div class="centrado sin-flotar" style="border: 4px dashed #b8bfe6; height: 220px; width: 28%;">
		<p class="center" style="float: right;">FIRMA AUTORIZADA</p>
		<?php 
		if($analista->firma != null){ ?>
			<img class="firma" style="border: none;" src="<?php echo base_url().'img/'.$analista->firma; ?>">
		<?php 	
		}
		else{ ?>
			<img class="firma" style="border: none;" src="<?php echo base_url().'img/firmaEstudios.jpg'; ?>">
		<?php
		}
		?>
	</div>

	<pagebreak>
	
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
		    	<td class="center"><p class="f-12"><?php echo $calle; ?></p></td>
		    	<td class="encabezado">Ext. Num:</td>
		    	<td class="center"><p class="f-12"><?php echo $ext; ?></p></td>
		    	<td class="encabezado">Int. Num:</td>
		    	<td class="center"><p class="f-12"><?php echo $int; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">Neighborhood:</td>
		  		<td class="center"><p class="f-12"><?php echo $colonia; ?></p></td>
		  		<td class="encabezado">State:</td>
		  		<td class="center"><p class="f-12"><?php echo $estado->nombre; ?></p></td>
		  		<td class="encabezado">City:</td>
		  		<td class="center"><p class="f-12"><?php echo $municipio->nombre; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">Zip Code:</td>
		  		<td class="center"><p class="f-12"><?php echo $cp; ?></p></td>
		  		<td class="encabezado">Mobile Num:</td>
		  		<td class="center"><p class="f-12"><?php echo $celular; ?></p></td>
		  		<td class="encabezado">Home Num:</td>
		  		<td class="center"><p class="f-12"><?php echo $telefono_casa; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">E-mail:</td>
		  		<td class="center" colspan="5"><p class="f-12"><?php echo $correo; ?></p></td>
		  	</tr>
		</table>
	</div>
	<?php 
	if($ver_documento){ ?>
		<div class="div_datos">
			<p class="center f-18">Documents</p>
			<table class="">
					<tr>
						<th class="encabezado">Document</th>
						<th class="encabezado">Number of Document</th>
						<th class="encabezado">Date / Institution</th>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">ID (IFE, INE)</p></td>
						<td class="center"><p class="f-12"><?php echo $ine_completo; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $ine_institucion; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Passport</p></td>
						<td class="center"><p class="f-12"><?php echo $pasaporte_id; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $pasaporte_date; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Non-criminal background letter</p></td>
						<td class="center"><p class="f-12"><?php echo $penales_completo; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $ver_penales_institucion; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Migration document</p></td>
						<td class="center"><p class="f-12"><?php echo $forma_migratoria_id; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $forma_migratoria_date; ?></p></td>
					</tr>
					
					
					<tr>
						<td class="encabezado center"><p class="f-12">Comments</p></td>
						<td class="center" colspan="2"><p class="f-12"><?php echo $comentario_ver_documento; ?></p></td>
					</tr>
			</table>
		</div>
	<?php 
	} ?>
	<div class="div_datos">
		<p class="center f-18">Global Data Searches</p>
		<table class="">
		  	<tr>
		    	<td class="encabezado">Law enforcement:</td>
		    	<td class="center"><p class="f-12"><?php echo $global_searches->law_enforcement; ?></p></td>
		  	</tr>
		  	<tr>
		    	<td class="encabezado">Regulatory:</td>
		    	<td class="center"><p class="f-12"><?php echo $global_searches->regulatory; ?></p></td>
		  	</tr>
		  	<tr>
		    	<td class="encabezado">Sanctions:</td>
		    	<td class="center"><p class="f-12"><?php echo $global_searches->sanctions; ?></p></td>
		  	</tr>
		  	<tr>
		    	<td class="encabezado">Web and media searches:</td>
		    	<td class="center"><p class="f-12"><?php echo $global_searches->media_searches; ?></p></td>
		  	</tr>
		  	<tr>
		    	<td class="encabezado">Other bodies:</td>
		    	<td class="center"><p class="f-12"><?php echo $global_searches->other_bodies; ?></p></td>
		  	</tr>
		  	<tr>
		    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
		  	</tr>
		</table>
	</div>

	<?php 
	if($secciones->lleva_estudios == 1){
		if($ver_mayor_estudio != null){ ?>
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
		<?php 
		}
	} ?>

	<pagebreak>
		
	<?php 
	if($lleva_empleos == 1){
		if($ref_laboral){ 
			$cont = 1; ?>
			<div class="div_datos">
					<p class="center f-18">Labor References </p>
			<?php
			foreach($ref_laboral as $ref){
				$ver_laboral = $this->candidato_model->getVerificacionLaboral($cont, $id_candidato); ?>
				
					<table class="">
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
					    	<td class="center"><p class="f-12"><?php echo $entrada_laboral = $ref->fecha_entrada_txt; ?></p></td>
					    	<td class="center"><p class="f-12"><?php echo $entrada_verifica = $ver_laboral->fecha_entrada_txt; ?></p></td>
					  	</tr>
					  	<tr>
					  		<td class="encabezado center"><p class="f-12">Exit Date</p></td>
					    	<td class="center"><p class="f-12"><?php echo $salida_laboral = $ref->fecha_salida_txt; ?></p></td>
					    	<td class="center"><p class="f-12"><?php echo $salida_verifica = $ver_laboral->fecha_salida_txt; ?></p></td>
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
					    	<td class="center"><p class="f-12"><?php echo $ref->salario1_txt; ?></p></td>
					    	<td class="center"><p class="f-12"><?php echo $ver_laboral->salario1_txt; ?></p></td>
					  	</tr>
					  	<tr>
					  		<td class="encabezado center"><p class="f-12">Last Salary</p></td>
					    	<td class="center"><p class="f-12"><?php echo $ref->salario2_txt; ?></p></td>
					    	<td class="center"><p class="f-12"><?php echo $ver_laboral->salario2_txt; ?></p></td>
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
				
				<p class="f-14 center">Candidate's features</p><br>
				<div class="div_datos">
					<table class="">
					  	<tr>
					    	<td class="encabezado right" width="35%"><p class="f-12"><b>Qualities of the candidate</b></p></td>
					    	<td class="center" colspan="3"><p class="f-11"><b><?php echo $ver_laboral->cualidades; ?></b></p></td>
					  	</tr>
					  	<tr>
					    	<td class="encabezado right" width="35%"><p class="f-12"><b>Skills of the candidate</b></p></td>
					    	<td class="center" colspan="3"><p class="f-11"><b><?php echo $ver_laboral->mejoras; ?></b></p></td>
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
		else{ ?>
			<div class="div_datos">
				<table class="">
				  	<tr>
				  		<td class="center"><p class="f-12">No previous experience</p></td>
			  		</tr>
				</table>
			</div><br>
		<?php
		}
	} ?>

	<!-- GAPS -->
  <?php 
	if($secciones->lleva_gaps == 1){
		if($gaps){ ?>
			<div class="div_datos">
				<p class="center f-18">Employment and/or Education Gaps</p>
				<table class="">
					<tr>
							<th class="encabezado">From</th>
							<th class="encabezado">To</th>
							<th class="encabezado" width="40%">Reason</th>
						</tr>
					<?php 
					foreach($gaps as $g){ ?>
						<tr>
							<td class="center"><p class="f-12"><?php echo $g->fecha_inicio; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $g->fecha_fin; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $g->razon; ?></p></td>
						</tr>
					<?php
						}
					?>
				</table>
			</div>
		<?php 
		}
	 } ?>

	<?php 
	if(!isset($doping)) { ?>
		<pagebreak>
	<?php
 	} ?>

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
		<pagebreak>
	<?php 
	} ?>

	<div class="center sin-flotar margen-top">
		<p class="f-20">VALIDATED Criminal Records – OFAC</p>
	</div>
	<?php 
	if($docs){
		echo '<div class="center">';
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 11){
				echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="550" height="750">';
			}
		}
		echo '</div>';
	}
	?>

	<pagebreak>

	<div class="center sin-flotar margen-top">
		<p class="f-20">VALIDATED Database Check</p>
	</div>
	<?php 
	if($docs){
		echo '<div class="center">';
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 18){
				echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="700" height="250"><br><br>';
			}
		}
		echo '</div>';
	}
	?>
	<pagebreak>

	<div class="center sin-flotar margen-top">
		<p class="f-20">Non-disclosure Agreement</p>
	</div>
	<?php 
	if($docs){
		echo '<div class="center">';
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 8){
				echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="550" height="750"><br><br>';
			}
		}
		echo '</div>';
	}
	?>
	<br>
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