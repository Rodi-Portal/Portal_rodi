<!-- Begin Page Content -->
<div class="container-fluid">

	<section class="content-header">
		<div class="row">
      <div class="col-sm-12 col-md-3 col-lg-3 mb-1">
        <h1 class="titulo_seccion">Bolsa de Trabajo</small></h1>
      </div>
      <div class="col-sm-4 col-md-2 col-lg-2 offset-md-3 offset-lg-3 mb-1">
        <button type="button" id="btnSubirAspirantes" class="btn btn-success btn-icon-split" onclick="openUploadCSV()">
          <span class="icon text-white-50">
            <i class="fas fa-upload"></i>
          </span>
          <span class="text">Subir aspirantes</span>
        </button>
      </div>
      <div class="col-sm-4 col-md-2 col-lg-2 mb-1">
        <button type="button"  id="btnNuevaRequisicion" class="btn btn-primary btn-icon-split" onclick="nuevaRequisicion()">
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
      <div class="col-sm-4 col-md-2 col-lg-2 mb-1" data-toggle="tooltip" <?php echo $textTitle; ?> >
        <button type="button" id="btnAsignarAspirante" class="btn btn-primary btn-icon-split" onclick="openAssignToUser()" <?php echo $disabled; ?> >
					<span class="icon text-white-50">
            <i class="fas fa-user-edit"></i>
					</span>
					<span class="text">Asignar aspirante</span>
        </button>
      </div>
    </div>
	</section>

	<?php echo $modals; ?>
	<div class="loader" style="display: none;"></div>
	<input type="hidden" id="idRegistro">
	<input type="hidden" id="idBolsa">
	<input type="hidden" id="idAspirante">

  <div class="row mt-3 mb-5" id="divFiltros">
    <div class="col-sm-12 col-md-3 col-lg-3 mb-1">
      <label for="ordenar">Ordenar:</label>
      <select name="ordenar" id="ordenar" class="form-control">
        <option value="">Selecciona</option>
        <option value="ascending">De la más antigua a la más actual</option>
        <option value="descending">De la más actual a la más antigua</option>
      </select>
    </div>
    <div class="col-sm-12 col-md-2 col-lg-2 mb-1">
      <label for="filtrar">Filtrar por:</label>
      <select name="filtrar" id="filtrar" class="form-control">
        <option value="">Selecciona</option>
        <option value="En espera">Estatus en espera</option>
        <option value="En proceso">Estatus en proceso de reclutamiento</option>
        <option value="Aceptado">Estatus aceptado para iniciar ESE</option>
        <option value="ESE">Estatus ESE en proceso</option>
        <option value="Bloqueado">Estatus bloqueado</option>
      </select>
    </div>
    <?php $isDisabled = ($this->session->userdata('idrol') == 4)? 'isDisabled' : ''; ?>
    <div class="col-sm-12 col-md-2 col-lg-2 mb-1">
      <label for="asignar">Asignado a:</label>
      <select name="asignar" id="asignar" class="selectpicker form-control <?php echo $isDisabled ?>" data-live-search="true" data-style="btn-custom-selectpicker" title="Selecciona">
        <option value="0">VER TODAS</option>
        <?php
        if ($usuarios_asignacion) {
          foreach ($usuarios_asignacion as $row) { ?>
            <option value="<?php echo $row->id; ?>"><?php echo $row->usuario; ?></option>
        <?php 
          }
        }else{ ?>
          <option value="">Sin usuarios registrados</option>
        <?php } ?>
      </select>
    </div>
    <div class="col-sm-12 col-md-2 col-lg-2 mb-1">
      <label for="area_interes_search">Por área de interés:</label>
      <select name="area_interes_search" id="area_interes_search" class="selectpicker form-control" data-live-search="true" data-style="btn-custom-selectpicker" title="Selecciona">
        <option value="">VER TODAS</option>
        <?php
        if ($areas_interes) {
          foreach ($areas_interes as $row) { ?>
            <option value="<?php echo $row->area_interes; ?>"><?php echo $row->area_interes; ?></option>
        <?php 
          }
        }else{ ?>
          <option value="">Sin áreas de interés registrados</option>
        <?php } ?>
      </select>
    </div>
    <div class="col-sm-12 col-md-3 col-lg-3 mb-1">
      <label for="buscador">Buscar:</label>
      <select name="buscador" id="buscador" class="selectpicker form-control" data-live-search="true" data-style="btn-custom-selectpicker" title="Selecciona">
        <option value="0">VER TODAS</option>
        <?php
        if ($registros_asignacion) {
          foreach ($registros_asignacion as $row) { ?>
            <option value="<?php echo $row->id; ?>"><?php echo '#'.$row->id.' '.$row->nombreCompleto; ?></option>
        <?php 
          }
        }else{ ?>
          <option value="">Sin aspirantes registrados</option>
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

	<div class="">
		<div id="seccionTarjetas">
			<?php 
			if($registros){
				echo '<div class="row mb-3">';
				foreach($registros as $r){
					date_default_timezone_set('America/Mexico_City');
					$hoy = date('Y-m-d H:i:s');
					// $fechaRegistro = new DateTime($r->creacion); 
					// $diaActual = new DateTime($hoy);
					// $dif = $diaActual->diff($fechaRegistro);
					// $transcurrido = ($dif->days <= 0)? 'Hoy':'Hace '.$dif->days.' días';
          $fecha_registro = fechaTexto($r->creacion,'espanol');
					$color_estatus = ''; $disabled_bloqueo = ''; $disabled_comentario = ''; $text_estatus = '';
          if($r->status == 0){
						$botonProceso = '<a href="javascript:void(0)" class="btn btn-success text-lg isDisabled" data-toggle="tooltip" title="Asignarlo a Requisición"><i class="fas fa-play-circle"></i></a>';
						$color_estatus = 'req_negativa'; $text_estatus = 'Estatus: <b>Bloqueado</b>';
            $disabled_bloqueo = 'isDisabled'; $disabled_comentario = 'isDisabled';
					}
					if($r->status == 1){
						$botonProceso = '<a href="javascript:void(0)" class="btn btn-success text-lg" id="btnIniciar'.$r->id.'" data-toggle="tooltip" title="Asignarlo a Requisición" onclick="openAddApplicant('.$r->id.',\''.$r->nombre.'\',\''.$r->paterno.'\',\''.$r->materno.'\',\''.$r->telefono.'\',\''.$r->medio_contacto.'\',\''.$r->area_interes.'\',\''.$r->domicilio.'\')"><i class="fas fa-play-circle"></i></a>';
            $text_estatus = 'Estatus: <b>En espera <a href="javascript:void(0)" class="" onclick="verHistorialBolsaTrabajo('.$r->id.',\''.$r->nombreCompleto.'\')">(ver/registrar comentarios)</a></b>';
            if($r->semaforo == 0){
              $color_estatus = '';
            }
            if($r->semaforo == 1){
              $color_estatus = 'req_positivo';
            }
            if($r->semaforo == 2){
              $color_estatus = 'req_negativa';
            }
            if($r->semaforo == 3){
              $color_estatus = 'req_preventiva';
            }
					}
          if($r->status == 2){
						$botonProceso = '<a href="javascript:void(0)" class="btn btn-success text-lg isDisabled" data-toggle="tooltip" title="Asignarlo a Requisición"><i class="fas fa-play-circle"></i></a>';
						$color_estatus = 'req_activa'; $text_estatus = 'Estatus: <b>En proceso de reclutamiento</b>';
            $disabled_comentario = 'isDisabled';
					}
          if($r->status == 3 && $r->semaforo == 1){
						$botonProceso = '<a href="javascript:void(0)" class="btn btn-success text-lg isDisabled" data-toggle="tooltip" title="Asignarlo a Requisición"><i class="fas fa-play-circle"></i></a>';
						$color_estatus = 'req_positivo'; $text_estatus = 'Estatus: <b>Aceptado para iniciar ESE</b>';
            $disabled_comentario = 'isDisabled';
					}
          if($r->status == 4){
						$botonProceso = '<a href="javascript:void(0)" class="btn btn-success text-lg isDisabled" data-toggle="tooltip" title="Asignarlo a Requisición"><i class="fas fa-play-circle"></i></a>';
						$color_estatus = 'req_activa'; $text_estatus = 'Estatus: <b>ESE en proceso</b>';
            $disabled_comentario = 'isDisabled';
					}
          $usuario = (empty($r->usuario))? 'Sin asignar' : $r->usuario;
          $area_interes = ($r->area_interes === '' || $r->area_interes === null)? 'No registrado' : $r->area_interes;
          $domicilio = ($r->domicilio === '' || $r->domicilio === null)? 'No registrado' : $r->domicilio;
          $totalApplicants = count($registros);
          $moveApplicant = ($totalApplicants > 1)? '' : 'offset-4';
					?>
					<div class="col-sm-12 col-md-6 col-lg-4 mb-5 <?php echo $moveApplicant ?>">
						<div class="card text-center">
							<div class="card-header <?php echo $color_estatus; ?>" id="req_header<?php echo $r->id;?>">
								<b><?php echo '#'.$r->id.' '.$r->nombreCompleto; ?></b>
							</div>
							<div class="card-body">
								<h5 class="card-title">Área de interés: <br><b><?php echo $area_interes; ?></b></h5>
								<h5 class="card-text">Localización: <br><b><?php echo $domicilio; ?></b></h5>
								<h5 class="card-text">Teléfono: <b><?php echo $r->telefono; ?></b></h5>
                <div class="alert alert-secondary text-center mt-3"><?php echo $text_estatus ?></div>
								<div class="row">
									<div class="col-sm-4 col-md-2 col-lg-2 mb-1">
										<a href="javascript:void(0)" class="btn btn-primary text-lg" data-toggle="tooltip" title="Ver detalles" onclick="verDetalles(<?php echo $r->id;?>)"><i class="fas fa-info-circle"></i></a>
									</div>
                  <div class="col-sm-4 col-md-2 col-lg-2 mb-1">
										<a href="javascript:void(0)" class="btn btn-info text-lg" data-toggle="tooltip" title="Ver empleos" onclick="verEmpleos(<?php echo $r->id;?>,'<?php echo $r->nombreCompleto ?>')"><i class="fas fa-user-tie"></i></a>
									</div>
                  <div class="col-sm-4 col-md-2 col-lg-2 mb-1">
                    <a href="javascript:void(0)" class="btn btn-info text-lg" data-toggle="tooltip" title="Historial de movimientos" onclick="verHistorialMovimientos(<?php echo $r->id;?>,'<?php echo $r->nombreCompleto ?>')"><i class="fas fa-history"></i></a>
                  </div>
                  <div class="col-sm-4 col-md-2 col-lg-2 mb-1" id="divIniciar<?php echo $r->id?>">
										<?php echo $botonProceso; ?>
									</div>
                  <div class="col-sm-4 col-md-2 col-lg-2 mb-1">
                    <a href="javascript:void(0)" class="btn btn-danger text-lg <?php echo $disabled_bloqueo ?>" data-toggle="tooltip" title="Bloquear persona" onclick="mostrarMensajeConfirmacion('bloquear proceso bolsa trabajo','<?php echo $r->nombreCompleto ?>',<?php echo $r->id;?>)"><i class="fas fa-ban"></i></a>
                  </div>
                  <div class="col-sm-4 col-md-2 col-lg-2 mb-1">
                    <a href="javascript:void(0)" class="btn btn-primary text-lg" data-toggle="tooltip" title="Editar aspirante" onclick="openUpdateApplicant(<?php echo $r->id;?>,'<?php echo $r->nombreCompleto ?>')"><i class="fas fa-edit"></i></a>
                  </div>
                  <!-- <div class="col-2">
                    <a href="javascript:void(0)" class="btn btn-warning text-lg <?php //echo $disabled_comentario ?>" data-toggle="tooltip" title="Registrar comentario previo a reclutar" onclick="verHistorialBolsaTrabajo(<?php //echo $r->id;?>,'<?php //echo $r->nombreCompleto ?>')"><i class="fas fa-exclamation-circle"></i></a>
                  </div> -->
								</div>
                <div class="alert alert-secondary text-center mt-3" id="divUsuario<?php echo $r->id; ?>"><b><?php echo $usuario; ?></b></div>
							</div>
							<div class="card-footer text-muted">
								<?php echo $fecha_registro; ?>
							</div>
						</div>
					</div>
			<?php 
				}
				echo '</div>';
			}else{  ?>
        <h3 class="text-center">No se encontraron registros de acuerdo a los filtros buscados</h3>
      <?php 
      } ?>
		</div>
		<div id="tarjeta_detalle" class="hidden mb-5">
      <div class="alert alert-info text-center" id="nombre_completo"></div>
			<div class="card">
				<div class="card-header">
					<ul class="nav nav-tabs card-header-tabs">
						<li class="nav-item">
							<a class="nav-link active" id="link_personales" href="javascript:void(0)">Detalles</a>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<div id="div_registro" class="div_info">
						<h3 id="detalle_area_interes" class="text-center"></h3><br>
						<div class="row">
							<div class="col-4">
								<h5 id="detalle_f_nacimiento"></h5>
								<h5 id="detalle_edad"></h5>
								<h5 id="detalle_nacionalidad"></h5>
                <h5 id="detalle_civil"></h5>
								<h5 id="detalle_dependientes"></h5>
								<h5 id="detalle_grado_estudios"></h5>
							</div>
              <div class="col-4">
                <h5 id="detalle_salud"></h5>
								<h5 id="detalle_enfermedad"></h5>
								<h5 id="detalle_deporte"></h5>
								<h5 id="detalle_metas"></h5>
							</div>
              <div class="col-4">
								<h5 id="detalle_sueldo_deseado"></h5>
								<h5 id="detalle_otros_ingresos"></h5>
								<h5 id="detalle_viajar"></h5>
                <h5 id="detalle_trabajar"></h5>
							</div>
						</div>
						<h5 id="detalle_domicilio" class="text-center"></h5><br>
						<h5 id="detalle_medio_contacto" class="text-center"></h5><br>
						<h5 id="detalle_idiomas" class="text-center"></h5><br>
						<h5 id="detalle_maquinas" class="text-center"></h5><br>
						<h5 id="detalle_software" class="text-center"></h5><br>
					</div>
				</div>
			</div>
		</div>
    <div id="seccionEditarBolsa" class="hidden">
      <div class="alert alert-info text-center" id="nombreBolsa"></div>
      <div class="card mb-5">
        <h5 class="card-header text-center seccion">Datos Personales</h5>
        <div class="card-body">
          <form id="formDatosPersonales">
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>Nombre(s) *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" id="nombre_update" name="nombre_update" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>Primer apellido *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" id="paterno_update" name="paterno_update" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>Segundo apellido</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" id="materno_update" name="materno_update" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-8 col-lg-8 mb-1">
                <label>Domicilio *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                  </div>
                  <input type="text" class="form-control" id="domicilio_update" name="domicilio_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>Fecha de nacimiento *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                  </div>
                  <input type="date" class="form-control" id="fecha_nacimiento_update" name="fecha_nacimiento_update">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-2 col-lg-2 mb-1">
                <label>Teléfono *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                  </div>
                  <input type="text" class="form-control" id="telefono_update" name="telefono_update" maxlength="16">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>Nacionalidad *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                  </div>
                  <input type="text" class="form-control" id="nacionalidad_update" name="nacionalidad_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>Estado civil *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <select class="custom-select" id="civil_update" name="civil_update">
                    <option value="">Selecciona</option>
                  <?php 
                  if($civiles){
                    foreach($civiles as $row){ ?>
                      <option value="<?php echo $row->id ?>"><?php echo $row->nombre ?></option>
                      <?php 
                    }
                  }else{ ?>
                    <option value="">Sin registro de estados civiles</option>
                    <?php 
                  } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-8 col-lg-8 mb-1">
                <label>Personas que dependan del aspirante *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                  </div>
                  <input type="text" class="form-control" id="dependientes_update" name="dependientes_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>Grado máximo de estudios *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <select class="custom-select" id="escolaridad_update" name="escolaridad_update">
                    <option value="">Selecciona</option>
                  <?php 
                  if($grados){
                    foreach($grados as $row){ ?>
                      <option value="<?php echo $row->id ?>"><?php echo $row->nombre ?></option>
                      <?php 
                    }
                  }else{ ?>
                    <option value="">Sin registro de escolaridades</option>
                    <?php 
                  } ?>
                  </select>
                </div>
              </div>
            </div>
          </form>
          <button type="button" class="btn btn-success btn-block text-lg" onclick="updateApplicant('personal')">Guardar Datos Personales</button>
        </div>
      </div>
      <div class="card mb-5">
        <h5 class="card-header text-center seccion">Salud y vida social</h5>
        <div class="card-body">
          <form id="formSalud">
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6 mb-1">
                <label>¿Cómo es su estado de salud actual? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                  </div>
                  <input type="text" class="form-control" id="salud_update" name="salud_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6 mb-1">
                <label>¿Padece de alguna enfermedad crónica? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  </div>
                  <input type="text" class="form-control" id="enfermedad_update" name="enfermedad_update">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6 mb-1">
                <label>¿Practica algún deporte? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                  </div>
                  <input type="text" class="form-control" id="deporte_update" name="deporte_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6 mb-1">
                <label>¿Cuáles son sus metas en la vida? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                  </div>
                  <input type="text" class="form-control" id="metas_update" name="metas_update">
                </div>
              </div>
            </div>
          </form>
          <button type="button" class="btn btn-success btn-block text-lg" onclick="updateApplicant('salud')">Guardar Información de Salud y Vida Social</button>
        </div>
      </div>
      <div class="card mb-5">
        <h5 class="card-header text-center seccion">Conocimientos y Habilidades</h5>
        <div class="card-body">
          <form id="formConocimientos">
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>Idiomas que domina *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control" id="idiomas_update" name="idiomas_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>Máquinas de oficina o taller que maneje *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control" id="maquinas_update" name="maquinas_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>Software que conoce *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control" id="software_update" name="software_update">
                </div>
              </div>
            </div>
          </form>
          <button type="button" class="btn btn-success btn-block text-lg" onclick="updateApplicant('conocimiento')">Guardar Información de Conocimientos y Habilidades</button>
        </div>
      </div>
      <div class="card mb-5">
        <h5 class="card-header text-center seccion">Intereses</h5>
        <div class="card-body">
          <form id="formIntereses">
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>¿Cómo se enteró de RODI? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                  </div>
                  <select class="custom-select" id="medio_contacto_update" name="medio_contacto_update">
                    <option value="">Selecciona</option>
                  <?php 
                  if($medios){
                    foreach($medios as $row){ ?>
                      <option value="<?php echo $row->nombre ?>"><?php echo $row->nombre ?></option>
                      <?php 
                    }
                  }else{ ?>
                    <option value="">Sin registro de medios de contacto</option>
                    <?php 
                  } ?>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>¿Qué área es de su interés? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  </div>
                  <input type="text" class="form-control" id="area_interes_update" name="area_interes_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>¿Qué sueldo desea percibir? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                  </div>
                  <input type="text" class="form-control" id="sueldo_update" name="sueldo_update">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>¿Tiene otros ingresos? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  </div>
                  <input type="text" class="form-control" id="otros_ingresos_update" name="otros_ingresos_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>¿Tiene disponibilidad para viajar? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                  </div>
                  <input type="text" class="form-control" id="viajar_update" name="viajar_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>¿Qué fecha o en qué momento podría presentarse a trabajar?  *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                  </div>
                  <input type="text" class="form-control" id="trabajar_update" name="trabajar_update">
                </div>
              </div>
            </div>
          </form>
          <button type="button" class="btn btn-success btn-block text-lg" onclick="updateApplicant('intereses')">Guardar Intereses</button>
        </div>
      </div>
    </div>
  </div>
<!-- Sweetalert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
<script>
	$(document).ready(function() {
    let url_applicants = '<?php echo base_url('Reclutamiento/bolsa'); ?>';
    let oldURL = url_applicants;

    let sortOption = '<?php echo $sortApplicant ?>';
    let filterOption = '<?php echo $filter ?>';
    let assignOption = '<?php echo $assign ?>';
    let areaOption = '<?php echo $area ?>';
    $('#ordenar').val(sortOption).trigger('change');
    $('#filtrar').val(filterOption).trigger('change');
    $('#asignar').val(assignOption).trigger('change');
    $('#area_interes_search').val(areaOption).trigger('change');

    $('#ordenar, #filtrar, #asignar, #area_interes_search').change(function(){
      let ordenar = $('#ordenar').val() != '' ? $('#ordenar').val() : 'none';
      let filtrar = $('#filtrar').val() != '' ? $('#filtrar').val() : 'none';
      let asignar = $('#asignar').val() != 0 ? $('#asignar').val() : 0;
      let area = $('#area_interes_search').val() != 0 ? $('#area_interes_search').val() : 'none';

      var newUrl = oldURL + '?' + 'sort=' + ordenar + '&filter=' + filtrar + '&user=' + asignar + '&area=' + area
      $(location).attr('href',newUrl);
      return false;

    })
    $('#buscador').change(function(){
      var opcion = $(this).val();
      var oldURL = url_applicants;
      if (history.pushState) {
        var newUrl = oldURL + "?applicant=" + opcion;
        $(location).attr('href',newUrl);
      }
      return false;
    })
    
		$('.nav-link').click(function(){
			$('.nav-link').removeClass('active');
			$(this).addClass('active');
		})
		$('#link_personales').click(function(){
			$('.div_info').css('display','none');
			$('#div_registro').css('display','block');
		})
	});
	function regresarListado(){
		location.reload();
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
			url: '<?php echo base_url('Reclutamiento/getBolsaTrabajoById'); ?>',
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
        let f_nacimiento = ''; let edad = '';
        if(dato['fecha_nacimiento'] === '' || dato['fecha_nacimiento'] === null){
          f_nacimiento = 'No registrado';
          edad = 'No registrado';
        }else{
          f_nacimiento = fechaSimpleAFront(dato['fecha_nacimiento']);
          edad = dato['edad']+' años';
        }
				$('#btnBack').css('display','block');
        $('#divFiltros').css('display','none')
				$('#seccionTarjetas').css('display','none');
				$('#nombre_completo').html('<b>Detalles del aspirante <h3>#'+dato['id']+' '+dato['nombreCompleto']+'</h3></b>')
				//Personales
        let area_interes = (dato['area_interes'] === '' || dato['area_interes'] === null)? 'No registrado' : dato['area_interes'];
				$('#detalle_area_interes').html('Área de interés:<br><b>'+area_interes+'</b>')
				$('#detalle_f_nacimiento').html('<b>Fecha de nacimiento: </b> '+f_nacimiento)
				$('#detalle_edad').html('<b>Edad: </b>'+edad)
        let nacionalidad = (dato['nacionalidad'] === '' || dato['nacionalidad'] === null)? 'No registrado' : dato['nacionalidad'];
				$('#detalle_nacionalidad').html('<b>Nacionalidad:</b> '+nacionalidad)
        let civil = (dato['civil'] === '' || dato['civil'] === null)? 'No registrado' : dato['civil'];
				$('#detalle_civil').html('<b>Estado civil:</b> '+civil)
        let dependientes = (dato['dependientes'] === '' || dato['dependientes'] === null)? 'No registrado' : dato['dependientes'];
				$('#detalle_dependientes').html('<b>Dependientes:</b> '+dependientes)
        let grado_estudios = (dato['grado_estudios'] === '' || dato['grado_estudios'] === null)? 'No registrado' : dato['grado_estudios'];
				$('#detalle_grado_estudios').html('<b>Grado máximo de estudios:</b> '+grado_estudios)
        let sueldo_deseado = (dato['sueldo_deseado'] === '' || dato['sueldo_deseado'] === null)? 'No registrado' : dato['sueldo_deseado'];
				$('#detalle_sueldo_deseado').html('<b>Sueldo deseado:</b> '+sueldo_deseado)
        let otros_ingresos = (dato['otros_ingresos'] === '' || dato['otros_ingresos'] === null)? 'No registrado' : dato['otros_ingresos'];
				$('#detalle_otros_ingresos').html('<b>Otros ingresos:</b> '+otros_ingresos)
        let viajar = (dato['viajar'] === '' || dato['viajar'] === null)? 'No registrado' : dato['viajar'];
				$('#detalle_viajar').html('<b>¿Disponibilidad para viajar?:</b> '+viajar)
        let trabajar = (dato['trabajar'] === '' || dato['trabajar'] === null)? 'No registrado' : dato['trabajar'];
				$('#detalle_trabajar').html('<b>¿Cuándo podría presentarse a trabajar?:</b> '+trabajar)
        let domicilio = (dato['domicilio'] === '' || dato['domicilio'] === null)? 'No registrado' : dato['domicilio'];
				$('#detalle_domicilio').html('<b>Domicilio:</b><br> '+domicilio)
        let salud = (dato['salud'] === '' || dato['salud'] === null)? 'No registrado' : dato['salud'];
				$('#detalle_salud').html('<b>Estado de salud:</b> '+salud)
        let enfermedad = (dato['enfermedad'] === '' || dato['enfermedad'] === null)? 'No registrado' : dato['enfermedad'];
				$('#detalle_enfermedad').html('<b>Enfermedad crónica:</b> '+enfermedad)
        let deporte = (dato['deporte'] === '' || dato['deporte'] === null)? 'No registrado' : dato['deporte'];
				$('#detalle_deporte').html('<b>Deporte:</b> '+deporte)
        let metas = (dato['metas'] === '' || dato['metas'] === null)? 'No registrado' : dato['metas'];
				$('#detalle_metas').html('<b>Metas en la vida:</b> '+metas)
				$('#detalle_medio_contacto').html('<b>¿Cómo se enteró de RODI?:</b><br> '+dato['medio_contacto'])
        let idiomas = (dato['idiomas'] === '' || dato['idiomas'] === null)? 'No registrado' : dato['idiomas'];
				$('#detalle_idiomas').html('<b>Idiomas que domina:</b><br> '+idiomas)
        let maquinas = (dato['maquinas'] === '' || dato['maquinas'] === null)? 'No registrado' : dato['maquinas'];
				$('#detalle_maquinas').html('<b>Máquinas de oficina o taller que maneja:</b><br> '+maquinas)
        let software = (dato['software'] === '' || dato['software'] === null)? 'No registrado' : dato['software'];
				$('#detalle_software').html('<b>Software que conoce:</b><br> '+software)		
				$('#tarjeta_detalle').css('display','block');
			}
		});
	}
  function verEmpleos(id, nombreCompleto) {
    $(".nombreRegistro").text(nombreCompleto);
    $('#div_historial_empleos').empty();
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/getEmpleosByIdBolsaTrabajo'); ?>',
      type: 'post',
      data: {
        'id': id
      },
      success: function(res) {
        var salida = '<table class="table table-striped" style="font-size: 14px">';
        salida += '<tr style="background: gray;color:white;">';
        salida += '<th>Empresa</th>';
        salida += '<th>Periodo</th>';
        salida += '<th>Sueldo</th>';
        salida += '<th>Puesto</th>';
        salida += '<th>Causa separación</th>';
        salida += '<th>Teléfono</th>';
        salida += '</tr>';
        if(res != 0){
          var dato = JSON.parse(res);
          for(var i = 0; i < dato.length; i++){
            salida += "<tr>";
            salida += '<td>'+dato[i]['empresa']+'</td>';
            salida += '<td>'+dato[i]['periodo']+'</td>';
            salida += '<td>'+dato[i]['sueldo']+'</td>';
            salida += '<td>'+dato[i]['puesto']+'</td>';
            salida += '<td>'+dato[i]['causa_separacion']+'</td>';
            salida += '<td>'+dato[i]['telefono']+'</td>';
            salida += "</tr>";
          }
        }
        else{
          salida += "<tr>";
          salida += '<td colspan="6" class="text-center"><h5>Sin empleos registrados</h5></td>';
          salida += "</tr>";
        }
        salida += "</table>";
        $('#div_historial_empleos').html(salida);
        $("#empleosModal").modal('show');
      }
    });
	}
  function openAddApplicant(id,nombre,paterno,materno,telefono,medio,area_interes,domicilio) {
    $('#idBolsa').val(id);
    $('#nombre').val(nombre);
    $('#paterno').val(paterno);
    $('#materno').val(materno);
    $('#telefono').val(telefono);
    $('#medio').val(medio);
    $('#area_interes').val(area_interes);
    $('#domicilio').val(domicilio);
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/getOrdersInProcess'); ?>',
      type: 'get',
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        if (res != 0) {
          let data = JSON.parse(res);
          for(let i = 0; i < data.length; i++){
            $('#req_asignada').append('<option value="'+data[i]['id']+'">#'+data[i]['id']+' '+data[i]['nombre']+' - '+data[i]['puesto']+' - Vacantes: '+data[i]['numero_vacantes']+'</option>');
          }
          $('#req_asignada').selectpicker()
        }
        else{
          Swal.fire({
            icon: 'error',
            title: 'Hubo un problema',
            html: 'No hay requisiciones a consultar',
            width: '50em',
            confirmButtonText: 'Cerrar'
          })
        }
      }
    });
    $("#nuevoAspiranteModal").modal('show');
	}
  function addApplicant() {
    let id_bolsa = $('#idBolsa').val();
    // var cv = $("#cv")[0].files[0];
		var datos = new FormData();
		datos.append('requisicion', $("#req_asignada").val());
		datos.append('nombre', $("#nombre").val());
		datos.append('paterno', $("#paterno").val());
		datos.append('materno', $("#materno").val());
		datos.append('correo', $("#correo").val());
		datos.append('telefono', $("#telefono").val());
		datos.append('medio', $("#medio").val());
		datos.append('area_interes', $("#area_interes").val());
		datos.append('domicilio', $("#domicilio").val());
    // datos.append("cv", cv);
    datos.append("id_aspirante",0);
    datos.append("id_bolsa_trabajo", id_bolsa);

		$.ajax({
			url: '<?php echo base_url('Reclutamiento/addApplicant'); ?>',
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
          $("#nuevoAspiranteModal").modal('hide')
          // $('#req_header'+id_bolsa).addClass('req_activa')
          // $('#divIniciar'+id_bolsa).html('<h5 class="text-info"><b>En proceso</b></h5>');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: data.msg,
            showConfirmButton: false,
            timer: 2500
          })
          setTimeout(function(){
            location.reload();
          },2500)
				} else {
					Swal.fire({
            icon: 'error',
            title: 'Campos obligatorios vacíos',
            html: data.msg,
            width: '50em',
            confirmButtonText: 'Cerrar'
          })
				}
			}
		});
	}
  function verHistorialMovimientos(id, nombreCompleto){
    $(".nombreRegistro").text(nombreCompleto);
    $('#div_historial_aspirante').empty();
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/getHistorialAspirante'); ?>',
      type: 'post',
      data: {
        'id': id,
        'tipo_id': 'bolsa'
      },
      success: function(res) {
        var salida = '<table class="table table-striped" style="font-size: 14px">';
        salida += '<tr style="background: gray;color:white;">';
        salida += '<th>Requisicion</th>';
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
            salida += '<td>#'+dato[i]['id_requisicion']+' '+dato[i]['nombre']+'</td>';
            salida += '<td>'+fecha+'</td>';
            salida += '<td>'+dato[i]['accion']+'</td>';
            salida += '<td>'+dato[i]['descripcion']+'</td>';
            salida += "</tr>";
          }
        }
        else{
          salida += "<tr>";
          salida += '<td colspan="4" class="text-center"><h5>Sin movimientos</h5></td>';
          salida += "</tr>";
        }
        salida += "</table>";
        $('#div_historial_aspirante').html(salida);
        $("#historialModal").modal('show');
      }
    });
  }
  function mostrarMensajeConfirmacion(accion,valor1,valor2){
		if(accion == "bloquear proceso bolsa trabajo"){
			$('#idBolsa').val(valor2);//id
			$('#titulo_mensaje').text('Bloquear proceso');
			$('#mensaje').html('¿Desea bloquear a <b>'+valor1+'</b> de todo proceso de reclutamiento?');
			$('#campos_mensaje').html('<div class="row"><div class="col-12"><label>Motivo de bloqueo *</label><textarea class="form-control" rows="3" id="mensaje_comentario" name="mensaje_comentario"></textarea></div></div>');
			$('#btnConfirmar').attr("onclick","cancelarBolsaTrabajo("+valor2+")");
			$('#mensajeModal').modal('show');
		}
  }
  function cancelarBolsaTrabajo(id_bolsa){
    let comentario = $('#mensaje_comentario').val();
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/cancelarBolsaTrabajo'); ?>',
      type: 'post',
      data: {
        'id_bolsa': id_bolsa,
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
          $("#mensajeModal").modal('hide');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: data.msg,
            showConfirmButton: false,
            timer: 3000
          })
          setTimeout(function(){
            location.reload();
          },3000)
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
  function verHistorialBolsaTrabajo(id, nombreCompleto){
    $(".nombreRegistro").text(nombreCompleto);
    $('#div_historial_comentario').empty();
    $('#btnComentario').attr('onclick','guardarComentario('+id+')');
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/getHistorialBolsaTrabajo'); ?>',
      type: 'post',
      data: {
        'id': id,
        'tipo_id': 'bolsa'
      },
      success: function(res) {
        var salida = '<table class="table table-striped" style="font-size: 14px">';
        salida += '<tr style="background: gray;color:white;">';
        salida += '<th>Fecha</th>';
        salida += '<th>Usuario</th>';
        salida += '<th>Comentario / Estatus</th>';
        salida += '</tr>';
        if(res != 0){
          var dato = JSON.parse(res);
          for(var i = 0; i < dato.length; i++){
            var aux = dato[i]['creacion'].split(' ');
            var f = aux[0].split('-');
            var fecha = f[2]+'/'+f[1]+'/'+f[0];
            salida += "<tr>";
            salida += '<td>'+fecha+'</td>';
            salida += '<td>'+dato[i]['usuario']+'</td>';
            salida += '<td>'+dato[i]['comentario']+'</td>';
            salida += "</tr>";
          }
        }
        else{
          salida += "<tr>";
          salida += '<td colspan="4" class="text-center"><h5>Sin comentarios</h5></td>';
          salida += "</tr>";
        }
        salida += "</table>";
        $('#div_historial_comentario').html(salida);
        $("#historialComentariosModal").modal('show');
      }
    });
  }
  function guardarComentario(id_bolsa){
    let comentario = $('#comentario_bolsa').val();
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/guardarHistorialBolsaTrabajo'); ?>',
      type: 'post',
      data: {
        'id_bolsa': id_bolsa,
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
          $("#historialComentariosModal").modal('hide');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: data.msg,
            showConfirmButton: false,
            timer: 3000
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
  function nuevaRequisicion(){
    $('#nuevaRequisicionModal').modal('show')
  }
  //* Asignacion de Usuario a registro de Bolsa de Trabajo
  function openAssignToUser(){
    let url = '<?php echo base_url('Reclutamiento/assignToUser'); ?>';
		$('#titulo_asignarUsuarioModal').text('Asignar registro de bolsa de trabajo a un reclutador');
		$('label[for="asignar_usuario"]').text('Reclutador *');
		$('label[for="asignar_registro"]').text('Persona en bolsa de Trabajo *');
    $('#asignar_usuario').removeAttr("multiple");
    $('#asignar_usuario').selectpicker('destroy');
    $('#asignar_usuario').selectpicker();
    $('#asignar_usuario').attr("name","asignar_usuario");
		$('#btnAsignar').attr("onclick","assignToUser(\""+url+"\",'bolsa_trabajo')");
		$('#asignarUsuarioModal').modal('show');
	}
   //* Carga de aspirantes masivos de acuerdo a CSV
  function openUploadCSV(){
    let url = '<?php echo base_url('Reclutamiento/uploadCSV'); ?>';
		$('#subirCSVModal .modal-title').text('Subir aspirantes masivos por csv');
		$('#subirCSVModal #label').html('Selecciona el archivo <code>.csv</code>');
		$('#btnSubir').attr("onclick","uploadCSV(\""+url+"\")");
		$('#subirCSVModal').modal('show');
	}
  function openUpdateApplicant(id, nombre){
    $('#idBolsa').val(id)
    $('#nombreBolsa').html('<b>Edición del aspirante <h3>#'+id+' '+nombre+'</h3></b>')
    $.ajax({
			url: '<?php echo base_url('Reclutamiento/getDetailsApplicantById'); ?>',
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
        //Personales
				$('#nombre_update').val(dato['nombre'])
				$('#paterno_update').val(dato['paterno'])
				$('#materno_update').val(dato['materno'])
				$('#domicilio_update').val(dato['domicilio'])
        let fecha = (dato['fecha_nacimiento'] !== null && dato['fecha_nacimiento'] !== '')? dato['fecha_nacimiento'] : ''
				$('#fecha_nacimiento_update').val(fecha)
				$('#telefono_update').val(dato['telefono'])
				$('#nacionalidad_update').val(dato['nacionalidad'])
				$('#civil_update').val(dato['civil'])
				$('#dependientes_update').val(dato['dependientes'])
				$('#escolaridad_update').val(dato['grado_estudios'])
				//Salud y Vida Social
				$('#salud_update').val(dato['salud'])
				$('#enfermedad_update').val(dato['enfermedad'])
				$('#deporte_update').val(dato['deporte'])
				$('#metas_update').val(dato['metas'])
				//Conocimientos
				$('#idiomas_update').val(dato['idiomas'])
				$('#maquinas_update').val(dato['maquinas'])
				$('#software_update').val(dato['software'])
				//Intereses
        $('#medio_contacto_update').val(dato['medio_contacto'])
				$('#area_interes_update').val(dato['area_interes'])
				$('#sueldo_update').val(dato['sueldo_deseado'])
				$('#otros_ingresos_update').val(dato['otros_ingresos'])
				$('#viajar_update').val(dato['viajar'])
				$('#trabajar_update').val(dato['trabajar'])

				$('#observaciones_update').val(dato['observaciones'])
			}
		});
    $('#btnBack').css('display','block');
    $('#seccionTarjetas').addClass('hidden')
    $('#seccionEditarBolsa').css('display','block')
    $('#divFiltros').css('display','none')
    $('#btnSubirAspirantes').addClass('isDisabled')
    $('#btnNuevaRequisicion').addClass('isDisabled')
    $('#btnAsignarAspirante').addClass('isDisabled')
  }
  function updateApplicant(section){
    let form = ''; 
    if(section == 'personal'){
      form = $('#formDatosPersonales').serialize();
      form += '&id_bolsa=' + $('#idBolsa').val();
      form += '&section=' + section;
    }
    if(section == 'salud'){
      form = $('#formSalud').serialize();
      form += '&id_bolsa=' + $('#idBolsa').val();
      form += '&section=' + section;
    }
    if(section == 'conocimiento'){
      form = $('#formConocimientos').serialize();
      form += '&id_bolsa=' + $('#idBolsa').val();
      form += '&section=' + section;
    }
    if(section == 'intereses'){
      let competenciasValues = '';
      form = $('#formIntereses').serialize();
      form += '&id_bolsa=' + $('#idBolsa').val();
      form += '&section=' + section;
    }
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/updateApplicant'); ?>',
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
</script>
<!-- Funciones Reclutamiento -->
<script src="<?php echo base_url(); ?>js/reclutamiento/functions.js"></script>