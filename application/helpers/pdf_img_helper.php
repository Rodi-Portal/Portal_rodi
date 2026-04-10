<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Convierte en el HTML todas las referencias a /_docs/ y /img/ (src=..., url(...))
 * a rutas ABSOLUTAS del sistema de archivos usando FCPATH.
 * No depende de HTTP ni cookies y funciona con mPDF.
 */
if (! function_exists('mpdf_localize_assets')) {
    function mpdf_localize_assets(string $html): string
    {
        // Asegura helper url
        if (! function_exists('base_url')) {
            $CI = &get_instance();
            $CI->load->helper('url');
        }

        $host = parse_url(base_url(), PHP_URL_HOST); // p.ej. rodicontrol.rodi.com.mx

        // Prefijos que pueden venir en el HTML
        $prefixes = [
            // _docs
            base_url() . '_docs/',
            site_url() . '_docs/',
            'https://' . $host . '/_docs/',
            'http://' . $host . '/_docs/',
            '/_docs/',
            // img
            base_url() . 'img/',
            site_url() . 'img/',
            'https://' . $host . '/img/',
            'http://' . $host . '/img/',
            '/img/',
            base_url() . '_adjuntos/', site_url() . '_adjuntos/', 'https://' . $host . '/_adjuntos/', 'http://' . $host . '/_adjuntos/', '/_adjuntos/',

            base_url() . '_psicometria/',
            site_url() . '_psicometria/',
            'https://' . $host . '/_psicometria/',
            'http://' . $host . '/_psicometria/',
            '/_psicometria/',
        ];

        // Reemplazo simple cuando el valor empieza exactamente por uno de los prefijos (src/href directos)
        $map = [
            base_url() . '_docs/'                 => FCPATH . '_docs/',
            site_url() . '_docs/'                 => FCPATH . '_docs/',
            'https://' . $host . '/_docs/'        => FCPATH . '_docs/',
            'http://' . $host . '/_docs/'         => FCPATH . '_docs/',
            '/_docs/'                             => FCPATH . '_docs/',

            base_url() . 'img/'                   => FCPATH . 'img/',
            site_url() . 'img/'                   => FCPATH . 'img/',
            'https://' . $host . '/img/'          => FCPATH . 'img/',
            'http://' . $host . '/img/'           => FCPATH . 'img/',
            '/img/'                               => FCPATH . 'img/',
            base_url() . '_adjuntos/'             => FCPATH . '_adjuntos/',
            site_url() . '_adjuntos/'             => FCPATH . '_adjuntos/',
            'https://' . $host . '/_adjuntos/'    => FCPATH . '_adjuntos/',
            'http://' . $host . '/_adjuntos/'     => FCPATH . '_adjuntos/',
            '/_adjuntos/'                         => FCPATH . '_adjuntos/',

            base_url() . '_psicometria/'          => FCPATH . '_psicometria/',
            site_url() . '_psicometria/'          => FCPATH . '_psicometria/',
            'https://' . $host . '/_psicometria/' => FCPATH . '_psicometria/',
            'http://' . $host . '/_psicometria/'  => FCPATH . '_psicometria/',
            '/_psicometria/'                      => FCPATH . '_psicometria/',

        ];
        $html = strtr($html, $map);

        // 2) También convertir url(...) en CSS inline o estilos (<style>)
        //   - Captura url("..."), url('...') y url(...)
        $html = preg_replace_callback(
            '#url\((["\']?)(/(?:_docs|img|_adjuntos|_psicometria)/[^)\'"]+)\1\)#i',
            function ($m) {
                $rel = $m[2];
                if (
                    stripos($rel, '/_docs/') === 0 ||
                    stripos($rel, '/_adjuntos/') === 0 ||
                    stripos($rel, '/img/') === 0 ||
                    stripos($rel, '/_psicometria/') === 0// ← NUEVO
                ) {
                    $path = FCPATH . ltrim($rel, '/');
                    return 'url(' . $m[1] . $path . $m[1] . ')';
                }
                return $m[0];
            },
            $html
        );

        // 3) Opcional: valida que existan los archivos; si no existen, deja el original
        // (más costoso; habilítalo si lo necesitas)
        /*
        $html = preg_replace_callback(
            '#(<img[^>]+src=["\'])([^"\']+)(["\'])#i',
            function($m) {
                $prefix = $m[1]; $src = $m[2]; $suf = $m[3];
                // Solo tocar si ahora apunta a FCPATH
                if (stripos($src, FCPATH) === 0 && !is_file($src)) return $m[0];
                return $prefix.$src.$suf;
            },
            $html
        );
        */

        return $html;
    }
}

/** Elige la primera ruta física existente a partir de candidatos (útil para logos en header/footer) */
if (! function_exists('mpdf_pick_path')) {
    function mpdf_pick_path(array $candidates)
    {
        foreach ($candidates as $p) {
            $rp = @realpath($p);
            if ($rp && is_file($rp) && is_readable($rp)) {
                return $rp;
            }

        }
        return null;
    }
}

function pick_path(array $candidates)
{
    foreach ($candidates as $p) {
        $rp = @realpath($p);
        if ($rp && is_file($rp) && is_readable($rp)) {
            return $rp;
        }

    }
    return null;
}
// Convierte una ruta relativa del proyecto a ruta física (o null)
function rel_to_fs($rel)
{
    $rel = ltrim($rel, '/');
    $rp  = @realpath(FCPATH . $rel);
    return ($rp && is_file($rp)) ? $rp : null;
}
