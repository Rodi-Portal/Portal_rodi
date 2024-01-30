<!-- <div class="modal fade" id="perfilUsuarioModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info text-center">User data</div>
        <form id="datos">
          <div class="row">
            <div class="col-6">
              <label>Name *</label>
              <input type="text" class="form-control" name="usuario_nombre" id="usuario_nombre">
              <br>
            </div>
            <div class="col-6">
              <label>First lastname *</label>
              <input type="text" class="form-control" name="usuario_paterno" id="usuario_paterno">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <label>Email *</label>
              <input type="email" class="form-control" name="usuario_correo" id="usuario_correo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
              <br>
            </div>
            <div class="col-6">
              <label>New password</label>
              <input type="password" class="form-control" name="usuario_nuevo_password" id="usuario_nuevo_password">
              <br>
            </div>
          </div>
          <div class="alert alert-info text-center">Configurations</div>
          <div class="row">
            <div class="col-6">
              <label>key</label>
              <input type="text" class="form-control" name="usuario_key" id="usuario_key" maxlength="16">
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="confirmarPassword()">Save</button>
      </div>
    </div>
  </div>
</div> -->
<div class="modal fade" id="confirmarPasswordModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Confirm password</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3>Please type your current password:</h3><br>
        <div class="row">
          <div class="col-12">
            <input type="password" class="form-control" id="password_actual" name="password_actual">
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="checkPasswordActual()">Accept</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="recuperarPasswordModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Password recovery</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3>Email:</h3><br>
        <div class="row">
          <div class="col-12">
            <input type="password" class="form-control" id="password_actual" name="password_actual">
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="checkPasswordActual()">Accept</button>
      </div>
    </div>
  </div>
</div>