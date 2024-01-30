<!-- Begin Page Content -->
<div class="container-fluid">

	<div id="mensaje" class="alert alert-danger in mensaje" style='display:none;'>
		<p id="texto_msj"></p>
	</div>
	<section class="content-header mb-5">
		<h1 class="titulo_seccion">Reporte de Registros de Clientes</small></h1>
	</section>
	<!--div class="row">
		<div class="col-7 offset-3 mt-3">
			Consideraciones del reporte: 
			<ul>
				<li>El reporte apoya a la consulta de los candidatos con examen antidoping asignado (o sin asignar) en el(los) cliente(s) en un periodo seleccionado</li>
			</ul>
		</div>
	</div-->
	<div class="loader" style="display: none;"></div>

	<div class="container">
		<form id="filtros">
			<div class="row">
				<div class="col-md-8 offset-2">
					<label>Cliente *</label>
					<select name="cliente" id="cliente" class="form-control">
						<option value="">Selecciona</option>
						<option value="0">TODOS</option>
						<?php
						foreach ($clientes as $cl) { ?>
							<option value="<?php echo $cl->id; ?>"><?php echo $cl->nombre; ?></option>
						<?php }
						?>
					</select>
					<br>
				</div>
			</div>
		</form>
		<div class="row mt-3 mb-5">
			<div class="col-4 offset-5">
				<a href="javascript:void(0)" class="btn btn-primary" onclick="consultar()">Consultar</a>
				<br>
			</div>
		</div>
		<div id="div_reporte">
			<h2>Datos consultados: </h2>
			<div id="html_reporte"></div>
		</div>
	</div>


</div>
<!-- InputMask -->
<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.extensions.js"></script>

<!-- Sweetalert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
<script>
	$(document).ready(function() {
		$('.tipo_fecha').inputmask('dd/mm/yyyy', {
			'placeholder': 'dd/mm/yyyy'
		});
	})

	function consultar() {
		var datos = new FormData();
		//datos.append('fi', $("#fecha_inicio").val());
		//datos.append('ff', $("#fecha_fin").val());
		datos.append('cliente', $("#cliente").val());
		//datos.append('resultado', $("#resultado").val());
		$.ajax({
			url: '<?php echo base_url('Reporte/reporteListadoClientes'); ?>',
			type: 'post',
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
				var dato = JSON.parse(res);
				if(dato.codigo === 1){
					$("#html_reporte").html(dato.msg);
				}
				else{
					Swal.fire({
            position: 'center',
            icon: 'error',
            title: dato.msg,
            showConfirmButton: false,
            timer: 2500
          })
				}
			}
		});
	}
	//Acepta solo numeros en los input
	$(".solo_numeros").on("input", function() {
		var valor = $(this).val();
		$(this).val(valor.replace(/[^0-9]/g, ''));
	});
</script>