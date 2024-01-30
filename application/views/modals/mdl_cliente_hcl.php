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
              <input type="text" class="form-control registro_obligado" name="nombre_registro" id="nombre_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>First lastname *</label>
              <input type="text" class="form-control registro_obligado" name="paterno_registro" id="paterno_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Second lastname </label>
              <input type="text" class="form-control" name="materno_registro" id="materno_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Email *</label>
              <input type="email" class="form-control registro_obligado" name="correo_registro" id="correo_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Cellphone number *</label>
              <input type="text" class="form-control" name="celular_registro" id="celular_registro" maxlength="16">
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
              <li>The required documents will add automatically depending of the selected options . The extra documents are optional, select them before the complementary tests.</li>
            </ul>
          </div>
          <div class="row div_check">
            <div class="col-md-6">
              <label>Employment history *</label>
              <select name="empleos_registro" id="empleos_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Time required</label>
              <select name="empleos_tiempo_registro" id="empleos_tiempo_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
          </div>
          <div class="row div_check">
            <div class="col-md-6">
              <label>Criminal check *</label>
              <select name="criminal_registro" id="criminal_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Time required</label>
              <select name="criminal_tiempo_registro" id="criminal_tiempo_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
          </div>
          <div class="row div_check">
            <div class="col-md-6">
              <label>Address history *</label>
              <select name="domicilios_registro" id="domicilios_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Time required</label>
              <select name="domicilios_tiempo_registro" id="domicilios_tiempo_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
          </div>
          <div class="row div_check">
            <div class="col-md-6">
              <label>Education check *</label>
              <select name="estudios_registro" id="estudios_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Global data searches *</label>
              <select name="global_registro" id="global_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
          </div>
          <div class="row div_check">
            <div class="col-md-6">
              <label>Credit check *</label>
              <select name="credito_registro" id="credito_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Time required</label>
              <select name="credito_tiempo_registro" id="credito_tiempo_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
          </div>
          <div class="row div_check">
            <div class="col-md-6">
              <label>Professional References (quantity)</label>
              <input type="number" class="form-control valor_dinamico" id="ref_profesionales_registro" name="ref_profesionales_registro" value="0" disabled>
              <br>
            </div>
            <div class="col-md-6">
              <label>Personal References (quantity)</label>
              <input type="number" class="form-control valor_dinamico" id="ref_personales_registro" name="ref_personales_registro" value="0" disabled>
              <br>
            </div>
          </div>
          <div class="row div_check">
            <div class="col-md-6">
              <label>Identity check *</label>
              <select name="identidad_registro" id="identidad_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Migratory form (FM, FM2 or FM3) check *</label>
              <select name="migracion_registro" id="migracion_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
            </div>
          </div>
          <div class="row div_check">
            <div class="col-md-6">
              <label>Prohibited parties list check *</label>
              <select name="prohibited_registro" id="prohibited_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Academic References (quantity)</label>
              <input type="number" class="form-control valor_dinamico" id="ref_academicas_registro" name="ref_academicas_registro" value="0" disabled>
              <br>
            </div>
          </div>
          <div class="row div_check">
            <div class="col-md-6">
              <label>Motor Vehicle Records (only in some  Mexico cities) *</label>
              <select name="mvr_registro" id="mvr_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              <br>
            </div>
            <div class="col-md-6">
              <label>CURP check *</label>
              <select name="curp_registro" id="curp_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
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
            <div class="col-md-6">
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
        <div id="campos_mensaje"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnGuardar" onclick="ejecutarAccion()">Aceptar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="generalesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Datos generales del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formGenerales">
          <div class="row">
            <div class="col-md-4">
              <label>Nombre(s) *</label>
              <input type="text" class="form-control personal_obligado" name="nombre_general" id="nombre_general" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Primer apellido *</label>
              <input type="text" class="form-control personal_obligado" name="paterno_general" id="paterno_general" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Segundo apellido</label>
              <input type="text" class="form-control" name="materno_general" id="materno_general" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Fecha de nacimiento *</label>
              <input type="text" class="form-control solo_lectura personal_obligado" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="dd/mm/yyyy">
              <br>
            </div>
            <div class="col-md-4">
              <label>Nacionalidad *</label>
              <input type="text" class="form-control personal_obligado" name="nacionalidad" id="nacionalidad">
              <br>
            </div>
            <div class="col-md-4">
              <label>Puesto *</label>
              <input type="text" class="form-control personal2_obligado" name="puesto_general" id="puesto_general">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Género: *</label>
              <select name="genero" id="genero" class="form-control personal_obligado">
                <option value="">Selecciona</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Calle *</label>
              <input type="text" class="form-control personal_obligado" name="calle" id="calle">
              <br>
            </div>
            <div class="col-md-4">
              <label>No. Exterior *</label>
              <input type="text" class="form-control personal_obligado" name="exterior" id="exterior" maxlength="8">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>No. Interior </label>
              <input type="text" class="form-control" name="interior" id="interior" maxlength="8">
              <br>
            </div>
            <div class="col-md-4">
              <label>Entre calles</label>
              <input type="text" class="form-control" name="calles" id="calles">
              <br>
            </div>
            <div class="col-md-4">
              <label>Colonia *</label>
              <input type="text" class="form-control personal_obligado" name="colonia" id="colonia">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Estado *</label>
              <select name="estado" id="estado" class="form-control personal_obligado">
                <option value="">Selecciona</option>
                <?php foreach ($estados as $e) { ?>
                  <option value="<?php echo $e->id; ?>"><?php echo $e->nombre; ?></option>
                <?php } ?>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Municipio (o Delegación) *</label>
              <select name="municipio" id="municipio" class="form-control personal_obligado" disabled>
                <option value="">Selecciona</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Código postal *</label>
              <input type="text" class="form-control solo_numeros personal_obligado" name="cp" id="cp" maxlength="5">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Estado civil *</label>
              <select name="civil" id="civil" class="form-control personal_obligado">
                <option value="">Selecciona</option>
                <option value="Married">Married</option>
                <option value="Single">Single</option>
                <option value="Divorced">Divorced</option>
                <option value="Free Union">Free Union</option>
                <option value="Widowed">Widowed</option>
                <option value="Separated">Separated</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Teléfono celular *</label>
              <input type="text" class="form-control solo_numeros personal_obligado" name="celular_general" id="celular_general" maxlength="10">
              <br>
            </div>
            <div class="col-md-4">
              <label>Teléfono local </label>
              <input type="text" class="form-control solo_numeros" name="tel_casa" id="tel_casa" maxlength="10">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Correo electrónico *</label>
              <input type="text" class="form-control " name="correo_general" id="correo_general">
              <input type="hidden" name="grado_estudios" id="grado_estudios">
              <br>
            </div>
            <div class="col-md-4">
              <label>CURP *</label>
              <input type="text" class="form-control " name="curp_general" id="curp_general" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" maxlength="18">
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarGenerales()">Guardar</button>
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
<div class="modal fade" id="mayoresEstudiosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Mayores estudios del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_mayor_estudios">
          <div class="alert alert-info">
            <p class="text-center">Candidato </p>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Nivel escolar *</label>
              <select name="mayor_estudios_candidato" id="mayor_estudios_candidato" class="form-control mayor_obligado">
                <option value="">Selecciona</option>
                <?php foreach ($studies as $st) { ?>
                  <option value="<?php echo $st->id; ?>"><?php echo $st->nombre; ?></option>
                <?php } ?>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Periodo *</label>
              <input type="text" class="form-control mayor_obligado" name="periodo_candidato" id="periodo_candidato">
              <br>
            </div>
            <div class="col-md-4">
              <label>Escuela *</label>
              <input type="text" class="form-control mayor_obligado" name="escuela_candidato" id="escuela_candidato">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Ciudad *</label>
              <input type="text" class="form-control mayor_obligado" name="ciudad_candidato" id="ciudad_candidato">
              <br>
            </div>
            <div class="col-md-4">
              <label>Certificado obtenido *</label>
              <input type="text" class="form-control mayor_obligado" name="certificado_candidato" id="certificado_candidato">
              <br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Analista </p>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Nivel escolar *</label>
              <select name="mayor_estudios_analista" id="mayor_estudios_analista" class="form-control mayor_obligado">
                <option value="">Selecciona</option>
                <?php foreach ($studies as $st) { ?>
                  <option value="<?php echo $st->id; ?>"><?php echo $st->nombre; ?></option>
                <?php } ?>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Periodo *</label>
              <input type="text" class="form-control mayor_obligado" name="periodo_analista" id="periodo_analista">
              <br>
            </div>
            <div class="col-md-4">
              <label>Escuela *</label>
              <input type="text" class="form-control mayor_obligado" name="escuela_analista" id="escuela_analista">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Ciudad *</label>
              <input type="text" class="form-control mayor_obligado" name="ciudad_analista" id="ciudad_analista">
              <br>
            </div>
            <div class="col-md-4">
              <label>Certificado obtenido *</label>
              <input type="text" class="form-control mayor_obligado" name="certificado_analista" id="certificado_analista">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Comentarios *</label>
              <textarea class="form-control mayor_obligado" name="mayor_estudios_comentarios" id="mayor_estudios_comentarios" rows="3"></textarea>
              <br><br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarMayoresEstudios()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="globalSearchModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Búsquedas globales del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formGlobal">
          <div class="row">
            <div class="col-12">
              <label>Global compliance & Sanctions database / General Services Administration Sanction *</label>
              <input type="text" class="form-control es_global" name="sanctions" id="sanctions">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Global media searches *</label>
              <input type="text" class="form-control es_global" name="media_searches" id="media_searches">
              <br>
            </div>
            <div class="col-md-6">
              <label>Office of the Inspector General *</label>
              <input type="text" class="form-control es_global" name="oig" id="oig">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>INTERPOL *</label>
              <input type="text" class="form-control es_global" name="interpol" id="interpol">
              <br>
            </div>
            <div class="col-md-6">
              <label>FACIS Sanction Search *</label>
              <input type="text" class="form-control es_global" name="facis" id="facis">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Bureau of Industry and Security List of Denied Persons *</label>
              <input type="text" class="form-control es_global" name="bureau" id="bureau">
              <br>
            </div>
            <div class="col-md-6">
              <label>EU Freeze List Maintained by the European Union (financial sanctions) *</label>
              <input type="text" class="form-control es_global" name="european_financial" id="european_financial">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>SAM *</label>
              <input type="text" class="form-control es_global" name="sam" id="sam">
              <br>
            </div>
            <div class="col-md-6">
              <label>OFAC *</label>
              <input type="text" class="form-control es_global" name="ofac" id="ofac">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Law enforcement *</label>
              <input type="text" class="form-control es_global" name="law_enforcement" id="law_enforcement">
              <br>
            </div>
            <div class="col-md-6">
              <label>Regulatory *</label>
              <input type="text" class="form-control es_global" name="regulatory" id="regulatory">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Other bodies *</label>
              <input type="text" class="form-control es_global" name="other_bodies" id="other_bodies">
              <br>
            </div>
            <div class="col-md-6">
              <label>USA sanctions *</label>
              <input type="text" class="form-control es_global" name="usa_sanctions" id="usa_sanctions">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>FDA department search *</label>
              <input type="text" class="form-control es_global" name="fda" id="fda">
              <br>
            </div>
            <div class="col-md-6">
              <label>SDN *</label>
              <input type="text" class="form-control es_global" name="sdn" id="sdn">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>MVR (Motor Vehicle Records) *</label>
              <input type="text" class="form-control es_global" name="mvr" id="mvr">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Comentarios *</label>
              <input type="text" class="form-control" name="global_comentarios" id="global_comentarios">
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarGlobalSearch()">Guardar</button>
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
        <div class="alert alert-info text-center">Nuevo registro</div>
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
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="generarGap()">Guardar</button>
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
<div class="modal fade" id="documentosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Documentos del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_documentos">
          <div class="alert alert-info">
            <p class="text-center">Comprobante de estudios (cedula, titulo o constancia) <br>
            <div class="text-center contenedor_documento" id="doc_estudios"></div>
            </p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Número de documento</label>
              <input type="text" class="form-control registro_documento" name="lic_profesional" id="lic_profesional">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control registro_documento" name="lic_institucion" id="lic_institucion">
              <br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Identificacion (o ID) <br>
            <div class="text-center contenedor_documento" id="doc_ine"></div>
            </p>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>ID o clave</label>
              <input type="text" class="form-control registro_documento" name="ine_clave" id="ine_clave" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" maxlength="18">
              <br>
            </div>
            <div class="col-md-4">
              <label>Año de registro</label>
              <input type="text" class="form-control solo_numeros registro_documento" name="ine_registro" id="ine_registro" maxlength="4">
              <br>
            </div>
            <div class="col-md-4">
              <label>Número vertical</label>
              <input type="text" class="form-control solo_numeros registro_documento" name="ine_vertical" id="ine_vertical" maxlength="13">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control registro_documento" name="ine_institucion" id="ine_institucion">
              <br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Número del Seguro Social (NSS)  <br>
            <div class="text-center contenedor_documento" id="doc_nss"></div>
            </p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>ID o Número</label>
              <input type="text" class="form-control registro_documento" name="nss_numero" id="nss_numero">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha de registro / Institución</label>
              <input type="text" class="form-control registro_documento" name="nss_fecha" id="nss_fecha">
              <br><br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Pasaporte <br>
            <div class="text-center contenedor_documento" id="doc_pasaporte"></div>
            </p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Número de documento</label>
              <input type="text" class="form-control registro_documento" name="pasaporte_numero" id="pasaporte_numero">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control registro_documento" name="pasaporte_institucion" id="pasaporte_institucion">
              <br><br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Carta de no antecedentes penales (carta policía) <br>
            <div class="text-center contenedor_documento" id="doc_penales"></div>
            </p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Número de documento</label>
              <input type="text" class="form-control registro_documento" name="penales_numero" id="penales_numero">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control registro_documento" name="penales_institucion" id="penales_institucion">
              <br><br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Comprobante de domicilio (servicio de electricidad o agua) <br>
            <div class="text-center contenedor_documento" id="doc_domicilio"></div>
            </p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Número de documento</label>
              <input type="text" class="form-control registro_documento" name="domicilio_numero" id="domicilio_numero">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control registro_documento" name="domicilio_fecha" id="domicilio_fecha">
              <br><br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Cartilla o carta militar <br>
            <div class="text-center contenedor_documento" id="doc_militar"></div>
            </p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Número de documento</label>
              <input type="text" class="form-control registro_documento" name="militar_numero" id="militar_numero">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control registro_documento" name="militar_fecha" id="militar_fecha">
              <br><br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Forma Migratoria FM, FM2 o FM3  <br>
            <div class="text-center contenedor_documento" id="doc_migratorio"></div>
            </p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Número de documento</label>
              <input type="text" class="form-control registro_documento" name="migratorio_numero" id="migratorio_numero">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control registro_documento" name="migratorio_fecha" id="migratorio_fecha">
              <br><br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Licencia de conducir  <br>
            <div class="text-center contenedor_documento" id="doc_licencia"></div>
            </p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Número de documento</label>
              <input type="text" class="form-control registro_documento" name="licencia_numero" id="licencia_numero">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha vencimiento / Institución</label>
              <input type="text" class="form-control registro_documento" name="licencia_fecha" id="licencia_fecha">
              <br><br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Historial de registros del vehiculo (Motor Vehicle Records) <br>
            <div class="text-center contenedor_documento" id="doc_mvr"></div>
            </p>
          </div>
          <div class="col-12">
            <label>Estatus / Comentarios</label>
            <textarea class="form-control registro_documento" name="mvr_estatus" id="mvr_estatus" rows="3"></textarea>
            <br><br>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Comentarios * </p>
          </div>
          <div class="row">
            <div class="col-md-12">
              <textarea class="form-control documento_obligado" name="doc_comentarios" id="doc_comentarios" rows="2"></textarea>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarDocumentacion()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="scopeModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Alcance de las verificaciones del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_checklist">
          <div class="row">
            <div class="col-md-4">
              <label>Educación *</label>
              <textarea class="form-control list_check" name="check_education" id="check_education" rows="2"></textarea>
              <br>
            </div>
            <div class="col-md-4">
              <label>Empleos *</label>
              <textarea class="form-control list_check" name="check_employment" id="check_employment" rows="2"></textarea>
              <br>
            </div>
            <div class="col-md-4">
              <label>Domicilios *</label>
              <textarea class="form-control list_check" name="check_address" id="check_address" rows="2"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Criminal *</label>
              <textarea class="form-control list_check" name="check_criminal" id="check_criminal" rows="2"></textarea>
              <br>
            </div>
            <div class="col-md-4">
              <label>Global database *</label>
              <textarea class="form-control list_check" name="check_database" id="check_database" rows="2"></textarea>
              <br>
            </div>
            <div class="col-md-4">
              <label>Identidad *</label>
              <textarea class="form-control list_check" name="check_identity" id="check_identity" rows="2"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <!-- <div class="col-md-4">
              <label>Servicio militar *</label>
              <textarea class="form-control list_check" name="check_military" id="check_military" rows="2"></textarea>
              <br>
            </div> -->
            <div class="col-md-4">
              <label>Prohibited parties list</label>
              <textarea class="form-control list_check" name="check_prohibited" id="check_prohibited" rows="2"></textarea>
              <br>
            </div>
            <div class="col-md-4">
              <label>Otras verificaciones *</label>
              <textarea class="form-control list_check" name="check_other" id="check_other" rows="2"></textarea>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="actualizarChecklist()">Guardar</button>
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
        <ul id="listado_revision">
          <li>Datos generales</li>
          <li>Historial académico</li>
          <li>Verificación de documentos</li>
          <li>Información familiar</li>
          <li>Referencias personales</li>
          <li>Referencias laborales</li>
          <li>Verificación de estudios</li>
          <li>Verificación de referencias laborales</li>
          <li>Verificación de antecedentes no penales</li>
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
        <form id="formChecks">
          <div class="row">
            <div class="col-md-4" id="final_identity">
              <label>Identidad *</label>
              <select name="check_identidad" id="check_identidad" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_employment">
              <label>Historial de empleos *</label>
              <select name="check_laboral" id="check_laboral" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_education">
              <label>Estudios *</label>
              <select name="check_estudios" id="check_estudios" class="form-control estatus_finales">
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
            <div class="col-md-4" id="final_visit">
              <label>Visita al domicilio *</label>
              <select name="check_visita" id="check_visita" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_criminal">
              <label>Antecedentes criminales*</label>
              <select name="check_penales" id="check_penales" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_ofacs">
              <label>OFAC *</label>
              <select name="check_ofac" id="check_ofac" class="form-control estatus_finales">
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
            <div class="col-md-4" id="final_medical">
              <label>Examen médico *</label>
              <select name="check_medico" id="check_medico" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_global">
              <label>Global data searches *</label>
              <select name="check_global" id="check_global" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_domicilios">
              <label>Historial de domicilios *</label>
              <select name="check_domicilio" id="check_domicilio" class="form-control estatus_finales">
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
            <div class="col-md-4" id="final_credito">
              <label>Historial crediticio *</label>
              <select name="check_credito" id="check_credito" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_sex_offender">
              <label>Agresor sexual *</label>
              <select name="check_sex_offender" id="check_sex_offender" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_professional_accreditation">
              <label>Acreditación profesional *</label>
              <select name="check_professional_accreditation" id="check_professional_accreditation" class="form-control estatus_finales">
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
            <div class="col-md-4" id="final_ref_academica">
              <label>Referencias académicas *</label>
              <select name="check_ref_academica" id="check_ref_academica" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_nss">
              <label>Número de Seguro Social (NSS) *</label>
              <select name="check_nss" id="check_nss" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_ciudadania">
              <label>Ciudadanía (Pasaporte) *</label>
              <select name="check_ciudadania" id="check_ciudadania" class="form-control estatus_finales">
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
            <div class="col-md-4" id="final_mvr">
              <label>Historial de registros del vehiculo (Motor Vehicle Records) *</label>
              <select name="check_mvr" id="check_mvr" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_servicio_militar">
              <label>Servicio militar *</label>
              <select name="check_servicio_militar" id="check_servicio_militar" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_credencial_academica">
              <label>Credencial académica *</label>
              <select name="check_credencial_academica" id="check_credencial_academica" class="form-control estatus_finales">
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
            <div class="col-md-4" id="final_ref_profesional">
              <label>Referencias profesionales *</label>
              <select name="check_ref_profesional" id="check_ref_profesional" class="form-control estatus_finales">
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
            <div class="col-md-4 offset-4">
              <label>Estatus final del BGC *</label>
              <select name="bgc_status" id="bgc_status" class="form-control check_obligado">
                <option value="">Selecciona</option>
                <option value="2">Negative</option>
                <option value="1">Positive</option>
                <option value="3">For Consideration (FC)</option>
              </select>
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
<div class="modal fade" id="checklistModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Checklist del candidato</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formChecklist">
          <div class="row">
            <div class="col-md-4" id="final_identity">
              <label>Identidad *</label>
              <select name="checklist_identidad" id="checklist_identidad" class="form-control campoChecklist">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
                <option value="4">Pending</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_employment">
              <label>Historial de empleos *</label>
              <select name="checklist_laboral" id="checklist_laboral" class="form-control campoChecklist">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
                <option value="4">Pending</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_education">
              <label>Estudios *</label>
              <select name="checklist_estudios" id="checklist_estudios" class="form-control campoChecklist">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
                <option value="4">Pending</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4" id="final_criminal">
              <label>Antecedentes criminales*</label>
              <select name="checklist_penales" id="checklist_penales" class="form-control campoChecklist">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
                <option value="4">Pending</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_ofacs">
              <label>OFAC *</label>
              <select name="checklist_ofac" id="checklist_ofac" class="form-control campoChecklist">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
                <option value="3">NA</option>
                <option value="4">Pending</option>
              </select>
              <br>
            </div>
            <div class="col-md-4" id="final_global">
              <label>Global data searches *</label>
              <select name="checklist_global" id="checklist_global" class="form-control campoChecklist">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">For Consideration (FC)</option>
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
        <button type="button" class="btn btn-success" onclick="actualizarChecks()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="AddressModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Historial de domicilios del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        for ($i = 1; $i <= 10; $i++) { ?>
          <form id="d_address<?php echo $i; ?>">
            <div class="alert alert-info">
              <p class="text-center"><?php echo 'Direccion #' . $i; ?></p>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>Periodo</label>
                <input type="text" class="form-control address_obligado<?php echo $i; ?>" name="address_periodo<?php echo $i; ?>" id="address_periodo<?php echo $i; ?>">
                <br>
              </div>
              <div class="col-md-4">
                <label>Causa de salida *</label>
                <input type="text" class="form-control address_obligado<?php echo $i; ?>" name="address_causa<?php echo $i; ?>" id="address_causa<?php echo $i; ?>">
                <br>
              </div>
              <div class="col-md-4">
                <label>Calle *</label>
                <input type="text" class="form-control address_obligado<?php echo $i; ?>" name="address_calle<?php echo $i; ?>" id="address_calle<?php echo $i; ?>">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>No. Exterior *</label>
                <input type="text" class="form-control address_obligado<?php echo $i; ?>" name="address_exterior<?php echo $i; ?>" id="address_exterior<?php echo $i; ?>">
                <br>
              </div>
              <div class="col-md-4">
                <label>No. Interior </label>
                <input type="text" class="form-control address_obligado<?php echo $i; ?>" name="address_interior<?php echo $i; ?>" id="address_interior<?php echo $i; ?>">
                <br>
              </div>
              <div class="col-md-4">
                <label>Colonia *</label>
                <input type="text" class="form-control address_obligado<?php echo $i; ?>" name="address_colonia<?php echo $i; ?>" id="address_colonia<?php echo $i; ?>">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>Estado *</label>
                <select name="address_estado<?php echo $i; ?>" id="address_estado<?php echo $i; ?>" class="form-control address_obligado<?php echo $i; ?> address_estado">
                  <option value="">Select</option>
                  <?php foreach ($estados as $e) { ?>
                    <option value="<?php echo $e->id; ?>"><?php echo $e->nombre; ?></option>
                  <?php } ?>
                </select>
                <br>
              </div>
              <div class="col-md-4">
                <label>Municipio *</label>
                <select name="address_municipio<?php echo $i; ?>" id="address_municipio<?php echo $i; ?>" class="form-control address_obligado<?php echo $i; ?>" disabled>
                  <option value="">Select</option>
                </select>
                <br>
              </div>
              <div class="col-md-4">
                <label>CP *</label>
                <input type="text" class="form-control address_obligado<?php echo $i; ?>" name="address_cp<?php echo $i; ?>" id="address_cp<?php echo $i; ?>" maxlength="5">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 offset-5">
                <button type="button" class="btn btn-success" onclick="guardarAddress(<?php echo $i; ?>)">Guardar</button>
                <input type="hidden" id="idAddress<?php echo $i; ?>">
                <br><br>
              </div>
            </div>
            <div id="msj_error_address_<?php echo $i; ?>" class="alert alert-danger hidden"></div>
          </form>
        <?php
        }
        ?>
        <div class="row">
          <div class="col-md-12">
            <label>Comentarios *</label>
            <input type="text" class="form-control address_comentario_obligado" name="address_comentarios" id="address_comentarios">
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 offset-5">
            <button type="button" class="btn btn-success" onclick="guardarComentarioAddress(<?php echo $i; ?>)">Guardar comentario</button><br><br>
          </div>
        </div>
        <div id="msj_error_address_comentario" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="customAddressModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Historial de domicilios del candidato: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        for ($i = 1; $i <= 10; $i++) { ?>
          <form id="d_custom_address<?php echo $i; ?>">
            <div class="alert alert-info">
              <p class="text-center"><?php echo 'Direccion #' . $i; ?></p>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>Periodo</label>
                <input type="text" class="form-control custom_address_obligado<?php echo $i; ?>" name="custom_periodo<?php echo $i; ?>" id="custom_periodo<?php echo $i; ?>">
                <br>
              </div>
              <div class="col-md-4">
                <label>Causa de salida *</label>
                <input type="text" class="form-control custom_address_obligado<?php echo $i; ?>" name="custom_causa<?php echo $i; ?>" id="custom_causa<?php echo $i; ?>">
                <br>
              </div>
              <div class="col-md-4">
                <label>Calle *</label>
                <input type="text" class="form-control custom_address_obligado<?php echo $i; ?>" name="custom_calle<?php echo $i; ?>" id="custom_calle<?php echo $i; ?>">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>No. Exterior *</label>
                <input type="text" class="form-control custom_address_obligado<?php echo $i; ?>" name="custom_exterior<?php echo $i; ?>" id="custom_exterior<?php echo $i; ?>">
                <br>
              </div>
              <div class="col-md-4">
                <label>No. Interior</label>
                <input type="text" class="form-control custom_address_obligado<?php echo $i; ?>" name="custom_interior<?php echo $i; ?>" id="custom_interior<?php echo $i; ?>">
                <br>
              </div>
              <div class="col-md-4">
                <label>Colonia *</label>
                <input type="text" class="form-control custom_address_obligado<?php echo $i; ?>" name="custom_colonia<?php echo $i; ?>" id="custom_colonia<?php echo $i; ?>">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>Estado *</label>
                <select name="custom_estado<?php echo $i; ?>" id="custom_estado<?php echo $i; ?>" class="form-control custom_address_obligado<?php echo $i; ?> custom_estado">
                  <option value="">Selecciona</option>
                  <?php foreach ($estados as $e) { ?>
                    <option value="<?php echo $e->id; ?>"><?php echo $e->nombre; ?></option>
                  <?php } ?>
                </select>
                <br>
              </div>
              <div class="col-md-4">
                <label>Municipio *</label>
                <select name="custom_municipio<?php echo $i; ?>" id="custom_municipio<?php echo $i; ?>" class="form-control custom_address_obligado<?php echo $i; ?>" disabled>
                  <option value="-1">Selecciona</option>
                </select>
                <br>
              </div>
              <div class="col-md-4">
                <label>CP *</label>
                <input type="text" class="form-control custom_address_obligado<?php echo $i; ?>" name="custom_cp<?php echo $i; ?>" id="custom_cp<?php echo $i; ?>" maxlength="5">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 offset-5">
                <button type="button" class="btn btn-success" onclick="guardarCustomAddress(<?php echo $i; ?>)">Guardar</button>
                <input type="hidden" id="idCustomAddress<?php echo $i; ?>">
                <br><br>
              </div>
            </div>
            <div id="msj_error_custom_address<?php echo $i; ?>" class="alert alert-danger hidden"></div>
          </form>
        <?php
        }
        ?>
        <div class="row">
          <div class="col-md-12">
            <label>Comentarios *</label>
            <input type="text" class="form-control custom_comentario_obligado" name="custom_address_comentarios" id="custom_address_comentarios">
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 offset-5">
            <button type="button" class="btn btn-success" onclick="guardarComentarioCustomAddress(<?php echo $i; ?>)">Guardar comentario</button><br><br>
          </div>
        </div>
        <div id="msj_error_custom_address_comentario" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
        <input id="doc_medico" name="doc_medico" class="medico_obligado" type="file" accept=".pdf"><br><br>
        <br>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="subirExamenMedico()">Subir</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="confirmarAccionModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titulo_confirmacion"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 id="mensaje_confirmacion"></h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="aceptarConfirmacion()">Confirmar</button>
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
                foreach ($paquetes_antidoping as $paq) { ?>
                  <option value="<?php echo $paq->id; ?>"><?php echo $paq->nombre.' ('.$paq->conjunto.')'; ?></option>
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
<!-- Modales para proyectos internacionales -->
<div class="modal fade" id="generalesInternacionalModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Datos generales del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formGeneralesInternacional">
          <div class="row">
            <div class="col-md-4">
              <label>Nombre(s) *</label>
              <input type="text" class="form-control inter_personal_obligado" name="nombre_internacional" id="nombre_internacional" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Primer apellido *</label>
              <input type="text" class="form-control inter_personal_obligado" name="paterno_internacional" id="paterno_internacional" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Segundo apellido </label>
              <input type="text" class="form-control" name="materno_internacional" id="materno_internacional" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Fecha de nacimiento *</label>
              <input type="text" class="form-control inter_personal_obligado" name="fecha_nacimiento_internacional" id="fecha_nacimiento_internacional"  placeholder="dd/mm/yyyy">
              <br>
            </div>
            <div class="col-md-4">
              <label>Nacionalidad *</label>
              <input type="text" class="form-control inter_personal_obligado" name="nacionalidad_internacional" id="nacionalidad_internacional">
              <br>
            </div>
            <div class="col-md-4">
              <label>Puesto *</label>
              <input type="text" class="form-control inter_personal_obligado" name="puesto_internacional" id="puesto_internacional">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Género: *</label>
              <select name="genero_internacional" id="genero_internacional" class="form-control inter_personal_obligado">
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Estado civil *</label>
              <select name="civil_internacional" id="civil_internacional" class="form-control personal_obligado">
                <option value="">Selecciona</option>
                <option value="Married">Married</option>
                <option value="Single">Single</option>
                <option value="Divorced">Divorced</option>
                <option value="Free Union">Free Union</option>
                <option value="Widowed">Widowed</option>
                <option value="Separated">Separated</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Domicilio *</label>
              <input type="text" class="form-control inter_personal_obligado" name="domicilio_internacional" id="domicilio_internacional">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>País *</label>
              <select name="pais_internacional" id="pais_internacional" class="form-control inter_personal_obligado">
                <option value="">Select</option>
                <?php foreach ($paises as $pais) { ?>
                  <option value="<?php echo $pais->nombre; ?>"><?php echo $pais->nombre; ?></option>
                <?php } ?>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Tel. Celular *</label>
              <input type="text" class="form-control solo_numeros inter_personal_obligado" name="celular_internacional" id="celular_internacional" maxlength="10">
              <br>
            </div>
            <div class="col-md-4">
              <label>Tel. Casa </label>
              <input type="text" class="form-control solo_numeros" name="tel_casa_internacional" id="tel_casa_internacional" maxlength="10">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Otro teléfono </label>
              <input type="text" class="form-control solo_numeros" name="tel_oficina_internacional" id="tel_oficina_internacional" maxlength="10">
              <br>
            </div>
            <div class="col-md-4">
              <label>Correo *</label>
              <input type="text" class="form-control inter_personal_obligado" name="correo_internacional" id="correo_internacional">
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarGeneralesInternacional()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="refProfesionalesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Referencias profesionales del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="contenedor_ref_profesionales"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="AddressInternacionalModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Historial de domicilios del candidato: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        for ($i = 1; $i <= 10; $i++) { ?>
          <form id="d_address_internacional<?php echo $i; ?>">
            <div class="alert alert-info">
              <p class="text-center"><?php echo 'Direccion #' . $i; ?></p>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>Periodo</label>
                <input type="text" class="form-control address_obligado_internacional<?php echo $i; ?>" name="address_periodo_internacional<?php echo $i; ?>" id="address_periodo_internacional<?php echo $i; ?>">
                <br>
              </div>
              <div class="col-md-6">
                <label>Causa de salida *</label>
                <input type="text" class="form-control address_obligado_internacional<?php echo $i; ?>" name="address_causa_internacional<?php echo $i; ?>" id="address_causa_internacional<?php echo $i; ?>">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>Domicilio *</label>
                <input type="text" class="form-control address_obligado_internacional<?php echo $i; ?>" name="address_domicilio_internacional<?php echo $i; ?>" id="address_domicilio_internacional<?php echo $i; ?>">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label>País *</label>
                <select name="address_pais_internacional<?php echo $i; ?>" id="address_pais_internacional<?php echo $i; ?>" class="form-control address_obligado_internacional<?php echo $i; ?>">
                  <option value="">Selecciona</option>
                  <?php foreach ($paises as $p) { ?>
                    <option value="<?php echo $p->nombre; ?>"><?php echo $p->nombre; ?></option>
                  <?php } ?>
                </select>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 offset-5">
                <button type="button" class="btn btn-success" onclick="guardarAddressInternacional(<?php echo $i; ?>)">Guardar</button>
                <input type="hidden" id="idAddressInternacional<?php echo $i; ?>">
                <br><br>
              </div>
            </div>
            <div id="msj_error<?php echo $i; ?>" class="alert alert-danger hidden"></div>
          </form>
        <?php
        }
        ?>
        <div class="row">
          <div class="col-md-12">
            <label>Comentarios *</label>
            <input type="text" class="form-control address_internacional_comentario_obligado" name="address_comentarios_internacional" id="address_comentarios_internacional">
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 offset-4">
            <button type="button" class="btn btn-success" onclick="guardarComentarioAddressInternacional(<?php echo $i; ?>)">Guardar comentario</button><br><br>
          </div>
        </div>
        <div id="msj_error_comentario" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
<div class="modal fade" id="refPersonalesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Referencias personales del candidato: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="contenedor_ref_personales"></div>
        <div id="boton_ref_personales"></div>
        <br>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="fechaInicioModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Fecha de inicio del proceso del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          <p>* Esta fecha se tomará en cuenta como el inicio del ESE. Se debe registrar la fecha una vez que el candidato haya proporcionado la información completa para iniciar con su proceso</p>
        </div>
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <label>Fecha *</label>
            <input class="form-control" name="fecha_inicio_proceso" id="fecha_inicio_proceso" placeholder="dd/mm/yyyy">
            <br>
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarFechaInicioProceso()">Guardar</button>
      </div>
    </div>
  </div>
</div>






<div class="modal fade" id="ofacModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Verificación OFAC y OIG</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4 col-md-offset-2">
            <p class="text-center"><b>Nombre del candidato</b></p>
            <p class="text-center" id="ofac_nombrecandidato"></p>
          </div>
          <div class="col-md-4">
            <p class="text-center" id="fecha_titulo_ofac"><b></b></p>
            <p class="text-center" id="fecha_estatus_ofac"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <label for="estatus_ofac">Estatus OFAC *</label>
            <textarea class="form-control ofac" name="estatus_ofac" id="estatus_ofac" rows="3" placeholder="Estatus OFAC"></textarea>
            <input type="hidden" id="idCliente">
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <label for="res_ofac">Resultado *</label>
            <select name="res_ofac" id="res_ofac" class="form-control ofac">
              <option value="">Select</option>
              <option value="1">Positivo</option>
              <option value="0">Negativo</option>
            </select>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <label for="estatus_oig">Estatus OIG *</label>
            <textarea class="form-control ofac" name="estatus_oig" id="estatus_oig" rows="3" placeholder="Estatus OIG"></textarea>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <label for="res_oig">Resultado *</label>
            <select name="res_oig" id="res_oig" class="form-control ofac">
              <option value="">Select</option>
              <option value="1">Positivo</option>
              <option value="0">Negativo</option>
            </select>
            <br><br><br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div id="campos_vacios_ofac">
              <p class="msj_error text-center">Hay campos vacíos</p>
            </div>
          </div>
          <div class="col-md-3 col-md-offset-1">
            <a class="btn btn-app btn_verificacion" onclick="actualizarOfac()">Actualizar verificación</a>
          </div>
          <br>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="completarOfacModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Finalizar proceso del candidato</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="ofac_incompleto" style="display: none;">
          <h4 class="text-center" id="ofac_msjIncompleto"></h4>
        </div>
        <div id="ofac_completo" style="display: none;">
          <form id="ofacChecks">
            <div class="row">
              <div class="col-md-12">
                <label>Informe final *</label>
                <textarea class="form-control fin_ofac_obligado" name="ofac_comentario_final" id="ofac_comentario_final" rows="3"></textarea>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 col-md-offset-4">
                <label>Estatus final *</label>
                <select name="ofac_estatus_final" id="ofac_estatus_final" class="form-control fin_ofac_obligado">
                  <option value="">Select</option>
                  <option value="1">Positivo</option>
                  <option value="2">Negativo</option>
                  <option value="3">A consideración</option>
                </select>
                <br>
              </div>
            </div>
          </form>
          <div id="campos_vacios_ofac_final">
            <p class="msj_error text-center">Hay campos vacíos</p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" id="btnOfac" class="btn btn-danger" style="display: none;" onclick="finalizarOfac()">Terminar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="verModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titulo_accion"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 id="nombre_candidato"></h4><br>
        <p class="" id="motivo"></p><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
            <input type="file" id="documento" class="doc_obligado" name="documento" accept=".jpg, .png, .jpeg, .pdf"><br><br>
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
<div class="modal fade" id="refAcademicaModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Referencias académicas del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body escrolable">
        <form id="formRefAcademica">
          <div class="row" id="rowRefAcademica"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCerrar">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnConfirmar">Confirmar</button>
      </div>
    </div>
  </div>
</div>
<script>
  $('.div_info_project, .div_project, .div_info_previo, .div_previo, .div_info_check, .div_check, .div_info_test, .div_test, .div_info_extra, .div_extra').css('display','none');

  $('#avancesModal').on('hidden.bs.modal', function(e) {
    $("#avancesModal #msj_error").css('display', 'none');
    $("#avancesModal input, #avancesModal textarea").val('');
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
    $('.valor_dinamico').prop('disabled',true);
    $('#ref_profesionales_registro').val(0);
    $('#ref_personales_registro').val(0);
    $('#examen_registro, #examen_medico, #previo').val(0);
    $('#opcion_registro').val('').trigger('change');
    $('#div_docs_extras').empty();
    extras = [];
  });
  $('#mensajeModal').on('hidden.bs.modal', function(e) {
    $("#mensajeModal #titulo_mensaje, #mensajeModal #mensaje").text('');
    $("#mensajeModal #campos_mensaje").empty();
    $("#mensajeModal #btnConfirmar").removeAttr('onclick');
  });
  $('#generalesModal').on('hidden.bs.modal', function(e) {
    $("#generalesModal #msj_error").css('display', 'none');
  });
  $('#contactoModal').on('hidden.bs.modal', function(e) {
    $("#contactoModal #msj_error").css('display', 'none');
    $("#contactoModal input").val('');
  });
  $('#mayoresEstudiosModal').on('hidden.bs.modal', function(e) {
    $("#mayoresEstudiosModal #msj_error").css('display', 'none');
    $("#mayoresEstudiosModal input, #mayoresEstudiosModal textarea").val('');
  });
  $('#generalesInternacionalModal').on('hidden.bs.modal', function(e) {
    $("#generalesInternacionalModal #msj_error").css('display', 'none');
  });
  $('#academicosModal').on('hidden.bs.modal', function(e) {
    $("#academicosModal #msj_error").css('display', 'none');
  });
  $('#globalSearchModal').on('hidden.bs.modal', function(e) {
    $("#globalSearchModal #msj_error").css('display', 'none');
    $("#globalSearchModal input").val('');
  });
  $('#gapsModal').on('hidden.bs.modal', function(e) {
    $("#gapsModal #msj_error").css('display', 'none');
    $("#div_antesgap").empty();
    $("#gapsModal input, #gapsModal textarea").val('');
  });
  $('#documentosModal').on('hidden.bs.modal', function(e) {
    $("#documentosModal #msj_error").css('display', 'none');
    $("#documentosModal input, #documentosModal textarea").val('');
  });
  $('#familiaresModal').on('hidden.bs.modal', function(e) {
    $("#familiaresModal input[id^='msj_error']").css('display', 'none');
  });
  $('#refProfesionalesModal').on('hidden.bs.modal', function(e) {
    $("#refProfesionalesModal input[id^='refpro_msj_error']").css('display', 'none');
  });
  $('#refPersonalesModal').on('hidden.bs.modal', function(e) {
    $("#refPersonalesModal div[id^='msj_error']").css('display', 'none');
    $("#contenedor_ref_personales").empty();
    $("#boton_ref_personales").empty();
  });
  $('#verificacionEstudiosModal').on('hidden.bs.modal', function(e) {
    $("#verificacionEstudiosModal #msj_error").css('display', 'none');
    $("#verificacionEstudiosModal textarea").val('');
  });
  $('#verificacionLaboralesModal').on('hidden.bs.modal', function(e) {
    $("#verificacionLaboralesModal #msj_error").css('display', 'none');
    $("#verificacionLaboralesModal textarea").val('');
  });
  $('#verificacionPenalesModal').on('hidden.bs.modal', function(e) {
    $("#verificacionPenalesModal #msj_error").css('display', 'none');
    $("#verificacionPenalesModal textarea").val('');
  });
  $('#scopeModal').on('hidden.bs.modal', function(e) {
    $("#scopeModal #msj_error").css('display', 'none');
    $("#scopeModal textarea").val('');
  });
  $('#docsModal').on('hidden.bs.modal', function(e) {
    $("#docsModal #msj_error").css('display', 'none');
    $("#docsModal input, #docsModal select").val('');
  });
  $('#completarModal').on('hidden.bs.modal', function(e) {
    $("#completarModal #msj_error").css('display', 'none');
    $("#completarModal textarea, #completarModal select").val('');
  });
  $('#ofacModal').on('hidden.bs.modal', function(e) {
    $("#ofacModal #msj_error").css('display', 'none');
    $("#ofacModal textarea, #ofacModal select").val('');
  });
  $('#fechaModal').on('hidden.bs.modal', function(e) {
    $("#fechaModal #msj_error").css('display', 'none');
    $("#fechaModal input").val('');
  });
  $('#completarFacisModal').on('hidden.bs.modal', function(e) {
    $("#completarFacisModal #msj_error").css('display', 'none');
    $("#completarFacisModal textarea, #completarFacisModal select").val('');
  });
  $('#creditoModal').on('hidden.bs.modal', function(e) {
    $("#creditoModal #msj_error").css('display', 'none');
    $("#creditoModal input, #creditoModal textarea").val('');
  });
  $('#medicoModal').on('hidden.bs.modal', function(e) {
    $("#medicoModal #msj_error").css('display', 'none');
    $("#medicoModal input").val('');
  });
  $('#pruebasModal').on('hidden.bs.modal', function(e) {
    $("#pruebasModal #msj_error").css('display', 'none');
    $("#pruebasModal select").val('');
  });
  $('#fechaInicioModal').on('hidden.bs.modal', function(e) {
    $("#fechaInicioModal #msj_error").css('display', 'none');
    $("#fechaInicioModal input").val('');
  });
  $('#AddressModal').on('hidden.bs.modal', function(e) {
    $('#Addressmodal div[id^="msj_error_address_"]').css('display','none');
    $("#AddressModal #msj_error_address_comentario").css('display', 'none');
    $("#AddressModal input").val('');
    $('#address_estado').val('').trigger('change');
  });
  $('#AddressModal').on('hidden.bs.modal', function(e) {
    $('#Addressmodal div[id^="msj_error_address_"]').css('display','none');
    $("#AddressModal #msj_error_address_comentario").css('display', 'none');
    $("#AddressModal input").val('');
    $('#address_estado').val('').trigger('change');
  });
  $('#AddressInternacionalModal').on('hidden.bs.modal', function(e) {
    $('#AddressInternacionalModal div[id^="msj_error"]').css('display','none');
    $("#AddressInternacionalModal #msj_error_comentario").css('display', 'none');
    $("#AddressInternacionalModal input, #AddressInternacionalModal select").val('');
  });
  $('#customAddressModal').on('hidden.bs.modal', function(e) {
    $('#customAddressModal div[id^="msj_error_custom_address"]').css('display','none');
    $("#customAddressModal #msj_error_custom_address_comentario").css('display', 'none');
    $("#customAddressModal input").val('');
    $('#custom_estado').val('').trigger('change');
  });
  $('#refAcademicaModal').on('hidden.bs.modal', function(e) {
    $('#rowRefAcademica').empty();
  });
  $('#quitarModal').on('hidden.bs.modal', function(e) {
    $("#quitarModal #titulo_accion, #quitarModal #texto_confirmacion").text('');
    $("#quitarModal #campos_mensaje").empty();
    $("#quitarModal #btnGuardar").removeAttr('onclick');
  });
</script>