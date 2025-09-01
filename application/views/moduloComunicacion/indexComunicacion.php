<!-- Vista Vue -->
<link rel="stylesheet" href="<?= base_url('public/comunicacion/comunicacion_vue3.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/vue@3"></script>

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
         data-your-rol-value="<?= $this->session->userdata('idrol'); ?>"></div>
  </div>
<?php } ?>

<script src="<?= base_url('public/comunicacion/comunicacion-vue3.js'); ?>"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('app')) {
      window.mountVueApp('#app');
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
  height: 100vh;                 /* bloquea al alto de pantalla */
  display: flex;
  flex-direction: column;
  overflow: hidden;              /* nada se sale de aquí */
  min-height: 0;                 /* clave cuando ancestro es flex */
}

/* Donde vive el scroll real */
.vh-scroll {
  flex: 1 1 auto;
  display: flex;
  flex-direction: column;
  min-height: 0;                 /* importantísimo en flex children */
  overflow: auto;                /* el scroll va aquí */
}

/* Si hay más wrappers flex dentro del componente, esto ayuda */
#app > * {
  min-height: 0;                 /* evita que hijos hagan “auto” y corten */
}

/* Si tu .seccion original tenía reglas, mantenlas suaves */
.seccion {
  /* nada de overflow aquí; lo controla .vh-scroll */
}

 </style>