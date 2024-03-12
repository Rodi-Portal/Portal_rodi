<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="align-items-center mb-4">
    <div class="row">
      <div class="col-sm-12 col-md-8">
        <h1 class="h3 mb-0 text-gray-800">Clientes</h1>
      </div>
      <div class="col-sm-12 col-md-2">
        <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#newModal"
          onclick="registrarCliente()">
          <span class="icon text-white-50">
            <i class="fas fa-user-tie"></i>
          </span>
          <span class="text">Agregar cliente</span>
        </a>
      </div>
      <div class="col-sm-12 col-md-2">
        <a href="#" class="btn btn-primary btn-icon-split" onclick="registrarAccesoCliente()">
          <span class="icon text-white-50">
            <i class="fas fa-sign-in-alt"></i>
          </span>
          <span class="text">Acceso a clientes</span>
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
  <input type="hidden" id="idUsuarioCliente">


</div>
<!-- /.content-wrapper -->
<script>
var url = '<?php echo base_url('Cat_Cliente/getClientes'); ?>';
var tipos_bloqueo_php =
  '<?php foreach($tipos_bloqueo as $row){ echo '<option value="'.$row->tipo.'">'.$row->descripcion.'</option>';} ?>';
var tipos_desbloqueo_php =
  '<?php foreach($tipos_desbloqueo as $row){ echo '<option value="'.$row->tipo.'">'.$row->descripcion.'</option>';} ?>';
$(document).ready(function() {
  console.log('Documento listo. Iniciando script.');
  $('[data-toggle="tooltip"]').tooltip();
  $('#newModal').on('shown.bs.modal', function() {
    $(this).find('input[type=text],select,textarea').filter(':visible:first').focus();
  });
  console.log('URL de Ajax:', url);
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

  if (typeof $.fn.dataTable === 'undefined') {
    console.error('Error: DataTables no está cargado correctamente.');
  } else {
    console.log('DataTables cargado correctamente.');
  }
  $('#tabla').DataTable({
    "pageLength": 25,
    //"pagingType": "simple",
    "order": [0, "desc"],
    "stateSave": true,
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
        "width": "25%",
        mRender: function(data, type, full) {
          return '<span class="badge badge-pill badge-dark">#' + full.idCliente + '</span><br><b>' + data + '</b>';
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
        title: 'Accesos',
        data: 'numero_usuarios_clientes',
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
        title: 'Acciones',
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

          let bloqueo = (full.bloqueado === 'NO') ?
            ' <a href="javascript:void(0)" data-toggle="tooltip" title="Bloquear cliente" id="bloquear_cliente" class="fa-tooltip icono_datatable icono_verde"><i class="fas fa-user-check"></i></a> ' :
            ' <a href="javascript:void(0)" data-toggle="tooltip" title="Desbloquear cliente" id="desbloquear_cliente" class="fa-tooltip icono_datatable icono_rojo"><i class="fas fa-user-lock"></i></a> ';

          return editar + accion + eliminar + acceso + bloqueo;
        }
      }
    ],
    fnDrawCallback: function(oSettings) {
      $('a[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
      });
    },
    rowCallback: function(row, data) {
     
      $("a#editar", row).bind('click', () => {
        $("#idCliente").val(data.idCliente);
        $("#idFacturacion").val(data.dFac);
        $("#idDomicilios").val(data.dDom);
        $("#idGenerales").val(data.dGen);
     
        $("#titulo_nuevo_modal").text("Editar cliente");

        // Generales
        $("#nombre").val(data.nombre);
        $("#clave").val(data.clave);

        // Domicilio
        cargarDatosDomicilioGeneral(data);
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
        $("#password_name").val(data.password_contacto)
        $("#newModal").modal("show");
      });
      $("a#activar", row).bind('click', () => {
        mostrarMensajeConfirmacion('activar cliente', data.nombre, data.id)
      });
      $("a#desactivar", row).bind('click', () => {
        mostrarMensajeConfirmacion('desactivar cliente', data.nombre, data.id)
      });
      $("a#bloquear_cliente", row).bind('click', () => {
        mostrarMensajeConfirmacion('bloquear cliente', data.nombre, data.id)
      });
      $("a#desbloquear_cliente", row).bind('click', () => {
        mostrarMensajeConfirmacion('desbloquear cliente', data.nombre, data.id)
      });
      $("a#eliminar", row).bind('click', () => {
        mostrarMensajeConfirmacion('eliminar cliente', data.nombre, data.id)
      });
      $("a#acceso", row).bind('click', () => {
        $(".nombreCliente").text(data.nombre);
        $.ajax({
          url: '<?php echo base_url('Cat_Cliente/getClientesAccesos'); ?>',
          type: 'post',
          data: {
            'id_cliente': data.idCliente
          },
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            console.log(res);
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            if (res != 0) {
              let dato = JSON.parse(res);
              let salida = '<table class="table table-striped">';
              salida += '<thead>';
              salida += '<tr>';
              salida += '<th scope="col">Nombre</th>';
              salida += '<th scope="col">Correo</th>';
              salida += '<th scope="col">Alta</th>';
              salida += '<th scope="col">Usuario</th>';
              salida += '<th scope="col">Categoría</th>';
              salida += '<th scope="col">Eliminar</th>';
              salida += '</tr>';
              salida += '</thead>';
              salida += '<tbody>';
              for (let i = 0; i < dato.length; i++) {
                let privacidad = (dato[i]['privacidad'] > 0) ? 'Nivel ' + dato[i]['privacidad'] :
                  'Sin privacidad';
                let fecha = fechaCompletaAFront(dato[i]['alta']);
                salida += "<tr id='" + dato[i]['idUsuarioCliente'] + "'><th>" + dato[i][
                    'usuario_cliente'
                  ] + "</th><th>" + dato[i]['correo_usuario'] + "</th><th>" + fecha + "</th><th>" +
                  dato[i]['usuario'] + "</th><th>" + privacidad +
                  "</th><th><a href='javascript:void(0)' class='fa-tooltip icono_datatable icono_accion_gris' onclick='mostrarMensajeConfirmacion(\"eliminar usuario cliente\",\"" +
                  dato[i]['usuario_cliente'] + "\"," + dato[i]['idUsuarioCliente'] +
                  ")'><i class='fas fa-trash'></i></a></th></tr>";
              }
              salida += '</tbody>';
              salida += '</table>';
              $("#div_accesos").html(salida);
            } else {
              $('#div_accesos').html(
                '<p style="text-align:center; font-size: 20px;">No hay registro de accesos</p>');
            }
          }
        });
        $("#accesosClienteModal").modal('show');
      });
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
            $("#item-details-countryValue").val(datos.pais);

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
                    var comboCities = "<option value=''>" + datos.ciudad + "</option>";
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
                            ""); // Limpiar el valor de la ciudad al cambiar el estado
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
</script>
<script>
function guardarCliente() {
  let datos = $('#formCatCliente').serialize();
  datos += '&id=' + $("#idCliente").val();
  $.ajax({
    url: '<?php echo base_url('Cat_Cliente/set'); ?>',
    type: "POST",
    data: datos,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      console.log(res);
      $('.loader').fadeOut();
      var data = JSON.parse(res);
      if (data.codigo === 1) {
        $("#newModal").modal('hide');
        recargarTable();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Cliente guardado correctamente',
          showConfirmButton: false,
          timer: 2500
        });
      } else {
        $("#newModal #msj_error").css('display', 'block').html(data.msg);
      }
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
    $('#titulo_mensaje2').text('Desactivar cliente');
    $('#mensaje').html('¿Desea desactivar al cliente <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "accionCliente('desactivar'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar cliente") {
    $('#titulo_mensaje3').text('Eliminar cliente');
    $('#mensaje').html('¿Desea eliminar al cliente <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "accionCliente('eliminar'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar usuario cliente") {
    $('#titulo_mensaje4').text('Eliminar usuario');
    $('#mensaje').html('¿Desea eliminar al usuario <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "controlAcceso('eliminar'," + valor2 + ")");
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
    $('#btnConfirmar').attr("onclick", "accionCliente('bloquear'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "desbloquear cliente") {
    $('#titulo_mensaje6').text('Desbloquear cliente');
    $('#mensaje').html('¿Desea desbloquear al cliente <b>' + valor1 + '</b>?');
    $('#mensaje').append(
      '<div class="row mt-3"><div class="col-12"><label>Razón de desbloqueo *</label><select class="form-control" id="opcion_motivo" name="opcion_motivo"><option value="">Selecciona</option>' +
      tipos_desbloqueo_php + '</select></div></div>');
    $('#btnConfirmar').attr("onclick", "accionCliente('desbloquear'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
}

function accionCliente(accion, id) {
  let opcion_motivo = $('#mensajeModal #opcion_motivo').val()
  let opcion_descripcion = $("#mensajeModal #opcion_motivo option:selected").text();
  let mensaje_comentario = $('#mensajeModal #mensaje_comentario').val()
  let bloquear_subclientes = $("#mensajeModal #bloquear_subclientes").is(":checked") ? 'SI' : 'NO';
  $.ajax({
    url: '<?php echo base_url('Cat_Cliente/status'); ?>',
    type: 'post',
    data: {
      'id': id,
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
  datosArray.push({ name: 'tipo_usuario', value: tipoUsuarioValue });

  $.ajax({
    url: '<?php echo base_url('Cat_Cliente/addUsuarioCliente'); ?>',
    type: 'POST',
    data: datosArray,
    beforeSend: function () {
      $('.loader').css("display", "block");
    },
    success: function (res) {
      setTimeout(function () {
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
        } else {
          $("#nuevoAccesoClienteModal #msj_error").css('display', 'block').html(data.msg);
        }
      } catch (error) {
        console.error("Error al analizar la respuesta JSON:", error);
        console.log(res);
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      console.error("Error en la llamada AJAX:", textStatus, errorThrown);
      console.log(xhr.responseText);
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
</script>