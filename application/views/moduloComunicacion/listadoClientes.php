<?php
  $columnas_visibles = array_filter($columnas_disponibles, function($col) use ($columnas_fijas, $columnas_ocultas) {
      return !in_array($col, $columnas_fijas) && !in_array($col, $columnas_ocultas);
  });
?>
<div class="container-fluid">
  <h2 class="modulo-titulo">Módulo de Comunicacion</h2>
  <p>En este módulo podrás consultar un listado de tus sucursales, áreas o departamentos, según la estructura definida
    por tu organización. Al seleccionar una entidad, accederás al módulo de comunicación correspondiente, donde podrás
    gestionar y compartir información clave con los colaboradores asociados.</p>
  <!--button class="btn btn-secondary mb-3" data-toggle="modal" data-target="#columnModal">
    Configurar columnas
  </button-->
  <button class="btn btn-success mb-3" id="accionMasiva">Acción masiva</button>

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
    <th><input type="text" class="form-control form-control-sm" placeholder="Buscar Sucursal"></th>
    <?php foreach ($columnas_visibles as $col): ?>
      <th><input type="text" class="form-control form-control-sm" placeholder="Buscar <?php echo htmlspecialchars($col); ?>"></th>
    <?php endforeach; ?>
    <th><input type="text" class="form-control form-control-sm" placeholder="Buscar Usuarios"></th>
    <th><input type="text" class="form-control form-control-sm" placeholder="Buscar Empleados"></th>
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
            <li><strong>Activos:</strong> <?php echo htmlspecialchars($p['empleados_activos']) ?></li>
            <li><strong>Inactivos:</strong> <?php echo htmlspecialchars($p['empleados_inactivos']) ?></li>
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
      <form id="columnSettingsForm">
        <div class="modal-header">
          <h5 class="modal-title" id="columnModalLabel">Seleccionar columnas</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php if (! empty($columnas_disponibles)): ?>
          <?php
    $columnIndex = 0;
    foreach ($columnas_disponibles as $col):
        // Mostrar solo columnas que NO están en fijas ni en ocultas
        if (in_array($col, $columnas_fijas) || in_array($col, $columnas_ocultas)) {
            $columnIndex++;
            continue;
        }
    ?>
          <div class="form-check">
            <input class="form-check-input column-toggle" type="checkbox" value="<?php echo $columnIndex ?>"
              id="col_<?php echo $columnIndex ?>" checked>
            <label class="form-check-label" for="col_<?php echo $columnIndex ?>">
              <?php echo htmlspecialchars($col) ?>
            </label>
          </div>
          <?php
                      $columnIndex++;
                  endforeach;
              ?>
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
$(document).ready(function() {
  const table = $('#processTable').DataTable({
    responsive: true,
    order: [
      [1, 'asc']
    ],
    columnDefs: [{
        orderable: false,
        targets: 'no-sort'
      } // Checkbox no ordenable
    ]
  });

  // Filtro por columna
  // Mapea solo las columnas visibles
  $('#processTable thead tr:eq(1) th').each(function(i) {
    const input = $('input', this);
    if (input.length) {
      input.on('keyup change', function() {
        const colIndex = $(this).closest('th').index();
        table.column(colIndex).search(this.value).draw();
      });
    }
  });


  // Checkbox seleccionar todos
  $('#selectAll').on('click', function() {
    $('.row-select').prop('checked', this.checked);
  });
  $('#accionMasiva').on('click', function() {
    const seleccionados = $('.row-select:checked').map(function() {
      return $(this).data('id');
    }).get();
    console.log("🚀 ~ seleccionados ~ seleccionados:", seleccionados)

    if (seleccionados.length === 0) {
      Swal.fire({
        icon: 'warning',
        title: 'Sin selección',
        text: 'Selecciona al menos una sucursal',
        confirmButtonText: 'OK'
      });
      return;
    }
    // Confirmar acción
    Swal.fire({
      title: '¿Continuar con la acción masiva?',
      text: 'Esta acción se aplicará a las sucursales seleccionadas.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sí',
      cancelButtonText: 'Cancelar'
    }).then(result => {
      if (result.isConfirmed) {
        // Enviar los IDs por POST usando un formulario oculto
        const form = $('<form>', {
          method: 'POST',
          action: '<?php echo base_url("empleados/showComunicacion") ?>'
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



  // Aplicar configuración de columnas
  $('#applyColumnSettings').on('click', function() {
    $('#columnSettingsForm .column-toggle').each(function() {
      const idx = parseInt($(this).val());
      table.column(idx).visible($(this).is(':checked'));
    });
  });

  // Eliminar permisos (SweetAlert)
  $(document).on('click', '.eliminar-permiso', function(e) {
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
        $.post('<?php echo site_url("Cat_usuarioInternos/eliminarPermiso"); ?>', {
            id_usuario,
            id_cliente
          })
          .done(response => {
            const data = JSON.parse(response);
            Swal.fire(data.status === 'success' ? 'Eliminado' : 'Error', data.message, data.status);
            if (data.status === 'success') location.reload();
          })
          .fail(() => Swal.fire('Error', 'No se pudo eliminar el permiso.', 'error'));
      }
    });
  });
});
</script>

<style>
.modulo-titulo {
  font-size: 28px;
  font-weight: bold;
  color: #bb67bb;
  margin-bottom: 10px;
}

#processTable thead {
  background: linear-gradient(to right, #e225e2, rgba(187, 103, 187, 0.6));
  color: white;
  text-align: center;
}

#processTable th,
#processTable td {
  vertical-align: top;
  text-align: left;
  padding: 10px;
}

#processTable tbody tr:hover {
  background-color: #f1f5ff;
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

.btn-ver-empleados:hover {
  background: linear-gradient(45deg, #0b5ed7, #0bb3d9);
}

#processTable thead tr:first-child th {
  text-transform: uppercase;
  text-align: center;
}
</style>