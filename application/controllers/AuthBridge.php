<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AuthBridge extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('admin_auth_bridge');
    }

    public function exchange()
    {
        if ($this->input->method(true) !== 'POST') {
            return $this->jsonResponse([
                'status'  => false,
                'message' => 'Método no permitido.',
            ], 405);
        }

        $resultado = $this->admin_auth_bridge->obtenerToken();

        return $this->jsonResponse(
            $resultado['body'],
            $resultado['http_code']
        );
    }

    private function jsonResponse(array $data, int $status)
    {
        return $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data));
    }
}