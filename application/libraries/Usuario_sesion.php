<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_sesion
{

    public function checkStatusBD()
    {
        $CI = &get_instance();

        $idUsuario = (int) $CI->session->userdata('id');
        $tipo      = (int) $CI->session->userdata('tipo');

        if ($idUsuario <= 0) {
            return;
        }

        if ($tipo === 2) {

            // Validación específica para usuarios clientes.
            $result = $CI->db
                ->select('
                UC.status AS usuario_status,
                UC.eliminado AS usuario_eliminado,
                CL.status AS cliente_status,
                CL.eliminado AS cliente_eliminado
            ')
                ->from('usuarios_clientes AS UC')
                ->join('cliente AS CL', 'CL.id = UC.id_cliente')
                ->where('UC.id', $idUsuario)
                ->get()
                ->row();

            $invalido = ! $result
            || (int) $result->usuario_status !== 1
            || (int) $result->usuario_eliminado !== 0
            || (int) $result->cliente_status !== 1
            || (int) $result->cliente_eliminado !== 0;

        } else {

            // Conservar la validación existente para otros usuarios.
            $CI->load->model('usuario_model');

            $result = $CI->usuario_model->checkUsuarioActivo($idUsuario);

            $invalido = ! $result
            || (int) $result->status === 0
            || (int) $result->eliminado === 1;
        }

        if ($invalido) {
            $CI->session->sess_destroy();
            redirect('Login/index');
            exit;
        }
    }

}
