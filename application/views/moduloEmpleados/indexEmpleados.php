 <!--Vista  Vue   -->

 <link rel="stylesheet" href="<?php echo base_url('public/vue/css/cssEmpleados.css'); ?>">
 <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
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
     data-your-client-value="<?php echo $cliente_id; ?>"
     data-your-rol-value="<?php echo $this->session->userdata('idrol'); ?>"></div>
 </div>
 <?php }?>
 <script src="<?php echo base_url('public/vue/js/moduloEmpleados.js'); ?>"></script>
 <script>
document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('app')) {
    window.mountVueApp('#app');
  }
});
 </script>