<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Form Candidate | RODI</title>
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<script src="https://kit.fontawesome.com/fdf6fee49b.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<!-- Select Bootstrap -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
	<!-- Sweetalert 2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>img/favicon.jpg" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/candidato.css">
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>

<body>
  <div class="loader" style="display: none;"></div>
  <?php 
  if(isset($_GET['fid'])){
    $token = $_GET['fid'];
    $res = $this->candidato_model->getSeccionesByToken($token);
    if($res != null && $res->status_bgc == 0){ ?>
      <div class="contenedor_form mt-5 mb-5 ">
        <?php
        if($res->id_seccion_datos_generales == 50){ ?>
          <div class="text-center mt-2 mb-3"><img src="<?php echo base_url(); ?>img/encabezado.png" class="img-fluid" alt="RODI"></div>
          <div class="text-center mt-2 mb-3"><h2>Formulario del candidato</h2></div>
          <div class="alert alert-warning">
            <ul>
              <li><h5>Contesta por favor cada sección de este formulario. Hay un botón para guardar para cada sección.</h5></li>
              <li><h5>Si no puedes contestarlo en este momento, puedes regresar más tarde para completarlo.</h5></li>
              <li><h5>Ten en cuenta que es de gran importancia recabar tu información lo antes posible para agilizar este proceso.</h5></li>
              <li><h5>Cuida tu privacidad, no compartas este formulario.</h5></li>
            </ul>
          </div>
          <form id="formGenerales">
            <div class="alert alert-info text-center"><h4>Datos generales</h4><p>Campos con * son obligatorios</p></div>
            <div class="row">
              <div class="col-sm-12 col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4 col-lg-4">
                <label>Nombre(s) *</label>
                <input type="text" class="form-control es_general" name="nombre_general" id="nombre_general" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" value="<?php echo $res->nombre ?>" disabled>
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4 col-lg-4">
                <label>Apellido paterno *</label>
                <input type="text" class="form-control es_general" name="paterno_general" id="paterno_general" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" value="<?php echo $res->paterno ?>" disabled>
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4 col-lg-4">
                <label>Apellido materno</label>
                <input type="text" class="form-control es_general" name="materno_general" id="materno_general" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" value="<?php echo $res->materno ?>" disabled>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4 col-lg-4">
                <label>Fecha de nacimiento *</label>
                <input type="text" class="form-control es_general tipo_fecha" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="dd/mm/yyyy">
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4 col-lg-4">
                <label>Lugar de nacimiento *</label>
                <input type="text" class="form-control es_general" name="lugar" id="lugar">
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4 col-lg-4">
                <label>País donde reside *</label>
                <select class="form-control es_general" id="pais_general" name="pais_general">
                  <?php
                    foreach ($paises as $p) { ?>
                      <option value="<?php echo $p->nombre; ?>"><?php echo $p->nombre; ?></option>
                    <?php
                    } 
                  ?>
                </select>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Puesto *</label>
                <select name="puesto_general" id="puesto_general" class="form-control es_general" disabled>
                  <option value="">Selecciona</option>
                  <?php foreach ($puestos as $pu) { ?>
                    <option value="<?php echo $pu->id; ?>"><?php echo $pu->nombre; ?></option>
                  <?php } ?>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Género: *</label>
                <select name="genero" id="genero" class="form-control es_general">
                  <option value="">Selecciona</option>
                  <option value="Masculino">Masculino</option>
                  <option value="Femenino">Femenino</option>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Calle *</label>
                <input type="text" class="form-control es_general" name="calle" id="calle">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>No. Exterior *</label>
                <input type="text" class="form-control es_general" name="exterior" id="exterior" maxlength="8">
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>No. Interior </label>
                <input type="text" class="form-control es_general" name="interior" id="interior" maxlength="8">
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Entre calles</label>
                <input type="text" class="form-control es_general" name="calles" id="calles">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Colonia *</label>
                <input type="text" class="form-control es_general" name="colonia" id="colonia">
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Estado *</label>
                <select name="estado" id="estado" class="form-control es_general">
                  <option value="">Selecciona</option>
                  <?php foreach ($estados as $e) { ?>
                    <option value="<?php echo $e->id; ?>"><?php echo $e->nombre; ?></option>
                  <?php } ?>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Municipio (o Delegación) *</label>
                <select name="municipio" id="municipio" class="form-control es_general" disabled>
                  <option value="">Selecciona</option>
                </select>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Código postal *</label>
                <input type="text" class="form-control solo_numeros es_general" name="cp" id="cp" maxlength="5">
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Estado civil *</label>
                <select name="civil" id="civil" class="form-control es_general">
                  <option value="">Selecciona</option>
                  <?php foreach ($civiles as $civ) { ?>
                    <option value="<?php echo $civ->nombre; ?>"><?php echo $civ->nombre; ?></option>
                  <?php } ?>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Teléfono celular *</label>
                <input type="text" class="form-control solo_numeros es_general" name="celular_general" id="celular_general" maxlength="10">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Teléfono de casa </label>
                <input type="text" class="form-control solo_numeros es_general" name="tel_casa" id="tel_casa" maxlength="10">
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Grado máximo de estudios: *</label>
                <select name="grado" id="grado" class="form-control es_general">
                  <option value="">Selecciona</option>
                  <?php foreach ($grados as $gr) { ?>
                    <option value="<?php echo $gr->id; ?>"><?php echo $gr->nombre; ?></option>
                  <?php } ?>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Correo electrónico </label>
                <input type="text" class="form-control es_general" name="correo_general" id="correo_general">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Tipo sanguíneo </label>
                <select name="tipo_sanguineo" id="tipo_sanguineo" class="form-control es_general">
                  <option value="">Selecciona</option>
                  <?php foreach ($sanguineos as $s) { ?>
                    <option value="<?php echo $s->nombre; ?>"><?php echo $s->nombre; ?></option>
                  <?php } ?>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Teléfono de emergencia </label>
                <input type="text" class="form-control es_general" name="tel_emergencia" id="tel_emergencia" maxlength="16">
                <br>
              </div>
              <div class="col-sm-12 col-sm-12 col-md-4 col-lg-4 col-lg-4">
                <label>Contacto de emergencia </label>
                <input type="text" class="form-control es_general" name="contacto_emergencia" id="contacto_emergencia">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>NSS/IMSS </label>
                <input type="text" class="form-control es_general" name="nss_general" id="nss_general" maxlength="15">
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>CURP </label>
                <input type="text" class="form-control es_general" name="curp_general" id="curp_general" maxlength="19" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                <br>
              </div>
            </div>
            <div class="row mt-5 mb-5">
              <div class="col-12">
                <button type="button" class="btn btn-info btn-block" onclick="guardarGenerales()"><b>Guardar datos generales</b></button>
              </div>
            </div>
          </form>
        <?php
        }
        if($res->id_estudios == 52){ ?>
          <div class="alert alert-info text-center"><h4>Historial académico</h4><p>Si no cuenta con algún nivel escolar, favor de dejarlo vacío.</p></div>
          <form id="formHistorialEstudios">
            <div class="text-center mt-5 mb-5">
              <h3>Primaria </h3>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Periodo</label>
                <input type="text" class="form-control es_estudio" name="prim_periodo" id="prim_periodo">
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Escuela</label>
                <input type="text" class="form-control es_estudio" name="prim_escuela" id="prim_escuela">
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Ciudad</label>
                <input type="text" class="form-control es_estudio" name="prim_ciudad" id="prim_ciudad">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Certificado</label>
                <select name="prim_certificado" id="prim_certificado" class="form-control es_estudio">
                  <option value="">Selecciona</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Promedio</label>
                <input type="text" class="form-control es_estudio" name="prim_promedio" id="prim_promedio">
                <br>
              </div>
            </div>
            <div class="text-center mt-5 mb-5">
              <h3>Secundaria </h3>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Periodo</label>
                <input type="text" class="form-control es_estudio" name="sec_periodo" id="sec_periodo">
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Escuela</label>
                <input type="text" class="form-control es_estudio" name="sec_escuela" id="sec_escuela">
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Ciudad</label>
                <input type="text" class="form-control es_estudio" name="sec_ciudad" id="sec_ciudad">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Certificado</label>
                <select name="sec_certificado" id="sec_certificado" class="form-control es_estudio">
                  <option value="">Selecciona</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Promedio</label>
                <input type="text" class="form-control es_estudio" name="sec_promedio" id="sec_promedio">
                <br>
              </div>
            </div>
            <div class="text-center mt-5 mb-5">
              <h3>Bachillerato/Preparatoria </h3>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Periodo</label>
                <input type="text" class="form-control es_estudio" name="prep_periodo" id="prep_periodo">
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Escuela</label>
                <input type="text" class="form-control es_estudio" name="prep_escuela" id="prep_escuela">
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Ciudad</label>
                <input type="text" class="form-control es_estudio" name="prep_ciudad" id="prep_ciudad">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Certificado</label>
                <select name="prep_certificado" id="prep_certificado" class="form-control es_estudio">
                  <option value="">Selecciona</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Promedio</label>
                <input type="text" class="form-control es_estudio" name="prep_promedio" id="prep_promedio">
                <br>
              </div>
            </div>
            <div class="text-center mt-5 mb-5">
              <h3>Licenciatura </h3>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Periodo</label>
                <input type="text" class="form-control es_estudio" name="lic_periodo" id="lic_periodo">
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Escuela</label>
                <input type="text" class="form-control es_estudio" name="lic_escuela" id="lic_escuela">
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Ciudad</label>
                <input type="text" class="form-control es_estudio" name="lic_ciudad" id="lic_ciudad">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Certificado</label>
                <select name="lic_certificado" id="lic_certificado" class="form-control es_estudio">
                  <option value="">Selecciona</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Promedio</label>
                <input type="text" class="form-control es_estudio" name="lic_promedio" id="lic_promedio">
                <br>
              </div>
            </div>
            <div class="text-center mt-5 mb-5">
              <h3>Estudios actuales </h3>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Periodo</label>
                <input type="text" class="form-control es_estudio" name="actual_periodo" id="actual_periodo">
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Escuela</label>
                <input type="text" class="form-control es_estudio" name="actual_escuela" id="actual_escuela">
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Ciudad</label>
                <input type="text" class="form-control es_estudio" name="actual_ciudad" id="actual_ciudad">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Certificado</label>
                <select name="actual_certificado" id="actual_certificado" class="form-control es_estudio">
                  <option value="">Selecciona</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label>Promedio</label>
                <input type="text" class="form-control es_estudio" name="actual_promedio" id="actual_promedio">
                <br>
              </div>
            </div>
            <div class="text-center mt-5 mb-5">
              <h3>Información extra </h3>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>Cédula profesional (Número y fecha de emisión) *</label>
                <textarea class="form-control es_estudio" name="cedula" id="cedula" rows="3"></textarea>
                <br>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>Otros estudios *</label>
                <textarea class="form-control es_estudio" name="otro_certificado" id="otro_certificado" rows="3"></textarea>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>Periodos inactivos (fechas y motivos) *</label>
                <textarea class="form-control es_estudio" name="carrera_inactivo" id="carrera_inactivo" rows="3"></textarea>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>Comentarios *</label>
                <textarea class="form-control es_estudio" name="estudios_comentarios" id="estudios_comentarios" rows="3"></textarea>
                <br><br>
              </div>
            </div>
            <div class="row mt-5 mb-5">
              <div class="col-12">
                <button type="button" class="btn btn-info btn-block" onclick="guardarEstudios()"><b>Guardar historial académico</b></button>
              </div>
            </div>
          </form>
        <?php
        }
        if($res->id_seccion_social == 53){  ?>
          <div class="alert alert-info text-center"><h4>Aspectos sociales</h4><p>Si no cuenta con alguno colocar No aplica o N/A</p></div>
          <form id="formSocial">
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Perteneció algún puesto sindical? *</label>
                <select name="sindical" id="sindical" class="form-control campo_social">
                  <option value="">Selecciona</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿A cuál? *</label>
                <input type="text" class="form-control campo_social" name="sindical_nombre" id="sindical_nombre">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Cargo? *</label>
                <input type="text" class="form-control campo_social" name="sindical_cargo" id="sindical_cargo">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Pertenece algún partido político? *</label>
                <select name="partido" id="partido" class="form-control campo_social">
                  <option value="">Selecciona</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿A cuál? *</label>
                <input type="text" class="form-control campo_social" name="partido_nombre" id="partido_nombre">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Cargo? *</label>
                <input type="text" class="form-control campo_social" name="partido_cargo" id="partido_cargo">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Pertenece algún club deportivo? *</label>
                <select name="club" id="club" class="form-control campo_social">
                  <option value="">Selecciona</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Qué deporte practica? *</label>
                <input type="text" class="form-control campo_social" name="deporte" id="deporte">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Qué religión profesa? *</label>
                <input type="text" class="form-control campo_social" name="religion" id="religion">
                <br>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Con qué frecuencia? *</label>
                <input type="text" class="form-control campo_social" name="religion_frecuencia" id="religion_frecuencia">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Ingiere bebidas alcohólicas? *</label>
                <select name="bebidas" id="bebidas" class="form-control campo_social">
                  <option value="">Selecciona</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Con qué frecuencia? *</label>
                <input type="text" class="form-control campo_social" name="bebidas_frecuencia" id="bebidas_frecuencia">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Acostumbra fumar? *</label>
                <select name="fumar" id="fumar" class="form-control campo_social">
                  <option value="">Selecciona</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Con qué frecuencia? *</label>
                <input type="text" class="form-control campo_social" name="fumar_frecuencia" id="fumar_frecuencia">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Ha tenido alguna intervención quirúrgica? *</label>
                <input type="text" class="form-control campo_social" name="cirugia" id="cirugia">
                <br>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Antecedentes de enfermedades en su familia? *</label>
                <input type="text" class="form-control campo_social" name="enfermedades" id="enfermedades">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Cuáles son sus planes a corto plazo? *</label>
                <input type="text" class="form-control campo_social" name="corto_plazo" id="corto_plazo">
                <br>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6">
                <label>¿Cuáles son sus planes a mediano plazo? *</label>
                <input type="text" class="form-control campo_social" name="mediano_plazo" id="mediano_plazo">
                <br><br>
              </div>
            </div>
            <div class="row mt-5 mb-5">
              <div class="col-12">
                <button type="button" class="btn btn-info btn-block" onclick="guardarSociales()"><b>Guardar aspectos sociales</b></button>
              </div>
            </div>
          </form>

        <?php 
        }
        if($res->cantidad_ref_personales > 0 && $res->id_ref_personales == 54){  ?>
          <div class="alert alert-info text-center"><h4>Referencias personales</h4><p>Las referencias no deben ser familiares</p></div>
          <div id="contenedor_ref_personales"></div>
        <?php
        }
        if($res->id_empleos == 55){ ?>
          <div class="alert alert-info text-center"><h4>Historial laboral</h4><p>Registrar su experiencia laboral de los últimos 5 años comenzando desde el trabajo más actual</p></div>
          <?php  
          for ($i = 1; $i <= 4; $i++) {
            $numTrabajo = ($i == 1)? 'actual o más reciente' : ' anterior #'.$i;
            echo '<div class="text-center mt-5 mb-5">
                    <h4 class="box-title"><strong> Trabajo ' . $numTrabajo . ' </strong></h4>
                  </div>';
            echo '<div class="row">
                    <div class="col-12">
                      <form id="data_reflaboral' . $i . '">
                      <input type="hidden" id="idlaboral' . $i . '">
                      <div class="row">
                        <div class="col-md-3">
                          <label>Nombre de la empresa * </label>
                          <input type="text" class="form-control" name="laboral' . $i . '_empresa" id="laboral' . $i . '_empresa">
                          <br>
                        </div>
                        <div class="col-md-3">
                          <label>Área o Departamento * </label>
                          <input type="text" class="form-control" name="laboral' . $i . '_area" id="laboral' . $i . '_area">
                          <br>
                        </div>
                        <div class="col-md-3">
                          <label>Domicilio, calle y número * </label>
                          <input type="text" class="form-control" name="laboral' . $i . '_domicilio" id="laboral' . $i . '_domicilio">
                          <br>
                        </div>
                        <div class="col-md-3">
                          <label>Colonia * </label>
                          <input type="text" class="form-control" name="laboral' . $i . '_colonia" id="laboral' . $i . '_colonia">
                          <br>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
                          <label>Código postal * </label>
                          <input type="text" class="form-control solo_numeros" name="laboral' . $i . '_cp" id="laboral' . $i . '_cp" maxlength="5">
                          <br>
                        </div>
                        <div class="col-md-3">
                          <label>Teléfono * </label>
                          <input type="text" class="form-control solo_numeros" name="laboral' . $i . '_telefono" id="laboral' . $i . '_telefono" maxlength="12">
                          <br>
                        </div>
                        <div class="col-md-3">
                          <label>Tipo de empresa * </label>
                          <input type="text" class="form-control" name="laboral' . $i . '_tipo" id="laboral' . $i . '_tipo">
                          <br>
                        </div>
                        <div class="col-md-3">
                          <label>Puesto desempeñado * </label>
                          <input type="text" class="form-control" name="laboral' . $i . '_puesto" id="laboral' . $i . '_puesto">
                          <br>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
                          <label>Periodo trabajado, mes y año * </label>
                          <input type="text" class="form-control" name="laboral' . $i . '_periodo" id="laboral' . $i . '_periodo">
                          <br>
                        </div>
                        <div class="col-md-3">
                          <label>Nombre del último jefe * </label>
                          <input type="text" class="form-control" name="laboral' . $i . '_jefenombre" id="laboral' . $i . '_jefenombre">
                          <br>
                        </div>
                        <div class="col-md-3">
                          <label>Puesto del último jefe * </label>
                          <input type="text" class="form-control" name="laboral' . $i . '_jefepuesto" id="laboral' . $i . '_jefepuesto">
                          <br>
                        </div>
                        <div class="col-md-3">
                          <label>Sueldo mensual inicial * </label>
                          <input type="text" class="form-control solo_numeros" name="laboral' . $i . '_sueldo1" id="laboral' . $i . '_sueldo1" maxlength="10">
                          <br>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-3">
                          <label>Sueldo mensual final * </label>
                          <input type="text" class="form-control solo_numeros" name="laboral' . $i . '_sueldo2" id="laboral' . $i . '_sueldo2" maxlength="10">
                          <br>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label>¿En qué consistía su trabajo? *</label>
                          <textarea class="form-control" cols="2" name="laboral' . $i . '_actividades" id="laboral' . $i . '_actividades"></textarea>
                          <br>
                        </div>
                        <div class="col-md-6">
                          <label>Causa de separación *</label>
                          <textarea class="form-control" cols="2" name="laboral' . $i . '_razon" id="laboral' . $i . '_razon"></textarea>
                          <br>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-12">
                          <button type="button" class="btn btn-info btn-block" onclick="actualizarLaboral(' . $i . ')"><b>Guardar Trabajo '. $numTrabajo .'</b></button>
                          <br><br>
                        </div>
                      </div>
                      <div id="laboral_msj_error' . $i . '" class="alert alert-danger hidden"></div>
                      </form>
                    </div>
                  </div>';
          }
        } ?>
        <div class="alert alert-warning text-center">
          <h4>Has llegado al final del formulario. Gracias por enviarnos tus respuestas. </h4><br>
          <h5>Si tuviste dudas o ha habido algún problema, comunícate por favor con la(el) analista que te ha contactado. </h5><br>
          <h5>Este formulario se mantendrá abierto hasta completar tu proceso.</h5>
        </div>
      </div>
      
      <?php 
    }
    else{
      echo '<div class="d-flex align-items-center justify-content-center mt-5" style="margin: 0px auto"><h5>Access not allowed</h5></div>';
    }
  } 
  else{
    echo '<div class="d-flex align-items-center justify-content-center mt-5" style="margin: 0px auto"><h5>Access not allowed</h5></div>';
  }
  ?>
    

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
	<!-- Sweetalert 2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
	<!-- Bootstrap Select -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
	<!-- InputMask -->
	<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.js"></script>
	<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.extensions.js"></script>
  <script>
    function generarRefPersonales(id_candidato, cantidad, id_ref_personales){
      let num = 0;
      let salida = '';
      $.ajax({
        url: '<?php echo base_url('Candidato_Ref_Personal/getById'); ?>',
        method: 'POST',
        data: {
          'id': id_candidato
        },
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          if(res != 0){
            var dato = JSON.parse(res);
            for(var i = 0; i < cantidad; i++){
              num++;
              if(dato[i] != null){
                salida += '<form id="d_refpersonal'+num+'"><div class="text-center mt-5 mb-5"><h3 class="text-center">Referencia #'+num+' </h3></div>';
                salida += '<div class="row"><div class="col-sm-12 col-md-6 col-lg-6"><label>Nombre *</label><input type="text" class="form-control esRefPersonal" name="refper'+num+'_nombre" id="refper'+num+'_nombre" value="'+dato[i]['nombre']+'"><br></div><div class="col-sm-12 col-md-6 col-lg-6"><label>Teléfono *</label><input type="text" class="form-control esRefPersonal" name="refper'+num+'_telefono" id="refper'+num+'_telefono" value="'+dato[i]['telefono']+'" maxlength="16"><br></div></div></div><br></form>';

                salida += '<div class="row fila_btn_ref_personal'+num+'"><div class="col-12"><button type="button" class="btn btn-info btn-block" onclick="guardarRefPersonal('+num+','+dato[i]['id']+')"><b>Guardar Referencia Personal #'+num+'</b></button></div></div><br><div id="msj_error_personal'+num+'" class="alert alert-danger hidden"></div><br>';

                salida += '<script>$("#refper'+num+'_recomienda").val("'+dato[i]['recomienda']+'");$("#refper'+num+'_trabajo").val("'+dato[i]['sabe_trabajo']+'");$("#refper'+num+'_vive").val("'+dato[i]['sabe_vive']+'");<\/script>';

                if(id_ref_personales == 31){
                  salida += '<script>$("#refper'+num+'_domicilio").prop("disabled","true");$("#refper'+num+'_domicilio").val("");$("#refper'+num+'_candidato_trabajo").prop("disabled","true");$("#refper'+num+'_candidato_trabajo").val("");$("#refper'+num+'_opinion_persona").prop("disabled","true");$("#refper'+num+'_opinion_persona").val("");$("#refper'+num+'_opinion_trabajador").prop("disabled","true");$("#refper'+num+'_opinion_trabajador").val("");$("#refper'+num+'_candidato_problemas").prop("disabled","true");$("#refper'+num+'_candidato_problemas").val("");<\/script>';
                }
                if(id_ref_personales == 54){
                  salida += '<script>$("#refper'+num+'_lugar").prop("disabled","true");$("#refper'+num+'_lugar").val("");$("#refper'+num+'_trabajo").prop("disabled","true");$("#refper'+num+'_trabajo").val("");$("#refper'+num+'_vive").prop("disabled","true");$("#refper'+num+'_vive").val("");$("#refper'+num+'_domicilio").prop("disabled","true");$("#refper'+num+'_domicilio").val("");$("#refper'+num+'_candidato_trabajo").prop("disabled","true");$("#refper'+num+'_candidato_trabajo").val("");$("#refper'+num+'_opinion_persona").prop("disabled","true");$("#refper'+num+'_opinion_persona").val("");$("#refper'+num+'_opinion_trabajador").prop("disabled","true");$("#refper'+num+'_opinion_trabajador").val("");$("#refper'+num+'_candidato_problemas").prop("disabled","true");$("#refper'+num+'_candidato_problemas").val("");<\/script>';
                }
                if(id_ref_personales == 75){
                  salida += '<script>$("#refper'+num+'_lugar").prop("disabled","true");$("#refper'+num+'_lugar").val("");$("#refper'+num+'_trabajo").prop("disabled","true");$("#refper'+num+'_trabajo").val("");$("#refper'+num+'_vive").prop("disabled","true");$("#refper'+num+'_vive").val("");$("#refper'+num+'_comentario").prop("disabled","true");$("#refper'+num+'_comentario").val("");<\/script>';
                }

              }
              else{
                salida += '<form id="d_refpersonal'+num+'"><div class="text-center mt-5 mb-5"><h3 class="text-center">Referencia #'+num+' </h3></div>';
                salida += '<div class="row"><div class="col-sm-12 col-md-6 col-lg-6"><label>Nombre *</label><input type="text" class="form-control esRefPersonal" name="refper'+num+'_nombre" id="refper'+num+'_nombre" ><br></div><div class="col-sm-12 col-md-6 col-lg-6"><label>Teléfono *</label><input type="text" class="form-control esRefPersonal" name="refper'+num+'_telefono" id="refper'+num+'_telefono" maxlength="16"><br></div></div></div><br></form>';

                salida += '<div class="row fila_btn_ref_personal'+num+'"><div class="col-12"><button type="button" class="btn btn-info btn-block" onclick="guardarRefPersonal('+num+',0)"><b>Guardar Referencia Personal #'+num+'</b></button></div></div><br><div id="msj_error_personal'+num+'" class="alert alert-danger hidden"></div><br>';

                if(id_ref_personales == 31){
                  salida += '<script>$("#refper'+num+'_domicilio").prop("disabled","true");$("#refper'+num+'_domicilio").val("");$("#refper'+num+'_candidato_trabajo").prop("disabled","true");$("#refper'+num+'_candidato_trabajo").val("");$("#refper'+num+'_opinion_persona").prop("disabled","true");$("#refper'+num+'_opinion_persona").val("");$("#refper'+num+'_opinion_trabajador").prop("disabled","true");$("#refper'+num+'_opinion_trabajador").val("");$("#refper'+num+'_candidato_problemas").prop("disabled","true");$("#refper'+num+'_candidato_problemas").val("");<\/script>';
                }
                if(id_ref_personales == 54){
                  salida += '<script>$("#refper'+num+'_lugar").prop("disabled","true");$("#refper'+num+'_lugar").val("");$("#refper'+num+'_trabajo").prop("disabled","true");$("#refper'+num+'_trabajo").val("");$("#refper'+num+'_vive").prop("disabled","true");$("#refper'+num+'_vive").val("");$("#refper'+num+'_domicilio").prop("disabled","true");$("#refper'+num+'_domicilio").val("");$("#refper'+num+'_candidato_trabajo").prop("disabled","true");$("#refper'+num+'_candidato_trabajo").val("");$("#refper'+num+'_opinion_persona").prop("disabled","true");$("#refper'+num+'_opinion_persona").val("");$("#refper'+num+'_opinion_trabajador").prop("disabled","true");$("#refper'+num+'_opinion_trabajador").val("");$("#refper'+num+'_candidato_problemas").prop("disabled","true");$("#refper'+num+'_candidato_problemas").val("");<\/script>';
                }
                if(id_ref_personales == 75){
                  salida += '<script>$("#refper'+num+'_lugar").prop("disabled","true");$("#refper'+num+'_lugar").val("");$("#refper'+num+'_trabajo").prop("disabled","true");$("#refper'+num+'_trabajo").val("");$("#refper'+num+'_vive").prop("disabled","true");$("#refper'+num+'_vive").val("");$("#refper'+num+'_comentario").prop("disabled","true");$("#refper'+num+'_comentario").val("");<\/script>';
                }
              }

              $('#contenedor_ref_personales').html(salida);

            }
          }
          else{
            for(var i = 0; i < cantidad; i++){
              num++;
              salida += '<form id="d_refpersonal'+num+'"><div class="text-center mt-5 mb-5"><h3 class="text-center">Referencia #'+num+' </h3></div>';
                salida += '<div class="row"><div class="col-sm-12 col-md-6 col-lg-6"><label>Nombre *</label><input type="text" class="form-control esRefPersonal" name="refper'+num+'_nombre" id="refper'+num+'_nombre" ><br></div><div class="col-sm-12 col-md-6 col-lg-6"><label>Teléfono *</label><input type="text" class="form-control esRefPersonal" name="refper'+num+'_telefono" id="refper'+num+'_telefono" maxlength="16"><br></div></div></div><br></form>';

              salida += '<div class="row fila_btn_ref_personal'+num+'"><div class="col-12"><button type="button" class="btn btn-info btn-block" onclick="guardarRefPersonal('+num+',0)"><b>Guardar Referencia Personal #'+num+'</b></button></div></div><br><div id="msj_error_personal'+num+'" class="alert alert-danger hidden"></div><br>';

              if(id_ref_personales == 31){
                salida += '<script>$("#refper'+num+'_domicilio").prop("disabled","true");$("#refper'+num+'_domicilio").val("");$("#refper'+num+'_candidato_trabajo").prop("disabled","true");$("#refper'+num+'_candidato_trabajo").val("");$("#refper'+num+'_opinion_persona").prop("disabled","true");$("#refper'+num+'_opinion_persona").val("");$("#refper'+num+'_opinion_trabajador").prop("disabled","true");$("#refper'+num+'_opinion_trabajador").val("");$("#refper'+num+'_candidato_problemas").prop("disabled","true");$("#refper'+num+'_candidato_problemas").val("");<\/script>';
              }
              if(id_ref_personales == 54){
                salida += '<script>$("#refper'+num+'_lugar").prop("disabled","true");$("#refper'+num+'_lugar").val("");$("#refper'+num+'_trabajo").prop("disabled","true");$("#refper'+num+'_trabajo").val("");$("#refper'+num+'_vive").prop("disabled","true");$("#refper'+num+'_vive").val("");$("#refper'+num+'_domicilio").prop("disabled","true");$("#refper'+num+'_domicilio").val("");$("#refper'+num+'_candidato_trabajo").prop("disabled","true");$("#refper'+num+'_candidato_trabajo").val("");$("#refper'+num+'_opinion_persona").prop("disabled","true");$("#refper'+num+'_opinion_persona").val("");$("#refper'+num+'_opinion_trabajador").prop("disabled","true");$("#refper'+num+'_opinion_trabajador").val("");$("#refper'+num+'_candidato_problemas").prop("disabled","true");$("#refper'+num+'_candidato_problemas").val("");<\/script>';
              }
              if(id_ref_personales == 75){
                salida += '<script>$("#refper'+num+'_lugar").prop("disabled","true");$("#refper'+num+'_lugar").val("");$("#refper'+num+'_trabajo").prop("disabled","true");$("#refper'+num+'_trabajo").val("");$("#refper'+num+'_vive").prop("disabled","true");$("#refper'+num+'_vive").val("");$("#refper'+num+'_comentario").prop("disabled","true");$("#refper'+num+'_comentario").val("");<\/script>';
              }

              $('#contenedor_ref_personales').html(salida);

            }
          }
        }
      });
    }
    function getEstudios(id_candidato){
      $.ajax({
        url: '<?php echo base_url('Candidato_Estudio/getHistorialById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          if(res != 0){
            var dato = JSON.parse(res);
            setTimeout(function(){
              $('.loader').fadeOut();
            },200);
            $("#prim_periodo").val(dato.primaria_periodo);
            $("#prim_escuela").val(dato.primaria_escuela);
            $("#prim_ciudad").val(dato.primaria_ciudad);
            $("#prim_certificado").val(dato.primaria_certificado);
            $("#prim_promedio").val(dato.primaria_promedio);
            $("#sec_periodo").val(dato.secundaria_periodo);
            $("#sec_escuela").val(dato.secundaria_escuela);
            $("#sec_ciudad").val(dato.secundaria_ciudad);
            $("#sec_certificado").val(dato.secundaria_certificado);
            $("#sec_promedio").val(dato.secundaria_promedio);
            $("#prep_periodo").val(dato.preparatoria_periodo);
            $("#prep_escuela").val(dato.preparatoria_escuela);
            $("#prep_ciudad").val(dato.preparatoria_ciudad);
            $("#prep_certificado").val(dato.preparatoria_certificado);
            $("#prep_promedio").val(dato.preparatoria_promedio);
            $("#lic_periodo").val(dato.licenciatura_periodo);
            $("#lic_escuela").val(dato.licenciatura_escuela);
            $("#lic_ciudad").val(dato.licenciatura_ciudad);
            $("#lic_certificado").val(dato.licenciatura_certificado);
            $("#lic_promedio").val(dato.licenciatura_promedio);
            $("#actual_periodo").val(dato.actual_periodo);
            $("#actual_escuela").val(dato.actual_escuela);
            $("#actual_ciudad").val(dato.actual_ciudad);
            $("#actual_certificado").val(dato.actual_certificado);
            $("#actual_promedio").val(dato.actual_promedio);
            $("#cedula").val(dato.cedula_profesional);
            $("#otro_certificado").val(dato.otros_certificados);
            $("#estudios_comentarios").val(dato.comentarios);
            $("#carrera_inactivo").val(dato.carrera_inactivo);
            $("#academicosModal").modal('show');
          }
          else{
            $('#formHistorialEstudios')[0].reset();
            setTimeout(function(){
              $('.loader').fadeOut();
            },200);
            $("#academicosModal").modal('show');
          }
        }
      });
    }
    function getSociales(id_candidato){
      $("#religion").prop('disabled',false);
      $("#religion_frecuencia").prop('disabled',false);
      $("#bebidas").prop('disabled', false);
      $("#bebidas_frecuencia").prop('disabled', false);
      $("#fumar").prop('disabled', false);
      $("#fumar_frecuencia").prop('disabled', false);
      $("#cirugia").prop('disabled', false);
      $("#enfermedades").prop('disabled', false);
      $("#corto_plazo").prop('disabled', false);
      $("#mediano_plazo").prop('disabled', false);
      $.ajax({
        url: '<?php echo base_url('Candidato_Social/getById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          if(res != 0){
            var dato = JSON.parse(res);
            setTimeout(function(){
              $('.loader').fadeOut();
            },200);
            $("#sindical").val(dato.sindical);
            $("#sindical_nombre").val(dato.sindical_nombre);
            $("#sindical_cargo").val(dato.sindical_cargo);
            $("#partido").val(dato.partido);
            $("#partido_nombre").val(dato.partido_nombre);
            $("#partido_cargo").val(dato.partido_cargo);
            $("#club").val(dato.club);
            $("#deporte").val(dato.deporte);
            $("#religion").val(dato.religion);
            $("#religion_frecuencia").val(dato.religion_frecuencia);
            $("#bebidas").val(dato.bebidas);
            $("#bebidas_frecuencia").val(dato.bebidas_frecuencia);
            $("#fumar").val(dato.fumar);
            $("#fumar_frecuencia").val(dato.fumar_frecuencia);
            $("#cirugia").val(dato.cirugia);
            $("#enfermedades").val(dato.enfermedades);
            $("#corto_plazo").val(dato.corto_plazo);
            $("#mediano_plazo").val(dato.mediano_plazo);
            $("#socialesModal").modal('show');
          }
          else{
            $('#formSocial')[0].reset();
            setTimeout(function(){
              $('.loader').fadeOut();
            },200);
            $("#socialesModal").modal('show');
          }
        }
      });
    }
    $(document).ready(function(){
      let id_candidato = '<?php echo $res->id_candidato; ?>';
      let id_ref_personales = '<?php echo $res->id_ref_personales; ?>';
      let cantidad_ref_personales = '<?php echo $res->cantidad_ref_personales; ?>';
      generarRefPersonales(id_candidato, cantidad_ref_personales, id_ref_personales);
      getEstudios(id_candidato);
      getSociales(id_candidato);
      $('.tipo_fecha').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      });
      //* Datos generales
      let fecha_nacimiento = '<?php echo $res->fecha_nacimiento; ?>';
      let id_estado = '<?php echo $res->id_estado; ?>';
      let id_municipio = '<?php echo $res->id_municipio; ?>';
      $("#puesto_general").val('<?php echo $res->id_puesto; ?>').trigger('change')
      $('#pais_general').val('<?php echo $res->pais; ?>').trigger('change')
      $('#correo_general').val('<?php echo $res->correo; ?>')
      $('#celular_general').val('<?php echo $res->celular; ?>')
      if (fecha_nacimiento != "") {
        let f_nacimiento = fechaSimpleAFront(fecha_nacimiento);
        $("#fecha_nacimiento").val(f_nacimiento);
      } else {
        $("#fecha_nacimiento").val("");
      }
      $("#nss_general").val('<?php echo $res->nss; ?>');
      $("#curp_general").val('<?php echo $res->curp; ?>');
      $("#civil").val('<?php echo $res->estado_civil; ?>');
      $("#celular_general").val('<?php echo $res->celular; ?>');
      $("#tel_casa").val('<?php echo $res->telefono_casa; ?>');
      $("#pais_general").val('<?php echo $res->pais; ?>');
      $("#calle").val('<?php echo $res->calle; ?>');
      $("#exterior").val('<?php echo $res->exterior; ?>');
      $("#interior").val('<?php echo $res->interior; ?>');
      $("#colonia").val('<?php echo $res->colonia; ?>');
      $("#calles").val('<?php echo $res->entre_calles; ?>');
      $("#estado").val(id_estado).trigger('change');
      if (id_estado != null && id_estado != 0) {
        getMunicipio(id_estado, id_municipio);
      } 
      else {
        $('#municipio').prop('disabled', true);
        $('#municipio').val('');
      }
      $("#cp").val('<?php echo $res->cp; ?>');
      $("#lugar").val('<?php echo $res->lugar_nacimiento; ?>');
      $("#tipo_sanguineo").val('<?php echo $res->tipo_sanguineo; ?>').trigger('change');
      $("#tel_emergencia").val('<?php echo $res->tel_emergencia; ?>');
      $("#contacto_emergencia").val('<?php echo $res->contacto_emergencia; ?>');
      $("#genero").val('<?php echo $res->genero; ?>');
      $("#grado").val('<?php echo $res->id_grado_estudio; ?>');
      $("#correo_general").val('<?php echo $res->correo; ?>');
      $("#estado").change(function() {
        var id_estado = $(this).val();
        if (id_estado != "") {
          $.ajax({
            url: '<?php echo base_url('Funciones/getMunicipios'); ?>',
            method: 'POST',
            data: {
              'id_estado': id_estado
            },
            dataType: "text",
            success: function(res) {
              $('#municipio').prop('disabled', false);
              $('#municipio').html(res);
            }
          });
        } else {
          $('#municipio').prop('disabled', true);
          $('#municipio').append($("<option selected></option>").attr("value", "").text("Selecciona"));
        }
      });
      //* Estudios
      
      
    });
    function guardarGenerales() {
      let id_candidato = '<?php echo $res->id_candidato; ?>';
      var datos = new FormData();
      datos.append('nombre', $("#nombre_general").val());
      datos.append('paterno', $("#paterno_general").val());
      datos.append('materno', $("#materno_general").val());
      datos.append('fecha_nacimiento', $("#fecha_nacimiento").val());
      datos.append('nacionalidad', $("#nacionalidad").val());
      datos.append('lugar', $("#lugar").val());
      datos.append('puesto', $("#puesto_general").val());
      datos.append('genero', $("#genero").val());
      datos.append('pais', $("#pais_general").val());
      datos.append('domicilio', $("#domicilio_general").val());
      datos.append('calle', $("#calle").val());
      datos.append('exterior', $("#exterior").val());
      datos.append('interior', $("#interior").val());
      datos.append('entre_calles', $("#calles").val());
      datos.append('colonia', $("#colonia").val());
      datos.append('estado', $("#estado").val());
      datos.append('municipio', $("#municipio").val());
      datos.append('cp', $("#cp").val());
      datos.append('civil', $("#civil").val());
      datos.append('celular', $("#celular_general").val());
      datos.append('tel_casa', $("#tel_casa").val());
      datos.append('tel_oficina', $("#tel_oficina").val());
      datos.append('tiempo_dom_actual', $("#tiempo_dom_actual").val());
      datos.append('tiempo_traslado', $("#tiempo_traslado").val());
      datos.append('medio_transporte', $("#medio_transporte").val());
      datos.append('grado_estudios', $("#grado").val());
      datos.append('correo', $("#correo_general").val());
      datos.append('tipo_sanguineo', $("#tipo_sanguineo").val());
      datos.append('tel_emergencia', $("#tel_emergencia").val());
      datos.append('contacto_emergencia', $("#contacto_emergencia").val());
      datos.append('religion', $("#religion_general").val());
      datos.append('radica', $("#radicar_general").val());
      datos.append('nss', $("#nss_general").val());
      datos.append('curp', $("#curp_general").val());
      datos.append('identificacion', $("#identificacion_general").val());
      datos.append('afore', $("#afore_general").val());
      datos.append('fecha_entrevista', $("#entrevista_general").val());
      datos.append('reclutador', $("#reclutador").val());
      datos.append('centro_costo', $("#centro_costo_general").val());
      datos.append('id_candidato', id_candidato);
      
      $.ajax({
        url: '<?php echo base_url('Candidato/set'); ?>',
        type: 'POST',
        data: datos,
        contentType: false,
        cache: false,
        processData: false,
        /*beforeSend: function() {
          $('.loader').css("display", "block");
        },*/
        success: function(res) {
          /*setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);*/
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Datos Generales guardados correctamente',
              showConfirmButton: false,
              timer: 2500
            })
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Hubo un problema al enviar el formulario',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Cerrar'
            })
          }
        }
      });
    }
    function guardarEstudios() {
      //if(id_estudios == 52){
        let id_candidato = '<?php echo $res->id_candidato; ?>';
        var datos = new FormData();
        datos.append('prim_periodo', $("#prim_periodo").val());
        datos.append('prim_escuela', $("#prim_escuela").val());
        datos.append('prim_ciudad', $("#prim_ciudad").val());
        datos.append('prim_certificado', $("#prim_certificado").val());
        datos.append('prim_promedio', $("#prim_promedio").val());
        datos.append('sec_periodo', $("#sec_periodo").val());
        datos.append('sec_escuela', $("#sec_escuela").val());
        datos.append('sec_ciudad', $("#sec_ciudad").val());
        datos.append('sec_certificado', $("#sec_certificado").val());
        datos.append('sec_promedio', $("#sec_promedio").val());
        datos.append('prep_periodo', $("#prep_periodo").val());
        datos.append('prep_escuela', $("#prep_escuela").val());
        datos.append('prep_ciudad', $("#prep_ciudad").val());
        datos.append('prep_certificado', $("#prep_certificado").val());
        datos.append('prep_promedio', $("#prep_promedio").val());
        datos.append('lic_periodo', $("#lic_periodo").val());
        datos.append('lic_escuela', $("#lic_escuela").val());
        datos.append('lic_ciudad', $("#lic_ciudad").val());
        datos.append('lic_certificado', $("#lic_certificado").val());
        datos.append('lic_promedio', $("#lic_promedio").val());
        datos.append('actual_periodo', $("#actual_periodo").val());
        datos.append('actual_escuela', $("#actual_escuela").val());
        datos.append('actual_ciudad', $("#actual_ciudad").val());
        datos.append('actual_certificado', $("#actual_certificado").val());
        datos.append('actual_promedio', $("#actual_promedio").val());
        datos.append('cedula', $("#cedula").val());
        datos.append('otro_certificado', $("#otro_certificado").val());
        datos.append('carrera_inactivo', $("#carrera_inactivo").val());
        datos.append('estudios_comentarios', $("#estudios_comentarios").val());
        datos.append('id_candidato', id_candidato);
        
        $.ajax({
          url: '<?php echo base_url('Candidato_Estudio/setHistorial'); ?>',
          type: 'POST',
          data: datos,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            var data = JSON.parse(res);
            if (data.codigo === 1) {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Historial académico guardado correctamente',
                showConfirmButton: false,
                timer: 2500
              })
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Hubo un problema al enviar el formulario',
                html: data.msg,
                width: '50em',
                confirmButtonText: 'Cerrar'
              })
            }
          }
        });
      //}
    }
    function guardarSociales() {
      //if(id_social == 30 || id_social == 53 || id_social == 64){
        let id_candidato = '<?php echo $res->id_candidato; ?>';
        var datos = new FormData();
        datos.append('sindical', $("#sindical").val());
        datos.append('sindical_nombre', $("#sindical_nombre").val());
        datos.append('sindical_cargo', $("#sindical_cargo").val());
        datos.append('partido', $("#partido").val());
        datos.append('partido_nombre', $("#partido_nombre").val());
        datos.append('partido_cargo', $("#partido_cargo").val());
        datos.append('club', $("#club").val());
        datos.append('deporte', $("#deporte").val());
        datos.append('religion', $("#religion").val());
        datos.append('religion_frecuencia', $("#religion_frecuencia").val());
        datos.append('bebidas', $("#bebidas").val());
        datos.append('bebidas_frecuencia', $("#bebidas_frecuencia").val());
        datos.append('fumar', $("#fumar").val());
        datos.append('fumar_frecuencia', $("#fumar_frecuencia").val());
        datos.append('cirugia', $("#cirugia").val());
        datos.append('enfermedades', $("#enfermedades").val());
        datos.append('corto_plazo', $("#corto_plazo").val());
        datos.append('mediano_plazo', $("#mediano_plazo").val());
        datos.append('id_candidato', id_candidato);
        
        $.ajax({
          url: '<?php echo base_url('Candidato_Social/set'); ?>',
          type: 'POST',
          data: datos,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            var data = JSON.parse(res);
            if (data.codigo === 1) {
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Antecedentes sociales actualizados correctamente',
                showConfirmButton: false,
                timer: 2500
              })
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Hubo un problema al enviar el formulario',
                html: data.msg,
                width: '50em',
                confirmButtonText: 'Cerrar'
              })
            }
          }
        });
      //}
    }
    function guardarRefPersonal(num,id){
      let id_candidato = '<?php echo $res->id_candidato; ?>';
      var datos = new FormData();
      datos.append('nombre', $('#refper' + num + '_nombre').val());
      datos.append('tiempo', $('#refper' + num + '_tiempo').val());
      datos.append('lugar', $('#refper' + num + '_lugar').val());
      datos.append('trabaja', $('#refper' + num + '_trabaja').val());
      datos.append('vive', $('#refper' + num + '_vive').val());
      datos.append('telefono', $('#refper' + num + '_telefono').val());
      datos.append('recomienda', $('#refper' + num + '_recomienda').val());
      datos.append('comentario', $('#refper' + num + '_comentario').val());
      datos.append('domicilio', $('#refper' + num + '_domicilio').val());
      datos.append('candidato_trabajo', $('#refper' + num + '_candidato_trabajo').val());
      datos.append('opinion_persona', $('#refper' + num + '_opinion_persona').val());
      datos.append('opinion_trabajador', $('#refper' + num + '_opinion_trabajador').val());
      datos.append('candidato_problemas', $('#refper' + num + '_candidato_problemas').val());
      datos.append('id_candidato', id_candidato);
      datos.append('id', id);

      $.ajax({
        url: '<?php echo base_url('Candidato_Ref_Personal/set'); ?>',
        type: 'POST',
        data: datos,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 0) {
            Swal.fire({
              icon: 'error',
              title: 'Hubo un problema al enviar el formulario',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Cerrar'
            })
          }
          if (data.codigo === 1) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Referencia personal guardada correctamente',
              showConfirmButton: false,
              timer: 2500
            })
          }
          if (data.codigo === 2) {
            $('.fila_btn_ref_personal'+num).empty();
            $('.fila_btn_ref_personal'+num).html('<div class="col-12"><button type="button" class="btn btn-info btn-block" onclick="guardarRefPersonal('+num+','+data.msg+')"><b>Guardar Referencia Personal #'+num+'</b></button></div>')
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Referencia personal guardada correctamente',
              showConfirmButton: false,
              timer: 2500
            })
          }
        }
      });
    }
    function actualizarLaboral(num) {
      let id_candidato = '<?php echo $res->id_candidato; ?>';
      var datos = new FormData();
      datos.append('empresa', $('#laboral' + num + '_empresa').val());
      datos.append('area', $('#laboral' + num + '_area').val());
      datos.append('domicilio', $('#laboral' + num + '_domicilio').val());
      datos.append('colonia', $('#laboral' + num + '_colonia').val());
      datos.append('cp', $('#laboral' + num + '_cp').val());
      datos.append('telefono', $('#laboral' + num + '_telefono').val());
      datos.append('tipo', $('#laboral' + num + '_tipo').val());
      datos.append('puesto', $('#laboral' + num + '_puesto').val());
      datos.append('periodo', $('#laboral' + num + '_periodo').val());
      datos.append('jefenombre', $('#laboral' + num + '_jefenombre').val());
      datos.append('jefepuesto', $('#laboral' + num + '_jefepuesto').val());
      datos.append('sueldo1', $('#laboral' + num + '_sueldo1').val());
      datos.append('sueldo2', $('#laboral' + num + '_sueldo2').val());
      datos.append('actividades', $('#laboral' + num + '_actividades').val());
      datos.append('razon', $('#laboral' + num + '_razon').val());
      datos.append('calidad', $('#laboral' + num + '_calidad').val());
      datos.append('puntualidad', $('#laboral' + num + '_puntualidad').val());
      datos.append('honesto', $('#laboral' + num + '_honesto').val());
      datos.append('responsabilidad', $('#laboral' + num + '_responsabilidad').val());
      datos.append('adaptacion', $('#laboral' + num + '_adaptacion').val());
      datos.append('actitud_jefes', $('#laboral' + num + '_actitud_jefes').val());
      datos.append('actitud_comp', $('#laboral' + num + '_actitud_comp').val());
      datos.append('comentarios', $('#laboral' + num + '_comentarios').val());
      datos.append('id_refper', $('#idlaboral' + num).val());
      datos.append('num', num);
      datos.append('id_candidato', id_candidato);

      $.ajax({
        url: '<?php echo base_url('Cliente_General/guardarAntecedenteLaboral'); ?>',
        type: 'POST',
        data: datos,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 0) {
            Swal.fire({
              icon: 'error',
              title: 'Hubo un problema al enviar el formulario',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Cerrar'
            })
          }
          if (data.codigo === 1) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Laboral actualizada correctamente',
              showConfirmButton: false,
              timer: 2500
            })
          }
          if (data.codigo === 2) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Laboral actualizada correctamente',
              showConfirmButton: false,
              timer: 2500
            })
            $('#idlaboral' + num).val(data.msg);
          }
        }
      });
    }
    function getMunicipio(id_estado, id_municipio) {
      $.ajax({
        url: '<?php echo base_url('Funciones/getMunicipios'); ?>',
        method: 'POST',
        data: {
          'id_estado': id_estado
        },
        dataType: "text",
        success: function(res) {
          $('#municipio').prop('disabled', false);
          $('#municipio').html(res);
          $("#municipio").find('option').attr("selected", false);
          $('#municipio option[value="' + id_municipio + '"]').attr('selected', 'selected');
        }
      });
    }
    function fechaSimpleAFront(fecha) {
			var aux = fecha.split('-');
			var f = aux[2] + '/' + aux[1] + '/' + aux[0];
			return f;
		}
  </script>
</body>
</html>