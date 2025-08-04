<div class="container-fluid">
  <h2>Módulo de Exmpleados</h2>
  <p>En este módulo podrás consultar los empleados que ya no están activos. Se muestra un listado de tus areas,
    departamentos o sucursales, al seleccionar uno, podrás ver el listado de exempleados. Desde ahí podrás gestionar sus
    registros de manera clara, ágil y eficiente.</p>

  <table id="processTable" class="display" style="width: 100%;">
    <thead>
      <tr>
        <th style="text-align: center">Sucursal </th>
        <th style="text-align: center">Correo Electrónico</th>
        <th style="text-align: center">Usuarios con acceso a sucursal</th>
        <th style="text-align: center">Empleados</th>
        <th style="text-align: center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($permisos) && ! empty($permisos)): ?>
      <?php foreach ($permisos as $p): ?>
      <?php if (isset($p['nombreCliente']) && isset($p['url'])): ?>
      <tr>
        <td><?php echo htmlspecialchars($p['nombreCliente'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo isset($p['correo']) ? htmlspecialchars($p['correo'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
        <td><?php foreach ($p['usuarios'] as $usuario): ?>
          <li>
            <?php echo htmlspecialchars($usuario['nombre_completo'], ENT_QUOTES, 'UTF-8'); ?>
            (<?php echo htmlspecialchars($usuario['rol'], ENT_QUOTES, 'UTF-8'); ?>)
            (<?php echo htmlspecialchars($usuario['id_usuario'], ENT_QUOTES, 'UTF-8'); ?>)
            <!-- Icono de papelera para eliminar el permiso -->
            <?php
                $idRol = $this->session->userdata('idrol');

            if ($idRol == 6 || $idRol == 1) {?>
            <a href="#" class="eliminar-permiso" data-id_usuario="<?php echo $usuario['id_usuario']; ?>"
              data-id_cliente="<?php echo $p['id_cliente']; ?>" title="Eliminar acceso a esta sucursal">
              <i class="fa fa-trash" style="color: red; float: right"></i>
            </a>
            <?php }?>
          </li>
          <?php endforeach; ?>
        </td>

        <td>
          <li>Numero maximo: <?php echo $p['max']; ?></li>
          <li>Empleados :<?php echo $p['empleados_activos']; ?></li>
          <li> Exempleados : <?php echo $p['empleados_inactivos']; ?></li>
        </td>
        <td>
          <a href="<?php echo site_url('procesoFormer/' . $p['id_cliente']); ?>" class="btn-ver-empleados">Ver Ex
            empleados</a>
        </td>
      </tr>
      <?php endif; ?>
      <?php endforeach; ?>
      <?php else: ?>
      <tr>
        <td colspan="6">No clients registered yet.</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<style>
.modulo-titulo {
  font-size: 28px;
  font-weight: bold;
  color: #58c4f5;
  /* Cambiado a azul claro */
  margin-bottom: 10px;
}

#processTable thead {
  background: linear-gradient(to right, #58c4f5, #31a5d3) !important;
  /* Azul degradado */
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
  background-color: #e8f7fe;
  /* Azul muy claro para hover */
}

.btn-ver-empleados,
.former-employment-btn {
  background: linear-gradient(to right, #58c4f5, #31a5d3);
  /* Botón azul con degradado */
  color: white;
  border: none;
  padding: 8px 14px;
  border-radius: 6px;
  font-weight: bold;
  text-decoration: none;
  display: inline-block;
  transition: background 0.3s ease;
}

.btn-ver-empleados:hover,
.former-employment-btn:hover {
  background: linear-gradient(45deg, #2fa6cf, #007ca8);
  /* Efecto hover más intenso */
}
</style>

<script>
$(document).ready(function() {
  $('#processTable').DataTable();
  $('#sidebarToggle').on('click', function() {
    $('#sidebar').toggleClass('hidden'); // Alternar la clase 'hidden'
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
        url: '<?php echo site_url("Cat_UsuarioInternos/eliminarPermiso"); ?>',
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
