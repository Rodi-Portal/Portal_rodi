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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

  <?php $idRol = $this->session->userdata('idrol');
  $logo          = $this->session->userdata('logo'); ?>
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
        <img style="max-width: 220px; max-height: 150px;"
          src="<?php echo base_url(); ?>_logosPortal/<?php echo $logo ?>" alt="Logo">
      </a>

      <!--h2 class="text-white text-center font-weight-bold">TalentSafe Control</h2> <!-- Divider -->
      <br><br>
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
          <span>Exempleados</span>
        </a>

      </li>
      <!-- Divider -->

      <!-- Reportes -->
      <?php
          $portal = $this->session->userdata('idPortal');
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
            if ($idRol == 1 || $idRol == 6) {?>
            <a class="collapse-item" href="<?php echo site_url('Cat_UsuarioInternos/index') ?>">Usuarios
              Administradores</a>
            <?php
            }?>
            <?php
if ($idRol == 1 || $idRol == 6) {?>
            <a class="collapse-item" href="<?php echo site_url('Cat_Cliente/index') ?>">Sucursales</a>
            <?php
            }?>
            <?php

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
      if ($portal == 1 && ($idRol == 1)) {?>
      <button id="enviarNotificacionesBtn">Enviar Notificaciones</button>
      <div id="resultados"></div>
      <?php }?>

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
                <a id="recruitment-btn" href="<?php echo site_url('Reclutamiento/menu') ?>"
                  class="btn custom-btn recruitment-btn">
                  <div class="module-label">Módulo</div>
                  <div class="btn-content">
                    <i class="fas fa-users"></i> <!-- Icono de FontAwesome para Recruitment -->
                    Reclutamiento
                  </div>
                </a>
                <a id="pre-employment-btn" href="<?php echo site_url('Empleados/preEmpleados') ?>"
                  class="btn custom-btn pre-employment-btn">
                  <div class="module-label">Módulo</div>
                  <div class="btn-content">
                    <i class="fas fa-user-clock"></i> <!-- Icono de FontAwesome para Pre-employment -->
                    Preempleo
                  </div>
                </a>
                <a id="employment-btn employment-btn" href="<?php echo site_url('Empleados/index') ?>"
                  class="btn custom-btn employment-btn">
                  <div class="module-label">Módulo</div>
                  <div class="btn-content">
                    <i class="fas fa-briefcase"></i> <!-- Icono de FontAwesome para Employee -->
                    Empleados
                  </div>
                </a>

                <a id="former-employment-btn " href="<?php echo site_url('Empleados/exEmpleados') ?>"
                  class="btn custom-btn former-employment-btn">
                  <div class="module-label">Módulo</div>
                  <div class="btn-content">
                    <!-- Contenedor para el ícono y texto -->
                    <i class="fas fa-user-times"></i> <!-- Icono de FontAwesome para Former employee -->
                    Exempleados
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
                <?php if ($portal == 1 && ($idRol == 1)) {?>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#updateLogoModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Actualizar Logo
                </a>
                <a class="dropdown-item" href="<?php echo base_url(); ?>Area/pasarela">

                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Suscripción
                </a>

                <?php }?>
                <a class="dropdown-item" href="<?php echo base_url(); ?>Login/logout">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cerrar sesión
                </a>
              </div>
            </li>
          </ul>
        </nav>

        <!-- Enlace que abre el modal -->


        <!-- Modal para subir la imagen -->
        <div class="modal fade" id="updateLogoModal" tabindex="-1" role="dialog" aria-labelledby="updateLogoModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="updateLogoModalLabel">Subir Nuevo Logo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                <form id="logoForm">
                  <div class="form-group">
                    <label for="fileLogo">Selecciona una imagen</label>
                    <input type="file" class="form-control-file" id="fileLogo" name="fileLogo" accept="image/*">
                  </div>
                </form>
                <div id="preview" style="display: none;">
                  <h6>Vista previa:</h6>
                  <img id="imagePreview" src="" alt="Vista previa de la imagen" style="max-width: 100%; height: auto;">
                </div>

                <!-- Si la variable de sesión 'logo' no es null, mostramos el botón de eliminar -->
                <?php if ($this->session->userdata('logo') != null) {?>
                <div id="currentLogoContainer">
                  <h6>Logo Actual:</h6>
                  <img id="currentLogo" src="<?php echo base_url(); ?>_logosPortal/<?php echo $logo ?>"" alt=" Logo
                    actual" style="max-width: 100%; height: auto;">
                  <button type="button" id="deleteLogo" class="btn btn-danger mt-2">Eliminar Logo</button>
                </div>
                <?php }?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" id="saveLogo" class="btn btn-primary">Guardar Logo</button>
              </div>
            </div>
          </div>
        </div>


        <div class="modal fade" id="modalKey" tabindex="-1" role="dialog" aria-labelledby="modalKeyLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content modal-key-content">
              <div class="modal-header modal-key-header">
                <h5 class="modal-title modal-title-modal-key-title-blanco" id="modalKeyLabel">Proveedores Destacados
                </h5>
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
                    <a href="https://www.crol.mx/#portada" target="_blank" style="text-decoration: none;">
                      <div class="modal-key-card">
                        <div class="modal-key-card-header modal-key-card-croll">
                          CROL
                        </div>
                        <!-- Contenedor para la imagen de fondo -->
                        <div class="modal-key-card-body" style="position: relative;">
                          <!-- Imagen de fondo con opacidad que no se repite -->
                          <div style="position: absolute; top: 70px; left: 0; right: 0; bottom: 0;
                    background-image: url('<?php echo base_url(); ?>img/provedores/crol.png');
                    background-size: 150px; background-position: center;
                    opacity: 0.9; z-index: 1; background-repeat: no-repeat;"></div>
                          <!-- Contenido de texto que no se ve afectado por la opacidad -->
                          <p class="modal-key-card-text" style="position: relative; z-index: 2;">Recursos Contables</p>
                        </div>
                        <div class="modal-key-card-footer">
                          Soluciones contables avanzadas.
                        </div>
                      </div>
                    </a>
                  </div>

                  <!-- GA -->
                  <div class="col-md-4 modal-key-col">
                    <a href="https://www.ga-solutionsgroup.com/" target="_blank" style="text-decoration: none;">
                      <div class="modal-key-card">
                        <div class="modal-key-card-header modal-key-card-ga">
                          GA Safety
                        </div>
                        <!-- Contenedor para la imagen de fondo -->
                        <div class="modal-key-card-body" style="position: relative; ">
                          <!-- Imagen de fondo con opacidad que no se repite -->
                          <div style="position: absolute; top: 50px; left: 0; right: 0; bottom: 0;
                            background-image: url('<?php echo base_url(); ?>img/provedores/GA.png');
                            background-size: 100px; background-position: center;
                            opacity: 0.9; z-index: 1; background-repeat: no-repeat;"></div>
                          <!-- Contenido de texto que no se ve afectado por la opacidad -->
                          <p class="modal-key-card-text" style="position: relative; z-index: 2;">Gestión Integral de
                            Riesgos</p>
                        </div>
                        <div class="modal-key-card-footer">
                          Soluciones avanzadas en seguridad laboral.
                        </div>
                      </div>
                    </a>
                  </div>

                  <!-- Rodi -->
                  <div class="col-md-4 modal-key-col">
                    <a href="https://www.rodi.com.mx" target="_blank" style="text-decoration: none;">
                      <div class="modal-key-card">
                        <div class="modal-key-card-header modal-key-card-valorh">
                          RODI
                        </div>
                        <!-- Contenedor para la imagen de fondo -->
                        <div class="modal-key-card-body" style="position: relative;">
                          <!-- Imagen de fondo con opacidad que no se repite -->
                          <div style="position: absolute; top: 100px; left: 0; right: 0; bottom: 0;
                    background-image: url('<?php echo base_url(); ?>img/provedores/Rodi.png');
                    background-size: 100px; background-position: center;
                    opacity: 0.9; z-index: 1; background-repeat: no-repeat;"></div>
                          <!-- Contenido de texto que no se ve afectado por la opacidad -->
                          <p class="modal-key-card-text" style="position: relative; z-index: 2;">
                            Reclutamiento, BGV, psicometrías y antidoping.
                          </p>
                        </div>
                        <div class="modal-key-card-footer">
                          Especialistas en soluciones de talento humano a nivel Latinoamérica.
                        </div>
                      </div>
                    </a>
                  </div>



                  <!-- Asesoría Jurídica -->
                  <div class="col-md-4 modal-key-col">
                    <a href="https://www.ejemplo.com" target="_blank" style="text-decoration: none;">
                      <div class="modal-key-card">
                        <div class="modal-key-card-header modal-key-card-juridica">
                          Asesoría Jurídica
                        </div>
                        <!-- Contenedor para la imagen de fondo -->
                        <div class="modal-key-card-body" style="position: relative;">
                          <!-- Imagen de fondo con opacidad que no se repite -->
                          <div style="position: absolute; top: 70px; left: 0; right: 0; bottom: 0;
                    background-image: url('<?php echo base_url(); ?>img/provedores/nadaaun.png');
                    background-size: 100px; background-position: center;
                    opacity: 0.4; z-index: 1; background-repeat: no-repeat;"></div>
                          <!-- Contenido de texto que no se ve afectado por la opacidad -->
                          <p class="modal-key-card-text" style="position: relative; z-index: 2;">Consultoría Jurídica
                          </p>
                        </div>
                        <div class="modal-key-card-footer">
                          Orientación legal confiable.
                        </div>
                      </div>
                    </a>
                  </div>

                  <!-- Fiscalista -->
                  <div class="col-md-4 modal-key-col">
                    <a href="#" target="_blank" style="text-decoration: none;">
                      <div class="modal-key-card">
                        <div class="modal-key-card-header modal-key-card-fiscalista">
                          Fiscalista
                        </div>
                        <!-- Contenedor para la imagen de fondo -->
                        <div class="modal-key-card-body" style="position: relative;">
                          <!-- Imagen de fondo con opacidad que no se repite -->
                          <div style="position: absolute; top: 80px; left: 0; right: 0; bottom: 0;
                    background-image: url('<?php echo base_url(); ?>img/provedores/nada.png');
                    background-size: 90px; background-position: center;
                    opacity: 0.9; z-index: 1; background-repeat: no-repeat;"></div>
                          <!-- Contenido de texto que no se ve afectado por la opacidad -->
                          <p class="modal-key-card-text" style="position: relative; z-index: 2;">Nómina, Timbrado y
                            Declaración de Impuestos</p>
                        </div>
                        <div class="modal-key-card-footer">
                          Servicios fiscales de alta calidad.
                        </div>
                      </div>
                    </a>
                  </div>

                  <!-- Dr. Clinic -->
                  <div class="col-md-4 modal-key-col">
                    <a href="https://doctorclinic.com.mx/" target="_blank" style="text-decoration: none;">
                      <div class="modal-key-card">
                        <div class="modal-key-card-header modal-key-card-clinic">
                          Dr. Clinic
                        </div>
                        <!-- Contenedor para la imagen de fondo -->
                        <div class="modal-key-card-body" style="position: relative;">
                          <!-- Imagen de fondo con opacidad que no se repite -->
                          <div style="position: absolute; top: 70px; left: 0; right: 0; bottom: 0;
                    background-image: url('<?php echo base_url(); ?>img/provedores/drclinic.png');
                    background-size: 100px; background-position: center;
                    opacity: 0.7; z-index: 1; background-repeat: no-repeat;"></div>
                          <!-- Contenido de texto que no se ve afectado por la opacidad -->
                          <p class="modal-key-card-text" style="position: relative; z-index: 2;">Exámenes Médicos
                            Detallados</p>
                        </div>
                        <div class="modal-key-card-footer">
                          Cuidado médico especializado.
                        </div>
                      </div>
                    </a>
                  </div>


                </div>
                <div class="row text-center">
                  <!-- CINCEL -->
                  <div class="col-md-4 modal-key-col">
                    <a href="https://www.cincel.digital/" target="_blank" style="text-decoration: none;">
                      <div class="modal-key-card">
                        <div class="modal-key-card-header modal-key-card-cincel">
                          CINCEL
                        </div>
                        <!-- Contenedor para la imagen de fondo -->
                        <div class="modal-key-card-body" style="position: relative;">
                          <!-- Imagen de fondo con opacidad que no se repite -->
                          <div style="position: absolute; top: 70px; left: 0; right: 0; bottom: 0;
                    background-image: url('<?php echo base_url(); ?>img/provedores/cincel.png');
                    background-size: 100px; background-position: center;
                    opacity: 0.9; z-index: 1; background-repeat: no-repeat;"></div>
                          <!-- Contenido de texto que no se ve afectado por la opacidad -->
                          <p class="modal-key-card-text" style="position: relative; z-index: 2;">Firmas Electrónicas</p>
                        </div>
                        <div class="modal-key-card-footer">
                          Soluciones digitales innovadoras.
                        </div>
                      </div>
                    </a>
                  </div>


                  <!-- Valor H -->
                  <div class="col-md-4 modal-key-col">
                    <a href="http://www.valorh.com.mx/" target="_blank" style="text-decoration: none;">
                      <div class="modal-key-card">
                        <div class="modal-key-card-header modal-key-card-valorh">
                          ValorH
                        </div>
                        <!-- Contenedor para la imagen de fondo -->
                        <div class="modal-key-card-body" style="position: relative;">
                          <!-- Imagen de fondo con opacidad que no se repite -->
                          <div style="position: absolute; top: 70px; left: 0; right: 0; bottom: 0;
                    background-image: url('<?php echo base_url(); ?>img/provedores/valorh.png');
                    background-size: 100px; background-position: center;
                    opacity: 0.9; z-index: 1; background-repeat: no-repeat;"></div>
                          <!-- Contenido de texto que no se ve afectado por la opacidad -->
                          <p class="modal-key-card-text" style="position: relative; z-index: 2;">Evaluaciones</p>
                        </div>
                        <div class="modal-key-card-footer">
                          Fomentando un ambiente laboral positivo.
                          Clima Laboral.
                          Desempeño.
                        </div>
                      </div>
                    </a>
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

        <script>
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



        // Funcionalidad para eliminar el logo usando AJAX
        $("#deleteLogo").on("click", function() {
          // Confirmación con SweetAlert2
          Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción no puede deshacerse!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
            if (result.isConfirmed) {
              // Hacemos la solicitud AJAX para eliminar el logo
              $.ajax({
                url: '<?php echo base_url(); ?>Area/eliminarLogo', // Archivo PHP que manejará la eliminación
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                  if (response.success) {
                    // Mostrar mensaje de éxito con SweetAlert2
                    Swal.fire(
                      '¡Eliminado!',
                      'El logo ha sido eliminado exitosamente.',
                      'success'
                    );
                    setTimeout(function() {
                      window.location.reload(); // Recarga la página
                    }, 1000);
                    $('#updateLogoModal').modal('hide'); // Cierra el modal
                    // Aquí puedes actualizar la vista o cerrar el modal
                    document.getElementById("currentLogoContainer").style.display = "none";
                  } else {
                    // Mostrar mensaje de error con SweetAlert2
                    Swal.fire(
                      'Error',
                      'Hubo un error al eliminar el logo.',
                      'error'
                    );
                  }
                },
                error: function(xhr, status, error) {
                  // Mostrar mensaje de error con SweetAlert2
                  Swal.fire(
                    'Error',
                    'Ocurrió un error al intentar eliminar el logo.',
                    'error'
                  );
                }
              });
            }
          });
        });


        // Funcionalidad del botón "Guardar Logo"
        document.getElementById('saveLogo').addEventListener('click', function() {
          const fileLogo = document.getElementById('fileLogo');
          const file = fileLogo.files[0];

          if (file) {
            // Aquí puedes enviar la imagen al servidor para guardarla, o actualizar el logo en el front-end
            const formData = new FormData();
            formData.append('fileLogo', file); // Asegúrate de que el nombre del campo sea 'logo'

            // Usando jQuery para enviar la solicitud AJAX
            $.ajax({
              url: '<?php echo base_url(); ?>Area/updateLogo', // URL de tu controlador en CodeIgniter
              type: 'POST',
              data: formData,
              contentType: false, // No se establecerá el tipo de contenido, porque estamos enviando datos de tipo FormData
              processData: false, // No procesar los datos automáticamente
              success: function(data) {
                // Si todo fue bien, actualizar el logo en la página
                const response = JSON.parse(data); // Parsear la respuesta JSON

                if (response.success) {
                  // Actualiza el logo en el sidebar
                  $('#updateLogoModal').modal('hide'); // Cierra el modal

                  // Mostrar mensaje de éxito con SweetAlert2
                  Swal.fire({
                    icon: 'success',
                    title: 'Logo actualizado',
                    text: 'El logo se ha actualizado correctamente.',
                  });
                  setTimeout(function() {
                    window.location.reload(); // Recarga la página
                  }, 1000);
                } else {
                  // Mostrar mensaje de error con SweetAlert2
                  Swal.fire({
                    icon: 'error',
                    title: 'Error al actualizar el logo',
                    text: response.message || 'Hubo un problema al intentar actualizar el logo.',
                  });
                }
              },
              error: function(xhr, status, error) {
                // Si hay un error en la solicitud AJAX
                console.error('Error:', error);
                Swal.fire({
                  icon: 'error',
                  title: 'Error al actualizar el logo',
                  text: 'Hubo un problema al intentar actualizar el logo.',
                });
              }
            });
          } else {
            Swal.fire({
              icon: 'warning',
              title: 'Sin archivo',
              text: 'Por favor, selecciona una imagen para el logo.',
            });
          }
        });

        // Al hacer clic en el botón
        $('#enviarNotificacionesBtn').on('click', function() {
          $.ajax({
            url: '<?php echo base_url("Notificacion/enviar_notificaciones_inmediatamente"); ?>', // Ruta a la función
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
        </script>