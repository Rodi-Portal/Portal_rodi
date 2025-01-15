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
        // Obtener los datos enviados mediante AJAX
        $amount = $this->input->post('amount'); // Ejemplo: 100.5
        $currency = $this->input->post('currency'); // Ejemplo: "MXN"
        $description = $this->input->post('description'); // Ejemplo: "Compra de ejemplo"

        // Llamar a la API de PayClip para generar el enlace de pago
        $linkPago = $this->createPayclipLink($amount, $currency, $description);

        // Retornar el enlace generado como respuesta en formato JSON
        echo json_encode(['linkPago' => $linkPago]);
    }

    // Función para llamar a la API de Payclip y generar el enlace de pago
    private function createPayclipLink($amount, $currency, $description)
    {
        $url = 'https://api.payclip.com/v2/checkout';

        $body = json_encode([
            'amount' => (float) $amount,
            'currency' => $currency,
            'purchase_description' => $description,
            'redirection_url' => [
                'success' => 'https://sandbox.talentsafecontrol.com/',
                'error' => 'https://dev.rodi.com.mx/',
                'default' => 'https://my-website.com/redirection/default',
            ],
        ]);

        $headers = [
            "Authorization: Basic ZmVkMjVhMTYtYmQ3Ni00YWI2LWFkYjYtNzdlOTYzZGE2MzhmOmU1Yjc5MjUzLWE4ZWUtNGFiMi05ZjZmLTFhZDdlMzcxY2NkOA==",
            'Accept: application/json',
            'Content-Type: application/json',
        ];

        log_message('error', 'Enviando datos a Payclip: ' . $body);

        $response = $this->makeCurlRequest($url, $body, $headers);

        if (!$response) {
            return 'Error en la comunicación con Payclip';
        }

        log_message('error', 'Respuesta de Payclip: ' . json_encode($response));

        if (isset($response['payment_request_url'])) {
            return $response['payment_request_url'];
        }

        if (isset($response['message'])) {
            return 'Error de Payclip: ' . $response['message'];
        }

        return 'Error al generar el enlace de pago';
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
        $logFile = fopen('curl_error_log.txt', 'w'); // Crear un archivo para los errores
        curl_setopt($ch, CURLOPT_STDERR, $logFile);
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

        return json_decode($response, true);
    }
}
