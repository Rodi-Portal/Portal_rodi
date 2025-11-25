<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ===== Common for branch/client listings =====
$lang['mod_clients_title']              = 'Branches / Clients';

$lang['mod_intro_pre'] = 'In this module you will see a list of your branches/clients, areas or departments. By selecting one, you can review the candidates who are in background checks and pre-employment assessments, making it easier to track the selection process before hiring.';

$lang['mod_intro_empleados'] = 'In this module you will see a list of your branches/clients, areas or departments. By selecting one, you can review the active employees assigned to each branch/client, making it easier to manage and follow up your workforce.';

$lang['mod_intro_exempleados'] = 'In this module you will see a list of your branches/clients, areas or departments. By selecting one, you can review former employees related to each branch/client, making it easier to consult historical records after termination.';

// Table headers
$lang['mod_table_branch']           = 'Branch / Client';
$lang['mod_table_email']            = 'Email';
$lang['mod_table_users_access']     = 'Users with access';
$lang['mod_table_candidates']       = 'Candidates in process';
$lang['mod_table_actions']          = 'Actions';

// Values / messages
$lang['mod_table_na']               = 'N/A';
$lang['mod_table_candidates_prefix']= 'Candidates: ';
$lang['mod_table_no_branches']      = 'There are no branches registered yet.';

// Buttons / tooltips
$lang['mod_btn_view_process']       = 'View processes';
$lang['mod_title_delete_access']    = 'Remove access to this branch/client';


// ===== Former employees module =====
$lang['mod_exempleados_title']      = 'Former Employees Module';

$lang['mod_ex_max_number']          = 'Maximum allowed:';
$lang['mod_ex_employees_active']    = 'Employees:';
$lang['mod_ex_employees_inactive']  = 'Former employees:';

// Specific headers for this module
$lang['mod_table_access_branch']    = 'Users with access';
$lang['mod_table_employees']        = 'Employees';

// Button
$lang['mod_btn_view_exemployees']   = 'View former employees';

// ==== Messages for removing branch/client permission ====
$lang['mod_perm_delete_title']       = 'Are you sure?';
$lang['mod_perm_delete_text']        = 'If you remove this permission, the user will no longer see this branch/client.';
$lang['mod_perm_delete_confirm']     = 'Yes, remove';
$lang['mod_perm_delete_cancel']      = 'Cancel';

$lang['mod_perm_deleted_title']      = 'Removed';
$lang['mod_perm_deleted_text']       = 'The permission was removed successfully.';

$lang['mod_perm_error_title']        = 'Error';
$lang['mod_perm_error_delete']       = 'An error occurred while trying to remove the permission.';


// ==== EMPLOYEES MODULE ====
$lang['mod_emp_title']        = 'Employees module';
$lang['mod_emp_intro']        = 'In this module you can see a list of your business units, departments or client branches. Select one to see their employees and manage their data and processes efficiently.';

$lang['mod_emp_th_client']    = 'Branch/Client';
$lang['mod_emp_th_email']     = 'Email';
$lang['mod_emp_th_access']    = 'Users with access';
$lang['mod_emp_th_employees'] = 'Employees';
$lang['mod_emp_th_actions']   = 'Actions';

$lang['mod_emp_lbl_max']      = 'Maximum headcount';
$lang['mod_emp_lbl_active']   = 'Active employees';
$lang['mod_emp_lbl_inactive'] = 'Former employees';

$lang['mod_emp_btn_view']     = 'View employees';
$lang['mod_emp_no_clients']   = 'No clients registered yet.';

$lang['mod_perm_delete_tooltip'] = 'Remove access to this branch/client';


// ==== COMMUNICATION MODULE ====
$lang['mod_com_title'] = 'Communication module';

$lang['mod_com_intro'] = 'In this module you can see a list of your branches/clients, areas or departments, according to your company structure. When you select one, you will enter its communication space, where you can share and manage key information with the related employees.';

$lang['mod_com_btn_columns']     = 'Show / hide columns';
$lang['mod_com_btn_mass_action'] = 'Open selection';

$lang['mod_com_filter_branch']     = 'Search branch';
$lang['mod_com_filter_users']      = 'Search users';
$lang['mod_com_filter_employees']  = 'Search employees';
$lang['mod_com_filter_any_prefix'] = 'Search';

$lang['mod_com_no_data'] = 'No data available.';

// Mass actions
$lang['mod_com_mass_no_selection_title'] = 'No selection';
$lang['mod_com_mass_no_selection_text']  = 'Please select at least one branch.';

$lang['mod_com_mass_confirm_title'] = 'Action on selected branches?';
$lang['mod_com_mass_confirm_text']  = 'You will have access to the information and tools for all the branches you selected.';
$lang['mod_com_mass_confirm_btn']   = 'Yes';
$lang['mod_com_mass_cancel_btn']    = 'Cancel';
// English
$lang['mod_com_btn_enter']  = 'Enter';
$lang['mod_com_btn_apply']  = 'Apply';

// ==== COMMUNICATION MODULE – dynamic columns ====
$lang['mod_com_col_TELEFONO'] = 'Phone';
$lang['mod_com_col_ESTADO']   = 'State';
$lang['mod_com_col_PAIS']     = 'Country';
$lang['mod_com_col_CIUDAD']   = 'City';
