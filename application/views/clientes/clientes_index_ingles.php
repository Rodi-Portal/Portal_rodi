<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<title><?php echo strtoupper($this->session->userdata('cliente')); ?> | RODI</title>
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
	<!--link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css"-->
	<!--link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"-->

</head>

<body>
  <div class="modal fade" id="bloqueoModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="titulo_modal"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="mensaje_modal"></div>
          <div class="text-center"><img src="<?php echo base_url() ?>/img/block_image.svg" alt="blocked access" width="30%"></div>
        </div>
      </div>
    </div>
  </div>
  <div id="exito" class="alert alert-success in mensaje" style='display:none;'>
    <strong>Success!</strong> The candidate has been add succesfully
  </div>
  <div id="mensaje" class="alert alert-success in mensaje" style='display:none;'>
    <strong>Success!</strong>
    <p id="texto_msj"></p>
  </div>
  <div class="modal fade" id="newModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">New candidato</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-info text-center">Personal data</div>
          <form id="nuevoRegistroForm">
            <div class="row">
              <div class="col-4">
                <label>Name(s) *</label>
                <input type="text" class="form-control obligado" name="nombre_registro" id="nombre_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                <br>
              </div>
              <div class="col-4">
                <label>First lastname *</label>
                <input type="text" class="form-control obligado" name="paterno_registro" id="paterno_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                <br>
              </div>
              <div class="col-4">
                <label>Second lastname</label>
                <input type="text" class="form-control" name="materno_registro" id="materno_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>Sub-client *</label>
                <select name="subcliente" id="subcliente" class="form-control obligado">
                  <option value="">Select</option>
                  <?php
                  if ($subclientes) {
                    foreach ($subclientes as $sub) { ?>
                      <option value="<?php echo $sub->id; ?>"><?php echo $sub->nombre; ?></option>
                    <?php   }
                    echo '<option value="0">N/A</option>';
                  } else { ?>
                    <option value="0">N/A</option>

                  <?php } ?>
                </select>
                <br>
              </div>
              <?php 
              $id_cliente = $this->session->userdata('idcliente');
              if($id_cliente != 172 && $id_cliente != 178 && $id_cliente != 205 && $id_cliente != 235 && $id_cliente != 1){ ?>
                <div class="col-4">
                  <label>Job position *</label>
                  <select name="puesto" id="puesto" class="form-control obligado">
                    <option value="">Select</option>
                    <?php
                    foreach ($puestos as $p) { ?>
                      <option value="<?php echo $p->id; ?>"><?php echo $p->nombre; ?></option>
                    <?php
                    } ?>
                  </select>
                  <br>
                </div>
              <?php 
              }
              else{ ?>
                <div class="col-4">
                  <label>Job position *</label>
                  <input type="text" class="form-control obligado" name="puesto" id="puesto">
                  <br>
                </div>
              <?php
              } ?>
              <div class="col-4">
                <label>Telephone number *</label>
                <input type="text" class="form-control obligado" name="celular_registro" id="celular_registro" maxlength="16">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>Country of residence *</label>
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
              <div class="col-4">
                <label>Email account </label>
                <input type="text" class="form-control obligado" name="correo_registro" id="correo_registro">
                <br>
              </div>
              <?php 
              if($this->session->userdata('idcliente') == 159){  ?>
                <div class="col-4">
                  <label>Centro de costos </label>
                  <input type="text" class="form-control obligado" name="centro_costo" id="centro_costo">
                  <br>
                </div>
              <?php
              } 
              ?>
            </div>
            <div class="row">
              <?php  
              if($this->session->userdata('idcliente') == 159){ ?>
                <div class="col-4">
                  <label>CURP *</label>
                  <input type="text" class="form-control obligado" name="curp_registro" id="curp_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" maxlength="18">
                  <br>
                </div>
                <div class="col-4">
                  <label>Social Security Number *</label>
                  <input type="text" class="form-control obligado" name="nss_registro" id="nss_registro" maxlength="11">
                  <br>
                </div>
              <?php  
              } ?>
            </div>
            <div class="alert alert-info text-center">Select a project</div>
            <div class="row">
              <div class="col-12">
                <label>Project</label>
                <select class="form-control" name="previos" id="previos"></select><br>
              </div>
            </div>
            <div id="detalles_previo"></div>
            <div class="alert alert-danger text-center">Complementary tests</div>
            <div class="row">
              <div class="col-4">
                <label>Doping test *</label>
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
              <div class="col-4">
                <label>Medical test *</label>
                <select name="examen_medico" id="examen_medico" class="form-control registro_obligado">
                  <option value="0">N/A</option>
                  <option value="1">Aplicar</option>
                </select>
                <br>
              </div>
              <div class="col-4">
                <label>Psychometric test *</label>
                <select name="examen_psicometrico" id="examen_psicometrico" class="form-control registro_obligado">
                  <option value="0">N/A</option>
                  <option value="1">Aplicar</option>
                </select>
                <br>
              </div>
            </div>
            <div class="alert alert-info text-center">Upload CV or job request</div>
            <div class="row">
              <div class="col-12">
                <label>Upload file</label>
                <input type="file" id="cv" name="cv" class="form-control" accept=".pdf, .jpg, .jpeg, .png" multiple><br>
              </div>
            </div>
          </form>
          <div id="msj_error" class="alert alert-danger hidden"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" onclick="registrar()">Add</button>
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
              <label for="motivo">Comment *</label>
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
          <h4 class="modal-title">Status of the candidate</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="nombreCandidato" class="text-center"></p>
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
          <h4 class="modal-title">Messages of process: <br><span class="nombreCandidato"></span></h4>
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
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
      
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu">
      <a class="navbar-brand text-light" href="#">
        <img src="<?php echo base_url() ?>/img/favicon.jpg" class="space">
        <?php echo $this->session->userdata('nombre') . " " . $this->session->userdata('paterno'); ?>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
          <?php 
          if($this->session->userdata('idcliente') == 16 || $this->session->userdata('idcliente') == 159 || $this->session->userdata('idcliente') == 172 || $this->session->userdata('idcliente') == 178 || $this->session->userdata('idcliente') == 205 || $this->session->userdata('idcliente') == 235 || $this->session->userdata('idcliente') == 1){ ?>
            <li class="nav-item">
              <a class="nav-link text-light font-weight-bold" href="javascript:void(0)" onclick="nuevoRegistro()"><i class="fas fa-plus-circle"></i> Add candidate</a>
            </li>
            <?php 
          } ?>
          <li class="nav-item">
            <a class="nav-link text-light font-weight-bold" href="javascript:void(0)" onclick="editarPerfil()"><i class="fas fa-user"></i> Edit profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light font-weight-bold" id="btnCloseSesion" href="<?php echo base_url(); ?>Login/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <?php 
    if(empty($bloqueo)){
      $estaBloqueado = 0;
      $mensaje = ''; ?>
      <div class="loader" style="display: none;"></div>
      <section>
        <div class="contenedor mt-5 my-5">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h4 class="mb-2 font-weight-bold text-primary  text-center">List of candidates</h4>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="tabla" class="table table-bordered" width="100%" cellspacing="0"></table>
              </div>
            </div>
          </div>
        </div>
      </section>
  <?php 
    }else{
      $estaBloqueado = 1;
      $mensaje = $bloqueo->mensaje;
    } ?>
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<!-- Sweetalert 2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
  <script>
    function finishSession(){
      let timerInterval;
      setTimeout(() => {
        Swal.fire({
          title: 'Do you want to keep session?',
          showClass: {
            popup: 'animate__animated animate__fadeInDown'
          },
          hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
          },
          html: 'Your session will finish in <strong></strong> segundos<br/><br/>',
          showDenyButton: true,
          confirmButtonText: 'Keep session',
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
            const CloseSesion = document.getElementById('btnCloseSesion')
            CloseSesion.click()
          } 
        })
      }, 7200000);
    }
    finishSession();
  </script>
	<script>
		$(document).ready(function() {
			//$('#avisoModal').modal('show')
      let estaBloqueado = 0; let mensajeBloqueado = '';
      
      estaBloqueado = <?php echo $estaBloqueado; ?>;
      mensajeBloqueado = '<?php echo $mensaje; ?>';
			if (estaBloqueado == 1) {
				$('#bloqueoModal #titulo_modal').html('MENSAJE IMPORTANTE <i class="fas fa-exclamation-triangle"></i>');
				$('#bloqueoModal #mensaje_modal').html('<h5 class="mt-3 mb-3">'+mensajeBloqueado+'</h5>');
				$('#bloqueoModal').modal('show');
			}
			var url = '<?php echo base_url('Cliente/getCandidatosCliente'); ?>';
			var psico = '<?php echo base_url(); ?>_psicometria/';

			changeDatatable(url, psico);
			$("#filtro_subcliente").change(function() {
				var subcliente = $(this).val();
				if (subcliente == 0) {
					var url = '<?php echo base_url('Cliente/getCandidatosCliente'); ?>';
					changeDatatable(url, psico);
				} else {
					var url = '<?php echo base_url('Subcliente/getCandidatosSubcliente?id_subcliente='); ?>' + subcliente;
					changeDatatable(url, psico);
				}
			});

			$("#tabla").DataTable().search(" ");
			$("#previos").change(function(){
        var previo = $(this).val();
        var id = <?php echo $this->session->userdata('idcliente') ?>;
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
          //TODO: Automatizar el valor dinamico de los examenes doping ligados al proceso
          if(id == 178){
            $.ajax({
              url: '<?php echo base_url('Doping/getExamenDopingByProceso'); ?>',
              method: 'POST',
              data: {'id_previo':previo},
              async: false,
              success: function(res)
              {
                $('#examen_registro').empty();
                $('#examen_registro').html(res);
              }
            });
          }
        }
        else{
          //$('.div_check').css('display','flex');
          //$('.div_info_check').css('display','block');
          $('#detalles_previo').empty();
        }
      });
			$('#perfilUsuarioModal').on('hidden.bs.modal', function(e) {
				$("#perfilUsuarioModal #msj_error").css('display', 'none');
			});
			$('#confirmarPasswordModal').on('hidden.bs.modal', function(e) {
				$("#confirmarPasswordModal #msj_error").css('display', 'none');
				$("#confirmarPasswordModal input").val('');
			});
		});
		//Proceso
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
        var centro_costo = null;
        var curp = '';
        var nss = '';
      }
			var datos = new FormData();
			datos.append('nombre', $("#nombre_registro").val());
			datos.append('paterno', $("#paterno_registro").val());
			datos.append('materno', $("#materno_registro").val());
			datos.append('celular', $("#celular_registro").val());
			datos.append('subcliente', $("#subcliente").val());
			datos.append('puesto', $("#puesto").val());
			datos.append('previo', $("#previos").val());
			datos.append('id_cliente', id_cliente);
			datos.append('examen', $("#examen_registro").val());
			datos.append('medico', $("#examen_medico").val());
			datos.append('psicometrico', $("#examen_psicometrico").val());
		  datos.append('correo', $("#correo_registro").val());
		  datos.append('centro_costo', centro_costo);
		  datos.append('curp', curp);
		  datos.append('nss', nss);
			datos.append('usuario', 2);

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
						recargarTable()
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Candidate saved successfully',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#newModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});	
		}
		function changeDatatable(url, psico) {
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
						title: 'id',
						data: 'id',
						visible: false
					},
					{
						title: 'Candidate',
						data: 'nombreCompleto',
						"width": "15%",
						mRender: function(data, type, full) {
              var centro_costo = (full.centro_costo != null && full.centro_costo != '' && full.centro_costo != 'null')? '<br><small>Centro de costo: '+full.centro_costo+'</small>' : '';
              var curp = (full.curp != null && full.curp != '' && full.curp != 'null')? '<br><small>CURP: '+full.curp+'</small>' : '';
              var nss = (full.nss != null && full.nss != '' && full.nss != 'null')? '<br><small>NSS: '+full.nss+'</small>' : '';
							return '<b><span data-toggle="tooltip" title="'+full.id+'">'+full.nombre + " " + full.paterno + " " + full.materno+'</span></b>' + centro_costo + curp + nss;
						}
					},
					{
						title: 'Sub-client',
						data: 'subcliente',
						"width": "15%",
						mRender: function(data, type, full) {
							var sub = (data == null || data == "") ? "N/A" : data;
							return sub;
						}
					},
          {
						title: 'Project',
						data: 'proyecto',
						"width": "17%",
						mRender: function(data, type, full) {
							var proceso = (data == null || data == "") ? "N/A" : data;
							return proceso;
						}
					},
					{
						title: 'Register Date',
						data: 'fecha_alta',
						"width": "10%",
						mRender: function(data, type, full) {
							var f = data.split(' ');
							var h = f[1];
							var aux = h.split(':');
							var hora = aux[0] + ':' + aux[1];
							var aux = f[0].split('-');
							var fecha = aux[2] + "/" + aux[1] + "/" + aux[0];
							var tiempo = fecha + ' ' + hora;
							return tiempo;
						}
					},
					{
						title: 'Status',
						data: 'visitador',
						"width": "8%",
						mRender: function(data, type, full) {
							return '<a href="javascript:void(0)" data-toggle="tooltip" data-accion="3" title="Mensajes de avances" id="msj_avances" class="fa-tooltip icono_datatable"><i class="fas fa-comment-dots"></i></a>';
						}
					},
					{
						title: 'Doping',
						data: 'id',
						bSortable: false,
						"width": "8%",
						mRender: function(data, type, full) {
							if (full.tipo_antidoping == 1) {
								if (full.fecha_resultado != null && full.fecha_resultado != "") {
									if (full.resultado_doping == 1) {
										return '<i class="fas fa-circle status_bgc2"></i> <div style="display: inline-block;margin-left:10px;"><form id="pdfForm' + full.idDoping + '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado" id="pdfDoping" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' + full.idDoping + '" value="' + full.idDoping + '"></form></div>';
									} else {
										return '<i class="fas fa-circle status_bgc1"></i> <div style="display: inline-block;margin-left:10px;"><form id="pdfForm' + full.idDoping + '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado" id="pdfDoping" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' + full.idDoping + '" value="' + full.idDoping + '"></form></div>';
									}

								} else {
									return "<i class='fas fa-circle status_bgc0'></i> Pending";
								}
							}
							if (full.tipo_antidoping == 0 || full.tipo_antidoping == "" || full.tipo_antidoping == null) {
								return "N/A";
							}
						}
					},
					{ title: 'Medic', data: 'id', width: '8%',
						mRender: function(data, type, full){
							if(full.cancelado == 0){
								if(full.medico == 1){
									if(full.idMedico != null){
										if(full.conclusion != null && full.descripcion != null){
											return '<div style="display: inline-block;"><form id="formMedico' + full.idMedico + '" action="<?php echo base_url('Medico/crearPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final" id="pdfMedico" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idMedico" id="idMedico' + full.idMedico + '" value="' + full.idMedico + '"></form></div>';
										}
										else{
											return "<i class='fas fa-circle status_bgc3'></i> En proceso";
										}
									}
									else{
										return "<i class='fas fa-circle status_bgc0'></i> Pending";
									}
								}
								else{
									return "N/A";
								}
							}
							else{
								return "N/A";
							}
						}
					},
					{
						title: 'Psychometric',
						data: 'id',
						bSortable: false,
						"width": "8%",
						mRender: function(data, type, full) {
							if (full.psicometrico == 1) {
								if (full.archivo != null && full.archivo != "") {
									return '<a href="' + psico + full.archivo + '" target="_blank" download="' + full.archivo + '" data-toggle="tooltip" title="Descargar psicometrico" id="descarga_psicometrico" class="fa-tooltip icono_datatable"><i class="fas fa-file-powerpoint"></i></a>';
								} else {
									return 'Pending';
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
						"width": "12%",
						mRender: function(data, type, full) {
							if(full.id_cliente != 1){
								var previo = (full.fecha_nacimiento != null && full.fecha_nacimiento != '0000-00-00')?' <div style="display: inline-flex;"><form id="reportePrevioForm'+data+'" action="<?php echo base_url('Candidato_Conclusion/createPrevioPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte previo" id="reportePrevioPDF" class="fa-tooltip icono_datatable icono_previo"><i class="far fa-file-powerpoint"></i></a><input type="hidden" name="idPDF" id="idPDF'+data+'" value="'+data+'"></form></div>' : '';
								if (full.status_bgc == 0) {
									if(full.fecha_nacimiento != null && full.fecha_nacimiento != '0000-00-00'){
										return previo;
									}
									else{
										return '<i class="fas fa-circle status_bgc0"></i> Registered';
									}
								} else {
									if (full.liberado == 1){
										switch(full.status_bgc){
											case '1': 
											case '4':
												var icono_resultado = 'icono_resultado_aprobado';
												break;
											case '2': 
												var icono_resultado = 'icono_resultado_reprobado';
												break;
											case '3':
											case '5': 
												var icono_resultado = 'icono_resultado_revision';
												break;
										}
										if(full.status_bgc > 0){
											return '<div style="display: inline-block;"><form id="reporteForm'+data+'" action="<?php echo base_url('Candidato_Conclusion/createPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte PDF" id="reportePDF" class="fa-tooltip icono_datatable '+icono_resultado+'"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idCandidatoPDF" id="idCandidatoPDF'+data+'" value="'+data+'"></form></div>' + previo;
										}
										else{
											return '<i class="fas fa-circle status_bgc0"></i> To finish';
										}
									}
									else{
										return '<i class="fas fa-circle status_bgc0"></i> To finish';
									}
								}
							}
							if(full.id_cliente == 1){
								let previo = '';
								if(full.proyecto != 'FACIS' && full.proyecto != 'BPO'){
									previo = '<form id="reportePrevioForm'+data+'" action="<?php echo base_url('Cliente_Ust/crearPrevio'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Download partial document" id="reportePrevioPDF" class="btn btn-info"><i class="fas fa-file-powerpoint"></i></a><input type="hidden" name="idCandidatoESE" id="idCandidatoESE'+data+'" value="'+data+'"></form>';
								}
								if (full.status_bgc == 0) {
									return '<div style="display: flex;align-items: center;justify-content: space-around;">' + previo + ' Registered</div>';
								} else {
									if (full.liberado == 1){
										switch(full.status_bgc){
											case '1': 
											case '4':
												var icono_resultado = 'icono_resultado_aprobado';
												break;
											case '2': 
												var icono_resultado = 'icono_resultado_reprobado';
												break;
											case '3':
											case '5': 
												var icono_resultado = 'icono_resultado_revision';
												break;
										}
										if(full.status_bgc > 0){
											if(full.proyecto != 'FACIS'){
												return '<div style="display: inline-block;"><form id="formESE'+data+'" action="<?php echo base_url('Cliente_Ust/crearPDFProcesoESE'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Download finished document" id="esePDF" class="fa-tooltip icono_datatable '+icono_resultado+'"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idCandidatoESE" id="idCandidatoESE'+data+'" value="'+data+'"></form></div>';
											}
											else{
												return '<div"><form id="reporteFormFACIS'+data+'" action="<?php echo base_url('Cliente_Ust/crearPDFProcesoFACIS'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Download finished document" id="facisPDF" class="fa-tooltip icono_datatable '+icono_resultado+'"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idCandidatoFACIS" id="idCandidatoFACIS'+data+'" value="'+data+'"></form></div>';
											}
										}
										else{
											return '<div style="display: flex;align-items: center;justify-content: space-around;">' + previo + ' To finish</div>';
										}
									}
									else{
										return '<div style="display: flex;align-items: center;justify-content: space-around;">' + previo + ' To finish</div>';
									}
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
						if (data.id_cliente != 16) {
							var salida = "";
							var visitado = (data.visitador == 0) ? "<tr><th>Documentación</th><th>En proceso</th></tr><tr><th>Datos del grupo familiar</th><th>En proceso</th></tr><tr><th>Egresos mensuales</th><th>En proceso</th></tr><tr><th>Habitación y medio ambiente</th><th>En proceso</th></tr><tr><th>Referencias vecinales</th><th>En proceso</th></tr>" : "<tr><th>Documentación</th><th>Terminado</th></tr><tr><th>Datos del grupo familiar</th><th>Terminado</th></tr><tr><th>Egresos mensuales</th><th>Terminado</th></tr><tr><th>Habitación y medio ambiente</th><th>Terminado</th></tr><tr><th>Referencias vecinales</th><th>Terminado</th></tr>";

							var estudios = (data.idEstudios == "" || data.idEstudios == null) ? "<tr><th>Historial académico </th><th>En proceso</th></tr>" : "<tr><th>Historial académico </th><th>Terminado</th></tr>";
							var sociales = (data.idSociales == "" || data.idSociales == null) ? "<tr><th>Antecedentes sociales </th><th>En proceso</th></tr>" : "<tr><th>Antecedentes sociales </th><th>Terminado</th></tr>";
							var personales = (data.idPersonales == "" || data.idPersonales == null) ? "<tr><th>Referencias personales </th><th>En proceso</th></tr>" : "<tr><th>Referencias personales </th><th>Registradas</th></tr>";
							var laborales = (data.idLaborales == "" || data.idLaborales == null) ? "<tr><th>Antecedentes laborales </th><th>En proceso</th></tr>" : "<tr><th>Antecedentes laborales </th><th>Registradas</th></tr>";
							var legales = (data.idLegales == "" || data.idLegales == null) ? "<tr><th>Investigación legal </th><th>En proceso</th></tr>" : "<tr><th>Investigación legal </th><th>Terminado</th></tr>";

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

							$("#nombreCandidato").text("Nombre del candidato: " + data.nombreCompleto);
							$("#div_status").html(salida);
							$("#statusModal").modal("show");
						}
						if (data.id_cliente == 16) {
							var salida = "";
							var visitado = (data.visitador == 0) ? "<tr><th>Documentación</th><th>En proceso</th></tr><tr><th>Datos del grupo familiar</th><th>En proceso</th></tr><tr><th>Egresos mensuales</th><th>En proceso</th></tr><tr><th>Habitación y medio ambiente</th><th>En proceso</th></tr><tr><th>Referencias vecinales</th><th>En proceso</th></tr>" : "<tr><th>Documentación</th><th>Terminado</th></tr><tr><th>Datos del grupo familiar</th><th>Terminado</th></tr><tr><th>Egresos mensuales</th><th>Terminado</th></tr><tr><th>Habitación y medio ambiente</th><th>Terminado</th></tr><tr><th>Referencias vecinales</th><th>Terminado</th></tr>";

							var estudios = (data.idEstudios == "" || data.idEstudios == null) ? "<tr><th>Historial académico </th><th>En proceso</th></tr>" : "<tr><th>Historial académico </th><th>Terminado</th></tr>";
							var sociales = (data.idSociales == "" || data.idSociales == null) ? "<tr><th>Antecedentes sociales </th><th>En proceso</th></tr>" : "<tr><th>Antecedentes sociales </th><th>Terminado</th></tr>";
							var personales = (data.idPersonales == "" || data.idPersonales == null) ? "<tr><th>Referencias personales </th><th>En proceso</th></tr>" : "<tr><th>Referencias personales </th><th>Registradas</th></tr>";
							var laborales = (data.idRefLaboral == "" || data.idRefLaboral == null) ? "<tr><th>Antecedentes laborales </th><th>En proceso</th></tr>" : "<tr><th>Antecedentes laborales </th><th>Registradas</th></tr>";

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
							salida += '</tbody>';
							salida += '</table>';

							$("#nombreCandidato").text("Nombre del candidato: " + data.nombreCompleto);
							$("#div_status").html(salida);
							$("#statusModal").modal("show");
						}
						if (data.id_cliente == 39) {
							if (data.id_tipo_proceso == 3) {
								var salida = "";
								var visitado = "";
								var estudios = (data.idMayores == "" || data.idMayores == null) ? "<tr><th>Highest studies </th><th>En proceso</th></tr>" : "<tr><th>Highest studies </th><th>Terminado</th></tr>";
								var sociales = "";
								var personales = "";
								var laborales = (data.idReflab == "" || data.idReflab == null) ? "<tr><th>Labor references </th><th>En proceso</th></tr>" : "<tr><th>Labor references </th><th>Registrado</th></tr>";
								var globales = (data.idGlobal == "" || data.idGlobal == null) ? "<tr><th>Global searches </th><th>En proceso</th></tr>" : "<tr><th>Global searches </th><th>Terminado</th></tr>";

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
								salida += globales;
								salida += '</tbody>';
								salida += '</table>';

								$("#nombreCandidato").text("Nombre del candidato: " + data.nombreCompleto);
								$("#div_status").html(salida);
								$("#statusModal").modal("show");
							}
							if (data.id_tipo_proceso == 4) {
								var salida = "";
								var visitado = "";
								var estudios = (data.idMayores == "" || data.idMayores == null) ? "<tr><th>Highest studies </th><th>En proceso</th></tr>" : "<tr><th>Highest studies </th><th>Terminado</th></tr>";
								var sociales = "";
								var personales = "";
								var laborales = (data.idReflab == "" || data.idReflab == null) ? "<tr><th>Labor references </th><th>En proceso</th></tr>" : "<tr><th>Labor references </th><th>Registrado</th></tr>";
								var globales = (data.idGlobal == "" || data.idGlobal == null) ? "<tr><th>Global searches </th><th>En proceso</th></tr>" : "<tr><th>Global searches </th><th>Terminado</th></tr>";

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
								salida += globales;
								salida += '</tbody>';
								salida += '</table>';

								$("#nombreCandidato").text("Nombre del candidato: " + data.nombreCompleto);
								$("#div_status").html(salida);
								$("#statusModal").modal("show");
							}
							if (data.id_tipo_proceso == 5) {
								var salida = "";
								var visitado = "";
								var estudios = "";
								var sociales = "";
								var personales = "";
								var laborales = "";
								var globales = (data.idGlobal == "" || data.idGlobal == null) ? "<tr><th>Global searches </th><th>En proceso</th></tr>" : "<tr><th>Global searches </th><th>Terminado</th></tr>";

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
								salida += globales;
								salida += '</tbody>';
								salida += '</table>';

								$("#nombreCandidato").text("Nombre del candidato: " + data.nombreCompleto);
								$("#div_status").html(salida);
								$("#statusModal").modal("show");
							}

						}
					});
					$("a#ofac", row).bind('click', () => {
						$(".idCandidato").val(data.id);
						$("#idCliente").val(data.id_cliente);
						$("#ofac_nombrecandidato").text(data.nombre + " " + data.paterno + " " + data.materno);
						estatusOFAC();
					});
					$('a[id^=pdfDoping]', row).bind('click', () => {
						var id = data.idDoping;
						$('#pdfForm' + id).submit();
					});
					$('a[id^=pdfMedico]', row).bind('click', () => {
						var id = data.idMedico;
						$('#formMedico' + id).submit();
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
					$('a[id^=reportePDF]', row).bind('click', () => {
            var id = data.id;
            $('#reporteForm' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'The BGV is being created and it will download soon',
              showConfirmButton: false,
              timer: 2500
            })
          });
					$('a[id^=esePDF]', row).bind('click', () => {
            var id = data.id;
            $('#formESE' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'The BGV is being created and it will download soon',
              showConfirmButton: false,
              timer: 2500
            })
          });
					$('a[id^=facisPDF]', row).bind('click', () => {
            var id = data.id;
            $('#reporteFormFACIS' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'The report is being created and it will download soon',
              showConfirmButton: false,
              timer: 2500
            })
          });
					$('a[id^=pdfCompleto]', row).bind('click', () => {
						var id = data.id;
						$('#formCompleto' + id).submit();
					});
					$('a[id^=pdfSimple]', row).bind('click', () => {
						var id = data.id;
						$('#formSimple' + id).submit();
					});
					$('a[id^=reportePrevioPDF]', row).bind('click', () => {
            var id = data.id;
						if(data.id_cliente != 1){
							$('#reportePrevioForm' + id).submit();
							Swal.fire({
								position: 'center',
								icon: 'success',
								title: 'The partial BGV is being created and it will download soon',
								showConfirmButton: false,
								timer: 2500
							})
						} else {
							Swal.fire({
								title: "Important Notice:",
								text: "Please be advised that this report is preliminary and is provided prior to finalizing the BGV. By downloading it, you agree to continue with the process until its completion, which will be billed in full.",
								icon: "info",
								showCancelButton: true,
								confirmButtonColor: "#3085d6",
								cancelButtonColor: "#d33",
								confirmButtonText: "Got it"
							}).then((result) => {
								if (result.isConfirmed) {
									$('#reportePrevioForm' + id).submit();
									Swal.fire({
										title: "Thanks!",
										text: "The partial BGV is being created and it will download soon",
										icon: "success"
									});
								}
							});
						}
          });
					$("a#msj_avances", row).bind('click', () => {
						$('.nombreCandidato').text(data.candidato)
						$.ajax({
							url: '<?php echo base_url('Candidato/viewAvances'); ?>',
							type: 'post',
							data: {
								'id_candidato': data.id,
								'espanol': 1
							},
							success: function(res) {
								$("#div_avances").html(res);
							}
						});
						$("#avancesModal").modal("show");
					});
					$("a#correoEnviado", row).bind('click', () => {
						$.ajax({
							url: '<?php echo base_url('Candidato/viewEmails'); ?>',
							type: 'post',
							data: {
								'id_candidato': data.id,
								'id_cliente': data.id_cliente
							},
							success: function(res) {
								$("#div_emails").html(res);

							},
							error: function(res) {

							}
						});
						$("#emailsModal").modal("show");
					});
					$('a#comentario', row).bind('click', () => {
						$.ajax({
							url: '<?php echo base_url('index.php/Candidato/viewComentario'); ?>',
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
				},
				
			});
		}
		function ejecutarAccion() {
			var accion = $("#btnGuardar").val();
			var id_candidato = $(".idCandidato").val();
			var correo = $(".correo").val();
			var motivo = $("#motivo").val();
			if (accion == 'cancel') {
				if (motivo == "") {
					$("#msg_accion").text("The comment is required");
					$("#msg_accion").css('display', 'block');
					setTimeout(function() {
						$('#msg_accion').fadeOut();
					}, 5000);
				} else {
					$.ajax({
						url: '<?php echo base_url('index.php/Candidato/cancel'); ?>',
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
					$("#msg_accion").text("The comment is required");
					$("#msg_accion").css('display', 'block');
					setTimeout(function() {
						$('#msg_accion').fadeOut();
					}, 5000);
				} else {
					$.ajax({
						url: '<?php echo base_url('index.php/Candidato/delete'); ?>',
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
					url: '<?php echo base_url('index.php/Candidato/generate'); ?>',
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
		$("#newModal").on("hidden.bs.modal", function() {
			$("#newModal input, #newModal select, #newModal textarea").val('');
			$("#newModal #msj_error").css('display', 'none');
			$("#examen_registro,#examen_medico,#examen_psicometrico").val(0);
			$("#pais").val('México');
      $('#detalles_previo').empty();
		})
	</script>
</body>

</html>