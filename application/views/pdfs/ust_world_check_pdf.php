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
				$global_searches = $row->global_searches_check;
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

      if($global_searches == 0){ $f_global_searches = "fondo2"; $s_global_searches = "Negative"; }
			if($global_searches == 1){ $f_global_searches = "fondo1"; $s_global_searches = "Positive"; }
			if($global_searches == 2){ $f_global_searches = "fondo3"; $s_global_searches = "Under Revision"; }
			if($global_searches == 3){ $f_global_searches = "fondo0"; $s_global_searches = "NA"; }

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
				else{
					$document = "School Certificate";
				}
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
				$estado_civil = $d->estado_civil;
				$colonia = $d->colonia;
				$id_estado = $d->id_estado;
				$id_municipio = $d->id_municipio;
				$cp = $d->cp;
				$celular = $d->celular;
				$telefono_casa = $d->telefono_casa;
				$telefono_otro = $d->telefono_otro;
				$correo = $d->correo;
				//$anos_direccion = $d->anos_direccion;
				//$meses_direccion = $d->meses_direccion;
				//$horas_traslado = $d->horas_traslado;
				//$minutos_traslado = $d->minutos_traslado;
				//$id_transporte = $d->id_transporte;
				$trabajo_inactivo = $d->trabajo_inactivo;
				$trabajo_gobierno = $d->trabajo_gobierno;
				
				
			}
			//Fechas
			$hoy = formatoEspecialFecha($hoy);
			$e = new DateTime($hoy);
			$hoy2 = $e->format('m/d/Y');

			$e = new DateTime($f);
			$f_requested = $e->format('m/d/Y');

			$e = new DateTime($fecha_nacimiento);
			$fecha_nacimiento = $e->format('m/d/Y');

			$e = new DateTime($fecha_final);
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
					$s_bgc = "Under Revision";
					break;
			}
			//Indicadores
			$estado = $this->candidato_model->getEstado($id_estado);
			$municipio = $this->candidato_model->getMunicipio($id_municipio);
			
		}

		/*
		<td class="center"><p class="f-14"><img class="icono" src="<?php echo base_url()."".$icono; ?>"><?php echo $bgc; ?></p></td>
	*/
	?>
	<!-- HOJA 1 -->
	<div>
		<div class="col-md-4 borde-derecho">
			<img src="<?php echo base_url().'img/logo.png' ?>" width="190px" >
		</div>
		<div class="col-md-6">
			<span class="f-16 color-rodi margen-top"><b><?php echo $cliente; ?></span></b><br>
			<span class="f-16 color-rodi"><b>World Check Report - Checklist</span></b>
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
		    	<td><?php echo $fecha_final; ?></td>
		  	</tr>
		  	<tr>
		  		<td>World Check</td>
		    	<td class="<?php echo $f_global_searches; ?>"><p class="f-14"><?php echo $s_global_searches; ?></p></td>
		    	<td><?php echo $fecha_final; ?></td>
		  	</tr>
		</table>	
	</div>
	<div class="col-md-6-2">
		<table class="media-tabla">
		  	<tr>
		    	<th class="encabezado">Supporting Documents</th>
		    	<th class="encabezado">Submitted (Y/N/NA)</th>
		  	</tr>
		  	<tr>
		  		<td>Government ID (IFE, INE)</td>
		    	<td><?php echo $doc_ine; ?></td>
		  	</tr>
		</table>
	</div><br><br><br>
	<div class="center sin-flotar margen-top">
		<p class="f-20">FINAL STATEMENT</p>
	</div>
	<div class="center">
		<textarea class="comentario" rows="7"><?php echo $comentario_final; ?></textarea>
	</div><br><br><br><br>
	<div class="center firma centrado">
		<p class="">AUTHORIZED SIGNATURE</p>
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
	</div><br><br>

  <?php 
  if($docs){
    foreach($docs as $doc){
      if($doc->id_tipo_documento == 3){
        echo '<pagebreak>';
        echo '<div class="center">';
        echo '<h2>ID</h2>';
        echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="650" height="750">';
        echo '</div>';
      }
    }
  }
  if($docs){
    foreach($docs as $doc){
      if($doc->id_tipo_documento == 11){
        echo '<pagebreak>';
        echo '<div class="center">';
        echo '<h2>OFAC</h2>';
        echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="650" height="750">';
        echo '</div>';
      }
    }
  }

  if($docs){
    foreach($docs as $doc){
      if($doc->id_tipo_documento == 18){
        echo '<pagebreak>';
        echo '<div class="center">';
        echo '<h2>World check</h2>';
        echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="650" height="750">';
        echo '</div>';
      }
    }
  }

  if($docs){
    foreach($docs as $doc){
      if($doc->id_tipo_documento == 8){
        echo '<pagebreak>';
        echo '<div class="center">';
        echo '<h2>Privacy notice</h2>';
        echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="650" height="750">';
        echo '</div>';
      }
    }
  }
  ?>
</body>
</html>