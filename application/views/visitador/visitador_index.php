<!DOCTYPE html>
<html lang="es">

<head>
	<title>Visitador | RODI</title>
	<link rel="stylesheet" href="<?php echo base_url() ?>css/visitador.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<link rel="icon" type="image/jpg" href="<?php echo base_url() ?>img/favicon.jpg" sizes="64x64">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://kit.fontawesome.com/fdf6fee49b.js"></script>
	<!-- Sweetalert 2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

</head>

<body>
	<div class="modal fade" id="formCandidatoModal" role="dialog" aria-labelledby="largeModal" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Candidato: <span class="formNombre"></span></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="datos">
						<div class="alert alert-warning text-center">
							<p>Los campos con asterico (*) son obligatorios</p>
						</div>
						<div class="alert alert-primary text-center">
							<p>Datos del Grupo Familiar</p>
						</div>
						<div class="alert alert-secondary text-center">
							<p>Persona #1</p>
						</div>
						<div class="row">
							<div class="col-12">
								<label for="p1_nombre">Nombre completo *</label>
								<input type="text" class="form-control es_persona p_obligado" name="p1_nombre" id="p1_nombre">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<label for="p1_parentesco">Parentesco *</label>
								<select name="p1_parentesco" id="p1_parentesco" class="form-control es_persona p_obligado">
									<option value="">Selecciona</option>
									<?php foreach ($parentescos as $par) { ?>
										<option value="<?php echo $par->id; ?>"><?php echo $par->nombre; ?></option>
									<?php } ?>
								</select>
								<br>
							</div>
							<div class="col-6">
								<label for="p1_edad">Edad *</label>
								<input type="text" class="form-control solo_numeros es_persona p_obligado" name="p1_edad" id="p1_edad" maxlength="2">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<label for="p1_escolaridad">Escolaridad *</label>
								<select name="p1_escolaridad" id="p1_escolaridad" class="form-control es_persona p_obligado">
									<option value="">Selecciona</option>
									<?php foreach ($escolaridades as $esc) { ?>
										<option value="<?php echo $esc->id; ?>"><?php echo $esc->nombre; ?></option>
									<?php } ?>
								</select>
								<br>
							</div>
							<div class="col-6">
								<label for="p1_vive">¿Vive con usted? *</label>
								<select name="p1_vive" id="p1_vive" class="form-control es_persona p_obligado">
									<option value="">Selecciona</option>
									<option value="0">No</option>
									<option value="1">Sí</option>
								</select>
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<label for="p1_civil">Estado civil *</label>
								<select name="p1_civil" id="p1_civil" class="form-control es_persona p_obligado">
									<option value="">Selecciona</option>
									<?php foreach ($civiles as $civ) { ?>
										<option value="<?php echo $civ->nombre; ?>"><?php echo $civ->nombre; ?></option>
									<?php } ?>
								</select>
								<br>
							</div>
							<div class="col-6">
								<label for="p1_empresa">Empresa *</label>
								<input type="text" class="form-control es_persona p_obligado" name="p1_empresa" id="p1_empresa">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<label for="p1_puesto">Puesto *</label>
								<input type="text" class="form-control es_persona p_obligado" name="p1_puesto" id="p1_puesto">
								<br>
							</div>
							<div class="col-6">
								<label for="p1_antiguedad">Antigüedad *</label>
								<input type="text" class="form-control es_persona p_obligado" name="p1_antiguedad" id="p1_antiguedad">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<label for="p1_sueldo">Sueldo *</label>
								<input type="text" class="form-control solo_numeros es_persona p_obligado" name="p1_sueldo" id="p1_sueldo" maxlength="8">
								<br>
							</div>
							<div class="col-6">
								<label for="p1_aportacion">Aportación *</label>
								<input type="text" class="form-control solo_numeros es_persona p_obligado" name="p1_aportacion" id="p1_aportacion" maxlength="8">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<label for="p1_muebles">Muebles e inmuebles *</label>
								<input type="text" class="form-control es_persona p_obligado" name="p1_muebles" id="p1_muebles">
								<br>
							</div>
							<div class="col-6">
								<label for="p1_adeudo">Adeudo *</label>
								<select name="p1_adeudo" id="p1_adeudo" class="form-control es_persona p_obligado">
									<option value="">Selecciona</option>
									<option value="0">No</option>
									<option value="1">Sí</option>
								</select>
								<br>
							</div>
						</div>
						<br>
						<div id="div_personas"></div>
						<div class="row">
							<div class="col-md-4 offset-md-4">
								<a href="javascript:void(0)" class="btn btn-primary" onclick="generarPersona()">Agregar otra persona</a><br><br>
							</div>
						</div>
						<div class="alert alert-info text-center">
							<p>Observaciones del visitador</p>
						</div>
						<div class="row">
							<div class="col-12">
								<label>Describa como fue su experiencia en la vista al candidato: <br><b><span class="formNombre"></span></b> *</label>
								<textarea class="form-control p_obligado" name="comentario_visitador_1" id="comentario_visitador_1" rows="5"></textarea>
								<br>
							</div>
						</div>
						<div class="alert alert-warning text-center">
							<p>Recuerde tomar las 2 fotos del candidato en su domicilio por favor</p>
						</div>
					</form>
					<div id="msj_error" class="alert alert-danger hidden"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-success" onclick="guardarVisita()">Guardar</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="formCandidato2Modal" role="dialog" aria-labelledby="largeModal" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Candidato: <span class="formNombre"></span></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="datostipo2">
						<div class="alert alert-warning text-center">
							<p>Los campos con asterico (*) son obligatorios</p>
						</div>
						<div class="alert alert-info text-center">
							<p>Observaciones del visitador</p>
						</div>
						<div class="row">
							<div class="col-12">
								<label>Describa como fue su experiencia en la vista al candidato: <br><b><span class="formNombre"></span></b> *</label>
								<textarea class="form-control p_obligado_2" name="comentario_visitador_2" id="comentario_visitador_2" rows="5"></textarea>
								<br>
							</div>
						</div>
						<div class="alert alert-danger text-center">
							<p>Recuerde tomar 2 fotos para este candidato, 1 de frente que abarque solo su rostro, y la otra fuera de su domicilio por favor</p>
						</div>
					</form>
					<div id="msj_error" class="alert alert-danger hidden"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-success" onclick="guardarVisitaAlterna()">Guardar</button>
				</div>
			</div>
		</div>
	</div>
  <div class="modal fade" id="formCandidato3Modal" role="dialog" aria-labelledby="largeModal" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Candidato: <br><span class="formNombre"></span></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
          <div class="alert alert-warning text-center"><h5>Grupo familiar e integrantes de la vivienda</h5><br><b>Importante: Incluir tanto familiares de origen (padres, hermanos) como integrantes de la misma vivienda del candidato</b></div>
          <form id="formGrupoFamiliar">
            <div class="alert alert-secondary text-center">
              <p>Persona #1</p>
            </div>
            <div class="row">
              <div class="col-12">
                <label for="p1_nombre">Nombre completo *</label>
                <input type="text" class="form-control es_familiar p_obligado" name="fam1_nombre" id="fam1_nombre">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <label for="fam1_parentesco">Parentesco *</label>
                <select name="fam1_parentesco" id="fam1_parentesco" class="form-control es_familiar p_obligado">
                  <option value="">Selecciona</option>
                  <?php foreach ($parentescos as $par) { ?>
                    <option value="<?php echo $par->id; ?>"><?php echo $par->nombre; ?></option>
                  <?php } ?>
                </select>
                <br>
              </div>
              <div class="col-6">
                <label for="fam1_edad">Edad *</label>
                <input type="text" class="form-control solo_numeros es_familiar p_obligado" name="fam1_edad" id="fam1_edad" maxlength="2">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <label for="fam1_escolaridad">Escolaridad *</label>
                <select name="fam1_escolaridad" id="fam1_escolaridad" class="form-control es_familiar p_obligado">
                  <option value="">Selecciona</option>
                  <?php foreach ($escolaridades as $esc) { ?>
                    <option value="<?php echo $esc->id; ?>"><?php echo $esc->nombre; ?></option>
                  <?php } ?>
                </select>
                <br>
              </div>
              <div class="col-6">
                <label for="fam1_vive">¿Vive con usted? *</label>
                <select name="fam1_vive" id="fam1_vive" class="form-control es_familiar p_obligado">
                  <option value="">Selecciona</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <label for="fam1_civil">Estado civil *</label>
                <select name="fam1_civil" id="fam1_civil" class="form-control es_familiar p_obligado">
                  <option value="">Selecciona</option>
                  <?php foreach ($civiles as $civ) { ?>
                    <option value="<?php echo $civ->nombre; ?>"><?php echo $civ->nombre; ?></option>
                  <?php } ?>
                </select>
                <br>
              </div>
              <div class="col-6">
                <label for="fam1_empresa">Empresa *</label>
                <input type="text" class="form-control es_familiar p_obligado" name="fam1_empresa" id="fam1_empresa">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <label for="fam1_puesto">Puesto *</label>
                <input type="text" class="form-control es_familiar p_obligado" name="fam1_puesto" id="fam1_puesto">
                <br>
              </div>
              <div class="col-6">
                <label for="fam1_antiguedad">Antigüedad *</label>
                <input type="text" class="form-control es_familiar p_obligado" name="fam1_antiguedad" id="fam1_antiguedad">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <label for="fam1_sueldo">Sueldo *</label>
                <input type="text" class="form-control solo_numeros es_familiar p_obligado" name="fam1_sueldo" id="fam1_sueldo" maxlength="8">
                <br>
              </div>
              <div class="col-6">
                <label for="fam1_aportacion">Aportación *</label>
                <input type="text" class="form-control solo_numeros es_familiar p_obligado" name="fam1_aportacion" id="fam1_aportacion" maxlength="8">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-6">
                <label for="fam1_muebles">Muebles e inmuebles *</label>
                <input type="text" class="form-control es_familiar p_obligado" name="fam1_muebles" id="fam1_muebles">
                <br>
              </div>
              <div class="col-6">
                <label for="fam1_adeudo">Adeudo *</label>
                <select name="fam1_adeudo" id="fam1_adeudo" class="form-control es_familiar p_obligado">
                  <option value="">Selecciona</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
            </div>
            <br>
            <div id="div_grupo_familiar"></div><br>
            <div id="familiar_msj_error" class="alert alert-danger hidden"></div>
            <div class="row">
              <div class="col-12">
                <button type="button" class="btn btn-primary btn-block" onclick="generarPersona3()">Agregar otro integrante</button><br><br>
                <button type="button" class="btn btn-success btn-block" onclick="guardarGrupoFamiliar()">Guardar todos los integrantes</button>
              </div>
            </div>
          </form>
          <br>
          <div class="alert alert-warning">
            <h5>Recuerda tomas las siguientes fotos al candidato en su visita:</h5><br>
            <ul>
              <li>Foto del rostro o tipo selfie</li>
              <li>Foto del exterior de su domicilio</li>
              <li>Foto del candidato dentro de su domicilio</li>
              <li>Foto a cuerpo completo</li>
            </ul>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Comentarios u observaciones del visitador *</label>
              <textarea class="form-control esRefVecinal" name="observacion_visitador" id="observacion_visitador" rows="3"></textarea>
              <br>
            </div>
          </div>
          <button type="button" class="btn btn-primary btn-block" onclick="terminarVisita()">Terminar la visita</button>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
  <div class="modal fade" id="familiaresModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Datos del grupo familiar del candidato: <br><span class="nombreCandidato"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formFamiliares">
            <div id="rowFamiliares" class="row escrolable"></div>
          </form>
          <div class="row mt-5 mb-3">
            <div class="col-md-5 offset-4"><a href="javascript:void(0)" class="btn btn-success"
                onclick="nuevoFamiliar()"><i class="fas fa-plus-circle"></i> Nuevo Integrante Familiar</a></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="nuevoFamiliarModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Registro de nuevo integrante familiar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-warning text-center">
            <h5>Para los candidatos de este cliente se hace hincapié en registrar a sus padres, esposa(o), hijos y/o hermanos si los hay</h5>
          </div>
          <div id="rowNuevoFamiliar" class="row escrolable"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="mensajeModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="titulo_mensaje"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <label>Comentarios del visitador del candidato *</label>
              <textarea class="form-control" name="comentario_visitador_51" id="comentario_visitador_51" rows="3"></textarea>
              <br>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success" id="btnConfirmar">Terminar</button>
        </div>
      </div>
    </div>
  </div> 
  
  <div class="modal fade" id="formModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="titleForm"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="dataForm">
            <div class="row" id="rowForm"></div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-success" id="btnSubmitForm">Guardar</button>
        </div>
      </div>
    </div>
  </div>

	<nav id="menu" class="navbar navbar-expand-lg navbar-light">
		<a class="navbar-brand text-white" href="#">
			<img src="<?php echo base_url() ?>/img/favicon.jpg" width="32" height="32" class="d-inline-block align-top">
			<?php echo strtoupper($this->session->userdata('nombre') . ' ' . $this->session->userdata('paterno')); ?>
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item active">
					<a class="nav-link text-white" href="<?php echo base_url(); ?>Login/logout"><i class="fas fa-sign-out-alt"></i><b> Cerrar sesión</b></a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="loader" style="display: none;"></div>
	<input type="hidden" id="idCandidato" name="idCandidato">
	<input type="hidden" class="correo">
  <div class="contenedor mt-5 my-5">
    <select name="buscador" id="buscador" class="form-control selectpicker" data-live-search="true">
      <option value="">Selecciona o teclea al candidato</option>
      <?php
      if ($visitas) {
        foreach ($visitas as $c) { ?>
          <option value="<?php echo $c->id; ?>"><?php echo '#'.$c->id.' '.$c->candidato.' ('.$c->cliente.')'; ?></option>
        <?php 
        }
      } ?>
    </select>
  </div>
	
  <div class="contenedor" id="tarjetaCandidato"></div>

  <input type="hidden" id="nombreCandidato">

	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
	<!-- Sweetalert 2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
	<!-- InputMask -->
	<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.js"></script>
	<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.extensions.js"></script>

  <!-- Funciones para guardar secciones -->
  <script src="<?php echo base_url(); ?>js/analista/request.js"></script>

  
  <script src="<?php echo base_url(); ?>js/dist/cryptojs-aes.min.js"></script>
  <script src="<?php echo base_url(); ?>js/dist/cryptojs-aes-format.js"></script>

	<script>
    var parentescos_php = '<?php foreach($parentescos as $p){ echo '<option value="'.$p->id.'">'.$p->nombre.'</option>';} ?>';
    var civiles_php = '<?php foreach($civiles as $c){ echo '<option value="'.$c->nombre.'">'.$c->nombre.'</option>';} ?>';
    var escolaridades_php = '<?php foreach($escolaridades as $e){ echo '<option value="'.$e->id.'">'.$e->nombre.'</option>';} ?>';
		$(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();
			$('.tipo_fecha').inputmask('dd/mm/yyyy', {
				'placeholder': 'dd/mm/yyyy'
			});
      $('#refVecinalesModal').on('hidden.bs.modal', function(e) {
        $("#refVecinalesModal input[id^='msj_error']").css('display', 'none');
        $("#refVecinalesModal input").val('');
      });
      $('#familiaresModal').on('hidden.bs.modal', function(e) {
        $("#rowFamiliares").empty();
      })
      $('#nuevoFamiliarModal').on('hidden.bs.modal', function(e) {
        $('#rowNuevoFamiliar').empty();
      })
      $('#formModal').on('hidden.bs.modal', function(e) {
        $("#rowForm").empty();
        $('#btnOpenFiles').remove()
        $('#formModal .modal-body').removeClass('escrolable');
        $('#formModal #btnSubmitForm').prop('disabled',false);
      });
			var msj = localStorage.getItem("success");
			if (msj == 1) {
				Swal.fire({
					position: 'center',
					icon: 'success',
					title: 'Se ha guardado correctamente',
					showConfirmButton: false,
					timer: 2500
				})
				localStorage.removeItem("success");
			}
      var setAccion = localStorage.getItem("familiarNuevo");
			if (setAccion == 1) {
        openFamiliares(localStorage.getItem("id_candidato"), localStorage.getItem("candidato"))
				Swal.fire({
					position: 'center',
					icon: 'success',
					title: 'Integrante familiar registrado correctamente',
					showConfirmButton: false,
					timer: 2500
				})
				localStorage.removeItem("familiarNuevo");
				localStorage.removeItem("id_candidato");
				localStorage.removeItem("candidato");
			}
      setAccion = localStorage.getItem("finanzasGuardadas");
			if (setAccion == 1) {
				Swal.fire({
					position: 'center',
					icon: 'success',
					title: 'Datos financieros guardados correctamente',
					showConfirmButton: false,
					timer: 2500
				})
				localStorage.removeItem("finanzasGuardadas");
			}
      setAccion = localStorage.getItem("finalizarVisita");
			if (setAccion == 1) {
				Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Visita finalizada correctamente',
          showConfirmButton: false,
          timer: 2500
        })
				localStorage.removeItem("finalizarVisita");
			}
			$(".solo_numeros").on("input", function() {
				var valor = $(this).val();
				$(this).val(valor.replace(/[^0-9]/g, ''));
			});
			$("#formCandidatoModal").on("hidden.bs.modal", function() {
				$("#formCandidatoModal input, #formCandidatoModal select, #formCandidatoModal textarea").val('');
				$("#formCandidatoModal #msj_error").css('display', 'none');
			})
			$("#formCandidato2Modal").on("hidden.bs.modal", function() {
				$("#formCandidato2Modal input, #formCandidato2Modal select, #formCandidato2Modal textarea").val('');
				$("#formCandidato2Modal #msj_error").css('display', 'none');
			})
      //* Opciones en modal sociales2Modal 
      $('#opcion_familiar_penal').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_fam_penal').val('')
          $('.es_fam_penal').prop('disabled',false);
        }
        else{
          $('.es_fam_penal').val('No aplica')
          $('.es_fam_penal').prop('disabled',true);
        }
      });
      $('#opcion_persona_empresa').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_pers_emp').val('')
          $('.es_pers_emp').prop('disabled',false);
        }
        else{
          $('.es_pers_emp').val('No aplica')
          $('.es_pers_emp').prop('disabled',true);
        }
      });
      $('#opcion_familiar_policia').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_fam_policia').val('')
          $('.es_fam_policia').prop('disabled',false);
        }
        else{
          $('.es_fam_policia').val('No aplica')
          $('.es_fam_policia').prop('disabled',true);
        }
      });
      $('#opcion_sindicato').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_sindicato').val('')
          $('.es_sindicato').prop('disabled',false);
        }
        else{
          $('.es_sindicato').val('No aplica')
          $('.es_sindicato').prop('disabled',true);
        }
      });
      $('#opcion_otro_trabajo').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_otro_trabajo').val('')
          $('.es_otro_trabajo').prop('disabled',false);
        }
        else{
          $('.es_otro_trabajo').val('No aplica')
          $('.es_otro_trabajo').prop('disabled',true);
        }
      });
      //* Opciones en modal saludModal 
      $('#opcion_deporte').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_deporte').val('')
          $('.es_deporte').prop('disabled',false);
        }
        else{
          $('.es_deporte').val('No aplica')
          $('.es_deporte').prop('disabled',true);
        }
      });
      //* Opciones en modal finanzasModal
      $('#opcion_credito_bancos').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_credito_bancos').val('')
          $('.es_credito_bancos').prop('disabled',false);
        }
        else{
          $('.es_credito_bancos').val('No aplica');
          $('#credito_banco_saldo').val(0);
          $('.es_credito_bancos').prop('disabled',true);
        }
      });
      $('#opcion_credito_infonavit').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_credito_infovanit').val('')
          $('.es_credito_infovanit').prop('disabled',false);
        }
        else{
          $('.es_credito_infovanit').val('No aplica');
          $('#credito_infonavit_saldo').val(0);
          $('.es_credito_infovanit').prop('disabled',true);
        }
      });
      $('#opcion_credito_otro').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_credito_otro').val('')
          $('.es_credito_otro').prop('disabled',false);
        }
        else{
          $('.es_credito_otro').val('No aplica');
          $('#credito_otro_saldo').val(0);
          $('.es_credito_otro').prop('disabled',true);
        }
      });
      $('#opcion_propiedad_casa').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_opcion_casa').val('')
          $('.es_opcion_casa').prop('disabled',false);
        }
        else{
          $('.es_opcion_casa').val('No aplica')
          $('.es_opcion_casa').prop('disabled',true);
        }
      });
      $('#opcion_propiedad_automovil').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_opcion_auto').val('')
          $('.es_opcion_auto').prop('disabled',false);
        }
        else{
          $('.es_opcion_auto').val('No aplica')
          $('.es_opcion_auto').prop('disabled',true);
        }
      });
      // $('#buscador').change(function(){
      //   var opcion = $(this).val();
      //   if(opcion == 0){
      //     $('.carta').css('display','block');
      //   }
      //   else{
      //     $(".carta").css('display','none');
      //     $('#'+opcion).css('display','block');
      //   }
      // })
      $('#buscador').change(function(){
        var opcion = $(this).val();
        if(opcion == ''){
          $('#tarjetaCandidato').empty();
        }
        else{
          $.ajax({
            url: '<?php echo base_url('Visita/getCandidato'); ?>',
            method: 'POST',
            data: {'id':opcion},
            async:false,
            success: function(res){
              //$("#tarjetaCandidato").css('display','block');
              $("#tarjetaCandidato").html(res);
            }
          });
        }
      })
		});

    function changeOptionFinanzas(selector, clase){
      if(selector == 1){
        $(clase).val('')
        $(clase+'_numerico').val(0)
      }
      else{
        $(clase).val('No aplica')
        $(clase+'_numerico').val(0)
      }
    }
    function getVivienda(id_candidato, candidato, id_vivienda){
      $("#idCandidato").val(id_candidato);
      $('#rowForm').empty();
      let valores = ''; let scripts = ''; let opciones = '';
      let url_tipo_zona = '<?php echo base_url('Funciones/getNivelesZona'); ?>'; let zonas_data = getDataCatalogo(url_tipo_zona, 'id', 0);
      let url_tipos_vivienda = '<?php echo base_url('Funciones/getTiposVivienda'); ?>'; let tipos_vivienda_data = getDataCatalogo(url_tipos_vivienda, 'id', 0);
      let url_condiciones_vivienda = '<?php echo base_url('Funciones/getCondicionesVivienda'); ?>'; let condiciones_vivienda_data = getDataCatalogo(url_condiciones_vivienda, 'id', 0);
      $.ajax({
        url: '<?php echo base_url('Candidato_Vivienda/getById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':id_vivienda,'tipo_orden':'orden_front'},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            for(let i = 0; i < dato.length; i++){
              if(valores != 0){
                //* Get Data Catalogos
                if(dato[i]['referencia'] == 'id_tipo_nivel_zona')
                  opciones = zonas_data;
                if(dato[i]['referencia'] == 'id_tipo_vivienda')
                  opciones = tipos_vivienda_data;
                if(dato[i]['referencia'] == 'calidad_mobiliario')
                  opciones = '<option value="">Selecciona</option><option value="1">Buena</option><option value="2">Regular</option><option value="3">Deficiente</option>';
                if(dato[i]['referencia'] == 'mobiliario')
                  opciones = '<option value="">Selecciona</option><option value="0">Incompleto</option><option value="1">Completo</option>';
                if(dato[i]['referencia'] == 'tamanio_vivienda')
                  opciones = '<option value="">Selecciona</option><option value="1">Amplia</option><option value="2">Media</option><option value="3">Reducida</option>';
                if(dato[i]['referencia'] == 'id_tipo_condiciones')
                  opciones = condiciones_vivienda_data;
                if(dato[i]['referencia'] == 'tipo_propiedad')
                  opciones = '<option value="">Selecciona</option><option value="Propia">Propia</option><option value="Rentada">Rentada</option><option value="Prestada">Prestada</option><option value="INFONAVIT">INFONAVIT</option>';
                if(dato[i]['referencia'] == 'tipo_zona')
                  opciones = '<option value="">Selecciona</option><option value="Urbana">Urbana</option><option value="Céntrica">Céntrica</option><option value="Sub-Urbana">Sub-Urbana</option><option value="Periferia">Periferia</option>';
                if(dato[i]['referencia'] == 'calidad_construccion')
                  opciones = '<option value="">Selecciona</option><option value="Baja">Baja</option><option value="Regular">Regular</option><option value="Lujo">Lujo</option>';
                if(dato[i]['referencia'] == 'estado_vivienda')
                  opciones = '<option value="">Selecciona</option><option value="En excelentes condiciones">En excelentes condiciones</option><option value="En buenas condiciones">En buenas condiciones</option><option value="En condiciones regulares">En condiciones regulares</option><option value="En malas condiciones">En malas condiciones</option><option value="En condiciones precarias">En condiciones precarias</option>';
                if(dato[i]['referencia'] == 'tipo_piso')
                  opciones = '<option value="Arena">Arena</option><option value="Cemento">Cemento</option><option value="Vitropiso">Vitropiso</option><option value="Madera">Madera</option><option value="Otro">Otro</option>';
                if(dato[i]['referencia'] == 'sala' || dato[i]['referencia'] == 'comedor' || dato[i]['referencia'] == 'cocina' || dato[i]['referencia'] == 'patio' || dato[i]['referencia'] == 'cochera')
                  opciones = '<option value="Sí">Sí</option><option value="No">No</option>';
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'input'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  $('#rowForm').append(dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  $('#rowForm').append(dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'checkbox'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  if(valores[dato[i]['referencia']] == 1)
                    $('#'+dato[i]['atr_id']).prop('checked',true);
                  
                }
              }
              else{
                //* Get Data Catalogos
                if(dato[i]['referencia'] == 'id_tipo_nivel_zona')
                  opciones = zonas_data;
                if(dato[i]['referencia'] == 'id_tipo_vivienda')
                  opciones = tipos_vivienda_data;
                if(dato[i]['referencia'] == 'calidad_mobiliario')
                  opciones = '<option value="">Selecciona</option><option value="1">Buena</option><option value="2">Regular</option><option value="3">Deficiente</option>';
                if(dato[i]['referencia'] == 'mobiliario')
                  opciones = '<option value="">Selecciona</option><option value="0">Incompleto</option><option value="1">Completo</option>';
                if(dato[i]['referencia'] == 'tamanio_vivienda')
                  opciones = '<option value="">Selecciona</option><option value="1">Amplia</option><option value="2">Media</option><option value="3">Reducida</option>';
                if(dato[i]['referencia'] == 'id_tipo_condiciones')
                  opciones = condiciones_vivienda_data;
                if(dato[i]['referencia'] == 'tipo_propiedad')
                  opciones = '<option value="">Selecciona</option><option value="Propia">Propia</option><option value="Rentada">Rentada</option><option value="Prestada">Prestada</option><option value="INFONAVIT">INFONAVIT</option>';
                if(dato[i]['referencia'] == 'tipo_zona')
                  opciones = '<option value="">Selecciona</option><option value="Urbana">Urbana</option><option value="Céntrica">Céntrica</option><option value="Sub-Urbana">Sub-Urbana</option><option value="Periferia">Periferia</option>';
                if(dato[i]['referencia'] == 'calidad_construccion')
                  opciones = '<option value="">Selecciona</option><option value="Baja">Baja</option><option value="Regular">Regular</option><option value="Lujo">Lujo</option>';
                if(dato[i]['referencia'] == 'estado_vivienda')
                  opciones = '<option value="">Selecciona</option><option value="En excelentes condiciones">En excelentes condiciones</option><option value="En buenas condiciones">En buenas condiciones</option><option value="En condiciones regulares">En condiciones regulares</option><option value="En malas condiciones">En malas condiciones</option><option value="En condiciones precarias">En condiciones precarias</option>';
                if(dato[i]['referencia'] == 'tipo_piso')
                  opciones = '<option value="Arena">Arena</option><option value="Cemento">Cemento</option><option value="Vitropiso">Vitropiso</option><option value="Madera">Madera</option><option value="Otro">Otro</option>';
                if(dato[i]['referencia'] == 'sala' || dato[i]['referencia'] == 'comedor' || dato[i]['referencia'] == 'cocina' || dato[i]['referencia'] == 'patio' || dato[i]['referencia'] == 'cochera')
                  opciones = '<option value="Sí">Sí</option><option value="No">No</option>';
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'input'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  $('#rowForm').append(dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  $('#rowForm').append(dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'checkbox'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
              }
            }
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>');
          }
          const formParams = {
            id: id_candidato,
            id_seccion: id_vivienda,
            url: '<?php echo base_url('Candidato_Vivienda/set') ?>',
            refresh: false,
            encrypt: true,
            clave_txt: '<?php echo $clave_txt ?>',
          }
          $('#titleForm').html('Vivienda del candidato: <br>'+candidato)
          $('#btnSubmitForm').attr("onclick","submitForm("+JSON.stringify(formParams)+")");
          $("#formModal").modal('show');
        }
      });
    }
    function getServicios(id_candidato, candidato, id_servicio){
      $("#idCandidato").val(id_candidato);
      $('#rowForm').empty();
      let valores = ''; let scripts = ''; let opciones = '';
      $.ajax({
        url: '<?php echo base_url('Candidato_Servicio/getById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':id_servicio,'tipo_orden':'orden_front'},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            for(let i = 0; i < dato.length; i++){
              if(valores != 0){
                //* Get Data Catalogos
                if(dato[i]['referencia'] == 'agua' || dato[i]['referencia'] == 'drenaje' || dato[i]['referencia'] == 'electricidad' || dato[i]['referencia'] == 'alumbrado' || dato[i]['referencia'] == 'iglesia' || dato[i]['referencia'] == 'transporte' || dato[i]['referencia'] == 'hospital' || dato[i]['referencia'] == 'policia' || dato[i]['referencia'] == 'mercado' || dato[i]['referencia'] == 'plaza_comercial' || dato[i]['referencia'] == 'aseo_publico' || dato[i]['referencia'] == 'areas_verdes')
                  opciones = '<option value="Sí cuenta con el servicio">Sí cuenta con el servicio</option><option value="No cuenta con el servicio">No cuenta con el servicio</option>';
                if(dato[i]['referencia'] == 'servicios_basicos')
                  opciones = '<option value="Sí cuenta con todos los servicios básicos municipales">Sí cuenta con todos los servicios básicos municipales</option><option value="No cuenta con todos los servicios básicos municipales">No cuenta con todos los servicios básicos municipales</option>';
                if(dato[i]['referencia'] == 'vias_acceso')
                  opciones = '<option value="Cuenta con varias vías de acceso">Cuenta con varias vías de acceso</option><option value="Cuenta con pocas vías de acceso">Cuenta con pocas vías de acceso</option><option value="Cuenta con una sola vía de acceso">Cuenta con una sola vía de acceso</option>';
                if(dato[i]['referencia'] == 'rutas_transporte')
                  opciones = '<option value="Hay varias rutas de transporte público">Hay varias rutas de transporte público</option><option value="Hay pocas rutas de transporte público">Hay pocas rutas de transporte público</option> <option value="Hay una sola ruta de transporte público">Hay una sola ruta de transporte público</option><option value="No hay rutas de transporte público cerca del domicilio">No hay rutas de transporte público cerca del domicilio</option>';
                
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  $('#rowForm').append(dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  $('#rowForm').append(dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
              }
              else{
                //* Get Data Catalogos
                if(dato[i]['referencia'] == 'agua' || dato[i]['referencia'] == 'drenaje' || dato[i]['referencia'] == 'electricidad' || dato[i]['referencia'] == 'alumbrado' || dato[i]['referencia'] == 'iglesia' || dato[i]['referencia'] == 'transporte' || dato[i]['referencia'] == 'hospital' || dato[i]['referencia'] == 'policia' || dato[i]['referencia'] == 'mercado' || dato[i]['referencia'] == 'plaza_comercial' || dato[i]['referencia'] == 'aseo_publico' || dato[i]['referencia'] == 'areas_verdes')
                  opciones = '<option value="Sí cuenta con el servicio">Sí cuenta con el servicio</option><option value="No cuenta con el servicio">No cuenta con el servicio</option>';
                if(dato[i]['referencia'] == 'servicios_basicos')
                  opciones = '<option value="Sí cuenta con todos los servicios básicos municipales">Sí cuenta con todos los servicios básicos municipales</option><option value="No cuenta con todos los servicios básicos municipales">No cuenta con todos los servicios básicos municipales</option>';
                if(dato[i]['referencia'] == 'vias_acceso')
                  opciones = '<option value="Cuenta con varias vías de acceso">Cuenta con varias vías de acceso</option><option value="Cuenta con pocas vías de acceso">Cuenta con pocas vías de acceso</option><option value="Cuenta con una sola vía de acceso">Cuenta con una sola vía de acceso</option>';
                if(dato[i]['referencia'] == 'rutas_transporte')
                  opciones = '<option value="Hay varias rutas de transporte público">Hay varias rutas de transporte público</option><option value="Hay pocas rutas de transporte público">Hay pocas rutas de transporte público</option> <option value="Hay una sola ruta de transporte público">Hay una sola ruta de transporte público</option><option value="No hay rutas de transporte público cerca del domicilio">No hay rutas de transporte público cerca del domicilio</option>';
                
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  $('#rowForm').append(dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  $('#rowForm').append(dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
              }
            }
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>');
          }
          const formParams = {
            id: id_candidato,
            id_seccion: id_servicio,
            url: '<?php echo base_url('Candidato_Servicio/set') ?>',
            refresh: false,
            encrypt: true,
            clave_txt: '<?php echo $clave_txt ?>',
          }
          $('#titleForm').html('Servicios públicos del candidato: <br>'+candidato)
          $('#btnSubmitForm').attr("onclick","submitForm("+JSON.stringify(formParams)+")");
          $("#formModal").modal('show');
        }
      });
    }
    function getSalud(id_candidato, candidato, id_salud){
      $("#idCandidato").val(id_candidato);
      $('#rowForm').empty();
      let valores = ''; let scripts = ''; let opciones = '';
      let url_sanguineo = '<?php echo base_url('Funciones/getGruposSanguineo'); ?>'; let sanguineo_data = getDataCatalogo(url_sanguineo, 'nombre', 0);
      let url_frecuencias = '<?php echo base_url('Funciones/getFrecuencias'); ?>'; let frecuencias_data = getDataCatalogo(url_frecuencias, 'nombre', 0);
      $.ajax({
        url: '<?php echo base_url('Candidato_Salud/getById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':id_salud,'tipo_orden':'orden_front'},
        async:false,
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            for(let i = 0; i < dato.length; i++){
              if(valores != 0){
                //* Get Data Catalogos
                if(dato[i]['referencia'] == 'tipo_sangre')
                  opciones = sanguineo_data;
                if(dato[i]['referencia'] == 'tabaco_frecuencia' || dato[i]['referencia'] == 'alcohol_frecuencia' || dato[i]['referencia'] == 'droga_frecuencia')
                  opciones = frecuencias_data;
                if(dato[i]['referencia'] == 'practica_deporte')
                  opciones = '<option value="0">No</option><option value="1">Sí</option>';
                if(dato[i]['referencia'] == 'tabaco' || dato[i]['referencia'] == 'alcohol' || dato[i]['referencia'] == 'droga')
                  opciones = '<option value="NO">No</option><option value="SI">Sí</option>';
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'input'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['script_final'] != null)
                  scripts += dato[i]['script_final'];
              }
              else{
                //* Get Data Catalogos
                if(dato[i]['referencia'] == 'tipo_sangre')
                  opciones = sanguineo_data;
                if(dato[i]['referencia'] == 'tabaco_frecuencia' || dato[i]['referencia'] == 'alcohol_frecuencia' || dato[i]['referencia'] == 'droga_frecuencia')
                  opciones = frecuencias_data;
                if(dato[i]['referencia'] == 'practica_deporte')
                  opciones = '<option value="0">No</option><option value="1">Sí</option>';
                if(dato[i]['referencia'] == 'tabaco' || dato[i]['referencia'] == 'alcohol' || dato[i]['referencia'] == 'droga')
                  opciones = '<option value="NO">No</option><option value="SI">Sí</option>';
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'input'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['script_inicial'] != null)
                  scripts += dato[i]['script_inicial'];
              }
            }
            $('#rowForm').append(scripts);
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>');
          }
          const formParams = {
            id: id_candidato,
            id_seccion: id_salud,
            url: '<?php echo base_url('Candidato_Salud/set') ?>',
            refresh: false,
            encrypt: true,
            clave_txt: '<?php echo $clave_txt ?>',
          }
          $('#titleForm').html('Estado de salud del candidato: <br>'+candidato)
          $('#btnSubmitForm').attr("onclick","submitForm("+JSON.stringify(formParams)+")");
          $("#formModal").modal('show');
        }
      });
    }
    function getFinanzas(id_candidato, candidato, id_finanzas){
      $("#idCandidato").val(id_candidato);
      $("#rowForm").empty();
      let valores = ''; let scripts = ''; let opciones = '';
      $.ajax({
        url: '<?php echo base_url('Candidato_Finanzas/getById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':id_finanzas,'tipo_orden':'orden_front'},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            for(let i = 0; i < dato.length; i++){
              if(valores != 0){
                //* Get Data Catalogos
                if(dato[i]['referencia'] == 'adeudo_muebles' || dato[i]['referencia'] == 'tiene_credito_banco' || dato[i]['referencia'] == 'unico_solvente')
                  opciones = '<option value="0">No</option><option value="1">Sí</option>';
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'input'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['script_final'] != null)
                  scripts += dato[i]['script_final'];
              }
              else{
                //* Get Data Catalogos
                if(dato[i]['referencia'] == 'adeudo_muebles' || dato[i]['referencia'] == 'tiene_credito_banco' || dato[i]['referencia'] == 'unico_solvente')
                  opciones = '<option value="0">No</option><option value="1">Sí</option>';
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'input'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['script_inicial'] != null)
                  scripts += dato[i]['script_inicial'];
              }
            }
            $('#rowForm').append(scripts);
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>');
          }
          const formParams = {
            id: id_candidato,
            id_seccion: id_finanzas,
            url: '<?php echo base_url('Candidato_Finanzas/set') ?>',
            refresh: false,
            encrypt: true,
            clave_txt: '<?php echo $clave_txt ?>',
          }
          $('#titleForm').html('Finanzas del candidato: <br>'+candidato)
          $('#btnSubmitForm').attr("onclick","submitForm("+JSON.stringify(formParams)+")");
          $("#formModal").modal('show');
        }
      });
    }
    function getDocumentacion(id_candidato, candidato, id_seccion_verificacion_docs){
      $("#idCandidato").val(id_candidato);
      $('#rowForm').empty();
      let valores = ''; let scripts = ''; let opciones = ''; let files = '';
      $.ajax({
        url: '<?php echo base_url('Documentacion/getByCandidate'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':id_seccion_verificacion_docs,'tipo_orden':'orden_front'},
        async:false,
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            let btnVerArchivos = ''
            var dato = JSON.parse(res);
            for(let i = 0; i < dato.length; i++){
              if(valores != 0){
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'input'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['script_final'] != null)
                  scripts += dato[i]['script_final'];                    
              }
              else{
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'input'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  $('#rowForm').append(dato[i]['titulo_seccion_modal']+dato[i]['grid_col_inicio']+dato[i]['label']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['script_inicial'] != null)
                  scripts += dato[i]['script_inicial'];
              }
            }
            $('#rowForm').append(scripts);
            let url_files = '<?php echo base_url('Candidato/getDocumentos'); ?>';
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>');
          }
          const formParams = {
            id: id_candidato,
            id_seccion: id_seccion_verificacion_docs,
            url: '<?php echo base_url('Documentacion/update') ?>',
            refresh: false,
            encrypt: true,
            clave_txt: '<?php echo $clave_txt ?>',
          }
          $('#titleForm').html('Documentacion del candidato: <br>'+candidato)
          $('#btnSubmitForm').attr("onclick","submitForm("+JSON.stringify(formParams)+")");
          $("#formModal").modal('show');
        }
      });
    }

    function getVecinales(id_candidato, candidato, id_ref_vecinal, cantidad_ref_vecinales){
      $("#idCandidato").val(id_candidato);
      $('#rowForm').empty();
      let valores = ''; let scripts = ''; let opciones = ''; let btn_candidato = ''; let autor_anterior = '';
      $.ajax({
        url: '<?php echo base_url('Candidato_Ref_Vecinal/getById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':id_ref_vecinal,'tipo_orden':'orden_front'},
        async:false,
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            for(var num = 1; num <= cantidad_ref_vecinales; num++){
              $('#rowForm').append('<div class="alert alert-secondary btn-block text-center"><h5>Referencia #'+num+'</h5></div>');
              //autor_anterior = '';
              for(let tag of dato){
                // //* Boton por autor del registro del campo
                // if(autor_anterior != '' && tag['autor'] != autor_anterior){
                //   //* Boton Guardar
                //   $('#rowForm').append('<button type="button" class="btn btn-success btn-block mt-3 mb-5" onclick="guardarRefPersonal('+num+')">Guardar información de la Referencia #'+num+'</button>');
                //   autor_anterior = tag['autor'];
                // }
                // if(autor_anterior == '' || tag['autor'] == autor_anterior){
                //   autor_anterior = tag['autor'];
                // }
                //* Get Data Catalogos
                //* HTML
                if(tag['tipo_etiqueta'] == 'select'){
                  $('#rowForm').append(tag['grid_col_inicio']+tag['label']+tag['etiqueta_inicio']+opciones+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'input'){
                  $('#rowForm').append(tag['titulo_seccion_modal']+tag['grid_col_inicio']+tag['label']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'textarea'){
                  $('#rowForm').append(tag['grid_col_inicio']+tag['label']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
              }
              //* Boton Guardar
              $('#rowForm').append('<div class="col-12"><button type="button" id="btnGuardarRefVecinal'+num+'" class="btn btn-success btn-block mt-3 mb-5" >Guardar la Referencia #'+num+'</button></div><');
              const formNewParams = {
                id: id_candidato,
                id_seccion: id_ref_vecinal,
                url: '<?php echo base_url('Candidato_Ref_Vecinal/set') ?>',
                refresh: false,
                num: num,
                id_ref: 0,
                hideModal: false,
                updateButton: 'btnGuardarRefVecinal',
                deleteButton: 'btnEliminarRefVecinal',
                action: 'eliminar referencia vecinal',
                encrypt: true,
                clave_txt: '<?php echo $clave_txt ?>',
              }
              $('#titleForm').html('Referencias vecinales del candidato: <br>'+candidato)
              $('#btnGuardarRefVecinal'+num).attr("onclick","submitForm("+JSON.stringify(formNewParams)+")");
            }
            //* Values
            if(valores != 0){
              let index = 0; let idRefVecinal = 0; let flag = 0;
              for(let valor of valores){
                flag = 0;
                for(let tag of dato){
                  $('[name="'+tag['atr_id']+'[]"]').eq(index).val(valor[tag['referencia']]);
                  $('#btnEliminarRefVecinal'+(index+1)).prop('disabled', false);
                  if(flag == 0){
                    idRefVecinal = valor['id'];
                    flag++;
                  }
                }
                const formParams = {
                  id: id_candidato,
                  id_seccion: id_ref_vecinal,
                  url: '<?php echo base_url('Candidato_Ref_Vecinal/set') ?>',
                  refresh: false,
                  num: (index+1),
                  id_ref: idRefVecinal,
                  hideModal: false,
                  updateButton: 'btnGuardarRefVecinal',
                  deleteButton: 'btnEliminarRefVecinal',
                  action: 'eliminar referencia vecinal',
                  encrypt: true,
                  clave_txt: '<?php echo $clave_txt ?>',
                }
                $('#titleForm').html('Referencias vecinales del candidato: <br>'+candidato)
                $('#btnGuardarRefVecinal'+(index+1)).attr("onclick","submitForm("+JSON.stringify(formParams)+")");
                //$('#btnEliminarRefVecinal'+(index+1)).attr("onclick","mostrarMensajeConfirmacion(\"eliminar referencia vecinal\","+(index+1)+","+idRefVecinal+")");
                
                index++;
              }
            }
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>');
          }
          $('#formModal #btnSubmitForm').prop('disabled',true);
          $('#formModal .modal-body').addClass('escrolable');
          $("#formModal").modal('show');
        }
      });
    }
    function openFamiliares(id_candidato, candidato){
      $("#div_familiares").empty();
      $("#idCandidato").val(id_candidato)
      $('.nombreCandidato').text(candidato);
      $('#nombreCandidato').val(candidato);
      getIntegrantesFamiliares(id_candidato, candidato);
      //$("#familiaresModal").modal('show');
    }
    function getIntegrantesFamiliares(id){
      let valores = ''; let scripts = ''; let opciones = '';
      let url_parentescos = '<?php echo base_url('Funciones/getParentescos'); ?>'; let parentescos_data = getDataCatalogo(url_parentescos, 'id', 1);
      let url_escolaridad = '<?php echo base_url('Funciones/getEscolaridades'); ?>'; let escolaridades_data = getDataCatalogo(url_escolaridad, 'id', 0);
      let url_civiles = '<?php echo base_url('Funciones/getCiviles'); ?>'; let civiles_data = getDataCatalogo(url_civiles, 'nombre', 0);
      $.ajax({
        url: '<?php echo base_url('Candidato_Familiar/getById'); ?>',
        method: 'POST',
        data: {'id':id},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':35,'tipo_orden':'orden_front'},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            let totalFamiliares = valores.length;
            for(let number = 0; number < valores.length; number++){
              $('#rowFamiliares').append('<div class="alert alert-info btn-block"><h5 class="text-center">Familiar #'+totalFamiliares+'</h5></div><br>');
              //for(let i = 0; i < dato.length; i++){
                for(let tag of dato){
                  let referencia = tag['referencia'];
                  if(referencia == 'id_tipo_parentesco')
                    opciones = parentescos_data;
                  if(referencia == 'estado_civil')
                    opciones = civiles_data;
                  if(referencia == 'id_grado_estudio')
                    opciones = escolaridades_data;
                  if(referencia == 'misma_vivienda' || referencia == 'adeudo')
                    opciones = '<option value="0">No</option><option value="1">Sí</option>';

                  if(tag['tipo_etiqueta'] == 'select'){
                    $('#rowFamiliares').append(tag['grid_col_inicio']+tag['label']+tag['etiqueta_inicio']+opciones+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                  }
                  if(tag['tipo_etiqueta'] == 'input'){
                    $('#rowFamiliares').append(tag['titulo_seccion_modal']+tag['grid_col_inicio']+tag['label']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                  }
                  if(tag['tipo_etiqueta'] == 'textarea'){
                    $('#rowFamiliares').append(tag['grid_col_inicio']+tag['label']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                  }
                }
                //* Boton Guardar
                $('#rowFamiliares').append('<div class="col-md-6 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-primary btn-block" onclick="guardarIntegranteFamiliar('+valores[number]['id']+','+number+','+valores[number]['id_candidato']+')">Actualizar Integrante #'+totalFamiliares+'</a></div><div class="col-md-6 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-danger btn-block" onclick="mostrarMensajeConfirmacion(\'eliminar integrante familiar\', '+valores[number]['id']+', \''+valores[number]['nombre']+'\')">Eliminar Integrante #'+totalFamiliares+'</a></div>');
                
              //}
              //$('#rowFamiliares').append(scripts);
              totalFamiliares--;
            }
            //* Values
            if(valores != 0){
              var index = 0;
              for(let valor of valores){
                for(let tag of dato){
                  $('[name="'+tag['atr_id']+'[]"]').eq(index).addClass('fam'+index);
                  $('[name="'+tag['atr_id']+'[]"]').eq(index).val(valor[tag['referencia']]);
                }
                index++;
              }
            }
            else{
              $('#rowFamiliares').append('<div class="col-12 text-center mt-5"><h4 class="">No hay familiares registrados</h4></div>');
            }
          }
          else{
            $('#rowFamiliares').html('<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>');
          }
          $("#familiaresModal").modal('show');
        }
      });
    }
    function nuevoFamiliar(){
      let id_candidato = $('#idCandidato').val(); let opciones = ''; 
      let url_parentescos = '<?php echo base_url('Funciones/getParentescos'); ?>'; let parentescos_data = getDataCatalogo(url_parentescos, 'id', 1);
      let url_escolaridad = '<?php echo base_url('Funciones/getEscolaridades'); ?>'; let escolaridades_data = getDataCatalogo(url_escolaridad, 'id', 0);
      let url_civiles = '<?php echo base_url('Funciones/getCiviles'); ?>'; let civiles_data = getDataCatalogo(url_civiles, 'nombre', 0);
      $('#rowNuevoFamiliar').empty();
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':35,'tipo_orden':'orden_front'},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $("#familiaresModal").modal('hide');
            $('.loader').fadeOut();
            if(res != 0){
              var dato = JSON.parse(res);
              for(let tag of dato){
                let referencia = tag['referencia'];
                if(referencia == 'id_tipo_parentesco')
                  opciones = parentescos_data;
                if(referencia == 'estado_civil')
                  opciones = civiles_data;
                if(referencia == 'id_grado_estudio')
                  opciones = escolaridades_data;
                if(referencia == 'misma_vivienda' || referencia == 'adeudo')
                  opciones = '<option value="0">No</option><option value="1">Sí</option>';

                if(tag['tipo_etiqueta'] == 'select'){
                  $('#rowNuevoFamiliar').append(tag['grid_col_inicio']+tag['label']+tag['etiqueta_inicio']+opciones+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'input'){
                  $('#rowNuevoFamiliar').append(tag['titulo_seccion_modal']+tag['grid_col_inicio']+tag['label']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'textarea'){
                  $('#rowNuevoFamiliar').append(tag['grid_col_inicio']+tag['label']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
              }
              //* Boton Guardar
              $('#rowNuevoFamiliar').append('<div class="col-12 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-success btn-lg btn-block" onclick="guardarIntegranteFamiliar(0,0,'+id_candidato+')"><i class="fas fa-plus-circle"></i> Registrar</a></div></div>');
            }
            else{
              $('#rowNuevoFamiliar').html('<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>');
            }
          },200);
          $("#nuevoFamiliarModal").modal('show');
        }
      });
    }
    function guardarIntegranteFamiliar(id_familiar, num_familiar, idCandidato) {
      var campos = '';
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':35,'tipo_orden':'orden_front'},
        async:false,
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            campos = JSON.parse(res);
          }
        }
      });
      let objeto = new Object();
      for(let tag of campos){
        let param = tag['atr_id'];
        objeto[tag['atr_id']] = $('[name="'+tag['atr_id']+'[]"]').eq(num_familiar).val();
      }
      let datos = $.param(objeto);
      datos += '&id_candidato=' + $("#idCandidato").val();
      datos += '&id_seccion=' + 35;
      datos += '&id_familiar=' + id_familiar;
      datos += '&num=' + num_familiar;
      
      $.ajax({
        url: '<?php echo base_url('Candidato_Familiar/set'); ?>',
        type: 'POST',
        data: datos,
        async:false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if(id_familiar != 0){
            var textoResponse = 'Integrante familiar actualizado correctamente';
          }
          else{
            var textoResponse = 'Integrante familiar guardado correctamente';
            $('#rowNuevoFamiliar').empty();
            $("#nuevoFamiliarModal").modal('hide');
            getIntegrantesFamiliares(idCandidato);
          }
          if (data.codigo === 1) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: textoResponse,
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
		function abrirFormulario(id, candidato) {
			$("#idCandidato").val(id);
			$(".formNombre").text(candidato);
			$("#formCandidatoModal").modal("show");
		}

		function guardarVisita() {
			var id_candidato = $("#idCandidato").val();
			var datos = new FormData();
			
			datos.append('comentario_visitador', $('#comentario_visitador_1').val());
			datos.append('id_candidato', id_candidato);
			for (var i = 1; i <= 3; i++) {
				datos.append('vecino' + i + '_nombre', $('#vecino' + i + '_nombre').val());
				datos.append('vecino' + i + '_domicilio', $('#vecino' + i + '_domicilio').val());
				datos.append('vecino' + i + '_tel', $('#vecino' + i + '_tel').val());
				datos.append('vecino' + i + '_concepto', $('#vecino' + i + '_concepto').val());
				datos.append('vecino' + i + '_familia', $('#vecino' + i + '_familia').val());
				datos.append('vecino' + i + '_civil', $('#vecino' + i + '_civil').val());
				datos.append('vecino' + i + '_hijos', $('#vecino' + i + '_hijos').val());
				datos.append('vecino' + i + '_sabetrabaja', $('#vecino' + i + '_sabetrabaja').val());
				datos.append('vecino' + i + '_notas', $('#vecino' + i + '_notas').val());
			}
			var persona = "";
			var total_persona = $(".es_persona").length;
			if (total_persona > 0) {
				for (var i = 1; i <= total_persona / 13; i++) {
					persona += $("#p" + i + "_nombre").val() + ",,";
					persona += $("#p" + i + "_parentesco").val() + ",,";
					persona += $("#p" + i + "_edad").val() + ",,";
					persona += $("#p" + i + "_escolaridad").val() + ",,";
					persona += $("#p" + i + "_vive").val() + ",,";
					persona += $("#p" + i + "_civil").val() + ",,";
					persona += $("#p" + i + "_empresa").val() + ",,";
					persona += $("#p" + i + "_puesto").val() + ",,";
					persona += $("#p" + i + "_antiguedad").val() + ",,";
					persona += $("#p" + i + "_sueldo").val() + ",,";
					persona += $("#p" + i + "_aportacion").val() + ",,";
					persona += $("#p" + i + "_muebles").val() + ",,";
					persona += $("#p" + i + "_adeudo").val() + "@@";
				}
				datos.append('personas', persona);
			}

			$.ajax({
				url: '<?php echo base_url('Candidato/registrarInfoVisitador'); ?>',
				type: 'POST',
				data: datos,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#formCandidatoModal").modal('hide')
						localStorage.setItem("success", 1);
						location.reload();
					} else {
						setTimeout(function() {
							$('.loader').fadeOut();
						}, 200);
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'Hay campos obligatorios vacios',
							showConfirmButton: false,
							timer: 3000
						})
					}
				}
			});
		}

		function guardarVisitaAlterna() {
			var id_candidato = $("#idCandidato").val();
			var datos = new FormData();
			
			datos.append('id_candidato', id_candidato);
			datos.append('comentario_visitador', $('#comentario_visitador_2').val());
			

			$.ajax({
				url: '<?php echo base_url('Candidato/registrarInfoVisitadorAlterno'); ?>',
				type: 'POST',
				data: datos,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#formCandidato2Modal").modal('hide')
						localStorage.setItem("success", 1);
						location.reload();
					} else {
						setTimeout(function() {
							$('.loader').fadeOut();
						}, 200);
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'Hay campos obligatorios vacios',
							showConfirmButton: false,
							timer: 3000
						})
					}
				}
			});
		}

		function abrirFormularioTipo2(id, candidato) {
			$("#idCandidato").val(id);
			$(".formNombre").text(candidato);
		
			$("#formCandidato2Modal").modal("show");
		}
    function abrirFormularioTipo3(id, candidato) {
			$("#idCandidato").val(id);
			$(".formNombre").text(candidato);

			$("#formCandidato3Modal").modal("show");
		}

    //* Terminar visita
    function terminarVisita(){
			var id_candidato = $("#idCandidato").val();
      var observacion = $('#observacion_visitador').val();
      $.ajax({
				url: '<?php echo base_url('Candidato/terminarVisita'); ?>',
				type: 'POST',
				data: {'id_candidato': id_candidato,'observacion': observacion},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
          $("#formCandidato3Modal").modal('hide')
          localStorage.setItem("success", 1);
          location.reload();
				}
			});
    }
    function endVisit(id_candidato, candidato){
      $('#titulo_mensaje').text('Finalizar visita');
			$('#btnConfirmar').attr("onclick","finalizarVisita("+id_candidato+")");
			$('#mensajeModal').modal('show');
    }
    function finalizarVisita(id_candidato){
      var comentario = $('#comentario_visitador_51').val();
      $.ajax({
        url: '<?php echo base_url('Candidato/setVisita'); ?>',
        type: 'POST',
        data: {'id_candidato':id_candidato,'comentario':comentario},
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          $('#mensajeModal').modal('hide');
          localStorage.setItem("finalizarVisita", 1);
          location.reload();
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
        }
      });
    }
    
    //* Grupo familiar
    function guardarGrupoFamiliar() {
			var datos = new FormData();
			var persona = "";
			var total_persona = $(".es_familiar").length;
			if (total_persona > 0) {
				for (var i = 1; i <= total_persona / 13; i++) {
					persona += $("#fam" + i + "_nombre").val() + ",,";
					persona += $("#fam" + i + "_parentesco").val() + ",,";
					persona += $("#fam" + i + "_edad").val() + ",,";
					persona += $("#fam" + i + "_escolaridad").val() + ",,";
					persona += $("#fam" + i + "_vive").val() + ",,";
					persona += $("#fam" + i + "_civil").val() + ",,";
					persona += $("#fam" + i + "_empresa").val() + ",,";
					persona += $("#fam" + i + "_puesto").val() + ",,";
					persona += $("#fam" + i + "_antiguedad").val() + ",,";
					persona += $("#fam" + i + "_sueldo").val() + ",,";
					persona += $("#fam" + i + "_aportacion").val() + ",,";
					persona += $("#fam" + i + "_muebles").val() + ",,";
					persona += $("#fam" + i + "_adeudo").val() + "@@";
				}
				datos.append('personas', persona);
				datos.append('id_candidato', $('#idCandidato').val());
        $.ajax({
          url: '<?php echo base_url('Candidato/registrarGrupoFamiliar'); ?>',
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
              $('#familiar_msj_error').css('display','none');
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Integrantes familiares agregados',
                showConfirmButton: false,
                timer: 3000
              })
            } else {
              setTimeout(function() {
                $('.loader').fadeOut();
              }, 200);
              Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Hay campos obligatorios vacios',
                showConfirmButton: false,
                timer: 3000
              })
            }
          }
        });
			}
		}
		var num = 1;

		function generarPersona() {
			num++;
			var item = "";
			item += '<div class="alert alert-secondary text-center p' + num + '"><p>Persona #' + num + '</p></div><div class="row p' + num + '"><div class="col-12"><label for="p' + num + '_nombre">Nombre completo *</label><input type="text" class="form-control es_persona p_obligado" name="p' + num + '_nombre" id="p' + num + '_nombre"><br></div></div><div class="row p' + num + '"><div class="col-6"><label for="p' + num + '_parentesco">Parentesco *</label><select name="p' + num + '_parentesco" id="p' + num + '_parentesco" class="form-control es_persona p_obligado"><option value="">Selecciona</option><?php foreach ($parentescos as $par) { ?><option value="<?php echo $par->id; ?>"><?php echo $par->nombre; ?></option><?php } ?></select><br></div><div class="col-6"><label for="p' + num + '_edad">Edad *</label><input type="text" class="form-control solo_numeros es_persona p_obligado" name="p' + num + '_edad" id="p' + num + '_edad" maxlength="2"><br></div></div><div class="row p' + num + '"><div class="col-6"><label for="p' + num + '_escolaridad">Escolaridad *</label><select name="p' + num + '_escolaridad" id="p' + num + '_escolaridad" class="form-control es_persona p_obligado"><option value="">Selecciona</option><?php foreach ($escolaridades as $esc) { ?><option value="<?php echo $esc->id; ?>"><?php echo $esc->nombre; ?></option><?php } ?></select><br></div><div class="col-6"><label for="p' + num + '_vive">¿Vive con usted? *</label><select name="p' + num + '_vive" id="p' + num + '_vive" class="form-control es_persona p_obligado"><option value="">Selecciona</option><option value="0">No</option><option value="1">Sí</option></select><br></div></div><div class="row p' + num + '"><div class="col-6"><label for="p' + num + '_civil">Estado civil *</label><select name="p' + num + '_civil" id="p' + num + '_civil" class="form-control es_persona p_obligado"><option value="">Selecciona</option><?php foreach ($civiles as $civ) { ?><option value="<?php echo $civ->nombre; ?>"><?php echo $civ->nombre; ?></option><?php } ?></select><br></div><div class="col-6"><label for="p' + num + '_empresa">Empresa *</label><input type="text" class="form-control es_persona p_obligado" name="p' + num + '_empresa" id="p' + num + '_empresa"><br></div></div><div class="row p' + num + '"><div class="col-6"><label for="p' + num + '_puesto">Puesto *</label><input type="text" class="form-control es_persona p_obligado" name="p' + num + '_puesto" id="p' + num + '_puesto"><br></div><div class="col-6"><label for="p' + num + '_antiguedad">Antigüedad *</label><input type="text" class="form-control es_persona p_obligado" name="p' + num + '_antiguedad" id="p' + num + '_antiguedad"><br></div></div><div class="row p' + num + '"><div class="col-6"><label for="p' + num + '_sueldo">Sueldo *</label><input type="text" class="form-control solo_numeros es_persona p_obligado" name="p' + num + '_sueldo" id="p' + num + '_sueldo" maxlength="8"><br></div><div class="col-6"><label for="p' + num + '_aportacion">Aportación *</label><input type="text" class="form-control solo_numeros es_persona p_obligado" name="p' + num + '_aportacion" id="p' + num + '_aportacion" maxlength="8"><br></div></div><div class="row p' + num + '"><div class="col-6"><label for="p' + num + '_muebles">Muebles e inmuebles *</label><input type="text" class="form-control es_persona p_obligado" name="p' + num + '_muebles" id="p' + num + '_muebles"><br></div><div class="col-6"><label for="p' + num + '_adeudo">Adeudo *</label><select name="p' + num + '_adeudo" id="p' + num + '_adeudo" class="form-control es_persona p_obligado"><option value="">Selecciona</option><option value="0">No</option><option value="1">Sí</option></select><br></div></div><br><div class="row p' + num + '"><div class="col-md-4 offset-md-4"><a href="javascript:void(0)" class="btn btn-danger" onclick="borrarPersona(' + num + ')">Borrar esta persona</a><br><br><br><br></div></div>';
      $("#div_personas").append(item);
		}
		num2 = 1;

		function generarPersonaTipo2() {
			num2++;
			var item2 = "";
			item2 += '<div class="alert alert-secondary text-center p2_' + num2 + '"><p>Persona #' + num2 + '</p></div><div class="row p2_' + num2 + '"><div class="col-12"><label>Nombre completo *</label><input type="text" class="form-control es_persona_2 p_obligado_2" name="p' + num2 + '_nombre_2" id="p' + num2 + '_nombre_2"><br></div></div><div class="row p2_' + num2 + '"><div class="col-6"><label>Parentesco *</label><select name="p' + num2 + '_parentesco_2" id="p' + num2 + '_parentesco_2" class="form-control es_persona_2 p_obligado_2"><option value="">Selecciona</option><?php foreach ($parentescos as $par) { ?><option value="<?php echo $par->id; ?>"><?php echo $par->nombre; ?></option><?php } ?></select><br></div><div class="col-6"><label>Edad *</label><input type="text" class="form-control solo_numeros es_persona_2 p_obligado_2" name="p' + num2 + '_edad_2" id="p' + num2 + '_edad_2" maxlength="2"><br></div></div><div class="row p2_' + num2 + '"><div class="col-6"><label>Escolaridad *</label><select name="p' + num2 + '_escolaridad_2" id="p' + num2 + '_escolaridad_2" class="form-control es_persona_2 p_obligado_2"><option value="">Selecciona</option><?php foreach ($escolaridades as $esc) { ?><option value="<?php echo $esc->id; ?>"><?php echo $esc->nombre; ?></option><?php } ?></select><br></div><div class="col-6"><label>¿Vive con usted? *</label><select name="p' + num2 + '_vive_2" id="p' + num2 + '_vive_2" class="form-control es_persona_2 p_obligado_2"><option value="">Selecciona</option><option value="0">No</option><option value="1">Sí</option></select><br></div></div><div class="row p2_' + num2 + '"><div class="col-6"><label>Estado civil *</label><select name="p' + num2 + '_civil_2" id="p' + num2 + '_civil_2" class="form-control es_persona_2 p_obligado_2"><option value="">Selecciona</option><?php foreach ($civiles as $civ) { ?><option value="<?php echo $civ->nombre; ?>"><?php echo $civ->nombre; ?></option><?php } ?></select><br></div><div class="col-6"><label>Empresa *</label><input type="text" class="form-control es_persona_2 p_obligado_2" name="p' + num2 + '_empresa_2" id="p' + num2 + '_empresa_2"><br></div></div><div class="row p2_' + num2 + '"><div class="col-6"><label for="p' + num2 + '_puesto">Puesto *</label><input type="text" class="form-control es_persona_2 p_obligado_2" name="p' + num2 + '_puesto_2" id="p' + num2 + '_puesto_2"><br></div><div class="col-6"><label>Antigüedad *</label><input type="text" class="form-control es_persona_2 p_obligado_2" name="p' + num2 + '_antiguedad_2" id="p' + num2 + '_antiguedad_2"><br></div></div><div class="row p2_' + num2 + '"><div class="col-6"><label>Sueldo *</label><input type="text" class="form-control solo_numeros es_persona_2 p_obligado_2" name="p' + num2 + '_sueldo_2" id="p' + num2 + '_sueldo_2" maxlength="8"><br></div><div class="col-6"><label>Aportación *</label><input type="text" class="form-control solo_numeros es_persona_2 p_obligado_2" name="p' + num2 + '_aportacion_2" id="p' + num2 + '_aportacion_2" maxlength="8"><br></div></div><div class="row p2_' + num2 + '"><div class="col-6"><label>Muebles e inmuebles *</label><input type="text" class="form-control es_persona_2 p_obligado_2" name="p' + num2 + '_muebles_2" id="p' + num2 + '_muebles_2"><br></div><div class="col-6"><label>Adeudo *</label><select name="p' + num2 + '_adeudo_2" id="p' + num2 + '_adeudo_2" class="form-control es_persona_2 p_obligado_2"><option value="">Selecciona</option><option value="0">No</option><option value="1">Sí</option></select><br></div></div><br><div class="row p2_' + num2 + '"><div class="col-md-4 offset-md-4"><a href="javascript:void(0)" class="btn btn-danger" onclick="borrarPersonaTipo2(' + num2 + ')">Borrar esta persona</a><br><br><br><br></div></div>';
			$("#div_personas_2").append(item2);
		}

    var num3 = 1;

		function generarPersona3() {
			num3++;
			var item = "";
			item += '<div class="alert alert-secondary text-center fam'+num3+'"><p>Persona #' + num3 + '</p></div><div class="row fam'+num3+'"><div class="col-12"><label for="fam'+num3+'_nombre">Nombre completo *</label><input type="text" class="form-control es_familiar p_obligado" name="fam'+num3+'_nombre" id="fam'+num3+'_nombre"><br></div></div><div class="row fam'+num3+'"><div class="col-6"><label for="fam'+num3+'_parentesco">Parentesco *</label><select name="fam'+num3+'_parentesco" id="fam'+num3+'_parentesco" class="form-control es_familiar p_obligado"><option value="">Selecciona</option><?php foreach ($parentescos as $par) { ?><option value="<?php echo $par->id; ?>"><?php echo $par->nombre; ?></option><?php } ?></select><br></div><div class="col-6"><label for="fam'+num3+'_edad">Edad *</label><input type="text" class="form-control solo_numeros es_familiar p_obligado" name="fam'+num3+'_edad" id="fam'+num3+'_edad" maxlength="2"><br></div></div><div class="row fam'+num3+'"><div class="col-6"><label for="fam'+num3+'_escolaridad">Escolaridad *</label><select name="fam'+num3+'_escolaridad" id="fam'+num3+'_escolaridad" class="form-control es_familiar p_obligado"><option value="">Selecciona</option><?php foreach ($escolaridades as $esc) { ?><option value="<?php echo $esc->id; ?>"><?php echo $esc->nombre; ?></option><?php } ?></select><br></div><div class="col-6"><label for="fam'+num3+'_vive">¿Vive con usted? *</label><select name="fam'+num3+'_vive" id="fam'+num3+'_vive" class="form-control es_familiar p_obligado"><option value="">Selecciona</option><option value="0">No</option><option value="1">Sí</option></select><br></div></div><div class="row fam'+num3+'"><div class="col-6"><label for="fam'+num3+'_civil">Estado civil *</label><select name="fam'+num3+'_civil" id="fam'+num3+'_civil" class="form-control es_familiar p_obligado"><option value="">Selecciona</option><?php foreach ($civiles as $civ) { ?><option value="<?php echo $civ->nombre; ?>"><?php echo $civ->nombre; ?></option><?php } ?></select><br></div><div class="col-6"><label for="fam'+num3+'_empresa">Empresa *</label><input type="text" class="form-control es_familiar p_obligado" name="fam'+num3+'_empresa" id="fam'+num3+'_empresa"><br></div></div><div class="row fam'+num3+'"><div class="col-6"><label for="fam'+num3+'_puesto">Puesto *</label><input type="text" class="form-control es_familiar p_obligado" name="fam'+num3+'_puesto" id="fam'+num3+'_puesto"><br></div><div class="col-6"><label for="fam'+num3+'_antiguedad">Antigüedad *</label><input type="text" class="form-control es_familiar p_obligado" name="fam'+num3+'_antiguedad" id="fam'+num3+'_antiguedad"><br></div></div><div class="row fam'+num3+'"><div class="col-6"><label for="fam'+num3+'_sueldo">Sueldo *</label><input type="text" class="form-control solo_numeros es_familiar p_obligado" name="fam'+num3+'_sueldo" id="fam'+num3+'_sueldo" maxlength="8"><br></div><div class="col-6"><label for="fam'+num3+'_aportacion">Aportación *</label><input type="text" class="form-control solo_numeros es_familiar p_obligado" name="fam'+num3+'_aportacion" id="fam'+num3+'_aportacion" maxlength="8"><br></div></div><div class="row fam'+num3+'"><div class="col-6"><label for="fam'+num3+'_muebles">Muebles e inmuebles *</label><input type="text" class="form-control es_familiar p_obligado" name="fam'+num3+'_muebles" id="fam'+num3+'_muebles"><br></div><div class="col-6"><label for="fam'+num3+'_adeudo">Adeudo *</label><select name="fam'+num3+'_adeudo" id="fam'+num3+'_adeudo" class="form-control es_familiar p_obligado"><option value="">Selecciona</option><option value="0">No</option><option value="1">Sí</option></select><br></div></div><br><div class="row fam'+num3+'"><div class="col-md-4 offset-md-4"><a href="javascript:void(0)" class="btn btn-danger" onclick="borrarPersona3(' + num3 + ')">Borrar esta persona</a><br><br><br><br></div></div>';
      $("#div_grupo_familiar").append(item);
		}

		function borrarPersona(numero) {
			$(".p" + numero).empty();
			$(".p" + numero).removeClass('alert', 'alert-secondary');
			num--;
		}
		function borrarPersonaTipo2(numero) {
			$(".p2_" + numero).empty();
			$(".p2_" + numero).removeClass('alert', 'alert-secondary');
			num2--;
		}
    function borrarPersona3(numero) {
			$(".fam" + numero).remove();
			$(".fam" + numero).removeClass('alert', 'alert-secondary');
			num3--;
		}
    function getEdad(dateString, campo) {
      let hoy = new Date()
      let aux = dateString.split('/');
      let arreglo = aux[2]+'-'+aux[1]+'-'+aux[0];
      let fechaNacimiento = new Date(arreglo)
      let edad = hoy.getFullYear() - fechaNacimiento.getFullYear()
      let diferenciaMeses = hoy.getMonth() - fechaNacimiento.getMonth()
      if ( diferenciaMeses < 0 || (diferenciaMeses === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
        edad--
      }
      $(''+campo+'').val(edad)
    }
    function getMunicipios(id_estado, selector, id_municipio) {
      $.ajax({
        url: '<?php echo base_url('Funciones/getMunicipios'); ?>',
        method: 'POST',
        data: {
          'id_estado': id_estado
        },
        success: function(res) {
          $(""+selector+"").html(res);
          $(""+selector+"").val(id_municipio)
        }
      });
    }
    function getDataCatalogo(url_data, referencia, opcion_no_aplica){
      let options = '<option value="">Selecciona</option>';
      if(opcion_no_aplica == 1)
        options += '<option value="No aplica">No aplica</option>';
      $.ajax({
        url: url_data,
        method: 'POST',
        async:false,
        success: function(res){
          if(res != 0){
            rows = JSON.parse(res);
            for(let i = 0; i < rows.length; i++){
              options += '<option value="'+rows[i][referencia]+'">'+rows[i]['nombre']+'</option>';
            }
          }
        }
      });
      return options;
    }
    function changeOptionSocial(selector, clase){
      if(selector == 1){
        $(clase).val('')
      }
      else{
        $(clase).val('No aplica')
      }
    }
    function changeOptionFinanzas(selector, clase){
      if(selector == 1){
        $(clase).val('')
        $(clase+'_numerico').val(0)
      }
      else{
        $(clase).val('No aplica')
        $(clase+'_numerico').val(0)
      }
    }
		function fechaCompletaAFront(fecha) {
			var f = fecha.split(' ');
			var aux = f[0].split('-');
			var date = aux[2] + '/' + aux[1] + '/' + aux[0];
			return date;
		}
		function fechaSimpleAFront(fecha) {
			var aux = fecha.split('-');
			var f = aux[2] + '/' + aux[1] + '/' + aux[0];
			return f;
		}
	</script>
</body>

</html>