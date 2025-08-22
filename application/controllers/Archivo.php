<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Archivo extends CI_Controller
{
    public function serve()
    {
        $p = $this->input->get('p', true);
        $e = (int) $this->input->get('e');
        $d = $this->input->get('d', true) ?: 'inline';
        $n = $this->input->get('n', true);
        $s = $this->input->get('s', true);

        $relative = base64_decode($p ?? '', true);
        $name     = base64_decode($n ?? '', true);

        if (!$relative || !$name || !$s) {
            show_error('Parámetros inválidos', 400);
        }
        if (time() > $e) {
            show_error('Link expirado', 403);
        }

        $secret  = $this->config->item('download_secret');
        $payload = $relative.'|'.$e.'|'.$d.'|'.$name;
        $sigCalc = hash_hmac('sha256', $payload, $secret);

        if (!hash_equals($sigCalc, $s)) {
            show_error('Firma inválida', 403);
        }

        $root   = rtrim($this->config->item('storage_root'), '/');
        $full   = realpath($root . '/' . $relative);

        // Anti-traversal + existencia
        if (!$full || strncmp($full, $root, strlen($root)) !== 0 || !is_file($full)) {
            show_404();
        }

        $this->_stream_file($full, $name, $d === 'inline');
    }

    private function _stream_file(string $full, string $downloadName, bool $inline = true): void
    {
        // Mime
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $full) ?: 'application/octet-stream';
        finfo_close($finfo);

        // Disposición
        $disp = $inline ? 'inline' : 'attachment';
        $safe = rawurlencode($downloadName);
        $cd   = "{$disp}; filename=\"{$safe}\"; filename*=UTF-8''{$safe}";

        // Encabezados
        header('Content-Type: ' . $mime);
        header('Content-Disposition: ' . $cd);
        header('Content-Length: ' . filesize($full));
        header('X-Content-Type-Options: nosniff');

        // Si usas Apache mod_xsendfile o Nginx X-Accel-Redirect, activa uno:
        // header('X-Sendfile: ' . $full); return;
        // header('X-Accel-Redirect: /protected'. substr($full, strlen($this->config->item('storage_root')))); return;

        // Fallback: streaming PHP
        @set_time_limit(0);
        $fp = fopen($full, 'rb');
        while (!feof($fp)) {
            echo fread($fp, 8192);
            @ob_flush(); flush();
        }
        fclose($fp);
    }
}
