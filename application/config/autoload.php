<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default. For example,
| the database is not connected to automatically since no assumption
| is made regarding whether you intend to use it.  This file lets
| you globally define which systems you would like loaded with every
| request.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Packages
| 2. Libraries
| 3. Drivers
| 4. Helper files
| 5. Custom config files
| 6. Language files
| 7. Models
|
 */

/*
| -------------------------------------------------------------------
|  Auto-load Packages
| -------------------------------------------------------------------
| Prototype:
|
|  $autoload['packages'] = array(APPPATH.'third_party', '/usr/local/shared');
|
 */
$autoload['packages'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Libraries
| -------------------------------------------------------------------
| These are the classes located in system/libraries/ or your
| application/libraries/ directory, with the addition of the
| 'database' library, which is somewhat of a special case.
|
| Prototype:
|
|    $autoload['libraries'] = array('database', 'email', 'session');
|
| You can also supply an alternative library name to be assigned
| in the controller:
|
|    $autoload['libraries'] = array('user_agent' => 'ua');
 */
$autoload['libraries'] = array('session', 'database', 'form_validation', 'email');

/*
| -------------------------------------------------------------------
|  Auto-load Drivers
| -------------------------------------------------------------------
| These classes are located in system/libraries/ or in your
| application/libraries/ directory, but are also placed inside their
| own subdirectory and they extend the CI_Driver_Library class. They
| offer multiple interchangeable driver options.
|
| Prototype:
|
|    $autoload['drivers'] = array('cache');
|
| You can also supply an alternative property name to be assigned in
| the controller:
|
|    $autoload['drivers'] = array('cache' => 'cch');
|
 */
$autoload['drivers'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Helper Files
| -------------------------------------------------------------------
| Prototype:
|
|    $autoload['helper'] = array('url', 'file');
 */
$autoload['helper'] = array('url', 'html', 'directory', 'form', 'funciones_helper', 'file', 'path');

/*
| -------------------------------------------------------------------
|  Auto-load Config files
| -------------------------------------------------------------------
| Prototype:
|
|    $autoload['config'] = array('config1', 'config2');
|
| NOTE: This item is intended for use ONLY if you have created custom
| config files.  Otherwise, leave it blank.
|
 */
$autoload['config'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Language files
| -------------------------------------------------------------------
| Prototype:
|
|    $autoload['language'] = array('lang1', 'lang2');
|
| NOTE: Do not include the "_lang" part of your file.  For example
| "codeigniter_lang.php" would be referenced as array('codeigniter');
|
 */
$autoload['language'] = array();

/*
| -------------------------------------------------------------------
|  Auto-load Models
| -------------------------------------------------------------------
| Prototype:
|
|    $autoload['model'] = array('first_model', 'second_model');
|
| You can also supply an alternative model name to be assigned
| in the controller:
|
|    $autoload['model'] = array('first_model' => 'first');
 */
$autoload['model'] = array(
    'notificaciones_whatsapp_model',
    'api_traer_documentos_model',
    'generales_model',
    'area_model',
    'avance_model',
    'cat_portales_model',
    'cat_subclientes_model',
    'candidato_avance_model',
    'candidato_conclusion_model',
    'candidato_estudio_model',
    'candidato_documentacion_model',
    'candidato_empresa_model',
    'candidato_familiar_model',
    'candidato_finanzas_model',
    'candidato_global_model',
    'candidato_investigacion_model',
    'candidato_laboral_model',
    'candidato_model',
    'candidato_ref_academica_model',
    'candidato_ref_personal_model',
    'candidato_ref_vecinal_model',
    'candidato_salud_model',
    'candidato_seccion_model',
    'candidato_servicio_model',
    'candidato_social_model',
    'candidato_vivienda_model',
    'calendario_model',
    'cat_usuario_model',
    'cat_cliente_model',
    'cat_generos_model',
    'cat_puestos_model',
    'cliente_alternativo_model',
    'cliente_control_model',
    'cliente_general_model',
    'cliente_esolutions_model',
    'cliente_hcl_model',
    'cliente_model',
    'cliente_ust_model',
    'configuracion_model',
    'criminal_model',
    'cronjobs_model',
    'documentacion_model',
    'domicilio_model',
    'doping_model',
    'estadistica_model',
    'formulario_model',
    'funciones_model',
    'gap_model',
    'laboratorio_model',
    'medico_model',
    'notificacion_model',
    'psicometrico_model',
    'requisicion_model',
    'reclutamiento_model',
    'referencia_cliente_model',
    'referencia_profesional_model',
    'reporte_model',
    'rol_model',
    'subcliente_panel_model',
    'subcliente_model',
    'subcliente_rts_model',
    'usuario_model',
    'visita_model',
    'covid_model',
    'empleados_model',
    'proveedores_model',
    'comunicacion_model',

);
