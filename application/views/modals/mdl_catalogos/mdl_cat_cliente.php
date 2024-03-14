<div class="modal fade" id="newModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_nuevo_modal">Nuevo cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cerrarModal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" id="formContainer">
        <form id="formCatCliente">
          <div id="paso1">
            <div class="row">
              <div class="col-md-12">
                <h3 class="text-center">Generales</h3>
                <label for="nombre">Nombre del cliente *</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                  placeholder="Ingrese el nombre del cliente" onkeyup="this.value=this.value.toUpperCase()" required>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label for="clave">Clave *</label>
                <input type="text" class="form-control" id="clave" name="clave"
                  placeholder="Ingrese la clave del cliente" maxlength="3" onkeyup="this.value=this.value.toUpperCase()"
                  required>
                <br>
              </div>
            </div>
          </div>
          <!-- Paso 2: Domicilio -->
          <div id="paso2">
            <div class="row">
              <div class="col-md-12">
                <h3 class="text-center">Domicilio</h3>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="item-details-countryValue">País *</label>
                <select class="form-control" id="item-details-countryValue" name="pais_name">
                  <!-- Opciones de país cargadas dinámicamente -->
                </select>
                <br>
              </div>
              <div class="col-md-6">
                <label for="item-details-stateValue">Estado *</label>
                <select class="form-control" id="item-details-stateValue" name="state_name">
                  <option value="NULL">Primero Selecciona un Pais</option>
                  <!-- Opciones de estado cargadas dinámicamente -->
                </select>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="item-details-cityValue">Ciudad *</label>
                <select class="form-control" id="item-details-cityValue" name="ciudad_name">
                  <option value="NULL">Primero Selecciona un Estado</option>
                  <!-- Opciones de ciudad cargadas dinámicamente -->
                </select>
                <br>
              </div>
              <div class="col-md-6">
                <label for="colonia">Colonia *</label>
                <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Ingrese la colonia"
                  required>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label for="calle">Calle *</label>
                <input type="text" class="form-control" id="calle" name="calle" placeholder="Ingrese la calle" required>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 mx-auto">
                <label for="numero_exterior">Número Exterior *</label>
                <input type="number" class="form-control" id="numero_exterior" name="numero_exterior"
                  placeholder="Ingrese el número exterior" required>
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
          </div>

          <!-- Paso 3 -->
          <div id="paso3">
            <div class="row">
              <div class="col-md-12">
                <h3 class="text-center">Datos de Facturación</h3>
                <label for="razon_social">Razón Social *</label>
                <input type="text" class="form-control" id="razon_social" name="razon_social"
                  placeholder="Ingrese la razón social" required>
                <br>
              </div>
            </div>
            <hr style="border-top: 1px solid #ccc;">
            <div class="row">
              <div class="col-md-6">
                <label for="telefono">Teléfono *</label>
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese el teléfono"
                  required>
                <input type="hidden" class="form-control" id="idCliente" name="idCliente" >
                <input type="hidden" id="idDomicilios" name="idDomicilios" class="form-control">
                <input type="hidden" id="idFacturacion" name="idFacturacion" class="form-control">
                <input type="hidden" id="idGenerales" name="idGenerales" class="form-control">
                <br>
              </div>
              <div class="col-md-6">
                <label for="correo">Correo *</label>
                <input type="text" class="form-control" id="correo" name="correo"
                  placeholder="Ingrese el correo electrónico" required>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="nombre_contacto">Nombre Contacto *</label>
                <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto"
                  placeholder="Nombre " required>
                <br>
              </div>
              <div class="col-md-6">
                <label for="apellido_contacto">Apellido Contacto *</label>
                <input type="text" class="form-control" id="apellido_contacto" name="apellido_contacto"
                  placeholder="Apellido paterno" required>
                <br>
              </div>
            </div>
            <hr style="border-top: 1px solid #ccc;">
            <div class="row">
              <div class="col-md-6">
                <label for="rfc">RFC *</label>
                <input type="text" class="form-control" id="rfc" name="rfc" placeholder="Ingrese el RFC" required>
                <br>
              </div>
              <div class="col-md-6">
                <label for="regimen">Régimen *</label>
                <input type="text" class="form-control" id="regimen" name="regimen" placeholder="Ingrese el régimen"
                  required>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="forma_pago">Forma de Pago *</label>
                <select class="form-control" id="forma_pago" name="forma_pago">
                  <option value="una_sola_exhibicion">Una sola exhibición</option>
                  <option value="pago_parcialidades">Pago en parcialidades</option>
                  <option value="pago_diferido">Pago en diferido</option>
                </select>
                <br>
              </div>
              <div class="col-md-6">
                <label for="metodo_pago">Método de Pago *</label>
                <select class="form-control" id="metodo_pago" name="metodo_pago">
                  <option value="efectivo">Efectivo</option>
                  <option value="cheque">Cheque de nómina</option>
                  <option value="transferencia">Transferencia electrónica</option>
                  <option value="tarjeta_credito">Tarjeta de crédito</option>
                  <option value="tarjeta_debito">Tarjeta de débito</option>
                </select>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label for="uso_cfdi">Uso de CFDI *</label>
                <input type="text" class="form-control" id="uso_cfdi" name="uso_cfdi"
                  placeholder="Ingrese el uso de CFDI" value="Gastos Generales" required>
                <br>
              </div>
            </div>
          </div>
        </form>
      </div>


      <div id="msj_error" class="alert alert-danger hidden"></div>
      <hr style="border-top: 1px solid #ccc;">
      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" id="btnAnterior">Anterior</button>
        <button type="button" class="btn btn-primary" id="btnSiguiente">Siguiente</button>
        <button type="button" class="btn btn-success" id="btnGuardar" onclick="guardarCliente()">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- modal para mensaje -->
<div class="modal fade" id="mensajeModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titulo_mensaje1"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 id="mensaje"></h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnConfirmar">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<!-- modal para mostrar accesos de los clientes -->
<div class="modal fade" id="accesosClienteModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cliente: <span class="nombreCliente"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="div_accesos"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- modal para registrar un nuevo acceso para un cliente -->
<div class="modal fade" id="nuevoAccesoClienteModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registro de credenciales del cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAccesoCliente">
          <div class="row">
            <div class="col-md-12">
              <label for="id_cliente">Cliente *</label>
              <select name="cliente" id="id_cliente" class="form-control"></select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mx-auto">
              <label for="nombre_cliente">Nombre *</label>
              <input type="text" class="form-control" name="nombre" id="nombre_cliente"
                onKeyUp="this.value=this.value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4 mx-auto">
              <label for="paterno_cliente">Primer apellido *</label>
              <input type="text" class="form-control" name="paterno" id="paterno_cliente"
                onKeyUp="this.value=this.value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4 mx-auto">
              <div class="custom-control custom-switch">
                <br>
                <input type="checkbox" class="custom-control-input" id="tipoUsuarioSwitch" name="tipo_usuario">
                <label class="custom-control-label" for="tipoUsuarioSwitch">Espectador</label>
              </div>
              <input type="hidden" name="tipo_usuario" id="hiddenTipoUsuario" value="null">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="privacidad">Privacidad de visualizar candidatos *</label>
              <select class="form-control" id="privacidad" name="privacidad">
                <option value="0">Sin privacidad (Visible para usuarios/clientes sin privacidad y Nivel 1)
                </option>
                <option value="1">Nivel 1 (Visibilidad total de los candidatos)</option>
                <option value="2">Nivel 2 (Visibilidad de candidatos para Nivel 2 y 1) </option>
                <option value="3">Nivel 3 (Visibilidad de candidatos para Nivel 3 y 1)</option>
                <option value="4">Nivel 4 (Visibilidad de candidatos para Nivel 4 y 1)</option>
                <option value="5">Nivel 5 (Visibilidad de candidatos para Nivel 5 y 1)</option>
                <option value="6">Nivel 6 (Visibilidad de candidatos para Nivel 6 y 1)</option>
                <option value="7">Nivel 7 (Visibilidad de candidatos para Nivel 7 y 1)</option>
                <option value="8">Nivel 8 (Visibilidad de candidatos para Nivel 8 y 1)</option>
                <option value="9">Nivel 9 (Visibilidad de candidatos para Nivel 9 y 1)</option>
                <option value="10">Nivel 10 (Visibilidad de candidatos para Nivel 10 y 1)</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="correo_cliente">Correo *</label>
              <input type="text" class="form-control" name="correo_cliente_name" id="correo_cliente">

            </div>
            <div class="col-md-6">
              <label for="number">Teléfono </label>
              <input type="text" class="form-control" name="telefono" id="telefono" maxlength="12">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 mx-auto">
              <label for="generarPass">Da click</label>
              <button type="button" class="btn btn-primary" id="generarPass" onclick="generarPassword()">Generar
                contraseña</button>
              <br>
            </div>
            <div class="col-md-6 mx-auto">
              <label for="password">Contraseña *</label>
              <input type="password" class="form-control" name="password_name" id="password" maxlength="8" readonly>
              <br>
            </div>

          </div>
        </form>
        <div class="row">
          <div class="col-md-12">
            <p>* La contraseña sera enviada al correo especificado en este apartado verifica que sea correcto y que se
              tenga acceso al mismo
            </p>
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="crearAccesoClientes()">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- modal para bloquear al cliente -->
<div class="modal fade" id="bloquearClienteModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titulo_mensaje5"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 id="mensaje"></h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnConfirmar">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<script>
function registrarCliente() {
  // Resto de tu código...

  // Llamada AJAX para obtener el token y cargar países, estados y ciudades
  var auth_token = "MUJkuDQTBwg6L_OLJghlvf5LDwdas3Tnm5EaF3Kny_7GIUXTah_7nbuE-K15HdxxTxo";

  // Agrega la lógica para cargar países, estados y ciudades aquí
  cargarPaisesEstadosCiudades(auth_token);
  $(document).ready(function() {

    // Event listener para el botón "Siguiente"
    $("#btnSiguiente").on("click", function() {
      nextStep();
    });
    $("#cerrarModal").on("click", function() {
            // Resetea el formulario al cerrar el modal
            $("#formCatCliente")[0].reset();
        });

    // Event listener para el botón "Anterior"
    $("#btnAnterior").on("click", function() {
      previousStep();
    });
    // Función para avanzar al siguiente paso
    function nextStep() {
      console.log("Avanzando al siguiente paso");
      if (currentStep < totalSteps) {
        currentStep++;
        loadStep(currentStep);
      }
    }

    // Función para retroceder al paso anterior
    function previousStep() {
      console.log("Retrocediendo al paso anterior");
      if (currentStep > 1) {
        currentStep--;
        loadStep(currentStep);
      }
    }

    // Cargar los países, estados y ciudades al abrir el modal


    $("#newModal").on("hide.bs.modal", function() {
      $("#newModal input").val("");
      $("#newModal #msj_error").css('display', 'none');
      $("#titulo_nuevo_modal").text("Nuevo cliente");
    });

    // Variables para el control del formulario por pasos
    var currentStep = 1;
    var totalSteps = 3;

    // Función para cargar el contenido del formulario según el paso
    function loadStep(step) {
      console.log("Cargando paso " + step);
      // Ocultar todos los pasos
      $("#formContainer > div").hide();
      // Mostrar solo el paso actual
      $("#paso" + step).show();

      // Lógica específica del paso, como mostrar/ocultar botones
      if (currentStep === 1) {
        $("#btnAnterior").hide();
        $("#btnSiguiente").show();
        $("#btnGuardar").show();
      } else if (currentStep === totalSteps) {
        $("#btnAnterior").show();
        $("#btnSiguiente").hide();
        $("#btnGuardar").show();
      } else {
        $("#btnAnterior").show();
        $("#btnSiguiente").show();
        $("#btnGuardar").show();
      }

    }

    // Cargar el primer paso al abrir el modal
    loadStep(currentStep);
  });

}


function cargarPaisesEstadosCiudades(auth_token) {
  $.ajax({
  
    url: 'https://www.universal-tutorial.com/api/getaccesstoken',
    method: 'GET',
    headers: {
      "Accept": "application/json",
      "api-token": auth_token,
      "user-email": "rodi.control@gmail.com"
    },
    success: function(data) {
      if (data.auth_token) {
        var auth_token = data.auth_token;
        $.ajax({
          url: 'https://www.universal-tutorial.com/api/countries/',
          method: 'GET',
          headers: {
            "Authorization": "Bearer " + auth_token,
            "Accept": "application/json"
          },
          success: function(data) {
            var countries = data;
            var comboCountries = "<option value=''>Seleccionar</option>";
            countries.forEach(element => {
              comboCountries += '<option value="' + element['country_name'] + '">' + element[
                'country_name'] + '</option>';
            });

            $("#item-details-countryValue").html(comboCountries);

            // State list
            $("#item-details-countryValue").on("change", function() {
              var country = this.value;
              $.ajax({
                url: 'https://www.universal-tutorial.com/api/states/' + country,
                method: 'GET',
                headers: {
                  "Authorization": "Bearer " + auth_token,
                  "Accept": "application/json"
                },
                success: function(data) {
                  var states = data;
                  var comboStates = "<option value=''>Estados de: " + country + "</option>";
                  states.forEach(element => {
                    comboStates += '<option value="' + element['state_name'] + '">' + element[
                      'state_name'] + '</option>';
                  });
                  $("#item-details-stateValue").html(comboStates);
                  // City list
                  $("#item-details-stateValue").on("change", function() {
                    var state = this.value;
                    $.ajax({
                      url: 'https://www.universal-tutorial.com/api/cities/' + state,
                      method: 'GET',
                      headers: {
                        "Authorization": "Bearer " + auth_token,
                        "Accept": "application/json"
                      },
                      success: function(data) {
                        var cities = data;
                        var comboCities = "<option value=''>Ciudades de: " + state +
                          "</option>"; // Aquí se indica el estado seleccionado
                        cities.forEach(element => {
                          comboCities += '<option value="' + element['city_name'] +
                            '">' + element['city_name'] + '</option>';
                        });
                        $("#item-details-cityValue").html(comboCities);
                      },
                      error: function(e) {
                        console.log("Error al obtener ciudades: " + e);
                      }
                    });
                  });
                },
                error: function(e) {
                  console.log("Error al obtener estados: " + e);
                }
              });

            });
          },
          error: function(e) {
            console.log("Error al obtener países: " + e);
          }
        });
      }
    },
    error: function(e) {
      console.log("Error al obtener el token de acceso: " + e);
    }
  });
}
</script>