<!-- Begin Page Content -->
<div class="container-fluid">

<section class="content-header">
  <div class="row">
    <div class="col-sm-12 col-md-3 col-lg-3">
      <h1 class="titulo_seccion">Requisiciones</small></h1>
    </div>
    <div class="col-sm-12 col-md-2 col-lg-2 offset-md-5 offset-lg-5 mb-3">
      <button type="button" id="btnNuevaRequisicion" class="btn btn-primary btn-icon-split" onclick="nuevaRequisicion()">
        <span class="icon text-white-50">
          <i class="far fa-file-alt"></i>
        </span>
        <span class="text">Nueva requisicion</span>
      </button>
    </div>
    <?php 
    if($this->session->userdata('idrol') == 4){
      $disabled = 'disabled'; $textTitle = 'title="No posees permiso para esta acción"';
    }else{
      $disabled = ''; $textTitle = '';
    } ?>
    <div class="col-sm-12 col-md-2 col-lg-2 mb-3" data-toggle="tooltip" <?php echo $textTitle; ?> >
      <button type="button" id="btnOpenAssignToUser" class="btn btn-primary btn-icon-split" onclick="openAssignToUser()" <?php echo $disabled; ?> >
        <span class="icon text-white-50">
          <i class="fas fa-user-edit"></i>
        </span>
        <span class="text">Asignar requisicion</span>
      </button>
    </div>
  </div>
</section>

	<?php echo $modals; ?>
	<?php echo $modals_reclutamiento; ?>
	<div class="loader" style="display: none;"></div>
	<input type="hidden" id="idRequisicion">
	<input type="hidden" id="currentPage">
	<input type="hidden" id="idCandidato">
	<input type="hidden" id="idAvance">

  <div class="row mt-3 mb-5" id="divFiltros">
    <div class="col-sm-12 col-md-2 col-lg-2 offset-md-5 offset-lg-5">
      <label for="ordenar">Ordenar:</label>
      <select name="ordenar" id="ordenar" class="form-control">
        <option value="">Selecciona</option>
        <option value="ascending">De la más antigua a la más actual</option>
        <option value="descending">De la más actual a la más antigua</option>
      </select>
    </div>
    <div class="col-sm-12 col-md-2 col-lg-2">
      <label for="filtrar">Filtrar por:</label>
      <select name="filtrar" id="filtrar" class="form-control">
        <option value="">Selecciona</option>
        <option value="COMPLETA">Requisión COMPLETA (registrada por externo)</option>
        <option value="EXPRESS">Requisición EXPRESS</option>
        <option value="En espera">Estatus en espera</option>
        <option value="En proceso">Estatus en proceso de reclutamiento</option>
      </select>
    </div>
    <div class="col-sm-12 col-md-3 col-lg-3" >
      <label for="buscador">Buscar:</label>
      <select name="buscador" id="buscador" class="selectpicker form-control" data-live-search="true" data-style="btn-custom-selectpicker" title="Selecciona">
        <option value="0">VER TODAS</option>
        <?php
        if ($orders_search) {
          foreach ($orders_search as $row) { ?>
            <option value="<?php echo $row->id; ?>"><?php echo '#'.$row->id.' '.$row->nombre; ?></option>
        <?php 
          }
        }else{ ?>
          <option value="">Sin requisiones registradas</option>
        <?php } ?>
      </select>
    </div>
  </div>

  <a href="javascript:void(0)" class="btn btn-primary btn-icon-split btnRegresar" id="btnBack" onclick="regresarListado()" style="display: none;">
    <span class="icon text-white-50">
      <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text">Regresar al listado</span>
  </a>

	<div id="seccionTarjetas">
		<div id="tarjetas">
			<?php 
			if($requisiciones){
				echo '<div class="row mb-3">';
				foreach($requisiciones as $r){
					$hoy = date('Y-m-d H:i:s');
          $fecha_registro = fechaTexto($r->creacion,'espanol');
					$color_estatus = ''; $text_estatus = '';
					if($r->status == 1){
						$botonProceso = '<a href="javascript:void(0)" class="btn btn-success text-lg" id="btnIniciar'.$r->id.'" data-toggle="tooltip" title="Iniciar proceso" onclick="iniciarProceso('.$r->id.',\''.$r->nombre.'\')"><i class="fas fa-play-circle"></i></a>';
            $text_estatus = 'Estatus: <b>En espera</b>';
						$botonResultados = '<a href="javascript:void(0)" class="btn btn-success text-lg isDisabled" data-toggle="tooltip" title="Ver resultados de los candidatos"><i class="fas fa-file-alt"></i></a>';
						$btnDelete = '<a href="javascript:void(0)" class="btn btn-danger text-lg" data-toggle="tooltip" title="Eliminar requisicion" onclick="openDeleteOrder('.$r->id.',\''.$r->nombre.'\')"><i class="fas fa-trash"></i></a>';
					}
					if($r->status == 2){
						$botonProceso = '<a href="javascript:void(0)" class="btn btn-success text-lg isDisabled" data-toggle="tooltip" title="Iniciar proceso"><i class="fas fa-play-circle"></i></a>';
						$color_estatus = 'req_activa';
            $text_estatus = 'Estatus: <b>En proceso de reclutamiento</b>';
						$botonResultados = '<a href="javascript:void(0)" class="btn btn-success text-lg" data-toggle="tooltip" title="Ver resultados de los candidatos" onclick="verExamenesCandidatos('.$r->id.',\''.$r->nombre.'\')"><i class="fas fa-file-alt"></i></a>';
						$btnDelete = '<a href="javascript:void(0)" class="btn btn-danger text-lg isDisabled" data-toggle="tooltip" title="Eliminar requisicion"><i class="fas fa-trash"></i></a>';
					}
          $usuario = (empty($r->usuario))? 'Requisición sin cambios<br>' : 'Última modificación: <b>'.$r->usuario.'</b><br>';
          $data['users'] = $this->reclutamiento_model->getUsersOrder($r->id);
          if(!empty($data['users'])){
            $usersAssigned = 'Usuarios asignados:<br>';
            foreach($data['users'] as $user){
              if($this->session->userdata('idrol') == 4)
                $usersAssigned .= '<div class="mb-1" id="divUser'.$user->id.'"><b>'.$user->usuario.'</b></div>';
              else 
                $usersAssigned .= '<div class="mb-1" id="divUser'.$user->id.'"><a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Eliminar usuario de la requsicion" onclick="openDeleteUserOrder('.$user->id.','.$user->id_requisicion.',\''.$user->usuario.'\')"><i class="fas fa-user-times"></i></a> <b>'.$user->usuario.'</b></div>';
            }
          }else{
            $usersAssigned = 'Sin asignar usuarios';
          }
          unset($data['users']);
          $btnExpress = ($r->tipo == 'EXPRESS')? '<a href="javascript:void(0)" class="btn btn-primary text-lg" data-toggle="tooltip" title="Editar requsición EXPRESS" onclick="openUpdateOrder('.$r->id.',\''.$r->nombre.'\',\''.$r->nombre_comercial.'\',\''.$r->puesto.'\')"><i class="fas fa-edit"></i></a>' : '<a href="javascript:void(0)" class="btn btn-primary text-lg isDisabled" data-toggle="tooltip" title="Editar requsición EXPRESS"><i class="fas fa-edit"></i></a>';
          //total de requisiciones para saber si fue buscada una en particular y colocarla enmedio de la vista
          $totalOrders = count($requisiciones);
          $moveOrder = ($totalOrders > 1)? '' : 'offset-md-4 offset-lg-4';
          $nombres = (empty($r->nombre_comercial))? $r->nombre : $r->nombre.'<br>'.$r->nombre_comercial;
					?>
					<div class="col-sm-12 col-md-4 col-lg-4 mb-5 <?php echo $moveOrder ?>">
						<div class="card text-center tarjeta" id="<?php echo 'tarjeta'.$r->id; ?>">
							<div class="card-header <?php echo $color_estatus; ?>">
								<b><?php echo '#'.$r->id.' '.$nombres; ?></b>
							</div>
							<div class="card-body">
								<h5 class="card-title"><b><?php echo $r->puesto; ?></b></h5>
								<p class="card-text"><?php echo 'Vacantes: <b>'.$r->numero_vacantes; ?></b></p>
								<p class="card-text">Contacto: <br><b><?php echo $r->contacto.' <br>'.$r->telefono.' <br>'.$r->correo; ?></b></p>
                <div class="alert alert-secondary text-center mt-3">Tipo: <b><?php echo $r->tipo ?></b><br><b><?php echo $text_estatus ?></b></div>
								<div class="row">
                  <div class="col-sm-4 col-md-2 col-lg-2 mb-1">
										<?php echo $btnExpress; ?>
									</div>
									<div class="col-sm-4 col-md-2 col-lg-2 mb-1">
                    <a href="javascript:void(0)" class="btn btn-primary text-lg" data-toggle="tooltip" title="Ver detalles" onclick="verDetalles(<?php echo $r->id;?>)"><i class="fas fa-info-circle"></i></a>
									</div>
									<div class="col-sm-4 col-md-2 col-lg-2 mb-1" id="divIniciar<?php echo $r->id?>">
										<?php echo $botonProceso; ?>
									</div>
                  <div class="col-sm-4 col-md-2 col-lg-2 mb-1">
                    <form method="POST" action="<?php echo base_url('Reclutamiento/getOrderPDF'); ?>">
                      <input type="hidden"  name="idReq" value="<?php echo $r->id ?>">
                      <button type="submit" class="btn btn-danger text-lg" data-toggle="tooltip" title="Descargar requisición en PDF"><i class="fas fa-file-pdf"></i></button>
                    </form>
                  </div>
                  <div class="col-sm-4 col-md-2 col-lg-2 mb-1">
										<?php echo $botonResultados; ?>
									</div>
                  <div class="col-sm-4 col-md-2 col-lg-2 mb-1">
										<?php echo $btnDelete; ?>
									</div>
								</div>
                <div class="alert alert-secondary text-left mt-3" id="divUsuario<?php echo $r->id; ?>"><?php echo $usuario.$usersAssigned; ?></div>
							</div>
							<div class="card-footer text-muted">
								<?php echo $fecha_registro; ?>
							</div>
						</div>
					</div>
			<?php 
				}
				echo '</div>';
			}  ?>
		</div>
		<div id="tarjeta_detalle" class="hidden mb-5">
      <div class="alert alert-info text-center" id="empresa"></div>
			<div class="card">
				<div class="card-header">
					<ul class="nav nav-tabs card-header-tabs">
						<li class="nav-item">
							<a class="nav-link active" id="link_vacante" href="javascript:void(0)">Información de la vacante</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="link_cargo" href="javascript:void(0)">Información sobre el cargo</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="link_perfil" href="javascript:void(0)">Perfil del cargo</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="link_factura" href="javascript:void(0)">Datos de facturación</a>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<div id="div_vacante" class="div_info">
						<h5 id="vacantes" class="text-center"><b></b></h5><br>
						<div class="row">
							<div class="col-6">
								<h5 id="sexo"><b></b></h5>
								<h5 id="civil"><b></b></h5>
								<h5 id="edad_min"><b></b></h5>
								<h5 id="edad_max"><b></b></h5>
								<h5 id="residencia"><b></b></h5>
								<h5 id="discapacidad"><b></b></h5><br>
							</div>
							<div class="col-6">
								<h5 id="escolaridad"><b></b></h5>
								<h5 id="estatus_escolar"><b></b></h5>
								<h5 id="carrera"><b></b></h5>
								<h5 id="otros_estudios"><b></b></h5>
								<h5 id="idiomas"><b></b></h5>
								<h5 id="licencia"><b></b></h5><br>
							</div>
						</div>
						<h5 id="hab_informatica" class="text-center"><b></b></h5><br>
						<h5 id="causa" class="text-center"><b></b></h5>
					</div>
					<div id="div_cargo" class="div_info hidden">
						<div class="row">
							<div class="col-6">
								<h5 id="jornada"><b></b></h5>
								<h5 id="inicio"><b></b></h5>
								<h5 id="final"><b></b></h5>
								<h5 id="descanso"><b></b></h5>
								<h5 id="viajar"><b></b></h5>
								<h5 id="horario"><b></b></h5><br>
							</div>
							<div class="col-6">
								<h5 id="tipo_sueldo"><b></b></h5>
								<h5 id="sueldo_min"><b></b></h5>
								<h5 id="sueldo_max"><b></b></h5>
								<h5 id="sueldo_adicional"><b></b></h5>
								<h5 id="tipo_pago"><b></b></h5>
								<h5 id="tipo_prestaciones"><b></b></h5><br>
							</div>
						</div>
						<h5 id="lugar_entrevista_detalle" class="text-center"><b></b></h5><br>
						<h5 id="zona" class="text-center"><b></b></h5><br>
						<h5 id="superiores" class="text-center"><b></b></h5><br>
						<h5 id="otras_prestaciones" class="text-center"><b></b></h5><br>
						<h5 id="experiencia" class="text-center"><b></b></h5><br>
						<h5 id="actividades" class="text-center"><b></b></h5><br>
					</div>
					<div id="div_perfil" class="div_info hidden">
						<h5 id="competencias" class="text-center"><b></b></h5><br><br>
						<h5 id="observaciones" class="text-center"><b></b></h5><br>
					</div>
					<div id="div_factura" class="div_info hidden">
						<div class="row">
							<div class="col-6">
								<h5 id="contacto"><b></b></h5>
								<h5 id="telefono_req"><b></b></h5>
								<h5 id="correo_req"><b></b></h5><br>
							</div>
							<div class="col-6">
								<h5 id="rfc"><b></b></h5>
								<h5 id="forma_pago"><b></b></h5>
								<h5 id="metodo_pago"><b></b></h5><br>
							</div>
						</div>
						<h5 id="regimen" class="text-center"><b></b></h5><br>
						<h5 id="domicilio" class="text-center"><b></b></h5><br>
						<h5 id="cfdi" class="text-center"><b></b></h5><br>
					</div>
				</div>
			</div>
		</div>
	</div>
  <div id="seccionEditarRequisicion" class="hidden">
    <div class="alert alert-info text-center" id="nombreRequisicion"></div>
    <div class="card mb-5">
	  	<h5 class="card-header text-center seccion">Datos de Facturación</h5>
		  <div class="card-body">
        <form id="formDatosFacturacionRequisicion">
          <div class="row">
            <div class="col-6">
              <label>Nombre comercial *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" id="comercial_update" name="comercial_update" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              </div>
            </div>
            <div class="col-6">
              <label>Razón social *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" id="nombre_update" name="nombre_update" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Domicilio Fiscal *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-home"></i></span>
                </div>
                <input type="text" class="form-control" id="domicilio_update" name="domicilio_update" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Código postal *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-home"></i></span>
                </div>
                <input type="number" class="form-control solo_numeros" id="cp_update" name="cp_update" maxlength="5">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Teléfono *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                </div>
                <input type="text" class="form-control" id="telefono_update" name="telefono_update" maxlength="16">
              </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label>Correo *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-envelope"></i></span>
                </div>
                <input type="text" class="form-control" id="correo_update" name="correo_update" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
              </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label>Contacto *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" id="contacto_update" name="contacto_update">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Régimen Fiscal *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                </div>
                <input type="text" class="form-control" id="regimen_update" name="regimen_update" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>RFC *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" id="rfc_update" name="rfc_update" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" maxlength="13">
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Forma de pago *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                </div>
                <select class="custom-select" id="forma_pago_update" name="forma_pago_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Pago en una sola exhibición">Pago en una sola exhibición</option>
                  <option value="Pago en parcialidades o diferidos">Pago en parcialidades o diferidos</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label>Método de pago *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                </div>
                <select class="custom-select" id="metodo_pago_update" name="metodo_pago_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Efectivo">Efectivo</option>
                  <option value="Cheque nominativo">Cheque nominativo</option>
                  <option value="Transferencia electrónica de fondos">Transferencia electrónica de fondos</option>
                  <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                  <option value="Tarjeta de débito">Tarjeta de débito</option>
                  <option value="Por definir">Por definir</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Uso de CFDI (Reescibra el uso de cfdi en caso de ser diferente) *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                </div>
                <input type="text" class="form-control" id="uso_cfdi_update" name="uso_cfdi_update" value="Gastos en General">
              </div>
            </div>
          </div>
        </form>
        <button type="button" class="btn btn-success btn-block text-lg" onclick="updateOrder('data_facturacion')">Guardar Datos de Facturación</button>
	    </div>
	  </div>
    <div class="card mb-5">
	  	<h5 class="card-header text-center seccion">Información de la Vacante</h5>
		  <div class="card-body">
        <form id="formVacante">
          <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Nombre de la posición *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                </div>
                <input type="text" class="form-control" id="puesto_update" name="puesto_update">
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Número de vacantes *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                </div>
                <input type="number" class="form-control" id="num_vacantes_update" name="num_vacantes_update">
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Formación académica requerida *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                </div>
                <select class="custom-select" id="escolaridad_update" name="escolaridad_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Primaria">Primaria</option>
                  <option value="Secundaria">Secundaria</option>
                  <option value="Bachiller">Bachiller</option>
                  <option value="Licenciatura">Licenciatura</option>
                  <option value="Maestría">Maestría</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Estatus académico *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                </div>
                <select class="custom-select" id="estatus_escolaridad_update" name="estatus_escolaridad_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Técnico">Técnico</option>
                  <option value="Pasante">Pasante</option>
                  <option value="Estudiante">Estudiante</option>
                  <option value="Titulado">Titulado</option>
                  <option value="Trunco">Trunco</option>
                  <option value="Otro">Otro</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Otro estatus académico</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                </div>
                <input type="text" class="form-control" id="otro_estatus_update" name="otro_estatus_update" disabled>
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Carrera requerida para el puesto *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                </div>
                <input type="text" class="form-control" id="carrera_update" name="carrera_update">
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Otros estudios</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                </div>
                <input type="text" class="form-control" id="otros_estudios_update" name="otros_estudios_update">
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Idiomas que habla y porcentajes de cada uno</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-language"></i></span>
                </div>
                <input type="text" class="form-control" id="idiomas_update" name="idiomas_update">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label>Habilidades informáticas requeridas</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                </div>
                <input type="text" class="form-control" id="hab_informatica_update" name="hab_informatica_update">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Sexo *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                </div>
                <select class="custom-select" id="genero_update" name="genero_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Femenino">Femenino</option>
                  <option value="Masculino">Masculino</option>
                  <option value="Indistinto">Indistinto</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Estado civil *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                </div>
                <select class="custom-select" id="civil_update" name="civil_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Soltero(a)">Soltero(a)</option>
                  <option value="Casado(a)">Casado(a)</option>
                  <option value="Indistinto">Indistinto</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Edad mínima *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-minus"></i></span>
                </div>
                <input type="number" id="edad_minima_update" name="edad_minima_update" class="form-control">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Edad máxima *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-plus"></i></span>
                </div>
                <input type="number" id="edad_maxima_update" name="edad_maxima_update" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Licencia de conducir *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                </div>
                <select class="custom-select" id="licencia_update" name="licencia_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Indispensable">Indispensable</option>
                  <option value="Deseable">Deseable</option>
                  <option value="No necesaria">No necesaria</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Tipo de licencia de conducir*</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                </div>
                <input type="text" class="form-control" id="tipo_licencia_update" name="tipo_licencia_update" disabled>
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Discapacidad aceptable *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-wheelchair"></i></span>
                </div>
                <select class="custom-select" id="discapacidad_update" name="discapacidad_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Motora">Motora</option>
                  <option value="Auditiva">Auditiva</option>
                  <option value="Visual">Visual</option>
                  <option value="Motora y auditiva">Motora y auditiva</option>
                  <option value="Motora y visual">Motora y visual</option>
                  <option value="Sin discapacidad">Sin discapacidad</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Causa que origina la vacante *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-question-circle"></i></span>
                </div>
                <select class="custom-select" id="causa_update" name="causa_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Empresa nueva">Empresa nueva</option>
                  <option value="Empleo temporal">Empleo temporal</option>
                  <option value="Puesto de nueva creación">Puesto de nueva creación</option>
                  <option value="Reposición de personal">Reposición de personal</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label>Lugar de residencia *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-home"></i></span>
                </div>
                <input type="text" class="form-control" id="residencia_update" name="residencia_update">
              </div>
            </div>
          </div>
        </form>
        <button type="button" class="btn btn-success btn-block text-lg" onclick="updateOrder('vacante')">Guardar Información de la Vacante</button>
	    </div>
	  </div>
    <div class="card mb-5">
	  	<h5 class="card-header text-center seccion">Información sobre el Cargo</h5>
		  <div class="card-body">
        <form id="formCargo">
          <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Jornada laboral *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-clock"></i></span>
                </div>
                <select class="custom-select" id="jornada_update" name="jornada_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Tiempo completo">Tiempo completo</option>
                  <option value="Medio tiempo">Medio tiempo</option>
                  <option value="Horas">Horas</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Inicio de la Jornada laboral *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-clock"></i></span>
                </div>
                <input type="text" class="form-control" id="tiempo_inicio_update" name="tiempo_inicio_update">
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Fin de la Jornada laboral *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-clock"></i></span>
                </div>
                <input type="text" class="form-control" id="tiempo_final_update" name="tiempo_final_update">
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Día(s) de descanso *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-bed"></i></span>
                </div>
                <input type="text" class="form-control" id="descanso_update" name="descanso_update">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Disponibilidad para viajar *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-plane"></i></span>
                </div>
                <select class="custom-select" id="viajar_update" name="viajar_update">
                  <option value="" selected>Selecciona</option>
                  <option value="NO">NO</option>
                  <option value="SI">SI</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Disponibilidad de horario *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-clock"></i></span>
                </div>
                <select class="custom-select" id="horario_update" name="horario_update">
                  <option value="" selected>Selecciona</option>
                  <option value="NO">NO</option>
                  <option value="SI">SI</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Lugar de la entrevista *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                </div>
                <textarea name="lugar_entrevista_update" id="lugar_entrevista_update" class="form-control" rows="3"></textarea>
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Zona de trabajo *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                </div>
                <textarea name="zona_update" id="zona_update" class="form-control" rows="3"></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Tipo de sueldo *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
                </div>
                <select class="custom-select" id="tipo_sueldo_update" name="tipo_sueldo_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Fijo">Fijo</option>
                  <option value="Variable">Variable</option>
                  <option value="Neto">Neto (libre)</option>
                  <option value="Nominal">Nominal</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Sueldo mínimo</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-minus"></i></span>
                </div>
                <input type="number" class="form-control" id="sueldo_minimo_update" name="sueldo_minimo_update">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Sueldo máximo *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-plus"></i></span>
                </div>
                <input type="number" class="form-control" id="sueldo_maximo_update" name="sueldo_maximo_update">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Adicional al sueldo *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                </div>
                <select class="custom-select" id="sueldo_adicional_update" name="sueldo_adicional_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Comisión">Comisión</option>
                  <option value="Bono">Bono</option>
                  <option value="N/A">N/A</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Monto</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                </div>
                <input type="text" class="form-control" id="monto_adicional_update" name="monto_adicional_update" disabled>
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label>Tipo de pago *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
                </div>
                <select class="custom-select" id="tipo_pago_update" name="tipo_pago_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Mensual">Mensual</option>
                  <option value="Quincenal">Quincenal</option>
                  <option value="Semanal">Semanal</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label>¿Tendrá prestaciones de ley? *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-gavel"></i></span>
                </div>
                <select class="custom-select" id="tipo_prestaciones_update" name="tipo_prestaciones_update">
                  <option value="" selected>Selecciona</option>
                  <option value="SI">SI</option>
                  <option value="NO">NO</option>
                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label>¿Tendrá prestaciones superiores? ¿Cuáles?</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-gavel"></i></span>
                </div>
                <input type="text" class="form-control" id="superiores_update" name="superiores_update">
              </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label>¿Tendrá otro tipo de prestaciones? ¿Cuáles? </label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-gavel"></i></span>
                </div>
                <input type="text" class="form-control" id="otras_prestaciones_update" name="otras_prestaciones_update">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
              <label>Se requiere experiencia en: *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-id-badge"></i></span>
                </div>
                <textarea name="experiencia_update" id="experiencia_update" class="form-control" rows="4"></textarea>
              </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
              <label>Actividades a realizar: *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
                </div>
                <textarea name="actividades_update" id="actividades_update" class="form-control" rows="4"></textarea>
              </div>
            </div>
          </div>
        </form>
        <button type="button" class="btn btn-success btn-block text-lg" onclick="updateOrder('cargo')">Guardar Información sobre el Cargo</button>
	    </div>
	  </div>
    <div class="card mb-5">
	  	<h5 class="card-header text-center seccion">Perfil del Cargo</h5>
	  	<h5 class="text-center mt-3 my-3">Competencias requeridas para el puesto:</h5>
		  <div class="card-body">
        <form id="formPerfil">
          <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label class="container_checkbox">Comunicación
                <input type="checkbox" id="Comunicación">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Análisis
                <input type="checkbox" id="Análisis">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Liderazgo
                <input type="checkbox" id="Liderazgo">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Negociación
                <input type="checkbox" id="Negociación">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Apego a normas
                <input type="checkbox" id="Apego-a-normas">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Planeación
                <input type="checkbox" id="Planeación">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Organización
                <input type="checkbox" id="Organización">
                <span class="checkmark"></span>
              </label>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label class="container_checkbox">Orientado a resultados
                <input type="checkbox" id="Orientado-a-resultados">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Manejo de conflictos
                <input type="checkbox" id="Manejo-de-conflictos">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Trabajo en equipo
                <input type="checkbox" id="Trabajo-en-equipo">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Toma de decisiones
                <input type="checkbox" id="Toma-de-decisiones">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Trabajo bajo presión
                <input type="checkbox" id="Trabajo-bajo-presión">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Don de mando
                <input type="checkbox" id="Don-de-mando">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Versátil
                <input type="checkbox" id="Versátil">
                <span class="checkmark"></span>
              </label>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label class="container_checkbox">Sociable
                <input type="checkbox" id="Sociable">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Intuitivo
                <input type="checkbox" id="Intuitivo">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Autodidacta
                <input type="checkbox" id="Autodidacta">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Creativo
                <input type="checkbox" id="Creativo">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Proactivo
                <input type="checkbox" id="Proactivo">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Adaptable
                <input type="checkbox" id="Adaptable">
                <span class="checkmark"></span>
              </label>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Observaciones adicionales</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-eye"></i></span>
                </div>
                <textarea name="observaciones_update" id="observaciones_update" class="form-control" rows="4"></textarea>
              </div>
            </div>
          </div>
        </form>
        <button type="button" class="btn btn-success btn-block text-lg" onclick="updateOrder('perfil')">Guardar Competencias requeridas para el puesto</button>
	    </div>
	  </div>
  </div>
</div>

<!-- Sweetalert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>

<script>
	$(document).ready(function() {
    let url_orders = '<?php echo base_url('Reclutamiento/requisicion'); ?>';
    let sortOption = '<?php echo $sortOrder ?>';
    let filterOption = '<?php echo $filter ?>';
    $('#ordenar').val(sortOption).trigger('change');
    $('#filtrar').val(filterOption).trigger('change');

    $('#ordenar').change(function(){
      let opcion = $(this).val();
      let filtrar = $('#filtrar').val();
      let filter = ''; let sort = '';
      var oldURL = url_orders;
      if (history.pushState) {
        if(filtrar != ''){
          filter = "?filter=" + filtrar;
          sort = "&sort=" + opcion
        }else{
          sort = "?sort=" + opcion
        }
        var newUrl = oldURL + filter + sort;
        $(location).attr('href',newUrl);
      }
      return false;
    })
    $('#filtrar').change(function(){
      let opcion = $(this).val();
      let ordenar = $('#ordenar').val();
      let sort = ''; let filter = '';
      var oldURL = url_orders;
      if (history.pushState) {
        if(ordenar != ''){
          sort = "?sort=" + ordenar;
          filter = "&filter=" + opcion;
        }else{
          filter = "?filter=" + opcion;
        }
        var newUrl = oldURL + sort + filter;
        $(location).attr('href',newUrl);
      }
      return false;
    })
    $('#buscador').change(function(){
      var opcion = $(this).val();
      var oldURL = url_orders;
      if (history.pushState) {
        var newUrl = oldURL + "?order=" + opcion;
        $(location).attr('href',newUrl);
      }
      return false;
    })
		$('.nav-link').click(function(){
			$('.nav-link').removeClass('active');
			$(this).addClass('active');
		})
		$('#link_vacante').click(function(){
			$('.div_info').css('display','none');
			$('#div_vacante').css('display','block');
		})
		$('#link_cargo').click(function(){
			$('.div_info').css('display','none');
			$('#div_cargo').css('display','block');
		})
		$('#link_perfil').click(function(){
			$('.div_info').css('display','none');
			$('#div_perfil').css('display','block');
		})
		$('#link_factura').click(function(){
			$('.div_info').css('display','none');
			$('#div_factura').css('display','block');
		})
    $('#estatus_escolaridad_update').change(function(){
      var opcion = $(this).val();
      if(opcion == "Otro"){
        $('#otro_estatus_update').prop('disabled', false);
      }
      else{
        $('#otro_estatus_update').prop('disabled', true);
        $('#otro_estatus_update').val('');
      }
    })
    $('#licencia_update').change(function(){
      var opcion = $(this).val();
      if(opcion != "No necesaria"){
        $('#tipo_licencia_update').prop('disabled', false);
      }
      else{
        $('#tipo_licencia_update').prop('disabled', true);
        $('#tipo_licencia_update').val('');
      }
    })
    $('#sueldo_adicional_update').change(function(){
      var opcion = $(this).val();
      if(opcion != "N/A"){
        $('#monto_adicional_update').prop('disabled', false);
      }
      else{
        $('#monto_adicional_update').prop('disabled', true);
        $('#monto_adicional_update').val('');
      }
    });
	})
	function regresarListado(){
		location.reload();
	}
	function iniciarProceso(id, nombre){
		$('#titulo_mensaje').text('Confirmación de inicio de requisición');
		$('#mensaje').html('¿Desea iniciar el proceso de la requisición <b>#'+id+' '+nombre+'</b>?');
		$('#idRequisicion').val(id);
		$('#btnConfirmar').attr("onclick","confirmarAccion(1,0)");
		$('#mensajeModal').modal('show');
	}
	function confirmarAccion(accion,valor){
		$('#mensajeModal').modal('hide');
		var id = $('#idRequisicion').val();
		//Colocar en privado o publico
		if(accion == 1){
			$.ajax({
				url: '<?php echo base_url('Reclutamiento/iniciarRequisicion'); ?>',
				type: 'post',
				data: {
					'id': id
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
						$('#divIniciar'+id).html('<h5 class="text-info"><b>En proceso</b></h5>');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: dato.msg,
							showConfirmButton: false,
							timer: 3000
						})
						setTimeout(function(){
							location.reload();
						},3000)
					}
				}
			});
		}
    //Eliminar requisicion
    if(accion == 2){
      let comentario = $('#mensaje_comentario').val();
			$.ajax({
				url: '<?php echo base_url('Reclutamiento/deleteOrder'); ?>',
				type: 'post',
				data: {
					'id': id,
          'comentario': comentario
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
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: dato.msg,
							showConfirmButton: false,
							timer: 2500
						})
						setTimeout(function(){
							location.reload();
						},2500)
					}
				}
			});
		}
	}
	function verDetalles(id) {
		$.ajax({
			url: '<?php echo base_url('Reclutamiento/getDetailsOrderById'); ?>',
			type: 'post',
			data: {'id':id},
			beforeSend: function() {
				$('.loader').css("display", "block");
			},
			success: function(res) {
				setTimeout(function() {
					$('.loader').fadeOut();
				}, 200);
				var dato = JSON.parse(res);
        $('#btnBack').css('display','block');
				$('#tarjetas').css('display','none');
        $('#divFiltros').css('display','none')
        $('#btnNuevaRequisicion').addClass('isDisabled')
        $('#btnOpenAssignToUser').addClass('isDisabled')
        let nombres = (dato['nombre_comercial'] === '' || dato['nombre_comercial'] === null)? dato['nombre'] : dato['nombre']+'<br>'+dato['nombre_comercial'];
				$('#empresa').html('<h3># '+dato['id']+' '+nombres+'<br><b>'+dato['puesto']+'</b></h3>');
				//Vacante
				$('#vacantes').html('<b>Vacantes:</b> '+dato['numero_vacantes'])
        let escolaridad = dato['escolaridad'] ?? 'No registrado';
				$('#escolaridad').html('<b>Formación académica requerida:</b> '+escolaridad)
				let estatus_escolar = (dato['estatus_escolar'] == 'Otro')? dato['otro_estatus_escolar'] : dato['estatus_escolar'] ?? 'No registrado';
				$('#estatus_escolar').html('<b>Estatus académico:</b> '+estatus_escolar)
        let carrera_requerida = dato['carrera_requerida'] ?? 'No registrado';
				$('#carrera').html('<b>Carrera requerida para el puesto:</b> '+carrera_requerida)
        let otros_estudios = (dato['otros_estudios'] === '' || dato['otros_estudios'] === null)? 'No registrado' : dato['otros_estudios'];
				$('#otros_estudios').html('<b>Otros estudios:</b> '+otros_estudios)
				let idiomas = (dato['idiomas'] == '')? 'No registrado' : dato['idiomas'] ?? 'No registrado';
				$('#idiomas').html('<b>Idiomas:</b> '+idiomas)
				let hab_informatica = (dato['habilidad_informatica'] == '')? 'No registrado' : dato['habilidad_informatica'] ?? 'No registrado';
				$('#hab_informatica').html('<b>Habilidades informáticas:</b><br> '+hab_informatica)
        let genero = dato['genero'] ?? 'No registrado';
				$('#sexo').html('<b>Sexo:</b> '+genero)
        let estado_civil = dato['estado_civil'] ?? 'No registrado';
				$('#civil').html('<b>Estado civil:</b> '+estado_civil)
        let edad_minima = dato['edad_minima'] ?? 'No registrado';
				$('#edad_min').html('<b>Edad mínima:</b> '+edad_minima)
        let edad_maxima = dato['edad_maxima'] ?? 'No registrado';
				$('#edad_max').html('<b>Edad máxima:</b> '+edad_maxima)
        let licencia = dato['licencia'] ?? 'No registrado';
				$('#licencia').html('<b>Licencia de conducir:</b> '+licencia)
        let discapacidad_aceptable = dato['discapacidad_aceptable'] ?? 'No registrado';
				$('#discapacidad').html('<b>Discapacidad aceptable:</b> '+discapacidad_aceptable)
        let causa_vacante = dato['causa_vacante'] ?? 'No registrado';
				$('#causa').html('<b>Causa que origina la vacante:</b><br> '+causa_vacante)
        let lugar_residencia = (dato['lugar_residencia'] === '' || dato['lugar_residencia'] === null)? 'No registrado' : dato['lugar_residencia'];
				$('#residencia').html('<b>Lugar de residencia:</b> '+lugar_residencia)
				//Cargo
        let jornada_laboral = dato['jornada_laboral'] ?? 'No registrado';
				$('#jornada').html('<b>Jornada laboral:</b> '+jornada_laboral)
        let tiempo_inicio = dato['tiempo_inicio'] ?? 'No registrado';
				$('#inicio').html('<b>Inicio de la Jornada laboral:</b> '+tiempo_inicio)
        let tiempo_final = dato['tiempo_final'] ?? 'No registrado';
				$('#final').html('<b>Fin de la Jornada laboral:</b> '+tiempo_final)
        let dias_descanso = dato['dias_descanso'] ?? 'No registrado';
				$('#descanso').html('<b>Día(s) de descanso:</b> '+dias_descanso)
        let disponibilidad_viajar = dato['disponibilidad_viajar'] ?? 'No registrado';
				$('#viajar').html('<b>Disponibilidad para viajar:</b> '+disponibilidad_viajar)
        let disponibilidad_horario = dato['disponibilidad_horario'] ?? 'No registrado';
				$('#horario').html('<b>Disponibilidad de horario:</b> '+disponibilidad_horario)
        let lugar_entrevista = (dato['lugar_entrevista'] === '' || dato['lugar_entrevista'] === null)? 'No registrado' : dato['lugar_entrevista'];
				$('#lugar_entrevista_detalle').html('<b>Lugar de la entrevista:</b><br> '+lugar_entrevista)
        let zona_trabajo = dato['zona_trabajo'] ?? 'No registrado';
				$('#zona').html('<b>Zona de trabajo:</b><br> '+zona_trabajo)
        let sueldo = dato['sueldo'] ?? 'No registrado';
				$('#tipo_sueldo').html('<b>Tipo de sueldo:</b> '+sueldo)
				let sueldo_min = (dato['sueldo_minimo'] == 0 || dato['sueldo_minimo'] === null)? 'No registrado' : dato['sueldo_minimo'];
				$('#sueldo_min').html('<b>Sueldo mínimo:</b> '+sueldo_min)
				let sueldo_maximo = (dato['sueldo_maximo'] == 0 || dato['sueldo_maximo'] === null)? 'No registrado' : dato['sueldo_maximo'];
				$('#sueldo_max').html('<b>Sueldo máximo:</b> '+sueldo_maximo)
        let sueldo_adicional = dato['sueldo_adicional'] ?? 'No registrado';
				$('#sueldo_adicional').html('<b>Sueldo adicional:</b> '+sueldo_adicional)
				$('#tipo_pago').html('<b>Tipo de pago:</b> '+dato['tipo_pago_sueldo'])
				$('#tipo_prestaciones').html('<b>¿Tendrá prestaciones de ley?</b> '+dato['tipo_prestaciones'])
				let superiores = (dato['tipo_prestaciones_superiores'] == '')? 'No registrado' : dato['tipo_prestaciones_superiores'] ?? 'No registrado';
				$('#superiores').html('<b>¿Tendrá prestaciones superiores? ¿Cuáles?</b><br> '+superiores)
				let otras_prestaciones = (dato['otras_prestaciones'] == '')? 'No registrado' : dato['otras_prestaciones'] ?? 'No registrado';
				$('#otras_prestaciones').html('<b>¿Tendrá otro tipo de prestaciones? ¿Cuáles?</b><br> '+otras_prestaciones)
        let experiencia = (dato['experiencia'] === '' || dato['experiencia'] === null)? 'No registrado' : dato['experiencia'];
				$('#experiencia').html('<b>Experiencia:</b><br> '+experiencia)
        let actividades = dato['actividades'] ?? 'No registrado';
				$('#actividades').html('<b>Actividades:</b><br> '+actividades)
				//Perfil del cargo
        let comp = '';
        if(dato['competencias'] != null){
          let aux = dato['competencias'].split('_');
          comp = aux.slice(0, -1);
        }else{
          comp = 'No registrado';
        }
				$('#competencias').html('<b>Competencias requeridas para el puesto:</b><br> '+comp)
				let observaciones = (dato['observaciones'] == '')? 'No registrado' : dato['observaciones'] ?? 'No registrado';
				$('#observaciones').html('<b>Observaciones adicionales:</b><br> '+observaciones)
				//Facturacion
				$('#telefono_req').html('<b>Teléfono:</b> '+dato['telefono'])
        let rfc = (dato['rfc'] === '' || dato['rfc'] === null)? 'No registrado' : dato['rfc'];
				$('#rfc').html('<b>RFC:</b> '+rfc)
        let correo = dato['correo'] ?? 'No registrado';
				$('#correo_req').html('<b>Correo:</b> '+correo)
				$('#contacto').html('<b>Contacto:</b> '+dato['contacto'])
        let forma_pago = dato['forma_pago'] ?? 'No registrado';
				$('#forma_pago').html('<b>Forma de pago:</b> '+forma_pago)
        let metodo_pago = dato['metodo_pago'] ?? 'No registrado';
				$('#metodo_pago').html('<b>Método de pago:</b><br> '+metodo_pago)
        let uso_cfdi = dato['uso_cfdi'] ?? 'No registrado';
				$('#cfdi').html('<b>Uso de CFDI:</b><br> '+uso_cfdi)
        let regimen = dato['regimen'] ?? 'No registrado';
				$('#regimen').html('<b>Régimen fiscal:</b> '+regimen)
        let domicilio = (dato['domicilio'] === '' || dato['domicilio'] === null)? 'No registrado' : dato['domicilio'];
        let cp = (dato['cp'] === '' || dato['cp'] === null)? 'No registrado' : dato['cp'];
				$('#domicilio').html('<b>Domicilio fiscal:</b> '+domicilio+' <b>Código postal: </b> '+cp+'<br>')
			
				$('#tarjeta_detalle').css('display','block');
			}
		});
	}
  function nuevaRequisicion(){
    $('#nuevaRequisicionModal').modal('show')
    $('#currentPage').val('requisicion');
  }
  //* Asignacion de Usuario a requisicion
  function openAssignToUser(){
    let url = '<?php echo base_url('Reclutamiento/assignToUser'); ?>';
		$('#titulo_asignarUsuarioModal').text('Asignar requisicion a un reclutador');
		$('label[for="asignar_usuario"]').text('Reclutador *');
		$('label[for="asignar_registro"]').text('Requisicion *');
    $('#asignar_usuario').attr("name","asignar_usuario[]");
		$('#btnAsignar').attr("onclick","assignToUser(\""+url+"\",'requisicion')");
		$('#asignarUsuarioModal').modal('show');
	}
  function verExamenesCandidatos(id, nombre){
    $(".nombreRegistro").text('#'+id+' '+nombre);
    $('#divContenido').empty();
    let salida = '';
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/getTestsByOrder'); ?>',
      type: 'post',
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
        salida += '<table class="table table-striped" style="font-size: 14px">';
        salida += '<tr style="background: gray;color:white;">';
        salida += '<th>Candidato</th>';
        salida += '<th>Avances/Estatus</th>';
        salida += '<th>ESE</th>';
        salida += '<th>Doping</th>';
        salida += '<th>Médico</th>';
        salida += '<th>Psicometría</th>';
        salida += '</tr>';
        if(res != 0){
          var dato = JSON.parse(res);
          let socio = ''; let previo = ''; let colorESE = ''; let colorDoping = ''; let doping = ''; let medico = ''; let psicometria = '';
          for(let i = 0; i < dato.length; i++){
            //ESE
            if(dato[i]['status_bgc'] > 0){
              switch(dato[i]['status_bgc']){
                case '1': 
                case '4': 
                  colorESE = 'btn-success';
                  break;
                case '2': 
                  colorESE = 'btn-danger';
                  break;
                case '3': 
                case '5': 
                  colorESE = 'btn-warning';
                  break;
              }
              socio = '<div><form onsubmit="return downloadFile()" id="reporteForm'+dato[i]['idCandidato']+'" action="<?php echo base_url('Candidato_Conclusion/createPDF'); ?>" method="POST"><button type="submit" data-toggle="tooltip" title="Descargar reporte PDF" id="reportePDF" class="btn '+colorESE+' text-lg"><i class="fas fa-file-pdf"></i></button><input type="hidden" name="idCandidatoPDF" id="idCandidatoPDF'+dato[i]['idCandidato']+'" value="'+dato[i]['idCandidato']+'"></form></div>';
            }else{
              previo = (dato[i]['fecha_nacimiento'] != null && dato[i]['fecha_nacimiento'] != '0000-00-00')?' <div><form onsubmit="return downloadFile()" id="reportePrevioForm'+dato[i]['idCandidato']+'" action="<?php echo base_url('Candidato_Conclusion/createPrevioPDF'); ?>" method="POST"><button type="submit" href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte previo" id="reportePrevioPDF" class="btn btn-secondary text-lg"><i class="far fa-file-powerpoint"></i></button><input type="hidden" name="idPDF" id="idPDF'+dato[i]['idCandidato']+'" value="'+dato[i]['idCandidato']+'"></form></div>' : '';

              socio = 'En proceso';
            }
            //Doping
            if(dato[i]['antidoping'] > 0){
              if(dato[i]['resultado_doping'] !== -1 && dato[i]['resultado_doping'] !== null){
                switch(dato[i]['resultado_doping']){
                  case '0': 
                    colorDoping = 'btn-success';
                    break;
                  case '1': 
                    colorDoping = 'btn-danger';
                    break;
                }
                doping = '<div><form onsubmit="return downloadFile()" id="pdfForm' + dato[i]['idDoping'] + '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><button type="submit" data-toggle="tooltip" title="Descargar doping" id="pdfDoping" class="btn '+colorDoping+' text-lg"><i class="fas fa-file-pdf"></i></button><input type="hidden" name="idDop" id="idDop' + dato[i]['idDoping'] + '" value="' + dato[i]['idDoping'] + '"></form></div>';
              }else{
                doping = 'Pendiente';
              }
            }else{
              doping = 'No aplica';
            }
            //Medico
            if(dato[i]['medico'] > 0){
              if(dato[i]['conclusionMedica'] !== null){
								medico = '<div><form onsubmit="return downloadFile()" action="<?php echo base_url('Medico/crearPDF'); ?>" method="POST"><button type="submit" data-toggle="tooltip" title="Descargar examen medico" id="pdfFinal" class="btn btn-info text-lg"><i class="fas fa-file-pdf"></i></button><input type="hidden" name="idMedico" id="idMedico' + dato[i]['idMedico'] + '" value="' + dato[i]['idMedico'] + '"></form></div>';
              }
              else{
                medico = 'En proceso';
              }
            }else{
              medico = 'No aplica';
            }
            //Psicometria
            if(dato[i]['psicometrico'] > 0){
              if(dato[i]['archivoPsicometria'] !== null){
								psicometria = '<a href="' + url_psicometrias + dato[i]['archivoPsicometria'] + '" target="_blank" data-toggle="tooltip" title="Descargar examen psicometrico" class="btn btn-info text-lg"><i class="fas fa-file-pdf"></i></a>';
              }
              else{
                psicometria = 'En proceso';
              }
            }else{
              psicometria = 'No aplica';
            }

            salida += "<tr>";
            salida += '<td>#'+dato[i]['idCandidato']+' '+dato[i]['candidato']+'</td>';
            salida += '<td><a href="javascript:void(0)" data-toggle="tooltip" title="Mensajes de avances" id="msj_avances" class="btn btn-primary" onclick="verMensajesAvances('+dato[i]['idCandidato']+',\''+dato[i]['candidato']+'\')"><i class="fas fa-comment-dots"></i></a></td>';
            salida += '<td>'+previo+' '+socio+'</td>';
            salida += '<td>'+doping+'</td>';
            salida += '<td>'+medico+'</td>';
            salida += '<td>'+psicometria+'</td>';
            salida += "</tr>";
          }
        }
        else{
          salida += "<tr>";
          salida += '<td colspan="6" class="text-center"><h5>No hay candidatos con ESE para esta requisición</h5></td>';
          salida += "</tr>";
        }
        salida += "</table>";
        $('#divContenido').html(salida);
        $("#resultadosModal").modal('show');
      }
    });
  }
  //* Edicion de la requisicion express
  function openUpdateOrder(id, nombre, nombre_comercial, puesto){
    $('#idRequisicion').val(id)
    let nombres = (nombre_comercial === '' || nombre_comercial === null)? nombre : nombre+'<br>'+nombre_comercial;
    $('#nombreRequisicion').html('<h3># '+id+' '+nombres+'<br><b>'+puesto+'</b></h3>');
    $.ajax({
			url: '<?php echo base_url('Reclutamiento/getDetailsOrderById'); ?>',
			type: 'post',
			data: {'id':id},
			beforeSend: function() {
				$('.loader').css("display", "block");
			},
			success: function(res) {
				setTimeout(function() {
					$('.loader').fadeOut();
				}, 200);
				var dato = JSON.parse(res);
        //Facturacion
				$('#nombre_update').val(dato['nombre'])
				$('#comercial_update').val(dato['nombre_comercial'])
				$('#domicilio_update').val(dato['domicilio'])
				$('#cp_update').val(dato['cp'])
				$('#regimen_update').val(dato['regimen'])
				$('#telefono_update').val(dato['telefono'])
				$('#correo_update').val(dato['correo'])
				$('#contacto_update').val(dato['contacto'])
				$('#rfc_update').val(dato['rfc'])
				$('#forma_pago_update').val(dato['forma_pago'])
				$('#metodo_pago_update').val(dato['metodo_pago'])
        let cfdi = dato['uso_cfdi'] ?? 'Gastos en general';
				$('#uso_cfdi_update').val(cfdi)
				//Vacante
				$('#puesto_update').val(dato['puesto'])
				$('#num_vacantes_update').val(dato['numero_vacantes'])
				$('#escolaridad_update').val(dato['escolaridad'])
				$('#estatus_escolaridad_update').val(dato['estatus_escolar'])
				if(dato['estatus_escolar'] == 'Otro'){
				  $('#otro_estatus_update').prop('disabled', false)
				  $('#otro_estatus_update').val(dato['otro_estatus_escolar'])
        }else{
          $('#otro_estatus_update').prop('disabled', true)
				  $('#otro_estatus_update').val('')
        } 
				$('#carrera_update').val(dato['carrera_requerida'])
				$('#otros_estudios_update').val(dato['otros_estudios'])
        $('#idiomas_update').val(dato['idiomas'])
				$('#hab_informatica_update').val(dato['habilidad_informatica'])
				$('#genero_update').val(dato['genero'])
				$('#civil_update').val(dato['estado_civil'])
				$('#edad_minima_update').val(dato['edad_minima'])
				$('#edad_maxima_update').val(dato['edad_maxima'])
        if(dato['licencia'] !== '' && dato['licencia'] !== null){
          let licencia = dato['licencia'].split(' ');
          $('#licencia_update').val(licencia[0])
          if(dato['licencia'] != 'No necesaria'){
            $('#tipo_licencia_update').prop('disabled', false)
            $('#tipo_licencia_update').val(licencia[1])
          }
          else{
            $('#tipo_licencia_update').prop('disabled', true)
				    $('#tipo_licencia_update').val('')
          }
        }else{
          $('#licencia_update').val('')
          $('#tipo_licencia_update').prop('disabled', true)
          $('#tipo_licencia_update').val('')
        }
				$('#discapacidad_update').val(dato['discapacidad_aceptable'])
				$('#causa_update').val(dato['causa_vacante'])
				$('#residencia_update').val(dato['lugar_residencia'])
				//Cargo
				$('#jornada_update').val(dato['jornada_laboral'])
				$('#tiempo_inicio_update').val(dato['tiempo_inicio'])
				$('#tiempo_final_update').val(dato['tiempo_final'])
				$('#descanso_update').val(dato['dias_descanso'])
				$('#viajar_update').val(dato['disponibilidad_viajar'])
				$('#horario_update').val(dato['disponibilidad_horario'])
				$('#lugar_entrevista_update').val(dato['lugar_entrevista'])
				$('#zona_update').val(dato['zona_trabajo'])
				$('#tipo_sueldo_update').val(dato['sueldo'])
				$('#sueldo_minimo_update').val(dato['sueldo_minimo'])
				$('#sueldo_maximo_update').val(dato['sueldo_maximo'])
        if(dato['sueldo_adicional'] !== '' && dato['sueldo_adicional'] !== null){
          let sueldo_adicional = dato['sueldo_adicional'].split(' por ');
          $('#sueldo_adicional_update').val(sueldo_adicional[0])
          if(dato['sueldo_adicional'] != '"N/A'){
            $('#monto_adicional_update').prop('disabled', false)
            $('#monto_adicional_update').val(sueldo_adicional[1])
          }else{
            $('#monto_adicional_update').prop('disabled', true)
            $('#monto_adicional_update').val('')
          } 
        }else{
          $('#sueldo_adicional_update').val('')
          $('#monto_adicional_update').prop('disabled', true)
          $('#monto_adicional_update').val('')
        }
				$('#tipo_pago_update').val(dato['tipo_pago_sueldo'])
				$('#tipo_prestaciones_update').val(dato['tipo_prestaciones'])
				$('#superiores_update').val(dato['tipo_prestaciones_superiores'])
				$('#otras_prestaciones_update').val(dato['otras_prestaciones'])
				$('#experiencia_update').val(dato['experiencia'])
				$('#actividades_update').val(dato['actividades'])
				//Perfil del cargo
        if(dato['competencias'] != null){
          let competencias = ''; let isIncluded = false;
          let auxiliar = dato['competencias'].split('_');
          competencias = auxiliar.slice(0, -1);
          for(let i = 0; i < competencias.length; i++){
            let competencia = competencias[i].replaceAll(' ', '-')
            competencias.includes(competencia)
            $('#'+competencia).prop('checked', true);
          }
        }
				$('#observaciones_update').val(dato['observaciones'])
			}
		});
    $('#divFiltros').css('display','none')
    $('#seccionTarjetas').addClass('hidden')
    $('#btnBack').css('display','block');
    $('#seccionEditarRequisicion').css('display','block')
    $('#btnNuevaRequisicion').addClass('isDisabled')
    $('#btnOpenAssignToUser').addClass('isDisabled')
  }
  function updateOrder(section){
    let form = ''; 
    if(section == 'data_facturacion'){
      form = $('#formDatosFacturacionRequisicion').serialize();
      form += '&id_requisicion=' + $('#idRequisicion').val();
      form += '&section=' + section;
    }
    if(section == 'vacante'){
      let licencia = $('#licencia_update').val();
      let tipo_licencia = $('#tipo_licencia_update').val();
      form = $('#formVacante').serialize();
      form += '&id_requisicion=' + $('#idRequisicion').val();
      form += '&section=' + section;
      form += '&licencia_completa=' + licencia+' '+tipo_licencia;
    }
    if(section == 'cargo'){
      let sueldo_adicional = $('#sueldo_adicional_update').val();
      let monto_adicional = $('#monto_adicional_update').val();
      form = $('#formCargo').serialize();
      form += '&id_requisicion=' + $('#idRequisicion').val();
      form += '&section=' + section;
      form += '&sueldo_adicional_completo=' + sueldo_adicional+' por '+monto_adicional;
    }
    if(section == 'perfil'){
      let competenciasValues = '';
      form = $('#formPerfil').serialize();
      let competenciasChecked = $("input:checkbox").map(function(){
        if($(this).is(":checked") == true)
          return this.id;
      }).get().join('_');
      if(competenciasChecked != ''){
        competenciasValues = competenciasChecked.replaceAll('-', ' ')
        competenciasValues += '_';
      }else{
        competenciasValues = '';
      }
      form += '&id_requisicion=' + $('#idRequisicion').val();
      form += '&section=' + section;
      form += '&competencias=' + competenciasValues;
    }
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/updateOrder'); ?>',
      type: 'post',
      data: form,
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 300);
        var dato = JSON.parse(res);
        if(dato.codigo === 1){
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: dato.msg,
            showConfirmButton: false,
            timer: 3000
          })
        }else{
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
  //* Eliminar usuario de la requisicion
  function openDeleteUserOrder(id, id_requisicion, nombre){
    let url = '<?php echo base_url('Reclutamiento/deleteUserOrder'); ?>';
		$('#titulo_mensaje').text('Confirmar eliminación de usuario en la requisición');
		$('#mensaje').html('¿Desea eliminar al usuario <b>'+nombre+'</b> de la requisición <b>#'+id_requisicion+'</b>?');
		$('#idRequisicion').val(id);
		$('#btnConfirmar').attr("onclick","deleteUserOrder("+id+",\""+url+"\")");
		$('#mensajeModal').modal('show');
	} 
  function openDeleteOrder(id, nombre){
    $('#titulo_mensaje').text('Eliminar requisición');
		$('#mensaje').html('¿Desea eliminar la requisición <b>#'+id+' '+nombre+'</b>?');
		$('#idRequisicion').val(id);
    $('#campos_mensaje').html('<div class="row"><div class="col-12"><label>Motivo de eliminacion *</label><textarea class="form-control" rows="3" id="mensaje_comentario" name="mensaje_comentario"></textarea></div></div>');
		$('#btnConfirmar').attr("onclick","confirmarAccion(2,"+id+")");
		$('#mensajeModal').modal('show');
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
</script>
<!-- Funciones Reclutamiento -->
<script src="<?php echo base_url(); ?>js/reclutamiento/functions.js"></script>