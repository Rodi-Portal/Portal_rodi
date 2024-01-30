<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Upload Documents | RODI</title>
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
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Success!</h4>
				</div>
				<div class="modal-body">
					<h5>Your documents have been uploaded successfully if we need any further documentacion or information we will contact you please, be aware.</h5>
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
	<div class="formulario contenedor mt-5">
		<div class="row">
			<div class="col-lg-12">
				<p class='text-center p-3 mb-2 bg-info text-white'>Verify and try to upload all the following documents in pdf, jpg or png formats (Max. 2MB each)<br>The documents with * are required, if you don't have some document you can back to platform for upload as soon as possible.
				</p>
				<?php 
				foreach($docs_requeridos as $requerido){
				?>
					<div class="col-sm-12 col-md-6 mb-5 mt-5 text-center flota_izq">
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
								<button type="button" class="btn btn-info" onclick="subirArchivo(<?php echo $requerido->id_tipo_documento ?>,'<?php echo $requerido->input_id ?>')">Click here to <?php echo $requerido->label_ingles; ?></button><br><br>
							</div>
						<?php	
						}
						?>
					</div>
				<?php 
				}
				?>
				<div id="msj_error" class="alert alert-danger hidden"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<button class="btn btn-success btn-block" onclick="concluirDocumentacion()"><b>Finish</b></button>
			</div>
		</div>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
	<!-- Sweetalert 2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
	<!-- Bootstrap Select -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
	<script>
		var id_candidato = "<?php echo $id_candidato; ?>";
		var nombre = "<?php echo $nombre; ?>";
		var paterno = "<?php echo $paterno; ?>";
		var prefijo = id_candidato + "_" + nombre + "_" + paterno;
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
		function subirArchivo(tipo,idInput) {
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