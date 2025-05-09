<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="align-items-center mb-4">
    <div class="row justify-content-between">
      <div class="col-sm-12 col-md-8">
        <h2 >Administración de Sucursales</h1>
      </div>

      <div class="col-sm-12 col-md-3">
        <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#newModal"
          onclick="registrarCliente()">
          <span class="icon text-white-50">
            <i class="fas fa-user-tie"></i>
          </span>
          <span class="text">Crear Sucursal</span>
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
    <div>
      <p>Este módulo permite la gestión completa de usuarios externos y sucursales, con funciones para <br>registrar,
        actualizar, eliminar y mantener la información de manera organizada y eficiente.</p>
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
  <input type="hidden" id="idUsuarioCliente">


</div>



<div class="modal fade" id="enviarCredenciales" tabindex="-1" role="dialog" aria-labelledby="mensajeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_mensaje_contraseña">Registrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="modal-body" id="mensaje_contraseña"></div> <!-- Centrar el contenido -->
          <div class="col-md-9">
            <label>Generar Contraseña*</label>
            <div class="input-group">
              <input type="text" class="form-control" name="password_cliente" id="password_cliente" maxlength="8"
                readonly>
              <div class="input-group-append">
                <button type="button" class="btn btn-primary" onclick="generarPassword1()">Generar</button>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" class="form-control" name="idDatosGeneralesEditPass" id="idDatosGeneralesEditPass">
        <input type="hidden" class="form-control" name="idCorreo" id="idCorreo">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="btnEnviarPass">Reenviar contraseña</button>
      </div>
    </div>
  </div>
</div>

<!-- /.content-wrapper -->
<script>
var url = '<?php echo base_url('Cat_Cliente/getClientes'); ?>';
var tipos_bloqueo_php =
  '<?php foreach ($tipos_bloqueo as $row) {echo '<option value="' . $row->tipo . '">' . $row->descripcion . '</option>';}?>';
var tipos_desbloqueo_php =
  '<?php foreach ($tipos_desbloqueo as $row) {echo '<option value="' . $row->tipo . '">' . $row->descripcion . '</option>';}?>';
$(document).ready(function() {
  $("#cerrarModal").on("click", function() {


    // Resetea el formulario al cerrar el modal
    $("#formCatCliente")[0].reset();
  });

  //console.log('Documento listo. Iniciando script.');
  $('[data-toggle="tooltip"]').tooltip();
  $('#newModal').on('shown.bs.modal', function() {

    //$(this).find('input[type=text],select,textarea').filter(':visible:first').focus();
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
        title: 'id',
        data: 'id',
        visible: false
      },
      {
        title: 'Nombre',
        data: 'nombre',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return '<span class="badge badge-pill badge-dark">#' + full.idCliente + '</span><br><b>' + data +
            '</b>';
        }
      },
      {
        title: 'Clave',
        data: 'clave',
        bSortable: false,
        "width": "3%",
        mRender: function(data, type, full) {
          return '<b>' + data + '</b>';
        }
      },
      {
        title: 'Fecha de Cracion',
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
        title: 'Accesos',
        data: 'numero_usuarios_clientes',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          if (data == 0) {
            return 'No access records found';
          } else {
            return 'Cuenta con ' + data + ' acceso(s) ';
          }
        }
      },
      {
        title: 'Acciones',
        data: 'id',
        bSortable: false,
        "width": "15%",
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

          let bloqueo = (full.bloqueado === 'NO') ?
            ' <a href="javascript:void(0)" data-toggle="tooltip" title="Bloquear cliente" id="bloquear_cliente" class="fa-tooltip icono_datatable icono_verde"><i class="fas fa-user-check"></i></a> ' :
            ' <a href="javascript:void(0)" data-toggle="tooltip" title="Desbloquear cliente" id="desbloquear_cliente" class="fa-tooltip icono_datatable icono_rojo"><i class="fas fa-user-lock"></i></a> ';

          return editar + accion + eliminar + acceso + bloqueo;
        }
      }
    ],
    "columnDefs": [{
      "targets": [2, 3, 4], // Índices de las columnas a ocultar en pantallas pequeñas
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
        resetModal();
        
        $("#idCliente").val(data.idCliente);
        $("#idFacturacion").val(data.dFac);
        $("#idDomicilios").val(data.dDom);
        $("#idGenerales").val(data.dGen);

        $("#titulo_nuevo_modal").text("Editar cliente");

        // Generales
        $("#nombre").val(data.nombre);
        $("#clave").val(data.clave);
        $("#empleados").val(data.max_colaboradores);
        // Domicilio
        $("#item-details-countryValue").val(data.pais);
        $("#item-details-stateValue").val(data.estado);
        $("#item-details-cityValue").val(data.ciudad);
        $("#numero_exterior").val(data.exterior);
        $("#numero_interior").val(data.interior);
        $("#calle").val(data.calle);
        $("#cp").val(data.cp);

        $("#colonia").val(data.colonia);

        // Datos de Facturación
        $("#razon_social").val(data.razon_social);
        $("#telefono").val(data.telefono_contacto);
        $("#correo").val(data.correo_contacto);

        $("#nombre_contacto").val(data.nombre_contacto);
        $("#apellido_contacto").val(data.apellido_contacto);
        $("#rfc").val(data.rfc);
        $("#regimen").val(data.regimen);
        $("#forma_pago").val(data.forma_pago).change();
        $("#metodo_pago").val(data.metodo_pago).change();
        $("#uso_cfdi").val(data.uso_cfdi);

        $("#password").val(data.password_contacto).hide().prev("label").hide();
        $("#generarPass").hide();
        $("#passLabel").hide();
        // Ocultar elementos


        // Mostrar el modal
        $("#newModal").modal("show");
      });
      $("a#activar", row).bind('click', () => {
        mostrarMensajeConfirmacion('activar cliente', data.nombre, data.idCliente)
      });
      $("a#desactivar", row).bind('click', () => {
        mostrarMensajeConfirmacion('desactivar cliente', data.nombre, data.idCliente)
      });
      $("a#bloquear_cliente", row).bind('click', () => {
        mostrarMensajeConfirmacion('bloquear cliente', data.nombre, data.idCliente)
      });
      $("a#desbloquear_cliente", row).bind('click', () => {
        mostrarMensajeConfirmacion('desbloquear cliente', data.nombre, data.idCliente)
      });
      $("a#eliminar", row).bind('click', () => {
        mostrarMensajeConfirmacion('eliminar cliente', data.nombre, data.idCliente)
      });
      $("a#acceso", row).bind('click', () => {
        $(".nombreCliente").text(data.nombre);
        mostrarLoader();

        $.ajax({
          url: '<?php echo base_url('Cat_Cliente/getClientesAccesos'); ?>',
          type: 'post',
          data: {
            'id_cliente': data.idCliente
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
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Alta</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>`;

        datos.forEach(dato => {
          let usuarioCliente = dato['usuario_cliente'] === null ? 'Pendiente de registrar' : dato[
            'usuario_cliente'];
          let privacidad = dato['privacidad'] > 0 ? `Nivel ${dato['privacidad']}` : 'Sin privacidad';
          let fecha = fechaCompletaAFront(dato['alta']);

          salida += `<tr id="${dato['idUsuarioCliente']}">
                        <th>${usuarioCliente}</th>
                        <th>${dato['correo_usuario']}</th>
                        <th>${fecha}</th>
                        <th>${dato['usuario']}</th>
                        <th>${privacidad}</th>
                        <th>
                            <a href="javascript:void(0)" class="fa-tooltip icono_datatable icono_accion_gris" onclick="mostrarMensajeConfirmacion('eliminar usuario cliente', '${usuarioCliente}', ${dato['idUsuarioCliente']})"><i class="fas fa-trash"></i></a>
                            <a href="javascript:void(0)" class="fa-tooltip icono_datatable icono_accion_amarillo" onclick="enviarCredenciales( '${dato['correo_usuario']}', ${dato['id_datos_generales']})"><i class="fas fa-sync-alt style="font-size: 16px;"></i></a>
                        </th>
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
      "lengthMenu": "Mostrar _MENU_ registros",
      "zeroRecords": "No se encontraron registros",
      "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(Filtrado de _MAX_ registros en total)",
      "sSearch": "Buscar:",
      "oPaginate": {
        "sLast": "Última página",
        "sFirst": "Primera",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      }
    }

  });
  // Ajuste adicional si es necesario
  $(window).on('resize', function() {
    tabla.columns.adjust().draw();
  });

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
                    var comboCities = "<option value='" + datos.ciudad + "'>" + datos.ciudad +
                      "</option>";
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
                            var comboCities = "<option value=''>Ciudades de: " +
                              state + "</option>";
                            cities.forEach(element => {
                              comboCities += '<option value="' + element[
                                  'city_name'] + '">' + element['city_name'] +
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

function mostrarMensajeConfirmacion(accion, valor1, valor2) {
  if (accion == "activar cliente") {
    $('#titulo_mensaje1').text('Activar cliente');
    $('#mensaje').html('¿Desea activar al cliente <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "accionCliente('activar'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "desactivar cliente") {
    $('#titulo_mensaje1').text('Desactivar cliente');
    $('#mensaje').html('¿Desea desactivar al cliente <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "accionCliente('desactivar'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar cliente") {
    $('#titulo_mensaje1').text('Eliminar cliente');
    $('#mensaje').html('¿Desea eliminar al cliente <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "accionCliente('eliminar'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar usuario cliente") {
    $('#titulo_mensaje1').text('Eliminar usuario');
    $('#mensaje').html('¿Desea eliminar al usuario <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "controlAcceso('eliminar'," + valor2 + ")");
    $("#accesosClienteModal").modal('hide')
    $('#mensajeModal').modal('show');
  }
  if (accion == "bloquear cliente") {
    $('#titulo_mensaje1').text('Bloquear cliente');
    $('#mensaje').html('¿Desea bloquear al cliente <b>' + valor1 + '</b>?');
    $('#mensaje').append(
      '<div class="row mt-3"><div class="col-12"><label>Motivo de bloqueo *</label><select class="form-control" id="opcion_motivo" name="opcion_motivo"><option value="">Selecciona</option>' +
      tipos_bloqueo_php +
      '</select></div></div><div class="row mt-3"><div class="col-12"><label>Mensaje para presentar en panel del cliente *</label><textarea class="form-control" rows="5" id="mensaje_comentario" name="mensaje_comentario">¡Lo sentimos! Su acceso ha sido interrumpido por falta de pago. Favor de comunicarse al teléfono 33 3454 2877.</textarea></div></div>'
    );
    $('#mensaje').append(
      '<div class="row mt-3"><div class="col-12"><label class="container_checkbox">Bloquear también subclientes/proveedores<input type="checkbox" id="bloquear_subclientes" name="bloquear_subclientes"><span class="checkmark"></span></label></div></div>'
    );
    $('#btnConfirmar').attr("onclick", "accionCliente('bloquear'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "desbloquear cliente") {
    $('#titulo_mensaje5').text('Desbloquear cliente');
    $('#mensaje').html('¿Desea desbloquear al cliente <b>' + valor1 + '</b>?');
    $('#mensaje').append(
      '<div class="row mt-3"><div class="col-12"><label>Razón de desbloqueo *</label><select class="form-control" id="opcion_motivo" name="opcion_motivo"><option value="">Selecciona</option>' +
      tipos_desbloqueo_php + '</select></div></div>');
    $('#btnConfirmar').attr("onclick", "accionCliente('desbloquear'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }

}


function enviarCredenciales(valor1, valor2) {
  $('#titulo_mensaje_contraseña').text('Reenviar Contraseña' + valor2);
  $('#mensaje_contraseña').html('¿Deseas actualizar la contraseña  al usuario <b>' + valor1 + '</b>?');
  $('#password_cliente').val('');
  $('#btnEnviarPass').attr("onclick", "actualizarContraseña()");
  $('#btnEnviarPass').attr("data-dismiss", "modal");
  $('#idDatosGeneralesEditPass').val(valor2); // Asignar valor a idUsuarioInterno
  $('#idCorreo').val(valor1);
  // Asignar valor a idCorreo
  $('#enviarCredenciales').modal('show');
}

function accionCliente(accion, id, correo = null) {
  console.log("id del cliente:  " + id + "  accion d a realizar:  " + accion)
  let opcion_motivo = $('#mensajeModal #opcion_motivo').val()
  let opcion_descripcion = $("#mensajeModal #opcion_motivo option:selected").text();
  let mensaje_comentario = $('#mensajeModal #mensaje_comentario').val()
  let bloquear_subclientes = $("#mensajeModal #bloquear_subclientes").is(":checked") ? 'SI' : 'NO';
  $.ajax({
    url: '<?php echo base_url('Cat_Cliente/status'); ?>',
    type: 'POST',
    data: {
      'idCliente': id,
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

function registrarAccesoCliente() {
  $.ajax({
    url: '<?php echo base_url('Cat_Cliente/getClientesActivos'); ?>',
    type: 'post',
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      if (res != 0) {
        $('#id_cliente').empty();
        var dato = JSON.parse(res);
        $('#id_cliente').append('<option value="">Selecciona</option>');
        for (let i = 0; i < dato.length; i++) {
          $('#id_cliente').append('<option value="' + dato[i]['id'] + '">' + dato[i]['nombre'] + '</option>');
        }
        $('#nuevoAccesoClienteModal').modal('show');
      }
    }
  });
}
/*Funcion para  crear  acesos  para  los usuarios de los clientes, esta  captura
los datos  del formulario mdl_cat_cliente los transforma en JSon y los envia Medisnte  El protocolo POST
  al archivo Cat_usuario a la funcion addUsuario */
function crearAccesoClientes() {
  let tipoUsuarioSwitch = document.getElementById("tipoUsuarioSwitch");
  let tipoUsuarioValue = tipoUsuarioSwitch.checked ? 1 : 0;

  let datosArray = $('#formAccesoCliente').serializeArray();
  datosArray.push({
    name: 'tipo_usuario',
    value: tipoUsuarioValue
  });

  $.ajax({
    url: '<?php echo base_url('Cat_Cliente/addUsuarioCliente'); ?>',
    type: 'POST',
    data: datosArray,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      console.log(res);

      try {
        var data = JSON.parse(res);

        if (data.codigo === 1) {
          $("#nuevoAccesoClienteModal").modal('hide');
          recargarTable();
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Usuario guardado correctamente',
            showConfirmButton: false,
            timer: 2500
          });
          $('#formAccesoCliente¿')[0].reset();
        } else {
          $("#nuevoAccesoClienteModal #msj_error").css('display', 'block').html(data.msg);
        }
      } catch (error) {
        console.error("Error al analizar la respuesta JSON:", error);
        console.log(res);
      }
    },
    error: function(xhr, textStatus, errorThrown) {
      console.error("Error en la llamada AJAX:", textStatus, errorThrown);
      console.log(xhr.responseText);
    }
  });
}

function actualizarContraseña() {
  var pass = $('#password_cliente').val();
  var correo = $('#idCorreo').val();
  var id_datos = $('#idDatosGeneralesEditPass').val();
  $.ajax({
    url: '<?php echo base_url('Cat_UsuarioInternos/actualizarPass'); ?>',
    type: 'post',
    data: {
      'id': id_datos,
      'correo': correo,
      'pass': pass
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
        recargarTable();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 3000
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Error al realizar la acción',
          text: data.msg,
          showConfirmButton: false,
          timer: 2500
        });
      }
    },
    error: function(err) {
      console.error('Error en la petición AJAX:', err.responseText);
    }
  });
}

function controlAcceso(accion, idUsuarioCliente) {
  $("tr#" + idUsuarioCliente).hide();
  $.ajax({
    url: '<?php echo base_url('Cat_Cliente/controlAcceso'); ?>',
    type: 'post',
    data: {
      'idUsuarioCliente': idUsuarioCliente,
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
        recargarTable()
        $("#mensajeModal").modal('hide')
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

function generarPassword1() {
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

      $("#password_cliente").val(res);

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
      $("#password").val(res);

    }
  });
}

function generarPassword_us() {
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

      $("#password_us").val(res)
    }
  });
}

function recargarTable() {
  $("#tabla").DataTable().ajax.reload();
}
</script>