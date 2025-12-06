<?php
    $CI    = &get_instance();
    $idRol = (int) $CI->session->userdata('idrol');
    $myId  = (int) $CI->session->userdata('id');

    // “legacy” como hoy (solo para heredar mientras migras)
    $L_EDITAR         = in_array($idRol, [1, 6, 9], true);
    $L_CAMBIAR_ESTADO = in_array($idRol, [1, 6, 9], true);
    $L_ELIMINAR       = in_array($idRol, [1, 6], true);
    $L_RESET          = in_array($idRol, [1, 6], true);
    $L_CONFIG         = in_array($idRol, [1, 6], true);

    // -> window.PERM = { ... }
    echo perms_js_flags([
        'USR_EDITAR'         => ['admin.usuarios_internos.editar', $L_EDITAR],
        'USR_CAMBIAR_ESTADO' => ['admin.usuarios_internos.cambiar_estado', $L_CAMBIAR_ESTADO],
        'USR_ELIMINAR'       => ['admin.usuarios_internos.eliminar', $L_ELIMINAR],
        'USR_RESET'          => ['admin.usuarios_internos.reset_credenciales', $L_RESET],
        'USR_CONFIG'         => ['admin.usuarios_internos.config_permisos', $L_CONFIG],
    ]);
?>
<script>
window.CURRENT_USER_ID = <?php echo (int) $myId ?>;
</script>

<!-- Begin Page Content -->
<div class="align-items-center mb-4">
  <div class="row">
    <div class="col-sm-12 col-md-6 d-flex justify-content-start align-items-center">
      <h2><?php echo $this->lang->line('admin_users_title') ?></h2>
    </div>

    <?php $idRol = $this->session->userdata('idrol'); ?>
    <?php if ($idRol == 1 || $idRol == 6): ?>
    <div class="col-sm-12 col-md-6 d-flex justify-content-end align-items-center">

      <a href="#" class="btn btn-primary btn-icon-split" onclick="BotonRegistroUsuarioInterno()">
        <span class="icon text-white-50">
          <i class="fas fa-user-tie"></i>
        </span>
        <span class="text"><?php echo $this->lang->line('admin_users_btn_create') ?></span>
      </a>

      <p> </p>

      <a href="#" class="btn btn-primary btn-icon-split" onclick="AsignarSucursalUsuarioInterno()">
        <span class="icon text-white-50">
          <i class="fas fa-user-tie"></i>
        </span>
        <span class="text"><?php echo $this->lang->line('admin_users_btn_assign') ?></span>
      </a>

    </div>
    <?php endif; ?>

  </div>

  <div>
    <p><?php echo $this->lang->line('admin_users_description') ?></p>
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
        <h5 class="modal-title"><?php echo $this->lang->line('admin_users_modal_assign_title') ?></h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form id="formAsignarSucursalUsuariosinternos">

          <!-- Usuarios -->
          <div class="form-group">
            <label for="usuario"><?php echo $this->lang->line('admin_users_modal_users') ?></label>
            <select id="usuario" class="form-control">
            </select>
          </div>
          <div id="listaUsuarios" class="mb-3"></div> <!-- Aquí se mostrarán los usuarios seleccionados -->
          <div class="form-group">
            <label>
              <input type="checkbox" id="selectAllSucursales">
              <?php echo $this->lang->line('admin_users_modal_select_all') ?>
            </label>
          </div>
          <!-- Sucursales -->
          <div class="form-group">
            <label for="sucursal"><?php echo $this->lang->line('admin_users_modal_branches') ?></label>
            <select id="sucursal" class="form-control">
            </select>
          </div>
          <div id="listaSucursales" class="mb-3"></div> <!-- Aquí se mostrarán las sucursales seleccionadas -->

          <div class="text-center">
            <button type="button" class="btn btn-primary" id="btnGuardarSucursal">
              <?php echo $this->lang->line('admin_users_modal_save') ?>
            </button>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?php echo $this->lang->line('admin_users_modal_btn_cancel') ?>
        </button>

        <button type="button" class="btn btn-danger" id="btnConfirmar">
          <?php echo $this->lang->line('admin_users_modal_btn_confirm') ?>
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Modal de Confirmación  para los botones de tipos de  Acciones-->
<div class="modal fade" id="enviarCredenciales" tabindex="-1" role="dialog" aria-labelledby="mensajeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_mensaje_contraseña">
          <?php echo $this->lang->line('admin_users_send_credentials_title') ?>
        </h5> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="modal-body" id="mensaje_contraseña"></div> <!-- Centrar el contenido -->
          <div class="col-md-9">
            <label><?php echo $this->lang->line('admin_users_generate_password') ?></label>
            <div class="input-group">
              <input type="text" class="form-control" name="password" id="password" maxlength="20">
              <div class="input-group-append">
                <button type="button" class="btn btn-primary" onclick="generarPassword()">Generate</button>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" class="form-control" name="idUsuarioInternoEditPass" id="idUsuarioInternoEditPass">
        <input type="hidden" class="form-control" name="idCorreo" id="idCorreo">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="btnEnviarPass">
          <?php echo $this->lang->line('admin_users_btn_resend') ?>
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Modal de Asignacion de  permisos -->

<div class="modal fade" id="modalPermisos" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h5 class="modal-title"><?php echo $this->lang->line('admin_users_permissions_title') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-0">
        <!-- aquí se injecta el parcial -->
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

  const P = window.PERM || {};
  const SHOW_ACTIONS = !!(P.USR_EDITAR || P.USR_CAMBIAR_ESTADO || P.USR_ELIMINAR || P.USR_RESET || P.USR_CONFIG);
  $('[data-toggle="tooltip"]').tooltip();


  var tabla = $('#tabla').DataTable({

    "pageLength": 25,
    //"pagingType": "simple",
    "order": [0, "desc"],
    "stateSave": false,
    "serverSide": false,
    "ajax": url,
    "columns": [{

        title: "<?php echo $this->lang->line('admin_users_col_id'); ?>",
        data: 'id',
        visible: false
      },
      {
        title: "<?php echo $this->lang->line('admin_users_col_id'); ?>",
        data: 'id_usuario',
        bSortable: false,
        "width": "4%",
        mRender: function(data, type, full) {
          return '<span class="badge badge-pill badge-dark">' + '</span><br><b>' + data + '</b>';
        }
      },
      {
        title: "<?php echo $this->lang->line('admin_users_col_name'); ?>",
        data: 'referente',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return '<span class="badge badge-pill badge-dark">' + '</span><br><b>' + data + '</b>';
        }
      },
      {
        title: "<?php echo $this->lang->line('admin_users_col_branch'); ?>",
        data: 'nombre_portal',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return '<span class="badge badge-pill badge-dark">' + '</span><br><b>' + data + '</b>';
        }
      },
      {
        title: "<?php echo $this->lang->line('admin_users_col_email'); ?>",
        data: 'correo',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return '<span class="badge badge-pill badge-dark">' + '</span><br><b>' + data + '</b>';
        }
      },
      {
        title: "<?php echo $this->lang->line('admin_users_col_role'); ?>",
        data: 'nombre_rol',
        bSortable: false,
        "width": "3%",
        mRender: function(data, type, full) {
          return '<b>' + data + '</b>';
        }
      },
      {
        title: "<?php echo $this->lang->line('admin_users_col_created'); ?>",
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
        title: "<?php echo $this->lang->line('admin_users_col_updated'); ?>",
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
        title: "<?php echo $this->lang->line('admin_users_col_actions'); ?>",
        data: 'id_usuario',
        bSortable: false,
        visible: SHOW_ACTIONS,

        width: "15%",
        mRender: function(data, type, full) {
          const isSelf = Number(data) === window.CURRENT_USER_ID;

          // Botones condicionados por permisos
          const editar = P.USR_EDITAR ?
            '<a id="editar" href="javascript:void(0)" class="fa-tooltip icono_datatable icono_azul_oscuro"><i class="fas fa-pencil-alt" style="font-size:16px;"></i></a> ' :
            '';

          const estado = P.USR_CAMBIAR_ESTADO ?
            ((full.status == 0) ?
              '<a href="javascript:void(0)" class="fa-tooltip icono_datatable icono_rojo cambiar-estado" data-id="' +
              data + '" data-referente="' + full.referente +
              '" data-status="activar"><i class="fas fa-ban" style="font-size:16px;"></i></a> ' :
              '<a href="javascript:void(0)" class="fa-tooltip icono_datatable icono_verde cambiar-estado" data-id="' +
              data + '" data-referente="' + full.referente +
              '" data-status="desactivar"><i class="far fa-check-circle" style="font-size:16px;"></i></a> '
            ) :
            '';

          const eliminar = P.USR_ELIMINAR ?
            '<a href="javascript:void(0)" class="fa-tooltip icono_datatable icono_rojo" data-id="' + data +
            '" data-referente="' + full.referente +
            '" data-action="eliminarUsuario"><i class="fas fa-trash" style="font-size:16px;"></i></a> ' :
            '';

          const credenciales = P.USR_RESET ?
            '<a href="javascript:void(0)" class="fa-tooltip icono_datatable icono_amarillo" data-correo="' +
            full.correo + '" data-id="' + full.id_datos_generales +
            '"><i class="fas fa-sync-alt" style="font-size:16px;"></i></a> ' :
            '';

          // Permisos: NO dejar que el propio usuario se los quite (excepto rol 1)
          // Mostrar el botón “Permisos” si el VISOR tiene el permiso global, incluso en su propia fila.
          // El bloqueo para no “auto-suicidarse” vive en el backend (ver punto 2).
          const permisos = P.USR_CONFIG ?
            '<a href="javascript:void(0)" class="fa-tooltip icono_datatable icono_morado abrir-permisos" title="<?php echo $this->lang->line('admin_users_col_actions'); ?>" data-id="' +
            data + '" data-module=""><i class="fas fa-user-shield" style="font-size:16px;"></i></a> ' :
            '';


          // Si el usuario de la fila es rol 1/6, no muestres cambiar estado ni eliminar (como tenías)
          if (full.id_rol == 1 || full.id_rol == 6) {
            return editar + permisos + credenciales;
          } else {
            return editar + permisos + estado + eliminar + credenciales;
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

    // ✔ Título traducido
    $("#titulo_nuevo_modal").text("<?php echo $this->lang->line('admin_users_edit_title'); ?>");

    $("#nombreUsuarioInterno").val(data.nombre);
    $("#paternoUsuarioInterno").val(data.paterno);

    const rolSesion = <?php echo $this->session->userdata('idrol'); ?>;

    // Si NO es rol 6 NI 1 → deshabilitar el select
    if (rolSesion != 6 && rolSesion != 1) {
        $("#id_rolUsuarioInterno").val(data.id_rol).prop('disabled', true);
    } else {
        $("#id_rolUsuarioInterno").val(data.id_rol).prop('disabled', false);
    }

    // Mantener sincronizado el hidden
    $("#id_rolUsuarioInterno_hidden").val(data.id_rol);

    $("#id_rolUsuarioInterno").on("change", function () {
        $("#id_rolUsuarioInterno_hidden").val($(this).val());
    });

    $("#correoUsuarioInterno").val(data.correo);
    $("#telefonoUsuarioInterno").val(data.telefono);

    // Ocultar elementos solo usados en registro
    $('#ocultar-en-editar').hide();
    $("#divGenerarPassword").hide();
    $("#labelOcultar").hide();

    // ✔ Botón traducido
    $("#btnGuardar").text("<?php echo $this->lang->line('admin_users_btn_save_changes'); ?>");

    $("#btnGuardar").off("click").on("click", function () {
        editarUsuarios();
    });

    $("#nuevoAccesoUsuariosInternos").modal("show");
});



    },

    /****************************************************************/
    // Traducciones del DataTable
    "language": {
      "lengthMenu": "<?php echo($lang == 'es') ? 'Mostrar _MENU_ registros' : 'Show _MENU_ records'; ?>",
      "zeroRecords": "<?php echo($lang == 'es') ? 'No se encontraron registros' : 'No records found'; ?>",
      "info": "<?php echo($lang == 'es') ? 'Mostrando _START_ a _END_ de _TOTAL_' : 'Showing _START_ to _END_ of _TOTAL_'; ?>",
      "infoEmpty": "<?php echo($lang == 'es') ? 'No hay registros disponibles' : 'No records available'; ?>",
      "infoFiltered": "<?php echo($lang == 'es') ? '(filtrado de _MAX_ registros)' : '(filtered from _MAX_ total records)'; ?>",
      "sSearch": "<?php echo($lang == 'es') ? 'Buscar:' : 'Search:'; ?>",
      "oPaginate": {
        "sLast": "<?php echo($lang == 'es') ? 'Última página' : 'Last page'; ?>",
        "sFirst": "<?php echo($lang == 'es') ? 'Primera' : 'First'; ?>",
        "sNext": "<?php echo($lang == 'es') ? 'Siguiente' : 'Next'; ?>",
        "sPrevious": "<?php echo($lang == 'es') ? 'Anterior' : 'Previous'; ?>"
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
    $('#titulo_mensaje').html('<?php echo $this->lang->line("admin_users_js_delete_title") ?>');
    $('#mensaje').html(
      '<?php echo str_replace("{user}", "' + valor1 + '", $this->lang->line("admin_users_js_delete_msg")) ?>');
    $('#btnConfirmar').attr("onclick", "botonesAccionesUsuario('eliminar'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  } else if (accion == "Desactivar usuario") {
    $('#titulo_mensaje').html('<?php echo $this->lang->line("admin_users_js_disable_title") ?>');
    $('#mensaje').html(
      '<?php echo str_replace("{user}", "' + valor1 + '", $this->lang->line("admin_users_js_disable_msg")) ?>');
    $('#btnConfirmar').attr("onclick", "botonesAccionesUsuario('desactivar'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  } else if (accion == "Activar usuario") {
    $('#titulo_mensaje').html('<?php echo $this->lang->line("admin_users_js_enable_title") ?>');
    $('#mensaje').html(
      '<?php echo str_replace("{user}", "' + valor1 + '", $this->lang->line("admin_users_js_enable_msg")) ?>');
    $('#btnConfirmar').attr("onclick", "botonesAccionesUsuario('activar'," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
}


function enviarCredenciales(email, userId) {

  $('#titulo_mensaje_contraseña').html('<?php echo $this->lang->line("admin_users_js_resend_title") ?>');
  $('#mensaje_contraseña').html(
    '<?php echo str_replace("{email}", "' + email + '", $this->lang->line("admin_users_js_resend_msg")) ?>');

  $('#btnEnviarPass').attr("onclick", "actualizarContraseña()");
  $('#idUsuarioInternoEditPass').val(userId);
  $('#idCorreo').val(email);
  $('#password').val('');

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
          title: "<?php echo $this->lang->line('admin_users_limit_reached_title'); ?>",
          html: "<?php echo $this->lang->line('admin_users_limit_reached_msg'); ?>",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: "<?php echo $this->lang->line('admin_users_btn_accept_extra'); ?>",
          cancelButtonText: "<?php echo $this->lang->line('admin_users_btn_cancel'); ?>"
        }).then((result) => {

          if (result.isConfirmed) {

            Swal.fire({
              title: "<?php echo $this->lang->line('admin_users_final_confirm_title'); ?>",
              html: "<?php echo $this->lang->line('admin_users_final_confirm_msg'); ?>",
              icon: 'question',
              showCancelButton: true,
              confirmButtonText: "<?php echo $this->lang->line('admin_users_btn_continue'); ?>",
              cancelButtonText: "<?php echo $this->lang->line('admin_users_btn_cancel'); ?>"
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
      Swal.fire(
        'Error',
        "<?php echo $this->lang->line('admin_users_error_check_limit'); ?>",
        'error'
      );
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
      $('#usuario').append(
        '<option value=""><?php echo $this->lang->line("admin_users_modal_select_user") ?></option>');
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

          $('#sucursal').append(
            '<option value=""><?php echo $this->lang->line("admin_users_modal_select_branch") ?></option>'
          );
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

  const t_warning_title = "<?php echo $this->lang->line('admin_users_assign_warning_title'); ?>";
  const t_warning_text = "<?php echo $this->lang->line('admin_users_assign_warning_text'); ?>";
  const t_success_title = "<?php echo $this->lang->line('admin_users_assign_success_title'); ?>";
  const t_success_text = "<?php echo $this->lang->line('admin_users_assign_success_text'); ?>";
  const t_error_title = "<?php echo $this->lang->line('admin_users_assign_error_title'); ?>";
  const t_error_text = "<?php echo $this->lang->line('admin_users_assign_error_text'); ?>";
  const t_confirm_btn = "<?php echo $this->lang->line('admin_users_assign_confirm'); ?>";

  if (usuariosSeleccionados.length === 0 || sucursalesSeleccionadas.length === 0) {
    Swal.fire({
      icon: 'warning',
      title: t_warning_title,
      text: t_warning_text,
      confirmButtonText: t_confirm_btn
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
        title: t_success_title,
        text: t_success_text,
        confirmButtonText: t_confirm_btn
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
        title: t_error_title,
        text: t_error_text,
        confirmButtonText: t_confirm_btn
      });
    }
  });
});




/****************************ACCION**EDITAR USUARIO***********************************************/


function editarUsuarios() {
  let datos = $('#formAccesoUsuariosinternos').serializeArray();
  console.log(datos);
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
          title: '<?php echo $this->lang->line("admin_users_sw_edit_success"); ?>',
          showConfirmButton: false,
          timer: 5000
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
          title: '<?php echo $this->lang->line("admin_users_action_success"); ?>',
          text: data.msg,
          showConfirmButton: false,
          timer: 2400
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: '<?php echo $this->lang->line("admin_users_action_error"); ?>',
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
          title: "<?php echo $this->lang->line('admin_users_sw_pass_success'); ?>",
          showConfirmButton: false,
          timer: 3000
        });
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: "<?php echo $this->lang->line('admin_users_sw_pass_error_title'); ?>",
          text: data.msg || "<?php echo $this->lang->line('admin_users_sw_pass_error_text'); ?>",
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

var baseUrl = window.BASE_URL || '<?php echo base_url(); ?>';

// Click en el botón del DataTable
$(document).on('click', '.abrir-permisos', function() {
  const userId = $(this).data('id');
  const module = $(this).data('module') || '';

  $.ajax({
    url: baseUrl + 'permisos/precheck',
    type: 'post',
    dataType: 'json',
    data: {
      user_id: userId,
      module: module
    },
    beforeSend: function() {
      $('.loader').show();
    },
    success: function(res) {
      $('.loader').fadeOut();

      if (!res || res.ok !== true) {
        Swal.fire(
          '<?php echo $this->lang->line("admin_users_permissions_error_title"); ?>',
          (res && res.msg) ? res.msg :
          '<?php echo $this->lang->line("admin_users_permissions_error_msg"); ?>',
          'warning'
        );
        return;
      }

      if (res.fallback && res.fallback_from) {
        Swal.fire({
          icon: 'info',
          title: '<?php echo $this->lang->line("admin_users_permissions_adjusted_title"); ?>',
          html: '<?php echo $this->lang->line("admin_users_permissions_adjusted_msg"); ?> <b>' + res
            .module + '</b>',
          timer: 1800,
          showConfirmButton: false
        });
      }

      // Título del modal traducido
      $('#modalPermisos .modal-title').text(
        '<?php echo $this->lang->line("admin_users_permissions_modal_title"); ?>' +
        userId +
        '<?php echo $this->lang->line("admin_users_permissions_modal_sub"); ?>' +
        (res.module || module)
      );

      $('#modalPermisos').modal('show');

      $('#modalPermisos .modal-body').html(
        '<div class="text-center p-5"><div class="spinner-border"></div><div class="mt-2 text-muted"><?php echo $this->lang->line("admin_users_permissions_loading"); ?></div></div>'
      );

      $('#modalPermisos .modal-body').load(res.modal_url);
    },
    error: function() {
      $('.loader').fadeOut();
      Swal.fire(
        'Error',
        '<?php echo $this->lang->line("admin_users_permissions_error_generic"); ?>',
        'error'
      );
    }
  });
});



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