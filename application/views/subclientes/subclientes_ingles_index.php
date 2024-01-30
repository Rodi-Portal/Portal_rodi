<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title><?php echo strtoupper($this->session->userdata('subcliente')); ?> | RODI</title>
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
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Candidate register form</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-info text-center">Candidate's information</div>
          <form id="nuevoRegistroForm">
            <div class="row">
              <div class="col-4">
                <label>Name *</label>
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
                <label>Supplier *</label>
                <select name="subcliente" id="subcliente" class="form-control obligado">
                  <option value="">Selecciona</option>
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
              if($id_cliente != 172 && $id_cliente != 178 && $id_cliente != 205 && $id_cliente != 96){ ?>
                <div class="col-4">
                  <label>Position *</label>
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
                  <label>Position *</label>
                  <input type="text" class="form-control obligado" name="puesto" id="puesto">
                  <br>
                </div>
              <?php
              } ?>
              <div class="col-4">
                <label>Telephone Number *</label>
                <input type="text" class="form-control obligado" name="celular_registro" id="celular_registro" maxlength="16">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <label>Country where the candidate resides *</label>
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
                <label>Email account *</label>
                <input type="text" class="form-control obligado" name="correo_registro" id="correo_registro">
                <br>
              </div>
            </div>
            <div class="alert alert-info text-center">Select an existing process/project</div>
            <div class="row">
              <div class="col-12">
                <label>Process/Project *</label>
                <select class="form-control" name="previos" id="previos"></select><br>
              </div>
            </div>
            <div id="detalles_previo"></div>
            <div class="alert alert-danger text-center">Complementary tests</div>
            <div class="row">
              <div class="col-4">
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
          </form>
          <div id="msj_error" class="alert alert-danger hidden"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" onclick="registrar()">Save</button>
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
          <h4 class="modal-title">View status: <br><span class="nombreCandidato"></span></h4>
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
  <div class="modal fade" id="verModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Candidate comments <br><span class="nombreCandidato"></span></h4>
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
							<h3>Se han implementado algunos cambios</h3>
						</div>
						<div class="text-center mt-3">
							<img src="<?php echo base_url() ?>img/cambios_aviso.svg" width="400" height="300">
						</div>
						<div class="text-left">
							<h4>El formulario de registro ha sido modificado. Por ahora, se deberán colocar los datos básicos del candidato, así como el puesto al que va dirigido, y si usted(es) cuentan con subclientes o proveedores elegir uno (Si hubiese y no se refleja favor de hacernoslo saber para registrarlo).</h4><br>
              <h4>Se deberá elegir el proceso al que va dirigido: General plus o Simple. Y si se requiere un examen antidoping para el candidato.</h4><br>
              <h4>De igual forma, puede solicitar que nosotros le apoyemos en sus registros. Puede hacerlo en las siguientes cuentas bramirez@rodicontrol.com y lgonzalez@rodi.com.mx</h4>
              <div class="text-center">
                <img src="<?php echo base_url() ?>img/referencias/7.png" width="600" height="800">
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
        <img src="<?php echo base_url() ?>img/favicon.jpg" class="space">
        <?php echo $this->session->userdata('nombre') . " " . $this->session->userdata('paterno'); ?>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link text-light font-weight-bold" href="javascript:void(0)" onclick="nuevoRegistro()"><i class="fas fa-plus-circle"></i> New candidate</a>
          </li>
          <li class="nav-item">
							<a class="nav-link text-light font-weight-bold" href="javascript:void(0)" onclick="editarPerfil()"><i class="fas fa-user"></i> Edit profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light font-weight-bold" href="<?php echo base_url(); ?>Login/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <div class="loader" style="display: none;"></div>
  <section>
    <div class="contenedor mt-5 my-5">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4 class="m-0 font-weight-bold text-primary  text-center">List of Candidates</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="tabla" class="table table-bordered" width="100%" cellspacing="0">
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

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
    $(document).ready(function() {
      //$('#avisoModal').modal('show')
      var id = '<?php echo $this->session->userdata('idcliente') ?>';
	    var url = '<?php echo base_url('Subcliente_RTS/getCandidatosPanelSubcliente?id='); ?>' + id;
      var psico = '<?php echo base_url(); ?>_psicometria/';

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
            title: 'Candidate',
            data: 'candidato',
            "width": "10%"
          },
          {
            title: 'Project',
            data: 'proyectoSeccion',
            "width": "5%"
          },
          {
            title: 'Register date',
            data: 'fecha_alta',
            "width": "5%",
            mRender: function(data, type, full) {
              var f = data.split(' ');
              var h = f[1];
              var aux = h.split(':');
              var hora = aux[0] + ':' + aux[1];
              var aux = f[0].split('-');
              var fecha = aux[1] + "/" + aux[2] + "/" + aux[0];
              var tiempo = fecha + ' ' + hora;
              return tiempo;
            }
          },
          {
            title: 'Status',
            data: 'id',
            "width": "5%",
            mRender: function(data, type, full) {
               var estatus = '<a href="javascript:void(0)" id="ver" data-toggle="tooltip" title="Status view" class="fa-tooltip icono_datatable"><i class="fas fa-eye"></i></a>';
              return '<a href="javascript:void(0)" data-toggle="tooltip" data-accion="3" title="Progress messages" id="msj_avances" class="fa-tooltip icono_datatable"><i class="fas fa-comment-dots"></i></a>';
            }
          },
          {
            title: 'Drug test',
            data: 'id',
            bSortable: false,
            "width": "5%",
            mRender: function(data, type, full) {
              if (full.tipo_antidoping == 1) {
                if (full.doping_hecho == 1) {
                  if (full.fecha_resultado != null && full.fecha_resultado != "") {
                    if (full.resultado_doping == 1) {
                      return '<i class="fas fa-circle status_bgc2"></i> <div style="display: inline-block;margin-left:10px;"><form id="formDoping' + full.idDoping + '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado" id="pdfDoping" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' + full.idDoping + '" value="' + full.idDoping + '"></form></div>';
                    } else {
                      return '<i class="fas fa-circle status_bgc1"></i> <div style="display: inline-block;margin-left:10px;"><form id="formDoping' + full.idDoping + '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado" id="pdfDoping" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' + full.idDoping + '" value="' + full.idDoping + '"></form></div>';
                    }
                  } else {
                    return '<i class="fas fa-circle status_bgc3"></i> Waiting for results';
                  }
                } else {
                  return '<i class="fas fa-circle status_bgc3"></i> Pending';
                }
              }
              if (full.tipo_antidoping == 0 || full.tipo_antidoping == "" || full.tipo_antidoping == null) {
                return "N/A";
              }
            }
          },
          {
            title: 'BGV',
            data: 'id',
            bSortable: false,
            "width": "5%",
            mRender: function(data, type, full) {
              if (full.status == 0) {
                return '<i class="fas fa-circle status_bgc0"></i> In process';
              } 
              else {
                var pdfCompleto = '';
                var pdfSimple = '<div style="display: inline-block;"><form id="formSimple' + data + '" action="<?php echo base_url('Subcliente_RTS/crearPDFSimple'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final simple" id="pdfSimple" class="fa-tooltip icono_datatable"><i class="far fa-file-pdf"></i></a><input type="hidden" name="idCandidatoSimple" id="idCandidatoSimple' + data + '" value="' + data + '"></form></div>';
                if(full.status_bgc == null || full.status_bgc == 0){
                  return '<i class="fas fa-circle status_bgc0"></i> In process';
                }
                if (full.status_bgc == 1) {
                  if (full.liberado == 1) {
                    pdfCompleto = '<div style="display: inline-block;"><form id="formCompleto' + data + '" action="<?php echo base_url('Subcliente_RTS/crearPDFCompleto'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final completo" id="pdfCompleto" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idCandidatoCompleto" id="idCandidatoCompleto' + data + '" value="' + data + '"></form></div>';
                  }
                  return '<i class="fas fa-circle status_bgc1"></i> ' + pdfSimple + ' ' + pdfCompleto + ' ';
                }
                if (full.status_bgc == 2) {
                  if (full.liberado == 1) {
                    pdfCompleto = '<div style="display: inline-block;"><form id="formCompleto' + data + '" action="<?php echo base_url('Subcliente_RTS/crearPDFCompleto'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final completo" id="pdfCompleto" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idCandidatoCompleto" id="idCandidatoCompleto' + data + '" value="' + data + '"></form></div>';
                  }
                  return '<i class="fas fa-circle status_bgc2"></i> ' + pdfSimple + ' ' + pdfCompleto + ' ';
                }
                if (full.status_bgc == 3) {
                  if (full.liberado == 1) {
                    pdfCompleto = '<div style="display: inline-block;"><form id="formCompleto' + data + '" action="<?php echo base_url('Subcliente_RTS/crearPDFCompleto'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final completo" id="pdfCompleto" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idCandidatoCompleto" id="idCandidatoCompleto' + data + '" value="' + data + '"></form></div>';
                  }
                  return '<i class="fas fa-circle status_bgc3"></i> ' + pdfSimple + ' ' + pdfCompleto + ' ';
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
            $('.nombreCandidato').text(data.candidato)
            var salida = "";
            if(data.id_tipo_proceso == 3){
              var estudios = (data.idMayores == "" || data.idMayores == null) ? "<tr><th>Education </th><th>In process</th></tr>" : "<tr><th>Education </th><th>Completed</th></tr>";
              var laborales = (data.idVerLab == "" || data.idVerLab == null) ? "<tr><th>Employment history </th><th>In process</th></tr>" : "<tr><th>Employment history </th><th>Registered</th></tr>";
              var identidad = "<tr><th>Identity verification </th><th>N/A</th></tr>";
              if(data.liberado == 1){
                laborales = "<tr><th>Employment history </th><th>Completed</th></tr>";
              }
            }
            if(data.id_tipo_proceso == 4){
              var estudios = (data.idMayores == "" || data.idMayores == null) ? "<tr><th>Education </th><th>In process</th></tr>" : "<tr><th>Education </th><th>Completed</th></tr>";
              var laborales = (data.idVerLab == "" || data.idVerLab == null) ? "<tr><th>Employment history </th><th>In process</th></tr>" : "<tr><th>Employment history </th><th>Registered</th></tr>";
              var identidad = (data.idVerificacionDocumentos == "" || data.idVerificacionDocumentos == null) ? "<tr><th>Identity verification </th><th>In process</th></tr>" : "<tr><th>Identity verification </th><th>Registered</th></tr>";
              if(data.liberado == 1){
                laborales = "<tr><th>Employment history </th><th>Completed</th></tr>";
                identidad = "<tr><th>Identity verification </th><th>Completed</th></tr>";
              }
            }
            if(data.id_tipo_proceso == 5){
              var estudios = "<tr><th>Education </th><th>N/A</th></tr>";
              var laborales = "<tr><th>Employment history </th><th>N/A</th></tr>";
              var identidad = (data.idVerificacionDocumentos == "" || data.idVerificacionDocumentos == null) ? "<tr><th>Identity verification </th><th>In process</th></tr>" : "<tr><th>Identity verification </th><th>Registered</th></tr>";
              if(data.liberado == 1){
                identidad = "<tr><th>Identity verification </th><th>Completed</th></tr>";
              }
            }
            var globales = (data.idGlobales == "" || data.idGlobales == null) ? "<tr><th>Global data searches </th><th>In process</th></tr>" : "<tr><th>Global data searches </th><th>Completed</th></tr>";
            var penales = (data.idVerificacionPenales == "" || data.idVerificacionPenales == null) ? "<tr><th>Criminal investigation </th><th>In process</th></tr>" : "<tr><th>Criminal investigation </th><th>Registered</th></tr>";
            if(data.liberado == 1 && data.idVerificacionPenales == null){
              penales = "<tr><th>Criminal investigation </th><th>Omitted</th></tr>";
            }
            if(data.liberado == 1 && data.idVerificacionPenales != null){
              penales = "<tr><th>Criminal investigation </th><th>Completed</th></tr>";
            }
            salida += '<table class="table table-striped">';
            salida += '<thead>';
            salida += '<tr>';
            salida += '<th scope="col">Concept</th>';
            salida += '<th scope="col">Status</th>';
            salida += '</tr>';
            salida += '</thead>';
            salida += '<tbody>';
            salida += estudios;
            salida += laborales;
            salida += globales;
            salida += penales;
            salida += identidad;
            salida += '</tbody>';
            salida += '</table>';

            $("#div_status").html(salida);
            $("#statusModal").modal("show");

          });
          $("a#ofac", row).bind('click', () => {
            $(".idCandidato").val(data.id);
            $("#idCliente").val(data.id_cliente);
            $("#ofac_nombrecandidato").text(data.nombre + " " + data.paterno + " " + data.materno);
            estatusOFAC();
          });
          $('a[id^=pdfDoping]', row).bind('click', () => {
            var id = data.idDoping;
            $('#formDoping' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'If you have Internet, this file will download immediately ',
              showConfirmButton: false,
              timer: 4000
            })
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
          $('a[id^=pdfCompleto]', row).bind('click', () => {
            var id = data.id;
            $('#formCompleto' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'If you have Internet, this file will download immediately ',
              showConfirmButton: false,
              timer: 4000
            })
          });
          $('a[id^=pdfSimple]', row).bind('click', () => {
            var id = data.id;
            $('#formSimple' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'If you have Internet, this file will download immediately ',
              showConfirmButton: false,
              timer: 4000
            })
          });
          $("a#msj_avances", row).bind('click', () => {
            $('.nombreCandidato').text(data.candidato)
            $.ajax({
              url: '<?php echo base_url('Candidato/viewAvances'); ?>',
              type: 'post',
              data: {
                'id_candidato': data.id,
                'espanol': 0
              },
              success: function(res) {
                $("#div_avances").html(res);
              }
            });
            $("#avancesModal").modal("show");
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


              }
            });
          });
        },

      });
      $("#tabla").DataTable().search(" ");
      $('#antidoping').change(function(){
        var opcion = $(this).val();
        var id_subcliente = '<?php echo $this->session->userdata('idsubcliente') ?>';
        var id_cliente = '<?php echo $this->session->userdata('idcliente') ?>';
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
            success: function(res) {
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
        $("#examen_medico,#examen_psicometrico,#examen_registro").val(0);
        $('#detalles_previo').empty();
        $('#pais').val('México');
      })
      $('#perfilUsuarioModal').on('hidden.bs.modal', function(e) {
				$("#perfilUsuarioModal #msj_error").css('display', 'none');
			});
			$('#confirmarPasswordModal').on('hidden.bs.modal', function(e) {
				$("#confirmarPasswordModal #msj_error").css('display', 'none');
				$("#confirmarPasswordModal input").val('');
			});
    });
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
      var datos = new FormData();
      var centro_costo = '';
      var curp = '';
      var nss = '';
      
      datos.append('nombre', $("#nombre_registro").val());
      datos.append('paterno', $("#paterno_registro").val());
      datos.append('materno', $("#materno_registro").val());
      datos.append('celular', $("#celular_registro").val());
      datos.append('subcliente', $("#subcliente").val());
      datos.append('puesto', $("#puesto").val());
      datos.append('pais', $("#pais").val());
      datos.append('previo', $("#previos").val());
      datos.append('proyecto', $("#proyecto_registro").val());
      datos.append('id_cliente', id_cliente);
      datos.append('examen', $("#examen_registro").val());
      datos.append('medico', $("#examen_medico").val());
      datos.append('psicometrico', $("#examen_psicometrico").val());
      datos.append('correo', $("#correo_registro").val());
      datos.append('centro_costo', centro_costo);
      datos.append('curp', curp);
      datos.append('nss', nss);
      datos.append('usuario', 2);

      datos.append("hay_cvs", 0);

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
              title: data.msg,
              showConfirmButton: false,
              timer: 3500
            })
          } else {
            $("#newModal #msj_error").css('display', 'block').html(data.msg);
          }
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
    function recargarTable() {
      $("#tabla").DataTable().ajax.reload();
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