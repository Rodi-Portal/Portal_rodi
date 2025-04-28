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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <!--script src="< ?php echo base_url() ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script -->
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
  <div id="rutas" data-baseimg="<?php echo base_url('img/provedores');?>"
    data-imgdefault="<?php echo base_url('_logosPortal/portal_icon.png');?>">
  </div>

  <?php

      $idRol        = $this->session->userdata('idrol');
      $logo         = $this->session->userdata('logo');
      $aviso_actual = $this->session->userdata('aviso');
      $archivo      = $aviso_actual ? $aviso_actual : 'AV_TL_V1.pdf';
  ?>


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
      <?php if ($idRol == 1 || $idRol == 6) {?>
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
            <?php if ($idRol == 1 || $idRol == 6) {?>
            <a class="collapse-item" href="javascript:void(0);" data-toggle="modal" data-target="#updateLogoModal">
              <i class="fas fa-image fa-sm fa-fw mr-2 text-gray-400"></i>
              Actualizar Logo
            </a>
            <a class="collapse-item" href="javascript:void(0);" data-toggle="modal" data-target="#updateAvisoModal">
              <i class="fas fa-user-shield fa-sm fa-fw mr-2 text-gray-400"></i>
              Aviso de Privacidad
            </a>
            <a class="collapse-item" href="<?php echo base_url(); ?>Area/pasarela">
              <i class="fas fa-credit-card fa-sm fa-fw mr-2 text-gray-400"></i>
              Pago/Suscripción
            </a>
            <?php }?>
            <a class="collapse-item" href="<?php echo base_url(); ?>Login/logout">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Cerrar sesión
            </a>
          </div>
        </div>
      </li>
      <?php }?>
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
        <a id="former-employment-btn" href="<?php echo site_url('Empleados/index') ?>" class="nav-link ">
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
      if (in_array(5, $submenus) || ($idRol == 1 || $idRol == 6 || $idRol == 9 || $idRol == 11 || $idRol == 4)) {?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCatalogos"
          aria-expanded="true" aria-controls="collapseCatalogos">
          <i class="fas fa-fw fa-folder"></i>
          <span>Registrar</span>
        </a>
        <div id="collapseCatalogos" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php
            if ($idRol == 1 || $idRol == 6 || $idRol == 9 ) {?>
            <a class="collapse-item" href="<?php echo site_url('Cat_UsuarioInternos/index') ?>">Usuarios
              Administradores</a>
            <?php
            }?>
            <?php
if ($idRol == 1 || $idRol == 6 || $idRol == 9 || $idRol == 11) {?>
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
      if ($portal == 1 && ($idRol == 1 || $idRol == 6)) {?>
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
                <a id="former-actividades-btn" href="#" class="btn custom-btn former-actividades-btn">
                  <div class="module-label">Módulo</div>
                  <div class="btn-content">
                    <!-- Contenedor para el ícono y texto -->
                    <i class="fas fa-calendar-alt"></i> <!-- Icono de FontAwesome para Former employee -->
                    Actividades
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
                  style="display:                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php echo $displayContador; ?>;"><?php echo $contadorNotificaciones ?></span>
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
              <a class="nav-link icono-dorado text-center" href="#" role="button" data-toggle="modal"
                data-target="#modalKey" data-bs-toggle="tooltip" data-bs-placement="top" title="Proveedores destacados"
                style="line-height: 1.2; display: flex; flex-direction: column; align-items: center; padding: 0; margin: 0;">

                <div style="font-size: 9px; font-weight: bold; color: #000; margin: 0; padding: 0;">Proveedores</div>
                <i class="fas fa-key fa-fw icono-dorado" style="font-size: 20px; margin: 0; padding: 0;"></i>
                <div style="font-size: 9px; font-weight: bold; color: #000; margin: 0; padding: 0;">Destacados</div>

              </a>
            </li>


            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <!--li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"
                  style="font-size: 12px;">< ?php echo $this->session->userdata('nombre') . " " . $this->session->userdata('paterno'); ?></span>
                <img class="img-profile rounded-circle" src="< ?php echo base_url(); ?>img/user.png">
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                < ?php if ($idRol == 1 || $idRol == 6) {?>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#updateLogoModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Actualizar Logo
                </a>
                <a class="dropdown-item" href="< ? php echo base_url(); ?>Area/pasarela">

                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Suscripción
                </a>
                < ?php }?>
                <a class="dropdown-item" href="< ?php echo base_url(); ?>Login/logout">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cerrar sesión
                </a>
              </div>
            </li -->
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

        <!-- Modal -->
        <div class="modal fade" id="updateAvisoModal" tabindex="-1" role="dialog"
          aria-labelledby="updateAvisoModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form id="form_aviso" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Actualizar Aviso de Privacidad</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">
                  <div class="form-group">
                    <label for="avisoPrivacidad">Selecciona el archivo PDF:</label>
                    <input type="file" class="form-control-file" id="avisoPrivacidad" name="aviso"
                      accept="application/pdf">
                  </div>

                  <div
                    class="alert                                                                                                                                                                                                                                                                                                                           <?php echo $aviso_actual ? 'alert-info' : 'alert-warning' ?>">
                    <?php echo $aviso_actual
                        ? 'Archivo actual:'
                    : 'No se encontró un aviso cargado. Se usará este  aviso por defecto:' ?>


                    <a href="<?php echo base_url('Avance/ver_aviso/' . $archivo); ?>" target="_blank">
                      Ver aviso
                    </a>

                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalKey" tabindex="-1" role="dialog" aria-labelledby="modalKeyLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-header custom-header" >
            <h5 class="modal-title" id="modalKeyLabel" style="color: #ffffff !important;">Proveedores Destacados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row text-center" id="proveedores-container">
                  <!-- Los proveedores se cargarán aquí mediante AJAX -->
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

        <!--Modal Formulario  para  provedores Destacados -->
        <div class="modal fade" id="modalFormulario" tabindex="-1" role="dialog" aria-labelledby="modalFormularioLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form id="formContactoProveedor">
              <div class="modal-header custom-header">
              <h5 class="modal-title" id="modalFormularioLabel" style="color: #ffffff !important;">Solicitar contacto</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p id="textoProveedorSeleccionado"></p>
                  <input type="hidden" id="proveedorId" name="proveedor_id">

                  <div class="form-group">
                    <label for="nombreContacto">Nombre de contacto</label>
                    <input type="text" class="form-control" id="nombreContacto" name="nombre_contacto" required>
                  </div>

                  <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" required>
                  </div>

                  <div class="form-group">
                    <label for="correo">Correo electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo" required>
                  </div>

                  <div class="form-group">
                    <label for="descripcion">Descripción de la solicitud</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                  </div>

                  <div class="alert alert-info">
                    Estos datos serán enviados a la empresa para que puedan ponerse en contacto contigo.
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Enviar solicitud</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <script>
        const rutasEl = document.getElementById('rutas');
        const rutaBaseImagen = rutasEl.dataset.baseimg;
        const rutaImagenDefault = rutasEl.dataset.imgdefault;


        // funcionalidad  para   Actualizar el logo en vista
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

        // Aviso  modulo Actividades  en construccion
        document.addEventListener("DOMContentLoaded", function() {
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
        // Funcionalidad cargar Aviso usando AJAX
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

        // Funcionalidad para cargar los proveedores cuando se abre el modal
        $('#modalKey').on('shown.bs.modal', function() {
          $.ajax({
            url: '<?php echo site_url('Avance/get_proveedores'); ?>',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
              $('#proveedores-container').empty();

              const colores = [
                '#98FD52', '#FB8C00', '#3949AB', '#43A047', '#6D4C41', '#00897B',
                '#8E24AA', '#5E35B1', '#1976D2', '#E53935', '#00ACC1', '#D81B60',
                '#FCF890', '#FDD835', '#C0CA33'
              ];

              $.each(data, function(index, proveedor) {
                const colorFondo = colores[index % colores.length];

                // Reemplazo en descripcion1 con banderitas
                let texto = proveedor.descripcion1 || "";
                texto = texto.replace("[flag]", "🏳️ ").replace("[/flag]", " 🏳️");

                const imagenUrl = proveedor.imagen && proveedor.imagen !== '' ?
                  `${rutaBaseImagen}/${proveedor.imagen}` :
                  `${rutaImagenDefault}`;
// cambiar <a href="  a #  para que se muestre  el formulario modalFormulario
                var proveedorCard = `
                <div class="col-md-4 modal-key-col">
                  <a href="${proveedor.url1}" 
                    class="btn-contactar"
                    data-nombre="${proveedor.nombre}"
                    data-url="${proveedor.url1}"
                    data-id="${proveedor.id}"
                    data-toggle="modal"
                    data-target="#">
                    
                  
                <div class="modal-key-card">
                  <div class="modal-key-card-header" style="background-color: ${colorFondo}; color: #fff;">
                    ${proveedor.nombre}
                  </div>
                <div class="modal-key-card-body" style="position: relative; padding: 0; margin: 0;">
                    <div style="
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background-image: url('${imagenUrl}');
                        background-size: 140px;
                        background-position: center center;
                        background-repeat: no-repeat;
                        opacity: 0.9;
                        z-index: 1;">
                    </div>
                </div>
                        <div class="modal-key-card-footer"><strong>${texto}</strong></div>
                        <div class="modal-key-card-footer"><p>${proveedor.descripcion}</p></div>
                </div>
                </a>
              </div>
              `;

                $('#proveedores-container').append(proveedorCard);
              });
            },
            error: function(xhr, status, error) {
              console.error("Error al cargar los proveedores: " + error);
            }
          });
        });




        // Abrir  formulario  de  contacto proveedores destacados
        $(document).on('click', '.btn-contactar', function(e) {
          e.preventDefault();

          const nombre = $(this).data('nombre');
          const id = $(this).data('id');
          const url = $(this).data('url');

          $('#textoProveedorSeleccionado').text(`Estás contactando a: ${nombre}`);
          $('#proveedorId').val(id);
        });

        // enviar  formulario Proveedores destacados
        $('#formContactoProveedor').on('submit', function(e) {
          e.preventDefault();

          $.ajax({
            url: '<?php echo base_url('proveedores/enviar_contacto') ?>',
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
              alert('¡Solicitud enviada con éxito!');
              $('#modalFormulario').modal('hide');
              $('#formContactoProveedor')[0].reset();
            },
            error: function() {
              alert('Ocurrió un error. Intenta más tarde.');
            }
          });
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