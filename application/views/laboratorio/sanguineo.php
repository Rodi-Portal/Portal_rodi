<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Detección de grupo sanguíneo</h1>
		<a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#newModal">
			<span class="icon text-white-50">
				<i class="fas fa-plus-circle"></i>
			</span>
			<span class="text">Registrar paciente</span>
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
	<input type="hidden" id="idAnalisis">
	<input type="hidden" id="idPaciente">


</div>
<!-- /.content-wrapper -->
<script>
	var url = '<?php echo base_url('Laboratorio/getExamenesGrupoSanguineo'); ?>';
	$(document).ready(function() {
		$('.tipo_fecha').inputmask('dd/mm/yyyy', {
			'placeholder': 'dd/mm/yyyy'
		})
    $('.tipo_fecha_hora').inputmask("datetime", {
			"placeholder": "dd-mm-yyyy hh:mm"
		});
		$('#tabla').DataTable({
			"pageLength": 25,
			"pagingType": "simple",
			//"stateSave": true,
			"order": [
				[0, "desc"]
			],
			"ajax": url,
			"columns": [{
					title: 'ID',
					data: 'id',
					"bVisible": false
				},
				{
					title: 'Paciente',
					data: 'paciente',
					bSortable: false,
          width: '20%'
				},
				{
					title: 'Tipo examen',
					data: 'tipo_examen',
					bSortable: false,
          width: '12%'
				},
				{
					title: 'Fecha de toma',
					data: 'fecha_toma',
					bSortable: false,
          width: '12%',
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
					title: 'Acciones',
					data: 'id',
					bSortable: false,
					width: "8%",
					mRender: function(data, type, full) {
						return '<a href="javascript:void(0)" id="editar" title="Editar paciente" data-toggle="tooltip" class="fa-tooltip icono_datatable"><i class="fas fa-edit"></i></a> <a href="javascript:void(0)" id="resultados" title="Registrar resultados" data-toggle="tooltip" class="fa-tooltip icono_datatable"><i class="fas fa-vial"></i></a> <a href="javascript:void(0)" id="eliminar" title="Eliminar paciente" data-toggle="tooltip" class="fa-tooltip icono_datatable"><i class="fas fa-trash"></i></a>';
					}
				},
				{
					title: 'Resultado',
					data: 'resultado',
					width: '10%',
					mRender: function(data, type, full) {
						if(data == null){
              return '<b>En proceso</b>';
            }
            else{
              return '<div style="display: inline-block;"><form id="analisis' + full.id + '" action="<?php echo base_url('Laboratorio/crearPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultados" id="pdfFinal" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idAnalisis" id="idAnalisis' + full.id + '" value="' + full.id + '"></form></div> <b>'+data+'</b>';
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
					$("#idPaciente").val(data.id_paciente);
					$("#idAnalisis").val(data.id);
          $('#titulo_modal_sanguineo').text('Editar paciente ')
					$("#nombre_sanguineo").val(data.nombre);
					$("#paterno_sanguineo").val(data.paterno);
					$("#materno_sanguineo").val(data.materno);
					$("#genero_sanguineo").val(data.genero);
					if(data.fecha_nacimiento != "0000-00-00" && data.fecha_nacimiento != null){
						var aux = data.fecha_nacimiento.split('-');
						var f_nacimiento = aux[2] + "/" + aux[1] + "/" + aux[0];
            $("#fecha_nacimiento_sanguineo").val(f_nacimiento);
					}
					else{
					  $("#fecha_nacimiento_sanguineo").val('');
					}
          if (data.fecha_toma != "0000-00-00" && data.fecha_toma != "") {
						var f = data.fecha_toma.split(' ');
						var aux = f[0].split('-');
						var f_toma = aux[2] + '/' + aux[1] + '/' + aux[0] + ' ' + f[1];
						$("#fecha_toma_sanguineo").val(f_toma);
					} 
          else {
						$("#fecha_toma_sanguineo").val("");
					}
					$("#metodo_sanguineo").val(data.metodo);
					$("#medico_sanguineo").val(data.medico);
					
					$("#newModal").modal('show');
				});
				$("a#resultados", row).bind('click', () => {
					$("#idPaciente").val(data.id_paciente);
					$("#idAnalisis").val(data.id);
					$(".nombrePaciente").text(data.paciente);
					$("#grupo_sanguineo").val(data.resultado);
					$("#resultadosModal").modal("show");
				});
        $('a#eliminar', row).bind('click', () => {
					$('#titulo_mensaje').text('Eliminar registro de paciente');
					$('#mensaje').html('¿Desea eliminar el registro del paciente: <b>'+data.paciente+'</b>?');
					$('#btnConfirmar').attr("onclick","confirmarAccion(1,"+data.id+")");
					$('#mensajeModal').modal('show');
				});
				$('a[id^=pdfFinal]', row).bind('click', () => {
					var id = data.id;
					$('#analisis' + id).submit();
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
		$('#tabla').on('draw.dt', function() {
			$('span[data-toggle="tooltip"]').tooltip({
				placement: 'right',
				html: true
			});
		});
		$('#tabla').DataTable().search(" ");
		$(".conclusion_obligado, .analisis_obligado").focus(function() {
			$(this).removeClass("requerido");
		});
		$('[data-toggle="tooltip"]').tooltip();
	});

	function nuevoRegistro(){
		var datos = new FormData();
		datos.append('nombre', $("#nombre_sanguineo").val());
		datos.append('paterno', $("#paterno_sanguineo").val());
		datos.append('materno', $("#materno_sanguineo").val());
		datos.append('genero', $("#genero_sanguineo").val());
		datos.append('fecha_nacimiento', $("#fecha_nacimiento_sanguineo").val());
		datos.append('fecha_toma', $("#fecha_toma_sanguineo").val());
		datos.append('medico', $("#medico_sanguineo").val());
		datos.append('metodo', $("#metodo_sanguineo").val());
		datos.append('id_analisis', $("#idAnalisis").val());
		datos.append('id_paciente', $("#idPaciente").val());
		
		$.ajax({
			url: '<?php echo base_url('Laboratorio/guardarPacienteGrupoSanguineo'); ?>',
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
					$('#newModal').modal('hide');
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
  function guardarResultados(){
		var datos = new FormData();
		datos.append('grupo', $("#grupo_sanguineo").val());
		datos.append('id_analisis', $("#idAnalisis").val());
		datos.append('id_paciente', $("#idPaciente").val());
		
		$.ajax({
			url: '<?php echo base_url('Laboratorio/guardarResultadoGrupoSanguineo'); ?>',
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
					$('#resultadosModal').modal('hide');
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'El resultado ha sido registrado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} 
				else {
					$("#resultadosModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}
  function confirmarAccion(accion,valor){
		$('#mensajeModal').modal('hide');
		//Eliminar analisis
		if(accion == 1){
			$.ajax({
				url: '<?php echo base_url('Laboratorio/eliminarAnalisis'); ?>',
				type: 'post',
				data: {
					'id_analisis': valor
				},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 300);
					var dato = JSON.parse(res);
					if(dato.codigo === 1){
						recargarTable();
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: dato.msg,
							showConfirmButton: false,
							timer: 3000
						})
					}
				}
			});
		}
	}
	function recargarTable() {
		$("#tabla").DataTable().ajax.reload();
	}
</script>