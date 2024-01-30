<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Cliente: <small><?php echo $cliente; ?></small></h1><br>
		<a href="#" class="btn btn-primary btn-icon-split" id="btn_nuevo" onclick="nuevoRegistro()">
			<span class="icon text-white-50">
				<i class="fas fa-plus-circle"></i>
			</span>
			<span class="text">Registrar candidato</span>
		</a>
		<a href="#" class="btn btn-primary btn-icon-split" id="btn_asignacion" data-toggle="modal" data-target="#asignarCandidatoModal">
			<span class="icon text-white-50">
				<i class="fas fa-plus-circle"></i>
			</span>
			<span class="text">Asignacion de candidato</span>
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
	<input type="hidden" id="idCandidato">
	<input type="hidden" id="idCliente">
	<input type="hidden" id="idDoping">
	<input type="hidden" class="prefijo">
	<input type="hidden" id="idFinalizado">
	<input type="hidden" id="idVecinal">
	<input type="hidden" id="numVecinal">

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
					<h4 class="text-primary"><strong> Referencias Laborales </strong></h4><br><br>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-warning"><h4 class="text-center">¿Cómo se enteró del trabajo en <span class="nombreCliente"></span>?</h4></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<textarea class="form-control trabajo_gobierno" name="trabajo_enterado" id="trabajo_enterado" rows="2"></textarea><br><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-warning"><h4 class="text-center">¿El candidato tiene familiares, amigos o conocidos trabajando en <span class="nombreCliente"></span>? (En caso de no haber registros se completará automáticamente en el reporte final)</h4></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<label>Nombre de la primera persona</label>
				<input type="text" class="form-control trabajo_gobierno" name="persona_trabajo_nombre1" id="persona_trabajo_nombre1" >
				<input type="hidden" id="idpersonatrabajo1">
				<br>
			</div>
			<div class="col-md-3">
				<label>Puesto de la primera persona</label>
				<input type="text" class="form-control trabajo_gobierno" name="persona_trabajo_puesto1" id="persona_trabajo_puesto1" >
				<br>
			</div>
			<div class="col-md-3">
				<label>Nombre de la segunda persona</label>
				<input type="text" class="form-control trabajo_gobierno" name="persona_trabajo_nombre2" id="persona_trabajo_nombre2" >
				<input type="hidden" id="idpersonatrabajo2">
				<br>
			</div>
			<div class="col-md-3">
				<label>Puesto de la segunda persona</label>
				<input type="text" class="form-control trabajo_gobierno" name="persona_trabajo_puesto2" id="persona_trabajo_puesto2" >
				<br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-warning"><h4 class="text-center">¿Has trabajado en alguna entidad de gobierno, partido político u ONG?</h4></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<textarea class="form-control trabajo_gobierno" name="trabajo_gobierno" id="trabajo_gobierno" rows="2"></textarea><br><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 offset-4">
				<button type="button" class="btn btn-success" onclick="actualizarTrabajoGobierno()">Guardar respuestas anteriores</button>
				<br><br>
			</div>
			<div class="col-md-2">
				<button type="button" class="btn btn-secondary" onclick="regresarListado()">Regresar al listado</button>
				<br><br><br><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="trabajos_msj_error" class="alert alert-danger hidden"></div>
			</div>
		</div>
		<?php
		for ($i = 1; $i <= 10; $i++) { ?>
			<div class="text-center">
				<h4 class="box-title"><strong><?php echo 'Trabajo #'.$i; ?></strong><hr></h4>
			</div>';
			<div class="row">
				<div class="col-6">
					<form id="candidato_reflaboral<?php echo $i; ?>">
						<div class="alert alert-info"><h4 class="text-center">Candidato</h4></div>
						<div class="row">
							<div class="col-md-3">
								<label>Compañía: </label>
								<br>
							</div>
							<div class="col-9">
								<input type="text" class="form-control" name="reflab<?php echo $i; ?>_empresa" id="reflab<?php echo $i; ?>_empresa" >
						<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Dirección: </label>
								<br>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="reflab<?php echo $i; ?>_direccion" id="reflab<?php echo $i; ?>_direccion">
						<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Fecha de entrada: </label>
								<br>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control fecha_laboral" name="reflab<?php echo $i; ?>_entrada" id="reflab<?php echo $i; ?>_entrada">
						<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Fecha de salida: </label>
								<br>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control fecha_laboral" name="reflab<?php echo $i; ?>_salida" id="reflab<?php echo $i; ?>_salida">
						<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Teléfono: </label>
								<br>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control solo_numeros" name="reflab<?php echo $i; ?>_telefono" id="reflab<?php echo $i; ?>_telefono" maxlength="10">
						<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Puesto inicial: </label>
								<br>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="reflab<?php echo $i; ?>_puesto1" id="reflab<?php echo $i; ?>_puesto1">
						<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Puesto final: </label>
								<br>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="reflab<?php echo $i; ?>_puesto2" id="reflab<?php echo $i; ?>_puesto2">
						<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Salario inicial: </label>
								<br>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control solo_numeros" name="reflab<?php echo $i; ?>_salario1" id="reflab<?php echo $i; ?>_salario1">
						<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Salario final: </label>
								<br>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control solo_numeros" name="reflab<?php echo $i; ?>_salario2" id="reflab<?php echo $i; ?>_salario2">
						<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Jefe inmediato: </label>
								<br>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="reflab<?php echo $i; ?>_jefenombre" id="reflab<?php echo $i; ?>_jefenombre">
						<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Correo del jefe inmediato: </label>
								<br>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="reflab<?php echo $i; ?>_jefecorreo" id="reflab<?php echo $i; ?>_jefecorreo">
						<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Puesto del jefe inmediato:</label>
								<br>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="reflab<?php echo $i; ?>_jefepuesto" id="reflab<?php echo $i; ?>_jefepuesto">
						<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<label>Causa de separación: </label>
								<br>
							</div>
							<div class="col-md-9">
								<input type="text" class="form-control" name="reflab<?php echo $i; ?>_separacion" id="reflab<?php echo $i; ?>_separacion">
						<br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 offset-md-4">
								<button type="button" class="btn btn-success" id="btnLaboral<?php echo $i; ?>" onclick="guardarReferenciaLaboral(<?php echo $i; ?>,0)">Guardar referencia laboral</button><br><br><br><br>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div id="reflab_msj_error<?php echo $i; ?>" class="alert alert-danger hidden"></div>
							</div>
						</div>
					</form>
				</div>
				<div class="col-6">
					<form id="analista_reflaboral<?php echo $i; ?>">
					<div class="alert alert-warning">
						<h4 class="text-center">Analista</h4>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Compañía: </label>
							<br>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control" name="an_reflab<?php echo $i; ?>_empresa" id="an_reflab<?php echo $i; ?>_empresa">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Dirección: </label>
							<br>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control" name="an_reflab<?php echo $i; ?>_direccion" id="an_reflab<?php echo $i; ?>_direccion">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Fecha de entrada: </label>
							<br>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control fecha_laboral" name="an_reflab<?php echo $i; ?>_entrada" id="an_reflab<?php echo $i; ?>_entrada">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Fecha de salida: </label>
							<br>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control fecha_laboral" name="an_reflab<?php echo $i; ?>_salida" id="an_reflab<?php echo $i; ?>_salida">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Teléfono: </label>
							<br>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control solo_numeros" name="an_reflab<?php echo $i; ?>_telefono" id="an_reflab<?php echo $i; ?>_telefono" maxlength="10">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Puesto inicial: </label>
							<br>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control" name="an_reflab<?php echo $i; ?>_puesto1" id="an_reflab<?php echo $i; ?>_puesto1">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Puesto final: </label>
							<br>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control" name="an_reflab<?php echo $i; ?>_puesto2" id="an_reflab<?php echo $i; ?>_puesto2">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Salario inicial: </label>
							<br>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control" name="an_reflab<?php echo $i; ?>_salario1" id="an_reflab<?php echo $i; ?>_salario1">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Salario final: </label>
							<br>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control" name="an_reflab<?php echo $i; ?>_salario2" id="an_reflab<?php echo $i; ?>_salario2">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Jefe inmediato: </label>
							<br>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control" name="an_reflab<?php echo $i; ?>_jefenombre" id="an_reflab<?php echo $i; ?>_jefenombre">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Correo del jefe inmediato: </label>
							<br>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control" name="an_reflab<?php echo $i; ?>_jefecorreo" id="an_reflab<?php echo $i; ?>_jefecorreo">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Puesto del jefe inmediato: </label>
							<br>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control" name="an_reflab<?php echo $i; ?>_jefepuesto" id="an_reflab<?php echo $i; ?>_jefepuesto">
							<br>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<label>Causa de separación: </label>
							<br>
						</div>
						<div class="col-md-9">
							<input type="text" class="form-control" name="an_reflab<?php echo $i; ?>_separacion" id="an_reflab<?php echo $i; ?>_separacion">
							<br>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<label>Fortalezas o cualidades del candidato *</label>
					<textarea class="form-control" name="an_reflab<?php echo $i; ?>_cualidades" id="an_reflab<?php echo $i; ?>_cualidades" rows="3"></textarea><br>
				</div>
				<div class="col-md-6">
					<label>Áreas a mejorar del candidato *</label>
					<textarea class="form-control" name="an_reflab<?php echo $i; ?>_mejoras" id="an_reflab<?php echo $i; ?>_mejoras" rows="3"></textarea><br>
				</div>
				<div class="col-md-12">
					<label>Referencia *</label>
					<textarea class="form-control" name="an_reflab<?php echo $i; ?>_comentarios" id="an_reflab<?php echo $i; ?>_comentarios" rows="3"></textarea><br>
				</div>
				</form>
				<div class="col-md-3 offset-md-3">
					<button type="button" class="btn btn-success" id="btnVerificacion<?php echo $i; ?>" onclick="guardarVerificacionLaboral(<?php echo $i; ?>,0)">Guardar la verificación del trabajo #<?php echo $i; ?></button>
					<br><br>
				</div>
				<div class="col-md-3">
					<button type="button" class="btn btn-secondary" onclick="regresarListado()">Regresar al listado</button>
					<br><br><br><br>
				</div>
				<div class="col-12">
					<div id="verlab_msj_error<?php echo $i; ?>" class="alert alert-danger hidden"></div>
				</div>
			</div>';
		<?php 
		}
		?>
	</section>
</div>
<!-- /.content-wrapper -->
<script>
	var id = '<?php echo $this->uri->segment(3) ?>';
	var url = '<?php echo base_url('Cliente_Monex/getCandidatos?id='); ?>' + id;
	var psico = '<?php echo base_url(); ?>_psicometria/';
	var parentescos_php = '<?php foreach($parentescos as $p){ echo '<option value="'.$p->id.'">'.$p->nombre.'</option>';} ?>';
	var civiles_php = '<?php foreach($civiles as $c){ echo '<option value="'.$c->nombre.'">'.$c->nombre.'</option>';} ?>';
	var escolaridades_php = '<?php foreach($escolaridades as $e){ echo '<option value="'.$e->id.'">'.$e->nombre.'</option>';} ?>';
	
	$(document).ready(function() {
		//inputmask
		$('#fecha_nacimiento, #fecha_acta, #fecha_domicilio, #fecha_imss, #fecha_curp, #fecha_retencion, #fecha_rfc, #fecha_licencia, #fecha_migra, #fecha_visa').inputmask('dd/mm/yyyy', {
			'placeholder': 'dd/mm/yyyy'
		});
		$('#fecha_ine').inputmask('yyyy', {
			'placeholder': 'yyyy'
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
		$('#tabla').DataTable({
			"pageLength": 25,
			//"pagingType": "simple",
			"order": [0, "desc"],
			"stateSave": true,
			"serverSide": false,
			"ajax": url,
			"columns": [{
					title: 'id',
					data: 'id',
					visible: false
				},
				{
					title: 'Candidato',
					data: 'candidato',
					bSortable: false,
					"width": "15%",
					mRender: function(data, type, full) {
						var analista = (full.usuario == null | full.usuario == '') ? '<small><b>(Sin definir)</b></small>' : '<small><b>('+full.usuario+')</b></small>';
						return '<a data-toggle="tooltip" class="sin_vinculo" title="' + full.id + '">' + data + '</a><br>'+analista;
					}
				},
				{
					title: 'Fechas',
					data: 'fecha_alta',
					bSortable: false,
					"width": "13%",
					mRender: function(data, type, full) {
						if (full.id_subcliente != 180) {
							var f = data.split(' ');
							var h = f[1];
							var aux = h.split(':');
							var hora = aux[0] + ':' + aux[1];
							var aux = f[0].split('-');
							var fecha = aux[2] + "/" + aux[1] + "/" + aux[0];
							var f_inicio = fecha + ' ' + hora;
							if (full.fecha_final != null) {
								var f = full.fecha_final.split(' ');
								var h = f[1];
								var aux = h.split(':');
								var hora = aux[0] + ':' + aux[1];
								var aux = f[0].split('-');
								var fecha = aux[2] + "/" + aux[1] + "/" + aux[0];
								var f_fin = "Final: " + fecha + ' ' + hora;
								return "Alta: " + f_inicio + '<br>' + f_fin;
							} else {
								var f = new Date();
								var hoy = f.getDate() + "/" + (f.getMonth() + 1) + "/" + f.getFullYear();
								return "Alta: " + f_inicio + '<br>Final: -';
							}
						} else {
							var f = data.split(' ');
							var h = f[1];
							var aux = h.split(':');
							var hora = aux[0] + ':' + aux[1];
							var aux = f[0].split('-');
							var fecha = aux[2] + "/" + aux[1] + "/" + aux[0];
							var f_inicio = fecha + ' ' + hora;
							if (full.fecha_final_ingles != null) {
								var f = full.fecha_final_ingles.split(' ');
								var h = f[1];
								var aux = h.split(':');
								var hora = aux[0] + ':' + aux[1];
								var aux = f[0].split('-');
								var fecha = aux[2] + "/" + aux[1] + "/" + aux[0];
								var f_fin = "Final: " + fecha + ' ' + hora;
								return "Alta: " + f_inicio + '<br>' + f_fin;
							} else {
								var f = new Date();
								var hoy = f.getDate() + "/" + (f.getMonth() + 1) + "/" + f.getFullYear();
								return "Alta: " + f_inicio + '<br>Final: -';
							}
						}
					}
				},
				{
					title: 'SLA',
					data: 'tiempo',
					bSortable: false,
					"width": "8%",
					mRender: function(data, type, full) {
						if(full.cancelado == 0){
							if (full.id_tipo_proceso == 1) {
								if (data != null) {
									if (data != -1) {
										if (data >= 0 && data <= 2) {
											return res = '<div class="formato_dias dias_verde">' + data + ' días</div>';
										}
										if (data > 2 && data <= 4) {
											return res = '<div class="formato_dias dias_amarillo">' + data + ' días</div>';
										}
										if (data >= 5) {
											return res = '<div class="formato_dias dias_rojo">' + data + ' días</div>';
										}
									} else {
										return "Actualizando...";
									}
								} else {
									if (full.tiempo_parcial != 0) {
										var parcial = full.tiempo_parcial;
										if (parcial >= 0 && parcial < 2) {
											return res = '<div class="formato_dias dias_verde">' + parcial + ' días</div>';
										}
										if (parcial >= 2 && parcial <= 4) {
											return res = '<div class="formato_dias dias_amarillo">' + parcial + ' días</div>';
										}
										if (parcial >= 5) {
											return res = '<div class="formato_dias dias_rojo">' + parcial + ' días</div>';
										}
									} else {
										return "Actualizando...";
									}
								}
							} else {
								if (full.tiempo_ingles != null) {
									if (full.tiempo_ingles != -1) {
										if (full.tiempo_ingles >= 0 && full.tiempo_ingles <= 2) {
											return res = '<div class="formato_dias dias_verde">' + full.tiempo_ingles + ' días</div>';
										}
										if (full.tiempo_ingles > 2 && full.tiempo_ingles <= 4) {
											return res = '<div class="formato_dias dias_amarillo">' + full.tiempo_ingles + ' días</div>';
										}
										if (full.tiempo_ingles >= 5) {
											return res = '<div class="formato_dias dias_rojo">' + full.tiempo_ingles + ' días</div>';
										}
									} else {
										return "Actualizando...";
									}
								} else {
									if (full.tiempo_parcial != 0) {
										var parcial = full.tiempo_parcial;
										if (parcial >= 0 && parcial < 2) {
											return res = '<div class="formato_dias dias_verde">' + parcial + ' días</div>';
										}
										if (parcial >= 2 && parcial <= 4) {
											return res = '<div class="formato_dias dias_amarillo">' + parcial + ' días</div>';
										}
										if (parcial >= 5) {
											return res = '<div class="formato_dias dias_rojo">' + parcial + ' días</div>';
										}
									} else {
										return "Actualizando...";
									}
								}
							}
						}
						else{
							return 'N/A';
						}
					}
				},
				{
					title: 'Acciones',
					data: 'id',
					bSortable: false,
					"width": "3%",
					mRender: function(data, type, full) {
						if(full.cancelado == 0){
							return '<a href="javascript:void(0)" id="msj_avances" class="fa-tooltip icono_datatable"><i class="fas fa-comment-dots"></i></a> <a href="javascript:void(0)" id="editar_pruebas" class="fa-tooltip icono_datatable"><i class="fas fa-edit"></i></a>';
						}
						else{
							return 'N/A';
						}
					}
				},
				{
					title: 'Estudio',
					data: 'secciones',
					bSortable: false,
					"width": "13%",
					mRender: function(data, type, full) {
						if(full.cancelado == 0){
							if(full.socioeconomico == 1){
								if(data != null){
									var salida = '';
									var gaps = '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0)" id="datos_gaps">GAPS</a>';
									var contenedor_inicial = '<div class="btn-group"  style="margin-bottom: 10px;"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'+full.proyectoSeccion+'</button><div class="dropdown-menu">';
									var contenedor_final = '</div></div>';
									var separador = '<div class="dropdown-divider"></div>';
									var resto = '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0)" id="subirDocs">Documentación</a>';
									var conclusiones = '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0)" id="conclusiones">Conclusiones</a>';
									var cancelar = '<div class="dropdown-divider"></div><a class="dropdown-item" href="javascript:void(0)" id="eliminar">Cancelar proceso</a></div></div>';
									var liberar = (full.liberado == 0)? '<a class="dropdown-item" href="javascript:void(0)" style="background: lightgreen;color:gray;" id="liberar">Liberar reporte</a>' : '<a class="dropdown-item" href="javascript:void(0)" style="background:indianred;color:white;" id="detener">Detener reporte</a>';
									salida += contenedor_inicial+data;
									var lleva_gaps = (full.lleva_gaps == 1)? gaps+separador:'';
									salida += lleva_gaps;
									if(full.status == 0 || full.status == 1){
										salida += resto+cancelar+contenedor_final;
									}
									if(full.status == 2){
										salida += resto+conclusiones+liberar+cancelar+contenedor_final;
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
				{
					title: 'Visita',
					data: 'seccion_visita',
					bSortable: false,
					"width": "10%",
					mRender: function(data, type, full) {
						if(full.cancelado == 0){
							if (data != null) {
								return '<div class="btn-group"  style="margin-bottom: 10px;"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Datos de la visita</button><div class="dropdown-menu">'+data+'</div></div>';
							} 
							else {
								return 'N/A';
							}
						}
						else{
							return 'N/A';
						}
					}
				},
				{
					title: 'Médico',
					data: 'id',
					bSortable: false,
					width: '6%',
					mRender: function(data, type, full) {
						if(full.cancelado == 0){
							if (full.medico == 1) {
								if(full.idMedico != null){
									if (full.conclusion != null && full.descripcion != null) {
										return '<div style="display: inline-block;"><form id="formMedico' + full.idMedico + '" action="<?php echo base_url('Medico/crearPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final" id="pdfMedico" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idMedico" id="idMedico' + full.idMedico + '" value="' + full.idMedico + '"></form></div>';
									} 
									else {
										return "<i class='fas fa-circle status_bgc3'></i> En proceso";
									}
								}
								else{
									return "<i class='fas fa-circle status_bgc0'></i> Pendiente";
								}
							} 
							else {
								return "N/A";
							}
						}
						else {
							return "N/A";
						}
					}
				},
				{
					title: 'Psicometrico',
					data: 'id',
					bSortable: false,
					"width": "13%",
					mRender: function(data, type, full) {
						if(full.cancelado == 0){
							if (full.psicometrico == 1) {
								if (full.archivo != null && full.archivo != "") {
									return '<a href="javascript:void(0)" data-toggle="tooltip" title="Subir psicometria" id="psicometria" class="fa-tooltip icono_datatable"><i class="fas fa-brain"></i></a> <a href="' + psico + full.archivo + '" target="_blank" data-toggle="tooltip" title="Ver psicometria" id="descarga_psicometrico" class="fa-tooltip icono_datatable"><i class="fas fa-file-powerpoint"></i></a>';
								} else {
									return '<a href="javascript:void(0)" data-toggle="tooltip" title="Subir psicometria" id="psicometria" class="fa-tooltip icono_datatable"><i class="fas fa-brain"></i></a>';
								}
							} else {
								return "N/A";
							}
						}
						else {
							return "N/A";
						}
					}
				},
				{
					title: 'Antidoping',
					data: 'id',
					bSortable: false,
					"width": "13%",
					mRender: function(data, type, full) {
						if(full.cancelado == 0){
							if (full.tipo_antidoping == 1) {
								if(full.doping_hecho == 1){
									if (full.fecha_resultado != null && full.fecha_resultado != "") {
										if (full.resultado_doping == 1) {
											return '<i class="fas fa-circle status_bgc2"></i> <div style="display: inline-block;"><form id="pdfForm' + full.idDoping + '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado" id="pdfDoping" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' + full.idDoping + '" value="' + full.idDoping + '"></form></div>';
										} else {
											return '<i class="fas fa-circle status_bgc1"></i> <div style="display: inline-block;"><form id="pdfForm' + full.idDoping + '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado" id="pdfDoping" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' + full.idDoping + '" value="' + full.idDoping + '"></form></div>';
										}

									} else {
										return "Pendiente";
									}
								}else {
									return "Pendiente";
								}
							}
							if (full.tipo_antidoping == 0) {
								return "N/A";
							}
						}
						else{
							return 'N/A';
						}
					}
				},
				{
					title: 'Resultado',
					data: 'id',
					bSortable: false,
					"width": "12%",
					mRender: function(data, type, full) {
						if(full.cancelado == 0){
							var previo = '<div style="display: inline-block;"><form id="formPrevio'+data+'" action="<?php echo base_url('Cliente_Monex/crearPrevioPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte previo" id="pdfPrevio" class="fa-tooltip icono_datatable"><i class="far fa-file-powerpoint"></i></a><input type="hidden" name="idPrevio" id="idPrevio'+data+'" value="'+data+'"></form></div>';
							if (full.status == 0) {
								return '<a href="javascript:void(0)" data-toggle="tooltip" title="Finalizar proceso del candidato" id="final" class="fa-tooltip icono_datatable"><i class="fas fa-user-check"></i></a> '+previo;
							} 
							else {
								if (full.status_bgc == 0) {
									return '<a href="javascript:void(0)" data-toggle="tooltip" title="Finalizar proceso del candidato" id="final" class="fa-tooltip icono_datatable"><i class="fas fa-user-check"></i></a>';
								}
								if (full.status_bgc == 1) {
									return '<i class="fas fa-circle status_bgc1"></i><div style="display: inline-block;"><form id="pdf' + data + '" action="<?php echo base_url('Cliente_Monex/crearPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final" id="pdfFinal" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idPDF" id="idPDF' + data + '" value="' + data + '"></form></div>';
								}
								if (full.status_bgc == 2) {
									return '<i class="fas fa-circle status_bgc2"></i><div style="display: inline-block;"><form id="pdf' + data + '" action="<?php echo base_url('Cliente_Monex/crearPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final" id="pdfFinal" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idPDF" id="idPDF' + data + '" value="' + data + '"></form></div>';
								}
								if (full.status_bgc == 3) {
									return '<i class="fas fa-circle status_bgc3"></i><div style="display: inline-block;"><form id="pdf' + data + '" action="<?php echo base_url('Cliente_Monex/crearPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final" id="pdfFinal" class="fa-tooltip icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idPDF" id="idPDF' + data + '" value="' + data + '"></form></div>';
								}
							}
						}
						else{
							return 'N/A';
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
				$('a#datos_generales_b', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$("#nombre_general").val(data.nombre);
					$("#paterno_general").val(data.paterno);
					$("#materno_general").val(data.materno);
					if (data.fecha_nacimiento != "" && data.fecha_nacimiento != null) {
						var f_nacimiento = convertirDate(data.fecha_nacimiento);
						$("#fecha_nacimiento").val(f_nacimiento);
					} else {
						$("#fecha_nacimiento").val("");
					}
					$("#puesto_general").val(data.id_puesto);
					$("#nacionalidad").val(data.nacionalidad);
					$("#genero").val(data.genero);
					$("#calle").val(data.calle);
					$("#exterior").val(data.exterior);
					$("#interior").val(data.interior);
					$("#colonia").val(data.colonia);
					$("#calles").val(data.entre_calles);
					$("#estado").val(data.id_estado);
					if (data.id_estado != "" && data.id_estado != null && data.id_estado != 0) {
						getMunicipio(data.id_estado, data.id_municipio);
					} else {
						$('#municipio').prop('disabled', true);
					}
					$("#cp").val(data.cp);
					$("#civil").val(data.estado_civil);
					$("#celular_general").val(data.celular);
					$("#tel_casa").val(data.telefono_casa);
					$("#grado").val(data.id_grado_estudio);
					$("#tel_oficina").val(data.telefono_otro);
					$("#personales_correo").val(data.correo);
					$("#tiempo_dom_actual").val(data.tiempo_dom_actual);
					$("#tiempo_traslado").val(data.tiempo_traslado);
					$("#medio_transporte").val(data.tipo_transporte);
					$("#correo_general").val(data.correo);
					$("#generalesModal").modal('show');
				});
				$('a#datos_academicos', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$.ajax({
            url: '<?php echo base_url('Candidato_Estudio/getHistorialById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != null){
								var data = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#prim_periodo").val(data.primaria_periodo);
								$("#prim_escuela").val(data.primaria_escuela);
								$("#prim_ciudad").val(data.primaria_ciudad);
								$("#prim_certificado").val(data.primaria_certificado);
								$("#prim_promedio").val(data.primaria_promedio);
								$("#sec_periodo").val(data.secundaria_periodo);
								$("#sec_escuela").val(data.secundaria_escuela);
								$("#sec_ciudad").val(data.secundaria_ciudad);
								$("#sec_certificado").val(data.secundaria_certificado);
								$("#sec_promedio").val(data.secundaria_promedio);
								$("#prep_periodo").val(data.preparatoria_periodo);
								$("#prep_escuela").val(data.preparatoria_escuela);
								$("#prep_ciudad").val(data.preparatoria_ciudad);
								$("#prep_certificado").val(data.preparatoria_certificado);
								$("#prep_promedio").val(data.preparatoria_promedio);
								$("#lic_periodo").val(data.licenciatura_periodo);
								$("#lic_escuela").val(data.licenciatura_escuela);
								$("#lic_ciudad").val(data.licenciatura_ciudad);
								$("#lic_certificado").val(data.licenciatura_certificado);
								$("#lic_promedio").val(data.licenciatura_promedio);
								$("#otro_certificado").val(data.otros_certificados);
								$("#estudios_comentarios").val(data.comentarios);
								$("#carrera_inactivo").val(data.carrera_inactivo);
								$("#academicosModal").modal('show');
							}
							else{
								$('#formHistorialEstudios')[0].reset();
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#academicosModal").modal('show');
							}
            }
          });
				});
				$('a#datos_mayores_estudios', row).bind('click', () => {
          $("#idCandidato").val(data.id);
          $(".nombreCandidato").text(data.candidato);
          
					$.ajax({
            url: '<?php echo base_url('Candidato_Estudio/getMayorById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != null){
								var data = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#mayor_estudios_candidato").val(data.id_grado_estudio);
								$("#periodo_candidato").val(data.estudios_periodo);
								$("#escuela_candidato").val(data.estudios_escuela);
								$("#ciudad_candidato").val(data.estudios_ciudad);
								$("#certificado_candidato").val(data.estudios_certificado);
								$("#mayor_estudios_analista").val(data.id_tipo_studies);
								$("#periodo_analista").val(data.periodo);
								$("#escuela_analista").val(data.escuela);
								$("#ciudad_analista").val(data.ciudad);
								$("#certificado_analista").val(data.certificado);
								$("#mayor_estudios_comentarios").val(data.comentarios);
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
				$('a#datos_sociales', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$('.campo_social').prop('readonly', true);
					if(data.id_seccion_social == 30){
						$('.campo_social').prop('readonly', false);
					}
					if(data.id_seccion_social == 64){
						$("#bebidas").prop('readonly', false);
						$("#bebidas_frecuencia").prop('readonly', false);
						$("#fumar").prop('readonly', false);
						$("#fumar_frecuencia").prop('readonly', false);
						$("#cirugia").prop('readonly', false);
						$("#enfermedades").prop('readonly', false);
						$("#corto_plazo").prop('readonly', false);
						$("#mediano_plazo").prop('readonly', false);
					}
					$.ajax({
            url: '<?php echo base_url('Candidato_Social/getById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != null){
								var data = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#religion").val(data.religion);
								$("#religion_frecuencia").val(data.religion_frecuencia);
								$("#bebidas").val(data.bebidas);
								$("#bebidas_frecuencia").val(data.bebidas_frecuencia);
								$("#fumar").val(data.fumar);
								$("#fumar_frecuencia").val(data.fumar_frecuencia);
								$("#cirugia").val(data.cirugia);
								$("#enfermedades").val(data.enfermedades);
								$("#corto_plazo").val(data.corto_plazo);
								$("#mediano_plazo").val(data.mediano_plazo);
								$("#socialesModal").modal('show');
							}
							else{
								$('#formSocial')[0].reset();
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#socialesModal").modal('show');
							}
            }
          });
				});
				$('a#datos_ref_personales_b', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$("#d_refpersonal")[0].reset();
					$.ajax({
						url: '<?php echo base_url('Cliente_Monex/getReferenciasPersonales'); ?>',
						method: 'POST',
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
							if (res != 0) {
								var rows = res.split('###');
								for (var i = 0; i < rows.length; i++) {
									if (rows[i] != "") {
										var dato = rows[i].split('@@');
										$("#refper" + (i + 1) + "_nombre").val(dato[0]);
										$("#refper" + (i + 1) + "_telefono").val(dato[1]);
										$("#refper" + (i + 1) + "_tiempo").val(dato[2]);
										$("#refper" + (i + 1) + "_lugar").val(dato[3]);
										$("#refper" + (i + 1) + "_trabaja").val(dato[4]);
										$("#refper" + (i + 1) + "_vive").val(dato[5]);
										$("#refper" + (i + 1) + "_recomienda").val(dato[6]);
										$("#refper" + (i + 1) + "_comentario").val(dato[7]);
										$("#refper" + (i + 1) + "_id").val(dato[8]);
									}
								}
							}
						}
					});
					$("#refPersonalesModal").modal('show');
				});
				$('a#datos_laborales_b', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					for(var i = 1; i <= 10; i++){
						$("#candidato_reflaboral"+i)[0].reset();
						$("#analista_reflaboral"+i)[0].reset();
					}
					$("#trabajo_gobierno").val(data.trabajo_gobierno);
					$("#trabajo_enterado").val(data.trabajo_enterado);
					$.ajax({
						async: false,
						url: '<?php echo base_url('Cliente_Monex/getPersonasMismoTrabajo'); ?>',
						method: 'POST',
						data: {
							'id_candidato': data.id
						},
						dataType: "text",
						success: function(res) {
							if (res != "") {
								var rows = res.split('###');
								for ($i = 0; $i < rows.length; $i++) {
									if (rows[$i] != "") {
										var dato = rows[$i].split('@@');
										$("#idpersonatrabajo" + ($i + 1)).val(dato[0]);
										$("#persona_trabajo_nombre"+ ($i + 1)).val(dato[1]);
										$("#persona_trabajo_puesto"+ ($i + 1)).val(dato[2]);
									}
								}
							}
						}
					});
					getHistorialLaboral(data.id);
					getVerificacionLaboral(data.id);
					
					$(".nombreCliente").text(data.cliente);
					$("#listado").css('display', 'none');
					$("#btn_nuevo").css('display', 'none');
					$("#btn_asignacion").css('display', 'none');
					$("#formulario").css('display', 'block');
					$("#btn_regresar").css('display', 'block');
				});
				$('a#datos_no_mencionados', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$.ajax({
            url: '<?php echo base_url('Candidato_Laboral/getNoMencionadosById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != null){
								var data = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#no_mencionados").val(data.no_mencionados);
								$("#resultado_no_mencionados").val(data.resultado_no_mencionados);
								$("#notas_no_mencionados").val(data.notas_no_mencionados);
								$("#noMencionadosModal").modal('show');
							}
							else{
								$('#formNoMencionados')[0].reset();
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#noMencionadosModal").modal('show');
							}
            }
          });
				});
				$('a#datos_documentacion', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$.ajax({
            url: '<?php echo base_url('Candidato_Documentacion/getById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != null){
								var data = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#imss").val(data.imss);
								$("#imss_institucion").val(data.imss_institucion);
								$("#comprobante").val(data.domicilio);
								$("#comprobante_institucion").val(data.fecha_domicilio);
								$("#ine").val(data.ine);
								$("#ine_institucion").val(data.ine_institucion);
								$("#curp").val(data.curp);
								$("#curp_institucion").val(data.curp_institucion);
								$("#rfc").val(data.rfc);
								$("#rfc_institucion").val(data.rfc_institucion);
								$("#licencia").val(data.licencia);
								$("#licencia_institucion").val(data.licencia_institucion);
								$("#cartas").val(data.carta_recomendacion);
								$("#cartas_institucion").val(data.carta_recomendacion_institucion);
								$("#comentarios_documentos").val(data.comentarios);
								$("#documentacionModal").modal('show');
							}
							else{
								$('#formDocumentacion')[0].reset();
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#documentacionModal").modal('show');
							}
            }
          });
				});
				$('a#datos_familiares', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					getIntegrantesFamiliares(data.id)
					$("#familiaresModal").modal('show');
				});
				$('a#datos_egresos_mensuales', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$("#d_egresos")[0].reset();
					$.ajax({
						url: '<?php echo base_url('Candidato/getEgresos'); ?>',
						method: 'POST',
						data: {
							'id_candidato': data.id
						},
						success: function(res) {
							if (res != '') {
								var dato = res.split('@@');
								$("#renta").val(dato[0]);
								$("#alimentos").val(dato[1]);
								$("#servicios").val(dato[2]);
								$("#transportes").val(dato[3]);
								$("#otros_gastos").val(dato[4]);
								$("#solvencia").val(dato[5]);
								$("#inmuebles").val(dato[6]);
								$("#inmuebles_adeudo").val(dato[7]);
								$("#candidato_ingresos").val(dato[8]);
								$("#candidato_aporte").val(dato[9]);
								$("#egresos_notas").val(dato[10]);
							}
						}
					});
					$("#egresosModal").modal('show');
				});
				$('a#datos_ingresos_egresos', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$("#d_ingresos_egresos")[0].reset();
					$.ajax({
						url: '<?php echo base_url('Candidato/getEgresos'); ?>',
						method: 'POST',
						data: {
							'id_candidato': data.id
						},
						success: function(res) {
							if (res != 0) {
								var dato = res.split('@@');
								$("#otros_gastos2").val(dato[4]);
								$("#solvencia2").val(dato[5]);
							}
						}
					});
					$('#candidato_muebles').val(data.muebles);
					$('#candidato_adeudo').val(data.adeudo_muebles);
					$('#ingresos').val(data.ingresos);
					$('#ingresos_extra').val(data.ingresos_extra);
					$('#notas_ingresos_egresos').val(data.comentario);
					$("#ingresosEgresosModal").modal('show');
				});
				$('a#datos_habitacion', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$.ajax({
            url: '<?php echo base_url('Candidato_Vivienda/getById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != null){
								var data = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#tiempo_residencia").val(data.tiempo_residencia);
								$("#nivel_zona").val(data.id_tipo_nivel_zona);
								$("#tipo_vivienda").val(data.id_tipo_vivienda);
								$("#recamaras").val(data.recamaras);
								$("#banios").val(data.banios);
								$("#distribucion").val(data.distribucion);
								$("#calidad_mobiliario").val(data.calidad_mobiliario);
								$("#mobiliario").val(data.mobiliario);
								$("#tamanio_vivienda").val(data.tamanio_vivienda);
								$("#condiciones_vivienda").val(data.id_tipo_condiciones);
								$("#viviendaModal").modal('show');
							}
							else{
								$('#formVivienda')[0].reset();
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#viviendaModal").modal('show');
							}
            }
          });
				});
				$('a#datos_ref_vecinales_a', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$("#d_refVecinal1")[0].reset();
					$.ajax({
						url: '<?php echo base_url('Candidato/getVecinales'); ?>',
						method: 'POST',
						data: {
							'id_candidato': data.id
						},
						dataType: "text",
						success: function(res) {
							if (res != 0) {
								var rows = res.split('###');
								for (var i = 0; i < rows.length; i++) {
									if (rows[i] != "") {
										var dato = rows[i].split('@@');
										$("#vecino" + (i + 1) + "_nombre").val(dato[0]);
										$("#vecino" + (i + 1) + "_tel").val(dato[1]);
										$("#vecino" + (i + 1) + "_domicilio").val(dato[2]);
										$("#vecino" + (i + 1) + "_concepto").val(dato[3]);
										$("#vecino" + (i + 1) + "_familia").val(dato[4]);
										$("#vecino" + (i + 1) + "_civil").val(dato[5]);
										$("#vecino" + (i + 1) + "_hijos").val(dato[6]);
										$("#vecino" + (i + 1) + "_sabetrabaja").val(dato[7]);
										$("#vecino" + (i + 1) + "_notas").val(dato[8]);
										$("#idrefvec" + (i + 1)).val(dato[9]);
									}
								}
							}
						}
					});
					$("#refVecinalesModal").modal('show');
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
				$('a#actualizacion_candidato', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$("#idDoping").val(data.idDoping);

					$("#actualizarCandidatoModal").modal('show');
				});
				$('a#solicitudes', row).bind('click', () => {
					$.ajax({
						url: '<?php echo base_url('Candidato/viewSolicitudesCandidato'); ?>',
						type: 'post',
						data: {
							'id_candidato': data.id
						},
						success: function(res) {
							if (res != "") {
								$("#titulo_accion").text("Requisición del candidato");
								$("#nombre_candidato").html("<b>" + data.nombre + ' ' + data.paterno + ' ' + data.materno + '</b>');
								$("#motivo").html(res);
								$("#verModal").modal('show');
							} else {
								$("#titulo_accion").text("Requisiciones del candidato");
								$("#motivo").html("No hay registro de requisición");
								$("#verModal").modal('show');
							}


						}
					});
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
							'prefijo': data.id + "_" + data.nombre + "" + data.paterno
						},
						success: function(res) {
							$("#tablaDocs").html(res);
						}
					});
					$("#docsModal").modal("show");
				});
				$("a#msj_avances", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$("#avances_nombrecandidato").text(data.nombre + " " + data.paterno + " " + data.materno);
					estatusAvances();
				});
				$("a#final", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					if(data.tipo_conclusion == 1){
						var conclusiones = $.ajax({
							url: '<?php echo base_url('Cliente_Monex/checkConclusionesCandidato'); ?>',
							type: 'post',
							async: false,
							data: {
								'id_candidato': data.id
							},
							success: function(res) {}
						}).responseText;
						//if (conclusiones != 1) {
							var refs_comentarios = $.ajax({
								url: '<?php echo base_url('Cliente_Monex/getComentariosRefPersonales'); ?>',
								type: 'post',
								async: false,
								data: {
									'id_candidato': data.id
								},
								success: function(res) {}
							}).responseText;
							var trabajos = $.ajax({
								url: '<?php echo base_url('Cliente_Monex/countReferenciasLaborales'); ?>',
								type: 'post',
								async: false,
								data: {
									'id_candidato': data.id
								},
								success: function(res) {}
							}).responseText;
							var comentarios_laborales = $.ajax({
								url: '<?php echo base_url('Cliente_Monex/getComentariosRefLaborales'); ?>',
								type: 'post',
								async: false,
								data: {
									'id_candidato': data.id
								},
								success: function(res) {}
							}).responseText;
							var vecinales = $.ajax({
								url: '<?php echo base_url('Cliente_Monex/getComentariosRefVecinales'); ?>',
								type: 'post',
								async: false,
								data: {
									'id_candidato': data.id
								},
								success: function(res) {}
							}).responseText;
							var bebidas = (data.bebidas == 1) ? "ingerir" : "no ingerir";
							var fuma = (data.fumar == 1) ? "Fuma " + data.fumar_frecuencia + "." : "No fuma.";
							switch (data.calidad_mobiliario) {
								case '1':
									var calidad = "Buena";
									break;
								case '2':
									var calidad = "Regular";
									break;
								case '3':
									var calidad = "Mala";
									break;
							}
							switch (data.tamanio_vivienda) {
								case '1':
									var tamano = "Amplia";
									break;
								case '2':
									var tamano = "Suficiente";
									break;
								case '3':
									var tamano = "Reducidad";
									break;
							}
							if (data.religion != "" && data.religion != "Ninguna" && data.religion != "NINGUNA" && data.religion != "No" && data.religion != "NO" && data.religion != "NA" && data.religion != "N/A" && data.religion != "No aplica" && data.religion != "NO APLICA" && data.religion != "No Aplica") {
								var religion = "profesa la religion " + data.religion + ".";
							} else {
								var religion = "no profesa alguna religión.";
							}
							if (data.cirugia != "" && data.cirugia != "Ninguna" && data.cirugia != "NINGUNA" && data.cirugia != "No" && data.cirugia != "NO" && data.cirugia != "NA" && data.cirugia != "N/A" && data.cirugia != "No aplica" && data.cirugia != "NO APLICA" && data.cirugia != "No Aplica" && data.cirugia != "0") {
								var cirugia = "Cuenta con cirugia(s) de " + data.cirugia + ".";
							} else {
								var cirugia = "No cuenta con cirugias.";
							}
							if (data.enfermedades != "" && data.enfermedades != "Ninguna" && data.enfermedades != "NINGUNA" && data.enfermedades != "No" && data.enfermedades != "NO" && data.enfermedades != "NA" && data.enfermedades != "N/A" && data.enfermedades != "No aplica" && data.enfermedades != "NO APLICA" && data.enfermedades != "No Aplica" && data.enfermedades != "0") {
								var enfermedades = "Tiene alguna(s) enfermedad(es) con antecedente familiar como " + data.enfermedades + ".";
							} else {
								var enfermedades = "No tiene antecedentes de enfermedadades en su familia.";
							}

							var adeudo = (data.adeudo_muebles == 1) ? "con adeudo" : "sin adeudo";

							$("#personal1").val(data.candidato + ", de " + data.edad + " años, es originario de " + data.municipio + ", " + data.estado + ". Es " + data.estado_civil + " y " + religion);
							$("#personal2").val("Refiere " + bebidas + " bebidas alcohólicas. " + fuma + " " + cirugia + " " + enfermedades + " Sus referencias personales lo describen como " + refs_comentarios + ".");
							$("#personal3").val("Su plan a corto plazo es " + data.corto_plazo + "; y su meta a mediano plazo es " + data.mediano_plazo);
							$("#personal4").val("Su grado máximo de estudios es " + data.grado);
							$("#socio1").val("Actualmente vive en un/una " + data.vivienda + ", con un tiempo de residencia de " + data.tiempo_residencia + ". El nivel de la zona es " + data.zona + ", el mobiliario es de calidad " + calidad + ", la vivienda es " + tamano + " y en condiciones " + data.condiciones + ". La distribución de su " + data.vivienda + " es " + data.distribucion);
							$("#socio2").val(data.candidato + " declara en sus ingresos " + data.ingresos + ". Los gastos generados en el hogar son solventados por _____. Cuenta con " + data.muebles + " " + adeudo + ".");
							$("#laboral1").val("Señaló " + trabajos + " referencias laborales");
							$("#laboral2").val(comentarios_laborales);
							$("#visita1").val("El candidato durante la visita: " + data.visita_comentarios);
							$("#visita2").val("De acuerdo a la referencia vecinal, el candidato es considerado: " + vecinales);
							$("#completarModal").modal('show');
						//}
					}
					if(data.tipo_conclusion == 5){
						var conclusiones = $.ajax({
							url: '<?php echo base_url('Cliente_Monex/checkConclusionesCandidato'); ?>',
							type: 'post',
							async: false,
							data: {
								'id_candidato': data.id
							},
							success: function(res) {}
						}).responseText;
						//if (conclusiones != 1) {
							var refs_comentarios = $.ajax({
								url: '<?php echo base_url('Cliente_Monex/getComentariosRefPersonales'); ?>',
								type: 'post',
								async: false,
								data: {
									'id_candidato': data.id
								},
								success: function(res) {}
							}).responseText;
							var trabajos = $.ajax({
								url: '<?php echo base_url('Cliente_Monex/countReferenciasLaborales'); ?>',
								type: 'post',
								async: false,
								data: {
									'id_candidato': data.id
								},
								success: function(res) {}
							}).responseText;
							var comentarios_laborales = $.ajax({
								url: '<?php echo base_url('Cliente_Monex/getComentariosRefLaborales'); ?>',
								type: 'post',
								async: false,
								data: {
									'id_candidato': data.id
								},
								success: function(res) {}
							}).responseText;
							var bebidas = (data.bebidas == 1) ? "ingerir" : "no ingerir";
							var fuma = (data.fumar == 1) ? "Fuma " + data.fumar_frecuencia + "." : "No fuma.";
							if (data.cirugia != "" && data.cirugia != "Ninguna" && data.cirugia != "NINGUNA" && data.cirugia != "No" && data.cirugia != "NO" && data.cirugia != "NA" && data.cirugia != "N/A" && data.cirugia != "No aplica" && data.cirugia != "NO APLICA" && data.cirugia != "No Aplica" && data.cirugia != "0") {
								var cirugia = "Cuenta con cirugia(s) de " + data.cirugia + ".";
							} else {
								var cirugia = "No cuenta con cirugias.";
							}
							if (data.enfermedades != "" && data.enfermedades != "Ninguna" && data.enfermedades != "NINGUNA" && data.enfermedades != "No" && data.enfermedades != "NO" && data.enfermedades != "NA" && data.enfermedades != "N/A" && data.enfermedades != "No aplica" && data.enfermedades != "NO APLICA" && data.enfermedades != "No Aplica" && data.enfermedades != "0") {
								var enfermedades = "Tiene alguna(s) enfermedad(es) con antecedente familiar como " + data.enfermedades + ".";
							} else {
								var enfermedades = "No presenta antecedentes de enfermedadades familiares.";
							}

							var adeudo = (data.adeudo_muebles == 1) ? "con adeudo" : "sin adeudo";

							$("#personal1").val(data.candidato + ", de " + data.edad + " años, es originario de " + data.municipio + ", " + data.estado + ". Es " + data.estado_civil);
							$("#personal2").val("Refiere " + bebidas + " bebidas alcohólicas. " + fuma + " " + cirugia + " " + enfermedades + " Sus referencias personales lo describen como " + refs_comentarios + ".");
							$("#personal3").val("Su plan a corto plazo: " + data.corto_plazo + ". Su plan a mediano plazo: " + data.mediano_plazo);
							$("#personal4").val("Su grado máximo de estudios es " + data.grado);
							$("#socio1").val("");
							$("#socio1").prop('disabled', true);
							$("#socio2").val(data.candidato + " declara en sus ingresos $" + data.ingresos + ". Los gastos generados en el hogar son solventados por _____. Cuenta con " + data.muebles + " " + adeudo + ".");
							$("#laboral1").val("Señaló " + trabajos + " referencias laborales");
							$("#laboral2").val(comentarios_laborales);
							$("#visita1").val("El candidato durante la visita: ");
							$("#visita2").val("");
							$("#visita2").prop('disabled', true);
							$("#completarModal").modal('show');
						//}
					}
					if(data.tipo_conclusion == 6){
						var conclusiones = $.ajax({
							url: '<?php echo base_url('Cliente_Monex/checkConclusionesCandidato'); ?>',
							type: 'post',
							async: false,
							data: {
								'id_candidato': data.id
							},
							success: function(res) {}
						}).responseText;
						if (conclusiones != 1) {
							var trabajos = $.ajax({
								url: '<?php echo base_url('Cliente_Monex/countReferenciasLaborales'); ?>',
								type: 'post',
								async: false,
								data: {
									'id_candidato': data.id
								},
								success: function(res) {}
							}).responseText;
							var comentarios_laborales = $.ajax({
								url: '<?php echo base_url('Cliente_Monex/getComentariosRefLaborales'); ?>',
								type: 'post',
								async: false,
								data: {
									'id_candidato': data.id
								},
								success: function(res) {}
							}).responseText;
							
							$("#personal1").val(data.candidato + ", de " + data.edad + " años, es originario de " + data.municipio + ", " + data.estado + ". Es " + data.estado_civil);
							$("#personal2").val("Refiere _ bebidas alcohólicas. Sus referencias personales lo describen como _.");
							$("#personal3").val("Su plan a corto plazo es _; y su meta a mediano plazo es _");
							$("#personal4").val("Su grado máximo de estudios es " + data.grado);
							$("#laboral1").val("Señaló " + trabajos + " referencias laborales");
							$("#laboral2").val(comentarios_laborales);
							$("#socio1").val('');
							$("#socio2").val('');
							$("#visita1").val('');
							$("#visita2").val('');
							$("#socio1").prop('disabled', true)
							$("#socio2").prop('disabled', true)
							$("#visita1").prop('disabled', true)
							$("#visita2").prop('disabled', true)
							$("#completarModal").modal('show');
						}
					}
				});
				$('a#conclusiones', row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$.ajax({
            url: '<?php echo base_url('Candidato_Conclusion/getFinalizadoById'); ?>',
            method: 'POST',
            data: {'id':data.id},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
							if(res != null){
								var data = JSON.parse(res);
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								if(data.tipo_conclusion == 1){
									$("#personal1").val(data.descripcion_personal1);
									$("#personal2").val(data.descripcion_personal2);
									$("#personal3").val(data.descripcion_personal3);
									$("#personal4").val(data.descripcion_personal4);
									$("#socio1").val(data.descripcion_socio1);
									$("#socio2").val(data.descripcion_socio2);
									$("#laboral1").val(data.descripcion_laboral1);
									$("#laboral2").val(data.descripcion_laboral2);
									$("#visita1").val(data.descripcion_visita1);
									$("#visita2").val(data.descripcion_visita2);
									$("#recomendable").val(data.recomendable);
									$("#completarModal").modal('show');
								}
								if(data.tipo_conclusion == 5){
									$("#socio1").prop('disabled', true)
									$("#visita2").prop('disabled', true)
									$("#personal1").val(data.descripcion_personal1);
									$("#personal2").val(data.descripcion_personal2);
									$("#personal3").val(data.descripcion_personal3);
									$("#personal4").val(data.descripcion_personal4);
									$("#socio2").val(data.descripcion_socio2);
									$("#laboral1").val(data.descripcion_laboral1);
									$("#laboral2").val(data.descripcion_laboral2);
									$("#visita1").val(data.descripcion_visita1);
									$("#recomendable").val(data.recomendable);
									$("#completarModal").modal('show');
								}
								if(data.tipo_conclusion == 6){
									$("#socio1").prop('disabled', true)
									$("#socio2").prop('disabled', true)
									$("#visita1").prop('disabled', true)
									$("#visita2").prop('disabled', true)
									$("#personal1").val(data.descripcion_personal1);
									$("#personal2").val(data.descripcion_personal2);
									$("#personal3").val(data.descripcion_personal3);
									$("#personal4").val(data.descripcion_personal4);
									$("#laboral1").val(data.descripcion_laboral1);
									$("#laboral2").val(data.descripcion_laboral2);
									$("#recomendable").val(data.recomendable);
									$("#completarModal").modal('show');
								}
							}
							else{
								$('#formConclusiones')[0].reset();
								setTimeout(function(){
									$('.loader').fadeOut();
								},200);
								$("#completarModal").modal('show');
							}
            }
          });
				});
				$('a#liberar', row).bind('click', () => {
          var accion = 1;
          $.ajax({
            url: '<?php echo base_url('Candidato/liberarProceso'); ?>',
            method: 'POST',
            data: {'id_candidato':data.id,'accion':accion},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
              recargarTable();
              setTimeout(function(){
                $('.loader').fadeOut();
              },200);
              var data = JSON.parse(res);
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: data.msg,
                showConfirmButton: false,
                timer: 2500
              })
            }
          });
        });
        $('a#detener', row).bind('click', () => {
          var accion = 0;
          $.ajax({
            url: '<?php echo base_url('Candidato/liberarProceso'); ?>',
            method: 'POST',
            data: {'id_candidato':data.id,'accion':accion},
            beforeSend: function() {
              $('.loader').css("display","block");
            },
            success: function(res){
              recargarTable();
              setTimeout(function(){
                $('.loader').fadeOut();
              },200);
              var data = JSON.parse(res);
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: data.msg,
                showConfirmButton: false,
                timer: 2500
              })
            }
          });
        });
				$('a[id^=pdfFinal]', row).bind('click', () => {
					var id = data.id;
					$('#pdf' + id).submit();
				});
				$('a[id^=pdfDoping]', row).bind('click', () => {
					var id = data.idDoping;
					$('#pdfForm' + id).submit();
				});
				$('a[id^=pdfMedico]', row).bind('click', () => {
					var id = data.idMedico;
					$('#formMedico' + id).submit();
				});
				$('a[id^=pdfPrevio]', row).bind('click', () => {
					var id = data.id;
					$('#formPrevio' + id).submit();
				});
				$("a#eliminar", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$("#quitarModal #titulo_accion").text("Cancelar proceso");
					$("#quitarModal #texto_confirmacion").html("¿Estás seguro de cancelar el proceso de <b>"+data.candidato+"</b>?");
					$("#quitarModal #btnGuardar").attr('value', 'delete');
					$("#quitarModal").modal("show");
				});
				$("a#psicometria", row).bind('click', () => {
					$("#idCandidato").val(data.id);
					$(".nombreCandidato").text(data.candidato);
					$("#psicometriaModal").modal("show");
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
		$("#previos").change(function(){
			var previo = $(this).val();
			if(previo != 0){
				$('.div_check').css('display','none');
				$('.div_info_check').css('display','none');
				$.ajax({
					url: '<?php echo base_url('Candidato/getDetallesProyectoPrevio2'); ?>',
					method: 'POST',
					data: {'id_previo':previo},
					success: function(res)
					{
						$('#detalles_previo').empty();
						$('#detalles_previo').html(res);
					}
				});
			}
			else{
				$('.div_check').css('display','flex');
				$('.div_info_check').css('display','block');
				$('#detalles_previo').empty();
			}
		});
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
		$('[data-toggle="tooltip"]').tooltip();
		
	});
	function getHistorialLaboral(id){
		$.ajax({
			async: false,
			url: '<?php echo base_url('Candidato_Laboral/getHistorialLaboralById'); ?>',
			method: 'POST',
			data: {
				'id': id
			},
			beforeSend: function() {
				$('.loader').css("display", "block");
			},
			success: function(res) {
				setTimeout(function() {
					$('.loader').fadeOut();
				}, 200);
				if (res != 0) {
					var data = JSON.parse(res);
					for (var i = 0; i < data.length; i++) {
						$("#reflab" + (i + 1) + "_empresa").val(data[i]['empresa']);
						$("#reflab" + (i + 1) + "_direccion").val(data[i]['direccion']);
						$("#reflab" + (i + 1) + "_entrada").val(data[i]['fecha_entrada_txt']);
						$("#reflab" + (i + 1) + "_salida").val(data[i]['fecha_salida_txt']);
						$("#reflab" + (i + 1) + "_telefono").val(data[i]['telefono']);
						$("#reflab" + (i + 1) + "_puesto1").val(data[i]['puesto1']);
						$("#reflab" + (i + 1) + "_puesto2").val(data[i]['puesto2']);
						$("#reflab" + (i + 1) + "_salario1").val(data[i]['salario1_txt']);
						$("#reflab" + (i + 1) + "_salario2").val(data[i]['salario2_txt']);
						$("#reflab" + (i + 1) + "_jefenombre").val(data[i]['jefe_nombre']);
						$("#reflab" + (i + 1) + "_jefecorreo").val(data[i]['jefe_correo']);
						$("#reflab" + (i + 1) + "_jefepuesto").val(data[i]['jefe_puesto']);
						$("#reflab" + (i + 1) + "_separacion").val(data[i]['causa_separacion']);
						$('#btnLaboral'+(i + 1)).removeAttr('onclick');
						$('#btnLaboral'+(i + 1)).attr("onclick","guardarReferenciaLaboral("+(i + 1)+","+data[i]['id']+")");
					}
				}
			}
		});
	}
	function getVerificacionLaboral(id){
		$.ajax({
			async: false,
			url: '<?php echo base_url('Candidato_Laboral/getVerificacionLaboralById'); ?>',
			method: 'POST',
			data: {
				'id': id
			},
			beforeSend: function() {
				$('.loader').css("display", "block");
			},
			success: function(res) {
				setTimeout(function() {
					$('.loader').fadeOut();
				}, 200);
				if (res != 0) {
					var data = JSON.parse(res);
					for (var i = 0; i < data.length; i++) {
						$("#an_reflab" + data[i]['numero_referencia'] + "_empresa").val(data[i]['empresa']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_direccion").val(data[i]['direccion']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_entrada").val(data[i]['fecha_entrada_txt']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_salida").val(data[i]['fecha_salida_txt']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_telefono").val(data[i]['telefono']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_puesto1").val(data[i]['puesto1']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_puesto2").val(data[i]['puesto2']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_salario1").val(data[i]['salario1_txt']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_salario2").val(data[i]['salario2_txt']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_jefenombre").val(data[i]['jefe_nombre']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_jefecorreo").val(data[i]['jefe_correo']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_jefepuesto").val(data[i]['jefe_puesto']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_separacion").val(data[i]['causa_separacion']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_comentarios").val(data[i]['notas']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_cualidades").val(data[i]['cualidades']);
						$("#an_reflab" + data[i]['numero_referencia'] + "_mejoras").val(data[i]['mejoras']);
						$('#btnVerificacion'+(i + 1)).removeAttr('onclick');
						$('#btnVerificacion'+(i + 1)).attr("onclick","guardarVerificacionLaboral("+(i + 1)+","+data[i]['id']+")");
					}
				}
			}
		});
	}
	//Proceso
	function nuevoRegistro(){
		var id_cliente = '<?php echo $this->uri->segment(3) ?>';
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
		$('.div_info_check').css('display','none');
		$('.div_check').css('display','none');
		$('#newModal').modal('show');
	}
	function registrar(){
		var id_cliente = '<?php echo $this->uri->segment(3) ?>';
		var datos = new FormData();
		datos.append('nombre', $("#nombre_registro").val());
		datos.append('paterno', $("#paterno_registro").val());
		datos.append('materno', $("#materno_registro").val());
		datos.append('celular', $("#celular_registro").val());
		datos.append('subcliente', $("#subcliente").val());
		datos.append('puesto', $("#puesto").val());
		datos.append('previo', $("#previos").val());
		datos.append('proyecto', $("#proyecto_registro").val());
		datos.append('generales', $("#generales_registro").val());
		datos.append('estudios', $("#estudios_registro").val());
		datos.append('empleos', $("#empleos_registro").val());
		datos.append('sociales', $("#sociales_registro").val());
		datos.append('no_mencionados', $("#no_mencionados_registro").val());
		datos.append('ref_personales', $("#ref_personales_registro").val());
		datos.append('documentacion', $("#documentacion_registro").val());
		datos.append('familiar', $("#familiar_registro").val());
		datos.append('egresos', $("#egresos_registro").val());
		datos.append('habitacion', $("#habitacion_registro").val());
		datos.append('ref_vecinales', $("#ref_vecinales_registro").val());
		datos.append('id_cliente', id_cliente);
		datos.append('examen', $("#examen_registro").val());
		datos.append('medico', $("#examen_medico").val());
		datos.append('psicometrico', $("#examen_psicometrico").val());
		datos.append('usuario', 1);

		var num_files = document.getElementById('cv').files.length;
		if (num_files > 0) {
			datos.append("hay_cvs", 1);
			for (var x = 0; x < num_files; x++) {
				datos.append("cvs[]", document.getElementById('cv').files[x]);
			}
		} else {
			datos.append("hay_cvs", 0);
		}

		$.ajax({
			url: '<?php echo base_url('Cliente_Monex/registrar'); ?>',
			type: 'POST',
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
						title: 'Se ha guardado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					$("#newModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});	
	}
	function AsignarCandidato() {
		var id_candidato = $("#asignar_candidato").val();
		var id_usuario = $("#asignar_usuario").val();

		var totalVacios = $('.asignar_obligado').filter(function() {
			return !$(this).val();
		}).length;

		if (totalVacios > 0) {
			$(".asignar_obligado").each(function() {
				var element = $(this);
				if (element.val() == "" || element.val() == -1) {
					element.addClass("requerido");
					$("#asignarCandidatoModal #msj_texto").text('Hay campos obligatorios vacios');
					$("#asignarCandidatoModal #msj_error").css('display', 'block');
					setTimeout(function() {
						$("#asignarCandidatoModal #msj_error").fadeOut();
					}, 4000);
				} else {
					element.removeClass("requerido");
				}
			});
		} else {
			$.ajax({
				url: '<?php echo base_url('Candidato/reasignarCandidatoAnalista'); ?>',
				method: 'POST',
				data: {
					'id_candidato': id_candidato,
					'id_usuario': id_usuario
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
						$("#asignarCandidatoModal").modal('hide')
						recargarTable()
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					} else {
						$("#asignarCandidatoModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
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
					recargarTable()
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
	function getIntegrantesFamiliares(id){
		$("#div_familiares").empty();
		$.ajax({
			url: '<?php echo base_url('Candidato_Familiar/getById'); ?>',
			method: 'POST',
			data: {
				'id': id
			},
			success: function(res) {
				if(res != 0){
					var data = JSON.parse(res);
					for(var i = 0; i < data.length; i++){
						$('#div_familiares').append('<div class="alert alert-info text-center"><p><b>Persona #'+(i + 1)+'</b></p></div>')
						$('#div_familiares').append('<div class="row"><div class="col-md-3"><label>Nombre completo *</label><input type="text" class="form-control es_persona" name="p'+i+'_nombre" id="p'+i+'_nombre" value="'+data[i]['nombre']+'"><br></div><div class="col-md-3"><label>Parentesco *</label><select name="p'+i+'_parentesco" id="p'+i+'_parentesco" class="form-control es_persona">'+parentescos_php+'</select><br></div><div class="col-md-3"><label>Edad *</label><input type="text" class="form-control solo_numeros es_persona" name="p'+i+'_edad" id="p'+i+'_edad" maxlength="2" value="'+data[i]['edad']+'"><br></div><div class="col-md-3"><label>Estado civil *</label><select name="p'+i+'_civil" id="p'+i+'_civil" class="form-control es_persona">'+civiles_php+'</select><br></div></div><div class="row"><div class="col-md-3"><label>Escolaridad *</label><select name="p'+i+'_escolaridad" id="p'+i+'_escolaridad" class="form-control es_persona ">'+escolaridades_php+'</select><br></div><div class="col-md-3"><label>¿Vive con usted? *</label><select name="p'+i+'_vive" id="p'+i+'_vive" class="form-control es_persona "><option value="0">No</option><option value="1">Sí</option></select><br></div><div class="col-md-3"><label>Empresa *</label><input type="text" class="form-control es_persona " name="p'+i+'_empresa" id="p'+i+'_empresa" value="'+data[i]['empresa']+'"><br></div><div class="col-md-3"><label>Puesto *</label><input type="text" class="form-control es_persona " name="p'+i+'_puesto" id="p'+i+'_puesto" value="'+data[i]['puesto']+'"><br></div></div><div class="row"><div class="col-md-3"><label>Antigüedad *</label><input type="text" class="form-control es_persona " name="p'+i+'_antiguedad" id="p'+i+'_antiguedad" value="'+data[i]['antiguedad']+'"><br></div><div class="col-md-3"><label>Sueldo *</label><input type="text" class="form-control solo_numeros es_persona " name="p'+i+'_sueldo" id="p'+i+'_sueldo" maxlength="8" value="'+data[i]['sueldo']+'"><br></div><div class="col-md-3"><label>Aportación *</label><input type="text" class="form-control solo_numeros es_persona " name="p'+i+'_aportacion" id="p'+i+'_aportacion" maxlength="8" value="'+data[i]['monto_aporta']+'"><br></div><div class="col-md-3"><label>Muebles e inmuebles *</label><input type="text" class="form-control es_persona " name="p'+i+'_muebles" id="p'+i+'_muebles" value="'+data[i]['muebles']+'"><br></div></div><div class="row"><div class="col-md-3"><label>Adeudo *</label><select name="p'+i+'_adeudo" id="p'+i+'_adeudo" class="form-control""><option value="0">No</option><option value="1">Sí</option></select><br></div></div>');
						$('#div_familiares').append('<div class="row mb-3"><div class="col-md-5 offset-4"><a href="javascript:void(0)" class="btn btn-primary" onclick="guardarIntegranteFamiliar('+data[i]['id']+','+i+','+data[i]['id_candidato']+')">Actualizar Persona #'+(i + 1)+'</a></div></div>');
						$('#div_familiares').append('<script>$("#p'+i+'_parentesco").val('+data[i]['id_tipo_parentesco']+');$("#p'+i+'_civil").val(\''+data[i]['estado_civil']+'\');$("#p'+i+'_escolaridad").val('+data[i]['id_grado_estudio']+');$("#p'+i+'_vive").val('+data[i]['misma_vivienda']+');$("#p'+i+'_adeudo").val('+data[i]['adeudo']+');<\/script>');
					}
				}
				else{
					$('#div_familiares').append('<div class="text-center mt-5"><b><h4>No hay registros de integrantes familiares</h4></b></div>');
				}
			}
		});
	}
	//Proceso Espanol
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
		datos.append('tel_oficina', $("#tel_oficina").val());
		datos.append('tiempo_dom_actual', $("#tiempo_dom_actual").val());
		datos.append('tiempo_traslado', $("#tiempo_traslado").val());
		datos.append('medio_transporte', $("#medio_transporte").val());
		datos.append('grado_estudios', $("#grado").val());
		datos.append('correo', $("#correo_general").val());
		datos.append('id_candidato', $("#idCandidato").val());
		
		$.ajax({
			url: '<?php echo base_url('Cliente_Monex/guardarDatosGenerales'); ?>',
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
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					$("#generalesModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}
	function guardarEstudios() {
		var datos = new FormData();
		datos.append('prim_periodo', $("#prim_periodo").val());
		datos.append('prim_escuela', $("#prim_escuela").val());
		datos.append('prim_ciudad', $("#prim_ciudad").val());
		datos.append('prim_certificado', $("#prim_certificado").val());
		datos.append('prim_promedio', $("#prim_promedio").val());
		datos.append('sec_periodo', $("#sec_periodo").val());
		datos.append('sec_escuela', $("#sec_escuela").val());
		datos.append('sec_ciudad', $("#sec_ciudad").val());
		datos.append('sec_certificado', $("#sec_certificado").val());
		datos.append('sec_promedio', $("#sec_promedio").val());
		datos.append('prep_periodo', $("#prep_periodo").val());
		datos.append('prep_escuela', $("#prep_escuela").val());
		datos.append('prep_ciudad', $("#prep_ciudad").val());
		datos.append('prep_certificado', $("#prep_certificado").val());
		datos.append('prep_promedio', $("#prep_promedio").val());
		datos.append('lic_periodo', $("#lic_periodo").val());
		datos.append('lic_escuela', $("#lic_escuela").val());
		datos.append('lic_ciudad', $("#lic_ciudad").val());
		datos.append('lic_certificado', $("#lic_certificado").val());
		datos.append('lic_promedio', $("#lic_promedio").val());
		datos.append('otro_certificado', $("#otro_certificado").val());
		datos.append('carrera_inactivo', $("#carrera_inactivo").val());
		datos.append('estudios_comentarios', $("#estudios_comentarios").val());
		datos.append('id_candidato', $("#idCandidato").val());
		
		$.ajax({
			url: '<?php echo base_url('Candidato_Estudio/setHistorial'); ?>',
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
					$("#academicosModal").modal('hide')
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Historial académico actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					$("#academicosModal #msj_error").css('display', 'block').html(data.msg);
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
	function guardarSociales() {
		var datos = new FormData();
		datos.append('religion', $("#religion").val());
		datos.append('religion_frecuencia', $("#religion_frecuencia").val());
		datos.append('bebidas', $("#bebidas").val());
		datos.append('bebidas_frecuencia', $("#bebidas_frecuencia").val());
		datos.append('fumar', $("#fumar").val());
		datos.append('fumar_frecuencia', $("#fumar_frecuencia").val());
		datos.append('cirugia', $("#cirugia").val());
		datos.append('enfermedades', $("#enfermedades").val());
		datos.append('corto_plazo', $("#corto_plazo").val());
		datos.append('mediano_plazo', $("#mediano_plazo").val());
		datos.append('id_candidato', $("#idCandidato").val());
		
		$.ajax({
			url: '<?php echo base_url('Candidato_Social/set'); ?>',
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
					$("#socialesModal").modal('hide')
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Antecedentes sociales actualizados correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					$("#socialesModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}
	function guardarRefPersonales(num) {
		var datos = new FormData();
		for(var num = 1; num <= 2; num++){
			datos.append('nombre'+num, $('#refper' + num + '_nombre').val());
			datos.append('tiempo'+num, $('#refper' + num + '_tiempo').val());
			datos.append('lugar'+num, $('#refper' + num + '_lugar').val());
			datos.append('trabaja'+num, $('#refper' + num + '_trabaja').val());
			datos.append('vive'+num, $('#refper' + num + '_vive').val());
			datos.append('telefono'+num, $('#refper' + num + '_telefono').val());
			datos.append('recomienda'+num, $('#refper' + num + '_recomienda').val());
			datos.append('comentario'+num, $('#refper' + num + '_comentario').val());
		}
		datos.append('id_candidato', $("#idCandidato").val());

		$.ajax({
			url: '<?php echo base_url('Cliente_Monex/guardarReferenciasPersonales'); ?>',
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
					recargarTable()
					$("#refPersonalesModal #msj_error").css('display', 'none');
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
	function actualizarTrabajoGobierno() {
		var datos = new FormData();
		datos.append('trabajo', $("#trabajo_gobierno").val());
		datos.append('enterado', $("#trabajo_enterado").val());
		datos.append('persona_nombre1', $("#persona_trabajo_nombre1").val());
		datos.append('persona_puesto1', $("#persona_trabajo_puesto1").val());
		datos.append('persona_nombre2', $("#persona_trabajo_nombre2").val());
		datos.append('persona_puesto2', $("#persona_trabajo_puesto2").val());
		datos.append('id_candidato', $("#idCandidato").val());
		datos.append('caso', 2);
		
		$.ajax({
			url: '<?php echo base_url('Cliente_Monex/guardarTrabajoGobierno'); ?>',
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
					recargarTable()
					$("#trabajos_msj_error").css('display', 'none')
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					$("#trabajos_msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}
	function guardarReferenciaLaboral(num, id) {
		var id_candidato = $("#idCandidato").val();
		var datos = new FormData();
		datos.append('empresa', $('#reflab' + num + '_empresa').val());
		datos.append('direccion', $('#reflab' + num + '_direccion').val());
		datos.append('entrada', $('#reflab' + num + '_entrada').val());
		datos.append('salida', $('#reflab' + num + '_salida').val());
		datos.append('telefono', $('#reflab' + num + '_telefono').val());
		datos.append('puesto1', $('#reflab' + num + '_puesto1').val());
		datos.append('puesto2', $('#reflab' + num + '_puesto2').val());
		datos.append('salario1', $('#reflab' + num + '_salario1').val());
		datos.append('salario2', $('#reflab' + num + '_salario2').val());
		datos.append('jefenombre', $('#reflab' + num + '_jefenombre').val());
		datos.append('jefecorreo', $('#reflab' + num + '_jefecorreo').val());
		datos.append('jefepuesto', $('#reflab' + num + '_jefepuesto').val());
		datos.append('separacion', $('#reflab' + num + '_separacion').val());
		datos.append('id', id);
		datos.append('num', num);
		datos.append('id_candidato', id_candidato);

		formdata = $("#candidato_reflaboral" + num).serialize();
		var idCandidato = id_candidato;
		var f = new Date();
		var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
		respaldoTxt(formdata, 'referencia_laboral_' + num + '-' + idCandidato + '-' + fecha_txt);

		$.ajax({
			url: '<?php echo base_url('Candidato_Laboral/setHistorialLaboral'); ?>',
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
					$("#candidato_reflaboral"+num)[0].reset();
					$("#analista_reflaboral"+num)[0].reset();
					getHistorialLaboral(id_candidato);
					getVerificacionLaboral(id_candidato);
					$("#reflab_msj_error" + num).css('display', 'none');
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Laboral actualizada correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				}
				else{
					$("#reflab_msj_error" + num).css('display', 'block').html(data.msg);
				}
			}
		});
	}
	function guardarVerificacionLaboral(num, id) {
		var id_candidato = $("#idCandidato").val();
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
		datos.append('cualidades', $('#an_reflab' + num + '_cualidades').val());
		datos.append('mejoras', $('#an_reflab' + num + '_mejoras').val());
		datos.append('comentarios', $('#an_reflab' + num + '_comentarios').val());
		datos.append('id', id);
		datos.append('num', num);
		datos.append('id_candidato', id_candidato);
		//Respaldo txt
		formdata = $("#analista_reflaboral" + num).serialize();
		var idCandidato = id_candidato;
		var f = new Date();
		var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
		respaldoTxt(formdata, 'verificacion_laboral_' + num + '-' + idCandidato + '-' + fecha_txt);

		$.ajax({
			url: '<?php echo base_url('Candidato_Laboral/setVerificacionLaboral'); ?>',
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
					$("#candidato_reflaboral"+num)[0].reset();
					$("#analista_reflaboral"+num)[0].reset();
					getHistorialLaboral(id_candidato);
					getVerificacionLaboral(id_candidato);
					$("#verlab_msj_error" + num).css('display', 'none');
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Verificacion laboral actualizada correctamente',
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
	function guardarNoMencionados() {
		var datos = new FormData();
		datos.append('no_mencionados', $('#no_mencionados').val());
		datos.append('resultado', $('#resultado_no_mencionados').val());
		datos.append('notas', $('#notas_no_mencionados').val());
		datos.append('id_candidato', $("#idCandidato").val());

		$.ajax({
			url: '<?php echo base_url('Candidato_Laboral/setNoMencionados'); ?>',
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
					$("#noMencionadosModal").modal('hide')
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Trabajos no mencionados actualizados correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					$("#noMencionadosModal #msj_error").css('display', 'block').html(data.msg);
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
					recargarTable();
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
	function finalizarProceso() {
		var id_candidato = $("#idCandidato").val();
		var datos = new FormData();
		datos.append('personal1', $("#personal1").val());
		datos.append('personal2', $("#personal2").val());
		datos.append('personal3', $("#personal3").val());
		datos.append('personal4', $("#personal4").val());
		datos.append('laboral1', $("#laboral1").val());
		datos.append('laboral2', $("#laboral2").val());
		datos.append('socio1', $("#socio1").val());
		datos.append('socio2', $("#socio2").val());
		datos.append('visita1', $("#visita1").val());
		datos.append('visita2', $("#visita2").val());
		datos.append('recomendable', $("#recomendable").val());
		datos.append('id_candidato', id_candidato);
		
		$.ajax({
			url: '<?php echo base_url('Candidato_Conclusion/setFinalizar'); ?>',
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
					$("#completarModal").modal('hide')
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					$("#completarModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}
	function actualizarProceso() {
		var id_candidato = $("#idCandidato").val();
		var id_doping = $("#idDoping").val();
		$.ajax({
			url: '<?php echo base_url('Cliente_Monex/actualizarProcesoCandidato'); ?>',
			method: 'POST',
			data: {
				'id_candidato': id_candidato,
				'id_doping': id_doping
			},
			beforeSend: function() {
				$('.loader').css("display", "block");
			},
			success: function(res) {
				if (res == 1) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 2000);
					localStorage.setItem("success", 1);
					location.reload();
				}
			}
		});
	}
	function ejecutarAccion() {
		var accion = $("#btnGuardar").val();
		var id_candidato = $("#idCandidato").val();
		var correo = $("#correo").val();
		if (accion == 'delete') {
			$.ajax({
				url: '<?php echo base_url('Candidato/cancelarCandidato'); ?>',
				type: 'post',
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
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#quitarModal").modal('hide');
						recargarTable()
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Se ha cancelado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
				}
			});
		}
	}
	function guardarDocumentacion(){
		var id_candidato = $("#idCandidato").val();
		var datos = new FormData();
		datos.append('imss', $("#imss").val());
		datos.append('imss_institucion', $("#imss_institucion").val());
		datos.append('comprobante', $("#comprobante").val());
		datos.append('comprobante_institucion', $("#comprobante_institucion").val());
		datos.append('ine', $("#ine").val());
		datos.append('ine_institucion', $("#ine_institucion").val());
		datos.append('curp', $("#curp").val());
		datos.append('curp_institucion', $("#curp_institucion").val());
		datos.append('rfc', $("#rfc").val());
		datos.append('rfc_institucion', $("#rfc_institucion").val());
		datos.append('licencia', $("#licencia").val());
		datos.append('licencia_institucion', $("#licencia_institucion").val());
		datos.append('cartas', $("#cartas").val());
		datos.append('cartas_institucion', $("#cartas_institucion").val());
		datos.append('comentarios', $("#comentarios_documentos").val());
		datos.append('id_candidato', id_candidato);
		
		$.ajax({
			url: '<?php echo base_url('Candidato_Documentacion/set'); ?>',
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
					$("#documentacionModal").modal('hide')
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Documentación actualizada correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					$("#documentacionModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}
	function guardarIntegranteFamiliar(id_persona, num_persona, idCandidato) {
		var id_candidato = $("#idCandidato").val();
		var datos = new FormData();
		datos.append('nombre', $("#p" + num_persona + "_nombre").val());
		datos.append('parentesco', $("#p" + num_persona + "_parentesco").val());
		datos.append('edad', $("#p" + num_persona + "_edad").val());
		datos.append('civil', $("#p" + num_persona + "_civil").val());
		datos.append('escolaridad', $("#p" + num_persona + "_escolaridad").val());
		datos.append('vive', $("#p" + num_persona + "_vive").val());
		datos.append('empresa', $("#p" + num_persona + "_empresa").val());
		datos.append('puesto', $("#p" + num_persona + "_puesto").val());
		datos.append('antiguedad', $("#p" + num_persona + "_antiguedad").val());
		datos.append('sueldo', $("#p" + num_persona + "_sueldo").val());
		datos.append('aportacion', $("#p" + num_persona + "_aportacion").val());
		datos.append('muebles', $("#p" + num_persona + "_muebles").val());
		datos.append('adeudo', $("#p" + num_persona + "_adeudo").val());
		datos.append('id_candidato', id_candidato);
		datos.append('id_persona', id_persona);
		
		$.ajax({
			url: '<?php echo base_url('Candidato_Familiar/set'); ?>',
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
					if(id_persona == 0){
						getIntegrantesFamiliares(id_candidato);
						$("#nuevoFamiliarModal #msj_error").css('display', 'none')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Integrante familiar registrado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
						$('#nuevoFamiliarModal').modal('hide');
					}
					else{
						//getIntegrantesFamiliares(id_candidato);
						$("#familiaresModal #msj_error").css('display', 'none')
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: 'Integrante familiar actualizado correctamente',
							showConfirmButton: false,
							timer: 2500
						})
					}
				} else {
					if(id_persona == 0){
						$("#nuevoFamiliarModal #msj_error").css('display', 'block').html(data.msg);
					}
					else{
						$("#familiaresModal #msj_error").css('display', 'block').html(data.msg);
					}
				}
			}
		});
	}
	function guardarExtrasCandidato(id_candidato) {
		var muebles = $("#candidato_muebles").val();
		var adeudo = $("#candidato_adeudo").val();
		var notas = $("#notas").val();
		var ingresos = $("#candidato_ingresos").val();
		var aporte = $("#candidato_aporte").val();
		var id_candidato = $("#idCandidato").val();

		$.ajax({
			url: '<?php echo base_url('Cliente_Monex/editarExtrasCandidato'); ?>',
			method: "POST",
			data: {
				'id_candidato': id_candidato,
				'notas': notas,
				'muebles': muebles,
				'adeudo':adeudo,
				'ingresos':ingresos,
				'aporte':aporte
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
					$("#mobiliario_msj_error").css('display', 'none')
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					$("#mobiliario_msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}
	function actualizarEgresos() {
		var id_candidato = $("#idCandidato").val();
		var datos = new FormData();
		datos.append('muebles', $("#inmuebles").val());
		datos.append('adeudo', $("#inmuebles_adeudo").val());
		datos.append('ingresos', $("#candidato_ingresos").val());
		datos.append('aporte', $("#candidato_aporte").val());
		datos.append('renta', $("#renta").val());
		datos.append('alimentos', $("#alimentos").val());
		datos.append('servicios', $("#servicios").val());
		datos.append('transportes', $("#transportes").val());
		datos.append('otros_gastos', $("#otros_gastos").val());
		datos.append('solvencia', $("#solvencia").val());
		datos.append('notas', $("#egresos_notas").val());
		datos.append('id_candidato', id_candidato);
		
		$.ajax({
			url: '<?php echo base_url('Cliente_Monex/guardarEgresos'); ?>',
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
					$("#egresosModal").modal('hide')
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					$("#egresosModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}
	function actualizarIngresosEgresos() {
		var id_candidato = $("#idCandidato").val();
		var datos = new FormData();
		datos.append('muebles', $("#candidato_muebles").val());
		datos.append('adeudo', $("#candidato_adeudo").val());
		datos.append('ingresos', $("#ingresos").val());
		datos.append('ingresos_extra', $("#ingresos_extra").val());
		datos.append('otros_gastos', $("#otros_gastos2").val());
		datos.append('solvencia', $("#solvencia2").val());
		datos.append('notas', $("#notas_ingresos_egresos").val());
		datos.append('id_candidato', id_candidato);
		
		$.ajax({
			url: '<?php echo base_url('Cliente_Monex/guardarIngresosEgresos'); ?>',
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
					$("#ingresosEgresosModal").modal('hide')
					recargarTable()
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha actualizado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					$("#ingresosEgresosModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}
	function actualizarHabitacion() {
		var id_candidato = $("#idCandidato").val();
		var datos = new FormData();
		datos.append('tiempo_residencia', $("#tiempo_residencia").val());
		datos.append('nivel_zona', $("#nivel_zona").val());
		datos.append('tipo_vivienda', $("#tipo_vivienda").val());
		datos.append('recamaras', $("#recamaras").val());
		datos.append('banios', $("#banios").val());
		datos.append('distribucion', $("#distribucion").val());
		datos.append('calidad_mobiliario', $("#calidad_mobiliario").val());
		datos.append('mobiliario', $("#mobiliario").val());
		datos.append('tamanio_vivienda', $("#tamanio_vivienda").val());
		datos.append('condiciones_vivienda', $("#condiciones_vivienda").val());
		datos.append('id_candidato', id_candidato);
		
		$.ajax({
			url: '<?php echo base_url('Candidato_Vivienda/set'); ?>',
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
					$("#viviendaModal").modal('hide')
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'La información de vivienda ha sido actualizada correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				} else {
					$("#viviendaModal #msj_error").css('display', 'block').html(data.msg);
				}
			}
		});
	}
	function guardarVecinales(num) {
		var id_candidato = $("#idCandidato").val();
		var datos = new FormData();
		datos.append('nombre', $("#vecino"+num+"_nombre").val());
		datos.append('domicilio', $("#vecino"+num+"_domicilio").val());
		datos.append('telefono', $("#vecino"+num+"_tel").val());
		datos.append('concepto', $("#vecino"+num+"_concepto").val());
		datos.append('familia', $("#vecino"+num+"_familia").val());
		datos.append('civil', $("#vecino"+num+"_civil").val());
		datos.append('hijos', $("#vecino"+num+"_hijos").val());
		datos.append('sabetrabaja', $("#vecino"+num+"_sabetrabaja").val());
		datos.append('notas', $("#vecino"+num+"_notas").val());
		datos.append('id_candidato', id_candidato);
		datos.append('idrefvec', $("#idrefvec"+num).val());
		
		$.ajax({
			url: '<?php echo base_url('Cliente_Monex/guardarReferenciasVecinales'); ?>',
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
				if (data.codigo === 0) {
					$("#refVecinalesModal #msj_error"+num).css('display', 'block').html(data.msg);
				}
				if (data.codigo === 1) {
					$("#refVecinalesModal #msj_error"+num).css('display', 'none')
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha guardado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				}
				if (data.codigo === 2) {
					$("#refVecinalesModal #msj_error"+num).css('display', 'none')
					$("#idrefvec"+num).val(data.msg)
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'Se ha guardado correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				}
			}
		});
	}
	function subirPsicometria() {
		var docs = new FormData();
		var archivo = $("#archivo")[0].files[0];
		docs.append("id_candidato", $("#idCandidato").val());
		docs.append("id_psicometrico", $("#idPsicometrico").val());
		docs.append("archivo", archivo);
		$.ajax({
			url: "<?php echo base_url('Candidato/subirPsicometrico'); ?>",
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
					$("#psicometriaModal").modal('hide');
					recargarTable();
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: 'La psicometria se ha subido correctamente',
						showConfirmButton: false,
						timer: 2500
					})
				}
				else {
					$("#psicometriaModal #msj_error").css('display', 'block').html(data.msg);
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
	function confirmar(num){
		var id = $('#idrefvec'+num).val();
		$('#idVecinal').val(id);
		$('#numVecinal').val(num);
		$('#titulo_confirmacion').text('Confirmar eliminación de Referencia Vecinal');
		$('#mensaje_confirmacion').text('¿Desea eliminar la Referencia Vecinal #'+num+'?');
		$('#confirmarAccionModal').modal('show');
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
	function aceptarConfirmacion(){
		var id = $('#idVecinal').val();
		var num = $('#numVecinal').val();
		$('#confirmarAccionModal').modal('hide');
		$("#vecino" + num + "_nombre").val('');
		$("#vecino" + num + "_tel").val('');
		$("#vecino" + num + "_domicilio").val('');
		$("#vecino" + num + "_concepto").val('');
		$("#vecino" + num + "_familia").val('');
		$("#vecino" + num + "_civil").val('');
		$("#vecino" + num + "_hijos").val('');
		$("#vecino" + num + "_sabetrabaja").val('');
		$("#vecino" + num + "_notas").val('');
		$("#idrefvec" + num).val('');
		eliminarVecinal(id);
	}
	function eliminarVecinal(id){
		$.ajax({
			url: '<?php echo base_url('Candidato/eliminarVecinal'); ?>',
			method: 'POST',
			data: {
				'id': id
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
					});
				}
				else{
					Swal.fire({
						position: 'center',
						icon: 'warning',
						title: 'No hay vecinal a eliminar o ya fue eliminada',
						showConfirmButton: false,
						timer: 2500
					});
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
	//Funciones de apoyo
	function recargarTable() {
		$("#tabla").DataTable().ajax.reload();
	}
	function getMunicipio(id_estado, id_municipio) {
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
				$("#municipio").find('option').attr("selected", false);
				$('#municipio option[value="' + id_municipio + '"]').attr('selected', 'selected');
			}
		});
	}
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
	function generarIntegranteFamiliar() {
		num2++;
		var item2 = "";
		item2 += '<div class="alert alert-secondary text-center p2_' + num2 + '"><p>Persona #' + num2 + '</p></div><div class="row p2_' + num2 + '"><div class="col-12"><label>Nombre completo *</label><input type="text" class="form-control es_persona_2 p_obligado_2" name="p' + num2 + '_nombre_2" id="p' + num2 + '_nombre_2"><br></div></div><div class="row p2_' + num2 + '"><div class="col-6"><label>Parentesco *</label><select name="p' + num2 + '_parentesco_2" id="p' + num2 + '_parentesco_2" class="form-control es_persona_2 p_obligado_2"><option value="">Selecciona</option><?php foreach ($parentescos as $par) { ?><option value="<?php echo $par->id; ?>"><?php echo $par->nombre; ?></option><?php } ?></select><br></div><div class="col-6"><label>Edad *</label><input type="text" class="form-control solo_numeros es_persona_2 p_obligado_2" name="p' + num2 + '_edad_2" id="p' + num2 + '_edad_2" maxlength="2"><br></div></div><div class="row p2_' + num2 + '"><div class="col-6"><label>Escolaridad *</label><select name="p' + num2 + '_escolaridad_2" id="p' + num2 + '_escolaridad_2" class="form-control es_persona_2 p_obligado_2"><option value="">Selecciona</option><?php foreach ($escolaridades as $esc) { ?><option value="<?php echo $esc->id; ?>"><?php echo $esc->nombre; ?></option><?php } ?></select><br></div><div class="col-6"><label>¿Vive con usted? *</label><select name="p' + num2 + '_vive_2" id="p' + num2 + '_vive_2" class="form-control es_persona_2 p_obligado_2"><option value="">Selecciona</option><option value="0">No</option><option value="1">Sí</option></select><br></div></div><div class="row p2_' + num2 + '"><div class="col-6"><label>Estado civil *</label><select name="p' + num2 + '_civil_2" id="p' + num2 + '_civil_2" class="form-control es_persona_2 p_obligado_2"><option value="">Selecciona</option><?php foreach ($civiles as $civ) { ?><option value="<?php echo $civ->nombre; ?>"><?php echo $civ->nombre; ?></option><?php } ?></select><br></div><div class="col-6"><label>Empresa *</label><input type="text" class="form-control es_persona_2 p_obligado_2" name="p' + num2 + '_empresa_2" id="p' + num2 + '_empresa_2"><br></div></div><div class="row p2_' + num2 + '"><div class="col-6"><label for="p' + num2 + '_puesto">Puesto *</label><input type="text" class="form-control es_persona_2 p_obligado_2" name="p' + num2 + '_puesto_2" id="p' + num2 + '_puesto_2"><br></div><div class="col-6"><label>Antigüedad *</label><input type="text" class="form-control es_persona_2 p_obligado_2" name="p' + num2 + '_antiguedad_2" id="p' + num2 + '_antiguedad_2"><br></div></div><div class="row p2_' + num2 + '"><div class="col-6"><label>Sueldo *</label><input type="text" class="form-control solo_numeros es_persona_2 p_obligado_2" name="p' + num2 + '_sueldo_2" id="p' + num2 + '_sueldo_2" maxlength="8"><br></div><div class="col-6"><label>Aportación *</label><input type="text" class="form-control solo_numeros es_persona_2 p_obligado_2" name="p' + num2 + '_aportacion_2" id="p' + num2 + '_aportacion_2" maxlength="8"><br></div></div><div class="row p2_' + num2 + '"><div class="col-6"><label>Muebles e inmuebles *</label><input type="text" class="form-control es_persona_2 p_obligado_2" name="p' + num2 + '_muebles_2" id="p' + num2 + '_muebles_2"><br></div><div class="col-6"><label>Adeudo *</label><select name="p' + num2 + '_adeudo_2" id="p' + num2 + '_adeudo_2" class="form-control es_persona_2 p_obligado_2"><option value="">Selecciona</option><option value="0">No</option><option value="1">Sí</option></select><br></div></div><br><div class="row p2_' + num2 + '"><div class="col-md-4 offset-md-4"><a href="javascript:void(0)" class="btn btn-danger" onclick="borrarPersonaTipo2(' + num2 + ')">Borrar esta persona</a><br><br><br><br></div></div>';
		$("#div_personas_2").append(item2);
	}
	function borrarIntegranteFamiliar(numero) {
		$(".p2_" + numero).empty();
		$(".p2_" + numero).removeClass('alert', 'alert-secondary');
		num2--;
		}
	//Regresa del formulario al listado
	function regresar() {
		$("#btn_regresar").css('display', 'none');
		$("#formulario").css('display', 'none');
		$("#listado").css('display', 'block');
		$("#btn_nuevo").css('display', 'block');
	}

	function convertirDate(fecha) {
		var aux = fecha.split('-');
		var f = aux[2] + '/' + aux[1] + '/' + aux[0];
		return f;
	}

	function convertirDateTime(fecha) {
		var f = fecha.split(' ');
		var aux = f[0].split('-');
		var date = aux[2] + '/' + aux[1] + '/' + aux[0];
		return date;
	}

	function checkDecimales(el) {
		var ex = /^[0-9]+\.?[0-9]*$/;
		if (ex.test(el.value) == false) {
			el.value = el.value.substring(0, el.value.length - 1);
		}
	}

	function regresarListado() {
		location.reload();
	}
	//Acepta solo numeros en los input
	$(".solo_numeros").on("input", function() {
		var valor = $(this).val();
		$(this).val(valor.replace(/[^0-9]/g, ''));
	});
</script>