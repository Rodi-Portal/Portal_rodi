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
	.flotar-derecha{ float: right; }
	table, th, td { border: 1px solid black; border-collapse: collapse;}
	.tabla { width:90%; border: 0;}
	/*th { text-transform: none; }*/
	.borde-inferior { border-bottom: 1px solid gray; padding: 5px; }
	/*th, td { padding: 5px;}*/
	.media-tabla { width: 90%; }
	.encabezado { background: #d9dadb; }
	.comentario { width: 80%; border: 1px solid gray; }
	.margen-top { margin-top: 100px; }
	.margen-left { margin-left: 20px !important; }
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
	.h-150 { height: 150px; }
	.foto { margin-left:-20px; }
	.texto-centrado { text-align: center;}
	.padding-5 { padding: 5px; }
	.padding-3 { padding: 3px; }
	.huella { border: 1px solid rgba(0,0,0,0.7); }
	.subrayado { text-decoration: underline; }
	
</style>
<body>
	<?php

		$aux = explode(' ', $doping->fecha_doping);
		$f = explode('-', $aux[0]);
		$fecha_doping = $f[2].'/'.$f[1].'/'.$f[0];

		$aux = explode(' ', $doping->fecha_nacimiento);
		$f = explode('-', $aux[0]);
		$fecha_nacimiento = $f[2].'/'.$f[1].'/'.$f[0];

		if($doping->foto == '' || $doping->foto == null){
			$foto = '<img width="160px" height="160px" class="foto" src="'.base_url().'img/logo.png">';
		}
		else{
			$foto = '<img width="160px" height="160px" class="foto" src="'.base_url().'_doping/'.$doping->foto.'">';
		}

		$subcliente = ($doping->subcliente == '' || $doping->subcliente == null)? '':'-'.$doping->subcliente;
		$proyecto = ($doping->proyecto == '' || $doping->proyecto == null)? '':$doping->proyecto;

		$descripcion = "";
		$s = explode(',', $doping->sustancias);
		for($i = 0; $i < count($s); $i++){
			$sust = $this->doping_model->getSustanciaCandidato($s[$i]);
			$descripcion .= $sust->abreviatura.' ';
		}
		
		if($doping->razon == 1){
			$motivo = "Nuevo ingreso";
		}
		if($doping->razon == 2){
			$motivo = "Aleatorio";
		}
		if($doping->razon == 3){
			$motivo = "Actualización";
		}

		$data['sustancias'] = $this->doping_model->getSustanciasDoping($doping->id);
		foreach($data['sustancias'] as $d){
			$s = $this->doping_model->getSustanciaCandidato($d->id_sustancia);
			$res = ($d->resultado == 0)? 'Negativo':'Positivo'; 
			$desc[] = $s->descripcion;
			$nom[] = $s->nombre_sistematico;
			$result[] = $res;
			$ref[] = $s->valor_referencia;		
		} 	
	?>
	<!-- HOJA 1 -->
	<p class="f-18 center"><b>Carta Cadena Custodia</b></p>
	<p class="f-14 right"><b>Folio: </b><?php echo $doping->codigo_prueba; ?></p>
	<table class="tabla w-100">
	  	<tr>
	    	<td class="encabezado left" width="25%"><p class="f-12"><b>Nombre:</b></p></td>
	    	<td class="left" colspan="3"><p class="f-11"><?php echo mb_strtoupper($doping->nombre).' '.mb_strtoupper($doping->paterno).' '.mb_strtoupper($doping->materno); ?></p></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado left" width="25%"><p class="f-12"><b><p class="f-12">Fecha:</p></b></p></td>
	    	<td class="center"><?php echo $fecha_doping; ?></td>
	    	<td class="encabezado left" width="15%"><p class="f-12"><b><p class="f-12">Institución:</p></b></p></td>
	    	<td class="center">
	    		<?php 
					if($doping->cliente == 'TATA' || $doping->cliente == 'LAPI'){ ?>
						<p class="f-12"><?php echo $doping->cliente.'-'.$proyecto; ?></p>
				<?php	
					}
					else{ ?>
						<p class="f-12"><?php echo $doping->cliente.''.$subcliente; ?></p>
				<?php	
					}
				?>
	    	</td>
	  	</tr>
	  	<tr>
	  		<td class="encabezado left" width="25%"><p class="f-12"><b><p class="f-12">Identificación con fotografía:</p></b></p></td>
	    	<td class="center"><?php echo $doping->identificacion; ?><br><?php echo $doping->ine; ?></td>
	    	<td class="encabezado left" width="25%"><p class="f-12"><b>Fecha de nacimiento:</b></p></td>
	    	<td class="center"><?php echo $fecha_nacimiento; ?></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado left" width="25%"><p class="f-12"><b>Razón para la Prueba:</b></p></td>
	    	<td class="center"><?php echo $motivo; ?></td>
	    	<td class="encabezado left" width="25%"><p class="f-12"><b>Para detección de los siguientes metabolitos:</b></p></td>
	    	<td class="center"><p class="f-11"><b><?php echo $doping->paquete; ?></b></p></td>
	  	</tr>
	  	<tr>
	    	<td class="encabezado left" width="25%"><p class="f-12"><b>Medicamentos recetados:</b></p></td>
	    	<td class="center" colspan="3"><p class="f-11"><b><?php echo $doping->medicamentos; ?></b></p></td>
	  	</tr>
	</table><br>
	<p class="f-14 center"><b>Autorización Prueba de Sustancias Controladas</b></p>
	<p class="f-12">Autorizo que se me tome la muestra de orina para ser evaluada por el laboratorio contratado y que se entreguen los resultados a la Empresa que me refiere, quien contrató este servicio, así mismo los resultados quedarán a disposición de esta Empresa para que sean analizados y pueden tomar las decisiones pertinentes. De acuerdo a los artículos 134, 135 y anexos de la Ley Federal del Trabajo vigente.</p><br>
	<div class="col-md-6">
		<hr class="margen-top">
		<p class="f-12 center">NOMBRE</p>
	</div>
	<div class="col-md-4-2 huella h-150">
		<p style="position: relative;margin-top: 140px;text-align: center;">HUELLA</p>
	</div>
	<div class="col-md-6 sin-flotar">
		<hr class="margen-top">
		<p class="f-12 center">FIRMA</p>
	</div>
	<div class="col-md-4-2">
		<hr class="margen-top">
		<p class="f-12 center">HORA</p><br>
	</div>
	<div class="sin-flotar">
		<p class="f-14"><b>Observaciones:</b> <br><br></p>
		<p><hr></p>
	</div>
</body>
</html>