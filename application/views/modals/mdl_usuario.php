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
</script>