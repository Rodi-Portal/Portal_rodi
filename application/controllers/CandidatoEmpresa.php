<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CandidatoEmpresa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('id')) {
            redirect('Login/index');
        }
        $this->load->library('usuario_sesion');
        $this->usuario_sesion->checkStatusBD();
    }

    public function getById()
    {
        $res = $this->candidato_empresa_model->getById($this->input->post('id'));
        if ($res != null) {
            echo json_encode($res);
        } else {
            echo $res = 0;
        }
    }

public function enviarInternoEmpleado()
{
    date_default_timezone_set('America/Mexico_City'); // Zona horaria de México

    $id_candidato = $this->input->post('id');
    $id_cliente   = $this->input->post('sucursal_id');
    $id_usuario   = $this->session->userdata('id');

    $data = [
        'id_cliente' => $id_cliente,
        'id_usuario' => $id_usuario,
        'status'     => 1,
        'edicion'    => date('Y-m-d H:i:s') // Fecha y hora actual de México
    ];

    $result = $this->empleados_model->updateEmpleado($id_candidato, $data);

    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'El colaborador se envió correctamente a la sucursal seleccionada'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al enviar a empleados'
        ]);
    }
}



    public function getActivas()
    {
        $id_portal = $this->session->userdata('idPortal');
        $sucs      = $this->cat_cliente_model->getAccesossucursalesActivas($id_portal);
        // $sucs normalmente es un array de objetos (result()).

        $resp = [
            'success' => true,
            'data'    => $sucs, // tal cual: [{idCliente:..., nombre:...}, ...]
        ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($resp, JSON_UNESCAPED_UNICODE));
    }
    public function set()
    {
        $id_candidato   = $this->input->post('id_candidato');
        $fail           = 0;
        $data['campos'] = $this->formulario_model->getBySeccion($this->input->post('id_seccion'), 'orden_front');
        if ($data['campos']) {
            foreach ($data['campos'] as $campo) {
                $this->form_validation->set_rules($campo->name, $campo->backend_label, $campo->backend_rule);

                $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
                $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');
                $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
                if ($this->form_validation->run() == false) {
                    $fail++;
                    break;
                }
            }
            if ($fail > 0) {
                $msj = [
                    'codigo' => 0,
                    'msg'    => validation_errors(),
                ];
            } else {
                date_default_timezone_set('America/Mexico_City');
                $date       = date('Y-m-d H:i:s');
                $id_usuario = $this->session->userdata('id');

                $hayId = $this->candidato_empresa_model->countByIdCandidato($id_candidato);
                if ($hayId == 0) {
                    $creacion = [
                        'creacion'     => $date,
                        'edicion'      => $date,
                        'id_usuario'   => $id_usuario,
                        'id_candidato' => $id_candidato,
                    ];
                    $this->candidato_empresa_model->add($creacion);
                    foreach ($data['campos'] as $c) {
                        $edicion = [
                            'edicion'      => $date,
                            'id_usuario'   => $id_usuario,
                            $c->referencia => $this->input->post($c->name),
                        ];
                        $this->candidato_empresa_model->edit($edicion, $id_candidato);
                    }
                } else {
                    foreach ($data['campos'] as $c) {
                        $edicion = [
                            'edicion'      => $date,
                            'id_usuario'   => $id_usuario,
                            $c->referencia => $this->input->post($c->name),
                        ];
                        $this->candidato_empresa_model->edit($edicion, $id_candidato);
                    }
                }
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'Empresa del candidato actualizada correctamente',
                ];
            }
        } else {
            $msj = [
                'codigo' => 0,
                'msg'    => 'Error en el formulario',
            ];
        }
        echo json_encode($msj);
    }

}
