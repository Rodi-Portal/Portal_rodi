<div class="modal fade" id="privacidadModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Privacidad del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formPrivacidad">
          <div class="row">
            <div class="col-12">
            <label>Selecciona el tipo de privacidad *</label>
            <select class="form-control" id="candidato_privacidad" name="candidato_privacidad">
              <option value="0">Sin privacidad (Visible para usuarios/clientes sin privacidad y Nivel 1)</option>
              <option value="1">Nivel 1 (Visibilidad total de los candidatos)</option>
              <option value="2">Nivel 2 (Visibilidad de candidatos Nivel 2 y Nivel 1) </option>
              <option value="3">Nivel 3 (Visibilidad de candidatos Nivel 3 y Nivel 1)</option>
              <option value="4">Nivel 4 (Visibilidad de candidatos Nivel 4 y Nivel 1)</option>
              <option value="5">Nivel 5 (Visibilidad de candidatos Nivel 5 y Nivel 1)</option>
              <option value="6">Nivel 6 (Visibilidad de candidatos Nivel 6 y Nivel 1)</option>
              <option value="7">Nivel 7 (Visibilidad de candidatos Nivel 7 y Nivel 1)</option>
              <option value="8">Nivel 8 (Visibilidad de candidatos Nivel 8 y Nivel 1)</option>
              <option value="9">Nivel 9 (Visibilidad de candidatos Nivel 9 y Nivel 1)</option>
              <option value="10">Nivel 10 (Visibilidad de candidatos Nivel 10 y Nivel 1)</option>
            </select>
            <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarPrivacidad()">Guardar</button>
      </div>
    </div>
  </div>
</div>