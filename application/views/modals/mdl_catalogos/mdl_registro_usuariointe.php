<div class="modal fade" id="nuevoAccesoUsuariosInternos" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  id="titulo_nuevo_modal">Registro de usuarios internos *</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span>&times;</span> 
        </button>
      </div>

      <div class="tab-content">
          <!--***Pestaña Nuevo*****-->
          <div class="modal-body">
            <form id="formAccesoUsuariosinternos">
            <div class="row">
           
            <div class="col-md-4">
              <label>Nombre *</label>
              <input type="text" class="form-control" name="nombre" id="nombre" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Apellido Paterno *</label>
              <input type="text" class="form-control" name="paterno" id="paterno" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Tipo de rol *</label>
              <select class="form-control" id="id_rol" name="id_rol">
               <option value="">Selecciona un rol</option>
               <option value="1">Administrador</option>
               <option value="6">Gerente</option>
               <option value="6">RRHH</option>
                <option value="4">Reclutadora</option>
                <option value="11">Coordinador  reclutamiento </option>
                <option value="13">Visor</option>
              </select>
              <br>
            </div>
          </div> 
          <div class="row">
           
            <div class="col-6">
            <label for="telefono">Telefono *</label>
              <input type="text" class="form-control" name="telefono" id="telefono">
              <br>
            </div>
            <div class="col-6">
              <label>Correo *</label>
              <input type="text" class="form-control" name="correo" id="correo">
              <br>
            </div>
          </div>
          <div class="row">
           
          </div>
              <div class="row">
                 <div class="col-md-3"  id="divGenerarPassword">
                   <label>Da click</label>
                      <button type="button" class="btn btn-primary" onclick="generarPassword()">Generar contraseña</button>
                      <br>
                </div>

                <input type="hidden" class="form-control" name="idUsuarioInterno" id="idUsuarioInterno" >
                <input type="hidden" class="form-control" name="idDatosGenerales" id="idDatosGenerales" >

                <div class="col-md-6" id="labelOcultar">
                 <label>Contraseña *</label>
                   <input type="text" class="form-control" name="password1" id="password1" maxlength="8" readonly>
                    <br>
                 </div>

               </div>
            </form>
         </div>
            <div class="row" id="ocultar-en-editar">
               <div class="col-md-12">
                 <p>* Copia la contraseña para enviarla, ya que al no hacerlo se tendrá que generar una nueva</p>
                </div>
             </div>

             <div id="msj_error" class="alert alert-danger hidden"></div>
     </div> <!--/**cierre de tab-content***/ -->

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="btnGuardar" type="button" class="btn btn-success" >Guardar</button>
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


  