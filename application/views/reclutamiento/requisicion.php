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
          'LINK'       => show_if_can('reclutamiento.reqs.link_requisicion', in_array($ROL, [1], true)),
          'DETENER'       => show_if_can('reclutamiento.reqs.detener_requisicion', in_array($ROL, [1], true)),

          // Usuarios asignados a la req
          'USU_ASIG_VER'   => show_if_can('reclutamiento.reqs.usuarios_asig_ver', true),
          'USU_ASIG_DEL'   => show_if_can('reclutamiento.reqs.usuarios_asig_del', $ROL !== 4),
      ];

      // (Opcional) Flags para JS (DataTables, habilitar íconos, etc.)
      echo perms_js_flags([
          'REQS_CREAR'          => ['reclutamiento.reqs.crear', ($TIPO_BOLSA === 1) || in_array($ROL, [4,1, 6, 9], true)],
          'REQS_ASIGNAR'        => ['reclutamiento.reqs.asignar', $ROL !== 4],
          'REQS_EDITAR'         => ['reclutamiento.reqs.editar', true],
          'REQS_DETENER'         => ['reclutamiento.reqs.detener_requisicion', true],
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
        <h1 class="titulo_seccion mb-3">Requisiciones</h1>
      </div>


      <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="actions d-flex justify-content-md-end flex-wrap">
          <?php if ($this->session->userdata('tipo_bolsa') == 1): ?>
            <?php if ($CAN['LINK']): ?>
          <!-- Link General (lo dejo como lo tenías; si quieres amarrarlo a VER, envuélvelo con $CAN['VER']) -->
          <button type="button" class="btn action-btn btn-green" onclick="openQrModal()">
            <span class="icon"><i class="far fa-file-alt"></i></span>
            <span class="text">Link General</span>
          </button>
          <?php endif; ?>
       <?php endif; ?>
          <?php if ($CAN['CREAR']): ?>
          <?php if ($this->session->userdata('tipo_bolsa') == 1): ?>
          <button type="button" id="btnRegistrarReq" class="btn action-btn btn-blue" onclick="nuevaRequisicionIntake()">
            <span class="icon"><i class="far fa-file-alt"></i></span>
            <span class="text">Registrar Requisición</span>
          </button>
          <?php else: ?>
          <button type="button" id="btnReqInterna" class="btn action-btn btn-blue" onclick="nuevaRequisicion()">
            <span class="icon"><i class="far fa-file-alt"></i></span>
            <span class="text">Requisición Interna</span>
          </button>
          <?php endif; ?>
          <?php endif; ?>

          <?php if ($CAN['ASIGNAR']): ?>
          <button type="button" id="btnOpenAssignToUser" class="btn action-btn btn-purple" onclick="openAssignToUser()">
            <span class="icon"><i class="fas fa-user-edit"></i></span>
            <span class="text">Asignar Requisición</span>
          </button>
          <?php endif; ?>
        </div>

      </div>

    </div>
  </section>
  <br><br>
  <div>
    <p>Este módulo facilita la gestión de requisiciones de empleo, permitiendo asignar a un reclutador, registrar nuevas
      requisiciones expresas, y realizar acciones como descargar, iniciar, ver, detener y eliminar requisiciones de
      manera ágil y organizada.</p>
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
      <label for="ordenar">Ordenar:</label>
      <select name="ordenar" id="ordenar" class="form-control">
        <option value="">Selecciona</option>
        <option value="ascending">De la más antigua a la más actual</option>
        <option value="descending">De la más actual a la más antigua</option>
      </select>
    </div>
    <div class="col-sm-12 col-md-2 col-lg-2">
      <label for="filtrar">Filtrar:</label>
      <select name="filtrar" id="filtrar" class="form-control">
        <option value="">Seleccionar</option>
        <option value="COMPLETA">Requisición COMPLETA (registrada por externo)</option>
        <option value="INTERNA">Requisición Interna</option>
        <option value="En espera">Estado pendiente</option>
        <option value="En proceso">Estado en proceso de reclutamiento</option>
      </select>
    </div>
    <div class="col-sm-12 col-md-3 col-lg-3">
      <label for="buscador">Buscar:</label>
      <select name="buscador" id="buscador" class="form-control">
        <option value="0">Todos</option>
        <?php if (! empty($orders_search)): ?>
        <?php foreach ($orders_search as $row): ?>
        <option value="<?php echo (int) $row->idReq; ?>">
          <?php
              echo '#' . (int) $row->idReq . ' '
                  . (! empty($row->nombre_cliente) ? htmlspecialchars($row->nombre_cliente) : 'No Asignado')
                  . ' - '
                  . (! empty($row->puesto) ? htmlspecialchars($row->puesto) : 'Sin puesto');
          ?>
        </option>
        <?php endforeach; ?>
        <?php else: ?>
        <option value="">Sin requisiciones registradas</option>
        <?php endif; ?>
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
              $text_estatus = 'Estatus: <b>En espera</b>';

              // Botón iniciar solo si tiene permiso
              if (! empty($CAN['INICIAR'])) {
                  $botonProceso = '<a href="javascript:void(0)" class="btn btn-success btn-ico" id="btnIniciar' . $r->idReq . '" title="Iniciar proceso" onclick="cambiarStatusRequisicion(' . $r->idReq . ',\'' . $nombreJS . '\', \'iniciar\')"><i class="fas fa-play-circle fa-fw"></i></a>';
              }

              // Ver resultados (lo dejo como estaba, si luego quieres permiso, lo amarramos)
              $botonResultados = '<a href="javascript:void(0)" class="btn btn-success btn-ico isDisabled" title="Ver resultados de los candidatos"><i class="fas fa-file-alt fa-fw"></i></a>';

              // Eliminar solo con permiso
              if (! empty($CAN['ELIMINAR'])) {
                  $btnDelete = '<a href="javascript:void(0)" class="btn btn-danger btn-ico" title="Eliminar Requisición" onclick="openDeleteOrder(' . $r->idReq . ',\'' . $nombreJS . '\')"><i class="fas fa-trash fa-fw"></i></a>';
              }
          }

          if ((int) $r->status === 2) {
              $color_estatus = 'req_activa';
              $text_estatus  = 'Estatus: <b>En proceso de reclutamiento</b>';

              // Botón detener solo si tiene permiso de cambiar status
              if (! empty($CAN['DETENER'])) {
                  $botonProceso = '<a href="javascript:void(0)" class="btn btn-danger btn-ico" id="btnIniciar' . $r->idReq . '" title="Detener proceso" onclick="cambiarStatusRequisicion(' . $r->idReq . ',\'' . $nombreJS . '\', \'detener\')"><i class="fas fa-stop fa-fw"></i></a>';
              }

              $botonResultados = '<a href="javascript:void(0)" class="btn btn-success btn-ico" title="Ver resultados de los candidatos" onclick="verExamenesCandidatos(' . $r->idReq . ',\'' . $nombreJS . '\')"><i class="fas fa-file-alt fa-fw"></i></a>';

              // Si está en proceso, mantener el isDisabled original del eliminar
                if (! empty($CAN['ELIMINAR'])) {
              $btnDelete = '<a href="javascript:void(0)" class="btn btn-danger btn-ico isDisabled" title="Eliminar Requisición"><i class="fas fa-trash fa-fw"></i></a>';
          }
        }

          // Usuarios asignados (dedupe)
          $usuario       = (empty($r->usuario)) ? 'Requisición sin cambios<br>' : 'Úlltimo movimiento: <b>' . $r->usuario . '</b><br>';
          $data['users'] = $this->reclutamiento_model->getUsersOrder($r->idReq);
          if (! empty($data['users'])) {
              $usersAssigned = 'Usuario Asignado:<br>';
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
	            <a href="javascript:void(0)" class="btn btn-danger btn-ico" title="Eliminar Usuario de la Requisición"
	               onclick="openDeleteUserOrder(' . $user->id . ',' . $user->id_requisicion . ',\'' . $nombreUsuario . '\')">
	               <i class="fas fa-user-times fa-fw"></i>
	            </a> <b>' . $nombreUsuario . '</b></div>';
                  } else {
                      $usersAssigned .= '<div class="mb-1" id="divUser' . $user->id . '"><b>' . $nombreUsuario . '</b></div>';
                  }
              }
          } else {
              $usersAssigned = 'No Asignada aun';
          }
          unset($data['users']);

          // Botón editar (respeta permiso, sin tocar IDs)
          $btnExpress = '';
          if (! empty($CAN['EDITAR'])) {
              $btnExpress = ($r->tipo == 'INTERNA' || $r->tipo == 'COMPLETA')
                  ? '<a href="javascript:void(0)" class="btn btn-primary btn-ico" title="Editar Requisición"
	             onclick="openUpdateOrder(' . $r->idReq . ',\'' . $nombreJS . '\',\'' . $nombreJS . '\',\'' . addslashes($puestoCard) . '\')">
	             <i class="fas fa-edit fa-fw"></i></a>'
                  : '<a href="javascript:void(0)" class="btn btn-primary btn-ico" title="Editar SOLICITUD" onclick="openUpdateOrderIntake(' . (int) $r->idReq . ')">
	             <i class="fas fa-edit fa-fw"></i></a>';
          }

          // Detalles (VER_COMPLETA)
          $btnDetalles = '';
          if (! empty($CAN['VER_COMPLETA'])) {
              $btnDetalles = ($r->tipo == 'INTERNA' || $r->tipo == 'COMPLETA')
                  ? '<a href="javascript:void(0)" class="btn btn-primary btn-ico" title="Ver detalles"
	             onclick="verDetalles(' . (int) $r->idReq . ')">
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
	            <button type="submit" class="btn btn-danger btn-ico" title="Descargar PDF">
	              <i class="fas fa-file-pdf fa-fw"></i>
	            </button>
	          </form>';
              } else {
                  $btnPDF =
                  '<form method="POST" action="' . base_url('Reclutamiento/getOrderPDFIntake') . '">
	            <input type="hidden" name="idReq" value="' . (int) $r->idReq . '">
	            <button type="submit" class="btn btn-danger btn-ico" title="Descargar PDF">
	              <i class="fas fa-file-pdf fa-fw"></i>
	            </button>
	          </form>';
              }
          }

          // Asignar sucursal (solo intake) — amarrado a permiso ASIGNAR
          $btnAsignarSucursal = '';
          if ($esIntake && ! empty($CAN['ASIGNAR'])) {
              $btnAsignarSucursal =
              '<button type="button" class="btn btn-success btn-ico btn-asignar-sucursal" title="Asignar a sucursal"
	           data-idreq="' . (int) $r->idReq . '"
	           data-sucursal="' . (isset($r->id_sucursal) ? (int) $r->id_sucursal : 0) . '">
	           <i class="fas fa-store fa-fw"></i>
	         </button>';
          }

          $totalOrders = count($requisiciones);
          $moveOrder   = ($totalOrders > 1) ? '' : 'offset-md-4 offset-lg-4';
      ?>
        <div class="col-sm-12 col-md-4 col-lg-4 mb-5<?php echo $moveOrder ?>">
          <div class="card text-center tarjeta" id="<?php echo 'tarjeta' . (int) $r->idReq; ?>">
            <div class="card-header	                                <?php echo $color_estatus ?>">
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
                <span class="badge badge-info ml-2">SOLICITUD</span>
                <?php endif; ?>
              </div>
            </div>

            <div class="card-body">
              <h5 class="card-title"><b><?php echo $puestoCard; ?></b></h5>
              <p class="card-text">Vacantes: <b><?php echo $r->numero_vacantes; ?></b></p>

              <p class="card-text">Contacto:
                <br><b><?php echo $contactoCard . ' <br>' . $telefonoCard . ' <br>' . $correoCard; ?></b>
              </p>

              <?php if ($esIntake): ?>
              <div class="alert alert-info text-center mt-2 p-2">
                <small>
                  <?php if (! empty($r->plan)): ?>Plan:
                  <b><?php echo htmlspecialchars($r->plan, ENT_QUOTES, 'UTF-8'); ?></b><?php endif; ?>
                  <?php if (! empty($r->metodo_comunicacion)): ?> · Medio:
                  <b><?php echo htmlspecialchars($r->metodo_comunicacion, ENT_QUOTES, 'UTF-8'); ?></b><?php endif; ?>
                  <?php if (! empty($r->pais_empresa)): ?> · País:
                  <b><?php echo htmlspecialchars($r->pais_empresa, ENT_QUOTES, 'UTF-8'); ?></b><?php endif; ?>
                </small>
              </div>
              <?php endif; ?>

              <div class="alert alert-secondary text-center mt-3">
                Tipo: <b><?php echo $r->tipo ?></b><br><?php echo $text_estatus ?>
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
                <input type="text" class="form-control" id="comercial_update" name="comercial_update"
                  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              </div>
            </div>
            <div class="col-6">
              <label>Razón social *</label>
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
              <label for="pais">País *</label>
              <input type="text" class="form-control" id="pais_update" name="pais_update">
            </div>
            <div class="col-md-4">
              <label for="estado">Estado *</label>
              <input type="text" class="form-control" id="estado_update" name="estado_update">
            </div>
            <div class="col-md-4">
              <label for="ciudad">Ciudad *</label>
              <input type="text" class="form-control" id="ciudad_update" name="ciudad_update">
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-4">
              <label for="colonia">Colonia *</label>
              <input type="text" class="form-control" id="colonia_update" name="colonia_update">
            </div>
            <div class="col-md-4">
              <label for="calle">Calle *</label>
              <input type="text" class="form-control" id="calle_update" name="calle_update">
            </div>
            <div class="col-md-2">
              <label for="num_interior">Número Interior</label>
              <input type="text" class="form-control" id="interior_update" name="interior_update">
            </div>
            <div class="col-md-2">
              <label for="num_exterior">Número Exterior</label>
              <input type="text" class="form-control" id="exterior_update" name="exterior_update">
            </div>
          </div>
          <br>
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
                <input type="text" class="form-control" id="correo_update" name="correo_update"
                  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
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
                <input type="text" class="form-control" id="regimen_update" name="regimen_update"
                  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>RFC *</label>
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
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label>Método de pago *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                </div>
                <select class="custom-select" id="metodo_pago_update" name="metodo_pago_update">
                  <option value="" selected>Selecciona</option>
                  <option value="Efectivo">Efectivo</option>
                  <option value="Cheque de nómina">Cheque de nómina</option>
                  <option value="Transferencia electrónica">Transferencia electrónica</option>
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
          onclick="updateOrder('data_facturacion')">Guardar Datos de Facturación</button>
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
        <button type="button" class="btn btn-success btn-block text-lg" onclick="updateOrder('vacante')">Guardar
          Información de la Vacante</button>
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
                <textarea name="lugar_entrevista_update" id="lugar_entrevista_update" class="form-control"
                  rows="3"></textarea>
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
                <input type="text" class="form-control" id="monto_adicional_update" name="monto_adicional_update"
                  disabled>
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
        <button type="button" class="btn btn-success btn-block text-lg" onclick="updateOrder('cargo')">Guardar
          Información sobre el Cargo</button>
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
                <input type="checkbox" id="Liderazgo-">
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
                <input type="checkbox" id="Sociable-">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Intuitivo
                <input type="checkbox" id="Intuitivo-">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Autodidacta
                <input type="checkbox" id="Autodidacta-">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Creativo
                <input type="checkbox" id="Creativo-">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Proactivo
                <input type="checkbox" id="Proactivo-">
                <span class="checkmark"></span>
              </label>
              <label class="container_checkbox">Adaptable
                <input type="checkbox" id="Adaptable-">
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
                <textarea name="observaciones_update" id="observaciones_update" class="form-control"
                  rows="4"></textarea>
              </div>
            </div>
          </div>
        </form>
        <button type="button" class="btn btn-success btn-block text-lg" onclick="updateOrder('perfil')">Guardar
          Competencias requeridas para el puesto</button>
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
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <button type="button" class="btn btn-secondary" id="btnCancelarIntake">Cancelar</button>
      </div>
    </form>
  </div>


</div>

<!-- Sweetalert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>

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
    titulo = 'Confirmación de inicio de requisición';
    mensaje = '¿Desea iniciar el proceso de la requisición <b>#' + id + ' ' + nombre + '</b>?';
    status = 2;
  } else if (accion === 'detener') {
    titulo = 'Confirmación de detención de requisición';
    mensaje = '¿Desea detener el proceso de la requisición <b>#' + id + ' ' + nombre + '</b>?';
    status = 1;
  }

  $('#titulo_mensaje').text(titulo);
  $('#mensaje').html(mensaje);
  $('#idRequisicion').val(id);

  // Configurar el evento onclick del botón #btnConfirmar
  $('#btnConfirmar').off('click').on('click', function() {
    confirmarAccion(status);
  });

  $('#mensajeModal').modal('show');
}

function confirmarAccion(status) {

  $('#mensajeModal').modal('hide');
  var idRequisicion = $('#idRequisicion').val();

  //Colocar en privado o publico
  if (status == 1 || status == 2) {
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/cambiarStatusRequisicion'); ?>',
      type: 'post',
      data: {
        'id': idRequisicion,
        'status': status,
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

          Swal.fire({
            position: 'center',
            icon: 'success',
            title: dato.msg,
            showConfirmButton: false,
            timer: 1500
          })
          setTimeout(function() {
            location.reload();
          }, 3000)
        }
      }
    });
  } else {
    let comentario = $('#mensaje_comentario').val();
    $.ajax({
      url: '<?php echo base_url('Reclutamiento/deleteOrder'); ?>',
      type: 'post',
      data: {
        'id': idRequisicion,
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
        if (dato.codigo === 1) {
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
  // 1) Modal de carga
  Swal.fire({
    title: 'Cargando intake…',
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    }
  });

  $.ajax({
    url: '<?php echo base_url('Reclutamiento/getDetailsOrderByIdIntake'); ?>',
    type: 'post',
    data: {
      id: idIntake
    },
    success: function(res) {
      let d;
      try {
        d = (typeof res === 'object') ? res : JSON.parse(res);
      } catch (e) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Respuesta inválida del servidor.'
        });
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
        if (!fname) return '—';
        const safeText = escapeHtml(texto || fname);
        const href = (isAbsUrl(fname) || isAbsPath(fname)) ? fname :
          (baseMap[key] ? baseMap[key] + encodeURIComponent(fname) : '#');
        return `<a href="${href}" target="_blank" rel="noopener">${safeText}</a>`;
      }

      const tituloH =
        `# ${escapeHtml(d.idReq || d.id || idIntake)} ${escapeHtml(d.nombre_c || d.nombre_cliente || '')}`;

      // HTML compacto por secciones (2 columnas)
      const html = `
        <style>
          .intake-grid{display:grid;min-width: 700px;grid-template-columns:repeat(2,minmax(260px,1fr));gap:12px}
          .intake-title{grid-column:1/-1;background:#0C9DD3;color:#fff;border-left:4px solid #38bdf8;
                        padding:8px 10px;border-radius:6px;font-weight:700}
          .intake-muted{color:#475569;font-size:.9rem}
          .intake-full{grid-column:1/-1}
        </style>

        <div class="intake-grid">
          <div class="intake-title">Datos de contacto</div>
          <div><b>Nombre cliente:</b><br>${NR(d.nombre_cliente)}</div>
          <div><b>Correo:</b><br>${NR(d.email)}</div>
          <div><b>Teléfono:</b><br>${NR(d.telefono)}</div>
          <div><b>Método contacto:</b><br>${NR(d.metodo_comunicacion)}</div>

          <div class="intake-title">Empresa / Ubicación</div>
          <div><b>Razón social:</b><br>${NR(d.razon_social)}</div>
          <div><b>NIT/RFC:</b><br>${NR(d.nit)}</div>
          <div><b>País:</b><br>${NR(d.pais_empresa)}${String(d.pais_empresa||'').toUpperCase()==='OTRO' && d.pais_otro ? ' ('+escapeHtml(d.pais_otro)+')' : ''}</div>
          <div><b>Sitio web:</b><br>${d.sitio_web ? `<a href="${escapeHtml(d.sitio_web)}" target="_blank" rel="noopener">${escapeHtml(d.sitio_web)}</a>` : 'No registrado'}</div>
          <div class="intake-full"><b>Actividad:</b><br>${NR(d.actividad)}</div>

          <div class="intake-title">Plan y fechas</div>
          <div><b>Plan:</b><br>${NR(d.puesto || d.plan)}</div>
          <div><b>Fecha solicitud:</b><br>${fechaYMDaDMY(d.fecha_solicitud)}</div>
          <div><b>Fecha inicio:</b><br>${fechaYMDaDMY(d.fecha_inicio)}</div>

          <div class="intake-title">VoIP / CRM</div>
          <div><b>¿Requiere VoIP?</b><br>${siNo(d.requiere_voip)}</div>
          <div>${String(d.requiere_voip||'').toLowerCase()==='si'
                ? `<b>Propiedad VoIP:</b><br>${NR(d.voip_propiedad)}`
                : '&nbsp;'}</div>
          <div class="intake-full">${String(d.requiere_voip||'').toLowerCase()==='si'
                ? `<b>País/Ciudad VoIP:</b><br>${NR(d.voip_pais_ciudad)}`
                : ''}</div>
          <div><b>¿Usa CRM?</b><br>${siNo(d.usa_crm)}</div>
          <div>${String(d.usa_crm||'').toLowerCase()==='si' ? `<b>CRM:</b><br>${NR(d.crm_nombre)}` : '&nbsp;'}</div>

          <div class="intake-title">Requisitos / Notas</div>
          <div class="intake-full"><b>Funciones:</b><br>${NR(d.funciones)}</div>
          <div class="intake-full"><b>Requisitos:</b><br>${NR(d.requisitos)}</div>
          <div class="intake-full"><b>Recursos:</b><br>${NR(d.recursos)}</div>
          <div class="intake-full"><b>Observaciones:</b><br>${NR(d.observaciones)}</div>

          <div class="intake-title">Documentos</div>
          <div><b>Archivo cargado:</b><br>${d.archivo_path ? link('archivo_path', d.archivo_path, 'Abrir archivo') : '—'}</div>
          <div><b>Términos:</b><br>${d.terminos_file ? link('terminos_file', d.terminos_file, 'Abrir documento') : '—'}</div>
          <div><b>Términos aceptados:</b><br>${d.acepta_terminos==1 ? 'Aceptados' : (d.acepta_terminos==0 ? 'No aceptados' : '—')}</div>

          <div class="intake-full intake-muted">
            <b>Creado:</b> ${fechaYMDaDMY(d.creacionR || d.creacion)} &nbsp; | &nbsp; <b>Última edición:</b> ${fechaYMDaDMY(d.edicion)}
          </div>
        </div>
      `;

      Swal.fire({
        title: tituloH,
        html: html,
        width: 900,
        showCloseButton: true,
        confirmButtonText: 'Cerrar',
        focusConfirm: false
      });
    },
    error: function(xhr) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: xhr.responseText || xhr.statusText || 'No se pudo obtener el intake.'
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
  const display = link ? truncateLink(link, 60) : 'Sin link';

  $('#qrLinkDisplay')
    .text(display)
    .attr('href', link || '#')
    .attr('title', link || 'No hay link');

  $('#qrUrl').val(link || '');

  if (qr) {
    $('#qrPreviewWrapper').html(`<img src="${qr}" alt="QR">`);
  } else {
    $('#qrPreviewWrapper').html(`<p class="text-muted mb-0">Sin imagen de QR.</p>`);
  }
}

// Abre y carga (llámala desde tu botón)
function openQrModal() {
  // Limpia UI
  renderQRModal('', null);
  $('#btnEliminarQR').prop('disabled', true);

  // Abre modal (una sola llamada)
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
    alert('No se pudo obtener la información del QR.');
  });
}

// ========= Handlers (registrar UNA sola vez) =========
$(function() {
  // Copiar link mostrado
  $("#btnGuardarQR").on("click", function() {
    // Si tienes el id_cliente en un input oculto, tómalo:
    var raw = ($("#idCliente").val() || "").trim(); // <input type="hidden" id="idCliente" ...>
    var idCliente = raw === "" ? null : parseInt(raw, 10);

    // Arma payload
    var data = {};
    if (idCliente !== null && !Number.isNaN(idCliente)) {
      data.id_cliente = idCliente; // si viene, envíalo
    }
    // Si además tu endpoint requiere id_portal explícito, agrégalo:
    // data.id_portal =                                                                                                                                                                                                                                                              <?php echo (int) $this->session->userdata('id_portal_token'); ?>;

    // CSRF opcional
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

        // Soporta ambos formatos de respuesta:
        // A) { success: true, link: "...", qr_image: "..." }
        // B) { link: "...", qr: "data:image/...base64", mensaje: "..." }
        var ok = (res && (res.success === true || !!res.link));
        var link = res && (res.link || res.url || null);
        var qrImage = res && (res.qr_image || res.qr || null);
        var msg = res && (res.mensaje || res.message || (ok ? 'OK' : 'Error'));

        if (!ok || !link) {
          Swal.fire("Error", msg || "No se pudo generar/actualizar el QR.", "error");
          return;
        }

        // Pinta en el modal
        $("#qrLinkDisplay")
          .attr("href", link)
          .attr("title", link)
          .text(shorten(link));

        if (qrImage) {
          $("#qrPreviewWrapper").html(
            '<img src="' + qrImage + '" class="img-fluid rounded border" style="max-width:220px;">'
          );
        } else {
          $("#qrPreviewWrapper").html('<p class="text-muted mb-0">Sin imagen de QR.</p>');
        }

        // Habilita eliminar
        $("#btnEliminarQR").prop("disabled", false);

        Swal.fire("Éxito", msg || "QR generado/actualizado correctamente.", "success");
      })
      .fail(function(xhr) {
        let m = (xhr.responseJSON && (xhr.responseJSON.error || xhr.responseJSON.message)) ||
          "Error en la petición AJAX";
        Swal.fire("Error", m, "error");
      });
  });

  // (Opcional) Eliminar
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
          Swal.fire("Éxito", "QR eliminado.", "success");
        } else {
          Swal.fire("Error", (res && (res.mensaje || res.error)) || "No se pudo eliminar.", "error");
        }
      })
      .fail(function() {
        Swal.fire("Error", "Error en la petición AJAX", "error");
      });
  });

  // Copiar link
  $("#btnCopiarLink").on("click", function() {
    var link = $("#qrLinkDisplay").attr("href");
    if (!link || link === "#") return;
    navigator.clipboard.writeText(link).then(
      () => Swal.fire("Copiado", "Link copiado al portapapeles", "success"),
      () => alert("No se pudo copiar")
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
      $('#btnBack').css('display', 'block');
      $('#tarjetas').css('display', 'none');
      $('#divFiltros').css('display', 'none')
      $('#btnNuevaRequisicionCompleta').addClass('isDisabled')
      $('#btnNuevaRequisicion').addClass('isDisabled')
      $('#btnOpenAssignToUser').addClass('isDisabled')
      let nombres = (dato['nombre_comercial'] === '' || dato['nombre_comercial'] === null) ? dato['nombre'] :
        dato['nombre'] + '<br>' + dato['nombre_comercial'];
      $('#empresa').html('<h3># ' + dato['id'] + ' ' + nombres + '<br><b>' + dato['puesto'] + '</b></h3>');
      //Vacante
      $('#vacantes').html('<b>Vacantes:</b> ' + dato['numero_vacantes'])
      let escolaridad = dato['escolaridad'] ?? 'No registrado';
      $('#escolaridad').html('<b>Formación académica requerida:</b> ' + escolaridad)
      let estatus_escolar = (dato['estatus_escolar'] == 'Otro') ? dato['otro_estatus_escolar'] : dato[
        'estatus_escolar'] ?? 'No registrado';
      $('#estatus_escolar').html('<b>Estatus académico:</b> ' + estatus_escolar)
      let carrera_requerida = dato['carrera_requerida'] ?? 'No registrado';
      $('#carrera').html('<b>Carrera requerida para el puesto:</b> ' + carrera_requerida)
      let otros_estudios = (dato['otros_estudios'] === '' || dato['otros_estudios'] === null) ?
        'No registrado' :
        dato['otros_estudios'];
      $('#otros_estudios').html('<b>Otros estudios:</b> ' + otros_estudios)
      let idiomas = (dato['idiomas'] == '') ? 'No registrado' : dato['idiomas'] ?? 'No registrado';
      $('#idiomas').html('<b>Idiomas:</b> ' + idiomas)
      let hab_informatica = (dato['habilidad_informatica'] == '') ? 'No registrado' : dato[
        'habilidad_informatica'] ?? 'No registrado';
      $('#hab_informatica').html('<b>Habilidades informáticas:</b><br> ' + hab_informatica)
      let genero = dato['genero'] ?? 'No registrado';
      $('#sexo').html('<b>Sexo:</b> ' + genero)
      let estado_civil = dato['estado_civil'] ?? 'No registrado';
      $('#civil').html('<b>Estado civil:</b> ' + estado_civil)
      let edad_minima = dato['edad_minima'] ?? 'No registrado';
      $('#edad_min').html('<b>Edad mínima:</b> ' + edad_minima)
      let edad_maxima = dato['edad_maxima'] ?? 'No registrado';
      $('#edad_max').html('<b>Edad máxima:</b> ' + edad_maxima)
      let licencia = dato['licencia'] ?? 'No registrado';
      $('#licencia').html('<b>Licencia de conducir:</b> ' + licencia)
      let discapacidad_aceptable = dato['discapacidad_aceptable'] ?? 'No registrado';
      $('#discapacidad').html('<b>Discapacidad aceptable:</b> ' + discapacidad_aceptable)
      let causa_vacante = dato['causa_vacante'] ?? 'No registrado';
      $('#causa').html('<b>Causa que origina la vacante:</b><br> ' + causa_vacante)
      let lugar_residencia = (dato['lugar_residencia'] === '' || dato['lugar_residencia'] === null) ?
        'No registrado' : dato['lugar_residencia'];
      $('#residencia').html('<b>Lugar de residencia:</b> ' + lugar_residencia)
      //Cargo
      let jornada_laboral = dato['jornada_laboral'] ?? 'No registrado';
      $('#jornada').html('<b>Jornada laboral:</b> ' + jornada_laboral)
      let tiempo_inicio = dato['tiempo_inicio'] ?? 'No registrado';
      $('#inicio').html('<b>Inicio de la Jornada laboral:</b> ' + tiempo_inicio)
      let tiempo_final = dato['tiempo_final'] ?? 'No registrado';
      $('#final').html('<b>Fin de la Jornada laboral:</b> ' + tiempo_final)
      let dias_descanso = dato['dias_descanso'] ?? 'No registrado';
      $('#descanso').html('<b>Día(s) de descanso:</b> ' + dias_descanso)
      let disponibilidad_viajar = dato['disponibilidad_viajar'] ?? 'No registrado';
      $('#viajar').html('<b>Disponibilidad para viajar:</b> ' + disponibilidad_viajar)
      let disponibilidad_horario = dato['disponibilidad_horario'] ?? 'No registrado';
      $('#horario').html('<b>Disponibilidad de horario:</b> ' + disponibilidad_horario)
      let lugar_entrevista = (dato['lugar_entrevista'] === '' || dato['lugar_entrevista'] === null) ?
        'No registrado' : dato['lugar_entrevista'];
      $('#lugar_entrevista_detalle').html('<b>Lugar de la entrevista:</b><br> ' + lugar_entrevista)
      let zona_trabajo = dato['zona_trabajo'] ?? 'No registrado';
      $('#zona').html('<b>Zona de trabajo:</b><br> ' + zona_trabajo)
      let sueldo = dato['sueldo'] ?? 'No registrado';
      $('#tipo_sueldo').html('<b>Tipo de sueldo:</b> ' + sueldo)
      let sueldo_min = (dato['sueldo_minimo'] == 0 || dato['sueldo_minimo'] === null) ? 'No registrado' : dato[
        'sueldo_minimo'];
      $('#sueldo_min').html('<b>Sueldo mínimo:</b> ' + sueldo_min)
      let sueldo_maximo = (dato['sueldo_maximo'] == 0 || dato['sueldo_maximo'] === null) ? 'No registrado' :
        dato[
          'sueldo_maximo'];
      $('#sueldo_max').html('<b>Sueldo máximo:</b> ' + sueldo_maximo)
      let sueldo_adicional = dato['sueldo_adicional'] ?? 'No registrado';
      $('#sueldo_adicional').html('<b>Sueldo adicional:</b> ' + sueldo_adicional)
      $('#tipo_pago').html('<b>Tipo de pago:</b> ' + dato['tipo_pago_sueldo'])
      $('#tipo_prestaciones').html('<b>¿Tendrá prestaciones de ley?</b> ' + dato['tipo_prestaciones'])
      let superiores = (dato['tipo_prestaciones_superiores'] == '') ? 'No registrado' : dato[
        'tipo_prestaciones_superiores'] ?? 'No registrado';
      $('#superiores').html('<b>¿Tendrá prestaciones superiores? ¿Cuáles?</b><br> ' + superiores)
      let otras_prestaciones = (dato['otras_prestaciones'] == '') ? 'No registrado' : dato[
        'otras_prestaciones'] ?? 'No registrado';
      $('#otras_prestaciones').html('<b>¿Tendrá otro tipo de prestaciones? ¿Cuáles?</b><br> ' +
        otras_prestaciones)
      let experiencia = (dato['experiencia'] === '' || dato['experiencia'] === null) ? 'No registrado' : dato[
        'experiencia'];
      $('#experiencia').html('<b>Experiencia:</b><br> ' + experiencia)
      let actividades = dato['actividades'] ?? 'No registrado';
      $('#actividades').html('<b>Actividades:</b><br> ' + actividades)
      //Perfil del cargo
      let comp = '';
      if (dato['competencias'] != null) {
        let aux = dato['competencias'].split('_');
        comp = aux.slice(0, -1);
      } else {
        comp = 'No registrado';
      }
      $('#competencias').html('<b>Competencias requeridas para el puesto:</b><br> ' + comp)
      let observaciones = (dato['observaciones'] == '') ? 'No registrado' : dato['observaciones'] ??
        'No registrado';
      $('#observaciones').html('<b>Observaciones adicionales:</b><br> ' + observaciones)
      //Facturacion
      $('#telefono_req').html('<b>Teléfono:</b> ' + dato['telefono'])
      let rfc = (dato['rfc'] === '' || dato['rfc'] === null) ? 'No registrado' : dato['rfc'];
      $('#rfc').html('<b>RFC:</b> ' + rfc)
      let correo = dato['correo'] ?? 'No registrado';
      $('#correo_req').html('<b>Correo:</b> ' + correo)
      $('#contacto').html('<b>Contacto:</b> ' + dato['contacto'])
      let forma_pago = dato['forma_pago'] ?? 'No registrado';
      $('#forma_pago').html('<b>Forma de pago:</b> ' + forma_pago)
      let metodo_pago = dato['metodo_pago'] ?? 'No registrado';
      $('#metodo_pago').html('<b>Método de pago:</b><br> ' + metodo_pago)
      let uso_cfdi = dato['uso_cfdi'] ?? 'No registrado';
      $('#cfdi').html('<b>Uso de CFDI:</b><br> ' + uso_cfdi)
      let regimen = dato['regimen'] ?? 'No registrado';
      $('#regimen').html('<b>Régimen fiscal:</b> ' + regimen)
      let domicilio = (dato['domicilio'] === '' || dato['domicilio'] === null) ? 'No registrado' : dato[
        'domicilio'];
      let cp = (dato['cp'] === '' || dato['cp'] === null) ? 'No registrado' : dato['cp'];
      $('#domicilio').html('<b>Domicilio fiscal:</b> ' + domicilio + ' <b>Código postal: </b> ' + cp + '<br>')

      $('#tarjeta_detalle').css('display', 'block');
    }
  });
}


//* Asignacion de Usuario a requisicion
function openAssignToUser() {
  let url = '<?php echo base_url('Reclutamiento/assignToUser'); ?>';
  $('#titulo_asignarUsuarioModal').text('Asignar requisicion a un reclutador');
  $('label[for="asignar_usuario"]').text('Reclutador *');
  $('label[for="asignar_registro"]').text('Requisicion *');
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
          //ESE
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
            socio = '<div><form onsubmit="return downloadFile()" id="reporteForm' + dato[i]['idCandidato'] +
              '" action="<?php echo base_url('Candidato_Conclusion/createPDF'); ?>" method="POST"><button type="submit" data-toggle="tooltip" title="Descargar reporte PDF" id="reportePDF" class="btn ' +
              colorESE +
              ' text-lg"><i class="fas fa-file-pdf"></i></button><input type="hidden" name="idCandidatoPDF" id="idCandidatoPDF' +
              dato[i]['idCandidato'] + '" value="' + dato[i]['idCandidato'] + '"></form></div>';
          } else {
            previo = (dato[i]['fecha_nacimiento'] != null && dato[i]['fecha_nacimiento'] != '0000-00-00') ?
              ' <div><form onsubmit="return downloadFile()" id="reportePrevioForm' + dato[i]['idCandidato'] +
              '" action="<?php echo base_url('Candidato_Conclusion/createPrevioPDF'); ?>" method="POST"><button type="submit" href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte previo" id="reportePrevioPDF" class="btn btn-secondary text-lg"><i class="far fa-file-powerpoint"></i></button><input type="hidden" name="idPDF" id="idPDF' +
              dato[i]['idCandidato'] + '" value="' + dato[i]['idCandidato'] + '"></form></div>' : '';

            socio = 'En proceso';
          }
          //Doping
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
              doping = '<div><form onsubmit="return downloadFile()" id="pdfForm' + dato[i]['idDoping'] +
                '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><button type="submit" data-toggle="tooltip" title="Descargar doping" id="pdfDoping" class="btn ' +
                colorDoping +
                ' text-lg"><i class="fas fa-file-pdf"></i></button><input type="hidden" name="idDop" id="idDop' +
                dato[i]['idDoping'] + '" value="' + dato[i]['idDoping'] + '"></form></div>';
            } else {
              doping = 'Pendiente';
            }
          } else {
            doping = 'No aplica';
          }
          //Medico
          if (dato[i]['medico'] > 0) {
            if (dato[i]['conclusionMedica'] !== null) {
              medico =
                '<div><form onsubmit="return downloadFile()" action="<?php echo base_url('Medico/crearPDF'); ?>" method="POST"><button type="submit" data-toggle="tooltip" title="Descargar examen medico" id="pdfFinal" class="btn btn-info text-lg"><i class="fas fa-file-pdf"></i></button><input type="hidden" name="idMedico" id="idMedico' +
                dato[i]['idMedico'] + '" value="' + dato[i]['idMedico'] + '"></form></div>';
            } else {
              medico = 'En proceso';
            }
          } else {
            medico = 'No aplica';
          }
          //Psicometria
          if (dato[i]['psicometrico'] > 0) {
            if (dato[i]['archivoPsicometria'] !== null) {
              psicometria = '<a href="' + url_psicometrias + dato[i]['archivoPsicometria'] +
                '" target="_blank" data-toggle="tooltip" title="Descargar examen psicometrico" class="btn btn-info text-lg"><i class="fas fa-file-pdf"></i></a>';
            } else {
              psicometria = 'En proceso';
            }
          } else {
            psicometria = 'No aplica';
          }

          salida += "<tr>";
          salida += '<td>#' + dato[i]['idCandidato'] + ' ' + dato[i]['candidato'] + '</td>';
          salida +=
            '<td><a href="javascript:void(0)" data-toggle="tooltip" title="Mensajes de avances" id="msj_avances" class="btn btn-primary" onclick="verMensajesAvances(' +
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
        salida +=
          '<td colspan="6" class="text-center"><h5>No hay candidatos con ESE para esta requisición</h5></td>';
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
      const dato = typeof res === 'string' ? JSON.parse(res) : res || {};


      // Encabezado
      const cliente = dato.nombre_c || '';
      const empresa = dato.nombre || '';
      const comercial = dato.razon_social || '';
      const puestoHdr = dato.puesto || dato.plan || '';
      const nombres = (comercial ? `${empresa}<br>${comercial}` : empresa);
      $('#nombreRequisicionIntake').html(`<h3># ${id} ${cliente}<br><b>${puestoHdr||''}</b></h3>`);

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
      alert('No se pudieron cargar los datos de De la Solicitud.');
    }
  });
}

/** Construye el formulario de INTAKE en base a un esquema */
function renderIntakeForm(dato, opts = {}) {
  const cols = opts.cols || 3; // nº columnas (3 por fila)
  const minWidth = opts.minWidth || 220;
  const compact = !!opts.compact;
  const theme = Object.assign({
    titleBg: '#1152eaff', // fondo de títulos
    titleColor: '#ffffff', // color de texto de títulos
    titleBorder: '#38bdf8', // borde izquierdo de títulos
    labelColor: '#111827', // color de etiquetas
    labelBold: '700' // grosor de etiquetas
  }, opts.theme || {});

  const $wrap = $('#intakeFieldset').empty();
  $wrap
    .toggleClass('compact', compact)
    .css({
      display: 'grid',
      gap: '12px', // Espaciado más cómodo
      gridTemplateColumns: `repeat(${cols}, minmax(${minWidth}px, 1fr))`,
      alignItems: 'start', // Mantiene los campos alineados arriba
      padding: '15px', // Espacio interno
      borderRadius: '6px', // Bordes redondeados sutiles
      backgroundColor: '#fafafa', // Fondo suave para diferenciar la sección
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

  // === SOLO CAMPOS DISPONIBLES EN TU SELECT ACTUAL ===
  const SECCIONES = [{
      titulo: ' Identificación / Contacto ',
      campos: [{
          key: 'nombre_cliente',
          label: 'NOMBRE DEL CLIENTE',
          type: 'text',
          required: true
        },
        {
          key: 'razon_social',
          label: 'RAZÓN SOCIAL',
          type: 'text'
        }, // de RI
        {
          key: 'email',
          label: 'E-MAIL',
          type: 'email'
        },
        {
          key: 'telefono',
          label: 'TELÉFONO',
          type: 'tel'
        },
        {
          key: 'sitio_web',
          label: 'SITIO WEB',
          type: 'url'
        },
        {
          key: 'metodo_comunicacion',
          label: 'MÉTODO DE COMUNICACIÓN PRINCIPAL',
          type: 'select',
          options: ['', 'E-MAIL', 'LLAMADA DE VOZ', 'WHATSAPP', 'OTRO']
        },
        {
          key: 'actividad',
          label: 'ACTIVIDAD DE LA EMPRESA',
          type: 'text'
        },
        {
          key: 'nit',
          label: 'NÚMERO DE IDENTIFICACIÓN TRIBUTARIA',
          type: 'text'
        },
        {
          key: 'miembro_bni',
          label: 'MIEMBRO BNI',
          type: 'select',
          options: ['', 'si', 'no']
        },
        {
          key: 'referido',
          label: 'REFERIDO',
          type: 'text'
        }
      ]
    },
    {
      titulo: 'Empresa / Ubicación',
      campos: [{
          key: 'pais_empresa',
          label: 'PAIS EMPRESA',
          type: 'select',
          options: ['', 'CANADÁ',
            'CHILE',
            'COLOMBIA',
            'COSTA RICA',
            'EEUU',
            'ESPAÑA',
            'GUATEMALA',
            'MEXICO',
            'PERÚ',
            'PUERTO RICO',
            'REPUBLICA DOMINICANA',
            'VENEZUELA',
            'OTRO'
          ]
        },
        {
          key: 'pais_otro',
          label: 'País (otro)',
          type: 'text',
          dependeDe: {
            key: 'pais_empresa',
            val: 'OTRO'
          }
        },
        {
          key: 'fecha_solicitud',
          label: 'FECHA SOLICITUD ',
          type: 'date'
        },

        {
          key: 'fecha_inicio',
          label: 'FECHA DE INICIO',
          type: 'date'
        },
        {
          key: 'plan',
          label: 'PLAN',
          type: 'select',
          options: ['', 'ASISTENTE BÁSICO',
            'ASISTENTE BÁSICO BILINGUE',
            'AGENTE COMERCIAL/ADMINISTRATIVO',
            'AGENTE COMERCIAL/ADMINISTRATIVO BILINGUE',
            'GRADO TÉCNICO',
            'GRADO TÉCNICO BILINGUE',
            'GRADO PROFESIONAL',
            'GRADO PROFESIONAL BILINGUE'
          ]

        },
        {
          key: 'horario',
          label: 'HORARIO',
          type: 'text'
        },
        {
          key: 'sexo_preferencia',
          label: 'SEXO  PREFERENCIA',
          type: 'select',
          options: ['', 'MASCULINO', 'FEMENINO', 'INDISTINTO']
        },
        {
          key: 'rango_edad',
          label: 'RANGO EDAD',
          type: 'text',
          placeholder: 'p.ej. 25-35'
        }
      ]
    },
    {
      titulo: ' REQUISITOS  / FUNCIONES ',
      campos: [{
          key: 'funciones',
          label: 'FUNCIONES A DESEMPEÑAR',
          type: 'textarea'
        },
        {
          key: 'requisitos',
          label: 'REQUISITOS/HABILIDADES',
          type: 'textarea'
        },
        {
          key: 'recursos',
          label: 'RECURSOS TÉCNICOS/PROGRAMAS A UTILIZAR ',
          type: 'textarea'
        },
        /*{
          key: 'experiencia',
          label: 'Experiencia ',
          type: 'textarea',
            hidden: true

        },*/
        {
          key: 'observaciones',
          label: 'OBSERVACIONES',
          type: 'textarea',

        }
      ]
    },
    {
      titulo: 'VOIP / CRM ',
      campos: [{
          key: 'requiere_voip',
          label: 'SERVICIO DE TELEFONÍA VoIP ADICIONAL?',
          type: 'select',
          options: ['', 'si', 'no']
        },
        {
          key: 'voip_propiedad',
          label: 'SERVICIO DE TELEFONÍA VoIP QUE USARÁ SU TELEOPERADOR',
          type: 'select',
          dependeDe: {
            key: 'requiere_voip',
            val: 'si'
          },
          options: ['', 'Telefonía propia', 'A través de Asistente Virtual Ok.com']
        },
        {
          key: 'voip_pais_ciudad',
          label: 'PAÍS/CIUDAD DE LA TELEFONÍA VoIP QUE REQUIERE',
          type: 'text',
          dependeDe: {
            key: 'requiere_voip',
            val: 'si'
          }
        },
        {
          key: 'usa_crm',
          label: 'USO DE ALGÚN CRM?',
          type: 'select',
          options: ['', 'si', 'no']
        },
        {
          key: 'crm_nombre',
          label: 'NOMBRE CRM UTILIZADO',
          type: 'text',
          dependeDe: {
            key: 'usa_crm',
            val: 'si'
          }
        }
      ]
    },
    /* {
       titulo: 'Requisición ',
       campos: [{
           key: 'zona_trabajo',
           label: 'Zona de trabajo',
           type: 'text'
         }

       ]
     },*/
    {
      titulo: 'DOCUMENTOS, SOLO LECTURA',
      campos: [
        /*   {
             key: 'acepta_terminos',
             label: 'TERMINOS  ACEPTADOS',
             type: 'select',
             options: [{
                 label: '—',
                 value: ''
               },
               {
                 label: 'Aceptados',
                 value: '1'
               },
               {
                 label: 'No aceptados',
                 value: '0'
               }
             ],
             readonly: true
           }, */
        {
          key: 'creacionR',
          label: 'FECHA DE REGISTRO ',
          type: 'text',
          readonly: true
        },
        {
          key: 'archivo_path',
          label: 'ARCHIVOS CARGADOS',
          type: 'link',
          linkText: 'Abrir archivo',
          hideWhenEmpty: true, // ← no se muestra si no hay valor
          readonly: true
        },
        {
          key: 'terminos_file',
          label: 'DOCUMENTO DE TERMINOS Y CONDICIONES',
          type: 'link',
          linkText: 'Abrir archivo',
          hideWhenEmpty: true, // ← no se muestra si no hay valor
          readonly: true
        },
        /* {
           key: 'edicion',
           label: 'ULTIMA EDICION',
           type: 'text',
           readonly: true
         },*/

      ]
    }
  ];

  // — helpers de render —
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
        ">
          ${texto}
        </div>
      </div>
    `);
  };

  const renderCampo = (f) => {
    const show = !f.dependeDe || String(val(f.dependeDe.key)).toLowerCase() === String(f.dependeDe.val).toLowerCase();
    const group = $('<div class="form-group"></div>').attr('data-key', f.key);
    if (!show) group.hide();

    // Label más estilizado
    group.append(
      `<label for="in_${f.key}" style="font-weight:600; font-size:0.95rem; margin-bottom:4px; display:block;">${f.label}${f.required?' *':''}</label>`
    );

    let $input;
    switch (f.type) {
      case 'textarea':
        $input = $(
          `<textarea class="form-control" id="in_${f.key}" name="${f.key}" rows="3" ${f.readonly?'readonly':''} style="padding:8px; border-radius:4px; border:1px solid #ccc; font-size:0.95rem;"></textarea>`
        );
        $input.val(val(f.key));
        break;

      case 'select':
        $input = $(
          `<select class="form-control" id="in_${f.key}" name="${f.key}" ${f.readonly?'disabled':''} style="padding:6px 8px; border-radius:4px; border:1px solid #ccc; font-size:0.95rem;"></select>`
        );
        (f.options || ['']).forEach(opt => {
          const $o = $('<option></option>').attr('value', opt).text(opt === '' ? '-- Selecciona --' : opt);
          if (String(val(f.key)).toLowerCase() === String(opt).toLowerCase()) $o.prop('selected', true);
          $input.append($o);
        });
        break;

      case 'date':
        $input = $(
          `<input type="date" class="form-control" id="in_${f.key}" name="${f.key}" ${f.readonly?'readonly':''} style="padding:6px 8px; border-radius:4px; border:1px solid #ccc; font-size:0.95rem;">`
        );
        $input.val(toISODate(val(f.key)));
        break;
      case 'link': {
        const filename = val(f.key);

        // 1) Mapa de bases por key (usa json_encode para que sean strings válidos en JS)
        const baseMap = {
          archivo_path: (<?php echo json_encode(LINKDOCREQUICICION) ?> || '').replace(/\/?$/, '/'),
          terminos_file: (<?php echo json_encode(LINKAVISOS) ?> || '').replace(/\/?$/,
            '/'), // define esta constante en CI3
        };

        // 2) Si el valor ya es URL absoluta o ruta absoluta, respétala tal cual
        const isAbsUrl = v => /^https?:\/\//i.test(v || '');
        const isAbsPath = v => (v || '').startsWith('/');

        // 3) Fallbacks existentes
        const hideWhenEmpty = !!f.hideWhenEmpty;
        const emptyText = f.emptyText || 'Sin archivo cargado';
        const emptyTag = f.emptyTag || 'span';
        const emptyClass = f.emptyClass || 'text-muted';
        const emptyHref = typeof f.emptyHref === 'function' ? f.emptyHref(dato) : (f.emptyHref || null);

        if (filename) {
          let url = '#';
          if (isAbsUrl(filename) || isAbsPath(filename)) {
            url = filename;
          } else {
            const base = baseMap[f.key] || ''; // ← toma la base según el key
            url = base ? (base + encodeURIComponent(filename)) : '#';
          }
          $input = $(`<a id="in_${f.key}" target="_blank" rel="noopener"></a>`)
            .attr('href', url)
            .text(f.linkText || filename);
        } else {
          if (hideWhenEmpty) {
            group.hide();
            break;
          }
          if (emptyTag === 'a' && emptyHref) {
            $input = $(`<a id="in_${f.key}" class="${emptyClass}" target="_blank" rel="noopener"></a>`)
              .attr('href', emptyHref).text(emptyText);
          } else if (emptyTag === 'button' && emptyHref) {
            $input = $(`<a id="in_${f.key}" class="${emptyClass} btn btn-sm"></a>`)
              .attr('href', emptyHref).text(emptyText);
          } else {
            $input = $(`<${emptyTag} id="in_${f.key}" class="${emptyClass}"></${emptyTag}>`).text(emptyText);
          }
        }
        break;
      }



      default:
        $input = $(
          `<input type="${f.type||'text'}" class="form-control" id="in_${f.key}" name="${f.key}" ${f.readonly?'readonly':''} placeholder="${f.placeholder||''}" style="padding:6px 8px; border-radius:4px; border:1px solid #ccc; font-size:0.95rem;">`
        );
        $input.val(val(f.key));
        break;
    }

    if (f.required) $input.prop('required', true);

    // Dependencias
    if (f.dependeDe) {
      const master = f.dependeDe.key;
      // Namespace único por dependiente:
      const ns = '.dep_' + master + '_' + f.key;

      // No usar .off() global por master; solo desata este handler específico si existe
      $(document).off('change' + ns)
        .on('change' + ns, '#in_' + master, function() {
          const on = String($(this).val()).toLowerCase() === String(f.dependeDe.val).toLowerCase();
          const $g = $('[data-key="' + f.key + '"]');
          on ? $g.slideDown(120) : $g.slideUp(120);
        });
    }

    group.append($input);
    $wrap.append(group);
  };


  // — pintar —
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
$(document).on('submit', '#formIntakeUpdate', function(e) {
  e.preventDefault();
  const payload = serializeIntakeForm();
  $.ajax({
    url: '<?php echo base_url('Reclutamiento/updateIntake'); ?>', // <-- ajusta a tu ruta real
    type: 'POST',
    data: payload,
    beforeSend: function() {
      $('.loader').show();
    },
    success: function(r) {
      $('.loader').fadeOut();
      try {
        r = (typeof r === 'string') ? JSON.parse(r) : r;
      } catch (e) {}
      if (r && r.success) {
        (window.Swal ? Swal.fire('Guardado', 'Cambios guardados', 'success') : alert('Cambios guardados'));
      } else {
        (window.Swal ? Swal.fire('Atención', (r && r.msg) || 'No se pudo guardar', 'warning') : alert(
          'No se pudo guardar'));
      }
    },
    error: function() {
      $('.loader').fadeOut();
      (window.Swal ? Swal.fire('Error', 'Error al guardar', 'error') : alert('Error al guardar'));
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
      if ($(this).is(":checked") == true)
        return this.id;
    }).get().join('_');
    if (competenciasChecked != '') {
      competenciasValues = competenciasChecked.replaceAll('-', ' ')
      competenciasValues += '_';
    } else {
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
//* Eliminar usuario de la requisicion
function openDeleteUserOrder(id, id_requisicion, nombre) {
  let url = '<?php echo base_url('Reclutamiento/deleteUserOrder'); ?>';
  $('#titulo_mensaje').text('Confirmar eliminación de usuario en la requisición');
  $('#mensaje').html('¿Desea eliminar al usuario <b>' + nombre + '</b> de la requisición <b>#' + id_requisicion +
    '</b>?');
  $('#idRequisicion').val(id);
  $('#btnConfirmar').attr("onclick", "deleteUserOrder(" + id + ",\"" + url + "\")");
  $('#mensajeModal').modal('show');
}

function openDeleteOrder(id, name) {
  // Update the modal title with a warning icon and translated text
  $('#titulo_mensaje').html('<i class="fa fa-exclamation-triangle text-warning"></i> Delete Requisition');
  // Update the message with translated text and keeping the #id and #name
  $('#mensaje').html('Are you sure you want to delete requisition <b>#' + id + ' ' + name +
    '</b>? This action is permanent. To proceed, press <b>Confirm</b>, or <b>Cancel</b> if you do not wish to delete it.'
  );
  // Set the requisition ID to be deleted
  $('#idRequisicion').val(id);
  // Keep the textarea for entering the reason for deletion
  $('#campos_mensaje').html(
    '<div class="row"><div class="col-12"><label>Reason for Deletion *</label><textarea class="form-control" rows="3" id="mensaje_comentario" name="mensaje_comentario"></textarea></div></div>'
  );
  // Set the confirmation action for the button
  $('#btnConfirmar').attr("onclick", "confirmarAccion(3," + id + ")");
  // Show the modal
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
  let msj = $('#avanceMensaje' + id).val();
  let archivo = $('#avanceArchivo' + id).val();
  let msj_archivo = '';
  let file = document.getElementById('avanceArchivo' + id);
  if (file.files.length > 0) {
    let filename = file.files[0].name;
    msj_archivo = (archivo !== '') ? '<br>¿Y la imagen? <br><b>' + filename + '</b>' : '';
  }
  $('#titulo_mensaje').text('Confirmar modificación de mensaje de avance');
  $('#mensaje').html('¿Desea confirmar el mensaje? <br><b>"' + msj + '"</b>' + msj_archivo);
  $('#btnConfirmar').attr("onclick", "editarAvance(" + id + ",\"" + msj + "\")");
  $('#mensajeModal').modal('show');
}

function editarAvance(id, msj) {
  let id_candidato = $("#idCandidato").val()
  let candidato = $('#avancesModal #nombreCandidato').text()
  let datos = new FormData();
  datos.append('id', id);
  datos.append('msj', msj);
  datos.append('archivo', $("#avanceArchivo" + id)[0].files[0]);
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
      if (dato.codigo === 1) {
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

function confirmarEliminarAvance(id) {
  let msj = $('#avanceMensaje' + id).val();
  $('#titulo_mensaje').text('Confirmar eliminar mensaje de avance');
  $('#mensaje').html('¿Desea eliminar el mensaje? <br><b>"' + msj + '"</b>');
  $('#btnConfirmar').attr("onclick", "eliminarAvance(" + id + ")");
  $('#mensajeModal').modal('show');
}

function eliminarAvance(id) {
  let id_candidato = $("#idCandidato").val()
  let candidato = $('#avancesModal #nombreCandidato').text()
  $.ajax({
    url: '<?php echo base_url('Avance/eliminar'); ?>',
    type: 'POST',
    data: {
      'id': id
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      $('#mensajeModal').modal('hide');
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 300);
      var dato = JSON.parse(res);
      if (dato.codigo === 1) {
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

function nuevaRequisicionIntake() {
  // Mostrar modal
  $('#modalRequisiciones').modal('show');

  // Loader mientras carga
  $('#contenedorTabla').html('<p class="text-center text-muted">Cargando enlaces...</p>');

  // Llamada AJAX
  $.ajax({
    url: '<?php echo base_url('Reclutamiento/get_links'); ?>',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.success && response.data.length) {
        renderTablaRequisiciones(response.data);
      } else {
        $('#contenedorTabla').html('<p class="text-center text-warning">No hay enlaces disponibles.</p>');
      }
    },
    error: function() {
      $('#contenedorTabla').html('<p class="text-center text-danger">Error al cargar los enlaces.</p>');
    }
  });
}

function renderTablaRequisiciones(data) {
  let html = `
    <table class="table table-hover table-sm">
      <thead class="thead-dark">
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th class="text-center">Acción</th>
        </tr>
      </thead>
      <tbody>
  `;

  data.forEach((item, index) => {
    html += `
      <tr>
        <td>${index + 1}</td>
        <td>${item.nombre}</td>
        <td class="text-center">
          <a href="${item.link}" class="btn btn-sm btn-primary" target="_blank">
            <i class="fas fa-paper-plane"></i> Solicitar
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