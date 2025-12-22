<style>
  .btn.btn-red{
  background: rgba(245, 87, 87, 1)!important;
  color: white !important;
}
</style>
<div class="modal fade" id="newModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titulo_nuevo_modal">
          <?php echo $this->lang->line('suc_modal_title_new_client'); ?>
        </h5>
        <button type="button" class="btn btn-red" data-dismiss="modal" aria-label="<?php echo $this->lang->line('suc_close'); ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div class="alert alert-info">
          <?php echo $this->lang->line('suc_newmodal_intro'); ?>
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

        <!-- PASO 1 -->
        <form id="formPaso1">
          <div class="row">
            <div class="col-md-7">
              <label for="nombre"><?php echo $this->lang->line('suc_lbl_branch_name'); ?> *</label>
              <input
                type="text"
                class="form-control"
                data-field="<?php echo $this->lang->line('suc_field_branch_name'); ?>"
                data-required="required"
                id="nombre"
                name="nombre"
                placeholder="<?php echo $this->lang->line('suc_ph_branch_name'); ?>"
                onkeyup="this.value=this.value.toUpperCase()"
                required
              >
              <br>
            </div>

            <div class="col-md-5">
              <label for="empleados"><?php echo $this->lang->line('suc_lbl_max_employees'); ?> *</label>
              <input
                type="number"
                class="form-control"
                data-field="<?php echo $this->lang->line('suc_field_max_employees'); ?>"
                data-required="required"
                id="empleados"
                name="empleados"
                placeholder="<?php echo $this->lang->line('suc_ph_max_employees'); ?>"
                value="999"
              >
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label for="clave"><?php echo $this->lang->line('suc_lbl_key'); ?> *</label>
              <input
                type="text"
                class="form-control"
                data-field="<?php echo $this->lang->line('suc_field_key'); ?>"
                id="clave"
                name="clave"
                data-required="required"
                placeholder="<?php echo $this->lang->line('suc_ph_key'); ?>"
                maxlength="3"
                onkeyup="this.value=this.value.toUpperCase()"
                required
              >
              <br>
            </div>

            <div class="col-md-6">
              <label for="correo"><?php echo $this->lang->line('suc_lbl_email'); ?></label>
              <input
                type="text"
                class="form-control"
                data-field="<?php echo $this->lang->line('suc_field_email'); ?>"
                id="correo"
                name="correo"
                placeholder="<?php echo $this->lang->line('suc_ph_email'); ?>"
              >
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-warning" role="alert">
                <strong><?php echo $this->lang->line('suc_note_title'); ?>:</strong>
                <?php echo $this->lang->line('suc_note_recruitment'); ?>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <label for="password" id="passLabel"><?php echo $this->lang->line('suc_lbl_generate_password'); ?></label>
              <div class="input-group">
                <input
                  type="password"
                  class="form-control"
                  style="height: 50px"
                  data-field="<?php echo $this->lang->line('suc_field_password'); ?>"
                  name="password"
                  id="password"
                  readonly
                />

                <div class="input-group-append">
                  <button
                    type="button"
                    class="btn btn-outline-secondary"
                    id="togglePass"
                    aria-label="<?php echo $this->lang->line('suc_aria_show_password'); ?>"
                    aria-controls="password"
                    aria-pressed="false"
                  >
                    <span class="icon-eye">👁️</span>
                    <span class="txt-show"><?php echo $this->lang->line('suc_btn_show'); ?></span>
                    <span class="txt-hide d-none"><?php echo $this->lang->line('suc_btn_hide'); ?></span>
                  </button>

                  <button type="button" class="btn btn-primary" id="generarPass" onclick="generarPassword()">
                    <?php echo $this->lang->line('suc_btn_generate'); ?>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>

        <!-- PASO 2 -->
        <form id="formPaso2" class="hidden">
          <div class="row">
            <div class="col-md-6">
              <label for="razon_social"><?php echo $this->lang->line('suc_lbl_razon_social'); ?></label>
              <input type="text" class="form-control" id="razon_social" name="razon_social"
                     placeholder="<?php echo $this->lang->line('suc_ph_razon_social'); ?>">
              <br>
            </div>
            <div class="col-md-6">
              <label for="telefono"><?php echo $this->lang->line('suc_lbl_phone'); ?></label>
              <input type="text" class="form-control" id="telefono" name="telefono"
                     placeholder="<?php echo $this->lang->line('suc_ph_phone'); ?>">

              <input type="hidden" class="form-control" id="idCliente" name="idCliente">
              <input type="hidden" id="idDomicilios" name="idDomicilios" class="form-control">
              <input type="hidden" id="idFacturacion" name="idFacturacion" class="form-control">
              <input type="hidden" id="idGenerales" name="idGenerales" class="form-control">
              <br>
            </div>
          </div>

          <hr style="border-top: 1px solid #ccc;">

          <div class="row">
            <div class="col-md-6">
              <label for="nombre_contacto"><?php echo $this->lang->line('suc_lbl_contact_name'); ?></label>
              <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto"
                     placeholder="<?php echo $this->lang->line('suc_ph_contact_name'); ?>">
              <br>
            </div>
            <div class="col-md-6">
              <label for="apellido_contacto"><?php echo $this->lang->line('suc_lbl_contact_lastname'); ?></label>
              <input type="text" class="form-control" id="apellido_contacto" name="apellido_contacto"
                     placeholder="<?php echo $this->lang->line('suc_ph_contact_lastname'); ?>">
              <br>
            </div>
          </div>

          <hr style="border-top: 1px solid #ccc;">

          <div class="row">
            <div class="col-md-6">
              <label for="rfc"><?php echo $this->lang->line('suc_lbl_rfc'); ?></label>
              <input type="text" class="form-control" id="rfc" name="rfc"
                     placeholder="<?php echo $this->lang->line('suc_ph_rfc'); ?>">
              <br>
            </div>
            <div class="col-md-6">
              <label for="regimen"><?php echo $this->lang->line('suc_lbl_regimen'); ?></label>
              <input type="text" class="form-control" id="regimen" name="regimen"
                     placeholder="<?php echo $this->lang->line('suc_ph_regimen'); ?>">
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label for="forma_pago"><?php echo $this->lang->line('suc_lbl_forma_pago'); ?></label>
              <select class="custom-select" id="forma_pago" name="forma_pago">
                <option value="" selected><?php echo $this->lang->line('suc_select_placeholder'); ?></option>
                <option value="Pago en una sola exhibición"><?php echo $this->lang->line('suc_opt_forma_pago_single'); ?></option>
                <option value="Pago en parcialidades o diferidos"><?php echo $this->lang->line('suc_opt_forma_pago_partial'); ?></option>
              </select>
              <br>
            </div>

            <div class="col-md-6">
              <label for="metodo_pago"><?php echo $this->lang->line('suc_lbl_metodo_pago'); ?></label>
              <select class="custom-select" id="metodo_pago" name="metodo_pago">
                <option value="" selected><?php echo $this->lang->line('suc_select_placeholder'); ?></option>
                <option value="Efectivo"><?php echo $this->lang->line('suc_opt_metodo_efectivo'); ?></option>
                <option value="Cheque de nómina"><?php echo $this->lang->line('suc_opt_metodo_cheque'); ?></option>
                <option value="Transferencia electrónica"><?php echo $this->lang->line('suc_opt_metodo_transfer'); ?></option>
                <option value="Tarjeta de crédito"><?php echo $this->lang->line('suc_opt_metodo_credit'); ?></option>
                <option value="Tarjeta de débito"><?php echo $this->lang->line('suc_opt_metodo_debit'); ?></option>
                <option value="Por definir"><?php echo $this->lang->line('suc_opt_metodo_tbd'); ?></option>
              </select>
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <br>
              <label for="uso_cfdi"><?php echo $this->lang->line('suc_lbl_uso_cfdi'); ?></label>
              <input type="text" class="form-control" id="uso_cfdi" name="uso_cfdi"
                     placeholder="<?php echo $this->lang->line('suc_ph_uso_cfdi'); ?>"
                     value="Gastos Generales">
              <br>
            </div>
          </div>
        </form>

        <!-- PASO 3 -->
        <form id="formPaso3" class="hidden">
          <div class="row">
            <div class="col-md-6">
              <label for="item-details-countryValue"><?php echo $this->lang->line('suc_lbl_country'); ?></label>
              <input type="text" class="form-control" id="item-details-countryValue" name="pais_name"
                     placeholder="<?php echo $this->lang->line('suc_ph_country'); ?>">
              <br>
            </div>

            <div class="col-md-6">
              <label for="item-details-stateValue"><?php echo $this->lang->line('suc_lbl_state'); ?></label>
              <input type="text" class="form-control" id="item-details-stateValue" name="state_name"
                     placeholder="<?php echo $this->lang->line('suc_ph_state'); ?>">
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label for="item-details-cityValue"><?php echo $this->lang->line('suc_lbl_city'); ?></label>
              <input type="text" class="form-control" id="item-details-cityValue" name="ciudad_name"
                     placeholder="<?php echo $this->lang->line('suc_ph_city'); ?>">
              <br>
            </div>

            <div class="col-md-6">
              <label for="colonia"><?php echo $this->lang->line('suc_lbl_colony'); ?></label>
              <input type="text" class="form-control" id="colonia" name="colonia"
                     placeholder="<?php echo $this->lang->line('suc_ph_colony'); ?>">
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <label for="calle"><?php echo $this->lang->line('suc_lbl_street'); ?></label>
              <input type="text" class="form-control" id="calle" name="calle"
                     placeholder="<?php echo $this->lang->line('suc_ph_street'); ?>">
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3 mx-auto">
              <label for="numero_exterior"><?php echo $this->lang->line('suc_lbl_ext_number'); ?></label>
              <input type="number" class="form-control" id="numero_exterior" name="numero_exterior"
                     placeholder="<?php echo $this->lang->line('suc_ph_ext_number'); ?>">
              <br>
            </div>

            <div class="col-md-3 mx-auto">
              <label for="numero_interior"><?php echo $this->lang->line('suc_lbl_int_number'); ?></label>
              <input type="text" class="form-control" id="numero_interior" name="numero_interior"
                     placeholder="<?php echo $this->lang->line('suc_ph_int_number'); ?>">
              <br>
            </div>

            <div class="col-md-3 mx-auto">
              <label for="cp"><?php echo $this->lang->line('suc_lbl_zip'); ?></label>
              <input type="number" class="form-control" id="cp" name="numero_cp"
                     placeholder="<?php echo $this->lang->line('suc_ph_zip'); ?>">
              <br>
            </div>
          </div>

          <br>
        </form>

      </div>

      <div class="modal-footer custom_modal_footer">
        <button type="button" class="btn btn-primary btn-icon-split" id="btnRegresar">
          <span class="icon text-white-50">
            <i class="fas fa-arrow-left"></i>
          </span>
          <span class="text"><?php echo $this->lang->line('suc_btn_back'); ?></span>
        </button>

        <button type="button" class="btn btn-success btn-icon-split" id="btnContinuar">
          <span class="text"><?php echo $this->lang->line('suc_btn_continue'); ?></span>
          <span class="icon text-white-50">
            <i class="fas fa-arrow-right"></i>
          </span>
        </button>
      </div>

    </div>
  </div>
</div>

<!-- modal para mensaje -->
<div class="modal fade" id="mensajeModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="titulo_mensaje1"></h4>

        <button type="button" class="btn btn-red" data-dismiss="modal"
                aria-label="<?php echo $this->lang->line('suc_close'); ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <h4 id="mensaje"></h4>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-red" data-dismiss="modal">
          <?php echo $this->lang->line('suc_btn_cancel'); ?>
        </button>
        <button type="button" class="btn btn-success" id="btnConfirmar">
          <?php echo $this->lang->line('suc_btn_confirm'); ?>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- modal para mostrar accesos de los clientes -->
<div class="modal fade" id="accesosClienteModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">
          <?php echo $this->lang->line('suc_access_modal_branch_label'); ?>: <span class="nombreCliente"></span>
        </h4>

        <button type="button" class="btn btn-red" data-dismiss="modal"
                aria-label="<?php echo $this->lang->line('suc_close'); ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div id="div_accesos"></div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-red" data-dismiss="modal">
          <?php echo $this->lang->line('suc_close'); ?>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- modal para mostrar accesos de los clientes -->
<div class="modal fade" id="modalGenerarUsuarioCliente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          <?php echo $this->lang->line('suc_guc_title'); ?>
          <span id="gucNombreCliente" class="font-weight-bold"></span>
        </h5>
        <button type="button" class="btn btn-red" data-dismiss="modal"
                aria-label="<?php echo $this->lang->line('suc_close'); ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="formGenerarUsuarioCliente" autocomplete="off">
        <div class="modal-body">

          <input type="hidden" name="idCliente" id="gucIdCliente">

          <div class="form-row">
            <div class="form-group col-md-6">
              <label><?php echo $this->lang->line('suc_guc_lbl_name'); ?></label>
              <input type="text" class="form-control" name="nombre" id="gucNombre" required>
            </div>

            <div class="form-group col-md-6">
              <label><?php echo $this->lang->line('suc_guc_lbl_lastname'); ?></label>
              <input type="text" class="form-control" name="paterno" id="gucPaterno" required>
            </div>
          </div>

          <div class="form-group">
            <label><?php echo $this->lang->line('suc_guc_lbl_email'); ?></label>
            <input type="email" class="form-control" name="correo" id="gucCorreo" required>
            <small class="text-muted"><?php echo $this->lang->line('suc_guc_email_help'); ?></small>
          </div>

          <div class="form-group">
            <label><?php echo $this->lang->line('suc_guc_lbl_phone'); ?></label>
            <input type="text" class="form-control" name="telefono" id="gucTelefono"
                   placeholder="<?php echo $this->lang->line('suc_guc_ph_phone'); ?>">
          </div>

          <!-- Password -->
          <div class="form-group">
            <label><?php echo $this->lang->line('suc_guc_lbl_password'); ?></label>
            <div class="input-group">
              <input type="password" class="form-control" name="password" id="gucPassword"
                     required minlength="9"
                     placeholder="<?php echo $this->lang->line('suc_guc_ph_password'); ?>">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="btnTogglePass1"
                        title="<?php echo $this->lang->line('suc_guc_tt_toggle'); ?>">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <small id="gucPassHelp" class="form-text text-muted">
              <?php echo $this->lang->line('suc_guc_pass_help'); ?>
            </small>
            <div class="invalid-feedback" id="gucPassError">
              <?php echo $this->lang->line('suc_guc_pass_invalid'); ?>
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="form-group">
            <label><?php echo $this->lang->line('suc_guc_lbl_password_confirm'); ?></label>
            <div class="input-group">
              <input type="password" class="form-control" name="password_confirm" id="gucPasswordConfirm" required>
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="btnTogglePass2"
                        title="<?php echo $this->lang->line('suc_guc_tt_toggle'); ?>">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
            </div>
            <div class="invalid-feedback" id="gucConfirmError">
              <?php echo $this->lang->line('suc_guc_pass_mismatch'); ?>
            </div>
          </div>

          <div class="alert alert-info py-2 mb-0">
            <?php echo $this->lang->line('suc_guc_info'); ?>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-red" data-dismiss="modal">
            <?php echo $this->lang->line('suc_btn_cancel'); ?>
          </button>
          <button type="submit" class="btn btn-success" id="btnGucGuardar">
            <i class="fas fa-user-plus mr-1"></i> <?php echo $this->lang->line('suc_guc_btn_submit'); ?>
          </button>
        </div>
      </form>

    </div>
  </div>
</div>


<!-- modal para registrar un nuevo acceso para un cliente -->
<!-- modal para registrar un nuevo acceso para un cliente -->
<div class="modal fade" id="nuevoAccesoClienteModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          <?php echo $this->lang->line('suc_access_create_title'); ?>
        </h5>
        <button type="button" class="btn btn-red" data-dismiss="modal"
                aria-label="<?php echo $this->lang->line('suc_close'); ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form id="formAccesoCliente">
          <div class="row">
            <div class="col-md-12">
              <label for="id_cliente"><?php echo $this->lang->line('suc_access_lbl_branch'); ?> *</label>
              <select name="cliente" id="id_cliente" class="form-control"></select>
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 mx-auto">
              <label for="nombre_cliente"><?php echo $this->lang->line('suc_access_lbl_name'); ?> *</label>
              <input type="text" class="form-control" name="nombre" id="nombre_cliente"
                     onKeyUp="this.value=this.value.toUpperCase()">
              <br>
            </div>

            <div class="col-md-4 mx-auto">
              <label for="paterno_cliente"><?php echo $this->lang->line('suc_access_lbl_lastname'); ?> *</label>
              <input type="text" class="form-control" name="paterno" id="paterno_cliente"
                     onKeyUp="this.value=this.value.toUpperCase()">
              <br>
            </div>

            <div class="col-md-4 mx-auto">
              <div class="custom-control custom-switch">
                <br>
                <input type="checkbox" class="custom-control-input" id="tipoUsuarioSwitch" name="tipo_usuario">
                <label class="custom-control-label" for="tipoUsuarioSwitch">
                  <?php echo $this->lang->line('suc_access_lbl_spectator'); ?>
                </label>
              </div>
              <input type="hidden" name="tipo_usuario" id="hiddenTipoUsuario" value="null">
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <label for="privacidad"><?php echo $this->lang->line('suc_access_lbl_privacy'); ?> *</label>
              <select class="form-control" id="privacidad" name="privacidad">
                <option value="0"><?php echo $this->lang->line('suc_access_privacy_0'); ?></option>
                <option value="1"><?php echo $this->lang->line('suc_access_privacy_1'); ?></option>
                <option value="2"><?php echo $this->lang->line('suc_access_privacy_2'); ?></option>
                <option value="3"><?php echo $this->lang->line('suc_access_privacy_3'); ?></option>
                <option value="4"><?php echo $this->lang->line('suc_access_privacy_4'); ?></option>
                <option value="5"><?php echo $this->lang->line('suc_access_privacy_5'); ?></option>
                <option value="6"><?php echo $this->lang->line('suc_access_privacy_6'); ?></option>
                <option value="7"><?php echo $this->lang->line('suc_access_privacy_7'); ?></option>
                <option value="8"><?php echo $this->lang->line('suc_access_privacy_8'); ?></option>
                <option value="9"><?php echo $this->lang->line('suc_access_privacy_9'); ?></option>
                <option value="10"><?php echo $this->lang->line('suc_access_privacy_10'); ?></option>
              </select>
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <label for="correo_cliente"><?php echo $this->lang->line('suc_access_lbl_email'); ?> *</label>
              <input type="text" class="form-control" name="correo_cliente_name" id="correo_cliente">
            </div>

            <div class="col-md-6">
              <label for="number"><?php echo $this->lang->line('suc_access_lbl_phone'); ?></label>
              <input type="text" class="form-control" name="telefono" id="telefono" maxlength="12">
              <br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <label for="password_us"><?php echo $this->lang->line('suc_lbl_generate_password'); ?> *</label>
              <div class="input-group">
                <input type="password" class="form-control" data-field="<?php echo $this->lang->line('suc_field_password'); ?>"
                       name="password_us" id="password_us" data-required="required" readonly required>
                <div class="input-group-append">
                  <button type="button" class="btn btn-primary" onclick="generarPassword_us()">
                    <?php echo $this->lang->line('suc_btn_generate'); ?>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>

        <div class="row">
          <div class="col-md-12">
            <p><?php echo $this->lang->line('suc_access_password_note'); ?></p>
          </div>
        </div>

        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-red" data-dismiss="modal">
          <?php echo $this->lang->line('suc_close'); ?>
        </button>
        <button type="button" class="btn btn-success" onclick="crearAccesoClientes()">
          <?php echo $this->lang->line('suc_btn_save'); ?>
        </button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="modalLinkRequisicion" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header py-2">
        <h5 class="modal-title"><?php echo $this->lang->line('suc_links_modal_title'); ?></h5>
        <button type="button" class="btn btn-red" data-dismiss="modal"
                aria-label="<?php echo $this->lang->line('suc_close'); ?>">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="mb-2"><strong><?php echo $this->lang->line('suc_links_generated_label'); ?></strong></div>
        <div id="linksContainer" class="mb-3">
          <em><?php echo $this->lang->line('suc_loading'); ?></em>
        </div>
      </div>

      <input type="hidden" id="idClienteForLink">

      <div class="modal-footer py-2">
        <button type="button" class="btn btn-outline-primary" id="btnGenerarLinkReq">
          <?php echo $this->lang->line('suc_links_btn_generate_update'); ?>
        </button>
        <button type="button" class="btn btn-red" data-dismiss="modal">
          <?php echo $this->lang->line('suc_close'); ?>
        </button>
      </div>

    </div>
  </div>
</div>



<!-- modal para bloquear al cliente -->
<!-- modal para bloquear al cliente -->
<div class="modal fade" id="bloquearClienteModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="titulo_bloqueo_modal"></h4>
        <button type="button" class="btn btn-red" data-dismiss="modal"
                aria-label="<?php echo $this->lang->line('suc_close'); ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <h4 id="mensaje_bloqueo_modal"></h4>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <?php echo $this->lang->line('suc_btn_cancel'); ?>
        </button>
        <button type="button" class="btn btn-success" id="btnConfirmarBloqueo">
          <?php echo $this->lang->line('suc_btn_confirm'); ?>
        </button>
      </div>

    </div>
  </div>
</div>


<input type="hidden" id="base_url" value="<?php echo base_url('Cat_Cliente/setCliente'); ?>">

<script>
window.LANG = <?php echo json_encode($this->lang->language, JSON_UNESCAPED_UNICODE); ?>;

window.t = function(key, fallback){
  if (window.LANG && window.LANG[key] !== undefined && window.LANG[key] !== '') return window.LANG[key];
  return (fallback !== undefined) ? fallback : key;
};
</script>
<script src="<?php echo base_url() ?>js/apis/registrarClientes.js"></script>
<script>
  (function () {
    const input = document.getElementById('password');
    const btn   = document.getElementById('togglePass');
    const txtShow = btn.querySelector('.txt-show');
    const txtHide = btn.querySelector('.txt-hide');

    // (opcional) al enfocar, selecciona todo para copiar rápido
    input.addEventListener('focus', () => input.select());

    btn.addEventListener('click', function () {
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';

      // accesibilidad y texto del botón
      this.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
      this.setAttribute('aria-label', isHidden ? 'Ocultar contraseña' : 'Mostrar contraseña');

      txtShow.classList.toggle('d-none', isHidden);    // ocultar “Mostrar” si se muestra
      txtHide.classList.toggle('d-none', !isHidden);   // mostrar “Ocultar” si se muestra
    });
  })();
  function tsPasswordValida(pass) {
    if (!pass || pass.length < 9) return false;
    var hasUpper = /[A-Z]/.test(pass);
    var hasLower = /[a-z]/.test(pass);
    var hasNum   = /[0-9]/.test(pass);
    var hasSym   = /[^A-Za-z0-9]/.test(pass);
    return hasUpper && hasLower && hasNum && hasSym;
  }

  function tsSetInvalid($input, isInvalid, $feedback) {
    if (isInvalid) {
      $input.addClass('is-invalid');
      if ($feedback) $feedback.show();
    } else {
      $input.removeClass('is-invalid');
      if ($feedback) $feedback.hide();
    }
  }

  function tsValidarPasswords() {
    var pass  = $('#gucPassword').val();
    var pass2 = $('#gucPasswordConfirm').val();

    var okPass = tsPasswordValida(pass);
    tsSetInvalid($('#gucPassword'), !okPass, $('#gucPassError'));

    var okMatch = (pass2.length > 0) ? (pass === pass2) : true;
    tsSetInvalid($('#gucPasswordConfirm'), !okMatch, $('#gucConfirmError'));

    $('#btnGucGuardar').prop('disabled', !(okPass && okMatch));
    return okPass && okMatch;
  }

  function tsTogglePassword(inputId, btnId) {
    var $inp = $(inputId);
    var $btn = $(btnId);
    var $icon = $btn.find('i');

    var type = $inp.attr('type') === 'password' ? 'text' : 'password';
    $inp.attr('type', type);
    $icon.toggleClass('fa-eye fa-eye-slash');

    // ✅ tooltip traducible
    var tt = window.TS_I18N?.guc_tt_toggle || 'Ver/ocultar';
    $btn.attr('title', tt);
  }

  $(document).on('click', '#btnTogglePass1', function(){ tsTogglePassword('#gucPassword', '#btnTogglePass1'); });
  $(document).on('click', '#btnTogglePass2', function(){ tsTogglePassword('#gucPasswordConfirm', '#btnTogglePass2'); });

  $(document).on('input', '#gucPassword, #gucPasswordConfirm', function(){
    tsValidarPasswords();
  });

  $('#modalGenerarUsuarioCliente').on('shown.bs.modal', function(){
    $('#gucPassword, #gucPasswordConfirm').val('').removeClass('is-invalid');
    $('#gucPassError, #gucConfirmError').hide();
    $('#btnGucGuardar').prop('disabled', true);
  });

  $('#formGenerarUsuarioCliente').on('submit', function(e){
    if (!tsValidarPasswords()) {
      e.preventDefault();
      return false;
    }
  });
</script>
