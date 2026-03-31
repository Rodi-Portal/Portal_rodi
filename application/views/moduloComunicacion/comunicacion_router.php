<div style="display:flex; align-items:center; justify-content:center; height:60vh;">
  <div style="text-align:center;">
    <div class="spinner-border text-primary mb-3"></div>
    <div>Cargando módulo...</div>
  </div>
</div>

<script>
(function() {
  const base = "<?php echo site_url('empleados/comunicacion_central'); ?>";

  let modulo = localStorage.getItem('com_modulo');

  if (!modulo || (modulo !== 'interna' && modulo !== '360')) {
    modulo = 'interna';
  }

  window.location.replace(base + '/' + modulo);
})();
</script>