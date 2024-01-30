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
	.media-tabla { width: 90%; }
	.encabezado { background: #f2f2f2; }
	.comentario { width: 80%; border: 1px solid gray; }
	.margen-top { margin-top: 10px; }
	.firma{ border: 2px dotted #a8a8a7; width: 60%; height: 170px; }
	.firma p { float: right !important; }
	.div_datos { margin: 0 auto; width: 100%; }
	.div_datos table { margin: 0 auto; width: 100%;}
	.div_final { margin: 0 auto; width: 80%; }
	.div_final table { margin: 0 auto; width: 100%;}
	.div-azul { background: #154c6e;  width: 100%; height: 20px; color: white; padding-left: 10px;} 
	.w-17 { width: 17%; }
	.w-30 { width: 30%; }
	.w-40 { width: 40%; }
	.w-50 { width: 50%; }
	.w-60 { width: 60%; }
	.w-80 { width: 80%; }
	.w-90 { width: 90% !important; }
	.w-100 { width: 100% !important; }
	.img-penales { width: 370px; height: 420px; }
	.borde-derecho { border-right: 1px solid black; }
	.color-rodi { color: #255880; }
	.margen-50 {margin-left: 50% !important;}
	.flotar-derecha { float: right !important; }
</style>
<body>
	<?php
		function formatoEspecialFecha($f){
			$res = strtotime($f);
			if($res !== false && $res !== -1){
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
			else{
				return $f;
			}
		}


		// estatus iniciales de los checks o verificaciones solicitadas con fondo gris en su respectiva celda en la tabla de checklist
		$f_identidad = "fondo0"; $s_identidad = '-';
		$f_empleo = "fondo0"; $s_empleo = '-';
		$f_estudios = "fondo0"; $s_estudios = '-';
		$f_visita = "fondo0"; $s_visita = '-';
		$f_penales = "fondo0"; $s_penales = '-';
		$f_ofac = "fondo0"; $s_ofac = '-';
		$f_lab = "fondo0"; $s_lab = '-';
		$f_medico = "fondo0"; $s_medico = '-';
		$f_global = "fondo0"; $s_global = '-';

		//Variable que posee los datos de finalización del proceso. Cambia los valores previos en caso de haber registro de finalización
		//según el estatus final que se le dé a cada check
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
				$comentario_final = $row->comentario_final;
			}
			if($identidad == 0){ $f_identidad = "fondo2"; $s_identidad = "Negative"; }
			if($identidad == 1){ $f_identidad = "fondo1"; $s_identidad = "Positive"; }
			if($identidad == 2){ $f_identidad = "fondo3"; $s_identidad = "Under Revision"; }
			if($identidad == 3){ $f_identidad = "fondo0"; $s_identidad = "NA"; }

			if($empleo == 0){ $f_empleo = "fondo2"; $s_empleo = "Negative"; }
			if($empleo == 1){ $f_empleo = "fondo1"; $s_empleo = "Positive"; }
			if($empleo == 2){ $f_empleo = "fondo3"; $s_empleo = "Under Revision"; }
			if($empleo == 3){ $f_empleo = "fondo0"; $s_empleo = "NA"; }

			if($estudios == 0){ $f_estudios = "fondo2"; $s_estudios = "Negative"; }
			if($estudios == 1){ $f_estudios = "fondo1"; $s_estudios = "Positive"; }
			if($estudios == 2){ $f_estudios = "fondo3"; $s_estudios = "Under Revision"; }
			if($estudios == 3){ $f_estudios = "fondo0"; $s_estudios = "NA"; }

			if($visita == 0){ $f_visita = "fondo2"; $s_visita = "Negative"; }
			if($visita == 1){ $f_visita = "fondo1"; $s_visita = "Positive"; }
			if($visita == 2){ $f_visita = "fondo3"; $s_visita = "Under Revision"; }
			if($visita == 3){ $f_visita = "fondo0"; $s_visita = "NA"; }

			if($penales == 0){ $f_penales = "fondo2"; $s_penales = "Negative"; }
			if($penales == 1){ $f_penales = "fondo1"; $s_penales = "Positive"; }
			if($penales == 2){ $f_penales = "fondo3"; $s_penales = "Under Revision"; }
			if($penales == 3){ $f_penales = "fondo0"; $s_penales = "NA"; }

			if($ofac == 0){ $f_ofac = "fondo2"; $s_ofac = "Negative"; }
			if($ofac == 1){ $f_ofac = "fondo1"; $s_ofac = "Positive"; }
			if($ofac == 2){ $f_ofac = "fondo3"; $s_ofac = "Under Revision"; }
			if($ofac == 3){ $f_ofac = "fondo0"; $s_ofac = "NA"; }

			if($lab == 0){ $f_lab = "fondo2"; $s_lab = "Negative"; }
			if($lab == 1){ $f_lab = "fondo1"; $s_lab = "Positive"; }
			if($lab == 2){ $f_lab = "fondo3"; $s_lab = "Under Revision"; }
			if($lab == 3){ $f_lab = "fondo0"; $s_lab = "NA"; }

			if($medico == 0){ $f_medico = "fondo2"; $s_medico = "Negative"; }
			if($medico == 1){ $f_medico = "fondo1"; $s_medico = "Positive"; }
			if($medico == 2){ $f_medico = "fondo3"; $s_medico = "Under Revision"; }
			if($medico == 3){ $f_medico = "fondo0"; $s_medico = "NA"; }
		$f_global = "fondo0"; $s_global = "NA"; }

		//Verificacion de los archivos que posee el candidato para indicar si se cargó o no 
		//para la segunda tabla de la portada para este fin
		$doc_acta = "NO";
		$doc_ine = "NO";
		$doc_rfc = "NO";
		$doc_curp = "NO";
		$doc_imss = "NO";
		$doc_estudio = "NO";
		$doc_dom = "NO";
		$doc_penal = "NO";
		$document = "School Certificate";
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
				else{
					$document = "School Certificate";
				}
			}

		}

		//Variable que posee las verificaciones de la documentación (verificacion_documento)
		$fecha_ver_documentos = '-';
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
			}
			if($ine_ano == "" && $ine_vertical == "" || $ine_ano == null && $ine_vertical == null){
				$ine_completo = "Número pasaporte:<br>".$ine."<br>";
			}
			else{
				$ine_completo = "Clave de elector:<br>".$ine."<br>Año de registro: ".$ine_ano."<br>Número vertical:<br>".$ine_vertical;
			}
			
			$penales_completo = "Document Number:<br>".$ver_penales;

			// $e = new DateTime($fechaEdicion);
			// $fecha_ver_documentos = $e->format('m/d/Y');
		}

		//Variable que posee los datos generales del candidato. Necesita ser revisado para omitir el foreach y
		//que se incrusten los campos de $datos directamente donde se requieran pintar
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
				$domicilio_internacional = $d->domicilio_internacional;
				$trabajo_inactivo = $d->trabajo_inactivo;
				$trabajo_gobierno = $d->trabajo_gobierno;
			}
			//Conversión de Fechas
			$hoy = formatoEspecialFecha($hoy);
			$e = new DateTime($hoy);
			$hoy2 = $e->format('m/d/Y');

			$e = new DateTime($f);
			$f_requested = $e->format('m/d/Y');
			
			$e = !empty($fecha_ver_laboral) ? new DateTime($fecha_ver_laboral->fecha_finalizado) : '-';
			$fecha_ver_laboral = ($e != '-') ? $e->format('m/d/Y') : $e;

			$e = !empty($fecha_ver_estudios) ? new DateTime($fecha_ver_estudios->fecha_finalizado) : '-';
			$fecha_ver_estudios = ($e != '-') ? $e->format('m/d/Y') : $e;

			$e = !empty($fecha_ver_penales) ? new DateTime($fecha_ver_penales->fecha_finalizado) : '-';
			$fecha_ver_penales = ($e != '-') ? $e->format('m/d/Y') : $e;

			$e = new DateTime($fecha_nacimiento);
			$fecha_nacimiento = $e->format('m/d/Y');

			$e = new DateTime($fecha_final);
			$fecha_final = $e->format('m/d/Y');

			//Definicion de estatus finales (candidato_bgc), el ícono y color relacionado al mismo estatus
			switch ($status_bgc) {
				case 0:
					$fondo = "fondo0";
					$icono = "img/iconos/bgc0.png";
					$s_bgc = "In process";
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
					$s_bgc = "Under Revision";
					break;
			}
			//Se obtienen los estados y municipios. Podría ser omitido para traerlo desde la consulta previa a este archivo
			$estado = $this->candidato_model->getEstado($id_estado);
			$municipio = $this->candidato_model->getMunicipio($id_municipio);
		}

		//Número de página
    $pagina = 1;
		
	?>
	<!-- Portada que reune los datos de finalizacion -->
	<div>
		<div class="col-md-4 borde-derecho">
			<img src="<?php echo base_url().'img/logo.png' ?>" width="190px" >
		</div>
		<div class="col-md-6">
			<span class="f-16 color-rodi margen-top"><b><?php echo $cliente; ?></span></b><br>
			<span class="f-16 color-rodi"><b>Background Check Report - Checklist</span></b>
		</div>
	</div>
	<div class="margen-50 margen-top">
		<table class="tabla w-100">
		  	<tr>
		    	<td class="encabezado right" width="20%"><p class="f-11"><b>Release Date</b></p></td>
					<?php 
					if(isset($fecha_bgc) && !empty($fecha_bgc)){ ?>
		    		<td class="right"><p class="f-11"><b><?php echo $fecha_bgc; ?></b></p></td>
						<?php 
					} else{  ?>
						<td class="right"><p class="f-11"><b>In process</b></p></td>
					<?php 
					}  ?>
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
					if($status_bgc == 0){
						echo '<td class="center"><p class="f-11"><b>Positive</b></p></td>';
						echo '<td class="center"><p class="f-11"><b>Negative</b></p></td>';
						echo '<td class="center"><p class="f-11"><b>Under Revision</b></p></td>';
					}
	    		if($status_bgc == 1){
	    			echo '<td class="center '.$fondo.'"><p class="f-11"><b>Positive</b></p></td>';
	    			echo '<td class="center"><p class="f-11"><b>Negative</b></p></td>';
	    			echo '<td class="center"><p class="f-11"><b>Under Revision</b></p></td>';
	    		}
	    		if($status_bgc == 2){
	    			echo '<td class="center"><p class="f-11"><b>Positive</b></p></td>';
	    			echo '<td class="center '.$fondo.'"><p class="f-11"><b>Negative</b></p></td>';
	    			echo '<td class="center"><p class="f-11"><b>Under Revision</b></p></td>';
	    		}
	    		if($status_bgc == 3){
	    			echo '<td class="center"><p class="f-11"><b>Positive</b></p></td>';
	    			echo '<td class="center"><p class="f-11"><b>Negative</b></p></td>';
	    			echo '<td class="center '.$fondo.'"><p class="f-11"><b>Under Revision</b></p></td>';
	    		}
	    	?>
	  	</tr>
	  	<tr>
	    	<td class="encabezado right" width="30%"><p class="f-12"><b>Remarks</b></p></td>
	    	<?php
					if($status_bgc == 0){
						echo '<td class="center" colspan="3"><p class="f-11"><b>In process</b></p></td>';
					} 
	    		if($status_bgc == 1){
	    			echo '<td class="center" colspan="3"><p class="f-11"><b>Suitable for hiring</b></p></td>';
	    		}
	    		if($status_bgc == 2){
	    			echo '<td class="center" colspan="3"><p class="f-11"><b>Do not suitable for hiring</b></p></td>';
	    		}
	    		if($status_bgc == 3){
	    			echo '<td class="center" colspan="3"><p class="f-11"><b>Under revision</b></p></td>';
	    		}
	    	?>
	  	</tr>
	</table><br>
	<!-- Tabla de estatus de verificaciones o checks -->
	<div class="col-md-6">
		<table class="media-tabla">
		  	<tr>
		    	<th class="encabezado">Check Item</th>
		    	<th class="encabezado">Status</th>
		    	<th class="encabezado">Delivery Date</th>
		  	</tr>
		  	<tr>
		  		<td>Identity check</td>
		    	<td class="<?php echo $f_identidad; ?>"><p class="f-14"><?php echo $s_identidad; ?></p></td>
		    	<td><?php echo $fechaFinal = (isset($fecha_final) && !empty($fecha_final)) ? $fecha_final : '-'; ?></td>
		  	</tr>
		  	<tr>
		  		<td>Employment History Check</td>
		    	<td class="<?php echo $f_empleo; ?>"><p class="f-14"><?php echo $s_empleo; ?></p></td>
		    	<td><?php echo $fecha_ver_laboral; ?></td>
		  	</tr>
		  	<tr>
		  		<td>Academic History Check</td>
		    	<td class="<?php echo $f_estudios; ?>"><p class="f-14"><?php echo $s_estudios; ?></p></td>
		    	<td><?php echo $fecha_ver_estudios; ?></td>
		  	</tr>
		  	<tr>
		  		<td>Criminal Records – Mexican</td>
		    	<td class="<?php echo $f_penales; ?>"><p class="f-14"><?php echo $s_penales; ?></p></td>
		    	<td><?php echo $fecha_ver_penales; ?></td>
		  	</tr>
		  	<tr>
		  		<td>Criminal Records – OFAC</td>
		    	<td class="<?php echo $f_ofac; ?>"><p class="f-14"><?php echo $s_ofac; ?></p></td>
		    	<td><?php echo $fecha_ver_penales; ?></td>
		  	</tr>
		</table>	
	</div>
	<!-- Tabla de documentos cargados al candidato -->
	<div class="col-md-6-2">
		<table class="media-tabla">
		  	<tr>
		    	<th class="encabezado">Supporting Documents</th>
		    	<th class="encabezado">Submitted (Y/N/NA)</th>
		  	</tr>
		  	<tr>
		  		<td>Birth Certificate</td>
		    	<td><?php echo $doc_acta; ?></td>
		  	</tr>
		  	<tr>
		  		<td>Government ID (IFE, INE, Passport, Cedula, Cartilla, FM2, FM3)</td>
		    	<td><?php echo $doc_ine; ?></td>
		  	</tr>
		  	<tr>
		  		<td>Personal National Identification Number (CURP)</td>
		    	<td><?php echo $doc_curp; ?></td>
		  	</tr>
		  	<tr>
		  		<td>Taxes ID Number (RFC)</td>
		    	<td><?php echo $doc_rfc; ?></td>
		  	</tr>
		  	<tr>
		  		<td>Social Security Number (IMSS)</td>
		    	<td><?php echo $doc_imss; ?></td>
		  	</tr>
		  	<tr>
		  		<td>Education Proof - Highest Degree</td>
		    	<td><?php echo $doc_estudio; ?></td>
		  	</tr>
		  	<tr>
		  		<td>Address Proof</td>
		    	<td><?php echo $doc_dom; ?></td>
		  	</tr>
		  	<tr>
		  		<td>Police Letter</td>
		    	<td><?php echo $doc_penal; ?></td>
		  	</tr>
		</table>
	</div><br>
	
	<pagebreak>

	<?php 
	//Se verifica si es diferente de vacío y nulo la variable de datos generales; 
	//tambien si $nacionalidad no es vacio ni nulo pero para el caso de que se hayan completado los datos generales
	if(!empty($datos) && !empty($nacionalidad)){ ?>
		<div class="div_datos">
			<p class="center f-18"><?php echo $pagina++; ?>. Personal Data</p>
			<?php 
			if($secciones->id_seccion_datos_generales == 1){ ?>
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
						<td class="encabezado">Number to leave Messages:</td>
						<td class="center"><p class="f-12"><?php echo $telefono_otro; ?></p></td>
						<td class="encabezado">E-mail:</td>
						<td class="center" colspan="3"><p class="f-12"><?php echo $correo; ?></p></td>
					</tr>
				</table>
			<?php 
			}
			if($secciones->id_seccion_datos_generales == 2){ ?>
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
						<td class="encabezado">Mobile Num:</td>
						<td class="center"><p class="f-12"><?php echo $celular; ?></p></td>
						<td class="encabezado">Home Num:</td>
						<td class="center"><p class="f-12"><?php echo $telefono_casa; ?></p></td>
						<td class="encabezado">Number to leave Messages:</td>
						<td class="center"><p class="f-12"><?php echo $telefono_otro; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado">E-mail:</td>
						<td class="center" colspan="5"><p class="f-12"><?php echo $correo; ?></p></td>
					</tr>
				</table>
			<?php 
			} ?>
		</div><br>
	<?php 
	} ?>

	<?php
	//Se verifica si es diferente de vacío y nulo la variable de documentacion
	if(!empty($ver_documento)){ ?>
		<div class="div_datos">
			<p class="center f-18"><?php echo $pagina++; ?>. Documents</p>
			<table class="">
				<tr>
					<th class="encabezado">Document</th>
					<th class="encabezado">Number of Document</th>
					<th class="encabezado">Date / Institution</th>
				</tr>
				<tr>
					<td class="encabezado center"><p class="f-12"><?php echo $document; ?></p></td>
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
					<td class="center"><p class="f-12"><?php echo $ver_penales_institucion; ?></p></td>
				</tr>
				<tr>
					<td class="encabezado center"><p class="f-12">Comments</p></td>
					<td class="center" colspan="2"><p class="f-12"><?php echo $comentario_ver_documento; ?></p></td>
				</tr>
			</table>
		</div>

		<pagebreak>
	<?php
	} ?>

	<?php
	if(!empty($ver_documento)){ ?>
		<div class="div_datos">
			<p class="center f-18"><?php echo $pagina++; ?>. Family Environment </p>
			<table class="">
					<tr>
						<th class="encabezado" colspan="2">Name</th>
						<th class="encabezado">Age</th>
						<th class="encabezado">Ocupation</th>
						<th class="encabezado">City/Company</th>
						<th class="encabezado w-17">Live with her/him</th>
					</tr>
					<?php 
					foreach($familia as $f){
						if($f->id_tipo_parentesco == 4 && $f->nombre != "undefined" && $f->edad != "undefined" && $f->puesto != "undefined" && $f->empresa != "undefined"){
							echo '<tr>';
							$conyuge = '';
							$conyuge .= '<td class="encabezado center"><p class="f-12">Wife/Husband</p></td><td class="center"><p class="f-12">'.$f->nombre.'</p></td>';
							$conyuge .= '<td class="center"><p class="f-12">'.$f->edad.'</p></td>';
							$conyuge .= '<td class="center"><p class="f-12">'.$f->puesto.'</p></td>';
							$conyuge .= '<td class="center"><p class="f-12">'.$f->empresa.'</p></td>';
							$conyuge .= ($f->misma_vivienda == 1) ? '<td class="center"><p class="f-12">Yes</p></td>' : '<td class="center"><p class="f-12">No</p></td>';
							echo $conyuge;
							echo '</tr>';
						}
						if($f->id_tipo_parentesco == 3){
							echo '<tr>';
							$hijo = '';
							$hijo .= '<td class="encabezado center"><p class="f-12">Child</p></td><td class="center"><p class="f-12">'.$f->nombre.'</p></td>';
							$hijo .= '<td class="center"><p class="f-12">'.$f->edad.'</p></td>';
							$hijo .= '<td class="center"><p class="f-12">'.$f->puesto.'</p></td>';
							$hijo .= '<td class="center"><p class="f-12">'.$f->empresa.'</p></td>';
							$hijo .= ($f->misma_vivienda == 1) ? '<td class="center"><p class="f-12">Yes</p></td>' : '<td class="center"><p class="f-12">No</p></td>';
							echo $hijo;
							echo '</tr>';
						}
						if($f->id_tipo_parentesco == 1){
							echo '<tr>';
							$padre = '';
							$padre .= '<td class="encabezado center"><p class="f-12">Father</p></td><td class="center"><p class="f-12">'.$f->nombre.'</p></td>';
							$padre .= '<td class="center"><p class="f-12">'.$f->edad.'</p></td>';
							$padre .= '<td class="center"><p class="f-12">'.$f->puesto.'</p></td>';
							$padre .= '<td class="center"><p class="f-12">'.$f->empresa.'</p></td>';
							$padre .= ($f->misma_vivienda == 1) ? '<td class="center"><p class="f-12">Yes</p></td>' : '<td class="center"><p class="f-12">No</p></td>';
							echo $padre;
							echo '</tr>';
						}
						if($f->id_tipo_parentesco == 2){
							echo '<tr>';
							$madre = '';
							$madre .= '<td class="encabezado center"><p class="f-12">Mother</p></td><td class="center"><p class="f-12">'.$f->nombre.'</p></td>';
							$madre .= '<td class="center"><p class="f-12">'.$f->edad.'</p></td>';
							$madre .= '<td class="center"><p class="f-12">'.$f->puesto.'</p></td>';
							$madre .= '<td class="center"><p class="f-12">'.$f->empresa.'</p></td>';
							$madre .= ($f->misma_vivienda == 1) ? '<td class="center"><p class="f-12">Yes</p></td>' : '<td class="center"><p class="f-12">No</p></td>';
							echo $madre;
							echo '</tr>';
						}
						if($f->id_tipo_parentesco == 6){
							echo '<tr>';
							$hermano = '';
							$hermano .= '<td class="encabezado center"><p class="f-12">Sister/Brother</p></td><td class="center"><p class="f-12">'.$f->nombre.'</p></td>';
							$hermano .= '<td class="center"><p class="f-12">'.$f->edad.'</p></td>';
							$hermano .= '<td class="center"><p class="f-12">'.$f->puesto.'</p></td>';
							$hermano .= '<td class="center"><p class="f-12">'.$f->empresa.'</p></td>';
							$hermano .= ($f->misma_vivienda == 1) ? '<td class="center"><p class="f-12">Yes</p></td>' : '<td class="center"><p class="f-12">No</p></td>';
							echo $hermano;
							echo '</tr>';
						}		  		
					}
					?>		  	
			</table>
		</div><br><br>
	<?php
	} ?>

	<?php
	//Se verifica si es diferente de vacío y nulo la variable de estudios y la variable de fecha de verificacion de estudios (verificaicion_Estudios)
	if(!empty($estudio) && $fecha_ver_estudios != '-'){ ?>
		<div class="div_datos">
			<p class="center f-18"><?php echo $pagina++; ?>. Studies Record</p>
			<table class="">
					<tr>
						<th class="encabezado">Level</th>
						<th class="encabezado">Period</th>
						<th class="encabezado">Institute</th>
						<th class="encabezado">City</th>
						<th class="encabezado">Certificate Obtained</th>
						<th class="encabezado">Validated</th>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Elementary School</p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->primaria_periodo; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->primaria_escuela; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->primaria_ciudad; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->primaria_certificado; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $valid = ($estudio->primaria_validada == 1)?'Yes':'No'; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Middle School</p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->secundaria_periodo; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->secundaria_escuela; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->secundaria_ciudad; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->secundaria_certificado; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $valid = ($estudio->secundaria_validada == 1)?'Yes':'No'; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">High School</p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->preparatoria_periodo; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->preparatoria_escuela; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->preparatoria_ciudad; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->preparatoria_certificado; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $valid = ($estudio->preparatoria_validada == 1)?'Yes':'No'; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">College</p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->licenciatura_periodo; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->licenciatura_escuela; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->licenciatura_ciudad; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $estudio->licenciatura_certificado; ?></p></td>
						<td class="center"><p class="f-12"><?php echo $valid = ($estudio->licenciatura_validada == 1)?'Yes':'No'; ?></p></td>
					</tr>
					<tr>
						<td class="left" colspan="6"><p class="f-12"><?php echo "<b>Seminaries/Courses Certificates:</b><br>".$estudio->otros_certificados; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Comments</p></td>
						<td class="center" colspan="5"><p class="f-12"><?php echo $estudio->comentarios; ?></p></td>
					</tr>
			</table>
		</div>

		<pagebreak>

		<div class="center sin-flotar margen-top">
			<p class="f-20"><?php echo $pagina++; ?>. Break(s) in Studies</p>
		</div>
		<div class="center">
			<textarea class="comentario" rows="3"><?php echo $estudio->carrera_inactivo; ?></textarea>
		</div>
		<div class="div_datos">
			<p class="center f-18"><?php echo $pagina++; ?>. School Documents Verification</p>
			<table class="">
					<tr>
						<td class="encabezado center"><p class="f-12">Studies verification requested</p></td>
						<td class="center"><p class="f-12"><?php echo $f_requested; ?></p></td>
						<!--td class="center" rowspan="2"><p class="f-12"><?php //echo $estatus_estudios->status; ?></p></!--td-->

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
				if($det_estudio){
					foreach($det_estudio as $det){
						$a = new DateTime($det->fecha);
						$f_det = $a->format('m/d/Y');
						echo '<tr>';
						echo '<td class="center w-17"><p class="f-12">'.$f_det.'</p></td>';
						echo '<td class="center"><p class="f-12">'.$det->comentarios.'</p></td>';
						echo '</tr>';
					}
				}
					?>
			</table>
		</div>

		<pagebreak>
	<?php
	} ?>


	<?php 
	//Se verifica si es diferente de vacío y nulo la variable de referencias laborales
	if(!empty($ref_laboral)){ 
		$cont = 1;
		foreach($ref_laboral as $ref){
			//Se obtiene la verificacion laboral de acuerdo a la posicion en la tabla con respecto al candidato, no tiene una llave foranea que las una
			//Se revisa que no este vacia o nula para pintar la iteracion
			$ver_laboral = $this->candidato_model->getVerificacionLaboral($cont, $id_candidato);
			if(!empty($ver_laboral)){ ?>
				<div class="div_datos">
					<p class="center f-18"><?php echo $pagina++; ?>. Labor References </p>
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
								<td class="center"><p class="f-12"><?php echo $entrada_laboral = formatoEspecialFecha($ref->fecha_entrada_txt); ?></p></td>
								<td class="center"><p class="f-12"><?php echo $entrada_verifica = formatoEspecialFecha($ver_laboral->fecha_entrada_txt); ?></p></td>
							</tr>
							<tr>
								<td class="encabezado center"><p class="f-12">Exit Date</p></td>
								<td class="center"><p class="f-12"><?php echo $salida_laboral = formatoEspecialFecha($ref->fecha_salida_txt); ?></p></td>
								<td class="center"><p class="f-12"><?php echo $salida_verifica = formatoEspecialFecha($ver_laboral->fecha_salida_txt); ?></p></td>
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
				</div><br>
				<div class="div_datos">
					<table class="">
							<tr>
								<td class="encabezado w-60">Did the candidate sue the company:</td>
								<td class="center"><?php echo $d1 = ($ver_laboral->demanda == 1)?'Yes':'No'; ?></td>
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
		}
	} 
	?>
  
	<?php 
	//Se verifica si es diferente de vacío y nulo la variable de datos generales 
	//y la variable de fecha de verificacion de estudios (verificaicion_Estudios)
	if(!empty($datos) && $fecha_ver_estudios != '-'){ ?>
		<div class="center sin-flotar margen-top">
			<p class="f-20"><?php echo $pagina++; ?>. Break(s) in Employment</p>
		</div>
		<div class="center">
			<textarea class="comentario" rows="3"><?php echo $trabajo_inactivo; ?></textarea>
		</div><br>
		<div class="div_datos">
			<p class="center f-18"><?php echo $pagina++; ?>. Employment references verification</p>
			<table class="">
					<tr>
						<td class="encabezado center"><p class="f-12">Labor verification requested</p></td>
						<td class="center"><p class="f-12"><?php echo $f_requested; ?></p></td>
						<!--td class="center" rowspan="2"><p class="f-12"><?php //echo $estatus_laborales->status; ?></p></!--td-->

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
				if($det_empleo){
					foreach($det_empleo as $det){
						$a = new DateTime($det->fecha);
						$f_det = $a->format('m/d/Y');
						echo '<tr>';
						echo '<td class="center w-17"><p class="f-12">'.$f_det.'</p></td>';
						echo '<td class="center"><p class="f-12">'.$det->comentarios.'</p></td>';
						echo '</tr>';
					}
				}
					?>
			</table>
		</div><br>
	<?php
	} ?>

	<?php 
	//Se verifica si es diferente de vacío y nulo la variable de referencias personales
	if(!empty($ref_personal)){ ?>
		<div class="div_datos">
			<p class="center f-18"><?php echo $pagina++; ?>.	Personal References</p>
			<p class="f-14 center">A) Personal reference</p>
			<table class="">
					<tr>
						<td class="encabezado center w-30"><p class="f-12">Name</p></td>
						<td class="center"><p class="f-12"><?php echo $ref_personal[0]->nombre; ?></p></td>
						<td class="encabezado center w-30"><p class="f-12">Phone</p></td>
						<td class="center"><p class="f-12"><?php echo $ref_personal[0]->telefono ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Time to know her/him:</p></td>
						<td class="center"><p class="f-12"><?php echo $ref_personal[0]->tiempo_conocerlo; ?></p></td>
						<td class="encabezado center"><p class="f-12">Why do you know her/him:</p></td>
						<td class="center"><p class="f-12"><?php echo $ref_personal[0]->donde_conocerlo ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Does she/he know where the candidate works/worked?</p></td>
						<td class="center"><p class="f-12"><?php echo $st = ($ref_personal[0]->sabe_trabajo == 1)?'Yes':'No'; ?></p></td>
						<td class="encabezado center"><p class="f-12">Does she/he know where the candidate lives?</p></td>
						<td class="center"><p class="f-12"><?php echo $sv = ($ref_personal[0]->sabe_vive == 1)?'Yes':'No'; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Comments:</p></td>
						<td class="center" colspan="3"><p class="f-12"><?php echo $ref_personal[0]->comentario; ?></p></td>
					</tr>
			</table>
		</div>
		<p class="f-14 center">B) Personal reference</p>
		<div class="div_datos">
			<table class="">
					<tr>
						<td class="encabezado center w-30"><p class="f-12">Name</p></td>
						<td class="center"><p class="f-12"><?php echo $ref_personal[1]->nombre; ?></p></td>
						<td class="encabezado center w-30"><p class="f-12">Phone</p></td>
						<td class="center"><p class="f-12"><?php echo $ref_personal[1]->telefono ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Time to know her/him:</p></td>
						<td class="center"><p class="f-12"><?php echo $ref_personal[1]->tiempo_conocerlo; ?></p></td>
						<td class="encabezado center"><p class="f-12">Why do you know her/him:</p></td>
						<td class="center"><p class="f-12"><?php echo $ref_personal[1]->donde_conocerlo ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Does she/he know where the candidate works/worked?</p></td>
						<td class="center"><p class="f-12"><?php echo $st = ($ref_personal[1]->sabe_trabajo == 1)?'Yes':'No'; ?></p></td>
						<td class="encabezado center"><p class="f-12">Does she/he know where the candidate lives?</p></td>
						<td class="center"><p class="f-12"><?php echo $sv = ($ref_personal[1]->sabe_vive == 1)?'Yes':'No'; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Comments:</p></td>
						<td class="center" colspan="3"><p class="f-12"><?php echo $ref_personal[1]->comentario; ?></p></td>
					</tr>
			</table>
		</div>
		<p class="f-14 center">C) Personal reference</p>
		<div class="div_datos">
			<table class="">
					<tr>
						<td class="encabezado center w-30"><p class="f-12">Name</p></td>
						<td class="center"><p class="f-12"><?php echo $ref_personal[2]->nombre; ?></p></td>
						<td class="encabezado center w-30"><p class="f-12">Phone</p></td>
						<td class="center"><p class="f-12"><?php echo $ref_personal[2]->telefono ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Time to know her/him:</p></td>
						<td class="center"><p class="f-12"><?php echo $ref_personal[2]->tiempo_conocerlo; ?></p></td>
						<td class="encabezado center"><p class="f-12">Why do you know her/him:</p></td>
						<td class="center"><p class="f-12"><?php echo $ref_personal[2]->donde_conocerlo ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Does she/he know where the candidate works/worked?</p></td>
						<td class="center"><p class="f-12"><?php echo $st = ($ref_personal[2]->sabe_trabajo == 1)?'Yes':'No'; ?></p></td>
						<td class="encabezado center"><p class="f-12">Does she/he know where the candidate lives?</p></td>
						<td class="center"><p class="f-12"><?php echo $sv = ($ref_personal[2]->sabe_vive == 1)?'Yes':'No'; ?></p></td>
					</tr>
					<tr>
						<td class="encabezado center"><p class="f-12">Comments:</p></td>
						<td class="center" colspan="3"><p class="f-12"><?php echo $ref_personal[2]->comentario; ?></p></td>
					</tr>
			</table>
		</div>
		
		<pagebreak>
	<?php
	} ?>

	<?php 
	if(!empty($datos) && !empty($trabajo_gobierno)){ ?>
		<div class="center sin-flotar margen-top">
			<p class="f-20"><?php echo $pagina++; ?>.	Has he worked in any government entity, Politic Party or NGO?</p>
		</div>
		<div class="center">
			<textarea class="comentario" rows="3"><?php echo $trabajo_gobierno; ?></textarea>
		</div>

		<pagebreak>
	<?php
	} ?>

	
	<?php 
	//Se verifica si es diferente de vacío y nulo la variable de archivos o documentos cargados al candidato
	if(!empty($docs)){
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 12){
				echo '<div class="center sin-flotar margen-top">';
				echo '<p class="f-20">'.$pagina++.'. VALIDATED Criminal Records </p>';
				echo '</div>';
				echo '<div class="center">';
				echo '<img src="'.base_url().'_docs/'.$doc->archivo.'">';
				echo '</div>';
        echo '<pagebreak>';
			}
		}
	}
	?>

	<?php 
	//Se verifica si existe y es diferente de vacío y nulo la variable de verificacion criminal o penal (verificacion_penales)
	if(isset($fecha_ver_penales) && $fecha_ver_penales != '-'){ ?>
		<div class="div_datos">
			<p class="center f-18"><?php echo $pagina++; ?>. Criminal Records Verification</p>
			<table class="">
					<tr>
						<td class="encabezado center"><p class="f-12">Criminal Record Document requested</p></td>
						<td class="center"><p class="f-12"><?php echo $f_requested; ?></p></td>
						<!--td class="center" rowspan="2"><p class="f-12"><?php //echo $estatus_penales->status; ?></p></!--td-->
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
				if($det_penales){
					foreach($det_penales as $pen){
						$a = new DateTime($pen->fecha);
						$f_det = $a->format('m/d/Y');
						echo '<tr>';
						echo '<td class="center w-17"><p class="f-12">'.$f_det.'</p></td>';
						echo '<td class="center"><p class="f-12">'.$pen->comentarios.'</p></td>';
						echo '</tr>';
					}
				}
					?>
			</table>
		</div>
	<?php
	}
	?>
    
  <?php 
	//Se verifica si la variable de busquedas globales es diferente de vacío y nulo y si es id = 7 
	//con respecto al registro de candidato_seccion en la columna id_seccion_global_search 
	if(!empty($secciones->id_seccion_global_search) && $secciones->id_seccion_global_search == 7){ ?>
		<div class="div_datos">
			<p class="center f-18"><?php echo $pagina++; ?>. Global Data Searches</p>
			<table class="">
        <tr>
          <td class="encabezado" width="20%">Law enforcement</td>
          <td class="center"><p class="f-12"><?php echo $global_searches->law_enforcement; ?></p></td>
        </tr>
        <tr>
          <td class="encabezado" width="20%">Regulatory</td>
          <td class="center"><p class="f-12"><?php echo $global_searches->regulatory; ?></p></td>
        </tr>
        <tr>
          <td class="encabezado" width="20%">Sanctions</td>
          <td class="center"><p class="f-12"><?php echo $global_searches->sanctions; ?></p></td>
        </tr>
        <tr>
          <td class="encabezado" width="20%">Web and media searches</td>
          <td class="center"><p class="f-12"><?php echo $global_searches->media_searches; ?></p></td>
        </tr>
        <tr>
          <td class="encabezado" width="20%">Other bodies</td>
          <td class="center"><p class="f-12"><?php echo $global_searches->other_bodies; ?></p></td>
        </tr>
        <tr>
          <td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
        </tr>
			</table>
		</div><br><br>
		<pagebreak>

	<?php
	} ?>
  

	
	<?php 
	//Se verifica si es diferente de vacío y nulo la variable de archivos o documentos cargados al candidato
	if($docs){
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 11){
				echo '<div class="center sin-flotar margen-top">';
				echo '<p class="f-20">'.$pagina++.'. VALIDATED Criminal Records – OFAC</p>';
				echo '</div>';
				echo '<div class="center">';
				echo '<img src="'.base_url().'_docs/'.$doc->archivo.'">';
				echo '</div>';
			}
		}
	}
	?>
	<?php 
  if($docs){
    foreach($docs as $doc){
      if($doc->id_tipo_documento == 7){
        echo '<pagebreak>';
        echo '<div class="center">';
        echo '<h2>'.$pagina++.'. Other Checks and Artifacts </h2>';
        echo '<img src="'.base_url().'_docs/'.$doc->archivo.'">';
        echo '</div>';
      }
    }
    foreach($docs as $doc){
      if($doc->id_tipo_documento == 8){
        echo '<pagebreak>';
        echo '<div class="center">';
        //echo '<h2>Privacy Notice </h2>';
        echo '<img src="'.base_url().'_docs/'.$doc->archivo.'">';
        echo '</div>';
      }
    }
    foreach($docs as $doc){
      if($doc->id_tipo_documento == 9){
        echo '<pagebreak>';
        echo '<div class="center">';
       // echo '<h2>Employment History (NSS) </h2>';
        echo '<img src="'.base_url().'_docs/'.$doc->archivo.'">';
        echo '</div>';
      }
    }
    foreach($docs as $doc){
      if($doc->id_tipo_documento == 13){
        echo '<pagebreak>';
        echo '<div class="center">';
        //echo '<h2>Work letter</h2>';
        echo '<img src="'.base_url().'_docs/'.$doc->archivo.'">';
        echo '</div>';
      }
    }
    foreach($docs as $doc){
      if($doc->id_tipo_documento == 10){
        echo '<pagebreak>';
        echo '<div class="center">';
        //echo '<h2>Professional licence</h2>';
        echo '<img src="'.base_url().'_docs/'.$doc->archivo.'">';
        echo '</div>';
      }
    }
    foreach($docs as $doc){
      if($doc->id_tipo_documento == 23){
        echo '<pagebreak>';
        echo '<div class="center">';
        //echo '<h2>Mail evidence </h2>';
        echo '<img src="'.base_url().'_docs/'.$doc->archivo.'">';
        echo '</div>';
      }
    }
    foreach($docs as $doc){
      if($doc->id_tipo_documento == 24){
        echo '<pagebreak>';
        echo '<div class="center">';
        //echo '<h2>Chat evidence </h2>';
        echo '<img src="'.base_url().'_docs/'.$doc->archivo.'">';
        echo '</div>';
      }
    }
    foreach($docs as $doc){
      if($doc->id_tipo_documento == 30){
        echo '<pagebreak>';
        echo '<div class="center">';
        //echo '<h2>Global data searches </h2>';
        echo '<img src="'.base_url().'_docs/'.$doc->archivo.'">';
        echo '</div>';
      }
    }
    foreach($docs as $doc){
      if($doc->id_tipo_documento == 18){
        echo '<pagebreak>';
        echo '<div class="center">';
        //echo '<h2>Global Search Check </h2>';
        echo '<img src="'.base_url().'_docs/'.$doc->archivo.'">';
        echo '</div>';
      }
    }
  }
	?>
</body>
</html>