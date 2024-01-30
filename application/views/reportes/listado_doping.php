<!-- Begin Page Content -->
<div class="container-fluid">

	<div id="mensaje" class="alert alert-danger in mensaje" style='display:none;'>
		<p id="texto_msj"></p>
	</div>
	<section class="content-header mb-5">
		<h1 class="titulo_seccion">Reporte de Registros de Exámenes Antidoping</small></h1>
	</section>
	<div class="row">
		<div class="col-7 offset-3 mt-3">
			Consideraciones del reporte: 
			<ul>
				<li>El reporte apoya a la consulta de los candidatos con examen antidoping asignado (o sin asignar) en el(los) cliente(s) en un periodo seleccionado</li>
			</ul>
		</div>
	</div>
	<div class="loader" style="display: none;"></div>

	<div class="container">
		<form id="filtros">
			<div class="row">
				<div class="col-md-3">
					<label>Fecha de inicio *</label>
					<input type="text" class="form-control tipo_fecha" id="fecha_inicio" name="fecha_inicio" placeholder="dd/mm/yyyy" autocomplete="off">
					<br>
				</div>
				<div class="col-md-3">
					<label>Fecha final *</label>
					<input type="text" class="form-control tipo_fecha" id="fecha_fin" name="fecha_fin" placeholder="dd/mm/yyyy" autocomplete="off">
					<br>
				</div>
				<div class="col-md-3">
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
				<div class="col-md-3">
					<label>Resultado *</label>
					<select name="resultado" id="resultado" class="form-control">
						<option value="">Selecciona</option>
						<option value="">TODOS</option>
						<option value="1">Positivo</option>
						<option value="0">Negativo</option>
						<option value="-1">Sin resultado</option>
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
		var datos = new FormData();
		datos.append('fi', $("#fecha_inicio").val());
		datos.append('ff', $("#fecha_fin").val());
		datos.append('cliente', $("#cliente").val());
		datos.append('resultado', $("#resultado").val());
		$.ajax({
			url: '<?php echo base_url('Reporte/reporteListadoDoping'); ?>',
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
					$('#msj_error').css('display', 'block').html(data.msg);
				}
			}
		});
	}

	function consultarDopingGeneral() {
		var reporte = $("#tipo_reporte").val();
		var fi = $("#r3_fecha_inicio").val();
		var ff = $("#r3_fecha_fin").val();
		var cliente = $("#r3_cliente").val();
		var subcliente = $("#r3_subcliente").val();
		var proyecto = $("#r3_proyecto").val();
		if (reporte == "" || fi == "" || ff == "") {
			$("#texto_msj").text('Se requiere elegir el tipo de archivo y las fechas de consulta');
			$("#mensaje").css('display', 'block');
			setTimeout(function() {
				$('#mensaje').fadeOut();
			}, 6000);
		} else {
			if (reporte == 3) {
				$.ajax({
					url: '<?php echo base_url('Reporte/reporteDopingGeneral'); ?>',
					type: 'post',
					data: {
						'fi': fi,
						'ff': ff,
						'cliente': cliente,
						'subcliente': subcliente,
						'proyecto': proyecto
					},
					beforeSend: function() {
						$('.loader').css("display", "block");
					},
					success: function(res) {
						setTimeout(function() {
							$('.loader').fadeOut();
						}, 300);
						$("#div_reporte").css('display', 'block');
						$("#html_reporte").html(res);
					}
				});
			}
		}
	}

	function consultarESEFinalizados() {
		var reporte = $("#tipo_reporte").val();
		var fi = $("#r2_fecha_inicio").val();
		var ff = $("#r2_fecha_fin").val();
		var cliente = $("#r2_cliente").val();
		var usuario = $("#r2_usuario").val();
		if (usuario == "" || fi == "" || ff == "") {
			$("#texto_msj").text('Se requiere elegir el usuario y las fechas de consulta');
			$("#mensaje").css('display', 'block');
			setTimeout(function() {
				$('#mensaje').fadeOut();
			}, 6000);
		} else {
			if (reporte == 2) {
				$.ajax({
					url: '<?php echo base_url('Reporte/reporteEstudiosFinalizados'); ?>',
					type: 'post',
					data: {
						'fi': fi,
						'ff': ff,
						'cliente': cliente,
						'usuario': usuario
					},
					beforeSend: function() {
						$('.loader').css("display", "block");
					},
					success: function(res) {
						setTimeout(function() {
							$('.loader').fadeOut();
						}, 300);
						$("#div_reporte").css('display', 'block');
						$("#html_reporte").html(res);
					}
				});
			}
		}
	}
	//Acepta solo numeros en los input
	$(".solo_numeros").on("input", function() {
		var valor = $(this).val();
		$(this).val(valor.replace(/[^0-9]/g, ''));
	});
</script>