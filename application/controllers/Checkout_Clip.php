<?php
class Checkout_Clip extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    // Función para generar el pago, llamada desde AJAX
    public function generarPago()
    {
        $id_portal   = $this->session->userdata('idPortal');
        $amount      = $this->input->post('amount');        // total del cobro
        $currency    = $this->input->post('currency');      // ejemplo: MXN
        $description = $this->input->post('description');   // descripción
        $meses       = $this->input->post('mesesPorPagar'); // array con fechas tipo Y-m-d

        // Llamar a la API de PayClip para generar el enlace de pago
        $linkPago = $this->createPayclipLink($amount, 'USD', $description);

        // Verificar resultado
        if ($linkPago == 0) {
            echo json_encode([
                'status'   => 'error',
                'linkPago' => $linkPago,
            ]);
            return;
        }

        // ✅ Si llegamos aquí, el link de pago se generó con éxito
        // ✅ Ahora registramos cada mes en la base de datos como pendiente

        // IMPORTANTE: verifica que $meses venga como array. Si viene como string separada por comas, conviértelo:
        if (! is_array($meses)) {
            $meses = explode(',', $meses); // si llega como "2025-08-01,2025-09-01,2025-10-01"
        }

        // Normaliza fechas (por si acaso tienen espacios)
        $meses = array_map('trim', $meses);

        // Guarda los registros en la tabla
        $this->load->model('Avance_model');
        $this->avance_model->crearRegistrosPagoMultiple($id_portal, $meses, $amount / count($meses), $linkPago);

        // Respuesta final
        echo json_encode([
            'status'   => 'success',
            'linkPago' => $linkPago,
        ]);
    }

    // Función para llamar a la API de Payclip y generar el enlace de pago
    private function createPayclipLink($amount, $currency, $description)
    {
        // 🔹 Obtener portal
        $id_portal = $this->session->userdata('idPortal');
        if (empty($id_portal)) {
            return 'Error en la comunicación con Payclip';
        }

        // 🔹 Endpoint de Payclip
        $url = 'https://api.payclip.com/v2/checkout';

        // 🔹 Construir el cuerpo de la solicitud
        $body = json_encode([
            'amount'               => (float) $amount,
            'currency'             => $currency,
            'purchase_description' => $description,
            'payment_method_types' => [
                "debit",
                "credit",
                "cash",
                "bank_transfer",
            ],
            'redirection_url'      => [
                'success' => REDIRECT_SUCCESS,
                'error'   => REDIRECT_ERROR,
                'default' => REDIRECT_DEFAULT,
            ],
        ]);

        // 🔹 Encabezados
        $headers = [
            "Authorization: " . KEY_CLIP,
            'Accept: application/json',
            'Content-Type: application/json',
        ];

   
        // 🔹 Llamada a la API
        $response = $this->makeCurlRequest($url, $body, $headers);

        // 🔹 Verificar si hubo respuesta
        if (! $response) {
            return 'Error en la comunicación con Payclip';
        }

      

        // 🔹 Verificar que la respuesta contenga la URL de pago
        if (! isset($response['payment_request_url'])) {
        
            return 'Error: respuesta inválida de Payclip';
        }

        // 🔹 Construir arreglo para guardar en BD
        $linkPago = [
            'payment_request_id'  => $response['payment_request_id'] ?? '',
            'object_type'         => $response['object_type'] ?? '',
            'status'              => $response['status'] ?? '',
            'last_status_message' => $response['last_status_message'] ?? '',
            'created_at'          => $response['created_at'] ?? date('Y-m-d H:i:s'),
            'payment_request_url' => $response['payment_request_url'] ?? '',
            'qr_image_url'        => $response['qr_image_url'] ?? '',
            'api_version'         => $response['api_version'] ?? '',
            'expires_at'          => $response['expires_at'] ?? '',
            'modified_at'         => $response['modified_at'] ?? null,
            'id_portal'           => $id_portal,
        ];

       

        // 🔹 Insertar en base de datos
        $resultado = $this->area_model->insertarLinkPago($linkPago);

        if ($resultado) {
             $this->db->where('id_portal', $id_portal);
             $this->db->where('id <>', $resultado); // asumimos que la tabla link_pago tiene PK id
             $this->db->delete('link_pago');
            return $response['payment_request_id'];
        } else {
            return 0;
        }
    }

    // Función para realizar la solicitud cURL
    private function makeCurlRequest($url, $body, $headers)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Ver detalle de la solicitud
        $response = curl_exec($ch);

        // Registrar errores de cURL, si los hay
        if (curl_errno($ch)) {
            log_message('error', 'Error cURL: ' . curl_error($ch));
            return false;
        }
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Registrar errores HTTP si ocurren
        if ($http_code >= 400) {
            log_message('error', 'HTTP error code: ' . $http_code . ' - Response: ' . $response);
            return json_decode($response, true);
        }

        curl_close($ch);
        log_message('info', 'Respuesta cURL: ' . $response);

        return json_decode($response, true);
    }

    public function verificarEstadoPago()
    {
        $payment_request_id = $this->input->post('payment_request_id'); // Obtener el ID del pago

        // La URL de la API de Clip para obtener el estado del pago
        $url = "https://api.payclip.com/v2/checkout/" . $payment_request_id;

        // Iniciar cURL
        $curl = curl_init();

        // Configurar cURL con las opciones necesarias
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url, // URL dinámica con el payment_request_id
            CURLOPT_RETURNTRANSFER => true, // Recibir la respuesta como string
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "GET", // Método GET
            CURLOPT_HTTPHEADER     => [
                "accept: application/json", // Indicamos que esperamos respuesta en JSON
                "Authorization: " . KEY_CLIP,
                // Agrega tu token de acceso aquí
            ],
        ]);

        // Ejecutar la solicitud cURL
        $response = curl_exec($curl);

        // Verificar si hubo algún error con la solicitud cURL
        $err = curl_error($curl);

        // Cerrar la conexión cURL
        curl_close($curl);

        // Si hubo un error, devolver el error
        if ($err) {
            echo json_encode(['error' => 'cURL Error #: ' . $err]); // Retornar error en formato JSON
            return;
        }

        // Verificar si la respuesta está vacía
        if (empty($response)) {
            echo json_encode(['error' => 'Respuesta vacía de la API']);
            return;
        }

        // Intentar decodificar la respuesta JSON
        $data = json_decode($response, true);

        // Verificar si la decodificación fue exitosa
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['error' => 'Error al procesar la respuesta JSON: ' . json_last_error_msg()]);
            return;
        }

        // Verificar el campo 'status'
        if (isset($data['status'])) {
            $status = $data['status'];

            // Si el pago está completado, realizar una inserción en la base de datos
            if ($status == 'CHECKOUT_COMPLETED') {
                $fecha_pago = $this->convertir_fecha($data['modified_at']);
                $id_portal  = $this->session->userdata('idPortal');
                $creacion   = $this->convertir_fecha($data['created_at']);

                // Lógica para insertar en la base de datos
                $datos_pago = [
                    'estado'             =>'pagado',
                    'fecha_pago'         => $fecha_pago,
                    'payment_request_id' => $data['payment_request_id'],
                    'link_status'        => $data['payment_request_url'],
                    'referencia'         => $data['receipt_no'],
                    'status'             => $status,
                   
                ];

                $link_validado = $this->area_model->validarPago($datos_pago);

                if ($link_validado === false) {
                    echo json_encode(['error' => 'No se pudo validar el pago, intenta nuevamente.']);
                    return;
                }

            }
            echo json_encode($data);
        } else {

                                     // Si la solicitud fue exitosa, devolver la respuesta de la API en formato JSON
            echo json_encode($data); // Asegúrate de devolver el JSON de la API
        }
    }

    public function convertir_fecha($fecha_str)
    {
        // Crear el objeto DateTime en UTC (ya que el timestamp está en UTC)
        $zona_utc = new DateTimeZone('UTC');
        $fecha    = new DateTime($fecha_str, $zona_utc);

        // Ahora convertir la fecha a la zona horaria de Ciudad de México
        $zona_mexico = new DateTimeZone('America/Mexico_City');
        $fecha->setTimezone($zona_mexico);

        // Obtener la fecha convertida en el formato adecuado (Y-m-d H:i:s)
        $fecha_convertida = $fecha->format('Y-m-d H:i:s');

        // Mostrar la fecha convertida
        // echo "Fecha sin convertir : " . $fecha_str . '   ';
        //echo "Fecha convertida a la hora de México: " . $fecha_convertida . '   ';

        // También puedes retornar la fecha como una respuesta si lo prefieres
        return $fecha_convertida;
    }

}
