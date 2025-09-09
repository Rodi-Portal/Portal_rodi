<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * show_if_can($permKey, $legacyBool): bool
 * - Para usarlo en if de las VISTAS (sidebar, menús, botones).
 */
if (!function_exists('show_if_can')) {
  function show_if_can(string $permKey, bool $legacyBool): bool {
    return user_can($permKey, $legacyBool);
  }
}

/**
 * perms_js_flags($map): string
 * - Genera flags JS (window.PERM.* = true/false) para DataTables/botones.
 * - $map = ['nombreFlagJS' => ['permKey', legacyBool], ...]
 */
if (!function_exists('perms_js_flags')) {
  function perms_js_flags(array $map): string {
    $flags = [];
    foreach ($map as $jsName => $pair) {
      [$permKey, $legacyBool] = $pair;
      $flags[$jsName] = user_can($permKey, (bool)$legacyBool);
    }
    return '<script>window.PERM='.json_encode($flags, JSON_UNESCAPED_UNICODE).';</script>';
  }
}
