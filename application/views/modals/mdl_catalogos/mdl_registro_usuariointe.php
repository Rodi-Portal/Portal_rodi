<div class="modal fade" id="nuevoAccesoUsuariosInternos" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="titulo_nuevo_modal">
          <?php echo $this->lang->line('admin_users_modal_new_title'); ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>

      <div class="tab-content">
        <div class="modal-body">
          <form id="formAccesoUsuariosinternos">

            <div class="row">
              <div class="col-md-4">
                <label><?php echo $this->lang->line('admin_users_modal_firstname'); ?></label>
                <input type="text" class="form-control" name="nombreUsuarioInterno"
                       id="nombreUsuarioInterno"
                       onkeyup="this.value=this.value.toUpperCase()">
                <br>
              </div>

              <div class="col-md-4">
                <label><?php echo $this->lang->line('admin_users_modal_lastname'); ?></label>
                <input type="text" class="form-control" name="paternoUsuarioInterno"
                       id="paternoUsuarioInterno"
                       onkeyup="this.value=this.value.toUpperCase()">
                <br>
              </div>

              <div class="col-md-4">
                <label><?php echo $this->lang->line('admin_users_modal_role'); ?></label>
                <select class="form-control" id="id_rolUsuarioInterno" name="id_rolUsuarioInterno">
                  <option value=""><?php echo $this->lang->line('admin_users_modal_select_role'); ?></option>
                  <option value="6">Administrador</option>
                  <option value="9">Gerente</option>
                  <option value="10">RRHH</option>
                  <option value="4">Reclutadora</option>
                  <option value="11">Coordinador reclutamiento</option>
                  <option value="13">Visor</option>
                </select>
                <input type="hidden" id="id_rolUsuarioInterno_hidden" name="id_rolUsuarioInterno">
                <br>
              </div>
            </div>

            <div class="row">
              <div class="col-6">
                <label><?php echo $this->lang->line('admin_users_modal_phone'); ?></label>
                <input type="text" class="form-control" name="telefonoUsuarioInterno" id="telefonoUsuarioInterno">
                <br>
              </div>

              <div class="col-6">
                <label><?php echo $this->lang->line('admin_users_modal_email'); ?></label>
                <input type="text" class="form-control" name="correoUsuarioInterno" id="correoUsuarioInterno">
                <br>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3" id="divGenerarPassword">
                <label><?php echo $this->lang->line('admin_users_modal_click'); ?></label>
                <button type="button" class="btn btn-primary" onclick="generarPassword()">
                  <?php echo $this->lang->line('admin_users_modal_generate_password'); ?>
                </button>
              </div>

              <input type="hidden" name="idUsuarioInterno" id="idUsuarioInterno">
              <input type="hidden" name="idDatosGenerales" id="idDatosGenerales">

              <div class="col-md-6" id="labelOcultar">
                <label><?php echo $this->lang->line('admin_users_modal_password'); ?></label>
                <input type="text" class="form-control" name="password1" id="password1" maxlength="8" readonly>
              </div>
            </div>

          </form>
        </div>

        <div class="row" id="ocultar-en-editar">
          <div class="col-md-12">
            <p><?php echo $this->lang->line('admin_users_modal_copy_warning'); ?></p>
          </div>
        </div>

        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?php echo $this->lang->line('admin_users_modal_btn_close'); ?>
        </button>

        <button id="btnGuardar" type="button" class="btn btn-success">
          <?php echo $this->lang->line('admin_users_modal_btn_save'); ?>
        </button>
      </div>

    </div>
  </div>
</div>





<!-- Modal de Confirmación  para los botones de tipos de  Acciones-->
<div class="modal fade" id="mensajeModal" tabindex="-1" role="dialog" aria-labelledby="mensajeModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_mensaje"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span >&times;</span>
        </button>
      </div>
      <div class="modal-body" id="mensaje"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="btnConfirmar">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<!-------------------------------------------------------->



<script>

  $("#accesoModal").on("hidden.bs.modal", function() {
    $("#accesoModal input, #accesoModal select").val("");
    $("#accesoModal #id_rol").val(0);
    $("#accesoModal input").removeClass("requerido");
    $("#accesoModal #msj_error").css('display', 'none');
    $("#idusuario").val("");
     // Habilitar los elementos fuera del modal
   

  });
  $("#editarModal").on("hidden.bs.modal", function() {
    $("#editarModalinput").val("");
    $("#editarModal #msj_error").css('display', 'none');
    $("#titulo_editar_modal").text("Nuevo Usuario");
    // Habilitar los elementos fuera del modal

  }); 

</script>


  