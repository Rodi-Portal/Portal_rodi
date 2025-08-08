<!DOCTYPE html>
<html lang="es">

<head>
  <!-- Meta Tags -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Title -->
  <title>Panel de Control | RODI</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?php echo base_url(); ?>img/favicon.jpg" sizes="64x64">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Font Awesome -->
  <link href="<?php echo base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/fdf6fee49b.js" crossorigin="anonymous"></script>

  <!-- Bootstrap 4.5.2 -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- Bootstrap Select -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">

  <!-- Animaciones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css">
  <?php echo link_tag("css/sb-admin-2.min.css"); ?>

  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>js/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JS (bundle incluye Popper.js) -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

  <!-- jQuery Easing -->
  <script src="<?php echo base_url(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Select2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.all.min.js"></script>

  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

  <!-- InputMask -->
  <script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.js"></script>
  <script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.extensions.js"></script>
</head>





<body id="page-top">
  <!-- JavaScript -->
  <?php
      echo $modals;
      $CI           = &get_instance();
      $id_cliente   = $CI->session->userdata('idcliente');
      $logo         = $CI->session->userdata('logo');
      $aviso_actual = $CI->session->userdata('aviso');
      $archivo      = $aviso_actual ? $aviso_actual : 'AV_TL_V1.pdf';
  ?>

  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <?php if ($logo == null) {
              $logo = 'logo_nuevo.png';
      }?>
      <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <img style="max-width: 220px; max-height: 150px; background: white;"
          src="<?php echo base_url(); ?>_logosPortal/<?php echo $logo ?>" alt="Logo">
      </a>

      <hr class="sidebar-divider my-0">
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuario"
          aria-expanded="true" aria-controls="collapseUsuario">
          <div class="d-flex align-items-center">
            <!-- Columna de la imagen -->
            <div>
              <img class="img-profile rounded-circle" src="<?php echo base_url(); ?>img/user.png"
                style="width: 40px; height: 40px;">
            </div>

            <!-- Columna del texto -->
            <div class="ml-3">
              <span class="d-none d-lg-inline text-white font-weight-bold" style="font-size: 14px;">
                <?php echo $this->session->userdata('nombre') . " " . $this->session->userdata('paterno'); ?>
              </span>
            </div>
          </div>
        </a>

        <div id="collapseUsuario" class="collapse" aria-labelledby="headingUser" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>Login/logout">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Cerrar sesión
            </a>
          </div>
        </div>
      </li>
      <!-- Divider -->


      <!-- Manual de Usuario -->

      <li class="nav-item">
        <!-- Ajusta la ruta del archivo según corresponda -->
        <a class="nav-link" href="<?php echo base_url('_manuales/guia_usuario_v1.pdf'); ?>" target="_blank">
          <i class="fas fa-book"></i>
          <span>User guide</span>
        </a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Divider with Text -->
      <li class="nav-item">
        <a class="nav-link" id="recruitment-btn" href="javascript:void(0);"
          onclick="loadSection('seccion-recruitment', '<?php echo site_url('Cliente_General/descripcionesCliente/1'); ?>')">
          <i class="fas fa-users"></i> Reclutamiento
        </a>


      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link" id="pre-employment-btn" href="javascript:void(0);"
          onclick="loadSection('seccion-pre-employment', '<?php echo site_url('Cliente_General/descripcionesCliente/2'); ?>')">
          <i class="fas fa-user-clock"></i> Preempleo
        </a>

      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link" id="employees-btn" href="javascript:void(0);"
          onclick="loadSection('seccion-employees', '<?php echo site_url('Cliente_General/descripcionesCliente/3'); ?>')">
          <i class="fas fa-user-check"></i> Empleados
        </a>

      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link" id="former-employees-btn" href="javascript:void(0);"
          onclick="loadSection('seccion-former-employees', '<?php echo site_url('Cliente_General/descripcionesCliente/4'); ?>')">
          <i class="fas fa-user-times"></i> Exempleadoss
        </a>

      </li>

      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <ul class="navbar-nav d-flex flex-row w-100">

            <!-- Contenedor para los botones -->
            <li class="nav-item custom-menu" style="flex: 1;">
              <div class="button-container">
                <a id="recruitment-btn" href="javascript:void(0);"
                  onclick="loadSection('seccion-recruitment', '<?php echo site_url('Cliente_General/descripcionesCliente/1'); ?>')"
                  class="btn custom-btn recruitment-btn">
                  <i class="fas fa-users"></i> <!-- Icono de FontAwesome para Recruitment -->
                  Reclutamiento
                </a>
                <a id="pre-employment-btn" href="javascript:void(0);"
                  onclick="loadSection('seccion-pre-employment', '<?php echo site_url('Cliente_General/descripcionesCliente/2'); ?>')"
                  class="btn custom-btn pre-employment-btn">
                  <i class="fas fa-user-clock"></i> <!-- Icono de FontAwesome para Pre-employment -->
                  Preempleo
                </a>
                <a id="employment-btn" href="javascript:void(0);"
                  onclick="loadSection('seccion-employees', '<?php echo site_url('Cliente_General/descripcionesCliente/3'); ?>')"
                  class="btn custom-btn employment-btn">
                  <i class="fas fa-briefcase"></i> <!-- Icono de FontAwesome para Employee -->
                  Empleados
                </a>
                <a id="former-employees-btn" href="javascript:void(0);"
                  onclick="loadSection('seccion-former-employees', '<?php echo site_url('Cliente_General/descripcionesCliente/4'); ?>')"
                  class="btn custom-btn former-employment-btn">
                  <i class="fas fa-user-times"></i> <!-- Icono de FontAwesome para Former employee -->
                  Exempleados
                </a>
                <a id="communication-btn" href="javascript:void(0);"
                  onclick="loadSection('seccion-communication', '<?php echo site_url('Cliente_General/descripcionesCliente/5'); ?>')"
                  class="btn custom-btn former-actividades-btn">
                  <div class="module-label">Módulo</div>
                  <div class="btn-content">
                    <i class="fas fa-calendar-alt"></i>
                    Comunicación
                  </div>
                </a>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1" id="iconoNotificaciones">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <?php if (isset($contadorNotificaciones)) {
                    $displayContador = ($contadorNotificaciones > 0) ? 'initial' : 'none'; ?>
                <span class="badge badge-danger badge-counter" id="contadorNotificaciones"
                  style="display:                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php echo $displayContador; ?>;"><?php echo $contadorNotificaciones ?></span>
                <?php
                }?>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Notificaciones</h6>
                <div id="contenedorNotificaciones" style="height: 40rem; overflow-y: auto;"></div>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1" id="iconoNotificaciones">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw" style="color:rgb(255, 42, 0);"></i>
                <?php if (isset($contadorNotificaciones)) {
                    $displayContador = ($contadorNotificaciones > 0) ? 'initial' : 'none'; ?>
                <span class="badge badge-danger badge-counter" id="contadorNotificaciones"
                  style="display:                                                                                                                                                                        <?php echo $displayContador; ?>;"><?php echo $contadorNotificaciones ?></span>
                <?php
                }?>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Notificaciones</h6>
                <div id="contenedorNotificaciones" style="height: 40rem; overflow-y: auto; color: red"></div>
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1" id="iconoLlave">
              <a id="btnAbrirProveedores" class="nav-link icono-dorado text-center" href="#" role="button"
                title="Proveedores destacados"
                style="line-height: 1.2; display: flex; flex-direction: column; align-items: center; padding: 0; margin: 0;">

                <div style="font-size: 9px; font-weight: bold; color: #000;">Proveedores</div>
                <i class="fas fa-key fa-fw icono-dorado" style="font-size: 20px;"></i>
                <div style="font-size: 9px; font-weight: bold; color: #000;">Destacados</div>
              </a>
            </li>


            <div class="topbar-divider d-none d-sm-block"></div>
          </ul>
        </nav>

        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <ul class="navbar-nav d-flex flex-row w-100">
            <li class="nav-item custom-menu" style="flex: 1;">
              <a class="btn custom-btn" href="javascript:void(0)" data-section="panel-inicio"
                onclick="showSection('panel-inicio')">
                <i class="fas fa-list-ol"></i>
                <span class="d-none d-md-inline">Requisiciones</span>
              </a>

              <a class="btn custom-btn" href="javascript:void(0)" data-section="seccion-bgv"
                onclick="showSection('seccion-bgv')">
                <i class="fas fa-chart-line"></i>
                <span class="d-none d-md-inline">Candidatos Pruebas</span>
              </a>
            </li>
            <!--//TODO: boton para en un futuro poder ver las requisiciones finalizadas actualmente sin funcionamiento -->


          </ul>
        </nav>
        <!-- Modal Principal: Nuestros Proveedores Destacados -->
        <div class="modal fade" id="modalKey" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header bg-blue text-white fw-bold">
                <h5 class="modal-title" id="exampleModalLabel" style="color: white !important; font-size: 1.8rem;">
                  Nuestros Proveedores Destacados
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal"
                  aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <div class="row" id="contenedor-proveedores">
                  <!-- Aquí se insertarán los proveedores destacados dinámicamente con JavaScript -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal Global Reutilizable para Contacto -->
        <div class="modal fade" id="modalContactoGlobal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="formContacto" method="post">
                <div class="modal-header" id="modalHeaderGlobal" style="background-color: #000;">
                  <img src="" alt="" id="modalImagenGlobal" style="max-height: 50px; margin-right: 10px;">
                  <h5 class="modal-title text-white" id="modalTituloGlobal">Contacto</h5>
                  <button type="button" class="btn-close btn-close-white" data-dismiss="modal"
                    aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                  <input type="hidden" name="proveedor_id" id="inputProveedorId">

                  <div class="form-group">
                    <label>Nombre completo</label>
                    <input type="text" class="form-control" name="nombre" required>
                  </div>

                  <div class="form-group">
                    <label>Empresa / Organización</label>
                    <input type="text" class="form-control" name="empresa">
                  </div>

                  <div class="form-group">
                    <label>Correo</label>
                    <input type="email" class="form-control" name="correo" required>
                  </div>

                  <div class="form-group">
                    <label>Teléfono con lada</label>
                    <input type="tel" class="form-control" name="telefono">
                  </div>

                  <div class="form-group">
                    <label>Descripción de la solicitud</label>
                    <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div id="panel-agregar-candidato" class="dynamic-section" style="display: none;"></div>
        <div id="seccion-bgv" class="dynamic-section" style="display: none;"></div>
        <div id="panel-inicio" class="dynamic-section"></div>
        <div id="panel-historial" class="dynamic-section" style="display: none;"></div>
        <div id="seccion-recruitment" class="dynamic-section"></div>
        <div id="seccion-pre-employment" class="dynamic-section"></div>
        <div id="seccion-employees" class="dynamic-section"></div>
        <div id="seccion-former-employees" class="dynamic-section"></div>
        <div id="seccion-communication" class="dynamic-section"></div>

        <script>
        let base_url = '<?php echo base_url() ?>'
        let url_listado = '<?php echo base_url('Cliente/get_candidates'); ?>';
        let url_psicometria = '<?php echo base_url(); ?>_psicometria/';
        let url_clinico = '<?php echo base_url(); ?>_clinico/';
        let idioma = '<?php echo $this->session->userdata('ingles') ?>';
        let id_cliente = '<?php echo $this->session->userdata('idcliente') ?>';
        let url_paises = '<?php echo base_url("Funciones/getPaises"); ?>'
        let url_subclientes = '<?php echo base_url("Subcliente/get_all"); ?>'
        let url_procesos = '<?php echo base_url("Candidato_Seccion/get_procesos_cliente"); ?>'
        let url_dopings = '<?php echo base_url('Doping/get_by_cliente'); ?>'
        let url_registro = '<?php echo base_url('Cliente_General/registrar'); ?>'
        let url_puestos = '<?php echo base_url('Funciones/getPuestos'); ?>'
        let url_archivos = '<?php echo base_url('Documentacion/get_archivos'); ?>'
        let url_tipos_archivo = '<?php echo base_url('Documentacion/get_tipos_documento'); ?>'
        let urlGuardarComentario = "<?php echo base_url('Reclutamiento/guardarHistorialBolsaTrabajo'); ?>";

        if (localStorage.getItem('candidatoRegistrado') == 1) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Candidato registrado correctamente',
            confirmButtonText: 'Aceptar'
          })
          localStorage.removeItem('candidatoRegistrado');
        }
        $(document).on('click', '.open-contacto', function(e) {
          e.preventDefault();

          const id = $(this).data('id');
          const nombre = $(this).data('nombre');
          const color = $(this).data('color') || '#333';
          const imagen = $(this).data('imagen') || '<?php echo base_url("img/portal_icon.png"); ?>';

          const modal = $('#modalContactoGlobal');

          // Asignar valores en el modal
          modal.find('#modalHeaderGlobal').css('background-color', color);
          modal.find('#modalTituloGlobal').text('Contacto ' + nombre);
          modal.find('#modalImagenGlobal').attr('src', imagen).attr('alt', nombre);
          modal.find('#inputProveedorId').val(id);

          modal.modal('show');
        });

        $('#btnAbrirProveedores').on('click', function(e) {
          e.preventDefault();

          // Spinner o loader
          $('#modalKey .modal-body').html('<div class="text-center py-5">Cargando proveedores...</div>');

          // AJAX para cargar proveedores
          $.ajax({
            url: '<?php echo base_url("Proveedor/destacados"); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
              let html = '<div class="row">';

              data.forEach(function(prov) {
                const color = prov.color || '#333';
                const imagen = prov.imagen || '<?php echo base_url("img/portal_icon.png"); ?>';

                // Botón sitio web
                const btnSitio = prov.url1 ?
                  `<a href="${prov.url1}" target="_blank" class="btn btn-link text-primary" title="Sitio web">
            <i class="fas fa-globe fa-lg"></i>
          </a>` : '';

                // Botón WhatsApp
                const btnWhats = prov.url2 ?
                  `<a href="${prov.url2}" target="_blank" class="btn btn-link text-success" title="WhatsApp">
            <i class="fab fa-whatsapp fa-lg"></i>
          </a>` : '';

                // Botón contacto (teléfono o correo)
                let btnContacto = '';
                if ((prov.telefono && prov.telefono.length > 0) || (prov.correo && prov.correo.length >
                    0)) {
                  btnContacto = `
                <button class="btn btn-link text-info open-contacto"
                  data-id="${prov.id}"
                  data-nombre="${prov.nombre}"
                  data-color="${color}"
                  data-imagen="${imagen}"
                  title="Formulario de Contacto">
                  <i class="fas fa-envelope fa-lg"></i>
                </button>`;
                }

                html += `
          <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card shadow border-0 h-100">
              <div class="card-header text-white text-center fw-bold" style="background-color:${color}; font-size: 1.8rem;">
                ${prov.nombre.toUpperCase()}
              </div>

              <div class="card-body text-center">
                <img src="${imagen}" alt="${prov.nombre}" class="img-fluid my-3" style="max-height: 60px;">
                <p class="mb-1"><strong>${prov.descripcion1}</strong></p>
                <p class="mb-2 text-muted">${prov.descripcion}</p>
              </div>

              <div class="card-footer d-flex justify-content-center gap-3">
                ${btnContacto}
                ${btnSitio}
                ${btnWhats}
              </div>
            </div>
          </div>`;
              });

              html += '</div>';
              $('#modalKey .modal-body').html(html);
              $('#modalKey').modal('show');
            },
            error: function() {
              $('#modalKey .modal-body').html(
                '<div class="text-danger text-center py-5">Error al cargar proveedores.</div>');
              $('#modalKey').modal('show');
            }
          });
        });

        $(document).ready(function() {
          $('#formContacto').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const btn = form.find('button[type="submit"]');
            btn.prop('disabled', true).text('Enviando...');

            $.ajax({
              url: '<?php echo base_url("Proveedor/enviar"); ?>',
              method: 'POST',
              data: form.serialize(),
              dataType: 'json',
              success: function(res) {
                if (res.status === 'success') {
                  Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: res.message,
                    confirmButtonText: 'Aceptar'
                  });

                  form[0].reset();
                } else if (res.status === 'validation_error') {
                  let errores = '';
                  for (let campo in res.errors) {
                    errores += `• ${res.errors[campo]}\n`;
                  }

                  Swal.fire({
                    icon: 'warning',
                    title: 'Faltan datos requeridos',
                    text: errores,
                    confirmButtonText: 'Corregir'
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error inesperado al enviar el formulario.',
                  });
                }
              },
              error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Fallo en el servidor',
                  text: 'No se pudo enviar. Verifica tu conexión e intenta de nuevo.',
                });
              },
              complete: function() {
                btn.prop('disabled', false).text('Enviar');
              }
            });
          });

        });

        function openHistory() {
          //$('#lista_candidatos').DataTable().destroy();
          getDatatable();
          $('#panel-agregar-candidato').css('display', 'none')
          $('#panel-inicio').css('display', 'none')
          $('#panel-historial').css('display', 'block')
        }

        function getDatatable() {
          if ($.fn.DataTable.isDataTable('#lista_candidatos')) {
            $('#lista_candidatos').DataTable().destroy();
          }

          $('#lista_candidatos').DataTable({
              "processing": false,
              "serverSide": false,
              "order": [],
              "ajax": {
                url: url_listado,
                type: 'POST'
              },
              "columns": [{
                  title: '#',
                  data: 'id',
                },
                {
                  title: 'Candidato',
                  data: 'candidato',
                  mRender: function(data, type, full) {
                    let subcliente = (full.subcliente !== null) ? '<br><small>Subcliente/Proveedor: ' + full
                      .subcliente + '</small>' : ''
                    let puesto = (full.puesto !== null && full.puesto !== '') ? '<br><small>Puesto: ' + full
                      .puesto +
                      '</small>' : ''
                    let curp = (full.curp !== null && full.curp !== '') ? '<br><small>CURP: ' + full.curp +
                      '</small>' :
                      ''
                    let nss = (full.nss !== null && full.nss !== '') ? '<br><small>NSS: ' + full.nss +
                      '</small>' : ''
                    let centro_costo = (full.centro_costo !== null && full.centro_costo !== '') ?
                      '<br><small>Centro de costo: ' + full.centro_costo + '</small>' : ''
                    let candidato = '<b>' + data + '</b>' + subcliente + puesto + curp + nss + centro_costo
                    return candidato
                  }
                },
                {
                  title: 'Proyecto',
                  data: 'puesto',
                  mRender: function(data, type, full) {
                    let observaciones = (full.puesto !== null && full.puesto !== '') ?
                      '<div class="text-center">' +
                      full.puesto + '</div>' : '<div class="text-center">Solo examen(es)</div>'
                    return observaciones
                  }
                },
                {
                  title: 'Fechas',
                  data: 'fecha_inicio',
                  mRender: function(data, type, full) {
                    let fechaInicio = (full.fecha_inicio !== null) ? convert_date_to_text(full.fecha_inicio,
                        idioma) :
                      'No registrado'
                    let fechas = '<div><b>Alta:</b> ' + convert_date_to_text(full.fecha_alta, idioma) +
                      '<br><b>Inicio:</b> ' + fechaInicio + '</div>'
                    return fechas
                  }
                },
                {
                  title: 'Acciones',
                  data: 'id',
                  mRender: function(data, type, full) {
                    let acciones =
                      '<div class="text-center"><div class="btn-group dropstart"><button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button><ul class="dropdown-menu"><li><a href="javascript:void(0)" data-toggle="tooltip" title="Progress messages" onclick="viewMessages(' +
                      data + ',' + idioma +
                      ')" class="dropdown-item"><i class="fas fa-comment-dots"></i>                                                                                                                                                                                                                                                                                                                                                                                                                                <?php echo $translations['proceso_accion_ver_comentarios'] ?> </a></li><li><a href="javascript:void(0)" data-toggle="tooltip" title="Files" onclick="viewFiles(' +
                      data +
                      ')" class="dropdown-item"><i class="fas fa-folder"></i><?php echo $translations['proceso_accion_archivos'] ?></a></li></ul></div></div>'
                    return acciones
                  }
                },
                {
                  title: 'DrugTest: ',
                  data: 'id',
                  mRender: function(data, type, full) {
                    let doping = '';
                    if (full.examenDoping !== null) {
                      if (full.doping_hecho == 1) {
                        if (full.fecha_resultado !== null) {
                          let colorResultado = (full.resultado_doping == 1) ? 'fondo-rojo' : 'fondo-verde'
                          doping = '<div class="m-auto" style="text-align:center"><small class="p-1"><b>' + full
                            .examenDoping +
                            '</b></small><br><a href="<?php echo site_url('Doping/createPDF?id=') ?>' +
                            full.idDoping +
                            '" data-toggle="tooltip" title="Download result" class="fa-tooltip icono_datatable ' +
                            $colorResultado + '"><i class="fas fa-file-pdf"></i></a></div>'
                        } else {
                          doping = '<div class="m-auto" style="text-align:center"><small><b>' + full
                            .examenDoping +
                            '</b></small><br>Waiting for results</div>'
                        }
                      } else {
                        doping = '<div class="m-auto" style="text-align:center"><small><b>' + full.examenDoping +
                          '</b></small><br>Pending</div>'
                      }
                    } else {
                      doping = '<div class="m-auto" style="text-align:center">NA</div>'
                    }

                    return doping
                  }
                },
                {
                  title: 'Examen Médico',
                  data: 'id',
                  mRender: function(data, type, full) {
                    let medico = '';
                    if (full.medico == 1) {
                      if (full.idMedico !== null) {
                        if (full.archivo_examen_medico !== null && full.conclusionMedica === null) {
                          medico = '<div class="m-auto" style="text-align:center"><a href="' + url_clinico + full
                            .archivo_examen_medico +
                            '" target="_blank" data-toggle="tooltip" title="Descargar" class="fa-tooltip icono_datatable fondo-azul-claro"><i class="fas fa-file-medical"></i></a></div>';
                        }
                        if (full.archivo_examen_medico === null && full.conclusionMedica !== null) {
                          medico =
                            '<div class="m-auto" style="text-align:center"><a href="<?php echo site_url('Medico/crearPDF?id=') ?>' +
                            full.idMedico +
                            '" data-toggle="tooltip" title="Download result" class="fa-tooltip icono_datatable fondo-azul-claro"><i class="fas fa-file-pdf"></i></a></div>';
                        }
                        if (full.archivo_examen_medico === null && full.conclusionMedica === null) {
                          medico = '<div class="m-auto" style="text-align:center">Pendiente</div>';
                        }
                      } else {
                        medico = '<div class="m-auto" style="text-align:center">Pendiente</div>';
                      }
                    } else {
                      medico = '<div class="m-auto" style="text-align:center">NA</div>';
                    }

                    return medico
                  }
                },
                {
                  title: 'Examen Psicométrico',
                  data: 'id',
                  mRender: function(data, type, full) {
                    let psicometrico = '';
                    if (full.psicometrico == 1) {
                      if (full.idPsicometrio !== null && full.psicometria !== null) {
                        psicometrico = '<div class="m-auto" style="text-align:center"><a href="' +
                          url_psicometria +
                          full.psicometria +
                          '" target="_blank" data-toggle="tooltip" title="Download result" class="fa-tooltip icono_datatable fondo-morado"><i class="fas fa-file-powerpoint text-white"></i></a></div>';
                      } else {
                        psicometrico = '<div class="m-auto" style="text-align:center">Pending</div>';
                      }
                    } else {
                      psicometrico = '<div class="m-auto" style="text-align:center">NA</div>';
                    }

                    return psicometrico
                  }
                },

              ],
              "columnDefs": [{
                "targets": [4], // Índices de las columnas a ocultar en pantallas pequeñas
                "visible": false // Ocultar columnas en pantallas pequeñas
              }],
              "initComplete": function(settings, json) {
                // Añadir la clase hide-on-small a las columnas especificadas
                var api = this.api();
                $(api.column(4).header()).addClass('hide-on-small');
              }




            })
            .on("processing.dt", function(e, settings, processing) {
              if (processing) {
                $('.loader').css('display', 'block');
              } else {
                $('.loader').css('display', 'none');
              }
            });
        }
        // escuchador  para   comentarios
        function descargarCV() {}

        function verHistorial(id, nombre) {
          $('#div_historial_aspirante').empty();
          $.ajax({
            url: '<?php echo base_url('Reclutamiento/getHistorialAspirante'); ?>',
            type: 'post',
            data: {
              'id': id,
              'tipo_id': 'aspirante'
            },
            success: function(res) {
              var salida = '<table class="table table-striped" style="font-size: 14px; width: 100%;">';
              salida += '<thead><tr style="background: gray; color: white;">';
              salida += '<th>Fecha</th>';
              salida += '<th>Estatus</th>';
              salida += '<th>Comentario / Descripción </th>';
              salida += '</tr></thead><tbody>';

              if (res != 0) {
                var dato = JSON.parse(res);
                for (var i = 0; i < dato.length; i++) {
                  var aux = dato[i]['creacion'].split(' ');
                  var f = aux[0].split('-');
                  var fecha = f[2] + '/' + f[1] + '/' + f[0];
                  salida += '<tr>';
                  salida += '<td>' + fecha + '</td>';
                  salida += '<td>' + dato[i]['accion'] + '</td>';
                  salida += '<td>' + dato[i]['descripcion'] + '</td>';
                  salida += '</tr>';
                }
              } else {
                salida += '<tr>';
                salida += '<td colspan="3" class="text-center"><h5>Sin movimientos</h5></td>';
                salida += '</tr>';
              }
              salida += '</tbody></table>';

              $('#div_historial_aspirante').html(salida);
              $("#historialModal").modal('show');

              // Ocultar el control de "Show entries" en el modal de historial
              $('#historialModal .dataTables_wrapper .dataTables_length').hide();

              $('#btnCerrarPasos').click(function() {
                $('#historialModal').modal('hide');
              });
            }
          });
        }

        function verHistorialMovimientos(nombreCompleto, id) {
          $("#nombre_aspirante").text(nombreCompleto);
          $('#div_historial_comentario').empty();
          $('#btnComentario').attr('onclick', 'guardarComentario(' + id + ')');
          $.ajax({
            url: '<?php echo base_url('Reclutamiento/getHistorialBolsaTrabajo'); ?>',
            type: 'post',
            data: {
              'id': id,
              'tipo_id': 'bolsa'
            },
            success: function(res) {
              var salida = '<table class="table table-striped" style="font-size: 14px; width: 100%;">';
              salida += '<thead><tr style="background: gray; color: white;">';
              salida += '<th>Fecha</th>';
              salida += '<th>Usuario</th>';
              salida += '<th>Comentario / Estatus</th>';
              salida += '</tr></thead><tbody>';

              if (res != 0) {
                var dato = JSON.parse(res);
                for (var i = 0; i < dato.length; i++) {
                  var aux = dato[i]['creacion'].split(' ');
                  var f = aux[0].split('-');
                  var fecha = f[2] + '/' + f[1] + '/' + f[0];
                  salida += '<tr>';
                  salida += '<td>' + fecha + '</td>';
                  salida += '<td>' + dato[i]['usuario'] + '</td>';
                  salida += '<td>' + dato[i]['comentario'] + '</td>';
                  salida += '</tr>';
                }
              } else {
                salida += '<tr>';
                salida += '<td colspan="3" class="text-center"><h5>Sin comentarios</h5></td>';
                salida += '</tr>';
              }
              salida += '</tbody></table>';

              $('#comentario_bolsa').val('');
              $('#div_historial_comentario').html(salida);
              $('#historialComentariosModal').modal('show');

              // Ocultar el control de "Show entries" en el modal de historial de comentarios
              $('#historialComentariosModal .dataTables_wrapper .dataTables_length').hide();

              $('#historialComentariosModal .btn-secondary').click(function() {
                $('#historialComentariosModal').modal('hide');
              });
            },
            error: function(xhr, status, error) {
              console.error(error);
            }
          });
        }
        $(document).on('click', '.btnDocs', function() {
          const idBolsa = $(this).data('id_ra');
          //console.log("🚀 ~ idBolsa:", idBolsa)
          const tbody = $('#tablaArchivos tbody').empty();
          $('#msgSinDocs').hide();

          $.ajax({
            url: `<?php echo base_url('Documentos_Aspirantes/lista'); ?>/${idBolsa}`,
            dataType: 'json',
            success: function(docs) {

              if (docs.length === 0) { // sin documentos
                $('#msgSinDocs').show();
              } else { // llena tabla
                docs.forEach(d => {
                  tbody.append(`
            <tr>
              <td>${d.nombre_personalizado}</td>
              <td class="text-center">
                <button class="btn btn-link text-primary btnVer"
                        data-id="${d.id}"
                        data-nombre="${d.nombre_personalizado}">
                  <i class="fas fa-eye"></i>
                </button>
              </td>
            </tr>`);
                });
              }

              $('#modalArchivos').modal('show'); // ya tenemos la info
            },
            error: () => alert('Error al cargar la lista de documentos')
          });
        });


        // ─────────────────────────────────────────────────────────────
        // 2) Clic en un archivo: pide el BINARIO y abre el visor
        // ─────────────────────────────────────────────────────────────
        $(document).on('click', '.btnVer', function() {
          const idDoc = $(this).data('id');
          const nombre = $(this).data('nombre');

          fetch(`<?php echo base_url('Documentos_Aspirantes/stream');?>/${idDoc}`)
            .then(r => r.blob())
            .then(blob => {
              const url = URL.createObjectURL(blob);
              const tipo = blob.type || 'desconocido';
              console.log('MIME:', tipo, 'URL:', url); // ← debug

              $('#tituloVisor').text(nombre);
              const wrap = $('#visorWrap').empty(); // contenedor limpio

              /* ---------- PDF ---------- */
              if (tipo === 'application/pdf') {
                // Prueba primero con iframe (más compatible con blobs PDF)
                $('<iframe>', {
                  src: url + '#view=FitH', // ajusta ancho
                  style: 'width:100%;height:100%;border:none;'
                }).appendTo(wrap);

                /* ---------- Imagen ---------- */
              } else if (tipo.startsWith('image/')) {
                $('<img>', {
                  src: url,
                  alt: nombre,
                  style: 'width:100%;height:100%;object-fit:contain;'
                }).appendTo(wrap);

                /* ---------- Video ---------- */
              } else if (tipo.startsWith('video/')) {
                $('<video>', {
                  src: url,
                  controls: true,
                  style: 'width:100%;height:100%;object-fit:contain;'
                }).appendTo(wrap);

                /* ---------- Cualquier otra cosa ---------- */
              } else {
                $('<iframe>', {
                  src: url,
                  style: 'width:100%;height:100%;border:none;'
                }).appendTo(wrap);
              }

              $('#modalVisor').modal('show');
            })
            .catch(() => Swal.fire('Error', 'No se pudo abrir el documento', 'error'));
        });

        /* Libera memoria y limpia cuando se cierra */
        $('#modalVisor').on('hidden.bs.modal', function() {
          $('#visorWrap').empty();
        });


        // Libera memoria al cerrar
        $('#modalVisor').on('hidden.bs.modal', function() {
          $('#visorWrap').empty();
        });


        // Limpia y libera memoria al cerrar
        $('#modalVisor').on('hidden.bs.modal', function() {
          const src = $('#iframeVisor').attr('src');
          if (src) {
            URL.revokeObjectURL(src);
          }
          $('#iframeVisor').attr('src', '');
        });

        function openDetails(requisicion_id) {
          if (window.innerWidth <= 768) {
            // Oculta el div1 y muestra el div2 en pantallas pequeñas
            $('.div1').hide();
            $('.div2').show();
          }

          $('.div-candidato').removeClass('card-proceso-active');
          $('#div-candidato' + requisicion_id).addClass('card-proceso-active');

          $.ajax({
            url: '<?php echo base_url('Cliente/get_requisicion_details'); ?>',
            method: 'POST',
            data: {
              'requisicion_id': requisicion_id
            },
            beforeSend: function() {
              $('.loader').css("display", "block");
            }
          }).done(function(res) {
            if (res.length !== 14) {
              let data = JSON.parse(res);
              let tbody = '';

              data.data.forEach(function(resp) {

                let cvLink = `
                    <button type="button"
                            class="btn btn-link text-primary btnDocs"
                            data-id_ra="${resp.id_ra}"
                            title="Ver documentos">
                      <i class="fas fa-file-alt"></i>
                    </button>`;


                tbody += '<tr>';
                tbody += '<td class="d-none d-sm-table-cell">' + resp.id + '</td>';
                tbody += '<td>' + resp.nombre_aspirante + '</td>';
                tbody += '<td class="d-none d-sm-table-cell">' + resp.area_interes +
                  '</td>'; // Oculta en pantallas pequeñas
                tbody += '<td>';
                tbody += '<div class="action-icons">';
                tbody += '<a href="#" onclick="verHistorial(' + resp.id_ra + ', \'' + resp.nombre_aspirante +
                  '\')" class="btn btn-link text-primary" title="Movimientos del Aspirante"><i class="fas fa-history"></i></a>';
                tbody += '<a href="#" onclick="verHistorialMovimientos(\'' + resp.nombre_aspirante + '\', \'' +
                  resp
                  .id_ra +
                  '\')" class="btn btn-link text-primary" title="Comentarios Reclutador"><i class="fas fa-comments"></i></a>';

                // Actualización del enlace CV


                tbody += cvLink;
                tbody += '</div>';
                tbody += '</td>';
                tbody += '</tr>';
              });

              $('#dataTable tbody').html(tbody);
              $('#dataTable').DataTable(); // Inicializa el DataTable
            } else {
              let tbody = '<tr>';
              tbody += '<td colspan="4" class="text-center">Aún no hay aspirantes para esta requisición</td>';
              tbody += '</tr>';
              $('#dataTable tbody').html(tbody);
            }
          }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
          }).always(function() {
            $('.loader').fadeOut();
          });
        }

        function goBack() {
          if (window.innerWidth <= 768) {
            // Muestra el div1 y oculta el div2 en pantallas pequeñas
            $('.div1').show();
            $('.div2').hide();
          }
        }

        function openProcedures() {
          // Recargar la página
          window.location.reload();
        }
        // Función que carga una sección y la muestra
        function loadPageInSection() {
          var id_cliente = <?php echo $id_cliente; ?>;
          loadSection(
            'panel-agregar-candidato',
            "<?php echo base_url('Requisicion/index'); ?>", {
              id_cliente: id_cliente
            }
          );
        }
        // Cargar ambas secciones al principio
        $(document).ready(function() {
          $('.dropdown-toggle').dropdown();
          $('.dynamic-section').hide();

          $.get("<?php echo base_url('Dashboard/client'); ?>", function(response) {
            $('#panel-inicio').html(response).show();
            $('.custom-btn[data-section="panel-inicio"]').addClass('active'); // Activa el botón inicial
          });

          $.get("<?php echo base_url('Cliente_General/indexCliente'); ?>", function(response) {
            $('#seccion-bgv').html(response);
          });
        });


        // Función para cargar contenido en las secciones
        function loadSection(sectionIdToShow, url, data = {}, callback = null) {
          if ($('#' + sectionIdToShow).length) {
            $.ajax({
              url: url,
              method: "GET",
              data: data,
              success: function(response) {
                $('#' + sectionIdToShow).html(response); // Cargar el contenido en la sección
                if (callback) {
                  callback(); // Ejecutar callback si existe
                }
                showSection(sectionIdToShow); // Mostrar la sección después de cargar
              },
              error: function(xhr) {
                console.error(`Error al cargar la sección: ${xhr.responseText}`);
              }
            });
          } else {
            console.error(`El elemento con el id ${sectionIdToShow} no se encontró en el DOM.`);
          }
        }

        // Función para mostrar la sección
        function showSection(sectionIdToShow) {
          $('.dynamic-section').hide();
          $('#' + sectionIdToShow).show();

          $('.custom-btn').removeClass('active');
          $('.custom-btn[data-section="' + sectionIdToShow + '"]').addClass('active');
        }


        function loadEnglishVersion() {
          var id_cliente = <?php echo $id_cliente; ?>;
          $('#panel-inicio').hide();
          $('#panel-historial').hide();
          $.ajax({
            url: "<?php echo site_url('Requisicion/vista_ingles'); ?>",
            method: "POST",
            data: {
              'id_cliente': id_cliente
            },
            success: function(response) {
              $('#panel-agregar-candidato').html(response);
              // Mostrar la sección
              $('#panel-agregar-candidato').show();
            },
            error: function(xhr, status, error) {
              console.error(xhr.responseText);
            }
          });
        }
        </script>
        <script src="<?php echo base_url() ?>js/bolsa/aspirantes.js"></script>