<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Panel de Control | RODI</title>
	<!-- CSS -->
	<?php echo link_tag("css/custom.css"); ?>
	<?php echo link_tag("css/sb-admin-2.min.css"); ?>
	<!-- DataTables -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<!-- FullCalendar -->
	<!--<link href='<?php echo base_url(); ?>calendar/css/fullcalendar.css' rel='stylesheet' >
	<!-- Favicon -->
	<link rel="icon" type="image/jpg" href="<?php echo base_url() ?>img/favicon.jpg" sizes="64x64">
	<!-- Select Bootstrap -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
	<!-- Sweetalert 2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">
	<!-- Bootstrap core JavaScript-->
	<script src="<?php echo base_url() ?>vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url() ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Animate -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url() ?>vendor/jquery-easing/jquery.easing.min.js"></script>
	<!-- Page level plugins -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script src="<?php echo base_url() ?>js/chart.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>


  <!-- <script src="https://js.pusher.com/7.2/pusher.min.js"></script> -->


</head>

<body id="page-top">
    <!-- JavaScript -->
   

  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" >
       
          <img width="100px" src="<?php echo base_url(); ?>img/portal_icon.png">
        
       
      </a>
      <h2 class="text-white text-center font-weight-bold">TalentSafe Control</h2>      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Dashboard -->
      <?php 
			if(in_array(1, $submenus)){ ?>
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo site_url('Dashboard/index') ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <?php
			}?>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Manual de Usuario -->
      <!-- ?php 
			if(in_array(30, $submenus)){ ?>
      <li class="nav-item">
        <a class="nav-link" href="< ?php echo site_url('Manual/index') ?>">
          <i class="fas fa-book"></i>
          <span>Manual de usuario</span></a>
      </li>
      < ?php
			}? -->

      <!-- Clientes -->
      <?php 
			if(in_array(2, $submenus)){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseClientes"
          aria-expanded="true" aria-controls="collapseClientes">
          <i class="fas fa-fw fa-users"></i>
          <span>Clientes</span>
        </a>
        <div id="collapseClientes" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php
									if($permisos){
										foreach($permisos as $p){ 
											echo "<a class='collapse-item contraer' data-toggle='tooltip' data-placement='right' title='".$p->nombreCliente."' href='".site_url("$p->url")."'>".$p->nombreCliente."</a>";
										} 
									} 
							?>
          </div>
        </div>
      </li>
      <?php       
			} ?>

      <!-- Reclutamiento -->
      <?php 
			if(in_array(14, $submenus)){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReclutamiento"
          aria-expanded="true" aria-controls="collapseReclutamiento">
          <i class="fas fa-handshake"></i>
          <span>Reclutamiento</span>
        </a>
        <div id="collapseReclutamiento" class="collapse" aria-labelledby="headingUtilities"
          data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php 
							if(in_array(15, $submenus)){ ?>
            <a class="collapse-item" href="<?php echo site_url('Reclutamiento/requisicion') ?>">Requisiciones</a>
            <?php
							}
              if(in_array(28, $submenus)){ ?>
            <a class="collapse-item" href="<?php echo site_url('Reclutamiento/bolsa') ?>">Bolsa de Trabajo</a>
            <?php
							}
							if(in_array(18, $submenus)){ ?>
            <a class="collapse-item" href="<?php echo site_url('Reclutamiento/control') ?>">En proceso</a>
            <?php
							}  
							if(in_array(19, $submenus)){ ?>
            <a class="collapse-item" href="<?php echo site_url('Reclutamiento/finalizados') ?>">Finalizados</a>
            <?php
							}
               ?>
          </div>
        </div>
      </li>
      <?php 
			} ?>


      <!-- Doping -->
      <?php       
			if(in_array(3, $submenus)){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDoping" aria-expanded="true"
          aria-controls="collapseDoping">
          <i class="fas fa-fw fa-eye-dropper"></i>
          <span>Doping</span>
        </a>
        <div id="collapseDoping" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php 
							if(in_array(4, $submenus)){ ?>
            <a class="collapse-item" href="<?php echo site_url('Doping/indexGenerales') ?>">Registros generales</a>
            <?php
							}
							if(in_array(23, $submenus)){ ?>
            <a class="collapse-item" href="<?php echo site_url('Doping/indexPendientes') ?>">Registros pendientes</a>
            <?php
							}
							if(in_array(24, $submenus)){ ?>
            <a class="collapse-item" href="<?php echo site_url('Doping/indexFinalizados') ?>">Finalizados</a>
            <?php
							} ?>
          </div>
        </div>
      </li>
      <?php 
			} ?>

      <!-- Laboratorio -->
      <?php       
			if(in_array(20, $submenus)){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLab" aria-expanded="true"
          aria-controls="collapseLab">
          <i class="fas fa-flask"></i>
          <span>Laboratorio</span>
        </a>
        <div id="collapseLab" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php 
							if(in_array(22, $submenus)){ ?>
            <a class="collapse-item" href="<?php echo site_url('Medico/index') ?>">Examen médico</a>
            <?php
							}
							if(in_array(32, $submenus)){ ?>
            <a class="collapse-item" href="<?php echo site_url('Covid/index') ?>">Pruebas COVID</a>
            <?php
							} 
							if(in_array(21, $submenus)){ ?>
            <a class="collapse-item" href="<?php echo site_url('Laboratorio/sanguineo') ?>">Grupo sanguíneo</a>
            <?php
							} ?>
          </div>
        </div>
      </li>
      <?php 
			} ?>

      <!-- Catalogos -->
      <?php
			if(in_array(5, $submenus)){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCatalogos"
          aria-expanded="true" aria-controls="collapseCatalogos">
          <i class="fas fa-fw fa-folder"></i>
          <span>Catálogos</span>
        </a>
        <div id="collapseCatalogos" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
          <?php 
							if(in_array(40, $submenus)){ ?>
            <a class="collapse-item" href="<?php echo site_url('Cat_UsuarioInternos/index') ?>">Usuarios</a>
            <?php
							} ?>
            <?php 
							if(in_array(6, $submenus)){ ?>
            <a class="collapse-item" href="<?php echo site_url('Cat_Cliente/index') ?>">Clientes</a>
            <?php
							} ?>
            <?php 
							if(in_array(7, $submenus)){ ?>
            <a class="collapse-item" href="<?php echo site_url('Cat_Subclientes/index') ?>">Subclientes</a>
            <?php
							} ?>
            
           /*   <!-- ?php 
							if(in_array(8, $submenus)){ ?>
            <a class="collapse-item" href="< ?php echo site_url('Cat_Puestos/index') ?>">Puestos</a>
            < ?php
							} ? --> 
          </div>
        </div>
      </li>
      <?php 
			}
			?>

      <!-- Reportes -->
      <?php
			if(in_array(9, $submenus)){ ?>
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
							if(in_array(25, $submenus)){ ?>
            <a class="collapse-item contraer" data-toggle="tooltip" data-placement="right" title="Listado de Clientes"
              href="<?php echo site_url('Reporte/listado_clientes_index') ?>">Listado de Clientes</a>
            <?php
							}
              if(in_array(29, $submenus)){ ?>
            <a class="collapse-item contraer" data-toggle="tooltip" data-placement="right"
              title="Proceso de reclutamiento"
              href="<?php echo site_url('Reporte/proceso_reclutamiento_index') ?>">Proceso de reclutamiento</a>
            <?php
							} ?>
          </div>
        </div>
      </li>
      <?php 
			}
			?>

      <!-- Control -->
      <?php
			if(in_array(17, $submenus)){ ?>
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
            <a class="collapse-item" href="<?php echo site_url('Reporte/listado_doping_index') ?>">Listado de Doping</a>
            <?php
							} */?>
          </div>
        </div>
      </li>
      <?php 
			}
			?>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <div id="divAlertaNotificacion"></div>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1" style="font-size: 1.3rem;" id="iconoNotificaciones">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <?php 
										if(isset($contadorNotificaciones)){
											$displayContador = ($contadorNotificaciones > 0) ? 'inital' : 'none'; ?>
                <span class="badge badge-danger badge-counter" id="contadorNotificaciones"
                  style="display: <?php echo $displayContador; ?> "> <?php echo $contadorNotificaciones ?></span>
                <?php 
										} ?>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Notificaciones
                </h6>
                <div id="contenedorNotificaciones" style="height: 40rem;overflow-y: auto;"></div>
                <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> -->
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span
                  class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $this->session->userdata('nombre')." ".$this->session->userdata('paterno'); ?></span>
                <img class="img-profile rounded-circle" src="<?php echo base_url(); ?>img/user.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <!--a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a-- class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a-->
                <!-- <a class="dropdown-item" href="#" onclick="editarPerfil()">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Editar perfil
                </a> -->
                <!-- <div class="dropdown-divider"></div> -->
                <a class="dropdown-item" href="<?php echo base_url(); ?>Login/logout">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cerrar sesión
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->