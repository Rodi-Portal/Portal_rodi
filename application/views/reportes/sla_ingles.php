<!-- Begin Page Content -->
<div class="container-fluid">

	<div id="mensaje" class="alert alert-danger in mensaje" style='display:none;'>
		<p id="texto_msj"></p>
	</div>
	<section class="content-header mb-5">
		<h1 class="titulo_seccion">Reporte SLA para Clientes en Inglés</small></h1>
	</section>
	<div class="row">
		<div class="col-7 offset-3 mt-3">
			Consideraciones del reporte: 
			<ul>
				<li>Por el momento solo funciona para el cliente HCL. Para otros clientes puede que surjan datos erróneos.</li>
				<li>El dato 'Register date' de la consulta representa la fecha de alta del candidato.</li>
				<li>El dato 'Start date' representa la fecha registrada por la(el) analista que indica el inicio real del proceso del candidato.</li>
				<li>El dato 'Process days' indica los días reales de trabajo del ESE del candidato, tomando en cuenta un inicio y un fin o transcurso de los días. Para el cálculo de los 'Process days' se toma en cuenta el dato 'Start date' como el inicio, en caso de no tener este dato, se tomará en cuenta el dato 'Register date'. El dato 'Finished date' indica la fecha de conclusión del estudio del candidato, en caso de no tener este dato se toma el día actual del sistema (horario de la Ciudad de México). Para este cálculo no se toman en cuenta días festivos ni fines de semana.</li>
				<li>Por cuestiones de política, si un candidato es registrado o su proceso inicia antes de las 4pm, se toma el día en cuestión en el conteo para el dato 'Process days'.</li>
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
						<label>¿Se requiere proceso finalizado? *</label>
						<select name="finalizado" id="finalizado" class="form-control">
							<option value="">Selecciona</option>
							<option value="Si">Sí</option>
							<option value="No">No</option>
							<option value="0">TODOS</option>
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
		datos.append('finalizado', $("#finalizado").val());
		$.ajax({
			url: '<?php echo base_url('Reporte/reporteSLAIngles'); ?>',
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
					//$("#div_reporte").css('display', 'block');
					$("#html_reporte").html(dato.msg);

				}
				else{
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: data.msg,
						showConfirmButton: false,
						timer: 3000
					})
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