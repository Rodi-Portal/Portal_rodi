<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* ===============================
   Modal – Update Logo
   =============================== */

$lang['portal_logo_modal_title']        = 'Upload new logo';
$lang['portal_logo_select_image']      = 'Select an image';
$lang['portal_logo_preview']           = 'Preview';
$lang['portal_logo_current']           = 'Current logo';
$lang['portal_logo_delete']            = 'Delete logo';
$lang['portal_logo_close']             = 'Close';
$lang['portal_logo_save']              = 'Save logo';

/* SweetAlert */
$lang['portal_logo_swal_confirm_title'] = 'Are you sure?';
$lang['portal_logo_swal_confirm_text']  = 'This action cannot be undone!';
$lang['portal_logo_swal_confirm_btn']   = 'Yes, delete it';
$lang['portal_logo_swal_cancel_btn']    = 'Cancel';

$lang['portal_logo_deleted_title']      = 'Deleted!';
$lang['portal_logo_deleted_text']       = 'The logo has been deleted successfully.';

$lang['portal_logo_update_success']     = 'Logo updated';
$lang['portal_logo_update_success_txt'] = 'The logo has been updated successfully.';

$lang['portal_logo_update_error']       = 'Error updating logo';
$lang['portal_logo_generic_error']      = 'There was a problem updating the logo.';
$lang['portal_logo_delete_error']       = 'There was an error deleting the logo.';

$lang['portal_logo_no_file_title']      = 'No file selected';
$lang['portal_logo_no_file_text']       = 'Please select an image for the logo.';

/* ===============================
   Portal – Documents Modal
   =============================== */

$lang['portal_docs_modal_title'] = 'Portal documents';

$lang['portal_docs_th_document'] = 'Document';
$lang['portal_docs_th_current']  = 'Current / Default';
$lang['portal_docs_th_upload']   = 'Upload PDF';
$lang['portal_docs_th_actions']  = 'Actions';

/* Documents */
$lang['portal_docs_aviso'] = 'Notice for candidates';
$lang['portal_docs_terminos'] = 'Terms and conditions (requisitions)';
$lang['portal_docs_confidencialidad'] = 'Confidentiality agreement';

/* Notes */
$lang['portal_docs_note_default'] = 'If no file is uploaded, the default document will be shown.';

/* Upload / Validation */
$lang['portal_docs_select_pdf']   = 'Select a PDF';
$lang['portal_docs_invalid_file'] = 'Invalid file';
$lang['portal_docs_only_pdf']     = 'Must be a PDF (.pdf)';
$lang['portal_docs_uploading']    = 'Uploading…';

/* Success / Status */
$lang['portal_docs_saved_title'] = 'Saved!';
$lang['portal_docs_updated']     = 'Document updated.';
$lang['portal_docs_view']        = 'View document';

/* Delete */
$lang['portal_docs_deleted_title'] = 'Deleted';
$lang['portal_docs_deleted']       = 'Document deleted.';
$lang['portal_docs_not_loaded']    = 'Not uploaded';
$lang['portal_docs_confirm_delete'] = 'Delete document?';

/* Errors */
$lang['portal_docs_upload_error'] = 'Upload error';
$lang['portal_docs_upload_fail']  = 'The document could not be uploaded.';
$lang['portal_docs_delete_fail']  = 'The document could not be deleted.';

/* Generic buttons / labels */
$lang['portal_save']    = 'Save';
$lang['portal_delete']  = 'Delete';
$lang['portal_close']   = 'Close';
$lang['portal_confirm'] = 'Yes, delete';
$lang['portal_cancel']  = 'Cancel';
$lang['portal_error']   = 'Error';
$lang['portal_docs_warn_title'] = 'Warning';

/* ===============================
   Portal – Documents (Backend)
   =============================== */

$lang['portal_docs_err_no_session'] = 'Session without idPortal';
$lang['portal_docs_err_invalid_type'] = 'Invalid type';
$lang['portal_docs_err_select_pdf'] = 'Please select a PDF';
$lang['portal_docs_err_upload'] = 'Upload error: {error}';
$lang['portal_docs_err_no_file_delete'] = 'There is no file to delete';
$lang['portal_docs_deleted_backend'] = '{tipo} deleted.';

$lang['portal_docs_saved_backend'] = '{tipo} updated.';
$lang['portal_docs_deleted_backend'] = '{tipo} deleted.';
$lang['portal_docs_tipo_aviso'] = 'Notice';
$lang['portal_docs_tipo_terminos'] = 'Terms';
$lang['portal_docs_tipo_confidencialidad'] = 'Confidentiality';



/* ======================================================
 * PAYMENT / SUBSCRIPTION – GENERAL
 * ====================================================== */

$lang['portal_pay_title'] = 'Subscription Details';

$lang['portal_pay_tab_pay']          = 'Pay';
$lang['portal_pay_tab_subscription'] = 'Subscription';
$lang['portal_pay_tab_history']      = 'Payment History';


/* ======================================================
 * GENERAL ALERTS
 * ====================================================== */

$lang['portal_pay_expired_alert_title'] = 'Your subscription has expired';
$lang['portal_pay_expired_alert_text'] =
'Your TalentSafe subscription has expired. Please complete your payment as soon as possible by generating a payment link.
After payment, return here and confirm it using the corresponding button.
This will re-enable your access.
You may also contact us at (52) 3334 54 2877 via call or WhatsApp from Mon–Fri, 8 am to 6 pm for any questions.';

$lang['portal_pay_no_data'] = 'No payment data available for this client.';


/* ======================================================
 * SUBSCRIPTION
 * ====================================================== */

$lang['portal_pay_subscription_detail'] = 'Subscription Details';
$lang['portal_pay_client_name']         = 'Client Name';
$lang['portal_pay_plan']               = 'Subscription';
$lang['portal_pay_plan_description']   = 'Plan Description';
$lang['portal_pay_users_included']     = 'Included Users';
$lang['portal_pay_extra_users']        = 'Extra Users';
$lang['portal_pay_due_date']           = 'Due Date';
$lang['portal_pay_status']             = 'Status';
$lang['portal_pay_total_price']        = 'Total Price';


/* ======================================================
 * STATUS (GENERAL)
 * ====================================================== */

$lang['portal_pay_status_active']  = 'Active';
$lang['portal_pay_status_expired'] = 'Expired';
$lang['portal_pay_status_paid']    = 'Paid';
$lang['portal_pay_status_pending'] = 'Pending';


/* ======================================================
 * TABLES – SUBSCRIPTION
 * ====================================================== */

$lang['portal_pay_table_name']  = 'Name';
$lang['portal_pay_table_email'] = 'Email / Description';
$lang['portal_pay_table_price'] = 'Price';


/* ======================================================
 * PAYMENT LINK
 * ====================================================== */

$lang['portal_pay_link_title']    = 'Payment Link Details';
$lang['portal_pay_link_go']       = 'Go to Payment';
$lang['portal_pay_link_qr']       = 'View QR';
$lang['portal_pay_link_confirm']  = 'Confirm Payment';
$lang['portal_pay_link_generate'] = 'Generate Payment Link';

$lang['portal_pay_no_link'] =
'No payment link has been generated or it has expired. Please generate a new one.';


/* ======================================================
 * PAYMENT LINK TABLE
 * ====================================================== */

$lang['portal_pay_table_link_id']     = 'Payment Link ID';
$lang['portal_pay_table_link']        = 'Payment Link';
$lang['portal_pay_table_link_status'] = 'Link Status';
$lang['portal_pay_table_created']     = 'Generated On';
$lang['portal_pay_table_expires']     = 'Expires On';
$lang['portal_pay_table_actions']     = 'Actions';


/* ======================================================
 * PAYMENT HISTORY
 * ====================================================== */

$lang['portal_pay_history_title']      = 'Payment History';
$lang['portal_pay_no_history']         = 'No payment history available.';
$lang['portal_pay_history_id']         = 'Payment ID';
$lang['portal_pay_history_month']      = 'Month';
$lang['portal_pay_history_date']       = 'Payment Date';
$lang['portal_pay_history_amount']     = 'Amount';
$lang['portal_pay_history_status']     = 'Status';
$lang['portal_pay_history_reference']  = 'Reference';
$lang['portal_pay_history_view_status'] = 'View status';


/* ======================================================
 * PAYMENT HISTORY – PASARELA TABLE
 * ====================================================== */

$lang['pasarela.history.title'] = 'Payment History';

$lang['pasarela.history.columns.payment_id']   = 'Payment ID';
$lang['pasarela.history.columns.month']        = 'Month to Pay';
$lang['pasarela.history.columns.payment_date'] = 'Payment Date';
$lang['pasarela.history.columns.amount']       = 'Amount';
$lang['pasarela.history.columns.status']       = 'Status';
$lang['pasarela.history.columns.reference']    = 'Reference';

$lang['pasarela.history.view_status'] = 'View Status';
$lang['pasarela.history.empty']       = 'No payment history available.';


/* ======================================================
 * MODAL – GENERATE PAYMENT
 * ====================================================== */

$lang['portal_pay_modal_title']         = 'Generate Payment';
$lang['portal_pay_modal_select_months'] = 'Select months to pay';
$lang['portal_pay_modal_total']         = 'Total';
$lang['portal_pay_modal_generate']      = 'Generate Link';

$lang['pasarela.modal.title']            = 'Generate Payment';
$lang['pasarela.modal.package_fallback'] = 'Package';
$lang['pasarela.modal.extra_users']      = 'Extra Users';
$lang['pasarela.modal.select_months']    = 'Select months to pay';
$lang['pasarela.modal.total']            = 'Total';
$lang['pasarela.modal.generate']         = 'Generate Link';


/* ======================================================
 * SWEETALERT – MESSAGES
 * ====================================================== */

$lang['portal_pay_swal_success'] = 'Success!';
$lang['portal_pay_swal_error']   = 'Error';
$lang['portal_pay_swal_confirm'] = 'Confirm';
$lang['portal_pay_swal_cancel']  = 'Cancel';

$lang['portal_pay_swal_select_month'] =
'You must select at least one month.';

$lang['portal_pay_swal_request_error'] =
'There was an error with the request. Please try again.';

$lang['portal_pay_swal_link_success'] =
'The payment link was generated successfully.';

$lang['portal_pay_swal_link_error'] =
'The payment link could not be generated.';

$lang['portal_pay_swal_payment_info'] =
'Payment Information';

$lang['portal_pay_swal_unknown_status'] =
'Unknown status.';


/* ======================================================
 * PAYMENT LINK STATUS (CHECKOUT / API)
 * ====================================================== */

$lang['portal_pay_status_created'] =
'The payment link was created and is pending completion.';

$lang['portal_pay_status_pending_text'] =
'The payment link is active and pending completion.';

$lang['portal_pay_status_cancelled'] =
'The payment link was cancelled due to too many attempts.';

$lang['portal_pay_status_expired_text'] =
'The payment link has expired.';

$lang['portal_pay_status_paid_text'] =
'The payment link has been successfully completed.';

$lang['portal_pay_pending_action'] =
'Pending action';


/* ======================================================
 * MONTHS
 * ====================================================== */

$lang['months.january']   = 'January';
$lang['months.february']  = 'February';
$lang['months.march']     = 'March';
$lang['months.april']     = 'April';
$lang['months.may']       = 'May';
$lang['months.june']      = 'June';
$lang['months.july']      = 'July';
$lang['months.august']    = 'August';
$lang['months.september'] = 'September';
$lang['months.october']   = 'October';
$lang['months.november']  = 'November';
$lang['months.december']  = 'December';

/* ======================================================
 * PASARELA – SUBSCRIPTION (MISSING KEYS)
 * ====================================================== */

/* Labels / Fields */
$lang['pasarela.subscription.client_name'] = 'Client Name';
$lang['pasarela.subscription.plan']        = 'Subscription';
$lang['pasarela.subscription.description'] = 'Package Description';
$lang['pasarela.subscription.users_included'] = 'Included Users';
$lang['pasarela.subscription.extra_users']    = 'Extra Users';
$lang['pasarela.subscription.users_suffix']   = 'user(s)';
$lang['pasarela.subscription.due_date']       = 'Due Date';
$lang['pasarela.subscription.status']         = 'Status';
$lang['pasarela.subscription.total_price']    = 'Total Price';

/* Section titles */
$lang['pasarela.subscription.extra_users_title'] = 'Extra Users';

/* Table headers */
$lang['pasarela.subscription.table.name']  = 'Name';
$lang['pasarela.subscription.table.email'] = 'Email / Description';
$lang['pasarela.subscription.table.price'] = 'Price';

/* =========================
 * PLANS – TalentSafe
 * ========================= */

$lang['plan.1.title'] = 'TalentSafe Light';

$lang['plan.1.description'] =
'Monthly (1 user).<br>
Extra user $ 50 USD.<br>
Basic access to the TalentSafe platform.';

$lang['plan.1.total'] = 'Total: $ 80 USD';

/* Plan 2 – TalentSafe Standard */

$lang['plan.2.title'] = 'TalentSafe Standard';

$lang['plan.2.description'] =
'Monthly (5 users).<br>
Extra user $ 50 USD.<br>
CHOOSE 2 MODULES:<br>
(RECRUITMENT + PRE-EMPLOYMENT OR EMPLOYEE + EX-EMPLOYEE + COMMUNICATION)';

$lang['plan.2.total'] = 'Total: $ 130 USD';



$lang['plan.3.title'] = 'TalentSafe Plus';

$lang['plan.3.description'] =
'Monthly (5 users).<br>
Extra user $ 50 USD.<br>
Extended access to multiple TalentSafe modules.';

$lang['plan.3.total'] = 'Total: $ 250 USD';

$lang['plan.4.title'] = 'TalentSafe Platinum';

$lang['plan.4.description'] =
'Monthly (20 users).<br>
Extra user $ 50 USD.<br>
Full access to all TalentSafe modules.';

$lang['plan.4.total'] = 'Total: $ 1000 USD';


