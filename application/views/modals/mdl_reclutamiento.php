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
          <div class="row mb-3">
            <div class="col-12">
              <label>Asignar requisición *</label>
              <select name="req_asignada" id="req_asignada" class="form-control obligado" data-live-search="true" data-style="btn-custom-selectpicker" title="Selecciona"></select>
              <br>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-12 col-md-4">
              <label>Nombre(s) *</label>
              <input type="text" class="form-control obligado" name="nombre" id="nombre" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
            <div class="col-sm-12 col-md-4">
              <label>Primer apellido *</label>
              <input type="text" class="form-control obligado" name="paterno" id="paterno" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
            <div class="col-sm-12 col-md-4">
              <label>Segundo apellido</label>
              <input type="text" class="form-control" name="materno" id="materno" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
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
                foreach ($medios as $m) { ?>
                  <option value="<?php echo $m->nombre; ?>"><?php echo $m->nombre; ?></option>
                <?php  
                } ?>
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
                <?php
                foreach ($acciones as $a) { ?>
                  <option value="<?php echo $a->id.':'.$a->descripcion; ?>"><?php echo $a->descripcion; ?></option>
                <?php   
                } ?>
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
              <select name="req_estatus" id="req_estatus" class="form-control obligado">
                <option value="">Selecciona</option>
                <?php
                if ($reqs) {
                  foreach ($reqs as $req) { ?>
                    <option value="<?php echo $req->id; ?>"><?php echo '#'.$req->id.' '.$req->nombre.' - '.$req->puesto.' - Vacantes: '.$req->numero_vacantes; ?></option>
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
                  <option value="<?php echo $req->id; ?>"><?php echo '#'.$req->id.' '.$req->nombre.' - '.$req->puesto.' - Vacantes: '.$req->numero_vacantes; ?></option>
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
        <h4 class="modal-title">Registrar candidato</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning text-center"><h5>El aspirante será registrado como candidato para RODI RECLUTAMIENTO</h5></div>
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
            <div class="col-4">
              <label>CURP</label>
              <input type="text" class="form-control obligado" name="curp_registro" id="curp_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" maxlength="18">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <label>Numero de Seguro Social (NSS)</label>
              <input type="text" class="form-control obligado" name="nss_registro" id="nss_registro" maxlength="11">
              <br>
            </div>
          </div>
          <div class="alert alert-info text-center">Selecciona un proceso</div>
          <div class="row">
            <div class="col-12">
              <label>Proceso</label>
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
        <button type="button" class="btn btn-success" onclick="registrarCandidato()">Registrar</button>
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
        <div id="div_historial_comentario" class="escrolable"></div><hr>
        <div class="row">
          <div class="col-12">
            <label for="comentario_bolsa">Registra un nuevo comentario o estatus *</label>
            <textarea class="form-control" name="comentario_bolsa" id="comentario_bolsa" rows="3"></textarea>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-12">
            <button type="button" class="btn btn-primary text-lg btn-block" id="btnComentario">Guardar comentario</button>
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
        <div class="alert alert-info">Este formulario es para el registro de requisiciones express o que fueron solicitadas de manera rápida. Se registrarán los datos más elementales y podrá ser completada en otro momento.</div>
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
            <div class="col-6">
              <label for="nombre_comercial_req">Nombre comercial *</label>
              <input type="text" class="form-control" data-required="required" data-field="Nombre comercial" name="nombre_comercial_req" id="nombre_comercial_req" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
            <div class="col-6">
              <label for="nombre_req">Razón social </label>
              <input type="text" class="form-control" data-required="required" data-field="Razón social" name="nombre_req" id="nombre_req" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12">
              <label for="domicilio_req">Domicilio fiscal</label>
              <input type="text" class="form-control" data-field="Domicilio fiscal" name="domicilio_req" id="domicilio_req">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-3">
              <label for="cp_req">Código postal </label>
              <input type="number" class="form-control" data-field="Código postal" name="cp_req" id="cp_req" maxlength="5">
            </div>
            <div class="col-3">
              <label for="telefono_req">Teléfono</label>
              <input type="text" class="form-control" data-field="Teléfono" name="telefono_req" id="telefono_req" maxlength="16">
            </div>
            <div class="col-3">
              <label for="contacto_req">Contacto</label>
              <input type="text" class="form-control" data-field="Contacto" name="contacto_req" id="contacto_req">
            </div>
            <div class="col-3">
              <label for="rfc_req">RFC </label>
              <input type="text" class="form-control" data-field="RFC" name="rfc_req" id="rfc_req" maxlength="13" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-3">
              <label for="correo_req">Correo </label>
              <input type="text" class="form-control" data-field="Correo" name="correo_req" id="correo_req">
            </div>
          </div>
        </form>
        <form id="formPaso2" class="hidden">
          <div class="row mb-3">
            <div class="col-6">
              <label for="puesto_req">Nombre de la posición *</label>
              <input type="text" class="form-control" data-required="required" data-field="Nombre de la posición" name="puesto_req" id="puesto_req">
            </div>
            <div class="col-6">
              <label for="numero_vacantes_req">Número de vacantes *</label>
              <input type="number" class="form-control" data-required="required" data-field="Número de vacantes" name="numero_vacantes_req" id="numero_vacantes_req">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12">
              <label for="residencia_req">Lugar de residencia </label>
              <textarea class="form-control" data-field="Lugar de residencia" name="residencia_req" id="residencia_req" rows="2"></textarea>
            </div>
          </div>
        </form>
        <form id="formPaso3" class="hidden">
          <div class="row mb-3">
            <div class="col-12">
              <label for="zona_req">Domicilio de trabajo *</label>
              <textarea class="form-control" data-required="required" data-field="Zona de trabajo" name="zona_req" id="zona_req" rows="2"></textarea>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-3">
              <label for="tipo_sueldo_req">Tipo de sueldo *</label>
              <select class="form-control" data-required="required" data-field="Tipo de sueldo" id="tipo_sueldo_req" name="tipo_sueldo_req">
						    <option value="" selected>Selecciona</option>
						    <option value="Fijo">Fijo</option>
						    <option value="Variable">Variable</option>
						    <option value="Neto">Neto (libre)</option>
						    <option value="Nominal">Nominal</option>
						  </select>
            </div>
            <div class="col-3">
              <label for="sueldo_minimo_req">Sueldo mínimo </label>
						  <input type="number" class="form-control" data-field="Sueldo mínimo" id="sueldo_minimo_req" name="sueldo_minimo_req">
            </div>
            <div class="col-3">
              <label for="sueldo_maximo_req">Sueldo máximo </label>
						  <input type="number" class="form-control" data-field="Sueldo máximo" id="sueldo_maximo_req" name="sueldo_maximo_req">
            </div>
            <div class="col-3">
              <label for="tipo_pago_req">Tipo de pago *</label>
              <select class="form-control" data-required="required" data-field="Tipo de pago" id="tipo_pago_req" name="tipo_pago_req">
						    <option value="" selected>Selecciona</option>
						    <option value="Mensual">Mensual</option>
						    <option value="Quincenal">Quincenal</option>
						    <option value="Semanal">Semanal</option>
						  </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-3">
              <label for="ley_req">¿Tendrá prestaciones de ley? *</label>
              <select class="form-control" data-required="required" data-field="¿Tendrá prestaciones de ley?" id="ley_req" name="ley_req">
						    <option value="" selected>Selecciona</option>
						    <option value="SI">SI</option>
						    <option value="NO">NO</option>
						  </select>
            </div>
            <div class="col-9">
              <label for="experiencia_req">Se requiere experiencia en</label>
              <textarea class="form-control" data-field="Se requiere experiencia en" name="experiencia_req" id="experiencia_req" rows="2"></textarea>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12">
              <label for="observaciones_req">Observaciones</label>
              <textarea class="form-control" data-field="Observaciones" name="observaciones_req" id="observaciones_req" rows="2"></textarea>
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
              <select id="asignar_usuario" class="form-control selectpicker dropup" data-dropup-auto="false" data-live-search="true" data-style="btn-custom-selectpicker" title="Selecciona" data-selected-text-format="count > 4" multiple>
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
              <select name="asignar_registro" id="asignar_registro" class="form-control selectpicker" data-live-search="true" data-style="btn-custom-selectpicker" title="Selecciona" data-size="10">
                <?php 
                if(!empty($registros_asignacion)){
                  foreach($registros_asignacion as $fila){ ?>
                    <option value="<?php echo $fila->id ?>"><?php echo '#'.$fila->id.' '.$fila->nombreCompleto ?></option>
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
        <h4 class="modal-title">Resultados de los estudios y exámenes de los candidatos de la Requisición: <br><span class="nombreRegistro"></span></h4>
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
              <input type="file" class="form-control" name="archivo_csv" id="archivo_csv" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
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
        <h4 class="modal-title">Información de ingreso al empleo del candidato: <br><span class="nombreRegistro"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info text-center">Registros del estatus de la garantía</div>
        <div id="divHistorialGarantia" class="escrolable"></div><hr>
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
              <button type="button" class="btn btn-primary text-lg btn-block" onclick="updateAdmission()">Guardar información</button>
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
  var pag = 1;
  $('#nuevaRequisicionModal').on('shown.bs.modal', function(e) {
    $("#nuevaRequisicionModal #titulo_paso").text('Información Básica');
    $("#nuevaRequisicionModal #btnContinuar span.text").text('Continuar');
    $("#nuevaRequisicionModal #btnRegresar, #nuevaRequisicionModal #paso2, #nuevaRequisicionModal #paso3").prop('disabled', true);
  });
  $('#nuevaRequisicionModal #btnContinuar').on('click', function() {
    var formulario_actual = document.getElementById('formPaso'+pag);
    var todoCorrecto = true;
    var formulario = formulario_actual;
    for (var i = 0; i < formulario.length; i++) {
      if(formulario[i].type == 'text' || formulario[i].type == 'number' || formulario[i].type == 'textarea' || formulario[i].type == 'select-one') {
        if(formulario[i].getAttribute("data-required") == 'required'){
          if(formulario[i].value == null || formulario[i].value == '' || formulario[i].value == 0 || formulario[i].value.length == 0 || /^\s*$/.test(formulario[i].value)){
            Swal.fire({
              icon: 'error',
              title: 'Hubo un problema',
              html: 'El campo <b>'+formulario[i].getAttribute("data-field")+'</b> no es válido',
              width: '50em',
              confirmButtonText: 'Cerrar'
            })
            todoCorrecto = false;
          }
        }
      }
    }
    if (todoCorrecto == true) {
      if(pag == 1){
        document.getElementById('formPaso1').className = "animate__animated animate__fadeOut ";
        setTimeout(function(){
          document.getElementById('formPaso1').className = "hidden";
          document.getElementById('formPaso2').className = "animate__animated animate__fadeInUp";
        },500)
        $("#nuevaRequisicionModal #titulo_paso").text('Información de la Vacante');
        $("#nuevaRequisicionModal #btnRegresar, #nuevaRequisicionModal #paso2").prop('disabled', false);
        document.getElementById('barra1').classList.remove('barra_espaciadora_off');
        document.getElementById('barra1').className += ' barra_espaciadora_on';
      }
      if(pag == 2){
        document.getElementById('formPaso2').className = "animate__animated animate__fadeOut ";
        setTimeout(function(){
          document.getElementById('formPaso2').className = "hidden";
          document.getElementById('formPaso3').className = "animate__animated animate__fadeInUp";
        },500)
        $("#nuevaRequisicionModal #titulo_paso").text('Información sobre el Cargo');
        $("#nuevaRequisicionModal #paso3").prop('disabled', false);
        document.getElementById('barra2').classList.remove('barra_espaciadora_off');
        document.getElementById('barra2').className += ' barra_espaciadora_on';
        $("#nuevaRequisicionModal #btnContinuar span.text").text('Finalizar');
      }
      if(pag == 3){
        let datos = $('#formPaso1').serialize();
        datos += '&' + $("#formPaso2").serialize();
        datos += '&' + $("#formPaso3").serialize();
        let currentPage =  $('#currentPage').val();
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
              if(currentPage == 'requisicion'){
                setTimeout(function(){
                  location.reload()
                },3000)
              }
            }
            else{
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
      if(pag == 1 || pag == 2)
        pag++;
    }
  });
  $('#nuevaRequisicionModal #btnRegresar').on('click', function() {
    if(pag == 2){
      document.getElementById('formPaso2').className = "animate__animated animate__fadeOut ";
      setTimeout(function(){
        document.getElementById('formPaso2').className = "hidden";
        document.getElementById('formPaso1').className = "animate__animated animate__fadeInUp";
      },500)
      $("#nuevaRequisicionModal #titulo_paso").text('Información Básica');
      $("#nuevaRequisicionModal #btnRegresar, #nuevaRequisicionModal #paso2").prop('disabled', true);
      document.getElementById('barra1').classList.remove('barra_espaciadora_on');
      document.getElementById('barra1').className += ' barra_espaciadora_off';
      $("#nuevaRequisicionModal #btnContinuar span.text").text('Continuar');
      pag--;
    }
    if(pag == 3){
      document.getElementById('formPaso3').className = "animate__animated animate__fadeOut ";
      setTimeout(function(){
        document.getElementById('formPaso3').className = "hidden";
        document.getElementById('formPaso2').className = "animate__animated animate__fadeInUp";
      },500)
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
    foreach ($paquetes_antidoping as $paq) { ?>
      $("#examen_registro").append('<option value="<?php echo $paq->id; ?>"><?php echo $paq->nombre.' ('.$paq->conjunto.')'; ?></option>');
    <?php
    } ?>
    $("#registroCandidatoModal input, #registroCandidatoModal select, #registroCandidatoModal textarea").val('');
    $("#examen_registro,#examen_medico,#examen_psicometrico").val(0);
    $('#pais').val('México')
    $('#subcliente').val(0)
    $('#detalles_previo').empty();
    $("#registroCandidatoModal .selectpicker").val('').selectpicker('refresh');

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
  
</script>