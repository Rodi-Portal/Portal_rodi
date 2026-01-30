  <?php
      $CI                   = &get_instance();
      $idRol                = $CI->session->userdata('idrol');
      $logo                 = $CI->session->userdata('logo');
      $aviso_actual         = $CI->session->userdata('aviso');
      $lang                 = $CI->session->userdata('lang') ?: 'es';
      $terminos_condiciones = $CI->session->userdata('terminos');
      $archivo              = $aviso_actual ? $aviso_actual : 'AV_TL_V1.pdf';
      $terminos             = $terminos_condiciones ? $terminos_condiciones : 'TM_TL_V1.pdf';
      $flag_mx              = base_url('img/iconos/flag_mx.svg');
      $flag_us              = base_url('img/iconos/flag_us.svg');

      // Bandera actual
      $flagSrc = ($lang === 'en') ? $flag_us : $flag_mx;

      // Idioma CI (nombre de carpeta)
      $idioma_ci = ($lang === 'en') ? 'english' : 'espanol';

      // 👇 importante: 'header' = header_lang.php
      $CI->lang->load('header', $idioma_ci);
      $CI->lang->load('portal_generales', $idioma_ci);
  
  ?>

  <!DOCTYPE html>
  <html lang="<?php echo $lang; ?>">

  <head>
    <?php i18n_js(['portal_', 'sidebar_', 'header_']); ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--meta name="csrf-token" content="{{ csrf_token() }}" -->
    <title>Panel de Control | RODI</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpg" href="<?php echo base_url() ?>img/favicon.jpg" sizes="64x64">
    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <?php echo link_tag("css/sb-admin-2.min.css"); ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
    <!-- Select Bootstrap -->
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Dropzone CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
    <!-- CSS -->
    <?php echo link_tag("css/custom.css"); ?>
    <!-- Sweetalert 2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- JavaScript -->
    <script src="<?php echo base_url() ?>vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!--script src="< ?php echo base_url() ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script -->
    <script src="<?php echo base_url() ?>vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Dropzone JS (debe ir después de jQuery y Bootstrap JS) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <!-- Page Level Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?php echo base_url() ?>js/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
    <!-- Dropzone JS -->
    <!-- FullCalendar (Descomentado si se necesita) -->
    <!--<link href='< ?php echo base_url(); ?>calendar/css/fullcalendar.css' rel='stylesheet' >-->
    <!-- Uncomment if Pusher is needed -->
    <!-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script> -->
    <!-- Inicialización de Selectpicker -->
    <script>
    $(document).on('focusin', function(e) {
      if ($(e.target).closest('.swal2-container').length) {
        e.stopImmediatePropagation();
      }
    });
    </script>
  </head>

  <body id="page-top">
    <!-- JavaScript -->

    <?php /*$token = $this->session->userdata('jwt_token'); 
    echo $token  */?>
    <!-- Page Wrapper -->
    <div id="wrapper">
      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <?php if ($logo == null) {
                $logo = 'logo_nuevo.png';
        }?>
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
    <img 
        src="<?php echo base_url(); ?>_logosPortal/<?php echo $logo; ?>" 
        alt="Logo"
        style="max-width: 200px; width: 100%; height: auto; object-fit: contain;"
    >
</a>

        <!--h2 class="text-white text-center font-weight-bold">TalentSafe Control</h2> <!-- Divider -->
        <br><br>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <?php if ($idRol == 1 || $idRol == 6 || $idRol == 9 || $idRol == 10 || $idRol == 4) {?>
        <li class="nav-item sidebar-main-item">
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
              <?php if ($idRol == 1 || $idRol == 6) {?>
              <a class="collapse-item" href="javascript:void(0);" data-toggle="modal" data-target="#updateLogoModal">
                <i class="fas fa-image fa-sm fa-fw mr-2 text-gray-400"></i>
                <?php echo $this->lang->line('sidebar_update_logo'); ?>
              </a>
              <a class="collapse-item" href="javascript:void(0);" data-toggle="modal" data-target="#updateAvisoModal">
                <i class="fas fa-user-shield fa-sm fa-fw mr-2 text-gray-400"></i>
                <?php echo $this->lang->line('sidebar_privacy_notice'); ?>
              </a>
              <a class="collapse-item" href="<?php echo base_url(); ?>Area/pasarela">
                <i class="fas fa-credit-card fa-sm fa-fw mr-2 text-gray-400"></i>
                <?php echo $this->lang->line('sidebar_billing_subscription'); ?>
              </a>
              <a class="collapse-item" href="<?php echo base_url(); ?>legal">
                <i class="fas fa-credit-card fa-sm fa-fw mr-2 text-gray-400"></i>
                <?php echo $this->lang->line('sidebar_terms_conditions'); ?>
              </a>
              <?php }?>
              <a class="collapse-item" href="<?php echo base_url(); ?>Login/logout">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                <?php echo $this->lang->line('sidebar_logout'); ?>
              </a>
            </div>
          </div>
        </li>
        <?php }?>
        <hr class="sidebar-divider my-0">
        <!-- Menú principal -->
        <li class="nav-item sidebar-main-item">
          <a class="nav-link" href="<?php echo site_url('Dashboard/show') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span><?php echo $this->lang->line('sidebar_dashboard'); ?></span>
          </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Manual de Usuario -->
        <li class="nav-item sidebar-main-item">
          <a class="nav-link" href="<?php echo base_url('_manuales/guia_usuario_v1.pdf'); ?>" target="_blank">
            <i class="fas fa-book"></i>
            <span><?php echo $this->lang->line('sidebar_user_guide'); ?></span>
          </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Divider with Text -->
        <li class="nav-item sidebar-main-item">
          <a class="nav-link " id="recruitment-btn" href="<?php echo site_url('Reclutamiento/menu') ?>">
            <i class="fas fa-users"></i>
            <span><?php echo $this->lang->line('sidebar_recruitment'); ?></span>
          </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <li class="nav-item sidebar-main-item">
          <a id="pre-employment-btn" href="<?php echo site_url('Empleados/preEmpleados') ?>" class="nav-link ">
            <i class="fas fa-user-clock"></i>
            <span><?php echo $this->lang->line('sidebar_pre_employment'); ?></span>
          </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <li class="nav-item sidebar-main-item">
          <a id="former-employment-btn" href="<?php echo site_url('Empleados/index') ?>" class="nav-link ">
            <i class="fas fa-user-times"></i>
            <span><?php echo $this->lang->line('sidebar_employees'); ?></span>
          </a>

        </li>
        <!-- Divider -->
        <hr class="sidebar-divider">
        <li class="nav-item sidebar-main-item">
          <a id="former-employment-btn" href="<?php echo site_url('Empleados/exEmpleados') ?>" class="nav-link ">
            <i class="fas fa-user-times"></i>
            <span><?php echo $this->lang->line('sidebar_former_employees'); ?></span>
          </a>

        </li>

        <!-- Comunicación -->
        <hr class="sidebar-divider">

        <li class="nav-item sidebar-main-item">
          <a id="communication-btn" href="<?php echo site_url('Empleados/comunicacion') ?>" class="nav-link">
            <i class="fas fa-calendar-alt"></i>
            <span><?php echo $this->lang->line('topbar_communication'); ?></span>
          </a>
        </li>
        <hr class="sidebar-divider">
        <!-- Divider -->
        <!-- Reportes -->
        <?php
            $portal = $this->session->userdata('idPortal');
        if (in_array(9, $submenus)) {?>
        <li class="nav-item sidebar-main-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportes"
            aria-expanded="true" aria-controls="collapseReportes">
            <i class="fas fa-fw fa-medkit"></i>
            <span><?php echo $this->lang->line('sidebar_reports'); ?></span>
          </a>
          <div id="collapseReportes" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <?php
              if ($idRol == 1 || $idRol == 6 || $idRol == 9 || $idRol == 10) {?>
              <a class="collapse-item contraer" ... href="<?php echo site_url('Reporte/listado_clientes_index') ?>">
                <?php echo $this->lang->line('sidebar_reports_branches'); ?>
              </a>
              <?php
                  }
                  if ($idRol == 1 || $idRol == 6 || $idRol == 9 || $idRol == 10) {?>
              <a class="collapse-item contraer" ...
                href="<?php echo site_url('Reporte/proceso_reclutamiento_index') ?>">
                <?php echo $this->lang->line('sidebar_reports_recruitment_process'); ?>
              </a>
              <?php
              }?>
              <?php if ($idRol == 1 || $idRol == 6 || $idRol == 9 || $idRol == 10) {?>
              <a class="collapse-item contraer" ... href="<?php echo site_url('Reporte/reporte_empleados_index') ?>">
                <?php echo $this->lang->line('sidebar_reports_employees'); ?>
              </a>
              <?php }?>
              <?php if ($idRol == 1 || $idRol == 6 || $idRol == 9 || $idRol == 10) {?>

              <a class="collapse-item contraer" ... href="<?php echo site_url('Reporte/reporte_exempleados') ?>">
                <?php echo $this->lang->line('sidebar_reports_former_employees'); ?>
              </a>
              <?php }?>
            </div>
          </div>
        </li>
        <?php }?>
        <!-- Catalogos -->
        <?php
            // ¿Se muestra el menú "Registrar"?
            $menuRegistrar = show_if_can(
                'admin.__menu.ver',
                in_array(5, $submenus) || in_array((int) $idRol, [1, 6, 9], true)
            );

            // Ítems dentro de "Registrar"
            $itemUsuariosAdmins = show_if_can(
                'admin.usuarios_internos.ver',
                in_array((int) $idRol, [1, 6, 9], true)
            );

            $itemSucursales = show_if_can(
                'admin.sucursales.ver',
                in_array((int) $idRol, [1, 6, 9], true)
            );

            // Si quieres dejar Portales con la misma condición legacy de antes:

            $soloPortal1YRol1 = ((int) $portal === 1 && (int) $idRol === 1);

            if ($soloPortal1YRol1) {
                // Aquí sí dejamos que el override per-usuario decida (legacy=true)
                $itemPortales = show_if_can('admin.portales.ver', true);
            } else {
                // Nunca mostrar para otros casos (incluye rol 6)
                $itemPortales = false;
            }
        ?>
        <?php
        if ($menuRegistrar): ?>
        <li class="nav-item sidebar-main-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCatalogos"
            aria-expanded="true" aria-controls="collapseCatalogos">
            <i class="fas fa-fw fa-folder"></i>
            <span><?php echo $this->lang->line('sidebar_register'); ?></span>
          </a>

          <div id="collapseCatalogos" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

              <?php if ($itemUsuariosAdmins): ?>
              <a class="collapse-item" href="<?php echo site_url('Cat_UsuarioInternos/index') ?>">
                <?php echo $this->lang->line('sidebar_admin_users'); ?>
              </a>
              <?php endif; ?>

              <?php if ($itemSucursales): ?>
              <a class="collapse-item" href="<?php echo site_url('Cat_Cliente/index') ?>">
                <?php echo $this->lang->line('sidebar_branches_clients'); ?>
              </a>
              <?php endif; ?>

              <?php if ($itemPortales): ?>
              <a class="collapse-item" href="<?php echo site_url('Cat_Portales/index') ?>">
                <?php echo $this->lang->line('sidebar_portals'); ?>
              </a>
              <?php endif; ?>

            </div>
          </div>
        </li>
        <?php endif;

        if ($portal == 1 && ($idRol == 1)) {?>
        <button id="enviarNotificacionesBtn">Enviar Notificaciones</button>
        <button id="enviarNotificacionesBtnex">Enviar Notificaciones</button>
        <button id="enviarNotificacionesBtnrec">Enviar Notificaciones</button>
        <div id="resultados"></div>

        <button id="enviarCvsBtn">Enviar CVS</button>
        <div id="resultados2"></div>
        <?php }?>
        <hr class="sidebar-divider d-none d-md-block">

        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

      </ul>
      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
          <!-- Topbar -->
          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <ul class="navbar-nav d-flex flex-row w-100">
              <!-- Contenedor para los botones -->
              <li class="nav-item custom-menu" style="flex: 1;">
                <div class="button-container">
                  <a id="recruitment-btn" href="<?php echo site_url('Reclutamiento/menu') ?>"
                    class="btn custom-btn recruitment-btn">
                    <div class="module-label">
                      <?php echo $this->lang->line('topbar_module_label'); ?>
                    </div>
                    <div class="btn-content">
                      <i class="fas fa-users"></i>
                      <?php echo $this->lang->line('topbar_recruitment'); ?>
                    </div>
                  </a>
                  <a id="pre-employment-btn" href="<?php echo site_url('Empleados/preEmpleados') ?>"
                    class="btn custom-btn pre-employment-btn">
                    <div class="module-label">
                      <?php echo $this->lang->line('topbar_module_label'); ?>
                    </div>
                    <div class="btn-content">
                      <i class="fas fa-user-clock"></i>
                      <?php echo $this->lang->line('topbar_pre_employment'); ?>
                    </div>
                  </a>
                  <a id="employment-btn employment-btn" href="<?php echo site_url('Empleados/index') ?>"
                    class="btn custom-btn employment-btn">
                    <div class="module-label">
                      <?php echo $this->lang->line('topbar_module_label'); ?>
                    </div>
                    <div class="btn-content">
                      <i class="fas fa-briefcase"></i>
                      <?php echo $this->lang->line('topbar_employees'); ?>
                    </div>
                  </a>

                  <a id="former-employment-btn " href="<?php echo site_url('Empleados/exEmpleados') ?>"
                    class="btn custom-btn former-employment-btn">
                    <div class="module-label">
                      <?php echo $this->lang->line('topbar_module_label'); ?>
                    </div>
                    <div class="btn-content">
                      <i class="fas fa-user-times"></i>
                      <?php echo $this->lang->line('topbar_former_employees'); ?>
                    </div>
                  </a>
                  <a id="former-actividades-btn" href="<?php echo site_url('Empleados/comunicacion') ?>"
                    class="btn custom-btn former-actividades-btn">
                    <div class="module-label">
                      <?php echo $this->lang->line('topbar_module_label'); ?>
                    </div>
                    <div class="btn-content">
                      <i class="fas fa-calendar-alt"></i>
                      <?php echo $this->lang->line('topbar_communication'); ?>
                    </div>
                  </a>

                </div>
              </li>
              <!-- Nav Item - Alerts -->
              <li class="nav-item dropdown no-arrow mx-1" id="iconoNotificaciones">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-bell fa-fw" style="color:rgb(255, 42, 0);"></i>
                  <?php if (isset($contadorNotificaciones)) {
                      $displayContador = ($contadorNotificaciones > 0) ? 'initial' : 'none'; ?>
                  <span class="badge badge-danger badge-counter" id="contadorNotificaciones"
                    style="display:<?php echo $displayContador; ?>;"><?php echo $contadorNotificaciones ?></span>
                  <?php
                  }?>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                  aria-labelledby="alertsDropdown">
                  <h6 class="dropdown-header">
                    <?php echo $this->lang->line('topbar_notifications'); ?>
                  </h6>
                  <div id="contenedorNotificaciones" style="height: 40rem; overflow-y: auto; color: red"></div>
                </div>
              </li>
              <li class="nav-item dropdown no-arrow mx-1" id="iconoLlave">
                <a id="btnAbrirProveedores" class="nav-link icono-dorado text-center" href="#" role="button"
                  title="Proveedores destacados"
                  style="line-height: 1.2; display: flex; flex-direction: column; align-items: center; padding: 0; margin: 0;">

                  <div style="font-size: 9px; font-weight: bold; color: #000;">
                    <?php echo $this->lang->line('topbar_suppliers'); ?>
                  </div>
                  <i class="fas fa-key fa-fw icono-dorado" style="font-size: 20px;"></i>
                  <div style="font-size: 9px; font-weight: bold; color: #000;">
                    <?php echo $this->lang->line('topbar_featured_suppliers'); ?>
                  </div>
                </a>
              </li>
              <!-- Selector de idioma solo con bandera -->
              <!-- Selector de idioma con banderas -->
              <li class="nav-item dropdown no-arrow mx-1 d-flex align-items-center justify-content-center">
                <a class="nav-link dropdown-toggle p-0" href="#" id="langDropdown" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false"
                  title="<?php echo($lang === 'en') ? 'Cambiar a español' : 'Change to English'; ?>">
                  <img src="<?php echo $flagSrc; ?>" alt="<?php echo($lang === 'en') ? 'English' : 'Español'; ?>"
                    class="lang-flag-img">
                </a>

                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="langDropdown">
                  <button class="dropdown-item lang-option" data-lang="es">
                    <img src="<?php echo $flag_mx; ?>" class="lang-flag-img mr-2" alt="Español">
                    Español
                  </button>
                  <button class="dropdown-item lang-option" data-lang="en">
                    <img src="<?php echo $flag_us; ?>" class="lang-flag-img mr-2" alt="English">
                    English
                  </button>
                </div>
              </li>

            </ul>
          </nav>
          <!-- Modal para subir la imagen -->
          <div class="modal fade" id="updateLogoModal" tabindex="-1" role="dialog"
            aria-labelledby="updateLogoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title"> <?php echo $this->lang->line('portal_logo_modal_title');?> </h5> <button
                    type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                      aria-hidden="true">&times;</span> </button>
                </div>
                <div class="modal-body">
                  <form id="logoForm">
                    <div class="form-group"> <label for="fileLogo">
                        <?php echo $this->lang->line('portal_logo_select_image');?> </label> <input type="file"
                        class="form-control-file" id="fileLogo" name="fileLogo" accept="image/*"> </div>
                  </form>
                  <div id="preview" style="display: none;">
                    <h6><?php echo $this->lang->line('portal_logo_preview');?>:</h6> <img id="imagePreview" src=""
                      alt="Vista previa de la imagen" style="max-width: 100%; height: auto;">
                  </div> <!-- Si la variable de sesión 'logo' no es null, mostramos el botón de eliminar -->
                  <?php if ($this->session->userdata('logo') != null) {?> <div id="currentLogoContainer">
                    <h6><?php echo $this->lang->line('portal_logo_current');?>:</h6> <img id="currentLogo"
                      src="<?php echo base_url(); ?>_logosPortal/<?php echo $logo ?>"" alt=" Logo actual"
                      style="max-width: 100%; height: auto;"> <button id="deleteLogo" class="btn btn-danger">
                      <?php echo $this->lang->line('portal_logo_delete');?>
                    </button>

                  </div> <?php }?>
                </div>
                <div class="modal-footer"> <button class="btn btn-secondary" data-dismiss="modal">
                    <?php echo $this->lang->line('portal_logo_close');?> </button>
                  <button id="saveLogo" class="btn btn-primary">
                    <?php echo $this->lang->line('portal_logo_save');?>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="updateAvisoModal" tabindex="-1" role="dialog"
            aria-labelledby="updateAvisoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">

                <div class="modal-header py-2">
                  <h5 class="modal-title">
                    <?php echo $this->lang->line('portal_docs_modal_title');?>
                  </h5>
                  <button type="button" class="close" data-dismiss="modal"
                    aria-label="<?php echo $this->lang->line('portal_close');?>">
                    <span>&times;</span>
                  </button>
                </div>

                <div class="modal-body">
                  <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                      <thead>
                        <tr>
                          <th style="width:25%"><?php echo $this->lang->line('portal_docs_th_document');?></th>
                          <th><?php echo $this->lang->line('portal_docs_th_current');?></th>
                          <th style="width:35%"><?php echo $this->lang->line('portal_docs_th_upload');?></th>
                          <th style="width:20%"><?php echo $this->lang->line('portal_docs_th_actions');?></th>
                        </tr>
                      </thead>
                      <tbody>

                        <!-- AVISO -->
                        <tr id="row-aviso">
                          <td><strong><?php echo $this->lang->line('portal_docs_aviso');?></strong></td>
                          <td>
                            <div id="estado-aviso" class="small"></div>
                          </td>
                          <td>
                            <input type="file" id="file-aviso" accept="application/pdf" class="form-control-file">
                          </td>
                          <td class="text-nowrap">
                            <button type="button" id="btn-save-aviso" class="btn btn-sm btn-link"
                              title="<?php echo $this->lang->line('portal_save');?>">
                              <span class="fas fa-save" style="font-size:2rem;color:#0d6efd;"></span>
                            </button>

                            <button type="button" id="btn-del-aviso" class="btn btn-sm btn-link"
                              title="<?php echo $this->lang->line('portal_delete');?>" disabled>
                              <span class="fas fa-trash-alt"
                                style="font-size:2rem;color:#dc3545;margin-left:25px"></span>
                            </button>
                          </td>
                        </tr>

                        <!-- TÉRMINOS -->
                        <tr id="row-terminos">
                          <td><strong><?php echo $this->lang->line('portal_docs_terminos');?></strong></td>
                          <td>
                            <div id="estado-terminos" class="small"></div>
                          </td>
                          <td>
                            <input type="file" id="file-terminos" accept="application/pdf" class="form-control-file">
                          </td>
                          <td class="text-nowrap">
                            <button type="button" id="btn-save-terminos" class="btn btn-sm btn-link"
                              title="<?php echo $this->lang->line('portal_save');?>">
                              <span class="fas fa-save" style="font-size:2rem;color:#0d6efd;"></span>
                            </button>

                            <button type="button" id="btn-del-terminos" class="btn btn-sm btn-link"
                              title="<?php echo $this->lang->line('portal_delete');?>" disabled>
                              <span class="fas fa-trash-alt"
                                style="font-size:2rem;color:#dc3545;margin-left:25px"></span>
                            </button>
                          </td>
                        </tr>

                        <!-- CONFIDENCIALIDAD -->
                        <tr id="row-confidencialidad">
                          <td><strong><?php echo $this->lang->line('portal_docs_confidencialidad');?></strong></td>
                          <td>
                            <div id="estado-confidencialidad" class="small"></div>
                          </td>
                          <td>
                            <input type="file" id="file-confidencialidad" accept="application/pdf"
                              class="form-control-file">
                          </td>
                          <td class="text-nowrap">
                            <button type="button" id="btn-save-confidencialidad" class="btn btn-sm btn-link"
                              title="<?php echo $this->lang->line('portal_save');?>">
                              <span class="fas fa-save" style="font-size:2rem;color:#0d6efd;"></span>
                            </button>

                            <button type="button" id="btn-del-confidencialidad" class="btn btn-sm btn-link"
                              title="<?php echo $this->lang->line('portal_delete');?>" disabled>
                              <span class="fas fa-trash-alt"
                                style="font-size:2rem;color:#dc3545;margin-left:25px"></span>
                            </button>
                          </td>
                        </tr>

                      </tbody>
                    </table>
                  </div>

                  <div class="text-muted small mt-2">
                    <?php echo $this->lang->line('portal_docs_note_default');?>
                  </div>
                </div>

                <div class="modal-footer py-2">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <?php echo $this->lang->line('portal_close');?>
                  </button>
                </div>

              </div>
            </div>
          </div>





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

          <!-- End of Topbar -->
          <script>
          const DEFAULTS = {
            aviso: 'AV_TL_V1.pdf',
            terminos: 'TM_TL_V1.pdf'
          };
          const CSRF_NAME = '<?php echo $this->security->get_csrf_token_name(); ?>';
          const CSRF_HASH = '<?php echo $this->security->get_csrf_hash(); ?>';
          const VIEW_AVISO_BASE = '<?php echo base_url("Avance/ver_aviso/"); ?>';

          function linkDoc(nombre) {
            const safe = encodeURIComponent(nombre || '');
            return `<a href="${VIEW_AVISO_BASE}${safe}" target="_blank">Ver documento</a>`;
          }

          function pintarEstado(tipo, tieneActual) {
            const ref = DOC[tipo];
            if (!ref) return;

            // Siempre apuntamos al controlador. Él decide: archivo propio o default.
            const urlVer = '<?php echo base_url("portal/doc"); ?>/' + tipo;

            if (tieneActual) {
              $(ref.estado).html(
                `<div>
         <span class="text-success">Actual:&nbsp;</span>
         <a href="${urlVer}" target="_blank" rel="noopener">Ver documento</a>
         <div class="text-muted">Si eliminas, volverá al por defecto.</div>
       </div>`
              );
              $(ref.del).prop('disabled', false).css({
                cursor: 'pointer',
                opacity: 1
              });
            } else {
              $(ref.estado).html(
                `<div>
         <span class="text-muted">Por defecto:&nbsp;</span>
         <a href="${urlVer}" target="_blank" rel="noopener">Ver documento por defecto</a>
       </div>`
              );
              $(ref.del).prop('disabled', true).css({
                cursor: 'not-allowed',
                opacity: .6
              });
            }
          }

          function cargarDocumentos() {
            $.ajax({
              url: '<?php echo base_url("Avance/documentos_info"); ?>',
              type: 'POST',
              dataType: 'json',
              data: {
                [CSRF_NAME]: CSRF_HASH
              },
              success: function(r) {
                if (r.error) {
                  $('#estado-aviso, #estado-terminos, #estado-confidencialidad')
                    .html('<span class="text-danger">Error al cargar estado.</span>');
                  $('#btn-del-aviso, #btn-del-terminos, #btn-del-confidencialidad')
                    .prop('disabled', true);
                  return;
                }
                pintarEstado('aviso', !!r.aviso_tiene);
                pintarEstado('terminos', !!r.terminos_tiene);
                pintarEstado('confidencialidad', !!r.confidencialidad_tiene);
              },
              error: function() {
                $('#estado-aviso, #estado-terminos, #estado-confidencialidad')
                  .html('<span class="text-danger">Error al cargar estado.</span>');
                $('#btn-del-aviso, #btn-del-terminos, #btn-del-confidencialidad')
                  .prop('disabled', true);
              }
            });
          }
          // Cambio de idioma al seleccionar una bandera del menú
          $(document).on('click', '.lang-option', function(e) {
            e.preventDefault();

            var nuevoLang = $(this).data('lang');

            $.ajax({
              url: '<?php echo base_url("Usuario/cambiar_idioma"); ?>',
              type: 'POST',
              dataType: 'json',
              data: (function() {
                var d = {};
                d['lang'] = nuevoLang;
                d[CSRF_NAME] = CSRF_HASH;
                return d;
              })(),
              success: function(res) {
                if (res && res.ok) {
                  location.reload(); // recarga con la nueva bandera e idioma
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: (res && res.message) || 'No se pudo cambiar el idioma.'
                  });
                }
              },
              error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'No se pudo cambiar el idioma (error de servidor).'
                });
              }
            });
          });

          // Asegúrate de mantener esto:
          $('#updateAvisoModal').on('show.bs.modal', cargarDocumentos);
          // Abrir el modal → cargar estado

          // ==== Mapa de referencia por tipo de documento ====
          const DOC = {
            aviso: {
              file: '#file-aviso',
              estado: '#estado-aviso',
              del: '#btn-del-aviso'
            },
            terminos: {
              file: '#file-terminos',
              estado: '#estado-terminos',
              del: '#btn-del-terminos'
            },
            confidencialidad: {
              file: '#file-confidencialidad',
              estado: '#estado-confidencialidad',
              del: '#btn-del-confidencialidad'
            }
          };

          // ==== Utils ====
          function isPDF(file) {
            if (!file) return false;
            // algunos navegadores no setean correctamente type, por eso validamos ambos
            const byMime = file.type && file.type.toLowerCase() === 'application/pdf';
            const byExt = /\.pdf$/i.test(file.name || '');
            return byMime || byExt;
          }

          function toast(icon, title, text) {
            if (window.Swal) return Swal.fire({
              icon,
              title,
              text
            });
            alert(title || text || (icon === 'success' ? 'OK' : 'Error'));
          }

          // ==== Guardar/Subir (genérico) ====
          function subirDocumento(tipo, file) {
            const ref = DOC[tipo];
            if (!ref) return;

            if (!file) {
              return toast('warning',
                t('portal_docs_warn_title'),
                t('portal_docs_select_pdf')
              );
            }

            if (!isPDF(file)) {
              return toast('warning',
                t('portal_docs_invalid_file'),
                t('portal_docs_only_pdf')
              );
            }

            const fd = new FormData();
            fd.append('tipo', tipo);
            fd.append('archivo', file);
            fd.append(CSRF_NAME, CSRF_HASH);

            $.ajax({
              url: '<?php echo base_url("Avance/documentos_guardar"); ?>',
              type: 'POST',
              data: fd,
              processData: false,
              contentType: false,
              dataType: 'json',
              beforeSend: () => {
                $(ref.estado).html(t('portal_docs_uploading'));
              },
              success: function(r) {
                if (r && r.error) {
                  toast('error', t('portal_error'), r.error);
                  $(ref.estado).html('<span class="text-danger">' + t('portal_docs_upload_error') + '</span>');
                  return;
                }

                $(ref.file).val('');
                $(ref.del).prop('disabled', false).css({
                  cursor: 'pointer',
                  opacity: 1
                });

                toast('success',
                  t('portal_docs_saved_title'),
                  (r && r.mensaje) || t('portal_docs_updated')
                );

                if (typeof cargarDocumentos === 'function') cargarDocumentos();
                else if (r && r.url) {
                  $(ref.estado).html('<a href="' + r.url + '" target="_blank">' + t('portal_docs_view') + '</a>');
                } else {
                  $(ref.estado).html('<span class="text-success">' + t('portal_docs_updated') + '</span>');
                }
              },
              error: function() {
                toast('error', t('portal_error'), t('portal_docs_upload_fail'));
              }
            });
          }


          // ==== Eliminar (genérico) ====
          function eliminarDocumento(tipo) {
            const ref = DOC[tipo];
            if (!ref) return;

            const go = () => {
              $.ajax({
                url: '<?php echo base_url("Avance/documentos_eliminar"); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                  tipo,
                  [CSRF_NAME]: CSRF_HASH
                },
                success: function(r) {
                  if (r && r.error) {
                    return toast('error', t('portal_error'), r.error);
                  }

                  toast('success',
                    t('portal_docs_deleted_title'),
                    (r && r.mensaje) || t('portal_docs_deleted')
                  );

                  $(ref.del).prop('disabled', true).css({
                    cursor: 'not-allowed',
                    opacity: .6
                  });
                  if (typeof cargarDocumentos === 'function') cargarDocumentos();
                  else $(ref.estado).html('<span class="text-muted">' + t('portal_docs_not_loaded') +
                    '</span>');
                },
                error: function() {
                  toast('error', t('portal_error'), t('portal_docs_delete_fail'));
                }
              });
            };

            if (window.Swal) {
              Swal.fire({
                icon: 'warning',
                title: t('portal_docs_confirm_delete'),
                showCancelButton: true,
                confirmButtonText: t('portal_confirm'),
                cancelButtonText: t('portal_cancel')
              }).then(r => {
                if (r.isConfirmed) go();
              });
            } else {
              if (confirm(t('portal_docs_confirm_delete'))) go();
            }
          }


          // ==== Handlers de GUARDAR ====
          $('#btn-save-aviso').on('click', function() {
            const f = $(DOC.aviso.file)[0].files[0];
            subirDocumento('aviso', f);
          });

          $('#btn-save-terminos').on('click', function() {
            const f = $(DOC.terminos.file)[0].files[0];
            subirDocumento('terminos', f);
          });

          $('#btn-save-confidencialidad').on('click', function() {
            const f = $(DOC.confidencialidad.file)[0].files[0];
            subirDocumento('confidencialidad', f);
          });

          // ==== Handlers de ELIMINAR ====
          $('#btn-del-aviso').on('click', function() {
            eliminarDocumento('aviso');
          });
          $('#btn-del-terminos').on('click', function() {
            eliminarDocumento('terminos');
          });
          $('#btn-del-confidencialidad').on('click', function() {
            eliminarDocumento('confidencialidad');
          });
          </script>

          <script>
          // tu visor sirve /Avance/ver/{archivo}
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

          document.getElementById('fileLogo').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith('image')) {
              const reader = new FileReader();
              reader.onload = function(e) {
                // Mostrar la vista previa de la imagen
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('preview').style.display = 'block'; // Hacer visible la vista previa
              };
              reader.readAsDataURL(file);
            } else {
              alert('Por favor, selecciona una imagen válida.');
            }
          });

          /* document.addEventListener("DOMContentLoaded", function() {
             document.getElementById("former-actividades-btn").addEventListener("click", function(e) {
               e.preventDefault(); // Prevenir comportamiento por defecto del enlace
               Swal.fire({
                 icon: 'info',
                 title: 'Módulo en desarrollo',
                 text: 'Este módulo estará disponible próximamente. Actualmente se encuentra en desarrollo.',
                 confirmButtonText: 'Entendido',
                 confirmButtonColor: '#3085d6'
               });
             });
           }); */

          // Funcionalidad para eliminar el logo usando AJAX
          const deleteLogoBtn = document.getElementById('deleteLogo');

          if (deleteLogoBtn) {
            deleteLogoBtn.addEventListener('click', function() {

              // Confirmación con SweetAlert2
              Swal.fire({
                title: t('portal_logo_swal_confirm_title'),
                text: t('portal_logo_swal_confirm_text'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: t('portal_logo_swal_confirm_btn'),
                cancelButtonText: t('portal_logo_swal_cancel_btn'),
              }).then((result) => {
                if (result.isConfirmed) {

                  // Solicitud AJAX para eliminar el logo
                  $.ajax({
                    url: '<?php echo base_url(); ?>Area/eliminarLogo',
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {

                      if (response.success) {

                        // Éxito
                        Swal.fire(
                          t('portal_logo_deleted_title'),
                          t('portal_logo_deleted_text'),
                          'success'
                        );

                        setTimeout(function() {
                          window.location.reload();
                        }, 1000);

                        $('#updateLogoModal').modal('hide');

                        const container = document.getElementById('currentLogoContainer');
                        if (container) {
                          container.style.display = 'none';
                        }

                      } else {

                        // Error controlado por backend
                        Swal.fire(
                          t('portal_logo_error_title'),
                          t('portal_logo_delete_error'),
                          'error'
                        );
                      }
                    },
                    error: function() {

                      // Error de red / servidor
                      Swal.fire(
                        t('portal_logo_error_title'),
                        t('portal_logo_delete_error_try'),
                        'error'
                      );
                    }
                  });
                }
              });
            });
          }


          $('#form_aviso').submit(function(e) {
            e.preventDefault(); // Evitar el envío por defecto del formulario

            var formData = new FormData(this); // Obtener los datos del formulario

            $.ajax({
              url: '<?php echo base_url('Avance/guardar_aviso'); ?>',
              type: 'POST',
              data: formData,
              processData: false, // No procesar los datos
              contentType: false, // No establecer tipo de contenido
              success: function(response) {
                var res = JSON.parse(response);

                // Mostrar Swal.fire en función de la respuesta
                if (res.status == 'success') {
                  Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: res.message
                  }).then(function() {
                    // Cerrar el modal
                    $('#miModal').modal('hide'); // Asumiendo que tu modal tiene el ID "miModal"

                    // Limpiar el formulario
                    $('#form_aviso')[0].reset(); // Limpiar el formulario

                    // Realizar otras acciones si es necesario, por ejemplo, recargar alguna parte de la página o actualizar datos
                    // Si necesitas actualizar el modal con los nuevos datos, puedes hacerlo aquí también.
                    location
                      .reload(); // Recargar la página o actualizar el contenido dinámico si es necesario
                  });
                } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message
                  });
                }
              }
            });
          });

          const saveLogoBtn = document.getElementById('saveLogo');
          if (saveLogoBtn) {
            saveLogoBtn.addEventListener('click', function() {
              const fileLogo = document.getElementById('fileLogo');
              const file = fileLogo ? fileLogo.files[0] : null;

              if (file) {
                const formData = new FormData();
                formData.append('fileLogo', file);

                $.ajax({
                  url: '<?php echo base_url(); ?>Area/updateLogo',
                  type: 'POST',
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function(data) {
                    let response = {};
                    try {
                      response = typeof data === 'string' ? JSON.parse(data) : data;
                    } catch (e) {}

                    if (response.success) {
                      $('#updateLogoModal').modal('hide');

                      Swal.fire({
                        icon: 'success',
                        title: t('portal_logo_update_success'),
                        text: t('portal_logo_update_success_txt'),
                      });

                      setTimeout(function() {
                        window.location.reload();
                      }, 1000);

                    } else {
                      Swal.fire({
                        icon: 'error',
                        title: t('portal_logo_update_error'),
                        text: response.message || t('portal_logo_generic_error'),
                      });
                    }
                  },
                  error: function() {
                    Swal.fire({
                      icon: 'error',
                      title: t('portal_logo_update_error'),
                      text: t('portal_logo_generic_error'),
                    });
                  }
                });

              } else {
                Swal.fire({
                  icon: 'warning',
                  title: t('portal_logo_no_file_title'),
                  text: t('portal_logo_no_file_text'),
                });
              }
            });
          }

          // Al hacer clic en el botón
          $('#enviarNotificacionesBtn').on('click', function() {
            $.ajax({
              url: '<?php echo base_url("Notificacion/enviar_notificaciones_cron_job2"); ?>', // Ruta a la función
              type: 'GET', // Método GET
              dataType: 'json', // Esperamos una respuesta en formato JSON
              success: function(response) {
                // Mostrar la respuesta en el div
                $('#resultados').html(JSON.stringify(response)); // Puedes formatearlo más si lo deseas
              },
              error: function(xhr, status, error) {
                console.log("Error: " + error); // Si ocurre algún error
              }
            });
          });
          $('#enviarNotificacionesBtnex').on('click', function() {
            $.ajax({
              url: '<?php echo base_url("Notificacion/enviar_notificaciones_exempleados_cron_job"); ?>', // Ruta a la función
              type: 'GET', // Método GET
              dataType: 'json', // Esperamos una respuesta en formato JSON
              success: function(response) {
                // Mostrar la respuesta en el div
                $('#resultados').html(JSON.stringify(response)); // Puedes formatearlo más si lo deseas
              },
              error: function(xhr, status, error) {
                console.log("Error: " + error); // Si ocurre algún error
              }
            });
          });
          $('#enviarNotificacionesBtnrec').on('click', function() {
            $.ajax({
              url: '<?php echo base_url("Notificacion/enviar_recordatorios_cron_job_run"); ?>', // Ruta a la función
              type: 'GET', // Método GET
              dataType: 'json', // Esperamos una respuesta en formato JSON
              success: function(response) {
                // Mostrar la respuesta en el div
                $('#resultados').html(JSON.stringify(response)); // Puedes formatearlo más si lo deseas
              },
              error: function(xhr, status, error) {
                console.log("Error: " + error); // Si ocurre algún error
              }
            });
          });

          $('#enviarCvsBtn').on('click', function() {
            $.ajax({
              url: '<?php echo base_url("Tools/migrar_cv"); ?>',
              type: 'GET',
              dataType: 'json',
              success: function(response) {
                if (response && response.mensajes) {
                  $('#resultados2').html(
                    '<ul><li>' + response.mensajes.join('</li><li>') + '</li></ul>'
                  );
                } else {
                  $('#resultados2').html('No se recibieron mensajes.');
                }
              },
              error: function(xhr, status, error) {
                console.log("Error: " + error);
                $('#resultados2').html('⚠ Ocurrió un error al ejecutar la migración.');
              }
            });
          });
          $(document).ready(function() {

            const sidebarHidden = localStorage.getItem('sidebar_hidden');

            if (sidebarHidden === '1') {
              $('body').addClass('sidebar-toggled');
              $('.sidebar').addClass('toggled');
            }

          });
          $(document).on('click', '[data-target="#collapseUsuario"]', function(e) {

            // Si el sidebar está colapsado
            if ($('body').hasClass('sidebar-toggled')) {
              e.preventDefault();

              // 1️⃣ Expandir sidebar
              $('body').removeClass('sidebar-toggled');
              $('.sidebar').removeClass('toggled');
              localStorage.setItem('sidebar_hidden', '0');

              // 2️⃣ Esperar animación y abrir menú
              setTimeout(function() {
                $('#collapseUsuario').collapse('show');
              }, 300);
            }
          });
          </script>