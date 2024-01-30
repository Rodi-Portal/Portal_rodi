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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="newModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registrar candidato</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="datos">
          <div class="row">
            <div class="col-md-4">
              <label>Nombre(s) *</label>
              <input type="text" class="form-control registro_obligado" name="nombre_nuevo" id="nombre_nuevo">
              <br>
            </div>
            <div class="col-md-4">
              <label>Primer apellido *</label>
              <input type="text" class="form-control registro_obligado" name="paterno_nuevo" id="paterno_nuevo">
              <br>
            </div>
            <div class="col-md-4">
              <label>Segundo apellido</label>
              <input type="text" class="form-control" name="materno_nuevo" id="materno_nuevo">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Email</label>
              <input type="email" class="form-control" name="correo_nuevo" id="correo_nuevo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Tel. Celular</label>
              <input type="text" class="form-control" name="celular_nuevo" id="celular_nuevo" maxlength="16">
              <br>
            </div>
            <div class="col-md-4">
              <label>Tel. Casa </label>
              <input type="text" class="form-control" name="fijo_nuevo" id="fijo_nuevo" maxlength="16">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Fecha de nacimiento</label>
              <input type="text" class="form-control" name="fecha_nacimiento_nuevo" id="fecha_nacimiento_nuevo" placeholder="mm/dd/yyyy">
              <br>
            </div>
            <div class="col-md-4">
              <label>Tipo de proceso *</label>
              <select name="proceso_nuevo" id="proceso_nuevo" class="form-control registro_obligado">
                <option value="">Selecciona</option>
                <option value="1">ESE</option>
                <option value="7">ESE Internacional</option>
                <option value="8">ESE - WORLD CHECK</option>
                <option value="2">FACIS</option>
                <option value="6">WORLD CHECK</option>
              </select>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="registrarCandidato()">Guardar</button>
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
<div class="modal fade" id="generalesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Datos generales del candidato: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_generales">
          <div class="row">
            <div class="col-md-4">
              <label>Name *</label>
              <input type="text" class="form-control personal_obligado" name="nombre_general" id="nombre_general">
              <br>
            </div>
            <div class="col-md-4">
              <label>First lastname *</label>
              <input type="text" class="form-control personal_obligado" name="paterno_general" id="paterno_general">
              <br>
            </div>
            <div class="col-md-4">
              <label>Second lastname </label>
              <input type="text" class="form-control" name="materno_general" id="materno_general">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Birthdate *</label>
              <input type="text" class="form-control personal_obligado" name="fecha_nacimiento" id="fecha_nacimiento">
              <br>
            </div>
            <div class="col-md-4">
              <label>Nationality *</label>
              <input type="text" class="form-control personal_obligado" name="nacionalidad" id="nacionalidad">
              <br>
            </div>
            <div class="col-md-4">
              <label>Job Position Requested *</label>
              <input type="text" class="form-control personal_obligado" name="puesto_general" id="puesto_general">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Gender: *</label>
              <select name="genero" id="genero" class="form-control personal_obligado">
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Address *</label>
              <input type="text" class="form-control personal_obligado" name="calle" id="calle">
              <br>
            </div>
            <div class="col-md-4">
              <label>Ext. Number *</label>
              <input type="text" class="form-control personal_obligado" name="exterior" id="exterior" maxlength="8">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Int. Number </label>
              <input type="text" class="form-control" name="interior" id="interior" maxlength="8">
              <br>
            </div>
            <div class="col-md-4">
              <label>Neighborhood *</label>
              <input type="text" class="form-control personal_obligado" name="colonia" id="colonia">
              <br>
            </div>
            <div class="col-md-4">
              <label>State *</label>
              <select name="estado" id="estado" class="form-control personal_obligado">
                <option value="">Select</option>
                <?php foreach ($estados as $e) { ?>
                  <option value="<?php echo $e->id; ?>"><?php echo $e->nombre; ?></option>
                <?php } ?>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>City *</label>
              <select name="municipio" id="municipio" class="form-control personal_obligado" disabled>
                <option value="">Select</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Zip Code *</label>
              <input type="text" class="form-control solo_numeros personal_obligado" name="cp" id="cp" maxlength="5">
              <br>
            </div>
            <div class="col-md-4">
              <label>Marital Status *</label>
              <select name="civil" id="civil" class="form-control personal_obligado">
                <option value="">Select</option>
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
            <div class="col-md-4">
              <label>Mobile Number *</label>
              <input type="text" class="form-control personal_obligado" name="celular_general" id="celular_general" maxlength="16">
              <br>
            </div>
            <div class="col-md-4">
              <label>Home Number </label>
              <input type="text" class="form-control" name="tel_casa" id="tel_casa" maxlength="16">
              <br>
            </div>
            <div class="col-md-4">
              <label>Number to leave Messages </label>
              <input type="text" class="form-control" name="tel_oficina" id="tel_oficina" maxlength="16">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Email *</label>
              <input type="text" class="form-control personal_obligado" name="personales_correo" id="personales_correo">
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
<div class="modal fade" id="generales2Modal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Datos generales del candidato: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_generales">
          <div class="row">
            <div class="col-md-4">
              <label>Name *</label>
              <input type="text" class="form-control personal_obligado" name="nombre_general_2" id="nombre_general_2">
              <br>
            </div>
            <div class="col-md-4">
              <label>First lastname *</label>
              <input type="text" class="form-control personal_obligado" name="paterno_general_2" id="paterno_general_2">
              <br>
            </div>
            <div class="col-md-4">
              <label>Second lastname </label>
              <input type="text" class="form-control" name="materno_general_2" id="materno_general_2">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Birthdate *</label>
              <input type="text" class="form-control personal_obligado" name="fecha_nacimiento_2" id="fecha_nacimiento_2">
              <br>
            </div>
            <div class="col-md-4">
              <label>Nationality *</label>
              <input type="text" class="form-control personal_obligado" name="nacionalidad_2" id="nacionalidad_2">
              <br>
            </div>
            <div class="col-md-4">
              <label>Job Position Requested *</label>
              <input type="text" class="form-control personal_obligado" name="puesto_general_2" id="puesto_general_2">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Gender: *</label>
              <select name="genero_2" id="genero_2" class="form-control personal_obligado">
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Marital Status *</label>
              <select name="civil_2" id="civil_2" class="form-control personal_obligado">
                <option value="">Select</option>
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
            <div class="col-12">
              <label>Full address *</label>
              <input type="text" class="form-control personal_obligado" name="domicilio_internacional" id="domicilio_internacional">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Mobile Number *</label>
              <input type="text" class="form-control personal_obligado" name="celular_general_2" id="celular_general_2" maxlength="16">
              <br>
            </div>
            <div class="col-md-4">
              <label>Home Number </label>
              <input type="text" class="form-control" name="tel_casa_2" id="tel_casa_2" maxlength="16">
              <br>
            </div>
            <div class="col-md-4">
              <label>Number to leave Messages </label>
              <input type="text" class="form-control" name="tel_oficina_2" id="tel_oficina_2" maxlength="16">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Email *</label>
              <input type="text" class="form-control personal_obligado" name="personales_correo_2" id="personales_correo_2">
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarGenerales2()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="academicosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Historial académico del candidato: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_estudios">
          <div class="alert alert-info">
            <p class="text-center">Elementary School </p>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Period *</label>
              <input type="text" class="form-control estudios_obligado" name="prim_periodo" id="prim_periodo">
              <br>
            </div>
            <div class="col-md-4">
              <label>Institute *</label>
              <input type="text" class="form-control estudios_obligado" name="prim_escuela" id="prim_escuela">
              <br>
            </div>
            <div class="col-md-4">
              <label>City *</label>
              <input type="text" class="form-control estudios_obligado" name="prim_ciudad" id="prim_ciudad">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Certificate Obtained *</label>
              <input type="text" class="form-control estudios_obligado" name="prim_certificado" id="prim_certificado">
              <br>
            </div>
            <div class="col-md-4">
              <label>Validated *</label>
              <select name="prim_validado" id="prim_validado" class="form-control">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
              <br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Middle School </p>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Period *</label>
              <input type="text" class="form-control estudios_obligado" name="sec_periodo" id="sec_periodo">
              <br>
            </div>
            <div class="col-md-4">
              <label>Institute *</label>
              <input type="text" class="form-control estudios_obligado" name="sec_escuela" id="sec_escuela">
              <br>
            </div>
            <div class="col-md-4">
              <label>City *</label>
              <input type="text" class="form-control estudios_obligado" name="sec_ciudad" id="sec_ciudad">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Certificate Obtained *</label>
              <input type="text" class="form-control estudios_obligado" name="sec_certificado" id="sec_certificado">
              <br>
            </div>
            <div class="col-md-4">
              <label>Validated *</label>
              <select name="sec_validado" id="sec_validado" class="form-control">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
              <br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">High School </p>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Period *</label>
              <input type="text" class="form-control estudios_obligado" name="prep_periodo" id="prep_periodo">
              <br>
            </div>
            <div class="col-md-4">
              <label>Institute *</label>
              <input type="text" class="form-control estudios_obligado" name="prep_escuela" id="prep_escuela">
              <br>
            </div>
            <div class="col-md-4">
              <label>City *</label>
              <input type="text" class="form-control estudios_obligado" name="prep_ciudad" id="prep_ciudad">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Certificado *</label>
              <input type="text" class="form-control estudios_obligado" name="prep_certificado" id="prep_certificado">
              <br>
            </div>
            <div class="col-md-4">
              <label>Validated *</label>
              <select name="prep_validado" id="prep_validado" class="form-control">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
              <br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">College </p>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Period *</label>
              <input type="text" class="form-control estudios_obligado" name="lic_periodo" id="lic_periodo">
              <br>
            </div>
            <div class="col-md-4">
              <label>Institute *</label>
              <input type="text" class="form-control estudios_obligado" name="lic_escuela" id="lic_escuela">
              <br>
            </div>
            <div class="col-md-4">
              <label>City *</label>
              <input type="text" class="form-control estudios_obligado" name="lic_ciudad" id="lic_ciudad">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Certificate Obtained *</label>
              <input type="text" class="form-control estudios_obligado" name="lic_certificado" id="lic_certificado">
              <br>
            </div>
            <div class="col-md-4">
              <label>Validated *</label>
              <select name="lic_validado" id="lic_validado" class="form-control">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
              <br>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <label>Seminaries/Courses Certificates *</label>
              <textarea class="form-control estudios_obligado" name="otro_certificado" id="otro_certificado" rows="3"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Break(s) in Studies *</label>
              <textarea class="form-control estudios_obligado" name="carrera_inactivo" id="carrera_inactivo" rows="3"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Comments *</label>
              <textarea class="form-control estudios_obligado" name="estudios_comentarios" id="estudios_comentarios" rows="3"></textarea>
              <br><br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarEstudios()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="documentosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Documentos del candidato: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_documentos">
          <div class="alert alert-info">
            <p class="text-center">Comprobante de estudios (cedula, titulo o constancia) <br>
            <div id="doc_estudios"></div>
            </p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Número de documento</label>
              <input type="text" class="form-control" name="lic_profesional" id="lic_profesional">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control" name="lic_institucion" id="lic_institucion">
              <br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">INE <br>
            <div id="doc_ine"></div>
            </p>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>ID o clave</label>
              <input type="text" class="form-control" name="ine_clave" id="ine_clave" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" maxlength="18">
              <br>
            </div>
            <div class="col-md-4">
              <label>Año de registro</label>
              <input type="text" class="form-control solo_numeros" name="ine_registro" id="ine_registro" maxlength="4">
              <br>
            </div>
            <div class="col-md-4">
              <label>Número vertical</label>
              <input type="text" class="form-control solo_numeros" name="ine_vertical" id="ine_vertical" maxlength="13">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control" name="ine_institucion" id="ine_institucion">
              <br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Carta de no antecedentes penales (carta policía) <br>
            <div id="doc_penales"></div>
            </p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Número de documento</label>
              <input type="text" class="form-control" name="penales_numero" id="penales_numero">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control" name="penales_institucion" id="penales_institucion">
              <br><br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Comentarios * </p>
          </div>
          <div class="row">
            <div class="col-md-12">
              <textarea class="form-control" name="doc_comentarios" id="doc_comentarios" rows="2"></textarea>
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
<div class="modal fade" id="familiaresModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Información familiar del candidato: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_familiares">
          <div id="div_familiares"></div>
          <input type="hidden" id="numFamiliares">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
        <form id="d_refpersonal">
        <?php
        for ($i = 1; $i <= 3; $i++) { ?>
            <div class="alert alert-info">
              <p class="text-center">Referencia #<?php echo $i; ?> </p>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>Nombre *</label>
                <input type="text" class="form-control refper<?php echo $i; ?>_obligado" name="refper<?php echo $i; ?>_nombre" id="refper<?php echo $i; ?>_nombre">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>Tiempo de conocerlo *</label>
                <input type="text" class="form-control refper<?php echo $i; ?>_obligado" name="refper<?php echo $i; ?>_tiempo" id="refper<?php echo $i; ?>_tiempo">
                <br>
              </div>
              <div class="col-md-4">
                <label>Lugar donde lo conoció *</label>
                <input type="text" class="form-control refper<?php echo $i; ?>_obligado" name="refper<?php echo $i; ?>_lugar" id="refper<?php echo $i; ?>_lugar">
                <br>
              </div>
              <div class="col-md-4">
                <label>Teléfono *</label>
                <input type="text" class="form-control refper<?php echo $i; ?>_obligado" name="refper<?php echo $i; ?>_telefono" id="refper<?php echo $i; ?>_telefono" maxlength="12">
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>¿Sabe dónde trabaja? *</label>
                <select name="refper<?php echo $i; ?>_trabaja" id="refper<?php echo $i; ?>_trabaja" class="form-control refper<?php echo $i; ?>_obligado">
                  <option value="">Select</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
              <div class="col-md-4">
                <label>¿Sabe dónde vive? *</label>
                <select name="refper<?php echo $i; ?>_vive" id="refper<?php echo $i; ?>_vive" class="form-control refper<?php echo $i; ?>_obligado">
                  <option value="">Select</option>
                  <option value="0">No</option>
                  <option value="1">Sí</option>
                </select>
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label>Comentarios *</label>
                <textarea class="form-control refper<?php echo $i; ?>_obligado" name="refper<?php echo $i; ?>_comentario" id="refper<?php echo $i; ?>_comentario" rows="2"></textarea>
                <br>
              </div>
            </div>
            <br>
        <?php
        }
        ?>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="guardarRefPersonales()">Guardar</button>
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
              <select name="estudio_estatus" id="estudio_estatus" class="form-control">
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
<div class="modal fade" id="completarModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Finalizar proceso del candidato: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formChecks">
          <div class="row">
            <div class="col-md-4">
              <label>Identity Check *</label>
              <select name="check_identidad" id="check_identidad" class="form-control check_obligado">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Employment History Check *</label>
              <select name="check_laboral" id="check_laboral" class="form-control check_obligado">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Academic History Check *</label>
              <select name="check_estudios" id="check_estudios" class="form-control check_obligado">
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
              <label>Home Visit</label>
              <select name="check_visita" id="check_visita" class="form-control check_obligado" readonly>
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Criminal Records – Mexican *</label>
              <select name="check_penales" id="check_penales" class="form-control check_obligado">
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Criminal Records – OFAC *</label>
              <select name="check_ofac" id="check_ofac" class="form-control check_obligado">
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
              <label>Laboratory Test</label>
              <select name="check_laboratorio" id="check_laboratorio" class="form-control check_obligado" readonly>
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Medical Check Up</label>
              <select name="check_medico" id="check_medico" class="form-control check_obligado" readonly>
                <option value="">Selecciona</option>
                <option value="0">Negative</option>
                <option value="1">Positive</option>
                <option value="2">Under Revision (UR)</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>World Check</label>
              <select name="check_global" id="check_global" class="form-control check_obligado">
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
            <div class="col-md-12">
              <label>Final Statement *</label>
              <textarea class="form-control check_obligado" name="comentario_final" id="comentario_final" rows="3"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 offset-md-4">
              <label>Final BGC Status *</label>
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
        <button type="button" id="btnTerminar" class="btn btn-success" onclick="finalizarProceso()">Terminar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="ofacModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Verificación FACIS: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <p class="text-center" id="fecha_titulo_ofac"><b></b></p>
            <p class="text-center" id="fecha_estatus_ofac"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label>Estatus OFAC *</label>
            <textarea class="form-control ofac" name="estatus_ofac" id="estatus_ofac" rows="3"></textarea>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <label>Resultado *</label>
            <select name="res_ofac" id="res_ofac" class="form-control ofac">
              <option value="">Selecciona</option>
              <option value="1">Positivo</option>
              <option value="0">Negativo</option>
            </select>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label>Estatus OIG *</label>
            <textarea class="form-control ofac" name="estatus_oig" id="estatus_oig" rows="3"></textarea>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <label>Resultado *</label>
            <select name="res_oig" id="res_oig" class="form-control ofac">
              <option value="">Selecciona</option>
              <option value="1">Positivo</option>
              <option value="0">Negativo</option>
            </select>
            <br><br><br>
          </div>
        </div>
        <div class="alert alert-info">
          <p>* La consulta de SAM es opcional, registrarla solo en caso de que se haya solicitado </p>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label>Estatus SAM</label>
            <textarea class="form-control" name="estatus_sam" id="estatus_sam" rows="3"></textarea>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <label>Resultado</label>
            <select name="res_sam" id="res_sam" class="form-control">
              <option value="">Selecciona</option>
              <option value="1">Positivo</option>
              <option value="0">Negativo</option>
            </select>
            <br><br><br>
          </div>
        </div>
        <div class="alert alert-info">
          <p>* La consulta de Data Jurídica es opcional, registrarla solo en caso de que se haya solicitado </p>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label>Estatus Data Jurídica</label>
            <textarea class="form-control" name="estatus_juridica" id="estatus_juridica" rows="3"></textarea>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <label>Resultado</label>
            <select name="res_juridica" id="res_juridica" class="form-control">
              <option value="">Selecciona</option>
              <option value="1">Positivo</option>
              <option value="0">Negativo</option>
            </select>
            <br><br><br>
          </div>
        </div>
        <div class="alert alert-info">
          <p>* La consulta de New York OMIG Restricted or Terminated of Excluded list es opcional, registrarla solo en caso de que se haya solicitado </p>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label>Estatus New York OMIG Restricted or Terminated of Excluded list</label>
            <textarea class="form-control" name="estatus_new_york" id="estatus_new_york" rows="3"></textarea>
            <br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 offset-md-4">
            <label>Resultado</label>
            <select name="res_new_york" id="res_new_york" class="form-control">
              <option value="">Selecciona</option>
              <option value="1">Positivo</option>
              <option value="0">Negativo</option>
            </select>
            <br><br><br>
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="actualizarOfac()">Actualizar verificación</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="fechaModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cambio de fechas para: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info">
          <p>* Se actualizarán las fechas del reporte final a la fecha elegida </p>
        </div>
        <div class="row mb-5">
          <div class="col-4 offset-2">
            <strong>Última fecha de solicitud o alta: </strong><br><span id="ultima_alta_txt"></span>
          </div>
          <div class="col-4">
            <strong>Última fecha de finalización: </strong><br><span id="ultima_final_txt"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-4 offset-2">
            <label>Nueva fecha de solicitud o alta *</label>
            <input class="form-control fecha_facis" name="fecha_alta_facis" id="fecha_alta_facis" placeholder="dd/mm/yyyy">
            <br>
          </div>
          <div class="col-4">
            <label>Nueva fecha de finalización *</label>
            <input class="form-control fecha_facis" name="fecha_final_facis" id="fecha_final_facis" placeholder="dd/mm/yyyy">
            <br>
          </div>
        </div>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="actualizarFecha()">Actualizar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="completarFacisModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Finalizar proceso FACIS del candidato: <br> <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="ofacChecks">
          <!-- <div class="row">
            <div class="col-md-12">
              <label>Informe final *</label>
              <textarea class="form-control fin_ofac_obligado" name="ofac_comentario_final" id="ofac_comentario_final" rows="3"></textarea>
              <br>
            </div>
          </div> -->
          <div class="row">
            <div class="col-md-4 offset-md-4">
              <label>Estatus final *</label>
              <select name="ofac_estatus_final" id="ofac_estatus_final" class="form-control fin_ofac_obligado">
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
        <button type="button" id="btnOfac" class="btn btn-success" onclick="finalizarFACIS()">Terminar</button>
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
<script>
  $('#avancesModal').on('hidden.bs.modal', function(e) {
    $("#avancesModal #msj_error").css('display', 'none');
    $("#avancesModal input, #avancesModal textarea").val('');
  });
  $('#newModal').on('hidden.bs.modal', function(e) {
    $("#newModal #msj_error").css('display', 'none');
    $("#newModal input, #newModal select").val('');
  });
  $('#generalesModal').on('hidden.bs.modal', function(e) {
    $("#generalesModal #msj_error").css('display', 'none');
  });
  $('#formModal').on('hidden.bs.modal', function(e) {
    $("#rowForm").empty();
    $('#btnOpenFiles').remove()
    $('#formModal .modal-body').removeClass('escrolable');
  })
  $('#generales2Modal').on('hidden.bs.modal', function(e) {
    $("#generales2Modal #msj_error").css('display', 'none');
  });
  $('#academicosModal').on('hidden.bs.modal', function(e) {
    $("#academicosModal #msj_error").css('display', 'none');
  });
  $('#documentosModal').on('hidden.bs.modal', function(e) {
    $("#documentosModal #msj_error").css('display', 'none');
  });
  $('#familiaresModal').on('hidden.bs.modal', function(e) {
    $("#familiaresModal input[id^='msj_error']").css('display', 'none');
  });
  $('#refPersonalesModal').on('hidden.bs.modal', function(e) {
    $("#refPersonalesModal div[id^='msj_error']").css('display', 'none');
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
  $('#pruebasModal').on('hidden.bs.modal', function(e) {
    $("#pruebasModal #msj_error").css('display', 'none');
    $("#pruebasModal select").val('');
  });
  $('#contactoModal').on('hidden.bs.modal', function(e) {
    $("#contactoModal #msj_error").css('display', 'none');
    $("#contactoModal input").val('');
  });
</script>