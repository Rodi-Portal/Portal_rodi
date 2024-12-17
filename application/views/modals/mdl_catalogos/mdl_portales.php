<div class="modal fade" id="newPortal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_nuevo_modal">Nuevo portal</h5>
        <button type="button" class="close custom_modal_close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div>

        </div>
        <div class="alert alert-info">¡Bienvenido al registro de un nuevo portal! Estamos aquí para facilitarte el
          proceso. Puedes completar el formulario parcialmente si así lo deseas. Los campos marcados con un
          asterisco (*) son obligatorios: Nombre y Clave
        </div>
        <div class="row justify-content-center align-items-center text-center mb-3">
          <div class="col-1">
            <button type="button" class="btn btn-primary" id="paso1">1</button>
          </div>
          <div class="col-1 barra_espaciadora_off" id="barra1"></div>
          <div class="col-1">
            <button type="button" class="btn btn-primary" id="paso2">2</button>
          </div>
          <div class="col-1 barra_espaciadora_off" id="barra2"></div>
          <div class="col-1">
            <button type="button" class="btn btn-primary" id="paso3">3</button>
          </div>
        </div>
        <h5 class="text-center" id="titulo_paso"></h5>
        <form id="formPaso1">
          <div class="row">
            <div class="col-md-9">

              <label for="nombre">Nombre del Portal *</label>
              <input type="text" class="form-control" data-field="Nombre de la Sucursal" data-required="required"
                id="nombrePortal" name="nombrePortal" placeholder="Ingrese el nombre de la Sucursal"
                onkeyup="this.value=this.value.toUpperCase()" required>
              <br>
            </div>
            <div class="col-md-3">
              <label for="accesos">Accesos *</label>
              <input type="number" class="form-control" data-field="Numero de accesos" data-required="required"
                id="accesos" name="accesos" value=5>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="telefono">Teléfono</label>
              <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ingrese el teléfono">
              <input type="hidden" class="form-control" id="idPortal" name="idPortal">
              <input type="hidden" id="idDomicilios" name="idDomicilios" class="form-control">
              <input type="hidden" id="idFacturacion" name="idFacturacion" class="form-control">
              <input type="hidden" id="idGenerales" name="idGenerales" class="form-control">
              <br>
            </div>
            <div class="col-md-8">
              <label for="correo">Correo</label>
              <input type="text" class="form-control" data-field="Correo" id="correo" name="correo"
                data-required="required" placeholder="Ingrese el correo electrónico" required>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="nombre_contacto">Nombre Contacto</label>
              <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto" placeholder="Nombre "
                onkeyup="capitalizeFirstLetter(event)">
              <br>
            </div>
            <div class="col-md-6">
              <label for="apellido_contacto">Apellido Contacto</label>
              <input type="text" class="form-control" id="apellido_contacto" name="apellido_contacto"
                placeholder="Apellido" onkeyup="capitalizeFirstLetter(event)">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="password" id="passLabel">Generar contraseña *</label>
              <div class="input-group">
                <input type="password" class="form-control" data-field="Contraseña" name="password" id="password"
                  data-required="required" readonly required>
                <div class="input-group-append">
                  <button type="button" class="btn btn-primary" id="generarPass"
                    onclick="generarPassword()">Generar</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <form id="formPaso2" class="hidden">
          <div class="row">
            <div class="col-md-12">
              <label for="razon_social">Razón Social</label>
              <input type="text" class="form-control" id="razon_social" name="razon_social"
                placeholder="Ingrese la razón social" onkeyup="capitalizeFirstLetter(event)">
              <br>
            </div>

          </div>
          <hr style="border-top: 1px solid #ccc;">
          <div class="row">
            <div class="col-md-6">
              <label for="rfc">RFC</label>
              <input type="text" class="form-control" id="rfc" name="rfc" placeholder="Ingrese el RFC"
                onkeyup="this.value=this.value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-6">
              <label for="regimen">Régimen</label>
              <input type="text" class="form-control" id="regimen" name="regimen" placeholder="Ingrese el régimen"
                onkeyup="capitalizeFirstLetter(event)">
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
              <input type="text" class="form-control" id="uso_cfdi" name="uso_cfdi" placeholder="Ingrese el uso de CFDI"
                value="Gastos Generales" onkeyup="capitalizeFirstLetter(event)">
              <br>
            </div>
          </div>
        </form>
        <form id="formPaso3" class="hidden">
          <!-- Paso 2: Domicilio -->
          <div class="row">

          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="item-details-countryValue">País</label>
              <input type="text" class="form-control" id="item-details-countryValue" name="pais_name"
                onkeyup="capitalizeFirstLetter(event)">


              <br>
            </div>
            <div class="col-md-6">
              <label for="item-details-stateValue">Estado</label>
              <input type="text" class="form-control" id="item-details-stateValue" name="state_name"
                onkeyup="capitalizeFirstLetter(event)">

              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="item-details-cityValue">Ciudad</label>
              <input type="text" class="form-control" id="item-details-cityValue" name="ciudad_name"
                onkeyup="capitalizeFirstLetter(event)">

              <br>
            </div>
            <div class="col-md-6">
              <label for="colonia">Colonia</label>
              <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Ingrese la colonia"
                onkeyup="capitalizeFirstLetter(event)">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="calle">Calle</label>
              <input type="text" class="form-control" id="calle" name="calle" placeholder="Ingrese la calle"
                onkeyup="capitalizeFirstLetter(event)">
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
              <input type="number" class="form-control" id="cp" name="numero_cp" placeholder="Ingrese el codigo postal">
              <br>
            </div>
          </div>
          <br>
        </form>
        <!-- Paso 3 -->

      </div>
      <div class="modal-footer custom_modal_footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

        <button type="button" class="btn btn-primary btn-icon-split" id="btnRegresar">
          <span class="icon text-white-50">
            <i class="fas fa-arrow-left"></i>
          </span>
          <span class="text">Regresar</span>
        </button>
        <button type="button" class="btn btn-success btn-icon-split" id="btnContinuar">
          <span class="text">Continuar</span>
          <span class="icon text-white-50">
            <i class="fas fa-arrow-right"></i>
          </span>
        </button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="editPortal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_nuevo_modal_editar">Editar Portal</h5>
        <button type="button" class="close custom_modal_close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div>

        </div>
        <div class="alert alert-info">Este formulario está diseñado para editar la información general del portal.
        </div>

        <h5 class="text-center" id="titulo_paso"></h5>
        <form id="formEditar">
          <div class="row">
            <div class="col-md-9">

              <label for="nombre">Nombre del Portal *</label>
              <input type="text" class="form-control" data-field="Nombre del Sucursal" data-required="required"
                id="nombrePortal_edit" name="nombrePortal_edit" placeholder="Ingrese el nombre de la Sucursal"
                onkeyup="this.value=this.value.toUpperCase()" required>

            </div>
            <div class="col-md-3">
              <label for="accesos">Accesos *</label>
              <input type="number" class="form-control" data-field="Numero de accesos" data-required="required"
                id="accesosEdit" name="accesosEdit">

            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <input type="hidden" class="form-control" id="idPortalE" name="idPortalE">
              <input type="hidden" id="idDomiciliosE" name="idDomiciliosE" class="form-control">
              <input type="hidden" id="idFacturacionE" name="idFacturacionE" class="form-control">
              <input type="hidden" id="idUsuarioPortalE" name="idUsuarioPortalE" class="form-control">


              <br>
            </div>
            <div class="col-md-12">
              <label for="razon_social">Razón Social</label>
              <input type="text" class="form-control" id="razon_social_edit" name="razon_social_edit"
                placeholder="Ingrese la razón social" onkeyup="capitalizeFirstLetter(event)">
              <br>
            </div>
          </div>
          <div class="row">
          </div>
          <hr style="border-top: 1px solid #ccc;">
          <div class="row">
            <div class="col-md-6">
              <label for="rfc">RFC</label>
              <input type="text" class="form-control" id="rfc_edit" name="rfc_edit" placeholder="Ingrese el RFC"
                onkeyup="this.value=this.value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-6">
              <label for="regimen">Régimen</label>
              <input type="text" class="form-control" id="regimen_edit" name="regimen_edit"
                placeholder="Ingrese el régimen" onkeyup="capitalizeFirstLetter(event)">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="forma_pago">Forma de Pago</label>
              <select class="custom-select" id="forma_pago_edit" name="forma_pago_edit">
                <option value="" selected>Selecciona</option>
                <option value="Pago en una sola exhibición">Pago en una sola exhibición</option>
                <option value="Pago en parcialidades o diferidos">Pago en parcialidades o diferidos</option>
              </select>
              <br>
            </div>
            <div class="col-md-6">
              <label for="metodo_pago">Método de Pago</label>
              <select class="custom-select" id="metodo_pago_edit" name="metodo_pago_edit">
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
              <input type="text" class="form-control" id="uso_cfdi_edit" name="uso_cfdi_edit" placeholder="Ingrese el uso de CFDI"
                value="Gastos Generales" onkeyup="capitalizeFirstLetter(event)">
              <br>
            </div>
          </div>

          <!-- Paso 2: Domicilio -->
          <div class="row">

          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="pais_edit">País</label>
              <input type="text" class="form-control" id="pais_edit" name="pais_edit"
                onkeyup="capitalizeFirstLetter(event)">


              <br>
            </div>
            <div class="col-md-6">
              <label for="estado_edit">Estado</label>
              <input type="text" class="form-control" id="estado_edit" name="estado_edit"
                onkeyup="capitalizeFirstLetter(event)">

              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="ciudad_edit">Ciudad</label>
              <input type="text" class="form-control" id="ciudad_edit" name="ciudad_edit"
                onkeyup="capitalizeFirstLetter(event)">

              <br>
            </div>
            <div class="col-md-6">
              <label for="colonia">Colonia</label>
              <input type="text" class="form-control" id="colonia_edit" name="colonia_edit" placeholder="Ingrese la colonia"
                onkeyup="capitalizeFirstLetter(event)">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="calle">Calle</label>
              <input type="text" class="form-control" id="calle_edit" name="calle_edit" placeholder="Ingrese la calle"
                onkeyup="capitalizeFirstLetter(event)">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 mx-auto">
              <label for="numero_exterior">Número Exterior</label>
              <input type="number" class="form-control" id="numero_exterior_edit" name="numero_exterior_edit"
                placeholder="Ingrese el número exterior">
              <br>
            </div>
            <div class="col-md-3 mx-auto">
              <label for="numero_interior">Número Interior</label>
              <input type="text" class="form-control" id="numero_interior_edit" name="numero_interior_edit"
                placeholder="Ingrese el número interior">
              <br>
            </div>
            <div class="col-md-3 mx-auto">
              <label for="cp">Codigo Postal</label>
              <input type="number" class="form-control" id="numero_cp_edit" name="numero_cp_edit" placeholder="Ingrese el codigo postal">
              <br>
            </div>
          </div>
          <br>
        </form>

      </div>
      <div class="modal-footer custom_modal_footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

        <button type="button" class="btn btn-success btn-icon-split ml-auto" id="btnActualizar">
          <span class="text">Actualizar</span>
          <span class="icon text-white-50">
            <i class="fas fa-arrow-right"></i>
          </span>
        </button>
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
        <h4 class="modal-title">Sucursales: <span class="nombreCliente"></span></h4>
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
        <h5 class="modal-title">Registro de credenciales de la Sucursal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAccesoCliente">
          <div class="row">
            <div class="col-md-12">
              <label for="id_cliente">Sucursal *</label>
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
            <div class="col-md-12">
              <label for="password_us">Generar contraseña *</label>
              <div class="input-group">
                <input type="password" class="form-control" data-field="Contraseña" name="password_us" id="password_us"
                  data-required="required" readonly required>
                <div class="input-group-append">
                  <button type="button" class="btn btn-primary" onclick="generarPassword_us()">Generar</button>
                </div>
              </div>
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
<input type="hidden" id="base_url" value="<?php echo base_url('Cat_Cliente/setCliente'); ?>">

<script>
$(document).ready(function() {
  let pag = 1; // Variable para controlar el paso actual del formulario

  // Manejo de eventos para ocultar el modal
  $('#newPortal').off('hidden.bs.modal').on('hidden.bs.modal', function () {
    $(this).find('.modal-title').text('Nuevo Portal');
    resetModal();
  });

  $('#editPortal').off('hidden.bs.modal').on('hidden.bs.modal', function () {
    $(this).find('.modal-title').text('Editar Portal');
  });

  function resetModal() {
    $("#newPortal input, #newPortal select").val("");
    $("#newPortal #msj_error").css('display', 'none');
    $("#idSubcliente").val("");
    $("#newPortal #titulo_paso").text('Informacíon Cliente');
    $("#newPortal #btnRegresar, #newPortal #paso2").prop('disabled', true);
    $("#newPortal #btnContinuar span.text").text('Continuar');
    document.getElementById('formPaso1').className = "block";
    document.getElementById('formPaso2').className = "hidden";
    document.getElementById('formPaso3').className = "hidden";
    document.getElementById('barra1').className = 'barra_espaciadora_off';
    document.getElementById('barra2').className = 'barra_espaciadora_off';
    pag = 1;
  }

  // Manejo de evento para el botón "Continuar"
  $('#newPortal #btnContinuar').off('click').on('click', function() {
    $(this).prop('disabled', true); // Desactiva el botón para evitar múltiples clics

    let formulario_actual = document.getElementById('formPaso' + pag);
    let todoCorrecto = true;

    // Validar formulario
    $(formulario_actual).find(':input').each(function() {
      if ($(this).attr('data-required') === 'required' && $.trim($(this).val()) === '') {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema',
          html: 'El campo <b>' + $(this).attr('data-field') + '</b> no es válido',
          width: '50em',
          confirmButtonText: 'Cerrar'
        });
        todoCorrecto = false;
        return false; // Rompe el loop
      }
    });

    if (todoCorrecto) {
      if (pag === 1) {
        transitionForm('formPaso1', 'formPaso2', 'Informacíon de Contacto', 'Continuar', ['#btnRegresar', '#paso2'], 'barra_espaciadora_on', 'barra_espaciadora_off');
      } else if (pag === 2) {
        transitionForm('formPaso2', 'formPaso3', 'Domicilio', 'Finalizar', ['#paso3'], 'barra_espaciadora_on', 'barra_espaciadora_off');
      } else if (pag === 3) {
        submitForm();
      }
      if (pag < 3) pag++;
    }

    $(this).prop('disabled', false); // Reactiva el botón
  });

  // Manejo de evento para el botón "Regresar"
  $('#newPortal #btnRegresar').off('click').on('click', function() {
    if (pag === 2) {
      transitionForm('formPaso2', 'formPaso1', 'Informacíon Cliente', 'Continuar', [], 'barra_espaciadora_off', 'barra_espaciadora_on');
    } else if (pag === 3) {
      transitionForm('formPaso3', 'formPaso2', 'Informacíon de Contacto', 'Continuar', [], 'barra_espaciadora_off', 'barra_espaciadora_on');
    }
    if (pag > 1) pag--;
  });

  function transitionForm(fromId, toId, title, continueText, enabledButtons,        removeClass, addClass) {
    document.getElementById(fromId).className = "animate__animated animate__fadeOut";
    setTimeout(function() {
      document.getElementById(fromId).className = "hidden";
      document.getElementById(toId).className = "animate__animated animate__fadeInUp";
      $("#newPortal #titulo_paso").text(title);
      $("#newPortal #btnContinuar span.text").text(continueText);
      enabledButtons.forEach(function(btn) {
        $(btn).prop('disabled', false);
      });
      document.getElementById('barra1').classList.toggle(removeClass, removeClass === 'barra_espaciadora_on');
      document.getElementById('barra1').classList.toggle(addClass, addClass === 'barra_espaciadora_on');
    }, 500);
  }

  function submitForm() {
    let formData = $('#formPaso1, #formPaso2, #formPaso3').serializeArray();
    let datos = {};

    formData.forEach(function(field) {
      datos[field.name] = field.value || null;
    });

    datos['currentPage'] = $('#currentPage').val();

    $.ajax({
      url: "<?php echo base_url('Cat_Portales/setPortal'); ?>",
      type: 'post',
      data: datos,
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        $('.loader').fadeOut();
        var data = JSON.parse(res);
        if (data.codigo === 1) {
          $("#newPortal").modal('hide');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: data.msg,
            showConfirmButton: false,
            timer: 3000
          }).then(function() {
            window.location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Hubo un problema',
            html: data.msg,
            width: '50em',
            confirmButtonText: 'Cerrar',
            timer: 3000
          });
        }
      },
      error: function(xhr, status, error) {
        $('.loader').fadeOut();
        Swal.fire({
          icon: 'error',
          title: 'Error de conexión',
          text: 'No se pudo completar la solicitud.',
          confirmButtonText: 'Cerrar'
        });
      }
    });
  }
});


$('#editPortal #btnActualizar').on('click', function() {
  // Recopilar datos del formulario
  var datos = $('#formEditar').serialize(); // Serializa los datos del formulario

  $.ajax({
    url: "<?php echo base_url('Cat_Portales/editPortal'); ?>",
    type: 'post',
    data: datos,
    beforeSend: function() {
      $('.loader').css("display", "block");
    },
    success: function(res) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);

      var data = JSON.parse(res); // Asegúrate de que el servidor devuelve JSON

      if (data.codigo === 1) {
        $("#editPortal").modal('hide');


        Swal.fire({
          position: 'center',
          icon: 'success',
          title: data.msg,
          showConfirmButton: false,
          timer: 3000
        }).then(function() {
          // Recargar la página después de que el mensaje de éxito desaparezca
          window.location.reload();
        });
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Hubo un problema',
          html: data.msg,
          width: '50em',
          confirmButtonText: 'Cerrar',
          timer: 3000
        });
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      setTimeout(function() {
        $('.loader').fadeOut();
      }, 200);

      Swal.fire({
        icon: 'error',
        title: 'Error en la solicitud',
        text: 'Hubo un problema al enviar la solicitud.',
        confirmButtonText: 'Cerrar'
      });
    }
  });
});

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
function capitalizeFirstLetter(event) {
  const input = event.target;
  const value = input.value;
  // Solo capitaliza la primera letra y pone el resto en minúsculas
  input.value = value.charAt(0).toUpperCase() + value.slice(1).toLowerCase();
}


</script>