<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Documentos_Aspirantes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Helpers base (incluye i18n)
        $this->load->helper(['url', 'file', 'language', 'i18n']);

        // Sesión
        $this->load->library('session');

        // 🔒 Seguridad (igual que en tus otros controladores)
        if (! $this->session->userdata('id')) {
            redirect('Login/index');
            return;
        }

        // Idioma actual
        $raw = strtolower((string) ($this->session->userdata('lang') ?: 'es'));
        $map = [
            'es'      => 'espanol',
            'en'      => 'english',
            'spanish' => 'espanol',
            'english' => 'english',
        ];
        $lang = $map[$raw] ?? 'espanol';

        // ✅ Carga de archivos de idioma que se usan en esta pantalla/flow
        // (mínimo el de progreso, porque de ahí estamos sacando keys rec_prog_*)
        $this->lang->load('reclutamiento_progreso', $lang);

        // Si también reutilizas keys comunes de escritorio, opcional:
       
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

        $doc = $this->_documento_aspirante_context($id);

        if (! $doc) {
            show_404();
        }

        $filename = basename(
            str_replace(
                '\\',
                '/',
                (string) $doc->nombre_archivo
            )
        );

        if ($filename === '') {
            show_404();
        }

        /*
         * AWS: exclusivamente storagetalentsafe.
         *
         * storagetalentsafe/portales/{portal}/reclutamiento/
         * aspirantes/{requisicion_aspirante}/documentos/{archivo}
         */
        $file = talentsafe_aspirante_doc_resolve(
            $filename,
            (int) $doc->id_portal,
            (int) $doc->id_aspirante
        );

        if (
            $file === ''
            || ! is_file($file)
            || ! is_readable($file)
        ) {
            log_message(
                'error',
                sprintf(
                    'Documento aspirante no encontrado. doc_id=%d aspirante_id=%d portal=%d archivo=%s ruta=%s',
                    $id,
                    (int) $doc->id_aspirante,
                    (int) $doc->id_portal,
                    $filename,
                    $file
                )
            );

            show_404();
        }

        $mime = mime_content_type($file)
            ?: 'application/octet-stream';

        $this->output
            ->set_content_type($mime)
            ->set_header('X-Content-Type-Options: nosniff')
            ->set_header('Cache-Control: private, max-age=0, must-revalidate')
            ->set_output(file_get_contents($file));
    }
    public function actualizar()
    {
        $idDoc       = (int) $this->input->post('id_doc');
        $nuevoNombre = $this->input->post('nuevo_nombre', true) ?? '';
        $idUsuario   = (int) ($this->session->userdata('id') ?: 0);

        /*
         * Además de obtener el documento, valida que pertenezca
         * al portal actual.
         */
        $doc = $this->_documento_aspirante_context($idDoc);

        if (! $doc) {
            return $this->output_json(
                false,
                t(
                    'rec_prog_doc_err_not_found_simple',
                    'Documento no encontrado'
                )
            );
        }

        $nuevoArchivo = null;
        $nuevoPath    = '';

        /*
         * Si se reemplaza el archivo, toda escritura va únicamente
         * a storagetalentsafe.
         */
        if (! empty($_FILES['file']['name'])) {
            $uploadPath = talentsafe_aspirante_doc_upload_dir(
                (int) $doc->id_portal,
                (int) $doc->id_aspirante
            );

            if ($uploadPath === '') {
                log_message(
                    'error',
                    sprintf(
                        'No se pudo resolver upload_path de documento aspirante. doc_id=%d portal=%d aspirante_id=%d',
                        $idDoc,
                        (int) $doc->id_portal,
                        (int) $doc->id_aspirante
                    )
                );

                return $this->output_json(
                    false,
                    t(
                        'rec_prog_doc_err_upload_fail',
                        'No se pudo subir el archivo.'
                    )
                );
            }

            if (
                ! is_dir($uploadPath)
                && ! @mkdir($uploadPath, 0775, true)
                && ! is_dir($uploadPath)
            ) {
                log_message(
                    'error',
                    sprintf(
                        'No se pudo crear directorio de documento aspirante. doc_id=%d ruta=%s',
                        $idDoc,
                        $uploadPath
                    )
                );

                return $this->output_json(
                    false,
                    t(
                        'rec_prog_doc_err_upload_fail',
                        'No se pudo subir el archivo.'
                    )
                );
            }

            if (! is_writable($uploadPath)) {
                log_message(
                    'error',
                    sprintf(
                        'Directorio no escribible para documento aspirante. doc_id=%d ruta=%s',
                        $idDoc,
                        $uploadPath
                    )
                );

                return $this->output_json(
                    false,
                    t(
                        'rec_prog_doc_err_upload_fail',
                        'No se pudo subir el archivo.'
                    )
                );
            }

            $config = [
                'upload_path'   => $uploadPath,
                'allowed_types' => 'pdf|jpg|jpeg|png|gif|bmp|mp4|mov|avi|wmv|mkv|webm',
                'max_size'      => 25600,
                'encrypt_name'  => true,
            ];

            $this->load->library('upload', $config);

            if (! $this->upload->do_upload('file')) {
                $err = trim(
                    strip_tags(
                        $this->upload->display_errors()
                    )
                );

                $fallback = t(
                    'rec_prog_doc_err_upload_fail',
                    'No se pudo subir el archivo.'
                );

                return $this->output_json(
                    false,
                    $err !== '' ? $err : $fallback
                );
            }

            $nuevoArchivo = $this->upload->data();

            $nuevoPath = rtrim(
                str_replace('\\', '/', $uploadPath),
                '/'
            ) . '/' . $nuevoArchivo['file_name'];
        }

        $dataUpdate = [
            'nombre_personalizado' => $nuevoNombre !== ''
                ? $nuevoNombre
                : $doc->nombre_personalizado,
            'fecha_actualizacion' => date('Y-m-d H:i:s'),
            'id_usuario'          => $idUsuario,
        ];

        if ($nuevoArchivo) {
            $dataUpdate['nombre_archivo'] =
                $nuevoArchivo['file_name'];

            $dataUpdate['tipo'] = strtolower(
                pathinfo(
                    $nuevoArchivo['file_name'],
                    PATHINFO_EXTENSION
                )
            );
        }

        /*
         * Conservamos la ruta anterior antes del UPDATE.
         * En AWS el resolver solamente consulta storagetalentsafe.
         */
        $oldPath = '';

        if ($nuevoArchivo) {
            $oldPath = talentsafe_aspirante_doc_resolve(
                (string) $doc->nombre_archivo,
                (int) $doc->id_portal,
                (int) $doc->id_aspirante
            );
        }

        $updated = $this->db
            ->where('id', $idDoc)
            ->update(
                'documentos_aspirante',
                $dataUpdate
            );

        /*
         * Si falla BD, retiramos únicamente el archivo recién subido.
         * El anterior permanece intacto.
         */
        if (! $updated) {
            if (
                $nuevoPath !== ''
                && is_file($nuevoPath)
            ) {
                @unlink($nuevoPath);
            }

            log_message(
                'error',
                sprintf(
                    'Falló actualización de documento aspirante en BD. doc_id=%d',
                    $idDoc
                )
            );

            return $this->output_json(
                false,
                t(
                    'rec_prog_doc_err_upload_fail',
                    'No se pudo subir el archivo.'
                )
            );
        }

        /*
         * La BD ya apunta al nuevo archivo.
         * Ahora sí podemos retirar el anterior.
         */
        if (
            $nuevoArchivo
            && $oldPath !== ''
            && $oldPath !== $nuevoPath
            && is_file($oldPath)
        ) {
            if (! @unlink($oldPath)) {
                log_message(
                    'error',
                    sprintf(
                        'No se pudo eliminar archivo anterior de documento aspirante. doc_id=%d ruta=%s',
                        $idDoc,
                        $oldPath
                    )
                );
            }
        }

        return $this->output_json(
            true,
            t(
                'rec_prog_doc_ok_updated',
                'Documento actualizado'
            ),
            $nuevoArchivo ?: []
        );
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
            return $this->output_json(false, t('rec_prog_doc_err_no_id', 'ID no proporcionado'));
        }

        $doc = $this->db->get_where('documentos_aspirante', ['id' => $id, 'eliminado' => 0])->row();

        if (! $doc) {
            return $this->output_json(false, t('rec_prog_doc_err_not_found', 'Documento no encontrado o ya fue eliminado'));
        }

        // Soft delete: solo marcar como eliminado
        $this->db->where('id', $id)
            ->update('documentos_aspirante', [
                'eliminado'           => 1,
                'fecha_actualizacion' => date('Y-m-d H:i:s'),
                'id_usuario'          => $id_usuario,
            ]);

        return $this->output_json(true, t('rec_prog_doc_ok_deleted', 'Documento eliminado correctamente'));
    }

/**
 * Helper para responder JSON estándar
 */
    public function subir()
    {
        $this->output->set_content_type('application/json');

        /*
         * Compatibilidad con el frontend actual:
         *
         * Aunque existe un campo llamado id_bolsa, el valor que
         * realmente recibe este flujo es requisicion_aspirante.id.
         */
        $idRequisicionAspirante = (int) (
            $this->input->post('id_aspirante')
            ?: $this->input->post('id_bolsa')
        );

        $idUsuario = (int) (
            $this->session->userdata('id') ?: 0
        );

        if ($idRequisicionAspirante <= 0) {
            return $this->output_json(
                false,
                'ID de aspirante inválido'
            );
        }

        /*
         * Valida existencia y pertenencia al portal de la sesión.
         */
        $contexto = $this->_requisicion_aspirante_context(
            $idRequisicionAspirante
        );

        if (! $contexto) {
            return $this->output_json(
                false,
                'Aspirante no encontrado'
            );
        }

        /*
         * Ruta canónica AWS:
         *
         * storagetalentsafe/portales/{portal}/reclutamiento/
         * aspirantes/{requisicion_aspirante}/documentos/
         */
        $uploadPath = talentsafe_aspirante_doc_upload_dir(
            (int) $contexto->id_portal,
            $idRequisicionAspirante
        );

        if ($uploadPath === '') {
            log_message(
                'error',
                sprintf(
                    'No se pudo resolver upload_path de aspirante. ra_id=%d portal=%d',
                    $idRequisicionAspirante,
                    (int) $contexto->id_portal
                )
            );

            return $this->output_json(
                false,
                'No se pudo preparar la carpeta de documentos'
            );
        }

        if (
            ! is_dir($uploadPath)
            && ! @mkdir($uploadPath, 0775, true)
            && ! is_dir($uploadPath)
        ) {
            log_message(
                'error',
                sprintf(
                    'No se pudo crear directorio de aspirante. ra_id=%d ruta=%s',
                    $idRequisicionAspirante,
                    $uploadPath
                )
            );

            return $this->output_json(
                false,
                'No se pudo preparar la carpeta de documentos'
            );
        }

        if (! is_writable($uploadPath)) {
            log_message(
                'error',
                sprintf(
                    'Directorio no escribible para aspirante. ra_id=%d ruta=%s',
                    $idRequisicionAspirante,
                    $uploadPath
                )
            );

            return $this->output_json(
                false,
                'No se pudo preparar la carpeta de documentos'
            );
        }

        /*
         * nombres_archivos puede venir como arreglo,
         * string o JSON.
         */
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

        /*
         * Detectar el nombre utilizado por el input.
         */
        $filesKey = null;

        if (isset($_FILES['files'])) {
            $filesKey = 'files';
        } elseif (isset($_FILES['file'])) {
            $filesKey = 'file';
        } else {
            return $this->output_json(
                false,
                'No se recibieron archivos'
            );
        }

        /*
         * Normalizar un solo archivo a arreglo.
         */
        if (! is_array($_FILES[$filesKey]['name'])) {
            foreach (
                ['name', 'type', 'tmp_name', 'error', 'size']
                as $key
            ) {
                $_FILES[$filesKey][$key] = [
                    $_FILES[$filesKey][$key],
                ];
            }
        }

        $totalFiles = count(
            $_FILES[$filesKey]['name']
        );

        if ($totalFiles <= 0) {
            return $this->output_json(
                false,
                'No se recibieron archivos'
            );
        }

        if (
            count($nombres) === 1
            && $totalFiles > 1
        ) {
            $nombres = array_fill(
                0,
                $totalFiles,
                (string) $nombres[0]
            );
        }

        $baseConfig = [
            'upload_path'   => $uploadPath,
            'allowed_types' =>
                'pdf|jpg|jpeg|png|gif|bmp|mp4|mov|avi|wmv|mkv|webm',
            'max_size'      => 25600,
            'encrypt_name'  => true,
        ];

        $responses = [];

        for ($i = 0; $i < $totalFiles; $i++) {
            $_FILES['single_file'] = [
                'name'     => $_FILES[$filesKey]['name'][$i],
                'type'     => $_FILES[$filesKey]['type'][$i],
                'tmp_name' => $_FILES[$filesKey]['tmp_name'][$i],
                'error'    => $_FILES[$filesKey]['error'][$i],
                'size'     => $_FILES[$filesKey]['size'][$i],
            ];

            $libraryName = 'u' . $i;

            $this->load->library(
                'upload',
                $baseConfig,
                $libraryName
            );

            if (
                ! $this->{$libraryName}->do_upload(
                    'single_file'
                )
            ) {
                $raw = strip_tags(
                    $this->{$libraryName}->display_errors(
                        '',
                        ''
                    )
                );

                $msg = method_exists(
                    $this,
                    'traducir_error_upload'
                )
                    ? $this->traducir_error_upload(
                        $raw,
                        $baseConfig
                    )
                    : $raw;

                $responses[] = [
                    'success' => false,
                    'file'    =>
                        $_FILES['single_file']['name'],
                    'error'   => $msg,
                ];

                continue;
            }

            $data = $this->{$libraryName}->data();

            $nombrePersonal =
                isset($nombres[$i])
                && trim((string) $nombres[$i]) !== ''
                    ? trim((string) $nombres[$i])
                    : pathinfo(
                        $_FILES['single_file']['name'],
                        PATHINFO_FILENAME
                    );

            $inserted = $this->db->insert(
                'documentos_aspirante',
                [
                    'id_aspirante' =>
                        $idRequisicionAspirante,
                    'id_usuario' =>
                        $idUsuario,
                    'nombre_personalizado' =>
                        $nombrePersonal,
                    'nombre_archivo' =>
                        $data['file_name'],
                    'fecha_subida' =>
                        date('Y-m-d H:i:s'),
                    'fecha_actualizacion' =>
                        date('Y-m-d H:i:s'),
                    'eliminado' =>
                        0,
                ]
            );

            /*
             * Si no pudo registrarse en BD, retiramos el archivo
             * para no dejar huérfanos físicos.
             */
            if (! $inserted) {
                $uploadedFile = rtrim(
                    str_replace(
                        '\\',
                        '/',
                        $uploadPath
                    ),
                    '/'
                ) . '/' . $data['file_name'];

                if (is_file($uploadedFile)) {
                    @unlink($uploadedFile);
                }

                log_message(
                    'error',
                    sprintf(
                        'Falló insert documentos_aspirante. ra_id=%d archivo=%s',
                        $idRequisicionAspirante,
                        $data['file_name']
                    )
                );

                $responses[] = [
                    'success' => false,
                    'file' =>
                        $_FILES['single_file']['name'],
                    'error' =>
                        'No se pudo registrar el documento',
                ];

                continue;
            }

            $responses[] = [
                'success' => true,
                'file' =>
                    $_FILES['single_file']['name'],
                'stored' =>
                    $data['file_name'],
                'label' =>
                    $nombrePersonal,
            ];
        }

        unset($_FILES['single_file']);

        return $this->output_json(
            true,
            'Proceso terminado',
            $responses
        );
    }
    private function _requisicion_aspirante_context(int $idRequisicionAspirante)
    {
        if ($idRequisicionAspirante <= 0) {
            return null;
        }

        $row = $this->db
            ->select(
                'RA.*,
                 BT.id_portal AS bolsa_portal,
                 R.id_portal AS requisicion_portal'
            )
            ->from('requisicion_aspirante AS RA')
            ->join(
                'bolsa_trabajo AS BT',
                'BT.id = RA.id_bolsa_trabajo',
                'left'
            )
            ->join(
                'requisicion AS R',
                'R.id = RA.id_requisicion',
                'left'
            )
            ->where('RA.id', $idRequisicionAspirante)
            ->get()
            ->row();

        if (! $row) {
            return null;
        }

        $portalBolsa  = (int) ($row->bolsa_portal ?? 0);
        $portalReq    = (int) ($row->requisicion_portal ?? 0);
        $portalSesion = (int) ($this->session->userdata('idPortal') ?? 0);

        if (
            $portalBolsa > 0
            && $portalReq > 0
            && $portalBolsa !== $portalReq
        ) {
            log_message(
                'error',
                sprintf(
                    'Portal inconsistente en requisicion_aspirante. ra_id=%d bolsa_portal=%d requisicion_portal=%d',
                    $idRequisicionAspirante,
                    $portalBolsa,
                    $portalReq
                )
            );

            return null;
        }

        $idPortal = $portalBolsa > 0
            ? $portalBolsa
            : $portalReq;

        if ($idPortal <= 0) {
            return null;
        }

        if (
            $portalSesion <= 0
            || $portalSesion !== $idPortal
        ) {
            return null;
        }

        $row->id_portal = $idPortal;

        return $row;
    }
    private function _documento_aspirante_context(int $idDocumento)
    {
        if ($idDocumento <= 0) {
            return null;
        }

        $row = $this->db
            ->select(
                'DA.*,
                 RA.id_bolsa_trabajo,
                 RA.id_requisicion,
                 BT.id_portal AS bolsa_portal,
                 R.id_portal AS requisicion_portal'
            )
            ->from('documentos_aspirante AS DA')
            ->join(
                'requisicion_aspirante AS RA',
                'RA.id = DA.id_aspirante',
                'left'
            )
            ->join(
                'bolsa_trabajo AS BT',
                'BT.id = RA.id_bolsa_trabajo',
                'left'
            )
            ->join(
                'requisicion AS R',
                'R.id = RA.id_requisicion',
                'left'
            )
            ->where('DA.id', $idDocumento)
            ->where('DA.eliminado', 0)
            ->get()
            ->row();

        if (! $row) {
            return null;
        }

        $portalBolsa = (int) ($row->bolsa_portal ?? 0);
        $portalReq   = (int) ($row->requisicion_portal ?? 0);
        $portalSesion = (int) ($this->session->userdata('idPortal') ?? 0);

        /*
         * Las dos relaciones deberían conducir al mismo portal.
         */
        if (
            $portalBolsa > 0
            && $portalReq > 0
            && $portalBolsa !== $portalReq
        ) {
            log_message(
                'error',
                sprintf(
                    'Portal inconsistente en documento_aspirante. doc_id=%d bolsa_portal=%d requisicion_portal=%d',
                    $idDocumento,
                    $portalBolsa,
                    $portalReq
                )
            );

            return null;
        }

        $idPortal = $portalBolsa > 0
            ? $portalBolsa
            : $portalReq;

        /*
         * En AWS el documento debe tener portal resoluble.
         */
        if ($idPortal <= 0) {
            return null;
        }

        /*
         * Evita acceso cruzado entre portales.
         */
        if (
            $portalSesion <= 0
            || $portalSesion !== $idPortal
        ) {
            return null;
        }

        $row->id_portal = $idPortal;

        return $row;
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





