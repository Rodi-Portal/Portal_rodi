<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Avance extends CI_Controller
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

    public function editar()
    {
        $id             = $this->input->post('id');
        $nombre_archivo = '';
        $avanceDetalle  = $this->avance_model->get_detalles($id);
        if (isset($_FILES['archivo']['name'])) {
            $extension               = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
            $cadena                  = substr(md5(time()), 0, 16);
            $nombre_archivo          = $cadena . "." . $extension;
            $config['upload_path']   = './_adjuntos/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['overwrite']     = true;
            $config['file_name']     = $nombre_archivo;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ($this->upload->do_upload('archivo')) {
                if (! empty($avanceDetalle->adjunto)) {
                    unlink('./_adjuntos/' . $avanceDetalle->adjunto);
                }
            }
        } else {
            if (! empty($avanceDetalle->adjunto)) {
                unlink('./_adjuntos/' . $avanceDetalle->adjunto);
            }
        }
        $data = [
            'comentarios' => $this->input->post('msj'),
            'adjunto'     => $nombre_archivo,
        ];
        $this->avance_model->update_detalle($data, $id);
        $msj = [
            'codigo' => 1,
            'msg'    => 'Mensaje de avance modificado correctamente',
        ];
        echo json_encode($msj);
    }
    public function eliminar()
    {
        $id            = $this->input->post('id');
        $avanceDetalle = $this->avance_model->get_detalles($id);
        if (! empty($avanceDetalle->adjunto)) {
            unlink('./_adjuntos/' . $avanceDetalle->adjunto);
        }
        $this->avance_model->delete_detalle($id);
        $msj = [
            'codigo' => 1,
            'msg'    => 'Mensaje de avance eliminado correctamente',
        ];
        echo json_encode($msj);
    }
    public function get()
    {
        $id_candidato  = $this->input->post('id_candidato');
        $idioma        = ($this->input->post('espanol') == 1) ? 'espanol' : 'ingles';
        $tituloArchivo = ($this->input->post('espanol') == 1) ? 'Ver imagen' : 'View file';
        $data          = [];
        $src           = '';
        $mensajes      = $this->avance_model->get_detalles_by_candidato($id_candidato);
        if ($mensajes) {
            foreach ($mensajes as $row) {
                if (! empty($row->adjunto)) {
                    $src = base_url() . "_adjuntos/" . $row->adjunto;
                }
                $fecha  = fechaTexto($row->fecha, $idioma);
                $data[] = [
                    'fecha'         => $fecha,
                    'tituloArchivo' => $tituloArchivo,
                    'mensaje'       => $row->comentarios,
                    'archivo'       => $src,
                ];
                //$salida .= ( != "")? "<a href='".base_url()."_adjuntos/".$row->adjunto."' target='_blank' style='margin-bottom: 10px;text-align:center;'>".$txt_imagen."</a><hr>" : "<hr>";
            }
        }
        echo json_encode($data);
    }

    public function subirDocumentoInterno()
    {
        // Validación básica de los campos
        $this->form_validation->set_rules('employee_id', 'Employee ID', 'required');
        $this->form_validation->set_rules('name', 'Document Name', 'required');

        if ($this->form_validation->run() == false) {
            echo json_encode(['error' => validation_errors()]);
            return;
        }

        // Validar si se ha seleccionado un archivo
        if (empty($_FILES['file']['name'])) {
            echo json_encode(['error' => 'Por favor, elige un archivo antes de subirlo.']);
            return;
        }

        // Obtener los datos del archivo
        $file = $_FILES['file'];

        // Datos adicionales del formulario
        $employee_id     = $this->input->post('employee_id');
        $name            = $this->input->post('name');
        $expiry_reminder = $this->input->post('expiry_reminder');
        $status          = $this->input->post('status');
        $id_portal       = $this->input->post('id_portal');
        $carpeta         = $this->input->post('carpeta');

        // Determina la URL del endpoint de la API de Laravel
        if ($this->input->post('origen') == 1) {
            $api_url = API_URL . 'documents/';
        } else {
            $api_url = API_URL . 'exams/';
        }

        // Preparar los datos para la API de Laravel
        $data = [
            'employee_id'     => $employee_id,
            'name'            => $name,
            'expiry_reminder' => $expiry_reminder,
            'status'          => $status,
            'id_portal'       => $id_portal,
            'carpeta'         => $carpeta,
        ];

        // Adjuntar el archivo al cuerpo de la solicitud
        $file_data = [
            'file' => curl_file_create($file['tmp_name'], $file['type'], $file['name']),
        ];

        // Fusionar los datos del archivo y los campos del formulario
        $post_fields = array_merge($data, $file_data);

        // Realizar la solicitud cURL a la API de Laravel
        $response = $this->callApi($api_url, $post_fields);
        
        // Procesar la respuesta de la API
        if ($response['message']) {
            // Obtener el mensaje y los datos del documento desde la respuesta
            $message  = $response['message'];
            $document = $response['document'];

            // Responder con el mensaje y datos
            echo json_encode([
                'message'  => $message,
                'document' => $document,
            ]);
        } else {
            // Manejar error si no es exitoso
            echo json_encode(['error' => 'No se pudo subir el documento']);
        }
    }

    private function callApi($url, $data)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);

        // Verificar si hay errores en la solicitud cURL
        if (curl_errno($ch)) {
            echo json_encode(['error' => curl_error($ch)]);
            curl_close($ch);
            return;
        }

        curl_close($ch);

        // Verifica si la respuesta está vacía
        if (empty($response)) {
            echo json_encode(['error' => 'Respuesta vacía de la API']);
            return;
        }

        // Verifica que la respuesta sea un JSON válido
        $decodedResponse = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['error' => 'Error al decodificar la respuesta JSON']);
            return;
        }

        // Decodificar la respuesta JSON
        return $decodedResponse;
    }

}
