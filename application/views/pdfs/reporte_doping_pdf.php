<!DOCTYPE html>
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
	/*table, th, td { border: 1px solid black; border-collapse: collapse;}*/
  .tabla_portada, .tabla_portada th, .tabla_portada td { border: 1px solid black; border-collapse: collapse;}
  .tabla_portada th { text-transform: none; }
	.tabla { margin: 0 auto; width:80%; }
	.tabla_portada th, .tabla_portada td { padding: 3px; text-align: center; }
  /*th, td { padding: 5px;}*/
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
	.firma{ width: 100px; height: 163px; padding-left: 20px;}
	.borde-inferior { border-bottom: 1px solid gray; padding: 5px; }
	.padding-3 { padding: 3px; }
	.padding-5 { padding: 5px; }
	.texto-centrado { text-align: center;}
  .p{font-size: 11px;}
  .tabla_doping { width:90%; border: 0;}
	.foto { margin-left:-20px; }
	.flotar{ float: left; }

</style>
<body>
	<?php
		$aux = explode(' ', $doping->fecha_resultado);
		$f = explode('-', $aux[0]);
		$fecha_resultado = $f[2].'/'.$f[1].'/'.$f[0];

		$aux = explode(' ', $doping->fecha_doping);
		$f = explode('-', $aux[0]);
		$fecha_doping = $f[2].'/'.$f[1].'/'.$f[0];

    $fecha_bgc = DateTime::createFromFormat('Y-m-d H:i:s', $doping->fecha_resultado);
		$fecha_bgc = $fecha_bgc->format('F d, Y');

		if($doping->foto == '' || $doping->foto == null){
			$foto = '<img width="125px" height="100px" class="foto" src="'.base_url().'img/logo_pie.png">';
		}
		else{
			$foto = '<img width="125px" height="125px" class="foto" src="'.base_url().'_doping/'.$doping->foto.'">';
		}

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
			if($d->resultado == 0){
				$res = 'Negativo';
			}
			elseif ($d->resultado == 1) {
				$res = 'Positivo';
			}
			else{
				$res = 'Inválido';
			}
			$ids[] = $s->id;
			$desc[] = $s->descripcion;
			$nom[] = $s->nombre_sistematico;
			$result[] = $res;
			$ref[] = $s->valor_referencia;		
		} 	
		$firma = base_url().'img/'.$area->firma;
		$qr_consulta = base_url().'_qrconsult/'.$qr;

    //Estatus Doping
    switch ($doping->resultado) {
      case 0:
        $fondo = "fondo1";
        $icono = "img/iconos/bgc0.png";
        $s_bgc = "Undefined";
        break;
      case 1:
        $fondo = "fondo2";
        $icono = "img/iconos/bgc1.png";
        $s_bgc = "Positive";
        break;
    }
	?>
	<!-- HOJA 1 -->
  <div>
		<div class="col-md-12 texto-centrado">
			<span class="f-16 color-rodi margen-top"><b><?php echo $doping->cliente.' - '.$doping->proyecto; ?></span></b>
			<span class="f-16 color-rodi"><b>Background Check Report - Checklist</span></b>
		</div>
	</div>
  <div class="margen-50 margen-top">
		<table class="tabla_portada tabla w-100">
      <tr>
        <td class="encabezado right" width="20%"><p class="f-11"><b>Release Date</b></p></td>
        <td class="right"><p class="f-11"><b><?php echo $fecha_bgc; ?></b></p></td>
      </tr>
		</table>
	</div>
	<br>
  <table class=" tabla_portada tabla w-100">
    <tr>
      <td class="encabezado right" width="30%"><p class="f-12"><b>Full Candidate Name</b></p></td>
      <td class="center" colspan="2"><p class="f-11"><b><?php echo mb_strtoupper($doping->nombre).' '.mb_strtoupper($doping->paterno).' '.mb_strtoupper($doping->materno); ?></b></p></td>
    </tr>
    <tr>
      <td class="encabezado right" width="30%"><p class="f-12"><b>Final BGC Status</b></p></td>
      <?php 
        if($doping->resultado == 1){
          echo '<td class="center"><p class="f-11"><b>Approved</b></p></td>';
          echo '<td class="center '.$fondo.'"><p class="f-11"><b>Not approved</b></p></td>';
        }
        if($doping->resultado == 0){
          echo '<td class="center '.$fondo.'"><p class="f-11"><b>Approved</b></p></td>';
          echo '<td class="center"><p class="f-11"><b>Not approved</b></p></td>';
        }
      ?>
    </tr>
    <tr>
      <td class="encabezado right" width="30%"><p class="f-12"><b>Remarks</b></p></td>
      <?php 
      if($doping->resultado == 1){ ?>
        <td class="center" colspan="2"><p class="f-11">The candidate failed the drug test</p></td>
      <?php 
      }
      else{ ?>
        <td class="center" colspan="2"><p class="f-11">The candidate passed the drug test</p></td>
      <?php 
      } ?>
    </tr>
	</table>
  <br>
  <div class="flotar-izquierda w-70">
		<table class="tabla_portada w-90">
      <tr>
        <th class="encabezado">Check Item</th>
        <th class="encabezado">Status</th>
        <th class="encabezado">Delivery Date</th>
      </tr>
      <tr>
        <td class="left">Identity check</td>
        <td>N/A</td>
        <td>N/A</td>
      </tr>
      <tr>
        <td class="left">Employment History check</td>
        <td>N/A</td>
        <td>N/A</td>
      </tr>
      <tr>
        <td class="left">Academic History check</td>
        <td>N/A</td>
        <td>N/A</td>
      </tr>
      <tr>
        <td class="left">Criminal Records</td>
        <td>N/A</td>
        <td>N/A</td>
      </tr>
      <tr>
        <td class="left">Criminal Records – OFAC</td>
        <td>N/A</td>
        <td>N/A</td>
      </tr>
      <tr>
        <td class="left">Global Database check</td>
        <td>N/A</td>
        <td>N/A</td>
      </tr>
      <tr>
        <td class="left">Laboratory Test (If Applicable)</td>
        <td class="<?php echo $f_doping = ($doping->resultado == 1)? 'fondo2' : 'fondo1'; ?>"><p class="f-14"><?php echo $res_doping = ($doping->resultado == 1)? 'Not approved' : 'Approved'; ?></p></td>
        <td><?php echo $fecha_resultado; ?></td>
      </tr>
      <tr>
        <td class="left">Medical Check Up (If Applicable)</td>
        <td>N/A</td>
        <td>N/A</td>
      </tr>
      <tr>
        <td class="left">Address History Check</td>
        <td>N/A</td>
        <td>N/A</td>
      </tr>	 
      <tr>
        <td class="left">Credit check</td>
        <td>N/A</td>
        <td>N/A</td>
      </tr>	
      <tr>
        <td class="left">Professional accreditation check</td>
        <td>N/A</td>
        <td>N/A</td>
      </tr>	
      <tr>
        <td class="left">Sex offender check</td>
        <td>N/A</td>
        <td>N/A</td>
      </tr>	  	
		</table>	
	</div>
  <div class="w-30 flotar-izquierda">
		<div class="bordes">
			<h5 class="center">STATUS REPORT KEY</h5>
		</div>
		<div>
			<div class="w-30 flotar-izquierda">
				<p class="fondo2 padding f-11 center">Not approved</p>
				<p  class="fondo1 padding f-11 center">Approved</p>
			</div>
			<div class="w-60">
        <p class="f-11 margin-left"> NOT SUITABLE FOR HIRING</p>
				<p class="f-11 margin-left"> SUITABLE FOR HIRING</p>
			</div>
		</div>
	</div>
	<br><br>
  <table class="tabla_portada tabla w-100">
    <tr>
      <th class="encabezado" colspan="2">Scope of Verification</th>
    </tr>
    <tr>
      <td class="encabezado center" width="25%"><p class="f-12"><b>Education</b></p></td>
      <td class="left" width="80%"><p class="f-11">N/A</p></td>
    </tr>
    <tr>
      <td class="encabezado center" width="20%"><p class="f-12"><b>Employment</b></p></td>
      <td class="left" width="80%"><p class="f-11">N/A</p></td>
    </tr>
    <tr>
      <td class="encabezado center" width="20%"><p class="f-12"><b>Address</b></p></td>
      <td class="left" width="80%"><p class="f-11">N/A</p></td>
    </tr>
    <tr>
      <td class="encabezado center" width="20%"><p class="f-12"><b>Criminal</b></p></td>
      <td class="left" width="80%"><p class="f-11">N/A</p></td>
    </tr>
    <tr>
      <td class="encabezado center" width="20%"><p class="f-12"><b>Database</b></p></td>
      <td class="left" width="80%"><p class="f-11">N/A</p></td>
    </tr>
    <tr>
      <td class="encabezado center" width="20%"><p class="f-12"><b>Identity</b></p></td>
      <td class="left" width="80%"><p class="f-11">N/A</p></td>
    </tr>
    <tr>
      <td class="encabezado center" width="20%"><p class="f-12"><b>Military</b></p></td>
      <td class="left" width="80%"><p class="f-11">N/A</p></td>
    </tr>
    <tr>
      <td class="encabezado center" width="20%"><p class="f-12"><b>Prohibited parties list</b></p></td>
      <td class="left" width="80%"><p class="f-11">N/A</p></td>
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
      <td class="left" width="80%"><p class="f-11">N/A</p></td>
    </tr>
  </table>
  <br>

  <pagebreak>

	<div class="center">
		<h2>Perfil de drogas</h2><br>
	</div>
	<div class="w-80 flotar">
		<table style="width:90%; border: 0;">
      <tr>
        <th width="20%">Nombre</th>
        <td class="left borde-inferior" colspan="3"><p class="p f-12"><?php echo mb_strtoupper($doping->nombre).' '.mb_strtoupper($doping->paterno).' '.mb_strtoupper($doping->materno); ?></p></td>
      </tr>
      <tr>
        <th width="20%">Fecha</th>
        <td class="left borde-inferior"><p class="p f-12"><?php echo $fecha_resultado; ?></p></td>
        <th width="20%">Folio</th>
        <td class="left borde-inferior"><p class="p f-12"><?php echo $doping->codigo_prueba; ?></p></td>
      </tr>
      <tr>
        <th width="30%">Código de examen</th>
        <td class="left borde-inferior"><p class="p f-12"><?php echo "AD-".$doping->paquete; ?></p></td>
        <th width="20%">Empresa</th>
        <?php 
          if($doping->cliente == 'TATA' || $doping->cliente == 'LAPI'){ ?>
          <td class="left borde-inferior"><p class="p f-12"><?php echo $proyecto; ?></p></td>
        <?php	
          }
          elseif($doping->id_subcliente == 180){
            $subcliente = str_replace('-', '', $subcliente); ?>
            <td class="left borde-inferior"><p class="p f-12"><?php echo $subcliente; ?></p></td>
        <?php
          }
          else{ ?>
          <td class="left borde-inferior"><p class="p f-12"><?php echo $doping->cliente.''.$subcliente; ?></p></td>
        <?php	
          }
        ?>
        
      </tr>
      <tr>
        <th width="20%">Descripción</th>
        <td class="left borde-inferior" colspan="3"><p class="p f-12"><?php echo $descripcion; ?></p></td>
      </tr>
      <tr>
        <th width="30%">Fecha de toma de muestra</th>
        <td class="left borde-inferior"><p class="p f-12"><?php echo $fecha_doping; ?></p></td>
        <th width="20%">Motivo de prueba</th>
        <td class="left borde-inferior"><p class="p f-12"><?php echo $motivo; ?></p></td>
      </tr>
		</table>
	</div>
	<div style="height: 160px;position: relative">
		<?php echo $foto; ?>
	</div>
	<br>
	<table class="centrado" border="1" cellpadding="0" cellspacing="0" bordercolor="#E2E1E1">
		<tr>
			<th class="padding-3">Examen</th>
			<th class="padding-3">Resultado</th>
			<th class="padding-3">Unidades</th>
			<th class="padding-3">Valor de referencia</th>
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
	<p class="p texto-centrado">La investigación de drogas de abuso es una prueba de escrutinio. <br>En caso de positividad se deberá realizar una prueba confirmatoria. <br>RESULTADO NO VÁLIDO SIN EL SELLO DE AUTENTICIDAD GRABADO EN EL PRESENTE. <br>Cualquier aclaración acerca de este estudio, comuníquese al tel: (33)33309678</p>

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