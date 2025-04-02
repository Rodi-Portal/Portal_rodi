<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sucursal: <small><?php echo $cliente; ?></small></h1><br>


    <a href="#" class="btn btn-primary btn-icon-split" id="btn_nuevo" onclick="modalRegistrarCandidato()">
      <span class="icon text-white-50">
        <i class="fas fa-user-plus"></i>
      </span>
      <span class="text">Registrar candidato</span>
    </a>

    <a href="#" class="btn btn-primary btn-icon-split hidden" id="btn_regresar" onclick="regresarListado()"
      style="display: none;">
      <span class="icon text-white-50">
        <i class="fas fa-arrow-left"></i>
      </span>
      <span class="text">Regresar al listado</span>
    </a>

  </div>
  <p>
    En este módulo se presenta un listado de los posibles empleados asociados a una sucursal, área o departamento
    específicos. Estos candidatos aún se encuentran en periodo de exámenes y pruebas. Una vez que hayan concluido
    satisfactoriamente dicho proceso, podrás proceder a contratarlos y enviarlos al módulo de empleados para su gestión.
  </p>

  <?php echo $modals;
  echo $mdl_candidato; ?>
  <div class="top-loader" style="display: none;">
    <h3 class="text-center">Actualizando listado, por favor espere...</h3>
  </div>
  <div class="loader" style="display: none;"></div>
  <input type="hidden" id="idCandidato">
  <input type="hidden" id="idSeccion">
  <input type="hidden" id="idCliente">
  <input type="hidden" id="idDoping">
  <input type="hidden" class="prefijo">
  <input type="hidden" id="idFinalizado">
  <input type="hidden" id="idVecinal">
  <input type="hidden" id="numVecinal">
  <input type="hidden" id="referenciaNumero">
  <input type="hidden" id="idRef">
  <input type="hidden" id="idFamiliar">
  <input type="hidden" id="tokenForm">


  <div id="listado">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-sm-12 col-md-4 col-lg-4 m-auto">
            <select class="form-control" name="filtroListado" id="filtroListado">
              <option value="">Selecciona un filtro para el listado de candidatos</option>
              <option value="1">Candidatos en enviados a RODI</option>
              <option value="2" selected>Candidatos Registrados Internamente</option>
            </select>
          </div>
        </div>
        <div class="table-responsive">
          <table id="tablaInternos" class="table table-hover table-bordered" width="100%" cellspacing="0"></table>
          <table id="tablaExternos" class="table table-hover table-bordered" width="100%" cellspacing="0"
            style="display: none;"></table>


          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- <div id="listadoFinalizados" style="display: none;">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary"></h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="tablaFinalizados" class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">
					</table>
				</div>
			</div>
		</div>
	</div> -->

  <section class="content" id="formulario" style="display: none;">
    <div class="row" id="rowLaboralExtra"></div>
    <div class="row" id="rowHistorialLaboral"></div>
  </section>

</div>

<!-- /.content-wrapper -->

<!-- Funciones para guardar secciones -->
<script src="<?php echo base_url(); ?>js/analista/request.js"></script>


<script>
var id = '<?php echo $this->uri->segment(3) ?>';
var nombre_cliente = '<?php echo $cliente; ?>';
var id_cliente = id;
//var url = '< ?php echo site_url("cliente_general/getEmpleadosInternos/") ?>' + id;
var url = '<?php echo API_URL ?>candidato-sync/' + id;
var psico = '<?php echo base_url(); ?>_psicometria/';
var beca_url = '<?php echo base_url(); ?>_beca/';
let url_form = '<?php echo base_url() . "Form/external?fid="; ?>';
//var parentescos_php ='< ?php foreach($parentescos as $p){ echo '<option value="'.$p->id.'">'.$p->nombre.'</option>';} ?>';
var civiles_php =
  '<?php foreach ($civiles as $c) {echo '<option value="' . $c->nombre . '">' . $c->nombre . '</option>';}?>';
//var escolaridades_php ='< ?php foreach($escolaridades as $e){ echo '<option value="'.$e->id.'">'.$e->nombre.'</option>';} ?>';
var extras = [];

function modalRegistrarCandidato() {
  let id_cliente = id;
  $('#registroCandidatoModal').modal('show');

  $.ajax({
    async: false,
    url: '<?php echo base_url('Cat_Puestos/getAllPositions'); ?>',
    type: 'GET',
    data: {

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
          $('#puesto').append('<option value="">Selecciona</option>');
          for (let i = 0; i < data.length; i++) {
            $('#puesto').append('<option value="' + data[i]['id'] + '">' + data[i]['nombre'] +
              '</option>');
          }

        } else {
          $('#puesto').append('<option value="">No hay puestos registrados</option>');
        }
      }
    });
  }, 200);
  setTimeout(function() {
    $('#puesto')('val', id_position)
    $('.loader').fadeOut();
  }, 250);


}

function registrarCandidato() {
  var datos = new FormData();



  datos.append('nombre', $("#nombre_registro").val());
  datos.append('paterno', $("#paterno_registro").val());
  datos.append('materno', $("#materno_registro").val());
  datos.append('celular', $("#celular_registro").val());
  datos.append('subcliente', $("#subcliente").val());
  datos.append('opcion', $('#opcion_registro').val());
  //datos.append('puesto', $('#puesto').('val'));
  datos.append('pais', $("#pais").val());
  datos.append('region', $("#region").val());

  datos.append('previo', $("#previos").val());
  datos.append('proyecto', $("#proyecto_registro").val());
  datos.append('id_cliente_hidden', id_cliente);
  datos.append('examen', $("#examen_registro").val());
  datos.append('medico', $("#examen_medico").val());


  datos.append('clave', $("#clave").val());
  datos.append('cliente', nombre_cliente);
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

        $("#registroCandidatoModal").modal('hide');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 3500
        });
        window.location.reload();
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






$(document).ready(function() {
  var urlInternos = '<?php echo base_url("Cliente_General/getEmpleadosInternos/") ?>' + id;
  var urlExternos = '<?php echo API_URL ?>candidato-sync/' + id;
  //inputmask
  $('.tipo_fecha').inputmask('dd/mm/yyyy', {
    'placeholder': 'dd/mm/yyyy'
  });
  $('#fecha_ine').inputmask('yyyy', {
    'placeholder': 'yyyy'
  });
  // Smooth scrolling using jQuery easing
  $(document).on('click', 'a.ripple', function(e) {
    var $anchor = $(this);
    $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
    }, 1000, 'easeInOutExpo');
    e.preventDefault();
  });
  var msj = localStorage.getItem("success");
  if (msj == 1) {
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Se ha actualizado correctamente',
      showConfirmButton: false,
      timer: 2500
    })
    localStorage.removeItem("success");
  }
  //
  loadInternos(urlInternos);

  $("#filtroListado").change(function() {
    var opcion = $(this).val();

    if (opcion == 1) {
      // Mostrar tabla de candidatos externos
      $('#tablaInternos').hide();
      $('#tablaExternos').show();
      changeDatatable(url);
    } else {
      // Mostrar tabla de candidatos internos
      $('#tablaExternos').hide();
      $('#tablaInternos').show();
      loadInternos(urlInternos);
    }
  });

  $("#subcliente").change(function() {
    var subcliente = $(this).val();
    if (subcliente != "") {
      $('#proceso').prop('disabled', false);
      $('#proceso').empty();
      $('#proceso').append($("<option selected></option>").attr("value", 1).text("ESE Español"));
      $('#antidoping').val('');
      $("#examen").prop('disabled', true);
      $('#examen').val('');
    } else {
      $('#proceso').empty();
      $('#proceso').append($("<option selected></option>").attr("value", "").text("Selecciona"));
      $('#antidoping').val('');
      $('#examen').val('');
      $('#proceso').prop('disabled', true);
      $("#examen").prop('disabled', true);
    }
  });
  $('#antidoping').change(function() {
    var opcion = $(this).val();
    var id_subcliente = $("#subcliente").val();
    var id_cliente = '<?php echo $this->uri->segment(3) ?>';
    subcliente = (id_subcliente == '') ? NULL : id_subcliente;
    if (opcion == 1) {
      $("#examen").prop('disabled', false);
      $.ajax({
        url: '<?php echo base_url('Doping/getPaqueteSubcliente'); ?>',
        method: 'POST',
        data: {
          'id_subcliente': subcliente,
          'id_cliente': id_cliente,
          'id_proyecto': 0
        },
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          if (res != "") {
            $('#examen').val(res);
            $("#examen").prop('disabled', false);
            $("#examen").addClass('obligado');
          } else {
            $('#examen').val('');
            $("#examen").prop('disabled', false);
            $("#examen").addClass('obligado');
          }
        }
      });
    } else {
      $("#examen").val('');
      $("#examen").prop('disabled', true);
    }
  })
  $("#previos").change(function() {
    var previo = $(this).val();
    if (previo != 0) {
      //$('.div_check').css('display','none');
      //$('.div_info_check').css('display','none');
      $.ajax({
        url: '<?php echo base_url('Candidato_Seccion/getDetallesProyectoPrevio'); ?>',
        method: 'POST',
        data: {
          'id_previo': previo
        },
        success: function(res) {
          $('#detalles_previo').empty();
          $('#detalles_previo').html(res);
        }
      });
      //TODO: Automatizar el valor dinamico de los examenes doping ligados al proceso
      if (id == 178 || id == 201) {
        $.ajax({
          url: '<?php echo base_url('Doping/getExamenDopingByProceso'); ?>',
          method: 'POST',
          data: {
            'id_previo': previo
          },
          async: false,
          success: function(res) {
            $('#examen_registro').empty();
            $('#examen_registro').html(res);
          }
        });
      }
      //TODO: Automatizar el valor dinamico de los examenes doping ligados al cliente
      if (id == 60 || id == 188 || id == 209 || id == 225 || id == 226 || id == 254 || id ==
        255 || id == 257) {
        $.ajax({
          url: '<?php echo base_url('Doping/getExamenDopingByCliente'); ?>',
          method: 'POST',
          data: {
            'id_cliente': id
          },
          async: false,
          success: function(res) {
            $('#examen_registro').empty();
            $('#examen_registro').html(res);
          }
        });
      }
      //* Checa en la tabla cliente_control si el cliente tiene predefinido examenes u otros valores
      $.ajax({
        url: '<?php echo base_url('Cliente/getControlesById'); ?>',
        method: 'POST',
        data: {
          'id_cliente': id
        },
        async: false,
        success: function(res) {
          if (res != null) {
            let data = JSON.parse(res);
            if (data !== null && Object.keys(data).length !== 0) {
              if (data.psicometria == 1) {
                $('#examen_psicometrico').val(1)
              }
            }
          }
        }
      });
    } else {
      //$('.div_check').css('display','flex');
      //$('.div_info_check').css('display','block');
      $('#detalles_previo').empty();
    }
  });
  $("#estado").change(function() {
    var id_estado = $(this).val();
    if (id_estado != "") {
      $.ajax({
        url: '<?php echo base_url('Funciones/getMunicipios'); ?>',
        method: 'POST',
        data: {
          'id_estado': id_estado
        },
        dataType: "text",
        success: function(res) {
          $('#municipio').prop('disabled', false);
          $('#municipio').html(res);
        }
      });
    } else {
      $('#municipio').prop('disabled', true);
      $('#municipio').append($("<option selected></option>").attr("value", "").text(
        "Selecciona"));
    }
  });
  $('[data-toggle="tooltip"]').tooltip();
  $(".aplicar_todo").change(function() {
    var id = $(this).attr('id');
    var aux = id.split('aplicar_todo');
    var num = aux[1];
    var valor = $('#' + id).val();
    switch (valor) {
      case "-1":
        $(".performance" + num).val("No proporciona");
        break;
      case "0":
        $(".performance" + num).val("No proporciona");
        break;
      case "1":
        $(".performance" + num).val("Excelente");
        break;
      case "2":
        $(".performance" + num).val("Bueno");
        break;
      case "3":
        $(".performance" + num).val("Regular");
        break;
      case "4":
        $(".performance" + num).val("Insuficiente");
        break;
      case "5":
        $(".performance" + num).val("Muy mal");
        break;
    }
  });
  $(".aplicar_all").change(function() {
    var id = $(this).attr('id');
    var aux = id.split('aplicar_all');
    var num = aux[1];
    var valor = $('#' + id).val();
    switch (valor) {
      case "-1":
        $(".caracteristica" + num).val("Not provided");
        break;
      case "0":
        $(".caracteristica" + num).val("Not provided");
        break;
      case "1":
        $(".caracteristica" + num).val("Excellent");
        break;
      case "2":
        $(".caracteristica" + num).val("Good");
        break;
      case "3":
        $(".caracteristica" + num).val("Regular");
        break;
      case "4":
        $(".caracteristica" + num).val("Bad");
        break;
      case "5":
        $(".caracteristica" + num).val("Very Bad");
        break;
    }
  });
  $(".solo_numeros").on("input", function() {
    var valor = $(this).val();
    $(this).val(valor.replace(/[^0-9]/g, ''));
  });
  $("#previos_hcl").change(function() {
    var previo = $(this).val();
    if (previo != 0) {
      $.ajax({
        url: '<?php echo base_url('Candidato/getDetallesProyectoPrevio'); ?>',
        method: 'POST',
        data: {
          'id_previo': previo
        },
        success: function(res) {
          var parte = res.split('@@');
          $('#detalles_previo_hcl').empty();
          $('#detalles_previo_hcl').html(parte[0]);
          $('#pais_previo_hcl').prop('disabled', false);
          $('#pais_previo_hcl').empty();
          $('#pais_previo_hcl').html(parte[1]);
          //$('#pais_previo').append($('<option></option>').attr('value','Mexico').text('Mexico'));
        }
      });
    } else {
      $('#detalles_previo_hcl').empty();
    }
  });
  $("#opcion_registro_hcl").change(function() {
    var opcion = $(this).val();
    $('.div_info_project').css('display', 'block');
    $('.div_project').css('display', 'flex');
    $('.div_info_test').css('display', 'block');
    $('.div_test').css('display', 'flex');
    $("#newModal #msj_error").css('display', 'none');
    if (opcion == 1) {
      $('.div_check_hcl').css('display', 'none');
      $('.div_info_check').css('display', 'none');
      $('.div_info_extra').css('display', 'none');
      $('.div_extra').css('display', 'none');
    }
    if (opcion == 0) {
      $('.div_previo').css('display', 'flex');
      $('.div_info_previo').css('display', 'block');
      $('.div_check_hcl').css('display', 'flex');
      $('.div_info_check').css('display', 'block');
      $('.div_info_extra').css('display', 'block');
      $('.div_extra').css('display', 'flex');
    }
    if (opcion == '') {
      $('.div_previo').css('display', 'none');
      $('.div_info_previo').css('display', 'none');
      $('.div_check_hcl').css('display', 'none');
      $('.div_info_check').css('display', 'none');
      $('.div_info_project').css('display', 'none');
      $('.div_project').css('display', 'none');
      $('.div_info_test').css('display', 'none');
      $('.div_test').css('display', 'none');
      $('.div_info_extra').css('display', 'none');
      $('.div_extra').css('display', 'none');
    }
  });
  $("#region_hcl").change(function() {
    var region = $(this).val();
    if (region != '') {
      $.ajax({
        url: '<?php echo base_url('Candidato/getSeccionesRegion'); ?>',
        method: 'POST',
        data: {
          'region': region
        },
        success: function(res) {
          var secciones = JSON.parse(res);
          $('.valor_dinamico').val('');
          $('.valor_dinamico').empty();
          //$('.valor_dinamico').append($('<option selected></option>').attr('value','').text('Select'));
          $('.valor_dinamico').prop('disabled', false);
          $('#ref_profesionales_registro_hcl').val(0);
          $('#ref_personales_registro_hcl').val(0);
          $('#ref_academicas_registro_hcl').val(0);
          //Distribuye las secciones en su correspondiente select
          for (var i = 0; i < secciones.length; i++) {
            if (secciones[i]['tipo_seccion'] == 'Global Search') {
              $('#global_registro_hcl').append($('<option></option>').attr(
                'value', secciones[i]['id']).text(secciones[i][
                'descripcion_ingles'
              ]));
            }
            /*if(secciones[i]['tipo_seccion'] == 'Verificacion Documentos'){
            	$('#identidad_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
            }*/
            //if(secciones[i]['tipo_seccion'] == 'Referencias Laborales'){
            if (secciones[i]['id'] == 16) {
              $('#empleos_registro_hcl').append($('<option></option>').attr(
                'value', secciones[i]['id']).text(secciones[i][
                'descripcion_ingles'
              ]));
            }
            //if(secciones[i]['tipo_seccion'] == 'Estudios'){
            if (secciones[i]['id'] == 3) {
              $('#estudios_registro_hcl').append($('<option></option>').attr(
                'value', secciones[i]['id']).text(secciones[i][
                'descripcion_ingles'
              ]));
            }
            if (secciones[i]['tipo_seccion'] == 'Domicilios') {
              $('#domicilios_registro_hcl').append($('<option></option>')
                .attr('value', secciones[i]['id']).text(secciones[i][
                  'descripcion_ingles'
                ]));
            }
            if (secciones[i]['tipo_seccion'] == 'Credito') {
              $('#credito_registro_hcl').append($('<option></option>').attr(
                'value', secciones[i]['id']).text(secciones[i][
                'descripcion_ingles'
              ]));
            }
          }
          //Empleos
          $('#empleos_registro_hcl').append($('<option></option>').attr('value',
            0).attr("selected", "selected").text('N/A'));
          $('#empleos_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '3 years').text('3 years'));
          $('#empleos_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '5 years').text('5 years'));
          $('#empleos_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '7 years').text('7 years'));
          $('#empleos_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '10 years').text('10 years'));
          $('#empleos_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', 'All').text('All'));
          $('#empleos_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '0').attr("selected", "selected").text('N/A'));
          //Criminales
          $('#criminal_registro_hcl').append($('<option></option>').attr('value',
            1).text('Apply'));
          $('#criminal_registro_hcl').append($('<option></option>').attr('value',
            0).attr("selected", "selected").text('N/A'));
          $('#criminal_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '3 years').text('3 years'));
          $('#criminal_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '5 years').text('5 years'));
          $('#criminal_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '7 years').text('7 years'));
          $('#criminal_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '10 years').text('10 years'));
          $('#criminal_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '0').attr("selected", "selected").text('N/A'));
          //Domicilios
          $('#domicilios_registro_hcl').append($('<option></option>').attr(
            'value', 0).attr("selected", "selected").text('N/A'));
          $('#domicilios_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '3 years').text('3 years'));
          $('#domicilios_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '5 years').text('5 years'));
          $('#domicilios_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '7 years').text('7 years'));
          $('#domicilios_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '10 years').text('10 years'));
          $('#domicilios_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '0').attr("selected", "selected").text('N/A'));
          //Credito
          $('#credito_registro_hcl').append($('<option></option>').attr('value',
            0).attr("selected", "selected").text('N/A'));
          $('#credito_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '3 years').text('3 years'));
          $('#credito_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '5 years').text('5 years'));
          $('#credito_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '7 years').text('7 years'));
          $('#credito_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '10 years').text('10 years'));
          $('#credito_tiempo_registro_hcl').append($('<option></option>').attr(
            'value', '0').attr("selected", "selected").text('N/A'));
          //Estudios
          $('#estudios_registro_hcl').append($('<option></option>').attr('value',
            0).attr("selected", "selected").text('N/A'));
          //Identidad
          $('#identidad_registro_hcl').append($('<option></option>').attr('value',
            1).text('Apply'));
          $('#identidad_registro_hcl').append($('<option></option>').attr('value',
            0).attr("selected", "selected").text('N/A'));
          //Globales
          $('#global_registro_hcl').append($('<option></option>').attr('value', 0)
            .attr("selected", "selected").text('N/A'));
          //Migracion
          $('#migracion_registro_hcl').append($('<option></option>').attr('value',
            1).text('Apply'));
          $('#migracion_registro_hcl').append($('<option></option>').attr('value',
            0).attr("selected", "selected").text('N/A'));
          //Prohibited parties list
          $('#prohibited_registro_hcl').append($('<option></option>').attr(
            'value', 1).text('Apply'));
          $('#prohibited_registro_hcl').append($('<option></option>').attr(
            'value', 0).attr("selected", "selected").text('N/A'));
          //Age check
          $('#edad_registro_hcl').append($('<option></option>').attr('value', 1)
            .text('Apply'));
          $('#edad_registro_hcl').append($('<option></option>').attr('value', 0)
            .attr("selected", "selected").text('N/A'));
          //Motor vehicle records
          $('#mvr_registro_hcl').append($('<option></option>').attr('value', 1)
            .text('Apply'));
          $('#mvr_registro_hcl').append($('<option></option>').attr('value', 0)
            .attr("selected", "selected").text('N/A'));
          //CURP
          $('#curp_registro_hcl').append($('<option></option>').attr('value', 1)
            .text('Apply'));
          $('#curp_registro_hcl').append($('<option></option>').attr('value', 0)
            .attr("selected", "selected").text('N/A'));
        }
      });
      if (region == 'International') {
        $('#pais_registro_hcl').prop('disabled', false);
        $('#pais_registro_hcl').val('');
        $('#pais_registr_hclo').find('option[value="México"]').remove()
        $('#mvr_registro_hcl').val(0);
      } else {
        $('#pais_registro_hcl').prop('disabled', true);
        //$('#pais_registro').val('México');
        $('#pais_registro_hcl').append($('<option></option>').attr('value', 'México').attr(
          "selected", "selected").text('Mexico'));
      }
      $('#proyecto_registro_hcl').prop('disabled', false);
    } else {
      $('#pais_registro_hcl').prop('disabled', true);
      $('#pais_registro_hcl').val('');
      $('#proyecto_registro_hcl').prop('disabled', true);
      $('#proyecto_registro_hcl').val('');
      $('.valor_dinamico').val('');
      $('.valor_dinamico').empty();
      $('.valor_dinamico').prop('disabled', true);
      $('#ref_profesionales_registro_hcl').val(0);
      $('#ref_personales_registro_hcl').val(0);
      $('#ref_academicas_registro_hcl').val(0);
    }
  });
  $('#extra_registro_hcl').change(function() {
    var id = $(this).val();
    if (id != '') {
      if (!extras.includes(id)) {
        var txt = $("#extra_registro_hcl option:selected").text();
        extras.push(id);
        //$("#extra_registro option[value='"+id+"']").remove();
        $('#div_docs_extras').append($('<div id="div_extra' + id +
          '" class="extra_agregado mb-1 d-flex justify-content-start"><h5 class="mr-5">Document added: <b>' +
          txt +
          '</b></h5><button type="button" class="btn btn-danger btn-sm" onclick="eliminarExtra(' +
          id + ',\'' + txt + '\')">X</button></div>'));
      }
    }
  })
});

function obtenerToken(url) {
  $.ajax({
    url: '<?php echo API_URL ?>login', // Ajusta la URL según tu endpoint de login
    type: 'POST',
    dataType: 'json',
    data: {
      email: 'john.doe@example.com', // Aquí deberías pasar los datos de login
      password: 'password123' // Y la contraseña correspondiente
    },
    success: function(response) {
      var token = response.token; // Suponiendo que la respuesta devuelve el token de acceso
      console.log('Token de acceso obtenido:', token);
      // Llamar a la función para cargar los datos protegidos
      changeDatatable(url, token);
    },
    error: function(xhr, status, error) {
      console.error('Error al obtener el token:', error);
      // Manejo de errores aquí
    }
  });
}


function loadInternos(url1) {
  console.log(url1);
  $.ajax({
    url: url1,
    dataType: 'json',
    success: function(response) {
      // Verificar que 'data' sea un array antes de mapear
      var formattedData = Array.isArray(response.data) ? response.data.map(function(item) {
        // Concatenación de nombre, paterno y materno
        var nombreCompleto = [item.nombre, item.paterno, item.materno].filter(Boolean).join(' ');

        return {
          id: item.id || '',
          nombreCompleto: nombreCompleto, // Columna concatenada
          creacion: item.creacion || '',
          correo: item.correo || '',
          telefono: item.telefono || '',
          documentos: item.documentos || '', // Aquí puedes añadir lógica para manejar documentos
          examenes: item.examenes || '' // Aquí puedes añadir lógica para manejar exámenes
        };
      }) : [];
      // Destruir la tabla anterior si ya existe
      if ($.fn.DataTable.isDataTable('#tablaExternos')) {
        $('#tablaExternos').DataTable().clear().destroy();
      }
      // Inicializar DataTable para Internos
      $('#tablaInternos').DataTable({
        "pageLength": 10,
        "order": [0, "desc"],
        "stateSave": false,
        "serverSide": false,
        "destroy": true,
        "data": formattedData,
        "columns": [{
            title: 'ID',
            data: 'id',
            "width": "10%",
            className: 'text-center' // Centrado de contenido
          },
          {
            title: 'Nombre',
            data: 'nombreCompleto',
            "width": "20%",
            className: 'text-center' // Centrado de contenido
          }, // Columna concatenada
          {
            title: 'Fecha Alta',
            data: 'creacion',
            "width": "15%",
            className: 'text-center' // Centrado de contenido
          },
          {
            title: 'Correo y Teléfono',
            data: function(row) {
              return row.correo + '<br>' + row.telefono;
            },
            "width": "25%",
            className: 'text-center' // Centrado de contenido
          },
          {
            title: 'Documentos',
            data: null,
            "width": "15%",
            className: 'text-center', // Centrado de contenido

            render: function(data, type, row) {
              // Crear botones para los documentos
              return '<button class="btn btn-info btn-sm" onclick="cargarDocumentosPanelClienteInterno(' +
                row.id +
                ', \'' + row.nombreCompleto + '\', 1)">' +
                '<i class="fa fa-eye"></i></button>';
            }
          },
          {
            title: 'Exámenes',
            data: null,
            "width": "15%",
            className: 'text-center', // Centrado de contenido
            render: function(data, type, row) {
              console.log("🚀 ~ loadInternos ~ r:", row)
              // Botón para los exámenes
              return '<div style="display: flex; justify-content: center; align-items: center;">' +
                '<button class="btn btn-primary btn-sm" onclick="cargarDocumentosPanelClienteInterno(' +
                row.id +
                ', \'' + row.nombreCompleto + '\', 2)">' +
                '<i class="fa fa-syringe"></i></button>' +
                '</div>';

            }
          }
        ]
      });
    },
    error: function(xhr, status, error) {
      console.error("Error en la petición AJAX de Internos:", status, error);
    }
  });
}

function changeDatatable(url1) {
  $.ajax({
    url: url1,
    dataType: 'json',

    success: function(data) {
      // Normalizar los datos devueltos para que cada entrada tenga la misma estructura de objeto
      var formattedData = data.map(function(item) {
        // Si el objeto solo contiene algunas propiedades, crear un nuevo objeto con la estructura completa
        if (!item.id) {
          item = {
            id: item.id_candidato_rodi,
            creacion: item.creacion,
            edicion: item.edicion,
            // Agrega otras propiedades necesarias aquí
          };
        }
        return item;
      });
      // Destruir la tabla anterior si ya existe
      if ($.fn.DataTable.isDataTable('#tablaInternos')) {
        $('#tablaInternos').DataTable().clear().destroy();
      }
      // Inicializar DataTable con los datos formateados
      var tabla = $('#tablaExternos').DataTable({
        "pageLength": 10,
        "order": [0, "desc"],
        "stateSave": false,
        "serverSide": false,
        "destroy": true, // Destruye cualquier instancia existente de DataTable antes de recrearla
        "data": formattedData, // Usar los datos formateados
        "columns": [{
            title: 'Candidate',
            data: 'candidato',
            "width": "15%",
            mRender: function(data, type, full) {

              var subcliente = (full.subcliente === null || full.subcliente === "") ? 'Sin Subcliente' :
                '<span class="badge badge-pill badge-primary">Subcliente: ' + full.subcliente +
                '</span><br>';
              var analista = (full.usuario === null || full.usuario === '') ?
                'Analista: Sin definir' : 'Analista: ' + full.usuario;
              var reclutador = (full.reclutadorAspirante !== null) ?
                '<br><span class="badge badge-pill badge-info">Reclutador(a): ' + full
                .reclutadorAspirante + '</span>' : '';
              var actionButton = '<br><button class="btn btn-success btn-sm" onclick="confirmAction(' +
                full.id + ')">Send to Employee</button>';


              return '<span class="badge badge-pill badge-dark">#' + full.id +
                '</span><br><a data-toggle="tooltip" class="sin_vinculo" style="color:black;"><b>' +
                full.candidato + actionButton;
              // reclutador;
            }
          },
          {
            title: 'Dates',
            data: 'fecha_alta',
            bSortable: false,
            "width": "15%",
            mRender: function(data, type, full) {
              let fechaAlta = '';
              let fechaFinal = '';
              let fechaFormulario = '';
              let fechaDocumentos = '';
              let fechas = '';
              fechaAlta = convertirFechaHora(data)
              fechaFormulario = (full.fecha_contestado != null) ? convertirFechaHora(full
                .fecha_contestado) : '-'
              fechaDocumentos = (full.fecha_documentos != null) ? convertirFechaHora(full
                .fecha_documentos) : '-'

              if (full.fecha_final != null) {
                fechaFinal = convertirFechaHora(full.fecha_final)
              }
              if (full.fecha_bgc != null) {
                fechaFinal = convertirFechaHora(full.fecha_bgc)
              }
              if (full.fecha_final == null && full.fecha_bgc == null) {
                fechaFinal = '-'
              }
              return fechas = '<b>Alta:</b> ' + fechaAlta + '<br>' + '<b>Formulario:</b> ' +
                fechaFormulario + '<br>' + '<b>Documentos:</b> ' + fechaDocumentos + '<br>' +
                '<b>Final:</b> ' + fechaFinal
            }
          },
          {
            title: 'SLA',
            data: 'tiempo_parcial',
            bSortable: false,
            "width": "10%",
            mRender: function(data, type, full) {
              if (full.cancelado == 0) {
                if (data != null) {
                  if (data != -1) {
                    if (data >= 0 && data <= 2) {
                      return res = '<div class="formato_dias dias_verde">' + data +
                        ' days</div>';
                    }
                    if (data > 2 && data <= 4) {
                      return res = '<div class="formato_dias dias_amarillo">' + data +
                        ' days</div>';
                    }
                    if (data >= 5) {
                      return res = '<div class="formato_dias dias_rojo">' + data +
                        ' days</div>';
                    }
                  } else {
                    return "Updating...";
                  }
                }
              } else {
                return 'N/A';
              }
            }
          },
          {
            title: 'Acciones',
            data: 'id',
            "width": "10%",
            bSortable: false,
            mRender: function(data, type, full) {
              // Condición para el usuario espectador
              if (full.socioeconomico == 1) {
                if (full.tipo_formulario != 0) {
                  var documentos =
                    ' <a href="javascript:void(0)" data-toggle="tooltip" title="Documents of the candidate" id="subirDocs" class="fa-tooltip icono_datatable"><i class="fas fa-folder"></i></a>';
                  return '<a href="javascript:void(0)" data-toggle="tooltip" title="Follow up of the candidate" id="msj_avances" class="fa-tooltip icono_datatable"><i class="fas fa-comment-dots"></i></a> <a href="javascript:void(0)" data-toggle="tooltip" title="Status process" id="ver" class="fa-tooltip icono_datatable"><i class="fas fa-eye"></i></a>' +
                    documentos;
                } else {
                  return '<a href="javascript:void(0)" data-toggle="tooltip" title="Follow up of the candidate" id="msj_avances" class="fa-tooltip icono_datatable"><i class="fas fa-comment-dots"></i></a>';
                }
              } else {
                return '<a href="javascript:void(0)" data-toggle="tooltip" title="Follow up of the candidate" id="msj_avances" class="fa-tooltip icono_datatable"><i class="fas fa-comment-dots"></i></a>';
              }

            }
          },
          {
            title: 'Exámenes',
            data: null,
            bSortable: false,
            "width": "15%",
            mRender: function(data, type, full) {
              if (full.cancelado == 0) {
                var salida = '';
                //* Doping
                if (full.tipo_antidoping == 1) {
                  if (full.doping_hecho == 1) {
                    if (full.fecha_resultado != null && full.fecha_resultado != "") {
                      if (full.resultado_doping == 1) {
                        salida +=
                          '<b>DrugTest: </b><div style="display: inline-block;margin-left:3px;"><form id="pdfForm' +
                          full.idDoping +
                          '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado" id="pdfDoping" class="fa-tooltip icono_datatable icono_doping_reprobado"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' +
                          full.idDoping + '" value="' + full.idDoping +
                          '"></form></div>';
                      } else {
                        salida +=
                          '<b>DrugTest: </b><div style="display: inline-block;margin-left:3px;"><form id="pdfForm' +
                          full.idDoping +
                          '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado" id="pdfDoping" class="fa-tooltip icono_datatable icono_doping_aprobado"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' +
                          full.idDoping + '" value="' + full.idDoping +
                          '"></form></div>';
                      }

                    } else {
                      salida += "<b>DrugTest: Pendiente</b> ";
                    }
                  } else {
                    salida += "<b>DrugTest: Pendiente</b> ";
                  }
                  if (full.medico == 1 || full.psicometrico == 1) {
                    salida += '<hr>';
                  }
                }
                /*if (full.tipo_antidoping == 0) {
                	salida += "<b>Doping: N/A</b> <hr>";
                }*/
                //* Médico
                if (full.medico == 1) {

                  if (full.idMedico != null) {
                    if (full.conclusion != null && full.descripcion != null) {
                      salida +=
                        '<b>Médico:</b> <div style="display: inline-flex;"><form id="formMedico' +
                        full.idMedico +
                        '" action="<?php echo base_url('Medico/crearPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final" id="pdfMedico" class="icono_datatable icono_medico"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idMedico" id="idMedico' +
                        full.idMedico + '" value="' + full.idMedico +
                        '"></form></div><hr>';
                    } else {
                      salida += "<b>Médico: En proceso</b>";
                    }

                  } else {
                    salida +=
                      '<b>Médico: Pendiente</b><div style="display: inline-block;margin-left:3px;"> <br>';
                  }

                }

                //* Psicometria
                if (full.psicometrico == 1) {

                  if (full.archivo != null && full.archivo != "") {


                    salida +=
                      '<b>Psicométrico:</b> <i class="fas fa-brain"></i></a> ' +
                      '<a href="' + psico + full.archivo +
                      '" target="_blank" data-toggle="tooltip" title="Ver psicometría" id="descarga_psicometrico" class="fa-tooltip icono_datatable icono_psicometria">' +
                      '<i class="fas fa-file-powerpoint"></i>' +
                      '</a>';
                  } else {
                    salida +=
                      '<b>Psicométrico:</b> <i class="fas fa-brain"></i></a>';
                  }
                }

                //* Sin examenes
                if (full.tipo_antidoping == 0 && full.medico == 0 && full.psicometrico == 0) {
                  salida = "<b>N/A</b> ";
                }

              } else {
                salida = "<b>N/A</b> ";
              }
              return salida;
            }
          },

          {
            title: 'Resultado',
            data: 'id',
            bSortable: false,
            "width": "12%",
            mRender: function(data, type, full) {


              if (full.cancelado == 0) {
                if (full.socioeconomico == 1) {
                  let icono_resultado = '';
                  let previo = '';
                  if (full.liberado == 0) {
                    previo =
                      ' <div style="display: inline-flex;"><form id="reportePrevioForm' +
                      data +
                      '" action="<?php echo base_url('Candidato_Conclusion/createPrevioPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte previo" id="reportePrevioPDF" class="fa-tooltip icono_datatable icono_previo"><i class="far fa-file-powerpoint"></i></a><input type="hidden" name="idPDF" id="idPDF' +
                      data + '" value="' + data + '"></form></div>';
                    return previo;
                  } else {

                    switch (full.status_bgc) {
                      case 1:
                        icono_resultado = 'icono_resultado_aprobado';

                        break;
                      case 4:
                        icono_resultado = 'icono_resultado_aprobado';
                        break;
                      case 2:
                        icono_resultado = 'icono_resultado_reprobado';
                        break;

                      case 3:
                        icono_resultado = 'icono_resultado_revision';
                        break;
                      default:

                        icono_resultado = 'icono_resultado_espera';
                        break;

                        break;
                    }


                    return '<div style="display: inline-block;">' +
                      '<form id="reporteForm' + data +
                      '" action="<?php echo base_url('Candidato_Conclusion/createPDF'); ?>" method="POST">' +
                      '<a href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte PDF" id="reportePDF" class="fa-tooltip icono_datatable ' +
                      icono_resultado + '">' +
                      '<i class="fas fa-file-pdf"></i>' +
                      '</a>' +
                      '<input type="hidden" name="idCandidatoPDF" id="idCandidatoPDF' + data +
                      '" value="' + data + '">' +
                      '</form>' +
                      '</div>' + previo;

                  }

                } else {
                  return 'Sin ESE';
                }
              } else {
                return 'N/A';
              }
            }
          }
          // Agrega más columnas según la estructura de tus datos
        ],
        "columnDefs": [{
          "targets": [1, 2, 3], // Índices de las columnas a ocultar en pantallas pequeñas
          "className": 'hide-on-small' // Clase personalizada para ocultar
        }],
        "responsive": {
          details: {
            type: 'column',
            target: 'tr'
          }
        },
        fnDrawCallback: function(oSettings) {
          $('a[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
          });
        },
        rowCallback: function(row, data) {
          $("a#ver", row).bind('click', () => {
            $(".nombreCandidato").text(data.candidato);
            $.ajax({
              url: '<?php echo base_url('Client/verProcesoCandidato'); ?>',
              type: 'post',
              data: {
                'id_candidato': data.id,
                'status_bgc': data.status_bgc,
                'formulario': data.fecha_contestado
              },
              success: function(res) {
                $("#div_status").html(res);
                $("#statusModal").modal("show");
              }
            });
          });
          $('a[id^=pdfDoping]', row).bind('click', () => {
            var id = data.idDoping;
            $('#pdfForm' + id).submit();
          });
          $('a[id^=pdfMedico]', row).bind('click', () => {
            var id = data.idMedico;
            $('#formMedico' + id).submit();
          });
          $('a[id^=simplePDF]', row).bind('click', () => {
            var id = data.id;
            $('#reporteFormSimple' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'El reporte PDF se esta creando y se descargará en breve',
              showConfirmButton: false,
              timer: 2500
            })
          });

          $("a#psicometria", row).bind('click', () => {
            $('#subirArchivoModal #titulo_modal').html(
              'Carga de archivo de psicometría del candidato: <br>' + data.candidato);
            $('#subirArchivoModal #label_modal').text('Selecciona el archivo de psicometría *');
            $('#btnSubir').attr("onclick", "subirArchivo('psicometrico'," + data.id + "," + data
              .idPsicometrico + ")");
            $('#subirArchivoModal').modal('show');
          });
          $("a#msj_avances", row).bind('click', () => {
            $.ajax({
              url: '<?php echo base_url('Candidato/viewAvances'); ?>',
              type: 'post',
              data: {
                'id_rol': 7,
                'id_candidato': data.id,
                'id_cliente': data.id_cliente
              },
              success: function(res) {
                $("#div_avances_dop").html(res);

              }
            });
            $("#avancesModal").modal("show");
          });
          $('a#documentos', row).bind('click', () => {
            $.ajax({
              url: '<?php echo base_url('Candidato/viewDocumentos'); ?>',
              type: 'post',
              data: {
                'id_candidato': data.id
              },
              success: function(res) {
                if (res != 0) {
                  $("#lista_documentos").empty();
                  $("#lista_documentos").html(res);
                  $("#documentosModal").modal('show');
                } else {
                  $("#lista_documentos").empty();
                  $("#lista_documentos").html(
                    "<p class='text-center'><b>Documents under review</b></p>");
                  $("#documentosModal").modal('show');
                }


              },
              error: function(res) {

              }
            });
          });
          $("a#subirDocs", row).bind('click', () => {
            cargarDocumentosPanelCliente(data.id, (data.nombre + ' ' + data.paterno), data.paterno);
          });


          $("a#msj_avances", row).bind('click', () => {
            $.ajax({
              url: '<?php echo base_url('Candidato/viewAvances'); ?>',
              type: 'post',
              data: {
                'id_rol': 2,
                'id_candidato': data.id,
                'id_cliente': data.id_cliente
              },
              success: function(res) {
                $("#div_avances_bgv").html(res);

              }
            });
            $("#avancesModal").modal("show");
          });
          $('a[id^=pdfPrevio]', row).bind('click', () => {
            var id = data.id;
            $('#formPrevio' + id).submit();
          });
          $("a#final", row).bind('click', () => {
            $("#idCandidato").val(data.id);
            $(".nombreCandidato").text(data.candidato);
            if (data.tipo_conclusion == 8) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', false);
              $('#check_credito').prop('disabled', true);
              $('#check_medico').prop('disabled', true);
              $('#check_domicilio').prop('disabled', true);
              $('#check_professional_accreditation').prop('disabled', true);
              $('#check_ref_academica').prop('disabled', true);
              $('#check_nss').prop('disabled', true);
              $('#check_ciudadania').prop('disabled', true);
              $('#check_mvr').prop('disabled', true);
              $('#check_servicio_militar').prop('disabled', true);
              $('#check_credencial_academica').prop('disabled', true);
              $('#check_ref_profesional').prop('disabled', true);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 9) {
              $('#finalizarInvestigacionesModal').modal('show')
            }
            if (data.tipo_conclusion == 11) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', false);
              $('#check_medico').prop('disabled', true);
              $('#check_domicilio').prop('disabled', true);
              $('#check_professional_accreditation').prop('disabled', true);
              $('#check_ref_academica').prop('disabled', true);
              $('#check_nss').prop('disabled', true);
              $('#check_ciudadania').prop('disabled', true);
              $('#check_mvr').prop('disabled', true);
              $('#check_servicio_militar').prop('disabled', true);
              $('#check_credencial_academica').prop('disabled', true);
              $('#check_ref_profesional').prop('disabled', true);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 12) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', true);
              $('#check_penales').prop('disabled', false);
              $('#check_ofac').prop('disabled', false);
              $('#check_global').prop('disabled', false);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 13) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', true);
              $('#check_penales').prop('disabled', false);
              $('#check_ofac').prop('disabled', false);
              $('#check_global').prop('disabled', false);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 16) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', true);
              $('#check_identidad').prop('disabled', false);
              $('#check_penales').prop('disabled', false);
              $('#check_ofac').prop('disabled', false);
              $('#check_global').prop('disabled', false);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 18) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', true);
              $('#check_identidad').prop('disabled', false);
              $('#check_laboral').prop('disabled', false);
              $('#check_estudios').prop('disabled', false);
              $('#check_penales').prop('disabled', false);
              $('#check_ofac').prop('disabled', false);
              $('#check_global').prop('disabled', false);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 20) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', true);
              $('#check_identidad').prop('disabled', false);
              $('#check_global').prop('disabled', false);
              $('#check_penales').prop('disabled', false);
              $('#check_laboral').prop('disabled', false);
              $('#check_estudios').prop('disabled', false);
              $('#check_ofac').prop('disabled', false);
              $('#check_credito').prop('disabled', false);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 22) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', false);
              //$('#comentario_final').val('')
              //$('#comentario_final').prop('disabled',true);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 1 || data.tipo_conclusion == 2 || data
              .tipo_conclusion == 3 || data.tipo_conclusion == 4 || data.tipo_conclusion ==
              5 || data.tipo_conclusion == 6 || data.tipo_conclusion == 7 || data
              .tipo_conclusion == 10 || data.tipo_conclusion == 14 || data.tipo_conclusion ==
              15 || data.tipo_conclusion == 17 || data.tipo_conclusion == 19 || data
              .tipo_conclusion == 21) {
              $('.loader').css("display", "block");
              //* Datos generales
              var adeudo = (data.adeudo_muebles == 1) ? "con adeudo" : "sin adeudo";
              var estatus_final_conclusion = '';
              switch (data.status_bgc) {
                case '1':
                  estatus_final_conclusion = 'Recomendable';
                  break;
                case '2':
                  estatus_final_conclusion = 'No recomendable';
                  break;
                case '3':
                  estatus_final_conclusion = 'A consideración del cliente';
                  break;
                default:
                  estatus_final_conclusion = 'Estatus final';
                  break;
              }
              //* Origen
              if (data.pais == 'México' || data.pais == 'Mexico' || data.pais == null) {
                var originario = data.lugar_nacimiento;
              } else {
                var originario = data.lugar_nacimiento + ', ' + data.pais;
              }
              //* Antecedentes sociales
              var data_social = $.ajax({
                url: '<?php echo base_url('Candidato_Social/getById'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              if (data_social != 0) {
                var social = JSON.parse(data_social);
                var bebidas = (social.bebidas == 1) ? "ingerir" : "no ingerir";
                var fuma = (social.fumar == 1) ? "Fuma " + social.fumar_frecuencia + "." :
                  "No fuma.";
                if (social.religion != "" && social.religion != "Ninguna" && social
                  .religion != "NINGUNA" && social.religion != "No" && social.religion !=
                  "NO" && social.religion != "NA" && social.religion != "N/A" && social
                  .religion != "No aplica" && social.religion != "NO APLICA" && social
                  .religion != "No Aplica") {
                  var religion = "profesa la religion " + social.religion + ".";
                } else {
                  var religion = "no profesa alguna religión.";
                }
                if (social.cirugia != "" && social.cirugia != "Ninguna" && social.cirugia !=
                  "NINGUNA" && social.cirugia != "No" && social.cirugia != "NO" && social
                  .cirugia != "NA" && social.cirugia != "N/A" && social.cirugia !=
                  "No aplica" && social.cirugia != "NO APLICA" && social.cirugia !=
                  "No Aplica" && social.cirugia != "0") {
                  var cirugia = "Cuenta con cirugia(s) de " + social.cirugia + ".";
                } else {
                  var cirugia = "No cuenta con cirugias.";
                }
                if (social.enfermedades != "" && social.enfermedades != "Ninguna" && social
                  .enfermedades != "NINGUNA" && social.enfermedades != "No" && social
                  .enfermedades != "NO" && social.enfermedades != "NA" && social
                  .enfermedades != "N/A" && social.enfermedades != "No aplica" && social
                  .enfermedades != "NO APLICA" && social.enfermedades != "No Aplica" &&
                  social.enfermedades != "0") {
                  var enfermedades =
                    "Tiene alguna(s) enfermedad(es) con antecedente familiar como " +
                    social.enfermedades + ".";
                } else {
                  var enfermedades =
                    "No tiene antecedentes de enfermedadades en su familia.";
                }

              } else {
                var social = '';
                var bebidas = '';
                var fuma = '';
                var religion = '';
                var cirugia = '';
                var enfermedades = '';
              }
              //*Comentarios ref laborales
              var comentarios_laborales = $.ajax({
                url: '<?php echo base_url('Candidato_Laboral/getComentarios'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id_candidato': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Historial de puestos laborales
              var historial_puestos = $.ajax({
                url: '<?php echo base_url('Candidato_Laboral/getHistorialPuestos'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Comentarios ref personales
              var refs_comentarios = $.ajax({
                url: '<?php echo base_url('Candidato_Ref_Personal/getComentarios'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Comentarios ref vecinales
              var vecinales = $.ajax({
                url: '<?php echo base_url('Candidato_Ref_Vecinal/getComentarios'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id_candidato': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Numero de antecedentes laborales reportados
              var trabajos = $.ajax({
                url: '<?php echo base_url('Candidato_Laboral/countAntecedentesLaborales'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id_candidato': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Información de vivienda
              var data_vivienda = $.ajax({
                url: '<?php echo base_url('Candidato_Vivienda/getById'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              if (data_vivienda != 0) {
                var vivienda = JSON.parse(data_vivienda);
                switch (vivienda.calidad_mobiliario) {
                  case '1':
                    var calidad = "Buena";
                    break;
                  case '2':
                    var calidad = "Regular";
                    break;
                  case '3':
                    var calidad = "Mala";
                    break;
                }
                switch (vivienda.tamanio_vivienda) {
                  case '1':
                    var tamano = "Amplia";
                    break;
                  case '2':
                    var tamano = "Suficiente";
                    break;
                  case '3':
                    var tamano = "Reducidad";
                    break;
                }
                switch (vivienda.tipo_propiedad) {
                  case 'Propia':
                  case 'Pagando hipoteca':
                  case 'INFONAVIT':
                    var propiedad = "suya o de sus padres";
                    break;
                  case 'Rentada':
                    var propiedad = "rentada ";
                    break;
                  case 'Prestada':
                    var propiedad = "prestada ";
                    break;
                }
                var distribucion_hogar = '';
                if (vivienda.sala == 'Sí')
                  distribucion_hogar += 'sala, ';
                if (vivienda.comedor == 'Sí')
                  distribucion_hogar += 'comedor, ';
                if (vivienda.cocina == 'Sí')
                  distribucion_hogar += 'cocina, ';
                if (vivienda.patio == 'Sí')
                  distribucion_hogar += 'patio, ';
                if (vivienda.cochera == 'Sí')
                  distribucion_hogar += 'cochera, ';
                if (vivienda.cuarto_servicio == 'Sí')
                  distribucion_hogar += 'cuarto de servicio, ';
                if (vivienda.jardin == 'Sí')
                  distribucion_hogar += 'jardín, ';
                distribucion_hogar += vivienda.banios + ' baño(s), ';
                distribucion_hogar += vivienda.recamaras + ' recámaras';
              } else {
                var vivienda = '';
                var distribucion_hogar = '';
              }
              //* Personas en misma vivienda
              var personas_mismo_domicilio = $.ajax({
                url: '<?php echo base_url('Candidato_Familiar/getIntegrantesDomicilio'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Estudios de acuerdo a historial
              var maximo_estudio = $.ajax({
                url: '<?php echo base_url('Candidato_Estudio/getMaximoEstudio'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Información de salud
              var data_salud = $.ajax({
                url: '<?php echo base_url('Candidato_Salud/getById'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              if (data_salud != 0) {
                var salud = JSON.parse(data_salud);
                if (salud.enfermedad_cronica == 'No aplica' || salud.enfermedad_cronica ==
                  'NA' || salud.enfermedad_cronica == 'N/A' || salud.enfermedad_cronica ==
                  'No padece' || salud.enfermedad_cronica == 'No tiene') {
                  var enfermedad_cronica = 'no padece enfermedades crónicas,';
                } else {
                  var enfermedad_cronica = 'padece de ' + salud.enfermedad_cronica + ',';
                }
                if (salud.accidentes == 'No aplica' || salud.accidentes == 'NA' || salud
                  .accidentes == 'N/A' || salud.accidentes == 'No ha tenido') {
                  var accidente = 'no ha sufrido accidentes graves,';
                } else {
                  var accidente = 'ha sufrido de ' + salud.accidentes + ',';
                }
                if (salud.alergias == 'No aplica' || salud.alergias == 'NA' || salud
                  .alergias == 'N/A' || salud.alergias == 'No ha tenido' || salud
                  .alergias == 'No tiene') {
                  var alergias = 'no reporta alergias.';
                } else {
                  var alergias = 'reporta alergias de ' + salud.alergias + '.';
                }
                if (salud.tabaco == 'SI') {
                  var salud_tabaco = 'Refiere consumir tabaco con una frecuencia de ' +
                    salud.tabaco_frecuencia.toLowerCase();
                } else {
                  var salud_tabaco = 'Niega la ingesta de tabaco';
                }
                if (salud.droga == 'SI') {
                  var salud_droga = ' , hace uso de droga con una frecuencia de ' + salud
                    .droga_frecuencia.toLowerCase();
                } else {
                  var salud_droga = ' , no hace uso de droga';
                }
                if (salud.alcohol == 'SI') {
                  var salud_alcohol = ' y refiere consumir alcohol de manera ' + salud
                    .alcohol_frecuencia.toLowerCase();
                } else {
                  var salud_alcohol = ' y no consume alcohol';
                }
                if (salud.practica_deporte == 1) {
                  var practica_deporte = 'Como actividad física menciona practicar ' +
                    salud.practica_deporte + ' ' + salud.deporte_frecuencia;
                } else {
                  var practica_deporte = 'Menciona que no practica algún deporte';
                }
              } else {
                var salud = '';
              }
              //* Información economica
              var data_economia = $.ajax({
                url: '<?php echo base_url('Candidato_Finanzas/getById'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              if (data_economia != 0) {
                var economia = JSON.parse(data_economia);
              } else {
                var economia = '';
              }
              //*Información referencias y contactos laborales
              var incidencias_laborales = $.ajax({
                url: '<?php echo base_url('Candidato_Laboral/getHistorialIncidencias'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Extra laboral
              var data_extra_laboral = $.ajax({
                url: '<?php echo base_url('Candidato_Laboral/getExtrasById'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              var extra_laboral = JSON.parse(data_extra_laboral);
              //* Informacion de servicios publicos
              var data_servicios = $.ajax({
                url: '<?php echo base_url('Candidato_Servicio/getById'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              var servicios = JSON.parse(data_servicios);
              setTimeout(function() {
                $('.loader').fadeOut();
              }, 200);
              //*Tipos de conclusion
              if (data.tipo_conclusion == 0) {
                finalizarProcesoSinEstatus();
              }
              if (data.tipo_conclusion == 21) {
                $("#personal3").prop('disabled', true);
                $("#personal3").val("");
                $("#personal4").prop('disabled', true);
                $("#personal4").val("");
                $("#socio1").prop('disabled', true);
                $("#socio1").val("");
                $("#laboral1").prop('disabled', true);
                $("#laboral1").val("");
                $("#visita1").prop('disabled', true);
                $("#visita1").val("");
                $("#visita2").prop('disabled', true);
                $("#visita2").val("");
                $('#comentario_bgc').prop('disabled', true)
                $('#comentario_bgc').val("");
                let sumaGastos = (parseInt(economia.renta) + parseInt(economia.alimentos) +
                  parseInt(economia.servicios) + parseInt(economia.transporte) +
                  parseInt(economia.otros));

                $("#personal1").val("C. " + data.candidato + ", de " + data.edad +
                  " años de edad, es " + data.estado_civil + ", reside en " + data
                  .municipio + ", " + data.estado + ".");
                $("#personal2").val("Menciona " + bebidas + " bebidas alcohólicas y " +
                  fuma + "." + cirugia + ".");
                //$("#personal3").val("Sus referencias personales lo describen como " + refs_comentarios + ".");
                //$("#socio1").val("Actualmente vive en un/una " + vivienda.vivienda + ", en una zona " + vivienda.zona + "; el mobiliario en su interior se observa de "+calidad+", la vivienda es "+tamano+", en condiciones "+vivienda.condiciones+". "+servicios.basicos+"; "+servicios.vias_acceso+" y "+servicios.rutas_transporte+".");
                $("#socio2").val("Los ingresos mensuales son de $" + economia.sueldo +
                  "; sus gastos mensualmente son de $" + sumaGastos +
                  ". Con respecto a si posee bienes el candidato menciona que " +
                  economia.bienes +
                  "; y con respecto a sus deudas comenta que tiene" + economia.deudas);
                $("#laboral2").val(comentarios_laborales);
                //$("#visita2").val("De acuerdo a su(s) referencia(s) vecinal(es), describen que es " + vecinales);
                //$("#visita1").val("Durante la visita, el(la) candidato(a) fue: ");
                $('#conclusion_investigacion').val(
                  'En la investigación realizada se encontró que el(la) candidato(a) es una persona ________.Le consideramos ' +
                  estatus_final_conclusion + ".")
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 14) {
                $("#personal4").prop('disabled', true);
                $("#personal4").val("");
                $("#laboral1").prop('disabled', true);
                $("#laboral1").val("");
                $('#comentario_bgc').prop('disabled', true)
                $('#comentario_bgc').val("");

                $("#personal1").val("C. " + data.candidato + ", de " + data.edad +
                  " años de edad, es " + data.estado_civil + ", reside en " + data
                  .municipio + ", " + data.estado + " " + religion +
                  ". Cuenta con estudios en " + data.grado);
                $("#personal2").val("Menciona " + bebidas + " bebidas alcohólicas y " +
                  fuma + "." + cirugia + ". Su plan a corto plazo es " + social
                  .corto_plazo + "; y su meta a mediano plazo es " + social
                  .mediano_plazo + ".");
                $("#personal3").val("Sus referencias personales lo describen como " +
                  refs_comentarios + ".");
                $("#socio1").val("Actualmente vive en un/una " + vivienda.vivienda +
                  ", en una zona " + vivienda.zona +
                  "; el mobiliario en su interior se observa de " + calidad +
                  ", la vivienda es " + tamano + ", en condiciones " + vivienda
                  .condiciones + ". " + servicios.basicos + "; " + servicios
                  .vias_acceso + " y " + servicios.rutas_transporte + ".");
                $("#socio2").val("El(La) candidato(a) vive " + personas_mismo_domicilio +
                  ". Los ingresos mensuales ______; gastan mensualmente $" + economia
                  .otros + ". La vivienda cuenta con " + distribucion_hogar + ".");
                $("#laboral2").val(comentarios_laborales);
                $("#visita2").val(
                  "De acuerdo a su(s) referencia(s) vecinal(es), describen que es " +
                  vecinales);
                $("#visita1").val("Durante la visita, el(la) candidato(a) fue: " + data
                  .comentarioVisitador);
                $('#conclusion_investigacion').val(
                  'En la investigación realizada se encontró que el(la) candidato(a) es una persona ________.Le consideramos ' +
                  estatus_final_conclusion + ".")
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 1) {
                $('#conclusion_investigacion').prop('disabled', true)
                $('#conclusion_investigacion').val('')
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, reside en " + data.municipio + ", " + data.estado +
                  ". Es " + data.estado_civil + " y " + religion);
                $("#personal2").val("Refiere " + bebidas + " bebidas alcohólicas. " + fuma +
                  " " + cirugia + " " + enfermedades +
                  " Sus referencias personales lo describen como " +
                  refs_comentarios + ".");
                $("#personal3").val("Su plan a corto plazo es " + social.corto_plazo +
                  "; y su meta a mediano plazo es " + social.mediano_plazo);
                $("#personal4").val("Su grado máximo de estudios es " + data.grado);
                $("#socio1").val("Actualmente vive en un/una " + vivienda.vivienda +
                  ", con un tiempo de residencia de " + vivienda.tiempo_residencia +
                  ". El nivel de la zona es " + vivienda.zona +
                  ", el mobiliario es de calidad " + calidad + ", la vivienda es " +
                  tamano + " y en condiciones " + vivienda.condiciones +
                  ". La distribución de su " + vivienda.vivienda + " es " + vivienda
                  .distribucion);
                $("#socio2").val(data.candidato + " declara en sus ingresos " + data
                  .ingresos +
                  ". Los gastos generados en el hogar son solventados por _____. Cuenta con " +
                  data.muebles + " " + adeudo + ".");
                $("#laboral1").val("Señaló " + trabajos + " referencias laborales");
                $("#laboral2").val(comentarios_laborales);
                $("#visita1").val("El candidato durante la visita: " + data
                  .comentarioVisitador);
                $("#visita2").val(
                  "De acuerdo a la referencia vecinal, el candidato es considerado: " +
                  vecinales);
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 2) {
                $('#conclusion_investigacion').prop('disabled', true)
                $('#conclusion_investigacion').val('')
                if (data.visitador == 1) {
                  $("#personal1").val("Se aplicó estudio socioeconómico a " + data
                    .candidato + ", de " + data.edad + " años, originario de " +
                    originario + " con CURP:" + data.curp + " y NSS:" + data.nss +
                    "; estado civil " + data.estado_civil.toLowerCase() +
                    ", vive " + personas_mismo_domicilio + "en el domicilio " + data
                    .calle + " #" + data.exterior + " " + data.interior +
                    ", colonia " + data.colonia + ", desde hace " + data
                    .tiempo_dom_actual + ", en una propiedad " + propiedad +
                    " que se encuentra ubicada en una zona " + vivienda.tipo_zona
                    .toLowerCase() + " de clase " + vivienda.zona.toLowerCase() +
                    ".");
                } else {
                  $("#personal1").val("No se pudo aplicar el estudio socioeconómico.");
                }
                $("#personal2").val("En cuanto a su salud " + enfermedad_cronica + " " +
                  accidente + " su tipo de sangre es " + salud.tipo_sangre + " y " +
                  alergias + " " + salud_tabaco + salud_droga + salud_alcohol + ". " +
                  practica_deporte + ".");
                $("#personal4").val("Sus estudios máximos son de " + maximo_estudio +
                  " su experiencia laboral es como " + historial_puestos + ".");
                $("#socio1").val(
                  "Referente a su economía, menciona solventar sus gastos con " +
                  economia.observacion + ".");
                $("#socio2").val("Sus referencias personales lo describen como " +
                  refs_comentarios + ".");
                $("#laboral2").val("En cuanto a sus empleos, estuvo en " +
                  incidencias_laborales);
                $("#personal3").prop('disabled', true);
                $("#personal3").val("");
                $("#laboral1").prop('disabled', true);
                $("#laboral1").val("");
                $("#visita1").prop('disabled', true);
                $("#visita1").val("");
                $("#visita2").prop('disabled', true);
                $("#visita2").val("");
                $("#comentario_bgc").prop('disabled', true);
                $("#comentario_bgc").val("");
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 3) {
                $('.es_conclusion').prop('disabled', true)
                $('.es_conclusion').val('')
                $("#comentario_bgc").prop('disabled', false);
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 4) {
                $('.es_conclusion').prop('disabled', true)
                $("#personal1").prop('disabled', false)
                $("#laboral1").prop('disabled', false)
                $("#laboral2").prop('disabled', false)
                $('.es_conclusion').val('')
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, es originario de " + originario +
                  ". Tiene como máximo grado de estudios: " + data.grado +
                  ". Refiere ser " + social.religion + ". Su plan a corto plazo: " +
                  social.corto_plazo + ". Su plan a mediano plazo: " + social
                  .mediano_plazo);
                $("#laboral1").val("Señaló " + trabajos + " referencias laborales");
                $("#laboral2").val(" es quien nos valida referencia laboral..");
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 5) {
                $('.es_conclusion').prop('disabled', false)
                $('.es_conclusion').val('')
                $("#socio1").prop('disabled', true);
                $("#visita2").prop('disabled', true);
                $("#conclusion_investigacion").prop('disabled', false)
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, de nacionalidad " + data.nacionalidad + ", que reside en " +
                  data.municipio + ", " + data.estado + ". Es " + data.estado_civil);
                $("#personal2").val("Refiere " + bebidas + " bebidas alcohólicas. " + fuma +
                  " " + cirugia + " " + enfermedades +
                  " Sus referencias personales lo describen como " +
                  refs_comentarios + ".");
                $("#personal3").val("Su plan a corto plazo: " + social.corto_plazo +
                  ". Su plan a mediano plazo: " + social.mediano_plazo);
                $("#personal4").val("Su grado máximo de estudios es " + data.grado);

                $("#socio2").val(data.candidato + " declara en sus ingresos $" + data
                  .ingresos +
                  ". Los gastos generados en el hogar son solventados por _____. Cuenta con " +
                  data.muebles + " " + adeudo + ".");
                $("#laboral1").val("Señaló " + trabajos + " referencias laborales");
                $("#laboral2").val(comentarios_laborales);
                $("#visita1").val("El candidato durante la visita: ");
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 6) {
                $('.es_conclusion').prop('disabled', false)
                $('.es_conclusion').val('')
                $("#socio1").prop('disabled', true)
                $("#socio2").prop('disabled', true)
                $("#visita1").prop('disabled', true)
                $("#visita2").prop('disabled', true)
                $('#conclusion_investigacion').prop('disabled', true)
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, de nacionalidad " + data.nacionalidad + ". Es " + data
                  .estado_civil);
                $("#personal2").val(
                  "Refiere _ bebidas alcohólicas. Sus referencias personales lo describen como _."
                );
                $("#personal3").val(
                  "Su plan a corto plazo es _; y su meta a mediano plazo es _");
                $("#personal4").val("Su grado máximo de estudios es " + data.grado);
                $("#laboral1").val("Señaló " + trabajos + " referencias laborales");
                $("#laboral2").val(comentarios_laborales);
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 7) {
                $('.es_conclusion').prop('disabled', true)
                $('.es_conclusion').val('')
                $('#personal1').prop('disabled', false)
                $('#personal2').prop('disabled', false)
                $("#laboral1").prop('disabled', false)
                $("#laboral2").prop('disabled', false)
                $("#socio1").prop('disabled', false)
                $("#socio2").prop('disabled', false)
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, es originario de " + originario +
                  ". Tiene como máximo grado de estudios: " + data.grado +
                  ". Refiere ser " + social.religion + ". Su plan a corto plazo: " +
                  social.corto_plazo + ". Su plan a mediano plazo: " + social
                  .mediano_plazo);
                $("#personal2").val("Refiere " + bebidas + " bebidas alcohólicas " + social
                  .bebidas_frecuencia + ". " + fuma +
                  " Sus referencias personales lo describen como " +
                  refs_comentarios + ".");
                $("#laboral1").val("Señaló " + trabajos + " referencias laborales.");
                $("#laboral2").val(" es quien nos valida referencia laboral.");
                $("#socio1").val(data.candidato + ", actualmente vive en un/una " + vivienda
                  .vivienda + ", con un tiempo de residencia de " + vivienda
                  .tiempo_residencia + ". El nivel de la zona es " + vivienda.zona +
                  ", el mobiliario es de calidad " + calidad + ", la vivienda es " +
                  tamano + " y en condiciones " + vivienda.condiciones);
                $("#socio2").val(
                  "Los gastos generados en el hogar son solventados por _____. Sus referencias vecinales describen que es " +
                  vecinales + ". El candidato cuenta con " + data.muebles + " " +
                  adeudo);
                $("#revisionModal").modal('show');
              }
              if (data.tipo_conclusion == 19) {
                $('.es_conclusion').prop('disabled', true)
                $('.es_conclusion').val('')
                $('#personal1').prop('disabled', false)
                $('#personal2').prop('disabled', false)
                $("#laboral1").prop('disabled', false)
                $("#laboral2").prop('disabled', false)
                $("#socio1").prop('disabled', false)
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, es originario de " + originario +
                  ". Tiene como máximo grado de estudios: " + data.grado +
                  ". Refiere ser " + social.religion + ". Su plan a corto plazo: " +
                  social.corto_plazo + ". Su plan a mediano plazo: " + social
                  .mediano_plazo);
                $("#personal2").val("Refiere " + bebidas + " bebidas alcohólicas " + social
                  .bebidas_frecuencia + ". " + fuma +
                  " Sus referencias personales lo describen como " +
                  refs_comentarios + ".");
                $("#laboral1").val("Señaló " + trabajos + " referencias laborales.");
                $("#laboral2").val(" es quien nos valida referencia laboral.");
                $("#socio1").val(data.candidato + ", actualmente vive en un/una " + vivienda
                  .vivienda + ", con un tiempo de residencia de " + vivienda
                  .tiempo_residencia + ". El nivel de la zona es " + vivienda.zona +
                  ", el mobiliario es de calidad " + calidad + ", la vivienda es " +
                  tamano + " y en condiciones " + vivienda.condiciones +
                  ". El candidato cuenta con " + data.muebles + " " + adeudo);
                $("#revisionModal").modal('show');
              }
              if (data.tipo_conclusion == 10) {
                $('.es_conclusion').prop('disabled', true)
                $('.es_conclusion').val('')
                $('#personal1').prop('disabled', false)
                $('#personal2').prop('disabled', false)
                $("#laboral2").prop('disabled', false)
                $("#socio1").prop('disabled', false)
                $("#socio2").prop('disabled', false)
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, es originario de " + originario +
                  ". Tiene como máximo grado de estudios: " + data.grado + ". Es " +
                  data.estado_civil + " y " + religion);
                $("#personal2").val("Refiere " + bebidas + " bebidas alcohólicas " + social
                  .bebidas_frecuencia + ". " + fuma + ". Refiere ser " + social
                  .religion + ". Su plan a corto plazo: " + social.corto_plazo +
                  ". Su plan a mediano plazo: " + social.mediano_plazo);
                $("#laboral2").val("Indica que tiene trabajando para " + data.cliente +
                  " por " + extra_laboral.actual_activo);
                $("#socio1").val(data.candidato + ", actualmente vive en un/una " + vivienda
                  .vivienda + ", con un tiempo de residencia de " + vivienda
                  .tiempo_residencia + ". El nivel de la zona es " + vivienda.zona +
                  ", el mobiliario es de calidad " + calidad + ", la vivienda es " +
                  tamano + " y en condiciones " + vivienda.condiciones);
                $("#socio2").val(
                  "Los gastos generados en el hogar son solventados por _____. Sus referencias vecinales describen que es " +
                  vecinales + ". El candidato cuenta con " + data.muebles + " " +
                  adeudo);
                $("#revisionModal").modal('show');
              }
              if (data.tipo_conclusion == 15) {
                $("#personal3").prop('disabled', true);
                $("#personal3").val("");
                $("#personal4").prop('disabled', true);
                $("#personal4").val("");
                $("#laboral1").prop('disabled', true);
                $("#laboral1").val("");
                $("#visita1").prop('disabled', true);
                $("#visita1").val("");
                $("#visita2").prop('disabled', true);
                $("#visita2").val("");
                $("#socio1").prop('disabled', true);
                $("#socio1").val("");
                $("#socio2").prop('disabled', true);
                $("#socio2").val("");
                $('#comentario_bgc').prop('disabled', true)
                $('#comentario_bgc').val("");

                $("#personal1").val("C. " + data.candidato + ", de " + data.edad +
                  " años de edad, es " + data.estado_civil + ", reside en " + data
                  .municipio + ", " + data.estado + " " + religion +
                  ". Cuenta con estudios en " + data.grado);
                $("#personal2").val("Menciona " + bebidas + " bebidas alcohólicas y " +
                  fuma + "." + cirugia + ". Su plan a corto plazo es " + social
                  .corto_plazo + "; y su meta a mediano plazo es " + social
                  .mediano_plazo + ".");
                $("#laboral2").val(comentarios_laborales);
                $('#conclusion_investigacion').val(
                  'En la investigación realizada se encontró que el(la) candidato(a) es una persona ________.Le consideramos ' +
                  estatus_final_conclusion + ".")
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 17) {
                $('.es_conclusion').prop('disabled', true)
                $('.es_conclusion').val('')
                // $('#conclusion_investigacion').prop('disabled', false)
                $("#comentario_bgc").prop('disabled', false);
                $("#completarModal").modal('show');
              }
            }
          });
          $('a[id^=reportePDF]', row).bind('click', () => {
            var id = data.id;
            $('#reporteForm' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'El reporte PDF se esta creando y se descargará en breve',
              showConfirmButton: false,
              timer: 2500
            })
          });
          $('a[id^=reportePrevioPDF]', row).bind('click', () => {
            var id = data.id;
            $('#reportePrevioForm' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'El reporte previo PDF se descargará en breve',
              showConfirmButton: false,
              timer: 2500
            })
          });
          $('a[id^=completoPDF]', row).bind('click', () => {
            var id = data.id;
            $('#reporteFormCompleto' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'El reporte PDF se esta creando y se descargará en breve',
              showConfirmButton: false,
              timer: 2500
            })
          });

        }
      });
    },
    error: function(xhr, error, thrown) {
      console.error("Error al cargar los datos:", error, thrown);
      console.error("Respuesta del servidor:", xhr.responseText);
    }
  });
}

function confirmAction(id) {
  // Muestra la alerta de confirmación con SweetAlert
  Swal.fire({
    title: 'Are you sure?',
    text: 'Are you sure you want to send this candidate to the Employee module?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, send it!',
    cancelButtonText: 'No, cancel',
    reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      // Si el usuario confirma, realiza la solicitud AJAX
      var urlFiltrada = '<?php echo API_URL ?>candidato-send/' + id;

      $.ajax({
        url: urlFiltrada,
        method: 'POST', // Asegúrate de usar el método adecuado
        dataType: 'json',
        success: function(data) {
          // Aquí verificamos si la respuesta contiene un éxito o un error
          if (data.success) {
            // Si todo salió bien, mostramos un mensaje de éxito
            Swal.fire({
              title: '¡Éxito!',
              text: 'Candidato procesado correctamente.',
              icon: 'success',
              confirmButtonText: 'Aceptar'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.reload();
              }
            });
          } else {
            // Si no se procesó correctamente, mostramos un mensaje de error
            Swal.fire({
              title: 'Error',
              text: data.error || 'Ocurrió un error al procesar el candidato.',
              icon: 'error',
              confirmButtonText: 'Aceptar'
            });
          }
        },
        error: function(xhr, status, error) {
          // Si ocurre un error en la solicitud AJAX, mostramos el error
          Swal.fire({
            title: 'Error',
            text: 'Hubo un problema con la solicitud. Intenta de nuevo.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
          });
          console.error('Error al realizar la solicitud:', error);
        }
      });
    } else {
      // Si el usuario cancela, no hace nada
      console.log('Acción cancelada');
    }
  });
}






function asignarCandidatoAnalista() {
  var analistas = getAnalistasActivos();
  var candidatos = getCandidatosActivosPorCliente(id);
  setTimeout(function() {
    $('.loader').fadeOut();
  }, 200);
  $('#asignarCandidatoModal').modal('show');
}

function getAnalistasActivos() {
  $.ajax({
    url: '<?php echo base_url('Usuario/getAnalistasActivos'); ?>',
    type: 'POST',
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      if (res != 0) {
        $('#asignar_usuario').html(res);
      }
    }
  });
}

function getCandidatosActivosPorCliente(id_cliente) {
  $.ajax({
    url: '<?php echo base_url('Candidato/getActivosPorCliente'); ?>',
    type: 'POST',
    data: {
      'id_cliente': id_cliente
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      if (res != 0) {
        $('#asignar_candidato').html(res);
      }
    }
  });
}

function nuevoRegistro() {
  var id_cliente = id;
  $.ajax({
    url: '<?php echo base_url('Candidato_Seccion/getHistorialProyectosByCliente'); ?>',
    type: 'POST',
    data: {
      'id_cliente': id_cliente
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      $('#previos').html(res);
    }
  });
  $('#newModal').modal('show');
}

function nuevoRegistroAlterno() {
  let id_cliente = id;
  $.ajax({
    url: '<?php echo base_url('Candidato/getSeccionesPrevias'); ?>',
    type: 'POST',
    data: {
      'id_cliente': id_cliente
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      $('#previos_hcl').html(res);
    }
  });
  $('#hclnewModal').modal('show');
}

function registrar() {
  var id_cliente = '<?php echo $this->uri->segment(3) ?>';
  var datos = new FormData();
  if (id == 159) {
    var centro_costo = $("#centro_costo").val();
    var curp = $('#curp_registro').val();
    var nss = $('#nss_registro').val();
  }
  if (id == 87) {
    var curp = $('#curp_registro').val();
    var nss = $('#nss_registro').val();
  } else {
    var centro_costo = '';
    var curp = '';
    var nss = '';
  }

  datos.append('nombre', $("#nombre_registro").val());
  datos.append('paterno', $("#paterno_registro").val());
  datos.append('materno', $("#materno_registro").val());
  datos.append('celular', $("#celular_registro").val());
  datos.append('subcliente', $("#subcliente").val());
  datos.append('puesto', $("#puesto").val());
  datos.append('pais', $("#pais").val());
  datos.append('previo', $("#previos").val());
  datos.append('proyecto', $("#proyecto_registro").val());
  datos.append('generales', $("#generales_registro").val());
  datos.append('estudios', $("#estudios_registro").val());
  datos.append('empleos', $("#empleos_registro").val());
  datos.append('sociales', $("#sociales_registro").val());
  datos.append('investigacion', $("#investigacion_registro").val());
  datos.append('no_mencionados', $("#no_mencionados_registro").val());
  datos.append('ref_personales', $("#ref_personales_registro").val());
  datos.append('documentacion', $("#documentacion_registro").val());
  datos.append('familiar', $("#familiar_registro").val());
  datos.append('egresos', $("#egresos_registro").val());
  datos.append('habitacion', $("#habitacion_registro").val());
  datos.append('ref_vecinales', $("#ref_vecinales_registro").val());
  datos.append('id_cliente_hidden', id_cliente);
  datos.append('examen', $("#examen_registro").val());
  datos.append('medico', $("#examen_medico").val());
  datos.append('psicometrico', $("#examen_psicometrico").val());
  datos.append('correo', $("#correo_registro").val());
  datos.append('centro_costo', centro_costo);
  datos.append('curp', curp);
  datos.append('nss', nss);
  datos.append('usuario', 1);

  var num_files = document.getElementById('cv').files.length;
  if (num_files > 0) {
    datos.append("hay_cvs", 1);
    for (var x = 0; x < num_files; x++) {
      datos.append("cvs[]", document.getElementById('cv').files[x]);
    }
  } else {
    datos.append("hay_cvs", 0);
  }

  $.ajax({
    url: '<?php echo base_url('Cliente_General/registrar'); ?>',
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
        let credenciales = '';
        $("#newModal").modal('hide')
        recargarTable()
        if (data.credenciales != '') {
          credenciales =
            'Copia las siguientes credenciales del candidato por si se llegan a necesitar: <br><li>' +
            $("#correo_registro").val() + '</li><li>' + data.credenciales + '</li>';
        }
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          html: credenciales,
          width: '50em',
          confirmButtonText: 'Entendido'
        })
        // Swal.fire({
        // 	position: 'center',
        // 	icon: 'success',
        // 	title: data.msg,
        // 	showConfirmButton: false,
        // 	timer: 3500
        // })
      } else {
        $("#newModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

function registrarAlterno() {
  //var id_cliente = 2;
  var correo = $("#correo_registro_hcl").val();
  var datos = new FormData();
  datos.append('correo', correo);
  datos.append('nombre', $("#nombre_registro_hcl").val());
  datos.append('paterno', $("#paterno_registro_hcl").val());
  datos.append('materno', $("#materno_registro_hcl").val());
  datos.append('celular', $("#celular_registro_hcl").val());
  datos.append('pais_previo', $("#pais_previo_hcl").val());
  datos.append('previo', $("#previos_hcl").val());
  datos.append('region', $("#region_hcl").val());
  datos.append('pais', $("#pais_registro_hcl").val());
  datos.append('proyecto', $("#proyecto_registro_hcl").val());
  datos.append('empleos', $("#empleos_registro_hcl").val());
  datos.append('empleos_tiempo', $("#empleos_tiempo_registro_hcl").val());
  datos.append('criminal', $("#criminal_registro_hcl").val());
  datos.append('criminal_tiempo', $("#criminal_tiempo_registro_hcl").val());
  datos.append('domicilios', $("#domicilios_registro_hcl").val());
  datos.append('domicilios_tiempo', $("#domicilios_tiempo_registro_hcl").val());
  datos.append('estudios', $("#estudios_registro_hcl").val());
  datos.append('identidad', $("#identidad_registro_hcl").val());
  datos.append('global', $("#global_registro_hcl").val());
  datos.append('ref_profesionales', $("#ref_profesionales_registro_hcl").val());
  datos.append('ref_personales', $("#ref_personales_registro_hcl").val());
  datos.append('credito', $("#credito_registro_hcl").val());
  datos.append('credito_tiempo', $("#credito_tiempo_registro_hcl").val());
  datos.append('id_cliente', id);
  datos.append('examen', $("#examen_registro_hcl").val());
  datos.append('medico', $("#examen_medico_hcl").val());
  datos.append('opcion', $("#opcion_registro_hcl").val());
  datos.append('migracion', $("#migracion_registro_hcl").val());
  datos.append('prohibited', $("#prohibited_registro_hcl").val());
  datos.append('curp', $("#curp_registro_hcl").val());
  datos.append('ref_academicas', $("#ref_academicas_registro_hcl").val());
  datos.append('mvr', $("#mvr_registro_hcl").val());
  datos.append('usuario', 1);
  for (var i = 0; i < extras.length; i++) {
    datos.append('extras[]', extras[i]);
  }
  $.ajax({
    url: '<?php echo base_url('Client/registrar'); ?>',
    type: 'POST',
    async: false,
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
        $("#hclnewModal").modal('hide')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'The candidate has successfully registered',
          showConfirmButton: false,
          timer: 2500
        })
      }
      if (data.codigo === 3) {
        $("#hclnewModal").modal('hide');
        recargarTable();
        $("#user").text(correo);
        $("#contrasena").text(data.msg);
        $("#respuesta_mail").text(
          "* El correo no pudo ser enviado, mandar las credenciales del candidato de forma manual."
        );
        $("#passModal").modal('show');
        Swal.fire({
          position: 'center',
          icon: 'warning',
          title: 'Se ha guardado correctamente pero hubo un problema al enviar el correo',
          showConfirmButton: false,
          timer: 2500
        })
      }
      if (data.codigo === 4) {
        $("#hclnewModal").modal('hide');
        recargarTable();
        $("#user").text(correo);
        $("#contrasena").text(data.msg);
        $("#respuesta_mail").text(
          "* Un correo ha sido enviado al candidato con sus nuevas credenciales. Este correo puede demorar algunos minutos."
        );
        $("#passModal").modal('show');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha guardado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      }
      if (data.codigo === 0 || data.codigo === 2) {
        $("#hclnewModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

function eliminarExtra(id_tipo_documento, txt) {
  for (var i = 0; i < extras.length; i++) {
    if (extras[i] == id_tipo_documento) {
      extras.splice(i, 1);
    }
  }
  $("#div_extra" + id_tipo_documento).remove();
  $('#extra_registro_hcl').append($('<option></option>').attr('value', id_tipo_documento).text(txt));
}

function registrarCandidatoBeca() {
  var id_cliente = '<?php echo $this->uri->segment(3) ?>';
  let datos = new FormData()
  datos.append('nombre', $("#nombre_beca").val());
  datos.append('paterno', $("#paterno_beca").val());
  datos.append('materno', $("#materno_beca").val());
  datos.append('celular', $("#celular_beca").val());
  datos.append('subcliente', $("#subcliente_beca").val());
  datos.append('id_cliente', id_cliente);
  datos.append('correo', $("#correo_beca").val());
  datos.append('usuario', 1);

  $.ajax({
    url: '<?php echo base_url('Candidato/registroTipoBeca'); ?>',
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
        $("#registroCandidatoBecaModal").modal('hide')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 3500
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema al enviar el formulario',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}

function AsignarCandidato() {
  var id_candidato = $("#asignar_candidato").val();
  var id_usuario = $("#asignar_usuario").val();

  $.ajax({
    url: '<?php echo base_url('Candidato/reasignarCandidatoAnalista'); ?>',
    method: 'POST',
    data: {
      'id_candidato': id_candidato,
      'id_usuario': id_usuario
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
        $("#asignarCandidatoModal").modal('hide')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha reasignado el candidato correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        $("#asignarCandidatoModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

function guardarDatosContacto() {
  var datos = new FormData();
  datos.append('nombre', $("#nombre_contacto").val());
  datos.append('paterno', $("#paterno_contacto").val());
  datos.append('materno', $("#materno_contacto").val());
  datos.append('celular', $("#celular_contacto").val());
  datos.append('tel_casa', $("#tel_casa_contacto").val());
  datos.append('correo', $("#correo_contacto").val());
  datos.append('id_candidato', $("#idCandidato").val());

  $.ajax({
    url: '<?php echo base_url('Candidato/setContacto'); ?>',
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
        $("#contactoModal").modal('hide')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Datos de contacto actualizados correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema al enviar el formulario',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}

function subirExamenMedico() {
  var docs = new FormData();
  var archivo = $("#doc_medico")[0].files[0];
  docs.append("id_candidato", $("#idCandidato").val());
  docs.append("archivo", archivo);
  $.ajax({
    url: "<?php echo base_url('Medico/subirExamenMedico'); ?>",
    method: "POST",
    data: docs,
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
        recargarTable()
        $("#medicoModal").modal('hide')
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha subido correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema al enviar el formulario',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}

function actualizarChecklist() {
  let datos = $('#formChecklist').serialize()
  datos += '&id_candidato=' + $("#idCandidato").val()
  $.ajax({
    url: '<?php echo base_url('Candidato_Conclusion/edit_checklist'); ?>',
    type: 'POST',
    data: datos,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      recargarTable();
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      var data = JSON.parse(res);
      if (data.codigo === 1) {
        $("#checklistModal").modal('hide')
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Checklist actualizado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema al enviar el formulario',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}

function getIntegrantesFamiliares(id, ingles) {
  let valores = '';
  let scripts = '';
  let opciones = '';
  let idiomaCliente = (ingles == 1) ? 'ingles' : 'espanol'
  let url_parentescos = '<?php echo base_url('Funciones/getParentescos'); ?>';
  let parentescos_data = getDataCatalogo(url_parentescos, 'id', 1, idiomaCliente);
  let url_escolaridad = '<?php echo base_url('Funciones/getEscolaridades'); ?>';
  let escolaridades_data = getDataCatalogo(url_escolaridad, 'id', 0, 'espanol');
  let url_civiles = '<?php echo base_url('Funciones/getCiviles'); ?>';
  let civiles_data = getDataCatalogo(url_civiles, 'nombre', 0, 'espanol', idiomaCliente);
  $.ajax({
    url: '<?php echo base_url('Candidato_Familiar/getById'); ?>',
    method: 'POST',
    data: {
      'id': id
    },
    async: false,
    success: function(res) {
      if (res != 0) {
        valores = JSON.parse(res);
      }
    }
  });
  $.ajax({
    url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
    method: 'POST',
    data: {
      'id_seccion': 35,
      'tipo_orden': 'orden_front'
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      if (res != 0) {
        var dato = JSON.parse(res);
        let totalFamiliares = valores.length;
        for (let number = 0; number < valores.length; number++) {
          $('#rowFamiliares').append(
            '<div class="alert alert-info btn-block"><h5 class="text-center">Familiar #' +
            totalFamiliares + '</h5></div><br>');
          //for(let i = 0; i < dato.length; i++){
          for (let tag of dato) {
            let referencia = tag['referencia'];
            if (referencia == 'id_tipo_parentesco')
              opciones = parentescos_data;
            if (referencia == 'estado_civil')
              opciones = civiles_data;
            if (referencia == 'id_grado_estudio')
              opciones = escolaridades_data;
            if (referencia == 'misma_vivienda' || referencia == 'adeudo')
              opciones = '<option value="0">No</option><option value="1">Sí</option>';

            if (tag['tipo_etiqueta'] == 'select') {
              $('#rowFamiliares').append(tag['grid_col_inicio'] + tag['label'] + tag[
                'etiqueta_inicio'] + opciones + tag['etiqueta_cierre'] + tag[
                'grid_col_cierre']);
            }
            if (tag['tipo_etiqueta'] == 'input') {
              $('#rowFamiliares').append(tag['titulo_seccion_modal'] + tag[
                'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] + tag[
                'etiqueta_cierre'] + tag['grid_col_cierre']);
            }
            if (tag['tipo_etiqueta'] == 'textarea') {
              $('#rowFamiliares').append(tag['grid_col_inicio'] + tag['label'] + tag[
                'etiqueta_inicio'] + tag['etiqueta_cierre'] + tag[
                'grid_col_cierre']);
            }
          }
          //* Boton Guardar
          $('#rowFamiliares').append(
            '<div class="col-md-6 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-primary btn-block" onclick="guardarIntegranteFamiliar(' +
            valores[number]['id'] + ',' + number + ',' + valores[number]['id_candidato'] +
            ')">Actualizar Integrante #' + totalFamiliares +
            '</a></div><div class="col-md-6 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-danger btn-block" onclick="mostrarMensajeConfirmacion(\'eliminar integrante familiar\', ' +
            valores[number]['id'] + ', \'' + valores[number]['nombre'] +
            '\')">Eliminar Integrante #' + totalFamiliares + '</a></div>');

          //}
          //$('#rowFamiliares').append(scripts);
          totalFamiliares--;
        }
        //* Values
        if (valores != 0) {
          var index = 0;
          for (let valor of valores) {
            for (let tag of dato) {
              $('[name="' + tag['atr_id'] + '[]"]').eq(index).addClass('fam' + index);
              $('[name="' + tag['atr_id'] + '[]"]').eq(index).val(valor[tag['referencia']]);
            }
            index++;
          }
        } else {
          $('#rowFamiliares').append(
            '<div class="col-12 text-center mt-5"><h4 class="">No hay familiares registrados</h4></div>'
          );
        }
      } else {
        $('#rowFamiliares').html(
          '<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>'
        );
      }
      $("#familiaresModal").modal('show');
    }
  });
}

function nuevoFamiliar() {
  let id_candidato = $('#idCandidato').val();
  let opciones = '';
  //let idiomaCliente = (data.ingles == 1) ? 'ingles' : 'espanol'
  let url_parentescos = '<?php echo base_url('Funciones/getParentescos'); ?>';
  let parentescos_data = getDataCatalogo(url_parentescos, 'id', 1, 'espanol');
  let url_escolaridad = '<?php echo base_url('Funciones/getEscolaridades'); ?>';
  let escolaridades_data = getDataCatalogo(url_escolaridad, 'id', 0, 'espanol');
  let url_civiles = '<?php echo base_url('Funciones/getCiviles'); ?>';
  let civiles_data = getDataCatalogo(url_civiles, 'nombre', 0, 'espanol');
  $('#rowNuevoFamiliar').empty();
  $.ajax({
    url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
    method: 'POST',
    data: {
      'id_seccion': 35,
      'tipo_orden': 'orden_front'
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $("#familiaresModal").modal('hide');
        $('.loader').fadeOut();
        if (res != 0) {
          var dato = JSON.parse(res);
          for (let tag of dato) {
            let referencia = tag['referencia'];
            if (referencia == 'id_tipo_parentesco')
              opciones = parentescos_data;
            if (referencia == 'estado_civil')
              opciones = civiles_data;
            if (referencia == 'id_grado_estudio')
              opciones = escolaridades_data;
            if (referencia == 'misma_vivienda' || referencia == 'adeudo')
              opciones = '<option value="0">No</option><option value="1">Sí</option>';

            if (tag['tipo_etiqueta'] == 'select') {
              $('#rowNuevoFamiliar').append(tag['grid_col_inicio'] + tag['label'] +
                tag['etiqueta_inicio'] + opciones + tag['etiqueta_cierre'] +
                tag['grid_col_cierre']);
            }
            if (tag['tipo_etiqueta'] == 'input') {
              $('#rowNuevoFamiliar').append(tag['titulo_seccion_modal'] + tag[
                  'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                tag['etiqueta_cierre'] + tag['grid_col_cierre']);
            }
            if (tag['tipo_etiqueta'] == 'textarea') {
              $('#rowNuevoFamiliar').append(tag['grid_col_inicio'] + tag['label'] +
                tag['etiqueta_inicio'] + tag['etiqueta_cierre'] + tag[
                  'grid_col_cierre']);
            }
          }
          //* Boton Guardar
          $('#rowNuevoFamiliar').append(
            '<div class="col-12 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-success btn-lg btn-block" onclick="guardarIntegranteFamiliar(0,0,' +
            id_candidato +
            ')"><i class="fas fa-plus-circle"></i> Registrar</a></div></div>');
        } else {
          $('#rowNuevoFamiliar').html(
            '<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>'
          );
        }
      }, 200);
      $("#nuevoFamiliarModal").modal('show');
    }
  });
}

function guardarIntegranteFamiliar(id_familiar, num_familiar, idCandidato) {
  var campos = '';
  $.ajax({
    url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
    method: 'POST',
    data: {
      'id_seccion': 35,
      'tipo_orden': 'orden_front'
    },
    async: false,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      if (res != 0) {
        campos = JSON.parse(res);
      }
    }
  });
  let objeto = new Object();
  for (let tag of campos) {
    let param = tag['atr_id'];
    objeto[tag['atr_id']] = $('[name="' + tag['atr_id'] + '[]"]').eq(num_familiar).val();
  }
  let datos = $.param(objeto);
  datos += '&id_candidato=' + $("#idCandidato").val();
  datos += '&id_seccion=' + $("#idSeccion").val();
  datos += '&id_familiar=' + id_familiar;
  datos += '&num=' + num_familiar;

  $.ajax({
    url: '<?php echo base_url('Candidato_Familiar/set'); ?>',
    type: 'POST',
    data: datos,
    async: false,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      var data = JSON.parse(res);
      if (id_familiar != 0) {
        var textoResponse = 'Integrante familiar actualizado correctamente';
      } else {
        var textoResponse = 'Integrante familiar guardado correctamente';
        $('#rowNuevoFamiliar').empty();
        $("#nuevoFamiliarModal").modal('hide');
        getIntegrantesFamiliares(idCandidato);
      }
      if (data.codigo === 1) {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: textoResponse,
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema al enviar el formulario',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}

function eliminarIntegranteFamiliar(id_familiar, candidato) {
  var id_candidato = $('#idCandidato').val();
  var datos = new FormData();
  datos.append('id_candidato', id_candidato);
  datos.append('id_familiar', id_familiar);

  $.ajax({
    url: '<?php echo base_url('Candidato_Familiar/delete'); ?>',
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
        $('#mensajeModal').modal('hide');
        getIntegrantesFamiliares(id_candidato);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Integrante familiar eliminado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      }
    }
  });
}






function nuevoDomicilio(id_candidato, id_seccion) {
  let opciones = '';
  //let idiomaCliente = (data.ingles == 1) ? 'ingles' : 'espanol'
  let url_estados = '<?php echo base_url('Funciones/getEstados'); ?>';
  let estados_data = getDataCatalogo(url_estados, 'id', 0, 'espanol');
  let url_paises = '<?php echo base_url('Funciones/getPaises'); ?>';
  let paises_data = getDataCatalogo(url_paises, 'nombre', 0, 'ingles');
  $('#rowNuevoItemForm').empty();
  $.ajax({
    url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
    method: 'POST',
    data: {
      'id_seccion': id_seccion,
      'tipo_orden': 'orden_front'
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $("#formModal").modal('hide');
        $('.loader').fadeOut();
        if (res != 0) {
          var dato = JSON.parse(res);
          for (let tag of dato) {
            let referencia = tag['referencia'];
            if (referencia == 'id_estado')
              opciones = estados_data;
            if (referencia == 'pais')
              opciones = paises_data;

            if (tag['tipo_etiqueta'] == 'select') {
              $('#rowNuevoItemForm').append(tag['grid_col_inicio'] + tag['label'] +
                tag['etiqueta_inicio'] + opciones + tag['etiqueta_cierre'] +
                tag['grid_col_cierre']);
            }
            if (tag['tipo_etiqueta'] == 'input') {
              $('#rowNuevoItemForm').append(tag['titulo_seccion_modal'] + tag[
                  'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                tag['etiqueta_cierre'] + tag['grid_col_cierre']);
            }
            if (tag['tipo_etiqueta'] == 'textarea') {
              $('#rowNuevoItemForm').append(tag['grid_col_inicio'] + tag['label'] +
                tag['etiqueta_inicio'] + tag['etiqueta_cierre'] + tag[
                  'grid_col_cierre']);
            }

            //* Funciones
            if (tag['referencia'] == 'id_estado') {
              $('#rowNuevoItemForm').append(
                '<script>$("#id_estado").change(function(){getMunicipios($("#id_estado").val(), "#id_municipio", "")})<\/script>'
              );
            }
            if (referencia == 'id_municipio') {
              $('#id_municipio').empty();
              $('#id_municipio').append('<option value="">Selecciona</option>')
            }
            if (tag['referencia'] == 'pais') {
              $('#' + tag['atr_id']).val('México')
            }
          }
          //* Boton Guardar
          $('#rowNuevoItemForm').append(
            '<div class="col-12 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-success btn-lg btn-block" onclick="guardarDomicilio(0,0,' +
            id_candidato + ',' + id_seccion +
            ')"><i class="fas fa-plus-circle"></i> Registrar</a></div></div>');
        } else {
          $('#rowNuevoItemForm').html(
            '<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>'
          );
        }
      }, 200);

      $('#titleItemForm').html('Registro de domicilio')
      $("#nuevoItemModal").modal('show');
    }
  });
}

function guardarDomicilio(id_domicilio, num_domicilio, idCandidato, id_seccion) {
  var campos = '';
  $.ajax({
    url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
    method: 'POST',
    data: {
      'id_seccion': id_seccion,
      'tipo_orden': 'orden_front'
    },
    async: false,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      if (res != 0) {
        campos = JSON.parse(res);
      }
    }
  });
  let objeto = new Object();
  for (let tag of campos) {
    let param = tag['atr_id'];
    objeto[tag['atr_id']] = $('[name="' + tag['atr_id'] + '[]"]').eq(num_domicilio).val();
  }
  let datos = $.param(objeto);
  datos += '&id_candidato=' + $("#idCandidato").val();
  datos += '&id_seccion=' + $("#idSeccion").val();
  datos += '&id_domicilio=' + id_domicilio;
  datos += '&num=' + num_domicilio;

  $.ajax({
    url: '<?php echo base_url('Domicilio/store'); ?>',
    type: 'POST',
    data: datos,
    async: false,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      var data = JSON.parse(res);
      if (id_domicilio == 0) {
        $('#rowNuevoItemForm').empty();
        $("#nuevoItemModal").modal('hide');
        getHistorialDomicilios(idCandidato, id_seccion)
      }
      if (data.codigo === 1) {
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
          title: 'Hubo un problema al enviar el formulario',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}

function guardarExtraLaboral() {
  let datos = $('#formExtraLaboral').serialize();
  datos += '&id_candidato=' + $("#idCandidato").val();
  datos += '&id_seccion=' + $("#idSeccion").val();

  $.ajax({
    url: '<?php echo base_url('Candidato_Laboral/setExtras'); ?>',
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
        $("#extraLaboralModal").modal('hide')
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Información extra laboral actualizada correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema al enviar el formulario',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}

function subirArchivo(tipoArchivo, id_candidato, id_psicometrico) {
  var docs = new FormData();
  var archivo = $("#archivo")[0].files[0];
  docs.append("tipoArchivo", tipoArchivo);
  docs.append("id_candidato", id_candidato);
  docs.append("id_archivo", id_psicometrico);
  docs.append("archivo", archivo);
  $.ajax({
    url: "<?php echo base_url('Documentacion/subirArchivo'); ?>",
    method: "POST",
    data: docs,
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
        $("#subirArchivoModal").modal('hide');
        if (tipoArchivo == 'beca') {
          registrarFechaFinal(id_candidato)
        }
        recargarTable();
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
          title: 'Hubo un problema al subir el archivo, intentalo más tarde',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}

function eliminarRefPersonal(num, id) {
  var datos = new FormData();
  datos.append('id_candidato', $("#idCandidato").val());
  datos.append('id', id);
  $.ajax({
    url: '<?php echo base_url('Candidato_Ref_Personal/delete'); ?>',
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
        $('#formModal').modal('hide');
        $('#mensajeModal').modal('hide');
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

function eliminarRefVecinal(num, id) {
  var datos = new FormData();
  datos.append('id_candidato', $("#idCandidato").val());
  datos.append('id', id);
  $.ajax({
    url: '<?php echo base_url('Candidato_Ref_Vecinal/delete'); ?>',
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
        $('#formModal').modal('hide');
        $('#mensajeModal').modal('hide');
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

function eliminarRefCliente(num, id) {
  var datos = new FormData();
  datos.append('id_candidato', $("#idCandidato").val());
  datos.append('id', id);
  $.ajax({
    url: '<?php echo base_url('ReferenciaCliente/delete'); ?>',
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
        $('#formModal').modal('hide');
        $('#mensajeModal').modal('hide');
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

function getHistorialLaboral(id, id_seccion) {
  let valores = '';
  let valores2 = '';
  let scripts = '';
  let opciones = '';
  let botones_collapse_menu = '';
  let autor_anterior = '';
  let candidato = $('#nombreCandidato').val();
  // let url_estados = '<?php //echo base_url('Funciones/getEstados'); ?>'; let estados_data = getDataCatalogo(url_estados, 'id', 0,'espanol');
  // let url_paises = '<?php  //echo base_url('Funciones/getPaises'); ?>'; let paises_data = getDataCatalogo(url_paises, 'nombre', 0,'espanol');
  if (id_seccion == 16 || id_seccion == 32 || id_seccion == 59 || id_seccion == 90) {
    $.ajax({
      url: '<?php echo base_url('Candidato_Laboral/getHistorialLaboralById'); ?>',
      method: 'POST',
      data: {
        'id': id,
        'id_seccion': id_seccion
      },
      async: false,
      success: function(res) {
        if (res != 0) {
          valores = JSON.parse(res);
        }
      }
    });
    $.ajax({
      url: '<?php echo base_url('Candidato_Laboral/getVerificacionLaboralById'); ?>',
      method: 'POST',
      data: {
        'id': id,
        'id_seccion': id_seccion
      },
      async: false,
      success: function(res) {
        if (res != 0) {
          valores2 = JSON.parse(res);
        }
      }
    });

    $('#rowHistorialLaboral').empty();
    if (valores != 0 || valores2 != 0) {
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {
          'id_seccion': id_seccion,
          'tipo_orden': 'orden_front'
        },
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          if (res != 0) {
            var dato = JSON.parse(res);
            //let cantidad_valores = (valores.length > 0)? valores.length : 1;
            $('#cantidadHistorialLaboral').val(30);
            // //* Boton nueva laboral
            // let botonNuevo = '<button type="button" class="floating-button-new" data-toggle="tooltip" data-placement="left" title="Agregar laboral" onclick="agregarLaboral()"><i class="fas fa-plus-circle"></i></button>';
            // $('#rowHistorialLaboral').append(botonNuevo);
            //* Menu lateral para navegar entre las laborales
            let menu = '<nav class="floating-menu"><ul class="main-menu">';
            for (let i = 1; i <= 30; i++) {
              menu += '<li id="itemMenu' + i +
                '" data-toggle="tooltip" data-placement="left" title="Ir a la Laboral #' +
                i + '"><a class="ripple" href="#topLaboral' + i + '"><b>#' + i +
                '</b></a></li>';
            }
            menu += '<div class="menu-bg"></div></ul></nav>';
            menu +=
              '<a class="btn-success btn-return" data-toggle="tooltip" data-placement="left" title="Regresar al listado" onclick="regresarListado()"><i class="fas fa-arrow-left"></i></a>';

            $('#rowHistorialLaboral').append(menu);

            for (let number = 0; number < 30; number++) {
              $('#rowHistorialLaboral').append(
                '<div class="col-12 mt-5"><div class="text-center" id="topLaboral' + (
                  number + 1) + '"><h3 class="text-primary"><strong>Laboral #' + (
                  number + 1) + '</strong></h3><br></div></div>');
              for (let tag of dato) {
                //* Boton por autor del registro del campo
                if (autor_anterior != '' && tag['autor'] != autor_anterior) {
                  //* Boton Guardar y Borrar
                  $('#rowHistorialLaboral').append(
                    '<div class="col-12"></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnGuardarLaboral' +
                    (number + 1) +
                    '" class="btn btn-success btn-block" onclick="guardarLaboral(0,' +
                    number + ',' + id + ',\'candidato\',\'' + candidato +
                    '\')">Guardar Laboral #' + (number + 1) +
                    '</button></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnEliminarLaboral' +
                    (number + 1) +
                    '" class="btn btn-danger btn-block" disabled>Eliminar Laboral #' +
                    (number + 1) + '</button></div>');
                  autor_anterior = tag['autor'];
                }
                if (autor_anterior == '' || tag['autor'] == autor_anterior) {
                  autor_anterior = tag['autor'];
                }
                if (id_seccion == 16 || id_seccion == 59) {
                  //* Opciones Select
                  if (tag['referencia'] == 'responsabilidad' || tag['referencia'] ==
                    'iniciativa' || tag['referencia'] == 'eficiencia' || tag[
                      'referencia'] == 'disciplina' || tag['referencia'] ==
                    'puntualidad' || tag['referencia'] == 'limpieza' || tag[
                      'referencia'] == 'estabilidad' || tag['referencia'] ==
                    'emocional' || tag['referencia'] == 'honestidad' || tag[
                      'referencia'] == 'rendimiento' || tag['referencia'] == 'actitud'
                  ) {
                    opciones =
                      '<option value="">Selecciona</option><option value="Not provided">Not provided</option><option value="Excellent">Excellent</option><option value="Good">Good</option><option value="Regular">Regular</option><option value="Bad">Bad</option><option value="Very Bad">Very Bad</option>';
                  }
                  if (tag['referencia'] == 'demanda' || tag['referencia'] ==
                    'recontratacion') {
                    opciones =
                      '<option value="0">No</option><option value="1">Sí</option>';
                  }
                }
                //* HTML
                if (tag['tipo_etiqueta'] == 'select') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    opciones + tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                if (tag['tipo_etiqueta'] == 'input') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                if (tag['tipo_etiqueta'] == 'textarea') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                //* Clase esLaboral* para contemplar todos los campos de cada iteracion
                $('[name="' + tag['atr_id'] + '[]"]').eq(number).addClass('esLaboral' + (
                  number + 1));
                if (id_seccion == 16 || id_seccion == 59) {
                  //* Clase esLaboral* para contemplar todos los campos de cada iteracion
                  if (tag['referencia'] == 'responsabilidad' || tag['referencia'] ==
                    'iniciativa' || tag['referencia'] == 'eficiencia' || tag[
                      'referencia'] == 'disciplina' || tag['referencia'] ==
                    'puntualidad' || tag['referencia'] == 'limpieza' || tag[
                      'referencia'] == 'estabilidad' || tag['referencia'] ==
                    'emocional' || tag['referencia'] == 'honestidad' || tag[
                      'referencia'] == 'rendimiento' || tag['referencia'] == 'actitud'
                  ) {
                    $('[name="' + tag['atr_id'] + '[]"]').eq(number).addClass(
                      'esAplicable' + (number + 1));
                  }
                  //* Dropdown para aplicar una misma opcion en multiples select
                  if (tag['referencia'] == 'demanda' && tag['autor'] == 'analista') {
                    $('#rowHistorialLaboral').append(
                      '<div class="col-10"></div><div class="col-3 offset-4 text-center"><label>Aplicar a todo</label><select class="form-control" id="aplicar_todo' +
                      (number + 1) +
                      '"><option value="">Selecciona</option><option value="Not provided">Not provided</option><option value="Excellent">Excellent</option><option value="Good">Good</option><option value="Regular">Regular</option><option value="Bad">Bad</option><option value="Very Bad">Very Bad</option></select><br></div><div class="col-5"></div>'
                    );
                    $('#rowHistorialLaboral').append('<script>$("#aplicar_todo' + (
                        number + 1) +
                      '").change(function(){var valor = $(this).val();$(".esAplicable' +
                      (number + 1) + '").val(valor)});<\/script>');
                  }
                }
              }
              //* Boton Guardar
              $('#rowHistorialLaboral').append(
                '<div class="col-12"></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnGuardarVerificacion' +
                (number + 1) +
                '" class="btn btn-success btn-block" onclick="guardarLaboral(0,' +
                number + ',' + id + ',\'analista\',\'' + candidato +
                '\')">Guardar Verificación #' + (number + 1) +
                '</button></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnEliminarVerificacion' +
                (number + 1) +
                '" class="btn btn-danger btn-block" disabled>Eliminar Verificacion #' +
                (number + 1) + '</button></div>');
              //* Reinicio de boton por autor del registro del campo
              autor_anterior = '';
            }
            //* Valores de laboral por el candidato
            if (valores != 0) {
              var index = 0;
              let idLaboral = 0;
              let flag = 0;
              for (let valor of valores) {
                flag = 0;
                for (let tag of dato) {
                  if (tag['autor'] == 'candidato')
                    $('[name="' + tag['atr_id'] + '[]"]').eq(index).val(valor[tag[
                      'referencia']]);
                  if (flag == 0) {
                    idLaboral = valor['id'];
                    flag++;
                  }
                }
                $('#itemMenu' + (index + 1)).css({
                  'background-color': '#1cc88a'
                });
                $('#btnGuardarLaboral' + (index + 1)).removeAttr('onclick');
                $('#btnGuardarLaboral' + (index + 1)).attr("onclick", "guardarLaboral(" +
                  idLaboral + "," + index + "," + id + ",\"candidato\",\"" +
                  candidato + "\")");
                $('#btnEliminarLaboral' + (index + 1)).removeAttr('disabled');
                $('#btnEliminarLaboral' + (index + 1)).attr("onclick",
                  "mostrarMensajeConfirmacion(\"eliminar laboral\"," + idLaboral +
                  "," + index + ")");
                index++;
              }
            }
            //* Valores de laboral por analista
            if (valores2 != 0) {
              var index = 0;
              let idVerificacion = 0;
              let flag = 0;
              let numeroReferenciaActual = 1;
              let indiceInput = 0;
              for (let valor2 of valores2) {
                flag = 0;
                for (let tag of dato) {
                  if (tag['autor'] == 'analista')
                    $('[name="' + tag['atr_id'] + '[]"]').eq((valor2[
                      'numero_referencia'] - 1)).val(valor2[tag['referencia']]);
                  if (flag == 0) {
                    idVerificacion = valor2['id'];
                    flag++;
                  }
                }
                if (valor2['numero_referencia'] > numeroReferenciaActual) {
                  fila = (valor2['numero_referencia'])
                  indiceInput = ((valor2['numero_referencia']) - 1)
                }
                if (valor2['numero_referencia'] == numeroReferenciaActual) {
                  fila = (index + 1)
                  indiceInput = index
                }
                $('#itemMenu' + valor2['numero_referencia']).css({
                  'background-color': '#1cc88a'
                });
                $('#btnGuardarVerificacion' + fila).removeAttr('onclick');
                $('#btnGuardarVerificacion' + fila).attr("onclick", "guardarLaboral(" +
                  idVerificacion + "," + indiceInput + "," + id + ",\"analista\",\"" +
                  candidato + "\")");
                $('#btnEliminarVerificacion' + valor2['numero_referencia']).removeAttr(
                  'disabled');
                $('#btnEliminarVerificacion' + valor2['numero_referencia']).attr("onclick",
                  "mostrarMensajeConfirmacion(\"eliminar verificacion laboral\"," +
                  idVerificacion + "," + (valor2['numero_referencia'] - 1) + ")");
                index++;
                numeroReferenciaActual++
              }
            }
          } else {
            $('#rowHistorialLaboral').html(
              '<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>'
            );
          }
          $("#listado").css('display', 'none');
          $("#btn_nuevo").css('display', 'none');
          $("#btn_asignacion").css('display', 'none');
          $("#formulario").css('display', 'block');
          $("#btn_regresar").css('display', 'block');
        }
      });
    } else {
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {
          'id_seccion': id_seccion,
          'tipo_orden': 'orden_front'
        },
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          if (res != 0) {
            var dato = JSON.parse(res);
            $('#cantidadHistorialLaboral').val(1);
            // //* Boton nueva laboral
            // let botonNuevo = '<button type="button" class="floating-button-new" data-toggle="tooltip" data-placement="left" title="Agregar laboral" onclick="agregarLaboral()"><i class="fas fa-plus-circle"></i></button>';
            // $('#rowHistorialLaboral').append(botonNuevo);
            //* Menu lateral para navegar entre las laborales
            let menu =
              '<nav class="floating-menu" data-toggle="tooltip" data-placement="left" title="Menu de laborales"><ul class="main-menu">';
            for (let i = 1; i <= 1; i++) {
              menu += '<li><a class="ripple" href="#topLaboral' + i + '"><b>#' + i +
                '</b></a></li>';
            }
            menu += '<div class="menu-bg"></div></ul></nav>';
            menu +=
              '<a class="btn-success btn-return" data-toggle="tooltip" data-placement="left" title="Regresar al listado" onclick="regresarListado()"><i class="fas fa-arrow-left"></i></a>';

            $('#rowHistorialLaboral').append(menu);

            for (let number = 0; number < 1; number++) {
              $('#rowHistorialLaboral').append(
                '<div class="col-12 mt-5"><div class="text-center" id="topLaboral' + (
                  number + 1) + '"><h4 class="text-primary"><strong>Laboral #' + (
                  number + 1) + '</strong></h4><br></div></div>');
              for (let tag of dato) {
                //* Boton por autor del registro del campo
                if (autor_anterior != '' && tag['autor'] != autor_anterior) {
                  //* Boton Guardar
                  $('#rowHistorialLaboral').append(
                    '<div class="col-12 mt-3 mb-5"><a href="javascript:void(0)" id="btnGuardarLaboral' +
                    (number + 1) +
                    '" class="btn btn-success btn-block" onclick="guardarLaboral(0,' +
                    number + ',' + id + ',\'candidato\',\'' + candidato +
                    '\')">Guardar Laboral #' + (number + 1) + '</a></div>');
                  autor_anterior = tag['autor'];
                }
                if (autor_anterior == '' || tag['autor'] == autor_anterior) {
                  autor_anterior = tag['autor'];
                }
                if (id_seccion == 59) {
                  //* Opciones Select
                  if (tag['referencia'] == 'responsabilidad' || tag['referencia'] ==
                    'iniciativa' || tag['referencia'] == 'eficiencia' || tag[
                      'referencia'] == 'disciplina' || tag['referencia'] ==
                    'puntualidad' || tag['referencia'] == 'limpieza' || tag[
                      'referencia'] == 'estabilidad' || tag['referencia'] ==
                    'emocional' || tag['referencia'] == 'honestidad' || tag[
                      'referencia'] == 'rendimiento' || tag['referencia'] == 'actitud'
                  ) {
                    opciones =
                      '<option value="">Selecciona</option><option value="Not provided">Not provided</option><option value="Excellent">Excellent</option><option value="Good">Good</option><option value="Regular">Regular</option><option value="Bad">Bad</option><option value="Very Bad">Very Bad</option>';
                  }
                  if (tag['referencia'] == 'demanda' || tag['referencia'] ==
                    'recontratacion') {
                    opciones =
                      '<option value="0">No</option><option value="1">Sí</option>';
                  }
                }
                //* HTML
                if (tag['tipo_etiqueta'] == 'select') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    opciones + tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                if (tag['tipo_etiqueta'] == 'input') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                if (tag['tipo_etiqueta'] == 'textarea') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                $('[name="' + tag['atr_id'] + '[]"]').eq(number).addClass('esLaboral' + (
                  number + 1));
                if (id_seccion == 16 || id_seccion == 59) {
                  //* Clase esLaboral* para contemplar todos los campos de cada iteracion
                  if (tag['referencia'] == 'responsabilidad' || tag['referencia'] ==
                    'iniciativa' || tag['referencia'] == 'eficiencia' || tag[
                      'referencia'] == 'disciplina' || tag['referencia'] ==
                    'puntualidad' || tag['referencia'] == 'limpieza' || tag[
                      'referencia'] == 'estabilidad' || tag['referencia'] ==
                    'emocional' || tag['referencia'] == 'honestidad' || tag[
                      'referencia'] == 'rendimiento' || tag['referencia'] == 'actitud'
                  ) {
                    $('[name="' + tag['atr_id'] + '[]"]').eq(number).addClass(
                      'esAplicable' + (number + 1));
                  }
                  //* Dropdown para aplicar una misma opcion en multiples select
                  if (tag['referencia'] == 'demanda' && tag['autor'] == 'analista') {
                    $('#rowHistorialLaboral').append(
                      '<div class="col-10"></div><div class="col-3 offset-4 text-center"><label>Aplicar a todo</label><select class="form-control" id="aplicar_todo' +
                      (number + 1) +
                      '"><option value="">Selecciona</option><option value="Not provided">Not provided</option><option value="Excellent">Excellent</option><option value="Good">Good</option><option value="Regular">Regular</option><option value="Bad">Bad</option><option value="Very Bad">Very Bad</option></select><br></div><div class="col-5"></div>'
                    );
                    $('#rowHistorialLaboral').append('<script>$("#aplicar_todo' + (
                        number + 1) +
                      '").change(function(){var valor = $(this).val();$(".esAplicable' +
                      (number + 1) + '").val(valor)});<\/script>');
                  }
                }
              }
              //* Boton Guardar
              $('#rowHistorialLaboral').append(
                '<div class="col-12 mt-3 mb-5"><a href="javascript:void(0)" id="btnGuardarVerificacion' +
                (number + 1) +
                '" class="btn btn-success btn-block" onclick="guardarLaboral(0,' +
                number + ',' + id + ',\'analista\',\'' + candidato +
                '\')">Guardar Verificación #' + (number + 1) + '</a></div>');
              $('#rowHistorialLaboral').append('<hr>');
              //* Reinicio de boton por autor del registro del campo
              autor_anterior = '';
            }
          } else {
            $('#rowHistorialLaboral').html(
              '<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>'
            );
          }
          $("#listado").css('display', 'none');
          $("#btn_nuevo").css('display', 'none');
          $("#btn_asignacion").css('display', 'none');
          $("#formulario").css('display', 'block');
          $("#btn_regresar").css('display', 'block');
        }
      });
    }
  }
  if (id_seccion == 55) {
    $.ajax({
      url: '<?php echo base_url('Candidato_Laboral/getAntecedentesLaboralesById'); ?>',
      method: 'POST',
      data: {
        'id': id,
        'id_seccion': id_seccion
      },
      async: false,
      success: function(res) {
        if (res != 0) {
          valores = JSON.parse(res);
        }
      }
    });
    $('#rowHistorialLaboral').empty();
    if (valores != 0) {
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {
          'id_seccion': id_seccion,
          'tipo_orden': 'orden_front'
        },
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          if (res != 0) {
            var dato = JSON.parse(res);
            $('#cantidadHistorialLaboral').val(30);
            //* Menu lateral para navegar entre las laborales
            let menu = '<nav class="floating-menu"><ul class="main-menu">';
            for (let i = 1; i <= 30; i++) {
              menu += '<li id="itemMenu' + i +
                '" data-toggle="tooltip" data-placement="left" title="Ir a la Laboral #' +
                i + '"><a class="ripple" href="#topLaboral' + i + '"><b>#' + i +
                '</b></a></li>';
            }
            menu += '<div class="menu-bg"></div></ul></nav>';
            menu +=
              '<a class="btn-success btn-return" data-toggle="tooltip" data-placement="left" title="Regresar al listado" onclick="regresarListado()"><i class="fas fa-arrow-left"></i></a>';
            $('#rowHistorialLaboral').append(menu);

            for (let number = 0; number < 30; number++) {
              $('#rowHistorialLaboral').append(
                '<div class="col-12 mt-5"><div class="text-center" id="topLaboral' + (
                  number + 1) + '"><h3 class="text-primary"><strong>Laboral #' + (
                  number + 1) + '</strong></h3><br></div></div>');
              for (let tag of dato) {
                //* Opciones Select
                if (tag['referencia'] == 'trabajo_calidad' || tag['referencia'] ==
                  'trabajo_puntualidad' || tag['referencia'] == 'trabajo_honesto' || tag[
                    'referencia'] == 'trabajo_responsabilidad' || tag['referencia'] ==
                  'trabajo_adaptacion' || tag['referencia'] == 'trabajo_actitud_jefes' ||
                  tag['referencia'] == 'trabajo_actitud_companeros') {
                  opciones =
                    '<option value="">Selecciona</option><option value="No proporciona">No proporciona</option><option value="Excelente">Excelente</option><option value="Bueno">Bueno</option><option value="Regular">Regular</option><option value="Insuficiente">Insuficiente</option><option value="Muy mal">Muy mal</option>';
                }
                //* HTML
                if (tag['tipo_etiqueta'] == 'select') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    opciones + tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                if (tag['tipo_etiqueta'] == 'input') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                if (tag['tipo_etiqueta'] == 'textarea') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                //* Clase esLaboral* para contemplar todos los campos de cada iteracion
                $('[name="' + tag['atr_id'] + '[]"]').eq(number).addClass('esLaboral' + (
                  number + 1));
                if (tag['referencia'] == 'trabajo_calidad' || tag['referencia'] ==
                  'trabajo_puntualidad' || tag['referencia'] == 'trabajo_honesto' || tag[
                    'referencia'] == 'trabajo_responsabilidad' || tag['referencia'] ==
                  'trabajo_adaptacion' || tag['referencia'] == 'trabajo_actitud_jefes' ||
                  tag['referencia'] == 'trabajo_actitud_companeros') {
                  $('[name="' + tag['atr_id'] + '[]"]').eq(number).addClass(
                    'esAplicable' + (number + 1));
                }
                //* Dropdown para aplicar una misma opcion en multiples select
                if (tag['referencia'] == 'causa_separacion') {
                  $('#rowHistorialLaboral').append(
                    '<div class="col-3 offset-4 text-center"><label>Aplicar a todo</label><select class="form-control" id="aplicar_todo' +
                    (number + 1) +
                    '"><option value="">Selecciona</option><option value="No proporciona">No proporciona</option><option value="Excelente">Excelente</option><option value="Bueno">Bueno</option><option value="Regular">Regular</option><option value="Insuficiente">Insuficiente</option><option value="Muy mal">Muy mal</option></select><br></div><div class="col-5"></div>'
                  );
                  $('#rowHistorialLaboral').append('<script>$("#aplicar_todo' + (number +
                      1) +
                    '").change(function(){var valor = $(this).val();$(".esAplicable' +
                    (number + 1) + '").val(valor)});<\/script>');
                }
              }
              //* Boton Guardar y Borrar
              $('#rowHistorialLaboral').append(
                '<div class="col-12"></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnGuardarLaboral' +
                (number + 1) +
                '" class="btn btn-success btn-block" onclick="guardarLaboral(0,' +
                number + ',' + id + ',\'analista\',\'' + candidato +
                '\')">Guardar Laboral #' + (number + 1) +
                '</button></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnEliminarLaboral' +
                (number + 1) +
                '" class="btn btn-danger btn-block" disabled>Eliminar Laboral #' + (
                  number + 1) + '</button></div>');
            }
            //* Valores de laboral por el candidato
            if (valores != 0) {
              var index = 0;
              let idLaboral = 0;
              let flag = 0;
              for (let valor of valores) {
                flag = 0;
                for (let tag of dato) {
                  $('[name="' + tag['atr_id'] + '[]"]').eq((valor['numero_referencia'] -
                    1)).val(valor[tag['referencia']]);
                  if (flag == 0) {
                    idLaboral = valor['id'];
                    flag++;
                  }
                }
                $('#itemMenu' + valor['numero_referencia']).css({
                  'background-color': '#1cc88a'
                });
                $('#btnGuardarLaboral' + valor['numero_referencia']).removeAttr('onclick');
                $('#btnGuardarLaboral' + valor['numero_referencia']).attr("onclick",
                  "guardarLaboral(" + idLaboral + "," + (valor['numero_referencia'] -
                    1) + "," + id + ",\"analista\",\"" + candidato + "\")");
                $('#btnEliminarLaboral' + valor['numero_referencia']).removeAttr(
                  'disabled');
                $('#btnEliminarLaboral' + valor['numero_referencia']).attr("onclick",
                  "mostrarMensajeConfirmacion(\"eliminar antecedente laboral\"," +
                  idLaboral + "," + valor['numero_referencia'] + ")");
                index++;
              }
            }
          } else {
            $('#rowHistorialLaboral').html(
              '<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>'
            );
          }
          $("#listado").css('display', 'none');
          $("#btn_nuevo").css('display', 'none');
          $("#btn_asignacion").css('display', 'none');
          $("#formulario").css('display', 'block');
          $("#btn_regresar").css('display', 'block');
        }
      });
    } else {
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {
          'id_seccion': id_seccion,
          'tipo_orden': 'orden_front'
        },
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          if (res != 0) {
            var dato = JSON.parse(res);
            $('#cantidadHistorialLaboral').val(1);
            //* Mensaje sin registros
            $('#rowHistorialLaboral').append(
              '<div class="col-12"><div class="text-center"><h5 class="text-primary">Este candidato no tiene información en su historial laboral</h5><br></div></div>'
            );
            //* Menu lateral para navegar entre las laborales
            let menu =
              '<nav class="floating-menu" data-toggle="tooltip" data-placement="left" title="Menu de laborales"><ul class="main-menu">';
            for (let i = 1; i <= 1; i++) {
              menu += '<li><a class="ripple" href="#topLaboral' + i + '"><b>#' + i +
                '</b></a></li>';
            }
            menu += '<div class="menu-bg"></div></ul></nav>';
            menu +=
              '<a class="btn-success btn-return" data-toggle="tooltip" data-placement="left" title="Regresar al listado" onclick="regresarListado()"><i class="fas fa-arrow-left"></i></a>';

            $('#rowHistorialLaboral').append(menu);

            for (let number = 0; number < 1; number++) {
              $('#rowHistorialLaboral').append(
                '<div class="col-12 mt-5"><div class="text-center" id="topLaboral' + (
                  number + 1) + '"><h4 class="text-primary"><strong>Laboral #' + (
                  number + 1) + '</strong></h4><br></div></div>');
              for (let tag of dato) {
                //* Opciones Select
                if (tag['referencia'] == 'trabajo_calidad' || tag['referencia'] ==
                  'trabajo_puntualidad' || tag['referencia'] == 'trabajo_honesto' || tag[
                    'referencia'] == 'trabajo_responsabilidad' || tag['referencia'] ==
                  'trabajo_adaptacion' || tag['referencia'] == 'trabajo_actitud_jefes' ||
                  tag['referencia'] == 'trabajo_actitud_companeros') {
                  opciones =
                    '<option value="">Selecciona</option><option value="No proporciona">No proporciona</option><option value="Excelente">Excelente</option><option value="Bueno">Bueno</option><option value="Regular">Regular</option><option value="Insuficiente">Insuficiente</option><option value="Muy mal">Muy mal</option>';
                }
                //* HTML
                if (tag['tipo_etiqueta'] == 'select') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    opciones + tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                if (tag['tipo_etiqueta'] == 'input') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                if (tag['tipo_etiqueta'] == 'textarea') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                //* Clase esLaboral* para contemplar todos los campos de cada iteracion
                $('[name="' + tag['atr_id'] + '[]"]').eq(number).addClass('esLaboral' + (
                  number + 1));
                if (tag['referencia'] == 'trabajo_calidad' || tag['referencia'] ==
                  'trabajo_puntualidad' || tag['referencia'] == 'trabajo_honesto' || tag[
                    'referencia'] == 'trabajo_responsabilidad' || tag['referencia'] ==
                  'trabajo_adaptacion' || tag['referencia'] == 'trabajo_actitud_jefes' ||
                  tag['referencia'] == 'trabajo_actitud_companeros') {
                  $('[name="' + tag['atr_id'] + '[]"]').eq(number).addClass(
                    'esAplicable' + (number + 1));
                }
                //* Dropdown para aplicar una misma opcion en multiples select
                if (tag['referencia'] == 'causa_separacion') {
                  $('#rowHistorialLaboral').append(
                    '<div class="col-3 offset-4 text-center"><label>Aplicar a todo</label><select class="form-control" id="aplicar_todo' +
                    (number + 1) +
                    '"><option value="">Selecciona</option><option value="No proporciona">No proporciona</option><option value="Excelente">Excelente</option><option value="Bueno">Bueno</option><option value="Regular">Regular</option><option value="Insuficiente">Insuficiente</option><option value="Muy mal">Muy mal</option></select><br></div><div class="col-5"></div>'
                  );
                  $('#rowHistorialLaboral').append('<script>$("#aplicar_todo' + (number +
                      1) +
                    '").change(function(){var valor = $(this).val();$(".esAplicable' +
                    (number + 1) + '").val(valor)});<\/script>');
                }
              }
              //* Boton Guardar y Borrar
              $('#rowHistorialLaboral').append(
                '<div class="col-12"></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnGuardarLaboral' +
                (number + 1) +
                '" class="btn btn-success btn-block" onclick="guardarLaboral(0,' +
                number + ',' + id + ',\'analista\',\'' + candidato +
                '\')">Guardar Laboral #' + (number + 1) +
                '</button></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnEliminarLaboral' +
                (number + 1) +
                '" class="btn btn-danger btn-block" disabled>Eliminar Laboral #' + (
                  number + 1) + '</button></div>');
            }
          } else {
            $('#rowHistorialLaboral').html(
              '<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>'
            );
          }
          $("#listado").css('display', 'none');
          $("#btn_nuevo").css('display', 'none');
          $("#btn_asignacion").css('display', 'none');
          $("#formulario").css('display', 'block');
          $("#btn_regresar").css('display', 'block');
        }
      });
    }
  }
  if (id_seccion == 77) {
    $.ajax({
      url: '<?php echo base_url('Candidato_Laboral/getHistorialLaboralById'); ?>',
      method: 'POST',
      data: {
        'id': id,
        'id_seccion': id_seccion
      },
      async: false,
      success: function(res) {
        if (res != 0) {
          valores = JSON.parse(res);
        }
      }
    });
    $.ajax({
      url: '<?php echo base_url('Candidato_Laboral/getContactoById'); ?>',
      method: 'POST',
      data: {
        'id': id,
        'id_seccion': id_seccion
      },
      async: false,
      success: function(res) {
        if (res != 0) {
          valores2 = JSON.parse(res);
        }
      }
    });

    $('#rowHistorialLaboral').empty();
    if (valores != 0 || valores2 != 0) {
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {
          'id_seccion': id_seccion,
          'tipo_orden': 'orden_front'
        },
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          if (res != 0) {
            var dato = JSON.parse(res);
            //let cantidad_valores = (valores.length > 0)? valores.length : 1;
            $('#cantidadHistorialLaboral').val(30);
            // //* Boton nueva laboral
            // let botonNuevo = '<button type="button" class="floating-button-new" data-toggle="tooltip" data-placement="left" title="Agregar laboral" onclick="agregarLaboral()"><i class="fas fa-plus-circle"></i></button>';
            // $('#rowHistorialLaboral').append(botonNuevo);
            //* Menu lateral para navegar entre las laborales
            let menu = '<nav class="floating-menu"><ul class="main-menu">';
            for (let i = 1; i <= 30; i++) {
              menu += '<li id="itemMenu' + i +
                '" data-toggle="tooltip" data-placement="left" title="Ir a la Laboral #' +
                i + '"><a class="ripple" href="#topLaboral' + i + '"><b>#' + i +
                '</b></a></li>';
            }
            menu += '<div class="menu-bg"></div></ul></nav>';
            menu +=
              '<a class="btn-success btn-return" data-toggle="tooltip" data-placement="left" title="Regresar al listado" onclick="regresarListado()"><i class="fas fa-arrow-left"></i></a>';

            $('#rowHistorialLaboral').append(menu);

            for (let number = 0; number < 30; number++) {
              $('#rowHistorialLaboral').append(
                '<div class="col-12 mt-5"><div class="text-center" id="topLaboral' + (
                  number + 1) + '"><h3 class="text-primary"><strong>Laboral #' + (
                  number + 1) + '</strong></h3><br></div></div>');
              for (let tag of dato) {
                //* Boton por autor del registro del campo
                if (autor_anterior != '' && tag['autor'] != autor_anterior) {
                  //* Boton Guardar y Borrar
                  $('#rowHistorialLaboral').append(
                    '<div class="col-12"></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnGuardarLaboral' +
                    (number + 1) +
                    '" class="btn btn-success btn-block" onclick="guardarLaboral(0,' +
                    number + ',' + id + ',\'candidato\',\'' + candidato +
                    '\')">Guardar Laboral #' + (number + 1) +
                    '</button></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnEliminarLaboral' +
                    (number + 1) +
                    '" class="btn btn-danger btn-block" disabled>Eliminar Laboral #' +
                    (number + 1) + '</button></div>');
                  autor_anterior = tag['autor'];
                }
                if (autor_anterior == '' || tag['autor'] == autor_anterior) {
                  autor_anterior = tag['autor'];
                }
                //* HTML
                if (tag['tipo_etiqueta'] == 'select') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    opciones + tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                if (tag['tipo_etiqueta'] == 'input') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                if (tag['tipo_etiqueta'] == 'textarea') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                //* Clase esLaboral* para contemplar todos los campos de cada iteracion
                $('[name="' + tag['atr_id'] + '[]"]').eq(number).addClass('esLaboral' + (
                  number + 1));
              }
              //* Boton Guardar
              $('#rowHistorialLaboral').append(
                '<div class="col-12"></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnGuardarVerificacion' +
                (number + 1) +
                '" class="btn btn-success btn-block" onclick="guardarLaboral(0,' +
                number + ',' + id + ',\'analista\',\'' + candidato +
                '\')">Guardar Verificación #' + (number + 1) +
                '</button></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnEliminarVerificacion' +
                (number + 1) +
                '" class="btn btn-danger btn-block" disabled>Eliminar Verificacion #' +
                (number + 1) + '</button></div>');
              //* Reinicio de boton por autor del registro del campo
              autor_anterior = '';
            }
            //* Valores de laboral por el candidato
            if (valores != 0) {
              var index = 0;
              let idLaboral = 0;
              let flag = 0;
              for (let valor of valores) {
                flag = 0;
                for (let tag of dato) {
                  if (tag['autor'] == 'candidato')
                    $('[name="' + tag['atr_id'] + '[]"]').eq(index).val(valor[tag[
                      'referencia']]);
                  if (flag == 0) {
                    idLaboral = valor['id'];
                    flag++;
                  }
                }
                $('#itemMenu' + (index + 1)).css({
                  'background-color': '#1cc88a'
                });
                $('#btnGuardarLaboral' + (index + 1)).removeAttr('onclick');
                $('#btnGuardarLaboral' + (index + 1)).attr("onclick", "guardarLaboral(" +
                  idLaboral + "," + index + "," + id + ",\"candidato\",\"" +
                  candidato + "\")");
                $('#btnEliminarLaboral' + (index + 1)).removeAttr('disabled');
                $('#btnEliminarLaboral' + (index + 1)).attr("onclick",
                  "mostrarMensajeConfirmacion(\"eliminar laboral\"," + idLaboral +
                  "," + index + ")");
                index++;
              }
            }
            //* Valores de laboral por analista
            if (valores2 != 0) {
              var index = 0;
              let idVerificacion = 0;
              let flag = 0;
              for (let valor2 of valores2) {
                flag = 0;
                for (let tag of dato) {
                  if (tag['autor'] == 'analista')
                    $('[name="' + tag['atr_id'] + '[]"]').eq((valor2[
                      'numero_referencia'] - 1)).val(valor2[tag['referencia']]);
                  if (flag == 0) {
                    idVerificacion = valor2['id'];
                    flag++;
                  }
                }
                $('#itemMenu' + valor2['numero_referencia']).css({
                  'background-color': '#1cc88a'
                });
                $('#btnGuardarVerificacion' + (index + 1)).removeAttr('onclick');
                $('#btnGuardarVerificacion' + (index + 1)).attr("onclick",
                  "guardarLaboral(" + idVerificacion + "," + index + "," + id +
                  ",\"analista\",\"" + candidato + "\")");
                $('#btnEliminarVerificacion' + valor2['numero_referencia']).removeAttr(
                  'disabled');
                $('#btnEliminarVerificacion' + valor2['numero_referencia']).attr("onclick",
                  "mostrarMensajeConfirmacion(\"eliminar contacto laboral\"," +
                  idVerificacion + "," + valor2['numero_referencia'] + ")");
                index++;
              }
            }
          } else {
            $('#rowHistorialLaboral').html(
              '<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>'
            );
          }
          $("#listado").css('display', 'none');
          $("#btn_nuevo").css('display', 'none');
          $("#btn_asignacion").css('display', 'none');
          $("#formulario").css('display', 'block');
          $("#btn_regresar").css('display', 'block');
        }
      });
    } else {
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {
          'id_seccion': id_seccion,
          'tipo_orden': 'orden_front'
        },
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          if (res != 0) {
            var dato = JSON.parse(res);
            $('#cantidadHistorialLaboral').val(1);
            // //* Boton nueva laboral
            // let botonNuevo = '<button type="button" class="floating-button-new" data-toggle="tooltip" data-placement="left" title="Agregar laboral" onclick="agregarLaboral()"><i class="fas fa-plus-circle"></i></button>';
            // $('#rowHistorialLaboral').append(botonNuevo);
            //* Menu lateral para navegar entre las laborales
            let menu =
              '<nav class="floating-menu" data-toggle="tooltip" data-placement="left" title="Menu de laborales"><ul class="main-menu">';
            for (let i = 1; i <= 1; i++) {
              menu += '<li><a class="ripple" href="#topLaboral' + i + '"><b>#' + i +
                '</b></a></li>';
            }
            menu += '<div class="menu-bg"></div></ul></nav>';
            menu +=
              '<a class="btn-success btn-return" data-toggle="tooltip" data-placement="left" title="Regresar al listado" onclick="regresarListado()"><i class="fas fa-arrow-left"></i></a>';

            $('#rowHistorialLaboral').append(menu);

            for (let number = 0; number < 1; number++) {
              $('#rowHistorialLaboral').append(
                '<div class="col-12 mt-5"><div class="text-center" id="topLaboral' + (
                  number + 1) + '"><h4 class="text-primary"><strong>Laboral #' + (
                  number + 1) + '</strong></h4><br></div></div>');
              for (let tag of dato) {
                //* Boton por autor del registro del campo
                if (autor_anterior != '' && tag['autor'] != autor_anterior) {
                  //* Boton Guardar
                  $('#rowHistorialLaboral').append(
                    '<div class="col-12 mt-3 mb-5"><a href="javascript:void(0)" id="btnGuardarLaboral' +
                    (number + 1) +
                    '" class="btn btn-success btn-block" onclick="guardarLaboral(0,' +
                    number + ',' + id + ',\'candidato\',\'' + candidato +
                    '\')">Guardar Laboral #' + (number + 1) + '</a></div>');
                  autor_anterior = tag['autor'];
                }
                if (autor_anterior == '' || tag['autor'] == autor_anterior) {
                  autor_anterior = tag['autor'];
                }
                //* HTML
                if (tag['tipo_etiqueta'] == 'select') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    opciones + tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                if (tag['tipo_etiqueta'] == 'input') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                if (tag['tipo_etiqueta'] == 'textarea') {
                  $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                      'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                    tag['etiqueta_cierre'] + tag['grid_col_cierre']);
                }
                $('[name="' + tag['atr_id'] + '[]"]').eq(number).addClass('esLaboral' + (
                  number + 1));
              }
              //* Boton Guardar
              $('#rowHistorialLaboral').append(
                '<div class="col-12 mt-3 mb-5"><a href="javascript:void(0)" id="btnGuardarVerificacion' +
                (number + 1) +
                '" class="btn btn-success btn-block" onclick="guardarLaboral(0,' +
                number + ',' + id + ',\'analista\',\'' + candidato +
                '\')">Guardar Verificación #' + (number + 1) + '</a></div>');
              $('#rowHistorialLaboral').append('<hr>');
              //* Reinicio de boton por autor del registro del campo
              autor_anterior = '';
            }
          } else {
            $('#rowHistorialLaboral').html(
              '<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>'
            );
          }
          $("#listado").css('display', 'none');
          $("#btn_nuevo").css('display', 'none');
          $("#btn_asignacion").css('display', 'none');
          $("#formulario").css('display', 'block');
          $("#btn_regresar").css('display', 'block');
        }
      });
    }
  }
}

function guardarLaboral(id, num, idCandidato, autor, candidato) {
  let textoResponse = '';
  let separador = '';
  let id_seccion = $('#idSeccion').val();
  var campos = '';

  if (autor == 'candidato') {
    separador = 'cand_';
    if (id != 0)
      textoResponse = 'Laboral actualizada correctamente';
    else
      textoResponse = 'Laboral guardada correctamente';
  }
  if (autor == 'analista') {
    separador = 'ana_';
    if (id_seccion == 16 || id_seccion == 32 || id_seccion == 59 || id_seccion == 90) {
      textoResponse = (id != 0) ? 'Verificación actualizada correctamente' :
        'Verificación guardada correctamente';
    }
    if (id_seccion == 55) {
      textoResponse = (id != 0) ? 'Laboral actualizada correctamente' : 'Laboral guardada correctamente';
    }
    if (id_seccion == 77) {
      textoResponse = (id != 0) ? 'Contacto/Informante actualizado correctamente' :
        'Contacto/Informante guardado correctamente';
    }
  }

  $.ajax({
    url: '<?php echo base_url('Formulario/getBySeccionAndAutor'); ?>',
    method: 'POST',
    data: {
      'id_seccion': id_seccion,
      'tipo_orden': 'orden_front',
      'autor': autor
    },
    async: false,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      if (res != 0) {
        campos = JSON.parse(res);
      }
    }
  });
  let objeto = new Object();
  for (let tag of campos) {
    let param = tag['atr_id'].split(separador);
    objeto[param[1]] = $('[name="' + tag['atr_id'] + '[]"]').eq(num).val();
  }
  let datos = $.param(objeto);
  datos += '&id_candidato=' + $("#idCandidato").val();
  datos += '&id_seccion=' + id_seccion;
  datos += '&id=' + id;
  datos += '&num=' + num;
  datos += '&autor=' + autor;

  if (id_seccion == 16 || id_seccion == 32 || id_seccion == 59 || id_seccion == 77 || id_seccion == 90) {
    if (autor == 'candidato') {
      $.ajax({
        url: '<?php echo base_url('Candidato_Laboral/setHistorialLaboral'); ?>',
        type: 'POST',
        data: datos,
        async: false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            if (id == 0) {
              $('#rowNuevaLaboral').empty();
              $("#rowHistorialLaboral").empty();
              getHistorialLaboral($("#idCandidato").val(), id_seccion)
            }
            //* Respaldo txt
            var idCandidato = $("#idCandidato").val();
            var f = new Date();
            var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
            respaldoTxt(datos, 'referencia_laboral_' + num + '-' + idCandidato + '-' +
              fecha_txt);
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: textoResponse,
              showConfirmButton: false,
              timer: 2500
            })
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Hubo un problema al enviar el formulario',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Cerrar'
            })
          }
        }
      });
    }
    if (autor == 'analista') {
      if (id_seccion == 16 || id_seccion == 32 || id_seccion == 59 || id_seccion == 90) {
        $.ajax({
          url: '<?php echo base_url('Candidato_Laboral/setVerificacionLaboral'); ?>',
          type: 'POST',
          data: datos,
          async: false,
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            var data = JSON.parse(res);
            if (data.codigo === 1) {
              if (id == 0) {
                $('#rowNuevaLaboral').empty();
                $("#rowHistorialLaboral").empty();
                getHistorialLaboral($("#idCandidato").val(), id_seccion)
              }
              //* Respaldo txt
              var idCandidato = $("#idCandidato").val();
              var f = new Date();
              var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
              respaldoTxt(datos, 'verificacion_laboral_' + num + '-' + idCandidato + '-' +
                fecha_txt);
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: textoResponse,
                showConfirmButton: false,
                timer: 2500
              })
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Hubo un problema al enviar el formulario',
                html: data.msg,
                width: '50em',
                confirmButtonText: 'Cerrar'
              })
            }
          }
        });
      }
      if (id_seccion == 77) {
        $.ajax({
          url: '<?php echo base_url('Candidato_Laboral/setContactoLaboral'); ?>',
          type: 'POST',
          data: datos,
          async: false,
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            var data = JSON.parse(res);
            if (data.codigo === 1) {
              if (id == 0) {
                $('#rowNuevaLaboral').empty();
                $("#rowHistorialLaboral").empty();
                getHistorialLaboral($("#idCandidato").val(), id_seccion)
              }
              //* Respaldo txt
              var idCandidato = $("#idCandidato").val();
              var f = new Date();
              var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
              respaldoTxt(datos, 'contacto_laboral_' + num + '-' + idCandidato + '-' +
                fecha_txt);
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: textoResponse,
                showConfirmButton: false,
                timer: 2500
              })
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Hubo un problema al enviar el formulario',
                html: data.msg,
                width: '50em',
                confirmButtonText: 'Cerrar'
              })
            }
          }
        });
      }
    }
  }
  if (id_seccion == 55) {
    if (autor == 'analista') {
      $.ajax({
        url: '<?php echo base_url('Candidato_Laboral/setAntecedentesLaborales'); ?>',
        type: 'POST',
        data: datos,
        async: false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            if (id == 0) {
              $("#rowHistorialLaboral").empty();
              getHistorialLaboral($("#idCandidato").val(), id_seccion)
            }
            //* Respaldo txt
            var idCandidato = $("#idCandidato").val();
            var f = new Date();
            var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
            respaldoTxt(datos, 'antecedente_laboral_' + num + '-' + idCandidato + '-' +
              fecha_txt);
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: textoResponse,
              showConfirmButton: false,
              timer: 2500
            })
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Hubo un problema al enviar el formulario',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Cerrar'
            })
          }
        }
      });
    }
  }
}

function eliminarLaboral(opcion, id, number) {
  var id_candidato = $('#idCandidato').val();
  let id_seccion = $('#idSeccion').val();
  var datos = new FormData();
  datos.append('id_candidato', id_candidato);
  datos.append('id', id);
  datos.append('numero', (number + 1));
  if (opcion == 'eliminar laboral') {
    $.ajax({
      url: '<?php echo base_url('Candidato_Laboral/deleteLaboral'); ?>',
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
          $('#mensajeModal').modal('hide');
          $("#rowHistorialLaboral").empty();
          getHistorialLaboral(id_candidato, id_seccion)
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Laboral eliminada correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        }
      }
    });
  }
  if (opcion == 'eliminar verificacion laboral') {
    $.ajax({
      url: '<?php echo base_url('Candidato_Laboral/deleteVerificacion'); ?>',
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
          $('#mensajeModal').modal('hide');
          $("#rowHistorialLaboral").empty();
          getHistorialLaboral(id_candidato, id_seccion)
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Verificación laboral eliminada correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        }
      }
    });
  }
  if (opcion == 'eliminar antecedente laboral') {
    $.ajax({
      url: '<?php echo base_url('Candidato_Laboral/deleteAntecedenteLaboral'); ?>',
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
          $('#mensajeModal').modal('hide');
          $("#rowHistorialLaboral").empty();
          getHistorialLaboral(id_candidato, id_seccion)
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Laboral eliminada correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        }
      }
    });
  }
  if (opcion == 'eliminar contacto laboral') {
    $.ajax({
      url: '<?php echo base_url('Candidato_Laboral/deleteContacto'); ?>',
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
          $('#mensajeModal').modal('hide');
          $("#rowHistorialLaboral").empty();
          getHistorialLaboral(id_candidato, id_seccion)
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Contacto/Informante laboral eliminado correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        }
      }
    });
  }
  if (opcion == 'eliminar referencia cliente') {
    $.ajax({
      url: '<?php echo base_url('ReferenciaCliente/delete'); ?>',
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
          $('#mensajeModal').modal('hide');
          $("#rowHistorialLaboral").empty();
          getReferenciasClientes(id_candidato, id_seccion)
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Referencia eliminada correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        }
      }
    });
  }
}
//TODO: Se requiere cambiar/sustituir esta funcion para mejor manejo en codigo y BD
function actualizarTrabajoGobierno() {
  var datos = new FormData();
  datos.append('trabajo', $("#trabajo_gobierno").val());
  datos.append('enterado', $("#trabajo_enterado").val());
  datos.append('persona_nombre1', $("#persona_trabajo_nombre1").val());
  datos.append('persona_puesto1', $("#persona_trabajo_puesto1").val());
  datos.append('persona_nombre2', $("#persona_trabajo_nombre2").val());
  datos.append('persona_puesto2', $("#persona_trabajo_puesto2").val());
  datos.append('id_candidato', $("#idCandidato").val());
  datos.append('caso', 2);

  $.ajax({
    url: '<?php echo base_url('Cliente_Monex/guardarTrabajoGobierno'); ?>',
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
        //recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Información extra laboral guardada correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema al enviar el formulario',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}
//TODO: Se requiere cambiar/sustituir esta funcion para mejor manejo en codigo y BD
function actualizarTrabajoGobierno2() {
  var datos = new FormData();
  datos.append('trabajo_gobierno', $("#trabajo_gobierno").val());
  datos.append('trabajo_inactivo', $("#trabajo_inactivo").val());
  datos.append('id_candidato', $("#idCandidato").val());

  $.ajax({
    url: '<?php echo base_url('Candidato_Laboral/setCuestiones'); ?>',
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
        //recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Información extra laboral guardada correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema al enviar el formulario',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}
//TODO: Se requiere cambiar/sustituir esta funcion para mejor manejo en codigo y BD
function actualizarTrabajoGobierno3() {
  var datos = new FormData();
  datos.append('trabajo_razon', $("#trabajo_razon").val());
  datos.append('trabajo_expectativa', $("#trabajo_expectativa").val());
  datos.append('id_candidato', $("#idCandidato").val());

  $.ajax({
    url: '<?php echo base_url('Candidato_Laboral/setCuestiones'); ?>',
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
        //recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Información extra laboral guardada correctament',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema al enviar el formulario',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}

function getDatosVisita() {
  var datos = new FormData();
  var archivo = $("#archivo_visita")[0].files[0];
  datos.append('archivo', archivo);
  $.ajax({
    url: '<?php echo base_url('Candidato/getDatosVisita'); ?>',
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
      $('#divInfoVisita').css('display', 'block');
      $('#divInfoVisita').html(res);
    }
  });
}

function getReferenciasClientes(id, id_seccion) {
  let valores = '';
  let valores2 = '';
  let scripts = '';
  let opciones = '';
  let botones_collapse_menu = '';
  let autor_anterior = '';
  let candidato = $('#nombreCandidato').val();
  $.ajax({
    url: '<?php echo base_url('ReferenciaCliente/getById'); ?>',
    method: 'POST',
    data: {
      'id': id,
      'id_seccion': id_seccion
    },
    async: false,
    success: function(res) {
      if (res != 0) {
        valores = JSON.parse(res);
      }
    }
  });
  $('#rowHistorialLaboral').empty();
  if (valores != 0) {
    $.ajax({
      url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
      method: 'POST',
      data: {
        'id_seccion': id_seccion,
        'tipo_orden': 'orden_front'
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        if (res != 0) {
          var dato = JSON.parse(res);
          $('#cantidadHistorialLaboral').val(30);
          //* Menu lateral para navegar entre las laborales
          let menu = '<nav class="floating-menu"><ul class="main-menu">';
          for (let i = 1; i <= 30; i++) {
            menu += '<li id="itemMenu' + i +
              '" data-toggle="tooltip" data-placement="left" title="Ir al cliente #' + i +
              '"><a class="ripple" href="#topLaboral' + i + '"><b>#' + i + '</b></a></li>';
          }
          menu += '<div class="menu-bg"></div></ul></nav>';
          menu +=
            '<a class="btn-success btn-return" data-toggle="tooltip" data-placement="left" title="Regresar al listado" onclick="regresarListado()"><i class="fas fa-arrow-left"></i></a>';
          $('#rowHistorialLaboral').append(menu);

          for (let number = 0; number < 30; number++) {
            $('#rowHistorialLaboral').append(
              '<div class="col-12 mt-5"><div class="text-center" id="topLaboral' + (
                number + 1) + '"><h3 class="text-primary"><strong>Laboral #' + (number +
                1) + '</strong></h3><br></div></div>');
            for (let tag of dato) {
              //* Opciones Select
              //* HTML
              if (tag['tipo_etiqueta'] == 'select') {
                $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                    'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                  opciones + tag['etiqueta_cierre'] + tag['grid_col_cierre']);
              }
              if (tag['tipo_etiqueta'] == 'input') {
                $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                    'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                  tag['etiqueta_cierre'] + tag['grid_col_cierre']);
              }
              if (tag['tipo_etiqueta'] == 'textarea') {
                $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                    'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                  tag['etiqueta_cierre'] + tag['grid_col_cierre']);
              }
            }
            //* Boton Guardar y Borrar
            $('#rowHistorialLaboral').append(
              '<div class="col-12"></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnGuardarCliente' +
              (number + 1) +
              '" class="btn btn-success btn-block" onclick="guardarRefCliente(0,' +
              number + ',' + id + ',\'analista\',\'' + candidato +
              '\')">Guardar Referencia #' + (number + 1) +
              '</button></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnEliminarCliente' +
              (number + 1) +
              '" class="btn btn-danger btn-block" disabled>Eliminar Referencia #' + (
                number + 1) + '</button></div>');
          }
          //* Valores de laboral por el candidato
          if (valores != 0) {
            var index = 0;
            let idLaboral = 0;
            let flag = 0;
            for (let valor of valores) {
              flag = 0;
              for (let tag of dato) {
                $('[name="' + tag['atr_id'] + '[]"]').eq((valor['numero_referencia'] - 1))
                  .val(valor[tag['referencia']]);
                if (flag == 0) {
                  idLaboral = valor['id'];
                  flag++;
                }
              }
              $('#itemMenu' + valor['numero_referencia']).css({
                'background-color': '#1cc88a'
              });
              $('#btnGuardarCliente' + (index + 1)).removeAttr('onclick');
              $('#btnGuardarCliente' + (index + 1)).attr("onclick", "guardarRefCliente(" +
                idLaboral + "," + index + "," + id + ",\"analista\",\"" + candidato +
                "\")");
              $('#btnEliminarCliente' + valor['numero_referencia']).removeAttr('disabled');
              $('#btnEliminarCliente' + valor['numero_referencia']).attr("onclick",
                "mostrarMensajeConfirmacion(\"eliminar referencia cliente\"," +
                idLaboral + "," + valor['numero_referencia'] + ")");
              index++;
            }
          }
        } else {
          $('#rowHistorialLaboral').html(
            '<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>'
          );
        }
        $("#listado").css('display', 'none');
        $("#btn_nuevo").css('display', 'none');
        $("#btn_asignacion").css('display', 'none');
        $("#formulario").css('display', 'block');
        $("#btn_regresar").css('display', 'block');
      }
    });
  } else {
    $.ajax({
      url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
      method: 'POST',
      data: {
        'id_seccion': id_seccion,
        'tipo_orden': 'orden_front'
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        if (res != 0) {
          var dato = JSON.parse(res);
          $('#cantidadHistorialLaboral').val(1);
          //* Mensaje sin registros
          $('#rowHistorialLaboral').append(
            '<div class="col-12"><div class="text-center"><h5 class="text-primary">Este candidato no tiene información de referencias de clientes</h5><br></div></div>'
          );
          //* Menu lateral para navegar entre las laborales
          let menu =
            '<nav class="floating-menu" data-toggle="tooltip" data-placement="left" title="Menu de referencias de clientes"><ul class="main-menu">';
          for (let i = 1; i <= 1; i++) {
            menu += '<li><a class="ripple" href="#topLaboral' + i + '"><b>#' + i +
              '</b></a></li>';
          }
          menu += '<div class="menu-bg"></div></ul></nav>';
          menu +=
            '<a class="btn-success btn-return" data-toggle="tooltip" data-placement="left" title="Regresar al listado" onclick="regresarListado()"><i class="fas fa-arrow-left"></i></a>';

          $('#rowHistorialLaboral').append(menu);

          for (let number = 0; number < 1; number++) {
            $('#rowHistorialLaboral').append(
              '<div class="col-12 mt-5"><div class="text-center" id="topLaboral' + (
                number + 1) + '"><h4 class="text-primary"><strong>Referencia #' + (
                number + 1) + '</strong></h4><br></div></div>');
            for (let tag of dato) {
              //* HTML
              if (tag['tipo_etiqueta'] == 'select') {
                $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                    'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                  opciones + tag['etiqueta_cierre'] + tag['grid_col_cierre']);
              }
              if (tag['tipo_etiqueta'] == 'input') {
                $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                    'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                  tag['etiqueta_cierre'] + tag['grid_col_cierre']);
              }
              if (tag['tipo_etiqueta'] == 'textarea') {
                $('#rowHistorialLaboral').append(tag['titulo_seccion_modal'] + tag[
                    'grid_col_inicio'] + tag['label'] + tag['etiqueta_inicio'] +
                  tag['etiqueta_cierre'] + tag['grid_col_cierre']);
              }
            }
            //* Boton Guardar y Borrar
            $('#rowHistorialLaboral').append(
              '<div class="col-12"></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnGuardarCliente' +
              (number + 1) +
              '" class="btn btn-success btn-block" onclick="guardarRefCliente(0,' +
              number + ',' + id + ',\'analista\',\'' + candidato +
              '\')">Guardar Referencia #' + (number + 1) +
              '</button></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnEliminarCliente' +
              (number + 1) +
              '" class="btn btn-danger btn-block" disabled>Eliminar Referencia #' + (
                number + 1) + '</button></div>');
          }
        } else {
          $('#rowHistorialLaboral').html(
            '<div class="col-12 text-center"><h5><b>Formulario no registrado para este candidato</b></h5></div>'
          );
        }
        $("#listado").css('display', 'none');
        $("#btn_nuevo").css('display', 'none');
        $("#btn_asignacion").css('display', 'none');
        $("#formulario").css('display', 'block');
        $("#btn_regresar").css('display', 'block');
      }
    });
  }
}

function guardarRefCliente(id, num, idCandidato, autor, candidato) {
  let textoResponse = '';
  let separador = '';
  let id_seccion = $('#idSeccion').val();
  var campos = '';

  if (autor == 'candidato') {
    separador = 'cand_';
    if (id != 0)
      textoResponse = 'Referencia actualizada correctamente';
    else
      textoResponse = 'Referencia guardada correctamente';
  }
  if (autor == 'analista') {
    separador = 'ana_';
    textoResponse = (id != 0) ? 'Referencia actualizada correctamente' : 'Referencia guardada correctamente';
  }

  $.ajax({
    url: '<?php echo base_url('Formulario/getBySeccionAndAutor'); ?>',
    method: 'POST',
    data: {
      'id_seccion': id_seccion,
      'tipo_orden': 'orden_front',
      'autor': autor
    },
    async: false,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      if (res != 0) {
        campos = JSON.parse(res);
      }
    }
  });
  let objeto = new Object();
  for (let tag of campos) {
    let param = tag['atr_id'].split(separador);
    objeto[param[1]] = $('[name="' + tag['atr_id'] + '[]"]').eq(num).val();
  }
  let datos = $.param(objeto);
  datos += '&id_candidato=' + $("#idCandidato").val();
  datos += '&id_seccion=' + id_seccion;
  datos += '&id=' + id;
  datos += '&num=' + num;
  datos += '&autor=' + autor;

  if (autor == 'analista') {
    $.ajax({
      url: '<?php echo base_url('ReferenciaCliente/update'); ?>',
      type: 'POST',
      data: datos,
      async: false,
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        var data = JSON.parse(res);
        if (data.codigo === 1) {
          if (id == 0) {
            $("#rowHistorialLaboral").empty();
            getReferenciasClientes($("#idCandidato").val(), id_seccion)
          }
          //* Respaldo txt
          var idCandidato = $("#idCandidato").val();
          var f = new Date();
          var fecha_txt = f.getDate() + "-" + (f.getMonth() + 1) + "-" + f.getFullYear();
          respaldoTxt(datos, 'referencia_cliente_' + num + '-' + idCandidato + '-' + fecha_txt);
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: textoResponse,
            showConfirmButton: false,
            timer: 2500
          })
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Hubo un problema al enviar el formulario',
            html: data.msg,
            width: '50em',
            confirmButtonText: 'Cerrar'
          })
        }
      }
    });
  }
}
//* Fin de las funciones actualizadas


//*Referencias Vecinales
function guardarRefVecinal(num, id) {
  var datos = new FormData();
  datos.append('nombre', $('#vecino' + num + '_nombre').val());
  datos.append('domicilio', $('#vecino' + num + '_domicilio').val());
  datos.append('telefono', $('#vecino' + num + '_tel').val());
  datos.append('concepto', $('#vecino' + num + '_concepto').val());
  datos.append('familia', $('#vecino' + num + '_familia').val());
  datos.append('civil', $('#vecino' + num + '_civil').val());
  datos.append('hijos', $('#vecino' + num + '_hijos').val());
  datos.append('sabetrabaja', $('#vecino' + num + '_sabetrabaja').val());
  datos.append('notas', $('#vecino' + num + '_notas').val());
  datos.append('tiempo', $('#vecino' + num + '_tiempo').val());
  datos.append('opinion_trabajador', $('#vecino' + num + '_opinion_trabajador').val());
  datos.append('candidato_problemas', $('#vecino' + num + '_candidato_problemas').val());
  datos.append('recomienda', $('#vecino' + num + '_recomienda').val());
  datos.append('id_candidato', $("#idCandidato").val());
  datos.append('id', id);

  $.ajax({
    url: '<?php echo base_url('Candidato_Ref_Vecinal/set'); ?>',
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
      if (data.codigo === 0) {
        $("#msj_error_vecinal" + num).css('display', 'block').html(data.msg);
      }
      if (data.codigo === 1) {
        $("#msj_error_vecinal" + num).css('display', 'none');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Referencia vecinal guardada correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      }
      if (data.codigo === 2) {
        $("#msj_error_vecinal" + num).css('display', 'none');
        $('.fila_btn_ref_vecinal' + num).empty();
        $('.fila_btn_ref_vecinal' + num).html(
          '<div class="col-6"><button type="button" class="btn btn-success btn-block" onclick="guardarRefVecinal(' +
          num + ',' + data.msg + ')">Guardar Referencia Vecinal #' + num +
          '</button></div><div class="col-6"><button type="button" class="btn btn-danger btn-block" onclick="mostrarMensajeConfirmacion(\'eliminar referencia vecinal\',' +
          num + ',' + data.msg + ')">Eliminar Referencia Vecinal #' + num +
          '</button></div><br><div id="msj_error_vecinal' + num +
          '" class="alert alert-danger hidden"></div><br>')
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Referencia vecinal guardada correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      }
    }
  });
}


function actualizarInvestigacion() {
  var datos = new FormData();
  datos.append('penal', $('#inv_penal').val());
  datos.append('penal_notas', $('#inv_penal_notas').val());
  datos.append('civil', $('#inv_civil').val());
  datos.append('civil_notas', $('#inv_civil_notas').val());
  datos.append('laboral', $('#inv_laboral').val());
  datos.append('laboral_notas', $('#inv_laboral_notas').val());
  datos.append('id_candidato', $("#idCandidato").val());

  $.ajax({
    url: '<?php echo base_url('Cliente_General/guardarInvestigacionLegal'); ?>',
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
        $("#legalesModal").modal('hide')
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha actualizado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        $("#legalesModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

function cargarDocumentosPanelCliente(id, nombre, paterno) {
  $(".idCandidato").val(id);
  $("#idCandidatoDocs").val(id);
  $(".nombreCandidato").text(nombre);
  $("#nameCandidato").val(nombre);

  $.ajax({
    url: '<?php echo base_url('Candidato/getDocumentosPanelCliente'); ?>',
    type: 'post',
    data: {
      'id_candidato': id,
      'prefijo': id + "_" + nombre + "" + paterno
    },
    success: function(res) {
      $("#tablaDocs").html(res);
    }
  });

  $("#docsModal").modal("show");
}

function subirDoc() {
  var data = new FormData();
  var doc = $("#documento")[0].files[0];
  data.append('id_candidato', $("#idCandidatoDocs").val());
  data.append('prefijo', $(".prefijo").val());
  data.append('tipo_doc', $("#tipo_archivo").val());
  data.append('documento', doc);
  id = $("#idCandidatoDocs").val();
  nombre = $("#nameCandidato").val();
  //console.log("🚀 ~ subirDoc ~ nombre:", nombre)
  $.ajax({
    url: "<?php echo base_url('Candidato/cargarDocumento'); ?>",
    method: "POST",
    data: data,
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
        $("#documento").val("");
        $("#tablaDocs").empty();
        $('#tipo_archivo').val('');
        $("#tablaDocs").html(data.msg);
        $("#docsModal #msj_error").css('display', 'none');

        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se cargó el documento correctamente',
          showConfirmButton: false,
          timer: 2500
        });

        // Llamar a cargarDocumentosPanelCliente
        cargarDocumentosPanelCliente(
          id,
          nombre,
          ""
        );
      }

      if (data.codigo === 0) {
        $("#docsModal #msj_error").css('display', 'block').html(data.message);
      }
    }
  });
}

function eliminarArchivo(idDoc, archivo, id_candidato) {
  $("#fila" + idDoc).remove();
  $.ajax({
    url: '<?php echo base_url('Candidato/eliminarDocumento'); ?>',
    method: 'POST',
    data: {
      'idDoc': idDoc,
      'archivo': archivo,
      'id_candidato': id_candidato
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
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha eliminado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Hubo un problema al eliminar, intenta más tarde',
          showConfirmButton: false,
          timer: 2500
        })
      }
    }
  });
}

function cargarDocumentosPanelClienteInterno(id, nombre, origen) {
  $("#employee_id").val(id);
  $("#idCandidatoDocsInterno").val(id);
  $(".nombreCandidato").text(nombre);
  $("#nameCandidatoInterno").val(nombre);
  $("#origen").val(origen);



  $.ajax({
    url: '<?php echo base_url('Candidato/getDocumentosPanelClienteInterno'); ?>',
    type: 'post',
    data: {
      'id_candidato': id,
      'prefijo': id + "_" + nombre,
      'origen': origen
    },
    success: function(res) {
      $("#tablaDocsInterno").html(res);
    }
  });

  $("#docsModalInterno").modal("show");
}

function subirDocInterno() {
  var origen = $("#origen").val();
  var nombreCandidato = $("#nameCandidatoInterno").val();
 
 var id = $("#employee_id").val();

  var data = new FormData();
  var modal = $("#docsModalInterno");

  var docInput = modal.find("#documentoInterno")[0];
  if (docInput.files.length === 0) {
    Swal.fire({
      icon: 'warning',
      title: 'Selecciona un archivo',
      text: 'Por favor, elige un archivo antes de subirlo.',
      timer: 2500
    });
    return;
  }
  var doc = docInput.files[0];
  var id_portal = "<?php echo $this->session->userdata('idPortal') ?>";
  // Sumar un año a la fecha
 
  // Agregar los datos esperados por el backend
  data.append('employee_id', modal.find("#employee_id").val());
  data.append('name', modal.find("#nombre_archivoInterno").val());
  data.append('description', null);
  data.append('expiry_date', '');
  data.append('expiry_reminder', modal.find("#recordatorioExpiracion").val() || "");
  data.append('file', doc);
  data.append('status', 1);
  data.append('id_portal', id_portal);
  
  
  var url_api = "<?php echo API_URL ?>";
  if (origen == 1) {
    data.append('carpeta', '_documentEmpleado');
    url_api = url_api + 'documents/';
  } else {
    url_api = url_api + 'exams/';
    data.append('carpeta', '_examEmpleado');
  }

  $.ajax({
    url: url_api,
    method: "POST",
    data: data,
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

      // Asegurar que res sea un objeto JSON
      var data = (typeof res === "string") ? JSON.parse(res) : res;

      if (data.message) {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.message,
          showConfirmButton: false,
          timer: 2500
        });

        // Limpiar campos del formulario
        let modal = $("#docsModalInterno"); // Asegúrate de cambiar esto por el ID correcto
        modal.find("#documentoInterno").val("");
        modal.find("#tablaDocsInterno").empty();
        modal.find("#nombre_archivoInterno").val("");
        console.log("🚀 ~ subirDocInterno ~ id:", id)
        console.log("🚀 ~ subirDocInterno ~ id:", nombreCandidato)
        console.log("🚀 ~ subirDocInterno ~ id:", origen)

        // Recargar documentos
        
        cargarDocumentosPanelClienteInterno(id,nombreCandidato, origen);
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: data.error || 'No se pudo subir el documento.',
          timer: 2500
        });
      }
    },
    error: function(jqXHR) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);

      let errorMessage = "Error en la solicitud.";

      if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
        errorMessage = jqXHR.responseJSON.error;
      } else if (jqXHR.status === 413) {
        errorMessage = "El archivo es demasiado grande.";
      } else if (jqXHR.status === 500) {
        errorMessage = "Error interno del servidor.";
      }

      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: errorMessage,
        timer: 2500
      });
    }
  });
}

function eliminarArchivoInterno(idDoc, archivo, id_candidato) {
  $("#fila" + idDoc).remove();
  $.ajax({
    url: '<?php echo base_url('Candidato/eliminarDocumento'); ?>',
    method: 'POST',
    data: {
      'idDoc': idDoc,
      'archivo': archivo,
      'id_candidato': id_candidato
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
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha eliminado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'Hubo un problema al eliminar, intenta más tarde',
          showConfirmButton: false,
          timer: 2500
        })
      }
    }
  });
}

function mostrarMensajeConfirmacion(accion, valor1, valor2) {
  if (accion == "eliminar referencia personal") {
    $('#titulo_mensaje').text('Eliminar referencia personal');
    $('#mensaje').html('¿Desea eliminar la referencia personal <b>#' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "eliminarRefPersonal(" + valor1 + "," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar integrante familiar") {
    $('#titulo_mensaje').text('Eliminar integrante familiar');
    $('#mensaje').html('¿Desea eliminar al integrante familiar <b>' + (valor2) + '</b>?');
    $('#btnConfirmar').attr("onclick", "eliminarIntegranteFamiliar(" + valor1 + ",\"" + valor2 + "\")");
    $("#familiaresModal").modal('hide');
    $('#mensajeModal').modal('show');
  }
  if (accion == "recrear reporte pdf") {
    $('#titulo_mensaje').text('Actualizar reporte PDF');
    $('#mensaje').html('¿Desea actualizar el formato PDF del reporte final de <b>' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "recrearPDF(" + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar referencia vecinal") {
    $('#titulo_mensaje').text('Eliminar referencia vecinal');
    $('#mensaje').html('¿Desea eliminar la referencia vecinal <b>#' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "eliminarRefVecinal(" + valor1 + "," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "reenviar credenciales al candidato") {
    $('#titulo_mensaje').text('Reenvío de credenciales de acceso');
    $('#mensaje').html('¿Desea reenviar el correo con nueva contraseña para el acceso del candidato <b>' + valor1 +
      '</b>?');
    $('#btnConfirmar').attr("onclick", "reenviarPassword(" + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "cancelar candidato") {
    $('#titulo_mensaje').text('Cancelar candidato');
    $('#mensaje').html('¿Desea cancelar al candidato <b>' + valor1 + '</b>?<br>');
    $('#campos_mensaje').html(
      '<div class="row"><div class="col-12"><label>Motivo de cancelación *</label><textarea class="form-control" rows="3" id="mensaje_comentario" name="mensaje_comentario"></textarea></div></div>'
    );
    $('#btnConfirmar').attr("onclick", "cancelarCandidato(" + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar laboral") {
    $('#titulo_mensaje').text('Eliminar laboral');
    $('#mensaje').html('¿Desea eliminar la laboral <b>#' + (valor2 + 1) +
      '</b>?<br> Esta acción también eliminará la verificación correspondiente');
    $('#btnConfirmar').attr("onclick", "eliminarLaboral(\"eliminar laboral\"," + valor1 + "," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar verificacion laboral") {
    $('#titulo_mensaje').text('Eliminar verificación laboral');
    $('#mensaje').html('¿Desea eliminar la verificación laboral <b>#' + (valor2 + 1) + '</b>?');
    $('#btnConfirmar').attr("onclick", "eliminarLaboral(\"eliminar verificacion laboral\"," + valor1 + "," +
      valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar antecedente laboral") {
    $('#titulo_mensaje').text('Eliminar laboral');
    $('#mensaje').html('¿Desea eliminar la laboral <b>#' + valor2 + '</b>?');
    $('#btnConfirmar').attr("onclick", "eliminarLaboral(\"eliminar antecedente laboral\"," + valor1 + "," + valor2 +
      ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar contacto laboral") {
    $('#titulo_mensaje').text('Eliminar contacto/informante laboral');
    $('#mensaje').html('¿Desea eliminar el contacto/informante de la laboral <b>#' + valor2 + '</b>?');
    $('#btnConfirmar').attr("onclick", "eliminarLaboral(\"eliminar contacto laboral\"," + valor1 + "," + valor2 +
      ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar referencia cliente") {
    $('#titulo_mensaje').text('Eliminar referencia de cliente');
    $('#mensaje').html('¿Desea eliminar la referencia <b>#' + valor1 + '</b>?');
    $('#btnConfirmar').attr("onclick", "eliminarRefCliente(" + valor1 + "," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
  if (accion == "eliminar gap") {
    $('#titulo_mensaje').text('Eliminar Gap');
    $('#mensaje').html('¿Desea eliminar el gap?');
    $('#btnConfirmar').attr("onclick", "eliminarGap(" + valor1 + "," + valor2 + ")");
    $('#mensajeModal').modal('show');
  }
}

function cancelarCandidato(id_candidato) {
  let comentario = $('#mensaje_comentario').val();
  $.ajax({
    url: '<?php echo base_url('Candidato/cancelarCandidato'); ?>',
    type: 'post',
    data: {
      'id_candidato': id_candidato,
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
        $("#mensajeModal").modal('hide');
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

function reenviarPassword(id_candidato) {
  var datos = new FormData();
  datos.append('id_candidato', id_candidato);

  $.ajax({
    url: '<?php echo base_url('Mail/reenviarPassword'); ?>',
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
        $("#mensajeModal").modal('hide');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha reenviado la contraseña correctamente',
          html: data.credenciales,
          width: '50em',
          confirmButtonText: 'Entendido'
        })
        // Swal.fire({
        //   position: 'center',
        //   icon: 'success',
        //   title: 'Se ha reenviado la contraseña correctamente',
        //   showConfirmButton: false,
        //   timer: 2500
        // })
      }
      if (data.codigo === 0) {
        $("#mensajeModal").modal('hide')
        Swal.fire({
          position: 'center',
          icon: 'warning',
          title: 'Se ha generado y guardado la nueva contraseña pero hubo un problema al enviar el correo',
          showConfirmButton: false,
          timer: 2500
        })
      }
    }
  });
}

function ejecutarAccion() {
  var accion = $("#btnGuardar").val();
  var id_candidato = $("#idCandidato").val();
  var correo = $("#correo").val();
  if (accion == 'cancel') {
    $.ajax({
      url: '<?php echo base_url('Candidato/cancelarCandidato'); ?>',
      type: 'post',
      data: {
        'id_candidato': id_candidato
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
          $("#quitarModal").modal('hide');
          recargarTable()
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Se ha cancelado correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        }
      }
    });
  }
}

function aceptarRevision() {
  $("#revisionModal").modal('hide');
  $("#completarModal").modal('show');
}

function guardarConclusionTemporal() {
  var id_candidato = $("#idCandidato").val();
  var datos = new FormData();
  datos.append('comentario', $("#conclusion_temporal").val());
  datos.append('id_candidato', id_candidato);

  $.ajax({
    url: '<?php echo base_url('Candidato_Conclusion/setConclusion'); ?>',
    method: "POST",
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
        $("#conclusionModal").modal('hide')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'La conclusión temporal se ha guardado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        $("#conclusionModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

function finalizarProceso() {
  var id_candidato = $("#idCandidato").val();
  var datos = new FormData();
  datos.append('personal1', $("#personal1").val());
  datos.append('personal2', $("#personal2").val());
  datos.append('personal3', $("#personal3").val());
  datos.append('personal4', $("#personal4").val());
  datos.append('laboral1', $("#laboral1").val());
  datos.append('laboral2', $("#laboral2").val());
  datos.append('socio1', $("#socio1").val());
  datos.append('socio2', $("#socio2").val());
  datos.append('visita1', $("#visita1").val());
  datos.append('visita2', $("#visita2").val());
  datos.append('investigacion', $("#conclusion_investigacion").val());
  datos.append('recomendable', $("#recomendable").val());
  datos.append('comentario', $("#comentario_bgc").val());
  datos.append('id_candidato', id_candidato);

  $.ajax({
    url: '<?php echo base_url('Candidato_Conclusion/setFinalizar'); ?>',
    method: "POST",
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
        $("#completarModal").modal('hide')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha finalizado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        $("#completarModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

function finalizarEstudio() {
  var datos = new FormData();
  datos.append('check_identidad', $("#check_identidad").val());
  datos.append('check_laboral', $("#check_laboral").val());
  datos.append('check_estudios', $("#check_estudios").val());
  datos.append('check_penales', $("#check_penales").val());
  datos.append('check_ofac', $("#check_ofac").val());
  datos.append('check_global', $("#check_global").val());
  datos.append('check_credito', $("#check_credito").val());
  datos.append('check_sex_offender', $("#check_sex_offender").val());
  datos.append('check_medico', $("#check_medico").val());
  datos.append('check_domicilio', $("#check_domicilio").val());
  datos.append('check_professional_accreditation', $("#check_professional_accreditation").val());
  datos.append('check_ref_academica', $("#check_ref_academica").val());
  datos.append('check_nss', $("#check_nss").val());
  datos.append('check_ciudadania', $("#check_ciudadania").val());
  datos.append('check_mvr', $("#check_mvr").val());
  datos.append('check_servicio_militar', $("#check_servicio_militar").val());
  datos.append('check_credencial_academica', $("#check_credencial_academica").val());
  datos.append('check_ref_profesional', $("#check_ref_profesional").val());
  datos.append('comentario_final', $("#comentario_final").val());
  datos.append('bgc_status', $("#bgc_status").val());
  datos.append('id_candidato', $("#idCandidato").val());
  $.ajax({
    url: '<?php echo base_url('Candidato_Conclusion/setBGC'); ?>',
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
        $("#finalizarModal").modal('hide')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha finalizado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        $("#finalizarModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

function finalizarProcesoSinEstatus() {
  var id_candidato = $("#idCandidato").val();
  var datos = new FormData();
  datos.append('id_candidato', id_candidato);

  $.ajax({
    url: '<?php echo base_url('Candidato_Conclusion/setFinalizar'); ?>',
    method: "POST",
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
        $("#completarModal").modal('hide')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha finalizado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        $("#completarModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

function registrarFechaFinal(id_candidato) {
  $.ajax({
    url: '<?php echo base_url('Candidato_Conclusion/storeFechaFinalizacion'); ?>',
    method: "POST",
    data: {
      'id_candidato': id_candidato
    },
    success: function(res) {

    }
  });
}

function actualizarProceso() {
  var id_candidato = $("#idCandidato").val();
  var id_doping = $("#idDoping").val();
  $.ajax({
    url: '<?php echo base_url('Cliente_General/actualizarProcesoCandidato'); ?>',
    method: 'POST',
    data: {
      'id_candidato': id_candidato,
      'id_doping': id_doping
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      if (res == 1) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha actualizado el proceso del candidato correctamente',
          showConfirmButton: false,
          timer: 2500
        });
        setTimeout(() => {
          recargarTable()
        }, 2000);
        /*localStorage.setItem("success", 1);
        location.reload();*/
      }
    }
  });
}

function verMensajesAvances(id_candidato, candidato) {
  $('#avancesModal #nombreCandidato').text(candidato)
  $("#idCandidato").val(id_candidato);
  getMensajesAvances(id_candidato, candidato);
  $("#avancesModal").modal("show");
}

function getMensajesAvances(id_candidato, candidato) {
  $("#divMensajesAvances").empty();
  $.ajax({
    url: '<?php echo base_url('Candidato/checkAvances'); ?>',
    method: 'POST',
    data: {
      'id_candidato': id_candidato
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      $("#divMensajesAvances").html(res)
    }
  });
}

//TODO:    verificar si las  funciones  son necesarias FUNCIONES OBSOLETAS
/*
function crearAvance() {
  let id_candidato = $("#idCandidato").val()
  let candidato = $('#avancesModal #nombreCandidato').text()
  var datos = new FormData();
  datos.append('id_candidato', id_candidato);
  datos.append('comentario', $("#mensaje_avance").val());
  datos.append('adjunto', $("#adjunto")[0].files[0]);
  $.ajax({
    url: '<?php echo base_url('Candidato/createEstatusAvance'); ?>',
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
      var dato = JSON.parse(res);
      if (dato.codigo === 1) {
        $("#adjunto").val('');
        $("#mensaje_avance").val('');
        getMensajesAvances(id_candidato, candidato);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: dato.msg,
          showConfirmButton: false,
          timer: 2500
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

function confirmarEditarAvance(id) {
  let msj = $('#avanceMensaje' + id).val();
  let archivo = $('#avanceArchivo' + id).val();
  let msj_archivo = '';
  let file = document.getElementById('avanceArchivo' + id);
  if (file.files.length > 0) {
    let filename = file.files[0].name;
    msj_archivo = (archivo !== '') ? '<br>¿Y la imagen? <br><b>' + filename + '</b>' : '';
  }
  $('#titulo_mensaje').text('Confirmar modificación de mensaje de avance');
  $('#mensaje').html('¿Desea confirmar el mensaje? <br><b>"' + msj + '"</b>' + msj_archivo);
  $('#btnConfirmar').attr("onclick", "editarAvance(" + id + ",\"" + msj + "\")");
  $('#mensajeModal').modal('show');
}

function editarAvance(id, msj) {
  let id_candidato = $("#idCandidato").val()
  let candidato = $('#avancesModal #nombreCandidato').text()
  let datos = new FormData();
  datos.append('id', id);
  datos.append('msj', msj);
  datos.append('archivo', $("#avanceArchivo" + id)[0].files[0]);
  $.ajax({
    url: '< ?php echo base_url('Avance/editar'); ?>',
    async: false,
    type: 'post',
    data: datos,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      $('#mensajeModal').modal('hide');
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 300);
      var dato = JSON.parse(res);
      if (dato.codigo === 1) {
        getMensajesAvances(id_candidato, candidato);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: dato.msg,
          showConfirmButton: false,
          timer: 2500
        })
      }
    }
  });
}

function confirmarEliminarAvance(id) {
  let msj = $('#avanceMensaje' + id).val();
  $('#titulo_mensaje').text('Confirmar eliminar mensaje de avance');
  $('#mensaje').html('¿Desea eliminar el mensaje? <br><b>"' + msj + '"</b>');
  $('#btnConfirmar').attr("onclick", "eliminarAvance(" + id + ")");
  $('#mensajeModal').modal('show');
}

function eliminarAvance(id) {
  let id_candidato = $("#idCandidato").val()
  let candidato = $('#avancesModal #nombreCandidato').text()
  $.ajax({
    url: '< ?php echo base_url('Avance/eliminar'); ?>',
    type: 'POST',
    data: {
      'id': id
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      $('#mensajeModal').modal('hide');
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 300);
      var dato = JSON.parse(res);
      if (dato.codigo === 1) {
        getMensajesAvances(id_candidato, candidato);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: dato.msg,
          showConfirmButton: false,
          timer: 2500
        })
      }
    }
  });
}
*/


function guardarExtrasCandidato(id_candidato) {
  var muebles = $("#candidato_muebles").val();
  var adeudo = $("#candidato_adeudo").val();
  var notas = $("#notas").val();
  var ingresos = $("#candidato_ingresos").val();
  var id_candidato = $("#idCandidato").val();

  $.ajax({
    url: '<?php echo base_url('Cliente_General/editarExtrasCandidato'); ?>',
    method: "POST",
    data: {
      'id_candidato': id_candidato,
      'notas': notas,
      'muebles': muebles,
      'adeudo': adeudo,
      'ingresos': ingresos
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
        $("#mobiliario_msj_error").css('display', 'none')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha actualizado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        $("#mobiliario_msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}


function finalizarInvestigaciones() {
  var datos = new FormData();
  datos.append('id_candidato', $("#idCandidato").val());
  datos.append('comentario', $("#comentario_investigaciones").val());
  datos.append('estatus', $("#estatus_investigaciones").val());

  $.ajax({
    url: '<?php echo base_url('Candidato_Conclusion/setFinalizar'); ?>',
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
        $("#finalizarInvestigacionesModal").modal('hide');
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha finalizado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        $('#finalizarInvestigacionesModal #msj_error').css('display', 'block').html(data.msg);
      }
    }
  });
}

function guardarAsignacionSubcliente() {
  var datos = new FormData();
  datos.append('id_subcliente', $("#subcliente_asignado").val());
  datos.append('id_candidato', $("#idCandidato").val());

  $.ajax({
    url: '<?php echo base_url('Candidato/setSubcliente'); ?>',
    type: 'POST',
    data: datos,
    contentType: false,
    cache: false,
    processData: false,
    /*beforeSend: function() {
    	$('.loader').css("display", "block");
    },*/
    success: function(res) {
      /*setTimeout(function() {
      	$('.loader').fadeOut();
      }, 200);*/
      var data = JSON.parse(res);
      if (data.codigo === 1) {
        $("#asignarSubclienteModal").modal('hide')
        recargarTable()
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se asignó subcliente al candidato correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        $("#asignarSubclienteModal").modal('hide')
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema al guardar',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
      }
    }
  });
}
//Verificacion de estudios
function verificacionEstudios() {
  var id_candidato = $("#idCandidato").val();
  var f = new Date();
  var dia = f.getDate();
  var mes = (f.getMonth() + 1);
  var dia = (dia < 10) ? '0' + dia : dia;
  var mes = (mes < 10) ? '0' + mes : mes;
  $("#fecha_estatus_estudio").text(dia + "/" + mes + "/" + f.getFullYear());
  $.ajax({
    url: '<?php echo base_url('Candidato/checkEstatusEstudios'); ?>',
    method: 'POST',
    data: {
      'id_candidato': id_candidato
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      if (res != 0) {
        var aux = res.split('@@');
        $("#div_crearEstatusEstudio").empty();
        $("#idVerificacionEstudio").val(aux[1]);
        $("#div_crearEstatusEstudio").append(aux[0]);
        $("#estudio_estatus").val(aux[2]);
      } else {
        $("#div_crearEstatusEstudio").empty();
        $("#div_crearEstatusEstudio").append('<p>Sin registros</p>');
        $("#div_estatus_estudio").css('display', 'block');
        $("#idVerificacionEstudio").val(0);
        $('#estudio_estatus').val('Validated');
      }
    }
  });
  $("#verificacionEstudiosModal").modal("show");
}

function registrarEstatusEstudio() {
  var datos = new FormData();
  datos.append('comentario', $("#estudio_estatus_comentario").val());
  datos.append('estatus', $("#estudio_estatus").val());
  datos.append('id_candidato', $("#idCandidato").val());
  datos.append('id_verificacion', $("#idVerificacionEstudio").val());
  $.ajax({
    url: '<?php echo base_url('Candidato/registrarEstatusEstudio'); ?>',
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
        $("#verificacionEstudiosModal  #msj_error").css('display', 'none');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha guardado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
        var aux = data.msg.split('@@');
        $("#idVerificacionEstudio").val(aux[1]);
        $("#estudio_estatus_comentario").val('');
        $("#div_crearEstatusEstudio").empty();
        $("#div_crearEstatusEstudio").append(aux[0]);
        $("#estudio_estatus").val(aux[2]);
      } else {
        $("#verificacionEstudiosModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

function accionEstatusEstudio(id_detalle, accion) {
  var datos = new FormData();
  datos.append('comentario', $("#comentario_estudio" + id_detalle).val());
  datos.append('fecha', $("#fecha_estatus_estudio" + id_detalle).val());
  datos.append('id_candidato', $("#idCandidato").val());
  datos.append('id_verificacion', $("#idVerificacionEstudio").val());
  datos.append('id_detalle', id_detalle);
  datos.append('accion', accion);
  if (accion == 'editar') {
    $.ajax({
      url: '<?php echo base_url('Candidato/accionEstatusEstudios'); ?>',
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
          $("#verificacionEstudiosModal  #msj_error").css('display', 'none');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Se ha actualizado correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        } else {
          $("#verificacionEstudiosModal #msj_error").css('display', 'block').html(data.msg);
        }
      }
    });
  }
  if (accion == 'eliminar') {
    $('#fila_estatus' + id_detalle).hide();
    $.ajax({
      url: '<?php echo base_url('Candidato/accionEstatusEstudios'); ?>',
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
          $("#verificacionEstudiosModal  #msj_error").css('display', 'none');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Se ha eliminado correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        } else {
          $("#verificacionEstudiosModal #msj_error").css('display', 'block').html(data.msg);
        }
      }
    });
  }
}

function guardarEstatusEstudios() {
  var id_verificacion = $("#idVerificacionEstudio").val();
  var id_candidato = $("#idCandidato").val();
  var estatus = $("#estudio_estatus").val();
  if (id_verificacion == 0) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'No hay registros de comentarios',
      showConfirmButton: false,
      timer: 2500
    })
  } else {
    $.ajax({
      url: '<?php echo base_url('Candidato/guardarEstatusEstudios'); ?>',
      method: 'POST',
      data: {
        'id_verificacion': id_verificacion,
        'id_candidato': id_candidato,
        'estatus': estatus
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha actualizado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      }
    });
  }
}
//Verificacion de laborales
function verificacionLaborales() {
  var id_candidato = $("#idCandidato").val();
  var f = new Date();
  var dia = f.getDate();
  var mes = (f.getMonth() + 1);
  var dia = (dia < 10) ? '0' + dia : dia;
  var mes = (mes < 10) ? '0' + mes : mes;
  $("#fecha_estatus_laboral").text(dia + "/" + mes + "/" + f.getFullYear());
  $.ajax({
    url: '<?php echo base_url('Candidato/checkEstatusLaborales'); ?>',
    method: 'POST',
    data: {
      'id_candidato': id_candidato
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      if (res != 0) {
        var aux = res.split('@@');
        $("#div_crearEstatusLaboral").empty();
        $("#idVerificacionLaboral").val(aux[1]);
        $("#div_crearEstatusLaboral").append(aux[0]);
        $("#laborales_estatus").val(aux[2]);
      } else {
        $("#div_crearEstatusLaboral").empty();
        $("#div_crearEstatusLaboral").append('<p>Sin registros </p>');
        $("#div_estatus_laboral").css('display', 'block');
        $("#idVerificacionLaboral").val(0);
        $("#laborales_estatus").val('Validated');
      }
    }
  });
  $("#verificacionLaboralesModal").modal("show");
}

function registrarEstatusLaboral() {
  var datos = new FormData();
  datos.append('comentario', $("#laboral_estatus_comentario").val());
  datos.append('estatus', $("#laborales_estatus").val());
  datos.append('id_candidato', $("#idCandidato").val());
  datos.append('id_verificacion', $("#idVerificacionLaboral").val());
  $.ajax({
    url: '<?php echo base_url('Candidato/registrarEstatusLaborales'); ?>',
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
        $("#verificacionLaboralesModal  #msj_error").css('display', 'none');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha guardado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
        var aux = data.msg.split('@@');
        $("#idVerificacionLaboral").val(aux[1]);
        $("#laboral_estatus_comentario").val("");
        $("#div_crearEstatusLaboral").empty();
        $("#div_crearEstatusLaboral").append(aux[0]);
        $("#laborales_estatus").val(aux[2]);
      } else {
        $("#verificacionLaboralesModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

function accionEstatusLaborales(id_detalle, accion) {
  var datos = new FormData();
  datos.append('comentario', $("#comentario_laborales" + id_detalle).val());
  datos.append('fecha', $("#fecha_estatus_laborales" + id_detalle).val());
  datos.append('id_candidato', $("#idCandidato").val());
  datos.append('id_verificacion', $("#idVerificacionLaboral").val());
  datos.append('id_detalle', id_detalle);
  datos.append('accion', accion);
  if (accion == 'editar') {
    $.ajax({
      url: '<?php echo base_url('Candidato/accionEstatusLaborales'); ?>',
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
          $("#verificacionLaboralesModal  #msj_error").css('display', 'none');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Se ha actualizado correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        } else {
          $("#verificacionLaboralesModal #msj_error").css('display', 'block').html(data.msg);
        }
      }
    });
  }
  if (accion == 'eliminar') {
    $('#fila_estatus' + id_detalle).hide();
    $.ajax({
      url: '<?php echo base_url('Candidato/accionEstatusLaborales'); ?>',
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
          $("#verificacionLaboralesModal  #msj_error").css('display', 'none');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Se ha eliminado correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        } else {
          $("#verificacionLaboralesModal #msj_error").css('display', 'block').html(data.msg);
        }
      }
    });
  }
}

function guardarEstatusLaborales() {
  var id_verificacion = $("#idVerificacionLaboral").val();
  var id_candidato = $("#idCandidato").val();
  var estatus = $("#laborales_estatus").val();
  if (id_verificacion == 0) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'No hay registros de comentarios',
      showConfirmButton: false,
      timer: 2500
    })
  } else {
    $.ajax({
      url: '<?php echo base_url('Candidato/guardarEstatusLaborales'); ?>',
      method: 'POST',
      data: {
        'id_verificacion': id_verificacion,
        'id_candidato': id_candidato,
        'estatus': estatus
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha actualizado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      }
    });
  }
}
//Verificacion criminal
function verificacionPenales() {
  var id_candidato = $("#idCandidato").val();
  var f = new Date();
  var dia = f.getDate();
  var mes = (f.getMonth() + 1);
  var dia = (dia < 10) ? '0' + dia : dia;
  var mes = (mes < 10) ? '0' + mes : mes;
  $("#fecha_estatus_penales").text(dia + "/" + mes + "/" + f.getFullYear());
  $.ajax({
    url: '<?php echo base_url('Candidato/checkEstatusPenales'); ?>',
    method: 'POST',
    data: {
      'id_candidato': id_candidato
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      if (res != 0) {
        var aux = res.split('@@');
        $("#div_crearEstatusPenales").empty();
        $("#idVerificacionPenales").val(aux[1]);
        $("#div_crearEstatusPenales").append(aux[0]);
        $("#criminal_estatus").val(aux[2]);
      } else {
        $("#div_crearEstatusPenales").empty();
        $("#div_crearEstatusPenales").append('<p>Sin registros </p>');
        $("#div_estatus_penales").css('display', 'block');
        $("#idVerificacionPenales").val(0);
        $("#criminal_estatus").val('Validated');
      }

    }
  });
  $("#verificacionPenalesModal").modal("show");
}

function registrarEstatusPenales() {
  var datos = new FormData();
  datos.append('comentario', $("#penales_estatus_comentario").val());
  datos.append('estatus', $("#criminal_estatus").val());
  datos.append('id_candidato', $("#idCandidato").val());
  datos.append('id_verificacion', $("#idVerificacionPenales").val());
  $.ajax({
    url: '<?php echo base_url('Candidato/registrarEstatusPenales'); ?>',
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
        $("#verificacionPenalesModal  #msj_error").css('display', 'none');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha guardado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
        var aux = data.msg.split('@@');
        $("#idVerificacionPenales").val(aux[1]);
        $("#penales_estatus_comentario").val("");
        $("#div_crearEstatusPenales").empty();
        $("#div_crearEstatusPenales").append(aux[0]);
        $("#criminal_estatus").val(aux[2]);
      } else {
        $("#verificacionPenalesModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

function accionEstatusPenales(id_detalle, accion) {
  var datos = new FormData();
  datos.append('comentario', $("#comentario_penales" + id_detalle).val());
  datos.append('fecha', $("#fecha_estatus_penales" + id_detalle).val());
  datos.append('id_candidato', $("#idCandidato").val());
  datos.append('id_verificacion', $("#idVerificacionPenales").val());
  datos.append('id_detalle', id_detalle);
  datos.append('accion', accion);
  if (accion == 'editar') {
    $.ajax({
      url: '<?php echo base_url('Candidato/accionEstatusPenales'); ?>',
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
          $("#verificacionPenalesModal  #msj_error").css('display', 'none');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Se ha actualizado correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        } else {
          $("#verificacionPenalesModal #msj_error").css('display', 'block').html(data.msg);
        }
      }
    });
  }
  if (accion == 'eliminar') {
    $('#fila_estatus' + id_detalle).hide();
    $.ajax({
      url: '<?php echo base_url('Candidato/accionEstatusPenales'); ?>',
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
          $("#verificacionPenalesModal  #msj_error").css('display', 'none');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Se ha eliminado correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        } else {
          $("#verificacionPenalesModal #msj_error").css('display', 'block').html(data.msg);
        }
      }
    });
  }
}

function guardarEstatusPenales() {
  var id_verificacion = $("#idVerificacionPenales").val();
  var id_candidato = $("#idCandidato").val();
  var estatus = $("#criminal_estatus").val();
  if (id_verificacion == 0) {
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'No hay registros de comentarios',
      showConfirmButton: false,
      timer: 2500
    })
  } else {
    $.ajax({
      url: '<?php echo base_url('Candidato/guardarEstatusPenales'); ?>',
      method: 'POST',
      data: {
        'id_verificacion': id_verificacion,
        'id_candidato': id_candidato,
        'estatus': estatus
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha actualizado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      }
    });
  }
}

function generarHistorialCredito() {
  var id_candidato = $("#idCandidato").val();
  var comentario = $("#credito_comentario").val();
  var fi = $("#credito_fecha_inicio").val();
  var ff = $("#credito_fecha_fin").val();
  $.ajax({
    url: '<?php echo base_url('Client/createHistorialCrediticio'); ?>',
    method: 'POST',
    data: {
      'id_candidato': id_candidato,
      'fi': fi,
      'ff': ff,
      'comentario': comentario
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      var data = JSON.parse(res);
      if (data.codigo === 1) {
        $("#creditoModal #msj_error").css('display', 'none');
        $("#credito_fecha_inicio").val("");
        $("#credito_fecha_fin").val("");
        $("#credito_comentario").val("");
        $("#div_antescredit").empty();
        $("#div_antescredit").append(data.msg);
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha actualizado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      }
      if (data.codigo === 0) {
        $("#creditoModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}
/*function confirmarAccion(accion,valor){
	$('#mensajeModal').modal('hide');
	var id_candidato = $('#idCandidato').val();
	//Colocar en privado o publico
	if(accion == 1){
		$.ajax({
			url: '< ?php echo base_url('Candidato/guardarVisibilidadCandidato'); ?>',
			type: 'post',
			data: {
				'id_candidato': id_candidato,
				'visibilidad': valor
			},
			beforeSend: function() {
				$('.loader').css("display", "block");
			},
			success: function(res) {
				setTimeout(function() {
					$('.loader').fadeOut();
				}, 300);
				var dato = JSON.parse(res);
				if(dato.codigo === 1){
					recargarTable();
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: dato.msg,
						showConfirmButton: false,
						timer: 3000
					})
				}
			}
		});
	}
}*/
function confirmacionAccion(tipo_accion, seccion, id, id_candidato) {
  if (seccion == 'gaps') {
    if (tipo_accion == 'eliminar') {
      $('#confirmarID').val(id);
      $('#idCandidato').val(id_candidato);
      $('#confirmarTipoAccion').val(tipo_accion);
      $('#confirmarSeccion').val(seccion);
      $('#titulo_confirmacion').text('Confirmar eliminación de GAP');
      $('#mensaje_confirmacion').text('¿Desea eliminar el GAP?');
    }
  }
  $('#confirmarAccionModal').modal('show');
}

function actualizarPruebasCandidato() {
  var id_cliente = '<?php echo $this->uri->segment(3) ?>';
  var datos = new FormData();
  datos.append('id_candidato', $('#idCandidato').val());
  datos.append('antidoping', $('#prueba_antidoping').val());
  datos.append('psicometrico', $('#prueba_psicometrica').val());
  datos.append('medico', $('#prueba_medica').val());
  datos.append('id_cliente', id_cliente);

  $.ajax({
    url: '<?php echo base_url('Candidato/actualizarPruebasCandidato'); ?>',
    method: "POST",
    data: datos,
    contentType: false,
    cache: false,
    processData: false,
    /*beforeSend: function() {
    	$('.loader').css("display", "block");
    },*/
    success: function(res) {
      /*setTimeout(function() {
      	$('.loader').fadeOut();
      }, 2000);*/
      var data = JSON.parse(res);
      if (data.codigo === 1) {
        recargarTable();
        $('#pruebasModal').modal('hide');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha actualizado correctamente',
          showConfirmButton: false,
          timer: 2500
        });
      } else {
        $("#pruebasModal #msj_error").css('display', 'block').html(data.msg);
      }
    }
  });
}

function guardarPrivacidad() {
  var id_candidato = $("#idCandidato").val();
  var privacidad = $("#candidato_privacidad").val();
  $.ajax({
    url: '<?php echo base_url('Candidato/guardarPrivacidad'); ?>',
    method: 'POST',
    data: {
      'id': id_candidato,
      'privacidad': privacidad
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      recargarTable();
      $('#privacidadModal').modal('hide');
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Se ha guardado correctamente',
        showConfirmButton: false,
        timer: 2500
      })
    }
  });
}

function recrearPDF(id_candidato) {
  $.ajax({
    url: '<?php echo base_url('Candidato_Conclusion/recreatePDF'); ?>',
    method: 'POST',
    data: {
      'idPDF': id_candidato
    },
    success: function(res) {
      $('#mensajeModal').modal('hide');
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Se ha actualizado el reporte final correctamente',
        showConfirmButton: false,
        timer: 2500
      });
      setTimeout(function() {
        recargarTable()
      }, 2000);
    }
  });
}

function getGaps(id_candidato) {
  $('#contenedor_gaps').empty();
  $.ajax({
    url: '<?php echo base_url('Gap/getById'); ?>',
    method: 'POST',
    data: {
      'id': id_candidato
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      if (res != 0) {
        let datos = JSON.parse(res)
        let rows = ''
        let consecutivo = 1
        for (let row of datos) {
          //$('#rowForm').append('<div class="col-6 mb-3"><label>From</label><input type="text" class="form-control" id="fecha_inicio_gap'+row['id']+'" name="fecha_inicio_gap'+row['id']+'" value="'+row['fecha_inicio']+'"></div><div class="col-6 mb-3"><label>To</label><input type="text" class="form-control" id="fecha_fin_gap'+row['id']+'" name="fecha_fin_gap'+row['id']+'" value="'+row['fecha_fin']+'"></div><div class="col-12 mb-3"><label>Reason and activities performed</label><textarea class="form-control" rows="3" id="razon_gap'+row['id']+'">'+row['razon']+'</textarea></div><div class="col-12 mt-3 mb-5 text-center"><a href="javascript:void(0)" class="btn btn-danger" onclick="eliminarGap('+id_candidato+','+row['id']+')"><i class="fas fa-trash"></i> Delete Gap</a></div><div class="col-12 mt-3 text-center"><a href="javascript:void(0)" class="btn btn-success" onclick="guardarGap('+id_candidato+')"><i class="fas fa-plus-circle"></i> Add Gap</a></div>')
          rows += '<tr id="fecha_inicio_gap' + row['id'] + '"><td>' + consecutivo + '</td><td>' +
            row['fecha_inicio'] + '</td><td>' + row['fecha_fin'] + '</td><td>' + row['razon'] +
            '</td><td><a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="mostrarMensajeConfirmacion(\'eliminar gap\', ' +
            row['id'] + ', ' + id_candidato +
            ')"><i class="fas fa-trash"></i> Delete Gap</a></td></tr>'
          consecutivo++
        }
        $('#contenedor_gaps').append(
          '<table class="table mb-5"><thead><tr><th>#</th><th>From</th><th>To</th><th>Reason and activities performed</th><th>Actions</th></tr></thead><tbody>' +
          rows + '</tbody></table>')
        $('#contenedor_gaps').append(
          '<form id="formNuevoGap"><div class="row"><div class="col-6 mb-3"><label>From</label><input type="text" class="form-control" id="fecha_inicio_gap" name="fecha_inicio_gap"></div><div class="col-6 mb-3"><label>To</label><input type="text" class="form-control" id="fecha_fin_gap" name="fecha_fin_gap"></div><div class="col-12 mb-3"><label>Reason and activities performed</label><textarea class="form-control" rows="3" id="razon_gap"></textarea></div></div></form><div class="col-12 mt-3 text-center"><a href="javascript:void(0)" class="btn btn-success" onclick="guardarGap(' +
          id_candidato + ')"><i class="fas fa-plus-circle"></i> Add Gap</a></div>')
      } else {
        $("#contenedor_gaps").html(
          '<div class="col-12"><p class="text-center">No records</p></div>');
        $('#contenedor_gaps').append(
          '<form id="formNuevoGap"><div class="row"><div class="col-6 mb-3"><label>From</label><input type="text" class="form-control" id="fecha_inicio_gap" name="fecha_inicio_gap"></div><div class="col-6 mb-3"><label>To</label><input type="text" class="form-control" id="fecha_fin_gap" name="fecha_fin_gap"></div><div class="col-12 mb-3"><label>Reason and activities performed</label><textarea class="form-control" rows="3" id="razon_gap"></textarea></div></div></form><div class="col-12 mt-3 text-center"><a href="javascript:void(0)" class="btn btn-success" onclick="guardarGap(' +
          id_candidato + ')"><i class="fas fa-plus-circle"></i> Add Gap</a></div>')
      }
      $("#gapsModal").modal('show');
    }
  });
}

function guardarGap(id_candidato) {
  let razon = $("#razon_gap").val();
  let fi = $("#fecha_inicio_gap").val();
  let ff = $("#fecha_fin_gap").val();
  $.ajax({
    url: '<?php echo base_url('Gap/store'); ?>',
    method: 'POST',
    data: {
      'id_candidato': id_candidato,
      'fi': fi,
      'ff': ff,
      'razon': razon
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      if (res != 0) {
        let data = JSON.parse(res);
        if (data.codigo === 1) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: data.msg,
            showConfirmButton: false,
            timer: 2500
          })
          $('#formNuevoGap')[0].reset();
          getGaps(id_candidato)
        } else {
          Swal.fire({
            icon: 'error',
            title: 'There was a problem submitting the form',
            html: data.msg,
            width: '50em',
            confirmButtonText: 'Close'
          })
        }
      }
    }
  });
}

function eliminarGap(id_gap, id_candidato) {
  var datos = new FormData();
  datos.append('id_candidato', id_candidato);
  datos.append('id_gap', id_gap);

  $.ajax({
    url: '<?php echo base_url('Gap/delete'); ?>',
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
        $('#mensajeModal').modal('hide');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Gap deleted successfully',
          showConfirmButton: false,
          timer: 2500
        })
        $('#formNuevoGap')[0].reset();
        getGaps(id_candidato)
      }
    }
  });
}

function editarGap(id, id_candidato) {
  var razon = $("#razon_gap" + id).val();
  var fi = $("#fecha_inicio_gap" + id).val();
  var ff = $("#fecha_fin_gap" + id).val();
  $.ajax({
    url: '<?php echo base_url('Candidato/editarGap'); ?>',
    method: 'POST',
    data: {
      'id': id,
      'id_candidato': id_candidato,
      'fi': fi,
      'ff': ff,
      'razon': razon
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
        $("#error_gap" + id).css('display', 'none');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Se ha actualizado correctamente',
          showConfirmButton: false,
          timer: 2500
        })
      } else {
        $("#error_gap" + id).css('display', 'block').html(data.msg);
      }
    }
  });
}

function generarAcceso() {
  let url = '<?php echo base_url() . "Form/external?fid="; ?>';
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
      $("#tokenForm").val(res)
      $("#link_acceso").val(url + res)
    }
  });
}

function addToken() {
  let id_candidato = $("#idCandidato").val();
  let token = $('#tokenForm').val();
  $.ajax({
    url: '<?php echo base_url('Candidato/addToken'); ?>',
    type: 'post',
    data: {
      'token': token,
      'id': id_candidato
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);
      $('#accesoFormModal').modal('hide')
      recargarTable()
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Se ha registrado el link de acceso correctamente',
        showConfirmButton: false,
        timer: 2500
      })
    }
  });
}
//Funciones de apoyo
function recargarTable() {
  $("#tabla").DataTable().ajax.reload();
}

function respaldoTxt(formdata, nombreArchivo) {
  var textFileAsBlob = new Blob([formdata], {
    type: 'text/plain'
  });
  var fileNameToSaveAs = nombreArchivo + ".txt";
  var downloadLink = document.createElement("a");
  downloadLink.download = fileNameToSaveAs;
  downloadLink.innerHTML = "My Hidden Link";
  window.URL = window.URL || window.webkitURL;
  downloadLink.href = window.URL.createObjectURL(textFileAsBlob);
  downloadLink.onclick = destroyClickedElement;
  downloadLink.style.display = "none";
  document.body.appendChild(downloadLink);
  downloadLink.click();
}

function destroyClickedElement(event) {
  document.body.removeChild(event.target);
}
//Regresa del formulario al listado
function regresar() {
  $("#btn_regresar").css('display', 'none');
  $("#formulario").css('display', 'none');
  $("#listado").css('display', 'block');
  $("#btn_nuevo").css('display', 'block');
}

function convertirFechaHora(fecha) {
  var fechaArray = fecha.split(' ')
  var fecha = fechaArray[0].split('-')
  var fechaConvertida = fecha[2] + '/' + fecha[1] + '/' + fecha[0]
  var hora = fechaArray[1].split(':')
  var horaConvertida = hora[0] + ':' + hora[1]
  return fechaConvertida + ' ' + horaConvertida
}

function convertirDate(fecha) {
  var aux = fecha.split('-');
  var f = aux[2] + '/' + aux[1] + '/' + aux[0];
  return f;
}

function convertirDateTime(fecha) {
  var f = fecha.split(' ');
  var aux = f[0].split('-');
  var date = aux[2] + '/' + aux[1] + '/' + aux[0];
  return date;
}

function getMunicipio(id_estado, id_municipio) {
  $.ajax({
    url: '<?php echo base_url('Funciones/getMunicipios'); ?>',
    method: 'POST',
    data: {
      'id_estado': id_estado
    },
    dataType: "text",
    success: function(res) {
      $('#municipio').prop('disabled', false);
      $('#municipio').html(res);
      $("#municipio").find('option').attr("selected", false);
      $('#municipio option[value="' + id_municipio + '"]').attr('selected', 'selected');
    }
  });
}

function regresarListado() {
  location.reload();
}



function guardarComentarioAddress() {
  console.log('La función guardarComentarioAddress se está llamando correctamente.');
  id_candidato = $("#idCandidato").val();
  comentario = $("#address_comentarios").val();
  $.ajax({
    url: '<?php echo base_url('Domicilio/guardarComentarioVerificarDomicilios'); ?>',
    method: "POST",
    data: {
      'id_candidato': id_candidato,
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
        $("#AddressModal #msj_error_address_comentario").css('display', 'none');
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Comentario actualizado correctamente',
          showConfirmButton: false,
          timer: 2500
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema al enviar el formulario',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar'
        })
        console.error("Error en la respuesta del servidor:", data);

      }
    }
  });

}

function getHistorialDomicilios(id_candidato, id_seccion) {
  let valores = '';
  let scripts = '';
  let opciones = '';
  let url_estados = '<?php echo base_url('Funciones/getEstados'); ?>';
  let estados_data = getDataCatalogo(url_estados, 'id', 0, 'espanol');
  let url_paises = '<?php echo base_url('Funciones/getPaises'); ?>';
  let paises_data = getDataCatalogo(url_paises, 'nombre', 0, 'ingles');

  $.ajax({
    url: '<?php echo base_url('Domicilio/getById'); ?>',
    method: 'POST',
    data: {
      'id': id_candidato
    },
    async: false,
    success: function(res) {
      if (res != 0) {
        valores = JSON.parse(res);
      }
    }
  });

  $.ajax({
    url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
    method: 'POST',
    data: {
      'id_seccion': id_seccion,
      'tipo_orden': 'orden_front'
    },
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);

      if (res != 0) {
        var dato = JSON.parse(res);
        let totalDomicilios = valores.length;

        for (let number = 0; number < valores.length; number++) {
          $('#rowForm').append(
            '<div class="alert alert-info btn-block"><h5 class="text-center">Address #' +
            totalDomicilios + '</h5></div><br>');
          for (let tag of dato) {
            let referencia = tag['referencia'];
            if (referencia == 'id_estado')
              opciones = estados_data;
            if (referencia == 'pais')
              opciones = paises_data;

            if (tag['tipo_etiqueta'] == 'select') {
              $('#rowForm').append(tag['grid_col_inicio'] + tag['label_ingles'] + tag[
                'etiqueta_inicio'] + opciones + tag['etiqueta_cierre'] + tag[
                'grid_col_cierre']);
            }
            if (tag['tipo_etiqueta'] == 'input') {
              $('#rowForm').append(tag['titulo_seccion_modal'] + tag['grid_col_inicio'] + tag[
                  'label_ingles'] + tag['etiqueta_inicio'] + tag['etiqueta_cierre'] +
                tag['grid_col_cierre']);
            }
            if (tag['tipo_etiqueta'] == 'textarea') {
              $('#rowForm').append(tag['grid_col_inicio'] + tag['label_ingles'] + tag[
                'etiqueta_inicio'] + tag['etiqueta_cierre'] + tag[
                'grid_col_cierre']);
            }
          }

          //* Boton Guardar
          $('#rowForm').append(
            '<div class="col-12 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-primary btn-block" onclick="guardarDomicilio(' +
            valores[number]['id'] + ',' + number + ',' + valores[number]['id_candidato'] +
            ',' + id_seccion + ')">Update Address #' + totalDomicilios + '</a></div>');

          totalDomicilios--;
        }

        if (valores != 0) {
          var index = 0;
          for (let valor of valores) {
            for (let tag of dato) {
              $('[name="' + tag['atr_id'] + '[]"]').eq(index).addClass('dom' + index);
              if (tag['referencia'] == 'id_estado') {
                $('[name="id_estado[]"]').eq(index).removeAttr('id');
                $('[name="id_estado[]"]').eq(index).attr('id', 'id_estado' + index);
                $('#rowForm').append('<script>$("#id_estado' + index +
                  '").change(function(){getMunicipios($("#id_estado' + index +
                  '").val(), "#id_municipio' + index + '", "")})<\/script>');
              }
              if (tag['referencia'] == 'id_municipio') {
                $('[name="id_municipio[]"]').eq(index).removeAttr('id')
                $('[name="id_municipio[]"]').eq(index).attr('id', 'id_municipio' + index);
                if (valor['id_municipio'] != null && valor['id_municipio'] != 0) {
                  $('#rowForm').append('<script>getMunicipios(' + valor['id_estado'] +
                    ', "#id_municipio' + index + '", ' + valor['id_municipio'] +
                    ');<\/script>');
                } else {
                  $('"#id_municipio' + index + '"').eq(index).empty();
                  $('"#id_municipio' + index + '"').eq(index).append(
                    '<option value="">Select</option>')
                }
              } else {
                $('[name="' + tag['atr_id'] + '[]"]').eq(index).val(valor[tag[
                  'referencia']]);
              }
            }
            index++;
          }
        } else {
          $('#rowForm').html(
            '<div class="col-12"><h4 class="text-center">No address registered</h4></div><br><div class="col-12 mt-3 text-center"></div>'
          );
        }
        $('#rowForm').append('<div id="comentarioError" class="col-12 text-danger"></div>');

        //* Campo Guardar Texto Adicional
        $('#rowForm').append(
          '<div class="col-12 mt-3 mb-3"><textarea id="address_comentarios" class="form-control" rows="3" placeholder="Ingrese un comentario..."></textarea></div>'
        );

        //* Botón Guardar Comentario
        $('#rowForm').append(
          '<div class="col-12 mt-3 mb-3"><button type="button" class="btn btn-primary btn-block" onclick="guardarComentarioAddress()">Guardar Comentario</button></div>'
        );

        // Llamada AJAX para obtener y mostrar el comentario almacenado
        $.ajax({
          url: '<?php echo base_url('Domicilio/getComentarioVerificarDomicilios'); ?>',
          method: 'POST',
          data: {
            'id_candidato': id_candidato
          },
          success: function(res) {
            console.log('Respuesta del servidor (getComentario):', res);
            var comentarioData = JSON.parse(res);
            if (comentarioData.codigo === 1) {
              $("#address_comentarios").val(comentarioData.comentario);
              $("#comentarioError").text(""); // Limpiar mensajes de error
            } else {
              $("#address_comentarios").val(
                ""
              ); // Limpiar el campo de comentarios en caso de que no haya comentario
              $("#comentarioError").text(
                ""); // Mostrar mensaje de error
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX (getComentario):", textStatus,
              errorThrown);
            // Mostrar mensaje de error
          }
        });


        $('#titleForm').html('Addresses');
        $('#btnSubmitForm').attr("onclick", "nuevoDomicilio(" + id_candidato + "," + id_seccion +
          ")");
        $('#btnSubmitForm').text('Nuevo domicilio');
        $('#formModal').modal('show');
      } else {
        $('#rowForm').html(
          '<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>'
        );
      }
    }
  });
}
</script>

<script src="<?php echo base_url(); ?>js/analista/functions.js"></script>