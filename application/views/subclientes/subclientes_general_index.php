<!DOCTYPE html>
<html class="html-subcliente">
    
  <meta charset="UTF-8">
	<title><?php echo strtoupper($this->session->userdata('subcliente')); ?> | RODI</title>
	<link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url() ?>css/subcliente.css">
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<script src="https://kit.fontawesome.com/fdf6fee49b.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<!-- Select Bootstrap -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
	<!-- Sweetalert 2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
	<link rel="icon" type="image/jpg" href="<?php echo base_url() ?>img/favicon.jpg" sizes="64x64">

  </head>
  <body >
    <!--Modal--> 
    <div class="modal fade" id="bloqueoModal" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="titulo_modal"></h4>
          </div>
          <div class="modal-body">
            <div id="mensaje_modal"></div>
            <div class="text-center"><img src="<?php echo base_url() ?>/img/block_image.svg" alt="blocked access" width="30%"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="newModal" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Registrar candidato</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-info text-center">Datos Generales</div>
            <form id="nuevoRegistroForm">
              <div class="row">
                <div class="col-4">
                  <label>Nombre(s) *</label>
                  <input type="text" class="form-control obligado" name="nombre_registro" id="nombre_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                  <br>
                </div>
                <div class="col-4">
                  <label>Apellido paterno *</label>
                  <input type="text" class="form-control obligado" name="paterno_registro" id="paterno_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                  <br>
                </div>
                <div class="col-4">
                  <label>Apellido materno</label>
                  <input type="text" class="form-control" name="materno_registro" id="materno_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                  <br>
                </div>
              </div>
              <div class="row">
                <div class="col-4">
                  <label>Puesto *</label>
                  <select name="puesto" id="puesto" class="form-control obligado">
                    <option value="">Selecciona</option>
                    <?php
                    foreach ($puestos as $p) { ?>
                      <option value="<?php echo $p->id; ?>"><?php echo $p->nombre; ?></option>
                    <?php
                    } ?>
                  </select>
                  <br>
                </div>
                <div class="col-4">
                  <label>Teléfono *</label>
                  <input type="text" class="form-control obligado" name="celular_registro" id="celular_registro" maxlength="16">
                  <br>
                </div>
                <div class="col-4">
                  <label>País donde reside *</label>
                  <select class="form-control" id="pais" name="pais">
                    <?php
                      foreach ($paises as $p) {
                        $default = ($p->nombre == 'México')? 'selected' : ''; ?>
                        <option value="<?php echo $p->nombre; ?>" <?php echo $default ?>><?php echo $p->nombre; ?></option>
                      <?php
                      } 
                    ?>
                  </select>
                  <br>
                </div>
              </div>
              <div class="row">
              <?php 
              if($this->session->userdata('idcliente') == 159){  ?>
                <div class="col-4">
                  <label>Centro de costos </label>
                  <input type="text" class="form-control obligado" name="centro_costo" id="centro_costo">
                  <br>
                </div>
                <div class="col-4">
                  <label>CURP *</label>
                  <input type="text" class="form-control obligado" name="curp_registro" id="curp_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" maxlength="18">
                  <br>
                </div>
                <div class="col-4">
                  <label>Numero de Seguro Social (NSS) *</label>
                  <input type="text" class="form-control obligado" name="nss_registro" id="nss_registro" maxlength="11">
                  <br>
                </div>
              <?php
              } 
              ?>
              </div>
              <!--div class="alert alert-warning text-center">Elige si se llevará a cabo un proceso registrado previamente o si es un proceso nuevo <br>Notas: <br>
                <ul class="text-left">
                  <li>Si se elige un proceso previo, se omitirán las opciones elegidas de la sección de proceso nuevo (en caso de haber).</li>
                  <li>Los exámenes complementarios son opcionales.</li>
                  <li>Los candidatos previamente concluidos corresponden al proceso General.</li>
                </ul> 
              </div-->
              <div class="alert alert-info text-center">Selecciona un proceso</div>
              <div class="row">
                <div class="col-12">
                  <label>Proceso</label>
                  <select class="form-control" name="previos" id="previos"></select><br>
                </div>
              </div>
              <div id="detalles_previo"></div>
              <!--div class="alert alert-info text-center div_info_check">Crear un proceso nuevo</div>
              <div class="row div_check">
                <div class="col-12">
                  <label>Nombre del proceso *</label>
                  <input type="text" class="form-control" name="proyecto_registro" id="proyecto_registro">
                  <br>
                </div>
              </div>
              <div class="row div_check">
                <div class="col-4">
                  <label>Datos generales *</label>
                  <select name="generales_registro" id="generales_registro" class="form-control">
                    <option value="" selected>Selecciona</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                  </select>
                  <br>
                </div>
                <div class="col-4">
                  <label>Historial académico *</label>
                  <select name="estudios_registro" id="estudios_registro" class="form-control">
                    <option value="" selected>Selecciona</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                  </select>
                  <br>
                </div>
                <div class="col-4">
                  <label>Antecedentes sociales *</label>
                  <select name="sociales_registro" id="sociales_registro" class="form-control">
                    <option value="" selected>Selecciona</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                  </select>
                  <br>
                </div>
              </div>
              <div class="row div_check">
                <div class="col-4">
                  <label>Referencias personales *</label>
                  <select name="ref_personales_registro" id="ref_personales_registro" class="form-control">
                    <option value="" selected>Selecciona</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                  </select>
                  <br>
                </div>
                <div class="col-4">
                  <label>Referencias laborales *</label>
                  <select name="empleos_registro" id="empleos_registro" class="form-control">
                    <option value="" selected>Selecciona</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                  </select>
                  <br>
                </div>
                <div class="col-4">
                  <label>Investigación legal *</label>
                  <select name="investigacion_registro" id="investigacion_registro" class="form-control">
                    <option value="" selected>Selecciona</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                  </select>
                  <br>
                </div>
              </div>
              <div class="row div_check">
                <div class="col-4">
                  <label>Trabajos no mencionados *</label>
                  <select name="no_mencionados_registro" id="no_mencionados_registro" class="form-control">
                    <option value="" selected>Selecciona</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                  </select>
                  <br>
                </div>
                <div class="col-4">
                  <label>Documentación *</label>
                  <select name="documentacion_registro" id="documentacion_registro" class="form-control">
                    <option value="" selected>Selecciona</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                  </select>
                  <br>
                </div>
                <div class="col-4">
                  <label>Información del grupo familiar *</label>
                  <select name="familiar_registro" id="familiar_registro" class="form-control">
                    <option value="" selected>Selecciona</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                  </select>
                  <br>
                </div>
              </div>
              <div-- class="row div_check">
                <div class="col-4">
                  <label>Ingresos y egresos *</label>
                  <select name="egresos_registro" id="egresos_registro" class="form-control">
                    <option value="" selected>Selecciona</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                  </select>
                  <br>
                </div>
                <div class="col-4">
                  <label>Habitación y medio ambiente *</label>
                  <select name="habitacion_registro" id="habitacion_registro" class="form-control">
                    <option value="" selected>Selecciona</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                  </select>
                  <br>
                </div>
                <div class="col-4">
                  <label>Referencias vecinales *</label>
                  <select name="ref_vecinales_registro" id="ref_vecinales_registro" class="form-control">
                    <option value="" selected>Selecciona</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                  </select>
                  <br>
                </div>
              </div-->
              <div class="alert alert-danger text-center">Exámenes complementarios</div>
              <div class="row">
                <div class="col-4">
                  <label>Examen antidoping *</label>
                  <select name="examen_registro" id="examen_registro" class="form-control registro_obligado">
                    <option value="">Selecciona</option>
                    <option value="0" selected>N/A</option>
                    <?php
                    foreach ($paquetes_antidoping as $paq) { ?>
                      <option value="<?php echo $paq->id; ?>"><?php echo $paq->nombre.' ('.$paq->conjunto.')'; ?></option>
                    <?php
                    } ?>
                  </select>
                  <br>
                </div>
                <div class="col-4">
                  <label>Examen médico *</label>
                  <select name="examen_medico" id="examen_medico" class="form-control registro_obligado">
                    <option value="0">N/A</option>
                    <option value="1">Aplicar</option>
                  </select>
                  <br>
                </div>
                <div class="col-4">
                  <label>Psicometría *</label>
                  <select name="examen_psicometrico" id="examen_psicometrico" class="form-control registro_obligado">
                    <option value="0">N/A</option>
                    <option value="1">Aplicar</option>
                  </select>
                  <br>
                </div>
              </div>
              <div class="alert alert-info text-center">Carga de CV o solicitu de empleo</div>
              <div class="row">
                <div class="col-12">
                  <label>Cargar CV o solicitud de empleo del candidato</label>
                  <input type="file" id="cv" name="cv" class="form-control" accept=".pdf, .jpg, .jpeg, .png" multiple><br>
                </div>
              </div>
            </form>
            <div id="msj_error" class="alert alert-danger hidden"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-success" onclick="registrar()">Registrar</button>
          </div>
        </div>
      </div>
    </div>
		<div class="modal fade" id="avancesModal" role="dialog" data-backdrop="static" data-keyboard="false">
	  	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		    <div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Mensajes de avances del candidato: <br><span class="nombreCandidato"></span> </h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div id="div_avances"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>
		    </div>
	 		</div>
		</div>
		<div class="modal fade" id="statusModal" role="dialog" data-backdrop="static" data-keyboard="false">
	  	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		    <div class="modal-content">
		      	<div class="modal-header">
		        	<h4 class="modal-title">Estatus del proceso del candidato: <br><span class="nombreCandidato"></span></h4>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
			          <span aria-hidden="true">&times;</span>
			        </button>
		      	</div>
		      	<div class="modal-body">
		      		<div id="div_status"></div>
		      	</div>
		      	<div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
									<label>key *</label>
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
		<div class="modal fade" id="avisoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-body">
						<div class="mt-5">
							<div class="alert alert-warning text-center" role="alert">
								<h3>Algunas mejoras han sido implementadas</h3>
							</div>
							<div class="text-center mt-3">
								<img src="<?php echo base_url() ?>img/cambios_perfil.svg" width="400" height="300">
							</div>
							<div class="text-left">
								<h3>Una mejora en la seguridad de información ha sido añadida. Favor de ver el siguiente video:</h3>
								<div class="text-center">
									<video id="video" width="750" height="500" controls>
										<source src="<?php echo base_url() ?>video/ExplicacionClaveClientesEspanol.mp4" type="video/mp4">
										Tu navegador no soporta la inclusión de videos.
									</video>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
    <!--NavBar-->
    <header>
    	<nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu">
			  <a class="navbar-brand text-light" href="#">
			   <img src="<?php echo base_url() ?>img/favicon.jpg" class="space">
			    <?php echo $this->session->userdata('nombre')." ".$this->session->userdata('paterno'); ?>
			  </a>
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav ml-auto">
						<?php 
						if($this->session->userdata('idcliente') != 16){ ?>
			      <li class="nav-item active">
			        <a class="nav-link text-light font-weight-bold" href="javascript:void(0)" onclick="nuevoRegistro()"><i class="fas fa-plus-circle"></i> Registrar candidato</a>
			      </li>
						<?php 
						} ?>
						<li class="nav-item">
							<a class="nav-link text-light font-weight-bold" href="javascript:void(0)" onclick="editarPerfil()"><i class="fas fa-user"></i> Editar perfil</a>
						</li>
			      <li class="nav-item">
			        <a class="nav-link text-light font-weight-bold" id="btnCerrarSesion" href="<?php echo base_url(); ?>Login/logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
			      </li>
			    </ul>
			  </div>
			</nav>
    </header>
    <?php 
    if(empty($bloqueo)){
      $estaBloqueado = 0;
      $mensaje = ''; ?>
      <!-- Valores Generales -->
      <input type="hidden" name="idSubcliente" id="idSubcliente" value="<?php echo $this->session->userdata('idsubcliente'); ?>">
      <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $this->session->userdata('idcliente'); ?>">
      <!--Cuerpo-->
      <div class="loader" style="display: none;"></div>
      <div class="contenedor mt-5 my-5">
        <select name="buscador" id="buscador" class="form-control selectpicker" data-live-search="true">
          <option value="0">VER TODOS</option>
          <?php
          if ($candidatos) {
            foreach ($candidatos as $can) { ?>
              <option value="<?php echo $can->id; ?>"><?php echo $can->candidato; ?></option>
          <?php 
            }
          } ?>
        </select>
      </div>
      <div class="contenedor">
        <div class="row mb-5">
          <?php 
          if($candidatos != "" && $candidatos != null){
            foreach($candidatos as $c){
              //$proyecto = ($c->proyecto == "" || $c->proyecto == null)? "":$c->proyecto;
              $cliente = $c->cliente." / ".$c->subcliente;
              $e = new DateTime($c->fecha_alta);
              $fecha = $e->format('d/m/Y H:h');
              //Color tarjeta
              $color_tarjeta = ($c->socioeconomico == 1)? 'color_socio':'color_antidoping';
              //Color icono avances
              $color_avances = ($c->idAvance != null)? '':'gris';
              //Estatus proceso
              $idEstudios = ($c->idEstudios != null)? $c->idEstudios:0;
              $idSociales = ($c->idSociales != null)? $c->idSociales:0;
              $idPersonales = ($c->idPersonales != null)? $c->idPersonales:0;
              $idLaborales = ($c->idLaborales != null)? $c->idLaborales:0;
              $idLegales = ($c->idLegales != null)? $c->idLegales:0;
              $socio = $c->socioeconomico;
              //Psicometria
              if($c->psicometrico == 1){
                if($c->archivo != null){
                  $color_psicometria = 'azul';
                  $href_psicometria = base_url()."_psicometria/".$c->archivo;
                  $alerta_psicometria = 'alerta_descarga';
                }
                else{
                  $color_psicometria = 'amarillo';
                  $href_psicometria = "javascript:void(0)";
                  $alerta_psicometria = '';
                }
              }
              else{
                $color_psicometria = 'gris';
                $href_psicometria = "javascript:void(0)";
                $alerta_psicometria = '';
              }
              //Examen Medico
              if ($c->medico == 1) {
                if($c->idMedico != null){
                  if ($c->conclusion != null && $c->descripcion != null) {
                    $res_medico = '<div><form id="formMedico' . $c->idMedico . '" action="'.base_url('Medico/crearPDF').'" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado" id="pdfMedico" data-id="' . $c->idMedico . '" class="fa-tooltip icono azul alerta_descarga"><i class="fas fa-notes-medical"></i></a><input type="hidden" name="idMedico" id="idMedico' . $c->idMedico . '" value="' . $c->idMedico . '"></form></div>';
                  } 
                  else {
                    $res_medico = '<a href="javascript:void(0);" data-toggle="tooltip" class="fa-tooltip icono naranja"><i class="fas fa-notes-medical"></i></a>';
                  }
                }
                else{
                  $res_medico = '<a href="javascript:void(0);" data-toggle="tooltip" class="fa-tooltip icono amarillo"><i class="fas fa-notes-medical"></i></a>';
                }
              } 
              else {
                $res_medico = '<a href="javascript:void(0);" data-toggle="tooltip" class="fa-tooltip icono gris"><i class="fas fa-notes-medical"></i></a>';
              }
              //Antidoping
              if($c->tipo_antidoping == 1){
                if($c->doping_hecho == 1){
                  if($c->fecha_resultado != null){
                    if($c->resultado_doping == 1){
                      $res_doping = '<div><form id="pdfForm' . $c->idDoping . '" action="'.base_url('Doping/createPDF').'" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado" id="pdfDoping" data-id="' . $c->idDoping . '" class="fa-tooltip icono rojo alerta_descarga"><i class="fas fa-eye-dropper"></i></a><input type="hidden" name="idDop" id="idDop' . $c->idDoping . '" value="' . $c->idDoping . '"></form></div>';
                    }
                    else{
                      $res_doping = '<div><form id="pdfForm' . $c->idDoping . '" action="'.base_url('Doping/createPDF').'" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado" id="pdfDoping" data-id="' . $c->idDoping . '" class="fa-tooltip icono verde alerta_descarga"><i class="fas fa-eye-dropper"></i></a><input type="hidden" name="idDop" id="idDop' . $c->idDoping . '" value="' . $c->idDoping . '"></form></div>';
                    }
                  }
                  else{
                    $res_doping = '<a href="javascript:void(0);" data-toggle="tooltip" class="fa-tooltip icono naranja"><i class="fas fa-eye-dropper"></i></a>';
                  }
                }
                else{
                  $res_doping = '<a href="javascript:void(0);" data-toggle="tooltip" class="fa-tooltip icono amarillo"><i class="fas fa-eye-dropper"></i></a>';
                }
              }
              else{
                $res_doping = '<a href="javascript:void(0);" data-toggle="tooltip" class="fa-tooltip icono gris"><i class="fas fa-eye-dropper"></i></a>';
              }
              //Reporte final
              if($c->status_bgc != 0){
                if($c->liberado == 1){
                  switch($c->status_bgc){
                    case 1:
                    case 4:
                      $color_final = 'verde';
                      break;
                    case 2:
                      $color_final = 'rojo';
                      break;
                    case 3:
                    case 5:
                      $color_final = 'amarillo';
                      break;
                  }
                  if($c->status_bgc > 0){
                    if($c->id_cliente == 159){
                      if($c->status_bgc == 1 || $c->status_bgc == 4){
                        $res_final = '<div style="display: inline-block;"><form id="formBGV'.$c->id.'" action="'.base_url('Candidato_Conclusion/createPDF').'" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte PDF" id="pdfFinal" data-id="'. $c->id.'" class="fa-tooltip alerta_descarga icono '.$color_final.'"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idCandidatoPDF" id="idCandidatoPDF'.$c->id.'" value="'.$c->id.'"></form></div>';
                      }
                      else{
                        $res_final = '<div style="display: inline-block;"><form id="reportePrevioForm'.$c->id.'" action="'.base_url('Candidato_Conclusion/createPrevioPDF').'" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte previo" id="reportePrevioPDF" data-id="'. $c->id.'" class="fa-tooltip alerta_descarga icono '.$color_final.'"><i class="far fa-file-powerpoint"></i></a><input type="hidden" name="idPDF" id="idPDF'.$c->id.'" value="'.$c->id.'"></form></div>';
                      }
                    }
                    else{
                      $res_final = '<div style="display: inline-block;"><form id="formBGV'.$c->id.'" action="'.base_url('Candidato_Conclusion/createPDF').'" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte PDF" id="pdfFinal" data-id="'. $c->id.'" class="fa-tooltip alerta_descarga icono '.$color_final.'"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idCandidatoPDF" id="idCandidatoPDF'.$c->id.'" value="'.$c->id.'"></form></div>';
                    }
                  }
                  else{
                    $res_final = '<a href="javascript:void(0);" data-toggle="tooltip" class="fa-tooltip icono gris"><i class="fas fa-file-pdf"></i></a>';
                  }
                  
                }
                else{
                  if($c->fecha_nacimiento != null && $c->fecha_nacimiento != '0000-00-00'){
                    $res_final = '<div style="display: inline-block;"><form id="reportePrevioForm'.$c->id.'" action="'.base_url('Candidato_Conclusion/createPrevioPDF').'" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte previo" id="reportePrevioPDF" data-id="'. $c->id.'" class="fa-tooltip alerta_descarga icono gris"><i class="far fa-file-powerpoint"></i></a><input type="hidden" name="idPDF" id="idPDF'.$c->id.'" value="'.$c->id.'"></form></div>';
                  }
                  else{
                    $res_final = '<a href="javascript:void(0);" data-toggle="tooltip" class="fa-tooltip icono gris"><i class="fas fa-file-pdf"></i></a>';
                  }
                }
              }
              else{
                if($c->fecha_nacimiento != null && $c->fecha_nacimiento != '0000-00-00'){
                  $res_final = '<div style="display: inline-block;"><form id="reportePrevioForm'.$c->id.'" action="'.base_url('Candidato_Conclusion/createPrevioPDF').'" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte previo" id="reportePrevioPDF" data-id="'. $c->id.'" class="fa-tooltip alerta_descarga icono gris"><i class="far fa-file-powerpoint"></i></a><input type="hidden" name="idPDF" id="idPDF'.$c->id.'" value="'.$c->id.'"></form></div>';
                }
                else{
                  $res_final = '<a href="javascript:void(0);" data-toggle="tooltip" class="fa-tooltip icono gris"><i class="fas fa-file-pdf"></i></a>';
                }
              }
              //Procesp
              $proceso = ($c->subproyecto != null)? ' <p><b>'.$c->subproyecto.'</b></p>' : '';
              //Centro de costo
              $centro_costo = ($c->centro_costo != null)? ' <small>Centro de costo: '.$c->centro_costo.'</small>' : '';
              ?>
            <div class="col-sm-12 col-md-12 col-lg-6 ">
              <div class="card carta mt-3 <?php echo $color_tarjeta ?> " id='<?php echo $c->id; ?>'>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4 mr text-center">
                      <img src="<?php echo base_url() ?>/img/user.png" class="profile" width="140" height="140">
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-8 mr-text">
                      <div class="text-center">
                        <h5 class="card-title my-1"><b><?php echo $c->candidato?></b></h5>
                        <?php echo $proceso . $centro_costo; ?>
                        <p><?php echo $cliente?></p>
                        <p><b><?php echo "Alta: ".$fecha ?></b></p>
                      </div>
                      <?php 
                      if($c->cancelado == 0){ ?>
                        <div class="row mt-1">
                          <div class="col-2 mr-7 text-center">
                            <?php 
                            if($socio == 1){ ?>
                              <a href="javascript:void(0)" data-toggle="tooltip" title="Mensajes de avances" class="fa-tooltip icono <?php echo $color_avances; ?> " onclick="verAvances('<?php echo $c->candidato ?>',<?php echo $c->id ?>)"><i class="fas fa-comment-dots"></i></a>
                            <?php 
                            } ?>
                          </div>
                          <!--div class="col-2 mr-7 text-center">
                            <?php /*
                            if($socio == 1){ ?>
                              <a href="javascript:void(0)" data-toggle="tooltip" title="Estatus proceso" class="fa-tooltip icono" onclick="verEstatus('<?php echo $c->candidato ?>',<?php echo $c->visitador ?>,<?php echo $idEstudios ?>,<?php echo $idSociales ?>,<?php echo $idPersonales ?>,<?php echo $idLaborales ?>,<?php echo $idLegales ?>)"><i class="fas fa-eye"></i></a>
                            <?php 
                            }*/ ?>
                          </!--div-->
                          <div class="col-2 mr-7 text-center">
                            <?php 
                            if($socio == 1){ ?>
                              <a href="<?php echo $href_psicometria; ?>" data-toggle="tooltip" download="" title="Psicometria" class="fa-tooltip icono <?php echo $alerta_psicometria; ?> <?php echo $color_psicometria; ?> "><i class="fas fa-brain"></i></a>
                            <?php 
                            } ?>
                          </div>
                          <div class="col-2 mr-7 text-center">
                            <?php echo $res_medico; ?>
                          </div>
                          <div class="col-2 mr-7 text-center">
                            <?php echo $res_doping; ?>
                          </div>
                          <div class="col-2 mr-7 text-center">
                            <?php
                            if($socio == 1){
                              echo $res_final; 
                            }?>
                          </div>
                        </div>
                      <?php 
                      } ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php 
            }
          }
          else{ ?>
            <div class="div_item_contenedor mt-5">
              <div class="col-md-12">
                <div class="div_item">
                  <p class="text-center">Sin registro de candidatos</p>
                </div>
              </div>
            </div>
      <?php 
          }
      ?>
        </div>
      </div>
    <?php 
    }else{
      $estaBloqueado = 1;
      $mensaje = $bloqueo->mensaje;
    } ?>

		<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
		<!-- Sweetalert 2 -->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
		<!-- Bootstrap Select -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script>
      function finishSession(){
        let timerInterval;
        setTimeout(() => {
          Swal.fire({
            title: '¿Desea mantener su sesion?',
            showClass: {
              popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
              popup: 'animate__animated animate__fadeOutUp'
            },
            html: 'Su sesión finalizará en <strong></strong> segundos<br/><br/>',
            showDenyButton: true,
            confirmButtonText: 'Mantener sesión',
            denyButtonText: 'Salir de la plataforma',
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
              const cerrarSesion = document.getElementById('btnCerrarSesion')
              cerrarSesion.click()
            } 
          })
        }, 7200000);
      }
      finishSession();
    </script>
		<script>
			$(document).ready(function(){
				//$('#avisoModal').modal('show')
        let estaBloqueado = 0; let mensajeBloqueado = '';
        estaBloqueado = <?php echo $estaBloqueado; ?>;
        mensajeBloqueado = '<?php echo $mensaje; ?>';
        if (estaBloqueado == 1) {
          $('#bloqueoModal #titulo_modal').html('MENSAJE IMPORTANTE <i class="fas fa-exclamation-triangle"></i>');
          $('#bloqueoModal #mensaje_modal').html('<h5 class="mt-3 mb-3">'+mensajeBloqueado+'</h5>');
          $('#bloqueoModal').modal('show');
        }

				var msj = localStorage.getItem("success");
				if (msj == 1) {
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'El candidato fue agregado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
					localStorage.removeItem("success");
				}
				$('.alerta_descarga').click(function(){
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Si cuenta con internet el archivo se descargará en breve',
						showConfirmButton: false,
						timer: 4000
					})
				});
				$('a[id^=pdfDoping]').click(function(){
					var id = $(this).data('id')
					$('#pdfForm'+id).submit();
				})
				$('a[id^=pdfFinal]').click(function(){
					var id = $(this).data('id')
					$('#formBGV'+id).submit();
				})
				$('a[id^=pdfMedico]').click(function(){
					var id = $(this).data('id');
					$('#formMedico' + id).submit();
				});
        $('a[id^=reportePrevioPDF]').click(function(){
          var id = $(this).data('id')
          $('#reportePrevioForm' + id).submit();
        });
				$('#buscador').change(function(){
					var opcion = $(this).val();
					if(opcion == 0){
						$('.carta').css('display','block');
					}
					else{
						$(".carta").css('display','none');
						$('#'+opcion).css('display','block');
					}
				})
				$('#antidoping').change(function(){
					var opcion = $(this).val();
					var id_subcliente = $("#idSubcliente").val();
					var id_cliente = $("#idCliente").val();
					if(opcion == 1){
						$("#examen").prop('disabled',false);
						$.ajax({
							url: '<?php echo base_url('Doping/getPaqueteSubcliente'); ?>',
							method: 'POST',
							data: {
								'id_subcliente': id_subcliente,
								'id_cliente': id_cliente,
								'id_proyecto': 0
							},
							beforeSend: function() {
								$('.loader').css("display", "block");
							},
							success: function(res) {
								setTimeout(function() {
									$('.loader').fadeOut();
								}, 200);
								if (res != "") {
									$('#examen').val(res);
									$("#examen").prop('disabled', false);
									$("#examen").addClass('obligado');
								} else {
									$('#examen').val('');
									$("#examen").prop('disabled', false);
									$("#examen").addClass('obligado');
								}
							}
						});
					}
					else{
						$("#examen").val('');
						$("#examen").prop('disabled',true);
					}
				})
        $("#previos").change(function(){
          var previo = $(this).val();
          if(previo != 0){
            //$('.div_check').css('display','none');
            //$('.div_info_check').css('display','none');
            $.ajax({
              url: '<?php echo base_url('Candidato_Seccion/getDetallesProyectoPrevio'); ?>',
              method: 'POST',
              data: {'id_previo':previo},
              success: function(res)
              {
                $('#detalles_previo').empty();
                $('#detalles_previo').html(res);
              }
            });
          }
          else{
            //$('.div_check').css('display','flex');
            //$('.div_info_check').css('display','block');
            $('#detalles_previo').empty();
          }
        });
				$("#newModal").on("hidden.bs.modal", function() {
          $("#newModal input, #newModal select, #newModal textarea").val('');
          $("#newModal #msj_error").css('display', 'none');
          $("#examen_registro,#examen_medico,#examen_psicometrico").val(0);
          $("#pais").val('México');
          $('#detalles_previo').empty();
        })
				$('#perfilUsuarioModal').on('hidden.bs.modal', function(e) {
					$("#perfilUsuarioModal #msj_error").css('display', 'none');
				});
				$('#confirmarPasswordModal').on('hidden.bs.modal', function(e) {
					$("#confirmarPasswordModal #msj_error").css('display', 'none');
					$("#confirmarPasswordModal input").val('');
				});
			})
			function nuevoRegistro(){
        var id_cliente = '<?php echo $this->session->userdata('idcliente') ?>';
        $.ajax({
          url: '<?php echo base_url('Candidato_Seccion/getHistorialProyectosByCliente'); ?>',
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
        var id_cliente = '<?php echo $this->session->userdata('idcliente') ?>';
        if(id_cliente == 159){
          var centro_costo = $("#centro_costo").val();
          var curp = $('#curp_registro').val();
          var nss = $('#nss_registro').val();
        }
        else{
          var centro_costo = '';
          var curp = '';
          var nss = '';
        }
        var datos = new FormData();
        datos.append('nombre', $("#nombre_registro").val());
        datos.append('paterno', $("#paterno_registro").val());
        datos.append('materno', $("#materno_registro").val());
        datos.append('celular', $("#celular_registro").val());
			  datos.append('subcliente', '<?php echo $this->session->userdata('idsubcliente') ?>');
        datos.append('puesto', $("#puesto").val());
        datos.append('previo', $("#previos").val());
        datos.append('id_cliente', id_cliente);
        datos.append('examen', $("#examen_registro").val());
        datos.append('medico', $("#examen_medico").val());
        datos.append('psicometrico', $("#examen_psicometrico").val());
		    datos.append('centro_costo', centro_costo);
        datos.append('curp', curp);
		    datos.append('nss', nss);
        datos.append('usuario', 3);

        var num_files = document.getElementById('cv').files.length;
        if (num_files > 0) {
          datos.append("hay_cvs", 1);
          for (var x = 0; x < num_files; x++) {
            datos.append("cvs[]", document.getElementById('cv').files[x]);
          }
        } else {
          datos.append("hay_cvs", 0);
        }

        $.ajax({
          url: '<?php echo base_url('Cliente_General/registrar'); ?>',
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
              localStorage.setItem('success', 1);
              location.reload();
            } else {
              $("#newModal #msj_error").css('display', 'block').html(data.msg);
            }
          }
        });	
      }
			function verAvances(candidato,id){
				$('.nombreCandidato').text(candidato)
				$.ajax({
					url: '<?php echo base_url('Candidato/viewAvances'); ?>',
					type: 'post',
					data: {'id_candidato':id,'espanol':1},
					success : function(res){ 
						$("#div_avances").html(res);
					}
				});
				$("#avancesModal").modal("show");
			}
			function verEstatus(candidato,visitador,idEstudios,idSociales,idPersonales,idLaborales,idLegales){
				var salida = "";
				var visitado = (visitador == 0)? "<tr><th>Documentación</th><th>En proceso</th></tr><tr><th>Datos del grupo familiar</th><th>En proceso</th></tr><tr><th>Egresos mensuales</th><th>En proceso</th></tr><tr><th>Habitación y medio ambiente</th><th>En proceso</th></tr><tr><th>Referencias vecinales</th><th>En proceso</th></tr>":"<tr><th>Documentación</th><th>Terminado</th></tr><tr><th>Datos del grupo familiar</th><th>Terminado</th></tr><tr><th>Egresos mensuales</th><th>Terminado</th></tr><tr><th>Habitación y medio ambiente</th><th>Terminado</th></tr><tr><th>Referencias vecinales</th><th>Terminado</th></tr>";

				var estudios = (idEstudios == 0)? "<tr><th>Historial académico </th><th>En proceso</th></tr>":"<tr><th>Historial académico </th><th>Terminado</th></tr>";
				var sociales = (idSociales == 0)? "<tr><th>Antecedentes sociales </th><th>En proceso</th></tr>":"<tr><th>Antecedentes sociales </th><th>Terminado</th></tr>";
				var personales = (idPersonales == 0)? "<tr><th>Referencias personales </th><th>En proceso</th></tr>":"<tr><th>Referencias personales </th><th>Terminado</th></tr>";
				var laborales = (idLaborales == 0)? "<tr><th>Antecedentes laborales </th><th>En proceso</th></tr>":"<tr><th>Antecedentes laborales </th><th>Terminado</th></tr>";
				var legales = (idLegales == 0)? "<tr><th>Investigación legal </th><th>En proceso</th></tr>":"<tr><th>Investigación legal </th><th>Terminado</th></tr>";

				salida += '<table class="table table-striped">';
				salida += '<thead>';
				salida += '<tr>';
				salida += '<th scope="col">Concepto</th>';
				salida += '<th scope="col">Estatus</th>';
				salida += '</tr>';
				salida += '</thead>';
				salida += '<tbody>';
				salida += visitado;
				salida += estudios;
				salida += sociales;
				salida += personales;
				salida += laborales;
				salida += legales;
				salida += '</tbody>';
				salida += '</table>';
				$('.nombreCandidato').text(candidato)
				$("#div_status").html(salida);
				$("#statusModal").modal("show");
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
		</script>
       
	</body>
    
</html>