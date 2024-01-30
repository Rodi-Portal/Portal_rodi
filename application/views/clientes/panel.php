<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<title>E-SOLUTIONS | RODI</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script src="https://kit.fontawesome.com/fdf6fee49b.js"></script>
	<link rel="stylesheet" href="<?php echo base_url() ?>css/subcliente.css">
	<!-- DataTables -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.css" />
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script src="https://kit.fontawesome.com/fdf6fee49b.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<!-- Sweetalert 2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
	<link rel="icon" type="image/jpg" href="<?php echo base_url() ?>img/favicon.jpg" sizes="64x64">

</head>

<body>
	<div class="modal fade" id="newModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">New Candidate</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-info text-center">Candidate's General Data</div>
					<form id="datos">
						<div class="row">
							<div class="col-md-4">
								<label>Name *</label>
								<input type="text" class="form-control registro_obligado" name="nombre_registro" id="nombre_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
								<br>
							</div>
							<div class="col-md-4">
								<label>First lastname *</label>
								<input type="text" class="form-control registro_obligado" name="paterno_registro" id="paterno_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
								<br>
							</div>
							<div class="col-md-4">
								<label>Second lastname </label>
								<input type="text" class="form-control" name="materno_registro" id="materno_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label>Email *</label>
								<input type="email" class="form-control registro_obligado" name="correo_registro" id="correo_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
								<br>
							</div>
							<div class="col-md-4">
								<label>Cellphone number *</label>
								<input type="text" class="form-control" name="celular_registro" id="celular_registro" maxlength="16">
								<br>
							</div>
						</div>
						<div class="alert alert-warning text-center">Choose a previous project or create another one. <br>Notes: <br>
							<ul class="text-left">
								<li>If you select a previous project, this will have a higher priority for your new register.</li>
								<li>The complementary tests are optional.</li>
							</ul> 
						</div>
						<div class="alert alert-info text-center">
							Choose what you want to do
						</div>
						<div class="row">
							<div class="col-12">
								<select name="opcion_registro" id="opcion_registro" class="form-control registro_obligado">
                  <option value="">Select</option>
                  <option value="0">Select a previous project or create a new one</option>
                  <option value="1">Register the candidate with only a Drug Test and/or Medical Test</option>
								</select>
								<br>
							</div>
						</div>
						<div class="alert alert-info text-center div_info_previo">Select a Previous Project</div>
						<div class="row div_previo">
							<div class="col-md-9">
								<label>Previous projects</label>
								<select class="form-control" name="previos" id="previos"></select><br>
							</div>
							<div class="col-md-3">
								<label>Country</label>
								<select class="form-control" name="pais_previo" id="pais_previo" disabled></select><br>
							</div>
						</div>
						<div id="detalles_previo"></div>
						<div class="alert alert-info text-center div_info_project">Select a New Project</div>
						<div class="row div_project">
							<div class="col-md-4">
								<label>Location *</label>
								<select name="region" id="region" class="form-control registro_obligado">
									<option value="">Select</option>
									<option value="Mexico">Mexico</option>
									<option value="International">International</option>
								</select>
								<br>
							</div>
							<div class="col-md-4">
								<label>Country</label>
								<select name="pais_registro" id="pais_registro" class="form-control registro_obligado" disabled>
									<option value="">Select</option>
									<?php
									foreach ($paises_estudio as $pe) { ?>
										<option value="<?php echo $pe->nombre_espanol; ?>"><?php echo $pe->nombre_ingles; ?></option>
									<?php
									} ?>
								</select>
								<br>
							</div>
							<div class="col-md-4">
								<label>Project name *</label>
								<input type="text" class="form-control" name="proyecto_registro" id="proyecto_registro" disabled>
								<br>
							</div>
						</div>
						<div class="alert alert-info text-center div_info_check">
							Required Information for the New Project<br>Note:<br>
							<ul class="text-left">
								<li>The required documents will add automatically depending of the selected options . The extra documents are optional, select them before the complementary tests.</li>
							</ul>
						</div>
						<div class="row div_check">
							<div class="col-md-6">
								<label>Employment history *</label>
								<select name="empleos_registro" id="empleos_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
								<br>
							</div>
							<div class="col-md-6">
								<label>Time required</label>
								<select name="empleos_tiempo_registro" id="empleos_tiempo_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
								<br>
							</div>
						</div>
						<div class="row div_check">
							<div class="col-md-6">
								<label>Criminal check *</label>
								<select name="criminal_registro" id="criminal_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
								<br>
							</div>
							<div class="col-md-6">
								<label>Time required</label>
								<select name="criminal_tiempo_registro" id="criminal_tiempo_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
								<br>
							</div>
						</div>
						<div class="row div_check">
							<div class="col-md-6">
								<label>Address history *</label>
								<select name="domicilios_registro" id="domicilios_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
								<br>
							</div>
							<div class="col-md-6">
								<label>Time required</label>
								<select name="domicilios_tiempo_registro" id="domicilios_tiempo_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
								<br>
							</div>
						</div>
						<div class="row div_check">
							<div class="col-md-6">
								<label>Education check *</label>
								<select name="estudios_registro" id="estudios_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
								<br>
							</div>
							<div class="col-md-6">
								<label>Global data searches *</label>
								<select name="global_registro" id="global_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
								<br>
							</div>
						</div>
						<div class="row div_check">
							<div class="col-md-6">
								<label>Credit check *</label>
								<select name="credito_registro" id="credito_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
								<br>
							</div>
							<div class="col-md-6">
								<label>Time required</label>
								<select name="credito_tiempo_registro" id="credito_tiempo_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
								<br>
							</div>
						</div>
						<div class="row div_check">
							<div class="col-md-6">
								<label>Professional References (quantity)</label>
								<input type="number" class="form-control valor_dinamico" id="ref_profesionales_registro" name="ref_profesionales_registro" value="0" disabled>
								<br>
							</div>
							<div class="col-md-6">
								<label>Personal References (quantity)</label>
								<input type="number" class="form-control valor_dinamico" id="ref_personales_registro" name="ref_personales_registro" value="0" disabled>
								<br>
							</div>
						</div>
						<div class="row div_check">
							<div class="col-md-6">
								<label>Identity check *</label>
								<select name="identidad_registro" id="identidad_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
								<br>
							</div>
							<div class="col-md-6">
								<label>Migratory form (FM, FM2 or FM3) check *</label>
								<select name="migracion_registro" id="migracion_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
							</div>
						</div>
						<div class="row div_check">
							<div class="col-md-6">
								<label>Prohibited parties list check *</label>
								<select name="prohibited_registro" id="prohibited_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
								<br>
							</div>
              <div class="col-md-6">
								<label>Age check *</label>
								<select name="edad_registro" id="edad_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
								<br>
							</div>
						</div>
            <div class="row div_check">
              <div class="col-md-6">
                <label>Academic References (quantity)</label>
                <input type="number" class="form-control valor_dinamico" id="ref_academicas_registro" name="ref_academicas_registro" value="0" disabled>
                <br>
              </div>
              <div class="col-md-6">
                <label>Motor Vehicle Records (only in some  Mexico cities) *</label>
                <select name="mvr_registro" id="mvr_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
            </div>
						<div class="alert alert-danger text-center div_info_extra">Extra documents</div>
						<div class="row div_extra">
							<div class="col-12">
								<label>Select the extra documents *</label>
								<select name="extra_registro" id="extra_registro" class="form-control registro_obligado">
									<option value="">Select</option>
									<option value="37">Driving licence</option>
									<option value="15">Military document</option>
                  <option value="14">Passport</option>
									<option value="10">Professional licence / Professional Accreditation</option>
									<option value="16">Resume</option>
                  <option value="42">Sex offender registry</option>
                  <option value="6">Social Security Number</option>
								</select>
								<br>
							</div>
						</div>
						<div class="row">
							<div id="div_docs_extras" class="col-12 d-flex flex-column mb-3">
							</div>
						</div>
						<div class="alert alert-danger text-center div_info_test">Complementary Tests</div>
						<div class="row div_test">
							<div class="col-md-6">
								<label>Drug test *</label>
								<select name="examen_registro" id="examen_registro" class="form-control registro_obligado">
									<option value="">Select</option>
									<option value="0" selected>N/A</option>
									<?php
									foreach ($paquetes_antidoping as $paq) { ?>
										<option value="<?php echo $paq->id; ?>"><?php echo $paq->nombre.' ('.$paq->conjunto.')'; ?></option>
									<?php
									} ?>
								</select>
								<br>
							</div>
							<div class="col-md-6">
								<label>Medical test *</label>
								<select name="examen_medico" id="examen_medico" class="form-control registro_obligado">
									<option value="0">N/A</option>
									<option value="1">Apply</option>
								</select>
								<br>
							</div>
						</div>
					</form>
					<div id="msj_error" class="alert alert-danger hidden"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-success" onclick="registrar()">Save</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="passModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Access credentials sent to the candidate</h5>
				</div>
				<div class="modal-body">
					<p><b>Email: </b><span id="user"></span></p>
					<p id="respuesta_mail"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="quitarModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="titulo_accion"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p class="" id="texto_confirmacion"></p><br>
					<div class="row" id="div_commentario">
						<div class="col-md-12">
							<label for="motivo">Type the reason *</label>
							<textarea name="motivo" id="motivo" class="form-control" rows="3"></textarea>
							<br>
						</div>
					</div>
					<div class="msj_error">
						<p id="msg_accion"></p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-danger" id="btnGuardar" onclick="ejecutarAccion()">Accept</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="statusModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Candidate Status: <br><span class="nombreCandidato"></span></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="div_status"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="avancesModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Progress messages: <br><span class="nombreCandidato"></span></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div id="div_avances"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="verModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Candidate comments</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p class="" id="comentario_candidato"></p><br>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="documentosModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-xl modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Candidate documents</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p id="lista_documentos"></p><br>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="ofacModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">OFAC and OIG Verifications</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4 offset-md-1">
							<p class="text-center"><b>Candidate name</b></p>
							<p class="text-center" id="ofac_nombrecandidato"></p>
						</div>
						<div class="col-md-4 offset-md-2">
							<p class="text-center" id="fecha_titulo_ofac"><b></b></p>
							<p class="text-center" id="fecha_estatus_ofac"></p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 borde_gris">
							<p id="estatus_ofac"></p><br>
							<span id="res_ofac"></span>
							<br><br>
						</div>
						<div class="col-md-6">
							<p id="estatus_oig"></p><br>
							<span id="res_oig"></span>
							<br><br>
						</div>
					</div>


				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="perfilUsuarioModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit profile</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="alert alert-info text-center">User data</div>
					<form id="datos">
						<div class="row">
							<div class="col-6">
								<label>Name *</label>
								<input type="text" class="form-control" name="usuario_nombre" id="usuario_nombre">
								<br>
							</div>
							<div class="col-6">
								<label>First lastname *</label>
								<input type="text" class="form-control" name="usuario_paterno" id="usuario_paterno">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<label>Email *</label>
								<input type="email" class="form-control" name="usuario_correo" id="usuario_correo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
								<br>
							</div>
							<div class="col-6">
								<label>New password</label>
								<input type="password" class="form-control" name="usuario_nuevo_password" id="usuario_nuevo_password">
								<br>
							</div>
						</div>
						<!--div class="text-center mt-3 mb-3">
							<a href="#" onclick="confirmarRecuperarPassword()">Forgot yout password?</a>
						</div-->
						<div class="alert alert-info text-center">Configurations</div>
						<div class="row">
							<div class="col-6">
								<label>key</label>
								<input type="text" class="form-control" name="usuario_key" id="usuario_key" maxlength="16">
								<br>
							</div>
						</div>
					</form>
					<div id="msj_error" class="alert alert-danger hidden"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-success" onclick="confirmarPassword()">Save</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="confirmarPasswordModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered  modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Confirm password</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h3>Please type your current password:</h3><br>
					<div class="row">
						<div class="col-12">
							<input type="password" class="form-control" id="password_actual" name="password_actual">
						</div>
					</div>
					<div id="msj_error" class="alert alert-danger hidden"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-success" onclick="checkPasswordActual()">Accept</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="aviso2Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<div class="mt-5">
						<div class="alert alert-warning text-center" role="alert">
							<h3>Some improvements have been implemented</h3>
						</div>
						<div class="text-center mt-3">
							<img src="<?php echo base_url() ?>img/cambios_perfil.svg" width="400" height="300">
						</div>
						<div class="text-left">
							<p>We have added a new list item about edit profile: <br><br><img src="<?php echo base_url() ?>img/referencias/5.png" width="700"></p>
							<p>In this new feature you can change your basic data and your credentials to access to this platform.</p>
							<p>Consider the following: </p>
							<ul>
								<li>If you desire to change the current password, type it on new password field. If the new password field is empty, the password will not change.</li>
								<li>You can register a key in the section of configurations. This key will use to decode the BGV reports in the future as a security way</li>
								<li>The security feature mentioned before will be implemented soon. <img src="<?php echo base_url() ?>img/referencias/4.png" width="700"></li><br>
								<li>For to apply the changes you must type your current password. <img src="<?php echo base_url() ?>img/referencias/6.png" width="700"></li>
							</ul>
							<br>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="avisoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<div class="mt-5">
						<div class="alert alert-warning text-center" role="alert">
							<h3>Some improvements have been implemented</h3>
						</div>
						<div class="text-center mt-3">
							<img src="<?php echo base_url() ?>img/cambios_perfil.svg" width="400" height="300">
						</div>
						<div class="text-left">
							<h3>A security improvement has been added to platform. We explain you in the video below:</h3>
							<div class="text-center">
								<video id="video" width="750" height="500" controls>
									<source src="<?php echo base_url() ?>video/ExplicacionClaveClientesIngles.mp4" type="video/mp4">
									Tu navegador no soporta la inclusión de videos.
								</video>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
  <div class="modal fade" id="docsModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Documentación del candidato: <span class="nombreCandidato"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div id="tablaDocs" class="text-center"></div><br><br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 text-center">
              <label>Selecciona el documento</label><br>
              <input type="file" id="documento" class="doc_obligado" name="documento" accept=".jpg, .png, .jpeg, .pdf"><br><br>
              <br>
            </div>
            <div class="col-md-6 text-center">
              <label>Tipo de archivo *</label>
              <select name="tipo_archivo" id="tipo_archivo" class="form-control personal_obligado">
                <option value="">Selecciona</option>
                <?php 
                foreach ($tipos_docs as $t) {
                  if($t->id == 3 || $t->id == 8 || $t->id == 9 || $t->id == 14 || $t->id == 45){ ?>
                    <option value="<?php echo $t->id; ?>"><?php echo $t->nombre; ?></option>
                <?php 
                  }
                } ?>
              </select>
              <br>
            </div>
          </div>
          <div id="msj_error" class="alert alert-danger hidden"></div>
        </div>
        <div class="modal-footer">
          <form method="POST" action="<?php echo base_url('Candidato/downloadDocumentosPanelCliente'); ?>">
            <input type="hidden" id="idCandidatoDocs" name="idCandidatoDocs">
            <button type="submit" class="btn btn-primary">Descargar todos los documentos</button>
          </form>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success" onclick="subirDoc()">Subir</button>
        </div>
      </div>
    </div>
  </div>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu">
			<a class="navbar-brand text-light" href="#">
				<img src="<?php echo base_url() ?>/img/favicon.jpg" width="32" height="32" class="d-inline-block align-top">
				<?php echo $this->session->userdata('nombre') . " " . $this->session->userdata('paterno'); ?>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link text-light font-weight-bold" href="javascript:void(0)" onclick="nuevoRegistro()"><i class="fas fa-plus-circle"></i> New candidate</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-light font-weight-bold" href="javascript:void(0)" onclick="editarPerfil()"><i class="fas fa-user"></i> Edit profile</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-light font-weight-bold" href="<?php echo base_url(); ?>Login/logout">
							<i class="fas fa-sign-out-alt">
							</i> Logout</a>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<div class="loader" style="display: none;"></div>
	<div class="contenedor mt-5 my-5">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h4 class="m-0 font-weight-bold text-primary  text-center">List of Candidates</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<input type="hidden" class="idCandidato">
					<input type="hidden" class="correo">
				</div>
				<div class="table-responsive">
					<table id="tabla" class="table table-bordered" width="100%" cellspacing="0">
					</table>
				</div>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<!-- Sweetalert 2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
	<!-- InputMask -->
	<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.js"></script>
	<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.extensions.js"></script>
  <script>
    function finishSession(){
      let timerInterval;
      setTimeout(() => {
        Swal.fire({
          title: 'Do you want to keep your session?',
          showClass: {
            popup: 'animate__animated animate__fadeInDown'
          },
          hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
          },
          html: 'Your session will end in <strong></strong> seconds<br/><br/>',
          showDenyButton: true,
          confirmButtonText: 'Keep me logged in',
          denyButtonText: 'Logout',
          timer: 30000,
          timerProgressBar: true,
          didOpen: () => {
            //Swal.showLoading(),
            timerInterval = setInterval(() => {
            Swal.getHtmlContainer().querySelector('strong')
              .textContent = (Swal.getTimerLeft() / 1000)
                .toFixed(0)
            }, 100)
          },
          willClose: () => {
            clearInterval(timerInterval)
          },
          allowOutsideClick: false
        }).then((result) => {
          if (result.isConfirmed) {
            finishSession();
          } else if (result.isDenied || result.dismiss === Swal.DismissReason.timer) {
            fetch('<?php echo base_url('Login/logout'); ?>')
              .then(response => {
                return location.reload()
              })
          } 
        })
      }, 7200000);
    }
    finishSession();
  </script>
	<script>
		var id_cliente = '<?php echo $this->session->userdata('idcliente') ?>';
		var extras = [];
		$(document).ready(function() {
			//$('#avisoModal').modal('show')
  		$('.div_info_project, .div_project, .div_info_previo, .div_previo, .div_info_check, .div_check, .div_info_test, .div_test, .div_info_extra, .div_extra').css('display','none');
			$('#fecha_nacimiento_registro').inputmask('mm/dd/yyyy', {
				'placeholder': 'mm/dd/yyyy'
			});
			$('#perfilUsuarioModal').on('hidden.bs.modal', function(e) {
				$("#perfilUsuarioModal #msj_error").css('display', 'none');
			});
			$('#confirmarPasswordModal').on('hidden.bs.modal', function(e) {
				$("#confirmarPasswordModal #msj_error").css('display', 'none');
				$("#confirmarPasswordModal input").val('');
			});
			var url = '<?php echo base_url('Cliente_ESOLUTIONS/getCandidatoPanelCliente'); ?>';
			$('#tabla').DataTable({
				"pageLength": 25,
				//"pagingType": "simple",
				"order": [0, "desc"],
				"stateSave": true,
				"serverSide": false,
				"ajax": url,
				"columns": [{
						title: 'id',
						data: 'id',
						visible: false
					},
					{
						title: 'Name',
						data: 'candidato',
						bSortable: false,
						"width": "20%",
					},
					{
						title: 'Project',
						data: 'proyecto',
						bSortable: false,
						"width": "10%",
						mRender: function(data, type, full) {
							if(full.socioeconomico == 1){
								if(data != null){
									var sub = (full.subproyecto != null)? full.subproyecto:'';
									return data+' '+sub;
								}
								else{
									var sub = (full.subproyecto != null)? full.subproyecto:'-';
									return sub;
								}
							}
							else{
								return full.subproyecto;
							}
						}
					},
					{
						title: 'Register Date',
						data: 'fecha_alta',
						bSortable: false,
						"width": "10%",
						mRender: function(data, type, full) {
							var aux = data.split(" ");
							var f = aux[0].split("-");
							var fecha = f[1] + "/" + f[2] + "/" + f[0];
							var h = aux[1].split(':');
							var hora = h[0] + ":" + h[1];
							var tiempo = fecha + " " + hora;
							return tiempo;
						}
					},
					{
						title: 'Form Date',
						data: 'fecha_contestado',
						bSortable: false,
						"width": "10%",
						mRender: function(data, type, full) {
							if(full.socioeconomico == 1){
								if (full.tipo_formulario != 0) {
									if (data == "" || data == null) {
										return "<i class='fas fa-circle estatus0'></i>Pending";
									} else {
										var f = data.split(' ');
										var h = f[1];
										var aux = h.split(':');
										var hora = aux[0] + ':' + aux[1];
										var aux = f[0].split('-');
										var fecha = aux[1] + "/" + aux[2] + "/" + aux[0];
										var tiempo = fecha + ' ' + hora;
										return "<i class='fas fa-circle estatus1'></i>" + tiempo;
									}
								} else {
									return "<i class='fas fa-circle status_bgc0'></i> N/A";
								}
							}
							else{
								return "<i class='fas fa-circle status_bgc0'></i> N/A";
							}
						}
					},
					{
						title: 'Documents Date',
						data: 'fecha_documentos',
						bSortable: false,
						"width": "10%",
						mRender: function(data, type, full) {
							if(full.socioeconomico == 1){
								if (full.tipo_formulario != 0) {
									if (data == "" || data == null) {
										return "<i class='fas fa-circle estatus0'></i>Pending";
									} else {
										var f = data.split(' ');
										var h = f[1];
										var aux = h.split(':');
										var hora = aux[0] + ':' + aux[1];
										var aux = f[0].split('-');
										var fecha = aux[1] + "/" + aux[2] + "/" + aux[0];
										var tiempo = fecha + ' ' + hora;
										return "<i class='fas fa-circle estatus1'></i>" + tiempo;
									}
								} else {
									return "<i class='fas fa-circle status_bgc0'></i> N/A";
								}
							}
							else{
								return "<i class='fas fa-circle status_bgc0'></i> N/A";
							}
						}
					},
					{
						title: 'Actions',
						data: 'id',
						"width": "8%",
						bSortable: false,
						mRender: function(data, type, full) {
							if(full.socioeconomico == 1){
								if(full.tipo_formulario != 0){
                  var documentos = ' <a href="javascript:void(0)" data-toggle="tooltip" title="Documents of the candidate" id="subirDocs" class="fa-tooltip icono_datatable"><i class="fas fa-folder"></i></a>';
									return '<a href="javascript:void(0)" data-toggle="tooltip" title="Follow up of the candidate" id="msj_avances" class="fa-tooltip icono_datatable"><i class="fas fa-comment-dots"></i></a> <a href="javascript:void(0)" data-toggle="tooltip" title="Status process" id="ver" class="fa-tooltip icono_datatable"><i class="fas fa-eye"></i></a>' + documentos;
								}
								else{
									return '<a href="javascript:void(0)" data-toggle="tooltip" title="Follow up of the candidate" id="msj_avances" class="fa-tooltip icono_datatable"><i class="fas fa-comment-dots"></i></a>';
								}
							}
							else{
								return '<a href="javascript:void(0)" data-toggle="tooltip" title="Follow up of the candidate" id="msj_avances" class="fa-tooltip icono_datatable"><i class="fas fa-comment-dots"></i></a>';
							}
						}
					},
					{
						title: 'Drug test',
						data: 'id',
						bSortable: false,
						"width": "10%",
						mRender: function(data, type, full) {
							if (full.tipo_antidoping == 1) {
								if (full.doping_hecho == 1) {
									if (full.fecha_resultado != null && full.fecha_resultado != "") {
										var color = (full.resultado_doping == 1)? '<i class="fas fa-circle status_bgc2"></i> ' : '<i class="fas fa-circle status_bgc1"></i> ';

										return color + '<div style="display: inline-block;"><form id="pdf' + full.idDoping + '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Download test doping" id="pdfDoping" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' + full.idDoping + '" value="' + full.idDoping + '"></form></div>';
									} else {
										return '<i class="fas fa-circle status_bgc3"></i> Waiting for results';
									}
								} else {
									return '<i class="fas fa-circle status_bgc3"></i> Pending';
								}
							}
							if (full.tipo_antidoping == 0 || full.tipo_antidoping == null) {
								return "N/A";
							}
						}
					},
					{
						title: 'Medic test',
						data: 'id',
						bSortable: false,
						"width": "8%",
						mRender: function(data, type, full) {
							if (full.medico == 1) {
								if (full.archivo_examen_medico != null && full.archivo_examen_medico != "") {
									var carpeta_clinico = '<?php echo base_url(); ?>_clinico/';
									return ' <a href="' + carpeta_clinico + full.archivo_examen_medico + '" id="ver_medico" target="_blank" data-toggle="tooltip" title="Download medic test" class="fa-tooltip icono_datatable"><i class="fas fa-file-medical"></i></a>';
								} else {
									return '<i class="fas fa-circle status_bgc3"></i> Pending';
								}
							} else {
								return "N/A";
							}
						}
					},
					{
						title: 'BGV',
						data: 'id',
						bSortable: false,
						"width": "8%",
						mRender: function(data, type, full) {
							if(full.socioeconomico == 1){
								if (full.status == 0) {
									return "<a href='javascript:void(0)' data-toggle='tooltip' title='Pending form'><i class='fas fa-circle status_bgc0'></i></a> Pending";
								}
								if (full.status == 1 && full.status_bgc == 0) {
									return "<a href='javascript:void(0)' data-toggle='tooltip' title='In process by analyst'><i class='fas fa-circle status_bgc3'></i></a> In process";
								} 
								if (full.status == 2 || (full.status == 1 && full.status_bgc != 0)) {
									switch(full.status_bgc){
										case '1': 
											var icono = '<i class="fas fa-circle status_bgc1"></i> ';
											break;
										case '2': 
											var icono = '<i class="fas fa-circle status_bgc2"></i> ';
											break;
										case '3': 
											var icono = '<i class="fas fa-circle status_bgc3"></i> ';
											break;
									}
									var pdf = '<div style="display: inline-block;"><form id="formBGV'+data+'" action="<?php echo base_url('Cliente_ESOLUTIONS/crearReportePDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final" id="pdfFinal" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idCandidatoPDF" id="idCandidatoPDF'+data+'" value="'+data+'"></form></div>';
									return icono + pdf;
								}
							}
							else{
								//Antidoping
                if (full.tipo_antidoping == 1) {
                  if (full.fecha_resultado != null && full.fecha_resultado != "") {
                    var color = (full.resultado_doping == 1)? '<i class="fas fa-circle status_bgc2"></i> ' : '<i class="fas fa-circle status_bgc1"></i> ';

                    return color + '<div style="display: inline-block;"><form id="pdfDopingBGV' + full.idDoping + '" action="<?php echo base_url('Doping/createReporteDopingPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Download test doping" id="pdfDopingBGV" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' + full.idDoping + '" value="' + full.idDoping + '"></form></div>';
                  } else {
                    return '<i class="fas fa-circle status_bgc3"></i> Waiting for results';
                  }
                }
                else{
								  return "N/A";
                }
							}
						}
					}
				],
				fnDrawCallback: function(oSettings) {
					$('a[data-toggle="tooltip"]').tooltip({
						trigger: "hover"
					});
				},
				rowCallback: function(row, data) {
					$("a#ver", row).bind('click', () => {
						$(".nombreCandidato").text(data.candidato);
						$.ajax({
							url: '<?php echo base_url('Cliente_ESOLUTIONS/verProcesoCandidato'); ?>',
							type: 'post',
							data: {
								'id_candidato': data.id,
								'status_bgc':data.status_bgc,
								'formulario':data.fecha_contestado
							},
							success: function(res) {
								$("#div_status").html(res);
								$("#statusModal").modal("show");
							}
						});
					});
					$("a#ofac", row).bind('click', () => {
						$(".idCandidato").val(data.id);
						$("#idCliente").val(data.id_cliente);
						$("#ofac_nombrecandidato").text(data.nombre + " " + data.paterno + " " + data.materno);
						estatusOFAC();
					});
					$('a[id^=pdfOfac]', row).bind('click', () => {
						var id = data.id;
						$('#ofacpdf' + id).submit();
					});
					$("a#cancelar", row).bind('click', () => {
						$(".idCandidato").val(data.id);
						$("#titulo_accion").text("Cancel candidate");
						$("#texto_confirmacion").html("Are you sure you want to cancel <b>" + data.nombre + " " + data.paterno + " " + data.materno + "</b>?");
						$("#btnGuardar").attr('value', 'cancel');
						$("#div_commentario").css('display', 'block');
						$("#quitarModal").modal("show");
					});
					$("a#eliminar", row).bind('click', () => {
						$(".idCandidato").val(data.id);
						$("#titulo_accion").text("Delete candidate");
						$("#texto_confirmacion").html("Are you sure you want to delete <b>" + data.nombre + " " + data.paterno + " " + data.materno + "</b>?");
						$("#btnGuardar").attr('value', 'delete');
						$("#div_commentario").css('display', 'block');
						$("#quitarModal").modal("show");
					});
					$("a#generar", row).bind('click', () => {
						$(".idCandidato").val(data.id);
						$(".correo").val(data.correo);
						$("#titulo_accion").text("Generate password");
						$("#texto_confirmacion").html("Are you sure you want to generate other password for <b>" + data.nombre + " " + data.paterno + " " + data.materno + "</b>?");
						$("#btnGuardar").attr('value', 'generate');
						$("#div_commentario").css('display', 'none');
						$("#quitarModal").modal("show");
					});
					$('a[id^=pdfDoping]', row).bind('click', () => {
						var id = data.idDoping;
						$('#pdf' + id).submit();
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'If you have Internet, this file will download immediately ',
							showConfirmButton: false,
							timer: 4000
						})
					});
          $('a[id^=pdfDopingBGV]', row).bind('click', () => {
						var id = data.idDoping;
						$('#pdfDopingBGV' + id).submit();
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'If you have Internet, this file will download immediately ',
							showConfirmButton: false,
							timer: 4000
						})
					});
					$('a[id^=pdfFinal]', row).bind('click', () => {
						var id = data.id;
						$('#formBGV'+id).submit();
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'If you have Internet, this file will download immediately ',
							showConfirmButton: false,
							timer: 4000
						})
					});
					$("a#msj_avances", row).bind('click', () => {
						$.ajax({
							url: '<?php echo base_url('Candidato/viewAvances'); ?>',
							type: 'post',
							data: {
								'id_candidato': data.id,
								'id_cliente': data.id_cliente
							},
							success: function(res) {
								$("#div_avances").html(res);

							}
						});
						$("#avancesModal").modal("show");
					});
					$('a#comentario', row).bind('click', () => {
						$.ajax({
							url: '<?php echo base_url('Candidato/viewComentario'); ?>',
							type: 'post',
							data: {
								'id_candidato': data.id
							},
							success: function(res) {
								if (res != 0) {
									$("#comentario_candidato").html(res);
									$("#verModal").modal('show');
								} else {
									$("#comentario_candidato").html("No comments");
									$("#verModal").modal('show');
								}


							},
							error: function(res) {

							}
						});
					});
					$('a#documentos', row).bind('click', () => {
						$.ajax({
							url: '<?php echo base_url('Candidato/viewDocumentos'); ?>',
							type: 'post',
							data: {
								'id_candidato': data.id
							},
							success: function(res) {
								if (res != 0) {
									$("#lista_documentos").empty();
									$("#lista_documentos").html(res);
									$("#documentosModal").modal('show');
								} else {
									$("#lista_documentos").empty();
									$("#lista_documentos").html("<p class='text-center'><b>Documents under review</b></p>");
									$("#documentosModal").modal('show');
								}


							},
							error: function(res) {

							}
						});
					});
          $("a#subirDocs", row).bind('click', () => {
            $(".idCandidato").val(data.id);
            $("#idCandidatoDocs").val(data.id);
            $(".nombreCandidato").text(data.candidato);
            $.ajax({
              url: '<?php echo base_url('Candidato/getDocumentosPanelCliente'); ?>',
              type: 'post',
              data: {
                'id_candidato': data.id,
                'prefijo': data.id + "_" + data.nombre + "" + data.paterno
              },
              success: function(res) {
                $("#tablaDocs").html(res);
              }
            });
            $("#docsModal").modal("show");
          });
				}
			});
			$("#tabla").DataTable().search(" ");
			$("#opcion_registro").change(function(){
				var opcion = $(this).val();
				$('.div_info_project').css('display','block');
				$('.div_project').css('display','flex');
				$('.div_info_test').css('display','block');
				$('.div_test').css('display','flex');
				$("#newModal #msj_error").css('display', 'none');
				if(opcion == 1){
					$('.div_check').css('display','none');
					$('.div_info_check').css('display','none');
					$('.div_info_extra').css('display','none');
					$('.div_extra').css('display','none');
				}
				if(opcion == 0){
					$('.div_previo').css('display','flex');
					$('.div_info_previo').css('display','block');
					$('.div_check').css('display','flex');
					$('.div_info_check').css('display','block');
					$('.div_info_extra').css('display','block');
					$('.div_extra').css('display','flex');
				}
				if(opcion == ''){
					$('.div_previo').css('display','none');
					$('.div_info_previo').css('display','none');
					$('.div_check').css('display','none');
					$('.div_info_check').css('display','none');
					$('.div_info_project').css('display','none');
					$('.div_project').css('display','none');
					$('.div_info_test').css('display','none');
					$('.div_test').css('display','none');
					$('.div_info_extra').css('display','none');
					$('.div_extra').css('display','none');
				}
			});
			$("#region").change(function(){
				var region = $(this).val();
				if(region != ''){
					$.ajax({
						url: '<?php echo base_url('Candidato/getSeccionesRegion'); ?>',
						method: 'POST',
						data: {'region':region},
						success: function(res){
							var secciones = JSON.parse(res);
							$('.valor_dinamico').val('');
							$('.valor_dinamico').empty();
							//$('.valor_dinamico').append($('<option selected></option>').attr('value','').text('Select'));
							$('.valor_dinamico').prop('disabled',false);
							$('#ref_profesionales_registro').val(0);
							$('#ref_personales_registro').val(0);
						  $('#ref_academicas_registro').val(0);
							//Distribuye las secciones en su correspondiente select
							for(var i = 0; i < secciones.length; i++){
								if(secciones[i]['tipo_seccion'] == 'Global Search'){
									$('#global_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
								}
								/*if(secciones[i]['tipo_seccion'] == 'Verificacion Documentos'){
									$('#identidad_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
								}*/
								//if(secciones[i]['tipo_seccion'] == 'Referencias Laborales'){
								if(secciones[i]['id'] == 16){
									$('#empleos_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
								}
								//if(secciones[i]['tipo_seccion'] == 'Estudios'){
								if(secciones[i]['id'] == 3){
									$('#estudios_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
								}
								if(secciones[i]['tipo_seccion'] == 'Domicilios'){
									$('#domicilios_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
								}
								if(secciones[i]['tipo_seccion'] == 'Credito'){
									$('#credito_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
								}
							}
							//Empleos
							$('#empleos_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
							$('#empleos_tiempo_registro').append($('<option></option>').attr('value','3 years').text('3 years'));
							$('#empleos_tiempo_registro').append($('<option></option>').attr('value','5 years').text('5 years'));
							$('#empleos_tiempo_registro').append($('<option></option>').attr('value','7 years').text('7 years'));
							$('#empleos_tiempo_registro').append($('<option></option>').attr('value','10 years').text('10 years'));
							$('#empleos_tiempo_registro').append($('<option></option>').attr('value','All').text('All'));
							$('#empleos_tiempo_registro').append($('<option></option>').attr('value','0').attr("selected","selected").text('N/A'));
							//Criminales
							$('#criminal_registro').append($('<option></option>').attr('value',1).text('Apply'));
							$('#criminal_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
							$('#criminal_tiempo_registro').append($('<option></option>').attr('value','3 years').text('3 years'));
							$('#criminal_tiempo_registro').append($('<option></option>').attr('value','5 years').text('5 years'));
							$('#criminal_tiempo_registro').append($('<option></option>').attr('value','7 years').text('7 years'));
							$('#criminal_tiempo_registro').append($('<option></option>').attr('value','10 years').text('10 years'));
							$('#criminal_tiempo_registro').append($('<option></option>').attr('value','0').attr("selected","selected").text('N/A'));
							//Domicilios
							$('#domicilios_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
							$('#domicilios_tiempo_registro').append($('<option></option>').attr('value','3 years').text('3 years'));
							$('#domicilios_tiempo_registro').append($('<option></option>').attr('value','5 years').text('5 years'));
							$('#domicilios_tiempo_registro').append($('<option></option>').attr('value','7 years').text('7 years'));
							$('#domicilios_tiempo_registro').append($('<option></option>').attr('value','10 years').text('10 years'));
							$('#domicilios_tiempo_registro').append($('<option></option>').attr('value','0').attr("selected","selected").text('N/A'));
							//Credito
							$('#credito_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
							$('#credito_tiempo_registro').append($('<option></option>').attr('value','3 years').text('3 years'));
							$('#credito_tiempo_registro').append($('<option></option>').attr('value','5 years').text('5 years'));
							$('#credito_tiempo_registro').append($('<option></option>').attr('value','7 years').text('7 years'));
							$('#credito_tiempo_registro').append($('<option></option>').attr('value','10 years').text('10 years'));
							$('#credito_tiempo_registro').append($('<option></option>').attr('value','0').attr("selected","selected").text('N/A'));
							//Estudios
							$('#estudios_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
							//Identidad
							$('#identidad_registro').append($('<option></option>').attr('value',1).text('Apply'));
							$('#identidad_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
							//Globales
							$('#global_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
							//Migracion
							$('#migracion_registro').append($('<option></option>').attr('value',1).text('Apply'));
							$('#migracion_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
							//Prohibited parties list
							$('#prohibited_registro').append($('<option></option>').attr('value',1).text('Apply'));
							$('#prohibited_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
              //Age check
              $('#edad_registro').append($('<option></option>').attr('value',1).text('Apply'));
              $('#edad_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
              //Motor vehicle records
              $('#mvr_registro').append($('<option></option>').attr('value',1).text('Apply'));
						  $('#mvr_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));	}
					});
					if(region == 'International'){
						$('#pais_registro').prop('disabled', false);
						$('#pais_registro').val('');
            $('#mvr_registro').val(0);
					}	      	
					else{
						$('#pais_registro').prop('disabled', true);
						$('#pais_registro').val('México');
					}
					$('#proyecto_registro').prop('disabled', false);
				}
				else{
					$('#pais_registro').prop('disabled', true);
					$('#pais_registro').val('');
					$('#proyecto_registro').prop('disabled', true);
					$('#proyecto_registro').val('');
					$('.valor_dinamico').val('');
					$('.valor_dinamico').empty();
					$('.valor_dinamico').prop('disabled',true);
					$('#ref_profesionales_registro').val(0);
					$('#ref_personales_registro').val(0);
          $('#ref_academicas_registro').val(0);
				}
			});
			$('#extra_registro').change(function(){
				var id = $(this).val();
				if(id != ''){
					if(!extras.includes(id)){
						var txt = $( "#extra_registro option:selected" ).text();
						extras.push(id);
						//$("#extra_registro option[value='"+id+"']").remove();
						$('#div_docs_extras').append($('<div id="div_extra'+id+'" class="extra_agregado mb-1 d-flex justify-content-start"><h5 class="mr-5">Document added: <b>'+txt+'</b></h5><button type="button" class="btn btn-danger btn-sm" onclick="eliminarExtra('+id+',\''+txt+'\')">X</button></div>'));
					}
				}
			})
			$("#previos").change(function(){
				var previo = $(this).val();
				if(previo != 0){
					$.ajax({
						url: '<?php echo base_url('Candidato/getDetallesProyectoPrevio'); ?>',
						method: 'POST',
						data: {'id_previo':previo},
						success: function(res)
						{
							var parte = res.split('@@');
							$('#detalles_previo').empty();
							$('#detalles_previo').html(parte[0]);
							$('#pais_previo').prop('disabled', false);
							$('#pais_previo').empty();
							$('#pais_previo').html(parte[1]);
						}
					});
				}
				else{
					$('#detalles_previo').empty();
				}
			});
		});
		function eliminarExtra(id_tipo_documento, txt){
			for( var i = 0; i < extras.length; i++){ 
				if ( extras[i] == id_tipo_documento) { 
					extras.splice(i, 1); 
				}
			}
			$("#div_extra"+id_tipo_documento).remove();
			$('#extra_registro').append($('<option></option>').attr('value',id_tipo_documento).text(txt));
		}
		function nuevoRegistro(){
			var id_cliente = 205;
			$.ajax({
				url: '<?php echo base_url('Candidato/getSeccionesPrevias'); ?>',
				type: 'POST',
				data: {'id_cliente':id_cliente},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					$('#previos').html(res);
				}
			});
			$('#newModal').modal('show');
		}
		function registrar(){
			var id_cliente = 205;
			var correo = $("#correo_registro").val();
			var datos = new FormData();
			datos.append('correo', correo);
			datos.append('nombre', $("#nombre_registro").val());
			datos.append('paterno', $("#paterno_registro").val());
			datos.append('materno', $("#materno_registro").val());
			datos.append('celular', $("#celular_registro").val());
			datos.append('previo', $("#previos").val());
			datos.append('pais_previo', $("#pais_previo").val());
			datos.append('region', $("#region").val());
			datos.append('pais', $("#pais_registro").val());
			datos.append('proyecto', $("#proyecto_registro").val());
			datos.append('empleos', $("#empleos_registro").val());
			datos.append('empleos_tiempo', $("#empleos_tiempo_registro").val());
			datos.append('criminal', $("#criminal_registro").val());
			datos.append('criminal_tiempo', $("#criminal_tiempo_registro").val());
			datos.append('domicilios', $("#domicilios_registro").val());
			datos.append('domicilios_tiempo', $("#domicilios_tiempo_registro").val());
			datos.append('estudios', $("#estudios_registro").val());
			datos.append('identidad', $("#identidad_registro").val());
			datos.append('global', $("#global_registro").val());
			datos.append('ref_profesionales', $("#ref_profesionales_registro").val());
			datos.append('ref_personales', $("#ref_personales_registro").val());
			datos.append('credito', $("#credito_registro").val());
			datos.append('credito_tiempo', $("#credito_tiempo_registro").val());
			datos.append('id_cliente', id_cliente);
			datos.append('examen', $("#examen_registro").val());
			datos.append('medico', $("#examen_medico").val());
			datos.append('opcion', $("#opcion_registro").val());
			datos.append('migracion', $("#migracion_registro").val());
			datos.append('prohibited', $("#prohibited_registro").val());
			datos.append('edad', $("#edad_registro").val());
			datos.append('ref_academicas', $("#ref_academicas_registro").val());
			datos.append('mvr', $("#mvr_registro").val());
			datos.append('usuario', 2);
			for (var i = 0; i < extras.length; i++) {
				datos.append('extras[]', extras[i]);
			}
			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/registrar'); ?>',
				type: 'POST',
				data: datos,
				contentType: false,  
				cache: false,  
				processData:false,
				beforeSend: function() {
					$('.loader').css("display","block");
				},
				success : function(res){ 
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#newModal").modal('hide')
						recargarTable()
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'The candidate has successfully registered',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if(data.codigo === 3){
						$("#newModal").modal('hide');
						recargarTable();
						$("#user").text(correo);
						$("#contrasena").text(data.msg);
						$("#respuesta_mail").text("* El correo no pudo ser enviado, mandar las credenciales del candidato de forma manual.");
						$("#passModal").modal('show');
						Swal.fire({
							position: 'center',
							icon: 'warning',
							title: 'Se ha guardado correctamente pero hubo un problema al enviar el correo',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if(data.codigo === 4){
						$("#newModal").modal('hide');
						recargarTable();
						$("#user").text(correo);
						$("#contrasena").text(data.msg);
						$("#respuesta_mail").text("* Un correo ha sido enviado al candidato con sus nuevas credenciales. Este correo puede demorar algunos minutos.");
						$("#passModal").modal('show');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha guardado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if(data.codigo === 0 || data.codigo === 2){
						$("#newModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});	
		}
    function subirDoc() {
			var data = new FormData();
			var doc = $("#documento")[0].files[0];
			data.append('id_candidato', $(".idCandidato").val());
			data.append('tipo_doc', $("#tipo_archivo").val());
			data.append('documento', doc);
			$.ajax({
				url: "<?php echo base_url('Candidato/cargarDocumentoPanelCliente'); ?>",
				method: "POST",
				data: data,
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
						$("#documento").val("");
						$("#tablaDocs").empty();
						$('#tipo_archivo').val('');
						$("#tablaDocs").html(data.msg);
						$("#docsModal #msj_error").css('display', 'none')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if (data.codigo === 0) {
						$("#docsModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
    function descargarZip() {
			let id_candidato = $(".idCandidato").val();
			$.ajax({
				url: "<?php echo base_url('Candidato/downloadDocumentosPanelCliente'); ?>",
				method: "POST",
				data: {'id_candidato':id_candidato},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
          window.location = res;
				}
			});
		}
		function estatusOFAC() {
			var id_candidato = $(".idCandidato").val();
			var f = new Date();
			var dia = f.getDate();
			var mes = (f.getMonth() + 1);
			var dia = (dia < 10) ? '0' + dia : dia;
			var mes = (mes < 10) ? '0' + mes : mes;
			var h = f.getHours();
			var m = f.getMinutes();
			$.ajax({
				url: '<?php echo base_url('Candidato/checkOfac'); ?>',
				method: 'POST',
				data: {
					'id_candidato': id_candidato
				},
				dataType: "text",
				success: function(res) {
					$("#fecha_estatus_ofac").empty();
					$("#estatus_ofac").empty();
					$("#res_ofac").empty();
					$("#estatus_oig").empty();
					$("#res_oig").empty();
					var datos = res.split('@@');
					if (datos[0] == 0) {
						$("#fecha_titulo_ofac").html("<b>No date</b>");
						$("#estatus_ofac").html("<b>OFAC Status: </b>Not defined yet");
						$("#res_ofac").html("<b>Result:</b> Not defined yet");
						$("#estatus_oig").html("<b>OIG Status: </b>Not defined yet");
						$("#res_oig").html("<b>Result:</b> Not defined yet");
					} else {
						$("#fecha_titulo_ofac").html("<b>Last update</b>");
						$("#fecha_estatus_ofac").text(datos[0]);
						$("#estatus_ofac").html("<b>OFAC Status:</b> " + datos[1]);
						var res_ofac = (datos[2] == 1) ? "Positive" : "Negative";
						$("#res_ofac").html("<b>Result:</b> " + res_ofac);
						$("#estatus_oig").html("<b>OIG Status:</b> " + datos[3]);
						var res_oig = (datos[4] == 1) ? "Positive" : "Negative";
						$("#res_oig").html("<b>Result:</b> " + res_oig);
					}

				},
				error: function(res) {
					//$('#errorModal').modal('show');
				}
			});
			$("#ofacModal").modal("show");
		}
		function ejecutarAccion() {
			var accion = $("#btnGuardar").val();
			var id_candidato = $(".idCandidato").val();
			var id_cliente = '<?php echo $this->session->userdata('id') ?>';
			var correo = $(".correo").val();
			var motivo = $("#motivo").val();
			var usuario = 2;
			if (accion == 'cancel') {
				if (motivo == "") {
					$("#msg_accion").text("The comment is required");
					$("#msg_accion").css('display', 'block');
					setTimeout(function() {
						$('#msg_accion').fadeOut();
					}, 5000);
				} else {
					$.ajax({
						url: '<?php echo base_url('Candidato/cancel'); ?>',
						type: 'post',
						data: {
							'id_candidato': id_candidato,
							'motivo': motivo
						},
						beforeSend: function() {
							$('.loader').css("display", "block");
						},
						success: function(res) {
							setTimeout(function() {
								$('.loader').fadeOut();
							}, 300);
							$("#quitarModal").modal('hide');
							recargarTable();
							$("#texto_msj").text('The candidate has been cancelled succesfully');
							$("#mensaje").css('display', 'block');
							setTimeout(function() {
								$('#mensaje').fadeOut();
							}, 3000);
						},
						error: function(res) {
							$('#errorModal').modal('show');
						}
					});
				}
			}
			if (accion == 'delete') {
				if (motivo == "") {
					$("#msg_accion").text("The reason is required");
					$("#msg_accion").css('display', 'block');
					setTimeout(function() {
						$('#msg_accion').fadeOut();
					}, 5000);
				} else {
					$.ajax({
						url: '<?php echo base_url('Candidato/accionCandidato'); ?>',
						type: 'post',
						data: {
							'id': id_candidato,
							'motivo': motivo,
							'usuario': usuario,
							'id_cliente': id_cliente
						},
						beforeSend: function() {
							$('.loader').css("display", "block");
						},
						success: function(res) {
							setTimeout(function() {
								$('.loader').fadeOut();
							}, 300);
							$("#quitarModal").modal('hide');
							recargarTable();
							$("#texto_msj").text('The candidate has been deleted succesfully');
							$("#mensaje").css('display', 'block');
							setTimeout(function() {
								$('#mensaje').fadeOut();
							}, 3000);
						},
						error: function(res) {
							$('#errorModal').modal('show');
						}
					});
				}
			}
			if (accion == 'generate') {
				$.ajax({
					url: '<?php echo base_url('Candidato/generate'); ?>',
					type: 'post',
					data: {
						'id_candidato': id_candidato,
						'correo': correo
					},
					beforeSend: function() {
						$('.loader').css("display", "block");
					},
					success: function(res) {
						setTimeout(function() {
							$('.loader').fadeOut();
						}, 300);
						$("#quitarModal").modal('hide');
						$("#user").text(correo);
						$("#pass").text(res);
						$("#respuesta_mail").text("* An email has been sent with this credentials to the candidate. This email could take a few minutes to be delivered.");
						$("#passModal").modal('show');
						recargarTable();
						$("#texto_msj").text('The password has been created succesfully');
						$("#mensaje").css('display', 'block');
						setTimeout(function() {
							$('#mensaje').fadeOut();
						}, 3000);
					},
					error: function(res) {
						$('#errorModal').modal('show');
					}
				});
			}
		}
		function editarPerfil(){
			$.ajax({
				url: '<?php echo base_url('Usuario/getData'); ?>',
				method: "POST",
				success: function(res) {
					var dato = JSON.parse(res);
					$('#usuario_nombre').val(dato['nombre'])
					$('#usuario_paterno').val(dato['paterno'])
					$('#usuario_correo').val(dato['correo'])
					$('#usuario_nuevo_password').val('');
					$('#usuario_key').val(dato['clave']);
					$('#perfilUsuarioModal').modal('show');
					$('#recuperacion_correo').val(dato['correo'])
				}
			});
		}
		function confirmarPassword(){
			$('#perfilUsuarioModal').modal('hide');
			$('#confirmarPasswordModal').modal('show');
		}
		function checkPasswordActual(){
			var nombre = $('#usuario_nombre').val();
			var paterno = $('#usuario_paterno').val();
			var correo = $('#usuario_correo').val();
			var nuevo_password = $('#usuario_nuevo_password').val();
			var password = $('#password_actual').val();
			var key = $('#usuario_key').val();
			$.ajax({
				url: '<?php echo base_url('Usuario/checkPasswordActual'); ?>',
				method: "POST",
				data: {'password':password,'nombre':nombre,'paterno':paterno,'correo':correo,'nuevo_password':nuevo_password,'key':key},
				beforeSend: function(){
					$('.loader').css("display","block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var dato = JSON.parse(res);
					if(dato.codigo == 1){
						$('#confirmarPasswordModal').modal('hide');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: dato.msg,
							showConfirmButton: false,
							timer: 3500
						})
						setTimeout(function() {
							window.location.href = "<?php echo base_url(); ?>Login/logout";
						}, 3500);
					}
					else{
						$('#confirmarPasswordModal').modal('hide');
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: dato.msg,
							showConfirmButton: false,
							timer: 3500
						})
					}
				}
			});
		}
		//Verificacion de correo
		function isEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}
		function recargarTable() {
			$("#tabla").DataTable().ajax.reload();
		}
		$('#quitarModal').on('hidden.bs.modal', function(e) {
			$("#msg_accion").css('display', 'none');
			$(this)
				.find("input,textarea")
				.val('')
				.end();
		});
		$('#newModal').on('hidden.bs.modal', function(e) {
			$("#newModal #msj_error").css('display', 'none');
			$("#newModal input, #newModal select").val('');
			$('.valor_dinamico').val(0);
			$('.valor_dinamico, #detalles_previo, #pais_previo').empty();
			$('#pais_registro, #pais_previo').prop('disabled', true);
			//$('#pais_registro').val(-1);
			$('#proyecto_registro').prop('disabled', true);
			$('#proyecto_registro').val('');
			$('.valor_dinamico').prop('disabled',true);
			$('#ref_profesionales_registro').val(0);
			$('#ref_personales_registro').val(0);
      $('#ref_academicas_registro').val(0);
			$('#examen_registro, #examen_medico, #previo').val(0);
			$('#opcion_registro').val('').trigger('change');
			$('#div_docs_extras').empty();
			extras = [];
		});
		var hoy = new Date();
		var dd = hoy.getDate();
		var mm = hoy.getMonth() + 1;
		var yyyy = hoy.getFullYear();
		var hora = hoy.getHours() + ":" + hoy.getMinutes();

		if (dd < 10) {
			dd = '0' + dd;
		}

		if (mm < 10) {
			mm = '0' + mm;
		}
	</script>
</body>

</html>