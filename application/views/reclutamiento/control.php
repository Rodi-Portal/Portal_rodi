<!-- Begin Page Content -->
<div class="container-fluid">
  <?php echo perms_js_flags([
    'ASP_VER_INFO'           => ['reclutamiento.aspirantes.ver_info', true],
    'ASP_EDITAR'             => ['reclutamiento.aspirantes.editar', true],
    'ASP_ASIGNAR_REQ'        => ['reclutamiento.aspirantes.asignar_req', true],
    'ASP_REGISTRAR_MOV'      => ['reclutamiento.aspirantes.registrar_mov', true],
    'ASP_VER_HIST'           => ['reclutamiento.aspirantes.ver_historial', true],
    'ASP_VER_EMPLEOS'        => ['reclutamiento.aspirantes.ver_empleos', true],
    'ASP_CARGAR_DOCS'        => ['reclutamiento.aspirantes.cargar_docs', true],
    'ASP_ACTUALIZAR_DOCS'    => ['reclutamiento.aspirantes.actualizar_docs', true],
    'ASP_CARGAR_COMENTS'     => ['reclutamiento.aspirantes.cargar_coments', true],
    'ASP_BLOQUEAR'           => ['reclutamiento.aspirantes.bloquear', true],
    'ASP_ELIMINAR_ASP'       => ['reclutamiento.aspirantes.eliminar_aspirante', true],
    'ASP_COMENTARIOS'        => ['reclutamiento.aspirantes.comentarios_cliente', true],
    'ASP_CAMBIAR_STATUS_REQ' => ['reclutamiento.aspirantes.cambiar_status_req', true],
])?>

  <section class="content-header">
    <div class="row align-items-center">
      <div class="col-sm-12 col-md-6 col-lg-6">
        <h1 class="titulo_seccion">Requisiciones en progreso</h1>
      </div>

      <div class="col-sm-12 col-md-6 col-lg-6 d-flex justify-content-end">
        <?php if (show_if_can('reclutamiento.aspirantes.asignar_req', true)): ?>
        <button type="button" class="btn btn-primary btn-icon-split mr-2" id="btn_nuevo" onclick="openAddApplicant()">
          <span class="icon text-white-50"><i class="fas fa-user-plus"></i></span>
          <span class="text">Registrar aspirante a requisición</span>
        </button>
        <?php endif; ?>

        <?php if (show_if_can('reclutamiento.aspirantes.cambiar_status_req', true)): ?>
        <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal"
          data-target="#estatusRequisicionModal">
          <span class="icon text-white-50"><i class="fas fa-exchange-alt"></i></span>
          <span class="text">Cambiar estatus Requisición</span>
        </button>
        <?php endif; ?>

      </div>
    </div>
  </section>
  <br>
  <div>
    <p>Este módulo facilita la gestión de requisiciones de empleo en curso, permitiendo realizar acciones clave como
      cambiar su estatus, finalizar, cancelar y asignar aspirantes. Además, brinda herramientas para dar seguimiento al
      proceso de reclutamiento y compartirlo con el solicitante, registrando movimientos, enviando candidatos a
      socioeconómico, cargando CVs y dejando comentarios. El reclutador puede agregar aspirantes a la requisición,
      permitiendo que el solicitante vea los avances del proceso de manera ágil y organizada.</p>
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
      <label>Selecciona una Requisicion </label>
      <select class="form-control" name="opcion_requisicion" id="opcion_requisicion">
        <option value="">All</option>
        <?php
            if ($reqs) {
            foreach ($reqs as $req) {?>
        <option value="<?php echo $req->idReq; ?>">
          <?php echo '#' . $req->idReq . ' ' . $req->nombre_cliente . ' - ' . $req->puesto . ' - Vacantes: ' . $req->numero_vacantes; ?>
        </option>
        <?php
            header('Content-Type: text/html; charset=utf-8');}
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
          <table id="tabla" class="table table-bordered" width="100%" cellspacing="0">
          </table>
        </div>
      </div>
    </div>
  </div>


</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url('js/whatsapi.js'); ?>"></script>
<script>
//if (window.__aspirantes_booted) throw 'skip-dup'; window.__aspirantes_booted = true;
// estado global mínimo
window.dtTabla = window.dtTabla || null;
window.DT_MODE = window.DT_MODE || null; // 'progreso' | 'finalizadas'
window.P = window.P || window.PERM || {};

window.allow = window.allow || (f => (typeof f === 'undefined') ? true : !!f);

// borra el state guardado de DataTables para evitar arrastres entre modos
function clearDTStateFor(id) {
  try {
    // limpia keys típicas de stateSave
    Object.keys(localStorage).forEach(k => {
      if (k.indexOf('DataTables_') === 0 || k.indexOf('DT_state_' + id) === 0) {
        localStorage.removeItem(k);
      }
    });
  } catch (e) {}
}

// cambia url si el modo es el mismo; si cambia modo, destruye y vuelve a crear
function changeDataTable(url, mode) {
  const sameMode = (window.DT_MODE === mode);

  if ($.fn.DataTable.isDataTable('#tabla') && window.dtTabla && sameMode) {
    // mismo modo ⇒ solo cambia URL/recarga
    const current = window.dtTabla.ajax.url();
    if (current !== url) window.dtTabla.ajax.url(url).load();
    else window.dtTabla.ajax.reload(null, false);
    return;
  }

  // modo diferente ⇒ reconstruir con columnas del modo correcto
  if ($.fn.DataTable.isDataTable('#tabla') && window.dtTabla) {
    try {
      window.dtTabla.state && window.dtTabla.state.clear && window.dtTabla.state.clear();
    } catch (e) {}
    try {
      window.dtTabla.destroy(true);
    } catch (e) {}
  }
  $('#tabla').empty();
  clearDTStateFor('tabla');

  if (mode === 'progreso') {
    buildTableProgreso(url); // ⬅️ usa tus columnas de “En progreso”
  } else if (mode === 'finalizadas') {
    buildTableFinalizadas(url); // ⬅️ usa tus columnas de “Finalizadas” (defínela en esa vista)
  }
  window.DT_MODE = mode;
}

$(document).ready(function() {
  const URL_EN_PROGRESO = '<?php echo base_url('Reclutamiento/getAspirantesRequisiciones'); ?>';
  const URL_POR_REQ = '<?php echo base_url('Reclutamiento/getAspirantesPorRequisicion'); ?>';

  // Al entrar a "En progreso": fuerza modo y URL correctos
  changeDataTable(URL_EN_PROGRESO, 'progreso');

  // Filtro por requisición (mismo modo)
  $(document).off('change.asp', '#opcion_requisicion')
    .on('change.asp', '#opcion_requisicion', function() {
      const id = $(this).val();
      const url = id ? (URL_POR_REQ + '?id=' + id) : URL_EN_PROGRESO;
      changeDataTable(url, 'progreso');
    });
});

window.dtTabla = window.dtTabla ?? null;

function buildTableProgreso(url) {
  window.dtTabla = $('#tabla').DataTable({
    pageLength: 25,
    order: [0, "desc"],
    stateSave: true,
    serverSide: false,
    bDestroy: true,
    ajax: url,
    columns: [{
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
        title: 'Sucursal/Cliente',
        data: 'nombre_cliente',
        bSortable: false,
        "width": "15%",
        mRender: function(data, type, full) {
          return '#' + full.id_requisicion + ' ' + full.nombre_cliente;
        }
      },
      {
        title: 'Puesto',
        data: 'puesto',
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
          const norm = (v, fallback = '--') => {
            if (v === null || v === undefined) return fallback;
            if (typeof v === 'string') {
              const s = v.trim();
              return (s === '' || s.toLowerCase() === 'null' || s.toLowerCase() === 'undefined') ?
                fallback :
                s;
            }
            return String(v);
          };

          const tel = norm(full?.telefono, '--');
          const correo = norm(full?.correo, 'No registrado');
          const medio = norm(full?.medio_contacto, '--');

          return `<b>Teléfono: </b>${tel}<br><b>Correo: </b>${correo}<br><b>Medio: </b>${medio}`;
        }
      },

      {
        title: 'Acciones',
        data: 'idAsp',
        bSortable: false,
        "width": "10%",
        mRender: function (data, type, full) {

          // Botones individuales (se muestran sólo si el permiso lo permite)
          var cvLink = allow(P.ASP_CARGAR_DOCS)
            ? '<a href="javascript:void(0);" class="dropdown-item" onclick="mostrarFormularioCargaCV(' + full.idAsp + ')" data-toggle="tooltip" title="Cargar  documentos"><i class="fas fa-upload"></i> Cargar Documentos</a>'
            : '';

          var eliminarAspirante = allow(P.ASP_ELIMINAR_ASP)
            ? '<a href="javascript:void(0);" class="dropdown-item" onclick="eliminarAspirante(' + full.idAsp + ')" data-toggle="tooltip" title="Eliminar"><i class="fas fa-upload"></i>Eliminar  Match</a>'
            : '';

          var actualizarDocs = allow(P.ASP_ACTUALIZAR_DOCS)
            ? '<a href="javascript:void(0);" class="dropdown-item" onclick="mostrarFormularioActualizarDocs(' + full.idAsp + ')" data-toggle="tooltip" title="Actualizar Documentos"><i class="fas fa-eye"></i> Actualizar Documentos</a>'
            : '';

          var comentarios = allow(P.ASP_COMENTARIOS)
            ? '<a href="javascript:void(0)" class="dropdown-item" onclick="verHistorialBolsaTrabajo(' + full.id + ', \'' + full.aspirante + '\')"><i class="fas fa-user-tie"></i>Comentarios Cliente</a>'
            : '';

          var historial = allow(P.ASP_VER_HIST)
            ? '<a href="javascript:void(0)" id="ver_historial" class="dropdown-item" data-toggle="tooltip" title="Ver historial de movimientos"><i class="fas fa-history"></i> Ver historial de movimientos</a>'
            : '';

          var iniciar_socio = allow(P.ASP_CAMBIAR_STATUS_REQ)
            ? '<a href="#" id="iniciar_socio" class="dropdown-item" data-toggle="tooltip" title="Enviar al módulo de Preempleo para candidatos con o sin estudios previos a la contratación."><i class="fas fa-play-circle"></i>Enviar a Preempleo</a>'
            : '';

          // No tienes perm. dedicado para “Registro de ingreso” en este módulo; lo amarro a registrar_mov
          var ingreso = allow(P.ASP_REGISTRAR_MOV)
            ? '<a href="#" id="ingreso_empresa" class="dropdown-item" data-toggle="tooltip" title="Registro de datos de ingreso del candidato"><i class="fas fa-user-tie"></i> Registro de ingreso</a>'
            : '';

          // Acciones “core” que usan los IDs que ya bindeas (#editar_aspirante y #accion)
          var acciones = '';
          if (allow(P.ASP_EDITAR)) {
            acciones += '<a href="javascript:void(0)" id="editar_aspirante" class="dropdown-item" data-toggle="tooltip" title="Editar aspirante"><i class="fas fa-user-edit"></i> Editar aspirante</a>';
          }
          if (allow(P.ASP_REGISTRAR_MOV)) {
            acciones += '<a href="javascript:void(0)" id="accion" class="dropdown-item" data-toggle="tooltip" title="Registrar paso en el proceso del aspirante"><i class="fas fa-plus-circle"></i> Registrar movimientos</a>';
          }

          // Lógica original de status, pero respetando permisos
          if (full.status_final == 'FINALIZADO' || full.status_final == 'COMPLETADO') {
            if (full.idCandidato != null && full.idCandidato != '') {
              acciones = '<b>ESE finalizado</b>';
            } else {
              acciones = (allow(P.ASP_CAMBIAR_STATUS_REQ) ? iniciar_socio : '')
                      + (allow(P.ASP_REGISTRAR_MOV) ? ingreso : '')
                      + (allow(P.ASP_EDITAR) ? '<a href="javascript:void(0)" id="editar_aspirante" class="dropdown-item" data-toggle="tooltip" title="Editar aspirante"><i class="fas fa-user-edit"></i> Editar aspirante</a>' : '')
                      + (allow(P.ASP_REGISTRAR_MOV) ? '<a href="javascript:void(0)" id="accion" class="dropdown-item" data-toggle="tooltip" title="Registrar paso en el proceso del aspirante"><i class="fas fa-plus-circle"></i> Registrar movimientos</a>' : '');
            }
          } else {
            if (full.status_final != 'CANCELADO') {
              acciones = (allow(P.ASP_CAMBIAR_STATUS_REQ) ? iniciar_socio : '')
                      + (allow(P.ASP_REGISTRAR_MOV) ? ingreso : '')
                      + (allow(P.ASP_EDITAR) ? '<a href="javascript:void(0)" id="editar_aspirante" class="dropdown-item" data-toggle="tooltip" title="Editar aspirante"><i class="fas fa-user-edit"></i> Editar aspirante</a>' : '')
                      + (allow(P.ASP_REGISTRAR_MOV) ? '<a href="javascript:void(0)" id="accion" class="dropdown-item" data-toggle="tooltip" title="Registrar paso en el proceso del aspirante"><i class="fas fa-plus-circle"></i> Registrar movimientos</a>' : '');
            }
          }

          // Arma el menú final
          var menu = acciones + historial + comentarios + cvLink + actualizarDocs + eliminarAspirante;

          // Si no hay nada que mostrar, no pintes el botón Acciones
          if (!menu || !menu.trim()) return '';

          return '<div class="btn-group">'
              +   '<button type="button" class="btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones</button>'
              +   '<div class="dropdown-menu">'
              +      menu
              +   '</div>'
              + '</div>';
        }
      },

      {
        title: 'Estatus actual',
        data: null, // Usamos `null` para poder controlar manualmente qué se muestra
        bSortable: false,
        width: "10%",
        render: function(data, type, row) {
          // console.log("🚀 ~ changeDataTable ~ row:", row)
          if (row.status_final !== null && row.status_final !== "") {
            return row.status_final;
          } else if (row.status != null && row.status != "") {
            return row.status;
          } else {
            return "Registrado";
          }
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
          'background-color': '#f8d7da',
          'color': '#721c24',
          'font-weight': 'bold'
        });
      }
      if (data.status_final == 'BLOQUEADO') {
        $('td:eq(6)', row).css({
          'background-color': '#f5c6cb',
          'color': '#721c24',
          'font-weight': 'bold'
        });
      }
      if (data.status_final == 'FINALIZADO') {
        $('td:eq(6)', row).css({
          'background-color': '#d4edda',
          'color': '#155724',
          'font-weight': 'bold'
        });
      }
      if (data.status_final == 'COMPLETADO') {
        $('td:eq(6)', row).css({
          'background-color': '#c3e6cb',
          'color': '#155724',
          'font-weight': 'bold'
        });
      }
      if (!data.status_final || data.status_final.trim() === "") {
        $('td:eq(6)', row).css({
          'background-color': '#d1ecf1',
          'color': '#0c5460',
          'font-weight': 'bold'
        });
      }



      $("a#editar_aspirante", row).bind('click', () => {
        $("#idAspirante").val(data.idAsp);
        $("#idBolsa").val(data.id_bolsa_trabajo);

        var nombre = data.aspirante.split(' ');

        $('#req_asignada').val(data.id_req).trigger('change'); // Reiniciar Select2
        $('#nombre').val(nombre[0]);
        $('#paterno').val(nombre[1]);
        $('#materno').val(nombre.slice(2).join(' '));
        $('#domicilio').val(data.domicilio);
        $('#area_interes').val(data.area_interes);
        $('#medio').val(data.medio_contacto);
        $('#telefono1').val(data.telefono);
        $('#correo1').val(data.correo);

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
        $('#semaforo').val(data.semaforo);
        $('#estatus_aspirante').val(data.status_aspirante);
        $('#semaforo').val(data.semaforo);

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
            salida += '<th>Eliminar Movimiento</th>';
            salida += '</tr>';
            if (res != 0) {
              var dato = JSON.parse(res);
              for (var i = 0; i < dato.length; i++) {
                var aux = dato[i]['creacion'].split(' ');
                var f = aux[0].split('-');
                var fecha = f[2] + '/' + f[1] + '/' + f[0];
                salida += "<tr id='fila_" + dato[i]['id'] + "'>";
                salida += '<td>' + fecha + '</td>';
                salida += '<td>' + dato[i]['accion'] + '</td>';
                salida += '<td>' + dato[i]['descripcion'] + '</td>';
                salida +=
                  '<td><i class="fas fa-trash-alt text-danger" style="cursor:pointer;" onclick="eliminarRegistro(' +
                  dato[i]['id'] + ')"></i></td>';
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

      $('a#iniciar_socio', row).off('click').bind('click', () => {
        // --- BLINDAJE INICIAL: limpiar estado mínimo antes de rellenar ---
        const $modal = $('#registroCandidatoModal');

        // (a) Corrige ID duplicado curp_registro (warning que te sale en consola)
        const $dups = $modal.find('#curp_registro');
        if ($dups.length > 1) {
          $($dups[1]).attr({
            id: 'curp_check_registro',
            name: 'curp_check_registro'
          });
        }

        // (b) Reinicia #puesto SIN perder funcionalidad (vacía y deja base)
        if ($.fn.select2 && $('#puesto').hasClass('select2-hidden-accessible')) {
          $('#puesto').select2('destroy'); // evita múltiples instancias
        }
        $('#puesto').empty()
          .append('<option value="0" selected>N/A</option>')
          .append('<option value="otro">Otro</option>');
        $('#puesto_otro').val('').hide();

        // (c) Limpia contenedores que vas a volver a llenar
        $('#previos').empty();
        $('#detalles_previo').empty();
        $('#div_docs_extras').empty();

        // (d) (Opcional) resetea validaciones visibles y loader
        $('#msj_error').addClass('hidden').empty();
        $('.loader').hide();

        // --- TU LÓGICA TAL CUAL ---
        var nombreCompleto = data.aspirante.trim();

        // Dividir el nombre completo en partes
        var partesNombre = nombreCompleto.split(" ");

        var nombreAspirante = partesNombre[0]; // Primer nombre
        var apellidoPaterno = partesNombre.length > 1 ? partesNombre[1] : ""; // Primer apellido
        var apellidoMaterno = partesNombre.length > 2 ? partesNombre[2] : "";
        var id_cliente = data.id_cliente;
        let id_position = 0;

        $("#id_cliente_hidden").val(data.id_cliente);
        $("#clave").val(data.clave);
        $("#cliente").val(data.nombre_cliente);
        $("#idAspiranteReq").val(data.id);
        $("#idRequisicion").val(data.id_requisicion);
        $("#idBolsaTrabajo").val(data.id_bolsa_trabajo);
        $('#nombre_registro').val(nombreAspirante)
        $('#paterno_registro').val(apellidoPaterno)
        $('#materno_registro').val(apellidoMaterno)
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

                // 🔒 IMPORTANTE: asegurar base limpia ANTES de append (por si otro flujo lo tocó)
                if ($.fn.select2 && $('#puesto').hasClass('select2-hidden-accessible')) {
                  $('#puesto').select2('destroy');
                }
                // Conserva N/A y Otro que dejamos al inicio
                // Agrega "Selecciona" una sola vez
                $('#puesto').append('<option value="">Selecciona</option>');

                for (let i = 0; i < data.length; i++) {
                  $('#puesto').append('<option value="' + data[i]['id'] + '">' + data[i]['nombre'] +
                    '</option>');
                }

                // Quita opciones duplicadas (por si algo previo dejó residuos)
                const seen = new Set();
                $('#puesto option').each(function() {
                  const k = this.value + '|' + (this.textContent || '');
                  if (seen.has(k)) $(this).remove();
                  else seen.add(k);
                });

                // Inicializa select2 una sola vez y dentro del modal
                $('#puesto').select2({
                  placeholder: 'Selecciona una opción',
                  allowClear: true,
                  width: '100%',
                  dropdownParent: $('#registroCandidatoModal')
                });

              } else {
                $('#puesto').append('<option value="">No hay puestos registrados</option>');
              }
            }
          });
        }, 200);

        setTimeout(function() {
          $('#puesto').val(id_position).trigger('change');
          $('.loader').fadeOut();
        }, 250);
        $('#opcion_registro').val('2').trigger('change');
        // Muestra el modal
        $('#registroCandidatoModal').modal('show');

        // 🔁 LIMPIEZA AL CERRAR (para siguiente apertura igualita)
        $('#registroCandidatoModal').one('hidden.bs.modal', function() {
          // deja el select tal cual base y sin select2
          if ($.fn.select2 && $('#puesto').hasClass('select2-hidden-accessible')) {
            $('#puesto').select2('destroy');
          }
          $('#puesto').empty()
            .append('<option value="0" selected>N/A</option>')
            .append('<option value="otro">Otro</option>');
          $('#puesto_otro').val('').hide();

          // limpia contenedores y estados
          $('#previos, #detalles_previo, #div_docs_extras').empty();
          $('#pais_registro, #proyecto_registro, .valor_dinamico').prop('disabled', true).val('');
          $('#msj_error').addClass('hidden').empty();
          $('.loader').hide();
        });
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
      "info": "Mostrando registros de _START_ a _END_ de un total de _TOTAL_ registros",
      "infoEmpty": "No hay registros disponibles",
      "infoFiltered": "(Filtrado de _MAX_ registros totales)",
      "sSearch": "Buscar:",
      "oPaginate": {
        "sLast": "Última página",
        "sFirst": "Primera",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      }
    }
  });

}; // <-- cierra función



if (typeof baseDocs === 'undefined') {
  var baseDocs = <?php echo json_encode(VERASPIRANTESDOCS); ?>;
}

function abreviarNombreArchivo(nombre, maxLen = 20) {
  if (!nombre || nombre.length <= maxLen) return nombre;
  const dot = nombre.lastIndexOf('.');
  const ext = (dot > -1 ? nombre.slice(dot) : '');
  const base = (dot > -1 ? nombre.slice(0, dot) : nombre);
  if (base.length + ext.length <= maxLen) return nombre;
  const keep = maxLen - ext.length - 3; // por '...'
  const left = Math.ceil(keep * 0.6);
  const right = keep - left;
  return base.slice(0, left) + '...' + base.slice(base.length - right) + ext;
}

function mostrarFormularioActualizarDocs(id) {
  $('#id_aspirante').val(id);
  const $tbody = $('#tablaDocsModal tbody');

  $tbody.html('<tr><td colspan="5" class="text-center">Cargando…</td></tr>');

  $.ajax({
    url: '<?php echo site_url('Documentos_Aspirantes/lista/') ?>' + id,
    type: 'GET',
    dataType: 'json',
    success: function(docs) {
      if (!Array.isArray(docs) || !docs.length) {
        $tbody.html('<tr><td colspan="5" class="text-center text-muted">Sin documentos</td></tr>');
        $('#modalActualizarArchivos').modal('show');
        return;
      }

      let filas = '';
      docs.forEach(function(d) {
        const urlVer = '<?php echo site_url('Archivo/ver_aspirante/') ?>' + d.id;
        const urlDown = '<?php echo site_url('Archivo/descargar_aspirante/') ?>' + d.id;
        const textoLink = abreviarNombreArchivo(d.nombre_archivo, 20);

        filas += `
          <tr>
            <td>${d.nombre_personalizado}</td>
            <td>
              <a href="${urlVer}" target="_blank" rel="noopener" title="${d.nombre_archivo}">
                ${textoLink}
              </a>
              <a href="${urlDown}" class="ml-2" title="Descargar" data-toggle="tooltip">
                <i class="fas fa-download"></i>
              </a>
            </td>
            <td>${d.fecha_subida}</td>
            <td>
              <div class="form-check form-switch">
                <input class="form-check-input tipo-vista-switch"
                       type="checkbox"
                       data-id="${d.id}"
                       ${Number(d.tipo_vista) === 1 ? 'checked' : ''}>
              </div>
            </td>
            <td>
              <button class="btn btn-sm btn-info"
                      data-toggle="tooltip" title="Reemplazar archivo"
                      onclick="abrirModalReemplazo(${d.id}, '${d.nombre_personalizado.replace(/'/g,'&#39;')}')">
                <i class="fas fa-sync-alt"></i>
              </button>
              <button class="btn btn-sm btn-danger"
                      data-toggle="tooltip" title="Eliminar archivo"
                      onclick="eliminarArchivo(${d.id})">
                <i class="fas fa-trash-alt"></i>
              </button>
            </td>
          </tr>`;
      });

      $tbody.html(filas);

      // Tooltips BS4
      $('[data-toggle="tooltip"]').tooltip();

      // Switch de tipo_vista
      $('.tipo-vista-switch').off('change').on('change', function() {
        const id = $(this).data('id');
        const tipo_vista = $(this).is(':checked') ? 1 : 0;

        $.ajax({
          url: '<?php echo site_url('Documentos_Aspirantes/actualizar_tipo_vista') ?>',
          type: 'POST',
          data: {
            id: id,
            tipo_vista: tipo_vista
          },
          dataType: 'json',
          success: function(resp) {
            if (resp && resp.ok) {
              Swal.fire({
                icon: 'success',
                title: 'Actualizado',
                text: 'Vista actualizada correctamente',
                timer: 1200,
                showConfirmButton: false
              });
            } else {
              Swal.fire('Error', (resp && resp.message) ? resp.message :
                'No se pudo actualizar la vista.', 'error');
            }
          },
          error: function() {
            Swal.fire('Error', 'No se pudo actualizar la vista.', 'error');
          }
        });
      });

      $('#modalActualizarArchivos').modal('show');
    },
    error: function() {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No se pudieron cargar los documentos'
      });
      $('#modalActualizarArchivos').modal('hide');
    }
  });
}

function eliminarAspirante(idAsp) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: "Vas a eliminar este aspirante",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      // Segunda advertencia
      Swal.fire({
        title: 'Advertencia',
        text: 'El aspirante desaparecerá de este listado y el cliente o sucursal no podrá verlo más',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar'
      }).then((result2) => {
        if (result2.isConfirmed) {
          // Llamada AJAX al backend
          $.ajax({
            url: '<?php echo base_url("Reclutamiento/eliminarAspirante") ?>',
            type: 'POST',
            data: {
              id: idAsp
            },
            success: function(response) {
              Swal.fire({
                icon: 'success',
                title: 'Eliminado',
                text: 'El aspirante fue eliminado correctamente'
              });

              if (dtTabla && $.fn.DataTable.isDataTable('#tabla')) {
                dtTabla.ajax.reload(null, false); // ← recarga SIN perder paginación
              }
            },
            error: function(xhr, status, error) {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo eliminar el aspirante. Intenta de nuevo.'
              });
            }
          });
        }
      });
    }
  });
}



function eliminarArchivo(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: 'Esta acción eliminará el archivo permanentemente.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then(result => {
    if (result.isConfirmed) {
      $.ajax({
        url: `<?php echo base_url('Documentos_Aspirantes/eliminar') ?>`, // Ajusta la ruta si es diferente
        type: 'POST',
        data: {
          id
        },
        dataType: 'json',
        success: resp => {
          if (resp.ok) {
            Swal.fire({
              icon: 'success',
              title: 'Eliminado',
              text: resp.message,
              timer: 1500,
              showConfirmButton: false
            });

            // Recarga tabla si aplica
            mostrarFormularioActualizarDocs($('#id_aspirante').val());
          } else {
            Swal.fire('Error', resp.message, 'error');
          }
        },
        error: () => {
          Swal.fire('Error', 'No se pudo eliminar el archivo.', 'error');
        }
      });
    }
  });
}

function abrirModalReemplazo(idDoc, nombreActual) {
  $('#id_doc').val(idDoc);
  $('#nuevo_nombre').val(nombreActual);
  $('#modalReemplazo').modal('show');
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
  datos.append('correo', $("#correo1").val());
  datos.append('telefono', $("#telefono1").val());
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

      var data = JSON.parse(res);
      if (data.codigo === 1) {
        $("#nuevoAspiranteModal").modal('hide')
        recargarTable()
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




function guardarAccion() {
  var datos = new FormData();
  datos.append('otra_accion', $("#otra_accion").val());
  datos.append('accion', $("#accion_aspirante").val());
  datos.append('comentario', $("#accion_comentario").val());
  datos.append("id_requisicion", $('#idRequisicion').val());
  datos.append("id_aspirante", $('#idAspirante').val());
  datos.append('semaforo', $("#semaforo").val());
  datos.append("estatus_aspirante", $('#estatus_aspirante').val());
  datos.append("estatus_proceso", $('#estatus_proceso').val());

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
          timer: 3000
        })
        //console.log("🚀 ~ guardarAccion ~ data.msg:", data.msg)
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

      let data;
      try {
        data = JSON.parse(res);
      } catch (e) {
        Swal.fire({
          icon: 'error',
          title: 'Error en el servidor',
          html: "<b>Respuesta inesperada del servidor:</b><br><pre style='text-align:left'>" + res + "</pre>",
          width: '50em'
        });
        console.error("Respuesta AJAX no es JSON:", res);
        return;
      }

      if (data.codigo === 1) {
        $("#estatusRequisicionModal").modal('hide')
        recargarTable();
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 2500
        });
      } else if (data.codigo === 0 && data.faltantes) {
        Swal.fire({
          icon: 'error',
          title: data.msg,
          html: '<ul style="text-align:left">' + data.faltantes.map(f => `<li>${f}</li>`).join('') + '</ul>',
          confirmButtonText: 'Cerrar'
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        });
      }
    }
  });
}


function registrarCandidato() {
  var datos = new FormData();

  datos.append('nombre', $("#nombre_registro").val());
  datos.append('paterno', $("#paterno_registro").val());
  datos.append('materno', $("#materno_registro").val());
  datos.append('celular', $("#celular_registro").val());
  datos.append('subcliente', $("#subcliente").val());
  datos.append('opcion', $('#opcion_registro').val());
  datos.append('puesto', $('#puesto').val());
  datos.append('puesto_otro', $('#puesto_otro').val());
  datos.append('pais', $("#pais").val());
  datos.append('region', $("#region").val());

  datos.append('previo', $("#previos").val());
  datos.append('proyecto', $("#proyecto_registro").val());

  datos.append('examen', $("#examen_registro").val());
  datos.append('medico', $("#examen_medico").val());

  datos.append('id_cliente', $('#id_cliente_hidden').val());
  datos.append('clave', $("#clave").val());
  datos.append('cliente', $("#cliente").val());
  datos.append('idAspiranteReq', $("#idAspiranteReq").val());
  datos.append('psicometrico', $("#examen_psicometrico").val());
  datos.append('correo', $("#correo_registro").val());
  datos.append('centro_costo', 'NA');
  datos.append('curp', $('#curp_registro').val());
  datos.append('nss', $('#nss_registro').val());
  datos.append('usuario', 1);
  datos.append('id_requisicion', $("#idRequisicion").val());
  datos.append('id_bolsa_trabajo', $("#idBolsaTrabajo").val());

  $.ajax({
    url: '<?php echo base_url('Client/registrar'); ?>',
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
        recargarTable();
        $("#registroCandidatoModal").modal('hide');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 3500
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        });
      }

    },
    error: function(xhr, status, error) {
      console.error("Error en la solicitud AJAX:", error);
      Swal.fire({
        icon: 'error',
        title: 'Error en la solicitud AJAX',
        text: 'Hubo un problema al comunicarse con el servidor',
        confirmButtonText: 'Cerrar'
      });
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

function eliminarRegistro(id) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: "¡Esta acción no se puede deshacer!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, continuar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      // Segunda confirmación
      Swal.fire({
        title: '¿Realmente deseas eliminar el registro?',
        text: "Esta acción es definitiva.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result2) => {
        if (result2.isConfirmed) {
          // Llamada AJAX al controlador
          $.ajax({
            url: '<?php echo base_url('Reclutamiento/eliminarRegistro'); ?>',
            type: 'POST',
            data: {
              id: id
            },
            success: function(response) {
              try {
                var res = JSON.parse(response);

                if (res.status) {
                  Swal.fire('Eliminado', res.mensaje, 'success');

                  // Elimina la fila del DOM si tienes una estructura tipo: <tr id="fila_ID">
                  $("#fila_" + id).remove();

                } else {
                  Swal.fire('Atención', res.mensaje, 'warning');
                }

              } catch (e) {
                Swal.fire('Error', 'Respuesta inesperada del servidor.', 'error');
                console.error('Error al parsear respuesta:', e, response);
              }
            },
            error: function(xhr, status, error) {
              Swal.fire('Error', 'Ocurrió un error al eliminar.', 'error');
              console.error('Error AJAX:', status, error);
            }
          });
        }
      });
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

        $("#ingresoCandidatoModal").modal('hide');

        recargarTable()
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