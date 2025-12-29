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
z
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

<a href="<?php echo base_url(); ?>Login/logout" style="
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
  " onmouseover="this.style.backgroundColor='#c9302c'; this.style.boxShadow='0 6px 12px rgba(0,0,0,0.15)';"
  onmouseout="this.style.backgroundColor='#d9534f'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.1)';">
  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400" style="margin-right:6px;"></i>
  Cerrar sesión
</a>
<a class="sidebar-brand d-flex align-items-center justify-content-center">
  <img style="max-width: 220px; max-height: 150px;" src="<?php echo base_url(); ?>_logosPortal/logo_nuevo.png"
    alt="Logo">
</a>
<div class="alert alert-danger text-center" role="alert" style="margin:10px; font-weight:600;">
  <i class="fas fa-exclamation-triangle"></i>
  Tu suscripción a <strong>TalentSafe</strong> ha expirado. Por favor realiza tu pago cuanto antes generando un link de
  pago.
  <br>Después de pagarlo, regresa aquí y confírmalo en el botón correspondiente. De esta manera tus accesos quedarán
  habilitados nuevamente.
  <br>También puedes comunicarte al <strong>(52) 3334 54 2877</strong> vía llamada o WhatsApp de <strong>L‑V de 8 am a
    6 pm</strong> para cualquier duda o aclaración.
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
        <h3 class="text-center titulo-blanco">
          <?php echo t('pasarela.subscription.plan'); ?>
        </h3>
      </div>

      <div class="card-body pasarela-card-body">

        <?php if (isset($datos_pago) && ! empty($datos_pago)): ?>
        <div class="pasarela-row">

          <p>
            <strong><?php echo t('pasarela.subscription.client_name'); ?>:</strong>
            <span class="pasarela-data">
              <?php echo htmlspecialchars($datos_pago->nombre); ?>
            </span>
          </p>

          <p>
            <strong><?php echo t('pasarela.subscription.plan'); ?>:</strong>
            <span class="pasarela-data">
              <?php echo htmlspecialchars($datos_pago->nombre_paquete); ?>
            </span>
            <span class="badge bg-success">
              $<?php echo number_format($datos_pago->precio); ?> USD
            </span>
          </p>

          <p>
            <strong><?php echo t('pasarela.subscription.description'); ?>:</strong>
            <span class="pasarela-data">
              <?php echo t(
                  $plan_key . '.description',
                  $datos_pago->descripcion ?? '',
                  $plan_vars
              ); ?>
            </span>
          </p>


          <p>
            <strong><?php echo t('pasarela.subscription.users_included'); ?>:</strong>
            <span class="pasarela-data">
              <?php echo htmlspecialchars($datos_pago->usuarios); ?>
            </span>
          </p>

          <p>
            <strong><?php echo t('pasarela.subscription.extra_users'); ?>:</strong>
            <span class="badge bg-primary">
              <?php echo htmlspecialchars($cantidad_usuarios); ?>
              <?php echo t('pasarela.subscription.users_suffix'); ?>
            </span>
            <span class="badge bg-success">
              $<?php echo number_format($cantidad_usuarios * 50, 2); ?> USD
            </span>
          </p>

          <p>
            <strong><?php echo t('pasarela.subscription.due_date'); ?>:</strong>
            <span class="pasarela-data">
              <?php echo htmlspecialchars($fecha_vencimiento); ?>
            </span>
          </p>

          <p>
            <strong><?php echo t('pasarela.subscription.status'); ?>:</strong>
            <span class="pasarela-status">
              <?php echo htmlspecialchars($estado_pago); ?>
            </span>
          </p>

        </div>

        <?php if (isset($usuarios) && ! empty($usuarios)): ?>
        <h4><?php echo t('pasarela.subscription.extra_users_title'); ?></h4>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th><?php echo t('pasarela.subscription.table.name'); ?></th>
              <th><?php echo t('pasarela.subscription.table.email'); ?></th>
              <th><?php echo t('pasarela.subscription.table.price'); ?></th>
            </tr>
          </thead>
          <tbody>

            <tr>
              <td><?php echo htmlspecialchars($datos_pago->nombre_paquete ?? ''); ?></td>
              <td>
                <span class="descripcion-paquete">
                  <?php echo t(
                    $plan_key . '.description',
                    $datos_pago->descripcion ?? '',
                    $plan_vars
                ); ?>

                </span>
              </td>

              <td>$<?php echo htmlspecialchars($datos_pago->precio ?? 0); ?> USD</td>
            </tr>

            <?php foreach ($usuarios as $usuario): ?>
            <tr>
              <td>
                <?php echo htmlspecialchars($usuario->nombre ?? '') . ' ' . htmlspecialchars($usuario->paterno ?? ''); ?>
              </td>
              <td><?php echo htmlspecialchars($usuario->correo ?? ''); ?></td>
              <td>$<?php echo number_format($usuario->cobro ?? 0, 2); ?> USD</td>
            </tr>
            <?php endforeach; ?>

          </tbody>
        </table>
        <?php endif; ?>

        <input type="hidden" id="total" value="<?php echo htmlspecialchars(number_format($cobro, 2)); ?>" />

        <?php if (htmlspecialchars($estado_pago) === 'pagado'): ?>
        <p class="precio-total">
          <strong><?php echo t('pasarela.subscription.total_price'); ?>:</strong>
          <span class="pasarela-data">
            $<?php echo $datos_pago->precio + ($cantidad_usuarios * 50); ?> USD
          </span>
        </p>
        <?php else: ?>
        <p class="precio-total">
          <strong><?php echo t('pasarela.subscription.total_price'); ?>:</strong>
          <span class="pasarela-data">
            $<?php echo number_format($cobro, 2); ?> USD
          </span>
        </p>
        <?php endif; ?>

        <?php else: ?>
        <div class="pasarela-alert">
          <?php echo t('pasarela.subscription.no_data'); ?>
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
      <h3 class="text-center titulo-blanco">
        <?php echo t('portal_pay_link_title'); ?>
      </h3>
    </div>

    <div class="card-body pasarela-card-body">
      <table id="tablaLinkPago" class="table table-bordered">
        <thead>
          <tr>
            <th><?php echo t('portal_pay_table_link_id'); ?></th>
            <th><?php echo t('portal_pay_table_link'); ?></th>
            <th><?php echo t('portal_pay_table_link_status'); ?></th>
            <th><?php echo t('portal_pay_table_created'); ?></th>
            <th><?php echo t('portal_pay_table_expires'); ?></th>
            <th><?php echo t('portal_pay_link_qr'); ?></th>
            <th><?php echo t('portal_pay_link_confirm'); ?></th>
          </tr>
        </thead>

        <tbody>
          <?php if (isset($link_pago) && ! empty($link_pago)): ?>
          <tr>
            <td><?php echo htmlspecialchars($link_pago->id); ?></td>

            <td>
              <a href="<?php echo htmlspecialchars($link_pago->payment_request_url); ?>" target="_blank"
                class="text-primary">
                <i class="bi bi-credit-card"></i>
                <?php echo t('portal_pay_link_go'); ?>
              </a>
            </td>

            <td>
              <span class="<?php echo htmlspecialchars($status_link_pago_class); ?>">
                <?php echo isset($status_link_pago_key) ? t($status_link_pago_key) : ''; ?>
              </span>
            </td>

            <td><?php echo htmlspecialchars($link_pago->created_at); ?></td>
            <td><?php echo htmlspecialchars($link_pago->expires_at); ?></td>

            <td>
              <a href="<?php echo htmlspecialchars($link_pago->qr_image_url); ?>" target="_blank" class="text-primary">
                <?php echo t('portal_pay_link_qr'); ?>
              </a>
            </td>

            <td>
              <input type="button" class="btn pasarela-btn" value="<?php echo t('portal_pay_link_confirm'); ?>"
                onclick="confirmarPago('<?php echo $link_pago->payment_request_id; ?>')">
            </td>
          </tr>
          <?php else: ?>
          <tr>
            <td colspan="7" class="text-center">
              <?php echo t('portal_pay_no_link'); ?>
            </td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Botón para generar link -->
    <div class="generar-link">
      <button class="btn pasarela-btn-2" id="btnAbrirModalPago">
        <?php echo t('portal_pay_link_generate'); ?>
      </button>
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
          <h5 class="modal-title">
            <?php echo t('pasarela.modal.title'); ?> -
            <?php echo $datos_pago->nombre_paquete ?? t('pasarela.modal.package_fallback'); ?>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Cuerpo del modal -->
        <div class="modal-body">
          <h5 class="title">
            <strong class="text-uppercase">
              <?php echo $datos_pago->nombre_paquete . ' ' . $datos_pago->precio . ' USD'; ?>
            </strong>
            <br>
            <span class="descripcion-paquete">
              <?php
                  echo t(
                      $plan_key . '.description',
                      t('pasarela.modal.package_fallback'),
                      $plan_vars
                  );
              ?>
            </span>

          </h5>

          <p><strong><?php echo t('pasarela.modal.extra_users'); ?>:</strong></p>
          <ul>
            <?php foreach ($usuarios as $usuario): ?>
            <li>
              <?php echo $usuario->nombre . ' ' . $usuario->paterno; ?>
              <?php echo ' $50 USD'; ?>
            </li>
            <?php endforeach; ?>
          </ul>

          <p><strong><?php echo t('pasarela.modal.select_months'); ?>:</strong></p>

          <div class="meses-grid" id="mesesContainer">
            <?php foreach ($meses_disponibles as $mes): ?>
            <button type="button" class="btn btn-outline-primary btn-mes" data-fecha="<?php echo $mes['fecha']; ?>">
              <?php
        echo t('months.' . $mes['month_key']) . ' ' . $mes['year'];
      ?>
            </button>
            <?php endforeach; ?>
          </div>


          <!-- Campo oculto para enviar meses seleccionados -->
          <input type="hidden" id="inputMesesSeleccionados" name="meses" value="">

          <!-- Monto total -->
          <p class="total-monto">
            <strong><?php echo t('pasarela.modal.total'); ?>:</strong>
            <span id="montoTotal">$0.00</span> USD
          </p>

        </div>

        <!-- Pie del modal -->
        <div class="modal-footer">
          <button type="button" class="btn btn-success" id="btnPagar">
            <?php echo t('pasarela.modal.generate'); ?>
          </button>
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
        <h3 class="text-center titulo-blanco">
          <?php echo t('pasarela.history.title'); ?>
        </h3>
      </div>

      <div class="card-body pasarela-card-body">
        <table id="historialPagos" class="table table-bordered">
          <thead>
            <tr>
              <th><?php echo t('pasarela.history.columns.payment_id'); ?></th>
              <th><?php echo t('pasarela.history.columns.month'); ?></th>
              <th><?php echo t('pasarela.history.columns.payment_date'); ?></th>
              <th><?php echo t('pasarela.history.columns.amount'); ?></th>
              <th><?php echo t('pasarela.history.columns.status'); ?></th>
              <th><?php echo t('pasarela.history.columns.reference'); ?></th>
            </tr>
          </thead>

          <tbody>
            <?php if (isset($historial_pagos) && ! empty($historial_pagos)): ?>
            <?php foreach ($historial_pagos as $pago): ?>
            <tr>

              <!-- 1️⃣ PAYMENT ID -->
              <td>
                <?php echo htmlspecialchars($pago->payment_request_id ?? '', ENT_QUOTES, 'UTF-8'); ?>
              </td>

              <!-- 2️⃣ MONTH -->
              <td>
                <?php
                    if (! empty($pago->mes)) {
                        $fecha = DateTime::createFromFormat('Y-m-d', $pago->mes);
                        if ($fecha) {
                            $meses = [
                                1  => t('months.january'),
                                2  => t('months.february'),
                                3  => t('months.march'),
                                4  => t('months.april'),
                                5  => t('months.may'),
                                6  => t('months.june'),
                                7  => t('months.july'),
                                8  => t('months.august'),
                                9  => t('months.september'),
                                10 => t('months.october'),
                                11 => t('months.november'),
                                12 => t('months.december'),
                            ];
                            echo $meses[(int) $fecha->format('n')] . ' ' . $fecha->format('Y');
                        } else {
                            echo '-';
                        }
                    } else {
                        echo '-';
                    }
                ?>
              </td>

              <!-- 3️⃣ PAYMENT DATE -->
              <td>
                <?php
                    echo ! empty($pago->fecha_pago)
                        ? htmlspecialchars($pago->fecha_pago, ENT_QUOTES, 'UTF-8')
                        : '-';
                ?>
              </td>

              <!-- 4️⃣ AMOUNT -->
              <td>
                <?php echo '$' . number_format($pago->monto ?? 0, 2) . ' USD'; ?>
              </td>

              <!-- 5️⃣ STATUS -->
              <td>
                <?php if (! empty($pago->link_status)): ?>
                <a href="<?php echo htmlspecialchars($pago->link_status); ?>" target="_blank">
                  <?php echo t('pasarela.history.view_status'); ?>
                </a>
                <?php else: ?>
                <button type="button" class="btn btn-sm btn-info verStatusLocal"
                  data-fecha="<?php echo htmlspecialchars($pago->estado ?? ''); ?>">
                  <?php echo t('pasarela.history.view_status'); ?>
                </button>
                <?php endif; ?>
              </td>

              <!-- 6️⃣ REFERENCE -->
              <td>
                <?php echo htmlspecialchars($pago->referencia ?? '-', ENT_QUOTES, 'UTF-8'); ?>
              </td>

            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">
                <?php echo t('pasarela.history.empty'); ?>
              </td>
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

        // Mapeo de estados a texto amigable (MULTILENGUAJE)
        switch (response.status) {
          case 'CHECKOUT_CREATED':
            statusMessage = "<?php echo t('portal_pay_status_created'); ?>";
            break;
          case 'CHECKOUT_PENDING':
            statusMessage = "<?php echo t('portal_pay_status_pending_text'); ?>";
            break;
          case 'CHECKOUT_CANCELLED':
            statusMessage = "<?php echo t('portal_pay_status_cancelled'); ?>";
            break;
          case 'CHECKOUT_EXPIRED':
            statusMessage = "<?php echo t('portal_pay_status_expired_text'); ?>";
            break;
          case 'CHECKOUT_COMPLETED':
            statusMessage = "<?php echo t('portal_pay_status_paid_text'); ?>";
            break;
          default:
            statusMessage = "<?php echo t('portal_pay_swal_unknown_status'); ?>";
            break;
        }

        // Armamos el contenido que se mostrará en SweetAlert
        let mensaje = `
            <strong><?php echo t('portal_pay_status'); ?>:</strong> ${statusMessage}<br>
            <strong><?php echo t('portal_pay_history_amount'); ?>:</strong> ${response.amount} ${response.currency}<br>
            <strong><?php echo t('portal_pay_plan_description'); ?>:</strong> ${response.purchase_description}<br>
            <strong>URL:</strong>
            <a href="${response.payment_request_url}" target="_blank">
              <?php echo t('portal_pay_link_go'); ?>
            </a><br>
          `;

        // Si hay acciones pendientes, las añadimos
        if (response.pending_action) {
          mensaje += `
              <strong><?php echo t('portal_pay_pending_action'); ?>:</strong> ${response.pending_action.type}<br>
              <strong><?php echo t('portal_pay_history_reference'); ?>:</strong> ${response.pending_action.reference}<br>
            `;
        }

        // Mostrar información con SweetAlert
        Swal.fire({
          title: "<?php echo t('portal_pay_swal_payment_info'); ?>",
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
        Swal.fire(
          "<?php echo t('portal_pay_swal_error'); ?>",
          "<?php echo t('portal_pay_swal_request_error'); ?>",
          'error'
        );
      }
    },
    error: function(xhr, status, error) {
      console.error("Hubo un error en la solicitud AJAX:", error);
      Swal.fire(
        "<?php echo t('portal_pay_swal_error'); ?>",
        "<?php echo t('portal_pay_swal_request_error'); ?>",
        'error'
      );
    }
  });
}

// =========================================================
// 🔹 DOCUMENT READY: Eventos y lógica al cargar la página
// =========================================================
document.addEventListener('DOMContentLoaded', function() {

  // Precio base mensual desde PHP
  const precioMensual = <?php echo $datos_pago->precio ?? 999; ?>;
  const cobroProporcional = <?php echo $cobro ?? 999; ?>;
  const cobroMensualFijo = <?php echo $cobro_mes ?? 999; ?>;
  const mesActual = "<?php echo date('Y-m') ?>";

  // =========================================================
  // ✅ Selección de meses (botones dinámicos)
  // =========================================================
  let mesesSeleccionados = [];

  $(document).on('click', '.btn-mes', function() {
    const fecha = $(this).data('fecha');
    const botones = $('.btn-mes');
    const indexClic = botones.index(this);

    if (mesesSeleccionados.includes(fecha)) {
      botones.each(function(i, btn) {
        const f = $(btn).data('fecha');
        if (i >= indexClic && mesesSeleccionados.includes(f)) {
          mesesSeleccionados = mesesSeleccionados.filter(m => m !== f);
          $(btn).removeClass('btn-primary').addClass('btn-outline-primary');
        }
      });
    } else {
      botones.each(function(i, btn) {
        const f = $(btn).data('fecha');
        if (i <= indexClic && !mesesSeleccionados.includes(f)) {
          mesesSeleccionados.push(f);
          $(btn).removeClass('btn-outline-primary').addClass('btn-primary');
        }
      });
    }

    $('#inputMesesSeleccionados').val(mesesSeleccionados.join(','));
    calcularMonto();
  });

  // =========================================================
  // ✅ Calcular monto total
  // =========================================================
  function calcularMonto() {
    let total = 0;

    mesesSeleccionados.forEach(function(fechaCompleta) {
      const soloMes = fechaCompleta.substring(0, 7);
      total += (soloMes === mesActual) ?
        cobroProporcional :
        cobroMensualFijo;
    });

    $('#montoTotal').text(`$${total.toFixed(2)}`);
  }

  // =========================================================
  // ✅ Abrir modal para generar pago
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
      Swal.fire(
        "<?php echo t('portal_pay_swal_error'); ?>",
        "<?php echo t('portal_pay_swal_select_month'); ?>",
        'error'
      );
      return;
    }

    const montoTotalTexto = document.getElementById('montoTotal').textContent;
    const montoTotalNumero = parseFloat(
      montoTotalTexto.replace(/[^0-9.]+/g, '')
    );

    const description = "<?php echo t('portal_pay_payment_details'); ?>";

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
          Swal.fire(
            "<?php echo t('portal_pay_swal_success'); ?>",
            "<?php echo t('portal_pay_swal_link_success'); ?>",
            'success'
          ).then(() => location.reload());
        } else {
          Swal.fire(
            "<?php echo t('portal_pay_swal_error'); ?>",
            "<?php echo t('portal_pay_swal_link_error'); ?>",
            'error'
          );
        }
      },
      error: function() {
        Swal.fire(
          "<?php echo t('portal_pay_swal_error'); ?>",
          "<?php echo t('portal_pay_swal_request_error'); ?>",
          'error'
        );
      }
    });

    const modal = bootstrap.Modal.getInstance(document.getElementById('modalGenerarPago'));
    modal.hide();
  });

  // =========================================================
  // ✅ Inicializar DataTables
  // =========================================================
  $.fn.dataTable.ext.errMode = 'throw';

  if ($.fn.DataTable.isDataTable('#historialPagos')) {
    $('#historialPagos').DataTable().destroy();
  }
  if ($.fn.DataTable.isDataTable('#tablaLinkPago')) {
    $('#tablaLinkPago').DataTable().destroy();
  }

  // =========================================================
  // ✅ Ver status local
  // =========================================================
  $(document).on('click', '.verStatusLocal', function() {
    const estado = $(this).data('fecha');

    if (estado === 'pagado') {
      Swal.fire({
        icon: 'success',
        title: "<?php echo t('portal_pay_status_paid'); ?>",
        text: "<?php echo t('portal_pay_status_paid_text'); ?>",
        confirmButtonText: 'OK'
      });
    } else if (estado === 'pendiente') {
      Swal.fire({
        icon: 'warning',
        title: "<?php echo t('portal_pay_status_pending'); ?>",
        text: "<?php echo t('portal_pay_status_pending_text'); ?>",
        confirmButtonText: 'OK'
      });
    } else if (estado === 'expirado') {
      Swal.fire({
        icon: 'error',
        title: "<?php echo t('portal_pay_status_expired'); ?>",
        text: "<?php echo t('portal_pay_status_expired_text'); ?>",
        confirmButtonText: 'OK'
      });
    } else {
      Swal.fire({
        icon: 'info',
        title: "<?php echo t('portal_pay_swal_unknown_status'); ?>",
        text: "<?php echo t('portal_pay_swal_unknown_status'); ?>",
        confirmButtonText: 'OK'
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