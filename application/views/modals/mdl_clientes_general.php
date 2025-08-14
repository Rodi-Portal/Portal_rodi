
<div class="modal fade" id="newModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Registrar candidato</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info text-center">Datos Generales</div>
        <form id="nuevoRegistroForm">
          <div class="row">
            <div class="col-4">
              <label>Nombre(s) *</label>
              <input type="text" class="form-control obligado" name="nombre_registro" id="nombre_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-4">
              <label>Apellido paterno *</label>
              <input type="text" class="form-control obligado" name="paterno_registro" id="paterno_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-4">
              <label>Apellido materno</label>
              <input type="text" class="form-control" name="materno_registro" id="materno_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <label>Subcliente (Proveedor) *</label>
              <select name="subcliente" id="subcliente" class="form-control obligado">
                <option value="">Selecciona</option>
                <?php
                if ($subclientes) {
                  foreach ($subclientes as $sub) { ?>
                    <option value="<?php echo $sub->id; ?>"><?php echo $sub->nombre; ?></option>
                  <?php   }
                  echo '<option value="0">N/A</option>';
                } else { ?>
                  <option value="0">N/A</option>
                <?php } ?>
              </select>
              <br>
            </div>
            <?php 
            $id_cliente = $this->uri->segment(3);
            if($id_cliente != 172 && $id_cliente != 178 && $id_cliente != 205 && $id_cliente != 96 && $id_cliente != 235){ ?>
              <div class="col-4">
                <label>Puesto *</label>
                <select name="puesto" id="puesto" class="form-control obligado">
                  <option value="">Selecciona</option>
                  <?php
                  foreach ($puestos as $p) { ?>
                    <option value="<?php echo $p->id; ?>"><?php echo $p->nombre; ?></option>
                  <?php
                  } ?>
                </select>
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
              <input type="text" class="form-control obligado" name="celular_registro" id="celular_registro" maxlength="16">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <label>País donde reside *</label>
              <select class="form-control" id="pais" name="pais">
                <?php
                  foreach ($paises as $p) {
                    $default = ($p->nombre == 'México')? 'selected' : ''; ?>
                    <option value="<?php echo $p->nombre; ?>" <?php echo $default ?>><?php echo $p->nombre; ?></option>
                  <?php
                  } 
                ?>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label>Correo </label>
              <input type="text" class="form-control obligado" name="correo_registro" id="correo_registro">
              <br>
            </div>
            <?php 
            if($this->uri->segment(3) == 159){  ?>
              <div class="col-4">
                <label>Centro de costos *</label>
                <input type="text" class="form-control obligado" name="centro_costo" id="centro_costo">
                <br>
              </div>
            <?php
            } ?>
          </div>
          <div class="row">
            <?php  
            if($this->uri->segment(3) == 159 || $this->uri->segment(3) == 87){ ?>
              <div class="col-4">
                <label>CURP *</label>
                <input type="text" class="form-control obligado" name="curp_registro" id="curp_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" maxlength="18">
                <br>
              </div>
              <div class="col-4">
                <label>Numero de Seguro Social (NSS) *</label>
                <input type="text" class="form-control obligado" name="nss_registro" id="nss_registro" maxlength="11">
                <br>
              </div>
            <?php  
            } ?>
          </div>
          <!--div class="alert alert-warning text-center">Elige si se llevará a cabo un proceso registrado previamente o si es un proceso nuevo <br>Notas: <br>
            <ul class="text-left">
              <li>Si se elige un proceso previo, se omitirán las opciones elegidas de la sección de proceso nuevo (en caso de haber).</li>
              <li>Los exámenes complementarios son opcionales.</li>
              <li>Los candidatos previamente concluidos corresponden al proceso General.</li>
            </ul> 
          </div-->
          <div class="alert alert-info text-center">Selecciona un proceso previo</div>
          <div class="row">
            <div class="col-12">
              <label>Proceso previo</label>
              <select class="form-control" name="previos" id="previos"></select><br>
            </div>
          </div>
          <div id="detalles_previo"></div>
          <div class="alert alert-danger text-center">Exámenes complementarios</div>
          <div class="row">
            <div class="col-4">
              <label>Examen antidoping *</label>
              <select name="examen_registro" id="examen_registro" class="form-control registro_obligado">
                <option value="">Selecciona</option>
                <option value="0" selected>N/A</option>
                <?php
                foreach ($paquetes_antidoping as $paq) { ?>
                  <option value="<?php echo $paq->id; ?>"><?php echo $paq->nombre.' ('.$paq->conjunto.')'; ?></option>
                <?php
                } ?>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label>Examen médico *</label>
              <select name="examen_medico" id="examen_medico" class="form-control registro_obligado">
                <option value="0">N/A</option>
                <option value="1">Aplicar</option>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label>Psicometría *</label>
              <select name="examen_psicometrico" id="examen_psicometrico" class="form-control registro_obligado">
                <option value="0">N/A</option>
                <option value="1">Aplicar</option>
              </select>
              <br>
            </div>
          </div>
          <div class="alert alert-info text-center">Carga de CV o solicitu de empleo</div>
          <div class="row">
            <div class="col-12">
              <label>Cargar CV o solicitud de empleo del candidato</label>
              <input type="file" id="cv" name="cv" class="form-control" accept=".pdf, .jpg, .jpeg, .png" multiple><br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="registrar()">Registrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="hclnewModal" role="dialog" data-backdrop="static" data-keyboard="false">
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
              <input type="text" class="form-control registro_obligado" name="nombre_registro_hcl" id="nombre_registro_hcl" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>First lastname *</label>
              <input type="text" class="form-control registro_obligado" name="paterno_registro_hcl" id="paterno_registro_hcl" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Second lastname </label>
              <input type="text" class="form-control" name="materno_registro_hcl" id="materno_registro_hcl" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Email *</label>
              <input type="email" class="form-control registro_obligado" name="correo_registro_hcl" id="correo_registro_hcl" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Cellphone number *</label>
              <input type="text" class="form-control" name="celular_registro_hcl" id="celular_registro_hcl" maxlength="16">
              <br>
            </div>
          </div>
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
              <select name="opcion_registro_hcl" id="opcion_registro_hcl" class="form-control registro_obligado">
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
              <select class="form-control" name="previos_hcl" id="previos_hcl"></select><br>
            </div>
            <div class="col-md-3">
              <label>Country</label>
              <select class="form-control" name="pais_previo_hcl" id="pais_previo_hcl" disabled></select><br>
            </div>
          </div>
          <div id="detalles_previo_hcl"></div>
          <div class="alert alert-info text-center div_info_project">Select a New Project</div>
          <div class="row div_project">
            <div class="col-md-4">
              <label>Location *</label>
              <select name="region_hcl" id="region_hcl" class="form-control registro_obligado">
                <option value="">Select</option>
                <option value="Mexico">Mexico</option>
                <option value="International">International</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Country</label>
              <select name="pais_registro_hcl" id="pais_registro_hcl" class="form-control registro_obligado" disabled>
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
              <input type="text" class="form-control" name="proyecto_registro_hcl" id="proyecto_registro_hcl" disabled>
              <br>
            </div>
          </div>
          <div class="alert alert-info text-center div_info_check">
            Required Information for the New Project<br>Note:<br>
            <ul class="text-left">
              <li>The required documents will add automatically depending of the selected options . The extra documents are optional, select them before the complementary tests.</li>
            </ul>
          </div>
          <div class="row div_check_hcl">
            <div class="col-md-6">
              <label>Employment history *</label>
              <select name="empleos_registro_hcl" id="empleos_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Time required</label>
              <select name="empleos_tiempo_registro_hcl" id="empleos_tiempo_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
          </div>
          <div class="row div_check_hcl">
            <div class="col-md-6">
              <label>Criminal check *</label>
              <select name="criminal_registro_hcl" id="criminal_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Time required</label>
              <select name="criminal_tiempo_registro_hcl" id="criminal_tiempo_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
          </div>
          <div class="row div_check_hcl">
            <div class="col-md-6">
              <label>Address history *</label>
              <select name="domicilios_registro_hcl" id="domicilios_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Time required</label>
              <select name="domicilios_tiempo_registro_hcl" id="domicilios_tiempo_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
          </div>
          <div class="row div_check_hcl">
            <div class="col-md-6">
              <label>Education check *</label>
              <select name="estudios_registro_hcl" id="estudios_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Global data searches *</label>
              <select name="global_registro_hcl" id="global_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
          </div>
          <div class="row div_check_hcl">
            <div class="col-md-6">
              <label>Credit check *</label>
              <select name="credito_registro_hcl" id="credito_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Time required</label>
              <select name="credito_tiempo_registro_hcl" id="credito_tiempo_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
          </div>
          <div class="row div_check_hcl">
            <div class="col-md-6">
              <label>Professional References (quantity)</label>
              <input type="number" class="form-control valor_dinamico" id="ref_profesionales_registro_hcl" name="ref_profesionales_registro_hcl" value="0" disabled>
              <br>
            </div>
            <div class="col-md-6">
              <label>Personal References (quantity)</label>
              <input type="number" class="form-control valor_dinamico" id="ref_personales_registro_hcl" name="ref_personales_registro_hcl" value="0" disabled>
              <br>
            </div>
          </div>
          <div class="row div_check_hcl">
            <div class="col-md-6">
              <label>Identity check *</label>
              <select name="identidad_registro_hcl" id="identidad_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Migratory form (FM, FM2 or FM3) check *</label>
              <select name="migracion_registro_hcl" id="migracion_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
            </div>
          </div>
          <div class="row div_check_hcl">
            <div class="col-md-6">
              <label>Prohibited parties list check *</label>
              <select name="prohibited_registro_hcl" id="prohibited_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Academic References (quantity)</label>
              <input type="number" class="form-control valor_dinamico" id="ref_academicas_registro_hcl" name="ref_academicas_registro_hcl" value="0" disabled>
              <br>
            </div>
          </div>
          <div class="row div_check_hcl">
            <div class="col-md-6">
              <label>Motor Vehicle Records (only in some  Mexico cities) *</label>
              <select name="mvr_registro_hcl" id="mvr_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>CURP check *</label>
              <select name="curp_registro_hcl" id="curp_registro_hcl" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
          </div>
          <div class="alert alert-danger text-center div_info_extra">Extra documents</div>
          <div class="row div_extra">
            <div class="col-12">
              <label>Select the extra documents *</label>
              <select name="extra_registro_hcl" id="extra_registro_hcl" class="form-control registro_obligado">
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
            <div class="col-md-6">
              <label>Drug test *</label>
              <select name="examen_registro_hcl" id="examen_registro_hcl" class="form-control registro_obligado">
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
            <div class="col-md-6">
              <label>Medical test *</label>
              <select name="examen_medico_hcl" id="examen_medico_hcl" class="form-control registro_obligado">
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
        <button type="button" class="btn btn-success" onclick="registrarAlterno()">Save</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="passModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Credenciales generadas para el candidato</h5>
      </div>
      <div class="modal-body">
        <p><b>Usuario/Correo: </b><span id="user"></span></p>
        <p><b>Contraseña: </b><span id="contrasena"></span></p>
        <p id="respuesta_mail"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="registroCandidatoBecaModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Registrar candidato</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info text-center">Datos Generales</div>
        <form id="">
          <div class="row">
            <div class="col-4">
              <label>Nombre(s) *</label>
              <input type="text" class="form-control obligado" name="nombre_beca" id="nombre_beca" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-4">
              <label>Apellido paterno *</label>
              <input type="text" class="form-control obligado" name="paterno_beca" id="paterno_beca" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-4">
              <label>Apellido materno</label>
              <input type="text" class="form-control" name="materno_beca" id="materno_beca" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <label>Subcliente (Proveedor) *</label>
              <select name="subcliente_beca" id="subcliente_beca" class="form-control obligado">
                <option value="">Selecciona</option>
                <?php
                if ($subclientes) {
                  foreach ($subclientes as $sub) { ?>
                    <option value="<?php echo $sub->id; ?>"><?php echo $sub->nombre; ?></option>
                  <?php   }
                  echo '<option value="0">N/A</option>';
                } else { ?>
                  <option value="0">N/A</option>
                <?php } ?>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label>Teléfono</label>
              <input type="text" class="form-control obligado" name="celular_beca" id="celular_beca" maxlength="16">
              <br>
            </div>
            <div class="col-4">
              <label>Correo </label>
              <input type="text" class="form-control obligado" name="correo_beca" id="correo_beca">
              <br>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="registrarCandidatoBeca()">Registrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="asignarCandidatoModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Reasignar candidato</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAsignacion">
          <div class="row">
            <div class="col-md-12">
              <label>Candidatos *</label>
              <select name="asignar_candidato" id="asignar_candidato" class="form-control asignar_obligado"></select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Usuario *</label>
              <select name="asignar_usuario" id="asignar_usuario" class="form-control asignar_obligado"></select>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="AsignarCandidato()">Guardar</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal: Elegir sucursal -->
<div class="modal fade" id="modalSucursal" tabindex="-1" role="dialog" aria-labelledby="sucursalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document"> <!-- AQUI modal-lg -->
    <div class="modal-content soft-shadow rounded-lg border-0">

      <div class="modal-header modal-header-primary py-2">
        <h6 class="modal-title mb-0" id="sucursalTitle">Selecciona la sucursal</h6>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body pt-3 pb-2">
        <div id="sucursalesLoader" class="alert alert-light mb-3 d-none">
          Cargando sucursales…
        </div>

        <div class="form-group">
          <label for="sucursalSelect">Sucursal</label>
          <select id="sucursalSelect" class="custom-select w-100" size="8">
            <option selected disabled value="">— elige una sucursal —</option>
          </select>
          <small class="form-text text-muted">Este cambio actualizará al candidato en la sucursal seleccionada.</small>
          <div id="sucursalesError" class="invalid-feedback d-block" style="display:none;"></div>
        </div>
      </div>

      <div class="modal-footer py-2 border-0">
        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
          Cancelar
        </button>
        <button id="btnEnviarEmpleado" type="button" class="btn btn-primary btn-sm">
          Enviar a Empleados
        </button>
      </div>

    </div>
  </div>
</div>






<div class="modal fade" id="refPersonalesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Referencias personales del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="contenedor_ref_personales"></div>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="legalesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Investigación legal del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_investigacion">
          <div class="row">
            <div class="col-md-6">
              <label>Penal *</label>
              <input type="text" class="form-control inv_obligado" name="inv_penal" id="inv_penal">
              <br>
            </div>
            <div class="col-md-6">
              <label>Notas *</label>
              <textarea cols="2" class="form-control inv_obligado" name="inv_penal_notas" id="inv_penal_notas"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Civil *</label>
              <input type="text" class="form-control inv_obligado" name="inv_civil" id="inv_civil">
              <br>
            </div>
            <div class="col-md-6">
              <label>Notas *</label>
              <textarea cols="2" class="form-control inv_obligado" name="inv_civil_notas" id="inv_civil_notas"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Laboral *</label>
              <input type="text" class="form-control inv_obligado" name="inv_laboral" id="inv_laboral">
              <br>
            </div>
            <div class="col-md-6">
              <label>Notas *</label>
              <textarea cols="2" class="form-control inv_obligado" name="inv_laboral_notas" id="inv_laboral_notas"></textarea>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="actualizarInvestigacion()">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="quitarModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titulo_accion"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="" id="texto_confirmacion"></p><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnGuardar" onclick="ejecutarAccion()">Aceptar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="revisionModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Última revisión al candidato: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Antes de finalizar tu estudio, realiza una ultima revisión de la ortografía, redacción y asegúrate que la información registrada sea la correcta. Para este estudio, se contemplan las siguientes secciones:</p><br>
        <ul>
          <li>Datos generales</li>
          <li>Historial académico</li>
          <li>Antecedentes sociales</li>
          <li>Referencias personales</li>
          <li>Antecedentes laborales</li>
          <li>Investigación legal</li>
          <li>Trabajos no mencionados</li>
          <li>Documentos en la visita</li>
          <li>Grupo familiar en la visita</li>
          <li>Egresos mensuales</li>
          <li>Habitación y medio ambiente</li>
          <li>Referencias vecinales</li>
        </ul><br>
        <p>En caso de que se presente un error o alguna imformación no se pueda cambiar, favor de avisar a TI en cuanto antes del cambio a solicitar </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar y regresar a revisar</button>
        <button type="button" class="btn btn-success" onclick="aceptarRevision()">Acepto que he revisado el estudio</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="completarModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Finalizar proceso del candidato</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formConclusiones">
          <div class="alert alert-warning text-center">
            <p>Las conclusiones y descripciones deshabilitadas no corresponden al proceso de este estudio. Solo registrar los campos disponibles.</p>
          </div>
          <div class="alert alert-info text-center">
            <p>Conclusión Personal</p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Primera descripción *</label>
              <textarea class="form-control es_conclusion" name="personal1" id="personal1" rows="6"></textarea>
              <br>
            </div>
            <div class="col-md-6">
              <label>Segunda descripción *</label>
              <textarea class="form-control es_conclusion" name="personal2" id="personal2" rows="6"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Tercera descripción</label>
              <textarea class="form-control es_conclusion" name="personal3" id="personal3" rows="6"></textarea>
              <br>
            </div>
            <div class="col-md-6">
              <label>Cuarta descripción</label>
              <textarea class="form-control es_conclusion" name="personal4" id="personal4" rows="6"></textarea>
              <br>
            </div>
          </div>
          <div class="alert alert-info text-center">
            <p>Conclusión Laboral</p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Número de referencias laborales señaladas *</label>
              <textarea class="form-control es_conclusion" name="laboral1" id="laboral1" rows="2"></textarea>
              <br>
            </div>
            <div class="col-md-6">
              <label>Descripción de las referencias laborales *</label>
              <textarea class="form-control es_conclusion" name="laboral2" id="laboral2" rows="6"></textarea>
              <br>
            </div>
          </div>
          <div class="alert alert-info text-center">
            <p>Conclusión Socioeconómica</p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Primera conclusión *</label>
              <textarea class="form-control es_conclusion" name="socio1" id="socio1" rows="6"></textarea>
              <br>
            </div>
            <div class="col-md-6">
              <label>Segunda conclusión *</label>
              <textarea class="form-control es_conclusion" name="socio2" id="socio2" rows="6"></textarea>
              <br><br>
            </div>
          </div>
          <div class="alert alert-info text-center">
            <p>Conclusión Visita</p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Conclusiones de la referencia vecinal</label>
              <textarea class="form-control es_conclusion" name="visita2" id="visita2" rows="6"></textarea>
              <br><br>
            </div>
            <div class="col-md-6">
              <label>Conclusiones del visitador</label>
              <textarea class="form-control es_conclusion" name="visita1" id="visita1" rows="6"></textarea>
              <br><br>
            </div>
          </div>
          <div class="alert alert-info text-center">
            <p>Proceso de Investigación</p>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Conclusión del proceso de estudio de investigación *</label>
              <textarea class="form-control es_conclusion" name="conclusion_investigacion" id="conclusion_investigacion" rows="3"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 offset-3">
              <label>De acuerdo a lo anterior, la persona investigada es considerada: *</label>
              <select name="recomendable" id="recomendable" class="form-control conclusion_obligado">
                <option value="">Selecciona</option>
                <option value="1">Recomendable</option>
                <option value="2">No recomendable</option>
                <option value="3">Con reservas</option>
                <option value="4">Referencias validadas</option>
                <option value="5">Referencias con inconsistencias</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Comentario del estatus final del estudio</label>
              <textarea class="form-control es_conclusion" name="comentario_bgc" id="comentario_bgc" rows="3"></textarea>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="finalizarProceso()">Guardar</button>
      </div>
    </div>
  </div>
</div>





<div class="modal fade" id="refVecinalesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Referencias vecinales del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="contenedor_ref_vecinales"></div>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="actualizarCandidatoModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Actualizar proceso del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="">
          <p class="text-center"><b>IMPORTANTE:</b> Para actualizar al candidato considera los siguientes puntos: <br><br>
          <ul>
            <li>Se reanudarán los resultados (estatus) finales del estudio actual.</li>
            <li>El archivo PDF del estudio finalizado actual se respaldará.</li>
            <li>La mayoría de la información del candidato se matendrá para su actualización.</li>
            <li>El examen antidoping se va requerir nuevamente en caso de que se haya aplicado.</li>
          </ul><br>
          </p>
          <p class="text-center">¿Desea continuar?</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="actualizarProceso()">Aceptar</button>
      </div>
    </div>
  </div>
</div>
<!-- <div class="modal fade" id="psicometriaModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Carga de archivo de psicometria: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-4 offset-4">
          <input id="archivo" name="archivo" class="psico_obligado" type="file" accept=".pdf"><br><br>
          <br>
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="subirPsicometria()">Guardar</button>
      </div>
    </div>
  </div>
</div> -->
<div class="modal fade" id="subirArchivoModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titulo_modal"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <label for="archivo" id="label_modal"></label>
          <input id="archivo" name="archivo" class="form-control" type="file" accept=".pdf, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet "><br><br>
          <br>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnSubir">Subir</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="pruebasModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pruebas y exámenes a aplicar al candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          Si la prueba o examen no se puede modificar indica que ya fue realizado. Si se desea modificar la prueba o examen ya realizado, favor de consultarlo con el administrador del sistema y/o con gerencia de operaciones.
        </div>
        <form id="d_pruebas">
          <div class="row">
            <div class="col-12">
              <label>Examen antidoping *</label>
              <select name="prueba_antidoping" id="prueba_antidoping" class="form-control obligado">
                <option value="">Selecciona</option>
                <option value="0">N/A</option>
                <?php
                foreach ($drogas as $d) { ?>
                  <option value="<?php echo $d->id; ?>"><?php echo $d->nombre . " (" . $d->conjunto . ")"; ?></option>
                <?php
                } ?>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-6">
              <label>Prueba psicométrica *</label>
              <select name="prueba_psicometrica" id="prueba_psicometrica" class="form-control obligado">
                <option value="">Selecciona</option>
                <option value="0">N/A</option>
                <option value="1">Aplicar/Aplicado</option>
              </select>
              <br>
            </div>
            <div class="col-6">
              <label>Exámen médico *</label>
              <select name="prueba_medica" id="prueba_medica" class="form-control obligado">
                <option value="">Selecciona</option>
                <option value="0">N/A</option>
                <option value="1">Aplicar/Aplicado</option>
              </select>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" id="btnActualizarPruebas" onclick="actualizarPruebasCandidato()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="comentarioVisitadorModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Observaciones del visitador</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="tituloObservaciones"></p>
        <br>
        <p id="observaciones_visitador"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="gapsModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Gaps laborales del candidato:  <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info text-center">Registrados</div>
        <div id="contenedor_gaps"></div>
        <!-- <div class="alert alert-info text-center">Nuevo registro</div>
        <div class="row mb-3">
          <div class="col-6">
            <p class="text-center">Fecha inicio</p>
            <input type="text" class="form-control" name="fecha_inicio" id="fecha_inicio">
          </div>
          <div class="col-6">
            <p class="text-center">Fecha fin</p>
            <input type="text" class="form-control" name="fecha_fin" id="fecha_fin">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-12">
            <label>Razón</label>
            <textarea class="form-control" name="razon" id="razon" rows="3"></textarea>
            <br>
          </div>
        </div> -->
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <button type="button" class="btn btn-success" onclick="generarGap()">Guardar</button> -->
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="conclusionModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Conclusión previa del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formConclusion">
          <div class="alert alert-warning text-center">
            <p>La conclusión a registrar será tomada en cuenta solo en el reporte previo del estudio.</p>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Conclusión temporal *</label>
              <textarea class="form-control" name="conclusion_temporal" id="conclusion_temporal" rows="3"></textarea>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="guardarConclusionTemporal()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="verificacionEstudiosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Verificación de estudios académicos del candidato: <br> <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="idVerificacionEstudio">
        <div class="box-header tituloSubseccion">
          <p class="box-title"><strong> Anteriores:</strong></p>
        </div>
        <div class="text-center" id="div_crearEstatusEstudio">
          <p>Sin registros </p>
        </div>
        <hr>
        <div class="margen" id="div_estatus_estudio">
          <div class="box-header tituloSubseccion">
            <p class="box-title"><strong> Nuevos:</strong></p>
          </div>
          <div class="row">
            <div class="col-md-3">
              <p class="text-center"><b>Fecha</b></p>
              <p class="text-center" id="fecha_estatus_estudio"></p>
            </div>
            <div class="col-md-9">
              <label for="estudio_estatus_comentario">Comentario</label>
              <textarea class="form-control" name="estudio_estatus_comentario" id="estudio_estatus_comentario" rows="3"></textarea>
              <br>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-4 offset-3">
              <label>Estatus de la verificación *</label>
              <select name="estudio_estatus" id="estudio_estatus" class="form-control">
                <option value="Validated">Validado</option>
                <option value="Not validated">No validado</option>
              </select>
              <br><br>
            </div>
            <div class="col-3 mt-4">
              <button type="button" class="btn btn-primary" onclick="guardarEstatusEstudios()">Guardar estatus</button><br><br>
            </div>
          </div>
          <div id="msj_error" class="alert alert-danger hidden"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="registrarEstatusEstudio()">Registrar comentario</button><br><br>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="verificacionLaboralesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Verificación de referencias laborales: <br> <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="idVerificacionLaboral">
        <div class="box-header tituloSubseccion">
          <p class="box-title"><strong> Anteriores:</strong></p>
        </div>
        <div class="text-center" id="div_crearEstatusLaboral">
          <p class="text-center">Sin registros </p>
        </div>
        <hr>
        <div class="margen" id="div_estatus_laboral">
          <div class="box-header tituloSubseccion">
            <p class="box-title"><strong> Nuevos:</strong></p>
          </div>
          <div class="row">
            <div class="col-md-3">
              <p class="text-center"><b>Fecha</b></p>
              <p class="text-center" id="fecha_estatus_laboral"></p>
            </div>
            <div class="col-md-9">
              <label for="laboral_estatus_comentario">Comentario</label>
              <textarea class="form-control" name="laboral_estatus_comentario" id="laboral_estatus_comentario" rows="3"></textarea>
              <br>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-4 offset-3">
              <label>Estatus de la verificación *</label>
              <select name="laborales_estatus" id="laborales_estatus" class="form-control">
                <option value="Validated">Validado</option>
                <option value="Not validated">No validado</option>
              </select>
              <br><br>
            </div>
            <div class="col-3 mt-4">
              <button type="button" class="btn btn-primary" onclick="guardarEstatusLaborales()">Guardar estatus</button><br><br>
            </div>
          </div>
          <div id="msj_error" class="alert alert-danger hidden"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="registrarEstatusLaboral()">Registrar comentario</button><br><br>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="verificacionPenalesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Verificación de antecedentes no penales: <br> <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="idVerificacionPenales">
        <div class="box-header tituloSubseccion">
          <p class="box-title"><strong> Anteriores:</strong></p>
        </div>
        <div class="text-center" id="div_crearEstatusPenales">
          <p class="text-center">Sin registros </p>
        </div>
        <hr>
        <div class="margen" id="div_estatus_penales">
          <div class="box-header tituloSubseccion">
            <p class="box-title"><strong> Nuevos:</strong></p>
          </div>
          <div class="row">
            <div class="col-md-3">
              <p class="text-center"><b>Fecha</b></p>
              <p class="text-center" id="fecha_estatus_penales"></p>
            </div>
            <div class="col-md-9">
              <label>Comentario</label>
              <textarea class="form-control" name="penales_estatus_comentario" id="penales_estatus_comentario" rows="3"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-4 offset-3">
              <label>Estatus de la verificación *</label>
              <select name="criminal_estatus" id="criminal_estatus" class="form-control">
                <option value="Validated">Validado</option>
                <option value="Not validated">No validado</option>
              </select>
              <br><br>
            </div>
            <div class="col-3 mt-4">
              <button type="button" class="btn btn-primary" onclick="guardarEstatusPenales()">Guardar estatus</button><br><br>
            </div>
          </div>
          <div id="msj_error" class="alert alert-danger hidden"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="registrarEstatusPenales()">Registrar comentario</button><br><br>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="finalizarModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Verificaciones finales del proceso del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formChecks">
          <div class="row">
            <div class="col-md-4">
              <label>Identidad *</label>
              <select name="check_identidad" id="check_identidad" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Historial de empleos *</label>
              <select name="check_laboral" id="check_laboral" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Estudios *</label>
              <select name="check_estudios" id="check_estudios" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Antecedentes criminales *</label>
              <select name="check_penales" id="check_penales" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>OFAC *</label>
              <select name="check_ofac" id="check_ofac" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Búsquedas de información globales (Worldcheck) *</label>
              <select name="check_global" id="check_global" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Historial crediticio *</label>
              <select name="check_credito" id="check_credito" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Agresor sexual *</label>
              <select name="check_sex_offender" id="check_sex_offender" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Examen médico subido *</label>
              <select name="check_medico" id="check_medico" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Historial de domicilios *</label>
              <select name="check_domicilio" id="check_domicilio" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Acreditación profesional *</label>
              <select name="check_professional_accreditation" id="check_professional_accreditation" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Referencias académicas *</label>
              <select name="check_ref_academica" id="check_ref_academica" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Número de Seguro Social (NSS) *</label>
              <select name="check_nss" id="check_nss" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Ciudadanía (Pasaporte) *</label>
              <select name="check_ciudadania" id="check_ciudadania" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Historial de registros del vehiculo (Motor Vehicle Records) *</label>
              <select name="check_mvr" id="check_mvr" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Servicio militar *</label>
              <select name="check_servicio_militar" id="check_servicio_militar" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Credencial académica *</label>
              <select name="check_credencial_academica" id="check_credencial_academica" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Referencias profesionales *</label>
              <select name="check_ref_profesional" id="check_ref_profesional" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Declaración final *</label>
              <textarea class="form-control check_obligado" name="comentario_final" id="comentario_final" rows="3"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 offset-md-4">
              <label>Estatus final BGC *</label>
              <select name="bgc_status" id="bgc_status" class="form-control check_obligado">
                <option value="">Selecciona</option>
                <option value="2">Negative</option>
                <option value="1">Positive</option>
                <option value="3">Under Revision (UR)</option>
              </select>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btnTerminar" class="btn btn-success" onclick="finalizarEstudio()">Terminar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="checklistModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Finalizar proceso del candidato: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formChecklist">
          <div class="row">
            <div class="col-md-4">
              <label>Identity Check *</label>
              <select name="estatus_identidad" id="estatus_identidad" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
                <option value="4">Pending</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Employment History Check *</label>
              <select name="estatus_laboral" id="estatus_laboral" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
                <option value="4">Pending</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Academic History Check *</label>
              <select name="estatus_estudios" id="estatus_estudios" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
                <option value="4">Pending</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Criminal Records *</label>
              <select name="estatus_penales" id="estatus_penales" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
                <option value="4">Pending</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Criminal Records – OFAC *</label>
              <select name="estatus_ofac" id="estatus_ofac" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
                <option value="4">Pending</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Global search (Refinitiv) *</label>
              <select name="estatus_global" id="estatus_global" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
                <option value="4">Pending</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Credit Check *</label>
              <select name="estatus_credito" id="estatus_credito" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
                <option value="4">Pending</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Sex offender *</label>
              <select name="estatus_sex_offender" id="estatus_sex_offender" class="form-control es_check">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
                <option value="4">Pending</option>
              </select>
              <br>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btnTerminar" class="btn btn-success" onclick="actualizarChecklist()">Terminar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="finalizarInvestigacionesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Finalizar investigaciones del candidato: <br> <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formFinalizarInvestigaciones">
          <div class="row">
            <div class="col-md-12">
              <label>Conclusión *</label>
              <textarea class="form-control" name="comentario_investigaciones" id="comentario_investigaciones" rows="3"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 offset-md-4">
              <label>Estatus final *</label>
              <select name="estatus_investigaciones" id="estatus_investigaciones" class="form-control">
                <option value="">Selecciona</option>
                <option value="1">Positivo</option>
                <option value="2">Negativo</option>
                <option value="3">Bajo revisión</option>
              </select>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btnOfac" class="btn btn-success" onclick="finalizarInvestigaciones()">Terminar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="accesoFormModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Acceso al formulario para el candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning">
          <h4 class="text-center"><b>Considera los siguientes puntos:</b></h4><br>
          <ul>
            <li>Se debe hacer entrega del link de acceso al candidato.</li>
            <li>El formulario estará activo hasta finalizar proceso para que se pueda actualizar la información en cualquier momento.</li>
            <li>Si se brinda el link de acceso al candidato, se recomienda al analista no registrar la misma información (datos generales, aspectos sociales, referencias personales, historial académico, historial de empleos) y esperar a que esta sea registrada por el candidato, de lo contrario, la información podría cambiar por acción del candidato.</li>
            <li>Una vez que el candidato conteste su formulario, en algunas secciones en el panel de analista puede aparecer la palabra 'undefined' pero esto no implica un error y se debe modificar de acuerdo a la verificación del(la) analista. Ejemplo: la pregunta ¿Lo recomienda? de las referencias personales debe ser registrada por la(el) analista.</li>
          </ul><br>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label>Haz clic</label>
            <button type="button" class="btn btn-primary" onclick="generarAcceso()">Generar link de acceso</button>
            <br>
          </div>
          <div class="col-md-8">
            <label>Copia este link *</label>
            <input type="text" class="form-control" name="link_acceso" id="link_acceso" maxlength="12" readonly>
            <br>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="addToken()">Registrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="creditoModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Historial crediticio <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="box-header tituloSubseccion">
          <p class="box-title"><strong> Anteriores:</strong></p>
        </div>
        <div class="row" id="div_antescredit">
          <p class="text-center">Sin registros </p>
        </div>
        <hr>
        <div class="margen" id="div_credit">
          <div class="box-header tituloSubseccion">
            <p class="box-title"><strong> Nuevos:</strong></p>
          </div>
          <div class="row">
            <div class="col-md-3">
              <p class="text-center"><b>Fecha inicio</b></p>
              <input type="text" class="form-control" name="credito_fecha_inicio" id="credito_fecha_inicio">
            </div>
            <div class="col-md-3">
              <p class="text-center"><b>Fecha fin</b></p>
              <input type="text" class="form-control" name="credito_fecha_fin" id="credito_fecha_fin">
            </div>
            <div class="col-md-6">
              <label>Comentario</label>
              <textarea class="form-control" name="credito_comentario" id="credito_comentario" rows="3"></textarea>
              <br>
            </div>
          </div>
          <div id="msj_error" class="alert alert-danger hidden"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="generarHistorialCredito()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="extraLaboralModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Información laboral extra del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formExtraLaboral">
          <div class="row" id="rowExtralaboral"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarExtraLaboral()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="asignarSubclienteModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Asignación/Cambio de Subcliente al candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAsignarSubcliente">
          <div class="row">
            <div class="col-12">
              <label>Elige un subcliente/proveedor:</label>
              <select name="subcliente_asignado" id="subcliente_asignado" class="form-control">
              <?php
                if ($subclientes) { ?>
                  <option value="0">Selecciona</option>
                  <?php
                  foreach ($subclientes as $sub) { ?>
                    <option value="<?php echo $sub->id; ?>"><?php echo $sub->nombre; ?></option>
                  <?php   }
                  echo '<option value="0">N/A</option>';
                } else { ?>
                  <option value="0">Este cliente no posee subclientes</option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarAsignacionSubcliente()">Guardar</button>
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
          <div class="row escrolable" id="rowForm"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnSubmitForm">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="nuevoItemModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titleItemForm"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="rowNuevoItemForm" class="row escrolable"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
            <p class="text-center text-danger font-weight-bold">* Recuerda que los documentos solo se podrán visualizar en el estudio finalizado si están en formato imagen (.jpg, .png, .jpeg), si están en .pdf se debe tomar una captura o escanear el documento</p>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div id="tablaDocs" class="text-center"></div><br><br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 text-center">
            <label>Selecciona el documento</label><br>
            <input type="file" id="documento" class="doc_obligado" name="documento" accept=".jpg, .png, .jpeg"><br><br>
            <br>
          </div>
          <div class="col-md-6 text-center">
            <label>Tipo de archivo *</label>
            <select name="tipo_archivo" id="tipo_archivo" class="form-control personal_obligado">
              <option value="">Selecciona</option>
              <?php foreach ($tipos_docs as $t) { ?>
                <option value="<?php echo $t->id; ?>"><?php echo $t->nombre; ?></option>
              <?php } ?>
            </select>
            <br>
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="subirDoc()">Subir</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="familiaresModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Datos del grupo familiar del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formFamiliares">
          <div id="rowFamiliares" class="row escrolable"></div>
        </form>
        <div class="row mt-5 mb-3">
          <div class="col-md-5 offset-4"><a href="javascript:void(0)" class="btn btn-success"
              onclick="nuevoFamiliar()"><i class="fas fa-plus-circle"></i> Nuevo Integrante Familiar</a></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="nuevoFamiliarModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Registro de nuevo integrante familiar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="rowNuevoFamiliar" class="row escrolable"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
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
<div class="modal fade" id="subirVisitaModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Información respaldada en la visita</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <label>Selecciona el archivo *</label><br>
            <input type="file" id="archivo_visita" class="form-control" name="archivo_visita" accept=".txt"><br><br>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-12" id="divInfoVisita" style="display:none;height: 300px;overflow-y: auto;"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="getDatosVisita()">Verificar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="contactoModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Datos de contacto del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formContacto">
          <div class="row">
            <div class="col-md-4">
              <label>Nombre(s) *</label>
              <input type="text" class="form-control personal_obligado" name="nombre_contacto" id="nombre_contacto" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Primer apellido *</label>
              <input type="text" class="form-control personal_obligado" name="paterno_contacto" id="paterno_contacto" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Segundo apellido</label>
              <input type="text" class="form-control" name="materno_contacto" id="materno_contacto" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Teléfono celular *</label>
              <input type="text" class="form-control solo_numeros personal_obligado" name="celular_contacto" id="celular_contacto" maxlength="10">
              <br>
            </div>
            <div class="col-md-4">
              <label>Teléfono local </label>
              <input type="text" class="form-control solo_numeros" name="tel_casa_contacto" id="tel_casa_contacto" maxlength="10">
              <br>
            </div>
            <div class="col-md-4">
              <label>Correo electrónico *</label>
              <input type="text" class="form-control " name="correo_contacto" id="correo_contacto">
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarDatosContacto()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="medicoModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Carga de examen medico del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 class="text-left"></h4><br>
        <input id="doc_medico" name="doc_medico" class="form-control medico_obligado" type="file" accept=".pdf"><br><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="subirExamenMedico()">Subir</button>
      </div>
    </div>
  </div>
</div>
<script>
  $('.div_info_project, .div_project, .div_info_previo, .div_previo, .div_info_check, .div_check_hcl, .div_info_test, .div_test, .div_info_extra, .div_extra').css('display','none');

  $(document).ready(function(){
    $('#formModal').on('hidden.bs.modal', function(e) {
      $("#rowForm").empty();
      $('#btnOpenFiles').remove()
      $('#btnSubmitForm').text('Guardar')
      $('#btnSubmitForm').css('display','initial')
      $('#formModal .modal-body').removeClass('escrolable');
    })
    $('#nuevoItemModal').on('hidden.bs.modal', function(e) {
      $('#rowNuevoItemForm').empty();
    })
    $('#familiaresModal').on('hidden.bs.modal', function(e) {
      $("#rowFamiliares").empty();
    })
    $('#nuevoFamiliarModal').on('hidden.bs.modal', function(e) {
      $('#rowNuevoFamiliar').empty();
    })
    $('#subirArchivoModal').on('hidden.bs.modal', function(e) {
      $("#subirArchivoModal input").val('');
    });
    $('#mensajeModal').on('hidden.bs.modal', function(e) {
      $("#mensajeModal #titulo_mensaje, #mensajeModal #mensaje").text('');
      $("#mensajeModal #campos_mensaje").empty();
      $("#mensajeModal #btnConfirmar").removeAttr('onclick');
    });
    $('#subirVisitaModal').on('hidden.bs.modal', function(e) {
      $("#subirVisitaModal input").val('');
      $('#divInfoVisita').empty();
    })
    $('#contactoModal').on('hidden.bs.modal', function(e) {
      $("#contactoModal input").val('');
    });
    $('#medicoModal').on('hidden.bs.modal', function(e) {
      $("#medicoModal input").val('');
    });
    $("#newModal").on("hidden.bs.modal", function() {
      $("#examen_registro").empty();
      $("#examen_registro").append('<option value="">Selecciona</option><option value="0" selected>N/A</option>');
      <?php
      foreach ($paquetes_antidoping as $paq) { ?>
        $("#examen_registro").append('<option value="<?php echo $paq->id; ?>"><?php echo $paq->nombre.' ('.$paq->conjunto.')'; ?></option>');
      <?php
      } ?>
			$("#newModal input, #newModal select, #newModal textarea").val('');
			$("#newModal #msj_error").css('display', 'none');
			$("#examen_registro,#examen_medico,#examen_psicometrico").val(0);
      $('#pais').val('México')
      $('#detalles_previo').empty();
      
		})
    $('#hclnewModal').on('hidden.bs.modal', function(e) {
      $("#hclnewModal #msj_error").css('display', 'none');
      $("#hclnewModal input, #hclnewModal select").val('');
      $('.valor_dinamico').val(0);
      $('.valor_dinamico, #detalles_previo_hcl, #pais_previo_hcl').empty();
      $('#pais_registro_hcl, #pais_previo_hcl').prop('disabled', true);
      //$('#pais_registro').val(-1);
      $('#proyecto_registro_hcl').prop('disabled', true);
      $('#proyecto_registro_hcl').val('');
      $('.valor_dinamico').prop('disabled',true);
      $('#ref_profesionales_registro_hcl').val(0);
      $('#ref_personales_registro_hcl').val(0);
      $('#examen_registro_hcl, #examen_medico_hcl, #previos_hcl').val(0);
      $('#opcion_registro_hcl').val('').trigger('change');
      $('#div_docs_extras').empty();
      extras = [];
    });
    $("#asignarCandidatoModal").on("hidden.bs.modal", function() {
			$("#asignarCandidatoModal select").val('');
			$("#asignarCandidatoModal #msj_error").css('display', 'none');
		})
    $('#avancesModal').on('hidden.bs.modal', function(e) {
      $("#avancesModal #msj_error").css('display', 'none');
      $("#avancesModal input, #avancesModal textarea").val('');
    });
    $('#generalesInternacionalesModal').on('hidden.bs.modal', function(e) {
      $("#generalesInternacionalesModal #msj_error").css('display', 'none');
      $("#generalesInternacionalesModal input, #generalesInternacionalesModal select").val('');
    });
   
    
    
    
    $('#refPersonalesModal').on('hidden.bs.modal', function(e) {
      $("#refPersonalesModal div[id^='msj_error_personal']").css('display', 'none');
      $("#contenedor_ref_personales").empty();
    });
    $('#legalesModal').on('hidden.bs.modal', function(e) {
      $("#legalesModal #msj_error").css('display', 'none');
      $("#legalesModal input, #legalesModal textarea").val('');
    });
    
    $('#docsModal').on('hidden.bs.modal', function(e) {
      $("#docsModal #msj_error").css('display', 'none');
      $("#docsModal input, #docsModal select").val('');
    });
    
    
    
    $('#refVecinalesModal').on('hidden.bs.modal', function(e) {
      $("#refVecinalesModal input[id^='msj_error']").css('display', 'none');
      $("#refVecinalesModal input").val('');
    });
    
    $('#completarModal').on('hidden.bs.modal', function(e) {
      $("#completarModal #msj_error").css('display', 'none');
      $("#completarModal input, #completarModal textarea, #completarModal select").val('');
    });
    $('#pruebasModal').on('hidden.bs.modal', function(e) {
      $("#pruebasModal #msj_error").css('display', 'none');
      $("#pruebasModal select").val('');
    });
    
    
    
    $('#gapsModal').on('hidden.bs.modal', function(e) {
      $("#gapsModal #msj_error").css('display', 'none');
      $("#div_antesgap").empty();
      $("#gapsModal input, #gapsModal textarea").val('');
    });
    
    
    $('#accesoFormModal').on('hidden.bs.modal', function(e) {
      $("#tokenForm").val('');
      $("#accesoFormModal input").val('');
    });
    



    $('#extraLaboralModal').on('hidden.bs.modal', function(e) {
      $('#rowExtralaboral').empty();
    });
    
  })
</script>