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
        $this->load->library('encryption');
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
            $api_url = API_URL . 'documents';
        } else {
            $api_url = API_URL . 'exams';
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

        // Procesar la respuesta de la API
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

    public function ver($token = null)
    {
        try {
            // Imprimir el token recibido
            echo 'Token recibido: ' . $token . '<br>';

            // Desencriptar el token
            $param = $this->encryption->decrypt(urldecode($token));

            // Imprimir el token desencriptado
            echo 'Token desencriptado: ' . $param . '<br>';

            if (! $param) {
                // Si no se puede desencriptar el token, mostrar error
                echo 'Error al desencriptar el token<br>';
                show_error('Token inválido', 400);
                return;
            }

            list($carpeta, $archivo) = explode('|', $param);

            // Imprimir los valores de carpeta y archivo
            echo 'Carpeta: ' . $carpeta . ' Archivo: ' . $archivo . '<br>';

            // Sanitizar la ruta y el archivo
            $carpeta = trim($carpeta, '/');
            $archivo = trim($archivo, '/');

            // Imprimir los valores de carpeta y archivo después de sanitización
            echo 'Carpeta sanitizada: ' . $carpeta . ' Archivo sanitizado: ' . $archivo . '<br>';

            // Validar que no se intente acceder a directorios fuera del alcance
            if (strpos($carpeta, '..') !== false || strpos($archivo, '..') !== false) {
                echo 'Ruta inválida detectada: Carpeta o archivo contiene ".."<br>';
                show_error('Ruta inválida', 400);
                return;
            }

            // Construir la ruta del archivo
            $path = FCPATH . $carpeta . DIRECTORY_SEPARATOR . $archivo;

            // Imprimir la ruta del archivo construida
            echo 'Ruta del archivo construida: ' . $path . '<br>';

            // Verificar si el archivo existe
            if (! file_exists($path)) {
                echo 'Archivo no encontrado en la ruta: ' . $path . '<br>';
                show_error('Archivo no encontrado', 404);
                return;
            }

            // Cargar el helper para obtener el tipo MIME
            $this->load->helper('file');
            $mime = get_mime_by_extension($path);

            // Imprimir el tipo MIME
            echo 'Tipo MIME del archivo: ' . $mime . '<br>';

            // Establecer encabezados para mostrar el archivo en línea
            header('Content-Type: ' . $mime);
            header('Content-Disposition: inline; filename="' . $archivo . '"');

            // Imprimir que se está leyendo el archivo
            echo 'Leyendo archivo: ' . $archivo . '<br>';

            readfile($path);

        } catch (Exception $e) {
            // Imprimir el error en caso de excepción
            echo 'Error en el procesamiento del token: ' . $e->getMessage() . '<br>';
            show_error('Token inválido', 400);
        }
    }

    public function ver_aviso($archivo = null)
    {
        $default = 'AV_TL_V1.pdf'; // <- tu default
        $baseDir = FCPATH . '_avisosPortal' . DIRECTORY_SEPARATOR;

        // 1) si no viene nombre, usa default
        $archivo = $archivo ? trim($archivo, "/\\") : $default;

        // 2) sanitiza (sin rutas)
        $archivo = basename($archivo);

        // 3) arma ruta y fallback al default si no existe
        $ruta = $baseDir . $archivo;
        if (! is_file($ruta)) {
            $ruta = $baseDir . $default;
            if (! is_file($ruta)) {
                show_error('Archivo no encontrado', 404);
                return;
            }
            $archivo = $default;
        }

        // 4) MIME y headers
        $mime = function_exists('mime_content_type') ? mime_content_type($ruta) : 'application/pdf';
        if (stripos($mime, 'pdf') === false) {$mime = 'application/pdf';}

        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($ruta));
        header('Content-Disposition: inline; filename="' . rawurlencode($archivo) . '"');
        readfile($ruta);
        exit;
    }

    // application/controllers/Proveedores.php

    public function get_proveedores()
    {
        // Obtener los proveedores desde el modelo
        $proveedores = $this->avance_model->get_proveedores();

        // Devolver los datos en formato JSON
        echo json_encode($proveedores);
    }
    public function documentos_info()
    {
        $this->output->set_content_type('application/json');

        $id_portal = $this->session->userdata('idPortal');
        $row       = $this->cat_portales_model->getDocs($id_portal); // columnas: 'aviso', 'terminos', 'confidencialidad'

        echo json_encode([
            'aviso_actual'             => $row->aviso ?? null,
            'terminos_actual'          => $row->terminos ?? null,
            'confidencialidad_actual'  => $row->confidencialidad ?? null,
            // defaults (ajústalos si ya tienes otros nombres por defecto)
            'default_aviso'            => 'AV_TL_V1.pdf',
            'default_terminos'         => 'TM_TL_V1.pdf',
            'default_confidencialidad' => 'AC_TL_V1.pdf',
        ]);
    }

    public function documentos_guardar()
    {
        $this->output->set_content_type('application/json');

        $id_portal = (int) $this->session->userdata('idPortal');
        $tipo      = $this->input->post('tipo'); // 'aviso' | 'terminos' | 'confidencialidad'

        if (empty($id_portal)) {
            echo json_encode(['error' => 'Sesión sin idPortal']);return;
        }
        if (! in_array($tipo, ['aviso', 'terminos', 'confidencialidad'], true)) {
            echo json_encode(['error' => 'Tipo inválido']);return;
        }
        if (empty($_FILES['archivo']['name'])) {
            echo json_encode(['error' => 'Selecciona un PDF']);return;
        }

        // Directorio destino (EXISTENTE y con permisos de escritura)
        $upload_path = FCPATH . '_avisosPortal' . DIRECTORY_SEPARATOR;
        if (! is_dir($upload_path)) {
            @mkdir($upload_path, 0775, true);
        }

        // Nombre final por tipo (prefijo con id_portal)
        switch ($tipo) {
            case 'aviso':
                $nombre_final = $id_portal . '_avisoPrivacidad.pdf';
                break;
            case 'terminos':
                $nombre_final = $id_portal . '_terminosCondiciones.pdf';
                break;
            case 'confidencialidad':
                $nombre_final = $id_portal . '_acuerdoConfidencialidad.pdf';
                break;
        }

        // Config de subida
        $config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'pdf',
            'max_size'      => 5120, // 5MB
            'file_name'     => $nombre_final,
            'overwrite'     => true,
        ];

        $this->load->library('upload', $config);

        if (! $this->upload->do_upload('archivo')) {
            $error = strip_tags($this->upload->display_errors('', ''));
            echo json_encode(['error' => 'Error al subir: ' . $error]);
            return;
        }

        // Persistimos en DB (campo = nombre del tipo)
        $this->cat_portales_model->updateDocs($id_portal, [
            $tipo     => $nombre_final, // 'aviso' | 'terminos' | 'confidencialidad'
            'edicion' => date('Y-m-d H:i:s'),
        ]);

        // URL para previsualizar/descargar (si ya tienes ver_aviso/ver_terminos, añade ver_confidencialidad o usa un ver_doc genérico)
        $ver_endpoint = [
            'aviso'            => 'ver_aviso/',
            'terminos'         => 'ver_terminos/',
            'confidencialidad' => 'ver_confidencialidad/',
        ][$tipo];

        echo json_encode([
            'status'  => 'success',
            'mensaje' => ucfirst($tipo) . ' actualizado.',
            'archivo' => $nombre_final,
            'ver_url' => base_url('Avance/' . $ver_endpoint . rawurlencode($nombre_final)),
        ]);
    }

    public function documentos_eliminar()
    {
        $this->output->set_content_type('application/json');

        $id_portal = (int) $this->session->userdata('idPortal');
        $tipo      = $this->input->post('tipo');

        if (! in_array($tipo, ['aviso', 'terminos', 'confidencialidad'], true)) {
            echo json_encode(['error' => 'Tipo inválido']);return;
        }

        $row     = $this->cat_portales_model->getDocs($id_portal);
        $current = $row ? ($row->{$tipo} ?? null) : null;
        if (! $current) {echo json_encode(['error' => 'No hay archivo para eliminar']);return;}

        // Borramos del mismo lugar donde guardamos
        $path = FCPATH . '_avisosPortal' . DIRECTORY_SEPARATOR . $current;
        if (is_file($path)) {
            @unlink($path);
        }

        // Limpiamos columna
        $this->cat_portales_model->updateDocs($id_portal, [$tipo => null]);

        echo json_encode(['status' => 'success', 'mensaje' => ucfirst($tipo) . ' eliminado.']);
    }

}