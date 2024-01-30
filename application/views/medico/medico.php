<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Examen Médico</h1>
		<a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#newModal">
			<span class="icon text-white-50">
				<i class="fas fa-plus-circle"></i>
			</span>
			<span class="text">Registrar nuevo examen médico</span>
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
	<input type="hidden" id="idCandidato">


</div>
<!-- /.content-wrapper -->
<script>
	var url = '<?php echo base_url('Medico/getAnalisisMedico'); ?>';
	$(document).ready(function() {
		$('.tipo_fecha').inputmask('dd/mm/yyyy', {
			'placeholder': 'dd/mm/yyyy'
		})
		var msj = localStorage.getItem("success");
		var msj2 = localStorage.getItem("finished");
		if (msj == 1) {
			$("#exitoCandidato").css('display', 'block');
			setTimeout(function() {
				$('#exitoCandidato').fadeOut();
			}, 4000);
			localStorage.removeItem("success");
		}
		if (msj2 == 1) {
			$("#exitoFinalizado").css('display', 'block');
			setTimeout(function() {
				$('#exitoFinalizado').fadeOut();
			}, 4000);
			localStorage.removeItem("finished");
		}
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
					title: 'Nombre del Candidato',
					data: 'candidato',
					bSortable: false
				},
				{
					title: 'Cliente/Subcliente',
					data: 'cliente',
					bSortable: false,
					mRender: function(data, type, full) {
						if(data != null){
							var cliente = '<small>Cliente: </small>' + data;

							if (full.id_subcliente == 0 && full.id_proyecto == 0) {
								return cliente;
							} else {
								if (full.id_subcliente != 0 && full.id_proyecto == 0) {
									var sub = full.subcliente;
									var subcliente = '<br><small>Subcliente: </small>';
									return cliente + subcliente + sub;
								}
								if (full.id_subcliente == 0 && full.id_proyecto != 0) {
									var pro = full.proyecto;
									var proyecto = '<br><small>Proyecto: </small>';
									return cliente + proyecto + pro;
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
						else{
							return 'N/A';
						}
					}
				},
				{
					title: 'Fecha de registro',
					data: 'fecha_alta',
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
					title: 'Acciones',
					data: 'id',
					bSortable: false,
					width: "8%",
					mRender: function(data, type, full) {
						if (full.idMedico != "" && full.idMedico != null) {
							return '<a href="javascript:void(0)" id="analisis" title="Registrar analisis" data-toggle="tooltip" class="fa-tooltip icono_datatable"><i class="fas fa-laptop-medical"></i></a> <a href="javascript:void(0)" data-toggle="tooltip" title="Registrar conclusiones" id="conclusiones" class="fa-tooltip icono_datatable"><i class="fas fa-comment-medical"></i></a>';
						} else {
							return '<a href="javascript:void(0)" id="analisis" title="Registrar analisis" data-toggle="tooltip" class="fa-tooltip icono_datatable"><i class="fas fa-laptop-medical"></i></a>';
						}
					}
				},
				{
					title: 'Resultado',
					data: 'id',
					bSortable: false,
					width: '15%',
					mRender: function(data, type, full) {
						if (full.idMedico != "" && full.idMedico != null) {
							if (full.conclusion != null && full.descripcion != null) {
								return '<div style="display: inline-block;"><form id="pdf' + full.idMedico + '" action="<?php echo base_url('Medico/crearPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final" id="pdfFinal" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idMedico" id="idMedico' + full.idMedico + '" value="' + full.idMedico + '"></form></div>';
							} else {
								return "<i class='fas fa-circle status_bgc3'></i> En proceso";
							}
						} else {
							return "<i class='fas fa-circle status_bgc0'></i> Pendiente";
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
				$("a#analisis", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$("#nombreCandidato").text(data.candidato);
					//Seccion Ficha de identificacion
					var genero = (data.genero == null)? '':data.genero;
					$("#genero").val(genero);
					if(data.fecha_nacimiento != "0000-00-00" && data.fecha_nacimiento != null){
						var aux = data.fecha_nacimiento.split('-');
						var f_nacimiento = aux[2] + "/" + aux[1] + "/" + aux[0];
					}
					else{
						var f_nacimiento = '';
					}
					$("#fecha_nacimiento").val(f_nacimiento);
					$("#civil").val(data.estado_civil);
					$("#escolaridad").val(data.id_grado_estudio);
					$("#avisar").val(data.avisar_a);
					$("#telefono_emergencia").val(data.telefono_emergencia);
					$("#edad").val(data.edad);
					//Seccion Antecedentes Heredo-Familiares
					$("#diabetes").val(data.diabetes);
					$("#cancer").val(data.cancer);
					$("#hipertension").val(data.hipertension);
					$("#cardiopatias").val(data.cardiopatias);
					$("#pulmonares").val(data.pulmonares);
					$("#renales").val(data.renales);
					$("#psiquiatrica").val(data.psiquiatricas);
					$("#cual").val(data.cuales_antecedentes_familiares);
					$("#sangre").val(data.tipo_sangre);
					//Seccion de Antecdentes no Patologicos
					$("#tabaco").val(data.tabaco);
					$("#tabaco_cantidad").val(data.tabaco_cantidad);
					$("#tabaco_frecuencia").val(data.tabaco_frecuencia);
					$("#alcohol").val(data.alcohol);
					$("#alcohol_cantidad").val(data.alcohol_cantidad);
					$("#alcohol_frecuencia").val(data.alcohol_frecuencia);
					$("#drogas").val(data.droga);
					$("#drogas_tipo").val(data.droga_tipo);
					$("#deporte").val(data.deporte);
					$("#deporte_cual").val(data.deporte_cual);
					$("#alimentacion").val(data.alimentacion);
					//Seccion Antecendentes Patologicos Personales
					$("#quirurgicos").val(data.quirurgicos);
					$("#quirurgicos_hace_cuanto").val(data.quirurgicos_hace_cuanto);
					$("#quirurgicos_cual").val(data.quirurgicos_cual);
					$("#internamientos").val(data.internamientos);
					$("#internamientos_hace_cuanto").val(data.internamientos_hace_cuanto);
					$("#internamientos_porque").val(data.internamientos_porque);
					$("#transfusiones").val(data.transfusiones);
					$("#transfusiones_hace_cuanto").val(data.transfusiones_hace_cuanto);
					$("#transfusiones_porque").val(data.transfusiones_porque);
					$("#fracturas").val(data.fracturas);
					$("#esguinces").val(data.esguinces);
					$("#luxaciones").val(data.luxaciones);
					$("#traumatismo").val(data.traumatismo);
					$("#hernias").val(data.hernia);
					$("#lesiones_columna").val(data.lesiones_columna)
					$("#alergias").val(data.alergias);
					$("#alergias_aque").val(data.alergias_cual);
					//Seccion Chequeo General
					var estatura = (data.estatura == 0)? '':data.estatura;
					var peso = (data.peso == 0)? '':data.peso;
					var imc = (data.imc == 0)? '':data.imc;
					var grasa = (data.grasa == 0)? '':data.grasa;
					var musculo = (data.musculo == 0)? '':data.musculo;
					var calorias = (data.calorias == 0)? '':data.calorias;
					var edad_metabolica = (data.edad_metabolica == 0)? '':data.edad_metabolica;
					var grasa_visceral = (data.grasa_visceral == 0)? '':data.grasa_visceral;
					var frecuencia_cardiaca = (data.frecuencia_cardiaca == 0)? '':data.frecuencia_cardiaca;
					var glucosa = (data.glucosa == 0)? '':data.glucosa;
					$("#estatura").val(estatura);
					$("#peso").val(peso);
					$("#imc").val(imc);
					$("#grasa_muscular").val(grasa);
					$("#musculo").val(musculo);
					$("#calorias").val(calorias);
					$("#edad_metabolica").val(edad_metabolica);
					$("#grasa_visceral").val(grasa_visceral);
					$("#presion_arterial").val(data.presion);
					$("#frecuencia_cardiaca").val(frecuencia_cardiaca);
					$("#glucosa").val(glucosa);
					//Seccion Vision
					$("#ojo_izquierdo").val(data.vision_izquierda);
					$("#ojo_derecho").val(data.vision_derecha);
					$("#lentes").val(data.lentes);
					$("#colores").val(data.vision_color);


					$("#analisisModal").modal('show');
				});
				$("a#historia", row).bind('click', () => {
					$("#h_idMedico").val(data.idMedico);
					$("#h_nombre_candidato").html("Candidato <b>" + data.candidato + "</b>");
					$("#historiaModal").modal("show");
				});
				$("a#conclusiones", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					var conclusion;
					(data.conclusion == null) ? conclusion = "Paciente apto para desempeñarse en el puesto que solicita." : conclusion = data.conclusion;

					var descripcion;
					(data.descripcion == null) ? descripcion = "no cuenta con síntomas de enfermedad orgánica crónica, infecciosa o transmisible, así mismo que tampoco padece alguna limitación física y mental" : descripcion = data.descripcion;

					$("#idAnalisis").val(data.idMedico);
					$("#descripcion").val(descripcion);
					$("#conclusion").val(conclusion);
					$("#candidato_nombre").text(data.candidato);
					$("#conclusionesModal").modal("show");
				});
				$('a[id^=pdfFinal]', row).bind('click', () => {
					var id = data.idMedico;
					$('#pdf' + id).submit();
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
		datos.append('cliente', $("#cliente_registro").val());
		datos.append('nombre', $("#nombre_registro").val());
		datos.append('paterno', $("#paterno_registro").val());
		datos.append('materno', $("#materno_registro").val());
		datos.append('genero', $("#genero_registro").val());
		datos.append('fecha_nacimiento', $("#fecha_nacimiento_registro").val());
		datos.append('telefono_emergencia', $("#telefono_emergencia_registro").val());
		datos.append('avisar', $("#avisar_registro").val());
		datos.append('civil', $("#civil_registro").val());
		datos.append('escolaridad', $("#escolaridad_registro").val());
		
		$.ajax({
			url: '<?php echo base_url('Medico/registrarNuevo'); ?>',
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
						title: 'Se ha registrado correctamente',
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
	function subirHistoria() {
		if ($("#doc_historia").val() == "") {
			$("#doc_historia").addClass("requerido");
			$("#historiaModal #campos_vacios").css("display", "block");
			setTimeout(function() {
				$("#historiaModal #campos_vacios").fadeOut();
			}, 4000);
		} else {
			var docs = new FormData();
			var archivo = $("#doc_historia")[0].files[0];
			docs.append("id_medico", $("#h_idMedico").val());
			docs.append("archivo", archivo);
			$.ajax({
				url: "<?php echo base_url('Medico/subirHistoriaClinica'); ?>",
				method: "POST",
				data: docs,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					if (res == 1) {
						setTimeout(function() {
							$('.loader').fadeOut();
						}, 300);
						$("#historiaModal").modal('hide');
						$("#texto_msj").text(" La historia clinica se ha guardado correctamente");
						$("#mensaje").css('display', 'block');
						recargarTable();
						setTimeout(function() {
							$("#mensaje").fadeOut();
						}, 6000);
					}
				}
			});
		}
	}
	function recargarTable() {
		$("#tabla").DataTable().ajax.reload();
	}
	function guardarFichaIdentificacion(){
		var datos = new FormData();
		datos.append('genero', $("#genero").val());
		datos.append('fecha_nacimiento', $("#fecha_nacimiento").val());
		datos.append('telefono_emergencia', $("#telefono_emergencia").val());
		datos.append('avisar', $("#avisar").val());
		datos.append('civil', $("#civil").val());
		datos.append('escolaridad', $("#escolaridad").val());
		datos.append('id_candidato', $("#idCandidato").val());
		//Respaldo txt
		var formdata = $('#identificacion').serialize();
		var idCandidato = $("#idCandidato").val();
		var f = new Date();
		var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
		respaldoTxt(formdata, 'ficha_identificacion-' + idCandidato + '-' + fecha_txt);
		$.ajax({
			url: '<?php echo base_url('Medico/guardarFichaIdentificacion'); ?>',
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
					$("#msj_error_ficha").css('display', 'none');
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} 
				else {
					$("#msj_error_ficha").css('display', 'block').html(data.msg);
				}
			}
		});
	}


	function guardarConcluir() {
		var datos = new FormData();
		datos.append('descripcion', $("#descripcion").val());
		datos.append('conclusion', $("#conclusion").val());
		datos.append('id_candidato', $("#idCandidato").val());
		//Respaldo txt
		var formdata = $('#concluir').serialize();
		var idCandidato = $("#idCandidato").val();
		var f = new Date();
		var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
		respaldoTxt(formdata, 'conclusion-' + idCandidato + '-' + fecha_txt);
		console.log("Estamos a punto de hacer la peticon " + formdata);
		$.ajax({
			url: '<?php echo base_url('Medico/guardarConcluir'); ?>',
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
					$("#conclusionesModal").modal('hide');
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} 
				else {
					$("#msj_error_conclusion").css('display', 'block').html(data.msg);
				}
			}
		});
	}


	function guardarAntecedentesHeredoFamiliares(){
		var datos = new FormData();
		datos.append('diabetes', $("#diabetes").val());
		datos.append('cancer', $("#cancer").val());
		datos.append('hipertension', $("#hipertension").val());
		datos.append('cardiopatias', $("#cardiopatias").val());
		datos.append('pulmonares', $("#pulmonares").val());
		datos.append('renales', $("#renales").val());
		datos.append('psiquiatrica', $("#psiquiatrica").val());
		datos.append('cual', $('#cual').val());
		datos.append('sangre', $("#sangre").val());
		datos.append('id_candidato', $("#idCandidato").val());

		var formdata = $('#antecedentes_familiares').serialize();
		var idCandidato = $("#idCandidato").val();
		var f = new Date();
		var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
		respaldoTxt(formdata, 'antecedentes_heredo_familiares-' + idCandidato + '-' + fecha_txt);

		$.ajax({
			url: '<?php echo base_url('Medico/guardarAntecedentesHeredoFamiliares'); ?>',
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
					$("#msj_error_antecedentes_heredo").css('display', 'none');
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} 
				else {
					$("#msj_error_antecedentes_heredo").css('display', 'block').html(data.msg);
				}
			}
		});

	}
	function guardarAntecedentesNoPatologicos(){
		var datos = new FormData();
		datos.append('tabaco', $("#tabaco").val());
		datos.append('tabaco_cantidad', $("#tabaco_cantidad").val());
		datos.append('tabaco_frecuencia', $("#tabaco_frecuencia").val());
		datos.append('alcohol', $("#alcohol").val());
		datos.append('alcohol_cantidad', $("#alcohol_cantidad").val());
		datos.append('alcohol_frecuencia', $("#alcohol_frecuencia").val());
		datos.append('drogas', $("#drogas").val());
		datos.append('drogas_tipo', $("#drogas_tipo").val());
		datos.append('deporte', $("#deporte").val());
		datos.append('deporte_cual', $("#deporte_cual").val());
		datos.append('alimentacion', $("#alimentacion").val());
		datos.append('id_candidato', $("#idCandidato").val());

		var formdata = $('#antecedentes_no_patologicos').serialize();
		var idCandidato = $("#idCandidato").val();
		var f = new Date();
		var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
		respaldoTxt(formdata, 'antecedentes_no_patologicos-' + idCandidato + '-' + fecha_txt);

		$.ajax({
			url: '<?php echo base_url('Medico/guardarAntecedentesNoPatologicos'); ?>',
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
					$("#msj_error_antecedentes_no_patologicos").css('display', 'none');
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} 
				else {
					$("#msj_error_antecedentes_no_patologicos").css('display', 'block').html(data.msg);
				}
			}
		});
	}

	function guardarAntecedentesPatologicosPersonales(){
		var datos = new FormData();
		datos.append('quirurgicos', $("#quirurgicos").val());
		datos.append('quirurgicos_hace_cuanto', $("#quirurgicos_hace_cuanto").val());
		datos.append('quirurgicos_cual', $("#quirurgicos_cual").val());

		datos.append('internamientos', $("#internamientos").val());
		datos.append('internamientos_hace_cuanto', $("#internamientos_hace_cuanto").val());
		datos.append('internamientos_porque', $("#internamientos_porque").val());

		datos.append('transfusiones', $("#transfusiones").val());
		datos.append('transfusiones_hace_cuanto', $("#transfusiones_hace_cuanto").val());
		datos.append('transfusiones_porque', $("#transfusiones_porque").val());

		datos.append('fracturas', $("#fracturas").val());
		datos.append('esguinces', $("#esguinces").val());
		datos.append('luxaciones', $("#luxaciones").val());
		datos.append('traumatismo', $("#traumatismo").val());
		datos.append('hernia', $("#hernias").val());
		datos.append('lesiones_columna', $("#lesiones_columna").val());
		datos.append('alergias', $("#alergias").val());
		datos.append('alergias_aque', $("#alergias_aque").val());
		datos.append('id_candidato', $("#idCandidato").val());

		var formdata = $('#antecedentes_patologicos').serialize();
		var idCandidato = $("#idCandidato").val();
		var f = new Date();
		var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
		respaldoTxt(formdata, 'antecedentes_patologicos_personales-' + idCandidato + '-' + fecha_txt);

		$.ajax({
			url: '<?php echo base_url('Medico/guardarAntecedentesPatologicosPersonales'); ?>',
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
					$("#msj_error_antecedentes_patologicos").css('display', 'none');
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} 
				else {
					$("#msj_error_antecedentes_patologicos").css('display', 'block').html(data.msg);
				}
			}
		});
	}

	function guardarChequeoGeneral(){
		var datos = new FormData();
		datos.append('estatura', $("#estatura").val());
		datos.append('peso', $("#peso").val());
		datos.append('imc', $("#imc").val());
		datos.append('grasa_muscular', $("#grasa_muscular").val());
		datos.append('musculo', $("#musculo").val());
		datos.append('calorias', $("#calorias").val());
		datos.append('edad_metabolica', $("#edad_metabolica").val());
		datos.append('grasa_visceral', $("#grasa_visceral").val());
		datos.append('presion_arterial', $("#presion_arterial").val());
		datos.append('frecuencia_cardiaca', $("#frecuencia_cardiaca").val());
		datos.append('glucosa', $("#glucosa").val());
		datos.append('id_candidato', $("#idCandidato").val());

		var formdata = $('#chequeo').serialize();
		var idCandidato = $("#idCandidato").val();
		var f = new Date();
		var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
		respaldoTxt(formdata, 'chequeo_general-' + idCandidato + '-' + fecha_txt);

		$.ajax({
			url: '<?php echo base_url('Medico/guardarChequeoGeneral'); ?>',
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
					$("#msj_error_chequeo").css('display', 'none');
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} 
				else {
					$("#msj_error_chequeo").css('display', 'block').html(data.msg);
				}
			}
		});
	}

	function guardarVision(){
		var datos = new FormData();
		datos.append('ojo_derecho', $("#ojo_derecho").val());
		datos.append('ojo_izquierdo', $("#ojo_izquierdo").val());
		datos.append('colores', $("#colores").val());
		datos.append('lentes', $("#lentes").val());
		datos.append('id_candidato', $("#idCandidato").val());

		var formdata = $('#vision').serialize();
		var idCandidato = $("#idCandidato").val();
		var f = new Date();
		var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
		respaldoTxt(formdata, 'vision-' + idCandidato + '-' + fecha_txt);

		$.ajax({
			url: '<?php echo base_url('Medico/guardarVision'); ?>',
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
					$("#msj_error_vision").css('display', 'none');
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} 
				else {
					$("#msj_error_vision").css('display', 'block').html(data.msg);
				}
			}
		});
	}
	//Funciones de apoyo
	function respaldoTxt(formdata, nombreArchivo) {
		var textFileAsBlob = new Blob([formdata], {
			type: 'text/plain'
		});
		var fileNameToSaveAs = nombreArchivo + ".txt";
		var downloadLink = document.createElement("a");
		downloadLink.download = fileNameToSaveAs;
		downloadLink.innerHTML = "My Hidden Link";
		window.URL = window.URL || window.webkitURL;
		downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
		downloadLink.onclick = destroyClickedElement;
		downloadLink.style.display = "none";
		document.body.appendChild(downloadLink);
		downloadLink.click();
	}
	function destroyClickedElement(event) {
		document.body.removeChild(event.target);
	}
</script>