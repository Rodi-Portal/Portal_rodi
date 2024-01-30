<!-- Begin Page Content -->
<div class="container-fluid">

	<div id="mensaje" class="alert alert-danger in mensaje" style='display:none;'>
		<p id="texto_msj"></p>
	</div>
	<section class="content-header">
		<h1 class="titulo_seccion">Reportes</small></h1>
	</section>
	<div class="loader" style="display: none;"></div>
	<a href="#" class="scroll-to-top"><i class="fas fa-arrow-up"></i><span class="sr-only">Ir arriba</span></a>
	<section class="content" id="listado">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<!--div class="box-header">
	              		<h3 class="box-title"><strong>  Selecciona el reporte a generar</strong></h3>
	            	</div-->
					<!-- /.box-header -->
					<div class="box-body table-responsive">
						<div>
							<br>
							<select name="tipo_reporte" id="tipo_reporte" class="form-control">
								<option value="">Selecciona el tipo de reporte</option>
								<option value="1">Registros de Doping Finalizados</option>
								<option value="3">Registros de Doping General</option>
								<option value="2">ESE finalizados por Analistas</option>
							</select>
							<br>
						</div>
						<div>
							<div class="box-header">
								<h3 class="box-title"><strong> Filtros del reporte</strong></h3>
							</div>
							<div class="repo1">
								<div class="row">
									<div class="col-md-2">
										<input type="text" class="form-control" id="fecha_inicio" placeholder="Fecha inicio" autocomplete="off">
										<br>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control" id="fecha_fin" placeholder="Fecha final" autocomplete="off">
										<br>
									</div>
									<div class="col-md-2">
										<select name="cliente" id="cliente" class="form-control nuevo_obligado">
											<option value="">Selecciona Cliente</option>
											<option value="0">TODOS</option>
											<?php
											foreach ($clientes as $cl) { ?>
												<option value="<?php echo $cl->id; ?>"><?php echo $cl->nombre; ?></option>
											<?php }
											?>
										</select>
										<br>
									</div>
									<div class="col-md-2">
										<select name="subcliente" id="subcliente" class="form-control nuevo_obligado">
											<option value="">Selecciona Subcliente</option>
										</select>
										<br>
									</div>
									<div class="col-md-2">
										<select name="proyecto" id="proyecto" class="form-control nuevo_obligado">
											<option value="">Selecciona Proyecto</option>
										</select>
										<br>
									</div>
									<div class="col-md-2">
										<select name="resultado_doping" id="resultado_doping" class="form-control nuevo_obligado">
											<option value="">Selecciona Resultado</option>
											<option value="1">Positivo</option>
											<option value="0">Negativo</option>
										</select>
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2">
										<select name="lab" id="lab" class="form-control nuevo_obligado">
											<option value="">Selecciona Laboratorio</option>
											<option value="GUADALAJARA">GUADALAJARA</option>
											<option value="LAPI">LAPI</option>
										</select>
										<br>
									</div>
									<div class="col-md-2">
										<a href="javascript:void(0)" class="btn btn-primary" onclick="consultarDopingFinalizados()">Consultar</a>
										<br>
									</div>
								</div>
							</div>
							<div class="repo2">
								<div class="row">
									<div class="col-md-3">
										<input type="text" class="form-control" id="r2_fecha_inicio" placeholder="Fecha inicio" autocomplete="off">
										<br>
									</div>
									<div class="col-md-3">
										<input type="text" class="form-control" id="r2_fecha_fin" placeholder="Fecha final" autocomplete="off">
										<br>
									</div>
									<div class="col-md-3">
										<select name="r2_usuario" id="r2_usuario" class="form-control nuevo_obligado">
											<option value="">Selecciona Analista</option>
											<option value="0">TODOS</option>
											<?php
											foreach ($usuarios as $u) { ?>
												<option value="<?php echo $u->id; ?>"><?php echo $u->nombre . ' ' . $u->paterno; ?></option>
											<?php }
											?>
										</select>
										<br>
									</div>
									<div class="col-md-3">
										<select name="r2_cliente" id="r2_cliente" class="form-control nuevo_obligado">
											<option value="">Selecciona Cliente</option>
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
								<div class="row">
									<div class="col-md-3">
										<a href="javascript:void(0)" class="btn btn-primary" onclick="consultarESEFinalizados()">Consultar</a>
										<br>
									</div>
								</div>
							</div>
							<div class="repo3">
								<div class="row">
									<div class="col-md-3">
										<input type="text" class="form-control" id="r3_fecha_inicio" placeholder="Fecha inicio" autocomplete="off">
										<br>
									</div>
									<div class="col-md-3">
										<input type="text" class="form-control" id="r3_fecha_fin" placeholder="Fecha final" autocomplete="off">
										<br>
									</div>
									<div class="col-md-3">
										<select name="r3_cliente" id="r3_cliente" class="form-control nuevo_obligado">
											<option value="">Selecciona Cliente</option>
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
										<select name="r3_subcliente" id="r3_subcliente" class="form-control nuevo_obligado">
											<option value="">Selecciona Subcliente</option>
										</select>
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<select name="r3_proyecto" id="r3_proyecto" class="form-control nuevo_obligado">
											<option value="">Selecciona Proyecto</option>
										</select>
										<br>
									</div>
									<div class="col-md-3">
										<a href="javascript:void(0)" class="btn btn-primary" onclick="consultarDopingGeneral()">Consultar</a>
										<br>
									</div>
								</div>
							</div>
						</div>
						<div id="div_reporte">
							<div id="html_reporte"></div>
						</div>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
		</div>
	</section>
</div>
<!-- /.content-wrapper -->
<script>
	$(document).ready(function() {
		$(".repo1, .repo2, .repo3").css('display', 'none');
		$('#fecha_inicio, #fecha_fin, #r2_fecha_inicio, #r2_fecha_fin, #r3_fecha_inicio, #r3_fecha_fin').inputmask('dd/mm/yyyy', {
			'placeholder': 'dd/mm/yyyy'
		});

		$("#tipo_reporte").change(function() {
			var reporte = $(this).val();
			if (reporte != "") {
				if (reporte == 1) {
					$(".repo1").css('display', 'initial');
					$(".repo3").css('display', 'none');
					$(".repo2").css('display', 'none');
				}
				if (reporte == 2) {
					$(".repo1").css('display', 'none');
					$(".repo3").css('display', 'none');
					$(".repo2").css('display', 'initial');
				}
				if (reporte == 3) {
					$(".repo1").css('display', 'none');
					$(".repo2").css('display', 'none');
					$(".repo3").css('display', 'initial');
				}
			} else {
				$(".repo1").css('display', 'none');
				$(".repo2").css('display', 'none');
				$(".repo3").css('display', 'none');
				$("#fecha_inicio").val('');
				$("#fecha_fin").val('');
				$("#cliente").val('');
				$("#subcliente").val('');
				$("#proyecto").val('');
				$("#resultado_doping").val('');
				$("#lab").val('');
				$("#r2_fecha_inicio").val('');
				$("#r2_fecha_fin").val('');
				$("#r2_usuario").val('');
				$("#r2_cliente").val('');
				$("#r3_fecha_inicio").val('');
				$("#r3_fecha_fin").val('');
				$("#r3_cliente").val('');
				$("#r3_subcliente").val('');
				$("#r3_proyecto").val('');
				$("#html_reporte").empty();
			}
		});
		$("#cliente").change(function() {
			var id_cliente = $(this).val();
			if (id_cliente != "" && id_cliente != 0) {
				$.ajax({
					url: '<?php echo base_url('Reporte/getSubclientes'); ?>',
					method: 'POST',
					data: {
						'id_cliente': id_cliente
					},
					dataType: "text",
					success: function(res) {
						$('#subcliente').prop('disabled', false);
						$('#subcliente').html(res);
					}
				});
				$.ajax({
					url: '<?php echo base_url('Reporte/getProyectos'); ?>',
					method: 'POST',
					data: {
						'id_cliente': id_cliente
					},
					dataType: "text",
					success: function(res) {
						$('#proyecto').prop('disabled', false);
						$('#proyecto').html(res);
					}
				});
			}
			if (id_cliente == 0 || id_cliente == "") {
				$('#subcliente').prop('disabled', true);
				$('#subcliente').append($("<option selected></option>").attr("value", "").text("Selecciona Subcliente"));
				$('#proyecto').prop('disabled', true);
				$('#proyecto').append($("<option selected></option>").attr("value", "").text("Selecciona Proyecto"));
			}
		});
		$("#r3_cliente").change(function() {
			var id_cliente = $(this).val();
			if (id_cliente != "" && id_cliente != 0) {
				$.ajax({
					url: '<?php echo base_url('Reporte/getSubclientes'); ?>',
					method: 'POST',
					data: {
						'id_cliente': id_cliente
					},
					dataType: "text",
					success: function(res) {
						$('#r3_subcliente').prop('disabled', false);
						$('#r3_subcliente').html(res);
					}
				});
				$.ajax({
					url: '<?php echo base_url('Reporte/getProyectos'); ?>',
					method: 'POST',
					data: {
						'id_cliente': id_cliente
					},
					dataType: "text",
					success: function(res) {
						$('#r3_proyecto').prop('disabled', false);
						$('#r3_proyecto').html(res);
					}
				});
			}
			if (id_cliente == 0 || id_cliente == "") {
				$('#r3_subcliente').prop('disabled', true);
				$('#r3_subcliente').append($("<option selected></option>").attr("value", "").text("Selecciona Subcliente"));
				$('#r3_proyecto').prop('disabled', true);
				$('#r3_proyecto').append($("<option selected></option>").attr("value", "").text("Selecciona Proyecto"));
			}
		});
	})

	function consultarDopingFinalizados() {
		var reporte = $("#tipo_reporte").val();
		var fi = $("#fecha_inicio").val();
		var ff = $("#fecha_fin").val();
		var cliente = $("#cliente").val();
		var subcliente = $("#subcliente").val();
		var proyecto = $("#proyecto").val();
		var res = $("#resultado_doping").val();
		var lab = $("#lab").val();
		if (reporte == "" || fi == "" || ff == "") {
			$("#texto_msj").text('Se requiere elegir el tipo de archivo y las fechas de consulta');
			$("#mensaje").css('display', 'block');
			setTimeout(function() {
				$('#mensaje').fadeOut();
			}, 6000);
		} else {
			if (reporte == 1) {
				$.ajax({
					url: '<?php echo base_url('Reporte/reporteDopingFinalizados'); ?>',
					type: 'post',
					data: {
						'fi': fi,
						'ff': ff,
						'cliente': cliente,
						'subcliente': subcliente,
						'proyecto': proyecto,
						'res': res,
						'lab': lab
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
	/*function generarExcel(){
		var reporte = $("#tipo_reporte").val();
		var fi = $("#fecha_inicio").val();
		var ff = $("#fecha_fin").val();
		var cliente = $("#cliente").val();
		var subcliente = $("#subcliente").val();
		var proyecto = $("#proyecto").val();
		if(reporte == "" || fi == "" || ff == ""){
			$("#texto_msj").text('Se requiere elegir el tipo de archivo y las fechas de consulta');
    		$("#mensaje").css('display','block');
    		setTimeout(function(){
          		$('#mensaje').fadeOut();
        	},6000);
		}
		else{
			if(reporte == 1){
				$.ajax({
	              	url: '<?php echo base_url('Reporte/reporteRegistrosDoping_Excel'); ?>',
	              	type: 'post',
	              	data: {'fi':fi,'ff':ff,'cliente':cliente,'subcliente':subcliente,'proyecto':proyecto},
	              	beforeSend: function() {
	                	$('.loader').css("display","block");
	              	},
	              	success : function(res){ 
	              		setTimeout(function(){
	                  		$('.loader').fadeOut();
	                	},300);
	            		$("#div_reporte").css('display','block');
	            		$("#html_reporte").html(res);
	              	},error: function(res){
	                	$('#errorModal').modal('show');
	              	}
	        	});
			}
		}
	}*/
	//Acepta solo numeros en los input
	$(".solo_numeros").on("input", function() {
		var valor = $(this).val();
		$(this).val(valor.replace(/[^0-9]/g, ''));
	});
</script>