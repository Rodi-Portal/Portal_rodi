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
	.margen-bottom { margin-bottom: 10px; }
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
	.img-foto-rostro { width: 150px; height: 160px; }
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
	.bordes-img{border: 1px solid black;}
	
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
		else{
			$doc_acta = "NO";
			$doc_ine = "NO";
			$doc_rfc = "NO";
			$doc_curp = "NO";
			$doc_imss = "NO";
			$doc_estudio = "NO";
			$doc_dom = "NO";
			$doc_penal = "NO";
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

			//$e = new DateTime($fecha_ver_laboral->fecha_finalizado);
			//$fecha_ver_laboral = $e->format('m/d/Y');

			//$e = new DateTime($fecha_ver_estudios->fecha_finalizado);
			//$fecha_ver_estudios = $e->format('m/d/Y');

			//$e = new DateTime($fecha_ver_penales->fecha_finalizado);
			//$fecha_ver_penales = $e->format('m/d/Y');

			$e = new DateTime($fecha_nacimiento);
			$fecha_nacimiento = $e->format('d/m/Y');

			if($doping != ""){
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
		if($ver_documento){
			foreach($ver_documento as $ver){
				$imss = $ver->imss;
				$imss_institucion = $ver->imss_institucion;
				$domicilio = $ver->domicilio;
				$domicilio_institucion = $ver->fecha_domicilio;
				$ine = $ver->ine;
				$ine_institucion = $ver->ine_institucion;
				$curp = $ver->curp;
				$curp_institucion = $ver->curp_institucion;
				$rfc = $ver->rfc;
				$rfc_institucion = $ver->rfc_institucion;
				$lic = $ver->licencia;
				$lic_institucion = $ver->licencia_institucion;
				$carta_recomendacion = $ver->carta_recomendacion;
				$carta_recomendacion_institucion = $ver->carta_recomendacion_institucion;
				$comentarios_documentos = $ver->comentarios;
			}
		}
		if(isset($pruebas)){
			$socioeconomico = ($pruebas->socioeconomico == 1)? "Sí":"No";
			$antidoping = ($pruebas->tipo_antidoping == 1)? "Sí":"No";
			$psicometrico = ($pruebas->psicometrico == 1)? "Sí":"No";
			$medico = ($pruebas->medico == 1)? "Sí":"No";
			$buro_credito = ($pruebas->buro_credito == 1)? "Sí":"No";
			$sociolaboral = ($pruebas->sociolaboral == 1)? "Sí":"No";
			$visita_domicilio = $visitador;

			if($medico == "Sí"){
				if($pruebas->conclusion_medico != null && $pruebas->conclusion_medico != ""){
					$e = new DateTime($pruebas->fecha_medico);
					$f_medico = $e->format('d/m/Y');
				}
				else{
					$f_medico = "Pendiente";
				}
			}
			else{
				$f_medico = "NA";
			}
			if($psicometrico == "Sí"){
				if($pruebas->archivo != null && $pruebas->archivo != ""){
					$e = new DateTime($pruebas->fecha_psicometrico);
					$f_psicometrico = $e->format('d/m/Y');
				}
				else{
					$f_psicometrico = "Pendiente";
				}
			}
			else{
				$f_psicometrico = "NA";
			}
		}
	?>
	<!-- HOJA 1 -->
	<div>
		<div class="col-md-4 borde-derecho">
			<img src="<?php echo base_url().'img/logo.png' ?>" width="190px" >
		</div>
		<div class="col-md-6">
			<span class="f-16 color-rodi margen-top"><b><?php echo $cliente; ?></span></b><br>
			<span class="f-16 color-rodi"><b>Reporte de Estudio Socioeconómico - Previo</span></b>
		</div>
	</div>

	
	<?php 
  if($secciones->id_seccion_datos_generales != NULL){
		if($edad != 0 && $estado_civil != NULL){ ?>
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
							<td class="encabezado">Edad:</td>
							<td class="center"><p class="f-12"><?php echo $edad; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Nacionalidad:</td>
							<td class="center"><p class="f-12"><?php echo $nacionalidad; ?></p></td>
							<td class="encabezado">Género:</td>
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
							<td class="encabezado">Ciudad:</td>
							<td class="center"><p class="f-12"><?php echo $municipio->nombre; ?></p></td>
							<td class="encabezado">Estado:</td>
							<td class="center"><p class="f-12"><?php echo $estado->nombre; ?></p></td>
							<td class="encabezado">Código postal:</td>
							<td class="center"><p class="f-12"><?php echo $cp; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Teléfono de casa:</td>
							<td class="center"><p class="f-12"><?php echo $tel_casa = ($telefono_casa == "")? "No proporciona":$telefono_casa; ?></p></td>
							<td class="encabezado">Teléfono de oficina:</td>
							<td class="center"><p class="f-12"><?php echo $tel_otro = ($telefono_otro == "")? "No proporciona":$telefono_otro; ?></p></td>
							<td class="encabezado">Teléfono celular:</td>
							<td class="center"><p class="f-12"><?php echo $celular; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Grado máximo de estudios:</td>
							<td class="center"><p class="f-12"><?php echo $estudios->nombre; ?></p></td>
							<td class="encabezado">Correo electrónico:</td>
							<td class="center"><p class="f-12"><?php echo $correo; ?></p></td>
							<td class="encabezado">Tiempo en el domicilio actual:</td>
							<td class="center"><p class="f-12"><?php echo $d->tiempo_dom_actual; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado">Tiempo de traslado a la oficina:</td>
							<td class="center"><p class="f-12"><?php echo $d->tiempo_traslado; ?></p></td>
							<td class="encabezado">Medio de transporte:</td>
							<td class="center"><p class="f-12"><?php echo $d->tipo_transporte; ?></p></td>
						</tr>
				</table>
			</div><br><br>
		<?php 
		} ?>
	<?php 
  }
	else{ ?>
		<div class="div_datos">
			<p class="center f-18">Datos Personales</p>
			<table class="">
				<tr>
					<td class="encabezado">Nombre del aspirante:</td>
					<td class="center" colspan="5"><p class="f-12"><?php echo $nombre." ".$pat." ".$mat; ?></p></td>
				</tr>
			</table>
		</div><br><br>
	<?php
	} ?>

	<?php 
  if($secciones->id_seccion_verificacion_docs != NULL){ 
		if($ver_documento){ ?>
			<div class="div_datos">
				<p class="center f-18">Documentos</p>
				<table class="">
						<tr>
							<th class="encabezado">CONCEPTO</th>
							<th class="encabezado">NÚMERO DE DOCUMENTO</th>
							<th class="encabezado">DATO / INSTITUCIÓN</th>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Número de Seguridad Social (NSS)</p></td>
							<td class="center"><p class="f-12"><?php echo $imss; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $imss_institucion; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Comprobante de domicilio</p></td>
							<td class="center"><p class="f-12"><?php echo $domicilio; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $domicilio_institucion; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">RFC con homoclave</p></td>
							<td class="center"><p class="f-12"><?php echo $rfc; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $rfc_institucion; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">ID (INE, IFE o pasaporte)</p></td>
							<td class="center"><p class="f-12"><?php echo $ine; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $ine_institucion; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">CURP</p></td>
							<td class="center"><p class="f-12"><?php echo $curp; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $curp_institucion; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Licencia para conducir</p></td>
							<td class="center"><p class="f-12"><?php echo $lic; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $lic_institucion; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado center"><p class="f-12">Carta de recomendación</p></td>
							<td class="center"><p class="f-12"><?php echo $carta_recomendacion; ?></p></td>
							<td class="center"><p class="f-12"><?php echo $carta_recomendacion_institucion; ?></p></td>
						</tr>
				</table>
			</div>
			<pagebreak>
		<?php 
		} ?>
	<?php
	} ?>


	<?php 
  if($secciones->lleva_sociales == 1){
		if(!empty($sociales)){ ?>
			<div class="div_datos">
				<p class="center f-18">Antecedentes Sociales</p>
				<table class="">
						<tr>
							<td class="encabezado w-25">¿Qué religión profesa?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales->religion; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales->religion_frecuencia; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Ingiere bebidas alcohólicas? </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales->bebidas == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia? </td>
							<td class="center"><p class="f-12"><?php echo $sociales->bebidas_frecuencia; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Acostumbra fumar?  </td>
							<td class="center"><p class="f-12"><?php echo $res = ($sociales->fumar == 1)? "Sí":"No"; ?></p></td>
							<td class="encabezado w-25">¿Con qué frecuencia?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales->fumar_frecuencia; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Ha tenido alguna intervención quirúrgica? </td>
							<td class="center"><p class="f-12"><?php echo $sociales->cirugia; ?></p></td>
							<td class="encabezado w-25">¿Antecedentes de enfermedades en su familia directa? </td>
							<td class="center"><p class="f-12"><?php echo $sociales->enfermedades; ?></p></td>
						</tr>
						<tr>
							<td class="encabezado w-25">¿Cuáles son sus planes a corto plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales->corto_plazo; ?></p></td>
							<td class="encabezado w-25">¿Cuáles son sus planes a mediano plazo?  </td>
							<td class="center"><p class="f-12"><?php echo $sociales->mediano_plazo; ?></p></td>
						</tr>
				</table>
			</div><br>
		<?php 
		} ?>
	<?php
	} ?>


	<?php 
  if($secciones->lleva_familiares == 1){
		if($familia){ ?>
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
						if($familia){
							foreach($familia as $f){
							
								$salida .= '<tr>';
								$salida .= '<td class="center w-40"><p class="f-12">'.$f->persona.'</p></td>';
								$salida .= '<td class="center"><p class="f-12">'.$f->parentesco.'</p></td>';
								$salida .= '<td class="center"><p class="f-12">'.$f->edad.'</p></td>';
								$salida .= '<td class="center"><p class="f-12">'.$f->estado_civil.'</p></td>';
								$salida .= '<td class="center"><p class="f-12">'.$f->escolaridad.'</p></td>';
								$salida .= ($f->misma_vivienda == 1) ? '<td class="center"><p class="f-12">Sí</p></td>' : '<td class="center"><p class="f-12">No</p></td>';
								$salida .= '</tr>';
							}
						}
						else{
							$salida2 .= '<tr>';
							$salida2 .= '<td class="center" colspan="4"><p class="f-12">El candidato vive solo</p></td>';
							$salida2 .= '</tr>';
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
							<th class="encabezado">EMPRESA / CIUDAD</th>
							<th class="encabezado">PUESTO</th>
							<th class="encabezado">ANTIGÜEDAD</th>
						</tr>
						<?php $salida = '';
						if($familia){
							foreach($familia as $f){
							
								$salida .= '<tr>';
								$salida .= '<td class="center"><p class="f-12">'.$f->persona.'</p></td>';
								$salida .= '<td class="center"><p class="f-12">'.$f->empresa.'</p></td>';
								$salida .= '<td class="center"><p class="f-12">'.$f->puesto.'</p></td>';
								$salida .= '<td class="center"><p class="f-12">'.$f->antiguedad.'</p></td>';
								$salida .= '</tr>';
							}
						}
						else{
							$salida2 .= '<tr>';
							$salida2 .= '<td class="center" colspan="4"><p class="f-12">El candidato vive solo</p></td>';
							$salida2 .= '</tr>';
						}
						echo $salida;
						?>
				</table>
			</div><br>
			<pagebreak>
	<?php
		}
	} ?>

<?php 
  if($secciones->lleva_familiares == 1 && $secciones->lleva_egresos == 1 && $secciones->id_finanzas == 36){
		if($familia){ ?>
			<div class="div_datos">
				<p class="center f-18">Situación Económica</p>
				<?php 
				if($secciones->lleva_familiares == 1){ ?>
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
							if($familia){
								$numFamiliares = count($familia);
								if($numFamiliares > 1){
									foreach($familia as $f){
										$salida2 .= '<tr>';
										$salida2 .= '<td class="center"><p class="f-12">'.$f->persona.'</p></td>';
										$salida2 .= '<td class="center"><p class="f-12">'.$f->sueldo.'</p></td>';
										$salida2 .= '<td class="center"><p class="f-12">'.$f->monto_aporta.'</p></td>';
										$salida2 .= '</tr>';
									}
								}
								if($numFamiliares == 1){
									$salida2 .= '<tr>';
									$salida2 .= '<td class="center"><p class="f-12">'.$nombre." ".$pat." ".$mat.'</p></td>';
									$salida2 .= '<td class="center"><p class="f-12">'.$d->ingresos.'</p></td>';
									$salida2 .= '<td class="center"><p class="f-12">'.$d->aporte.'</p></td>';
									$salida2 .= '</tr>';
								}
							}
							else{
								$salida2 .= '<tr>';
								$salida2 .= '<td class="center"><p class="f-12">'.$nombre." ".$pat." ".$mat.'</p></td>';
								$salida2 .= '<td class="center"><p class="f-12">'.$d->ingresos.'</p></td>';
								$salida2 .= '<td class="center"><p class="f-12">'.$d->aporte.'</p></td>';
								$salida2 .= '</tr>';
								$salida2 .= '<tr>';
								$salida2 .= '<td class="center" colspan="3"><p class="f-12">El candidato vive solo</p></td>';
								$salida2 .= '</tr>';
							}
							echo $salida2;
							?>
					</table>
				<?php 
				}  
				if($secciones->lleva_egresos == 1 && $secciones->id_finanzas == 36){ ?>
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
				<?php 
				} ?>
			</div><br>
	<?php 
		}
	} ?>

	<?php
	if($secciones->id_finanzas == 43){
		if(!empty($egresos) && $d->ingresos != null){ ?>	
			<table class="">
				<tr>
					<th class="encabezado" colspan="2">BIENES, INGRESOS Y EGRESOS</th>
				</tr>
				<tr>
					<th class="encabezado w-25">CONCEPTOS</th>
					<th class="encabezado">MONTOS</th>
				</tr>
				<tr>
					<td class="encabezado w-40">Muebles y/o inmuebles </td>
					<td class="center"><p class="f-12"><?php echo $muebles; ?></p></td>
				</tr>
				<tr>
					<td class="encabezado w-40">Adeudo en muebles e inmuebles </td>
					<td class="center"><p class="f-12"><?php echo $res = ($adeudo_muebles == 1)? "Sí":"No"; ?></p></td>
				</tr>
				<tr>
					<td class="encabezado w-40">Ingresos fijos </td>
					<td class="center"><p class="f-12"><?php echo $d->ingresos; ?></p></td>
				</tr>
				<tr>
					<td class="encabezado w-40">Ingresos extra </td>
					<td class="center"><p class="f-12"><?php echo $d->ingresos_extra; ?></p></td>
				</tr>
				<tr>
					<td class="encabezado w-40">Gastos/Egresos generales </td>
					<td class="center"><p class="f-12"><?php echo $egresos->otros; ?></p></td>
				</tr>
				<tr>
					<td class="encabezado w-40">¿Cuándo los egresos son mayores a los ingresos, cómo los solventa? </td>
					<td class="center"><p class="f-12"><?php echo $egresos->solvencia; ?></p></td>
				</tr>
				<tr>
					<td class="encabezado w-40">Notas </td>
					<td class="center"><p class="f-12"><?php echo $d->comentario; ?></p></td>
				</tr>
			</table>
	<?php 
		}
	} ?>

	<?php 
	if($secciones->lleva_familiares == 1 && $secciones->id_finanzas == 36){ 
		if($familia){ ?>
			<div class="div_datos">
				<p class="center f-18">Bienes (Muebles e Inmuebles)</p>
				<table class="">
						<tr>
							<th class="encabezado">NOMBRE DEL PROPIETARIO</th>
							<th class="encabezado">MUEBLES E INMUEBLES</th>
							<th class="encabezado">ADEUDO</th>
						</tr>
						<?php $salida3 = '';
						if($familia){
							foreach($familia as $f){
							
								$salida3 .= '<tr>';
								$salida3 .= '<td class="center"><p class="f-12">'.$f->persona.'</p></td>';
								$salida3 .= '<td class="center"><p class="f-12">'.$f->muebles.'</p></td>';
								$salida3 .= '<td class="center"><p class="f-12">'.$res = ($f->adeudo == 1)? "Sí":"No".'</p></td>';
								$salida3 .= '</tr>';
							}
							if($muebles != null && $muebles != ""){
								$salida3 .= '<tr>';
								$salida3 .= '<td class="center"><p class="f-12">'.$nombre." ".$pat." ".$mat.'</p></td>';
								$salida3 .= '<td class="center"><p class="f-12">'.$muebles.'</p></td>';
								$salida3 .= '<td class="center"><p class="f-12">'.$res = ($adeudo_muebles == 1)? "Sí":"No".'</p></td>';
							}
						}
						else{
							if($muebles != null && $muebles != ""){
								$salida3 .= '<tr>';
								$salida3 .= '<td class="center"><p class="f-12">'.$nombre." ".$pat." ".$mat.'</p></td>';
								$salida3 .= '<td class="center"><p class="f-12">'.$muebles.'</p></td>';
								$salida3 .= '<td class="center"><p class="f-12">'.$res = ($adeudo_muebles == 1)? "Sí":"No".'</p></td>';
							}
						}
						echo $salida3;
						?>
				</table>
			</div><br>
			<pagebreak>
		<?php 
		} ?>
	<?php 
	} ?>


	<?php
	if($secciones->lleva_vivienda == 1){
		if(!empty($vivienda)){  ?>
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
			</div><br>
		<?php 
		} ?>
	<?php 
	} ?>

<?php
	if($secciones->lleva_estudios == 1){
		if(!empty($academico)){  ?>
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
						<tr>
							<td class="encabezado center"><p class="f-12">Seminarios / Cursos</p></td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $academico->otros_certificados; ?></p></td>
						</tr>
						
						<tr>
							<td class="encabezado center"><p class="f-12">Comentarios</p></td>
							<td class="center" colspan="5"><p class="f-12"><?php echo $academico->comentarios; ?></p></td>
						</tr>
				</table>
			</div><br>
			<div class="div_datos">
				<p class="center f-18">Periodos escolares inactivos</p>
				<table>
					<tr>
							<td class="center"><p class="f-12"><?php echo $academico->carrera_inactivo; ?></p></td>
						</tr>
				</table>
			</div>
			<pagebreak>
		<?php 
		} ?>
	<?php 
	} ?>

	<?php 
	if($secciones->lleva_empleos == 1){
		if($ref_laboral){ 
			$cont = 1; ?>
			<div class="div_datos">
					<p class="center f-18">Referencias laborales </p>
			<?php
			foreach($ref_laboral as $ref){
				$ver_laboral = $this->candidato_model->getVerificacionLaboral($cont, $id_candidato); ?>
				
					<table class="">
							<tr>
								<th class="encabezado"></th>
								<th class="encabezado">Candidato</th>
								<th class="encabezado">Compañía</th>
								<th class="encabezado">Referencias</th>
							</tr>
							<tr>
								<td class="encabezado center"><p class="f-12">Compañía</p></td>
								<td class="center"><p class="f-12"><?php echo $ref->empresa; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $ver_laboral->empresa; ?></p></td>
								<td class="left w-30" rowspan="12"><p class="f-12"><?php echo $ver_laboral->notas; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado center"><p class="f-12">Dirección</p></td>
								<td class="center"><p class="f-12"><?php echo $ref->direccion; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $ver_laboral->direccion; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado center"><p class="f-12">Fecha de entrada</p></td>
								<td class="center"><p class="f-12"><?php echo $entrada_laboral = $ref->fecha_entrada_txt; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $entrada_verifica = $ver_laboral->fecha_entrada_txt; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado center"><p class="f-12">Fecha de salida</p></td>
								<td class="center"><p class="f-12"><?php echo $salida_laboral = $ref->fecha_salida_txt; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $salida_verifica = $ver_laboral->fecha_salida_txt; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado center"><p class="f-12">Teléfono</p></td>
								<td class="center"><p class="f-12"><?php echo $ref->telefono; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $ver_laboral->telefono; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado center"><p class="f-12">Puesto inicial</p></td>
								<td class="center"><p class="f-12"><?php echo $ref->puesto1; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $ver_laboral->puesto1; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado center"><p class="f-12">Puesto final</p></td>
								<td class="center"><p class="f-12"><?php echo $ref->puesto2; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $ver_laboral->puesto2; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado center"><p class="f-12">Salario inicial</p></td>
								<td class="center"><p class="f-12"><?php echo $ref->salario1_txt; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $ver_laboral->salario1_txt; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado center"><p class="f-12">Salario final</p></td>
								<td class="center"><p class="f-12"><?php echo $ref->salario2_txt; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $ver_laboral->salario2_txt; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado center"><p class="f-12">Jefe inmediato</p></td>
								<td class="center"><p class="f-12"><?php echo $ref->jefe_nombre."<br>".$ref->jefe_correo; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $ver_laboral->jefe_nombre."<br>".$ver_laboral->jefe_correo; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado center"><p class="f-12">Puesto del jefe inmediato</p></td>
								<td class="center"><p class="f-12"><?php echo $ref->jefe_puesto; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $ver_laboral->jefe_puesto; ?></p></td>
							</tr>
							<tr>
								<td class="encabezado center"><p class="f-12">Motivo de separación</p></td>
								<td class="center"><p class="f-12"><?php echo $ref->causa_separacion; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $ver_laboral->causa_separacion; ?></p></td>
							</tr>
					</table>
				
				<p class="f-14 center">Características del candidato</p><br>
				<div class="div_datos">
					<table class="">
							<tr>
								<td class="encabezado right" width="35%"><p class="f-12"><b>Fortalezas o cualidades del candidato</b></p></td>
								<td class="center" colspan="3"><p class="f-11"><b><?php echo $ver_laboral->cualidades; ?></b></p></td>
							</tr>
							<tr>
								<td class="encabezado right" width="35%"><p class="f-12"><b>Áreas a mejorar del candidato</b></p></td>
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
	} ?>
	
	<?php 
	if($secciones->lleva_no_mencionados == 1){
		if(!empty($nom)){ ?>
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
				</table><br>
			</div>
		<?php 
		} ?>
	<?php 
	} ?>

	<?php 
	if($secciones->lleva_empleos == 1){
		if($d->trabajo_enterado != NULL && $d->trabajo_gobierno != NULL){ ?>
			<div class="div_datos">
				<p class="center f-18">¿Cómo se enteró del trabajo en <?php echo $cliente; ?> </p>
				<table>
					<tr>
							<td class="center"><p class="f-12"><?php echo $d->trabajo_enterado; ?></p></td>
						</tr>
				</table>
			</div><br>

			<div class="div_datos">
				<p class="center f-18">¿El candidato ha trabajado en alguna entidad de gobierno, partido político u ONG? </p>
				<table>
					<tr>
							<td class="center"><p class="f-12"><?php echo $d->trabajo_gobierno; ?></p></td>
						</tr>
				</table>
			</div><br>
		<?php 
		} 
		if($ref_empresa){ ?>
			<div class="div_datos">
				<p class="center f-18">Contactos en la misma empresa </p>
			<?php 
			if($ref_empresa){ 
				foreach($ref_empresa as $row){ ?>
					<table class="">
							<tr>
								<th class="encabezado">Nombre</th>
								<th class="encabezado">Puesto</th>
							</tr>
							<tr>
								<td class="center"><p class="f-12"><?php echo $row->nombre; ?></p></td>
								<td class="center"><p class="f-12"><?php echo $row->puesto; ?></p></td>
							</tr>
					</table>
				<?php
				} ?>
			<?php
			}
			else{ ?>
				<table>
					<tr>
							<td class="center"><p class="f-12">El candidato no tiene familiares, amigos o conocidos en <?php echo $cliente; ?></p></td>
						</tr>
				</table>
			<?php
			} ?>
			</div><br>
	<?php 
		}
	} ?>


<?php 
	if($secciones->cantidad_ref_vecinales > 0){
		if($ref_vecinal){ ?>
			<div class="div_datos">
				<p class="center f-18">Referencias Vecinales</p>
					<?php $salida4 = '';
					if($ref_vecinal){
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
					}
					else{
						$salida4 .= '<table class=""><tr>';
						$salida4 .= '<td class="encabezado"><p class="f-12">Sin referencias vecinales</p></td>';
						$salida4 .= '</tr></table><br><br>';
					}
					echo $salida4;
					?>		  	
			</div><br>
			<pagebreak>
		<?php 
		} ?>
	<?php 
	} ?>

	<?php 
	if($secciones->cantidad_ref_personales > 0){
		if($ref_personal){ ?>
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
					$sabe_donde = ($refper->sabe_trabajo == 1)? "Sí":"No";
					$sabe_vive = ($refper->sabe_vive == 1)? "Sí":"No";
					
					$salida2 .= '<table class=""><tr>';
					$salida2 .= '<td class="encabezado w-25"><p class="f-12">Nombre</p></td>';
					$salida2 .= '<td class="center"><p class="f-12">'.$refper->nombre.'</p></td>';
					$salida2 .= '<td class="encabezado w-25"><p class="f-12">Teléfono</p></td>';
					$salida2 .= '<td class="center"><p class="f-12">'.$refper->telefono.'</p></td>';
					$salida2 .= '</tr>';
					$salida2 .= '<tr>';
					$salida2 .= '<td class="encabezado w-25"><p class="f-12">Tiempo de conocerlo</p></td>';
					$salida2 .= '<td class="center"><p class="f-12">'.$refper->tiempo_conocerlo.'</p></td>';
					$salida2 .= '<td class="encabezado w-25"><p class="f-12">De qué lugar conoce al candidato</p></td>';
					$salida2 .= '<td class="center"><p class="f-12">'.$refper->donde_conocerlo.'</p></td>';
					$salida2 .= '</tr>';
					$salida2 .= '<tr>';
					$salida2 .= '<td class="encabezado"><p class="f-12">Sabe dónde trabaja el candidato</p></td>';
					$salida2 .= '<td class="center"><p class="f-12">'.$sabe_donde.'</p></td>';
					$salida2 .= '<td class="encabezado"><p class="f-12">Sabe dónde vive el candidato</p></td>';
					$salida2 .= '<td class="center"><p class="f-12">'.$sabe_vive.'</p></td>';
					$salida2 .= '</tr>';
					$salida2 .= '<tr>';
					$salida2 .= '<td class="encabezado w-25"><p class="f-12">La recomienda</p></td>';
					$salida2 .= '<td class="center" colspan="3"><p class="f-12">'.$recomienda.'</p></td>';
					$salida2 .= '</tr>';
					$salida2 .= '<tr>';
					$salida2 .= '<td class="encabezado"><p class="f-12">Comentario</p></td>';
					$salida2 .= '<td class="encabezado" colspan="3"><p class="f-12">'.$refper->comentario.'</p></td>';
					$salida2 .= '</tr></table><br><br>';
				}
				echo $salida2;
				?>		  	
			</div><br>
		<?php 
		} ?>
	<?php 
	} ?>

</body>
</html>