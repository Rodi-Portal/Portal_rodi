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
            <div class="col-4">
              <label>Puesto *</label>
              <input type="text" class="form-control obligado" name="puesto" id="puesto"><br>
              <br>
            </div>
            <div class="col-4">
              <label>Teléfono *</label>
              <input type="text" class="form-control obligado" name="celular_registro" id="celular_registro" maxlength="16">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Correo electrónico *</label>
              <input type="email" class="form-control" name="correo_registro" id="correo_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
              <br>
            </div>
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
          </div>
          <!--div class="alert alert-warning text-center">Elige si se llevará a cabo un proceso registrado previamente o si es un proceso nuevo <br>Notas: <br>
            <ul class="text-left">
              <li>Si se elige un proceso previo, se omitirán las opciones elegidas de la sección de proceso nuevo (en caso de haber).</li>
              <li>Los exámenes complementarios son opcionales.</li>
              <li>Los candidatos previamente concluidos corresponden al proceso General plus o Simple.</li>
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
          <!--div class="alert alert-info text-center div_info_check">Crear un proceso nuevo</!--div>
          <div class="row div_check">
            <div class="col-12">
              <label>Nombre del proceso *</label>
              <input type="text" class="form-control" name="proyecto_registro" id="proyecto_registro">
              <br>
            </div>
          </div>
          <div class="row div_check">
            <div class="col-4">
              <label>Datos generales *</label>
              <select name="generales_registro" id="generales_registro" class="form-control">
                <option value="" selected>Selecciona</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label>Mayores estudios *</label>
              <select name="estudios_registro" id="estudios_registro" class="form-control">
                <option value="" selected>Selecciona</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label>Antecedentes sociales *</label>
              <select name="sociales_registro" id="sociales_registro" class="form-control">
                <option value="" selected>Selecciona</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row div_check">
            <div class="col-4">
              <label>Referencias personales *</label>
              <select name="ref_personales_registro" id="ref_personales_registro" class="form-control">
                <option value="" selected>Selecciona</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label>Referencias laborales *</label>
              <select name="empleos_registro" id="empleos_registro" class="form-control">
                <option value="" selected>Selecciona</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label>Investigación legal *</label>
              <select name="investigacion_registro" id="investigacion_registro" class="form-control">
                <option value="" selected>Selecciona</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row div_check">
            <div class="col-4">
              <label>Trabajos no mencionados *</label>
              <select name="no_mencionados_registro" id="no_mencionados_registro" class="form-control">
                <option value="" selected>Selecciona</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label>Verificación de identidad *</label>
              <select name="documentacion_registro" id="documentacion_registro" class="form-control">
                <option value="" selected>Selecciona</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label>Información del grupo familiar *</label>
              <select name="familiar_registro" id="familiar_registro" class="form-control">
                <option value="" selected>Selecciona</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row div_check">
            <div class="col-4">
              <label>Ingresos y egresos *</label>
              <select name="egresos_registro" id="egresos_registro" class="form-control">
                <option value="" selected>Selecciona</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label>Habitación y medio ambiente *</label>
              <select name="habitacion_registro" id="habitacion_registro" class="form-control">
                <option value="" selected>Selecciona</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label>Referencias vecinales *</label>
              <select name="ref_vecinales_registro" id="ref_vecinales_registro" class="form-control">
                <option value="" selected>Selecciona</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
              <br>
            </div>
          </div>
          <div-- class="row">
            <div class="col-4">
              <label>Antecedentes criminales *</label>
              <select name="criminal_registro" id="criminal_registro" class="form-control">
                <option value="" selected>Selecciona</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
              </select>
              <br>
            </div>
          </div-->
          <div class="alert alert-danger text-center">Exámenes complementarios</div>
          <div class="row">
            <div class="col-12">
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
            <!--div class="col-4">
              <label>Examen médico *</label>
              <select name="examen_medico" id="examen_medico" class="form-control registro_obligado">
                <option value="0">N/A</option>
                <option value="1">Aplicar</option>
              </select>
              <br>
            </!--div>
            <div-- class="col-4">
              <label>Psicometría *</label>
              <select name="examen_psicometrico" id="examen_psicometrico" class="form-control registro_obligado">
                <option value="0">N/A</option>
                <option value="1">Aplicar</option>
              </select>
              <br>
            </div-->
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
              <select name="asignar_candidato" id="asignar_candidato" class="form-control asignar_obligado">
                <option value="">Selecciona</option>
                <?php foreach ($cands as $cand) { ?>
                  <option value="<?php echo $cand->id; ?>"><?php echo $cand->candidato; ?></option>
                <?php } ?>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Usuario *</label>
              <select name="asignar_usuario" id="asignar_usuario" class="form-control asignar_obligado">
                <option value="">Selecciona</option>
                <?php foreach ($usuarios as $user) { ?>
                  <option value="<?php echo $user->id; ?>"><?php echo $user->usuario; ?></option>
                <?php } ?>
              </select>
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
        <h4 class="modal-title">Datos generales del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_generales">
          <div class="row">
            <div class="col-md-4">
              <label>Nombre(s) *</label>
              <input type="text" class="form-control es_general" name="nombre_general" id="nombre_general" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Apellido paterno *</label>
              <input type="text" class="form-control es_general" name="paterno_general" id="paterno_general" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-md-4">
              <label>Apellido materno</label>
              <input type="text" class="form-control es_general" name="materno_general" id="materno_general" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Fecha de nacimiento *</label>
              <input type="text" class="form-control solo_lectura es_general" name="fecha_nacimiento" id="fecha_nacimiento">
              <br>
            </div>
            <div class="col-md-4">
              <label>Nacionalidad *</label>
              <input type="text" class="form-control es_general" name="nacionalidad" id="nacionalidad">
              <br>
            </div>
            <div class="col-md-4">
              <label>Puesto *</label>
              <input type="text" class="form-control es_general" name="puesto_general" id="puesto_general">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Domicilio completo *</label>
              <input type="text" class="form-control es_general" name="domicilio_general" id="domicilio_general">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Género: *</label>
              <select name="genero" id="genero" class="form-control es_general">
                <option value="">Selecciona</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Calle *</label>
              <input type="text" class="form-control es_general" name="calle" id="calle">
              <br>
            </div>
            <div class="col-md-4">
              <label>No. Exterior *</label>
              <input type="text" class="form-control es_general" name="exterior" id="exterior" maxlength="8">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>No. Interior </label>
              <input type="text" class="form-control es_general" name="interior" id="interior" maxlength="8">
              <br>
            </div>
            <div class="col-md-4">
              <label>Entre calles</label>
              <input type="text" class="form-control es_general" name="calles" id="calles">
              <br>
            </div>
            <div class="col-md-4">
              <label>Colonia *</label>
              <input type="text" class="form-control es_general" name="colonia" id="colonia">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Estado *</label>
              <select name="estado" id="estado" class="form-control es_general">
                <option value="">Selecciona</option>
                <?php foreach ($estados as $e) { ?>
                  <option value="<?php echo $e->id; ?>"><?php echo $e->nombre; ?></option>
                <?php } ?>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Municipio (o Delegación) *</label>
              <select name="municipio" id="municipio" class="form-control es_general" disabled>
                <option value="">Selecciona</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Código postal *</label>
              <input type="text" class="form-control solo_numeros es_general" name="cp" id="cp" maxlength="5">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Estado civil *</label>
              <select name="civil" id="civil" class="form-control es_general">
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
              <input type="text" class="form-control solo_numeros es_general" name="celular_general" id="celular_general" maxlength="10">
              <br>
            </div>
            <div class="col-md-4">
              <label>Teléfono local </label>
              <input type="text" class="form-control solo_numeros es_general" name="tel_casa" id="tel_casa" maxlength="10">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Correo electrónico *</label>
              <input type="text" class="form-control es_general" name="correo_general" id="correo_general">
              <br>
            </div>
            <div class="col-4">
              <label>País donde reside *</label>
              <select class="form-control" id="pais_general" name="pais_general">
                <?php
                  foreach ($paises as $p) { ?>
                    <option value="<?php echo $p->nombre; ?>"><?php echo $p->nombre; ?></option>
                  <?php
                  } 
                ?>
              </select>
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
        <form id="formMayoresEstudios">
          <div class="alert alert-info">
            <p class="text-center">Candidato </p>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Nivel escolar *</label>
              <select name="mayor_estudios_candidato" id="mayor_estudios_candidato" class="form-control mayor_obligado">
                <option value="">Selecciona</option>
                <?php foreach ($studies as $g) { ?>
                  <option value="<?php echo $g->id; ?>"><?php echo $g->nombre; ?></option>
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
                <?php foreach ($studies as $g) { ?>
                  <option value="<?php echo $g->id; ?>"><?php echo $g->nombre; ?></option>
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
<div class="modal fade" id="identidadModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Verificación de identidad del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_identidad">
          <div class="alert alert-info">
            <p class="text-center">INE (IFE) </p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>ID</label>
              <input type="text" class="form-control" name="ine" id="ine">
              <br>
            </div>
            <div class="col-md-6">
              <label>Año de registro</label>
              <input type="text" class="form-control" name="ine_ano" id="ine_ano" maxlength="4">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Número vertical</label>
              <input type="text" class="form-control" name="ine_vertical" id="ine_vertical">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control" name="ine_institucion" id="ine_institucion">
              <br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Pasaporte </p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>ID</label>
              <input type="text" class="form-control" name="pasaporte" id="pasaporte">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control" name="pasaporte_fecha" id="pasaporte_fecha">
              <br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Carta de Antecedentes No Penales (Carta policía)</p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>ID</label>
              <input type="text" class="form-control" name="penales_id" id="penales_id">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control" name="penales_institucion" id="penales_institucion">
              <br>
            </div>
          </div>
          <div class="alert alert-info">
            <p class="text-center">Forma migratoria </p>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>ID</label>
              <input type="text" class="form-control" name="forma_migratoria" id="forma_migratoria">
              <br>
            </div>
            <div class="col-md-6">
              <label>Fecha / Institución</label>
              <input type="text" class="form-control" name="forma_migratoria_fecha" id="forma_migratoria_fecha">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Comentarios *</label>
              <input type="text" class="form-control identidad_obligado" name="identidad_comentarios" id="identidad_comentarios">
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarVerificacionIdentidad()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="globalesGeneralModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Búsquedas globales del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_globales_general">
          <div class="row">
            <div class="col-md-4">
              <label>Law enforcement *</label>
              <input type="text" class="form-control global_general_obligado" name="law_enforcement" id="law_enforcement">
              <br>
            </div>
            <div class="col-md-4">
              <label>Regulatory *</label>
              <input type="text" class="form-control global_general_obligado" name="regulatory" id="regulatory">
              <br>
            </div>
            <div class="col-md-4">
              <label>Sanctions *</label>
              <input type="text" class="form-control global_general_obligado" name="sanctions" id="sanctions">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Other bodies *</label>
              <input type="text" class="form-control global_general_obligado" name="other_bodies" id="other_bodies">
              <br>
            </div>
            <div class="col-md-4">
              <label>Web and media searches *</label>
              <input type="text" class="form-control global_general_obligado" name="media_searches" id="media_searches">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Comentarios *</label>
              <input type="text" class="form-control global_general_obligado" name="global_comentarios" id="global_comentarios">
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarGlobalesGeneral()">Guardar</button>
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
          <li>Verificación de identidad</li>
          <li>Búsquedas globales</li>
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
<div class="modal fade" id="finalizarModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Finalizar proceso del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formChecks">
          <div class="row">
            <div class="col-md-4">
              <label>Verif. Identidad *</label>
              <select name="check_identidad" id="check_identidad" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="1">Aprobado</option>
                <option value="0">No Aprobado</option>
                <option value="2">A consideración</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Verif. Global Data Searches *</label>
              <select name="check_global" id="check_global" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="1">Aprobado</option>
                <option value="0">No Aprobado</option>
                <option value="2">A consideración</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Verif. Criminal *</label>
              <select name="check_penales" id="check_penales" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="1">Aprobado</option>
                <option value="0">No Aprobado</option>
                <option value="2">A consideración</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Verif. Historial de empleos *</label>
              <select name="check_laboral" id="check_laboral" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="1">Aprobado</option>
                <option value="0">No Aprobado</option>
                <option value="2">A consideración</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Verif. Estudios *</label>
              <select name="check_estudios" id="check_estudios" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="1">Aprobado</option>
                <option value="0">No Aprobado</option>
                <option value="2">A consideración</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
            <div class="col-md-4">
              <label>Verif. OFAC *</label>
              <select name="check_ofac" id="check_ofac" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="1">Aprobado</option>
                <option value="0">No Aprobado</option>
                <option value="2">A consideración</option>
                <option value="3">NA</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label>Buró de crédito *</label>
              <select name="check_credito" id="check_credito" class="form-control estatus_finales">
                <option value="">Selecciona</option>
                <option value="1">Aprobado</option>
                <option value="0">No Aprobado</option>
                <option value="2">A consideración</option>
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
              <label>Estatus final del Estudio *</label>
              <select name="bgc_status" id="bgc_status" class="form-control check_obligado">
                <option value="">Selecciona</option>
                <option value="1">Recomendable</option>
                <option value="2">No recomendable</option>
                <option value="3">A consideración</option>
              </select>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="finalizarProceso()">Terminar</button>
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
<!-- Secciones extra -->
<div class="modal fade" id="socialesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Antecedentes sociales del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_sociales">
          <div class="row">
            <div class="col-md-6">
              <label>¿Perteneció algún puesto sindical? *</label>
              <select name="sindical" id="sindical" class="form-control social_obligado">
                <option value="">Selecciona</option>
                <option value="0">No</option>
                <option value="1">Sí</option>
              </select>
              <br>
            </div>
            <div class="col-md-6">
              <label>¿A cuál? *</label>
              <input type="text" class="form-control social_obligado" name="sindical_nombre" id="sindical_nombre">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>¿Cargo? *</label>
              <input type="text" class="form-control social_obligado" name="sindical_cargo" id="sindical_cargo">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>¿Pertenece algún partido político? *</label>
              <select name="partido" id="partido" class="form-control social_obligado">
                <option value="">Selecciona</option>
                <option value="0">No</option>
                <option value="1">Sí</option>
              </select>
              <br>
            </div>
            <div class="col-md-6">
              <label>¿A cuál? *</label>
              <input type="text" class="form-control social_obligado" name="partido_nombre" id="partido_nombre">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>¿Cargo? *</label>
              <input type="text" class="form-control social_obligado" name="partido_cargo" id="partido_cargo">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>¿Pertenece algún club deportivo? *</label>
              <select name="club" id="club" class="form-control social_obligado">
                <option value="">Selecciona</option>
                <option value="0">No</option>
                <option value="1">Sí</option>
              </select>
              <br>
            </div>
            <div class="col-md-6">
              <label>¿Qué deporte practica? *</label>
              <input type="text" class="form-control social_obligado" name="deporte" id="deporte">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>¿Qué religión profesa? *</label>
              <input type="text" class="form-control social_obligado" name="religion" id="religion">
              <br>
            </div>
            <div class="col-md-6">
              <label>¿Con qué frecuencia? *</label>
              <input type="text" class="form-control social_obligado" name="religion_frecuencia" id="religion_frecuencia">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>¿Ingiere bebidas alcohólicas? *</label>
              <select name="bebidas" id="bebidas" class="form-control social_obligado">
                <option value="">Selecciona</option>
                <option value="0">No</option>
                <option value="1">Sí</option>
              </select>
              <br>
            </div>
            <div class="col-md-6">
              <label>¿Con qué frecuencia? *</label>
              <input type="text" class="form-control social_obligado" name="bebidas_frecuencia" id="bebidas_frecuencia">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>¿Acostumbra fumar? *</label>
              <select name="fumar" id="fumar" class="form-control social_obligado">
                <option value="">Selecciona</option>
                <option value="0">No</option>
                <option value="1">Sí</option>
              </select>
              <br>
            </div>
            <div class="col-md-6">
              <label>¿Con qué frecuencia? *</label>
              <input type="text" class="form-control social_obligado" name="fumar_frecuencia" id="fumar_frecuencia">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>¿Ha tenido alguna intervención quirúrgica? *</label>
              <input type="text" class="form-control social_obligado" name="cirugia" id="cirugia">
              <br>
            </div>
            <div class="col-md-6">
              <label>¿Antecedentes de enfermedades en su familia? *</label>
              <input type="text" class="form-control social_obligado" name="enfermedades" id="enfermedades">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>¿Cuáles son sus planes a corto plazo? *</label>
              <input type="text" class="form-control social_obligado" name="corto_plazo" id="corto_plazo">
              <br>
            </div>
            <div class="col-md-6">
              <label>¿Cuáles son sus planes a mediano plazo? *</label>
              <input type="text" class="form-control social_obligado" name="mediano_plazo" id="mediano_plazo">
              <br><br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarSociales()">Guardar</button>
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
              <label>Teléfono *</label>
              <input type="text" class="form-control refper<?php echo $i; ?>_obligado" name="refper<?php echo $i; ?>_telefono" id="refper<?php echo $i; ?>_telefono" maxlength="12">
              <br>
            </div>
            <div class="col-md-4">
              <label>¿Lo recomienda? *</label>
              <select name="refper<?php echo $i; ?>_recomienda" id="refper<?php echo $i; ?>_recomienda" class="form-control refper<?php echo $i; ?>_obligado">
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
<div class="modal fade" id="noMencionadosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Trabajos no mencionados del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_no_mencionados">
          <div class="row">
            <div class="col-md-6">
              <label>Trabajos no mencionados *</label>
              <textarea cols="2" class="form-control nomen_obligado" name="no_mencionados" id="no_mencionados"></textarea>
              <br>
            </div>
            <div class="col-md-6">
              <label>Resultado *</label>
              <textarea cols="2" class="form-control nomen_obligado" name="resultado_no_mencionados" id="resultado_no_mencionados"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Notas *</label>
              <textarea cols="2" class="form-control nomen_obligado" name="notas_no_mencionados" id="notas_no_mencionados"></textarea>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="actualizarNoMencionados()">Guardar</button>
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
        <form id="d_familia">
          <div id="div_familiares">

          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="egresosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Egresos mensuales del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_egresos">
          <div class="row">
            <div class="col-md-4">
              <label for="renta">Renta *</label>
              <input type="text" class="form-control solo_numeros e_obligado" name="renta" id="renta" maxlength="8">
              <br>
            </div>
            <div class="col-md-4">
              <label for="alimentos">Alimentos *</label>
              <input type="text" class="form-control solo_numeros e_obligado" name="alimentos" id="alimentos" maxlength="8">
              <br>
            </div>
            <div class="col-md-4">
              <label for="servicios">Servicios *</label>
              <input type="text" class="form-control solo_numeros e_obligado" name="servicios" id="servicios" maxlength="8">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="transportes">Transportes *</label>
              <input type="text" class="form-control solo_numeros e_obligado" name="transportes" id="transportes" maxlength="8">
              <br>
            </div>
            <div class="col-md-4">
              <label for="otros_gastos">Otros *</label>
              <input type="text" class="form-control solo_numeros e_obligado" name="otros_gastos" id="otros_gastos" maxlength="8">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="solvencia">Cuando los egresos son mayores a los ingresos, ¿cómo los solventa? *</label>
              <textarea class="form-control e_obligado" name="solvencia" id="solvencia" rows="2"></textarea>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="actualizarEgresos()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="visitaHabitacionModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Habitacion y medio ambiente del candidato: <br><span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="d_habitacion">
          <div class="row">
            <div class="col-md-6">
              <label>Tiempo de residencia en el domicilio actual *</label>
              <input type="text" class="form-control h_obligado" name="tiempo_residencia" id="tiempo_residencia">
              <br>
            </div>
            <div class="col-md-6">
              <label>Nivel de la zona *</label>
              <select name="nivel_zona" id="nivel_zona" class="form-control h_obligado">
                <option value="">Selecciona</option>
                <?php foreach ($zonas as $z) { ?>
                  <option value="<?php echo $z->id; ?>"><?php echo $z->nombre; ?></option>
                <?php } ?>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Tipo de vivienda *</label>
              <select name="tipo_vivienda" id="tipo_vivienda" class="form-control h_obligado">
                <option value="">Selecciona</option>
                <?php foreach ($viviendas as $viv) { ?>
                  <option value="<?php echo $viv->id; ?>"><?php echo $viv->nombre; ?></option>
                <?php } ?>
              </select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Recámaras *</label>
              <input type="number" class="form-control h_obligado" name="recamaras" id="recamaras">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Baños *</label>
              <input type="text" class="form-control h_obligado" name="banios" id="banios">
              <br>
            </div>
            <div class="col-md-6">
              <label>Distribución *</label>
              <textarea class="form-control h_obligado" name="distribucion" id="distribucion" rows="2"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Calidad mobiliario *</label>
              <select name="calidad_mobiliario" id="calidad_mobiliario" class="form-control h_obligado">
                <option value="">Selecciona</option>
                <option value="1">Buena</option>
                <option value="2">Regular</option>
                <option value="3">Deficiente</option>
              </select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Mobiliario *</label>
              <select name="mobiliario" id="mobiliario" class="form-control h_obligado">
                <option value="">Selecciona</option>
                <option value="0">Incompleto</option>
                <option value="1">Completo</option>
              </select>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label>Tamaño vivienda *</label>
              <select name="tamanio_vivienda" id="tamanio_vivienda" class="form-control h_obligado">
                <option value="">Selecciona</option>
                <option value="1">Amplia</option>
                <option value="2">Media</option>
                <option value="3">Reducida</option>
              </select>
              <br>
            </div>
            <div class="col-md-6">
              <label>Condiciones de la vivienda *</label>
              <select name="condiciones_vivienda" id="condiciones_vivienda" class="form-control h_obligado">
                <option value="">Selecciona</option>
                <?php foreach ($condiciones as $cond) { ?>
                  <option value="<?php echo $cond->id; ?>"><?php echo $cond->nombre; ?></option>
                <?php } ?>
              </select>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="actualizarHabitacion()">Guardar</button>
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
<script>
  $(document).ready(function() {
    $("#newModal").on("hidden.bs.modal", function() {
			$("#newModal input, #newModal select, #newModal textarea").val('');
			$("#newModal #msj_error").css('display', 'none');
			$("#examen_medico,#examen_psicometrico,#examen_registro").val(0);
      $('#detalles_previo').empty();
      $('#pais').val('México');
		})
    $("#asignarCandidatoModal").on("hidden.bs.modal", function() {
			$("#asignarCandidatoModal select").val('');
			$("#asignarCandidatoModal #msj_error").css('display', 'none');
		})
    $('#avancesModal').on('hidden.bs.modal', function(e) {
      $("#avancesModal #msj_error").css('display', 'none');
      $("#avancesModal input, #avancesModal textarea").val('');
    });
    $('#generalesModal').on('hidden.bs.modal', function(e) {
      $("#generalesModal #msj_error").css('display', 'none');
      $("#generalesModal input, #generalesModal textarea, #generalesModal select").val('');
    });
    $('#mayoresEstudiosModal').on('hidden.bs.modal', function(e) {
      $("#mayoresEstudiosModal #msj_error").css('display', 'none');
      $("#mayoresEstudiosModal input, #mayoresEstudiosModal textarea").val('');
    });
    $('#identidadModal').on('hidden.bs.modal', function(e) {
      $("#identidadModal #msj_error").css('display', 'none');
      $("#identidadModal input").val('');
    });
    $('#globalesGeneralModal').on('hidden.bs.modal', function(e) {
      $("#globalesGeneralModal #msj_error").css('display', 'none');
      $("#globalesGeneralModal input").val('');
    });
    $('#verificacionPenalesModal').on('hidden.bs.modal', function(e) {
      $("#verificacionPenalesModal #msj_error").css('display', 'none');
      $("#verificacionPenalesModal textarea").val('');
    });
    $('#docsModal').on('hidden.bs.modal', function(e) {
      $("#docsModal #msj_error").css('display', 'none');
      $("#docsModal input, #docsModal select").val('');
    });
    $('#visitaDocumentosModal').on('hidden.bs.modal', function(e) {
      $("#visitaDocumentosModal #msj_error").css('display', 'none');
      $("#visitaDocumentosModal input").val('');
    });
    $('#psicometriaModal').on('hidden.bs.modal', function(e) {
      $("#psicometriaModal #msj_error").css('display', 'none');
      $("#psicometriaModal input").val('');
    });
    $('#finalizarModal').on('hidden.bs.modal', function(e) {
      $("#finalizarModal #msj_error").css('display', 'none');
      $("#finalizarModal input, #finalizarModal textarea, #finalizarModal select").val('');
    });
    $('#pruebasModal').on('hidden.bs.modal', function(e) {
      $("#pruebasModal #msj_error").css('display', 'none');
      $("#pruebasModal select").val('');
    });
    $('#socialesModal').on('hidden.bs.modal', function(e) {
      $("#socialesModal #msj_error").css('display', 'none');
      $("#socialesModal input, #socialesModal select").val('');
    });
    $('#refPersonalesModal').on('hidden.bs.modal', function(e) {
      $("#refPersonalesModal div[id^='msj_error']").css('display', 'none');
    });
    $('#noMencionadosModal').on('hidden.bs.modal', function(e) {
      $("#noMencionadosModal #msj_error").css('display', 'none');
      $("#noMencionadosModal textarea").val('');
    });
    $('#legalesModal').on('hidden.bs.modal', function(e) {
      $("#legalesModal #msj_error").css('display', 'none');
      $("#legalesModal input, #legalesModal textarea").val('');
    });
    $('#egresosModal').on('hidden.bs.modal', function(e) {
      $("#egresosModal #msj_error").css('display', 'none');
      $("#egresosModal input, #egresosModal textarea").val('');
    });
    $('#visitaHabitacionModal').on('hidden.bs.modal', function(e) {
      $("#visitaHabitacionModal #msj_error").css('display', 'none');
      $("#visitaHabitacionModal input, #visitaHabitacionModal textarea, #visitaHabitacionModal select").val('');
    });
    $('#quitarModal').on('hidden.bs.modal', function(e) {
      $("#quitarModal #titulo_accion, #quitarModal #texto_confirmacion").text('');
      $("#quitarModal #campos_mensaje").empty();
      $("#quitarModal #btnGuardar").removeAttr('onclick');
    });
    $('#creditoModal').on('hidden.bs.modal', function(e) {
      $("#creditoModal #msj_error").css('display', 'none');
      $("#creditoModal input, #creditoModal textarea").val('');
    });
  })
</script>