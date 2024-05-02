<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Requisiciones en Proceso</h1><br>
    <a href="#" class="btn btn-primary btn-icon-split" id="btn_nuevo" onclick="openAddApplicant()">
      <span class="icon text-white-50">
        <i class="fas fa-user-plus"></i>
      </span>
      <span class="text">Registrar aspirante a Requisición</span>
    </a>
    <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#estatusRequisicionModal">
      <span class="icon text-white-50">
        <i class="fas fa-exchange-alt"></i>
      </span>
      <span class="text">Cambiar estatus de requisición</span>
    </a>
    <a href="#" class="btn btn-primary btn-icon-split hidden" id="btn_regresar" onclick="regresarListado()"
      style="display: none;">
      <span class="icon text-white-50">
        <i class="fas fa-arrow-left"></i>
      </span>
      <span class="text">Regresar al listado</span>
    </a>
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
      <label>Selecciona la requisición a mostrar: </label>
      <select class="form-control" name="opcion_requisicion" id="opcion_requisicion">
        <option value="">Todas</option>
        <?php
        if ($reqs) {
          foreach ($reqs as $req) { ?>
        <option value="<?php echo $req->id; ?>">
          <?php echo '#'.$req->id.' '.$req->nombre.' - '.$req->puesto.' - Vacantes: '.$req->numero_vacantes; ?></option>
        <?php   
          }
        } ?>
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
        title: 'Nombre o Razón Social',
        data: 'empresa',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return '#' + full.id_requisicion + ' ' + data;
        }
      },
      {
        title: 'Puesto',
        data: 'req_puesto',
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
    
          return '<b>Teléfono: </b>' + data + '<br><b>Correo: </b>' + correo + '<br><b>Medio: </b>' + full
            .medio_contacto;
        }
      },
    
      {
        title: 'Acciones',
        data: 'id',
        bSortable: false,
        "width": "10%",
        mRender: function(data, type, full) {
          var cvLink = (full.cv != null) ?
            '<a href="<?php echo base_url(); ?>_docs/' + full.cv +
            '" target="_blank" class="dropdown-item" data-toggle="tooltip" title="Ver CV/Solicitud"><i class="fas fa-eye"></i> Ver CV/Solicitud</a>' +
            '<a href="javascript:void(0);" class="dropdown-item" onclick="mostrarFormularioCargaCV(' + full.id +
            ')" data-toggle="tooltip" title="Actualizar CV/Solicitud"><i class="fas fa-upload"></i> Actualizar CV/Solicitud</a>' :
            '<a href="javascript:void(0);" class="dropdown-item" onclick="mostrarFormularioCargaCV(' + full.id +
            ')" data-toggle="tooltip" title="Cargar CV/Solicitud"><i class="fas fa-upload"></i> Cargar CV/Solicitud</a>';


            var comentarios = '<a href="javascript:void(0)" class="dropdown-item" onclick="verHistorialBolsaTrabajo(' + full.id + ', \'' + full.aspirante + '\')"><i class="fas fa-user-tie"></i>Comentarios Cliente</a>';


          var historial =
            '<a href="javascript:void(0)" id="ver_historial" class="dropdown-item" data-toggle="tooltip" title="Ver historial de movimientos"><i class="fas fa-history"></i> Ver historial de movimientos</a>';
          //var iniciar_socio =
            //'<a href="#" id="iniciar_socio" class="dropdown-item" data-toggle="tooltip" title="Iniciar ESE"><i class="fas fa-play-circle"></i> Iniciar ESE</a>';
          let ingreso =
            '<a href="#" id="ingreso_empresa" class="dropdown-item" data-toggle="tooltip" title="Registro de datos de ingreso del candidato"><i class="fas fa-user-tie"></i> Registro de ingreso</a>';

          var acciones = '';
          if (full.status_final == null) {
            acciones =
              '<a href="javascript:void(0)" id="editar_aspirante" class="dropdown-item" data-toggle="tooltip" title="Editar aspirante"><i class="fas fa-user-edit"></i> Editar aspirante</a>' +
              '<a href="javascript:void(0)" id="accion" class="dropdown-item" data-toggle="tooltip" title="Registrar paso en el proceso del aspirante"><i class="fas fa-plus-circle"></i> Registrar movimientos</a>';
          } else {
            if (full.status_final == 'FINALIZADO' || full.status_final == 'COMPLETADO') {
              if (full.idCandidato != null && full.idCandidato != '') {
                acciones = '<b>ESE finalizado</b>';
              } //else {                acciones = iniciar_socio;              }
            } else {
              if (full.status_final != 'CANCELADO') {
                acciones = ingreso;
              }
            }
          }

          return '<div class="btn-group">' +
            '<button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones</button>' +
            '<div class="dropdown-menu">' +
            acciones +
            historial+
            comentarios+
            cvLink +
            
            ingreso +
           

            '</div>' +
            '</div>';
        }
      },
       

      {
        title: 'Estatus actual',
        data: 'status',
        bSortable: false,
        "width": "10%",
        mRender: function(data, type, full) {
          return '<b>' + data + '<b>';
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
          'background-color': '#c71c2d',
          'color': 'white'
        });
      }
      if (data.status_final == 'FINALIZADO') {
        $('td:eq(6)', row).css({
          'background-color': '#f9fc12',
          'color': 'black'
        });
      }
      if (data.status_final == 'COMPLETADO') {
        $('td:eq(6)', row).css({
          'background-color': '#04bf13',
          'color': 'white'
        });
      }
      if (data.status_final == 'ESE FINALIZADO') {
        for (let i = 0; i < 7; i++) {
          $('td:eq(' + i + ')', row).css({
            'background-color': '#1cc88a',
            'color': 'white'
          });
        }
      }
      $("a#editar_aspirante", row).bind('click', () => {
      
        $("#idAspirante").val(data.id);
        $("#idBolsa").val(data.id_bolsa_trabajo);

        var nombre = data.aspirante.split(' ');

        $('#req_asignada').val(data.id_req);
        $('#req_asignada').selectpicker('refresh');
        $('#nombre').val(nombre[0]);
        $('#paterno').val(nombre[1]);
        $('#materno').val(nombre.slice(2).join(' '));
        $('#domicilio').val(data.domicilio);
        $('#area_interes').val(data.area_interes);
        $('#medio').val(data.medio_contacto);
        $('#telefono').val(data.telefono);
        $('#correo').val(data.correo);
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
            salida += '</tr>';
            if (res != 0) {
              var dato = JSON.parse(res);
              for (var i = 0; i < dato.length; i++) {
                var aux = dato[i]['creacion'].split(' ');
                var f = aux[0].split('-');
                var fecha = f[2] + '/' + f[1] + '/' + f[0];
                salida += "<tr>";
                salida += '<td>' + fecha + '</td>';
                salida += '<td>' + dato[i]['accion'] + '</td>';
                salida += '<td>' + dato[i]['descripcion'] + '</td>';
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
        var id_cliente = 0;
        let id_position = 0;
        $("#idAspirante").val(data.id);
        $("#idRequisicion").val(data.id_requisicion);
        $("#idBolsaTrabajo").val(data.id_bolsa_trabajo);
        $('#nombre_registro').val(data.nombre)
        $('#paterno_registro').val(data.paterno)
        $('#materno_registro').val(data.materno)
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
                $('#puesto').selectpicker({
                  liveSearch: true
                })
              } else {
                $('#puesto').append('<option value="">No hay puestos registrados</option>');
              }
            }
          });
        }, 200);
        setTimeout(function() {
          $('#puesto').selectpicker('val', id_position)
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
      "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "infoEmpty": "Sin registros disponibles",
      "infoFiltered": "(Filtrado _MAX_ registros totales)",
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

function mostrarFormularioCargaCV($id) {
  // Muestra el modal para cargar el CV
  $('#id_aspirante').val($id);
  $('#modalCargaCV').modal('show');
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
  datos.append('correo', $("#correo").val());
  datos.append('telefono', $("#telefono").val());
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
      recargarTable();
      var data = JSON.parse(res);
      if (data.codigo === 1) {
        $("#nuevoAspiranteModal").modal('hide')
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

function subirCVReqAspirante() {
  var idAspirante = $('#id_aspirante').val();
 // console.log("🚀 ~ subirCVReqAspirante ~ idAspirante:", idAspirante);
  var idCV = $('#id_cv').val();
 // console.log("🚀 ~ subirCVReqAspirante ~ idCV:", idCV);



  var formData = new FormData($('#formularioCargaCV')[0]);

  formData.append('id_aspirante', idAspirante);
  formData.append('id_cv', idCV);

  $.ajax({
    url: '<?php echo base_url('Reclutamiento/subirCVReqAspirante'); ?>',
    type: 'POST',
    data: formData,
    processData: false,
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
        $("#modalCargaCV").modal('hide');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'CV subido correctamente',
          showConfirmButton: false,
          timer: 2500
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error al subir CV',
          text: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        });
      }
    }
  });
}


function guardarAccion() {
  var datos = new FormData();
  datos.append('accion', $("#accion_aspirante").val());
  datos.append('comentario', $("#accion_comentario").val());
  datos.append("id_requisicion", $('#idRequisicion').val());
  datos.append("id_aspirante", $('#idAspirante').val());

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
      var data = JSON.parse(res);
      if (data.codigo === 1) {
        $("#estatusRequisicionModal").modal('hide')
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 2500
        })
        setTimeout(() => {
          location.reload();
        }, 2500);
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

function registrarCandidato() {
  var id_cliente = 87;
  var datos = new FormData();
  var curp = $('#curp_registro').val();
  var nss = $('#nss_registro').val();
  datos.append('nombre', $("#nombre_registro").val());
  datos.append('paterno', $("#paterno_registro").val());
  datos.append('materno', $("#materno_registro").val());
  datos.append('celular', $("#celular_registro").val());
  datos.append('subcliente', $("#subcliente").val());
  datos.append('puesto', $('#puesto').selectpicker('val'));
  datos.append('pais', $("#pais").val());
  datos.append('previo', $("#previos").val());
  datos.append('proyecto', $("#proyecto_registro").val());
  datos.append('id_cliente', id_cliente);
  datos.append('examen', $("#examen_registro").val());
  datos.append('medico', $("#examen_medico").val());
  datos.append('psicometrico', $("#examen_psicometrico").val());
  datos.append('correo', $("#correo_registro").val());
  datos.append('centro_costo', 'NA');
  datos.append('curp', curp);
  datos.append('nss', nss);
  datos.append('usuario', 1);
  datos.append('id_aspirante', $("#idAspirante").val());
  datos.append('id_requisicion', $("#idRequisicion").val());
  datos.append('id_bolsa_trabajo', $("#idBolsaTrabajo").val());
  var num_files = document.getElementById('cv').files.length;
  if (num_files > 0) {
    datos.append("hay_cvs", 1);
    for (var x = 0; x < num_files; x++) {
      datos.append("cvs[]", document.getElementById('cv').files[x]);
    }
  } else {
    datos.append("hay_cvs", 0);
  }

  $.ajax({
    url: '<?php echo base_url('Cliente_General/registrar'); ?>',
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
        recargarTable()
        $("#registroCandidatoModal").modal('hide')
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 3500
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