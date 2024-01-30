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
	/*table, th, td { border: 1px solid black; border-collapse: collapse;}*/
	.tabla { width:90%; border: 0;}
	/*th { text-transform: none; }*/
	.borde-inferior { border-bottom: 1px solid gray; padding: 5px; }
	/*th, td { padding: 5px;}*/
	.media-tabla { width: 90%; }
	.encabezado { background: #d9dadb; }
	.comentario { width: 80%; border: 1px solid gray; }
	.padding-top { padding-top: 100px; }
	.margen-top { margin-top: 100px; }
	.margen-bottom { margin-bottom: 100px; }
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
	
</style>
<body>
	<?php
		$aux = explode(' ', $doping->fecha_resultado);
		$f = explode('-', $aux[0]);
		$fecha_resultado = $f[2].'/'.$f[1].'/'.$f[0];

		$aux = explode(' ', $doping->fecha_doping);
		$f = explode('-', $aux[0]);
		$fecha_doping = $f[2].'/'.$f[1].'/'.$f[0];
		$foto = '';

		$subcliente = ($doping->subcliente == '' || $doping->subcliente == null)? '':'-'.$doping->subcliente;
		$proyecto = ($doping->proyecto == '' || $doping->proyecto == null)? '':$doping->proyecto;

		$descripcion = "";
		$s = explode(',', $doping->sustancias);
		$num_sustancias = count($s);
		for($i = 0; $i < count($s); $i++){
			$sust = $this->doping_model->getSustanciaCandidato($s[$i]);
			$descripcion .= $sust->abreviatura.' ';
		}
		
		if($doping->razon == 1){
			$motivo = "New entry";
		}
		if($doping->razon == 2){
			$motivo = "Random";
		}
		if($doping->razon == 3){
			$motivo = "Update";
		}

		$data['sustancias'] = $this->doping_model->getSustanciasDoping($doping->id);
		foreach($data['sustancias'] as $d){
			$s = $this->doping_model->getSustanciaCandidato($d->id_sustancia);
			if($d->resultado == 0){
				$res = 'Negative';
			}
			elseif ($d->resultado == 1) {
				$res = 'Positive';
			}
			else{
				$res = 'Not valid';
			}
			$desc[] = $s->descripcion_ingles;
			$nom[] = $s->nombre_sistematico;
			$result[] = $res;
			$ref[] = $s->valor_referencia;		
		} 	
		$firma = base_url().'img/'.$area->firma;
		$qr_consulta = base_url().'_qrconsult/'.$qr;
	?>
	<!-- HOJA 1 -->
	<br><br><br><br>
	<div class="w-80 flotar">
		<table class="tabla">
		  	<tr>
		    	<th width="20%">Name</th>
		    	<td class="left borde-inferior" colspan="3"><p class="f-12"><?php echo mb_strtoupper($doping->nombre).' '.mb_strtoupper($doping->paterno).' '.mb_strtoupper($doping->materno); ?></p></td>
		  	</tr>
		  	<tr>
		    	<th width="20%">Date</th>
		    	<td class="left borde-inferior"><p class="f-12"><?php echo $fecha_resultado; ?></p></td>
		    	<th width="20%">Folio</th>
		    	<td class="left borde-inferior"><p class="f-12"><?php echo $doping->codigo_prueba; ?></p></td>
		  	</tr>
		  	<tr>
		    	<th width="30%">Test code</th>
		    	<td class="left borde-inferior"><p class="f-12"><?php echo "AD-".$doping->paquete; ?></p></td>
		    	<th width="20%">Company</th>
		    	<?php 
		    		if($doping->cliente == 'TATA' || $doping->cliente == 'LAPI'){ ?>
						<td class="left borde-inferior"><p class="f-12"><?php echo $proyecto; ?></p></td>
		    	<?php	
		    		}
		    		elseif($doping->id_subcliente == 180){
		    			$subcliente = str_replace('-', '', $subcliente); ?>
		    			<td class="left borde-inferior"><p class="f-12"><?php echo $subcliente; ?></p></td>
		    	<?php
		    		}
		    		else{ ?>
						<td class="left borde-inferior"><p class="f-12"><?php echo $doping->cliente.''.$subcliente; ?></p></td>
		    	<?php	
		    		}
		    	?>
		    	
		  	</tr>
		  	<tr>
		    	<th width="20%">Description</th>
		    	<td class="left borde-inferior" colspan="3"><p class="f-12"><?php echo $descripcion; ?></p></td>
		  	</tr>
		  	<tr>
		    	<th width="30%">Test date</th>
		    	<td class="left borde-inferior"><p class="f-12"><?php echo $fecha_doping; ?></p></td>
		    	<th width="20%">Reason for testing</th>
		    	<td class="left borde-inferior"><p class="f-12"><?php echo $motivo; ?></p></td>
		  	</tr>
		</table>
	</div>
	<div style="height: 160px;position: relative">
		<?php echo $foto; ?>
	</div>
	<br><br>
	<table class="centrado" border="1" cellpadding="0" cellspacing="0" bordercolor="#E2E1E1">
		<tr>
			<th class="padding-3">Test</th>
			<th class="padding-3">Result</th>
			<th class="padding-3">Unit</th>
			<th class="padding-3">Reference value</th>
		</tr>
		
		<?php 
    for($i = 0; $i < count($desc); $i++){
      if($ids[$i] != 16 && $ids[$i] != 18)
        $unidades = '<td class="texto-centrado padding-5" >ng/ml</td>';
      if($ids[$i] == 16 || $ids[$i] == 19)
        $unidades = '<td class="texto-centrado padding-5" ></td>';
      if($ids[$i] == 18)
        $unidades = '<td class="texto-centrado padding-5" >mg/dL</td>';
      
      echo '<tr>';
      echo '<td class="padding-5" ><b>'.$desc[$i].'</b><br>'.$nom[$i].'</td>';
      echo '<td class="texto-centrado padding-5" ><b>'.$result[$i].'</b></td>';
      echo $unidades;
      echo '<td class="texto-centrado padding-5">'.$ref[$i].'</td>';
      echo '</tr>';
    } ?>	
	</table>
	<p class="texto-centrado">Drug of abuse research is a test of scrutiny. <br>In case of positivity, a confirmatory test should be performed. <br>INVALID RESULT WITHOUT THE STAMP OF AUTHENTICITY ENGRAVED ON THE PRESENT.  <br>If you have any questions about this study, please call us at: (33)33309678</p>
	<?php 
  $cedula = (!empty($area->cedula))? '<span>Cédula Profesional: '.$area->cedula.'</span><br>' : '<span>Personal autorizado por laboratorio</span><br>';
	if($num_sustancias <= 6){ ?>
		<div class="">
			<div class="texto-centrado" style="float: left; width:85%; margin-left: 20px;">
				<img class="" width="220px" src="<?php echo $firma; ?>"><br><span><?php echo $area->profesion_responsable.' '.$area->responsable; ?></span><br><?php echo $cedula; ?><span>Laboratorio de Análisis</span><br><span>PERINTEX SC.</span><br><span>Cédula de licencia municipal: 580386</span><br><span>REG. SSA COFEPRIS: 21040912</span><br><img width="100px" src="<?php echo base_url().'img/qr_cofepris.jpg' ?>">
			</div>
			<div style="float: left; width:15%; margin-top: 80px; margin-left: -30px;">
        <img src="<?php echo $qr_consulta; ?>">
      </div>
		</div>
	<?php 
	}
	else{ ?>
		<div style="margin-left: 40px; width: 100%">
			<div style="float: left; width: 35%; text-align: center;">
				<img class="" width="170px" src="<?php echo $firma; ?>"><br><span><?php echo $area->profesion_responsable.' '.$area->responsable; ?></span><br><?php echo $cedula; ?>
			</div>
			<div style="float: left; width: 35%; text-align: center;">
				<span>Laboratorio de Análisis</span><br><span>PERINTEX SC.</span><br><span>Cédula de licencia municipal: 580386</span><br><span>REG. SSA COFEPRIS: 21040912</span><br><img width="60px" src="<?php echo base_url().'img/qr_cofepris.jpg' ?>">	
			</div>
			<div style="float: left; width:15%; margin-top: 20px; margin-left: 20px;">
        <img src="<?php echo $qr_consulta; ?>">
      </div>
		</div>
	<?php
	} ?>
</body>
</html>