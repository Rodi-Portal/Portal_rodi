<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Registros pendientes</small></h1><br>
		<br>
		<a href="#" class="btn btn-danger btn-icon-split" onclick="checkEliminados()">
      <span class="icon text-white-50">
        <i class="fas fa-times-circle"></i>
      </span>
      <span class="text">Examenes eliminados</span>
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
	var url = '<?php echo base_url('Doping/getDopingsPendientes'); ?>';
	var img = '<?php echo base_url(); ?>_doping/';
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
		// 		title: 'Se ha registrado correctamente',
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
        data: 'idCandidato',
        "bVisible": false
      },
      {
        title: 'Candidato',
        data: 'candidato',
				bSortable: false,
        width: '30%',
        mRender: function(data, type, full) {
          var usuario = (full.usuario == null)? '<small><b>(Por definir)</b></small>' : '<small><b>('+full.usuario+')</b></small>';
          return '<span data-toggle="tooltip" title="' + full.idCandidato + '">' + data + '</span><br>' + usuario;
        }
      },
      {
        title: 'Cliente',
        data: 'cliente',
				bSortable: false,
				width: '20%',
        mRender: function(data, type, full) {
          var cliente = '<small>Cliente: </small>' + data;

          if (full.id_subcliente == 0 && full.id_proyecto == 0) {
            var subcliente = '';
            return cliente + subcliente;
          } 
          else {
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
        width: '10%',
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
        title: 'Fecha alta',
        data: 'fecha_alta',
				bSortable: false,
        width: '10%',
        mRender: function(data, type, full){
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
        title: 'Datos de contacto',
        data: 'celular',
				bSortable: false,
				width: '15%',
        mRender: function(data, type, full) {
          var cel = (data != null && data != '')? '<small>Celular: <b>'+data+'</b></small><br>' : '<small>Celular: <b>No registrado</b></small><br>';
          var tel = (full.telefono_casa != null && full.telefono_casa != '')? '<small>Otro tel. : <b>'+full.telefono_casa+'</b></small><br>' : '<small>Otro tel. : <b>No registrado</b></small><br>';
          var correo = (full.correo != null && full.correo != '')? '<small>Correo: <b>'+full.correo+'</b></small>' : '<small>Correo: <b>No registrado</b></small>';
					return cel + tel + correo;
        }
      },
      {
        title: 'Acciones',
        data: 'idDoping',
        bSortable: false,
        width: "8%",
        mRender: function(data, type, full) {
          return '<a href="javascript:void(0)" data-toggle="tooltip"title="Registrar examen" id="registrar" class="fa-tooltip icono_datatable"><i class="fas fa-id-badge"></i></a>';
        }
      }
			],
			fnDrawCallback: function(oSettings) {
				$('a[data-toggle="tooltip"]').tooltip({
					trigger: "hover"
				});
			},
			rowCallback: function(row, data) {
				$("a#registrar", row).bind('click', () => {
					$("#idCandidato").val(data.idCandidato);
					if(data.fecha_nacimiento != '0000-00-00' && data.fecha_nacimiento != null){
						var aux = data.fecha_nacimiento.split('-');
						var f_nacimiento = aux[2]+'/'+aux[1]+'/'+aux[0];
						$('#fecha_nacimiento').val(f_nacimiento)
					}
					else{
						$('#fecha_nacimiento').val('')
					}
					$.ajax({
						url: '<?php echo base_url('Doping/getAntidopingCandidato'); ?>',
						method: 'POST',
						data: {
							'id_candidato': data.idCandidato
						},
						success: function(res) {
							$('#parametros').empty();
							$('#parametros').html(res);
							$('#pendientesModal').modal('show');
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
					$("#quitarModal #texto_confirmacion").html("¿Estás seguro de eliminar el doping <b>" + data.codigo_prueba + "</b>?");
					$("#btnGuardar").attr('value', 'delete');
					$("#div_commentario").css('display', 'block');
					$("#quitarModal").modal("show");
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
					dataType: "text",
					success: function(res) {
						$('#subcliente').prop('disabled', false);
						$('#subcliente').html(res);
					}
				});
				$.ajax({
					url: '<?php echo base_url('Doping/getProyectos'); ?>',
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
				$.ajax({
					url: '<?php echo base_url('Doping/getPaqueteCliente'); ?>',
					method: 'POST',
					data: {
						'id_cliente': id_cliente,
						'id_subcliente': id_subcliente,
						'id_proyecto': id_proyecto
					},
					dataType: "text",
					success: function(res) {
						$("#paquete").empty();
						$('#paquete').html(res);
						$('#paquete').prop('disabled', false);
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
				//$('#clave').html("<b>Clave a registrar: Pendiente</b>");
			}
		});
		$("#subcliente").change(function() {
			var id_subcliente = $(this).val();
			var id_cliente = $("#cliente").val();
			var id_proyecto = $("#proyecto").val();
			$.ajax({
				url: '<?php echo base_url('Doping/getPaqueteCliente'); ?>',
				method: 'POST',
				data: {
					'id_subcliente': id_subcliente,
					'id_cliente': id_cliente,
					'id_proyecto': id_proyecto
				},
				dataType: "text",
				success: function(res) {
					$("#paquete").empty();
					$('#paquete').html(res);
					$('#paquete').prop('disabled', false);
				}
			});
			if (id_subcliente != 0) {
				$.ajax({
					url: '<?php echo base_url('Doping/getProyectosSubcliente'); ?>',
					method: 'POST',
					data: {
						'id_subcliente': id_subcliente
					},
					dataType: "text",
					success: function(res) {
						$('#proyecto').prop('disabled', false);
						$('#proyecto').html(res);
					}
				});
			}
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
				dataType: "text",
				success: function(res) {
					$("#paquete").empty();
					$('#paquete').html(res);
					$('#paquete').prop('disabled', false);

				}
			});
			$.ajax({
				url: '<?php echo base_url('Doping/getClaveCliente'); ?>',
				method: 'POST',
				data: {
					'id_cliente': id_cliente,
					'id_proyecto': id_proyecto,
					'id_subcliente': id_subcliente
				},
				success: function(res) {
					$('#clave').html("<b>Clave a registrar: " + res + "</b>");
				}
			});
		});
	});
	function registrarPendiente() {
		var datos = new FormData();
		datos.append('id_candidato', $("#idCandidato").val());
		datos.append('fecha_nacimiento', $("#fecha_nacimiento").val());
		datos.append('identificacion', $("#identificacion").val());
		datos.append('ine', $("#ine").val());
		datos.append('razon', $("#razon").val());
		datos.append('foraneo', $("#foraneo").val());
		datos.append('medicamentos', $("#medicamentos").val());
		datos.append('fecha_doping', $("#fecha_doping").val());
		datos.append('comentarios', $("#comentarios").val());
		datos.append('foto', $("#foto")[0].files[0]);

		$.ajax({
			url: '<?php echo base_url('Doping/registrarPendiente'); ?>',
			type: 'POST',
			data: datos,
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function() {
				$('.loader').css("display", "block");
			},
			success: function(res) {
				var data = JSON.parse(res);
				if (data.codigo === 1) {
					$("#pendientesModal").modal('hide')
					//localStorage.setItem("success", 1);
					url_local = '<?php echo base_url('Doping/indexGenerales') ?>';
					window.location.replace(url_local);
					//location.reload();
				} else {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					$("#pendientesModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
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
				$('#subcliente').prop('disabled', false);
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
				$('#proyecto').prop('disabled', false);
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
		var motivo = $("#motivo").val();
		if (accion == 'delete') {
			$.ajax({
				url: '<?php echo base_url('Doping/delete'); ?>',
				type: 'post',
				data: {
					'id_candidato': id_candidato,
					'motivo': motivo,
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

	//Acepta solo numeros en los input
	$(".solo_numeros").on("input", function() {
		var valor = $(this).val();
		$(this).val(valor.replace(/[^0-9]/g, ''));
	});
</script>