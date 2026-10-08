<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PaymentAccessHook
{
    public function verificar()
    {
        $CI = &get_instance();

        $controlador = strtolower($CI->router->fetch_class());
        $metodo      = strtolower($CI->router->fetch_method());

        // Rutas de acceso público o suspensión
        // Métodos de autenticación permitidos durante una suspensión
        $metodosLoginPermitidos = [
            'index',
            'verifying_account',
            'verify_new_pass',
            'recovery_view',
            'verifyview',
            'session_verificada',
            'verificar_codigo',
            'logout',
        ];

        if (
            $controlador === 'login' &&
            in_array($metodo, $metodosLoginPermitidos, true)
        ) {
            return;
        }

        if ($controlador === 'area' && $metodo === 'pasarela') {
            return;
        }

        // Solo evaluar sesiones autenticadas del portal
        $idUsuario = (int) $CI->session->userdata('id');
        $idPortal  = (int) $CI->session->userdata('idPortal');

        // Sin sesión: no interferir con las rutas públicas
        if ($idUsuario <= 0) {
            return;
        }

// Sesión existente sin portal válido:
// impedir acceso hasta resolver la inconsistencia
        if ($idPortal <= 0) {
            show_error(
                'No fue posible identificar el portal asociado a la sesión.',
                403,
                'Acceso no autorizado'
            );
            exit;
        }
        // Portales exentos de la validación de pago mensual
        $portalesExentos = TALENTSAFE_PORTALES_EXENTOS_PAGO;

        if (in_array($idPortal, $portalesExentos, true)) {
            return;
        }

        // Consultar el pago actual, sin crear registros
        $CI->load->model('avance_model');

        $estado = $CI->avance_model
            ->verificarPagoMesActual($idPortal, false);

        $CI->session->set_userdata('notPago', $estado);

        if (in_array($estado, [
            'pagado',
            'pendiente_en_plazo',
        ], true)) {
            return;
        }

        // Peticiones protegidas: impedir cualquier ejecución
        // Peticiones AJAX: responder con error de acceso
        if ($CI->input->is_ajax_request()) {
            $CI->output
                ->set_status_header(403)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode([
                    'ok'      => false,
                    'error'   => 'PORTAL_SUSPENDIDO',
                    'message' => 'El servicio se encuentra temporalmente suspendido.',
                ]))
                ->_display();

            exit;
        }

// Navegación normal: mostrar suspensión
        redirect('Area/pasarela');
        exit;
    }
}
