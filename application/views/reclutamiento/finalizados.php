<!-- Begin Page Content -->
<div class="container-fluid">
  <?php echo perms_js_flags([
    'FIN_REACTIVAR' => ['reclutamiento.reqs.reactivar', true],
    'FIN_VER_CV'    => ['reclutamiento.finalizadas.ver_cv', true],
  ])?>

  <?php i18n_js(['rec_fin_']); ?>

  <script>
    const P = window.PERM || {};
    const allow = f => (typeof f === 'undefined') ? true : !!f;
  </script>

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= t('rec_fin_page_title', 'Requisiciones Finalizadas'); ?></h1><br>

    <?php if (show_if_can('reclutamiento.reqs.reactivar', true)): ?>
      <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#reactivarRequisicionModal">
        <span class="icon text-white-50"><i class="fas fa-check-circle"></i></span>
        <span class="text"><?= t('rec_fin_btn_reactivate', 'Reactivar Requisición'); ?></span>
      </a>
    <?php endif; ?>

    <a href="#" class="btn btn-primary btn-icon-split hidden" id="btn_regresar" onclick="regresarListado()"
       style="display: none;">
      <span class="icon text-white-50">
        <i class="fas fa-arrow-left"></i>
      </span>
      <span class="text"><?= t('rec_fin_btn_back_list', 'Regresar al listado'); ?></span>
    </a>
  </div>

  <div>
    <p><?= t('rec_fin_intro', 'En este módulo se muestran las requisiciones de empleo que han sido finalizadas. Puedes consultar el estatus final de cada requisición, ver los comentarios finales y conocer qué aspirante aplicó para la vacante. Además, tienes la opción de reactivar una requisición si es necesario.'); ?></p>
  </div>

  <?php echo $modals; ?>
  <div class="loader" style="display: none;"></div>
  <input type="hidden" id="idAspirante">
  <input type="hidden" id="idRequisicion">
  <input type="hidden" id="idDoping">
  <input type="hidden" id="numVecinal">

  <div id="div_requisiciones" class="row">
    <div class="col-6">
      <label><?= t('rec_fin_select_req_label', 'Selecciona una requisición:'); ?> </label>
      <select class="form-control" name="opcion_requisicion" id="opcion_requisicion">
        <option value=""><?= t('rec_fin_option_all', 'Todas'); ?></option>

        <?php
        if ($reqs) {
          foreach ($reqs as $req) {?>
            <option value="<?php echo $req->id; ?>">
              <?php
              echo '#' . $req->id . ' ' . $req->nombre . ' - ' . $req->puesto . ' - '
                 . t('rec_fin_label_vacancies', 'Vacantes:') . ' ' . $req->numero_vacantes;
              ?>
            </option>
          <?php }
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
          <table id="tablaF" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- /.content-wrapper -->
<script>
$(document).ready(function() {
  var url = '<?php echo base_url('Reclutamiento/getAspirantesRequisicionesFinalizadas'); ?>';
  changeDataTable(url);
  $('#opcion_requisicion').change(function() {
    var id = $(this).val();
    if (id != '') {
      var baseurl = '<?php echo base_url('Reclutamiento/getAspirantesPorRequisicionesFinalizadas'); ?>';
      var url = baseurl + '?id=' + id;
      changeDataTable(url);
    } else {
      var url = '<?php echo base_url('Reclutamiento/getAspirantesRequisicionesFinalizadas'); ?>';
      changeDataTable(url);
    }
  })
  //inputmask
  $('.fecha').inputmask('dd/mm/yyyy', {
    'placeholder': 'dd/mm/yyyy'
  });
});

function changeDataTable(url) {

  // Traduce roles comunes si vienen como texto plano
  function trUsuarioRol(u) {
    if (!u) return u;
    if (u === 'Cliente') return t('rec_fin_role_client', 'Cliente');
    if (u === 'Reclutador') return t('rec_fin_role_recruiter', 'Reclutador');
    return u;
  }

  $('#tablaF').DataTable({
    "pageLength": 25,
    "order": [0, "desc"],
    "stateSave": true,
    "serverSide": false,
    "bDestroy": true,
    "ajax": url,
    "columns": [
      {
        title: t('rec_fin_dt_col_id', '#'),
        data: 'id',
        bSortable: false,
        "width": "3%",
        mRender: function (data, type, full) {
          if (data != null) return data;
          return t('rec_fin_dt_na', 'N/A');
        }
      },
      {
        title: t('rec_fin_dt_col_applicant', 'Aspirante'),
        data: 'aspirante',
        bSortable: false,
        "width": "15%",
        mRender: function (data, type, full) {
          if (data == null) {
            data = t('rec_fin_dt_no_applicants', 'Sin Aspirantes registrads');
          }
          return mostrarDato(data) + '<br><small><b>(' + trUsuarioRol(mostrarDato(full.usuario)) + ')</b></small>';
        }
      },
      {
        title: t('rec_fin_dt_col_branch_client', 'Sucursal/Cliente'),
        data: 'empresa',
        bSortable: false,
        "width": "15%",
        mRender: function (data, type, full) {
          return '#' + mostrarDato(full.id_requisicion) + ' ' + mostrarDato(data);
        }
      },
      {
        title: t('rec_fin_dt_col_position', 'Puesto'),
        data: 'puesto',
        bSortable: false,
        "width": "12%",
        mRender: function (data, type, full) {
          return mostrarDato(data);
        }
      },
      {
        title: t('rec_fin_dt_col_action', 'Accion'),
        data: 'id',
        bSortable: false,
        width: "8%",
        mRender: function (data, type, full) {

          if (!allow(P.FIN_VER_CV)) {
            return '<a href="javascript:void(0);" class="fa-tooltip gris icono_datatable" title="' +
              t('rec_fin_dt_no_permission', 'Sin permiso') +
              '"><i class="fas fa-eye"></i></a>';
          }

          if (full.cv) {
            return '<a href="<?= base_url('_docs/'); ?>' + full.cv +
              '" target="_blank" class="fa-tooltip icono_datatable" title="' +
              t('rec_fin_dt_view_cv', 'Ver CV') +
              '"><i class="fas fa-eye"></i></a>';
          }

          return '<a href="javascript:void(0);" class="fa-tooltip gris icono_datatable" title="' +
            t('rec_fin_dt_no_cv', 'Sin CV') +
            '"><i class="fas fa-eye"></i></a>';
        }
      },
      {
        title: t('rec_fin_dt_col_applicant_status', 'Estatus Aspirante'),
        data: 'status',
        bSortable: false,
        "width": "10%",
        mRender: function (data, type, full) {
          if (data == null) data = t('rec_fin_dt_no_status', 'Sin estatus registrado');
          return '<b>' + data + '</b>';
        }
      },
      {
        title: t('rec_fin_dt_col_order_status', 'Estatus de la Orden'),
        data: 'statusReq',
        bSortable: false,
        "width": "10%",
        mRender: function (data, type, full) {
          var estatus = (data == 3)
            ? t('rec_fin_dt_status_done', 'TERMINADA')
            : t('rec_fin_dt_status_canceled', 'CANCELADA');
          return '<b>' + mostrarDato(estatus) + '</b>';
        }
      },
      {
        title: t('rec_fin_dt_col_final_comment', 'Comentario Final.'),
        data: 'comentario_final',
        bSortable: false,
        "width": "17%",
        mRender: function (data, type, full) {
          return '<b>' + mostrarDato(data) + '</b>';
        }
      }
    ],

    fnDrawCallback: function (oSettings) {
      $('a[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
    },

    rowCallback: function (row, data) {
      $("a#editar_aspirante", row).bind('click', () => {
        $("#idAspirante").val(data.id);
        $(".nombreAspirante").text(data.aspirante);
        $('#req_asignada').val(data.id_requisicion);
        $('#nombre').val(data.nombre);
        $('#paterno').val(data.paterno);
        $('#materno').val(data.materno);
        $('#medio').val(data.medio_contacto);
        $('#telefono').val(data.telefono);
        $('#correo').val(data.correo);

        if (data.cv != null) {
          $('#cv_previo').html(
            '<small><b>(' + t('rec_fin_dt_prev_cv', 'CV previo:') + ' </b></small>' +
            '<a href="<?php echo base_url(); ?>_docs/' + data.cv + '" target="_blank">' + data.cv + '</a>)'
          );
        }
        $("#newModal").modal('show');
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

        $.ajax({
          url: '<?php echo base_url('Reclutamiento/getHistorialAspirante'); ?>',
          type: 'post',
          data: { 'id': data.id, 'tipo_id': 'bolsa' },
          success: function (res) {
            var salida = '<table class="table table-striped" style="font-size: 14px">';
            salida += '<tr style="background: gray;color:white;">';
            salida += '<th>' + t('rec_fin_dt_hist_date', 'Fecha') + '</th>';
            salida += '<th>' + t('rec_fin_dt_hist_status', 'Estatus') + '</th>';
            salida += '<th>' + t('rec_fin_dt_hist_desc', 'Comentario / Descripción / Fecha y lugar') + '</th>';
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
              salida += '<td colspan="3" class="text-center"><h5>' + t('rec_fin_dt_no_moves', 'Sin movimientos') + '</h5></td>';
              salida += "</tr>";
            }

            salida += "</table>";
            $('#div_historial_aspirante').html(salida);
            $("#historialModal").modal('show');
          }
        });
      });
    },

    "language": {
      "lengthMenu":   t('rec_fin_dt_lengthMenu',   'Mostrar _MENU_ registros por página'),
      "zeroRecords":  t('rec_fin_dt_zeroRecords',  'No se encontraron registros'),
      "info":         t('rec_fin_dt_info',         'Mostrando registros de _START_ a _END_ de un total de _TOTAL_ registros'),
      "infoEmpty":    t('rec_fin_dt_infoEmpty',    'No hay registros disponibles'),
      "infoFiltered": t('rec_fin_dt_infoFiltered', '(Filtrado de _MAX_ registros totales)'),
      "sSearch":      t('rec_fin_dt_search',       'Buscar:'),
      "oPaginate": {
        "sLast":     t('rec_fin_dt_pag_last',     'Última página'),
        "sFirst":    t('rec_fin_dt_pag_first',    'Primera'),
        "sNext":     t('rec_fin_dt_pag_next',     'Siguiente'),
        "sPrevious": t('rec_fin_dt_pag_prev',     'Anterior')
      }
    }
  });
}


function mostrarDato(valor) {
  if (valor === undefined || valor === null || valor === "") {
    return "No Disponible";
  }
  return valor;
}

function reactivarsRequisicion() {
  var datos = new FormData();
  datos.append('id', $("#reactivar_req").val());

  $.ajax({
    url: '<?php echo base_url('Reclutamiento/reactivarRequisicion'); ?>',
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
        $("#reactivarRequisicionModal").modal('hide')
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 2500
        })
        setTimeout(() => {
          location.reload()
        }, 2500);
      } else {
        $("#reactivarRequisicionModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}
</script>