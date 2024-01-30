<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->
	<div class="align-items-center mb-4">
		<div class="row">
			<div class="col-sm-12 col-md-8">
				<h1 class="h3 mb-0 text-gray-800">Subclientes</h1>
			</div>
			<div class="col-sm-12 col-md-2">
				<a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#newModal">
					<span class="icon text-white-50">
						<i class="fas fa-plus-circle"></i>
					</span>
					<span class="text">Agregar subcliente</span>
				</a>
			</div>
			<div class="col-sm-12 col-md-2">
				<a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#accesoModal">
					<span class="icon text-white-50">
						<i class="fas fa-plus-circle"></i>
					</span>
					<span class="text">Acceso a subclientes</span>
				</a>
			</div>
		</div>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"></h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table id="tabla" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				</table>
			</div>
		</div>
	</div>

	<?php echo $modals; ?>
	<div class="loader" style="display: none;"></div>
	<input type="hidden" id="idCliente">
	<input type="hidden" id="idSubcliente">
	<input type="hidden" id="idUsuarioSubcliente">

</div>
<!-- /.content-wrapper -->
<script>
	var url = '<?php echo base_url('Cat_Subclientes/getSubclientes'); ?>';
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
		$('#newModal').on('shown.bs.modal', function() {
			$(this).find('input[type=text],select,textarea').filter(':visible:first').focus();
		});
		var msj = localStorage.getItem("success");
		if (msj == 1) {
			Swal.fire({
				position: 'center',
				icon: 'success',
				title: 'Se ha guardado correctamente',
				showConfirmButton: false,
				timer: 2500
			})
			localStorage.removeItem("success");
		}
		$('#tabla').DataTable({
			"pageLength": 25,
			//"pagingType": "simple",
			"order": [0, "desc"],
			"stateSave": true,
			"ajax": url,
			"columns": [
				{ 
					title: 'id', 
					data: 'id', 
					visible: false
				},
				{
					title: 'Nombre',
					data: 'nombre',
					bSortable: false,
					"width": "20%",
				},
				{
					title: 'Clave',
					data: 'clave',
					bSortable: false,
					"width": "3%",
				},
				{
					title: 'Cliente',
					data: 'cliente',
					bSortable: false,
					"width": "15%",
				},
				{
					title: 'Fecha de alta',
					data: 'creacion',
					bSortable: false,
					"width": "10%",
					mRender: function(data, type, full) {
						var f = data.split(' ');
						var h = f[1];
						var aux = h.split(':');
						var hora = aux[0] + ':' + aux[1];
						var aux = f[0].split('-');
						var fecha = aux[2] + "/" + aux[1] + "/" + aux[0];
						var tiempo = fecha + ' ' + hora;
						return tiempo;
					}
				},
				{
					title: 'Accesos',
					data: 'numero_accesos',
					bSortable: false,
					"width": "15%",
					mRender: function(data, type, full) {
						if (data == 0) {
							return 'Sin registro de accesos';
						} else {
							return 'Cuenta con ' + data + ' registro(s) de acceso';
						}
					}
				},
				{
					title: 'Operaciones',
					data: 'id',
					bSortable: false,
					"width": "10%",
					mRender: function(data, type, full) {
						if (full.status == 0) {
							return '<a id="editar" href="javascript:void(0)" data-toggle="tooltip" title="Editar" class="fa-tooltip icono_datatable"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Activar" id="activar" class="fa-tooltip icono_datatable accion_desactiva"><i class="fas fa-ban text-red"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar cliente" id="eliminar" class="fa-tooltip icono_datatable"><i class="fas fa-trash"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Ver accesos" id="acceso" class="fa-tooltip icono_datatable"><i class="fas fa-sign-in-alt"></i></a>';
						}
						if (full.status == 1) {
							return '<a id="editar" href="javascript:void(0)" data-toggle="tooltip" title="Editar" class="fa-tooltip icono_datatable"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Desactivar" id="desactivar" class="fa-tooltip icono_datatable accion_activa"><i class="far fa-check-circle text-green"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar cliente" id="eliminar" class="fa-tooltip icono_datatable"><i class="fas fa-trash"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Ver accesos" id="acceso" class="fa-tooltip icono_datatable"><i class="fas fa-sign-in-alt"></i></a>';
						}
					}
				}
			],
			fnDrawCallback: function(oSettings) {
				$('a[data-toggle="tooltip"]').tooltip({
					trigger: "hover"
				});
			},
			rowCallback: function(row, data) {
				$("a#editar", row).bind('click', () => {
					$("#idSubcliente").val(data.id);
					$(".modal-title").text("Editar subcliente");
					$("#nombre").val(data.nombre);
					$("#cliente").val(data.id_cliente);
					$("#clave").val(data.clave);
					$("#guardar").attr('value', 'editar');
					$("#newModal").modal("show");
				});
				$("a#activar", row).bind('click', () => {
					$("#idSubcliente").val(data.id);
					$("#idUsuarioSubcliente").val(data.idUsuarioSubcliente);
					$("#titulo_accion").text("Activar subcliente");
					$("#texto_confirmacion").html("¿Estás seguro de activar el subcliente <b>" + data.nombre + "</b>?");
					$("#accion").attr('value', 'activar');
					$("#quitarModal").modal("show");
				});
				$("a#desactivar", row).bind('click', () => {
					$("#idSubcliente").val(data.id);
					$("#idUsuarioSubcliente").val(data.idUsuarioSubcliente);
					$("#titulo_accion").text("Desactivar subcliente");
					$("#texto_confirmacion").html("¿Estás seguro de desactivar el subcliente <b>" + data.nombre + "</b>?");
					$("#accion").attr('value', 'desactivar');
					$("#quitarModal").modal("show");
				});
				$("a#eliminar", row).bind('click', () => {
					$("#idSubcliente").val(data.id);
					$("#titulo_accion").text("Eliminar subcliente");
					$("#texto_confirmacion").html("¿Estás seguro de eliminar el subcliente <b>" + data.nombre + "</b>?");
					$("#accion").attr('value', 'eliminar');
					$("#quitarModal").modal("show");
				});
				$("a#acceso", row).bind('click', () => {
					$.ajax({
						url: '<?php echo base_url('Cat_Subclientes/getSubclientesAccesos'); ?>',
						type: 'post',
						data: {
							'id_subcliente': data.id
						},
						beforeSend: function() {
							$('.loader').css("display", "block");
						},
						success: function(res) {
							setTimeout(function(){
									$('.loader').fadeOut();
							},200);
							$("#nombreSubcliente").text(data.nombre);
							$("#div_accesos").html(res);
							$("#accesosClienteModal").modal('show');
						}
					});
				});
			},
			"language": {
				"lengthMenu": "Mostrar _MENU_ registros por página",
				"zeroRecords": "No se encontraron registros",
				"info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				"infoEmpty": "Sin registros disponibles",
				"infoFiltered": "(Filtrado _MAX_ registros totales)",
				"sSearch": "Buscar:",
				"oPaginate": {
					"sLast": "Última página",
					"sFirst": "Primera",
					"sNext": "Siguiente",
					"sPrevious": "Anterior"
				}
			}
		});
		$("#guardar").click(function() {
			var nombre = $("#nombre").val();
			var cliente = $("#cliente").val();
			var clave = $("#clave").val();
			var id = $("#idSubcliente").val();
			var opcion = $(this).val();
			if (opcion == "nuevo") {
				$.ajax({
					url: '<?php echo base_url('Cat_Subclientes/registrar'); ?>',
					type: 'POST',
					data: {
						'nombre': nombre,
						'cliente': cliente,
						'clave': clave
					},
					beforeSend: function() {
						$('.loader').css("display", "block");
					},
					success: function(res) {
						setTimeout(function(){
							$('.loader').fadeOut();
						},200);
						var data = JSON.parse(res);
						if (data.codigo === 1){
							setTimeout(function() {
								$('.loader').fadeOut();
								$("#newModal").modal('hide')
								localStorage.setItem("success", 1);
								location.reload();
							}, 200);
						} 
						else {
							$("#newModal #msj_error").css('display', 'block').html(data.msg);
						}
					}
				});
			}
			if (opcion == "editar") {
				$.ajax({
					url: '<?php echo base_url('Cat_Subclientes/editar'); ?>',
					type: 'POST',
					data: {
						'nombre': nombre,
						'cliente': cliente,
						'id': id,
						'clave': clave
					},
					beforeSend: function() {
						$('.loader').css("display", "block");
					},
					success: function(res) {
						setTimeout(function(){
							$('.loader').fadeOut();
						},200);
						var data = JSON.parse(res);
						if (data.codigo === 1){
							$("#newModal").modal('hide')
							recargarTable()
							Swal.fire({
								position: 'center',
								icon: 'success',
								title: 'Se ha guardado correctamente',
								showConfirmButton: false,
								timer: 2500
							})
						} 
						else {
							$("#newModal #msj_error").css('display', 'block').html(data.msg);
						}
					}
				});
			}
		});
		$("#crear_acceso").click(function() {
			var nombre = $("#nombre_cliente").val();
			var paterno = $("#paterno_cliente").val();
			var correo = $("#correo_cliente").val();
			var password = $("#password").val();
			var id = $("#id_subcliente").val();
			var id_cliente = $("#id_cliente").val();

			$.ajax({
				url: '<?php echo base_url('Cat_Subclientes/registrarUsuario'); ?>',
				type: 'POST',
				data: {
					'nombre': nombre,
					'paterno': paterno,
					'correo': correo,
					'password': password,
					'id': id,
					'id_cliente': id_cliente
				},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function(){
						$('.loader').fadeOut();
					},200);
					var data = JSON.parse(res);
					if (data.codigo === 1){
						$("#accesoModal").modal('hide')
						recargarTable()
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha guardado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} 
					else {
						$("#accesoModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		});
		$("#id_cliente").change(function() {
			var id_cliente = $(this).val();
			var id_subcliente = $("#subcliente").val();
			if (id_cliente != "") {
				$.ajax({
					url: '<?php echo base_url('Cat_Subclientes/getOpcionesSubclientes'); ?>',
					method: 'POST',
					data: {
						'id_cliente': id_cliente
					},
					dataType: "text",
					success: function(res) {
						$('#id_subcliente').prop('disabled', false);
						$('#id_subcliente').html(res);
					}
				});
			} else {
				$('#id_subcliente').prop('disabled', true);
				$('#id_subcliente').val('');
			}
		});
		
	});
	function eliminarAcceso(idUsuarioSubcliente) {
		$("tr#" + idUsuarioSubcliente).hide();
		$.ajax({
			url: '<?php echo base_url('Cat_Subclientes/controlAcceso'); ?>',
			type: 'post',
			data: {
				'idUsuarioSubcliente': idUsuarioSubcliente,
				'activo': -1
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
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha eliminado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} 
			}
		});
	}
	function generarPassword() {
		$.ajax({
			url: '<?php echo base_url('Funciones/generarPassword'); ?>',
			type: 'post',
			beforeSend: function() {
				$('.loader').css("display", "block");
			},
			success: function(res) {
				setTimeout(function() {
					$('.loader').fadeOut();
				}, 200);
				$("#password").val(res)
			}
		});
	}
	function recargarTable() {
		$("#tabla").DataTable().ajax.reload();
	}
	function ejecutarOperacion() {
		var accion = $("#accion").val();
		var id = $("#idSubcliente").val();
		var id_usuario_subcliente = $("#idUsuarioSubcliente").val();
		$.ajax({
			url: '<?php echo base_url('Cat_Subclientes/accion'); ?>',
			type: 'post',
			data: {
				'id': id,
				'id_usuario_subcliente': id_usuario_subcliente,
				'accion': accion
			},
			beforeSend: function() {
				$('.loader').css("display", "block");
			},
			success: function(res) {
				setTimeout(function(){
						$('.loader').fadeOut();
				},200);
				var data = JSON.parse(res);
				if (data.codigo === 1){
					$("#quitarModal").modal('hide')
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} 
			}
		});
	}
</script>