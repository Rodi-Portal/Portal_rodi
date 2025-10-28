<?php defined('BASEPATH') or exit('No direct script access allowed');

class Archivo extends CI_Controller
{
    private $base_path;

    public function __construct()
    {
        parent::__construct();
        // carpeta física al nivel de application/public (raíz del proyecto)
        $this->base_path = rtrim(FCPATH, '/') . '/_documentEmpleado/';

        // crea la carpeta si no existe (opcional)
        if (! is_dir($this->base_path)) {
            @mkdir($this->base_path, 0750, true);
        }
    }

    public function ver_doc($filename = '')
    {
        // 1) Debe haber sesión
        if (! $this->session->userdata('id')) {
            show_404(); // o redirect('login');
        }

        // 2) Normaliza nombre (sin subcarpetas)
        $filename = urldecode((string) $filename);
        $filename = basename($filename); // evita traversal y separadores

        if ($filename === '') {
            show_404();
        }

        // 3) Opcional: whitelist de extensiones
        $ext     = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'png', 'jpg', 'jpeg', 'gif', 'txt', 'csv'];
        if (! in_array($ext, $allowed, true)) {
            show_404();
        }

        // 4) Resuelve y valida
        $full = $this->base_path . $filename;
        if (! is_file($full) || ! is_readable($full)) {
            show_404();
        }

        // 5) Cabeceras
        $mime        = $this->_detect_mime($full, $ext);
        $disposition = $this->input->get('dl') ? 'attachment' : 'inline'; // agrega ?dl=1 para forzar descarga
        $safe        = rawurlencode($filename);

        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($full));
        header('Content-Disposition: ' . $disposition . '; filename="' . $safe . '"; filename*=UTF-8\'\'' . $safe);
        header('X-Content-Type-Options: nosniff');

        // 6) Stream
        @set_time_limit(0);
        $fp = fopen($full, 'rb');
        while (! feof($fp)) {
            echo fread($fp, 8192);
            @ob_flush();
            flush();
        }
        fclose($fp);
        exit;
    }

    public function ver_exam($filename = '')
    {
        if (! $this->session->userdata('id')) {show_404();}

        $filename = urldecode((string) $filename);
        $filename = basename($filename);
        if ($filename === '') {show_404();}

        $ext     = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'png', 'jpg', 'jpeg', 'gif', 'txt', 'csv'];
        if (! in_array($ext, $allowed, true)) {show_404();}

        // Carpeta física específica para exámenes
        $base_path_exams = rtrim(FCPATH, '/') . '/_examEmpleado/';
        if (! is_dir($base_path_exams)) {@mkdir($base_path_exams, 0750, true);}

        $full = $base_path_exams . $filename;
        if (! is_file($full) || ! is_readable($full)) {show_404();}

        $mime        = $this->_detect_mime($full, $ext);
        $disposition = $this->input->get('dl') ? 'attachment' : 'inline';
        $safe        = rawurlencode($filename);

        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($full));
        header('Content-Disposition: ' . $disposition . '; filename="' . $safe . '"; filename*=UTF-8\'\'' . $safe);
        header('X-Content-Type-Options: nosniff');

        @set_time_limit(0);
        $fp = fopen($full, 'rb');
        while (! feof($fp)) {echo fread($fp, 8192);@ob_flush();
            flush();}
        fclose($fp);
        exit;
    }

    public function ver_docs_bolsa($filename = '')
    {
        if (! $this->session->userdata('id')) {show_404();}

        $filename = urldecode((string) $filename);
        $filename = basename($filename);
        if ($filename === '') {show_404();}

        $ext     = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'png', 'jpg', 'jpeg', 'gif', 'txt', 'csv'];
        if (! in_array($ext, $allowed, true)) {show_404();}

        // Carpeta física específica para exámenes
        $base_path_exams = rtrim(FCPATH, '/') . '/_documentosBolsa/';
        if (! is_dir($base_path_exams)) {@mkdir($base_path_exams, 0750, true);}

        $full = $base_path_exams . $filename;
        if (! is_file($full) || ! is_readable($full)) {show_404();}

        $mime        = $this->_detect_mime($full, $ext);
        $disposition = $this->input->get('dl') ? 'attachment' : 'inline';
        $safe        = rawurlencode($filename);

        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($full));
        header('Content-Disposition: ' . $disposition . '; filename="' . $safe . '"; filename*=UTF-8\'\'' . $safe);
        header('X-Content-Type-Options: nosniff');

        @set_time_limit(0);
        $fp = fopen($full, 'rb');
        while (! feof($fp)) {echo fread($fp, 8192);@ob_flush();
            flush();}
        fclose($fp);
        exit;
    }
    public function ver_portal_doc($tipo = '')
    {
        if (! $this->session->userdata('id')) {show_404();}

        $id_portal = (int) $this->session->userdata('idPortal');
        if (empty($id_portal)) {show_404();}

        $tipo = strtolower(trim((string) $tipo));
        if (! in_array($tipo, ['aviso', 'terminos', 'confidencialidad'], true)) {show_404();}

        // === Ambos en _avisosPortal/ porque ahí tienes los defaults ===
        $upload_dir   = rtrim(FCPATH, '/\\') . '/_avisosPortal/';
        $defaults_dir = $upload_dir;

        if (! is_dir($upload_dir)) {@mkdir($upload_dir, 0775, true);}
        if (! is_dir($defaults_dir)) {@mkdir($defaults_dir, 0775, true);}

        $map = [
            'aviso'            => ['db' => 'aviso', 'def' => 'AV_TL_V1.pdf'],
            'terminos'         => ['db' => 'terminos', 'def' => 'TM_TL_V1.pdf'],
            'confidencialidad' => ['db' => 'confidencialidad', 'def' => 'AC_TL_V1.docx'],
        ];

        // Trae nombre guardado en DB (p.ej. "23_avisoPrivacidad.pdf")
        $row    = $this->cat_portales_model->getDocs($id_portal);
        $nombre = $row ? ($row->{$map[$tipo]['db']} ?? null) : null;

        // Si hay archivo propio y existe físicamente -> úsalo; si no -> usa el default en la MISMA carpeta
        if ($nombre && is_file($upload_dir . $nombre)) {
            $fileAbs = $upload_dir . $nombre;
        } else {
            $fileAbs = $defaults_dir . $map[$tipo]['def'];
        }

        // Si tampoco existe el default, 404
        if (! is_file($fileAbs) || ! is_readable($fileAbs)) {show_404();}

        $ext  = strtolower(pathinfo($fileAbs, PATHINFO_EXTENSION));
        $mime = $this->_detect_mime($fileAbs, $ext);

        $forceDownload = (bool) $this->input->get('dl');
        $disp          = $forceDownload ? 'attachment' : 'inline';

        $downloadName = basename($fileAbs);
        $ascii        = preg_replace('/[^A-Za-z0-9\._-]+/', '_', $downloadName);

        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($fileAbs));
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header("Content-Disposition: $disp; filename=\"{$ascii}\"; filename*=UTF-8''" . rawurlencode($downloadName));

        @readfile($fileAbs);
        exit;
    }

    public function ver_aspirante($id)
    {
        $this->_serve_doc_aspirante((int) $id, false); // inline si tipo_vista==1
    }

    public function descargar_aspirante($id)
    {
        $this->_serve_doc_aspirante((int) $id, true); // fuerza descarga
    }

    private function _serve_doc_aspirante(int $id, bool $forceDownload)
    {
        if ($id <= 0) {show_404();}

        // 1) Sesión obligatoria (ajusta a tu lógica)
        if (! $this->session->userdata('id')) {show_404();}

                                 // 2) Registro en BD
        $this->load->database(); // por si no está autoload
        $doc = $this->db->get_where('documentos_aspirante', [
            'id'        => $id,
            'eliminado' => 0,
        ])->row();
        if (! $doc) {show_404();}

                                                             // 3) Ruta física correcta (carpeta + nombre)
        $filename = basename((string) $doc->nombre_archivo); // sanitiza
        $baseDir  = rtrim(FCPATH, '/\\') . '/_docs/';        // tu carpeta objetivo
        $fileAbs  = $baseDir . $filename;                    // <- ¡aquí faltaba el $filename!

        if (! is_file($fileAbs) || ! is_readable($fileAbs)) {
            log_message('error', "Archivo no encontrado o no legible: {$fileAbs} (doc_id={$id})");
            show_404();
        }

        // 4) MIME, nombre y disposición
        $ext  = strtolower(pathinfo($fileAbs, PATHINFO_EXTENSION));
        $mime = $this->_detect_mime($fileAbs, $ext);

        // Inline si tipo_vista == 1 y no se fuerza descarga (default inline si no existe la col)
        $inline = (! $forceDownload && (isset($doc->tipo_vista) ? (int) $doc->tipo_vista === 1 : true));

        // Nombre “bonito” de salida
        $downloadName = $this->_nice_name($doc->nombre_personalizado ?: 'documento', $ext);
        $ascii        = preg_replace('/[^A-Za-z0-9\._-]+/', '_', $downloadName);

        // 5) Cabeceras y stream
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . filesize($fileAbs));
        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: private, max-age=0, must-revalidate');

        $disp = $inline ? 'inline' : 'attachment';
        header("Content-Disposition: $disp; filename=\"{$ascii}\"; filename*=UTF-8''" . rawurlencode($downloadName));

        @readfile($fileAbs);
        exit;
    }

    public function ver_calendario_id($id)
    {
        $this->_serve_doc_calendario((int) $id, false); // inline (para ver)
    }

    public function descargar_calendario($id)
    {
        $this->_serve_doc_calendario((int) $id, true); // attachment (para descargar)
    }

    private function _serve_doc_calendario(int $id, bool $forceDownload)
    {
        if ($id <= 0) {show_404();}
        if (! $this->session->userdata('id')) {show_404();}

        $this->load->database();
        // Solo pedimos la columna que SÍ existe
        $doc = $this->db->select('archivo')
            ->get_where('calendario_eventos', ['id' => $id, 'eliminado' => 0])
            ->row();
        if (! $doc) {show_404();}

        $filename = basename((string) $doc->archivo);
        $baseDir  = rtrim(FCPATH, '/\\') . '/_archivo_calendario/';
        $fileAbs  = $baseDir . $filename;

        clearstatcache(true, $fileAbs);
        if (! is_file($fileAbs) || ! is_readable($fileAbs)) {show_404();}

        $size = filesize($fileAbs);
        if ($size === 0) {show_404();}

        // Limpia cualquier salida previa para no corromper binarios
        while (ob_get_level()) {@ob_end_clean();}
        @ini_set('zlib.output_compression', 'Off');

        $ext  = strtolower(pathinfo($fileAbs, PATHINFO_EXTENSION));
        $mime = $this->_detect_mime($fileAbs, $ext) ?: 'application/octet-stream';

        // (Opcional) en dev, si embebes en iframe desde Vite 5173:
        // header_remove('X-Frame-Options');
        // header("Content-Security-Policy: frame-ancestors 'self' http://localhost:5173 http://127.0.0.1:5173");

        header('X-Content-Type-Options: nosniff');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');

        // ✅ usa el mismo filename como nombre de descarga
        $downloadName = $filename;
        $ascii        = preg_replace('/[^A-Za-z0-9\._-]+/', '_', $downloadName);

        header('Content-Type: ' . $mime);
        header('Content-Length: ' . $size);
        $disp = $forceDownload ? 'attachment' : 'inline';
        header("Content-Disposition: $disp; filename=\"{$ascii}\"; filename*=UTF-8''" . rawurlencode($downloadName));

        $fp = fopen($fileAbs, 'rb');if (! $fp) {show_404();}
        @set_time_limit(0);
        fpassthru($fp);
        fclose($fp);
        exit;
    }

    private function _nice_name(string $base, string $ext): string
    {
        $s = @iconv('UTF-8', 'ASCII//TRANSLIT', $base);
        $s = strtolower(trim(preg_replace('/[^a-z0-9\._-]+/i', '_', $s), '_'));
        return $s . ($ext ? '.' . $ext : '');
    }

    private function _detect_mime($path, $ext)
    {
        if (function_exists('finfo_open')) {
            $f = finfo_open(FILEINFO_MIME_TYPE);
            if ($f) {
                $m = finfo_file($f, $path);
                finfo_close($f);
                if ($m) {
                    return $m;
                }

            }
        }
        $map = [
            'pdf'  => 'application/pdf', 'doc'   => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls'  => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'png'  => 'image/png', 'jpg'         => 'image/jpeg', 'jpeg'     => 'image/jpeg', 'gif'      => 'image/gif', 'bmp' => 'image/bmp',
            'txt'  => 'text/plain', 'csv'        => 'text/csv',
            'mp4'  => 'video/mp4', 'mov'         => 'video/quicktime', 'avi' => 'video/x-msvideo', 'wmv' => 'video/x-ms-wmv',
            'mkv'  => 'video/x-matroska', 'webm' => 'video/webm',
        ];
        return $map[$ext] ?? 'application/octet-stream';
    }

public function ver_psicometrico($filename = '')
{
    // 1️⃣ Verificar sesión
    if (! $this->session->userdata('id')) {
        show_404();
    }

    // 2️⃣ Sanitizar nombre
    $filename = basename(urldecode((string) $filename));
    if ($filename === '') {
        show_404();
    }

    // 3️⃣ Validar extensión
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allowed = ['pdf','doc','docx','ppt','pptx','xls','xlsx','png','jpg','jpeg'];
    if (! in_array($ext, $allowed, true)) {
        show_404();
    }

    // 4️⃣ Ruta física segura
    $base_path_psico = rtrim(FCPATH, '/') . '/_psicometria/';
    $full = $base_path_psico . $filename;

    if (! is_file($full) || ! is_readable($full)) {
        log_message('error', "Archivo psicométrico no encontrado: {$full}");
        show_404();
    }

    // 🔒 5️⃣ Limpia todo buffer previo y evita compresión
    while (ob_get_level()) { @ob_end_clean(); }
    @ini_set('zlib.output_compression', 'Off');

    // 6️⃣ Detectar MIME
    $mime = $this->_detect_mime($full, $ext);
    $disposition = $this->input->get('dl') ? 'attachment' : 'inline';
    $safe = rawurlencode($filename);

    // 7️⃣ Enviar headers limpios
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($full));
    header('Content-Disposition: ' . $disposition . '; filename="' . $safe . '"; filename*=UTF-8\'\'' . $safe);
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: private, no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: no-cache');

    // 8️⃣ Leer el archivo directamente y terminar
    $handle = fopen($full, 'rb');
    if ($handle) {
        fpassthru($handle);
        fclose($handle);
    }
    exit;
}


}
