<div class="modal fade" id="newModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titulo_modal_sanguineo">Registro de paciente</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_registro">
          <div class="row mb-3">
            <div class="col-4">
              <label>Nombre(s) *</label><br>
              <input class="form-control" type="text" name="nombre_sanguineo" id="nombre_sanguineo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
            <div class="col-4">
              <label>Primer apellido *</label><br>
              <input class="form-control" type="text" name="paterno_sanguineo" id="paterno_sanguineo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
            <div class="col-4">
              <label>Segundo apellido </label><br>
              <input class="form-control" type="text" name="materno_sanguineo" id="materno_sanguineo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-4">
              <label>Genero *</label><br>
              <select name="genero_sanguineo" id="genero_sanguineo" class="form-control">
                <option value="">Selecciona</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select>
            </div>
            <div class="col-4">
              <label>Fecha de nacimiento *</label><br>
              <input class="form-control tipo_fecha" type="text" name="fecha_nacimiento_sanguineo" id="fecha_nacimiento_sanguineo" placeholder="dd/mm/yyyy">
            </div>
            <div class="col-4">
              <label>Fecha de toma *</label><br>
              <input class="form-control tipo_fecha_hora" type="text" name="fecha_toma_sanguineo" id="fecha_toma_sanguineo" placeholder="dd/mm/yyyy hh:mm">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-4">
              <label>Método a utilizar *</label><br>
              <input class="form-control" type="text" name="metodo_sanguineo" id="metodo_sanguineo" value="AGLUTINACIÓN">
            </div>
            <div class="col-4">
              <label>Dirigido a *</label><br>
              <input class="form-control" type="text" name="medico_sanguineo" id="medico_sanguineo" value="A QUIEN CORRESPONDA">
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="nuevoRegistro()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="resultadosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Registro de resultados de: <br><span class="nombrePaciente"></span> </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="resultados_grupo_sanguineo">
          <div class="row">
            <div class="col-md-12">
              <label>Grupo sanguíneo *</label>
              <select class="form-control" name="grupo_sanguineo" id="grupo_sanguineo">
                <option value="">Selecciona</option>
                <?php 
                foreach($grupos_sanguineos as $row){ ?>
                  <option value="<?php echo $row->nombre ?>"><?php echo $row->nombre ?></option>
                <?php
                }
                ?>
              </select>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert  alert-danger hidden msj_error"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarResultados()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="mensajeModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titulo_mensaje"></h4>
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
  $("#newModal").on("hidden.bs.modal", function() {
    $("#newModal input, #newModal select").val('');
    $('#metodo_sanguineo').val('AGLUTINACIÓN')
    $('#medico_sanguineo').val('A QUIEN CORRESPONDA')
    $("#newModal #msj_error").css('display', 'none');
    $('#titulo_modal_sanguineo').text('Registrar paciente ')
    $('#newModal .nombrePaciente').text('')
    $('#idAnalisis').val('')
    $('#idPaciente').val('')
  });
  $("#resultadosModal").on("hidden.bs.modal", function() {
    $("#resultadosModal select").val('');
    $("#resultadosModal #msj_error").css('display', 'none');
    $('#idAnalisis').val('')
    $('#idPaciente').val('')
  });
  $('#mensajeModal').on('hidden.bs.modal', function(e) {
    $("#mensajeModal #titulo_mensaje, #mensajeModal #mensaje").text('');
    $("#mensajeModal #btnConfirmar").removeAttr('onclick');
  });
</script>
