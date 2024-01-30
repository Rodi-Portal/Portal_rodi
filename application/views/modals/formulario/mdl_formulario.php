<div class="modal fade" id="formModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titleForm"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="dataForm">
          <div class="row" id="rowForm"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnSubmitForm">Guardar</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    $('#formModal').on('hidden.bs.modal', function(e) {
      $("#rowForm").empty();
    });
  })
</script>