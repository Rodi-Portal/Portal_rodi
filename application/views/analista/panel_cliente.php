<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Cliente: <small>E-SOLUTIONS</small></h1><br>
		<a href="#" class="btn btn-primary btn-icon-split" id="btn_nuevo" onclick="nuevoRegistro()">
			<span class="icon text-white-50">
				<i class="fas fa-plus-circle"></i>
			</span>
			<span class="text">Registrar candidato</span>
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
	<a href="#" class="btn btn-primary btn-icon-split btnRegresar" id="btn_regresar" onclick="regresarListado()" style="display: none;">
		<span class="icon text-white-50">
			<i class="fas fa-arrow-left"></i>
		</span>
		<span class="text">Regresar al listado</span>
	</a>
	<input type="hidden" id="idCandidato">
	<input type="hidden" id="correo">
	<input type="hidden" id="idCliente">
	<input type="hidden" id="idDoping">
	<input type="hidden" class="prefijo">
	<input type="hidden" id="idFinalizado">
	<input type="hidden" id="idBGC">
	<input type="hidden" id="docsConjunto">
	<input type="hidden" id="idMedico">
	<input type="hidden" id="confirmarID">
	<input type="hidden" id="confirmarTipoAccion">
	<input type="hidden" id="confirmarSeccion">
	<input type="hidden" id="idElemento">
	<input type="hidden" id="idElemento2">
	<input type="hidden" id="Numero">
	<input type="hidden" id="Candidato">
	<input type="hidden" id="idSeccion">

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

	<section class="content" id="formulario" style="display: none;">
		<div class="row">
			<div class="col-12">
				<div class="text-center">
					<h4 class="text-primary"><strong> Referencias Laborales de <span class="nombreCandidato"></span></strong></h4><br><br>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="alert alert-warning">
					<h4 class="text-center">Break(s) in Employment</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<textarea class="form-control trabajo_gobierno" name="trabajo_inactivo" id="trabajo_inactivo" rows="5"></textarea><br><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 offset-md-5">
				<button type="button" class="btn btn-success" onclick="actualizarTrabajoGobierno()">Guardar respuestas anteriores</button>
				<br><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="trabajos_msj_error" class="alert alert-danger hidden"></div>
			</div>
		</div>
		<?php
		for ($i = 1; $i <= 25; $i++) {
			echo '<div class="text-center">
							<h4 class="box-title " id="titulo_reflab' . $i . '"><strong> Trabajo #' . $i . ' </strong><hr></h4>
						</div>';
			echo '<div class="row">
							<div class="col-6">
								<form id="candidato_reflaboral' . $i . '" class="formCandidato">
									<div class="alert alert-info"><h4 class="text-center">Candidato</h4></div>
									<div class="row">
										<div class="col-md-3">
											<label>Compañía: </label>
											<br>
										</div>
										<div class="col-9">
											<input type="text" class="form-control es_reflab" name="reflab' . $i . '_empresa_ingles" id="reflab' . $i . '_empresa_ingles" >
									<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<label>Dirección: </label>
											<br>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control es_reflab" name="reflab' . $i . '_direccion_ingles" id="reflab' . $i . '_direccion_ingles">
									<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<label>Fecha de entrada: </label>
											<br>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control fecha_laboral es_reflab" name="reflab' . $i . '_entrada_ingles" id="reflab' . $i . '_entrada_ingles" placeholder="mm/dd/yyyy">
									<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<label>Fecha de salida: </label>
											<br>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control fecha_laboral es_reflab" name="reflab' . $i . '_salida_ingles" id="reflab' . $i . '_salida_ingles" placeholder="mm/dd/yyyy">
									<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<label>Teléfono: </label>
											<br>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control solo_numeros es_reflab" name="reflab' . $i . '_telefono_ingles" id="reflab' . $i . '_telefono_ingles" maxlength="10">
									<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<label>Puesto inicial: </label>
											<br>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control es_reflab" name="reflab' . $i . '_puesto1_ingles" id="reflab' . $i . '_puesto1_ingles">
									<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<label>Puesto final: </label>
											<br>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control es_reflab" name="reflab' . $i . '_puesto2_ingles" id="reflab' . $i . '_puesto2_ingles">
									<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<label>Salario inicial: </label>
											<br>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control solo_numeros es_reflab" name="reflab' . $i . '_salario1_ingles" id="reflab' . $i . '_salario1_ingles">
									<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<label>Salario final: </label>
											<br>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control solo_numeros es_reflab" name="reflab' . $i . '_salario2_ingles" id="reflab' . $i . '_salario2_ingles">
									<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<label>Jefe inmediato: </label>
											<br>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control es_reflab" name="reflab' . $i . '_jefenombre_ingles" id="reflab' . $i . '_jefenombre_ingles">
									<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<label>Correo del jefe inmediato: </label>
											<br>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control es_reflab" name="reflab' . $i . '_jefecorreo_ingles" id="reflab' . $i . '_jefecorreo_ingles">
									<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<label>Puesto del jefe inmediato:</label>
											<br>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control es_reflab" name="reflab' . $i . '_jefepuesto_ingles" id="reflab' . $i . '_jefepuesto_ingles">
									<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-3">
											<label>Causa de separación: </label>
											<br>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control es_reflab" name="reflab' . $i . '_separacion_ingles" id="reflab' . $i . '_separacion_ingles">
									<br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4 offset-2">
											<button type="button" class="btn btn-success" onclick="actualizarReferenciaLaboral(' . $i . ')">Guardar referencia laboral</button><br><br><br><br>
											<input type="hidden" id="idreflabingles' . $i . '">
										</div>
										<div class="col-md-4">
											<button type="button" class="btn btn-danger" onclick="confirmarEliminarLaboral(' . $i . ')">Eliminar referencia laboral</button><br><br><br><br>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div id="reflab_msj_error' . $i . '" class="alert alert-danger hidden"></div>
										</div>
									</div>
								</form>
							</div>
							<div class="col-6">
  							<form id="analista_reflaboral' . $i . '" class="formAnalista">
								<div class="alert alert-warning">
									<h4 class="text-center">Analista</h4>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Compañía: </label>
										<br>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control es_verlab" name="an_reflab' . $i . '_empresa" id="an_reflab' . $i . '_empresa">
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Dirección: </label>
										<br>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control es_verlab" name="an_reflab' . $i . '_direccion" id="an_reflab' . $i . '_direccion">
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Fecha de entrada: </label>
										<br>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control fecha_laboral es_verlab" name="an_reflab' . $i . '_entrada" id="an_reflab' . $i . '_entrada" placeholder="mm/dd/yyyy">
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Fecha de salida: </label>
										<br>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control fecha_laboral es_verlab" name="an_reflab' . $i . '_salida" id="an_reflab' . $i . '_salida" placeholder="mm/dd/yyyy">
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Teléfono: </label>
										<br>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control solo_numeros es_verlab" name="an_reflab' . $i . '_telefono" id="an_reflab' . $i . '_telefono" maxlength="10">
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Puesto inicial: </label>
										<br>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control es_verlab" name="an_reflab' . $i . '_puesto1" id="an_reflab' . $i . '_puesto1">
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Puesto final: </label>
										<br>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control es_verlab" name="an_reflab' . $i . '_puesto2" id="an_reflab' . $i . '_puesto2">
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Salario inicial: </label>
										<br>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control solo_numeros es_verlab" name="an_reflab' . $i . '_salario1" id="an_reflab' . $i . '_salario1">
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Salario final: </label>
										<br>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control solo_numeros es_verlab" name="an_reflab' . $i . '_salario2" id="an_reflab' . $i . '_salario2">
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Jefe inmediato: </label>
										<br>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control es_verlab" name="an_reflab' . $i . '_jefenombre" id="an_reflab' . $i . '_jefenombre">
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Correo del jefe inmediato: </label>
										<br>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control es_verlab" name="an_reflab' . $i . '_jefecorreo" id="an_reflab' . $i . '_jefecorreo">
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Puesto del jefe inmediato: </label>
										<br>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control es_verlab" name="an_reflab' . $i . '_jefepuesto" id="an_reflab' . $i . '_jefepuesto">
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Causa de separación: </label>
										<br>
									</div>
									<div class="col-md-9">
										<input type="text" class="form-control es_verlab" name="an_reflab' . $i . '_separacion" id="an_reflab' . $i . '_separacion">
										<br>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<label>Notas *</label>
								<textarea class="form-control es_verlab" name="an_reflab' . $i . '_notas" id="an_reflab' . $i . '_notas" rows="3"></textarea><br>
							</div>
							<div class="col-md-6 offset-md-4">
								<label>Aplicar a todos</label>
								<select id="aplicar_todo' . $i . '" class="form-control aplicar_todo">
									<option value="-1">Select</option>
									<option value="0">Not provided</option>
									<option value="1">Excellent</option>
									<option value="2">Good</option>
									<option value="3">Regular</option>
									<option value="4">Bad</option>
									<option value="5">Very Bad</option>
								</select>
								<br><br>
							</div>
							<div class="col-md-3">
								<label>Responsabilidad *</label>
								<select name="an_reflab' . $i . '_responsabilidad" id="an_reflab' . $i . '_responsabilidad" class="form-control caracteristica performance' . $i . ' ">
									<option value="Not provided">Not provided</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Regular">Regular</option>
									<option value="Bad">Bad</option>
									<option value="Very Bad">Very Bad</option>
								</select>
								<br>
							</div>
							<div class="col-md-3">
								<label>Iniciativa *</label>
								<select name="an_reflab' . $i . '_iniciativa" id="an_reflab' . $i . '_iniciativa" class="form-control caracteristica performance' . $i . ' ">
									<option value="Not provided">Not provided</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Regular">Regular</option>
									<option value="Bad">Bad</option>
									<option value="Very Bad">Very Bad</option>
								</select>
								<br>
							</div>
							<div class="col-md-3">
								<label>Eficiencia laboral *</label>
								<select name="an_reflab' . $i . '_eficiencia" id="an_reflab' . $i . '_eficiencia" class="form-control caracteristica performance' . $i . ' ">
									<option value="Not provided">Not provided</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Regular">Regular</option>
									<option value="Bad">Bad</option>
									<option value="Very Bad">Very Bad</option>
								</select>
								<br>
							</div>
							<div class="col-md-3">
								<label>Disciplina *</label>
								<select name="an_reflab' . $i . '_disciplina" id="an_reflab' . $i . '_disciplina" class="form-control caracteristica performance' . $i . ' ">
									<option value="Not provided">Not provided</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Regular">Regular</option>
									<option value="Bad">Bad</option>
									<option value="Very Bad">Very Bad</option>
								</select>
								<br>
							</div>
							<div class="col-md-3">
								<label>Puntualidad y asistencia *</label>
								<select name="an_reflab' . $i . '_puntualidad" id="an_reflab' . $i . '_puntualidad" class="form-control caracteristica performance' . $i . ' ">
									<option value="Not provided">Not provided</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Regular">Regular</option>
									<option value="Bad">Bad</option>
									<option value="Very Bad">Very Bad</option>
								</select>
								<br>
							</div>
							<div class="col-md-3">
								<label>Limpieza y orden *</label>
								<select name="an_reflab' . $i . '_limpieza" id="an_reflab' . $i . '_limpieza" class="form-control caracteristica performance' . $i . ' ">
									<option value="Not provided">Not provided</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Regular">Regular</option>
									<option value="Bad">Bad</option>
									<option value="Very Bad">Very Bad</option>
								</select>
								<br>
							</div>
							<div class="col-md-3">
								<label>Estabilidad laboral *</label>
								<select name="an_reflab' . $i . '_estabilidad" id="an_reflab' . $i . '_estabilidad" class="form-control caracteristica performance' . $i . ' ">
									<option value="Not provided">Not provided</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Regular">Regular</option>
									<option value="Bad">Bad</option>
									<option value="Very Bad">Very Bad</option>
								</select>
								<br>
							</div>
							<div class="col-md-3">
								<label>Estabilidad emocional *</label>
								<select name="an_reflab' . $i . '_emocional" id="an_reflab' . $i . '_emocional" class="form-control caracteristica performance' . $i . ' ">
									<option value="Not provided">Not provided</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Regular">Regular</option>
									<option value="Bad">Bad</option>
									<option value="Very Bad">Very Bad</option>
								</select>
								<br>
							</div>
							<div class="col-md-3">
								<label>Honestidad *</label>
								<select name="an_reflab' . $i . '_honesto" id="an_reflab' . $i . '_honesto" class="form-control caracteristica performance' . $i . ' ">
									<option value="Not provided">Not provided</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Regular">Regular</option>
									<option value="Bad">Bad</option>
									<option value="Very Bad">Very Bad</option>
								</select>
								<br>
							</div>
							<div class="col-md-3">
								<label>Rendimiento *</label>
								<select name="an_reflab' . $i . '_rendimiento" id="an_reflab' . $i . '_rendimiento" class="form-control caracteristica performance' . $i . ' ">
									<option value="Not provided">Not provided</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Regular">Regular</option>
									<option value="Bad">Bad</option>
									<option value="Very Bad">Very Bad</option>
								</select>
								<br>
							</div>
							<div class="col-md-4">
								<label>Actitud con colaboradores, jefes y subordinados *</label>
								<select name="an_reflab' . $i . '_actitud" id="an_reflab' . $i . '_actitud" class="form-control caracteristica performance' . $i . ' ">
									<option value="Not provided">Not provided</option>
									<option value="Excellent">Excellent</option>
									<option value="Good">Good</option>
									<option value="Regular">Regular</option>
									<option value="Bad">Bad</option>
									<option value="Very Bad">Very Bad</option>
								</select>
								<br>
							</div>
							<div class="col-md-4">
								<label>¿Lo(a) contrataría de nuevo? *</label>
								<select name="an_reflab' . $i . '_recontratacion" id="an_reflab' . $i . '_recontratacion" class="form-control es_verlab">
									<option value="">Select</option>
									<option value="0">No</option>
									<option value="1">Yes</option>
								</select>
								<br><br><br>
							</div>
							<div class="col-md-8">
								<label>¿Por qué? *</label>
								<textarea class="form-control es_verlab" name="an_reflab' . $i . '_motivo" id="an_reflab' . $i . '_motivo" rows="3"></textarea>
								<br><br><br>
							</div>
							</form>
							<div class="col-md-3 offset-md-5">
								<button type="button" class="btn btn-success" onclick="verificarLaboral(' . $i . ')">Guardar verificación laboral #' . $i . '</button>
								<br><br><input type="hidden" id="idverlab' . $i . '">
							</div>
							<div class="col-12">
								<div id="verlab_msj_error' . $i . '" class="alert alert-danger hidden"></div>
							</div>
						</div>';
			}
		?>
	</section>
	
</div>

<!-- /.content-wrapper -->	
<script>
	var id_cliente = 205;
	var extras = [];
	var url = '<?php echo base_url('Cliente_ESOLUTIONS/getCandidatos'); ?>';
	$(document).ready(function(){
		$('#fecha_nacimiento_registro, #fecha_nacimiento_nuevo, .fecha_laboral, #fecha_facis').inputmask('mm/dd/yyyy', {
			'placeholder': 'mm/dd/yyyy'
		});
		$('.fecha_laboral').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' });
		$('#fecha_inicio_proceso, #fecha_nacimiento, #fecha_nacimiento_internacional').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
		var msj = localStorage.getItem("success");
		var msj2 = localStorage.getItem("finished");
		if(msj == 1){
			$("#exitoCandidato").css('display','block');
			setTimeout(function(){
						$('#exitoCandidato').fadeOut();
				},4000);
				localStorage.removeItem("success");
		}
		if(msj2 == 1){
			$("#exitoFinalizado").css('display','block');
			setTimeout(function(){
						$('#exitoFinalizado').fadeOut();
				},4000);
				localStorage.removeItem("finished");
		}
		$('#tabla').DataTable({
			"pageLength": 25,
			//"pagingType": "simple",
			"order": [0, "desc"],
			"stateSave": true,
			"serverSide": false,
			
			"ajax": url,
			"columns":[ 
				{ title: 'id', data: 'id', visible: false },
				{ title: 'Candidato', data: 'candidato', "width": "15%", bSortable: false,
					mRender: function(data, tpe, full){
						var analista = (full.usuario == null | full.usuario == '') ? '<small><b>(Sin definir)</b></small>' : '<small><b>('+full.usuario+')</b></small>';
						return '<a data-toggle="tooltip" class="sin_vinculo" title="' + full.id + '">' + data + '</a><br>'+analista;
					}
				},
				{ title: 'Proyecto', data: 'proyecto', bSortable: false,
					mRender: function(data, type, full){
						if(data != null){
							var sub = (full.subproyecto != null)? full.subproyecto:'';
							return data+' '+sub;
						}
						else{
							var sub = (full.subproyecto != null)? full.subproyecto:'-';
							return sub;
						}
					}
				},
				{ title: 'Fechas de Registro', data: 'fecha_alta', bSortable: false, "width": "18%",
					mRender: function(data, type, full){
						if(full.socioeconomico == 1){
							var f = data.split(' ');
							var h = f[1];
							var aux = h.split(':');
							var hora = aux[0]+':'+aux[1];
							var aux = f[0].split('-');
							var fecha = aux[2]+"/"+aux[1]+"/"+aux[0];
							var f_inicio = fecha+' '+hora;
							if(full.fecha_final != null){
								var f = full.fecha_final.split(' ');
								var h = f[1];
								var aux = h.split(':');
								var hora = aux[0]+':'+aux[1];
								var aux = f[0].split('-');
								var fecha = aux[2]+"/"+aux[1]+"/"+aux[0];
								var f_fin = "<b>Final:</b>: "+fecha+' '+hora;
								return "<b>Alta:</b> "+f_inicio+'<br>'+f_fin;
							}
							else{
								var f = new Date();
								var hoy = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear();
								return "<b>Alta:</b> "+f_inicio+'<br><b>Final:</b> -';
							}
						}
						else{
							var f = data.split(' ');
							var h = f[1];
							var aux = h.split(':');
							var hora = aux[0]+':'+aux[1];
							var aux = f[0].split('-');
							var fecha = aux[2]+"/"+aux[1]+"/"+aux[0];
							var f_inicio = fecha+' '+hora;
							return "<b>Alta:</b> "+f_inicio;
						}
					}
				},
				{ title: 'SLA', data: 'tiempo', bSortable: false, "width": "6%",
					mRender: function(data, type, full){
						if(full.socioeconomico == 1){
							if(data != null){
								if(data != -1){
									if(data >= 0 && data <= 2){
										return res = '<div class="formato_dias dias_verde">'+data+' días</div>';
									}
									if(data > 2 && data <= 4){
										return res = '<div class="formato_dias dias_amarillo">'+data+' días</div>';
									}
									if(data >= 5){
										return res = '<div class="formato_dias dias_rojo">'+data+' días</div>';
									}
								}
								else{
									return "Actualizando...";
								}
							}
							else{
								if(full.tiempo_parcial != 0){
									var parcial = full.tiempo_parcial;
									if(parcial >= 0 && parcial <= 2){
										return res = '<div class="formato_dias dias_verde">'+parcial+' días</div>';
									}
									if(parcial >= 2 && parcial <= 4){
										return res = '<div class="formato_dias dias_amarillo">'+parcial+' días</div>';
									}
									if(parcial >= 5){
										return res = '<div class="formato_dias dias_rojo">'+parcial+' días</div>';
									}
								}
								else{
									return "Actualizando...";
								}
							}
						}
						else{
							return 'N/A';
						}
					}
				},
				{ title: 'Fechas de Proceso', data: 'fecha_contestado', bSortable: false, "width": "18%",
					mRender: function(data, type, full){
						if(full.cancelado == 0){
							if(full.socioeconomico == 1){
								if(full.tipo_formulario > 0){
									var salida = '';
									//Fecha recibida por el envio de formulario del candidato
									if(data == "" || data == null){
										salida += "<i class='fas fa-circle estatus0'></i> Sin contestar <br>";
									}
									else{
										var f = data.split(' ');
										var h = f[1];
										var aux = h.split(':');
										var hora = aux[0]+':'+aux[1];
										var aux = f[0].split('-');
										var fecha = aux[2]+"/"+aux[1]+"/"+aux[0];
										var tiempo = fecha+' '+hora;
										salida += "<i class='fas fa-circle estatus1'></i><b>Formulario: </b>"+tiempo+'<br>';
									}
									//Fecha recibida por el carga de documentos del candidato
									if(full.fecha_documentos == "" || full.fecha_documentos == null){
										salida += "<i class='fas fa-circle estatus0'></i> En espera";
									}
									else{
										var f = full.fecha_documentos.split(' ');
										var h = f[1];
										var aux = h.split(':');
										var hora = aux[0]+':'+aux[1];
										var aux = f[0].split('-');
										var fecha = aux[2]+"/"+aux[1]+"/"+aux[0];
										var tiempo = fecha+' '+hora;
										salida += "<i class='fas fa-circle estatus1'></i><b>Documentos: </b>"+tiempo;
									}
									return salida;
								}
								else{
									return "N/A";
								}
							}
							else{
								return 'N/A';
							}
						}
						else{
							return "N/A";
						}
					}
				},
				{ title: 'Acciones', data: 'id', bSortable: false, "width": "10%",
					mRender: function(data, type, full) {
						if(full.cancelado == 0){
							var icono_datosContacto = '<a href="javascript:void(0)" id="datos_contacto" class="fa-tooltip icono_datatable"><i class="far fa-address-card"></i></a>';
							if(full.socioeconomico == 1){
								var icono_fechaReal = '<a href="javascript:void(0)" id="fecha_real" class="fa-tooltip icono_datatable"><i class="fas fa-calendar-check"></i></a>';
								if(full.tipo_formulario > 0){
									return '<a href="javascript:void(0)" id="msj_avances" class="fa-tooltip icono_datatable"><i class="fas fa-comment-dots"></i></a> <a href="javascript:void(0)" id="generar" class="fa-tooltip icono_datatable"><i class="fas fa-key"></i></a> <a href="javascript:void(0)" id="editar_pruebas" class="fa-tooltip icono_datatable"><i class="fas fa-edit"></i></a> '+icono_datosContacto+' '+icono_fechaReal;
								}
								else{
									return '<a href="javascript:void(0)" id="msj_avances" class="fa-tooltip icono_datatable"><i class="fas fa-comment-dots"></i></a> <a href="javascript:void(0)" id="editar_pruebas" class="fa-tooltip icono_datatable"><i class="fas fa-edit"></i></a> '+icono_datosContacto+' '+icono_fechaReal;
								}
							}
							else{
								return '<a href="javascript:void(0)" id="msj_avances" class="fa-tooltip icono_datatable"><i class="fas fa-comment-dots"></i></a> <a href="javascript:void(0)" id="editar_pruebas" class="fa-tooltip icono_datatable"><i class="fas fa-edit"></i></a> '+icono_datosContacto;
							}
						}
						else{
							return "N/A";
						}
					}
				},
				{ title: 'Estudio', data: 'secciones', bSortable: false, "width": "12%",
					mRender: function(data, type, full) {
						if(full.cancelado == 0){
							if(full.socioeconomico == 1){
								if(data != null){
									var salida = '';
									var contenedor_inicial = '<div class="btn-group"  style="margin-bottom: 10px;"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Proceso del candidato</button><div class="dropdown-menu">';
									var contenedor_final = '</div></div>';
									var separador = '<div class="dropdown-divider"></div>';
									var gaps = '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0)" id="datos_gaps">GAPS</a>';
									var ver_estudios = '<a class="dropdown-item" href="javascript:void(0)" id="estudios">Verificación de estudios</a>';
									var ver_empleos = '<a class="dropdown-item" href="javascript:void(0)" id="laborales">Verificación de referencias laborales</a>';
									var ver_criminal = '<a class="dropdown-item" href="javascript:void(0)" id="penales">Verificación antecedentes penales</a>';
									// var resto = '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0)" id="datos_checklist">Alcance de las verificaciones</a><div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0)" id="subirDocs">Documentación</a>';
									var resto = '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0)" id="subirDocs">Documentación</a>';
									var conclusiones = '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0)" id="conclusiones">Conclusiones</a>';
									var cancelar = '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0)" id="eliminar">Cancelar proceso</a></div></div>';
									salida += contenedor_inicial+data;
									var lleva_gaps = (full.lleva_gaps == 1)? gaps+separador:'';
									salida += lleva_gaps;
									if(full.lleva_empleos == 1 || full.lleva_criminal == 1 || full.lleva_estudios == 1){
										if(full.lleva_estudios == 1){
											salida += ver_estudios;
										}
										if(full.lleva_empleos == 1){
											salida += ver_empleos;
										}
										if(full.lleva_criminal == 1){
											salida += ver_criminal;
										}
									}
									if(full.status == 0 || full.status == 1){
										salida += resto+cancelar+contenedor_final;
									}
									if(full.status == 2){
										salida += resto+conclusiones+cancelar+contenedor_final;
									}
									return salida;
									
								}
								else{
									return 'Procesando...'
								}
							}
							else{
								return "N/A";
							}
						}
						else{
							return "N/A";
						}
					}
				},
				{ title: 'Exámenes', data: 'id', bSortable: false, "width": "15%",
					mRender: function(data, type, full) {
						var doping = '';
						var medico = '';
						if(full.cancelado == 0){
							//Antidoping
							if(full.antidoping != 0){
								if(full.fecha_resultado != null && full.fecha_resultado != ""){
									if(full.resultado_doping == 1){
										doping = "<b>Antidoping: </b> <i class='fas fa-circle status_bgc2'></i>"; 
									}
									else{
										doping = "<b>Antidoping: </b> <i class='fas fa-circle status_bgc1'></i>";
									}
								}
								else{
									doping = "<b>Antidoping: </b> <i class='fas fa-circle status_bgc0'></i>";
								}
							}
							if(full.antidoping == 0){
								doping = "<b>Antidoping: </b> N/A";
							}
							//Medico
							if(full.medico == 1){
								if(full.archivo_examen_medico != null && full.archivo_examen_medico != ""){
									var carpeta_clinico = '<?php echo base_url(); ?>_clinico/';
									medico = '<b>Médico: </b> <a href="javascript:void(0)" data-toggle="tooltip" title="Subir examen medico" id="examen_medico" class="fa-tooltip icono_datatable"><i class="fas fa-upload"></i></a> <a href="'+carpeta_clinico+full.archivo_examen_medico+'" id="ver_medico" target="_blank" data-toggle="tooltip" title="Ver examen medico" class="fa-tooltip icono_datatable"><i class="fas fa-file-medical"></i></a>'; 
								}
								else{
									medico = '<b>Médico: </b> <a href="javascript:void(0)" data-toggle="tooltip" title="Subir examen medico" id="examen_medico" class="fa-tooltip icono_datatable"><i class="fas fa-upload"></i></a>';
								}
							}
							else{
								medico = "<b>Médico: </b> N/A";
							}
							//Resultados
							return doping+'<br>'+medico;
						}
						else{
							return "N/A";
						}
					}
				},
				{ title: 'Proceso', data: 'id', bSortable: false, "width": "10%",
					mRender: function(data, type, full) {
						if(full.cancelado == 0){
							if(full.socioeconomico == 1){
								if(full.status == 0 || (full.status == 1 && full.status_bgc == 0)){
									return '<a href="javascript:void(0)" data-toggle="tooltip" title="Finalizar proceso del candidato" id="final" class="fa-tooltip icono_datatable"><i class="fas fa-user-check"></i></a>';
								}
								else{
									switch(full.status_bgc){
										case '1': 
											var icono = '<i class="fas fa-circle status_bgc1"></i> ';
											break;
										case '2': 
											var icono = '<i class="fas fa-circle status_bgc2"></i> ';
											break;
										case '3': 
											var icono = '<i class="fas fa-circle status_bgc3"></i> ';
											break;
									}
									var pdf = '<div style="display: inline-block;"><form id="pdfForm'+data+'" action="<?php echo base_url('Cliente_ESOLUTIONS/crearReportePDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final" id="pdfFinal" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idCandidatoPDF" id="idCandidatoPDF'+data+'" value="'+data+'"></form></div>';
									return icono + pdf;
								}
							}
							else{
                //Antidoping
                if (full.tipo_antidoping == 1) {
                  if (full.fecha_resultado != null && full.fecha_resultado != "") {
                    var color = (full.resultado_doping == 1)? '<i class="fas fa-circle status_bgc2"></i> ' : '<i class="fas fa-circle status_bgc1"></i> ';

                    return color + '<div style="display: inline-block;"><form id="pdfDopingBGV' + full.idDoping + '" action="<?php echo base_url('Doping/createReporteDopingPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Download test doping" id="pdfDopingBGV" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' + full.idDoping + '" value="' + full.idDoping + '"></form></div>';
                  } else {
                    return '<i class="fas fa-circle status_bgc3"></i> Waiting for results';
                  }
                }
                else{
								  return "Sin ESE";
                }
							}
						}
						else{
							return "N/A";
						}
					}
				}     
			],
			fnDrawCallback: function (oSettings) {
				$('a[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
			},
			rowCallback: function( row, data ) {
				$("a#msj_avances", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					verMensajesAvances(data.id,data.candidato)
				});
				$("a#generar", row).bind('click', () => {
          $("#idCandidato").val(data.id);
					$.ajax({
            url: '<?php echo base_url('Candidato/getById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != 0){
								var dato = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#correo").val(dato.correo);
								$("#quitarModal #titulo_accion").text("Generar password");
								$("#quitarModal #texto_confirmacion").html("Estás seguro de generar un nuevo password para <b>" + dato.nombre + " " + dato.paterno + " " + dato.materno + "</b>?");
								$("#quitarModal #btnGuardar").attr('value', 'generar');
								$("#quitarModal").modal("show");
							}
							else{
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								Swal.fire({
									position: 'center',
									icon: 'error',
									title: 'No se encontró información del candidato',
									showConfirmButton: false,
									timer: 2500
								})
							}
            }
          });
        });
				$('a#datos_generales', row).bind('click', () => {
          $("#idCandidato").val(data.id);
          $(".nombreCandidato").text(data.candidato);
					$.ajax({
            url: '<?php echo base_url('Candidato/getById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != 0){
								var dato = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#nombre_general").val(dato.nombre);
								$("#paterno_general").val(dato.paterno);
								$("#materno_general").val(dato.materno);
								if(dato.fecha_nacimiento != "0000-00-00" && dato.fecha_nacimiento != null){
									var f_nacimiento = fechaFormEspanol(dato.fecha_nacimiento);
									$("#fecha_nacimiento").val(f_nacimiento);
								}
								else{
									$("#fecha_nacimiento").val("");
								}
								$("#puesto_general").val(dato.puesto);
								$("#nacionalidad").val(dato.nacionalidad);
								$("#genero").val(dato.genero);
								$("#calle").val(dato.calle);
								$("#exterior").val(dato.exterior);
								$("#interior").val(dato.interior);
								$("#colonia").val(dato.colonia);
								$("#calles").val(dato.entre_calles);
								$("#estado").val(dato.id_estado);
								if (dato.id_estado != "" && dato.id_estado != null && dato.id_estado != 0) {
									getMunicipio(dato.id_estado, dato.id_municipio);
								} else {
									$('#municipio').prop('disabled', true);
									$('#municipio').val('');
								}
								$("#cp").val(dato.cp);
								$("#civil").val(dato.estado_civil);
								$("#celular_general").val(dato.celular);
								$("#tel_casa").val(dato.telefono_casa);
								$("#correo_general").val(dato.correo);
								$("#grado_estudios").val(dato.id_grado_estudio);
								$("#curp_general").val(dato.curp);
								$("#generalesModal").modal('show');
							}
							else{
								$('#formGenerales')[0].reset();
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#generalesModal").modal('show');
							}
            }
          });
        });
				$('a#datos_contacto', row).bind('click', () => {
          $("#idCandidato").val(data.id);
          $(".nombreCandidato").text(data.candidato);
					$.ajax({
            url: '<?php echo base_url('Candidato/getById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != 0){
								var dato = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#nombre_contacto").val(dato.nombre);
								$("#paterno_contacto").val(dato.paterno);
								$("#materno_contacto").val(dato.materno);
								$("#celular_contacto").val(dato.celular);
								$("#tel_casa_contacto").val(dato.telefono_casa);
								$("#correo_contacto").val(dato.correo);
								$("#contactoModal").modal('show');
							}
							else{
								$('#formContacto')[0].reset();
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#contactoModal").modal('show');
							}
            }
          });
        });
				$('a#datos_generales_internacionales', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$('.personal_obligado').removeClass('requerido');
					
					$.ajax({
            url: '<?php echo base_url('Candidato/getById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != 0){
								var dato = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#nombre_internacional").val(dato.nombre);
								$("#paterno_internacional").val(dato.paterno);
								$("#materno_internacional").val(dato.materno);
								if(dato.fecha_nacimiento != "0000-00-00" && dato.fecha_nacimiento != null){
									var f_nacimiento = fechaFormEspanol(dato.fecha_nacimiento);
									$("#fecha_nacimiento_internacional").val(f_nacimiento);
								}
								else{
									$("#fecha_nacimiento_internacional").val("");
								}
								$("#puesto_internacional").val(dato.puesto);
								$("#nacionalidad_internacional").val(dato.nacionalidad);
								$("#genero_internacional").val(dato.genero);
								$("#domicilio_internacional").val(dato.domicilio_internacional);
								$("#pais_internacional").val(dato.pais);
								$("#civil_internacional").val(dato.estado_civil);
								$("#celular_internacional").val(dato.celular);
								$("#tel_casa_internacional").val(dato.telefono_casa);
								$("#tel_oficina_internacional").val(dato.telefono_otro);
								$("#correo_internacional").val(dato.correo);
								$("#generalesInternacionalModal").modal('show');
							}
							else{
								$('#formGeneralesInternacional')[0].reset();
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#generalesInternacionalModal").modal('show');
							}
            }
          });
				});
				$('a#datos_mayores_estudios', row).bind('click', () => {
          $("#idCandidato").val(data.id);
          $(".nombreCandidato").text(data.candidato);
          $("#mayor_estudios_candidato").val(data.id_grado_estudio);
          $("#periodo_candidato").val(data.estudios_periodo);
          $("#escuela_candidato").val(data.estudios_escuela);
          $("#ciudad_candidato").val(data.estudios_ciudad);
          $("#certificado_candidato").val(data.estudios_certificado);
					$.ajax({
            url: '<?php echo base_url('Candidato_Estudio/getMayorById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != 0){
								var dato = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
                
								$("#mayor_estudios_analista").val(dato.id_tipo_studies);
								$("#periodo_analista").val(dato.periodo);
								$("#escuela_analista").val(dato.escuela);
								$("#ciudad_analista").val(dato.ciudad);
								$("#certificado_analista").val(dato.certificado);
								$("#mayor_estudios_comentarios").val(dato.comentarios);
								$("#mayoresEstudiosModal").modal('show');
							}
							else{
								$('#formMayoresEstudios')[0].reset();
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#mayoresEstudiosModal").modal('show');
							}
            }
          });
        });
				$('a#datos_globales', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$('.es_global').prop('readonly',true);
					if(data.id_seccion_global_search == 4){
						$("#oig").prop('readonly', false);
						$("#interpol").prop('readonly', false);
						$("#sanctions").prop('readonly', false);
						$("#media_searches").prop('readonly', false);
						$.ajax({
							url: '<?php echo base_url('Candidato_Global/getById'); ?>',
							method: 'POST',
							data: {'id':data.id},
							beforeSend: function() {
								$('.loader').css("display","block");
							},
							success: function(res){
								if(res != null){
									var dato = JSON.parse(res);
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#oig").val(dato.oig);
									$("#interpol").val(dato.interpol);
									$("#sanctions").val(dato.sanctions);
									$("#media_searches").val(dato.media_searches);
									$("#global_comentarios").val(dato.global_comentarios);
									$("#globalSearchModal").modal('show');
								}
								else{
									$('#formGlobal')[0].reset();
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#globalSearchModal").modal('show');
								}
							}
						});
					}
					if(data.id_seccion_global_search == 5){
						$("#oig").prop('readonly', false);
						$("#sanctions").prop('readonly', false);
						$("#facis").prop('readonly', false);
						$("#bureau").prop('readonly', false);
						$("#european_financial").prop('readonly', false);
						$.ajax({
							url: '<?php echo base_url('Candidato_Global/getById'); ?>',
							method: 'POST',
							data: {'id':data.id},
							beforeSend: function() {
								$('.loader').css("display","block");
							},
							success: function(res){
								if(res != null){
									var dato = JSON.parse(res);
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#oig").val(dato.oig);
									$("#sanctions").val(dato.sanctions);
									$("#facis").val(dato.facis);
									$("#bureau").val(dato.bureau);
									$("#european_financial").val(dato.european_financial);
									$("#global_comentarios").val(dato.global_comentarios);
									$("#globalSearchModal").modal('show');
								}
								else{
									$('#formGlobal')[0].reset();
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#globalSearchModal").modal('show');
								}
							}
						});
					}
					if(data.id_seccion_global_search == 6){
						$("#oig").prop('readonly', false);
						$("#sam").prop('readonly', false);
						$("#ofac").prop('readonly', false);
						$("#interpol").prop('readonly', false);
						$.ajax({
							url: '<?php echo base_url('Candidato_Global/getById'); ?>',
							method: 'POST',
							data: {'id':data.id},
							beforeSend: function() {
								$('.loader').css("display","block");
							},
							success: function(res){
								if(res != null){
									var dato = JSON.parse(res);
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#oig").val(dato.oig);
									$("#sam").val(dato.sam);
									$("#ofac").val(dato.ofac);
									$("#interpol").val(dato.interpol);
									$("#global_comentarios").val(dato.global_comentarios);
									$("#globalSearchModal").modal('show');
								}
								else{
									$('#formGlobal')[0].reset();
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#globalSearchModal").modal('show');
								}
							}
						});
					}
					if(data.id_seccion_global_search == 7){
						$("#law_enforcement").prop('readonly', false);
						$("#regulatory").prop('readonly', false);
						$("#sanctions").prop('readonly', false);
						$("#other_bodies").prop('readonly', false);
						$("#media_searches").prop('readonly', false);
						$.ajax({
							url: '<?php echo base_url('Candidato_Global/getById'); ?>',
							method: 'POST',
							data: {'id':data.id},
							beforeSend: function() {
								$('.loader').css("display","block");
							},
							success: function(res){
								if(res != null){
									var dato = JSON.parse(res);
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#law_enforcement").val(dato.law_enforcement);
									$("#regulatory").val(dato.regulatory);
									$("#sanctions").val(dato.sanctions);
									$("#other_bodies").val(dato.other_bodies);
									$("#media_searches").val(dato.media_searches);
									$("#global_comentarios").val(dato.global_comentarios);
									$("#globalSearchModal").modal('show');
								}
								else{
									$('#formGlobal')[0].reset();
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#globalSearchModal").modal('show');
								}
							}
						});
					}
					if(data.id_seccion_global_search == 8){
						$("#usa_sanctions").prop('readonly', false);
						$("#sanctions").prop('readonly', false);
						$.ajax({
							url: '<?php echo base_url('Candidato_Global/getById'); ?>',
							method: 'POST',
							data: {'id':data.id},
							beforeSend: function() {
								$('.loader').css("display","block");
							},
							success: function(res){
								if(res != null){
									var dato = JSON.parse(res);
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#usa_sanctions").val(dato.usa_sanctions);
									$("#sanctions").val(dato.sanctions);
									$("#global_comentarios").val(dato.global_comentarios);
									$("#globalSearchModal").modal('show');
								}
								else{
									$('#formGlobal')[0].reset();
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#globalSearchModal").modal('show');
								}
							}
						});
					}
					if(data.id_seccion_global_search == 9){
						$("#ofac").prop('readonly', false);
						$("#sam").prop('readonly', false);
						$("#fda").prop('readonly', false);
						$.ajax({
							url: '<?php echo base_url('Candidato_Global/getById'); ?>',
							method: 'POST',
							data: {'id':data.id},
							beforeSend: function() {
								$('.loader').css("display","block");
							},
							success: function(res){
								if(res != null){
									var dato = JSON.parse(res);
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#ofac").val(dato.ofac);
									$("#sam").val(dato.sam);
									$("#fda").val(dato.fda);
									$("#global_comentarios").val(dato.global_comentarios);
									$("#globalSearchModal").modal('show');
								}
								else{
									$('#formGlobal')[0].reset();
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#globalSearchModal").modal('show');
								}
							}
						});
					}
					if(data.id_seccion_global_search == 21){
						$("#law_enforcement").prop('readonly', false);
						$("#regulatory").prop('readonly', false);
						$("#sanctions").prop('readonly', false);
						$("#other_bodies").prop('readonly', false);
						$("#media_searches").prop('readonly', false);
						$("#sdn").prop('readonly', false);
						$.ajax({
							url: '<?php echo base_url('Candidato_Global/getById'); ?>',
							method: 'POST',
							data: {'id':data.id},
							beforeSend: function() {
								$('.loader').css("display","block");
							},
							success: function(res){
								if(res != null){
									var dato = JSON.parse(res);
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#law_enforcement").val(dato.law_enforcement);
									$("#regulatory").val(dato.regulatory);
									$("#sanctions").val(dato.sanctions);
									$("#other_bodies").val(dato.other_bodies);
									$("#media_searches").val(dato.media_searches);
									$("#sdn").val(dato.sdn);
									$("#global_comentarios").val(dato.global_comentarios);
									$("#globalSearchModal").modal('show');
								}
								else{
									$('#formGlobal')[0].reset();
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#globalSearchModal").modal('show');
								}
							}
						});
					}
					if(data.id_seccion_global_search == 45){
						$("#law_enforcement").prop('readonly', false);
						$("#regulatory").prop('readonly', false);
						$("#sanctions").prop('readonly', false);
						$("#other_bodies").prop('readonly', false);
						$("#media_searches").prop('readonly', false);
						$("#oig").prop('readonly', false);
						$("#ofac").prop('readonly', false);
						$.ajax({
							url: '<?php echo base_url('Candidato_Global/getById'); ?>',
							method: 'POST',
							data: {'id':data.id},
							beforeSend: function() {
								$('.loader').css("display","block");
							},
							success: function(res){
								if(res != null){
									var dato = JSON.parse(res);
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#law_enforcement").val(dato.law_enforcement);
									$("#regulatory").val(dato.regulatory);
									$("#sanctions").val(dato.sanctions);
									$("#other_bodies").val(dato.other_bodies);
									$("#media_searches").val(dato.media_searches);
									$("#oig").val(dato.oig);
									$("#ofac").val(dato.ofac);
									$("#global_comentarios").val(dato.global_comentarios);
									$("#globalSearchModal").modal('show');
								}
								else{
									$('#formGlobal')[0].reset();
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#globalSearchModal").modal('show');
								}
							}
						});
					}
					if(data.id_seccion_global_search == 65){
						$("#ofac").prop('readonly', false);
						$("#sam").prop('readonly', false);
						$("#fda").prop('readonly', false);
						$("#oig").prop('readonly', false);
						$.ajax({
							url: '<?php echo base_url('Candidato_Global/getById'); ?>',
							method: 'POST',
							data: {'id':data.id},
							beforeSend: function() {
								$('.loader').css("display","block");
							},
							success: function(res){
								if(res != null){
									var dato = JSON.parse(res);
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#ofac").val(dato.ofac);
									$("#sam").val(dato.sam);
									$("#fda").val(dato.fda);
									$("#oig").val(dato.oig);
									$("#global_comentarios").val(dato.global_comentarios);
									$("#globalSearchModal").modal('show');
								}
								else{
									$('#formGlobal')[0].reset();
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#globalSearchModal").modal('show');
								}
							}
						});
					}
					if(data.id_seccion_global_search == 66){
						$("#law_enforcement").prop('readonly', false);
						$("#regulatory").prop('readonly', false);
						$("#ofac").prop('readonly', false);
						$("#sam").prop('readonly', false);
						$("#oig").prop('readonly', false);
						$.ajax({
							url: '<?php echo base_url('Candidato_Global/getById'); ?>',
							method: 'POST',
							data: {'id':data.id},
							beforeSend: function() {
								$('.loader').css("display","block");
							},
							success: function(res){
								if(res != null){
									var dato = JSON.parse(res);
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#law_enforcement").val(dato.law_enforcement);
									$("#regulatory").val(dato.regulatory);
									$("#ofac").val(dato.ofac);
									$("#sam").val(dato.sam);
									$("#oig").val(dato.oig);
									$("#global_comentarios").val(dato.global_comentarios);
									$("#globalSearchModal").modal('show');
								}
								else{
									$('#formGlobal')[0].reset();
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#globalSearchModal").modal('show');
								}
							}
						});
					}
					if(data.id_seccion_global_search == 67){
						$("#sanctions").prop('readonly', false);
						$("#media_searches").prop('readonly', false);
						$("#ofac").prop('readonly', false);
						$("#sam").prop('readonly', false);
						$("#fda").prop('readonly', false);
						$("#oig").prop('readonly', false);
						$.ajax({
							url: '<?php echo base_url('Candidato_Global/getById'); ?>',
							method: 'POST',
							data: {'id':data.id},
							beforeSend: function() {
								$('.loader').css("display","block");
							},
							success: function(res){
								if(res != null){
									var dato = JSON.parse(res);
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#sanctions").val(dato.sanctions);
									$("#media_searches").val(dato.media_searches);
									$("#ofac").val(dato.ofac);
									$("#sam").val(dato.sam);
									$("#fda").val(dato.fda);
									$("#oig").val(dato.oig);
									$("#global_comentarios").val(dato.global_comentarios);
									$("#globalSearchModal").modal('show');
								}
								else{
									$('#formGlobal')[0].reset();
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#globalSearchModal").modal('show');
								}
							}
						});
					}
          if(data.id_seccion_global_search == 86){
						$("#oig").prop('readonly', false);
						$("#sam").prop('readonly', false);
						$("#ofac").prop('readonly', false);
						$("#interpol").prop('readonly', false);
						$("#sanctions").prop('readonly', false);
						$("#media_searches").prop('readonly', false);
						$("#mvr").prop('readonly', false);
						$.ajax({
							url: '<?php echo base_url('Candidato_Global/getById'); ?>',
							method: 'POST',
							data: {'id':data.id},
							beforeSend: function() {
								$('.loader').css("display","block");
							},
							success: function(res){
								if(res != null){
									var dato = JSON.parse(res);
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#oig").val(dato.oig);
									$("#sam").val(dato.sam);
									$("#ofac").val(dato.ofac);
									$("#interpol").val(dato.interpol);
									$("#sanctions").val(dato.sanctions);
									$("#media_searches").val(dato.media_searches);
									$("#mvr").val(dato.motor_vehicle_records);
									$("#global_comentarios").val(dato.global_comentarios);
									$("#globalSearchModal").modal('show');
								}
								else{
									$('#formGlobal')[0].reset();
									setTimeout(function(){
										$('.loader').fadeOut();
									},200);
									$("#globalSearchModal").modal('show');
								}
							}
						});
					}
				});
				$('a#datos_verificacion_docs', row).bind('click', () => {
					$("#d_documentos")[0].reset();
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					var href = '<?php echo base_url()."_docs/"; ?>';
					//Habilitados.
					verificarDocumentacion(data.id, data.pais);
					$.ajax({
						url: '<?php echo base_url('Candidato/checkDocumentos'); ?>',
						method: 'POST',
						data: {'id_candidato':data.id},
						success: function(res){
							if(res != 0){
								$(".contenedor_documento").empty();
								var salida = res.split('@@');
								for(var i = 0; i < salida.length; i++){
									var aux = salida[i].split(',');
									if(aux[0] == 2){
										$("#doc_domicilio").append("<a href='"+href+aux[1]+"' target='_blank' style='color: black;'>"+aux[1]+"</a>");
									}
									if(aux[0] == 3){
										$("#doc_ine").append("<a href='"+href+aux[1]+"' target='_blank' style='color: black;'>"+aux[1]+"</a>");
									}
                  if(aux[0] == 6){
										$("#doc_nss").append("<a href='"+href+aux[1]+"' target='_blank' style='color: black;'>"+aux[1]+"</a><br><br>");
									}
									if(aux[0] == 7 || aux[0] == 10){
										$("#doc_estudios").append("<a href='"+href+aux[1]+"' target='_blank' style='color: black;'>"+aux[1]+"</a><br><br>");
									}
									if(aux[0] == 12){
										$("#doc_penales").append("<a href='"+href+aux[1]+"' target='_blank' style='color: black;'>"+aux[1]+"</a>");
									}
									if(aux[0] == 14){
										$("#doc_pasaporte").append("<a href='"+href+aux[1]+"' target='_blank' style='color: black;'>"+aux[1]+"</a><br><br>");
									}
									if(aux[0] == 15){
										$("#doc_militar").append("<a href='"+href+aux[1]+"' target='_blank' style='color: black;'>"+aux[1]+"</a>");
									}
									if(aux[0] == 20){
										$("#doc_migratorio").append("<a href='"+href+aux[1]+"' target='_blank' style='color: black;'>"+aux[1]+"</a><br><br>");
									}
									if(aux[0] == 37){
										$("#doc_licencia").append("<a href='"+href+aux[1]+"' target='_blank' style='color: black;'>"+aux[1]+"</a><br><br>");
									}
                  if(aux[0] == 44){
										$("#doc_mvr").append("<a href='"+href+aux[1]+"' target='_blank' style='color: black;'>"+aux[1]+"</a><br><br>");
									}
								}
							}
						}
					});
					$.ajax({
						url: '<?php echo base_url('Cliente_ESOLUTIONS/getVerificacionDocumentos'); ?>',
						method: 'POST',
						data: {'id_candidato':data.id},
						beforeSend: function(){
							$('.loader').css("display","block");
						},
						success: function(res){
							setTimeout(function(){
								if(res != 0){
									var data = res.split('@@');
									$("#lic_profesional").val(data[0]);
									$("#lic_institucion").val(data[1]);
									$("#ine_clave").val(data[2]);
									$("#ine_registro").val(data[3]);
									$("#ine_vertical").val(data[4]);
									$("#ine_institucion").val(data[5]);
									$("#penales_numero").val(data[6]);
									$("#penales_institucion").val(data[7]);
									$("#domicilio_numero").val(data[8]);
									$("#domicilio_fecha").val(data[9]);
									$("#militar_numero").val(data[10]);
									$("#militar_fecha").val(data[11]);
									$("#pasaporte_numero").val(data[12]);
									$("#pasaporte_institucion").val(data[13]);
									$("#migratorio_numero").val(data[14]);
									$("#migratorio_fecha").val(data[15]);
                  $("#nss_numero").val(data[16]);
									$("#nss_fecha").val(data[17]);
									$("#mvr_estatus").val(data[19]);
									$("#doc_comentarios").val(data[18]);
								}
								$('.loader').fadeOut();
							},200);
						}
					});
					$("#documentosModal").modal('show');
				});
				$('a#datos_laborales', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$("#Candidato").val(data.candidato);
					$('.es_reflab').val('');
					$('.es_verlab').val('');
					$('.aplicar_todo').val(-1);
					$('.caracteristica').val('Not provided');
					$.ajax({
            url: '<?php echo base_url('Candidato/getById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != 0){
								var dato = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#trabajo_inactivo").val(dato.trabajo_inactivo);
							}
							else{
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#trabajo_inactivo").val('');
							}
            }
          });
					$.ajax({
						async: false,
						url: '<?php echo base_url('Cliente_ESOLUTIONS/getReferenciasLaborales'); ?>',
						method: 'POST',
						data: {
							'id_candidato': data.id
						},
						beforeSend: function() {
							$('.loader').css("display","block");
						},
						success: function(res) {
							setTimeout(function() {
								$('.loader').fadeOut();
							}, 200);
							var rows = res.split('###');
							for (var i = 0; i < rows.length; i++) {
								if (rows[i] != "") {
									var dato = rows[i].split('@@');
									var entrada = (dato[2] != '0000-00-00 00:00:00')? convertirDateTime(dato[2]):'';
									var salida = (dato[3] != '0000-00-00 00:00:00')? convertirDateTime(dato[3]):'';
									$("#reflab" + (i + 1) + "_empresa_ingles").val(dato[0]);
									$("#reflab" + (i + 1) + "_direccion_ingles").val(dato[1]);
									$("#reflab" + (i + 1) + "_entrada_ingles").val(entrada);
									$("#reflab" + (i + 1) + "_salida_ingles").val(salida);
									$("#reflab" + (i + 1) + "_telefono_ingles").val(dato[4]);
									$("#reflab" + (i + 1) + "_puesto1_ingles").val(dato[5]);
									$("#reflab" + (i + 1) + "_puesto2_ingles").val(dato[6]);
									$("#reflab" + (i + 1) + "_salario1_ingles").val(dato[7]);
									$("#reflab" + (i + 1) + "_salario2_ingles").val(dato[8]);
									$("#reflab" + (i + 1) + "_jefenombre_ingles").val(dato[9]);
									$("#reflab" + (i + 1) + "_jefecorreo_ingles").val(dato[10]);
									$("#reflab" + (i + 1) + "_jefepuesto_ingles").val(dato[11]);
									$("#reflab" + (i + 1) + "_separacion_ingles").val(dato[12]);
									$("#idreflabingles" + (i + 1)).val(dato[13]);
								}
							}
						}
					});
					$.ajax({
						async: false,
						url: '<?php echo base_url('Cliente_ESOLUTIONS/getVerificacionesLaborales'); ?>',
						method: 'POST',
						data: {
							'id_candidato': data.id
						},
						success: function(res) {
							if (res != "") {
								var rows = res.split('###');
								for (var i = 0; i < rows.length; i++) {
									if (rows[i] != "") {
										var dato = rows[i].split('@@');
										var entrada = convertirDateTime(dato[2]);
										var salida = convertirDateTime(dato[3]);
										$("#an_reflab" + dato[28] + "_empresa").val(dato[0]);
										$("#an_reflab" + dato[28] + "_direccion").val(dato[1]);
										$("#an_reflab" + dato[28] + "_entrada").val(entrada);
										$("#an_reflab" + dato[28] + "_salida").val(salida);
										$("#an_reflab" + dato[28] + "_telefono").val(dato[4]);
										$("#an_reflab" + dato[28] + "_puesto1").val(dato[5]);
										$("#an_reflab" + dato[28] + "_puesto2").val(dato[6]);
										$("#an_reflab" + dato[28] + "_salario1").val(dato[7]);
										$("#an_reflab" + dato[28] + "_salario2").val(dato[8]);
										$("#an_reflab" + dato[28] + "_jefenombre").val(dato[9]);
										$("#an_reflab" + dato[28] + "_jefecorreo").val(dato[10]);
										$("#an_reflab" + dato[28] + "_jefepuesto").val(dato[11]);
										$("#an_reflab" + dato[28] + "_separacion").val(dato[12]);
										$("#an_reflab" + dato[28] + "_notas").val(dato[13]);
										$("#an_reflab" + dato[28] + "_responsabilidad").val(dato[14]);
										$("#an_reflab" + dato[28] + "_iniciativa").val(dato[15]);
										$("#an_reflab" + dato[28] + "_eficiencia").val(dato[16]);
										$("#an_reflab" + dato[28] + "_disciplina").val(dato[17]);
										$("#an_reflab" + dato[28] + "_puntualidad").val(dato[18]);
										$("#an_reflab" + dato[28] + "_limpieza").val(dato[19]);
										$("#an_reflab" + dato[28] + "_estabilidad").val(dato[20]);
										$("#an_reflab" + dato[28] + "_emocional").val(dato[21]);
										$("#an_reflab" + dato[28] + "_honesto").val(dato[22]);
										$("#an_reflab" + dato[28] + "_rendimiento").val(dato[23]);
										$("#an_reflab" + dato[28] + "_actitud").val(dato[24]);
										$("#an_reflab" + dato[28] + "_recontratacion").val(dato[25]);
										$("#an_reflab" + dato[28] + "_motivo").val(dato[26]);
										$("#idverlab" + dato[28]).val(dato[27]);
									}
								}
							}

						}
					});
					$("#listado").css('display', 'none');
					$("#btn_nuevo").css('display', 'none');
					$(".btnRegresar").css('display', 'block');
					$("#formulario").css('display', 'block');
					$("#btn_regresar").css('display', 'block');
				});
				$('a#datos_domicilios_a', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					for(var i = 0; i <= 10; i++){
						$(".address_obligado"+i).val('');
					}
					$.ajax({
						url: '<?php echo base_url('Cliente_ESOLUTIONS/getHistorialDomicilios'); ?>',
						type: 'post',
						data: {'id_candidato':data.id},
						beforeSend: function(){
								$('.loader').css("display","block");
						},
						success : function(res){ 
							if(res != 0){
								setTimeout(function(){
									var data = res.split('###');
									for(var i = 0; i < data.length; i++){
										if(data[i] != ''){
											var num = i + 1;
											var d = data[i].split('@@');
											$("#address_periodo"+num).val(d[0]);
											$("#address_causa"+num).val(d[1]);
											$("#address_calle"+num).val(d[2]);
											$("#address_exterior"+num).val(d[3]);
											$("#address_interior"+num).val(d[4]);
											$("#address_colonia"+num).val(d[5]);
											$("#address_cp"+num).val(d[8]);
											$("#address_estado"+num).val(d[6]);
											$("#idAddress"+num).val(d[9]);
											var num = i + 1;
											getMunicipioDomicilio(d[6], d[7], num, 'general');
										}
									}
									$('.loader').fadeOut();
								},200);
							}
							else{
								setTimeout(function() {
									$('.loader').fadeOut();
								}, 200);
							}
						}
					});
					$.ajax({
						url: '<?php echo base_url('Cliente_ESOLUTIONS/getVerificacionHistorialDomicilios'); ?>',
						type: 'post',
						data: {'id_candidato':data.id},
						success : function(res)
						{ 
							$('#address_comentarios').val(res);
						}
					});
					$("#AddressModal").modal('show');
				});
				$('a#datos_domicilios_b', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					for(var i = 0; i <= 10; i++){
						$(".address_obligado"+i).val('');
					}
					$.ajax({
						url: '<?php echo base_url('Cliente_ESOLUTIONS/getHistorialDomicilios'); ?>',
						type: 'post',
						data: {'id_candidato':data.id},
						beforeSend: function(){
							$('.loader').css("display","block");
						},
						success : function(res){ 
							setTimeout(function(){
								var data = res.split('###');
								for(var i = 0; i < data.length; i++){
									if(data[i] != ''){
										var num = i + 1;
										var d = data[i].split('@@');
										$("#address_periodo_internacional"+num).val(d[0]);
										$("#address_causa_internacional"+num).val(d[1]);
										$("#address_domicilio_internacional"+num).val(d[10]);
										$("#address_pais_internacional"+num).val(d[11]);
										$("#idAddressInternacional"+num).val(d[9]);
										var num = i + 1;
									}
								}
								$('.loader').fadeOut();
							},200);
						}
					});
					$.ajax({
						url: '<?php echo base_url('Cliente_ESOLUTIONS/getVerificacionHistorialDomicilios'); ?>',
						type: 'post',
						data: {'id_candidato':data.id},
						success : function(res)
						{ 
							$('#address_comentarios_internacional').val(res);
						}
					});
					$("#AddressInternacionalModal").modal('show');
				});
				$('a#custom_address_check', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					for(var i = 0; i <= 10; i++){
						$(".custom_address_obligado"+i).val('');
					}
					$.ajax({
						url: '<?php echo base_url('Cliente_ESOLUTIONS/getHistorialDomicilios'); ?>',
						type: 'post',
						data: {'id_candidato':data.id},
						beforeSend: function(){
							$('.loader').css("display","block");
						},
						success : function(res){ 
							setTimeout(function(){
								var data = res.split('###');
								for(var i = 0; i < data.length; i++){
									if(data[i] != ''){
										var num = i + 1;
										var d = data[i].split('@@');
										$("#custom_periodo"+num).val(d[0]);
										$("#custom_causa"+num).val(d[1]);
										$("#custom_calle"+num).val(d[2]);
										$("#custom_exterior"+num).val(d[3]);
										$("#custom_interior"+num).val(d[4]);
										$("#custom_colonia"+num).val(d[5]);
										$("#custom_cp"+num).val(d[8]);
										$("#custom_estado"+num).val(d[6]);
										$("#idDomicilio"+num).val(d[9]);
										var num = i + 1;
										getMunicipioDomicilio(d[6], d[7], num, 'custom');
									}
								}
								$('.loader').fadeOut();
							},200);
						}
					});
					$.ajax({
						url: '<?php echo base_url('Cliente_ESOLUTIONS/getVerificacionHistorialDomicilios'); ?>',
						type: 'post',
						data: {'id_candidato':data.id},
						success : function(res)
						{ 
							$('#custom_address_comentarios').val(res);
						}
					});
					$("#customAddressModal").modal('show');
				});
				$("a#datos_gaps", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$.ajax({
						url: '<?php echo base_url('Candidato/checkGaps'); ?>',
						method: 'POST',
						data: {'id_candidato':data.id},
						beforeSend: function() {
							$('.loader').css("display", "block");
						},
						success: function(res)
						{
							setTimeout(function() {
								$('.loader').fadeOut();
							}, 200);
							if(res != ''){
								$("#contenedor_gaps").empty();
								$("#contenedor_gaps").html(res);
							}
							else{
								$("#contenedor_gaps").empty();
								$("#contenedor_gaps").html('<div class="col-12"><p class="text-center">Sin registros</p></div>');
								$("#gapsModal").modal('show');
							}
							$("#gapsModal").modal('show');
						}
					});
				});
				$('a#datos_ref_profesionales', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					var cantidad = data.cantidad_ref_profesionales;
					$.ajax({
						url: '<?php echo base_url('Cliente_ESOLUTIONS/getReferenciasProfesionales'); ?>',
						type: 'post',
						data: {'id_candidato':data.id},
						beforeSend: function(){
							$('.loader').css("display","block");
						},
						success : function(res){ 
							if(res != 0){
								setTimeout(function(){
									var data = res.split('###');
									var salida = '';
									for(var i = 0; i < cantidad; i++){
										var num = i + 1;
										if(data[i] !== '' && data[i] !== undefined){
											var d = data[i].split('@@');

											salida += '<form id="d_refprofesional'+num+'"><div class="alert alert-info"><p class="text-center">Referencia #'+num+' </p></div>';
											salida += '<div class="row"><div class="col-md-12"><label>Nombre *</label><input type="text" class="form-control" name="refpro'+num+'_nombre" id="refpro'+num+'_nombre" value="'+d[1]+'"><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>Teléfono *</label><input type="text" class="form-control" name="refpro'+num+'_telefono" id="refpro'+num+'_telefono" maxlength="16" value="'+d[2]+'"><br></div><div class="col-md-6"><label>Tiempo de conocerlo(a) *</label><input type="text" class="form-control" name="refpro'+num+'_tiempo" id="refpro'+num+'_tiempo" value="'+d[3]+'"><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>Dónde lo(a) conoció *</label><input type="text" class="form-control" name="refpro'+num+'_conocido" id="refpro'+num+'_conocido" value="'+d[4]+'"><br></div><div class="col-md-6"><label>Qué puesto desempeñaba *</label> <input type="text" class="form-control" name="refpro'+num+'_puesto" id="refpro'+num+'_puesto" value="'+d[5]+'"><br></div></div>';
											salida += '<div class="alert alert-warning"><p class="text-center">Los siguientes campos deben ser completados por parte de la analista para verificar la referencia profesional </p></div><div class="row"><div class="col-md-6"><label>Tiempo de conocer al candidato *</label><input type="text" class="form-control" name="refpro'+num+'_tiempo2" id="refpro'+num+'_tiempo2" value="'+d[6]+'"><br></div><div class="col-md-6"><label>Dónde conoció al candidato *</label><input type="text" class="form-control" name="refpro'+num+'_conocido2" id="refpro'+num+'_conocido2" value="'+d[7]+'"><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>Qué puesto desempeñaba *</label><input type="text" class="form-control" name="refpro'+num+'_puesto2" id="refpro'+num+'_puesto2" value="'+d[8]+'"><br></div><div class="col-md-6"><label>Cualidades del candidato *</label><input type="text" class="form-control" name="refpro'+num+'_cualidades" id="refpro'+num+'_cualidades" value="'+d[9]+'"><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>¿Cómo fue el desempeño del candidato? *</label><select name="refpro'+num+'_desempeno" id="refpro'+num+'_desempeno" class="form-control"><option value="">Selecciona</option><option value="Not provided">Not provided</option><option value="Excellent">Excellent</option><option value="Good">Good</option><option value="Regular">Regular</option><option value="Bad">Bad</option><option value="Very Bad">Very Bad</option></select><br></div><div class="col-md-6"><label>¿Recomienda al candidato? *</label><select name="refpro'+num+'_recomienda" id="refpro'+num+'_recomienda" class="form-control"><option value="">Selecciona</option><option value="No">No</option><option value="Yes">Yes</option><option value="N/A">N/A</option></select><br></div></div>';
											salida += '<div class="row"><div class="col-md-12"><label>Comentarios de la referencia *</label><textarea class="form-control" name="refpro'+num+'_comentario" id="refpro'+num+'_comentario" rows="3">'+d[12]+'</textarea><br></div></div><div id="refpro_msj_error'+num+'" class="alert alert-danger hidden"></div><div class="row"><div class="col-md-3 offset-5"><button type="button" class="btn btn-success" onclick="guardarReferenciaProfesional('+num+')">Guardar</button><input type="hidden" id="id_refpro'+num+'" value="'+d[0]+'"><br><br></div></div><br></form>';

											salida += '<script>$("#refpro'+num+'_desempeno").val("'+d[10]+'");$("#refpro'+num+'_recomienda").val("'+d[11]+'");<\/script>';

											$('#contenedor_ref_profesionales').html(salida);
										}
										else{
											salida += '<form id="d_refprofesional'+num+'"><div class="alert alert-info"><p class="text-center">Referencia #'+num+' </p></div>';
											salida += '<div class="row"><div class="col-md-12"><label>Nombre *</label><input type="text" class="form-control" name="refpro'+num+'_nombre" id="refpro'+num+'_nombre"><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>Teléfono *</label><input type="text" class="form-control" name="refpro'+num+'_telefono" id="refpro'+num+'_telefono" maxlength="16"><br></div><div class="col-md-6"><label>Tiempo de conocerlo(a) *</label><input type="text" class="form-control" name="refpro'+num+'_tiempo" id="refpro'+num+'_tiempo"><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>Dónde lo(a) conoció *</label><input type="text" class="form-control" name="refpro'+num+'_conocido" id="refpro'+num+'_conocido"><br></div><div class="col-md-6"><label>Qué puesto desempeñaba *</label> <input type="text" class="form-control" name="refpro'+num+'_puesto" id="refpro'+num+'_puesto"><br></div></div>';
											salida += '<div class="alert alert-warning"><p class="text-center">Los siguientes campos deben ser completados por parte de la analista para verificar la referencia profesional </p></div><div class="row"><div class="col-md-6"><label>Tiempo de conocer al candidato *</label><input type="text" class="form-control" name="refpro'+num+'_tiempo2" id="refpro'+num+'_tiempo2"><br></div><div class="col-md-6"><label>Dónde conoció al candidato *</label><input type="text" class="form-control" name="refpro'+num+'_conocido2" id="refpro'+num+'_conocido2"><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>Qué puesto desempeñaba *</label><input type="text" class="form-control" name="refpro'+num+'_puesto2" id="refpro'+num+'_puesto2"><br></div><div class="col-md-6"><label>Cualidades del candidato *</label><input type="text" class="form-control" name="refpro'+num+'_cualidades" id="refpro'+num+'_cualidades"><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>¿Cómo fue el desempeño del candidato? *</label><select name="refpro'+num+'_desempeno" id="refpro'+num+'_desempeno" class="form-control"><option value="">Selecciona</option><option value="Not provided">Not provided</option><option value="Excellent">Excellent</option><option value="Good">Good</option><option value="Regular">Regular</option><option value="Bad">Bad</option><option value="Very Bad">Very Bad</option></select><br></div><div class="col-md-6"><label>¿Recomienda al candidato? *</label><select name="refpro'+num+'_recomienda" id="refpro'+num+'_recomienda" class="form-control"><option value="">Selecciona</option><option value="No">No</option><option value="Yes">Yes</option><option value="N/A">N/A</option></select><br></div></div>';
											salida += '<div class="row"><div class="col-md-12"><label>Comentarios de la referencia *</label><textarea class="form-control" name="refpro'+num+'_comentario" id="refpro'+num+'_comentario" rows="3"></textarea><br></div></div><div id="refpro_msj_error'+num+'" class="alert alert-danger hidden"></div><div class="row"><div class="col-md-3 offset-5"><button type="button" class="btn btn-success" onclick="guardarReferenciaProfesional('+num+')">Guardar</button><input type="hidden" id="id_refpro'+num+'"><br><br></div></div><br></form>';

											$('#contenedor_ref_profesionales').html(salida);
										}
									}
									$('.loader').fadeOut();
								},200);
							}
							else{
								setTimeout(function(){
									var salida = '';
									for(var i = 0; i < cantidad; i++){
										var num = i + 1;

										salida += '<form id="d_refprofesional'+num+'"><div class="alert alert-info"><p class="text-center">Referencia #'+num+' </p></div>';
										salida += '<div class="row"><div class="col-md-12"><label>Nombre *</label><input type="text" class="form-control" name="refpro'+num+'_nombre" id="refpro'+num+'_nombre"><br></div></div>';
										salida += '<div class="row"><div class="col-md-6"><label>Teléfono *</label><input type="text" class="form-control" name="refpro'+num+'_telefono" id="refpro'+num+'_telefono" maxlength="16"><br></div><div class="col-md-6"><label>Tiempo de conocerlo(a) *</label><input type="text" class="form-control" name="refpro'+num+'_tiempo" id="refpro'+num+'_tiempo"><br></div></div>';
										salida += '<div class="row"><div class="col-md-6"><label>Dónde lo(a) conoció *</label><input type="text" class="form-control" name="refpro'+num+'_conocido" id="refpro'+num+'_conocido"><br></div><div class="col-md-6"><label>Qué puesto desempeñaba *</label> <input type="text" class="form-control" name="refpro'+num+'_puesto" id="refpro'+num+'_puesto"><br></div></div>';
										salida += '<div class="alert alert-warning"><p class="text-center">Los siguientes campos deben ser completados por parte de la analista para verificar la referencia profesional </p></div><div class="row"><div class="col-md-6"><label>Tiempo de conocer al candidato *</label><input type="text" class="form-control" name="refpro'+num+'_tiempo2" id="refpro'+num+'_tiempo2"><br></div><div class="col-md-6"><label>Dónde conoció al candidato *</label><input type="text" class="form-control" name="refpro'+num+'_conocido2" id="refpro'+num+'_conocido2"><br></div></div>';
										salida += '<div class="row"><div class="col-md-6"><label>Qué puesto desempeñaba *</label><input type="text" class="form-control" name="refpro'+num+'_puesto2" id="refpro'+num+'_puesto2"><br></div><div class="col-md-6"><label>Cualidades del candidato *</label><input type="text" class="form-control" name="refpro'+num+'_cualidades" id="refpro'+num+'_cualidades"><br></div></div>';
										salida += '<div class="row"><div class="col-md-6"><label>¿Cómo fue el desempeño del candidato? *</label><select name="refpro'+num+'_desempeno" id="refpro'+num+'_desempeno" class="form-control"><option value="">Selecciona</option><option value="Not provided">Not provided</option><option value="Excellent">Excellent</option><option value="Good">Good</option><option value="Regular">Regular</option><option value="Bad">Bad</option><option value="Very Bad">Very Bad</option></select><br></div><div class="col-md-6"><label>¿Recomienda al candidato? *</label><select name="refpro'+num+'_recomienda" id="refpro'+num+'_recomienda" class="form-control"><option value="">Selecciona</option><option value="No">No</option><option value="Yes">Yes</option><option value="N/A">N/A</option></select><br></div></div>';
										salida += '<div class="row"><div class="col-md-12"><label>Comentarios de la referencia *</label><textarea class="form-control" name="refpro'+num+'_comentario" id="refpro'+num+'_comentario" rows="3"></textarea><br></div></div><div id="refpro_msj_error'+num+'" class="alert alert-danger hidden"></div><div class="row"><div class="col-md-3 offset-5"><button type="button" class="btn btn-success" onclick="guardarReferenciaProfesional('+num+')">Guardar</button><input type="hidden" id="id_refpro'+num+'"><br><br></div></div><br></form>';

										$('#contenedor_ref_profesionales').html(salida);
									}
									$('.loader').fadeOut();
								},200);
							}
						}
					});
					$("#refProfesionalesModal").modal('show');
				});
				$('a#datos_ref_personales', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					var cantidad = data.cantidad_ref_personales;
					$.ajax({
						url: '<?php echo base_url('Cliente_ESOLUTIONS/getReferenciasPersonales'); ?>',
						type: 'post',
						data: {'id_candidato':data.id},
						beforeSend: function(){
							$('.loader').css("display","block");
						},
						success : function(res){
							var salida = '';
							if(res != 0){
								setTimeout(function(){
									var data = res.split('###');
									for(var i = 0; i < cantidad; i++){
										var num = i + 1;
										if(data[i] !== '' && data[i] !== undefined){
											var d = data[i].split('@@');

											salida += '<form id="d_refpersonal'+num+'"><div class="alert alert-info"><p class="text-center">Referencia #'+num+' </p></div>';
											salida += '<div class="row"><div class="col-md-12"><label>Nombre *</label><input type="text" class="form-control" name="refper'+num+'_nombre" id="refper'+num+'_nombre" value="'+d[0]+'"><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>Tiempo de conocerlo(a) *</label><input type="text" class="form-control" name="refper'+num+'_tiempo" id="refper'+num+'_tiempo" value="'+d[2]+'"><br></div><div class="col-md-6"><label>Lugar donde lo(a) conoció *</label><input type="text" class="form-control" name="refper'+num+'_lugar" id="refper'+num+'_lugar" value="'+d[3]+'"><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>Teléfono *</label><input type="text" class="form-control" name="refper'+num+'_telefono" id="refper'+num+'_telefono" value="'+d[1]+'" maxlength="16"><br></div><div class="col-md-6"><label>¿Sabe dónde trabaja? *</label><select name="refper'+num+'_trabaja" id="refper'+num+'_trabaja" class="form-control"><option value="">Selecciona</option><option value="1">Sí</option><option value="0">No</option><option value="2">N/A</option></select><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>¿Sabe dónde vive? *</label><select name="refper'+num+'_vive" id="refper'+num+'_vive" class="form-control"><option value="">Selecciona</option><option value="1">Sí</option><option value="0">No</option><option value="2">N/A</option></select><br></div></div>';
											salida += '<div class="row"><div class="col-12"><label>Comentarios de la referencia *</label><textarea class="form-control" name="refper'+num+'_comentario" id="refper'+num+'_comentario" rows="3">'+d[7]+'</textarea><br></div></div><br></form>';

											salida += '<script>$("#refper'+num+'_trabaja").val("'+d[4]+'");$("#refper'+num+'_vive").val("'+d[5]+'");<\/script>';

											$('#contenedor_ref_personales').html(salida);
										}
										else{
											salida += '<form id="d_refpersonal'+num+'"><div class="alert alert-info"><p class="text-center">Referencia #'+num+' </p></div>';
											salida += '<div class="row"><div class="col-md-12"><label>Nombre *</label><input type="text" class="form-control" name="refper'+num+'_nombre" id="refper'+num+'_nombre"><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>Tiempo de conocerlo(a) *</label><input type="text" class="form-control" name="refper'+num+'_tiempo" id="refper'+num+'_tiempo"><br></div><div class="col-md-6"><label>Lugar donde lo(a) conoció *</label><input type="text" class="form-control" name="refper'+num+'_lugar" id="refper'+num+'_lugar"><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>Teléfono *</label><input type="text" class="form-control" name="refper'+num+'_telefono" id="refper'+num+'_telefono" maxlength="16"><br></div><div class="col-md-6"><label>¿Sabe dónde trabaja? *</label><select name="refper'+num+'_trabaja" id="refper'+num+'_trabaja" class="form-control"><option value="">Selecciona</option><option value="1">Sí</option><option value="0">No</option><option value="2">N/A</option></select><br></div></div>';
											salida += '<div class="row"><div class="col-md-6"><label>¿Sabe dónde vive? *</label><select name="refper'+num+'_vive" id="refper'+num+'_vive" class="form-control"><option value="">Selecciona</option><option value="1">Sí</option><option value="0">No</option><option value="2">N/A</option></select><br></div></div>';
											salida += '<div class="row"><div class="col-12"><label>Comentarios de la referencia *</label><textarea class="form-control" name="refper'+num+'_comentario" id="refper'+num+'_comentario" rows="3"></textarea><br></div></div><br></form>';

											$('#contenedor_ref_personales').html(salida);
										}
									}
									$('.loader').fadeOut();
								},200);
							}
							else{
								setTimeout(function(){
									var salida = '';
									for(var i = 0; i < cantidad; i++){
										var num = i + 1;

										salida += '<form id="d_refpersonal'+num+'"><div class="alert alert-info"><p class="text-center">Referencia #'+num+' </p></div>';
										salida += '<div class="row"><div class="col-md-12"><label>Nombre *</label><input type="text" class="form-control" name="refper'+num+'_nombre" id="refper'+num+'_nombre"><br></div></div>';
										salida += '<div class="row"><div class="col-md-6"><label>Tiempo de conocerlo(a) *</label><input type="text" class="form-control" name="refper'+num+'_tiempo" id="refper'+num+'_tiempo"><br></div><div class="col-md-6"><label>Lugar donde lo(a) conoció *</label><input type="text" class="form-control" name="refper'+num+'_lugar" id="refper'+num+'_lugar"><br></div></div>';
										salida += '<div class="row"><div class="col-md-6"><label>Teléfono *</label><input type="text" class="form-control" name="refper'+num+'_telefono" id="refper'+num+'_telefono" maxlength="16"><br></div><div class="col-md-6"><label>¿Sabe dónde trabaja? *</label><select name="refper'+num+'_trabaja" id="refper'+num+'_trabaja" class="form-control"><option value="">Selecciona</option><option value="1">Sí</option><option value="0">No</option><option value="2">N/A</option></select><br></div></div>';
										salida += '<div class="row"><div class="col-md-6"><label>¿Sabe dónde vive? *</label><select name="refper'+num+'_vive" id="refper'+num+'_vive" class="form-control"><option value="">Selecciona</option><option value="1">Sí</option><option value="0">No</option><option value="2">N/A</option></select><br></div></div>';
										salida += '<div class="row"><div class="col-12"><label>Comentarios de la referencia *</label><textarea class="form-control" name="refper'+num+'_comentario" id="refper'+num+'_comentario" rows="3"></textarea><br></div></div><br></form>';

										$('#contenedor_ref_personales').html(salida);
									}
									$('.loader').fadeOut();
								},200);
							}
							$('#boton_ref_personales').html('<div class="row"><div class="col-4 offset-4"><button type="button" class="btn btn-success" onclick="guardarRefPersonales('+cantidad+')">Guardar Referencias Personales</button></div></div>');
						}
					});
					$("#refPersonalesModal").modal('show');
				});
        $('a#datos_ref_academicas', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$("#idSeccion").val(data.id_ref_academica);
					$(".nombreCandidato").text(data.candidato);
          let valores = ''; let scripts = ''; let opciones = '';
          $.ajax({
            url: '<?php echo base_url('Candidato_Ref_Academica/getById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            async:false,
            success: function(res){
              if(res != 0){
                valores = JSON.parse(res);
              }
            }
          });
          $.ajax({
            url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
            method: 'POST',
            data: {'id_seccion':data.id_ref_academica,'tipo_orden':'orden_front'},
            async:false,
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
              setTimeout(function(){
                $('.loader').fadeOut();
              },200);
              if(res != 0){
                var dato = JSON.parse(res);
                for(var num = 1; num <= data.cantidad_ref_academicas; num++){
                  //* HTML
                  $('#rowRefAcademica').append('<div class="alert alert-warning btn-block text-center"><h5>Referencia #'+num+'</h5></div>');
                  for(let tag of dato){
                    if(tag['tipo_etiqueta'] == 'select'){
                      $('#rowRefAcademica').append(tag['grid_col_inicio']+tag['label']+tag['etiqueta_inicio']+opciones+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                    }
                    if(tag['tipo_etiqueta'] == 'input'){
                      $('#rowRefAcademica').append(tag['titulo_seccion_modal']+tag['grid_col_inicio']+tag['label']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                    }
                    if(tag['tipo_etiqueta'] == 'textarea'){
                      $('#rowRefAcademica').append(tag['grid_col_inicio']+tag['label']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                    }

                  }
                  //* Boton Guardar
                  $('#rowRefAcademica').append('<button type="button" class="btn btn-success btn-block mt-3 mb-5" onclick="guardarRefAcademica('+num+')">Guardar Referencia #'+num+'</button>');
                }
                //* Values
                for(let valor of valores){
                  var index = (valor['number'] - 1);
                  for(let tag of dato){
                    $('[name="'+tag['atr_id']+'[]"]').eq(index).val(valor[tag['referencia']]);
                  }
                }
              }
              else{
                $('#rowRefAcademica').html('<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>');
              }
              $("#refAcademicaModal").modal('show');
            }
          });
				});
				$('a#datos_checklist', row).bind('click', () =>{
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					var cadena = '';
					$.ajax({
						url: '<?php echo base_url('Candidato/getChecklistCandidato'); ?>',
						type: 'POST',
						data: {'id_candidato':data.id},
						beforeSend: function() {
							$('.loader').css("display", "block");
						},
						success: function(res) {
							setTimeout(function() {
								$('.loader').fadeOut();
							}, 200);
							if(res != 0){
								var dato = JSON.parse(res);
								var prohibited = (dato['prohibited_parties_list'] != '' && dato['prohibited_parties_list'] != null)? dato['prohibited_parties_list']:'N/A';
								$("#check_education").val(dato['education']);
								$("#check_employment").val(dato['employment']);
								$("#check_address").val(dato['address']);
								$("#check_criminal").val(dato['criminal']);
								$("#check_database").val(dato['global_database']);
								$("#check_identity").val(dato['identity']);
								//$("#check_military").val(dato['military']);
								$("#check_prohibited").val(prohibited);
								$("#check_other").val(dato['other']);
							}
							else{
								var lleva_estudios = (data.lleva_estudios == 1)? 'Highest education attained':'N/A';
								$("#check_education").val(lleva_estudios);
								var tiempo_empleos = (data.tiempo_empleos != null)? 'Last '+data.tiempo_empleos:'N/A';
								$("#check_employment").val(tiempo_empleos);
								var tiempo_domicilios = (data.tiempo_domicilios != null)? 'Last '+data.tiempo_domicilios:'N/A';
								$("#check_address").val(tiempo_domicilios);
								var tiempo_criminales = (data.tiempo_criminales != null)? 'Last '+data.tiempo_criminales:'N/A';
								$("#check_criminal").val(tiempo_criminales);
								var seccionGlobal = (data.id_seccion_global_search != null)? data.global_descripcion:'N/A';
								$("#check_database").val(seccionGlobal);
								if(data.custom_ine != null && data.custom_ine != ''){
									cadena += 'Voter ID';
									if(data.custom_pasaporte != null && data.custom_pasaporte != ''){
										cadena += '/ Passport';
									}
								}
								else{
									if(data.custom_pasaporte != null && data.custom_pasaporte != ''){
										cadena += 'Passport';
									}
									else{
										cadena += 'N/A';
									}
								}
								$("#check_identity").val(cadena);
								// var militar = (data.custom_militar != null && data.custom_militar != '')? data.custom_militar:'N/A';
								// $("#check_military").val(militar);
								var lleva_prohibited = (data.lleva_prohibited_parties_list == 1)? 'Required':'N/A';
								$("#check_prohibited").val(lleva_prohibited);
								var credito = (data.tiempo_credito != null && data.tiempo_credito != '')? 'Credit check for '+data.tiempo_credito:'N/A';
								$("#check_other").val(credito);
							}
						}
					});
					$("#scopeModal").modal('show');
				});
				$("a#subirDocs", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$(".prefijo").val(data.id + "_" + data.nombre + "" + data.paterno);
					$.ajax({
						url: '<?php echo base_url('Candidato/getDocumentos'); ?>',
						type: 'post',
						data: {
							'id_candidato': data.id,
              'tipo_usuario': 1,
							'prefijo': data.id + "_" + data.nombre + "" + data.paterno
						},
						success: function(res) {
							$("#tablaDocs").html(res);
						}
					});
					$("#docsModal").modal("show");
				});
				$("a#eliminar", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$("#quitarModal #titulo_accion").text("Cancelar proceso");
					$("#quitarModal #texto_confirmacion").html("¿Estás seguro de cancelar el proceso de <b>"+data.candidato+"</b>?");
			    $('#campos_mensaje').html('<div class="row"><div class="col-12"><label>Motivo de cancelación *</label><textarea class="form-control" rows="3" id="mensaje_comentario" name="mensaje_comentario"></textarea></div></div>');
					$("#quitarModal #btnGuardar").attr('value', 'delete');
					$("#quitarModal").modal("show");
				});
				$("a#estudios", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$("#estudios_nombrecandidato").text(data.nombre + " " + data.paterno + " " + data.materno);
					verificacionEstudios();
				});
				$("a#laborales", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$("#laborales_nombrecandidato").text(data.nombre + " " + data.paterno + " " + data.materno);
					verificacionLaborales();
				});
				$("a#penales", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$("#penales_nombrecandidato").text(data.nombre + " " + data.paterno + " " + data.materno);
					verificacionPenales();
				});
				$("a#datos_credito", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$.ajax({
						url: '<?php echo base_url('Cliente_ESOLUTIONS/checkCredito'); ?>',
						method: 'POST',
						data: {'id_candidato':data.id},
						success: function(res)
						{
							if(res != 0){
								$("#div_antescredit").empty();
								$("#div_antescredit").append(res);
								$("#creditoModal").modal('show');
							}
							else{
								$("#div_antescredit").empty();
								$("#div_antescredit").html('<div class="col-12"><p class="text-center">Sin registros</p></div>');
								$("#creditoModal").modal('show');
							}
						}
					});
				});
				$("a#examen_medico", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").html("Candidato <b>"+data.candidato+"</b>");
					$("#medicoModal").modal("show");
				});
				$("a#final", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					var listado = '';
          let tieneMilitar = getDocumentacion(data.id);
					//Se inician como deshabilitados todos los campos
					$('.estatus_finales').prop('disabled',true);
					$("#check_visita").val(3);

					//Datos generales
					var lista_generales = (data.id_seccion_datos_generales == 1 || data.id_seccion_datos_generales == 2)? '<li>Datos generales</li>':'';
					listado += lista_generales;
					
					//Verificacion de identidad o de documentos
					var identidad = (data.lleva_identidad == 1)? false:true;
					$("#check_identidad").prop('disabled',identidad);
					var lista_docs = (data.lleva_identidad == 1)? '<li>Verificación de identidad</li>':'';
					listado += lista_docs;
					var valor_identidad = (data.lleva_identidad == 1)? '':3;
					$("#check_identidad").val(valor_identidad);


					//Laborales
					var laboral = (data.lleva_empleos == 1)? false:true;
					$("#check_laboral").prop('disabled',laboral);
					var lista_laboral = (data.lleva_empleos == 1)? '<li>Referencias laborales</li>':'';
					listado += lista_laboral;
					var valor_empleos = (data.lleva_empleos == 1)? '':3;
					$("#check_laboral").val(valor_empleos);
					
					//Estudios
					var estudios = (data.lleva_estudios == 1)? false:true;
					$("#check_estudios").prop('disabled',estudios);
					var lista_estudios = (data.lleva_estudios == 1)? '<li>Mayores estudios</li>':'';
					listado += lista_estudios;
					var valor_estudios = (data.lleva_estudios == 1)? '':3;
					$("#check_estudios").val(valor_estudios);

					//Examen Medico
					$("#check_medico").prop('disabled',false);
					$("#check_medico").val('');

					//Globales
					var globales = (data.id_seccion_global_search != null)? false:true;
					$("#check_global").prop('disabled',globales);
					var lista_globales = (data.id_seccion_global_search != null)? '<li>Global searches</li>':'';
					listado += lista_globales;
					var valor_global = (data.id_seccion_global_search != null)? '':3;
					$("#check_global").val(valor_global);

					//Domicilios
					var domicilios = (data.lleva_domicilios == 1)? false:true;
					$("#check_domicilio").prop('disabled',domicilios);
					var lista_domicilios = (data.lleva_domicilios == 1)? '<li>Historial de domicilios</li>':'';
					listado += lista_domicilios;
					var valor_domicilios = (data.lleva_domicilios == 1)? '':3;
					$("#check_domicilio").val(valor_domicilios);

					//Referencias profesionales
					var lista_profesionales = (data.cantidad_ref_profesionales > 0)? '<li>Referencias profesionales</li>':'';
					listado += lista_profesionales;
					
					//Credito
					var credito = (data.lleva_credito == 1)? false:true;
					$("#check_credito").prop('disabled',credito);
					var lista_credito = (data.lleva_credito == 1)? '<li>Historial de credito</li>':'';
					listado += lista_credito;
					var valor_credito = (data.lleva_credito == 1)? '':3;
					$("#check_credito").val(valor_credito);

					//GAPS
					var lista_gaps = (data.lleva_gaps == 1)? '<li>GAPS o periodos inactivos</li>':'';
					listado += lista_gaps;

					//Verificacion de estudios
					var lista_ver_estudios = (data.lleva_estudios == 1)? '<li>Verificación de estudios</li>':'';
					listado += lista_ver_estudios;

					//Verificacion de laborales
					var lista_ver_laboral = (data.lleva_empleos == 1)? '<li>Verificación de referencias laborales</li>':'';
					listado += lista_ver_laboral;

					//Verificacion criminal
					var criminales = (data.lleva_criminal == 1)? false:true;
					$("#check_penales").prop('disabled',criminales);
					$("#check_ofac").prop('disabled',false);
					var lista_criminales = (data.lleva_criminal == 1)? '<li>Verificación de antecedentes no penales</li>':'';
					var valor_criminal = (data.lleva_criminal == 1)? '':3;
					$("#check_penales").val(valor_criminal);
					$("#check_ofac").val('');

          //Ref academicas
					var ref_academica = (data.cantidad_ref_academicas > 0)? false:true;
					$("#check_ref_academica").prop('disabled',ref_academica);
					var lista_docs = (data.cantidad_ref_academicas > 0)? '<li>Verificación de referencias académicas</li>':'';
					listado += lista_docs;
					var valor_ref_academica = (data.cantidad_ref_academicas > 0)? '':3;
					$("#check_ref_academica").val(valor_ref_academica);

          //Verificacion militar
					var militar = (tieneMilitar == 1)? false:true;
					$("#check_servicio_militar").prop('disabled',militar);
					var lista_militar = (tieneMilitar == 1)? '<li>Verificación servicio militar</li>':'';
					var valor_militar = (tieneMilitar == 1)? '':3;
					$("#check_servicio_militar").val(valor_militar);

          //* Documentos extra
          $("#check_professional_accreditation").val(3);
          $("#check_sex_offender").val(3)
          $("#check_nss").val(3)
          $("#check_ciudadania").val(3)
          $("#check_mvr").val(3);
          $.ajax({
            url: '<?php echo base_url('Candidato_Documentacion/getDocumentosExtraRequeridos'); ?>',
            method: 'POST',
            data: {'id':data.id},
            success: function(res){
							if(res != 0){
								var docs = JSON.parse(res);
                for(var i = 0; i < docs.length; i++){
                  if(docs[i]['id_tipo_documento'] == 6){
								    $("#check_nss").prop('disabled',false);
                    $("#check_nss").val('')
                  }
                  if(docs[i]['id_tipo_documento'] == 10){
								    $("#check_professional_accreditation").prop('disabled',false);
                    $("#check_professional_accreditation").val('')
                  }
                  if(docs[i]['id_tipo_documento'] == 14){
								    $("#check_ciudadania").prop('disabled',false);
                    $("#check_ciudadania").val('')
                  }
                  if(docs[i]['id_tipo_documento'] == 42){
								    $("#check_sex_offender").prop('disabled',false);
                    $("#check_sex_offender").val('')
                  }
                  if(docs[i]['id_tipo_documento'] == 44){
								    $("#check_mvr").prop('disabled',false);
                    $("#check_mvr").val('')
                  }
                }
							}
            }
          });
					//Scope o alcance de verificaciones
					listado += '<li>Alcance de verificaciones</li>'

					$('#listado_revision').html(listado);

					$("#revisionModal").modal('show');
				});
				$("a#conclusiones", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
          let tieneMilitar = getDocumentacion(data.id);

					//Se inician como deshabilitados todos los campos
					$('.estatus_finales').prop('disabled',true);

					//Verificacion de identidad o de documentos
					var identidad = (data.lleva_identidad == 1)? false:true;
					$("#check_identidad").prop('disabled',identidad);

					//Laborales
					var laboral = (data.lleva_empleos == 1)? false:true;
					$("#check_laboral").prop('disabled',laboral);
					
					//Estudios
					var estudios = (data.lleva_estudios == 1)? false:true;
					$("#check_estudios").prop('disabled',estudios);

					//Examen Medico
					$("#check_medico").prop('disabled',false);

					//Globales
					var globales = (data.id_seccion_global_search != null)? false:true;
					$("#check_global").prop('disabled',globales);

					//Domicilios
					var domicilios = (data.lleva_domicilios == 1)? false:true;
					$("#check_domicilio").prop('disabled',domicilios);
					
					//Credito
					var credito = (data.lleva_credito == 1)? false:true;
					$("#check_credito").prop('disabled',credito);

					//Verificacion criminal
					var criminales = (data.lleva_criminal == 1)? false:true;
					$("#check_penales").prop('disabled',criminales);
					$("#check_ofac").prop('disabled',false);

          //Ref academicas
					var ref_academica = (data.cantidad_ref_academicas > 0)? false:true;
					$("#check_ref_academica").prop('disabled',ref_academica);
					var valor_ref_academica = (data.cantidad_ref_academicas > 0)? '':3;

          //Verificacion militar
					var militar = (tieneMilitar == 1)? false:true;
					$("#check_servicio_militar").prop('disabled',militar);

          //* Documentos extra
          $.ajax({
            url: '<?php echo base_url('Candidato_Documentacion/getDocumentosExtraRequeridos'); ?>',
            method: 'POST',
            data: {'id':data.id},
            success: function(res){
							if(res != 0){
								var docs = JSON.parse(res);
                for(var i = 0; i < docs.length; i++){
                  if(docs[i]['id_tipo_documento'] == 6){
								    $("#check_nss").prop('disabled',false);
                  }
                  if(docs[i]['id_tipo_documento'] == 10){
								    $("#check_professional_accreditation").prop('disabled',false);
                  }
                  if(docs[i]['id_tipo_documento'] == 14){
								    $("#check_ciudadania").prop('disabled',false);
                  }
                  if(docs[i]['id_tipo_documento'] == 42){
								    $("#check_sex_offender").prop('disabled',false);
                  }
                  if(docs[i]['id_tipo_documento'] == 44){
								    $("#check_mvr").prop('disabled',false);
                  }
                }
							}
            }
          });

					$.ajax({
            url: '<?php echo base_url('Candidato_Conclusion/getBGCById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != null){
								var dato = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
                let nss = (dato.nss_check == -1)? 3 : dato.nss_check;
                let ciudadania = (dato.ciudadania_check == -1)? 3 : dato.ciudadania_check;
								$("#check_identidad").val(dato.identidad_check);
								$("#check_laboral").val(dato.empleo_check);
								$("#check_estudios").val(dato.estudios_check);
								$("#check_visita").val(dato.visita_check);
								$("#check_penales").val(dato.penales_check);
								$("#check_ofac").val(dato.ofac_check);
								$("#check_laboratorio").val(dato.laboratorio_check);
								$("#check_medico").val(dato.medico_check);
								$("#check_global").val(dato.global_searches_check);
								$("#check_domicilio").val(dato.domicilios_check);
								$("#check_credito").val(dato.credito_check);
								$("#check_professional_accreditation").val(dato.professional_accreditation_check);
								$("#check_sex_offender").val(dato.sex_offender_check);
								$("#check_ref_academica").val(dato.ref_academica_check);
								$("#check_nss").val(nss);
								$("#check_ciudadania").val(ciudadania);
								$("#check_mvr").val(dato.mvr_check);
                $("#check_servicio_militar").val(dato.militar_check);
								$("#comentario_final").val(dato.comentario_final);
								$("#bgc_status").val(data.status_bgc);
								$("#completarModal").modal('show');
							}
							else{
								$('#formMayoresEstudios')[0].reset();
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#completarModal").modal('show');
							}
            }
          });
				});
				$('a[id^=pdfFinal]', row).bind('click', () => {
					var id = data.id;
					$('#pdfForm'+id).submit();
				});
        $('a[id^=pdfDopingBGV]', row).bind('click', () => {
          var id = data.idDoping;
          $('#pdfDopingBGV' + id).submit();
          /*Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'If you have Internet, this file will download immediately ',
            showConfirmButton: false,
            timer: 4000
          })*/
        });
				$('a[id^=pdfDoping]', row).bind('click', () => {
						var id = data.idDoping;
						$('#pdf'+id).submit();
				});
				$('a[id^=pdfOfac]', row).bind('click', () => {
						var id = data.id;
						$('#ofacpdf'+id).submit();
				});
				$('a#comentario', row).bind('click', () => {
						$.ajax({
							url: '<?php echo base_url('Candidato/viewComentario'); ?>',
							type: 'post',
							data: {'id_candidato':data.id},
							success : function(res){ 
								if(res != 0){
									$("#titulo_accion").text("Comentario del candidato");
									$("#motivo").html(res);
									$("#verModal").modal('show');
								}
								else{
									$("#titulo_accion").text("Comentarios del candidato");
									$("#motivo").html("No hay registro de comentarios");
									$("#verModal").modal('show');
								}
							}
					});
				});
				$("a#editar_pruebas", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$("#d_pruebas")[0].reset();
					$.ajax({
						url: '<?php echo base_url('Candidato/getPruebasCandidato'); ?>',
						type: 'post',
						data: {
							'id_candidato': data.id
						},
						beforeSend: function() {
							$('.loader').css("display", "block");
						},
						success: function(res) {
							setTimeout(function() {
								$('.loader').fadeOut();
							}, 200);
							if(res != ''){
								var dato = JSON.parse(res);
								$('#prueba_antidoping').val(dato.antidoping);
								$('#prueba_psicometrica').val(dato.psicometrico);
								$('#prueba_medica').val(dato.medico);
								if(dato.status_doping == 1){
									$('#prueba_antidoping').prop('disabled',true);
								}
								if(dato.idMedico != null){
									$('#prueba_medica').prop('disabled',true);
								}
								if(dato.idPsicometrico != null){
									$('#prueba_psicometrica').prop('disabled',true);
								}
								if(dato.status_doping == 1 && dato.idMedico != null && dato.idPsicometrico != null){
									$('#btnActualizarPruebas').prop('disabled',true);
								}
							}
							$("#pruebasModal").modal('show');
						}
					});
				});
				$("a#fecha_real", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$.ajax({
						url: '<?php echo base_url('Candidato/getFechaInicio'); ?>',
						type: 'post',
						data: {
							'id_candidato': data.id
						},
						beforeSend: function() {
							$('.loader').css("display", "block");
						},
						success: function(res) {
							setTimeout(function() {
								$('.loader').fadeOut();
							}, 200);
							var fecha = (res != null)? res:'';
							$('#fecha_inicio_proceso').val(fecha);
							$("#fechaInicioModal").modal('show');
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
		$("#opcion_registro").change(function(){
			var opcion = $(this).val();
			$('.div_info_project').css('display','block');
			$('.div_project').css('display','flex');
			$('.div_info_test').css('display','block');
			$('.div_test').css('display','flex');
			$("#newModal #msj_error").css('display', 'none');
			if(opcion == 1){
				$('.div_check').css('display','none');
				$('.div_info_check').css('display','none');
				$('.div_info_extra').css('display','none');
				$('.div_extra').css('display','none');
			}
			if(opcion == 0){
				$('.div_previo').css('display','flex');
				$('.div_info_previo').css('display','block');
				$('.div_check').css('display','flex');
				$('.div_info_check').css('display','block');
				$('.div_info_extra').css('display','block');
				$('.div_extra').css('display','flex');
			}
			if(opcion == ''){
				$('.div_previo').css('display','none');
				$('.div_info_previo').css('display','none');
				$('.div_check').css('display','none');
				$('.div_info_check').css('display','none');
				$('.div_info_project').css('display','none');
				$('.div_project').css('display','none');
				$('.div_info_test').css('display','none');
				$('.div_test').css('display','none');
				$('.div_info_extra').css('display','none');
				$('.div_extra').css('display','none');
			}
		});
		$("#region").change(function(){
			var region = $(this).val();
			if(region != ''){
				$.ajax({
					url: '<?php echo base_url('Candidato/getSeccionesRegion'); ?>',
					method: 'POST',
					data: {'region':region},
					success: function(res){
						var secciones = JSON.parse(res);
						$('.valor_dinamico').val('');
						$('.valor_dinamico').empty();
						//$('.valor_dinamico').append($('<option selected></option>').attr('value','').text('Select'));
						$('.valor_dinamico').prop('disabled',false);
						$('#ref_profesionales_registro').val(0);
						$('#ref_personales_registro').val(0);
						$('#ref_academicas_registro').val(0);
						//Distribuye las secciones en su correspondiente select
						for(var i = 0; i < secciones.length; i++){
							if(secciones[i]['tipo_seccion'] == 'Global Search'){
								$('#global_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
							}
							/*if(secciones[i]['tipo_seccion'] == 'Verificacion Documentos'){
								$('#identidad_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
							}*/
							//if(secciones[i]['tipo_seccion'] == 'Referencias Laborales'){
							if(secciones[i]['id'] == 16){
								$('#empleos_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
							}
							//if(secciones[i]['tipo_seccion'] == 'Estudios'){
							if(secciones[i]['id'] == 3){
								$('#estudios_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
							}
							if(secciones[i]['tipo_seccion'] == 'Domicilios'){
								$('#domicilios_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
							}
							if(secciones[i]['tipo_seccion'] == 'Credito'){
								$('#credito_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
							}
						}
						//Empleos
						$('#empleos_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
						$('#empleos_tiempo_registro').append($('<option></option>').attr('value','3 years').text('3 years'));
						$('#empleos_tiempo_registro').append($('<option></option>').attr('value','5 years').text('5 years'));
						$('#empleos_tiempo_registro').append($('<option></option>').attr('value','7 years').text('7 years'));
						$('#empleos_tiempo_registro').append($('<option></option>').attr('value','10 years').text('10 years'));
						$('#empleos_tiempo_registro').append($('<option></option>').attr('value','All').text('All'));
						$('#empleos_tiempo_registro').append($('<option></option>').attr('value','0').attr("selected","selected").text('N/A'));
						//Criminales
						$('#criminal_registro').append($('<option></option>').attr('value',1).text('Apply'));
						$('#criminal_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
						$('#criminal_tiempo_registro').append($('<option></option>').attr('value','3 years').text('3 years'));
						$('#criminal_tiempo_registro').append($('<option></option>').attr('value','5 years').text('5 years'));
						$('#criminal_tiempo_registro').append($('<option></option>').attr('value','7 years').text('7 years'));
						$('#criminal_tiempo_registro').append($('<option></option>').attr('value','10 years').text('10 years'));
						$('#criminal_tiempo_registro').append($('<option></option>').attr('value','0').attr("selected","selected").text('N/A'));
						//Domicilios
						$('#domicilios_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
						$('#domicilios_tiempo_registro').append($('<option></option>').attr('value','3 years').text('3 years'));
						$('#domicilios_tiempo_registro').append($('<option></option>').attr('value','5 years').text('5 years'));
						$('#domicilios_tiempo_registro').append($('<option></option>').attr('value','7 years').text('7 years'));
						$('#domicilios_tiempo_registro').append($('<option></option>').attr('value','10 years').text('10 years'));
						$('#domicilios_tiempo_registro').append($('<option></option>').attr('value','0').attr("selected","selected").text('N/A'));
						//Credito
						$('#credito_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
						$('#credito_tiempo_registro').append($('<option></option>').attr('value','3 years').text('3 years'));
						$('#credito_tiempo_registro').append($('<option></option>').attr('value','5 years').text('5 years'));
						$('#credito_tiempo_registro').append($('<option></option>').attr('value','7 years').text('7 years'));
						$('#credito_tiempo_registro').append($('<option></option>').attr('value','10 years').text('10 years'));
						$('#credito_tiempo_registro').append($('<option></option>').attr('value','0').attr("selected","selected").text('N/A'));
						//Estudios
						$('#estudios_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
						//Identidad
						$('#identidad_registro').append($('<option></option>').attr('value',1).text('Apply'));
						$('#identidad_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
						//Globales
						$('#global_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
						//Migracion
						$('#migracion_registro').append($('<option></option>').attr('value',1).text('Apply'));
						$('#migracion_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
						//Prohibited parties list
						$('#prohibited_registro').append($('<option></option>').attr('value',1).text('Apply'));
						$('#prohibited_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
            //Age check
						$('#edad_registro').append($('<option></option>').attr('value',1).text('Apply'));
						$('#edad_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
            //Motor vehicle records
						$('#mvr_registro').append($('<option></option>').attr('value',1).text('Apply'));
						$('#mvr_registro').append($('<option></option>').attr('value',0).attr("selected","selected").text('N/A'));
					}
				});
				if(region == 'International'){
					$('#pais_registro').prop('disabled', false);
					$('#pais_registro').val('');
					$('#mvr_registro').val(0);
				}	      	
				else{
					$('#pais_registro').prop('disabled', true);
					$('#pais_registro').val('México');
				}
				$('#proyecto_registro').prop('disabled', false);
			}
			else{
				$('#pais_registro').prop('disabled', true);
				$('#pais_registro').val('');
				$('#proyecto_registro').prop('disabled', true);
				$('#proyecto_registro').val('');
				$('.valor_dinamico').val('');
				$('.valor_dinamico').empty();
				$('.valor_dinamico').prop('disabled',true);
				$('#ref_profesionales_registro').val(0);
				$('#ref_personales_registro').val(0);
        $('#ref_academicas_registro').val(0);
			}
		});
		$('#extra_registro').change(function(){
			var id = $(this).val();
			if(id != ''){
				if(!extras.includes(id)){
					var txt = $( "#extra_registro option:selected" ).text();
					extras.push(id);
					//$("#extra_registro option[value='"+id+"']").remove();
					$('#div_docs_extras').append($('<div id="div_extra'+id+'" class="extra_agregado mb-1 d-flex justify-content-start"><h5 class="mr-5">Document added: <b>'+txt+'</b></h5><button type="button" class="btn btn-danger btn-sm" onclick="eliminarExtra('+id+',\''+txt+'\')">X</button></div>'));
				}
			}
		})
		/*$("#proyecto_registro").change(function(){
			var valor = $(this).val();
			var aux = valor.split('@@');
			var id_proyecto = aux[0];
			var internacional = aux[1];
			if(id_proyecto != "" && id_proyecto != 0){
				$.ajax({
						url: '<?php //echo base_url('Candidato/getPaqueteProyecto'); ?>',
						method: 'POST',
						data: {'id_proyecto':id_proyecto,'id_cliente':id_cliente},
						dataType: "text",
						success: function(res)
						{
							if(res != ""){
								$('#examen_registro').html(res);
							}
						}
				});
			}
			else{
				$('#examen').empty();
				$('#examen').append($("<option selected></option>").attr("value","").text("Select"));
			}
			if(internacional == 1){
				$('#pais_registro').prop('disabled', false);
			}	      	
			else{
				$('#pais_registro').prop('disabled', true);
				$('#pais_registro').val(-1);
			}
		});*/	
		$("#estado").change(function() {
			var id_estado = $(this).val();
			if (id_estado != "") {
				$.ajax({
					url: '<?php echo base_url('Funciones/getMunicipios'); ?>',
					method: 'POST',
					data: {
						'id_estado': id_estado
					},
					dataType: "text",
					success: function(res) {
						$('#municipio').prop('disabled', false);
						$('#municipio').html(res);
					}
				});
			} else {
				$('#municipio').prop('disabled', true);
				$('#municipio').append($("<option selected></option>").attr("value", "").text("Selecciona"));
			}
		});
		$(".address_estado").change(function(){
			var id_estado = $(this).val();
			var seleccionado = $(this).attr("id");
			var aux = seleccionado.split('address_estado');
			var num = aux[1];
			if(id_estado != ''){
				$.ajax({
						url: '<?php echo base_url('Funciones/getMunicipios'); ?>',
						method: 'POST',
						data: {'id_estado':id_estado},
						success: function(res)
						{
							$('#address_municipio'+num).prop('disabled', false);
							$('#address_municipio'+num).html(res);
						}
				});
			}
			else{
				$('#address_municipio'+num).prop('disabled', true);
				$('#address_municipio'+num).append($("<option selected></option>").attr("value","").text("Selecciona"));
			}
		});
		$(".custom_estado").change(function(){
				var id_estado = $(this).val();
				var seleccionado = $(this).attr("id");
				var aux = seleccionado.split('custom_estado');
				var num = aux[1];
				if(id_estado != ''){
					$.ajax({
							url: '<?php echo base_url('Funciones/getMunicipios'); ?>',
							method: 'POST',
							data: {'id_estado':id_estado},
							dataType: "text",
							success: function(res)
							{
								$('#custom_municipio'+num).prop('disabled', false);
								$('#custom_municipio'+num).html(res);
							}
					});
				}
				else{
					$('#custom_municipio'+num).prop('disabled', true);
					$('#custom_municipio'+num).append($("<option selected></option>").attr("value",-1).text("Selecciona"));
				}
		});
  	});
		$("#previos").change(function(){
			var previo = $(this).val();
			if(previo != 0){
				$.ajax({
					url: '<?php echo base_url('Candidato/getDetallesProyectoPrevio'); ?>',
					method: 'POST',
					data: {'id_previo':previo},
					success: function(res)
					{
						var parte = res.split('@@');
						$('#detalles_previo').empty();
						$('#detalles_previo').html(parte[0]);
						$('#pais_previo').prop('disabled', false);
						$('#pais_previo').empty();
						$('#pais_previo').html(parte[1]);
					}
				});
			}
			else{
				$('#detalles_previo').empty();
			}
		});
    function getDocumentacion(id_candidato){
      let tieneMilitar = 0;
      $.ajax({
        async: false,
        url: '<?php echo base_url('Cliente_HCL/getVerificacionDocumentos'); ?>',
        method: 'POST',
        data: {'id_candidato':id_candidato},
        success: function(res){
          if(res != 0){
            var data = res.split('@@');
            if(data[10] != '' && data[10] != null){
              tieneMilitar = 1;
            }
            // $("#lic_profesional").val(data[0]);
            // $("#lic_institucion").val(data[1]);
            // $("#ine_clave").val(data[2]);
            // $("#ine_registro").val(data[3]);
            // $("#ine_vertical").val(data[4]);
            // $("#ine_institucion").val(data[5]);
            // $("#penales_numero").val(data[6]);
            // $("#penales_institucion").val(data[7]);
            // $("#domicilio_numero").val(data[8]);
            // $("#domicilio_fecha").val(data[9]);
            // $("#pasaporte_numero").val(data[12]);
            // $("#pasaporte_institucion").val(data[13]);
            // $("#migratorio_numero").val(data[14]);
            // $("#migratorio_fecha").val(data[15]);
            // $("#nss_numero").val(data[16]);
            // $("#nss_fecha").val(data[17]);
            // $("#mvr_estatus").val(data[19]);
            // $("#doc_comentarios").val(data[18]);
          }
        }
      });
      // let tieneDocumento = [
      //   'militar'=> tieneMilitar
      // ]
      return tieneMilitar;
    }
    function guardarRefAcademica(num) {
      let datos = $('#formRefAcademica').serialize();
      datos += '&id_candidato=' + $("#idCandidato").val();
      datos += '&id_seccion=' + $("#idSeccion").val();
      datos += '&num=' + num;

      $.ajax({
        url: '<?php echo base_url('Candidato_Ref_Academica/set'); ?>',
        type: 'POST',
        data: datos,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res){
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Referencia académica actualizada correctamente',
              showConfirmButton: false,
              timer: 2500
            })
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Hubo un problema al enviar el formulario',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Cerrar'
            })
          }
        }
      });
    }
		function verificarDocumentacion(id_candidato, pais){
			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/getDocumentosRequeridos'); ?>',
				method: 'POST',
				data: {'id_candidato':id_candidato},
				beforeSend: function(){
					$('.loader').css("display","block");
				},
				success: function(res){
					$(".registro_documento").prop('readonly', true);
					var docs = JSON.parse(res);
					var conjunto = [];
					docs.forEach(
						element => conjunto.push(element['id_tipo_documento'])
					)
					setTimeout(function(){
						if(conjunto.includes('2')){//Comprobante de Domicilio
							$("#domicilio_numero").prop('readonly', false);
							$("#domicilio_fecha").prop('readonly', false);
						}
						if(conjunto.includes('3')){ // ID
							if(pais == 'México' || pais == 'Mexico' || pais == null || pais == ''){
								$("#ine_clave").prop('readonly', false);
								$("#ine_registro").prop('readonly', false);
								$("#ine_vertical").prop('readonly', false);
								$("#ine_institucion").prop('readonly', false);
							}
							else{
								$("#ine_clave").prop('readonly', false);
								$("#ine_institucion").prop('readonly', false);
							}
						}
            if(conjunto.includes('6')){ //Estudios
							$("#nss_numero").prop('readonly', false);
							$("#nss_fecha").prop('readonly', false);
						}
						if(conjunto.includes('7') || conjunto.includes('10')){ //Estudios
							$("#lic_profesional").prop('readonly', false);
							$("#lic_institucion").prop('readonly', false);
						}
						if(conjunto.includes('12')){//Carta de Antecedentes No Penales
							$("#penales_numero").prop('readonly', false);
							$("#penales_institucion").prop('readonly', false);
						}
						if(conjunto.includes('14')){ //Pasaporte
							$("#pasaporte_numero").prop('readonly', false);
							$("#pasaporte_institucion").prop('readonly', false);
						}
						if(conjunto.includes('15')){//Carta Militar
							$("#militar_numero").prop('readonly', false);
							$("#militar_fecha").prop('readonly', false);
						}
						if(conjunto.includes('20')){//Carta Migratoria
							$("#migratorio_numero").prop('readonly', false);
							$("#migratorio_fecha").prop('readonly', false);
						}
						if(conjunto.includes('37')){//Licencia de conducir
							$("#licencia_numero").prop('readonly', false);
							$("#licencia_fecha").prop('readonly', false);
						}
            if(conjunto.includes('44')){//Motor vehicle records
							$("#mvr_estatus").prop('readonly', false);
						}
						$('.loader').fadeOut();
					},200);
				}
			});
		}
		function eliminarExtra(id_tipo_documento, txt){
			for( var i = 0; i < extras.length; i++){ 
				if ( extras[i] == id_tipo_documento) { 
					extras.splice(i, 1); 
				}
			}
			$("#div_extra"+id_tipo_documento).remove();
			$('#extra_registro').append($('<option></option>').attr('value',id_tipo_documento).text(txt));
		}
		//Proceso
		function nuevoRegistro(){
			var id_cliente = 205;
			$.ajax({
				url: '<?php echo base_url('Candidato/getSeccionesPrevias'); ?>',
				type: 'POST',
				data: {'id_cliente':id_cliente},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					$('#previos').html(res);
				}
			});
			$('#newModal').modal('show');
		}
		function estatusAvances() {
			var id_candidato = $("#idCandidato").val();
			var f = new Date();
			var dia = f.getDate();
			var mes = (f.getMonth() + 1);
			var dia = (dia < 10) ? '0' + dia : dia;
			var mes = (mes < 10) ? '0' + mes : mes;
			var h = f.getHours();
			var m = f.getMinutes();
			$("#fecha_estatus_avances").text(dia + "/" + mes + "/" + f.getFullYear());
			$.ajax({
				url: '<?php echo base_url('Candidato/checkAvances'); ?>',
				method: 'POST',
				data: {
					'id_candidato': id_candidato
				},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function() {
						if (res != 0) {
							var aux = res.split('@@');
							var finalizado = aux[2];
							if (finalizado == 1) {
								$("#div_estatus_avances").css('display', 'none');
							}
							$("#div_crearEstatusAvances").empty();
							$("#idAvances").val(aux[1]);
							$("#div_crearEstatusAvances").append(aux[0]);
						} else {
							$("#idAvances").val(0);
							$("#div_crearEstatusAvances").empty();
							$("#div_crearEstatusAvances").html('<div class="col-12"><p class="text-center">Sin registros</p></div>');
						}
						$('.loader').fadeOut();
					}, 200);
				}
			});
			$("#avancesModal").modal("show");
		}
		function generarEstatusAvance() {
			var datos = new FormData();
			datos.append('id_candidato', $("#idCandidato").val());
			datos.append('id_avance', $("#idAvances").val());
			datos.append('comentario', $("#avances_estatus_comentario").val());
			datos.append('adjunto', $("#adjunto")[0].files[0]);
			$.ajax({
				url: '<?php echo base_url('Candidato/createEstatusAvance'); ?>',
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
						$("#adjunto").val("");
						var aux = data.msg.split('@@');
						$("#idAvances").val(aux[1]);
						$("#avances_estatus_comentario").val("");
						$("#div_crearEstatusAvances").empty();
						$("#div_crearEstatusAvances").append(aux[0]);
						$("#avancesModal #msj_error").css('display', 'none')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#avancesModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function registrar(){
			var id_cliente = 205;
			var correo = $("#correo_registro").val();
			var datos = new FormData();
			datos.append('correo', correo);
			datos.append('nombre', $("#nombre_registro").val());
			datos.append('paterno', $("#paterno_registro").val());
			datos.append('materno', $("#materno_registro").val());
			datos.append('celular', $("#celular_registro").val());
			datos.append('pais_previo', $("#pais_previo").val());
			datos.append('previo', $("#previos").val());
			datos.append('region', $("#region").val());
			datos.append('pais', $("#pais_registro").val());
			datos.append('proyecto', $("#proyecto_registro").val());
			datos.append('empleos', $("#empleos_registro").val());
			datos.append('empleos_tiempo', $("#empleos_tiempo_registro").val());
			datos.append('criminal', $("#criminal_registro").val());
			datos.append('criminal_tiempo', $("#criminal_tiempo_registro").val());
			datos.append('domicilios', $("#domicilios_registro").val());
			datos.append('domicilios_tiempo', $("#domicilios_tiempo_registro").val());
			datos.append('estudios', $("#estudios_registro").val());
			datos.append('identidad', $("#identidad_registro").val());
			datos.append('global', $("#global_registro").val());
			datos.append('ref_profesionales', $("#ref_profesionales_registro").val());
			datos.append('ref_personales', $("#ref_personales_registro").val());
			datos.append('credito', $("#credito_registro").val());
			datos.append('credito_tiempo', $("#credito_tiempo_registro").val());
			datos.append('id_cliente', id_cliente);
			datos.append('examen', $("#examen_registro").val());
			datos.append('medico', $("#examen_medico").val());
			datos.append('opcion', $("#opcion_registro").val());
			datos.append('migracion', $("#migracion_registro").val());
			datos.append('prohibited', $("#prohibited_registro").val());
			datos.append('edad', $("#edad_registro").val());
			datos.append('ref_academicas', $("#ref_academicas_registro").val());
			datos.append('mvr', $("#mvr_registro").val());
			datos.append('usuario', 1);
			for (var i = 0; i < extras.length; i++) {
				datos.append('extras[]', extras[i]);
			}
			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/registrar'); ?>',
				type: 'POST',
				async : false,
				data: datos,
				contentType: false,  
				cache: false,  
				processData:false,
				beforeSend: function() {
					$('.loader').css("display","block");
				},
				success : function(res){ 
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#newModal").modal('hide')
						recargarTable()
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'The candidate has successfully registered',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if(data.codigo === 3){
						$("#newModal").modal('hide');
						recargarTable();
						$("#user").text(correo);
						$("#contrasena").text(data.msg);
						$("#respuesta_mail").text("* El correo no pudo ser enviado, mandar las credenciales del candidato de forma manual.");
						$("#passModal").modal('show');
						Swal.fire({
							position: 'center',
							icon: 'warning',
							title: 'Se ha guardado correctamente pero hubo un problema al enviar el correo',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if(data.codigo === 4){
						$("#newModal").modal('hide');
						recargarTable();
						$("#user").text(correo);
						$("#contrasena").text(data.msg);
						$("#respuesta_mail").text("* Un correo ha sido enviado al candidato con sus nuevas credenciales. Este correo puede demorar algunos minutos.");
						$("#passModal").modal('show');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha guardado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if(data.codigo === 0 || data.codigo === 2){
						$("#newModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});	
		}
		function guardarGenerales() {
			var datos = new FormData();
			datos.append('nombre', $("#nombre_general").val());
			datos.append('paterno', $("#paterno_general").val());
			datos.append('materno', $("#materno_general").val());
			datos.append('fecha_nacimiento', $("#fecha_nacimiento").val());
			datos.append('nacionalidad', $("#nacionalidad").val());
			datos.append('puesto', $("#puesto_general").val());
			datos.append('genero', $("#genero").val());
			datos.append('calle', $("#calle").val());
			datos.append('exterior', $("#exterior").val());
			datos.append('interior', $("#interior").val());
			datos.append('entre_calles', $("#calles").val());
			datos.append('colonia', $("#colonia").val());
			datos.append('estado', $("#estado").val());
			datos.append('municipio', $("#municipio").val());
			datos.append('cp', $("#cp").val());
			datos.append('civil', $("#civil").val());
			datos.append('celular', $("#celular_general").val());
			datos.append('tel_casa', $("#tel_casa").val());
			datos.append('correo', $("#correo_general").val());
			datos.append('grado_estudios', $("#grado_estudios").val());
      datos.append('curp', $('#curp_general').val());
			datos.append('id_candidato', $("#idCandidato").val());
			
			$.ajax({
				url: '<?php echo base_url('Candidato/set'); ?>',
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
						$("#generalesModal").modal('hide')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Datos generales actualizados correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#generalesModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function guardarDatosContacto() {
			var datos = new FormData();
			datos.append('nombre', $("#nombre_contacto").val());
			datos.append('paterno', $("#paterno_contacto").val());
			datos.append('materno', $("#materno_contacto").val());
			datos.append('celular', $("#celular_contacto").val());
			datos.append('tel_casa', $("#tel_casa_contacto").val());
			datos.append('correo', $("#correo_contacto").val());
			datos.append('id_candidato', $("#idCandidato").val());
			
			$.ajax({
				url: '<?php echo base_url('Candidato/setContacto'); ?>',
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
						$("#contactoModal").modal('hide')
						recargarTable()
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Datos de contacto actualizados correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#contactoModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function guardarMayoresEstudios(){
			var datos = new FormData();
			datos.append('mayor_estudios_candidato', $("#mayor_estudios_candidato").val());
			datos.append('periodo_candidato', $("#periodo_candidato").val());
			datos.append('escuela_candidato', $("#escuela_candidato").val());
			datos.append('ciudad_candidato', $("#ciudad_candidato").val());
			datos.append('certificado_candidato', $("#certificado_candidato").val());
			datos.append('mayor_estudios_analista', $("#mayor_estudios_analista").val());
			datos.append('periodo_analista', $("#periodo_analista").val());
			datos.append('escuela_analista', $("#escuela_analista").val());
			datos.append('ciudad_analista', $("#ciudad_analista").val());
			datos.append('certificado_analista', $("#certificado_analista").val());
			datos.append('comentarios', $("#mayor_estudios_comentarios").val());
			datos.append('id_candidato', $("#idCandidato").val());
		
			$.ajax({
				url: '<?php echo base_url('Candidato_Estudio/setMayor'); ?>',
				type: 'POST',
				data: datos,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res){
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#mayoresEstudiosModal").modal('hide')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Mayores estudios actualizados correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#mayoresEstudiosModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function guardarGlobalSearch(){
			var datos = new FormData();
			datos.append('sanctions', $('#sanctions').val());
			datos.append('media_searches', $('#media_searches').val());
			datos.append('oig', $('#oig').val());
			datos.append('interpol', $('#interpol').val());
			datos.append('facis', $('#facis').val());
			datos.append('bureau', $('#bureau').val());
			datos.append('european_financial', $('#european_financial').val());
			datos.append('sam', $('#sam').val());
			datos.append('ofac', $('#ofac').val());
			datos.append('law_enforcement', $('#law_enforcement').val());
			datos.append('regulatory', $('#regulatory').val());
			datos.append('other_bodies', $('#other_bodies').val());
  		datos.append('usa_sanctions', $('#usa_sanctions').val());
			datos.append('fda', $('#fda').val());
  		datos.append('sdn', $('#sdn').val());
      datos.append('mvr', $('#mvr').val());
			datos.append('comentarios', $('#global_comentarios').val());
			datos.append('id_candidato', $("#idCandidato").val());

			$.ajax({
				url: '<?php echo base_url('Candidato_Global/set'); ?>',
				type: 'POST',
				data: datos,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res){
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#globalSearchModal").modal('hide')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Búsqueda global actualizada correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					else{
						$("#globalSearchModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function actualizarTrabajoGobierno() {
			var datos = new FormData();
			datos.append('inactivo', $("#trabajo_inactivo").val());
			datos.append('id_candidato', $("#idCandidato").val());
			datos.append('caso', 2);
			
			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/guardarTrabajoGobierno'); ?>',
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
						$("#trabajos_msj_error").css('display', 'none')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Inactividad en empleos actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#trabajos_msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function actualizarReferenciaLaboral(num) {
			var datos = new FormData();
			datos.append('empresa', $('#reflab' + num + '_empresa_ingles').val());
			datos.append('direccion', $('#reflab' + num + '_direccion_ingles').val());
			datos.append('entrada', $('#reflab' + num + '_entrada_ingles').val());
			datos.append('salida', $('#reflab' + num + '_salida_ingles').val());
			datos.append('telefono', $('#reflab' + num + '_telefono_ingles').val());
			datos.append('puesto1', $('#reflab' + num + '_puesto1_ingles').val());
			datos.append('puesto2', $('#reflab' + num + '_puesto2_ingles').val());
			datos.append('salario1', $('#reflab' + num + '_salario1_ingles').val());
			datos.append('salario2', $('#reflab' + num + '_salario2_ingles').val());
			datos.append('jefenombre', $('#reflab' + num + '_jefenombre_ingles').val());
			datos.append('jefecorreo', $('#reflab' + num + '_jefecorreo_ingles').val());
			datos.append('jefepuesto', $('#reflab' + num + '_jefepuesto_ingles').val());
			datos.append('separacion', $('#reflab' + num + '_separacion_ingles').val());
			datos.append('idref', $('#idreflabingles'+num).val());
			datos.append('num', num);
			datos.append('id_candidato', $("#idCandidato").val());

			formdata = $("#candidato_reflaboral" + num).serialize();
			var idCandidato = $("#idCandidato").val();
			var f = new Date();
			var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
			respaldoTxt(formdata, 'referencia_laboral_' + num + '-' + idCandidato + '-' + fecha_txt);

			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/guardarReferenciaLaboral'); ?>',
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
					if (data.codigo === 0) {
						$("#reflab_msj_error" + num).css('display', 'block').html(data.msg);
					}
					if (data.codigo === 1) {
						$("#reflab_msj_error" + num).css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Laboral actualizada correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if (data.codigo === 2) {
						$("#reflab_msj_error" + num).css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Laboral actualizada correctamente',
							showConfirmButton: false,
							timer: 2500
						})
						$('#idreflabingles' + num).val(data.msg);
					}
				}
			});
		}
		function verificarLaboral(num) {
			var datos = new FormData();
			datos.append('empresa', $('#an_reflab' + num + '_empresa').val());
			datos.append('direccion', $('#an_reflab' + num + '_direccion').val());
			datos.append('entrada', $('#an_reflab' + num + '_entrada').val());
			datos.append('salida', $('#an_reflab' + num + '_salida').val());
			datos.append('telefono', $('#an_reflab' + num + '_telefono').val());
			datos.append('puesto1', $('#an_reflab' + num + '_puesto1').val());
			datos.append('puesto2', $('#an_reflab' + num + '_puesto2').val());
			datos.append('salario1', $('#an_reflab' + num + '_salario1').val());
			datos.append('salario2', $('#an_reflab' + num + '_salario2').val());
			datos.append('jefenombre', $('#an_reflab' + num + '_jefenombre').val());
			datos.append('jefecorreo', $('#an_reflab' + num + '_jefecorreo').val());
			datos.append('jefepuesto', $('#an_reflab' + num + '_jefepuesto').val());
			datos.append('separacion', $('#an_reflab' + num + '_separacion').val());
			datos.append('notas', $('#an_reflab' + num + '_notas').val());
			datos.append('responsabilidad', $('#an_reflab' + num + '_responsabilidad').val());
			datos.append('iniciativa', $('#an_reflab' + num + '_iniciativa').val());
			datos.append('eficiencia', $('#an_reflab' + num + '_eficiencia').val());
			datos.append('disciplina', $('#an_reflab' + num + '_disciplina').val());
			datos.append('puntualidad', $('#an_reflab' + num + '_puntualidad').val());
			datos.append('limpieza', $('#an_reflab' + num + '_limpieza').val());
			datos.append('estabilidad', $('#an_reflab' + num + '_estabilidad').val());
			datos.append('emocional', $('#an_reflab' + num + '_emocional').val());
			datos.append('honesto', $('#an_reflab' + num + '_honesto').val());
			datos.append('rendimiento', $('#an_reflab' + num + '_rendimiento').val());
			datos.append('actitud', $('#an_reflab' + num + '_actitud').val());
			datos.append('recontratacion', $('#an_reflab' + num + '_recontratacion').val());
			datos.append('motivo', $('#an_reflab' + num + '_motivo').val());
			datos.append('idverlab', $('#idverlab'+num).val());
			datos.append('num', num);
			datos.append('id_candidato', $("#idCandidato").val());
			//Respaldo txt
			formdata = $("#analista_reflaboral" + num).serialize();
			var idCandidato = $("#idCandidato").val();
			var f = new Date();
			var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
			respaldoTxt(formdata, 'verificacion_laboral_' + num + '-' + idCandidato + '-' + fecha_txt);

			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/guardarVerificacionLaboral'); ?>',
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
						$("#verlab_msj_error" + num).css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Verificación laboral actualizada correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					else{
						$("#verlab_msj_error" + num).css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function generarGap(){
			var id_candidato = $("#idCandidato").val();
			var razon = $("#razon").val();
			var fi = $("#fecha_inicio").val();
			var ff = $("#fecha_fin").val();
			$.ajax({
				url: '<?php echo base_url('Candidato/createGap'); ?>',
				method: 'POST',
				data: {'id_candidato':id_candidato,'fi':fi,'ff':ff,'razon':razon},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res)
				{
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#gapsModal #msj_error").css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha registrado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
						$("#fecha_inicio").val("");
						$("#fecha_fin").val("");
						$("#razon").val("");
						$("#contenedor_gaps").empty();
						$("#contenedor_gaps").html(data.msg);
					}
					else{
						$("#gapsModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		//Verificacion de estudios
		function verificacionEstudios() {
			var id_candidato = $("#idCandidato").val();
			var f = new Date();
			var dia = f.getDate();
			var mes = (f.getMonth() + 1);
			var dia = (dia < 10) ? '0' + dia : dia;
			var mes = (mes < 10) ? '0' + mes : mes;
			$("#fecha_estatus_estudio").text(dia + "/" + mes + "/" + f.getFullYear());
			$.ajax({
				url: '<?php echo base_url('Candidato/checkEstatusEstudios'); ?>',
				method: 'POST',
				data: {
					'id_candidato': id_candidato
				},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					if (res != 0) {
						var aux = res.split('@@');
						$("#div_crearEstatusEstudio").empty();
						$("#idVerificacionEstudio").val(aux[1]);
						$("#div_crearEstatusEstudio").append(aux[0]);
						$("#estudio_estatus").val(aux[2]);
					} else {
						$("#div_crearEstatusEstudio").empty();
						$("#div_crearEstatusEstudio").append('<p>Sin registros</p>');
						$("#div_estatus_estudio").css('display', 'block');
						$("#idVerificacionEstudio").val(0);
    				$('#estudio_estatus').val('Validated');
					}
				}
			});
			$("#verificacionEstudiosModal").modal("show");
		}
		function registrarEstatusEstudio() {
			var datos = new FormData();
			datos.append('comentario', $("#estudio_estatus_comentario").val());
			datos.append('estatus', $("#estudio_estatus").val());
			datos.append('id_candidato', $("#idCandidato").val());
			datos.append('id_verificacion', $("#idVerificacionEstudio").val());
			$.ajax({
				url: '<?php echo base_url('Candidato/registrarEstatusEstudio'); ?>',
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
						$("#verificacionEstudiosModal  #msj_error").css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha guardado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
						var aux = data.msg.split('@@');
						$("#idVerificacionEstudio").val(aux[1]);
						$("#estudio_estatus_comentario").val('');
						$("#div_crearEstatusEstudio").empty();
						$("#div_crearEstatusEstudio").append(aux[0]);
						$("#estudio_estatus").val(aux[2]);
					}
					else{
						$("#verificacionEstudiosModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function accionEstatusEstudio(id_detalle, accion) {
			var datos = new FormData();
			datos.append('comentario', $("#comentario_estudio"+id_detalle).val());
			datos.append('fecha', $("#fecha_estatus_estudio"+id_detalle).val());
			datos.append('id_candidato', $("#idCandidato").val());
			datos.append('id_verificacion', $("#idVerificacionEstudio").val());
			datos.append('id_detalle', id_detalle);
			datos.append('accion', accion);
			if(accion == 'editar'){
				$.ajax({
					url: '<?php echo base_url('Candidato/accionEstatusEstudios'); ?>',
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
							$("#verificacionEstudiosModal  #msj_error").css('display', 'none');
							Swal.fire({
								position: 'center',
								icon: 'success',
								title: 'Se ha actualizado correctamente',
								showConfirmButton: false,
								timer: 2500
							})
						}
						else{
							$("#verificacionEstudiosModal #msj_error").css('display', 'block').html(data.msg);
						}
					}
				});
			}
			if(accion == 'eliminar'){
				$('#fila_estatus'+id_detalle).hide();
				$.ajax({
					url: '<?php echo base_url('Candidato/accionEstatusEstudios'); ?>',
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
							$("#verificacionEstudiosModal  #msj_error").css('display', 'none');
							Swal.fire({
								position: 'center',
								icon: 'success',
								title: 'Se ha eliminado correctamente',
								showConfirmButton: false,
								timer: 2500
							})
						}
						else{
							$("#verificacionEstudiosModal #msj_error").css('display', 'block').html(data.msg);
						}
					}
				});
			}
		}
		function guardarEstatusEstudios() {
			var id_verificacion = $("#idVerificacionEstudio").val();
			var id_candidato = $("#idCandidato").val();
			var estatus = $("#estudio_estatus").val();
			if(id_verificacion == 0){
				Swal.fire({
					position: 'center',
					icon: 'error',
					title: 'No hay registros de comentarios',
					showConfirmButton: false,
					timer: 2500
				})
			}
			else{
				$.ajax({
					url: '<?php echo base_url('Candidato/guardarEstatusEstudios'); ?>',
					method: 'POST',
					data: {
						'id_verificacion': id_verificacion,
						'id_candidato': id_candidato,
						'estatus':estatus
					},
					beforeSend: function() {
						$('.loader').css("display", "block");
					},
					success: function(res) {
						setTimeout(function() {
							$('.loader').fadeOut();
						}, 200);
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
				});
			}
		}
		//Verificacion de laborales
		function verificacionLaborales() {
			var id_candidato = $("#idCandidato").val();
			var f = new Date();
			var dia = f.getDate();
			var mes = (f.getMonth() + 1);
			var dia = (dia < 10) ? '0' + dia : dia;
			var mes = (mes < 10) ? '0' + mes : mes;
			$("#fecha_estatus_laboral").text(dia + "/" + mes + "/" + f.getFullYear());
			$.ajax({
				url: '<?php echo base_url('Candidato/checkEstatusLaborales'); ?>',
				method: 'POST',
				data: {
					'id_candidato': id_candidato
				},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					if (res != 0) {
						var aux = res.split('@@');
						$("#div_crearEstatusLaboral").empty();
						$("#idVerificacionLaboral").val(aux[1]);
						$("#div_crearEstatusLaboral").append(aux[0]);
						$("#laborales_estatus").val(aux[2]);
					} else {
						$("#div_crearEstatusLaboral").empty();
						$("#div_crearEstatusLaboral").append('<p>Sin registros </p>');
						$("#div_estatus_laboral").css('display', 'block');
						$("#idVerificacionLaboral").val(0);
						$("#laborales_estatus").val('Validated');
					}
				}
			});
			$("#verificacionLaboralesModal").modal("show");
		}
		function registrarEstatusLaboral() {
			var datos = new FormData();
			datos.append('comentario', $("#laboral_estatus_comentario").val());
			datos.append('estatus', $("#laborales_estatus").val());
			datos.append('id_candidato', $("#idCandidato").val());
			datos.append('id_verificacion', $("#idVerificacionLaboral").val());
			$.ajax({
				url: '<?php echo base_url('Candidato/registrarEstatusLaborales'); ?>',
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
						$("#verificacionLaboralesModal  #msj_error").css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha guardado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
						var aux = data.msg.split('@@');
						$("#idVerificacionLaboral").val(aux[1]);
						$("#laboral_estatus_comentario").val("");
						$("#div_crearEstatusLaboral").empty();
						$("#div_crearEstatusLaboral").append(aux[0]);
						$("#laborales_estatus").val(aux[2]);
					}
					else{
						$("#verificacionLaboralesModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function accionEstatusLaborales(id_detalle, accion) {
			var datos = new FormData();
			datos.append('comentario', $("#comentario_laborales"+id_detalle).val());
			datos.append('fecha', $("#fecha_estatus_laborales"+id_detalle).val());
			datos.append('id_candidato', $("#idCandidato").val());
			datos.append('id_verificacion', $("#idVerificacionLaboral").val());
			datos.append('id_detalle', id_detalle);
			datos.append('accion', accion);
			if(accion == 'editar'){
				$.ajax({
					url: '<?php echo base_url('Candidato/accionEstatusLaborales'); ?>',
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
							$("#verificacionLaboralesModal  #msj_error").css('display', 'none');
							Swal.fire({
								position: 'center',
								icon: 'success',
								title: 'Se ha actualizado correctamente',
								showConfirmButton: false,
								timer: 2500
							})
						}
						else{
							$("#verificacionLaboralesModal #msj_error").css('display', 'block').html(data.msg);
						}
					}
				});
			}
			if(accion == 'eliminar'){
				$('#fila_estatus'+id_detalle).hide();
				$.ajax({
					url: '<?php echo base_url('Candidato/accionEstatusLaborales'); ?>',
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
							$("#verificacionLaboralesModal  #msj_error").css('display', 'none');
							Swal.fire({
								position: 'center',
								icon: 'success',
								title: 'Se ha eliminado correctamente',
								showConfirmButton: false,
								timer: 2500
							})
						}
						else{
							$("#verificacionLaboralesModal #msj_error").css('display', 'block').html(data.msg);
						}
					}
				});
			}
		}
		function guardarEstatusLaborales() {
			var id_verificacion = $("#idVerificacionLaboral").val();
			var id_candidato = $("#idCandidato").val();
			var estatus = $("#laborales_estatus").val();
			if(id_verificacion == 0){
				Swal.fire({
					position: 'center',
					icon: 'error',
					title: 'No hay registros de comentarios',
					showConfirmButton: false,
					timer: 2500
				})
			}
			else{
				$.ajax({
					url: '<?php echo base_url('Candidato/guardarEstatusLaborales'); ?>',
					method: 'POST',
					data: {
						'id_verificacion': id_verificacion,
						'id_candidato': id_candidato,
						'estatus':estatus
					},
					beforeSend: function() {
						$('.loader').css("display", "block");
					},
					success: function(res) {
						setTimeout(function() {
							$('.loader').fadeOut();
						}, 200);
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
				});
			}
		}
		//Verificacion criminal
		function verificacionPenales() {
			var id_candidato = $("#idCandidato").val();
			var f = new Date();
			var dia = f.getDate();
			var mes = (f.getMonth() + 1);
			var dia = (dia < 10) ? '0' + dia : dia;
			var mes = (mes < 10) ? '0' + mes : mes;
			$("#fecha_estatus_penales").text(dia + "/" + mes + "/" + f.getFullYear());
			$.ajax({
				url: '<?php echo base_url('Candidato/checkEstatusPenales'); ?>',
				method: 'POST',
				data: {
					'id_candidato': id_candidato
				},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					if (res != 0) {
						var aux = res.split('@@');
						$("#div_crearEstatusPenales").empty();
						$("#idVerificacionPenales").val(aux[1]);
						$("#div_crearEstatusPenales").append(aux[0]);
						$("#criminal_estatus").val(aux[2]);
					} else {
						$("#div_crearEstatusPenales").empty();
						$("#div_crearEstatusPenales").append('<p>Sin registros </p>');
						$("#div_estatus_penales").css('display', 'block');
						$("#idVerificacionPenales").val(0);
						$("#criminal_estatus").val('Validated');
					}

				}
			});
			$("#verificacionPenalesModal").modal("show");
		}
		function registrarEstatusPenales() {
			var datos = new FormData();
			datos.append('comentario', $("#penales_estatus_comentario").val());
			datos.append('estatus', $("#criminal_estatus").val());
			datos.append('id_candidato', $("#idCandidato").val());
			datos.append('id_verificacion', $("#idVerificacionPenales").val());
			$.ajax({
				url: '<?php echo base_url('Candidato/registrarEstatusPenales'); ?>',
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
						$("#verificacionPenalesModal  #msj_error").css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha guardado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
						var aux = data.msg.split('@@');
						$("#idVerificacionPenales").val(aux[1]);
						$("#penales_estatus_comentario").val("");
						$("#div_crearEstatusPenales").empty();
						$("#div_crearEstatusPenales").append(aux[0]);
						$("#criminal_estatus").val(aux[2]);
					}
					else{
						$("#verificacionPenalesModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function accionEstatusPenales(id_detalle, accion) {
			var datos = new FormData();
			datos.append('comentario', $("#comentario_penales"+id_detalle).val());
			datos.append('fecha', $("#fecha_estatus_penales"+id_detalle).val());
			datos.append('id_candidato', $("#idCandidato").val());
			datos.append('id_verificacion', $("#idVerificacionPenales").val());
			datos.append('id_detalle', id_detalle);
			datos.append('accion', accion);
			if(accion == 'editar'){
				$.ajax({
					url: '<?php echo base_url('Candidato/accionEstatusPenales'); ?>',
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
							$("#verificacionPenalesModal  #msj_error").css('display', 'none');
							Swal.fire({
								position: 'center',
								icon: 'success',
								title: 'Se ha actualizado correctamente',
								showConfirmButton: false,
								timer: 2500
							})
						}
						else{
							$("#verificacionPenalesModal #msj_error").css('display', 'block').html(data.msg);
						}
					}
				});
			}
			if(accion == 'eliminar'){
				$('#fila_estatus'+id_detalle).hide();
				$.ajax({
					url: '<?php echo base_url('Candidato/accionEstatusPenales'); ?>',
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
							$("#verificacionPenalesModal  #msj_error").css('display', 'none');
							Swal.fire({
								position: 'center',
								icon: 'success',
								title: 'Se ha eliminado correctamente',
								showConfirmButton: false,
								timer: 2500
							})
						}
						else{
							$("#verificacionPenalesModal #msj_error").css('display', 'block').html(data.msg);
						}
					}
				});
			}
		}
		function guardarEstatusPenales() {
			var id_verificacion = $("#idVerificacionPenales").val();
			var id_candidato = $("#idCandidato").val();
			var estatus = $("#criminal_estatus").val();
			if(id_verificacion == 0){
				Swal.fire({
					position: 'center',
					icon: 'error',
					title: 'No hay registros de comentarios',
					showConfirmButton: false,
					timer: 2500
				})
			}
			else{
				$.ajax({
					url: '<?php echo base_url('Candidato/guardarEstatusPenales'); ?>',
					method: 'POST',
					data: {
						'id_verificacion': id_verificacion,
						'id_candidato': id_candidato,
						'estatus':estatus
					},
					beforeSend: function() {
						$('.loader').css("display", "block");
					},
					success: function(res) {
						setTimeout(function() {
							$('.loader').fadeOut();
						}, 200);
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
				});
			}
		}

		function actualizarChecklist(){
			var datos = new FormData();
			datos.append('check_education', $("#check_education").val());
			datos.append('check_employment', $("#check_employment").val());
			datos.append('check_address', $("#check_address").val());
			datos.append('check_criminal', $("#check_criminal").val());
			datos.append('check_database', $("#check_database").val());
			datos.append('check_identity', $("#check_identity").val());
			//datos.append('check_military', $("#check_military").val());
			datos.append('check_prohibited', $("#check_prohibited").val());
			datos.append('check_other', $("#check_other").val());
			datos.append('id_candidato', $("#idCandidato").val());
			
			$.ajax({
				url: '<?php echo base_url('Candidato/guardarVerificacionChecklist'); ?>',
				type: 'POST',
				data: datos,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res)
				{
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#scopeModal").modal('hide')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Checklist actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#scopeModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function guardarDocumentacion(){
			var datos = new FormData();
			datos.append('lic_profesional', $("#lic_profesional").val());
			datos.append('lic_institucion', $("#lic_institucion").val());
			datos.append('ine_clave', $("#ine_clave").val());
			datos.append('ine_registro', $("#ine_registro").val());
			datos.append('ine_vertical', $("#ine_vertical").val());
			datos.append('ine_institucion', $("#ine_institucion").val());
			datos.append('pasaporte_numero', $("#pasaporte_numero").val());
			datos.append('pasaporte_institucion', $("#pasaporte_institucion").val());
			datos.append('penales_numero', $("#penales_numero").val());
			datos.append('penales_institucion', $("#penales_institucion").val());
			datos.append('domicilio_numero', $("#domicilio_numero").val());
			datos.append('domicilio_fecha', $("#domicilio_fecha").val());
			datos.append('militar_numero', $("#militar_numero").val());
			datos.append('militar_fecha', $("#militar_fecha").val());
			datos.append('migratorio_numero', $("#migratorio_numero").val());
			datos.append('migratorio_fecha', $("#migratorio_fecha").val());
			datos.append('licencia_numero', $("#licencia_numero").val());
			datos.append('licencia_fecha', $("#licencia_fecha").val());
      datos.append('nss_numero', $("#nss_numero").val());
			datos.append('nss_fecha', $("#nss_fecha").val());
			datos.append('mvr', $("#mvr_estatus").val());
			datos.append('comentarios', $("#doc_comentarios").val());
			datos.append('id_candidato', $("#idCandidato").val());
			
			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/guardarDocumentacion'); ?>',
				type: 'POST',
				data: datos,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res){
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#documentosModal").modal('hide')
						recargarTable()
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#documentosModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function subirDoc() {
			var data = new FormData();
			var doc = $("#documento")[0].files[0];
			data.append('id_candidato', $("#idCandidato").val());
			data.append('prefijo', $(".prefijo").val());
			data.append('tipo_doc', $("#tipo_archivo").val());
			data.append('documento', doc);
			$.ajax({
				url: "<?php echo base_url('Candidato/cargarDocumento'); ?>",
				method: "POST",
				data: data,
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
						$("#documento").val("");
						$("#tablaDocs").empty();
						$('#tipo_archivo').val('');
						$("#tablaDocs").html(data.msg);
						$("#docsModal #msj_error").css('display', 'none')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if (data.codigo === 0) {
						$("#docsModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function eliminarArchivo(idDoc, archivo, id_candidato) {
			$("#fila" + idDoc).remove();
			$.ajax({
				url: '<?php echo base_url('Candidato/eliminarDocumento'); ?>',
				method: 'POST',
				data: {
					'idDoc': idDoc,
					'archivo': archivo,
					'id_candidato': id_candidato
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
							icon: 'success',
							title: 'Se ha eliminado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					else{
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'Hubo un problema al eliminar, intenta más tarde',
							showConfirmButton: false,
							timer: 2500
						})
					}
				}
			});
		}
		function finalizarProceso(){
			var datos = new FormData();
			datos.append('check_identidad', $("#check_identidad").val());
			datos.append('check_laboral', $("#check_laboral").val());
			datos.append('check_estudios', $("#check_estudios").val());
			datos.append('check_visita', $("#check_visita").val());
			datos.append('check_penales', $("#check_penales").val());
			datos.append('check_ofac', $("#check_ofac").val());
			datos.append('check_laboratorio', $("#check_laboratorio").val());
			datos.append('check_global', $("#check_global").val());
			datos.append('check_domicilio', $("#check_domicilio").val());
			datos.append('check_credito', $("#check_credito").val());
			datos.append('check_medico', $("#check_medico").val());
			datos.append('check_sex_offender', $("#check_sex_offender").val());
			datos.append('check_professional_accreditation', $("#check_professional_accreditation").val());
			datos.append('check_ref_academica', $("#check_ref_academica").val());
			datos.append('check_nss', $("#check_nss").val());
			datos.append('check_ciudadania', $("#check_ciudadania").val());
			datos.append('check_mvr', $("#check_mvr").val());
			datos.append('check_servicio_militar', $("#check_servicio_militar").val());
			datos.append('comentario_final', $("#comentario_final").val());
			datos.append('bgc_status', $("#bgc_status").val());
			datos.append('id_candidato', $("#idCandidato").val());

			$.ajax({
				url: '<?php echo base_url('Candidato_Conclusion/setBGC'); ?>',
				type: 'POST',
				data: datos,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res){
					recargarTable();
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#completarModal").modal('hide')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Conclusiones actualizadas correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#completarModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function guardarAddress(num){
			var datos = new FormData();
			datos.append('address_periodo', $("#address_periodo"+num).val());
			datos.append('address_causa', $("#address_causa"+num).val());
			datos.append('address_calle', $("#address_calle"+num).val());
			datos.append('address_exterior', $("#address_exterior"+num).val());
			datos.append('address_interior', $("#address_interior"+num).val());
			datos.append('address_colonia', $("#address_colonia"+num).val());
			datos.append('address_estado', $("#address_estado"+num).val());
			datos.append('address_municipio', $("#address_municipio"+num).val());
			datos.append('address_cp', $("#address_cp"+num).val());
			datos.append('id_domicilio', $("#idAddress"+num).val());
			datos.append('num', num);
			datos.append('tipo', 'general');
			datos.append('id_candidato', $("#idCandidato").val());

			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/guardarHistorialDomicilios'); ?>',
				type: 'POST',
				data: datos,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res)
				{
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#AddressModal #msj_error_address_"+num).css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Historial domicilios actualizados correctamente',
							showConfirmButton: false,
							timer: 2500
						})
						$("#idAddress"+num).val(data.msg);
					}
					if (data.codigo === 2) {
						$("#AddressModal #msj_error_address_"+num).css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Historial domicilios actualizados correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} 
					if (data.codigo === 0) {
						$("#AddressModal #msj_error_address_"+num).css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function guardarComentarioAddress(){
			id_candidato = $("#idCandidato").val();
			comentario = $("#address_comentarios").val();
			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/guardarComentarioVerificarDomicilios'); ?>',
				method: "POST",  
				data: {'id_candidato':id_candidato,'comentario':comentario},
				beforeSend: function(){
					$('.loader').css("display","block");
				},
				success: function(res){
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#AddressModal #msj_error_address_comentario").css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Comentario actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if (data.codigo === 0) {
						$("#AddressModal #msj_error_address_comentario").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function guardarCustomAddress(num){
			var datos = new FormData();
			datos.append('address_periodo', $("#custom_periodo"+num).val());
			datos.append('address_causa', $("#custom_causa"+num).val());
			datos.append('address_calle', $("#custom_calle"+num).val());
			datos.append('address_exterior', $("#custom_exterior"+num).val());
			datos.append('address_interior', $("#custom_interior"+num).val());
			datos.append('address_colonia', $("#custom_colonia"+num).val());
			datos.append('address_estado', $("#custom_estado"+num).val());
			datos.append('address_municipio', $("#custom_municipio"+num).val());
			datos.append('address_cp', $("#custom_cp"+num).val());
			datos.append('id_domicilio', $("#idCustomAddress"+num).val());
			datos.append('num', num);
			datos.append('tipo', 'general');
			datos.append('id_candidato', $("#idCandidato").val());

			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/guardarHistorialDomicilios'); ?>',
				type: 'POST',
				data: datos,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res)
				{
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#customAddressModal #msj_error_custom_address"+num).css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Historial domicilios actualizados correctamente',
							showConfirmButton: false,
							timer: 2500
						})
						$("#idAddress"+num).val(data.msg);
					}
					if (data.codigo === 2) {
						$("#customAddressModal #msj_error_custom_address"+num).css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Historial domicilios actualizados correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} 
					if (data.codigo === 0) {
						$("#customAddressModal #msj_error_custom_address"+num).css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function guardarComentarioCustomAddress(){
			id_candidato = $("#idCandidato").val();
			comentario = $("#custom_address_comentarios").val();
			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/guardarComentarioVerificarDomicilios'); ?>',
				method: "POST",  
				data: {'id_candidato':id_candidato,'comentario':comentario},
				beforeSend: function(){
					$('.loader').css("display","block");
				},
				success: function(res){
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#customAddressModal #msj_error_custom_address_comentario").css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Comentario actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if (data.codigo === 0) {
						$("#customAddressModal #msj_error_custom_address_comentario").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function guardarGeneralesInternacional() {
			var datos = new FormData();
			datos.append('nombre', $("#nombre_internacional").val());
			datos.append('paterno', $("#paterno_internacional").val());
			datos.append('materno', $("#materno_internacional").val());
			datos.append('fecha_nacimiento', $("#fecha_nacimiento_internacional").val());
			datos.append('nacionalidad', $("#nacionalidad_internacional").val());
			datos.append('puesto', $("#puesto_internacional").val());
			datos.append('genero', $("#genero_internacional").val());
			datos.append('domicilio', $("#domicilio_internacional").val());
			datos.append('pais', $("#pais_internacional").val());
			datos.append('civil', $("#civil_internacional").val());
			datos.append('celular', $("#celular_internacional").val());
			datos.append('tel_casa', $("#tel_casa_internacional").val());
			datos.append('otro_telefono', $("#tel_oficina_internacional").val());
			datos.append('correo', $("#correo_internacional").val());
			datos.append('id_candidato', $("#idCandidato").val());
			
			$.ajax({
				url: '<?php echo base_url('Candidato/setInternacional'); ?>',
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
						$("#generalesInternacionalModal").modal('hide')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Datos generales actualizados correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#generalesInternacionalModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function guardarReferenciaProfesional(num) {
			var datos = new FormData();
			datos.append('nombre', $('#refpro' + num + '_nombre').val());
			datos.append('telefono', $('#refpro' + num + '_telefono').val());
			datos.append('tiempo', $('#refpro' + num + '_tiempo').val());
			datos.append('conocido', $('#refpro' + num + '_conocido').val());
			datos.append('puesto', $('#refpro' + num + '_puesto').val());
			datos.append('tiempo2', $('#refpro' + num + '_tiempo2').val());
			datos.append('conocido2', $('#refpro' + num + '_conocido2').val());
			datos.append('puesto2', $('#refpro' + num + '_puesto2').val());
			datos.append('cualidades', $('#refpro' + num + '_cualidades').val());
			datos.append('desempeno', $('#refpro' + num + '_desempeno').val());
			datos.append('recomienda', $('#refpro' + num + '_recomienda').val());
			datos.append('comentario', $('#refpro' + num + '_comentario').val());
			datos.append('idref', $('#id_refpro'+num).val());
			datos.append('num', num);
			datos.append('id_candidato', $("#idCandidato").val());

			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/guardarReferenciaProfesional'); ?>',
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
					if (data.codigo === 0) {
						$("#refpro_msj_error" + num).css('display', 'block').html(data.msg);
					}
					if (data.codigo === 1) {
						$("#refpro_msj_error" + num).css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Referencia profesional actualizada correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
				}
			});
		}
		function guardarRefPersonales(cantidad) {
			var datos = new FormData();
			for(var num = 1; num <= cantidad; num++){
				datos.append('nombre'+num, $('#refper' + num + '_nombre').val());
				datos.append('tiempo'+num, $('#refper' + num + '_tiempo').val());
				datos.append('lugar'+num, $('#refper' + num + '_lugar').val());
				datos.append('telefono'+num, $('#refper' + num + '_telefono').val());
				datos.append('trabaja'+num, $('#refper' + num + '_trabaja').val());
				datos.append('vive'+num, $('#refper' + num + '_vive').val());
				datos.append('comentario'+num, $('#refper' + num + '_comentario').val());
			}
			datos.append('cantidad', cantidad);
			datos.append('id_candidato', $("#idCandidato").val());

			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/guardarReferenciasPersonales'); ?>',
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
					if (data.codigo === 0) {
						$("#refPersonalesModal #msj_error").css('display', 'block').html(data.msg);
					}
					if (data.codigo === 1) {
						$("#refPersonalesModal").modal('hide');
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
		function guardarAddressInternacional(num){
			var datos = new FormData();
			datos.append('address_periodo', $("#address_periodo_internacional"+num).val());
			datos.append('address_causa', $("#address_causa_internacional"+num).val());
			datos.append('address_domicilio', $("#address_domicilio_internacional"+num).val());
			datos.append('address_pais', $("#address_pais_internacional"+num).val());
			datos.append('id_domicilio', $("#idAddressInternacional"+num).val());
			datos.append('num', num);
			datos.append('tipo', 'internacional');
			datos.append('id_candidato', $("#idCandidato").val());
			
			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/guardarHistorialDomicilios'); ?>',
				type: 'POST',
				data: datos,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res)
				{
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#AddressInternacionalModal #msj_error"+num).css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Historial de domicilios actualizados correctamente',
							showConfirmButton: false,
							timer: 2500
						})
						$("#idAddressInternacional"+num).val(data.msg);
					}
					if (data.codigo === 2) {
						$("#AddressInternacionalModal #msj_error"+num).css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Historial de domicilios actualizados correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} 
					if (data.codigo === 0) {
						$("#AddressInternacionalModal #msj_error"+num).css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function guardarComentarioAddressInternacional(){
			id_candidato = $("#idCandidato").val();
			comentario = $("#address_comentarios_internacional").val();
			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/guardarComentarioVerificarDomicilios'); ?>',
				method: "POST",  
				data: {'id_candidato':id_candidato,'comentario':comentario},
				beforeSend: function(){
					$('.loader').css("display","block");
				},
				success: function(res){
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#AddressInternacionalModal #msj_error_comentario").css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Comentario actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if (data.codigo === 0) {
						$("#AddressInternacionalModal #msj_error_comentario").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function generarHistorialCredito(){
			var id_candidato = $("#idCandidato").val();
			var comentario = $("#credito_comentario").val();
			var fi = $("#credito_fecha_inicio").val();
			var ff = $("#credito_fecha_fin").val();
			$.ajax({
				url: '<?php echo base_url('Cliente_ESOLUTIONS/createHistorialCrediticio'); ?>',
				method: 'POST',
				data: {'id_candidato':id_candidato,'fi':fi,'ff':ff,'comentario':comentario},
				success: function(res)
				{
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#creditoModal #msj_error").css('display', 'none');
						$("#credito_fecha_inicio").val("");
						$("#credito_fecha_fin").val("");
						$("#credito_comentario").val("");
						$("#div_antescredit").empty();
						$("#div_antescredit").append(data.msg);
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if (data.codigo === 0) {
						$("#creditoModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function subirExamenMedico(){
			var docs = new FormData();
			var archivo = $("#doc_medico")[0].files[0];
			docs.append("id_candidato", $("#idCandidato").val());
			docs.append("archivo", archivo);
			$.ajax({  
				url:"<?php echo base_url('Medico/subirExamenMedico'); ?>",   
				method: "POST",  
				data: docs,  
				contentType: false,  
				cache: false,  
				processData:false,  
				beforeSend: function(){
					$('.loader').css("display","block");
				},
				success:function(res){
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						recargarTable()
						$("#medicoModal").modal('hide')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha subido correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					else{
						$("#medicoModal #msj_error").css('display', 'block').html(data.msg);
					}
				}  
			});  
		}
		function ejecutarAccion(){
			var accion = $("#btnGuardar").val();
			var id_candidato = $("#idCandidato").val();
			var correo = $("#correo").val();
			if(accion == 'generar'){
				$.ajax({
					url: '<?php echo base_url('Cliente_ESOLUTIONS/regenerarPassword'); ?>',
					type: 'post',
					data: {'id_candidato':id_candidato,'correo':correo},
					beforeSend: function() {
						$('.loader').css("display","block");
					},
					success : function(res){ 
						setTimeout(function() {
							$('.loader').fadeOut();
						}, 200);
						var data = JSON.parse(res);
						if (data.codigo === 1) {
							$("#quitarModal").modal('hide');
							$("#user").text(correo);
							$("#contrasena").text(data.msg);
							$("#respuesta_mail").text("* Un correo ha sido enviado al candidato con sus nuevas credenciales. Este correo puede demorar algunos minutos.");
							$("#passModal").modal('show');
							Swal.fire({
								position: 'center',
								icon: 'success',
								title: 'Se ha actualizado correctamente',
								showConfirmButton: false,
								timer: 2500
							})
						}
						if (data.codigo === 3) {
							$("#quitarModal").modal('hide')
							$("#user").text(correo);
							$("#contrasena").text(data.msg);
							$("#respuesta_mail").text("* El correo no pudo ser enviado, mandar las credenciales del candidato de forma manual.");
							$("#passModal").modal('show');
							Swal.fire({
								position: 'center',
								icon: 'warning',
								title: 'Se ha guardado correctamente pero no se envió el correo',
								showConfirmButton: false,
								timer: 2500
							})
						}
						
					}
				});
			}
			if (accion == 'delete') {
        let comentario = $('#mensaje_comentario').val();
				$.ajax({
					url: '<?php echo base_url('Candidato/cancelarCandidato'); ?>',
					type: 'post',
					data: {
						'id_candidato': id_candidato,
            'comentario':comentario
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
							$("#quitarModal").modal('hide');
							recargarTable()
							Swal.fire({
								position: 'center',
								icon: 'success',
								title: data.msg,
								showConfirmButton: false,
								timer: 2500
							})
						}
            else{
              Swal.fire({
                icon: 'error',
                title: 'Hubo un problema',
                html: data.msg,
                width: '50em',
                confirmButtonText: 'Cerrar'
              })
            }
					}
				});
			}
			if (accion == 'eliminarLaboral') {
				var id = $('#idElemento').val();
				var id_verificacion = $('#idElemento2').val();
				var num = $('#Numero').val();
				$('#candidato_reflaboral'+num)[0].reset();
				$('#analista_reflaboral'+num)[0].reset();
				$.ajax({
					url: '<?php echo base_url('Candidato/eliminarReferenciaLaboral'); ?>',
					type: 'post',
					data: {
						'id_candidato': id_candidato,
						'id':id,
						'id_verificacion':id_verificacion,
						'num':num
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
							$("#quitarModal").modal('hide');
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
		}
		function editarGap(id, id_candidato){
			var razon = $("#razon_gap"+id).val();
			var fi = $("#fecha_inicio_gap"+id).val();
			var ff = $("#fecha_fin_gap"+id).val();
			$.ajax({
				url: '<?php echo base_url('Candidato/editarGap'); ?>',
				method: 'POST',
				data: {'id':id,'id_candidato':id_candidato,'fi':fi,'ff':ff,'razon':razon},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res)
				{
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#error_gap"+id).css('display', 'none');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					else{
						$("#error_gap"+id).css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function confirmacionAccion(tipo_accion, seccion, id, id_candidato){
			if(seccion == 'gaps'){
				if(tipo_accion == 'eliminar'){
					$('#confirmarID').val(id);
					$('#idCandidato').val(id_candidato);
					$('#confirmarTipoAccion').val(tipo_accion);
					$('#confirmarSeccion').val(seccion);
					$('#titulo_confirmacion').text('Confirmar eliminación de GAP');
					$('#mensaje_confirmacion').text('¿Desea eliminar el GAP?');
				}
			}
			$('#confirmarAccionModal').modal('show');
		}
		function aceptarConfirmacion(tipo_accion, seccion, id, id_candidato){
			var id = $('#confirmarID').val();
			var id_candidato = $('#idCandidato').val();
			var tipo_accion = $('#confirmarTipoAccion').val();
			var seccion = $('#confirmarSeccion').val();
			if(seccion == 'gaps'){
				if(tipo_accion == 'eliminar'){
					$('#confirmarAccionModal').modal('hide');
					eliminarGap(id, id_candidato);
				}
			}
		}
		function eliminarGap(id, id_candidato){
			$("#gap" + id).remove();
			$.ajax({
				url: '<?php echo base_url('Candidato/eliminarGap'); ?>',
				method: 'POST',
				data: {
					'id': id,
					'id_candidato': id_candidato
				},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					if(res != ''){
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha eliminado correctamente',
							showConfirmButton: false,
							timer: 2500
						});
						$("#contenedor_gaps").empty();
						$("#contenedor_gaps").html(res);
					}
					else{
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha eliminado correctamente',
							showConfirmButton: false,
							timer: 2500
						});
						$("#contenedor_gaps").empty();
						$("#contenedor_gaps").html('<div class="col-12"><p class="text-center">Sin registros</p></div>');
						$("#gapsModal").modal('show');
					}
				}
			});
		}
		function actualizarPruebasCandidato(){
			var id_cliente = '<?php echo $this->uri->segment(3) ?>';
			var datos = new FormData();
			datos.append('id_candidato', $('#idCandidato').val());
			datos.append('antidoping', $('#prueba_antidoping').val());
			datos.append('psicometrico', $('#prueba_psicometrica').val());
			datos.append('medico', $('#prueba_medica').val());
			datos.append('id_cliente', id_cliente);
			
			$.ajax({
				url: '<?php echo base_url('Candidato/actualizarPruebasCandidato'); ?>',
				method: "POST",
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
						recargarTable();
						$('#pruebasModal').modal('hide');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						});
					}
					else {
						$("#pruebasModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		function confirmarEliminarLaboral(num){
			var id = $('#idreflabingles'+num).val();
			var id_verificacion = $('#idverlab'+num).val();
			var candidato = $('#Candidato').val();
			$("#idElemento").val(id);
			$("#idElemento2").val(id_verificacion);
			$("#Numero").val(num);
			$("#quitarModal #titulo_accion").text("Eliminar referencia laboral");
			$("#quitarModal #texto_confirmacion").html("¿Desea eliminar la referencia laboral #<b>"+num+"</b> de <b>"+candidato+"</b>? <br>* Esta acción también eliminará la verificación correspondiente");
			$("#quitarModal #btnGuardar").attr('value', 'eliminarLaboral');
			$("#quitarModal").modal("show");
		}
		function guardarFechaInicioProceso(){
			var id_candidato = $("#idCandidato").val();
			var fecha = $("#fecha_inicio_proceso").val();
			$.ajax({
				url: '<?php echo base_url('Candidato/guardarFechaInicio'); ?>',
				method: 'POST',
				data: {'id_candidato':id_candidato,'fecha':fecha},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res){
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#fechaInicioModal #msj_error").css('display', 'none');
						$("#fechaInicioModal").modal('hide');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
					else{
						$("#fechaInicioModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
		//Funciones de apoyo
		function regresarListado(){
			/*$('.es_reflab').val('');
			$('.es_verlab').val('');
			$('.aplicar_todo').val(-1);
			$('.caracteristica').val('Not provided');
			$("#formulario").css('display', 'none');
			$("#btn_regresar").css('display', 'none');
			$(".btnRegresar").css('display', 'none');
			$("#listado").css('display', 'block');
			$("#btn_nuevo").css('display', 'block');*/
			location.reload();
		}
		function aceptarRevision(){
			$("#revisionModal").modal('hide');
			$("#completarModal").modal('show');
		}
		function recargarTable(){
    	$("#tabla").DataTable().ajax.reload();
  	}
		$(".aplicar_todo").change(function(){
  		var id = $(this).attr('id');
  		var aux = id.split('aplicar_todo');
  		var num = aux[1];
  		var valor = $('#'+id).val();
  		switch(valor){
  			case "-1":
					$(".performance"+num).val("Not provided");
					break;
				case "0":
					$(".performance"+num).val("Not provided");
					break;
				case "1":
					$(".performance"+num).val("Excellent");
					break;
				case "2":
					$(".performance"+num).val("Good");
					break;
				case "3":
					$(".performance"+num).val("Regular");
					break;
				case "4":
					$(".performance"+num).val("Bad");
					break;
				case "5":
					$(".performance"+num).val("Very Bad");
					break;
  		}
  	});
		function respaldoTxt(formdata,nombreArchivo){      
	    var textFileAsBlob = new Blob([formdata], {type:'text/plain'});
	    var fileNameToSaveAs = nombreArchivo+".txt";
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
		function destroyClickedElement(event){
			document.body.removeChild(event.target);
		}
		function getMunicipioDomicilio(id_estado, id_municipio, num, tipo){
			$.ajax({
				url: '<?php echo base_url('Funciones/getMunicipios'); ?>',
				method: 'POST',
				data: {'id_estado':id_estado},
				dataType: "text",
				success: function(res){
					if(tipo == 'custom'){
						$('#custom_municipio'+num).prop('disabled', false);
						$('#custom_municipio'+num).html(res);
						$("#custom_municipio"+num).find('option').attr("selected",false) ;
						$('#custom_municipio'+num+' option[value="'+id_municipio+'"]').attr('selected', 'selected');
					}
					if(tipo == 'general'){
						$('#address_municipio'+num).prop('disabled', false);
						$('#address_municipio'+num).html(res);
						$("#address_municipio"+num).find('option').attr("selected",false) ;
						$('#address_municipio'+num+' option[value="'+id_municipio+'"]').attr('selected', 'selected');
					}
				}
			});
		}
		function getMunicipio(id_estado, id_municipio){
			$.ajax({
				url: '<?php echo base_url('Funciones/getMunicipios'); ?>',
				method: 'POST',
				data: {'id_estado':id_estado},
				success: function(res){
						$('#municipio').prop('disabled', false);
						$('#municipio').html(res);
						$("#municipio").find('option').attr("selected",false) ;
						$('#municipio option[value="'+id_municipio+'"]').attr('selected', 'selected');
				}
			});
		}
		function convertirFechaEspanol(fecha){
  		var aux = fecha.split(' ');
  		var time = aux[0].split('-');
    	var dia = time[2]+'/'+time[1]+'/'+time[0];
    	return dia;
  	}
		function convertirDate(fecha){
  		var aux = fecha.split('-');
    	var f = aux[1]+'/'+aux[2]+'/'+aux[0];
    	return f;
  	}
		function fechaFormEspanol(fecha){
  		var aux = fecha.split('-');
    	var f = aux[2]+'/'+aux[1]+'/'+aux[0];
    	return f;
  	}









	
	
	
	
		
	function checkOfac(){
		var id_candidato = $("#idCandidato").val();
		$.ajax({
      		url: '<?php echo base_url('Candidato/verificarOfacCandidato'); ?>',
      		method: 'POST',
      		data: {'id_candidato':id_candidato},
      		dataType: "text",
      		success: function(res)
      		{
      			if(res == 0){
      				$("#ofac_incompleto").css('display','initial');
  					$("#ofac_completo").css('display','none');
  					$("#ofac_msjIncompleto").text("Faltan datos o los archivos de la verificación de OFAC y OIG");
  					$("#btnOfac").css('display','none');
  					$("#completarOfacModal").modal('show');
      			}
      			else{
  					$("#ofac_completo").css('display','block');
  					$("#ofac_incompleto").css('display','initial');
  					$("#btnOfac").css('display','initial');
  					$("#completarOfacModal").modal('show');
      			}
      		},error:function(res)
      		{
        		//$('#errorModal').modal('show');
      		}
    	});
	}
	
  function verMensajesAvances(id_candidato, candidato){
    $('#avancesModal #nombreCandidato').text(candidato)
    $("#idCandidato").val(id_candidato);
		getMensajesAvances(id_candidato, candidato);
		$("#avancesModal").modal("show");
  }
  function getMensajesAvances(id_candidato, candidato){
    $("#divMensajesAvances").empty();
    $.ajax({
			url: '<?php echo base_url('Candidato/checkAvances'); ?>',
			method: 'POST',
			data: {
				'id_candidato': id_candidato
			},
			beforeSend: function() {
				$('.loader').css("display", "block");
			},
			success: function(res) {
				setTimeout(function() {
					$('.loader').fadeOut();
				}, 200);
        $("#divMensajesAvances").html(res)
			}
		});
  }
  function crearAvance() {
    let id_candidato = $("#idCandidato").val()
    let candidato = $('#avancesModal #nombreCandidato').text()
		var datos = new FormData();
		datos.append('id_candidato', id_candidato);
		datos.append('comentario', $("#mensaje_avance").val());
		datos.append('adjunto', $("#adjunto")[0].files[0]);
		$.ajax({
			url: '<?php echo base_url('Candidato/createEstatusAvance'); ?>',
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
				var dato = JSON.parse(res);
				if (dato.codigo === 1) {
					$("#adjunto").val('');
					$("#mensaje_avance").val('');
					getMensajesAvances(id_candidato, candidato);
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: dato.msg,
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					Swal.fire({
            icon: 'error',
            title: 'Hubo un problema',
            html: dato.msg,
            width: '50em',
            confirmButtonText: 'Cerrar'
          })
				}
			}
		});
	}
  function confirmarEditarAvance(id){
    let msj = $('#avanceMensaje'+id).val();
    let archivo = $('#avanceArchivo'+id).val();
    let msj_archivo = '';
    let file = document.getElementById('avanceArchivo'+id);   
    if(file.files.length > 0){
      let filename = file.files[0].name;
      msj_archivo = (archivo !== '')? '<br>¿Y la imagen? <br><b>'+filename+'</b>' : '';
    }
    $('#titulo_mensaje').text('Confirmar modificación de mensaje de avance');
		$('#mensaje').html('¿Desea confirmar el mensaje? <br><b>"'+msj+'"</b>'+msj_archivo);
		$('#btnConfirmar').attr("onclick","editarAvance("+id+",\""+msj+"\")");
		$('#mensajeModal').modal('show');
  }
  function editarAvance(id, msj){
    let id_candidato = $("#idCandidato").val()
    let candidato = $('#avancesModal #nombreCandidato').text()
    let datos = new FormData();
		datos.append('id', id);
		datos.append('msj', msj);
		datos.append('archivo', $("#avanceArchivo"+id)[0].files[0]);
    $.ajax({
      url: '<?php echo base_url('Avance/editar'); ?>',
      async: false,
      type: 'post',
      data: datos,
			contentType: false,
			cache: false,
			processData: false,
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
		    $('#mensajeModal').modal('hide');
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 300);
        var dato = JSON.parse(res);
        if(dato.codigo === 1){
		      getMensajesAvances(id_candidato, candidato);
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: dato.msg,
            showConfirmButton: false,
            timer: 2500
          })
        }
      }
    });
  }
  function confirmarEliminarAvance(id){
    let msj = $('#avanceMensaje'+id).val();
    $('#titulo_mensaje').text('Confirmar eliminar mensaje de avance');
		$('#mensaje').html('¿Desea eliminar el mensaje? <br><b>"'+msj+'"</b>');
		$('#btnConfirmar').attr("onclick","eliminarAvance("+id+")");
		$('#mensajeModal').modal('show');
  }
  function eliminarAvance(id){
    let id_candidato = $("#idCandidato").val()
    let candidato = $('#avancesModal #nombreCandidato').text()
    $.ajax({
      url: '<?php echo base_url('Avance/eliminar'); ?>',
      type: 'POST',
      data: {'id':id},
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
		    $('#mensajeModal').modal('hide');
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 300);
        var dato = JSON.parse(res);
        if(dato.codigo === 1){
		      getMensajesAvances(id_candidato, candidato);
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: dato.msg,
            showConfirmButton: false,
            timer: 2500
          })
        }
      }
    });
  }
	
	
		
  	function convertirDateTime(fecha){
  		var aux = fecha.split(' ');
  		var time = aux[0].split('-');
    	var dia = time[1]+'/'+time[2]+'/'+time[0];
    	return dia;
  	}
  	
  	//Regresa del formulario al listado
  	function regresar(){
  		$("#listado").css('display','block');
  		$("#btn_regresar").css('display','none'); 
  		$("#formulario").css('display','none');
  	}
  	
  	//Se crea la variable para establecer la fecha actual
  	var hoy = new Date();
  	var dd = hoy.getDate();
  	var mm = hoy.getMonth()+1;
  	var yyyy = hoy.getFullYear();
  	var hora = hoy.getHours()+":"+hoy.getMinutes();

  	if(dd<10) {
      	dd='0'+dd;
  	} 

  	if(mm<10) {
      	mm='0'+mm;
  	}
</script>