<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Documentos_Aspirantes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Carga helpers, librerías y modelo si lo usas
        $this->load->helper(['url', 'file']);
        $this->load->library('session');
        // $this->load->model('Documento_model'); // Si después usas modelo
    }

    public function lista($id_bolsa = 0)
    {
        // Sanitiza/parchea por si llega sin parámetro
        $id_bolsa = (int) $id_bolsa;

        // Si no viene un ID válido, 400 Bad Request
        if ($id_bolsa === 0) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'ok'      => false,
                    'message' => 'id_bolsa inválido',
                ]));
        }

        // Consulta: solo documentos no eliminados
        $docs = $this->db->select('id, nombre_personalizado, nombre_archivo, fecha_subida, tipo_vista')
            ->from('documentos_aspirante')
            ->where('id_aspirante', $id_bolsa)
            ->where('tipo_vista', 1)
            ->where('eliminado', 0)
            ->order_by('fecha_subida', 'DESC')
            ->get()
            ->result();

        // Respuesta
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($docs));
    }

    public function stream($id = 0)
    {
        $id = (int) $id;

        // 1. ¿Existe el registro y no está eliminado?
        $doc = $this->db->get_where(
            'documentos_aspirante',
            ['id' => $id, 'eliminado' => 0]
        )->row();

        if (! $doc) {
            // 404 limpio si el id no está en la BD
            show_error('Documento no encontrado', 404);
        }

        // 2. ¿Existe físicamente el archivo en disco?
        $file = LINKASPIRANTESDOCS . '/' . $doc->nombre_archivo;

        if (! is_file($file)) {
            // evita los warnings de mime_content_type / file_get_contents
            show_error('El archivo fue eliminado o movido del servidor', 404);
        }

        // 3. Stream: si todo está bien, envía el archivo
        $mime = mime_content_type($file);

        $this->output
            ->set_content_type($mime)
            ->set_output(file_get_contents($file));
    }

    public function actualizar()
    {
        $id_doc      = $this->input->post('id_doc');
        $nuevoNombre = $this->input->post('nuevo_nombre', true) ?? '';
        $id_usuario  = $this->session->userdata('id');
        $doc         = $this->db->get_where('documentos_aspirante', ['id' => $id_doc, 'eliminado' => 0])->row();
        if (! $doc) {
            return $this->output_json(false, 'Documento no encontrado');
        }

        $nuevoArchivo = null;

        // 1. Si hay archivo, lo sube
        if (! empty($_FILES['file']['name'])) {
            $config = [
                'upload_path'   => LINKASPIRANTESDOCS,
                'allowed_types' => 'pdf|jpg|jpeg|png|gif|bmp|mp4|mov|avi|wmv|mkv|webm',
                'max_size'      => 25600,
                'encrypt_name'  => true,
            ];
            $this->load->library('upload', $config);

            if (! $this->upload->do_upload('file')) {
                return $this->output_json(false, strip_tags($this->upload->display_errors()));
            }

            $nuevoArchivo = $this->upload->data();

            // Borrar el archivo anterior
            $old = LINKASPIRANTESDOCS . $doc->nombre_archivo;
            if (is_file($old)) {
                unlink($old);
            }
        }

        // 2. Prepara datos para update
        $dataUpdate = [
            'nombre_personalizado' => $nuevoNombre ?: $doc->nombre_personalizado,
            'fecha_actualizacion'  => date('Y-m-d H:i:s'),
            'id_usuario'           => $id_usuario,
        ];

        if ($nuevoArchivo) {
            $dataUpdate['nombre_archivo'] = $nuevoArchivo['file_name'];
            $dataUpdate['tipo']           = strtolower(pathinfo($nuevoArchivo['file_name'], PATHINFO_EXTENSION));
        }

        // 3. Ejecuta el update
        $this->db->where('id', $id_doc)->update('documentos_aspirante', $dataUpdate);

        return $this->output_json(true, 'Documento actualizado', $nuevoArchivo ?: []);
    }
    public function actualizar_tipo_vista()
    {
        $id         = $this->input->post('id');
        $tipo_vista = $this->input->post('tipo_vista');

        if (! is_numeric($id) || ! in_array($tipo_vista, ['0', '1'])) {
            return $this->output_json(false, 'Datos inválidos');
        }

        $this->db->where('id', $id)
            ->update('documentos_aspirante', ['tipo_vista' => $tipo_vista]);

        return $this->output_json(true, 'Vista actualizada');
    }

    public function eliminar()
    {
        $id         = $this->input->post('id');
        $id_usuario = $this->session->userdata('id');

        if (! $id) {
            return $this->output_json(false, 'ID no proporcionado');
        }

        $doc = $this->db->get_where('documentos_aspirante', ['id' => $id, 'eliminado' => 0])->row();

        if (! $doc) {
            return $this->output_json(false, 'Documento no encontrado o ya fue eliminado');
        }

        // Soft delete: solo marcar como eliminado
        $this->db->where('id', $id)
            ->update('documentos_aspirante', [
                'eliminado'           => 1,
                'fecha_actualizacion' => date('Y-m-d H:i:s'),
                'id_usuario'          => $id_usuario,
            ]);

        return $this->output_json(true, 'Documento eliminado correctamente');
    }

/**
 * Helper para responder JSON estándar
 */
    public function subir()
    {
        $this->output->set_content_type('application/json');

        // ───────────────────────────────────────────────────
        // 1) Datos básicos
        // ───────────────────────────────────────────────────
        // Toma primero id_bolsa (si lo mandas) o id_aspirante como fallback
        $id_bolsa   = $this->input->post('id_bolsa') ?: $this->input->post('id_aspirante');
        $id_usuario = $this->session->userdata('id') ?: 0;

        // nombres_archivos puede venir como arreglo o string/JSON
        $nombres = $this->input->post('nombres_archivos');
        if (is_string($nombres)) {
            $json = json_decode($nombres, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $nombres = $json;
            }

        }
        if (! is_array($nombres)) {
            $nombres = (array) $nombres;
        }

                                           // Carpeta destino
        $upload_path = LINKASPIRANTESDOCS; // tu constante
        if (! is_dir($upload_path)) {
            @mkdir($upload_path, 0777, true);
        }

        // ───────────────────────────────────────────────────
        // 2) Detectar clave de archivos y normalizar a arreglo
        // ───────────────────────────────────────────────────
        $filesKey = null;
        if (isset($_FILES['files'])) {
            $filesKey = 'files';
        } elseif (isset($_FILES['file'])) {
            $filesKey = 'file';
        } else {
            return $this->output_json(false, 'No se recibieron archivos');
        }

        // Si vino un solo archivo plano, conviértelo a estructura de arreglos
        if (! is_array($_FILES[$filesKey]['name'])) {
            foreach (['name', 'type', 'tmp_name', 'error', 'size'] as $k) {
                $_FILES[$filesKey][$k] = [$_FILES[$filesKey][$k]];
            }
        }

        $total_files = count($_FILES[$filesKey]['name']);

        // Si mandaron 1 nombre para todos, lo replicamos; si mandaron ninguno, se pondrá fallback por archivo.
        if (count($nombres) === 1 && $total_files > 1) {
            $nombres = array_fill(0, $total_files, (string) $nombres[0]);
        }

        // ───────────────────────────────────────────────────
        // 3) Configuración Upload
        // ───────────────────────────────────────────────────
        $base_config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'pdf|jpg|jpeg|png|gif|bmp|mp4|mov|avi|wmv|mkv|webm',
            'max_size'      => 25600, // 25 MB (en KB para CI3)
            'encrypt_name'  => true,
        ];

        $this->load->database();
        $responses = [];

        // ───────────────────────────────────────────────────
        // 4) Subir cada archivo
        // ───────────────────────────────────────────────────
        for ($i = 0; $i < $total_files; $i++) {
            // Remap a un solo archivo para la librería Upload
            $_FILES['single_file'] = [
                'name'     => $_FILES[$filesKey]['name'][$i],
                'type'     => $_FILES[$filesKey]['type'][$i],
                'tmp_name' => $_FILES[$filesKey]['tmp_name'][$i],
                'error'    => $_FILES[$filesKey]['error'][$i],
                'size'     => $_FILES[$filesKey]['size'][$i],
            ];

            // Inicializa la librería (handler distinto por iteración)
            $this->load->library('upload', $base_config, 'u' . $i);

            if ($this->{'u' . $i}->do_upload('single_file')) {
                $data = $this->{'u' . $i}->data(); // info del archivo

                // Nombre personalizado con fallback al nombre base del archivo
                $nombrePersonal = isset($nombres[$i]) && trim((string) $nombres[$i]) !== ''
                    ? trim((string) $nombres[$i])
                    : pathinfo($_FILES['single_file']['name'], PATHINFO_FILENAME);

                // Guarda en BD
                $this->db->insert('documentos_aspirante', [
                    'id_aspirante'         => $id_bolsa,
                    'id_usuario'           => $id_usuario,
                    'nombre_personalizado' => $nombrePersonal,
                    'nombre_archivo'       => $data['file_name'],
                    'fecha_subida'         => date('Y-m-d H:i:s'),
                    'fecha_actualizacion'  => date('Y-m-d H:i:s'),
                    'eliminado'            => 0,
                ]);

                $responses[] = [
                    'success' => true,
                    'file'    => $_FILES['single_file']['name'],
                    'stored'  => $data['file_name'],
                    'label'   => $nombrePersonal,
                ];
            } else {
                $raw = strip_tags($this->{'u' . $i}->display_errors('', ''));
                $msg = method_exists($this, 'traducir_error_upload')
                    ? $this->traducir_error_upload($raw, $base_config)
                    : $raw;

                $responses[] = [
                    'success' => false,
                    'file'    => $_FILES['single_file']['name'],
                    'error'   => $msg,
                ];
            }
        }

        // ───────────────────────────────────────────────────
        // 5) Respuesta JSON
        // ───────────────────────────────────────────────────
        return $this->output_json(true, 'Proceso terminado', $responses);
    }

    private function output_json($ok, $msg, $data = [])
    {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'ok'      => $ok,
                'message' => $msg,
                'data'    => $data,
            ]));
    }

    /**
     * Mapea los mensajes por defecto de CI_Upload a español.
     * Amplía los casos según necesites.
     */
// ------------------------------------------------------------------
//  MÉTODO PRIVADO DE TRADUCCIÓN
// ------------------------------------------------------------------
    private function traducir_error_upload($raw, $cfg)
    {
        if (strpos($raw, 'larger than the permitted size') !== false ||
            strpos($raw, 'exceeds the maximum allowed size') !== false) {

            $limiteMB = $cfg['max_size'] / 1024;
            return "El archivo excede el tamaño máximo permitido ({$limiteMB} MB).";
        }

        if (strpos($raw, 'filetype you are attempting to upload is not allowed') !== false) {
            return 'Tipo de archivo no permitido. Solo se aceptan PDF, imágenes o video.';
        }

        if (strpos($raw, 'You did not select a file to upload') !== false) {
            return 'No seleccionaste ningún archivo.';
        }

        if (strpos($raw, 'upload_path does not appear to be valid') !== false) {
            return 'Error interno: la carpeta de destino no existe o no es escribible.';
        }

        return $raw; // por defecto deja el texto original
    }

}
