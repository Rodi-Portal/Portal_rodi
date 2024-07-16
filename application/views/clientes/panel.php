<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>TalentSafe-Control</title>

</head>

<body>
  <div class="modal fade" id="newModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New Candidate</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-info text-center">Candidate's General Data</div>
          <form id="datos">
            <div class="row">
              <div class="col-md-4">
                <label>Name *</label>
                <input type="text" class="form-control registro_obligado" name="nombre_registro" id="nombre_registro"
                  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                <br>
              </div>
              <div class="col-md-4">
                <label>First lastname *</label>
                <input type="text" class="form-control registro_obligado" name="paterno_registro" id="paterno_registro"
                  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                <br>
              </div>
              <div class="col-md-4">
                <label>Second lastname </label>
                <input type="text" class="form-control" name="materno_registro" id="materno_registro"
                  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>Email *</label>
                <input type="email" class="form-control registro_obligado" name="correo_registro" id="correo_registro"
                  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
                <br>
              </div>
              <div class="col-md-4">
                <label>Cellphone number *</label>
                <input type="text" class="form-control" name="celular_registro" id="celular_registro" maxlength="16">
                <br>
              </div>
            </div>
            <div class="alert alert-warning text-center">Choose a previous project or create another one. <br>Notes:
              <br>
              <ul class="text-left">
                <li>If you select a previous project, this will have a higher priority for your new register.</li>
                <li>The complementary tests are optional.</li>
              </ul>
            </div>
            <div class="alert alert-info text-center">
              Choose what you want to do
            </div>
            <div class="row">
              <div class="col-12">
                <select name="opcion_registro" id="opcion_registro" class="form-control registro_obligado">
                  <option value="">Select</option>
                  <option value="0">Select a previous project or create a new one</option>
                  <option value="1">Register the candidate with only a Drug Test and/or Medical Test</option>
                </select>
                <br>
              </div>
            </div>
            <div class="alert alert-info text-center div_info_previo">Select a Previous Project</div>
            <div class="row div_previo">
              <div class="col-md-9">
                <label>Previous projects</label>
                <select class="form-control" name="previos" id="previos"></select><br>
              </div>
              <div class="col-md-3">
                <label>Country</label>
                <select class="form-control" name="pais_previo" id="pais_previo" disabled></select><br>
              </div>
            </div>
            <div id="detalles_previo"></div>
            <div class="alert alert-info text-center div_info_project">Select a New Project</div>
            <div class="row div_project">
              <div class="col-md-4">
                <label>Location *</label>
                <select name="region" id="region" class="form-control registro_obligado">
                  <option value="">Select</option>
                  <option value="Mexico">Mexico</option>
                  <option value="International">International</option>
                </select>
                <br>
              </div>
              <div class="col-md-4">
                <label>Country</label>
                <select name="pais_registro" id="pais_registro" class="form-control registro_obligado" disabled>
                  <option value="">Select</option>
                  <?php
foreach ($paises_estudio as $pe) {?>
                  <option value="<?php echo $pe->nombre_espanol; ?>"><?php echo $pe->nombre_ingles; ?></option>
                  <?php
}?>
                </select>
                <br>
              </div>
              <div class="col-md-4">
                <label>Project name *</label>
                <input type="text" class="form-control" name="proyecto_registro" id="proyecto_registro" disabled>
                <br>
              </div>
            </div>
            <div class="alert alert-info text-center div_info_check">
              Required Information for the New Project<br>Note:<br>
              <ul class="text-left">
                <li>The required documents will add automatically depending of the selected options . The extra
                  documents are optional, select them before the complementary tests.</li>
              </ul>
            </div>
            <div class="row div_check">
              <div class="col-md-6">
                <label>Employment history *</label>
                <select name="empleos_registro" id="empleos_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label>Time required</label>
                <select name="empleos_tiempo_registro" id="empleos_tiempo_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
            </div>
            <div class="row div_check">
              <div class="col-md-6">
                <label>Criminal check *</label>
                <select name="criminal_registro" id="criminal_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label>Time required</label>
                <select name="criminal_tiempo_registro" id="criminal_tiempo_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
            </div>
            <div class="row div_check">
              <div class="col-md-6">
                <label>Address history *</label>
                <select name="domicilios_registro" id="domicilios_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label>Time required</label>
                <select name="domicilios_tiempo_registro" id="domicilios_tiempo_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
            </div>
            <div class="row div_check">
              <div class="col-md-6">
                <label>Education check *</label>
                <select name="estudios_registro" id="estudios_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label>Global data searches *</label>
                <select name="global_registro" id="global_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
            </div>
            <div class="row div_check">
              <div class="col-md-6">
                <label>Credit check *</label>
                <select name="credito_registro" id="credito_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label>Time required</label>
                <select name="credito_tiempo_registro" id="credito_tiempo_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
            </div>
            <div class="row div_check">
              <div class="col-md-6">
                <label>Professional References (quantity)</label>
                <input type="number" class="form-control valor_dinamico" id="ref_profesionales_registro"
                  name="ref_profesionales_registro" value="0" disabled>
                <br>
              </div>
              <div class="col-md-6">
                <label>Personal References (quantity)</label>
                <input type="number" class="form-control valor_dinamico" id="ref_personales_registro"
                  name="ref_personales_registro" value="0" disabled>
                <br>
              </div>
            </div>
            <div class="row div_check">
              <div class="col-md-6">
                <label>Identity check *</label>
                <select name="identidad_registro" id="identidad_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label>Migratory form (FM, FM2 or FM3) check *</label>
                <select name="migracion_registro" id="migracion_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
              </div>
            </div>
            <div class="row div_check">
              <div class="col-md-6">
                <label>Prohibited parties list check *</label>
                <select name="prohibited_registro" id="prohibited_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label>Age check *</label>
                <select name="edad_registro" id="edad_registro" class="form-control valor_dinamico registro_obligado"
                  disabled></select>
                <br>
              </div>
            </div>
            <div class="row div_check">
              <div class="col-md-6">
                <label>Academic References (quantity)</label>
                <input type="number" class="form-control valor_dinamico" id="ref_academicas_registro"
                  name="ref_academicas_registro" value="0" disabled>
                <br>
              </div>
              <div class="col-md-6">
                <label>Motor Vehicle Records (only in some Mexico cities) *</label>
                <select name="mvr_registro" id="mvr_registro" class="form-control valor_dinamico registro_obligado"
                  disabled></select>
                <br>
              </div>
            </div>
            <div class="alert alert-danger text-center div_info_extra">Extra documents</div>
            <div class="row div_extra">
              <div class="col-12">
                <label>Select the extra documents *</label>
                <select name="extra_registro" id="extra_registro" class="form-control registro_obligado">
                  <option value="">Select</option>
                  <option value="37">Driving licence</option>
                  <option value="15">Military document</option>
                  <option value="14">Passport</option>
                  <option value="10">Professional licence / Professional Accreditation</option>
                  <option value="16">Resume</option>
                  <option value="42">Sex offender registry</option>
                  <option value="6">Social Security Number</option>
                </select>
                <br>
              </div>
            </div>
            <div class="row">
              <div id="div_docs_extras" class="col-12 d-flex flex-column mb-3">
              </div>
            </div>
            <div class="alert alert-danger text-center div_info_test">Complementary Tests</div>
            <div class="row div_test">
              <div class="col-md-6">
                <label>Drug test *</label>
                <select name="examen_registro" id="examen_registro" class="form-control registro_obligado">
                  <option value="">Select</option>
                  <option value="0" selected>N/A</option>
                  <?php
foreach ($paquetes_antidoping as $paq) {?>
                  <option value="<?php echo $paq->id; ?>"><?php echo $paq->nombre . ' (' . $paq->conjunto . ')'; ?>
                  </option>
                  <?php
}?>
                </select>
                <br>
              </div>
              <div class="col-md-6">
                <label>Medical test *</label>
                <select name="examen_medico" id="examen_medico" class="form-control registro_obligado">
                  <option value="0">N/A</option>
                  <option value="1">Apply</option>
                </select>
                <br>
              </div>
            </div>
          </form>
          <div id="msj_error" class="alert alert-danger hidden"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-success" onclick="registrar()">Save</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="passModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Access credentials sent to the candidate</h5>
        </div>
        <div class="modal-body">
          <p><b>Email: </b><span id="user"></span></p>
          <p id="respuesta_mail"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="quitarModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="titulo_accion"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="" id="texto_confirmacion"></p><br>
          <div class="row" id="div_commentario">
            <div class="col-md-12">
              <label for="motivo">Type the reason *</label>
              <textarea name="motivo" id="motivo" class="form-control" rows="3"></textarea>
              <br>
            </div>
          </div>
          <div class="msj_error">
            <p id="msg_accion"></p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" id="btnGuardar" onclick="ejecutarAccion()">Accept</button>
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
            <span aria-hidden="true">&times;</span>
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
  <div class="modal fade" id="avancesModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Progress messages: <br><span class="nombreCandidato"></span></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="div_avances"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="verModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Candidate comments</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="" id="comentario_candidato"></p><br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="documentosModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Candidate documents</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="lista_documentos"></p><br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="ofacModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">OFAC and OIG Verifications</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4 offset-md-1">
              <p class="text-center"><b>Candidate name</b></p>
              <p class="text-center" id="ofac_nombrecandidato"></p>
            </div>
            <div class="col-md-4 offset-md-2">
              <p class="text-center" id="fecha_titulo_ofac"><b></b></p>
              <p class="text-center" id="fecha_estatus_ofac"></p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 borde_gris">
              <p id="estatus_ofac"></p><br>
              <span id="res_ofac"></span>
              <br><br>
            </div>
            <div class="col-md-6">
              <p id="estatus_oig"></p><br>
              <span id="res_oig"></span>
              <br><br>
            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="perfilUsuarioModal" role="dialog" data-backdrop="static" data-keyboard="false">
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
                <input type="email" class="form-control" name="usuario_correo" id="usuario_correo"
                  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
                <br>
              </div>
              <div class="col-6">
                <label>New password</label>
                <input type="password" class="form-control" name="usuario_nuevo_password" id="usuario_nuevo_password">
                <br>
              </div>
            </div>
            <!--div class="text-center mt-3 mb-3">
							<a href="#" onclick="confirmarRecuperarPassword()">Forgot yout password?</a>
						</div-->
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
  </div>
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
  <div class="modal fade" id="aviso2Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <div class="mt-5">
            <div class="alert alert-warning text-center" role="alert">
              <h3>Some improvements have been implemented</h3>
            </div>
            <div class="text-center mt-3">
              <img src="<?php echo base_url() ?>img/cambios_perfil.svg" width="400" height="300">
            </div>
            <div class="text-left">
              <p>We have added a new list item about edit profile: <br><br><img
                  src="<?php echo base_url() ?>img/referencias/5.png" width="700"></p>
              <p>In this new feature you can change your basic data and your credentials to access to this platform.</p>
              <p>Consider the following: </p>
              <ul>
                <li>If you desire to change the current password, type it on new password field. If the new password
                  field is empty, the password will not change.</li>
                <li>You can register a key in the section of configurations. This key will use to decode the BGV reports
                  in the future as a security way</li>
                <li>The security feature mentioned before will be implemented soon. <img
                    src="<?php echo base_url() ?>img/referencias/4.png" width="700"></li><br>
                <li>For to apply the changes you must type your current password. <img
                    src="<?php echo base_url() ?>img/referencias/6.png" width="700"></li>
              </ul>
              <br>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="avisoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <div class="mt-5">
            <div class="alert alert-warning text-center" role="alert">
              <h3>Some improvements have been implemented</h3>
            </div>
            <div class="text-center mt-3">
              <img src="<?php echo base_url() ?>img/cambios_perfil.svg" width="400" height="300">
            </div>

          </div>
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
              <input type="file" id="documento" class="doc_obligado" name="documento"
                accept=".jpg, .png, .jpeg, .pdf"><br><br>
              <br>
            </div>
            <div class="col-md-6 text-center">
              <label>Tipo de archivo *</label>
              <select name="tipo_archivo" id="tipo_archivo" class="form-control personal_obligado">
                <option value="">Selecciona</option>
                <?php
foreach ($tipos_docs as $t) {
    if ($t->id == 3 || $t->id == 8 || $t->id == 9 || $t->id == 14 || $t->id == 45) {?>
                <option value="<?php echo $t->id; ?>"><?php echo $t->nombre; ?></option>
                <?php }
}?>
              </select>
              <br>
            </div>
          </div>
          <div id="msj_error" class="alert alert-danger hidden"></div>
        </div>
        <div class="modal-footer">
          <form method="POST" action="<?php echo base_url('Candidato/downloadDocumentosPanelCliente'); ?>">
            <input type="hidden" id="idCandidatoDocs" name="idCandidatoDocs">
            <button type="submit" class="btn btn-primary">Descargar todos los documentos</button>
          </form>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success" onclick="subirDoc()">Subir</button>
        </div>
      </div>
    </div>
  </div>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-light font-weight-bold" href="javascript:void(0)" onclick="nuevoRegistro()"><i
                class="fas fa-plus-circle"></i> New candidate</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light font-weight-bold" href="javascript:void(0)" onclick="editarPerfil()"><i
                class="fas fa-user"></i> Edit profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light font-weight-bold" href="<?php echo base_url(); ?>Login/logout">
              <i class="fas fa-sign-out-alt">
              </i> Logout</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <div class="loader" style="display: none;"></div>
  <input type="hidden" id="idCandidato">
  <input type="hidden" id="idSeccion">
  <input type="hidden" id="idCliente">
  <input type="hidden" id="idDoping">
  <input type="hidden" class="prefijo">
  <input type="hidden" id="idFinalizado">
  <input type="hidden" id="idVecinal">
  <input type="hidden" id="numVecinal">
  <input type="hidden" id="referenciaNumero">
  <input type="hidden" id="idRef">
  <input type="hidden" id="idFamiliar">
  <input type="hidden" id="tokenForm">


  <div id="listado">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="tabla" class="table table-hover table-bordered" id="dataTable" width="100%" cellspacing="0">


          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- jQuery -->
 

  <!-- Bootstrap JS Bundle -->
  <!--script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
  </script>

  -- DataTables JS >
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.js"></script>

  <-- SweetAlert 2 JS ->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>

  <!-- InputMask JS -->
  <script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.js"></script>
  <script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.extensions.js"></script>



  <script>
  function finishSession() {
    let timerInterval;
    setTimeout(() => {
      Swal.fire({
        title: 'Do you want to keep your session?',
        showClass: {
          popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp'
        },
        html: 'Your session will end in <strong></strong> seconds<br/><br/>',
        showDenyButton: true,
        confirmButtonText: 'Keep me logged in',
        denyButtonText: 'Logout',
        timer: 30000,
        timerProgressBar: true,
        didOpen: () => {
          //Swal.showLoading(),
          timerInterval = setInterval(() => {
            Swal.getHtmlContainer().querySelector('strong')
              .textContent = (Swal.getTimerLeft() / 1000)
              .toFixed(0)
          }, 100)
        },
        willClose: () => {
          clearInterval(timerInterval)
        },
        allowOutsideClick: false
      }).then((result) => {
        if (result.isConfirmed) {
          finishSession();
        } else if (result.isDenied || result.dismiss === Swal.DismissReason.timer) {
          fetch('<?php echo base_url('Login/logout'); ?>')
            .then(response => {
              return location.reload()
            })
        }
      })
    }, 7200000);
  }
  finishSession();

  var id = '<?php echo $this->session->userdata('id')?>';
  var id_cliente1 = '<?php echo $this->session->userdata('idcliente')?>';
  console.log("🚀 ~ id_cliente1:", id_cliente1)


  var urlFiltrada = '<?php echo API_URL ?>candidato-sync/' + id_cliente1;
  var psico = '<?php echo base_url(); ?>_psicometria/';
  var beca_url = '<?php echo base_url(); ?>_beca/';
  let url_form = '<?php echo base_url() . "Form/external?fid="; ?>';
  //var parentescos_php ='< ?php foreach($parentescos as $p){ echo '<option value="'.$p->id.'">'.$p->nombre.'</option>';} ?>';

  //var escolaridades_php ='< ?php foreach($escolaridades as $e){ echo '<option value="'.$e->id.'">'.$e->nombre.'</option>';} ?>';

  var extras = [];
  $(document).ready(function() {
    $('.tipo_fecha').inputmask('dd/mm/yyyy', {
      'placeholder': 'dd/mm/yyyy'
    });
    $('#fecha_ine').inputmask('yyyy', {
      'placeholder': 'yyyy'
    });
    // Smooth scrolling using jQuery easing
    $(document).on('click', 'a.ripple', function(e) {
      var $anchor = $(this);
      $('html, body').stop().animate({
        scrollTop: ($($anchor.attr('href')).offset().top)
      }, 1000, 'easeInOutExpo');
      e.preventDefault();
    });
    var msj = localStorage.getItem("success");
    if (msj == 1) {
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Se ha actualizado correctamente',
        showConfirmButton: false,
        timer: 2500
      })
      localStorage.removeItem("success");
    }
    

		
    $("#subcliente").change(function() {
      var subcliente = $(this).val();
      if (subcliente != "") {
        $('#proceso').prop('disabled', false);
        $('#proceso').empty();
        $('#proceso').append($("<option selected></option>").attr("value", 1).text("ESE Español"));
        $('#antidoping').val('');
        $("#examen").prop('disabled', true);
        $('#examen').val('');
      } else {
        $('#proceso').empty();
        $('#proceso').append($("<option selected></option>").attr("value", "").text("Selecciona"));
        $('#antidoping').val('');
        $('#examen').val('');
        $('#proceso').prop('disabled', true);
        $("#examen").prop('disabled', true);
      }
    });
    $('#antidoping').change(function() {
      var opcion = $(this).val();
      var id_subcliente = $("#subcliente").val();
     
      subcliente = (id_subcliente == '') ? NULL : id_subcliente;
      if (opcion == 1) {
        $("#examen").prop('disabled', false);
        $.ajax({
          url: '<?php echo base_url('Doping/getPaqueteSubcliente'); ?>',
          method: 'POST',
          data: {
            'id_subcliente': subcliente,
            'id_cliente': id_cliente,
            'id_proyecto': 0
          },
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            if (res != "") {
              $('#examen').val(res);
              $("#examen").prop('disabled', false);
              $("#examen").addClass('obligado');
            } else {
              $('#examen').val('');
              $("#examen").prop('disabled', false);
              $("#examen").addClass('obligado');
            }
          }
        });
      } else {
        $("#examen").val('');
        $("#examen").prop('disabled', true);
      }
    })
    $("#previos").change(function() {
      var previo = $(this).val();
      if (previo != 0) {
        //$('.div_check').css('display','none');
        //$('.div_info_check').css('display','none');
        $.ajax({
          url: '<?php echo base_url('Candidato_Seccion/getDetallesProyectoPrevio'); ?>',
          method: 'POST',
          data: {
            'id_previo': previo
          },
          success: function(res) {
            $('#detalles_previo').empty();
            $('#detalles_previo').html(res);
          }
        });
        //TODO: Automatizar el valor dinamico de los examenes doping ligados al proceso
        if (id == 178 || id == 201) {
          $.ajax({
            url: '<?php echo base_url('Doping/getExamenDopingByProceso'); ?>',
            method: 'POST',
            data: {
              'id_previo': previo
            },
            async: false,
            success: function(res) {
              $('#examen_registro').empty();
              $('#examen_registro').html(res);
            }
          });
        }
        //TODO: Automatizar el valor dinamico de los examenes doping ligados al cliente
        if (id == 60 || id == 188 || id == 209 || id == 225 || id == 226 || id == 254 || id ==
          255 || id == 257) {
          $.ajax({
            url: '<?php echo base_url('Doping/getExamenDopingByCliente'); ?>',
            method: 'POST',
            data: {
              'id_cliente': id
            },
            async: false,
            success: function(res) {
              $('#examen_registro').empty();
              $('#examen_registro').html(res);
            }
          });
        }
        // Checa en la tabla cliente_control si el cliente tiene predefinido examenes u otros valores
        $.ajax({
          url: '<?php echo base_url('Cliente/getControlesById'); ?>',
          method: 'POST',
          data: {
            'id_cliente': id
          },
          async: false,
          success: function(res) {
            if (res != null) {
              let data = JSON.parse(res);
              if (data !== null && Object.keys(data).length !== 0) {
                if (data.psicometria == 1) {
                  $('#examen_psicometrico').val(1)
                }
              }
            }
          }
        });
      } else {
        //$('.div_check').css('display','flex');
        //$('.div_info_check').css('display','block');
        $('#detalles_previo').empty();
      }
    });
    $("#estado").change(function() {
      var id_estado = $(this).val();
      if (id_estado != "") {
        $.ajax({
          url: '<?php echo base_url('Funciones/getMunicipios'); ?>',
          method: 'POST',
          data: {
            'id_estado': id_estado
          },
          dataType: "text",
          success: function(res) {
            $('#municipio').prop('disabled', false);
            $('#municipio').html(res);
          }
        });
      } else {
        $('#municipio').prop('disabled', true);
        $('#municipio').append($("<option selected></option>").attr("value", "").text(
          "Selecciona"));
      }
    });
    $('[data-toggle="tooltip"]').tooltip();
    $(".aplicar_todo").change(function() {
      var id = $(this).attr('id');
      var aux = id.split('aplicar_todo');
      var num = aux[1];
      var valor = $('#' + id).val();
      switch (valor) {
        case "-1":
          $(".performance" + num).val("No proporciona");
          break;
        case "0":
          $(".performance" + num).val("No proporciona");
          break;
        case "1":
          $(".performance" + num).val("Excelente");
          break;
        case "2":
          $(".performance" + num).val("Bueno");
          break;
        case "3":
          $(".performance" + num).val("Regular");
          break;
        case "4":
          $(".performance" + num).val("Insuficiente");
          break;
        case "5":
          $(".performance" + num).val("Muy mal");
          break;
      }
    });
    $(".aplicar_all").change(function() {
      var id = $(this).attr('id');
      var aux = id.split('aplicar_all');
      var num = aux[1];
      var valor = $('#' + id).val();
      switch (valor) {
        case "-1":
          $(".caracteristica" + num).val("Not provided");
          break;
        case "0":
          $(".caracteristica" + num).val("Not provided");
          break;
        case "1":
          $(".caracteristica" + num).val("Excellent");
          break;
        case "2":
          $(".caracteristica" + num).val("Good");
          break;
        case "3":
          $(".caracteristica" + num).val("Regular");
          break;
        case "4":
          $(".caracteristica" + num).val("Bad");
          break;
        case "5":
          $(".caracteristica" + num).val("Very Bad");
          break;
      }
    });
    $(".solo_numeros").on("input", function() {
      var valor = $(this).val();
      $(this).val(valor.replace(/[^0-9]/g, ''));
    });
    $("#previos_hcl").change(function() {
      var previo = $(this).val();
      if (previo != 0) {
        $.ajax({
          url: '<?php echo base_url('Candidato/getDetallesProyectoPrevio'); ?>',
          method: 'POST',
          data: {
            'id_previo': previo
          },
          success: function(res) {
            var parte = res.split('@@');
            $('#detalles_previo_hcl').empty();
            $('#detalles_previo_hcl').html(parte[0]);
            $('#pais_previo_hcl').prop('disabled', false);
            $('#pais_previo_hcl').empty();
            $('#pais_previo_hcl').html(parte[1]);
            //$('#pais_previo').append($('<option></option>').attr('value','Mexico').text('Mexico'));
          }
        });
      } else {
        $('#detalles_previo_hcl').empty();
      }
    });
    $("#opcion_registro_hcl").change(function() {
      var opcion = $(this).val();
      $('.div_info_project').css('display', 'block');
      $('.div_project').css('display', 'flex');
      $('.div_info_test').css('display', 'block');
      $('.div_test').css('display', 'flex');
      $("#newModal #msj_error").css('display', 'none');
      if (opcion == 1) {
        $('.div_check_hcl').css('display', 'none');
        $('.div_info_check').css('display', 'none');
        $('.div_info_extra').css('display', 'none');
        $('.div_extra').css('display', 'none');
      }
      if (opcion == 0) {
        $('.div_previo').css('display', 'flex');
        $('.div_info_previo').css('display', 'block');
        $('.div_check_hcl').css('display', 'flex');
        $('.div_info_check').css('display', 'block');
        $('.div_info_extra').css('display', 'block');
        $('.div_extra').css('display', 'flex');
      }
      if (opcion == '') {
        $('.div_previo').css('display', 'none');
        $('.div_info_previo').css('display', 'none');
        $('.div_check_hcl').css('display', 'none');
        $('.div_info_check').css('display', 'none');
        $('.div_info_project').css('display', 'none');
        $('.div_project').css('display', 'none');
        $('.div_info_test').css('display', 'none');
        $('.div_test').css('display', 'none');
        $('.div_info_extra').css('display', 'none');
        $('.div_extra').css('display', 'none');
      }
    });
    $("#region_hcl").change(function() {
      var region = $(this).val();
      if (region != '') {
        $.ajax({
          url: '<?php echo base_url('Candidato/getSeccionesRegion'); ?>',
          method: 'POST',
          data: {
            'region': region
          },
          success: function(res) {
            var secciones = JSON.parse(res);
            $('.valor_dinamico').val('');
            $('.valor_dinamico').empty();
            //$('.valor_dinamico').append($('<option selected></option>').attr('value','').text('Select'));
            $('.valor_dinamico').prop('disabled', false);
            $('#ref_profesionales_registro_hcl').val(0);
            $('#ref_personales_registro_hcl').val(0);
            $('#ref_academicas_registro_hcl').val(0);
            //Distribuye las secciones en su correspondiente select
            for (var i = 0; i < secciones.length; i++) {
              if (secciones[i]['tipo_seccion'] == 'Global Search') {
                $('#global_registro_hcl').append($('<option></option>').attr(
                  'value', secciones[i]['id']).text(secciones[i][
                  'descripcion_ingles'
                ]));
              }
              /*if(secciones[i]['tipo_seccion'] == 'Verificacion Documentos'){
              	$('#identidad_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
              } */
              ////if(secciones[i]['tipo_seccion'] == 'Referencias Laborales'){
              if (secciones[i]['id'] == 16) {
                $('#empleos_registro_hcl').append($('<option></option>').attr(
                  'value', secciones[i]['id']).text(secciones[i][
                  'descripcion_ingles'
                ]));
              }
              //if(secciones[i]['tipo_seccion'] == 'Estudios'){
              if (secciones[i]['id'] == 3) {
                $('#estudios_registro_hcl').append($('<option></option>').attr(
                  'value', secciones[i]['id']).text(secciones[i][
                  'descripcion_ingles'
                ]));
              }
              if (secciones[i]['tipo_seccion'] == 'Domicilios') {
                $('#domicilios_registro_hcl').append($('<option></option>')
                  .attr('value', secciones[i]['id']).text(secciones[i][
                    'descripcion_ingles'
                  ]));
              }
              if (secciones[i]['tipo_seccion'] == 'Credito') {
                $('#credito_registro_hcl').append($('<option></option>').attr(
                  'value', secciones[i]['id']).text(secciones[i][
                  'descripcion_ingles'
                ]));
              }
            }
            //Empleos
            $('#empleos_registro_hcl').append($('<option></option>').attr('value',
              0).attr("selected", "selected").text('N/A'));
            $('#empleos_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '3 years').text('3 years'));
            $('#empleos_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '5 years').text('5 years'));
            $('#empleos_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '7 years').text('7 years'));
            $('#empleos_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '10 years').text('10 years'));
            $('#empleos_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', 'All').text('All'));
            $('#empleos_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '0').attr("selected", "selected").text('N/A'));
            //Criminales
            $('#criminal_registro_hcl').append($('<option></option>').attr('value',
              1).text('Apply'));
            $('#criminal_registro_hcl').append($('<option></option>').attr('value',
              0).attr("selected", "selected").text('N/A'));
            $('#criminal_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '3 years').text('3 years'));
            $('#criminal_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '5 years').text('5 years'));
            $('#criminal_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '7 years').text('7 years'));
            $('#criminal_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '10 years').text('10 years'));
            $('#criminal_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '0').attr("selected", "selected").text('N/A'));
            //Domicilios
            $('#domicilios_registro_hcl').append($('<option></option>').attr(
              'value', 0).attr("selected", "selected").text('N/A'));
            $('#domicilios_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '3 years').text('3 years'));
            $('#domicilios_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '5 years').text('5 years'));
            $('#domicilios_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '7 years').text('7 years'));
            $('#domicilios_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '10 years').text('10 years'));
            $('#domicilios_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '0').attr("selected", "selected").text('N/A'));
            //Credito
            $('#credito_registro_hcl').append($('<option></option>').attr('value',
              0).attr("selected", "selected").text('N/A'));
            $('#credito_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '3 years').text('3 years'));
            $('#credito_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '5 years').text('5 years'));
            $('#credito_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '7 years').text('7 years'));
            $('#credito_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '10 years').text('10 years'));
            $('#credito_tiempo_registro_hcl').append($('<option></option>').attr(
              'value', '0').attr("selected", "selected").text('N/A'));
            //Estudios
            $('#estudios_registro_hcl').append($('<option></option>').attr('value',
              0).attr("selected", "selected").text('N/A'));
            //Identidad
            $('#identidad_registro_hcl').append($('<option></option>').attr('value',
              1).text('Apply'));
            $('#identidad_registro_hcl').append($('<option></option>').attr('value',
              0).attr("selected", "selected").text('N/A'));
            //Globales
            $('#global_registro_hcl').append($('<option></option>').attr('value', 0)
              .attr("selected", "selected").text('N/A'));
            //Migracion
            $('#migracion_registro_hcl').append($('<option></option>').attr('value',
              1).text('Apply'));
            $('#migracion_registro_hcl').append($('<option></option>').attr('value',
              0).attr("selected", "selected").text('N/A'));
            //Prohibited parties list
            $('#prohibited_registro_hcl').append($('<option></option>').attr(
              'value', 1).text('Apply'));
            $('#prohibited_registro_hcl').append($('<option></option>').attr(
              'value', 0).attr("selected", "selected").text('N/A'));
            //Age check
            $('#edad_registro_hcl').append($('<option></option>').attr('value', 1)
              .text('Apply'));
            $('#edad_registro_hcl').append($('<option></option>').attr('value', 0)
              .attr("selected", "selected").text('N/A'));
            //Motor vehicle records
            $('#mvr_registro_hcl').append($('<option></option>').attr('value', 1)
              .text('Apply'));
            $('#mvr_registro_hcl').append($('<option></option>').attr('value', 0)
              .attr("selected", "selected").text('N/A'));
            //CURP
            $('#curp_registro_hcl').append($('<option></option>').attr('value', 1)
              .text('Apply'));
            $('#curp_registro_hcl').append($('<option></option>').attr('value', 0)
              .attr("selected", "selected").text('N/A'));
          }
        });
        if (region == 'International') {
          $('#pais_registro_hcl').prop('disabled', false);
          $('#pais_registro_hcl').val('');
          $('#pais_registr_hclo').find('option[value="México"]').remove()
          $('#mvr_registro_hcl').val(0);
        } else {
          $('#pais_registro_hcl').prop('disabled', true);
          //$('#pais_registro').val('México');
          $('#pais_registro_hcl').append($('<option></option>').attr('value', 'México').attr(
            "selected", "selected").text('Mexico'));
        }
        $('#proyecto_registro_hcl').prop('disabled', false);
      } else {
        $('#pais_registro_hcl').prop('disabled', true);
        $('#pais_registro_hcl').val('');
        $('#proyecto_registro_hcl').prop('disabled', true);
        $('#proyecto_registro_hcl').val('');
        $('.valor_dinamico').val('');
        $('.valor_dinamico').empty();
        $('.valor_dinamico').prop('disabled', true);
        $('#ref_profesionales_registro_hcl').val(0);
        $('#ref_personales_registro_hcl').val(0);
        $('#ref_academicas_registro_hcl').val(0);
      }
    });
    $('#extra_registro_hcl').change(function() {
      var id = $(this).val();
      if (id != '') {
        if (!extras.includes(id)) {
          var txt = $("#extra_registro_hcl option:selected").text();
          extras.push(id);
          //$("#extra_registro option[value='"+id+"']").remove();
          $('#div_docs_extras').append($('<div id="div_extra' + id +
            '" class="extra_agregado mb-1 d-flex justify-content-start"><h5 class="mr-5">Document added: <b>' +
            txt +
            '</b></h5><button type="button" class="btn btn-danger btn-sm" onclick="eliminarExtra(' +
            id + ',\'' + txt + '\')">X</button></div>'));
        }
      }
    })

    changeDatatable(urlFiltrada);
  });
	function changeDatatable(url1) {
  $.ajax({
    url: url1,
    dataType: 'json',

    success: function(data) {
      // Normalizar los datos devueltos para que cada entrada tenga la misma estructura de objeto
      var formattedData = data.map(function(item) {
        // Si el objeto solo contiene algunas propiedades, crear un nuevo objeto con la estructura completa
        if (!item.id) {
          item = {
            id: item.id_candidato_rodi,
            creacion: item.creacion,
            edicion: item.edicion,
            // Agrega otras propiedades necesarias aquí
          };
        }
        return item;
      });


      // Inicializar DataTable con los datos formateados
      $('#tabla').DataTable({
        "pageLength": 10,
        "order": [0, "desc"],
        "stateSave": true,
        "serverSide": false,
        "destroy": true, // Destruye cualquier instancia existente de DataTable antes de recrearla
        "data": formattedData, // Usar los datos formateados
        "columns": [{
            title: 'Candidato',
            data: 'candidato',
            "width": "15%",
            mRender: function(data, type, full) {

              var subcliente = (full.subcliente === null || full.subcliente === "") ? 'Sin Subcliente' :
                '<span class="badge badge-pill badge-primary">Subcliente: ' + full.subcliente +
                '</span><br>';
              var analista = (full.usuario === null || full.usuario === '') ?
                'Analista: Sin definir' : 'Analista: ' + full.usuario;
              var reclutador = (full.reclutadorAspirante !== null) ?
                '<br><span class="badge badge-pill badge-info">Reclutador(a): ' + full
                .reclutadorAspirante + '</span>' : '';
              return '<span class="badge badge-pill badge-dark">#' + full.id +
                '</span><br><a data-toggle="tooltip" class="sin_vinculo" style="color:black;"><b>' +
                data;
              // reclutador;
            }
          },
          {
            title: 'Fechas',
            data: 'fecha_alta',
            bSortable: false,
            "width": "15%",
            mRender: function(data, type, full) {
              let fechaAlta = '';
              let fechaFinal = '';
              let fechaFormulario = '';
              let fechaDocumentos = '';
              let fechas = '';
              fechaAlta = convertirFechaHora(data)
              fechaFormulario = (full.fecha_contestado != null) ? convertirFechaHora(full
                .fecha_contestado) : '-'
              fechaDocumentos = (full.fecha_documentos != null) ? convertirFechaHora(full
                .fecha_documentos) : '-'

              if (full.fecha_final != null) {
                fechaFinal = convertirFechaHora(full.fecha_final)
              }
              if (full.fecha_bgc != null) {
                fechaFinal = convertirFechaHora(full.fecha_bgc)
              }
              if (full.fecha_final == null && full.fecha_bgc == null) {
                fechaFinal = '-'
              }
              return fechas = '<b>Alta:</b> ' + fechaAlta + '<br>' + '<b>Formulario:</b> ' +
                fechaFormulario + '<br>' + '<b>Documentos:</b> ' + fechaDocumentos + '<br>' +
                '<b>Final:</b> ' + fechaFinal
            }
          },
          {
            title: 'SLA',
            data: 'tiempo_parcial',
            bSortable: false,
            "width": "10%",
            mRender: function(data, type, full) {
              if (full.cancelado == 0) {
                if (data != null) {
                  if (data != -1) {
                    if (data >= 0 && data <= 2) {
                      return res = '<div class="formato_dias dias_verde">' + data +
                        ' días</div>';
                    }
                    if (data > 2 && data <= 4) {
                      return res = '<div class="formato_dias dias_amarillo">' + data +
                        ' días</div>';
                    }
                    if (data >= 5) {
                      return res = '<div class="formato_dias dias_rojo">' + data +
                        ' días</div>';
                    }
                  } else {
                    return "Actualizando...";
                  }
                }
              } else {
                return 'N/A';
              }
            }
          },
          {
            title: 'Process',
            data: 'nombre_proyecto',
            bSortable: false,
            "width": "15%",
            render: function(data, type, row) {
              if (data) {
                return '<div style="display: flex; justify-content: center; align-items: center; height: 100%;"><button style="width: 120px; height: 50px; margin: 0; font-size: 14px;" class="btn btn-primary btn-info">' +
                  data + '</button></div>';
              } else {
                return '<div style="display: flex; justify-content: center; align-items: center; height: 100%;"><button style="width: 120px; height: 50px; margin: 0; font-size: 14px;" class="btn btn-primary btn-info">Exámenes</button></div>';
              }
            }
          },
          {
            title: 'Exámenes',
            data: null,
            bSortable: false,
            "width": "15%",
            mRender: function(data, type, full) {
              if (full.cancelado == 0) {
                var salida = '';
                //* Doping
                if (full.tipo_antidoping == 1) {
                  if (full.doping_hecho == 1) {
                    if (full.fecha_resultado != null && full.fecha_resultado != "") {
                      if (full.resultado_doping == 1) {
                        salida +=
                          '<b>Doping: </b><div style="display: inline-block;margin-left:3px;"><form id="pdfForm' +
                          full.idDoping +
                          '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado" id="pdfDoping" class="fa-tooltip icono_datatable icono_doping_reprobado"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' +
                          full.idDoping + '" value="' + full.idDoping +
                          '"></form></div>';
                      } else {
                        salida +=
                          '<b>Doping: </b><div style="display: inline-block;margin-left:3px;"><form id="pdfForm' +
                          full.idDoping +
                          '" action="<?php echo base_url('Doping/createPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar resultado" id="pdfDoping" class="fa-tooltip icono_datatable icono_doping_aprobado"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idDop" id="idDop' +
                          full.idDoping + '" value="' + full.idDoping +
                          '"></form></div>';
                      }

                    } else {
                      salida += "<b>Doping: Pendiente</b> ";
                    }
                  } else {
                    salida += "<b>Doping: Pendiente</b> ";
                  }
                  if (full.medico == 1 || full.psicometrico == 1) {
                    salida += '<hr>';
                  }
                }
                /*if (full.tipo_antidoping == 0) {
                	salida += "<b>Doping: N/A</b> <hr>";
                }*/
                //* Médico
                if (full.medico == 1) {

                  if (full.idMedico != null) {
                    if (full.conclusion != null && full.descripcion != null) {
                      salida +=
                        '<b>Médico:</b> <div style="display: inline-flex;"><form id="formMedico' +
                        full.idMedico +
                        '" action="<?php echo base_url('Medico/crearPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar documento final" id="pdfMedico" class="icono_datatable icono_medico"><i class="fas fa-file-pdf"></i></a><input type="hidden" name="idMedico" id="idMedico' +
                        full.idMedico + '" value="' + full.idMedico +
                        '"></form></div><hr>';
                    } else {
                      salida += "<b>Médico: En proceso</b>";
                    }

                  } else {
                    salida +=
                      '<b>Médico: Pendiente</b><div style="display: inline-block;margin-left:3px;"> <br>';
                  }



                  /*if (full.archivo_examen_medico != null && full.archivo_examen_medico !=
                    "") {
                    var carpeta_clinico = '< ?php echo base_url(); ?>_clinico/';
                    salida +=
                      '<b>Médico: </b> <a href="javascript:void(0)" data-toggle="tooltip" title="Subir examen medico" id="examen_medico" class="icono_datatable icono_medico"><i class="fas fa-upload"></i></a> <a href="' +
                      carpeta_clinico + full.archivo_examen_medico +
                      '" id="ver_medico" target="_blank" data-toggle="tooltip" title="Ver examen medico" class="icono_datatable icono_medico"><i class="fas fa-file-medical"></i></a>';
                  } else {
                    salida +=
                      '<b>Médico: </b> <a href="javascript:void(0)" data-toggle="tooltip" title="Subir examen medico" id="examen_medico" class="icono_datatable icono_medico"><i class="fas fa-upload"></i></a>';
                  }
                  if (full.psicometrico == 1) {
                    salida += '<hr>';
                  }*/

                }
                /*else {
                	salida += "<b>Médico: N/A</b> <hr>";
                }*/
                //* Psicometria
                if (full.psicometrico == 1) {

                  if (full.archivo != null && full.archivo != "") {


                    salida +=
                      '<b>Psicométrico:</b> <i class="fas fa-brain"></i></a> ' +
                      '<a href="' + psico + full.archivo +
                      '" target="_blank" data-toggle="tooltip" title="Ver psicometría" id="descarga_psicometrico" class="fa-tooltip icono_datatable icono_psicometria">' +
                      '<i class="fas fa-file-powerpoint"></i>' +
                      '</a>';
                  } else {
                    salida +=
                      '<b>Psicométrico:</b> <i class="fas fa-brain"></i></a>';
                  }
                }

                //* Sin examenes
                if (full.tipo_antidoping == 0 && full.medico == 0 && full.psicometrico == 0) {
                  salida = "<b>N/A</b> ";
                }
                /*else {
                	salida += "<b>Psicométrico: N/A</b> ";
                }*/
              } else {
                salida = "<b>N/A</b> ";
              }
              return salida;
            }
          },

          {
            title: 'Resultado',
            data: 'id',
            bSortable: false,
            "width": "12%",
            mRender: function(data, type, full) {


              if (full.cancelado == 0) {
                if (full.socioeconomico == 1) {
                  let icono_resultado = '';
                  let previo = '';
                  if (full.liberado == 0) {
                    previo =
                      ' <div style="display: inline-flex;"><form id="reportePrevioForm' +
                      data +
                      '" action="<?php echo base_url('Candidato_Conclusion/createPrevioPDF'); ?>" method="POST"><a href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte previo" id="reportePrevioPDF" class="fa-tooltip icono_datatable icono_previo"><i class="far fa-file-powerpoint"></i></a><input type="hidden" name="idPDF" id="idPDF' +
                      data + '" value="' + data + '"></form></div>';
                    return previo;
                  } else {

                    switch (full.status_bgc) {
                      case 1:
                        icono_resultado = 'icono_resultado_aprobado';

                        break;
                      case 4:
                        icono_resultado = 'icono_resultado_aprobado';
                        break;
                      case 2:
                        icono_resultado = 'icono_resultado_reprobado';
                        break;

                      case 3:
                        icono_resultado = 'icono_resultado_revision';
                        break;
                      default:

                        icono_resultado = 'icono_resultado_espera';
                        break;

                        break;
                    }


                    return '<div style="display: inline-block;">' +
                      '<form id="reporteForm' + data +
                      '" action="<?php echo base_url('Candidato_Conclusion/createPDF'); ?>" method="POST">' +
                      '<a href="javascript:void(0);" data-toggle="tooltip" title="Descargar reporte PDF" id="reportePDF" class="fa-tooltip icono_datatable ' +
                      icono_resultado + '">' +
                      '<i class="fas fa-file-pdf"></i>' +
                      '</a>' +
                      '<input type="hidden" name="idCandidatoPDF" id="idCandidatoPDF' + data +
                      '" value="' + data + '">' +
                      '</form>' +
                      '</div>' + previo;

                  }

                } else {
                  return 'Sin ESE';
                }
              } else {
                return 'N/A';
              }
            }
          }
          // Agrega más columnas según la estructura de tus datos
        ],
        fnDrawCallback: function(oSettings) {
          $('a[data-toggle="tooltip"]').tooltip({
            trigger: "hover"
          });
        },
        rowCallback: function(row, data) {
          $('a[id^=pdfDoping]', row).bind('click', () => {
            var id = data.idDoping;
            $('#pdfForm' + id).submit();
          });
          $('a[id^=pdfMedico]', row).bind('click', () => {
            var id = data.idMedico;
            $('#formMedico' + id).submit();
          });
          $('a[id^=simplePDF]', row).bind('click', () => {
            var id = data.id;
            $('#reporteFormSimple' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'El reporte PDF se esta creando y se descargará en breve',
              showConfirmButton: false,
              timer: 2500
            })
          });

          $("a#psicometria", row).bind('click', () => {
            $('#subirArchivoModal #titulo_modal').html(
              'Carga de archivo de psicometría del candidato: <br>' + data.candidato);
            $('#subirArchivoModal #label_modal').text('Selecciona el archivo de psicometría *');
            $('#btnSubir').attr("onclick", "subirArchivo('psicometrico'," + data.id + "," + data
              .idPsicometrico + ")");
            $('#subirArchivoModal').modal('show');
          });
          $("a#msj_avances", row).bind('click', () => {
            $("#idCandidato").val(data.id);
            verMensajesAvances(data.id, data.candidato)
          });
          $('a[id^=pdfPrevio]', row).bind('click', () => {
            var id = data.id;
            $('#formPrevio' + id).submit();
          });
          $("a#final", row).bind('click', () => {
            $("#idCandidato").val(data.id);
            $(".nombreCandidato").text(data.candidato);
            if (data.tipo_conclusion == 8) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', false);
              $('#check_credito').prop('disabled', true);
              $('#check_medico').prop('disabled', true);
              $('#check_domicilio').prop('disabled', true);
              $('#check_professional_accreditation').prop('disabled', true);
              $('#check_ref_academica').prop('disabled', true);
              $('#check_nss').prop('disabled', true);
              $('#check_ciudadania').prop('disabled', true);
              $('#check_mvr').prop('disabled', true);
              $('#check_servicio_militar').prop('disabled', true);
              $('#check_credencial_academica').prop('disabled', true);
              $('#check_ref_profesional').prop('disabled', true);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 9) {
              $('#finalizarInvestigacionesModal').modal('show')
            }
            if (data.tipo_conclusion == 11) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', false);
              $('#check_medico').prop('disabled', true);
              $('#check_domicilio').prop('disabled', true);
              $('#check_professional_accreditation').prop('disabled', true);
              $('#check_ref_academica').prop('disabled', true);
              $('#check_nss').prop('disabled', true);
              $('#check_ciudadania').prop('disabled', true);
              $('#check_mvr').prop('disabled', true);
              $('#check_servicio_militar').prop('disabled', true);
              $('#check_credencial_academica').prop('disabled', true);
              $('#check_ref_profesional').prop('disabled', true);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 12) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', true);
              $('#check_penales').prop('disabled', false);
              $('#check_ofac').prop('disabled', false);
              $('#check_global').prop('disabled', false);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 13) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', true);
              $('#check_penales').prop('disabled', false);
              $('#check_ofac').prop('disabled', false);
              $('#check_global').prop('disabled', false);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 16) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', true);
              $('#check_identidad').prop('disabled', false);
              $('#check_penales').prop('disabled', false);
              $('#check_ofac').prop('disabled', false);
              $('#check_global').prop('disabled', false);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 18) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', true);
              $('#check_identidad').prop('disabled', false);
              $('#check_laboral').prop('disabled', false);
              $('#check_estudios').prop('disabled', false);
              $('#check_penales').prop('disabled', false);
              $('#check_ofac').prop('disabled', false);
              $('#check_global').prop('disabled', false);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 20) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', true);
              $('#check_identidad').prop('disabled', false);
              $('#check_global').prop('disabled', false);
              $('#check_penales').prop('disabled', false);
              $('#check_laboral').prop('disabled', false);
              $('#check_estudios').prop('disabled', false);
              $('#check_ofac').prop('disabled', false);
              $('#check_credito').prop('disabled', false);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 22) {
              $('.es_check').val(3);
              $('.es_check').prop('disabled', false);
              //$('#comentario_final').val('')
              //$('#comentario_final').prop('disabled',true);
              $('#finalizarModal').modal('show')
            }
            if (data.tipo_conclusion == 1 || data.tipo_conclusion == 2 || data
              .tipo_conclusion == 3 || data.tipo_conclusion == 4 || data.tipo_conclusion ==
              5 || data.tipo_conclusion == 6 || data.tipo_conclusion == 7 || data
              .tipo_conclusion == 10 || data.tipo_conclusion == 14 || data.tipo_conclusion ==
              15 || data.tipo_conclusion == 17 || data.tipo_conclusion == 19 || data
              .tipo_conclusion == 21) {
              $('.loader').css("display", "block");
              //* Datos generales
              var adeudo = (data.adeudo_muebles == 1) ? "con adeudo" : "sin adeudo";
              var estatus_final_conclusion = '';
              switch (data.status_bgc) {
                case '1':
                  estatus_final_conclusion = 'Recomendable';
                  break;
                case '2':
                  estatus_final_conclusion = 'No recomendable';
                  break;
                case '3':
                  estatus_final_conclusion = 'A consideración del cliente';
                  break;
                default:
                  estatus_final_conclusion = 'Estatus final';
                  break;
              }
              //* Origen
              if (data.pais == 'México' || data.pais == 'Mexico' || data.pais == null) {
                var originario = data.lugar_nacimiento;
              } else {
                var originario = data.lugar_nacimiento + ', ' + data.pais;
              }
              //* Antecedentes sociales
              var data_social = $.ajax({
                url: '<?php echo base_url('Candidato_Social/getById'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              if (data_social != 0) {
                var social = JSON.parse(data_social);
                var bebidas = (social.bebidas == 1) ? "ingerir" : "no ingerir";
                var fuma = (social.fumar == 1) ? "Fuma " + social.fumar_frecuencia + "." :
                  "No fuma.";
                if (social.religion != "" && social.religion != "Ninguna" && social
                  .religion != "NINGUNA" && social.religion != "No" && social.religion !=
                  "NO" && social.religion != "NA" && social.religion != "N/A" && social
                  .religion != "No aplica" && social.religion != "NO APLICA" && social
                  .religion != "No Aplica") {
                  var religion = "profesa la religion " + social.religion + ".";
                } else {
                  var religion = "no profesa alguna religión.";
                }
                if (social.cirugia != "" && social.cirugia != "Ninguna" && social.cirugia !=
                  "NINGUNA" && social.cirugia != "No" && social.cirugia != "NO" && social
                  .cirugia != "NA" && social.cirugia != "N/A" && social.cirugia !=
                  "No aplica" && social.cirugia != "NO APLICA" && social.cirugia !=
                  "No Aplica" && social.cirugia != "0") {
                  var cirugia = "Cuenta con cirugia(s) de " + social.cirugia + ".";
                } else {
                  var cirugia = "No cuenta con cirugias.";
                }
                if (social.enfermedades != "" && social.enfermedades != "Ninguna" && social
                  .enfermedades != "NINGUNA" && social.enfermedades != "No" && social
                  .enfermedades != "NO" && social.enfermedades != "NA" && social
                  .enfermedades != "N/A" && social.enfermedades != "No aplica" && social
                  .enfermedades != "NO APLICA" && social.enfermedades != "No Aplica" &&
                  social.enfermedades != "0") {
                  var enfermedades =
                    "Tiene alguna(s) enfermedad(es) con antecedente familiar como " +
                    social.enfermedades + ".";
                } else {
                  var enfermedades =
                    "No tiene antecedentes de enfermedadades en su familia.";
                }

              } else {
                var social = '';
                var bebidas = '';
                var fuma = '';
                var religion = '';
                var cirugia = '';
                var enfermedades = '';
              }
              //*Comentarios ref laborales
              var comentarios_laborales = $.ajax({
                url: '<?php echo base_url('Candidato_Laboral/getComentarios'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id_candidato': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Historial de puestos laborales
              var historial_puestos = $.ajax({
                url: '<?php echo base_url('Candidato_Laboral/getHistorialPuestos'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Comentarios ref personales
              var refs_comentarios = $.ajax({
                url: '<?php echo base_url('Candidato_Ref_Personal/getComentarios'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Comentarios ref vecinales
              var vecinales = $.ajax({
                url: '<?php echo base_url('Candidato_Ref_Vecinal/getComentarios'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id_candidato': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Numero de antecedentes laborales reportados
              var trabajos = $.ajax({
                url: '<?php echo base_url('Candidato_Laboral/countAntecedentesLaborales'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id_candidato': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Información de vivienda
              var data_vivienda = $.ajax({
                url: '<?php echo base_url('Candidato_Vivienda/getById'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              if (data_vivienda != 0) {
                var vivienda = JSON.parse(data_vivienda);
                switch (vivienda.calidad_mobiliario) {
                  case '1':
                    var calidad = "Buena";
                    break;
                  case '2':
                    var calidad = "Regular";
                    break;
                  case '3':
                    var calidad = "Mala";
                    break;
                }
                switch (vivienda.tamanio_vivienda) {
                  case '1':
                    var tamano = "Amplia";
                    break;
                  case '2':
                    var tamano = "Suficiente";
                    break;
                  case '3':
                    var tamano = "Reducidad";
                    break;
                }
                switch (vivienda.tipo_propiedad) {
                  case 'Propia':
                  case 'Pagando hipoteca':
                  case 'INFONAVIT':
                    var propiedad = "suya o de sus padres";
                    break;
                  case 'Rentada':
                    var propiedad = "rentada ";
                    break;
                  case 'Prestada':
                    var propiedad = "prestada ";
                    break;
                }
                var distribucion_hogar = '';
                if (vivienda.sala == 'Sí')
                  distribucion_hogar += 'sala, ';
                if (vivienda.comedor == 'Sí')
                  distribucion_hogar += 'comedor, ';
                if (vivienda.cocina == 'Sí')
                  distribucion_hogar += 'cocina, ';
                if (vivienda.patio == 'Sí')
                  distribucion_hogar += 'patio, ';
                if (vivienda.cochera == 'Sí')
                  distribucion_hogar += 'cochera, ';
                if (vivienda.cuarto_servicio == 'Sí')
                  distribucion_hogar += 'cuarto de servicio, ';
                if (vivienda.jardin == 'Sí')
                  distribucion_hogar += 'jardín, ';
                distribucion_hogar += vivienda.banios + ' baño(s), ';
                distribucion_hogar += vivienda.recamaras + ' recámaras';
              } else {
                var vivienda = '';
                var distribucion_hogar = '';
              }
              //* Personas en misma vivienda
              var personas_mismo_domicilio = $.ajax({
                url: '<?php echo base_url('Candidato_Familiar/getIntegrantesDomicilio'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Estudios de acuerdo a historial
              var maximo_estudio = $.ajax({
                url: '<?php echo base_url('Candidato_Estudio/getMaximoEstudio'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Información de salud
              var data_salud = $.ajax({
                url: '<?php echo base_url('Candidato_Salud/getById'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              if (data_salud != 0) {
                var salud = JSON.parse(data_salud);
                if (salud.enfermedad_cronica == 'No aplica' || salud.enfermedad_cronica ==
                  'NA' || salud.enfermedad_cronica == 'N/A' || salud.enfermedad_cronica ==
                  'No padece' || salud.enfermedad_cronica == 'No tiene') {
                  var enfermedad_cronica = 'no padece enfermedades crónicas,';
                } else {
                  var enfermedad_cronica = 'padece de ' + salud.enfermedad_cronica + ',';
                }
                if (salud.accidentes == 'No aplica' || salud.accidentes == 'NA' || salud
                  .accidentes == 'N/A' || salud.accidentes == 'No ha tenido') {
                  var accidente = 'no ha sufrido accidentes graves,';
                } else {
                  var accidente = 'ha sufrido de ' + salud.accidentes + ',';
                }
                if (salud.alergias == 'No aplica' || salud.alergias == 'NA' || salud
                  .alergias == 'N/A' || salud.alergias == 'No ha tenido' || salud
                  .alergias == 'No tiene') {
                  var alergias = 'no reporta alergias.';
                } else {
                  var alergias = 'reporta alergias de ' + salud.alergias + '.';
                }
                if (salud.tabaco == 'SI') {
                  var salud_tabaco = 'Refiere consumir tabaco con una frecuencia de ' +
                    salud.tabaco_frecuencia.toLowerCase();
                } else {
                  var salud_tabaco = 'Niega la ingesta de tabaco';
                }
                if (salud.droga == 'SI') {
                  var salud_droga = ' , hace uso de droga con una frecuencia de ' + salud
                    .droga_frecuencia.toLowerCase();
                } else {
                  var salud_droga = ' , no hace uso de droga';
                }
                if (salud.alcohol == 'SI') {
                  var salud_alcohol = ' y refiere consumir alcohol de manera ' + salud
                    .alcohol_frecuencia.toLowerCase();
                } else {
                  var salud_alcohol = ' y no consume alcohol';
                }
                if (salud.practica_deporte == 1) {
                  var practica_deporte = 'Como actividad física menciona practicar ' +
                    salud.practica_deporte + ' ' + salud.deporte_frecuencia;
                } else {
                  var practica_deporte = 'Menciona que no practica algún deporte';
                }
              } else {
                var salud = '';
              }
              //* Información economica
              var data_economia = $.ajax({
                url: '<?php echo base_url('Candidato_Finanzas/getById'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              if (data_economia != 0) {
                var economia = JSON.parse(data_economia);
              } else {
                var economia = '';
              }
              //*Información referencias y contactos laborales
              var incidencias_laborales = $.ajax({
                url: '<?php echo base_url('Candidato_Laboral/getHistorialIncidencias'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              //* Extra laboral
              var data_extra_laboral = $.ajax({
                url: '<?php echo base_url('Candidato_Laboral/getExtrasById'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              var extra_laboral = JSON.parse(data_extra_laboral);
              //* Informacion de servicios publicos
              var data_servicios = $.ajax({
                url: '<?php echo base_url('Candidato_Servicio/getById'); ?>',
                type: 'post',
                async: false,
                data: {
                  'id': data.id
                },
                success: function(res) {}
              }).responseText;
              var servicios = JSON.parse(data_servicios);
              setTimeout(function() {
                $('.loader').fadeOut();
              }, 200);
              //*Tipos de conclusion
              if (data.tipo_conclusion == 0) {
                finalizarProcesoSinEstatus();
              }
              if (data.tipo_conclusion == 21) {
                $("#personal3").prop('disabled', true);
                $("#personal3").val("");
                $("#personal4").prop('disabled', true);
                $("#personal4").val("");
                $("#socio1").prop('disabled', true);
                $("#socio1").val("");
                $("#laboral1").prop('disabled', true);
                $("#laboral1").val("");
                $("#visita1").prop('disabled', true);
                $("#visita1").val("");
                $("#visita2").prop('disabled', true);
                $("#visita2").val("");
                $('#comentario_bgc').prop('disabled', true)
                $('#comentario_bgc').val("");
                let sumaGastos = (parseInt(economia.renta) + parseInt(economia.alimentos) +
                  parseInt(economia.servicios) + parseInt(economia.transporte) +
                  parseInt(economia.otros));

                $("#personal1").val("C. " + data.candidato + ", de " + data.edad +
                  " años de edad, es " + data.estado_civil + ", reside en " + data
                  .municipio + ", " + data.estado + ".");
                $("#personal2").val("Menciona " + bebidas + " bebidas alcohólicas y " +
                  fuma + "." + cirugia + ".");
                //$("#personal3").val("Sus referencias personales lo describen como " + refs_comentarios + ".");
                //$("#socio1").val("Actualmente vive en un/una " + vivienda.vivienda + ", en una zona " + vivienda.zona + "; el mobiliario en su interior se observa de "+calidad+", la vivienda es "+tamano+", en condiciones "+vivienda.condiciones+". "+servicios.basicos+"; "+servicios.vias_acceso+" y "+servicios.rutas_transporte+".");
                $("#socio2").val("Los ingresos mensuales son de $" + economia.sueldo +
                  "; sus gastos mensualmente son de $" + sumaGastos +
                  ". Con respecto a si posee bienes el candidato menciona que " +
                  economia.bienes +
                  "; y con respecto a sus deudas comenta que tiene" + economia.deudas);
                $("#laboral2").val(comentarios_laborales);
                //$("#visita2").val("De acuerdo a su(s) referencia(s) vecinal(es), describen que es " + vecinales);
                //$("#visita1").val("Durante la visita, el(la) candidato(a) fue: ");
                $('#conclusion_investigacion').val(
                  'En la investigación realizada se encontró que el(la) candidato(a) es una persona ________.Le consideramos ' +
                  estatus_final_conclusion + ".")
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 14) {
                $("#personal4").prop('disabled', true);
                $("#personal4").val("");
                $("#laboral1").prop('disabled', true);
                $("#laboral1").val("");
                $('#comentario_bgc').prop('disabled', true)
                $('#comentario_bgc').val("");

                $("#personal1").val("C. " + data.candidato + ", de " + data.edad +
                  " años de edad, es " + data.estado_civil + ", reside en " + data
                  .municipio + ", " + data.estado + " " + religion +
                  ". Cuenta con estudios en " + data.grado);
                $("#personal2").val("Menciona " + bebidas + " bebidas alcohólicas y " +
                  fuma + "." + cirugia + ". Su plan a corto plazo es " + social
                  .corto_plazo + "; y su meta a mediano plazo es " + social
                  .mediano_plazo + ".");
                $("#personal3").val("Sus referencias personales lo describen como " +
                  refs_comentarios + ".");
                $("#socio1").val("Actualmente vive en un/una " + vivienda.vivienda +
                  ", en una zona " + vivienda.zona +
                  "; el mobiliario en su interior se observa de " + calidad +
                  ", la vivienda es " + tamano + ", en condiciones " + vivienda
                  .condiciones + ". " + servicios.basicos + "; " + servicios
                  .vias_acceso + " y " + servicios.rutas_transporte + ".");
                $("#socio2").val("El(La) candidato(a) vive " + personas_mismo_domicilio +
                  ". Los ingresos mensuales ______; gastan mensualmente $" + economia
                  .otros + ". La vivienda cuenta con " + distribucion_hogar + ".");
                $("#laboral2").val(comentarios_laborales);
                $("#visita2").val(
                  "De acuerdo a su(s) referencia(s) vecinal(es), describen que es " +
                  vecinales);
                $("#visita1").val("Durante la visita, el(la) candidato(a) fue: " + data
                  .comentarioVisitador);
                $('#conclusion_investigacion').val(
                  'En la investigación realizada se encontró que el(la) candidato(a) es una persona ________.Le consideramos ' +
                  estatus_final_conclusion + ".")
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 1) {
                $('#conclusion_investigacion').prop('disabled', true)
                $('#conclusion_investigacion').val('')
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, reside en " + data.municipio + ", " + data.estado +
                  ". Es " + data.estado_civil + " y " + religion);
                $("#personal2").val("Refiere " + bebidas + " bebidas alcohólicas. " + fuma +
                  " " + cirugia + " " + enfermedades +
                  " Sus referencias personales lo describen como " +
                  refs_comentarios + ".");
                $("#personal3").val("Su plan a corto plazo es " + social.corto_plazo +
                  "; y su meta a mediano plazo es " + social.mediano_plazo);
                $("#personal4").val("Su grado máximo de estudios es " + data.grado);
                $("#socio1").val("Actualmente vive en un/una " + vivienda.vivienda +
                  ", con un tiempo de residencia de " + vivienda.tiempo_residencia +
                  ". El nivel de la zona es " + vivienda.zona +
                  ", el mobiliario es de calidad " + calidad + ", la vivienda es " +
                  tamano + " y en condiciones " + vivienda.condiciones +
                  ". La distribución de su " + vivienda.vivienda + " es " + vivienda
                  .distribucion);
                $("#socio2").val(data.candidato + " declara en sus ingresos " + data
                  .ingresos +
                  ". Los gastos generados en el hogar son solventados por _____. Cuenta con " +
                  data.muebles + " " + adeudo + ".");
                $("#laboral1").val("Señaló " + trabajos + " referencias laborales");
                $("#laboral2").val(comentarios_laborales);
                $("#visita1").val("El candidato durante la visita: " + data
                  .comentarioVisitador);
                $("#visita2").val(
                  "De acuerdo a la referencia vecinal, el candidato es considerado: " +
                  vecinales);
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 2) {
                $('#conclusion_investigacion').prop('disabled', true)
                $('#conclusion_investigacion').val('')
                if (data.visitador == 1) {
                  $("#personal1").val("Se aplicó estudio socioeconómico a " + data
                    .candidato + ", de " + data.edad + " años, originario de " +
                    originario + " con CURP:" + data.curp + " y NSS:" + data.nss +
                    "; estado civil " + data.estado_civil.toLowerCase() +
                    ", vive " + personas_mismo_domicilio + "en el domicilio " + data
                    .calle + " #" + data.exterior + " " + data.interior +
                    ", colonia " + data.colonia + ", desde hace " + data
                    .tiempo_dom_actual + ", en una propiedad " + propiedad +
                    " que se encuentra ubicada en una zona " + vivienda.tipo_zona
                    .toLowerCase() + " de clase " + vivienda.zona.toLowerCase() +
                    ".");
                } else {
                  $("#personal1").val("No se pudo aplicar el estudio socioeconómico.");
                }
                $("#personal2").val("En cuanto a su salud " + enfermedad_cronica + " " +
                  accidente + " su tipo de sangre es " + salud.tipo_sangre + " y " +
                  alergias + " " + salud_tabaco + salud_droga + salud_alcohol + ". " +
                  practica_deporte + ".");
                $("#personal4").val("Sus estudios máximos son de " + maximo_estudio +
                  " su experiencia laboral es como " + historial_puestos + ".");
                $("#socio1").val(
                  "Referente a su economía, menciona solventar sus gastos con " +
                  economia.observacion + ".");
                $("#socio2").val("Sus referencias personales lo describen como " +
                  refs_comentarios + ".");
                $("#laboral2").val("En cuanto a sus empleos, estuvo en " +
                  incidencias_laborales);
                $("#personal3").prop('disabled', true);
                $("#personal3").val("");
                $("#laboral1").prop('disabled', true);
                $("#laboral1").val("");
                $("#visita1").prop('disabled', true);
                $("#visita1").val("");
                $("#visita2").prop('disabled', true);
                $("#visita2").val("");
                $("#comentario_bgc").prop('disabled', true);
                $("#comentario_bgc").val("");
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 3) {
                $('.es_conclusion').prop('disabled', true)
                $('.es_conclusion').val('')
                $("#comentario_bgc").prop('disabled', false);
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 4) {
                $('.es_conclusion').prop('disabled', true)
                $("#personal1").prop('disabled', false)
                $("#laboral1").prop('disabled', false)
                $("#laboral2").prop('disabled', false)
                $('.es_conclusion').val('')
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, es originario de " + originario +
                  ". Tiene como máximo grado de estudios: " + data.grado +
                  ". Refiere ser " + social.religion + ". Su plan a corto plazo: " +
                  social.corto_plazo + ". Su plan a mediano plazo: " + social
                  .mediano_plazo);
                $("#laboral1").val("Señaló " + trabajos + " referencias laborales");
                $("#laboral2").val(" es quien nos valida referencia laboral..");
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 5) {
                $('.es_conclusion').prop('disabled', false)
                $('.es_conclusion').val('')
                $("#socio1").prop('disabled', true);
                $("#visita2").prop('disabled', true);
                $("#conclusion_investigacion").prop('disabled', false)
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, de nacionalidad " + data.nacionalidad + ", que reside en " +
                  data.municipio + ", " + data.estado + ". Es " + data.estado_civil);
                $("#personal2").val("Refiere " + bebidas + " bebidas alcohólicas. " + fuma +
                  " " + cirugia + " " + enfermedades +
                  " Sus referencias personales lo describen como " +
                  refs_comentarios + ".");
                $("#personal3").val("Su plan a corto plazo: " + social.corto_plazo +
                  ". Su plan a mediano plazo: " + social.mediano_plazo);
                $("#personal4").val("Su grado máximo de estudios es " + data.grado);

                $("#socio2").val(data.candidato + " declara en sus ingresos $" + data
                  .ingresos +
                  ". Los gastos generados en el hogar son solventados por _____. Cuenta con " +
                  data.muebles + " " + adeudo + ".");
                $("#laboral1").val("Señaló " + trabajos + " referencias laborales");
                $("#laboral2").val(comentarios_laborales);
                $("#visita1").val("El candidato durante la visita: ");
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 6) {
                $('.es_conclusion').prop('disabled', false)
                $('.es_conclusion').val('')
                $("#socio1").prop('disabled', true)
                $("#socio2").prop('disabled', true)
                $("#visita1").prop('disabled', true)
                $("#visita2").prop('disabled', true)
                $('#conclusion_investigacion').prop('disabled', true)
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, de nacionalidad " + data.nacionalidad + ". Es " + data
                  .estado_civil);
                $("#personal2").val(
                  "Refiere _ bebidas alcohólicas. Sus referencias personales lo describen como _."
                );
                $("#personal3").val(
                  "Su plan a corto plazo es _; y su meta a mediano plazo es _");
                $("#personal4").val("Su grado máximo de estudios es " + data.grado);
                $("#laboral1").val("Señaló " + trabajos + " referencias laborales");
                $("#laboral2").val(comentarios_laborales);
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 7) {
                $('.es_conclusion').prop('disabled', true)
                $('.es_conclusion').val('')
                $('#personal1').prop('disabled', false)
                $('#personal2').prop('disabled', false)
                $("#laboral1").prop('disabled', false)
                $("#laboral2").prop('disabled', false)
                $("#socio1").prop('disabled', false)
                $("#socio2").prop('disabled', false)
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, es originario de " + originario +
                  ". Tiene como máximo grado de estudios: " + data.grado +
                  ". Refiere ser " + social.religion + ". Su plan a corto plazo: " +
                  social.corto_plazo + ". Su plan a mediano plazo: " + social
                  .mediano_plazo);
                $("#personal2").val("Refiere " + bebidas + " bebidas alcohólicas " + social
                  .bebidas_frecuencia + ". " + fuma +
                  " Sus referencias personales lo describen como " +
                  refs_comentarios + ".");
                $("#laboral1").val("Señaló " + trabajos + " referencias laborales.");
                $("#laboral2").val(" es quien nos valida referencia laboral.");
                $("#socio1").val(data.candidato + ", actualmente vive en un/una " + vivienda
                  .vivienda + ", con un tiempo de residencia de " + vivienda
                  .tiempo_residencia + ". El nivel de la zona es " + vivienda.zona +
                  ", el mobiliario es de calidad " + calidad + ", la vivienda es " +
                  tamano + " y en condiciones " + vivienda.condiciones);
                $("#socio2").val(
                  "Los gastos generados en el hogar son solventados por _____. Sus referencias vecinales describen que es " +
                  vecinales + ". El candidato cuenta con " + data.muebles + " " +
                  adeudo);
                $("#revisionModal").modal('show');
              }
              if (data.tipo_conclusion == 19) {
                $('.es_conclusion').prop('disabled', true)
                $('.es_conclusion').val('')
                $('#personal1').prop('disabled', false)
                $('#personal2').prop('disabled', false)
                $("#laboral1").prop('disabled', false)
                $("#laboral2").prop('disabled', false)
                $("#socio1").prop('disabled', false)
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, es originario de " + originario +
                  ". Tiene como máximo grado de estudios: " + data.grado +
                  ". Refiere ser " + social.religion + ". Su plan a corto plazo: " +
                  social.corto_plazo + ". Su plan a mediano plazo: " + social
                  .mediano_plazo);
                $("#personal2").val("Refiere " + bebidas + " bebidas alcohólicas " + social
                  .bebidas_frecuencia + ". " + fuma +
                  " Sus referencias personales lo describen como " +
                  refs_comentarios + ".");
                $("#laboral1").val("Señaló " + trabajos + " referencias laborales.");
                $("#laboral2").val(" es quien nos valida referencia laboral.");
                $("#socio1").val(data.candidato + ", actualmente vive en un/una " + vivienda
                  .vivienda + ", con un tiempo de residencia de " + vivienda
                  .tiempo_residencia + ". El nivel de la zona es " + vivienda.zona +
                  ", el mobiliario es de calidad " + calidad + ", la vivienda es " +
                  tamano + " y en condiciones " + vivienda.condiciones +
                  ". El candidato cuenta con " + data.muebles + " " + adeudo);
                $("#revisionModal").modal('show');
              }
              if (data.tipo_conclusion == 10) {
                $('.es_conclusion').prop('disabled', true)
                $('.es_conclusion').val('')
                $('#personal1').prop('disabled', false)
                $('#personal2').prop('disabled', false)
                $("#laboral2").prop('disabled', false)
                $("#socio1").prop('disabled', false)
                $("#socio2").prop('disabled', false)
                $("#personal1").val(data.candidato + ", de " + data.edad +
                  " años, es originario de " + originario +
                  ". Tiene como máximo grado de estudios: " + data.grado + ". Es " +
                  data.estado_civil + " y " + religion);
                $("#personal2").val("Refiere " + bebidas + " bebidas alcohólicas " + social
                  .bebidas_frecuencia + ". " + fuma + ". Refiere ser " + social
                  .religion + ". Su plan a corto plazo: " + social.corto_plazo +
                  ". Su plan a mediano plazo: " + social.mediano_plazo);
                $("#laboral2").val("Indica que tiene trabajando para " + data.cliente +
                  " por " + extra_laboral.actual_activo);
                $("#socio1").val(data.candidato + ", actualmente vive en un/una " + vivienda
                  .vivienda + ", con un tiempo de residencia de " + vivienda
                  .tiempo_residencia + ". El nivel de la zona es " + vivienda.zona +
                  ", el mobiliario es de calidad " + calidad + ", la vivienda es " +
                  tamano + " y en condiciones " + vivienda.condiciones);
                $("#socio2").val(
                  "Los gastos generados en el hogar son solventados por _____. Sus referencias vecinales describen que es " +
                  vecinales + ". El candidato cuenta con " + data.muebles + " " +
                  adeudo);
                $("#revisionModal").modal('show');
              }
              if (data.tipo_conclusion == 15) {
                $("#personal3").prop('disabled', true);
                $("#personal3").val("");
                $("#personal4").prop('disabled', true);
                $("#personal4").val("");
                $("#laboral1").prop('disabled', true);
                $("#laboral1").val("");
                $("#visita1").prop('disabled', true);
                $("#visita1").val("");
                $("#visita2").prop('disabled', true);
                $("#visita2").val("");
                $("#socio1").prop('disabled', true);
                $("#socio1").val("");
                $("#socio2").prop('disabled', true);
                $("#socio2").val("");
                $('#comentario_bgc').prop('disabled', true)
                $('#comentario_bgc').val("");

                $("#personal1").val("C. " + data.candidato + ", de " + data.edad +
                  " años de edad, es " + data.estado_civil + ", reside en " + data
                  .municipio + ", " + data.estado + " " + religion +
                  ". Cuenta con estudios en " + data.grado);
                $("#personal2").val("Menciona " + bebidas + " bebidas alcohólicas y " +
                  fuma + "." + cirugia + ". Su plan a corto plazo es " + social
                  .corto_plazo + "; y su meta a mediano plazo es " + social
                  .mediano_plazo + ".");
                $("#laboral2").val(comentarios_laborales);
                $('#conclusion_investigacion').val(
                  'En la investigación realizada se encontró que el(la) candidato(a) es una persona ________.Le consideramos ' +
                  estatus_final_conclusion + ".")
                $("#completarModal").modal('show');
              }
              if (data.tipo_conclusion == 17) {
                $('.es_conclusion').prop('disabled', true)
                $('.es_conclusion').val('')
                // $('#conclusion_investigacion').prop('disabled', false)
                $("#comentario_bgc").prop('disabled', false);
                $("#completarModal").modal('show');
              }
            }
          });
          $('a[id^=reportePDF]', row).bind('click', () => {
            var id = data.id;
            $('#reporteForm' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'El reporte PDF se esta creando y se descargará en breve',
              showConfirmButton: false,
              timer: 2500
            })
          });
          $('a[id^=reportePrevioPDF]', row).bind('click', () => {
            var id = data.id;
            $('#reportePrevioForm' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'El reporte previo PDF se descargará en breve',
              showConfirmButton: false,
              timer: 2500
            })
          });
          $('a[id^=completoPDF]', row).bind('click', () => {
            var id = data.id;
            $('#reporteFormCompleto' + id).submit();
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'El reporte PDF se esta creando y se descargará en breve',
              showConfirmButton: false,
              timer: 2500
            })
          });

        }
      });
    },
    error: function(xhr, error, thrown) {
      console.error("Error al cargar los datos:", error, thrown);
      console.error("Respuesta del servidor:", xhr.responseText);
    }
  });
}



  $("#opcion_registro").change(function() {
    var opcion = $(this).val();
    $('.div_info_project').css('display', 'block');
    $('.div_project').css('display', 'flex');
    $('.div_info_test').css('display', 'block');
    $('.div_test').css('display', 'flex');
    $("#newModal #msj_error").css('display', 'none');
    if (opcion == 1) {
      $('.div_check').css('display', 'none');
      $('.div_info_check').css('display', 'none');
      $('.div_info_extra').css('display', 'none');
      $('.div_extra').css('display', 'none');
    }
    if (opcion == 0) {
      $('.div_previo').css('display', 'flex');
      $('.div_info_previo').css('display', 'block');
      $('.div_check').css('display', 'flex');
      $('.div_info_check').css('display', 'block');
      $('.div_info_extra').css('display', 'block');
      $('.div_extra').css('display', 'flex');
    }
    if (opcion == '') {
      $('.div_previo').css('display', 'none');
      $('.div_info_previo').css('display', 'none');
      $('.div_check').css('display', 'none');
      $('.div_info_check').css('display', 'none');
      $('.div_info_project').css('display', 'none');
      $('.div_project').css('display', 'none');
      $('.div_info_test').css('display', 'none');
      $('.div_test').css('display', 'none');
      $('.div_info_extra').css('display', 'none');
      $('.div_extra').css('display', 'none');
    }
  });
  $("#region").change(function() {
    var region = $(this).val();
    if (region != '') {
      $.ajax({
        url: '<?php echo base_url('Candidato/getSeccionesRegion'); ?>',
        method: 'POST',
        data: {
          'region': region
        },
        success: function(res) {
          var secciones = JSON.parse(res);
          $('.valor_dinamico').val('');
          $('.valor_dinamico').empty();
          //$('.valor_dinamico').append($('<option selected></option>').attr('value','').text('Select'));
          $('.valor_dinamico').prop('disabled', false);
          $('#ref_profesionales_registro').val(0);
          $('#ref_personales_registro').val(0);
          $('#ref_academicas_registro').val(0);
          //Distribuye las secciones en su correspondiente select
          for (var i = 0; i < secciones.length; i++) {
            if (secciones[i]['tipo_seccion'] == 'Global Search') {
              $('#global_registro').append($('<option></option>').attr('value', secciones[i]['id']).text(
                secciones[i]['descripcion_ingles']));
            }
            /*if(secciones[i]['tipo_seccion'] == 'Verificacion Documentos'){
            	$('#identidad_registro').append($('<option></option>').attr('value',secciones[i]['id']).text(secciones[i]['descripcion_ingles']));
            }*/
            //if(secciones[i]['tipo_seccion'] == 'Referencias Laborales'){
            if (secciones[i]['id'] == 16) {
              $('#empleos_registro').append($('<option></option>').attr('value', secciones[i]['id']).text(
                secciones[i]['descripcion_ingles']));
            }
            //if(secciones[i]['tipo_seccion'] == 'Estudios'){
            if (secciones[i]['id'] == 3) {
              $('#estudios_registro').append($('<option></option>').attr('value', secciones[i]['id']).text(
                secciones[i]['descripcion_ingles']));
            }
            if (secciones[i]['tipo_seccion'] == 'Domicilios') {
              $('#domicilios_registro').append($('<option></option>').attr('value', secciones[i]['id']).text(
                secciones[i]['descripcion_ingles']));
            }
            if (secciones[i]['tipo_seccion'] == 'Credito') {
              $('#credito_registro').append($('<option></option>').attr('value', secciones[i]['id']).text(
                secciones[i]['descripcion_ingles']));
            }
          }
          //Empleos
          $('#empleos_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected")
            .text('N/A'));
          $('#empleos_tiempo_registro').append($('<option></option>').attr('value', '3 years').text(
            '3 years'));
          $('#empleos_tiempo_registro').append($('<option></option>').attr('value', '5 years').text(
            '5 years'));
          $('#empleos_tiempo_registro').append($('<option></option>').attr('value', '7 years').text(
            '7 years'));
          $('#empleos_tiempo_registro').append($('<option></option>').attr('value', '10 years').text(
            '10 years'));
          $('#empleos_tiempo_registro').append($('<option></option>').attr('value', 'All').text('All'));
          $('#empleos_tiempo_registro').append($('<option></option>').attr('value', '0').attr("selected",
            "selected").text('N/A'));
          //Criminales
          $('#criminal_registro').append($('<option></option>').attr('value', 1).text('Apply'));
          $('#criminal_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected")
            .text('N/A'));
          $('#criminal_tiempo_registro').append($('<option></option>').attr('value', '3 years').text(
            '3 years'));
          $('#criminal_tiempo_registro').append($('<option></option>').attr('value', '5 years').text(
            '5 years'));
          $('#criminal_tiempo_registro').append($('<option></option>').attr('value', '7 years').text(
            '7 years'));
          $('#criminal_tiempo_registro').append($('<option></option>').attr('value', '10 years').text(
            '10 years'));
          $('#criminal_tiempo_registro').append($('<option></option>').attr('value', '0').attr("selected",
            "selected").text('N/A'));
          //Domicilios
          $('#domicilios_registro').append($('<option></option>').attr('value', 0).attr("selected",
            "selected").text('N/A'));
          $('#domicilios_tiempo_registro').append($('<option></option>').attr('value', '3 years').text(
            '3 years'));
          $('#domicilios_tiempo_registro').append($('<option></option>').attr('value', '5 years').text(
            '5 years'));
          $('#domicilios_tiempo_registro').append($('<option></option>').attr('value', '7 years').text(
            '7 years'));
          $('#domicilios_tiempo_registro').append($('<option></option>').attr('value', '10 years').text(
            '10 years'));
          $('#domicilios_tiempo_registro').append($('<option></option>').attr('value', '0').attr("selected",
            "selected").text('N/A'));
          //Credito
          $('#credito_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected")
            .text('N/A'));
          $('#credito_tiempo_registro').append($('<option></option>').attr('value', '3 years').text(
            '3 years'));
          $('#credito_tiempo_registro').append($('<option></option>').attr('value', '5 years').text(
            '5 years'));
          $('#credito_tiempo_registro').append($('<option></option>').attr('value', '7 years').text(
            '7 years'));
          $('#credito_tiempo_registro').append($('<option></option>').attr('value', '10 years').text(
            '10 years'));
          $('#credito_tiempo_registro').append($('<option></option>').attr('value', '0').attr("selected",
            "selected").text('N/A'));
          //Estudios
          $('#estudios_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected")
            .text('N/A'));
          //Identidad
          $('#identidad_registro').append($('<option></option>').attr('value', 1).text('Apply'));
          $('#identidad_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected")
            .text('N/A'));
          //Globales
          $('#global_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected")
            .text('N/A'));
          //Migracion
          $('#migracion_registro').append($('<option></option>').attr('value', 1).text('Apply'));
          $('#migracion_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected")
            .text('N/A'));
          //Prohibited parties list
          $('#prohibited_registro').append($('<option></option>').attr('value', 1).text('Apply'));
          $('#prohibited_registro').append($('<option></option>').attr('value', 0).attr("selected",
            "selected").text('N/A'));
          //Age check
          $('#edad_registro').append($('<option></option>').attr('value', 1).text('Apply'));
          $('#edad_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected")
            .text('N/A'));
          //Motor vehicle records
          $('#mvr_registro').append($('<option></option>').attr('value', 1).text('Apply'));
          $('#mvr_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected").text(
            'N/A'));
        }
      });
      if (region == 'International') {
        $('#pais_registro').prop('disabled', false);
        $('#pais_registro').val('');
        $('#mvr_registro').val(0);
      } else {
        $('#pais_registro').prop('disabled', true);
        $('#pais_registro').val('México');
      }
      $('#proyecto_registro').prop('disabled', false);
    } else {
      $('#pais_registro').prop('disabled', true);
      $('#pais_registro').val('');
      $('#proyecto_registro').prop('disabled', true);
      $('#proyecto_registro').val('');
      $('.valor_dinamico').val('');
      $('.valor_dinamico').empty();
      $('.valor_dinamico').prop('disabled', true);
      $('#ref_profesionales_registro').val(0);
      $('#ref_personales_registro').val(0);
      $('#ref_academicas_registro').val(0);
    }
  });
  $('#extra_registro').change(function() {
    var id = $(this).val();
    if (id != '') {
      if (!extras.includes(id)) {
        var txt = $("#extra_registro option:selected").text();
        extras.push(id);
        //$("#extra_registro option[value='"+id+"']").remove();
        $('#div_docs_extras').append($('<div id="div_extra' + id +
          '" class="extra_agregado mb-1 d-flex justify-content-start"><h5 class="mr-5">Document added: <b>' +
          txt + '</b></h5><button type="button" class="btn btn-danger btn-sm" onclick="eliminarExtra(' + id +
          ',\'' + txt + '\')">X</button></div>'));
      }
    }
  })
  $("#previos").change(function() {
    var previo = $(this).val();
    if (previo != 0) {
      $.ajax({
        url: '<?php echo base_url('Candidato/getDetallesProyectoPrevio'); ?>',
        method: 'POST',
        data: {
          'id_previo': previo
        },
        success: function(res) {
          var parte = res.split('@@');
          $('#detalles_previo').empty();
          $('#detalles_previo').html(parte[0]);
          $('#pais_previo').prop('disabled', false);
          $('#pais_previo').empty();
          $('#pais_previo').html(parte[1]);
        }
      });
    } else {
      $('#detalles_previo').empty();
    }
  });

  function eliminarExtra(id_tipo_documento, txt) {
    for (var i = 0; i < extras.length; i++) {
      if (extras[i] == id_tipo_documento) {
        extras.splice(i, 1);
      }
    }
    $("#div_extra" + id_tipo_documento).remove();
    $('#extra_registro').append($('<option></option>').attr('value', id_tipo_documento).text(txt));
  }

  function nuevoRegistro() {
    var id = 205;
    $.ajax({
      url: '<?php echo base_url('Candidato/getSeccionesPrevias'); ?>',
      type: 'POST',
      data: {
        'id_cliente': id
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        $('#previos').html(res);
      }
    });
    $('#newModal').modal('show');
  }

  function registrar() {
    var id = 205;
    var correo = $("#correo_registro").val();
    var datos = new FormData();
    datos.append('correo', correo);
    datos.append('nombre', $("#nombre_registro").val());
    datos.append('paterno', $("#paterno_registro").val());
    datos.append('materno', $("#materno_registro").val());
    datos.append('celular', $("#celular_registro").val());
    datos.append('previo', $("#previos").val());
    datos.append('pais_previo', $("#pais_previo").val());
    datos.append('region', $("#region").val());
    datos.append('pais', $("#pais_registro").val());
    datos.append('proyecto', $("#proyecto_registro").val());
    datos.append('empleos', $("#empleos_registro").val());
    datos.append('empleos_tiempo', $("#empleos_tiempo_registro").val());
    datos.append('criminal', $("#criminal_registro").val());
    datos.append('criminal_tiempo', $("#criminal_tiempo_registro").val());
    datos.append('domicilios', $("#domicilios_registro").val());
    datos.append('domicilios_tiempo', $("#domicilios_tiempo_registro").val());
    datos.append('estudios', $("#estudios_registro").val());
    datos.append('identidad', $("#identidad_registro").val());
    datos.append('global', $("#global_registro").val());
    datos.append('ref_profesionales', $("#ref_profesionales_registro").val());
    datos.append('ref_personales', $("#ref_personales_registro").val());
    datos.append('credito', $("#credito_registro").val());
    datos.append('credito_tiempo', $("#credito_tiempo_registro").val());
    datos.append('id_cliente', id);
    datos.append('examen', $("#examen_registro").val());
    datos.append('medico', $("#examen_medico").val());
    datos.append('opcion', $("#opcion_registro").val());
    datos.append('migracion', $("#migracion_registro").val());
    datos.append('prohibited', $("#prohibited_registro").val());
    datos.append('edad', $("#edad_registro").val());
    datos.append('ref_academicas', $("#ref_academicas_registro").val());
    datos.append('mvr', $("#mvr_registro").val());
    datos.append('usuario', 2);
    for (var i = 0; i < extras.length; i++) {
      datos.append('extras[]', extras[i]);
    }
    $.ajax({
      url: '<?php echo base_url('Cliente_ESOLUTIONS/registrar'); ?>',
      type: 'POST',
      data: datos,
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        var data = JSON.parse(res);
        if (data.codigo === 1) {
          $("#newModal").modal('hide')
          recargarTable()
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'The candidate has successfully registered',
            showConfirmButton: false,
            timer: 2500
          })
        }
        if (data.codigo === 3) {
          $("#newModal").modal('hide');
          recargarTable();
          $("#user").text(correo);
          $("#contrasena").text(data.msg);
          $("#respuesta_mail").text(
            "* El correo no pudo ser enviado, mandar las credenciales del candidato de forma manual.");
          $("#passModal").modal('show');
          Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Se ha guardado correctamente pero hubo un problema al enviar el correo',
            showConfirmButton: false,
            timer: 2500
          })
        }
        if (data.codigo === 4) {
          $("#newModal").modal('hide');
          recargarTable();
          $("#user").text(correo);
          $("#contrasena").text(data.msg);
          $("#respuesta_mail").text(
            "* Un correo ha sido enviado al candidato con sus nuevas credenciales. Este correo puede demorar algunos minutos."
          );
          $("#passModal").modal('show');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Se ha guardado correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        }
        if (data.codigo === 0 || data.codigo === 2) {
          $("#newModal #msj_error").css('display', 'block').html(data.msg);
        }
      }
    });
  }

  function subirDoc() {
    var data = new FormData();
    var doc = $("#documento")[0].files[0];
    data.append('id_candidato', $(".idCandidato").val());
    data.append('tipo_doc', $("#tipo_archivo").val());
    data.append('documento', doc);
    $.ajax({
      url: "<?php echo base_url('Candidato/cargarDocumentoPanelCliente'); ?>",
      method: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        var data = JSON.parse(res);
        if (data.codigo === 1) {
          $("#documento").val("");
          $("#tablaDocs").empty();
          $('#tipo_archivo').val('');
          $("#tablaDocs").html(data.msg);
          $("#docsModal #msj_error").css('display', 'none')
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Se ha actualizado correctamente',
            showConfirmButton: false,
            timer: 2500
          })
        }
        if (data.codigo === 0) {
          $("#docsModal #msj_error").css('display', 'block').html(data.msg);
        }
      }
    });
  }

  function descargarZip() {
    let id_candidato = $(".idCandidato").val();
    $.ajax({
      url: "<?php echo base_url('Candidato/downloadDocumentosPanelCliente'); ?>",
      method: "POST",
      data: {
        'id_candidato': id_candidato
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        window.location = res;
      }
    });
  }

  function estatusOFAC() {
    var id_candidato = $(".idCandidato").val();
    var f = new Date();
    var dia = f.getDate();
    var mes = (f.getMonth() + 1);
    var dia = (dia < 10) ? '0' + dia : dia;
    var mes = (mes < 10) ? '0' + mes : mes;
    var h = f.getHours();
    var m = f.getMinutes();
    $.ajax({
      url: '<?php echo base_url('Candidato/checkOfac'); ?>',
      method: 'POST',
      data: {
        'id_candidato': id_candidato
      },
      dataType: "text",
      success: function(res) {
        $("#fecha_estatus_ofac").empty();
        $("#estatus_ofac").empty();
        $("#res_ofac").empty();
        $("#estatus_oig").empty();
        $("#res_oig").empty();
        var datos = res.split('@@');
        if (datos[0] == 0) {
          $("#fecha_titulo_ofac").html("<b>No date</b>");
          $("#estatus_ofac").html("<b>OFAC Status: </b>Not defined yet");
          $("#res_ofac").html("<b>Result:</b> Not defined yet");
          $("#estatus_oig").html("<b>OIG Status: </b>Not defined yet");
          $("#res_oig").html("<b>Result:</b> Not defined yet");
        } else {
          $("#fecha_titulo_ofac").html("<b>Last update</b>");
          $("#fecha_estatus_ofac").text(datos[0]);
          $("#estatus_ofac").html("<b>OFAC Status:</b> " + datos[1]);
          var res_ofac = (datos[2] == 1) ? "Positive" : "Negative";
          $("#res_ofac").html("<b>Result:</b> " + res_ofac);
          $("#estatus_oig").html("<b>OIG Status:</b> " + datos[3]);
          var res_oig = (datos[4] == 1) ? "Positive" : "Negative";
          $("#res_oig").html("<b>Result:</b> " + res_oig);
        }

      },
      error: function(res) {
        //$('#errorModal').modal('show');
      }
    });
    $("#ofacModal").modal("show");
  }

  function ejecutarAccion() {
    var accion = $("#btnGuardar").val();
    var id_candidato = $(".idCandidato").val();
    var correo = $(".correo").val();
    var motivo = $("#motivo").val();
    var usuario = 2;
    if (accion == 'cancel') {
      if (motivo == "") {
        $("#msg_accion").text("The comment is required");
        $("#msg_accion").css('display', 'block');
        setTimeout(function() {
          $('#msg_accion').fadeOut();
        }, 5000);
      } else {
        $.ajax({
          url: '<?php echo base_url('Candidato/cancel'); ?>',
          type: 'post',
          data: {
            'id_candidato': id_candidato,
            'motivo': motivo
          },
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 300);
            $("#quitarModal").modal('hide');
            recargarTable();
            $("#texto_msj").text('The candidate has been cancelled succesfully');
            $("#mensaje").css('display', 'block');
            setTimeout(function() {
              $('#mensaje').fadeOut();
            }, 3000);
          },
          error: function(res) {
            $('#errorModal').modal('show');
          }
        });
      }
    }
    if (accion == 'delete') {
      if (motivo == "") {
        $("#msg_accion").text("The reason is required");
        $("#msg_accion").css('display', 'block');
        setTimeout(function() {
          $('#msg_accion').fadeOut();
        }, 5000);
      } else {
        $.ajax({
          url: '<?php echo base_url('Candidato/accionCandidato'); ?>',
          type: 'post',
          data: {
            'id': id_candidato,
            'motivo': motivo,
            'usuario': usuario,
            'id_cliente': id_cliente
          },
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 300);
            $("#quitarModal").modal('hide');
            recargarTable();
            $("#texto_msj").text('The candidate has been deleted succesfully');
            $("#mensaje").css('display', 'block');
            setTimeout(function() {
              $('#mensaje').fadeOut();
            }, 3000);
          },
          error: function(res) {
            $('#errorModal').modal('show');
          }
        });
      }
    }
    if (accion == 'generate') {
      $.ajax({
        url: '<?php echo base_url('Candidato/generate'); ?>',
        type: 'post',
        data: {
          'id_candidato': id_candidato,
          'correo': correo
        },
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 300);
          $("#quitarModal").modal('hide');
          $("#user").text(correo);
          $("#pass").text(res);
          $("#respuesta_mail").text(
            "* An email has been sent with this credentials to the candidate. This email could take a few minutes to be delivered."
          );
          $("#passModal").modal('show');
          recargarTable();
          $("#texto_msj").text('The password has been created succesfully');
          $("#mensaje").css('display', 'block');
          setTimeout(function() {
            $('#mensaje').fadeOut();
          }, 3000);
        },
        error: function(res) {
          $('#errorModal').modal('show');
        }
      });
    }
  }

  function editarPerfil() {
    $.ajax({
      url: '<?php echo base_url('Usuario/getData'); ?>',
      method: "POST",
      success: function(res) {
        var dato = JSON.parse(res);
        $('#usuario_nombre').val(dato['nombre'])
        $('#usuario_paterno').val(dato['paterno'])
        $('#usuario_correo').val(dato['correo'])
        $('#usuario_nuevo_password').val('');
        $('#usuario_key').val(dato['clave']);
        $('#perfilUsuarioModal').modal('show');
        $('#recuperacion_correo').val(dato['correo'])
      }
    });
  }

  function convertirFechaHora(fecha) {
    var fechaArray = fecha.split(' ')
    var fecha = fechaArray[0].split('-')
    var fechaConvertida = fecha[2] + '/' + fecha[1] + '/' + fecha[0]
    var hora = fechaArray[1].split(':')
    var horaConvertida = hora[0] + ':' + hora[1]
    return fechaConvertida + ' ' + horaConvertida
  }

  function confirmarPassword() {
    $('#perfilUsuarioModal').modal('hide');
    $('#confirmarPasswordModal').modal('show');
  }

  function checkPasswordActual() {
    var nombre = $('#usuario_nombre').val();
    var paterno = $('#usuario_paterno').val();
    var correo = $('#usuario_correo').val();
    var nuevo_password = $('#usuario_nuevo_password').val();
    var password = $('#password_actual').val();
    var key = $('#usuario_key').val();
    $.ajax({
      url: '<?php echo base_url('Usuario/checkPasswordActual'); ?>',
      method: "POST",
      data: {
        'password': password,
        'nombre': nombre,
        'paterno': paterno,
        'correo': correo,
        'nuevo_password': nuevo_password,
        'key': key
      },
      beforeSend: function() {
        $('.loader').css("display", "block");
      },
      success: function(res) {
        setTimeout(function() {
          $('.loader').fadeOut();
        }, 200);
        var dato = JSON.parse(res);
        if (dato.codigo == 1) {
          $('#confirmarPasswordModal').modal('hide');
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: dato.msg,
            showConfirmButton: false,
            timer: 3500
          })
          setTimeout(function() {
            window.location.href = "<?php echo base_url(); ?>Login/logout";
          }, 3500);
        } else {
          $('#confirmarPasswordModal').modal('hide');
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: dato.msg,
            showConfirmButton: false,
            timer: 3500
          })
        }
      }
    });
  }
  //Verificacion de correo
  function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  function recargarTable() {
    $("#tabla").DataTable().ajax.reload();
  }
  $('#quitarModal').on('hidden.bs.modal', function(e) {
    $("#msg_accion").css('display', 'none');
    $(this)
      .find("input,textarea")
      .val('')
      .end();
  });
  $('#newModal').on('hidden.bs.modal', function(e) {
    $("#newModal #msj_error").css('display', 'none');
    $("#newModal input, #newModal select").val('');
    $('.valor_dinamico').val(0);
    $('.valor_dinamico, #detalles_previo, #pais_previo').empty();
    $('#pais_registro, #pais_previo').prop('disabled', true);
    //$('#pais_registro').val(-1);
    $('#proyecto_registro').prop('disabled', true);
    $('#proyecto_registro').val('');
    $('.valor_dinamico').prop('disabled', true);
    $('#ref_profesionales_registro').val(0);
    $('#ref_personales_registro').val(0);
    $('#ref_academicas_registro').val(0);
    $('#examen_registro, #examen_medico, #previo').val(0);
    $('#opcion_registro').val('').trigger('change');
    $('#div_docs_extras').empty();
    extras = [];
  });
  var hoy = new Date();
  var dd = hoy.getDate();
  var mm = hoy.getMonth() + 1;
  var yyyy = hoy.getFullYear();
  var hora = hoy.getHours() + ":" + hoy.getMinutes();

  if (dd < 10) {
    dd = '0' + dd;
  }

  if (mm < 10) {
    mm = '0' + mm;
  }
  </script>
</body>

</html>