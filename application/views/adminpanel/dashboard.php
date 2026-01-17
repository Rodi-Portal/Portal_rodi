<?php
$CI = &get_instance();

$lang = $CI->session->userdata('lang') ?: 'es';

if (ENVIRONMENT === 'development') {
  $assets_version = time();
} else {
  $assets_version = $CI->config->item('assets_version') ?: '1';
}

// ✅ Token ya generado y guardado en sesión
$dashJwt = (string) $CI->session->userdata('dash_jwt');

// ✅ Clientes asignados (tabla usuario_permiso). Tu controller debe mandar esto como array
$cliente_id = $cliente_id ?? [];
?>
<link rel="stylesheet" href="<?= base_url('public/dashboard/dashboard.css'); ?>?v=<?= $assets_version; ?>">

<?php if ((int)$this->session->userdata('idrol') == 4) { ?>

  <div class="seccion" id="seccion1">
    <h3 style="text-align:center;font-size:2em;color:blue;">No tienes acceso a este módulo</h3>
  </div>

<?php } else { ?>

  <div class="seccion" id="seccion1">
    <div id="dashApp"
      data-your-value="<?= (int)$this->session->userdata('idPortal'); ?>"
      data-your-user-value="<?= (int)$this->session->userdata('id'); ?>"
      data-your-rol-value="<?= (int)$this->session->userdata('idrol'); ?>"
      data-your-client-value='<?= json_encode($cliente_id); ?>'
      data-lang="<?= htmlspecialchars($lang, ENT_QUOTES); ?>"
    ></div>
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
