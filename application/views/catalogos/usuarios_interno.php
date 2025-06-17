<!-- Begin Page Content -->
<div class="align-items-center mb-4">
  <div class="row">
    <div class="col-sm-12 col-md-6 d-flex justify-content-start align-items-center">
      <h2>Administradores del Sistema</h2>
    </div>
    <?php $idRol = $this->session->userdata('idrol'); ?>
    <?php if ($idRol == 1 || $idRol == 6): ?>
    <div class="col-sm-12 col-md-6 d-flex justify-content-end align-items-center">
      <a href="#" class="btn btn-primary btn-icon-split" onclick="BotonRegistroUsuarioInterno()">
        <span class="icon text-white-50">
          <i class="fas fa-user-tie"></i>
        </span>
        <span class="text">Crear Usuario</span>
      </a>
      <p> </p>
      <a href="#" class="btn btn-primary btn-icon-split" onclick="AsignarSucursalUsuarioInterno()">
        <span class="icon text-white-50">
          <i class="fas fa-user-tie"></i>
        </span>
        <span class="text">Asignar Usuario</span>
      </a>
    </div>
    <?php endif; ?>

  </div>
  <div>
    <P> En este módulo podrás gestionar a tus usuarios internos. Tendrás la capacidad de crear <br>nuevos usuarios,
      actualizar su información y reenviar credenciales cuando sea necesario.</P>
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
<!-- Modal  Para  asignar  usuario a Sucursales-->
<div class="modal fade" id="nuevoAsignarSucursalUsuariosInternos" data-backdrop="static" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Asignar Sucursal a Usuarios</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="formAsignarSucursalUsuariosinternos">

          <!-- Usuarios -->
          <div class="form-group">
            <label for="usuario">Usuarios</label>
            <select id="usuario" class="form-control">
              <option value="">Seleccione un usuario</option>
            </select>
          </div>
          <div id="listaUsuarios" class="mb-3"></div> <!-- Aquí se mostrarán los usuarios seleccionados -->
          <div class="form-group">
            <label>
              <input type="checkbox" id="selectAllSucursales"> Seleccionar todas las sucursales
            </label>
          </div>
          <!-- Sucursales -->
          <div class="form-group">
            <label for="sucursal">Sucursales</label>
            <select id="sucursal" class="form-control">
              <option value="">Seleccione una sucursal</option>
            </select>
          </div>
          <div id="listaSucursales" class="mb-3"></div> <!-- Aquí se mostrarán las sucursales seleccionadas -->

          <div class="text-center">
            <button type="button" class="btn btn-primary" id="btnGuardarSucursal">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal de Confirmación  para los botones de tipos de  Acciones-->
<div class="modal fade" id="mensajeModal" tabindex="-1" role="dialog" aria-labelledby="mensajeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_mensaje"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body" id="mensaje"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="btnConfirmar">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal de Confirmación  para los botones de tipos de  Acciones-->
<div class="modal fade" id="enviarCredenciales" tabindex="-1" role="dialog" aria-labelledby="mensajeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_mensaje_contraseña">Send credentials</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="modal-body" id="mensaje_contraseña"></div> <!-- Centrar el contenido -->
          <div class="col-md-9">
            <label>Generate password *</label>
            <div class="input-group">
              <input type="text" class="form-control" name="password" id="password" maxlength="8" readonly>
              <div class="input-group-append">
                <button type="button" class="btn btn-primary" onclick="generarPassword()">Generar</button>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" class="form-control" name="idUsuarioInternoEditPass" id="idUsuarioInternoEditPass">
        <input type="hidden" class="form-control" name="idCorreo" id="idCorreo">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="btnEnviarPass">Resend password</button>
      </div>
    </div>
  </div>
</div>

<?php echo $modals; ?>
<div class="loader" style="display: none;"></div>
<input type="hidden" id="idusuario">
</div>
<!-- /.container-fluid -->


<script>
var idRol = Number('<?php echo (int) $this->session->userdata('idrol'); ?>');
var url = '<?php echo base_url('Cat_UsuarioInternos/getUsuarios'); ?>';
let rolesVisibles = [1, 6];
let mostrarColumna = rolesVisibles.includes(idRol);
$(document).ready(function() {
  $('[data-toggle="tooltip"]').tooltip();


  var tabla = $('#tabla').DataTable({

    "pageLength": 25,
    //"pagingType": "simple",
    "order": [0, "desc"],
    "stateSave": false,
    "serverSide": false,
    "ajax": url,
    "columns": [{

        title: 'id',
        data: 'id',
        visible: false
      },
      {
        title: 'ID',
        data: 'id_usuario',
        bSortable: false,
        "width": "4%",
        mRender: function(data, type, full) {
          return '<span class="badge badge-pill badge-dark">' + '</span><br><b>' + data + '</b>';
        }
      },
      {
        title: 'Nombre',
        data: 'referente',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return '<span class="badge badge-pill badge-dark">' + '</span><br><b>' + data + '</b>';
        }
      },
      {
        title: 'Matriz',
        data: 'nombre_portal',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return '<span class="badge badge-pill badge-dark">' + '</span><br><b>' + data + '</b>';
        }
      },
      {
        title: 'Correo',
        data: 'correo',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return '<span class="badge badge-pill badge-dark">' + '</span><br><b>' + data + '</b>';
        }
      },
      {
        title: 'Rol Usuario',
        data: 'nombre_rol',
        bSortable: false,
        "width": "3%",
        mRender: function(data, type, full) {
          return '<b>' + data + '</b>';
        }
      },
      {
        title: 'Fecha de creacion',
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
        title: 'Última Actualización',
        data: 'edicion',
        bSortable: false,
        "width": "8%",
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
        title: 'Acciones',
        data: 'id_usuario',
        bSortable: false,
        visible: mostrarColumna,
        "width": "15%",
        mRender: function(data, type, full) {
          let editar =
            '<a id="editar" href="javascript:void(0)" class="fa-tooltip icono_datatable icono_azul_oscuro"><i class="fas fa-pencil-alt" style="font-size: 16px;"></i></a> ';

          let accion = (full.status == 0) ?
            '<a href="javascript:void(0)" class="fa-tooltip icono_datatable icono_rojo cambiar-estado" data-id="' +
            data + '" data-referente="' + full.referente +
            '" data-status="activar"><i class="fas fa-ban" style="font-size: 16px;"></i></a> ' :
            '<a href="javascript:void(0)" class="fa-tooltip icono_datatable icono_verde cambiar-estado" data-id="' +
            data + '" data-referente="' + full.referente +
            '" data-status="desactivar"><i class="far fa-check-circle" style="font-size: 16px;"></i></a> ';

          let eliminar =
            '<a href="javascript:void(0)" class="fa-tooltip icono_datatable icono_rojo" data-id="' + data +
            '" data-referente="' + full.referente +
            '" data-action="eliminarUsuario"><i class="fas fa-trash" style="font-size: 16px;"></i></a> ';

          let credenciales =
            '<a href="javascript:void(0)" class="fa-tooltip icono_datatable icono_amarillo" data-correo="' +
            full.correo + '" data-id="' + full.id_datos_generales +
            '"><i class="fas fa-sync-alt" style="font-size: 16px;"></i></a> ';

          if (full.id_rol == 1 || full.id_rol == 6) {
            return editar + credenciales;
          } else {
            return editar + accion + eliminar + credenciales;
          }
        }
      }

    ],
    "columnDefs": [{
      "targets": [1, 3, 4, 6, 7], // Índices de las columnas a ocultar en pantallas pequeñas
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

    /*****Devuelve los valores registrados para editarlos DESDE EL BOTON EDITAR**************/

    rowCallback: function(row, data) {


      $("a#editar", row).bind('click', () => {
        $("#idUsuarioInterno").val(data.id_usuario);
        $("#idDatosGenerales").val(data.id_datos_generales);
        $("#titulo_nuevo_modal").text("Editar Usuario");
        $("#nombreUsuarioInterno").val(data.nombre);
        $("#paternoUsuarioInterno").val(data.paterno);

        if (<?php echo $this->session->userdata('idrol'); ?> != 6) {
          $("#id_rolUsuarioInterno").val(data.id_rol);
          $("#id_rolUsuarioInterno").prop('disabled', true);

        } else {
          $("#id_rolUsuarioInterno").val(data.id_rol);

        }
        $("#correoUsuarioInterno").val(data.correo);
        $("#telefonoUsuarioInterno").val(data.telefono);
        // Se oculta el botón de Generar contraseña en modo de edición
        $('#ocultar-en-editar').hide();
        $("#divGenerarPassword").hide();
        $("#labelOcultar").hide();


        $("#btnGuardar").text("Guardar Cambios");
        $("#btnGuardar").off("click").on("click", function() {
          editarUsuarios();
        });

        $("#nuevoAccesoUsuariosInternos").modal("show");

      });

    },

    /****************************************************************/
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
  $(document).on('click', '.cambiar-estado', function() {
    var status = $(this).data('status');
    var id = $(this).data('id');
    var referente = $(this).data('referente');
    mostrarMensajeConfirmacion(status === 'activar' ? 'Activar usuario' : 'Desactivar usuario', referente, id);
  });

  $(document).on('click', 'a[data-action="eliminarUsuario"]', function() {
    var id = $(this).data('id');
    var referente = $(this).data('referente');
    mostrarMensajeConfirmacion('eliminarUsuario', referente, id);
  });

  $(document).on('click', '.fa-sync-alt', function() {
    var correo = $(this).closest('a').data('correo'); // data-correo
    var idDatosGenerales = $(this).closest('a').data('id'); // data-id
    enviarCredenciales(correo, idDatosGenerales);
  });
  $(window).on('resize', function() {
    tabla.columns.adjust().draw();
  });

});

/****************************FUNCION***EDITAR*****************************************/
function mostrarMensajeConfirmacion(accion, valor1, valor2) {
  if (accion == "eliminarUsuario") {
    $('#titulo_mensaje').text('Eliminar usuario');
    $('#mensaje').html('¿Desea eliminar al usuario <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "botonesAccionesUsuario('eliminar'," + valor2 + ")");
    $('#btnConfirmar').attr("data-dismiss", "modal");
    $('#mensajeModal').modal('show');

  } else if (accion == "Desactivar usuario") {
    $('#titulo_mensaje').text('Desactivar usuario');
    $('#mensaje').html('¿Desea desactivar al usuario <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "botonesAccionesUsuario('desactivar'," + valor2 + ")");
    $('#btnConfirmar').attr("data-dismiss", "modal");
    $('#mensajeModal').modal('show');
  } else if (accion == "Activar usuario") {
    $('#titulo_mensaje').text('Activar usuario');
    $('#mensaje').html('¿Desea Activar al usuario <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "botonesAccionesUsuario('activar'," + valor2 + ")");
    $('#btnConfirmar').attr("data-dismiss", "modal");
    $('#mensajeModal').modal('show');
  }
}

function enviarCredenciales(valor1, valor2) {

  $('#titulo_mensaje_contraseña').text('Reenviar Contraseña');
  $('#mensaje_contraseña').html('¿Deseas actualizar la contraseña <b>' + valor1 + '</b>?');
  $('#btnEnviarPass').attr("onclick", "actualizarContraseña()");
  $('#btnEnviarPass').attr("data-dismiss", "modal");
  $('#idUsuarioInternoEditPass').val(valor2); // Asignar valor a idUsuarioInterno
  $('#idCorreo').val(valor1);
  $('#password').val(''); // Asignar valor a idCorreo
  $('#enviarCredenciales').modal('show');
}



/*********************************************************************************/
/*--------------LLAMADO DEL BOTON REGISTRO USUARIO INTERNOS----------------------------*/
function BotonRegistroUsuarioInterno() {
  $.ajax({
    url: '<?php echo base_url('Cat_UsuarioInternos/verificarLimiteUsuarios'); ?>',
    type: 'post',
    dataType: 'json',
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      $('.loader').fadeOut();

      if (res.supera_limite) {
        Swal.fire({
          title: 'Límite de usuarios alcanzado',
          html: 'Los usuarios disponibles para tu suscripción ya están completos.<br>¿Deseas agregar uno más por un costo mensual adicional de <b>$50 USD</b>?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Sí, aceptar costo extra',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            // Segunda confirmación
            Swal.fire({
              title: 'Confirmación final',
              html: 'Estás a punto de generar un cobro adicional que se reflejará en tu próxima factura.<br><b>¿Deseas continuar?</b>',
              icon: 'question',
              showCancelButton: true,
              confirmButtonText: 'Sí, continuar',
              cancelButtonText: 'Volver'
            }).then((secondResult) => {
              if (secondResult.isConfirmed) {
                mostrarModalRegistroUsuario();
              }
            });
          }
        });
      } else {
        mostrarModalRegistroUsuario();
      }
    },
    error: function() {
      $('.loader').fadeOut();
      Swal.fire('Error', 'No se pudo verificar el límite de usuarios.', 'error');
    }
  });
}


function mostrarModalRegistroUsuario() {
  // Mostrar los elementos del formulario
  $("#divGenerarPassword").css('display', 'block');
  $("#ocultar-en-editar").css('display', 'block');
  $("#labelOcultar").css('display', 'block');

  $("#btnGuardar").text("Guardar");
  $("#btnGuardar").off("click").on("click", function() {
    registroUsuariosInternos();
  });

  $('#formAccesoUsuariosinternos')[0].reset();
  $('#nuevoAccesoUsuariosInternos').modal('show');
  $("#nombreUsuarioInterno").focus();
}


// Cerrar modal y liberar foco
$('#nuevoAccesoUsuariosInternos').on('hidden.bs.modal', function() {
  document.activeElement.blur();
});

// Función de registro de usuario
function registroUsuariosInternos() {
  let datos = $('#formAccesoUsuariosinternos').serialize();
  $.ajax({
    url: '<?php echo base_url('Cat_UsuarioInternos/addUsuarioInterno'); ?>',
    type: 'POST',
    data: datos,
    beforeSend: function() {
      $('.loader').css("display", "block");
      $("#btnGuardar").prop("disabled", true); // Desactivar el botón durante la solicitud
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
        $("#btnGuardar").prop("disabled", false); // Rehabilitar el botón después de la respuesta
      }, 200);
      var data = JSON.parse(res);

      if (data.codigo === 1) {
        $("#nuevoAccesoUsuariosInternos").modal('hide');
        recargarTable();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Usuario guardado correctamente',
          showConfirmButton: false,
          timer: 2500
        });

        $('#formAccesoUsuariosinternos')[0].reset(); // Limpia el formulario
      } else {
        $("#nuevoAccesoUsuariosInternos #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

/*********************************************************************************/
/*--------------LLAMADO DEL BOTON REGISTRO USUARIO INTERNOS----------------------------*/
let usuariosSeleccionados = [];
let sucursalesSeleccionadas = [];

function AsignarSucursalUsuarioInterno() {
  $.ajax({
    url: '<?php echo base_url("Cat_UsuarioInternos/getUsuarios"); ?>',
    type: 'POST',
    dataType: 'json',
    beforeSend: function() {
      $('.loader').show();
    },
    success: function(res) {
      console.log("usuarios del servidor:", res); // Imprime la respuesta completa en consola

      $('.loader').fadeOut();
      $("#usuario").html('<option value="">Seleccione un usuario</option>');
      $.each(res.data, function(index, usuario) {
        $("#usuario").append('<option value="' + usuario.id_usuario + '">' + usuario.referente + '</option>');
      });

      // Cargar sucursales
      $.ajax({
        url: '<?php echo base_url("Cat_UsuarioInternos/getSucursales"); ?>',
        type: 'POST',
        dataType: 'json',
        success: function(res) {
          console.log("Sucursales del servidor:", res); // Imprime la respuesta completa en consola

          $("#sucursal").html('<option value="">Seleccione una sucursal</option>');
          $.each(res.data, function(index, sucursal) {
            $("#sucursal").append('<option value="' + sucursal.id + '">' + sucursal.nombre +
              '</option>');
          });
        }
      });


      $('#nuevoAsignarSucursalUsuariosInternos').modal('show');
    }
  });
}
// Evento para seleccionar todas las sucursales
$("#selectAllSucursales").on("change", function() {
  let isChecked = $(this).is(":checked");

  if (isChecked) {
    $("#sucursal option").each(function() {
      let id = $(this).val();
      let nombre = $(this).text();

      if (id && !sucursalesSeleccionadas.some(s => s.id === id)) {
        sucursalesSeleccionadas.push({
          id,
          nombre
        });
      }
    });
  } else {
    sucursalesSeleccionadas = [];
  }

  mostrarSucursalesSeleccionadas();
});

// Agregar usuario a la lista
$("#usuario").change(function() {
  let id = $(this).val();
  let nombre = $("#usuario option:selected").text();

  if (id && !usuariosSeleccionados.some(u => u.id === id)) {
    usuariosSeleccionados.push({
      id,
      nombre
    });
    mostrarUsuariosSeleccionados();
  }
});

// Agregar sucursal a la lista
$("#sucursal").change(function() {
  let id = $(this).val();
  let nombre = $("#sucursal option:selected").text();

  if (id && !sucursalesSeleccionadas.some(s => s.id === id)) {
    sucursalesSeleccionadas.push({
      id,
      nombre
    });
    mostrarSucursalesSeleccionadas();
  }
});

// Mostrar usuarios seleccionados
function mostrarUsuariosSeleccionados() {
  $("#listaUsuarios").html("");
  usuariosSeleccionados.forEach((usuario, index) => {
    $("#listaUsuarios").append(`
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                ${usuario.nombre}
                <button type="button" class="close" onclick="eliminarUsuario(${index})">&times;</button>
            </div>
        `);
  });
}

// Mostrar sucursales seleccionadas
function mostrarSucursalesSeleccionadas() {
  $("#listaSucursales").html("");
  sucursalesSeleccionadas.forEach((sucursal, index) => {
    $("#listaSucursales").append(`
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                ${sucursal.nombre}
                <button type="button" class="close" onclick="eliminarSucursal(${index})">&times;</button>
            </div>
        `);
  });
}

// Eliminar usuario seleccionado
function eliminarUsuario(index) {
  usuariosSeleccionados.splice(index, 1);
  mostrarUsuariosSeleccionados();
}

// Eliminar sucursal seleccionada
function eliminarSucursal(index) {
  sucursalesSeleccionadas.splice(index, 1);
  mostrarSucursalesSeleccionadas();
}

// Guardar asignaciones
$("#btnGuardarSucursal").on("click", function() {
  if (usuariosSeleccionados.length === 0 || sucursalesSeleccionadas.length === 0) {
    Swal.fire({
      icon: 'warning',
      title: 'Atención',
      text: 'Seleccione al menos un usuario y una sucursal.',
      confirmButtonText: 'Aceptar'
    });
    return;
  }
  let idsUsuarios = usuariosSeleccionados.map(u => u.id);
  let idsSucursales = sucursalesSeleccionadas.map(s => s.id);
  $.ajax({
    url: '<?php echo base_url("Cat_UsuarioInternos/asignarSucursal"); ?>',
    type: 'POST',
    data: {
      usuarios: idsUsuarios,
      sucursales: idsSucursales
    },
    success: function(response) {
      Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: 'Asignación guardada con éxito.',
        confirmButtonText: 'Aceptar'
      }).then(() => {
        $('#nuevoAsignarSucursalUsuariosInternos').modal('hide');
        usuariosSeleccionados = [];
        sucursalesSeleccionadas = [];
        mostrarUsuariosSeleccionados();
        mostrarSucursalesSeleccionadas();
      });
    },
    error: function() {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Hubo un problema al guardar la asignación.',
        confirmButtonText: 'Aceptar'
      });
    }
  });
});



/****************************ACCION**EDITAR USUARIO***********************************************/


function editarUsuarios() {
  let datos = $('#formAccesoUsuariosinternos').serializeArray();

  $.ajax({
    url: '<?php echo base_url('Cat_UsuarioInternos/editarUsuarioControlador'); ?>',
    type: 'POST',
    data: datos,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {


      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);

      var data = JSON.parse(res);
      if (data.codigo === 1) {
        $("#nuevoAccesoUsuariosInternos").modal('hide');
        recargarTable();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Usuario editado correctamente',
          showConfirmButton: false,
          timer: 2500
        });

        $('#formAccesoUsuariosinternos')[0]
      .reset(); // Se limpian nuevamente los campos de registro después de guardar
      } else {
        $("#nuevoAccesoUsuariosInternos #msj_error").css('display', 'block').html(data.msg);
      }
    },
    error: function(err) {
      console.error('Error en la petición AJAX:', err.responseText);
    }

  });
}



/*********************************Función acciones*********************************/

function botonesAccionesUsuario(accion, idUsuario) {
  $.ajax({
    url: '<?php echo base_url('Cat_UsuarioInternos/status'); ?>',
    type: 'post',
    data: {
      'id': idUsuario,
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
        recargarTable();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 2400
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

function actualizarContraseña() {
  var pass = $('#password').val();
  var correo = $('#idCorreo').val();
  var id_datos = $('#idUsuarioInternoEditPass').val();
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

function recargarTable() {
  $("#tabla").DataTable().ajax.reload();
}



/**********************************************************************************************/

/*----------------------------------------------------------*/
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
      $("#password1").val(res)
      $("#password").val(res)
    }
  });
}

function recargarTable() {
  location.reload();
  //$("#tabla").DataTable().ajax.reload();
}
</script>