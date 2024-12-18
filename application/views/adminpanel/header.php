<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <!-- CSS -->
  <?php echo link_tag("css/custom.css"); ?>

  <!-- Sweetalert 2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">

  <!-- Animate CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <!-- JavaScript -->
  <script src="<?php echo base_url() ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url() ?>vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

  <!-- Incluir Bootstrap Select JS -->

  <!-- Page Level Plugins -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="<?php echo base_url() ?>js/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
  <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

  <!-- FullCalendar (Descomentado si se necesita) -->
  <!--<link href='< ?php echo base_url(); ?>calendar/css/fullcalendar.css' rel='stylesheet' >-->

  <!-- Uncomment if Pusher is needed -->
  <!-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script> -->

  <!-- Inicialización de Selectpicker -->

</head>

<body id="page-top">
  <!-- JavaScript -->


  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center">

        <img width="100px" src="<?php echo base_url(); ?>img/portal_icon.png" alt="Logo">


      </a>
      <h2 class="text-white text-center font-weight-bold">TalentSafe Control</h2> <!-- Divider -->
      <hr class="sidebar-divider my-0">


      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Menú principal -->
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo site_url('Dashboard/dashboardIndex') ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

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
        <a class="nav-link " id="recruitment-btn" href="<?php echo site_url('Reclutamiento/menu') ?>"><i
            class="fas fa-users"></i>
          <span>Reclutamiento</span><!-- Icono de FontAwesome para Recruitment -->

        </a>

      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <li class="nav-item">
        <a id="pre-employment-btn" href="<?php echo site_url('Empleados/preEmpleados') ?>" class="nav-link ">
          <i class="fas fa-user-clock"></i>
          <span>Preempleo</span>
        </a>

      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <li class="nav-item">
        <a id="former-employment-btn" href="<?php echo site_url('Empleados/exEmpleados') ?>" class="nav-link ">
          <i class="fas fa-user-times"></i>
          <span>Empleados</span>
        </a>

      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <li class="nav-item">
        <a id="former-employment-btn" href="<?php echo site_url('Empleados/exEmpleados') ?>" class="nav-link ">
          <i class="fas fa-user-times"></i>
          <span>Exempleado</span>
        </a>

      </li>
      <!-- Divider -->

      <!-- Reportes -->
      <?php
if (in_array(9, $submenus)) {?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportes"
          aria-expanded="true" aria-controls="collapseReportes">
          <i class="fas fa-fw fa-medkit"></i>
          <span>Reportes</span>
        </a>
        <div id="collapseReportes" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <!--a class="collapse-item" href="< ?php echo site_url('Reporte/index') ?>">Reportes</a>
           < ?php
              if(in_array(27, $submenus)){ ?>
            <a class="collapse-item contraer" data-toggle="tooltip" data-placement="right" title="Listado de Estudios"
              href="< ?php echo site_url('Reporte/listado_estudios_index') ?>">Listado de Estudios</a>
            < ?php
							}
							if(in_array(26, $submenus)){ ?>
            <a class="collapse-item contraer" data-toggle="tooltip" data-placement="right" title="Doping Finalizados"
              href="< ?php echo site_url('Reporte/listado_clientes_index') ?>">Doping Finalizados</a>
            < ?php
							}
							if(in_array(13, $submenus)){ ?>
            <a class="collapse-item" href="< ?php echo site_url('Reporte/sla_ingles_index') ?>">SLA Inglés</a>
            < ?php
							}  */
							if(in_array(16, $submenus)){ ?>
            <a class="collapse-item" href="< ?php echo site_url('Reporte/listado_doping_index') ?>">Listado de Doping</a-->

            <?php
if (in_array(25, $submenus)) {?>
            <a class="collapse-item contraer" data-toggle="tooltip" data-placement="right" title="Listado de Clientes"
              href="<?php echo site_url('Reporte/listado_clientes_index') ?>">Reportes de sucursales</a>
            <?php
}
    if (in_array(29, $submenus)) {?>
            <a class="collapse-item contraer" data-toggle="tooltip" data-placement="right"
              title="Proceso de reclutamiento"
              href="<?php echo site_url('Reporte/proceso_reclutamiento_index') ?>">Procesos de Reclutamiento.</a>
            <?php
}?>
          </div>
        </div>
      </li>
      <?php }
?>









      <!-- Catalogos -->
      <?php
if (in_array(5, $submenus)) {?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCatalogos"
          aria-expanded="true" aria-controls="collapseCatalogos">
          <i class="fas fa-fw fa-folder"></i>
          <span>Registrar</span>
        </a>
        <div id="collapseCatalogos" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php
$idRol = $this->session->userdata('idrol');
    if ($idRol == 1 || $idRol == 6) {?>
            <a class="collapse-item" href="<?php echo site_url('Cat_UsuarioInternos/index') ?>">Usuarios Administradores</a>
            <?php
}?>
            <?php
if ($idRol == 1 || $idRol == 6) {?>
            <a class="collapse-item" href="<?php echo site_url('Cat_Cliente/index') ?>">Sucursales</a>
            <?php
}?>
            <?php
$portal = $this->session->userdata('idPortal');
    $idRol = $this->session->userdata('idrol');
    if ($portal == 1 && ($idRol == 1 || $idRol == 6)) {?>
            <a class="collapse-item" href="<?php echo site_url('Cat_Portales/index') ?>">Portales</a>
            <?php
}?>

            <!-- ?php
                        if(in_array(8, $submenus)){ ?>
                      <a class="collapse-item" href="< ?php echo site_url('Cat_Puestos/index') ?>">Puestos</a>
                      < ?php
                        } ? -->
          </div>
        </div>
      </li>
      <?php }
?>


      <!-- ?php
                        if(in_array(8, $submenus)){ ?>
                      <a class="collapse-item" href="< ?php echo site_url('Cat_Puestos/index') ?>">Puestos</a>
                      < ?php
                        } ? -->



      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>
    </ul>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
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
                <a id="recruitment-btn" href="<?php echo site_url('Reclutamiento/menu') ?>" class="btn custom-btn">
                  <i class="fas fa-users"></i> <!-- Icono de FontAwesome para Recruitment -->
                  Reclutamiento
                </a>
                <a id="pre-employment-btn" href="<?php echo site_url('Empleados/preEmpleados') ?>"
                  class="btn custom-btn">
                  <i class="fas fa-user-clock"></i> <!-- Icono de FontAwesome para Pre-employment -->
                  Preempleo
                </a>
                <a id="employment-btn" href="<?php echo site_url('Empleados/index') ?>" class="btn custom-btn">
                  <i class="fas fa-briefcase"></i> <!-- Icono de FontAwesome para Employee -->
                  Empleados
                </a>
                <a id="former-employment-btn" href="<?php echo site_url('Empleados/exEmpleados') ?>"
                  class="btn custom-btn">
                  <i class="fas fa-user-times"></i> <!-- Icono de FontAwesome para Former employee -->
                  Exempleado
                </a>

              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1" id="iconoNotificaciones">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <?php if (isset($contadorNotificaciones)) {
    $displayContador = ($contadorNotificaciones > 0) ? 'initial' : 'none';?>
                <span class="badge badge-danger badge-counter" id="contadorNotificaciones"
                  style="display: <?php echo $displayContador; ?>;"><?php echo $contadorNotificaciones ?></span>
                <?php
}?>
              </a>
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Notificaciones</h6>
                <div id="contenedorNotificaciones" style="height: 40rem; overflow-y: auto;"></div>
              </div>
            </li>
            <li class="nav-item dropdown no-arrow mx-1" id="iconoLlave">
              <a class="nav-link icono-dorado" href="#" role="button" data-toggle="modal" data-target="#modalKey"
                data-bs-toggle="tooltip" data-bs-placement="top" title="proveedores  destacados">
                <i class="fas fa-key fa-fw icono-dorado"></i> <!-- Icono de llave -->
              </a>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"
                  style="font-size: 12px;"><?php echo $this->session->userdata('nombre') . " " . $this->session->userdata('paterno'); ?></span>
                <img class="img-profile rounded-circle" src="<?php echo base_url(); ?>img/user.png">
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?php echo base_url(); ?>Login/logout">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cerrar sesión
                </a>
              </div>
            </li>
          </ul>
        </nav>

        <div class="modal fade" id="modalKey" tabindex="-1" role="dialog" aria-labelledby="modalKeyLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-key-content">
              <div class="modal-header modal-key-header">
                <h5 class="modal-title modal-key-title" id="modalKeyLabel">Proveedores Destacados</h5>
                <button type="button" class="close modal-key-close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body modal-key-body">
                <p class="modal-key-intro">
                  Estas compañías hermanas destacan por su excelencia y profesionalismo, apoyando nuestras operaciones.
                </p>
                <div class="row text-center">
                  <!-- CROL -->
                  <div class="col-md-4 modal-key-col">
                    <div class="modal-key-card">
                      <div class="modal-key-card-header modal-key-card-croll">
                        CROL
                      </div>
                      <div class="modal-key-card-body">
                        <p class="modal-key-card-text">Recursos Contables</p>
                      </div>
                      <div class="modal-key-card-footer">
                        Soluciones contables avanzadas.
                      </div>
                    </div>
                  </div>
                  <!-- Valor H -->
                  <div class="col-md-4 modal-key-col">
                    <div class="modal-key-card">
                      <div class="modal-key-card-header modal-key-card-valorh">
                        Valor H
                      </div>
                      <div class="modal-key-card-body">
                        <p class="modal-key-card-text">Evaluaciones</p>
                      </div>
                      <div class="modal-key-card-footer">
                        Fomentando un ambiente laboral positivo.
                        Clima Laboral.
                        Desempeño.
                      </div>
                    </div>
                  </div>
                  <!-- Asesoría Jurídica -->
                  <div class="col-md-4 modal-key-col">
                    <div class="modal-key-card">
                      <div class="modal-key-card-header modal-key-card-juridica">
                        Asesoría Jurídica
                      </div>
                      <div class="modal-key-card-body">
                        <p class="modal-key-card-text">Consultoría Jurídica</p>
                      </div>
                      <div class="modal-key-card-footer">
                        Orientación legal confiable.
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row text-center">
                  <!-- Fiscalista -->
                  <div class="col-md-4 modal-key-col">
                    <div class="modal-key-card">
                      <div class="modal-key-card-header modal-key-card-fiscalista">
                        Fiscalista
                      </div>
                      <div class="modal-key-card-body">
                        <p class="modal-key-card-text">Nómina, Timbrado y Declaración de Impuestos</p>
                      </div>
                      <div class="modal-key-card-footer">
                        Servicios fiscales de alta calidad.
                      </div>
                    </div>
                  </div>
                  <!-- Dr. Clinic -->
                  <div class="col-md-4 modal-key-col">
                    <div class="modal-key-card">
                      <div class="modal-key-card-header modal-key-card-clinic">
                        Dr. Clinic
                      </div>
                      <div class="modal-key-card-body">
                        <p class="modal-key-card-text">Exámenes Médicos Detallados</p>
                      </div>
                      <div class="modal-key-card-footer">
                        Cuidado médico especializado.
                      </div>
                    </div>
                  </div>
                  <!-- CINCEL -->
                  <div class="col-md-4 modal-key-col">
                    <div class="modal-key-card">
                      <div class="modal-key-card-header modal-key-card-cincel">
                        CINCEL
                      </div>
                      <div class="modal-key-card-body">
                        <p class="modal-key-card-text">Firmas Electrónicas</p>
                      </div>
                      <div class="modal-key-card-footer">
                        Soluciones digitales innovadoras.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer modal-key-footer">
                <button type="button" class="btn modal-key-btn-close" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>


        <!-- RutasVue-->
        <!--script src="< ?php echo base_url('public/vue/js/chunk-vendors.e32c3448.js'); ?>"></script -->


        <!-- End of Topbar -->

        <?php
/*
<!-- Doping -->
<?php
if (in_array(3, $submenus)) {?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDoping"
            aria-expanded="true" aria-controls="collapseDoping">
            <i class="fas fa-fw fa-eye-dropper"></i>
            <span>Doping</span>
          </a>
          <div id="collapseDoping" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <?php
if (in_array(4, $submenus)) {?>
              <a class="collapse-item" href="<?php echo site_url('Doping/indexGenerales') ?>">Registros generales</a>
              <?php
}
if (in_array(23, $submenus)) {?>
              <a class="collapse-item" href="<?php echo site_url('Doping/indexPendientes') ?>">Registros pendientes</a>
              <?php
}
if (in_array(24, $submenus)) {?>
              <a class="collapse-item" href="<?php echo site_url('Doping/indexFinalizados') ?>">Finalizados</a>
              <?php
}?>
            </div>
          </div>
        </li>
        <?php }?>

        <!-- Laboratorio -->
        <?php
if (in_array(20, $submenus)) {?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLab" aria-expanded="true"
            aria-controls="collapseLab">
            <i class="fas fa-flask"></i>
            <span>Laboratorio</span>
          </a>
          <div id="collapseLab" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <?php
if (in_array(22, $submenus)) {?>
              <a class="collapse-item" href="<?php echo site_url('Medico/index') ?>">Examen médico</a>
              <?php
}
if (in_array(32, $submenus)) {?>
              <a class="collapse-item" href="<?php echo site_url('Covid/index') ?>">Pruebas COVID</a>
              <?php
}
if (in_array(21, $submenus)) {?>
              <a class="collapse-item" href="<?php echo site_url('Laboratorio/sanguineo') ?>">Grupo sanguíneo</a>
              <?php
}?>
            </div>
          </div>
        </li>
        <?php }?>
        */
        ?>
        <!-- Control -->
        <?php /*
if (in_array(17, $submenus)) {?>
        <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseControl"
            aria-expanded="true" aria-controls="collapseControl">
            <i class="fas fa-cogs"></i>
            <span>Control</span>
          </a>
          <div id="collapseControl" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <!--a class="collapse-item" href="<?php //echo site_url('Reporte/index') ?>">Control</a-->
              <?php /*
if(in_array(32, $submenus)){ ?>
              <a class="collapse-item" href="<?php echo site_url('Reporte/sla_ingles_index') ?>">SLA Inglés</a>
              <?php
}
if(in_array(38, $submenus)){ ?>
              <a class="collapse-item" href="<?php echo site_url('Reporte/listado_doping_index') ?>">Listado de
                Doping</a>
              <?php
} ?>
            </div>
          </div>
        </li>
        <?php
}
 */?>