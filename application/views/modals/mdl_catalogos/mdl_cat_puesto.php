<div class="modal fade" id="newModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar puesto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_puesto" onkeydown="return event.key != 'Enter';">
          <div class="row">
            <div class="col-md-12">
              <label for="nombre">Nombre *</label>
              <input type="text" class="form-control obligado" name="nombre" id="nombre">
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="btnGuardar" value="nuevo">Guardar</button>
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
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="accion" onclick="ejecutarAccion()">Aceptar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="importarcsvModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Importar puestos por csv</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formImportarPuestos">
          <div class="row">
            <div class="col-12">
              <label>Selecciona el archivo <code>.csv</code> </label>
              <input type="file" class="form-control" name="archivo_csv" id="archivo_csv" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="importarCSV()">Importar</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#newModal').on('shown.bs.modal', function () {
    $(this).find('input[type=text],select,textarea').filter(':visible:first').focus();
  });
  $("#newModal").on("hidden.bs.modal", function(){
    $("#newModal input").val("");
    $("#msj_error").css('display','none');
    $("#idPuesto").val("");
    $("#guardar").attr('value','nuevo');
  });
  $("#importarcsvModal").on("hidden.bs.modal", function(){
    $("#importarcsvModal input").val("");
    $("#importarcsvModal #msj_error").css('display','none');
  });
</script>