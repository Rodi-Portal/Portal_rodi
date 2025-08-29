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
        // fallback por extensión
        $map = [
            'pdf'  => 'application/pdf', 'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls'  => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'png'  => 'image/png', 'jpg'       => 'image/jpeg', 'jpeg' => 'image/jpeg', 'gif' => 'image/gif',
            'txt'  => 'text/plain', 'csv'      => 'text/csv',
        ];
        return $map[$ext] ?? 'application/octet-stream';
    }
}
