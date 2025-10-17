<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notificacion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if ($this->input->is_cli_request()) {
            return;
        }

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

    public function enviar_notificaciones_cron_job()
    {
        // --- Validación del token ---
        $token = $this->uri->segment(3) ?: $this->input->get('token', true);
        if ($token !== 'jlF4ELpLyE35dZ9Tq3SqdcMxPrEL1Zrf5fr7ChRJzcvAezEdFj6YGG5EVFPqVcqO') {
            show_404();
            return;
        }

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
        $token = $this->uri->segment(3) ?: $this->input->get('token', true);
        if ($token !== 'jlF4ELpLyE35dZ9Tq3SqdcMxPrEL1Zrf5fr7ChRJzcvAezEdFj6YGG5EVFPqVcqO') {
            show_404();
            return;
        }

        // --- Determinar el horario actual (cron corre 09:00 / 15:00 / 19:00) ---
        $tz              = new DateTimeZone('America/Mexico_City');
        $slotActual      = (new DateTime('now', $tz))->format('h:i A'); // "09:00 AM", "03:00 PM" o "07:00 PM"
        $horariosValidos = ['09:00 AM', '03:00 PM', '07:00 PM'];
        if (! in_array($slotActual, $horariosValidos, true)) {
            log_message('info', "[CRON EX] Llamado fuera de horario válido: {$slotActual}");
            return;
        }

        // --- Cargar modelo y obtener notificaciones de EX (status=2) para el slot ---
        $this->load->model('Notificacion_model');
        $registros = $this->Notificacion_model->get_notificaciones_exempleados_por_slot($slotActual);

        if (empty($registros)) {
            log_message('info', "[CRON EX] No hay registros para procesar en {$slotActual}");
            return;
        }

        // --- Procesar registros ---
        foreach ($registros as $registro) {
            // 1) Obtener estado SOLO para ex (status=2): nos interesa statusDocuments
            $estado = $this->obtener_estado_empleado($registro->id_portal, $registro->id_cliente, 2);
            if (! $estado) {
                log_message('error', "[CRON EX] No se pudo obtener estado para ID={$registro->id} (portal={$registro->id_portal}, cliente={$registro->id_cliente})");
                continue;
            }

            // 2) Enviar SOLO si documentos están en rojo
            if (strcasecmp($estado['statusDocuments'] ?? '', 'rojo') !== 0) {
                log_message('info', "[CRON EX] Sin documentos en rojo para ID={$registro->id}");
                continue;
            }

            // 3) Único módulo relevante para ex: Documentos
            $modulos = ["<li>Documentos</li>"];

            // 4) Enviar correo (si está habilitado y hay destinatarios)
            if ((int) $registro->correo === 1) {
                $correos = array_values(array_unique(array_filter([$registro->correo1 ?? null, $registro->correo2 ?? null])));
                if (! empty($correos)) {
                    $this->enviar_correo(
                        $correos,
                        'Notificación TalentSafe Control - Ex Empleados',
                        $modulos,
                        $registro->nombre ?? "Ex Empleado"
                    );
                    log_message('info', "[CRON EX] Correo enviado a ID={$registro->id}: " . implode(', ', $correos));
                }
            }

            // 5) Enviar WhatsApp (si está habilitado y hay teléfonos)
            if ((int) $registro->whatsapp === 1) {
                $telefonos = array_filter([
                    ! empty($registro->telefono1) ? ($registro->ladaSeleccionada . $registro->telefono1) : null,
                    ! empty($registro->telefono2) ? ($registro->ladaSeleccionada2 . $registro->telefono2) : null,
                ]);

                if (! empty($telefonos)) {
                    $this->enviar_whatsapp(
                        $telefonos,
                        $registro->nombrePortal ?? 'Portal',
                        $registro->nombre ?? 'Ex Empleado',
                        'Documentos',
                        'notificacion_exempleados'
                    );
                    log_message('info', "[CRON EX] WhatsApp enviado a ID={$registro->id}: " . implode(', ', $telefonos));
                }
            }
        }

        log_message('info', "[CRON EX] Finalizado envío de notificaciones de ex-empleados para {$slotActual}");
    }

    /*Envio de  notificaciones  whastapp*/
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
    /*
 public function enviar_whatsapp($telefonos, $portal , $sucursal, $submodulos, $template)
{
    // 1) Base del API (compat con tu constante)
    $api_base = defined('API_URL') ? API_URL : null;
    if (empty($api_base) || !is_string($api_base)) {
        $msg = 'API_URL no está definida (o es vacía). Configúrala antes de usar WhatsApp.';
        log_message('error', '[WA] ' . $msg);
        if (!$this->input->is_cli_request()) {
            echo "<script>console.error('{$msg}');</script>";
        }
        return false;
    }
    $api_base = rtrim($api_base, '/');
    $url = $api_base . '/send-notification';

    // 2) Asegurar que $telefonos sea arreglo y no vacío
    if (!is_array($telefonos)) $telefonos = [$telefonos];
    $telefonos = array_values(array_filter($telefonos, function ($t) {
        return is_string($t) && trim($t) !== '';
    }));
    if (empty($telefonos)) {
        $msg = 'No se proporcionaron números de teléfono válidos para enviar WhatsApp.';
        log_message('error', '[WA] ' . $msg);
        if (!$this->input->is_cli_request()) {
            echo "<script>console.error('{$msg}');</script>";
        }
        return false;
    }

    // 3) Normaliza a E.164 básico (+52..., sin espacios/guiones)
    $telefonos = array_map(function ($t) {
        $t = preg_replace('/\s+|-/', '', $t);       // quita espacios y guiones
        if (strpos($t, '+') !== 0) {                // si no empieza con +, deja solo dígitos
            $t = preg_replace('/\D+/', '', $t);
        }
        return $t;
    }, $telefonos);

    // 4) Headers (si tu API requiere token, agrégalo aquí)
    $headers = [
        'Content-Type: application/json',
        'Accept: application/json',
        // 'Authorization: Bearer ' . config_item('whatsapp_api_key'), // <— si aplica
    ];

    $fallidos = [];
    $enviados = [];

    foreach ($telefonos as $telefono) {
        $payload = [
            'phone'           => $telefono,
            'template'        => $template,
            'nombre_cliente'  => $portal,
            'submodulo'       => $submodulos,
            'sucursales'      => $sucursal,
        ];

        // 5) cURL con timeouts y manejo de errores
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
            CURLOPT_TIMEOUT        => 20,
            CURLOPT_CONNECTTIMEOUT => 5,
            // SOLO para pruebas locales con SSL propio:
            // CURLOPT_SSL_VERIFYPEER => false,
            // CURLOPT_SSL_VERIFYHOST => 0,
        ]);

        $response = curl_exec($ch);
        $errno    = curl_errno($ch);
        $errstr   = curl_error($ch);
        $http     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($errno) {
            $motivo = "cURL({$errno}): {$errstr}";
            $fallidos[] = ['phone' => $telefono, 'motivo' => $motivo];
            log_message('error', "[WA] {$telefono} {$motivo}");
            continue;
        }

        if ($response === false || $response === '') {
            $motivo = "Respuesta vacía (HTTP {$http})";
            $fallidos[] = ['phone' => $telefono, 'motivo' => $motivo];
            log_message('error', "[WA] {$telefono} {$motivo}");
            continue;
        }

        $json = json_decode($response, true);
        if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
            $motivo = "Respuesta no JSON (HTTP {$http})";
            $fallidos[] = ['phone' => $telefono, 'motivo' => $motivo, 'resp' => $response];
            log_message('error', "[WA] {$telefono} {$motivo} -> {$response}");
            continue;
        }

        if (isset($json['status']) && $json['status'] === 'success') {
            $enviados[] = $telefono;
            log_message('info', "[WA] OK {$telefono} (HTTP {$http})");
        } else {
            $msg = $json['message'] ?? 'Error desconocido';
            $motivo = "{$msg} (HTTP {$http})";
            $fallidos[] = ['phone' => $telefono, 'motivo' => $motivo, 'resp' => $json];
            log_message('error', "[WA] FALLÓ {$telefono} {$motivo} / Resp: " . json_encode($json));
        }
    }

    // 6) SOLO imprimir en consola los que NO funcionaron (si no es CLI)
    if (!$this->input->is_cli_request()) {
        if (!empty($fallidos)) {
            $js = json_encode($fallidos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            echo "<script>console.error('WhatsApp fallidos:', {$js});</script>";
        } else {
            // Si prefieres NO imprimir nada cuando todo va bien, comenta esta línea:
            $js = json_encode($enviados, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            echo "<script>console.log('WhatsApp enviados:', {$js});</script>";
        }
    }

    return empty($fallidos);
}*/

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
