<!-- Begin Page Content -->
<div class="container-fluid">

	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Registros finalizados</small></h1><br>
		<br>
	</div>
	
  <div class="alert alert-info text-center">Para obtener un resultado en particular, busca por su nombre o por su número de prueba o por el cliente y un rango de fechas</div><br>
	<div class="row">
		<div class="col-8">
			<div class="row">
				<div class="col-4">
					<label>Nombre(s)</label>
					<input type="text" class="form-control" id="nombre_busqueda" name="nombre_busqueda" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
				</div>
				<div class="col-4">
					<label>Primer apellido</label>
					<input type="text" class="form-control" id="paterno_busqueda" name="paterno_busqueda" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
					<br>
				</div>
				<div class="col-4">
					<label>Segundo apellido</label>
					<input type="text" class="form-control" id="materno_busqueda" name="materno_busqueda" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
				</div>
			</div>
			<div class="row">
			<div class="col-4">
				<label>Número de examen</label>
				<input type="text" class="form-control solo_numeros" id="numero_busqueda" name="numero_busqueda">
				<br>
			</div>
			</div>
			<div class="row mb-5">
				<div class="col-4">
					<label>Cliente</label>
					<select class="form-control" name="cliente_busqueda" id="cliente_busqueda">
						<option value="">Selecciona</option>
						<?php 
						foreach($clientes as $c){ ?>
							<option value="<?php echo $c->id ?> "><?php echo $c->nombre ?></option>
						<?php 
						} ?>
					</select>
				</div>
				<div class="col-4">
					<label>Fecha inicial</label>
					<input type="text" class="form-control tipo_fecha" id="inicio_busqueda" name="inicio_busqueda" placeholder="dd/mm/yyyy">
				</div>
				<div class="col-4">
					<label>Fecha final</label>
					<input type="text" class="form-control tipo_fecha" id="fin_busqueda" name="fin_busqueda" placeholder="dd/mm/yyyy">
				</div>
				
			</div>
		</div>
		<div class="col-4">
			<div class="container">
				<div class="d-flex align-items-center" style="height:150px">
					<button class="btn btn-primary" onclick="buscarResultado()"><i class="fas fa-search"></i> Buscar</button>
					<button class="btn btn-info" onclick="limpiarBusqueda()"><i class="fas fa-eraser"></i></i> Limpiar</button>
				</div>
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
	<input type="hidden" id="idDoping">
	<input type="hidden" id="idCandidato">
	<input type="hidden" id="codigo">

</div>
<!-- /.content-wrapper -->
<script>
	$(document).ready(function() {
    $('.tipo_fecha').inputmask('dd/mm/yyyy', {
			'placeholder': 'dd/mm/yyyy'
		});
    $('.tipo_fecha_hora').inputmask("datetime", {
			"placeholder": "dd-mm-yyyy hh:mm"
		});
    var msj = localStorage.getItem("success");
		if (msj == 1) {
			Swal.fire({
				position: 'center',
				icon: 'success',
				title: 'Se ha actualizado correctamente',
				showConfirmButton: false,
				timer: 2500
			})
			localStorage.removeItem("success");
		}
		//Al iniciar la vista se manda llamar a los doping finalizados para el Datatable, recogiendo pocos registros
		//pero haciendo la carga pesada
	  /*var url = '<?php echo base_url('Doping/getDopingsFinalizadosListado'); ?>';
		changeDataTable(url);*/
    $('#opcion_doping').change(function(){
      var id = $(this).val();
      if(id != ''){
	      var baseurl = '<?php echo base_url('Doping/getDopingsFinalizados'); ?>';
        var url = baseurl+'?id='+id;
        changeDataTable(url);
      }
      else{
	      var url = '<?php echo base_url('Doping/getDopingsFinalizadosListado'); ?>';
        changeDataTable(url);
      }
    })
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
			/*$.ajax({
				url: '<?php //echo base_url('Doping/getClaveCliente'); 
							?>',
				method: 'POST',
				data: {
					'id_cliente': id_cliente,
					'id_subcliente': id_subcliente,
					'id_proyecto': id_proyecto
				},
				success: function(res) {
					$('#clave').html("<b>Clave a registrar: " + res + "</b>");
				}
			});*/
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
  function changeDataTable(url){
    $('#tabla').DataTable({
      "pageLength": 25,
      //"pagingType": "simple",
      "order": [0, "desc"],
      "stateSave": true,
      "bDestroy": true,
      "ajax": url,
      "processing": true,
      "columns": [{
          title: 'ID',
          data: 'id',
          "bVisible": false
        },
        {
          title: 'Candidato',
          data: 'candidato',
          bSortable: false,
          width: '30%',
          mRender: function(data, type, full) {
            return '<span data-toggle="tooltip" title="' + full.id_candidato + '">' + data + '</span><br>' + '<small><b>('+full.usuario+')</b></small>';
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
          width: '12%'
        },
        {
          title: 'Fechas',
          data: 'fecha_doping',
          bSortable: false,
          width: '12%',
          mRender: function(data, type, full) {
            var f = data.split(' ');
            var h = f[1];
            var aux = h.split(':');
            var hora = aux[0] + ':' + aux[1];
            var aux = f[0].split('-');
            var fecha = aux[2] + "/" + aux[1] + "/" + aux[0];
            var f_doping = fecha + ' ' + hora;

            f = full.fecha_resultado.split(' ');
            h = f[1];
            aux = h.split(':');
            hora = aux[0] + ':' + aux[1];
            aux = f[0].split('-');
            fecha = aux[2] + "/" + aux[1] + "/" + aux[0];
            var f_resultado = fecha + ' ' + hora;

            return '<small><b>Fecha toma: '+f_doping+'</b></small><br><small><b>Fecha resultado: '+f_resultado+'</b></small>';
          }
        },
        {
          title: 'Resultados',
          data: 'id',
          bSortable: false,
          width: "15%",
          mRender: function(data, type, full) {
            var color = (full.resultado == 0)? '<i class="fas fa-circle status_bgc1"></i> ' : '<i class="fas fa-circle status_bgc2"></i> ';
            
            var eliminar = '<a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar doping" id="eliminar" class="fa-tooltip icono_datatable"><i class="fas fa-trash"></i></a>';

            var editar = '<a href="javascript:void(0)" data-toggle="tooltip" title="Editar doping" id="editar" class="fa-tooltip icono_datatable"><i class="fas fa-edit"></i></a>';

            var pdfDigital = '<div style="display: inline-block;"><form id="formDigital' + data + '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado digital" id="pdfDigital" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' + data + '" value="' + data + '"></form></div>';

            var pdfDigitalIngles = '<div style="display: inline-block;"><form id="formDigitalIngles' + data + '" action="<?php echo base_url('Doping/crearPDFIngles'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado digital ingles" id="pdfDigitalIngles" class="fa-tooltip icono_datatable"><i class="far fa-file-pdf"></i></a><input type="hidden" name="idDopingIngles" id="idDopingIngles' + data + '" value="' + data + '"></form></div>';

            var pdfMembretado = '<div style="display: inline-block;"><form id="formMembretado' + data + '" action="<?php echo base_url('Doping/createMembretadoPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado para membretar" id="pdfMembretado" class="fa-tooltip icono_datatable"><i class="fas fa-file"></i></a><input type="hidden" name="idDopMembretado" id="idDopMembretado' + data + '" value="' + data + '"></form></div>';

            var pdfMembretadoIngles = '<div style="display: inline-block;"><form id="formMembretadoIngles' + data + '" action="<?php echo base_url('Doping/crearMembretadoPDFIngles'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado para membretar ingles" id="pdfMembretadoIngles" class="fa-tooltip icono_datatable"><i class="far fa-file"></i></a><input type="hidden" name="idDopingMembretadoIngles" id="idDopingMembretadoIngles' + data + '" value="' + data + '"></form></div>'

            if(full.id_cliente == 3 || full.id_cliente == 71){
              var adulterante = '<div style="display: inline-block;"><form id="formAdulterante' + data + '" action="<?php echo base_url('Doping/createPDF2'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar adulterante" id="pdfAdulterante" class="fa-tooltip icono_datatable"><i class="fas fa-file-alt"></i></a><input type="hidden" name="idPDF2" id="idPDF2' + data + '" value="' + data + '"></form></div>';
            }
            else{
              var adulterante = '';
            }
            
            return color + '<a href="javascript:void(0)" data-toggle="tooltip"title="Ver detalles" id="ver_detalles" class="fa-tooltip icono_datatable"><i class="fas fa-eye"></i></a> <a href="javascript:void(0)" data-toggle="tooltip"title="Ingresar resultados" id="resultados" class="fa-tooltip icono_datatable"><i class="fas fa-capsules"></i></a>' + editar + eliminar + '<br>' + pdfDigital + pdfDigitalIngles + pdfMembretado + pdfMembretadoIngles + adulterante;
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
        $('a[id^=pdfDigital]', row).bind('click', () => {
          var id = data.id;
          $('#formDigital' + id).submit();
        });
        $('a[id^=pdfDigitalIngles]', row).bind('click', () => {
          var id = data.id;
          $('#formDigitalIngles' + id).submit();
        });
        $('a[id^=pdfMembretado]', row).bind('click', () => {
          var id = data.id;
          $('#formMembretado' + id).submit();
        });
        $('a[id^=cadenaPDF]', row).bind('click', () => {
          var id = data.id;
          $('#formCadena' + id).submit();
        });
        $('a[id^=pdfAdulterante]', row).bind('click', () => {
          var id = data.id;
          $('#formAdulterante' + id).submit();
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
        },
        "sProcessing": "<div class='loader'></div>"
      }
    });
  }
  function buscarResultado(){
    var datos = new FormData();
    var nombre = $("#nombre_busqueda").val();
    var paterno = $("#paterno_busqueda").val();
    var materno = $("#materno_busqueda").val();
    var numero = $("#numero_busqueda").val();
    var cliente = $("#cliente_busqueda").val();
    var inicio = $("#inicio_busqueda").val();
    var fin = $("#fin_busqueda").val();

    if(nombre == '' && paterno == '' && numero == '' && cliente == '' && inicio == '' && fin == ''){
      Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'No se establecieron datos para la búsqueda de resultados',
        showConfirmButton: false,
        timer: 3500
      })
    }
    else{
			if(nombre != '' && paterno != ''){
				var baseurl = '<?php echo base_url('Doping/getResultadoFiltrado'); ?>';
        var url = baseurl+'?nombre='+nombre+'&primero='+paterno+'&segundo='+materno+'&numero='+numero+'&cliente='+cliente+'&inicio='+inicio+'&fin='+fin;
        changeDataTable(url);
			}
			else{
				if(numero != ''){
					var baseurl = '<?php echo base_url('Doping/getResultadoFiltrado'); ?>';
					var url = baseurl+'?nombre='+nombre+'&primero='+paterno+'&segundo='+materno+'&numero='+numero+'&cliente='+cliente+'&inicio='+inicio+'&fin='+fin;
					changeDataTable(url);
				}
				else{
					if(cliente != '' && inicio != '' && fin != ''){
						var baseurl = '<?php echo base_url('Doping/getResultadoFiltrado'); ?>';
						var url = baseurl+'?nombre='+nombre+'&primero='+paterno+'&segundo='+materno+'&numero='+numero+'&cliente='+cliente+'&inicio='+inicio+'&fin='+fin;
						changeDataTable(url);
					}
					else{
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'No se ha podido consultar con los datos solicitados, intenta de nuevo',
							showConfirmButton: false,
							timer: 4000
						})
					}
				}
			}
    }
  }
  function limpiarBusqueda(){
    $("#nombre_busqueda").val('');
    $("#paterno_busqueda").val('');
    $("#materno_busqueda").val('');
    $("#numero_busqueda").val('');
    $("#cliente_busqueda").val('');
    $("#inicio_busqueda").val('');
    $("#fin_busqueda").val('');
  }
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
						/*localStorage.setItem("success", 1);
						location.reload();*/
						recargarTable()
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha actualizado correctamente',
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
					$("#quitarModal").modal('hide')
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						/*localStorage.setItem("success", 1);
						location.reload();*/ 
						recargarTable()
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha eliminado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
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
				if (data.codigo === 1) {
					$("#resultadosModal").modal('hide')
					//localStorage.setItem("success", 1);
					//location.reload();
          setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
          recargarTable()
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Resultados actualizados correctamente',
            showConfirmButton: false,
            timer: 2500
          })
				} else {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					$("#resultadosModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}

	/*----------------------------------------*/
	/*  Acciones de examenes finalizados
	/*----------------------------------------*/
	function editarDoping(idCandidato, idDoping, nombre, paterno, materno, antidoping, id_cliente, id_subcliente, id_proyecto, fecha_nacimiento, id_tipo_identificacion, ine, razon, medicamentos, fecha_doping, foto, comentarios) {
		$("#idCandidato").val(idCandidato);
		$("#idDoping").val(idDoping);
		$("#btnRegistro").attr('value', 'editar');
		$("#nombre").val(nombre);
		$("#paterno").val(paterno);
		$("#materno").val(materno);
		$("#paquete").val(antidoping);
		$("#cliente").val(id_cliente);
		if (id_cliente != "" && id_cliente != null && id_cliente != 0) {
			getSubcliente(id_cliente, id_subcliente);
		} else {
			$('#subcliente').prop('disabled', true);
			$('#subcliente').val('');
		}
		if (id_cliente != "" && id_cliente != null && id_cliente != 0) {
			getProyecto(id_cliente, id_proyecto);
		} else {
			$('#proyecto').prop('disabled', true);
			$('#proyecto').val('');
		}
		if (fecha_nacimiento != "0000-00-00" && fecha_nacimiento != "" && fecha_nacimiento != null) {
			var aux = fecha_nacimiento.split('-');
			var f_nacimiento = aux[2] + '/' + aux[1] + '/' + aux[0];
			$("#nuevo_fecha_nacimiento").val(f_nacimiento);
		} else {
			$("#nuevo_fecha_nacimiento").val("");
		}
		$("#nuevo_identificacion").val(id_tipo_identificacion);
		$("#nuevo_ine").val(ine);
		$("#nuevo_razon").val(razon);
		$("#nuevo_medicamentos").val(medicamentos);
		if (fecha_doping != "0000-00-00" && fecha_doping != "" && fecha_doping != null) {
			var f = fecha_doping.split(' ');
			var aux = f[0].split('-');
			var f_doping = aux[2] + '/' + aux[1] + '/' + aux[0] + ' ' + f[1];
			$("#nuevo_fecha_doping").val(f_doping);
		} else {
			$("#nuevo_fecha_doping").val("");
		}
		$("#nuevo_foto").val("");
		if (foto != '' && foto != null) {
			var archivo = "_doping/" + foto;
			$("#previa_foto").html(" (Previa: <a href='<?php echo base_url(); ?>" + archivo + "' target='_blank'>" + foto + ")");
		} else {
			$("#previa_foto").empty();
		}
		$("#nuevo_comentarios").val(comentarios);
		$("#finalizadosModal").modal("hide");
		$("#nuevoModal").modal('show');
	}

	function resultadosDoping(idDoping, codigo_prueba, candidato, fecha_resultado, id_candidato) {
		$("#idDoping").val(idDoping);
		$("#titulo_prueba").text(codigo_prueba);
		$("#titulo_candidato").text(candidato);
		if (fecha_resultado != "0000-00-00" && fecha_resultado != "" && fecha_resultado != null) {
			var f = fecha_resultado.split(' ');
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
				'id_doping': idDoping,
				'id_candidato': id_candidato
			},
			success: function(res) {
				$("#div_resultados").html(res);
				$("#finalizadosModal").modal("hide");
				$("#resultadosModal").modal('show');
			}
		});
	}

	function eliminarDoping(idDoping, idCandidato, codigo) {
		$("#idCandidato").val(idCandidato);
		$("#idDoping").val(idDoping);
		$("#titulo_accion").text("Eliminar examen antidoping");
		$("#texto_confirmacion").html("¿Estás seguro de eliminar el doping <b>" + codigo + "</b>?");
		$("#btnGuardar").attr('value', 'delete');
		$("#div_commentario").css('display', 'block');
		$("#finalizadosModal").modal("hide");
		$("#quitarModal").modal("show");
	}
	//Acepta solo numeros en los input
	$(".solo_numeros").on("input", function() {
		var valor = $(this).val();
		$(this).val(valor.replace(/[^0-9]/g, ''));
	});
</script>