<div class="container-fluid py-3">

  <div class="com-switch-wrap">
    <a href="<?php echo site_url('empleados/comunicacion_central/interna'); ?>"
      class="com-switch-btn <?php echo ($modulo_actual === 'interna') ? 'active' : ''; ?>" data-modulo="interna">
      Internal Communication
    </a>

    <a href="<?php echo site_url('empleados/comunicacion_central/360'); ?>"
      class="com-switch-btn <?php echo ($modulo_actual === '360') ? 'active' : ''; ?>" data-modulo="360">
      Communication 360
    </a>
  </div>
  <div class="com-content mt-3">
    <?php
    if ($modulo_actual === 'interna') {
        $this->load->view('moduloComunicacion/embeds/comunicacion_interna_embed');
    } else {
        $this->load->view('moduloComunicacion/embeds/comunicacion_360_embed');
    }
  ?>
  </div>

</div>

<style>
.com-switch-wrap {
  display: flex;
  align-items: center;
  gap: 12px;
  width: 100%;
  background: #f3f3f3;
  border-radius: 18px;
  padding: 10px;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, .04);
}

.com-switch-btn {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 54px;
  padding: 0 18px;
  border-radius: 999px;
  text-decoration: none !important;
  font-size: 18px;
  font-weight: 700;
  color: #374151 !important;
  background: #ececec;
  transition: all .2s ease;
  box-shadow: 0 4px 10px rgba(0, 0, 0, .08);
}

.com-switch-btn:hover {
  color: #374151 !important;
  text-decoration: none !important;
}

.com-switch-btn.active {
  background: linear-gradient(90deg, #eb69a9 0%, #c96fb0 100%);
  color: #fff !important;
  box-shadow: 0 6px 14px rgba(201, 111, 176, .28);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.com-switch-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const modulo = this.getAttribute('data-modulo') || 'interna';
      localStorage.setItem('com_modulo', modulo);
    });
  });
});
</script>