<div class="modal fade" id="newModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar subcliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="datos">
          <div class="row">
            <div class="col-md-12">
              <label>Nombre del subcliente *</label>
              <input type="text" class="form-control obligado" name="nombre" id="nombre" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Cliente *</label>
              <select name="cliente" id="cliente" class="form-control obligado">
                <option value="">Selecciona</option>
                <?php
                foreach ($clientes as $cl) { ?>
                  <option value="<?php echo $cl->id; ?>"><?php echo $cl->nombre; ?></option>
                <?php
                } ?>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Clave *</label>
              <input type="text" class="form-control obligado" name="clave" id="clave" maxlength="3" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="guardar" value="nuevo">Guardar</button>
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
            <label>Cliente *</label>
            <select name="id_cliente" id="id_cliente" class="form-control acceso_obligado">
              <option value="">Selecciona</option>
              <?php
              foreach ($clientes as $cl) { ?>
                <option value="<?php echo $cl->id; ?>"><?php echo $cl->nombre; ?></option>
              <?php
              } ?>
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
            <input type="text" class="form-control acceso_obligado" name="nombre_cliente" id="nombre_cliente" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            <br>
          </div>
          <div class="col-md-6">
            <label>Apellido paterno *</label>
            <input type="text" class="form-control acceso_obligado" name="paterno_cliente" id="paterno_cliente" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
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
            <input type="text" class="form-control acceso_obligado" name="password" id="password" maxlength="8" readonly>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p>* Copia la contraseña para enviarla al subcliente o proveedor, ya que al no hacerlo se tendrá que generar una nueva</p>
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
<script>
  $("#newModal").on("hidden.bs.modal", function() {
    $("#newModal input,#newModal select").val("");
    $("#newModal #msj_error").css('display', 'none');
    $("#idSubcliente").val("");
    $(".modal-title").text("Agregar subcliente");
    $("#guardar").attr('value', 'nuevo');
  });
  $("#accesoModal").on("hidden.bs.modal", function() {
    $("#accesoModal input, #accesoModal select").val("");
    $("#accesoModal #msj_error").css('display', 'none');
    $("#idSubcliente").val("");
  });
</script>