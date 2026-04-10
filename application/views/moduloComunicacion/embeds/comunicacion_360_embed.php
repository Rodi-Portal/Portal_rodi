<?php
    $CI = &get_instance();

    $lang = $CI->session->userdata('lang') ?: 'es';

    if (ENVIRONMENT === 'development') {
    $assets_version = time();
    } else {
    $assets_version = $CI->config->item('assets_version') ?: '1';
    }

    $SLUGS = [
    'comunicacion360.sucursales.seleccionar_multiple',
    'comunicacion360.nomina.periodos.ver',
    'comunicacion360.nomina.periodos.crear',
    'comunicacion360.nomina.periodos.editar',
    'comunicacion360.nomina.prenomina.crear',
    'comunicacion360.nomina.prenomina.editar',
    'comunicacion360.nomina.prenomina.descargar_excel',
    'comunicacion360.nomina.prenomina.modificar_celdas',
    'comunicacion360.nomina.historial.ver',
    'comunicacion360.nomina.historial.editar',
    'comunicacion360.calendario.ver_meses',
    'comunicacion360.calendario.registrar_evento',
    'comunicacion360.calendario.guardar_eventos',
    'comunicacion360.calendario.eliminar_evento',
    'comunicacion360.calendario.ver_dia',
    'comunicacion360.calendario.descargar_evento',
    'comunicacion360.mensajeria.configurar_columnas',
    'comunicacion360.mensajeria.crear_plantilla',
    'comunicacion360.mensajeria.actualizar_plantilla',
    'comunicacion360.mensajeria.enviar_masivo',
    'comunicacion360.recordatorios.ver',
    'comunicacion360.recordatorios.crear',
    'comunicacion360.recordatorios.editar',
    'comunicacion360.recordatorios.eliminar',
    ];

    $ALLOWED = [];
    foreach ($SLUGS as $slug) {
    if (user_can($slug, false)) {
        $ALLOWED[] = $slug;
    }
    }
?>

<link rel="stylesheet" href="<?php echo base_url('public/comunicacion360/comunicacion360.css'); ?>">


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

<?php if ($this->session->userdata('idrol') == 11 || $this->session->userdata('idrol') == 4) {?>
<div class="seccion" id="seccion1">
  <h3 style="text-align:center;font-size:2em;color:blue;">No tienes acceso a este módulo</h3>
</div>
<?php } else {?>
<div class="seccion vh-lock" id="seccion1">
  <div class="com360-shell">
    <div id="app" class="vh-scroll" data-your-value="<?php echo $this->session->userdata('idPortal'); ?>"
      data-your-user-value="<?php echo $this->session->userdata('id'); ?>"
      data-your-client-value='<?php echo json_encode($cliente_id ?? []); ?>'
      data-clientes='<?php echo json_encode($clientes_disponibles ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_APOS | JSON_HEX_QUOT); ?>'
      data-lang="<?php echo htmlspecialchars($lang, ENT_QUOTES, 'UTF-8'); ?>"
      data-your-rol-value="<?php echo $this->session->userdata('idrol'); ?>">
    </div>
  </div>
</div>
<?php }?>
<script>
window.global = window;
window.process = window.process || { env: {} };
</script>
<script src="<?php echo base_url('public/comunicacion360/comunicacion-360.js'); ?>?v=<?php echo $assets_version; ?>">
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
.com360-shell {
  width: 100%;
  padding: 0;     
    margin: 0;       /* quitamos el espacio */
  background: transparent; /* quitamos fondo */
  border-radius: 0;      /* quitamos bordes */
  box-sizing: border-box;
}

.com360-shell,
.com360-shell * {
  box-sizing: border-box;
}

.com360-shell #app {
  width: 100%;
  max-width: 100%;
  margin: 0;
}
</style>