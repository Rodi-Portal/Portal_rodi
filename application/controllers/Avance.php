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
        // ✅ MAPEO DE IDIOMA
        $lang = $this->session->userdata('lang') ?? 'es';

        $idioma = ($lang === 'en') ? 'english' : 'espanol';

        $this->lang->load('portal_generales', $idioma);
        $this->lang->load('pre_empleo', $idioma);

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
        $this->form_validation->set_rules(
            'employee_id',
            'Employee ID',
            'required|integer'
        );
        $this->form_validation->set_rules(
            'name',
            'Document Name',
            'required'
        );

        if ($this->form_validation->run() === false) {
            echo json_encode([
                'error' => validation_errors(),
            ]);
            return;
        }

        if (empty($_FILES['file']['name'])) {
            echo json_encode([
                'error' => t('preemployment_choose_file_before_upload'),
            ]);
            return;
        }

        $employeeId = (int) $this->input->post('employee_id');
        $origen     = (int) $this->input->post('origen');

        if ($employeeId <= 0 || ! in_array($origen, [1, 2], true)) {
            echo json_encode([
                'error' => t('preemployment_document_upload_error'),
            ]);
            return;
        }

        $this->load->library('admin_auth_bridge');

        $resultadoToken = $this->admin_auth_bridge->obtenerToken();
        $accessToken    = (string) (
            $resultadoToken['body']['access_token'] ?? ''
        );

        if ($accessToken === '') {
            log_message(
                'error',
                'No fue posible obtener el token al cargar archivo de Preempleo.'
            );

            echo json_encode([
                'error' => t('preemployment_document_upload_error'),
            ]);
            return;
        }

        $tipoRuta = $origen === 1 ? 'documentos' : 'examenes';

        $apiUrl = rtrim(API_URL, '/')
            . '/pre-empleo/candidatos/'
            . $employeeId
            . '/'
            . $tipoRuta;

        /*
        * El portal y la carpeta no se mandan a Laravel:
        * se resuelven con el token y el empleado autorizado.
        */
        $description = trim((string) $this->input->post('description'));

        if (strtolower($description) === 'null') {
            $description = '';
        }
        $postFields = [

            'name'            => (string) $this->input->post('name'),
            'description'     => $description,
            'expiry_date'     => (string) $this->input->post('expiry_date'),
            'expiry_reminder' => (string) (
                $this->input->post('expiry_reminder') ?? 0
            ),
            'status'          => 1,
            'file'            => curl_file_create(
                $_FILES['file']['tmp_name'],
                $_FILES['file']['type'],
                $_FILES['file']['name']
            ),
        ];

        $respuesta = $this->callApi(
            $apiUrl,
            $postFields,
            $accessToken
        );

        if (! $respuesta['ok']) {
            log_message(
                'error',
                'No fue posible cargar archivo de Preempleo. HTTP '
                . $respuesta['http_status']
                . '. cURL: ' . $respuesta['curl_error']
                . '. Respuesta API: ' . $respuesta['raw_response']
            );

            echo json_encode([
                'error' => t('preemployment_document_upload_error'),
            ]);
            return;
        }

        echo json_encode([
            'message'  => t('preemployment_uploaded_successfully'),
            'document' => $respuesta['body']['document'] ?? [],
        ]);
    }

    private function callApi(
        string $url,
        array $data,
        string $accessToken
    ): array {
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_HTTPHEADER     => [
                'Accept: application/json',
                'Authorization: Bearer ' . $accessToken,
            ],
        ]);

        $rawResponse = curl_exec($ch);
        $curlError   = curl_error($ch);
        $httpStatus  = (int) curl_getinfo(
            $ch,
            CURLINFO_HTTP_CODE
        );

        curl_close($ch);

        $body = null;

        if (is_string($rawResponse) && $rawResponse !== '') {
            $decoded = json_decode($rawResponse, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $body = $decoded;
            }
        }

        return [
            'ok'           => $rawResponse !== false
            && $httpStatus >= 200
            && $httpStatus < 300
            && is_array($body),
            'http_status'  => $httpStatus,
            'curl_error'   => $curlError,
            'raw_response' => is_string($rawResponse)
                ? $rawResponse
                : '',
            'body'         => $body,
        ];
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
        $id_portal = (int) $this->session->userdata('idPortal');

        if (empty($id_portal)) {
            jsonOut([
                'error' => t('portal_docs_err_no_session'),
            ], 401);
        }

        $row = $this->cat_portales_model->getDocs($id_portal);

        jsonOut([
            'aviso_tiene'            => ! empty($row->aviso),
            'terminos_tiene'         => ! empty($row->terminos),
            'confidencialidad_tiene' => ! empty($row->confidencialidad),
        ]);
    }

    public function documentos_guardar()
    {
        $id_portal = (int) $this->session->userdata('idPortal');
        $tipo      = $this->input->post('tipo'); // aviso | terminos | confidencialidad

        if (empty($id_portal)) {
            jsonOut([
                'error' => t('portal_docs_err_no_session'),
            ], 401);
        }

        if (! in_array($tipo, ['aviso', 'terminos', 'confidencialidad'], true)) {
            jsonOut([
                'error' => t('portal_docs_err_invalid_type'),
            ], 422);
        }

        if (empty($_FILES['archivo']['name'])) {
            jsonOut([
                'error' => t('portal_docs_err_select_pdf'),
            ], 422);
        }

        // Directorio de subida
        $upload_path = FCPATH . '_avisosPortal' . DIRECTORY_SEPARATOR;
        if (! is_dir($upload_path)) {
            @mkdir($upload_path, 0775, true);
        }

        // Nombre final según tipo
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

        // Configuración de upload
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
            jsonOut([
                'error' => t('portal_docs_err_upload', '', ['error' => $error]),
            ], 422);
        }

        // Guardar en BD
        $this->cat_portales_model->updateDocs($id_portal, [
            $tipo     => $nombre_final,
            'edicion' => date('Y-m-d H:i:s'),
        ]);

        // Endpoint de visualización
        $ver_endpoint = [
            'aviso'            => 'ver_aviso/',
            'terminos'         => 'ver_terminos/',
            'confidencialidad' => 'ver_confidencialidad/',
        ][$tipo];

        // 👉 CLAVE: traducir el NOMBRE del documento, no el identificador
        $tipo_label = t('portal_docs_tipo_' . $tipo);

        jsonOut([
            'status'  => 'success',
            'mensaje' => t('portal_docs_saved_backend', '', [
                'tipo' => $tipo_label,
            ]),
            'archivo' => $nombre_final,
            'url'     => base_url('Avance/' . $ver_endpoint . rawurlencode($nombre_final)),
        ]);
    }

    public function documentos_eliminar()
    {
        $id_portal = (int) $this->session->userdata('idPortal');
        $tipo      = $this->input->post('tipo'); // aviso | terminos | confidencialidad

        if (! in_array($tipo, ['aviso', 'terminos', 'confidencialidad'], true)) {
            jsonOut([
                'error' => t('portal_docs_err_invalid_type'),
            ], 422);
        }

        $row     = $this->cat_portales_model->getDocs($id_portal);
        $current = $row ? ($row->{$tipo} ?? null) : null;

        if (! $current) {
            jsonOut([
                'error' => t('portal_docs_err_no_file_delete'),
            ], 404);
        }

        // Eliminar archivo físico
        $path = FCPATH . '_avisosPortal' . DIRECTORY_SEPARATOR . $current;
        if (is_file($path)) {
            @unlink($path);
        }

        // Limpiar columna en BD
        $this->cat_portales_model->updateDocs($id_portal, [
            $tipo => null,
        ]);

        // 👉 CLAVE: traducir el nombre del documento
        $tipo_label = t('portal_docs_tipo_' . $tipo);

        jsonOut([
            'status'  => 'success',
            'mensaje' => t('portal_docs_deleted_backend', '', [
                'tipo' => $tipo_label,
            ]),
        ]);
    }

}
