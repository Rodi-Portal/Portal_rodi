<!-- Begin Page Content -->
<div class="container-fluid">

  <section class="content-header">
    <div class="row align-items-center">
      <div class="col-sm-12 col-md-6 col-lg-6">
        <h1 class="titulo_seccion">Requisiciones en progreso</h1>
      </div>

      <div class="col-sm-12 col-md-6 col-lg-6 d-flex justify-content-end">
        <button type="button" class="btn btn-primary btn-icon-split mr-2" id="btn_nuevo" onclick="openAddApplicant()">
          <span class="icon text-white-50">
            <i class="fas fa-user-plus"></i>
          </span>
          <span class="text">Registrar
            aspirante a requicision
          </span>
        </button>
        <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal"
          data-target="#estatusRequisicionModal">
          <span class="icon text-white-50">
            <i class="fas fa-exchange-alt"></i>
          </span>
          <span class="text">Cambiar estatus Requisicion</span>
        </button>
      </div>
    </div>
  </section>
  <br>
  <div>
    <p>Este módulo facilita la gestión de requisiciones de empleo en curso, permitiendo realizar acciones clave como
      cambiar su estatus, finalizar, cancelar y asignar aspirantes. Además, brinda herramientas para dar seguimiento al
      proceso de reclutamiento y compartirlo con el solicitante, registrando movimientos, enviando candidatos a
      socioeconómico, cargando CVs y dejando comentarios. El reclutador puede agregar aspirantes a la requisición,
      permitiendo que el solicitante vea los avances del proceso de manera ágil y organizada.</p>
  </div>





  <?php echo $modals; ?>
  <div class="loader" style="display: none;"></div>
  <input type="hidden" id="idAspirante">
  <input type="hidden" id="idRequisicion">
  <input type="hidden" id="idBolsaTrabajo">
  <input type="hidden" id="idDoping">
  <input type="hidden" id="numVecinal">


  <div id="div_requisiciones" class="row">
    <div class="col-6">
      <label>Selecciona una Requisicion </label>
      <select class="form-control" name="opcion_requisicion" id="opcion_requisicion">
        <option value="">All</option>
        <?php
            if ($reqs) {
            foreach ($reqs as $req) {?>
        <option value="<?php echo $req->id; ?>">
          <?php echo '#' . $req->id . ' ' . $req->nombre . ' - ' . $req->puesto . ' - Vacantes: ' . $req->numero_vacantes; ?>
        </option>
        <?php
            header('Content-Type: text/html; charset=utf-8');}
        }?>
      </select><br>
    </div>
  </div>

  <div id="listado">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="tabla" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          </table>
        </div>
      </div>
    </div>
  </div>


</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('js/whatsapi.js'); ?>"></script>
<script>
$(document).ready(function() {
  var url = '<?php echo base_url('Reclutamiento/getAspirantesRequisiciones'); ?>';
  changeDataTable(url);

  $('#opcion_requisicion').change(function() {
    var id = $(this).val();
    if (id != '') {
      var baseurl = '<?php echo base_url('Reclutamiento/getAspirantesPorRequisicion'); ?>';
      var url = baseurl + '?id=' + id;
      changeDataTable(url);
    } else {
      var url = '<?php echo base_url('Reclutamiento/getAspirantesRequisiciones'); ?>';
      changeDataTable(url);
    }
    //console.log(url+"  esta  es la url "); // Imprimir URL al final
  });

  //inputmask
  $('.fecha').inputmask('dd/mm/yyyy', {
    'placeholder': 'dd/mm/yyyy'
  });
});

function changeDataTable(url) {
  if ($.fn.DataTable.isDataTable('#tabla')) {
    $('#tabla').DataTable().clear().destroy();
  }
  $('#tabla').empty();

  $('#tabla').DataTable({
    "pageLength": 25,
    //"pagingType": "simple",
    "order": [0, "desc"],
    "stateSave": true,
    "serverSide": false,
    "bDestroy": true,
    "ajax": url,
    "columns": [{
        title: '#',
        data: 'id',
        "width": "3%",
        mRender: function(data, type, full) {
          return data;
        }
      },
      {
        title: 'Aspirante',
        data: 'aspirante',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return data; //+'<br><small><b>('+full.usuario+')</b></small>';
        }
      },
      {
        title: 'Sucursal',
        data: 'nombre_cliente',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return '#' + full.id_requisicion + ' ' + full.nombre_cliente;
        }
      },
      {
        title: 'Puesto',
        data: 'puesto',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return data + '<br>(' + full.numero_vacantes + ' vacantes)';
        }
      },
      {
        title: 'Contacto',
        data: 'telefono',
        bSortable: false,
        "width": "10%",
        mRender: function(data, type, full) {
          var correo = (full.correo != '') ? full.correo : 'No registrado';

          return '<b>Teléfono: </b>' + full.telefono + '<br><b>Correo: </b>' + correo + '<br><b>Medio: </b>' +
            full
            .medio_contacto;
        }
      },

      {
        title: 'Acciones',
        data: 'id',
        bSortable: false,
        "width": "10%",
        mRender: function(data, type, full) {
          var cvLink =
            '<a href="javascript:void(0);" class="dropdown-item" onclick="mostrarFormularioCargaCV(' + full.id +
            ')" data-toggle="tooltip" title="Cargar  documentos"><i class="fas fa-upload"></i> Cargar Documentos</a>'

          var actualizarDocs =
            '<a href="javascript:void(0);" class="dropdown-item" onclick="mostrarFormularioActualizarDocs(' +
            full.id +
            ')" data-toggle="tooltip" title="Actualizar Documentos"><i class="fas fa-eye"></i> Actualizar Documentos</a>';

          var comentarios =
            '<a href="javascript:void(0)" class="dropdown-item" onclick="verHistorialBolsaTrabajo(' + full.id +
            ', \'' + full.aspirante + '\')"><i class="fas fa-user-tie"></i>Comentarios Cliente</a>';

          var historial =
            '<a href="javascript:void(0)" id="ver_historial" class="dropdown-item" data-toggle="tooltip" title="Ver historial de movimientos"><i class="fas fa-history"></i> Ver historial de movimientos</a>';
          var iniciar_socio =
            '<a href="#" id="iniciar_socio" class="dropdown-item" data-toggle="tooltip" title="Enviar al módulo de Preempleo para candidatos con o sin estudios previos a la contratación."><i class="fas fa-play-circle"></i>Enviar a Preempleo</a>';
          let ingreso =
            '<a href="#" id="ingreso_empresa" class="dropdown-item" data-toggle="tooltip" title="Registro de datos de ingreso del candidato"><i class="fas fa-user-tie"></i> Registro de ingreso</a>';

          var acciones = '';

          acciones =
            '<a href="javascript:void(0)" id="editar_aspirante" class="dropdown-item" data-toggle="tooltip" title="Editar aspirante"><i class="fas fa-user-edit"></i> Editar aspirante</a>' +
            '<a href="javascript:void(0)" id="accion" class="dropdown-item" data-toggle="tooltip" title="Registrar paso en el proceso del aspirante"><i class="fas fa-plus-circle"></i> Registrar movimientos</a>';

          if (full.status_final == 'FINALIZADO' || full.status_final == 'COMPLETADO') {
            if (full.idCandidato != null && full.idCandidato != '') {
              acciones = '<b>ESE finalizado</b>';
            } else {
              acciones = iniciar_socio + ingreso +
                '<a href="javascript:void(0)" id="editar_aspirante" class="dropdown-item" data-toggle="tooltip" title="Editar aspirante"><i class="fas fa-user-edit"></i> Editar aspirante</a>' +
                '<a href="javascript:void(0)" id="accion" class="dropdown-item" data-toggle="tooltip" title="Registrar paso en el proceso del aspirante"><i class="fas fa-plus-circle"></i> Registrar movimientos</a>';;
            }
          } else {
            if (full.status_final != 'CANCELADO') {
              acciones = iniciar_socio + ingreso +

                '<a href="javascript:void(0)" id="editar_aspirante" class="dropdown-item" data-toggle="tooltip" title="Editar aspirante"><i class="fas fa-user-edit"></i> Editar aspirante</a>' +
                '<a href="javascript:void(0)" id="accion" class="dropdown-item" data-toggle="tooltip" title="Registrar paso en el proceso del aspirante"><i class="fas fa-plus-circle"></i> Registrar movimientos</a>';;
            }
          }


          return '<div class="btn-group">' +
            '<button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones</button>' +
            '<div class="dropdown-menu">' +

            acciones +
            historial +
            comentarios +
            cvLink +
            actualizarDocs +
            '</div>' +
            '</div>';
        }
      },
      {
        title: 'Estatus actual',
        data: null, // Usamos `null` para poder controlar manualmente qué se muestra
        bSortable: false,
        width: "10%",
        render: function(data, type, row) {
          // console.log("🚀 ~ changeDataTable ~ row:", row)
          if (row.status_final !== null && row.status_final !== "") {
            return row.status_final;
          } else if (row.status != null && row.status != "") {
            return row.status;
          } else {
            return "Registrado";
          }
        }
      }
    ],
    fnDrawCallback: function(oSettings) {
      $('a[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
      });
    },
    rowCallback: function(row, data) {

      //Color de estatus
      if (data.status_final == 'CANCELADO') {
        $('td:eq(6)', row).css({
          'background-color': '#f8d7da',
          'color': '#721c24',
          'font-weight': 'bold'
        });
      }
      if (data.status_final == 'BLOQUEADO') {
        $('td:eq(6)', row).css({
          'background-color': '#f5c6cb',
          'color': '#721c24',
          'font-weight': 'bold'
        });
      }
      if (data.status_final == 'FINALIZADO') {
        $('td:eq(6)', row).css({
          'background-color': '#d4edda',
          'color': '#155724',
          'font-weight': 'bold'
        });
      }
      if (data.status_final == 'COMPLETADO') {
        $('td:eq(6)', row).css({
          'background-color': '#c3e6cb',
          'color': '#155724',
          'font-weight': 'bold'
        });
      }
      if (!data.status_final || data.status_final.trim() === "") {
        $('td:eq(6)', row).css({
          'background-color': '#d1ecf1',
          'color': '#0c5460',
          'font-weight': 'bold'
        });
      }



      $("a#editar_aspirante", row).bind('click', () => {
        $("#idAspirante").val(data.id);
        $("#idBolsa").val(data.id_bolsa_trabajo);

        var nombre = data.aspirante.split(' ');

        $('#req_asignada').val(data.id_req).trigger('change'); // Reiniciar Select2
        $('#nombre').val(nombre[0]);
        $('#paterno').val(nombre[1]);
        $('#materno').val(nombre.slice(2).join(' '));
        $('#domicilio').val(data.domicilio);
        $('#area_interes').val(data.area_interes);
        $('#medio').val(data.medio_contacto);
        $('#telefono1').val(data.telefono);
        $('#correo1').val(data.correo);

        if (data.cv != null) {
          $('#cv_previo').html('<small><b> (CV previo: </b></small><a href="<?php echo base_url(); ?>_docs/' +
            data.cv + '" target="_blank">' + data.cv + '</a>)');
        }

        $("#nuevoAspiranteModal").modal('show');
      });
      $('a#accion', row).bind('click', () => {
        $("#idAspirante").val(data.id);
        $(".nombreAspirante").text(data.aspirante);
        $('#idRequisicion').val(data.id_requisicion);
        $('#semaforo').val(data.semaforo);
        $('#estatus_aspirante').val(data.status_aspirante);
        $('#semaforo').val(data.semaforo);

        $("#nuevaAccionModal").modal('show');
      });
      $('a#ver_historial', row).bind('click', () => {
        $("#idAspirante").val(data.id);
        $(".nombreAspirante").text(data.aspirante);
        $('#div_historial_aspirante').empty();
        $.ajax({
          url: '<?php echo base_url('Reclutamiento/getHistorialAspirante'); ?>',
          type: 'post',
          data: {
            'id': data.id,
            'tipo_id': 'aspirante'
          },
          success: function(res) {
            var salida = '<table class="table table-striped" style="font-size: 14px">';
            salida += '<tr style="background: gray;color:white;">';
            salida += '<th>Fecha</th>';
            salida += '<th>Estatus</th>';
            salida += '<th>Comentario / Descripción / Fecha y lugar</th>';
            salida += '<th>Eliminar Movimiento</th>';
            salida += '</tr>';
            if (res != 0) {
              var dato = JSON.parse(res);
              for (var i = 0; i < dato.length; i++) {
                var aux = dato[i]['creacion'].split(' ');
                var f = aux[0].split('-');
                var fecha = f[2] + '/' + f[1] + '/' + f[0];
                salida += "<tr id='fila_" + dato[i]['id'] + "'>";
                salida += '<td>' + fecha + '</td>';
                salida += '<td>' + dato[i]['accion'] + '</td>';
                salida += '<td>' + dato[i]['descripcion'] + '</td>';
                salida +=
                  '<td><i class="fas fa-trash-alt text-danger" style="cursor:pointer;" onclick="eliminarRegistro(' +
                  dato[i]['id'] + ')"></i></td>';
                salida += "</tr>";
              }
            } else {
              salida += "<tr>";
              salida += '<td colspan="3" class="text-center"><h5>Sin movimientos</h5></td>';
              salida += "</tr>";
            }
            salida += "</table>";
            $('#div_historial_aspirante').html(salida);
            $("#historialModal").modal('show');
          }
        });
      });

      $('a#iniciar_socio', row).bind('click', () => {


        var nombreCompleto = data.aspirante.trim();


        // Dividir el nombre completo en partes
        var partesNombre = nombreCompleto.split(" ");

        var nombreAspirante = partesNombre[0]; // Primer nombre
        var apellidoPaterno = partesNombre.length > 1 ? partesNombre[1] : ""; // Primer apellido
        var apellidoMaterno = partesNombre.length > 2 ? partesNombre[2] : "";
        var id_cliente = data.id_cliente;
        let id_position = 0;
        $("#id_cliente_hidden").val(data.id_cliente);
        $("#clave").val(data.clave);
        $("#cliente").val(data.nombre_cliente);
        $("#idAspiranteReq").val(data.id);
        $("#idRequisicion").val(data.id_requisicion);
        $("#idBolsaTrabajo").val(data.id_bolsa_trabajo);
        $('#nombre_registro').val(nombreAspirante)
        $('#paterno_registro').val(apellidoPaterno)
        $('#materno_registro').val(apellidoMaterno)
        $('#celular_registro').val(data.telefono)
        $('#correo_registro').val(data.correo)
        $('.loader').css("display", "block");
        $.ajax({
          async: false,
          url: '<?php echo base_url('Cat_Puestos/getPositionByName'); ?>',
          type: 'POST',
          data: {
            'nombre': data.req_puesto
          },
          success: function(res) {
            id_position = res;
          }
        });
        $.ajax({
          async: false,
          url: '<?php echo base_url('Candidato_Seccion/getHistorialProyectosByCliente'); ?>',
          type: 'POST',
          data: {
            'id_cliente': id_cliente
          },
          success: function(res) {
            $('#previos').html(res);
          }
        });
        setTimeout(() => {
          $.ajax({
            async: false,
            url: '<?php echo base_url('Cat_Puestos/getAllPositions'); ?>',
            type: 'POST',
            success: function(res) {
              if (res != 0) {
                let data = JSON.parse(res);
                $('#puesto').append('<option value="">Selecciona</option>');
                for (let i = 0; i < data.length; i++) {
                  $('#puesto').append('<option value="' + data[i]['id'] + '">' + data[i]['nombre'] +
                    '</option>');
                }
                $('#puesto').select2({
                  placeholder: 'Selecciona una opción',
                  allowClear: true,
                  // Puedes agregar más opciones según tus necesidades
                });
              } else {
                $('#puesto').append('<option value="">No hay puestos registrados</option>');
              }
            }
          });
        }, 200);
        setTimeout(function() {
          $('#puesto').val(id_position).trigger('change');
          $('.loader').fadeOut();
        }, 250);
        $('#registroCandidatoModal').modal('show');
      });
      $('a#ingreso_empresa', row).bind('click', () => {
        $("#idAspirante").val(data.id);
        $('#ingresoCandidatoModal .nombreRegistro').text(data.nombre)
        $("#sueldo_acordado").val(data.sueldo_acordado);
        $("#fecha_ingreso").val(data.fecha_ingreso);
        $("#pago").val(data.pago);
        getIngresoCandidato(data.id);
      });
    },
    "language": {
      "lengthMenu": "Mostrar _MENU_ registros por página",
      "zeroRecords": "No se encontraron registros",
      "info": "Mostrando registros de _START_ a _END_ de un total de _TOTAL_ registros",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(Filtrado de _MAX_ registros totales)",
      "sSearch": "Buscar:",
      "oPaginate": {
        "sLast": "Última página",
        "sFirst": "Primera",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      }
    }
  });
}

function mostrarFormularioCargaCV(id) {
  console.log('mostrarFormularioCargaCV id:', id);
  $('#id_aspirante').val(id);

  /* ───── VALIDACIONES RÁPIDAS ───── */

  // 1. ¿La librería Dropzone está cargada?
  if (typeof window.Dropzone === 'undefined') {
    Swal.fire('Ups…', 'La librería Dropzone no se cargó. Recarga la página.', 'error');
    return;                               // ⛔ NO abras el modal
  }

  // 2. (Opcional) ¿Ya hay una cola en curso?
  //    Evita abrir un segundo modal si el usuario está subiendo algo.
  if (dz && dz.getQueuedFiles().length > 0) {
    Swal.fire('Atención', 'Tienes archivos pendientes de subir.', 'warning');
    return;                               // ⛔ NO abras el modal
  }

  /* ───── Todo OK → abre el modal ───── */
  $('#modalCargaArchivos').modal('show');
}

const baseDocs = <?php echo json_encode(VERASPIRANTESDOCS);?>;

function mostrarFormularioActualizarDocs(id) {
  $('#id_aspirante').val(id); // por si luego lo necesitas
  const $tbody = $('#tablaDocsModal tbody');

  // 1) Limpia y muestra “Cargando…”
  $tbody.html('<tr><td colspan="4" class="text-center">Cargando…</td></tr>');

  // 2) Pide los documentos del aspirante
  $.ajax({
    url: `<?php echo base_url('Documentos_Aspirantes/lista/')?>${id}`,
    type: 'GET',
    dataType: 'json',
    success: function(docs) {
      if (!docs.length) {
        $tbody.html('<tr><td colspan="4" class="text-center text-muted">Sin documentos</td></tr>');
      } else {
        let filas = '';
        docs.forEach(d => {
          filas += `
            <tr>
              <td>${d.nombre_personalizado}</td>
              <td><a href="${baseDocs}${d.nombre_archivo}" target="_blank">${d.nombre_archivo}</a></td>
              <td>${d.fecha_subida}</td>
              <td>
                <button class="btn btn-sm btn-info"
                        data-toggle="tooltip" title="Reemplazar archivo"
                        onclick="abrirModalReemplazo(${d.id}, '${d.nombre_personalizado.replace(/'/g,'&#39;')}')">
                  <i class="fas fa-sync-alt"></i>
                </button>
              </td>
            </tr>`;
        });
        $tbody.html(filas);
        $('[data-toggle="tooltip"]').tooltip(); // re-inicializa tooltips
      }

      // 3) Finalmente muestra el modal
      $('#modalActualizarArchivos').modal('show');
    },
    error: function() {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No se pudieron cargar los documentos'
      });
      $('#modalActualizarArchivos').modal('hide');
    }
  });
}

function abrirModalReemplazo(idDoc, nombreActual) {
  $('#id_doc').val(idDoc);
  $('#nuevo_nombre').val(nombreActual);
  $('#modalReemplazo').modal('show');
}

function openAddApplicant() {

  $("#nuevoAspiranteModal").modal('show');
}




function addApplicant() {
  // var cv = $("#cv")[0].files[0];
  var datos = new FormData();
  datos.append('requisicion', $("#req_asignada").val());
  datos.append('nombre', $("#nombre").val());
  datos.append('paterno', $("#paterno").val());
  datos.append('materno', $("#materno").val());
  datos.append('correo', $("#correo1").val());
  datos.append('telefono', $("#telefono1").val());
  datos.append('medio', $("#medio").val());
  datos.append('area_interes', $("#area_interes").val());
  datos.append('domicilio', $("#domicilio").val());
  // datos.append("cv", cv);
  datos.append("id_aspirante", $("#idAspirante").val());
  datos.append("id_bolsa_trabajo", $("#idBolsa").val());


  $.ajax({
    url: '<?php echo base_url('Reclutamiento/addApplicant'); ?>',
    type: 'POST',
    data: datos,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);

      var data = JSON.parse(res);
      if (data.codigo === 1) {
        $("#nuevoAspiranteModal").modal('hide')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}

function guardarComentario(id_bolsa) {

  let comentario = $('#comentario_bolsa').val();
  $.ajax({
    url: '<?php echo base_url('Reclutamiento/guardarHistorialBolsaTrabajo'); ?>',
    type: 'post',
    data: {
      'id_bolsa': id_bolsa,
      'comentario': comentario
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      var data = JSON.parse(res);
      if (data.codigo === 1) {
        $("#historialComentariosModal").modal('hide');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 3000
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}




function guardarAccion() {
  var datos = new FormData();
  datos.append('otra_accion', $("#otra_accion").val());
  datos.append('accion', $("#accion_aspirante").val());
  datos.append('comentario', $("#accion_comentario").val());
  datos.append("id_requisicion", $('#idRequisicion').val());
  datos.append("id_aspirante", $('#idAspirante').val());
  datos.append('semaforo', $("#semaforo").val());
  datos.append("estatus_aspirante", $('#estatus_aspirante').val());
  datos.append("estatus_proceso", $('#estatus_proceso').val());

  $.ajax({
    url: '<?php echo base_url('Reclutamiento/guardarAccionRequisicion'); ?>',
    type: 'POST',
    data: datos,
    processData: false,
    cache: false,
    contentType: false,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      var data = JSON.parse(res);
      if (data.codigo === 1) {
        recargarTable();
        $("#nuevaAccionModal").modal('hide')
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 3000
        })
        //console.log("🚀 ~ guardarAccion ~ data.msg:", data.msg)
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}

function guardarEstatusRequisicion() {
  var datos = new FormData();
  datos.append('estatus', $("#asignar_estatus").val());
  datos.append('comentario', $("#comentario_estatus").val());
  datos.append("id_requisicion", $('#req_estatus').val());

  $.ajax({
    url: '<?php echo base_url('Reclutamiento/guardarEstatusRequisicion'); ?>',
    type: 'POST',
    data: datos,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);

      let data;
      try {
        data = JSON.parse(res);
      } catch (e) {
        Swal.fire({
          icon: 'error',
          title: 'Error en el servidor',
          html: "<b>Respuesta inesperada del servidor:</b><br><pre style='text-align:left'>" + res + "</pre>",
          width: '50em'
        });
        console.error("Respuesta AJAX no es JSON:", res);
        return;
      }

      if (data.codigo === 1) {
        $("#estatusRequisicionModal").modal('hide')
        recargarTable();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 2500
        });
      } else if (data.codigo === 0 && data.faltantes) {
        Swal.fire({
          icon: 'error',
          title: data.msg,
          html: '<ul style="text-align:left">' + data.faltantes.map(f => `<li>${f}</li>`).join('') + '</ul>',
          confirmButtonText: 'Cerrar'
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        });
      }
    }
  });
}


function registrarCandidato() {
  var datos = new FormData();

  datos.append('nombre', $("#nombre_registro").val());
  datos.append('paterno', $("#paterno_registro").val());
  datos.append('materno', $("#materno_registro").val());
  datos.append('celular', $("#celular_registro").val());
  datos.append('subcliente', $("#subcliente").val());
  datos.append('opcion', $('#opcion_registro').val());
  datos.append('puesto', $('#puesto').val());
  datos.append('puesto_otro', $('#puesto_otro').val());
  datos.append('pais', $("#pais").val());
  datos.append('region', $("#region").val());

  datos.append('previo', $("#previos").val());
  datos.append('proyecto', $("#proyecto_registro").val());

  datos.append('examen', $("#examen_registro").val());
  datos.append('medico', $("#examen_medico").val());

  datos.append('id_cliente', $('#id_cliente_hidden').val());
  datos.append('clave', $("#clave").val());
  datos.append('cliente', $("#cliente").val());
  datos.append('idAspiranteReq', $("#idAspiranteReq").val());
  datos.append('psicometrico', $("#examen_psicometrico").val());
  datos.append('correo', $("#correo_registro").val());
  datos.append('centro_costo', 'NA');
  datos.append('curp', $('#curp_registro').val());
  datos.append('nss', $('#nss_registro').val());
  datos.append('usuario', 1);
  datos.append('id_requisicion', $("#idRequisicion").val());
  datos.append('id_bolsa_trabajo', $("#idBolsaTrabajo").val());

  $.ajax({
    url: '<?php echo base_url('Client/registrar'); ?>',
    type: 'POST',
    data: datos,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);

      var data = JSON.parse(res);
      if (data.codigo === 1) {
        recargarTable();
        $("#registroCandidatoModal").modal('hide');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 3500
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        });
      }

    },
    error: function(xhr, status, error) {
      console.error("Error en la solicitud AJAX:", error);
      Swal.fire({
        icon: 'error',
        title: 'Error en la solicitud AJAX',
        text: 'Hubo un problema al comunicarse con el servidor',
        confirmButtonText: 'Cerrar'
      });
    }
  });
}

function getIngresoCandidato(id) {
  $.ajax({
    async: false,
    url: '<?php echo base_url('Reclutamiento/getWarrantyApplicant'); ?>',
    type: 'POST',
    data: {
      'id': id
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 300);
      var salida = '<table class="table table-striped" style="font-size: 14px">';
      salida += '<tr style="background: gray;color:white;">';
      salida += '<th>Fecha registro</th>';
      salida += '<th>Usuario</th>';
      salida += '<th>Descripción / Estatus</th>';
      salida += '</tr>';
      if (res != 0) {
        var dato = JSON.parse(res);
        for (var i = 0; i < dato.length; i++) {
          var aux = dato[i]['creacion'].split(' ');
          var f = aux[0].split('-');
          var fecha = f[2] + '/' + f[1] + '/' + f[0];
          salida += "<tr>";
          salida += '<td>' + fecha + '</td>';
          salida += '<td>' + dato[i]['usuario'] + '</td>';
          salida += '<td>' + dato[i]['descripcion'] + '</td>';
          salida += "</tr>";
        }
      } else {
        salida += "<tr>";
        salida += '<td colspan="4" class="text-center"><h5>Sin registros</h5></td>';
        salida += "</tr>";
      }
      salida += "</table>";
      $('#divHistorialGarantia').html(salida);
    }
  });
  $('#ingresoCandidatoModal').modal('show');
}

function verHistorialBolsaTrabajo(id, nombreCompleto) {
  $(".nombreRegistro").text(nombreCompleto);
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
      var salida = '<table class="table table-striped" style="font-size: 14px">';
      salida += '<tr style="background: gray;color:white;">';
      salida += '<th>Fecha</th>';
      salida += '<th>Usuario</th>';
      salida += '<th>Comentario / Estatus</th>';
      salida += '</tr>';
      if (res != 0) {
        var dato = JSON.parse(res);
        for (var i = 0; i < dato.length; i++) {
          var aux = dato[i]['creacion'].split(' ');
          var f = aux[0].split('-');
          var fecha = f[2] + '/' + f[1] + '/' + f[0];
          salida += "<tr>";
          salida += '<td>' + fecha + '</td>';
          salida += '<td>' + dato[i]['usuario'] + '</td>';
          salida += '<td>' + dato[i]['comentario'] + '</td>';
          salida += "</tr>";
        }
      } else {
        salida += "<tr>";
        salida += '<td colspan="4" class="text-center"><h5>Sin comentarios</h5></td>';
        salida += "</tr>";
      }
      salida += "</table>";
      $('#div_historial_comentario').html(salida);
      $("#historialComentariosModal").modal('show');
    }
  });
}

function eliminarRegistro(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: "¡Esta acción no se puede deshacer!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, continuar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      // Segunda confirmación
      Swal.fire({
        title: '¿Realmente deseas eliminar el registro?',
        text: "Esta acción es definitiva.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result2) => {
        if (result2.isConfirmed) {
          // Llamada AJAX al controlador
          $.ajax({
            url: '<?php echo base_url('Reclutamiento/eliminarRegistro'); ?>',
            type: 'POST',
            data: {
              id: id
            },
            success: function(response) {
              try {
                var res = JSON.parse(response);

                if (res.status) {
                  Swal.fire('Eliminado', res.mensaje, 'success');

                  // Elimina la fila del DOM si tienes una estructura tipo: <tr id="fila_ID">
                  $("#fila_" + id).remove();

                } else {
                  Swal.fire('Atención', res.mensaje, 'warning');
                }

              } catch (e) {
                Swal.fire('Error', 'Respuesta inesperada del servidor.', 'error');
                console.error('Error al parsear respuesta:', e, response);
              }
            },
            error: function(xhr, status, error) {
              Swal.fire('Error', 'Ocurrió un error al eliminar.', 'error');
              console.error('Error AJAX:', status, error);
            }
          });
        }
      });
    }
  });
}


function updateAdmission(section) {
  let id_aspirante = $('#idAspirante').val()
  let form = $('#formIngreso').serialize();
  form += '&id_aspirante=' + id_aspirante;
  $.ajax({
    url: '<?php echo base_url('Reclutamiento/updateWarrantyApplicant'); ?>',
    type: 'post',
    data: form,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 300);
      var dato = JSON.parse(res);
      if (dato.codigo === 1) {
        getIngresoCandidato(id_aspirante)

        $("#ingresoCandidatoModal").modal('hide');

        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: dato.msg,
          showConfirmButton: false,
          timer: 3000
        })

      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema',
          html: dato.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}
//Funciones de apoyo
function recargarTable() {
  $("#tabla").DataTable().ajax.reload();
}
</script>