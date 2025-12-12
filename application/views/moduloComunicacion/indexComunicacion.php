<!-- Vista Vue -->
 <?php
$CI = &get_instance();

// Idioma actual (como en el header)
$lang = $CI->session->userdata('lang') ?: 'es';

// En desarrollo: forzar no caché
if (ENVIRONMENT === 'development') {
    $assets_version = time();
} else {
    $assets_version = $CI->config->item('assets_version') ?: '1';
}
?>
<link rel="stylesheet" href="<?= base_url('public/comunicacion/comunicacion_vue3.css'); ?>?v=<?php echo $assets_version; ?>">
<!-- script src="https://cdn.jsdelivr.net/npm/vue@3"></script -->

<?php
// ===== 1) Slugs del módulo que vas a usar en el front =====
$SLUGS = [
  'comunicacion.sucursales.seleccionar_multiple',
  'comunicacion.nomina.periodos.ver',
  'comunicacion.nomina.periodos.crear',
  'comunicacion.nomina.periodos.editar',
  'comunicacion.nomina.prenomina.crear',
  'comunicacion.nomina.prenomina.editar',
  'comunicacion.nomina.prenomina.descargar_excel',
  'comunicacion.nomina.prenomina.modificar_celdas',
  'comunicacion.nomina.historial.ver',
  'comunicacion.nomina.historial.editar',
  'comunicacion.calendario.ver_meses',
  'comunicacion.calendario.registrar_evento',
  'comunicacion.calendario.guardar_eventos',
  'comunicacion.calendario.eliminar_evento',
  'comunicacion.calendario.ver_dia',
  'comunicacion.calendario.descargar_evento',
  'comunicacion.mensajeria.configurar_columnas',
  'comunicacion.mensajeria.crear_plantilla',
  'comunicacion.mensajeria.actualizar_plantilla',
  'comunicacion.mensajeria.enviar_masivo',
  'comunicacion.recordatorios.ver',
  'comunicacion.recordatorios.crear',
  'comunicacion.recordatorios.editar',
  'comunicacion.recordatorios.eliminar',
];

// ===== 2) Calcula cuáles están permitidos para el usuario actual =====
// Usamos tu helper user_can(). El segundo parámetro (legacy) = false por seguridad si no hay override.
$ALLOWED = [];
foreach ($SLUGS as $slug) {
  if (user_can($slug, false)) $ALLOWED[] = $slug;
}
?>

<!-- 3) Expone permisos al front -->
<script>
  // Slugs permitidos para el usuario actual (leerá comunicacion-vue3.js)
  window.APP_PERMS = <?= json_encode($ALLOWED) ?>;
  console.log("🚀 ~ APP_PERMS:", window.APP_PERMS);

  // Helper de permisos compartido (Vue 2/3)
  window.$perms = {
    set: new Set(window.APP_PERMS || []),
    can(p)      { return this.set.has(p); },
    canAny(arr) { return arr.some(p => this.set.has(p)); },
    canAll(arr) { return arr.every(p => this.set.has(p)); }
  };
</script>

<?php if ($this->session->userdata('idrol') == 11 || $this->session->userdata('idrol') == 4) { ?>
  <div class="seccion" id="seccion1">
    <h3 style="text-align:center;font-size:2em;color:blue;">No tienes acceso a este módulo</h3>
  </div>
<?php } else { ?>
  <!-- ⬇️ añade vh-lock a la sección y vh-scroll al app -->
  <div class="seccion vh-lock" id="seccion1">
    <div id="app" class="vh-scroll"
         data-your-value="<?= $this->session->userdata('idPortal'); ?>"
         data-your-user-value="<?= $this->session->userdata('id'); ?>"
         data-your-client-value='<?= json_encode($cliente_id); ?>'
         data-lang="<?php echo htmlspecialchars($lang, ENT_QUOTES, 'UTF-8'); ?>"
         data-your-rol-value="<?= $this->session->userdata('idrol'); ?>"></div>
  </div>
<?php } ?>

<script src="<?= base_url('public/comunicacion/comunicacion-vue3.js'); ?>?v=<?php echo $assets_version; ?>"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('app')) {
      window.mountVueApp('#app'); // dentro de esa función instalaremos v-can / $can
    }
  });
</script>

<style>
/* Asegura altura base */
html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}

/* Contenedor que se ajusta al viewport y evita cortes */
.vh-lock {
  height: 100vh;
  display: flex;
  flex-direction: column;
  overflow: hidden;
  min-height: 0;
}

/* Donde vive el scroll real */
.vh-scroll {
  flex: 1 1 auto;
  display: flex;
  flex-direction: column;
  min-height: 0;
  overflow: auto;
}

/* Si hay más wrappers flex dentro del componente, esto ayuda */
#app > * {
  min-height: 0;
}

/* Si tu .seccion original tenía reglas, mantenlas suaves */
.seccion { /* el scroll lo controla .vh-scroll */ }
</style>
