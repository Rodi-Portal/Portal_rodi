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
  <?php
      // Permisos del módulo Bolsa de Trabajo (solo se aplican si existen overrides)
      $CAN = [
          'DESCARGAR_PLANTILLA' => user_can('reclutamiento.bolsa_trabajo.descargar_plantilla', true),
          'SUBIR_PLANTILLA'     => user_can('reclutamiento.bolsa_trabajo.subir_plantilla', true),
          'CREAR_REQUISICION'   => user_can('reclutamiento.bolsa_trabajo.crear_requisicion', true),
          'ASIGNAR_ASPIRANTE'   => user_can('reclutamiento.bolsa_trabajo.asignar_aspirante', true),
          'GENERAR_LINK'        => user_can('reclutamiento.bolsa_trabajo.generar_link_registro', true),

          'VER_DETALLES'        => user_can('reclutamiento.bolsa_trabajo.ver_detalles', true),
          'ASIGNARLO_REQ'       => user_can('reclutamiento.bolsa_trabajo.asignarlo_requisicion', true),
          'BLOQUEAR'            => user_can('reclutamiento.bolsa_trabajo.bloquear_aspirante', true),
          'EDITAR'              => user_can('reclutamiento.bolsa_trabajo.editar_aspirante', true),
          'SUBIR_DOCS'          => user_can('reclutamiento.bolsa_trabajo.subir_docs', true),
          'CAMBIAR_STATUS'      => user_can('reclutamiento.bolsa_trabajo.cambiar_status', true),
          'VER_EMPLEOS'         => user_can('reclutamiento.bolsa_trabajo.ver_empleos', true),
          'VER_MOVIMIENTOS'     => user_can('reclutamiento.bolsa_trabajo.ver_movimientos', true),
      ];
  ?>
  <section class="content-header">
    <div class="row align-items-center">
      <div class="col-sm-12 col-md-3 col-lg-3 mb-1 d-flex align-items-center">
        <h2 class="titulo_seccion"><?php echo t('rec_bol_title', 'Bolsa de Trabajo'); ?> </h2>
      </div>

      <div class="col-sm-12 col-md-9 col-lg-9 mb-1 d-flex justify-content-end">
        <div class="btn-group d-none d-md-flex" role="group"
          aria-label="<?php echo t('rec_bol_btn_group_aria', 'Buttons for large screens'); ?>">

          <?php if ($CAN['DESCARGAR_PLANTILLA']): ?>
          <button type="button" id="btnDownloadTemplate" class="btn btn-info btn-icon-split"
            onclick="descargarFormato()">
            <span class="icon text-white-50"><i class="fas fa-download"></i></span>
            <span class="text"><?php echo t('rec_bol_btn_download_template', 'Descargar Plantilla'); ?></span>
          </button>
          <?php endif; ?>

          <?php if ($CAN['SUBIR_PLANTILLA']): ?>
          <button type="button" id="btnUploadCandidates" class="btn btn-success btn-icon-split"
            onclick="openUploadCSV()">
            <span class="icon text-white-50"><i class="fas fa-upload"></i></span>
            <span class="text"><?php echo t('rec_bol_btn_upload_applicants', 'Subir Aspirantes'); ?></span>
          </button>
          <?php endif; ?>



          <?php
              if ($this->session->userdata('idrol') == 4) {
                  $disabled  = 'disabled';
                  $textTitle = 'title="' . htmlspecialchars(t('rec_bol_no_permission_title', 'You do not have permission for this action'), ENT_QUOTES, 'UTF-8') . '"';
              } else {
                  $disabled  = '';
                  $textTitle = '';
              }
          ?>

          <?php if ($CAN['ASIGNAR_ASPIRANTE']): ?>
          <button type="button" id="btnAssignCandidate" class="btn btn-navy btn-icon-split" onclick="openAssignToUser()"
            <?php echo $disabled; ?>>
            <span class="icon text-white-50"><i class="fas fa-user-edit"></i></span>
            <span class="text"><?php echo t('rec_bol_btn_assign_applicant', 'Asignar Aspirante'); ?></span>
          </button>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <?php if (($this->session->userdata('idrol') == 1 || $this->session->userdata('idrol') == 6) && $CAN['GENERAR_LINK']): ?>
    <div class="mb-3 text-right" data-toggle="tooltip" <?php echo $textTitle; ?>>
      <button type="button" id="generarLink" class="btn"
        style="background-color:#FFD700;color:#000;border:none;font-weight:bold;border-radius:8px;box-shadow:0px 2px 6px rgba(0,0,0,0.2);"
        data-toggle="modal" data-target="#modalGenerarLink" <?php echo $disabled; ?>>
        <span class="icon text-white-50"><i class="fas fa-user-edit" style="color:#000;"></i></span>
        <span class="text"><?php echo t('rec_bol_btn_generate_link', 'Generar Link'); ?></span>
      </button>
    </div>
    <?php endif; ?>
  </section>

  <br>

  <div>
    <p><?php echo t(
               'rec_bol_description',
           'En este módulo, puedes gestionar la bolsa de trabajo de manera completa. Se permite cargar aspirantes, asignarlos a requisiciones de empleo, y crear nuevas requisiciones. Además, puedes realizar acciones sobre los aspirantes como bloquear, editar o asignarles nuevas requisiciones, todo de manera ágil y organizada para facilitar el proceso de selección.'
       ); ?></p>
  </div>

  <?php echo $modals; ?>
  <div class="loader" style="display: none;"></div>
  <input type="hidden" id="idRegistro">
  <input type="hidden" id="idBolsa">
  <input type="hidden" id="idAspirante">

  <form id="frmFiltros" method="get" action="<?php echo base_url('reclutamiento/bolsa'); ?>">
    <input type="hidden" name="page" id="page" value="0">
    <div class="row mt-3 mb-5" id="divFiltros">
      <div class="col-sm-12 col-md-3 col-lg-3 mb-1">
        <label for="ordenar"><?php echo t('rec_bol_filter_sort_label', 'Ordenar por:'); ?></label>
        <?php $selectedSort = (string) ($this->input->get('sort') ?? ''); ?>

        <select name="sort" id="ordenar" class="form-control">
          <option value="" <?php echo($selectedSort === '' ? 'selected' : ''); ?>>
            <?php echo t('rec_common_select', 'Seleccionar'); ?>
          </option>
          <option value="ascending" <?php echo($selectedSort === 'ascending' ? 'selected' : ''); ?>>
            <?php echo t('rec_bol_sort_oldest', 'De más antiguo a más reciente'); ?>
          </option>
          <option value="descending" <?php echo($selectedSort === 'descending' ? 'selected' : ''); ?>>
            <?php echo t('rec_bol_sort_newest', 'De más reciente a más antiguo'); ?>
          </option>
        </select>

      </div>


      <div class="col-sm-12 col-md-2 col-lg-2 mb-1">
        <label for="filtrar"><?php echo t('rec_bol_filter_status_label', 'Filtrar por:'); ?></label>
        <?php $selectedFilter = (string) ($this->input->get('filter') ?? 'Todos'); ?>

        <select name="filter" id="filtrar" class="form-control">
          <option value="Todos" <?php echo($selectedFilter === '' || $selectedFilter === 'Todos' ? 'selected' : ''); ?>>
            <?php echo t('rec_common_all', 'Todos'); ?>
          </option>

          <option value="En espera" <?php echo($selectedFilter === 'En espera' ? 'selected' : ''); ?>>
            <?php echo t('rec_bol_status_waiting', 'En espera'); ?>
          </option>

          <option value="En Proceso / Aprobado"
            <?php echo($selectedFilter === 'En Proceso / Aprobado' ? 'selected' : ''); ?>>
            <?php echo t('rec_bol_status_in_process_approved', 'En Proceso / Aprobado'); ?>
          </option>

          <option value="Reutilizable" <?php echo($selectedFilter === 'Reutilizable' ? 'selected' : ''); ?>>
            <?php echo t('rec_bol_status_reusable', 'Reutilizable'); ?>
          </option>

          <option value="Preempleo / Contratado"
            <?php echo($selectedFilter === 'Preempleo / Contratado' ? 'selected' : ''); ?>>
            <?php echo t('rec_bol_status_preemployment_hired', 'Preempleo / Contratado'); ?>
          </option>

          <option value="Aprobado con Acuerdo"
            <?php echo($selectedFilter === 'Aprobado con Acuerdo' ? 'selected' : ''); ?>>
            <?php echo t('rec_bol_status_approved_with_agreement', 'Aprobado con Acuerdo'); ?>
          </option>

          <option value="Bloqueado" <?php echo($selectedFilter === 'Bloqueado' ? 'selected' : ''); ?>>
            <?php echo t('rec_bol_status_blocked', 'Bloqueado'); ?>
          </option>
        </select>

      </div>

      <?php $isDisabled = ($this->session->userdata('idrol') == 4) ? 'isDisabled' : ''; ?>
      <div class="col-sm-12 col-md-2 col-lg-2 mb-1">
        <label for="asignar"><?php echo t('rec_bol_filter_assigned_label', 'Asignado a:'); ?></label>
        <?php $selectedUser = (int) ($this->input->get('user') ?? 0); ?>

        <select name="user" id="asignar"
          class="form-control                                                                                                                       <?php echo $isDisabled ?>">
          <option value="0" <?php echo($selectedUser === 0 ? 'selected' : ''); ?>>
            <?php echo t('rec_common_all', 'Todos'); ?>
          </option>

          <?php if ($usuarios_asignacion) {foreach ($usuarios_asignacion as $row) {?>
          <option value="<?php echo (int) $row->id; ?>"
            <?php echo((int) $row->id === $selectedUser ? 'selected' : ''); ?>>
            <?php echo $row->usuario; ?>
          </option>
          <?php }} else {?>
          <option value="0">
            <?php echo t('rec_bol_no_assigned_user', 'Sin Usuario Asignado'); ?>
          </option>
          <?php }?>
        </select>

      </div>

      <div class="col-sm-12 col-md-2 col-lg-2 mb-1">
        <label
          for="area_interes_search"><?php echo t('rec_bol_filter_interest_area_label', 'Por área de interés:'); ?></label>
        <?php $selectedArea = (string) ($this->input->get('area') ?? ''); ?>

        <select name="area" id="area_interes_search" class="form-control">
          <option value="all" <?php echo(($selectedArea === '' || $selectedArea === 'all') ? 'selected' : ''); ?>>
            <?php echo t('rec_common_all', 'Todos'); ?>
          </option>


          <?php if ($areas_interes) {foreach ($areas_interes as $row) {?>
          <option value="<?php echo $row->area_interes; ?>"
            <?php echo($selectedArea === $row->area_interes ? 'selected' : ''); ?>>
            <?php echo $row->area_interes; ?>
          </option>
          <?php }} else {?>
          <option value="" selected>
            <?php echo t('rec_bol_no_interest_areas', 'No hay áreas de interés registradas'); ?>
          </option>
          <?php }?>
        </select>

      </div>

      <div class="col-sm-12 col-md-3 col-lg-3 mb-1">
        <label for="buscador"><?php echo t('rec_bol_filter_search_label', 'Buscar:'); ?></label>
        <?php $selectedApplicant = (int) ($this->input->get('applicant') ?? 0); ?>

        <select name="applicant" id="buscador" class="form-control">
          <option value="0" <?php echo($selectedApplicant === 0 ? 'selected' : ''); ?>>
            <?php echo t('rec_bol_search_find', 'Encontrar'); ?>
          </option>

          <?php if ($registros_asignacion) {foreach ($registros_asignacion as $row) {?>
          <option value="<?php echo (int) $row->id; ?>"
            <?php echo((int) $row->id === $selectedApplicant ? 'selected' : ''); ?>>
            <?php echo '#' . $row->id . ' ' . $row->nombreCompleto; ?>
          </option>
          <?php }} else {?>
          <option value="0">
            <?php echo t('rec_bol_no_applicants', 'No hay aspirantes registrados'); ?>
          </option>
          <?php }?>
        </select>


      </div>
    </div>
  </form>

  <a href="javascript:void(0)" class="btn btn-primary btn-icon-split btnRegresar" id="btnBack"
    onclick="regresarListado()" style="display: none;">
    <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
    <span class="text"><?php echo t('rec_common_back_to_list', 'Regresar al listado'); ?></span>
  </a>
  <script>
  $(function() {
    $('#ordenar, #filtrar, #asignar, #area_interes_search, #buscador').on('change', function() {
      $('#page').val('0'); // al cambiar filtros, regresamos a la página 1
      $('#frmFiltros').submit();
    });
  });
  </script>


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
            $data = array_merge((array) $r, (array) $extras);

            $normalizadas = [];
            foreach ($data as $k => $v) {
                $normalizadas[strtolower(trim($k))] = $v;
            }

            foreach ($campos as $campo) {
                $campoNormalizado = strtolower(trim($campo));
                if (! empty($normalizadas[$campoNormalizado])) {
                    return $normalizadas[$campoNormalizado];
                }
            }

            return t('rec_bol_not_registered', 'No registrado');
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
                  $telefono       = obtenerDato($r, $extras, 'telefono', t('rec_bol_not_registered', 'No registrado'));

                  $medio_contacto = obtenerDato($r, $extras, 'medio_contacto', t('rec_bol_not_registered', 'No registrado'));
                  $area_interes   = obtenerDato($r, $extras, 'area_interes', t('rec_bol_not_registered', 'No registrado'));

                  $correo = obtenerPrimeroDisponible(
                      $r,
                      $extras,
                      ['E-MAIL E.G.C (email)', 'CORREO BINANCE (email) ', 'correo']
                  );

                  $domicilio = obtenerPrimeroDisponible($r, $extras, ['domicilio', 'direccion', 'estado']);
                  $estado    = obtenerDato($r, $extras, 'estado', '');
                  $direccion = obtenerDato($r, $extras, 'direccion', '');

                  $usuario = (empty($r->usuario)) ? t('rec_bol_unassigned', 'Sin asignar') : $r->usuario;

                  // Normaliza nombre y paterno para envío
                  if (empty($paterno) && ! empty($nombre) && strpos(trim($nombre), ' ') !== false) {
                      $partes   = explode(' ', trim($nombre));
                      $paterno1 = array_pop($partes);
                      $nombre1  = implode(' ', $partes);
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

                  // --- Botón Asignarlo a Requisición según permiso ---
                  $canAssign    = ! empty($CAN['ASIGNARLO_REQ']);
                  $botonProceso = '';

                  if ((int) $r->status === 0) {
                      if ($canAssign) {
                          $botonProceso = '
                    <a href="javascript:void(0)" class="btn btn-success  btn-cuadro mr-1 isDisabled"
                      data-toggle="tooltip" title="' . t('rec_bol_tt_assign_to_req', 'Asignarlo a Requisición') . '">
                      <i class="fas fa-play"></i>
                    </a>';
                      }
                  } else {
                      if ($canAssign) {
                          $botonProceso = '
                    <a href="javascript:void(0)" class="btn btn-success  btn-cuadro mr-1" id="btnIniciar' . $r->id . '"data-toggle="tooltip"
                      title="' . t('rec_bol_tt_assign_to_req', 'Asignarlo a Requisición') . '" onclick="openAddApplicant('
                          . $r->id . ',\'' . addslashes($nombre1) . '\',\'' . addslashes($paterno1) . '\',\'' . addslashes($materno1) . '\',\'' . addslashes($telefono) . '\',\'' . addslashes($medio_contacto) . '\',\'' . addslashes($area_interes) . '\',\'' . addslashes($domicilio1) . '\',\'' . addslashes($correo) . '\')">
                      <i class="fas fa-play-circle"></i>
                    </a>';
                      }
                  }

                  // --- Excepción para status 0: botón deshabilitado y otros cambios ---
                  if ($r->status == 0) {
                      $botonProceso = '
                  <a href="javascript:void(0)" class="btn btn-success  btn-cuadro mr-1 isDisabled"
                    data-toggle="tooltip" title="' . t('rec_bol_tt_assign_to_req', 'Asignarlo a Requisición') . '">
                    <i class="fas fa-play"></i>
                  </a>';

                      $color_estatus       = 'req_negativa';
                      $text_estatus        = t('rec_bol_status_label_blocked_html', 'Estatus: <b>Bloqueado <br></b>');
                      $disabled_bloqueo    = 'isDisabled';
                      $disabled_comentario = 'isDisabled';

                      $desbloquear_aspirante = '
                <a href="javascript:void(0)" class="btn btn-success  btn-cuadro mr-1 unlockButton"
                  style="width:38px;height:38px;"
                  onclick="confirmarDesbloqueo()"
                  data-toggle="tooltip" title="' . t('rec_bol_tt_unlock', 'Desbloquear') . '">
                  <i class="fas fa-lock-open"></i>
                </a>';
                  } elseif ($r->status == 1) {
                      $color_estatus = 'req_espera';
                      $text_estatus  = t('rec_bol_status_label_waiting_html', 'Estatus: <b>En espera <br></b>');
                  } elseif ($r->status == 2) {
                      $color_estatus       = 'req_activa';
                      $text_estatus        = t('rec_bol_status_label_inprocess_html', 'Estatus: <b>En Proceso/Aprobado<br></b>');
                      $disabled_comentario = 'isDisabled';
                  } elseif ($r->status == 3) {
                      $color_estatus       = 'req_preventiva';
                      $text_estatus        = t('rec_bol_status_label_reusable_html', 'Estatus: <b>Reutilizable/Revisar Historial<br></b>');
                      $disabled_comentario = 'isDisabled';
                  } elseif ($r->status == 4) {
                      $color_estatus       = 'req_positivo';
                      $text_estatus        = t('rec_bol_status_label_preemployment_html', 'Estatus: <b>Preempleo/Contratado<br></b>');
                      $disabled_comentario = 'isDisabled';
                  } elseif ($r->status == 5) {
                      $color_estatus       = 'req_aprobado';
                      $text_estatus        = t('rec_bol_status_label_agreement_html', 'Estatus: <b>Aprobado con Acuerdo/<br></b>');
                      $disabled_comentario = 'isDisabled';
                  }

                  $totalApplicants = count($registros);
                  $moveApplicant   = ($totalApplicants > 1) ? '' : 'offset-4';
              ?>
      <div class="col-sm-12 col-md-6 col-lg-4 mb-5<?php echo $moveApplicant ?>">
        <div class="card text-center ">
          <div
            class="card-header                                                                                                                                                                                                                                                                                                                        <?php echo $color_estatus ?>"
            id="req_header<?php echo $r->id; ?>">
            <b><?php echo '#' . $r->id . ' ' . $nombreCompleto; ?></b>
          </div>

          <div class="card-body">
            <?php if ($esTipoExtras): ?>
            <h5 class="card-text">
              <?php echo t('rec_bol_location', 'Ubicación:'); ?> <br>
              <b><?php echo($domicilio ?? $estado . ', ' . $direccion); ?></b>
            </h5>
            <h5 class="card-title">
              <?php echo t('rec_bol_email', 'Correo:'); ?> <br><b><?php echo $correo; ?></b>
            </h5>
            <?php else: ?>
            <h5 class="card-title">
              <?php echo t('rec_bol_interest_area', 'Área de interés:'); ?> <br><b><?php echo $area_interes; ?></b>
            </h5>
            <h5 class="card-text">
              <?php echo t('rec_bol_location', 'Ubicación:'); ?> <br><b><?php echo $domicilio; ?></b>
            </h5>
            <?php endif; ?>

            <h5 class="card-text">
              <?php echo t('rec_bol_phone', 'Teléfono:'); ?> <b><?php echo $telefono; ?></b>
            </h5>

            <div class="alert alert-secondary text-center mt-3"><?php echo $text_estatus ?></div>

            <div class="d-flex justify-content-center align-items-center flex-nowrap">
              <?php if (! empty($CAN['VER_DETALLES'])): ?>
              <a href="javascript:void(0)" class="btn btn-primary btn-cuadro mr-1" data-toggle="tooltip"
                title="<?php echo t('rec_bol_tt_view_details', 'Ver detalles'); ?>"
                onclick="verDetalles(<?php echo (int) $r->id; ?>)">
                <i class="fas fa-info-circle"></i>
              </a>
              <?php endif; ?>

              <?php if (! empty($CAN['VER_EMPLEOS'])): ?>
              <a href="javascript:void(0)" class="btn btn-info btn-cuadro mr-1" data-toggle="tooltip"
                title="<?php echo t('rec_bol_tt_view_jobs', 'Ver empleos'); ?>"
                onclick="verEmpleos(<?php echo $r->id; ?>,'<?php echo addslashes($nombreCompleto) ?>')">
                <i class="fas fa-user-tie"></i>
              </a>
              <?php endif; ?>

              <?php if (! empty($CAN['VER_MOVIMIENTOS'])): ?>
              <a href="javascript:void(0)" class="btn btn-info btn-cuadro mr-1" data-toggle="tooltip"
                title="<?php echo t('rec_bol_tt_movement_history', 'Historial de movimientos'); ?>"
                onclick="verHistorialMovimientos(<?php echo $r->id; ?>,'<?php echo addslashes($nombreCompleto) ?>')">
                <i class="fas fa-history"></i>
              </a>
              <?php endif; ?>

              <!-- Botón proceso -->
              <?php echo $botonProceso; ?>

              <?php if ((int) $r->status === 0): ?>
              <?php if (! empty($CAN['BLOQUEAR'])): ?>
              <a href="javascript:void(0)" class="btn btn-success btn-cuadro mr-1 unlockButton" data-toggle="tooltip"
                title="<?php echo t('rec_bol_tt_unlock_person', 'Desbloquear persona'); ?>"
                onclick="mostrarMensajeConfirmacion('<?php echo t('rec_bol_unlock_applicant_title', 'Desbloquear Aspirante'); ?>','<?php echo addslashes($nombreCompleto) ?>',<?php echo (int) $r->id; ?>)">
                <i class="fas fa-lock-open"></i>
              </a>
              <?php endif; ?>
              <?php else: ?>
              <?php if (! empty($CAN['BLOQUEAR'])): ?>
              <a href="javascript:void(0)" class="btn btn-danger btn-cuadro mr-1" data-toggle="tooltip"
                title="<?php echo t('rec_bol_tt_block_person', 'Bloquear persona'); ?>"
                onclick="mostrarMensajeConfirmacion('<?php echo t('rec_bol_block_process_key', 'bloquear proceso bolsa trabajo'); ?>','<?php echo addslashes($nombreCompleto) ?>',<?php echo (int) $r->id; ?>)">
                <i class="fas fa-ban"></i>
              </a>
              <?php endif; ?>
              <?php endif; ?>

              <?php if (! empty($CAN['EDITAR'])): ?>
              <a href="javascript:void(0)" class="btn btn-warning btn-cuadro mr-1" data-toggle="tooltip"
                title="<?php echo t('rec_bol_tt_edit_applicant', 'Editar aspirante'); ?>"
                onclick="openUpdateApplicant(<?php echo (int) $r->id; ?>,'<?php echo addslashes($nombreCompleto) ?>')">
                <i class="fas fa-edit"></i>
              </a>
              <?php endif; ?>

              <?php if (! empty($CAN['SUBIR_DOCS'])): ?>
              <a href="javascript:void(0)" class="btn btn-secondary btn-cuadro" data-toggle="tooltip"
                title="<?php echo t('rec_bol_tt_upload_docs', 'Subir documentos'); ?>"
                onclick="openSubirDocumentos(<?php echo (int) $r->id; ?>,'<?php echo addslashes($nombreCompleto) ?>')">
                <i class="fas fa-upload"></i>
              </a>
              <?php endif; ?>

              <?php if (! empty($CAN['CAMBIAR_STATUS'])): ?>
              <a href="javascript:void(0)" class="btn btn-status btn-cuadro mr-1" data-toggle="tooltip"
                title="<?php echo t('rec_bol_tt_change_status', 'Cambiar Estatus'); ?>"
                onclick="openModalStatus(<?php echo (int) $r->id; ?>,'<?php echo addslashes($nombreCompleto) ?>')">
                <i class="fas fa-exchange-alt"></i>
              </a>
              <?php endif; ?>
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
              // ✅ Paginación (debajo de las tarjetas)
              if (! empty($pagination)) {
                  echo '<div class="row">';
                  echo '  <div class="col-12">';
                  echo $pagination;
                  echo '  </div>';
                  echo '</div>';
              }
      } else {?>
      <h3 class="text-center">
        <?php echo t('rec_bol_no_applicants_now', 'Actualmente no hay aspirantes registrados.'); ?></h3>
      <?php }?>
    </div>







    <div id="tarjeta_detalle" class="hidden mb-5">
      <div class="alert alert-info text-center" id="nombre_completo"></div>
      <div class="card">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a class="nav-link active" id="link_personales" href="javascript:void(0)">
                <?php echo t('rec_bol_details_tab', 'Detallés'); ?>
              </a>
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
        <h5 class="card-header text-center seccion">
          <?php echo t('rec_bol_personal_data', 'Personal Data'); ?>
        </h5>

        <div class="card-body">
          <form id="formDatosPersonales">
            <div id="form_campos_normales">
              <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                  <label><?php echo t('rec_bol_first_name', 'Nombre(s)'); ?> *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="nombre_update" name="nombre_update"
                      onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                  </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                  <label><?php echo t('rec_bol_last_name_p', 'Apellido paterno'); ?>*</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="paterno_update" name="paterno_update"
                      onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                  </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                  <label><?php echo t('rec_bol_last_name_m', 'Apellido Materno'); ?></label>
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
                  <label><?php echo t('rec_bol_address', 'Dirección'); ?> *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-home"></i></span>
                    </div>
                    <input type="text" class="form-control" id="domicilio_update" name="domicilio_update">
                  </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                  <label><?php echo t('rec_bol_birthdate', 'Fecha de nacimiento'); ?>*</label>
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
                  <label><?php echo t('rec_bol_phone_label', 'Teléfono'); ?> *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id="telefono_update" name="telefono_update" maxlength="16">
                  </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                  <label><?php echo t('rec_bol_nationality', 'Nacionalidad'); ?> *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-globe"></i></span>
                    </div>
                    <input type="text" class="form-control" id="nacionalidad_update" name="nacionalidad_update">
                  </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                  <label><?php echo t('rec_bol_marital_status', 'Estado civil'); ?>*</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <select class="custom-select" id="civil_update" name="civil_update">
                      <option value=""><?php echo t('rec_bol_select', 'Selecciona'); ?></option>
                      <?php if ($civiles) {foreach ($civiles as $row) {?>
                      <option value="<?php echo $row->id ?>"><?php echo $row->nombre ?></option>
                      <?php }} else {?>
                      <option value=""><?php echo t('rec_bol_no_marital_records', 'Sin registros de estado civil..'); ?>
                      </option>
                      <?php }?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-sm-12 col-md-8 col-lg-8 mb-1">
                  <label><?php echo t('rec_bol_dependents', 'Dependientes del solicitante'); ?>*</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                    </div>
                    <input type="text" class="form-control" id="dependientes_update" name="dependientes_update">
                  </div>
                </div>

                <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                  <label><?php echo t('rec_bol_max_education', 'Nivel máximo de estudios.'); ?> *</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <select class="custom-select" id="escolaridad_update" name="escolaridad_update">
                      <option value=""><?php echo t('rec_bol_select', 'Selecciona'); ?></option>
                      <?php if ($grados) {foreach ($grados as $row) {?>
                      <option value="<?php echo $row->id ?>"><?php echo $row->nombre ?></option>
                      <?php }} else {?>
                      <option value="">
                        <?php echo t('rec_bol_no_education_records', 'No se encontraron registros de educación.'); ?>
                      </option>
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
                <i class="fas fa-plus"></i> <?php echo t('rec_bol_add_extra_field', 'Agregar campo extra'); ?>
              </button>
            </div>
            <div class="col-12 col-sm-6 mb-2">
              <button type="button" class="btn btn-success w-100" onclick="updateApplicant('personal')">
                <?php echo t('rec_bol_save_personal_info', 'Guardar información personal'); ?>
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-5" id="form_campos_normales2">
        <h5 class="card-header text-center seccion">
          <?php echo t('rec_bol_health_social_title', 'Salud y vida social'); ?>
        </h5>

        <div class="card-body">
          <form id="formSalud">
            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-6 mb-1">
                <label><?php echo t('rec_bol_health_current', '¿Cuál es tu estado de salud actual?'); ?> **</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                  </div>
                  <input type="text" class="form-control" id="salud_update" name="salud_update">
                </div>
              </div>

              <div class="col-sm-12 col-md-6 col-lg-6 mb-1">
                <label><?php echo t('rec_bol_health_chronic', '¿Padeces alguna enfermedad crónica?'); ?> *</label>
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
                <label><?php echo t('rec_bol_sport', '¿Practicas algún deporte?'); ?> *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                  </div>
                  <input type="text" class="form-control" id="deporte_update" name="deporte_update">
                </div>
              </div>

              <div class="col-sm-12 col-md-6 col-lg-6 mb-1">
                <label><?php echo t('rec_bol_goals', '¿Cuáles son tus metas en la vida?'); ?> *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                  </div>
                  <input type="text" class="form-control" id="metas_update" name="metas_update">
                </div>
              </div>
            </div>
          </form>

          <button type="button" class="btn btn-success btn-block text-lg" onclick="updateApplicant('salud')">
            <?php echo t('rec_bol_save_health_social', 'Guardar información de salud y vida social'); ?>
          </button>
        </div>
      </div>

      <div class="card mb-5" id="form_campos_normales3">
        <h5 class="card-header text-center seccion">
          <?php echo t('rec_bol_skills_title', 'Conocimientos y habilidades'); ?>
        </h5>

        <div class="card-body">
          <form id="formConocimientos">
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label><?php echo t('rec_bol_languages', 'Idiomas que domina'); ?> *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control" id="idiomas_update" name="idiomas_update">
                </div>
              </div>

              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label><?php echo t('rec_bol_office_tools', 'Equipo de oficina o taller que maneja'); ?> *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control" id="maquinas_update" name="maquinas_update">
                </div>
              </div>

              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label><?php echo t('rec_bol_software', 'Software que maneja'); ?> *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="far fa-clock"></i></span>
                  </div>
                  <input type="text" class="form-control" id="software_update" name="software_update">
                </div>
              </div>
            </div>
          </form>

          <button type="button" class="btn btn-success btn-block text-lg" onclick="updateApplicant('conocimiento')">
            <?php echo t('rec_bol_save_skills', 'Guardar Información de conocimientos y habilidades'); ?>
          </button>
        </div>
      </div>

      <div class="card mb-5" id="form_campos_normales4">
        <h5 class="card-header text-center seccion">
          <?php echo t('rec_bol_interests_title', 'Intereses'); ?>
        </h5>

        <div class="card-body">
          <form id="formIntereses">
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label><?php echo t('rec_bol_how_did_you_hear', '¿Cómo te enteraste de TalentSafe?'); ?> *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                  </div>
                  <select class="custom-select" id="medio_contacto_update" name="medio_contacto_update">
                    <option value=""><?php echo t('rec_bol_select', 'Selecciona'); ?></option>
                    <?php if ($medios) {foreach ($medios as $row) {?>
                    <option value="<?php echo $row->nombre ?>"><?php echo $row->nombre ?></option>
                    <?php }} else {?>
                    <option value="">
                      <?php echo t('rec_bol_no_contact_sources', 'No hay registros de fuentes de contacto.'); ?>
                    </option>
                    <?php }?>
                  </select>
                </div>
              </div>

              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label><?php echo t('rec_bol_interest_work_area', '¿En qué área te interesa trabajar?'); ?> *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  </div>
                  <input type="text" class="form-control" id="area_interes_update" name="area_interes_update">
                </div>
              </div>

              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label><?php echo t('rec_bol_desired_salary', '¿Cuál es el salario que deseas recibir?'); ?> *</label>
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
                <label><?php echo t('rec_bol_other_income', '¿Percibes algún ingreso adicional?'); ?> *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                  </div>
                  <input type="text" class="form-control" id="otros_ingresos_update" name="otros_ingresos_update">
                </div>
              </div>

              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label><?php echo t('rec_bol_available_travel', '¿Tienes disponibilidad para viajar?'); ?> *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                  </div>
                  <input type="text" class="form-control" id="viajar_update" name="viajar_update">
                </div>
              </div>

              <div class="col-sm-12 col-md-4 col-lg-4 mb-1">
                <label><?php echo t('rec_bol_when_can_start', '¿En qué fecha puedes comenzar a trabajar?'); ?> *</label>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                  </div>
                  <input type="text" class="form-control" id="trabajar_update" name="trabajar_update">
                </div>
              </div>
            </div>
          </form>

          <button type="button" class="btn btn-success btn-block text-lg" onclick="updateApplicant('intereses')">
            <?php echo t('rec_bol_save_interests', 'Guardar Intereses'); ?>
          </button>
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
      initColoredFilter($(document));
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
        $('#module-content').html('<p>' + window.t('rec_bol_load_error', 'Error al cargar el contenido.') +
          '</p>');
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
          $('#module-content').html('<p>' + window.t('rec_bol_load_error',
              'Error al cargar el contenido.') +
            '</p>');
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
    const T = window.t || function(key, fallback) {
      return fallback || key;
    };

    $.ajax({
      url: '<?php echo base_url('Reclutamiento/getBolsaTrabajoById'); ?>',
      type: 'post',
      data: {
        id: id
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);

        let dato;
        try {
          dato = (typeof res === 'string') ? JSON.parse(res) : res;
        } catch (e) {
          Swal.fire({
            icon: 'error',
            title: T('rec_bol_load_details_error', 'Error al obtener los detalles del aspirante.'),
            html: "<b>" + T('rec_bol_server_response_unexpected', 'Respuesta inesperada del servidor:') +
              "</b><br><pre style='text-align:left'>" + String(res) + "</pre>",
            width: '50em'
          });
          return;
        }

        // Detecta si tiene extras con info
        var extras = {};
        var esTipoExtras = false;
        if (dato['extras'] && dato['extras'] !== "" && dato['extras'] !== null) {
          try {
            extras = (typeof dato['extras'] === "string") ? JSON.parse(dato['extras']) : dato['extras'];
            esTipoExtras = Object.keys(extras).length > 0;
          } catch (e) {
            extras = {};
            esTipoExtras = false;
          }
        }

        $('#btnBack').css('display', 'block');
        $('#divFiltros').css('display', 'none');
        $('#seccionTarjetas').css('display', 'none');

        // --- helpers para extras ---
        function normalizeKeyForI18n(key) {
          return String(key || '')
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '_')
            .replace(/^_+|_+$/g, '');
        }

        function humanizeKey(key) {
          return String(key || '')
            .replace(/_/g, ' ')
            .replace(/\b\w/g, l => l.toUpperCase());
        }

        // ----------- DINÁMICO PARA EXTRAS -------------
        if (esTipoExtras) {
          $('#tarjeta_detalle').hide();
          $('#detalle_extras_dinamico').show();

          let html = `
          <div class="card shadow-sm mt-4">
            <div class="alert alert-info text-center">
              <h5 class="mb-0">
                <i class="fas fa-info-circle"></i>
                <b>${T('rec_bol_details_title', 'Detalles del aspirante')}</b>
                <h3>#${dato['id']} ${dato['nombreCompleto'] || ''}</h3>
              </h5>
            </div>
            <div class="card-body">
              <div class="container-fluid">
                <div class="row">
        `;

          const entries = Object.entries(extras).filter(([key, _]) => key !== '_token');
          const colsPerRow = 3;

          for (let i = 0; i < entries.length; i += colsPerRow) {
            html += `<div class="w-100"></div>`;
            for (let j = i; j < i + colsPerRow && j < entries.length; j++) {
              const [key, valueRaw] = entries[j];

              // etiqueta fallback "bonita"
              let etiquetaFallback = humanizeKey(key);

              // intento de traducción por clave dinámica:
              // ej: rec_bol_extra_correo, rec_bol_extra_direccion, etc.
              const dynKey = 'rec_bol_extra_' + normalizeKeyForI18n(key);
              let etiqueta = T(dynKey, etiquetaFallback);

              let icono = '';
              const k = key.toLowerCase();
              if (k.includes('correo') || k.includes('email')) icono =
                '<i class="fas fa-envelope-open-text text-secondary"></i> ';
              if (k.includes('direccion')) icono = '<i class="fas fa-map-marker-alt text-danger"></i> ';
              if (k.includes('estado')) icono = '<i class="fas fa-map text-success"></i> ';
              if (k.includes('telefono') || k.includes('phone')) icono =
                '<i class="fas fa-phone-alt text-primary"></i> ';

              const value = (valueRaw === null || valueRaw === undefined || String(valueRaw).trim() === '') ?
                T('rec_bol_not_registered', 'No registrado') :
                valueRaw;

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
          return;
        }

        // ------------ VISTA NORMAL (clásica) ---------------
        $('#tarjeta_detalle').show();
        $('#detalle_extras_dinamico').hide().html('');

        const NO = T('rec_bol_not_registered', 'No registrado');

        let f_nacimiento = (!dato['fecha_nacimiento']) ? NO : fechaSimpleAFront(dato['fecha_nacimiento']);
        let edad = (!dato['edad']) ? NO : (dato['edad'] + ' ' + T('rec_bol_years', 'años'));

        $('#nombre_completo').html(
          '<b>' + T('rec_bol_details_title', 'Detalles del aspirante') +
          ' <h3>#' + dato['id'] + ' ' + (dato['nombreCompleto'] || '') + '</h3></b>'
        );

        $('#detalle_area_interes').html(
          T('rec_bol_interest_area', 'Área de interés') + ':<br><b>' + (dato['area_interes'] || NO) + '</b>'
        );

        $('#detalle_f_nacimiento').html('<b>' + T('rec_bol_birthdate', 'Fecha de nacimiento') + ': </b> ' +
          f_nacimiento);
        $('#detalle_edad').html('<b>' + T('rec_bol_age', 'Edad') + ': </b>' + edad);
        $('#detalle_nacionalidad').html('<b>' + T('rec_bol_nationality', 'Nacionalidad') + ':</b> ' + (dato[
          'nacionalidad'] || NO));
        $('#detalle_civil').html('<b>' + T('rec_bol_marital_status', 'Estado civil') + ':</b> ' + (dato[
            'civil'] ||
          NO));
        $('#detalle_dependientes').html('<b>' + T('rec_bol_dependents', 'Dependientes') + ':</b> ' + (dato[
          'dependientes'] || NO));
        $('#detalle_grado_estudios').html('<b>' + T('rec_bol_max_education', 'Grado máximo de estudios') +
          ':</b> ' + (dato['grado_estudios'] || NO));

        $('#detalle_sueldo_deseado').html('<b>' + T('rec_bol_desired_salary', 'Sueldo deseado') + ':</b> ' + (
          dato[
            'sueldo_deseado'] || NO));
        $('#detalle_otros_ingresos').html('<b>' + T('rec_bol_other_income', 'Otros ingresos') + ':</b> ' + (dato[
          'otros_ingresos'] || NO));
        $('#detalle_viajar').html('<b>' + T('rec_bol_can_travel', '¿Disponibilidad para viajar?') + ':</b> ' + (
          dato['viajar'] || NO));
        $('#detalle_trabajar').html('<b>' + T('rec_bol_start_work', '¿Cuándo podría presentarse a trabajar?') +
          ':</b> ' + (dato['trabajar'] || NO));

        $('#detalle_domicilio').html('<b>' + T('rec_bol_address', 'Domicilio') + ':</b><br> ' + (dato[
          'domicilio'] || NO));

        $('#detalle_salud').html('<b>' + T('rec_bol_health_status', 'Estado de salud') + ':</b> ' + (dato[
          'salud'] || NO));
        $('#detalle_enfermedad').html('<b>' + T('rec_bol_chronic_disease', 'Enfermedad crónica') + ':</b> ' + (
          dato[
            'enfermedad'] || NO));
        $('#detalle_deporte').html('<b>' + T('rec_bol_sport', 'Deporte') + ':</b> ' + (dato['deporte'] || NO));
        $('#detalle_metas').html('<b>' + T('rec_bol_goals', 'Metas en la vida') + ':</b> ' + (dato['metas'] ||
          NO));

        $('#detalle_medio_contacto').html('<b>' + T('rec_bol_contact_source', '¿Cómo se enteró de RODI?') +
          ':</b><br> ' + (dato['medio_contacto'] || NO));
        $('#detalle_idiomas').html('<b>' + T('rec_bol_languages', 'Idiomas que domina') + ':</b><br> ' + (dato[
          'idiomas'] || NO));
        $('#detalle_maquinas').html('<b>' + T('rec_bol_machines', 'Máquinas de oficina o taller que maneja') +
          ':</b><br> ' + (dato['maquinas'] || NO));
        $('#detalle_software').html('<b>' + T('rec_bol_software', 'Software que conoce') + ':</b><br> ' + (dato[
          'software'] || NO));

        $('#tarjeta_detalle').css('display', 'block');
      },
      error: function() {
        $('.loader').fadeOut();
        Swal.fire({
          icon: 'error',
          title: T('rec_bol_load_details_error', 'Error al obtener los detalles del aspirante.'),
        });
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
    const T = window.t || function(key, fallback) {
      return fallback || key;
    };

    $("#docIdAspirante").val(idAspirante);
    $("#docNombreAspirante").text(nombreCompleto);

    $("#tablaDocumentos tbody").html(
      '<tr><td colspan="2">' + T('rec_bol_docs_loading', 'Cargando...') + '</td></tr>'
    );

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
        console.log('getDocumentosBolsa ->', resp);

        const docs = Array.isArray(resp) ? resp : (resp && typeof resp === 'object' ? [resp] : []);

        let rows = "";
        if (docs.length > 0) {
          rows = docs.map(function(doc) {
            const nombreMostrar =
              (doc.nombre_personalizado && String(doc.nombre_personalizado).trim() !== '') ?
              doc.nombre_personalizado :
              doc.nombre_archivo;

            const href = '<?php echo base_url('docsBolsa/'); ?>' + encodeURIComponent(doc.nombre_archivo);

            const safeNombreMostrar = (nombreMostrar || '').replace(/'/g, "\\'");
            const safeNombreArchivo = (doc.nombre_archivo || '').replace(/'/g, "\\'");

            return `
            <tr>
              <td>
                <a href="${href}" target="_blank">${nombreMostrar}</a>
              </td>
              <td>
                <button class="btn btn-sm btn-info"
                        title="${T('rec_bol_docs_rename', 'Renombrar')}"
                        onclick="renombrarDoc(${Number(doc.id)}, '${safeNombreMostrar}', '${safeNombreArchivo}')">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger"
                        title="${T('rec_bol_docs_delete', 'Eliminar')}"
                        onclick="eliminarDoc(${Number(doc.id)})">
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>`;
          }).join('');
        } else {
          rows = "<tr><td colspan='2'>" + T('rec_bol_docs_empty', 'No hay documentos') + "</td></tr>";
        }

        $("#tablaDocumentos tbody").html(rows);
      },
      error: function(xhr) {
        $("#tablaDocumentos tbody").html(
          "<tr><td colspan='2'>" + T('rec_bol_docs_load_error', 'Error al cargar documentos') + "</td></tr>"
        );
        console.error(xhr.responseText || xhr);
      }
    });
  }

  function actualizarTarjetaVisualStatus(id, status) {
    const T = window.t || function(key, fallback, repl) {
      let s = fallback || key;
      if (repl && typeof repl === 'object') {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    const st = parseInt(status, 10);

    // textos por status (traducción)
    const statusText = {
      1: T('rec_bol_status_waiting', 'En espera'),
      2: T('rec_bol_status_inprocess', 'En Proceso/Aprobado'),
      3: T('rec_bol_status_reusable', 'Reutilizable'),
      4: T('rec_bol_status_prehire', 'Preempleo/Contratado'),
      5: T('rec_bol_status_agreement', 'Aprobado con Acuerdo')
    };

    // config visual
    const map = {
      1: {
        cls: 'req_espera',
        bg: '#6c757d',
        fg: '#fff'
      },
      2: {
        cls: 'req_activa',
        bg: '#17a2b8',
        fg: '#fff'
      },
      3: {
        cls: 'req_preventiva',
        bg: '#ffc107',
        fg: '#212529'
      },
      4: {
        cls: 'req_positivo',
        bg: '#28a745',
        fg: '#fff'
      },
      5: {
        cls: 'req_aprobado',
        bg: '#fd7e14',
        fg: '#212529'
      }
    };

    const conf = map[st];
    if (!conf) return;

    // 1) Header de la tarjeta
    const $header = $("#req_header" + id);
    if (!$header.length) return;

    $header.removeClass('req_espera req_activa req_preventiva req_positivo req_aprobado req_negativa');
    $header.addClass(conf.cls);

    // fallback inline
    $header.css({
      backgroundColor: conf.bg,
      color: conf.fg
    });

    // 2) Texto del estatus
    const $card = $header.closest('.card');
    const $alertEstatus = $card.find('.alert.alert-secondary').first();

    if ($alertEstatus.length) {
      const label = T('rec_bol_status_label', 'Estatus:');
      const value = statusText[st] || T('rec_bol_status_unknown', 'Sin estatus registrado');
      $alertEstatus.html(label + ' <b>' + value + '<br></b>');
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
    const T = window.t || function(key, fallback, repl) {
      let s = fallback || key;
      if (repl && typeof repl === 'object') {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    const id = $("#statusIdAspirante").val();
    const status = $("#selectStatus").val();

    if (!id || !status) {
      Swal.fire(
        T('rec_bol_swal_attention_title', 'Atención'),
        T('rec_bol_swal_pick_status', 'Debes seleccionar un estatus.'),
        "warning"
      );
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
        if (r && r.ok) {
          Swal.fire({
            icon: "success",
            title: T('rec_bol_swal_ready_title', '¡Listo!'),
            text: T('rec_bol_swal_status_updated', 'Estatus actualizado'),
            timer: 1500,
            showConfirmButton: false
          });

          $("#modalStatus").modal("hide");

          // refresca tarjeta
          const id2 = $("#statusIdAspirante").val();
          const st2 = $("#selectStatus").val();
          actualizarTarjetaVisualStatus(id2, st2);

        } else {
          Swal.fire(
            T('rec_bol_swal_error_title', 'Error'),
            (r && r.msg) ? r.msg : T('rec_bol_swal_status_update_fail', 'No fue posible actualizar'),
            "error"
          );
        }
      },
      error: function() {
        Swal.fire(
          T('rec_bol_swal_error_title', 'Error'),
          T('rec_bol_swal_save_problem', 'Ocurrió un problema al guardar.'),
          "error"
        );
      }
    });
  }


  async function renombrarDoc(idDoc, nombreActual, nombreArchivo) {
    const T = window.t || function(key, fallback, repl) {
      let s = fallback || key;
      if (repl && typeof repl === 'object') {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    const porDefecto = (nombreActual && nombreActual.trim()) ?
      nombreActual.trim() :
      (nombreArchivo ? nombreArchivo.replace(/\.[^/.]+$/, '') : '');

    const {
      value: nombre
    } = await Swal.fire({
      title: T('rec_bol_doc_rename_title', 'Renombrar documento'),
      input: 'text',
      inputValue: porDefecto,
      inputAttributes: {
        autocapitalize: 'off',
        maxlength: 255
      },
      inputAutoFocus: true,
      showCancelButton: true,
      confirmButtonText: T('rec_bol_btn_save', 'Guardar'),
      cancelButtonText: T('rec_bol_btn_cancel', 'Cancelar'),
      showLoaderOnConfirm: true,
      allowOutsideClick: () => !Swal.isLoading(),
      didOpen: () => {
        const input = Swal.getInput();
        if (input) input.focus();
      },
      inputValidator: (value) => {
        if (!value || !value.trim()) return T('rec_bol_doc_name_required', 'Escribe un nombre');
        if (/[/\\:*?"<>|]/.test(value)) return T('rec_bol_doc_invalid_chars',
          'No uses caracteres inválidos: /\\:*?"<>|');
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
          if (!r || !r.ok) throw new Error((r && r.msg) ? r.msg : T('rec_bol_doc_rename_fail',
            'No se pudo renombrar'));
          return r;
        }).catch((err) => {
          Swal.showValidationMessage(err.message || T('rec_bol_doc_rename_error', 'Error al renombrar'));
        });
      }
    });

    if (nombre) {
      Swal.fire({
        icon: 'success',
        title: T('rec_bol_doc_renamed_title', 'Renombrado'),
        timer: 1200,
        showConfirmButton: false
      });

      openSubirDocumentos($("#docIdAspirante").val(), $("#docNombreAspirante").text());
    }
  }


  function eliminarDoc(idDoc) {
    const T = window.t || function(key, fallback, repl) {
      let s = fallback || key;
      if (repl && typeof repl === 'object') {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    Swal.fire({
      title: T('rec_bol_doc_delete_title', '¿Eliminar documento?'),
      text: T('rec_bol_doc_delete_text', 'Esta acción no se puede deshacer'),
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: T('rec_bol_doc_delete_confirm', 'Sí, eliminar'),
      cancelButtonText: T('rec_bol_btn_cancel', 'Cancelar'),
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
          if (!r || !r.ok) throw new Error((r && r.msg) ? r.msg : T('rec_bol_doc_delete_fail',
            'No se pudo eliminar'));
          return r;
        }).catch((err) => {
          Swal.showValidationMessage(err.message || T('rec_bol_doc_delete_error', 'Error al eliminar'));
        });
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          icon: 'success',
          title: T('rec_bol_doc_deleted_title', 'Eliminado'),
          timer: 1200,
          showConfirmButton: false
        });

        openSubirDocumentos($("#docIdAspirante").val(), $("#docNombreAspirante").text());
      }
    });
  }




  // ========= Preview de archivos =========
  $("#inputArchivos").on("change", function() {
    const T = window.t || function(key, fallback, repl) {
      let s = fallback || key;
      if (repl && typeof repl === "object") {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

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
                 value="${_baseName(file.name).replace(/"/g, "&quot;")}"
                 data-index="${idx}"
                 placeholder="${T('rec_bol_docs_placeholder_name_no_ext', 'Nombre sin extensión')}"
                 required>
        </td>
        <td>${_fmtBytes(file.size)}</td>
      </tr>
    `);
    });

    $prev.show();
  });


  // ========= SUBIR múltiples archivos + nombres =========
  $("#formSubirDocs").on("submit", function(e) {
    e.preventDefault();

    const T = window.t || function(key, fallback, repl) {
      let s = fallback || key;
      if (repl && typeof repl === "object") {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    const idAspirante = $("#docIdAspirante").val();
    const input = document.getElementById("inputArchivos");
    const files = Array.from(input.files || []);

    if (!files.length) {
      Swal.fire(
        T("rec_bol_swal_attention_title", "Atención"),
        T("rec_bol_docs_pick_at_least_one", "Selecciona al menos un archivo."),
        "warning"
      );
      return;
    }

    const nombresInputs = Array.from(document.querySelectorAll("#previewArchivos .nombre-personalizado"));

    if (nombresInputs.length !== files.length) {
      Swal.fire(
        T("rec_bol_swal_error_title", "Error"),
        T("rec_bol_docs_read_names_problem", "Ocurrió un problema al leer los nombres personalizados."),
        "error"
      );
      return;
    }

    // valida nombres vacíos
    for (let i = 0; i < nombresInputs.length; i++) {
      const v = (nombresInputs[i].value || "").trim();
      if (!v) {
        nombresInputs[i].focus();
        Swal.fire(
          T("rec_bol_swal_attention_title", "Atención"),
          T("rec_bol_docs_name_required_each", "Define un nombre para cada archivo."),
          "warning"
        );
        return;
      }
    }

    const fd = new FormData();
    fd.append("id_aspirante", idAspirante);

    files.forEach((file) => fd.append("archivos[]", file, file.name));
    nombresInputs.forEach((inp) => fd.append("nombres[]", (inp.value || "").trim()));

    // opcional: UI loading
    const $btn = $("#btnSubirDocs");
    if ($btn.length) $btn.prop("disabled", true).text(T("rec_bol_docs_uploading", "Subiendo..."));

    $.ajax({
        url: "<?php echo base_url('Reclutamiento/subirDocumentosBolsa'); ?>",
        type: "POST",
        data: fd,
        processData: false,
        contentType: false,
        dataType: "json"
      })
      .done(function(resp) {
        if (resp && resp.ok) {
          Swal.fire({
            icon: "success",
            title: T("rec_bol_docs_uploaded_title", "¡Listo!"),
            text: resp.msg || T("rec_bol_docs_uploaded_text", "Documentos subidos correctamente."),
            timer: 1400,
            showConfirmButton: false
          });

          // refresca lista
          openSubirDocumentos(idAspirante, $("#docNombreAspirante").text());

          // limpia preview
          $("#inputArchivos").val("");
          $("#previewArchivos tbody").empty();
          $("#previewArchivos").hide();
        } else {
          Swal.fire(
            T("rec_bol_swal_error_title", "Error"),
            (resp && resp.msg) ? resp.msg : T("rec_bol_docs_upload_fail",
              "No se pudieron subir los documentos."),
            "error"
          );
        }
      })
      .fail(function(xhr) {
        Swal.fire(
          T("rec_bol_swal_error_title", "Error"),
          T("rec_bol_docs_upload_server_error", "Error al subir documentos."),
          "error"
        );
        console.error(xhr.responseText || xhr);
      })
      .always(function() {
        if ($btn.length) $btn.prop("disabled", false).text(T("rec_bol_docs_upload_btn", "Subir"));
      });
  });


  // ========= Ver empleos =========
  function verEmpleos(id, nombreCompleto) {
    const T = window.t || function(key, fallback, repl) {
      let s = fallback || key;
      if (repl && typeof repl === "object") {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    $(".nombreRegistro").text(nombreCompleto);
    $("#div_historial_empleos").empty();

    $.ajax({
      url: "<?php echo base_url('Reclutamiento/getEmpleosByIdBolsaTrabajo'); ?>",
      type: "post",
      data: {
        id: id
      },
      success: function(res) {
        var salida = '<table class="table table-striped" style="font-size: 14px">';
        salida += '<tr style="background: gray;color:white;">';
        salida += `<th>${T('rec_bol_jobs_th_company', 'Empresa')}</th>`;
        salida += `<th>${T('rec_bol_jobs_th_period', 'Periodo')}</th>`;
        salida += `<th>${T('rec_bol_jobs_th_salary', 'Sueldo')}</th>`;
        salida += `<th>${T('rec_bol_jobs_th_position', 'Puesto')}</th>`;
        salida += `<th>${T('rec_bol_jobs_th_separation', 'Causa separación')}</th>`;
        salida += `<th>${T('rec_bol_jobs_th_phone', 'Teléfono')}</th>`;
        salida += "</tr>";

        if (res != 0) {
          var dato = JSON.parse(res);
          for (var i = 0; i < dato.length; i++) {
            salida += "<tr>";
            salida += "<td>" + (dato[i]["empresa"] || "") + "</td>";
            salida += "<td>" + (dato[i]["periodo"] || "") + "</td>";
            salida += "<td>" + (dato[i]["sueldo"] || "") + "</td>";
            salida += "<td>" + (dato[i]["puesto"] || "") + "</td>";
            salida += "<td>" + (dato[i]["causa_separacion"] || "") + "</td>";
            salida += "<td>" + (dato[i]["telefono"] || "") + "</td>";
            salida += "</tr>";
          }
        } else {
          salida += "<tr>";
          salida +=
            `<td colspan="6" class="text-center"><h5>${T('rec_bol_jobs_none', 'Sin empleos registrados')}</h5></td>`;
          salida += "</tr>";
        }

        salida += "</table>";
        $("#div_historial_empleos").html(salida);
        $("#empleosModal").modal("show");
      },
      error: function() {
        Swal.fire(
          T("rec_bol_swal_error_title", "Error"),
          T("rec_bol_jobs_load_error", "No se pudieron cargar los empleos."),
          "error"
        );
      }
    });
  }


  function openAddApplicant(id, nombre, paterno, materno, telefono, medio, area_interes, domicilio, correo) {
    const T = window.t || function(key, fallback, repl) {
      let s = fallback || key;
      if (repl && typeof repl === "object") {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

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

        // res puede venir string JSON o ya parseado
        let arr = [];
        try {
          arr = (typeof res === 'string') ? JSON.parse(res) : res;
        } catch (e) {
          arr = [];
        }

        if (Array.isArray(arr) && arr.length > 0) {
          for (let i = 0; i < arr.length; i++) {
            let optionText =
              '#' + arr[i]['idReq'] + ' ' +
              (arr[i]['nombre_cliente'] || '') + ' - ' +
              (arr[i]['puesto'] || '') + ' - ' +
              T('rec_bol_add_vacancies', 'Vacantes: ') + (arr[i]['numero_vacantes'] || 0);

            $('#req_asignada').append($('<option>', {
              value: arr[i]['idReq'],
              text: optionText
            }));
          }
        } else {
          Swal.fire({
            icon: 'info',
            title: T('rec_bol_swal_no_orders_title', 'Sin requisiciones'),
            html: T('rec_bol_swal_no_orders_text', 'No hay requisiciones a consultar.'),
            width: '50em',
            confirmButtonText: T('rec_bol_btn_close', 'Cerrar')
          });
        }
      },
      error: function() {
        $('.loader').fadeOut();
        Swal.fire({
          icon: 'error',
          title: T('rec_bol_swal_error_title', 'Error'),
          text: T('rec_bol_swal_load_orders_error', 'No se pudieron cargar las requisiciones.'),
          confirmButtonText: T('rec_bol_btn_close', 'Cerrar')
        });
      }
    });

    $("#nuevoAspiranteModal").modal('show');
  }


  function addApplicant() {
    const T = window.t || function(key, fallback, repl) {
      let s = fallback || key;
      if (repl && typeof repl === "object") {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    let id_bolsa = $('#idBolsa').val();

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

        var data = {};
        try {
          data = (typeof res === 'string') ? JSON.parse(res) : res;
        } catch (e) {
          data = {
            codigo: 0,
            msg: T('rec_bol_unexpected_response', 'Respuesta inesperada del servidor.')
          };
        }

        if (Number(data.codigo) === 1) {
          $("#nuevoAspiranteModal").modal('hide');

          Swal.fire({
            position: 'center',
            icon: 'success',
            title: data.msg || T('rec_bol_add_success', 'Aspirante asignado correctamente.'),
            showConfirmButton: false,
            timer: 2500
          });

          setTimeout(function() {
            location.reload();
          }, 2500);
        } else {
          Swal.fire({
            icon: 'warning',
            title: T('rec_bol_required_empty_title', 'Campos obligatorios vacíos'),
            html: (data.msg || T('rec_bol_required_empty_text',
              'Verifica la información e inténtalo de nuevo.')),
            width: '50em',
            confirmButtonText: T('rec_bol_btn_close', 'Cerrar')
          });
        }
      },
      error: function() {
        $('.loader').fadeOut();
        Swal.fire({
          icon: 'error',
          title: T('rec_bol_swal_error_title', 'Error'),
          text: T('rec_bol_add_error', 'Ocurrió un problema al guardar.'),
          confirmButtonText: T('rec_bol_btn_close', 'Cerrar')
        });
      }
    });
  }


  function verHistorialMovimientos(id, nombreCompleto) {
    const T = window.t || function(key, fallback, repl) {
      let s = fallback || key;
      if (repl && typeof repl === "object") {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

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
        salida += '<th>' + T('rec_bol_hist_th_req', 'Requisición') + '</th>';
        salida += '<th>' + T('rec_bol_hist_th_date', 'Fecha') + '</th>';
        salida += '<th>' + T('rec_bol_hist_th_status', 'Estatus') + '</th>';
        salida += '<th>' + T('rec_bol_hist_th_comment', 'Comentario / Descripción / Fecha y lugar') + '</th>';
        salida += '</tr>';

        if (res != 0) {
          var dato = (typeof res === 'string') ? JSON.parse(res) : res;

          for (var i = 0; i < dato.length; i++) {
            var aux = (dato[i]['creacion'] || '').split(' ');
            var f = (aux[0] || '').split('-');
            var fecha = (f.length === 3) ? (f[2] + '/' + f[1] + '/' + f[0]) : '';

            salida += "<tr>";
            salida += '<td>#' + (dato[i]['id_requisicion'] || '') + ' ' + (dato[i]['nombre'] || '') + '</td>';
            salida += '<td>' + fecha + '</td>';
            salida += '<td>' + (dato[i]['accion'] || '') + '</td>';
            salida += '<td>' + (dato[i]['descripcion'] || '') + '</td>';
            salida += "</tr>";
          }
        } else {
          salida += "<tr>";
          salida += '<td colspan="4" class="text-center"><h5>' + T('rec_bol_hist_none', 'Sin movimientos') +
            '</h5></td>';
          salida += "</tr>";
        }

        salida += "</table>";
        $('#div_historial_aspirante').html(salida);
        $("#historialModal").modal('show');
      },
      error: function() {
        Swal.fire(
          T('rec_bol_swal_error_title', 'Error'),
          T('rec_bol_hist_load_error', 'No se pudo cargar el historial.'),
          'error'
        );
      }
    });
  }


  function mostrarMensajeConfirmacion(accion, valor1, valor2) {
    const T = window.t || function(key, fallback, repl) {
      let s = fallback || key;
      if (repl && typeof repl === "object") {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    $('#idBolsa').val(valor2);

    const isBloquear = (accion === "bloquear proceso bolsa trabajo");

    $('#titulo_mensaje').text(
      isBloquear ?
      T('rec_bol_block_title', 'Bloquear proceso') :
      T('rec_bol_unblock_title', 'Desbloquear Proceso')
    );

    $('#mensaje').html(
      isBloquear ?
      T('rec_bol_block_confirm_html', '¿Desea bloquear a <b>{name}</b> de todo proceso de reclutamiento?', {
        '{name}': valor1
      }) :
      T('rec_bol_unblock_confirm_html', '¿Desea desbloquear a <b>{name}</b>?', {
        '{name}': valor1
      })
    );

    $('#campos_mensaje').html('');

    if (isBloquear) {
      $('#campos_mensaje').html(
        '<div class="row">' +
        '<div class="col-12">' +
        '<label>' + T('rec_bol_block_reason_label', 'Motivo de bloqueo *') + '</label>' +
        '<textarea class="form-control" rows="3" id="mensaje_comentario" name="mensaje_comentario"></textarea>' +
        '</div>' +
        '</div>'
      );
      $('#btnConfirmar').attr("onclick", "cambiarStatusBolsaTrabajo(" + valor2 + ", 'bloquear')");
    } else {
      $('#btnConfirmar').attr("onclick", "cambiarStatusBolsaTrabajo(" + valor2 + ", 'desbloquear')");
    }

    $('#mensajeModal').modal('show');
  }


  function cambiarStatusBolsaTrabajo(id_bolsa, action) {
    const T = window.t || function(key, fallback, repl) {
      let s = fallback || key;
      if (repl && typeof repl === "object") {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    let comentario = '';
    if (action === 'desbloquear') {
      comentario = 'x';
    } else {
      comentario = ($('#mensaje_comentario').val() || '').trim();
    }

    $.ajax({
      url: '<?php echo base_url('Reclutamiento/cambiarStatusBolsaTrabajo'); ?>',
      type: 'post',
      data: {
        'id_bolsa': id_bolsa,
        'comentario': comentario,
        'accion': action
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);

        let data = {};
        try {
          data = (typeof res === 'string') ? JSON.parse(res) : res;
        } catch (e) {
          data = {
            codigo: 0,
            msg: T('rec_bol_unexpected_response', 'Respuesta inesperada del servidor.')
          };
        }

        if (Number(data.codigo) === 1) {
          $("#mensajeModal").modal('hide');

          Swal.fire({
            position: 'center',
            icon: 'success',
            title: data.msg || T('rec_bol_status_updated', 'Estatus actualizado'),
            showConfirmButton: false,
            timer: 3000
          });

          setTimeout(function() {
            location.reload();
          }, 3000);
        } else {
          Swal.fire({
            icon: 'error',
            title: T('rec_bol_error_try_again_title', 'Hubo un problema, inténtalo de nuevo'),
            html: data.msg || T('rec_bol_error_try_again_text', 'No fue posible completar la acción.'),
            width: '50em',
            confirmButtonText: T('rec_bol_btn_close', 'Cerrar')
          });
        }
      },
      error: function() {
        $('.loader').fadeOut();
        Swal.fire({
          icon: 'error',
          title: T('rec_bol_swal_error_title', 'Error'),
          text: T('rec_bol_status_change_error', 'Ocurrió un problema al cambiar el estatus.'),
          confirmButtonText: T('rec_bol_btn_close', 'Cerrar')
        });
      }
    });
  }


  function verHistorialBolsaTrabajo(id, nombreCompleto) {
    const T = window.t || function(key, fallback, repl) {
      let s = fallback || key;
      if (repl && typeof repl === "object") {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

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
        salida += '<th>' + T('rec_bol_hist_th_date', 'Fecha') + '</th>';
        salida += '<th>' + T('rec_bol_hist_th_user', 'Usuario') + '</th>';
        salida += '<th>' + T('rec_bol_hist_th_comment_status', 'Comentario / Estatus') + '</th>';
        salida += '</tr>';

        if (res != 0) {
          var dato = (typeof res === 'string') ? JSON.parse(res) : res;

          for (var i = 0; i < dato.length; i++) {
            var aux = (dato[i]['creacion'] || '').split(' ');
            var f = (aux[0] || '').split('-');
            var fecha = (f.length === 3) ? (f[2] + '/' + f[1] + '/' + f[0]) : '';

            salida += "<tr>";
            salida += '<td>' + fecha + '</td>';
            salida += '<td>' + (dato[i]['usuario'] || '') + '</td>';
            salida += '<td>' + (dato[i]['comentario'] || '') + '</td>';
            salida += "</tr>";
          }
        } else {
          salida += "<tr>";
          salida += '<td colspan="4" class="text-center"><h5>' + T('rec_bol_hist_none_comments',
            'Sin comentarios') + '</h5></td>';
          salida += "</tr>";
        }

        salida += "</table>";
        $('#div_historial_comentario').html(salida);
        $("#historialComentariosModal").modal('show');
      },
      error: function() {
        Swal.fire(
          T('rec_bol_swal_error_title', 'Error'),
          T('rec_bol_hist_comments_load_error', 'No se pudo cargar el historial de comentarios.'),
          'error'
        );
      }
    });
  }


  $('#modalGenerarLink').off('show.bs.modal').on('show.bs.modal', function() {
    const T = window.t || function(key, fallback, repl) {
      let s = (fallback || key);
      if (repl && typeof repl === 'object') {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    // ✅ variable segura (evita "url is not defined")
    let url = '';

    // Limpia UI
    setLinkGenerado('');
    $('#linkGeneradoPreview').val(T('rec_bol_link_loading', 'Cargando...'));
    $('#qrGenerado').html('');
    setQrButtons('');

    $.ajax({
      url: '<?php echo base_url("Reclutamiento/verificar_archivos_existentes"); ?>',
      type: 'POST',
      dataType: 'json',
      success: function(response) {

        // Link generado
        url = (response && response.link) ? response.link : '';

        if (url) {
          setLinkGenerado(url);
        } else {
          setLinkGenerado('');
          $('#linkGeneradoPreview').val(T('rec_bol_link_not_generated', 'Aún no se ha generado un link.'));
        }

        // QR generado
        if (response && response.qr) {
          $('#qrGenerado').html(
            `<img id="imgQrGenerado" src="${response.qr}" alt="${T('rec_bol_qr_alt','QR')}" style="max-width: 150px;">`
          );
          setQrButtons(response.qr);
        } else {
          $('#qrGenerado').html('');
          setQrButtons('');
        }
      },
      error: function() {
        setLinkGenerado('');
        $('#linkGeneradoPreview').val(T('rec_bol_link_fetch_error', 'Error al obtener datos del portal.'));
        $('#qrGenerado').html('');
        setQrButtons('');
      }
    });
  });


  function setQrButtons(qrSrc) {
    // qrSrc puede ser: URL (https://...) o data:image/png;base64,...
    if (qrSrc) {
      $('#btnCopyQr').prop('disabled', false).data('qr', qrSrc);

      $('#btnDownloadQr')
        .removeClass('disabled')
        .attr('href', qrSrc);
    } else {
      $('#btnCopyQr').prop('disabled', true).removeData('qr');

      $('#btnDownloadQr')
        .addClass('disabled')
        .attr('href', '#');
    }
  }

  $(document).on('click', '#btnCopyQr', function() {
    const qrSrc = $(this).data('qr');
    if (!qrSrc) return;

    // Portapapeles moderno
    if (navigator.clipboard && window.isSecureContext) {
      navigator.clipboard.writeText(qrSrc).then(function() {
        Swal.fire({
          icon: 'success',
          title: (window.t ? window.t('rec_common_copied', 'Copiado') : 'Copiado'),
          timer: 1200,
          showConfirmButton: false
        });
      }).catch(function() {
        Swal.fire({
          icon: 'error',
          title: (window.t ? window.t('rec_common_problem_title', 'Hubo un problema') : 'Hubo un problema')
        });
      });
      return;
    }

    // Fallback
    const $tmp = $('<textarea>').val(qrSrc).appendTo('body').select();
    document.execCommand('copy');
    $tmp.remove();
    Swal.fire({
      icon: 'success',
      title: (window.t ? window.t('rec_common_copied', 'Copiado') : 'Copiado'),
      timer: 1200,
      showConfirmButton: false
    });
  });




  // Botón para generar o actualizar link y QR
  $('#btnGenerarLink').on('click', function() {
    const T = window.t || function(key, fallback, repl) {
      let s = (fallback || key);
      if (repl && typeof repl === 'object') {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    Swal.fire({
      icon: 'warning',
      title: T('rec_bol_genlink_confirm_title', '¿Estás seguro?'),
      text: T('rec_bol_genlink_confirm_text',
        'El link y el código QR anteriores quedarán obsoletos. ¿Deseas continuar?'),
      showCancelButton: true,
      confirmButtonText: T('rec_bol_btn_yes_continue', 'Sí, continuar'),
      cancelButtonText: T('rec_bol_btn_cancel', 'Cancelar'),
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?php echo base_url("Reclutamiento/generar_o_mostrar_link") ?>',
          type: 'POST',
          dataType: 'json',
          success: function(response) {
            if (response.link) {
              setLinkGenerado(response.link);
              $('#qrGenerado').html(
                `<img id="imgQrGenerado" src="${response.qr}" alt="${T('rec_bol_qr_alt','QR')}" style="max-width: 150px;">`
              );
              setQrButtons(response.qr || '');
              Swal.fire({
                icon: 'success',
                title: T('rec_bol_genlink_success_title', '¡Éxito!'),
                text: response.mensaje || T('rec_bol_genlink_success_fallback',
                  'Link generado/actualizado correctamente.'),
              }).then(() => {
                $('#modalGenerarLink').modal('show');
              });

            } else if (response.error) {
              Swal.fire({
                icon: 'error',
                title: T('rec_bol_swal_error_title', 'Error'),
                text: response.error,
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: T('rec_bol_swal_error_title', 'Error'),
                text: T('rec_bol_genlink_error_fallback', 'No se pudo generar el link.'),
              });
            }
          },
          error: function() {
            Swal.fire({
              icon: 'error',
              title: T('rec_bol_swal_error_title', 'Error'),
              text: T('rec_bol_genlink_error_generation', 'Error en la generación del link.'),
            });
          }
        });
      }
    });
  });


  function nuevaRequisicion() {
    $('#nuevaRequisicionModal').modal('show');
  }


  //* Asignación de Usuario a registro de Bolsa de Trabajo
  function openAssignToUser() {
    const T = window.t || function(key, fallback, repl) {
      let s = (fallback || key);
      if (repl && typeof repl === 'object') {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    let url = '<?php echo base_url('Reclutamiento/assignToUser'); ?>';

    $('#titulo_asignarUsuarioModal').text(
      T('rec_bol_assign_modal_title', 'Asignar registro de bolsa de trabajo a un reclutador')
    );

    $('label[for="asignar_usuario"]').text(
      T('rec_bol_assign_label_user', 'Reclutador *')
    );

    $('label[for="asignar_registro"]').text(
      T('rec_bol_assign_label_record', 'Persona en bolsa de trabajo *')
    );

    $('#asignar_usuario').removeAttr("multiple");

    // Inicializar Select2
    $('#asignar_usuario').select2({
      placeholder: T('rec_bol_assign_select_recruiter_placeholder', 'Selecciona un reclutador'),
      allowClear: false,
      width: '100%'
    });

    $('#asignar_usuario').attr("name", "asignar_usuario");
    $('#btnAsignar').attr("onclick", "assignToUser(\"" + url + "\",'bolsa_trabajo')");
    $('#asignarUsuarioModal').modal('show');
  }


  //* Carga de aspirantes masivos de acuerdo a CSV
  function descargarFormato() {
    const T = window.t || function(key, fallback, repl) {
      let s = (fallback || key);
      if (repl && typeof repl === 'object') {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    // Ruta del archivo a descargar
    let fileUrl = '<?php echo base_url() . '_docs/CargarAspirantes.csv'; ?>';

    fetch(fileUrl)
      .then(response => {
        if (!response.ok) {
          throw new Error('download_failed');
        }
        return response.blob();
      })
      .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'CargarAspirantes.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
      })
      .catch(error => {
        console.error('Error:', error);
        alert(T('rec_bol_download_error', 'Error al descargar el archivo'));
      });
  }

  function openUploadCSV() {
    const T = window.t || function(key, fallback, repl) {
      let s = (fallback || key);
      if (repl && typeof repl === 'object') {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    let url = '<?php echo base_url('Reclutamiento/uploadCSV'); ?>';
    $('#subirCSVModal .modal-title').text(T('rec_bol_csv_modal_title', 'Subir aspirantes masivos por CSV'));
    $('#subirCSVModal #label').html(T('rec_bol_csv_modal_label', 'Selecciona el archivo <code>.csv</code>'));
    $('#btnSubir').attr("onclick", "uploadCSV(\"" + url + "\")");
    $('#subirCSVModal').modal('show');
  }

  function openUpdateApplicant(id, nombre) {
    const T = window.t || function(key, fallback, repl) {
      let s = (fallback || key);
      if (repl && typeof repl === 'object') {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    $('#idBolsa').val(id);

    // Antes: "Edición del aspirante ..."
    $('#nombreBolsa').html(
      '<b>' + T('rec_bol_edit_title', 'Edición del aspirante') +
      ' <h3>#' + id + ' ' + nombre + '</h3></b>'
    );

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
          if (paterno) nombre = nombre + ' ' + paterno;

          const camposNormales = {
            nombre: nombre,
            telefono: dato['telefono'] || extras['telefono'] || "",
            fecha_nacimiento: dato['fecha_nacimiento'] || extras['fecha_nacimiento'] || ""
          };

          const camposDinamicos = {
            ...camposNormales
          };

          Object.keys(extras).forEach(function(key) {
            if (key === '_token') return;
            if (!camposDinamicos.hasOwnProperty(key)) camposDinamicos[key] = extras[key];
          });

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

          // Contador para nuevos extras
          let contadorExtras = 0;

          $('#agregar_extra').off('click').on('click', function() {
            contadorExtras++;
            const keyDefault = `nuevo_${contadorExtras}`;
            const keySlug = slugKey(keyDefault);

            const htmlNuevo = `
            <div class="col-md-4 col-sm-12 mb-3 extra-dinamico" data-key="${keySlug}">
              <div class="card shadow-sm h-100">
                <div class="card-body d-flex flex-column">

                  <label class="mb-1 font-weight-bold">${T('rec_bol_extra_field_name', 'Nombre del campo')}</label>
                  <input
                    type="text"
                    class="form-control llave-extra"
                    placeholder="${T('rec_bol_extra_field_name_ph', 'Escribe el nombre del campo (sin espacios). Ej.: curp, rfc, talla_playera, linkedin')}"
                    value="">

                  <label class="mb-1 font-weight-bold mt-3">${T('rec_bol_extra_field_value', 'Contenido del campo')}</label>
                  <div class="d-flex align-items-start">
                    <input
                      type="text"
                      class="form-control valor-extra"
                      name="extra_${keySlug}"
                      placeholder="${T('rec_bol_extra_field_value_ph', 'Escribe el contenido/valor. Ej.: ABCD001122HDFLRS05 / M / https://linkedin.com/in/usuario')}"
                      value="">
                    <button
                      type="button"
                      class="btn btn-sm btn-danger ml-2 eliminar-extra"
                      data-key="${keySlug}"
                      title="${T('rec_bol_extra_delete_title', 'Eliminar este campo')}"
                      aria-label="${T('rec_bol_extra_delete_title', 'Eliminar este campo')}">
                      <i class="fas fa-trash"></i>
                    </button>
                  </div>

                </div>
              </div>
            </div>`;

            $('#extras_update .row').append(htmlNuevo);
          });

          $(document).off('input.llaveExtra').on('input.llaveExtra', '.llave-extra', function() {
            const $col = $(this).closest('.extra-dinamico');
            const raw = $(this).val();
            const keyNew = slugKey(raw);

            $col.attr('data-key', keyNew);
            $col.find('.valor-extra').attr('name', `extra_${keyNew}`);
            $col.find('.eliminar-extra').attr('data-key', keyNew);
          });

        } else {
          $('#extras_update').hide();
          $('#form_campos_normales').show();

          // Setters clásicos
          $('#nombre_update').val(dato['nombre']);
          $('#paterno_update').val(dato['paterno']);
          $('#materno_update').val(dato['materno']);
          $('#domicilio_update').val(dato['domicilio']);
          let fecha = (dato['fecha_nacimiento'] !== null && dato['fecha_nacimiento'] !== '') ? dato[
            'fecha_nacimiento'] : '';
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
    $('#seccionTarjetas').addClass('hidden');
    $('#seccionEditarBolsa').css('display', 'block');
    $('#divFiltros').css('display', 'none');
    $('#btnSubirAspirantes').addClass('isDisabled');
    $('#btnNuevaRequisicion').addClass('isDisabled');
    $('#btnAsignarAspirante').addClass('isDisabled');
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
    const T = window.t || function(key, fallback, repl) {
      let s = (fallback || key);
      if (repl && typeof repl === 'object') {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

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
            title: dato.msg, // viene del backend ya traducido en tu flow
            showConfirmButton: false,
            timer: 3000
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: T('rec_bol_error_title', 'Hubo un problema'),
            html: dato.msg, // viene del backend
            width: '50em',
            confirmButtonText: T('rec_bol_btn_close', 'Cerrar')
          });
        }
      },
      error: function() {
        Swal.fire({
          icon: 'error',
          title: T('rec_bol_error_title', 'Hubo un problema'),
          text: T('rec_bol_save_error_generic', 'Ocurrió un problema al guardar.'),
          confirmButtonText: T('rec_bol_btn_close', 'Cerrar')
        });
      }
    });
  }

  $(document).on('click', '.eliminar-extra', function() {
    const T = window.t || function(key, fallback, repl) {
      let s = (fallback || key);
      if (repl && typeof repl === 'object') {
        for (var k in repl)
          if (Object.prototype.hasOwnProperty.call(repl, k)) s = s.split(k).join(repl[k]);
      }
      return s;
    };

    const key = $(this).data('key');

    Swal.fire({
      title: T('rec_bol_extra_delete_confirm_title', '¿Eliminar el campo "{key}"?', {
        '{key}': key
      }),
      text: T('rec_bol_extra_delete_confirm_text', 'Esta acción no se puede deshacer'),
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: T('rec_bol_btn_yes_delete', 'Sí, eliminar'),
      cancelButtonText: T('rec_bol_btn_cancel', 'Cancelar')
    }).then((result) => {
      if (result.isConfirmed) {
        // Quitar del DOM
        $(this).closest('.col-md-4').remove();

        // ⚠️ Importante: esto solo funciona si camposDinamicos existe en este scope global
        if (typeof camposDinamicos !== 'undefined' && camposDinamicos && typeof camposDinamicos === 'object') {
          delete camposDinamicos[key];
        }

        Swal.fire(
          T('rec_bol_deleted_title', 'Eliminado'),
          T('rec_bol_extra_deleted_ok', 'El campo ha sido eliminado'),
          'success'
        );
      }
    });
  });
  </script>
  <!-- Funciones Reclutamiento -->
  <script src="<?php echo base_url(); ?>js/reclutamiento/functions.js"></script>
  <script src="<?php echo base_url(); ?>js/reclutamiento/requisicion.js"></script>
  <style>
  /* Estilo base para la fila */
  .select2-results__option.status-row {
    padding: 6px 10px;
    text-transform: uppercase;
    /* Mayúsculas */
    font-weight: 600;
  }

  /* Colores por estado */
  .select2-results__option.status-all {
    background-color: #e9ecef;
    color: #212529;
  }

  .select2-results__option.status-espera {
    background-color: #6c757d;
    color: #ffffff;
  }

  .select2-results__option.status-proceso {
    background-color: #17a2b8;
    color: #ffffff;
  }

  .select2-results__option.status-reutilizar {
    background-color: #ffc107;
    color: #212529;
  }

  .select2-results__option.status-preempleo {
    background-color: #28a745;
    color: #ffffff;
  }

  .select2-results__option.status-acuerdo {
    background-color: #fd7e14;
    color: #212529;
  }

  .select2-results__option.status-bloqueado {
    background-color: #dc3545;
    color: #ffffff;
  }

  /* Mantén el color en hover/focus */
  .select2-results__option.status-row.select2-results__option--highlighted {
    filter: brightness(0.9);
  }

  /* Chip de selección */
  .status-pill {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 9999px;
    font-size: 12px;
    line-height: 1.2;
    margin-right: 6px;
    border: 1px solid rgba(0, 0, 0, .08);
    text-transform: uppercase;
    /* Mayúsculas */
    font-weight: 600;
  }
  </style>

  <script>
  // Namespace seguro
  window.TS = window.TS || {};
  // Define una sola vez
  window.TS.FILTER_STATUS_STYLES = window.TS.FILTER_STATUS_STYLES || Object.freeze({
    "Todos": {
      bg: "#e9ecef",
      fg: "#212529",
      cls: "status-all",
      db: null
    },
    "En espera": {
      bg: "#6c757d",
      fg: "#ffffff",
      cls: "status-espera",
      db: 1
    },
    "En Proceso / Aprobado": {
      bg: "#17a2b8",
      fg: "#ffffff",
      cls: "status-proceso",
      db: 2
    },
    "Reutilizable": {
      bg: "#ffc107",
      fg: "#212529",
      cls: "status-reutilizar",
      db: 3
    },
    "Preempleo / Contratado": {
      bg: "#28a745",
      fg: "#ffffff",
      cls: "status-preempleo",
      db: 4
    },
    "Aprobado con Acuerdo": {
      bg: "#fd7e14",
      fg: "#212529",
      cls: "status-acuerdo",
      db: 5
    },
    "Bloqueado": {
      bg: "#dc3545",
      fg: "#ffffff",
      cls: "status-bloqueado",
      db: 0
    }
  });

  function initColoredFilter($scope) {
    const map = window.TS.FILTER_STATUS_STYLES;
    const $filtrar = ($scope || $(document)).find('#filtrar');
    if (!$filtrar.length) return;

    if ($filtrar.data('select2')) $filtrar.select2('destroy');

    // Render de opciones
    function tplResult(state) {
      if (!state.id) return state.text;
      return state.text.toUpperCase(); // fila en mayúsculas (CSS + extra)
    }
    // Render de selección (chip)
    function tplSelection(state) {
      if (!state.id) return state.text;
      const s = map[state.id];
      if (!s) return state.text;
      const $n = $('<span class="status-pill"></span>');
      $n.css({
        backgroundColor: s.bg,
        color: s.fg
      }).text((state.text || state.id).toUpperCase());
      return $n;
    }

    $filtrar.select2({
      placeholder: "Select",
      allowClear: false,
      width: '100%',
      templateResult: tplResult,
      templateSelection: tplSelection,
      escapeMarkup: m => m
    });

    // Pinta filas completas con clase al abrir
    // Pinta filas completas con clase al abrir (versión robusta con MAYÚSCULAS)
    $filtrar.off('select2:open.__paintrows__').on('select2:open.__paintrows__', function() {
      setTimeout(function() {
        const map = window.TS.FILTER_STATUS_STYLES;

        $('.select2-results__option[role="option"]').each(function() {
          const $li = $(this);
          const data = $li.data('data'); // <-- aquí viene {id,text,...}

          $li.removeClass(
            'status-row status-all status-espera status-proceso status-reutilizar status-preempleo status-acuerdo status-bloqueado'
          );

          if (data && data.id && map[data.id] && map[data.id].cls) {
            $li.addClass('status-row ' + map[data.id].cls);
          }
        });
      }, 0);
    });


  }

  // Llamadas
  $(document).ready(function() {
    initColoredFilter(); // inicial
  });
  // Después de AJAX:
  // $('#module-content').html(data); initColoredFilter($('#module-content'));
  </script>