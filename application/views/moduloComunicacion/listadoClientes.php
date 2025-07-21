<div class="container-fluid">
  <h2 class="modulo-titulo">Módulo de Comunicacion</h2>
  <p>En este módulo podrás consultar un listado de tus sucursales, áreas o departamentos, según la estructura definida por tu organización. Al seleccionar una entidad, accederás al módulo de comunicación correspondiente, donde podrás gestionar y compartir información clave con los colaboradores asociados.</p>
<button class="btn btn-secondary mb-3" id="btnConfigurarColumnas">
  Configurar columnas
</button>
  <table id="processTable" class="table table-striped table-hover display" style="width:100%;">
    <thead>
      <tr>
        <th>Sucursal</th>
        <th>Correo Electrónico</th>
        <th>Usuarios con acceso</th>
        <th>Empleados</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($permisos) && ! empty($permisos)): ?>
<?php foreach ($permisos as $p): ?>
<?php if (isset($p['nombreCliente']) && isset($p['url'])): ?>
      <tr>
        <td><?php echo htmlspecialchars($p['nombreCliente'], ENT_QUOTES, 'UTF-8')?></td>
        <td><?php echo isset($p['correo']) ? htmlspecialchars($p['correo'], ENT_QUOTES, 'UTF-8') : 'N/A'?></td>
        <td>
          <ul style="padding-left: 16px;">
            <?php foreach ($p['usuarios'] as $usuario): ?>
            <li>
              <?php echo htmlspecialchars($usuario['nombre_completo'], ENT_QUOTES, 'UTF-8')?>
              (<?php echo htmlspecialchars($usuario['rol'], ENT_QUOTES, 'UTF-8')?>)
              (<?php echo htmlspecialchars($usuario['id_usuario'], ENT_QUOTES, 'UTF-8')?>)
              <?php
                  $idRol = $this->session->userdata('idrol');
              if ($idRol == 6 || $idRol == 1): ?>
              <a href="#" class="eliminar-permiso" data-id_usuario="<?php echo $usuario['id_usuario']?>" data-id_cliente="<?php echo $p['id_cliente']?>" title="Eliminar acceso a esta sucursal">
                <i class="fa fa-trash-alt" style="color: red;"></i>
              </a>
              <?php endif; ?>
            </li>
            <?php endforeach; ?>
          </ul>
        </td>
        <td>
          <ul style="padding-left: 16px;">
            <li><strong>Máximo:</strong> <?php echo $p['max']?></li>
            <li><strong>Activos:</strong> <?php echo $p['empleados_activos']?></li>
            <li><strong>Inactivos:</strong> <?php echo $p['empleados_inactivos']?></li>
          </ul>
        </td>
        <td>
          <a href="<?php echo site_url('comunicacion/' . $p['id_cliente'])?>" class="btn-ver-empleados">Entrar</a>
        </td>
      </tr>
      <?php endif; ?>
<?php endforeach; ?>
<?php else: ?>
      <tr>
        <td colspan="5">No hay clientes registrados.</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<div class="modal fade" id="modalColumnas" tabindex="-1" role="dialog" aria-labelledby="modalColumnasLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalColumnasLabel">Selecciona las columnas a mostrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formColumnas">
          <!-- Checboxes dinámicos -->
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="Sucursal" id="colSucursal" checked>
            <label class="form-check-label" for="colSucursal">Sucursal</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="Correo Electrónico" id="colCorreo" checked>
            <label class="form-check-label" for="colCorreo">Correo Electrónico</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="Usuarios con acceso" id="colUsuarios" checked>
            <label class="form-check-label" for="colUsuarios">Usuarios con acceso</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="Empleados" id="colEmpleados" checked>
            <label class="form-check-label" for="colEmpleados">Empleados</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="Acciones" id="colAcciones" checked>
            <label class="form-check-label" for="colAcciones">Acciones</label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarColumnas">Guardar</button>
      </div>
    </div>
  </div>
</div>

<style>
.modulo-titulo {
  font-size: 28px;
  font-weight: bold;
  color: #bb67bb;
  margin-bottom: 10px;
}

#processTable thead {
background: linear-gradient(to right, rgb(226, 37, 226), rgba(187, 103, 187, 0.6));
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
  border: none;
  padding: 8px 14px;
  border-radius: 6px;
  font-weight: bold;
  text-decoration: none;
  display: inline-block;
  transition: background 0.3s ease;
}

.btn-ver-empleados:hover {
  background: linear-gradient(45deg, #0b5ed7, #0bb3d9);
}
</style>


<script>
$(document).ready(function() {
  $('#processTable').DataTable({
    order: [
      [3, 'desc'],
      responsive: true
    ] // Índice 3 = cuarta columna, "Empleados"
  });
  $('#sidebarToggle').on('click', function() {
    $('#sidebar').toggleClass('hidden'); // Alternar la clase 'hidden'
  });
});
$('#btnConfigurarColumnas').on('click', function() {
  $('#modalColumnas').modal('show');
});

$('#guardarColumnas').on('click', function () {
  const columnasSeleccionadas = [];

  $('#formColumnas input[type="checkbox"]').each(function () {
    if ($(this).is(':checked')) {
      columnasSeleccionadas.push($(this).val());
    }
  });

  // Enviar al servidor
  $.ajax({
    url: '<?= site_url("tuControlador/guardarConfiguracionColumnas") ?>',
    method: 'POST',
    data: {
      columnas: columnasSeleccionadas,
      id_usuario: <?= $this->session->userdata('idusuario') ?>
    },
    success: function(response) {
      Swal.fire('Listo', 'Configuración guardada', 'success').then(() => {
        location.reload(); // Recargar para aplicar
      });
    },
    error: function() {
      Swal.fire('Error', 'No se pudo guardar la configuración', 'error');
    }
  });
});

$(document).on('click', '.eliminar-permiso', function(e) {
  e.preventDefault();

  var id_usuario = $(this).data('id_usuario');
  var id_cliente = $(this).data('id_cliente');

  // Mostrar confirmación usando SweetAlert
  Swal.fire({
    title: '¿Estás seguro?',
    text: 'Al eliminar este permiso, el usuario perderá visibilidad a esta sucursal.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      // Enviar solicitud de eliminación al servidor
      $.ajax({
        url: '<?php echo site_url("Cat_usuarioInternos/eliminarPermiso"); ?>',
        method: 'POST',
        data: {
          id_usuario: id_usuario,
          id_cliente: id_cliente
        },
        success: function(response) {
          var data = JSON.parse(response);
          if (data.status === 'success') {
            Swal.fire(
              'Eliminado',
              'El permiso ha sido eliminado exitosamente.',
              'success'
            );
            location.reload(); // Recargar la página para actualizar los datos
          } else {
            Swal.fire(
              'Error',
              data.message,
              'error'
            );
          }
        },
        error: function() {
          Swal.fire(
            'Error',
            'Ocurrió un error al intentar eliminar el permiso.',
            'error'
          );
        }
      });
    }
  });
});
</script>