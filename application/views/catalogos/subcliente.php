<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="align-items-center mb-4">
    <div class="row">
      <div class="col-sm-12 col-md-8">
        <h1 class="h3 mb-0 text-gray-800">Subclientes</h1>
      </div>
      <div class="col-sm-12 col-md-2">
        <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#newModal"
          onclick="registrarCliente()">
          <span class="icon text-white-50">
            <i class="fas fa-plus-circle"></i>
          </span>
          <span class="text">Agregar subcliente</span>
        </a>
      </div>
      <div class="col-sm-12 col-md-2">
        <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#accesoModal">
          <span class="icon text-white-50">
            <i class="fas fa-plus-circle"></i>
          </span>
          <span class="text">Acceso subclientes</span>
        </a>
      </div>
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
  <input type="hidden" id="idCliente">
  <input type="hidden" id="idSubcliente">
  <input type="hidden" id="idUsuarioSubcliente">

</div>
<!-- /.content-wrapper -->
<script>
var url = '<?php echo base_url('Cat_Subclientes/getSubclientes'); ?>';
$(document).ready(function() {
  $('[data-toggle="tooltip"]').tooltip();
  $('#newModal').on('shown.bs.modal', function() {
    $(this).find('input[type=text],select,textarea').filter(':visible:first').focus();
  });
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
  $('#tabla').DataTable({
    "pageLength": 25,
    //"pagingType": "simple",
    "order": [0, "desc"],
    "stateSave": true,
    "ajax": url,
    "columns": [{
        title: 'id',
        data: 'id',
        visible: false
      },
      {
        title: 'Nombre',
        data: 'nombre_subcliente',
        bSortable: false,
        "width": "20%",
      },
      {
        title: 'Clave',
        data: 'clave_subcliente',
        bSortable: false,
        "width": "3%",
      },
      {
        title: 'Cliente',
        data: 'cliente',
        bSortable: false,
        "width": "15%",
      },
      {
        title: 'Fecha de alta',
        data: 'creacion',
        bSortable: false,
        "width": "10%",
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
        title: 'Accesos',
        data: 'numero_accesos',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          if (data == 0) {
            return 'Sin registro de accesos';
          } else {
            return 'Cuenta con ' + data + ' registro(s) de acceso';
          }
        }
      },
      {
        title: 'Operaciones',
        data: 'id',
        bSortable: false,
        "width": "10%",
        mRender: function(data, type, full) {
          let editar =
            '<a id="editar" href="javascript:void(0)" data-toggle="tooltip" title="Editar" class="fa-tooltip icono_datatable icono_azul_oscuro"><i class="fas fa-edit"></i></a> ';
          let eliminar =
            '<a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar cliente" id="eliminar" class="fa-tooltip icono_datatable icono_gris"><i class="fas fa-trash"></i></a> ';
          let acceso =
            '<a href="javascript:void(0)" data-toggle="tooltip" title="Ver accesos" id="acceso" class="fa-tooltip icono_datatable icono_azul_claro"><i class="fas fa-sign-in-alt"></i></a>';

          let accion = (full.status == 0) ?
            '<a href="javascript:void(0)" data-toggle="tooltip" title="Activar" id="activar" class="fa-tooltip icono_datatable icono_rojo"><i class="fas fa-ban"></i></a> ' :
            '<a href="javascript:void(0)" data-toggle="tooltip" title="Desactivar" id="desactivar" class="fa-tooltip icono_datatable icono_verde"><i class="far fa-check-circle"></i></a> ';



          return editar + accion + eliminar + acceso;
        }
      }
    ],
    fnDrawCallback: function(oSettings) {
      $('a[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
      });
    },
    rowCallback: function(row, data) {
      // Eliminar  Coodigo Despues  console.log(data);
      $("a#editar", row).bind('click', () => {
        resetModal();
        $("#idCliente").prop('disabled', true);
        $("#idCliente").val(data.id_cliente);
        $("#idSubCliente").val(data.idSub);
        $("#idFacturacion").val(data.id_datos_facturacion);
        $("#idDomicilios").val(data.id_domicilios);
        $("#idGenerales").val(data.id_datos_generales);
        $("#titulo_nuevo_modal").text("Editar Sub-Cliente");
        $("#nombreSubcliente").val(data.nombre_subcliente);
        $("#claveSubcliente").val(data.clave_subcliente);


        // Generales
        $("#telefono").val(data.telefono);
        $("#correo").val(data.correo);
        $("#nombreContacto").val(data.nombre);
        $("#apellidoContacto").val(data.paterno);

        // Domicilio
        cargarDatosDomicilioGeneral(data);
        $("#numero_exterior").val(data.exterior);
        $("#numero_interior").val(data.interior);
        $("#calle").val(data.calle);
        $("#cp").val(data.cp);
        $("#colonia").val(data.colonia);

        // Datos de Facturación
        $("#razonSocial").val(data.razon_social);

        $("#rfc").val(data.rfc);




        $("#newModal").modal("show");

      });
      $("a#activar", row).bind('click', () => {
        mostrarMensajeConfirmacion('activar cliente', data.nombre_subcliente, data.idSub)
      });
      $("a#desactivar", row).bind('click', () => {
        mostrarMensajeConfirmacion('desactivar cliente', data.nombre_subcliente, data.idSub)
      });
      $("a#bloquear_cliente", row).bind('click', () => {
        mostrarMensajeConfirmacion('bloquear cliente', data.nombre_subcliente, data.idSub)
      });
      $("a#desbloquear_cliente", row).bind('click', () => {
        mostrarMensajeConfirmacion('desbloquear cliente', data.nombre_subcliente, data.idSub)
      });
      $("a#eliminar", row).bind('click', () => {
        mostrarMensajeConfirmacion('eliminar cliente', data.nombre_subcliente, data.idSub)
      });
      $("a#acceso", row).bind('click', () => {
        $.ajax({
          url: '<?php echo base_url('Cat_Subclientes/getSubclientesAccesos'); ?>',
          type: 'post',
          data: {
            'id_subcliente': data.id
          },
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            $("#nombreSubcliente").text(data.nombre);
            $("#div_accesos").html(res);
            $("#accesosClienteModal").modal('show');
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

  function cargarDatosDomicilioGeneral(datos) {
    var auth_token = "MUJkuDQTBwg6L_OLJghlvf5LDwdas3Tnm5EaF3Kny_7GIUXTah_7nbuE-K15HdxxTxo";

    // Obtener token de acceso
    $.ajax({
      url: 'https://www.universal-tutorial.com/api/getaccesstoken',
      method: 'GET',
      headers: {
        "Accept": "application/json",
        "api-token": auth_token,
        "user-email": "rodi.control@gmail.com"
      },
      success: function(data) {
        if (data.auth_token) {
          var auth_token = data.auth_token;

          // Cargar países
          $.ajax({
            url: 'https://www.universal-tutorial.com/api/countries/',
            method: 'GET',
            headers: {
              "Authorization": "Bearer " + auth_token,
              "Accept": "application/json"
            },
            success: function(data) {
              var countries = data;
              var comboCountries = "<option value='" + datos.pais + "'>" + datos.pais + "</option>";
              countries.forEach(element => {
                comboCountries += '<option value="' + element['country_name'] + '">' + element[
                  'country_name'] + '</option>';
              });

              $("#item-details-countryValue").html(comboCountries);
              if (datos.pais !== '') {
                $("#item-details-countryValue").val(datos.pais);
              } else {
                $("#item-details-countryValue").val("Selecciona un Pais");
              }

              // Obtener estados
              $.ajax({
                url: 'https://www.universal-tutorial.com/api/states/' + datos.pais,
                method: 'GET',
                headers: {
                  "Authorization": "Bearer " + auth_token,
                  "Accept": "application/json"
                },
                success: function(data) {
                  var states = data;
                  var comboStates = "<option value='" + datos.estado + "'>" + datos.estado +
                    "</option>";
                  states.forEach(element => {
                    comboStates += '<option value="' + element['state_name'] + '">' + element[
                      'state_name'] + '</option>';
                  });

                  $("#item-details-stateValue").html(comboStates);
                  $("#item-details-stateValue").val(datos.estado);

                  // Obtener ciudades
                  $.ajax({
                    url: 'https://www.universal-tutorial.com/api/cities/' + datos.estado,
                    method: 'GET',
                    headers: {
                      "Authorization": "Bearer " + auth_token,
                      "Accept": "application/json"
                    },
                    success: function(data) {
                      var cities = data;
                      var comboCities = "<option value='" + datos.ciudad + "'>" + datos
                        .ciudad + "</option>";
                      cities.forEach(element => {
                        comboCities += '<option value="' + element['city_name'] + '">' +
                          element['city_name'] + '</option>';
                      });

                      $("#item-details-cityValue").html(comboCities);
                    },
                    error: function(e) {
                      console.log("Error al obtener ciudades: " + e);
                    }
                  });

                  // Evento onchange para el país
                  $("#item-details-countryValue").on("change", function() {
                    var country = this.value;

                    // Obtener estados al cambiar el país
                    $.ajax({
                      url: 'https://www.universal-tutorial.com/api/states/' + country,
                      method: 'GET',
                      headers: {
                        "Authorization": "Bearer " + auth_token,
                        "Accept": "application/json"
                      },
                      success: function(data) {
                        var states = data;
                        var comboStates = "<option value=''>Estados de: " + country +
                          "</option>";
                        states.forEach(element => {
                          comboStates += '<option value="' + element['state_name'] +
                            '">' + element['state_name'] + '</option>';
                        });

                        $("#item-details-stateValue").html(comboStates);
                        $("#item-details-stateValue").val(
                          ""); // Limpiar el valor del estado al cambiar el país

                        // Obtener ciudades al cambiar el estado
                        $("#item-details-stateValue").on("change", function() {
                          var state = this.value;

                          $.ajax({
                            url: 'https://www.universal-tutorial.com/api/cities/' +
                              state,
                            method: 'GET',
                            headers: {
                              "Authorization": "Bearer " + auth_token,
                              "Accept": "application/json"
                            },
                            success: function(data) {
                              var cities = data;
                              var comboCities =
                                "<option value=''>Ciudades de: " +
                                state + "</option>";
                              cities.forEach(element => {
                                comboCities += '<option value="' +
                                  element[
                                    'city_name'] + '">' + element[
                                    'city_name'] +
                                  '</option>';
                              });

                              $("#item-details-cityValue").html(comboCities);
                              $("#item-details-cityValue").val(
                                ""
                              ); // Limpiar el valor de la ciudad al cambiar el estado
                            },
                            error: function(e) {
                              console.log("Error al obtener ciudades: " + e);
                            }
                          });
                        });
                      },
                      error: function(e) {
                        console.log("Error al obtener estados: " + e);
                      }
                    });
                  });
                },
                error: function(e) {
                  console.log("Error al obtener estados: " + e);
                }
              });
            },
            error: function(e) {
              console.log("Error al obtener países: " + e);
            }
          });
        }
      },
      error: function(e) {
        console.log("Error al obtener el token de acceso: " + e);
      }
    });
  }

   $("#crear_acceso").click(function() {
     var nombre = $("#nombre_cliente").val();
     var paterno = $("#paterno_cliente").val();
     var correo = $("#correo_cliente").val();
     var password = $("#password").val();
     var id_subcliente = $("#id_subcliente").val();
     var id_cliente = $("#id_cliente").val();

     $.ajax({
       url: '<?php echo base_url('Cat_Subclientes/registrarUsuario'); ?>',
       type: 'POST',
       data: {
         'nombre': nombre,
         'paterno': paterno,
         'correo': correo,
         'password': password,
         'id_subcliente': id_subcliente,
         'id_cliente': id_cliente
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
           $("#accesoModal").modal('hide')
           recargarTable()
           Swal.fire({
             position: 'center',
             icon: 'success',
             title: 'Se ha guardado correctamente',
             showConfirmButton: false,
             timer: 2500
           })
         } else {
           $("#accesoModal #msj_error").css('display', 'block').html(data.msg);
         }
       }
     });
   });
  function mostrarMensajeConfirmacion(accion, valor1, valor2) {
    if (accion == "activar cliente") {
      $('#titulo_mensaje1').text('Activar cliente');
      $('#mensaje').html('¿Desea activar al cliente <b>' + valor1 + '</b>?');
      $('#btnConfirm').attr("onclick", "accionesSubcliente('activar'," + valor2 + ")");
      $('#mensajeModal').modal('show');
    }
    if (accion == "desactivar cliente") {
      $('#titulo_mensaje2').text('Desactivar cliente');
      $('#mensaje').html('¿Desea desactivar al cliente <b>' + valor1 + '</b>?');
      $('#btnConfirm').attr("onclick", "accionesSubcliente('desactivar'," + valor2 + ")");
      $('#mensajeModal').modal('show');
    }
    if (accion == "eliminar cliente") {
      $('#titulo_mensaje3').text('Eliminar cliente');
      $('#mensaje').html('¿Desea eliminar al cliente <b>' + valor1 + '</b>?');
      $('#btnConfirm').attr("onclick", "accionesSubcliente('eliminar'," + valor2 + ")");
      $('#mensajeModal').modal('show');
    }
    if (accion == "eliminar usuario cliente") {
      $('#titulo_mensaje4').text('Eliminar usuario');
      $('#mensaje').html('¿Desea eliminar al usuario <b>' + valor1 + '</b>?');
      $('#btnConfirm').attr("onclick", "controlAcceso('eliminar'," + valor2 + ")");
      $("#accesosClienteModal").modal('hide')
      $('#mensajeModal').modal('show');
    }
    if (accion == "bloquear cliente") {
      $('#titulo_mensaje5').text('Bloquear cliente');
      $('#mensaje').html('¿Desea bloquear al cliente <b>' + valor1 + '</b>?');
      $('#mensaje').append(
        '<div class="row mt-3"><div class="col-12"><label>Motivo de bloqueo *</label><select class="form-control" id="opcion_motivo" name="opcion_motivo"><option value="">Selecciona</option>' +
        tipos_bloqueo_php +
        '</select></div></div><div class="row mt-3"><div class="col-12"><label>Mensaje para presentar en panel del cliente *</label><textarea class="form-control" rows="5" id="mensaje_comentario" name="mensaje_comentario">¡Lo sentimos! Su acceso ha sido interrumpido por falta de pago. Favor de comunicarse al teléfono 33 3454 2877.</textarea></div></div>'
      );
      $('#mensaje').append(
        '<div class="row mt-3"><div class="col-12"><label class="container_checkbox">Bloquear también subclientes/proveedores<input type="checkbox" id="bloquear_subclientes" name="bloquear_subclientes"><span class="checkmark"></span></label></div></div>'
      );
      $('#btnConfirm').attr("onclick", "accionesSubcliente('bloquear'," + valor2 + ")");
      $('#mensajeModal').modal('show');
    }
    if (accion == "desbloquear cliente") {
      $('#titulo_mensaje6').text('Desbloquear Sub-Cliente');
      $('#mensaje').html('¿Desea desbloquear al cliente <b>' + valor1 + '</b>?');
      $('#mensaje').append(
        '<div class="row mt-3"><div class="col-12"><label>Razón de desbloqueo *</label><select class="form-control" id="opcion_motivo" name="opcion_motivo"><option value="">Selecciona</option>' +
        tipos_desbloqueo_php + '</select></div></div>');
      $('#btnConfirm').attr("onclick", "accionesSubcliente('desbloquear'," + valor2 + ")");
      $('#mensajeModal').modal('show');
    }
  }

  




  $("#id_cliente").change(function() {
    var id_cliente = $(this).val();
    var id_subcliente = $("#subcliente").val();
    if (id_cliente != "") {
      $.ajax({
        url: '<?php echo base_url('Cat_Subclientes/getOpcionesSubclientes'); ?>',
        method: 'POST',
        data: {
          'id_cliente': id_cliente
        },
        dataType: "text",
        success: function(res) {
          //Borrar despues console.log(res+"     aqui res ")
          $('#id_subcliente').prop('disabled', false);
          $('#id_subcliente').html(res);
        }
      });
    } else {
      $('#id_subcliente').prop('disabled', true);
      $('#id_subcliente').val('');
    }
  });

});
function accionesSubcliente(accion, id) {
    let opcion_motivo = $('#mensajeModal #opcion_motivo').val();
    let opcion_descripcion = $("#mensajeModal #opcion_motivo option:selected").text();
    let mensaje_comentario = $('#mensajeModal #mensaje_comentario').val();
    let bloquear_subclientes = $("#mensajeModal #bloquear_subclientes").is(":checked") ? 'SI' : 'NO';
    $.ajax({
      url: "<?php echo base_url('Cat_Subclientes/accionSubclientes'); ?>",
      type: 'POST',
      data: {
        'idSubcliente': id,
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
          $("#mensajeModal").modal('hide');
          recargarTable();
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: data.msg,
            showConfirmButton: false,
            timer: 2500
          });
        }
      }
    });
  }

function eliminarAcceso(idUsuarioSubcliente) {
  $("tr#" + idUsuarioSubcliente).hide();
  $.ajax({
    url: '<?php echo base_url('Cat_Subclientes/controlAcceso'); ?>',
    type: 'post',
    data: {
      'idUsuarioSubcliente': idUsuarioSubcliente,
      'activo': -1
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
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha eliminado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      }
    }
  });
}

function generarPassword() {
  $.ajax({
    url: '<?php echo base_url('Funciones/generarPassword'); ?>',
    type: 'post',
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      $("#password").val(res)
    }
  });
}

function recargarTable() {
  $("#tabla").DataTable().ajax.reload();
}

function ejecutarOperacion() {
  var accion = $("#accion").val();
  var id = $("#idSubcliente").val();
  var id_usuario_subcliente = $("#idUsuarioSubcliente").val();
  $.ajax({
    url: '<?php echo base_url('Cat_Subclientes/accion'); ?>',
    type: 'post',
    data: {
      'id': id,
      'id_usuario_subcliente': id_usuario_subcliente,
      'accion': accion
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
        $("#quitarModal").modal('hide')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha actualizado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      }
    }
  });
}
</script>