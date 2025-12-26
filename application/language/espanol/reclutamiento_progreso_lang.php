<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['rec_prog_title'] = 'Requisiciones en progreso';

$lang['rec_prog_btn_register_applicant'] = 'Registrar aspirante a requisición';
$lang['rec_prog_btn_change_req_status']  = 'Cambiar estatus de requisición';

$lang['rec_prog_intro'] = 'Este módulo facilita la gestión de requisiciones de empleo en curso, permitiendo realizar acciones clave como cambiar su estatus, finalizar, cancelar y asignar aspirantes. Además, brinda herramientas para dar seguimiento al proceso de reclutamiento y compartirlo con el solicitante, registrando movimientos, enviando candidatos a socioeconómico, cargando CVs y dejando comentarios. El reclutador puede agregar aspirantes a la requisición, permitiendo que el solicitante vea los avances del proceso de manera ágil y organizada.';

$lang['rec_prog_filter_select_req'] = 'Selecciona una requisición';
$lang['rec_prog_filter_all']        = 'Todas';

$lang['rec_prog_openings_label'] = 'Vacantes:';

$lang['rec_prog_table_title'] = '';


$lang['rec_prog_col_id']             = '#';
$lang['rec_prog_col_applicant']      = 'Aspirante';
$lang['rec_prog_col_branch_client']  = 'Sucursal/Cliente';
$lang['rec_prog_col_position']       = 'Puesto';
$lang['rec_prog_col_contact']        = 'Contacto';
$lang['rec_prog_col_actions']        = 'Acciones';
$lang['rec_prog_col_current_status'] = 'Estatus actual';

$lang['rec_prog_openings_label_lower'] = 'vacantes';

$lang['rec_prog_contact_phone']   = 'Teléfono';
$lang['rec_prog_contact_email']   = 'Correo';
$lang['rec_prog_contact_channel'] = 'Medio';

$lang['rec_prog_not_registered']    = 'No registrado';
$lang['rec_prog_status_registered'] = 'Registrado';

$lang['rec_prog_actions_btn'] = 'Acciones';

$lang['rec_prog_action_upload_docs'] = 'Cargar Documentos';
$lang['rec_prog_tt_upload_docs']     = 'Cargar documentos';

$lang['rec_prog_tt_delete']           = 'Eliminar';
$lang['rec_prog_action_delete_match'] = 'Eliminar Match';

$lang['rec_prog_action_update_docs'] = 'Actualizar Documentos';
$lang['rec_prog_tt_update_docs']     = 'Actualizar Documentos';

$lang['rec_prog_action_client_comments'] = 'Comentarios Cliente';

$lang['rec_prog_action_view_history'] = 'Ver historial de movimientos';
$lang['rec_prog_tt_view_history']     = 'Ver historial de movimientos';

$lang['rec_prog_action_send_preemployment'] = 'Enviar a Preempleo';
$lang['rec_prog_tt_send_preemployment']     = 'Enviar al módulo de Preempleo para candidatos con o sin estudios previos a la contratación.';

$lang['rec_prog_action_entry_record'] = 'Registro de ingreso';
$lang['rec_prog_tt_entry_record']     = 'Registro de datos de ingreso del candidato';

$lang['rec_prog_action_edit_applicant'] = 'Editar aspirante';
$lang['rec_prog_tt_edit_applicant']     = 'Editar aspirante';

$lang['rec_prog_action_register_moves'] = 'Registrar movimientos';
$lang['rec_prog_tt_register_moves']     = 'Registrar paso en el proceso del aspirante';

$lang['rec_prog_msg_ese_finished'] = 'ESE finalizado';

$lang['rec_prog_hist_date']   = 'Fecha';
$lang['rec_prog_hist_status'] = 'Estatus';
$lang['rec_prog_hist_desc']   = 'Comentario / Descripción / Fecha y lugar';
$lang['rec_prog_hist_delete'] = 'Eliminar Movimiento';
$lang['rec_prog_hist_none']   = 'Sin movimientos';

$lang['rec_prog_opt_na']             = 'N/A';
$lang['rec_prog_opt_other']          = 'Otro';
$lang['rec_prog_opt_select']         = 'Selecciona';
$lang['rec_prog_select_placeholder'] = 'Selecciona una opción';
$lang['rec_prog_no_positions']       = 'No hay puestos registrados';

$lang['rec_prog_dt_length']        = 'Mostrar _MENU_ registros por página';
$lang['rec_prog_dt_zero']          = 'No se encontraron registros';
$lang['rec_prog_dt_info']          = 'Mostrando registros de _START_ a _END_ de un total de _TOTAL_ registros';
$lang['rec_prog_dt_info_empty']    = 'No hay registros disponibles';
$lang['rec_prog_dt_info_filtered'] = '(Filtrado de _MAX_ registros totales)';
$lang['rec_prog_dt_search']        = 'Buscar:';
$lang['rec_prog_dt_last']          = 'Última página';
$lang['rec_prog_dt_first']         = 'Primera';
$lang['rec_prog_dt_next']          = 'Siguiente';
$lang['rec_prog_dt_prev']          = 'Anterior';

$lang['rec_prog_docs_loading']         = 'Cargando…';
$lang['rec_prog_docs_none']            = 'Sin documentos';
$lang['rec_prog_docs_download']        = 'Descargar';
$lang['rec_prog_docs_replace_tt']      = 'Reemplazar archivo';
$lang['rec_prog_docs_delete_tt']       = 'Eliminar archivo';

$lang['rec_prog_docs_updated_title']   = 'Actualizado';
$lang['rec_prog_docs_view_updated_ok'] = 'Vista actualizada correctamente';
$lang['rec_prog_docs_view_update_fail']= 'No se pudo actualizar la vista.';

$lang['rec_prog_docs_load_fail']       = 'No se pudieron cargar los documentos';

$lang['rec_prog_common_error_title']   = 'Error';

$lang['rec_prog_docs_modal_title']        = 'Documentos del aspirante';
$lang['rec_prog_docs_th_custom_name']     = 'Nombre personalizado';
$lang['rec_prog_docs_th_file']            = 'Archivo';
$lang['rec_prog_docs_th_date']            = 'Fecha';
$lang['rec_prog_docs_th_visible_branch']  = 'Visible para Sucursal';
$lang['rec_prog_docs_th_actions']         = 'Acciones';

$lang['rec_common_close_x']               = '&times;';

// SweetAlert - genéricas
$lang['rec_prog_swal_confirm_title']              = '¿Estás seguro?';
$lang['rec_prog_swal_warning_title']              = 'Advertencia';

// Eliminar aspirante
$lang['rec_prog_swal_confirm_delete_applicant']   = 'Vas a eliminar este aspirante';
$lang['rec_prog_swal_warning_applicant_hide']     = 'El aspirante desaparecerá de este listado y el cliente o sucursal no podrá verlo más';
$lang['rec_prog_applicant_deleted_ok']            = 'El aspirante fue eliminado correctamente';
$lang['rec_prog_applicant_delete_fail']           = 'No se pudo eliminar el aspirante. Intenta de nuevo.';

// Eliminar archivo
$lang['rec_prog_file_delete_warn']                = 'Esta acción eliminará el archivo permanentemente.';
$lang['rec_prog_file_deleted_ok']                 = 'Archivo eliminado correctamente';
$lang['rec_prog_file_delete_fail']                = 'No se pudo eliminar el archivo.';

// Comunes (si no existen aún en tu diccionario)
$lang['rec_common_yes_delete']                    = 'Sí, eliminar';
$lang['rec_common_cancel']                        = 'Cancelar';
$lang['rec_common_accept']                        = 'Aceptar';
$lang['rec_common_deleted_title']                 = 'Eliminado';
$lang['rec_common_error_title']                   = 'Error';

$lang['rec_prog_doc_err_no_id']     = 'ID no proporcionado';
$lang['rec_prog_doc_err_not_found'] = 'Documento no encontrado o ya fue eliminado';
$lang['rec_prog_doc_ok_deleted']    = 'Documento eliminado correctamente';

$lang['rec_prog_replace_modal_title']  = 'Reemplazar documento';
$lang['rec_prog_replace_f_custom_name']= 'Nombre personalizado';
$lang['rec_prog_replace_f_new_file']   = 'Nuevo archivo';
$lang['rec_prog_replace_btn_save']     = 'Guardar cambios';

$lang['rec_prog_doc_err_not_found_simple'] = 'Documento no encontrado';
$lang['rec_prog_doc_err_upload_fail']      = 'No se pudo subir el archivo.';
$lang['rec_prog_doc_ok_updated']           = 'Documento actualizado';

// Modal aspirante
$lang['rec_prog_app_modal_title']        = 'Datos del aspirante';
$lang['rec_prog_app_f_req_select']       = 'Selecciona una Requisición :';
$lang['rec_prog_app_req_openings']       = 'Vacantes:';
$lang['rec_prog_app_no_reqs']            = 'Sin requisiones registradas';

$lang['rec_prog_app_f_first_names']      = 'Nombre(s) *';
$lang['rec_prog_app_f_lastname_1']       = 'Primer apellido *';
$lang['rec_prog_app_f_lastname_2']       = 'Segundo apellido';
$lang['rec_prog_app_f_address']          = 'Localización o domicilio *';
$lang['rec_prog_app_f_interest_area']    = 'Área de interés *';
$lang['rec_prog_app_f_contact_method']   = 'Medio de contacto *';
$lang['rec_prog_app_f_phone']            = 'Teléfono *';
$lang['rec_prog_app_f_email']            = 'Correo*';

// Comunes (si no existen ya)
$lang['rec_common_select']               = 'Selecciona';
$lang['rec_common_na']                   = 'N/A';
$lang['rec_common_save']                 = 'Guardar';

// addApplicant - labels (backend)
$lang['rec_prog_app_rule_requisition']     = 'Asignar requisición';
$lang['rec_prog_app_rule_name']            = 'Nombre(s)';
$lang['rec_prog_app_rule_lastname1']       = 'Primer apellido';
$lang['rec_prog_app_rule_lastname2']       = 'Segundo apellido';
$lang['rec_prog_app_rule_address']         = 'Localización o domicilio';
$lang['rec_prog_app_rule_interest']        = 'Área de interés';
$lang['rec_prog_app_rule_contact_method']  = 'Medio de contacto';
$lang['rec_prog_app_rule_phone']           = 'Teléfono';
$lang['rec_prog_app_rule_email']           = 'Correo';

// Validación (si no existe en tus lang globales)
$lang['rec_val_integer']                   = 'El campo {field} debe ser numérico';

// Negocio / respuestas
$lang['rec_prog_app_req_not_found']        = 'La requisición {req} no existe o no pertenece a este portal';
$lang['rec_prog_app_already_registered']   = 'Ya está registrado el aspirante para esta requisición';
$lang['rec_prog_status_registered']        = 'Registrado';
$lang['rec_prog_app_db_error']             = 'No se pudo registrar el aspirante (error BD).';
$lang['rec_prog_app_save_fail']            = 'No se pudo registrar el aspirante.';
$lang['rec_prog_app_saved_ok']             = 'El aspirante fue guardado correctamente.';
$lang['rec_prog_app_updated_ok']           = 'El aspirante fue actualizado correctamente :)';
$lang['rec_prog_app_updated_fail']         = 'El aspirante no pudo ser actualizado :(';

$lang['rec_common_problem_title'] = 'Hubo un problema';
$lang['rec_common_close']         = 'Cerrar';
$lang['rec_common_server_error_title']     = 'Error en el servidor';
$lang['rec_common_server_unexpected_reply']= 'Respuesta inesperada del servidor:';

$lang['rec_common_note_label'] = 'NOTA:';
$lang['rec_common_select']     = 'Selecciona';
$lang['rec_common_other']      = 'Otro';
$lang['rec_common_cancel']     = 'Cancelar';
$lang['rec_common_close']      = 'Cerrar';
$lang['rec_common_save']       = 'Guardar';

$lang['rec_prog_action_modal_title'] = 'Registro de acción al aspirante:';
$lang['rec_prog_action_note_success'] = 'En esta sección podrás registrar las acciones que se van tomando en el proceso de reclutamiento en base a este Aspirante.';
$lang['rec_prog_action_field_action'] = 'Acción a aplicar *';
$lang['rec_prog_action_placeholder_other_action'] = 'Escribe la acción';
$lang['rec_prog_action_field_comment'] = 'Comentario / Descripción / Fecha y lugar *';

$lang['rec_prog_action_note_warning_intro'] = 'Si la acción a registrar influye en el estatus o color del aspirante en bolsa de trabajo, o en el proceso, no olvides modificar los siguientes campos:';
$lang['rec_prog_action_note_candidate_status_title'] = 'Estatus del Aspirante';
$lang['rec_prog_action_note_candidate_status_desc']  = 'Este cambia el color y estatus del aspirante en bolsa de trabajo.';
$lang['rec_prog_action_note_process_status_title']    = 'Estatus del Proceso';
$lang['rec_prog_action_note_process_status_desc']     = 'Este cambia el estatus actual del proceso de reclutamiento.';

$lang['rec_prog_action_tip_candidate_status'] = 'El cambio realizado impactará directamente en la Bolsa de Trabajo, actualizando tanto el color como el estatus del aspirante';
$lang['rec_prog_action_label_candidate_status'] = 'Estatus del aspirante';

$lang['rec_prog_action_opt_waiting']              = 'En espera';
$lang['rec_prog_action_opt_caution']              = 'Precaucion';
$lang['rec_prog_action_opt_in_process']           = 'En proceso de reclutamiento';
$lang['rec_prog_action_opt_ready_pre_employment'] = 'Listo para iniciar el proceso de preempleo';
$lang['rec_prog_action_opt_block']                = 'Bloquear aspirante';

$lang['rec_prog_action_tip_process_status'] = "Esta opción se registra en este módulo 'En proceso' y se refleja en la columna 'Estatus Actual'";
$lang['rec_prog_action_label_process_status'] = 'Estatus proceso';
$lang['rec_prog_action_opt_completed'] = 'Completado';
$lang['rec_prog_action_opt_canceled']  = 'Cancelado';
$lang['rec_prog_action_opt_remove_final_status'] = 'Eliminar Estatus Final';

$lang['rec_prog_action_btn_register'] = 'Registrar';

$lang['rec_prog_history_modal_title'] = 'Historial de movimientos del aspirante:';

$lang['rec_prog_req_status_modal_title']  = 'Estatus de requisición';
$lang['rec_prog_req_status_field_req']    = 'Requisición *';
$lang['rec_prog_req_status_field_assign'] = 'Estatus a asignar *';
$lang['rec_prog_req_status_opt_finish']   = 'Terminar';
$lang['rec_prog_req_status_opt_cancel']   = 'Cancelar';
$lang['rec_prog_req_status_opt_delete']   = 'Eliminar';
$lang['rec_prog_req_status_field_comments'] = 'Comentarios *';

$lang['rec_common_na'] = 'N/A';
$lang['rec_common_apply'] = 'Aplicar';

$lang['rec_prog_candidate_modal_title'] = 'Registro de candidatos';
$lang['rec_prog_candidate_section_general'] = 'Datos generales';

$lang['rec_prog_candidate_f_first_name'] = 'Nombre (s) *';
$lang['rec_prog_candidate_f_lastname_1'] = 'Paterno*';
$lang['rec_prog_candidate_f_lastname_2'] = 'Materno';
$lang['rec_prog_candidate_f_subclient'] = 'Subcliente';
$lang['rec_prog_candidate_f_position'] = 'Posición*';
$lang['rec_prog_candidate_ph_specify_position'] = 'Especificar posición';
$lang['rec_prog_candidate_f_phone'] = 'Teléfono *';
$lang['rec_prog_candidate_f_country_residence'] = 'País de residencia *';
$lang['rec_prog_candidate_f_email'] = 'Correo*';
$lang['rec_prog_candidate_f_curp'] = 'CURP';
$lang['rec_prog_candidate_f_ssn'] = 'Número de Seguro Social (SSN)';

$lang['rec_prog_candidate_choose_option'] = 'Seleccione una de las siguientes opciones:';
$lang['rec_prog_candidate_opt_self_process_free'] = 'Registrar mi propio proceso - Gratis';
$lang['rec_prog_candidate_opt_prev_or_new_project'] = 'Seleccionar un proyecto anterior o crear uno nuevo / Enviado a RODI';
$lang['rec_prog_candidate_opt_drug_med_only'] = 'Registrar al candidato solo con Prueba de Drogas y/o Examen Médico / Enviado a RODI';

$lang['rec_prog_candidate_prev_project_title'] = 'Seleccionar un Proyecto Anterior';
$lang['rec_prog_candidate_rodi_cost_notice_1'] = 'Al enviar a RODI se genera un costo. Si no estás seguro de los costos, ponte en contacto con';
$lang['rec_prog_candidate_prev_projects_label'] = 'Proyectos previos';

$lang['rec_prog_candidate_new_project_title'] = 'Seleccionar un nuevo proyecto';
$lang['rec_prog_candidate_new_project_location'] = 'Ubicación *';
$lang['rec_prog_candidate_region_mexico'] = 'México';
$lang['rec_prog_candidate_region_international'] = 'Internacional';
$lang['rec_prog_candidate_new_project_country'] = 'País';
$lang['rec_prog_candidate_new_project_name'] = 'Nombre del proyecto *';

$lang['rec_prog_candidate_required_info_new_project'] = 'Información requerida para el nuevo proyecto';
$lang['rec_prog_candidate_required_info_note_1'] = 'Los documentos requeridos se agregarán automáticamente según las opciones seleccionadas. Los documentos extra son opcionales; selecciónalos antes de las pruebas complementarias.';

$lang['rec_prog_candidate_employment_history'] = 'Historial laboral *';
$lang['rec_prog_candidate_time_required'] = 'Tiempo requerido';
$lang['rec_prog_candidate_criminal_check'] = 'Antecedentes penales *';
$lang['rec_prog_candidate_address_history'] = 'Historial de domicilios *';
$lang['rec_prog_candidate_education_check'] = 'Validación de estudios *';
$lang['rec_prog_candidate_global_searches'] = 'Búsquedas globales *';
$lang['rec_prog_candidate_credit_check'] = 'Revisión de crédito *';
$lang['rec_prog_candidate_prof_refs_qty'] = 'Referencias profesionales (cantidad)';
$lang['rec_prog_candidate_personal_refs_qty'] = 'Referencias personales (cantidad)';
$lang['rec_prog_candidate_identity_check'] = 'Validación de identidad *';
$lang['rec_prog_candidate_migratory_form_check'] = 'Validación de forma migratoria (FM, FM2 o FM3) *';
$lang['rec_prog_candidate_prohibited_parties_check'] = 'Validación en listas restringidas *';
$lang['rec_prog_candidate_academic_refs_qty'] = 'Referencias académicas (cantidad)';
$lang['rec_prog_candidate_mvr_check'] = 'Historial vehicular (solo en algunas ciudades de México) *';
$lang['rec_prog_candidate_curp_check'] = 'Validación de CURP *';

$lang['rec_prog_candidate_extra_docs_title'] = 'Documentos extra';
$lang['rec_prog_candidate_extra_docs_label'] = 'Selecciona los documentos extra *';
$lang['rec_prog_candidate_extra_military'] = 'Cartilla militar';
$lang['rec_prog_candidate_extra_passport'] = 'Pasaporte';
$lang['rec_prog_candidate_extra_license'] = 'Cédula profesional';
$lang['rec_prog_candidate_extra_credential'] = 'Credencial académica / profesional';
$lang['rec_prog_candidate_extra_resume'] = 'Currículum';
$lang['rec_prog_candidate_extra_sex_offender'] = 'Registro de agresores sexuales';
$lang['rec_prog_candidate_extra_ssn'] = 'Número de Seguro Social';

$lang['rec_prog_candidate_tests_title'] = 'Pruebas complementarias';
$lang['rec_prog_candidate_test_drug'] = 'Prueba de drogas *';
$lang['rec_prog_candidate_test_medical'] = 'Examen médico *';
$lang['rec_prog_candidate_test_psychometric'] = 'Psicométrico *';

$lang['rec_prog_comments_modal_title'] = 'Historial de comentarios con respecto a:';
$lang['rec_prog_comments_f_new_comment'] = 'Registra un nuevo comentario o estatus *';
$lang['rec_prog_comments_btn_save'] = 'Guardar comentario';

$lang['rec_prog_hist_tbl_date']    = 'Fecha';
$lang['rec_prog_hist_tbl_user']    = 'Usuario';
$lang['rec_prog_hist_tbl_comment'] = 'Comentario / Estatus';
$lang['rec_prog_hist_no_comments'] = 'Sin comentarios';

$lang['rec_prog_upload_modal_title']    = 'Carga y nombra tus archivos';
$lang['rec_prog_upload_select_files']   = 'Selecciona uno o varios archivos';
$lang['rec_prog_upload_allowed_types']  = 'Tipos permitidos: PDF, imágenes y videos.';
$lang['rec_prog_upload_th_file']        = 'Archivo';
$lang['rec_prog_upload_th_size']        = 'Tamaño';
$lang['rec_prog_upload_th_custom_name'] = 'Nombre personalizado';
$lang['rec_prog_upload_th_actions']     = 'Acciones';
$lang['rec_prog_upload_empty']          = 'Sin archivos seleccionados…';
$lang['rec_prog_upload_btn_upload']     = 'Subir archivos';

$lang['rec_prog_upload_placeholder_custom_name'] = 'Ejemplo: CV, Comprobante, etc.';
$lang['rec_prog_upload_remove_file_aria']        = 'Quitar archivo';

$lang['rec_prog_upload_swal_no_files_title'] = 'Sin archivos';
$lang['rec_prog_upload_swal_no_files_text']  = 'Selecciona al menos un archivo.';

$lang['rec_prog_upload_swal_name_required_title'] = 'Nombre requerido';
$lang['rec_prog_upload_swal_name_required_text']  = 'Define un nombre personalizado para cada archivo.';

$lang['rec_prog_upload_btn_uploading'] = 'Subiendo...';

$lang['rec_prog_upload_swal_success_title']        = '¡Éxito!';
$lang['rec_prog_upload_swal_success_text_default'] = 'Archivos cargados.';
$lang['rec_prog_upload_swal_success_all']          = 'Todos los archivos cargados.';

$lang['rec_prog_upload_swal_partial_title'] = 'Carga parcial';

$lang['rec_prog_upload_swal_error_title']        = 'Error';
$lang['rec_prog_upload_swal_error_text_default'] = 'No se pudo completar la carga.';

$lang['rec_prog_upload_swal_server_error_title']        = 'Error de servidor';
$lang['rec_prog_upload_swal_server_error_text_default'] = 'Intenta de nuevo.';

$lang['rec_prog_hist_field_comment_status'] = 'Comentario / Estatus';

$lang['rec_prog_val_required_msg']   = 'El campo {field} es obligatorio';
$lang['rec_prog_val_max_length_msg'] = 'El campo {field} debe tener máximo {param} carácteres';
$lang['rec_prog_val_numeric_msg']    = 'El campo {field} debe ser numérico';

$lang['rec_prog_hist_save_ok_prefix'] = 'El registro se realizó correctamente. ';

$lang['rec_prog_hist_notify_not_sent_no_data'] =
'El registro se realizó correctamente. La notificación no fue enviada porque no se encontraron datos válidos para notificar.';

$lang['rec_prog_hist_notify_not_sent_disabled'] =
'El registro se realizó correctamente. La notificación no fue enviada.';

$lang['rec_prog_hist_save_fail'] = 'No se pudo registrar el comentario, intente más tarde.';


$lang['rec_prog_bolsa_status_blocked_text'] = 'Bloqueado del proceso de reclutamiento';

$lang['rec_prog_bolsa_hist_action_user_blocks'] =
'Usuario bloquea a la persona del proceso de reclutamiento';

$lang['rec_prog_bolsa_block_ok']   = 'Se ha bloqueado correctamente';
$lang['rec_prog_bolsa_unblock_ok'] = 'Se ha desbloqueado correctamente';

$lang['rec_prog_bolsa_block_reason_required'] =
'Debes llenar el motivo de bloqueo e intentarlo de nuevo';

$lang['rec_prog_adm_modal_title'] = 'Información de ingreso al empleo del candidato:';
$lang['rec_prog_adm_warranty_history_title'] = 'Registros del estatus de la garantía';

$lang['rec_prog_adm_salary_agreed'] = 'Sueldo acordado';
$lang['rec_prog_adm_company_start_date'] = 'Fecha de ingreso a la empresa';
$lang['rec_prog_adm_payment'] = 'Pago';

$lang['rec_prog_adm_warranty_status'] = 'Estatus de la garantia';

$lang['rec_prog_adm_btn_save_info'] = 'Guardar información';

$lang['rec_prog_btn_close'] = 'Cerrar';
$lang['rec_prog_btn_close_aria'] = 'Cerrar';

$lang['rec_prog_swal_delete_confirm_title'] = '¿Estás seguro?';
$lang['rec_prog_swal_delete_confirm_text'] = '¡Esta acción no se puede deshacer!';
$lang['rec_prog_swal_delete_confirm_btn_yes_continue'] = 'Sí, continuar';

$lang['rec_prog_swal_delete_confirm2_title'] = '¿Realmente deseas eliminar el registro?';
$lang['rec_prog_swal_delete_confirm2_text'] = 'Esta acción es definitiva.';
$lang['rec_prog_swal_delete_confirm2_btn_yes_delete'] = 'Sí, eliminar';

$lang['rec_prog_swal_btn_cancel'] = 'Cancelar';

$lang['rec_prog_swal_deleted_title'] = 'Eliminado';
$lang['rec_prog_swal_attention_title'] = 'Atención';

$lang['rec_prog_swal_error_title'] = 'Error';
$lang['rec_prog_swal_unexpected_server_response'] = 'Respuesta inesperada del servidor.';
$lang['rec_prog_swal_delete_ajax_error'] = 'Ocurrió un error al eliminar.';

$lang['rec_prog_warranty_th_date'] = 'Fecha registro';
$lang['rec_prog_warranty_th_user'] = 'Usuario';
$lang['rec_prog_warranty_th_desc_status'] = 'Descripción / Estatus';
$lang['rec_prog_warranty_no_records'] = 'Sin registros';
$lang['rec_common_role_client']    = 'Cliente';
$lang['rec_common_role_recruiter'] = 'Reclutador';
$lang['rec_mov_delete_ok']   = 'El registro ha sido eliminado correctamente.';
$lang['rec_mov_delete_fail'] = 'No se pudo eliminar el registro.';
$lang['rec_action_saved_ok']   = 'Acción registrada correctamente.';
$lang['rec_action_saved_fail'] = 'Hubo un problema, no se registró la acción.';

$lang['rec_req_rule_requisition'] = 'Requisición';
$lang['rec_req_rule_status']      = 'Estatus a asignar';
$lang['rec_req_rule_comments']    = 'Comentarios';

$lang['fv_required']    = 'El campo {field} es obligatorio';
$lang['fv_max_length']  = 'El campo {field} debe tener máximo {param} carácteres';
$lang['fv_numeric']     = 'El campo {field} debe ser numérico';

$lang['rec_req_cancel_ok']        = 'La requisición fue cancelada correctamente';
$lang['rec_req_delete_ok']        = 'La requisición fue eliminada correctamente';
$lang['rec_req_finish_ok']        = 'La requisición fue terminada correctamente';
$lang['rec_req_cannot_close']     = 'No se puede cerrar la requisición porque falta información:';

$lang['rec_req_missing_salary']     = 'no tiene registrado el sueldo acordado.';
$lang['rec_req_missing_entry_date'] = 'no tiene registrada la fecha de ingreso.';
$lang['rec_req_candidate_prefix']   = 'El candidato <b>{name}</b> ';
$lang['rec_req_missing_vacancies']  = 'Faltan {n} vacantes por cubrir con candidatos completos.';
