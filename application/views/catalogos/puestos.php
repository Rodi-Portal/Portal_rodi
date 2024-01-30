<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Puestos</h1>
		<a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#newModal">
			<span class="icon text-white-50">
				<i class="fas fa-plus-circle"></i>
			</span>
			<span class="text">Agregar puesto</span>
		</a>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<div class="row text-right justify-content-end">
        <div class="col-3">
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#importarcsvModal">Importar csv</button>
        </div>
      </div>
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
	<input type="hidden" id="idPuesto">
	
</div>
<!-- /.content-wrapper -->	
<script>
	var url = '<?php echo base_url('Cat_Puestos/getPuestos'); ?>';
  	$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
    	$('#tabla').DataTable({
      		"pageLength": 25,
	      	//"pagingType": "simple",
	      	"order": [0, "desc"],
	      	"stateSave": true,
	      	"ajax": url,
	      	"columns":[ 
						{ title: 'id', data: 'id', visible: false},
	        	{ title: 'Nombre', data: 'nombre', bSortable: false, "width": "40%", },
	        	{ title: 'Fecha de alta', data: 'creacion', bSortable: false, "width": "15%",
	        		mRender: function(data, type, full){
            			var f = data.split(' ');
            			var h = f[1];
            			var aux = h.split(':');
            			var hora = aux[0]+':'+aux[1];
            			var aux = f[0].split('-');
            			var fecha = aux[2]+"/"+aux[1]+"/"+aux[0];
            			var tiempo = fecha+' '+hora;
        				return tiempo;
          			}
	        	},
	        	{ title: 'Usuario', data: 'usuario', bSortable: false, "width": "15%", },
	        	{ title: 'Acciones', data: 'id', bSortable: false, "width": "10%",
         			mRender: function(data, type, full) {
     					if(full.status == 0){
                			return '<a id="editar" href="javascript:void(0)" data-toggle="tooltip" title="Editar" class="fa-tooltip icono_datatable"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Activar" id="activar" class="fa-tooltip icono_datatable accion_desactiva"><i class="fas fa-ban text-red"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar" id="eliminar" class="fa-tooltip icono_datatable"><i class="fas fa-trash"></i></a>';
            			}
            			if(full.status == 1){
                			return '<a id="editar" href="javascript:void(0)" data-toggle="tooltip" title="Editar" class="fa-tooltip icono_datatable"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Desactivar" id="desactivar" class="fa-tooltip icono_datatable accion_activa"><i class="far fa-check-circle text-green"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar" id="eliminar" class="fa-tooltip icono_datatable"><i class="fas fa-trash"></i></a>';
            			}
          			}
        		},
	      	],
	      	fnDrawCallback: function (oSettings) {
	        	$('a[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
	      	},
	      	rowCallback: function( row, data ) {
	      		$("a#editar", row).bind('click', () => {
	      			$("#idPuesto").val(data.id);
	      			$(".modal-title").text("Editar puesto");
	      			$("#nombre").val(data.nombre);
	      			$("#btnGuardar").attr('value','editar');
	      			$("#newModal").modal("show");
	      		});
	      		$("a#activar", row).bind('click', () => {
	      			$("#idPuesto").val(data.id);
	      			$("#titulo_accion").text("Activar puesto");
	      			$("#texto_confirmacion").html("¿Estás seguro de activar el puesto <b>"+data.nombre+"</b>?");
	      			$("#accion").attr('value','activar');
	      			$("#quitarModal").modal("show");
	      		});
	      		$("a#desactivar", row).bind('click', () => {
	      			$("#idPuesto").val(data.id);
	      			$("#titulo_accion").text("Desactivar puesto");
	      			$("#texto_confirmacion").html("¿Estás seguro de desactivar el puesto <b>"+data.nombre+"</b>?");
	      			$("#accion").attr('value','desactivar');
	      			$("#quitarModal").modal("show");
	      		});
	      		$("a#eliminar", row).bind('click', () => {
	      			$("#idPuesto").val(data.id);
	      			$("#titulo_accion").text("Eliminar puesto");
	      			$("#texto_confirmacion").html("¿Estás seguro de eliminar el puesto <b>"+data.nombre+"</b>?");
	      			$("#accion").attr('value','eliminar');
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
    	$("#btnGuardar").click(function(){
				var nombre = $("#nombre").val();
				var id = $("#idPuesto").val();
				var opcion = $(this).val();
				if(opcion == "nuevo"){
					$.ajax({
						url: '<?php echo base_url('Cat_Puestos/registrar'); ?>',
						type: 'POST',
						data: {'nombre':nombre},
						beforeSend: function() {
							$('.loader').css("display","block");
						},
						success : function(res){ 
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
				if(opcion == "editar"){
					$.ajax({
						url: '<?php echo base_url('Cat_Puestos/editar'); ?>',
						type: 'POST',
						data: {'nombre':nombre,'id':id},
						beforeSend: function() {
							$('.loader').css("display","block");
						},
						success : function(res){ 
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
  	});
	function recargarTable(){
		$("#tabla").DataTable().ajax.reload();
	}
	function ejecutarAccion(){
		var accion = $("#accion").val();
		var id = $("#idPuesto").val();
		$.ajax({
			url: '<?php echo base_url('Cat_Puestos/accion'); ?>',
			type: 'post',
			data: {'id':id,'accion':accion},
			beforeSend: function() {
				$('.loader').css("display","block");
			},
			success : function(res){ 
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
  function importarCSV() {
		var docs = new FormData();
		var archivo = $("#archivo_csv")[0].files[0];
		docs.append("archivo", archivo);
		$.ajax({
			url: "<?php echo base_url('Cat_Puestos/uploadCSV'); ?>",
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
				if (data.codigo === 1) {
					$("#importarcsvModal").modal('hide');
					recargarTable();
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'La importación se ha cargado con éxito',
						showConfirmButton: false,
						timer: 2500
					})
				}
				else {
					$("#importarcsvModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}
</script>