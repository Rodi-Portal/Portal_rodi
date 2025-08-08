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
        $docs = $this->db->select('id, nombre_personalizado, nombre_archivo, fecha_subida')
            ->from('documentos_aspirante')
            ->where('id_aspirante', $id_bolsa)
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
        $doc         = $this->db->get_where('documentos_aspirante', ['id' => $id_doc, 'eliminado' => 0])->row();

        if (! $doc) {
            return $this->output_json(false, 'Documento no encontrado');
        }

        /* ── subir nuevo archivo ────────────────────────── */
        if (empty($_FILES['file']['name'])) {
            return $this->output_json(false, 'Debes seleccionar un archivo');
        }

        $config = [
            'upload_path'   => LINKASPIRANTESDOCS,
            'allowed_types' => 'pdf|jpg|jpeg|png|gif|bmp',
            'max_size'      => 25600,
            'encrypt_name'  => true,
        ];
        $this->load->library('upload', $config);

        if (! $this->upload->do_upload('file')) {
            return $this->output_json(false, strip_tags($this->upload->display_errors()));
        }
        $data = $this->upload->data();

        /* ── borrar físico anterior ─────────────────────── */
        $old = LINKASPIRANTESDOCS . $doc->nombre_archivo;
        if (is_file($old)) {
            unlink($old);
        }

        /* ── update BD ───────────────────────────────────── */
        $this->db->where('id', $id_doc)
            ->update('documentos_aspirante', [
                'nombre_personalizado' => $nuevoNombre ?: $doc->nombre_personalizado,
                'nombre_archivo'       => $data['file_name'],
                'tipo'                 => strtolower(pathinfo($data['file_name'], PATHINFO_EXTENSION)),
                'fecha_actualizacion'  => date('Y-m-d H:i:s'),
            ]);

        return $this->output_json(true, 'Documento actualizado', $data);
    }

/**
 * Helper para responder JSON estándar
 */
    public function subir()
    {
        // ───────────────────────────────────────────────────
        // 1. Datos básicos
        // ───────────────────────────────────────────────────
        $id_bolsa   = $this->input->post('id_aspirante') ?: $this->input->post('id_aspirante');
        $id_usuario = $this->session->userdata('id') ?: 0; // asegúrate de tener sesión
        $nombres    = $this->input->post('nombres_archivos');

                                           // Carpeta de destino
        $upload_path = LINKASPIRANTESDOCS; // constante definida en config
        if (! is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        // ───────────────────────────────────────────────────
        // 2. Validación de archivos recibidos
        // ───────────────────────────────────────────────────
        if (empty($_FILES['file']['name']) || ! is_array($_FILES['file']['name'])) {
            return $this->output_json(false, 'No se recibieron archivos');
        }

        $total_files = count($_FILES['file']['name']);
        if ($total_files !== count($nombres)) {
            return $this->output_json(false, 'Faltan nombres personalizados para uno o más archivos');
        }

        // ───────────────────────────────────────────────────
        // 3. Configuración base de la librería Upload
        // ───────────────────────────────────────────────────
        $base_config = [
            'upload_path'   => $upload_path,
            'allowed_types' => 'pdf|jpg|jpeg|png|gif|bmp|mp4|mov|avi|wmv|mkv|webm',
            'max_size'      => 25600, // 25 MB en KB
            'encrypt_name'  => true,
        ];

        $this->load->database();
        $responses = [];

        // ───────────────────────────────────────────────────
        // 4. Procesar cada archivo
        // ───────────────────────────────────────────────────
        for ($i = 0; $i < $total_files; $i++) {

            // Remapea a 'single_file' para usar la librería Upload
            $_FILES['single_file'] = [
                'name'     => $_FILES['file']['name'][$i],
                'type'     => $_FILES['file']['type'][$i],
                'tmp_name' => $_FILES['file']['tmp_name'][$i],
                'error'    => $_FILES['file']['error'][$i],
                'size'     => $_FILES['file']['size'][$i],
            ];

            // Carga la librería con sufijo único
            $this->load->library('upload', $base_config, 'u' . $i);

            if ($this->{'u' . $i}->do_upload('single_file')) {

                $data = $this->{'u' . $i}->data(); // info del archivo subido

                // Guarda en BD
                $this->db->insert('documentos_aspirante', [
                    'id_aspirante'         => $id_bolsa,
                    'id_usuario'           => $id_usuario,
                    'nombre_personalizado' => $nombres[$i],
                    'nombre_archivo'       => $data['file_name'],

                    'fecha_subida'         => date('Y-m-d H:i:s'),
                    'fecha_actualizacion'  => date('Y-m-d H:i:s'),
                    'eliminado'            => 0,
                ]);

                $responses[] = [
                    'success' => true,
                    'file'    => $data['file_name'],
                ];

            } else {
                // (1)  Mensaje original en inglés
                $raw = strip_tags($this->{'u' . $i}->display_errors('', ''));

                                                                         // (2)  Conviértelo en texto en ESPAÑOL
                $msg = $this->traducir_error_upload($raw, $base_config); // ← nueva función

                $responses[] = [
                    'success' => false,
                    'file'    => $_FILES['single_file']['name'],
                    'error'   => $msg, // ← ya traducido
                ];
            }
        }

        // ───────────────────────────────────────────────────
        // 5. Devuelve JSON
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
