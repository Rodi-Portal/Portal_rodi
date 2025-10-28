<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['candidato_conclusion/createPrevioPDF'] = 'Candidato_Conclusion/createPrevioPDF';
$route['candidato_conclusion/createPDF'] = 'Candidato_Conclusion/createPDF';

$route['proceso/(:num)'] = 'Empleados/showEmpleados/$1';
$route['procesoFormer/(:num)'] = 'Empleados/showExEmpleados/$1';
$route['comunicacion/(:num)'] = 'Empleados/showComunicacion/$1';

$route['Cliente_General/getEmpleadosInternos/(:num)'] = 'Cliente_General/getEmpleadosInternos/$1';
$route['Avance/ver/(:any)'] = 'Avance/ver/$1';
$route['docs/(:any)'] = 'Archivo/ver_doc/$1';
$route['exams/(:any)'] = 'Archivo/ver_exam/$1'; 
$route['docsBolsa/(:any)'] = 'Archivo/ver_docs_bolsa/$1';  // nueva ruta para exámenes
 // nueva ruta para exámenes

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['legal']                = 'legal/index';
$route['legal/download/(:any)'] = 'legal/download/$1';
$route['portal/doc/(:any)'] = 'Archivo/ver_portal_doc/$1';

$route['permisos/precheck'] = 'permisos/precheck';
$route['permisos/usuario/(:num)'] = 'permisos/usuario/$1';
$route['permisos/guardar'] = 'permisos/guardar';


$route['Archivo/ver_aspirante/(:num)']       = 'Archivo/ver_aspirante/$1';
$route['Archivo/descargar_aspirante/(:num)'] = 'Archivo/descargar_aspirante/$1';

//calendario
$route['archivo/ver_calendario_id/(:num)']     = 'archivo/ver_calendario_id/$1';
$route['archivo/descargar_calendario/(:num)']  = 'archivo/descargar_calendario/$1';

// (Opcional, si también quieres por nombre de archivo)
$route['archivo/ver_calendario/(:any)']        = 'archivo/ver_calendario/$1';


/** RUTA  PARA  VER  PSICOMETRIAS   DESDE  RODI */
$route['archivo/psicometrico/(:any)'] = 'archivo/ver_psicometrico/$1';