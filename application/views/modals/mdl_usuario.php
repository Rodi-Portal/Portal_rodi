<!-- <div class="modal fade" id="perfilUsuarioModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info text-center">User data</div>
        <form id="datos">
          <div class="row">
            <div class="col-6">
              <label>Name *</label>
              <input type="text" class="form-control" name="usuario_nombre" id="usuario_nombre">
              <br>
            </div>
            <div class="col-6">
              <label>First lastname *</label>
              <input type="text" class="form-control" name="usuario_paterno" id="usuario_paterno">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <label>Email *</label>
              <input type="email" class="form-control" name="usuario_correo" id="usuario_correo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
              <br>
            </div>
            <div class="col-6">
              <label>New password</label>
              <input type="password" class="form-control" name="usuario_nuevo_password" id="usuario_nuevo_password">
              <br>
            </div>
          </div>
          <div class="alert alert-info text-center">Configurations</div>
          <div class="row">
            <div class="col-6">
              <label>key</label>
              <input type="text" class="form-control" name="usuario_key" id="usuario_key" maxlength="16">
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="confirmarPassword()">Save</button>
      </div>
    </div>
  </div>
</div> -->
<div class="modal fade" id="confirmarPasswordModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirm password</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

        </button>
      </div>
      <div class="modal-body">
        <h3>Please type your current password:</h3><br>
        <div class="row">
          <div class="col-12">
            <input type="password" class="form-control" id="password_actual" name="password_actual">
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="checkPasswordActual()">Accept</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="recuperarPasswordModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Password recovery</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

        </button>
      </div>
      <div class="modal-body">
        <h3>Email:</h3><br>
        <div class="row">
          <div class="col-12">
            <input type="password" class="form-control" id="password_actual" name="password_actual">
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="checkPasswordActual()">Accept</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="avancesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Progress messages:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

        </button>
      </div>
      <div class="modal-body">

        <ul class="nav nav-tabs" id="modalTabs">
          <li class="nav-item">
            <a class="nav-link active" id="pestaña1-tab" data-toggle="tab" href="#pestaña1">BGV comments:</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pestaña2-tab" data-toggle="tab" href="#pestaña2">Drug Test comments:</a>
          </li>
        </ul>

        <div class="tab-content">
          <div class="tab-pane fade show active" id="pestaña1">
            <p class="" id="comentario_candidato_p1"></p><br>
            <h4>BGV <h4>
                <div class="modal-body">

                  <div id="div_avances_bgv">

                  </div>
                </div>
          </div>
          <div class="tab-pane fade" id="pestaña2">
            <p class="" id="comentario_candidato_p2"></p><br>
            <h4>Drug Test <h4>
                <div class="modal-body">
                  <div id="div_avances_dop">

                  </div>
                </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="statusModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Candidate Status: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
        </button>
      </div>
      <div class="modal-body">
        <div id="div_status"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalLinkEmpleado" tabindex="-1" role="dialog" aria-labelledby="titleLinkEmpleado"
  aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 id="titleLinkEmpleado" class="modal-title">Link de PreEmpleo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <!-- Loader -->
        <div id="lk_loader" class="text-center my-3" style="display:none;">
          <div class="spinner-border" role="status"></div>
          <div class="small mt-2">Cargando…</div>
        </div>

        <!-- SIN LINK -->
        <div id="lk_empty" class="alert alert-warning" style="display:none;">
          No hay link disponible para este empleado.
        </div>

        <!-- CON LINK -->
        <div id="lk_info" style="display:none;">
          <p class="mb-2">
            <b>Estado:</b>
            <span id="lk_estado" class="badge badge-secondary">—</span>
          </p>

          <div class="form-group mb-2">
            <label class="mb-1"><b>Link:</b></label>
            <div class="d-flex align-items-center">
              <a id="lk_url" href="#" target="_blank" class="text-truncate" style="max-width: 100%;">—</a>
              <button id="lk_copy" type="button" class="btn btn-outline-secondary btn-sm ml-2">Copiar</button>
            </div>
          </div>

          <div class="text-center my-3">
            <img id="lk_qr" src="" alt="QR" class="img-fluid border p-1" style="max-height:220px;">
          </div>

          <ul class="list-unstyled small mb-0">
            <li><b>Creación:</b> <span id="lk_creacion">—</span></li>
            <li><b>Expira:</b> <span id="lk_expira">—</span></li>
            <li><b>Usado en:</b> <span id="lk_used">—</span></li>
            <li><b>Revocado:</b> <span id="lk_revoked">—</span></li>
            <li><b>JTI:</b> <span id="lk_jti">—</span></li>
            <li><b>SHA16:</b> <span id="lk_sha">—</span></li>
          </ul>
        </div>
      </div>

      <div class="modal-footer">
        <button id="lk_btn_regen" type="button" class="btn btn-primary">Crear / Actualizar</button>
        <button id="lk_btn_revoke" type="button" class="btn btn-danger">Revocar / Eliminar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="docsModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Documentación del candidatooo: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <div id="tablaDocs" class="text-center"></div><br><br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 text-center">
            <label>Selecciona el documento</label><br>
            <input type="file" id="documento" class="doc_obligado" name="documento"
              accept=".jpg, .png, .jpeg, .pdf"><br><br>
            <br>
          </div>
          <div class="col-md-6 text-center">
            <label>Tipo de archivo *</label>
            <select name="tipo_archivo" id="tipo_archivo" class="form-control personal_obligado">
              <option value="">Selecciona</option>
              <?php
                  foreach ($tipos_docs as $t) {
                  if ($t->id == 3 || $t->id == 8 || $t->id == 9 || $t->id == 14 || $t->id == 45) {?>
              <option value="<?php echo $t->id; ?>"><?php echo $t->nombre; ?></option>
              <?php }
              }?>
            </select>
            <br>
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <Form method="POST" action="< ?php echo base_url('Candidato/downloadDocumentosPanelCliente'); ?>">
          <input type="hidden" id="idCandidatoDocs" name="idCandidatoDocs">
          <input type="hidden" id="nameCandidato" name="nameCandidato" class="nombreCandidato">

          <!--button type="submit" class="btn btn-primary">Descargar todos los documentos</button -->
        </form>

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="subirDoc()">Subir</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="docsModalInterno" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Documentación del candidato: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <div id="tablaDocsInterno" class="text-center"></div><br><br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 text-center">
            <label>Selecciona el documento</label><br>
            <input type="file" id="documentoInterno" class="doc_obligado" name="documentoInterno"
              accept=".jpg, .png, .jpeg, .pdf"><br><br>
            <br>
          </div>
          <div class="col-md-6 text-center">
            <label>Nombre del Archivo *</label>
            <input name="nombre_archivoInterno" id="nombre_archivoInterno" class="form-control personal_obligado">
            <input type="hidden" name="employee_id" id="employee_id">
            <input type="hidden" id="nameCandidatoInterno" name="nameCandidatoInterno">
            <input type="hidden" id="origen" name="origen">

            <br>
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <Form method="POST" action="< ?php echo base_url('Candidato/downloadDocumentosPanelCliente'); ?>">
          <input type="hidden" id="idCandidatoDocsInterno" name="idCandidatoDocsInterno">

          <!--button type="submit" class="btn btn-primary">Descargar todos los documentos</button -->
        </form>

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="subirDocInterno()">Subir</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="empDynModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          <i class="fas fa-user mr-2"></i>
          <span id="empDynTitle">Empleado</span>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div id="empDynAlert" class="alert alert-info py-2 px-3 mb-3" style="display:none;"></div>

        <ul class="nav nav-tabs" id="empDynTabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="tab-base" data-toggle="tab" href="#pane-base" role="tab">Datos base</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab-extra" data-toggle="tab" href="#pane-extra" role="tab">Informacion Adicional</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab-docs" data-toggle="tab" href="#pane-docs" role="tab">Documentos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="tab-exams" data-toggle="tab" href="#pane-exams" role="tab">Exámenes</a>
          </li>
        </ul>

        <div class="tab-content border-left border-right border-bottom p-3">
          <div class="tab-pane fade show active" id="pane-base" role="tabpanel">
            <div id="empDynBase"></div>
          </div>
          <div class="tab-pane fade" id="pane-extra" role="tabpanel">
            <div id="empDynExtra"></div>
          </div>
          <div class="tab-pane fade" id="pane-docs" role="tabpanel">
            <div id="empDynDocs"></div>
          </div>
          <div class="tab-pane fade" id="pane-exams" role="tabpanel">
            <div id="empDynExams"></div>
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="modalAsignarCliente" tabindex="-1" role="dialog" aria-labelledby="modalAsignarClienteLabel"
  aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalAsignarClienteLabel">Asignar a sucursal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="idCandidatoSeleccionado" value="">
        <div class="form-group">
          <label for="selectCliente">Sucursal (cliente)</label>
          <select id="selectCliente" class="form-control">
            <option value="">Cargando sucursales...</option>
          </select>
        </div>
        <div id="asignarAlert" class="alert alert-danger d-none mb-0">Seleccione una sucursal.</div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
        <button type="button" id="asignarCliente" class="btn btn-primary">Asignar</button>
      </div>

    </div>
  </div>
</div>


<?php
    // --- Preparar labels del periodo y vencimiento (ES) ---
    date_default_timezone_set('America/Mexico_City');
    $tz      = new DateTimeZone('America/Mexico_City');
    $hoy     = new DateTime('now', $tz);
    $periodo = new DateTime('first day of last month', $tz);       // mes anterior
    $vence   = new DateTime($hoy->format('Y-m-05 00:00:00'), $tz); // día 5 del mes actual

    if (class_exists('IntlDateFormatter')) {
        $fmtMesAnio    = new IntlDateFormatter('es_MX', IntlDateFormatter::LONG, IntlDateFormatter::NONE, $tz->getName(), IntlDateFormatter::GREGORIAN, "LLLL y");
        $fmtLargo      = new IntlDateFormatter('es_MX', IntlDateFormatter::LONG, IntlDateFormatter::NONE, $tz->getName(), IntlDateFormatter::GREGORIAN, "d 'de' LLLL 'de' y");
        $periodo_label = $fmtMesAnio->format($periodo);
        $vence_label   = $fmtLargo->format($vence);
    } else {
        // Fallback sin extensión intl (útil en Windows/Laragon)
        $MESES         = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        $periodo_label = ucfirst($MESES[(int) $periodo->format('n') - 1]) . ' ' . $periodo->format('Y');
        $vence_label   = $vence->format('j') . ' de ' . $MESES[(int) $vence->format('n') - 1] . ' de ' . $vence->format('Y');
    }
?>
<div class="modal fade" id="modalAvisoPago" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"
  data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">
          <i class="fas fa-exclamation-triangle mr-1"></i> Aviso de pago
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <p class="mb-1"><b>Periodo:</b> <?php echo htmlspecialchars($periodo_label) ?></p>
        <p class="mb-2"><b>Vence:</b> <?php echo htmlspecialchars($vence_label) ?></p>
        <?php if (isset($monto_label) && $monto_label !== ''): ?>
        <p class="mb-2"><b>Monto del periodo:</b><?php echo htmlspecialchars($monto_label) ?></p>
        <?php endif; ?>

        <div class="alert alert-info py-2">
          Para realizar el pago puedes:
          <ul class="mb-0 mt-2 pl-3">
            <li>
              <i class="fas fa-envelope"></i>
              Escribir a
              <a href="mailto:bramirez@rodicontrol.com">bramirez@rodicontrol.com</a>
            </li>
            <li>
              <i class="fas fa-phone"></i>
              Comunicarte por teléfono al
              <a href="tel:+523334542877">33 3454 2877</a>
              o por WhatsApp al
              <a href="https://wa.me/523334542877" target="_blank" rel="noopener">33 3454 2877</a>.
            </li>
            <li>
              <i class="fas fa-credit-card"></i>
              Presionar <b>“Ir a pagos”</b> para ingresar al apartado de <b>Pagos y Suscripción</b>, donde podrás
              generar un <b>link de pago</b> según tu suscripción y el monto indicado.
            </li>
          </ul>
        </div>

        <p class="text-muted small mb-0">
          Recuerda: el pago se realiza del <b>1 al 5</b> de cada mes. Para cualquier duda o aclaración,
          contáctanos por los medios mencionados anteriormente.
        </p>
      </div>

      <div class="modal-footer">
        <a href="<?php echo base_url('Area/pasarela'); ?>" class="btn btn-primary">
          <i class="fas fa-external-link-alt mr-1"></i> Ir a pagos
        </a>
        <button type="button" class="btn btn-success" id="btnEntendidoPago" data-dismiss="modal">Entendido</button>
      </div>
    </div>
  </div>
</div>


<script>
/**
 * Script de asignación de clientes a candidatos con DataTables y Bootstrap 4.
 *
 * Flujo:
 * 1. Inicialización:
 *    - Activa tooltips de Bootstrap para elementos con `data-toggle="tooltip"`.
 *    - Reaplica los tooltips cada vez que la tabla (`#tabla`) se redibuja.
 *
 * 2. Al hacer clic en ".btn-asignar-cliente":
 *    - Obtiene el ID del candidato desde el atributo `data-id`.
 *    - Guarda el ID en un input oculto `#idCandidatoSeleccionado`.
 *    - Limpia y carga el select `#selectCliente` con las sucursales obtenidas vía AJAX.
 *    - Si la carga falla, muestra un mensaje de error en el select.
 *    - Abre el modal `#modalAsignarCliente`.
 *
 * 3. Al confirmar con el botón "#asignarCliente":
 *    - Obtiene el candidato y el cliente seleccionados.
 *    - Valida que se haya elegido un cliente (si no, muestra alerta).
 *    - Envía una petición POST al backend (`cliente_general/asignarCliente`)
 *      con los datos requeridos (id_candidato, id_cliente).
 *    - Si la respuesta es exitosa:
 *        - Cierra el modal.
 *        - Recarga la tabla DataTable sin perder la paginación actual.
 *        - (Opcional) muestra un mensaje de éxito con toastr.
 *    - Si ocurre un error (backend o red), muestra un mensaje en `#asignarAlert`.
 *
 * Dependencias:
 * - jQuery (eventos, AJAX, manipulación DOM).
 * - Bootstrap 4 (tooltips, modales).
 * - DataTables (para redibujar la tabla y refrescar datos).
 * - CodeIgniter 3 (endpoints y opcionalmente protección CSRF).
 *
 * Uso:
 * - Se espera que el backend exponga:
 *    - `cliente_general/listarClientes`: retorna lista de sucursales en JSON.
 *    - `cliente_general/asignarCliente`: procesa la asignación y devuelve JSON con {status, message}.
 */
$(function() {
  // Tooltips BS4
  function initTips() {
    $('[data-toggle="tooltip"]').tooltip({
      container: 'body'
    });
  }
  initTips();
  $('#tabla').on('draw.dt', initTips);

  // Al hacer clic en el botón de cada fila
  $(document).on('click', '.btn-asignar-cliente', function() {
    const idCandidato = $(this).data('id');
    $('#idCandidatoSeleccionado').val(idCandidato);
    // console.log("🚀 ~ idCandidato:", idCandidato)
    $('#asignarAlert').addClass('d-none');

    // Limpia y carga el select
    $('#selectCliente').empty().append('<option value="">Cargando sucursales...</option>');

    // Llama al backend para traer sucursales (clientes)
    $.get('<?php echo site_url("Cliente/listarClientes"); ?>', function(resp) {
        $('#selectCliente').empty().append('<option value="0">Sin sucursal...</option>');

        if (Array.isArray(resp) && resp.length) {

          resp.forEach(function(cli) {
            $('#selectCliente').append(
              $('<option>', {
                value: cli.id,
                text: cli.nombre
              })
            );
          });
        } else {
          $('#selectCliente').append('<option value="">(Sin sucursales disponibles)</option>');
        }
      }, 'json')
      .fail(function() {
        $('#selectCliente').empty().append('<option value="">Error al cargar sucursales</option>');
      });

    // Abre modal
    $('#modalAsignarCliente').modal('show');
  });

  // Confirmar asignación
  $('#asignarCliente').on('click', function() {
    const idCandidato = $('#idCandidatoSeleccionado').val();
    // console.log("🚀 ~ idCandidato:", idCandidato)
    const idCliente = $('#selectCliente').val();

    if (!idCliente) {
      $('#asignarAlert').removeClass('d-none').text('Seleccione una sucursal.');
      return;
    }

    // Si usas CSRF en CI3, agrega token aquí:
    // const csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
    // const csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    $.post('<?php echo site_url("Cliente/asignarCliente"); ?>', {
        id_candidato: idCandidato,
        id_cliente: idCliente,
        // [csrfName]: csrfHash
      }, function(resp) {
        if (resp && resp.status === 'success') {


          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Asignación realizada',
            showConfirmButton: false,
            timer: 1800,
            timerProgressBar: true
          });
          $('#modalAsignarCliente').one('hidden.bs.modal', function() {
            window.location.reload(); // 👈 recarga cuando termine de cerrarse
          }).modal('hide');

          // Refresca la tabla
        } else {
          Swal.fire({
            icon: 'error',
            title: 'No se pudo asignar',
            text: (resp && resp.message) ? resp.message : 'Inténtalo nuevamente.'
          });
        }
      }, 'json')
      .fail(xhr => {
        Swal.close();
        const msg = (xhr.responseJSON && xhr.responseJSON.message) ?
          xhr.responseJSON.message :
          (xhr.statusText || 'Error de red');
        Swal.fire({
          icon: 'error',
          title: 'Error de red',
          text: msg
        });
      });
  });
});

/**
 * Muestra un modal de aviso de pago si la sesión contiene el estado "pendiente_en_plazo".
 *
 * Flujo:
 * 1. Al cargar la página:
 *    - Revisa la variable de sesión `notPago` enviada desde el backend.
 *    - Si el valor es "pendiente_en_plazo", abre el modal `#modalAvisoPago`.
 *
 * 2. Al dar clic en el botón "#btnEntendidoPago":
 *    - Envía una petición AJAX tipo POST al endpoint "Area/omitirAvisoPago".
 *    - Incluye el token CSRF si está habilitado en CodeIgniter.
 *    - Cierra el modal sin importar la respuesta del servidor.
 *
 * Dependencias:
 * - jQuery (para DOM y AJAX).
 * - Bootstrap Modal (para mostrar/ocultar el aviso).
 * - CodeIgniter 3 (para sesión y seguridad CSRF).
 *
 * Uso:
 * - El backend debe establecer en sesión `notPago = 'pendiente_en_plazo'`.
 * - El método "omitirAvisoPago" debe procesar la petición y actualizar la sesión.
 */
$(function() {
  // Si el backend dejó 'pendiente_en_plazo' en sesión, mostramos el modal
  var estadoPago = "<?php echo $this->session->userdata('notPago'); ?>";
  if (estadoPago === 'pendiente_en_plazo') {
    $('#modalAvisoPago').modal('show');
  }

  // Al dar clic en "Entendido", cambiamos la variable de sesión para esta sesión
  $('#btnEntendidoPago').on('click', function() {
    var data = {};
    <?php if (method_exists($this->security, 'get_csrf_token_name')): ?>
    data['<?php echo $this->security->get_csrf_token_name(); ?>'] =
      '<?php echo $this->security->get_csrf_hash(); ?>';
    <?php endif; ?>

    $.ajax({
      url: "<?php echo base_url('Area/omitirAvisoPago'); ?>",
      type: "POST",
      dataType: "json",
      data: data
    }).always(function() {
      // Cerramos el modal (éxito o no) y no se mostrará otra vez hasta relogueo
      $('#modalAvisoPago').modal('hide');
    });
  });
});
</script>


<script>
// ENDPOINTS (ajusta rutas si tu controlador se llama distinto)
if (typeof URL_GET === 'undefined') {
  var URL_GET = '<?php echo base_url('Reclutamiento/getLinkEmpleado'); ?>';
  var URL_REGEN = '<?php echo base_url('Client/regenerarLinkEmpleado'); ?>';
  var URL_REVOKE = '<?php echo base_url('Client/revocarLinkEmpleado'); ?>';
}

// Si necesitas id_portal desde sesión (ajústalo si tu sesión usa otra key/nombre)
var ID_PORTAL_SESSION = <?php echo json_encode((int) ($this->session->userdata('idPortal') ?? 0)); ?>;

function linkPreEmpleo(idEmpleado) {
  const $m = $('#modalLinkEmpleado');
  $m.data('id-empleado', idEmpleado);

  // Reset UI
  $('#lk_loader').show();
  $('#lk_empty').hide();
  $('#lk_info').hide();

  // Limpia contenido
  $('#lk_estado').attr('class', 'badge badge-secondary').text('—');
  $('#lk_url').text('—').attr('href', '#');
  $('#lk_qr').attr('src', '');
  $('#lk_creacion,#lk_expira,#lk_used,#lk_revoked,#lk_jti,#lk_sha').text('—');

  // Mostrar modal
  $m.modal('show');

  // Cargar datos
  $.getJSON(URL_GET, {
      id_empleado: idEmpleado
    })
    .done(function(resp) {
      $('#lk_loader').hide();

      if (!resp || resp.success === false) {
        $('#lk_empty').show().text(resp && resp.error ? resp.error : 'Error al consultar el link.');
        return;
      }

      if (!resp.exists) {
        $('#lk_empty').show();
        return;
      }

      // Hay link
      const r = resp.row || {};
      $('#lk_info').show();

      // Estado => badge
      const estado = resp.status || '—';
      const badgeClass = (estado === 'Activo') ? 'badge badge-success' :
        (estado === 'Expirado') ? 'badge badge-warning' :
        (estado === 'Revocado') ? 'badge badge-danger' :
        (estado === 'Usado') ? 'badge badge-secondary' :
        'badge badge-light';
      $('#lk_estado').attr('class', badgeClass).text(estado);

      // Link y QR
      if (r.link) {
        $('#lk_url').text(r.link).attr('href', r.link);
      }
      if (r.qr) {
        $('#lk_qr').attr('src', r.qr);
      }

      // Tiempos
      $('#lk_creacion').text(r.creacion ?? '—');
      $('#lk_expira').text(r.exp_unix ? new Date(r.exp_unix * 1000).toLocaleString() : '—');
      $('#lk_used').text(r.used_at ?? '—');
      $('#lk_revoked').text(r.revoked_at ?? '—');

      // Identificadores
      $('#lk_jti').text(r.jti ?? '—');
      $('#lk_sha').text(r.token_sha16 ?? '—');
    })
    .fail(function() {
      $('#lk_loader').hide();
      $('#lk_empty').show().text('No se pudo consultar el link.');
    });

  // Handlers de botones (rebind seguro)
  $('#lk_btn_regen').off('click').on('click', function() {
    const idEmpleado = $m.data('id-empleado');
    const payload = {
      id_empleado: idEmpleado,
      id_portal: ID_PORTAL_SESSION
    };

    bloqueoModal(true, 'Generando...');
    $.post(URL_REGEN, payload, null, 'json')
      .done(function(resp) {
        bloqueoModal(false);
        if (!resp || resp.success === false) {
          alert(resp && resp.error ? resp.error : 'No se pudo generar/actualizar el link.');
          return;
        }
        // Refresca con lo que regresó
        // re-uso del GET para pintar estados derivados (status, etc.)
        linkPreEmpleo(idEmpleado);
      })
      .fail(function() {
        bloqueoModal(false);
        alert('Error al generar/actualizar el link.');
      });
  });

  $('#lk_btn_revoke').off('click').on('click', function() {
    if (!confirm('¿Seguro que deseas revocar/eliminar el link?')) return;

    const idEmpleado = $m.data('id-empleado');
    bloqueoModal(true, 'Revocando...');
    $.post(URL_REVOKE, {
        id_empleado: idEmpleado
      }, null, 'json')
      .done(function(resp) {
        bloqueoModal(false);
        if (!resp || resp.success === false) {
          alert(resp && resp.error ? resp.error : 'No se pudo revocar/eliminar el link.');
          return;
        }
        // Refresca
        linkPreEmpleo(idEmpleado);
      })
      .fail(function() {
        bloqueoModal(false);
        alert('Error al revocar/eliminar el link.');
      });
  });

  $('#lk_copy').off('click').on('click', function() {
    const url = $('#lk_url').attr('href');
    if (!url || url === '#') return;
    navigator.clipboard.writeText(url)
      .then(() => {
        $(this).text('¡Copiado!');
        setTimeout(() => $(this).text('Copiar'), 1200);
      })
      .catch(() => alert('No se pudo copiar.'));
  });
}

function bloqueoModal(lock, msg) {
  if (lock) {
    $('#lk_loader').show().find('.small').text(msg || 'Procesando…');
    $('#lk_btn_regen,#lk_btn_revoke').prop('disabled', true);
  } else {
    $('#lk_loader').hide();
    $('#lk_btn_regen,#lk_btn_revoke').prop('disabled', false);
  }
}


if (typeof window.BASE4 === 'undefined') {
  window.BASE4 = "<?php echo base_url('tu_ruta'); ?>";
}
// ========= Utilidades =========
function esc(s) {
  return $('<div/>').text(s == null ? '' : String(s)).html();
}

function niceKey(k) {
  return esc(String(k).replace(/_/g, ' ').replace(/\b\w/g, m => m.toUpperCase()));
}

function isImage(name) {
  return /\.(png|jpe?g|gif|webp|bmp)$/i.test(name || '');
}

function isPdf(name) {
  return /\.pdf$/i.test(name || '');
}

// Ajusta a tu endpoint seguro (Files/stream, docs/ver_doc, etc.)
function buildDocUrl(fileName, kind) {
  const base = (kind === 'exam') ? 'exams' : 'docs';
  return BASE4 + base + "/" + encodeURIComponent(fileName);
}

// Campos a ignorar por clave / patrón
if (!Array.isArray(window.IGNORE_KEYS)) {
  window.IGNORE_KEYS = ['id', 'id_empleado', 'id_domicilio_empleado', 'id_usuario', 'id_cliente', 'id_portal', 'status',
    'convenio_confidencialidad', 'acuerdo_confidencialidad', 'foto_asociado', 'cedula_identidad'
  ];
}

if (!Array.isArray(window.IGNORE_PARTIAL)) {
  window.IGNORE_PARTIAL = ['creacion', 'edicion', 'updated', 'fecha', 'eliminado', 'status'];
} // oculta fechas e indicadores internos

function shouldIgnoreKey(k, v) {
  if (!k) return true;
  const key = String(k).toLowerCase();

  // ignora ids y campos tipo fecha/flags internos
  if (IGNORE_KEYS.includes(key)) return true;
  if (IGNORE_PARTIAL.some(p => key.includes(p))) return true;

  // ignora valores vacíos
  if (v == null) return true;
  const sv = String(v).trim().toLowerCase();
  if (sv === '' || sv === 'null') return true;

  return false;
}
// 0/1 → No/Sí (badges). Si quieres texto simple, cambia por "No"/"Sí"
function formatValue(v) {
  if (v == null) return '';
  const s = String(v).trim().toLowerCase();

  if (s === '0') return '<span class="badge badge-danger">No</span>';
  if (s === '1') return '<span class="badge badge-success">Sí</span>';
  if (s === 'null') return '';

  return esc(v);
}
// ========= Renderizadores =========
function renderKV(obj) {
  const keys = Object.keys(obj || {});
  const rows = keys
    .filter(k => !shouldIgnoreKey(k, obj[k]))
    .map(k => `<tr><th style="width:240px;">${niceKey(k)}</th><td>${formatValue(obj[k])}</td></tr>`)
    .join('');
  if (!rows) return '<div class="text-muted">Sin datos</div>';
  return `<div class="table-responsive">
      <table class="table table-sm table-bordered mb-0"><tbody>${rows}</tbody></table>
    </div>`;
}

function renderCamposExtra(list) {
  if (!list || !list.length) return '<div class="text-muted">Sin informacion extra</div>';

  const rows = list
    .filter(it => !shouldIgnoreKey(it && it.nombre, it && it.valor))
    .map(it => {
      const val = it.valor || '';
      // Si parece archivo, crea link
      if (/\.(pdf|png|jpe?g|gif|webp|bmp)$/i.test(val)) {
        const fileName = val.split('/').pop(); // si guardas subcarpeta, ajusta aquí
        const url = buildDocUrl(fileName);
        const icon = isPdf(val) ? 'fa-file-pdf' : 'fa-image';
        return `<tr>
            <th style="width:260px;">${niceKey(it.nombre)}</th>
            <td><a href="${url}" target="_blank"><i class="far ${icon} mr-1"></i>${esc(val)}</a></td>
          </tr>`;
      }
      // valor normal (con 0/1 → No/Sí)
      return `<tr>
          <th style="width:260px;">${niceKey(it.nombre)}</th>
          <td>${formatValue(val)}</td>
        </tr>`;
    })
    .join('');

  if (!rows) return '<div class="text-muted">Sin campos extra</div>';
  return `<div class="table-responsive">
      <table class="table table-sm table-bordered mb-0"><tbody>${rows}</tbody></table>
    </div>`;
}

function abbreviateFilename(name, max = 32) {
  if (!name) return '';
  // quitar ruta y querystrings
  const basePart = name.split(/[\\/]/).pop();
  const clean = basePart.split('?')[0];

  if (clean.length <= max) return clean;

  const dot = clean.lastIndexOf('.');
  let ext = '',
    base = clean;
  if (dot > 0 && dot < clean.length - 1) {
    ext = clean.slice(dot);
    base = clean.slice(0, dot);
  }

  const available = max - ext.length; // espacio para la base (sin extensión)
  if (available <= 1) return clean.slice(0, max - 1) + '…';

  const front = Math.ceil((available - 1) / 2);
  const back = Math.floor((available - 1) / 2);

  return base.slice(0, front) + '…' + base.slice(-back) + ext;
}
 const URL_VER_DOC  = '<?= site_url("archivo/ver_doc/") ?>';
  const URL_VER_EXAM = '<?= site_url("archivo/ver_exam/") ?>';
function renderDocs(list) {
  if (!list || !list.length) return '<div class="text-muted">Sin documentos</div>';

  const rows = list.map(d => {
    const file = d.name || d.filename || '';
    if (!file) return null;

    const url = URL_VER_DOC+file;
    const icon = isPdf(file) ? 'fa-file-pdf' : (isImage(file) ? 'fa-image' : 'fa-file');
    const desc = d.description || d.nameDocument || '';
    const status = (d.status === '0' || d.status === 0) ? '<span class="badge badge-secondary">Inactivo</span>' :
      (d.status === '1' || d.status === 1) ? '<span class="badge badge-success">Activo</span>' :
      esc(d.status || '');

    // 👇 abreviado para mostrar, completo en title
    const shortFile = abbreviateFilename(file, 32);

    return `<tr>
      <td class="text-nowrap">
        <a href="${url}" target="_blank" title="${esc(file)}">
          <i class="far ${icon} mr-1"></i>${esc(shortFile)}
        </a>
      </td>
      <td>${formatValue(desc)}</td>
      <td>${status}</td>
    </tr>`;
  }).filter(Boolean).join('');

  if (!rows) return '<div class="text-muted">Sin documentos</div>';

  return `<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered mb-0">
      <thead class="thead-light">
        <tr><th>Archivo</th><th>Descripción</th><th>Status</th></tr>
      </thead>
      <tbody>${rows}</tbody>
    </table>
  </div>`;
}


function renderExams(list) {
  if (!list || !list.length) return '<div class="text-muted">Sin exámenes</div>';

  const rows = list
    .map(x => {
      const file = x.name || '';
      if (!file) return null;

    const url = URL_VER_EXAM+file;
         const icon = isPdf(file) ? 'fa-file-pdf' : (isImage(file) ? 'fa-image' : 'fa-file');

      const nombreDoc = x.nameDocument || '';
      const status = (x.status === '0' || x.status === 0) ? '<span class="badge badge-secondary">Inactivo</span>' :
        (x.status === '1' || x.status === 1) ? '<span class="badge badge-success">Activo</span>' :
        esc(x.status || '');

      return `<tr>
          <td class="text-nowrap"><a href="${url}" target="_blank"><i class="far ${icon} mr-1"></i>${esc(file)}</a></td>
          <td>${formatValue(nombreDoc)}</td>
          <td>${status}</td>
        </tr>`;
    })
    .filter(Boolean)
    .join('');

  if (!rows) return '<div class="text-muted">Sin exámenes</div>';
  return `<div class="table-responsive">
      <table class="table table-sm table-striped table-bordered mb-0">
        <thead class="thead-light"><tr><th>Archivo</th><th>Nombre Doc</th><th>Status</th></tr></thead>
        <tbody>${rows}</tbody>
      </table>
    </div>`;
}

// ========= Carga y pintado del modal =========
function verCandidato(id) {
  // encabezado + placeholders
  $('#empDynTitle').text('Empleado #' + id);
  $('#empDynAlert').hide().removeClass('alert-danger').addClass('alert-info').text('');
  $('#empDynBase').html('<div class="text-muted">Cargando…</div>');
  $('#empDynExtra').empty();
  $('#empDynDocs').empty();
  $('#empDynExams').empty();

  // abrir modal
  $('#empDynModal').modal('show');

  // AJAX directo al controlador (sin rutas personalizadas)
  $.ajax({
      url: BASE4 + "index.php/Empleados/getEmpleado/" + encodeURIComponent(id),
      type: "GET",
      dataType: "json"
    })
    .done(function(resp) {
      if (!resp || !resp.ok) {
        $('#empDynAlert').show().addClass('alert-danger').removeClass('alert-info')
          .text('No se pudo obtener información del empleado.');
        return;
      }

      const D = resp.data || {};

      // Datos base (filtrado de ids/fechas/vacíos y 0/1 → No/Sí)
      $('#empDynBase').html(renderKV(D.base || {}));

      // Campos extra
      $('#empDynExtra').html(renderCamposExtra(D.campos_extra || []));

      // Documentos
      $('#empDynDocs').html(renderDocs(D.documentos || []));

      // Exámenes
      $('#empDynExams').html(renderExams(D.examenes || []));
    })
    .fail(function(xhr) {
      $('#empDynAlert').show().addClass('alert-danger').removeClass('alert-info')
        .text('Error al cargar los datos del empleado.');
      console.log('getEmpleado FAIL', xhr.responseText);
    });
}
</script>