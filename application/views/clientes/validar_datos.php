<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Validar Datos</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <?php echo link_tag("css/paneles/clientes.css"); ?>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

</head>

<body>
  <!-- Modal -->
  <div class="modal fade" id="clientModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="titulo_nuevo_modal">Bienvenido a TalentSafe Control</h5>
          <button type="button" class="close custom_modal_close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div>

          </div>
          <div class="alert alert-info">¡Bienvenido , por favor revisa y completa todos los datos solicitados en este
            formulario. Este paso se realiza una única vez.
          </div>

          <h5 class="text-center" id="titulo_paso"></h5>
          <form id="formPaso1" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-12">

                <label for="nombre">Nombre del cliente *</label>
                <input type="text" class="form-control" data-field="Nombre del Cliente" 
                  id="nombre" name="nombre" disabled>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="clave">Clave *</label>
                <input type="text" class="form-control" data-field="Clave" id="clave" name="clave"
                disabled>
                <br>
              </div>
              <div class="col-md-6">
                <label for="correo">Correo</label>
                <input type="text" class="form-control" data-field="Correo" id="correo" name="correo"
                disabled>
                <br>
              </div>
            </div>
            <div class="row">
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="razon_social">Razón Social</label>
                <input type="text" class="form-control" id="razon_social" name="razon_social"
                  placeholder="Ingrese la razón social">
                <br>
              </div>
              <div class="col-md-6">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese el teléfono">
                <input type="hidden" class="form-control" id="idCliente" name="idCliente" readonly>
                <input type="hidden" id="idDomicilios" name="idDomicilios" class="form-control" readonly>
                <input type="hidden" id="idFacturacion" name="idFacturacion" class="form-control" readonly>
                <input type="hidden" id="idGenerales" name="idGenerales" class="form-control" readonly>
                <br>
              </div>
            </div>
            <hr style="border-top: 1px solid #ccc;">
            <div class="row">


            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="nombre_contacto">Nombre Contacto</label>
                <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto"
                  placeholder="Nombre ">
                <br>
              </div>
              <div class="col-md-6">
                <label for="apellido_contacto">Apellido Contacto</label>
                <input type="text" class="form-control" id="apellido_contacto" name="apellido_contacto"
                  placeholder="Apellido paterno">
                <br>
              </div>
            </div>
            <hr style="border-top: 1px solid #ccc;">
            <div class="row">
              <div class="col-md-6">
                <label for="rfc">RFC</label>
                <input type="text" class="form-control" id="rfc" name="rfc" placeholder="Ingrese el RFC">
                <br>
              </div>
              <div class="col-md-6">
                <label for="regimen">Régimen</label>
                <input type="text" class="form-control" id="regimen" name="regimen" placeholder="Ingrese el régimen">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="forma_pago">Forma de Pago</label>
                <select class="custom-select" id="forma_pago" name="forma_pago">
                  <option value="" selected>Selecciona</option>
                  <option value="Pago en una sola exhibición">Pago en una sola exhibición</option>
                  <option value="Pago en parcialidades o diferidos">Pago en parcialidades o diferidos</option>
                </select>
                <br>
              </div>
              <div class="col-md-6">
                <label for="metodo_pago">Método de Pago</label>
                <select class="custom-select" id="metodo_pago" name="metodo_pago">
                  <option value="" selected>Selecciona</option>
                  <option value="Efectivo">Efectivo</option>
                  <option value="Cheque de nómina">Cheque de nómina</option>
                  <option value="Transferencia electrónica">Transferencia electrónica</option>
                  <option value="Tarjeta de crédito">Tarjeta de crédito</option>
                  <option value="Tarjeta de débito">Tarjeta de débito</option>
                  <option value="Por definir">Por definir</option>
                </select>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <br>
                <label for="uso_cfdi">Uso de CFDI</label>
                <input type="text" class="form-control" id="uso_cfdi" name="uso_cfdi"
                  placeholder="Ingrese el uso de CFDI" value="Gastos Generales">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label for="archivo">Subir Constancia de situacion fiscal</label>
                <input type="file" class="form-control" id="archivo" name="archivo">
                <br>
              </div>
            </div>

            <!-- Paso 2: Domicilio -->
            <div class="row">

            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="item-details-countryValue">País</label>
                <input class="form-control" id="item-details-countryValue" name="pais_name">
                <!-- Opciones de país cargadas dinámicamente -->

                <br>
              </div>
              <div class="col-md-6">
                <label for="item-details-stateValue">Estado</label>
                <input class="form-control" id="item-details-stateValue" name="state_name">


                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="item-details-cityValue">Ciudad</label>
                <input class="form-control" id="item-details-cityValue" name="ciudad_name">

                <br>
              </div>
              <div class="col-md-6">
                <label for="colonia">Colonia</label>
                <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Ingrese la colonia">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label for="calle">Calle</label>
                <input type="text" class="form-control" id="calle" name="calle" placeholder="Ingrese la calle">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 mx-auto">
                <label for="numero_exterior">Número Exterior</label>
                <input type="number" class="form-control" id="numero_exterior" name="numero_exterior"
                  placeholder="Ingrese el número exterior">
                <br>
              </div>
              <div class="col-md-3 mx-auto">
                <label for="numero_interior">Número Interior</label>
                <input type="text" class="form-control" id="numero_interior" name="numero_interior"
                  placeholder="Ingrese el número interior">
                <br>
              </div>
              <div class="col-md-3 mx-auto">
                <label for="cp">Codigo Postal</label>
                <input type="number" class="form-control" id="cp" name="numero_cp"
                  placeholder="Ingrese el codigo postal">
                <br>
              </div>
            </div>
            <br>
          </form>
          <!-- Paso 3 -->

        </div>
        <div class="modal-footer custom_modal_footer">

          <button type="button" class="btn btn-success btn-icon-split" id="btnContinuar">
            <span class="text">Guardar</span>
            <span class="icon text-white-50">
              <i class="fas fa-arrow-right"></i>
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
  <script>
  $(document).ready(function() {
    // Variable de ID del cliente. Asegúrate de que este ID esté disponible
    var idCliente = <?php echo json_encode($this->session->userdata('idcliente')); ?>;

    // Solicitud AJAX para obtener los datos del cliente
    $.ajax({
      url: '<?php echo base_url('Dashboard/datosCliente'); ?>',
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        // Verifica si la respuesta contiene un array y toma el primer elemento
        if (Array.isArray(response) && response.length > 0) {
          console.log("🚀 ~ $ ~ response:", response)

          var cliente = response[0]; // Accede al primer objeto en el array

          // Cargar los datos en el formulario
          $('#nombre').val(cliente.nombre || '');
          $('#clave').val(cliente.clave || '');
          $('#correo').val(cliente.correo_contacto || '');
          $('#razon_social').val(cliente.razon_social || '');
          $('#nombre_contacto').val(cliente.nombre_contacto || '');
          $('#apellido_contacto').val(cliente.apellido_contacto || '');
          $('#telefono').val(cliente.telefono_contacto || '');
          $('#idCliente').val(cliente.idCliente || '');
          $('#idDomicilios').val(cliente.dDom || '');
          $('#idFacturacion').val(cliente.dFac || '');
          $('#idGenerales').val(cliente.dGen || '');
          $('#rfc').val(cliente.rfc || '');
          $('#regimen').val(cliente.regimen || '');
          $('#forma_pago').val(cliente.forma_pago || '');
          $('#metodo_pago').val(cliente.metodo_pago || '');
          $('#uso_cfdi').val(cliente.uso_cfdi || '');
          $('#item-details-countryValue').val(cliente.pais || '');
          $('#item-details-stateValue').val(cliente.estado || '');
          $('#item-details-cityValue').val(cliente.ciudad || '');
          $('#colonia').val(cliente.colonia || '');
          $('#calle').val(cliente.calle || '');
          $('#numero_exterior').val(cliente.exterior || '');
          $('#numero_interior').val(cliente.numero_interior || '');
          $('#cp').val(cliente.cp || '');

          // Mostrar el modal
          $('#clientModal').modal('show');
        } else {
          // Manejar el caso cuando no hay datos
          alert('No se encontraron datos para el cliente.');
        }
      },
      error: function() {
        // Manejar errores
        alert('Hubo un error al cargar los datos del cliente.');
      }
    });

    $('#btnContinuar').click(function() {
  
      // Verifica si se ha seleccionado un archivo
      if ($('#archivo').get(0).files.length === 0) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Por favor selecciona un archivo antes de continuar.',
          confirmButtonText: 'OK'
        });
        return; // Detiene la ejecución del código
      }
      // Crear un objeto FormData con el contenido del formulario
      var formData = new FormData($('#formPaso1')[0]);

      $.ajax({
        url: '<?php echo base_url('Cat_cliente/guardarDatos'); ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
          // Ya no necesitas parsear la respuesta
          // response ya es un objeto JavaScript
          console.log("🚀 ~ $ ~ response:", response)

          if (response.codigo == 1) {
            Swal.fire({
              icon: 'success',
              title: 'Éxito',
              text: response.msg,
              confirmButtonText: 'OK'
            }).then((result) => {
              if (result.isConfirmed) {
                // Cerrar el modal si es necesario
                $('#clientModal').modal('hide');
                location.reload(); 
              }
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Errorqqq',
              text: response.msg,
              confirmButtonText: 'OK'
            });
          }
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'Errorewrt',
            text: 'Hubo un error al guardar los datos.',
            confirmButtonText: 'OK'
          });
        }
      });
    });
  });
  </script>

</body>

</html>