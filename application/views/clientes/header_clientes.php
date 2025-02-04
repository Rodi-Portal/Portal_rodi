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

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Poppins:wght@600&display=swap" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Font Awesome -->
  <link href="<?php echo base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <script src="https://kit.fontawesome.com/fdf6fee49b.js" crossorigin="anonymous"></script>

  <!-- Bootstrap -->
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">

  <!-- Animations -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css">
  <?php echo link_tag("css/sb-admin-2.min.css"); ?>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
  </script>


  <!-- Easing Plugin -->
  <script src="<?php echo base_url(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.all.min.js"></script>



  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

  <script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.js"></script>
  <script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.extensions.js"></script>
</head>


<body id="page-top">
  <!-- JavaScript -->
  <?php
/*echo $modalCliente;
echo '<pre>';
print_r($cliente);
echo '</pre>';*/
$id_cliente = $this->session->userdata('idcliente');
/*echo '<pre>';
echo $procesosActuales[0]->url;
print_r($procesosActuales);
echo '</pre>';*/

?>

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
      <a class="nav-link" id="recruitment-btn" href="javascript:void(0);" onclick="loadSection('seccion-recruitment', '<?php echo site_url('Cliente_General/descripcionesCliente/1'); ?>')">
            <i class="fas fa-users"></i> Reclutamiento
        </a>


      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <li class="nav-item">
      <a class="nav-link" id="pre-employment-btn" href="javascript:void(0);" onclick="loadSection('seccion-pre-employment', '<?php echo site_url('Cliente_General/descripcionesCliente/2'); ?>')">
            <i class="fas fa-user-clock"></i> Preempleo
        </a>

      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <li class="nav-item">
      <a class="nav-link" id="employees-btn" href="javascript:void(0);" onclick="loadSection('seccion-employees', '<?php echo site_url('Cliente_General/descripcionesCliente/3'); ?>')">
            <i class="fas fa-user-check"></i> Empleados
        </a>

      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <li class="nav-item">
      <a class="nav-link" id="former-employees-btn" href="javascript:void(0);" onclick="loadSection('seccion-former-employees', '<?php echo site_url('Cliente_General/descripcionesCliente/4'); ?>')">
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
                <a id="recruitment-btn" href="javascript:void(0);" onclick="loadSection('seccion-recruitment', '<?php echo site_url('Cliente_General/descripcionesCliente/1'); ?>')" class="btn custom-btn">
                  <i class="fas fa-users"></i> <!-- Icono de FontAwesome para Recruitment -->
                  Reclutamiento
                </a>
                <a id="pre-employment-btn" href="javascript:void(0);" onclick="loadSection('seccion-pre-employment', '<?php echo site_url('Cliente_General/descripcionesCliente/2'); ?>')"

                
                  class="btn custom-btn">
                  <i class="fas fa-user-clock"></i> <!-- Icono de FontAwesome para Pre-employment -->
                  Preempleo
                </a>
                <a id="employment-btn" href="javascript:void(0);" onclick="loadSection('seccion-employees', '<?php echo site_url('Cliente_General/descripcionesCliente/3'); ?>')" class="btn custom-btn">
                  <i class="fas fa-briefcase"></i> <!-- Icono de FontAwesome para Employee -->
                  Empleados
                </a>
                <a  id="former-employees-btn" href="javascript:void(0);" onclick="loadSection('seccion-former-employees', '<?php echo site_url('Cliente_General/descripcionesCliente/4'); ?>')"
                  class="btn custom-btn">
                  <i class="fas fa-user-times"></i> <!-- Icono de FontAwesome para Former employee -->
                  Exempleados
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

        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <ul class="navbar-nav d-flex flex-row w-100">
            <li class="nav-item custom-menu" style="flex: 1;">
              <a class="btn custom-btn" href="javascript:void(0)" onclick="showSection('panel-inicio')">
                <i class="fas fa-list-ol"></i>
                <span class="d-none d-md-inline">Requisiciones</span>
              </a>

              <a class="btn custom-btn" href="javascript:void(0)" onclick="showSection('seccion-bgv')">
                <i class="fas fa-chart-line"></i>
                <span class="d-none d-md-inline">Candidatos BGV</span>
              </a>
            </li>
            <!--//TODO: boton para en un futuro poder ver las requisiciones finalizadas actualmente sin funcionamiento -->
            <!--li class="nav-item">
        <a class="nav-link text-light active" href="javascript:void(0)" onclick="openHistory()">
          <i class="fas fa-history"></i>
          <span class="d-none d-md-inline">< ?php echo $translations['menu_historial_candidatos']; ?></span>
        </a>
      </li -->
            <!-- <li class="nav-item">
        <a class="nav-link text-light active" href="javascript:void(0)" onclick="openUsers()">
          <i class="fas fa-users"></i>
          <span class="d-none d-md-inline">< ?php //echo $translations['menu_usuarios']; ?></span>
        </a>
      </li> -->

          </ul>
        </nav>

        <div id="panel-agregar-candidato" class="dynamic-section" style="display: none;"></div>
        <div id="seccion-bgv" class="dynamic-section" style="display: none;"></div>
        <div id="panel-inicio" class="dynamic-section"></div>
        <div id="panel-historial" class="dynamic-section" style="display: none;"></div>
        <div id="seccion-recruitment" class="dynamic-section"></div>
        <div id="seccion-pre-employment" class="dynamic-section"></div>
        <div id="seccion-employees" class="dynamic-section"></div>
        <div id="seccion-former-employees" class="dynamic-section"></div>
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
                      ')" class="dropdown-item"><i class="fas fa-comment-dots"></i> <?php echo $translations['proceso_accion_ver_comentarios'] ?> </a></li><li><a href="javascript:void(0)" data-toggle="tooltip" title="Files" onclick="viewFiles(' +
                      data +
                      ')" class="dropdown-item"><i class="fas fa-folder"></i> <?php echo $translations['proceso_accion_archivos'] ?></a></li></ul></div></div>'
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
                let cvLink = (resp.cv != null) ?
                  '<a href="<?php echo base_url(); ?>_docs/' + resp.cv +
                  '" target="_blank" class="btn btn-link text-primary" data-toggle="tooltip" title="Ver CV/Solicitud"><i class="fas fa-file-alt"></i></a>' :
                  '<button type="button" class="btn btn-link text-primary" onclick="mostrarFormularioCargaCV(' +
                  resp
                  .id_ra +
                  ')"><i class="fas fa-exclamation-circle"></i></button>';


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

        function openDetailss(requisicion_id) {
          $('.div-candidato').removeClass('card-proceso-active');
          $('#div-candidato' + requisicion_id).addClass('card-proceso-active');
          $.ajax({
            url: '<?php echo base_url('Cliente/get_requisicion_details'); ?>',
            method: 'POST',
            data: {
              'requisicion_id': requisicion_id,
            },
            beforeSend: function() {
              $('.loader').css("display", "block");
            },
            success: function(res) {

              let data = JSON.parse(res);
              let tbody = '';
              data.data.forEach(function(resp) {

                let cvLink = (resp.cv != null) ? '<a href="<?php echo base_url(); ?>_docs/' + resp.cv +
                  '" target="_blank" class="dropdown-item" data-toggle="tooltip" title="Ver CV/Solicitud"><i class="fas fa-eye"></i> Ver CV/Solicitud</a>' :
                  '<button type="button" class="dropdown-item" onclick="mostrarFormularioCargaCV(' + resp
                  .id_ra +
                  ')">Cargar CV/Solicitud</button>';
                tbody += '<tr>';
                tbody += '<td>' + resp.id + '</td>';
                tbody += '<td>' + resp.nombre_aspirante + '</td>';
                tbody += '<td>' + resp.medio_contacto + '</td>';
                tbody += '<td>';
                tbody += '<div class="btn-group">';
                tbody +=
                  '<button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">';
                tbody += 'Acciones';
                tbody += '</button>';
                tbody += '<ul class="dropdown-menu">';
                tbody +=
                  '<li><button type="button" class="dropdown-item" id="ver_historial" onclick="verHistorial(' +
                  resp.id_ra + ', \'' + resp.nombre_aspirante +
                  '\')">Movimientos del Aspirante</button></li>';
                tbody +=
                  '<li><button type="button" class="dropdown-item comentarios-reclutador-btn"  onclick="verHistorialMovimientos(\'' +
                  resp.nombre_aspirante + '\', \'' + resp.id_ra + '\')">Comentarios Reclutador</button>';
                tbody +=
                  '<li>' + cvLink + '</li>';
                // Agrega más opciones de modales dentro del dropdown según necesites
                tbody += '</ul>';
                tbody += '</div>';
                tbody += '</td>';
              });
              $('#dataTable tbody').html(tbody);
              $('#dataTable').DataTable(); // Inicializa el DataTable
              setTimeout(function() {
                $('.loader').fadeOut();
              }, 200);
            }
          });

        }

        function openProcedures() {
          // Recargar la página
          window.location.reload();
        }

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
          //loadSection('seccion-bgv', "<?php echo base_url('Cliente_General/indexCliente'); ?>");
          loadSection('panel-inicio', "<?php echo base_url('Dashboard/client'); ?>");
        });

        // Función para cargar contenido en las secciones
        function loadSection(sectionIdToShow, url, data = {}) {
          if ($('#' + sectionIdToShow).length) {
            // Ocultar todas las secciones dinámicas
            $('.dynamic-section').hide();

            // Comprobar si el contenido ya está cargado en la sección
            if ($('#' + sectionIdToShow).html() === '') {
              $.ajax({
                url: url,
                method: "GET",
                data: data,
                success: function(response) {
                  
                  // Cargar contenido en la sección específica
                  $('#' + sectionIdToShow).html(response).show();
                },
                error: function(xhr) {
                  console.error(`Error al cargar la sección: ${xhr.responseText}`);
                }
              });
            } else {
              // Si ya está cargada, simplemente mostrarla
              $('#' + sectionIdToShow).show();
            }
          } else {
            console.error(`El elemento con el id ${sectionIdToShow} no se encontró en el DOM.`);
          }
        }

        // Funciones para mostrar u ocultar las secciones según sea necesario
        function showSection(sectionIdToShow) {
          // Ocultar todas las secciones
          $('.dynamic-section').hide();
          // Mostrar la sección solicitada
          $('#' + sectionIdToShow).show();
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