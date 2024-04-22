<div class="modal fade" id="newModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl custom_modal_size" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_nuevo_modal">Nuevo Sub-Cliente</h5>
        <button type="button" class="close custom_modal_close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="alert alert-info">¡Bienvenido al registro de un nuevo subcliente! Estamos aquí para facilitarte el
          proceso. Puedes completar el formulario parcialmente si así lo deseas. Los campos marcados con un asterisco
          (*) son obligatorios: Cliente, Nombre del Subcliente y Clave.
          Los demás campos pueden ser completados en otro momento. </div>
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
            <div class="col-md-12">
              <input type="hidden" class="form-control" id="idSubCliente" name="idSubCliente">
              <input type="hidden" id="idDomicilios" name="idDomicilios" class="form-control">
              <input type="hidden" id="idFacturacion" name="idFacturacion" class="form-control">
              <input type="hidden" id="idGenerales" name="idGenerales" class="form-control">

              <label for="cliente">Cliente *</label>
              <select name="idCliente" data-field="Cliente" id="idCliente" class="form-control"
                data-required="required">
                <option value="">Selecciona</option>
                <?php
foreach ($clientes as $cl) {?>
                <option value="<?php echo $cl->id; ?>"><?php echo $cl->nombre; ?></option>
                <?php
}?>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Nombre del subcliente *</label>
              <input type="text" class="form-control" data-field="Subcliente" data-required="required"
                name="nombreSubcliente" placeholder="Ingrese el nombre del sub-cliente" id="nombreSubcliente"
                onkeyup="this.value=this.value.toUpperCase()" required>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Clave *</label>
              <input type="text" class="form-control" data-required="required" data-field="Clave" name="claveSubcliente"
                id="claveSubcliente" maxlength="3" onkeyup="this.value=this.value.toUpperCase()" required>
              <br>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-8">
              <label for="razonSocial">Razón Social</label>
              <input type="text" class="form-control" data-field="Razon Social" name="razonSocial" id="razonSocial">
            </div>

            <div class="col-4">
              <label for="rfc">RFC</label>
              <input type="text" class="form-control" data-field="RFC" name="rfc" id="rfc">
            </div>
          </div>

        </form>
        <form id="formPaso2" class="hidden">
          <div class="row mb-3">
            <div class="col-6">
              <label for="nombreContacto">Nombre contacto</label>
              <input type="text" class="form-control" data-field="Nombre Contacto" name="nombreContacto"
                id="nombreContacto">
            </div>
            <div class="col-6">
              <label for="apellidoContacto">Apellido Contacto</label>
              <input type="text" class="form-control" data-field="Apellido Paterno" name="apellidoContacto"
                id="apellidoContacto">
            </div>
          </div>
          <div class="row mb-6">
            <div class="col-6">
              <label for="corrre">Correo </label>
              <input class="form-control" data-field="Correo" name="correo" id="correo">
            </div>
            <div class="col-6">
              <label for="corrre">Telefono </label>
              <input class="form-control" data-field="Correo" name="telefono" id="telefono">
            </div>
          </div>
        </form>
        <form id="formPaso3" class="hidden">
          <div id="paso2">
            <div class="row">
              <div class="col-md-12">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label for="item-details-countryValue">País </label>
                <select class="form-control" id="item-details-countryValue" name="pais_name">
                  <!-- Opciones de país cargadas dinámicamente -->
                </select>
                <br>
              </div>
              <div class="col-md-6">
                <label for="item-details-stateValue">Estado </label>
                <select class="form-control" id="item-details-stateValue" name="state_name">
                  <option value="NULL">Primero Selecciona un Pais</option>
                  <!-- Opciones de estado cargadas dinámicamente -->
                </select>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="item-details-cityValue">Ciudad </label>
                <select class="form-control" id="item-details-cityValue" name="ciudad_name">
                  <option value="NULL">Primero Selecciona un Estado</option>
                  <!-- Opciones de ciudad cargadas dinámicamente -->
                </select>
                <br>
              </div>
              <div class="col-md-6">
                <label for="colonia">Colonia </label>
                <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Ingrese la colonia"
                  required>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label for="calle">Calle </label>
                <input type="text" class="form-control" id="calle" name="calle" placeholder="Ingrese la calle" required>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 mx-auto">
                <label for="numero_exterior">Número Exterior </label>
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
        </form>
      </div>
      <div class="modal-footer custom_modal_footer">
        <button type="button" class="btn btn-primary btn-icon-split" id="btnRegresar">
          <span class="icon text-white-50">
            <i class="fas fa-arrow-left"></i>
          </span>
          <span class="text">Regresar</span>
        </button>
        <button type="button" class="btn btn-success btn-icon-split" id="btnContinuar">
          <span class="text"></span>
          <span class="icon text-white-50">
            <i class="fas fa-arrow-right"></i>
          </span>
        </button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="quitarModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titulo_accion"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="" id="texto_confirmacion"></p><br>
        <div class="row" id="div_commentario">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="accion" onclick="ejecutarOperacion()">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="accesoModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registro de credenciales del subcliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <label for="id_cliente">Cliente *</label>
            <select name="id_cliente" id="id_cliente" class="form-control acceso_obligado">
              <option value="">Selecciona</option>
              <?php
              foreach ($clientes as $cl) {?>
              <option value="<?php echo $cl->id; ?>"><?php echo $cl->nombre; ?></option>
              <?php
       }?>
            </select>
            <br>
          </div>
          <div class="col-md-6">
            <label>Subcliente *</label>
            <select name="id_subcliente" id="id_subcliente" class="form-control acceso_obligado" disabled>
              <option value="">Selecciona</option>
            </select>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <label>Nombre *</label>
            <input type="text" class="form-control acceso_obligado" name="nombre_cliente" id="nombre_cliente"
              onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            <br>
          </div>
          <div class="col-md-6">
            <label>Apellido paterno *</label>
            <input type="text" class="form-control acceso_obligado" name="paterno_cliente" id="paterno_cliente"
              onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label>Correo *</label>
            <input type="text" class="form-control acceso_obligado" name="correo_cliente" id="correo_cliente">
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <label>Da click</label>
            <button class="btn btn-primary" onclick="generarPassword()">Generar contraseña</button>
            <br>
          </div>
          <div class="col-md-6">
            <label>Contraseña *</label>
            <input type="text" class="form-control acceso_obligado" name="password" id="password" maxlength="8"
              readonly>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p>* Copia la contraseña para enviarla al subcliente o proveedor, ya que al no hacerlo se tendrá que generar
              una nueva</p>
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="crear_acceso">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="accesosClienteModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Subcliente <span id="nombreSubcliente"></span></h4>
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
        <button type="button" class="btn btn-success" id="btnConfirm">Confirmar</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="base_url" value="<?php echo base_url('Cat_Subclientes/registrarSubcliente'); ?>">

<script src="<?php echo base_url() ?>js/apis/registrarClientes.js"></script>