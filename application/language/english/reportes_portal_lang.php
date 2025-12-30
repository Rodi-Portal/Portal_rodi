<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['reportes_clientes_title']         = 'Branch Records Report';
$lang['reportes_clientes_sucursal']      = 'Branch *';
$lang['reportes_clientes_select']        = 'Select';
$lang['reportes_clientes_all']           = 'ALL';
$lang['reportes_clientes_btn_consultar'] = 'Search';
$lang['reportes_clientes_resultados']    = 'Retrieved data:';
$lang['reportes_date_placeholder']       = 'dd/mm/yyyy';

// ===== Validations =====
$lang['reportes_val_cliente']          = 'Client';
$lang['reportes_val_required']         = 'The {field} field is required';
$lang['reportes_val_numeric']          = 'The {field} field must be numeric';

// ===== Buttons / Actions =====
$lang['reportes_btn_export_excel']     = 'Export to Excel';

// ===== Table =====
$lang['reportes_th_empresa']           = 'Company';
$lang['reportes_th_razon_social']      = 'Business name';
$lang['reportes_th_ingles']            = 'English';
$lang['reportes_th_clave']             = 'Code';
$lang['reportes_th_fecha_alta']        = 'Created date';
$lang['reportes_th_subcliente']        = 'Sub-client';

// ===== Values / States =====
$lang['reportes_si']                   = 'YES';
$lang['reportes_no']                   = 'NO';
$lang['reportes_sin_registro']          = 'No record';

// ===== Messages =====
$lang['reportes_sin_resultados']       = 'No records found for the applied filters';

// ===== Recruitment Process Report =====
$lang['reportes_reclutamiento_title']        = 'Recruitment Process Report';
$lang['reportes_reclutamiento_info_title']   = 'Report considerations:';
$lang['reportes_reclutamiento_info_text']    = 'This report includes ongoing requisitions and candidates assigned to a requisition';

// ===== Filters =====
$lang['reportes_fecha_inicio']               = 'Start date *';
$lang['reportes_fecha_fin']                  = 'End date *';
$lang['reportes_reclutador']                 = 'Recruiter *';
$lang['reportes_select']                     = 'Select';
$lang['reportes_todos']                      = 'ALL';

// ===== Buttons =====
$lang['reportes_btn_resultados']             = 'Get results';

// ===== Results =====
$lang['reportes_datos_consultados']          = 'Results found:';

// ===== Dates =====
$lang['reportes_date_placeholder']            = 'mm/dd/yyyy';

// ===== Recruitment Process – Table headers =====
$lang['reportes_th_reclutador']         = 'Recruiter';
$lang['reportes_th_fecha_registro']     = 'Registration date';
$lang['reportes_th_aspirante']          = 'Applicant';
$lang['reportes_th_telefono']           = 'Phone';
$lang['reportes_th_domicilio']          = 'Address';
$lang['reportes_th_medio_contacto']     = 'Contact method';
$lang['reportes_th_cliente']            = 'Client';
$lang['reportes_th_puesto']             = 'Position';
$lang['reportes_th_sueldo']              = 'Salary';
$lang['reportes_th_fecha_requisicion']  = 'Requisition date';
$lang['reportes_th_fecha_ingreso']      = 'Hire date';
$lang['reportes_th_garantia']            = 'Guarantee';
$lang['reportes_th_pago']                = 'Payment';

// ===== Recruitment Process – Values =====
$lang['reportes_sin_asignar']            = 'Unassigned';

// ===== Employees Report =====
$lang['reportes_empleados_title']            = 'Generate Employees Report';

// ===== Filters =====
$lang['reportes_empleados_sucursal']         = 'Select a branch:';
$lang['reportes_empleados_all_sucursales']   = '-- All branches --';

$lang['reportes_empleados_campos']           = 'Select the information to include:';
$lang['reportes_empleados_campos_extra']     = 'Extra fields';
$lang['reportes_empleados_domicilio']        = 'Address';
$lang['reportes_empleados_medica']           = 'Medical information';
$lang['reportes_empleados_laborales']        = 'Employment data';
$lang['reportes_empleados_examenes']         = 'Exams';
$lang['reportes_empleados_documentos']       = 'Documents';
$lang['reportes_empleados_cursos']           = 'Courses';

// ===== Dates =====
$lang['reportes_empleados_fecha_filtro']     = 'Filter by hire date:';
$lang['reportes_empleados_desde']             = 'From';
$lang['reportes_empleados_hasta']             = 'To';

// ===== Position / Department =====
$lang['reportes_empleados_puesto_depto']     = 'Filter by position and department:';
$lang['reportes_empleados_puesto']            = 'Position';
$lang['reportes_empleados_departamento']     = 'Department';
$lang['reportes_empleados_all_puestos']      = '-- All positions --';
$lang['reportes_empleados_all_departamentos']= '-- All departments --';

// ===== Button =====
$lang['reportes_empleados_btn_excel']         = 'Generate Excel';

// ===== Dynamic selects =====
$lang['reportes_select_puesto']               = '-- Select position --';
$lang['reportes_select_departamento']         = '-- Select department --';

$lang['reportes_excel_nombre']      = 'Name';
$lang['reportes_excel_descripcion'] = 'Description';
$lang['reportes_excel_expira']      = 'Expires';
$lang['reportes_excel_tipo']        = 'Type';

$lang['reportes_excel_dom_pais']    = 'Country';
$lang['reportes_excel_dom_estado']  = 'State';
$lang['reportes_excel_dom_ciudad']  = 'City';
$lang['reportes_excel_dom_colonia'] = 'District';
$lang['reportes_excel_dom_calle']   = 'Street';
$lang['reportes_excel_dom_num_int'] = 'Int.';
$lang['reportes_excel_dom_num_ext'] = 'Ext.';

// ===== Former Employees Report =====
$lang['reportes_ex_title']                = 'Generate Former Employees Report';

// ===== Filters =====
$lang['reportes_ex_sucursal']             = 'Select a branch:';
$lang['reportes_ex_all_sucursales']       = '-- All branches --';

$lang['reportes_ex_campos']               = 'Select information to include:';
$lang['reportes_ex_campos_extra']         = 'Extra fields';
$lang['reportes_ex_domicilio']            = 'Address';
$lang['reportes_ex_medica']               = 'Medical information';
$lang['reportes_ex_laborales']            = 'Work information';
$lang['reportes_ex_examenes']             = 'Exams';
$lang['reportes_ex_documentos']           = 'Documents';
$lang['reportes_ex_cursos']               = 'Courses';

$lang['reportes_ex_fecha_filtro']         = 'Filter by hire date:';
$lang['reportes_ex_desde']                = 'From';
$lang['reportes_ex_hasta']                = 'To';

$lang['reportes_ex_puesto_depto']         = 'Filter by position and department:';
$lang['reportes_ex_puesto']               = 'Position';
$lang['reportes_ex_departamento']         = 'Department';

$lang['reportes_ex_all_puestos']           = '-- All positions --';
$lang['reportes_ex_all_departamentos']     = '-- All departments --';

// ===== Button =====
$lang['reportes_ex_btn_excel']             = 'Generate Excel';

// ===== Dynamic select =====
$lang['reportes_ex_select_puesto']         = '-- Select position --';
$lang['reportes_ex_select_departamento']   = '-- Select department --';