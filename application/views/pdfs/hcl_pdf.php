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
	.age_check_positive { background: #78f26d; }
	.age_check_negative { background: #eb4034; }
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
    //Se determinan los estatus finales de cada seccion
		if($bgc){
			foreach($bgc as $row){
				$identidad = $row->identidad_check;
				$empleo = $row->empleo_check;
				$estudios_check = $row->estudios_check;
				$penales = $row->penales_check;
				$ofac = $row->ofac_check;
				$lab = $row->laboratorio_check;
				$medico = $row->medico_check;
				$global = $row->global_searches_check;
				$domicilios_check = $row->domicilios_check;
				$credito_check = $row->credito_check;
				$professional_accreditation_check = $row->professional_accreditation_check;
				$sex_offender_check = $row->sex_offender_check;
				$ref_academica_check = $row->ref_academica_check;
				$nss_check = $row->nss_check;
				$ciudadania_check = $row->ciudadania_check;
				$mvr_check = $row->mvr_check;
				$militar_check = $row->militar_check;
				//$licencia_manejo_check = $row->licencia_manejo_check;
				$credencial_academica_check = $row->credencial_academica_check;
				$ref_profesional_check = $row->ref_profesional_check;
				$comentario_final = $row->comentario_final;
			}
			if($identidad == 0){ $f_identidad = "fondo2"; $s_identidad = "Negative"; }
			if($identidad == 1){ $f_identidad = "fondo1"; $s_identidad = "Positive"; }
			if($identidad == 2){ $f_identidad = "fondo3"; $s_identidad = "FC"; }
			if($identidad == 3 || $identidad == -1){  $f_identidad=''; $s_identidad = "NA"; }
			if($identidad == 4){ $f_identidad=''; $s_identidad = "Pending"; }

			if($empleo == 0){ $f_empleo = "fondo2"; $s_empleo = "Negative"; }
			if($empleo == 1){ $f_empleo = "fondo1"; $s_empleo = "Positive"; }
			if($empleo == 2){ $f_empleo = "fondo3"; $s_empleo = "FC"; }
			if($empleo == 3 || $empleo == -1){  $f_empleo=''; $s_empleo = "NA"; }
			if($empleo == 4){ $f_empleo=''; $s_empleo = "Pending"; }

			if($estudios_check == 0){ $f_estudios = "fondo2"; $s_estudios = "Negative"; }
			if($estudios_check == 1){ $f_estudios = "fondo1"; $s_estudios = "Positive"; }
			if($estudios_check == 2){ $f_estudios = "fondo3"; $s_estudios = "FC"; }
			if($estudios_check == 3 || $estudios_check == -1){  $f_estudios=''; $s_estudios = "NA"; }
			if($estudios_check == 4){ $f_estudios=''; $s_estudios = "Pending"; }

			if($penales == 0){ $f_penales = "fondo2"; $s_penales = "Negative"; }
			if($penales == 1){ $f_penales = "fondo1"; $s_penales = "Positive"; }
			if($penales == 2){ $f_penales = "fondo3"; $s_penales = "FC"; }
			if($penales == 3 || $penales == -1){  $f_penales=''; $s_penales = "NA"; }
			if($penales == 4){ $f_penales=''; $s_penales = "Pending"; }

			if($ofac == 0){ $f_ofac = "fondo2"; $s_ofac = "Negative"; }
			if($ofac == 1){ $f_ofac = "fondo1"; $s_ofac = "Positive"; }
			if($ofac == 2){ $f_ofac = "fondo3"; $s_ofac = "FC"; }
			if($ofac == 3 || $ofac == -1){  $f_ofac=''; $s_ofac = "NA"; }
			if($ofac == 4){ $f_ofac=''; $s_ofac = "Pending"; }

			if($medico == 0){ $f_medico = "fondo2"; $s_medico = "Negative"; }
			if($medico == 1){ $f_medico = "fondo1"; $s_medico = "Positive"; }
			if($medico == 2){ $f_medico = "fondo3"; $s_medico = "FC"; }
			if($medico == 3 || $medico == -1){  $f_medico=''; $s_medico = "NA"; }

			if($global == 0){ $f_global = "fondo2"; $s_global = "Negative"; }
			if($global == 1){ $f_global = "fondo1"; $s_global = "Positive"; }
			if($global == 2){ $f_global = "fondo3"; $s_global = "FC"; }
			if($global == 3 || $global == -1){  $f_global=''; $s_global = "NA"; }
			if($global == 4){ $f_global=''; $s_global = "Pending"; }

			if($domicilios_check == 0){ $f_dom = "fondo2"; $s_dom = "Negative"; }
			if($domicilios_check == 1){ $f_dom = "fondo1"; $s_dom = "Positive"; }
			if($domicilios_check == 2){ $f_dom = "fondo3"; $s_dom = "FC"; }
			if($domicilios_check == 3 || $domicilios_check == -1){ $f_dom=''; $s_dom = "NA"; }

      if($credito_check == 0){ $f_credito = "fondo2"; $s_credito = "Negative"; }
			if($credito_check == 1){ $f_credito = "fondo1"; $s_credito = "Positive"; }
			if($credito_check == 2){ $f_credito = "fondo3"; $s_credito = "FC"; }
			if($credito_check == 3 || $credito_check == -1){ $f_credito=''; $s_credito = "NA"; }

      if($professional_accreditation_check == 0){ $f_professional_acreditation = "fondo2"; $s_professional_acreditation = "Negative"; }
			if($professional_accreditation_check == 1){ $f_professional_acreditation = "fondo1"; $s_professional_acreditation = "Positive"; }
			if($professional_accreditation_check == 2){ $f_professional_acreditation = "fondo3"; $s_professional_acreditation = "FC"; }
			if($professional_accreditation_check == 3 || $professional_accreditation_check == -1){ $f_professional_acreditation=''; $s_professional_acreditation = "NA"; }

      if($sex_offender_check == 0){ $f_sex_offender = "fondo2"; $s_sex_offender = "Negative"; }
			if($sex_offender_check == 1){ $f_sex_offender = "fondo1"; $s_sex_offender = "Positive"; }
			if($sex_offender_check == 2){ $f_sex_offender = "fondo3"; $s_sex_offender = "FC"; }
			if($sex_offender_check == 3 || $sex_offender_check == -1){ $f_sex_offender=''; $s_sex_offender = "NA"; }

      if($ref_academica_check == 0){ $f_ref_academica = "fondo2"; $s_ref_academica = "Negative"; }
			if($ref_academica_check == 1){ $f_ref_academica = "fondo1"; $s_ref_academica = "Positive"; }
			if($ref_academica_check == 2){ $f_ref_academica = "fondo3"; $s_ref_academica = "FC"; }
			if($ref_academica_check == 3 || $ref_academica_check == -1){ $f_ref_academica=''; $s_ref_academica = "NA"; }

      if($nss_check == 0){ $f_nss = "fondo2"; $s_nss = "Negative"; }
			if($nss_check == 1){ $f_nss = "fondo1"; $s_nss = "Positive"; }
			if($nss_check == 2){ $f_nss = "fondo3"; $s_nss = "FC"; }
			if($nss_check == 3 || $nss_check == -1){ $f_nss=''; $s_nss = "NA"; }

      if($ciudadania_check == 0){ $f_ciudadania = "fondo2"; $s_ciudadania = "Negative"; }
			if($ciudadania_check == 1){ $f_ciudadania = "fondo1"; $s_ciudadania = "Positive"; }
			if($ciudadania_check == 2){ $f_ciudadania = "fondo3"; $s_ciudadania = "FC"; }
			if($ciudadania_check == 3 || $ciudadania_check == -1){ $f_ciudadania=''; $s_ciudadania = "NA"; }

      if($mvr_check == 0){ $f_mvr = "fondo2"; $s_mvr = "Negative"; }
			if($mvr_check == 1){ $f_mvr = "fondo1"; $s_mvr = "Positive"; }
			if($mvr_check == 2){ $f_mvr = "fondo3"; $s_mvr = "FC"; }
			if($mvr_check == 3 || $mvr_check == -1){ $f_mvr=''; $s_mvr = "NA"; }
      
      if($militar_check == 0){ $f_militar = "fondo2"; $s_militar = "Negative"; }
			if($militar_check == 1){ $f_militar = "fondo1"; $s_militar = "Positive"; }
			if($militar_check == 2){ $f_militar = "fondo3"; $s_militar = "FC"; }
			if($militar_check == 3 || $militar_check == -1){ $f_militar=''; $s_militar = "NA"; }

      // if($licencia_manejo_check == 0){ $f_licencia_manejo = "fondo2"; $s_licencia_manejo = "Negative"; }
			// if($licencia_manejo_check == 1){ $f_licencia_manejo = "fondo1"; $s_licencia_manejo = "Positive"; }
			// if($licencia_manejo_check == 2){ $f_licencia_manejo = "fondo3"; $s_licencia_manejo = "FC"; }
			// if($licencia_manejo_check == 3 || $licencia_manejo_check == -1){ $f_licencia_manejo=''; $s_licencia_manejo = "NA"; }

      if($credencial_academica_check == 0){ $f_credencial_academica = "fondo2"; $s_credencial_academica = "Negative"; }
			if($credencial_academica_check == 1){ $f_credencial_academica = "fondo1"; $s_credencial_academica = "Positive"; }
			if($credencial_academica_check == 2){ $f_credencial_academica = "fondo3"; $s_credencial_academica = "FC"; }
			if($credencial_academica_check == 3 || $credencial_academica_check == -1){ $f_credencial_academica=''; $s_credencial_academica = "NA"; }

      if($ref_profesional_check == 0){ $f_ref_profesional = "fondo2"; $s_ref_profesional = "Negative"; }
			if($ref_profesional_check == 1){ $f_ref_profesional = "fondo1"; $s_ref_profesional = "Positive"; }
			if($ref_profesional_check == 2){ $f_ref_profesional = "fondo3"; $s_ref_profesional = "FC"; }
			if($ref_profesional_check == 3 || $ref_profesional_check == -1){ $f_ref_profesional=''; $s_ref_profesional = "NA"; }

      //Se evalua el examen antidoping en caso de que se haya asignado
			if(isset($doping)){
				$res_doping = ($doping->resultado == 0)? "Approved":"Not approved";
				if($doping->resultado == 0){ $f_doping = "fondo1"; }
				if($doping->resultado == 1){ $f_doping = "fondo2"; }
				$a = new DateTime($doping->fecha_resultado);
				$fecha_doping_res = $a->format('m/d/Y');
        $examenDoping = $this->doping_model->getPaqueteCandidato($doping->id_antidoping_paquete);
			}
			else{
				if($pruebas->tipo_antidoping != 0 && $pruebas->antidoping != 0){
          $examenDoping = $this->doping_model->getPaqueteCandidato($pruebas->antidoping);
          $res_doping = "Pending";
					$fecha_doping_res = ' - ';
				}
				else{
					$res_doping = "NA";
					$fecha_doping_res = 'NA';
				}
			}
      //Se extrae la fecha de finalizado en la verificacion de penales (se incluye la fecha en la verificacion OFAC)
			if(isset($fecha_ver_penales)){
				$e = new DateTime($fecha_ver_penales->fecha_finalizado);
				$fecha_ver_penales = $e->format('m/d/Y');
			}
			else{
				$fecha_ver_penales = 'NA';
			}
      //Se extrae la fecha de la verificacion de documentos que corresponde al Identity check
			if(isset($fecha_ver_documentos)){
				$e = new DateTime($fecha_ver_documentos->creacion);
				$fecha_ver_documentos = $e->format('m/d/Y');
			}
			else{
				$fecha_ver_documentos = 'NA';
			}
      //Se extrae la fecha de la creacion de las busquedas globales
			if(isset($global_searches)){
				$e = new DateTime($global_searches->creacion);
				$fecha_global = $e->format('m/d/Y');
			}
			else{
				$fecha_global = 'NA';
			}
      //Se extrae la fecha de finalizado en la verificacion de estudios
			if(isset($fecha_ver_estudios)){
				$e = new DateTime($fecha_ver_estudios->fecha_finalizado);
				$fecha_ver_estudios = $e->format('m/d/Y');
			}
			else{
				$fecha_ver_estudios = 'NA';
			}
      //Se extrae la fecha de finalizado en la verificacion de laborales
			if(isset($fecha_ver_laboral)){
				$e = new DateTime($fecha_ver_laboral->fecha_finalizado);
				$fecha_ver_laboral = $e->format('m/d/Y');
			}
			else{
				$fecha_ver_laboral = 'NA';
			}
      //Se extrae la fecha de la creacion del examen medico
			if(isset($fecha_medico)){
				$e = new DateTime($fecha_medico->creacion);
				$fecha_medico = $e->format('m/d/Y');
			}
			else{
				$fecha_medico = 'NA';
			}
      //Se extrae la fecha de la creacion de la verificacion de domicilios
			if(isset($ver_domicilios)){
				$e = new DateTime($ver_domicilios->creacion);
				$fecha_domicilios = $e->format('m/d/Y');
			}
			else{
				$fecha_domicilios = 'NA';
			}
      //Se extrae la fecha de la creacion de la ultima referencia academica
			if($ref_academicas){
        $index = (count($ref_academicas) - 1);
				$e = new DateTime($ref_academicas[$index]->creacion);
				$fecha_ref_academica = $e->format('m/d/Y');
			}
			else{
				$fecha_ref_academica = 'NA';
			}
      //Se extrae la fecha de la creacion de la ultima referencia profesional
			if($ref_profesional){
        $index = (count($ref_profesional) - 1);
				$e = new DateTime($ref_profesional[$index]->creacion);
				$fecha_ref_profesional = $e->format('m/d/Y');
			}
			else{
				$fecha_ref_academica = 'NA';
			}
      //Se extrae la fecha de la creacion del historial de credito
			if(isset($fecha_credito)){
				$e = new DateTime($fecha_credito->creacion);
				$fecha_historial_credito = $e->format('m/d/Y');
			}
			else{
				$fecha_historial_credito = 'NA';
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
				//$edad = $d->edad;
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
        //Datos internacionales
        $domicilio_internacional = $d->domicilio_internacional;
				$pais = $d->pais;
				$curp = $d->curp;
			}
			//Fechas
			$hoy = formatoEspecialFecha($hoy);
			$e = new DateTime($hoy);
			$hoy2 = $e->format('m/d/Y');

			$e = new DateTime($f);
			$f_requested = $e->format('m/d/Y');

      $f_alta_candidato = fecha_sinhora_ingles_front($f);

      if(!empty($fecha_nacimiento) && $fecha_nacimiento != '0000-00-00'){
        $f_nacimiento = fecha_ingles_usuario($fecha_nacimiento);
        $edad = calculaEdad($fecha_nacimiento);
      }else{
        $f_nacimiento = '';
        $edad = 0;
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
					$s_bgc = "For Consideration";
					break;
			}

			$estado = $this->candidato_model->getEstado($id_estado);
			$municipio = $this->candidato_model->getMunicipio($id_municipio);
      if($id_grado_estudio != NULL && $id_grado_estudio != 0){
        //$grado_estudios = $this->candidato_model->getTipoStudies($id_grado_estudio);
        $grado_estudios = $this->funciones_model->getGradoEstudioById($id_grado_estudio);
        if(isset($ver_mayor_estudio))
			    $ver_tipo_estudio = $this->funciones_model->getGradoEstudioById($ver_mayor_estudio->id_tipo_studies);
      }
		}
    //Extraccion de documentacion
    if($ver_documento){
			foreach($ver_documento as $item){
        //Estudios
				if(empty($item->licencia)){
					$lic = "N/A";
					$lic_institucion = "N/A";
				}
				else{
					$lic = $item->licencia;
					$lic_institucion = $item->licencia_institucion;
				}
        //ID
        //$estudios_region = $this->candidato_model->getSeccion($secciones->id_seccion_verificacion_docs);
        $tieneID = $this->candidato_model->getDocumentoEspecificoRequerido($id_candidato, 3);
        if($tieneID != null){
         
            if(empty($item->ine)){
              $ine_completo = "Not provided";
              $ine_institucion = "Not provided";
              $idDocumento = "ID not provided";
            }
            else{
              $ine_vertical = "";
              $ine_ano = "";
              if(!empty($item->ine_ano) && strlen($item->ine_ano) == 4){
                  
                $ine_ano = "<br>Register date: ".$item->ine_ano;
              }
              
              if(!empty($item->ine_vertical) && strlen($item->ine_vertical) > 4){

                $ine_vertical = "<br>Vertical number: ".$item->ine_vertical;

              }
             
              $ine_completo = "ID: ".$item->ine.$ine_ano.$ine_vertical;
              $ine_institucion = !empty($item->ine_institucion)? $item->ine_institucion : "Instituto Nacional Electoral" ;
              $idDocumento = "ID: ".$item->ine;
            }

          
          
        }else{
          $ine_completo = "N/A";
          $ine_institucion = "N/A";
        }
        //Antecedentes criminales
        if($item->penales == ''){
					$penales_completo = "N/A";
					$penales_institucion = "N/A";
				}
				else{
					$penales_completo = "Document Number:<br>".$item->penales;
					$penales_institucion = $item->penales_institucion;
				}
        //Pasaporte
				if(empty($item->pasaporte)){
					$pasaporte_completo = "N/A";
					$pasaporte_fecha = "N/A";
          $pasaporteDocumento = 'Not provided';
				}
				else{
					$pasaporte_completo = "Document Number:<br>".$item->pasaporte;
					$pasaporte_fecha = $item->pasaporte_fecha;
          $pasaporteDocumento = $item->pasaporte.' '.$item->pasaporte_fecha;
				}
        //Comprobnate de Domicilio
        if($item->domicilio == ''){
					$domicilio = "N/A";
					$domicilio_fecha = "N/A";
				}
				else{
					$domicilio = "Document Number:<br>".$item->domicilio;
					$domicilio_fecha = $item->fecha_domicilio;
				}
        //Servicio militar
				if(empty($item->militar)){
					$militar = "N/A";
					$militar_fecha = "N/A";
				}
				else{
					$militar = "Document Number:<br>".$item->militar;
					$militar_fecha = $item->militar_fecha;
				}
        //Forma migratoria
				if($item->forma_migratoria == ''){
					$forma_migratoria = "N/A";
					$forma_migratoria_fecha = "N/A";
				}
				else{
					$forma_migratoria = "Document Number:<br>".$item->forma_migratoria;
					$forma_migratoria_fecha = $item->militar_fecha;
				}
        //Licencia conducir
				if($item->licencia_manejo == ''){
					$licencia_manejo = "N/A";
					$licencia_manejo_fecha = "N/A";
				}
				else{
					$licencia_manejo = "Document Number:<br>".$item->licencia_manejo;
					$licencia_manejo_fecha = $item->militar_fecha;
				}
        //NSS
				if(empty($item->imss)){
					$imss = "N/A";
					$imss_institucion = "N/A";
				}
				else{
					$imss = "Document Number:<br>".$item->imss;
					$imss_institucion = $item->imss_institucion;
				}
        //MVR
				if(empty($item->motor_vehicle_records)){
					$mvr = "N/A";
				}
				else{
					$mvr = $item->motor_vehicle_records;
				}
				//Comentarios en la vrificacion de documentos
				$comentario_ver_documento = $item->comentarios;
			}
    }
    //Control de valores
    //Prohibited List
    if(isset($checklist)){
      $prohibited = ($checklist->prohibited_parties_list != '' && $checklist->prohibited_parties_list != null)? $checklist->prohibited_parties_list:'N/A';
    }
    else{
      $prohibited = 'N/A';
    }
    //Datos Generales
    $tel_casa = ($telefono_casa != '' && $telefono_casa != null)? $telefono_casa:'-';
    $tel_otro = ($telefono_otro != '' && $telefono_otro != null)? $telefono_otro:'-';
    //Comprobante de estudios
    if($docs){
      foreach($docs as $d){
        $doc[] = $d->id_tipo_documento;
      }
      if(in_array(10, $doc)){
        $comprobante_estudios = "Professional License";
      }
      else{
        $comprobante_estudios = "School Certificate";
      }
    }
    else{
      $comprobante_estudios = "School Certificate";
    }
	?>
	<!-- HOJA 1 -->
	<div>
		<div class="col-md-4 borde-derecho">
			<img src="<?php echo base_url().'img/logo.png' ?>" width="190px" >
		</div>
		<div class="col-md-6">
			<span class="f-16 color-rodi margen-top"><b><?php echo $cliente.' - '.$secciones->proyecto; ?></span></b><br>
			<span class="f-16 color-rodi"><b>Background Check Report - Checklist</span></b>
		</div>
	</div>
  <?php 
  if(isset($fecha_bgc)){ ?>
    <div class="margen-50 margen-top">
      <table class="tabla w-100">
        <tr>
          <td class="encabezado right" width="20%"><p class="f-11"><b>Release Date</b></p></td>
          <td class="right"><p class="f-11"><b><?php echo $fecha_bgc; ?></b></p></td>
        </tr>
      </table>
    </div>
  <?php
  } ?>
	<br>
  <table class="tabla w-100">
    <tr>
      <td class="encabezado right" width="30%"><p class="f-12"><b>Full Candidate Name</b></p></td>
      <td class="center" colspan="3"><p class="f-11"><b><?php echo $candidato; ?></b></p></td>
    </tr>
    <tr>
      <td class="encabezado right" width="30%"><p class="f-12"><b>Final BGC Status</b></p></td>
      <?php 
        if($status_bgc == 0){
          echo '<td class="center" colspan="3"><p class="f-11"><b>Pending</b></p></td>';
        }
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
    <?php 
    if(isset($comentario_final)){ ?>
      <tr>
        <td class="encabezado right" width="30%"><p class="f-12"><b>Remarks</b></p></td>
        <td class="center" colspan="3"><p class="f-11"><?php echo $comentario_final; ?></p></td>
      </tr>
    <?php
    } ?>
	</table>
  <br>
  <?php 
  //* Se obtienen los documentos cargados del candidato
  $documentosCandidato = array();
  if($docs){
    $archivos['documentos'] = $this->documentacion_model->getArchivosCandidato($id_candidato);
    if($archivos['documentos']){
      foreach($archivos['documentos'] as $doc){
        //if(stripos($doc->archivo, '.pdf') === false){
          $documentosCandidato[] = $doc->id_tipo_documento;
        //}
      }
    }
  }
  //* Se obtienen los documentos solicitados para el candidato
  $archivos['documentos_requeridos'] = $this->documentacion_model->getDocumentosRequeridosByCandidato($id_candidato);
  if($archivos['documentos_requeridos']){
    foreach($archivos['documentos_requeridos'] as $row){
      $documentosRequeridos[] = $row->id_tipo_documento;
    }
  }
  ?>
  <div class="flotar-izquierda w-70">
		<table class="w-90">
      <tr>
        <th class="encabezado">Check Item</th>
        <th class="encabezado">Status</th>
        <th class="encabezado">Delivery Date</th>
      </tr>
      <?php
      if($secciones->lleva_identidad == 1){ ?>
        <tr>
          <td class="left">Identity check</td>
          <td class="<?php echo $f_identidad; ?>"><?php echo $s_identidad; ?></td>
          <td><?php echo $fecha_ver_documentos ?></td>
        </tr>
      <?php 
      }
      if($secciones->lleva_empleos == 1){ ?>
        <tr>
          <td class="left">Employment History check</td>
          <td class="<?php echo $f_empleo; ?>"><?php echo $s_empleo; ?></td>
          <td><?php echo $fecha_ver_laboral; ?></td>
        </tr>
      <?php 
      }
      if($secciones->lleva_estudios == 1){ ?>
        <tr>
          <td class="left">Academic History check</td>
          <td class="<?php echo $f_estudios; ?>"><?php echo $s_estudios; ?></td>
          <td><?php echo $fecha_ver_estudios; ?></td>
        </tr>
      <?php 
      }
      if($secciones->lleva_criminal == 1){ ?>
        <tr>
          <td class="left">Criminal Records</td>
          <td class="<?php echo $f_penales; ?>"><?php echo $s_penales; ?></td>
          <td><?php echo $fecha_ver_penales; ?></td>
        </tr>
      <?php 
      }
      if(in_array(11, $documentosCandidato)){ ?>
        <tr>
          <td class="left">Criminal Records – OFAC</td>
          <td class="<?php echo $f_ofac; ?>"><?php echo $s_ofac; ?></td>
          <td><?php echo $fecha_ofac = ($fecha_ver_penales != 'NA')? $fecha_ver_penales : $fecha_ver_documentos; ?></td>
        </tr>
      <?php 
      }
      if($secciones->id_seccion_global_search != NULL){ ?>
        <tr>
          <td class="left">Global Database check</td>
          <td class="<?php echo $f_global; ?>"><?php echo $s_global; ?></td>
          <td><?php echo $fecha_global; ?></td>
        </tr>
      <?php 
      }
      if($res_doping != 'NA'){ ?>
        <tr>
          <td class="left">Laboratory Test (If Applicable)</td>
          <td class="<?php echo $f_doping; ?>"><?php echo $res_doping; ?></td>
          <td><?php echo $fecha_doping_res; ?></td>
        </tr>
      <?php 
      }
      if($fecha_medico != 'NA'){ ?>
        <tr>
          <td class="left">Medical Check Up (If Applicable)</td>
          <td class="<?php echo $f_medico; ?>"><?php echo $s_medico; ?></td>
          <td><?php echo $fecha_medico; ?></td>
        </tr>
      <?php 
      }
      if($secciones->id_seccion_historial_domicilios != NULL && $status_bgc > 0){ ?>
        <tr>
          <td class="left">Address History Check</td>
          <td class="<?php echo $f_dom; ?>"><?php echo $s_dom; ?></td>
          <td><?php echo $fecha_domicilios; ?></td>
        </tr>
      <?php 
      }
      if($secciones->lleva_credito == 1 && $status_bgc > 0){ ?>
        <tr>
          <td class="left">Credit check</td>
          <td class="<?php echo $f_credito; ?>"><?php echo $s_credito; ?></td>
          <td><?php echo $fecha_historial_credito; ?></td>
        </tr>
      <?php 
      }
      if(in_array(10, $documentosCandidato) && $status_bgc > 0){ ?>
        <tr>
          <td class="left">Professional accreditation check</td>
          <td class="<?php echo $f_professional_acreditation; ?>"><?php echo $s_professional_acreditation; ?></td>
          <td><?php echo $fecha_ver_documentos; ?></td>
        </tr>
      <?php 
      }
      if(in_array(48, $documentosRequeridos) && $status_bgc > 0){ ?>
        <tr>
          <td class="left">Academic credential check</td>
          <td class="<?php echo $f_credencial_academica; ?>"><?php echo $s_credencial_academica; ?></td>
          <td><?php echo $fecha_ver_documentos; ?></td>
        </tr>
      <?php 
      }
      if(in_array(42, $documentosCandidato) && $status_bgc > 0){ ?>
        <tr>
          <td class="left">Sex offender check</td>
          <td class="<?php echo $f_sex_offender; ?>"><?php echo $s_sex_offender; ?></td>
          <td><?php echo $fecha_ver_documentos; ?></td>
        </tr>
      <?php 
      }
      if($ref_academicas && $status_bgc > 0){ ?>
        <tr>
          <td class="left">Academic references check</td>
          <td class="<?php echo $f_ref_academica; ?>"><?php echo $s_ref_academica; ?></td>
          <td><?php echo $fecha_ref_academica; ?></td>
        </tr>
      <?php 
      }
      if($nss_check != 3 && $nss_check != -1 && $status_bgc > 0){ ?>
        <tr>
          <td class="left">Social Security Number check</td>
          <td class="<?php echo $f_nss; ?>"><?php echo $s_nss; ?></td>
          <td><?php echo $fecha_ver_documentos; ?></td>
        </tr>
      <?php 
      }
      if($ciudadania_check != 3 && $ciudadania_check != -1 && $status_bgc > 0){
        // $f_ciudadania = '';
        // $s_ciudadania = 'N/A';
        // $fecha_ciudadania = 'N/A';
        $f_ciudadania = $f_ciudadania;
        $s_ciudadania = $s_ciudadania;
        $fecha_ciudadania = $fecha_ver_documentos; ?>
        <tr>
          <td class="left">Citizenship check</td>
          <td class="<?php echo $f_ciudadania; ?>"><?php echo $s_ciudadania; ?></td>
          <td><?php echo $fecha_ciudadania; ?></td>
        </tr>
      <?php 
      }  
      if($secciones->lleva_motor_vehicle_records == 1 && $status_bgc > 0){ ?>
        <tr>
          <td class="left">Motor Vehicle Records check</td>
          <td class="<?php echo $f_mvr; ?>"><?php echo $s_mvr; ?></td>
          <td><?php echo $fecha_ver_documentos; ?></td>
        </tr>
      <?php 
      }
      if($secciones->lleva_prohibited_parties_list == 1 && in_array(30, $documentosCandidato) && $status_bgc > 0){ ?>
        <tr>
          <td class="left">Prohibited Parties List check</td>
          <td class="fondo1">Positive</td>
          <td><?php echo $fecha_ver_documentos; ?></td>
        </tr>
      <?php 
      }
      if($militar_check != 3 && $militar_check != -1 && $status_bgc > 0){ ?>
        <tr>
          <td class="left">Military Service check</td>
          <td class="<?php echo $f_militar; ?>"><?php echo $s_militar; ?></td>
          <td><?php echo $fecha_ver_documentos; ?></td>
        </tr>
      <?php 
      }
      if($ref_profesional && $status_bgc > 0){ ?>
        <tr>
          <td class="left">Professional references check</td>
          <td class="<?php echo $f_ref_profesional; ?>"><?php echo $s_ref_profesional; ?></td>
          <td><?php echo $fecha_ref_profesional; ?></td>
        </tr>
      <?php 
      }
      if($edad <= 16 && $secciones->id_seccion_datos_generales != NULL && $status_bgc > 0){ ?>
        <tr>
          <td class="left">Age check</td>
          <td class="fondo3">FC</td>
          <td><?php echo $f_alta_candidato; ?></td>
        </tr>
      <?php 
      }
      if($secciones->lleva_curp == 1 && (in_array(3, $documentosCandidato) || in_array(5, $documentosCandidato)) && $status_bgc > 0){ ?>
        <tr>
          <td class="left">CURP check</td>
          <td class="fondo1">Positive</td>
          <td><?php echo $fecha_ver_documentos; ?></td>
        </tr>
      <?php 
      }
      ?>
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
  <?php 
  if($ver_documento){
    $identificaciones = '';
    foreach($ver_documento as $item){
      if(!empty($item->ine) && in_array(3, $documentosCandidato)){
        $identificaciones = $idDocumento;
      }
      else{
        if(!empty($item->pasaporte) && in_array(14, $documentosCandidato)){
          $identificaciones = 'Passport: '.$item->pasaporte.' '.$item->pasaporte_fecha;
        }
      }
    }
    if($identificaciones == ''){
      $identificaciones = 'ID not provided';
    }
  }
  else{
    $identificaciones = 'N/A';
  } ?>

  <!-- Scope of verification -->
  <table class="tabla w-100">
    <tr>
      <th class="encabezado" colspan="2">Scope of Verification</th>
    </tr>
    <?php
    if($secciones->lleva_identidad == 1){ ?>
      <tr>
        <td class="encabezado center" width="25%"><b>Identity</b></td>
        <td class="left"><?php echo $identificaciones; ?></td>
      </tr>
    <?php 
    }
    if($secciones->lleva_empleos == 1){ ?>
      <tr>
        <td class="encabezado center"><b>Employment</b></td>
        <td class="left"><?php echo $secciones->tiempo_empleos; ?></td>
      </tr>
    <?php 
    }
    if($secciones->lleva_estudios == 1){ ?>
      <tr>
        <td class="encabezado center"><b>Education</b></td>
        <td class="left"><?php echo 'Highest studies'; ?></td>
      </tr>
    <?php 
    }
    if($secciones->lleva_criminal == 1){ ?>
      <tr>
        <td class="encabezado center"><b>Criminal</b></td>
        <td class="left"><?php echo $secciones->tiempo_criminales; ?></td>
      </tr>
    <?php 
    }
    if(in_array(11, $documentosCandidato)){ ?>
      <tr>
        <td class="encabezado center"><b>OFAC</b></td>
        <td class="left">No record found</td>
      </tr>
    <?php 
    }
    if($secciones->id_seccion_global_search != NULL){
      $seccion = $this->candidato_model->getSeccion($secciones->id_seccion_global_search);
      $descripcion_global = $seccion->descripcion_ingles; ?>
      <tr>
        <td class="encabezado center"><b>Database</b></td>
        <td class="left"><?php echo $descripcion_global; ?></td>
      </tr>
    <?php 
    }
    if($res_doping != 'NA'){ ?>
      <tr>
        <td class="encabezado center"><b>Drug test</b></td>
        <td class="left"><?php echo $examenDoping->nombre." Panel Drug Test"; ?></td>
      </tr>
    <?php 
    }
    if($fecha_medico != 'NA'){ ?>
      <tr>
        <td class="encabezado center"><b>Medical test</b></td>
        <td class="left"><?php echo 'Uploaded'; ?></td>
      </tr>
    <?php 
    }
    if($secciones->id_seccion_historial_domicilios != NULL && $status_bgc > 0){ ?>
      <tr>
        <td class="encabezado center"><b>Address</b></td>
        <td class="left"><?php echo $secciones->tiempo_domicilios; ?></td>
      </tr>
    <?php 
    }
    if($secciones->lleva_credito == 1 && $status_bgc > 0){ ?>
      <tr>
        <td class="encabezado center"><b>Credit</b></td>
        <td class="left">Checked</td>
      </tr>
    <?php 
    }
    if(in_array(10, $documentosCandidato) && $lic != 'N/A'){ ?>
      <tr>
        <td class="encabezado center"><b>Professional accreditation</b></td>
        <td class="left"><?php echo 'Verified with document: '.$s_professional_acreditation; ?></td>
      </tr>
    <?php 
    }
    if(in_array(48, $documentosRequeridos) && $status_bgc > 0){ ?>
      <tr>
        <td class="encabezado center"><b>Academic credential</b></td>
        <td class="left">Checked</td>
      </tr>
    <?php 
    }
    if(in_array(42, $documentosCandidato) && $status_bgc > 0){ ?>
      <tr>
        <td class="encabezado center"><b>Sex offender</b></td>
        <td class="left">No record found</td>
      </tr>
    <?php 
    }
    if($ref_academicas && $status_bgc > 0){ ?>
      <tr>
        <td class="encabezado center"><b>Academic references</b></td>
        <td class="left">Checked</td>
      </tr>
    <?php 
    }
    if($nss_check != 3 && $nss_check != -1 && $status_bgc > 0){
      if($nss_check == 1 || $nss_check == 2){ ?>
        <tr>
          <td class="encabezado center"><b>SSN</b></td>
          <td class="left"><?php echo $imss; ?></td>
        </tr>
    <?php 
      }
      elseif($nss_check == 0 && $status_bgc > 0){ ?>
        <tr>
          <td class="encabezado center"><b>SSN</b></td>
          <td class="left">Not validated</p></td>
        </tr>
    <?php
      }
    }
    //$citizenship = (in_array(14, $documentosCandidato))? 'Validated with Passport '.$pasaporteDocumento : 'Passport not provided';
    if($ciudadania_check != 3 && $ciudadania_check != -1 && $status_bgc > 0){
      if($ciudadania_check == 1 || $ciudadania_check == 2){ ?>
        <tr>
          <td class="encabezado center"><b>Citizenship</b></td>
          <td class="left"><?php echo 'Validated with Passport '.$pasaporteDocumento; ?></td>
        </tr>
    <?php 
      }
      elseif($ciudadania_check == 0 && $status_bgc > 0){ ?>
        <tr>
          <td class="encabezado center"><b>Citizenship</b></td>
          <td class="left">Not validated</p></td>
        </tr>
    <?php
      }
    }
    if($secciones->lleva_motor_vehicle_records == 1 && $status_bgc > 0){ ?>
      <tr>
        <td class="encabezado center"><b>MVR check</b></td>
        <td class="left"><?php echo $mvr; ?></td>
      </tr>
    <?php 
    }
    if($secciones->lleva_prohibited_parties_list == 1 && in_array(30, $documentosCandidato) && $status_bgc > 0){ ?>
      <tr>
        <td class="encabezado center"><b>Prohibited Parties List</b></td>
        <td class="left">No record found</td>
      </tr>
    <?php 
    }
    if($militar_check != 3 && $militar_check != -1 && $status_bgc > 0){
      if($militar_check == 1 || $militar_check == 2){ ?>
        <tr>
          <td class="encabezado center"><b>Military</b></td>
          <td class="left"><?php echo $militar.' '.$militar_fecha; ?></p></td>
        </tr>
    <?php 
      }
      elseif($militar_check == 0 && $status_bgc > 0){ ?>
        <tr>
          <td class="encabezado center"><b>Military</b></td>
          <td class="left">Not validated</p></td>
        </tr>
    <?php
      }
    }
    if($ref_profesional && $status_bgc > 0){ ?>
      <tr>
        <td class="encabezado center"><b>Professional references</b></td>
        <td class="left">Checked</td>
      </tr>
    <?php 
    }
    if($edad <= 16 && $secciones->id_seccion_datos_generales != NULL && $status_bgc > 0){ ?>
      <tr>
        <td class="encabezado center"><b>Age check</b></td>
        <td class="left"><?php echo $edad.' years old'; ?></p></td>
      </tr>
    <?php
    }
    if($secciones->lleva_curp == 1 && (in_array(3, $documentosCandidato) || in_array(5, $documentosCandidato)) && $status_bgc > 0){ ?>
      <tr>
        <td class="encabezado center">CURP check</td>
        <td class="left">Checked</td>
      </tr>
    <?php 
    }
    ?>
  </table>

  <br>
	

  <pagebreak>
	<!-- Datos Personales -->
  <?php 
  if($secciones->id_seccion_datos_generales == 111){ ?>
    <div class="div_datos">
      <p class="center f-18">Personal Data</p>
      <table class="">
          <tr>
            <td class="encabezado">Name:</td>
            <td class="center" colspan="5"><p class="f-12"><?php echo $nombre." ".$pat." ".$mat; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado">Date of birth:</td>
            <td class="center"><p class="f-12"><?php echo $f_nacimiento; ?></p></td>
            <td class="encabezado">Age:</td>
            <?php $estatus_edad = ($edad > 16)? '' : 'fondo3'; ?>
            <td class="center <?php echo $estatus_edad; ?>"><p class="f-12"><?php echo $edad; ?></p></td>
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
            <td class="center"><p class="f-12"><?php echo $tel_casa; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado">Number to leave Messages:</td>
            <td class="center"><p class="f-12"><?php echo $tel_otro; ?></p></td>
            <td class="encabezado">E-mail:</td>
            <td class="center"><p class="f-12"><?php echo $correo; ?></p></td>
            <?php
            if($curp != NULL && $curp != ''){ ?>
              <td class="encabezado">CURP:</td>
              <td class="center"><p class="f-12"><?php echo $curp; ?></p></td>
            <?php
            } ?>
          </tr>
      </table>
    </div>
  <?php 
  }
  if($secciones->id_seccion_datos_generales == 83){ ?>
    <div class="div_datos">
      <p class="center f-18">Personal Data</p>
      <table class="">
        <tr>
          <td class="encabezado">Name:</td>
          <td class="center" colspan="5"><p class="f-12"><?php echo $nombre." ".$pat." ".$mat; ?></p></td>
        </tr>
        <tr>
          <td class="encabezado">Date of birth:</td>
          <td class="center"><p class="f-12"><?php echo $f_nacimiento; ?></p></td>
          <td class="encabezado">Age:</td>
          <?php $estatus_edad = ($edad > 16)? '' : 'age_check_negative'; ?>
          <td class="center <?php echo $estatus_edad; ?>"><p class="f-12"><?php echo $edad; ?></p></td>
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
          <td class="center"><p class="f-12"><?php echo $tel_casa; ?></p></td>
        </tr>
        <tr>
          <td class="encabezado">Number to leave Messages:</td>
          <td class="center"><p class="f-12"><?php echo $tel_otro; ?></p></td>
          <td class="encabezado">E-mail:</td>
          <td class="center" colspan="3"><p class="f-12"><?php echo $correo; ?></p></td>
        </tr>
      </table>
	  </div>

  <?php 
  }
  if($secciones->id_seccion_datos_generales == null){ ?>
    <div class="div_datos">
      <p class="center f-18">Personal Data</p>
      <table class="">
          <tr>
            <td class="encabezado">Name:</td>
            <td class="center" colspan="5"><p class="f-12"><?php echo $nombre." ".$pat." ".$mat; ?></p></td>
          </tr>
      </table>
    </div>
    <br><br>
  <?php 
  } ?>

  <!-- Documentos -->
  <?php 
  if($ver_documento){ ?>
    <div class="div_datos">
      <p class="center f-18">Documents</p>
      <table class="">
          <tr>
            <th class="encabezado" width="30%">Document</th>
            <th class="encabezado" width="50%">Number of Document</th>
            <th class="encabezado" width="20%">Date / Institution</th>
          </tr>
          <tr>
            <td class="encabezado center"><p class="f-12"><?php echo $comprobante_estudios; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $lic; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $lic_institucion; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center"><p class="f-12">Identification document(ID)</p></td>
            <td class="center"><p class="f-12"><?php echo $ine_completo; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $ine_institucion; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center"><p class="f-12">Non-criminal history document (or non-criminal background letter)</p></td>
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
            <td class="encabezado center"><p class="f-12">Military service</p></td>
            <td class="center"><p class="f-12"><?php echo $militar; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $militar_fecha; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center"><p class="f-12">Migratory Form</p></td>
            <td class="center"><p class="f-12"><?php echo $forma_migratoria; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $forma_migratoria_fecha; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center"><p class="f-12">Driver license</p></td>
            <td class="center"><p class="f-12"><?php echo $licencia_manejo; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $licencia_manejo_fecha; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center"><p class="f-12">Social Security Number</p></td>
            <td class="center"><p class="f-12"><?php echo $imss; ?></p></td>
            <td class="center"><p class="f-12"><?php echo $imss_institucion; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado center"><p class="f-12">Comments</p></td>
            <td class="center" colspan="2"><p class="f-12"><?php echo $comentario_ver_documento; ?></p></td>
          </tr>
      </table>
    </div>
  <?php 
  } ?>

 
  <!-- Estudios -->
  <?php 
  if($secciones->lleva_estudios == 1 && !empty($ver_mayor_estudio) && !empty($det_estudio)){
    echo '<pagebreak>'; ?>
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
          <td class="center"><p class="f-12"><?php echo $grado_estudios->nombre_ingles; ?></p></td>
          <td class="center"><p class="f-12"><?php echo $ver_tipo_estudio->nombre_ingles; ?></p></td>
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
    </div><br>
  <?php 
  } ?>

   <!-- Referencias Academicas -->
	<?php 
  if($secciones->cantidad_ref_academicas > 0 && $status_bgc > 0){
    if($ref_academicas){ 
      
      $num = 0; ?>
      <div class="div_datos">
        <p class="center f-18">Academic References</p>
        <?php 
        foreach($ref_academicas as $a){
          $num++;  ?>
          <table class="">
            <tr>
              <th class="encabezado center" colspan="3"><p class="f-12">Reference #<?php echo $num; ?> </p></th>
            <tr>
              <td class="encabezado center" width="10%"><p class="f-12">Name:</p></td>
              <td class="center" colspan="2"><p class="f-12"><?php echo $a->nombre; ?></p></td>
            </tr>
            <tr>
              <td class="encabezado center" width="10%"><p class="f-12">Phone:</p></td>
              <td class="center" colspan="2"><p class="f-12"><?php echo $a->telefono; ?></p></td>
            </tr>
            <tr>
                <th class="encabezado"></th>
                <th class="encabezado">Candidate</th>
                <th class="encabezado">Analist</th>
              </tr>
              <tr>
                <td class="encabezado center" width="25%"><p class="f-12">Time to know her/him?</p></td>
                <td class="center"><p class="f-12"><?php echo $a->tiempo; ?></p></td>
                <td class="center"><p class="f-12"><?php echo $a->verificacion_tiempo; ?></p></td>
              </tr>
              <tr>
                <td class="encabezado center" width="25%"><p class="f-12">School or Institution</p></td>
                <td class="center"><p class="f-12"><?php echo $a->institucion; ?></p></td>
                <td class="center"><p class="f-12"><?php echo $a->verificacion_institucion; ?></p></td>
              </tr>
              <tr>
                <td class="encabezado center" width="25%"><p class="f-12">How do you know her/him?</p></td>
                <td class="center"><p class="f-12"><?php echo $a->forma; ?></p></td>
                <td class="center"><p class="f-12"><?php echo $a->verificacion_forma; ?></p></td>
              </tr>
              <tr>
                <td class="encabezado center" width="25%"><p class="f-12">What position had her/him?</p></td>
                <td class="center"><p class="f-12"><?php echo $a->puesto; ?></p></td>
                <td class="center"><p class="f-12"><?php echo $a->verificacion_puesto; ?></p></td>
              </tr>
            </table>
          <br>
          <table class="">
            <tr>
                <td class="encabezado center" width="25%"><p class="f-12">Candidate's qualities</p></td>
                <td class="center"><p class="f-12"><?php echo $a->cualidades; ?></p></td>
              </tr>
              <tr>
                <td class="encabezado center" width="25%"><p class="f-12">Candidate's performance</p></td>
                <td class="center"><p class="f-12"><?php echo $a->desempeno; ?></p></td>
              </tr>
              <tr>
                <td class="encabezado center" width="25%"><p class="f-12">Does the academic reference recommend the candidate?</p></td>
                <td class="center"><p class="f-12"><?php echo $a->recomienda; ?></p></td>
              </tr>
              <tr>
                <td class="encabezado center" width="25%"><p class="f-12">Comments</p></td>
                <td class="center"><p class="f-12"><?php echo $a->comentario; ?></p></td>
              </tr>
          </table>
          <br><br>
        <?php
        }
        ?>
      </div>
    <?php 
    
    if($secciones->cantidad_ref_academicas > 2){
      echo '<pagebreak>';
     }
    }
  }
	?>

  <!-- Global Database searches -->
	<?php 
	if($secciones->id_seccion_global_search != null && !empty($global_searches)){ ?>
		<div class="div_datos">
			<p class="center f-18">Global Data Searches</p>
			<table class="">
        <?php 
        if($secciones->id_seccion_global_search == 4){ ?>
			  	<tr>
			    	<td class="encabezado" width="20%">Global compliance & Sanctions database</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->sanctions; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado" width="20%">Global media searches</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->media_searches; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado" width="20%">Office of the Inspector General</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->oig; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado" width="20%">INTERPOL</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->interpol; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
			  	</tr>
        <?php 
        } 
        if($secciones->id_seccion_global_search == 5){ ?>
			  	<tr>
			    	<td class="encabezado" width="20%">Office of the Inspector General</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->oig; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado" width="20%">General Services Administration Sanction</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->sanctions; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado" width="20%">FACIS Sanction Search</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->facis; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado" width="20%">Bureau of Industry and Security List of Denied Persons</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->bureau; ?></p></td>
			  	</tr>
          <tr>
			    	<td class="encabezado" width="20%">EU Freeze List Maintained by the European Union (financial sanctions)</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->european_financial; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
			  	</tr>
        <?php 
        } 
        if($secciones->id_seccion_global_search == 6){ ?>
			  	<tr>
			    	<td class="encabezado" width="20%">OIG</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->oig; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado" width="20%">SAM</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->sam; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado" width="20%">OFAC</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->ofac; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado" width="20%">INTERPOL</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->interpol; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
			  	</tr>
        <?php 
        } 
        if($secciones->id_seccion_global_search == 7){ ?>
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
        <?php 
        } 
        if($secciones->id_seccion_global_search == 8){ ?>
			  	<tr>
			    	<td class="encabezado" width="20%">USA sanctions</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->usa_sanctions; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado" width="20%">Global sanctions</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->sanctions; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
			  	</tr>
        <?php 
        }  
        if($secciones->id_seccion_global_search == 9){ ?>
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
        }  
        if($secciones->id_seccion_global_search == 21){ ?>
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
			    	<td class="encabezado" width="20%">SDN</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->sdn; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
			  	</tr>
        <?php 
        }
        if($secciones->id_seccion_global_search == 45){ ?>
          <tr>
            <td class="encabezado" width="20%">Sanctions</td>
            <td class="center"><p class="f-12"><?php echo $global_searches->sanctions; ?></p></td>
          </tr>
          <tr>
			    	<td class="encabezado" width="20%">Law enforcement</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->law_enforcement; ?></p></td>
			  	</tr>
          <tr>
			    	<td class="encabezado" width="20%">Regulatory</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->regulatory; ?></p></td>
			  	</tr>
          <tr>
			    	<td class="encabezado" width="20%">Other bodies</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->other_bodies; ?></p></td>
			  	</tr>
          <tr>
            <td class="encabezado" width="20%">Web and media searches</td>
            <td class="center"><p class="f-12"><?php echo $global_searches->media_searches; ?></p></td>
          </tr>
          <tr>
			    	<td class="encabezado" width="20%">OIG</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->oig; ?></p></td>
			  	</tr>
          <tr>
            <td class="encabezado" width="20%">OFAC</td>
            <td class="center"><p class="f-12"><?php echo $global_searches->ofac; ?></p></td>
          </tr>
			  	<tr>
			    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
			  	</tr>
        <?php 
        }
        if($secciones->id_seccion_global_search == 65){ ?>
          <tr>
			    	<td class="encabezado" width="20%">OIG</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->oig; ?></p></td>
			  	</tr>
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
        }
        if($secciones->id_seccion_global_search == 66){ ?>
          <tr>
			    	<td class="encabezado" width="20%">Law enforcement</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->law_enforcement; ?></p></td>
			  	</tr>
          <tr>
			    	<td class="encabezado" width="20%">Regulatory</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->regulatory; ?></p></td>
			  	</tr>
          <tr>
			    	<td class="encabezado" width="20%">OIG</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->oig; ?></p></td>
			  	</tr>
          <tr>
			    	<td class="encabezado" width="20%">OFAC</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->ofac; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado" width="20%">GSA/SAM</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->sam; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
			  	</tr>
        <?php 
        }
        if($secciones->id_seccion_global_search == 67){ ?>
          <tr>
            <td class="encabezado" width="20%">Sanctions</td>
            <td class="center"><p class="f-12"><?php echo $global_searches->sanctions; ?></p></td>
          </tr>
          <tr>
            <td class="encabezado" width="20%">Web and media searches</td>
            <td class="center"><p class="f-12"><?php echo $global_searches->media_searches; ?></p></td>
          </tr>
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
			    	<td class="encabezado" width="20%">OIG</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->oig; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
			  	</tr>
        <?php 
        }
        if($secciones->id_seccion_global_search == 86){ ?>
          <tr>
			    	<td class="encabezado" width="20%">OIG</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->oig; ?></p></td>
			  	</tr>
          <tr>
			    	<td class="encabezado" width="20%">OFAC</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->ofac; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="encabezado" width="20%">GSA/SAM</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->sam; ?></p></td>
			  	</tr>
          <tr>
			    	<td class="encabezado" width="20%">Sanctions</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->sanctions; ?></p></td>
			  	</tr>
          <tr>
			    	<td class="encabezado" width="20%">INTERPOL</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->interpol; ?></p></td>
			  	</tr>
          <tr>
			    	<td class="encabezado" width="20%">Web and media searches</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->media_searches; ?></p></td>
			  	</tr>
          <tr>
			    	<td class="encabezado" width="20%">Motor Vehicle Records (MVR)</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->motor_vehicle_records; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
			  	</tr>
        <?php 
        }
        if($secciones->id_seccion_global_search == 102){ ?>
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
			    	<td class="encabezado" width="20%">Motor Vehicle Records (MVR)</td>
			    	<td class="center"><p class="f-12"><?php echo $global_searches->motor_vehicle_records; ?></p></td>
			  	</tr>
			  	<tr>
			    	<td class="center" colspan="2"><p class="f-12"><?php echo $global_searches->global_comentarios; ?></p></td>
			  	</tr>
        <?php 
        }  ?>
			</table>
		</div><br><br>
	<?php
	}
	?>

  <!-- Separador de hoja -->
  <?php

 

  if($secciones->lleva_empleos == 1 && $secciones->lleva_domicilios == 0){
    echo '<pagebreak>';
  }

  if(($secciones->lleva_empleos == 0 && $secciones->lleva_estudios == 0 && $secciones->lleva_domicilios == 1) || $secciones->lleva_domicilios == 1 ){
    echo '<pagebreak>';
  }
 
  ?>
 
  <!-- Domicilios -->
	<?php 
	if($secciones->lleva_domicilios == 1 && $status_bgc > 0){ ?>
		<div class="div_datos">
			<p class="center f-18">Address History</p>
			<?php 
      $countDomicilios = 1;
      if($secciones->id_seccion_historial_domicilios == 17){
        if($countDomicilios % 4 == 0){
          echo '<pagebreak>';
        }
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
                  <td class="center"><p class="f-12">'.$dom->calle.'</p></td>
                </tr>
                <tr>
                  <td class="encabezado w-17">Ext. Num.:</td>
                  <td class="center"><p class="f-12">'.$dom->exterior.'</p></td>
                </tr>
                <tr>
                  <td class="encabezado w-17">Int. Num.:</td>
                  <td class="center"><p class="f-12">'.$dom->interior.'</p></td>
                </tr>
                <tr>
                  <td class="encabezado w-17">Neighborhood:</td>
                  <td class="center"><p class="f-12">'.$dom->colonia.'</p></td>
                </tr>
                <tr>
                  <td class="encabezado w-17">State:</td>
                  <td class="center"><p class="f-12">'.$dom->estado.'</p></td>
                </tr>
                <tr>
                  <td class="encabezado w-17">City:</td>
                  <td class="center"><p class="f-12">'.$dom->municipio.'</p></td>
                </tr>
                <tr>
                  <td class="encabezado w-17">Zip Code:</td>
                  <td class="center"><p class="f-12">'.$dom->cp.'</p></td>
                </tr>
            </table>
            <br><br>';
            $countDomicilios++;
        }
      }
      if($secciones->id_seccion_historial_domicilios == 18){
        if($countDomicilios % 4 == 0){
          echo '<pagebreak>';
        }
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
                  <td class="encabezado w-17">Country:</td>
                  <td class="center"><p class="f-12">'.$dom->pais.'</p></td>
                </tr>
            </table>
            <br><br>';
            $countDomicilios++; 
        }
      }
      echo '<table class="">
					<tr>
				    	<td class="encabezado">Comments:</td>
				    	<td class="center" colspan="5"><p class="f-12">'.$ver_domicilios->comentario.'</p></td>
				  	</tr>
				</table><br><br>';
			?>
		</div>
  <?php  
	}
	?>

  <!-- Separador de hoja -->
  <?php 
  if($secciones->lleva_domicilios == 1 && $secciones->lleva_empleos == 1){
    echo '<pagebreak>';
  } ?>

  <!-- Referencias laborales -->
	<?php 
  $hayVerificacionesLaborales = $this->candidato_laboral_model->getVerificacionLaboralById($id_candidato);
  if($secciones->lleva_empleos == 1 && isset($fecha_ver_laboral) && !empty($det_empleo) && !empty($hayVerificacionesLaborales)){ 
    if($ref_laboral){ ?>
      <p class="center f-18">Labor References </p>
      <?php 
      $cont = 1;
      foreach($ref_laboral as $ref){
        $ver_laboral = $this->candidato_model->getVerificacionLaboral($cont, $id_candidato);
        if(!empty($ref->fecha_entrada_txt)){
          if(strtotime($ref->fecha_entrada_txt) !== false){
            $entrada_laboral = formatoEspecialFecha($ref->fecha_entrada_txt);
          }
          else{
            $entrada_laboral = $ref->fecha_entrada_txt;
          }
        }
        else{
          $entrada_laboral = 'Not provided';
        }
        if(!empty($ver_laboral->fecha_entrada_txt)){
          if(strtotime($ver_laboral->fecha_entrada_txt) !== false){
            $entrada_verifica = formatoEspecialFecha($ver_laboral->fecha_entrada_txt);
          }
          else{
            $entrada_verifica = $ver_laboral->fecha_entrada_txt;
          }
        }
        else{
          $entrada_verifica = 'Not provided';
        }
        //Salida
        if(!empty($ref->fecha_salida_txt)){
          if(strtotime($ref->fecha_salida_txt) !== false){
            $salida_laboral = formatoEspecialFecha($ref->fecha_salida_txt);
          }
          else{
            $salida_laboral = $ref->fecha_salida_txt;
          }
        }
        else{
          $salida_laboral = 'Not provided';
        }
        if(!empty($ver_laboral->fecha_salida_txt)){
          if(strtotime($ver_laboral->fecha_salida_txt) !== false){
            $salida_verifica = formatoEspecialFecha($ver_laboral->fecha_salida_txt);
          }
          else{
            $salida_verifica = $ver_laboral->fecha_salida_txt;
          }
        }
        else{
          $salida_verifica = 'Not provided';
        }
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
                <td class="center"><p class="f-12"><?php echo $entrada_laboral; ?></p></td>
                <td class="center"><p class="f-12"><?php echo $entrada_verifica; ?></p></td>
              </tr>
              <tr>
                <td class="encabezado center"><p class="f-12">Exit Date</p></td>
                <td class="center"><p class="f-12"><?php echo $salida_laboral; ?></p></td>
                <td class="center"><p class="f-12"><?php echo $salida_verifica; ?></p></td>
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

  <!-- GAPS -->
  <?php 
  if($secciones->lleva_gaps == 1 && $status_bgc > 0 && !empty($gaps)){ ?>
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
    </div>
  <?php 
  } ?>

  <!-- Separador de hoja -->
  <?php 
  if($secciones->cantidad_ref_profesionales > 2 && $status_bgc > 0){
    echo '<pagebreak>';
  } ?>

  <!-- Referencias Profesionales -->
	<?php 
  if($secciones->cantidad_ref_profesionales > 0 && $status_bgc > 0){
    if($ref_profesional){ 
      $num = 0; ?>
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
    <?php 
    }
  }
	?>

  <?php 
  if($secciones->id_seccion_datos_generales == null && $secciones->cantidad_ref_profesionales > 0 && $secciones->cantidad_ref_personales > 0){ 
    echo '<pagebreak>'; 
  } ?>

  <!-- Referencias Personales -->
	<?php 
  if($secciones->cantidad_ref_personales > 0 && $status_bgc > 0){
    if($ref_personales){ 
      $num = 0; ?>
      <div class="div_datos">
        <p class="center f-18">Personal References</p>
        <?php 
        foreach($ref_personales as $row){
          $num++;  ?>
          <table class="">
            <tr>
              <th class="encabezado center" colspan="4"><p class="f-12">Reference #<?php echo $num; ?> </p></th>
            </tr>
            <tr>
              <td class="encabezado center w-30"><p class="f-12">Name:</p></td>
              <td class="center"><p class="f-12"><?php echo $row->nombre; ?></p></td>
              <td class="encabezado center w-30"><p class="f-12">Phone:</p></td>
              <td class="center"><p class="f-12"><?php echo $row->telefono; ?></p></td>
            </tr>
            <tr>
              <td class="encabezado center"><p class="f-12">Time to know her/him?</p></td>
              <td class="center"><p class="f-12"><?php echo $row->tiempo_conocerlo; ?></p></td>
              <td class="encabezado center"><p class="f-12">Why do you know her/him?</p></td>
              <td class="center"><p class="f-12"><?php echo $row->donde_conocerlo; ?></p></td>
            </tr>
            <tr>
              <td class="encabezado center"><p class="f-12">Does she/he know where the candidate works/worked?</p></td>
              <td class="center"><p class="f-12"><?php echo $st = ($row->sabe_trabajo == 1)?'Yes':'No'; ?></p></td>
              <td class="encabezado center"><p class="f-12">Does she/he know where the candidate lives?</p></td>
              <td class="center"><p class="f-12"><?php echo $sv = ($row->sabe_vive == 1)?'Yes':'No'; ?></p></td>
            </tr>
            <tr>
              <td class="encabezado center"><p class="f-12">Comments:</p></td>
              <td class="center" colspan="3"><p class="f-12"><?php echo $row->comentario; ?></p></td>
            </tr>
          </table>
          <br>
        <?php
        }
        ?>
      </div>
    <?php 
    }
  }
	?>

  
  <!-- Separador de hoja -->
  <?php 
  if($secciones->cantidad_ref_personales > 0){
    echo '<pagebreak>';
  } ?>

  <!-- Records Criminales -->
  <?php
  if($secciones->lleva_criminal == 1){ 
    if($fecha_ver_penales != 'NA'){ ?>
      <div class="div_datos">
        <p class="center f-18">Criminal Records Verification</p>
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
    } 
  }?>

  <!-- Credito -->
  <?php 
	if($secciones->lleva_credito == 1 && $status_bgc > 0){ 
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
    }
	} ?>

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
          //$parametros = explode('x', $doping->drogas);
          $descripcion_doping = ($doping->resultado == 0)? "".$examenDoping->nombre." Panel Drug Test Passed":"".$examenDoping->nombre." Panel Drug Test Not Passed";
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
  if($secciones->id_seccion_global_search == null && $secciones->id_seccion_datos_generales != null && $secciones->lleva_criminal == 0 && $secciones->lleva_empleos == 1 && $secciones->lleva_estudios == 1  && $secciones->lleva_domicilios == 1  && $secciones->lleva_gaps == 1){ ?>
	  <pagebreak>
  <?php 
  } ?>

  <!-- Documentos requeridos por la seccion y el tipo de verificacion de documentos -->
  <?php 
  if($docs){
    //$registros['docs_requeridos'] = $this->candidato_model->getDocumentacionSeccion($secciones->id_seccion_verificacion_docs);
    //$banderaCriminal = 0;
    $registros['docs_requeridos'] = $this->candidato_model->getDocumentosCandidatoRequeridos($id_candidato);
    if($registros['docs_requeridos']){
      foreach($registros['docs_requeridos'] as $doc_requerido){
        //Variable para almacenar los documentos y compararlos con los documentos opcionales y no repetirlos al verificar el conjunto 
        $conjunto_docs[] = $doc_requerido->id_tipo_documento;
        $archivos['documentos'] = $this->candidato_model->getDocumentoCandidato($doc_requerido->id_tipo_documento, $id_candidato);
        if($archivos['documentos']){
          foreach($archivos['documentos'] as $doc){
            if(stripos($doc->archivo, '.pdf') === false){ ?>
              <pagebreak>
              <div class="center sin-flotar margen-top">
                <p class="f-20"><?php echo $doc_requerido->nombre_ingles; ?></p>
                <?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'">'; ?>
              </div>
              <?php
              // if($doc->id_tipo_documento == 12){
              //   $banderaCriminal = 1;
              // } ?>
          <?php
            }
          }
        }
      }
    }
    else{
      $conjunto_docs[] = '';
    }
  }
  else{
    $conjunto_docs[] = '';
  }
  ?>

  <!-- Documentos opcionales y que apareceran en caso de estar cargados y registrados en sistema -->

  <!-- Carta laboral -->
  <?php 
	if($docs){
		foreach($docs as $doc){
      if(!in_array(13, $conjunto_docs)){
        if(stripos($doc->archivo, '.pdf') === false){
          if($doc->id_tipo_documento == 13){ ?>
            <pagebreak>
            <div class="center sin-flotar margen-top">
              <p class="f-20">Reference letter </p>
            </div>
            <div class="center">
              <?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'"><br><br>'; ?>
            </div>
          
	<?php 
          }
        }
			}
		}
	}
	?>

  <!-- Historial credito -->
  <?php /*
	if($docs){
		foreach($docs as $doc){
      if(!in_array(28, $conjunto_docs)){
        if($doc->id_tipo_documento == 28){ ?>
          <div class="center sin-flotar margen-top">
            <p class="f-20">Credit history </p>
          </div>
          <div class="center">
            <?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'"><br><br>'; ?>
          </div>
          <pagebreak>
	<?php }
			}
		}
	}*/
	?>

  <!-- Constancia o carta de antecedentes no penales -->
  <?php 
	if($docs){
		foreach($docs as $doc){
      if(!in_array(12, $conjunto_docs)){
        if($doc->id_tipo_documento == 12){
          if(stripos($doc->archivo, '.pdf') === false){ ?>
            <pagebreak>
            <div class="center sin-flotar margen-top">
              <p class="f-20">Non-criminal history document </p>
            </div>
            <div class="center">
              <?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'"><br><br>'; ?>
            </div>
        <?php  
          }
	      }
			}
		}
	}
	?>

  <!-- World check -->
  <?php 
	if($docs){
		foreach($docs as $doc){
      if(!in_array(18, $conjunto_docs)){
        if(stripos($doc->archivo, '.pdf') === false){
          if($doc->id_tipo_documento == 18){ ?>
            <pagebreak>
            <div class="center sin-flotar margen-top">
              <p class="f-20">Global database check </p>
            </div>
            <div class="center">
              <?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'"><br><br>'; ?>
            </div>
	<?php 
          }
        }
			}
		}
	}
	?>

  <!-- OFAC -->
  <?php 
	if($docs){
		foreach($docs as $doc){
      if(!in_array(11, $conjunto_docs)){
        if(stripos($doc->archivo, '.pdf') === false){
          if($doc->id_tipo_documento == 11){ ?>
            <pagebreak>
            <div class="center sin-flotar margen-top">
              <p class="f-20">OFAC </p>
            </div>
            <div class="center">
              <?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'"><br><br>'; ?>
            </div>
	<?php 
          }
        }
			}
		}
	}
	?>

  <!-- OIG -->
  <?php 
	if($docs){
		foreach($docs as $doc){
      if(!in_array(17, $conjunto_docs)){
        if(stripos($doc->archivo, '.pdf') === false){
          if($doc->id_tipo_documento == 17){ ?>
            <pagebreak>
            <div class="center sin-flotar margen-top">
              <p class="f-20">OIG </p>
            </div>
            <div class="center">
              <?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'"><br><br>'; ?>
            </div>
	<?php 
          }
        }
			}
		}
	}
	?>

  <!-- SAM -->
  <?php 
	if($docs){
		foreach($docs as $doc){
      if(!in_array(21, $conjunto_docs)){
        if(stripos($doc->archivo, '.pdf') === false){
          if($doc->id_tipo_documento == 21){ ?>
            <pagebreak>
            <div class="center sin-flotar margen-top">
              <p class="f-20">SAM </p>
            </div>
            <div class="center">
              <?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'"><br><br>'; ?>
            </div>
	<?php 
          }
        }
			}
		}
	}
	?>

  <!-- INTERPOL -->
  <?php 
	if($docs){
		foreach($docs as $doc){
      if(!in_array(29, $conjunto_docs)){
        if(stripos($doc->archivo, '.pdf') === false){
          if($doc->id_tipo_documento == 29){ ?>
            <pagebreak>
            <div class="center sin-flotar margen-top">
              <p class="f-20">INTERPOL </p>
            </div>
            <div class="center">
              <?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'">'; ?>
            </div>
	<?php 
          }
        }
			}
		}
	}
	?>

  <!-- PROHIBITED PARTIES LIST -->
  <?php 
	if($docs){
		foreach($docs as $doc){
      if(!in_array(30, $conjunto_docs)){
        if(stripos($doc->archivo, '.pdf') === false){
          if($doc->id_tipo_documento == 30){ ?>
            <pagebreak>
            <div class="center sin-flotar margen-top">
              <p class="f-20">PROHIBITED PARTIES LIST </p>
            </div>
            <div class="center">
              <?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'"><br><br>'; ?>
            </div>
	<?php 
          }
        }
			}
		}
	}
	?>

  <!-- Licencia conducir -->
  <?php 
	if($docs){
		foreach($docs as $doc){
      if(!in_array(37, $conjunto_docs)){
        if(stripos($doc->archivo, '.pdf') === false){
          if($doc->id_tipo_documento == 37){ ?>
            <pagebreak>
            <div class="center sin-flotar margen-top">
              <p class="f-20">Driver license </p>
            </div>
            <div class="center">
              <?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'"><br><br>'; ?>
            </div>
          
	<?php 
          }
        }
			}
		}
	}
	?>

  <!-- Aviso de privacidad -->
  <?php 
	if($docs){
		foreach($docs as $doc){
      if(!in_array(8, $conjunto_docs)){
        if(stripos($doc->archivo, '.pdf') === false){
          if($doc->id_tipo_documento == 8){ ?>
            <pagebreak>
            <div class="center sin-flotar margen-top">
              <p class="f-20">Non-disclosure agreement </p>
            </div>
            <div class="center">
              <?php echo '<img src="'.base_url().'_docs/'.$doc->archivo.'"><br><br>'; ?>
            </div>
	<?php 
          }
        }
			}
		}
	}
	?>

  <!-- Informacion del o la analista que lo llevo a cabo -->
  <pagebreak>
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