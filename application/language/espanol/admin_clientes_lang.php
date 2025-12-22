<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['suc_title'] = 'Administración de Sucursales/Clientes';

$lang['suc_btn_links_all']   = 'Crear/Actualizar Links';
$lang['suc_btn_create_branch']= 'Crear Sucursal';

$lang['suc_description'] =
'Este módulo permite la gestión completa de usuarios externos y sucursales, con funciones para registrar, actualizar, eliminar y mantener la información de manera organizada y eficiente.';

/* Modal enviar credenciales */
$lang['suc_modal_send_credentials_title'] = 'Registrar';
$lang['suc_lbl_generate_password']        = 'Generar Contraseña*';
$lang['suc_btn_generate']                = 'Generar';
$lang['suc_btn_cancel']                  = 'Cancelar';
$lang['suc_btn_resend_password']          = 'Reenviar contraseña'; 

/* DataTable columnas */
$lang['suc_col_id']            = 'ID';
$lang['suc_col_name']          = 'Nombre';
$lang['suc_col_key']           = 'Clave';
$lang['suc_col_created_at']    = 'Fecha de creación';
$lang['suc_col_access']        = 'Accesos';
$lang['suc_col_actions']       = 'Acciones';

/* DataTable textos */
$lang['suc_access_none']       = 'No se encontraron accesos';
$lang['suc_access_has']        = 'Cuenta con {count} acceso(s)';

/* Tooltips acciones */
$lang['suc_tt_edit']           = 'Editar';
$lang['suc_tt_activate']       = 'Activar';
$lang['suc_tt_deactivate']     = 'Desactivar';
$lang['suc_tt_delete_client']  = 'Eliminar cliente';
$lang['suc_tt_view_access']    = 'Ver accesos';
$lang['suc_tt_block_client']   = 'Bloquear cliente';
$lang['suc_tt_unblock_client'] = 'Desbloquear cliente';
$lang['suc_tt_generate_link']  = 'Generar link';
$lang['suc_tt_generar_usuario']= 'Generar usuario';

/* Swal / mensajes */
$lang['suc_saved_ok'] = 'Se ha guardado correctamente';

/* DataTables UI */
$lang['dt_lengthMenu']  = 'Mostrar _MENU_ registros';
$lang['dt_zeroRecords'] = 'No se encontraron registros';
$lang['dt_info']        = 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros';
$lang['dt_infoEmpty']   = 'No hay registros disponibles';
$lang['dt_infoFiltered']= '(Filtrado de _MAX_ registros en total)';
$lang['dt_search']      = 'Buscar:';
$lang['dt_last']        = 'Última página';
$lang['dt_first']       = 'Primera';
$lang['dt_next']        = 'Siguiente';
$lang['dt_previous']    = 'Anterior';

$lang['suc_modal_title_edit_client'] = 'Editar cliente';
$lang['suc_modal_title_new_client']  = 'Nuevo cliente';

$lang['suc_loading'] = 'Cargando…';

$lang['suc_links_label_link']        = 'Link:';
$lang['suc_links_label_qr']          = 'QR:';
$lang['suc_links_qr_not_available']  = 'QR no disponible';
$lang['suc_links_expires']           = 'Expira: {date}';
$lang['suc_links_none']              = 'No hay links generados';
$lang['suc_links_error_load']        = 'Error al cargar links';

$lang['suc_btn_copy']   = 'Copiar';
$lang['suc_btn_copied'] = '¡Copiado!';

$lang['suc_missing_id_cliente'] = 'Falta id_cliente';

$lang['suc_sw_error_title']          = 'Error';
$lang['suc_sw_success_title']        = '¡Listo!';
$lang['suc_sw_link_generated']       = 'Link generado.';
$lang['suc_sw_link_generate_failed'] = 'No se pudo generar el link.';
$lang['suc_sw_link_confirm_title']   = '¿Generar/actualizar link?';
$lang['suc_sw_link_confirm_text']    = 'El link y el QR anteriores quedarán obsoletos.';
$lang['suc_sw_confirm_yes']          = 'Sí, continuar';
$lang['suc_sw_confirm_cancel']       = 'Cancelar';

$lang['suc_access_modal_none']       = 'Sin accesos.';
$lang['suc_access_modal_error_load'] = 'Error al cargar accesos.';
$lang['suc_access_no_records']       = 'No hay registro de accesos';

$lang['suc_access_tbl_name']     = 'Nombre';
$lang['suc_access_tbl_email']    = 'Correo';
$lang['suc_access_tbl_created']  = 'Alta';
$lang['suc_access_tbl_user']     = 'Usuario';
$lang['suc_access_tbl_category'] = 'Categoría';
$lang['suc_access_tbl_actions']  = 'Acciones';

$lang['suc_access_pending_register'] = 'Pendiente de registrar';
$lang['suc_access_privacy_level']    = 'Nivel {level}';
$lang['suc_access_privacy_none']     = 'Sin privacidad';

$lang['suc_updated_ok'] = 'Se ha actualizado exitosamente';

/* Confirmaciones (modal #mensajeModal) */
$lang['suc_confirm_activate_title'] = 'Activar cliente';
$lang['suc_confirm_activate_text']  = '¿Desea activar al cliente <b>{name}</b>?';

$lang['suc_confirm_deactivate_title'] = 'Desactivar cliente';
$lang['suc_confirm_deactivate_text']  = '¿Desea desactivar al cliente <b>{name}</b>?';

$lang['suc_confirm_delete_title'] = 'Eliminar cliente';
$lang['suc_confirm_delete_text']  = '¿Desea eliminar al cliente <b>{name}</b>?';

$lang['suc_confirm_delete_user_title'] = 'Eliminar usuario';
$lang['suc_confirm_delete_user_text']  = '¿Desea eliminar al usuario <b>{name}</b>?';

/* Bloqueo / desbloqueo (campos extra dentro del modal) */
$lang['suc_confirm_block_title'] = 'Bloquear cliente';
$lang['suc_confirm_block_text']  = '¿Desea bloquear al cliente <b>{name}</b>?';

$lang['suc_block_reason_lbl']   = 'Motivo de bloqueo *';
$lang['suc_block_message_lbl']  = 'Mensaje para presentar en panel del cliente *';
$lang['suc_block_message_default'] = '¡Lo sentimos! Su acceso ha sido interrumpido por falta de pago. Favor de comunicarse al teléfono 33 3454 2877.';
$lang['suc_block_subclients_lbl'] = 'Bloquear también subclientes/proveedores';

$lang['suc_confirm_unblock_title'] = 'Desbloquear cliente';
$lang['suc_confirm_unblock_text']  = '¿Desea desbloquear al cliente <b>{name}</b>?';
$lang['suc_unblock_reason_lbl']    = 'Razón de desbloqueo *';

$lang['suc_select_placeholder'] = 'Selecciona';

/* Modal reenviar contraseña (enviarCredenciales) */
$lang['suc_modal_resend_password_title'] = 'Reenviar contraseña';
$lang['suc_modal_resend_password_text']  = '¿Deseas actualizar la contraseña al usuario <b>{email}</b>?';

/* Errores genéricos usados en AJAX */
$lang['suc_sw_comm_error'] = 'Error de comunicación con el servidor.';

$lang['suc_user_saved_ok'] = 'Usuario guardado correctamente';
$lang['suc_error_action']  = 'Error al realizar la acción';

$lang['suc_close'] = 'Cerrar';

$lang['suc_newmodal_intro'] = '¡Bienvenido al registro de una nueva sucursal/cliente o actualización de una existente! Estamos aquí para facilitarte el proceso. Puedes completar el formulario parcialmente si así lo deseas. Los campos marcados con un asterisco (*) son obligatorios: Nombre y Clave.';

$lang['suc_lbl_branch_name'] = 'Nombre de la Sucursal/Cliente';
$lang['suc_field_branch_name'] = 'Nombre del Cliente';
$lang['suc_ph_branch_name'] = 'Ingrese el nombre del cliente';

$lang['suc_lbl_max_employees'] = 'Número máximo de empleados';
$lang['suc_field_max_employees'] = 'Número máximo de empleados';
$lang['suc_ph_max_employees'] = 'Número máximo de empleados';

$lang['suc_lbl_key'] = 'Clave';
$lang['suc_field_key'] = 'Clave';
$lang['suc_ph_key'] = 'Ingrese la clave del cliente';

$lang['suc_lbl_email'] = 'Correo';
$lang['suc_field_email'] = 'Correo';
$lang['suc_ph_email'] = 'Ingrese el correo electrónico';

$lang['suc_note_title'] = 'Nota';
$lang['suc_note_recruitment'] = 'Los campos correo y contraseña solo son necesarios si se cuenta con el módulo de reclutamiento y pre empleo activos.';

$lang['suc_field_password'] = 'Contraseña';
$lang['suc_aria_show_password'] = 'Mostrar contraseña';
$lang['suc_btn_show'] = ' Mostrar';
$lang['suc_btn_hide'] = ' Ocultar';

$lang['suc_lbl_razon_social'] = 'Razón Social';
$lang['suc_ph_razon_social'] = 'Ingrese la razón social';

$lang['suc_lbl_phone'] = 'Teléfono';
$lang['suc_ph_phone'] = 'Ingrese el teléfono';

$lang['suc_lbl_contact_name'] = 'Nombre contacto';
$lang['suc_ph_contact_name'] = 'Nombre';

$lang['suc_lbl_contact_lastname'] = 'Apellido contacto';
$lang['suc_ph_contact_lastname'] = 'Apellido paterno';

$lang['suc_lbl_rfc'] = 'RFC';
$lang['suc_ph_rfc'] = 'Ingrese el RFC';

$lang['suc_lbl_regimen'] = 'Régimen';
$lang['suc_ph_regimen'] = 'Ingrese el régimen';

$lang['suc_lbl_forma_pago'] = 'Forma de pago';
$lang['suc_opt_forma_pago_single'] = 'Pago en una sola exhibición';
$lang['suc_opt_forma_pago_partial'] = 'Pago en parcialidades o diferidos';

$lang['suc_lbl_metodo_pago'] = 'Método de pago';
$lang['suc_opt_metodo_efectivo'] = 'Efectivo';
$lang['suc_opt_metodo_cheque'] = 'Cheque de nómina';
$lang['suc_opt_metodo_transfer'] = 'Transferencia electrónica';
$lang['suc_opt_metodo_credit'] = 'Tarjeta de crédito';
$lang['suc_opt_metodo_debit'] = 'Tarjeta de débito';
$lang['suc_opt_metodo_tbd'] = 'Por definir';

$lang['suc_lbl_uso_cfdi'] = 'Uso de CFDI';
$lang['suc_ph_uso_cfdi'] = 'Ingrese el uso de CFDI';

$lang['suc_lbl_country'] = 'País';
$lang['suc_ph_country'] = 'Ingrese su país';

$lang['suc_lbl_state'] = 'Estado';
$lang['suc_ph_state'] = 'Ingrese su estado';

$lang['suc_lbl_city'] = 'Ciudad';
$lang['suc_ph_city'] = 'Ingrese su ciudad';

$lang['suc_lbl_colony'] = 'Colonia';
$lang['suc_ph_colony'] = 'Ingrese la colonia';

$lang['suc_lbl_street'] = 'Calle';
$lang['suc_ph_street'] = 'Ingrese la calle';

$lang['suc_lbl_ext_number'] = 'Número exterior';
$lang['suc_ph_ext_number'] = 'Ingrese el número exterior';

$lang['suc_lbl_int_number'] = 'Número interior';
$lang['suc_ph_int_number'] = 'Ingrese el número interior';

$lang['suc_lbl_zip'] = 'Código postal';
$lang['suc_ph_zip'] = 'Ingrese el código postal';

$lang['suc_btn_back'] = 'Regresar';
$lang['suc_btn_continue'] = 'Continuar';

$lang['suc_step1_title'] = 'Información Sucursal';
$lang['suc_step2_title'] = 'Información de Contacto';
$lang['suc_step3_title'] = 'Domicilio';

$lang['suc_btn_finish'] = 'Finalizar';
$lang['suc_btn_ok']     = 'Aceptar';
$lang['suc_btn_close']  = 'Cerrar';

$lang['suc_sw_problem_title']  = 'Hubo un problema';
$lang['suc_sw_invalid_field']  = 'El campo <b>{field}</b> no es válido';
$lang['suc_sw_unknown_error']  = 'Ocurrió un error.';
$lang['suc_field_unknown']     = 'este campo';

$lang['suc_states_of'] = 'Estados de: {country}';
$lang['suc_cities_of'] = 'Ciudades de: {state}';
$lang['suc_pending']   = 'Pendiente';

$lang['suc_btn_confirm'] = 'Confirmar';
$lang['suc_access_modal_branch_label'] = 'Sucursal';
$lang['suc_btn_save'] = 'Guardar';

$lang['suc_access_create_title'] = 'Registro de credenciales Sucursal/Cliente';
$lang['suc_access_lbl_branch'] = 'Sucursal';
$lang['suc_access_lbl_name'] = 'Nombre';
$lang['suc_access_lbl_lastname'] = 'Primer apellido';
$lang['suc_access_lbl_spectator'] = 'Espectador';
$lang['suc_access_lbl_privacy'] = 'Privacidad de visualizar candidatos';
$lang['suc_access_lbl_email'] = 'Correo';
$lang['suc_access_lbl_phone'] = 'Teléfono';

$lang['suc_access_password_note'] = '* La contraseña será enviada al correo especificado. Verifica que sea correcto y que tengas acceso.';

$lang['suc_access_privacy_0']  = 'Sin privacidad (Visible para usuarios/clientes sin privacidad y Nivel 1)';
$lang['suc_access_privacy_1']  = 'Nivel 1 (Visibilidad total de los candidatos)';
$lang['suc_access_privacy_2']  = 'Nivel 2 (Visibilidad de candidatos para Nivel 2 y 1)';
$lang['suc_access_privacy_3']  = 'Nivel 3 (Visibilidad de candidatos para Nivel 3 y 1)';
$lang['suc_access_privacy_4']  = 'Nivel 4 (Visibilidad de candidatos para Nivel 4 y 1)';
$lang['suc_access_privacy_5']  = 'Nivel 5 (Visibilidad de candidatos para Nivel 5 y 1)';
$lang['suc_access_privacy_6']  = 'Nivel 6 (Visibilidad de candidatos para Nivel 6 y 1)';
$lang['suc_access_privacy_7']  = 'Nivel 7 (Visibilidad de candidatos para Nivel 7 y 1)';
$lang['suc_access_privacy_8']  = 'Nivel 8 (Visibilidad de candidatos para Nivel 8 y 1)';
$lang['suc_access_privacy_9']  = 'Nivel 9 (Visibilidad de candidatos para Nivel 9 y 1)';
$lang['suc_access_privacy_10'] = 'Nivel 10 (Visibilidad de candidatos para Nivel 10 y 1)';

$lang['suc_links_modal_title'] = 'Links para formulario de Requisición';
$lang['suc_links_generated_label'] = 'Links generados';
$lang['suc_links_btn_generate_update'] = 'Generar/Actualizar';

$lang['suc_guc_title'] = 'Generar usuario para ';
$lang['suc_guc_lbl_name'] = 'Nombre';
$lang['suc_guc_lbl_lastname'] = 'Apellido';
$lang['suc_guc_lbl_email'] = 'Correo';
$lang['suc_guc_email_help'] = 'Se usará como usuario de acceso.';
$lang['suc_guc_lbl_phone'] = 'Teléfono';
$lang['suc_guc_ph_phone'] = '33 1234 5678';

$lang['suc_guc_lbl_password'] = 'Contraseña';
$lang['suc_guc_ph_password'] = 'Mín. 9 caracteres con Mayús/Minús/Número/Símbolo';
$lang['suc_guc_pass_help'] = 'Debe incluir: mayúscula, minúscula, número y símbolo.';
$lang['suc_guc_pass_invalid'] = 'La contraseña no cumple los requisitos.';

$lang['suc_guc_lbl_password_confirm'] = 'Confirmar contraseña';
$lang['suc_guc_pass_mismatch'] = 'Las contraseñas no coinciden.';

$lang['suc_guc_info'] = 'Se creará el usuario y se asociará a este cliente. Si el correo ya existe en el sistema, no te permitirá registrarlo.';
$lang['suc_guc_btn_submit'] = 'Generar usuario';

$lang['suc_guc_tt_toggle'] = 'Ver/ocultar';
$lang['suc_guc_js_show'] = 'Mostrar contraseña';
$lang['suc_guc_js_hide'] = 'Ocultar contraseña';

$lang['suc_api_missing_id_portal']         = 'Falta id_portal en la sesión.';
$lang['suc_api_no_clients_to_process']     = 'No hay clientes para procesar.';
$lang['suc_api_invalid_id_cliente']        = 'id_cliente inválido.';
$lang['suc_api_link_generate_failed_item'] = 'No se pudo generar el link.';
$lang['suc_api_process_done_with_errors']  = 'Proceso terminado con errores.';
$lang['suc_api_process_done_ok']           = 'Proceso completado correctamente.';
$lang['suc_links_ok']   = 'Correctos';
$lang['suc_links_fail'] = 'Errores';

$lang['suc_btn_accept'] = 'Aceptar';

/* generarLinkstodos() */
$lang['suc_links_generating_title']     = 'Generando links...';
$lang['suc_links_generating_text']      = 'Esto puede tardar unos segundos.';

$lang['suc_links_done_with_errors']     = 'Proceso terminado con errores.';
$lang['suc_links_done_ok']              = 'Proceso completado correctamente.';

$lang['suc_links_view_link']            = 'Ver link';
$lang['suc_links_unknown_error']        = 'Error desconocido';
$lang['suc_links_no_items']             = 'Sin elementos.';

$lang['suc_links_tbl_id']               = 'ID Cliente';
$lang['suc_links_tbl_status']           = 'Estado';
$lang['suc_links_tbl_detail']           = 'Detalle / Link';

$lang['suc_links_done_warn_title']      = 'Proceso con advertencias';

$lang['suc_links_request_error']        = 'Ocurrió un problema al procesar la solicitud.';

/* ya las tenías pendientes */
// Validación CI3
$lang['fv_required']     = 'El campo {field} es obligatorio';
$lang['fv_max_length']   = 'El campo {field} debe tener máximo {param} caracteres.';
$lang['fv_valid_email']  = 'El campo {field} debe ser un correo válido.';
$lang['fv_check_nombre_unique'] = 'El Nombre del Cliente/Sucursal ya existe.';

// Labels (para validation_errors)
$lang['fv_field_nombre']   = 'Nombre del cliente/sucursal';
$lang['fv_field_clave']    = 'Clave';
$lang['fv_field_correo']   = 'Correo';
$lang['fv_field_password'] = 'Contraseña';
$lang['fv_field_empleados']= 'Número máximo de empleados';
$lang['fv_field_pais']     = 'País';
$lang['fv_field_estado']   = 'Estado';
$lang['fv_field_ciudad']   = 'Ciudad';
$lang['fv_field_colonia']  = 'Colonia';
$lang['fv_field_calle']    = 'Calle';
$lang['fv_field_num_ext']  = 'Número exterior';
$lang['fv_field_num_int']  = 'Número interior';
$lang['fv_field_cp']       = 'Código postal';
$lang['fv_field_razon_social'] = 'Razón social';
$lang['fv_field_telefono'] = 'Teléfono';
$lang['fv_field_nombre_contacto']   = 'Nombre de contacto';
$lang['fv_field_apellido_contacto'] = 'Apellido de contacto';
$lang['fv_field_rfc']      = 'RFC';
$lang['fv_field_regimen']  = 'Régimen';
$lang['fv_field_forma_pago']  = 'Forma de pago';
$lang['fv_field_metodo_pago'] = 'Método de pago';
$lang['fv_field_uso_cfdi']    = 'Uso de CFDI';

// Mensajes setCliente()
$lang['cli_email_exists']      = 'El correo proporcionado ya existe';
$lang['cli_updated_ok']        = 'Cliente/Sucursal actualizada exitosamente';
$lang['cli_created_ok_sent']   = 'Cliente/Sucursal registrado exitosamente, se enviaron las credenciales a {email}';
$lang['cli_create_error']      = 'Error al registrar al cliente/sucursal';
$lang['cli_name_or_key_exists']= 'El nombre de la sucursal y/o clave ya existe';

$lang['cli_email_exists']        = 'El correo proporcionado ya existe';
$lang['cli_updated_ok']          = 'Cliente/Sucursal actualizada exitosamente';
$lang['cli_created_ok_sent']     = 'Cliente/Sucursal registrado exitosamente, se enviaron las credenciales a {email}';
$lang['cli_create_error']        = 'Error al registrar al cliente/sucursal';
$lang['cli_name_or_key_exists']  = 'El nombre de la sucursal y/o clave ya existe';

// ===== guardarDatos messages =====
$lang['gd_file_required']  = 'Por favor sube tu archivo en el apartado correspondiente.';
$lang['gd_upload_failed']  = 'Error al cargar el archivo, inténtalo nuevamente.';
$lang['gd_saved_ok']       = 'Los datos y el archivo fueron almacenados correctamente :)';
$lang['gd_update_failed']  = 'Hubo un problema al actualizar los datos, por favor inténtalo nuevamente.';

$lang['cli_status_invalid_request'] = 'Solicitud inválida.';
$lang['cli_status_unknown_action']  = 'Acción no válida.';

$lang['cli_status_deactivated_ok']  = 'Sucursal inactivada correctamente';
$lang['cli_status_activated_ok']    = 'Sucursal activada correctamente';
$lang['cli_status_deleted_ok']      = 'Sucursal eliminada correctamente';
$lang['cli_status_blocked_ok']      = 'Sucursal bloqueada correctamente';
$lang['cli_status_unblocked_ok']    = 'Sucursal desbloqueada correctamente';

$lang['guc_invalid_client']            = 'Cliente inválido.';
$lang['guc_name_last_required']        = 'Nombre y apellido son requeridos.';
$lang['guc_invalid_email']             = 'Correo inválido.';
$lang['guc_pass_not_valid']            = 'La contraseña no cumple los requisitos.';
$lang['guc_pass_not_match']            = 'La confirmación de contraseña no coincide.';
$lang['guc_email_exists_use_other']    = 'Este correo ya está registrado. Usa otro.';
$lang['guc_email_exists']              = 'Este correo ya está registrado.';
$lang['guc_cannot_create_user']        = 'No se pudo crear el usuario.';
$lang['guc_cannot_generate_user']      = 'No se pudo generar el usuario.';
$lang['guc_user_created_and_linked']   = 'Usuario generado y asociado.';
$lang['guc_no_email_associated']     = 'No existe un correo asociado a este usuario.';


$lang['acc_invalid_user_client']      = 'ID de usuario/cliente inválido.';
$lang['acc_user_deleted_ok']          = 'Usuario eliminado correctamente';
$lang['acc_credentials_updated_ok']   = 'Credenciales actualizadas correctamente';
$lang['acc_invalid_action']           = 'Acción inválida.';

$lang['links_invalid_client_id']      = 'ID de cliente inválido';

// ===== Requisición: generar link =====
$lang['suc_req_missing_field']      = 'Falta {field}.';
$lang['suc_req_private_key_error']  = 'No se pudo cargar la clave privada JWT.';
$lang['suc_req_missing_form_url']   = 'Falta LINKNUEVAREQUISICION.';
$lang['suc_req_save_link_error']    = 'No se pudo guardar el link.';
$lang['suc_req_link_ok']            = 'Link generado/actualizado correctamente.';

// ===== Actualizar contraseña =====
$lang['ap_field_id']    = 'ID';
$lang['ap_field_email'] = 'Correo';
$lang['ap_field_pass']  = 'Contraseña';

// Si tu fv_required usa {field}, este es el que usa %s (sprintf)
$lang['fv_required_sprintf'] = 'El campo %s es obligatorio';

$lang['ap_email_missing'] = 'Falta el correo.';
$lang['ap_pass_sent_to']  = 'La nueva contraseña fue enviada a {email}';
$lang['ap_pass_update_fail_support'] = 'No se pudo actualizar la contraseña. Póngase en contacto con soporte@talentsafecontrol.com';
$lang['ap_no_email_cannot_send'] = 'No existe un correo asociado. No se puede enviar la contraseña.';
$lang['fv_valid_email_sprintf']  = 'El campo %s debe ser un correo válido';

