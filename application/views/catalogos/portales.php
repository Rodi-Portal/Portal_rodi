<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="align-items-center mb-4">
    <div class="row justify-content-between">
      <div class="col-sm-12 col-md-8">
        <h1 class="h3 mb-0 text-gray-800">Portales</h1>
      </div>
      <div class="col-sm-12 col-md-3">
        <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#newPortal">
          <span class="icon text-white-50">
            <i class="fas fa-user-tie"></i>
          </span>
          <span class="text">Agregar portal</span>
        </a>
      </div>
      <!-- div class="col-sm-12 col-md-2" style="display: none;">
        <a href="#" class="btn btn-primary btn-icon-split" onclick="registrarAccesoCliente()">
          <span class="icon text-white-50">
            <i class="fas fa-sign-in-alt"></i>
          </span>
          <span class="text">Acceso a clientes</span>
        </a>
      </div -->
    </div>
  </div>

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

  <?php echo $modals; ?>
  <div class="loader" style="display: none;"></div>
  <input type="hidden" id="idPortal">
  <input type="hidden" id="idUsuarioCliente">


</div>




<!-- /.content-wrapper -->
<script>
var url = '<?php echo base_url('Cat_Portales/getPortales'); ?>';
var tipos_bloqueo_php =
  '<?php foreach ($tipos_bloqueo as $row) {echo '<option value="' . $row->tipo . '">' . $row->descripcion . '</option>';}?>';
var tipos_desbloqueo_php =
  '<?php foreach ($tipos_desbloqueo as $row) {echo '<option value="' . $row->tipo . '">' . $row->descripcion . '</option>';}?>';
$(document).ready(function() {
  $("#cerrarModal").on("click", function() {


    // Resetea el formulario al cerrar el modal

  });

  //console.log('Documento listo. Iniciando script.');
  $('[data-toggle="tooltip"]').tooltip();
  $('#newPortal').on('shown.bs.modal', function() {

    $(this).find('input[type=text],select,textarea').filter(':visible:first').focus();
  });
  //console.log('URL de Ajax:', url);
  var msj = localStorage.getItem("success");
  if (msj == 1) {
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Se ha guardado correctamente',
      showConfirmButton: false,
      timer: 2500
    })
    localStorage.removeItem("success");
  }
  // Verificar la carga de bibliotecas
  if (typeof jQuery === 'undefined') {
    console.error('Error: jQuery no está cargado correctamente.');
  } else {
    console.log('jQuery cargado correctamente.');
  }

  /* if (typeof $.fn.dataTable === 'undefined') {
     console.error('Error: DataTables no está cargado correctamente.');
   } else {
     console.log('DataTables cargado correctamente.');
   }*/
  var tabla = $('#tabla').DataTable({
    "pageLength": 25,
    //"pagingType": "simple",
    "order": [0, "desc"],
    "stateSave": false,
    "serverSide": false,
    "destroy": true, 
    "ajax": {
      "url": url,
      "type": "GET",
      "dataType": "json",
      "error": function(xhr, status, error) {
        console.error("Error en la solicitud AJAX:", status, error);
        // Puedes agregar código adicional para manejar errores aquí
        // Por ejemplo, puedes mostrar un mensaje de error al usuario o realizar alguna acción específica.

        // Si estás utilizando DataTables 1.10.13 o superior, puedes intentar cargar la tabla vacía en caso de error:
        // $('#tabla').DataTable().clear().draw();
      }
    },
    "columns": [{
        "title": 'idPortal',
        "data": 'idPortal',
        "visible": false,
        "width": "3%"
      },
      {
        title: 'Nombre',
        data: 'nombre',
        bSortable: false,
        "width": "10%",
        mRender: function(data, type, full) {
          return '<span class="badge badge-pill badge-dark">#' + full.idPortal + '</span><br><b>' + data +
            '</b>';
        }
      },


      {
        title: 'Fecha de alta',
        data: 'creacion',
        bSortable: false,
        "width": "7%",
        mRender: function(data, type, full) {
          var f = data.split(' ');
          var h = f[1];
          var aux = h.split(':');
          var hora = aux[0] + ':' + aux[1];
          var aux = f[0].split('-');
          var fecha = aux[2] + "/" + aux[1] + "/" + aux[0];
          var tiempo = fecha + ' ' + hora;
          return tiempo;
        }
      },
      {
        title: 'Situación Fiscal',
        data: 'constancia',
        bSortable: false,
        width: "3%",
        mRender: function(data, type, full) {
          const fileUrl = '<?php echo base_url("_portal_files/"); ?>' + data;

          if (data && data.trim() !== '') {
            return '<a href="' + fileUrl +
              '" target="_blank" data-toggle="tooltip" title="Ver Constancia" ' +
              'id="descarga_constancia_' + full.id +
              '" class="fa-tooltip icono_datatable icono_azul_oscuro ">' +
              '<i class="fas fa-file-invoice"></i>' +
              '</a>' +
              ' <a href="javascript:void(0)" onclick="document.getElementById(\'cargar_constancia_' + full
              .idPortal + '\').click();" ' +
              'class="fa-tooltip icono_datatable icono_amarillo" data-toggle="tooltip" title="Subir Constancia">' +
              '<i class="fas fa-upload"></i>' +
              '</a>'+
              '<input type="file" id="cargar_constancia_' + full.idPortal +
              '" name="constancia" style="display: none;" ' +
              'onchange="uploadFile(event, \'' + full.idPortal + '\')">';
          } else {
            return '<input type="file" id="cargar_constancia_' + full.idPortal +
              '" name="constancia" style="display: none;" ' +
              'onchange="uploadFile(event, \'' + full.idPortal + '\')">' +
              '<a href="javascript:void(0)" onclick="document.getElementById(\'cargar_constancia_' + full
              .idPortal + '\').click();" ' +
              'class="fa-tooltip icono_datatable icono_azul_oscuro" data-toggle="tooltip" title="Subir Constancia">' +
              '<i class="fas fa-upload"></i>' +
              '</a>';
          }
        }
      },

      {
        title: 'Accesos',
        data: 'numero_usuarios_portal',
        bSortable: false,
        "width": "10%",
        mRender: function(data, type, full) {
          if (data == 0) {
            return 'Sin registro de accesos';
          } else {
            return 'Cuenta con ' + data + ' registro(s) de acceso';
          }
        }
      },
      {
        title: 'Acciones',
        data: 'id',
        bSortable: false,
        "width": "10%",
        mRender: function(data, type, full) {

          let editar =
            '<a id="editar" href="javascript:void(0)" data-toggle="tooltip" title="Editar" class="fa-tooltip icono_datatable icono_azul_oscuro"><i class="fas fa-edit"></i></a> ';
          let eliminar =
            '<a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar portal" id="eliminar" class="fa-tooltip icono_datatable icono_rojo"><i class="fas fa-trash"></i></a> ';
          let acceso =
            '<a href="javascript:void(0)" data-toggle="tooltip" title="Ver accesos" id="acceso" class="fa-tooltip icono_datatable icono_azul_claro"><i class="fas fa-sign-in-alt"></i></a> ';

          // let accion = (full.status == 0) ?
          //'<a href="javascript:void(0)" data-toggle="tooltip" title="Activar" id="activar" class="fa-tooltip icono_datatable icono_rojo"><i class="fas fa-ban"></i></a> ' :
          //'<a href="javascript:void(0)" data-toggle="tooltip" title="Desactivar" id="desactivar" class="fa-tooltip icono_datatable icono_verde"><i class="far fa-check-circle"></i></a> ';

          let bloqueo = (full.bloqueado == 0) ?
            ' <a href="javascript:void(0)" data-toggle="tooltip" title="Bloquear portal" id="bloquear_portal" class="fa-tooltip icono_datatable icono_verde"><i class="fas fa-user-check"></i></a> ' :
            ' <a href="javascript:void(0)" data-toggle="tooltip" title="Desbloquear portal" id="desbloquear_portal" class="fa-tooltip icono_datatable icono_rojo"><i class="fas fa-user-lock"></i></a> ';

          return editar + acceso + bloqueo + eliminar;
          //  antesreturn editar + accion + bloqueo + acceso +  eliminar;
        }
      }
    ],
    "columnDefs": [{
      "targets": [2, 4], // Índices de las columnas a ocultar en pantallas pequeñas
      "className": 'hide-on-small' // Clase personalizada para ocultar
    }],
    "responsive": {
      details: {
        type: 'column',
        target: 'tr'
      }
    },
    "scrollX": true,
    fnDrawCallback: function(oSettings) {
      $('a[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
      });
    },
    rowCallback: function(row, data) {
      $("a#editar", row).bind('click', () => {


        console.log('abriendo editar  ');
        $("#idPortalE").val(data.idPortal);
        $("#idFacturacionE").val(data.idFac);
        $("#idDomiciliosE").val(data.idDom);
        $("#idUsuarioPortalE").val(data.id_usuario_portal);

        // Generales
        $("#nombrePortal_edit").val(data.nombre);
        $("#accesosEdit").val(data.usuarios_permitidos);
        // Domicilio
        $("#pais_edit").val(data.pais);
        $("#ciudad_edit").val(data.ciudad);
        $("#estado_edit").val(data.estado);
        $("#numero_exterior_edit").val(data.exterior);
        $("#numero_interior_edit").val(data.interior);
        $("#calle_edit").val(data.calle);
        $("#numero_cp_edit").val(data.cp);
        $("#colonia_edit").val(data.colonia);

        // Datos de Facturación
        $("#razon_social_edit").val(data.razon_social);
        $("#rfc_edit").val(data.rfc);
        $("#regimen_edit").val(data.regimen);
        $("#forma_pago_edit").val(data.forma_pago);
        $("#metodo_pago_edit").val(data.metodo_pago);
        $("#uso_cfdi_edit").val(data.uso_cfdi);

        // Mostrar el modal
        $("#editPortal").modal("show");
      });
      $("a#activar", row).bind('click', () => {
        mostrarMensajeConfirmacion('activar portal', data.nombre, data.idPortal)
      });
      $("a#desactivar", row).bind('click', () => {
        mostrarMensajeConfirmacion('desactivar portal', data.nombre, data.idPortal)
      });
      $("a#bloquear_portal", row).bind('click', () => {
        mostrarMensajeConfirmacion('bloquear portal', data.nombre, data.idPortal)
      });
      $("a#desbloquear_portal", row).bind('click', () => {
        mostrarMensajeConfirmacion('desbloquear portal', data.nombre, data.idPortal)
      });
      $("a#eliminar", row).bind('click', () => {
        mostrarMensajeConfirmacion('eliminar portal', data.nombre, data.idPortal)
      });
      $("a#acceso", row).bind('click', () => {
        $(".nombreCliente").text(data.nombre);
        mostrarLoader();

        $.ajax({

          url: '<?php echo base_url('Cat_Portales/getPortalesAccesos'); ?>',
          type: 'post',
          data: {
            'idPortal': data.idPortal
          },

          beforeSend: function() {
            mostrarLoader();
          },
          success: function(res) {
            ocultarLoader();
            console.log(res);
            if (res !== 0) {
              let datos = JSON.parse(res);
              let salida = generarTabla(datos);
              $("#div_accesos").html(salida);
            } else {
              mostrarMensajeNoRegistros();
            }
          }
        });

        mostrarModal();
      });

      function mostrarModal() {
        $("#accesosClienteModal").modal('show');
      }

      function mostrarLoader() {
        $('.loader').css("display", "block");
      }

      function ocultarLoader() {
        setTimeout(() => {
          $('.loader').fadeOut();
        }, 200);
      }

      function generarTabla(datos) {
        let salida = `<table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Usuario</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Alta</th>           
                        </tr>
                    </thead>
                    <tbody>`;

        datos.forEach(dato => {
          let usuarioCliente = dato['usuario_portal'] === null ? 'Pendiente de registrar' : dato[
            'usuario_portal'];
          let privacidad = dato['privacidad'] > 0 ? `Nivel ${dato['privacidad']}` : 'Sin privacidad';
          let fecha = fechaCompletaAFront(dato['alta']);

          salida += `<tr id="${dato['idUsuarioCliente']}">
                        <th>${dato['usuario']}</th>
                        <th>${dato['correo_usuario']}</th>
                        <th>${fecha}</th>
                      
                      
                      
                    </tr>`;
        });

        salida += `</tbody>
                </table>`;

        return salida;
      }

      function mostrarMensajeNoRegistros() {
        $('#div_accesos').html(
          '<p style="text-align:center; font-size: 20px;">No hay registro de accesos</p>');
      }
      $("a#desactivar_acceso", row).bind('click', () => {
        $.ajax({
          url: '<?php echo base_url('Cliente/controlAccesoCliente'); ?>',
          type: 'post',
          data: {
            'idUsuarioCliente': data.idUsuarioCliente,
            'activo': 0
          },
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            console.log(res);
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            $("#mensajeModal").modal('hide');
            recargarTable();
            $("#texto_msj").text('Se ha actualizado exitosamente');
            $("#mensaje").css('display', 'block');
            setTimeout(function() {
              $('#mensaje').fadeOut();
            }, 4000);
          }
        });
      });
      $("a#activar_acceso", row).bind('click', () => {
        $.ajax({
          url: '<?php echo base_url('Cliente/controlAccesoCliente'); ?>',
          type: 'post',
          data: {
            'idUsuarioCliente': data.idUsuarioCliente,
            'activo': 1
          },
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            console.log(res);
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            $("#mensajeModal").modal('hide');
            recargarTable();
            $("#texto_msj").text('Se ha actualizado exitosamente');
            $("#mensaje").css('display', 'block');
            setTimeout(function() {
              $('#mensaje').fadeOut();
            }, 4000);
          }
        });
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

  $(window).on('resize', function() {
    tabla.columns.adjust().draw();
  });
});


function mostrarMensajeConfirmacion(accion, valor1, valor2) {
  if (accion == "activar portal") {
    $('#titulo_mensaje1').text('Activar portal');
    $('#mensaje').html('¿Desea activar al portal <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "accionPortal('activar'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "desactivar portal") {
    $('#titulo_mensaje1').text('Desactivar portal');
    $('#mensaje').html('¿Desea desactivar al portal <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "accionPortal('desactivar'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar portal") {
    $('#titulo_mensaje1').text('Eliminar portal');
    $('#mensaje').html('¿Desea eliminar al portal <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "accionPortal('eliminar'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar usuario portal") {
    $('#titulo_mensaje1').text('Eliminar usuario');
    $('#mensaje').html('¿Desea eliminar al usuario <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "controlAcceso('eliminar'," + valor2 + ")");
    $("#accesosClienteModal").modal('hide')
    $('#mensajeModal').modal('show');
  }
  if (accion == "bloquear portal") {
    $('#titulo_mensaje1').text('Bloquear portal');
    $('#mensaje').html('¿Desea bloquear al portal <b>' + valor1 + '</b>?');
    $('#mensaje').append(
      '<div class="row mt-3"><div class="col-12"><label>Motivo de bloqueo *</label><select class="form-control" id="opcion_motivo" name="opcion_motivo"><option value="">Selecciona</option>' +
      tipos_bloqueo_php +
      '</select></div></div><div class="row mt-3"><div class="col-12"><label>Mensaje para presentar en panel del portal *</label><textarea class="form-control" rows="5" id="mensaje_comentario" name="mensaje_comentario">¡Lo sentimos! Su acceso ha sido interrumpido por falta de pago. Favor de comunicarse al teléfono 33 3454 2877.</textarea></div></div>'
    );
    $('#btnConfirmar').attr("onclick", "accionPortal('bloquear'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "desbloquear portal") {
    $('#titulo_mensaje5').text('Desbloquear portal');
    $('#mensaje').html('¿Desea desbloquear al cliente <b>' + valor1 + '</b>?');
    $('#mensaje').append(
      '<div class="row mt-3"><div class="col-12"><label>Razón de desbloqueo *</label><select class="form-control" id="opcion_motivo" name="opcion_motivo"><option value="">Selecciona</option>' +
      tipos_desbloqueo_php + '</select></div></div>');
    $('#btnConfirmar').attr("onclick", "accionPortal('desbloquear'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }

}




function accionPortal(accion, id, correo = null) {
  console.log("id del portal:  " + id + "  accion d a realizar:  " + accion)
  let opcion_motivo = $('#mensajeModal #opcion_motivo').val()
  let opcion_descripcion = $("#mensajeModal #opcion_motivo option:selected").text();
  let mensaje_comentario = $('#mensajeModal #mensaje_comentario').val()
  let bloquear_subclientes = $("#mensajeModal #bloquear_subclientes").is(":checked") ? 'SI' : 'NO';

  $.ajax({
    url: '<?php echo base_url('Cat_Portales/status'); ?>',
    type: 'POST',
    data: {
      'idPortal': id,
      'accion': accion,
      'opcion_motivo': opcion_motivo,
      'mensaje_comentario': mensaje_comentario,
      'opcion_descripcion': opcion_descripcion,
      'bloquear_subclientes': bloquear_subclientes
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
        $("#mensajeModal").modal('hide')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 2500
        })
      }
    }
  });
}


/*Funcion para  crear  acesos  para  los usuarios de los clientes, esta  captura
los datos  del formulario mdl_cat_cliente los transforma en JSon y los envia Medisnte  El protocolo POST
  al archivo Cat_usuario a la funcion addUsuario */


function recargarTable() {
  $("#tabla").DataTable().ajax.reload();
}


function uploadFile(event, idPortal) {


  // Opcional: Pausar la ejecución para inspeccionar el estado
  // debugger;

  // Detener la ejecución si solo quieres ver los datos
  // return;

  const file = event.target.files[0];
  if (file) {
    const formData = new FormData();
    formData.append('file', file);
    formData.append('idPortal', idPortal);

    fetch('<?php echo base_url('Cat_Portales/subirConstancia'); ?>', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        console.log('Éxito:', data);

        // Mostrar mensaje con SweetAlert2
        if (data.codigo === 1) {
          Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: data.mensaje,
          }).then((result) => {
            if (result.isConfirmed) {
              // Refrescar la página al confirmar el mensaje de éxito
              location.reload();
            }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: data.mensaje,
          });
        }
      })
      .catch((error) => {
        console.error('Error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Ocurrió un error al intentar subir el archivo.',
        });
      });
  }
}
</script>