<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
</head>
<style>
html,
body {
  height: 100%;
}

body {
  font-family: 'Arial';
  font-size: 12px;
}

.col-md-2 {
  width: 16%;
  float: left;
}

.col-md-4 {
  width: 33%;
  float: left;
}

.col-md-4-2 {
  width: 33%;
  float: right;
}

.col-md-3 {
  width: 25%;
  float: left;
}

.col-md-6 {
  width: 48%;
  margin-left: 25px;
  float: left;
}

.col-md-6-2 {
  width: 48%;
  float: right;
}

.f-10 {
  font-size: 10px;
}

.f-12 {
  font-size: 12px;
}

.f-14 {
  font-size: 14px;
}

.f-16 {
  font-size: 16px;
}

.f-18 {
  font-size: 18px;
}

.f-20 {
  font-size: 20px;
}

.f-white {
  color: white;
}

.first {
  height: 50px;
  border-bottom: 1px solid #081e26;
}

.firstSecond {
  height: 50px;
  border-bottom: 1px solid #081e26;
  padding-top: 1px;
}

.firstTitle {
  border-bottom: 1px solid #e5e5e5;
  padding-top: 0px;
  height: 20px;
}

.datos {
  margin-left: 10px;
  margin-right: 10px;
}

.logo {
  height: 50px;
}

.right {
  text-align: right;
}

.center {
  text-align: center;
}

.left {
  text-align: left !important;
}

.centrado {
  margin: 0px auto;
}

.head {
  padding-top: 0px;
}

.title {
  border-bottom: 1px solid #e5e5e5;
  padding-top: 5px;
  height: 5px;
}

h3 {
  font-size: 12px;
}

p {
  padding-bottom: 2px;
  font-size: 11px;
}

.sin-flotar {
  clear: both;
}

.flotar {
  float: left;
}

/*table, th, td { border: 1px solid black; border-collapse: collapse;}*/
.tabla {
  width: 90%;
  border: 0;
}

/*th { text-transform: none; }*/
.borde-inferior {
  border-bottom: 1px solid gray;
  padding: 5px;
}

/*th, td { padding: 5px;}*/
.media-tabla {
  width: 90%;
}

.encabezado {
  background: #d9dadb;
}

.comentario {
  width: 80%;
  border: 1px solid gray;
}

.margen-top {
  margin-top: 10px;
}

.firma {
  border: 2px dotted #a8a8a7;
  width: 60%;
  height: 170px;
}

.firma p {
  float: right !important;
}

.div_datos {
  margin: 0 auto;
  width: 100%;
}

.div_datos table {
  margin: 0 auto;
  width: 100%;
}

.div_final {
  margin: 0 auto;
  width: 80%;
}

.div_final table {
  margin: 0 auto;
  width: 100%;
}

.div-azul {
  background: #154c6e;
  width: 100%;
  height: 20px;
  color: white;
  padding-left: 10px;
}

.w-10 {
  width: 10%;
}

.w-20 {
  width: 20%;
}

.w-30 {
  width: 30%;
}

.w-60 {
  width: 60%;
}

.w-80 {
  width: 80%;
}

.w-100 {
  width: 100%;
}

.foto {
  margin-left: -20px;
}

.texto-centrado {
  text-align: center;
}

.padding-5 {
  padding: 5px;
}

.padding-3 {
  padding: 3px;
}
</style>

<body>
  <?php
		$aux = explode(' ', $doping->fecha_resultado);
		$f = explode('-', $aux[0]);
		$fecha_resultado = $f[2].'/'.$f[1].'/'.$f[0];

		$aux = explode(' ', $doping->fecha_doping);
		$f = explode('-', $aux[0]);
		$fecha_doping = $f[2].'/'.$f[1].'/'.$f[0];

    if($doping->foto == '' || $doping->foto == null){
			$foto = '<img width="125px" height="100px" class="foto" src="'.base_url().'img/logo_pie.png">';
		}
		else{
			$foto = !empty($doping->foto) 
    ? '<img width="125px" height="125px" class="foto" src="'.base_url().'_doping/'.$doping->foto.'">' 
    : '';
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


		 // Primera solicitud cURL
		 $url_doping = API_URL.'doping-detalles/' . $doping->id;
		 $ch_doping = curl_init($url_doping);
		 curl_setopt($ch_doping, CURLOPT_RETURNTRANSFER, true);
		 $response_doping = curl_exec($ch_doping);

		 // Verificar si ocurrió un error durante la ejecución de cURL
		 if ($response_doping === false) {
				 $error_doping = curl_error($ch_doping);
				 curl_close($ch_doping);
				 die('Error en la solicitud cURL para Doping: ' . $error_doping);
		 }

		 // Decodificar la respuesta JSON para la primera solicitud
		 $data['sustancias'] = json_decode($response_doping);
		/* echo "<br>";
		 print_r($data['sustancias']);
		 echo "<br>";
		 die(); */
		 // Cerrar la sesión cURL para la primera solicitud
		 curl_close($ch_doping);

		//$data['sustancias'] = $this->doping_model->getSustanciasDoping($doping->id);
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
    $qr_consulta = !empty($qr) 
    ? base_url().'_qrconsult/'.$qr 
    : '';
	?>
  <!-- HOJA 1 -->
  <div class="center">
    <h2>Perfil de drogas</h2><br>
  </div>
  <div class="w-80 flotar">
    <table class="tabla">
      <tr>
        <th width="20%">Nombre</th>
        <td class="left borde-inferior" colspan="3">
          <p class="f-12">
            <?php echo mb_strtoupper($doping->nombre).' '.mb_strtoupper($doping->paterno).' '.mb_strtoupper($doping->materno); ?>
          </p>
        </td>
      </tr>
      <tr>
        <th width="20%">Fecha</th>
        <td class="left borde-inferior">
          <p class="f-12"><?php echo $fecha_resultado; ?></p>
        </td>
        <th width="20%">Folio</th>
        <td class="left borde-inferior">
          <p class="f-12"><?php echo $doping->codigo_prueba; ?></p>
        </td>
      </tr>
      <tr>
        <th width="30%">Código de examen</th>
        <td class="left borde-inferior">
          <p class="f-12"><?php echo "AD-".$doping->paquete; ?></p>
        </td>
        <th width="20%">Empresa</th>
        <?php 
		    		if($doping->cliente == 'TATA' || $doping->cliente == 'LAPI'){ ?>
        <td class="left borde-inferior">
          <p class="f-12"><?php echo $proyecto; ?></p>
        </td>
        <?php	
		    		}
		    		elseif($doping->id_subcliente == 180){
		    			$subcliente = str_replace('-', '', $subcliente); ?>
        <td class="left borde-inferior">
          <p class="f-12"><?php echo $subcliente; ?></p>
        </td>
        <?php
		    		}
		    		else{ ?>
        <td class="left borde-inferior">
          <p class="f-12"><?php echo $doping->cliente.''.$subcliente; ?></p>
        </td>
        <?php	
		    		}
		    	?>

      </tr>
      <tr>
        <th width="20%">Descripción</th>
        <td class="left borde-inferior" colspan="3">
          <p class="f-12"><?php echo $descripcion; ?></p>
        </td>
      </tr>
      <tr>
        <th width="30%">Fecha de toma de muestra</th>
        <td class="left borde-inferior">
          <p class="f-12"><?php echo $fecha_doping; ?></p>
        </td>
        <th width="20%">Motivo de prueba</th>
        <td class="left borde-inferior">
          <p class="f-12"><?php echo $motivo; ?></p>
        </td>
      </tr>
    </table>
  </div>
  <?php if (!empty($foto)): ?>
  <div style="height: 160px; position: relative">
    <?php echo $foto; ?>
  </div>
  <?php else: ?>
  <div style="height: 160px; position: relative">
    <img src="" alt="" style="display: none;">
  </div>
  <?php endif; ?>
  <br>
  <table class="centrado" border="1" cellpadding="0" cellspacing="0" bordercolor="#E2E1E1">
    <tr>
      <th class="padding-3">Examen</th>
      <th class="padding-3">Resultado</th>
      <th class="padding-3">Unidades</th>
      <th class="padding-3">Valor de referencia</th>
    </tr>

    <?php 
    $contador = 0;
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
        $contador ++;
		} ?>
  </table>
  
  <?php 
  if($contador > 8 ){ ?>
  <pagebreak>
    <?php  } ?>
  <p class="texto-centrado">La investigación de drogas de abuso es una prueba de escrutinio. <br>En caso de positividad
    se deberá realizar una prueba confirmatoria. <br>RESULTADO NO VÁLIDO SIN EL SELLO DE AUTENTICIDAD GRABADO EN EL
    PRESENTE. <br>Cualquier aclaración acerca de este estudio, comuníquese al tel: (33)33309678</p>

 <?php $cedula = (!empty($area->cedula))? '<span>Cédula Profesional: '.$area->cedula.'</span><br>' : '<span>Personal autorizado por laboratorio</span><br>'; 
	if($num_sustancias <= 6){ ?>
    <table style="width: 100%;  page-break-inside: avoid;">
      <tr>
        <td style="width: 33%; text-align: center;">
          <img width="180px" src="<?php echo $firma; ?>"><br>
          <span><?php echo $area->profesion_responsable . ' ' . $area->responsable; ?></span><br>
          <?php echo $cedula; ?>
        </td>
        <td style="width: 33%; text-align: center;">
          <span>Laboratorio de Análisis</span><br>
          <span>PERINTEX SC.</span><br>
          <span>Cédula de licencia municipal: 580386</span><br>
          <span>REG. SSA COFEPRIS: 21040912</span><br>
          <img width="60px" src="<?php echo base_url() . 'img/qr_cofepris.jpg'; ?>">
        </td>
        <?php if (!empty($qr_consulta)): ?>
        <td style="width: 33%; text-align: center;">
          <img src="<?php echo $qr_consulta; ?>" style="width: 100px;">
        </td>
        <?php else: ?>
        <td style="width: 33%; text-align: center;">
          <!-- Espacio vacío o contenido alternativo si es necesario -->
        </td>
        <?php endif; ?>
      </tr>
    </table>
    <?php 
	}
	else{ ?>
    <table style="width: 100%;  page-break-inside: avoid; table-layout: fixed;">
      <tr>
        <td style="width: 33%; text-align: center;">
          <img width="180px" src="<?php echo $firma; ?>"><br>
          <span><?php echo $area->profesion_responsable . ' ' . $area->responsable; ?></span><br>
          <?php echo $cedula; ?>
        </td>
        <td style="width: 33%; text-align: center;">
          <span>Laboratorio de Análisis</span><br>
          <span>PERINTEX SC.</span><br>
          <span>Cédula de licencia municipal: 580386</span><br>
          <span>REG. SSA COFEPRIS: 21040912</span><br>
          <img width="60px" src="<?php echo base_url() . 'img/qr_cofepris.jpg'; ?>">
        </td>
        <td style="width: 33%; text-align: center;">
          <img src="<?php echo $qr_consulta; ?>" style="width: 100px;">
        </td>
      </tr>
      <?php
	} ?>


</body>

</html>