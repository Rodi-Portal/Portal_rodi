<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Form and Documentation of the Candidate | RODI</title>
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
	<div class="modal fade" id="checkAvisoModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-xl modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Important notice</h4>
					
				</div>
				<div class="modal-body">
					<?php  $avisoPrivacidad = ($info->id_cliente == 2) ? 'non-disclosure-hcl.pdf' : 'non-disclosure.pdf'; ?>
					<h5>Before starting the process, it is important that you download, read, sign and send us the Non-disclosure agreement (image or PDF format).</h5><br>
					<h5>You can download the Non-disclosure agreement <b><a class=""href="<?php echo base_url() . 'privacy_notice/'.$avisoPrivacidad ?>" target="_blank">Here</a></b> Once you have uploaded the file, the form will be enabled to start the process.</h5><br><br>
					<div class="row">
						<div class="col-4 offset-4">
							<label>Select the file *</label><br>
							<input id="doc_aviso" class="form-control" type="file" name="doc_aviso" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
						</div>
					</div>
					<div id="msj_error" class="alert alert-danger hidden"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" onclick="subirAvisoPrivacidad()">Upload the non-disclosure agreement</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="mensajeModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Success!</h4>
				</div>
				<div class="modal-body">
					<h5>If you have sent the form it means that you have finished your registration. If we need any further documentacion or information we will contact you please, be aware.</h5>
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
		//Control de informacion del candidato
		if($info->fecha_nacimiento != null && $info->fecha_nacimiento != '0000-00-00'){
			$aux = explode('-', $info->fecha_nacimiento);
			$f_nacimiento = $aux[2].'/'.$aux[1].'/'.$aux[0];
		}
		else{
			$f_nacimiento = '';
		} ?>
    <div class="formulario contenedor mt-5">
			<?php 
			if ($parametros->id_seccion_datos_generales != NULL){ ?>
				<div class="card my-5">
					<h5 class="card-header text-center seccion">Personal Data</h5>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12 col-md-4 col-lg-4">
								<label>Name *</label>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-user"></i></span>
									</div>
									<input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $this->session->userdata('nombre'); ?>" disabled>
								</div>
							</div>
							<div class="col-sm-12 col-md-4 col-lg-4">
								<label>First lastname *</label>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-user"></i></span>
									</div>
									<input type="text" class="form-control" name="paterno" id="paterno" value="<?php echo $this->session->userdata('paterno'); ?>" disabled>
								</div>
							</div>
							<div class="col-sm-12 col-md-4 col-lg-4">
								<label>Second lastname</label>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-user"></i></span>
									</div>
									<input type="text" class="form-control" name="materno" id="materno" value="<?php echo $this->session->userdata('materno'); ?>" disabled>
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
									<input type="text" class="form-control obligado" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="dd/mm/yyyy"  value='<?php echo $f_nacimiento; ?>'>
								</div>
							</div>
							<div class="col-sm-12 col-md-3 col-lg-3">
								<label>Job Position Requested *</label>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-user-tie"></i></span>
									</div>
									<input type="text" class="form-control obligado" name="puesto" id="puesto" value='<?php echo $info->puestoCandidato; ?>'>
								</div>
							</div>
							<div class="col-sm-12 col-md-3 col-lg-3">
								<label>Nationality *</label>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-globe-americas"></i></span>
									</div>
									<input type="text" class="form-control obligado" name="nacionalidad" id="nacionalidad" value="<?php echo $info->nacionalidad; ?>">
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
							<div class="col-12">
								<label>Address *</label>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-home"></i></span>
									</div>
									<input type="text" class="form-control obligado" name="domicilio" id="domicilio" placeholder="Street, number, neighborhood, zip code and city" value="<?php echo $info->domicilio_internacional; ?>">
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-sm-12 col-md-6 col-lg-6">
								<label>Country *</label>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-flag"></i></span>
									</div>
									<select name="pais" id="pais" class="form-control obligado">
										<option value="">Select</option>
										<?php foreach ($paises as $pais) { ?>
											<option value="<?php echo $pais->nombre; ?>"><?php echo $pais->nombre; ?></option>
										<?php } ?>
									</select>
								</div>
								<br>
							</div>
							<div class="col-6">
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
						</div>
						<div class="row">
							<div class="col-sm-12 col-md-4 col-lg-4">
								<label>Mobile Number *</label>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
									</div>
									<input type="text" class="form-control obligado" name="telefono" id="telefono" maxlength="16" value="<?php echo $info->celular; ?>">
								</div>
							</div>
							<div class="col-sm-12 col-md-4 col-lg-4">
								<label>Home Number </label>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
									</div>
									<input type="text" class="form-control" name="tel_casa" id="tel_casa" maxlength="16" value="<?php echo $info->telefono_casa; ?>">
								</div>
							</div>
							<div class="col-sm-12 col-md-4 col-lg-4">
								<label>Number to leave Messages </label>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-sms"></i></span>
									</div>
									<input type="text" class="form-control" name="tel_otro" id="tel_otro" maxlength="16"  value="<?php echo $info->telefono_otro; ?>">
								</div>
							</div>
						</div>
						<br>
					</div>
				</div>
			<?php 
			} ?>
			
			<?php 
			if ($parametros->lleva_estudios == 1){ ?>
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
											<input type="text" class="form-control obligado" name="estudios_periodo" id="estudios_periodo" value="<?php echo $info->estudios_periodo; ?>">
										</div>
									</div>
									<div class="col-sm-12 col-md-3 col-lg-3">
										<label>Institute *</label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-university"></i></span>
											</div>
											<input type="text" class="form-control obligado" name="estudios_escuela" id="estudios_escuela" value="<?php echo $info->estudios_escuela; ?>">
										</div>
									</div>
									<div class="col-sm-12 col-md-3 col-lg-3">
										<label>City *</label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-city"></i></span>
											</div>
											<input type="text" class="form-control obligado" name="estudios_ciudad" id="estudios_ciudad" value="<?php echo $info->estudios_ciudad; ?>">
										</div>
									</div>
									<div class="col-sm-12 col-md-3 col-lg-3">
										<label>Certificate Obtained *</label>
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
											</div>
											<input type="text" class="form-control obligado" name="estudios_certificado" id="estudios_certificado" value="<?php echo $info->estudios_certificado; ?>">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			} ?>

			<?php 
			if ($parametros->lleva_domicilios == 1){ ?>
				<div class="accordion" id="acordeonCollapse">
					<div class="card my-5">
						<h5 class="card-header text-center seccion">Address History</h5>
						<div class="card-body">
							<?php
							if ($this->session->userdata('proyecto') == 150 || $this->session->userdata('proyecto') == 151 || $this->session->userdata('proyecto') == 152 || $this->session->userdata('proyecto') == 154) { ?>
								<h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">TYPE IN YOUR ADDRESSES OF THE LAST 10 YEARS, STARTING WITH THE CURRENT ONE</h6>
							<?php
							}
							if ($this->session->userdata('proyecto') == 153) { ?>
								<h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">TYPE IN YOUR ADDRESSES OF THE LAST 7 YEARS, STARTING WITH THE CURRENT ONE</h6>
							<?php
							}
							?>
							<div class="card my-5">
							<?php 
							for($i = 1;$i<=15;$i++){
								if($doms != false){
									$per = (isset($doms[$i-1]->periodo))? $doms[$i-1]->periodo : '';
									$cau = (isset($doms[$i-1]->causa))? $doms[$i-1]->causa : '';
									$dom = (isset($doms[$i-1]->domicilio_internacional))? $doms[$i-1]->domicilio_internacional : '';
								}
								else{
									$per = '';$cau = '';$dom = '';
								}
								$mostrar_direccion = ($i >= 2)? '':'show';  ?>
								<div class="card-header" id="heading<?php echo $i; ?>">
								<h2 class="mb-0">
										<button class="btn btn-link btn-block text-center colapsable" type="button" data-toggle="collapse" data-target="#collapseDom<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
											Reference #<?php echo $i; ?> <i class="fas fa-caret-down"></i>
										</button>
									</h2>
								</div>
								<div id="collapseDom<?php echo $i; ?>" class="collapse <?php echo $mostrar_direccion; ?>" aria-labelledby="heading<?php echo $i; ?>" data-parent="#acordeonCollapse">
									<div id="<?php echo 'reflab_form'.$i; ?>" class="card-body">
										<div class="row">
											<div class="col-sm-12 col-md-6 col-lg-6">
												<label>Period *</label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
													</div>
													<input type="text" class="form-control" name="h<?php echo $i; ?>_periodo" id="h<?php echo $i; ?>_periodo" value="<?php echo $per; ?>">
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6">
												<label>Cause of departure *</label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-handshake"></i></span>
													</div>
													<input type="text" class="form-control" name="h<?php echo $i; ?>_causa" id="h<?php echo $i; ?>_causa" value="<?php echo $cau; ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12 col-md-6 col-lg-6">
												<label>Address *</label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-home"></i></span>
													</div>
													<input type="text" class="form-control" name="h<?php echo $i; ?>_domicilio" id="h<?php echo $i; ?>_domicilio" placeholder="Street, number, neighborhood, zip code and city" value="<?php echo $dom; ?>">
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6">
												<label>Country *</label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-flag"></i></span>
													</div>
													<select name="h<?php echo $i; ?>_pais" id="h<?php echo $i; ?>_pais" class="form-control obligado">
														<option value="">Select</option>
														<?php foreach ($paises as $pais) { ?>
															<option value="<?php echo $pais->nombre; ?>"><?php echo $pais->nombre; ?></option>
														<?php } ?>
													</select>
												</div>
												<br>
											</div>
											<?php 
											if((isset($doms[$i-1]->pais))){
												echo '<script> $("#h'.$i.'_pais").val("'.$doms[$i-1]->pais.'"); </script>';
											} ?>
										</div>
										<br>
									</div>
								</div>
							<?php 
							} ?>
							</div>
						</div>
					</div>
				</div>
			<?php
			}  ?>

			<?php 
			if ($parametros->lleva_empleos == 1){ ?>
				<div class="accordion" id="acordeonCollapse">
					<div class="card my-5">
						<h5 class="card-header text-center seccion">Employment History</h5>
						<div class="card-body">
							<h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center text-uppercase">TYPE YOUR EMPLOYMENTS OF THE LAST  <?php echo $parametros->tiempo_empleos; ?>, STARTING WITH THE LAST ONE.</h6>
							<div class="card my-5">
							<?php 
							for($i = 1;$i<=25;$i++){
								if($refs != false){
									if(isset($refs[$i-1]->fecha_entrada)){
										$f = explode(' ', $refs[$i-1]->fecha_entrada);
										$aux = explode('-', $f[0]);
										$ent = $aux[2].'/'.$aux[1].'/'.$aux[0];
									}
									else{
										$ent = '';
									}
									if(isset($refs[$i-1]->fecha_salida)){
										$f = explode(' ', $refs[$i-1]->fecha_salida);
										$aux = explode('-', $f[0]);
										$sal = $aux[2].'/'.$aux[1].'/'.$aux[0];
									}
									else{
										$sal = '';
									}
									$emp = (isset($refs[$i-1]->empresa))? $refs[$i-1]->empresa : '';
									$dir = (isset($refs[$i-1]->direccion))? $refs[$i-1]->direccion : '';
									$tel = (isset($refs[$i-1]->telefono))? $refs[$i-1]->telefono : '';
									$p1 = (isset($refs[$i-1]->puesto1))? $refs[$i-1]->puesto1 : '';
									$p2 = (isset($refs[$i-1]->puesto2))? $refs[$i-1]->puesto2 : '';
									$s1 = (isset($refs[$i-1]->salario1))? $refs[$i-1]->salario1 : '';
									$s2 = (isset($refs[$i-1]->salario2))? $refs[$i-1]->salario2 : '';
									$bnombre = (isset($refs[$i-1]->jefe_nombre))? $refs[$i-1]->jefe_nombre : '';
									$bcorreo = (isset($refs[$i-1]->jefe_correo))? $refs[$i-1]->jefe_correo : '';
									$bpuesto = (isset($refs[$i-1]->jefe_puesto))? $refs[$i-1]->jefe_puesto : '';
									$sep = (isset($refs[$i-1]->causa_separacion))? $refs[$i-1]->causa_separacion : '';
								}
								else{
									$emp = '';$dir = '';$ent = '';$sal = '';	$tel = '';$p1 = '';$p2 = '';$s1 = '';$s2 = '';
									$bnombre = '';$bcorreo = '';$bpuesto = '';$sep = '';
								}
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
											<div class="col-sm-12 col-md-6 col-lg-6">
												<label>Company </label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-building"></i></span>
													</div>
													<input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_empresa" id="reflab<?php echo $i; ?>_empresa" value="<?php echo $emp; ?>">
												</div>
											</div>
											<div class="col-sm-12 col-md-6 col-lg-6">
												<label>Address </label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
													</div>
													<input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_direccion" id="reflab<?php echo $i; ?>_direccion" value="<?php echo $dir; ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Entry Date </label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-calendar"></i></span>
													</div>
													<input type="text" class="form-control reflab1 tipo_fecha" name="reflab<?php echo $i; ?>_entrada" id="reflab<?php echo $i; ?>_entrada" value="<?php echo $ent; ?>">
												</div>
											</div>
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Exit Date </label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
													</div>
													<input type="text" class="form-control reflab1 tipo_fecha" name="reflab<?php echo $i; ?>_salida" id="reflab<?php echo $i; ?>_salida" value="<?php echo $sal; ?>">
												</div>
											</div>
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Phone </label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
													</div>
													<input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_telefono" id="reflab<?php echo $i; ?>_telefono" maxlength="16" value="<?php echo $tel; ?>">
												</div>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Initial Job Position </label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-user-tie"></i></span>
													</div>
													<input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_puesto1" id="reflab<?php echo $i; ?>_puesto1" value="<?php echo $p1; ?>">
												</div>
											</div>
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Last Job Position </label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-people-arrows"></i></span>
													</div>
													<input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_puesto2" id="reflab<?php echo $i; ?>_puesto2" value="<?php echo $p2; ?>">
												</div>
											</div>
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Initial Salary </label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
													</div>
													<input type="text" class="form-control solo_numeros reflab1" name="reflab<?php echo $i; ?>_salario1" id="reflab<?php echo $i; ?>_salario1" maxlength="8" value="<?php echo $s1; ?>">
												</div>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Last Salary </label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
													</div>
													<input type="text" class="form-control solo_numeros reflab1" name="reflab<?php echo $i; ?>_salario2" id="reflab<?php echo $i; ?>_salario2" maxlength="8" value="<?php echo $s2; ?>">
												</div>
											</div>
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Immediate Boss Name </label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-user-tie"></i></span>
													</div>
													<input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_bossnombre" id="reflab<?php echo $i; ?>_bossnombre" value="<?php echo $bnombre; ?>">
												</div>
											</div>
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Immediate Boss Email </label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-envelope"></i></span>
													</div>
													<input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_bosscorreo" id="reflab<?php echo $i; ?>_bosscorreo" value="<?php echo $bcorreo; ?>">
												</div>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Boss's Job Position </label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fab fa-black-tie"></i></span>
													</div>
													<input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_bosspuesto" id="reflab<?php echo $i; ?>_bosspuesto" value="<?php echo $bpuesto; ?>">
												</div>
											</div>
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Cause of Separation </label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-handshake"></i></span>
													</div>
													<input type="text" class="form-control reflab1" name="reflab<?php echo $i; ?>_separacion" id="reflab<?php echo $i; ?>_separacion" value="<?php echo $sep; ?>">
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
			<?php
			} ?>

			<?php 
			if ($parametros->lleva_empleos == 1){ ?>
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
									<textarea class="form-control obligado" name="trabajo_inactivo" id="trabajo_inactivo" rows="3"><?php echo $info->trabajo_inactivo; ?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			} ?>

			<?php 
			if ($parametros->cantidad_ref_profesionales > 0){ ?>
				<div class="accordion" id="acordeonCollapse">
					<div class="card my-5">
						<h5 class="card-header text-center seccion">Professional references</h5>
						<div class="card-body">
							<div class="card my-5">
							<?php 
							for($k = 1;$k <= $parametros->cantidad_ref_profesionales;$k++){ 
								if($profs != false){
									$pnom = (isset($profs[$k-1]->nombre))? $profs[$k-1]->nombre : '';
									$ptel = (isset($profs[$k-1]->telefono))? $profs[$k-1]->telefono : '';
									$ptiempo = (isset($profs[$k-1]->tiempo_conocerlo))? $profs[$k-1]->tiempo_conocerlo : '';
									$plugar = (isset($profs[$k-1]->donde_conocerlo))? $profs[$k-1]->donde_conocerlo : '';
									$ppuesto = (isset($profs[$k-1]->puesto))? $profs[$k-1]->puesto : '';
								}
								else{
									$pnom = '';$ptel = '';$ptiempo = '';$plugar = '';	$ppuesto = '';
								} ?>
								<div class="card-header" id="heading<?php echo $k; ?>">
								<h2 class="mb-0">
										<button class="btn btn-link btn-block text-center colapsable" type="button" data-toggle="collapse" data-target="#collapseRefProf<?php echo $k; ?>" aria-expanded="true" aria-controls="collapse<?php echo $k; ?>">
											Reference #<?php echo $k; ?> <i class="fas fa-caret-down"></i>
										</button>
									</h2>
								</div>
								<div id="collapseRefProf<?php echo $k; ?>" class="collapse show" aria-labelledby="heading<?php echo $k; ?>" data-parent="#acordeonCollapse">
									<div id="<?php echo 'reflab_form'.$k; ?>" class="card-body">
										<div class="row">
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Name *</label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-user"></i></span>
													</div>
													<input type="text" class="form-control" name="refpro<?php echo $k; ?>_nombre" id="refpro<?php echo $k; ?>_nombre" value="<?php echo $pnom; ?>">
												</div>
											</div>
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Phone *</label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
													</div>
													<input type="text" class="form-control" name="refpro<?php echo $k; ?>_telefono" id="refpro<?php echo $k; ?>_telefono" value="<?php echo $ptel; ?>">
												</div>
											</div>
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>Time to know her/him *</label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
													</div>
													<input type="text" class="form-control" name="refpro<?php echo $k; ?>_tiempo" id="refpro<?php echo $k; ?>_tiempo" value="<?php echo $ptiempo; ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>How did you meet her/him? *</label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-building"></i></span>
													</div>
													<input type="text" class="form-control" name="refpro<?php echo $k; ?>_conocido" id="refpro<?php echo $k; ?>_conocido" value="<?php echo $plugar; ?>">
												</div>
											</div>
											<div class="col-sm-12 col-md-4 col-lg-4">
												<label>What position had her/him? *</label>
												<div class="input-group mb-3">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fas fa-user-tie"></i></span>
													</div>
													<input type="text" class="form-control" name="refpro<?php echo $k; ?>_puesto" id="refpro<?php echo $k; ?>_puesto" value="<?php echo $ppuesto; ?>">
												</div>
											</div>
										</div>
										<br>
									</div>
								</div>
							<?php 
							} ?>
							</div>
						</div>
					</div>
				</div>
			<?php 
			}
			?>
			
			<?php 
      if($parametros->cantidad_ref_personales > 0){ ?>
				<div class="card my-5">
					<h5 class="card-header text-center seccion">Personal references</h5>
					<div class="card-body">
						<h6 class="alert alert-warning card-subtitle mb-2 text-muted text-center">THESE REFERENCES MUST BE YOUR FRIENDS ONLY, NOT FAMILY. IF YOU DON'T HAVE PERSONAL REFERENCES, LEAVE EMPTY</h6>
						<?php 
						for($j = 1; $j <= $parametros->cantidad_ref_personales; $j++){
							if($pers != false){
								$pnom2 = (isset($pers[$j-1]->nombre))? $pers[$j-1]->nombre : '';
								$ptel2 = (isset($pers[$j-1]->telefono))? $pers[$j-1]->telefono : '';
								$ptiempo2 = (isset($pers[$j-1]->tiempo_conocerlo))? $pers[$j-1]->tiempo_conocerlo : '';
								$plugar2 = (isset($pers[$j-1]->donde_conocerlo))? $pers[$j-1]->donde_conocerlo : '';
							}
							else{
								$pnom2 = '';$ptel2 = '';$ptiempo2 = '';$plugar2 = '';
							} ?>
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
												<input type="text" class="form-control obligado" name="refper<?php echo $j; ?>_nombre" id="refper<?php echo $j; ?>_nombre" value="<?php echo $pnom2; ?>">
											</div>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-4">
											<label>Phone *</label>
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
												</div>
												<input type="text" class="form-control obligado" name="refper<?php echo $j; ?>_telefono" id="refper<?php echo $j; ?>_telefono" maxlength="16"value="<?php echo $ptel2; ?>">
											</div>
										</div>
										<div class="col-sm-12 col-md-4 col-lg-4">
											<label>Time to know her/him *</label>
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text"><i class="far fa-clock"></i></span>
												</div>
												<input type="text" class="form-control obligado" name="refper<?php echo $j; ?>_tiempo" id="refper<?php echo $j; ?>_tiempo" value="<?php echo $ptiempo2; ?>">
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
												<input type="text" class="form-control obligado" name="refper<?php echo $j; ?>_conocido" id="refper<?php echo $j; ?>_conocido" value="<?php echo $plugar2; ?>">
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
									<?php 
									if((isset($pers[$j-1]->sabe_trabajo))){
										echo '<script> $("#refper'.$j.'_sabetrabajo").val("'.$pers[$j-1]->sabe_trabajo.'"); </script>';
									}
									if((isset($pers[$j-1]->sabe_vive))){
										echo '<script> $("#refper'.$j.'_sabevive").val("'.$pers[$j-1]->sabe_vive.'"); </script>';
									} ?>
								</div>
							</div>
						<?php 
						} ?>
					</div>
				</div>
			<?php 
			} ?>
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
								<textarea name="obs" id="obs" class="form-control obligado" rows="5"><?php echo $info->comentario; ?></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="msj_error_form" class="alert alert-danger hidden"></div>
			<div class="row my-5">
				<div class="col-8">
					<button id="subirFormulario" class="btn btn-success btn-block form-control">Send form</button>
				</div>
				<div class="col-4">
					<button id="parte2" class="btn btn-info btn-block form-control">Go to documents upload</button>
				</div>
			</div>
		</div>
		<!-- Documentacion -->
		<div class="documentacion contenedor mt-5 hidden">
			<div class="row">
				<div class="col-lg-12">
					<p class='text-center p-3 mb-2 bg-info text-white'>Verify and try to upload all the following documents in pdf, jpg or png formats (Max. 2MB each)<br>The documents with * are required, if you don't have some document you can back to platform for upload as soon as possible.
					</p>
					<?php 
					foreach($docs_requeridos as $requerido){
						if($requerido->solicitado == 1){
					?>
						<div class="col-12 mb-5 mt-5 text-center">
							<label><?php echo $requerido->label_ingles; ?> <?php echo $simbolo = ($requerido->obligatorio == 1)? '*':''; ?></label>
							<?php
							$res = $this->candidato_model->matchDocumento($id_candidato, $requerido->id_tipo_documento);
							if ($res > 0) { ?>
								<div id="<?php echo $requerido->div_id; ?>">
									<div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
								</div>
							<?php
							} else { ?>
								<div id="<?php echo $requerido->div_id; ?>">
									<input id="<?php echo $requerido->input_id; ?>" class="obligado" type="file" name="<?php echo $requerido->input_id; ?>" accept=".pdf, .jpg, .jpeg, .png" <?php echo $multiple = ($requerido->multiple == 1)? 'multiple':''; ?>><br><br>
									<button type="button" class="btn btn-info" onclick="subirArchivo(<?php echo $requerido->id_tipo_documento ?>,'<?php echo $requerido->input_id ?>','<?php echo $requerido->div_id; ?>')">Click here to <?php echo $requerido->label_ingles; ?></button><br><br>
								</div>
							<?php	
							}
							?>
						</div>
					<?php 
						}
					}
					?>
					<div id="msj_error" class="alert alert-danger hidden"></div>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-4">
					<button id="parte1" class="btn btn-info btn-block form-control">Go to form</button>
				</div>
				<div class="col-8">
					<button class="btn btn-success btn-block" onclick="concluirDocumentacion()"><b>Finish all</b></button>
				</div>
			</div>
		</div>
  <?php
  } ?>
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
		//Verificacion de aviso de privacidad como primera accion en formulario
		var check_aviso = <?php echo $tiene_aviso; ?>;
		if (check_aviso == 0) {
			$('#checkAvisoModal').modal('show');
		}
		var id_candidato = "<?php echo $this->session->userdata('id'); ?>";
		//Asignacion de valores guardados previamente para el formulario
		var form_genero = "<?php echo $info->genero; ?>";
		$('#genero').val(form_genero);
		var form_civil = "<?php echo $info->estado_civil; ?>";
		$('#civil').val(form_civil);
		var form_pais = "<?php echo $info->pais; ?>";
		$('#pais').val(form_pais);
		var form_estudios = "<?php echo $info->id_grado_estudio; ?>";
		$('#estudios').val(form_estudios);

    $(document).ready(function() {
      $('#fecha_nacimiento').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      });
      $("#domicilio").change(function() {
        var valor = $(this).val();
        $("#h1_domicilio").val(valor);
      });
      $("#pais").change(function() {
        var pais = $(this).val();
        if (pais != '') {
          $('#h1_pais').val(pais)
        } else {
          $('#h1_pais').val('')
        }
      });
      $(".solo_numeros").on("input", function() {
				var valor = $(this).val();
				$(this).val(valor.replace(/[^0-9]/g, ''));
			});
			$('#parte2').click(function(){
				$('.documentacion').css('display','block');
				$('.formulario').css('display','none');
			})
			$('#parte1').click(function(){
				$('.documentacion').css('display','none');
				$('.formulario').css('display','block');
			})
      $('#subirFormulario').click(function() {
				var num_refpro = <?php echo $parametros->cantidad_ref_profesionales; ?>;
				var num_refper = <?php echo $parametros->cantidad_ref_personales; ?>;
				var data = new FormData();
				data.append('fecha_nacimiento', $('#fecha_nacimiento').val());
				data.append('puesto', $('#puesto').val());
				data.append('nacionalidad', $('#nacionalidad').val());
				data.append('genero', $('#genero').val());
				data.append('civil', $('#civil').val());
				data.append('telefono', $('#telefono').val());
				data.append('tel_casa', $('#tel_casa').val());
				data.append('tel_otro', $('#tel_otro').val());
				data.append('domicilio', $('#domicilio').val());
				data.append('pais', $('#pais').val());

				data.append('estudios', $('#estudios').val());
				data.append('estudios_periodo', $('#estudios_periodo').val());
				data.append('estudios_escuela', $('#estudios_escuela').val());
				data.append('estudios_ciudad', $('#estudios_ciudad').val());
				data.append('estudios_certificado', $('#estudios_certificado').val());

				for (var i = 1; i <= 25; i++) {
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

        for (var j = 1; j <= 15; j++) {
					data.append('h' + j + 'periodo', $('#h' + j + '_periodo').val());
					data.append('h' + j + 'causa', $('#h' + j + '_causa').val());
					data.append('h' + j + 'domicilio', $('#h' + j + '_domicilio').val());
					data.append('h' + j + 'pais', $('#h' + j + '_pais').val());
				}

        for (var k = 1; k <= num_refpro; k++) {
					data.append('refpro' + k + 'nombre', $('#refpro' + k + '_nombre').val());
					data.append('refpro' + k + 'telefono', $('#refpro' + k + '_telefono').val());
					data.append('refpro' + k + 'tiempo', $('#refpro' + k + '_tiempo').val());
					data.append('refpro' + k + 'conocido', $('#refpro' + k + '_conocido').val());
					data.append('refpro' + k + 'puesto', $('#refpro' + k + '_puesto').val());
				}

				for (var i = 1; i <= num_refper; i++) {
					data.append('refper' + i + 'nombre', $('#refper' + i + '_nombre').val());
					data.append('refper' + i + 'telefono', $('#refper' + i + '_telefono').val());
					data.append('refper' + i + 'tiempo', $('#refper' + i + '_tiempo').val());
					data.append('refper' + i + 'conocido', $('#refper' + i + '_conocido').val());
					data.append('refper' + i + 'sabetrabajo', $('#refper' + i + '_sabetrabajo').val());
					data.append('refper' + i + 'sabevive', $('#refper' + i + '_sabevive').val());
				}

				data.append('trabajo_inactivo', $('#trabajo_inactivo').val());
				data.append('comentarios_candidato', $('#obs').val());

				$.ajax({
					url: "<?php echo base_url('Candidato/guardarInternationalFormHCLCandidato'); ?>",
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
							Swal.fire({
								position: 'center',
								icon: 'success',
								title: 'The form has been sent successfully',
								showConfirmButton: false,
								timer: 2500
							})
						}
						else{
							$("#msj_error_form").css('display', 'block').html(data.msg);
						}
					}
				});
			});
    });
    
    function subirAvisoPrivacidad() {
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
		function concluirDocumentacion(){
			$.ajax({
				url: '<?php echo base_url('Candidato/finalizarDocumentacionCandidato'); ?>',
				method: 'POST',
				data: {
					'id_candidato': id_candidato
				},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1){
						$("#mensajeModal").modal("show");
						setTimeout(function() {
						$("#mensajeModal").modal("hide");
							window.location.href = "<?php echo base_url(); ?>Login/logout";
						}, 10000);
					}
					else{
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
		function subirArchivo(tipo,idInput, div_id) {
			var docs = new FormData();
			docs.append('tipo_documento', tipo);
			docs.append("id_candidato", id_candidato);
			var num_files = document.getElementById(idInput).files.length;
			for (var x = 0; x < num_files; x++) {
				docs.append("archivos[]", document.getElementById(idInput).files[x]);
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
						//location.reload();
						$('#'+div_id).html('<div id="'+div_id+'"><div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div></div>');
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