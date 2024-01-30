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
					<h5>You can download the Non-disclosure agreement <b><a class="" href="<?php echo base_url() . "privacy_notice/rts.pdf" ?>" target="_blank">Here</a></b> Once you have uploaded the file, the form will be enabled to start the process.</h5><br><br>
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
	if ($tiene_aviso > 0) { ?>
		<div class="formulario contenedor mt-5">
      <?php 
			if ($parametros->id_seccion_datos_generales == 1){ ?>
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
                <label>Address *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="calle" id="calle">
                </div>
              </div>
            </div>
            <br>
            <div class="row">
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
                <label>Surrounding streets </label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="calles" id="calles" maxlength="30">
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
          </div>
        </div>
      <?php 
			} 
      if ($parametros->id_seccion_datos_generales == 2){ ?>
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
            </div>
            <br>
            <div class="row">
              <div class="col-12">
                <label>Complete Address *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                  </div>
                  <input type="text" class="form-control obligado" name="domicilio" id="domicilio">
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php 
			} ?>
			<div class="card my-5">
				<h5 class="card-header text-center seccion">Studies Record</h5>
				<div class="card-body">
					<h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">TYPE YOUR HIGHEST STUDIES</h6>
					<div class="card my-5">
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-3 col-lg-3">
									<label>Highest studies *</label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
										</div>
										<select name="estudios" id="estudios" class="form-control obligado">
											<option value="">Select</option>
											<?php foreach ($studies as $st) { ?>
												<option value="<?php echo $st->id; ?>"><?php echo $st->nombre; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3">
									<label>Period *</label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
										</div>
										<input type="text" class="form-control obligado" name="estudios_periodo" id="estudios_periodo">
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3">
									<label>Institute *</label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-university"></i></span>
										</div>
										<input type="text" class="form-control obligado" name="estudios_escuela" id="estudios_escuela">
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3">
									<label>City *</label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-city"></i></span>
										</div>
										<input type="text" class="form-control obligado" name="estudios_ciudad" id="estudios_ciudad">
									</div>
								</div>
								<div class="col-sm-12 col-md-3 col-lg-3">
									<label>Certificate Obtained *</label>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
										</div>
										<input type="text" class="form-control obligado" name="estudios_certificado" id="estudios_certificado">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="accordion" id="acordeonCollapse">
				<div class="card my-5">
					<h5 class="card-header text-center seccion">Employment History</h5>
					<div class="card-body">
						<h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">TYPE YOUR EMPLOYMENTS OF THE LAST FIVE YEARS, STARTING WITH THE LAST ONE.</h6>
						<div class="card my-5">
						<?php 
						for($i = 1;$i<=10;$i++){
							$mostrar = ($i >= 2)? '':'show'; ?>
							<div class="card-header" id="heading<?php echo $i; ?>">
							<h2 class="mb-0">
									<button class="btn btn-link btn-block text-center colapsable" type="button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
										Reference #<?php echo $i; ?> <i class="fas fa-caret-down"></i>
									</button>
								</h2>
							</div>
							<div id="collapse<?php echo $i; ?>" class="collapse <?php echo $mostrar; ?>" aria-labelledby="heading<?php echo $i; ?>" data-parent="#acordeonCollapse">
								<div id="<?php echo 'reflab_form'.$i; ?>" class="card-body">
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
												<input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_salario1" id="reflab<?php echo $i; ?>_salario1" maxlength="8">
											</div>
										</div>
										<div class="col-sm-12 col-md-3 col-lg-3">
											<label>Last Salary </label>
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
												</div>
												<input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_salario2" id="reflab<?php echo $i; ?>_salario2" maxlength="8">
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
							</div>
						<?php 
						} ?>
						</div>
					</div>
				</div>
			</div>
			<div class="card my-5">
				<h5 class="card-header text-center seccion">Break(s) in employment and/or studies</h5>
				<div class="card-body">
					<h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">IF YOU HAD A BREAK DURING EMPLOYMENTS AND/OR STUDIES, PLEASE EXPLAIN THE REASON, INDICATE PERIOD AND WHICH activities DID YOU DO MEANWHILE. IF NOT TYPE NA</h6>
					<div class="row gaps">
						<div class="col-sm-12 col-md-3 col-lg-3">
							<label>Start date *</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="far fa-clock"></i></span>
								</div>
								<input class="form-control obligado" name="inicio_gap1" id="inicio_gap1">
							</div>
							<br>
						</div>
						<div class="col-sm-12 col-md-3 col-lg-3">
							<label>End date *</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="far fa-clock"></i></span>
								</div>
								<input class="form-control obligado" name="fin_gap1" id="fin_gap1">
							</div>
							<br>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<label>Reason and activities *</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-coffee"></i></span>
								</div>
								<textarea class="form-control obligado" name="comentario_gap1" id="comentario_gap1" rows="3"></textarea>
							</div>
							<br><br>
						</div>
					</div>
					<div id="div_gaps"></div>
					<div class="row">
						<div class="col-12">
							<button class="btn btn-info btn-block" onclick="agregarGapTrabajo()"><i class="fas fa-plus-circle"></i> Add another break in employment</button>
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
					<button id="subirFormulario" class="btn btn-success btn-block form-control">Send form</button>
				</div>
			</div>
			<div id="msj_error_form" class="alert alert-danger hidden"></div>
		</div>
	<?php
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
			$('#fecha_nacimiento').inputmask('mm/dd/yyyy', {
				'placeholder': 'mm/dd/yyyy'
			});
			var fnacimiento = '<?php echo $this->session->userdata('fecha') ?>';
			if (fnacimiento != null && fnacimiento != '0000-00-00' && fnacimiento != 0) {
				$("#fecha_nacimiento").val(fnacimiento);
			}
			else{
				$("#fecha_nacimiento").val('');
			}
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
			//Crear registro
			$('#subirFormulario').click(function() {
				var data = new FormData();
				var cantidad_gaps = $('.gaps').length;
				data.append('fecha_nacimiento', $('#fecha_nacimiento').val());
				data.append('puesto', $('#puesto').val());
				data.append('nacionalidad', $('#nacionalidad').val());
				data.append('genero', $('#genero').val());
				data.append('civil', $('#civil').val());
				data.append('telefono', $('#telefono').val());
				data.append('tel_casa', $('#tel_casa').val());
				data.append('calles', $('#calles').val());
				data.append('calle', $('#calle').val());
				data.append('exterior', $('#exterior').val());
				data.append('interior', $('#interior').val());
				data.append('colonia', $('#colonia').val());
				data.append('estado', $('#estado').val());
				data.append('municipio', $('#municipio').val());
				data.append('cp', $('#cp').val());
				data.append('domicilio', $('#domicilio').val());

				data.append('estudios', $('#estudios').val());
				data.append('estudios_periodo', $('#estudios_periodo').val());
				data.append('estudios_escuela', $('#estudios_escuela').val());
				data.append('estudios_ciudad', $('#estudios_ciudad').val());
				data.append('estudios_certificado', $('#estudios_certificado').val());

				for (var i = 1; i <= 10; i++) {
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

				for(var i = 1; i <= cantidad_gaps; i++){
					data.append('inicio_gap'+i, $('#inicio_gap'+i).val());
					data.append('fin_gap'+i, $('#fin_gap'+i).val());
					data.append('comentario_gap'+i, $('#comentario_gap'+i).val()); 
				}
				data.append('cantidad_gaps', cantidad_gaps);
				data.append('comentarios_candidato', $('#obs').val());

				$.ajax({
					url: "<?php echo base_url('Candidato/guardarFormSubclienteCandidato'); ?>",
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
		var id_candidato = "<?php echo $this->session->userdata('id'); ?>";
		var num = 2;

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
		function agregarGapTrabajo(){
			salida = '<div class="row gaps"><div class="col-sm-12 col-md-3 col-lg-3"><label>Start date *</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text"><i class="far fa-clock"></i></span></div><input class="form-control obligado" name="inicio_gap'+num+'" id="inicio_gap'+num+'"></div><br></div><div class="col-sm-12 col-md-3 col-lg-3"><label>End date *</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text"><i class="far fa-clock"></i></span></div><input class="form-control obligado" name="fin_gap'+num+'" id="fin_gap'+num+'"></div><br></div><div class="col-sm-12 col-md-6 col-lg-6"><label>Reason and activities *</label><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-coffee"></i></span></div><textarea class="form-control obligado" name="comentario_gap'+num+'" id="comentario_gap'+num+'" rows="3"></textarea></div><br><br></div></div>';

			$('#div_gaps').append(salida);
			num++;
		}
	</script>
</body>

</html>