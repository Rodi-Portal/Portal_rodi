<?php
    if (! function_exists('ts_section_label')) {
        function ts_section_label(string $slug): string
        {
            $slug = trim($slug);
            // quita prefijos "__"
            $slug = preg_replace('/^__+/', '', $slug);
            // separa niveles: "expediente.generales" -> "expediente · generales"
            $slug = str_replace('.', ' · ', $slug);
            // underscores a espacios: "bgv_examenes" -> "bgv examenes"
            $slug = str_replace('_', ' ', $slug);
            // MAYÚSCULAS
            return mb_strtoupper($slug, 'UTF-8');
        }
    }
?>


<div class="p-3">
  <div class="d-flex align-items-center mb-2">
    <h6 class="mr-3 mb-0">Permisos por usuario</h6>
    <span class="text-muted">Usuario ID: <?php echo (int) $user_id; ?></span>
  </div>

  <form id="permFormModal" method="post" action="#">
    <div class="form-row mb-2">
      <div class="col-auto">
        <label class="mb-1">Módulo</label>
        <select id="modSelector" class="form-control form-control-sm">
          <?php foreach ($modules as $m): $mval = $m['module']; ?>
          <?php $label                                   = mb_strtoupper(str_replace('_', ' ', $mval), 'UTF-8'); ?>
          <option value="<?php echo html_escape($mval); ?>" <?php echo $mval === $module ? 'selected' : ''; ?>>
            <?php echo html_escape($label); ?>
          </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col">
        <label class="mb-1">Buscar</label>
        <input type="text" id="filtroModal" class="form-control form-control-sm"
          placeholder="Filtra por sección, acción o clave...">
      </div>
    </div>

    <?php if (! empty($module)): ?>
    <?php if ((int) ($stats['total'] ?? 0) > 0): ?>
    <div class="alert alert-success py-2">
      <strong>Configuración previa:</strong>
      <span class="ml-2 badge badge-success">ALLOW: <?php echo (int) $stats['allow']; ?></span>
      <span class="ml-2 badge badge-danger">DENY: <?php echo (int) $stats['deny']; ?></span>
    </div>
    <?php else: ?>
    <div class="alert alert-info py-2">
      Sin configuración previa (todo en <em>Heredar</em>, deny por defecto).
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <?php if (empty($secciones)): ?>
    <div class="alert alert-info">No hay permisos para mostrar.</div>
    <?php else: ?>
    <?php foreach ($secciones as $section => $rows): ?>
    <div class="card mb-2">
      <div class="card-header py-2 d-flex justify-content-between align-items-center">
        <strong><?php echo html_escape(ts_section_label($section)); ?></strong>
        <div class="btn-group btn-group-sm">
          <button type="button" class="btn btn-outline-success"
            onclick="marcarFilaModal('<?php echo addslashes($section); ?>','allow')">Allow</button>
          <button type="button" class="btn btn-outline-danger"
            onclick="marcarFilaModal('<?php echo addslashes($section); ?>','deny')">Deny</button>
          <button type="button" class="btn btn-outline-secondary"
            onclick="marcarFilaModal('<?php echo addslashes($section); ?>','inherit')">Heredar</button>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-sm mb-0 tabla-perms-modal">
          <thead class="thead-light">
            <tr>
              <th style="width:40%">Permiso</th>
              <th style="width:20%">Acción</th>
              <th style="width:15%">Sensibilidad</th>
              <th style="width:25%">Efecto</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r):
                    $key  = $r['key'];
                    $act  = $r['action'];
                    $sens = (int) $r['is_sensitive'] === 1;
                    $eff  = $r['effect']; // 'allow' | 'deny' | null (heredar)

                    // ---------- Presentación “bonita” de la 1ª columna ----------
                    // Mapa de iconos por acción (ajusta según tus acciones reales)
                    $icons = [
                        'ver'                 => 'fa-eye', 'crear'                       => 'fa-plus', 'editar'       => 'fa-edit', 'eliminar' => 'fa-trash-alt',
                        'cargar'              => 'fa-upload', 'descargar'                => 'fa-download', 'exportar' => 'fa-file-export',
                        'asignar'             => 'fa-user-check', 'registrar_candidato'  => 'fa-user-plus',
                        'cambiar_de_sucursal' => 'fa-exchange-alt', 'enviar_a_empleados' => 'fa-share-square',
                        'subir'               => 'fa-upload', 'bajar'                    => 'fa-download',
                    ];
                    $ico = isset($icons[$act]) ? $icons[$act] : 'fa-check-circle';

                    $human = function ($s) {return ucfirst(str_replace('_', ' ', strtolower((string) $s)));};
                    $modNice = mb_strtoupper(str_replace('_', ' ', $r['module']), 'UTF-8');
                    $secNice = ts_section_label($section);
                    $actNice = $human($act);
                    $desc    = ! empty($r['description']) ? $r['description'] : $actNice; // requiere p.description en el SELECT del modelo
                                                                                         // ----------------------------------------------------------------
                ?>
            <tr data-section="<?php echo html_escape($section); ?>" data-key="<?php echo html_escape($key); ?>">
              <td>
                <div class="perm-cell">
                  <div class="perm-icon<?php echo $sens ? ' perm-icon-warn' : ''; ?>">
                    <i
                      class="fas		                                	                                	                                		                                	                                		                                	                                	                                	                                 	                                      <?php echo $ico; ?>"></i>
                  </div>
                  <div>
                    <div class="perm-title text-truncate-1" title="<?php echo html_escape($desc); ?>">
                      <?php echo html_escape($desc); ?>
                    </div>
                    <div class="perm-meta mt-1">
                      <span class="badge badge-soft"><?php echo html_escape($modNice); ?></span>
                      <span class="mx-1">›</span>
                      <span class="badge badge-soft"><?php echo html_escape($secNice); ?></span>
                      <a href="javascript:void(0)" class="ml-2 perm-key copy-key"
                        data-key="<?php echo html_escape($key); ?>" data-toggle="tooltip" title="Copiar clave">
                        <i class="far fa-copy"></i> <span
                          class="d-none d-sm-inline"><?php echo html_escape($key); ?></span>
                      </a>
                    </div>
                  </div>
                </div>
              </td>

              <td><span class="badge badge-primary"><?php echo html_escape($act); ?></span></td>

              <td>
                <?php if ($sens): ?>
                <span class="badge badge-warning">Sensible</span>
                <?php else: ?>
                <span class="text-muted small">–</span>
                <?php endif; ?>
              </td>

              <td>
                <?php $keyEnc = rtrim(strtr(base64_encode($key), '+/', '-_'), '='); ?>

                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="eff_enc[<?php echo $keyEnc ?>]" id="m-allow-<?php echo md5($key) ?>"
                    class="custom-control-input" value="allow" <?php echo $eff === 'allow' ? 'checked' : ''; ?>>
                  <label class="custom-control-label" for="m-allow-<?php echo md5($key) ?>">Allow</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="eff_enc[<?php echo $keyEnc ?>]" id="m-deny-<?php echo md5($key) ?>"
                    class="custom-control-input" value="deny" <?php echo $eff === 'deny' ? 'checked' : ''; ?>>
                  <label class="custom-control-label" for="m-deny-<?php echo md5($key) ?>">Deny</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                  <input type="radio" name="eff_enc[<?php echo $keyEnc ?>]" id="m-inh-<?php echo md5($key) ?>"
                    class="custom-control-input" value="inherit" <?php echo is_null($eff) ? 'checked' : ''; ?>>
                  <label class="custom-control-label" for="m-inh-<?php echo md5($key) ?>">Heredar</label>
                </div>

              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>

    <div class="d-flex justify-content-end">
      <button type="button" id="btnGuardarPermisos" class="btn btn-primary">
        Guardar cambios
      </button>
    </div>

    <input type="hidden" name="user_id" value="<?php echo (int) $user_id; ?>">
    <input type="hidden" name="module" value="<?php echo html_escape($module); ?>">
  </form>
</div>

<script>
function formatModLabel(slug) {
  return (slug || '').replace(/_/g, ' ').toUpperCase();
}
// Delegado: copiar clave
$(document).off('click', '.copy-key').on('click', '.copy-key', function() {
  var key = $(this).data('key') || '';
  if (!key) return;
  var ta = document.createElement('textarea');
  ta.value = key;
  document.body.appendChild(ta);
  ta.select();
  document.execCommand('copy');
  document.body.removeChild(ta);

  if (window.Swal) {
    Swal.fire({
      toast: true,
      position: 'top-end',
      timer: 1200,
      showConfirmButton: false,
      icon: 'success',
      title: 'Clave copiada'
    });
  } else if ($.fn.tooltip) {
    $(this).attr('data-original-title', '¡Copiada!').tooltip('show');
    setTimeout(() => $(this).tooltip('hide').attr('data-original-title', 'Copiar clave'), 900);
  }
});

// Filtro en modal
document.getElementById('filtroModal')?.addEventListener('input', function() {
  const q = this.value.toLowerCase();
  document.querySelectorAll('#modalPermisos table.tabla-perms-modal tbody tr').forEach(tr => {
    const key = (tr.getAttribute('data-key') || '').toLowerCase();
    const sec = (tr.getAttribute('data-section') || '').toLowerCase();
    tr.style.display = (key.includes(q) || sec.includes(q)) ? '' : 'none';
  });
});

// Marcar toda la sección
function marcarFilaModal(section, effect) {
  document.querySelectorAll('#modalPermisos tr[data-section="' + section + '"]').forEach(tr => {
    const radios = tr.querySelectorAll('input[type="radio"]');
    radios.forEach(r => {
      const isAllow = effect === 'allow' && r.id.indexOf('m-allow-') === 0;
      const isDeny = effect === 'deny' && r.id.indexOf('m-deny-') === 0;
      const isInherit = effect === 'inherit' && r.id.indexOf('m-inh-') === 0;
      if (isAllow || isDeny || isInherit) r.checked = true;
    });
  });
}

// Cambiar de módulo = recargar el cuerpo del modal
(function() {
  var baseUrl = window.BASE_URL || '<?php echo base_url(); ?>';
  var userId = <?php echo (int) $user_id; ?>;

  $('#modSelector').on('change', function() {
    var mod = $(this).val() || '';
    var url = baseUrl + 'permisos/usuario/' + userId + '?module=' + encodeURIComponent(mod) + '&partial=1';
    $('#modalPermisos .modal-body').load(url, function() {
      // Actualiza el título del modal
      $('#modalPermisos .modal-title')
        .text('Permisos del usuario #' + userId + ' · ' + formatModLabel(mod));

      // Re-inicializa tooltips si usas Bootstrap tooltip
      if ($.fn.tooltip) {
        $('#modalPermisos [data-toggle="tooltip"]').tooltip({
          container: '#modalPermisos'
        });
      }
    });
  });

  // Inicializa tooltips al cargar este parcial
  if ($.fn.tooltip) {
    $('#modalPermisos [data-toggle="tooltip"]').tooltip({
      container: '#modalPermisos'
    });
  }
})();

$(document).off('click', '#btnGuardarPermisos').on('click', '#btnGuardarPermisos', function() {
  const $btn = $(this);
  const $form = $('#permFormModal');
  $btn.prop('disabled', true).text('Guardando...');

  $.ajax({
    url: (window.BASE_URL || '<?php echo base_url(); ?>') + 'permisos/guardar',
    type: 'post',
    dataType: 'json',
    data: $form.serialize(), // user_id, module, eff[key]=allow|deny|inherit
    beforeSend: function() {
      $('.loader').css('display', 'block');
    },
    success: function(res) {
      $('.loader').fadeOut();
      if (!res || res.ok !== true) {
        Swal.fire('Atención', (res && res.msg) ? res.msg : 'No se pudieron guardar los permisos.', 'warning');
        return;
      }
      Swal.fire('Listo', res.msg || 'Permisos guardados correctamente.', 'success');

      // Recarga el mismo parcial para reflejar cambios
      const userId = <?php echo (int) $user_id ?>;
      const mod = '<?php echo rawurlencode($module ?: "") ?>';
      const url = (window.BASE_URL || '<?php echo base_url(); ?>') + 'permisos/usuario/' + userId +
        '?module=' + mod + '&partial=1';
      $('#modalPermisos .modal-body').load(url, function() {
        // re-inicializa tooltips, etc., si usas
        if ($.fn.tooltip) {
          $('#modalPermisos [data-toggle="tooltip"]').tooltip({
            container: '#modalPermisos'
          });
        }
      });
    },
    error: function() {
      $('.loader').fadeOut();
      Swal.fire('Error', 'Ocurrió un error al guardar.', 'error');
    },
    complete: function() {
      $btn.prop('disabled', false).text('Guardar cambios');
    }
  });
});
</script>

<style>
.perm-cell {
  display: flex;
  align-items: flex-start;
}

.perm-icon {
  width: 34px;
  height: 34px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: .6rem;
  background: #f5f6f8;
}

.perm-icon-warn {
  background: #fff8e1;
}

/* fondo ámbar si es sensible */
.perm-title {
  font-weight: 600;
  line-height: 1.1;
}

.perm-meta {
  font-size: 12px;
  color: #6c757d;
}

.perm-key {
  font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
}

.badge-soft {
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  font-weight: 500;
}

.text-truncate-1 {
  display: block;
  max-width: 380px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

@media (max-width: 992px) {
  .text-truncate-1 {
    max-width: 220px;
  }
}
</style>