 <!--Vista  Vue   -->
 <link rel="stylesheet" href="<?php echo base_url('public/vue/css/cssEmpleados.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<div class="seccion" id="seccion1">
    <div id="app"></div> <!-- Contenedor para el componente Vue -->
</div>

<script src="<?php echo base_url('public/vue/js/moduloEmpleados.js'); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Montar la aplicación Vue en el contenedor #app
    if (document.getElementById('app')) {
        window.mountVueApp('#app');
    }
});
</script>