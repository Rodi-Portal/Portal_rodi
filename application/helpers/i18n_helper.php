<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (! function_exists('t')) {
    function t($key, $fallback = '', $repl = [])
    {
        $CI =& get_instance();

        $line = $CI->lang->line($key);

        if ($line === FALSE || $line === '') {
            $line = ($fallback !== '') ? $fallback : $key;
        }

        if (is_array($repl) && !empty($repl)) {
            $line = strtr($line, $repl);
        }

        return $line;
    }
}

if (! function_exists('jsonOut')) {
    function jsonOut($data, $status = 200)
    {
        $CI =& get_instance();
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
        $CI =& get_instance();

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
  if (repl && typeof repl === 'object'){
    for (var k in repl){
      if (Object.prototype.hasOwnProperty.call(repl, k)){
        s = s.split(k).join(repl[k]);
      }
    }
  }
  return s;
};
</script>";
    }
}

