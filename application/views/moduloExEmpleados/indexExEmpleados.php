 <!--Vista  Vue   -->
 <link rel="stylesheet" href="<?php echo base_url('public/former/css/cssFormer.css'); ?>">
 <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>

<div class="seccion" id="seccion1">
    <div id="app" 
         data-your-value="<?php echo $this->session->userdata('idPortal'); ?>" 
         data-your-user-value="<?php echo $this->session->userdata('id'); ?>"></div>
</div>

<script src="<?php echo base_url('public/former/js/moduloFormer.js'); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('app')) {
        window.mountVueApp('#app');
    }
});
</script>