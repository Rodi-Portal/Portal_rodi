<?php
$CI = &get_instance();

// Idioma actual (como en el header)
$lang = $CI->session->userdata('lang') ?: 'es';

// En desarrollo: forzar no caché
if (ENVIRONMENT != 'development') {
    $assets_version = time();
} else {
    $assets_version = $CI->config->item('assets_version') ?: '1';
}
echo $assets_version;
?>
<!--Vista  Vue   -->
<link rel="stylesheet"
  href="<?php echo base_url('public/former/css/cssFormer.css'); ?>?v=<?php echo $assets_version; ?>">
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
<?php if ($this->session->userdata('idrol') == 4) {?>
<div class="seccion" id="seccion1">
  <h3 style="text-align: center; font-size: 2em; color: blue;">
    No tienes acceso a este módulo
  </h3>
</div>


<?php } else {?>
<div class="seccion" id="seccion1">
  <div id="app" data-your-value="<?php echo $this->session->userdata('idPortal'); ?>"
    data-your-user-value="<?php echo $this->session->userdata('id'); ?>"
    data-your-rol-value="<?php echo $this->session->userdata('idrol'); ?>"
    data-your-client-value="<?php echo $cliente_id; ?>"
    data-lang="<?php echo htmlspecialchars($lang, ENT_QUOTES, 'UTF-8'); ?>">
  </div>
  <?php } ?>
  <script src="<?php echo base_url('public/former/js/moduloFormer.js'); ?>?v=<?php echo $assets_version; ?>"></script>
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('app')) {
      window.mountVueApp('#app');
    }
  });
  </script>