<div class="container-fluid">
  <h2>Sucursales</h2>
  <div>
    <p>En este módulo verás un listado de tus clientes o sucursales. Al seleccionar uno, podrás consultar los candidatos
      que se encuentran en exámenes y estudios previos a ser contratados, facilitando el seguimiento del proceso de
      selección antes de la contratación.</p>
  </div>
  <table id="processTable" class="display" style="width: 100%;">
    <thead>
      <tr>
        <th>Nombre del Cliente</th>
        <th>Correo Electrónico</th>
        <th>Teléfono</th>
        <th>Fecha de Creación</th>
        <th>Acciones</th>
      </tr>

    </thead>
    <tbody>
      <?php if (isset($permisos) && !empty($permisos)): ?>
      <?php foreach ($permisos as $p): ?>
      <?php if (isset($p->nombreCliente) && isset($p->url)): ?>
      <tr>
        <td><?php echo htmlspecialchars($p->nombreCliente, ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo isset($p->correo) ? htmlspecialchars($p->correo, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
        <td><?php echo isset($p->telefono) ? htmlspecialchars($p->telefono, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
        <td><?php echo isset($p->creacion) ? htmlspecialchars($p->creacion, ENT_QUOTES, 'UTF-8') : 'N/A'; ?></td>
        <td>
          <a href="<?php echo site_url(htmlspecialchars($p->url, ENT_QUOTES, 'UTF-8')); ?>" class="btn btn-primary">Ver procesos</a>
        </td>
      </tr>
      <?php endif; ?>
      <?php endforeach; ?>
      <?php else: ?>
      <tr>
      <td colspan="6">Aún no hay clientes registrados.</td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<style>
.container-fluid {
  width: 100%;
  /* Full width */
  padding: 20px;
  /* Internal padding */
  box-sizing: border-box;
  /* Include padding in width */
}

#processTable {
  width: 100%;
  /* Make the table full width */
  border-collapse: collapse;
  /* Ensure borders collapse */
}

#processTable th,
#processTable td {
  border: 1px solid #ddd;
  /* Add borders to table cells */
  padding: 8px;
  /* Add padding inside cells */
  text-align: left;
  /* Align text to the left */
}

#processTable th {
  background-color: #f2f2f2;
  /* Header background color */
  font-weight: bold;
  /* Bold header text */
}
</style>

<script>
$(document).ready(function() {
  $('#processTable').DataTable();
  $('#sidebarToggle').on('click', function() {
    $('#sidebar').toggleClass('hidden'); // Alternar la clase 'hidden'
  });
});
</script>