<div class="container-fluid px-0 py-0">
  <div class="com-switch-wrap">
    <a href="<?php echo site_url('empleados/comunicacion_central/interna'); ?>"
      class="com-switch-btn <?php echo ($modulo_actual === 'interna') ? 'active' : ''; ?>"
      data-modulo="interna">
      <?= $this->lang->line('com_tab_internal'); ?>
    </a>

    <a href="<?php echo site_url('empleados/comunicacion_central/360'); ?>"
      class="com-switch-btn <?php echo ($modulo_actual === '360') ? 'active' : ''; ?>"
      data-modulo="360">
      <?= $this->lang->line('com_tab_360'); ?>
    </a>
  </div>

  <div class="com-content mt-0">
    <?php
      if ($modulo_actual === 'interna') {
          if (! empty($com_habilitado)) {
              $this->load->view('moduloComunicacion/embeds/comunicacion_interna_embed');
          } else {
              $this->load->view('moduloComunicacion/descripcion_comunicacion_interna');
          }
      } else {
          if (! empty($com360_habilitado)) {
              $this->load->view('moduloComunicacion/embeds/comunicacion_360_embed');
          } else {
              $this->load->view('moduloComunicacion/descripcion_comunicacion_360');
          }
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
  margin-bottom: 10px;
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
  text-align: center;
}

.com-switch-btn:hover {
  color: #374151 !important;
  text-decoration: none !important;
}

.com-switch-btn.active {
  background: linear-gradient(90deg, #221dac 0%, #070766 100%);
  color: #fff !important;
  box-shadow: 0 6px 14px rgba(111, 123, 201, 0.28);
}

.com-content {
  width: 100%;
}

@media (max-width: 768px) {
  .com-switch-wrap {
    flex-direction: column;
    gap: 10px;
  }

  .com-switch-btn {
    width: 100%;
    min-height: 50px;
    font-size: 16px;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.com-switch-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const modulo = this.getAttribute('data-modulo') || 'interna';
      localStorage.setItem('com_modulo', modulo);
    });
  });
});
</script>