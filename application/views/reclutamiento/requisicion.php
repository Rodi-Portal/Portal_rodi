<!-- Begin Page Content -->
<div>
  <?php
      // Helpers: view_perms y authz ya autoloaded
      $ROL        = (int) $this->session->userdata('idrol');
      $TIPO_BOLSA = (int) $this->session->userdata('tipo_bolsa'); // 1 = intake/externo según tu lógica

      $CAN = [
          // Vista / listado (por si luego lo necesitas)
          'VER'            => show_if_can('reclutamiento.reqs.ver', true),

          // Botones superiores
          'CREAR'          => show_if_can('reclutamiento.reqs.crear', ($TIPO_BOLSA === 1) || in_array($ROL, [1, 6, 9], true)),
          'ASIGNAR'        => show_if_can('reclutamiento.reqs.asignar', $ROL !== 4),

          // Botones en tarjeta
          'EDITAR'         => show_if_can('reclutamiento.reqs.editar', true),
          'VER_COMPLETA'   => show_if_can('reclutamiento.reqs.ver_completa', true),
          'INICIAR'        => show_if_can('reclutamiento.reqs.iniciar', true),
          'CAMBIAR_STATUS' => show_if_can('reclutamiento.reqs.cambiar_status', true),
          'PDF'            => show_if_can('reclutamiento.reqs.descargar_pdf', true),

          'ELIMINAR'       => show_if_can('reclutamiento.reqs.eliminar', in_array($ROL, [1], true)),
          'LINK'           => show_if_can('reclutamiento.reqs.link_requisicion', in_array($ROL, [1], true)),
          'DETENER'        => show_if_can('reclutamiento.reqs.detener_requisicion', in_array($ROL, [1], true)),

          // Usuarios asignados a la req
          'USU_ASIG_VER'   => show_if_can('reclutamiento.reqs.usuarios_asig_ver', true),
          'USU_ASIG_DEL'   => show_if_can('reclutamiento.reqs.usuarios_asig_del', $ROL !== 4),
      ];

      // (Opcional) Flags para JS (DataTables, habilitar íconos, etc.)
      echo perms_js_flags([
          'REQS_CREAR'          => ['reclutamiento.reqs.crear', ($TIPO_BOLSA === 1) || in_array($ROL, [4, 1, 6, 9], true)],
          'REQS_ASIGNAR'        => ['reclutamiento.reqs.asignar', $ROL !== 4],
          'REQS_EDITAR'         => ['reclutamiento.reqs.editar', true],
          'REQS_DETENER'        => ['reclutamiento.reqs.detener_requisicion', true],
          'REQS_VER_COMPLETA'   => ['reclutamiento.reqs.ver_completa', true],
          'REQS_INICIAR'        => ['reclutamiento.reqs.iniciar', true],
          'REQS_CAMBIAR_STATUS' => ['reclutamiento.reqs.cambiar_status', true],
          'REQS_PDF'            => ['reclutamiento.reqs.descargar_pdf', true],
          'REQS_ELIMINAR'       => ['reclutamiento.reqs.eliminar', in_array($ROL, [1], true)],
          'REQS_USU_DEL'        => ['reclutamiento.reqs.usuarios_asig_del', $ROL !== 4],
      ]);
  ?>

  <section class="content-header">
    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6 text-center">
        <h1 class="titulo_seccion mb-3"><?php echo t('rec_desk_title', 'Requisiciones'); ?></h1>
      </div>


      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="actions d-flex justify-content-md-end flex-wrap">
          <?php if ($this->session->userdata('tipo_bolsa') == 1): ?>
          <?php if ($CAN['LINK']): ?>
          <!-- Link General (lo dejo como lo tenías; si quieres amarrarlo a VER, envuélvelo con $CAN['VER']) -->
          <button type="button" class="btn action-btn btn-green" onclick="openQrModal()">
            <span class="icon"><i class="far fa-file-alt"></i></span>
            <span class="text"><?php echo t('rec_desk_btn_link_general', 'Link General'); ?></span>
          </button>
          <?php endif; ?>
          <?php endif; ?>
          <?php if ($CAN['CREAR']): ?>
          <?php if ($this->session->userdata('tipo_bolsa') == 1): ?>
          <button type="button" id="btnRegistrarReq" class="btn action-btn btn-blue" onclick="nuevaRequisicionIntake()">
            <span class="icon"><i class="far fa-file-alt"></i></span>
            <span class="text"><?php echo t('rec_desk_btn_register', 'Registrar Requisición'); ?></span>
          </button>
          <?php else: ?>
          <button type="button" id="btnReqInterna" class="btn action-btn btn-blue" onclick="nuevaRequisicion()">
            <span class="icon"><i class="far fa-file-alt"></i></span>
            <span class="text"><?php echo t('rec_desk_btn_internal', 'Requisición Interna'); ?></span>
          </button>
          <?php endif; ?>
          <?php endif; ?>

          <?php if ($CAN['ASIGNAR']): ?>
          <button type="button" id="btnOpenAssignToUser" class="btn action-btn btn-purple" onclick="openAssignToUser()">
            <span class="icon"><i class="fas fa-user-edit"></i></span>
            <span class="text"><?php echo t('rec_desk_btn_assign', 'Asignar Requisición'); ?></span>
          </button>
          <?php endif; ?>
        </div>

      </div>

    </div>
  </section>
  <br><br>
  <div>
    <p><?php echo t('rec_desk_intro',
           'Este módulo facilita la gestión de requisiciones de empleo, permitiendo asignar a un reclutador, registrar nuevas requisiciones expresas, y realizar acciones como descargar, iniciar, ver, detener y eliminar requisiciones de manera ágil y organizada.'
       ); ?></p>

  </div>

  <?php echo $modals; ?>
  <?php echo $modals_reclutamiento; ?>
  <div class="loader" style="display: none;"></div>
  <input type="hidden" id="idRequisicion">
  <input type="hidden" id="currentPage">
  <input type="hidden" id="idCandidato">
  <input type="hidden" id="idAvance">

  <div class="row mt-3 mb-5" id="divFiltros">
    <div class="col-sm-12 col-md-2 col-lg-2 offset-md-5 offset-lg-5">
      <label for="ordenar"><?php echo t('rec_desk_sort_label', 'Ordenar:'); ?></label>
      <select name="ordenar" id="ordenar" class="form-control">
        <option value=""><?php echo t('rec_desk_sort_placeholder', 'Selecciona'); ?></option>
        <option value="ascending"><?php echo t('rec_desk_sort_ascending', 'De la más antigua a la más actual'); ?>
        </option>
        <option value="descending"><?php echo t('rec_desk_sort_descending', 'De la más actual a la más antigua'); ?>
        </option>

      </select>
    </div>
    <div class="col-sm-12 col-md-2 col-lg-2">
      <label for="filtrar"><?php echo t('rec_desk_filter_label', 'Filtrar:'); ?></label>
      <select name="filtrar" id="filtrar" class="form-control">
        <option value=""><?php echo t('rec_desk_filter_placeholder', 'Seleccionar'); ?></option>
        <option value="COMPLETA">
          <?php echo t('rec_desk_filter_complete', 'Requisición COMPLETA (registrada por externo)'); ?></option>
        <option value="INTERNA"><?php echo t('rec_desk_filter_internal', 'Requisición Interna'); ?></option>
        <option value="En espera"><?php echo t('rec_desk_filter_waiting', 'Estado pendiente'); ?></option>
        <option value="En proceso"><?php echo t('rec_desk_filter_in_process', 'Estado en proceso de reclutamiento'); ?>
        </option>


      </select>
    </div>
    <div class="col-sm-12 col-md-3 col-lg-3">
      <label for="buscador"><?php echo t('rec_desk_search_label', 'Buscar:'); ?></label>
      <select name="buscador" id="buscador" class="form-control">
        <option value="0"><?php echo t('rec_desk_search_all', 'Todos'); ?></option>
        <?php if (! empty($orders_search)): ?>
        <?php foreach ($orders_search as $row): ?>
        <option value="<?php echo (int) $row->idReq; ?>">
          <?php
              echo '#' . (int) $row->idReq . ' '
                  . (! empty($row->nombre_cliente) ? htmlspecialchars($row->nombre_cliente) : t('rec_desk_unassigned', 'No Asignado'))
                  . ' - '
                  . (! empty($row->puesto) ? htmlspecialchars($row->puesto) : t('rec_desk_no_position', 'Sin puesto'));
          ?>
        </option>
        <?php endforeach; ?>
        <?php else: ?>
        <option value=""><?php echo t('rec_desk_search_empty', 'Sin requisiciones registradas'); ?></option>
        <?php endif; ?>
      </select>
    </div>

  </div>

  <a href="javascript:void(0)" class="btn btn-primary btn-icon-split btnRegresar" id="btnBack"
    onclick="regresarListado()" style="display: none;">
    <span class="icon text-white-50">
      <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text"><?php echo t('rec_desk_btn_back', 'Regresar al listado'); ?></span>
  </a>

  <div id="seccionTarjetas">
    <div id="tarjetas">
      <?php

      if ($requisiciones): ?>

      <div class="row mb-3">
        <?php foreach ($requisiciones as $r):
                $hoy            = date('Y-m-d H:i:s');
                $fecha_registro = ! empty($r->creacionReq) ? fechaTexto($r->creacionReq, 'espanol') : '';

                // Intake vs clásica
                $esIntake = (isset($r->tipo) && strtoupper($r->tipo) === 'SOLICITUD' || strtoupper($r->tipo) === 'INTAKE');

                if ($esIntake) {
                    $empresa      = trim((string) ($r->nombre ?? ''));
                    $comercial    = trim((string) ($r->razon_social ?? ''));
                    $puestoCard   = ! empty($r->puesto) ? $r->puesto : ($r->plan ?? '');
                    $telefonoCard = trim((string) ($r->telIntake ?? ''));
                    $correoCard   = ! empty($r->email) ? trim((string) $r->email) : trim((string) ($r->correo ?? ''));
                    $contactoCard = trim((string) ($r->nombre_cliente ?? ''));
                } else {
                    $empresa      = trim((string) ($r->nombre_cliente ?? ''));
                    $comercial    = trim((string) ($r->nombre_comercial ?? ''));
                    $puestoCard   = trim((string) ($r->puesto ?? ''));
                    $telefonoCard = trim((string) ($r->telefono_cliente ?? ''));
                    $correoCard   = trim((string) ($r->correo_cliente ?? ''));
                    $contactoCard = trim((string) ($r->contacto ?? ''));
                }

                $nombres  = empty($comercial) ? $empresa : ($empresa . '<br>' . $comercial);
                $nombreJS = addslashes($empresa);

                // Estatus / botones (respetando permisos)
                $color_estatus   = '';
                $text_estatus    = '';
                $botonProceso    = '';
                $botonResultados = '';
                $btnDelete       = '';

                if ((int) $r->status === 1) {
                    // SIEMPRE mostrar texto de estatus
                    $text_estatus = t('rec_desk_status_label', 'Estatus:') . ' <b>' . t('rec_desk_status_waiting', 'En espera') . '</b>';

                    // Botón iniciar solo si tiene permiso
                    if (! empty($CAN['INICIAR'])) {
                        $botonProceso = '<a href="javascript:void(0)" class="btn btn-success btn-ico" id="btnIniciar' . $r->idReq . '"title="' . t('rec_desk_btn_start_title', 'Iniciar proceso') . '" onclick="cambiarStatusRequisicion(' . $r->idReq . ',\'' . $nombreJS . '\', \'iniciar\')"><i class="fas fa-play-circle fa-fw"></i></a>';
                    }

                    // Ver resultados (lo dejo como estaba, si luego quieres permiso, lo amarramos)
                    $botonResultados = '<a href="javascript:void(0)" class="btn btn-success btn-ico isDisabled" title="' . t('rec_desk_btn_results_title', 'Ver resultados de los candidatos') . '"><i class="fas fa-file-alt fa-fw"></i></a>';

                    // Eliminar solo con permiso
                    if (! empty($CAN['ELIMINAR'])) {
                        $btnDelete = '<a href="javascript:void(0)" class="btn btn-danger btn-ico" title="' . t('rec_desk_btn_delete_title', 'Eliminar Requisición') . '" onclick="openDeleteOrder(' . $r->idReq . ',\'' . $nombreJS . '\')"><i class="fas fa-trash fa-fw"></i></a>';

                    }
                }

                if ((int) $r->status === 2) {
                    $color_estatus = 'req_activa';
                    $text_estatus  = t('rec_desk_status_label', 'Estatus:') . ' <b>' . t('rec_desk_status_in_process', 'En proceso de reclutamiento') . '</b>';

                    // Botón detener solo si tiene permiso de cambiar status
                    if (! empty($CAN['DETENER'])) {
                        $botonProceso = '<a href="javascript:void(0)" class="btn btn-danger btn-ico" id="btnIniciar' . $r->idReq . '" title="' . t('rec_desk_btn_stop_title', 'Detener proceso') . '" onclick="cambiarStatusRequisicion(' . $r->idReq . ',\'' . $nombreJS . '\', \'detener\')"><i class="fas fa-stop fa-fw"></i></a>';

                    }

                    $botonResultados = '<a href="javascript:void(0)" class="btn btn-success btn-ico" title="' . t('rec_desk_btn_results_title', 'Ver resultados de los candidatos') . '" onclick="verExamenesCandidatos(' . $r->idReq . ',\'' . $nombreJS . '\')"><i class="fas fa-file-alt fa-fw"></i></a>';

                    // Si está en proceso, mantener el isDisabled original del eliminar
                    if (! empty($CAN['ELIMINAR'])) {
                        $btnDelete = '<a href="javascript:void(0)" class="btn btn-danger btn-ico isDisabled" title="' . t('rec_desk_btn_delete_title', 'Eliminar Requisición') . '"><i class="fas fa-trash fa-fw"></i></a>';

                    }
                }

                // Usuarios asignados (dedupe)
                $usuario = (empty($r->usuario))
                    ? t('rec_desk_user_no_changes', 'Requisición sin cambios') . '<br>'
                    : t('rec_desk_user_last_move', 'Último movimiento:') . ' <b>' . $r->usuario . '</b><br>';

                $data['users'] = $this->reclutamiento_model->getUsersOrder($r->idReq);
                if (! empty($data['users'])) {
                    $usersAssigned = t('rec_desk_assigned_user_label', 'Usuario Asignado:') . '<br>';
                    $seen          = [];
                    foreach ($data['users'] as $user) {
                        if (isset($seen[$user->id])) {
                            continue;
                        }

                        $seen[$user->id] = true;
                        $nombreUsuario   = htmlspecialchars($user->usuario, ENT_QUOTES, 'UTF-8');

                        // Quitar/eliminar usuario asignado SOLO si tiene permiso (sin cambiar IDs)
                        if (! empty($CAN['USU_ASIG_DEL'])) {
                            $usersAssigned .= '<div class="mb-1" id="divUser' . $user->id . '">
	                            <a href="javascript:void(0)" class="btn btn-danger btn-ico" title="' . t('rec_desk_btn_remove_user_title', 'Eliminar Usuario de la Requisición') . '" onclick="openDeleteUserOrder(' . $user->id . ',' . $user->id_requisicion . ',\'' . $nombreUsuario . '\')"> <i class="fas fa-user-times fa-fw"></i>
	                            </a> <b>' . $nombreUsuario . '</b></div>';

                        } else {
                            $usersAssigned .= '<div class="mb-1" id="divUser' . $user->id . '"><b>' . $nombreUsuario . '</b></div>';
                        }
                    }
                } else {
                    $usersAssigned = t('rec_desk_assigned_none', 'No Asignada aun');
                }
                unset($data['users']);

                // Botón editar (respeta permiso, sin tocar IDs)
                $btnExpress = '';
                if (! empty($CAN['EDITAR'])) {
                    $btnExpress = ($r->tipo == 'INTERNA' || $r->tipo == 'COMPLETA')
                        ? '<a href="javascript:void(0)" class="btn btn-primary btn-ico" title="' . t('rec_desk_btn_edit_req_title', 'Editar Requisición') . '" onclick="openUpdateOrder(' . $r->idReq . ',\'' . $nombreJS . '\',\'' . $nombreJS . '\',\'' . addslashes($puestoCard) . '\')">
							             <i class="fas fa-edit fa-fw"></i></a>'
                        : '<a href="javascript:void(0)" class="btn btn-primary btn-ico" title="' . t('rec_desk_btn_edit_request_title', 'Editar SOLICITUD') . '" onclick="openUpdateOrderIntake(' . (int) $r->idReq . ')">
							             <i class="fas fa-edit fa-fw"></i></a>';
                }

                // Detalles (VER_COMPLETA)
                $btnDetalles = '';
                if (! empty($CAN['VER_COMPLETA'])) {
                    $btnDetalles = ($r->tipo == 'INTERNA' || $r->tipo == 'COMPLETA')
                        ? '<a href="javascript:void(0)" class="btn btn-primary btn-ico" title="' . t('rec_desk_btn_view_details_title', 'Ver detalles') . '"  onclick="verDetalles(' . (int) $r->idReq . ')">
							             <i class="fas fa-info-circle fa-fw"></i>
							           </a>'
                        : '<a href="javascript:void(0)" class="btn btn-primary btn-ico" title="Ver detalles"
							             onclick="verDetallesIntake(' . (int) $r->idReq . ')">
							             <i class="fas fa-info-circle fa-fw"></i>
							           </a>';
                }

                // PDF
                $btnPDF = '';
                if (! empty($CAN['PDF'])) {
                    if ($r->tipo == 'INTERNA' || $r->tipo == 'COMPLETA') {
                        $btnPDF =
                        '<form method="POST" action="' . base_url('Reclutamiento/getOrderPDF') . '">
							            <input type="hidden" name="idReq" value="' . (int) $r->idReq . '">
							            <button type="submit" class="btn btn-danger btn-ico" title="' . t('rec_desk_btn_download_pdf_title', 'Descargar PDF') . '">
							              <i class="fas fa-file-pdf fa-fw"></i>
							            </button>
							          </form>';
                    } else {
                        $btnPDF =
                        '<form method="POST" action="' . base_url('Reclutamiento/getOrderPDFIntake') . '">
							            <input type="hidden" name="idReq" value="' . (int) $r->idReq . '">
							            <button type="submit" class="btn btn-danger btn-ico" title="' . t('rec_desk_btn_download_pdf_title', 'Descargar PDF') . '">
							              <i class="fas fa-file-pdf fa-fw"></i>
							            </button>
							          </form>';
                    }
                }

                // Asignar sucursal (solo intake) — amarrado a permiso ASIGNAR
                $btnAsignarSucursal = '';
                if ($esIntake && ! empty($CAN['ASIGNAR'])) {
                    $btnAsignarSucursal =
                    '<button type="button" class="btn btn-success btn-ico btn-asignar-sucursal" title="' . t('rec_desk_btn_assign_branch_title', 'Asignar a sucursal') . '" data-idreq="' . (int) $r->idReq . '"
							           data-sucursal="' . (isset($r->id_sucursal) ? (int) $r->id_sucursal : 0) . '">
							           <i class="fas fa-store fa-fw"></i>
							         </button>';
                }

                $totalOrders = count($requisiciones);
                $moveOrder   = ($totalOrders > 1) ? '' : 'offset-md-4 offset-lg-4';
            ?>
		        <div class="col-sm-12 col-md-4 col-lg-4 mb-5<?php echo $moveOrder ?>">
		          <div class="card text-center tarjeta" id="<?php echo 'tarjeta' . (int) $r->idReq; ?>">
		            <div
		              class="card-header		                                	                                	                                	                                		                                   	                                   	                                <?php echo $color_estatus ?>">
		              <div class="d-flex align-items-center">
		                <span class="text-uppercase text-truncate d-block w-100">
		                  <strong>
		                    #<?php echo (int) $r->idReq ?>
		                    <?php
                                    $headerNombre = preg_replace(
                                        '/\s+/', ' ',
                                        trim(str_ireplace(['<br>', '<br/>', '<br />'], ' ', (string) $nombres))
                                    );
                                    echo ' ' . html_escape($headerNombre);
                                ?>
		                  </strong>
		                </span>

		                <?php if ($esIntake): ?>
		                <span class="badge badge-info ml-2"><?php echo t('rec_desk_badge_request', 'SOLICITUD'); ?></span>
		                <?php endif; ?>
              </div>
            </div>

            <div class="card-body">
              <h5 class="card-title"><b><?php echo $puestoCard; ?></b></h5>
              <p class="card-text"><?php echo t('rec_desk_label_vacancies', 'Vacantes:'); ?>
                <b><?php echo $r->numero_vacantes; ?></b>
              </p>

              <p class="card-text"><?php echo t('rec_desk_label_contact', 'Contacto:'); ?>
                <br><b><?php echo $contactoCard . ' <br>' . $telefonoCard . ' <br>' . $correoCard; ?></b>
              </p>

              <?php if ($esIntake): ?>
              <div class="alert alert-info text-center mt-2 p-2">
                <small>
                  <?php if (! empty($r->plan)): ?><?php echo t('rec_desk_label_plan', 'Plan:'); ?>
                  <b><?php echo htmlspecialchars($r->plan, ENT_QUOTES, 'UTF-8'); ?></b><?php endif; ?>
                  <?php if (! empty($r->metodo_comunicacion)): ?> ·<?php echo t('rec_desk_label_channel', 'Medio:'); ?>
                  <b><?php echo htmlspecialchars($r->metodo_comunicacion, ENT_QUOTES, 'UTF-8'); ?></b><?php endif; ?>
                  <?php if (! empty($r->pais_empresa)): ?> ·<?php echo t('rec_desk_label_country', 'País:'); ?>
                  <b><?php echo htmlspecialchars($r->pais_empresa, ENT_QUOTES, 'UTF-8'); ?></b><?php endif; ?>
                </small>
              </div>
              <?php endif; ?>

              <div class="alert alert-secondary text-center mt-3">
                <?php echo t('rec_desk_label_type', 'Tipo:'); ?>
                <b><?php echo $r->tipo ?></b><br><?php echo $text_estatus ?>
              </div>

              <!-- Barra uniforme de botones -->
              <div class="btnbar">
                <?php echo $btnExpress; ?>
                <?php echo $btnDetalles; ?>
                <span id="divIniciar<?php echo (int) $r->idReq ?>"><?php echo $botonProceso ?></span>
                <?php echo $btnPDF; ?>
                <?php echo $btnDelete; ?>
                <?php echo $btnAsignarSucursal; ?>
              </div>

              <div class="alert alert-secondary text-left mt-3" id="divUsuario<?php echo (int) $r->idReq; ?>">
                <?php echo $usuario . $usersAssigned; ?>
              </div>
            </div>

            <div class="card-footer text-muted">
              <?php echo $fecha_registro; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <?php endif; ?>
    </div>



    <!-- Detalle (sin cambios) -->
    <div id="tarjeta_detalle" class="hidden mb-5">
      <div class="alert alert-info text-center" id="empresa"></div>
      <div class="card">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a class="nav-link active" id="link_vacante"
                href="javascript:void(0)"><?php echo t('rec_desk_tab_vacancy_info', 'Información de la vacante'); ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="link_cargo"
                href="javascript:void(0)"><?php echo t('rec_desk_tab_role_info', 'Información sobre el cargo'); ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="link_perfil"
                href="javascript:void(0)"><?php echo t('rec_desk_tab_role_profile', 'Perfil del cargo'); ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="link_factura"
                href="javascript:void(0)"><?php echo t('rec_desk_tab_billing', 'Datos de facturación'); ?></a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <!-- ... (tu contenido de detalle tal cual) ... -->
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
      <h5 class="card-header text-center seccion"><?php echo t('rec_desk_bill_title', 'Datos de Facturación'); ?></h5>
      <div class="card-body">
        <form id="formDatosFacturacionRequisicion">
          <div class="row">
            <div class="col-6">
              <label><?php echo t('rec_desk_bill_trade_name', 'Nombre comercial'); ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" id="comercial_update" name="comercial_update"
                  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              </div>
            </div>
            <div class="col-6">
              <label><?php echo t('rec_desk_bill_legal_name', 'Razón social'); ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" id="nombre_update" name="nombre_update"
                  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="pais"><?php echo t('rec_desk_bill_country', 'País'); ?> *</label>
              <input type="text" class="form-control" id="pais_update" name="pais_update">
            </div>
            <div class="col-md-4">
              <label for="estado"><?php echo t('rec_desk_bill_state', 'Estado'); ?> *</label>
              <input type="text" class="form-control" id="estado_update" name="estado_update">
            </div>
            <div class="col-md-4">
              <label for="ciudad"><?php echo t('rec_desk_bill_city', 'Ciudad'); ?> *</label>
              <input type="text" class="form-control" id="ciudad_update" name="ciudad_update">
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-4">
              <label for="colonia"><?php echo t('rec_desk_bill_neighborhood', 'Colonia'); ?> *</label>
              <input type="text" class="form-control" id="colonia_update" name="colonia_update">
            </div>
            <div class="col-md-4">
              <label for="calle"><?php echo t('rec_desk_bill_street', 'Calle'); ?> *</label>
              <input type="text" class="form-control" id="calle_update" name="calle_update">
            </div>
            <div class="col-md-2">
              <label for="num_interior"><?php echo t('rec_desk_bill_int_number', 'Número Interior'); ?></label>
              <input type="text" class="form-control" id="interior_update" name="interior_update">
            </div>
            <div class="col-md-2">
              <label for="num_exterior"><?php echo t('rec_desk_bill_ext_number', 'Número Exterior'); ?></label>
              <input type="text" class="form-control" id="exterior_update" name="exterior_update">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label><?php echo t('rec_desk_bill_postal_code', 'Código postal'); ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-home"></i></span>
                </div>
                <input type="number" class="form-control solo_numeros" id="cp_update" name="cp_update" maxlength="5">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label><?php echo t('rec_desk_bill_phone', 'Teléfono'); ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                </div>
                <input type="text" class="form-control" id="telefono_update" name="telefono_update" maxlength="16">
              </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label><?php echo t('rec_desk_bill_email', 'Correo'); ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-envelope"></i></span>
                </div>
                <input type="text" class="form-control" id="correo_update" name="correo_update"
                  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
              </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label><?php echo t('rec_desk_bill_contact', 'Contacto'); ?> *</label>
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
              <label><?php echo t('rec_desk_bill_tax_regime', 'Régimen Fiscal'); ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                </div>
                <input type="text" class="form-control" id="regimen_update" name="regimen_update"
                  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label><?php echo t('rec_desk_bill_rfc', 'RFC'); ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" id="rfc_update" name="rfc_update"
                  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                  maxlength="13">
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label><?php echo t('rec_desk_bill_payment_form', 'Forma de pago'); ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                </div>
                <select class="custom-select" id="forma_pago_update" name="forma_pago_update">
                  <option value="" selected><?php echo t('rec_desk_bill_select', 'Selecciona'); ?></option>
                  <option value="Pago en una sola exhibición">
                    <?php echo t('rec_desk_bill_payment_form_single', 'Pago en una sola exhibición'); ?></option>
                  <option value="Pago en parcialidades o diferidos">
                    <?php echo t('rec_desk_bill_payment_form_installments', 'Pago en parcialidades o diferidos'); ?>
                  </option>

                </select>
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label><?php echo t('rec_desk_bill_payment_method', 'Método de pago'); ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                </div>
                <select class="custom-select" id="metodo_pago_update" name="metodo_pago_update">
                  <option value="" selected><?php echo t('rec_desk_bill_select', 'Selecciona'); ?></option>
                  <option value="Efectivo"><?php echo t('rec_desk_bill_pay_cash', 'Efectivo'); ?></option>
                  <option value="Cheque de nómina">
                    <?php echo t('rec_desk_bill_pay_payroll_check', 'Cheque de nómina'); ?></option>
                  <option value="Transferencia electrónica">
                    <?php echo t('rec_desk_bill_pay_transfer', 'Transferencia electrónica'); ?></option>
                  <option value="Tarjeta de crédito">
                    <?php echo t('rec_desk_bill_pay_credit_card', 'Tarjeta de crédito'); ?></option>
                  <option value="Tarjeta de débito">
                    <?php echo t('rec_desk_bill_pay_debit_card', 'Tarjeta de débito'); ?></option>
                  <option value="Por definir"><?php echo t('rec_desk_bill_pay_tbd', 'Por definir'); ?></option>

                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label><?php echo t('rec_desk_bill_cfdi_use_label', 'Uso de CFDI (Reescibra el uso de cfdi en caso de ser diferente)'); ?>
                *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
                </div>
                <input type="text" class="form-control" id="uso_cfdi_update" name="uso_cfdi_update"
                  value="Gastos en General">
              </div>
            </div>

            <div class="input-group mb-3">

              <input type="hidden" class="form-control" id="id_generales_update" name="id_generales_update">
              <input type="hidden" class="form-control" id="id_facturacion_update" name="id_facturacion_update">
              <input type="hidden" class="form-control" id="id_domicilios_update" name="id_domicilios_update">
            </div>

          </div>
        </form>
        <button type="button" class="btn btn-success btn-block text-lg"
          onclick="updateOrder('data_facturacion')"><?php echo t('rec_desk_bill_btn_save', 'Guardar Datos de Facturación'); ?></button>

      </div>
    </div>
<div class="card mb-5">
  <h5 class="card-header text-center seccion">
    <?php echo t('rec_desk_vac_title', 'Información de la Vacante'); ?>
  </h5>

  <div class="card-body">
    <form id="formVacante">
      <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_vac_position_name', 'Nombre de la posición'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
            </div>
            <input type="text" class="form-control" id="puesto_update" name="puesto_update">
          </div>
        </div>

        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_vac_openings', 'Número de vacantes'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
            </div>
            <input type="number" class="form-control" id="num_vacantes_update" name="num_vacantes_update">
          </div>
        </div>

        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_vac_required_education', 'Formación académica requerida'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
            </div>
            <select class="custom-select" id="escolaridad_update" name="escolaridad_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="Primaria"><?php echo t('rec_desk_vac_edu_primary', 'Primaria'); ?></option>
              <option value="Secundaria"><?php echo t('rec_desk_vac_edu_secondary', 'Secundaria'); ?></option>
              <option value="Bachiller"><?php echo t('rec_desk_vac_edu_highschool', 'Bachiller'); ?></option>
              <option value="Licenciatura"><?php echo t('rec_desk_vac_edu_bachelor', 'Licenciatura'); ?></option>
              <option value="Maestría"><?php echo t('rec_desk_vac_edu_master', 'Maestría'); ?></option>
            </select>
          </div>
        </div>

        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_vac_academic_status', 'Estatus académico'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
            </div>
            <select class="custom-select" id="estatus_escolaridad_update" name="estatus_escolaridad_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="Técnico"><?php echo t('rec_desk_vac_status_technical', 'Técnico'); ?></option>
              <option value="Pasante"><?php echo t('rec_desk_vac_status_intern', 'Pasante'); ?></option>
              <option value="Estudiante"><?php echo t('rec_desk_vac_status_student', 'Estudiante'); ?></option>
              <option value="Titulado"><?php echo t('rec_desk_vac_status_graduated', 'Titulado'); ?></option>
              <option value="Trunco"><?php echo t('rec_desk_vac_status_incomplete', 'Trunco'); ?></option>
              <option value="Otro"><?php echo t('rec_desk_vac_status_other', 'Otro'); ?></option>
            </select>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_vac_other_academic_status', 'Otro estatus académico'); ?></label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
            </div>
            <input type="text" class="form-control" id="otro_estatus_update" name="otro_estatus_update" disabled>
          </div>
        </div>

        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_vac_required_degree', 'Carrera requerida para el puesto'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
            </div>
            <input type="text" class="form-control" id="carrera_update" name="carrera_update">
          </div>
        </div>

        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_vac_other_studies', 'Otros estudios'); ?></label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
            </div>
            <input type="text" class="form-control" id="otros_estudios_update" name="otros_estudios_update">
          </div>
        </div>

        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_vac_languages', 'Idiomas que habla y porcentajes de cada uno'); ?></label>
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
          <label><?php echo t('rec_desk_vac_it_skills', 'Habilidades informáticas requeridas'); ?></label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-laptop"></i></span>
            </div>
            <input type="text" class="form-control" id="hab_informatica_update" name="hab_informatica_update">
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-lg-2">
          <label><?php echo t('rec_desk_vac_gender', 'Sexo'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
            </div>
            <select class="custom-select" id="genero_update" name="genero_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="Femenino"><?php echo t('rec_desk_vac_gender_female', 'Femenino'); ?></option>
              <option value="Masculino"><?php echo t('rec_desk_vac_gender_male', 'Masculino'); ?></option>
              <option value="Indistinto"><?php echo t('rec_desk_vac_gender_any', 'Indistinto'); ?></option>
            </select>
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-lg-2">
          <label><?php echo t('rec_desk_vac_marital_status', 'Estado civil'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
            </div>
            <select class="custom-select" id="civil_update" name="civil_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="Soltero(a)"><?php echo t('rec_desk_vac_marital_single', 'Soltero(a)'); ?></option>
              <option value="Casado(a)"><?php echo t('rec_desk_vac_marital_married', 'Casado(a)'); ?></option>
              <option value="Indistinto"><?php echo t('rec_desk_vac_marital_any', 'Indistinto'); ?></option>
            </select>
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-lg-2">
          <label><?php echo t('rec_desk_vac_min_age', 'Edad mínima'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-minus"></i></span>
            </div>
            <input type="number" id="edad_minima_update" name="edad_minima_update" class="form-control">
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-lg-2">
          <label><?php echo t('rec_desk_vac_max_age', 'Edad máxima'); ?> *</label>
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
          <label><?php echo t('rec_desk_vac_driver_license', 'Licencia de conducir'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-id-card"></i></span>
            </div>
            <select class="custom-select" id="licencia_update" name="licencia_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="Indispensable"><?php echo t('rec_desk_vac_license_required', 'Indispensable'); ?></option>
              <option value="Deseable"><?php echo t('rec_desk_vac_license_desirable', 'Deseable'); ?></option>
              <option value="No necesaria"><?php echo t('rec_desk_vac_license_not_needed', 'No necesaria'); ?></option>
            </select>
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-lg-2">
          <label><?php echo t('rec_desk_vac_driver_license_type', 'Tipo de licencia de conducir'); ?>*</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-id-card"></i></span>
            </div>
            <input type="text" class="form-control" id="tipo_licencia_update" name="tipo_licencia_update" disabled>
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-lg-2">
          <label><?php echo t('rec_desk_vac_acceptable_disability', 'Discapacidad aceptable'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-wheelchair"></i></span>
            </div>
            <select class="custom-select" id="discapacidad_update" name="discapacidad_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="Motora"><?php echo t('rec_desk_vac_disability_motor', 'Motora'); ?></option>
              <option value="Auditiva"><?php echo t('rec_desk_vac_disability_hearing', 'Auditiva'); ?></option>
              <option value="Visual"><?php echo t('rec_desk_vac_disability_visual', 'Visual'); ?></option>
              <option value="Motora y auditiva"><?php echo t('rec_desk_vac_disability_motor_hearing', 'Motora y auditiva'); ?></option>
              <option value="Motora y visual"><?php echo t('rec_desk_vac_disability_motor_visual', 'Motora y visual'); ?></option>
              <option value="Sin discapacidad"><?php echo t('rec_desk_vac_disability_none', 'Sin discapacidad'); ?></option>
            </select>
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-lg-2">
          <label><?php echo t('rec_desk_vac_vacancy_cause', 'Causa que origina la vacante'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-question-circle"></i></span>
            </div>
            <select class="custom-select" id="causa_update" name="causa_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="Empresa nueva"><?php echo t('rec_desk_vac_cause_new_company', 'Empresa nueva'); ?></option>
              <option value="Empleo temporal"><?php echo t('rec_desk_vac_cause_temp_job', 'Empleo temporal'); ?></option>
              <option value="Puesto de nueva creación"><?php echo t('rec_desk_vac_cause_new_position', 'Puesto de nueva creación'); ?></option>
              <option value="Reposición de personal"><?php echo t('rec_desk_vac_cause_replacement', 'Reposición de personal'); ?></option>
            </select>
          </div>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-4">
          <label><?php echo t('rec_desk_vac_residence', 'Lugar de residencia'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-home"></i></span>
            </div>
            <input type="text" class="form-control" id="residencia_update" name="residencia_update">
          </div>
        </div>
      </div>
    </form>

    <button type="button" class="btn btn-success btn-block text-lg" onclick="updateOrder('vacante')">
      <?php echo t('rec_desk_vac_btn_save', 'Guardar Información de la Vacante'); ?>
    </button>
  </div>
</div>

<div class="card mb-5">
  <h5 class="card-header text-center seccion">
    <?php echo t('rec_desk_role_title', 'Información sobre el Cargo'); ?>
  </h5>

  <div class="card-body">
    <form id="formCargo">

      <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_role_workday', 'Jornada laboral'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-clock"></i></span>
            </div>
            <select class="custom-select" id="jornada_update" name="jornada_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="Tiempo completo"><?php echo t('rec_desk_role_workday_full', 'Tiempo completo'); ?></option>
              <option value="Medio tiempo"><?php echo t('rec_desk_role_workday_part', 'Medio tiempo'); ?></option>
              <option value="Horas"><?php echo t('rec_desk_role_workday_hours', 'Horas'); ?></option>
            </select>
          </div>
        </div>

        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_role_workday_start', 'Inicio de la Jornada laboral'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-clock"></i></span>
            </div>
            <input type="text" class="form-control" id="tiempo_inicio_update" name="tiempo_inicio_update">
          </div>
        </div>

        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_role_workday_end', 'Fin de la Jornada laboral'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-clock"></i></span>
            </div>
            <input type="text" class="form-control" id="tiempo_final_update" name="tiempo_final_update">
          </div>
        </div>

        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_role_rest_days', 'Día(s) de descanso'); ?> *</label>
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
          <label><?php echo t('rec_desk_role_travel', 'Disponibilidad para viajar'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-plane"></i></span>
            </div>
            <select class="custom-select" id="viajar_update" name="viajar_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="NO"><?php echo t('rec_common_no', 'NO'); ?></option>
              <option value="SI"><?php echo t('rec_common_yes', 'SI'); ?></option>
            </select>
          </div>
        </div>

        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_role_schedule', 'Disponibilidad de horario'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-clock"></i></span>
            </div>
            <select class="custom-select" id="horario_update" name="horario_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="NO"><?php echo t('rec_common_no', 'NO'); ?></option>
              <option value="SI"><?php echo t('rec_common_yes', 'SI'); ?></option>
            </select>
          </div>
        </div>

        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_role_interview_place', 'Lugar de la entrevista'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
            </div>
            <textarea name="lugar_entrevista_update" id="lugar_entrevista_update" class="form-control" rows="3"></textarea>
          </div>
        </div>

        <div class="col-sm-12 col-md-3 col-lg-3">
          <label><?php echo t('rec_desk_role_work_zone', 'Zona de trabajo'); ?> *</label>
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
          <label><?php echo t('rec_desk_role_salary_type', 'Tipo de sueldo'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
            </div>
            <select class="custom-select" id="tipo_sueldo_update" name="tipo_sueldo_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="Fijo"><?php echo t('rec_desk_role_salary_fixed', 'Fijo'); ?></option>
              <option value="Variable"><?php echo t('rec_desk_role_salary_variable', 'Variable'); ?></option>
              <option value="Neto"><?php echo t('rec_desk_role_salary_net', 'Neto (libre)'); ?></option>
              <option value="Nominal"><?php echo t('rec_desk_role_salary_nominal', 'Nominal'); ?></option>
            </select>
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-lg-2">
          <label><?php echo t('rec_desk_role_salary_min', 'Sueldo mínimo'); ?></label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-minus"></i></span>
            </div>
            <input type="number" class="form-control" id="sueldo_minimo_update" name="sueldo_minimo_update">
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-lg-2">
          <label><?php echo t('rec_desk_role_salary_max', 'Sueldo máximo'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-plus"></i></span>
            </div>
            <input type="number" class="form-control" id="sueldo_maximo_update" name="sueldo_maximo_update">
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-lg-2">
          <label><?php echo t('rec_desk_role_salary_extra', 'Adicional al sueldo'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
            </div>
            <select class="custom-select" id="sueldo_adicional_update" name="sueldo_adicional_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="Comisión"><?php echo t('rec_desk_role_extra_commission', 'Comisión'); ?></option>
              <option value="Bono"><?php echo t('rec_desk_role_extra_bonus', 'Bono'); ?></option>
              <option value="N/A"><?php echo t('rec_common_na', 'N/A'); ?></option>
            </select>
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-lg-2">
          <label><?php echo t('rec_desk_role_amount', 'Monto'); ?></label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
            </div>
            <input type="text" class="form-control" id="monto_adicional_update" name="monto_adicional_update" disabled>
          </div>
        </div>

        <div class="col-sm-12 col-md-2 col-lg-2">
          <label><?php echo t('rec_desk_role_payment_type', 'Tipo de pago'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
            </div>
            <select class="custom-select" id="tipo_pago_update" name="tipo_pago_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="Mensual"><?php echo t('rec_desk_role_pay_monthly', 'Mensual'); ?></option>
              <option value="Quincenal"><?php echo t('rec_desk_role_pay_biweekly', 'Quincenal'); ?></option>
              <option value="Semanal"><?php echo t('rec_desk_role_pay_weekly', 'Semanal'); ?></option>
            </select>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4">
          <label><?php echo t('rec_desk_role_statutory_benefits', '¿Tendrá prestaciones de ley?'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-gavel"></i></span>
            </div>
            <select class="custom-select" id="tipo_prestaciones_update" name="tipo_prestaciones_update">
              <option value="" selected><?php echo t('rec_desk_select', 'Selecciona'); ?></option>
              <option value="SI"><?php echo t('rec_common_yes', 'SI'); ?></option>
              <option value="NO"><?php echo t('rec_common_no', 'NO'); ?></option>
            </select>
          </div>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-4">
          <label><?php echo t('rec_desk_role_superior_benefits', '¿Tendrá prestaciones superiores? ¿Cuáles?'); ?></label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-gavel"></i></span>
            </div>
            <input type="text" class="form-control" id="superiores_update" name="superiores_update">
          </div>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-4">
          <label><?php echo t('rec_desk_role_other_benefits', '¿Tendrá otro tipo de prestaciones? ¿Cuáles?'); ?></label>
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
          <label><?php echo t('rec_desk_role_experience', 'Se requiere experiencia en:'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-id-badge"></i></span>
            </div>
            <textarea name="experiencia_update" id="experiencia_update" class="form-control" rows="4"></textarea>
          </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-6">
          <label><?php echo t('rec_desk_role_activities', 'Actividades a realizar:'); ?> *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
            </div>
            <textarea name="actividades_update" id="actividades_update" class="form-control" rows="4"></textarea>
          </div>
        </div>
      </div>

    </form>

    <button type="button" class="btn btn-success btn-block text-lg" onclick="updateOrder('cargo')">
      <?php echo t('rec_desk_role_btn_save', 'Guardar Información sobre el Cargo'); ?>
    </button>
  </div>
</div>

<div class="card mb-5">
  <h5 class="card-header text-center seccion">
    <?php echo t('rec_desk_profile_title', 'Perfil del Cargo'); ?>
  </h5>

  <h5 class="text-center mt-3 my-3">
    <?php echo t('rec_desk_profile_required_competencies', 'Competencias requeridas para el puesto:'); ?>
  </h5>

  <div class="card-body">
    <form id="formPerfil">
      <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4">

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_communication', 'Comunicación'); ?>
            <input type="checkbox" id="Comunicación">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_analysis', 'Análisis'); ?>
            <input type="checkbox" id="Análisis">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_leadership', 'Liderazgo'); ?>
            <input type="checkbox" id="Liderazgo-">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_negotiation', 'Negociación'); ?>
            <input type="checkbox" id="Negociación">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_policy', 'Apego a normas'); ?>
            <input type="checkbox" id="Apego-a-normas">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_planning', 'Planeación'); ?>
            <input type="checkbox" id="Planeación">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_organization', 'Organización'); ?>
            <input type="checkbox" id="Organización">
            <span class="checkmark"></span>
          </label>

        </div>

        <div class="col-sm-12 col-md-4 col-lg-4">

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_results', 'Orientado a resultados'); ?>
            <input type="checkbox" id="Orientado-a-resultados">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_conflicts', 'Manejo de conflictos'); ?>
            <input type="checkbox" id="Manejo-de-conflictos">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_teamwork', 'Trabajo en equipo'); ?>
            <input type="checkbox" id="Trabajo-en-equipo">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_decisions', 'Toma de decisiones'); ?>
            <input type="checkbox" id="Toma-de-decisiones">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_pressure', 'Trabajo bajo presión'); ?>
            <input type="checkbox" id="Trabajo-bajo-presión">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_authority', 'Don de mando'); ?>
            <input type="checkbox" id="Don-de-mando">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_versatile', 'Versátil'); ?>
            <input type="checkbox" id="Versátil">
            <span class="checkmark"></span>
          </label>

        </div>

        <div class="col-sm-12 col-md-4 col-lg-4">

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_sociable', 'Sociable'); ?>
            <input type="checkbox" id="Sociable-">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_intuitive', 'Intuitivo'); ?>
            <input type="checkbox" id="Intuitivo-">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_self_taught', 'Autodidacta'); ?>
            <input type="checkbox" id="Autodidacta-">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_creative', 'Creativo'); ?>
            <input type="checkbox" id="Creativo-">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_proactive', 'Proactivo'); ?>
            <input type="checkbox" id="Proactivo-">
            <span class="checkmark"></span>
          </label>

          <label class="container_checkbox">
            <?php echo t('rec_desk_profile_comp_adaptable', 'Adaptable'); ?>
            <input type="checkbox" id="Adaptable-">
            <span class="checkmark"></span>
          </label>

        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <label><?php echo t('rec_desk_profile_additional_notes', 'Observaciones adicionales'); ?></label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-eye"></i></span>
            </div>
            <textarea name="observaciones_update" id="observaciones_update" class="form-control" rows="4"></textarea>
          </div>
        </div>
      </div>
    </form>

    <button type="button" class="btn btn-success btn-block text-lg" onclick="updateOrder('perfil')">
      <?php echo t('rec_desk_profile_btn_save', 'Guardar competencias requeridas para el puesto'); ?>
    </button>
  </div>
</div>

  </div>
  <!-- EDITAR INTAKE (nuevo) -->
  <div id="seccionEditarIntake" class="hidden">
    <div id="nombreRequisicionIntake" class="mb-3"></div>

    <form id="formIntakeUpdate">
      <input type="hidden" name="idReq" id="idReqIntake">
      <!-- si usas CSRF en CodeIgniter -->
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
        value="<?php echo $this->security->get_csrf_hash(); ?>">

      <div id="intakeFieldset" class="intake-grid"></div>

<div class="mt-3 d-flex gap-2">
  <button type="submit" class="btn btn-primary">
    <?php echo t('rec_common_save_changes', 'Guardar cambios'); ?>
  </button>

  <button type="button" class="btn btn-secondary" id="btnCancelarIntake">
    <?php echo t('rec_common_cancel', 'Cancelar'); ?>
  </button>
</div>

    </form>
  </div>


</div>

<!-- Sweetalert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
<?php i18n_js(['rec_']); ?>

<script>

$(document).ready(function() {
  let url_orders = '<?php echo base_url('Reclutamiento/requisicion'); ?>';
  let sortOption = '<?php echo $sortOrder ?>';
  let filterOption = '<?php echo $filter ?>';

  // Inicializa select2 para el buscador
  $('#buscador').select2({
    placeholder: "Selecciona",
    allowClear: false,
    width: '100%' // Asegura que el select ocupe todo el ancho del contenedor
  });

  // Función para cargar contenido
  function loadContent(url) {
    $.get(url, function(data) {
      $('#module-content').html(data);

      // Si quieres abrir un modal automáticamente, tendrías que llamarlo aquí, por ejemplo:
      // $('#confirmarPasswordModal').modal('show');
    }).fail(function(xhr, status, error) {
      console.error("Error en loadContent:", status, error, xhr.responseText);
      $('#module-content').html('<p>Error al cargar el contenido. Por favor, inténtalo de nuevo.</p>');
    });
  }


  // Manejo del cambio en el select de buscador
  $('#buscador').on('change', function() {
    const opcion = $(this).val(); // ahora será "60", no "#60 ..."
    if (opcion === "0") {
      regresarListado();
    } else if (opcion && opcion !== "") {
      const newUrl = url_orders + "?order=" + encodeURIComponent(opcion);
      loadContent(newUrl);
    }
    return false;
  });

  // Inicializa los valores de los selects para ordenar y filtrar
  $('#ordenar').val(sortOption).trigger('change');
  $('#filtrar').val(filterOption).trigger('change');

  // Manejo del cambio en el select de ordenar
  $('#ordenar').change(function() {
    let opcion = $(this).val();
    let filtrar = $('#filtrar').val();
    let filter = filtrar ? "?filter=" + filtrar : "";
    let sort = "?sort=" + opcion;

    var newUrl = url_orders + filter + sort;
    loadContent(newUrl); // Cargar el contenido sin cambiar la URL

    return false; // Prevenir el comportamiento predeterminado
  });

  // Manejo del cambio en el select de filtrar
  $('#filtrar').change(function() {
    let opcion = $(this).val();
    let ordenar = $('#ordenar').val();
    let sort = ordenar ? "?sort=" + ordenar : "";
    let filter = "?filter=" + opcion;

    var newUrl = url_orders + sort + filter;
    loadContent(newUrl); // Cargar el contenido sin cambiar la URL

    return false; // Prevenir el comportamiento predeterminado
  });


  $('.nav-link').click(function() {
    $('.nav-link').removeClass('active');
    $(this).addClass('active');
  })
  $('#link_vacante').click(function() {
    $('.div_info').css('display', 'none');
    $('#div_vacante').css('display', 'block');
  })
  $('#link_cargo').click(function() {
    $('.div_info').css('display', 'none');
    $('#div_cargo').css('display', 'block');
  })
  $('#link_perfil').click(function() {
    $('.div_info').css('display', 'none');
    $('#div_perfil').css('display', 'block');
  })
  $('#link_factura').click(function() {
    $('.div_info').css('display', 'none');
    $('#div_factura').css('display', 'block');
  })
  $('#estatus_escolaridad_update').change(function() {
    var opcion = $(this).val();
    if (opcion == "Otro") {
      $('#otro_estatus_update').prop('disabled', false);
    } else {
      $('#otro_estatus_update').prop('disabled', true);
      $('#otro_estatus_update').val('');
    }
  })
  $('#licencia_update').change(function() {
    var opcion = $(this).val();
    if (opcion != "No necesaria") {
      $('#tipo_licencia_update').prop('disabled', false);
    } else {
      $('#tipo_licencia_update').prop('disabled', true);
      $('#tipo_licencia_update').val('');
    }
  })
  $('#sueldo_adicional_update').change(function() {
    var opcion = $(this).val();
    if (opcion != "N/A") {
      $('#monto_adicional_update').prop('disabled', false);
    } else {
      $('#monto_adicional_update').prop('disabled', true);
      $('#monto_adicional_update').val('');
    }
  });
})

function regresarListado() {
  location.reload();
}

function cambiarStatusRequisicion(id, nombre, accion) {
  var titulo = '';
  var mensaje = '';
  var status = '';

  if (accion === 'iniciar') {
    titulo  = t('rec_desk_status_start_title', 'Confirmación de inicio de requisición');
    mensaje = t('rec_desk_status_start_msg', '¿Desea iniciar el proceso de la requisición <b>#{id} {nombre}</b>?', {
      '{id}': id,
      '{nombre}': nombre
    });
    status = 2;

  } else if (accion === 'detener') {
    titulo  = t('rec_desk_status_stop_title', 'Confirmación de detención de requisición');
    mensaje = t('rec_desk_status_stop_msg', '¿Desea detener el proceso de la requisición <b>#{id} {nombre}</b>?', {
      '{id}': id,
      '{nombre}': nombre
    });
    status = 1;
  }

  $('#titulo_mensaje').text(titulo);
  $('#mensaje').html(mensaje);
  $('#idRequisicion').val(id);

  $('#btnConfirmar').off('click').on('click', function() {
    confirmarAccion(status);
  });

  $('#mensajeModal').modal('show');
}


function confirmarAccion(status) {

  $('#mensajeModal').modal('hide');
  var idRequisicion = $('#idRequisicion').val();

  // ✅ Textos comunes (fallbacks)
  const TXT_SUCCESS = t('rec_common_success', 'Éxito');
  const TXT_ERROR   = t('rec_common_error', 'Error');
  const TXT_GENERIC_ERROR = t('rec_common_generic_error', 'Ocurrió un error. Intenta de nuevo.');
  const TXT_NETWORK_FAILED = t('rec_common_network_failed', 'Fallo de red');

  // Cambiar status (1/2)
  if (status == 1 || status == 2) {
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/cambiarStatusRequisicion'); ?>',
      type: 'post',
      data: {
        id: idRequisicion,
        status: status
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 300);

        var dato;
        try {
          dato = JSON.parse(res);
        } catch (e) {
          Swal.fire({ icon: 'error', title: TXT_ERROR, text: TXT_GENERIC_ERROR });
          return;
        }

        if (dato && dato.codigo === 1) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: dato.msg || TXT_SUCCESS,
            showConfirmButton: false,
            timer: 1500
          });

          setTimeout(function() {
            location.reload();
          }, 3000);

        } else {
          Swal.fire({
            icon: 'error',
            title: TXT_ERROR,
            text: (dato && dato.msg) ? dato.msg : TXT_GENERIC_ERROR
          });
        }
      },
      error: function(xhr) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 300);

        Swal.fire({
          icon: 'error',
          title: TXT_ERROR,
          text: xhr.statusText || TXT_NETWORK_FAILED
        });
      }
    });

  } else {
    // Eliminar
    let comentario = $('#mensaje_comentario').val();

    $.ajax({
      url: '<?php echo base_url('Reclutamiento/deleteOrder'); ?>',
      type: 'post',
      data: {
        id: idRequisicion,
        comentario: comentario
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 300);

        var dato;
        try {
          dato = JSON.parse(res);
        } catch (e) {
          Swal.fire({ icon: 'error', title: TXT_ERROR, text: TXT_GENERIC_ERROR });
          return;
        }

        if (dato && dato.codigo === 1) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: dato.msg || TXT_SUCCESS,
            showConfirmButton: false,
            timer: 2500
          });

          setTimeout(function() {
            location.reload();
          }, 2500);

        } else {
          Swal.fire({
            icon: 'error',
            title: TXT_ERROR,
            text: (dato && dato.msg) ? dato.msg : TXT_GENERIC_ERROR
          });
        }
      },
      error: function(xhr) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 300);

        Swal.fire({
          icon: 'error',
          title: TXT_ERROR,
          text: xhr.statusText || TXT_NETWORK_FAILED
        });
      }
    });
  }
}

// Helpers reutilizables
function escapeHtml(s) {
  if (s === null || s === undefined) return '';
  return String(s)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

function NR(v) {
  return (v === null || v === undefined || String(v).trim() === '') ? 'No registrado' : escapeHtml(v);
}

function fechaYMDaDMY(v) {
  if (!v) return 'No registrado';
  const m = String(v).match(/^(\d{4})[-/](\d{2})[-/](\d{2})/);
  return m ? `${m[3]}/${m[2]}/${m[1]}` : NR(v);
}

function siNo(v) {
  const s = String(v || '').toLowerCase();
  return s === 'si' ? 'Sí' : (s === 'no' ? 'No' : 'No registrado');
}

function verDetallesIntake(idIntake) {
  // ✅ Textos i18n
  const TXT_LOADING = t('rec_intake_loading', 'Cargando intake…');
  const TXT_ERROR   = t('rec_common_error', 'Error');
  const TXT_INVALID = t('rec_intake_invalid_response', 'Respuesta inválida del servidor.');
  const TXT_CLOSE   = t('rec_common_close', 'Cerrar');
  const TXT_FETCH_FAIL = t('rec_intake_fetch_failed', 'No se pudo obtener el intake.');
  const DASH = t('rec_common_dash', '—');
  const NR_TXT = t('rec_common_not_registered', 'No registrado');

  // Helpers locales (para que TODO quede localizado y escapado)
  const NR = (v) => (v === null || v === undefined || v === '') ? NR_TXT : escapeHtml(String(v));
  const siNoTxt = (v) => {
    const s = String(v || '').toLowerCase();
    if (s === 'si' || s === 'sí' || s === '1' || s === 'true') return t('rec_common_yes', 'Sí');
    if (s === 'no' || s === '0' || s === 'false') return t('rec_common_no', 'No');
    return DASH;
  };

  // Labels / Secciones
  const SEC_CONTACT = t('rec_intake_sec_contact', 'Datos de contacto');
  const SEC_COMPANY = t('rec_intake_sec_company', 'Empresa / Ubicación');
  const SEC_PLAN    = t('rec_intake_sec_plan_dates', 'Plan y fechas');
  const SEC_VOIP    = t('rec_intake_sec_voip_crm', 'VoIP / CRM');
  const SEC_REQS    = t('rec_intake_sec_requirements', 'Requisitos / Notas');
  const SEC_DOCS    = t('rec_intake_sec_docs', 'Documentos');

  const L_CLIENT_NAME   = t('rec_intake_lbl_client_name', 'Nombre cliente:');
  const L_EMAIL         = t('rec_intake_lbl_email', 'Correo:');
  const L_PHONE         = t('rec_intake_lbl_phone', 'Teléfono:');
  const L_CONTACT_METHOD= t('rec_intake_lbl_contact_method', 'Método contacto:');

  const L_BUSINESS_NAME = t('rec_intake_lbl_business_name', 'Razón social:');
  const L_TAX_ID        = t('rec_intake_lbl_tax_id', 'NIT/RFC:');
  const L_COUNTRY       = t('rec_intake_lbl_country', 'País:');
  const L_WEBSITE       = t('rec_intake_lbl_website', 'Sitio web:');
  const L_ACTIVITY      = t('rec_intake_lbl_activity', 'Actividad:');

  const L_PLAN          = t('rec_intake_lbl_plan', 'Plan:');
  const L_REQUEST_DATE  = t('rec_intake_lbl_request_date', 'Fecha solicitud:');
  const L_START_DATE    = t('rec_intake_lbl_start_date', 'Fecha inicio:');

  const L_REQ_VOIP      = t('rec_intake_lbl_requires_voip', '¿Requiere VoIP?');
  const L_VOIP_OWNER    = t('rec_intake_lbl_voip_ownership', 'Propiedad VoIP:');
  const L_VOIP_CITY     = t('rec_intake_lbl_voip_country_city', 'País/Ciudad VoIP:');

  const L_USE_CRM       = t('rec_intake_lbl_uses_crm', '¿Usa CRM?');
  const L_CRM           = t('rec_intake_lbl_crm', 'CRM:');

  const L_FUNCS         = t('rec_intake_lbl_functions', 'Funciones:');
  const L_REQS          = t('rec_intake_lbl_requirements', 'Requisitos:');
  const L_RESOURCES     = t('rec_intake_lbl_resources', 'Recursos:');
  const L_NOTES         = t('rec_intake_lbl_notes', 'Observaciones:');

  const L_UPLOADED_FILE = t('rec_intake_lbl_uploaded_file', 'Archivo cargado:');
  const L_TERMS         = t('rec_intake_lbl_terms', 'Términos:');
  const L_TERMS_OK      = t('rec_intake_lbl_terms_accepted', 'Términos aceptados:');

  const TXT_OPEN_FILE   = t('rec_intake_open_file', 'Abrir archivo');
  const TXT_OPEN_DOC    = t('rec_intake_open_document', 'Abrir documento');
  const TXT_ACCEPTED    = t('rec_intake_terms_yes', 'Aceptados');
  const TXT_NOT_ACCEPTED= t('rec_intake_terms_no', 'No aceptados');

  const L_CREATED       = t('rec_intake_lbl_created', 'Creado:');
  const L_LAST_EDIT     = t('rec_intake_lbl_last_edit', 'Última edición:');

  // 1) Modal de carga
  Swal.fire({
    title: TXT_LOADING,
    allowOutsideClick: false,
    didOpen: () => Swal.showLoading()
  });

  $.ajax({
    url: '<?php echo base_url('Reclutamiento/getDetailsOrderByIdIntake'); ?>',
    type: 'post',
    data: { id: idIntake },
    success: function(res) {
      let d;
      try {
        d = (typeof res === 'object') ? res : JSON.parse(res);
      } catch (e) {
        Swal.fire({ icon: 'error', title: TXT_ERROR, text: TXT_INVALID });
        return;
      }

      // Bases para links
      const baseMap = {
        archivo_path: ('<?php echo LINKDOCREQUICICION; ?>').replace(/\/?$/, '/'),
        terminos_file: ('<?php echo LINKAVISOS ?>').replace(/\/?$/, '/')
      };
      const isAbsUrl = v => /^https?:\/\//i.test(v || '');
      const isAbsPath = v => (v || '').startsWith('/');

      function link(key, fname, texto) {
        if (!fname) return DASH;
        const safeText = escapeHtml(texto || fname);
        const href = (isAbsUrl(fname) || isAbsPath(fname)) ? fname :
          (baseMap[key] ? baseMap[key] + encodeURIComponent(fname) : '#');
        return `<a href="${href}" target="_blank" rel="noopener">${safeText}</a>`;
      }

      const tituloH =
        `# ${escapeHtml(d.idReq || d.id || idIntake)} ${escapeHtml(d.nombre_c || d.nombre_cliente || '')}`;

      const html = `
        <style>
          .intake-grid{display:grid;min-width:700px;grid-template-columns:repeat(2,minmax(260px,1fr));gap:12px}
          .intake-title{grid-column:1/-1;background:#0C9DD3;color:#fff;border-left:4px solid #38bdf8;
                        padding:8px 10px;border-radius:6px;font-weight:700}
          .intake-muted{color:#475569;font-size:.9rem}
          .intake-full{grid-column:1/-1}
        </style>

        <div class="intake-grid">
          <div class="intake-title">${SEC_CONTACT}</div>
          <div><b>${L_CLIENT_NAME}</b><br>${NR(d.nombre_cliente)}</div>
          <div><b>${L_EMAIL}</b><br>${NR(d.email)}</div>
          <div><b>${L_PHONE}</b><br>${NR(d.telefono)}</div>
          <div><b>${L_CONTACT_METHOD}</b><br>${NR(d.metodo_comunicacion)}</div>

          <div class="intake-title">${SEC_COMPANY}</div>
          <div><b>${L_BUSINESS_NAME}</b><br>${NR(d.razon_social)}</div>
          <div><b>${L_TAX_ID}</b><br>${NR(d.nit)}</div>
          <div><b>${L_COUNTRY}</b><br>${NR(d.pais_empresa)}${
            String(d.pais_empresa||'').toUpperCase()==='OTRO' && d.pais_otro
              ? ' ('+escapeHtml(d.pais_otro)+')'
              : ''
          }</div>
          <div><b>${L_WEBSITE}</b><br>${
            d.sitio_web
              ? `<a href="${escapeHtml(d.sitio_web)}" target="_blank" rel="noopener">${escapeHtml(d.sitio_web)}</a>`
              : NR_TXT
          }</div>
          <div class="intake-full"><b>${L_ACTIVITY}</b><br>${NR(d.actividad)}</div>

          <div class="intake-title">${SEC_PLAN}</div>
          <div><b>${L_PLAN}</b><br>${NR(d.puesto || d.plan)}</div>
          <div><b>${L_REQUEST_DATE}</b><br>${fechaYMDaDMY(d.fecha_solicitud)}</div>
          <div><b>${L_START_DATE}</b><br>${fechaYMDaDMY(d.fecha_inicio)}</div>

          <div class="intake-title">${SEC_VOIP}</div>
          <div><b>${L_REQ_VOIP}</b><br>${siNoTxt(d.requiere_voip)}</div>
          <div>${
            String(d.requiere_voip||'').toLowerCase()==='si'
              ? `<b>${L_VOIP_OWNER}</b><br>${NR(d.voip_propiedad)}`
              : '&nbsp;'
          }</div>
          <div class="intake-full">${
            String(d.requiere_voip||'').toLowerCase()==='si'
              ? `<b>${L_VOIP_CITY}</b><br>${NR(d.voip_pais_ciudad)}`
              : ''
          }</div>
          <div><b>${L_USE_CRM}</b><br>${siNoTxt(d.usa_crm)}</div>
          <div>${
            String(d.usa_crm||'').toLowerCase()==='si'
              ? `<b>${L_CRM}</b><br>${NR(d.crm_nombre)}`
              : '&nbsp;'
          }</div>

          <div class="intake-title">${SEC_REQS}</div>
          <div class="intake-full"><b>${L_FUNCS}</b><br>${NR(d.funciones)}</div>
          <div class="intake-full"><b>${L_REQS}</b><br>${NR(d.requisitos)}</div>
          <div class="intake-full"><b>${L_RESOURCES}</b><br>${NR(d.recursos)}</div>
          <div class="intake-full"><b>${L_NOTES}</b><br>${NR(d.observaciones)}</div>

          <div class="intake-title">${SEC_DOCS}</div>
          <div><b>${L_UPLOADED_FILE}</b><br>${
            d.archivo_path ? link('archivo_path', d.archivo_path, TXT_OPEN_FILE) : DASH
          }</div>
          <div><b>${L_TERMS}</b><br>${
            d.terminos_file ? link('terminos_file', d.terminos_file, TXT_OPEN_DOC) : DASH
          }</div>
          <div><b>${L_TERMS_OK}</b><br>${
            d.acepta_terminos==1 ? TXT_ACCEPTED : (d.acepta_terminos==0 ? TXT_NOT_ACCEPTED : DASH)
          }</div>

          <div class="intake-full intake-muted">
            <b>${L_CREATED}</b> ${fechaYMDaDMY(d.creacionR || d.creacion)}
            &nbsp; | &nbsp;
            <b>${L_LAST_EDIT}</b> ${fechaYMDaDMY(d.edicion)}
          </div>
        </div>
      `;

      Swal.fire({
        title: tituloH,
        html: html,
        width: 900,
        showCloseButton: true,
        confirmButtonText: TXT_CLOSE,
        focusConfirm: false
      });
    },
    error: function(xhr) {
      Swal.fire({
        icon: 'error',
        title: TXT_ERROR,
        text: xhr.responseText || xhr.statusText || TXT_FETCH_FAIL
      });
    }
  });
}

// ENDPOINTS: define una sola vez (en layout)
window.ENDPOINTS = window.ENDPOINTS || {
  GET: "<?php echo base_url('Cat_Cliente/getLinkPortal'); ?>",
  SAVE: "<?php echo base_url('Cat_Cliente/saveLinkPortal'); ?>",
  DELETE: "<?php echo base_url('Cat_Cliente/deleteLinkPortal'); ?>"
};

// Utilidades
function csrfPair() {
  const name = document.querySelector('meta[name="csrf-name"]');
  const hash = document.querySelector('meta[name="csrf-hash"]');
  return name && hash ? {
    name: name.content,
    hash: hash.content
  } : null;
}

function updateCsrfFromResponse(resp) {
  if (resp && resp.csrf_name && resp.csrf_hash) {
    document.querySelector('meta[name="csrf-name"]').setAttribute('content', resp.csrf_name);
    document.querySelector('meta[name="csrf-hash"]').setAttribute('content', resp.csrf_hash);
  }
}

function shorten(url, max = 90) {
  if (!url) return '';
  return url.length > max ? url.slice(0, 45) + '…' + url.slice(-35) : url;
}

function truncateLink(link, maxLen) {
  if (!link) return '';
  if (link.length <= maxLen) return link;
  const left = Math.floor((maxLen - 1) * 0.55);
  const right = maxLen - 1 - left;
  return link.substr(0, left) + '…' + link.substr(link.length - right);
}

function copyText(text) {
  const temp = document.createElement('input');
  temp.value = text;
  document.body.appendChild(temp);
  temp.select();
  document.execCommand('copy');
  document.body.removeChild(temp);
}

// Render del modal (no registra handlers)
function renderQRModal(link, qr) {
  const TXT_NO_LINK      = t('rec_qr_no_link', 'Sin link');
  const TXT_NO_LINK_TTL  = t('rec_qr_no_link_title', 'No hay link');
  const TXT_QR_ALT       = t('rec_qr_alt', 'QR');
  const TXT_NO_QR_IMAGE  = t('rec_qr_no_image', 'Sin imagen de QR.');

  const display = link ? truncateLink(link, 60) : TXT_NO_LINK;

  $('#qrLinkDisplay')
    .text(display)
    .attr('href', link || '#')
    .attr('title', link || TXT_NO_LINK_TTL);

  $('#qrUrl').val(link || '');

  if (qr) {
    $('#qrPreviewWrapper').html(`<img src="${qr}" alt="${TXT_QR_ALT}">`);
  } else {
    $('#qrPreviewWrapper').html(`<p class="text-muted mb-0">${TXT_NO_QR_IMAGE}</p>`);
  }
}

// Abre y carga (llámala desde tu botón)
function openQrModal() {
  const TXT_QR_FETCH_FAIL = t('rec_qr_fetch_failed', 'No se pudo obtener la información del QR.');

  // Limpia UI
  renderQRModal('', null);
  $('#btnEliminarQR').prop('disabled', true);

  // Abre modal
  $('#qrModal').modal({
    backdrop: 'static',
    show: true
  });

  // Trae datos
  $.ajax({
    url: ENDPOINTS.GET,
    method: 'GET',
    dataType: 'json'
  }).done(function(resp) {
    const item = Array.isArray(resp) ? resp[0] : resp;
    const link = item && (item.link || item.url || null);
    const qr = item && (item.qr || item.qr_url || item.qrImage || null);

    renderQRModal(link, qr);
    $('#btnEliminarQR').prop('disabled', !(link || qr));
    updateCsrfFromResponse(resp);
  }).fail(function() {
    renderQRModal('', null);
    alert(TXT_QR_FETCH_FAIL);
  });
}


// ========= Handlers (registrar UNA sola vez) =========
$(function() {

  // ===== Textos i18n =====
  const TXT_ERROR         = t('rec_common_error', 'Error');
  const TXT_SUCCESS       = t('rec_common_success', 'Éxito');
  const TXT_COPIED        = t('rec_common_copied', 'Copiado');

  const TXT_QR_GEN_FAIL   = t('rec_qr_generate_failed', 'No se pudo generar/actualizar el QR.');
  const TXT_QR_UPDATED_OK = t('rec_qr_updated_ok', 'QR generado/actualizado correctamente.');
  const TXT_QR_NO_IMAGE   = t('rec_qr_no_image', 'Sin imagen de QR.');

  const TXT_AJAX_ERROR    = t('rec_common_ajax_error', 'Error en la petición AJAX');

  const TXT_QR_DELETED_OK = t('rec_qr_deleted_ok', 'QR eliminado.');
  const TXT_QR_DELETE_FAIL= t('rec_qr_delete_failed', 'No se pudo eliminar.');

  const TXT_COPY_OK       = t('rec_qr_copy_ok', 'Link copiado al portapapeles');
  const TXT_COPY_FAIL     = t('rec_qr_copy_failed', 'No se pudo copiar');

  // Copiar link mostrado (Generar/Actualizar)
  $("#btnGuardarQR").on("click", function() {

    var raw = ($("#idCliente").val() || "").trim();
    var idCliente = raw === "" ? null : parseInt(raw, 10);

    var data = {};
    if (idCliente !== null && !Number.isNaN(idCliente)) {
      data.id_cliente = idCliente;
    }

    var csrf = csrfPair();
    if (csrf) data[csrf.name] = csrf.hash;

    $.ajax({
        url: "<?php echo base_url('Cat_Cliente/generarLinkRequisicion'); ?>",
        type: "POST",
        data: data,
        dataType: "json"
      })
      .done(function(res) {
        updateCsrfFromResponse(res);

        var ok = (res && (res.success === true || !!res.link));
        var link = res && (res.link || res.url || null);
        var qrImage = res && (res.qr_image || res.qr || null);

        // msg viene del backend; NO lo traduzco (solo fallback si no viene)
        var msg = res && (res.mensaje || res.message || (ok ? 'OK' : TXT_ERROR));

        if (!ok || !link) {
          Swal.fire(TXT_ERROR, msg || TXT_QR_GEN_FAIL, "error");
          return;
        }

        $("#qrLinkDisplay")
          .attr("href", link)
          .attr("title", link)
          .text(shorten(link));

        if (qrImage) {
          $("#qrPreviewWrapper").html(
            '<img src="' + qrImage + '" class="img-fluid rounded border" style="max-width:220px;">'
          );
        } else {
          $("#qrPreviewWrapper").html('<p class="text-muted mb-0">' + TXT_QR_NO_IMAGE + '</p>');
        }

        $("#btnEliminarQR").prop("disabled", false);

        Swal.fire(TXT_SUCCESS, msg || TXT_QR_UPDATED_OK, "success");
      })
      .fail(function(xhr) {
        let m = (xhr.responseJSON && (xhr.responseJSON.error || xhr.responseJSON.message)) || TXT_AJAX_ERROR;
        Swal.fire(TXT_ERROR, m, "error");
      });
  });

  // Eliminar
  $("#btnEliminarQR").on("click", function() {

    var raw = ($("#idCliente").val() || "").trim();
    var idCliente = raw === "" ? null : parseInt(raw, 10);

    var data = {};
    if (idCliente !== null && !Number.isNaN(idCliente)) data.id_cliente = idCliente;

    var csrf = csrfPair();
    if (csrf) data[csrf.name] = csrf.hash;

    $.ajax({
        url: "<?php echo base_url('Cat_Cliente/eliminarLinkRequisicion'); ?>",
        type: "POST",
        data: data,
        dataType: "json"
      })
      .done(function(res) {
        updateCsrfFromResponse(res);

        if (res && (res.success === true || res.deleted === true)) {
          $("#qrLinkDisplay").attr("href", "#").attr("title", "").text("");
          $("#qrPreviewWrapper").empty();
          $("#btnEliminarQR").prop("disabled", true);

          Swal.fire(TXT_SUCCESS, TXT_QR_DELETED_OK, "success");
        } else {
          Swal.fire(TXT_ERROR, (res && (res.mensaje || res.error)) || TXT_QR_DELETE_FAIL, "error");
        }
      })
      .fail(function() {
        Swal.fire(TXT_ERROR, TXT_AJAX_ERROR, "error");
      });
  });

  // Copiar link
  $("#btnCopiarLink").on("click", function() {
    var link = $("#qrLinkDisplay").attr("href");
    if (!link || link === "#") return;

    navigator.clipboard.writeText(link).then(
      () => Swal.fire(TXT_COPIED, TXT_COPY_OK, "success"),
      () => alert(TXT_COPY_FAIL)
    );
  });

  // Limpieza visual al cerrar (opcional)
  $('#qrModal').on('hidden.bs.modal', function() {
    renderQRModal('', null);
    $('#btnEliminarQR').prop('disabled', true);
  });

});



function verDetalles(id) {
  $.ajax({
    url: '<?php echo base_url('Reclutamiento/getDetailsOrderById'); ?>',
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

      // ✅ Traducciones JS desde lang.php (cargadas por i18n_js)
      const NR = t('rec_common_not_registered', 'No registrado');

      $('#btnBack').css('display', 'block');
      $('#tarjetas').css('display', 'none');
      $('#divFiltros').css('display', 'none');
      $('#btnNuevaRequisicionCompleta').addClass('isDisabled');
      $('#btnNuevaRequisicion').addClass('isDisabled');
      $('#btnOpenAssignToUser').addClass('isDisabled');

      let nombres = (dato['nombre_comercial'] === '' || dato['nombre_comercial'] === null) ?
        dato['nombre'] :
        dato['nombre'] + '<br>' + dato['nombre_comercial'];

      $('#empresa').html('<h3># ' + dato['id'] + ' ' + nombres + '<br><b>' + dato['puesto'] + '</b></h3>');

      // =========================
      // Vacante
      // =========================
      $('#vacantes').html('<b>' + t('rec_desk_det_vacancies', 'Vacantes:') + '</b> ' + dato['numero_vacantes']);

      let escolaridad = dato['escolaridad'] ?? NR;
      $('#escolaridad').html('<b>' + t('rec_desk_det_required_education', 'Formación académica requerida:') +
        '</b> ' + escolaridad);

      let estatus_escolar = (dato['estatus_escolar'] == 'Otro') ?
        (dato['otro_estatus_escolar'] ?? NR) :
        (dato['estatus_escolar'] ?? NR);
      $('#estatus_escolar').html('<b>' + t('rec_desk_det_academic_status', 'Estatus académico:') + '</b> ' +
        estatus_escolar);

      let carrera_requerida = dato['carrera_requerida'] ?? NR;
      $('#carrera').html('<b>' + t('rec_desk_det_required_degree', 'Carrera requerida para el puesto:') +
        '</b> ' + carrera_requerida);

      let otros_estudios = (dato['otros_estudios'] === '' || dato['otros_estudios'] === null) ? NR : dato[
        'otros_estudios'];
      $('#otros_estudios').html('<b>' + t('rec_desk_det_other_studies', 'Otros estudios:') + '</b> ' +
        otros_estudios);

      let idiomas = (dato['idiomas'] == '' || dato['idiomas'] === null) ? NR : (dato['idiomas'] ?? NR);
      $('#idiomas').html('<b>' + t('rec_desk_det_languages', 'Idiomas:') + '</b> ' + idiomas);

      let hab_informatica = (dato['habilidad_informatica'] == '' || dato['habilidad_informatica'] === null) ? NR :
        (dato['habilidad_informatica'] ?? NR);
      $('#hab_informatica').html('<b>' + t('rec_desk_det_it_skills', 'Habilidades informáticas:') + '</b><br> ' +
        hab_informatica);

      let genero = dato['genero'] ?? NR;
      $('#sexo').html('<b>' + t('rec_desk_det_gender', 'Sexo:') + '</b> ' + genero);

      let estado_civil = dato['estado_civil'] ?? NR;
      $('#civil').html('<b>' + t('rec_desk_det_marital_status', 'Estado civil:') + '</b> ' + estado_civil);

      let edad_minima = dato['edad_minima'] ?? NR;
      $('#edad_min').html('<b>' + t('rec_desk_det_min_age', 'Edad mínima:') + '</b> ' + edad_minima);

      let edad_maxima = dato['edad_maxima'] ?? NR;
      $('#edad_max').html('<b>' + t('rec_desk_det_max_age', 'Edad máxima:') + '</b> ' + edad_maxima);

      let licencia = dato['licencia'] ?? NR;
      $('#licencia').html('<b>' + t('rec_desk_det_driver_license', 'Licencia de conducir:') + '</b> ' + licencia);

      let discapacidad_aceptable = dato['discapacidad_aceptable'] ?? NR;
      $('#discapacidad').html('<b>' + t('rec_desk_det_acceptable_disability', 'Discapacidad aceptable:') +
        '</b> ' + discapacidad_aceptable);

      let causa_vacante = dato['causa_vacante'] ?? NR;
      $('#causa').html('<b>' + t('rec_desk_det_vacancy_reason', 'Causa que origina la vacante:') + '</b><br> ' +
        causa_vacante);

      let lugar_residencia = (dato['lugar_residencia'] === '' || dato['lugar_residencia'] === null) ? NR : dato[
        'lugar_residencia'];
      $('#residencia').html('<b>' + t('rec_desk_det_residence', 'Lugar de residencia:') + '</b> ' +
        lugar_residencia);

      // =========================
      // Cargo
      // =========================
      let jornada_laboral = dato['jornada_laboral'] ?? NR;
      $('#jornada').html('<b>' + t('rec_desk_det_workday', 'Jornada laboral:') + '</b> ' + jornada_laboral);

      let tiempo_inicio = dato['tiempo_inicio'] ?? NR;
      $('#inicio').html('<b>' + t('rec_desk_det_workday_start', 'Inicio de la Jornada laboral:') + '</b> ' +
        tiempo_inicio);

      let tiempo_final = dato['tiempo_final'] ?? NR;
      $('#final').html('<b>' + t('rec_desk_det_workday_end', 'Fin de la Jornada laboral:') + '</b> ' +
        tiempo_final);

      let dias_descanso = dato['dias_descanso'] ?? NR;
      $('#descanso').html('<b>' + t('rec_desk_det_rest_days', 'Día(s) de descanso:') + '</b> ' + dias_descanso);

      let disponibilidad_viajar = dato['disponibilidad_viajar'] ?? NR;
      $('#viajar').html('<b>' + t('rec_desk_det_travel_availability', 'Disponibilidad para viajar:') + '</b> ' +
        disponibilidad_viajar);

      let disponibilidad_horario = dato['disponibilidad_horario'] ?? NR;
      $('#horario').html('<b>' + t('rec_desk_det_schedule_availability', 'Disponibilidad de horario:') + '</b> ' +
        disponibilidad_horario);

      let lugar_entrevista = (dato['lugar_entrevista'] === '' || dato['lugar_entrevista'] === null) ? NR : dato[
        'lugar_entrevista'];
      $('#lugar_entrevista_detalle').html('<b>' + t('rec_desk_det_interview_place', 'Lugar de la entrevista:') +
        '</b><br> ' + lugar_entrevista);

      let zona_trabajo = dato['zona_trabajo'] ?? NR;
      $('#zona').html('<b>' + t('rec_desk_det_work_zone', 'Zona de trabajo:') + '</b><br> ' + zona_trabajo);

      let sueldo = dato['sueldo'] ?? NR;
      $('#tipo_sueldo').html('<b>' + t('rec_desk_det_salary_type', 'Tipo de sueldo:') + '</b> ' + sueldo);

      let sueldo_min = (dato['sueldo_minimo'] == 0 || dato['sueldo_minimo'] === null) ? NR : dato[
        'sueldo_minimo'];
      $('#sueldo_min').html('<b>' + t('rec_desk_det_salary_min', 'Sueldo mínimo:') + '</b> ' + sueldo_min);

      let sueldo_maximo = (dato['sueldo_maximo'] == 0 || dato['sueldo_maximo'] === null) ? NR : dato[
        'sueldo_maximo'];
      $('#sueldo_max').html('<b>' + t('rec_desk_det_salary_max', 'Sueldo máximo:') + '</b> ' + sueldo_maximo);

      let sueldo_adicional = dato['sueldo_adicional'] ?? NR;
      $('#sueldo_adicional').html('<b>' + t('rec_desk_det_additional_salary', 'Sueldo adicional:') + '</b> ' +
        sueldo_adicional);

      $('#tipo_pago').html('<b>' + t('rec_desk_det_payment_type', 'Tipo de pago:') + '</b> ' + (dato[
        'tipo_pago_sueldo'] ?? NR));
      $('#tipo_prestaciones').html('<b>' + t('rec_desk_det_statutory_benefits', '¿Tendrá prestaciones de ley?') +
        '</b> ' + (dato['tipo_prestaciones'] ?? NR));

      let superiores = (dato['tipo_prestaciones_superiores'] == '' || dato['tipo_prestaciones_superiores'] ===
        null) ? NR : (dato['tipo_prestaciones_superiores'] ?? NR);
      $('#superiores').html('<b>' + t('rec_desk_det_superior_benefits',
        '¿Tendrá prestaciones superiores? ¿Cuáles?') + '</b><br> ' + superiores);

      let otras_prestaciones = (dato['otras_prestaciones'] == '' || dato['otras_prestaciones'] === null) ? NR : (
        dato['otras_prestaciones'] ?? NR);
      $('#otras_prestaciones').html('<b>' + t('rec_desk_det_other_benefits',
        '¿Tendrá otro tipo de prestaciones? ¿Cuáles?') + '</b><br> ' + otras_prestaciones);

      let experiencia = (dato['experiencia'] === '' || dato['experiencia'] === null) ? NR : dato['experiencia'];
      $('#experiencia').html('<b>' + t('rec_desk_det_experience', 'Experiencia:') + '</b><br> ' + experiencia);

      let actividades = dato['actividades'] ?? NR;
      $('#actividades').html('<b>' + t('rec_desk_det_activities', 'Actividades:') + '</b><br> ' + actividades);

      // =========================
      // Perfil del cargo
      // =========================
      let comp = NR;
      if (dato['competencias'] != null && dato['competencias'] !== '') {
        let aux = String(dato['competencias']).split('_');
        comp = aux.slice(0, -1);
      }
      $('#competencias').html('<b>' + t('rec_desk_det_required_competencies',
        'Competencias requeridas para el puesto:') + '</b><br> ' + comp);

      let observaciones = (dato['observaciones'] == '' || dato['observaciones'] === null) ? NR : (dato[
        'observaciones'] ?? NR);
      $('#observaciones').html('<b>' + t('rec_desk_det_additional_notes', 'Observaciones adicionales:') +
        '</b><br> ' + observaciones);

      // =========================
      // Facturación
      // =========================
      $('#telefono_req').html('<b>' + t('rec_desk_det_phone', 'Teléfono:') + '</b> ' + (dato['telefono'] ?? NR));

      let rfc = (dato['rfc'] === '' || dato['rfc'] === null) ? NR : dato['rfc'];
      $('#rfc').html('<b>' + t('rec_desk_det_rfc', 'RFC:') + '</b> ' + rfc);

      let correo = dato['correo'] ?? NR;
      $('#correo_req').html('<b>' + t('rec_desk_det_email', 'Correo:') + '</b> ' + correo);

      $('#contacto').html('<b>' + t('rec_desk_det_contact', 'Contacto:') + '</b> ' + (dato['contacto'] ?? NR));

      let forma_pago = dato['forma_pago'] ?? NR;
      $('#forma_pago').html('<b>' + t('rec_desk_det_payment_form', 'Forma de pago:') + '</b> ' + forma_pago);

      let metodo_pago = dato['metodo_pago'] ?? NR;
      $('#metodo_pago').html('<b>' + t('rec_desk_det_payment_method', 'Método de pago:') + '</b><br> ' +
        metodo_pago);

      let uso_cfdi = dato['uso_cfdi'] ?? NR;
      $('#cfdi').html('<b>' + t('rec_desk_det_cfdi_use', 'Uso de CFDI:') + '</b><br> ' + uso_cfdi);

      let regimen = dato['regimen'] ?? NR;
      $('#regimen').html('<b>' + t('rec_desk_det_tax_regime', 'Régimen fiscal:') + '</b> ' + regimen);

      let domicilio = (dato['domicilio'] === '' || dato['domicilio'] === null) ? NR : dato['domicilio'];
      let cp = (dato['cp'] === '' || dato['cp'] === null) ? NR : dato['cp'];
      $('#domicilio').html(
        '<b>' + t('rec_desk_det_tax_address', 'Domicilio fiscal:') + '</b> ' + domicilio +
        ' <b>' + t('rec_desk_det_postal_code', 'Código postal:') + '</b> ' + cp + '<br>'
      );

      $('#tarjeta_detalle').css('display', 'block');
    }

  });
}


//* Asignacion de Usuario a requisicion
function openAssignToUser() {
  let url = '<?php echo base_url('Reclutamiento/assignToUser'); ?>';

  $('#titulo_asignarUsuarioModal').text(
    t('rec_assign_modal_title', 'Asignar requisición a un reclutador')
  );

  $('label[for="asignar_usuario"]').text(
    t('rec_assign_recruiter_label', 'Reclutador *')
  );

  $('label[for="asignar_registro"]').text(
    t('rec_assign_req_label', 'Requisición *')
  );

  $('#asignar_usuario').attr("name", "asignar_usuario[]");
  $('#btnAsignar').attr("onclick", "assignToUser(\"" + url + "\",'requisicion')");
  $('#asignarUsuarioModal').modal('show');
}


function verExamenesCandidatos(id, nombre) {
  $(".nombreRegistro").text('#' + id + ' ' + nombre);
  $('#divContenido').empty();
  let salida = '';

  $.ajax({
    url: '<?php echo base_url('Reclutamiento/getTestsByOrder'); ?>',
    type: 'post',
    data: { 'id': id },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);

      // Textos i18n
      const TXT_CANDIDATE      = t('rec_tests_th_candidate', 'Candidato');
      const TXT_PROGRESS       = t('rec_tests_th_progress', 'Avances/Estatus');
      const TXT_ESE            = t('rec_tests_th_ese', 'ESE');
      const TXT_DOPING         = t('rec_tests_th_doping', 'Doping');
      const TXT_MEDICAL        = t('rec_tests_th_medical', 'Médico');
      const TXT_PSYCHOMETRIC   = t('rec_tests_th_psychometric', 'Psicometría');

      const TXT_DOWN_PDF       = t('rec_tests_tt_download_pdf', 'Descargar reporte PDF');
      const TXT_DOWN_PREVIEW   = t('rec_tests_tt_download_preview', 'Descargar reporte previo');
      const TXT_DOWN_DOPING    = t('rec_tests_tt_download_doping', 'Descargar doping');
      const TXT_DOWN_MEDICAL   = t('rec_tests_tt_download_medical', 'Descargar examen médico');
      const TXT_DOWN_PSYCHO    = t('rec_tests_tt_download_psychometric', 'Descargar examen psicométrico');
      const TXT_PROGRESS_MSGS  = t('rec_tests_tt_progress_messages', 'Mensajes de avances');

      const TXT_IN_PROCESS     = t('rec_common_in_process', 'En proceso');
      const TXT_PENDING        = t('rec_common_pending', 'Pendiente');
      const TXT_NOT_APPLIES    = t('rec_common_not_applicable', 'No aplica');

      const TXT_NO_CANDIDATES  = t('rec_tests_no_candidates', 'No hay candidatos con ESE para esta requisición');

      salida += '<table class="table table-striped" style="font-size: 14px">';
      salida += '<tr style="background: gray;color:white;">';
      salida += '<th>' + TXT_CANDIDATE + '</th>';
      salida += '<th>' + TXT_PROGRESS + '</th>';
      salida += '<th>' + TXT_ESE + '</th>';
      salida += '<th>' + TXT_DOPING + '</th>';
      salida += '<th>' + TXT_MEDICAL + '</th>';
      salida += '<th>' + TXT_PSYCHOMETRIC + '</th>';
      salida += '</tr>';

      if (res != 0) {
        var dato = JSON.parse(res);

        let socio = '';
        let previo = '';
        let colorESE = '';
        let colorDoping = '';
        let doping = '';
        let medico = '';
        let psicometria = '';

        for (let i = 0; i < dato.length; i++) {

          // ===== ESE =====
          if (dato[i]['status_bgc'] > 0) {
            switch (dato[i]['status_bgc']) {
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

            socio =
              '<div><form onsubmit="return downloadFile()" id="reporteForm' + dato[i]['idCandidato'] +
              '" action="<?php echo base_url('Candidato_Conclusion/createPDF'); ?>" method="POST">' +
              '<button type="submit" data-toggle="tooltip" title="' + TXT_DOWN_PDF + '" id="reportePDF" class="btn ' +
              colorESE + ' text-lg"><i class="fas fa-file-pdf"></i></button>' +
              '<input type="hidden" name="idCandidatoPDF" id="idCandidatoPDF' + dato[i]['idCandidato'] +
              '" value="' + dato[i]['idCandidato'] + '">' +
              '</form></div>';

          } else {
            previo = (dato[i]['fecha_nacimiento'] != null && dato[i]['fecha_nacimiento'] != '0000-00-00') ?
              ' <div><form onsubmit="return downloadFile()" id="reportePrevioForm' + dato[i]['idCandidato'] +
              '" action="<?php echo base_url('Candidato_Conclusion/createPrevioPDF'); ?>" method="POST">' +
              '<button type="submit" href="javascript:void(0);" data-toggle="tooltip" title="' + TXT_DOWN_PREVIEW +
              '" id="reportePrevioPDF" class="btn btn-secondary text-lg"><i class="far fa-file-powerpoint"></i></button>' +
              '<input type="hidden" name="idPDF" id="idPDF' + dato[i]['idCandidato'] +
              '" value="' + dato[i]['idCandidato'] + '">' +
              '</form></div>' : '';

            socio = TXT_IN_PROCESS;
          }

          // ===== Doping =====
          if (dato[i]['antidoping'] > 0) {
            if (dato[i]['resultado_doping'] !== -1 && dato[i]['resultado_doping'] !== null) {
              switch (dato[i]['resultado_doping']) {
                case '0':
                  colorDoping = 'btn-success';
                  break;
                case '1':
                  colorDoping = 'btn-danger';
                  break;
              }

              doping =
                '<div><form onsubmit="return downloadFile()" id="pdfForm' + dato[i]['idDoping'] +
                '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST">' +
                '<button type="submit" data-toggle="tooltip" title="' + TXT_DOWN_DOPING + '" id="pdfDoping" class="btn ' +
                colorDoping + ' text-lg"><i class="fas fa-file-pdf"></i></button>' +
                '<input type="hidden" name="idDop" id="idDop' + dato[i]['idDoping'] +
                '" value="' + dato[i]['idDoping'] + '">' +
                '</form></div>';

            } else {
              doping = TXT_PENDING;
            }
          } else {
            doping = TXT_NOT_APPLIES;
          }

          // ===== Médico =====
          if (dato[i]['medico'] > 0) {
            if (dato[i]['conclusionMedica'] !== null) {
              medico =
                '<div><form onsubmit="return downloadFile()" action="<?php echo base_url('Medico/crearPDF'); ?>" method="POST">' +
                '<button type="submit" data-toggle="tooltip" title="' + TXT_DOWN_MEDICAL + '" id="pdfFinal" class="btn btn-info text-lg">' +
                '<i class="fas fa-file-pdf"></i></button>' +
                '<input type="hidden" name="idMedico" id="idMedico' + dato[i]['idMedico'] +
                '" value="' + dato[i]['idMedico'] + '">' +
                '</form></div>';
            } else {
              medico = TXT_IN_PROCESS;
            }
          } else {
            medico = TXT_NOT_APPLIES;
          }

          // ===== Psicometría =====
          if (dato[i]['psicometrico'] > 0) {
            if (dato[i]['archivoPsicometria'] !== null) {
              psicometria =
                '<a href="' + url_psicometrias + dato[i]['archivoPsicometria'] +
                '" target="_blank" data-toggle="tooltip" title="' + TXT_DOWN_PSYCHO +
                '" class="btn btn-info text-lg"><i class="fas fa-file-pdf"></i></a>';
            } else {
              psicometria = TXT_IN_PROCESS;
            }
          } else {
            psicometria = TXT_NOT_APPLIES;
          }

          salida += "<tr>";
          salida += '<td>#' + dato[i]['idCandidato'] + ' ' + dato[i]['candidato'] + '</td>';
          salida +=
            '<td><a href="javascript:void(0)" data-toggle="tooltip" title="' + TXT_PROGRESS_MSGS +
            '" id="msj_avances" class="btn btn-primary" onclick="verMensajesAvances(' +
            dato[i]['idCandidato'] + ',\'' + dato[i]['candidato'] +
            '\')"><i class="fas fa-comment-dots"></i></a></td>';
          salida += '<td>' + previo + ' ' + socio + '</td>';
          salida += '<td>' + doping + '</td>';
          salida += '<td>' + medico + '</td>';
          salida += '<td>' + psicometria + '</td>';
          salida += "</tr>";
        }

      } else {
        salida += "<tr>";
        salida += '<td colspan="6" class="text-center"><h5>' + TXT_NO_CANDIDATES + '</h5></td>';
        salida += "</tr>";
      }

      salida += "</table>";
      $('#divContenido').html(salida);
      $("#resultadosModal").modal('show');
    }
  });
}

//* Edicion de la requisicion express


function openUpdateOrder(id, nombre, nombre_comercial, puesto) {
  $('#idRequisicion').val(id)
  let nombres = (nombre_comercial === '' || nombre_comercial === null) ? nombre : nombre + '<br>';
  $('#nombreRequisicion').html('<h3># ' + id + ' ' + nombres + '<br><b>' + puesto + '</b></h3>');
  $.ajax({
    url: '<?php echo base_url('Reclutamiento/getDetailsOrderById'); ?>',
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
      //Facturacion id_datos_facturacion id_domicilios_update
      $('#nombre_update').val(dato['razon_social']);
      $('#comercial_update').val(dato['nombre']);
      $('#pais_update').val(dato['pais']);
      $('#estado_update').val(dato['estado']);
      $('#ciudad_update').val(dato['ciudad']);
      $('#colonia_update').val(dato['colonia']);
      $('#calle_update').val(dato['calle']);
      $('#interior_update').val(dato['interior']);
      $('#exterior_update').val(dato['exterior']);
      $('#cp_update').val(dato['cp']);
      $('#regimen_update').val(dato['regimen']);
      $('#telefono_update').val(dato['telefono']);
      $('#correo_update').val(dato['correo']);
      $('#contacto_update').val(dato['contacto']);
      $('#rfc_update').val(dato['rfc']);
      $('#forma_pago_update').val(dato['forma_pago']);
      $('#metodo_pago_update').val(dato['metodo_pago']);
      $('#id_generales_update').val(dato['id_datos_generales']);
      $('#id_facturacion_update').val(dato['id_datos_facturacion']);
      $('#id_domicilios_update').val(dato['id_domicilios']);
      let cfdi = dato['uso_cfdi'] ?? 'Gastos en general';
      $('#uso_cfdi_update').val(cfdi);

      //Vacante
      $('#puesto_update').val(dato['puesto'])
      $('#num_vacantes_update').val(dato['numero_vacantes'])
      $('#escolaridad_update').val(dato['escolaridad'])
      $('#estatus_escolaridad_update').val(dato['estatus_escolar'])
      if (dato['estatus_escolar'] == 'Otro') {
        $('#otro_estatus_update').prop('disabled', false)
        $('#otro_estatus_update').val(dato['otro_estatus_escolar'])
      } else {
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
      if (dato['licencia'] !== '' && dato['licencia'] !== null) {
        let licencia = dato['licencia'].split(' ');
        $('#licencia_update').val(licencia[0])
        if (dato['licencia'] != 'No necesaria') {
          $('#tipo_licencia_update').prop('disabled', false)
          $('#tipo_licencia_update').val(licencia[1])
        } else {
          $('#tipo_licencia_update').prop('disabled', true)
          $('#tipo_licencia_update').val('')
        }
      } else {
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
      if (dato['sueldo_adicional'] !== '' && dato['sueldo_adicional'] !== null) {
        let sueldo_adicional = dato['sueldo_adicional'].split(' por ');
        $('#sueldo_adicional_update').val(sueldo_adicional[0])
        if (dato['sueldo_adicional'] != '"N/A') {
          $('#monto_adicional_update').prop('disabled', false)
          $('#monto_adicional_update').val(sueldo_adicional[1])
        } else {
          $('#monto_adicional_update').prop('disabled', true)
          $('#monto_adicional_update').val('')
        }
      } else {
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
      if (dato['competencias'] != null) {
        let competencias = '';
        let isIncluded = false;
        let auxiliar = dato['competencias'].split('_');
        competencias = auxiliar.slice(0, -1);
        console.log('Competencias obtenidas:', competencias);

        for (let i = 0; i < competencias.length; i++) {
          let competencia = competencias[i].replaceAll(' ', '-');
          console.log('Competencia actual:', competencia);
          $('#' + competencia).prop('checked', true);
        }
      }
      $('#observaciones_update').val(dato['observaciones'])
    }
  });
  $('#divFiltros').css('display', 'none')
  $('#seccionTarjetas').addClass('hidden')
  $('#btnBack').css('display', 'block');
  $('#seccionEditarRequisicion').css('display', 'block')
  $('#btnNuevaRequisicionCompleta').addClass('isDisabled')
  $('#btnNuevaRequisicion').addClass('isDisabled')
  $('#btnOpenAssignToUser').addClass('isDisabled')
}

function openUpdateOrderIntake(id) {
  $('#idReqIntake').val(id);

  $.ajax({
    url: '<?php echo base_url('Reclutamiento/getDetailsOrderByIdIntake'); ?>',
    type: 'POST',
    data: {
      id: id,
      '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
    },
    beforeSend: function() {
      $('.loader').show();
    },
    success: function(res) {
      setTimeout(() => $('.loader').fadeOut(), 200);

      const dato = typeof res === 'string' ? JSON.parse(res) : (res || {});

      // ✅ i18n
      const TXT_TITLE_PREFIX = t('rec_intake_edit_title_prefix', '#');
      // Encabezado
      const cliente  = dato.nombre_c || '';
      const empresa  = dato.nombre || '';
      const comercial = dato.razon_social || '';
      const puestoHdr = dato.puesto || dato.plan || '';
      const nombres = (comercial ? `${empresa}<br>${comercial}` : empresa);

      $('#nombreRequisicionIntake').html(
        `<h3>${TXT_TITLE_PREFIX} ${id} ${cliente}<br><b>${puestoHdr || ''}</b></h3>`
      );

      // Render dinámico
      renderIntakeForm(dato);

      // Mostrar sección INTAKE y ocultar lo demás
      $('#divFiltros').hide();
      $('#seccionTarjetas').addClass('hidden');
      $('#seccionEditarRequisicion').hide(); // <- el de las requis normales
      $('#btnBack').show();
      $('#seccionEditarIntake').show();
      $('#btnNuevaRequisicionCompleta, #btnNuevaRequisicion, #btnOpenAssignToUser').addClass('isDisabled');
    },
    error: function() {
      $('.loader').fadeOut();

      // ✅ i18n (antes: alert fijo)
      alert(t('rec_intake_edit_load_error', 'No se pudieron cargar los datos de la Solicitud.'));
    }
  });
}


/** Construye el formulario de INTAKE en base a un esquema */
function renderIntakeForm(dato, opts = {}) {
  // ===== i18n helper (JS) =====
  const TT = (key, fallback, repl) =>
    (typeof window.t === 'function') ? window.t(key, fallback, repl) : (fallback || key);

  const TXT = {
    select: TT('rec_common_select', '-- Selecciona --'),
    noFile: TT('rec_intake_no_file', 'Sin archivo cargado'),
    openFile: TT('rec_intake_open_file', 'Abrir archivo'),
    docsReadOnly: TT('rec_intake_docs_readonly', 'DOCUMENTOS, SOLO LECTURA'),
  };

  const cols = opts.cols || 3;
  const minWidth = opts.minWidth || 220;
  const compact = !!opts.compact;
  const theme = Object.assign({
    titleBg: '#1152eaff',
    titleColor: '#ffffff',
    titleBorder: '#38bdf8',
    labelColor: '#111827',
    labelBold: '700'
  }, opts.theme || {});

  const $wrap = $('#intakeFieldset').empty();
  $wrap
    .toggleClass('compact', compact)
    .css({
      display: 'grid',
      gap: '12px',
      gridTemplateColumns: `repeat(${cols}, minmax(${minWidth}px, 1fr))`,
      alignItems: 'start',
      padding: '15px',
      borderRadius: '6px',
      backgroundColor: '#fafafa',
    });

  const val = k => (dato && k in dato) ? (dato[k] ?? '') : '';

  const toISODate = s => {
    if (!s) return '';
    const m = String(s).match(/^(\d{4})[-\/](\d{2})[-\/](\d{2})/);
    if (m) return `${m[1]}-${m[2]}-${m[3]}`;
    const d = new Date(s);
    if (isNaN(d)) return '';
    const mm = String(d.getMonth() + 1).padStart(2, '0');
    const dd = String(d.getDate()).padStart(2, '0');
    return `${d.getFullYear()}-${mm}-${dd}`;
  };

  // Normaliza options: string -> {value,label}, object -> {value,label}
  const normOpt = (opt) => {
    if (opt && typeof opt === 'object') {
      return {
        value: opt.value ?? '',
        label: opt.label ?? String(opt.value ?? '')
      };
    }
    return {
      value: opt,
      label: (opt === '' ? TXT.select : String(opt))
    };
  };

  // ===== Secciones (ya con TT) =====
  const SECCIONES = [
    {
      titulo: TT('rec_intake_sec_identification', 'Identificación / Contacto'),
      campos: [
        { key:'nombre_cliente', label: TT('rec_intake_f_customer_name','Nombre del cliente'), type:'text', required:true },
        { key:'razon_social',   label: TT('rec_intake_f_legal_name','Razón social'), type:'text' },
        { key:'email',          label: TT('rec_intake_f_email','E-mail'), type:'email' },
        { key:'telefono',       label: TT('rec_intake_f_phone','Teléfono'), type:'tel' },
        { key:'sitio_web',      label: TT('rec_intake_f_website','Sitio web'), type:'url' },

        {
          key:'metodo_comunicacion',
          label: TT('rec_intake_f_main_contact_method','Método de comunicación principal'),
          type:'select',
          // value (BD) no cambia, label sí
          options: [
            { value:'', label: TXT.select },
            { value:'E-MAIL',         label: TT('rec_intake_opt_method_email','E-mail') },
            { value:'LLAMADA DE VOZ', label: TT('rec_intake_opt_method_call','Llamada de voz') },
            { value:'WHATSAPP',       label: TT('rec_intake_opt_method_whatsapp','WhatsApp') },
            { value:'OTRO',           label: TT('rec_intake_opt_method_other','Otro') },
          ]
        },

        { key:'actividad',    label: TT('rec_intake_f_business_activity','Actividad de la empresa'), type:'text' },
        { key:'nit',          label: TT('rec_intake_f_tax_id','Número de identificación tributaria'), type:'text' },
        {
          key:'miembro_bni',
          label: TT('rec_intake_f_bni_member','Miembro BNI'),
          type:'select',
          options: [
            { value:'', label: TXT.select },
            { value:'si', label: TT('rec_common_yes','Sí') },
            { value:'no', label: TT('rec_common_no','No') },
          ]
        },
        { key:'referido',     label: TT('rec_intake_f_referred_by','Referido'), type:'text' },
      ]
    },

    {
      titulo: TT('rec_intake_sec_company_location', 'Empresa / Ubicación'),
      campos: [
        {
          key:'pais_empresa',
          label: TT('rec_intake_f_company_country','País empresa'),
          type:'select',
          // Si tu BD guarda estos values tal cual, NO los cambies, solo traduce label si quieres
          options: [
            { value:'', label: TXT.select },
            { value:'CANADÁ', label: TT('rec_intake_country_canada','Canadá') },
            { value:'CHILE', label: TT('rec_intake_country_chile','Chile') },
            { value:'COLOMBIA', label: TT('rec_intake_country_colombia','Colombia') },
            { value:'COSTA RICA', label: TT('rec_intake_country_costarica','Costa Rica') },
            { value:'EEUU', label: TT('rec_intake_country_usa','EEUU') },
            { value:'ESPAÑA', label: TT('rec_intake_country_spain','España') },
            { value:'GUATEMALA', label: TT('rec_intake_country_guatemala','Guatemala') },
            { value:'MEXICO', label: TT('rec_intake_country_mexico','México') },
            { value:'PERÚ', label: TT('rec_intake_country_peru','Perú') },
            { value:'PUERTO RICO', label: TT('rec_intake_country_puertorico','Puerto Rico') },
            { value:'REPUBLICA DOMINICANA', label: TT('rec_intake_country_dominicana','República Dominicana') },
            { value:'VENEZUELA', label: TT('rec_intake_country_venezuela','Venezuela') },
            { value:'OTRO', label: TT('rec_common_other','Otro') },
          ]
        },
        { key:'pais_otro', label: TT('rec_intake_f_country_other','País (otro)'), type:'text', dependeDe:{ key:'pais_empresa', val:'OTRO' } },
        { key:'fecha_solicitud', label: TT('rec_intake_f_request_date','Fecha solicitud'), type:'date' },
        { key:'fecha_inicio', label: TT('rec_intake_f_start_date','Fecha de inicio'), type:'date' },

        {
          key:'plan',
          label: TT('rec_intake_f_plan','Plan'),
          type:'select',
          // Aquí igual: value no cambies si se guarda en BD
          options: [
            { value:'', label: TXT.select },
            { value:'ASISTENTE BÁSICO', label: TT('rec_intake_plan_basic','Asistente básico') },
            { value:'ASISTENTE BÁSICO BILINGUE', label: TT('rec_intake_plan_basic_bi','Asistente básico bilingüe') },
            { value:'AGENTE COMERCIAL/ADMINISTRATIVO', label: TT('rec_intake_plan_commercial','Agente comercial/administrativo') },
            { value:'AGENTE COMERCIAL/ADMINISTRATIVO BILINGUE', label: TT('rec_intake_plan_commercial_bi','Agente comercial/administrativo bilingüe') },
            { value:'GRADO TÉCNICO', label: TT('rec_intake_plan_tech','Grado técnico') },
            { value:'GRADO TÉCNICO BILINGUE', label: TT('rec_intake_plan_tech_bi','Grado técnico bilingüe') },
            { value:'GRADO PROFESIONAL', label: TT('rec_intake_plan_pro','Grado profesional') },
            { value:'GRADO PROFESIONAL BILINGUE', label: TT('rec_intake_plan_pro_bi','Grado profesional bilingüe') },
          ]
        },

        { key:'horario', label: TT('rec_intake_f_schedule','Horario'), type:'text' },
        {
          key:'sexo_preferencia',
          label: TT('rec_intake_f_gender_preference','Sexo preferencia'),
          type:'select',
          options: [
            { value:'', label: TXT.select },
            { value:'MASCULINO', label: TT('rec_common_male','Masculino') },
            { value:'FEMENINO', label: TT('rec_common_female','Femenino') },
            { value:'INDISTINTO', label: TT('rec_common_any','Indistinto') },
          ]
        },
        { key:'rango_edad', label: TT('rec_intake_f_age_range','Rango edad'), type:'text', placeholder: TT('rec_intake_ph_age_range','p.ej. 25-35') },
      ]
    },

    {
      titulo: TT('rec_intake_sec_requirements', 'Requisitos / Funciones'),
      campos: [
        { key:'funciones', label: TT('rec_intake_f_functions','Funciones a desempeñar'), type:'textarea' },
        { key:'requisitos', label: TT('rec_intake_f_requirements','Requisitos / habilidades'), type:'textarea' },
        { key:'recursos', label: TT('rec_intake_f_resources','Recursos técnicos / programas a utilizar'), type:'textarea' },
        { key:'observaciones', label: TT('rec_intake_f_notes','Observaciones'), type:'textarea' },
      ]
    },

    {
      titulo: TT('rec_intake_sec_voip_crm', 'VoIP / CRM'),
      campos: [
        { key:'requiere_voip', label: TT('rec_intake_f_voip_required','¿Servicio de telefonía VoIP adicional?'), type:'select',
          options:[ {value:'',label:TXT.select}, {value:'si',label:TT('rec_common_yes','Sí')}, {value:'no',label:TT('rec_common_no','No')} ] },

        { key:'voip_propiedad', label: TT('rec_intake_f_voip_owner','Telefonía VoIP que usará su teleoperador'), type:'select',
          dependeDe:{ key:'requiere_voip', val:'si' },
          options:[
            { value:'', label: TXT.select },
            { value:'Telefonía propia', label: TT('rec_intake_opt_voip_own','Telefonía propia') },
            { value:'A través de Asistente Virtual Ok.com', label: TT('rec_intake_opt_voip_ok','A través de Asistente Virtual Ok.com') },
          ]
        },

        { key:'voip_pais_ciudad', label: TT('rec_intake_f_voip_city','País/Ciudad de la VoIP requerida'), type:'text', dependeDe:{ key:'requiere_voip', val:'si' } },

        { key:'usa_crm', label: TT('rec_intake_f_crm_used','¿Uso de algún CRM?'), type:'select',
          options:[ {value:'',label:TXT.select}, {value:'si',label:TT('rec_common_yes','Sí')}, {value:'no',label:TT('rec_common_no','No')} ] },

        { key:'crm_nombre', label: TT('rec_intake_f_crm_name','Nombre CRM utilizado'), type:'text', dependeDe:{ key:'usa_crm', val:'si' } },
      ]
    },

    {
      titulo: TXT.docsReadOnly,
      campos: [
        { key:'creacionR', label: TT('rec_intake_f_created_at','Fecha de registro'), type:'text', readonly:true },
        {
          key:'archivo_path',
          label: TT('rec_intake_f_uploaded_files','Archivos cargados'),
          type:'link',
          linkText: TXT.openFile,
          hideWhenEmpty: true,
          readonly: true,
          emptyText: TXT.noFile
        },
        {
          key:'terminos_file',
          label: TT('rec_intake_f_terms_doc','Documento de términos y condiciones'),
          type:'link',
          linkText: TXT.openFile,
          hideWhenEmpty: true,
          readonly: true,
          emptyText: TXT.noFile
        }
      ]
    }
  ];

  // ===== render helpers =====
  const renderTitulo = (texto) => {
    $wrap.append(`
      <div class="col-span-title" style="grid-column: 1 / -1; margin: 10px 0;">
        <div style="
          background: ${theme.titleBg};
          color: ${theme.titleColor};
          border-left: 4px solid ${theme.titleBorder};
          padding: 6px 10px;
          border-radius: 6px;
          font-weight: 700;
          font-size: 0.95rem;
        ">${texto}</div>
      </div>
    `);
  };

  const renderCampo = (f) => {
    const show = !f.dependeDe || String(val(f.dependeDe.key)).toLowerCase() === String(f.dependeDe.val).toLowerCase();
    const group = $('<div class="form-group"></div>').attr('data-key', f.key);
    if (!show) group.hide();

    group.append(
      `<label for="in_${f.key}" style="font-weight:600;font-size:0.95rem;margin-bottom:4px;display:block;text-transform:uppercase;">
        ${f.label}${f.required ? ' *' : ''}
      </label>`
    );

    let $input;

    switch (f.type) {
      case 'textarea':
        $input = $(`<textarea class="form-control" id="in_${f.key}" name="${f.key}" rows="3" ${f.readonly?'readonly':''}></textarea>`);
        $input.val(val(f.key));
        break;

      case 'select':
        $input = $(`<select class="form-control" id="in_${f.key}" name="${f.key}" ${f.readonly?'disabled':''}></select>`);
        (f.options || ['']).forEach(opt => {
          const o = normOpt(opt);
          const $o = $('<option></option>').attr('value', o.value).text(o.label);
          if (String(val(f.key)).toLowerCase() === String(o.value).toLowerCase()) $o.prop('selected', true);
          $input.append($o);
        });
        break;

      case 'date':
        $input = $(`<input type="date" class="form-control" id="in_${f.key}" name="${f.key}" ${f.readonly?'readonly':''}>`);
        $input.val(toISODate(val(f.key)));
        break;

      case 'link': {
        const filename = val(f.key);

        const baseMap = {
          archivo_path: (<?php echo json_encode(LINKDOCREQUICICION) ?> || '').replace(/\/?$/, '/'),
          terminos_file: (<?php echo json_encode(LINKAVISOS) ?> || '').replace(/\/?$/, '/'),
        };

        const isAbsUrl = v => /^https?:\/\//i.test(v || '');
        const isAbsPath = v => (v || '').startsWith('/');

        const hideWhenEmpty = !!f.hideWhenEmpty;
        const emptyText = f.emptyText || TXT.noFile;

        if (filename) {
          let url = '#';
          if (isAbsUrl(filename) || isAbsPath(filename)) {
            url = filename;
          } else {
            const base = baseMap[f.key] || '';
            url = base ? (base + encodeURIComponent(filename)) : '#';
          }
          $input = $(`<a id="in_${f.key}" target="_blank" rel="noopener"></a>`)
            .attr('href', url)
            .text(f.linkText || filename);
        } else {
          if (hideWhenEmpty) { group.hide(); break; }
          $input = $(`<span id="in_${f.key}" class="text-muted"></span>`).text(emptyText);
        }
        break;
      }

      default:
        $input = $(`<input type="${f.type||'text'}" class="form-control" id="in_${f.key}" name="${f.key}" ${f.readonly?'readonly':''} placeholder="${f.placeholder||''}">`);
        $input.val(val(f.key));
        break;
    }

    if (f.required) $input.prop('required', true);

    if (f.dependeDe) {
      const master = f.dependeDe.key;
      const ns = '.dep_' + master + '_' + f.key;

      $(document).off('change' + ns).on('change' + ns, '#in_' + master, function() {
        const on = String($(this).val()).toLowerCase() === String(f.dependeDe.val).toLowerCase();
        const $g = $('[data-key="' + f.key + '"]');
        on ? $g.slideDown(120) : $g.slideUp(120);
      });
    }

    group.append($input);
    $wrap.append(group);
  };

  // ===== paint =====
  SECCIONES.forEach(sec => {
    renderTitulo(sec.titulo);
    sec.campos.forEach(renderCampo);
  });

  $('#in_requiere_voip').trigger('change');
  $('#in_usa_crm').trigger('change');
  $('#in_pais_empresa').trigger('change');
}




/** Serializa el formulario de intake en un objeto */
function serializeIntakeForm() {
  const data = {};
  $('#formIntakeUpdate').serializeArray().forEach(p => {
    if (data[p.name] !== undefined) {
      if (!Array.isArray(data[p.name])) data[p.name] = [data[p.name]];
      data[p.name].push(p.value);
    } else {
      data[p.name] = p.value;
    }
  });
  return data;
}

/** Guarda cambios de INTAKE (AJAX POST) */
/** Guarda cambios de INTAKE (AJAX POST) */
$(document).on('submit', '#formIntakeUpdate', function(e) {
  e.preventDefault();

  const TT = (key, fallback, repl) =>
    (typeof window.t === 'function') ? window.t(key, fallback, repl) : (fallback || key);

  const payload = serializeIntakeForm();

  $.ajax({
    url: '<?php echo base_url('Reclutamiento/updateIntake'); ?>',
    type: 'POST',
    data: payload,
    beforeSend: function() {
      $('.loader').show();
    },
    success: function(r) {
      $('.loader').fadeOut();

      try { r = (typeof r === 'string') ? JSON.parse(r) : r; } catch (e) { r = null; }

      // ✅ acepta {success:true} o {codigo:1}
      const ok = !!(r && (r.success === true || r.codigo === 1));

      if (ok) {
        if (window.Swal) {
          Swal.fire({
            icon: 'success',
            title: TT('rec_intake_save_ok_title', 'Guardado'),
            text: TT('rec_intake_save_ok_text', 'Cambios guardados correctamente.'),
            timer: 1800,
            showConfirmButton: false
          });
        } else {
          alert(TT('rec_intake_save_ok_text', 'Cambios guardados correctamente.'));
        }
        return;
      }

      // ❌ no ok
      if (window.Swal) {
        Swal.fire({
          icon: 'warning',
          title: TT('rec_common_attention', 'Atención'),
          text: TT('rec_intake_save_fail_text', 'No se pudo guardar. Verifica la información e intenta de nuevo.'),
          confirmButtonText: TT('rec_common_close', 'Cerrar')
        });
      } else {
        alert(TT('rec_intake_save_fail_text', 'No se pudo guardar. Verifica la información e intenta de nuevo.'));
      }
    },
    error: function() {
      $('.loader').fadeOut();

      if (window.Swal) {
        Swal.fire({
          icon: 'error',
          title: TT('rec_common_error', 'Error'),
          text: TT('rec_intake_save_error_text', 'Ocurrió un error al guardar. Intenta nuevamente.'),
          confirmButtonText: TT('rec_common_close', 'Cerrar')
        });
      } else {
        alert(TT('rec_intake_save_error_text', 'Ocurrió un error al guardar. Intenta nuevamente.'));
      }
    }
  });
});


/** Botón cancelar (vuelve a las tarjetas) */
$(document).on('click', '#btnCancelarIntake', function() {
  $('#seccionEditarIntake').hide();
  $('#seccionTarjetas').removeClass('hidden').show();
  $('#divFiltros').show();
  $('#btnBack').hide();
});

/** Helpers */
function toISODate(s) {
  if (!s) return '';
  // intenta YYYY-MM-DD, o parsea y formatea
  const m = String(s).match(/^(\d{4})[-\/](\d{2})[-\/](\d{2})/);
  if (m) return `${m[1]}-${m[2]}-${m[3]}`;
  const d = new Date(s);
  if (isNaN(d)) return '';
  const mm = String(d.getMonth() + 1).padStart(2, '0');
  const dd = String(d.getDate()).padStart(2, '0');
  return `${d.getFullYear()}-${mm}-${dd}`;
}


function updateOrder(section) {
  const TT = (key, fallback, repl) =>
    (typeof window.t === 'function') ? window.t(key, fallback, repl) : (fallback || key);

  let form = '';

  if (section == 'data_facturacion') {
    form = $('#formDatosFacturacionRequisicion').serialize();
    form += '&id_requisicion=' + $('#idRequisicion').val();
    form += '&section=' + section;
  }
  if (section == 'vacante') {
    let licencia = $('#licencia_update').val();
    let tipo_licencia = $('#tipo_licencia_update').val();
    form = $('#formVacante').serialize();
    form += '&id_requisicion=' + $('#idRequisicion').val();
    form += '&section=' + section;
    form += '&licencia_completa=' + licencia + ' ' + tipo_licencia;
  }
  if (section == 'cargo') {
    let sueldo_adicional = $('#sueldo_adicional_update').val();
    let monto_adicional = $('#monto_adicional_update').val();
    form = $('#formCargo').serialize();
    form += '&id_requisicion=' + $('#idRequisicion').val();
    form += '&section=' + section;
    form += '&sueldo_adicional_completo=' + sueldo_adicional + ' por ' + monto_adicional;
  }
  if (section == 'perfil') {
    let competenciasValues = '';
    form = $('#formPerfil').serialize();
    let competenciasChecked = $("input:checkbox").map(function() {
      if ($(this).is(":checked") == true) return this.id;
    }).get().join('_');

    if (competenciasChecked != '') {
      competenciasValues = competenciasChecked.replaceAll('-', ' ') + '_';
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
      setTimeout(function() { $('.loader').fadeOut(); }, 300);

      let dato;
      try { dato = (typeof res === 'string') ? JSON.parse(res) : res; }
      catch (e) {
        Swal.fire({
          icon: 'error',
          title: TT('rec_common_error', 'Error'),
          text: TT('rec_common_invalid_response', 'Respuesta inválida del servidor.')
        });
        return;
      }

      // ✅ Mensaje 100% FRONT (según sección)
      const okTitleBySection = {
        data_facturacion: TT('rec_order_saved_billing', 'Datos de facturación guardados'),
        vacante:          TT('rec_order_saved_vacancy', 'Información de la vacante guardada'),
        cargo:            TT('rec_order_saved_role', 'Información del cargo guardada'),
        perfil:           TT('rec_order_saved_profile', 'Perfil del cargo guardado'),
      };

      if (String(dato.codigo) === '1') {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: okTitleBySection[section] || TT('rec_common_saved', 'Guardado correctamente'),
          showConfirmButton: false,
          timer: 2500
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: TT('rec_common_problem', 'Hubo un problema'),
          text: TT('rec_common_try_again', 'No se pudo guardar la información. Intenta de nuevo.'),
          confirmButtonText: TT('rec_common_close', 'Cerrar')
        });

        // (Opcional) si quieres ver el msg técnico SIN mostrárselo al usuario:
        // console.warn('BACK msg:', dato.msg);
      }
    },
    error: function(xhr) {
      $('.loader').fadeOut();
      Swal.fire({
        icon: 'error',
        title: TT('rec_common_problem', 'Hubo un problema'),
        text: TT('rec_common_network_error', 'Fallo de red. Intenta nuevamente.'),
        confirmButtonText: TT('rec_common_close', 'Cerrar')
      });
    }
  });
}



//* Eliminar usuario de la requisicion
function openDeleteUserOrder(id, id_requisicion, nombre) {
  const TT = (key, fallback, repl) =>
    (typeof window.t === 'function') ? window.t(key, fallback, repl) : (fallback || key);

  let url = '<?php echo base_url('Reclutamiento/deleteUserOrder'); ?>';

  // Limpia campos extra por si venías de "eliminar requisición"
  $('#campos_mensaje').html('');

  $('#titulo_mensaje').text(
    TT('rec_order_del_user_title', 'Confirmar eliminación de usuario en la requisición')
  );

  $('#mensaje').html(
    TT(
      'rec_order_del_user_msg',
      '¿Desea eliminar al usuario <b>{name}</b> de la requisición <b>#{req}</b>?',
      { '{name}': nombre, '{req}': id_requisicion }
    )
  );

  $('#idRequisicion').val(id);

  // OK: aquí sí necesitas pasar id y url a tu función deleteUserOrder
  $('#btnConfirmar').off('click').on('click', function () {
    deleteUserOrder(id, url);
  });

  $('#mensajeModal').modal('show');
}


function openDeleteOrder(id, name) {
  const TT = (key, fallback, repl) =>
    (typeof window.t === 'function') ? window.t(key, fallback, repl) : (fallback || key);

  $('#titulo_mensaje').html(
    '<i class="fa fa-exclamation-triangle text-warning"></i> ' +
    TT('rec_order_del_title', 'Eliminar requisición')
  );

  const confirmTxt = TT('rec_common_confirm', 'Confirmar');
  const cancelTxt  = TT('rec_common_cancel', 'Cancelar');

  $('#mensaje').html(
    TT(
      'rec_order_del_msg',
      '¿Seguro que deseas eliminar la requisición <b>#{id} {name}</b>? Esta acción es permanente. ' +
      'Para continuar, presiona <b>{confirm}</b>, o <b>{cancel}</b> si no deseas eliminarla.',
      { '{id}': id, '{name}': name, '{confirm}': confirmTxt, '{cancel}': cancelTxt }
    )
  );

  $('#idRequisicion').val(id);

  $('#campos_mensaje').html(
    '<div class="row"><div class="col-12">' +
      '<label>' + TT('rec_order_del_reason', 'Motivo de eliminación *') + '</label>' +
      '<textarea class="form-control" rows="3" id="mensaje_comentario" name="mensaje_comentario" ' +
      'placeholder="' + TT('rec_order_del_reason_ph', 'Escribe el motivo…') + '"></textarea>' +
    '</div></div>'
  );

  // Tu confirmarAccion(3) ya toma #idRequisicion y #mensaje_comentario
  $('#btnConfirmar').off('click').on('click', function() {
    confirmarAccion(3);
  });

  $('#mensajeModal').modal('show');
}




function verMensajesAvances(id_candidato, candidato) {
  $('#avancesModal #nombreCandidato').text(candidato)
  $("#idCandidato").val(id_candidato);
  getMensajesAvances(id_candidato, candidato);
  $("#avancesModal").modal("show");
}

function getMensajesAvances(id_candidato, candidato) {
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

function confirmarEditarAvance(id) {
  const TT = (key, fallback, repl) =>
    (typeof window.t === 'function') ? window.t(key, fallback, repl) : (fallback || key);

  let msj = ($('#avanceMensaje' + id).val() || '').trim();

  const fileEl = document.getElementById('avanceArchivo' + id);
  let msj_archivo = '';
  if (fileEl && fileEl.files && fileEl.files.length > 0) {
    let filename = fileEl.files[0].name;
    msj_archivo =
      '<br>' + TT('rec_adv_edit_confirm_file_line', '¿Y la imagen?') +
      '<br><b>' + filename + '</b>';
  }

  $('#titulo_mensaje').text(
    TT('rec_adv_edit_confirm_title', 'Confirmar modificación de avance')
  );

  $('#mensaje').html(
    TT(
      'rec_adv_edit_confirm_msg',
      '¿Desea confirmar el mensaje?<br><b>"{msg}"</b>{fileLine}',
      { '{msg}': escapeHtml(msj), '{fileLine}': msj_archivo }
    )
  );

  $('#btnConfirmar').off('click').on('click', function () {
    editarAvance(id, msj);
  });

  $('#mensajeModal').modal('show');
}

function editarAvance(id, msj) {
  const TT = (key, fallback, repl) =>
    (typeof window.t === 'function') ? window.t(key, fallback, repl) : (fallback || key);

  let id_candidato = $("#idCandidato").val();
  let candidato = $('#avancesModal #nombreCandidato').text();

  // Validación mínima
  const fileEl = $("#avanceArchivo" + id)[0];
  const file = (fileEl && fileEl.files && fileEl.files[0]) ? fileEl.files[0] : null;
  const cleanMsg = (msj || '').trim();

  if (!cleanMsg && !file) {
    Swal.fire({
      icon: 'warning',
      title: TT('rec_adv_need_content_title', 'Falta información'),
      text: TT('rec_adv_need_content_text', 'Escribe un comentario o adjunta un archivo.'),
      confirmButtonText: TT('rec_common_ok', 'OK')
    });
    return;
  }

  let datos = new FormData();
  datos.append('id', id);
  datos.append('msj', cleanMsg);
  if (file) datos.append('archivo', file);

  $.ajax({
    url: '<?php echo base_url('Avance/editar'); ?>',
    type: 'post',
    data: datos,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function () {
      $('.loader').css("display", "block");
    },
    success: function (res) {
      $('#mensajeModal').modal('hide');
      setTimeout(function () { $('.loader').fadeOut(); }, 300);

      let dato;
      try { dato = (typeof res === 'object') ? res : JSON.parse(res); } catch (e) { dato = null; }

      if (dato && Number(dato.codigo) === 1) {
        getMensajesAvances(id_candidato, candidato);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: TT('rec_adv_edit_ok_title', 'Avance actualizado'),
          text: TT('rec_adv_edit_ok_text', 'Los cambios se guardaron correctamente.'),
          showConfirmButton: false,
          timer: 2000
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: TT('rec_adv_error_title', 'Hubo un problema'),
          text: TT('rec_adv_edit_error_text', 'No se pudo actualizar el avance. Intenta de nuevo.'),
          confirmButtonText: TT('rec_common_close', 'Cerrar')
        });
      }
    },
    error: function () {
      $('#mensajeModal').modal('hide');
      $('.loader').fadeOut();
      Swal.fire({
        icon: 'error',
        title: TT('rec_adv_error_title', 'Hubo un problema'),
        text: TT('rec_common_network_error', 'Fallo de red. Intenta de nuevo.'),
        confirmButtonText: TT('rec_common_close', 'Cerrar')
      });
    }
  });
}

function confirmarEliminarAvance(id) {
  const TT = (key, fallback, repl) =>
    (typeof window.t === 'function') ? window.t(key, fallback, repl) : (fallback || key);

  let msj = ($('#avanceMensaje' + id).val() || '').trim();

  $('#titulo_mensaje').text(
    TT('rec_adv_del_confirm_title', 'Confirmar eliminación de avance')
  );

  $('#mensaje').html(
    TT(
      'rec_adv_del_confirm_msg',
      '¿Desea eliminar el mensaje?<br><b>"{msg}"</b>',
      { '{msg}': escapeHtml(msj) }
    )
  );

  $('#btnConfirmar').off('click').on('click', function () {
    eliminarAvance(id);
  });

  $('#mensajeModal').modal('show');
}

function eliminarAvance(id) {
  const TT = (key, fallback, repl) =>
    (typeof window.t === 'function') ? window.t(key, fallback, repl) : (fallback || key);

  let id_candidato = $("#idCandidato").val();
  let candidato = $('#avancesModal #nombreCandidato').text();

  $.ajax({
    url: '<?php echo base_url('Avance/eliminar'); ?>',
    type: 'POST',
    data: { id: id },
    beforeSend: function () {
      $('.loader').css("display", "block");
    },
    success: function (res) {
      $('#mensajeModal').modal('hide');
      setTimeout(function () { $('.loader').fadeOut(); }, 300);

      let dato;
      try { dato = (typeof res === 'object') ? res : JSON.parse(res); } catch (e) { dato = null; }

      if (dato && Number(dato.codigo) === 1) {
        getMensajesAvances(id_candidato, candidato);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: TT('rec_adv_del_ok_title', 'Avance eliminado'),
          text: TT('rec_adv_del_ok_text', 'El avance se eliminó correctamente.'),
          showConfirmButton: false,
          timer: 2000
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: TT('rec_adv_error_title', 'Hubo un problema'),
          text: TT('rec_adv_del_error_text', 'No se pudo eliminar el avance. Intenta de nuevo.'),
          confirmButtonText: TT('rec_common_close', 'Cerrar')
        });
      }
    },
    error: function () {
      $('#mensajeModal').modal('hide');
      $('.loader').fadeOut();
      Swal.fire({
        icon: 'error',
        title: TT('rec_adv_error_title', 'Hubo un problema'),
        text: TT('rec_common_network_error', 'Fallo de red. Intenta de nuevo.'),
        confirmButtonText: TT('rec_common_close', 'Cerrar')
      });
    }
  });
}


function nuevaRequisicionIntake() {
  const TT = (key, fallback, repl) =>
    (typeof window.t === 'function') ? window.t(key, fallback, repl) : (fallback || key);

  $('#modalRequisiciones').modal('show');

  $('#contenedorTabla').html(
    '<p class="text-center text-muted">' + TT('rec_intake_links_loading', 'Cargando enlaces...') + '</p>'
  );

  $.ajax({
    url: '<?php echo base_url('Reclutamiento/get_links'); ?>',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response && response.success && Array.isArray(response.data) && response.data.length) {
        renderTablaRequisiciones(response.data);
      } else {
        $('#contenedorTabla').html(
          '<p class="text-center text-warning">' + TT('rec_intake_links_empty', 'No hay enlaces disponibles.') + '</p>'
        );
      }
    },
    error: function() {
      $('#contenedorTabla').html(
        '<p class="text-center text-danger">' + TT('rec_intake_links_error', 'Error al cargar los enlaces.') + '</p>'
      );
    }
  });
}

function renderTablaRequisiciones(data) {
  const TT = (key, fallback, repl) =>
    (typeof window.t === 'function') ? window.t(key, fallback, repl) : (fallback || key);

  let html = `
    <table class="table table-hover table-sm">
      <thead class="thead-dark">
        <tr>
          <th>${TT('rec_common_number', '#')}</th>
          <th>${TT('rec_common_name', 'Nombre')}</th>
          <th class="text-center">${TT('rec_common_action', 'Acción')}</th>
        </tr>
      </thead>
      <tbody>
  `;

  data.forEach((item, index) => {
    const nombre = item && item.nombre ? escapeHtml(item.nombre) : '—';
    const link = item && item.link ? item.link : '#';

    html += `
      <tr>
        <td>${index + 1}</td>
        <td>${nombre}</td>
        <td class="text-center">
          <a href="${link}" class="btn btn-sm btn-primary" target="_blank" rel="noopener">
            <i class="fas fa-paper-plane"></i> ${TT('rec_intake_links_request', 'Solicitar')}
          </a>
        </td>
      </tr>
    `;
  });

  html += `
      </tbody>
    </table>
  `;

  $('#contenedorTabla').html(html);
}

</script>
<!-- Funciones Reclutamiento -->
<script src="<?php echo base_url(); ?>js/reclutamiento/functions.js"></script>
<script src="<?php echo base_url(); ?>js/reclutamiento/requisicion.js"></script>