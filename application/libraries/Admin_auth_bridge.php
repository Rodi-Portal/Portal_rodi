<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin_auth_bridge
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();

        $this->CI->load->library('session');
        $this->CI->config->load(
            'auth_bridge_private',
            true
        );
    }

    public function obtenerToken(): array
    {
        if (! $this->sesionAdministrativaValida()) {
            return $this->resultado(401, [
                'status'  => false,
                'message' => 'Sesión administrativa no válida.',
            ]);
        }

        $tokenGuardado = $this->tokenVigente();

        if ($tokenGuardado !== null) {
            return $this->resultado(200, $tokenGuardado);
        }

        $bridge = $this->CI->config->item(
            'auth_bridge',
            'auth_bridge_private'
        );

        if (
            ! is_array($bridge) ||
            empty($bridge['secret']) ||
            strlen($bridge['secret']) < 64 ||
            empty($bridge['issuer'])
        ) {
            log_message(
                'error',
                'Configuración de Auth Bridge incompleta.'
            );

            return $this->resultado(503, [
                'status'  => false,
                'message' => 'Servicio de autenticación no disponible.',
            ]);
        }

        try {
            $nonce = bin2hex(random_bytes(32));
        } catch (Throwable $exception) {
            log_message(
                'error',
                'No fue posible generar el nonce de Auth Bridge.'
            );

            return $this->resultado(500, [
                'status'  => false,
                'message' => 'No fue posible preparar la autenticación.',
            ]);
        }

        $bridgeSessionId = (string) $this->CI->session->userdata(
            'bridge_session_id'
        );

        $payload = [
            'issuer'       => (string) $bridge['issuer'],
            'user_id'      => (int) $this->CI->session->userdata('id'),
            'portal_id'    => (int) $this->CI->session->userdata('idPortal'),
            'role_id'      => (int) $this->CI->session->userdata('idrol'),
            'timestamp'    => time(),
            'nonce'        => $nonce,
            'session_hash' => hash('sha256', $bridgeSessionId),
        ];

        $canonical = implode("\n", [
            'POST',
            '/api/admin/auth/exchange',
            $payload['issuer'],
            (string) $payload['user_id'],
            (string) $payload['portal_id'],
            (string) $payload['role_id'],
            (string) $payload['timestamp'],
            $payload['nonce'],
            $payload['session_hash'],
        ]);

        $signature = hash_hmac(
            'sha256',
            $canonical,
            $bridge['secret']
        );

        $url = rtrim(API_URL, '/')
            . '/admin/auth/exchange';

        return $this->solicitarTokenLaravel(
            $url,
            $payload,
            $signature
        );
    }

    public function limpiarTokenLocal(): void
    {
        $this->CI->session->unset_userdata([
            'admin_access_token',
            'admin_token_expires_at',
            'admin_token_usuario',
        ]);
    }

    private function sesionAdministrativaValida(): bool
    {
        return
            (bool) $this->CI->session->userdata('logueado')
            && (int) $this->CI->session->userdata('tipo') === 1
            && $this->CI->session->userdata('tipo_acceso') === 'usuario'
            && (bool) $this->CI->session->userdata(
                'autenticacion_completa'
            )
            && (int) $this->CI->session->userdata('id') > 0
            && (int) $this->CI->session->userdata('idPortal') > 0
            && (int) $this->CI->session->userdata('idrol') > 0
            && is_string(
                $this->CI->session->userdata('bridge_session_id')
            )
            && strlen(
                $this->CI->session->userdata('bridge_session_id')
            ) === 64;
    }

    private function tokenVigente(): ?array
    {
        $accessToken = $this->CI->session->userdata(
            'admin_access_token'
        );

        $expiresAt = (int) $this->CI->session->userdata(
            'admin_token_expires_at'
        );

        $usuario = $this->CI->session->userdata(
            'admin_token_usuario'
        );

        if (
            ! is_string($accessToken) ||
            $accessToken === '' ||
            $expiresAt <= time() + 60
        ) {
            $this->limpiarTokenLocal();
            return null;
        }

        return [
            'status'       => true,
            'token_type'   => 'Bearer',
            'access_token' => $accessToken,
            'expires_at'   => date(DATE_ATOM, $expiresAt),
            'usuario'      => is_array($usuario) ? $usuario : null,
            'from_cache'   => true,
        ];
    }

    private function solicitarTokenLaravel(
        string $url,
        array $payload,
        string $signature
    ): array {
        $json = json_encode($payload);

        if ($json === false) {
            return $this->resultado(500, [
                'status'  => false,
                'message' => 'No fue posible preparar la autenticación.',
            ]);
        }

        $curl = curl_init($url);

        curl_setopt_array($curl, [
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_HTTPHEADER     => [
                'Accept: application/json',
                'Content-Type: application/json',
                'X-CI3-Signature: ' . $signature,
            ],
            CURLOPT_POSTFIELDS     => $json,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);

        $response = curl_exec($curl);
        $curlError = curl_error($curl);
        $httpCode = (int) curl_getinfo(
            $curl,
            CURLINFO_HTTP_CODE
        );

        curl_close($curl);

        if ($response === false) {
            log_message(
                'error',
                'Auth Bridge cURL error: ' . $curlError
            );

            return $this->resultado(502, [
                'status'  => false,
                'message' => 'No fue posible contactar al servicio de autenticación.',
            ]);
        }

        $decoded = json_decode($response, true);

        if (! is_array($decoded)) {
            log_message(
                'error',
                'Auth Bridge recibió una respuesta no válida.'
            );

            return $this->resultado(502, [
                'status'  => false,
                'message' => 'Respuesta de autenticación no válida.',
            ]);
        }

        if (
            $httpCode === 200 &&
            ($decoded['status'] ?? false) === true &&
            ! empty($decoded['access_token']) &&
            ! empty($decoded['expires_at'])
        ) {
            $expiresAt = strtotime($decoded['expires_at']);

            if ($expiresAt === false || $expiresAt <= time()) {
                return $this->resultado(502, [
                    'status'  => false,
                    'message' => 'La vigencia del token no es válida.',
                ]);
            }

            $this->CI->session->set_userdata([
                'admin_access_token'     => $decoded['access_token'],
                'admin_token_expires_at' => $expiresAt,
                'admin_token_usuario'    => $decoded['usuario'] ?? null,
            ]);

            $decoded['from_cache'] = false;
        }

        return $this->resultado(
            $httpCode >= 100 ? $httpCode : 502,
            $decoded
        );
    }

    private function resultado(
        int $httpCode,
        array $body
    ): array {
        return [
            'http_code' => $httpCode,
            'body'      => $body,
        ];
    }
}