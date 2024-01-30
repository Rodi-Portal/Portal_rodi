<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Requisiciones Finalizadas</h1><br>
		<!--a href="#" class="btn btn-primary btn-icon-split" id="btn_nuevo" data-toggle="modal" data-target="#newModal">
			<span class="icon text-white-50">
				<i class="fas fa-user-plus"></i>
			</span>
			<span class="text">Registrar aspirante</span>
		</a-->
		<a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#reactivarRequisicionModal">
			<span class="icon text-white-50">
        <i class="fas fa-check-circle"></i>
			</span>
			<span class="text">Reactivar requisición</span>
		</a>
		<a href="#" class="btn btn-primary btn-icon-split hidden" id="btn_regresar" onclick="regresarListado()" style="display: none;">
			<span class="icon text-white-50">
				<i class="fas fa-arrow-left"></i>
			</span>
			<span class="text">Regresar al listado</span>
		</a>
	</div>

	<?php echo $modals; ?>
	<div class="loader" style="display: none;"></div>
	<input type="hidden" id="idAspirante">
	<input type="hidden" id="idRequisicion">
	<input type="hidden" id="idDoping">
	<input type="hidden" id="numVecinal">


  <div id="div_requisiciones" class="row">
		<div class="col-6">
			<label>Selecciona la requisición a mostrar: </label>
			<select class="form-control" name="opcion_requisicion" id="opcion_requisicion">
				<option value="">Todas</option>
				<?php
        if ($reqs) {
          foreach ($reqs as $req) { ?>
            <option value="<?php echo $req->id; ?>"><?php echo '#'.$req->id.' '.$req->nombre.' - '.$req->puesto.' - Vacantes: '.$req->numero_vacantes; ?></option>
          <?php   
          }
        } ?>
			</select><br>
		</div>
	</div>

	<div id="listado">
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
	</div>


</div>
<!-- /.content-wrapper -->
<script>
	$(document).ready(function() {
	  var url = '<?php echo base_url('Reclutamiento/getAspirantesRequisicionesFinalizadas'); ?>';
    changeDataTable(url);
    $('#opcion_requisicion').change(function(){
      var id = $(this).val();
      if(id != ''){
	      var baseurl = '<?php echo base_url('Reclutamiento/getAspirantesPorRequisicionesFinalizadas'); ?>';
        var url = baseurl+'?id='+id;
        changeDataTable(url);
      }
      else{
	      var url = '<?php echo base_url('Reclutamiento/getAspirantesRequisicionesFinalizadas'); ?>';
        changeDataTable(url);
      }
    })
		//inputmask
		$('.fecha').inputmask('dd/mm/yyyy', {
			'placeholder': 'dd/mm/yyyy'
		});
	});
  function changeDataTable(url){
    $('#tabla').DataTable({
			"pageLength": 25,
			//"pagingType": "simple",
			"order": [0, "desc"],
			"stateSave": true,
			"serverSide": false,
      "bDestroy": true,
			"ajax": url,
			"columns": [{
					title: '#',
					data: 'id',
					bSortable: false,
          "width": "3%",
          mRender: function(data, type, full){
            return data;
          }
				},
        {
					title: 'Aspirante',
					data: 'aspirante',
					bSortable: false,
					"width": "15%",
          mRender: function(data, type, full){
            return data+'<br><small><b>('+full.usuario+')</b></small>';
          }
				},
				{
					title: 'Nombre o Razón Social',
					data: 'empresa',
					bSortable: false,
					"width": "15%",
          mRender: function(data, type, full){
            return '#'+full.id_requisicion+' '+data;
          }
				},
				{
					title: 'Puesto',
					data: 'puesto',
					bSortable: false,
					"width": "12%"
				},
				{
					title: 'Acciones',
					data: 'id',
					bSortable: false,
					"width": "8%",
          mRender: function(data, type, full){
						var cv = (full.cv != null)? '<a href="<?php echo base_url(); ?>_docs/'+full.cv+'" target="_blank" class="fa-tooltip icono_datatable"><i class="fas fa-eye"></i></a> ' : '<a href="javascript:void(0);" class="fa-tooltip gris icono_datatable"><i class="fas fa-eye"></i></a> ';
						var historial = '<a href="javascript:void(0)" id="ver_historial" class="fa-tooltip icono_datatable"><i class="fas fa-history"></i></a> ';
						if(full.status_final == null){
            	return cv+'<a href="javascript:void(0)" id="editar_aspirante" class="fa-tooltip icono_datatable"><i class="fas fa-user-edit"></i></a> <a href="javascript:void(0)" id="accion" class="fa-tooltip icono_datatable"><i class="fas fa-plus-circle"></i></a> '+historial;
						}
						else{
							return cv+historial;
						}
          }
				},
				{
					title: 'Estatus aspirante',
					data: 'status',
					bSortable: false,
					"width": "10%",
          mRender: function(data, type, full){
						return '<b>'+data+'<b>';
          }
				},
        {
					title: 'Estatus requisición',
					data: 'statusReq',
					bSortable: false,
					"width": "10%",
          mRender: function(data, type, full){
            var estatus = (data == 3)? 'TERMINADA':'CANCELADA';
						return '<b>'+estatus+'<b>';
          }
				},
        {
					title: 'Comentario final',
					data: 'comentario_final',
					bSortable: false,
					"width": "17%",
          mRender: function(data, type, full){
						return '<b>'+data+'<b>';
          }
				}
			],
			fnDrawCallback: function(oSettings) {
				$('a[data-toggle="tooltip"]').tooltip({
					trigger: "hover"
				});
			},
			rowCallback: function(row, data) {
        $("a#editar_aspirante", row).bind('click', () => {
					$("#idAspirante").val(data.id);
					$(".nombreAspirante").text(data.aspirante);
          $('#req_asignada').val(data.id_requisicion);
          $('#nombre').val(data.nombre);
          $('#paterno').val(data.paterno);
          $('#materno').val(data.materno);
          $('#medio').val(data.medio_contacto);
          $('#telefono').val(data.telefono);
          $('#correo').val(data.correo);
          if(data.cv != null){
            $('#cv_previo').html('<small><b> (CV previo: </b></small><a href="<?php echo base_url(); ?>_docs/'+data.cv+'" target="_blank">'+data.cv+'</a>)');
          }
          $("#newModal").modal('show');
				});
				$('a#accion', row).bind('click', () => {
					$("#idAspirante").val(data.id);
					$(".nombreAspirante").text(data.aspirante);
          $('#idRequisicion').val(data.id_requisicion);
          $("#nuevaAccionModal").modal('show');
				});
				$('a#ver_historial', row).bind('click', () => {
					$("#idAspirante").val(data.id);
					$(".nombreAspirante").text(data.aspirante);
					$.ajax({
						url: '<?php echo base_url('Reclutamiento/getHistorialAspirante'); ?>',
						type: 'post',
						data: {
							'id_aspirante': data.id
						},
						success: function(res) {
							var salida = '<table class="table table-striped" style="font-size: 14px">';
							salida += '<tr style="background: gray;color:white;">';
							salida += '<th>Fecha</th>';
							salida += '<th>Estatus</th>';
							salida += '<th>Comentario / Descripción / Fecha y lugar</th>';
							salida += '</tr>';
							if(res != 0){
								var dato = JSON.parse(res);
								for(var i = 0; i < dato.length; i++){
									var aux = dato[i]['creacion'].split(' ');
									var f = aux[0].split('-');
									var fecha = f[2]+'/'+f[1]+'/'+f[0];
									salida += "<tr>";
									salida += '<td>'+fecha+'</td>';
									salida += '<td>'+dato[i]['accion']+'</td>';
									salida += '<td>'+dato[i]['descripcion']+'</td>';
									salida += "</tr>";
								}
							}
							else{
								salida += "<tr>";
								salida += '<td colspan="3" class="text-center"><h5>Sin movimientos</h5></td>';
								salida += "</tr>";
							}
							salida += "</table>";
							$('#div_historial_aspirante').html(salida);
							$("#historialModal").modal('show');
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
  }
	function reactivarsRequisicion() {
		var datos = new FormData();
		datos.append('id', $("#reactivar_req").val());

		$.ajax({
			url: '<?php echo base_url('Reclutamiento/iniciarRequisicion'); ?>',
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
					$("#reactivarRequisicionModal").modal('hide')
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: data.msg,
						showConfirmButton: false,
						timer: 2500
					})
          setTimeout(() => {
            location.reload()
          }, 2500);
				} else {
					$("#reactivarRequisicionModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}
</script>