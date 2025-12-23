<?php
    header('Content-Type: text/html; charset=utf-8');
    $idRol        = $this->session->userdata('idrol');
    $logo         = $this->session->userdata('logo');
    $aviso_actual = $this->session->userdata('aviso');
    $archivo      = $aviso_actual ? $aviso_actual : 'AV_TL_V1.pdf';
?>



<div class="modal fade" id="nuevoAspiranteModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title"><?php echo t('rec_prog_app_modal_title', 'Datos del aspirante'); ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo t('rec_common_close', 'Cerrar'); ?>">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="formAspirante">
          <div class="col-sm-12">

            <label for="buscador"><?php echo t('rec_prog_app_f_req_select', 'Selecciona una Requisición :'); ?></label>
            <select name="req_asignada" id="req_asignada">

              <?php
                if ($reqs) {
                  foreach ($reqs as $req) { ?>
                    <option value="<?php echo $req->idReq; ?>">
                      <?php echo '# ' . $req->idReq . ' ' . $req->nombre_cliente . ' - ' . $req->puesto . ' - ' . t('rec_prog_app_req_openings', 'Vacantes:') . ' ' . $req->numero_vacantes; ?>
                    </option>
              <?php }
                } else { ?>
                  <option value=""><?php echo t('rec_prog_app_no_reqs', 'Sin requisiones registradas'); ?></option>
              <?php } ?>
            </select>

          </div>

          <br>

          <div class="row mb-3">
            <div class="col-sm-12 col-md-4">
              <label><?php echo t('rec_prog_app_f_first_names', 'Nombre(s) *'); ?></label>
              <input type="text" class="form-control obligado" name="nombre" id="nombre"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>

            <div class="col-sm-12 col-md-4">
              <label><?php echo t('rec_prog_app_f_lastname_1', 'Primer apellido *'); ?></label>
              <input type="text" class="form-control obligado" name="paterno" id="paterno"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>

            <div class="col-sm-12 col-md-4">
              <label><?php echo t('rec_prog_app_f_lastname_2', 'Segundo apellido'); ?></label>
              <input type="text" class="form-control" name="materno" id="materno"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12">
              <label><?php echo t('rec_prog_app_f_address', 'Localización o domicilio *'); ?></label>
              <textarea class="form-control" name="domicilio" id="domicilio" rows="2"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-12 col-md-4">
              <label><?php echo t('rec_prog_app_f_interest_area', 'Área de interés *'); ?></label>
              <input type="text" id="area_interes" name="area_interes" class="form-control">
            </div>

            <div class="col-sm-12 col-md-4">
              <label><?php echo t('rec_prog_app_f_contact_method', 'Medio de contacto *'); ?></label>
              <select name="medio" id="medio" class="form-control obligado w-100">
                <option value=""><?php echo t('rec_common_select', 'Selecciona'); ?></option>

                <?php if ($medios != null): ?>
                  <?php foreach ($medios as $m): ?>
                    <option value="<?php echo $m->nombre; ?>"><?php echo $m->nombre; ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>

                <option value="0"><?php echo t('rec_common_na', 'N/A'); ?></option>
              </select>
            </div>

            <div class="col-sm-12 col-md-4">
              <label><?php echo t('rec_prog_app_f_phone', 'Teléfono *'); ?></label>
              <input type="text" id="telefono1" name="telefono1" class="form-control">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-12 col-md-4">
              <label><?php echo t('rec_prog_app_f_email', 'Correo*'); ?></label>
              <input type="mail" id="correo1" name="correo1" class="form-control">

              <input type="hidden" id="idAspirante" name="idAspirante">
              <input type="hidden" id="idBolsa" name="idBolsa">
            </div>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?php echo t('rec_common_cancel', 'Cancelar'); ?>
        </button>
        <button type="button" class="btn btn-success" onclick="addApplicant()">
          <?php echo t('rec_common_save', 'Guardar'); ?>
        </button>
      </div>

    </div>
  </div>
</div>




<div class="modal fade" id="nuevaAccionModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title-modal-key-title-blanco">
          <?php echo t('rec_prog_action_modal_title', 'Registro de acción al aspirante:'); ?>
          <span class="nombreAspirante"></span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo t('rec_common_close', 'Cerrar'); ?>">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="alert alert-success text-start" role="alert" style="text-align: left;">
          ✅ <strong><?php echo t('rec_common_note_label', 'NOTA:'); ?></strong>
          <?php echo t('rec_prog_action_note_success', 'En esta sección podrás registrar las acciones que se van tomando en el proceso de reclutamiento en base a este Aspirante.'); ?>
        </div>

        <form id="formAccion">
          <div class="row">
            <div class="col-12">
              <label><?php echo t('rec_prog_action_field_action', 'Acción a aplicar *'); ?></label>
              <select name="accion_aspirante" id="accion_aspirante" class="form-control obligado">
                <option value=""><?php echo t('rec_common_select', 'Selecciona'); ?></option>
                <option value="otro"><?php echo t('rec_common_other', 'Otro'); ?></option>
                <?php if ($acciones != null) { foreach ($acciones as $a) { ?>
                  <option value="<?php echo $a->id . ':' . $a->descripcion; ?>"><?php echo $a->descripcion; ?></option>
                <?php } } ?>
              </select>
              <br>

              <!-- Input oculto para la acción personalizada -->
              <input type="text"
                     name="otra_accion"
                     id="otra_accion"
                     class="form-control mt-2"
                     placeholder="<?php echo t('rec_prog_action_placeholder_other_action', 'Escribe la acción'); ?>"
                     style="display: none;">
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <label><?php echo t('rec_prog_action_field_comment', 'Comentario / Descripción / Fecha y lugar *'); ?></label>
              <textarea class="form-control" id="accion_comentario" name="accion_comentario" rows="4"></textarea>
              <br>
            </div>
          </div>

          <div class="alert alert-warning text-start" role="alert" style="text-align: left;">
            ⚠️ <strong><?php echo t('rec_common_note_label', 'NOTA:'); ?></strong>
            <?php echo t('rec_prog_action_note_warning_intro', 'Si la acción a registrar influye en el estatus o color del aspirante en bolsa de trabajo, o en el proceso, no olvides modificar los siguientes campos:'); ?>
            <ul>
              <ul>
                <li>
                  <strong><?php echo t('rec_prog_action_note_candidate_status_title', 'Estatus del Aspirante'); ?></strong>:
                  <?php echo t('rec_prog_action_note_candidate_status_desc', 'Este cambia el color y estatus del aspirante en bolsa de trabajo.'); ?>
                </li>
                <li>
                  <strong><?php echo t('rec_prog_action_note_process_status_title', 'Estatus del Proceso'); ?></strong>:
                  <?php echo t('rec_prog_action_note_process_status_desc', 'Este cambia el estatus actual del proceso de reclutamiento.'); ?>
                </li>
              </ul>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label for="estatus_aspirante"
                     data-toggle="tooltip"
                     data-placement="top"
                     title="<?php echo t('rec_prog_action_tip_candidate_status', 'El cambio realizado impactará directamente en la Bolsa de Trabajo, actualizando tanto el color como el estatus del aspirante'); ?>">
                <?php echo t('rec_prog_action_label_candidate_status', 'Estatus del aspirante'); ?>
                <i class="fas fa-info-circle text-primary"></i>
              </label>
              <select class="form-control" id="estatus_aspirante" name="estatus_aspirante">
                <option value=""><?php echo t('rec_common_select', 'Selecciona'); ?></option>
                <option value="1" data-color="#6c757d">⚪ <?php echo t('rec_prog_action_opt_waiting', 'En espera'); ?></option>
                <option value="3" data-color="#ffc107">🟡 <?php echo t('rec_prog_action_opt_caution', 'Precaucion'); ?></option>
                <option value="2" data-color="#17a2b8">🔵 <?php echo t('rec_prog_action_opt_in_process', 'En proceso de reclutamiento'); ?></option>
                <option value="4" data-color="#28a745">🟢 <?php echo t('rec_prog_action_opt_ready_pre_employment', 'Listo para iniciar el proceso de preempleo'); ?></option>
                <option value="0" data-color="#dc3545">🔴 <?php echo t('rec_prog_action_opt_block', 'Bloquear aspirante'); ?></option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="estatus_proceso"
                     data-toggle="tooltip"
                     data-placement="top"
                     title="<?php echo t('rec_prog_action_tip_process_status', "Esta opción se registra en este módulo 'En proceso' y se refleja en la columna 'Estatus Actual'"); ?>">
                <?php echo t('rec_prog_action_label_process_status', 'Estatus proceso'); ?>
                <i class="fas fa-info-circle text-primary"></i>
              </label>
              <select class="form-control" id="estatus_proceso" name="estatus_proceso">
                <option value=""><?php echo t('rec_common_select', 'Selecciona'); ?></option>
                <option value="1"><?php echo t('rec_prog_action_opt_completed', 'Completado'); ?></option>
                <option value="3"><?php echo t('rec_prog_action_opt_canceled', 'Cancelado'); ?></option>
                <option value="2"><?php echo t('rec_prog_action_opt_remove_final_status', 'Eliminar Estatus Final'); ?></option>
              </select>
            </div>
          </div>
        </form>

        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?php echo t('rec_common_cancel', 'Cancelar'); ?>
        </button>
        <button type="button" class="btn btn-success" onclick="guardarAccion()">
          <?php echo t('rec_prog_action_btn_register', 'Registrar'); ?>
        </button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="historialModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <?php echo t('rec_prog_history_modal_title', 'Historial de movimientos del aspirante:'); ?>
          <br><span class="nombreAspirante"></span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo t('rec_common_close', 'Cerrar'); ?>">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="div_historial_aspirante"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?php echo t('rec_common_close', 'Cerrar'); ?>
        </button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="estatusRequisicionModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo t('rec_prog_req_status_modal_title', 'Estatus de requisición'); ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo t('rec_common_close', 'Cerrar'); ?>">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="formEstatusReq">
          <div class="row">
            <div class="col-12">
              <label><?php echo t('rec_prog_req_status_field_req', 'Requisición *'); ?></label>
              <select name="req_estatus" id="req_estatus">
                <option value=""><?php echo t('rec_common_select', 'Selecciona'); ?></option>
                <?php if ($reqs) { foreach ($reqs as $req) { ?>
                  <option value="<?php echo $req->idReq; ?>">
                    <?php echo '# ' . $req->idReq . ' ' . $req->nombre_cliente . ' - ' . $req->puesto . ' - Vacantes: ' . $req->numero_vacantes; ?>
                  </option>
                <?php } } ?>
              </select>
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 col-md-4 offset-4">
              <label><?php echo t('rec_prog_req_status_field_assign', 'Estatus a asignar *'); ?></label>
              <select name="asignar_estatus" id="asignar_estatus" class="form-control obligado">
                <option value=""><?php echo t('rec_common_select', 'Selecciona'); ?></option>
                <option value="3"><?php echo t('rec_prog_req_status_opt_finish', 'Terminar'); ?></option>
                <option value="0"><?php echo t('rec_prog_req_status_opt_cancel', 'Cancelar'); ?></option>
                <option value="1"><?php echo t('rec_prog_req_status_opt_delete', 'Eliminar'); ?></option>
              </select>
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <label><?php echo t('rec_prog_req_status_field_comments', 'Comentarios *'); ?></label>
              <textarea class="form-control" name="comentario_estatus" id="comentario_estatus" rows="4"></textarea>
              <br>
            </div>
          </div>
        </form>

        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?php echo t('rec_common_cancel', 'Cancelar'); ?>
        </button>
        <button type="button" class="btn btn-success" onclick="guardarEstatusRequisicion()">
          <?php echo t('rec_common_save', 'Guardar'); ?>
        </button>
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
          <span>&times;</span>
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
                  foreach ($reqs as $req) {?>
              <option value="<?php echo $req->id; ?>">
                <?php echo '# ' . $req->id . ' ' . $req->nombre . ' - ' . $req->puesto . ' - Vacantes: ' . $req->numero_vacantes; ?>
              </option>
              <?php }
              }?>
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
          <span>&times;</span>
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

<!-- Modal Subir / Administrar Documentos -->
<div class="modal fade" id="modalDocumentos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Documentos de <span id="docNombreAspirante"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <!-- Tabla de documentos -->
        <table class="table table-bordered" id="tablaDocumentos">
          <thead>
            <tr>
              <th>Archivo</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>

        <hr>
        <!-- Subir nuevos documentos -->
        <form id="formSubirDocs" enctype="multipart/form-data">
          <input type="hidden" name="id_aspirante" id="docIdAspirante">

          <div class="form-group">
            <label>Subir nuevos documentos</label>
            <input type="file" name="archivos[]" id="inputArchivos" multiple class="form-control">
            <small class="form-text text-muted">Selecciona varios; podrás editar el nombre antes de subir.</small>
          </div>
          <!-- Vista previa + nombres personalizados -->
          <div id="previewArchivos" class="mb-3" style="display:none;">
            <table class="table table-sm table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Archivo</th>
                  <th>Nombre personalizado</th>
                  <th>Peso</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Subir</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal: Cambiar Estatus -->
<div class="modal fade" id="modalStatus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content shadow-lg">

      <div class="modal-header bg-primary text-white py-2">
        <h5 class="modal-title mb-0">
          <i class="fas fa-user-tag me-2"></i> Cambiar estatus
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="statusIdAspirante">

        <div class="form-group">
          <label for="selectStatus">Estatus del Aspirante</label>
          <select id="selectStatus" class="form-control">
            <option value="">-- Selecciona estatus --</option>
            <option value="1" class="status-1">En espera de asignar a proceso</option>
            <option value="2" class="status-2">En proceso</option>
            <option value="3" class="status-3">Reutilizable / Revisar Historial</option>
            <option value="4" class="status-4">Contratado</option>
            <option value="5" class="status-5">Aprobado con acuerdo</option>
          </select>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="guardarStatusAspirante()">
          <i class="fas fa-save"></i> Guardar
        </button>
      </div>

    </div>
  </div>
</div>


<!-- ESTAMOS AQUI -->
<div class="modal fade" id="registroCandidatoModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <meta charset="UTF-8">
        <h4 class="modal-title"><?php echo t('rec_prog_candidate_modal_title', 'Registro de candidatos'); ?></h4>

        <!-- div id="language-switch">
          <label for="language-select">Language:</label>
          <select id="language-select" onchange="switchLanguage(this.value);">
            <option value="english">English</option>
            <option value="spanish">Español</option>
          </select>
        </div -->
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo t('rec_common_close', 'Cerrar'); ?>">
          <span>&times;</span>
        </button>

      </div>

      <div class="modal-body">
        <div class="alert alert-info text-center"><?php echo t('rec_prog_candidate_section_general', 'Datos generales'); ?></div>

        <form id="nuevoRegistroForm">
          <div class="row">
            <div class="col-4">
              <label><?php echo t('rec_prog_candidate_f_first_name', 'Nombre (s) *'); ?></label>
              <input type="text" class="form-control obligado" name="nombre_registro" id="nombre_registro"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-4">
              <label><?php echo t('rec_prog_candidate_f_lastname_1', 'Paterno*'); ?></label>
              <input type="text" class="form-control obligado" name="paterno_registro" id="paterno_registro"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-4">
              <label><?php echo t('rec_prog_candidate_f_lastname_2', 'Materno'); ?></label>
              <input type="text" class="form-control" name="materno_registro" id="materno_registro"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-4">
              <label><?php echo t('rec_prog_candidate_f_subclient', 'Subcliente'); ?></label>
              <select name="subcliente" id="subcliente" class="form-control obligado">
                <option value="0"><?php echo t('rec_common_na', 'N/A'); ?></option>
              </select>
              <br>
            </div>

            <div class="col-4">
              <label><?php echo t('rec_prog_candidate_f_position', 'Posición*'); ?></label>
              <select name="puesto" id="puesto" class="form-control" onchange="mostrarInputOtro()">
                <option value="0" selected><?php echo t('rec_common_na', 'N/A'); ?></option>
                <option value="otro"><?php echo t('rec_common_other', 'Otro'); ?></option>
              </select>

              <br>

              <!-- Input oculto que se muestra cuando seleccionan "Otro" -->
              <input type="text" name="puesto_otro" id="puesto_otro" class="form-control"
                placeholder="<?php echo t('rec_prog_candidate_ph_specify_position', 'Especificar posición'); ?>"
                style="display: none;">
            </div>

            <div class="col-4">
              <label><?php echo t('rec_prog_candidate_f_phone', 'Teléfono *'); ?></label>
              <input type="text" class="form-control obligado" name="celular_registro" id="celular_registro"
                maxlength="16">
              <input type="hidden" class="form-control obligado" name="id_cliente_portal" id="id_cliente_portal">
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-4">
              <label><?php echo t('rec_prog_candidate_f_country_residence', 'País de residencia *'); ?></label>
              <select class="form-control" id="pais" name="pais">
                <?php
                    if ($paises != null) {
                        foreach ($paises as $p) {
                        $default = ($p->nombre == 'México') ? 'selected' : ''; ?>
                <option value="<?php echo $p->nombre; ?>" <?php echo $default ?>><?php echo $p->nombre; ?></option>
                <?php
                    }
                    }
                ?>
              </select>
              <br>
            </div>
            <div class="col-4">
              <label><?php echo t('rec_prog_candidate_f_email', 'Correo*'); ?> </label>
              <input type="text" class="form-control obligado" name="correo_registro" id="correo_registro">
              <br>
            </div>
            <div class="col-4">
              <label><?php echo t('rec_prog_candidate_f_curp', 'CURP'); ?></label>
              <input type="text" class="form-control obligado" name="curp_registro" id="curp_registro"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                maxlength="18">
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-4">
              <label><?php echo t('rec_prog_candidate_f_ssn', 'Número de Seguro Social (SSN)'); ?></label>
              <input type="text" class="form-control obligado" name="nss_registro" id="nss_registro" maxlength="11">
              <input type="hidden" class="form-control obligado" name="id_cliente_hidden" id="id_cliente_hidden" maxlength="11">
              <input type="hidden" class="form-control obligado" name="clave" id="clave" maxlength="11">
              <input type="hidden" class="form-control obligado" name="cliente" id="cliente" maxlength="11">
              <input type="hidden" class="form-control obligado" name="idAspiranteReq" id="idAspiranteReq" maxlength="11">
            </div>
          </div>

          <br><br>

          <div class="alert alert-info text-center">
            <?php echo t('rec_prog_candidate_choose_option', 'Seleccione una de las siguientes opciones:'); ?>
          </div>

          <div class="row">
            <div class="col-12">
              <select name="opcion_registro" id="opcion_registro" class="form-control registro_obligado">
                <option value="2" selected><?php echo t('rec_prog_candidate_opt_self_process_free', 'Registrar mi propio proceso - Gratis'); ?></option>
                <option value="0"><?php echo t('rec_prog_candidate_opt_prev_or_new_project', 'Seleccionar un proyecto anterior o crear uno nuevo / Enviado a RODI'); ?></option>
                <option value="1"><?php echo t('rec_prog_candidate_opt_drug_med_only', 'Registrar al candidato solo con Prueba de Drogas y/o Examen Médico / Enviado a RODI'); ?></option>
              </select>

              <br>
            </div>
          </div>

          <div class="alert alert-info text-center div_info_previo">
            <?php echo t('rec_prog_candidate_prev_project_title', 'Seleccionar un Proyecto Anterior'); ?>
          </div>

          <div class="row div_previo">
            <div class="alert alert-warning text-center">
              <?php echo t('rec_prog_candidate_rodi_cost_notice_1', 'Al enviar a RODI se genera un costo. Si no estás seguro de los costos, ponte en contacto con'); ?>
              <a href="mailto:bramirez@rodicontrol.com">bramirez@rodicontrol.com</a>.
            </div>

            <div class="col-md-12">
              <label><?php echo t('rec_prog_candidate_prev_projects_label', 'Previous projects'); ?></label>
              <select class="form-control" name="previos" id="previos"></select><br>
            </div>
          </div>

          <div id="detalles_previo"></div>

          <div class="nuevo_proyecto">
            <div class="row div_project">
              <div class="alert alert-info text-center div_info_projectt">
                <?php echo t('rec_prog_candidate_new_project_title', 'Select a New Project'); ?>
              </div>

              <div class="col-md-4">
                <label><?php echo t('rec_prog_candidate_new_project_location', 'Location *'); ?></label>
                <select name="region" id="region" class="form-control registro_obligado">
                  <option value=""><?php echo t('rec_common_select', 'Select'); ?></option>
                  <option value="Mxico"><?php echo t('rec_prog_candidate_region_mexico', 'Mexico'); ?></option>
                  <option value="International"><?php echo t('rec_prog_candidate_region_international', 'International'); ?></option>
                </select>
                <br>
              </div>

              <div class="col-md-4">
                <label><?php echo t('rec_prog_candidate_new_project_country', 'Country'); ?></label>
                <select name="pais_registro" id="pais_registro" class="form-control registro_obligado" disabled>
                  <option value=""><?php echo t('rec_common_select', 'Select'); ?></option>
                  <?php foreach ($paises_estudio as $pe) {?>
                    <option value="<?php echo $pe->nombre_espanol; ?>"><?php echo $pe->nombre_ingles; ?></option>
                  <?php }?>
                </select>
                <br>
              </div>

              <div class="col-md-4">
                <label><?php echo t('rec_prog_candidate_new_project_name', 'Project name *'); ?></label>
                <input type="text" class="form-control" name="proyecto_registro" id="proyecto_registro" disabled>
                <br>
              </div>
            </div>

            <div class="alert alert-info text-center div_info_check">
              <?php echo t('rec_prog_candidate_required_info_new_project', 'Required Information for the New Project'); ?><br>
              <?php echo t('rec_common_note_label', 'Note:'); ?><br>
              <ul class="text-left">
                <li><?php echo t('rec_prog_candidate_required_info_note_1', 'The required documents will add automatically depending of the selected options . The extra documents are optional, select them before the complementary tests.'); ?></li>
              </ul>
            </div>

            <div class="row div_check">
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_employment_history', 'Employment history *'); ?></label>
                <select name="empleos_registro" id="empleos_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_time_required', 'Time required'); ?></label>
                <select name="empleos_tiempo_registro" id="empleos_tiempo_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
            </div>

            <div class="row div_check">
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_criminal_check', 'Criminal check *'); ?></label>
                <select name="criminal_registro" id="criminal_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_time_required', 'Time required'); ?></label>
                <select name="criminal_tiempo_registro" id="criminal_tiempo_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
            </div>

            <div class="row div_check">
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_address_history', 'Address history *'); ?></label>
                <select name="domicilios_registro" id="domicilios_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_time_required', 'Time required'); ?></label>
                <select name="domicilios_tiempo_registro" id="domicilios_tiempo_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
            </div>

            <div class="row div_check">
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_education_check', 'Education check *'); ?></label>
                <select name="estudios_registro" id="estudios_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_global_searches', 'Global data searches *'); ?></label>
                <select name="global_registro" id="global_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
            </div>

            <div class="row div_check">
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_credit_check', 'Credit check *'); ?></label>
                <select name="credito_registro" id="credito_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_time_required', 'Time required'); ?></label>
                <select name="credito_tiempo_registro" id="credito_tiempo_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
            </div>

            <div class="row div_check">
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_prof_refs_qty', 'Professional References (quantity)'); ?></label>
                <input type="number" class="form-control valor_dinamico" id="ref_profesionales_registro" name="ref_profesionales_registro" value="0" disabled>
                <br>
              </div>
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_personal_refs_qty', 'Personal References (quantity)'); ?></label>
                <input type="number" class="form-control valor_dinamico" id="ref_personales_registro" name="ref_personales_registro" value="0" disabled>
                <br>
              </div>
            </div>

            <div class="row div_check">
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_identity_check', 'Identity check *'); ?></label>
                <select name="identidad_registro" id="identidad_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_migratory_form_check', 'Migratory form (FM, FM2 or FM3) check *'); ?></label>
                <select name="migracion_registro" id="migracion_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
              </div>
            </div>

            <div class="row div_check">
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_prohibited_parties_check', 'Prohibited parties list check *'); ?></label>
                <select name="prohibited_registro" id="prohibited_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_academic_refs_qty', 'Academic References (quantity)'); ?></label>
                <input type="number" class="form-control valor_dinamico" id="ref_academicas_registro" name="ref_academicas_registro" value="0" disabled>
                <br>
              </div>
            </div>

            <div class="row div_check">
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_mvr_check', 'Motor Vehicle Records (only in some Mexico cities) *'); ?></label>
                <select name="mvr_registro" id="mvr_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
              <div class="col-md-6">
                <label><?php echo t('rec_prog_candidate_curp_check', 'CURP check *'); ?></label>
                <select name="curp_check_registro" id="curp_check_registro" class="form-control valor_dinamico registro_obligado" disabled></select>
                <br>
              </div>
            </div>

            <div class="alert alert-danger text-center div_info_extra">
              <?php echo t('rec_prog_candidate_extra_docs_title', 'Extra documents'); ?>
            </div>

            <div class="row div_extra">
              <div class="col-12">
                <label><?php echo t('rec_prog_candidate_extra_docs_label', 'Select the extra documents *'); ?></label>
                <select name="extra_registro" id="extra_registro" class="form-control registro_obligado">
                  <option value=""><?php echo t('rec_common_select', 'Select'); ?></option>
                  <option value="15"><?php echo t('rec_prog_candidate_extra_military', 'Military document'); ?></option>
                  <option value="14"><?php echo t('rec_prog_candidate_extra_passport', 'Passport'); ?></option>
                  <option value="10"><?php echo t('rec_prog_candidate_extra_license', 'Professional licence'); ?></option>
                  <option value="48"><?php echo t('rec_prog_candidate_extra_credential', 'Academic / Professional Credential'); ?></option>
                  <option value="16"><?php echo t('rec_prog_candidate_extra_resume', 'Resume'); ?></option>
                  <option value="42"><?php echo t('rec_prog_candidate_extra_sex_offender', 'Sex offender registry'); ?></option>
                  <option value="6"><?php echo t('rec_prog_candidate_extra_ssn', 'Social Security Number'); ?></option>
                </select>
                <br>
              </div>
            </div>

            <div class="row">
              <div id="div_docs_extras" class="col-12 d-flex flex-column mb-3"></div>
            </div>
          </div>

          <div class="alert alert-danger text-center div_info_test">
            <?php echo t('rec_prog_candidate_tests_title', 'Complementary Tests'); ?>
          </div>

          <div class="row div_test">
            <div class="alert alert-warning text-center">
              <?php echo t('rec_prog_candidate_rodi_cost_notice_1', 'Al enviar a RODI se genera un costo. Si no estás seguro de los costos, ponte en contacto con'); ?>
              <a href="mailto:bramirez@rodicontrol.com">bramirez@rodicontrol.com</a>.
            </div>

            <div class="col-md-4">
              <label><?php echo t('rec_prog_candidate_test_drug', 'Drug test *'); ?></label>
              <select name="examen_registro" id="examen_registro" class="form-control registro_obligado">
                <option value=""><?php echo t('rec_common_select', 'Select'); ?></option>
                <option value="0" selected><?php echo t('rec_common_na', 'N/A'); ?></option>
                <?php foreach ($paquetes_antidoping as $paq) { ?>
                  <option value="<?php echo $paq->id; ?>">
                    <?php echo $paq->nombre . ' (' . $paq->conjunto . ')'; ?>
                  </option>
                <?php } ?>
              </select>
              <br>
            </div>

            <div class="col-md-4">
              <label><?php echo t('rec_prog_candidate_test_medical', 'Medical test *'); ?></label>
              <select name="examen_medico" id="examen_medico" class="form-control registro_obligado">
                <option value="0"><?php echo t('rec_common_na', 'N/A'); ?></option>
                <option value="1"><?php echo t('rec_common_apply', 'Apply'); ?></option>
              </select>
              <br>
            </div>

            <div class="col-md-4">
              <label><?php echo t('rec_prog_candidate_test_psychometric', 'Psicométric *'); ?></label>
              <select name="examen_psicometrico" id="examen_psicometrico" class="form-control registro_obligado">
                <option value="0"><?php echo t('rec_common_na', 'N/A'); ?></option>
                <option value="1"><?php echo t('rec_common_apply', 'Apply'); ?></option>
              </select>
              <br>
            </div>
          </div>
        </form>

        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?php echo t('rec_common_cancel', 'Cancelar'); ?>
        </button>
        <button type="button" class="btn btn-success" onclick="registrarCandidato()">
          <?php echo t('rec_common_save', 'Guardar'); ?>
        </button>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="historialComentariosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <?php echo t('rec_prog_comments_modal_title', 'Historial de comentarios con respecto a:'); ?>
          <br><span class="nombreRegistro"></span>
        </h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo t('rec_common_close', 'Cerrar'); ?>">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div id="div_historial_comentario" class="escrolable"></div>
        <hr>

        <div class="row">
          <div class="col-12">
            <label for="comentario_bolsa">
              <?php echo t('rec_prog_comments_f_new_comment', 'Registra un nuevo comentario o estatus *'); ?>
            </label>
            <textarea class="form-control" name="comentario_bolsa" id="comentario_bolsa" rows="3"></textarea>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-12">
            <button type="button" class="btn btn-primary text-lg btn-block" id="btnComentario">
              <?php echo t('rec_prog_comments_btn_save', 'Guardar comentario'); ?>
            </button>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?php echo t('rec_common_close', 'Cerrar'); ?>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="modalGenerarLink" tabindex="-1" role="dialog" aria-labelledby="modalGenerarLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalGenerarLabel">Generar o Actualizar Link del Portal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <!-- Logo actual -->
        <div class="mb-3 text-center">
          <label><strong>Logo Actual:</strong></label><br>
          <img id="logoActual" src="<?php echo base_url('_logosPortal/' . $this->session->userdata('logo')) ?>"
            alt="Logo" style="max-height: 80px;"
            onerror="this.onerror=null; this.src='<?php echo base_url('_logosPortal/portal_icon.png') ?>';">
        </div>

        <!-- Aviso actual -->
        <div class="mb-3 text-center">
          <label><strong>Aviso de Privacidad:</strong></label><br>

          <a id="linkAviso" href="<?php echo base_url('Avance/ver_aviso/' . $archivo); ?>" target="_blank">
            Ver documento</a>
        </div>

        <!-- Link generado -->
        <div class="mb-3">
          <label><strong>Link Generado:</strong></label>
          <div id="linkGenerado" class="text-break">Cargando...</div>
        </div>

        <!-- QR generado -->
        <div class="mb-3 text-center">
          <label><strong>Código QR:</strong></label>
          <div id="qrGenerado"></div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" id="btnGenerarLink" class="btn btn-primary">Generar / Actualizar Link</button>
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
            <span>&times;</span>
          </button>
        </div>
        <div class="alert alert-info">
          <?php echo t('rec_new_req_info_alert', 'Este formulario permite registrar una requisición...') ?>
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
              <label for="id_cliente"><?php echo t('rec_new_req_f_client', 'Cliente') ?> *</label>
              <select name="id_cliente" id="id_cliente" class="form-control acceso_obligado">
              </select>
              <br>
            </div>
            <div class="col-6">

              <label for="nombre_comercial_req"><?php echo t('rec_new_req_f_trade_name', 'Nombre comercial') ?>
                *</label>
              <input type="text" class="form-control" data-required="required" data-field="Nombre comercial"
                name="nombre_comercial_req" id="nombre_comercial_req"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>

          </div>
          <div class="row mb-3">
            <div class="col-6">
              <label for="nombre_req"><?php echo t('rec_new_req_f_legal_name', 'Razón social') ?> *</label>
              <input type="text" class="form-control" data-required="required" data-field="Razón social"
                name="nombre_req" id="nombre_req"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
            <div class="col-6">
              <label for="correo_req"><?php echo t('rec_new_req_f_email', 'Correo') ?></label>
              <input type="text" class="form-control" data-field="Correo" name="correo_req" id="correo_req">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-3">
              <label for="cp_req"><?php echo t('rec_new_req_f_zip', 'Código postal') ?></label>
              <input type="number" class="form-control" data-field="Código postal" name="cp_req" id="cp_req"
                maxlength="5">
            </div>
            <div class="col-3">
              <label for="telefono_req"><?php echo t('rec_new_req_f_phone', 'Teléfono') ?></label>
              <input type="text" class="form-control" data-field="Teléfono" name="telefono_req" id="telefono_req"
                maxlength="16">
            </div>
            <div class="col-3">
              <label for="contacto_req"><?php echo t('rec_new_req_f_contact', 'Contacto') ?></label>
              <input type="text" class="form-control" data-field="Contacto" name="contacto_req" id="contacto_req">
            </div>
            <div class="col-3">
              <label for="rfc_req"><?php echo t('rec_new_req_f_rfc', 'RFC') ?></label>
              <input type="text" class="form-control" data-field="RFC" name="rfc_req" id="rfc_req" maxlength="13"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
          </div>
          <hr>
          <p style="text-align:center;color:#808080;">
            <?php echo t('rec_new_req_full_block_hint', 'Datos para llenar Requisición Completa ↓') ?>
          </p>
          <hr>
          <div class=" row">
            <div class="col-md-3">
              <label for="pais_req"><?php echo t('rec_new_req_f_country', 'País') ?> *</label>
              <input type="text" class="form-control" id="pais_req" name="pais_req">
            </div>
            <div class="col-md-3">
              <label for="estado_req"><?php echo t('rec_new_req_f_state', 'Estado') ?> *</label>
              <input type="text" class="form-control" id="estado_req" name="estado_req">
            </div>
            <div class="col-md-3">
              <label for="ciudad_req"><?php echo t('rec_new_req_f_city', 'Ciudad') ?> *</label>
              <input type="text" class="form-control" id="ciudad_req" name="ciudad_req">
            </div>
            <div class="col-md-3">
              <label for="colonia_req"><?php echo t('rec_new_req_f_neighborhood', 'Colonia') ?> *</label>
              <input type="text" class="form-control" id="colonia_req" name="colonia_req">
            </div>
          </div>
          <div class="row mt-3">

            <div class="col-md-8">
              <label for="calle_req"><?php echo t('rec_new_req_f_street', 'Calle') ?> *</label>
              <input type="text" class="form-control" id="calle_req" name="calle_req">
            </div>
            <div class="col-md-2">
              <label for="interior_req"><?php echo t('rec_new_req_f_interior', 'Interior') ?></label>
              <input type="text" class="form-control" id="interior_req" name="interior_req">
            </div>
            <div class="col-md-2">
              <label for="exterior_req"><?php echo t('rec_new_req_f_exterior', 'Exterior') ?></label>
              <input type="text" class="form-control" id="exterior_req" name="exterior_req">
            </div>

          </div>
          <br>
          <div class="row mb-3">

            <div class="col-3">
              <label for="regimen_req"><?php echo t('rec_new_req_f_tax_regime', 'Régimen Fiscal') ?> *</label>
              <div class="input-group mb-3">

                <input type="text" class="form-control" id="regimen_req" name="regimen_req">
              </div>
              <div id="errorregimen" class="text-danger"></div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-3">
              <label for="forma_pago_req"><?php echo t('rec_new_req_f_payment_form', 'Forma de pago') ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                </div>
                <select class="custom-select" id="forma_pago_req" name="forma_pago_req">
                  <option value="" selected><?php echo t('rec_common_select', 'Selecciona') ?></option>
                  <option value="Pago en una sola exhibición">
                    <?php echo t('rec_new_req_payform_single', 'Pago en una sola exhibición') ?>
                  </option>
                  <option value="Pago en parcialidades o diferidos">
                    <?php echo t('rec_new_req_payform_installments', 'Pago en parcialidades o diferidos') ?>
                  </option>


                </select>
                <div id="forma_pago" class="text-danger"></div>
              </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-3">
              <label for="metodo_pago_req"><?php echo t('rec_new_req_f_payment_method', 'Método de pago') ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                </div>
                <select class="custom-select" id="metodo_pago_req" name="metodo_pago_req">
                  <option value="" selected><?php echo t('rec_common_select', 'Selecciona') ?></option>
                  <option value="Efectivo"><?php echo t('rec_new_req_paymethod_cash', 'Efectivo') ?></option>
                  <option value="Cheque de nómina">
                    <?php echo t('rec_new_req_paymethod_payroll_check', 'Cheque de nómina') ?></option>
                  <option value="Transferencia electrónica">
                    <?php echo t('rec_new_req_paymethod_transfer', 'Transferencia electrónica') ?></option>
                  <option value="Tarjeta de crédito">
                    <?php echo t('rec_new_req_paymethod_credit_card', 'Tarjeta de crédito') ?></option>
                  <option value="Tarjeta de débito">
                    <?php echo t('rec_new_req_paymethod_debit_card', 'Tarjeta de débito') ?></option>
                  <option value="Por definir"><?php echo t('rec_new_req_paymethod_tbd', 'Por definir') ?></option>

                </select>
              </div>
            </div>
            <div class="col-3">
              <label for="uso_cfdi_req"><?php echo t('rec_new_req_f_cfdi_use', 'Uso de CFDI') ?></label>
              <input type="text" class="form-control" data-field="Uso de CFDI" name="uso_cfdi_req" id="uso_cfdi_req"
                value="Gastos Generales">
            </div>
          </div>

        </form>
        <form id="formPaso2" class="hidden">
          <div class="row mb-3">
            <div class="col-6">
              <label for="puesto_req"><?php echo t('rec_new_req_f_position_name', 'Nombre de la posición') ?> *</label>
              <input type="text" class="form-control" data-field="Nombre de la posición" name="puesto_req"
                id="puesto_req">
            </div>
            <div class="col-6">
              <label for="numero_vacantes_req"><?php echo t('rec_new_req_f_vacancies', 'Número de vacantes') ?>
                *</label>
              <input type="number" class="form-control" data-field="Número de vacantes" name="numero_vacantes_req"
                id="numero_vacantes_req">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12">
              <label for="residencia_req"><?php echo t('rec_desk_det_residence', 'Lugar de residencia') ?></label>
              <textarea class="form-control" data-field="Lugar de residencia" name="residencia_req" id="residencia_req"
                rows="2"></textarea>
            </div>
          </div>
          <hr>
          <p style="text-align:center;color:#808080;">
            <?php echo t('rec_new_req_full_block_hint', 'Datos para llenar Requisición Completa ↓') ?>
          </p>
          <hr>
          <div class=" row">
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label
                for="escolaridad_req"><?php echo t('rec_desk_det_required_education', 'Formación académica requerida') ?>
                *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                </div>
                <select class="custom-select" id="escolaridad_req" name="escolaridad_req"
                  data-siguiente-campo="estatus_escolaridad">
                  <option value="" selected><?php echo t('rec_common_select', 'Selecciona') ?></option>
                  <option value="Primaria"><?php echo t('rec_desk_vac_edu_primary', 'Primaria') ?></option>
                  <option value="Secundaria"><?php echo t('rec_desk_vac_edu_secondary', 'Secundaria') ?></option>
                  <option value="Bachiller"><?php echo t('rec_desk_vac_edu_highschool', 'Bachiller') ?></option>
                  <option value="Licenciatura"><?php echo t('rec_desk_vac_edu_bachelor', 'Licenciatura') ?></option>
                  <option value="Maestría"><?php echo t('rec_desk_vac_edu_master', 'Maestría') ?></option>

                </select>
              </div>
              <div id="errorescolaridad" class="text-danger"></div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label for="estatus_escolaridad_req"><?php echo t('rec_new_req_f_academic_status', 'Estatus académico') ?>
                *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                </div>
                <select class="custom-select" id="estatus_escolaridad_req" name="estatus_escolaridad_req"
                  data-siguiente-campo="carrera">
                  <label
                    for="estatus_escolaridad_req"><?php echo t('rec_new_req_f_academic_status', 'Estatus académico') ?>
                    *</label>
                  <option value="Técnico"><?php echo t('rec_desk_vac_status_technical', 'Técnico') ?></option>
                  <option value="Pasante"><?php echo t('rec_desk_vac_status_intern', 'Pasante') ?></option>
                  <option value="Estudiante"><?php echo t('rec_desk_vac_status_student', 'Estudiante') ?></option>
                  <option value="Titulado"><?php echo t('rec_desk_vac_status_graduated', 'Titulado') ?></option>
                  <option value="Trunco"><?php echo t('rec_desk_vac_status_incomplete', 'Trunco') ?></option>
                  <option value="Otro"><?php echo t('rec_desk_vac_status_other', 'Otro') ?></option>

                </select>
              </div>
              <div id="errorestatus_escolaridadd" class="text-danger"></div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
              <label
                for="otro_estatus_req"><?php echo t('rec_new_req_f_other_academic_status', 'Otro estatus académico') ?></label>
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
              <label
                for="carrera_req"><?php echo t('rec_new_req_f_required_degree', 'Carrera requerida para el puesto') ?>
                *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                </div>
                <input type="text" class="form-control" id="carrera_req" name="carrera_req"
                  data-siguiente-campo="genero">
              </div>
              <div id="errorcarrera" class="text-danger"></div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
              <label for="otros_estudios_req"><?php echo t('rec_new_req_f_other_studies', 'Otros estudios') ?></label>
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
              <label for="idioma1_req"><?php echo t('rec_new_req_f_native_language', 'Idioma nativo') ?></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-language"></i></span>
                </div>
                <input type="text" class="form-control" id="idioma1_req" name="idioma1_req">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label
                for="por_idioma1_req"><?php echo t('rec_new_req_f_native_language_pct', 'Porcentaje del idioma nativo') ?></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                </div>
                <input type="number" class="form-control" id="por_idioma1_req" name="por_idioma1_req">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label for="idioma2_req"><?php echo t('rec_new_req_f_second_language', 'Segundo idioma') ?></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-language"></i></span>
                </div>
                <input type="text" class="form-control" id="idioma2_req" name="idioma2_req">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label
                for="por_idioma2_req"><?php echo t('rec_new_req_f_second_language_pct', 'Porcentaje del segundo idioma') ?></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                </div>
                <input type="number" class="form-control" id="por_idioma2_req" name="por_idioma2_req">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label for="idioma3_req"><?php echo t('rec_new_req_f_third_language', 'Tercer idioma') ?></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-language"></i></span>
                </div>
                <input type="text" class="form-control" id="idioma3_req" name="idioma3_req">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label
                for="por_idioma3_req"><?php echo t('rec_new_req_f_third_language_pct', 'Porcentaje del tercer idioma') ?></label>
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
              <label
                for="habilidad1_req"><?php echo t('rec_new_req_f_it_skill_1', 'Habilidad informática requerida') ?></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                </div>
                <input type="text" class="form-control" id="habilidad1_req" name="habilidad1_req">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label
                for="por_habilidad1_req"><?php echo t('rec_new_req_f_it_skill_pct_1', 'Porcentaje de la habilidad') ?></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                </div>
                <input type="number" class="form-control" id="por_habilidad1_req" name="por_habilidad1_req">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label
                for="habilidad2_req"><?php echo t('rec_new_req_f_it_skill_2', 'Otra habilidad informática') ?></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                </div>
                <input type="text" class="form-control" id="habilidad2_req" name="habilidad2_req">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label
                for="por_habilidad2_req"><?php echo t('rec_new_req_f_it_skill_pct_2', 'Porcentaje de la habilidad') ?></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                </div>
                <input type="number" class="form-control" id="por_habilidad2_req" name="por_habilidad2_req">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label
                for="habilidad3_req"><?php echo t('rec_new_req_f_it_skill_3', 'Otra habilidad informática') ?></label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                </div>
                <input type="text" class="form-control" id="habilidad3_req" name="habilidad3_req">
              </div>
            </div>
            <div class="col-sm-12 col-md-2 col-lg-2">
              <label
                for="por_habilidad3_req"><?php echo t('rec_new_req_f_it_skill_pct_3', 'Porcentaje de la habilidad') ?></label>
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
              <label for="genero_req"><?php echo t('rec_new_req_f_gender', 'Sexo') ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                </div>
                <select class="custom-select" id="genero_req" name="genero_req" data-siguiente-campo="civil">
                  <option value="NULL" selected><?php echo t('rec_common_select', 'Selecciona') ?></option>
                  <option value="Femenino"><?php echo t('rec_common_female', 'Femenino') ?></option>
                  <option value="Masculino"><?php echo t('rec_common_male', 'Masculino') ?></option>
                  <option value="Indistinto"><?php echo t('rec_common_any', 'Indistinto') ?></option>

                </select>
              </div>
              <div id="errorgenero" class="text-danger"></div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label for="civil_req"><?php echo t('rec_new_req_f_marital_status', 'Estado civil') ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                </div>
                <select class="custom-select" id="civil_req" name="civil_req" data-siguiente-campo="edad_minima">
                  <option value="NULL" selected><?php echo t('rec_common_select', 'Selecciona') ?></option>
                  <option value="Soltero(a)"><?php echo t('rec_new_req_opt_marital_single', 'Soltero(a)') ?></option>
                  <option value="Casado(a)"><?php echo t('rec_new_req_opt_marital_married', 'Casado(a)') ?></option>
                  <option value="Indistinto"><?php echo t('rec_common_any', 'Indistinto') ?></option>

                </select>
              </div>
              <div id="errorcivil" class="text-danger"></div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label for="edad_minima_req"><?php echo t('rec_new_req_f_min_age', 'Edad mínima') ?> *</label>
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
              <label for="edad_maxima_req"><?php echo t('rec_new_req_f_max_age', 'Edad máxima') ?> *</label>
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
              <label for="licencia_req"><?php echo t('rec_new_req_f_driver_license', 'Licencia de conducir') ?>
                *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                </div>
                <select class="custom-select" id="licencia_req" name="licencia_req"
                  data-siguiente-campo="tipo_licencia">
                  <option value="" selected><?php echo t('rec_common_select', 'Selecciona') ?></option>
                  <option value="Indispensable"><?php echo t('rec_new_req_opt_license_required', 'Indispensable') ?>
                  </option>
                  <option value="Deseable"><?php echo t('rec_new_req_opt_license_desirable', 'Deseable') ?></option>
                  <option value="No necesaria"><?php echo t('rec_new_req_opt_license_not_needed', 'No necesaria') ?>
                  </option>

                </select>
              </div>
              <div id="errorlicencia" class="text-danger"></div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label
                for="tipo_licencia_req"><?php echo t('rec_desk_vac_driver_license_type', 'Tipo de licencia de conducir') ?>
                *</label>
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
              <label for="discapacidad"><?php echo t('rec_new_req_f_disability', 'Discapacidad aceptable') ?> *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-wheelchair"></i></span>
                </div>
                <select class="custom-select" id="discapacidad" name="discapacidad_req"
                  data-siguiente-campo="discapacidad_req">
                  <option value="NULL" selected><?php echo t('rec_common_select', 'Selecciona') ?></option>
                  <option value="Motora"><?php echo t('rec_new_req_opt_disability_motor', 'Motora') ?></option>
                  <option value="Auditiva"><?php echo t('rec_new_req_opt_disability_hearing', 'Auditiva') ?></option>
                  <option value="Visual"><?php echo t('rec_new_req_opt_disability_visual', 'Visual') ?></option>
                  <option value="Motora y auditiva">
                    <?php echo t('rec_new_req_opt_disability_motor_hearing', 'Motora y auditiva') ?></option>
                  <option value="Motora y visual">
                    <?php echo t('rec_new_req_opt_disability_motor_visual', 'Motora y visual') ?></option>
                  <option value="Sin discapacidad">
                    <?php echo t('rec_new_req_opt_disability_none', 'Sin discapacidad') ?>
                  </option>

                </select>
              </div>
              <div id="errordiscapacidad" class="text-danger"></div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3">
              <label for="causa_req"><?php echo t('rec_new_req_f_vacancy_cause', 'Causa que origina la vacante') ?>
                *</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="far fa-question-circle"></i></span>
                </div>
                <select class="custom-select" id="causa_req" name="causa_req" data-siguiente-campo="residencia">
                  <label for="causa_req"><?php echo t('rec_new_req_f_vacancy_cause', 'Causa que origina la vacante') ?>
                    *</label>
                  <option value="Empresa nueva"><?php echo t('rec_new_req_opt_cause_new_company', 'Empresa nueva') ?>
                  </option>
                  <option value="Empleo temporal"><?php echo t('rec_new_req_opt_cause_temporary', 'Empleo temporal') ?>
                  </option>
                  <option value="Puesto de nueva creación">
                    <?php echo t('rec_new_req_opt_cause_new_position', 'Puesto de nueva creación') ?></option>
                  <option value="Reposición de personal">
                    <?php echo t('rec_new_req_opt_cause_replacement', 'Reposición de personal') ?></option>

                </select>
              </div>
              <div id="errorcausa" class="text-danger"></div>
            </div>
          </div>
        </form>
        <form id="formPaso3" class="hidden">
          <div class="row mb-3">
            <div class="col-12">
              <label for="zona_req"><?php echo t('rec_new_req_f_work_address', 'Domicilio de trabajo') ?> *</label>
              <textarea class="form-control" data-required="required" data-field="Zona de trabajo" name="zona_req"
                id="zona_req" rows="2"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-3">
              <label for="tipo_sueldo_req"><?php echo t('rec_new_req_f_salary_type', 'Tipo de sueldo') ?> *</label>
              <select class="form-control" data-required="required" data-field="Tipo de sueldo" id="tipo_sueldo_req"
                name="tipo_sueldo_req">
                <option value="NULL" selected><?php echo t('rec_common_select', 'Selecciona') ?></option>
                <option value="Neto"><?php echo t('rec_new_req_opt_salary_net', 'Neto (Libre)') ?></option>
                <option value="Nominal"><?php echo t('rec_new_req_opt_salary_nominal', 'Nominal (Salario bruto)') ?>
                </option>
              </select>
            </div>

            <div class="col-3">
              <label for="sueldo_minimo_req"><?php echo t('rec_new_req_f_salary_min', 'Sueldo mínimo') ?> *</label>
              <input type="number" class="form-control" data-field="Sueldo mínimo" id="sueldo_minimo_req"
                name="sueldo_minimo_req">
            </div>

            <div class="col-3">
              <label for="sueldo_maximo_req"><?php echo t('rec_new_req_f_salary_max', 'Sueldo máximo') ?> *</label>
              <input type="number" class="form-control" data-field="Sueldo máximo" id="sueldo_maximo_req"
                name="sueldo_maximo_req">
            </div>

            <div class="col-3">
              <label for="tipo_pago_req"><?php echo t('rec_new_req_f_payment_type', 'Tipo de pago') ?> *</label>
              <select class="form-control" data-required="required" data-field="Tipo de pago" id="tipo_pago_req"
                name="tipo_pago_req">
                <option value="NULL" selected><?php echo t('rec_common_select', 'Selecciona') ?></option>
                <option value="Mensual"><?php echo t('rec_new_req_opt_pay_monthly', 'Mensual') ?></option>
                <option value="Quincenal"><?php echo t('rec_new_req_opt_pay_biweekly', 'Quincenal') ?></option>
                <option value="Semanal"><?php echo t('rec_new_req_opt_pay_weekly', 'Semanal') ?></option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-3">
              <label
                for="tipo_prestaciones_req"><?php echo t('rec_new_req_f_legal_benefits', '¿Tendrá prestaciones de ley?') ?>
                *</label>
              <select class="form-control" data-required="required" data-field="¿Tendrá prestaciones de ley?"
                id="tipo_prestaciones_req" name="tipo_prestaciones_req">
                <option value="" selected><?php echo t('rec_common_select', 'Selecciona') ?></option>
                <option value="SI"><?php echo t('rec_common_yes', 'Sí') ?></option>
                <option value="NO"><?php echo t('rec_common_no', 'No') ?></option>
              </select>
            </div>

            <div class="col-9">
              <label
                for="experiencia_req"><?php echo t('rec_new_req_f_experience_required', 'Se requiere experiencia en') ?></label>
              <textarea class="form-control" data-field="Se requiere experiencia en" name="experiencia_req"
                id="experiencia_req" rows="2"></textarea>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12">
              <label for="observaciones_req"><?php echo t('rec_new_req_f_notes', 'Observaciones') ?></label>
              <textarea class="form-control" data-field="Observaciones" name="observaciones_req" id="observaciones_req"
                rows="2"></textarea>
            </div>
          </div>

          <hr>
          <p style="text-align: center; color: #808080;">
            <?php echo t('rec_new_req_full_block_hint', 'Datos para llenar Requisición Completa ↓') ?>
          </p>
          <hr>

          <div class="card-body">
            <div class="row">
              <div class="col-sm-12 col-md-4 col-lg-4">
                <label class="container_checkbox"><?php echo t('rec_new_req_comp_communication', 'Comunicación') ?>
                  <input type="checkbox" name="competencias[]" id="Comunicación" value="Comunicación">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_analysis', 'Análisis') ?>
                  <input type="checkbox" name="competencias[]" id="Análisis" value="Análisis">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_leadership', 'Liderazgo') ?>
                  <input type="checkbox" name="competencias[]" id="Liderazgo" value="Liderazgo">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_negotiation', 'Negociación') ?>
                  <input type="checkbox" name="competencias[]" id="Negociación" value="Negociación">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_compliance', 'Apego a normas') ?>
                  <input type="checkbox" name="competencias[]" id="Apego" value="Apego">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_planning', 'Planeación') ?>
                  <input type="checkbox" name="competencias[]" id="Planeación" value="Planeación">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_organization', 'Organización') ?>
                  <input type="checkbox" name="competencias[]" id="Organización" value="Organización">
                  <span class="checkmark"></span>
                </label>
              </div>

              <div class="col-sm-12 col-md-4 col-lg-4">
                <label
                  class="container_checkbox"><?php echo t('rec_new_req_comp_results_oriented', 'Orientado a resultados') ?>
                  <input type="checkbox" name="competencias[]" id="Orientado_resultados" value="Orientado_resultados">
                  <span class="checkmark"></span>
                </label>

                <label
                  class="container_checkbox"><?php echo t('rec_new_req_comp_conflict_management', 'Manejo de conflictos') ?>
                  <input type="checkbox" name="competencias[]" id="Manejo-conflictos" value="Manejo-conflictos">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_teamwork', 'Trabajo en equipo') ?>
                  <input type="checkbox" name="competencias[]" id="Trabajo_equipo" value="Trabajo-equipo">
                  <span class="checkmark"></span>
                </label>

                <label
                  class="container_checkbox"><?php echo t('rec_new_req_comp_decision_making', 'Toma de decisiones') ?>
                  <input type="checkbox" name="competencias[]" id="Toma-decisiones" value="Toma_decisiones">
                  <span class="checkmark"></span>
                </label>

                <label
                  class="container_checkbox"><?php echo t('rec_new_req_comp_work_under_pressure', 'Trabajo bajo presión') ?>
                  <input type="checkbox" name="competencias[]" id="Trabajo-presion" value="Trabajo-presion">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_command', 'Don de mando') ?>
                  <input type="checkbox" name="competencias[]" id="Don_mando" value="Don-mando">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_versatile', 'Versátil') ?>
                  <input type="checkbox" name="competencias[]" id="Versátil" value="Versátil">
                  <span class="checkmark"></span>
                </label>
              </div>

              <div class="col-sm-12 col-md-4 col-lg-4">
                <label class="container_checkbox"><?php echo t('rec_new_req_comp_social', 'Sociable') ?>
                  <input type="checkbox" name="competencias[]" id="Sociable" value="Sociable">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_intuitive', 'Intuitivo') ?>
                  <input type="checkbox" name="competencias[]" id="Intuitivo" value="Intuitivo">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_self_taught', 'Autodidacta') ?>
                  <input type="checkbox" name="competencias[]" id="Autodidacta" value="Autodidacta">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_creative', 'Creativo') ?>
                  <input type="checkbox" name="competencias[]" id="Creativo" value="Creativo">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_proactive', 'Proactivo') ?>
                  <input type="checkbox" name="competencias[]" id="Proactivo" value="Proactivo">
                  <span class="checkmark"></span>
                </label>

                <label class="container_checkbox"><?php echo t('rec_new_req_comp_adaptable', 'Adaptable') ?>
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
          <span class="text"><?php echo t('rec_common_back', 'Regresar') ?></span>
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
        <button type="button" class="close" data-dismiss="modal"
          aria-label="<?php echo t('rec_common_close', 'Cerrar'); ?>">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="formAsignacion">
          <div class="row mb-3">
            <div class="col-md-12">
              <label for="asignar_usuario">
                <?php echo t('rec_assign_user_label', 'Usuario'); ?>
              </label>

              <select id="asignar_usuario" name="asignar_usuario" class="form-control">
                <option value=""><?php echo t('rec_common_select', 'Selecciona'); ?></option>

                <?php if (! empty($usuarios_asignacion)) {?>
                <?php foreach ($usuarios_asignacion as $row) {?>
                <option value="<?php echo $row->id ?>"><?php echo $row->usuario ?></option>
                <?php }?>
                <?php } else {?>
                <option value=""><?php echo t('rec_assign_no_users', 'No hay usuarios correspondientes'); ?></option>
                <?php }?>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-12">
              <label for="asignar_registro">
                <?php echo t('rec_assign_record_label', 'Registro'); ?>
              </label>

              <select name="asignar_registro" id="asignar_registro" class="form-control">
                <option value=""><?php echo t('rec_common_select', 'Selecciona'); ?></option>

                <?php if (! empty($registros_asignacion)) {?>
                <?php foreach ($registros_asignacion as $fila) {?>
                <option value="<?php echo $fila->id ?>">
                  <?php
                      echo '#' . $fila->id . '  ' . $fila->nombreCompleto .
                              (! empty($fila->puesto)
                                  ? ' ' . t('rec_assign_position_prefix', 'Puesto: ') . $fila->puesto
                                  : ''
                          );
                      ?>
                </option>
                <?php }?>
                <?php } else {?>
                <option value=""><?php echo t('rec_assign_no_records', 'No hay registros para asignar'); ?></option>
                <?php }?>
              </select>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?php echo t('rec_common_cancel', 'Cancelar'); ?>
        </button>
        <button type="button" class="btn btn-success" id="btnAsignar">
          <?php echo t('rec_common_save', 'Guardar'); ?>
        </button>
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
          <span>&times;</span>
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
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if ($this->session->userdata('tipo_bolsa') > 0) {?>
        <form action="<?php echo base_url('Importa_excel/importar'); ?>" method="post" enctype="multipart/form-data"
          id="form-importar-excel">
          <input type="hidden" name="id_portal">
          <input type="hidden" name="id_cliente"><!-- si aplica -->
          <div class="form-group">
            <label>Excel (.xlsx)</label>
            <input type="file" name="archivo_excel" accept=".xlsx,.xls" class="form-control" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

            <button class="btn btn-primary">Importar</button>

          </div>
        </form>
      </div>
      <?php } else {?>
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
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

      <button type="button" class="btn btn-success" id="btnSubir">Enviar</button>

    </div>
    <?php }?>
  </div>
</div>
</div>

<div class="modal fade" id="ingresoCandidatoModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <?php echo t('rec_prog_adm_modal_title', 'Información de ingreso al empleo del candidato:'); ?>
          <br><span class="nombreRegistro"></span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo t('rec_prog_btn_close_aria', 'Cerrar'); ?>">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="alert alert-info text-center">
          <?php echo t('rec_prog_adm_warranty_history_title', 'Registros del estatus de la garantía'); ?>
        </div>

        <div id="divHistorialGarantia" class="escrolable"></div>

        <form id="formIngreso">
          <div class="row mb-3">
            <div class="col-4">
              <label><?php echo t('rec_prog_adm_salary_agreed', 'Sueldo acordado'); ?> *</label>
              <input type="text" class="form-control" id="sueldo_acordado" name="sueldo_acordado">
            </div>

            <div class="col-4">
              <label><?php echo t('rec_prog_adm_company_start_date', 'Fecha de ingreso a la empresa'); ?> *</label>
              <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso">
            </div>

            <div class="col-4">
              <label><?php echo t('rec_prog_adm_payment', 'Pago'); ?></label>
              <input type="text" class="form-control" id="pago" name="pago">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12">
              <label for="garantia"><?php echo t('rec_prog_adm_warranty_status', 'Estatus de la garantia'); ?></label>
              <textarea class="form-control" name="garantia" id="garantia" rows="3"></textarea>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-12">
              <button type="button" class="btn btn-primary text-lg btn-block" onclick="updateAdmission()">
                <?php echo t('rec_prog_adm_btn_save_info', 'Guardar información'); ?>
              </button>
            </div>
          </div>
      </div>
      </form>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?php echo t('rec_prog_btn_close', 'Cerrar'); ?>
        </button>
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
          <span>&times;</span>
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
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4 id="mensaje"></h4>
        <div id="campos_mensaje"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?php echo t('rec_common_cancel', 'Cancelar'); ?>
        </button>

        <button type="button" class="btn btn-success" id="btnConfirmar">
          <?php echo t('rec_common_confirm', 'Confirmar'); ?>
        </button>
      </div>

    </div>
  </div>
</div>
<!-- Modal para cargar CV -->
<div class="modal fade" id="modalCargaArchivos" tabindex="-1" role="dialog" aria-labelledby="modalCargaArchivosLabel">
  <div class="modal-dialog" role="document" style="max-width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCargaArchivosLabel">
          <?php echo t('rec_prog_upload_modal_title', 'Carga y nombra tus archivos'); ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo t('rec_common_close', 'Cerrar'); ?>">
          <span>&times;</span>
        </button>
      </div>

      <form id="formCargaArchivos" enctype="multipart/form-data" onsubmit="return false;">
        <div class="modal-body">
          <input type="hidden" id="id_aspirante" name="id_aspirante" value="">
          <input type="hidden" id="id_bolsa" name="id_bolsa" value="">

          <div class="form-group">
            <label for="filesInput">
              <?php echo t('rec_prog_upload_select_files', 'Selecciona uno o varios archivos'); ?>
            </label>
            <input id="filesInput" name="files[]" type="file" class="form-control" multiple accept=".pdf,image/*,video/*">
            <small class="form-text text-muted">
              <?php echo t('rec_prog_upload_allowed_types', 'Tipos permitidos: PDF, imágenes y videos.'); ?>
            </small>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
              <thead class="thead-light">
                <tr>
                  <th><?php echo t('rec_prog_upload_th_file', 'Archivo'); ?></th>
                  <th><?php echo t('rec_prog_upload_th_size', 'Tamaño'); ?></th>
                  <th><?php echo t('rec_prog_upload_th_custom_name', 'Nombre personalizado'); ?></th>
                  <th style="width:1%;"><?php echo t('rec_prog_upload_th_actions', 'Acciones'); ?></th>
                </tr>
              </thead>
              <tbody id="filesTableBody">
                <tr class="text-muted" id="emptyRow">
                  <td colspan="4"><?php echo t('rec_prog_upload_empty', 'Sin archivos seleccionados…'); ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <?php echo t('rec_common_cancel', 'Cancelar'); ?>
          </button>
          <button type="button" class="btn btn-primary" id="btnSubirArchivos">
            <?php echo t('rec_prog_upload_btn_upload', 'Subir archivos'); ?>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>




<div class="modal fade" id="modalRequisiciones" tabindex="-1" role="dialog" aria-labelledby="modalRequisicionesLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalRequisicionesLabel">Solicitar Requisición</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" id="contenedorTabla">
        <p class="text-center text-muted">Cargando...</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>



<div class="modal fade" id="modalActualizarArchivos" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo t('rec_prog_docs_modal_title', 'Documentos del aspirante'); ?></h5>
        <button type="button" class="close" data-dismiss="modal">
          <span><?php echo t('rec_common_close_x', '&times;'); ?></span>
        </button>
      </div>

      <div class="modal-body">
        <!-- oculto para reutilizarlo en reemplazos -->
        <input type="hidden" id="id_aspirante">

        <table class="table table-bordered" id="tablaDocsModal">
          <thead>
            <tr>
              <th><?php echo t('rec_prog_docs_th_custom_name', 'Nombre personalizado'); ?></th>
              <th><?php echo t('rec_prog_docs_th_file', 'Archivo'); ?></th>
              <th><?php echo t('rec_prog_docs_th_date', 'Fecha'); ?></th>
              <th><?php echo t('rec_prog_docs_th_visible_branch', 'Visible para Sucursal'); ?></th>
              <th><?php echo t('rec_prog_docs_th_actions', 'Acciones'); ?></th>
            </tr>
          </thead>
          <tbody>
            <!-- filas AJAX -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalReemplazo" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo t('rec_prog_replace_modal_title', 'Reemplazar documento'); ?></h5>
      </div>

      <div class="modal-body">
        <form id="frmReemplazo" action="<?php echo base_url('Documentos_Aspirantes/actualizar') ?>"
          enctype="multipart/form-data">

          <input type="hidden" name="id_doc" id="id_doc">

          <div class="form-group">
            <label><?php echo t('rec_prog_replace_f_custom_name', 'Nombre personalizado'); ?></label>
            <input type="text" class="form-control" name="nuevo_nombre" id="nuevo_nombre">
          </div>

          <div class="form-group">
            <label><?php echo t('rec_prog_replace_f_new_file', 'Nuevo archivo'); ?></label>
            <input type="file" class="form-control-file" name="file" required>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary" id="btnGuardarCambios">
          <?php echo t('rec_prog_replace_btn_save', 'Guardar cambios'); ?>
        </button>
      </div>

    </div>
  </div>
</div>

<!-- Modal Link clientes general-->
<div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <!-- ancho -->
    <div class="modal-content">
      <div class="modal-header bg-primary text-white py-2">
        <h5 class="modal-title" id="qrModalLabel">
          <i class="fas fa-qrcode mr-2"></i> Link de QR
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="row">
          <!-- Col izquierda -->
          <div class="col-md-6 border-right">
            <h6 class="text-muted mb-2"><i class="fas fa-link mr-1"></i> Link</h6>

            <div class="d-flex align-items-center mb-3">
              <a id="qrLinkDisplay" href="#" target="_blank" class="text-truncate" style="max-width:80%;" title=""></a>
              <button type="button" class="btn btn-sm btn-outline-primary ml-2" id="btnCopiarLink" title="Copiar">
                <i class="fas fa-copy"></i>
              </button>
            </div>

          </div>

          <!-- Col derecha -->
          <div class="col-md-6 text-center">
            <h6 class="text-muted mb-2"><i class="far fa-image mr-1"></i> QR</h6>
            <div id="qrPreviewWrapper" class="mt-2"></div>
          </div>
        </div>
      </div>

      <div class="modal-footer d-flex justify-content-between">



        <button type="button" class="btn btn-outline-danger" id="btnEliminarQR">
          <i class="fas fa-trash-alt mr-1"></i> Eliminar
        </button>

        <button type="button" class="btn btn-primary" id="btnGuardarQR">
          <i class="fas fa-save mr-1"></i> Guardar / Actualizar
        </button>

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalAsignarSucursal" tabindex="-1" role="dialog"
  aria-labelledby="modalAsignarSucursalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="formAsignarSucursal" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAsignarSucursalLabel">
          <i class="fas fa-store mr-2"></i><?php echo t('rec_desk_assign_branch_title', 'Asignar a sucursal'); ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal"
          aria-label="<?php echo t('rec_common_close', 'Cerrar'); ?>">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="idReq" id="asg_idReq">

        <div class="form-group">
          <label for="asg_sucursal"><?php echo t('rec_desk_assign_branch_label', 'Sucursal'); ?></label>

          <select id="asg_sucursal" name="id_sucursal" class="form-control" style="width:100%">
            <option value=""></option> <!-- necesaria para placeholder -->
          </select>

          <small
            class="form-text text-muted"><?php echo t('rec_desk_assign_branch_help', 'Escribe para buscar…'); ?></small>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
          <?php echo t('rec_common_cancel', 'Cancelar'); ?>
        </button>

        <button type="submit" class="btn btn-primary" id="btnGuardarAsignacion">
          <span class="txt"><?php echo t('rec_common_save', 'Guardar'); ?></span>
          <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
        </button>
      </div>
    </form>
  </div>
</div>








<script>
var urltraerClientes = '<?php echo base_url('Cat_Cliente/getClientesActivos'); ?>';
var urlCargarDatosCliente = '<?php echo base_url('Cat_Cliente/getClientesPorId'); ?>';
</script>
<script>
  // Define TT solo si no existe (idempotente)
  window.TT = window.TT || function(key, fallback, repl) {
    if (typeof window.t === 'function') return window.t(key, fallback, repl);
    return (fallback || key);
  };

  // Alias opcional T (también solo si no existe)
  window.T = window.T || function(k, fb, repl) {
    return window.TT(k, fb, repl);
  };
</script>

<script>


(function() {
  var $modal = $('#modalAsignarSucursal');
  var $select = $('#asg_sucursal');

  function initSucursalSelect(preselectedId) {
    const $sel = $('#asg_sucursal');
    const $modal = $('#modalAsignarSucursal');

    if ($sel.data('select2')) $sel.select2('destroy');
    $sel.empty().append('<option value=""></option>');

    $sel.select2({
      theme: 'bootstrap4', // usa el tema BS4
      width: '100%',
      placeholder: 'Selecciona una sucursal',
      allowClear: true,
      dropdownParent: $modal, // muy importante en modales
      ajax: {
        url: '<?php echo site_url('Area/select2'); ?>',
        dataType: 'json',
        delay: 250,
        data: p => ({
          q: p.term || '',
          page: p.page || 1
        }),
        processResults: d => ({
          results: d?.results || [],
          pagination: {
            more: !!d?.more
          }
        }),
        cache: true
      }
    });

    if (preselectedId) {
      $.getJSON('<?php echo site_url('Area/get/'); ?>' + preselectedId, function(item) {
        if (item && item.id) {
          const opt = new Option(item.text, item.id, true, true);
          $sel.append(opt).trigger('change');
        }
      });
    }
  }



  // Abrir modal desde el botón “Asignar sucursal”
  $(document).on('click', '.btn-asignar-sucursal', function() {
    var idReq = $(this).data('idreq');
    var pre = $(this).data('sucursal') || '';
    $('#asg_idReq').val(idReq);
    initSucursalSelect(pre);
    $modal.modal('show');
  });

  // Guardar
  $('#formAsignarSucursal').on('submit', function(e) {
    e.preventDefault();

    var idReq = $('#asg_idReq').val();
    var idSucursal = $select.val();

    // ✅ Traducciones
    const TXT_SELECT_BRANCH_TITLE = t('rec_desk_assign_branch_warn_title', 'Selecciona una sucursal');
    const TXT_SELECT_BRANCH_TEXT = t('rec_desk_assign_branch_warn_text', 'Debes elegir una sucursal.');
    const TXT_SAVING = t('rec_common_saving', 'Guardando…');
    const TXT_ASSIGNED_TITLE = t('rec_desk_assign_branch_success_title', 'Asignado');
    const TXT_ASSIGNED_TEXT = t('rec_desk_assign_branch_success_text', 'La requisición fue asignada.');
    const TXT_ERROR_TITLE = t('rec_common_error', 'Error');
    const TXT_ASSIGN_FAILED = t('rec_desk_assign_branch_failed', 'No se pudo asignar.');
    const TXT_NETWORK_FAILED = t('rec_common_network_failed', 'Fallo de red');
    const TXT_SAVE = t('rec_common_save', 'Guardar');

    if (!idSucursal) {
      Swal.fire({
        icon: 'warning',
        title: TXT_SELECT_BRANCH_TITLE,
        text: TXT_SELECT_BRANCH_TEXT
      });
      return;
    }

    var $btn = $('#btnGuardarAsignacion');
    $btn.prop('disabled', true);
    $btn.find('.txt').text(TXT_SAVING);
    $btn.find('.spinner-border').removeClass('d-none');

    $.ajax({
      url: '<?php echo site_url('Requisicion/asignar_sucursal'); ?>',
      method: 'POST',
      dataType: 'json',
      data: {
        idReq: idReq,
        id_sucursal: idSucursal
      },
      success: function(resp) {
        if (resp && resp.ok) {
          Swal.fire({
            icon: 'success',
            title: TXT_ASSIGNED_TITLE,
            text: TXT_ASSIGNED_TEXT,
            timer: 1200,
            showConfirmButton: false
          });

          $modal.modal('hide');

          // Actualiza data-sucursal en el botón de esa tarjeta
          $('.btn-asignar-sucursal[data-idreq="' + idReq + '"]').data('sucursal', idSucursal);

          // (Opcional) pinta nombre en la tarjeta si viene
          if (resp.sucursal) {
            $('#divUsuario' + idReq).find('.asignacion-sucursal').remove();
            $('#divUsuario' + idReq).append(
              '<div class="asignacion-sucursal mt-2"><i class="fas fa-store mr-1"></i>' + resp.sucursal +
              '</div>'
            );
          }
        } else {
          Swal.fire(
            TXT_ERROR_TITLE,
            (resp && resp.msg) ? resp.msg : TXT_ASSIGN_FAILED,
            'error'
          );
        }
      },
      error: function(xhr) {
        Swal.fire(
          TXT_ERROR_TITLE,
          xhr.statusText || TXT_NETWORK_FAILED,
          'error'
        );
      },
      complete: function() {
        $btn.prop('disabled', false);
        $btn.find('.txt').text(TXT_SAVE);
        $btn.find('.spinner-border').addClass('d-none');
      }
    });
  });


  // Limpieza al cerrar
  $modal.on('hidden.bs.modal', function() {
    if ($select.data('select2')) $select.select2('destroy');
    $select.empty();
    $('#asg_idReq').val('');
  });
})();


// ====== SIN DROPZONE: multi-file input “normal” ======
$(function() {
  var selectedFiles = [];
  var $modal = $('#modalCargaArchivos');
  var $filesInput = $('#filesInput');
  var $tbody = $('#filesTableBody');
  var $btnUpload = $('#btnSubirArchivos');

  const UPLOAD_URL = "<?php echo base_url('Documentos_Aspirantes/subir'); ?>";

  // 1) Abrir modal y preparar id_aspirante
  window.mostrarFormularioCargaCV = function(id) {
    $('#id_aspirante').val(id);
    $('#id_bolsa').val(id); // si aplicas mismo id, o bórralo si no lo usas
    $modal.modal('show');
  };

  // 2) Construye la tabla de archivos seleccionados
  function bytesToSize(bytes) {
    if (bytes === 0) return '0 B';
    var k = 1024,
      sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
    var i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
  }

  function baseNameNoExt(filename) {
    var i = filename.lastIndexOf('.');
    return (i > 0) ? filename.substring(0, i) : filename;
  }

  function rebuildTable() {
    $tbody.empty();
    selectedFiles.forEach(function(file, idx) {
      var tr = document.createElement('tr');

      tr.innerHTML = `
        <td><span class="font-weight-bold">${file.name}</span></td>
        <td><small class="text-muted">${bytesToSize(file.size)}</small></td>
        <td>
          <input type="text" class="form-control"
                 name="nombres_archivos[]"
                 value="${baseNameNoExt(file.name)}"
                 placeholder="${TT('rec_prog_upload_placeholder_custom_name', 'Ejemplo: CV, Comprobante, etc.')}"
                 required>
        </td>
        <td class="text-right">
          <button type="button"
                  class="btn btn-sm btn-outline-danger btn-remove"
                  data-index="${idx}"
                  aria-label="${TT('rec_prog_upload_remove_file_aria', 'Quitar archivo')}">
            <i class="fas fa-trash-alt"></i>
          </button>
        </td>
      `;
      $tbody.append(tr);
    });
  }

  // 3) Al seleccionar archivos en el input
  $filesInput.on('change', function() {
    selectedFiles = Array.from(this.files || []);
    rebuildTable();
  });

  // 4) Eliminar un archivo de la lista (y del FileList usando DataTransfer)
  $tbody.on('click', '.btn-remove', function() {
    var idx = parseInt(this.getAttribute('data-index'), 10);
    if (isNaN(idx)) return;

    selectedFiles.splice(idx, 1);

    // reconstruir FileList con DataTransfer
    var dt = new DataTransfer();
    selectedFiles.forEach(function(f) {
      dt.items.add(f);
    });
    $filesInput[0].files = dt.files;

    rebuildTable();
  });

  // 5) Subir (AJAX + FormData)
  $btnUpload.on('click', function() {
    if (!selectedFiles.length) {
      Swal.fire({
        icon: 'info',
        title: TT('rec_prog_upload_swal_no_files_title', 'Sin archivos'),
        text: TT('rec_prog_upload_swal_no_files_text', 'Selecciona al menos un archivo.')
      });
      return;
    }

    // Validar nombres personalizados
    var nombresInputs = document.querySelectorAll('input[name="nombres_archivos[]"]');
    var nombresOk = true;
    for (var i = 0; i < nombresInputs.length; i++) {
      if (!nombresInputs[i].value.trim()) {
        nombresInputs[i].focus();
        nombresOk = false;
        break;
      }
    }
    if (!nombresOk) {
      Swal.fire({
        icon: 'warning',
        title: TT('rec_prog_upload_swal_name_required_title', 'Nombre requerido'),
        text: TT('rec_prog_upload_swal_name_required_text', 'Define un nombre personalizado para cada archivo.')
      });
      return;
    }

    var fd = new FormData();
    // Archivos
    selectedFiles.forEach(function(file) {
      fd.append('files[]', file);
    });
    // Nombres personalizados (como arreglo)
    nombresInputs.forEach(function(input) {
      fd.append('nombres_archivos[]', input.value.trim());
    });

    // Extras
    fd.append('id_aspirante', $('#id_aspirante').val() || '');
    fd.append('id_bolsa', $('#id_bolsa').val() || '');

    // Deshabilita botón durante el envío
    $btnUpload.prop('disabled', true).text(TT('rec_prog_upload_btn_uploading', 'Subiendo...'));

    $.ajax({
        url: UPLOAD_URL,
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'json'
      })
      .done(function(resp) {
        if (resp && resp.ok) {
          Swal.fire({
            icon: 'success',
            title: TT('rec_prog_upload_swal_success_title', '¡Éxito!'),
            text: resp.msg || TT('rec_prog_upload_swal_success_text_default', 'Archivos cargados.')
          });
          $modal.modal('hide');
        } else if (resp && Array.isArray(resp.data)) {
          var errores = resp.data.filter(r => !r.success).map(r => `${r.file}: ${r.error}`);
          if (errores.length) {
            Swal.fire({
              icon: 'warning',
              title: TT('rec_prog_upload_swal_partial_title', 'Carga parcial'),
              html: errores.join('<br>')
            });
          } else {
            Swal.fire({
              icon: 'success',
              title: TT('rec_prog_upload_swal_success_title', '¡Éxito!'),
              text: TT('rec_prog_upload_swal_success_all', 'Todos los archivos cargados.')
            });
            $modal.modal('hide');
          }
        } else {
          Swal.fire({
            icon: 'error',
            title: TT('rec_prog_upload_swal_error_title', 'Error'),
            text: (resp && resp.msg) ? resp.msg : TT('rec_prog_upload_swal_error_text_default', 'No se pudo completar la carga.')
          });
        }
      })
      .fail(function(xhr) {
        Swal.fire({
          icon: 'error',
          title: TT('rec_prog_upload_swal_server_error_title', 'Error de servidor'),
          text: xhr.statusText || TT('rec_prog_upload_swal_server_error_text_default', 'Intenta de nuevo.')
        });
      })
      .always(function() {
        $btnUpload.prop('disabled', false).text(TT('rec_prog_upload_btn_upload', 'Subir archivos'));
        // Limpieza
        selectedFiles = [];
        $filesInput.val('');
        $tbody.empty();
      });
  });

  // 6) Limpiar al cerrar el modal
  $modal.on('hidden.bs.modal', function() {
    selectedFiles = [];
    $filesInput.val('');
    $tbody.empty();
  });
});



$('#btnGuardarCambios').on('click', function() {

  // 1. Empaquetar todo el formulario en FormData
  const fd = new FormData(document.getElementById('frmReemplazo'));

  // 2. Enviar vía AJAX
  $.ajax({
    url: $('#frmReemplazo').attr('action'), // «documentos_aspirantes/actualizar»
    type: 'POST',
    data: fd,
    processData: false, // ← IMPORTANTE para FormData
    contentType: false,
    dataType: 'json',

    success: resp => {

      if (resp.ok) {
        Swal.fire({
          icon: 'success',
          title: TT('rec_prog_doc_ok_updated', 'Documento actualizado'),
          timer: 1500,
          showConfirmButton: false
        });

        // 2-a  Cerrar modales
        $('#modalReemplazo').modal('hide');
        $('#modalActualizarArchivos').modal('hide');

        // 2-b  Refrescar la tabla SIN recargar página
        if ($.fn.DataTable.isDataTable('#tablaDocsModal')) {
          $('#tablaDocsModal').DataTable().ajax.reload(null, false);
        }
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: resp.message
        });
      }
    },

    error: xhr => {
      // Puedes mostrar el mensaje HTTP si lo necesitas:
      // console.error(xhr.responseText);
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'La petición falló.'
      });
    }
  });

});

//////////////////////////////////////////////////////////////////////////////////
document.getElementById('accion_aspirante').addEventListener('change', function() {
  var inputOtro = document.getElementById('otra_accion');
  if (this.value === 'otro') {
    inputOtro.style.display = 'block'; // Mostrar input si selecciona "Otro"
    inputOtro.setAttribute('required', 'required'); // Hacerlo obligatorio
  } else {
    inputOtro.style.display = 'none'; // Ocultar input si elige otra opción
    inputOtro.removeAttribute('required'); // Quitar obligatoriedad
  }
});
// ===== INICIO REEMPLAZO COMPLETO =====
var pag = 1;

// Oculta secciones al cargar el script
// --- Lista única de secciones dinámicas ---
(function($) {
  // ---- Selectores de todos los bloques dinámicos ----
  const BLOQUES = [
    '.div_info_project', '.div_info_projectt', '.div_project',
    '.div_info_previo', '.div_previo',
    '.div_info_check', '.div_check',
    '.div_info_test', '.div_test',
    '.div_info_extra', '.div_extra',
    '#detalles_previo'
  ].join(', ');

  // Limpia estilos inline de display (por si quedaron display:none)
  $(BLOQUES).each(function() {
    this.style && (this.style.display = '');
  });

  // 1) Al mostrar el modal, dispara el change del combo para pintar el estado actual
  $(document)
    .off('shown.bs.modal.registro', '#registroCandidatoModal')
    .on('shown.bs.modal.registro', '#registroCandidatoModal', function() {
      const $sel = $('#opcion_registro');
      if (!$sel.length) {
        console.warn('[registro] No existe #opcion_registro');
        return;
      }
      console.log('[registro] modal shown; valor actual:', $sel.val());
      $sel.trigger('change');
    });

  // 2) Cambio de opción (delegado y namespaced)
  $(document)
    .off('change.registro', '#opcion_registro')
    .on('change.registro', '#opcion_registro', function() {
      const opcion = String(this.value);
      console.log('[registro] change opcion_registro =', opcion);

      // Oculta todo
      $(BLOQUES).addClass('d-none');

      // Nunca mostrar (siempre ocultos)
      $('.div_info_project, .div_info_projectt, .div_project, .div_info_check, .div_check, .div_info_extra, .div_extra')
        .addClass('d-none');

      if (opcion === '0') {
        // Proyecto anterior + Exámenes
        $('.div_info_previo, .div_previo, .div_info_test, .div_test, #detalles_previo')
          .removeClass('d-none')
          .each(function() {
            this.style.display = '';
          });
        console.log('[registro] mostrando: previo + test');
      } else if (opcion === '1') {
        // Solo exámenes
        $('.div_info_test, .div_test')
          .removeClass('d-none')
          .each(function() {
            this.style.display = '';
          });
        console.log('[registro] mostrando: solo test');
      } else {
        console.log('[registro] mostrando: nada extra');
      }
    });

  // 3) Al cerrar el modal: reset SOLO lo dinámico (no borra datos del aspirante)
  $(document)
    .off('hidden.bs.modal.registro', '#registroCandidatoModal')
    .on('hidden.bs.modal.registro', '#registroCandidatoModal', function() {
      $(BLOQUES).addClass('d-none');
      $("#registroCandidatoModal #msj_error").hide().empty();

      $('#detalles_previo, #div_docs_extras').empty();

      $('select.valor_dinamico').prop('disabled', true).empty();
      $('#pais_registro, #pais_previo').prop('disabled', true).val('');
      $('#proyecto_registro').prop('disabled', true).val('');

      $('#puesto_otro').val('').hide();

      $('#examen_registro').val('0');
      $('#examen_medico').val('0');
      $('#examen_psicometrico').val('0');

      // Sin selección por defecto; al reabrir, shown.bs.modal ejecuta el change
      $('#opcion_registro').val('');
      console.log('[registro] modal hidden; reseteado');
    });

  // (Opcional) Select2
  if ($.fn.select2) {
    $(document).on('hidden.bs.modal.registro', '#registroCandidatoModal', function() {
      if ($('#puesto').hasClass('select2-hidden-accessible')) {
        $('#puesto').select2('destroy');
      }
    });
  }
})(jQuery);





// (Opcional) Si usas Select2 en #puesto, destrúyelo al cerrar
if ($.fn.select2 && $('#puesto').hasClass('select2-hidden-accessible')) {
  $('#registroCandidatoModal').on('hidden.bs.modal', function() {
    $('#puesto').select2('destroy');
  });
}

// Mostrar/ocultar input "otro" de puesto
$('#puesto').off('change').on('change', function() {
  $('#puesto_otro').toggle(this.value === 'otro');
});

// Deja este bloque tal cual (no se toca)
$('#nuevaRequisicionModal').on('shown.bs.modal', function(e) {
  // Copia el texto del <label> hacia data-field (y así queda traducido)
  $('#nuevaRequisicionModal input[data-field], #nuevaRequisicionModal select[data-field], #nuevaRequisicionModal textarea[data-field]')
    .each(function() {
      var id = this.id;
      if (!id) return;

      var lbl = $('#nuevaRequisicionModal label[for="' + id + '"]').first();
      if (lbl.length) {
        var txt = (lbl.text() || '').trim();
        if (txt) this.setAttribute('data-field', txt);
      }
    });
  cargarClientesActivos(urltraerClientes);
  $("#nuevaRequisicionModal #titulo_paso").text(
    TT('rec_newreq_step_title_data', 'Datos')
  );
  $("#nuevaRequisicionModal #btnContinuar span.text").text(
    TT('rec_common_continue', 'Continuar')
  );
  $("#nuevaRequisicionModal #btnRegresar, #nuevaRequisicionModal #paso2, #nuevaRequisicionModal #paso3").prop(
    'disabled', true);
});
// ===== FIN REEMPLAZO COMPLETO =====
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
            title: <?php echo json_encode(t('rec_common_problem_title', 'Hubo un problema')); ?>,
            html: <?php echo json_encode(t('rec_common_invalid_field_html', 'El campo <b>{field}</b> no es válido')); ?>
              .replace('{field}', formulario[i].getAttribute("data-field")),

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
      $("#nuevaRequisicionModal #titulo_paso").text(
        TT('rec_newreq_step_title_vacancy', 'Información de la Vacante')
      );
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
      $("#nuevaRequisicionModal #titulo_paso").text(
        TT('rec_newreq_step_title_job', 'Información sobre el Cargo')
      );
      $("#nuevaRequisicionModal #paso3").prop('disabled', false);
      document.getElementById('barra2').classList.remove('barra_espaciadora_off');
      document.getElementById('barra2').className += ' barra_espaciadora_on';
      $("#nuevaRequisicionModal #btnContinuar span.text").text(
        TT('rec_common_finish', 'Finalizar')
      );
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
              title: TT('rec_common_saved', 'Guardado correctamente'),
              showConfirmButton: false,
              timer: 3000
            });

            if (currentPage === 'requisicion') {
              setTimeout(function() {
                location.reload();
              }, 3000);
            }
          } else {
            Swal.fire({
              icon: 'error',
              title: TT('rec_common_problem_title', 'Hubo un problema'),
              html: TT('rec_common_try_again', 'Intenta de nuevo.'),
              width: '50em',
              confirmButtonText: TT('rec_common_close', 'Cerrar')
            });
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
    $("#nuevaRequisicionModal #btnContinuar span.text").text(
      TT('rec_common_continue', 'Continuar')
    );
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
    $("#nuevaRequisicionModal #btnContinuar span.text").text(
      TT('rec_common_continue', 'Continuar')
    );
    pag--;
  }
});


$('#nuevoAspiranteModal').on('hidden.bs.modal', function(e) {
  $("#nuevoAspiranteModal #msj_error").css('display', 'none');
  $("#nuevoAspiranteModal input, #nuevoAspiranteModal select, #nuevoAspiranteModal textarea").val('');
  $("#nuevoAspiranteModal #req_asignada").val(null).trigger(
    'change'); // Usar null para reiniciar el valor en Select2
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
  $("#asignarUsuarioModal select").val(null).trigger('change'); // Reiniciar Select2
});
$('#subirCSVModal').on('hidden.bs.modal', function(e) {
  $("#subirCSVModal input").val('');
});
$('#ingresoCandidatoModal').on('hidden.bs.modal', function(e) {
  $("#ingresoCandidatoModal input, #ingresoCandidatoModal textarea").val('');
});
$(document).ready(function() {
  $('#req_estatus').select2({
    placeholder: "Selecciona",
    allowClear: true,
    width: '100%' // Asegura que el select ocupe todo el ancho del contenedor
  });
  $('#asignar_usuario').select2({
    placeholder: "Selecciona",
    allowClear: true,
    width: '100%' // Asegura que el select ocupe todo el ancho del contenedor
  });
  $('#asignar_registro').select2({
    placeholder: "Selecciona",
    allowClear: true,
    width: '100%' // Asegura que el select ocupe todo el ancho del contenedor
  });
  $('#req_asignada').select2({
    placeholder: "Selecciona",
    allowClear: true,
    width: '100%' // Asegura que el select ocupe todo el ancho del contenedor
  });
  $("#previos").change(function() {
    var previo = $(this).val();
    if (previo != 0) {
      $('.div_check').css('display', 'none');
      $('.div_info_check').css('display', 'none');
      $.ajax({
        url: '<?php echo base_url('Candidato/getDetallesProyectoPrevio2'); ?>',
        method: 'POST',
        data: {
          'id_previo': previo
        },
        success: function(res)


        {
          console.log("🚀 ~ $ ~ res:", res);
          $('#detalles_previo').empty();
          $('#detalles_previo').html(res);
          $('.nuevo_proyecto').css('display', 'none');
        }
      });

    } else {
      $('.div_check').css('display', 'flex');

      $('.div_info_check').css('display', 'block');
      $('.nuevo_proyecto').css('display', 'none');
      $('#detalles_previo').empty();
    }
  });
});

function switchLanguage(language) {
  // Hacer una solicitud AJAX para cambiar el idioma
  $.ajax({
    type: 'POST',
    url: '<?php echo site_url('language/switch'); ?>',
    data: {
      language: language
    },
    success: function(response) {
      // Después de cambiar el idioma, actualizar el contenido del modal
      // Simplemente mostrar el modal de nuevo para que se vuelva a cargar con el contenido en el nuevo idioma
      $('#registroCandidatoModal').modal('show');
    }
  });
}

function nuevoRegistro() {
  $.ajax({
    url: '<?php echo base_url('Candidato_Seccion/getHistorialProyectosByCliente'); ?>',
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

function mostrarInputOtro() {
  var select = document.getElementById("puesto");
  var inputOtro = document.getElementById("puesto_otro");

  if (select.value == "otro") {
    inputOtro.style.display = "block"; // Mostrar input
  } else {
    inputOtro.style.display = "none"; // Ocultar input
    inputOtro.value = ""; // Limpiar el input si se cambia a otra opción
  }
}

function buildFallasCSV(fallas) {
  const headers = ['fila', 'nombre', 'entidad', 'label', 'url', 'http_code', 'error'];
  const esc = v => {
    const s = String(v ?? '');
    return /[",\n]/.test(s) ? '"' + s.replace(/"/g, '""') + '"' : s;
  };
  const lines = [headers.join(',')];
  (fallas || []).forEach(f => {
    lines.push([esc(f.fila), esc(f.nombre), esc(f.entidad), esc(f.label), esc(f.url), esc(f.http_code), esc(f
      .error || '')].join(','));
  });
  return lines.join('\r\n');
}

function downloadTextFile(filename, text, mime = 'text/csv;charset=utf-8;') {
  const blob = new Blob([text], {
    type: mime
  });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = filename;
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  URL.revokeObjectURL(url);
}

// ===== Render del resultado (SweetAlert + botón CSV si hay fallas) =====
function renderResultado(resp) {
  if (!resp || resp.ok === false) {
    Swal.fire('Error', (resp && resp.msg) ? resp.msg : 'Falló la importación', 'error');
    return;
  }
  let msg = `
    <b>Bolsa insertados:</b> ${resp.bolsa_insertados}<br>
    <b>Empleados insertados:</b> ${resp.empleados_insertados}<br>
    <b>Extras empleados:</b> ${resp.empleado_extras_rows}<br>
  `;
  if (resp.errores && resp.errores.length) {
    msg += `<hr><b>Errores:</b><ul>` + resp.errores.map(e => `<li>${e}</li>`).join('') + `</ul>`;
  }

  let csvData = null;
  if (resp.fallas_descargas && resp.fallas_descargas.length) {
    msg += `<hr><b>Descargas fallidas:</b><ul>` +
      resp.fallas_descargas.map(f =>
        `<li>Fila ${f.fila} (${f.nombre}) [${f.entidad}] ${f.label}:
          <a href="${f.url}" target="_blank">${f.url}</a>
          — HTTP ${f.http_code} ${f.error ? (' - '+f.error) : ''}</li>`
      ).join('') +
      `</ul>
       <p style="margin-top:12px">
         <button type="button" id="btn-dl-csv" class="swal2-confirm swal2-styled">
           Descargar CSV de fallas
         </button>
       </p>`;
    csvData = buildFallasCSV(resp.fallas_descargas);
  }

  if (resp.fallas_csv_url) {
    msg += `<p style="margin-top:8px">
      <a class="swal2-confirm swal2-styled" href="${resp.fallas_csv_url}" target="_blank">
        Descargar CSV de fallas (servidor)
      </a></p>`;
  }

  Swal.fire({
    title: 'Importación terminada',
    html: msg,
    icon: 'success',
    width: 800,
    didOpen: () => {
      const btn = document.getElementById('btn-dl-csv');
      if (btn && csvData) {
        btn.addEventListener('click', () => {
          const ts = new Date().toISOString().slice(0, 19).replace(/[:T]/g, '-');
          downloadTextFile(`fallas_descargas_${ts}.csv`, csvData);
        });
      }
    }
  });
}

// ===== Interceptar ese único form y mandar por AJAX =====
$(function() {
  // Selecciona exactamente tu form por su action (contiene Importa_excel/importar)
  // ====================== Configuración ======================
  const THRESH_MB = 8; // umbral: si el archivo >= 8MB se usa importar_streaming
  // ===========================================================

  (function($) {
    // Fallback muy simple por si no existe renderResultado en tu proyecto
    if (typeof window.renderResultado !== 'function') {
      window.renderResultado = function(resp) {
        if (!resp || typeof resp !== 'object') {
          Swal.fire('Error', 'Respuesta no válida del servidor', 'error');
          return;
        }
        if (resp.ok) {
          const det = [
            'Bolsa insertados: ' + (resp.bolsa_insertados ?? 0),
            'Empleados insertados: ' + (resp.empleados_insertados ?? 0),
            'Extras empleados: ' + (resp.empleado_extras_rows ?? 0),
            (resp.errores && resp.errores.length ? ('Errores: ' + resp.errores.length) : ''),
            (resp.fallas_descargas && resp.fallas_descargas.length ? ('Fallas descargas: ' + resp
              .fallas_descargas.length) : '')
          ].filter(Boolean).join('<br>');
          Swal.fire({
            icon: 'success',
            title: 'Importación completa',
            html: det
          });
        } else {
          Swal.fire('Error', resp.msg || 'Importación fallida', 'error');
        }
      };
    }

    $(function() {
      // Selecciona exactamente el form por id (más seguro)
      $('#form-importar-excel').on('submit', function(e) {
        e.preventDefault();

        const form = this;
        const $form = $(form);
        const fd = new FormData(form);

        // Localiza el input file
        const $fileInput = $form.find('input[type="file"][name="archivo_excel"]');
        const file = $fileInput.length ? ($fileInput[0].files[0] || null) : null;

        if (!file) {
          Swal.fire('Falta archivo', 'Selecciona un Excel antes de importar', 'warning');
          return;
        }

        // Heurística por tamaño para decidir endpoint
        const sizeMB = file.size / (1024 * 1024);
        const useStreaming = sizeMB >= THRESH_MB;

        // Construye la URL final según el modo
        let actionUrl = $form.attr('action') || '';
        if (useStreaming && /importar(?:\/)?$/i.test(actionUrl)) {
          actionUrl = actionUrl.replace(/importar(?:\/)?$/i, 'importar_streaming');
        } else if (!useStreaming && /importar_streaming(?:\/)?$/i.test(actionUrl)) {
          actionUrl = actionUrl.replace(/importar_streaming(?:\/)?$/i, 'importar');
        }

        // Bandera para logging en backend (opcional)
        fd.append('modo_import', useStreaming ? 'streaming' : 'normal');

        // (Opcional) CSRF de CI3 si lo usas:
        // fd.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');

        $.ajax({
          url: actionUrl,
          method: 'POST',
          data: fd,
          processData: false,
          contentType: false,
          xhr: function() {
            const xhr = new window.XMLHttpRequest();
            // barra de progreso de subida
            xhr.upload.addEventListener('progress', function(evt) {
              if (evt.lengthComputable) {
                const pct = Math.round((evt.loaded / evt.total) * 100);
                Swal.update({
                  title: useStreaming ? 'Importando (streaming)...' : 'Importando...',
                  html: `Subiendo archivo: <b>${pct}%</b><br>Tamaño: ${sizeMB.toFixed(2)} MB`
                });
              }
            });
            return xhr;
          },
          beforeSend: function() {
            Swal.fire({
              title: useStreaming ? 'Importando (streaming)...' : 'Importando...',
              text: 'Por favor espera',
              allowOutsideClick: false,
              didOpen: () => Swal.showLoading()
            });
          },
          success: function(resp) {
            // Asegura objeto JSON
            if (typeof resp === 'string') {
              try {
                resp = JSON.parse(resp);
              } catch (e) {
                resp = {
                  ok: false,
                  msg: 'Respuesta no válida del servidor'
                };
              }
            }
            renderResultado(resp);
          },
          error: function(xhr) {
            let msg = 'No se pudo contactar al servidor';
            try {
              const j = JSON.parse(xhr.responseText);
              if (j && (j.msg || j.message)) msg = j.msg || j.message;
            } catch (_) {}
            Swal.fire('Error', msg, 'error');
          }
        });
      });
    });
  })(jQuery);
});
</script>

<style>
#selectStatus option.status-1 {
  background: #d6d6d6;
  color: #000;
}

#selectStatus option.status-2 {
  background: #87CEFA;
  color: #000;
}

#selectStatus option.status-3 {
  background: #FFD700;
  color: #000;
}

#selectStatus option.status-4 {
  background: #32CD32;
  color: #fff;
}

#selectStatus option.status-5 {
  background: #ff6200ff;
  color: #000;
}

/* que el select también se pinte al elegir */
#selectStatus {
  transition: background-color .15s, color .15s;
}

/* app.scss o tu hoja de estilos */
.btn-status {
  margin-left: 5px;
  background-color: #6f42c1;
  /* morado Bootstrap */
  border-color: #5a379d;
  color: #fff;
}

.btn-status:hover {
  background-color: #59359c;
  border-color: #45277a;
}
</style>
<style>
.actions {
  gap: .5rem;
}

.action-btn {
  display: inline-flex;
  align-items: center;
  min-width: 240px;
  /* mismo tamaño */
  padding: .6rem .9rem;
  border-radius: .6rem;
  font-weight: 600;
  box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
  transition: transform .12s ease, filter .12s ease;
}

.action-btn .icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 2.25rem;
  height: 2.25rem;
  margin-right: .6rem;
  border-radius: .5rem;
  background: rgba(255, 255, 255, .18);
}

.action-btn:hover {
  transform: translateY(-1px);
  filter: brightness(1.03);
}

.action-btn:disabled {
  opacity: .6;
  cursor: not-allowed;
}

/* Tonos (puedes ajustar hex a tu gusto) */
.btn-green {
  background: #10b981;
  border-color: #10b981;
  color: #fff;
}

.btn-blue {
  background: #3b82f6;
  border-color: #3b82f6;
  color: #fff;
}

.btn-purple {
  background: #6366f1;
  border-color: #6366f1;
  color: #fff;
}

/* Altura y padding tipo form-control de BS4 */
/* ----- Select2 dentro del modal de sucursal ----- */
#modalAsignarSucursal .select2-container {
  width: 100% !important;
}

/* Caja del control (como un form-control de BS4) */
#modalAsignarSucursal .select2-container--bootstrap4 .select2-selection--single,
#modalAsignarSucursal .select2-container--default .select2-selection--single {
  height: calc(2.25rem + 2px) !important;
  min-height: calc(2.25rem + 2px) !important;
  padding: .375rem .75rem !important;
  border: 1px solid #ced4da !important;
  border-radius: .25rem !important;
  background-color: #fff !important;
  display: flex !important;
  align-items: center !important;
  box-shadow: none !important;
}

/* Texto renderizado */
#modalAsignarSucursal .select2-container--bootstrap4 .select2-selection__rendered,
#modalAsignarSucursal .select2-container--default .select2-selection__rendered {
  line-height: 1.5 !important;
  padding-left: 0 !important;
}

/* Placeholder gris como BS4 */
#modalAsignarSucursal .select2-container--bootstrap4 .select2-selection__placeholder,
#modalAsignarSucursal .select2-container--default .select2-selection__placeholder {
  color: #6c757d !important;
}

/* Flecha del desplegable */
#modalAsignarSucursal .select2-container--bootstrap4 .select2-selection__arrow,
#modalAsignarSucursal .select2-container--default .select2-selection__arrow {
  height: calc(2.25rem + 2px) !important;
  right: .75rem !important;
}
</style>