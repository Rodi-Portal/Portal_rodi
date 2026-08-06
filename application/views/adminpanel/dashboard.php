<?php
$CI = &get_instance();

$lang = $CI->session->userdata('lang') ?: 'es';

if (ENVIRONMENT === 'development') {
    $assets_version = time();
} else {
    $assets_version = $CI->config->item('assets_version') ?: '1';
}

// Clientes asignados por el controlador
$cliente_id = $cliente_id ?? [];

// Permisos activos reales del módulo Dashboards
$CI->load->model('Permission_model');

$SLUGS = $CI->Permission_model->get_active_permission_keys(
    'dashboards',
    true
);

$ALLOWED = [];

foreach ($SLUGS as $slug) {
    if (user_can($slug, false)) {
        $ALLOWED[] = $slug;
    }
}

$CAN_ACCESS_MODULE = in_array(
    'module.dashboards.ver',
    $ALLOWED,
    true
);
?>
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

window.AUTH_BRIDGE = {
  exchangeUrl: <?php echo json_encode(
      site_url('AuthBridge/exchange'),
      JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
  ); ?>
};
</script>
<link rel="stylesheet" href="<?= base_url('public/dashboard/dashboard.css'); ?>?v=<?= $assets_version; ?>">

<?php if (! $CAN_ACCESS_MODULE) { ?>

<div class="seccion" id="seccion1">

  <div style="
    max-width: 640px;
    margin: 48px auto;
    padding: 28px;
    border-radius: 14px;
    background: #f9fafc;
    border: 1px solid #e1e4ea;
    text-align: center;
  ">
    <h3 style="font-size:1.7em;color:#2c3e50;margin-bottom:14px;">
      <?= $this->lang->line('dashboard_no_access_title'); ?>
    </h3>

    <p style="font-size:1.1em;color:#5f6368; line-height:1.6;">
      <?= $this->lang->line('dashboard_no_access_msg'); ?>
    </p>
  </div>
</div>


<?php } else { ?>

<div class="seccion" id="seccion1">
  <div id="dashApp" data-your-value="<?= (int)$this->session->userdata('idPortal'); ?>"
    data-your-user-value="<?= (int)$this->session->userdata('id'); ?>"
    data-your-rol-value="<?= (int)$this->session->userdata('idrol'); ?>"
    data-your-client-value='<?= json_encode($cliente_id); ?>' data-lang="<?= htmlspecialchars($lang, ENT_QUOTES); ?>">
  </div>
</div>

<?php } ?>

<script src="<?= base_url('public/dashboard/dashboard.js'); ?>?v=<?= $assets_version; ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('dashApp');
  if (el && window.mountDashboardApp) {
    window.mountDashboardApp('#dashApp');
  }
});
</script>

<style>
/* 👇 Opcional, solo por si quieres un poquito de aire alrededor */
#dashApp {
  padding-bottom: 24px;
}
</style>