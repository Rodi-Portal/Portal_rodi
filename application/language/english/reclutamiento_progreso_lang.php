<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['rec_prog_title'] = 'Requisitions in progress';

$lang['rec_prog_btn_register_applicant'] = 'Register applicant to requisition';
$lang['rec_prog_btn_change_req_status']  = 'Change requisition status';

$lang['rec_prog_intro'] = 'This module helps manage ongoing job requisitions, allowing key actions such as changing status, closing, canceling, and assigning applicants. It also provides tools to track and share recruitment progress with the requester by logging movements, sending candidates to background screening, uploading CVs, and adding comments. Recruiters can add applicants to the requisition so the requester can see progress in an agile and organized way.';

$lang['rec_prog_filter_select_req'] = 'Select a requisition';
$lang['rec_prog_filter_all']        = 'All';

$lang['rec_prog_openings_label'] = 'Openings:';

$lang['rec_prog_table_title'] = '';


$lang['rec_prog_col_id']             = '#';
$lang['rec_prog_col_applicant']      = 'Applicant';
$lang['rec_prog_col_branch_client']  = 'Branch/Client';
$lang['rec_prog_col_position']       = 'Position';
$lang['rec_prog_col_contact']        = 'Contact';
$lang['rec_prog_col_actions']        = 'Actions';
$lang['rec_prog_col_current_status'] = 'Current status';

$lang['rec_prog_openings_label_lower'] = 'openings';

$lang['rec_prog_contact_phone']   = 'Phone';
$lang['rec_prog_contact_email']   = 'Email';
$lang['rec_prog_contact_channel'] = 'Channel';

$lang['rec_prog_not_registered']    = 'Not registered';
$lang['rec_prog_status_registered'] = 'Registered';

$lang['rec_prog_actions_btn'] = 'Actions';

$lang['rec_prog_action_upload_docs'] = 'Upload documents';
$lang['rec_prog_tt_upload_docs']     = 'Upload documents';

$lang['rec_prog_tt_delete']           = 'Delete';
$lang['rec_prog_action_delete_match'] = 'Delete match';

$lang['rec_prog_action_update_docs'] = 'Update documents';
$lang['rec_prog_tt_update_docs']     = 'Update documents';

$lang['rec_prog_action_client_comments'] = 'Client comments';

$lang['rec_prog_action_view_history'] = 'View movement history';
$lang['rec_prog_tt_view_history']     = 'View movement history';

$lang['rec_prog_action_send_preemployment'] = 'Send to Pre-employment';
$lang['rec_prog_tt_send_preemployment']     = 'Send to the Pre-employment module for candidates with or without prior records before hiring.';

$lang['rec_prog_action_entry_record'] = 'Entry record';
$lang['rec_prog_tt_entry_record']     = 'Candidate entry data record';

$lang['rec_prog_action_edit_applicant'] = 'Edit applicant';
$lang['rec_prog_tt_edit_applicant']     = 'Edit applicant';

$lang['rec_prog_action_register_moves'] = 'Register movements';
$lang['rec_prog_tt_register_moves']     = 'Register a step in the applicant process';

$lang['rec_prog_msg_ese_finished'] = 'BGC completed';

$lang['rec_prog_hist_date']   = 'Date';
$lang['rec_prog_hist_status'] = 'Status';
$lang['rec_prog_hist_desc']   = 'Comment / Description / Date and place';
$lang['rec_prog_hist_delete'] = 'Delete movement';
$lang['rec_prog_hist_none']   = 'No movements';

$lang['rec_prog_opt_na']             = 'N/A';
$lang['rec_prog_opt_other']          = 'Other';
$lang['rec_prog_opt_select']         = 'Select';
$lang['rec_prog_select_placeholder'] = 'Select an option';
$lang['rec_prog_no_positions']       = 'No positions registered';

$lang['rec_prog_dt_length']        = 'Show _MENU_ entries per page';
$lang['rec_prog_dt_zero']          = 'No records found';
$lang['rec_prog_dt_info']          = 'Showing _START_ to _END_ of _TOTAL_ entries';
$lang['rec_prog_dt_info_empty']    = 'No entries available';
$lang['rec_prog_dt_info_filtered'] = '(filtered from _MAX_ total entries)';
$lang['rec_prog_dt_search']        = 'Search:';
$lang['rec_prog_dt_last']          = 'Last page';
$lang['rec_prog_dt_first']         = 'First';
$lang['rec_prog_dt_next']          = 'Next';
$lang['rec_prog_dt_prev']          = 'Previous';

$lang['rec_prog_docs_loading']         = 'Loading…';
$lang['rec_prog_docs_none']            = 'No documents';
$lang['rec_prog_docs_download']        = 'Download';
$lang['rec_prog_docs_replace_tt']      = 'Replace file';
$lang['rec_prog_docs_delete_tt']       = 'Delete file';

$lang['rec_prog_docs_updated_title']   = 'Updated';
$lang['rec_prog_docs_view_updated_ok'] = 'View updated successfully';
$lang['rec_prog_docs_view_update_fail']= 'Could not update the view.';

$lang['rec_prog_docs_load_fail']       = 'Could not load the documents';

$lang['rec_prog_common_error_title']   = 'Error';

$lang['rec_prog_docs_modal_title']        = 'Applicant documents';
$lang['rec_prog_docs_th_custom_name']     = 'Custom name';
$lang['rec_prog_docs_th_file']            = 'File';
$lang['rec_prog_docs_th_date']            = 'Date';
$lang['rec_prog_docs_th_visible_branch']  = 'Visible to branch';
$lang['rec_prog_docs_th_actions']         = 'Actions';

$lang['rec_common_close_x']               = '&times;';

// SweetAlert - generic
$lang['rec_prog_swal_confirm_title']              = 'Are you sure?';
$lang['rec_prog_swal_warning_title']              = 'Warning';

// Delete applicant
$lang['rec_prog_swal_confirm_delete_applicant']   = 'You are about to delete this applicant';
$lang['rec_prog_swal_warning_applicant_hide']     = 'The applicant will disappear from this list and the client/branch will no longer be able to see them';
$lang['rec_prog_applicant_deleted_ok']            = 'The applicant was deleted successfully';
$lang['rec_prog_applicant_delete_fail']           = 'The applicant could not be deleted. Please try again.';

// Delete file
$lang['rec_prog_file_delete_warn']                = 'This action will permanently delete the file.';
$lang['rec_prog_file_deleted_ok']                 = 'File deleted successfully';
$lang['rec_prog_file_delete_fail']                = 'The file could not be deleted.';

// Commons (if you don’t already have them)
$lang['rec_common_yes_delete']                    = 'Yes, delete';
$lang['rec_common_cancel']                        = 'Cancel';
$lang['rec_common_accept']                        = 'OK';
$lang['rec_common_deleted_title']                 = 'Deleted';
$lang['rec_common_error_title']                   = 'Error';

$lang['rec_prog_doc_err_no_id']     = 'ID not provided';
$lang['rec_prog_doc_err_not_found'] = 'Document not found or it was already deleted';
$lang['rec_prog_doc_ok_deleted']    = 'Document deleted successfully';

$lang['rec_prog_replace_modal_title']   = 'Replace document';
$lang['rec_prog_replace_f_custom_name'] = 'Custom name';
$lang['rec_prog_replace_f_new_file']    = 'New file';
$lang['rec_prog_replace_btn_save']      = 'Save changes';

$lang['rec_prog_doc_err_not_found_simple'] = 'Document not found';
$lang['rec_prog_doc_err_upload_fail']      = 'Could not upload the file.';
$lang['rec_prog_doc_ok_updated']           = 'Document updated';

// Applicant modal
$lang['rec_prog_app_modal_title']        = 'Applicant details';
$lang['rec_prog_app_f_req_select']       = 'Select a requisition:';
$lang['rec_prog_app_req_openings']       = 'Openings:';
$lang['rec_prog_app_no_reqs']            = 'No requisitions registered';

$lang['rec_prog_app_f_first_names']      = 'First name(s) *';
$lang['rec_prog_app_f_lastname_1']       = 'Last name *';
$lang['rec_prog_app_f_lastname_2']       = 'Second last name';
$lang['rec_prog_app_f_address']          = 'Location / address *';
$lang['rec_prog_app_f_interest_area']    = 'Area of interest *';
$lang['rec_prog_app_f_contact_method']   = 'Contact method *';
$lang['rec_prog_app_f_phone']            = 'Phone *';
$lang['rec_prog_app_f_email']            = 'Email *';

// Commons (if you don’t already have them)
$lang['rec_common_select']               = 'Select';
$lang['rec_common_na']                   = 'N/A';
$lang['rec_common_save']                 = 'Save';

// addApplicant - labels (backend)
$lang['rec_prog_app_rule_requisition']     = 'Assign requisition';
$lang['rec_prog_app_rule_name']            = 'First name(s)';
$lang['rec_prog_app_rule_lastname1']       = 'Last name';
$lang['rec_prog_app_rule_lastname2']       = 'Second last name';
$lang['rec_prog_app_rule_address']         = 'Location / address';
$lang['rec_prog_app_rule_interest']        = 'Area of interest';
$lang['rec_prog_app_rule_contact_method']  = 'Contact method';
$lang['rec_prog_app_rule_phone']           = 'Phone';
$lang['rec_prog_app_rule_email']           = 'Email';

// Validation (if not already defined globally)
$lang['rec_val_integer']                   = 'The {field} field must be numeric';

// Business / responses
$lang['rec_prog_app_req_not_found']        = 'Requisition {req} does not exist or does not belong to this portal';
$lang['rec_prog_app_already_registered']   = 'The applicant is already registered for this requisition';
$lang['rec_prog_status_registered']        = 'Registered';
$lang['rec_prog_app_db_error']             = 'Could not save the applicant (database error).';
$lang['rec_prog_app_save_fail']            = 'Could not save the applicant.';
$lang['rec_prog_app_saved_ok']             = 'The applicant was saved successfully.';
$lang['rec_prog_app_updated_ok']           = 'The applicant was updated successfully :)';
$lang['rec_prog_app_updated_fail']         = 'The applicant could not be updated :(';


$lang['rec_common_problem_title'] = 'There was a problem';
$lang['rec_common_close']         = 'Close';
$lang['rec_common_server_error_title']     = 'Server error';
$lang['rec_common_server_unexpected_reply']= 'Unexpected server response:';

$lang['rec_common_note_label'] = 'NOTE:';
$lang['rec_common_select']     = 'Select';
$lang['rec_common_other']      = 'Other';
$lang['rec_common_cancel']     = 'Cancel';
$lang['rec_common_close']      = 'Close';
$lang['rec_common_save']       = 'Save';

$lang['rec_prog_action_modal_title'] = 'Action log for applicant:';
$lang['rec_prog_action_note_success'] = 'In this section you can record the actions taken during the recruitment process for this applicant.';
$lang['rec_prog_action_field_action'] = 'Action to apply *';
$lang['rec_prog_action_placeholder_other_action'] = 'Type the action';
$lang['rec_prog_action_field_comment'] = 'Comment / Description / Date and place *';

$lang['rec_prog_action_note_warning_intro'] = 'If the action affects the applicant status/color in the job pool or the process status, remember to update the following fields:';
$lang['rec_prog_action_note_candidate_status_title'] = 'Applicant Status';
$lang['rec_prog_action_note_candidate_status_desc']  = 'This changes the applicant color and status in the job pool.';
$lang['rec_prog_action_note_process_status_title']    = 'Process Status';
$lang['rec_prog_action_note_process_status_desc']     = 'This changes the current recruitment process status.';

$lang['rec_prog_action_tip_candidate_status'] = 'This change will directly impact the Job Pool, updating both the applicant color and status';
$lang['rec_prog_action_label_candidate_status'] = 'Applicant status';

$lang['rec_prog_action_opt_waiting']              = 'Waiting';
$lang['rec_prog_action_opt_caution']              = 'Caution';
$lang['rec_prog_action_opt_in_process']           = 'In recruitment process';
$lang['rec_prog_action_opt_ready_pre_employment'] = 'Ready to start the pre-employment process';
$lang['rec_prog_action_opt_block']                = 'Block applicant';

$lang['rec_prog_action_tip_process_status'] = "This option is recorded in this module as 'In progress' and is shown in the 'Current Status' column";
$lang['rec_prog_action_label_process_status'] = 'Process status';
$lang['rec_prog_action_opt_completed'] = 'Completed';
$lang['rec_prog_action_opt_canceled']  = 'Canceled';
$lang['rec_prog_action_opt_remove_final_status'] = 'Remove final status';

$lang['rec_prog_action_btn_register'] = 'Register';

$lang['rec_prog_history_modal_title'] = 'Applicant movement history:';

$lang['rec_prog_req_status_modal_title']  = 'Requisition status';
$lang['rec_prog_req_status_field_req']    = 'Requisition *';
$lang['rec_prog_req_status_field_assign'] = 'Status to assign *';
$lang['rec_prog_req_status_opt_finish']   = 'Finish';
$lang['rec_prog_req_status_opt_cancel']   = 'Cancel';
$lang['rec_prog_req_status_opt_delete']   = 'Delete';
$lang['rec_prog_req_status_field_comments'] = 'Comments *';

$lang['rec_common_na'] = 'N/A';
$lang['rec_common_apply'] = 'Apply';

$lang['rec_prog_candidate_modal_title'] = 'Candidate registration';
$lang['rec_prog_candidate_section_general'] = 'General information';

$lang['rec_prog_candidate_f_first_name'] = 'First name(s) *';
$lang['rec_prog_candidate_f_lastname_1'] = 'Last name *';
$lang['rec_prog_candidate_f_lastname_2'] = 'Second last name';
$lang['rec_prog_candidate_f_subclient'] = 'Sub-client';
$lang['rec_prog_candidate_f_position'] = 'Position *';
$lang['rec_prog_candidate_ph_specify_position'] = 'Specify position';
$lang['rec_prog_candidate_f_phone'] = 'Phone *';
$lang['rec_prog_candidate_f_country_residence'] = 'Country of residence *';
$lang['rec_prog_candidate_f_email'] = 'Email *';
$lang['rec_prog_candidate_f_curp'] = 'CURP';
$lang['rec_prog_candidate_f_ssn'] = 'Social Security Number (SSN)';

$lang['rec_prog_candidate_choose_option'] = 'Select one of the following options:';
$lang['rec_prog_candidate_opt_self_process_free'] = 'Register my own process - Free';
$lang['rec_prog_candidate_opt_prev_or_new_project'] = 'Select a previous project or create a new one / Sent to RODI';
$lang['rec_prog_candidate_opt_drug_med_only'] = 'Register the candidate only with Drug Test and/or Medical Exam / Sent to RODI';

$lang['rec_prog_candidate_prev_project_title'] = 'Select a previous project';
$lang['rec_prog_candidate_rodi_cost_notice_1'] = 'Sending to RODI generates a cost. If you are not sure about costs, please contact';
$lang['rec_prog_candidate_prev_projects_label'] = 'Previous projects';

$lang['rec_prog_candidate_new_project_title'] = 'Select a new project';
$lang['rec_prog_candidate_new_project_location'] = 'Location *';
$lang['rec_prog_candidate_region_mexico'] = 'Mexico';
$lang['rec_prog_candidate_region_international'] = 'International';
$lang['rec_prog_candidate_new_project_country'] = 'Country';
$lang['rec_prog_candidate_new_project_name'] = 'Project name *';

$lang['rec_prog_candidate_required_info_new_project'] = 'Required information for the new project';
$lang['rec_prog_candidate_required_info_note_1'] = 'Required documents will be added automatically depending on the selected options. Extra documents are optional; select them before complementary tests.';

$lang['rec_prog_candidate_employment_history'] = 'Employment history *';
$lang['rec_prog_candidate_time_required'] = 'Time required';
$lang['rec_prog_candidate_criminal_check'] = 'Criminal check *';
$lang['rec_prog_candidate_address_history'] = 'Address history *';
$lang['rec_prog_candidate_education_check'] = 'Education check *';
$lang['rec_prog_candidate_global_searches'] = 'Global data searches *';
$lang['rec_prog_candidate_credit_check'] = 'Credit check *';
$lang['rec_prog_candidate_prof_refs_qty'] = 'Professional references (quantity)';
$lang['rec_prog_candidate_personal_refs_qty'] = 'Personal references (quantity)';
$lang['rec_prog_candidate_identity_check'] = 'Identity check *';
$lang['rec_prog_candidate_migratory_form_check'] = 'Migratory form (FM, FM2 or FM3) check *';
$lang['rec_prog_candidate_prohibited_parties_check'] = 'Prohibited parties list check *';
$lang['rec_prog_candidate_academic_refs_qty'] = 'Academic references (quantity)';
$lang['rec_prog_candidate_mvr_check'] = 'Motor Vehicle Records (only in some Mexico cities) *';
$lang['rec_prog_candidate_curp_check'] = 'CURP check *';

$lang['rec_prog_candidate_extra_docs_title'] = 'Extra documents';
$lang['rec_prog_candidate_extra_docs_label'] = 'Select the extra documents *';
$lang['rec_prog_candidate_extra_military'] = 'Military document';
$lang['rec_prog_candidate_extra_passport'] = 'Passport';
$lang['rec_prog_candidate_extra_license'] = 'Professional licence';
$lang['rec_prog_candidate_extra_credential'] = 'Academic / Professional Credential';
$lang['rec_prog_candidate_extra_resume'] = 'Resume';
$lang['rec_prog_candidate_extra_sex_offender'] = 'Sex offender registry';
$lang['rec_prog_candidate_extra_ssn'] = 'Social Security Number';

$lang['rec_prog_candidate_tests_title'] = 'Complementary tests';
$lang['rec_prog_candidate_test_drug'] = 'Drug test *';
$lang['rec_prog_candidate_test_medical'] = 'Medical test *';
$lang['rec_prog_candidate_test_psychometric'] = 'Psychometric *';

$lang['rec_prog_comments_modal_title'] = 'Comment history regarding:';
$lang['rec_prog_comments_f_new_comment'] = 'Add a new comment or status *';
$lang['rec_prog_comments_btn_save'] = 'Save comment';

$lang['rec_prog_hist_tbl_date']    = 'Date';
$lang['rec_prog_hist_tbl_user']    = 'User';
$lang['rec_prog_hist_tbl_comment'] = 'Comment / Status';
$lang['rec_prog_hist_no_comments'] = 'No comments';

$lang['rec_prog_upload_modal_title']    = 'Upload and name your files';
$lang['rec_prog_upload_select_files']   = 'Select one or more files';
$lang['rec_prog_upload_allowed_types']  = 'Allowed types: PDF, images and videos.';
$lang['rec_prog_upload_th_file']        = 'File';
$lang['rec_prog_upload_th_size']        = 'Size';
$lang['rec_prog_upload_th_custom_name'] = 'Custom name';
$lang['rec_prog_upload_th_actions']     = 'Actions';
$lang['rec_prog_upload_empty']          = 'No files selected…';
$lang['rec_prog_upload_btn_upload']     = 'Upload files';

$lang['rec_prog_upload_placeholder_custom_name'] = 'Example: CV, Receipt, etc.';
$lang['rec_prog_upload_remove_file_aria']        = 'Remove file';

$lang['rec_prog_upload_swal_no_files_title'] = 'No files';
$lang['rec_prog_upload_swal_no_files_text']  = 'Select at least one file.';

$lang['rec_prog_upload_swal_name_required_title'] = 'Name required';
$lang['rec_prog_upload_swal_name_required_text']  = 'Set a custom name for each file.';

$lang['rec_prog_upload_btn_uploading'] = 'Uploading...';

$lang['rec_prog_upload_swal_success_title']        = 'Success!';
$lang['rec_prog_upload_swal_success_text_default'] = 'Files uploaded.';
$lang['rec_prog_upload_swal_success_all']          = 'All files uploaded.';

$lang['rec_prog_upload_swal_partial_title'] = 'Partial upload';

$lang['rec_prog_upload_swal_error_title']        = 'Error';
$lang['rec_prog_upload_swal_error_text_default'] = 'The upload could not be completed.';

$lang['rec_prog_upload_swal_server_error_title']        = 'Server error';
$lang['rec_prog_upload_swal_server_error_text_default'] = 'Please try again.';

$lang['rec_prog_hist_field_comment_status'] = 'Comment / Status';

$lang['rec_prog_val_required_msg']   = 'The {field} field is required';
$lang['rec_prog_val_max_length_msg'] = 'The {field} field must be at most {param} characters';
$lang['rec_prog_val_numeric_msg']    = 'The {field} field must be numeric';

$lang['rec_prog_hist_save_ok_prefix'] = 'Saved successfully. ';

$lang['rec_prog_hist_notify_not_sent_no_data'] =
'Saved successfully. The notification was not sent because no valid data was found to notify.';

$lang['rec_prog_hist_notify_not_sent_disabled'] =
'Saved successfully. The notification was not sent.';

$lang['rec_prog_hist_save_fail'] = 'The comment could not be saved. Please try again later.';

$lang['rec_prog_bolsa_status_blocked_text'] = 'Blocked from the recruitment process';

$lang['rec_prog_bolsa_hist_action_user_blocks'] =
'User blocks the person from the recruitment process';

$lang['rec_prog_bolsa_block_ok']   = 'Blocked successfully';
$lang['rec_prog_bolsa_unblock_ok'] = 'Unblocked successfully';

$lang['rec_prog_bolsa_block_reason_required'] =
'You must enter the blocking reason and try again';

$lang['rec_prog_adm_modal_title'] = 'Employment admission information for the candidate:';
$lang['rec_prog_adm_warranty_history_title'] = 'Warranty status history';

$lang['rec_prog_adm_salary_agreed'] = 'Agreed salary';
$lang['rec_prog_adm_company_start_date'] = 'Company start date';
$lang['rec_prog_adm_payment'] = 'Payment';

$lang['rec_prog_adm_warranty_status'] = 'Warranty status';

$lang['rec_prog_adm_btn_save_info'] = 'Save information';

$lang['rec_prog_btn_close'] = 'Close';
$lang['rec_prog_btn_close_aria'] = 'Close';

$lang['rec_prog_swal_delete_confirm_title'] = 'Are you sure?';
$lang['rec_prog_swal_delete_confirm_text'] = 'This action cannot be undone!';
$lang['rec_prog_swal_delete_confirm_btn_yes_continue'] = 'Yes, continue';

$lang['rec_prog_swal_delete_confirm2_title'] = 'Do you really want to delete the record?';
$lang['rec_prog_swal_delete_confirm2_text'] = 'This action is final.';
$lang['rec_prog_swal_delete_confirm2_btn_yes_delete'] = 'Yes, delete';

$lang['rec_prog_swal_btn_cancel'] = 'Cancel';

$lang['rec_prog_swal_deleted_title'] = 'Deleted';
$lang['rec_prog_swal_attention_title'] = 'Attention';

$lang['rec_prog_swal_error_title'] = 'Error';
$lang['rec_prog_swal_unexpected_server_response'] = 'Unexpected server response.';
$lang['rec_prog_swal_delete_ajax_error'] = 'An error occurred while deleting.';

$lang['rec_prog_warranty_th_date'] = 'Record date';
$lang['rec_prog_warranty_th_user'] = 'User';
$lang['rec_prog_warranty_th_desc_status'] = 'Description / Status';
$lang['rec_prog_warranty_no_records'] = 'No records';

$lang['rec_common_role_client']    = 'Client';
$lang['rec_common_role_recruiter'] = 'Recruiter';

$lang['rec_mov_delete_ok']   = 'The record has been deleted successfully.';
$lang['rec_mov_delete_fail'] = 'The record could not be deleted.';
$lang['rec_action_saved_ok']   = 'Action recorded successfully.';
$lang['rec_action_saved_fail'] = 'There was a problem; the action was not recorded.';

$lang['rec_req_rule_requisition'] = 'Requisition';
$lang['rec_req_rule_status']      = 'Status to assign';
$lang['rec_req_rule_comments']    = 'Comments';

$lang['fv_required']    = 'The {field} field is required';
$lang['fv_max_length']  = 'The {field} field must be at most {param} characters';
$lang['fv_numeric']     = 'The {field} field must be numeric';

$lang['rec_req_cancel_ok']        = 'The requisition was cancelled successfully';
$lang['rec_req_delete_ok']        = 'The requisition was deleted successfully';
$lang['rec_req_finish_ok']        = 'The requisition was closed successfully';
$lang['rec_req_cannot_close']     = 'The requisition cannot be closed because information is missing:';

$lang['rec_req_missing_salary']     = 'does not have the agreed salary recorded.';
$lang['rec_req_missing_entry_date'] = 'does not have the start date recorded.';
$lang['rec_req_candidate_prefix']   = 'Candidate <b>{name}</b> ';
$lang['rec_req_missing_vacancies']  = '{n} vacancies are still missing to be covered with complete candidates.';






