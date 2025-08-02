<?php if (! empty($cargar_recursos)): ?>

    <!-- ✅ Estilos primero -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- FontAwesome -->
    <link href="<?php echo base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">

    <!-- SB Admin 2 -->
    <?php echo link_tag("css/sb-admin-2.min.css"); ?>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">

    <!-- Bootstrap Select y Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <?php echo link_tag("css/custom.css"); ?>

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- ✅ Scripts después -->
    <!-- jQuery -->
    <script src="<?php echo base_url() ?>vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Bundle (incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery Easing -->
    <script src="<?php echo base_url() ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- Bootstrap Select -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- (Opcional) Chart.js si lo usas -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <script src="<?php echo base_url() ?>js/chart.min.js"></script> -->


<!-- otros recursos -->

<a
  href="<?php echo base_url(); ?>Login/logout"
  style="
    display:inline-block;
    background-color:#d9534f;
    color:#fff;
    font-weight:bold;
    padding:10px 18px;
    border-radius:8px;
    text-decoration:none;
    font-family:'Segoe UI', Tahoma, sans-serif;
    font-size:15px;
    box-shadow:0 4px 8px rgba(0,0,0,0.1);
    transition:all 0.3s ease;
  "
  onmouseover="this.style.backgroundColor='#c9302c'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.15)';"
  onmouseout="this.style.backgroundColor='#d9534f'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.1)';"
>
  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400" style="margin-right:6px;"></i>
  Cerrar sesión
</a>
 <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <img style="max-width: 220px; max-height: 150px;"
          src="<?php echo base_url(); ?>_logosPortal/logo_nuevo.png" alt="Logo">
      </a>
 <div class="alert alert-danger text-center" role="alert" style="margin:10px; font-weight:600;">
    <i class="fas fa-exclamation-triangle"></i>
    Tu suscripción a <strong>TalentSafe</strong> ha expirado. Por favor realiza tu pago cuanto antes generando un link de pago.
    <br>Después de pagarlo, regresa aquí y confírmalo en el botón correspondiente. De esta manera tus accesos quedarán habilitados nuevamente.
    <br>También puedes comunicarte al <strong>(52) 3334 54 2877</strong> vía llamada o WhatsApp de <strong>L‑V de 8 am a 6 pm</strong> para cualquier duda o aclaración.
  </div>
<?php endif; ?>

<!-- ========================================================= -->
<!-- 🔹 Encabezado principal -->
<!-- ========================================================= -->
<div class="text-center pasarela-header">
  <h1 class="pasarela-title">Detalles de tu Suscripción</h1>
  <!-- Incluye Bootstrap desde tu base_url -->
</div>
<!-- ========================================================= -->
<!-- 🔹 Pestañas de navegación -->
<!-- ========================================================= -->
<ul class="nav nav-tabs" id="tabs" role="tablist">
  <li class="nav-item" role="presentation">
    <a class="nav-link active" id="linkPago-tab" data-bs-toggle="tab" href="#linkPago" role="tab"
      aria-controls="linkPago" aria-selected="true">Pagar</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="suscripcion-tab" data-bs-toggle="tab" href="#suscripcion" role="tab"
      aria-controls="suscripcion" aria-selected="false">Suscripción</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link" id="historial-tab" data-bs-toggle="tab" href="#historial" role="tab" aria-controls="historial"
      aria-selected="false">Historial de Pagos</a>
  </li>
</ul>

<!-- ========================================================= -->
<!-- 🔹 Contenedor de contenido para las pestañas -->
<!-- ========================================================= -->
<div class="tab-content" id="myTabContent">

  <!-- ============================== -->
  <!-- 🟢 Pestaña: SUSCRIPCIÓN -->
  <!-- ============================== -->
  <div class="tab-pane fade" id="suscripcion" role="tabpanel" aria-labelledby="suscripcion-tab">
    <div class="card pasarela-card">
      <div class="card-header pasarela-card-header">
        <h3 class="text-center titulo-blanco">Detalle de tu Suscripción</h3>
      </div>
      <div class="card-body pasarela-card-body">

        <!-- Validación: si existen datos de pago -->
        <?php if (isset($datos_pago) && ! empty($datos_pago)): ?>
        <div class="pasarela-row">
          <p><strong>Nombre del Cliente:</strong> <span
              class="pasarela-data"><?php echo htmlspecialchars($datos_pago->nombre) ?></span></p>
          <p><strong>Suscripción:</strong> <span
              class="pasarela-data"><?php echo htmlspecialchars($datos_pago->nombre_paquete) ?></span><span
              class="badge bg-success">
              $<?php echo number_format($datos_pago->precio); ?> USD
            </span>
          </p>
          <p><strong>Descripción del Paquete:</strong> <span
              class="pasarela-data"><?php echo htmlspecialchars($datos_pago->descripcion) ?></span></p>
          <p><strong>Usuarios Incluidos:</strong> <span
              class="pasarela-data"><?php echo htmlspecialchars($datos_pago->usuarios) ?></span></p>
          <p>
            <strong>Usuarios Extras:</strong>
            <span class="badge bg-primary">
              <?php echo htmlspecialchars($cantidad_usuarios); ?> usuario(s)
            </span>
            <span class="badge bg-success">
              $<?php echo number_format($cantidad_usuarios * 50, 2); ?> USD
            </span>
          </p>
          <p><strong>Fecha de Vencimiento:</strong> <span
              class="pasarela-data"><?php echo htmlspecialchars($fecha_vencimiento) ?></span></p>
          <p><strong>Estado:</strong> <span class="pasarela-status"><?php echo htmlspecialchars($estado_pago) ?></span>
          </p>
        </div>

        <!-- Tabla: usuarios extras -->
        <?php if (isset($usuarios) && ! empty($usuarios)): ?>
        <h4>Usuarios Extras:</h4>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Correo/descriocion</th>
              <th>Precio</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo htmlspecialchars($datos_pago->nombre_paquete ?? '') ?></td>
              <td><span class="descripcion-paquete"><?php echo nl2br($datos_pago->descripcion ?? 'Paquete'); ?></span>
              </td>
              <td>$<?php echo htmlspecialchars($datos_pago->precio ?? '') ?> USD</td>

              <td></td>
            </tr>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
              <td>
                <?php echo htmlspecialchars($usuario->nombre ?? '') . ' ' . htmlspecialchars($usuario->paterno ?? '') ?>
              </td>
              <td><?php echo htmlspecialchars($usuario->correo ?? '') ?></td>
              <td>$<?php echo number_format($usuario->cobro ?? 0, 2) ?> USD</td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php endif; ?>

        <!-- Total -->
        <input type="hidden" id="total" value="<?php echo htmlspecialchars(number_format($cobro, 2)) ?>" />

        <?php if (htmlspecialchars($estado_pago) === 'pagado'): ?>
        <p class="precio-total"><strong>Precio Total:</strong> <span
            class="pasarela-data">$<?php echo $datos_pago->precio + ($cantidad_usuarios * 50) ?> USD</span></p>
        <?php else: ?>

        <p class="precio-total"><strong>Precio Total:</strong> <span
            class="pasarela-data">$<?php echo number_format($cobro, 2) ?> USD</span></p>
        <?php endif; ?>
<?php else: ?>
        <!-- Si no hay datos -->
        <div class="pasarela-alert">
          No hay datos disponibles para este cliente.
        </div>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <!-- ============================== -->
  <!-- 🟢 Pestaña: LINK DE PAGO -->
  <!-- ============================== -->
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
          <?php if (isset($link_pago) && ! empty($link_pago)): ?>
          <tr>
            <td><?php echo htmlspecialchars($link_pago->id) ?></td>
            <td>
              <a href="<?php echo htmlspecialchars($link_pago->payment_request_url) ?>" target="_blank"
                class="text-primary">
                <i class="bi bi-credit-card"></i> Ir al Pago
              </a>
            </td>
            <td>
              <span class="<?php echo htmlspecialchars($status_link_pago_class) ?>">
                <?php echo htmlspecialchars($status_link_pago_text) ?>
              </span>
            </td>
            <td><?php echo htmlspecialchars($link_pago->created_at) ?></td>
            <td><?php echo htmlspecialchars($link_pago->expires_at) ?></td>
            <td>
              <a href="<?php echo htmlspecialchars($link_pago->qr_image_url) ?>" target="_blank"
                class="text-primary">Ver QR</a>
            </td>
            <td>
              <?php if (isset($link_pago) && ! empty($link_pago)): ?>
              <input type="button" class="btn pasarela-btn" value="Confirmar Pago"
                onclick="confirmarPago('<?php echo $link_pago->payment_request_id ?>')">
              <?php else: ?>
              <span class="<?php echo htmlspecialchars($status_link_pago_class) ?>">
                <?php echo htmlspecialchars($status_link_pago_text) ?>
              </span>
              <?php endif; ?>
            </td>
          </tr>
          <?php else: ?>
          <tr>
            <td colspan="7" class="text-center">
              No se ha generado un link de pago o este ya expiró. Por favor, genera otro.
            </td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Botón para generar link si está expirado -->


    <div class="generar-link">
      <button class="btn pasarela-btn-2" id="btnAbrirModalPago">Generar Link de Pago</button>
    </div>
  </div>

  <!-- ============================== -->
  <!-- 🟢 MODAL: Generar pago -->
  <!-- ============================== -->
  <div class="modal fade" id="modalGenerarPago" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Encabezado del modal -->
        <div class="modal-header-pagos">
          <h5 class="modal-title">Generar Pago -                                                 <?php echo $datos_pago->nombre_paquete ?? 'Paquete'; ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Cuerpo del modal -->
        <div class="modal-body">
          <h5 class="title">
            <strong
              class="text-uppercase"><?php echo $datos_pago->nombre_paquete . ' ' . $datos_pago->precio . ' USD' ?></strong>
            <br>
            <span class="descripcion-paquete"><?php echo nl2br($datos_pago->descripcion ?? 'Paquete'); ?></span>
          </h5>
          <p><strong>Usuarios Extras:</strong></p>
          <ul>
            <?php foreach ($usuarios as $usuario): ?>
            <li><?php echo $usuario->nombre; ?><?php echo $usuario->paterno . ' $50 USD'; ?></li>
            <?php endforeach; ?>
          </ul>

          <p><strong>Selecciona los meses a pagar:</strong></p>
          <div class="meses-grid" id="mesesContainer">
            <?php foreach ($meses_disponibles as $mes): ?>
            <button type="button" class="btn btn-outline-primary btn-mes" data-fecha="<?php echo $mes['fecha']; ?>">
              <?php echo $mes['nombre_mes']; ?>
            </button>
            <?php endforeach; ?>
          </div>

          <!-- Campo oculto para enviar meses seleccionados -->
          <input type="hidden" id="inputMesesSeleccionados" name="meses" value="">
          <!-- Monto total -->
          <p class="total-monto"><strong>Total:</strong> <span id="montoTotal">$0.00 </span> USD</p>


        </div>
        <!-- Pie del modal -->
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btnPagar">Generar Link</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ============================== -->
  <!-- 🟢 Pestaña: HISTORIAL DE PAGOS -->
  <!-- ============================== -->
  <div class="tab-pane fade" id="historial" role="tabpanel" aria-labelledby="historial-tab">
    <div class="card pasarela-card">
      <div class="card-header pasarela-card-header">
        <h3 class="text-center titulo-blanco">Historial de Pagos</h3>
      </div>
      <div class="card-body pasarela-card-body">
        <table id="historialPagos" class="table table-bordered">
          <thead>
            <tr>
              <th>ID Pago</th>
              <th>Mes a pagar</th>
              <th>Fecha de Pago</th>
              <th>Monto</th>
              <th>Estatus</th>
              <th>Referencia</th>
            </tr>
          </thead>
          <tbody>
            <?php if (isset($historial_pagos) && ! empty($historial_pagos)): ?>
<?php foreach ($historial_pagos as $pago): ?>
            <tr>
              <td><?php echo htmlspecialchars($pago->payment_request_id ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
              <td>
                <?php
                    if (! empty($pago->mes)) {
                        $fecha = DateTime::createFromFormat('Y-m-d', $pago->mes);
                        if ($fecha) {
                            // Mapeo manual de meses en español
                            $meses = [
                                1 => 'Enero', 2       => 'Febrero', 3  => 'Marzo', 4      => 'Abril',
                                5 => 'Mayo', 6        => 'Junio', 7    => 'Julio', 8      => 'Agosto',
                                9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
                            ];

                            $mesNum = (int) $fecha->format('n'); // número de mes 1-12
                            $anio   = $fecha->format('Y');       // año completo
                            echo $meses[$mesNum] . ' ' . $anio;  // ejemplo: Julio 2025
                        } else {
                            echo '-';
                        }
                    } else {
                        echo '-';
                    }
                ?>
              </td>
              <td>
                <?php
                    $fechaPago  = $pago->fecha_pago ?? ''; // si es null, será cadena vacía
                    $estadoPago = $pago->estado ?? '';     // igual, cadena vacía si es null

                    echo $fechaPago !== ''
                    ? htmlspecialchars($fechaPago, ENT_QUOTES, 'UTF-8')
                    : htmlspecialchars($estadoPago, ENT_QUOTES, 'UTF-8');
                ?>
              </td>
              <td>$<?php echo htmlspecialchars($pago->monto) ?></td>
              <td>
                <?php if (! empty($pago->link_status)): ?>
                <!-- ✅ Hay link_status, mostramos el link normal -->
                <a href="<?php echo htmlspecialchars($pago->link_status) ?>" target="_blank">Ver Status</a>
                <?php else: ?>
                <!-- ❌ No hay link_status, usamos un botón para lanzar SweetAlert -->
                <button type="button" class="btn btn-sm btn-info verStatusLocal"
                  data-fecha="<?php echo htmlspecialchars($pago->estado) ?>">
                  Ver Status
                </button>
                <?php endif; ?>
              </td>
              <td><?php echo htmlspecialchars($pago->referencia ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
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

</div> <!-- Fin tab-content -->



<!-- Scripts para Bootstrap 5 -->
<script src="<?php echo base_url('js/bootstrap.bundle.min.js') ?>"></script>


<script>
// =========================================================
// 🔹 FUNCIÓN: Confirmar el estado de un pago existente
// =========================================================
function confirmarPago(parametro) {
  console.log('El parámetro es: ' + parametro);

  // Petición AJAX para consultar estado de pago
  $.ajax({
    url: '<?php echo base_url("Checkout_Clip/verificarEstadoPago") ?>',
    type: 'POST',
    dataType: 'json',
    data: {
      payment_request_id: parametro
    },
    success: function(response) {
      // Si la respuesta trae estado:
      if (response.status) {
        let statusMessage = '';

        // Mapeo de estados a texto amigable
        switch (response.status) {
          case 'CHECKOUT_CREATED':
            statusMessage = 'El link de pago fue creado y está pendiente de ser completado.';
            break;
          case 'CHECKOUT_PENDING':
            statusMessage = 'El link de pago está activo y pendiente de ser completado.';
            break;
          case 'CHECKOUT_CANCELLED':
            statusMessage = 'El link de pago fue cancelado por exceso de intentos.';
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

        // Armamos el contenido que se mostrará en SweetAlert
        let mensaje = `
          <strong>Estatus:</strong> ${statusMessage}<br>
          <strong>Monto:</strong> ${response.amount} ${response.currency}<br>
          <strong>Descripción:</strong> ${response.purchase_description}<br>
          <strong>URL:</strong> <a href="${response.payment_request_url}" target="_blank">Ir al Pago</a><br>
        `;

        // Si hay acciones pendientes, las añadimos
        if (response.pending_action) {
          mensaje += `
            <strong>Acción pendiente:</strong> ${response.pending_action.type}<br>
            <strong>Referencia:</strong> ${response.pending_action.reference}<br>
          `;
        }

        // Mostrar información con SweetAlert
        Swal.fire({
          title: 'Información del pago',
          html: mensaje,
          icon: 'info',
          showConfirmButton: false,
          timer: 4000,
          timerProgressBar: true
        }).then(() => {
          // Recargar la página al cerrar alerta
          location.reload();
        });

      } else {
        // Error si no hay estado
        console.error("Error: No se pudo validar el pago.");
        Swal.fire('Error', 'No se pudo obtener el estado del pago.', 'error');
      }
    },
    error: function(xhr, status, error) {
      console.error("Hubo un error en la solicitud AJAX:", error);
      Swal.fire('Error', 'Hubo un problema con la solicitud, por favor intente de nuevo.', 'error');
    }
  });
}

// =========================================================
// 🔹 DOCUMENT READY: Eventos y lógica al cargar la página
// =========================================================
document.addEventListener('DOMContentLoaded', function() {

  // Precio base mensual desde PHP
  const precioMensual =                        <?php echo $datos_pago->precio ?? 999; ?>;
  const cobroProporcional =                            <?php echo $cobro ?? 999; ?>;
  const cobroMensualFijo =                           <?php echo $cobro_mes ?? 999; ?>;
  const mesActual = "<?php echo date('Y-m') ?>";

  // Array para guardar los meses seleccionados dinámicamente

  // =========================================================
  // ✅ Selección de meses (botones dinámicos)
  // =========================================================
  // arreglo global
  let mesesSeleccionados = [];

  $(document).on('click', '.btn-mes', function() {
    const fecha = $(this).data('fecha');
    const botones = $('.btn-mes'); // todos los botones en orden

    // obtener índices de cada botón
    const indexClic = botones.index(this);

    // si el mes ya estaba seleccionado → vamos a desmarcar desde ese índice en adelante
    if (mesesSeleccionados.includes(fecha)) {
      // recorrer todos los botones desde el final hacia el índice clicado
      botones.each(function(i, btn) {
        const f = $(btn).data('fecha');
        if (i >= indexClic && mesesSeleccionados.includes(f)) {
          // quitar selección
          mesesSeleccionados = mesesSeleccionados.filter(m => m !== f);
          $(btn).removeClass('btn-primary').addClass('btn-outline-primary');
        }
      });
    } else {
      // no estaba seleccionado: marcar desde el inicio hasta este índice
      botones.each(function(i, btn) {
        const f = $(btn).data('fecha');
        if (i <= indexClic && !mesesSeleccionados.includes(f)) {
          mesesSeleccionados.push(f);
          $(btn).removeClass('btn-outline-primary').addClass('btn-primary');
        }
      });
    }

    // actualizar campo oculto y monto
    $('#inputMesesSeleccionados').val(mesesSeleccionados.join(','));
    calcularMonto();
  });




  // =========================================================
  // ✅ Función: Calcular monto total en base a meses seleccionados
  // =========================================================
  function calcularMonto() {
    let total = 0;

    mesesSeleccionados.forEach(function(fechaCompleta) {
      // Normaliza el formato "YYYY-MM-DD" a solo "YYYY-MM"
      const soloMes = fechaCompleta.substring(0, 7);

      if (soloMes === mesActual) {
        // ✅ Es el mes actual → usar cobro proporcional
        total += cobroProporcional;
      } else {
        // ✅ Es un mes futuro → usar cobro mensual fijo
        total += cobroMensualFijo;
      }
    });

    // Mostrar el total en la interfaz
    $('#montoTotal').text(`$${total.toFixed(2)}`);
  }



  // =========================================================
  // ✅ Abrir modal para generar pago (limpia selección)
  // =========================================================
  $('#btnAbrirModalPago').on('click', function() {
    mesesSeleccionados = [];
    $('.btn-mes').removeClass('btn-primary').addClass('btn-outline-primary');
    $('#inputMesesSeleccionados').val('');
    $('#montoTotal').text('$0.00');

    const modal = new bootstrap.Modal(document.getElementById('modalGenerarPago'));
    modal.show();
  });

  // =========================================================
  // ✅ Generar pago desde el modal
  // =========================================================
  $('#btnPagar').on('click', function() {
    if (mesesSeleccionados.length === 0) {
      Swal.fire('Error', 'Debes seleccionar al menos un mes.', 'error');
      return;
    }

    // Calcular monto y preparar datos
    const montoTotalTexto = document.getElementById('montoTotal').textContent;

    // Ejemplo: "$0.00 USD"
    console.log(montoTotalTexto);

    // Si quieres convertirlo a número (quitar símbolos y letras):
    const montoTotalNumero = parseFloat(
      montoTotalTexto.replace(/[^0-9.]+/g, '') // deja solo números y puntos
    );
    const description = 'Pago por ' + mesesSeleccionados.length + ' mes(es) de la suscripción.';

    // Llamada AJAX para generar enlace de pago
    $.ajax({
      url: '<?php echo site_url("Checkout_Clip/generarPago") ?>',
      type: 'POST',
      data: {
        amount: montoTotalNumero,
        months: mesesSeleccionados.length,
        description: description,
        mesesPorPagar: mesesSeleccionados
      },
      success: function(response) {
        if (typeof response === 'string') response = JSON.parse(response);

        if (response.status == 'success' && response.linkPago) {
          Swal.fire('¡Éxito!', 'El enlace de pago se generó correctamente.', 'success').then(() => {
            location.reload();
          });
        } else {
          Swal.fire('Error', 'No se pudo generar el enlace de pago.', 'error');
        }
      },
      error: function() {
        Swal.fire('Error', 'Hubo un error en la solicitud.', 'error');
      }
    });

    // Cerrar modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalGenerarPago'));
    modal.hide();
  });

  // =========================================================
  // ✅ Botón principal "Generar Pago" (fuera del modal)
  // =========================================================
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
          const monto = parseFloat(document.getElementById('total').value) || 0;
          const currency = 'USD';
          const description =
            'Pago mensual de la suscripción a TalentSafe. Para más detalles visita el apartado de Suscripción.';

          // Generar enlace de pago
          $.ajax({
            url: '<?php echo site_url("Checkout_Clip/generarPago") ?>',
            type: 'POST',
            data: {
              amount: monto,
              currency: currency,
              description: description
            },
            success: function(response) {
              if (typeof response === 'string') response = JSON.parse(response);
              if (response.status == 'success' && response.linkPago > 0) {
                Swal.fire('¡Éxito!', 'El enlace de pago se generó con éxito.', 'success').then(() => {
                  location.reload();
                });
              } else {
                Swal.fire('Error', 'Hubo un problema al generar el enlace de pago.', 'error');
              }
            },
            error: function(xhr, status, error) {
              console.error('Error en la solicitud AJAX:', error);
              Swal.fire('Error', 'Hubo un error al procesar la solicitud.', 'error');
            }
          });
        }
      });
    });
  }

  // =========================================================
  // ✅ Inicializar DataTables (evita errores si ya están inicializadas)
  // =========================================================
  $.fn.dataTable.ext.errMode = 'throw';
  if ($.fn.DataTable.isDataTable('#historialPagos')) {
    $('#historialPagos').DataTable().destroy();
  }
  if ($.fn.DataTable.isDataTable('#tablaLinkPago')) {
    $('#tablaLinkPago').DataTable().destroy();
  }
  // =========================================================
  // ✅ Accion para  ver Status Pago
  // =========================================================

  $(document).on('click', '.verStatusLocal', function() {
    const estado = $(this).data('fecha'); // ahora contiene 'pendiente', 'vencido' o 'pagado'

    if (estado === 'pagado') {
      Swal.fire({
        icon: 'success',
        title: 'Pago confirmado',
        text: 'Este mes ya está pagado.',
        confirmButtonText: 'Aceptar'
      });
    } else if (estado === 'pendiente') {
      Swal.fire({
        icon: 'warning',
        title: 'Pago pendiente',
        text: 'Este mes aún está pendiente de pago.',
        confirmButtonText: 'Aceptar'
      });
    } else if (estado === 'expirado') {
      Swal.fire({
        icon: 'error',
        title: 'Pago vencido',
        text: 'Este mes ya pasó la fecha límite de pago.',
        confirmButtonText: 'Aceptar'
      });
    } else {
      Swal.fire({
        icon: 'info',
        title: 'Sin información',
        text: 'No se encontró un estado válido.',
        confirmButtonText: 'Aceptar'
      });
    }
  });


}); // DOMContentLoaded
</script>
<style>
/* =========================================================
 🎨 ESTILOS GENERALES
========================================================= */
body {
  font-family: 'Poppins', 'Segoe UI', Tahoma, sans-serif;
  background-color: #f5f7fa;
  /* fondo neutro */
  color: #222;
  margin: 0;
  padding: 0;
}

/* =========================================================
 📦 CONTENEDOR PRINCIPAL
========================================================= */
.pasarela-container {
  max-width: 1200px;
  margin: 30px auto;
  padding: 30px;
  background-color: #ffffff;
  border-radius: 12px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
}

/* =========================================================
 🏷️ ENCABEZADOS Y TEXTOS
========================================================= */
.pasarela-header {
  margin-bottom: 30px;
  text-align: center;
}

.pasarela-title {
  font-size: 2.2rem;
  color: #0d47a1;
  /* azul corporativo sólido */
  font-weight: 800;
  margin-bottom: 8px;
}

.pasarela-subtitle {
  font-size: 1rem;
  color: #555;
}

/* =========================================================
 MODAL
========================================================= */
.modal-content {
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 10px 32px rgba(0, 0, 0, 0.15);
}

.modal-header-pagos {
  background-color: #0d47a1;
  color: #fff !important;
  padding: 1.2rem 1.5rem;
  border-bottom: none;

  /* Flexbox para alinear en fila */
  display: flex;
  align-items: center;
  /* Centrado vertical */
  justify-content: space-between;
  /* Espaciado entre título y botón */
}

.titulo-blanco {
  color: #eceef2ff !important;
}

.modal-title {
  color: #eceef2ff !important;
  font-size: 1.4rem;
  font-weight: 700;
}

.btn-close {
  filter: brightness(0) invert(1);
  opacity: 0.85;
  transition: opacity 0.3s ease;
}

.btn-close:hover {
  opacity: 1;
}

.modal-body {
  padding: 1.5rem;
  color: #333;
  font-size: 1rem;
}

.modal-footer {
  background-color: #f1f1f1;
  padding: 1rem;
  border-top: none;
  justify-content: flex-end;
}

.modal-footer .btn-success {
  background-color: #2e7d32;
  /* verde profesional */
  border: none;
  padding: 0.7rem 1.4rem;
  font-size: 1.05rem;
  font-weight: 700;
  border-radius: 8px;
  transition: all 0.3s ease;
  color: #fff;
}

.modal-footer .btn-success:hover {
  background-color: #1b5e20;
  transform: translateY(-1px);
}

/* =========================================================
 BOTONES DE MESES
========================================================= */
#mesesContainer {
  display: flex;
  flex-wrap: wrap;
  gap: 0.6rem;
  margin-bottom: 1rem;
}

#mesesContainer .btn-mes {
  background-color: #e3f2fd;
  border: 2px solid #0d47a1;
  color: #0d47a1;
  font-size: 0.95rem;
  font-weight: 600;
  padding: 0.6rem 1rem;
  border-radius: 8px;
  transition: all 0.3s ease;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
}

#mesesContainer .btn-mes:hover {
  background-color: #0d47a1;
  color: #fff;
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

#mesesContainer .btn-mes.btn-primary {
  background-color: #1565c0;
  color: #fff;
  border-color: #0d47a1;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

/* =========================================================
 TOTAL
========================================================= */
#montoTotal {
  font-size: 1.8rem;
  font-weight: 800;
  color: #2e7d32;
  margin-top: 10px;
  text-align: right;
}

/* =========================================================
 PESTAÑAS DE NAVEGACIÓN
========================================================= */
.nav-tabs {
  border-bottom: 2px solid #0d47a1;
  justify-content: center;
  margin-bottom: 1rem;
}

.nav-tabs .nav-link {
  border: 2px solid transparent;
  border-radius: 50px;
  padding: 12px 20px;
  background-color: #e8eaf6;
  color: #0d47a1;
  font-weight: 600;
  margin: 0 4px;
  transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
  background-color: #c5cae9;
}

.nav-tabs .nav-link.active {
  background-color: #0d47a1;
  color: #fff;
  border-color: #0d47a1;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* =========================================================
 TARJETAS
========================================================= */
.pasarela-card {
  border-radius: 10px;
  border: none;
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
  background-color: #fff;
  margin-bottom: 20px;
  overflow: hidden;
}

.pasarela-card-header {
  background-color: #0d47a1;
  color: #fff;
  font-size: 20px;
  padding: 16px;
  font-weight: 700;
}

.pasarela-card-body {
  padding: 20px;
}

.pasarela-row {
  margin-bottom: 15px;
}

/* Datos destacados */
.pasarela-data {
  font-weight: bold;
  color: #0d47a1;
}

.pasarela-status {
  font-weight: bold;
  color: #ef6c00;
  /* naranja acento */
}

/* =========================================================
 ALERTAS
========================================================= */
.pasarela-alert {
  background-color: #fff3cd;
  color: #856404;
  padding: 15px;
  border-radius: 8px;
  margin-top: 10px;
  border: 1px solid #ffeeba;
  font-weight: 500;
}

/* =========================================================
 BOTONES GENERALES
========================================================= */
.pasarela-btn {
  font-size: 18px;
  padding: 12px 28px;
  background-color: #0d47a1;
  color: #fff;
  border: none;
  border-radius: 50px;
  cursor: pointer;
  font-weight: 600;
  transition: all 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.pasarela-btn:hover {
  background-color: #002171;
  transform: translateY(-2px);
}

.pasarela-btn-2 {
  font-size: 18px;
  padding: 12px 28px;
  background-color: #4d89e2ff;
  color: #fff;
  border: none;
  border-radius: 50px;
  cursor: pointer;
  font-weight: 600;
  transition: all 0.3s ease;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.pasarela-btn-2:hover {
  background-color: #0b286cff;
  transform: translateY(-2px);
}

/* =========================================================
 TABLAS
========================================================= */
.table {
  margin-top: 20px;
  border-collapse: collapse;
  width: 100%;
}

.table th,
.table td {
  padding: 14px;
  text-align: left;
  border: 1px solid #dee2e6;
}

.table th {
  background-color: #0d47a1;
  color: #fff;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 0.85rem;
}

.table tbody tr:nth-child(even) {
  background-color: #f2f4f7;
}

/* =========================================================
 PRECIO TOTAL
========================================================= */
.precio-total {
  font-size: 1.5rem;
  font-weight: 700;
  text-align: right;
  color: #0d47a1;
}

.precio-total .pasarela-data {
  font-size: 1.8rem;
  color: #2e7d32;
}

.descripcion-paquete {
  font-size: 14px;
  line-height: 1.6;
  color: #555;
  display: block;
  margin-top: 0.5rem;
}

.generar-link {
  text-align: center;


}

/* === Contenedor en tres columnas === */
#mesesContainer {
  display: grid;
  /* usamos grid */
  grid-template-columns: repeat(4, 1fr);
  /* tres columnas iguales */
  gap: 12px;
  /* espacio entre botones */
  margin-bottom: 20px;
}

/* === Botones de meses con tamaño consistente === */
#mesesContainer .btn-mes {
  width: 100%;
  /* ancho completo dentro de la columna */
  height: 60px;
  /* altura fija para todos */
  font-weight: 600;
  /* texto más grueso */
  font-size: 1rem;
  border-radius: 10px;
  box-sizing: border-box;
  display: flex;
  /* centrado vertical y horizontal */
  align-items: center;
  justify-content: center;
  background-color: #e3f2fd;
  /* color de fondo base */
  border: 2px solid #0d47a1;
  /* borde sólido profesional */
  color: #0d47a1;
  /* color de texto base */
  transition: all 0.3s ease;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
}

/* === Hover === */
#mesesContainer .btn-mes:hover {
  background-color: #0d47a1;
  color: #fff;
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.total-monto {
  text-align: right;
  font-size: 1.5rem;
  /* opcional para hacerlo más llamativo */
  font-weight: 800;
  color: #007bff !important;
  /* opcional para hacerlo más profesional */
}

.total-monto #montoTotal {

  /* color llamativo sólido */
  font-size: 1.5rem;
  font-weight: 700;
}
</style>