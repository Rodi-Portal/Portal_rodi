<?php
// ======================================================
// 🟦 SECCIÓN: TEXTOS GENERALES DE LA INTERFAZ
// ======================================================

$lang['perm_title']              = "Permisos del Usuario";
$lang['perm_user_id']            = "ID del Usuario";
$lang['perm_module']             = "Módulo";
$lang['perm_search']             = "Buscar";
$lang['perm_search_placeholder'] = "Buscar permisos...";
$lang['perm_prev_config']        = "Configuración previa";
$lang['perm_no_prev']            = "Sin configuración previa (todo en Heredar).";

$lang['perm_allow']   = "Permitir";
$lang['perm_deny']    = "Denegar";
$lang['perm_inherit'] = "Heredar";

$lang['perm_col_permission'] = "Permiso";
$lang['perm_col_action']     = "Acción";
$lang['perm_col_sensitive']  = "Sensible";
$lang['perm_col_effect']     = "Efecto";

$lang['perm_sensitive'] = "Sensible";
$lang['perm_copy_key']  = "Copiar clave";
$lang['perm_drag']      = "Arrastrar sección";
$lang['perm_drag_help'] = "Arrastra para reordenar secciones";

$lang['perm_loading']        = "Cargando…";
$lang['perm_save_changes']   = "Guardar cambios";
$lang['perm_saved_ok']       = "Permisos guardados exitosamente.";
$lang['perm_error_saving']   = "No se pudieron guardar los permisos.";
$lang['perm_no_permissions'] = "No se encontraron permisos.";
$lang['perm_modal_title']    = "Permisos del usuario #";

// ======================================================
// 🟩 SECCIÓN: EMPLEADOS
// ======================================================

// --- Expediente > Generales ---
$lang['perm_empleados.expediente.generales.ver']                = "Ver datos generales del empleado";
$lang['perm_empleados.expediente.generales.crear']              = "Crear/alta de datos generales";
$lang['perm_empleados.expediente.generales.editar']             = "Editar datos generales";
$lang['perm_empleados.expediente.generales.eliminar']           = "Eliminar datos generales";
$lang['perm_empleados.expediente.generales.exportar_plantilla'] = "Exportar plantilla de generales";
$lang['perm_empleados.expediente.generales.carga_masiva']       = "Carga masiva de datos generales";

// --- Expediente > Laborales ---
$lang['perm_empleados.expediente.laborales.ver']              = "Ver datos laborales";
$lang['perm_empleados.expediente.laborales.crear']            = "Crear/alta de datos laborales";
$lang['perm_empleados.expediente.laborales.editar']           = "Editar datos laborales";
$lang['perm_empleados.expediente.laborales.eliminar']         = "Eliminar datos laborales";
$lang['perm_empleados.expediente.laborales.prenomina_ver']    = "Ver prenómina";
$lang['perm_empleados.expediente.laborales.prenomina_editar'] = "Editar prenómina";

// --- Expediente > Médica ---
$lang['perm_empleados.expediente.medica.ver']                = "Ver información médica";
$lang['perm_empleados.expediente.medica.crear']              = "Crear/alta de información médica";
$lang['perm_empleados.expediente.medica.editar']             = "Editar información médica";
$lang['perm_empleados.expediente.medica.eliminar']           = "Eliminar información médica";
$lang['perm_empleados.expediente.medica.exportar_plantilla'] = "Exportar plantilla médica";
$lang['perm_empleados.expediente.medica.carga_masiva']       = "Carga masiva de datos médicos";

// --- Documentos ---
$lang['perm_empleados.expediente.documentos.ver']      = "Ver documentos";
$lang['perm_empleados.expediente.documentos.subir']    = "Subir documentos";
$lang['perm_empleados.expediente.documentos.editar']   = "Editar metadatos de documentos";
$lang['perm_empleados.expediente.documentos.eliminar'] = "Eliminar documentos";

// --- BGV / Exámenes ---
$lang['perm_empleados.expediente.bgv_examenes.ver']               = "Ver BGV y exámenes";
$lang['perm_empleados.expediente.bgv_examenes.subir']             = "Subir BGV/exámenes";
$lang['perm_empleados.expediente.bgv_examenes.editar']            = "Editar BGV/exámenes";
$lang['perm_empleados.expediente.bgv_examenes.eliminar']          = "Eliminar BGV/exámenes";
$lang['perm_empleados.expediente.bgv_examenes.solicitar_externa'] = "Solicitar evaluación externa";

// --- Expediente · Aprobaciones ---
$lang['perm_empleados.expediente.aprobaciones.aprobar']  = "Aprobar renovaciones enviadas por colaboradores";
$lang['perm_empleados.expediente.aprobaciones.rechazar'] = "Rechazar renovaciones enviadas por colaboradores";
$lang['perm_empleados.expediente.aprobaciones.ver']      = "Ver solicitudes pendientes de aprobación";

// --- Expediente · Compartidos con administración ---
$lang['perm_empleados.expediente.compartidos_admin.descargar'] = "Descargar archivos compartidos con administración";
$lang['perm_empleados.expediente.compartidos_admin.ver']       = "Ver documentos, cursos y exámenes compartidos con administración";

// --- Expediente · Generales ---
$lang['perm_empleados.expediente.generales.cambiar_sucursal']      = "Cambiar al empleado de sucursal o proyecto";
$lang['perm_empleados.expediente.generales.config_notificaciones'] = "Configurar notificaciones de expedientes de empleados";
$lang['perm_empleados.expediente.generales.descargar_plantilla']   = "Descargar plantilla";

// --- Expediente · Información interna compartida ---
$lang['perm_empleados.expediente.informacion_interna_compartida.descargar'] = "Descargar información interna compartida con administración";
$lang['perm_empleados.expediente.informacion_interna_compartida.ver']       = "Ver información interna compartida con administración";

// --- Expediente · Información interna ---
$lang['perm_empleados.expediente.informacion_interna.compartir_documento'] = "Configurar compartición de documentos internos";
$lang['perm_empleados.expediente.informacion_interna.crear_directorio']    = "Crear directorios de información interna";
$lang['perm_empleados.expediente.informacion_interna.descargar_documento'] = "Descargar documentos de información interna";
$lang['perm_empleados.expediente.informacion_interna.editar_directorio']   = "Editar directorios de información interna";
$lang['perm_empleados.expediente.informacion_interna.eliminar_directorio'] = "Eliminar directorios de información interna";
$lang['perm_empleados.expediente.informacion_interna.eliminar_documento']  = "Eliminar documentos de información interna";
$lang['perm_empleados.expediente.informacion_interna.subir_documento']     = "Subir documentos de información interna";
$lang['perm_empleados.expediente.informacion_interna.ver']                 = "Ver información interna";

// --- Expediente · Laborales ---
$lang['perm_empleados.expediente.laborales.carga_masiva']        = "Carga masiva de información laboral";
$lang['perm_empleados.expediente.laborales.descargar_plantilla'] = "Descargar plantilla de información laboral";

// --- Cursos ---
$lang['perm_empleados.cursos.ver']              = "Ver cursos/capacitaciones";
$lang['perm_empleados.cursos.agregar_interno']  = "Agregar curso interno";
$lang['perm_empleados.cursos.agregar_externo']  = "Agregar curso externo";
$lang['perm_empleados.cursos.editar']           = "Editar cursos";
$lang['perm_empleados.cursos.eliminar']         = "Eliminar cursos";
$lang['perm_empleados.cursos.exportar_matriz']  = "Exportar matriz de cursos";
$lang['perm_empleados.cursos.ver_link_publico'] = "Ver link público";

// --- Evaluaciones ---
$lang['perm_empleados.evaluaciones.ver']                  = "Ver evaluaciones";
$lang['perm_empleados.evaluaciones.subir_interna']        = "Subir evaluación interna";
$lang['perm_empleados.evaluaciones.solicitar_externa']    = "Solicitar evaluación externa";
$lang['perm_empleados.evaluaciones.editar']               = "Editar evaluación";
$lang['perm_empleados.evaluaciones.eliminar']             = "Eliminar evaluación";
$lang['perm_empleados.evaluaciones.descargar_resultados'] = "Descargar resultados";

// ======================================================
// 🟧 SECCIÓN: RECLUTAMIENTO
// ======================================================

// --- Requisiciones ---
$lang['perm_reclutamiento.reqs.ver']                 = "Ver listado de requisiciones";
$lang['perm_reclutamiento.reqs.crear']               = "Crear requisición";
$lang['perm_reclutamiento.reqs.asignar']             = "Asignar requisición";
$lang['perm_reclutamiento.reqs.editar']              = "Editar requisición";
$lang['perm_reclutamiento.reqs.ver_completa']        = "Ver requisición completa";
$lang['perm_reclutamiento.reqs.iniciar']             = "Iniciar requisición";
$lang['perm_reclutamiento.reqs.descargar_pdf']       = "Descargar requisición en PDF";
$lang['perm_reclutamiento.reqs.eliminar']            = "Eliminar requisición";
$lang['perm_reclutamiento.reqs.usuarios_asig_del']   = "Eliminar usuarios asignados";
$lang['perm_reclutamiento.reqs.registrar_aspirante'] = "Registrar aspirante";
$lang['perm_reclutamiento.reqs.registrar_ingreso']   = "Registrar ingreso del aspirante";
$lang['perm_reclutamiento.reqs.editar_aspirante']    = "Editar aspirante";
$lang['perm_reclutamiento.reqs.detener_requisicion'] = "Detener requisición";
$lang['perm_reclutamiento.reqs.link_requisicion']    = "Link para registrar requisición";
$lang['perm_reclutamiento.reqs.reactivar']           = "Reactivar requisición";
$lang['perm_reclutamiento.finalizadas.ver_cv']       = "Ver CV en requisiciones finalizadas";

// --- Bolsa de trabajo ---
$lang['perm_reclutamiento.bolsa_trabajo.descargar_plantilla']   = "Descargar plantilla";
$lang['perm_reclutamiento.bolsa_trabajo.subir_plantilla']       = "Subir plantilla";
$lang['perm_reclutamiento.bolsa_trabajo.crear_requisicion']     = "Crear requisición";
$lang['perm_reclutamiento.bolsa_trabajo.asignar_aspirante']     = "Asignar aspirante";
$lang['perm_reclutamiento.bolsa_trabajo.generar_link_registro'] = "Generar link de registro";
$lang['perm_reclutamiento.bolsa_trabajo.asignarlo_requisicion'] = "Asignar aspirante a requisición";
$lang['perm_reclutamiento.bolsa_trabajo.bloquear_aspirante']    = "Bloquear aspirante";
$lang['perm_reclutamiento.bolsa_trabajo.editar_aspirante']      = "Editar aspirante";
$lang['perm_reclutamiento.bolsa_trabajo.subir_docs']            = "Subir documentos del aspirante";
$lang['perm_reclutamiento.bolsa_trabajo.cambiar_status']        = "Cambiar estatus del aspirante";
$lang['perm_reclutamiento.bolsa_trabajo.ver_detalles']          = "Ver detalles del aspirante";

$lang['perm_reclutamiento.bolsa_trabajo.ver_movimientos'] = "Ver movimientos del aspirante";

// --- Aspirantes ---
$lang['perm_reclutamiento.aspirantes.editar']        = "Editar aspirante";
$lang['perm_reclutamiento.aspirantes.asignar_req']   = "Asignar a requisición";
$lang['perm_reclutamiento.aspirantes.registrar_mov'] = "Registrar movimientos";
$lang['perm_reclutamiento.aspirantes.ver_historial'] = "Ver historial de movimientos";

$lang['perm_reclutamiento.bolsa_trabajo.ver_empleos']      = "Ver empleos registrados por el aspirante";
$lang['perm_reclutamiento.aspirantes.cargar_docs']         = "Subir documentos";
$lang['perm_reclutamiento.aspirantes.actualizar_docs']     = "Actualizar documentos";
$lang['perm_reclutamiento.aspirantes.eliminar_aspirante']  = "Eliminar aspirante";
$lang['perm_reclutamiento.aspirantes.comentarios_cliente'] = "Registrar/ver comentarios del cliente";
$lang['perm_reclutamiento.aspirantes.cambiar_status_req']  = "Cambiar estatus de requisición";

// ======================================================
// 🟦 SECCIÓN: PRE-EMPLEO
// ======================================================

$lang['perm_pre_empleo.sucursales.ver']                     = "Ver sucursales asignadas";
$lang['perm_pre_empleo.sucursales.eliminar_acceso_usuario'] = "Eliminar acceso de usuario";
$lang['perm_pre_empleo.sucursales.ver_procesos']            = "Ver procesos";

$lang['perm_pre_empleo.procesos.registrar_candidato'] = "Registrar candidato";

$lang['perm_pre_empleo.candidatos.enviar_a_empleados']  = "Enviar a empleados";
$lang['perm_pre_empleo.candidatos.ver_info']            = "Ver información del candidato";
$lang['perm_pre_empleo.candidatos.cambiar_de_sucursal'] = "Cambiar candidato de sucursal";
$lang['perm_pre_empleo.candidatos.eliminar']            = "Eliminar candidato";

$lang['perm_pre_empleo.documentos.ver']      = "Ver documentos";
$lang['perm_pre_empleo.documentos.cargar']   = "Cargar documentos";
$lang['perm_pre_empleo.documentos.eliminar'] = "Eliminar documentos";

$lang['perm_pre_empleo.examenes.ver']      = "Ver exámenes";
$lang['perm_pre_empleo.examenes.cargar']   = "Cargar exámenes";
$lang['perm_pre_empleo.examenes.eliminar'] = "Eliminar exámenes";

// ======================================================
// 🟥 SECCIÓN: EX-EMPLEADOS
// ======================================================

$lang['perm_exempleados.expediente.generales.ver']        = "Ver datos generales";
$lang['perm_exempleados.expediente.generales.actualizar'] = "Actualizar datos generales";

$lang['perm_exempleados.expediente.medica.ver']        = "Ver información médica";
$lang['perm_exempleados.expediente.medica.actualizar'] = "Actualizar información médica";

$lang['perm_exempleados.expediente.documentos.ver']      = "Ver documentos históricos";
$lang['perm_exempleados.expediente.documentos.eliminar'] = "Eliminar documentos históricos";

$lang['perm_exempleados.expediente.documentos_salida.ver']        = "Ver documentos de salida";
$lang['perm_exempleados.expediente.documentos_salida.crear']      = "Crear documento de salida";
$lang['perm_exempleados.expediente.documentos_salida.actualizar'] = "Actualizar documento de salida";
$lang['perm_exempleados.expediente.documentos_salida.eliminar']   = "Eliminar documento de salida";

$lang['perm_exempleados.expediente.recontratar']        = "Recontratar exempleado";
$lang['perm_exempleados.expediente.enviar_a_empleados'] = "Regresar al módulo de empleados";

$lang['perm_exempleados.conclusiones.ver']      = "Ver conclusiones de salida";
$lang['perm_exempleados.conclusiones.agregar']  = "Agregar conclusión";
$lang['perm_exempleados.conclusiones.eliminar'] = "Eliminar conclusión";

$lang['perm_exempleados.notificaciones.configurar'] = "Configurar notificaciones de vencimiento";

// ======================================================
// 🟪 SECCIÓN: COMUNICACIÓN
// ======================================================

// --- Sucursales ---
$lang['perm_comunicacion.sucursales.seleccionar_multiple'] = "Seleccionar múltiples sucursales";

// --- Nómina / Periodos ---
$lang['perm_comunicacion.nomina.periodos.ver']    = "Ver periodos de nómina";
$lang['perm_comunicacion.nomina.periodos.crear']  = "Crear periodo de nómina";
$lang['perm_comunicacion.nomina.periodos.editar'] = "Editar periodo de nómina";

// --- Nómina / Prenómina ---
$lang['perm_comunicacion.nomina.prenomina.crear']            = "Crear prenómina";
$lang['perm_comunicacion.nomina.prenomina.editar']           = "Editar prenómina";
$lang['perm_comunicacion.nomina.prenomina.descargar_excel']  = "Descargar Excel de prenómina";
$lang['perm_comunicacion.nomina.prenomina.modificar_celdas'] = "Modificar celdas del spreadsheet";

// --- Nómina / Historial ---
$lang['perm_comunicacion.nomina.historial.ver']    = "Ver historial de nómina";
$lang['perm_comunicacion.nomina.historial.editar'] = "Editar nómina guardada";

// --- Calendario ---
$lang['perm_comunicacion.calendario.ver_meses']        = "Ver meses del calendario";
$lang['perm_comunicacion.calendario.registrar_evento'] = "Registrar evento/incidencia";
$lang['perm_comunicacion.calendario.guardar_eventos']  = "Guardar eventos";
$lang['perm_comunicacion.calendario.eliminar_evento']  = "Eliminar evento";
$lang['perm_comunicacion.calendario.ver_dia']          = "Ver eventos del día";
$lang['perm_comunicacion.calendario.descargar_evento'] = "Descargar evento/evidencia";

// --- Mensajería ---
$lang['perm_comunicacion.mensajeria.configurar_columnas']  = "Configurar columnas";
$lang['perm_comunicacion.mensajeria.crear_plantilla']      = "Crear plantilla";
$lang['perm_comunicacion.mensajeria.actualizar_plantilla'] = "Actualizar plantilla";
$lang['perm_comunicacion.mensajeria.enviar_masivo']        = "Enviar mensajes masivos";

// --- Recordatorios ---
$lang['perm_comunicacion.recordatorios.ver']      = "Ver recordatorios";
$lang['perm_comunicacion.recordatorios.crear']    = "Crear recordatorio";
$lang['perm_comunicacion.recordatorios.editar']   = "Editar recordatorio";
$lang['perm_comunicacion.recordatorios.eliminar'] = "Eliminar recordatorio";

// ======================================================
// 🟨 SECCIÓN: ADMINISTRACIÓN
// ======================================================

// --- Menú ---
$lang['perm_admin.usuarios_internos.__menu.ver'] = "Ver menú de usuarios internos";
$lang['perm_admin.sucursales.__menu.ver']        = "Ver menú de sucursales";

// --- Usuarios internos ---
$lang['perm_admin.usuarios_internos.ver']                = "Ver usuarios internos";
$lang['perm_admin.usuarios_internos.crear']              = "Crear usuario interno";
$lang['perm_admin.usuarios_internos.editar']             = "Editar usuario interno";
$lang['perm_admin.usuarios_internos.cambiar_estado']     = "Activar/Desactivar usuario";
$lang['perm_admin.usuarios_internos.reset_credenciales'] = "Resetear credenciales";
$lang['perm_admin.usuarios_internos.config_permisos']    = "Configurar permisos";
$lang['perm_admin.usuarios_internos.eliminar']           = "Eliminar usuario interno";

// --- Sucursales ---
$lang['perm_admin.sucursales.ver']            = "Ver sucursales";
$lang['perm_admin.sucursales.crear']          = "Crear sucursal";
$lang['perm_admin.sucursales.editar']         = "Editar sucursal";
$lang['perm_admin.sucursales.cambiar_estado'] = "Activar/Desactivar sucursal";
$lang['perm_admin.sucursales.eliminar']       = "Eliminar sucursal";
$lang['perm_admin.sucursales.generar_link']   = "Generar link";
$lang['perm_admin.sucursales.ver_accesos']    = "Ver accesos a la sucursal";

// ======================================================
// 🟫 SECCIÓN: REPORTES
// ======================================================

$lang['perm_reportes.__menu.ver']                 = "Ver menú de reportes";
$lang['perm_reportes.sucursales_excel.descargar'] = "Descargar reporte de sucursales (Excel)";
$lang['perm_reportes.empleados.descargar']        = "Descargar reporte de empleados (Excel)";
$lang['perm_reportes.reclutamiento.proceso']      = "Reporte de proceso de reclutamiento";
$lang['perm_reportes.exempleados.descargar']      = "Descargar reporte de exempleados (Excel)";

$lang['perm_reportes.rotacion.descargar'] = "Descargar reporte de rotación (Excel)";

// ======================================================
// 🟦 SECCIÓN: DASHBOARDS
// ======================================================

$lang['perm_dashboards.general.__menu.ver']         = "Ver Dashboard General";
$lang['perm_dashboards.reclutamiento.__menu.ver']   = "Ver Dashboard de Reclutamiento";
$lang['perm_dashboards.pre_empleo.__menu.ver']      = "Ver Dashboard de Pre-empleo";
$lang['perm_dashboards.medios_contacto.__menu.ver'] = "Ver Dashboard de Medios de contacto";
$lang['perm_dashboards.examenes.__menu.ver']        = "Ver Dashboard de Exámenes";

$lang['perm_dashboards.general.ver']                   = "Ver dashboard general";
$lang['perm_dashboards.reclutamiento.ver']             = "Ver dashboard de reclutamiento";
$lang['perm_dashboards.pre_empleo.ver']                = "Ver dashboard de pre-empleo";
$lang['perm_dashboards.medios_contacto.ver']           = "Ver métodos de contacto";
$lang['perm_dashboards.examenes.ver']                  = "Ver exámenes";
$lang['perm_dashboards.exportar']                      = "Exportar datos/imagen del dashboard";
$lang['perm_dashboards.ejecutivo.ver']                 = "Ver dashboard ejecutivo";
$lang['perm_dashboards.nomina.ver']                    = "Ver indicadores y gráficas de nómina";
$lang['perm_dashboards.operativo.ver']                 = "Ver dashboard operativo";
$lang['perm_dashboards.organigrama.asignar_empleados'] = "Asignar o desvincular empleados del organigrama";
$lang['perm_dashboards.organigrama.crear']             = "Crear nodos del organigrama";
$lang['perm_dashboards.organigrama.editar']            = "Editar nodos y configuración del organigrama";
$lang['perm_dashboards.organigrama.eliminar']          = "Eliminar nodos del organigrama";
$lang['perm_dashboards.organigrama.ver']               = "Ver organigrama";
$lang['perm_module.dashboards.ver']                    = "Ver módulo Dashboards";

// ======================================================
// 🟩 SECCIÓN: MI CUENTA
// ======================================================

$lang['perm_mi_cuenta.__menu.ver'] = "Ver menú Mi Cuenta";

$lang['perm_mi_cuenta.logo.actualizar'] = "Actualizar logo de la plataforma";

$lang['perm_mi_cuenta.pagos.confirmar']     = "Confirmar pago/suscripción";
$lang['perm_mi_cuenta.pagos.generar_link']  = "Generar link de pago";
$lang['perm_mi_cuenta.pagos.ver_historial'] = "Ver historial de pagos";

$lang['perm_mi_cuenta.privacidad_tc.cargar']        = "Cargar/actualizar Aviso de Privacidad y Términos";
$lang['perm_mi_cuenta.privacidad_tc.eliminar']      = "Eliminar Aviso/Términos";
$lang['perm_mi_cuenta.privacidad_tc.ver_descargar'] = "Ver/descargar Aviso y Términos";

$lang['perm_mi_cuenta.tc.descargar'] = "Descargar Términos y Condiciones";
$lang['perm_mi_cuenta.tc.ver']       = "Ver Términos y Condiciones";

// ======================================================
// 🟦 NOMBRES DE MÓDULOS (UI)
// ======================================================

$lang['perm_module_admin']           = "Administración";
$lang['perm_module_comunicacion']    = "Comunicación";
$lang['perm_module_comunicacion360'] = "Comunicación 360";
$lang['perm_module_dashboards']      = "Dashboards";
$lang['perm_module_empleados']       = "Empleados";
$lang['perm_module_exempleados']     = "Exempleados";
$lang['perm_module_mi_cuenta']       = "Mi cuenta";
$lang['perm_module_pre_empleo']      = "Pre-empleo";
$lang['perm_module_reclutamiento']   = "Reclutamiento";
$lang['perm_module_reportes']        = "Reportes";

// ----------------------------------------------------
// SECCIONES (Títulos de los bloques de permisos)
// ----------------------------------------------------



// Reclutamiento
$lang['perm_section_reclutamiento.reqs']          = "Reclutamiento · Requisiciones";
$lang['perm_section_reclutamiento.aspirantes']    = "Reclutamiento · Aspirantes";
$lang['perm_section_reclutamiento.bolsa_trabajo'] = "Reclutamiento · Bolsa de trabajo";
$lang['perm_section_reclutamiento.finalizadas']   = "Reclutamiento · Finalizadas";

// Pre-empleo
$lang['perm_section_pre_empleo.sucursales'] = "Pre-empleo · Sucursales";
$lang['perm_section_pre_empleo.procesos']   = "Pre-empleo · Procesos";
$lang['perm_section_pre_empleo.candidatos'] = "Pre-empleo · Candidatos";
$lang['perm_section_pre_empleo.documentos'] = "Pre-empleo · Documentos";
$lang['perm_section_pre_empleo.examenes']   = "Pre-empleo · Exámenes";

// Ex-empleados
$lang['perm_section_exempleados.expediente']     = "Ex-empleados · Expediente";
$lang['perm_section_exempleados.conclusiones']   = "Ex-empleados · Conclusiones";
$lang['perm_section_exempleados.notificaciones'] = "Ex-empleados · Notificaciones";

// Comunicación
$lang['perm_section_comunicacion.sucursales']       = "Comunicación · Sucursales";
$lang['perm_section_comunicacion.nomina.periodos']  = "Comunicación · Nómina · Períodos";
$lang['perm_section_comunicacion.nomina.prenomina'] = "Comunicación · Nómina · Prenómina";
$lang['perm_section_comunicacion.nomina.historial'] = "Comunicación · Nómina · Historial";
$lang['perm_section_comunicacion.calendario']       = "Comunicación · Calendario";
$lang['perm_section_comunicacion.mensajeria']       = "Comunicación · Mensajería";
$lang['perm_section_comunicacion.recordatorios']    = "Comunicación · Recordatorios";

// Admin
$lang['perm_section_admin.usuarios_internos'] = "Administración · Usuarios internos";
$lang['perm_section_admin.sucursales']        = "Administración · Sucursales";

// Reportes
$lang['perm_section_reportes'] = "Reportes";

// Dashboards
$lang['perm_section_dashboards.general']         = "Dashboard · General";
$lang['perm_section_dashboards.reclutamiento']   = "Dashboard · Reclutamiento";
$lang['perm_section_dashboards.pre_empleo']      = "Dashboard · Pre-empleo";
$lang['perm_section_dashboards.medios_contacto'] = "Dashboard · Medios de contacto";
$lang['perm_section_dashboards.examenes']        = "Dashboard · Exámenes";

// Mi Cuenta
$lang['perm_section_mi_cuenta.logo']          = "Mi Cuenta · Logo";
$lang['perm_section_mi_cuenta.pagos']         = "Mi Cuenta · Pagos";
$lang['perm_section_mi_cuenta.privacidad_tc'] = "Mi Cuenta · Avisos y Términos";
$lang['perm_section_mi_cuenta.tc']            = "Mi Cuenta · Términos y Condiciones";

// EXPEDIENTE - APROBACIONES Y COMPARTIDOS
$lang['perm_section_expediente_aprobaciones'] =
    "Expediente · Aprobaciones";

$lang['perm_section_expediente_compartidos_admin'] =
    "Expediente · Compartidos con administradores";

$lang['perm_section_expediente_informacion_interna_compartida'] =
    "Expediente · Información interna compartida";
$lang['perm_section_ejecutivo']   = "Ejecutivo";
$lang['perm_section_nomina']      = "Nómina";
$lang['perm_section_operativo']   = "Operativo";
$lang['perm_section_organigrama'] = "Organigrama";
$lang['perm_section_dashboards']  = "Dashboards";
// --------------------------------------
// SECCIONES
// --------------------------------------
// ====== SECCIONES (TÍTULOS) ======
$lang['perm_section_sucursales']        = "Sucursales";
$lang['perm_section_usuarios_internos'] = "Usuarios internos";

$lang['perm_section_calendario'] = "Calendario";
$lang['perm_section_mensajeria'] = "Mensajería";

$lang['perm_section_nomina_historial'] = "Nómina · Historial";
$lang['perm_section_nomina_periodos']  = "Nómina · Períodos";
$lang['perm_section_nomina_prenomina'] = "Nómina · Prenómina";

$lang['perm_section_recordatorios'] = "Recordatorios";

$lang['perm_section_examenes']        = "Exámenes";
$lang['perm_section_general']         = "General";
$lang['perm_section_medios_contacto'] = "Medios de contacto";

$lang['perm_section_pre_empleo']    = "Pre-empleo";
$lang['perm_section_reclutamiento'] = "Reclutamiento";

$lang['perm_section_cursos']       = "Cursos";
$lang['perm_section_evaluaciones'] = "Evaluaciones";

$lang['perm_section_expediente_bgv_examenes'] = "Expediente · BGV Exámenes";
$lang['perm_section_expediente_documentos']   = "Expediente · Documentos";
$lang['perm_section_expediente_foto']         = "Expediente · Foto";
$lang['perm_section_expediente_generales']    = "Expediente · Generales";
$lang['perm_section_expediente_laborales']    = "Expediente · Laborales";
$lang['perm_section_expediente_medica']       = "Expediente · Médica";

$lang['perm_section_conclusiones']                 = "Conclusiones";
$lang['perm_section_expediente']                   = "Expediente";
$lang['perm_section_expediente_documentos_salida'] = "Expediente · Documentos de salida";

$lang['perm_section_notificaciones'] = "Notificaciones";
$lang['perm_section_logo']           = "Logo";
$lang['perm_section_pagos']          = "Pagos";
$lang['perm_section_privacidad_tc']  = "Privacidad y Términos";
$lang['perm_section_tc']             = "Términos y Condiciones";

$lang['perm_section_candidatos'] = "Candidatos";
$lang['perm_section_documentos'] = "Documentos";
$lang['perm_section_procesos']   = "Procesos";

$lang['perm_section_aspirantes']    = "Aspirantes";
$lang['perm_section_bolsa_trabajo'] = "Bolsa de trabajo";
$lang['perm_section_finalizadas']   = "Requisiciones finalizadas";

$lang['perm_section_reqs']      = "Requisiciones";
$lang['perm_section_empleados'] = "Empleados";

$lang['perm_section_sucursales_excel']               = "Sucursales · Reporte Excel";
$lang['perm_section_expediente_informacion_interna'] =    "Expediente · Información interna";
$lang['perm_section_exempleados'] = "Exempleados";
$lang['perm_section_rotacion'] = "Rotación";

$lang['perm_empleados.expediente.foto.actualizar']              = "Actualizar foto de perfil del empleado";


// ----- EXEMPLEADOS → MENU -----
$lang['perm_exempleados.__menu.ver'] = "Ver módulo de Exempleados en el menú";

// ----- EXEMPLEADOS → EXPEDIENTE (HEADER / BOTÓN) -----
$lang['perm_exempleados.expediente.__header.ver']         = "Ver header del expediente";
$lang['perm_exempleados.expediente.boton_expediente.ver'] = "Ver botón 'Expediente' en el listado de Exempleados";
// ===== EMPLEADOS → EXPEDIENTE.GENERALES =====

$lang['perm_empleados.expediente.generales.enviar_exempleados']
= "Mover empleado al módulo de Exempleados";

$lang['perm_empleados.expediente.generales.ver_detalles']
= "Ver detalles del expediente del empleado";

// ===== EXEMPLEADOS → MENU =====


$lang['perm_exempleados.expediente.foto.actualizar'] = "Actualizar foto de perfil en el expediente";

// --- Accesos generales ---
$lang['perm_comunicacion.calendario']       = "Acceso general al calendario";
$lang['perm_comunicacion.mensajeria']       = "Acceso general a mensajería";
$lang['perm_comunicacion.mensajeria.ver']   = "Ver módulo de mensajería";
$lang['perm_comunicacion.nomina.historial'] = "Acceso general al historial de nómina";
$lang['perm_comunicacion.nomina.periodos']  = "Acceso general a periodos de nómina";
$lang['perm_comunicacion.nomina.prenomina'] = "Acceso general a prenómina";
$lang['perm_comunicacion.sucursales']       = "Acceso general a sucursales";
$lang['perm_module.comunicacion.ver']       = "Ver módulo de Comunicación Interna";

// ======================================================
// 🟦 SECCIÓN: COMUNICACIÓN 360
// ======================================================

// --- Accesos ---
$lang['perm_comunicacion360.accesos.actualizar']    = "Actualizar accesos y credenciales de colaboradores";
$lang['perm_comunicacion360.accesos.cerrar_sesion'] = "Cerrar sesiones activas de colaboradores";
$lang['perm_comunicacion360.accesos.eliminar']      = "Eliminar acceso de un colaborador";
$lang['perm_comunicacion360.accesos.generar']       = "Generar accesos de colaboradores";
$lang['perm_comunicacion360.accesos.ver']           = "Ver accesos de colaboradores";

// --- Accesos · Checadas ---
$lang['perm_comunicacion360.accesos.checadas.gestionar'] = "Registrar, editar o cerrar checadas administrativamente";
$lang['perm_comunicacion360.accesos.checadas.ver']       = "Consultar checadas y métricas del colaborador";

// --- Accesos · Eventos ---
$lang['perm_comunicacion360.accesos.eventos.registrar_horas_extra'] = "Registrar eventos de horas extra";
$lang['perm_comunicacion360.accesos.eventos.ver']                   = "Consultar eventos e incidencias del colaborador";

// --- Accesos · Direcciones IP ---
$lang['perm_comunicacion360.accesos.ips.crear']    = "Registrar una dirección IP autorizada";
$lang['perm_comunicacion360.accesos.ips.editar']   = "Editar una dirección IP autorizada";
$lang['perm_comunicacion360.accesos.ips.eliminar'] = "Eliminar una dirección IP autorizada";
$lang['perm_comunicacion360.accesos.ips.ver']      = "Ver direcciones IP autorizadas del colaborador";

// --- Accesos · Perfil ---
$lang['perm_comunicacion360.accesos.perfil.ver'] = "Ver perfil y análisis operativo del colaborador";

// --- Accesos · Reportes ---
$lang['perm_comunicacion360.accesos.reportes.ver'] = "Consultar y descargar reportes de asistencia";

// --- Accesos · Tareas ---
$lang['perm_comunicacion360.accesos.tareas.comentar']            = "Agregar comentarios administrativos a tareas";
$lang['perm_comunicacion360.accesos.tareas.eliminar_comentario'] = "Eliminar comentarios administrativos de tareas";
$lang['perm_comunicacion360.accesos.tareas.reabrir']             = "Reabrir tareas de colaboradores";
$lang['perm_comunicacion360.accesos.tareas.ver']                 = "Consultar tareas asignadas a colaboradores";

// --- Checador · Horarios ---
$lang['perm_comunicacion360.checador.horarios.cambiar_estado'] = "Activar o desactivar horarios del checador";
$lang['perm_comunicacion360.checador.horarios.crear']          = "Crear horarios del checador";
$lang['perm_comunicacion360.checador.horarios.editar']         = "Editar horarios del checador";
$lang['perm_comunicacion360.checador.horarios.ver']            = "Ver horarios del checador";

// --- Checador · Plantillas ---
$lang['perm_comunicacion360.checador.plantillas.asignar']        = "Asignar plantillas de checada a colaboradores";
$lang['perm_comunicacion360.checador.plantillas.cambiar_estado'] = "Activar o desactivar plantillas de checada";
$lang['perm_comunicacion360.checador.plantillas.configurar']     = "Configurar métodos, ubicaciones, horarios y aprobadores";
$lang['perm_comunicacion360.checador.plantillas.crear']          = "Crear plantillas de configuración del checador";
$lang['perm_comunicacion360.checador.plantillas.editar']         = "Editar plantillas de configuración del checador";
$lang['perm_comunicacion360.checador.plantillas.ver']            = "Ver plantillas de configuración del checador";

// --- Checador · Ubicaciones ---
$lang['perm_comunicacion360.checador.ubicaciones.crear']      = "Crear ubicaciones autorizadas del checador";
$lang['perm_comunicacion360.checador.ubicaciones.editar']     = "Editar ubicaciones autorizadas del checador";
$lang['perm_comunicacion360.checador.ubicaciones.eliminar']   = "Eliminar ubicaciones autorizadas del checador";
$lang['perm_comunicacion360.checador.ubicaciones.generar_qr'] = "Generar o regenerar el código QR de una ubicación";
$lang['perm_comunicacion360.checador.ubicaciones.ver']        = "Ver ubicaciones autorizadas del checador";
$lang['perm_comunicacion360.checador.ubicaciones.ver_qr']     = "Ver código QR fijo de una ubicación";

// --- Importaciones · Checadas ---
$lang['perm_comunicacion360.importaciones.checadas.confirmar'] = "Confirmar importación masiva de checadas";
$lang['perm_comunicacion360.importaciones.checadas.exportar']  = "Exportar plantilla para checadas masivas";
$lang['perm_comunicacion360.importaciones.checadas.validar']   = "Validar archivo de importación masiva de checadas";

// --- Importaciones · Incidencias ---
$lang['perm_comunicacion360.importaciones.incidencias.confirmar'] = "Confirmar importación masiva de incidencias";
$lang['perm_comunicacion360.importaciones.incidencias.exportar']  = "Exportar plantilla para incidencias masivas";
$lang['perm_comunicacion360.importaciones.incidencias.validar']   = "Validar archivo de importación masiva de incidencias";

// --- Incidencias ---
$lang['perm_comunicacion360.incidencias.ver']           = "Ver calendario y detalle de incidencias";
$lang['perm_comunicacion360.incidencias.ver_evidencia'] = "Ver o descargar evidencias de incidencias";

// --- Plantillas de tareas ---
$lang['perm_comunicacion360.plantillas.asignar']    = "Asignar plantillas de tareas a colaboradores";
$lang['perm_comunicacion360.plantillas.crear']      = "Crear plantillas de tareas";
$lang['perm_comunicacion360.plantillas.desasignar'] = "Desasignar plantillas de tareas de colaboradores";
$lang['perm_comunicacion360.plantillas.editar']     = "Editar plantillas de tareas";
$lang['perm_comunicacion360.plantillas.eliminar']   = "Eliminar plantillas de tareas";
$lang['perm_comunicacion360.plantillas.ver']        = "Ver plantillas de tareas";

// --- Catálogo de tareas ---
$lang['perm_comunicacion360.tareas.crear']    = "Crear tareas en el catálogo";
$lang['perm_comunicacion360.tareas.editar']   = "Editar tareas del catálogo";
$lang['perm_comunicacion360.tareas.eliminar'] = "Eliminar tareas del catálogo";
$lang['perm_comunicacion360.tareas.ver']      = "Ver catálogo de tareas";

// --- Puerta del módulo ---
$lang['perm_module.comunicacion360.ver']        = "Ver módulo Comunicación 360";
$lang['perm_section___menu']                    = "Menu";
$lang['perm_section_accesos']                   = "Accesos";
$lang['perm_section_accesos_checadas']          = "Accesos · Checadas";
$lang['perm_section_accesos_eventos']           = "Accesos · Eventos";
$lang['perm_section_accesos_ips']               = "Accesos · Direcciones IP";
$lang['perm_section_accesos_perfil']            = "Accesos · Perfil";
$lang['perm_section_accesos_reportes']          = "Accesos · Reportes";
$lang['perm_section_accesos_tareas']            = "Accesos · Tareas";
$lang['perm_section_checador_horarios']         = "Checador · Horarios";
$lang['perm_section_checador_plantillas']       = "Checador · Plantillas";
$lang['perm_section_checador_ubicaciones']      = "Checador · Ubicaciones";
$lang['perm_section_importaciones_checadas']    = "Importaciones · Checadas";
$lang['perm_section_importaciones_incidencias'] = "Importaciones · Incidencias";
$lang['perm_section_incidencias']               = "Incidencias";
$lang['perm_section_plantillas']                = "Plantillas de tareas";
$lang['perm_section_tareas']                    = "Catálogo de tareas";
$lang['perm_section_comunicacion360']           = "Comunicación 360";
