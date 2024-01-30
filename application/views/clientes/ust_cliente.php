<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>UST Global | RODI</title>
	<!-- Google Font -->
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
					<h5 class="modal-title">New candidate</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="datos">
						<div class="row">
							<div class="col-md-4">
								<label>Name *</label>
								<input type="text" class="form-control registro_obligado" name="nombre_nuevo" id="nombre_nuevo">
								<br>
							</div>
							<div class="col-md-4">
								<label>First lastname *</label>
								<input type="text" class="form-control registro_obligado" name="paterno_nuevo" id="paterno_nuevo">
								<br>
							</div>
							<div class="col-md-4">
								<label>Second lastname</label>
								<input type="text" class="form-control" name="materno_nuevo" id="materno_nuevo">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label>Email</label>
								<input type="email" class="form-control" name="correo_nuevo" id="correo_nuevo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
								<br>
							</div>
							<div class="col-md-4">
								<label>Cellphone</label>
								<input type="text" class="form-control" name="celular_nuevo" id="celular_nuevo" maxlength="16">
								<br>
							</div>
							<div class="col-md-4">
								<label>Home phone </label>
								<input type="text" class="form-control" name="fijo_nuevo" id="fijo_nuevo" maxlength="16">
								<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<label>Birthdate</label>
								<input type="text" class="form-control" name="fecha_nacimiento_nuevo" id="fecha_nacimiento_nuevo" placeholder="mm/dd/yyyy">
								<br>
							</div>
							<div class="col-md-4">
								<label>Process *</label>
								<select name="proceso_nuevo" id="proceso_nuevo" class="form-control registro_obligado">
                  <option value="">Selecciona</option>
                  <option value="1">ESE</option>
                  <option value="7">ESE Internacional</option>
                  <option value="8">ESE - WORLD CHECK</option>
                  <option value="2">FACIS</option>
                  <option value="6">WORLD CHECK</option>
								</select>
								<br>
							</div>
						</div>
					</form>
					<div id="msj_error" class="alert alert-danger hidden"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<button type="button" class="btn btn-success" onclick="registrarCandidato()">Save</button>
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
	        				<label for="motivo">Type the reason  *</label>
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
	  	<div class="modal-dialog modal-dialog-centered modal-lg">
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
							<a class="nav-link text-light font-weight-bold" href="javascript:void(0)" data-toggle="modal" data-target="#newModal"><i class="fas fa-plus-circle"></i> New candidate</a>
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
    $(document).ready(function(){
			//$('#avisoModal').modal('show')

			$('#fecha_nacimiento_nuevo').inputmask('mm/dd/yyyy', {
				'placeholder': 'mm/dd/yyyy'
			});
			var url = '<?php echo base_url('Cliente_Ust/getCandidatosPanelCliente'); ?>';
			$('#tabla').DataTable({
				"pageLength": 25,
				//"pagingType": "simple",
				"order": [0, "desc"],
				"stateSave": true,
				"serverSide": false,
				"ajax": url,
				"columns":[ 
					{
						title: 'id',
						data: 'id',
						visible: false
					},
					{ title: 'Name', data: 'nombreCompleto', "width": "15%",
						mRender: function(data, type, full){
							return full.nombre+" "+full.paterno+" "+full.materno;
						}
					},
					{ title: 'Process', data: 'id_tipo_proceso', "width": "5%",
						mRender: function(data, type, full){
              if(data == 1){
                var proceso = 'General';
              }
              if(data == 2){
                var proceso = 'Investigation';
              }
							if(data == 6){
                var proceso = 'World check';
              }
              if(data == 8){
                var proceso = 'ESE-World check';
              }
              if(data == 7){
                var proceso = 'ESE International';
              }
							return proceso;
						}
					},
					{ title: 'Register Date', data: 'fecha_alta', "width": "10%",
						mRender: function(data, type, full){
							var aux = data.split(" ");
							var f = aux[0].split("-");
							var  fecha = f[1]+"/"+f[2]+"/"+f[0];
							var h = aux[1].split(':');
							var hora = h[0]+":"+h[1];
							var tiempo = fecha+" "+hora;
							return tiempo;
						}
					},
					{ title: 'Form Date', data: 'fecha_contestado', "width": "10%",
						mRender: function(data, type, full){
							if(full.id_tipo_proceso == 1 || full.id_tipo_proceso == 6 || full.id_tipo_proceso == 7 || full.id_tipo_proceso == 8){
								if(data == "" || data == null){
									return "<i class='fas fa-circle estatus0'></i>Pending";
								}
								else{
									var f = data.split(' ');
									var h = f[1];
									var aux = h.split(':');
									var hora = aux[0]+':'+aux[1];
									var aux = f[0].split('-');
									var fecha = aux[1]+"/"+aux[2]+"/"+aux[0];
									var tiempo = fecha+' '+hora;
									return "<i class='fas fa-circle estatus1'></i>"+tiempo;
								}
							}
							else{
								return "<i class='fas fa-circle status_bgc0'></i> N/A";
							}
						}
					},
					{ title: 'Documents Date', data: 'fecha_documentos', "width": "10%",
						mRender: function(data, type, full){
							if(full.id_tipo_proceso == 1 || full.id_tipo_proceso == 6 || full.id_tipo_proceso == 7 || full.id_tipo_proceso == 8){
								if(data == "" || data == null){
									return "<i class='fas fa-circle estatus0'></i>Pending";
								}
								else{
									var f = data.split(' ');
									var h = f[1];
									var aux = h.split(':');
									var hora = aux[0]+':'+aux[1];
									var aux = f[0].split('-');
									var fecha = aux[1]+"/"+aux[2]+"/"+aux[0];
									var tiempo = fecha+' '+hora;
									return "<i class='fas fa-circle estatus1'></i>"+tiempo;
								}
							}
							else{
								return "<i class='fas fa-circle status_bgc0'></i> N/A";
							}
						}
					},
					{
						title: 'Progress Messages',
						data: 'id',
						"width": "5%",
						bSortable: false, 
						mRender: function(data, type, full) {
							return '<a href="javascript:void(0)" data-toggle="tooltip" data-accion="3" title="Progress messages" id="msj_avances" class="fa-tooltip icono_datatable"><i class="fas fa-comment-dots"></i></a>';
						}
					},
					{ title: 'BGC Status', data: 'id',bSortable: false, "width": "8%",
						mRender: function(data, type, full){
							if(full.id_tipo_proceso == 1 || full.id_tipo_proceso == 6 || full.id_tipo_proceso == 7 || full.id_tipo_proceso == 8){
								if(full.status == 0){
									return "<i class='fas fa-circle status_bgc0'></i> Pending";
								}
								if(full.status == 1){
									return "<i class='fas fa-circle status_bgc3'></i> In process";
								}
								else{
									var pdf = '<div style="display: inline-block;"><form id="formESE'+data+'" action="<?php echo base_url('Cliente_Ust/crearPDFProcesoESE'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Download finished document" id="pdfFinal" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idCandidatoESE" id="idCandidatoESE'+data+'" value="'+data+'"></form></div>';
									switch(full.status_bgc){
										case '1':
											return "<i class='fas fa-circle status_bgc1'></i> "+pdf+" ";
										break;
										case '2':
											return "<i class='fas fa-circle status_bgc2'></i> "+pdf+" ";
										break;
										case '3':
											return "<i class='fas fa-circle status_bgc3'></i> "+pdf+" ";
										break;
									}
								}
							}
							else{
								if(full.status == 0){
									return "<i class='fas fa-circle status_bgc0'></i> In process</a>";
								}
								else{
									var pdf = '<div style="display: inline-block;"><form id="formFACIS'+data+'" action="<?php echo base_url('Cliente_Ust/crearPDFProcesoFACIS'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Download finished document" id="pdfFACIS" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idCandidatoFACIS" id="idCandidatoFACIS'+data+'" value="'+data+'"></form></div>';
									switch(full.status_bgc){
										case '1':
											return "<i class='fas fa-circle status_bgc1'></i> "+pdf+" ";
										break;
										case '2':
											return "<i class='fas fa-circle status_bgc2'></i> "+pdf+"  ";
										break;
										case '3':
											return "<i class='fas fa-circle status_bgc3'></i> "+pdf+" ";
										break;
									}
								}
							}
						}
					}            
				],	
				fnDrawCallback: function (oSettings) {
					$('a[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
				},
				rowCallback: function( row, data ) {
					$("a#ver", row).bind('click', () => {
						$('.nombreCandidato').text(data.candidato)
							var salida = "";
							if(data.id_tipo_proceso == 1){
								var estudios = (data.idEstudios == "" || data.idEstudios == null) ? "<tr><th>Education </th><th>Waiting for upload</th></tr>" : "<tr><th>Education </th><th>Verifying</th></tr>";
								var documentos = (data.idVerificacionDocumento == "" || data.idVerificacionDocumento == null) ? "<tr><th>Documentation </th><th>Waiting for upload</th></tr>" : "<tr><th>Documentation </th><th>In process</th></tr>";
								var familiares = (data.idFamiliar == "" || data.idFamiliar == null) ? "<tr><th>Family environment </th><th>Waiting for upload</th></tr>" : "<tr><th>Family environment </th><th>Completed</th></tr>";
								var personales = (data.idRefPersonal == "" || data.idRefPersonal == null) ? "<tr><th>Personal references </th><th>Waiting for upload</th></tr>" : "<tr><th>Personal references </th><th>Verifying</th></tr>";
								salida += '<table class="table table-striped">';
								var laborales = (data.idVerificacionLaboral == "" || data.idVerificacionLaboral == null) ? "<tr><th>Employment history </th><th>Waiting for upload</th></tr>" : "<tr><th>Employment history </th><th>In process</th></tr>";
								var penales = (data.idPenalCheck == "" || data.idPenalCheck == null) ? "<tr><th>Criminal check </th><th>In process</th></tr>" : "<tr><th>Criminal check </th><th>Verifying</th></tr>";

								if(data.status_bgc != 0){
									estudios = "<tr><th>Education </th><th>Completed</th></tr>";
									documentos = "<tr><th>Documentation </th><th>Completed</th></tr>";
									personales = "<tr><th>Personal references </th><th>Completed</th></tr>";
									laborales = "<tr><th>Employment history </th><th>Completed</th></tr>";
									penales = "<tr><th>Criminal check </th><th>Completed</th></tr>";
								}
								salida += '<thead>';
								salida += '<tr>';
								salida += '<th scope="col">Concept</th>';
								salida += '<th scope="col">Status</th>';
								salida += '</tr>';
								salida += '</thead>';
								salida += '<tbody>';
								salida += estudios;
								salida += documentos;
								salida += familiares;
								salida += personales;
								salida += laborales;
								salida += penales;
								salida += '</tbody>';
								salida += '</table>';
							}
							if(data.id_tipo_proceso == 2){
								var ofac = (data.ofac != "" && data.ofac != null) ? "<tr><th>OFAC </th><th>Registered</th></tr>" : "<tr><th>OFAC </th><th>N/A</th></tr>";
								var oig = (data.oig != "" && data.oig != null) ? "<tr><th>OIG </th><th>Registered</th></tr>" : "<tr><th>OIG </th><th>N/A</th></tr>";
								var sam = (data.sam != "" && data.sam != null) ? "<tr><th>SAM </th><th>Registered</th></tr>" : "<tr><th>SAM </th><th>N/A</th></tr>";
								var data_juridica = (data.data_juridica != "" && data.data_juridica != null) ? "<tr><th>Legal investigation </th><th>Registered</th></tr>" : "<tr><th>Legal investigation </th><th>N/A</th></tr>";
								salida += '<thead>';
								salida += '<tr>';
								salida += '<th scope="col">Concept</th>';
								salida += '<th scope="col">Status</th>';
								salida += '</tr>';
								salida += '</thead>';
								salida += '<tbody>';
								salida += ofac;
								salida += oig;
								salida += sam;
								salida += data_juridica;
								salida += '</tbody>';
								salida += '</table>';
							}

							$("#div_status").html(salida);
							$("#statusModal").modal("show");
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
					$('a[id^=pdfFACIS]', row).bind('click', () => {
						var id = data.id;
						$('#formFACIS'+id).submit();
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
						$("#texto_confirmacion").html("Are you sure you want to cancel <b>"+data.nombre+" "+data.paterno+" "+data.materno+"</b>?");
						$("#btnGuardar").attr('value','cancel');
						$("#div_commentario").css('display','block');
						$("#quitarModal").modal("show");
					});
					$("a#eliminar", row).bind('click', () => {
						$(".idCandidato").val(data.id);
						$("#titulo_accion").text("Delete candidate");
						$("#texto_confirmacion").html("Are you sure you want to delete <b>"+data.nombre+" "+data.paterno+" "+data.materno+"</b>?");
						$("#btnGuardar").attr('value','delete');
						$("#div_commentario").css('display','block');
						$("#quitarModal").modal("show");
					});
					$('a[id^=pdfFinal]', row).bind('click', () => {
						var id = data.id;
						$('#formESE'+id).submit();
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'If you have Internet, this file will download immediately ',
							showConfirmButton: false,
							timer: 4000
						})
					});
					$('a#comentario', row).bind('click', () => {
						$.ajax({
							url: '<?php echo base_url('Candidato/verComentarioCandidato'); ?>',
							type: 'post',
							data: {'id_candidato':data.id},
							success : function(res){ 
								if(res != 0){
									$("#comentario_candidato").html(res);
									$("#verModal").modal('show');
								}
								else{
									$("#comentario_candidato").html("<div class='col-12'><p class='text-center'>No comments</p></div>");
									$("#verModal").modal('show');
								}

							}
						});
					});
				}
			});
			$("#tabla").DataTable().search(" ");
			$("#registrar").click(function(){
				var datos = new FormData();
				var correo = $("#correo").val();
				datos.append('correo', $("#correo").val());
				datos.append('nombre', $("#nombre").val());
				datos.append('paterno', $("#paterno").val());
				datos.append('materno', $("#materno").val());
				datos.append('celular', $("#celular").val());
				datos.append('fijo', $("#fijo").val());
				datos.append('fecha_nacimiento', $("#fecha_nacimiento").val());
				datos.append('proceso', $("#proceso").val());
				datos.append('ine', $("#ine")[0].files[0]);
				//console.log($("#ine")[0].files[0])
				var totalVacios = $('.obligado').filter(function(){
					return !$(this).val();
				}).length;
					
				if(totalVacios > 0){
					$(".obligado").each(function() {
						var element = $(this);
						if (element.val() == "") {
							element.addClass("requerido");
							$("#campos_vacios").css('display','block');
							setTimeout(function(){
								$('#campos_vacios').fadeOut();
							},4000);
						}
						else{
							element.removeClass("requerido");
						}
					});
				}
				else{
					if(!isEmail(correo) && correo != ""){
						$('#campos_vacios').css("display", "none");
						$('#correo_invalido').css("display", "block");
						$("#correo").addClass("requerido");
						setTimeout(function(){
							$("#correo_invalido").fadeOut();
						},4000);
					}
					else{
						$.ajax({
							url: '<?php echo base_url('Candidato/nuevoCandidato'); ?>',
							type: 'POST',
							data: datos,
							contentType: false,  
							cache: false,  
							processData:false,
							beforeSend: function() {
								$('.loader').css("display","block");
							},
							success : function(res){ 
								if(res == 0){
									$('.loader').fadeOut();
									$('#campos_vacios').css("display", "none");
									$('#correo_invalido').css("display", "none");
									$('#repetido').css("display", "block");
									setTimeout(function(){
										$("#repetido").fadeOut();
									},4000);
								}
								if(res == 1){
									setTimeout(function(){
										$('.loader').fadeOut();
									},300);
									$("#newModal").modal('hide');
									recargarTable();
									$("#exito").css('display','block');
									setTimeout(function(){
										$('#exito').fadeOut();
									},4000);
								}
								if(res != 0 && res != 1){
									var dato = res.split('@@');
									if(dato[0] == "Sent"){
										setTimeout(function(){
											$('.loader').fadeOut();
										},300);
										$("#newModal").modal('hide');
										recargarTable();
										$("#exito").css('display','block');
										$("#user").text(correo);
										$("#pass").text(dato[1]);
										$("#respuesta_mail").text("* A email has been sent with this credentials to candidate. This email could take a few minutes to be delivered.");
										$("#passModal").modal('show');
										setTimeout(function(){
											$('#exito').fadeOut();
										},3000);
									}
									if(dato[0] != "Sent" && dato[0] != "No sent"){
										setTimeout(function(){
											$('.loader').fadeOut();
										},200);
										$('#alert-msg').html('<div class="alert alert-danger">' + res + '</div>');
									}
								}
							}
						});
					}
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
	function registrarCandidato() {
		var datos = new FormData();
		var correo = $("#correo_nuevo").val();
		var proceso = $("#proceso_nuevo").val();
		datos.append('correo', $("#correo_nuevo").val());
		datos.append('nombre', $("#nombre_nuevo").val());
		datos.append('paterno', $("#paterno_nuevo").val());
		datos.append('materno', $("#materno_nuevo").val());
		datos.append('celular', $("#celular_nuevo").val());
		datos.append('fijo', $("#fijo_nuevo").val());
		datos.append('fecha_nacimiento', $("#fecha_nacimiento_nuevo").val());
		datos.append('proceso', proceso);
		datos.append('id_cliente', 1);
		datos.append('usuario', 2);
		if (proceso == 1 || proceso == 6 || proceso == 7 || proceso == 8) {
			$.ajax({
				url: '<?php echo base_url('Cliente_Ust/registrarCandidato'); ?>',
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
						$("#newModal #msj_error").css('display', 'block').html(data.msg);
					}
					if (data.codigo === 1) {
						$("#newModal").modal('hide')
						recargarTable()
						$("#user").text(correo);
						$("#respuesta_mail").text("* An email was sent with the credentials of the candidate to access to platform.");
						$("#passModal").modal('show');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha guardado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if (data.codigo === 2) {
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: data.msg,
							showConfirmButton: false,
							timer: 2500
						})
					}
					if (data.codigo === 3) {
						$("#newModal").modal('hide')
						recargarTable()
						Swal.fire({
							position: 'center',
							icon: 'warning',
							title: 'Se ha guardado correctamente y' + data.msg,
							showConfirmButton: false,
							timer: 2500
						})
					}
					if (data.codigo === 4) {
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: data.msg,
							showConfirmButton: false,
							timer: 2500
						})
					}
				}
			});
		}
		if (proceso == 2) {
			$.ajax({
				url: '<?php echo base_url('Cliente_Ust/registrarCandidato'); ?>',
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
						recargarTable()
						$("#newModal").modal('hide')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha guardado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#newModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		if (proceso == '') {
			$("#newModal #msj_error").css('display', 'block').html('The field Process is required');
		}
	}
	function ejecutarAccion(){
		var accion = $("#btnGuardar").val();
		var id_candidato = $(".idCandidato").val();
		var id_cliente = '<?php echo $this->session->userdata('id') ?>';
		var correo = $(".correo").val();
		var motivo = $("#motivo").val();
		var usuario = 2;
		if(accion == 'cancel'){
			if(motivo == ""){
				$("#msg_accion").text("The comment is required");
				$("#msg_accion").css('display','block');
				setTimeout(function(){
						$('#msg_accion').fadeOut();
				},5000);
			}
			else{
				$.ajax({
					url: '<?php echo base_url('Candidato/cancel'); ?>',
					type: 'post',
					data: {'id_candidato':id_candidato,'motivo':motivo},
					beforeSend: function() {
						$('.loader').css("display","block");
					},
					success : function(res){ 
						setTimeout(function(){
							$('.loader').fadeOut();
						},300);
						$("#quitarModal").modal('hide');
						recargarTable();
						$("#texto_msj").text('The candidate has been cancelled succesfully');
						$("#mensaje").css('display','block');
						setTimeout(function(){
							$('#mensaje').fadeOut();
						},3000);
					}
				});
			}
		}
		if(accion == 'delete'){
			if(motivo == ""){
				$("#msg_accion").text("The reason is required");
				$("#msg_accion").css('display','block');
				setTimeout(function(){
					$('#msg_accion').fadeOut();
				},5000);
			}
			else{
				$.ajax({
					url: '<?php echo base_url('Candidato/accionCandidato'); ?>',
					type: 'post',
					data: {'id':id_candidato,'motivo':motivo,'usuario':usuario,'id_cliente':id_cliente},
					beforeSend: function() {
						$('.loader').css("display","block");
					},
					success : function(res){ 
						setTimeout(function(){
							$('.loader').fadeOut();
						},300);
						$("#quitarModal").modal('hide');
						recargarTable();
						$("#texto_msj").text('The candidate has been deleted succesfully');
						$("#mensaje").css('display','block');
						setTimeout(function(){
							$('#mensaje').fadeOut();
						},3000);
					}
				});
			}
		}
		if(accion == 'generate'){
			$.ajax({
				url: '<?php echo base_url('Candidato/generate'); ?>',
				type: 'post',
				data: {'id_candidato':id_candidato,'correo':correo},
				beforeSend: function() {
					$('.loader').css("display","block");
				},
				success : function(res){ 
					setTimeout(function(){
						$('.loader').fadeOut();
					},300);
					$("#quitarModal").modal('hide');
					$("#user").text(correo);
					$("#pass").text(res);
					$("#respuesta_mail").text("* An email has been sent with this credentials to the candidate. This email could take a few minutes to be delivered.");
					$("#passModal").modal('show');
					recargarTable();
					$("#texto_msj").text('The password has been created succesfully');
					$("#mensaje").css('display','block');
					setTimeout(function(){
						$('#mensaje').fadeOut();
					},3000);
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
	function recargarTable(){
		$("#tabla").DataTable().ajax.reload();
	}
	$('#quitarModal').on('hidden.bs.modal', function (e) {
		$("#msg_accion").css('display','none');
		$(this)
			.find("input,textarea")
			.val('')
			.end();
	});
	$('#newModal').on('hidden.bs.modal', function (e) {
		$("#alert-msg").empty();
		$("#alert-msg").css('display','none');
		$("#campos_vacios").css('display','none');
		$("#correo_invalido").css('display','none');
		$("#repetido").css('display','none');
		$(this)
			.find("input,select")
			.val('')
			.end();
	});
	</script>
</body>
</html>