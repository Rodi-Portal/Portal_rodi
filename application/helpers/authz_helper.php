<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * user_can($permKey, $legacy = null)
 * - Prioriza override por usuario (auth_user_permission).
 * - Si NO hay override => usa $legacy:
 *     * bool  : true/false de tu lógica actual por roles/submenus.
 *     * callable: se invoca y debe retornar bool (para controladores).
 */
if (!function_exists('user_can')) {
function user_can(string $permKey, $legacy = null): bool {
  $CI  =& get_instance();
  $uid = (int) ($CI->session->userdata('id') ?? 0);
  static $cache = [];

  $ck = $uid.'|'.$permKey;
  if (array_key_exists($ck, $cache)) return $cache[$ck];

  $idRol = (int) ($CI->session->userdata('idrol') ?? 0);

  // 1) Primero: si hay override explícito (ALLOW/DENY) lo respetamos para TODOS (incluye roles 1 y 6)
  $row = $CI->db->select('effect')
                ->from('auth_user_permission')
                ->where([
                  'user_id'        => $uid,
                  'permission_key' => $permKey,
                  'scope_type'     => 'global',
                  'scope_value'    => null,
                ])->limit(1)->get()->row_array();

  if (isset($row['effect'])) {
    return $cache[$ck] = ($row['effect'] === 'allow');
  }

  // 2) Si NO hay override y es rol 1/6: ALLOW por defecto (seguros),
  //    pero ya viste que un DENY explícito arriba sí los puede “cerrar”.
  if (in_array($idRol, [1,6], true)) {
    return $cache[$ck] = true;
  }

  // 3) Resto: hereda a la lógica legacy que ya tienes
  if (is_bool($legacy))     return $cache[$ck] = $legacy;
  if (is_callable($legacy)) return $cache[$ck] = (bool) call_user_func($legacy);

  // 4) Por defecto: deny
  return $cache[$ck] = false;
}

}

/**
 * require_perm($permKey, $legacy = null, $ajax = false)
 * - Úsalo en controladores para bloquear acciones.
 */
if (!function_exists('require_perm')) {
  function require_perm(string $permKey, $legacy = null, bool $ajax = false): void {
    $ok = user_can($permKey, $legacy);
    if ($ok) return;

    $CI =& get_instance();
    if ($ajax) {
      $CI->output->set_status_header(403)
         ->set_content_type('application/json','utf-8')
         ->set_output(json_encode(['ok'=>false,'msg'=>'No autorizado']));
      exit;
    }
    show_error('No autorizado', 403);
  }
}
