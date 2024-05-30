<div class="modal fade" id="nuevoAspiranteModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Datos del aspirante</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAspirante">
          <div class="col-sm-12 ">
            <label for="buscador">Selecciona una Requisición :</label>
            <select name="req_asignada" id="req_asignada" class="selectpicker form-control" data-live-search="true"
              data-style="btn-custom-selectpicker" title="Selecciona" data-live-search="true">

              <?php
                if ($reqs) {
                  foreach ($reqs as $req) { ?>
              <option value="<?php echo $req->id; ?>">
                <?php echo '# '.$req->id.' '.$req->nombre.' - '.$req->puesto.' - Vacantes: '.$req->numero_vacantes; ?>
              </option>
              <?php 
          }
        }else{ ?>
              <option value="">Sin requisiones registradas</option>
              <?php } ?>
            </select>

          </div>
          <br>
          <div class="row mb-3">
            <div class="col-sm-12 col-md-4">
              <label>Nombre(s) *</label>
              <input type="text" class="form-control obligado" name="nombre" id="nombre"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
            <div class="col-sm-12 col-md-4">
              <label>Primer apellido *</label>
              <input type="text" class="form-control obligado" name="paterno" id="paterno"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
            <div class="col-sm-12 col-md-4">
              <label>Segundo apellido</label>
              <input type="text" class="form-control" name="materno" id="materno"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12">
              <label>Localización o domicilio *</label>
              <textarea class="form-control" name="domicilio" id="domicilio" rows="2"></textarea>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-12 col-md-4">
              <label>Área de interés *</label>
              <input type="text" id="area_interes" name="area_interes" class="form-control">
            </div>
            <div class="col-sm-12 col-md-4">
              <label>Medio de contacto *</label>
              <select name="medio" id="medio" class="form-control obligado">

                <option value="">Selecciona</option>
                <?php
              if($medios != null){
                foreach ($medios as $m) { ?>
                <option value="<?php echo $m->nombre; ?>"><?php echo $m->nombre; ?></option>
                <?php  
                } }?>
                <option value="0">N/A</option>
              </select>
            </div>
            <div class="col-sm-12 col-md-4">
              <label>Teléfono *</label>
              <input type="text" id="telefono" name="telefono" class="form-control">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-12 col-md-4">
              <label>Correo</label>
              <input type="text" id="correo" name="correo" class="form-control">
              <input type="hidden" id="idAspirante" name="idAspirante">
              <input type="hidden" id="idBolsa" name="idBolsa">

            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="addApplicant()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal para cargar CV -->
<div class="modal fade" id="modalCargaCV" tabindex="-1" role="dialog" aria-labelledby="modalCargaCVLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCargaCVLabel">Cargar CV/Solicitud</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Aquí coloca el formulario para cargar el CV -->
        <form id="formularioCargaCV" enctype="multipart/form-data">
          <div class="form-group">
            <label for="cv">Selecciona tu CV/Solicitud:</label>
            <input type="file" class="form-control-file" id="id_cv" name="id_cv" required>
            <input type="hidden" class="form-control-file" id="id_aspirante" name="id_aspirante" required>
          </div>
          <!-- Agrega el atributo onclick para llamar a la función -->
          <button type="button" class="btn btn-primary" onclick="subirCVReqAspirante()">Cargar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="nuevaAccionModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Registro de acción al aspirante: <br><span class="nombreAspirante"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAccion">
          <div class="row">
            <div class="col-12">
              <label>Acción a aplicar *</label>
              <select name="accion_aspirante" id="accion_aspirante" class="form-control obligado">
                <option value="">Selecciona</option>
                <?php if($acciones != null){
                foreach ($acciones as $a) { ?>
                <option value="<?php echo $a->id.':'.$a->descripcion; ?>"><?php echo $a->descripcion; ?></option>
                <?php   
                } }?>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Comentario / Descripción / Fecha y lugar *</label>
              <textarea class="form-control" id="accion_comentario" name="accion_comentario" rows="4"></textarea>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarAccion()">Registrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="historialModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Historial de movimientos del aspirante: <br><span class="nombreAspirante"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="div_historial_aspirante"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="estatusRequisicionModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Estatus de requisición</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formEstatusReq">
          <div class="row">
            <div class="col-12">
              <label>Requisición *</label>
              <select name="req_estatus" id="req_estatus" class="selectpicker form-control"
                data-style="btn-custom-selectpicker" data-live-search="true">
                <option value="">Selecciona</option>
                <?php
                if ($reqs) {
                  foreach ($reqs as $req) { ?>
                <option value="<?php echo $req->id; ?>">
                  <?php echo '#'.$req->id.' '.$req->nombre.' - '.$req->puesto.' - Vacantes: '.$req->numero_vacantes; ?>
                </option>
                <?php   
                  }
                } ?>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12 col-md-4 offset-4">
              <label>Estatus a asignar *</label>
              <select name="asignar_estatus" id="asignar_estatus" class="form-control obligado">
                <option value="">Selecciona</option>
                <option value="3">Terminar</option>
                <option value="0">Cancelar</option>
                <option value="1">Eliminar</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Comentarios *</label>
              <textarea class="form-control" name="comentario_estatus" id="comentario_estatus" rows="4"></textarea>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarEstatusRequisicion()">Guardar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="reactivarRequisicionModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Reactivar requisición</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <label>Requisición *</label>
            <select name="reactivar_req" id="reactivar_req" class="form-control obligado">
              <option value="">Selecciona</option>
              <?php
              if ($reqs) {
                foreach ($reqs as $req) { ?>
              <option value="<?php echo $req->id; ?>">
                <?php echo '#'.$req->id.' '.$req->nombre.' - '.$req->puesto.' - Vacantes: '.$req->numero_vacantes; ?>
              </option>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="reactivarsRequisicion()">Guardar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="empleosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Historial de empleos de: <br><span class="nombreRegistro"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="div_historial_empleos"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="registroCandidatoModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo $this->lang->line('register_candidate'); ?></h4>
        
        <div id="language-switch">
          <label for="language-select">Language:</label>
          <select id="language-select" onchange="switchLanguage(this.value);">
            <option value="english">English</option>
            <option value="spanish">Español</option>
          </select>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        
      </div>
     
      <div class="modal-body">
        <div class="alert alert-info text-center"><?php echo $this->lang->line('general_data'); ?></div>
        <form id="nuevoRegistroForm">
          <div class="row">
            <div class="col-4">
              <label>Nombre(s) *</label>
              <input type="text" class="form-control obligado" name="nombre_registro" id="nombre_registro"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-4">
              <label>Apellido paterno *</label>
              <input type="text" class="form-control obligado" name="paterno_registro" id="paterno_registro"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-4">
              <label>Apellido materno</label>
              <input type="text" class="form-control" name="materno_registro" id="materno_registro"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <label>Subcliente (Proveedor) *</label>
              <select name="subcliente" id="subcliente" class="form-control obligado">
                <option value="0">N/A</option>
              </select>
              <br>
            </div>
            <?php 
            $id_cliente = $this->uri->segment(3);
            if($id_cliente != 172){ ?>
            <div class="col-4">
              <label>Puesto *</label>
              <select name="puesto" id="puesto" class="form-control"></select>
              <br>
            </div>
            <?php 
            }
            else{ ?>
            <div class="col-4">
              <label>Puesto *</label>
              <input type="text" class="form-control obligado" name="puesto" id="puesto">
              <br>
            </div>
            <?php
            } ?>
            <div class="col-4">
              <label>Teléfono *</label>
              <input type="text" class="form-control obligado" name="celular_registro" id="celular_registro"
                maxlength="16">
              <input type="hidden" class="form-control obligado" name="id_cliente_portal" id="id_cliente_portal">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <label>País donde reside *</label>
              <select class="form-control" id="pais" name="pais">
                <?php
                  if($paises != null){
                  foreach ($paises as $p) {
                    $default = ($p->nombre == 'México')? 'selected' : ''; ?>
                <option value="<?php echo $p->nombre; ?>" <?php echo $default ?>><?php echo $p->nombre; ?></option>
                <?php
                  } }
                ?>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label>Correo </label>
              <input type="text" class="form-control obligado" name="correo_registro" id="correo_registro">
              <br>
            </div>
            <div class="col-4">
              <label>CURP</label>
              <input type="text" class="form-control obligado" name="curp_registro" id="curp_registro"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                maxlength="18">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <label>Numero de Seguro Social (NSS)</label>
              <input type="text" class="form-control obligado" name="nss_registro" id="nss_registro" maxlength="11">
            </div>
          </div>
          <br><br>
          <div class="alert alert-warning text-center">Choose a previous project or create another one. <br>Notes: <br>
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
                foreach ($paises_estudio as $pe) { ?>
                <option value="<?php echo $pe->nombre_espanol; ?>"><?php echo $pe->nombre_ingles; ?></option>
                <?php
                } ?>
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
              <li>The required documents will add automatically depending of the selected options . The extra documents
                are optional, select them before the complementary tests.</li>
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
              <select name="global_registro" id="global_registro" class="form-control valor_dinamico registro_obligado"
                disabled></select>
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
              <label>Academic References (quantity)</label>
              <input type="number" class="form-control valor_dinamico" id="ref_academicas_registro"
                name="ref_academicas_registro" value="0" disabled>
              <br>
            </div>
          </div>
          <div class="row div_check">
            <div class="col-md-6">
              <label>Motor Vehicle Records (only in some Mexico cities) *</label>
              <select name="mvr_registro" id="mvr_registro" class="form-control valor_dinamico registro_obligado"
                disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>CURP check *</label>
              <select name="curp_registro" id="curp_registro" class="form-control valor_dinamico registro_obligado"
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
                <option value="15">Military document</option>
                <option value="14">Passport</option>
                <option value="10">Professional licence</option>
                <option value="48">Academic / Professional Credential</option>
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
            <div class="col-md-4">
              <label>Drug test *</label>
              <select name="examen_registro" id="examen_registro" class="form-control registro_obligado">
                <option value="">Select</option>
                <option value="0" selected>N/A</option>
                <?php
                foreach ($paquetes_antidoping as $paq) { ?>
                <option value="<?php echo $paq->id; ?>"><?php echo $paq->nombre.' ('.$paq->conjunto.')'; ?></option>
                <?php
                } ?>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Medical test *</label>
              <select name="examen_medico" id="examen_medico" class="form-control registro_obligado">
                <option value="0">N/A</option>
                <option value="1">Apply</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Psicométric *</label>
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


<div class="modal fade" id="historialComentariosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Historial de comentarios con respecto a: <br><span class="nombreRegistro"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
            <button type="button" class="btn btn-primary text-lg btn-block" id="btnComentario">Guardar
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


<div class="modal fade" id="nuevaRequisicionModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl custom_modal_size" role="document">
    <div class="modal-content">

      <div class="modal-body">
        <div>
          <button type="button" class="close custom_modal_close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="alert alert-info">
          Este formulario permite registrar una requisición de manera completa o parcial. Cada paso está dividido en dos
          secciones, siendo la sección superior la que solicita los datos elementales para crear una requisición de
          manera rápida.
        </div>
        <div class="row justify-content-center align-items-center text-center mb-3">
          <div class="col-1">
            <button type="button" class="btn btn-primary" id="paso1">1</button>
          </div>
          <div class="col-1 barra_espaciadora_off" id="barra1"></div>
          <div class="col-1">
            <button type="button" class="btn btn-primary" id="paso2">2</button>
          </div>
          <div class="col-1 barra_espaciadora_off" id="barra2"></div>
          <div class="col-1">
            <button type="button" class="btn btn-primary" id="paso3">3</button>
          </div>
        </div>
        <h5 class="text-center" id="titulo_paso"></h5>
        <form id="formPaso1">
          <div class="row mb-3">
            <div class="col-sm-12 col-md-6">
              <label for="id_cliente">Cliente *</label>
              <select name="id_cliente" id="id_cliente" class="form-control acceso_obligado">
              </select>
              <br>
            </div>
            <div class="col-6">

              <label for="nombre_comercial_req">Nombre comercial *</label>
              <input type="text" class="form-control" data-required="required" data-field="Nombre comercial"
                name="nombre_comercial_req" id="nombre_comercial_req"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>

          </div>
          <div class="row mb-3">
            <div class="col-6">
              <label for="nombre_req">Razón social </label>
              <input type="text" class="form-control" data-required="required" data-field="Razón social"
                name="nombre_req" id="nombre_req"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
            <div class="col-6">
              <label for="correo_req">Correo </label>
              <input type="text" class="form-control" data-field="Correo" name="correo_req" id="correo_req">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-3">
              <label for="cp_req">Código postal </label>
              <input type="number" class="form-control" data-field="Código postal" name="cp_req" id="cp_req"
                maxlength="5">
            </div>
            <div class="col-3">
              <label for="telefono_req">Teléfono</label>
              <input type="text" class="form-control" data-field="Teléfono" name="telefono_req" id="telefono_req"
                maxlength="16">
            </div>
            <div class="col-3">
              <label for="contacto_req">Contacto</label>
              <input type="text" class="form-control" data-field="Contacto" name="contacto_req" id="contacto_req">
            </div>
            <div class="col-3">
              <label for="rfc_req">RFC </label>
              <input type="text" class="form-control" data-field="RFC" name="rfc_req" id="rfc_req" maxlength="13"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
          </div>
          <hr>
          <p style="text-align: center; color: #808080;""> Datos Para llenar Requisicion Completa ↓</p>
        <hr>
        <div class=" row">
          <div class="col-md-3">
            <label for="pais_req">País *</label>
            <input type="text" class="form-control" id="pais_req" name="pais_req">
          </div>
          <div class="col-md-3">
            <label for="estado_req">Estado *</label>
            <input type="text" class="form-control" id="estado_req" name="estado_req">
          </div>
          <div class="col-md-3">
            <label for="ciudad_req">Ciudad *</label>
            <input type="text" class="form-control" id="ciudad_req" name="ciudad_req">
          </div>
          <div class="col-md-3">
            <label for="colonia_req">Colonia *</label>
            <input type="text" class="form-control" id="colonia_req" name="colonia_req">
          </div>
      </div>
      <div class="row mt-3">

        <div class="col-md-8">
          <label for="calle_req">Calle *</label>
          <input type="text" class="form-control" id="calle_req" name="calle_req">
        </div>
        <div class="col-md-2">
          <label for="interior_req">Interior</label>
          <input type="text" class="form-control" id="interior_req" name="interior_req">
        </div>
        <div class="col-md-2">
          <label for="num_exterior">Exterior</label>
          <input type="text" class="form-control" id="exterior_req" name="exterior_req">
        </div>

      </div>
      <br>
      <div class="row mb-3">

        <div class="col-3">
          <label for="regimen_req">Régimen Fiscal *</label>
          <div class="input-group mb-3">

            <input type="text" class="form-control" id="regimen_req" name="regimen_req">
          </div>
          <div id="errorregimen" class="text-danger"></div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-3">
          <label for="forma_pago">Forma de pago *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-credit-card"></i></span>
            </div>
            <select class="custom-select" id="forma_pago_req" name="forma_pago_req">
              <option value="" selected>Selecciona</option>
              <option value="Pago en una sola exhibición">Pago en una sola exhibición</option>
              <option value="Pago en parcialidades o diferidos">Pago en parcialidades o diferidos</option>
            </select>
            <div id="forma_pago" class="text-danger"></div>
          </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-3">
          <label for="metodo_pago">Método de pago *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-credit-card"></i></span>
            </div>
            <select class="custom-select" id="metodo_pago_req" name="metodo_pago_req">
              <option value="" selected>Selecciona</option>
              <option value="Efectivo">Efectivo</option>
              <option value="Cheque de nómina">Cheque de nómina</option>
              <option value="Transferencia electrónica">Transferencia electrónica</option>
              <option value="Tarjeta de crédito">Tarjeta de crédito</option>
              <option value="Tarjeta de débito">Tarjeta de débito</option>
              <option value="Por definir">Por definir</option>
            </select>
          </div>
        </div>
        <div class="col-3">
          <label for="puesto_req">Uso de CFDI</label>
          <input type="text" class="form-control" data-field="Uso de CFDI" name="uso_cfdi_req" id="uso_cfdi_req"
            value="Gastos Generales">
        </div>
      </div>

      </form>
      <form id="formPaso2" class="hidden">
        <div class="row mb-3">
          <div class="col-6">
            <label for="puesto_req">Nombre de la posición *</label>
            <input type="text" class="form-control" data-field="Nombre de la posición" name="puesto_req"
              id="puesto_req">
          </div>
          <div class="col-6">
            <label for="numero_vacantes_req">Número de vacantes *</label>
            <input type="number" class="form-control" data-field="Número de vacantes" name="numero_vacantes_req"
              id="numero_vacantes_req">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12">
            <label for="residencia_req">Lugar de residencia </label>
            <textarea class="form-control" data-field="Lugar de residencia" name="residencia_req" id="residencia_req"
              rows="2"></textarea>
          </div>
        </div>
        <hr>
        <p style="text-align: center; color: #808080;""> Datos Para llenar Requisicion Completa ↓</p>
        <hr>
        <div class=" row">
        <div class="col-sm-12 col-md-4 col-lg-4">
          <label for="escolaridad">Formación académica requerida *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
            </div>
            <select class="custom-select" id="escolaridad_req" name="escolaridad_req"
              data-siguiente-campo="estatus_escolaridad">
              <option value="" selected>Selecciona</option>
              <option value="Primaria">Primaria</option>
              <option value="Secundaria">Secundaria</option>
              <option value="Bachiller">Bachiller</option>
              <option value="Licenciatura">Licenciatura</option>
              <option value="Maestría">Maestría</option>
            </select>
          </div>
          <div id="errorescolaridad" class="text-danger"></div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
          <label for="estatus_escolaridad">Estatus académico *</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
            </div>
            <select class="custom-select" id="estatus_escolaridad_req" name="estatus_escolaridad_req"
              data-siguiente-campo="carrera">
              <option value="" selected>Selecciona</option>
              <option value="Técnico">Técnico</option>
              <option value="Pasante">Pasante</option>
              <option value="Estudiante">Estudiante</option>
              <option value="Titulado">Titulado</option>
              <option value="Trunco">Trunco</option>
              <option value="Otro">Otro</option>
            </select>
          </div>
          <div id="errorestatus_escolaridadd" class="text-danger"></div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
          <label for="otro_estatus_req">Otro estatus académico</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
            </div>
            <input type="text" class="form-control" id="otro_estatus_req" name="otro_estatus_req">
          </div>
        </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6">
        <label for="carrera">Carrera requerida para el puesto *</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
          </div>
          <input type="text" class="form-control" id="carrera_req" name="carrera_req" data-siguiente-campo="genero">
        </div>
        <div id="errorcarrera" class="text-danger"></div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-6">
        <label for="otros_estudios">Otros estudios</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
          </div>
          <input type="text" class="form-control" id="otros_estudios_req" name="otros_estudios_req">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-2 col-lg-2">
        <label for="idioma1">Idioma nativo</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-language"></i></span>
          </div>
          <input type="text" class="form-control" id="idioma1_req" name="idioma1_req">
        </div>
      </div>
      <div class="col-sm-12 col-md-2 col-lg-2">
        <label for="por_idioma1">Porcentaje del idioma nativo</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
          <input type="number" class="form-control" id="por_idioma1_req" name="por_idioma1_req">
        </div>
      </div>
      <div class="col-sm-12 col-md-2 col-lg-2">
        <label for="idioma2">Segundo idioma</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-language"></i></span>
          </div>
          <input type="text" class="form-control" id="idioma2_req" name="idioma2_req">
        </div>
      </div>
      <div class="col-sm-12 col-md-2 col-lg-2">
        <label for="por_idioma2">Porcentaje del segundo idioma</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
          <input type="number" class="form-control" id="por_idioma2_req" name="por_idioma2_req">
        </div>
      </div>
      <div class="col-sm-12 col-md-2 col-lg-2">
        <label for="idioma3">Tercer idioma </label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-language"></i></span>
          </div>
          <input type="text" class="form-control" id="idioma3_req" name="idioma3_req">
        </div>
      </div>
      <div class="col-sm-12 col-md-2 col-lg-2">
        <label for="por_idioma3">Porcentaje del tercer idioma</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
          <input type="number" class="form-control" id="por_idioma3_req" name="por_idioma3_req">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-2 col-lg-2">
        <label for="habilidad1">Habilidad informática requerida</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-laptop"></i></span>
          </div>
          <input type="text" class="form-control" id="habilidad1_req" name="habilidad1_req">
        </div>
      </div>
      <div class="col-sm-12 col-md-2 col-lg-2">
        <label for="por_habilidad1">Porcentaje de la habilidad</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
          <input type="number" class="form-control" id="por_habilidad1_req" name="por_habilidad1_req">
        </div>
      </div>
      <div class="col-sm-12 col-md-2 col-lg-2">
        <label for="habilidad2">Otra habilidad informática</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-laptop"></i></span>
          </div>
          <input type="text" class="form-control" id="habilidad2_req" name="habilidad2_req">
        </div>
      </div>
      <div class="col-sm-12 col-md-2 col-lg-2">
        <label for="por_habilidad2">Porcentaje de la habilidad</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
          <input type="number" class="form-control" id="por_habilidad2_req" name="por_habilidad2_req">
        </div>
      </div>
      <div class="col-sm-12 col-md-2 col-lg-2">
        <label for="habilidad3">Otra habilidad informática </label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-laptop"></i></span>
          </div>
          <input type="text" class="form-control" id="habilidad3_req" name="habilidad3_req">
        </div>
      </div>
      <div class="col-sm-12 col-md-2 col-lg-2">
        <label for="por_habilidad3">Porcentaje de la habilidad</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-percentage"></i></span>
          </div>
          <input type="number" class="form-control" id="por_habilidad3_req" name="por_habilidad3_req">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-3 col-lg-3">
        <label for="genero">Sexo *</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
          </div>
          <select class="custom-select" id="genero_req" name="genero_req" data-siguiente-campo="civil">
            <option value="NULL" selected>Selecciona</option>
            <option value="Femenino">Femenino</option>
            <option value="Masculino">Masculino</option>
            <option value="Indistinto">Indistinto</option>
          </select>
        </div>
        <div id="errorgenero" class="text-danger"></div>
      </div>
      <div class="col-sm-12 col-md-3 col-lg-3">
        <label for="civil">Estado civil *</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
          </div>
          <select class="custom-select" id="civil_req" name="civil_req" data-siguiente-campo="edad_minima">
            <option value="NULL" selected>Selecciona</option>
            <option value="Soltero(a)">Soltero(a)</option>
            <option value="Casado(a)">Casado(a)</option>
            <option value="Indistinto">Indistinto</option>
          </select>
        </div>
        <div id="errorcivil" class="text-danger"></div>
      </div>
      <div class="col-sm-12 col-md-3 col-lg-3">
        <label for="edad_minima">Edad mínima *</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-minus"></i></span>
          </div>
          <input type="number" id="edad_minima_req" name="edad_minima_req" class="form-control"
            data-siguiente-campo="edad_maxima">
        </div>
        <div id="erroredad_minima" class="text-danger"></div>
      </div>
      <div class="col-sm-12 col-md-3 col-lg-3">
        <label for="edad_maxima">Edad máxima *</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-plus"></i></span>
          </div>
          <input type="number" id="edad_maxima_req" name="edad_maxima_req" class="form-control"
            data-siguiente-campo="licencia">
        </div>
        <div id="erroredad_maxima" class="text-danger"></div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-3 col-lg-3">
        <label for="licencia">Licencia de conducir *</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
          </div>
          <select class="custom-select" id="licencia_req" name="licencia_req" data-siguiente-campo="tipo_licencia">
            <option value="" selected>Selecciona</option>
            <option value="Indispensable">Indispensable</option>
            <option value="Deseable">Deseable</option>
            <option value="No necesaria">No necesaria</option>
          </select>
        </div>
        <div id="errorlicencia" class="text-danger"></div>
      </div>
      <div class="col-sm-12 col-md-3 col-lg-3">
        <label for="tipo_licencia_req">Tipo de licencia de conducir*</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
          </div>
          <input type="text" class="form-control" id="tipo_licencia_req" name="tipo_licencia_req"
            data-siguiente-campo="discapacidad">
        </div>
        <div id="errortipo_licencia" class="text-danger"></div>
      </div>
      <div class="col-sm-12 col-md-3 col-lg-3">
        <label for="discapacidad">Discapacidad aceptable *</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-wheelchair"></i></span>
          </div>
          <select class="custom-select" id="discapacidad" name="discapacidad_req"
            data-siguiente-campo="discapacidad_req">
            <option value="NULL" selected>Selecciona</option>
            <option value="Motora">Motora</option>
            <option value="Auditiva">Auditiva</option>
            <option value="Visual">Visual</option>
            <option value="Motora y auditiva">Motora y auditiva</option>
            <option value="Motora y visual">Motora y visual</option>
            <option value="Sin discapacidad">Sin discapacidad</option>
          </select>
        </div>
        <div id="errordiscapacidad" class="text-danger"></div>
      </div>
      <div class="col-sm-12 col-md-3 col-lg-3">
        <label for="causa">Causa que origina la vacante *</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="far fa-question-circle"></i></span>
          </div>
          <select class="custom-select" id="causa_req" name="causa_req" data-siguiente-campo="residencia">
            <option value="NULL" selected>Selecciona</option>
            <option value="Empresa nueva">Empresa nueva</option>
            <option value="Empleo temporal">Empleo temporal</option>
            <option value="Puesto de nueva creación">Puesto de nueva creación</option>
            <option value="Reposición de personal">Reposición de personal</option>
          </select>
        </div>
        <div id="errorcausa" class="text-danger"></div>
      </div>
    </div>
    </form>
    <form id="formPaso3" class="hidden">
      <div class="row mb-3">
        <div class="col-12">
          <label for="zona_req">Domicilio de trabajo *</label>
          <textarea class="form-control" data-required="required" data-field="Zona de trabajo" name="zona_req"
            id="zona_req" rows="2"></textarea>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-3">
          <label for="tipo_sueldo_req">Tipo de sueldo *</label>
          <select class="form-control" data-required="required" data-field="Tipo de sueldo" id="tipo_sueldo_req"
            name="tipo_sueldo_req">
            <option value="NULL" selected>Selecciona</option>
            <option value="Neto">Neto (Libre)</option>
            <option value="Nominal">Nominal(Salario bruto)</option>
          </select>
        </div>
        <div class="col-3">
          <label for="sueldo_minimo_req">Sueldo mínimo </label>
          <input type="number" class="form-control" data-field="Sueldo mínimo" id="sueldo_minimo_req"
            name="sueldo_minimo_req">
        </div>
        <div class="col-3">
          <label for="sueldo_maximo_req">Sueldo máximo </label>
          <input type="number" class="form-control" data-field="Sueldo máximo" id="sueldo_maximo_req"
            name="sueldo_maximo_req">
        </div>
        <div class="col-3">
          <label for="tipo_pago_req">Tipo de pago *</label>
          <select class="form-control" data-required="required" data-field="Tipo de pago" id="tipo_pago_req"
            name="tipo_pago_req">
            <option value="NULL" selected>Selecciona</option>
            <option value="Mensual">Mensual</option>
            <option value="Quincenal">Quincenal</option>
            <option value="Semanal">Semanal</option>
          </select>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-3">
          <label for="ley_req">¿Tendrá prestaciones de ley? *</label>
          <select class="form-control" data-required="required" data-field="¿Tendrá prestaciones de ley?"
            id="tipo_prestaciones_req" name="tipo_prestaciones_req">
            <option value="" selected>Selecciona</option>
            <option value="SI">SI</option>
            <option value="NO">NO</option>
          </select>
        </div>
        <div class="col-9">
          <label for="experiencia_req">Se requiere experiencia en</label>
          <textarea class="form-control" data-field="Se requiere experiencia en" name="experiencia_req"
            id="experiencia_req" rows="2"></textarea>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12">
          <label for="observaciones_req">Observaciones</label>
          <textarea class="form-control" data-field="Observaciones" name="observaciones_req" id="observaciones_req"
            rows="2"></textarea>
        </div>
      </div>
      <hr>
      <p style="text-align: center; color: #808080;""> Datos Para llenar Requisicion Completa ↓</p>
        <hr>


        <div class=" card-body">
      <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4">
          <label class="container_checkbox">Comunicación
            <input type="checkbox" name="competencias[]" id="Comunicación" value="Comunicación">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Análisis
            <input type="checkbox" name="competencias[]" id="Análisis" value="Análisis">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Liderazgo
            <input type="checkbox" name="competencias[]" id="Liderazgo" value="Liderazgo">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Negociación
            <input type="checkbox" name="competencias[]" id="Negociación" value="Negociación">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Apego a normas
            <input type="checkbox" name="competencias[]" id="Apego" value="Apego">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Planeación
            <input type="checkbox" name="competencias[]" id="Planeación" value="Planeación">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Organización
            <input type="checkbox" name="competencias[]" id="Organización" value="Organización">
            <span class="checkmark"></span>
          </label>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
          <label class="container_checkbox">Orientado a resultados
            <input type="checkbox" name="competencias[]" id="Orientado_resultados" value="Orientado_resultados">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Manejo de conflictos
            <input type="checkbox" name="competencias[]" id="Manejo-conflictos" value="Manejo-conflictos">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Trabajo en equipo
            <input type="checkbox" name="competencias[]" id="Trabajo_equipo" value="Trabajo-equipo">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Toma de decisiones
            <input type="checkbox" name="competencias[]" id="Toma-decisiones" value="Toma_decisiones">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Trabajo bajo presión
            <input type="checkbox" name="competencias[]" id="Trabajo-presion" value="Trabajo-presion">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Don de mando
            <input type="checkbox" name="competencias[]" id="Don_mando" value="Don-mando">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Versátil
            <input type="checkbox" name="competencias[]" id="Versátil" value="Versátil">
            <span class="checkmark"></span>
          </label>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
          <label class="container_checkbox">Sociable
            <input type="checkbox" name="competencias[]" id="Sociable" value="Sociable">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Intuitivo
            <input type="checkbox" name="competencias[]" id="Intuitivo" value="Intuitivo">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Autodidacta
            <input type="checkbox" name="competencias[]" id="Autodidacta" value="Autodidacta">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Creativo
            <input type="checkbox" name="competencias[]" id="Creativo" value="Creativo">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Proactivo
            <input type="checkbox" name="competencias[]" id="Proactivo" value="Proactivo">
            <span class="checkmark"></span>
          </label>
          <label class="container_checkbox">Adaptable
            <input type="checkbox" name="competencias[]" id="Adaptable" value="Adaptable">
            <span class="checkmark"></span>
          </label>
        </div>
      </div>

  </div>

  </form>
</div>
<div class="modal-footer custom_modal_footer">
  <button type="button" class="btn btn-primary btn-icon-split" id="btnRegresar">
    <span class="icon text-white-50">
      <i class="fas fa-arrow-left"></i>
    </span>
    <span class="text">Regresar</span>
  </button>
  <button type="button" class="btn btn-success btn-icon-split" id="btnContinuar">
    <span class="text"></span>
    <span class="icon text-white-50">
      <i class="fas fa-arrow-right"></i>
    </span>
  </button>
</div>
</div>
</div>
</div>



<div class="modal fade" id="asignarUsuarioModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titulo_asignarUsuarioModal"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAsignacion">
          <div class="row mb-3">
            <div class="col-md-12">
              <label for="asignar_usuario"></label>
              <select id="asignar_usuario" class="form-control selectpicker dropup" data-dropup-auto="false"
                data-live-search="true" data-style="btn-custom-selectpicker" title="Selecciona"
                data-selected-text-format="count > 4" multiple>
                <?php 
                if(!empty($usuarios_asignacion)){
                  foreach($usuarios_asignacion as $row){ ?>
                <option value="<?php echo $row->id ?>"><?php echo $row->usuario ?></option>
                <?php 
                  }
                }else{ ?>
                <option value="">No hay usuarios correspondientes</option>
                <?php 
                } ?>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <label for="asignar_registro"></label>
              <select name="asignar_registro" id="asignar_registro" class="form-control selectpicker"
                data-live-search="true" data-style="btn-custom-selectpicker" title="Selecciona" data-size="10">
                <?php 
                if(!empty($registros_asignacion)){
                  foreach($registros_asignacion as $fila){ ?>
                <option value="<?php echo $fila->id ?>">
                  <?php echo '#'.$fila->id.'  '.$fila->nombreCompleto. (!empty($fila->puesto) ? ' Puesto: '.$fila->puesto : ''); ?>
                </option>
                <?php 
                  }
                }else{ ?>
                <option value="">No hay registros para asignar</option>
                <?php 
                } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnAsignar">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="resultadosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Resultados de los estudios y exámenes de los candidatos de la Requisición: <br><span
            class="nombreRegistro"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="divContenido"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="subirCSVModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formImportarPuestos">
          <div class="row">
            <div class="col-12">
              <label for="archivo_csv" id="label"></label>
              <input type="file" class="form-control" name="archivo_csv" id="archivo_csv"
                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
              <br>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnSubir">Enviar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ingresoCandidatoModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Información de ingreso al empleo del candidato: <br><span class="nombreRegistro"></span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info text-center">Registros del estatus de la garantía</div>
        <div id="divHistorialGarantia" class="escrolable"></div>

        <form id="formIngreso">
          <div class="row mb-3">
            <div class="col-4">
              <label>Sueldo acordado *</label>
              <input type="text" class="form-control" id="sueldo_acordado" name="sueldo_acordado">
            </div>
            <div class="col-4">
              <label>Fecha de ingreso a la empresa *</label>
              <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso">
            </div>
            <div class="col-4">
              <label>Pago</label>
              <input type="text" class="form-control" id="pago" name="pago">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12">
              <label for="garantia">Estatus de la garantia</label>
              <textarea class="form-control" name="garantia" id="garantia" rows="3"></textarea>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-12">
              <button type="button" class="btn btn-primary text-lg btn-block" onclick="updateAdmission()">Guardar
                información</button>
            </div>
          </div>
      </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="avancesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Mensajes de avances del candidato: <br><span id="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row escrolable" id="divMensajesAvances"></div>
        <div class="margen" id="div_estatus_avances">
          <div class="mt-3 alert alert-info text-center">Nuevo mensaje</div>
          <div class="row">
            <div class="col-12">
              <label for="mensaje_avance">Comentario o Estatus *</label>
              <textarea class="form-control" name="mensaje_avance" id="mensaje_avance" rows="3"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label for="adjunto">Adjuntar imagen de apoyo</label>
              <input type="file" id="adjunto" name="adjunto" class="form-control" accept=".jpg, .jpeg, .png"><br>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="crearAvance()">Agregar</button>
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
        <div id="campos_mensaje"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnConfirmar">Confirmar</button>
      </div>
    </div>
  </div>
</div>


<script>
var urltraerClientes = '<?php echo base_url('Cat_Cliente/getClientesActivos'); ?>';
var urlCargarDatosCliente = '<?php echo base_url('Cat_Cliente/getClientesPorId'); ?>';
</script>

<script>
var pag = 1;
$('.div_info_project, .div_project, .div_info_previo, .div_previo, .div_info_check, .div_check, .div_info_test, .div_test, .div_info_extra, .div_extra')
  .css('display', 'none');
$('#registroCandidatoModal').on('hidden.bs.modal', function(e) {
  $("#registroCandidatoModal #msj_error").css('display', 'none');
  $("#registroCandidatoModal input, #registroCandidatoModal select").val('');
  $('.valor_dinamico').val(0);
  $('.valor_dinamico, #detalles_previo, #pais_previo').empty();
  $('#pais_registro, #pais_previo').prop('disabled', true);
  //$('#pais_registro').val(-1);
  $('#proyecto_registro').prop('disabled', true);
  $('#proyecto_registro').val('');
  $('.valor_dinamico').prop('disabled', true);
  $('#ref_profesionales_registro').val(0);
  $('#ref_personales_registro').val(0);
  $('#examen_registro, #examen_medico, #previo').val(0);
  $('#opcion_registro').val('').trigger('change');
  $('#div_docs_extras').empty();
  extras = [];
});
$("#opcion_registro").change(function() {
  var opcion = $(this).val();
  $('.div_info_project').css('display', 'block');
  $('.div_project').css('display', 'flex');
  $('.div_info_test').css('display', 'block');
  $('.div_test').css('display', 'flex');
  $("#registroCandidatoModal #msj_error").css('display', 'none');
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
$('#nuevaRequisicionModal').on('shown.bs.modal', function(e) {
  cargarClientesActivos(urltraerClientes);
  $("#nuevaRequisicionModal #titulo_paso").text('Datos  ');
  $("#nuevaRequisicionModal #btnContinuar span.text").text('Continuar');
  $("#nuevaRequisicionModal #btnRegresar, #nuevaRequisicionModal #paso2, #nuevaRequisicionModal #paso3").prop(
    'disabled', true);
});
$('#nuevaRequisicionModal #btnContinuar').on('click', function() {
  var formulario_actual = document.getElementById('formPaso' + pag);
  var todoCorrecto = true;
  var formulario = formulario_actual;
  for (var i = 0; i < formulario.length; i++) {
    if (formulario[i].type == 'text' || formulario[i].type == 'number' || formulario[i].type == 'textarea' ||
      formulario[i].type == 'select-one') {
      if (formulario[i].getAttribute("data-required") == 'required') {
        if (formulario[i].value == null || formulario[i].value == '' || formulario[i].value == 0 || formulario[i]
          .value.length == 0 || /^\s*$/.test(formulario[i].value)) {
          Swal.fire({
            icon: 'error',
            title: 'Hubo un problema',
            html: 'El campo <b>' + formulario[i].getAttribute("data-field") + '</b> no es válido',
            width: '50em',
            confirmButtonText: 'Cerrar'
          })
          todoCorrecto = false;
        }
      }
    }
  }
  if (todoCorrecto == true) {
    if (pag == 1) {
      document.getElementById('formPaso1').className = "animate__animated animate__fadeOut ";
      setTimeout(function() {
        document.getElementById('formPaso1').className = "hidden";
        document.getElementById('formPaso2').className = "animate__animated animate__fadeInUp";
      }, 500)
      $("#nuevaRequisicionModal #titulo_paso").text('Información de la Vacante');
      $("#nuevaRequisicionModal #btnRegresar, #nuevaRequisicionModal #paso2").prop('disabled', false);
      document.getElementById('barra1').classList.remove('barra_espaciadora_off');
      document.getElementById('barra1').className += ' barra_espaciadora_on';
    }
    if (pag == 2) {
      document.getElementById('formPaso2').className = "animate__animated animate__fadeOut ";
      setTimeout(function() {
        document.getElementById('formPaso2').className = "hidden";
        document.getElementById('formPaso3').className = "animate__animated animate__fadeInUp";
      }, 500)
      $("#nuevaRequisicionModal #titulo_paso").text('Información sobre el Cargo');
      $("#nuevaRequisicionModal #paso3").prop('disabled', false);
      document.getElementById('barra2').classList.remove('barra_espaciadora_off');
      document.getElementById('barra2').className += ' barra_espaciadora_on';
      $("#nuevaRequisicionModal #btnContinuar span.text").text('Finalizar');
    }
    if (pag == 3) {
      let datos = $('#formPaso1').serialize();
      datos += '&' + $("#formPaso2").serialize();
      datos += '&' + $("#formPaso3").serialize();
      let currentPage = $('#currentPage').val();
      $.ajax({
        url: '<?php echo base_url('Reclutamiento/addRequisicion'); ?>',
        type: 'post',
        data: datos,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            $("#nuevaRequisicionModal").modal('hide');
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: data.msg,
              showConfirmButton: false,
              timer: 3000
            })
            if (currentPage == 'requisicion') {
              setTimeout(function() {
                location.reload()
              }, 3000)
            }
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Hubo un problema',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Cerrar'
            })
          }
        }
      });
    }
    if (pag == 1 || pag == 2)
      pag++;
  }
});
$('#nuevaRequisicionModal #btnRegresar').on('click', function() {
  if (pag == 2) {
    document.getElementById('formPaso2').className = "animate__animated animate__fadeOut ";
    setTimeout(function() {
      document.getElementById('formPaso2').className = "hidden";
      document.getElementById('formPaso1').className = "animate__animated animate__fadeInUp";
    }, 500)
    $("#nuevaRequisicionModal #titulo_paso").text('Información Básica');
    $("#nuevaRequisicionModal #btnRegresar, #nuevaRequisicionModal #paso2").prop('disabled', true);
    document.getElementById('barra1').classList.remove('barra_espaciadora_on');
    document.getElementById('barra1').className += ' barra_espaciadora_off';
    $("#nuevaRequisicionModal #btnContinuar span.text").text('Continuar');
    pag--;
  }
  if (pag == 3) {
    document.getElementById('formPaso3').className = "animate__animated animate__fadeOut ";
    setTimeout(function() {
      document.getElementById('formPaso3').className = "hidden";
      document.getElementById('formPaso2').className = "animate__animated animate__fadeInUp";
    }, 500)
    $("#nuevaRequisicionModal #titulo_paso").text('Información de la Vacante');
    $("#nuevaRequisicionModal #paso3").prop('disabled', true);
    document.getElementById('barra2').classList.remove('barra_espaciadora_on');
    document.getElementById('barra2').className += ' barra_espaciadora_off';
    $("#nuevaRequisicionModal #btnContinuar span.text").text('Continuar');
    pag--;
  }
});


$('#nuevoAspiranteModal').on('hidden.bs.modal', function(e) {
  $("#nuevoAspiranteModal #msj_error").css('display', 'none');
  $("#nuevoAspiranteModal input, #nuevoAspiranteModal select, #nuevoAspiranteModal textarea").val('');
  $("#nuevoAspiranteModal #req_asignada").val('').selectpicker('refresh');
  $('#cv_previo').html('');
  $('#idAspirante').val('');
});
$('#nuevaAccionModal').on('hidden.bs.modal', function(e) {
  $("#nuevaAccionModal #msj_error").css('display', 'none');
  $("#nuevaAccionModal textarea, #nuevaAccionModal select").val('');
});
$('#estatusRequisicionModal').on('hidden.bs.modal', function(e) {
  $("#estatusRequisicionModal #msj_error").css('display', 'none');
  $("#estatusRequisicionModal textarea, #estatusRequisicionModal select").val('');
});
$("#registroCandidatoModal").on("hidden.bs.modal", function() {
  $("#examen_registro").empty();
  $("#examen_registro").append('<option value="">Selecciona</option><option value="0" selected>N/A</option>');
  <?php
  if($paquetes_antidoping != null){ 
    foreach ($paquetes_antidoping as $paq) { ?>
  $("#examen_registro").append(
    '<option value="<?php echo $paq->id; ?>"><?php echo $paq->nombre.' ('.$paq->conjunto.')'; ?></option>');
  <?php
    }} ?>
  $("#registroCandidatoModal input, #registroCandidatoModal select, #registroCandidatoModal textarea").val('');
  $("#examen_registro,#examen_medico,#examen_psicometrico").val(0);
  $('#pais').val('México')
  $('#subcliente').val(0)
  $('#detalles_previo').empty();
  $("#registroCandidatoModal .selectpicker").val('').selectpicker('refresh');

})

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
        $('#empleos_tiempo_registro').append($('<option></option>').attr('value', '3 years').text('3 years'));
        $('#empleos_tiempo_registro').append($('<option></option>').attr('value', '5 years').text('5 years'));
        $('#empleos_tiempo_registro').append($('<option></option>').attr('value', '7 years').text('7 years'));
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
        $('#domicilios_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected")
          .text('N/A'));
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
        $('#credito_tiempo_registro').append($('<option></option>').attr('value', '3 years').text('3 years'));
        $('#credito_tiempo_registro').append($('<option></option>').attr('value', '5 years').text('5 years'));
        $('#credito_tiempo_registro').append($('<option></option>').attr('value', '7 years').text('7 years'));
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
        $('#prohibited_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected")
          .text('N/A'));
        //Age check
        $('#edad_registro').append($('<option></option>').attr('value', 1).text('Apply'));
        $('#edad_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected").text(
          'N/A'));
        //Motor vehicle records
        $('#mvr_registro').append($('<option></option>').attr('value', 1).text('Apply'));
        $('#mvr_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected").text(
          'N/A'));
        //CURP
        $('#curp_registro').append($('<option></option>').attr('value', 1).text('Apply'));
        $('#curp_registro').append($('<option></option>').attr('value', 0).attr("selected", "selected").text(
          'N/A'));
      }
    });
    if (region == 'International') {
      $('#pais_registro').prop('disabled', false);
      $('#pais_registro').val('');
      $('#mvr_registro').val(0);
    } else {
      $('#pais_registro').prop('disabled', true);
      //$('#pais_registro').val('México');
      $('#pais_registro').append($('<option></option>').attr('value', 'México').attr("selected", "selected").text(
        'Mexico'));
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
$('#mensajeModal').on('hidden.bs.modal', function(e) {
  $("#mensajeModal #titulo_mensaje, #mensajeModal #mensaje").text('');
  $("#mensajeModal #campos_mensaje").empty();
  $("#mensajeModal #btnConfirmar").removeAttr('onclick');
});
$('#historialComentariosModal').on('hidden.bs.modal', function(e) {
  $("#historialComentariosModal .nombreRegistro").text('');
  $("#historialComentariosModal #comentario_bolsa").val('');
  $("#historialComentariosModal #div_historial_comentario").empty();
  $("#historialComentariosModal #btnComentario").removeAttr('onclick');
});
$('#nuevaRequisicionModal').on('hidden.bs.modal', function(e) {
  $("#nuevaRequisicionModal input, #nuevaRequisicionModal select, #nuevaRequisicionModal textarea").val('');
  document.getElementById('formPaso1').className = "block";
  document.getElementById('formPaso2').className = "hidden";
  document.getElementById('formPaso3').className = "hidden";
  $("#nuevaRequisicionModal #titulo_paso").text('Información Básica');
  $("#nuevaRequisicionModal #btnRegresar, #nuevaRequisicionModal #paso2").prop('disabled', true);
  document.getElementById('barra1').classList.remove('barra_espaciadora_on');
  document.getElementById('barra1').className += ' barra_espaciadora_off';
  document.getElementById('barra2').classList.remove('barra_espaciadora_on');
  document.getElementById('barra2').className += ' barra_espaciadora_off';
  $("#nuevaRequisicionModal #btnContinuar span.text").text('Continuar');
  pag = 1;
});
$('#asignarUsuarioModal').on('hidden.bs.modal', function(e) {
  $("#asignarUsuarioModal .selectpicker").val('').selectpicker('refresh');
});
$('#subirCSVModal').on('hidden.bs.modal', function(e) {
  $("#subirCSVModal input").val('');
});
$('#ingresoCandidatoModal').on('hidden.bs.modal', function(e) {
  $("#ingresoCandidatoModal input, #ingresoCandidatoModal textarea").val('');
});
function switchLanguage(language) {
    // Hacer una solicitud AJAX para cambiar el idioma
    $.ajax({
        type: 'POST',
        url: '<?php echo site_url('language/switch'); ?>',
        data: { language: language },
        success: function(response) {
            // Después de cambiar el idioma, actualizar el contenido del modal
            // Simplemente mostrar el modal de nuevo para que se vuelva a cargar con el contenido en el nuevo idioma
            $('#registroCandidatoModal').modal('show');
        }
    });
}

function nuevoRegistro() {
  $.ajax({
    url: '<?php echo base_url('Candidato/getSeccionesPrevias'); ?>',
    type: 'POST',
    data: {
      'id_cliente': id_cliente
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
</script>