<?php
// =======================================================
// 🟦 SECCIÓN 1 — ETIQUETAS GENERALES DE LA INTERFAZ (UI)
// =======================================================

$lang['perm_title']   = "User Permissions";
$lang['perm_user_id'] = "User ID";
$lang['perm_module']  = "Module";

$lang['perm_search']             = "Search";
$lang['perm_search_placeholder'] = "Search permissions...";

$lang['perm_prev_config'] = "Previous configuration";
$lang['perm_no_prev']     = "No previous configuration (all set to Inherit).";

$lang['perm_allow']   = "Allow";
$lang['perm_deny']    = "Deny";
$lang['perm_inherit'] = "Inherit";

$lang['perm_col_permission'] = "Permission";
$lang['perm_col_action']     = "Action";
$lang['perm_col_sensitive']  = "Sensitive";
$lang['perm_col_effect']     = "Effect";

$lang['perm_sensitive'] = "Sensitive";
$lang['perm_copy_key']  = "Copy key";
$lang['perm_drag']      = "Drag section";
$lang['perm_drag_help'] = "Drag to reorder sections";

$lang['perm_loading']        = "Loading…";
$lang['perm_save_changes']   = "Save changes";
$lang['perm_saved_ok']       = "Permissions saved successfully.";
$lang['perm_error_saving']   = "Could not save permissions.";
$lang['perm_no_permissions'] = "No permissions found.";
$lang['perm_modal_title']    = "Permissions for user #";

// =======================================================
// 🟦 SECCIÓN 2 — TRADUCCIONES DE MÓDULOS PRINCIPALES
// =======================================================

$lang['perm_module_admin']           = "Administration";
$lang['perm_module_comunicacion']    = "Communication";
$lang['perm_module_comunicacion360'] = "Communication 360";
$lang['perm_module_dashboards']      = "Dashboards";
$lang['perm_module_empleados']       = "Employees";
$lang['perm_module_exempleados']     = "Former employees";
$lang['perm_module_mi_cuenta']       = "My account";
$lang['perm_module_pre_empleo']      = "Pre-employment";
$lang['perm_module_reclutamiento']   = "Recruitment";
$lang['perm_module_reportes']        = "Reports";

// =======================================================
// 🟦 SECCIÓN 3 — PERMISOS DEL MÓDULO: EMPLEADOS
// =======================================================

// ----- EXPEDIENTE GENERALES -----
$lang['perm_empleados.expediente.generales.ver']                = "View employee general data";
$lang['perm_empleados.expediente.generales.crear']              = "Create/add general data";
$lang['perm_empleados.expediente.generales.editar']             = "Edit general data";
$lang['perm_empleados.expediente.generales.eliminar']           = "Delete general data";
$lang['perm_empleados.expediente.generales.exportar_plantilla'] = "Export general template";
$lang['perm_empleados.expediente.generales.carga_masiva']       = "Bulk upload of general data";

// ----- EXPEDIENTE LABORALES -----
$lang['perm_empleados.expediente.laborales.ver']              = "View employment data";
$lang['perm_empleados.expediente.laborales.crear']            = "Create/add employment data";
$lang['perm_empleados.expediente.laborales.editar']           = "Edit employment data";
$lang['perm_empleados.expediente.laborales.eliminar']         = "Delete employment data";
$lang['perm_empleados.expediente.laborales.prenomina_ver']    = "View pre-payroll";
$lang['perm_empleados.expediente.laborales.prenomina_editar'] = "Edit pre-payroll";

// ----- EXPEDIENTE MÉDICA -----
$lang['perm_empleados.expediente.medica.ver']                = "View medical information";
$lang['perm_empleados.expediente.medica.crear']              = "Create/add medical information";
$lang['perm_empleados.expediente.medica.editar']             = "Edit medical information";
$lang['perm_empleados.expediente.medica.eliminar']           = "Delete medical information";
$lang['perm_empleados.expediente.medica.exportar_plantilla'] = "Export medical template";
$lang['perm_empleados.expediente.medica.carga_masiva']       = "Bulk upload of medical data";

// ----- DOCUMENTOS -----
$lang['perm_empleados.expediente.documentos.ver']      = "View documents";
$lang['perm_empleados.expediente.documentos.subir']    = "Upload documents";
$lang['perm_empleados.expediente.documentos.editar']   = "Edit document metadata";
$lang['perm_empleados.expediente.documentos.eliminar'] = "Delete documents";

// ----- BGV / EXÁMENES -----
$lang['perm_empleados.expediente.bgv_examenes.ver']               = "View BGV and exams";
$lang['perm_empleados.expediente.bgv_examenes.subir']             = "Upload BGV/exams";
$lang['perm_empleados.expediente.bgv_examenes.editar']            = "Edit BGV/exams";
$lang['perm_empleados.expediente.bgv_examenes.eliminar']          = "Delete BGV/exams";
$lang['perm_empleados.expediente.bgv_examenes.solicitar_externa'] = "Request external evaluation";

// ----- CURSOS -----
$lang['perm_empleados.cursos.ver']              = "View courses/trainings";
$lang['perm_empleados.cursos.agregar_interno']  = "Add internal course";
$lang['perm_empleados.cursos.agregar_externo']  = "Add external course";
$lang['perm_empleados.cursos.editar']           = "Edit courses";
$lang['perm_empleados.cursos.eliminar']         = "Delete courses";
$lang['perm_empleados.cursos.exportar_matriz']  = "Export course matrix";
$lang['perm_empleados.cursos.ver_link_publico'] = "View public link";

// ----- EVALUACIONES -----
$lang['perm_empleados.evaluaciones.ver']                  = "View evaluations";
$lang['perm_empleados.evaluaciones.subir_interna']        = "Upload internal evaluation";
$lang['perm_empleados.evaluaciones.solicitar_externa']    = "Request external evaluation";
$lang['perm_empleados.evaluaciones.editar']               = "Edit evaluation";
$lang['perm_empleados.evaluaciones.eliminar']             = "Delete evaluation";
$lang['perm_empleados.evaluaciones.descargar_resultados'] = "Download results";
// --- Employee record · Approvals ---
$lang['perm_empleados.expediente.aprobaciones.aprobar']  = "Approve renewals submitted by employees";
$lang['perm_empleados.expediente.aprobaciones.rechazar'] = "Reject renewals submitted by employees";
$lang['perm_empleados.expediente.aprobaciones.ver']      = "View pending approval requests";

// --- Employee record · Shared with administration ---
$lang['perm_empleados.expediente.compartidos_admin.descargar'] = "Download files shared with administration";
$lang['perm_empleados.expediente.compartidos_admin.ver']       = "View documents, courses, and exams shared with administration";

// --- Employee record · General data ---
$lang['perm_empleados.expediente.generales.cambiar_sucursal']      = "Move an employee to another branch or project";
$lang['perm_empleados.expediente.generales.config_notificaciones'] = "Configure employee record notifications";
$lang['perm_empleados.expediente.generales.descargar_plantilla']   = "Download template";

// --- Employee record · Shared internal information ---
$lang['perm_empleados.expediente.informacion_interna_compartida.descargar'] = "Download internal information shared with administration";
$lang['perm_empleados.expediente.informacion_interna_compartida.ver']       = "View internal information shared with administration";

// --- Employee record · Internal information ---
$lang['perm_empleados.expediente.informacion_interna.compartir_documento'] = "Configure internal document sharing";
$lang['perm_empleados.expediente.informacion_interna.crear_directorio']    = "Create internal information directories";
$lang['perm_empleados.expediente.informacion_interna.descargar_documento'] = "Download internal information documents";
$lang['perm_empleados.expediente.informacion_interna.editar_directorio']   = "Edit internal information directories";
$lang['perm_empleados.expediente.informacion_interna.eliminar_directorio'] = "Delete internal information directories";
$lang['perm_empleados.expediente.informacion_interna.eliminar_documento']  = "Delete internal information documents";
$lang['perm_empleados.expediente.informacion_interna.subir_documento']     = "Upload internal information documents";
$lang['perm_empleados.expediente.informacion_interna.ver']                 = "View internal information";

// --- Employee record · Employment data ---
$lang['perm_empleados.expediente.laborales.carga_masiva']        = "Bulk upload employment information";
$lang['perm_empleados.expediente.laborales.descargar_plantilla'] = "Download employment information template";

// RECORD - APPROVALS AND SHARED FILES
$lang['perm_section_expediente_aprobaciones'] =
    "Record · Approvals";

$lang['perm_section_expediente_compartidos_admin'] =
    "Record · Shared with administrators";

$lang['perm_section_expediente_informacion_interna_compartida'] =
    "Record · Shared internal information";
$lang['perm_section_ejecutivo']                      = "Executive";
$lang['perm_section_nomina']                         = "Payroll";
$lang['perm_section_operativo']                      = "Operational";
$lang['perm_section_organigrama']                    = "Organization chart";
$lang['perm_section_dashboards']                     = "Dashboards";
$lang['perm_section_expediente_informacion_interna'] =
    "Employee record · Internal information";
// =======================================================
// 🟦 SECCIÓN 4 — MÓDULO RECLUTAMIENTO
// =======================================================

// ----- REQUISICIONES -----
$lang['perm_reclutamiento.reqs.ver']                 = "View requisition list";
$lang['perm_reclutamiento.reqs.crear']               = "Create requisition";
$lang['perm_reclutamiento.reqs.asignar']             = "Assign requisition";
$lang['perm_reclutamiento.reqs.editar']              = "Edit requisition";
$lang['perm_reclutamiento.reqs.ver_completa']        = "View full requisition";
$lang['perm_reclutamiento.reqs.iniciar']             = "Start requisition";
$lang['perm_reclutamiento.reqs.descargar_pdf']       = "Download requisition PDF";
$lang['perm_reclutamiento.reqs.eliminar']            = "Delete requisition";
$lang['perm_reclutamiento.reqs.usuarios_asig_del']   = "Remove assigned users";
$lang['perm_reclutamiento.reqs.registrar_aspirante'] = "Register applicant";
$lang['perm_reclutamiento.reqs.registrar_ingreso']   = "Register applicant hiring";
$lang['perm_reclutamiento.reqs.editar_aspirante']    = "Edit applicant";
$lang['perm_reclutamiento.reqs.detener_requisicion'] = "Stop requisition";
$lang['perm_reclutamiento.reqs.link_requisicion']    = "Requisition registration link";
$lang['perm_reclutamiento.reqs.reactivar']           = "Reactivate requisition";

// ----- ASPIRANTES -----
$lang['perm_reclutamiento.aspirantes.editar']              = "Edit applicant";
$lang['perm_reclutamiento.aspirantes.asignar_req']         = "Assign to requisition";
$lang['perm_reclutamiento.aspirantes.registrar_mov']       = "Register movements";
$lang['perm_reclutamiento.aspirantes.ver_historial']       = "View movement history";
$lang['perm_reclutamiento.aspirantes.cargar_docs']         = "Upload documents";
$lang['perm_reclutamiento.aspirantes.actualizar_docs']     = "Update documents";
$lang['perm_reclutamiento.aspirantes.eliminar_aspirante']  = "Delete applicant";
$lang['perm_reclutamiento.aspirantes.comentarios_cliente'] = "Register/view client comments";
$lang['perm_reclutamiento.aspirantes.cambiar_status_req']  = "Change requisition status";

// ----- BOLSA DE TRABAJO -----
$lang['perm_reclutamiento.bolsa_trabajo.descargar_plantilla']   = "Download template";
$lang['perm_reclutamiento.bolsa_trabajo.subir_plantilla']       = "Upload template";
$lang['perm_reclutamiento.bolsa_trabajo.crear_requisicion']     = "Create requisition";
$lang['perm_reclutamiento.bolsa_trabajo.asignar_aspirante']     = "Assign applicant";
$lang['perm_reclutamiento.bolsa_trabajo.generar_link_registro'] = "Generate registration link";

$lang['perm_reclutamiento.bolsa_trabajo.editar_aspirante']      = "Edit applicant";
$lang['perm_reclutamiento.bolsa_trabajo.subir_docs']            = "Upload applicant documents";
$lang['perm_reclutamiento.bolsa_trabajo.cambiar_status']        = "Change applicant status";
$lang['perm_reclutamiento.bolsa_trabajo.bloquear_aspirante']    = "Block applicant";
$lang['perm_reclutamiento.bolsa_trabajo.asignarlo_requisicion'] = "Assign applicant to requisition";

$lang['perm_reclutamiento.bolsa_trabajo.ver_detalles']    = "View applicant details";
$lang['perm_reclutamiento.bolsa_trabajo.ver_empleos']     = "View jobs registered by applicant";
$lang['perm_reclutamiento.bolsa_trabajo.ver_movimientos'] = "View applicant movements";

// ----- FINALIZADAS -----
$lang['perm_reclutamiento.finalizadas.ver_cv'] = "View CV in finalized requisitions";

// =======================================================
// 🟦 SECCIÓN 5 — PRE-EMPLEO
// =======================================================

$lang['perm_pre_empleo.sucursales.ver']                     = "View assigned branches";
$lang['perm_pre_empleo.sucursales.eliminar_acceso_usuario'] = "Remove user access";
$lang['perm_pre_empleo.sucursales.ver_procesos']            = "View processes";

$lang['perm_pre_empleo.procesos.registrar_candidato'] = "Register candidate";

$lang['perm_pre_empleo.candidatos.enviar_a_empleados']  = "Send to employees";
$lang['perm_pre_empleo.candidatos.ver_info']            = "View candidate info";
$lang['perm_pre_empleo.candidatos.cambiar_de_sucursal'] = "Change candidate branch";
$lang['perm_pre_empleo.candidatos.eliminar']            = "Delete candidate";

$lang['perm_pre_empleo.documentos.ver']      = "View documents";
$lang['perm_pre_empleo.documentos.cargar']   = "Upload documents";
$lang['perm_pre_empleo.documentos.eliminar'] = "Delete documents";

$lang['perm_pre_empleo.examenes.ver']      = "View exams";
$lang['perm_pre_empleo.examenes.cargar']   = "Upload exams";
$lang['perm_pre_empleo.examenes.eliminar'] = "Delete exams";

// =======================================================
// 🟦 SECCIÓN 6 — EX EMPLEADOS
// =======================================================

$lang['perm_exempleados.expediente.generales.ver']        = "View general data";
$lang['perm_exempleados.expediente.generales.actualizar'] = "Update general data";

$lang['perm_exempleados.expediente.medica.ver']        = "View medical information";
$lang['perm_exempleados.expediente.medica.actualizar'] = "Update medical information";

$lang['perm_exempleados.expediente.documentos.ver']      = "View historical documents";
$lang['perm_exempleados.expediente.documentos.eliminar'] = "Delete historical documents";

$lang['perm_exempleados.expediente.documentos_salida.ver']        = "View exit documents";
$lang['perm_exempleados.expediente.documentos_salida.crear']      = "Create exit document";
$lang['perm_exempleados.expediente.documentos_salida.actualizar'] = "Update exit document";
$lang['perm_exempleados.expediente.documentos_salida.eliminar']   = "Delete exit document";

$lang['perm_exempleados.expediente.recontratar']        = "Rehire former employee";
$lang['perm_exempleados.expediente.enviar_a_empleados'] = "Return to Employees module";

$lang['perm_exempleados.conclusiones.ver']      = "View exit conclusions";
$lang['perm_exempleados.conclusiones.agregar']  = "Add conclusion";
$lang['perm_exempleados.conclusiones.eliminar'] = "Delete conclusion";

$lang['perm_exempleados.notificaciones.configurar'] = "Configure expiration notifications";

// =======================================================
// 🟦 SECCIÓN 7 — COMUNICACIÓN
// =======================================================

$lang['perm_comunicacion.sucursales.seleccionar_multiple'] = "Select multiple branches";

// --- Nómina ---
$lang['perm_comunicacion.nomina.periodos.ver']    = "View payroll periods";
$lang['perm_comunicacion.nomina.periodos.crear']  = "Create payroll period";
$lang['perm_comunicacion.nomina.periodos.editar'] = "Edit payroll period";

$lang['perm_comunicacion.nomina.prenomina.crear']            = "Create pre-payroll";
$lang['perm_comunicacion.nomina.prenomina.editar']           = "Edit pre-payroll";
$lang['perm_comunicacion.nomina.prenomina.descargar_excel']  = "Download pre-payroll Excel";
$lang['perm_comunicacion.nomina.prenomina.modificar_celdas'] = "Modify spreadsheet cells";

$lang['perm_comunicacion.nomina.historial.ver']    = "View payroll history";
$lang['perm_comunicacion.nomina.historial.editar'] = "Edit saved payroll";

// --- Calendario ---
$lang['perm_comunicacion.calendario.ver_meses']        = "View calendar months";
$lang['perm_comunicacion.calendario.registrar_evento'] = "Register event/incident";
$lang['perm_comunicacion.calendario.guardar_eventos']  = "Save events";
$lang['perm_comunicacion.calendario.eliminar_evento']  = "Delete event";
$lang['perm_comunicacion.calendario.ver_dia']          = "View daily events";
$lang['perm_comunicacion.calendario.descargar_evento'] = "Download event/evidence";

// --- Mensajería ---
$lang['perm_comunicacion.mensajeria.configurar_columnas']  = "Configure columns";
$lang['perm_comunicacion.mensajeria.crear_plantilla']      = "Create template";
$lang['perm_comunicacion.mensajeria.actualizar_plantilla'] = "Update template";
$lang['perm_comunicacion.mensajeria.enviar_masivo']        = "Send bulk messages";

// --- Recordatorios ---
$lang['perm_comunicacion.recordatorios.ver']      = "View reminders";
$lang['perm_comunicacion.recordatorios.crear']    = "Create reminder";
$lang['perm_comunicacion.recordatorios.editar']   = "Edit reminder";
$lang['perm_comunicacion.recordatorios.eliminar'] = "Delete reminder";

// =======================================================
// 🟦 SECCIÓN 8 — ADMINISTRACIÓN
// =======================================================

// --- Menús ---
$lang['perm_admin.usuarios_internos.__menu.ver'] = "View Internal Users menu";
$lang['perm_admin.sucursales.__menu.ver']        = "View Branches menu";

// --- Usuarios internos ---
$lang['perm_admin.usuarios_internos.ver']                = "View internal users";
$lang['perm_admin.usuarios_internos.crear']              = "Create internal user";
$lang['perm_admin.usuarios_internos.editar']             = "Edit internal user";
$lang['perm_admin.usuarios_internos.cambiar_estado']     = "Activate/Deactivate user";
$lang['perm_admin.usuarios_internos.reset_credenciales'] = "Reset credentials";
$lang['perm_admin.usuarios_internos.config_permisos']    = "Configure permissions";
$lang['perm_admin.usuarios_internos.eliminar']           = "Delete internal user";

// --- Sucursales ---
$lang['perm_admin.sucursales.ver']            = "View branches";
$lang['perm_admin.sucursales.crear']          = "Create branch";
$lang['perm_admin.sucursales.editar']         = "Edit branch";
$lang['perm_admin.sucursales.cambiar_estado'] = "Activate/Deactivate branch";
$lang['perm_admin.sucursales.eliminar']       = "Delete branch";
$lang['perm_admin.sucursales.generar_link']   = "Generate link";
$lang['perm_admin.sucursales.ver_accesos']    = "View branch accesses";

// =======================================================
// 🟦 SECCIÓN 9 — REPORTES
// =======================================================

$lang['perm_reportes.__menu.ver']                 = "View Reports menu";
$lang['perm_reportes.sucursales_excel.descargar'] = "Download branch report (Excel)";
$lang['perm_reportes.reclutamiento.proceso']      = "Recruitment process report";
$lang['perm_reportes.empleados.descargar']        = "Download employee report (Excel)";
$lang['perm_reportes.exempleados.descargar']      = "Download former employee report (Excel)";

$lang['perm_reportes.rotacion.descargar'] = "Download employee turnover report (Excel)";

// =======================================================
// 🟦 SECCIÓN 10 — DASHBOARDS
// =======================================================

$lang['perm_dashboards.general.__menu.ver']         = "View General Dashboard";
$lang['perm_dashboards.reclutamiento.__menu.ver']   = "View Recruitment Dashboard";
$lang['perm_dashboards.pre_empleo.__menu.ver']      = "View Pre-employment Dashboard";
$lang['perm_dashboards.medios_contacto.__menu.ver'] = "View Contact Methods Dashboard";
$lang['perm_dashboards.examenes.__menu.ver']        = "View Exams Dashboard";

$lang['perm_dashboards.general.ver']         = "View general dashboard";
$lang['perm_dashboards.reclutamiento.ver']   = "View recruitment dashboard";
$lang['perm_dashboards.pre_empleo.ver']      = "View pre-employment dashboard";
$lang['perm_dashboards.medios_contacto.ver'] = "View contact methods";
$lang['perm_dashboards.examenes.ver']        = "View exams";


$lang['perm_dashboards.ejecutivo.ver']                 = "View executive dashboard";
$lang['perm_dashboards.nomina.ver']                    = "View payroll indicators and charts";
$lang['perm_dashboards.operativo.ver']                 = "View operational dashboard";
$lang['perm_dashboards.organigrama.asignar_empleados'] = "Assign or unlink employees from the organization chart";
$lang['perm_dashboards.organigrama.crear']             = "Create organization chart nodes";
$lang['perm_dashboards.organigrama.editar']            = "Edit organization chart nodes and settings";
$lang['perm_dashboards.organigrama.eliminar']          = "Delete organization chart nodes";
$lang['perm_dashboards.organigrama.ver']               = "View organization chart";
$lang['perm_module.dashboards.ver']                    = "View Dashboards module";

// =======================================================
// 🟦 SECCIÓN 11 — MI CUENTA
// =======================================================

$lang['perm_mi_cuenta.__menu.ver'] = "View My Account menu";

$lang['perm_mi_cuenta.logo.actualizar'] = "Update platform logo";

$lang['perm_mi_cuenta.pagos.confirmar']     = "Confirm subscription/payment";
$lang['perm_mi_cuenta.pagos.generar_link']  = "Generate payment link";
$lang['perm_mi_cuenta.pagos.ver_historial'] = "View payment history";

$lang['perm_mi_cuenta.privacidad_tc.cargar']        = "Upload/Update Privacy Notice & Terms";
$lang['perm_mi_cuenta.privacidad_tc.eliminar']      = "Delete Privacy Notice/Terms";
$lang['perm_mi_cuenta.privacidad_tc.ver_descargar'] = "View/Download Privacy Notice & Terms";

$lang['perm_mi_cuenta.tc.descargar'] = "Download Terms & Conditions";
$lang['perm_mi_cuenta.tc.ver']       = "View Terms & Conditions";

// --------------------------------------
// SECTIONS
// --------------------------------------
$lang['perm_section___menu'] = "Menu";
$lang['perm_section_cursos']       = "Courses";
$lang['perm_section_evaluaciones'] = "Evaluations";

$lang['perm_section_expediente_bgv_examenes'] = "Record · BGV Exams";
$lang['perm_section_expediente_documentos']   = "Record · Documents";
$lang['perm_section_expediente_foto']         = "Record · Photo";
$lang['perm_section_expediente_generales']    = "Record · General Data";
$lang['perm_section_expediente_laborales']    = "Record · Employment Data";
$lang['perm_section_expediente_medica']       = "Record · Medical Data";

// ====== SECTION LABELS ======
$lang['perm_section_sucursales']        = "Branches";
$lang['perm_section_usuarios_internos'] = "Internal users";

$lang['perm_section_calendario'] = "Calendar";
$lang['perm_section_mensajeria'] = "Messaging";

$lang['perm_section_nomina_historial'] = "Payroll · History";
$lang['perm_section_nomina_periodos']  = "Payroll · Periods";
$lang['perm_section_nomina_prenomina'] = "Payroll · Pre-payroll";

$lang['perm_section_recordatorios'] = "Reminders";

$lang['perm_section_examenes']        = "Exams";
$lang['perm_section_general']         = "General";
$lang['perm_section_medios_contacto'] = "Contact methods";

$lang['perm_section_pre_empleo']    = "Pre-employment";
$lang['perm_section_reclutamiento'] = "Recruitment";


$lang['perm_section_conclusiones']                 = "Conclusions";
$lang['perm_section_expediente']                   = "Record";
$lang['perm_section_expediente_documentos_salida'] = "Record · Exit documents";

$lang['perm_section_notificaciones'] = "Notifications";
$lang['perm_section_logo']           = "Logo";
$lang['perm_section_pagos']          = "Payments";
$lang['perm_section_privacidad_tc']  = "Privacy & Terms";
$lang['perm_section_tc']             = "Terms & Conditions";

$lang['perm_section_candidatos'] = "Candidates";
$lang['perm_section_documentos'] = "Documents";
$lang['perm_section_procesos']   = "Processes";

$lang['perm_section_aspirantes']    = "Applicants";
$lang['perm_section_bolsa_trabajo'] = "Job board";
$lang['perm_section_finalizadas']   = "Completed requisitions";

$lang['perm_section_reqs']      = "Requisitions";
$lang['perm_section_empleados'] = "Employees";

$lang['perm_section_sucursales_excel']                          = "Branches · Excel Report";
$lang['perm_empleados.expediente.foto.actualizar']              = "Update employee profile photo";
$lang['perm_empleados.expediente.generales.enviar_exempleados'] = "Move employee to Former Employees module";
$lang['perm_empleados.expediente.generales.ver_detalles']       = "View employee record details";
// ===== EMPLOYEES → expediente.generales =====


// ===== FORMER EMPLOYEES → MENU =====

$lang['perm_exempleados.__menu.ver']
= "View Former Employees module in menu";

// ===== FORMER EMPLOYEES → EXPEDIENTE =====

$lang['perm_exempleados.expediente.__header.ver']
= "View employee file header";

$lang['perm_exempleados.expediente.boton_expediente.ver']
                                                     = "View \"Employee File\" button in Former Employees list";
$lang['perm_exempleados.expediente.foto.actualizar'] = "Update profile photo in the record";

// --- General access ---
$lang['perm_comunicacion.calendario']       = "General access to Calendar";
$lang['perm_comunicacion.mensajeria']       = "General access to Messaging";
$lang['perm_comunicacion.mensajeria.ver']   = "View Messaging module";
$lang['perm_comunicacion.nomina.historial'] = "General access to Payroll History";
$lang['perm_comunicacion.nomina.periodos']  = "General access to Payroll Periods";
$lang['perm_comunicacion.nomina.prenomina'] = "General access to Pre-payroll";
$lang['perm_comunicacion.sucursales']       = "General access to Branches";
$lang['perm_module.comunicacion.ver']       = "View Internal Communication module";

// =======================================================
// 🟦 SECTION: COMMUNICATION 360
// =======================================================

// --- Access ---
$lang['perm_comunicacion360.accesos.actualizar']    = "Update employee access and credentials";
$lang['perm_comunicacion360.accesos.cerrar_sesion'] = "Close active employee sessions";
$lang['perm_comunicacion360.accesos.eliminar']      = "Delete employee access";
$lang['perm_comunicacion360.accesos.generar']       = "Generate employee access";
$lang['perm_comunicacion360.accesos.ver']           = "View employee access";

// --- Access · Time entries ---
$lang['perm_comunicacion360.accesos.checadas.gestionar'] = "Administratively register, edit, or close time entries";
$lang['perm_comunicacion360.accesos.checadas.ver']       = "View employee time entries and metrics";

// --- Access · Events ---
$lang['perm_comunicacion360.accesos.eventos.registrar_horas_extra'] = "Register overtime events";
$lang['perm_comunicacion360.accesos.eventos.ver']                   = "View employee events and incidents";

// --- Access · IP addresses ---
$lang['perm_comunicacion360.accesos.ips.crear']    = "Register an authorized IP address";
$lang['perm_comunicacion360.accesos.ips.editar']   = "Edit an authorized IP address";
$lang['perm_comunicacion360.accesos.ips.eliminar'] = "Delete an authorized IP address";
$lang['perm_comunicacion360.accesos.ips.ver']      = "View employee authorized IP addresses";

// --- Access · Profile ---
$lang['perm_comunicacion360.accesos.perfil.ver'] = "View employee profile and operational analysis";

// --- Access · Reports ---
$lang['perm_comunicacion360.accesos.reportes.ver'] = "View and download attendance reports";

// --- Access · Tasks ---
$lang['perm_comunicacion360.accesos.tareas.comentar']            = "Add administrative comments to tasks";
$lang['perm_comunicacion360.accesos.tareas.eliminar_comentario'] = "Delete administrative task comments";
$lang['perm_comunicacion360.accesos.tareas.reabrir']             = "Reopen employee tasks";
$lang['perm_comunicacion360.accesos.tareas.ver']                 = "View tasks assigned to employees";

// --- Time clock · Schedules ---
$lang['perm_comunicacion360.checador.horarios.cambiar_estado'] = "Activate or deactivate time clock schedules";
$lang['perm_comunicacion360.checador.horarios.crear']          = "Create time clock schedules";
$lang['perm_comunicacion360.checador.horarios.editar']         = "Edit time clock schedules";
$lang['perm_comunicacion360.checador.horarios.ver']            = "View time clock schedules";

// --- Time clock · Templates ---
$lang['perm_comunicacion360.checador.plantillas.asignar']        = "Assign time entry templates to employees";
$lang['perm_comunicacion360.checador.plantillas.cambiar_estado'] = "Activate or deactivate time entry templates";
$lang['perm_comunicacion360.checador.plantillas.configurar']     = "Configure methods, locations, schedules, and approvers";
$lang['perm_comunicacion360.checador.plantillas.crear']          = "Create time clock configuration templates";
$lang['perm_comunicacion360.checador.plantillas.editar']         = "Edit time clock configuration templates";
$lang['perm_comunicacion360.checador.plantillas.ver']            = "View time clock configuration templates";

// --- Time clock · Locations ---
$lang['perm_comunicacion360.checador.ubicaciones.crear']      = "Create authorized time clock locations";
$lang['perm_comunicacion360.checador.ubicaciones.editar']     = "Edit authorized time clock locations";
$lang['perm_comunicacion360.checador.ubicaciones.eliminar']   = "Delete authorized time clock locations";
$lang['perm_comunicacion360.checador.ubicaciones.generar_qr'] = "Generate or regenerate a location QR code";
$lang['perm_comunicacion360.checador.ubicaciones.ver']        = "View authorized time clock locations";
$lang['perm_comunicacion360.checador.ubicaciones.ver_qr']     = "View a location's fixed QR code";

// --- Imports · Time entries ---
$lang['perm_comunicacion360.importaciones.checadas.confirmar'] = "Confirm bulk time entry import";
$lang['perm_comunicacion360.importaciones.checadas.exportar']  = "Export the bulk time entry template";
$lang['perm_comunicacion360.importaciones.checadas.validar']   = "Validate the bulk time entry import file";

// --- Imports · Incidents ---
$lang['perm_comunicacion360.importaciones.incidencias.confirmar'] = "Confirm bulk incident import";
$lang['perm_comunicacion360.importaciones.incidencias.exportar']  = "Export the bulk incident template";
$lang['perm_comunicacion360.importaciones.incidencias.validar']   = "Validate the bulk incident import file";

// --- Incidents ---
$lang['perm_comunicacion360.incidencias.ver']           = "View the incident calendar and details";
$lang['perm_comunicacion360.incidencias.ver_evidencia'] = "View or download incident evidence";

// --- Task templates ---
$lang['perm_comunicacion360.plantillas.asignar']    = "Assign task templates to employees";
$lang['perm_comunicacion360.plantillas.crear']      = "Create task templates";
$lang['perm_comunicacion360.plantillas.desasignar'] = "Unassign task templates from employees";
$lang['perm_comunicacion360.plantillas.editar']     = "Edit task templates";
$lang['perm_comunicacion360.plantillas.eliminar']   = "Delete task templates";
$lang['perm_comunicacion360.plantillas.ver']        = "View task templates";

// --- Task catalog ---
$lang['perm_comunicacion360.tareas.crear']    = "Create tasks in the catalog";
$lang['perm_comunicacion360.tareas.editar']   = "Edit catalog tasks";
$lang['perm_comunicacion360.tareas.eliminar'] = "Delete catalog tasks";
$lang['perm_comunicacion360.tareas.ver']      = "View the task catalog";

// --- Module gate ---
$lang['perm_module.comunicacion360.ver']        = "View Communication 360 module";
$lang['perm_section_accesos']                   = "Access";
$lang['perm_section_accesos_checadas']          = "Access · Time entries";
$lang['perm_section_accesos_eventos']           = "Access · Events";
$lang['perm_section_accesos_ips']               = "Access · IP addresses";
$lang['perm_section_accesos_perfil']            = "Access · Profile";
$lang['perm_section_accesos_reportes']          = "Access · Reports";
$lang['perm_section_accesos_tareas']            = "Access · Tasks";
$lang['perm_section_checador_horarios']         = "Time clock · Schedules";
$lang['perm_section_checador_plantillas']       = "Time clock · Templates";
$lang['perm_section_checador_ubicaciones']      = "Time clock · Locations";
$lang['perm_section_importaciones_checadas']    = "Imports · Time entries";
$lang['perm_section_importaciones_incidencias'] = "Imports · Incidents";
$lang['perm_section_incidencias']               = "Incidents";
$lang['perm_section_plantillas']                = "Task templates";
$lang['perm_section_tareas']                    = "Task catalog";
$lang['perm_section_comunicacion360']           = "Communication 360";
$lang['perm_section_exempleados']               = "Former employees";
$lang['perm_section_rotacion']                  = "Employee turnover";
