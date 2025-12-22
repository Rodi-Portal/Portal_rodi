<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ===== Comunes para listados por sucursal/cliente =====
$lang['mod_clients_title']              = 'Sucursales/Clientes';

$lang['mod_intro_pre'] = 'En este módulo verás un listado de tus sucursales/clientes, áreas o departamentos. Al seleccionar uno, podrás consultar los candidatos que se encuentran en exámenes y estudios previos a ser contratados, facilitando el seguimiento del proceso de selección antes de la contratación.';

$lang['mod_intro_empleados'] = 'En este módulo verás un listado de tus sucursales/clientes, áreas o departamentos. Al seleccionar uno, podrás consultar a los empleados activos asociados a cada sucursal/cliente, lo que facilita el seguimiento y la administración del personal.';

$lang['mod_intro_exempleados'] = 'En este módulo verás un listado de tus sucursales/clientes, áreas o departamentos. Al seleccionar uno, podrás consultar a los exempleados asociados, lo que facilita la consulta histórica y el seguimiento posterior a la baja.';

// Encabezados de tabla
$lang['mod_table_branch']           = 'Sucursal/Cliente'; 
$lang['mod_table_email']            = 'Correo electrónico';
$lang['mod_table_users_access']     = 'Usuarios con acceso a sucursal/cliente';
$lang['mod_table_candidates']       = 'Candidatos en proceso';
$lang['mod_table_actions']          = 'Acciones';

// Valores / mensajes
$lang['mod_table_na']               = 'N/A';
$lang['mod_table_candidates_prefix']= 'Candidatos: ';
$lang['mod_table_no_branches']      = 'Aún no hay sucursales registradas.';

// Botones / tooltips
$lang['mod_btn_view_process']       = 'Ver procesos';
$lang['mod_title_delete_access']    = 'Eliminar acceso a esta sucursal/cliente';


// ===== Módulo de exempleados =====
$lang['mod_exempleados_title']      = 'Módulo de Exempleados';

$lang['mod_ex_max_number']          = 'Número máximo:';
$lang['mod_ex_employees_active']    = 'Empleados:';
$lang['mod_ex_employees_inactive']  = 'Exempleados:';

// Encabezados específicos de este módulo
$lang['mod_table_access_branch']    = 'Acceso a sucursal/cliente';
$lang['mod_table_employees']        = 'Empleados';

// Botón
$lang['mod_btn_view_exemployees']   = 'Ver exempleados';
// ==== Mensajes para eliminar permiso de sucursal/cliente ====
$lang['mod_perm_delete_title']       = '¿Estás seguro?';
$lang['mod_perm_delete_text']        = 'Al eliminar este permiso, el usuario perderá visibilidad a esta sucursal/cliente.';
$lang['mod_perm_delete_confirm']     = 'Sí, eliminar';
$lang['mod_perm_delete_cancel']      = 'Cancelar';

$lang['mod_perm_deleted_title']      = 'Eliminado';
$lang['mod_perm_deleted_text']       = 'El permiso ha sido eliminado exitosamente.';

$lang['mod_perm_error_title']        = 'Error';
$lang['mod_perm_error_delete']       = 'Ocurrió un error al intentar eliminar el permiso.';


// ==== MÓDULO EMPLEADOS ====
$lang['mod_emp_title']        = 'Módulo de Empleados';
$lang['mod_emp_intro']        = 'En este módulo podrás consultar un listado de tus áreas, departamentos o sucursales/clientes. Al seleccionar uno, accederás al listado de empleados asociados y podrás gestionar sus datos y procesos de manera eficiente.';

$lang['mod_emp_th_client']    = 'Sucursal/Cliente';
$lang['mod_emp_th_email']     = 'Correo electrónico';
$lang['mod_emp_th_access']    = 'Usuarios con acceso a sucursal/cliente';
$lang['mod_emp_th_employees'] = 'Empleados';
$lang['mod_emp_th_actions']   = 'Acciones';

$lang['mod_emp_lbl_max']      = 'Número máximo';
$lang['mod_emp_lbl_active']   = 'Empleados';
$lang['mod_emp_lbl_inactive'] = 'Exempleados';

$lang['mod_emp_btn_view']     = 'Ver empleados';
$lang['mod_emp_no_clients']   = 'No hay clientes registrados.';

// Tooltip (también usado en otros módulos)
$lang['mod_perm_delete_tooltip'] = 'Eliminar acceso a esta sucursal/cliente';


// ==== MÓDULO COMUNICACIÓN ====
$lang['mod_com_title'] = 'Módulo de comunicación';

$lang['mod_com_intro'] = 'En este módulo podrás consultar un listado de tus sucursales/clientes, áreas o departamentos, según la estructura definida por tu organización. Al seleccionar una entidad, accederás al módulo de comunicación correspondiente, donde podrás gestionar y compartir información clave con los colaboradores asociados.';

$lang['mod_com_btn_columns']     = 'Mostrar/ocultar columnas';
$lang['mod_com_btn_mass_action'] = 'Ingresar selección';

$lang['mod_com_filter_branch']    = 'Buscar sucursal';
$lang['mod_com_filter_users']     = 'Buscar usuarios';
$lang['mod_com_filter_employees'] = 'Buscar empleados';
$lang['mod_com_filter_any_prefix'] = 'Buscar';

$lang['mod_com_no_data'] = 'No hay datos disponibles.';

// Acciones masivas
$lang['mod_com_mass_no_selection_title'] = 'Sin selección';
$lang['mod_com_mass_no_selection_text']  = 'Selecciona al menos una sucursal.';

$lang['mod_com_mass_confirm_title'] = '¿Acción sobre sucursales seleccionadas?';
$lang['mod_com_mass_confirm_text']  = 'Dispondrás de la información y funciones de todas las sucursales que seleccionaste.';
$lang['mod_com_mass_confirm_btn']   = 'Sí';
$lang['mod_com_mass_cancel_btn']    = 'Cancelar';
// Español
$lang['mod_com_btn_enter']  = 'Entrar';
$lang['mod_com_btn_apply']  = 'Aplicar';
// ==== MÓDULO COMUNICACIÓN – columnas dinámicas ====
$lang['mod_com_col_TELEFONO'] = 'Teléfono';
$lang['mod_com_col_ESTADO']   = 'Estado';
$lang['mod_com_col_PAIS']     = 'País';
$lang['mod_com_col_CIUDAD']   = 'Ciudad';
