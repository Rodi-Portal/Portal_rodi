<div class="modal fade" id="nuevoModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registrar examen antidoping</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="nuevo">
          <div class="row">
            <!--div class="col-12 text-center">
              <h5 id="clave"><b>Clave a registrar: Pendiente</b></h5>
            </div-->
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Nombre(s) *</label>
              <input type="text" class="form-control nuevo_obligado" name="nombre" id="nombre" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Primer apellido *</label>
              <input type="text" class="form-control nuevo_obligado" name="paterno" id="paterno" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-6">
              <label>Segundo apellido</label>
              <input type="text" class="form-control" name="materno" id="materno" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Cliente *</label>
              <select name="cliente" id="cliente" class="form-control nuevo_obligado">
                <option value="">Selecciona</option>
                <?php
                foreach ($clientes as $cl) { ?>
                    <option value="<?php echo $cl->id; ?>"><?php echo $cl->nombre; ?></option>
                <?php
                }
                ?>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Subcliente *</label>
              <select name="subcliente" id="subcliente" class="form-control nuevo_obligado" disabled>
                <option value="0">Selecciona</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Proyecto *</label>
              <select name="proyecto" id="proyecto" class="form-control nuevo_obligado" disabled>
                <option value="0">Selecciona</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Parámetros a aplicar *</label>
              <select name="paquete" id="paquete" class="form-control nuevo_obligado" disabled>
                <option value="">Selecciona</option>
                <?php
                foreach ($paquetes as $paq) { ?>
                  <option value="<?php echo $paq->id; ?>"><?php echo $paq->nombre; ?></option>
                <?php }
                ?>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Fecha de nacimiento *</label>
              <input type="text" class="form-control nuevo_obligado tipo_fecha" name="nuevo_fecha_nacimiento" id="nuevo_fecha_nacimiento" placeholder="dd/mm/yyyy">
              <br>
            </div>
            <div class="col-md-4">
              <label>Tipo identificación *</label>
              <select name="nuevo_identificacion" id="nuevo_identificacion" class="form-control nuevo_obligado">
                <option value="">Selecciona</option>
                <?php
                foreach ($identificaciones as $ide) { ?>
                  <option value="<?php echo $ide->id; ?>"><?php echo $ide->nombre; ?></option>
                <?php }
                ?>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Número, licencia o código *</label>
              <input type="text" class="form-control nuevo_obligado" name="nuevo_ine" id="nuevo_ine">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Razón *</label>
              <select name="nuevo_razon" id="nuevo_razon" class="form-control nuevo_obligado">
                <option value="">Selecciona</option>
                <option value="1">Nuevo ingreso</option>
                <option value="2">Aleatorio</option>
                <option value="3">Actualización</option>
              </select>
              <br>
            </div>
            <div class="col-md-6">
              <label>¿Este examen es foráneo (fuera de GDL)? *</label>
              <select name="nuevo_foraneo" id="nuevo_foraneo" class="form-control nuevo_obligado">
                <option value="">Selecciona</option>
                <option value="NO">NO</option>
                <option value="SI">SI</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Medicamentos recetados * </label>
              <textarea name="nuevo_medicamentos" id="nuevo_medicamentos" class="form-control nuevo_obligado" rows="2"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Fecha de doping *</label>
              <input type="text" class="form-control nuevo_obligado tipo_fecha_hora" name="nuevo_fecha_doping" id="nuevo_fecha_doping">
              <br>
            </div>
            <div class="col-md-6">
              <label>Foto</label><span id="previa_foto"></span>
              <input type="file" id="nuevo_foto" name="nuevo_foto" class="form-control" accept=".jpg, .jpeg, .png"><br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Comentarios </label>
              <textarea name="nuevo_comentarios" id="nuevo_comentarios" class="form-control" rows="2"></textarea>
              <br>
            </div>
          </div>
          <div id="msj_error" class="alert alert-danger hidden"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="btnRegistro" onclick="guardarDoping()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="pendientesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Solicitudes de doping pendientes</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-11 text-center" id="parametros">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label>Fecha de nacimiento *</label>
            <input type="text" class="form-control dop_obligado tipo_fecha" name="fecha_nacimiento" id="fecha_nacimiento">
            <br>
          </div>
          <div class="col-md-4">
            <label>Tipo identificación *</label>
            <select name="identificacion" id="identificacion" class="form-control dop_obligado">
              <option value="">Selecciona</option>
              <?php
              foreach ($identificaciones as $ide) { ?>
                <option value="<?php echo $ide->id; ?>"><?php echo $ide->nombre; ?></option>
              <?php }
              ?>
            </select>
            <br>
          </div>
          <div class="col-md-4">
            <label>Número, licencia o código *</label>
            <input type="text" class="form-control dop_obligado" name="ine" id="ine">
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label>Razón *</label>
            <select name="razon" id="razon" class="form-control dop_obligado">
              <option value="">Selecciona</option>
              <option value="1">Nuevo ingreso</option>
              <option value="2">Aleatorio</option>
              <option value="3">Actualización</option>
            </select>
            <br>
          </div>
          <div class="col-md-4">
            <label>Fecha de doping *</label>
            <input type="text" class="form-control dop_obligado tipo_fecha_hora" name="fecha_doping" id="fecha_doping">
            <br>
          </div>
          <div class="col-md-4">
            <label>¿Este examen es foráneo (fuera de GDL)? *</label>
            <select name="foraneo" id="foraneo" class="form-control nuevo_obligado">
              <option value="">Selecciona</option>
              <option value="NO">NO</option>
              <option value="SI">SI</option>
            </select>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <label>Medicamentos recetados * </label>
            <textarea name="medicamentos" id="medicamentos" class="form-control dop_obligado" rows="2"></textarea>
            <br>
          </div>
          <div class="col-md-6">
            <label>Foto</label>
            <input type="file" id="foto" name="foto" class="form-control" accept=".jpg, .jpeg, .png"><br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label>Comentarios </label>
            <textarea name="comentarios" id="comentarios" class="form-control" rows="2"></textarea>
            <br>
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="registrarPendiente()">Registrar</button>
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
<div class="modal fade" id="resultadosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Resultados del examen antidoping</h4>
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
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <label>Fecha resultado *</label>
            <input type="text" class="form-control sust_obligado tipo_fecha_hora" name="nuevo_fecha_resultado" id="nuevo_fecha_resultado" placeholder="dd/mm/yyyy hh:mm"><br><br>
          </div>
        </div>
        <form id="results">
          <div id="div_resultados"></div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="registrarResultados()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="quitarModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titulo_accion"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="" id="texto_confirmacion"></p><br>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="btnGuardar" onclick="ejecutarAccion()">Aceptar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="eliminadosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Examenes antidoping eliminados</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="div_eliminados">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="labModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Laboratorio del examen de antidoping</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-left" id="lab_nombre_candidato"></p><br>
        <select name="opcion_laboratorio" id="opcion_laboratorio" class="form-control">
          <option value="GUADALAJARA">GUADALAJARA</option>
          <option value="LAPI">LAPI</option>
        </select>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="actualizarLab()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<script>
  $("#nuevoModal").on("hidden.bs.modal", function() {
    $("#nuevoModal input, #nuevoModal select, textarea").val("");
    $("#nuevoModal #msj_error").css('display', 'none');
    $("#previa_foto").empty();
    $("#subcliente, #paquete, #proyecto").prop('disabled', true);
  });
  $("#pendientesModal").on("hidden.bs.modal", function() {
    $("#pendientesModal input, #pendientesModal select, #pendientesModal textarea").val("");
    $("#candidato").val('').trigger('change');
    $("#parametros").empty();
    $("#pendientesModal #msj_error").css('display', 'none');
  });
  $("#quitarModal").on("hidden.bs.modal", function() {
    $("#quitarModal #msj_error").css('display', 'none');
    $("#quitarModal textarea").val('');
  });
  $("#resultadosModal").on("hidden.bs.modal", function() {
    $("#resultadosModal input").val('');
    $("#div_resultados").empty();
    $("#resultadosModal #msj_error").css('display', 'none');
  });
</script>