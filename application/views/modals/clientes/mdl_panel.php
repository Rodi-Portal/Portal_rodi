<div class="modal fade" id="avancesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo $translations['titulo_modal_avances'] ?><br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="div_avances" class="escrolable"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="historialComentariosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Historial de comentarios con respecto a: <br><span class="nombreRegistro" id="nombre_aspirante"></span></h4>
       
      </div>
      <div class="modal-body">
        <div id="div_historial_comentario" class="escrolable"></div>
        <hr>
        <div class="row">
          <div class="col-12">
            <label for="comentario_bolsa">Registra un nuevo comentario o estatus *</label>
            <textarea class="form-control" name="comentario_bolsa" id="comentario_bolsa" rows="3"></textarea>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-12">
            <button type="button" class="btn btn-primary text-lg btn-block w-100" id="btnComentario">Guardar
              comentario</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>