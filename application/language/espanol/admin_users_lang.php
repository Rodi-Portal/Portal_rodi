<?php
$lang['admin_users_title']      = "Administradores del sistema";
$lang['admin_users_btn_create'] = "Crear usuario";
$lang['admin_users_btn_assign'] = "Asignar usuario";

$lang['admin_users_description'] =
    "En este módulo puedes gestionar a tus usuarios internos. Puedes crear nuevos usuarios, actualizar su información y reenviar credenciales cuando sea necesario.";

// --- Modal de asignación ---
$lang['admin_users_modal_assign_title'] = "Asignar sucursal a usuarios";
$lang['admin_users_modal_users']        = "Usuarios";
$lang['admin_users_modal_select_user']  = "Selecciona un usuario";
$lang['admin_users_modal_select_all']   = "Seleccionar todas las sucursales/clientes";

$lang['admin_users_modal_branches']      = "Sucursales/Clientes";
$lang['admin_users_modal_select_branch'] = "Selecciona una sucursal/cliente";
$lang['admin_users_modal_save']          = "Guardar";

$lang['admin_users_modal_confirm_title'] = "Confirmación";
$lang['admin_users_modal_btn_cancel']    = "Cancelar";
$lang['admin_users_modal_btn_confirm']   = "Confirmar";

// --- Enviar credenciales ---
$lang['admin_users_send_credentials_title'] = "Enviar credenciales";
$lang['admin_users_generate_password']      = "Generar contraseña *";
$lang['admin_users_btn_resend']             = "Reenviar contraseña";

// --- Permisos ---
$lang['admin_users_permissions_title'] = "Permisos";

// --- Columnas ---
$lang['admin_users_col_id']      = "ID";
$lang['admin_users_col_user']    = "Usuario";
$lang['admin_users_col_name']    = "Nombre";
$lang['admin_users_col_branch']  = "Sucursal";
$lang['admin_users_col_email']   = "Correo";
$lang['admin_users_col_role']    = "Rol de usuario";
$lang['admin_users_col_created'] = "Fecha de creación";
$lang['admin_users_col_updated'] = "Última actualización";
$lang['admin_users_col_actions'] = "Acciones";

// --- Acciones JS ---
$lang['admin_users_js_delete_title'] = "Eliminar usuario";
$lang['admin_users_js_delete_msg']   = "¿Deseas eliminar al usuario <b>{user}</b>?";

$lang['admin_users_js_disable_title'] = "Desactivar usuario";
$lang['admin_users_js_disable_msg']   = "¿Deseas desactivar al usuario <b>{user}</b>?";

$lang['admin_users_js_enable_title'] = "Activar usuario";
$lang['admin_users_js_enable_msg']   = "¿Deseas activar al usuario <b>{user}</b>?";

$lang['admin_users_js_resend_title'] = "Reenviar contraseña";
$lang['admin_users_js_resend_msg']   = "¿Deseas actualizar y reenviar la contraseña a <b>{email}</b>?";

// --- Límite de usuarios ---
$lang['admin_users_limit_reached_title'] = "Límite de usuarios alcanzado";
$lang['admin_users_limit_reached_msg']   =
    "Has alcanzado el límite de usuarios de tu suscripción.<br>¿Deseas agregar uno adicional por un costo mensual de <b>$50 USD</b>?";
$lang['admin_users_btn_accept_extra'] = "Sí, aceptar costo extra";
$lang['admin_users_btn_cancel']       = "Cancelar";

$lang['admin_users_final_confirm_title'] = "Confirmación final";
$lang['admin_users_final_confirm_msg']   =
    "Estás a punto de generar un cargo adicional que aparecerá en tu próxima factura.<br><b>¿Deseas continuar?</b>";
$lang['admin_users_btn_continue']        = "Sí, continuar";

// --- Mensajes generales ---
$lang['admin_users_error_check_limit']          = "No fue posible verificar el límite de usuarios.";
$lang['admin_users_assign_warning_title']       = "Atención";
$lang['admin_users_assign_warning_text']        = "Selecciona al menos un usuario y una sucursal.";
$lang['admin_users_assign_success_title']       = "Éxito";
$lang['admin_users_assign_success_text']        = "Asignación de sucursales guardada correctamente.";
$lang['admin_users_assign_error_title']         = "Error";
$lang['admin_users_assign_error_text']          = "Hubo un problema al guardar la asignación.";
$lang['admin_users_assign_confirm']             = "OK";

$lang['admin_users_sw_edit_success']            = "Usuario actualizado correctamente";
$lang['admin_users_sw_pass_success']            = "Contraseña actualizada correctamente";
$lang['admin_users_sw_pass_error_title']        = "Acción fallida";
$lang['admin_users_sw_pass_error_text']         = "No se pudo actualizar la contraseña.";

$lang['admin_users_permissions_error_title']    = "Atención";
$lang['admin_users_permissions_error_msg']      = "No fue posible abrir el modal.";
$lang['admin_users_permissions_adjusted_title'] = "Módulo ajustado";
$lang['admin_users_permissions_adjusted_msg']   = "Abriendo: ";
$lang['admin_users_permissions_loading']        = "Cargando…";
$lang['admin_users_permissions_modal_title']    = "Permisos del usuario #";
$lang['admin_users_permissions_modal_sub']      = " · ";
$lang['admin_users_permissions_error_generic']  = "No se pudo validar la apertura del modal.";

$lang['admin_users_action_success'] = "Acción realizada correctamente";
$lang['admin_users_action_error']   = "Error al realizar la acción";
$lang['admin_users_action_close']   = "Cerrar";

// --- Modal nuevo / editar usuario ---
$lang['admin_users_modal_new_title']  = "Registrar usuario interno *";
$lang['admin_users_modal_edit_title'] = "Editar usuario interno";

$lang['admin_users_modal_firstname']   = "Nombre(s) *";
$lang['admin_users_modal_lastname']    = "Apellidos *";
$lang['admin_users_modal_role']        = "Tipo de rol *";
$lang['admin_users_modal_select_role'] = "Selecciona un rol";

$lang['admin_users_modal_phone'] = "Teléfono *";
$lang['admin_users_modal_email'] = "Correo electrónico *";

$lang['admin_users_modal_click']             = "Click";
$lang['admin_users_modal_generate_password'] = "Generar contraseña";
$lang['admin_users_modal_password']          = "Contraseña *";

$lang['admin_users_modal_copy_warning'] =
    "* Copia la contraseña para enviarla después. Si no la copias ahora, deberás generar una nueva.";

$lang['admin_users_modal_btn_close']  = "Cerrar";
$lang['admin_users_modal_btn_save']   = "Guardar";
$lang['admin_users_modal_btn_update'] = "Guardar cambios";

$lang['admin_users_edit_title']       = "Editar usuario";
$lang['admin_users_btn_save_changes'] = "Guardar cambios";

//$lang['dashboard_no_access_title'] = 'Acceso no disponible';
//$lang['dashboard_no_access_msg']   = 'Este módulo muestra indicadores y métricas generales de la plataforma. Actualmente no cuentas con acceso a esta sección. Si consideras que deberías tenerlo, por favor comunícate con el administrador.';
