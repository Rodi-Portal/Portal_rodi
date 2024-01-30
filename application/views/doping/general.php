<!-- Begin Page Content -->
<div class="container-fluid">

	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Registros generales</small></h1><br>
		<br>
		<a href="#" class="btn btn-primary btn-icon-split" onclick="nuevoRegistro()">
			<span class="icon text-white-50">
				<i class="fas fa-plus-circle"></i>
			</span>
			<span class="text">Registrar examen</span>
		</a>
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
	<input type="hidden" id="idDoping">
	<input type="hidden" id="idCandidato">
	<input type="hidden" id="codigo">
	<input type="hidden" name="lab_idDoping" id="lab_idDoping">

</div>
<!-- /.content-wrapper -->
<script>
	var url = '<?php echo base_url('Doping/getDopingsGenerales'); ?>';
	var img = '<?php echo base_url(); ?>_doping/';
	var imgDefault = '<?php echo base_url(); ?>_doping/default.png';
	$(document).ready(function() {
		$('.tipo_fecha').inputmask('dd/mm/yyyy', {
			'placeholder': 'dd/mm/yyyy'
		});
		$('.tipo_fecha_hora').inputmask("datetime", {
			"placeholder": "dd-mm-yyyy hh:mm"
		});
		// var msj = localStorage.getItem("success");
		// if (msj == 1) {
		// 	Swal.fire({
		// 		position: 'center',
		// 		icon: 'success',
		// 		title: 'Se ha actualizado correctamente',
		// 		showConfirmButton: false,
		// 		timer: 2500
		// 	})
		// 	localStorage.removeItem("success");
		// }
		$('#tabla').DataTable({
			"pageLength": 25,
			//"pagingType": "simple",
			"order": [0, "desc"],
			"stateSave": true,
			"ajax": url,
			"columns": [{
					title: 'ID',
					data: 'id',
					"bVisible": false
				},
				{
					title: 'Candidato',
					data: 'candidato',
					bSortable: false,
					width: '25%',
					mRender: function(data, type, full) {
						return '<span data-toggle="tooltip" title="' + full.id_candidato + '">' + data + '</span><br>' + '<small><b>('+full.usuario+')</b></small>';
					}
				},
				{
					title: 'Cliente',
					data: 'cliente',
					bSortable: false,
					mRender: function(data, type, full) {
						var cliente = '<small>Cliente: </small>' + data;

						if (full.id_subcliente == 0 && full.id_proyecto == 0) {
							var subcliente = '';
							return cliente + subcliente;
						} else {
							if (full.id_subcliente != 0 && full.id_proyecto == 0) {
								var sub = full.subcliente;
								var subcliente = '<br><small>Subcliente: </small>';
								return cliente + subcliente + sub;
							}
							if (full.id_subcliente == 0 && full.id_proyecto != 0) {
								var sub = full.proyecto;
								var subcliente = '<br><small>Proyecto: </small>';
								return cliente + subcliente + sub;
							}
							if (full.id_subcliente != 0 && full.id_proyecto != 0) {
								var sub = full.subcliente;
								var subcliente = '<br><small>Subcliente: </small>';
								var pro = full.proyecto;
								var proyecto = '<br><small>Proyecto: </small>';
								return cliente + subcliente + sub + proyecto + pro;
							}
						}
					}
				},
				{
					title: 'Examen',
					data: 'paquete',
					bSortable: false,
					width: '8%',
					mRender: function(data, type, full){
						if(data == null){
							return 'Pendiente'
						}
						else{
							return data
						}
					}
				},
				{
					title: 'Código',
					data: 'codigo_prueba',
					bSortable: false,
					width: '10%'
				},
				{
					title: 'Fecha doping',
					data: 'fecha_doping',
					bSortable: false,
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
					title: 'Laboratorio',
					data: 'laboratorio',
					bSortable: false,
					width: '10%',
					mRender: function(data, type, full) {
						if (data == null) {
							return '<a id="cambio_laboratorio" href="javascript:void(0);">Sin definir</a>';
						} else {
							return '<a id="cambio_laboratorio" href="javascript:void(0);">' + data + '</a>';
						}
					}
				},
				{
					title: 'Acciones',
					data: 'id',
					bSortable: false,
					width: "15%",
					mRender: function(data, type, full) {
						var editar = '<a href="javascript:void(0)" data-toggle="tooltip" title="Editar doping" id="editar" class="fa-tooltip icono_datatable"><i class="fas fa-edit"></i></a>';

						var eliminar = '<a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar doping" id="eliminar" class="fa-tooltip icono_datatable"><i class="fas fa-trash"></i></a>';
						
						return '<div style="display: inline-block;margin-left:10px;"><form id="formCadena' + full.id + '" action="<?php echo base_url('Doping/createCadenaPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar cadena custodia" id="cadenaPDF" class="fa-tooltip icono_datatable"><i class="fas fa-file-alt"></i></a><input type="hidden" name="idCadena" id="idCadena' + full.id + '" value="' + full.id + '"></form></div><a href="javascript:void(0)" data-toggle="tooltip"title="Ver detalles" id="ver_detalles" class="fa-tooltip icono_datatable"><i class="fas fa-eye"></i></a>' + editar + '<a href="javascript:void(0)" data-toggle="tooltip"title="Ingresar resultados" id="resultados" class="fa-tooltip icono_datatable"><i class="fas fa-capsules"></i></a>' + eliminar;
					}
				}
			],
			fnDrawCallback: function(oSettings) {
				$('a[data-toggle="tooltip"]').tooltip({
					trigger: "hover"
				});
			},
			rowCallback: function(row, data) {
				//Color de estatus
				if(data.socioeconomico == 1){
					$('td', row).css({'background-color':'beige'});
				}
				$("a#editar", row).bind('click', () => {
          $("#idCandidato").val(data.id_candidato);
          $("#idDoping").val(data.id);
          $("#btnRegistro").attr('value', 'editar');
          $("#nombre").val(data.nombre);
          $("#paterno").val(data.paterno);
          $("#materno").val(data.materno);
          $("#cliente").val(data.id_cliente);
          getSubcliente(data.id_cliente, data.id_subcliente);
          getProyecto(data.id_cliente, data.id_proyecto);
          $("#paquete").val(data.id_antidoping_paquete);
          if(data.socioeconomico == 0){
            $("#nombre").prop('disabled',false);
            $("#paterno").prop('disabled',false);
            $("#materno").prop('disabled',false);
            $("#cliente").prop('disabled',false);
            $("#subcliente").prop('disabled',false);
            $("#proyecto").prop('disabled',false);
            $('#paquete').prop('disabled', false);
          }
          else{
            $("#nombre").prop('disabled',true);
            $("#paterno").prop('disabled',true);
            $("#materno").prop('disabled',true);
            $("#cliente").prop('disabled',true);
            $("#subcliente").prop('disabled',true);
            $("#proyecto").prop('disabled',true);
            $('#paquete').prop('disabled', false);
          }
          if (data.fecha_nacimiento != "0000-00-00" && data.fecha_nacimiento != null) {
            var aux = data.fecha_nacimiento.split('-');
            var f_nacimiento = aux[2] + '/' + aux[1] + '/' + aux[0];
            $("#nuevo_fecha_nacimiento").val(f_nacimiento);
          } else {
            $("#nuevo_fecha_nacimiento").val("");
          }
          $("#nuevo_identificacion").val(data.id_tipo_identificacion);
          $("#nuevo_ine").val(data.ine);
          $("#nuevo_razon").val(data.razon);
          $("#nuevo_foraneo").val(data.foraneo);
          $("#nuevo_medicamentos").val(data.medicamentos);
          if (data.fecha_doping != "0000-00-00" && data.fecha_doping != null) {
            var f = data.fecha_doping.split(' ');
            var aux = f[0].split('-');
            var f_doping = aux[2] + '/' + aux[1] + '/' + aux[0] + ' ' + f[1];
            $("#nuevo_fecha_doping").val(f_doping);
          } else {
            $("#nuevo_fecha_doping").val("");
          }
          $("#nuevo_foto").val("");
          if (data.foto != '' && data.foto != null) {
            var archivo = "_doping/" + data.foto;
            $("#previa_foto").html(" (Previa: <a href='<?php echo base_url(); ?>" + archivo + "' target='_blank'>" + data.foto + ")");
          } else {
            $("#previa_foto").empty();
          }
          $("#nuevo_comentarios").val(data.comentarios);
          $("#nuevoModal").modal('show');
        });
				$('a#ver_detalles', row).bind('click', () => {
					$.ajax({
						url: '<?php echo base_url('Doping/getDopingCandidato'); ?>',
						type: 'post',
						data: {
							'id_doping': data.id,
							'id_candidato': data.id_candidato
						},
						success: function(res) {
							datos = res.split('##');
							var comentarios = (datos[3] == '' || datos == null) ? 'Sin comentarios' : datos[3];
							$("#verModal #titulo_accion").text("Detalles del doping");
							$("#nombre_candidato").html("<b>" + data.nombreCompleto + '</b><br>');
							$("#detalles").html("<div class='row'><div class='col-md-6' style='border-right: solid 1px gray;float: left;padding:10px;'><b>Folio: </b>" + datos[2] + "<br><b>Medicamentos: </b>" + datos[1] + "<br><b>" + datos[5] + ": </b>" + datos[0] + "<br><b>Comentarios: </b>" + comentarios + "</div><div class='col-md-5' style='margin-left:10px;'>" + datos[4] + "</div></div>");
							$("#verModal").modal('show');

						}
					});
				});
				$('a#resultados', row).bind('click', () => {
					$("#idDoping").val(data.id);
					$("#titulo_prueba").text(data.codigo_prueba);
					$("#titulo_candidato").text(data.nombreCompleto);
					if (data.fecha_resultado != "0000-00-00" && data.fecha_resultado != "" && data.fecha_resultado != null) {
						var f = data.fecha_resultado.split(' ');
						var aux = f[0].split('-');
						var f_resultado = aux[2] + '/' + aux[1] + '/' + aux[0] + ' ' + f[1];
						$("#nuevo_fecha_resultado").val(f_resultado);
					} else {
						$("#nuevo_fecha_resultado").val("");
					}
					$.ajax({
						url: '<?php echo base_url('Doping/getSustanciasDoping'); ?>',
						type: 'post',
						data: {
							'id_doping': data.id,
							'id_candidato': data.id_candidato
						},
						success: function(res) {
							$("#div_resultados").html(res);
							$("#resultadosModal").modal('show');
						}
					});
				});
				$("a#eliminar", row).bind('click', () => {
          $("#idCandidato").val(data.id_candidato);
          $("#idDoping").val(data.id);
          $("#quitarModal #titulo_accion").text("Eliminar examen antidoping");
          $("#quitarModal #texto_confirmacion").html("<h5>¿Desea eliminar el examen <b>" + data.codigo_prueba + " del candidato "+data.candidato+"</b>?</h5>");
          $("#btnGuardar").attr('value', 'delete');
          $("#div_commentario").css('display', 'block');
          $("#quitarModal").modal("show");
        });
				$("a#cambio_laboratorio", row).bind('click', () => {
					$("#lab_idDoping").val(data.id);
					if (data.laboratorio != null) {
						$("#opcion_laboratorio").val(data.laboratorio);
					}
					$("#lab_nombre_candidato").html("<small>Candidato: </small>" + data.nombreCompleto);
					$("#labModal").modal("show");
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
		$('#tabla').on('draw.dt', function () {
			$('span[data-toggle="tooltip"]').tooltip({
				placement : 'right',
				html : true 
			});
		}); 
		$("#materno").change(function() {
			var materno = $(this).val();
			var nombre = $("#nombre").val();
			var paterno = $("#paterno").val();
			$.ajax({
				url: '<?php echo base_url('Doping/checkPendienteDoping'); ?>',
				method: 'POST',
				data: {
					'nombre': nombre,
					'paterno': paterno,
					'materno': materno
				},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						Swal.fire({
							position: 'center',
							icon: 'info',
							title: data.msg,
							showConfirmButton: false,
							timer: 2500
						})
					}
				}
			});
		});
		$("#cliente").change(function() {
			var id_cliente = $(this).val();
			var id_subcliente = $("#subcliente").val();
			var id_proyecto = $("#proyecto").val();
			if (id_cliente != "") {
				$.ajax({
					url: '<?php echo base_url('Doping/getSubclientes'); ?>',
					method: 'POST',
					data: {
						'id_cliente': id_cliente
					},
					success: function(res) {
						$('#subcliente').prop('disabled', false);
						$('#subcliente').html(res);
					}
				});				
				if (id_cliente == 6 || id_cliente == 16) {
					$("#nuevo_foto").addClass('nuevo_obligado');
				} else {
					$("#nuevo_foto").removeClass('nuevo_obligado');
					$("#nuevo_foto").removeClass('requerido');
				}
			} else {
				$('#subcliente').prop('disabled', true);
				$('#subcliente').append($("<option selected></option>").attr("value", 0).text("Selecciona"));
				$('#proyecto').prop('disabled', true);
				$('#proyecto').append($("<option selected></option>").attr("value", 0).text("Selecciona"));
				$('#paquete').val('');
			}
		});
		$("#subcliente").change(function() {
			var id_subcliente = $(this).val();
			var id_cliente = $("#cliente").val();
			var id_proyecto = $("#proyecto").val();
			$.ajax({
				url: '<?php echo base_url('Doping/getProyectosSubcliente'); ?>',
				method: 'POST',
				data: {
					'id_cliente': id_cliente,
					'id_subcliente': id_subcliente
				},
				success: function(res) {
					$('#proyecto').prop('disabled', false);
					$('#proyecto').html(res);
				}
			});
		});
		$("#proyecto").change(function() {
			var id_proyecto = $(this).val();
			var id_cliente = $("#cliente").val();
			var id_subcliente = $("#subcliente").val();
			$.ajax({
				url: '<?php echo base_url('Doping/getPaqueteCliente'); ?>',
				method: 'POST',
				data: {
					'id_proyecto': id_proyecto,
					'id_cliente': id_cliente,
					'id_subcliente': id_subcliente
				},
				success: function(res) {
					$("#paquete").empty();
					$('#paquete').html(res);
					$('#paquete').prop('disabled', false);

				}
			});
		});
	});

	function nuevoRegistro() {
		$("#btnRegistro").attr('value', 'nuevo');
		$("#previa_foto").empty();
		$("#nuevoModal").modal('show');
	}
	function guardarDoping() {
		var accion = $("#btnRegistro").val();
		var datos = new FormData();
		datos.append('nombre', $("#nombre").val());
		datos.append('paterno', $("#paterno").val());
		datos.append('materno', $("#materno").val());
		datos.append('cliente', $("#cliente").val());
		datos.append('subcliente', $("#subcliente").val());
		datos.append('proyecto', $("#proyecto").val());
		datos.append('paquete', $("#paquete").val());
		datos.append('fecha_nacimiento', $("#nuevo_fecha_nacimiento").val());
		datos.append('identificacion', $("#nuevo_identificacion").val());
		datos.append('ine', $("#nuevo_ine").val());
		datos.append('razon', $("#nuevo_razon").val());
		datos.append('foraneo', $("#nuevo_foraneo").val());
		datos.append('medicamentos', $("#nuevo_medicamentos").val());
		datos.append('fecha_doping', $("#nuevo_fecha_doping").val());
		datos.append('comentarios', $("#nuevo_comentarios").val());
		datos.append('id_doping', $("#idDoping").val());
		datos.append('id_candidato', $("#idCandidato").val());
		datos.append('foto', $("#nuevo_foto")[0].files[0]);
		if (accion == 'nuevo') {
			$.ajax({
				url: '<?php echo base_url('Doping/crearRegistro'); ?>',
				type: 'POST',
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
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#nuevoModal").modal('hide')
						recargarTable()
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha guardado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#nuevoModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		if (accion == 'editar') {
			$.ajax({
				url: '<?php echo base_url('Doping/editarRegistro'); ?>',
				type: 'POST',
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
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#nuevoModal").modal('hide')
						recargarTable()
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha guardado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#nuevoModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
	}

	function checkEliminados() {
		$.ajax({
			url: '<?php echo base_url('Doping/getDopingsEliminados'); ?>',
			method: 'POST',
			success: function(res) {
				$('#div_eliminados').html(res);
				$("#eliminadosModal").modal("show");
			}
		});
	}

	function getSubcliente(id_cliente, id_subcliente) {
		$.ajax({
			url: '<?php echo base_url('Doping/getSubclientes'); ?>',
			method: 'POST',
			data: {
				'id_cliente': id_cliente
			},
			success: function(res) {
				$('#subcliente').html(res);
				$("#subcliente").find('option').attr("selected", false);
				$('#subcliente option[value="' + id_subcliente + '"]').attr('selected', 'selected');
			}
		});
	}

	function getProyecto(id_cliente, id_proyecto) {
		$.ajax({
			url: '<?php echo base_url('Doping/getProyectos'); ?>',
			method: 'POST',
			data: {
				'id_cliente': id_cliente
			},
			success: function(res) {
				$('#proyecto').html(res);
				$("#proyecto").find('option').attr("selected", false);
				$('#proyecto option[value="' + id_proyecto + '"]').attr('selected', 'selected');
			}
		});
	}


	function recargarTable() {
		$("#tabla").DataTable().ajax.reload();
	}

	function ejecutarAccion() {
		var accion = $("#btnGuardar").val();
		var id_candidato = $("#idCandidato").val();
		var id_doping = $("#idDoping").val();
		if (accion == 'delete') {
			$.ajax({
				url: '<?php echo base_url('Doping/eliminarDoping'); ?>',
				type: 'post',
				data: {
					'id_candidato': id_candidato,
					'id_doping': id_doping
				},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#quitarModal").modal('hide')
            recargarTable()
					} else {
						setTimeout(function() {
							$('.loader').fadeOut();
						}, 200);
						$("#quitarModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
	}

	function registrarResultados() {
		var id_doping = $("#idDoping").val();
		var fecha_resultados = $("#nuevo_fecha_resultado").val();
		var valores = $('select[name^="sust"] option:selected').map(function() {
			return $(this).val();
		}).get().join(",");

		$.ajax({
			url: '<?php echo base_url('Doping/registrarResultadosDoping'); ?>',
			type: 'POST',
			data: {
				'valores': valores,
				'id_doping': id_doping,
				'fecha_resultados': fecha_resultados
			},
			beforeSend: function() {
				$('.loader').css("display", "block");
			},
			success: function(res) {
				var data = JSON.parse(res);
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
				if (data.codigo === 1) {
					$("#resultadosModal").modal('hide')
          recargarTable()
				} else {
					$("#resultadosModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}

	function actualizarLab() {
		var id = $("#lab_idDoping").val();
		var lab = $("#opcion_laboratorio").val();
		$.ajax({
			url: '<?php echo base_url('Doping/changeLaboratorio'); ?>',
			method: 'POST',
			data: {
				'lab': lab,
				'id_doping': id
			},
			beforeSend: function() {
				$('.loader').css("display", "block");
			},
			success: function(res) {
				setTimeout(function() {
					$('.loader').fadeOut();
				}, 200);
				var data = JSON.parse(res);
				if (data.codigo === 1) {
					$("#labModal").modal("hide");
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha guardado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					$("#labModal #msj_error").css('display', 'block').html(data.msg);
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