<!-- Begin Page Content -->
<div class="container-fluid">

	<div id="mensaje" class="alert alert-danger in mensaje" style='display:none;'>
		<p id="texto_msj"></p>
	</div>
	<section class="content-header mb-5">
		<h1 class="titulo_seccion">Reporte de Procesos de Reclutamiento</small></h1>
    <div class="alert alert-info text-center">Consideraciones del reporte:<br>- El reporte contempla las requisiciones en proceso y los aspirantes/candidatos asignados a alguna requisición
    </div>
	</section>
	
	<div class="loader" style="display: none;"></div>

	<div style="width: 90%; margin: 0px auto;">
		<form id="filtros">
			<div class="row">
				<div class="col-md-3 offset-2">
					<label>Fecha de inicio *</label>
					<input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
					<br>
				</div>
				<div class="col-md-3">
					<label>Fecha final *</label>
					<input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
					<br>
				</div>
				<div class="col-md-3">
					<label>Reclutador(a) *</label>
					<select name="usuario" id="usuario" class="form-control">
						<option value="">Selecciona</option>
						<option value="0">TODOS</option>
						<?php
						foreach ($usuarios as $row) { ?>
							<option value="<?php echo $row->id; ?>"><?php echo $row->usuario; ?></option>
						<?php }
						?>
					</select>
					<br>
				</div>
				<!-- <div class="col-md-3">
					<label>Estatus actual *</label>
					<select name="estatus" id="estatus" class="form-control">
						<option value="">TODOS</option>
						<option value="1">En proceso</option>
						<option value="2">Finalizado</option>
					</select>
					<br>
				</div>
        <div class="col-md-3">
					<label>Resultado *</label>
					<select name="resultado" id="resultado" class="form-control">
						<option value="">TODOS</option>
						<option value="1">Recomendable</option>
						<option value="2">No recomendable</option>
						<option value="3">A consideración</option>
						<option value="4">Referencias validadas</option>
						<option value="5">Referencias con inconsistencias</option>
					</select>
					<br>
				</div> -->
			</div>
		</form>
		<div class="row mt-3 mb-5">
			<div class="col-4 offset-6">
				<a href="javascript:void(0)" class="btn btn-primary" onclick="consultar()">Obtener resultados</a>
				<br>
			</div>
		</div>
		<div class="row">
			<div id="msj_error" class="alert alert-danger hidden"></div>
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
    let form = $('#filtros').serialize();
    form += '&usuario=' + $("#usuario").val();
		$.ajax({
			url: '<?php echo base_url('Reporte/reporteProcesoReclutamiento'); ?>',
			type: 'post',
			data: form,
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