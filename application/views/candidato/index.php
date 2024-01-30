<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Candidate Form | RODI</title>
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
</head>

<body>
	<div class="modal fade" id="mensajeModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Form completed</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h5>The next step is to upload your documents. When you have the require documents, you must access to this link with your same credentials in order to upload your documents in pdf, jpg or png formats (max. 2MB each).</h5><br>
					<h5>This message will close and you will redirect to login view.</h5>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="checkAvisoModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-xl modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Important notice</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h5>Before starting the process, it is important that you download, read, sign and send us the Non-disclosure agreement (image or PDF format).</h5><br>
					<h5>You can download the Non-disclosure agreement <b><a class="" href="<?php echo base_url() . "privacy_notice/non-disclosure.pdf" ?>" target="_blank">Here</a></b> Once you have uploaded the file, the form will be enabled to start the process.</h5><br><br>
					<div class="row">
						<div class="col-4 offset-4">
							<label>Select the file *</label><br>
							<input id="doc_aviso" class="form-control" type="file" name="doc_aviso" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
						</div>
					</div>
					<div id="msj_error" class="alert alert-danger hidden"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="subirArchivo()">Upload the non-disclosure agreement</button>
				</div>
			</div>
		</div>
	</div>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu">
			<a class="navbar-brand text-light" href="#">
				<img src="<?php echo base_url() ?>img/favicon.jpg" class="space">
				<?php echo $this->session->userdata('nombre') . " " . $this->session->userdata('paterno') . " " . $this->session->userdata('materno'); ?>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link text-light font-weight-bold" href="<?php echo base_url(); ?>Login/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<div class="loader" style="display: none;"></div>
	<div class="alert alert-info">
		<h5 class="text-center">* All fields are required</h5>
	</div>
	<?php
	if ($tiene_aviso > 0) {
    if(($tipo_proceso == 1 || $tipo_proceso == 7 || $tipo_proceso == 8) && $id_cliente != 172 && $id_cliente != 178 && $id_cliente != 211){
      $numJobs = 'TWO JOBS';

      if($id_cliente == 1){
        if($tipo_proceso == 1 || $tipo_proceso == 7){
          $numEmpleos = 2;
        }
        else{
          $numEmpleos = 3;
          $numJobs = 'THREE JOBS';
        }
      }
      else{
        $numEmpleos = 6;
      } ?>
      
      <div class="formulario contenedor mt-5">
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Personal Data</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Name *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $this->session->userdata('nombre'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>First lastname *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="paterno" id="paterno" value="<?php echo $this->session->userdata('paterno'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Second lastname</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="materno" id="materno" value="<?php echo $this->session->userdata('materno'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Email *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                  </div>
                  <input type="text" class="form-control" name="correo" id="correo" value="<?php echo $this->session->userdata('correo'); ?>" disabled>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Birthdate *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="mm/dd/yyyy">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Job Position Requested *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="puesto" id="puesto">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Nationality *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="nacionalidad" id="nacionalidad">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Gender *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                  </div>
                  <select name="genero" id="genero" class="form-control obligado">
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Marital Status *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                  </div>
                  <select name="civil" id="civil" class="form-control obligado">
                    <option value="">Select</option>
                    <option value="Married">Married</option>
                    <option value="Single">Single</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Free Union">Free Union</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Separated">Separated</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Mobile Number *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="telefono" id="telefono" maxlength="16" value="<?php echo $this->session->userdata('celular'); ?>">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Home Number </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                  </div>
                  <input type="text" class="form-control" name="tel_casa" id="tel_casa" maxlength="16">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Number to leave Messages </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-sms"></i></span>
                  </div>
                  <input type="text" class="form-control" name="tel_otro" id="tel_otro" maxlength="16">
                </div>
              </div>
            </div>
            <br>
            <?php
            if($id_cliente != 201 && $proyecto_seccion != 'ESE International' && $proyecto_seccion != 'ESE-WORLD CHECK'){ ?>
              <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>Address *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-home"></i></span>
                    </div>
                    <input type="text" class="form-control obligado" name="calle" id="calle">
                  </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>Exterior Number *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-home"></i></span>
                    </div>
                    <input type="text" class="form-control obligado" name="exterior" id="exterior" maxlength="8">
                  </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>Interior Number </label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-home"></i></span>
                    </div>
                    <input type="text" class="form-control" name="interior" id="interior" maxlength="8">
                  </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>Neighborhood *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    </div>
                    <input type="text" class="form-control obligado" name="colonia" id="colonia">
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>State *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-city"></i></span>
                    </div>
                    <select name="estado" id="estado" class="form-control obligado">
                      <option value="">Select</option>
                      <?php foreach ($estados as $e) { ?>
                        <option value="<?php echo $e->id; ?>"><?php echo $e->nombre; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>City *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-city"></i></span>
                    </div>
                    <select name="municipio" id="municipio" class="form-control obligado" disabled>
                      <option value="">Select</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>Zip Code *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    </div>
                    <input type="text" class="form-control solo_numeros obligado" name="cp" id="cp" maxlength="5">
                  </div>
                </div>
              </div>
            <?php
            }
            if($id_cliente == 201 || $proyecto_seccion == 'ESE International' || $proyecto_seccion == 'ESE-WORLD CHECK'){ ?>
              <div class="row">
                <div class="col-12">
                  <label>Address *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-home"></i></span>
                    </div>
                    <input type="text" class="form-control obligado" name="domicilio_completo" id="domicilio_completo">
                  </div>
                </div>
              </div>
              <br>
            <?php
            } ?>
          </div>
        </div>
        <?php 
        if($proyecto_seccion != 'ESE-WORLD CHECK'){ ?>
          <div class="card my-5">
            <h5 class="card-header text-center seccion">Family Environment</h5>
            <div class="card-body">
              <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">TYPE THE COMPLETE NAMES OF YOUR PARENTS AND SIBLINGS INCLUDING THOSE WHO DO NOT LIVE IN YOUR SAME ADDRESS. IF YOU DON'T HAVE SOME THIS DATA, TYPE N/A</h6>
              <div class="card my-5">
                <p class="card-header text-center"><b>Wife/Husband</b></p>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Name </label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control casado" name="nombre_conyuge" id="nombre_conyuge">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Age </label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-id-card"></i></span>
                        </div>
                        <input type="text" class="form-control solo_numeros casado" name="edad_conyuge" id="edad_conyuge" maxlength="2">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Ocupation </label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        </div>
                        <input type="text" class="form-control casado" name="puesto_conyuge" id="puesto_conyuge">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>City</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-city"></i></span>
                        </div>
                        <input type="text" class="form-control casado" name="ciudad_conyuge" id="ciudad_conyuge">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Company</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-building"></i></span>
                        </div>
                        <input type="text" class="form-control casado" name="empresa_conyuge" id="empresa_conyuge">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Live with her/him?</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-house-user"></i></span>
                        </div>
                        <select name="con_conyuge" id="con_conyuge" class="form-control casado">
                          <option value="">Select</option>
                          <option value="0">No</option>
                          <option value="1">Yes</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card my-5">
                <p class="card-header text-center"><b>Children</b></p>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4 offset-md-4 offset-lg-4">
                      <label>How many children do you have? <br>(If not type zero) *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-baby"></i></span>
                        </div>
                        <input type="text" class="form-control solo_numeros obligado" name="num_hijos" id="num_hijos" maxlength="2" oninput="generarHijos()">
                      </div>
                    </div>
                  </div>
                  <div id="children"></div>
                </div>
              </div>
              <div class="card my-5">
                <p class="card-header text-center"><b>Father</b></p>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Name *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control obligado" name="nombre_padre" id="nombre_padre">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Age *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-id-card"></i></span>
                        </div>
                        <input type="text" class="form-control solo_numeros obligado" name="edad_padre" id="edad_padre" maxlength="2">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Ocupation *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        </div>
                        <input type="text" class="form-control obligado" name="puesto_padre" id="puesto_padre">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>City *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-city"></i></span>
                        </div>
                        <input type="text" class="form-control obligado" name="ciudad_padre" id="ciudad_padre">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Company *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-building"></i></span>
                        </div>
                        <input type="text" class="form-control obligado" name="empresa_padre" id="empresa_padre">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Live with her/him? *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-house-user"></i></span>
                        </div>
                        <select name="con_padre" id="con_padre" class="form-control obligado">
                          <option value="">Select</option>
                          <option value="0">No</option>
                          <option value="1">Yes</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card my-5">
                <p class="card-header text-center"><b>Mother</b></p>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Name *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control obligado" name="nombre_madre" id="nombre_madre">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Age *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-id-card"></i></span>
                        </div>
                        <input type="text" class="form-control solo_numeros obligado" name="edad_madre" id="edad_madre" maxlength="2">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Ocupation *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        </div>
                        <input type="text" class="form-control obligado" name="puesto_madre" id="puesto_madre">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>City *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-city"></i></span>
                        </div>
                        <input type="text" class="form-control obligado" name="ciudad_madre" id="ciudad_madre">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Company *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-building"></i></span>
                        </div>
                        <input type="text" class="form-control obligado" name="empresa_madre" id="empresa_madre">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Live with her/him? *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-house-user"></i></span>
                        </div>
                        <select name="con_madre" id="con_madre" class="form-control obligado">
                          <option value="">Select</option>
                          <option value="0">No</option>
                          <option value="1">Yes</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card">
                <p class="card-header text-center"><b>Siblings</b></p>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4 offset-md-4 offset-lg-4">
                      <label>How many siblings do you have? (If not type zero)*</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-users"></i></span>
                        </div>
                        <input type="text" class="form-control solo_numeros obligado" name="num_hermanos" id="num_hermanos" maxlength="2" oninput="generarHermanos()">
                      </div>
                    </div>
                  </div>
                  <div id="siblings"></div>
                </div>
              </div>
            </div>
          </div>
        <?php 
        } ?>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Studies Record</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">TYPE BY PERIOD, FOR EXAMPLE: 2000-2003. IF YOU DON'T HAVE SOME THIS DATA, TYPE N/A</h6>
            <div class="card my-5">
              <p class="card-header text-center"><b>Elementary School</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Period *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prim_periodo" id="prim_periodo">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Institute *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prim_escuela" id="prim_escuela">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prim_ciudad" id="prim_ciudad">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Certificate Obtained *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prim_certificado" id="prim_certificado">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card my-5">
              <p class="card-header text-center"><b>Middle School</b></p>
              <div class=" card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Period *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="sec_periodo" id="sec_periodo">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Institute *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="sec_escuela" id="sec_escuela">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="sec_ciudad" id="sec_ciudad">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Certificate Obtained *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="sec_certificado" id="sec_certificado">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card my-5">
              <p class="card-header text-center"><b>High School</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Period *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prep_periodo" id="prep_periodo">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Institute *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prep_escuela" id="prep_escuela">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prep_ciudad" id="prep_ciudad">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Certificate Obtained *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prep_certificado" id="prep_certificado">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card my-5">
              <p class=" card-header text-center"><b>College</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Period *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="lic_periodo" id="lic_periodo">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Institute *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="lic_escuela" id="lic_escuela">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="lic_ciudad" id="lic_ciudad">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Certificate Obtained *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="lic_certificado" id="lic_certificado">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <label>Seminaries/Courses Certificates *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <textarea class="form-control obligado" name="otro_certificado" id="otro_certificado" rows="3"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Break(s) in Studies</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOU HAD A BREAK DURING YOUR STUDIES, PLEASE EXPLAIN THE REASON, INDICATE PERIOD AND WHICH ACTIVITIES DID YOU DO MEANWHILE. IF NOT TYPE N/A</h6>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <label>Period, Reason and Activities *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                  </div>
                  <textarea class="form-control obligado" name="carrera_inactivo" id="carrera_inactivo" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Employment History</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">TYPE YOUR LAST <?php echo $numJobs; ?> STARTING WITH THE LAST ONE. PROVIDE THE TELEPHONE NUMBER OF THE COMPANY AND THE EMAIL OF YOUR IMMEDIATE BOSS.IF YOU DON'T HAVE EMPLOYMENT HISTORY, LEAVE EMPTY</h6>
            <div class="card my-5">
            <?php 
            for($i = 1;$i<=$numEmpleos;$i++){
            ?>
              <p class="card-header text-center"><b>Reference #<?php echo $i; ?></b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Company </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_empresa" id="reflab<?php echo $i; ?>_empresa">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Address </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_direccion" id="reflab<?php echo $i; ?>_direccion">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-2 col-lg-2">
                    <label>Entry Date </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1 tipo_fecha" name="reflab<?php echo $i; ?>_entrada" id="reflab<?php echo $i; ?>_entrada">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-2 col-lg-2">
                    <label>Exit Date </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1 tipo_fecha" name="reflab<?php echo $i; ?>_salida" id="reflab<?php echo $i; ?>_salida">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Phone </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros reflab1" name="reflab<?php echo $i; ?>_telefono" id="reflab<?php echo $i; ?>_telefono" maxlength="16">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Initial Job Position </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_puesto1" id="reflab<?php echo $i; ?>_puesto1">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Last Job Position </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-people-arrows"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_puesto2" id="reflab<?php echo $i; ?>_puesto2">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Initial Salary </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros reflab1" name="reflab<?php echo $i; ?>_salario1" id="reflab<?php echo $i; ?>_salario1" maxlength="8">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Last Salary </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros reflab1" name="reflab<?php echo $i; ?>_salario2" id="reflab<?php echo $i; ?>_salario2" maxlength="8">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Immediate Boss Name </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_bossnombre" id="reflab<?php echo $i; ?>_bossnombre">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Immediate Boss Email </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_bosscorreo" id="reflab<?php echo $i; ?>_bosscorreo">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <label>Boss's Job Position </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fab fa-black-tie"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_bosspuesto" id="reflab<?php echo $i; ?>_bosspuesto">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <label>Cause of Separation </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_separacion" id="reflab<?php echo $i; ?>_separacion">
                    </div>
                  </div>
                </div>
              </div>
            <?php 
            } ?>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Break(s) in Employment</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOU HAD A BREAK DURING EMPLOYMENTS, PLEASE EXPLAIN THE REASON, INDICATE PERIOD AND WHICH ACTIVITIES DID YOU DO MEANWHILE. IF NOT TYPE NA</h6>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <label>Period, Reason and Activities *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                  </div>
                  <textarea class="form-control obligado" name="trabajo_inactivo" id="trabajo_inactivo" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php 
        if($proyecto_seccion != 'ESE-WORLD CHECK'){ ?>
          <div class="card my-5">
            <h5 class="card-header text-center seccion">Personal references</h5>
            <div class="card-body">
              <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">THESE REFERENCES MUST BE YOUR FRIENDS ONLY, NOT FAMILY. IF YOU DON'T HAVE PERSONAL REFERENCES, LEAVE EMPTY</h6>
              <?php 
              for($j = 1; $j <= 3; $j++){
              ?>
              <div class="card my-5">
                <p class="card-header text-center"><b>Reference #<?php echo $j; ?></b></p>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Name *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control obligado" name="refper<?php echo $j; ?>_nombre" id="refper<?php echo $j; ?>_nombre">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Phone *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                        </div>
                        <input type="text" class="form-control solo_numeros obligado" name="refper<?php echo $j; ?>_telefono" id="refper<?php echo $j; ?>_telefono" maxlength="10">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Time to know her/him (years) *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-clock"></i></span>
                        </div>
                        <input type="text" class="form-control solo_numeros obligado" name="refper<?php echo $j; ?>_tiempo" id="refper<?php echo $j; ?>_tiempo" maxlength="2">
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>How did you meet her/him? *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-comments"></i></span>
                        </div>
                        <input type="text" class="form-control obligado" name="refper<?php echo $j; ?>_conocido" id="refper<?php echo $j; ?>_conocido">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Does she/he know where do you work/worked? *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-question"></i></span>
                        </div>
                        <select name="refper<?php echo $j; ?>_sabetrabajo" id="refper<?php echo $j; ?>_sabetrabajo" class="form-control obligado">
                          <option value="">Select</option>
                          <option value="0">No</option>
                          <option value="1">Yes</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                      <label>Does she/he know where do you live? *</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-question"></i></span>
                        </div>
                        <select name="refper<?php echo $j; ?>_sabevive" id="refper<?php echo $j; ?>_sabevive" class="form-control obligado">
                          <option value="">Select</option>
                          <option value="0">No</option>
                          <option value="1">Yes</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php 
              } ?>
            </div>
          </div>
        <?php 
        } ?>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Have you worked in any government entity, Politic Party or NGO? *</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOUR ANSWER IS AFIRMATIVE, INDICATE DEPENDENCY NAME, PERIOD, SALARY AND SEPARATION MOTIVE</h6>
            <div class="row">
              <div class="col-sm-12 col-lg-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-university"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="trabajo_gobierno" id="trabajo_gobierno">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Your Comments</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOU HAVE ANY COMMENT ABOUT YOUR DOCUMENTS OR IF YOU WANT TO ADD ANY INFORMATION WHICH COULD HELP US DURING THE PROCESS, PLEASE LET US KNOW</h6>
            <div class="row">
              <div class="col-sm-12 col-lg-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-comments"></i></span>
                  </div>
                  <textarea name="obs" id="obs" class="form-control obligado" rows="5"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row my-5">
          <div class="col-12">
            <button class="btn btn-success btn-block form-control" onclick="subirFormulario('<?php echo $proyecto_seccion; ?>')">Send form</button>
          </div>
        </div>
        <div id="msj_error_form" class="alert alert-danger hidden"></div>
      </div>
	  <?php
    }
    if($tipo_proceso == 1 && $id_cliente == 178){ ?>
      <div class="formulario contenedor mt-5">
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Personal Data</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Name *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $this->session->userdata('nombre'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>First lastname *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="paterno" id="paterno" value="<?php echo $this->session->userdata('paterno'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Second lastname</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="materno" id="materno" value="<?php echo $this->session->userdata('materno'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Email *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                  </div>
                  <input type="text" class="form-control" name="correo" id="correo" value="<?php echo $this->session->userdata('correo'); ?>" disabled>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Birthdate *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="mm/dd/yyyy">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Job Position Requested *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="puesto" id="puesto">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Nationality *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="nacionalidad" id="nacionalidad">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Gender *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                  </div>
                  <select name="genero" id="genero" class="form-control obligado">
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Marital Status *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                  </div>
                  <select name="civil" id="civil" class="form-control obligado">
                    <option value="">Select</option>
                    <option value="Married">Married</option>
                    <option value="Single">Single</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Free Union">Free Union</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Separated">Separated</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Mobile Number *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="telefono" id="telefono" maxlength="16" value="<?php echo $this->session->userdata('celular'); ?>">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Home Number </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                  </div>
                  <input type="text" class="form-control" name="tel_casa" id="tel_casa" maxlength="16">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Number to leave Messages </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-sms"></i></span>
                  </div>
                  <input type="text" class="form-control" name="tel_otro" id="tel_otro" maxlength="16">
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-12">
                <label>Address *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="domicilio_completo" id="domicilio_completo">
                </div>
              </div>
            </div>
            <br>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Studies Record</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">TYPE BY PERIOD, FOR EXAMPLE: 2000-2003. IF YOU DON'T HAVE SOME THIS DATA, TYPE N/A</h6>
            <div class="card my-5">
              <p class="card-header text-center"><b>Elementary School</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Period *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prim_periodo" id="prim_periodo">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Institute *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prim_escuela" id="prim_escuela">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prim_ciudad" id="prim_ciudad">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Certificate Obtained *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prim_certificado" id="prim_certificado">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card my-5">
              <p class="card-header text-center"><b>Middle School</b></p>
              <div class=" card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Period *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="sec_periodo" id="sec_periodo">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Institute *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="sec_escuela" id="sec_escuela">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="sec_ciudad" id="sec_ciudad">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Certificate Obtained *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="sec_certificado" id="sec_certificado">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card my-5">
              <p class="card-header text-center"><b>High School</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Period *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prep_periodo" id="prep_periodo">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Institute *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prep_escuela" id="prep_escuela">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prep_ciudad" id="prep_ciudad">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Certificate Obtained *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prep_certificado" id="prep_certificado">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card my-5">
              <p class=" card-header text-center"><b>College</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Period *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="lic_periodo" id="lic_periodo">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Institute *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="lic_escuela" id="lic_escuela">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="lic_ciudad" id="lic_ciudad">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Certificate Obtained *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="lic_certificado" id="lic_certificado">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <label>Seminaries/Courses Certificates *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <textarea class="form-control obligado" name="otro_certificado" id="otro_certificado" rows="3"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Break(s) in Studies</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOU HAD A BREAK DURING YOUR STUDIES, PLEASE EXPLAIN THE REASON, INDICATE PERIOD AND WHICH ACTIVITIES DID YOU DO MEANWHILE. IF NOT TYPE N/A</h6>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <label>Period, Reason and Activities *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                  </div>
                  <textarea class="form-control obligado" name="carrera_inactivo" id="carrera_inactivo" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Employment History</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">TYPE YOUR LAST FIVE YEARS OF JOBS STARTING WITH THE LAST ONE. PROVIDE THE TELEPHONE NUMBER OF THE COMPANY AND THE EMAIL OF YOUR IMMEDIATE BOSS.IF YOU DON'T HAVE EMPLOYMENT HISTORY, LEAVE EMPTY</h6>
            <div class="card my-5">
            <?php 
            for($i = 1;$i<=6;$i++){
            ?>
              <p class="card-header text-center"><b>Reference #<?php echo $i; ?></b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Company </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_empresa" id="reflab<?php echo $i; ?>_empresa">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Address </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_direccion" id="reflab<?php echo $i; ?>_direccion">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-2 col-lg-2">
                    <label>Entry Date </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_entrada" id="reflab<?php echo $i; ?>_entrada">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-2 col-lg-2">
                    <label>Exit Date </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_salida" id="reflab<?php echo $i; ?>_salida">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Phone </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros reflab1" name="reflab<?php echo $i; ?>_telefono" id="reflab<?php echo $i; ?>_telefono" maxlength="16">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Initial Job Position </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_puesto1" id="reflab<?php echo $i; ?>_puesto1">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Last Job Position </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-people-arrows"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_puesto2" id="reflab<?php echo $i; ?>_puesto2">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Initial Salary </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros reflab1" name="reflab<?php echo $i; ?>_salario1" id="reflab<?php echo $i; ?>_salario1" maxlength="8">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Last Salary </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros reflab1" name="reflab<?php echo $i; ?>_salario2" id="reflab<?php echo $i; ?>_salario2" maxlength="8">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Immediate Boss Name </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_bossnombre" id="reflab<?php echo $i; ?>_bossnombre">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Immediate Boss Email </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_bosscorreo" id="reflab<?php echo $i; ?>_bosscorreo">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <label>Boss's Job Position </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fab fa-black-tie"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_bosspuesto" id="reflab<?php echo $i; ?>_bosspuesto">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <label>Cause of Separation </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_separacion" id="reflab<?php echo $i; ?>_separacion">
                    </div>
                  </div>
                </div>
              </div>
            <?php 
            } ?>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Break(s) in Employment</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOU HAD A BREAK DURING EMPLOYMENTS, PLEASE EXPLAIN THE REASON, INDICATE PERIOD AND WHICH ACTIVITIES DID YOU DO MEANWHILE. IF NOT TYPE NA</h6>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <label>Period, Reason and Activities *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                  </div>
                  <textarea class="form-control obligado" name="trabajo_inactivo" id="trabajo_inactivo" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Personal references</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">THESE REFERENCES MUST BE YOUR FRIENDS ONLY, NOT FAMILY. IF YOU DON'T HAVE PERSONAL REFERENCES, LEAVE EMPTY</h6>
            <?php 
            for($j = 1; $j <= 3; $j++){
            ?>
            <div class="card my-5">
              <p class="card-header text-center"><b>Reference #<?php echo $j; ?></b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Name *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-user"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="refper<?php echo $j; ?>_nombre" id="refper<?php echo $j; ?>_nombre">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Phone *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros obligado" name="refper<?php echo $j; ?>_telefono" id="refper<?php echo $j; ?>_telefono" maxlength="10">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Time to know her/him (years) *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros obligado" name="refper<?php echo $j; ?>_tiempo" id="refper<?php echo $j; ?>_tiempo" maxlength="2">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>How did you meet her/him? *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-comments"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="refper<?php echo $j; ?>_conocido" id="refper<?php echo $j; ?>_conocido">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Does she/he know where do you work/worked? *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-question"></i></span>
                      </div>
                      <select name="refper<?php echo $j; ?>_sabetrabajo" id="refper<?php echo $j; ?>_sabetrabajo" class="form-control obligado">
                        <option value="">Select</option>
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Does she/he know where do you live? *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-question"></i></span>
                      </div>
                      <select name="refper<?php echo $j; ?>_sabevive" id="refper<?php echo $j; ?>_sabevive" class="form-control obligado">
                        <option value="">Select</option>
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php 
            } ?>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Have you worked in any government entity, Politic Party or NGO? *</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOUR ANSWER IS AFIRMATIVE, INDICATE DEPENDENCY NAME, PERIOD, SALARY AND SEPARATION MOTIVE</h6>
            <div class="row">
              <div class="col-sm-12 col-lg-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-university"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="trabajo_gobierno" id="trabajo_gobierno">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Your Comments</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOU HAVE ANY COMMENT ABOUT YOUR DOCUMENTS OR IF YOU WANT TO ADD ANY INFORMATION WHICH COULD HELP US DURING THE PROCESS, PLEASE LET US KNOW</h6>
            <div class="row">
              <div class="col-sm-12 col-lg-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-comments"></i></span>
                  </div>
                  <textarea name="obs" id="obs" class="form-control obligado" rows="5"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row my-5">
          <div class="col-12">
            <button class="btn btn-success btn-block form-control" onclick="subirFormulario('<?php echo $proyecto_seccion; ?>')">Send form</button>
          </div>
        </div>
        <div id="msj_error_form" class="alert alert-danger hidden"></div>
      </div>
	  <?php
    }
    if($tipo_proceso == 1 && $id_cliente == 211){ ?>
      <div class="formulario contenedor mt-5">
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Personal Data</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Name *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $this->session->userdata('nombre'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>First lastname *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="paterno" id="paterno" value="<?php echo $this->session->userdata('paterno'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Second lastname</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="materno" id="materno" value="<?php echo $this->session->userdata('materno'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Email *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                  </div>
                  <input type="text" class="form-control" name="correo" id="correo" value="<?php echo $this->session->userdata('correo'); ?>" disabled>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Birthdate *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="mm/dd/yyyy">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Job Position Requested *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="puesto" id="puesto">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Nationality *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="nacionalidad" id="nacionalidad">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Gender *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                  </div>
                  <select name="genero" id="genero" class="form-control obligado">
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Marital Status *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                  </div>
                  <select name="civil" id="civil" class="form-control obligado">
                    <option value="">Select</option>
                    <option value="Married">Married</option>
                    <option value="Single">Single</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Free Union">Free Union</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Separated">Separated</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Mobile Number *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="telefono" id="telefono" maxlength="16" value="<?php echo $this->session->userdata('celular'); ?>">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Home Number </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                  </div>
                  <input type="text" class="form-control" name="tel_casa" id="tel_casa" maxlength="16">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Number to leave Messages </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-sms"></i></span>
                  </div>
                  <input type="text" class="form-control" name="tel_otro" id="tel_otro" maxlength="16">
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-12">
                <label>Address *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="domicilio_completo" id="domicilio_completo">
                </div>
              </div>
            </div>
            <br>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Your Comments</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOU HAVE ANY COMMENT ABOUT YOUR DOCUMENTS OR IF YOU WANT TO ADD ANY INFORMATION WHICH COULD HELP US DURING THE PROCESS, PLEASE LET US KNOW</h6>
            <div class="row">
              <div class="col-sm-12 col-lg-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-comments"></i></span>
                  </div>
                  <textarea name="obs" id="obs" class="form-control obligado" rows="5"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row my-5">
          <div class="col-12">
            <button class="btn btn-success btn-block form-control" onclick="subirFormulario2('<?php echo $proyecto_seccion; ?>')">Send form</button>
          </div>
        </div>
        <div id="msj_error_form" class="alert alert-danger hidden"></div>
      </div>
	  <?php
    }
    if($tipo_proceso == 1 && $id_cliente == 172){ ?>
      <div class="formulario contenedor mt-5">
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Personal Data</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Name *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $this->session->userdata('nombre'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>First lastname *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="paterno" id="paterno" value="<?php echo $this->session->userdata('paterno'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Second lastname</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="materno" id="materno" value="<?php echo $this->session->userdata('materno'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Email *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                  </div>
                  <input type="text" class="form-control" name="correo" id="correo" value="<?php echo $this->session->userdata('correo'); ?>" disabled>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Birthdate *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="mm/dd/yyyy">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Job Position Requested *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="puesto" id="puesto">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Nationality *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="nacionalidad" id="nacionalidad">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Gender *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                  </div>
                  <select name="genero" id="genero" class="form-control obligado">
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Marital Status *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                  </div>
                  <select name="civil" id="civil" class="form-control obligado">
                    <option value="">Select</option>
                    <option value="Married">Married</option>
                    <option value="Single">Single</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Free Union">Free Union</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Separated">Separated</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Mobile Number *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="telefono" id="telefono" maxlength="16" value="<?php echo $this->session->userdata('celular'); ?>">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Home Number </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                  </div>
                  <input type="text" class="form-control" name="tel_casa" id="tel_casa" maxlength="16">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Number to leave Messages </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-sms"></i></span>
                  </div>
                  <input type="text" class="form-control" name="tel_otro" id="tel_otro" maxlength="16">
                </div>
              </div>
            </div>
            <br>
            <?php 
            if($proyecto_seccion == 'National Verification'){ ?>
              <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>Address *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-home"></i></span>
                    </div>
                    <input type="text" class="form-control obligado" name="calle" id="calle">
                  </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>Exterior Number *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-home"></i></span>
                    </div>
                    <input type="text" class="form-control obligado" name="exterior" id="exterior" maxlength="8">
                  </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>Interior Number </label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-home"></i></span>
                    </div>
                    <input type="text" class="form-control" name="interior" id="interior" maxlength="8">
                  </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>Neighborhood *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    </div>
                    <input type="text" class="form-control obligado" name="colonia" id="colonia">
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>State *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-city"></i></span>
                    </div>
                    <select name="estado" id="estado" class="form-control obligado">
                      <option value="">Select</option>
                      <?php foreach ($estados as $e) { ?>
                        <option value="<?php echo $e->id; ?>"><?php echo $e->nombre; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>City *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-city"></i></span>
                    </div>
                    <select name="municipio" id="municipio" class="form-control obligado" disabled>
                      <option value="">Select</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                  <label>Zip Code *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                    </div>
                    <input type="text" class="form-control solo_numeros obligado" name="cp" id="cp" maxlength="5">
                  </div>
                </div>
              </div>
            <?php
            }
            if($proyecto_seccion == 'International Verification' || $proyecto_seccion == 'Identity and Criminal Verification'){ ?>
              <div class="row">
                <div class="col-12">
                  <label>Address *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-home"></i></span>
                    </div>
                    <input type="text" class="form-control obligado" name="domicilio_completo" id="domicilio_completo">
                  </div>
                </div>
              </div>
              <br>
            <?php
            } ?>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Family Environment</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">TYPE THE COMPLETE NAMES OF YOUR PARENTS AND SIBLINGS INCLUDING THOSE WHO DO NOT LIVE IN YOUR SAME ADDRESS. IF YOU DON'T HAVE SOME THIS DATA, TYPE N/A</h6>
            <div class="card my-5">
              <p class="card-header text-center"><b>Wife/Husband</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Name </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>
                      <input type="text" class="form-control casado" name="nombre_conyuge" id="nombre_conyuge">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Age </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-id-card"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros casado" name="edad_conyuge" id="edad_conyuge" maxlength="2">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Ocupation </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                      </div>
                      <input type="text" class="form-control casado" name="puesto_conyuge" id="puesto_conyuge">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>City</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control casado" name="ciudad_conyuge" id="ciudad_conyuge">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Company</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                      </div>
                      <input type="text" class="form-control casado" name="empresa_conyuge" id="empresa_conyuge">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Live with her/him?</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-house-user"></i></span>
                      </div>
                      <select name="con_conyuge" id="con_conyuge" class="form-control casado">
                        <option value="">Select</option>
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card my-5">
              <p class="card-header text-center"><b>Children</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4 offset-md-4 offset-lg-4">
                    <label>How many children do you have? <br>(If not type zero) *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-baby"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros obligado" name="num_hijos" id="num_hijos" maxlength="2" oninput="generarHijos()">
                    </div>
                  </div>
                </div>
                <div id="children"></div>
              </div>
            </div>
            <div class="card my-5">
              <p class="card-header text-center"><b>Father</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Name *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="nombre_padre" id="nombre_padre">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Age *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-id-card"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros obligado" name="edad_padre" id="edad_padre" maxlength="2">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Ocupation *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="puesto_padre" id="puesto_padre">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="ciudad_padre" id="ciudad_padre">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Company *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="empresa_padre" id="empresa_padre">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Live with her/him? *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-house-user"></i></span>
                      </div>
                      <select name="con_padre" id="con_padre" class="form-control obligado">
                        <option value="">Select</option>
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card my-5">
              <p class="card-header text-center"><b>Mother</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Name *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="nombre_madre" id="nombre_madre">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Age *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-id-card"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros obligado" name="edad_madre" id="edad_madre" maxlength="2">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Ocupation *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="puesto_madre" id="puesto_madre">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="ciudad_madre" id="ciudad_madre">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Company *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="empresa_madre" id="empresa_madre">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Live with her/him? *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-house-user"></i></span>
                      </div>
                      <select name="con_madre" id="con_madre" class="form-control obligado">
                        <option value="">Select</option>
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card">
              <p class="card-header text-center"><b>Siblings</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4 offset-md-4 offset-lg-4">
                    <label>How many siblings do you have? (If not type zero)*</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-users"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros obligado" name="num_hermanos" id="num_hermanos" maxlength="2" oninput="generarHermanos()">
                    </div>
                  </div>
                </div>
                <div id="siblings"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Studies Record</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">TYPE BY PERIOD, FOR EXAMPLE: 2000-2003. IF YOU DON'T HAVE SOME THIS DATA, TYPE N/A</h6>
            <div class="card my-5">
              <p class="card-header text-center"><b>Elementary School</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Period *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prim_periodo" id="prim_periodo">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Institute *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prim_escuela" id="prim_escuela">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prim_ciudad" id="prim_ciudad">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Certificate Obtained *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prim_certificado" id="prim_certificado">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card my-5">
              <p class="card-header text-center"><b>Middle School</b></p>
              <div class=" card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Period *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="sec_periodo" id="sec_periodo">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Institute *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="sec_escuela" id="sec_escuela">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="sec_ciudad" id="sec_ciudad">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Certificate Obtained *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="sec_certificado" id="sec_certificado">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card my-5">
              <p class="card-header text-center"><b>High School</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Period *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prep_periodo" id="prep_periodo">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Institute *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prep_escuela" id="prep_escuela">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prep_ciudad" id="prep_ciudad">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Certificate Obtained *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="prep_certificado" id="prep_certificado">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card my-5">
              <p class=" card-header text-center"><b>College</b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Period *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="lic_periodo" id="lic_periodo">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Institute *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="lic_escuela" id="lic_escuela">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>City *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-city"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="lic_ciudad" id="lic_ciudad">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Certificate Obtained *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="lic_certificado" id="lic_certificado">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-12 col-lg-12">
                    <label>Seminaries/Courses Certificates *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                      </div>
                      <textarea class="form-control obligado" name="otro_certificado" id="otro_certificado" rows="3"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Break(s) in Studies</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOU HAD A BREAK DURING YOUR STUDIES, PLEASE EXPLAIN THE REASON, INDICATE PERIOD AND WHICH ACTIVITIES DID YOU DO MEANWHILE. IF NOT TYPE N/A</h6>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <label>Period, Reason and Activities *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                  </div>
                  <textarea class="form-control obligado" name="carrera_inactivo" id="carrera_inactivo" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Employment History</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">TYPE YOUR LAST FIVE YEARS OF JOBS STARTING WITH THE LAST ONE. PROVIDE THE TELEPHONE NUMBER OF THE COMPANY AND THE EMAIL OF YOUR IMMEDIATE BOSS.IF YOU DON'T HAVE EMPLOYMENT HISTORY, LEAVE EMPTY</h6>
            <div class="card my-5">
            <?php 
            for($i = 1;$i<=6;$i++){
            ?>
              <p class="card-header text-center"><b>Reference #<?php echo $i; ?></b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Company </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_empresa" id="reflab<?php echo $i; ?>_empresa">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Address </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_direccion" id="reflab<?php echo $i; ?>_direccion">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-2 col-lg-2">
                    <label>Entry Date </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1 tipo_fecha" name="reflab<?php echo $i; ?>_entrada" id="reflab<?php echo $i; ?>_entrada">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-2 col-lg-2">
                    <label>Exit Date </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1 tipo_fecha" name="reflab<?php echo $i; ?>_salida" id="reflab<?php echo $i; ?>_salida">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Phone </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros reflab1" name="reflab<?php echo $i; ?>_telefono" id="reflab<?php echo $i; ?>_telefono" maxlength="16">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Initial Job Position </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_puesto1" id="reflab<?php echo $i; ?>_puesto1">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Last Job Position </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-people-arrows"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_puesto2" id="reflab<?php echo $i; ?>_puesto2">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Initial Salary </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros reflab1" name="reflab<?php echo $i; ?>_salario1" id="reflab<?php echo $i; ?>_salario1" maxlength="8">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Last Salary </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros reflab1" name="reflab<?php echo $i; ?>_salario2" id="reflab<?php echo $i; ?>_salario2" maxlength="8">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Immediate Boss Name </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_bossnombre" id="reflab<?php echo $i; ?>_bossnombre">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-3 col-lg-3">
                    <label>Immediate Boss Email </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_bosscorreo" id="reflab<?php echo $i; ?>_bosscorreo">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <label>Boss's Job Position </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fab fa-black-tie"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_bosspuesto" id="reflab<?php echo $i; ?>_bosspuesto">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6">
                    <label>Cause of Separation </label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-handshake"></i></span>
                      </div>
                      <input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_separacion" id="reflab<?php echo $i; ?>_separacion">
                    </div>
                  </div>
                </div>
              </div>
            <?php 
            } ?>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Break(s) in Employment</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOU HAD A BREAK DURING EMPLOYMENTS, PLEASE EXPLAIN THE REASON, INDICATE PERIOD AND WHICH ACTIVITIES DID YOU DO MEANWHILE. IF NOT TYPE NA</h6>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12">
                <label>Period, Reason and Activities *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                  </div>
                  <textarea class="form-control obligado" name="trabajo_inactivo" id="trabajo_inactivo" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Personal references</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">THESE REFERENCES MUST BE YOUR FRIENDS ONLY, NOT FAMILY. IF YOU DON'T HAVE PERSONAL REFERENCES, LEAVE EMPTY</h6>
            <?php 
            for($j = 1; $j <= 3; $j++){
            ?>
            <div class="card my-5">
              <p class="card-header text-center"><b>Reference #<?php echo $j; ?></b></p>
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Name *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-user"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="refper<?php echo $j; ?>_nombre" id="refper<?php echo $j; ?>_nombre">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Phone *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros obligado" name="refper<?php echo $j; ?>_telefono" id="refper<?php echo $j; ?>_telefono" maxlength="10">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Time to know her/him (years) *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                      </div>
                      <input type="text" class="form-control solo_numeros obligado" name="refper<?php echo $j; ?>_tiempo" id="refper<?php echo $j; ?>_tiempo" maxlength="2">
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>How did you meet her/him? *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-comments"></i></span>
                      </div>
                      <input type="text" class="form-control obligado" name="refper<?php echo $j; ?>_conocido" id="refper<?php echo $j; ?>_conocido">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Does she/he know where do you work/worked? *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-question"></i></span>
                      </div>
                      <select name="refper<?php echo $j; ?>_sabetrabajo" id="refper<?php echo $j; ?>_sabetrabajo" class="form-control obligado">
                        <option value="">Select</option>
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-4 col-lg-4">
                    <label>Does she/he know where do you live? *</label>
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-question"></i></span>
                      </div>
                      <select name="refper<?php echo $j; ?>_sabevive" id="refper<?php echo $j; ?>_sabevive" class="form-control obligado">
                        <option value="">Select</option>
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php 
            } ?>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Have you worked in any government entity, Politic Party or NGO? *</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOUR ANSWER IS AFIRMATIVE, INDICATE DEPENDENCY NAME, PERIOD, SALARY AND SEPARATION MOTIVE</h6>
            <div class="row">
              <div class="col-sm-12 col-lg-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-university"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="trabajo_gobierno" id="trabajo_gobierno">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Your Comments</h5>
          <div class="card-body">
            <h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOU HAVE ANY COMMENT ABOUT YOUR DOCUMENTS OR IF YOU WANT TO ADD ANY INFORMATION WHICH COULD HELP US DURING THE PROCESS, PLEASE LET US KNOW</h6>
            <div class="row">
              <div class="col-sm-12 col-lg-12">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-comments"></i></span>
                  </div>
                  <textarea name="obs" id="obs" class="form-control obligado" rows="5"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row my-5">
          <div class="col-12">
            <button class="btn btn-success btn-block form-control" onclick="subirFormulario('<?php echo $proyecto_seccion; ?>')">Send form</button>
          </div>
        </div>
        <div id="msj_error_form" class="alert alert-danger hidden"></div>
      </div>
	  <?php
    }
    if($tipo_proceso == 6){ ?>
      <div class="formulario contenedor mt-5">
        <div class="card my-5">
          <h5 class="card-header text-center seccion">Personal Data</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Name *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="nombre2" id="nombre2" value="<?php echo $this->session->userdata('nombre'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>First lastname *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="paterno2" id="paterno2" value="<?php echo $this->session->userdata('paterno'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Second lastname</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" name="materno2" id="materno2" value="<?php echo $this->session->userdata('materno'); ?>" disabled>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Email *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                  </div>
                  <input type="text" class="form-control" name="correo2" id="correo2" value="<?php echo $this->session->userdata('correo'); ?>" disabled>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Birthdate *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                  </div>
                  <input type="text" class="form-control obligado tipo_fecha" name="fecha_nacimiento2" id="fecha_nacimiento2" placeholder="mm/dd/yyyy">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Job Position Requested *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="puesto2" id="puesto2">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Nationality *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="nacionalidad2" id="nacionalidad2">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Gender *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                  </div>
                  <select name="genero2" id="genero2" class="form-control obligado">
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Marital Status *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                  </div>
                  <select name="civil2" id="civil2" class="form-control obligado">
                    <option value="">Select</option>
                    <option value="Married">Married</option>
                    <option value="Single">Single</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Free Union">Free Union</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Separated">Separated</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Mobile Number *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="telefono2" id="telefono2" maxlength="16" value="<?php echo $this->session->userdata('celular'); ?>">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Home Number </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                  </div>
                  <input type="text" class="form-control" name="tel_casa2" id="tel_casa2" maxlength="16">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Number to leave Messages </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-sms"></i></span>
                  </div>
                  <input type="text" class="form-control" name="tel_otro2" id="tel_otro2" maxlength="16">
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Address *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="calle2" id="calle2">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Exterior Number *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="exterior2" id="exterior2" maxlength="8">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Interior Number </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                  </div>
                  <input type="text" class="form-control" name="interior2" id="interior2" maxlength="8">
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Neighborhood *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="colonia2" id="colonia2">
                </div>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>State *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-city"></i></span>
                  </div>
                  <select name="estado2" id="estado2" class="form-control obligado">
                    <option value="">Select</option>
                    <?php foreach ($estados as $e) { ?>
                      <option value="<?php echo $e->id; ?>"><?php echo $e->nombre; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>City *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-city"></i></span>
                  </div>
                  <select name="municipio2" id="municipio2" class="form-control obligado" disabled>
                    <option value="">Select</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-3 col-lg-3">
                <label>Zip Code *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                  </div>
                  <input type="text" class="form-control solo_numeros obligado" name="cp2" id="cp2" maxlength="5">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row my-5">
          <div class="col-12">
            <button id="subirFormulario2" class="btn btn-success btn-block form-control">Send form</button>
          </div>
        </div>
        <div id="msj_error_form" class="alert alert-danger hidden"></div>
      </div>
    <?php 
    }
	} ?>
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
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
		$(document).ready(function() {
			var check_aviso = <?php echo $tiene_aviso; ?>;
			if (check_aviso == 0) {
				$('#checkAvisoModal').modal('show');
			}
			$('#fecha_nacimiento, .tipo_fecha').inputmask('mm/dd/yyyy', {
				'placeholder': 'mm/dd/yyyy'
			});
			$("#estado").change(function() {
				var id_estado = $(this).val();
				if (id_estado != '') {
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
					$('#municipio').append($("<option selected></option>").attr("value", '').text("Select"));
				}
			});
      $("#estado2").change(function() {
				var id_estado = $(this).val();
				if (id_estado != '') {
					$.ajax({
						url: '<?php echo base_url('Funciones/getMunicipios'); ?>',
						method: 'POST',
						data: {
							'id_estado': id_estado
						},
						dataType: "text",
						success: function(res) {
							$('#municipio2').prop('disabled', false);
							$('#municipio2').html(res);
						}
					});
				} else {
					$('#municipio2').prop('disabled', true);
					$('#municipio2').append($("<option selected></option>").attr("value", '').text("Select"));
				}
			});
			
      //Crear registro
			$('#subirFormulario2').click(function() {
				var data = new FormData();
				data.append('fecha_nacimiento', $('#fecha_nacimiento2').val());
				data.append('puesto', $('#puesto2').val());
				data.append('nacionalidad', $('#nacionalidad2').val());
				data.append('genero', $('#genero2').val());
				data.append('civil', $('#civil2').val());
				data.append('telefono', $('#telefono2').val());
				data.append('tel_casa', $('#tel_casa2').val());
				data.append('tel_otro', $('#tel_otro2').val());
				data.append('calle', $('#calle2').val());
				data.append('exterior', $('#exterior2').val());
				data.append('interior', $('#interior2').val());
				data.append('colonia', $('#colonia2').val());
				data.append('estado', $('#estado2').val());
				data.append('municipio', $('#municipio2').val());
				data.append('cp', $('#cp2').val());

				$.ajax({
					url: "<?php echo base_url('Candidato/guardarForm2USTCandidato'); ?>",
					type: 'POST',
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
						if (data.codigo === 1){
							$("#msj_error_form").css('display', 'none');
							$("#mensajeModal").modal("show");
							setTimeout(function() {
							$("#mensajeModal").modal("hide");
								window.location.href = "<?php echo base_url(); ?>Login/logout";
							}, 20000);
						}
						else{
							$("#msj_error_form").css('display', 'block').html(data.msg);
						}
					}
				});
			});

			//Acepta solo numeros en los input
			$(".solo_numeros").on("input", function() {
				var valor = $(this).val();
				$(this).val(valor.replace(/[^0-9]/g, ''));
			});
		});

    //Crear registro
    function subirFormulario(proyecto){
      var data = new FormData();
      var id_cliente = '<?php echo $this->session->userdata('idcliente'); ?> ';
      if(id_cliente == 1){
        if(proyecto != 'ESE-WORLD CHECK')
          var num_trabajos = 2;
        else 
          var num_trabajos = 3;
      }
      if(id_cliente != 1){
        var num_trabajos = 6
      }
      data.append('proyecto', proyecto);
      data.append('fecha_nacimiento', $('#fecha_nacimiento').val());
      data.append('puesto', $('#puesto').val());
      data.append('nacionalidad', $('#nacionalidad').val());
      data.append('genero', $('#genero').val());
      data.append('civil', $('#civil').val());
      data.append('telefono', $('#telefono').val());
      data.append('tel_casa', $('#tel_casa').val());
      data.append('tel_otro', $('#tel_otro').val());
      data.append('calle', $('#calle').val());
      data.append('exterior', $('#exterior').val());
      data.append('interior', $('#interior').val());
      data.append('colonia', $('#colonia').val());
      data.append('estado', $('#estado').val());
      data.append('municipio', $('#municipio').val());
      data.append('cp', $('#cp').val());
      data.append('domicilio_completo', $('#domicilio_completo').val());

      data.append('nombre_conyuge', $('#nombre_conyuge').val());
      data.append('edad_conyuge', $('#edad_conyuge').val());
      data.append('puesto_conyuge', $('#puesto_conyuge').val());
      data.append('ciudad_conyuge', $('#ciudad_conyuge').val());
      data.append('empresa_conyuge', $('#empresa_conyuge').val());
      data.append('con_conyuge', $('#con_conyuge').val());

      data.append('num_hijos', $("#num_hijos").val());
      var num_hijos = $("#num_hijos").val();
      if (num_hijos > 0) {
        for (var i = 1; i <= num_hijos; i++) {
          data.append('nombre_hijo'+i, $("#nombre_hijo" + i).val());
          data.append('edad_hijo'+i, $("#edad_hijo" + i).val());
          data.append('puesto_hijo'+i, $("#puesto_hijo" + i).val());
          data.append('ciudad_hijo'+i, $("#ciudad_hijo" + i).val());
          data.append('empresa_hijo'+i, $("#empresa_hijo" + i).val());
          data.append('con_hijo'+i, $("#con_hijo" + i).val());
        }
      }
      data.append('nombre_padre', $('#nombre_padre').val());
      data.append('edad_padre', $('#edad_padre').val());
      data.append('puesto_padre', $('#puesto_padre').val());
      data.append('ciudad_padre', $('#ciudad_padre').val());
      data.append('empresa_padre', $('#empresa_padre').val());
      data.append('con_padre', $('#con_padre').val());

      data.append('nombre_madre', $('#nombre_madre').val());
      data.append('edad_madre', $('#edad_madre').val());
      data.append('puesto_madre', $('#puesto_madre').val());
      data.append('ciudad_madre', $('#ciudad_madre').val());
      data.append('empresa_madre', $('#empresa_madre').val());
      data.append('con_madre', $('#con_madre').val());

      data.append('num_hermanos', $("#num_hermanos").val());
      var num_hermanos = $("#num_hermanos").val();
      if (num_hermanos > 0) {
        for (var i = 1; i <= num_hermanos; i++) {
          data.append('nombre_hermano'+i, $("#nombre_hermano" + i).val());
          data.append('edad_hermano'+i, $("#edad_hermano" + i).val());
          data.append('puesto_hermano'+i, $("#puesto_hermano" + i).val());
          data.append('ciudad_hermano'+i, $("#ciudad_hermano" + i).val());
          data.append('empresa_hermano'+i, $("#empresa_hermano" + i).val());
          data.append('con_hermano'+i, $("#con_hermano" + i).val());
        }
      }
      data.append('prim_periodo', $('#prim_periodo').val());
      data.append('prim_escuela', $('#prim_escuela').val());
      data.append('prim_ciudad', $('#prim_ciudad').val());
      data.append('prim_certificado', $('#prim_certificado').val());

      data.append('sec_periodo', $('#sec_periodo').val());
      data.append('sec_escuela', $('#sec_escuela').val());
      data.append('sec_ciudad', $('#sec_ciudad').val());
      data.append('sec_certificado', $('#sec_certificado').val());

      data.append('prep_periodo', $('#prep_periodo').val());
      data.append('prep_escuela', $('#prep_escuela').val());
      data.append('prep_ciudad', $('#prep_ciudad').val());
      data.append('prep_certificado', $('#prep_certificado').val());

      data.append('lic_periodo', $('#lic_periodo').val());
      data.append('lic_escuela', $('#lic_escuela').val());
      data.append('lic_ciudad', $('#lic_ciudad').val());
      data.append('lic_certificado', $('#lic_certificado').val());

      data.append('otro_certificado', $('#otro_certificado').val());
      data.append('carrera_inactivo', $('#carrera_inactivo').val());

      for (var i = 1; i <= num_trabajos; i++) {
        data.append('reflab' + i + 'empresa', $('#reflab' + i + '_empresa').val());
        data.append('reflab' + i + 'direccion', $('#reflab' + i + '_direccion').val());
        data.append('reflab' + i + 'entrada', $('#reflab' + i + '_entrada').val());
        data.append('reflab' + i + 'salida', $('#reflab' + i + '_salida').val());
        data.append('reflab' + i + 'telefono', $('#reflab' + i + '_telefono').val());
        data.append('reflab' + i + 'puesto1', $('#reflab' + i + '_puesto1').val());
        data.append('reflab' + i + 'puesto2', $('#reflab' + i + '_puesto2').val());
        data.append('reflab' + i + 'salario1', $('#reflab' + i + '_salario1').val());
        data.append('reflab' + i + 'salario2', $('#reflab' + i + '_salario2').val());
        data.append('reflab' + i + 'bossnombre', $('#reflab' + i + '_bossnombre').val());
        data.append('reflab' + i + 'bosscorreo', $('#reflab' + i + '_bosscorreo').val());
        data.append('reflab' + i + 'bosspuesto', $('#reflab' + i + '_bosspuesto').val());
        data.append('reflab' + i + 'separacion', $('#reflab' + i + '_separacion').val());
      }

      data.append('trabajo_inactivo', $('#trabajo_inactivo').val());

      for (var j = 1; j <= 3; j++) {
        data.append('refper' + j + 'nombre', $('#refper' + j + '_nombre').val());
        data.append('refper' + j + 'telefono', $('#refper' + j + '_telefono').val());
        data.append('refper' + j + 'tiempo', $('#refper' + j + '_tiempo').val());
        data.append('refper' + j + 'conocido', $('#refper' + j + '_conocido').val());
        data.append('refper' + j + 'sabetrabajo', $('#refper' + j + '_sabetrabajo').val());
        data.append('refper' + j + 'sabevive', $('#refper' + j + '_sabevive').val());
      }

      data.append('trabajo_gobierno', $('#trabajo_gobierno').val());
      data.append('comentarios_candidato', $('#obs').val());

      $.ajax({
        url: "<?php echo base_url('Candidato/guardarFormUSTCandidato'); ?>",
        type: 'POST',
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
          if (data.codigo === 1){
            $("#msj_error_form").css('display', 'none');
            $("#mensajeModal").modal("show");
            setTimeout(function() {
            $("#mensajeModal").modal("hide");
              window.location.href = "<?php echo base_url(); ?>Login/logout";
            }, 20000);
          }
          else{
            $("#msj_error_form").css('display', 'block').html(data.msg);
          }
        }
      });
    }
    function subirFormulario2(proyecto){
      var data = new FormData();
      var id_cliente = '<?php echo $this->session->userdata('idcliente'); ?> ';
      data.append('proyecto', proyecto);
      data.append('fecha_nacimiento', $('#fecha_nacimiento').val());
      data.append('puesto', $('#puesto').val());
      data.append('nacionalidad', $('#nacionalidad').val());
      data.append('genero', $('#genero').val());
      data.append('civil', $('#civil').val());
      data.append('telefono', $('#telefono').val());
      data.append('tel_casa', $('#tel_casa').val());
      data.append('tel_otro', $('#tel_otro').val());
      data.append('calle', $('#calle').val());
      data.append('exterior', $('#exterior').val());
      data.append('interior', $('#interior').val());
      data.append('colonia', $('#colonia').val());
      data.append('estado', $('#estado').val());
      data.append('municipio', $('#municipio').val());
      data.append('cp', $('#cp').val());
      data.append('domicilio_completo', $('#domicilio_completo').val());
      data.append('comentarios_candidato', $('#obs').val());

      $.ajax({
        url: "<?php echo base_url('Candidato/guardarFormSimple'); ?>",
        type: 'POST',
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
          if (data.codigo === 1){
            $("#msj_error_form").css('display', 'none');
            $("#mensajeModal").modal("show");
            setTimeout(function() {
            $("#mensajeModal").modal("hide");
              window.location.href = "<?php echo base_url(); ?>Login/logout";
            }, 20000);
          }
          else{
            $("#msj_error_form").css('display', 'block').html(data.msg);
          }
        }
      });
    }
		function generarHijos() {
			var num = $("#num_hijos").val();
			var bloque = "";
			if (num >= 1) {
				for (i = 1; i <= num; i++) {
					bloque += "<div class='card'><p class='card-header text-center'><b>Child " + i + "</b></p><div class='card-body'><div class='row'><div class='col-sm-12 col-md-4 col-lg-4'><label>Name *</label><div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-user'></i></span></div><input type='text' class='form-control obligado' name='nombre_hijo" + i + "' id='nombre_hijo" + i + "'></div></div><div class='col-sm-12 col-md-4 col-lg-4'><label>Age *</label><div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-birthday-cake'></i></span></div><input type='text' class='form-control solo_numeros obligado' name='edad_hijo" + i + "' id='edad_hijo" + i + "'  maxlength='2' ></div></div><div class='col-sm-12 col-md-4 col-lg-4'><label>Ocupation *</label><div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-user-tie'></i></span></div><input type='text' class='form-control obligado' name='puesto_hijo" + i + "' id='puesto_hijo" + i + "' ></div></div></div><div class='row'><div class='col-sm-12 col-md-4 col-lg-4'><label>City *</label><div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-city'></i></span></div><input type='text' class='form-control obligado' name='ciudad_hijo" + i + "' id='ciudad_hijo" + i + "' ></div></div><div class='col-sm-12 col-md-4 col-lg-4'><label>School/Company *</label><div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-school'></i></span></div><input type='text' class='form-control obligado' name='empresa_hijo" + i + "' id='empresa_hijo" + i + "' ></div></div><div class='col-sm-12 col-md-4 col-lg-4'><label>Live with her/him? *</label><div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-house-user'></i></span></div><select name='con_hijo" + i + "' id='con_hijo" + i + "' class='form-control obligado'><option value='-1'>Select</option><option value='0'>No</option><option value='1'>Yes</option></select></div></div></div></div></div>";
				}
				bloque += "<script>";
				bloque += '$(".solo_numeros").on("input",function(){var valor = $(this).val();$(this).val(valor.replace(/[^0-9]/g,""));});';
				bloque += "<\/script>";
				$("#children").html(bloque);
			} else {
				$("#children").empty();
			}
		}

		function generarHermanos() {
			var num = $("#num_hermanos").val();
			var bloque = "";
			if (num >= 1) {
				for (i = 1; i <= num; i++) {
					bloque += "<div class='card my-5'><p class='card-header text-center'><b>Sibling " + i + "</b></p><div class='card-body'><div class='row'><div class='col-sm-12 col-md-4 col-lg-4'><label>Name *</label><div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-user'></i></span></div><input type='text' class='form-control obligado' name='nombre_hermano" + i + "' id='nombre_hermano" + i + "'></div></div><div class='col-sm-12 col-md-4 col-lg-4'><label>Age *</label><div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-id-card'></i></span></div><input type='text' class='form-control solo_numeros obligado' name='edad_hermano" + i + "' id='edad_hermano" + i + "' maxlength='2'></div></div><div class='col-sm-12 col-md-4 col-lg-4'><label>Ocupation *</label><div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-user-tie'></i></span></div><input type='text' class='form-control obligado' name='puesto_hermano" + i + "' id='puesto_hermano" + i + "'></div></div></div><div class='row'><div class='col-sm-12 col-md-4 col-lg-4'><label>City *</label><div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-city'></i></span></div><input type='text' class='form-control obligado' name='ciudad_hermano" + i + "' id='ciudad_hermano" + i + "'></div></div><div class='col-sm-12 col-md-4 col-lg-4'><label>School/Company *</label><div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-building'></i></span></div><input type='text' class='form-control obligado' name='empresa_hermano" + i + "' id='empresa_hermano" + i + "'></div></div><div class='col-sm-12 col-md-4 col-lg-4'><label>Live with her/him? *</label><div class='input-group mb-3'><div class='input-group-prepend'><span class='input-group-text'><i class='fas fa-house-user'></i></span></div><select name='con_hermano" + i + "' id='con_hermano" + i + "' class='form-control obligado'><option value='-1'>Select</option><option value='0'>No</option><option value='1'>Yes</option></select></div></div></div></div></div>";
				}
				bloque += "<script>";
				bloque += '$(".solo_numeros").on("input",function(){var valor = $(this).val();$(this).val(valor.replace(/[^0-9]/g,""));});';
				bloque += "<\/script>";
				$("#siblings").html(bloque);
			} else {
				$("#siblings").empty();
			}
		}
		var id_candidato = "<?php echo $this->session->userdata('id'); ?>";
		function subirArchivo() {
			var docs = new FormData();
			docs.append('tipo_documento', 8);
			docs.append("id_candidato", id_candidato);
			var num_files = document.getElementById('doc_aviso').files.length;
			for (var x = 0; x < num_files; x++) {
				docs.append("archivos[]", document.getElementById('doc_aviso').files[x]);
			}
			$.ajax({
				url: "<?php echo base_url('Candidato/subirArchivosCandidato'); ?>",
				method: "POST",
				data: docs,
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
							position: 'center',
							icon: 'error',
							title: 'Select the file from your device',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if (data.codigo === 1) {
						location.reload();
					}
					if (data.codigo === 2) {
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'Select a PDF, JPG or PNG file with maximum size 2MB',
							showConfirmButton: false,
							timer: 2500
						})
					}
				}
			});
		}
	</script>
</body>

</html>