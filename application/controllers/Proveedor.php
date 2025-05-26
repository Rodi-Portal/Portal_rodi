<?php
defined('BASEPATH') or exit('No direct script access allowed');
// application/core/MY_Controller.php
class Proveedor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

    }

    public function destacados()
    {
        $proveedores = $this->proveedores_model->getProveedores();
        $result      = [];

        foreach ($proveedores as $prov) {
            $imagen = (! empty($prov['imagen']) && file_exists(FCPATH . 'img/provedores/' . $prov['imagen']))
            ? base_url('img/provedores/' . $prov['imagen'])
            : base_url('img/portal_icon.png');

            $result[] = [
                'id'           => $prov['id'],
                'nombre'       => htmlspecialchars($prov['nombre']),
                'descripcion'  => htmlspecialchars($prov['descripcion']),
                'descripcion1' => htmlspecialchars($prov['descripcion1']),
                'url1'         => $prov['url1'],
                'url2'         => $prov['url2'],
                'telefono'     => ! empty($prov['telefonos']) ? $prov['telefonos'][0] : '',
                'correo'       => ! empty($prov['correos']) ? $prov['correos'][0] : '',
                'imagen'       => $imagen,
                'color'        => $this->get_color_for_proveedor($prov['id']),
            ];
        }

        echo json_encode($result);
    }

    public function get_color_for_proveedor($id)
    {
        $colores = [
            '#C0392B', // Rojo fuerte
            '#00B894', // Verde menta (más claro que esmeralda)
            '#F39C12', // Naranja dorado fuerte
            '#2980B9', // Azul profundo
            '#8E44AD', // Morado oscuro
            '#E67E22', // Naranja medio, más vibrante que el oscuro
            '#1B4F72', // Azul marino (oscuro, excelente contraste)
            '#1ABC9C', // Verde turquesa brillante
            '#145A32', // Verde bosque (oscuro)
        ];
        return $colores[$id % count($colores)];
    }

    public function enviar()
    {

        $this->form_validation->set_rules('nombre', 'Nombre completo', 'required');
        $this->form_validation->set_rules('correo', 'Correo', 'required|valid_email');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'required');

        if ($this->form_validation->run() === false) {
            echo json_encode([
                'status' => 'validation_error',
                'errors' => $this->form_validation->error_array(),
            ]);
            return;
        }
        $id_portal    = $this->session->userdata('idPortal');
        $id_usuario   = $this->session->userdata('id');
        $id_proveedor = $this->input->post('proveedor_id');
        $nombre       = $this->input->post('nombre');
        $empresa      = $this->input->post('empresa');
        $correo       = $this->input->post('correo');
        $telefono     = $this->input->post('telefono');
        $descripcion  = $this->input->post('descripcion');

        $data = [
            'id_portal'    => $id_portal,
            'id_usuario'   => $id_usuario,
            'id_proveedor' => $id_proveedor,
            'nombre'       => $nombre,
            'empresa'      => $empresa,
            'correo'       => $correo,
            'telefono'     => $telefono,
            'descripcion'  => $descripcion,

        ];

        $id = $this->proveedores_model->registrarContacto($data);

        if ($id) {

            $telefonosProveedores = $this->proveedores_model->get_telefonos_by_proveedor($id_proveedor);
            $correosProveedores   = $this->proveedores_model->get_correos_by_proveedor($id_proveedor);

            $correos_enviados = 0;
            $whats_enviados   = 0;
            // print_r($correosProveedores); exit;

            foreach ($correosProveedores as $c) {
                if ($this->enviar_correo($c->correo, $c->nombre_contacto, $data)) {
                    $correos_enviados++;
                }
            }
            echo json_encode([
                'status'  => 'success',
                'message' => "Gracias por tu mensaje. Hemos enviado tu información de contacto al proveedor. Un asesor se pondrá en contacto contigo en breve. Por favor, permanece atento.",
            ]);
            /* foreach ($telefonosProveedores as $t) {
                if ($this->enviar_correo($t->correo, $t->nombre_contacto, $data)) {
                    $whats_enviados++;
                }
            }*/

        } else {
            echo json_encode([
                'status'  => 'error',
                'message' => 'No se seleccionó un proveedor válido.',
            ]);
        }
    }

    private function enviar_correo($destino, $nombre, $data)
    {
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        $mail->isSMTP();
        $mail->Host       = 'mail.talentsafecontrol.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        // ESTO ES IMPORTANTE:
        $mail->CharSet  = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->setFrom(SMTP_USER, 'TalentSafe - Contacto de Usuario');
        $mail->addAddress($destino, $nombre);
        $mail->addReplyTo($destino, $nombre);

        $mail->isHTML(true);
        $mail->Subject = 'Solicitud de contacto desde TalentSafe - Proveedores Destacados';

        $mensaje = $this->load->view('correos/contacto_provedores', [
            'nombre1'     => $nombre,
            'nombre'      => $data['nombre'],
            'empresa'     => $data['empresa'],
            'correo'      => $data['correo'],
            'telefono'    => $data['telefono'],
            'descripcion' => $data['descripcion'],
        ], true);

        $mail->Body = $mensaje;

        if (! $mail->send()) {
            log_message('error', 'Error al enviar correo a ' . $destino . ': ' . $mail->ErrorInfo);
            return false;
        }

        return true;
    }

}
