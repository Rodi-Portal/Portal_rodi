<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* ===============================
   Modal – Actualizar Logo
   =============================== */

$lang['portal_logo_modal_title']        = 'Subir nuevo logo';
$lang['portal_logo_select_image']      = 'Selecciona una imagen';
$lang['portal_logo_preview']           = 'Vista previa';
$lang['portal_logo_current']           = 'Logo actual';
$lang['portal_logo_delete']            = 'Eliminar logo';
$lang['portal_logo_close']             = 'Cerrar';
$lang['portal_logo_save']              = 'Guardar logo';

/* SweetAlert */
$lang['portal_logo_swal_confirm_title'] = '¿Estás seguro?';
$lang['portal_logo_swal_confirm_text']  = '¡Esta acción no puede deshacerse!';
$lang['portal_logo_swal_confirm_btn']   = 'Sí, eliminarlo';
$lang['portal_logo_swal_cancel_btn']    = 'Cancelar';

$lang['portal_logo_deleted_title']      = '¡Eliminado!';
$lang['portal_logo_deleted_text']       = 'El logo ha sido eliminado exitosamente.';

$lang['portal_logo_update_success']     = 'Logo actualizado';
$lang['portal_logo_update_success_txt'] = 'El logo se ha actualizado correctamente.';

$lang['portal_logo_update_error']       = 'Error al actualizar el logo';
$lang['portal_logo_generic_error']      = 'Hubo un problema al intentar actualizar el logo.';
$lang['portal_logo_delete_error']       = 'Hubo un error al eliminar el logo.';

$lang['portal_logo_no_file_title']      = 'Sin archivo';
$lang['portal_logo_no_file_text']       = 'Por favor, selecciona una imagen para el logo.';


$lang['portal_docs_modal_title'] = 'Documentos del portal';

$lang['portal_docs_th_document'] = 'Documento';
$lang['portal_docs_th_current']  = 'Actual / Por defecto';
$lang['portal_docs_th_upload']   = 'Cargar PDF';
$lang['portal_docs_th_actions']  = 'Acciones';

$lang['portal_docs_aviso'] = 'Aviso para candidatos';
$lang['portal_docs_terminos'] = 'Términos y condiciones (requisiciones)';
$lang['portal_docs_confidencialidad'] = 'Acuerdo de confidencialidad';

$lang['portal_docs_note_default'] = 'Si no hay archivo cargado, se mostrará el documento por defecto.';

$lang['portal_docs_select_pdf'] = 'Selecciona un PDF';
$lang['portal_docs_invalid_file'] = 'Archivo inválido';
$lang['portal_docs_only_pdf'] = 'Debe ser un PDF (.pdf)';
$lang['portal_docs_uploading'] = 'Subiendo…';

$lang['portal_docs_saved_title'] = '¡Guardado!';
$lang['portal_docs_updated'] = 'Documento actualizado.';
$lang['portal_docs_view'] = 'Ver documento';

$lang['portal_docs_deleted_title'] = 'Eliminado';
$lang['portal_docs_deleted'] = 'Documento eliminado.';
$lang['portal_docs_not_loaded'] = 'No cargado';

$lang['portal_docs_confirm_delete'] = '¿Eliminar documento?';

$lang['portal_docs_upload_error'] = 'Error al subir';
$lang['portal_docs_upload_fail'] = 'No se pudo subir el documento.';
$lang['portal_docs_delete_fail'] = 'No se pudo eliminar.';

$lang['portal_save'] = 'Guardar';
$lang['portal_delete'] = 'Eliminar';
$lang['portal_close'] = 'Cerrar';
$lang['portal_confirm'] = 'Sí, eliminar';
$lang['portal_cancel'] = 'Cancelar';
$lang['portal_error'] = 'Error';
$lang['portal_docs_warn_title'] = 'Aviso';

/* ===============================
   Portal – Documentos (Backend)
   =============================== */

$lang['portal_docs_err_no_session'] = 'Sesión sin idPortal';
$lang['portal_docs_err_invalid_type'] = 'Tipo inválido';
$lang['portal_docs_err_select_pdf'] = 'Selecciona un PDF';
$lang['portal_docs_err_upload'] = 'Error al subir: {error}';
$lang['portal_docs_err_no_file_delete'] = 'No hay archivo para eliminar';
$lang['portal_docs_deleted_backend'] = '{tipo} eliminado.';

$lang['portal_docs_saved_backend'] = '{tipo} actualizado.';
$lang['portal_docs_deleted_backend'] = '{tipo} eliminado.';
$lang['portal_docs_tipo_aviso'] = 'Aviso';
$lang['portal_docs_tipo_terminos'] = 'Términos';
$lang['portal_docs_tipo_confidencialidad'] = 'Confidencialidad';


/* ======================================================
 * PASARELA / PAGOS – GENERAL
 * ====================================================== */

$lang['portal_pay_title'] = 'Detalles de tu Suscripción';

$lang['portal_pay_tab_pay']          = 'Pagar';
$lang['portal_pay_tab_subscription'] = 'Suscripción';
$lang['portal_pay_tab_history']      = 'Historial de Pagos';


/* ======================================================
 * ALERTAS GENERALES
 * ====================================================== */

$lang['portal_pay_expired_alert_title'] = 'Tu suscripción ha expirado';
$lang['portal_pay_expired_alert_text'] =
'Tu suscripción a TalentSafe ha expirado. Por favor realiza tu pago cuanto antes generando un link de pago.
Después de pagarlo, regresa aquí y confírmalo en el botón correspondiente.
De esta manera tus accesos quedarán habilitados nuevamente.
También puedes comunicarte al (52) 3334 54 2877 vía llamada o WhatsApp de L-V de 8 am a 6 pm para cualquier duda o aclaración.';

$lang['portal_pay_no_data'] = 'No hay datos de pago disponibles para este cliente.';


/* ======================================================
 * SUSCRIPCIÓN
 * ====================================================== */

$lang['portal_pay_subscription_detail'] = 'Detalle de tu Suscripción';
$lang['portal_pay_client_name']         = 'Nombre del Cliente';
$lang['portal_pay_plan']               = 'Suscripción';
$lang['portal_pay_plan_description']   = 'Descripción del Paquete';
$lang['portal_pay_users_included']     = 'Usuarios Incluidos';
$lang['portal_pay_extra_users']        = 'Usuarios Extras';
$lang['portal_pay_due_date']           = 'Fecha de Vencimiento';
$lang['portal_pay_status']             = 'Estado';
$lang['portal_pay_total_price']        = 'Precio Total';


/* ======================================================
 * ESTADOS (GENERALES)
 * ====================================================== */

$lang['portal_pay_status_active']   = 'Activo';
$lang['portal_pay_status_expired']  = 'Expirado';
$lang['portal_pay_status_paid']     = 'Pagado';
$lang['portal_pay_status_pending']  = 'Pendiente';


/* ======================================================
 * TABLAS – SUSCRIPCIÓN
 * ====================================================== */

$lang['portal_pay_table_name']  = 'Nombre';
$lang['portal_pay_table_email'] = 'Correo / Descripción';
$lang['portal_pay_table_price'] = 'Precio';


/* ======================================================
 * LINK DE PAGO
 * ====================================================== */

$lang['portal_pay_link_title']    = 'Detalles del Enlace de Pago';
$lang['portal_pay_link_go']       = 'Ir al Pago';
$lang['portal_pay_link_qr']       = 'Ver QR';
$lang['portal_pay_link_confirm']  = 'Confirmar Pago';
$lang['portal_pay_link_generate'] = 'Generar Link de Pago';

$lang['portal_pay_no_link'] =
'No se ha generado un link de pago o este ya expiró. Por favor, genera otro.';


/* ======================================================
 * TABLA – LINK DE PAGO
 * ====================================================== */

$lang['portal_pay_table_link_id']     = 'ID del Link de Pago';
$lang['portal_pay_table_link']        = 'Enlace para realizar el pago';
$lang['portal_pay_table_link_status'] = 'Estatus del Link';
$lang['portal_pay_table_created']     = 'Fecha de generación';
$lang['portal_pay_table_expires']     = 'Fecha de expiración';
$lang['portal_pay_table_actions']     = 'Acciones';


/* ======================================================
 * HISTORIAL DE PAGOS
 * ====================================================== */

$lang['portal_pay_history_title']      = 'Historial de Pagos';
$lang['portal_pay_no_history']         = 'No hay historial de pagos disponible.';
$lang['portal_pay_history_id']         = 'ID del Pago';
$lang['portal_pay_history_month']      = 'Mes';
$lang['portal_pay_history_date']       = 'Fecha de Pago';
$lang['portal_pay_history_amount']     = 'Monto';
$lang['portal_pay_history_status']     = 'Estatus';
$lang['portal_pay_history_reference']  = 'Referencia';
$lang['portal_pay_history_view_status'] = 'Ver estatus';


/* ======================================================
 * HISTORIAL (PASARELA – TABLA)
 * ====================================================== */

$lang['pasarela.history.title'] = 'Historial de Pagos';

$lang['pasarela.history.columns.payment_id']   = 'ID Pago';
$lang['pasarela.history.columns.month']        = 'Mes a pagar';
$lang['pasarela.history.columns.payment_date'] = 'Fecha de Pago';
$lang['pasarela.history.columns.amount']       = 'Monto';
$lang['pasarela.history.columns.status']       = 'Estatus';
$lang['pasarela.history.columns.reference']    = 'Referencia';

$lang['pasarela.history.view_status'] = 'Ver estatus';
$lang['pasarela.history.empty']       = 'No hay historial de pagos disponible.';


/* ======================================================
 * MODAL – GENERAR PAGO
 * ====================================================== */

$lang['portal_pay_modal_title']         = 'Generar Pago';
$lang['portal_pay_modal_select_months'] = 'Selecciona los meses a pagar';
$lang['portal_pay_modal_total']         = 'Total';
$lang['portal_pay_modal_generate']      = 'Generar Link';

$lang['pasarela.modal.title']            = 'Generar Pago';
$lang['pasarela.modal.package_fallback'] = 'Paquete';
$lang['pasarela.modal.extra_users']      = 'Usuarios Extras';
$lang['pasarela.modal.select_months']    = 'Selecciona los meses a pagar';
$lang['pasarela.modal.total']            = 'Total';
$lang['pasarela.modal.generate']         = 'Generar Link';


/* ======================================================
 * SWEETALERT – MENSAJES
 * ====================================================== */

$lang['portal_pay_swal_success'] = '¡Éxito!';
$lang['portal_pay_swal_error']   = 'Error';
$lang['portal_pay_swal_confirm'] = 'Confirmar';
$lang['portal_pay_swal_cancel']  = 'Cancelar';

$lang['portal_pay_swal_select_month'] =
'Debes seleccionar al menos un mes.';

$lang['portal_pay_swal_request_error'] =
'Ocurrió un error en la solicitud. Inténtalo nuevamente.';

$lang['portal_pay_swal_link_success'] =
'El enlace de pago se generó correctamente.';

$lang['portal_pay_swal_link_error'] =
'No se pudo generar el enlace de pago.';

$lang['portal_pay_swal_payment_info'] =
'Información del pago';

$lang['portal_pay_swal_unknown_status'] =
'Estatus desconocido.';


/* ======================================================
 * ESTADOS DEL LINK DE PAGO (API / CHECKOUT)
 * ====================================================== */

$lang['portal_pay_status_created'] =
'El enlace de pago fue creado y está pendiente de ser completado.';

$lang['portal_pay_status_pending_text'] =
'El enlace de pago está activo y pendiente de ser completado.';

$lang['portal_pay_status_cancelled'] =
'El enlace de pago fue cancelado por exceso de intentos.';

$lang['portal_pay_status_expired_text'] =
'El enlace de pago ha expirado.';

$lang['portal_pay_status_paid_text'] =
'El enlace de pago se completó correctamente.';

$lang['portal_pay_pending_action'] =
'Acción pendiente';


/* ======================================================
 * MESES
 * ====================================================== */

$lang['months.january']   = 'Enero';
$lang['months.february']  = 'Febrero';
$lang['months.march']     = 'Marzo';
$lang['months.april']     = 'Abril';
$lang['months.may']       = 'Mayo';
$lang['months.june']      = 'Junio';
$lang['months.july']      = 'Julio';
$lang['months.august']    = 'Agosto';
$lang['months.september'] = 'Septiembre';
$lang['months.october']   = 'Octubre';
$lang['months.november']  = 'Noviembre';
$lang['months.december']  = 'Diciembre';


/* ======================================================
 * PASARELA – SUBSCRIPTION
 * ====================================================== */

/* Labels / Fields */
$lang['pasarela.subscription.client_name']     = 'Client Name';
$lang['pasarela.subscription.plan']            = 'Subscription';
$lang['pasarela.subscription.description']     = 'Package Description';
$lang['pasarela.subscription.users_included']  = 'Included Users';
$lang['pasarela.subscription.extra_users']     = 'Extra Users';
$lang['pasarela.subscription.users_suffix']    = 'user(s)';
$lang['pasarela.subscription.due_date']         = 'Due Date';
$lang['pasarela.subscription.status']           = 'Status';
$lang['pasarela.subscription.total_price']      = 'Total Price';

/* Section titles */
$lang['pasarela.subscription.extra_users_title'] = 'Extra Users';

/* Table headers */
$lang['pasarela.subscription.table.name']       = 'Name';
$lang['pasarela.subscription.table.email']      = 'Email / Description';
$lang['pasarela.subscription.table.price']      = 'Price';
/* =========================
 * PLANES – TalentSafe
 * ========================= */
$lang['plan.1.title'] = 'TalentSafe Light';

$lang['plan.1.description'] =
'Precio por mes (1 usuario).<br>
Usuario extra $ 50 USD.<br>
Acceso básico a la plataforma TalentSafe.';

$lang['plan.1.total'] = 'Total: $ 80 USD';


/* Plan 2 – TalentSafe Standard */

$lang['plan.2.title'] = 'TalentSafe Standard';

$lang['plan.2.description'] =
'Precio por mes (5 usuarios).<br>
Usuario extra $ 50 USD.<br>
ELIGE 2 MÓDULOS:<br>
(RECLUTAMIENTO + PREEMPLEO O EMPLEADOS + EXEMPLEADOS + COMUNICACIÓN)';

$lang['plan.2.total'] = 'Total: $ 130 USD';


$lang['plan.3.title'] = 'TalentSafe Plus';

$lang['plan.3.description'] =
'Precio por mes (5 usuarios).<br>
Usuario extra $ 50 USD.<br>
Acceso extendido a múltiples módulos de TalentSafe.';

$lang['plan.3.total'] = 'Total: $ 250 USD';


$lang['plan.4.title'] = 'TalentSafe Platinum';

$lang['plan.4.description'] =
'Precio por mes (20 usuarios).<br>
Usuario extra $ 50 USD.<br>
Acceso completo a todos los módulos de TalentSafe.';

$lang['plan.4.total'] = 'Total: $ 1000 USD';
