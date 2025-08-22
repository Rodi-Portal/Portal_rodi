<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('secure_file_url')) {
    /**
     * Genera una URL firmada y con expiración para servir un archivo físico.
     * @param string $relative Ruta relativa dentro de storage_root (ej: 'requisiciones/11/docs/cv.pdf')
     * @param string|null $download_name Nombre sugerido al navegador (opcional)
     * @param string $disposition 'inline' o 'attachment'
     * @param int $ttl Segundos de validez del link (por defecto 10 min)
     */
    function secure_file_url(string $relative, ?string $download_name = null, string $disposition='inline', int $ttl=600): string
    {
        $CI =& get_instance();
        $exp  = time() + $ttl;
        $name = $download_name ?? basename($relative);

        // Payload para la firma
        $payload = $relative.'|'.$exp.'|'.$disposition.'|'.$name;
        $sig = hash_hmac('sha256', $payload, $CI->config->item('download_secret'));

        // Empaquetamos parámetros (base64 para soportar UTF-8)
        $p = rawurlencode(base64_encode($relative));
        $n = rawurlencode(base64_encode($name));
        $d = rawurlencode($disposition);

        return site_url("archivo/serve?p={$p}&e={$exp}&d={$d}&n={$n}&s={$sig}");
    }
}
