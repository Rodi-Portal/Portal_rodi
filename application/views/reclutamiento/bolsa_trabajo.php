<style>
.btn-cuadro {
  width: 38px;
  /* ancho fijo */
  height: 38px;
  /* alto fijo */
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 !important;
  /* quita el padding que mete Bootstrap */
  font-size: 16px;
  /* controla el tamaño del ícono */
  line-height: 1;
  /* evita que crezca verticalmente */
}

.btn-cuadro i.fa-info-circle {
  padding: 10px;
  /* súbelo hasta que se vea igual que los demás */
}
</style>
<!-- Begin Page Content -->
<div class="container-fluid">
  <section class="content-header">
    <div class="row align-items-center">
      <div class="col-sm-12 col-md-3 col-lg-3 mb-1 d-flex align-items-center">
        <h2 class="titulo_seccion">Bolsa de Trabajo </h2>
      </div>

      <div class="col-sm-12 col-md-9 col-lg-9 mb-1 d-flex justify-content-end">
        <div class="btn-group d-none d-md-flex" role="group" aria-label="Buttons for large screens">
          <button type="button" id="btnDownloadTemplate" class="btn btn-info btn-icon-split"
            onclick="descargarFormato()">
            <span class="icon text-white-50">
              <i class="fas fa-download"></i>
            </span>
            <span class="text">Descargar Plantilla</span>
          </button>
          <button type="button" id="btnUploadCandidates" class="btn btn-success btn-icon-split"
            onclick="openUploadCSV()">
            <span class="icon text-white-50">
              <i class="fas fa-upload"></i>
            </span>
            <span class="text">Subir Aspirantes</span>
          </button>
          <button type="button" id="btnNewRequisition" class="btn btn-navy btn-icon-split" onclick="nuevaRequisicion()">
            <span class="icon text-white-50">
              <i class="far fa-file-alt"></i>
            </span>
            <span class="text">Nueva Requisicion</span>
          </button>
          <?php
              if ($this->session->userdata('idrol') == 4) {
                  $disabled  = 'disabled';
                  $textTitle = 'title="You do not have permission for this action"';
              } else {
                  $disabled  = '';
                  $textTitle = '';
          }?>
          <button type="button" id="btnAssignCandidate" class="btn btn-navy btn-icon-split" onclick="openAssignToUser()"
            <?php echo $disabled; ?>>
            <span class="icon text-white-50">
              <i class="fas fa-user-edit"></i>
            </span>
            <span class="text">Asignar Aspirante</span>
          </button>
        </div>
      </div>

    </div>
    <?php if ($this->session->userdata('idrol') == 1 || $this->session->userdata('idrol') == 6) {?>
    <div class="mb-3 text-right" data-toggle="tooltip" <?php echo $textTitle; ?>>
      <button type="button" id="generarLink" class="btn"
        style="background-color: #FFD700; color: #000; border: none; font-weight: bold; border-radius: 8px; box-shadow: 0px 2px 6px rgba(0,0,0,0.2);"
        data-toggle="modal" data-target="#modalGenerarLink" <?php echo $disabled; ?>>

        <span class="icon text-white-50">
          <i class="fas fa-user-edit" style="color: #000;"></i>
        </span>
        <span class="text">Generar Link</span>
      </button>
    </div>
    <?php }?>

  </section>
  <br>
  <div>
    <p>En este módulo, puedes gestionar la bolsa de trabajo de manera completa. Se permite cargar aspirantes, asignarlos
      a requisiciones de empleo, y crear nuevas requisiciones. Además, puedes realizar acciones sobre los aspirantes
      como bloquear, editar o asignarles nuevas requisiciones, todo de manera ágil y organizada para facilitar el
      proceso de selección.</p>
  </div>



  <?php echo $modals; ?>
  <div class="loader" style="display: none;"></div>
  <input type="hidden" id="idRegistro">
  <input type="hidden" id="idBolsa">
  <input type="hidden" id="idAspirante">

  <div class="row mt-3 mb-5" id="divFiltros">
    <div class="col-sm-12 col-md-3 col-lg-3 mb-1">
      <label for="ordenar">Ordenar por:</label>
      <select name="ordenar" id="ordenar" class="form-control">
        <option value="">Seleccionar</option>
        <option value="ascending">De más antiguo a más reciente</option>
        <option value="descending">De más reciente a más antiguo</option>
      </select>
    </div>
    <div class="col-sm-12 col-md-2 col-lg-2 mb-1">
      <label for="filtrar">Filtrar por:</label>
      <select name="filtrar" id="filtrar" class="form-control">
        <option value="">Seleccionar</option>
        <option value="En espera">Estatus Pendiente</option>
        <option value="En proceso">Estatus En Proceso de Reclutamiento</option>
        <option value="Aceptado">Estatus Aceptado para Iniciar ESE</option>
        <option value="ESE">Estatus ESE en Progreso</option>
        <option value="Bloqueado">Estatus Bloqueado</option>
      </select>
    </div>
    <?php $isDisabled = ($this->session->userdata('idrol') == 4) ? 'isDisabled' : ''; ?>
    <div class="col-sm-12 col-md-2 col-lg-2 mb-1">
      <label for="asignar">Asignado a:</label>
      <select name="asignar" id="asignar"
        class="form-control                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php echo $isDisabled ?>"
        title="Select">
        <option value="0">ATodosll</option>
        <?php
            if ($usuarios_asignacion) {
            foreach ($usuarios_asignacion as $row) {?>
        <option value="<?php echo $row->id; ?>"><?php echo $row->usuario; ?></option>
        <?php }
        } else {?>
        <option value="">Sin Usuario Asignado</option>
        <?php }?>
      </select>
    </div>
    <div class="col-sm-12 col-md-2 col-lg-2 mb-1">
      <label for="area_interes_search">Por área de interés:</label>
      <select name="area_interes_search" id="area_interes_search" class="form-control">
        <option value="">Todas</option>
        <?php
            if ($areas_interes) {
            foreach ($areas_interes as $row) {?>
        <option value="<?php echo $row->area_interes; ?>"><?php echo $row->area_interes; ?></option>
        <?php }
        } else {?>
        <option value="">No hay áreas de interés registradas</option>
        <?php }?>
      </select>
    </div>
    <div class="col-sm-12 col-md-3 col-lg-3 mb-1">
      <label for="buscador">Buscar:</label>
      <select name="buscador" id="buscador" class="form-control">
        <option value="0">Encontrar</option>
        <?php
            if ($registros_asignacion) {
            foreach ($registros_asignacion as $row) {?>
        <option value="<?php echo $row->id; ?>"><?php echo '#' . $row->id . ' ' . $row->nombreCompleto; ?></option>
        <?php }
        } else {?>
        <option value="">No hay aspirantes registrados </option>
        <?php }?>
      </select>
    </div>
  </div>

  <a href="javascript:void(0)" class="btn btn-primary btn-icon-split btnRegresar" id="btnBack"
    onclick="regresarListado()" style="display: none;">
    <span class="icon text-white-50">
      <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text">Regresar al listado</span>
  </a>

  <div class="">
    <?php
        if (! function_exists('obtenerDato')) {
            function obtenerDato($r, $extras, $campo, $default = 'No registrado')
            {
                if (! empty($r->$campo)) {
                    return $r->$campo;
                }
                if (is_string($extras)) {
                    $extras = json_decode($extras, true);
                }
                if (is_array($extras) && isset($extras[$campo]) && $extras[$campo] !== '' && $extras[$campo] !== null) {
                    return $extras[$campo];
                }
                return $default;
            }
        }

        function obtenerPrimeroDisponible($r, $extras, $campos)
        {
            // Combinar $r y $extras en un solo arreglo
            $data = array_merge((array) $r, (array) $extras);

            // Normalizar las claves (minúsculas y sin espacios extras)
            $normalizadas = [];
            foreach ($data as $k => $v) {
                $normalizadas[strtolower(trim($k))] = $v;
            }

            // Buscar el primer campo que tenga valor
            foreach ($campos as $campo) {
                $campoNormalizado = strtolower(trim($campo));
                if (! empty($normalizadas[$campoNormalizado])) {
                    return $normalizadas[$campoNormalizado];
                }
            }

            return 'No registrado';
        }

    ?>
    <div id="seccionTarjetas">
      <?php
          /*
          echo '<pre>';
          print_r($registros);
          echo '</pre>';
        */
          if ($registros) {
              echo '<div class="row mb-3">';
              foreach ($registros as $r) {

                  date_default_timezone_set('America/Mexico_City');
                  $hoy                   = date('Y-m-d H:i:s');
                  $fecha_registro        = fechaTexto($r->creacion, 'espanol');
                  $color_estatus         = '';
                  $disabled_bloqueo      = '';
                  $disabled_comentario   = '';
                  $text_estatus          = '';
                  $desbloquear_aspirante = '';

                  // Detecta si es tipo "extras"
                  $extras       = [];
                  $esTipoExtras = false;
                  if (! empty($r->extras)) {
                      $extras       = json_decode($r->extras, true);
                      $esTipoExtras = (is_array($extras) && count($extras) > 0);
                  }

                  // --- Datos principales ---
                  $nombre         = obtenerDato($r, $extras, 'nombre', '');
                  $paterno        = obtenerDato($r, $extras, 'paterno', '');
                  $materno        = obtenerDato($r, $extras, 'materno', '');
                  $nombreCompleto = trim($nombre . ' ' . $paterno . ' ' . $materno);
                  $telefono       = obtenerDato($r, $extras, 'telefono');

                  $medio_contacto = obtenerDato($r, $extras, 'medio_contacto');
                  $area_interes   = obtenerDato($r, $extras, 'area_interes');
                  $correo         = obtenerPrimeroDisponible(
                      $r,
                      $extras,
                      ['E-MAIL E.G.C (email)', 'CORREO BINANCE (email) ', 'correo']
                  );
                  $domicilio = obtenerPrimeroDisponible($r, $extras, ['domicilio', 'direccion', 'estado']);
                  $estado    = obtenerDato($r, $extras, 'estado', '');
                  $direccion = obtenerDato($r, $extras, 'direccion', '');
                  $usuario   = (empty($r->usuario)) ? 'Sin asignar' : $r->usuario;

                  // Normaliza nombre y paterno para envío
                  if (empty($paterno) && ! empty($nombre) && strpos(trim($nombre), ' ') !== false) {
                      // Si NO hay 'paterno', pero el nombre tiene más de una palabra
                      $partes   = explode(' ', trim($nombre));
                      $paterno1 = array_pop($partes);    // Última palabra como paterno
                      $nombre1  = implode(' ', $partes); // El resto como nombre
                  } else {
                      $nombre1  = $nombre;
                      $paterno1 = $paterno;
                  }
                  $materno1 = $materno;

                  // Domicilio unificado para envío
                  $partesDomicilio = [];
                  if (! empty($domicilio)) {
                      $partesDomicilio[] = $domicilio;
                  }

                  if (! empty($direccion)) {
                      $partesDomicilio[] = $direccion;
                  }

                  if (! empty($estado)) {
                      $partesDomicilio[] = $estado;
                  }

                  $domicilio1 = implode(', ', $partesDomicilio);
                  // --- Definir el botón UNA SOLA VEZ ---
                  $botonProceso = '<a href="javascript:void(0)" class="btn btn-success  btn-cuadro mr-1" id="btnIniciar' . $r->id . '" data-toggle="tooltip" title="Asignarlo a Requisición" onclick="openAddApplicant('
                  . $r->id . ',\''
                  . addslashes($nombre1) . '\',\''
                  . addslashes($paterno1) . '\',\''
                  . addslashes($materno1) . '\',\''
                  . addslashes($telefono) . '\',\''
                  . addslashes($medio_contacto) . '\',\''
                  . addslashes($area_interes) . '\',\''
                  . addslashes($domicilio1) . '\',\''
                  . addslashes($correo) . '\')"><i class="fas fa-play-circle"></i></a>';

                  // --- Excepción para status 0: botón deshabilitado y otros cambios ---
                  if ($r->status == 0) {
                      $botonProceso = '
                        <a href="javascript:void(0)"
                          class="btn btn-success  btn-cuadro mr-1 isDisabled"

                          data-toggle="tooltip"
                          title="Asignarlo a Requisición">
                          <i class="fas fa-play"></i>
                        </a>';
                      $color_estatus         = 'req_negativa';
                      $text_estatus          = 'Estatus: <b>Bloqueado <br></b>';
                      $disabled_bloqueo      = 'isDisabled';
                      $disabled_comentario   = 'isDisabled';
                      $desbloquear_aspirante = '
                      <a href="javascript:void(0)"
                        class="btn btn-success  btn-cuadro mr-1 unlockButton"
                        style="width:38px;height:38px;"
                        onclick="confirmarDesbloqueo()"
                        data-toggle="tooltip"
                        title="Desbloquear">
                        <i class="fas fa-lock-open"></i>
                      </a>';
                  } elseif ($r->status == 1) {
                      $color_estatus = 'req_espera';
                      $text_estatus  = 'Estatus: <b>En espera <br></b>';
                  } elseif ($r->status == 2) {
                      $color_estatus       = 'req_activa';
                      $text_estatus        = 'Estatus: <b>En Proceso/Aprobado<br></b>';
                      $disabled_comentario = 'isDisabled';
                  } elseif ($r->status == 3) {
                      $color_estatus       = 'req_preventiva';
                      $text_estatus        = 'Estatus: <b>Reutilizable/<br></b>';
                      $disabled_comentario = 'isDisabled';
                  } elseif ($r->status == 4) {
                      $color_estatus       = 'req_positivo';
                      $text_estatus        = 'Estatus: <b>Preempleo/Contratado<br></b>';
                      $disabled_comentario = 'isDisabled';
                  } elseif ($r->status == 5) {
                      $color_estatus       = 'req_aprobado';
                      $text_estatus        = 'Estatus: <b>Aprobado con Acuerdo<br></b>';
                      $disabled_comentario = 'isDisabled';
                  }

                  $totalApplicants = count($registros);
                  $moveApplicant   = ($totalApplicants > 1) ? '' : 'offset-4';
              ?>
      <div class="col-sm-12 col-md-6 col-lg-4 mb-5<?php echo $moveApplicant ?>">
        <div class="card text-center ">
          <div
            class="card-header                                                                                                                                                           <?php echo $color_estatus ?>"
            id="req_header<?php echo $r->id; ?>">
            <b><?php echo '#' . $r->id . ' ' . $nombreCompleto; ?></b>
          </div>
          <div class="card-body">
            <?php if ($esTipoExtras): ?>
            <h5 class="card-text">
              Ubicación: <br>
              <b>
                <?php echo($domicilio ?? $estado . ', ' . $direccion); ?>
              </b>
            </h5>
            <h5 class="card-title">Correo: <br><b><?php echo $correo; ?></b></h5>
            <?php else: ?>
            <h5 class="card-title">Área de interés: <br><b><?php echo $area_interes; ?></b></h5>
            <h5 class="card-text">Ubicación: <br><b><?php echo $domicilio; ?></b></h5>
            <?php endif; ?>
            <h5 class="card-text">Teléfono: <b><?php echo $telefono; ?></b></h5>
            <div class="alert alert-secondary text-center mt-3"><?php echo $text_estatus ?></div>
            <div class="d-flex justify-content-center align-items-center flex-nowrap">
              <a href="javascript:void(0)" class="btn btn-primary btn-cuadro mr-1" data-toggle="tooltip"
                title="Ver detalles" onclick="verDetalles(<?php echo $r->id; ?>)">
                <i class="fas fa-info-circle"></i>
              </a>

              <a href="javascript:void(0)" class="btn btn-info btn-cuadro mr-1" data-toggle="tooltip"
                title="Ver empleos"
                onclick="verEmpleos(<?php echo $r->id; ?>,'<?php echo addslashes($nombreCompleto) ?>')">
                <i class="fas fa-user-tie"></i>
              </a>

              <a href="javascript:void(0)" class="btn btn-info btn-cuadro mr-1" data-toggle="tooltip"
                title="Historial de movimientos"
                onclick="verHistorialMovimientos(<?php echo $r->id; ?>,'<?php echo addslashes($nombreCompleto) ?>')">
                <i class="fas fa-history"></i>
              </a>

              <!-- Botón proceso -->
              <?php echo $botonProceso; ?>

              <?php if ($r->status == 0): ?>
              <a href="javascript:void(0)" class="btn btn-success btn-cuadro mr-1 unlockButton" data-toggle="tooltip"
                title="Desbloquear persona"
                onclick="mostrarMensajeConfirmacion('Desbloquear Aspirante','<?php echo addslashes($nombreCompleto) ?>',<?php echo $r->id; ?>)">
                <i class="fas fa-lock-open"></i>
              </a>
              <?php else: ?>
              <a href="javascript:void(0)" class="btn btn-danger btn-cuadro mr-1" data-toggle="tooltip"
                title="Bloquear persona"
                onclick="mostrarMensajeConfirmacion('bloquear proceso bolsa trabajo','<?php echo addslashes($nombreCompleto) ?>',<?php echo $r->id; ?>)">
                <i class="fas fa-ban"></i>
              </a>
              <?php endif; ?>

              <a href="javascript:void(0)" class="btn btn-warning btn-cuadro mr-1" data-toggle="tooltip"
                title="Editar aspirante"
                onclick="openUpdateApplicant(<?php echo $r->id; ?>,'<?php echo addslashes($nombreCompleto) ?>')">
                <i class="fas fa-edit"></i>
              </a>

              <a href="javascript:void(0)" class="btn btn-secondary btn-cuadro" data-toggle="tooltip"
                title="Subir documentos"
                onclick="openSubirDocumentos(<?php echo $r->id; ?>,'<?php echo addslashes($nombreCompleto) ?>')">
                <i class="fas fa-upload"></i>
              </a>

              <a href="javascript:void(0)" class="btn btn-status btn-cuadro mr-1" data-toggle="tooltip"
                title="Cambiar Estatus"
                onclick="openModalStatus(<?php echo $r->id; ?>,'<?php echo addslashes($nombreCompleto) ?>')">
                <i class="fas fa-exchange-alt"></i>
              </a>

            </div>

            <div class="alert alert-secondary text-center mt-3" id="divUsuario<?php echo $r->id; ?>">
              <b><?php echo $usuario . ' utrututu'; ?></b>
            </div>
          </div>
          <div class="card-footer text-muted">
            <?php echo $fecha_registro; ?>
          </div>
        </div>
      </div>
      <?php
          }
              echo '</div>';
      } else {?>
      <h3 class="text-center">Actualmente no hay aspirantes registrados.</h3>
      <?php }?>
    </div>






    <div id="tarjeta_detalle" class="hidden mb-5">
      <div class="alert alert-info text-center" id="nombre_completo"></div>
      <div class="card">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a class="nav-link active" id="link_personales" href="javascript:void(0)">Detallés</a>
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
    <div id="detalle_extras_dinamico"></div>

    <div id="seccionEditarBolsa" class="hidden">
      <div class="alert alert-info text-center" id="nombreBolsa"></div>
      <div class="card mb-5">
        <h5 class="card-header text-center seccion">Personal Data</h5>
        <div class="card-body">
          <form id="formDatosPersonales">
            <div id="form_campos_normales">
              <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                  <label>Nombre(s) *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="nombre_update" name="nombre_update"
                      onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                  </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                  <label>Apellido paterno*</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="paterno_update" name="paterno_update"
                      onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                  </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                  <label>Apellido Materno</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="materno_update" name="materno_update"
                      onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-8 col-lg-8 mb-1">
                  <label>Dirección *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-home"></i></span>
                    </div>
                    <input type="text" class="form-control" id="domicilio_update" name="domicilio_update">
                  </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                  <label>Fecha de nacimiento*</label>
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
                  <label>Nationalidad *</label>
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
                      <span class="input-group-text"><i class="fas fa-globe"></i></span>
                    </div>
                    <input type="text" class="form-control" id="nacionalidad_update" name="nacionalidad_update">
                  </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                  <label>Estado civil*</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <select class="custom-select" id="civil_update" name="civil_update">
                      <option value="">Seleciona</option>
                      <?php
                          if ($civiles) {
                          foreach ($civiles as $row) {?>
                      <option value="<?php echo $row->id ?>"><?php echo $row->nombre ?></option>
                      <?php }
                      } else {?>
                      <option value="">Sin registros de estado civil..</option>
                      <?php }?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12 col-md-8 col-lg-8 mb-1">
                  <label>Dependientes del solicitante*</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                    </div>
                    <input type="text" class="form-control" id="dependientes_update" name="dependientes_update">
                  </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                  <label>Nivel máximo de estudios. *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <select class="custom-select" id="escolaridad_update" name="escolaridad_update">
                      <option value="">Select</option>
                      <?php
                          if ($grados) {
                          foreach ($grados as $row) {?>
                      <option value="<?php echo $row->id ?>"><?php echo $row->nombre ?></option>
                      <?php }
                      } else {?>
                      <option value="">No se encontraron registros de educación.</option>
                      <?php }?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div id="extras_update" style="display:none"></div>
          </form>

          <div class="row mt-3">
            <div class="col-12 col-sm-6 mb-2">
              <button type="button" id="agregar_extra" class="btn btn-primary w-100">
                <i class="fas fa-plus"></i> Agregar campo extra
              </button>
            </div>
            <div class="col-12 col-sm-6 mb-2">
              <button type="button" class="btn btn-success w-100" onclick="updateApplicant('personal')">
                Guardar información personal
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-5" id="form_campos_normales2">
        <h5 class="card-header text-center seccion">Salud y vida social</h5>
        <div class="card-body">
          <form id="formSalud">

            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6 mb-1">
                <label>¿Cuál es tu estado de salud actual? **</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                  </div>
                  <input type="text" class="form-control" id="salud_update" name="salud_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6 mb-1">
                <label>¿Padeces alguna enfermedad crónica? *</label>
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
                <label>¿Practicas algún deporte? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                  </div>
                  <input type="text" class="form-control" id="deporte_update" name="deporte_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-6 mb-1">
                <label>¿Cuáles son tus metas en la vida? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                  </div>
                  <input type="text" class="form-control" id="metas_update" name="metas_update">
                </div>
              </div>
            </div>
          </form>
          <button type="button" class="btn btn-success btn-block text-lg" onclick="updateApplicant('salud')">Guardar
            información de salud y vida social</button>
        </div>
      </div>

      <div class="card mb-5" id="form_campos_normales3">
        <h5 class="card-header text-center seccion">Conocimientos y habilidades</h5>
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
                <label>Equipo de oficina o taller que maneja *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control" id="maquinas_update" name="maquinas_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>Software que maneja *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control" id="software_update" name="software_update">
                </div>
              </div>
            </div>
          </form>
          <button type="button" class="btn btn-success btn-block text-lg"
            onclick="updateApplicant('conocimiento')">Guardar Información de conocimientos y habilidades</button>
        </div>
      </div>
      <div class="card mb-5" id="form_campos_normales4">
        <h5 class="card-header text-center seccion">Intereses</h5>
        <div class="card-body">
          <form id="formIntereses">
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>¿Cómo te enteraste de TalentSafe? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                  </div>
                  <select class="custom-select" id="medio_contacto_update" name="medio_contacto_update">
                    <option value="">Select</option>
                    <?php
                        if ($medios) {
                        foreach ($medios as $row) {?>
                    <option value="<?php echo $row->nombre ?>"><?php echo $row->nombre ?></option>
                    <?php }
                    } else {?>
                    <option value="">No hay registros de fuentes de contacto.</option>
                    <?php }?>
                  </select>
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>¿En qué área te interesa trabajar? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  </div>
                  <input type="text" class="form-control" id="area_interes_update" name="area_interes_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>¿Cuál es el salario que deseas recibir? *</label>
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
                <label>¿Percibes algún ingreso adicional? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  </div>
                  <input type="text" class="form-control" id="otros_ingresos_update" name="otros_ingresos_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>¿Tienes disponibilidad para viajar? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                  </div>
                  <input type="text" class="form-control" id="viajar_update" name="viajar_update">
                </div>
              </div>
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label>¿En qué fecha puedes comenzar a trabajar? *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                  </div>
                  <input type="text" class="form-control" id="trabajar_update" name="trabajar_update">
                </div>
              </div>
            </div>
          </form>
          <button type="button" class="btn btn-success btn-block text-lg" onclick="updateApplicant('intereses')">Guardar
            Intereses</button>
        </div>
      </div>
    </div>

    <div id="extras_update" style="display:none">
      <div class="row"></div>
      <!-- Aquí se agregan los campos -->
    </div>


  </div>
  <!-- Sweetalert 2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
  <script>
  $(document).ready(function() {
    $('#ordenar').select2({
      placeholder: "Select",
      allowClear: false,
      width: '100%' // Asegura que el select ocupe todo el ancho del contenedor
    });
    $('#filtrar').select2({
      placeholder: "Select",
      allowClear: false,
      width: '100%' // Asegura que el select ocupe todo el ancho del contenedor
    });
    $('#asignar').select2({
      placeholder: "Select",
      allowClear: false,
      width: '100%' // Asegura que el select ocupe todo el ancho del contenedor
    });
    $('#area_interes_search').select2({
      placeholder: "Select",
      allowClear: false,
      width: '100%' // Asegura que el select ocupe todo el ancho del contenedor
    });
    $('#buscador').select2({
      placeholder: "Search",
      allowClear: false,
      width: '100%' // Asegura que el select ocupe todo el ancho del contenedor
    });

    let url_applicants = '<?php echo base_url('Reclutamiento/bolsa'); ?>';
    let oldURL = url_applicants;

    let sortOption = '<?php echo $sortApplicant ?>';
    let filterOption = '<?php echo $filter ?>';
    let assignOption = '<?php echo $assign ?>';
    let areaOption = '<?php echo $area ?>';
    $('#ordenar, #filtrar, #asignar, #area_interes_search').change(function() {
      let ordenar = $('#ordenar').val() || 'none';
      let filtrar = $('#filtrar').val() != '' ? $('#filtrar').val() : 'none'
      let asignar = $('#asignar').val() || 0;
      let area = $('#area_interes_search').val() || 'none';

      // Construir la nueva URL
      var newUrl = oldURL + '?' + 'sort=' + ordenar + '&filter=' + filtrar + '&user=' + asignar + '&area=' +
        area;

      // Realizar la petición AJAX
      $.get(newUrl, function(data) {
        $('#module-content').html(data);
      }).fail(function() {
        $('#module-content').html('<p>Error al cargar el contenido.</p>');
      });

      return false;
    });

    // Inicializa los filtros

    $('#buscador').change(function() {
      var opcion = $(this).val();
      if (opcion) {
        var newUrl = url_applicants + "?applicant=" + opcion;

        $.get(newUrl, function(data) {
          $('#module-content').html(data);
        }).fail(function() {
          $('#module-content').html('<p>Error al cargar el contenido.</p>');
        });
      }
    });



    $('.nav-link').click(function() {
      $('.nav-link').removeClass('active');
      $(this).addClass('active');
    })
    $('#link_personales').click(function() {
      $('.div_info').css('display', 'none');
      $('#div_registro').css('display', 'block');
    })
  });

  function regresarListado() {
    location.reload();
  }

  function confirmarAccion(accion, valor) {
    $('#mensajeModal').modal('hide');
    var id = $('#idRequisicion').val();

    //Colocar en privado o publico
    if (accion == 1) {
      $.ajax({
        url: '<?php echo base_url('Reclutamiento/cambiarStatusRequisicion'); ?>',
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
          if (dato.codigo === 1) {
            $('#divIniciar' + id).html('<h5 class="text-info"><b>En proceso</b></h5>');
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: dato.msg,
              showConfirmButton: false,
              timer: 2500
            })
            setTimeout(function() {
              location.reload();
            }, 2500)
          }
        }
      });
    }
  }

  function verDetalles(id) {
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/getBolsaTrabajoById'); ?>',
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
        var dato = JSON.parse(res);

        // Detecta si tiene extras con info
        var extras = {};
        var esTipoExtras = false;
        if (dato['extras'] && dato['extras'] !== "" && dato['extras'] !== null) {
          try {
            extras = typeof dato['extras'] === "string" ? JSON.parse(dato['extras']) : dato['extras'];
            esTipoExtras = Object.keys(extras).length > 0;
          } catch (e) {
            extras = {};
            esTipoExtras = false;
          }
        }

        $('#btnBack').css('display', 'block');
        $('#divFiltros').css('display', 'none');
        $('#seccionTarjetas').css('display', 'none');

        // ----------- DINÁMICO PARA EXTRAS -------------
        if (esTipoExtras) {
          $('#tarjeta_detalle').hide();
          $('#detalle_extras_dinamico').show();

          let html = `
          <div class="card shadow-sm mt-4">
            <div class="alert alert-info text-center">
              <h5 class="mb-0">
                <i class="fas fa-info-circle"></i>
                <b>Detalles del aspirante</b>
                <h3>#${dato['id']} ${dato['nombreCompleto'] || ''}</h3>
              </h5>
            </div>
            <div class="card-body">
              <div class="container-fluid">
                <div class="row">
                `;

          // Transforma el objeto extras en un array de pares clave-valor, para poder hacer columnas
          const entries = Object.entries(extras).filter(([key, _]) => key !== '_token');
          const colsPerRow = 3; // Cambia a 3 si quieres 3 columnas

          for (let i = 0; i < entries.length; i += colsPerRow) {
            html += `<div class="w-100"></div>`; // Nueva fila
            for (let j = i; j < i + colsPerRow && j < entries.length; j++) {
              const [key, value] = entries[j];
              let etiqueta = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
              let icono = '';
              if (key.toLowerCase().includes('correo')) icono =
                '<i class="fas fa-envelope-open-text text-secondary"></i> ';
              if (key.toLowerCase().includes('direccion')) icono =
                '<i class="fas fa-map-marker-alt text-danger"></i> ';
              if (key.toLowerCase().includes('estado')) icono = '<i class="fas fa-map text-success"></i> ';
              if (key.toLowerCase().includes('telefono')) icono =
                '<i class="fas fa-phone-alt text-primary"></i> ';

              html += `
              <div class="col-md-4 col-sm-12 mb-3">
                <div class="p-3 border rounded bg-light h-100">
                  <div class="font-weight-bold">${icono}${etiqueta}</div>
                  <div>${value}</div>
                </div>
              </div>
              `;
            }
          }

          html += `
                </div>
              </div>
            </div>
          </div>
          `;

          $('#detalle_extras_dinamico').html(html);
        } else {
          // ------------ VISTA NORMAL (tu código clásico) ---------------
          $('#tarjeta_detalle').show(); // Muestra los detalles clásicos
          $('#detalle_extras_dinamico').hide(); // <-- Oculta el dinámico si no aplica

          let f_nacimiento = (dato['fecha_nacimiento'] === '' || dato['fecha_nacimiento'] === null) ?
            'No registrado' :
            fechaSimpleAFront(dato['fecha_nacimiento']);
          let edad = (dato['edad'] === '' || dato['edad'] === null) ?
            'No registrado' :
            dato['edad'] + ' años';

          $('#nombre_completo').html('<b>Detalles del aspirante <h3>#' + dato['id'] + ' ' + dato[
            'nombreCompleto'] + '</h3></b>');
          $('#detalle_area_interes').html('Área de interés:<br><b>' + (dato['area_interes'] || 'No registrado') +
            '</b>');
          $('#detalle_f_nacimiento').html('<b>Fecha de nacimiento: </b> ' + f_nacimiento);
          $('#detalle_edad').html('<b>Edad: </b>' + edad);
          $('#detalle_nacionalidad').html('<b>Nacionalidad:</b> ' + (dato['nacionalidad'] || 'No registrado'));
          $('#detalle_civil').html('<b>Estado civil:</b> ' + (dato['civil'] || 'No registrado'));
          $('#detalle_dependientes').html('<b>Dependientes:</b> ' + (dato['dependientes'] || 'No registrado'));
          $('#detalle_grado_estudios').html('<b>Grado máximo de estudios:</b> ' + (dato['grado_estudios'] ||
            'No registrado'));
          $('#detalle_sueldo_deseado').html('<b>Sueldo deseado:</b> ' + (dato['sueldo_deseado'] ||
            'No registrado'));
          $('#detalle_otros_ingresos').html('<b>Otros ingresos:</b> ' + (dato['otros_ingresos'] ||
            'No registrado'));
          $('#detalle_viajar').html('<b>¿Disponibilidad para viajar?:</b> ' + (dato['viajar'] ||
            'No registrado'));
          $('#detalle_trabajar').html('<b>¿Cuándo podría presentarse a trabajar?:</b> ' + (dato['trabajar'] ||
            'No registrado'));
          $('#detalle_domicilio').html('<b>Domicilio:</b><br> ' + (dato['domicilio'] || 'No registrado'));
          $('#detalle_salud').html('<b>Estado de salud:</b> ' + (dato['salud'] || 'No registrado'));
          $('#detalle_enfermedad').html('<b>Enfermedad crónica:</b> ' + (dato['enfermedad'] || 'No registrado'));
          $('#detalle_deporte').html('<b>Deporte:</b> ' + (dato['deporte'] || 'No registrado'));
          $('#detalle_metas').html('<b>Metas en la vida:</b> ' + (dato['metas'] || 'No registrado'));
          $('#detalle_medio_contacto').html('<b>¿Cómo se enteró de RODI?:</b><br> ' + (dato['medio_contacto'] ||
            'No registrado'));
          $('#detalle_idiomas').html('<b>Idiomas que domina:</b><br> ' + (dato['idiomas'] || 'No registrado'));
          $('#detalle_maquinas').html('<b>Máquinas de oficina o taller que maneja:</b><br> ' + (dato[
            'maquinas'] || 'No registrado'));
          $('#detalle_software').html('<b>Software que conoce:</b><br> ' + (dato['software'] || 'No registrado'));
          $('#tarjeta_detalle').css('display', 'block');
          $('#detalle_extras_dinamico').html('');
        }


      }
    });
  }

  // Utilidades locales
  function _baseName(filename) {
    if (!filename) return '';
    const lastSlash = Math.max(filename.lastIndexOf('/'), filename.lastIndexOf('\\'));
    const justName = lastSlash !== -1 ? filename.substring(lastSlash + 1) : filename;
    const dot = justName.lastIndexOf('.');
    return dot > 0 ? justName.substring(0, dot) : justName;
  }

  function _fmtBytes(bytes) {
    if (!bytes) return '0 B';
    const k = 1024,
      sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
  }

  function openSubirDocumentos(idAspirante, nombreCompleto) {
    $("#docIdAspirante").val(idAspirante);
    $("#docNombreAspirante").text(nombreCompleto);

    $("#tablaDocumentos tbody").html('<tr><td colspan="2">Cargando...</td></tr>');
    $("#inputArchivos").val('');
    $("#previewArchivos tbody").empty();
    $("#previewArchivos").hide();

    $("#modalDocumentos").modal("show");

    $.ajax({
      url: '<?php echo base_url('Reclutamiento/getDocumentosBolsa'); ?>',
      type: "POST",
      data: {
        id: idAspirante
      },
      dataType: "json",
      success: function(resp) {
        console.log('getDocumentosBolsa ->', resp); // 👈 para depurar

        // Normaliza: si viene objeto, conviértelo a arreglo de 1
        const docs = Array.isArray(resp) ? resp : (resp && typeof resp === 'object' ? [resp] : []);

        let rows = "";
        if (docs.length > 0) {
          rows = docs.map(function(doc) {
            const nombreMostrar = (doc.nombre_personalizado && doc.nombre_personalizado.trim() !== '') ?
              doc.nombre_personalizado :
              doc.nombre_archivo;

            // ⚠️ Carpeta pública correcta
            const href = '<?php echo base_url('docsBolsa/'); ?>' + encodeURIComponent(doc.nombre_archivo);

            // Evita romper el HTML con comillas
            const safeNombreMostrar = (nombreMostrar || '').replace(/'/g, "\\'");
            const safeNombreArchivo = (doc.nombre_archivo || '').replace(/'/g, "\\'");

            return `
            <tr>
              <td>
                <a href="${href}" target="_blank">${nombreMostrar}</a>
              </td>
              <td>
                <button class="btn btn-sm btn-info" onclick="renombrarDoc(${Number(doc.id)}, '${safeNombreMostrar}', '${safeNombreArchivo}')">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="eliminarDoc(${Number(doc.id)})">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>`;
          }).join('');
        } else {
          rows = "<tr><td colspan='2'>No hay documentos</td></tr>";
        }
        $("#tablaDocumentos tbody").html(rows);
      },
      error: function(xhr) {
        $("#tablaDocumentos tbody").html("<tr><td colspan='2'>Error al cargar documentos</td></tr>");
        console.error(xhr.responseText || xhr);
      }
    });
  }

  function actualizarTarjetaVisualStatus(id, status) {
    // Mapea clases + colores de respaldo (inline)
    const map = {
      1: {
        cls: 'req_espera',
        bg: '#6c757d',
        fg: '#fff',
        text: 'Estatus: <b>En espera <br></b>'
      }, // gris
      2: {
        cls: 'req_activa',
        bg: '#17a2b8',
        fg: '#fff',
        text: 'Estatus: <b>En Proceso/Aprobado<br></b>'
      }, // azul cielo
      3: {
        cls: 'req_preventiva',
        bg: '#ffc107',
        fg: '#212529',
        text: 'Estatus: <b>Reutilizable/<br></b>'
      }, // amarillo
      4: {
        cls: 'req_positivo',
        bg: '#28a745',
        fg: '#fff',
        text: 'Estatus: <b>Preempleo/Contratado<br></b>'
      }, // verde
      5: {
        cls: 'req_aprobado',
        bg: '#fd7e14',
        fg: '#212529',
        text: 'Estatus: <b>Aprobado con Acuerdo<br></b>'
      } // naranja
    };

    const conf = map[parseInt(status, 10)];
    if (!conf) return;

    // 1) Header de la tarjeta
    const $header = $("#req_header" + id);
    if (!$header.length) return;

    // Asegura quitar TODAS las clases de estado conocidas
    $header.removeClass('req_espera req_activa req_preventiva req_positivo req_aprobado req_negativa');

    // Añade la nueva clase
    $header.addClass(conf.cls);

    // Fallback: fuerza colores inline por si otro CSS pisa los estilos
    // (no quita tus clases; solo asegura el color correcto al instante)
    $header.css({
      backgroundColor: conf.bg,
      color: conf.fg
    });

    // 2) Texto del estatus dentro de la tarjeta
    const $card = $header.closest('.card');
    // Si tienes varios .alert-secondary, toma el primero debajo del body
    const $alertEstatus = $card.find('.alert.alert-secondary').first();
    if ($alertEstatus.length) {
      $alertEstatus.html(conf.text);
    }
  }


  function openModalStatus(idAspirante, statusActual) {
    $("#statusIdAspirante").val(idAspirante);
    $("#selectStatus").val(statusActual || "").trigger("change");
    $("#modalStatus").modal("show");
  }

  if (!window.STATUS_COLORS) {
    window.STATUS_COLORS = Object.freeze({
      1: {
        bg: '#d6d6d6',
        fg: '#000'
      },
      2: {
        bg: '#87CEFA',
        fg: '#000'
      },
      3: {
        bg: '#FFD700',
        fg: '#000'
      },
      4: {
        bg: '#32CD32',
        fg: '#fff'
      },
      5: {
        bg: '#ff6200ff',
        fg: '#000'
      }
    });
  }


  $("#selectStatus").on("change", function() {
    const val = $(this).val();
    const s = STATUS_COLORS[val];
    if (s) {
      $(this).css({
        "background-color": s.bg,
        "color": s.fg
      });
    } else {
      $(this).css({
        "background-color": "",
        "color": ""
      });
    }
  });

  function guardarStatusAspirante() {
    const id = $("#statusIdAspirante").val();
    const status = $("#selectStatus").val();

    if (!id || !status) {
      Swal.fire("Atención", "Debes seleccionar un estatus.", "warning");
      return;
    }

    $.ajax({
      url: "<?php echo base_url('Reclutamiento/actualizar_status'); ?>",
      type: "POST",
      dataType: "json",
      data: {
        id,
        status
      },
      success: function(r) {
        if (r.ok) {
          Swal.fire({
            icon: "success",
            title: "¡Listo!",
            text: "Estatus actualizado",
            timer: 1500,
            showConfirmButton: false
          });
          $("#modalStatus").modal("hide");

          // 🔸 refresca solo la tarjeta visualmente
          const id = $("#statusIdAspirante").val();
          const status = $("#selectStatus").val();
          actualizarTarjetaVisualStatus(id, status);
        } else {
          Swal.fire("Error", r.msg || "No fue posible actualizar", "error");
        }
      },
      error: function() {
        Swal.fire("Error", "Ocurrió un problema al guardar.", "error");
      }
    });
  }


  async function renombrarDoc(idDoc, nombreActual, nombreArchivo) {
    const porDefecto = (nombreActual && nombreActual.trim()) ?
      nombreActual.trim() :
      (nombreArchivo ? nombreArchivo.replace(/\.[^/.]+$/, '') : '');

    const {
      value: nombre
    } = await Swal.fire({
      title: 'Renombrar documento',
      input: 'text',
      inputValue: porDefecto,
      inputAttributes: {
        autocapitalize: 'off',
        maxlength: 255
      },
      inputAutoFocus: true, // (por defecto ya es true, pero lo dejamos explícito)
      showCancelButton: true,
      confirmButtonText: 'Guardar',
      cancelButtonText: 'Cancelar',
      showLoaderOnConfirm: true,
      allowOutsideClick: () => !Swal.isLoading(),
      didOpen: () => { // asegura foco al input
        const input = Swal.getInput();
        if (input) input.focus();
      },
      inputValidator: (value) => {
        if (!value || !value.trim()) return 'Escribe un nombre';
        if (/[/\\:*?"<>|]/.test(value)) return 'No uses caracteres inválidos: /\\:*?"<>|';
        return undefined;
      },
      preConfirm: (value) => {
        const nombre = value.trim();
        return $.ajax({
          url: '<?php echo base_url('Reclutamiento/renombrarDocumentoBolsa'); ?>',
          type: 'POST',
          dataType: 'json',
          data: {
            id: idDoc,
            nombre
          }
        }).then((r) => {
          if (!r || !r.ok) throw new Error((r && r.msg) ? r.msg : 'No se pudo renombrar');
          return r;
        }).catch((err) => {
          Swal.showValidationMessage(err.message || 'Error al renombrar');
        });
      }
    });

    if (nombre) {
      Swal.fire({
        icon: 'success',
        title: 'Renombrado',
        timer: 1200,
        showConfirmButton: false
      });
      openSubirDocumentos($("#docIdAspirante").val(), $("#docNombreAspirante").text());
    }
  }



  function eliminarDoc(idDoc) {
    Swal.fire({
      title: '¿Eliminar documento?',
      text: 'Esta acción no se puede deshacer',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar',
      reverseButtons: true,
      showLoaderOnConfirm: true,
      preConfirm: () => {
        return $.ajax({
          url: '<?php echo base_url('Reclutamiento/eliminarDocumentoBolsa'); ?>',
          type: 'POST',
          dataType: 'json',
          data: {
            id: idDoc
          }
        }).then((r) => {
          if (!r || !r.ok) {
            throw new Error((r && r.msg) ? r.msg : 'No se pudo eliminar');
          }
          return r;
        }).catch((err) => {
          Swal.showValidationMessage(err.message || 'Error al eliminar');
        });
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          icon: 'success',
          title: 'Eliminado',
          timer: 1200,
          showConfirmButton: false
        });
        openSubirDocumentos($("#docIdAspirante").val(), $("#docNombreAspirante").text());
      }
    });
  }



  // PREVIEW: cuando seleccionen archivos
  $("#inputArchivos").on("change", function() {
    const files = Array.from(this.files || []);
    const $prev = $("#previewArchivos");
    const $tbody = $prev.find("tbody");
    $tbody.empty();

    if (!files.length) {
      $prev.hide();
      return;
    }
    files.forEach((file, idx) => {
      $tbody.append(`
      <tr>
        <td>${idx + 1}</td>
        <td>${file.name}</td>
        <td>
          <input type="text" class="form-control form-control-sm nombre-personalizado"
                 value="${_baseName(file.name).replace(/"/g, '&quot;')}" data-index="${idx}"
                 placeholder="Nombre sin extensión">
        </td>
        <td>${_fmtBytes(file.size)}</td>
      </tr>
    `);
    });
    $prev.show();
  });

  // SUBIR múltiples archivos + nombres
  $("#formSubirDocs").on("submit", function(e) {
    e.preventDefault();

    const idAspirante = $("#docIdAspirante").val();
    const input = document.getElementById('inputArchivos');
    const files = Array.from(input.files || []);
    if (!files.length) {
      alert('Selecciona al menos un archivo');
      return;
    }

    const nombresInputs = Array.from(document.querySelectorAll('#previewArchivos .nombre-personalizado'));
    if (nombresInputs.length !== files.length) {
      alert('Ocurrió un problema al leer los nombres personalizados.');
      return;
    }

    const fd = new FormData();
    fd.append('id_aspirante', idAspirante);

    // Empaqueta en el mismo orden
    files.forEach((file) => fd.append('archivos[]', file, file.name));
    nombresInputs.forEach((inp) => fd.append('nombres[]', inp.value.trim()));

    $.ajax({
      url: '<?php echo base_url('Reclutamiento/subirDocumentosBolsa'); ?>', // ajusta a tu ruta
      type: 'POST',
      data: fd,
      processData: false,
      contentType: false,
      success: function(resp) {
        // refresca lista
        openSubirDocumentos(idAspirante, $("#docNombreAspirante").text());
        // limpia preview
        $("#inputArchivos").val('');
        $("#previewArchivos tbody").empty();
        $("#previewArchivos").hide();
      },
      error: function(xhr) {
        alert('Error al subir documentos');
        console.error(xhr.responseText || xhr);
      }
    });
  });




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
        if (res != 0) {
          var dato = JSON.parse(res);
          for (var i = 0; i < dato.length; i++) {
            salida += "<tr>";
            salida += '<td>' + dato[i]['empresa'] + '</td>';
            salida += '<td>' + dato[i]['periodo'] + '</td>';
            salida += '<td>' + dato[i]['sueldo'] + '</td>';
            salida += '<td>' + dato[i]['puesto'] + '</td>';
            salida += '<td>' + dato[i]['causa_separacion'] + '</td>';
            salida += '<td>' + dato[i]['telefono'] + '</td>';
            salida += "</tr>";
          }
        } else {
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

  function openAddApplicant(id, nombre, paterno, materno, telefono, medio, area_interes, domicilio, correo) {
    $('#idBolsa').val(id);
    $('#nombre').val(nombre);
    $('#paterno').val(paterno);
    $('#materno').val(materno);
    $('#telefono1').val(telefono);
    $('#medio').val(medio);

    $('#area_interes').val(area_interes);
    $('#domicilio').val(domicilio);
    $('#correo1').val(correo);
    // Limpiar el select antes de agregar nuevas opciones
    $('#req_asignada').empty();
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
        if (res.length > 0) {
          let data = JSON.parse(res);
          //console.log("🚀 ~ openAddApplicant ~ res:", res)
          for (let i = 0; i < data.length; i++) {
            let optionText = '#' + data[i]['idReq'] + ' ' + data[i]['nombre_cliente'] + ' - ' + data[i][
                'puesto'
              ] +
              ' - Vacantes: ' + data[i]['numero_vacantes'];
            $('#req_asignada').append($('<option>', {
              value: data[i]['idReq'],
              text: optionText
            }));
          }

        } else {
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
    datos.append('correo', $("#correo1").val());
    datos.append('telefono', $("#telefono1").val());
    datos.append('medio', $("#medio").val());
    datos.append('area_interes', $("#area_interes").val());
    datos.append('domicilio', $("#domicilio").val());
    // datos.append("cv", cv);
    datos.append("id_aspirante", 0);
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
          setTimeout(function() {
            location.reload();
          }, 2500)
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

  function verHistorialMovimientos(id, nombreCompleto) {
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
        if (res != 0) {
          var dato = JSON.parse(res);
          for (var i = 0; i < dato.length; i++) {
            var aux = dato[i]['creacion'].split(' ');
            var f = aux[0].split('-');
            var fecha = f[2] + '/' + f[1] + '/' + f[0];
            salida += "<tr>";
            salida += '<td>#' + dato[i]['id_requisicion'] + ' ' + dato[i]['nombre'] + '</td>';
            salida += '<td>' + fecha + '</td>';
            salida += '<td>' + dato[i]['accion'] + '</td>';
            salida += '<td>' + dato[i]['descripcion'] + '</td>';
            salida += "</tr>";
          }
        } else {
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

  function mostrarMensajeConfirmacion(accion, valor1, valor2) {
    $('#idBolsa').val(valor2); //id
    $('#titulo_mensaje').text((accion == "bloquear proceso bolsa trabajo") ? 'Bloquear proceso' :
      'Desbloquear Proceso');
    $('#mensaje').html((accion == "bloquear proceso bolsa trabajo") ?
      '¿Desea bloquear a <b>' + valor1 + '</b> de todo proceso de reclutamiento?' :
      '¿Desea desbloquear a <b>' + valor1 + '</b>?');

    $('#campos_mensaje').html(''); // Limpiar campos de mensaje

    if (accion == "bloquear proceso bolsa trabajo") {
      $('#campos_mensaje').html(
        '<div class="row"><div class="col-12"><label>Motivo de bloqueo *</label><textarea class="form-control" rows="3" id="mensaje_comentario" name="mensaje_comentario"></textarea></div></div>'
      );
      $('#btnConfirmar').attr("onclick", "cambiarStatusBolsaTrabajo(" + valor2 + ", 'bloquear')");
    } else {
      $('#btnConfirmar').attr("onclick", "cambiarStatusBolsaTrabajo(" + valor2 + ", 'desbloquear')");
    }

    $('#mensajeModal').modal('show'); // Aquí estaba el problema, la llave de cierre estaba mal ubicada
  }

  function cambiarStatusBolsaTrabajo(id_bolsa, action) {

    if (action === 'desbloquear') {
      comentario = 'x';
    } else {
      comentario = $('#mensaje_comentario').val().trim();
    }
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/cambiarStatusBolsaTrabajo'); ?>',
      type: 'post',
      data: {
        'id_bolsa': id_bolsa,
        'comentario': comentario,
        'accion': action, // Pasar la acción (bloquear/desbloquear)
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        var data = JSON.parse(res);
        console.log("🚀 ~ cambiarStatusBolsaTrabajo ~ data:", data)
        if (data.codigo === 1) {
          $("#mensajeModal").modal('hide');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: data.msg,
            showConfirmButton: false,
            timer: 3000
          })
          setTimeout(function() {
            location.reload();
          }, 3000)
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Hubo un problema intentalon de nuevo ',
            html: data.msg,
            width: '50em',
            confirmButtonText: 'Cerrar'
          })
        }
      }
    });
  }

  function verHistorialBolsaTrabajo(id, nombreCompleto) {
    $(".nombreRegistro").text(nombreCompleto);
    $('#div_historial_comentario').empty();
    $('#btnComentario').attr('onclick', 'guardarComentario(' + id + ')');
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
        if (res != 0) {
          var dato = JSON.parse(res);
          for (var i = 0; i < dato.length; i++) {
            var aux = dato[i]['creacion'].split(' ');
            var f = aux[0].split('-');
            var fecha = f[2] + '/' + f[1] + '/' + f[0];
            salida += "<tr>";
            salida += '<td>' + fecha + '</td>';
            salida += '<td>' + dato[i]['usuario'] + '</td>';
            salida += '<td>' + dato[i]['comentario'] + '</td>';
            salida += "</tr>";
          }
        } else {
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
  $('#modalGenerarLink').on('show.bs.modal', function() {
    $('#linkGenerado').html("Cargando...");
    $('#qrGenerado').html("");

    $.ajax({
      url: '<?php echo base_url("Reclutamiento/verificar_archivos_existentes"); ?>',
      type: 'POST',
      dataType: 'json',
      success: function(response) {


        // Mostrar aviso
        const avisoHref = response.aviso ?
          "<?php echo base_url('Avance/ver/'); ?>" + encodeURIComponent(response.aviso) :
          "<?php echo base_url('Avance/ver/AvisoPrivacidadTalentSafeControl-V1.0.pdf'); ?>";

        // Link generado
        if (response.link) {
          $('#linkGenerado').html(`<a href="${response.link}" target="_blank">${response.link}</a>`);
        } else {
          $('#linkGenerado').html("Aún no se ha generado un link.");
        }

        // QR generado
        if (response.qr) {
          $('#qrGenerado').html(`<img src="${response.qr}" alt="QR" style="max-width: 150px;">`);
        }
      },
      error: function() {
        $('#linkGenerado').html("Error al obtener datos del portal.");
      }
    });
  });


  // Botón para generar o actualizar link y QR
  $('#btnGenerarLink').on('click', function() {
    Swal.fire({
      icon: 'warning',
      title: '¿Estás seguro?',
      text: 'El link y el código QR anteriores quedarán obsoletos. ¿Deseas continuar?',
      showCancelButton: true,
      confirmButtonText: 'Sí, continuar',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        // Si el usuario confirma, ejecutar AJAX
        $.ajax({
          url: '<?php echo base_url("Reclutamiento/generar_o_mostrar_link") ?>',
          type: 'POST',
          dataType: 'json',
          success: function(response) {
            if (response.link) {
              $('#linkGenerado').html(`<a href="${response.link}" target="_blank">${response.link}</a>`);
              $('#qrGenerado').html(`<img src="${response.qr}" alt="QR" style="max-width: 150px;">`);

              Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: response.mensaje || 'Link generado/actualizado correctamente.',
              }).then(() => {
                $('#modalGenerarLink').modal('show');
              });

            } else if (response.error) {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: response.error,
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo generar el link.',
              });
            }
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Error en la generación del link.',
            });
          }
        });
      }
    });
  });



  function nuevaRequisicion() {
    $('#nuevaRequisicionModal').modal('show')
  }
  //* Asignacion de Usuario a registro de Bolsa de Trabajo
  function openAssignToUser() {
    let url = '<?php echo base_url('Reclutamiento/assignToUser'); ?>';
    $('#titulo_asignarUsuarioModal').text('Asignar registro de bolsa de trabajo a un reclutador');
    $('label[for="asignar_usuario"]').text('Reclutador *');
    $('label[for="asignar_registro"]').text('Persona en bolsa de Trabajo *');

    $('#asignar_usuario').removeAttr("multiple");



    // Inicializar Select2
    $('#asignar_usuario').select2({
      placeholder: "Select a recruiter", // Placeholder
      allowClear: false,
      width: '100%'
      // Permitir limpiar la selección
    });

    $('#asignar_usuario').attr("name", "asignar_usuario");
    $('#btnAsignar').attr("onclick", "assignToUser(\"" + url + "\",'bolsa_trabajo')");
    $('#asignarUsuarioModal').modal('show');
  }
  //* Carga de aspirantes masivos de acuerdo a CSV
  function descargarFormato() {
    // Ruta del archivo a descargar
    let url = '<?php echo base_url() . '_docs/CargarAspirantes.csv'; ?>';

    // Realizar solicitud para descargar el archivo
    fetch(url)
      .then(response => {
        // Verificar si la respuesta es exitosa
        if (!response.ok) {
          throw new Error('Error al descargar el archivo');
        }
        // Devolver el contenido del archivo como un blob
        return response.blob();
      })
      .then(blob => {
        // Crear un objeto URL para el blob
        const url = window.URL.createObjectURL(blob);
        // Crear un enlace temporal para descargar el archivo
        const a = document.createElement('a');
        a.href = url;
        a.download = 'CargarAspirantes.csv'; // Nombre del archivo para descargar
        // Agregar el enlace al documento y simular un clic en él para iniciar la descarga
        document.body.appendChild(a);
        a.click();
        // Eliminar el enlace del documento
        document.body.removeChild(a);
        // Revocar el objeto URL para liberar memoria
        window.URL.revokeObjectURL(url);
      })
      .catch(error => {
        console.error('Error:', error);
        // Manejar el error, por ejemplo, mostrando un mensaje al usuario
        alert('Error al descargar el archivo');
      });
  }

  function openUploadCSV() {
    let url = '<?php echo base_url('Reclutamiento/uploadCSV'); ?>';
    $('#subirCSVModal .modal-title').text('Subir aspirantes masivos por csv');
    $('#subirCSVModal #label').html('Selecciona el archivo <code>.csv</code>');
    $('#btnSubir').attr("onclick", "uploadCSV(\"" + url + "\")");
    $('#subirCSVModal').modal('show');
  }

  function openUpdateApplicant(id, nombre) {
    $('#idBolsa').val(id)
    $('#nombreBolsa').html('<b>Edición del aspirante <h3>#' + id + ' ' + nombre + '</h3></b>')
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/getDetailsApplicantById'); ?>',
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

        var dato = JSON.parse(res);
        //console.log("🚀 ~ openUpdateApplicant ~ dato:", dato)

        // Detecta si hay datos en extras
        var extras = {};
        var esTipoExtras = false;
        if (dato['extras'] && dato['extras'] !== "" && dato['extras'] !== null) {
          try {
            extras = typeof dato['extras'] === "string" ? JSON.parse(dato['extras']) : dato['extras'];
            esTipoExtras = Object.keys(extras).length > 0;
          } catch (e) {
            extras = {};
            esTipoExtras = false;
          }
        }

        if (esTipoExtras) {
          $('#form_campos_normales').hide();
          $('#form_campos_normales2').hide();
          $('#form_campos_normales3').hide();
          $('#form_campos_normales4').hide();

          let nombre = (dato['nombre'] || extras['nombre'] || '');
          let paterno = (dato['paterno'] || extras['paterno'] || '');
          if (paterno) {
            nombre = nombre + ' ' + paterno;
          }

          const camposNormales = {
            nombre: nombre,
            telefono: dato['telefono'] || extras['telefono'] || "",
            fecha_nacimiento: dato['fecha_nacimiento'] || extras['fecha_nacimiento'] || ""
          };

          const camposDinamicos = {
            ...camposNormales
          };

          // Añadir los extras que no existan
          Object.keys(extras).forEach(function(key) {
            if (key === '_token') return;
            if (!camposDinamicos.hasOwnProperty(key)) {
              camposDinamicos[key] = extras[key];
            }
          });

          // Generar todos los campos existentes
          let html = `<div class="row">`;
          Object.keys(camposDinamicos).forEach(function(key) {
            let etiqueta = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            html += `
            <div class="col-md-4 col-sm-12 mb-3 extra-dinamico" data-key="${key}">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <label class="font-weight-bold mb-2">${etiqueta}</label>
                        <div class="d-flex align-items-center mb-2">
                            <input type="text" class="form-control" name="extra_${key}" value="${camposDinamicos[key] || ''}">
                            <button type="button" class="btn btn-sm btn-danger ml-2 eliminar-extra" data-key="${key}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            `;
          });
          html += `</div>`;

          $('#extras_update').html(html).show();

          // Contador global para nuevos extras (fuera de la función)
          let contadorExtras = 0;

          // Botón para agregar campos nuevos
          $('#agregar_extra').off('click').on('click', function() {
            contadorExtras++;
            const keyDefault = `nuevo_${contadorExtras}`;
            const keySlug = slugKey(keyDefault);

            const htmlNuevo = `
            <div class="col-md-4 col-sm-12 mb-3 extra-dinamico" data-key="${keySlug}">
              <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                  <label class="font-weight-bold mb-2">Nuevo campo extra</label>
                  <div class="d-flex mb-2">
                    <input type="text" class="form-control llave-extra mr-2"
                          placeholder="Nombre de la llave" value="${keySlug}">
                    <!-- IMPORTANTE: el valor SIEMPRE tiene name="extra_<slug>" -->
                    <input type="text" class="form-control valor-extra mr-2"
                          name="extra_${keySlug}" placeholder="Valor" value="">
                    <button type="button" class="btn btn-sm btn-danger eliminar-extra" data-key="${keySlug}">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>
                  <small class="text-muted">Se enviará como <code>extra_${keySlug}</code></small>
                </div>
              </div>
            </div>`;
            $('#extras_update .row').append(htmlNuevo);
          });
          $(document).on('input', '.llave-extra', function() {
            const $col = $(this).closest('.extra-dinamico');
            const raw = $(this).val();
            const keyNew = slugKey(raw);

            $col.attr('data-key', keyNew);
            $col.find('.valor-extra').attr('name', `extra_${keyNew}`);
            $col.find('.eliminar-extra').attr('data-key', keyNew);
            // (opcional) actualizar la leyenda del pequeño <small> si la agregaste
            $col.find('small.text-muted code').text(`extra_${keyNew}`);
          });

          // SweetAlert para eliminar cualquier campo

        } else {
          $('#extras_update').hide();
          $('#form_campos_normales').show();

          // Tus setters clásicos
          $('#nombre_update').val(dato['nombre']);
          $('#paterno_update').val(dato['paterno']);
          $('#materno_update').val(dato['materno']);
          $('#domicilio_update').val(dato['domicilio']);
          let fecha = (dato['fecha_nacimiento'] !== null && dato['fecha_nacimiento'] !== '') ? dato[
            'fecha_nacimiento'] : ''
          $('#fecha_nacimiento_update').val(fecha);
          $('#telefono_update').val(dato['telefono']);
          $('#nacionalidad_update').val(dato['nacionalidad']);
          $('#civil_update').val(dato['civil']);
          $('#dependientes_update').val(dato['dependientes']);
          $('#escolaridad_update').val(dato['grado_estudios']);
          $('#salud_update').val(dato['salud']);
          $('#enfermedad_update').val(dato['enfermedad']);
          $('#deporte_update').val(dato['deporte']);
          $('#metas_update').val(dato['metas']);
          $('#idiomas_update').val(dato['idiomas']);
          $('#maquinas_update').val(dato['maquinas']);
          $('#software_update').val(dato['software']);
          $('#medio_contacto_update').val(dato['medio_contacto']);
          $('#area_interes_update').val(dato['area_interes']);
          $('#sueldo_update').val(dato['sueldo_deseado']);
          $('#otros_ingresos_update').val(dato['otros_ingresos']);
          $('#viajar_update').val(dato['viajar']);
          $('#trabajar_update').val(dato['trabajar']);
          $('#observaciones_update').val(dato['observaciones']);
        }
      }
    });
    $('#btnBack').css('display', 'block');
    $('#seccionTarjetas').addClass('hidden')
    $('#seccionEditarBolsa').css('display', 'block')
    $('#divFiltros').css('display', 'none')
    $('#btnSubirAspirantes').addClass('isDisabled')
    $('#btnNuevaRequisicion').addClass('isDisabled')
    $('#btnAsignarAspirante').addClass('isDisabled')
  }

  function slugKey(k) {
    return (k || '')
      .trim()
      .replace(/\s+/g, '_') // espacios -> _
      .replace(/[^\w\-]/g, '') // deja solo [A-Za-z0-9_ -]
      ||
      'nuevo';
  }

  function updateApplicant(section) {
    let form = '';
    if (section == 'personal') {
      form = $('#formDatosPersonales').serialize();
      form += '&id_bolsa=' + $('#idBolsa').val();
      form += '&section=' + section;

    }
    if (section == 'salud') {
      form = $('#formSalud').serialize();
      form += '&id_bolsa=' + $('#idBolsa').val();
      form += '&section=' + section;
    }
    if (section == 'conocimiento') {
      form = $('#formConocimientos').serialize();
      form += '&id_bolsa=' + $('#idBolsa').val();
      form += '&section=' + section;
    }
    if (section == 'intereses') {
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
        if (dato.codigo === 1) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: dato.msg,
            showConfirmButton: false,
            timer: 3000
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
  $(document).on('click', '.eliminar-extra', function() {
    const key = $(this).data('key'); // clave del JSON a eliminar

    Swal.fire({
      title: `¿Eliminar el campo "${key}"?`,
      text: "Esta acción no se puede deshacer",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {

        // Quitar del DOM
        $(this).closest('.col-md-4').remove();

        // Quitar del objeto JS para que no se envíe al guardar
        delete camposDinamicos[key];

        Swal.fire(
          'Eliminado',
          'El campo ha sido eliminado',
          'success'
        );
      }
    });
  });
  </script>
  <!-- Funciones Reclutamiento -->
  <script src="<?php echo base_url(); ?>js/reclutamiento/functions.js"></script>
  <script src="<?php echo base_url(); ?>js/reclutamiento/requisicion.js"></script>