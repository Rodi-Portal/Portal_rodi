<?php defined('BASEPATH') or exit('No direct script access allowed');

if (! function_exists('t')) {
    function t($key, $fallback = '', $repl = [])
    {
        $CI = &get_instance();

        $line = $CI->lang->line($key);

        if ($line === false || $line === '' || $line === null) {
            $line = ($fallback !== '') ? $fallback : (string) $key;
        }

        // ✅ REEMPLAZA SOLO TOKENS {clave} (evita reemplazar letras sueltas como "n")
        if (is_array($repl) && ! empty($repl)) {
            $line = (string) $line; // 🛡️ PHP 8.1 safe
            $map  = [];
            foreach ($repl as $k => $v) {
                $k = (string) $k;

                if (strlen($k) >= 2 && $k[0] === '{' && substr($k, -1) === '}') {
                    $map[$k] = (string) $v;
                } else {
                    $map['{' . $k . '}'] = (string) $v;
                }
            }

            $line = strtr($line, $map);
        }

        return $line;
    }
}

if (! function_exists('jsonOut')) {
    function jsonOut($data, $status = 200)
    {
        $CI = &get_instance();
        $CI->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }
}

if (! function_exists('i18n_js')) {
    /**
     * Imprime un <script> que expone los strings cargados en CI3 a JS.
     * Opcional: filtrar por prefijos para no mandar TODO.
     */
    function i18n_js(array $prefixes = ['rec_'])
    {
        $CI = &get_instance();

        $dict = isset($CI->lang->language) && is_array($CI->lang->language)
            ? $CI->lang->language
            : [];

        // Filtrar por prefijos (para reducir tamaño)
        if (! empty($prefixes)) {
            $filtered = [];
            foreach ($dict as $k => $v) {
                foreach ($prefixes as $p) {
                    if (strpos($k, $p) === 0) {
                        $filtered[$k] = $v;
                        break;
                    }
                }
            }
            $dict = $filtered;
        }

        $json = json_encode($dict, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        echo "<script>
window._i18n = window._i18n || {};
Object.assign(window._i18n, {$json});

window.t = window.t || function(key, fallback, repl){
  var s = (window._i18n && window._i18n[key] !== undefined) ? window._i18n[key] : (fallback || key);

  // ✅ Reemplaza SOLO {clave} (evita que 'n' rompa palabras)
  if (repl && typeof repl === 'object'){
    for (var k in repl){
      if (Object.prototype.hasOwnProperty.call(repl, k)){
        var token = (k && k[0] === '{' && k[k.length-1] === '}') ? k : '{' + k + '}';
        s = s.split(token).join(String(repl[k]));
      }
    }
  }
  return s;
};

// ✅ Alias para tu error: _t is not defined
window._t = window._t || window.t;
</script>";
    }
}