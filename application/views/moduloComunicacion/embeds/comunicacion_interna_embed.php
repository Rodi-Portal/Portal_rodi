<?php
    $CI = &get_instance();

    $lang = $CI->session->userdata('lang') ?: 'es';

    if (ENVIRONMENT === 'development') {
    $assets_version = time();
    } else {
    $assets_version = $CI->config->item('assets_version') ?: '1';
    }

    $CI->load->model('Permission_model');

    $SLUGS = $CI->Permission_model->get_active_permission_keys(
    'comunicacion',
    true
    );

    $ALLOWED = [];

    foreach ($SLUGS as $slug) {
    if (user_can($slug, false)) {
        $ALLOWED[] = $slug;
    }
    }

    $CAN_ACCESS_MODULE = in_array(
    'module.comunicacion.ver',
    $ALLOWED,
    true
    );
?>

<link rel="stylesheet" href="<?php echo base_url('public/comunicacion/comunicacion_vue3.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/vue@3"></script>

<script>
window.APP_PERMS = <?php echo json_encode($ALLOWED) ?>;
window.$perms = {
  set: new Set(window.APP_PERMS || []),
  can(p) {
    return this.set.has(p);
  },
  canAny(arr) {
    return arr.some(p => this.set.has(p));
  },
  canAll(arr) {
    return arr.every(p => this.set.has(p));
  }
};
</script>

<?php if (! $CAN_ACCESS_MODULE) {?>
<div class="seccion" id="seccion1">
  <h3 style="text-align:center;font-size:2em;color:blue;">No tienes acceso a este módulo</h3>
</div>
<?php } else {?>
<div class="seccion vh-lock" id="seccion1">
  <div id="app" class="vh-scroll" data-your-value="<?php echo $this->session->userdata('idPortal'); ?>"
    data-your-user-value="<?php echo $this->session->userdata('id'); ?>"
    data-your-client-value='<?php echo json_encode($cliente_id ?? []); ?>'
    data-clientes='<?php echo json_encode($clientes_disponibles ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT); ?>'
    data-lang="<?php echo htmlspecialchars($lang, ENT_QUOTES, 'UTF-8'); ?>"
    data-your-rol-value="<?php echo $this->session->userdata('idrol'); ?>">
  </div>
</div>
<?php }?>
<script>
window.AUTH_BRIDGE = {
  exchangeUrl: <?php echo json_encode(
                       site_url('AuthBridge/exchange'),
                       JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
               ); ?>
};
</script>
<script src="<?php echo base_url('public/comunicacion/comunicacion-vue3.js'); ?>?v=<?php echo $assets_version; ?>">
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('app') && window.mountVueApp) {
    window.mountVueApp('#app');
  }
});
</script>

<style>
.seccion,
.vh-lock,
.vh-scroll,
#app {
  height: auto !important;
  min-height: 0 !important;
  max-height: none !important;
  overflow: visible !important;
}

#app>* {
  min-height: 0;
}
</style>