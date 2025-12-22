<!-- Begin Page Content -->
<div class="container-fluid">
  <?php
      // justo arriba del <script> donde configuras DataTables
      $idRol = $this->session->userdata('idrol');
  ?>

  <!-- Page Heading -->
  <div class="align-items-center mb-4">
    <div class="row justify-content-between align-items-center">
      <div class="col-sm-12 col-md-8">
        <h2><?php echo $this->lang->line('suc_title'); ?></h2>
      </div>

      <div class="col-sm-12 col-md-4 d-flex flex-wrap flex-md-nowrap justify-content-end align-items-center">
        <?php if (show_if_can('admin.sucursales.generar_link', ($tipo_bolsa == 1) && in_array((int) $idRol, [1, 6, 9], true))): ?>
        <a href="#" class="btn btn-outline-primary btn-lg btn-elevated mr-2 mb-2" onclick="generarLinkstodos(event)">
          <span><?php echo $this->lang->line('suc_btn_links_all'); ?></span>
        </a>
        <?php endif; ?>

        <?php if (show_if_can('admin.sucursales.crear', in_array((int) $idRol, [1, 6, 9], true))): ?>
        <a href="#" class="btn btn-outline-primary btn-lg btn-elevated mb-2" data-toggle="modal" data-target="#newModal"
          onclick="registrarCliente()">
          <span><?php echo $this->lang->line('suc_btn_create_branch'); ?></span>
        </a>
        <?php endif; ?>
      </div>
    </div>

    <div>
      <p><?php echo $this->lang->line('suc_description'); ?></p>
    </div>
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <!-- Si quieres ponerle título aquí, crea una key y la imprimes -->
      <h6 class="m-0 font-weight-bold text-primary"></h6>
    </div>

    <div class="card-body">
      <div class="table-responsive">
        <table id="tabla" class="table table-bordered" width="100%" cellspacing="0"></table>
      </div>
    </div>
  </div>

  <?php echo $modals; ?>

  <div class="loader" style="display:none;"></div>
  <input type="hidden" id="idCliente">
  <input type="hidden" id="idUsuarioCliente">
</div>

<div class="modal fade" id="enviarCredenciales" tabindex="-1" role="dialog" aria-labelledby="mensajeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="titulo_mensaje_contraseña">
          <?php echo $this->lang->line('suc_modal_send_credentials_title'); ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="modal-body" id="mensaje_contraseña"></div>

          <div class="col-md-9">
            <label><?php echo $this->lang->line('suc_lbl_generate_password'); ?></label>

            <div class="input-group">
              <input type="text" class="form-control" name="password_cliente" id="password_cliente" maxlength="20">
              <div class="input-group-append">
                <button type="button" class="btn btn-primary" onclick="generarPassword1()">
                  <?php echo $this->lang->line('suc_btn_generate'); ?>
                </button>
              </div>
            </div>
          </div>
        </div>

        <input type="hidden" class="form-control" name="idDatosGeneralesEditPass" id="idDatosGeneralesEditPass">
        <input type="hidden" class="form-control" name="idCorreo" id="idCorreo">
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?php echo $this->lang->line('suc_btn_cancel'); ?>
        </button>

        <button type="button" class="btn btn-danger" id="btnEnviarPass">
          <?php echo $this->lang->line('suc_btn_resend_password'); ?>
        </button>
      </div>

    </div>
  </div>
</div>
<?php
    // justo arriba del <script> donde configuras DataTables
    echo perms_js_flags([
        'suc_ver'             => ['admin.sucursales.ver', in_array((int) $idRol, [1, 6, 9], true)],
        'suc_crear'           => ['admin.sucursales.crear', in_array((int) $idRol, [1, 6, 9], true)],
        'suc_editar'          => ['admin.sucursales.editar', in_array((int) $idRol, [1, 6, 9], true)],
        'suc_eliminar'        => ['admin.sucursales.eliminar', in_array((int) $idRol, [1, 6, 9], true)],
        'suc_estado'          => ['admin.sucursales.cambiar_estado', in_array((int) $idRol, [1, 6, 9], true)],
        'suc_generar_link'    => ['admin.sucursales.generar_link', ($tipo_bolsa == 1) && in_array((int) $idRol, [1, 6, 9], true)],
        'suc_ver_accesos'     => ['admin.sucursales.ver_accesos', in_array((int) $idRol, [1, 6, 9], true)],
        'suc_generar_usuario' => ['admin.sucursales.generar_usuario', in_array((int) $idRol, [1, 6, 9], true)],

    ]);
?>
<!-- /.content-wrapper -->
<script>
// Todo lo que ya cargó CI3 con $this->lang->load(...)
window.LANG = <?php echo json_encode(
                                                $this->lang->language,
                                            JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
                                        ); ?>;

// Traducción simple
window.t = function(key, fallback) {
  if (window.LANG && window.LANG[key] !== undefined && window.LANG[key] !== '') return window.LANG[key];
  return (fallback !== undefined) ? fallback : key;
};

// Para meter texto en atributos HTML (title="", data-*)
window.escAttr = function(s) {
  return String(s ?? '')
    .replace(/&/g, '&amp;')
    .replace(/"/g, '&quot;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;');
};

window.tAttr = function(key, fallback) {
  return window.escAttr(window.t(key, fallback));
};
</script>

<script>
var url = '<?php echo base_url('Cat_Cliente/getClientes'); ?>';

var tipos_bloqueo_php =
  '<?php foreach ($tipos_bloqueo as $row) {echo '<option value="' . $row->tipo . '">' . $row->descripcion . '</option>';}?>';
var tipos_desbloqueo_php =
  '<?php foreach ($tipos_desbloqueo as $row) {echo '<option value="' . $row->tipo . '">' . $row->descripcion . '</option>';}?>';
window.TS_I18N = window.TS_I18N || {};
Object.assign(window.TS_I18N, {
  // Swal
  suc_saved_ok: "<?php echo $this->lang->line('suc_saved_ok'); ?>",

  // Columnas / datatable
  suc_col_id: "<?php echo $this->lang->line('suc_col_id'); ?>",
  suc_col_name: "<?php echo $this->lang->line('suc_col_name'); ?>",
  suc_col_key: "<?php echo $this->lang->line('suc_col_key'); ?>",
  suc_col_created_at: "<?php echo $this->lang->line('suc_col_created_at'); ?>",
  suc_col_access: "<?php echo $this->lang->line('suc_col_access'); ?>",
  suc_col_actions: "<?php echo $this->lang->line('suc_col_actions'); ?>",

  // Accesos texto
  suc_access_none: "<?php echo $this->lang->line('suc_access_none'); ?>",
  suc_access_has: "<?php echo $this->lang->line('suc_access_has'); ?>",

  // Tooltips
  suc_tt_edit: "<?php echo $this->lang->line('suc_tt_edit'); ?>",
  suc_tt_activate: "<?php echo $this->lang->line('suc_tt_activate'); ?>",
  suc_tt_deactivate: "<?php echo $this->lang->line('suc_tt_deactivate'); ?>",
  suc_tt_delete_client: "<?php echo $this->lang->line('suc_tt_delete_client'); ?>",
  suc_tt_view_access: "<?php echo $this->lang->line('suc_tt_view_access'); ?>",
  suc_tt_block_client: "<?php echo $this->lang->line('suc_tt_block_client'); ?>",
  suc_tt_unblock_client: "<?php echo $this->lang->line('suc_tt_unblock_client'); ?>",
  suc_tt_generate_link: "<?php echo $this->lang->line('suc_tt_generate_link'); ?>",
  suc_tt_generar_usuario: "<?php echo $this->lang->line('suc_tt_generar_usuario'); ?>",

  // DataTables language UI
  dt_lengthMenu: "<?php echo $this->lang->line('dt_lengthMenu'); ?>",
  dt_zeroRecords: "<?php echo $this->lang->line('dt_zeroRecords'); ?>",
  dt_info: "<?php echo $this->lang->line('dt_info'); ?>",
  dt_infoEmpty: "<?php echo $this->lang->line('dt_infoEmpty'); ?>",
  dt_infoFiltered: "<?php echo $this->lang->line('dt_infoFiltered'); ?>",
  dt_search: "<?php echo $this->lang->line('dt_search'); ?>",
  dt_last: "<?php echo $this->lang->line('dt_last'); ?>",
  dt_first: "<?php echo $this->lang->line('dt_first'); ?>",
  dt_next: "<?php echo $this->lang->line('dt_next'); ?>",
  dt_previous: "<?php echo $this->lang->line('dt_previous'); ?>"
});
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
      title: (window.TS_I18N?.suc_saved_ok || 'Se ha guardado correctamente'),
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
      }
    },

    "columns": [{
        title: window.t('suc_col_id', 'ID'),
        data: 'id',
        visible: false
      },
      {
        title: window.t('suc_col_name', 'Nombre'),
        data: 'nombre',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return '<span class="badge badge-pill badge-dark">#' + full.idCliente + '</span><br><b>' + data +
            '</b>';
        }
      },
      {
        title: window.t('suc_col_key', 'Clave'),
        data: 'clave',
        bSortable: false,
        "width": "3%",
        mRender: function(data, type, full) {
          return '<b>' + data + '</b>';
        }
      },
      {
        title: window.t('suc_col_created_at', 'Fecha de creación'),
        data: 'creacion',
        bSortable: false,
        "width": "7%",
        mRender: function(data, type, full) {
          var f = data.split(' ');
          var h = f[1];
          var auxH = h.split(':');
          var hora = auxH[0] + ':' + auxH[1];

          var auxF = f[0].split('-');
          var fecha = auxF[2] + "/" + auxF[1] + "/" + auxF[0];

          return fecha + ' ' + hora;
        }
      },
      {
        title: window.t('suc_col_access', 'Accesos'),
        data: 'numero_usuarios_clientes',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          if (data == 0) {
            return window.t('suc_access_none', 'No se encontraron accesos');
          }
          return window.t('suc_access_has', 'Cuenta con {count} acceso(s)').replace('{count}', data);
        }
      },
      {
        title: window.t('suc_col_actions', 'Acciones'),
        data: null,
        orderable: false,
        width: "15%",
        render: function(data, type, full) {

          function can(k) {
            return !!(window.PERM && window.PERM[k]);
          }

          var nombre = window.escAttr((full && full.nombre) ? full.nombre : '');
          var id = full.idCliente;

          var html = '';

          // Editar
          if (can('suc_editar')) {
            html += '' +
              '<a href="javascript:void(0)" data-toggle="tooltip"' +
              ' title="' + window.tAttr('suc_tt_edit', 'Editar') + '"' +
              ' class="act-editar fa-tooltip icono_datatable icono_azul_oscuro"' +
              ' data-id="' + id + '" data-nombre="' + nombre + '">' +
              ' <i class="fas fa-edit"></i>' +
              '</a> ';
          }

          // Activar / Desactivar
          if (can('suc_estado')) {
            if (Number(full.status) === 0) {
              html += '' +
                '<a href="javascript:void(0)" data-toggle="tooltip"' +
                ' title="' + window.tAttr('suc_tt_activate', 'Activar') + '"' +
                ' class="act-activar fa-tooltip icono_datatable icono_rojo"' +
                ' data-id="' + id + '" data-nombre="' + nombre + '">' +
                ' <i class="fas fa-ban"></i>' +
                '</a> ';
            } else {
              html += '' +
                '<a href="javascript:void(0)" data-toggle="tooltip"' +
                ' title="' + window.tAttr('suc_tt_deactivate', 'Desactivar') + '"' +
                ' class="act-desactivar fa-tooltip icono_datatable icono_verde"' +
                ' data-id="' + id + '" data-nombre="' + nombre + '">' +
                ' <i class="far fa-check-circle"></i>' +
                '</a> ';
            }
          }

          // Eliminar
          if (can('suc_eliminar')) {
            html += '' +
              '<a href="javascript:void(0)" data-toggle="tooltip"' +
              ' title="' + window.tAttr('suc_tt_delete_client', 'Eliminar cliente') + '"' +
              ' class="act-eliminar fa-tooltip icono_datatable icono_gris"' +
              ' data-id="' + id + '" data-nombre="' + nombre + '">' +
              ' <i class="fas fa-trash"></i>' +
              '</a> ';
          }

          // Ver accesos
          if (can('suc_ver_accesos')) {
            html += '' +
              '<a href="javascript:void(0)" data-toggle="tooltip"' +
              ' title="' + window.tAttr('suc_tt_view_access', 'Ver accesos') + '"' +
              ' class="act-acceso fa-tooltip icono_datatable icono_azul_claro"' +
              ' data-id="' + id + '" data-nombre="' + nombre + '">' +
              ' <i class="fas fa-sign-in-alt"></i>' +
              '</a> ';
          }

          // Bloquear / Desbloquear
          if (can('suc_estado')) {
            if (String(full.bloqueado) === 'NO') {
              html += '' +
                '<a href="javascript:void(0)" data-toggle="tooltip"' +
                ' title="' + window.tAttr('suc_tt_block_client', 'Bloquear cliente') + '"' +
                ' class="act-bloquear fa-tooltip icono_datatable icono_verde"' +
                ' data-id="' + id + '" data-nombre="' + nombre + '">' +
                ' <i class="fas fa-user-check"></i>' +
                '</a> ';
            } else {
              html += '' +
                '<a href="javascript:void(0)" data-toggle="tooltip"' +
                ' title="' + window.tAttr('suc_tt_unblock_client', 'Desbloquear cliente') + '"' +
                ' class="act-desbloquear fa-tooltip icono_datatable icono_rojo"' +
                ' data-id="' + id + '" data-nombre="' + nombre + '">' +
                ' <i class="fas fa-user-lock"></i>' +
                '</a> ';
            }
          }

          // Generar link
          if (can('suc_generar_link') && Number(full.tipo_bolsa) === 1) {
            html += '' +
              '<a href="javascript:void(0)" data-toggle="tooltip"' +
              ' title="' + window.tAttr('suc_tt_generate_link', 'Generar link') + '"' +
              ' class="link-requisicion fa-tooltip icono_datatable icono_azul_claro"' +
              ' data-id-cliente="' + id + '" data-nombre="' + nombre + '">' +
              ' <i class="fas fa-external-link-alt"></i>' +
              '</a> ';
          }

          // Generar usuario (siempre lo estabas pintando)
          html += '' +
            '<a href="javascript:void(0)" data-toggle="tooltip"' +
            ' title="' + window.tAttr('suc_tt_generar_usuario', 'Generar usuario') + '"' +
            ' class="btn-generar-usuario fa-tooltip icono_datatable icono_verde"' +
            ' data-id-cliente="' + id + '" data-nombre="' + nombre + '">' +
            ' <i class="fas fa-user-plus"></i>' +
            '</a>';

          return html;
        }
      }
    ],

    "columnDefs": [{
      "targets": [2, 3, 4],
      "className": 'hide-on-small'
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

      // EDITAR
      $("a.act-editar", row).off('click').on('click', function() {
        resetModal();

        $("#idCliente").val(data.idCliente);
        $("#idFacturacion").val(data.dFac);
        $("#idDomicilios").val(data.dDom);
        $("#idGenerales").val(data.dGen);

        $("#titulo_nuevo_modal").text(window.t('suc_modal_title_edit_client', 'Editar cliente'));

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

        // Facturación
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

        // Password/contacto (ocultos en edición)
        $("#password").val(data.password_contacto).hide().prev("label").hide();
        $("#generarPass").hide();
        $("#passLabel").hide();
        $("#togglePass").hide();

        $("#newModal").modal("show");
      });

      // Al cerrar modal: limpiar
      $("#newModal").off('hidden.bs.modal').on('hidden.bs.modal', function() {
        if (typeof resetModal === 'function') {
          resetModal();
          return;
        }

        var frm = $(this).find('form')[0];
        if (frm && frm.reset) frm.reset();

        $(this).find('input, select, textarea').val('');

        $("#password").show().prev("label").show();
        $("#generarPass, #passLabel, #togglePass").show();

        $("#titulo_nuevo_modal").text(window.t('suc_modal_title_new_client', 'Nuevo cliente'));
      });

      // ESTADO / BLOQUEO / ELIMINAR (tu lógica igual)
      $("a.act-activar", row).off('click').on('click', function() {
        mostrarMensajeConfirmacion('activar cliente', data.nombre, data.idCliente);
      });
      $("a.act-desactivar", row).off('click').on('click', function() {
        mostrarMensajeConfirmacion('desactivar cliente', data.nombre, data.idCliente);
      });
      $("a.act-bloquear", row).off('click').on('click', function() {
        mostrarMensajeConfirmacion('bloquear cliente', data.nombre, data.idCliente);
      });
      $("a.act-desbloquear", row).off('click').on('click', function() {
        mostrarMensajeConfirmacion('desbloquear cliente', data.nombre, data.idCliente);
      });
      $("a.act-eliminar", row).off('click').on('click', function() {
        mostrarMensajeConfirmacion('eliminar cliente', data.nombre, data.idCliente);
      });

      // LINK REQUISICIÓN
      $(row).find('a.link-requisicion').off('click').on('click', function() {
        var idCliente = $(this).data('id-cliente');
        var nombre = $(this).data('nombre') || '';

        $(".nombreCliente").text(nombre);
        $('#idClienteForLink').val(idCliente);

        $('#modalLinkRequisicion').data('idCliente', idCliente);
        $('#btnGenerarLinkReq').data('idCliente', idCliente);

        cargarLinks(idCliente);
        $('#modalLinkRequisicion').modal('show');
      });

      function cargarLinks(idCliente) {

        $('#linksContainer').html('<em>' + window.t('suc_loading', 'Cargando…') + '</em>');

        $.ajax({
          url: '<?php echo base_url("Cat_Cliente/getLinks"); ?>',
          type: 'POST',
          dataType: 'json',
          data: {
            id_cliente: idCliente,
            <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
          },
          beforeSend: mostrarLoader,
          success: function(res) {
            ocultarLoader();

            var html = '';
            if (Array.isArray(res) && res.length) {
              for (var i = 0; i < res.length; i++) {
                var l = res[i];
                var urlLink = l.link || '#';

                var expiresHtml = '';
                if (l.fecha_expira) {
                  expiresHtml = '<small class="text-muted">' +
                    window.t('suc_links_expires', 'Expira: {date}').replace('{date}', l.fecha_expira) +
                    '</small>';
                }

                var qrHtml = '';
                if (l.qr) {
                  qrHtml = '<img src="' + l.qr +
                    '" alt="QR" class="img-fluid mx-auto d-block" style="max-width:150px;">';
                } else {
                  qrHtml = '<em class="d-block">' + window.t('suc_links_qr_not_available',
                    'QR no disponible') + '</em>';
                }

                html += '' +
                  '<div class="p-2 mb-2 border rounded link-item">' +
                  '  <div class="d-flex align-items-center gap-2">' +
                  '    <strong class="mr-2">' + window.t('suc_links_label_link', 'Link:') +
                  '</strong>' +
                  '    <a href="' + urlLink + '" target="_blank" class="link-url text-truncate mr-2"' +
                  '       style="display:inline-block; max-width: calc(100% - 180px);">' +
                  urlLink +
                  '    </a>' +
                  '    <button type="button" class="btn btn-sm btn-outline-primary btn-copy-link" data-url="' +
                  urlLink + '">' +
                  window.t('suc_btn_copy', 'Copiar') +
                  '    </button>' +
                  '  </div>' +
                  '  <div class="mt-2 text-center">' +
                  '    <strong class="d-block mb-1">' + window.t('suc_links_label_qr', 'QR:') +
                  '</strong>' +
                  qrHtml +
                  '  </div>' +
                  expiresHtml +
                  '</div>';
              }
            } else {
              html = '<div class="text-muted"><em>' + window.t('suc_links_none',
                'No hay links generados') + '</em></div>';
            }

            $('#linksContainer').html(html);
          },
          error: function() {
            ocultarLoader();
            $('#linksContainer').html('<div class="text-danger">' + window.t('suc_links_error_load',
              'Error al cargar links') + '</div>');
          }
        });
      }

      // copiar link
      $('#linksContainer').off('click', '.btn-copy-link').on('click', '.btn-copy-link', function() {
        var $btn = $(this);
        var urlLink = $btn.data('url');

        function setCopiedState() {
          $btn.text(window.t('suc_btn_copied', '¡Copiado!')).prop('disabled', true);
          setTimeout(function() {
            $btn.text(window.t('suc_btn_copy', 'Copiar')).prop('disabled', false);
          }, 1200);
        }

        function fallbackCopy(text) {
          var ta = document.createElement('textarea');
          ta.value = text;
          ta.style.position = 'fixed';
          ta.style.opacity = '0';
          document.body.appendChild(ta);
          ta.select();
          try {
            document.execCommand('copy');
          } catch (e) {}
          document.body.removeChild(ta);
          setCopiedState();
        }

        if (navigator.clipboard && window.isSecureContext) {
          navigator.clipboard.writeText(urlLink)
            .then(function() {
              setCopiedState();
            })
            .catch(function() {
              fallbackCopy(urlLink);
            });
        } else {
          fallbackCopy(urlLink);
        }
      });

      // generar link req
      $(document).off('click', '#btnGenerarLinkReq').on('click', '#btnGenerarLinkReq', function() {

        var idCliente =
          $(this).data('idCliente') ||
          $('#modalLinkRequisicion').data('idCliente') ||
          $('#idClienteForLink').val();

        if (!idCliente) {
          return alert(window.t('suc_missing_id_cliente', 'Falta id_cliente'));
        }

        function generar() {
          $.ajax({
            url: '<?php echo base_url("Cat_Cliente/generarLinkRequisicion"); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
              id_cliente: parseInt(idCliente, 10),
              <?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            beforeSend: mostrarLoader,
            success: function(res) {
              ocultarLoader();

              if (res && res.error) {
                if (window.Swal) return Swal.fire(window.t('suc_sw_error_title', 'Error'), res
                  .error, 'error');
                return alert(res.error);
              }

              cargarLinks(idCliente);

              var msgOk = (res && res.mensaje) ? res.mensaje : window.t('suc_sw_link_generated',
                'Link generado.');
              if (window.Swal) return Swal.fire(window.t('suc_sw_success_title', '¡Listo!'), msgOk,
                'success');

            },
            error: function() {
              ocultarLoader();
              var msgErr = window.t('suc_sw_link_generate_failed', 'No se pudo generar el link.');
              if (window.Swal) return Swal.fire(window.t('suc_sw_error_title', 'Error'), msgErr,
                'error');
              alert(msgErr);
            }
          });
        }

        if (window.Swal) {
          Swal.fire({
            icon: 'warning',
            title: window.t('suc_sw_link_confirm_title', '¿Generar/actualizar link?'),
            text: window.t('suc_sw_link_confirm_text',
              'El link y el QR anteriores quedarán obsoletos.'),
            showCancelButton: true,
            confirmButtonText: window.t('suc_sw_confirm_yes', 'Sí, continuar'),
            cancelButtonText: window.t('suc_sw_confirm_cancel', 'Cancelar')
          }).then(function(r) {
            if (r && r.isConfirmed) generar();
          });
        } else {
          generar();
        }
      });

      // VER ACCESOS
      $("a.act-acceso", row).off('click').on('click', function() {

        $(".nombreCliente").text(data.nombre);
        $("#div_accesos").empty();
        mostrarLoader();

        $.ajax({
          url: '<?php echo base_url('Cat_Cliente/getClientesAccesos'); ?>',
          type: 'post',
          data: {
            id_cliente: data.idCliente
          },
          success: function(res) {
            ocultarLoader();

            if (res && res !== "0") {
              var datos = JSON.parse(res);
              var salida = generarTabla(datos);
              $("#div_accesos").html(salida);
            } else {
              mostrarMensajeNoRegistros();
              $("#div_accesos").html('<div class="text-center py-3">' + window.t(
                'suc_access_modal_none', 'Sin accesos.') + '</div>');
            }
          },
          error: function() {
            ocultarLoader();
            $("#div_accesos").html('<div class="text-danger text-center py-3">' + window.t(
              'suc_access_modal_error_load', 'Error al cargar accesos.') + '</div>');
          }
        });

        $("#accesosClienteModal").modal('show');
      });

      $("#accesosClienteModal").off('hidden.bs.modal').on('hidden.bs.modal', function() {
        $(".nombreCliente").text('');
        $("#div_accesos").empty();
      });

      function mostrarLoader() {
        $('.loader').css("display", "block");
      }

      function ocultarLoader() {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
      }

      function generarTabla(datos) {
        var salida = '' +
          '<table class="table table-striped">' +
          '  <thead>' +
          '    <tr>' +
          '      <th scope="col">' + window.t('suc_access_tbl_name', 'Nombre') + '</th>' +
          '      <th scope="col">' + window.t('suc_access_tbl_email', 'Correo') + '</th>' +
          '      <th scope="col">' + window.t('suc_access_tbl_created', 'Alta') + '</th>' +
          '      <th scope="col">' + window.t('suc_access_tbl_user', 'Usuario') + '</th>' +
          '      <th scope="col">' + window.t('suc_access_tbl_category', 'Categoría') + '</th>' +
          '      <th scope="col">' + window.t('suc_access_tbl_actions', 'Acciones') + '</th>' +
          '    </tr>' +
          '  </thead>' +
          '  <tbody>';

        for (var i = 0; i < datos.length; i++) {
          var dato = datos[i];

          var usuarioCliente = (dato['usuario_cliente'] === null) ?
            window.t('suc_access_pending_register', 'Pendiente de registrar') :
            dato['usuario_cliente'];

          var privacidad = '';
          if (dato['privacidad'] > 0) {
            privacidad = window.t('suc_access_privacy_level', 'Nivel {level}').replace('{level}', dato[
              'privacidad']);
          } else {
            privacidad = window.t('suc_access_privacy_none', 'Sin privacidad');
          }

          var fecha = fechaCompletaAFront(dato['alta']);

          salida += '' +
            '<tr id="' + dato['idUsuarioCliente'] + '">' +
            '  <th>' + usuarioCliente + '</th>' +
            '  <th>' + dato['correo_usuario'] + '</th>' +
            '  <th>' + fecha + '</th>' +
            '  <th>' + dato['usuario'] + '</th>' +
            '  <th>' + privacidad + '</th>' +
            '  <th>' +
            '    <a href="javascript:void(0)" class="fa-tooltip icono_datatable icono_accion_gris"' +
            '       onclick="mostrarMensajeConfirmacion(\'eliminar usuario cliente\', \'' + String(
              usuarioCliente).replace(/'/g, "\\'") + '\', ' + dato['idUsuarioCliente'] + ')">' +
            '      <i class="fas fa-trash"></i>' +
            '    </a>' +
            '    <a href="javascript:void(0)" class="fa-tooltip icono_datatable icono_accion_amarillo"' +
            '       onclick="enviarCredenciales(\'' + String(dato['correo_usuario']).replace(/'/g, "\\'") +
            '\', ' + dato['id_datos_generales'] + ')">' +
            '      <i class="fas fa-sync-alt" style="font-size: 16px;"></i>' +
            '    </a>' +
            '  </th>' +
            '</tr>';
        }

        salida += '</tbody></table>';
        return salida;
      }

      function mostrarMensajeNoRegistros() {
        $('#div_accesos').html('<p style="text-align:center; font-size: 20px;">' + window.t(
          'suc_access_no_records', 'No hay registro de accesos') + '</p>');
      }

      // estos dos los dejé igual, solo cambié a .off/.on y el texto final traducible
      $("a#desactivar_acceso", row).off('click').on('click', function() {
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
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            $("#mensajeModal").modal('hide');
            recargarTable();
            $("#texto_msj").text(window.t('suc_updated_ok', 'Se ha actualizado exitosamente'));
            $("#mensaje").css('display', 'block');
            setTimeout(function() {
              $('#mensaje').fadeOut();
            }, 4000);
          }
        });
      });

      $("a#activar_acceso", row).off('click').on('click', function() {
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
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            $("#mensajeModal").modal('hide');
            recargarTable();
            $("#texto_msj").text(window.t('suc_updated_ok', 'Se ha actualizado exitosamente'));
            $("#mensaje").css('display', 'block');
            setTimeout(function() {
              $('#mensaje').fadeOut();
            }, 4000);
          }
        });
      });

    }, // rowCallback

    "language": {
      "lengthMenu": window.t('dt_lengthMenu', "Mostrar _MENU_ registros"),
      "zeroRecords": window.t('dt_zeroRecords', "No se encontraron registros"),
      "info": window.t('dt_info', "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros"),
      "infoEmpty": window.t('dt_infoEmpty', "No hay registros disponibles"),
      "infoFiltered": window.t('dt_infoFiltered', "(Filtrado de _MAX_ registros en total)"),
      "sSearch": window.t('dt_search', "Buscar:"),
      "oPaginate": {
        "sLast": window.t('dt_last', "Última página"),
        "sFirst": window.t('dt_first', "Primera"),
        "sNext": window.t('dt_next', "Siguiente"),
        "sPrevious": window.t('dt_previous', "Anterior")
      }
    }

  });

  // Ajuste adicional si es necesario
  $(window).on('resize', function() {
    tabla.columns.adjust().draw();
  });

});
$(document).on('click', '.btn-generar-usuario', function() {
  var idCliente = $(this).data('id-cliente');
  var nombreCliente = $(this).data('nombre') || '';

  $('#gucIdCliente').val(idCliente);
  $('#gucNombreCliente').text(nombreCliente);

  // limpia campos
  $('#gucNombre').val('');
  $('#gucPaterno').val('');
  $('#gucCorreo').val('');
  $('#gucTelefono').val('');

  $('#btnGucGuardar').prop('disabled', false);
  $('#modalGenerarUsuarioCliente').modal('show');
});
var URL_GENERAR_USUARIO = "<?php echo site_url('Cat_Cliente/generar_usuario_cliente'); ?>";

// Enviar formulario
// ------------------------------
// 1) Submit: Generar Usuario Cliente
// ------------------------------

$('#formGenerarUsuarioCliente').off('submit').on('submit', function(e) {
  e.preventDefault();

  var $btn = $('#btnGucGuardar');
  $btn.prop('disabled', true);

  $.ajax({
    url: URL_GENERAR_USUARIO,
    method: 'POST',
    dataType: 'json',
    data: $(this).serialize(),
    success: function(res) {
      if (res && res.ok) {
        $('#modalGenerarUsuarioCliente').modal('hide');

        var msgOk = (res && res.msg) ? res.msg : window.t('suc_user_generated', 'Usuario generado.');

        if (window.Swal) {
          Swal.fire(window.t('suc_sw_success_title', '¡Listo!'), msgOk, 'success');
        } else {
          alert(msgOk);
        }

        // opcional: recargar datatable
        // $('#tabla').DataTable().ajax.reload(null, false);

      } else {
        var msgWarn = (res && res.msg) ? res.msg : window.t('suc_user_generate_failed',
          'No se pudo generar.');

        if (window.Swal) {
          Swal.fire(window.t('suc_sw_warning_title', 'Atención'), msgWarn, 'warning');
        } else {
          alert(msgWarn);
        }
      }
    },
    error: function() {
      var msgErr = window.t('suc_sw_comm_error', 'Error de comunicación con el servidor.');
      if (window.Swal) Swal.fire(window.t('suc_sw_error_title', 'Error'), msgErr, 'error');
      else alert(msgErr);
    },
    complete: function() {
      $btn.prop('disabled', false);
    }
  });
});


// ------------------------------
// 2) Generar Links Todos
//    (nota: el botón real debe existir: #btnGenerarLinks)
// ------------------------------
function generarLinkstodos(e) {
  if (e && e.preventDefault) e.preventDefault();

  var $btn = $('#btnGenerarLinks');
  var ajaxUrl = '<?php echo base_url('Cat_Cliente/generarLinksTodos'); ?>';

  $.ajax({
    url: ajaxUrl,
    method: 'POST',
    dataType: 'json',

    beforeSend: function() {
      $btn.prop('disabled', true).addClass('disabled');

      if (window.Swal) {
        Swal.fire({
          title: window.t('suc_links_generating_title', 'Generando links...'),
          text: window.t('suc_links_generating_text', 'Esto puede tardar unos segundos.'),
          allowOutsideClick: false,
          didOpen: function() {
            Swal.showLoading();
          }
        });
      }
    },

    success: function(res) {
      if (window.Swal) Swal.close();

      // Seguridad por si llega algo distinto
      var ok = 0;
      var fail = 0;
      var msg = '';
      var items = [];

      if (res) {
        ok = parseInt(res.ok, 10);
        if (isNaN(ok)) ok = 0;

        fail = parseInt(res.fail, 10);
        if (isNaN(fail)) fail = 0;

        msg = res.message || '';
        items = (res.items && Array.isArray(res.items)) ? res.items : [];
      }

      if (!msg) {
        msg = fail ?
          window.t('suc_links_done_with_errors', 'Proceso terminado con errores.') :
          window.t('suc_links_done_ok', 'Proceso completado correctamente.');
      }

      // Armar filas (sin template literals)
      var rows = '';
      for (var i = 0; i < items.length; i++) {
        var it = items[i] || {};
        var idCliente = (it.id_cliente !== undefined && it.id_cliente !== null) ? it.id_cliente : '-';
        var success = !!it.success;

        var estado = success ? '✅' : '❌';

        var detalle = '';
        if (success) {
          if (it.link) {
            detalle = '<a href="' + it.link + '" target="_blank" rel="noopener">' +
              window.t('suc_links_view_link', 'Ver link') +
              '</a>';
          } else {
            detalle = '-';
          }
        } else {
          detalle = it.error ? window.escAttr(it.error) : window.t('suc_links_unknown_error',
            'Error desconocido');
        }

        rows += '' +
          '<tr>' +
          '  <td style="white-space:nowrap;">' + idCliente + '</td>' +
          '  <td>' + estado + '</td>' +
          '  <td style="max-width:480px; overflow:hidden; text-overflow:ellipsis;">' + detalle + '</td>' +
          '</tr>';
      }

      if (!rows) {
        rows = '<tr><td colspan="3" style="padding:.5rem;">' + window.t('suc_links_no_items', 'Sin elementos.') +
          '</td></tr>';
      }

      var html = '' +
        '<div style="text-align:left">' +
        '  <p style="margin:.25rem 0;">✅ ' + window.t('suc_links_ok', 'Correctos') + ': <b>' + ok + '</b></p>' +
        '  <p style="margin:.25rem 0;">❌ ' + window.t('suc_links_fail', 'Errores') + ': <b>' + fail + '</b></p>' +
        '  <p style="margin:.25rem 0;">' + window.escAttr(msg) + '</p>' +
        '  <div style="max-height:300px; overflow:auto; border:1px solid #eee; border-radius:6px;">' +
        '    <table style="width:100%; font-size:13px;">' +
        '      <thead>' +
        '        <tr style="background:#f7f7f7;">' +
        '          <th style="text-align:left; padding:.5rem;">' + window.t('suc_links_tbl_id', 'ID ') +
        '</th>' +
        '          <th style="text-align:left; padding:.5rem;">' + window.t('suc_links_tbl_status', 'Status') +
        '</th>' +
        '          <th style="text-align:left; padding:.5rem;">' + window.t('suc_links_tbl_detail',
          'Detalle / Link') + '</th>' +
        '        </tr>' +
        '      </thead>' +
        '      <tbody>' + rows + '</tbody>' +
        '    </table>' +
        '  </div>' +
        '</div>';

      if (window.Swal) {
        Swal.fire({
          icon: fail ? 'warning' : 'success',
          title: fail ? window.t('suc_links_done_warn_title', 'Proceso con advertencias') : window.t(
            'suc_api_process_done_ok', 'Proceso completado'),
          html: html,
          confirmButtonText: window.t('suc_btn_accept', 'Aceptar')
        });
      } else {
        alert(msg);
      }
    },

    error: function(xhr) {
      if (window.Swal) Swal.close();
      console.error('Error AJAX:', (xhr && (xhr.responseText || xhr.statusText)) ? (xhr.responseText || xhr
        .statusText) : '');

      var msgErr = window.t('suc_links_request_error', 'Ocurrió un problema al procesar la solicitud.');

      if (window.Swal) {
        Swal.fire({
          icon: 'error',
          title: window.t('suc_sw_error_title', 'Error'),
          text: msgErr,
          confirmButtonText: window.t('suc_btn_accept', 'Aceptar')
        });
      } else {
        alert(msgErr);
      }
    },

    complete: function() {
      $btn.prop('disabled', false).removeClass('disabled');
    }
  });
}

// -----------------------------------------
// 1) Confirmaciones (activar/desactivar/eliminar/bloquear/desbloquear)
// -----------------------------------------
function mostrarMensajeConfirmacion(accion, valor1, valor2) {

  function setModal(tituloKey, tituloFallback, msgKey, msgFallback, btnOnclick) {
    // OJO: en tu HTML usas #titulo_mensaje1 y en desbloquear usabas #titulo_mensaje5
    // Para no romper, usamos #titulo_mensaje1 siempre (si existe).
    var $titulo = $('#titulo_mensaje1');
    if (!$titulo.length) $titulo = $('#titulo_mensaje5'); // fallback si tu modal usa otro id

    $titulo.text(window.t(tituloKey, tituloFallback));

    // mensaje base
    var nombre = String(valor1 || '');
    var htmlMsg = window.t(msgKey, msgFallback).replace('{name}', '<b>' + window.escAttr(nombre) + '</b>');
    $('#mensaje').html(htmlMsg);

    $('#btnConfirmar').attr('onclick', btnOnclick);
    $('#mensajeModal').modal('show');
  }

  if (accion == "activar cliente") {
    setModal(
      'suc_confirm_activate_title', 'Activar cliente',
      'suc_confirm_activate_text', '¿Desea activar al cliente {name}?',
      "accionCliente('activar'," + valor2 + ")"
    );
    return;
  }

  if (accion == "desactivar cliente") {
    setModal(
      'suc_confirm_deactivate_title', 'Desactivar cliente',
      'suc_confirm_deactivate_text', '¿Desea desactivar al cliente {name}?',
      "accionCliente('desactivar'," + valor2 + ")"
    );
    return;
  }

  if (accion == "eliminar cliente") {
    setModal(
      'suc_confirm_delete_title', 'Eliminar cliente',
      'suc_confirm_delete_text', '¿Desea eliminar al cliente {name}?',
      "accionCliente('eliminar'," + valor2 + ")"
    );
    return;
  }

  if (accion == "eliminar usuario cliente") {
    // cierra el modal de accesos si está abierto
    $("#accesosClienteModal").modal('hide');

    setModal(
      'suc_confirm_delete_user_title', 'Eliminar usuario',
      'suc_confirm_delete_user_text', '¿Desea eliminar al usuario {name}?',
      "controlAcceso('eliminar'," + valor2 + ")"
    );
    return;
  }

  if (accion == "bloquear cliente") {
    // título + pregunta
    setModal(
      'suc_confirm_block_title', 'Bloquear cliente',
      'suc_confirm_block_text', '¿Desea bloquear al cliente {name}?',
      "accionCliente('bloquear'," + valor2 + ")"
    );

    // campos extra (motivo, mensaje, checkbox)
    $('#mensaje').append(
      '<div class="row mt-3">' +
      '<div class="col-12">' +
      '<label>' + window.t('suc_block_reason_lbl', 'Motivo de bloqueo *') + '</label>' +
      '<select class="form-control" id="opcion_motivo" name="opcion_motivo">' +
      '<option value="">' + window.t('suc_select_placeholder', 'Selecciona') + '</option>' +
      tipos_bloqueo_php +
      '</select>' +
      '</div>' +
      '</div>' +
      '<div class="row mt-3">' +
      '<div class="col-12">' +
      '<label>' + window.t('suc_block_message_lbl', 'Mensaje para presentar en panel del cliente *') + '</label>' +
      '<textarea class="form-control" rows="5" id="mensaje_comentario" name="mensaje_comentario">' +
      window.t('suc_block_message_default',
        '¡Lo sentimos! Su acceso ha sido interrumpido por falta de pago. Favor de comunicarse al teléfono 33 3454 2877.'
      ) +
      '</textarea>' +
      '</div>' +
      '</div>'
    );

    $('#mensaje').append(
      '<div class="row mt-3">' +
      '<div class="col-12">' +
      '<label class="container_checkbox">' +
      window.t('suc_block_subclients_lbl', 'Bloquear también subclientes/proveedores') +
      '<input type="checkbox" id="bloquear_subclientes" name="bloquear_subclientes">' +
      '<span class="checkmark"></span>' +
      '</label>' +
      '</div>' +
      '</div>'
    );

    return;
  }

  if (accion == "desbloquear cliente") {
    setModal(
      'suc_confirm_unblock_title', 'Desbloquear cliente',
      'suc_confirm_unblock_text', '¿Desea desbloquear al cliente {name}?',
      "accionCliente('desbloquear'," + valor2 + ")"
    );

    $('#mensaje').append(
      '<div class="row mt-3">' +
      '<div class="col-12">' +
      '<label>' + window.t('suc_unblock_reason_lbl', 'Razón de desbloqueo *') + '</label>' +
      '<select class="form-control" id="opcion_motivo" name="opcion_motivo">' +
      '<option value="">' + window.t('suc_select_placeholder', 'Selecciona') + '</option>' +
      tipos_desbloqueo_php +
      '</select>' +
      '</div>' +
      '</div>'
    );

    return;
  }
}


// -----------------------------------------
// 2) Enviar credenciales (modal)
// -----------------------------------------
function enviarCredenciales(valor1, valor2) {
  // valor1 = correo, valor2 = id_datos_generales
  $('#titulo_mensaje_contraseña').text(window.t('suc_modal_resend_password_title', 'Reenviar contraseña'));

  var htmlMsg = window.t(
    'suc_modal_resend_password_text',
    '¿Deseas actualizar la contraseña al usuario <b>{email}</b>?'
  ).replace('{email}', window.escAttr(valor1 || ''));

  $('#mensaje_contraseña').html(htmlMsg);

  $('#password_cliente').val('');
  $('#btnEnviarPass').attr('onclick', 'actualizarContraseña()');
  $('#btnEnviarPass').attr('data-dismiss', 'modal');

  $('#idDatosGeneralesEditPass').val(valor2);
  $('#idCorreo').val(valor1);

  $('#enviarCredenciales').modal('show');
}


// -----------------------------------------
// 3) Acción cliente (AJAX status)
// -----------------------------------------
function accionCliente(accion, id, correo) {
  // correo no se usa aquí, pero lo dejamos por compatibilidad (sin default param para no romper)

  var opcion_motivo = $('#mensajeModal #opcion_motivo').val();
  var opcion_descripcion = $('#mensajeModal #opcion_motivo option:selected').text();
  var mensaje_comentario = $('#mensajeModal #mensaje_comentario').val();

  var bloquear_subclientes = ($('#mensajeModal #bloquear_subclientes').is(':checked')) ? 'SI' : 'NO';

  $.ajax({
    url: '<?php echo base_url('Cat_Cliente/status'); ?>',
    type: 'POST',
    data: {
      idCliente: id,
      accion: accion,
      opcion_motivo: opcion_motivo,
      mensaje_comentario: mensaje_comentario,
      opcion_descripcion: opcion_descripcion,
      bloquear_subclientes: bloquear_subclientes
    },
    beforeSend: function() {
      $('.loader').css('display', 'block');
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);

      // tu backend a veces regresa string JSON
      let data = res;
      if (typeof res === 'string') {
        try {
          data = JSON.parse(res);
        } catch (e) {
          data = null;
        }
      }

      if (data && Number(data.codigo) === 1) {
        $('#mensajeModal').modal('hide');
        if (typeof recargarTable === 'function') recargarTable();

        if (window.Swal) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: data.msg || window.t('suc_updated_ok', 'Updated successfully'),
            showConfirmButton: false,
            timer: 2500
          });
        } else {
          alert(data.msg || window.t('suc_updated_ok', 'Updated successfully'));
        }
      } else if (data && data.msg) {
        if (window.Swal) Swal.fire(window.t('suc_sw_error_title', 'Error'), data.msg, 'error');
        else alert(data.msg);
      }
    },
    error: function() {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      var msgErr = window.t('suc_sw_comm_error', 'Error de comunicación con el servidor.');
      if (window.Swal) Swal.fire(window.t('suc_sw_error_title', 'Error'), msgErr, 'error');
      else alert(msgErr);
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

        let data = res;
        if (typeof res === 'string') {
          try {
            data = JSON.parse(res);
          } catch (e) {
            data = null;
          }
        }
        // 👇 Traducción simple
        $('#id_cliente').append('<option value="">' + window.t('suc_select_placeholder', 'Selecciona') +
          '</option>');

        for (let i = 0; i < dato.length; i++) {
          $('#id_cliente').append(
            '<option value="' + dato[i]['id'] + '">' + dato[i]['nombre'] + '</option>'
          );
        }

        $('#nuevoAccesoClienteModal').modal('show');
      }
    }
  });
}

/* Crear accesos a usuarios cliente */
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
            title: window.t('suc_user_saved_ok', 'Usuario guardado correctamente'),
            showConfirmButton: false,
            timer: 2500
          });

          // OJO: aquí tenías un typo: formAccesoCliente¿
          $('#formAccesoCliente')[0].reset();

        } else {
          $("#nuevoAccesoClienteModal #msj_error")
            .css('display', 'block')
            .html(data.msg || window.t('suc_error_action', 'Error al realizar la acción'));
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
    url: '<?php echo base_url('Cat_Cliente/actualizarPass'); ?>',
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

      let data = res;
      if (typeof res === 'string') {
        try {
          data = JSON.parse(res);
        } catch (e) {
          data = null;
        }
      }

      if (data.codigo === 1) {
        recargarTable();

        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg || window.t('suc_updated_ok', 'Actualizado correctamente'),
          showConfirmButton: false,
          timer: 3000
        });

      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: window.t('suc_sw_error_title', 'Error'),
          text: data.msg || window.t('suc_error_action', 'Error al realizar la acción'),
          showConfirmButton: false,
          timer: 2500
        });
      }
    },
    error: function(err) {
      console.error('Error en la petición AJAX:', err.responseText);

      // opcional, si quieres mostrar algo al usuario:
      // Swal.fire(window.t('suc_sw_error_title','Error'), window.t('suc_sw_comm_error','Error de comunicación con el servidor.'), 'error');
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
      let data = res;
      if (typeof res === 'string') {
        try {
          data = JSON.parse(res);
        } catch (e) {
          data = null;
        }
      }
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