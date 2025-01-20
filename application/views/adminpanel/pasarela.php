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
  text-align: right;
  /* Alinear el contenido del contenedor a la derecha */
}

.pasarela-btn {
  font-size: 20px;
  /* Tamaño de fuente del botón */
  padding: 10px 20px;
  /* Espaciado interior para hacerlo más grande */
  background-color: #2d87f0;
  /* Color de fondo del botón */
  color: white;
  /* Color del texto */
  border: none;
  /* Sin borde */
  border-radius: 5px;
  /* Bordes redondeados */
  cursor: pointer;
  /* Cambiar el cursor al pasar sobre el botón */
  transition: background-color 0.3s ease;
  border-radius: 50px;
  /* Transición para el color del fondo */
}

.pasarela-btn:hover {
  background-color: rgb(17, 62, 124);
  color: rgb(222, 197, 13);
  font: weight;
  /* Color del botón cuando el cursor está sobre él */
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

.titulo-blanco {
  color: white !important;

}
</style>


<div class="text-center pasarela-header">
  <h1 class="pasarela-title">Detalles de tu Suscripción</h1>
</div>

<!-- Pestañas -->
<ul class="nav nav-tabs" id="tabs" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="linkPago-tab" data-bs-toggle="tab" href="#linkPago" role="tab"
      aria-controls="linkPago" aria-selected="true">Pagar</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link " id="suscripcion-tab" data-bs-toggle="tab" href="#suscripcion" role="tab"
      aria-controls="suscripcion" aria-selected="false">Suscripción</a>
  </li>

  <li class="nav-item" role="presentation">
    <a class="nav-link" id="historial-tab" data-bs-toggle="tab" href="#historial" role="tab" aria-controls="historial"
      aria-selected="false">Historial de Pagos</a>
  </li>
</ul>

<!-- Contenido de las pestañas -->
<div class="tab-content" id="myTabContent">
  <!-- Pestaña Suscripción -->
  <div class="tab-pane fade" id="suscripcion" role="tabpanel" aria-labelledby="suscripcion-tab">
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
              <th>Costo</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
              <td><?=htmlspecialchars($usuario->nombre) . ' ' . htmlspecialchars($usuario->paterno)?></td>
              <td><?=htmlspecialchars($usuario->correo)?></td>
              <td>$<?=number_format($usuario->cobro, 2)?> USD</td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <input type="hidden" id="total" value="<?=htmlspecialchars(number_format($cobro, 2))?>" />

        <p class="precio-total"><strong>Precio Total:</strong> <span
            class="pasarela-data">$<?=number_format($cobro, 2)?> USD</span></p>
        <?php else: ?>
        <div class="pasarela-alert">
          No hay usuarios extras.
        </div>
        <?php endif; ?>
        <?php else: ?>
        <div class="pasarela-alert">
          No hay datos disponibles para este cliente.
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>


  <!-- seccion para ver o generar el link de pago-->
  <div class="tab-pane fade show active" id="linkPago" role="tabpanel" aria-labelledby="linkPago-tab">
    <div class="card-header pasarela-card-header">
      <h3 class="text-center titulo-blanco">Detalles del Enlace de Pago</h3>
    </div>
    <div class="card-body pasarela-card-body">
      <table id="tablaLinkPago" class="table table-bordered">
        <thead>
          <tr>
            <th>ID Link de pago</th>
            <th>Link para realizar pago</th>
            <th>Estatus del link</th>
            <th>Fue generado</th>
            <th>El link Expira</th>
            <th>Ver QR</th>
            <th>Confirmar el Pago</th>
          </tr>
        </thead>

        <tbody>
          <?php if (isset($link_pago) && !empty($link_pago)): ?>
          <td><?=htmlspecialchars($link_pago->id)?></td>
          <td> <a href="<?=htmlspecialchars($link_pago->payment_request_url)?>" target="_blank" class="text-primary "><i
                class="bi bi-credit-card"></i>Ir al Pago</a>
          </td>
          <td> <span class="<?=htmlspecialchars($status_link_pago_class)?>">
              <?=htmlspecialchars($status_link_pago_text)?>
            </span></td>
          <td><?=htmlspecialchars($link_pago->created_at)?></td>
          <td><?=htmlspecialchars($link_pago->expires_at)?></td>
          <td><a href="<?=htmlspecialchars($link_pago->qr_image_url)?>" target="_blank" class="text-primary ">Ver QR</a>
          </td>
          <td>
            <input type="button" class="btn pasarela-btn" value="Confirmar Pago"
              onclick="confirmarPago('<?=$link_pago->payment_request_id?>')">
          </td>
          <?php else: ?>
          <tr>
            <td colspan="7" class="text-center">No se ha generado un link de pago o este ya expiró. Por favor, genera otro. Ten en cuenta que el link de pago solo podrá generarse a partir del primer día de cada mes o cuando tu suscripción se encuentre pendiente  o vencida.
            </td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <?php   if (!isset($link_pago) && empty($link_pago) && $estado_pago != 'pagado' ): ?>
    <div class="text-end mt-4">
      <button class="btn pasarela-btn" id="btnGenerarPago">
        Generar Link de Pago 
      </button>
    </div>
    <?php endif; ?>
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
              <th>Estatus </th>
              <th>Referencia</th>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($historial_pagos) && !empty($historial_pagos)): ?>
            <?php foreach ($historial_pagos as $pago): ?>
            <tr>
              <td><?=htmlspecialchars($pago->payment_request_id)?></td>
              <td><?=htmlspecialchars($pago->fecha_pago)?></td>
              <td>$<?=htmlspecialchars($pago->monto)?></td>
              <td><a href="<?=htmlspecialchars($pago->link_status)?>" target= "blank">Ver Status</a></td>
              <td><?=htmlspecialchars($pago->referencia)?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
              <td colspan="5" class="text-center">No hay historial de pagos disponible.</td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<!-- Scripts para Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


<script>
function confirmarPago(parametro) {
  console.log('El parámetro es: ' + parametro);

  // Realizar una solicitud AJAX para verificar el estado del pago
  $.ajax({
    url: '<?= base_url("Checkout_Clip/verificarEstadoPago") ?>', // Ruta al método del controlador en CodeIgniter
    type: 'POST',
    dataType: 'json', // Esperamos una respuesta JSON
    data: {
      payment_request_id: parametro // Enviar el payment_request_id como parámetro
    },
    success: function(response) {

      // Verificar si la respuesta contiene el estado
      if (response.status) {
        let statusMessage = '';

        // Asignar la descripción según el estado
        switch (response.status) {
          case 'CHECKOUT_CREATED':
            statusMessage = 'El link de pago fue creado exitosamente y esta   pendiente  de ser  completado.';
            break;
          case 'CHECKOUT_PENDING':
            statusMessage = 'El link de pago está activo y pendiente de ser completado.';
            break;
          case 'CHECKOUT_CANCELLED':
            statusMessage = 'El link de pago fue cancelado por exceso de intentos (máximo 5).';
            break;
          case 'CHECKOUT_EXPIRED':
            statusMessage = 'El link de pago expiró.';
            break;
          case 'CHECKOUT_COMPLETED':
            statusMessage = 'El link de pago se liquidó.';
            break;
          default:
            statusMessage = 'Estado desconocido.';
            break;
        }

        // Crear el contenido del mensaje
        let mensaje = `
                    <strong>Estatus de la solicitud de pago:</strong> ${statusMessage}<br>
                    <strong>Monto:</strong> ${response.amount} ${response.currency}<br>
                    <strong>Descripción de la compra:</strong> ${response.purchase_description}<br>
                    <strong>URL de pago:</strong> <a href="${response.payment_request_url}" target="_blank">Ir al Pago</a><br>
                `;

        // Verificar si hay una acción pendiente
        if (response.pending_action) {
          mensaje += `
                        <strong>Acción pendiente:</strong> ${response.pending_action.type}<br>
                        <strong>Referencia de acción pendiente:</strong> ${response.pending_action.reference}<br>
                    `;
        }

        // Mostrar la alerta con los datos
        Swal.fire({
          title: 'Información del pago',
          html: mensaje, // Usar el contenido generado
          icon: 'info',
          confirmButtonText: 'Cerrar'
        }).then((result) => {
          if (result.isConfirmed) {
            // Recargar la página para actualizar los datos
            location.reload(); // Esto recargará la página y cargará los nuevos datos
          }
        });

      } else {
        console.error("Error: No se pudo validar el pago.");
        Swal.fire({
          title: 'Error',
          text: 'No se pudo obtener el estado del pago.',
          icon: 'error',
          confirmButtonText: 'Cerrar'
        });
      }
    },
    error: function(xhr, status, error) {
      console.error("Hubo un error en la solicitud AJAX:", error);
      Swal.fire({
        title: 'Error',
        text: 'Hubo un problema con la solicitud, por favor intente de nuevo.',
        icon: 'error',
        confirmButtonText: 'Cerrar'
      });
    }
  });
}



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
          //var monto = 1.00;
          monto = parseFloat(document.getElementById('total').value) || 0;
          var currency = 'USD';
          //var currency = 'MXN';
          var description = 'Pago mensual de la suscripción a TalentSafe. Para más detalles sobre los beneficios y características de la suscripción, visita el apartado de Suscripción en nuestra plataforma.';

          // Hacer la solicitud AJAX para generar el enlace de pago
          $.ajax({
            url: '<?=site_url("Checkout_Clip/generarPago")?>',
            type: 'POST',
            data: {
              amount: monto,
              currency: currency,
              description: description
            },
            success: function(response) {


              // Si response es una cadena, la convertimos a objeto JSON
              if (typeof response === 'string') {
                response = JSON.parse(response);
              }

              // Verificamos que la respuesta contenga el objeto 'linkPago'
              if (response.status == 'success' && response.linkPago > 0) {
                // Verifica que la respuesta sea positiva y el enlace de pago se haya generado correctamente
                Swal.fire({
                  title: '¡Éxito!',
                  text: 'El enlace de pago se generó con éxito. Revisa la sección de pagos para acceder a él.',
                  icon: 'success',
                  confirmButtonText: 'Aceptar'
                }).then((result) => {
                  if (result.isConfirmed) {
                    // Recargar la página para actualizar los datos
                    location.reload(); // Esto recargará la página y cargará los nuevos datos
                  }
                });
              } else {
                // Si la respuesta no es válida o hay un error
                Swal.fire('Error',
                  'Hubo un problema al generar el enlace de pago. Por favor, inténtalo nuevamente.',
                  'error');
              }

            },
            error: function(xhr, status, error) {
              console.error('Error en la solicitud AJAX:', error);
              Swal.fire('Error', 'Hubo un error al procesar la solicitud', 'error');
            }
          });
        }
      });
    });
    // Inicializar las pestañas Bootstrap 5
    var tab3 = new bootstrap.Tab(document.querySelector('#suscripcion-tab'));
    var tab2 = new bootstrap.Tab(document.querySelector('#historial-tab'));
    var tab1 = new bootstrap.Tab(document.querySelector('#linkPago-tab'));

    // Configuración de DataTable
    $.fn.dataTable.ext.errMode = 'throw';

    // Inicializar DataTable en la tabla de historial de pagos
    if ($.fn.DataTable.isDataTable('#historialPagos')) {
      $('#historialPagos').DataTable().destroy();


    }
    if ($.fn.DataTable.isDataTable('#tablaLinkPago')) {
      $('#tablaLinkPago').DataTable().destroy();


    }

  }
});
</script>