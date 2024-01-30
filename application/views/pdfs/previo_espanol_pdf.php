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
	.w-25 { width: 25%;}
	.w-30 { width: 30%; }
	.w-40 { width: 40%; }
	.w-50 { width: 50%; }
	.w-60 { width: 60%; }
	.w-70 { width: 70%; }
	.w-80 { width: 80%; }
	.w-90 { width: 90% !important; }
	.w-100 { width: 100% !important; }
	.img-penales { width: 370px; height: 420px; }
	.img-aviso { width: 500px; height: 720px; }
	.foto { width: 400px; height: 330px;padding-top: 10px; }
	.borde-derecho { border-right: 1px solid black; }
	.color-rodi { color: #255880; }
	.margen-50 {margin-left: 50% !important;}
	.flotar-derecha { float: right !important; }
	.flotar-izquierda { float: left; }
	.bordes { border-top: 1px solid gray;border-bottom: 1px solid gray; }
	.padding { padding: 7px; }
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
		/*if($ver_documento){
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
		}*/
		
		if($datos){
			foreach($datos as $d){
				$id_candidato = $d->id;
				$f = $d->fecha_alta;
				$f_alta = formatoEspecialFecha($f);
				$nombre = $d->nombre;
				$pat = $d->paterno;
				$mat = $d->materno;
				$status_bgc = $d->status_bgc;
				$lugar_nacimiento = $d->lugar_nacimiento;
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
				$entre_calles = $d->entre_calles;
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
				$visitador = $d->visitador;
				$acta = $d->acta;
				$fecha_acta = $d->fecha_acta;
				$fecha_domicilio = $d->fecha_domicilio;
				$cuenta_domicilio = $d->cuenta_domicilio;
				$emision_ine = ($d->emision_ine == "")? "No proporciona":$d->emision_ine;
				$ine = ($d->ine == "")? "No proporciona":$d->ine;
				$emision_curp = $d->emision_curp;
				$curp = $d->curp;
				$emision_nss = $d->emision_nss;
				$nss = ($d->nss == "")? "No proporciona":$d->nss;;
				$fecha_retencion_impuestos = $d->fecha_retencion_impuestos;
				$retencion_impuestos = ($d->retencion_impuestos == "")? "No proporciona":$d->retencion_impuestos;
				$emision_rfc = $d->emision_rfc;
				$rfc = $d->rfc;
				$fecha_licencia = $d->fecha_licencia;
				$licencia = ($d->licencia == "")? "No proporciona":$d->licencia;
				$vigencia_migratoria = $d->vigencia_migratoria;
				$numero_migratorio = ($d->numero_migratorio == "")? "No proporciona":$d->numero_migratorio;
				$fecha_visa = $d->fecha_visa;
				$visa = ($d->visa == "")? "No proporciona":$d->visa;
				$muebles = $d->muebles;
				$adeudo_muebles = $d->adeudo_muebles;
				$id_cliente = $d->id_cliente;
			}
			//Fechas
			$hoy = formatoEspecialFecha($hoy);
			$e = new DateTime($hoy);
			$hoy2 = $e->format('d/m/Y');

			$fecha_finalizado = formatoFechaEspanol($fecha_fin);
			$e = new DateTime($fecha_fin);
			$fecha_fin = $e->format('d/m/Y');

			$e = new DateTime($fecha_acta);
			$fecha_acta = $e->format('d/m/Y');

			$e = new DateTime($fecha_domicilio);
			$fecha_domicilio = $e->format('d/m/Y');

			$e = new DateTime($emision_curp);
			$emision_curp = $e->format('d/m/Y');

			if(!empty($emision_nss) && $emision_nss != "0000-00-00"){
				$e = new DateTime($emision_nss);
				$emision_nss = $e->format('d/m/Y');
			}
			else{
				$emision_nss = "No proporciona";
			}

			if(!empty($fecha_retencion_impuestos) && $fecha_retencion_impuestos != "0000-00-00"){
				$e = new DateTime($fecha_retencion_impuestos);
				$fecha_retencion_impuestos = $e->format('d/m/Y');
			}
			else{
				$fecha_retencion_impuestos = "No proporciona";
			}

			$e = new DateTime($emision_rfc);
			$emision_rfc = $e->format('d/m/Y');

			if(!empty($fecha_licencia) && $fecha_licencia != "0000-00-00"){
				$e = new DateTime($fecha_licencia);
				$fecha_licencia = $e->format('d/m/Y');
			}
			else{
				$fecha_licencia = "No proporciona";
			}

			if(!empty($vigencia_migratoria) && $vigencia_migratoria != "0000-00-00"){
				$e = new DateTime($vigencia_migratoria);
				$vigencia_migratoria = $e->format('d/m/Y');
			}
			else{
				$vigencia_migratoria = "No proporciona";
			}

			if(!empty($fecha_visa) && $fecha_visa != "0000-00-00"){
				$e = new DateTime($fecha_visa);
				$fecha_visa = $e->format('d/m/Y');
			}
			else{
				$fecha_visa = "No proporciona";
			}

			$e = new DateTime($fecha_nacimiento);
			$fecha_nacimiento = $e->format('d/m/Y');

			if($doc_doping != ""){
				$e = new DateTime($doping->fecha_resultado);
				$fecha_res_doping = $e->format('d/m/Y');
			}
			else{
				$fecha_res_doping = "N/A";
			}
			

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
			$estudios = $this->candidato_model->getGradoEstudio($id_grado_estudio);
			//$tiempo_direccion = $anos_direccion." years ".$meses_direccion." months";
			//$tiempo_traslado = $horas_traslado." hours ".$minutos_traslado." minutes";
			//$transporte = $this->candidato_model->getTransporte($id_transporte);

			
		}
		
	?>
	<!-- HOJA 1 -->
	<div>
		<div class="col-md-4 borde-derecho">
			<?php 
			if($id_cliente == 39){  ?>
				<img src="<?php echo base_url().'img/logo_talink.png' ?>" width="140px" >
			<?php
			}
			else{  ?>
				<img src="<?php echo base_url().'img/logo.png' ?>" width="190px" >
			<?php
			} ?>
		</div>
		<div class="col-md-6">
			<span class="f-16 color-rodi margen-top"><b><?php echo $cliente." - ".$subcliente; ?></span></b><br>
			<span class="f-16 color-rodi"><b>Reporte Previo de Estudio Socioeconómico</span></b>
		</div>
	</div>
		
	<!-- HOJA 2 -->
	<div class="div_datos">
		<p class="center f-18">Datos Personales</p>
		<table class="">
		  	<tr>
		    	<td class="encabezado">Nombre del aspirante:</td>
		    	<td class="center" colspan="5"><p class="f-12"><?php echo $nombre." ".$pat." ".$mat; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">Puesto que solicita:</td>
		    	<td class="center"><p class="f-12"><?php echo $puesto; ?></p></td>
		    	<td class="encabezado w-17">Fecha de Nacimiento:</td>
		    	<td class="center"><p class="f-12"><?php echo $fecha_nacimiento; ?></p></td>
		  		<td class="encabezado">Lugar de Nacimiento:</td>
		    	<td class="center"><p class="f-12"><?php echo $lugar_nacimiento; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">Edad:</td>
		    	<td class="center"><p class="f-12"><?php echo $edad; ?></p></td>
		    	<td class="encabezado">Sexo:</td>
		    	<td class="center"><p class="f-12"><?php echo $genero; ?></p></td>
		    	<td class="encabezado">Estado civil:</td>
		    	<td class="center"><p class="f-12"><?php echo $estado_civil; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">Domicilio (calle, número exterior e interior):</td>
		    	<td class="center"><p class="f-12"><?php echo $calle.' '.$ext.' '.$int; ?></p></td>
		    	<td class="encabezado">Entre la calle de:</td>
		  		<td class="center"><p class="f-12"><?php echo $entre = ($entre_calles == "")? "No proporciona":$entre_calles; ?></p></td>
		    	<td class="encabezado">Colonia:</td>
		    	<td class="center"><p class="f-12"><?php echo $colonia; ?></p></td>
		    	
		  	</tr>
		  	<tr>
		  		<td class="encabezado">Delegación:</td>
		    	<td class="center"><p class="f-12"><?php echo $municipio->nombre; ?></p></td>
		  		<td class="encabezado">Ciudad o Estado:</td>
		    	<td class="center"><p class="f-12"><?php echo $estado->nombre; ?></p></td>
		    	<td class="encabezado">Código postal:</td>
		    	<td class="center"><p class="f-12"><?php echo $cp; ?></p></td>
		  	</tr>
		  	<tr>
		  		<td class="encabezado">Grado máximo de estudios:</td>
		  		<td class="center"><p class="f-12"><?php echo $estudios->nombre; ?></p></td>
		  		<td class="encabezado">Teléfono local:</td>
		  		<td class="center"><p class="f-12"><?php echo $tel_casa = ($telefono_casa == "")? "No proporciona":$telefono_casa; ?></p></td>
		  		<td class="encabezado">Teléfono celular:</td>
		  		<td class="center"><p class="f-12"><?php echo $celular; ?></p></td>
		  	</tr>
		</table>
	</div>
	<br><br><br><br>
	<?php 
		if($acta != "" && $acta != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Documentos Comprobatorios</p>
				<table class="">
				  	<tr>
				    	<th class="encabezado">CONCEPTO</th>
				    	<th class="encabezado">NÚMERO Y/O VIGENCIA</th>
				    	<th class="encabezado">FECHA DE EXPEDICIÓN</th>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Acta de nacimiento</p></td>
				    	<td class="center"><p class="f-12"><?php echo $acta; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $fecha_acta; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Comprobante de domicilio</p></td>
				    	<td class="center"><p class="f-12"><?php echo $cuenta_domicilio; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $fecha_domicilio; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Credencial de elector</p></td>
				    	<td class="center"><p class="f-12"><?php echo $ine; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $emision_ine; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">CURP</p></td>
				    	<td class="center"><p class="f-12"><?php echo $curp; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $emision_curp; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Afiliación al IMSS</p></td>
				    	<td class="center"><p class="f-12"><?php echo $nss; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $emision_nss; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Comprobante retención de impuestos</p></td>
				    	<td class="center"><p class="f-12"><?php echo $retencion_impuestos; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $fecha_retencion_impuestos; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">RFC</p></td>
				    	<td class="center"><p class="f-12"><?php echo $rfc; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $emision_rfc; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Licencia para conducir</p></td>
				    	<td class="center"><p class="f-12"><?php echo $licencia; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $fecha_licencia; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Vigencia migratoria (extranjeros)</p></td>
				    	<td class="center"><p class="f-12"><?php echo $vigencia_migratoria; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $numero_migratorio; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">VISA Norteamericana</p></td>
				    	<td class="center"><p class="f-12"><?php echo $visa; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $fecha_visa; ?></p></td>
				  	</tr>
				</table>
			</div>
			<pagebreak>

	<?php	
		}
	 ?>
	
	<?php 
		if($academico->primaria_periodo != "" && $academico->comentarios != ""){ ?>
			<div class="div_datos">
				<p class="center f-18">Historial Académico</p>
				<table class="">
				  	<tr>
				    	<th class="encabezado">NIVEL ESCOLAR</th>
				    	<th class="encabezado">PERIDO</th>
				    	<th class="encabezado">ESCUELA</th>
				    	<th class="encabezado">CIUDAD</th>
				    	<th class="encabezado">CERTIFICADO</th>
				    	<th class="encabezado">PROMEDIO</th>
				    	
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Primaria</p></td>
				    	<td class="center"><p class="f-12"><?php echo $academico->primaria_periodo; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $academico->primaria_escuela; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $academico->primaria_ciudad; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $res = ($academico->primaria_certificado == 1)? "Sí":"No"; ?></p></td>
				    	<td class="center"><p class="f-12"><?php echo $academico->primaria_promedio; ?></p></td>
				  	</tr>
				  	<?php 
						if($academico->secundaria_periodo != null && $academico->secundaria_periodo != ''){
						?>
							<tr>
								<td class="encabezado center"><p class="f-12">Secundaria</p></td>
								<td class="center"><p class="f-12"><?php echo $academico->secundaria_periodo; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->secundaria_escuela; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->secundaria_ciudad; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $res = ($academico->secundaria_certificado == 1)? "Sí":"No"; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->secundaria_promedio; ?></p></td>
							</tr>
						<?php 
						} ?>
						<?php 
						if($academico->comercial_periodo != null && $academico->comercial_periodo != ''){
						?>
							<tr>
								<td class="encabezado center"><p class="f-12">Carrera comercial</p></td>
								<td class="center"><p class="f-12"><?php echo $academico->comercial_periodo; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->comercial_escuela; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->comercial_ciudad; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $res = ($academico->comercial_certificado == 1)? "Sí":"No"; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->comercial_promedio; ?></p></td>
							</tr>
						<?php 
						} ?>
						<?php 
						if($academico->preparatoria_periodo != null && $academico->preparatoria_periodo != ''){
						?>
							<tr>
								<td class="encabezado center"><p class="f-12">Bachillerato</p></td>
								<td class="center"><p class="f-12"><?php echo $academico->preparatoria_periodo; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->preparatoria_escuela; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->preparatoria_ciudad; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $res = ($academico->preparatoria_certificado == 1)? "Sí":"No"; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->preparatoria_promedio; ?></p></td>
							</tr>
						<?php 
						} ?>
						<?php 
						if($academico->licenciatura_periodo != null && $academico->licenciatura_periodo != ''){
						?>
							<tr>
								<td class="encabezado center"><p class="f-12">Licenciatura</p></td>
								<td class="center"><p class="f-12"><?php echo $academico->licenciatura_periodo; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->licenciatura_escuela; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->licenciatura_ciudad; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $res = ($academico->licenciatura_certificado == 1)? "Sí":"No"; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->licenciatura_promedio; ?></p></td>
							</tr>
						<?php 
						} ?>
						<?php 
						if($academico->actual_periodo != null && $academico->actual_periodo != ''){
						?>
							<tr>
								<td class="encabezado center"><p class="f-12">Estudios actuales</p></td>
								<td class="center"><p class="f-12"><?php echo $academico->actual_periodo; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->actual_escuela; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->actual_ciudad; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $res = ($academico->actual_certificado == 1)? "Sí":"No"; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $academico->actual_promedio; ?></p></td>
							</tr>
						<?php 
						} ?>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Cédula profesional</p></td>
				    	<td class="center" colspan="5"><p class="f-12"><?php echo $academico->cedula_profesional; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Otros estudios</p></td>
				    	<td class="center" colspan="5"><p class="f-12"><?php echo $academico->otros_certificados; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Periodos inactivos</p></td>
				    	<td class="center" colspan="5"><p class="f-12"><?php echo $academico->carrera_inactivo; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center"><p class="f-12">Comentarios</p></td>
				    	<td class="center" colspan="5"><p class="f-12"><?php echo $academico->comentarios; ?></p></td>
				  	</tr>
				</table>
			</div><pagebreak>
	<?php	
		}
	 ?>
	
	<?php 
		if($sociales->sindical_nombre != "" && $sociales->mediano_plazo != ""){ ?>
			<div class="div_datos">
				<p class="center f-18">Antecedentes Sociales</p>
				<table class="">
				  	<tr>
				    	<td class="encabezado">¿Perteneció algún puesto sindical? </td>
				    	<td class="center"><p class="f-12"><?php echo $res = ($sociales->sindical == 1)? "Sí":"No"; ?></p></td>
				    	<td class="encabezado">¿A cuál? </td>
				    	<td class="center"><p class="f-12"><?php echo $sociales->sindical_nombre; ?></p></td>
				    	<td class="encabezado">¿Cargo? </td>
				    	<td class="center" colspan="2"><p class="f-12"><?php echo $sociales->sindical_cargo; ?></p></td>
				  	</tr>
				  	<tr>
				    	<td class="encabezado">¿Pertenece algún partido político? </td>
				    	<td class="center"><p class="f-12"><?php echo $res = ($sociales->partido == 1)? "Sí":"No"; ?></p></td>
				    	<td class="encabezado">¿A cuál? </td>
				    	<td class="center"><p class="f-12"><?php echo $sociales->partido_nombre; ?></p></td>
				    	<td class="encabezado">¿Cargo? </td>
				    	<td class="center" colspan="2"><p class="f-12"><?php echo $sociales->partido_cargo; ?></p></td>
				  	</tr>
				  	<tr>
				    	<td class="encabezado">¿Pertenece algún club deportivo? </td>
				    	<td class="center"><p class="f-12"><?php echo $res = ($sociales->club == 1)? "Sí":"No"; ?></p></td>
				    	<td class="encabezado">¿Qué deporte practica? </td>
				    	<td class="center"><p class="f-12"><?php echo $sociales->deporte; ?></p></td>
				    	<td class="encabezado">¿Qué religión profesa?  </td>
				    	<td class="center"><p class="f-12"><?php echo $sociales->religion; ?></p></td>
				    	<td class="encabezado">¿Con qué frecuencia?  </td>
				    	<td class="center"><p class="f-12"><?php echo $sociales->religion_frecuencia; ?></p></td>
				  	</tr>
				  	<tr>
				    	<td class="encabezado">¿Ingiere bebidas alcohólicas? </td>
				    	<td class="center"><p class="f-12"><?php echo $res = ($sociales->bebidas == 1)? "Sí":"No"; ?></p></td>
				    	<td class="encabezado">¿Con qué frecuencia? </td>
				    	<td class="center"><p class="f-12"><?php echo $sociales->bebidas_frecuencia; ?></p></td>
				    	<td class="encabezado">¿Acostumbra fumar?  </td>
				    	<td class="center"><p class="f-12"><?php echo $res = ($sociales->fumar == 1)? "Sí":"No"; ?></p></td>
				    	<td class="encabezado">¿Con qué frecuencia?  </td>
				    	<td class="center"><p class="f-12"><?php echo $sociales->fumar_frecuencia; ?></p></td>
				  	</tr>
				  	<tr>
				    	<td class="encabezado">¿Ha tenido alguna intervención quirúrgica? </td>
				    	<td class="center"><p class="f-12"><?php echo $sociales->cirugia; ?></p></td>
				    	<td class="encabezado">¿Antecedentes de enfermedades en su familia directa? </td>
				    	<td class="center"><p class="f-12"><?php echo $sociales->enfermedades; ?></p></td>
				    	<td class="encabezado">¿Cuáles son sus planes a corto plazo?  </td>
				    	<td class="center"><p class="f-12"><?php echo $sociales->corto_plazo; ?></p></td>
				    	<td class="encabezado">¿Cuáles son sus planes a mediano plazo?  </td>
				    	<td class="center"><p class="f-12"><?php echo $sociales->mediano_plazo; ?></p></td>
				  	</tr>
				</table>
			</div>
			<br><br><br><br>
	<?php	
		}
	 ?>
	

	<?php 
		if($familia != "" && $familia != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Datos del Grupo Familiar</p>
				<table class="">
				  	<tr>
				    	<th class="encabezado">NOMBRE</th>
				    	<th class="encabezado">PARENTESCO</th>
				    	<th class="encabezado">EDAD</th>
				    	<th class="encabezado">ESTADO CIVIL</th>
				    	<th class="encabezado">ESCOLARIDAD</th>
				    	<th class="encabezado">VIVE CON USTED</th>
				    	
				  	</tr>
				  	<?php $salida = '';
				  	foreach($familia as $f){
				  		
			  			$salida .= '<tr>';
			  			$salida .= '<td class="center"><p class="f-12">'.$f->persona.'</p></td>';
			  			$salida .= '<td class="center"><p class="f-12">'.$f->parentesco.'</p></td>';
			  			$salida .= '<td class="center"><p class="f-12">'.$f->edad.'</p></td>';
			  			$salida .= '<td class="center"><p class="f-12">'.$f->estado_civil.'</p></td>';
			  			$salida .= '<td class="center"><p class="f-12">'.$f->escolaridad.'</p></td>';
			  			$salida .= ($f->misma_vivienda == 1) ? '<td class="center"><p class="f-12">Sí</p></td>' : '<td class="center"><p class="f-12">No</p></td>';
			  			$salida .= '</tr>';
				  		
				  	}
				  	echo $salida;
				  	?>
				</table>
			</div><br>
			<div class="div_datos">
				<p class="center f-18">Antecedentes Laborales del Grupo Familiar</p>
				<table class="">
				  	<tr>
				    	<th class="encabezado">NOMBRE</th>
				    	<th class="encabezado">EMPRESA</th>
				    	<th class="encabezado">PUESTO</th>
				    	<th class="encabezado">ANTIGÜEDAD</th>
				  	</tr>
				  	<?php $salida = '';
				  	foreach($familia as $f){
				  		
			  			$salida .= '<tr>';
			  			$salida .= '<td class="center"><p class="f-12">'.$f->persona.'</p></td>';
			  			$salida .= '<td class="center"><p class="f-12">'.$f->empresa.'</p></td>';
			  			$salida .= '<td class="center"><p class="f-12">'.$f->puesto.'</p></td>';
			  			$salida .= '<td class="center"><p class="f-12">'.$f->antiguedad.'</p></td>';
			  			$salida .= '</tr>';
				  	}
				  	echo $salida;
				  	?>
				</table>
			</div><br>
			<div class="div_datos">
				<p class="center f-18">Situación Económica</p>
				<table class="">
				  	<tr>
				    	<th class="encabezado" colspan="3">INGRESOS MENSUALES</th>
				  	</tr>
				  	<tr>
				    	<th class="encabezado">NOMBRE</th>
				    	<th class="encabezado">SUELDO</th>
				    	<th class="encabezado">APORTACIÓN</th>
				  	</tr>
				  	<?php $salida2 = '';
				  	foreach($familia as $f){
				  		
			  			$salida2 .= '<tr>';
			  			$salida2 .= '<td class="center"><p class="f-12">'.$f->persona.'</p></td>';
			  			$salida2 .= '<td class="center"><p class="f-12">'.$f->sueldo.'</p></td>';
			  			$salida2 .= '<td class="center"><p class="f-12">'.$f->monto_aporta.'</p></td>';
			  			$salida2 .= '</tr>';
				  	}
				  	echo $salida2;
				  	?>
				</table>
				<table class="">
				  	<tr>
				    	<th class="encabezado" colspan="2">EGRESOS MENSUALES</th>
				  	</tr>
				  	<tr>
				    	<th class="encabezado w-25">CONCEPTOS</th>
				    	<th class="encabezado">MONTOS</th>
				  	</tr>
				  	<tr>
				  		<td class="encabezado w-40">Renta </td>
			  			<td class="center"><p class="f-12"><?php echo "$ ".$egresos->renta; ?></p></td>
			  		</tr>
			  		<tr>
			  			<td class="encabezado w-40">Alimentos </td>
			  			<td class="center"><p class="f-12"><?php echo "$ ".$egresos->alimentos; ?></p></td>
			  		</tr>
			  		<tr>
			  			<td class="encabezado w-40">Servicios </td>
			  			<td class="center"><p class="f-12"><?php echo "$ ".$egresos->servicios; ?></p></td>
			  		</tr>
			  		<tr>
			  			<td class="encabezado w-40">Transporte </td>
			  			<td class="center"><p class="f-12"><?php echo "$ ".$egresos->transporte; ?></p></td>
			  		</tr>
			  		<tr>
			  			<td class="encabezado w-40">Otros </td>
			  			<td class="center"><p class="f-12"><?php echo "$ ".$egresos->otros; ?></p></td>
			  			<?php $total = $egresos->renta + $egresos->alimentos + $egresos->servicios + $egresos->transporte + $egresos->otros; ?>
			  		</tr>
			  		<tr>
			  			<td class="encabezado w-40">Total </td>
			  			<td class="encabezado"><p class="f-12"><?php echo "$ ".$total; ?></p></td>
			  		</tr>
			  		<tr>
			  			<td class="encabezado w-40">¿Cuándo los egresos son mayores a los ingresos, cómo los solventa? </td>
			  			<td class="center"><p class="f-12"><?php echo $egresos->solvencia; ?></p></td>
		  			</tr>
				</table>
			</div><br><br>
			<div class="div_datos">
				<p class="center f-18">Bienes (Muebles e Inmuebles)</p>
				<table class="">
				  	<tr>
				    	<th class="encabezado">NOMBRE DEL PROPIETARIO</th>
				    	<th class="encabezado">MUEBLES E INMUEBLES</th>
				    	<th class="encabezado">ADEUDO</th>
				  	</tr>
				  	<?php $salida3 = '';
				  	foreach($familia as $f){
				  		
			  			$salida3 .= '<tr>';
			  			$salida3 .= '<td class="center"><p class="f-12">'.$f->persona.'</p></td>';
			  			$salida3 .= '<td class="center"><p class="f-12">'.$f->muebles.'</p></td>';
			  			$salida3 .= '<td class="center"><p class="f-12">'.$res = ($f->adeudo == 1)? "Sí":"No".'</p></td>';
			  			$salida3 .= '</tr>';
				  	}	
			  		$salida3 .= '<tr>';
		  			$salida3 .= '<td class="center"><p class="f-12">'.$nombre." ".$pat." ".$mat.'</p></td>';
		  			$salida3 .= '<td class="center"><p class="f-12">'.$muebles.'</p></td>';
		  			$salida3 .= '<td class="center"><p class="f-12">'.$res = ($adeudo_muebles == 1)? "Sí":"No".'</p></td>';
				  	echo $salida3;
				  	?>
				</table>
			</div><br><br><br><br><br><br><br><br><br><br>

	<?php	
		}
	 ?>

	<?php 
		if($vivienda != "" && $vivienda != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Habitación y Medio Ambiente</p>
				<table class="">
				  	<tr>
				  		<td class="encabezado center w-40"><p class="f-12">TIEMPO DE RESIDENCIA EN EL DOMICILIO ACTUAL</p></td>
				    	<td class="center"><p class="f-12"><?php echo $vivienda->tiempo_residencia; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center w-40"><p class="f-12">NIVEL DE ZONA</p></td>
				    	<td class="center"><p class="f-12"><?php echo $vivienda->zona; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center w-40"><p class="f-12">TIPO DE VIVIENDA</p></td>
				    	<td class="center"><p class="f-12"><?php echo $vivienda->vivienda; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center w-40"><p class="f-12">RECÁMARAS</p></td>
				    	<td class="center"><p class="f-12"><?php echo $vivienda->recamaras; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center w-40"><p class="f-12">BAÑOS</p></td>
				    	<td class="center"><p class="f-12"><?php echo $vivienda->banios; ?></p></td>		  
				  	</tr>
				  	<tr>
				  		<td class="encabezado center w-40"><p class="f-12">DISTRIBUCIÓN</p></td>
				    	<td class="center"><p class="f-12"><?php echo $vivienda->distribucion; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center w-40"><p class="f-12">EL MOBILIARIO ES</p></td>
				  		<?php
				  		if($vivienda->calidad_mobiliario == 1){
				  			$calidad = "Buena";
				  		 
				  		}
				  		if($vivienda->calidad_mobiliario == 2){
				  			$calidad = "Regular";
				  		 
				  		}
				  		if($vivienda->calidad_mobiliario == 3){
				  			$calidad = "Mala";
				  		 
				  		}
				  		?>
				    	<td class="center"><p class="f-12"><?php echo $calidad; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center w-40"><p class="f-12">EL MOBILIARIO ESTÁ</p></td>
				    	<td class="center"><p class="f-12"><?php echo $res = ($vivienda->mobiliario == 1)? "Completo":"Incompleto"; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center w-40"><p class="f-12">LA VIVIENDA ES</p></td>
				  		<?php
				  		if($vivienda->tamanio_vivienda == 1){
				  			$tamano = "Amplia";
				  		 
				  		}
				  		if($vivienda->tamanio_vivienda == 2){
				  			$tamano = "Media";
				  		 
				  		}
				  		if($vivienda->tamanio_vivienda == 3){
				  			$tamano = "Reducida";
				  		 
				  		}
				  		?>
				    	<td class="center"><p class="f-12"><?php echo $tamano; ?></p></td>
				  	</tr>
				  	<tr>
				  		<td class="encabezado center w-40"><p class="f-12">CONDICIONES</p></td>
				    	<td class="center"><p class="f-12"><?php echo $vivienda->condiciones; ?></p></td>
				  	</tr>
				</table>
			</div><br><br><br><br><br><br><br><br><br><br>
	<?php	
		}
	 ?>
	
	<?php 
		if($ref_personal != "" && $ref_personal != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Referencias Personales</p>
					<?php $salida2 = '';
				  	foreach($ref_personal as $refper){
				  		if($refper->recomienda == 0){
				  			$recomienda = "No";
				  		 
				  		}
				  		if($refper->recomienda == 1){
				  			$recomienda = "Sí";
				  		 
				  		}
				  		if($refper->recomienda == 2){
				  			$recomienda = "NA";
				  		 
				  		}
				  		
			  			$salida2 .= '<table class=""><tr>';
			  			$salida2 .= '<td class="encabezado"><p class="f-12">Nombre</p></td>';
			  			$salida2 .= '<td class="center"><p class="f-12">'.$refper->nombre.'</p></td>';
			  			$salida2 .= '<td class="encabezado"><p class="f-12">Tiempo de conocerlo</p></td>';
			  			$salida2 .= '<td class="center"><p class="f-12">'.$refper->tiempo_conocerlo.'</p></td>';
			  			$salida2 .= '</tr>';
			  			$salida2 .= '<tr>';
			  			$salida2 .= '<td class="encabezado"><p class="f-12">Teléfono</p></td>';
			  			$salida2 .= '<td class="center"><p class="f-12">'.$refper->telefono.'</p></td>';
			  			$salida2 .= '<td class="encabezado"><p class="f-12">La recomienda</p></td>';
			  			$salida2 .= '<td class="center"><p class="f-12">'.$recomienda.'</p></td>';
			  			$salida2 .= '</tr>';
			  			$salida2 .= '<tr>';
			  			$salida2 .= '<td class="encabezado"><p class="f-12">Comentario</p></td>';
			  			$salida2 .= '<td class="encabezado" colspan="2"><p class="f-12">'.$refper->comentario.'</p></td>';
			  			$salida2 .= '</tr></table><br><br>';
				  	}
				  	echo $salida2;
				  	?>		  	
			</div><br><br><br><br><br><br><br><br><br><br><br>
	<?php	
		}
	 ?>
	
	<?php 
		if($ref_vecinal != "" && $ref_vecinal != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Referencias Vecinales</p>
					<?php $salida4 = '';
				  	foreach($ref_vecinal as $refvec){
			  			$salida4 .= '<table class=""><tr>';
			  			$salida4 .= '<td class="encabezado w-40"><p class="f-12">Nombre</p></td>';
			  			$salida4 .= '<td class="center"><p class="f-12">'.$refvec->nombre.'</p></td>';
			  			$salida4 .= '</tr>';
			  			$salida4 .= '<tr>';
			  			$salida4 .= '<td class="encabezado w-40"><p class="f-12">Domicilio y Teléfono</p></td>';
			  			$salida4 .= '<td class="center"><p class="f-12">'.$refvec->domicilio.' / '.$refvec->telefono.'</p></td>';
			  			$salida4 .= '</tr>';
			  			$salida4 .= '<tr>';
			  			$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Qué concepto tiene del aspirante?</p></td>';
			  			$salida4 .= '<td class="center"><p class="f-12">'.$refvec->concepto_candidato.'</p></td>';
			  			$salida4 .= '</tr>';
			  			$salida4 .= '<tr>';
			  			$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿En qué concepto tiene a la familia como vecinos?</p></td>';
			  			$salida4 .= '<td class="center"><p class="f-12">'.$refvec->concepto_familia.'</p></td>';
			  			$salida4 .= '</tr>';
			  			$salida4 .= '<tr>';
			  			$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Conoce el estado civil del aspirante? ¿Cuál es?</p></td>';
			  			$salida4 .= '<td class="center"><p class="f-12">'.$refvec->civil_candidato.'</p></td>';
			  			$salida4 .= '</tr>';
			  			$salida4 .= '<tr>';
			  			$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Tiene hijos?</p></td>';
			  			$salida4 .= '<td class="center"><p class="f-12">'.$refvec->hijos_candidato.'</p></td>';
			  			$salida4 .= '</tr>';
			  			$salida4 .= '<tr>';
			  			$salida4 .= '<td class="encabezado w-40"><p class="f-12">¿Sabe en dónde trabaja? </p></td>';
			  			$salida4 .= '<td class="center"><p class="f-12">'.$refvec->sabe_trabaja.'</p></td>';
			  			$salida4 .= '</tr>';
			  			$salida4 .= '<tr>';
			  			$salida4 .= '<td class="encabezado w-40"><p class="f-12">Notas</p></td>';
			  			$salida4 .= '<td class="encabezado"><p class="f-12">'.$refvec->notas.'</p></td>';
			  			$salida4 .= '</tr></table><br><br>';
				  	}
				  	echo $salida4;
				  	?>		  	
			</div><br>

	<?php	
		}
	 ?>
	
	<?php 
		if($ref_laboral != "" && $ref_laboral != null){ ?>
			<pagebreak>
			<p class="center f-18">Antecedentes Laborales </p>
			<?php 
				foreach($ref_laboral as $ref){
			 		?>
			 		<br><br>
					<div class="div_datos">
						<table class="">
							<?php 
							 ?>
						  	<tr>
						  		<td class="encabezado center"><p class="f-12">Nombre de la empresa</p></td>
						    	<td class="center"><p class="f-12"><?php echo $ref->empresa; ?></p></td>
						    	<td class="encabezado center"><p class="f-12">Área o Departamento</p></td>
						    	<td class="center"><p class="f-12"><?php echo $ref->area; ?></p></td>
						  	</tr>
						  	<tr>
						  		<td class="encabezado center"><p class="f-12">Domicilio, calle y número</p></td>
						    	<td class="center"><p class="f-12"><?php echo $ref->calle; ?></p></td>
						    	<td class="encabezado center"><p class="f-12">Colonia</p></td>
						    	<td class="center"><p class="f-12"><?php echo $ref->colonia; ?></p></td>
						  	</tr>
						  	<tr>
						  		<td class="encabezado center"><p class="f-12">Código postal</p></td>
						    	<td class="center"><p class="f-12"><?php echo $ref->cp; ?></p></td>
						    	<td class="encabezado center"><p class="f-12">Teléfono</p></td>
						    	<td class="center"><p class="f-12"><?php echo $ref->telefono; ?></p></td>
						  	</tr>
						  	<tr>
						  		<td class="encabezado center"><p class="f-12">Tipo de empresa</p></td>
						    	<td class="center"><p class="f-12"><?php echo $ref->tipo_empresa; ?></p></td>
						    	<td class="encabezado center"><p class="f-12">Puesto desempeñado</p></td>
						    	<td class="center"><p class="f-12"><?php echo $ref->puesto; ?></p></td>
						  	</tr>
						  	<tr>
						  		<td class="encabezado center"><p class="f-12">Periodo trabajado, mes y año</p></td>
						    	<td class="center"><p class="f-12"><?php echo $ref->periodo; ?></p></td>
						    	<td class="encabezado center"><p class="f-12">Nombre del último jefe</p></td>
						    	<td class="center"><p class="f-12"><?php echo $ref->jefe_nombre; ?></p></td>
						  	</tr>
						  	<tr>
						  		<td class="encabezado center"><p class="f-12">Puesto del último jefe</p></td>
						    	<td class="center"><p class="f-12"><?php echo $ref->jefe_puesto; ?></p></td>
						    	<td class="encabezado center"><p class="f-12">Sueldo mensual inicial</p></td>
						    	<td class="center"><p class="f-12"><?php echo "$ ".$ref->sueldo_inicial; ?></p></td>
						  	</tr>
						  	<tr>
						  		<td class="encabezado center"><p class="f-12">Sueldo mensual final</p></td>
						    	<td class="center"><p class="f-12"><?php echo "$ ".$ref->sueldo_final; ?></p></td>
						    	<td class="encabezado center"><p class="f-12">¿En qué consistía su trabajo?</p></td>
						    	<td class="center"><p class="f-12"><?php echo $ref->actividades; ?></p></td>
						  	</tr>
						  	<tr>
						  		<td class="encabezado center"><p class="f-12">Causa de separación</p></td>
						    	<td class="center" colspan="3"><p class="f-12"><?php echo $ref->causa_separacion; ?></p></td>
						  	</tr>
						</table>
					</div><br>
					<p class="f-14 center">Tabla de Rendimiento</p><br>
					<div class="div_datos">
						<table class="">
						  	<tr>
						    	<th class="encabezado w-60">Características Analizadas</th>
						    	<th class="encabezado">Calificación</th>
						  	</tr>
						  	<?php 
							  	if($ref->trabajo_calidad == "No proporciona" && $ref->trabajo_puntualidad == "No proporciona" && $ref->trabajo_honesto == "No proporciona" && $ref->trabajo_responsabilidad == "No proporciona" && $ref->trabajo_adaptacion == "No proporciona" && $ref->trabajo_actitud_jefes == "No proporciona" && $ref->trabajo_actitud_companeros == "No proporciona"){
							  		echo '<tr>
							  				<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
							    			<td class="center" rowspan="7"><p class="f-12">No proporciona</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
						  				</tr>
						  				<tr>
							  				<td class="encabezado center"><p class="f-12">Emotional Actitud hacia sus compañeros</p></td>
						  				</tr>';
							  	}
							  	else{
							  		if($ref->trabajo_calidad == "Excelente" && $ref->trabajo_puntualidad == "Excelente" && $ref->trabajo_honesto == "Excelente" && $ref->trabajo_responsabilidad == "Excelente" && $ref->trabajo_adaptacion == "Excelente" && $ref->trabajo_actitud_jefes == "Excelente" && $ref->trabajo_actitud_companeros == "Excelente"){
								  		echo '<tr>
								  				<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
								    			<td class="center" rowspan="7"><p class="f-12">Excelente</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
							  				</tr>
							  				<tr>
								  				<td class="encabezado center"><p class="f-12">Emotional Actitud hacia sus compañeros</p></td>
							  				</tr>';
								  	}
								  	else{
								  		if($ref->trabajo_calidad == "Bueno" && $ref->trabajo_puntualidad == "Bueno" && $ref->trabajo_honesto == "Bueno" && $ref->trabajo_responsabilidad == "Bueno" && $ref->trabajo_adaptacion == "Bueno" && $ref->trabajo_actitud_jefes == "Bueno" && $ref->trabajo_actitud_companeros == "Bueno"){
									  		echo '<tr>
									  				<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
									    			<td class="center" rowspan="7"><p class="f-12">Bueno</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
								  				</tr>
								  				<tr>
									  				<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
								  				</tr>';
									  	}
									  	else{
									  		if($ref->trabajo_calidad == "Regular" && $ref->trabajo_puntualidad == "Regular" && $ref->trabajo_honesto == "Regular" && $ref->trabajo_responsabilidad == "Regular" && $ref->trabajo_adaptacion == "Regular" && $ref->trabajo_actitud_jefes == "Regular" && $ref->trabajo_actitud_companeros == "Regular"){
										  		echo '<tr>
										  				<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
										    			<td class="center" rowspan="7"><p class="f-12">Regular</p></td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
									  				</tr>
									  				<tr>
										  				<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
									  				</tr>';
										  	}
										  	else{
										  		if($ref->trabajo_calidad == "Insuficiente" && $ref->trabajo_puntualidad == "Insuficiente" && $ref->trabajo_honesto == "Insuficiente" && $ref->trabajo_responsabilidad == "Insuficiente" && $ref->trabajo_adaptacion == "Insuficiente" && $ref->trabajo_actitud_jefes == "Insuficiente" && $ref->trabajo_actitud_companeros == "Insuficiente"){
											  		echo '<tr>
											  				<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
											    			<td class="center" rowspan="7"><p class="f-12">Insuficiente</p></td>
										  				</tr>
										  				<tr>
											  				<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
										  				</tr>
										  				<tr>
											  				<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
										  				</tr>
										  				<tr>
											  				<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
										  				</tr>
										  				<tr>
											  				<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
										  				</tr>
										  				<tr>
											  				<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
										  				</tr>
										  				<tr>
											  				<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
										  				</tr>';
											  	}
											  	else{
											  		if($ref->trabajo_calidad == "Muy mal" && $ref->trabajo_puntualidad == "Muy mal" && $ref->trabajo_honesto == "Muy mal" && $ref->trabajo_responsabilidad == "Muy mal" && $ref->trabajo_adaptacion == "Muy mal" && $ref->trabajo_actitud_jefes == "Muy mal" && $ref->trabajo_actitud_companeros == "Muy mal"){
												  		echo '<tr>
												  				<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
												    			<td class="center" rowspan="7"><p class="f-12">Muy mal</p></td>
											  				</tr>
											  				<tr>
												  				<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
											  				</tr>
											  				<tr>
												  				<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
											  				</tr>
											  				<tr>
												  				<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
											  				</tr>
											  				<tr>
												  				<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
											  				</tr>
											  				<tr>
												  				<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
											  				</tr>
											  				<tr>
												  				<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
											  				</tr>';
												  	}
												  	else{
												  		echo '<tr>
												  				<td class="encabezado center"><p class="f-12">Calidad en el trabajo</p></td>
												    			<td class="center"><p class="f-12">'.$ref->trabajo_calidad.'</p></td>
											  				</tr>
											  				<tr>
												  				<td class="encabezado center"><p class="f-12">Puntualidad y asistencia</p></td>
												  				<td class="center"><p class="f-12">'.$ref->trabajo_puntualidad.'</p></td>
											  				</tr>
											  				<tr>
												  				<td class="encabezado center"><p class="f-12">Honradez e integridad</p></td>
												  				<td class="center"><p class="f-12">'.$ref->trabajo_honesto.'</p></td>
											  				</tr>
											  				<tr>
												  				<td class="encabezado center"><p class="f-12">Responsabilidad</p></td>
												  				<td class="center"><p class="f-12">'.$ref->trabajo_responsabilidad.'</p></td>
											  				</tr>
											  				<tr>
												  				<td class="encabezado center"><p class="f-12">Adaptación al trabajo</p></td>
												  				<td class="center"><p class="f-12">'.$ref->trabajo_adaptacion.'</p></td>
											  				</tr>
											  				<tr>
												  				<td class="encabezado center"><p class="f-12">Actitud hacia sus jefes</p></td>
												  				<td class="center"><p class="f-12">'.$ref->trabajo_actitud_jefes.'</p></td>
											  				</tr>
											  				<tr>
												  				<td class="encabezado center"><p class="f-12">Actitud hacia sus compañeros</p></td>
												  				<td class="center"><p class="f-12">'.$ref->trabajo_actitud_companeros.'</p></td>
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
						    	<td class="encabezado w-60">Comentarios y Observaciones</td>
						    	<td class="center"><?php echo $ref->comentarios; ?></td>
						  	</tr>
						</table>
					</div>
					<pagebreak>
			<?php
				}
			?>
	<?php	
		}
	 ?>

	<?php 
		if($legal != "" && $legal != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Investigación Legal</p>
				<table class="">
				  	<tr>
				    	<td class="center w-20">Penal </td>
				    	<td class="encabezado"><p class="f-12"><?php echo $legal->penal; ?></p></td>
				    </tr>
				    <tr>
				    	<td class="center w-20">Notas </td>
				    	<td class="center"><p class="f-12"><?php echo $legal->penal_notas; ?></p></td>		    	
				  	</tr>
				</table><br><br>
				<table class="">
				  	<tr>
				    	<td class="center w-20">Civil </td>
				    	<td class="encabezado"><p class="f-12"><?php echo $legal->civil; ?></p></td>
				    </tr>
				    <tr>
				    	<td class="center w-20">Notas </td>
				    	<td class="center"><p class="f-12"><?php echo $legal->civil_notas; ?></p></td>		    	
				  	</tr>
				</table><br><br>
				<table class="">
				  	<tr>
				    	<td class="center w-20">Laboral </td>
				    	<td class="encabezado"><p class="f-12"><?php echo $legal->laboral; ?></p></td>
				    </tr>
				    <tr>
				    	<td class="center w-20">Notas </td>
				    	<td class="center"><p class="f-12"><?php echo $legal->laboral_notas; ?></p></td>		    	
				  	</tr>
				</table>
			</div><br><br><br>
	<?php	
		}
	 ?>

	<?php 
		if($nom != "" && $nom != null){ ?>
			<div class="div_datos">
				<p class="center f-18">Trabajos No Mencionados</p>
				<table class="">
				  	<tr>
				    	<td class="center w-20">No Mencionados </td>
				    	<td class="encabezado"><p class="f-12"><?php echo $nom->no_mencionados; ?></p></td>
				    </tr>
				    <tr>
				    	<td class="center w-20">Resultado </td>
				    	<td class="center"><p class="f-12"><?php echo $nom->resultado_no_mencionados; ?></p></td>		    	
				  	</tr>
				</table><br><br>
				<table class="">
				  	<tr>
				    	<td class="center w-20">Notas </td>
				    	<td class="encabezado" colspan="2"><p class="f-12"><?php echo $nom->notas_no_mencionados; ?></p></td>
				    </tr>
				</table><br><br>
			</div>

			<pagebreak>
	<?php	
		}
	 ?>

	<div class="center sin-flotar margen-top">
		<p class="f-20">Fotos </p><br>
	</div>
	<?php 
	if($docs){
		$band = 0;
		echo '<div class="center margen-top">';
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 19){
				echo '<img class="foto" src="'.base_url().'_docs/'.$doc->archivo.'">';
				$band++;
			}
		}
		if($band == 0){
			echo '<h2>Sin registro de fotos</h2>';
		}
		echo '</div>';
	}
	?>

	<pagebreak>

	<div class="center sin-flotar margen-top">
		<p class="f-20">Records Criminales – OFAC</p>
	</div>
	<?php 
	if($docs){
		$band = 0;
		echo '<div class="center">';
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 11){
				echo '<img src="'.base_url().'_docs/'.$doc->archivo.'" width="550" height="750">';
				$band++;
			}
		}
		if($band == 0){
			echo '<h2>Sin registro de OFAC</h2>';
		}
		echo '</div>';
	}
	?>

	<pagebreak>

	<div class="center sin-flotar margen-top">
		<p class="f-20">Aviso de Privacidad </p><br><br>
	</div>
	<?php 
	if($docs){
		$band = 0;
		echo '<div class="center">';
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 8){
				echo '<img class="img-aviso" src="'.base_url().'_docs/'.$doc->archivo.'">';
				$band++;
			}
		}
		if($band == 0){
			echo '<h2>Sin registro de aviso de privacidad</h2>';
		}
		echo '</div>';
	}
	?>

	<pagebreak>

	<div class="center sin-flotar margen-top">
		<p class="f-20">Anexos </p><br><br>
	</div>
	<?php 
	if($docs){
		$band = 0;
		echo '<div class="center">';
		foreach($docs as $doc){
			if($doc->id_tipo_documento == 9 || $doc->id_tipo_documento == 13 || $doc->id_tipo_documento == 23){
				echo '<img class="" src="'.base_url().'_docs/'.$doc->archivo.'">';
				$band++;
			}
		}
		if($band == 0){
			echo '<h2>Sin registro de anexos</h2>';
		}
		echo '</div>';
	}
	?>

	<?php 
		if($doc_doping != ""){ ?>
			<pagebreak>
			<div class="center sin-flotar margen-top">
				<p class="f-20">Examen Antidoping </p>
			</div>
	<?php 
			echo $doc_doping;
		}
	?>
</body>
</html>