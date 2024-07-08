<!-- Begin Page Content -->
<div class="container-fluid">
  <?php
$cliente = 1;//$procesosActuales[0];
?>
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Cliente: <small><?php echo "cxxx"/*$cliente->nombre; */?></small></h1><br>
    <?php
if ($this->uri->segment(3) != 100 && $this->uri->segment(3) != 205 && $this->uri->segment(3) != 233 && $this->uri->segment(3) != 250) {
    ?>
    <a href="#" class="btn btn-primary btn-icon-split" id="btn_nuevo" onclick="modalRegistrarCandidato()">
      <span class="icon text-white-50">
        <i class="fas fa-user-plus"></i>
      </span>
      <span class="text">Registrar candidato</span>
    </a>
    <?php
} else {?>
    <a href="#" class="btn btn-primary btn-icon-split" id="btn_nuevo" onclick="nuevoRegistroAlterno()">
      <span class="icon text-white-50">
        <i class="fas fa-user-plus"></i>
      </span>
      <span class="text">Registrar candidato</span>
    </a>
    <?php }?>
    <!-- a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#subirVisitaModal">
            <span class="icon text-white-50">
                <i class="fas fa-upload"></i>
            </span>
            <span class="text">Verificar datos de visita</span>
        </a -->
    <?php
if ($this->uri->segment(3) == 33) {?>
    <!--a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#registroCandidatoBecaModal">
            <span class="icon text-white-50">
                <i class="fas fa-user-plus"></i>
            </span>
            <span class="text">Registrar candidato para solicitud de Beca</span>
        </a -->
    <?php }
//if($this->session->userdata('idrol') != 2){ ?>
    <!--a href="#" class="btn btn-primary btn-icon-split" id="btn_asignacion" onclick="asignarCandidatoAnalista()">
            <span class="icon text-white-50">
                <i class="fas fa-people-arrows"></i>
            </span>
            <span class="text">Reasignacion de candidato</span >
        </a -->
    <?php
//} ?>
    <a href="#" class="btn btn-primary btn-icon-split hidden" id="btn_regresar" onclick="regresarListado()"
      style="display: none;">
      <span class="icon text-white-50">
        <i class="fas fa-arrow-left"></i>
      </span>
      <span class="text">Regresar al listado</span>
    </a>
  </div>

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
              <option value="1">Candidatos en proceso</option>
              <option value="2">Todos los candidatos finalizados</option>
              <option value="3">Últimos candidatos finalizados</option>
              <option value="4">Todos los candidatos</option>

            </select>
          </div>
        </div>
        <div class="table-responsive">
          <table id="tabla" class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">


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
          $('#puesto').selectpicker({
            liveSearch: true
          })
        } else {
          $('#puesto').append('<option value="">No hay puestos registrados</option>');
        }
      }
    });
  }, 200);
  setTimeout(function() {
    $('#puesto').selectpicker('val', id_position)
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
  datos.append('puesto', $('#puesto').selectpicker('val'));
  datos.append('pais', $("#pais").val());
  datos.append('region', $("#region").val());

  datos.append('previo', $("#previos").val());
  datos.append('proyecto', $("#proyecto_registro").val());
  datos.append('id_cliente', id_cliente);
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
  changeDatatable(url);
  $("#filtroListado").change(function() {
    var opcion = $(this).val();

    let urlFiltrada = '<?php echo API_URL ?>candidato-sync/' + id;
    if (opcion == 1) {
      $('#tabla').DataTable().destroy();
      urlFiltrada = '<?php echo API_URL ?>candidato-sync/' + id;

      changeDatatable(urlFiltrada);
    }
    if (opcion == 2) {
      $('#tabla').DataTable().destroy();
      urlFiltrada = '<?php echo API_URL ?>candidato-sync/' + id;
      changeDatatable(urlFiltrada);
    }
    if (opcion == 3) {
      $('#tabla').DataTable().destroy();
      urlFiltrada = '<?php echo API_URL ?>candidato-sync/' + id;
      changeDatatable(urlFiltrada);
    }
    if (opcion == 4) {
      $('#tabla').DataTable().destroy();
      urlFiltrada = '<?php echo API_URL ?>candidato-sync/' + id;
      changeDatatable(urlFiltrada);
    }
    if (opcion == 5) {
      $('#tabla').DataTable().destroy();
      urlFiltrada = '<?php echo API_URL ?>candidato-sync/' + id;
      changeDatatable(urlFiltrada);
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