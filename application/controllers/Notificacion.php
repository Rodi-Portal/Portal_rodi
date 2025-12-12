<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notificacion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct(); // ← siempre primero (así $this->uri existe también en CLI)

        // Si se ejecuta desde CLI (cron), silenciamos y no validamos sesión
        if (function_exists('is_cli') && is_cli()) {
            error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
            ini_set('display_errors', 0);
            // nada de validar login ni cargar usuario_sesion en CLI
            return;
        }

        // Flujo WEB normal
        if (! $this->session->userdata('id')) {
            redirect('Login/index');
        }
        $this->load->library('usuario_sesion');
        $this->usuario_sesion->checkStatusBD();
    }

/*Notificaciones    via  Whatsapp  o correo*/
/*
    public function obtener_estado_empleado($id_portal, $id_cliente)
    {

        $api_url = API_URL;
        // URL del endpoint
        $url = $api_url . 'empleados/status?id_portal=' . $id_portal . '&id_cliente=' . $id_cliente;

        // Inicializar cURL
        $ch = curl_init();

        // Configuración de la solicitud
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);

        // Verificar si hubo un error
        if (curl_errno($ch)) {
            echo 'Error al obtener estado del empleado: ' . curl_error($ch);
            return null;
        }

        // Cerrar la conexión cURL
        curl_close($ch);

                                             // Decodificar la respuesta JSON
        return json_decode($response, true); // Devuelve un array con los estados de los documentos, cursos y evaluaciones
    }*/
    public function obtener_estado_empleado($id_portal, $id_cliente, $status = null)
    {
        $api_url = rtrim(API_URL, '/'); // por si trae '/'
        $params  = array_filter([
            'id_portal'  => $id_portal,
            'id_cliente' => $id_cliente,
            'status'     => $status, // null => no se incluye
        ], static function ($v) {return $v !== null && $v !== '';});

        $url = $api_url . '/empleados/status?' . http_build_query($params);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 20,
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            // Mejor log que echo en cron
            log_message('error', 'Error cURL obtener_estado_empleado: ' . curl_error($ch));
            curl_close($ch);
            return null;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode < 200 || $httpCode >= 300) {
            log_message('error', "HTTP {$httpCode} en obtener_estado_empleado: {$url}");
            return null;
        }

        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'JSON inválido en obtener_estado_empleado: ' . json_last_error_msg());
            return null;
        }

        return $data; // ['statusDocuments'=>..., 'statusCursos'=>..., 'statusEvaluaciones'=>...]
    }
    public function enviar_notificaciones_cron_job()
    {
        // --- Validación del token ---
        /* $token = $this->uri->segment(3) ?: $this->input->get('token', true);
        if ($token !== 'jlF4ELpLyE35dZ9Tq3SqdcMxPrEL1Zrf5fr7ChRJzcvAezEdFj6YGG5EVFPqVcqO') {
            show_404();
            return;
        }*/

        // --- Determinar el horario actual ---
        $tz              = new DateTimeZone('America/Mexico_City');
        $slotActual      = (new DateTime('now', $tz))->format('h:i A'); // Ej: "09:00 AM"
        $horariosValidos = ['09:00 AM', '03:00 PM', '07:00 PM'];

        if (! in_array($slotActual, $horariosValidos, true)) {
            log_message('info', "[CRON] Llamado fuera de horario válido: {$slotActual}");
            return;
        }

        // --- Cargar modelo y obtener notificaciones ---
        $this->load->model('Notificacion_model');
        $registros = $this->Notificacion_model->get_notificaciones_por_slot($slotActual);

        if (empty($registros)) {
            log_message('info', "[CRON] No hay registros para procesar en {$slotActual}");
            return;
        }

        // --- Procesar registros ---
        foreach ($registros as $registro) {
            $estado = $this->obtener_estado_empleado($registro->id_portal, $registro->id_cliente);
            if (! $estado) {
                log_message('error', "[CRON] No se pudo obtener estado para ID: {$registro->id}");
                continue;
            }

            // Verificar módulos en rojo
            $modulos = [];
            if ((int) $registro->cursos === 1 && ($estado['statusCursos'] ?? '') === 'rojo') {
                $modulos[] = "<li>Cursos</li>";
            }
            if ((int) $registro->evaluaciones === 1 && ($estado['statusEvaluaciones'] ?? '') === 'rojo') {
                $modulos[] = "<li>Evaluaciones</li>";
            }
            if ((int) $registro->expediente === 1 && ($estado['statusDocuments'] ?? '') === 'rojo') {
                $modulos[] = "<li>Expediente</li>";
            }

            if (empty($modulos)) {
                continue; // nada que notificar
            }

            // --- Enviar correo ---
            if ((int) $registro->correo === 1) {
                $correos = array_values(array_unique(array_filter([$registro->correo1 ?? null, $registro->correo2 ?? null])));
                if (! empty($correos)) {
                    $this->enviar_correo($correos, 'Notificación TalentSafe Control', $modulos, $registro->nombre);
                    log_message('info', "[CRON] Correo enviado a ID {$registro->id}: " . implode(', ', $correos));
                }
            }

            // --- Enviar WhatsApp ---
            if ((int) $registro->whatsapp === 1) {
                $telefonos = array_filter([
                    ! empty($registro->telefono1) ? ($registro->ladaSeleccionada . $registro->telefono1) : null,
                    ! empty($registro->telefono2) ? ($registro->ladaSeleccionada2 . $registro->telefono2) : null,
                ]);

                if (! empty($telefonos)) {
                    $submodulos = implode(", ", array_map(static fn($li) => strip_tags($li), $modulos));
                    $this->enviar_whatsapp($telefonos, $registro->nombrePortal, $registro->nombre, $submodulos, 'notificacion_empleados');
                    log_message('info', "[CRON] WhatsApp enviado a ID {$registro->id}: " . implode(', ', $telefonos));
                }
            }
        }

        log_message('info', "[CRON] Finalizado envío de notificaciones para slot {$slotActual}");
    }
    public function enviar_notificaciones_exempleados_cron_job()
    {
        // --- Token de seguridad ---
        /*  $token = $this->uri->segment(3) ?: $this->input->get('token', true);
        if ($token !== 'jlF4ELpLyE35dZ9Tq3SqdcMxPrEL1Zrf5fr7ChRJzcvAezEdFj6YGG5EVFPqVcqO') {
            show_404();
            return;
        }*/

        log_message('info', '[CRON EX] Iniciando notificaciones de ex-empleados...');

        // --- Determinar el horario actual (con ventana de gracia ±15 min) ---
        $tz              = new DateTimeZone('America/Mexico_City');
        $ahora           = new DateTime('now', $tz);
        $horariosValidos = ['09:00 AM', '03:00 PM', '07:00 PM'];
        $graciaMinutos   = 999;
        $slotActual      = null;

        foreach ($horariosValidos as $h) {
            $horaSlot = DateTime::createFromFormat('h:i A', $h, $tz);
            if (! $horaSlot) {
                continue;
            }

            $diff = abs($ahora->getTimestamp() - $horaSlot->getTimestamp()) / 60; // diferencia en minutos

            if ($diff <= $graciaMinutos) {
                $slotActual = $h;
                break;
            }
        }

        // Si está fuera de los horarios válidos, no ejecutar
        if ($slotActual === null) {
            log_message('info', "[CRON EX] Fuera de ventana de gracia (" . $ahora->format('h:i A') . ")");
            return;
        }

        log_message('info', "[CRON EX] Ejecutando slot {$slotActual}");

        // --- Cargar modelo y obtener notificaciones de ex empleados (status=2) ---
        $this->load->model('Notificacion_model');
        $registros = $this->Notificacion_model->get_notificaciones_exempleados_por_slot($slotActual);

        if (empty($registros)) {
            log_message('info', "[CRON EX] No hay registros para procesar en {$slotActual}");
            return;
        }

        // --- Procesar registros ---
        foreach ($registros as $registro) {
            log_message('info', "[CRON EX] Procesando ID={$registro->id} (portal={$registro->id_portal}, cliente={$registro->id_cliente})");

            // 1) Obtener estado del ex empleado (status=2)
            $estado = $this->obtener_estado_empleado($registro->id_portal, $registro->id_cliente, 2);

            if (! $estado) {
                log_message('error', "[CRON EX] No se pudo obtener estado para ID={$registro->id}");
                continue;
            }

            // 2) Enviar solo si documentos están en rojo
            if (strcasecmp($estado['statusDocuments'] ?? '', 'rojo') !== 0) {
                log_message('info', "[CRON EX] Sin documentos en rojo para ID={$registro->id}");
                continue;
            }

            // 3) Módulo relevante: Documentos
            $modulos = ["<li>Documentos</li>"];

            // 4) Enviar correo si está habilitado
            if ((int) $registro->correo === 1) {
                $correos = array_values(array_unique(array_filter([$registro->correo1 ?? null, $registro->correo2 ?? null])));
                if (! empty($correos)) {
                    try {
                        $this->enviar_correo(
                            $correos,
                            'Notificación TalentSafe Control - Ex Empleados',
                            $modulos,
                            $registro->nombre ?? "Ex Empleado"
                        );
                        log_message('info', "[CRON EX] Correo enviado a ID={$registro->id}: " . implode(', ', $correos));
                    } catch (Exception $e) {
                        log_message('error', "[CRON EX] Error al enviar correo a ID={$registro->id}: " . $e->getMessage());
                    }
                }
            }

            // 5) Enviar WhatsApp si está habilitado
            if ((int) $registro->whatsapp === 1) {
                $telefonos = array_filter([
                    ! empty($registro->telefono1) ? ($registro->ladaSeleccionada . $registro->telefono1) : null,
                    ! empty($registro->telefono2) ? ($registro->ladaSeleccionada2 . $registro->telefono2) : null,
                ]);

                if (! empty($telefonos)) {
                    try {
                        $this->enviar_whatsapp_ex(
                            $telefonos,
                            $registro->nombrePortal ?? 'Portal',
                            $registro->nombre ?? 'Sucursal',
                            'Exempleados',
                            'notificacion_exempleados'
                        );
                        echo "[CRON EX] WhatsApp enviado a ID={$registro->id}: " . implode(', ', $telefonos);
                    } catch (Exception $e) {
                        echo "[CRON EX] Error al enviar WhatsApp a ID={$registro->id}: " . $e->getMessage();
                    }
                }
            }
        }

        log_message('info', "[CRON EX] Finalizado envío de notificaciones de ex empleados para {$slotActual}");
    }

    public function enviar_notificaciones_cron_job2()
    {
        $tz    = new DateTimeZone('America/Mexico_City');
        $ahora = new DateTime('now', $tz);

        $horariosValidos = ['09:00 AM', '03:00 PM', '07:00 PM'];
        $graciaMinutos   = 999;
        $slotActual      = null;

        foreach ($horariosValidos as $h) {
            $horaSlot = DateTime::createFromFormat('h:i A', $h, $tz);
            if (! $horaSlot) {
                continue;
            }

            $diff = abs($ahora->getTimestamp() - $horaSlot->getTimestamp()) / 60;
            if ($diff <= $graciaMinutos) {
                $slotActual = $h;
                break;
            }
        }

        if ($slotActual === null) {
            return;
        }

        $this->load->model('Notificacion_model');
        $registros = $this->Notificacion_model->get_notificaciones_por_slot($slotActual);

        if (empty($registros)) {
            return;
        }

        foreach ($registros as $registro) {
            $estado = $this->obtener_estado_empleado($registro->id_portal, $registro->id_cliente);
            if (! $estado) {
                continue;
            }

            $modulos = [];
            if ((int) $registro->cursos === 1 && ($estado['statusCursos'] ?? '') === 'rojo') {
                $modulos[] = "Cursos";
            }
            if ((int) $registro->evaluaciones === 1 && ($estado['statusEvaluaciones'] ?? '') === 'rojo') {
                $modulos[] = "Evaluaciones";
            }
            if ((int) $registro->expediente === 1 && ($estado['statusDocuments'] ?? '') === 'rojo') {
                $modulos[] = "Expediente";
            }

            if (empty($modulos)) {
                continue;
            }

            // --- Envío por correo ---
            if ((int) $registro->correo === 1) {
                $correos = array_values(array_unique(array_filter([$registro->correo1 ?? null, $registro->correo2 ?? null])));
                if (! empty($correos)) {
                    try {
                        $this->enviar_correo($correos, 'Notificación TalentSafe Control', $modulos, $registro->nombre);
                    } catch (Exception $e) {
                        // Se puede registrar en log_message('error', ...) si deseas
                    }
                }
            }

            // --- Envío por WhatsApp ---
            if ((int) $registro->whatsapp === 1) {
                $telefonos = array_filter([
                    ! empty($registro->telefono1) ? ($registro->ladaSeleccionada . $registro->telefono1) : null,
                    ! empty($registro->telefono2) ? ($registro->ladaSeleccionada2 . $registro->telefono2) : null,
                ]);

                if (! empty($telefonos)) {
                    try {
                        $submodulos = implode(", ", $modulos);
                        $this->enviar_whatsapp(
                            $telefonos,
                            $registro->nombrePortal ?? 'Portal',
                            $registro->nombre ?? 'Sucursal',
                            $submodulos,
                            'notificacion_empleados'
                        );
                    } catch (Exception $e) {
                        // log_message('error', $e->getMessage());
                    }
                }
            }
        }
    }

    public function enviar_correo($destinatarios, $asunto, $modulos, $nombrecliente)
    {
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        try {
                                                              // Configuración del servidor SMTP
            $mail->isSMTP();                                  // Establecer el envío usando SMTP
            $mail->Host       = 'mail.talentsafecontrol.com'; // Servidor SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'soporte@talentsafecontrol.com';
            $mail->Password   = 'FQ{[db{}%ja-';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465; // Puerto SMTP

            // Remitente
            $mail->setFrom('soporte@talentsafecontrol.com', 'TalentSafe Control');

            // Destinatarios
            foreach ($destinatarios as $correo) {
                $mail->addAddress($correo); // Agrega el destinatario
            }

            // Asunto
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Notificación TalentSafe Control';

            // Cuerpo del mensaje con los módulos
            $mensaje = "
          <h3>Excelente día,</h3>
          <p>Te recordamos que tienes algunos  archivos por  vencer en tu sucursal: " . $nombrecliente . " en los siguientes módulos:</p>
          <ul>";

            // Agregar los módulos seleccionados al mensaje

            // Agregar los módulos seleccionados al mensaje
            if (! empty($modulos)) {
                $mensaje .= implode('', $modulos); // Convertir el arreglo de módulos en una lista HTML
            }

            $mensaje .= "</ul>
          <p>Por favor ingresa a <a href='https://portal.talentsafecontrol.com' target='_blank'>TalentSafeControl</a> y realiza las actualizaciones pertinentes.</p>
          <p>Saludos cordiales,<br>El equipo de TalentSafeControl</p>";

            $mail->Body = $mensaje; // Asignar el cuerpo del mensaje

            // Enviar el correo
            $mail->send();
            echo "<script>console.log('Correo enviado a: {$correo}');</script>";
        } catch (Exception $e) {
            echo "<script>console.log('No se pudo enviar el correo. Error: {$mail->ErrorInfo}');</script>";
        }
    }

    public function enviar_recordatorios_cron_job_run()
    {
        $tz    = new DateTimeZone('America/Mexico_City');
        $ahora = new DateTime('now', $tz);
        $hoy   = (new DateTime('today', $tz))->format('Y-m-d');

        // Horarios oficiales del sistema (estandarizados)
        $horariosBase = [
            '09:00 AM',
            '03:00 PM',
            '07:00 PM',
        ];

        $ventana    = 30; // minutos de tolerancia (puedes poner 30)
        $slotActual = null;

        foreach ($horariosBase as $h) {

            // Normalizar: quitar espacios y poner mayúsculas
            $norm = strtoupper(str_replace(' ', '', $h));

            // Parseo flexible: g:iA, H:iA, gA
            $slot = DateTime::createFromFormat('g:iA', $norm, $tz)
                ?: DateTime::createFromFormat('H:iA', $norm, $tz)
                ?: DateTime::createFromFormat('gA', $norm, $tz);

            if (! $slot) {
                continue;
            }

            // Le ponemos la fecha actual
            $slot->setDate(
                (int) $ahora->format('Y'),
                (int) $ahora->format('m'),
                (int) $ahora->format('d')
            );

            // Diferencia en minutos entre ahora y el slot
            $dif = abs($ahora->getTimestamp() - $slot->getTimestamp()) / 60;

            if ($dif <= $ventana) {
                $slotActual = $h; // ← LO QUE SE ENVÍA AL MODELO
                break;
            }
        }

        // Si no estamos dentro de la ventana del horario, cancelar
        if ($slotActual === null) {
            return;
        }

        // Carga modelo
        $this->load->model('Notificacion_model');

        // Obtiene recordatorios filtrando por slot + anticipación
        $registros = $this->Notificacion_model
            ->get_recordatorios_para_slot_window($slotActual, $hoy, false);

        if (empty($registros)) {
            return;
        }

        foreach ($registros as $r) {

            // ====================================
            //            ENVÍO POR CORREO
            // ====================================
            if ((int) $r->correo_cfg === 1) {
                $correos = array_values(array_unique(array_filter([
                    $r->correo1_cfg ?: null,
                    $r->correo2_cfg ?: null,
                ], static function ($v) {
                    return ! empty($v) && filter_var($v, FILTER_VALIDATE_EMAIL);
                })));

                if (! empty($correos)) {
                    try {
                        $this->enviar_correo(
                            $correos,
                            "Recordatorio {$r->nombre}",
                            ["<li>{$r->nombre} - vence {$r->proxima_fecha}</li>"],
                            $r->nombre ?? 'Recordatorio'
                        );
                    } catch (Exception $e) {}
                }
            }

            // ====================================
            //       ENVÍO POR WHATSAPP (WABA)
            // ====================================
            if ((int) $r->whatsapp_cfg === 1) {

                $tels = array_values(array_unique(array_filter([
                    (! empty($r->telefono1_cfg) && ! empty($r->lada1_cfg))
                        ? ($r->lada1_cfg . $r->telefono1_cfg) : null,
                    (! empty($r->telefono2_cfg) && ! empty($r->lada2_cfg))
                        ? ($r->lada2_cfg . $r->telefono2_cfg) : null,
                ], static function ($v) {
                    if ($v === null) {
                        return false;
                    }

                    return strlen(preg_replace('/\D+/', '', $v)) >= 10;
                })));

                if (! empty($tels)) {
                    try {
                        $portal     = $r->portal ?? 'TalentSafe';
                        $cliente    = $r->cliente ?? 'Sucursal';
                        $asunto     = $r->nombre;
                        $detalle    = $r->descripcion ?? 'Sin detalle';
                        $venceFecha = (new DateTime($r->proxima_fecha, $tz))->format('d/m/Y');

                        $this->enviar_whatsapp_recordatorio(
                            $tels,
                            $portal,
                            $cliente,
                            $asunto,
                            $detalle,
                            $venceFecha,
                            'notificacion_recordatorios'
                        );
                    } catch (Exception $e) {}
                }
            }

            // ====================================
            //          REPROGRAMAR FECHA
            // ====================================
            if ($hoy === $r->proxima_fecha) {
                $nueva = $this->calcularProximaFecha($r, $tz);
                if ($nueva !== null) {
                    $this->Notificacion_model
                        ->actualizar_proxima_fecha($r->id, $nueva);
                }
            }
        }
    }

/**
 * Enviar WhatsApp para RECORDATORIOS al endpoint Laravel /send-notification-recordatorio
 * Requiere plantilla con 5 parámetros: portal, cliente, recordatorio, mensaje, fecha.
 */

    private function enviar_whatsapp_recordatorio($telefonos, $portal, $cliente, $recordatorio, $mensaje, $fecha, $template = 'notificacion_recordatorio')
    {
        $base = rtrim(API_URL, '/'); // define(API_URL, 'http://localhost:8000/api'); por ejemplo
        $url  = $base . '/send-notification-recordatorio';

        if (! is_array($telefonos)) {
            $telefonos = [$telefonos];
        }

        // Normaliza y filtra teléfonos válidos
        $telefonos = array_values(array_filter(array_map(function ($t) {
            if (! is_string($t) || $t === '') {
                return null;
            }

            $digits = preg_replace('/\D+/', '', $t);
            return (strlen($digits) >= 10) ? $t : null;
        }, $telefonos)));

        if (empty($telefonos)) {
            log_message('error', '[WA-REC] No hay teléfonos válidos.');
            return;
        }

        foreach ($telefonos as $phone) {
            $payload = [
                'phone'        => $phone,
                'template'     => $template,
                'portal'       => (string) $portal,
                'cliente'      => (string) $cliente,
                'recordatorio' => (string) $recordatorio,
                'mensaje'      => (string) $mensaje,
                'fecha'        => (string) $fecha,
            ];

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLOPT_POST           => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER     => [
                    'Content-Type: application/json',
                    'Accept: application/json',
                ],
                CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT        => 25,
            ]);

            $response = curl_exec($ch);
            if ($response === false) {
                log_message('error', '[WA-REC] cURL error (' . $phone . '): ' . curl_error($ch));
                curl_close($ch);
                continue;
            }

            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $json = json_decode($response, true);
            if ($code >= 200 && $code < 300 && isset($json['status']) && $json['status'] === 'success') {
                log_message('info', '[WA-REC] Enviado OK a ' . $phone);
            } else {
                $msg = $json['message'] ?? $response;
                // log_message('error', "[WA-REC] Falló envío a {$phone} (HTTP {$code}) {$msg}");
            }
        }
    }

/**
 * Avanza la próxima fecha para recordatorios recurrentes.
 * Soporta tipo = 'mensual' usando intervalo_meses (1=mensual, 2=bimestral, 3=trimestral, 6=semestral, 12=anual).
 * Para 'unico' devuelve null (no cambia).
 */
    private function calcularProximaFecha($r, DateTimeZone $tz)
    {
        // Si no es recurrente, no actualizar
        if (isset($r->tipo) && strtolower($r->tipo) === 'unico') {
            return null;
        }

        $base = null;
        if (! empty($r->proxima_fecha)) {
            $base = DateTime::createFromFormat('Y-m-d', $r->proxima_fecha, $tz);
        } elseif (! empty($r->fecha_base)) {
            $base = DateTime::createFromFormat('Y-m-d', $r->fecha_base, $tz);
        }

        if (! $base) {
            return null;
        }

        // Por defecto 1 mes si no viene intervalo_meses
        $intervalo = (int) ($r->intervalo_meses ?? 1);
        if ($intervalo <= 0) {
            $intervalo = 1;
        }

        // Avanza meses
        $base->modify("+{$intervalo} month");
        return $base->format('Y-m-d');
    }

    public function enviar_notificaciones_inmediatamente()
    {
        $this->load->model('Notificacion_model');
        $registros = $this->Notificacion_model->get_notificaciones();
        // Obtiene los registros activos

        // Si no hay registros, muestra un mensaje
        if (empty($registros)) {
            echo "<script>console.log('No hay registros para procesar en este momento.');</script>";
            return;
        }

        // Itera sobre los registros y envía notificaciones
        foreach ($registros as $registro) {

            // Obtener el estado del empleado desde la API
            $estado = $this->obtener_estado_empleado($registro->id_portal, $registro->id_cliente);
            /*print_r($estado);
            die();*/
            // Verificar que la respuesta de la API es válida
            if ($estado && $estado['statusDocuments'] === 'rojo' || $estado['statusCursos'] === 'rojo' || $estado['statusEvaluaciones'] === 'rojo') {

                $modulos = [];
                // Si el módulo está vencido, se agrega al arreglo
                if ($registro->cursos == 1 && $estado['statusCursos'] === 'rojo') {
                    $modulos[] = "<li>Cursos</li>";
                }

                if ($registro->evaluaciones == 1 && $estado['statusEvaluaciones'] === 'rojo') {
                    $modulos[] = "<li>Evaluaciones</li>";
                }

                if ($registro->expediente == 1 && $estado['statusDocuments'] === 'rojo') {
                    $modulos[] = "<li>Expedienete</li>";
                }
                // Si hay módulos vencidos, enviar notificación por correo
                if (! empty($modulos)) {

                    // Enviar correos si la opción está activada
                    if ($registro->correo == 1) {
                        // Filtra los correos vacíos y elimina duplicados, solo si ambos existen
                        $correos = array_unique(array_filter([$registro->correo1, $registro->correo2]));

                        // Llamada a la función para enviar los correos solo si el arreglo no está vacío
                        if (! empty($correos)) {
                            $this->enviar_correo($correos, 'Notificación TalentSafe Control', $modulos, $registro->nombre);
                        }
                    }

                    // Enviar WhatsApp si la opción está activada
                    if ($registro->whatsapp == 1) {
                        $telefonos = array_filter([
                            ! empty($registro->telefono1) ? $registro->ladaSeleccionada . $registro->telefono1 : null,
                            ! empty($registro->telefono2) ? $registro->ladaSeleccionada2 . $registro->telefono2 : null,
                        ]);

                        // Define los submódulos como texto para el mensaje
                        $submodulos = implode(", ", array_map(function ($modulo) {
                            return strip_tags($modulo); // Remueve etiquetas HTML
                        }, $modulos));

                        // Enviar WhatsApp a los teléfonos válidos
                        if (! empty($telefonos)) {
                            $this->enviar_whatsapp($telefonos, $registro->nombrePortal, $registro->nombre, $submodulos, 'notificacion_empleados');
                        }

                        // Depuración en el navegador
                        echo "<script>console.log('Enviando WhatsApp para ID: {$registro->id}', " . json_encode($telefonos) . ");</script>";
                    }
                }
            }

            // Mostrar los módulos seleccionados para depuración
            echo "<script>console.log('Módulos seleccionados para ID: {$registro->id}', " . json_encode($modulos) . ");</script>";
        }
    }
    /*
    public function enviar_notificaciones_cron_job()
    {
        $token = $this->uri->segment(3) ?: $this->input->get('token', true);

        if ($token !== 'jlF4ELpLyE35dZ9Tq3SqdcMxPrEL1Zrf5fr7ChRJzcvAezEdFj6YGG5EVFPqVcqO') {
            show_404(); // o mostrar acceso no autorizado
            return;
        }

        // Horarios específicos para ejecución del cron job
        /* $horarios_cron = ['09:00 AM', '03:00 PM', '07:00 PM'];

        $this->load->model('Notificacion_model');
        $registros = $this->Notificacion_model->get_notificaciones();

        $tz         = new DateTimeZone('America/Mexico_City');
        $slotActual = (new DateTime('now', $tz))->format('h:i A'); // "09:00 AM" o "03:00 PM" o "07:00 PM"

        $registros = $this->Notificacion_model->get_notificaciones_por_slot($slotActual);

        // Filtra los registros por los horarios predefinidos
        $registros_filtrados = [];
        foreach ($registros as $registro) {
            $horarios = explode(', ', $registro->horarios);
            if (array_intersect($horarios_cron, $horarios)) {
                $registros_filtrados[] = $registro;
            }
        }

        if (empty($registros_filtrados)) {
            echo "<script>console.log('No hay registros para procesar en este horario del cron job.');</script>";
            return;
        }

        foreach ($registros_filtrados as $registro) {
            // Obtener estado del empleado desde la API
            $estado = $this->obtener_estado_empleado($registro->id_portal, $registro->id_cliente);

            if ($estado && ($estado['statusDocuments'] === 'rojo' || $estado['statusCursos'] === 'rojo' || $estado['statusEvaluaciones'] === 'rojo')) {

                $modulos = [];

                if ($registro->cursos == 1 && $estado['statusCursos'] === 'rojo') {
                    $modulos[] = "<li>Cursos</li>";
                }

                if ($registro->evaluaciones == 1 && $estado['statusEvaluaciones'] === 'rojo') {
                    $modulos[] = "<li>Evaluaciones</li>";
                }

                if ($registro->expediente == 1 && $estado['statusDocuments'] === 'rojo') {
                    $modulos[] = "<li>Expediente</li>";
                }

                if (! empty($modulos)) {
                    // Enviar correos
                    if ($registro->correo == 1) {
                        $correos = array_unique(array_filter([$registro->correo1, $registro->correo2]));
                        if (! empty($correos)) {
                            $this->enviar_correo($correos, 'Notificación TalentSafe Control', $modulos, $registro->nombre);
                        }
                    }

                    // Enviar WhatsApp
                    if ($registro->whatsapp == 1) {
                        $telefonos = array_filter([
                            !empty($registro->telefono1) ? $registro->ladaSeleccionada . $registro->telefono1 : null,
                            !empty($registro->telefono2) ? $registro->ladaSeleccionada2 . $registro->telefono2 : null,
                        ]);

                        $submodulos = implode(", ", array_map(function ($modulo) {
                            return strip_tags($modulo);
                        }, $modulos));

                        if (! empty($telefonos)) {
                            $this->enviar_whatsapp($telefonos, $registro->nombrePortal, $registro->nombre, $submodulos, 'notificacion_empleados');
                        }

                        echo "<script>console.log('Enviando WhatsApp para ID: {$registro->id}', " . json_encode($telefonos) . ");</script>";
                    }
                }

                echo "<script>console.log('Módulos seleccionados para ID: {$registro->id}', " . json_encode($modulos) . ");</script>";
            }
        }
    }
    */

    // Envio de  notificaciones  whastapp
    public function enviar_whatsapp($telefonos, $portal, $sucursal, $submodulos, $template)
    {
        $api_url = API_URL;
        $url     = $api_url . 'send-notification';

        // Asegurarse de que $telefonos sea un array
        if (! is_array($telefonos)) {
            $telefonos = [$telefonos]; // Convierte a array si no lo es
        }

        // Filtra valores vacíos o no válidos
        $telefonos = array_filter($telefonos, function ($telefono) {
            return ! empty($telefono) && is_string($telefono); // Acepta solo cadenas no vacías
        });

        // Verifica si hay teléfonos válidos
        if (empty($telefonos)) {
            log_message('error', 'No se proporcionaron números de teléfono válidos para enviar WhatsApp.');
            return;
        }

        foreach ($telefonos as $telefono) {

            $payload = [
                'phone'          => $telefono,
                'template'       => $template,
                'nombre_cliente' => $portal,
                'submodulo'      => $submodulos,
                'sucursales'     => $sucursal, // Cambiar si tienes el dato de sucursales
            ];

            // Inicializa cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

            // Ejecuta la solicitud
            $response = curl_exec($ch);

            // Maneja errores de cURL
            if (curl_errno($ch)) {
                log_message('error', 'Error de cURL: ' . curl_error($ch));
                curl_close($ch);
                continue;
            }

            // Cierra cURL
            curl_close($ch);

            // Decodifica la respuesta
            $result = json_decode($response, true);

            // Manejo de la respuesta
            if (isset($result['status']) && $result['status'] === 'success') {
                log_message('info', 'WhatsApp enviado correctamente a ' . $telefono);
            } else {
                $error_message = $result['message'] ?? 'Error desconocido';
                log_message('info', 'Enviando WhatsApp a: ' . implode(', ', $telefonos));
            }
        }
    }

    public function enviar_whatsapp_ex($telefonos, $portal, $sucursal, $submodulos, $template)
    {
        $api_url = API_URL;
        $url     = $api_url . 'send-notification-ex';

        // Asegurarse de que $telefonos sea un array
        if (! is_array($telefonos)) {
            $telefonos = [$telefonos]; // Convierte a array si no lo es
        }

        // Filtra valores vacíos o no válidos
        $telefonos = array_filter($telefonos, function ($telefono) {
            return ! empty($telefono) && is_string($telefono); // Acepta solo cadenas no vacías
        });

        // Verifica si hay teléfonos válidos
        if (empty($telefonos)) {
            log_message('error', 'No se proporcionaron números de teléfono válidos para enviar WhatsApp.');
            return;
        }

        foreach ($telefonos as $telefono) {

            $payload = [
                'phone'    => $telefono,
                'portal'   => $portal,
                'modulo'   => $submodulos,
                'sucursal' => $sucursal,
            ];

            // Inicializa cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

            // Ejecuta la solicitud
            $response = curl_exec($ch);

            // Maneja errores de cURL
            if (curl_errno($ch)) {
                log_message('error', 'Error de cURL: ' . curl_error($ch));
                curl_close($ch);
                continue;
            }

            // Cierra cURL
            curl_close($ch);

            // Decodifica la respuesta
            $result = json_decode($response, true);

            // Manejo de la respuesta
            if (isset($result['status']) && $result['status'] === 'success') {
                log_message('info', 'WhatsApp enviado correctamente a ' . $telefono);
            } else {
                $error_message = $result['message'] ?? 'Error desconocido';
                log_message('info', 'Enviando WhatsApp a: ' . implode(', ', $telefonos));
            }
        }
    }

    /*correos  para  notificaciones */

    // aqui termina   la funcion notificaciones  via  whatsapp   y correos
    public function alertaNuevoCandidato()
    {
        $Pusher_Opciones = [
            //"scheme" => "http",
            //"host" => "tudominio.com", //"The HOST option overrides the CLUSTER option!"
            //"port" => 80,
            //"timeout" => 30,
            //
            "encrypted" => false,
            //"cluster" => "mt1",
            //"curl_options" => array(
            //CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
            //)
        ];

        $options = [
            'cluster'   => 'mt1',
            'useTLS'    => true,
            "encrypted" => false,
        ];
        $pusher = new Pusher\Pusher(
            '1c1dc3822919195c87be',
            'aebe2c78bb647fffeb02',
            '1561704',
            $options
        );

        $Mi_Info = [
            "notificacion" => $this->input->post('mensaje'),
            "timestamp"    => time(),
        ];

        //$data['message'] = 'hello world';
        $pusher->trigger('rodicontrol-channel', 'my-event', $Mi_Info);
    }

    public function marcar_visto()
    {
        $id         = $this->input->post('id');
        $date       = date('Y-m-d H:i:s');
        $id_usuario = $this->session->userdata('id');
        $data       = [
            'visto'   => 1,
            'edicion' => date('Y-m-d H:i:s'),
        ];
        $this->notificacion_model->update($data, $id);
        $contador = $this->notificacion_model->get_by_usuario($id_usuario, [0]);
        if (! empty($contador)) {
            echo count($contador);
        } else {
            echo $contador = 0;
        }
    }
    // function get_by_usuario(){
    //   $id_usuario = $this->session->userdata('id');
    //   $notificaciones = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0,1]);
    //   if(!empty($notificaciones)){
    //     $contador = 0;
    //     foreach($notificaciones as $row){
    //       $fechaCreacion = fechaTexto($row->creacion,'espanol');
    //       if($row->visto == 0){
    //         $contador++;
    //       }
    //       $notificacionArray[] = [
    //         'id' => $row->id,
    //         'titulo' => $row->titulo,
    //         'mensaje' => $row->mensaje,
    //         'visto' => $row->visto,
    //         'fechaCreacion' => $fechaCreacion,
    //       ];
    //     }
    //     $data['notificaciones'] = $notificacionArray;
    //     $data['contadorNotificaciones'] = $contador;
    //     echo json_encode($data);
    //   }
    //   else{
    //     $data['contadorNotificaciones'] = $contador;
    //     echo json_encode($data);
    //   }
    // }

    public function get_by_usuario()
    {
        $id_usuario     = $this->session->userdata('id');
        $notificaciones = '';
        if ($this->session->userdata('tipo') == 1) {
            $notificaciones = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0, 1]);
        }
        if (! empty($notificaciones)) {
            $contador = 0;
            $html     = '';
            foreach ($notificaciones as $row) {
                $fechaCreacion          = fechaTexto($row->creacion, 'espanol');
                $colorNotificacion      = ($row->visto == 0) ? '#c7eafc' : 'transparent';
                $iconoNotificacion      = ($row->visto == 0) ? '<i class="fas fa-exclamation text-white"></i>' : '<i class="fas fa-check text-white"></i>';
                $fondoIconoNotificacion = ($row->visto == 0) ? 'bg-warning' : 'bg-primary';
                if ($row->visto == 0) {
                    $contador++;
                }
                // $notificacionArray[] = [
                //   'id' => $row->id,
                //   'titulo' => $row->titulo,
                //   'mensaje' => $row->mensaje,
                //   'visto' => $row->visto,
                //   'fechaCreacion' => $fechaCreacion,
                // ];
                $html .= '<a class="dropdown-item d-flex align-items-center notificacion" data-id="' . $row->id . '" data-visto="' . $row->visto . '" id="mensaje' . $row->id . '" style="background-color:' . $colorNotificacion . '" href="#"><div class="mr-3"><div class="icon-circle ' . $fondoIconoNotificacion . '" id="icono' . $row->id . '">' . $iconoNotificacion . '</div></div><div><div class="small text-gray-800">' . $fechaCreacion . '</div><span class="font-weight-bold"> ' . $row->mensaje . ' </span></div></a>';
            }

            $data['notificaciones']         = $html;
            $data['contadorNotificaciones'] = $contador;
            echo json_encode($data);
        } else {
            $data['contadorNotificaciones'] = null;
            echo json_encode($data);
        }
    }

}