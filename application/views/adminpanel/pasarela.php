<style>
/* Estilos generales */
body {
  font-family: 'Arial', sans-serif;
  background-color: #f4f7fa;
  color: #333;
}

/* Contenedor principal */
.pasarela-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Título principal */
.pasarela-header {
  margin-bottom: 20px;
}

.pasarela-title {
  font-size: 36px;
  color: #2c3e50;
  font-weight: bold;
}

.pasarela-subtitle {
  font-size: 18px;
  color: #7f8c8d;
}

/* Pestañas */
.nav-tabs {
  border-bottom: 2px solid #2c3e50;
}

.nav-tabs .nav-link {
  border: 2px solid transparent;
  border-radius: 50px;
  padding: 12px 20px;
  background-color: #ecf0f1;
  color: #2c3e50;
}

.nav-tabs .nav-link.active {
  border-color: rgb(17, 111, 173);
  background-color: rgb(17, 111, 173);
  color: #fff;
}

/* Card (tarjeta) */
.pasarela-card {
  border-radius: 8px;
  border: 1px solid #ddd;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  background-color: #fff;
}

.pasarela-card-header {
  background-color: rgb(17, 111, 173);
  color: white;
  font-size: 20px;
  padding: 15px;
  border-radius: 8px 8px 0 0;
}

.pasarela-card-body {
  padding: 20px;
}

.pasarela-row {
  margin-bottom: 15px;
}

.pasarela-data {
  font-weight: bold;
  color: #2c3e50;
}

.pasarela-status {
  font-weight: bold;
  color: #e67e22;
}

.pasarela-alert {
  background-color: #f8d7da;
  color: #721c24;
  padding: 15px;
  border-radius: 5px;
  margin-top: 10px;
}

.text-end {
  text-align: right; /* Alinear el contenido del contenedor a la derecha */
}

.pasarela-btn {
  font-size: 20px; /* Tamaño de fuente del botón */
  padding: 10px 20px; /* Espaciado interior para hacerlo más grande */
  background-color: #2d87f0; /* Color de fondo del botón */
  color: white; /* Color del texto */
  border: none; /* Sin borde */
  border-radius: 5px; /* Bordes redondeados */
  cursor: pointer; /* Cambiar el cursor al pasar sobre el botón */
  transition: background-color 0.3s ease;
  border-radius: 50px;
   /* Transición para el color del fondo */
}

.pasarela-btn:hover {
  background-color:rgb(17, 62, 124);
  color:rgb(222, 197, 13);
  font: weight; /* Color del botón cuando el cursor está sobre él */
}

/* DataTable */
.table {
  margin-top: 20px;
  border-collapse: collapse;
  width: 100%;
}

.table th,
.table td {
  padding: 10px;
  text-align: left;
  border: 1px solid #ddd;
}

.table th {
  background-color: rgb(17, 111, 173);
  color: white;
  font-weight: bold;
}

.table tbody tr:nth-child(even) {
  background-color: #f4f7fa;
}

/* Botón de Generar Link */

.precio-total {
  font-size: 24px;
  /* Tamaño de fuente más grande */
  font-weight: bold;
  text-align: right;
  /* Alinear a la derecha */
  color: #2d87f0;
  /* Puedes elegir el color que prefieras */
}

.precio-total .pasarela-data {
  font-size: 28px;
  /* Tamaño de fuente aún más grande para el monto */
  color: #ff6600;
  /* Color destacado para el monto */
}
.pasarela-card .titulo-blanco {
  color: white !important;

}
</style>
<div class="container mt-5 pasarela-container">
  <div class="text-center pasarela-header">
    <h1 class="pasarela-title">Información del Cliente</h1>
    <p class="pasarela-subtitle">Detalles sobre el paquete activo y la suscripción</p>
  </div>

  <!-- Pestañas -->
  <ul class="nav nav-tabs" id="tabs" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" id="suscripcion-tab" data-bs-toggle="tab" href="#suscripcion" role="tab"
        aria-controls="suscripcion" aria-selected="true">Suscripción</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="historial-tab" data-bs-toggle="tab" href="#historial" role="tab" aria-controls="historial"
        aria-selected="false">Historial de Pagos</a>
    </li>
  </ul>

  <!-- Contenido de las pestañas -->
  <div class="tab-content" id="myTabContent">
    <!-- Pestaña Suscripción -->
    <div class="tab-pane fade show active" id="suscripcion" role="tabpanel" aria-labelledby="suscripcion-tab">
      <div class="card pasarela-card">
        <div class="card-header pasarela-card-header">
          <h3 class="text-center titulo-blanco">Detalle de tu Suscripción</h3>
        </div>
        <div class="card-body pasarela-card-body">
          <?php if (isset($datos_pago) && !empty($datos_pago)): ?>
          <div class="pasarela-row">
            <p><strong>Nombre del Cliente:</strong> <span
                class="pasarela-data"><?=htmlspecialchars($datos_pago->nombre)?></span></p>
            <p><strong>Suscripción:</strong> <span
                class="pasarela-data"><?=htmlspecialchars($datos_pago->nombre_paquete)?></span></p>
            <p><strong>Descripción del Paquete:</strong> <span
                class="pasarela-data"><?=htmlspecialchars($datos_pago->descripcion)?></span></p>
            <p><strong>Usuarios Incluidos:</strong> <span
                class="pasarela-data"><?=htmlspecialchars($datos_pago->usuarios)?></span></p>
            <p><strong>Usuarios Extras:</strong> <span
                class="pasarela-data"><?=htmlspecialchars($cantidad_usuarios)?></span></p>
            <p><strong>Fecha de Vencimiento:</strong> <span
                class="pasarela-data"><?=htmlspecialchars($fecha_vencimiento)?></span></p>
            <p><strong>Estado:</strong> <span class="pasarela-status"><?=htmlspecialchars($estado_pago)?></span></p>
          </div>

          <!-- Mostrar los usuarios extras -->
          <?php if (isset($usuarios) && !empty($usuarios)): ?>
          <h4>Usuarios Extras:</h4>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Usuarios</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($usuarios as $usuario): ?>
              <tr>
                <td><?=htmlspecialchars($usuario->nombre) . ' ' . htmlspecialchars($usuario->paterno)?></td>
                <td><?=htmlspecialchars($usuario->correo)?></td>
                <td>$<?=number_format($usuario->cobro, 2)?></td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
          <p class="precio-total"><strong>Precio Total:</strong> <span
              class="pasarela-data">$<?=number_format($cobro, 2)?> USD</span></p>
          <?php else: ?>
          <div class="pasarela-alert">
            No hay usuarios extras.
          </div>
          <?php endif;?>
          <?php else: ?>
          <div class="pasarela-alert">
            No hay datos disponibles para este cliente.
          </div>
          <?php endif;?>
        </div>
      </div>
    </div>

    <!-- Pestaña Historial de Pagos -->
    <div class="tab-pane fade" id="historial" role="tabpanel" aria-labelledby="historial-tab">
      <div class="card pasarela-card">
        <div class="card-header pasarela-card-header">
          <h3 class="text-center titulo-blanco">Historial de Pagos</h3>
        </div>
        <div class="card-body pasarela-card-body">
          <!-- DataTable para el historial de pagos -->
          <table id="historialPagos" class="table table-bordered">
            <thead>
              <tr>
                <th>ID Pago</th>
                <th>Fecha de Pago</th>
                <th>Monto</th>
                <th>Método de Pago</th>
                <th>Referencia</th>
              </tr>
            </thead>
            <tbody>
              <?php if (isset($historial_pagos) && !empty($historial_pagos)): ?>
              <?php foreach ($historial_pagos as $pago): ?>
              <tr>
                <td><?=htmlspecialchars($pago->id_pagos)?></td>
                <td><?=htmlspecialchars($pago->fecha_pago)?></td>
                <td>$<?=number_format($pago->monto, 2)?></td>
                <td><?=htmlspecialchars($pago->metodo_pago)?></td>
                <td><?=htmlspecialchars($pago->referencia)?></td>
              </tr>
              <?php endforeach;?>
              <?php else: ?>
              <tr>
                <td colspan="5" class="text-center">No hay historial de pagos disponible.</td>
              </tr>
              <?php endif;?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="text-end mt-4">
    <button class="btn pasarela-btn" id="btnGenerarPago">
      Generar Link de Pago
    </button>
  </div>
<!-- Aquí se mostrará el enlace de pago generado -->
<div id="linkPagoSection" style="display:none;">
    <p>Enlace de Pago: <a href="" id="linkPago" target="_blank">Generar enlace de pago</a></p>
</div>
  <!-- Scripts para Bootstrap 5 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script>

  document.addEventListener('DOMContentLoaded', function() {
    // Confirmación para generar enlace de pago
    const btnGenerarPago = document.getElementById('btnGenerarPago');
if (btnGenerarPago) {
  btnGenerarPago.addEventListener('click', function() {
    Swal.fire({
      title: 'Confirmar',
      text: '¿Deseas generar un enlace de pago?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, generar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Definir los parámetros que deseas enviar
        var amount = 10050;
        var currency = 'MXN';
        var description = 'Compra de ejemplo';

        // Hacer la solicitud AJAX para generar el enlace de pago
        $.ajax({
          url: '<?=site_url("Checkout_Clip/generarPago")?>',
          type: 'POST',
          data: {
            amount: amount,
            currency: currency,
            description: description
          },
          success: function(response) {
            // Suponiendo que el controlador retorna el enlace de pago generado
            var linkPago = response.linkPago;

            // Mostrar el enlace de pago en el DOM
            document.getElementById('linkPago').href = linkPago;
            document.getElementById('linkPagoSection').style.display = 'block'; // Mostrar la sección del enlace
          },
          error: function() {
            Swal.fire('Error', 'Hubo un error al generar el enlace de pago', 'error');
          }
        });
      }
    });
  });
}

    // Inicializar las pestañas Bootstrap 5
    var tab1 = new bootstrap.Tab(document.querySelector('#suscripcion-tab'));
    var tab2 = new bootstrap.Tab(document.querySelector('#historial-tab'));

    $('#historialPagos').DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "language": {
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "No se encontraron registros",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrado de _MAX_ registros totales)",
        "search": "Buscar:",
        "paginate": {
          "next": "Siguiente",
          "previous": "Anterior"
        }
      }
    });
  });
  </script>
</div>