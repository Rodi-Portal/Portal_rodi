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

<?php
$portalActual = (int) $this->session->userdata('idPortal');
$soloPortales = [1, 12]; // 👈 TEMPORAL: quitar esta línea después
//if ((int)$this->session->userdata('idrol') == 4) { ?>
<?php if (
  (int)$this->session->userdata('idrol') == 4
  || !in_array($portalActual, $soloPortales, true)
) { ?>
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