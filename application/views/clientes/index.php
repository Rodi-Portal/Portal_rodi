<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client's Panel | RODI</title>

  <!-- Preconnect -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

  <!-- Bootstrap 5.2.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Select2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/custom.css">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?php echo base_url(); ?>img/favicon.jpg" />
</head>

<body>
  <!-- Your content goes here -->

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>

  <!-- Bootstrap 5.3.0 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- FontAwesome -->
  <script src="https://kit.fontawesome.com/fdf6fee49b.js"></script>

  <!-- Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.all.min.js"></script>

  <!-- Se imprimen los modals -->
  <?php echo $modals;
/*echo $modalCliente;
echo '<pre>';
print_r($cliente);
echo '</pre>';*/
$id_cliente = $this->session->userdata('idcliente');
/*echo '<pre>';
echo $procesosActuales[0]->url;
print_r($procesosActuales);
echo '</pre>';*/
$cliente = $procesosActuales[0] ?? null;
?>

  <header>
    <nav class="navbar navbar-dark" style="background-color: #0a39a6;">
      <a class="navbar-brand" href="javascript:void(0)">
        <img src="<?php echo base_url(); ?>img/portal_icon.png" width="40" height="35"
          class="d-inline-block align-top ms-1" alt="RODI">
        <h5 class="d-inline d-none d-sm-inline text-wrap">
          <?php echo $this->session->userdata('nombre') . ' ' . $this->session->userdata('paterno') ?>
        </h5>
      </a>
      <ul class="nav justify-content-end">
        <li class="nav-item">
          <a class="nav-link text-light active" href="javascript:void(0)" onclick="openProcedures()">
            <i class="fas fa-list-ol"></i>
            <span class="d-none d-md-inline"><?php echo $translations['menu_inicio_candidatos']; ?></span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light active" href="javascript:void(0)"
            onclick="loadClientView(<?php echo $id_cliente; ?>)">
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
        <li class="nav-item">
          <a class="nav-link text-light active" href="<?php echo base_url(); ?>Login/logout">
            <i class="fas fa-sign-out-alt"></i>
            <span class="d-none d-md-inline"><?php echo $translations['cerrar_sesion']; ?></span>
          </a>
        </li>
      </ul>
    </nav>
  </header>

  <div class="loader" style="display: none;"></div>

  <div class="contenedor mt-5 my-5 hidden" id="panel-historial">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h4 class="m-0 font-weight-bold text-center txt-color-principal"><?php echo $translations['titulo_tabla'] ?>
        </h4>
      </div>
      <div class="card-body">
        <div class="table-responsive-sm mb-5">
          <table id="lista_candidatos" class="table table-hover" width="100%"></table>
        </div>
      </div>
    </div>
  </div>
  <div id="content">
    <div id="panel-inicio">
      <div class="d-flex justify-content-center flex-column flex-md-row flex-lg-row mt-5 panel-inicio">
        <div class="card shadow div1 flex-fill">
          <div class="card-body">
            <div class="d-flex flex-column flex-sm-row justify-content-around align-items-baseline">
              <?php $totalRequisiciones = (!empty($procesosActuales)) ? count($procesosActuales) : 0?>
              <h4 class="text-wrap">
                <?php echo $translations['proceso_titulo'] . ': <b>' . $totalRequisiciones . '</b>' ?></h4>
            </div>
            <button type="button" class="btn btn-primary btn-sm" onclick="loadPageInSection()">
              <i class="fas fa-plus"></i> <?php echo $translations['accion_nueva_requisicion']; ?>
            </button>
            <hr>
            <?php if (!empty($procesosActuales)) {
            foreach ($procesosActuales as $proceso) {
                $idioma = ($proceso->ingles == 1) ? 'ingles' : 'espanol';
                $status = ($proceso->statusReq > 1) ? 
                    '<label>' . $translations['proceso_status'] . ': <b>Iniciada</b></label><br>' : 
                    '<label>' . $translations['proceso_status'] . ': <b>Pendiente</b></label><br>';

                $observaciones = ($proceso->ingles == 1) ? 
                    '<small>Observations: <b>' . $proceso->observaciones . '</b></small><br>' : 
                    '<small>Observaciones: <b>' . $proceso->observaciones . '</b></small><br>';

                $numeroVacantes = ($proceso->ingles == 1) ? 
                    '<small>Vacantes: <b>' . $proceso->numero_vacantes . '</b></small><br>' : 
                    '<small>Vacantes: <b>' . $proceso->numero_vacantes . '</b></small><br>';

                $zona = ($proceso->ingles == 1) ? 
                    '<small>Zona de trabajo: <b>' . $proceso->zona_trabajo . '</b></small><br>' : 
                    '<small>Zona de trabajo: <b>' . $proceso->zona_trabajo . '</b></small><br>';

                $experiencia = ($proceso->ingles == 1) ? 
                    '<small>Experiencia: <b>' . $proceso->experiencia . '</b></small><br>' : 
                    '<small>Experiencia: <b>' . $proceso->experiencia . '</b></small><br>';
                ?>
            <div class="card-proceso position-relative div-candidato" id="div-candidato<?php echo $proceso->idReq ?>">
              <div class="card-title" onclick="openDetails(<?php echo $proceso->idReq ?>)">
                <span class="badge text-bg-dark">Nombre de la vacante</span>
                <h4 class="d-inline align-middle"><b><?php echo $proceso->puesto ?></b></h4><br>
                <?php echo $status; ?>
                <?php echo $observaciones; ?>
                <?php echo $numeroVacantes; ?>
                <?php echo $zona; ?>
                <?php echo $experiencia; ?>
                <div>
                  <span class="badge text-bg-info">Sueldo Mínimo: <?php echo $proceso->sueldo_minimo ?></span>
                  <span class="badge text-bg-info">Sueldo Máximo: <?php echo $proceso->sueldo_maximo ?></span>
                </div>
                <p class="text-muted text-end">
                  <?php echo $translations['proceso_fecha_registro'] . ': ' . fechaTexto($proceso->creacion, $idioma) ?>
                </p>
              </div>
            </div>
            <hr>
            <?php }
        } else { ?>
            <div class="card">
              <div class="card-body text-center">
                <?php echo $translations['proceso_sin_candidatos'] ?>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
        <div class="card shadow div2 flex-fill">
          <div class="card-body">
            <button type="button" class="btn btn-secondary btn-sm d-block d-md-none" onclick="goBack()">
              <i class="fas fa-arrow-left"></i> Back
            </button>
            <div id="dataTableContainer">
              <table id="dataTable" class="table table-striped">
                <thead>
                  <tr>
                    <th class="d-none d-md-table-cell">ID</th>
                    <th>Aspirante</th>
                    <th class="d-none d-md-table-cell">Area de interes</th>
                    <th>Acciones</th>
                    <!-- Agrega más columnas según necesites -->
                  </tr>
                </thead>
                <tbody>
                  <!-- Aquí se agregarán las filas dinámicamente con JavaScript -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <section id="panel-agregar-candidato" class="mt-5 hidden">

  </section>

  <section id="panel-agregar-examenes" class="mt-5 hidden">


  </section>

  </section -->
  <!-- Scripts al final del cuerpo del documento -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>
  <!-- Sweetalert 2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
  <!-- DataTables -->
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.js"></script>
  <!-- Select2 -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <!-- Bootstrap 4.6.0 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
  </script>
  <!-- Bootstrap Select -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
  <!-- Custom JS -->




  <script>
  let base_url = '<?php echo base_url() ?>'

  function loadClientView(id_cliente) {
    $.ajax({
      url: "<?php echo base_url('Cliente_General/indexCliente'); ?>",
      method: "GET",
      success: function(data) {
        $('#content').html(data);
      },
      error: function() {
        alert('Error al cargar la vista del cliente.');
      }
    });
  }

  function finishSession() {
    let timerInterval;
    setTimeout(() => {
      Swal.fire({
        title: 'Do you want to keep your session?',
        showClass: {
          popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp'
        },
        html: 'Your session will end in <strong></strong> seconds<br/><br/>',
        showDenyButton: true,
        confirmButtonText: 'Keep me logged in',
        denyButtonText: 'Logout',
        timer: 30000,
        timerProgressBar: true,
        didOpen: () => {
          //Swal.showLoading(),
          timerInterval = setInterval(() => {
            Swal.getHtmlContainer().querySelector('strong')
              .textContent = (Swal.getTimerLeft() / 1000)
              .toFixed(0)
          }, 100)
        },
        willClose: () => {
          clearInterval(timerInterval)
        },
        allowOutsideClick: false
      }).then((result) => {
        if (result.isConfirmed) {
          finishSession();
        } else if (result.isDenied || result.dismiss === Swal.DismissReason.timer) {
          fetch('<?php echo base_url('Login/logout'); ?>')
            .then(response => {
              return window.location.href = base_url + 'Login/index'
            })
        }
      })
    }, 7200000);
  }
  finishSession();

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
              let puesto = (full.puesto !== null && full.puesto !== '') ? '<br><small>Puesto: ' + full.puesto +
                '</small>' : ''
              let curp = (full.curp !== null && full.curp !== '') ? '<br><small>CURP: ' + full.curp + '</small>' :
                ''
              let nss = (full.nss !== null && full.nss !== '') ? '<br><small>NSS: ' + full.nss + '</small>' : ''
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
              let observaciones = (full.puesto !== null && full.puesto !== '') ? '<div class="text-center">' +
                full.puesto + '</div>' : '<div class="text-center">Solo examen(es)</div>'
              return observaciones
            }
          },
          {
            title: 'Fechas',
            data: 'fecha_inicio',
            mRender: function(data, type, full) {
              let fechaInicio = (full.fecha_inicio !== null) ? convert_date_to_text(full.fecha_inicio, idioma) :
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
                      .examenDoping + '</b></small><br><a href="<?php echo site_url('Doping/createPDF?id=') ?>' +
                      full.idDoping +
                      '" data-toggle="tooltip" title="Download result" class="fa-tooltip icono_datatable ' +
                      $colorResultado + '"><i class="fas fa-file-pdf"></i></a></div>'
                  } else {
                    doping = '<div class="m-auto" style="text-align:center"><small><b>' + full.examenDoping +
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
                      '" target="_blank" data-toggle="tooltip" title="Download result" class="fa-tooltip icono_datatable fondo-azul-claro"><i class="fas fa-file-medical"></i></a></div>';
                  }
                  if (full.archivo_examen_medico === null && full.conclusionMedica !== null) {
                    medico =
                      '<div class="m-auto" style="text-align:center"><a href="<?php echo site_url('Medico/crearPDF?id=') ?>' +
                      full.idMedico +
                      '" data-toggle="tooltip" title="Download result" class="fa-tooltip icono_datatable fondo-azul-claro"><i class="fas fa-file-pdf"></i></a></div>';
                  }
                  if (full.archivo_examen_medico === null && full.conclusionMedica === null) {
                    medico = '<div class="m-auto" style="text-align:center">Waiting for results</div>';
                  }
                } else {
                  medico = '<div class="m-auto" style="text-align:center">Pending</div>';
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
                  psicometrico = '<div class="m-auto" style="text-align:center"><a href="' + url_psicometria +
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
        "columnDefs": [
            {
                "targets": [4], // Índices de las columnas a ocultar en pantallas pequeñas
                "visible": false // Ocultar columnas en pantallas pequeñas
            }
        ], 
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
            '<button type="button" class="btn btn-link text-primary" onclick="mostrarFormularioCargaCV(' + resp
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
          tbody += '<a href="#" onclick="verHistorialMovimientos(\'' + resp.nombre_aspirante + '\', \'' + resp
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
            '<button type="button" class="dropdown-item" onclick="mostrarFormularioCargaCV(' + resp.id_ra +
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
            resp.id_ra + ', \'' + resp.nombre_aspirante + '\')">Movimientos del Aspirante</button></li>';
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
    // Ocultar el contenido actual
    var id_cliente = <?php echo $id_cliente; ?>;


    $('#panel-inicio').hide();
    $('#panel-historial').hide();

    $.ajax({
      url: "<?php echo base_url('Requisicion/index'); ?>",
      method: "GET",
      data: {
        id_cliente: id_cliente
      },
      success: function(response) {
        // Insertar el contenido de la página en la sección
        $('#panel-agregar-candidato').html(response);
        // Mostrar la sección
        $('#panel-agregar-candidato').show();
      },
      error: function(xhr, status, error) {
        // Manejar cualquier error que ocurra durante la solicitud AJAX
        console.error(xhr.responseText);
      }
    });
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

</body>

</html>