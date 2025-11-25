<?php
    // Ya te llegan del controlador:
    // $columnas_disponibles (keys de permisos), $columnas_usuario (seleccionadas),
    // $columnas_fijas, $columnas_ocultas
    $columnas_disponibles = $columnas_disponibles ?? [];
    $columnas_usuario     = $columnas_usuario ?? [];
    $columnas_fijas       = $columnas_fijas ?? [];
    $columnas_ocultas     = $columnas_ocultas ?? [];

    // Dinámicas = disponibles - fijas - ocultas
    $columnas_dinamicas = [];
    foreach ($columnas_disponibles as $col) {
        if (! in_array($col, $columnas_fijas, true) && ! in_array($col, $columnas_ocultas, true)) {
            $columnas_dinamicas[] = $col;
        }
    }

    // Las que pintas en THEAD/TBODY (todas las dinámicas; luego se ocultan por JS)
    $columnas_visibles = $columnas_dinamicas;

    // Para JS
    $DINAMICAS_JS = json_encode(array_values($columnas_dinamicas));
    $SEL_JS       = json_encode(array_values($columnas_usuario));
    $TABLE_KEY    = 'mensajeria'; // el módulo donde guardas
?>

<div class="container-fluid">
  <input type="text" id="focus-catcher" style="position:absolute; left:-9999px; width:1px; height:1px; opacity:0;"
    tabindex="-1" />

  <h2 class="modulo-titulo"><?php echo lang('mod_com_title'); ?></h2>
  <p><?php echo lang('mod_com_intro'); ?></p>

  <div class="d-flex justify-content-end mb-3 gap-2">
    <button class="btn btn-config" data-toggle="modal" data-target="#columnModal">
      <i class="fas fa-cogs mr-1"></i> <?php echo lang('mod_com_btn_columns'); ?>
    </button>

    <button class="btn btn-success" id="accionMasiva">
      <i class="fas fa-tasks mr-1"></i> <?php echo lang('mod_com_btn_mass_action'); ?>
    </button>
  </div>

  <table id="processTable" class="table table-striped table-hover display nowrap" style="width:100%;">
    <thead>
      <tr>
        <th><input type="checkbox" id="selectAll"></th>
        <th><?php echo lang('mod_table_branch'); ?></th>
        <?php foreach ($columnas_visibles as $col): ?>
        <?php
      // Intentar traducir: mod_com_col_TELEFONO, mod_com_col_ESTADO, etc.
      $key   = 'mod_com_col_' . strtoupper($col);
      $label = lang($key);

      // Si no existe traducción, usar el nombre tal cual
      if ($label === $key) {
          $label = htmlspecialchars($col, ENT_QUOTES, 'UTF-8');
      }
  ?>
        <th><?php echo $label; ?></th>
        <?php endforeach; ?>

        <th><?php echo lang('mod_table_users_access'); ?></th>
        <th><?php echo lang('mod_emp_th_employees'); ?></th>
        <th><?php echo lang('mod_table_actions'); ?></th>
      </tr>

      <tr>
        <th></th>

        <!-- Filtro sucursal -->
        <th>
          <input type="text" class="form-control form-control-sm"
            placeholder="<?php echo lang('mod_com_filter_branch'); ?>" autocomplete="off"
            name="search_sucursal_<?php echo uniqid(); ?>" readonly onfocus="this.removeAttribute('readonly');">
        </th>

        <!-- Filtros dinámicos por columna -->
        <?php foreach ($columnas_visibles as $col): ?>
        <th>
          <input type="text" class="form-control form-control-sm"
            placeholder="<?php echo lang('mod_com_filter_any_prefix') . ' ' . htmlspecialchars($col, ENT_QUOTES, 'UTF-8'); ?>"
            autocomplete="off" name="search_<?php echo uniqid(); ?>" readonly
            onfocus="this.removeAttribute('readonly');">
        </th>
        <?php endforeach; ?>

        <!-- Filtro usuarios -->
        <th>
          <input type="text" class="form-control form-control-sm"
            placeholder="<?php echo lang('mod_com_filter_users'); ?>" autocomplete="off"
            name="search_usuarios_<?php echo uniqid(); ?>" readonly onfocus="this.removeAttribute('readonly');">
        </th>

        <!-- Filtro empleados -->
        <th>
          <input type="text" class="form-control form-control-sm"
            placeholder="<?php echo lang('mod_com_filter_employees'); ?>" autocomplete="off"
            name="search_empleados_<?php echo uniqid(); ?>" readonly onfocus="this.removeAttribute('readonly');">
        </th>

        <th></th>
      </tr>
    </thead>

    <tbody>
      <?php if (! empty($permisos)): ?>
      <?php foreach ($permisos as $p): ?>
      <tr>
        <td>
          <input type="checkbox" class="row-select" data-id="<?php echo $p['id_cliente']; ?>">
        </td>

        <td><?php echo htmlspecialchars($p['nombreCliente']); ?></td>

        <?php foreach ($columnas_disponibles as $col): ?>
        <?php if (! in_array($col, $columnas_fijas, true) && ! in_array($col, $columnas_ocultas, true)): ?>
        <td>
          <?php
                      if (isset($p[$col])) {
                          if (is_array($p[$col])) {
                              echo htmlspecialchars(json_encode($p[$col]));
                          } else {
                              echo htmlspecialchars($p[$col]);
                          }
                      } else {
                          echo lang('mod_table_na');
                      }
                  ?>
        </td>
        <?php endif; ?>
        <?php endforeach; ?>

        <!-- Usuarios con acceso -->
        <td>
          <ul class="usuarios-acceso-list">
            <?php foreach ($p['usuarios'] as $usuario): ?>
            <li class="usuario-acceso-item">
              <div class="usuario-info">
                <span class="usuario-nombre">
                  <?php echo htmlspecialchars($usuario['nombre_completo'], ENT_QUOTES, 'UTF-8'); ?>
                </span>
                <span class="usuario-detalle">
                  <?php echo htmlspecialchars($usuario['rol'], ENT_QUOTES, 'UTF-8'); ?>
                  · ID:<?php echo htmlspecialchars($usuario['id_usuario'], ENT_QUOTES, 'UTF-8'); ?>
                </span>
              </div>

              <?php
                          $idRol = $this->session->userdata('idrol');
                          if ($idRol == 6 || $idRol == 1):
                      ?>
              <button type="button" class="btn-usuario-remove eliminar-permiso"
                data-id_usuario="<?php echo $usuario['id_usuario']; ?>"
                data-id_cliente="<?php echo $p['id_cliente']; ?>"
                title="<?php echo $this->lang->line('mod_perm_delete_tooltip'); ?>">
                <i class="fa fa-trash"></i>
              </button>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </td>

        <!-- Resumen empleados -->
        <td>
          <ul class="pl-3 mb-0">
            <li><strong><?php echo lang('mod_ex_max_number'); ?></strong><?php echo htmlspecialchars($p['max']); ?></li>
            <li>
              <strong><?php echo lang('mod_emp_lbl_active'); ?>:</strong><?php echo htmlspecialchars($p['empleados_activos']); ?>
            </li>
            <li>
              <strong><?php echo lang('mod_emp_lbl_inactive'); ?>:</strong><?php echo htmlspecialchars($p['empleados_inactivos']); ?>
            </li>
          </ul>
        </td>

        <!-- Acciones -->
        <td>
          <a href="<?php echo site_url('comunicacion/' . $p['id_cliente']); ?>" class="btn-ver-empleados">
            <!-- si quieres, crea mod_com_btn_enter en el lang -->
            <?php echo lang('mod_com_btn_enter') ?? 'Entrar'; ?>
          </a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php else: ?>
      <tr>
        <td
          colspan="<?php echo 3 + count($columnas_disponibles) - count($columnas_fijas) - count($columnas_ocultas); ?>">
          <?php echo lang('mod_com_no_data'); ?>
        </td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Modal para seleccionar columnas -->
<div class="modal fade" id="columnModal" tabindex="-1" role="dialog" aria-labelledby="columnModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <form id="columnSettingsForm" data-table="<?php echo $TABLE_KEY; ?>">
        <input type="hidden" id="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>"
          value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="modal-header">
          <h5 class="modal-title" id="columnModalLabel"><?php echo lang('mod_com_btn_columns'); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <?php if (! empty($columnas_dinamicas)): ?>
          <?php foreach ($columnas_dinamicas as $name): ?>
          <div class="form-check">
            <input class="form-check-input column-toggle" type="checkbox" value="<?php echo htmlspecialchars($name); ?>"
              id="col_<?php echo htmlspecialchars($name); ?>"
              <?php echo in_array($name, $columnas_usuario, true) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="col_<?php echo htmlspecialchars($name); ?>">
              <?php echo htmlspecialchars($name); ?>
            </label>
          </div>
          <?php endforeach; ?>
          <?php else: ?>
          <p><?php echo lang('mod_com_no_data'); ?></p>
          <?php endif; ?>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <?php echo lang('mod_com_mass_cancel_btn'); ?>
          </button>
          <button type="button" class="btn btn-primary" id="applyColumnSettings" data-dismiss="modal">
            <?php echo lang('mod_com_btn_apply') ?? 'Aplicar'; ?>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Listas generadas por PHP
const DINAMICAS = <?php echo $DINAMICAS_JS; ?>; // p.ej. ["telefono","estado","pais","ciudad"]
const SELECCIONADAS = <?php echo $SEL_JS; ?>; // p.ej. ["telefono","estado"]
const BASE1 = 2; // 0=checkbox, 1=Sucursal; dinámicas empiezan en la 2

$(document).ready(function() {
  // Evita doble inicialización
  const table = $.fn.DataTable.isDataTable('#processTable') ?
    $('#processTable').DataTable() :
    $('#processTable').DataTable({
      scrollX: true,
      responsive: true,
      orderCellsTop: true, // importante con 2 filas en THEAD
      order: [],
    });

  // Mostrar SOLO fijas + seleccionadas
  const selected = new Set(SELECCIONADAS);
  DINAMICAS.forEach((name, i) => {
    const colIdx = BASE1 + i; // índice físico en la tabla
    const visible = selected.has(name);
    table.column(colIdx).visible(visible);
  });

  // Sincroniza checks del modal (value = nombre)
  $('#columnSettingsForm .column-toggle').each(function() {
    this.checked = selected.has(this.value);
  });

  // ===== Filtros por columna (compatible con scrollX/responsive y readonly) =====
  const api = table;
  const $container = $(api.table().container());

  function wireColumnFilters() {
    // header visible cuando hay scrollX; si no, usa thead normal
    const $head = $container.find('.dataTables_scrollHead thead').length ?
      $container.find('.dataTables_scrollHead thead') :
      $(api.table().header()).parent();

    // limpia handlers previos para no duplicar
    $head.off('.colfilter');

    // tu estrategia anti-autocompletar: quitar readonly al enfocar
    $head.on('focus.colfilter', 'tr:eq(1) th input', function() {
      this.removeAttribute('readonly');
      this.setAttribute('autocomplete', 'off');
    });

    // filtrar por columna (mapeo por nodo <th> real)
    $head.on('input.colfilter change.colfilter', 'tr:eq(1) th input', function() {
      const i = $(this).closest('th').index();
      const topTh = $head.find('tr:first th').eq(i)[0];
      const colIdx = api.column(topTh).index();
      const val = this.value;

      if (api.column(colIdx).search() !== val) {
        api.column(colIdx).search(val, false, true).draw();
      }
    });
  }

  wireColumnFilters();
  table.on('draw.dt column-visibility.dt responsive-resize.dt', wireColumnFilters);

  // Checkbox seleccionar todos
  $('#selectAll').on('click', function() {
    $('.row-select').prop('checked', this.checked);
  });

  // Acción masiva
  $('#accionMasiva').on('click', function() {
    const seleccionados = $('.row-select:checked').map(function() {
      return $(this).data('id');
    }).get();

    if (seleccionados.length === 0) {
      Swal.fire({
        icon: 'warning',
        title: '<?php echo lang('mod_com_mass_no_selection_title'); ?>',
        text: '<?php echo lang('mod_com_mass_no_selection_text'); ?>',
        confirmButtonText: 'OK'
      });
      return;
    }

    Swal.fire({
      title: '<?php echo lang('mod_com_mass_confirm_title'); ?>',
      text: '<?php echo lang('mod_com_mass_confirm_text'); ?>',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: '<?php echo lang('mod_com_mass_confirm_btn'); ?>',
      cancelButtonText: '<?php echo lang('mod_com_mass_cancel_btn'); ?>'
    }).then(result => {
      if (result.isConfirmed) {
        const form = $('<form>', {
          method: 'POST',
          action: '<?php echo base_url("empleados/showComunicacion"); ?>'
        });

        seleccionados.forEach(id => {
          form.append($('<input>', {
            type: 'hidden',
            name: 'ids[]',
            value: id
          }));
        });

        $('body').append(form);
        form.submit();
      }
    });
  });

  // Guardar configuración (por NOMBRE) y aplicar visibilidad al vuelo
  const saveUrl = "<?php echo site_url('configuracion/save'); ?>";
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2200,
    timerProgressBar: true
  });

  $('#applyColumnSettings').on('click', function() {
    const $form = $('#columnSettingsForm');
    const tableKey = $form.data('table') || 'mensajeria';

    const visibleNames = [];
    $('#columnSettingsForm .column-toggle').each(function() {
      const name = this.value;
      const vis = this.checked;
      const i = DINAMICAS.indexOf(name);

      if (i >= 0) {
        const colIdx = BASE1 + i;
        table.column(colIdx).visible(vis);
      }
      if (vis) visibleNames.push(name);
    });

    table.columns().adjust().draw(false);
    wireColumnFilters();

    const payload = {
      table_key: tableKey,
      settings: {
        visible_names: visibleNames
      }
    };

    const $csrf = $('#csrfToken');
    const csrfKey = $csrf.attr('name');
    const csrfVal = $csrf.val();

    Swal.fire({
      title: 'Guardando…',
      allowOutsideClick: false,
      didOpen: () => Swal.showLoading()
    });

    $.ajax({
      url: saveUrl,
      type: 'POST',
      dataType: 'json',
      data: {
        payload: JSON.stringify(payload),
        [csrfKey]: csrfVal
      },
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      },
      success(res) {
        Swal.close();
        if (res && res.ok) {
          if (res.csrf) $csrf.val(res.csrf);
          Toast.fire({
            icon: 'success',
            title: res.msg || 'Preferencias guardadas'
          });
        } else {
          Swal.fire({
            icon: 'warning',
            title: 'No se pudo guardar',
            text: (res && res.error) || 'Inténtalo de nuevo.'
          });
        }
      },
      error(xhr) {
        Swal.close();
        Swal.fire({
          icon: 'error',
          title: 'Error del servidor',
          text: xhr.responseText || xhr.statusText || 'Error desconocido'
        });
      }
    });
  });

  // Eliminar permisos
  $(document).on('click', '.eliminar-permiso', function(e) {
    e.preventDefault();
    const id_usuario = $(this).data('id_usuario');
    const id_cliente = $(this).data('id_cliente');

    Swal.fire({
      title: '<?php echo lang('mod_perm_delete_title'); ?>',
      text: '<?php echo lang('mod_perm_delete_text'); ?>',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: '<?php echo lang('mod_perm_delete_confirm'); ?>',
      cancelButtonText: '<?php echo lang('mod_perm_delete_cancel'); ?>',
    }).then((result) => {
      if (result.isConfirmed) {
        $.post('<?php echo site_url("Cat_UsuarioInternos/eliminarPermiso"); ?>', {
            id_usuario,
            id_cliente
          })
          .done(response => {
            const data = JSON.parse(response);
            const isOk = (data.status === 'success');

            Swal.fire(
              isOk ? '<?php echo lang('mod_perm_deleted_title'); ?>' :
              '<?php echo lang('mod_perm_error_title'); ?>',
              data.message || (isOk ?
                '<?php echo lang('mod_perm_deleted_text'); ?>' :
                '<?php echo lang('mod_perm_error_delete'); ?>'),
              isOk ? 'success' : 'error'
            );

            if (isOk) {
              location.reload();
            }
          })
          .fail(() => {
            Swal.fire(
              '<?php echo lang('mod_perm_error_title'); ?>',
              '<?php echo lang('mod_perm_error_delete'); ?>',
              'error'
            );
          });
      }
    });
  });

  // Foco inicial (opcional)
  $('#focus-catcher').focus();
});
</script>



<style>
.modulo-titulo {
  font-size: 28px;
  font-weight: bold;
  color: #bb67bb;
  margin-bottom: 10px;
}

*======HEADER DE LA TABLA (original + clonado por scrollX)======*/ #processTable.dataTable thead>tr>th,
#processTable.dataTable thead>tr>td,
div.dataTables_scrollHead table.dataTable thead>tr>th,
div.dataTables_scrollHead table.dataTable thead>tr>td {
  background: linear-gradient(to right, #e225e2, rgba(187, 103, 187, .6)) !important;
  color: #fff !important;
  text-align: center !important;
}

/* Quitar el background-image de los TH con sorting para que se vea tu degradado */
#processTable.dataTable thead>tr>th.sorting,
#processTable.dataTable thead>tr>th.sorting_asc,
#processTable.dataTable thead>tr>th.sorting_desc,
#processTable.dataTable thead>tr>th.sorting_asc_disabled,
#processTable.dataTable thead>tr>th.sorting_desc_disabled,
div.dataTables_scrollHead table.dataTable thead>tr>th.sorting,
div.dataTables_scrollHead table.dataTable thead>tr>th.sorting_asc,
div.dataTables_scrollHead table.dataTable thead>tr>th.sorting_desc,
div.dataTables_scrollHead table.dataTable thead>tr>th.sorting_asc_disabled,
div.dataTables_scrollHead table.dataTable thead>tr>th.sorting_desc_disabled {
  background-image: none !important;
}

/* Primera fila del thead (títulos) */
#processTable thead tr:first-child th,
div.dataTables_scrollHead thead tr:first-child th {
  text-transform: uppercase;
  text-align: center;
  background: right, #e225e2 !important;
  color: white;
  font
}

/* Inputs de búsqueda (2ª fila) */
#processTable thead input.form-control {
  height: 28px;
  padding: 2px 6px;
}

/* ====== CUERPO ====== */
#processTable.dataTable tbody td,
#processTable.dataTable tbody th {
  vertical-align: top !important;
  text-align: left !important;
  padding: 10px 12px !important;
}

#processTable.dataTable tbody tr:hover>* {
  background-color: #f1f5ff !important;
}

.btn-ver-empleados {
  background: linear-gradient(to right, #bb67bb, #a057a0);
  color: white;
  padding: 8px 14px;
  border-radius: 6px;
  font-weight: bold;
  border: none;
  text-decoration: none;
  transition: background 0.3s ease;
}

.form-check-label {
  text-transform: uppercase;
}

.btn-ver-empleados:hover {
  background: linear-gradient(45deg, #0b5ed7, #0bb3d9);
}

#processTable thead tr:first-child th {
  text-transform: uppercase;
  text-align: center;
}

.botones-accion {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  margin-bottom: 1rem;
}

.btn {
  font-size: 1.5rem;
  font-weight: 500;
  padding: 0.55rem 1.25rem;
  border-radius: 8px;
  margin: 10px;
  transition: box-shadow .2s, background .2s;
  box-shadow: 0 2px 8px #0001;
}

.btn-secondary {
  background: #1b659dff;
  color: #fff;

}

.btn-config {
  background: #6b27d9ff;
  color: #fff;

}

.btn-success {
  background: linear-gradient(to right, #ae67bbff, #8f57a0ff);
  color: #fff;
  border: none;
}

.btn:hover {
  box-shadow: 0 4px 16px #0002;
  opacity: .93;
}

/* MODAL ULTRA SUTIL Y PROFESIONAL EN TONOS LILA/ROSA */
/* Estiliza el modal con degradado y más profundidad */
.modal-content {
  background: linear-gradient(120deg, #e7c3ee 60%, #fff 100%);
  border: 2px solid #bb67bb;
  border-radius: 18px;
  box-shadow: 0 8px 40px #bb67bb55;
  padding: 0;
}

.modal-header {
  background: linear-gradient(90deg, #bb67bb 70%, #a057a0 100%);
  color: #fff !important;
  border-bottom: 2px solid #a057a0;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
  padding-top: 1.2rem;
  padding-bottom: 1.2rem;
}

.modal-title {
  font-size: 1.6rem !important;
  font-weight: bold;
  color: #fff !important;
}

.modal-body {
  background: #ffffffff;
  padding: 30px 25px 15px 25px;
}

.form-check-input[type="checkbox"] {
  width: 1.3em;
  height: 1.3em;
  accent-color: #bb67bb;
  border: 2px solid #bb67bb;
}

.form-check-label {
  font-size: 1.2rem;
  font-weight: 500;
  margin-left: 10px;
  color: #7b4280;
}

.modal-footer {
  background: #f3f3f3ff;
  border-top: 1.5px solid #bb67bb;
  border-bottom-left-radius: 15px;
  border-bottom-right-radius: 15px;
}

.modal-footer .btn {
  font-size: 1.18rem;
  padding: 0.55rem 2rem;
  border-radius: 8px;
  margin: 0 10px 5px 0;
  transition: background 0.2s, color 0.2s;
  border: none;
}

.modal-footer .btn-primary {
  background: linear-gradient(90deg, #5e32fcff 80%, #5b57a0ff 100%);
  color: #fff;
}

.modal-footer .btn-primary:hover {
  background: linear-gradient(60deg, #15084eff, #6b67bbff);
  color: #fff;
}

.modal-footer .btn-secondary {
  background: #f80000ff;
  color: #fafafaff;
}

.modal-footer .btn-secondary:hover {
  background: #f14d0dff;
  color: #fcfbfcff;
}

/* Mejora la separación visual */
.form-check {
  margin-bottom: 10px;
}

.usuarios-acceso-list {
  list-style: none;
  margin: 0;
  padding-left: 0;
}

/* Tarjetita por usuario */
.usuario-acceso-item {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 8px;
  background: #fbdff2ff;
  /* verde muy clarito */
  border-radius: 6px;
  padding: 6px 10px;
  margin-bottom: 6px;
  border: 1px solid rgba(214, 127, 227, 0.35);
}

.usuario-info {
  display: flex;
  flex-direction: column;
}

.usuario-nombre {
  font-weight: 600;
  font-size: 0.9rem;
  color: #333;
}

.usuario-detalle {
  font-size: 0.78rem;
  color: #666;
}

/* Botón de eliminar a la derecha */
.btn-usuario-remove {
  background: transparent;
  border: none;
  color: #e74c3c;
  cursor: pointer;
  padding: 0;
  line-height: 1;
}

.btn-usuario-remove i {
  font-size: 1rem;
}

.btn-usuario-remove:hover i {
  transform: scale(1.1);
}
</style>