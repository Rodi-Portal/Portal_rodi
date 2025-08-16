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

  <h2 class="modulo-titulo">Módulo de Comunicacion</h2>
  <p>En este módulo podrás consultar un listado de tus sucursales, áreas o departamentos, según la estructura definida
    por tu organización. Al seleccionar una entidad, accederás al módulo de comunicación correspondiente, donde podrás
    gestionar y compartir información clave con los colaboradores asociados.</p>
  <div class="d-flex justify-content-end mb-3 gap-2">
    <button class="btn btn-config" data-toggle="modal" data-target="#columnModal">
      <i class="fas fa-cogs mr-1"></i> Mostrar/Ocultar Columnas
    </button>
    <button class="btn btn-success" id="accionMasiva">
      <i class="fas fa-tasks mr-1"></i>Entrar Sucursales seleccionadas
    </button>
  </div>

  <table id="processTable" class="table table-striped table-hover display nowrap" style="width:100%;">
    <thead>
      <tr>
        <th><input type="checkbox" id="selectAll"></th>
        <th>Sucursal</th>
        <?php foreach ($columnas_visibles as $col): ?>
        <th><?php echo htmlspecialchars($col, ENT_QUOTES, 'UTF-8'); ?></th>
        <?php endforeach; ?>
        <th>Usuarios con acceso</th>
        <th>Empleados</th>
        <th>Acciones</th>
      </tr>
      <tr>
        <th></th>
        <th>
          <input type="text" class="form-control form-control-sm" placeholder="Buscar Sucursal" autocomplete="off"
            name="search_sucursal_<?php echo uniqid(); ?>" readonly onfocus="this.removeAttribute('readonly');">
        </th>
        <?php foreach ($columnas_visibles as $col): ?>
        <th>
          <input type="text" class="form-control form-control-sm"
            placeholder="Buscar                                                                                                                                                                                                                                                                                                                                                <?php echo htmlspecialchars($col); ?>"
            autocomplete="off" name="search_<?php echo uniqid(); ?>" readonly
            onfocus="this.removeAttribute('readonly');">
        </th>
        <?php endforeach; ?>
        <th>
          <input type="text" class="form-control form-control-sm" placeholder="Buscar Usuarios" autocomplete="off"
            name="search_usuarios_<?php echo uniqid(); ?>" readonly onfocus="this.removeAttribute('readonly');">
        </th>
        <th>
          <input type="text" class="form-control form-control-sm" placeholder="Buscar Empleados" autocomplete="off"
            name="search_empleados_<?php echo uniqid(); ?>" readonly onfocus="this.removeAttribute('readonly');">
        </th>
        <th></th>
      </tr>


    </thead>

    <tbody>
      <?php if (! empty($permisos)): ?>
      <?php foreach ($permisos as $p): ?>
      <tr>
        <td><input type="checkbox" class="row-select" data-id="<?php echo $p['id_cliente'] ?>"></td>
        <td><?php echo htmlspecialchars($p['nombreCliente']) ?></td>

        <?php foreach ($columnas_disponibles as $col): ?>
        <?php if (! in_array($col, $columnas_fijas) && ! in_array($col, $columnas_ocultas)): ?>
        <td>
          <?php
              if (isset($p[$col])) {
                  if (is_array($p[$col])) {
                      echo htmlspecialchars(json_encode($p[$col]));
                  } else {
                      echo htmlspecialchars($p[$col]);
                  }
              } else {
                  echo 'N/A';
              }
          ?>
        </td>
        <?php endif; ?>
        <?php endforeach; ?>

        <td>
          <ul style="padding-left: 16px;">
            <?php foreach ($p['usuarios'] as $usuario): ?>
            <li>
              <?php echo htmlspecialchars($usuario['nombre_completo']) ?>
              (<?php echo htmlspecialchars($usuario['rol']) ?>)
              (<?php echo htmlspecialchars($usuario['id_usuario']) ?>)
              <?php if (in_array($this->session->userdata('idrol'), [1, 6])): ?>
              <a href="#" class="eliminar-permiso ms-2" data-id_usuario="<?php echo $usuario['id_usuario'] ?>"
                data-id_cliente="<?php echo $p['id_cliente'] ?>" title="Eliminar acceso a esta sucursal">
                <i class="fa fa-trash-alt" style="color: red;"></i>
              </a>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </td>

        <td>
          <ul class="pl-3 mb-0">
            <li><strong>Máximo:</strong> <?php echo htmlspecialchars($p['max']) ?></li>
            <li><strong>Empleados:</strong> <?php echo htmlspecialchars($p['empleados_activos']) ?></li>
            <li><strong>Exempleados:</strong> <?php echo htmlspecialchars($p['empleados_inactivos']) ?></li>
          </ul>
        </td>
        <td>
          <a href="<?php echo site_url('comunicacion/' . $p['id_cliente']) ?>" class="btn-ver-empleados">Entrar</a>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php else: ?>
      <tr>
        <td
          colspan="<?php echo 3 + count($columnas_disponibles) - count($columnas_fijas) - count($columnas_ocultas); ?>">
          No hay datos disponibles.
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
      <form id="columnSettingsForm" data-table="<?php echo $TABLE_KEY?>">
        <input type="hidden" id="csrfToken" name="<?php echo $this->security->get_csrf_token_name();?>"
          value="<?php echo $this->security->get_csrf_hash();?>">

        <div class="modal-header">
          <h5 class="modal-title" id="columnModalLabel">Seleccionar columnas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span>&times;</span></button>
        </div>

        <div class="modal-body">
          <?php if (! empty($columnas_dinamicas)): ?>
          <?php foreach ($columnas_dinamicas as $name): ?>
          <div class="form-check">
            <input class="form-check-input column-toggle" type="checkbox" value="<?php echo htmlspecialchars($name)?>"
              id="col_<?php echo htmlspecialchars($name)?>"
              <?php echo in_array($name, $columnas_usuario, true) ? 'checked' : ''?>>
            <label class="form-check-label" for="col_<?php echo htmlspecialchars($name)?>">
              <?php echo htmlspecialchars($name)?>
            </label>
          </div>
          <?php endforeach; ?>
          <?php else: ?>
          <p>No hay columnas disponibles.</p>
          <?php endif; ?>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="applyColumnSettings" data-dismiss="modal">Aplicar</button>
        </div>
      </form>
    </div>
  </div>
</div>




<script>
  // Listas generadas por PHP
  const DINAMICAS     = <?= $DINAMICAS_JS ?>;   // p.ej. ["telefono","estado","pais","ciudad"]
  const SELECCIONADAS = <?= $SEL_JS ?>;         // p.ej. ["telefono","estado"]
  const BASE = 2; // 0=checkbox, 1=Sucursal; dinámicas empiezan en la 2

  $(document).ready(function () {
    // Evita doble inicialización
    const table = $.fn.DataTable.isDataTable('#processTable')
      ? $('#processTable').DataTable()
      : $('#processTable').DataTable({
          scrollX: true,
          responsive: true,
          order: [],
          // columnDefs: [{ orderable: false, targets: [0, -1] }], // opcional
        });

    // Mostrar SOLO fijas + seleccionadas
    const selected = new Set(SELECCIONADAS);
    DINAMICAS.forEach((name, i) => {
      const colIdx = BASE + i;               // índice físico en la tabla
      const visible = selected.has(name);    // únicamente seleccionadas
      table.column(colIdx).visible(visible);
    });

    // Sincroniza checks del modal (value = nombre)
    $('#columnSettingsForm .column-toggle').each(function () {
      this.checked = selected.has(this.value);
    });

    // Filtros por columna (segunda fila de thead)
    $('#processTable thead tr:eq(1) th').each(function () {
      const $input = $('input', this);
      if ($input.length) {
        $input
          .on('keyup change', function () {
            const colIndex = $(this).closest('th').index();
            table.column(colIndex).search(this.value).draw();
          })
          .attr({
            autocomplete: 'no-autofill',
            autocorrect: 'off',
            autocapitalize: 'off',
            spellcheck: 'false'
          });
      }
    });

    // Checkbox seleccionar todos
    $('#selectAll').on('click', function () {
      $('.row-select').prop('checked', this.checked);
    });

    // Acción masiva
    $('#accionMasiva').on('click', function () {
      const seleccionados = $('.row-select:checked').map(function () {
        return $(this).data('id');
      }).get();

      if (seleccionados.length === 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Sin selección',
          text: 'Selecciona al menos una sucursal',
          confirmButtonText: 'OK'
        });
        return;
      }

      Swal.fire({
        title: '¿Acción sobre sucursales seleccionadas?',
        text: 'Dispondrás de la información y funciones de todas las sucursales que seleccionaste.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar'
      }).then(result => {
        if (result.isConfirmed) {
          const form = $('<form>', {
            method: 'POST',
            action: '<?= base_url("empleados/showComunicacion") ?>'
          });
          seleccionados.forEach(id => {
            form.append($('<input>', { type: 'hidden', name: 'ids[]', value: id }));
          });
          $('body').append(form);
          form.submit();
        }
      });
    });

    // Guardar configuración (por NOMBRE) y aplicar visibilidad al vuelo
    const saveUrl = "<?= site_url('configuracion/save'); ?>";
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2200,
      timerProgressBar: true
    });

    $('#applyColumnSettings').on('click', function () {
      const $form = $('#columnSettingsForm');
      const tableKey = $form.data('table') || 'mensajeria';

      const visibleNames = [];
      $('#columnSettingsForm .column-toggle').each(function () {
        const name = this.value;        // NOMBRE (no índice)
        const vis  = this.checked;
        const i    = DINAMICAS.indexOf(name);
        if (i >= 0) {
          const colIdx = BASE + i;
          table.column(colIdx).visible(vis);
        }
        if (vis) visibleNames.push(name);
      });

      const payload = {
        table_key: tableKey,
        settings: { visible_names: visibleNames }
      };

      const $csrf   = $('#csrfToken');
      const csrfKey = $csrf.attr('name');
      const csrfVal = $csrf.val();

      Swal.fire({ title: 'Guardando…', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

      $.ajax({
        url: saveUrl,
        type: 'POST',
        dataType: 'json',
        data: { payload: JSON.stringify(payload), [csrfKey]: csrfVal },
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success(res) {
          Swal.close();
          if (res?.ok) {
            if (res.csrf) $csrf.val(res.csrf);
            Toast.fire({ icon: 'success', title: res.msg || 'Preferencias guardadas' });
          } else {
            Swal.fire({ icon: 'warning', title: 'No se pudo guardar', text: res?.error || 'Inténtalo de nuevo.' });
          }
        },
        error(xhr) {
          Swal.close();
          Swal.fire({ icon: 'error', title: 'Error del servidor', text: xhr.responseText || xhr.statusText || 'Error desconocido' });
        }
      });
    });

    // Eliminar permisos
    $(document).on('click', '.eliminar-permiso', function (e) {
      e.preventDefault();
      const id_usuario = $(this).data('id_usuario');
      const id_cliente = $(this).data('id_cliente');

      Swal.fire({
        title: '¿Estás seguro?',
        text: 'El usuario perderá el acceso a esta sucursal.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
          $.post('<?= site_url("Cat_UsuarioInternos/eliminarPermiso"); ?>', { id_usuario, id_cliente })
            .done(response => {
              const data = JSON.parse(response);
              Swal.fire(data.status === 'success' ? 'Eliminado' : 'Error', data.message, data.status);
              if (data.status === 'success') location.reload();
            })
            .fail(() => Swal.fire('Error', 'No se pudo eliminar el permiso.', 'error'));
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

* ====== HEADER DE LA TABLA (original + clonado por scrollX) ====== */
#processTable.dataTable thead > tr > th,
#processTable.dataTable thead > tr > td,
div.dataTables_scrollHead table.dataTable thead > tr > th,
div.dataTables_scrollHead table.dataTable thead > tr > td{
  background:linear-gradient(to right,#e225e2,rgba(187,103,187,.6)) !important;
  color:#fff !important;
  text-align:center !important;
}

/* Quitar el background-image de los TH con sorting para que se vea tu degradado */
#processTable.dataTable thead > tr > th.sorting,
#processTable.dataTable thead > tr > th.sorting_asc,
#processTable.dataTable thead > tr > th.sorting_desc,
#processTable.dataTable thead > tr > th.sorting_asc_disabled,
#processTable.dataTable thead > tr > th.sorting_desc_disabled,
div.dataTables_scrollHead table.dataTable thead > tr > th.sorting,
div.dataTables_scrollHead table.dataTable thead > tr > th.sorting_asc,
div.dataTables_scrollHead table.dataTable thead > tr > th.sorting_desc,
div.dataTables_scrollHead table.dataTable thead > tr > th.sorting_asc_disabled,
div.dataTables_scrollHead table.dataTable thead > tr > th.sorting_desc_disabled{
  background-image:none !important;
}

/* Primera fila del thead (títulos) */
#processTable thead tr:first-child th,
div.dataTables_scrollHead thead tr:first-child th{
  text-transform:uppercase; text-align:center;
    background:right,#e225e2 !important;
    color: white;
    font

}

/* Inputs de búsqueda (2ª fila) */
#processTable thead input.form-control{
  height:28px; padding:2px 6px;
}

/* ====== CUERPO ====== */
#processTable.dataTable tbody td,
#processTable.dataTable tbody th{
  vertical-align:top !important;
  text-align:left !important;
  padding:10px 12px !important;
}
#processTable.dataTable tbody tr:hover > *{
  background-color:#f1f5ff !important;
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
</style>