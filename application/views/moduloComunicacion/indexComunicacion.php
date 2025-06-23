 <!--Vista  Vue   -->

 <link rel="stylesheet" href="<?php echo base_url('public/comunicacion/comunicacion_vue3.css'); ?>">
 <script src="https://cdn.jsdelivr.net/npm/vue@3"></script>
 <?php if ($this->session->userdata('idrol') == 11 || $this->session->userdata('idrol') == 4) {?>
 <div class="seccion" id="seccion1">
   <h3 style="text-align: center; font-size: 2em; color: blue;">
     No tienes acceso a este módulo
   </h3>
 </div>


 <?php } else {?>
 <div class="seccion" id="seccion1">
   <div id="app" data-your-value="<?php echo $this->session->userdata('idPortal'); ?>"
     data-your-user-value="<?php echo $this->session->userdata('id'); ?>"
     data-your-client-value="<?php echo $cliente_id; ?>"
     data-your-rol-value="<?php echo $this->session->userdata('idrol'); ?>"></div>
 </div>
 <?php }?>
 <script src="<?php echo base_url('public/comunicacion/comunicacion-vue3.js'); ?>"></script>
 <script>
document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('app')) {
    window.mountVueApp('#app');
  }
});
 </script>
 <style>
  html, body, .seccion, #app {
    height: 100%;
    margin: 0;
    padding: 0;
  }
  .seccion {
    display: flex;
    flex-direction: column;
  }
  #app {
    flex: 1;
    display: flex;
    flex-direction: column;
  }
</style>
