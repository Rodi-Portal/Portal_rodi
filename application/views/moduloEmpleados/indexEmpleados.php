<?php
$CI = &get_instance();

// Idioma actual
$lang = $CI->session->userdata('lang') ?: 'es';

// Versión de assets
if (ENVIRONMENT === 'development') {
    $assets_version = time();
} else {
    $assets_version = $CI->config->item('assets_version') ?: '1';
}

// Obtener todos los permisos activos reales del módulo Empleados
$CI->load->model('Permission_model');

$SLUGS = $CI->Permission_model->get_active_permission_keys(
    'empleados',
    true
);

$ALLOWED = [];

foreach ($SLUGS as $slug) {
    if (user_can($slug, false)) {
        $ALLOWED[] = $slug;
    }
}

/*
 * Todavía no existe una clave raíz module.empleados.ver.
 * Por ahora conservamos la regla de acceso general existente.
 * Los controles internos se resolverán mediante permisos exactos.
 */
$CAN_ACCESS_MODULE = ((int) $CI->session->userdata('idrol') !== 4);
?>

<!-- Permisos efectivos inyectados desde CI3 -->
<script>
window.APP_PERMS = <?php echo json_encode(
    $ALLOWED,
    JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
); ?>;

window.$perms = {
  set: new Set(window.APP_PERMS || []),

  can(p) {
    return typeof p === 'string' && p !== '' && this.set.has(p);
  },

  canAny(arr) {
    return Array.isArray(arr) && arr.some(p => this.set.has(p));
  },

  canAll(arr) {
    return Array.isArray(arr) && arr.every(p => this.set.has(p));
  }
};
</script>

<!-- Puente seguro CI3 -> token administrativo Laravel -->
<script>
window.AUTH_BRIDGE = {
  exchangeUrl: <?php echo json_encode(
      site_url('AuthBridge/exchange'),
      JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
  ); ?>
};
</script>

<!-- Assets de Vue -->
<link rel="stylesheet"
      href="<?php echo base_url('public/vue/css/cssEmpleados.css'); ?>?v=<?php echo $assets_version; ?>">

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>

<?php if (! $CAN_ACCESS_MODULE): ?>
  <div class="seccion" id="seccion1">
    <h3 style="text-align:center;font-size:2em;color:blue;">
      No tienes acceso a este módulo
    </h3>
  </div>
<?php else: ?>
  <div class="seccion" id="seccion1">
    <div id="app"
         data-your-value="<?php echo $this->session->userdata('idPortal'); ?>"
         data-your-user-value="<?php echo $this->session->userdata('id'); ?>"
         data-your-client-value="<?php echo $cliente_id; ?>"
         data-your-rol-value="<?php echo $this->session->userdata('idrol'); ?>"
         data-lang="<?php echo htmlspecialchars($lang, ENT_QUOTES, 'UTF-8'); ?>">
    </div>
  </div>
<?php endif; ?>

<script src="<?php echo base_url('public/vue/js/moduloEmpleados.js'); ?>?v=<?php echo $assets_version; ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('app') && window.mountVueApp) {
    window.mountVueApp('#app');
  }
});
</script>