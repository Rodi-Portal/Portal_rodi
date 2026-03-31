<?php
$CI = &get_instance();

$lang = $CI->session->userdata('lang') ?: 'es';

if (ENVIRONMENT === 'development') {
    $assets_version = time();
} else {
    $assets_version = $CI->config->item('assets_version') ?: '1';
}
?>

<link rel="stylesheet" href="<?= base_url('public/comunicacion/comunicacion_vue3.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/vue@3"></script>

<?php
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

$ALLOWED = [];
foreach ($SLUGS as $slug) {
  if (user_can($slug, false)) {
    $ALLOWED[] = $slug;
  }
}
?>

<script>
  window.APP_PERMS = <?= json_encode($ALLOWED) ?>;
  window.COMUNICACION_TIPO = <?= json_encode($tipo_modulo ?? 'interna') ?>;

  window.$perms = {
    set: new Set(window.APP_PERMS || []),
    can(p)      { return this.set.has(p); },
    canAny(arr) { return arr.some(p => this.set.has(p)); },
    canAll(arr) { return arr.every(p => this.set.has(p)); }
  };
</script>

<div class="container-fluid py-3">
  <div class="com-top-switch mb-3">
    <button type="button" class="com-switch-btn active" data-modulo="interna">
      Comunicación interna
    </button>

    <button type="button" class="com-switch-btn" data-modulo="360">
      Comunicación 360
    </button>
  </div>

  <?php if ($this->session->userdata('idrol') == 11 || $this->session->userdata('idrol') == 4) { ?>
    <div class="seccion" id="seccion1">
      <h3 style="text-align:center;font-size:2em;color:blue;">No tienes acceso a este módulo</h3>
    </div>
  <?php } else { ?>
    <div class="seccion vh-lock" id="seccion1">
      <div
        id="app"
        class="vh-scroll"
        data-your-value="<?= $this->session->userdata('idPortal'); ?>"
        data-your-user-value="<?= $this->session->userdata('id'); ?>"
        data-your-client-value='<?= json_encode($cliente_id ?? []); ?>'
        data-lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8'); ?>"
        data-your-rol-value="<?= $this->session->userdata('idrol'); ?>"
        data-modulo="<?= htmlspecialchars($tipo_modulo ?? 'interna', ENT_QUOTES, 'UTF-8'); ?>">
      </div>
    </div>
  <?php } ?>
</div>

<script src="<?= base_url('public/comunicacion/comunicacion-vue3.js'); ?>?v=<?= $assets_version; ?>"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const appEl = document.getElementById('app');
  const buttons = document.querySelectorAll('.com-switch-btn');

  function setModulo(modulo) {
    window.COMUNICACION_TIPO = modulo;

    buttons.forEach(btn => {
      btn.classList.toggle('active', btn.dataset.modulo === modulo);
    });

    if (appEl) {
      appEl.setAttribute('data-modulo', modulo);
    }

    // Si tu app Vue expone método para cambiar módulo en caliente, aquí lo llamas
    if (window.setComunicacionModulo && typeof window.setComunicacionModulo === 'function') {
      window.setComunicacionModulo(modulo);
    }
  }

  buttons.forEach(btn => {
    btn.addEventListener('click', function() {
      setModulo(this.dataset.modulo);
    });
  });

  if (appEl && window.mountVueApp) {
    window.mountVueApp('#app');
  }

  setModulo(window.COMUNICACION_TIPO || 'interna');
});
</script>

<style>
.com-top-switch{
  display:flex;
  gap:12px;
  background:#ececec;
  border-radius:22px;
  padding:8px;
}

.com-switch-btn{
  flex:1;
  border:none;
  border-radius:18px;
  padding:14px 18px;
  font-size:18px;
  font-weight:700;
  background:#e5e5e5;
  color:#374151;
  transition:all .2s ease;
  outline:none;
}

.com-switch-btn.active{
  background:linear-gradient(90deg,#ef5da8,#c86dd7);
  color:#fff;
  box-shadow:0 8px 20px rgba(200,109,215,.25);
}

html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}

.vh-lock {
  height: calc(100vh - 180px);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  min-height: 0;
}

.vh-scroll {
  flex: 1 1 auto;
  display: flex;
  flex-direction: column;
  min-height: 0;
  overflow: auto;
}

#app > * {
  min-height: 0;
}
</style>