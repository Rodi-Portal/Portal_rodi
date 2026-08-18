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

// Obtener los permisos activos del módulo Exempleados
$CI->load->model('Permission_model');

$SLUGS = $CI->Permission_model->get_active_permission_keys(
    'exempleados',
    true
);

$ALLOWED = [];

foreach ($SLUGS as $slug) {
    if (user_can($slug, false)) {
        $ALLOWED[] = $slug;
    }
}

// Conservamos temporalmente la regla de acceso existente.
$CAN_ACCESS_MODULE = (
    (int) $CI->session->userdata('idrol') !== 4
);
?>

<!-- Permisos efectivos inyectados desde CI3 -->
<script>
window.APP_PERMS = <?php echo json_encode(
    $ALLOWED,
    JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
); ?>;

window.$perms = {
  set: new Set(window.APP_PERMS || []),

  can(permission) {
    return (
      typeof permission === 'string' &&
      permission !== '' &&
      this.set.has(permission)
    );
  },

  canAny(permissions) {
    return (
      Array.isArray(permissions) &&
      permissions.some(permission => this.set.has(permission))
    );
  },

  canAll(permissions) {
    return (
      Array.isArray(permissions) &&
      permissions.every(permission => this.set.has(permission))
    );
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

<!-- Assets del módulo Vue -->
<link
  rel="stylesheet"
  href="<?php echo base_url(
      'public/former/css/cssFormer.css'
  ); ?>?v=<?php echo $assets_version; ?>"
>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>

<?php if (! $CAN_ACCESS_MODULE): ?>

  <div class="seccion" id="seccion1">
    <h3 style="text-align:center;font-size:2em;color:blue;">
      No tienes acceso a este módulo
    </h3>
  </div>

<?php else: ?>

  <div class="seccion" id="seccion1">
    <div
      id="app"
      data-your-value="<?php echo $this->session->userdata('idPortal'); ?>"
      data-your-user-value="<?php echo $this->session->userdata('id'); ?>"
      data-your-rol-value="<?php echo $this->session->userdata('idrol'); ?>"
      data-your-client-value="<?php echo $cliente_id; ?>"
      data-lang="<?php echo htmlspecialchars(
          $lang,
          ENT_QUOTES,
          'UTF-8'
      ); ?>"
    >
    </div>
  </div>

<?php endif; ?>

<script
  src="<?php echo base_url(
      'public/former/js/moduloFormer.js'
  ); ?>?v=<?php echo $assets_version; ?>"
></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('app') && window.mountVueApp) {
    window.mountVueApp('#app');
  }
});
</script>