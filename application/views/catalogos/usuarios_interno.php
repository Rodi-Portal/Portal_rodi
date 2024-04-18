<!-- Begin Page Content -->
<div class="align-items-center mb-4">
  <div class="row">
    <div class="col-sm-12 col-md-6 d-flex justify-content-start align-items-center">
      <h2>Usuarios Internos</h2>
    </div>
    <div class="col-sm-12 col-md-6 d-flex justify-content-end align-items-center">
      <a href="#" class="btn btn-primary btn-icon-split" onclick="BotonRegistroUsuarioInterno()">
        <span class="icon text-white-50">
          <i class="fas fa-user-tie"></i>
        </span>
        <span class="text">Registro de usuarios</span>
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

<!-- Modal de Confirmación  para los botones de tipos de  Acciones-->
<div class="modal fade" id="mensajeModal" tabindex="-1" role="dialog" aria-labelledby="mensajeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_mensaje"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="mensaje"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="btnConfirmar">Confirmar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal de Confirmación  para los botones de tipos de  Acciones-->
<div class="modal fade" id="enviarCredenciales" tabindex="-1" role="dialog" aria-labelledby="mensajeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo_mensaje_contraseña">Enviar credenciales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                <div class="modal-body" id="mensaje_contraseña"></div> <!-- Centrar el contenido -->
                    <div class="col-md-9">
                        <label>Generar contraseña *</label>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnEnviarPass">Renviar contraseña</button>
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
var url = '<?php echo base_url('Cat_UsuarioInternos/getUsuarios'); ?>';

$(document).ready(function() {
  $('[data-toggle="tooltip"]').tooltip();
  $('#nuevoAccesoUsuariosInternos').on('shown.bs.modal', function() {
    $(this).find('input[type=text],select,textarea').filter(':visible:first').focus();
  });

  $('#tabla').DataTable({

    "pageLength": 25,
    //"pagingType": "simple",
    "order": [0, "desc"],
    "stateSave": true,
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
        title: 'Nombre de usuario',
        data: 'referente',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return '<span class="badge badge-pill badge-dark">' + '</span><br><b>' + data + '</b>';
        }
      },
      {
        title: 'Portal',
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
        title: 'Tipo de rol',
        data: 'nombre_rol',
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
        title: 'Fecha de edición',
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
        "width": "15%",
        mRender: function(data, type, full) {
          let editar =
            '<a id="editar" href="javascript:void(0)" data-toggle="tooltip" title="Editar Usuario" class="fa-tooltip icono_datatable icono_azul_oscuro"><i class="fas fa-pencil-alt" style="font-size: 16px;"></i></a> ';

          let accion = (full.status == 0) ?
            '<a href="javascript:void(0)" data-toggle="tooltip" title="Activar" class="fa-tooltip icono_datatable icono_rojo cambiar-estado" onclick="mostrarMensajeConfirmacion(\'Activar usuario\', \'' +
            full.referente + '\', \'' + data +
            '\')"><i class="fas fa-ban" style="font-size: 16px;"></i></a> ' :
            '<a href="javascript:void(0)" data-toggle="tooltip" title="Desactivar" class="fa-tooltip icono_datatable icono_verde cambiar-estado"  onclick="mostrarMensajeConfirmacion(\'Desactivar usuario\', \'' +
            full.referente + '\', \'' + data +
            '\')"><i class="far fa-check-circle" style="font-size: 16px;"></i></a> ';

          let eliminar =
            '<a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar usuario" onclick="mostrarMensajeConfirmacion(\'eliminar usuario\', \'' +
            full.referente + '\', \'' + data +
            '\')" class="fa-tooltip icono_datatable icono_rojo"><i class="fas fa-trash" style="font-size: 16px;"></i></a> ';


          let credenciales =
            '<a href="javascript:void(0)" data-toggle="tooltip" title="Actualizar credenciales al candidato" onclick="enviarCredenciales(\'' +
            full.correo + '\', \'' + full.id_datos +
            '\')" class="fa-tooltip icono_datatable icono_amarillo"><i class="fas fa-sync-alt style="font-size: 16px;"></i></a> ';

          return editar + accion + eliminar + credenciales;
        }
           
      }
    ],

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
        $("#nombre").val(data.nombre);
        $("#paterno").val(data.paterno);
        $("#id_rol").val(data.id_rol);
        $("#correo").val(data.correo);
        $("#telefono").val(data.telefono);
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
       console.log("🚀 ~ $ ~ data:", data)

    },

    /****************************************************************/
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

/****************************FUNCION***EDITAR*****************************************/
function mostrarMensajeConfirmacion(accion, valor1, valor2) {
  if (accion == "eliminar usuario") {
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
    $('#titulo_mensaje').text('Desactivar usuario');
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
    $('#password').val(); // Asignar valor a idCorreo
    $('#enviarCredenciales').modal('show');
}
   


/*********************************************************************************/
/*--------------LLAMADO DEL BOTON REGISTRO USUARIO INTERNOS----------------------------*/
function BotonRegistroUsuarioInterno() {

  // Mostrar el botón de Generar contraseña al agregar un nuevo usuario
  $("#divGenerarPassword").css('display', 'block');
  $("#ocultar-en-editar").css('display', 'block');
  $("#labelOcultar").css('display', 'block');


  $.ajax({
    url: '<?php echo base_url('Cat_UsuarioInternos/getActivos');?>',
    type: 'post',
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);

      $("#btnGuardar").text("Guardar");
      $("#btnGuardar").off("click").on("click", function() {
        registroUsuariosInternos(); // Llama a la función con el ID del usuario
      });
      $('#nuevoAccesoUsuariosInternos').modal('show');

    }
  });
}
/*--------------LLAMADO DEL ONCLIK DEL BOTON GUARDAR DEL REGISTRO DEL FORMULARIO----------------------------*/
function registroUsuariosInternos() {
  let datos = $('#formAccesoUsuariosinternos').serialize();
  $.ajax({
    url: '<?php echo base_url('Cat_UsuarioInternos/addUsuarioInterno'); ?>',
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
      //console.log("🚀 ~ registroUsuariosInternos ~ data:", data)

      if (data.codigo === 1) {
        $("#nuevoAccesoUsuariosInternos").modal('hide')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Usuario guardado correctamente',
          showConfirmButton: false,
          timer: 2500
        })

        $('#formAccesoUsuariosinternos')[0]
          .reset(); //se limpian nuevamente los campos de registro después de guardar
      } else {
        $("#nuevoAccesoUsuariosInternos #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

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
  $("#tabla").DataTable().ajax.reload();

  debug: true
}
</script>