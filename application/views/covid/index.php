<!-- Begin Page Content -->
<div class="container-fluid">

<div id="mensaje" class="alert alert-success in mensaje" style='display:none;'>
    <p id="texto_msj"></p>
  </div>
  <div id="error_mensaje" class="alert alert-danger in mensaje" style='display:none;'>
    <p id="texto_msj"></p>
  </div>
  <div class="modal fade" id="nuevoModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Registro de Prueba de COVID-19</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formNuevo">
            <div class="row">
              <div class="col-md-12">
                <label>Nombre del paciente *</label>
                <input type="text" class="form-control nuevo_obligado" name="nombre" id="nombre" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>Tipo prueba *</label>
                <select name="tipo" id="tipo" class="form-control nuevo_obligado">
                  <option value="">Selecciona</option>
                  <option value="Nasofaringea">Nasofaríngea</option>
                  <option value="Sanguinea">Sanguínea</option>
                  <option value="PCR">PCR</option>
                </select>
                <br>
              </div>
              <div class="col-md-4">
                <label>Fecha de prueba *</label>
                <input type="text" class="form-control nuevo_obligado" name="fecha_prueba" id="fecha_prueba">
                <br>
              </div>
              <div class="col-md-4">
                <label>Folio </label>
                <input type="text" class="form-control" name="folio" id="folio">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>Fecha de nacimiento *</label>
                <input type="text" class="form-control nuevo_obligado" name="fecha_nacimiento" id="fecha_nacimiento">
                <br>
              </div>
              <div class="col-md-4">
                <label>Edad *</label>
                <input type="text" class="form-control" name="edad" id="edad" readonly>
                <br>
              </div>
              <div class="col-md-4">
                <label>Género *</label>
                <select name="genero" id="genero" class="form-control nuevo_obligado">
                  <option value="">Selecciona</option>
                  <option value="F">Femenino</option>
                  <option value="M">Masculino</option>
                </select>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>Teléfono celular</label>
                <input type="text" class="form-control" name="celular" id="celular">
                <br>
              </div>
              <div class="col-md-4">
                <label>Pasaporte *</label>
                <input type="text" class="form-control nuevo_obligado" name="pasaporte" id="pasaporte">
                <br>
              </div>
              <div class="col-md-4">
                <label>Médico *</label>
                <input type="text" class="form-control nuevo_obligado " name="medico" id="medico" value="Valeria Villegas Espinosa">
                <br>
              </div>
            </div>
            <div id="msj_error" class="alert alert-danger hidden">
              <p id="msj_texto" class="msj_error text-white"></p>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success" id="btnGuardar" onclick="registrar()">Registrar</button>
        </div>
      </div>
    </div>
  </div>
	<div class="modal fade" id="verModal" role="dialog" data-backdrop="static" data-keyboard="false">
	  	<div class="modal-dialog modal-lg modal-dialog-centered">
	    	<div class="modal-content">
	      		<div class="modal-header">
	      			<h4 class="modal-title" id="titulo_accion"></h4>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
	      		</div>
	      		<div class="modal-body">
	      			<h4 id="nombre_candidato"></h4><br>
	        		<p class="" id="detalles"></p><br>
	    		</div>
		    	<div class="modal-footer">
		      		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		    	</div>
	  		</div>
		</div>
	</div>
	<div class="modal fade" id="resultadoModal" role="dialog" data-backdrop="static" data-keyboard="false">
	  	<div class="modal-dialog modal-lg modal-dialog-centered">
	    	<div class="modal-content">
	      		<div class="modal-header">
	      			<h4 class="modal-title">Resultados de la Prueba</h4>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
	      		</div>
	      		<div class="modal-body">
	      			<div class="row">
	      				<div class="col-md-12 text-center">
	      					<b><span id="titulo_candidato"></span></b><br>
	      				</div>
	      			</div>
	      			<div class="row">
	      				<div class="col-md-12 text-center">
	      					<b><span id="titulo_prueba"></span></b><br><br>
	      				</div>
	      			</div>
	      			<div class="row" id="tipo1">
	      				<div class="col-md-4 col-md-offset-4">
	      					<label>Resultado de la prueba *</label>
                  <select name="resultado_tipo1" id="resultado_tipo1" class="form-control res_obligado">
                    <option value="">Selecciona</option>
                    <option value="NEGATIVO">NEGATIVO</option>
                    <option value="POSITIVO">POSITIVO</option>
                  </select>
                  <br>
	      				</div>
	      			</div>
              <div class="row" id="tipo2">
	      				<div class="col-md-4 col-md-offset-4">
	      					<label>Resultado de la prueba *</label>
                  <select name="resultado_tipo2" id="resultado_tipo2" class="form-control res_obligado">
                    <option value="">Selecciona</option>
                    <option value="NEGATIVO - NEGATIVO">NEGATIVO - NEGATIVO</option>
                    <option value="POSITIVO - NEGATIVO">POSITIVO - NEGATIVO</option>
                    <option value="POSITIVO - POSITIVO">POSITIVO - POSITIVO</option>
                    <option value="NEGATIVO - POSITIVO">NEGATIVO - POSITIVO</option>
                  </select>
                  <br>
	      				</div>
	      			</div>
              <div class="row" id="tipo3">
                <div class="col-md-4 col-md-offset-4">
                  <label>Resultado de la prueba *</label>
                  <select name="resultado_tipo3" id="resultado_tipo3" class="form-control res_obligado">
                    <option value="">Selecciona</option>
                    <option value="NO DETECTADO">NO DETECTADO</option>
                    <option value="DETECTADO">DETECTADO</option>
                  </select>
                  <br>
                </div>
              </div>
	      			<div id="msj_error" class="alert alert-danger hidden">
		      			<p id="msj_texto" class="msj_error text-white"></p>
		      		</div>
	    		</div>
		    	<div class="modal-footer">
		      		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		      		<button type="button" class="btn btn-success" onclick="registrarResultado()">Guardar</button>
		    	</div>
	  		</div>
		</div>
	</div>
	<div class="modal fade" id="quitarModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="titulo_accion"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p class="" id="texto_confirmacion"></p><br>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-success" onclick="ejecutarAccion()">Aceptar</button>
        </div>
      </div>
		</div>
	</div>
	<div class="modal fade" id="finalizadosModal" role="dialog" data-backdrop="static" data-keyboard="false">
	  	<div class="modal-dialog modal-lg modal-dialog-centered">
	    	<div class="modal-content">
	      		<div class="modal-header">
	      			<h4 class="modal-title">Exámenes antidoping finalizados</h4>
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
	      		</div>
	      		<div class="modal-body">
	      			<div class="row">
						<div class="col-md-12">
							<label>Busca al candidato *</label>
		        			<select name="candidato_finalizado" id="candidato_finalizado" class="form-control solo_lectura selectpicker" data-live-search="true">
					            <option value="">Selecciona</option>
					           	<?php 
					           	if($finalizados){
				           			foreach ($finalizados as $f) {
					           			$sub = ($f->subcliente != '' && $f->subcliente != null)? " - ".$f->subcliente:"";
					           			$proyecto = ($f->proyecto != '' && $f->proyecto != null)? " - ".$f->proyecto:""; ?>
				                		<option value="<?php echo $f->id; ?>"><?php echo $f->id.' - '.$f->candidato.' - '.$f->cliente.$sub.$proyecto; ?></option>
				            	<?php } 
				        		}?>
				          	</select>
				          	<br><br>
						</div>
					</div>
					<div class="row"> 
		        		<div class="col-md-12" id="detalle_finalizado">
		        		</div>
		        	</div>
	    		</div>
		    	<div class="modal-footer">
		      		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		    	</div>
	  		</div>
		</div>
	</div>
  <div class="modal fade" id="revisionModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Revisa los datos de:  <span class="paciente"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Antes de terminar la prueba, realiza una ultima revisión a los siguientes datos y asegúrate que la información registrada sea la correcta:</p><br>
          <ul id="lista_datos"></ul><br>
          <p>En caso de que se presente un error en la plataforma, favor de avisar a TI en cuanto antes para dar solución al problema </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar y regresar a revisar</button>
          <button type="button" class="btn btn-danger" onclick="aceptarRevision()">Acepto que he revisado la información ingresada</button>
        </div>
      </div>
    </div>
  </div>

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Pruebas COVID</h1>
		<a href="#" class="btn btn-primary btn-icon-split" onclick="nuevoRegistro()">
			<span class="icon text-white-50">
				<i class="fas fa-plus-circle"></i>
			</span>
			<span class="text">Registrar nueva prueba</span>
		</a>
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"></h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
        <input type="hidden" id="idPrueba">
				<table id="tabla" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				</table>
			</div>
		</div>
	</div>

</div>
<!-- /.content-wrapper -->
<script>
	var url = '<?php echo base_url('Covid/getPruebas'); ?>';
	$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('#fecha_nacimiento, #fecha_prueba').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    f = new Date();
    var hoy = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear()
    $('#fecha_prueba').val(hoy);
    $("#fecha_nacimiento").change(function(){
		  var aux = $(this).val().split('/');
		  var f = aux[1]+'/'+aux[0]+'/'+aux[2];
		  var fecha = f;
		  var today = new Date();
	    var birthDate = new Date(fecha);
	    var age = today.getFullYear() - birthDate.getFullYear();
	    var m = today.getMonth() - birthDate.getMonth();
	    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
	        age = age - 1;
	    }
	    $("#edad").val(age);
	  });
    $('#tabla').DataTable({
      "pageLength": 25,
      "pagingType": "simple",
      "stateSave": true,
      "order": [[ 0, "desc" ]],
      "ajax": url,
      "columns":[ 
        { title: 'ID', data:'id',"bVisible": false},
        { title: 'Paciente', data: 'paciente', bSortable: false, width: '18%'},
        { title: 'Tipo', data: 'tipo_prueba', bSortable: false, width: '8%'},
        { title: 'Orden', data: 'orden', bSortable: false, width: '8%' },
        { title: 'Folio', data: 'folio', bSortable: false, width: '5%',
          mRender: function(data, type, full){
            var folio = (data == null)? 'N/A':data;
            return folio;
          }
        },
        { title: 'Fecha de toma', data: 'creacion', bSortable: false, width: '9%',
          mRender: function(data, type, full){
            var f = data.split(' ');
            var h = f[1];
            var aux = h.split(':');
            var hora = aux[0]+':'+aux[1];
            var aux = f[0].split('-');
            var fecha = aux[2]+"/"+aux[1]+"/"+aux[0];
            var tiempo = fecha+' '+hora;
            return tiempo;
          }
        },
        { title: 'Médico', data: 'medico', bSortable: false, width: '10%',
          mRender: function(data, type, full){
            return data;
          }
        },
        { title: 'Resultado', data: 'resultado', bSortable: false,  width: '12%',
          mRender: function(data, type, full){
            if(data != null){
              if(full.tipo_prueba == "Nasofaringea"){
                if(data == "POSITIVO"){
                  return res = '<div class="formato_dias dias_rojo">'+data+'</div>';
                }
                if(data == "NEGATIVO"){
                  return res = '<div class="formato_dias dias_verde">'+data+'</div>';
                }
              }
              if(full.tipo_prueba == "Sanguinea"){
                if(data == "NEGATIVO - NEGATIVO"){
                  return '<div class="formato_dias dias_verde">'+data+'</div>';
                }
                if(data == "POSITIVO - NEGATIVO"){
                  return '<div class="formato_dias dias_rojo">'+data+'</div>';
                }
                if(data == "POSITIVO - POSITIVO"){
                  return '<div class="formato_dias dias_rojo">'+data+'</div>';
                }
                if(data == "NEGATIVO - POSITIVO"){
                  return '<div class="formato_dias dias_verde">'+data+'</div>';
                }
              }
              if(full.tipo_prueba == "PCR"){
                if(data == "DETECTADO"){
                  return res = '<div class="formato_dias dias_rojo">'+data+'</div>';
                }
                if(data == "NO DETECTADO"){
                  return res = '<div class="formato_dias dias_verde">'+data+'</div>';
                }
              }
            }
            else{
              return 'Pendiente';
            }
          }
        },
        { title: 'Acciones', data: 'id', bSortable: false, width: "18%",
          mRender: function(data, type, full) {
            if(full.status == 1){
              if(full.resultado != null){
                if(full.tipo_prueba == "Nasofaringea"){
                  return '<div style="display: inline-block;margin-left:10px;"><form id="formPrueba'+data+'" action="<?php echo base_url('Covid/createNasofaringeaPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultados español" id="espanolPDF" class="icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idPruebaCovid" id="idPruebaCovid'+data+'" value="'+data+'"></form></div> <div style="display: inline-block;margin-left:10px;"><form id="formPrueba3'+data+'" action="<?php echo base_url('Covid/createNasofaringeaDigitalPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultados en digital español" id="espanolDigitalPDF" class="icono_datatable"><i class="fas fa-file-invoice"></i></a><input type="hidden" name="idPruebaCovid" id="idPruebaCovid'+data+'" value="'+data+'"></form></div> <div style="display: inline-block;margin-left:10px;"><form id="formPrueba2'+data+'" action="<?php echo base_url('Covid/createNasofaringeaInglesPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar  resultados ingles" id="inglesPDF" class="icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idPruebaCovid" id="idPruebaCovid'+data+'" value="'+data+'"></form></div> <div style="display: inline-block;margin-left:10px;"><form id="formDigEN'+data+'" action="<?php echo base_url('Covid/createNasofaringeaDigitalENPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultados en digital ingles" id="inglesDigitalPDF" class="icono_datatable"><i class="fas fa-file-invoice"></i></a><input type="hidden" name="idENDigital" id="idENDigital'+data+'" value="'+data+'"></form></div>  <a href="javascript:void(0)" data-toggle="tooltip" title="Registrar resultado" id="resultados" class="icono_datatable"><i class="fas fa-capsules"></i></a> <a href="javascript:void(0)" data-toggle="tooltip" title="Editar registro" id="editar" class="icono_datatable"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Cancelar registro" id="eliminar" class="icono_datatable"><i class="fas fa-trash"></i></a>';
                }
                if(full.tipo_prueba == "Sanguinea"){
                  return '<div style="display: inline-block;margin-left:10px;"><form id="formPrueba'+data+'" action="<?php echo base_url('Covid/createSanguineaPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar PDF de resultados" id="cadenaPDF" class="icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idPruebaCovid" id="idPruebaCovid'+data+'" value="'+data+'"></form></div> <div style="display: inline-block;margin-left:10px;"><form id="formPrueba2'+data+'" action="<?php echo base_url('Covid/createSanguineaMembretadoPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado sanguineo para membretar" id="sanguineoMembretadoPDF" class="icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idPruebaCovid" id="idPruebaCovid'+data+'" value="'+data+'"></form></div> <a href="javascript:void(0)" data-toggle="tooltip" title="Registrar resultado" id="resultados" class="icono_datatable"><i class="fas fa-capsules"></i></a> <a href="javascript:void(0)" data-toggle="tooltip" title="Editar registro" id="editar" class="icono_datatable"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Cancelar registro" id="eliminar" class="icono_datatable"><i class="fas fa-trash"></i></a>';
                }
                if(full.tipo_prueba == "PCR"){
                  return '<div style="display: inline-block;margin-left:10px;"><form id="formPrueba'+data+'" action="<?php echo base_url('Covid/createPCRPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultados español" id="espanolPDF" class="icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idPruebaCovid" id="idPruebaCovid'+data+'" value="'+data+'"></form></div> <div style="display: inline-block;margin-left:10px;"><form id="formPrueba3'+data+'" action="<?php echo base_url('Covid/createPCRDigitalPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultados en digital español" id="espanolDigitalPDF" class="icono_datatable"><i class="fas fa-file-invoice"></i></a><input type="hidden" name="idPruebaCovid" id="idPruebaCovid'+data+'" value="'+data+'"></form></div> <div style="display: inline-block;margin-left:10px;"><form id="formPrueba2'+data+'" action="<?php echo base_url('Covid/createPCRInglesPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar  resultados ingles" id="inglesPDF" class="icono_datatable"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idPruebaCovid" id="idPruebaCovid'+data+'" value="'+data+'"></form></div> <div style="display: inline-block;margin-left:10px;"><form id="formDigEN'+data+'" action="<?php echo base_url('Covid/createPCRDigitalENPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultados en digital ingles" id="inglesDigitalPDF" class="icono_datatable"><i class="fas fa-file-invoice"></i></a><input type="hidden" name="idENDigital" id="idENDigital'+data+'" value="'+data+'"></form></div>  <a href="javascript:void(0)" data-toggle="tooltip" title="Registrar resultado" id="resultados" class="icono_datatable"><i class="fas fa-capsules"></i></a> <a href="javascript:void(0)" data-toggle="tooltip" title="Editar registro" id="editar" class="icono_datatable"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Cancelar registro" id="eliminar" class="icono_datatable"><i class="fas fa-trash"></i></a>';
                }
              }
              else{
                return ' <a href="javascript:void(0)" data-toggle="tooltip" title="Registrar resultado" id="resultados" class="icono_datatable"><i class="fas fa-capsules"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Editar registro" id="editar" class="icono_datatable"><i class="fas fa-edit"></i></a><a href="javascript:void(0)" data-toggle="tooltip" title="Cancelar registro" id="eliminar" class="icono_datatable"><i class="fas fa-trash"></i></a>';
              }
            }
            else{
              return 'CANCELADO';
            }
          }
        }	        	   
      ],
      fnDrawCallback: function (oSettings) {
        $('a[data-toggle="tooltip"]').tooltip({ trigger: "hover" });
      },
      rowCallback: function( row, data ) {
        $("a#editar", row).bind('click', () => {
          $("#idPrueba").val(data.id);
          //$('#proxima_orden').text(data.orden); 
          $("#nombre").val(data.nombre);
          $("#tipo").val(data.tipo_prueba);
          $("#tipo").prop('disabled', true);
          var orden = data.dia_orden.split('-');
          $('#fecha_prueba').val(orden[2]+'/'+orden[1]+'/'+orden[0]);
          $("#edad").val(data.edad);
          if(data.fecha_nacimiento != "0000-00-00" && data.fecha_nacimiento != null){
            var aux = data.fecha_nacimiento.split('-');
            var f_nacimiento = aux[2]+'/'+aux[1]+'/'+aux[0];
            $("#fecha_nacimiento").val(f_nacimiento).trigger('change');
          }
          else{
            $("#fecha_nacimiento").val("");
          }
          $("#folio").val(data.folio);
          $("#genero").val(data.genero);
          $("#celular").val(data.telefono);
          $("#pasaporte").val(data.pasaporte);
          $("#medico").val(data.medico);
          $("#btnGuardar").val('editar');
          $("#nuevoModal").modal('show');
        });
        $('a[id^=cadenaPDF]', row).bind('click', () => {
          var id = data.id;
          $('#formPrueba'+id).submit();
        });
        $('a[id^=espanolPDF]', row).bind('click', () => {
          var id = data.id;
          $('#formPrueba'+id).submit();
        });
        $('a[id^=espanolDigitalPDF]', row).bind('click', () => {
          var id = data.id;
          $('#formPrueba3'+id).submit();
        });
        $('a[id^=inglesDigitalPDF]', row).bind('click', () => {
          var id = data.id;
          $('#formDigEN'+id).submit();
        });
        $('a[id^=inglesPDF]', row).bind('click', () => {
          var id = data.id;
          $('#formPrueba2'+id).submit();
        });
        $('a[id^=sanguineoMembretadoPDF]', row).bind('click', () => {
          var id = data.id;
          $('#formPrueba2'+id).submit();
        });
        $('a#resultados', row).bind('click', () => {
          $("#idPrueba").val(data.id);
          $("#titulo_prueba").text(data.orden);
          $("#titulo_candidato").text(data.paciente);
          if(data.tipo_prueba == "Nasofaringea"){
            $("#tipo1").css('display', 'block');
            $("#tipo2").css('display', 'none');
            $("#tipo3").css('display', 'none');
          }
          if(data.tipo_prueba == "Sanguinea"){
            $("#tipo1").css('display', 'none');
            $("#tipo2").css('display', 'block');
            $("#tipo3").css('display', 'none');
          }
          if(data.tipo_prueba == "PCR"){
            $("#tipo1").css('display', 'none');
            $("#tipo2").css('display', 'none');
            $("#tipo3").css('display', 'block');
          }
          var aux = data.dia_orden.split('-');
          var fecha_orden = aux[2]+"/"+aux[1]+"/"+aux[0];

          var aux = data.fecha_nacimiento.split('-');
          var fecha_nacimiento = aux[2]+"/"+aux[1]+"/"+aux[0];

          var folio = (data.folio == null)? 'N/A':data.folio;
          
          //$("#resultadoModal").modal('show');
          $(".paciente").text(data.paciente);	
          $("#lista_datos").empty(); 
          $("#lista_datos").append('<li><b>Paciente:</b> '+data.paciente+'</li><li><b>Fecha de nacimiento:</b> '+data.fecha_nacimiento+'</li><li><b>No. Pasaporte:</b> '+data.pasaporte+'</li><li><b>Prueba:</b> '+data.tipo_prueba+'</li><li><b>Fecha de orden:</b> '+fecha_orden+'</li><li><b>Folio:</b> '+folio+'</li><li><b>Médico:</b> '+data.medico+'</li>');
          $("#revisionModal").modal('show');             
        });
        $("a#eliminar", row).bind('click', () => {
          $("#idPrueba").val(data.id);
          $("#titulo_accion").text("Eliminar doping");
          $("#texto_confirmacion").html("¿Está seguro de cancelar la prueba <b>"+data.orden+"</b>?");
          $("#btnGuardar").attr('value','delete');
          $("#quitarModal").modal("show");
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
            "sNext": "<i class='fa  fa-arrow-right'></i>",
            "sPrevious": "<i class='fa fa-arrow-left'></i>"
        }
      }
    });
    $("#nuevoModal").on("hidden.bs.modal", function(){
      $("#nuevoModal input, #nuevoModal select").val("");
      $("#nuevoModal input, #nuevoModal select").removeClass("requerido");
      $("#nuevoModal #msj_error").css('display','none');
      $("#tipo").prop('disabled', false);
      //$("#proxima_orden").text('');
    });
    $("#resultadoModal").on("hidden.bs.modal", function(){
      $("#resultadoModal select").val("");
      $("#resultadoModal select").removeClass("requerido");
      $("#resultadoModal #msj_error").css('display','none');
    });
  });

	function nuevoRegistro(){
    $("#medico").val("Valeria Villegas Espinosa");
    $("#btnGuardar").val('nuevo');
    f = new Date();
    var hoy = f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear()
    $('#fecha_prueba').val(hoy);
    $("#nuevoModal").modal('show');
    /*$.ajax({
      url: '',
      method: 'POST',
      beforeSend: function(){
        $('.loader').css("display","block");
      },
      success: function(res)
      {
        setTimeout(function(){
          $('.loader').fadeOut();
          $("#btnGuardar").val('nuevo');
          $("#nuevoModal").modal('show');
        },100);
      }
    });*/
  }
  function registrar(){
    var datos = $("#formNuevo").serialize();
    var opcion = $("#btnGuardar").val();
    var id_prueba = $("#idPrueba").val();
    var total = $('.nuevo_obligado').filter(function(){
      return !$(this).val();
    }).length;
    if(total > 0){
      $(".nuevo_obligado").each(function() {
        var element = $(this);
        if (element.val() == "") {
          element.addClass("requerido");
          $("#nuevoModal #msj_texto").text(" Hay campos obligatorios vacíos");
          $('#nuevoModal #mdj_error').css("display", "block");
          setTimeout(function(){
            $('#nuevoModal #mdj_error').fadeOut();
          },4000);
        }
        else{
            element.removeClass("requerido");
        }
      });
    }
    else{
      if(opcion == 'nuevo'){
        $.ajax({
          url: '<?php echo base_url('Covid/registrar'); ?>',
          method: "POST",  
          data: {'datos':datos},
          beforeSend: function() {
            $('.loader').css("display","block");
          },
          success: function(res){
            if(res == 1){
              setTimeout(function(){
                $("#nuevoModal").modal('hide');
                recargarTable();
                $("#texto_msj").text(" El registro se ha agregado correctamente");
                $("#mensaje").css('display','block');
                setTimeout(function(){
                    $('#mensaje').fadeOut();
                },4000);
                $('.loader').fadeOut();
              },100);
            }
            else{
              setTimeout(function(){
                $("#error_mensaje #texto_msj").text(" La fecha de prueba a registrar es incorrecta. No debe ser anterior ni pasar 48 horas al día actual");
                $("#error_mensaje").css('display','block');
                setTimeout(function(){
                    $('#error_mensaje').fadeOut();
                },4000);
                $('.loader').fadeOut();
              },100);
            }
          }
        });
      }
      if(opcion == 'editar'){
        $.ajax({
          url: '<?php echo base_url('Covid/editar'); ?>',
          method: "POST",  
          data: {'datos':datos,'id_prueba':id_prueba},
          beforeSend: function() {
            $('.loader').css("display","block");
          },
          success: function(res){
            if(res == 1){
              setTimeout(function(){
                $("#nuevoModal").modal('hide');
                recargarTable();
                $("#texto_msj").text(" El registro se ha editado correctamente");
                $("#mensaje").css('display','block');
                setTimeout(function(){
                    $('#mensaje').fadeOut();
                },4000);
                $('.loader').fadeOut();
              },100);
            }
            else{
              setTimeout(function(){
                $("#error_mensaje #texto_msj").text(" La fecha de prueba a editar es incorrecta. No debe ser anterior ni pasar 48 horas al día actual");
                $("#error_mensaje").css('display','block');
                setTimeout(function(){
                    $('#error_mensaje').fadeOut();
                },4000);
                $('.loader').fadeOut();
              },100);
            }
          }
        });
      }
    }
  }
  function registrarResultado(){
    var res1 = $("#resultado_tipo1").val();
    var res2 = $("#resultado_tipo2").val();
    var res3 = $("#resultado_tipo3").val();
    var res = '';
    if(res1 != ''){
      res = res1;
    }
    else{
      if(res2 != ''){
        res = res2;
      }
      else{
        res = res3;
      }
    }
    var id = $("#idPrueba").val();
    if(res1 == '' && res2 == '' && res3 == ''){
      $('.res_obligado').addClass("requerido");
      $("#resultadoModal #msj_texto").text(" Hay campos obligatorios vacíos");
      $('#resultadoModal #mdj_error').css("display", "block");
      setTimeout(function(){
        $('#resultadoModal #mdj_error').fadeOut();
      },4000);
    }
    else{
      $.ajax({
        url: '<?php echo base_url('Covid/registrarResultado'); ?>',
        method: "POST",  
        data: {'res':res,'id':id},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          if(res == 1){
            setTimeout(function(){
              $("#resultadoModal").modal('hide');
              recargarTable();
              $("#texto_msj").text(" El resultado se ha registrado correctamente");
              $("#mensaje").css('display','block');
              setTimeout(function(){
                  $('#mensaje').fadeOut();
              },4000);
              $('.loader').fadeOut();
            },100);
          }
        }
      });
    }
  }
  function recargarTable(){
    $("#tabla").DataTable().ajax.reload();
  }
  function ejecutarAccion(){
		var id_prueba = $("#idPrueba").val();
		$.ajax({
      url: '<?php echo base_url('Covid/eliminar'); ?>',
      type: 'post',
      data: {'id_prueba':id_prueba},
      beforeSend: function() {
        $('.loader').css("display","block");
      },
      success : function(res){ 
        if(res == 1){
          setTimeout(function(){
            $("#quitarModal").modal('hide');
            recargarTable();
            $("#texto_msj").text(" El registro se ha cancelado correctamente");
            $("#mensaje").css('display','block');
            setTimeout(function(){
                $('#mensaje').fadeOut();
            },4000);
            $('.loader').fadeOut();
          },100);
        }
      }
    });
	}
  function aceptarRevision(){
    $("#revisionModal").modal('hide');
    $("#resultadoModal").modal('show');
  }
</script>