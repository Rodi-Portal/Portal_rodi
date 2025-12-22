<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['suc_title'] = 'Branch / Client Administration';

$lang['suc_btn_links_all']    = 'Create / Update Links';
$lang['suc_btn_create_branch'] = 'Create Branch';

$lang['suc_description'] =
'This module allows full management of external users and branches, with features to register, update, delete, and keep information organized and efficient.';

/* Send credentials modal */
$lang['suc_modal_send_credentials_title'] = 'Register';
$lang['suc_lbl_generate_password']        = 'Generate Password*';
$lang['suc_btn_generate']                 = 'Generate';
$lang['suc_btn_cancel']                   = 'Cancel';
$lang['suc_btn_resend_password']           = 'Resend password';

/* DataTable columns */
$lang['suc_col_id']         = 'ID';
$lang['suc_col_name']       = 'Name';
$lang['suc_col_key']        = 'Key';
$lang['suc_col_created_at'] = 'Creation date';
$lang['suc_col_access']     = 'Access';
$lang['suc_col_actions']    = 'Actions';

/* DataTable texts */
$lang['suc_access_none'] = 'No access found';
$lang['suc_access_has']  = 'Has {count} access(es)';

/* Action tooltips */
$lang['suc_tt_edit']            = 'Update';
$lang['suc_tt_activate']        = 'Activate';
$lang['suc_tt_deactivate']      = 'Deactivate';
$lang['suc_tt_delete_client']   = 'Delete branch';
$lang['suc_tt_view_access']     = 'View access';
$lang['suc_tt_block_client']    = 'Block branch';
$lang['suc_tt_unblock_client']  = 'Unblock branch';
$lang['suc_tt_generate_link']   = 'Generate link';
$lang['suc_tt_generar_usuario'] = 'Generate user';

/* Swal / messages */
$lang['suc_saved_ok'] = 'Saved successfully';

/* DataTables UI */
$lang['dt_lengthMenu']   = 'Show _MENU_ entries';
$lang['dt_zeroRecords']  = 'No records found';
$lang['dt_info']         = 'Showing _START_ to _END_ of _TOTAL_ entries';
$lang['dt_infoEmpty']    = 'No entries available';
$lang['dt_infoFiltered'] = '(filtered from _MAX_ total entries)';
$lang['dt_search']       = 'Search:';
$lang['dt_last']         = 'Last page';
$lang['dt_first']        = 'First';
$lang['dt_next']         = 'Next';
$lang['dt_previous']     = 'Previous';


$lang['suc_modal_title_edit_client'] = 'Update branch Information';
$lang['suc_modal_title_new_client']  = 'New branch';
$lang['suc_links_generating_title'] = 'Generating links, please wait…';
$lang['suc_links_generating_text'] = 'This may take a few seconds.';
$lang['suc_loading'] = 'Loading…';

$lang['suc_links_label_link']        = 'Link:';
$lang['suc_links_label_qr']          = 'QR:';
$lang['suc_links_qr_not_available']  = 'QR not available';
$lang['suc_links_expires']           = 'Expires: {date}';
$lang['suc_links_none']              = 'No links generated';
$lang['suc_links_error_load']        = 'Error loading links';

$lang['suc_btn_copy']   = 'Copy';
$lang['suc_btn_copied'] = 'Copied!';

$lang['suc_missing_id_cliente'] = 'Missing id';

$lang['suc_sw_error_title']          = 'Error';
$lang['suc_sw_success_title']        = 'Done!';
$lang['suc_sw_link_generated']       = 'Link generated.';
$lang['suc_sw_link_generate_failed'] = 'Could not generate link.';
$lang['suc_sw_link_confirm_title']   = 'Generate/update link?';
$lang['suc_sw_link_confirm_text']    = 'The previous link and QR will become obsolete.';
$lang['suc_sw_confirm_yes']          = 'Yes, continue';
$lang['suc_sw_confirm_cancel']       = 'Cancel';

$lang['suc_access_modal_none']       = 'No access.';
$lang['suc_access_modal_error_load'] = 'Error loading access.';
$lang['suc_access_no_records']       = 'No access records';

$lang['suc_access_tbl_name']     = 'Name';
$lang['suc_access_tbl_email']    = 'Email';
$lang['suc_access_tbl_created']  = 'Created';
$lang['suc_access_tbl_user']     = 'User';
$lang['suc_access_tbl_category'] = 'Category';
$lang['suc_access_tbl_actions']  = 'Actions';

$lang['suc_access_pending_register'] = 'Pending registration';
$lang['suc_access_privacy_level']    = 'Level {level}';
$lang['suc_access_privacy_none']     = 'No privacy';

$lang['suc_updated_ok'] = 'Updated successfully';

/* Confirmaciones (modal #mensajeModal) */
$lang['suc_confirm_activate_title'] = 'Activate branch';
$lang['suc_confirm_activate_text']  = 'Do you want to activate branch {name}?';

$lang['suc_confirm_deactivate_title'] = 'Deactivate branch';
$lang['suc_confirm_deactivate_text']  = 'Do you want to deactivate branch {name}?';

$lang['suc_confirm_delete_title'] = 'Delete clbranchient';
$lang['suc_confirm_delete_text']  = 'Do you want to delete branch {name}?';

$lang['suc_confirm_delete_user_title'] = 'Delete user';
$lang['suc_confirm_delete_user_text']  = 'Do you want to delete user {name}?';

/* Bloqueo / desbloqueo (campos extra dentro del modal) */
$lang['suc_confirm_block_title'] = 'Block branch';
$lang['suc_confirm_block_text']  = 'Do you want to block branch {name}?';

$lang['suc_block_reason_lbl']   = 'Block reason *';
$lang['suc_block_message_lbl']  = 'Message to show in branch panel *';
$lang['suc_block_message_default'] = 'We are sorry! Your access has been suspended due to non-payment. Please contact 33 3454 2877.';
$lang['suc_block_subclients_lbl'] = 'Also block subclients/providers';

$lang['suc_confirm_unblock_title'] = 'Unblock branch';
$lang['suc_confirm_unblock_text']  = 'Do you want to unblock branch {name}?';
$lang['suc_unblock_reason_lbl']    = 'Unblock reason *';

$lang['suc_select_placeholder'] = 'Select';

/* Modal reenviar contraseña (enviarCredenciales) */
$lang['suc_modal_resend_password_title'] = 'Resend password';
$lang['suc_modal_resend_password_text']  = 'Do you want to update the password for user <b>{email}</b>?';

/* Errores genéricos usados en AJAX */
$lang['suc_sw_comm_error'] = 'Communication error with the server.';

$lang['suc_user_saved_ok'] = 'User saved successfully';
$lang['suc_error_action']  = 'Error while performing the action';

$lang['suc_close'] = 'Close';

$lang['suc_newmodal_intro'] = 'Welcome to the registration of a new branch/client or the update of an existing one! We are here to make the process easier. You may complete the form partially if you wish. Fields marked with an asterisk (*) are required: Name and Key.';

$lang['suc_lbl_branch_name'] = 'Branch/Client name';
$lang['suc_field_branch_name'] = 'Branch name';
$lang['suc_ph_branch_name'] = 'Enter the branch name';

$lang['suc_lbl_max_employees'] = 'Maximum number of employees';
$lang['suc_field_max_employees'] = 'Maximum number of employees';
$lang['suc_ph_max_employees'] = 'Maximum number of employees';

$lang['suc_lbl_key'] = 'Key';
$lang['suc_field_key'] = 'Key';
$lang['suc_ph_key'] = 'Enter the branch key';

$lang['suc_lbl_email'] = 'Email';
$lang['suc_field_email'] = 'Email';
$lang['suc_ph_email'] = 'Enter the email address';

$lang['suc_note_title'] = 'Note';
$lang['suc_note_recruitment'] = 'The fields email and password are only required if the recruitment and pre-employment modules are active.';

$lang['suc_field_password'] = 'Password';
$lang['suc_aria_show_password'] = 'Show password';
$lang['suc_btn_show'] = ' Show';
$lang['suc_btn_hide'] = ' Hide';

$lang['suc_lbl_razon_social'] = 'Company name';
$lang['suc_ph_razon_social'] = 'Enter the company name';

$lang['suc_lbl_phone'] = 'Phone';
$lang['suc_ph_phone'] = 'Enter the phone number';

$lang['suc_lbl_contact_name'] = 'Contact name';
$lang['suc_ph_contact_name'] = 'Name';

$lang['suc_lbl_contact_lastname'] = 'Contact last name';
$lang['suc_ph_contact_lastname'] = 'Last name';

$lang['suc_lbl_rfc'] = 'RFC';
$lang['suc_ph_rfc'] = 'Enter the RFC';

$lang['suc_lbl_regimen'] = 'Tax regime';
$lang['suc_ph_regimen'] = 'Enter the tax regime';

$lang['suc_lbl_forma_pago'] = 'Payment form';
$lang['suc_opt_forma_pago_single'] = 'Single payment';
$lang['suc_opt_forma_pago_partial'] = 'Installments / deferred';

$lang['suc_lbl_metodo_pago'] = 'Payment method';
$lang['suc_opt_metodo_efectivo'] = 'Cash';
$lang['suc_opt_metodo_cheque'] = 'Payroll check';
$lang['suc_opt_metodo_transfer'] = 'Bank transfer';
$lang['suc_opt_metodo_credit'] = 'Credit card';
$lang['suc_opt_metodo_debit'] = 'Debit card';
$lang['suc_opt_metodo_tbd'] = 'To be defined';

$lang['suc_lbl_uso_cfdi'] = 'CFDI use';
$lang['suc_ph_uso_cfdi'] = 'Enter CFDI use';

$lang['suc_lbl_country'] = 'Country';
$lang['suc_ph_country'] = 'Enter your country';

$lang['suc_lbl_state'] = 'State';
$lang['suc_ph_state'] = 'Enter your state';

$lang['suc_lbl_city'] = 'City';
$lang['suc_ph_city'] = 'Enter your city';

$lang['suc_lbl_colony'] = 'Neighborhood';
$lang['suc_ph_colony'] = 'Enter the neighborhood';

$lang['suc_lbl_street'] = 'Street';
$lang['suc_ph_street'] = 'Enter the street';

$lang['suc_lbl_ext_number'] = 'Exterior number';
$lang['suc_ph_ext_number'] = 'Enter exterior number';

$lang['suc_lbl_int_number'] = 'Interior number';
$lang['suc_ph_int_number'] = 'Enter interior number';

$lang['suc_lbl_zip'] = 'ZIP code';
$lang['suc_ph_zip'] = 'Enter ZIP code';

$lang['suc_btn_back'] = 'Back';
$lang['suc_btn_continue'] = 'Continue';

$lang['suc_step1_title'] = 'Branch information';
$lang['suc_step2_title'] = 'Contact information';
$lang['suc_step3_title'] = 'Address';

$lang['suc_btn_finish'] = 'Finish';
$lang['suc_btn_ok']     = 'OK';
$lang['suc_btn_close']  = 'Close';

$lang['suc_sw_problem_title']  = 'There was a problem';
$lang['suc_sw_invalid_field']  = 'The field <b>{field}</b> is not valid';
$lang['suc_sw_unknown_error']  = 'An error occurred.';
$lang['suc_field_unknown']     = 'this field';

$lang['suc_states_of'] = 'States of: {country}';
$lang['suc_cities_of'] = 'Cities of: {state}';
$lang['suc_pending']   = 'Pending';

$lang['suc_btn_confirm'] = 'Confirm';
$lang['suc_access_modal_branch_label'] = 'Branch';
$lang['suc_btn_save'] = 'Save';

$lang['suc_access_create_title'] = 'Branch/Client credentials registration';
$lang['suc_access_lbl_branch'] = 'Branch';
$lang['suc_access_lbl_name'] = 'Name';
$lang['suc_access_lbl_lastname'] = 'First last name';
$lang['suc_access_lbl_spectator'] = 'Spectator';
$lang['suc_access_lbl_privacy'] = 'Candidate visibility privacy';
$lang['suc_access_lbl_email'] = 'Email';
$lang['suc_access_lbl_phone'] = 'Phone';

$lang['suc_access_password_note'] = '* The password will be sent to the email specified here. Verify it is correct and accessible.';

$lang['suc_access_privacy_0']  = 'No privacy (Visible to users/branch without privacy and Level 1)';
$lang['suc_access_privacy_1']  = 'Level 1 (Full visibility of candidates)';
$lang['suc_access_privacy_2']  = 'Level 2 (Candidates visible to Level 2 and 1)';
$lang['suc_access_privacy_3']  = 'Level 3 (Candidates visible to Level 3 and 1)';
$lang['suc_access_privacy_4']  = 'Level 4 (Candidates visible to Level 4 and 1)';
$lang['suc_access_privacy_5']  = 'Level 5 (Candidates visible to Level 5 and 1)';
$lang['suc_access_privacy_6']  = 'Level 6 (Candidates visible to Level 6 and 1)';
$lang['suc_access_privacy_7']  = 'Level 7 (Candidates visible to Level 7 and 1)';
$lang['suc_access_privacy_8']  = 'Level 8 (Candidates visible to Level 8 and 1)';
$lang['suc_access_privacy_9']  = 'Level 9 (Candidates visible to Level 9 and 1)';
$lang['suc_access_privacy_10'] = 'Level 10 (Candidates visible to Level 10 and 1)';

$lang['suc_links_modal_title'] = 'Links for requisition form';
$lang['suc_links_generated_label'] = 'Generated links';
$lang['suc_links_btn_generate_update'] = 'Generate/Update';

$lang['suc_guc_title'] = 'Generate user for ';
$lang['suc_guc_lbl_name'] = 'Name';
$lang['suc_guc_lbl_lastname'] = 'Last name';
$lang['suc_guc_lbl_email'] = 'Email';
$lang['suc_guc_email_help'] = 'It will be used as the login username.';
$lang['suc_guc_lbl_phone'] = 'Phone';
$lang['suc_guc_ph_phone'] = '33 1234 5678';

$lang['suc_guc_lbl_password'] = 'Password';
$lang['suc_guc_ph_password'] = 'Min. 9 chars with Upper/Lower/Number/Symbol';
$lang['suc_guc_pass_help'] = 'Must include: uppercase, lowercase, number and symbol.';
$lang['suc_guc_pass_invalid'] = 'Password does not meet the requirements.';

$lang['suc_guc_lbl_password_confirm'] = 'Confirm password';
$lang['suc_guc_pass_mismatch'] = 'Passwords do not match.';

$lang['suc_guc_info'] = 'The user will be created and associated with this branch. If the email already exists, registration will be blocked.';
$lang['suc_guc_btn_submit'] = 'Generate user';

$lang['suc_guc_tt_toggle'] = 'Show/hide';
$lang['suc_guc_js_show'] = 'Show password';
$lang['suc_guc_js_hide'] = 'Hide password';

$lang['suc_api_missing_id_portal']         = 'Missing id_portal in session.';
$lang['suc_api_no_clients_to_process']     = 'There are no branches to process.';
$lang['suc_api_invalid_id_cliente']        = 'Invalid id.';
$lang['suc_api_link_generate_failed_item'] = 'Could not generate link.';
$lang['suc_api_process_done_with_errors']  = 'Process finished with errors.';
$lang['suc_api_process_done_ok']           = 'Process completed successfully.';
$lang['suc_links_ok']   = 'Success';
$lang['suc_links_fail'] = 'Errors';

$lang['suc_btn_accept'] = 'Accept';

/* generarLinkstodos() */

$lang['suc_links_done_with_errors']     = 'Process finished with errors.';
$lang['suc_links_done_ok']              = 'Process completed successfully.';

$lang['suc_links_view_link']            = 'View link';
$lang['suc_links_unknown_error']        = 'Unknown error';
$lang['suc_links_no_items']             = 'No items.';

$lang['suc_links_tbl_id']               = 'Branch ID';
$lang['suc_links_tbl_status']           = 'Status';
$lang['suc_links_tbl_detail']           = 'Detail / Link';

$lang['suc_links_done_warn_title']      = 'Process completed with warnings';

$lang['suc_links_request_error']        = 'There was a problem processing the request.';

/* ya las tenías pendientes */

// CI3 validation
$lang['fv_required']     = 'The {field} field is required';
$lang['fv_max_length']   = 'The {field} field must be at most {param} characters.';
$lang['fv_valid_email']  = 'The {field} field must contain a valid email address.';
$lang['fv_check_nombre_unique'] = 'The Branch/Client name already exists.';

// Labels
$lang['fv_field_nombre']   = 'Branch/Client name';
$lang['fv_field_clave']    = 'Key';
$lang['fv_field_correo']   = 'Email';
$lang['fv_field_password'] = 'Password';
$lang['fv_field_empleados']= 'Maximum number of employees';
$lang['fv_field_pais']     = 'Country';
$lang['fv_field_estado']   = 'State';
$lang['fv_field_ciudad']   = 'City';
$lang['fv_field_colonia']  = 'Neighborhood';
$lang['fv_field_calle']    = 'Street';
$lang['fv_field_num_ext']  = 'Exterior number';
$lang['fv_field_num_int']  = 'Interior number';
$lang['fv_field_cp']       = 'ZIP code';
$lang['fv_field_razon_social'] = 'Company name';
$lang['fv_field_telefono'] = 'Phone';
$lang['fv_field_nombre_contacto']   = 'Contact name';
$lang['fv_field_apellido_contacto'] = 'Contact last name';
$lang['fv_field_rfc']      = 'RFC';
$lang['fv_field_regimen']  = 'Tax regime';
$lang['fv_field_forma_pago']  = 'Payment form';
$lang['fv_field_metodo_pago'] = 'Payment method';
$lang['fv_field_uso_cfdi']    = 'CFDI use';

// setCliente messages
$lang['cli_email_exists']       = 'The provided email already exists';
$lang['cli_updated_ok']         = 'Branch/Client updated successfully';
$lang['cli_created_ok_sent']    = 'Branch/Client created successfully. Credentials were sent to {email}';
$lang['cli_create_error']       = 'Error while creating the Branch/Client';
$lang['cli_name_or_key_exists'] = 'The branch/client name and/or key already exists';

$lang['cli_email_exists']        = 'The provided email already exists';
$lang['cli_updated_ok']          = 'Branch/Client updated successfully';
$lang['cli_created_ok_sent']     = 'Branch/Client created successfully. Credentials were sent to {email}';
$lang['cli_create_error']        = 'Error while creating the branch/client';
$lang['cli_name_or_key_exists']  = 'The branch/client name and/or key already exists';

// ===== guardarDatos messages =====
$lang['gd_file_required']  = 'Please upload your file in the corresponding section.';
$lang['gd_upload_failed']  = 'File upload failed. Please try again.';
$lang['gd_saved_ok']       = 'Data and file were saved successfully :)';
$lang['gd_update_failed']  = 'There was a problem updating the data. Please try again.';

$lang['cli_status_invalid_request'] = 'Invalid request.';
$lang['cli_status_unknown_action']  = 'Invalid action.';

$lang['cli_status_deactivated_ok']  = 'Branch/Client deactivated successfully';
$lang['cli_status_activated_ok']    = 'Branch/Client activated successfully';
$lang['cli_status_deleted_ok']      = 'Branch/Client deleted successfully';
$lang['cli_status_blocked_ok']      = 'Branch/Client blocked successfully';
$lang['cli_status_unblocked_ok']    = 'Branch/Client unblocked successfully';

$lang['guc_invalid_client']            = 'Invalid client.';
$lang['guc_name_last_required']        = 'First name and last name are required.';
$lang['guc_invalid_email']             = 'Invalid email.';
$lang['guc_pass_not_valid']            = 'Password does not meet the requirements.';
$lang['guc_pass_not_match']            = 'Password confirmation does not match.';
$lang['guc_email_exists_use_other']    = 'This email is already registered. Use another one.';
$lang['guc_email_exists']              = 'This email is already registered.';
$lang['guc_cannot_create_user']        = 'Could not create the user.';
$lang['guc_cannot_generate_user']      = 'Could not generate the user.';
$lang['guc_user_created_and_linked']   = 'User created and linked successfully.';
$lang['guc_no_email_associated']     = 'There is no email associated with this user.';

$lang['acc_invalid_user_client']      = 'Invalid user/client ID.';
$lang['acc_user_deleted_ok']          = 'User deleted successfully.';
$lang['acc_credentials_updated_ok']   = 'Credentials updated successfully.';
$lang['acc_invalid_action']           = 'Invalid action.';

$lang['links_invalid_client_id']      = 'Invalid client ID';

// ===== Requisition: generate link =====
$lang['suc_req_missing_field']      = 'Missing {field}.';
$lang['suc_req_private_key_error']  = 'Could not load the JWT private key.';
$lang['suc_req_missing_form_url']   = 'Missing LINKNUEVAREQUISICION.';
$lang['suc_req_save_link_error']    = 'Could not save the link.';
$lang['suc_req_link_ok']            = 'Link generated/updated successfully.';

// ===== Update password =====
$lang['ap_field_id']    = 'ID';
$lang['ap_field_email'] = 'Email';
$lang['ap_field_pass']  = 'Password';

$lang['fv_required_sprintf'] = 'The %s field is required';

$lang['ap_email_missing'] = 'Email is missing.';
$lang['ap_pass_sent_to']  = 'The new password was sent to {email}';
$lang['ap_pass_update_fail_support'] = 'Could not update the password. Please contact soporte@talentsafecontrol.com';
$lang['ap_no_email_cannot_send'] = 'There is no associated email. The password cannot be sent.';
$lang['fv_valid_email_sprintf']  = 'The %s field must be a valid email';
