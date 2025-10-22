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
        <h4 class="modal-title">Datos del aspirante</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAspirante">
          <div class="col-sm-12 ">

            <label for="buscador">Selecciona una Requisición :</label>
            <select name="req_asignada" id="req_asignada">

              <?php
                  if ($reqs) {
                  foreach ($reqs as $req) {?>

              <option value="<?php echo $req->idReq; ?>">
                <?php echo '# ' . $req->idReq . ' ' . $req->nombre_cliente . ' - ' . $req->puesto . ' - Vacantes: ' . $req->numero_vacantes; ?>
              </option>
              <?php }
              } else {?>
              <option value="">Sin requisiones registradas</option>
              <?php }?>
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
              <select name="medio" id="medio" class="form-control obligado w-100">
                <option value="">Selecciona</option>
                <?php if ($medios != null): ?>
                <?php foreach ($medios as $m): ?>
                <option value="<?php echo $m->nombre; ?>"><?php echo $m->nombre; ?></option>
                <?php endforeach; ?>
                <?php endif; ?>
                <option value="0">N/A</option>
              </select>
            </div>
            <div class="col-sm-12 col-md-4">
              <label>Teléfono *</label>
              <input type="text" id="telefono1" name="telefono1" class="form-control">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-12 col-md-4">
              <label>Correo*</label>
              <input type="mail" id="correo1" name="correo1" class="form-control">
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



<div class="modal fade" id="nuevaAccionModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title-modal-key-title-blanco">Registro de acción al aspirante: <span
            class="nombreAspirante"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-success text-start" role="alert" style="text-align: left;">
          ✅ <strong>NOTA:</strong> En esta sección podrás registrar las acciones que se van tomando en el proceso de
          reclutamiento en base a este Aspirante.
        </div>
        <form id="formAccion">
          <div class="row">
            <div class="col-12">
              <label>Acción a aplicar *</label>
              <select name="accion_aspirante" id="accion_aspirante" class="form-control obligado">
                <option value="">Selecciona</option>
                <option value="otro">Otro</option>
                <?php if ($acciones != null) {
                    foreach ($acciones as $a) {?>
                <option value="<?php echo $a->id . ':' . $a->descripcion; ?>"><?php echo $a->descripcion; ?></option>
                <?php }
                }?>
                <!-- Opción para escribir otra acción -->
              </select>
              <br>

              <!-- Input oculto para la acción personalizada -->
              <input type="text" name="otra_accion" id="otra_accion" class="form-control mt-2"
                placeholder="Escribe la acción" style="display: none;">
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label>Comentario / Descripción / Fecha y lugar *</label>
              <textarea class="form-control" id="accion_comentario" name="accion_comentario" rows="4"></textarea>
              <br>
            </div>
          </div>
          <div class="alert alert-warning text-start" role="alert" style="text-align: left;">
            ⚠️ <strong>NOTA:</strong> Si la acción a registrar influye en el estatus o color del aspirante en bolsa de
            trabajo, o en el proceso, no olvides modificar los siguientes campos:
            <ul>
              <ul>
                <li><strong>Estatus del Aspirante</strong>: Este cambia el color y estatus del aspirante en bolsa de
                  trabajo.
                </li>
                <li><strong>Estatus del Proceso</strong>: Este cambia el estatus actual del proceso de reclutamiento.
                </li>
              </ul>
          </div>

          <div class="row">
            <!-- Primer Select -->


            <!-- Segundo Select -->
            <div class="col-md-6">
              <label for="estatus_aspirante" data-toggle="tooltip" data-placement="top"
                title="El cambio realizado impactará directamente en la Bolsa de Trabajo, actualizando tanto el color como el estatus del aspirante">
                Estatus del aspirante
                <i class="fas fa-info-circle text-primary"></i>
              </label>
              <select class="form-control" id="estatus_aspirante" name="estatus_aspirante">
                <option value="">Selecciona</option>
                <option value="1" data-color="#6c757d">⚪ En espera</option>
                <option value="3" data-color="#ffc107">🟡 Precaucion</option>
                <option value="2" data-color="#17a2b8">🔵 En proceso de reclutamiento</option>
                <option value="4" data-color="#28a745">🟢 Listo para iniciar el proceso de preempleo</option>
                <option value="0" data-color="#dc3545">🔴 Bloquear aspirante</option>
              </select>
            </div>
            <!-- Tercer Select -->
            <div class="col-md-6">
              <label for="select3" data-toggle="tooltip" data-placement="top"
                title="Esta opción se registra en este módulo 'En proceso' y se refleja en la columna 'Estatus Actual'">
                Estatus proceso
                <i class="fas fa-info-circle text-primary"></i>
              </label>
              <select class="form-control" id="estatus_proceso" name="estatus_proceso">
                <option value="">Selecciona</option>
                <option value="1">Completado</option>
                <option value="3">Cancelado</option>
                <option value="2">Eliminar Estatus Final</option>
              </select>
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
          <span>&times;</span>
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
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form id="formEstatusReq">
          <div class="row">
            <div class="col-12">
              <label>Requisición *</label>
              <select name="req_estatus" id="req_estatus">
                <option value="">Selecciona</option>
                <?php

                    if ($reqs) {
                    foreach ($reqs as $req) {?>
                <option value="<?php echo $req->idReq; ?>">
                  <?php echo '# ' . $req->idReq . ' ' . $req->nombre_cliente . ' - ' . $req->puesto . ' - Vacantes: ' . $req->numero_vacantes; ?>
                </option>
                <?php }
                }?>
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
              <option value="<?php echo $req->idReq; ?>">
                <?php echo '# ' . $req->idReq . ' ' . $req->nombre_cliente . ' - ' . $req->puesto . ' - Vacantes: ' . $req->numero_vacantes; ?>
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
        <h4 class="modal-title">Registro de candidatos</h4>

        <!-- div id="language-switch">
          <label for="language-select">Language:</label>
          <select id="language-select" onchange="switchLanguage(this.value);">
            <option value="english">English</option>
            <option value="spanish">Español</option>
          </select>
        </div -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>

      </div>

      <div class="modal-body">
        <div class="alert alert-info text-center">Datos generales</div>
        <form id="nuevoRegistroForm">
          <div class="row">
            <div class="col-4">
              <label>Nombre (s) *</label>
              <input type="text" class="form-control obligado" name="nombre_registro" id="nombre_registro"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-4">
              <label>Paterno*</label>
              <input type="text" class="form-control obligado" name="paterno_registro" id="paterno_registro"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
            <div class="col-4">
              <label>Materno</label>
              <input type="text" class="form-control" name="materno_registro" id="materno_registro"
                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <label>Subcliente</label>
              <select name="subcliente" id="subcliente" class="form-control obligado">
                <option value="0">N/A</option>
              </select>
              <br>
            </div>



            <div class="col-4">
              <label>Posición*</label>
              <select name="puesto" id="puesto" class="form-control" onchange="mostrarInputOtro()">
                <option value="0" selected>N/A</option>
                <option value="otro">Otro</option>
              </select>

              <br>

              <!-- Input oculto que se muestra cuando seleccionan "Otro" -->
              <input type="text" name="puesto_otro" id="puesto_otro" class="form-control"
                placeholder="Especificar posición" style="display: none;">
            </div>



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
              <label>País de residencia *</label>
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
              <label>Correo* </label>
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
              <label>Número de Seguro Social (SSN)</label>
              <input type="text" class="form-control obligado" name="nss_registro" id="nss_registro" maxlength="11">
              <input type="hidden" class="form-control obligado" name="id_cliente_hidden" id="id_cliente_hidden"
                maxlength="11">
              <input type="hidden" class="form-control obligado" name="clave" id="clave" maxlength="11">
              <input type="hidden" class="form-control obligado" name="cliente" id="cliente" maxlength="11">
              <input type="hidden" class="form-control obligado" name="idAspiranteReq" id="idAspiranteReq"
                maxlength="11">
            </div>
          </div>
          <br><br>
          <!-- /TODO: regresar  cuando se permita crear proyectos -->
          <!--div class="alert alert-warning text-center">Choose a previous project or create another one. <br>Notes: <br>
            <ul class="text-left">
              <li>If you select a previous project, this will have a higher priority for your new register.</li>
              <li>The complementary tests are optional.</li>
            </ul>
          </div -->
          <div class="alert alert-info text-center">
            Seleccione una de las siguientes opciones:
          </div>
          <div class="row">
            <div class="col-12">
              <select name="opcion_registro" id="opcion_registro" class="form-control registro_obligado">
                <option value="2" selected>Registrar mi propio proceso - Gratis</option>
                <option value="0">Seleccionar un proyecto anterior o crear uno nuevo / Enviado a RODI</option>
                <option value="1">Registrar al candidato solo con Prueba de Drogas y/o Examen Médico / Enviado a RODI
                </option>
              </select>

              <br>
            </div>
          </div>
          <div class="alert alert-info text-center div_info_previo">Seleccionar un Proyecto Anterior</div>

          <div class="row div_previo">
            <div class="alert alert-warning text-center">
              Al enviar a RODI se genera un costo. Si no estás seguro de los costos, ponte en contacto con <a
                href="mailto:bramirez@rodicontrol.com">bramirez@rodicontrol.com</a>.
            </div>
            <div class="col-md-12">
              <label>Previous projects</label>
              <select class="form-control" name="previos" id="previos"></select><br>

            </div>
            <!-- /TODO: verificar    si se usa  este campo -->
            <!-- div class="col-md-3">
              <label>Country</label>
              <select class="form-control" name="pais_previo" id="pais_previo" disabled></select><br>
            </div -->
          </div>
          <div id="detalles_previo"></div>
          <div class="nuevo_proyecto">

            <div class="row div_project">
              <div class="alert alert-info text-center div_info_projectt">Select a New Project</div>
              <div class="col-md-4">
                <label>Location *</label>
                <select name="region" id="region" class="form-control registro_obligado">
                  <option value="">Select</option>
                  <option value="Mxico">Mexico</option>
                  <option value="International">International</option>
                </select>
                <br>
              </div>
              <div class="col-md-4">
                <label>Country</label>
                <select name="pais_registro" id="pais_registro" class="form-control registro_obligado" disabled>
                  <option value="">Select</option>
                  <?php foreach ($paises_estudio as $pe) {?>
                  <option value="<?php echo $pe->nombre_espanol; ?>"><?php echo $pe->nombre_ingles; ?></option>
                  <?php }?>
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
                  documents
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
                <select name="curp_check_registro" id="curp_check_registro"
                  class="form-control valor_dinamico registro_obligado" disabled></select>
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
          </div>
          <div class="alert alert-danger text-center div_info_test">Complementary Tests</div>

          <div class="row div_test">
            <div class="alert alert-warning text-center">
              Al enviar a RODI se genera un costo. Si no estás seguro de los costos, ponte en contacto con <a
                href="mailto:bramirez@rodicontrol.com">bramirez@rodicontrol.com</a>.
            </div>
            <div class="col-md-4">
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
              <select name="examen_psicometrico" id="examen_psicometrico" class="form-control registro_obligado">
                <option value="0">N/A</option>
                <option value="1">Apply</option>
              </select>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <!-- ESTA;OS AQUI -->

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="registrarCandidato()">Guardar</button>
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
          <span>&times;</span>
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
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAsignacion">
          <div class="row mb-3">
            <div class="col-md-12">
              <label for="asignar_usuario"></label>
              <select id="asignar_usuario" name="asignar_usuario" class="form-control">
                <option value="">Select</option>
                <?php
                    if (! empty($usuarios_asignacion)) {
                    foreach ($usuarios_asignacion as $row) {?>
                <option value="<?php echo $row->id ?>"><?php echo $row->usuario ?></option>
                <?php }
                } else {?>
                <option value="">No hay usuarios correspondientes</option>
                <?php }?>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <label for="asignar_registro"></label>
              <select name="asignar_registro" id="asignar_registro">
                <option value="">Select</option>
                <?php
                    if (! empty($registros_asignacion)) {
                    foreach ($registros_asignacion as $fila) {?>
                <option value="<?php echo $fila->id ?>">
                  <?php echo '#' . $fila->id . '  ' . $fila->nombreCompleto . (! empty($fila->puesto) ? ' Puesto: ' . $fila->puesto : ''); ?>
                </option>
                <?php }
                } else {?>
                <option value="">No hay registros para asignar</option>
                <?php }?>
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
        <h4 class="modal-title">Información de ingreso al empleo del candidato: <br><span class="nombreRegistro"></span>
        </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnConfirmar">Confirmar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal para cargar CV -->
<div class="modal fade" id="modalCargaArchivos" tabindex="-1" role="dialog" aria-labelledby="modalCargaArchivosLabel">
  <div class="modal-dialog" role="document" style="max-width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCargaArchivosLabel">Carga y nombra tus archivos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span>&times;</span>
        </button>
      </div>

      <form id="formCargaArchivos" enctype="multipart/form-data" onsubmit="return false;">
        <div class="modal-body">
          <input type="hidden" id="id_aspirante" name="id_aspirante" value="">
          <input type="hidden" id="id_bolsa" name="id_bolsa" value="">

          <div class="form-group">
            <label for="filesInput">Selecciona uno o varios archivos</label>
            <input id="filesInput" name="files[]" type="file" class="form-control" multiple
              accept=".pdf,image/*,video/*">
            <small class="form-text text-muted">Tipos permitidos: PDF, imágenes y videos.</small>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
              <thead class="thead-light">
                <tr>
                  <th>Archivo</th>
                  <th>Tamaño</th>
                  <th>Nombre personalizado</th>
                  <th style="width:1%;">Acciones</th>
                </tr>
              </thead>
              <tbody id="filesTableBody">
                <tr class="text-muted" id="emptyRow">
                  <td colspan="4">Sin archivos seleccionados…</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btnSubirArchivos">Subir archivos</button>
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
        <h5 class="modal-title">Documentos del aspirante</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">
        <!-- oculto para reutilizarlo en reemplazos -->
        <input type="hidden" id="id_aspirante">

        <table class="table table-bordered" id="tablaDocsModal">
          <thead>
            <tr>
              <th>Nombre personalizado</th>
              <th>Archivo</th>
              <th>Fecha</th>
              <th>Visible para Sucursal</th>
              <th>Acciones</th>
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
        <h5 class="modal-title">Reemplazar documento</h5>
      </div>
      <div class="modal-body">
        <form id="frmReemplazo" action="<?php echo base_url('Documentos_Aspirantes/actualizar') ?>"
          enctype="multipart/form-data">
          <input type="hidden" name="id_doc" id="id_doc">
          <div class="form-group">
            <label>Nombre personalizado</label>
            <input type="text" class="form-control" name="nuevo_nombre" id="nuevo_nombre">
          </div>
          <div class="form-group">
            <label>Nuevo archivo</label>
            <input type="file" class="form-control-file" name="file" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" id="btnGuardarCambios">Guardar cambios</button>
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
          <i class="fas fa-store mr-2"></i>Asignar a sucursal
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idReq" id="asg_idReq">
        <div class="form-group">
          <label for="asg_sucursal">Sucursal</label>
          <select id="asg_sucursal" name="id_sucursal" class="form-control" style="width:100%">
            <option value=""></option> <!-- ← NECESARIA para que se vea el placeholder -->
          </select>
          <small class="form-text text-muted">Escribe para buscar…</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary" id="btnGuardarAsignacion">
          <span class="txt">Guardar</span>
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

    if (!idSucursal) {
      Swal.fire({
        icon: 'warning',
        title: 'Selecciona una sucursal',
        text: 'Debes elegir una sucursal.'
      });
      return;
    }

    var $btn = $('#btnGuardarAsignacion');
    $btn.prop('disabled', true);
    $btn.find('.txt').text('Guardando…');
    $btn.find('.spinner-border').removeClass('d-none');

    $.ajax({
      url: '<?php echo site_url('Requisicion/asignar_sucursal'); ?>', // también sin routes extra
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
            title: 'Asignado',
            text: 'La requisición fue asignada.',
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
          Swal.fire('Error', (resp && resp.msg) ? resp.msg : 'No se pudo asignar.', 'error');
        }
      },
      error: function(xhr) {
        Swal.fire('Error', xhr.statusText || 'Fallo de red', 'error');
      },
      complete: function() {
        $btn.prop('disabled', false);
        $btn.find('.txt').text('Guardar');
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

  // Si tu vista es PHP, usa una de estas (elige la que corresponda):
  // const UPLOAD_URL = "< ?php echo base_url('Documentos_Aspirantes/subir')?>";
  const UPLOAD_URL = "<?php echo base_url('Documentos_Aspirantes/subir'); ?>";

  // 1) Abrir modal y preparar id_aspirante
  window.mostrarFormularioCargaCV = function(id) {
    //console.log('mostrarFormularioCargaCV id:', id);
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
                 placeholder="Ejemplo: CV, Comprobante, etc."
                 required>
        </td>
        <td class="text-right">
          <button type="button"
                  class="btn btn-sm btn-outline-danger btn-remove"
                  data-index="${idx}">
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
        title: 'Sin archivos',
        text: 'Selecciona al menos un archivo.'
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
        title: 'Nombre requerido',
        text: 'Define un nombre personalizado para cada archivo.'
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

    // Extras que ya mandabas
    fd.append('id_aspirante', $('#id_aspirante').val() || '');
    fd.append('id_bolsa', $('#id_bolsa').val() || '');

    // Deshabilita botón durante el envío
    $btnUpload.prop('disabled', true).text('Subiendo...');

    $.ajax({
        url: UPLOAD_URL,
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'json'
      })
      .done(function(resp) {
        // Soporta dos variantes comunes de respuesta
        if (resp && resp.ok) {
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: resp.msg || 'Archivos cargados.'
          });
          $modal.modal('hide');
        } else if (resp && Array.isArray(resp.data)) {
          // estilo por-archivo: [{success, file, error}]
          var errores = resp.data.filter(r => !r.success).map(r => `${r.file}: ${r.error}`);
          if (errores.length) {
            Swal.fire({
              icon: 'warning',
              title: 'Carga parcial',
              html: errores.join('<br>')
            });
          } else {
            Swal.fire({
              icon: 'success',
              title: '¡Éxito!',
              text: 'Todos los archivos cargados.'
            });
            $modal.modal('hide');
          }
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: (resp && resp.msg) ? resp.msg : 'No se pudo completar la carga.'
          });
        }
      })
      .fail(function(xhr) {
        Swal.fire({
          icon: 'error',
          title: 'Error de servidor',
          text: xhr.statusText || 'Intenta de nuevo.'
        });
      })
      .always(function() {
        $btnUpload.prop('disabled', false).text('Subir archivos');
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
})



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
          title: 'Documento actualizado',
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
  cargarClientesActivos(urltraerClientes);
  $("#nuevaRequisicionModal #titulo_paso").text('Datos  ');
  $("#nuevaRequisicionModal #btnContinuar span.text").text('Continuar');
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