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
<div class="modal fade" id="avancesModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<h4 class="modal-title">Progress messages:</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					
					</button>
				</div>
				<div class="modal-body">
					
					<ul class="nav nav-tabs" id="modalTabs">
						<li class="nav-item">
							<a class="nav-link active" id="pestaña1-tab" data-toggle="tab" href="#pestaña1">BGV comments:</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pestaña2-tab" data-toggle="tab" href="#pestaña2">Drug Test comments:</a>
						</li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane fade show active" id="pestaña1">
							<p class="" id="comentario_candidato_p1"></p><br>
							<h4>BGV <h4>
							<div class="modal-body">
								
								<div id="div_avances_bgv">

								</div>
							</div>						
						</div>
						<div class="tab-pane fade" id="pestaña2">
							<p class="" id="comentario_candidato_p2"></p><br>
							<h4>Drug Test <h4>
								<div class="modal-body">
									<div id="div_avances_dop">

									</div>
								</div>	
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

  <div class="modal fade" id="statusModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Candidate Status: <br><span class="nombreCandidato"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          </button>
        </div>
        <div class="modal-body">
          <div id="div_status"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="docsModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Documentación del candidato: <span class="nombreCandidato"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div id="tablaDocs" class="text-center"></div><br><br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 text-center">
              <label>Selecciona el documento</label><br>
              <input type="file" id="documento" class="doc_obligado" name="documento" accept=".jpg, .png, .jpeg, .pdf"><br><br>
              <br>
            </div>
            <div class="col-md-6 text-center">
              <label>Tipo de archivo *</label>
              <select name="tipo_archivo" id="tipo_archivo" class="form-control personal_obligado">
                <option value="">Selecciona</option>
                <?php 
                foreach ($tipos_docs as $t) {
                  if($t->id == 3 || $t->id == 8 || $t->id == 9 || $t->id == 14 || $t->id == 45){ ?>
                    <option value="<?php echo $t->id; ?>"><?php echo $t->nombre; ?></option>
                <?php 
                  }
                } ?>
              </select>
              <br>
            </div>
          </div>
          <div id="msj_error" class="alert alert-danger hidden"></div>
        </div>
        <div class="modal-footer">
          <!--form method="POST" action="< ?php echo base_url('Candidato/downloadDocumentosPanelCliente'); ?>">
            

            <button type="submit" class="btn btn-primary">Descargar todos los documentos</button>
          </form -->
          <input type="hidden" id="idCandidatoDocs" name="idCandidatoDocs">
            <input type="hidden" id="nameCandidato" name="nameCandidato" class="nombreCandidato">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success" onclick="subirDoc()">Subir</button>
        </div>
      </div>
    </div>
  </div>