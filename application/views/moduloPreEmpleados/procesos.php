<div class="container-fluid">
  <h2>Sucursales/Clientes</h2>
  <div>
    <p>En este módulo verás un listado de tus sucursales/clientes, areas o departamentos. Al seleccionar uno, podrás consultar los candidatos
      que se encuentran en exámenes y estudios previos a ser contratados, facilitando el seguimiento del proceso de
      selección antes de la contratación.</p>
  </div>
  <table id="processTable" class="display" style="width: 100%;">
    <thead>
      <tr>
      <th style="text-align: center">Sucursal/Cliente </th>
        <th style="text-align: center">Correo Electrónico</th>
        <th style="text-align: center">Usuarios con acceso a sucursal/cliente</th>
        <th style="text-align: center">Candidatos en proceso</th>
        <th style="text-align: center">Acciones</th>
      </tr>

    </thead>
    <tbody>
      <?php if (isset($permisos) && !empty($permisos)): ?>
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
             
             if($idRol == 6 || $idRol == 1){ ?>
            <a href="#" class="eliminar-permiso" data-id_usuario="<?php echo $usuario['id_usuario']; ?>"
              data-id_cliente="<?php echo $p['id_cliente']; ?>"  title="Eliminar acceso a esta sucursal/cliente">
              <i class="fa fa-trash" style="color: red; float: right"></i> 
            </a>
            <?php } ?>
          </li>
          <?php endforeach; ?>
        </td>
        <td>Candidatos: <?php echo isset($p['pre_empleados']) ? htmlspecialchars($p['pre_empleados'], ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
        <td>
          <a href="<?php echo site_url(htmlspecialchars($p['url'], ENT_QUOTES, 'UTF-8')); ?>" class="btn-ver-empleados">Ver procesos</a>
        </td>
      </tr>
      <?php endif; ?>
      <?php endforeach; ?>
      <?php else: ?>
      <tr>
      <td colspan="6">Aún no hay Sucursales registrados.</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<style>
.modulo-titulo {
  font-size: 28px;
  font-weight: bold;
  color: #9fda64; /* Verde claro */
  margin-bottom: 10px;
}

#processTable thead {
  background: linear-gradient(to right, #9fda64, #7eb94f) !important; /* Degradado verde */
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
  background-color: #f3fbec; /* Verde muy claro para hover */
}

.btn-ver-empleados,
.pre-employment-btn {
  background: linear-gradient(to right, #9fda64, #7eb94f); /* Botón con degradado verde */
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
.pre-employment-btn:hover {
  background: linear-gradient(45deg, #8ecf55, #6ca93c); /* Hover más intenso */
}

</style>

<script>
$(document).ready(function () {
  $('#processTable').DataTable({
    order: [],                    // 👈 respeta el orden del DOM (tu foreach)
  });

  $('#sidebarToggle').on('click', function () {
    $('#sidebar').toggleClass('hidden');
  });
});
</script>