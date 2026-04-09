<div id="comunicacion-app" class="comunicacion-container">
  <div class="comunicacion-box">
    <h1 class="comunicacion-title">
      <?php echo $this->lang->line('com_desc_360_title'); ?>
    </h1>

    <p class="comunicacion-intro">
      <?php echo $this->lang->line('com_desc_360_intro'); ?>
    </p>

    <div class="comunicacion-section">
      <h2 class="comunicacion-section-title">
        <?php echo $this->lang->line('com_desc_360_features_title'); ?>
      </h2>

      <div class="comunicacion-card">
        <div class="comunicacion-icon">
          <i class="fas fa-bullhorn"></i>
        </div>
        <div class="comunicacion-card-content">
          <h3><?php echo $this->lang->line('com_desc_360_feature_1_title'); ?></h3>
          <p><?php echo $this->lang->line('com_desc_360_feature_1_text'); ?></p>
        </div>
      </div>

      <div class="comunicacion-card">
        <div class="comunicacion-icon">
          <i class="fas fa-bell"></i>
        </div>
        <div class="comunicacion-card-content">
          <h3><?php echo $this->lang->line('com_desc_360_feature_2_title'); ?></h3>
          <p><?php echo $this->lang->line('com_desc_360_feature_2_text'); ?></p>
        </div>
      </div>

      <div class="comunicacion-card">
        <div class="comunicacion-icon">
          <i class="fas fa-comment-dots"></i>
        </div>
        <div class="comunicacion-card-content">
          <h3><?php echo $this->lang->line('com_desc_360_feature_3_title'); ?></h3>
          <p><?php echo $this->lang->line('com_desc_360_feature_3_text'); ?></p>
        </div>
      </div>
    </div>

    <div class="comunicacion-contacto">
      <p><?php echo $this->lang->line('com_desc_360_cta_text'); ?></p>

      <button type="button" class="comunicacion-btn">
        <?php echo $this->lang->line('com_desc_360_button'); ?>
      </button>
    </div>
  </div>
</div>

<style>
.comunicacion-container {
  width: 100%;
  padding: 30px 0 40px;
}

/* 🔥 MÁS GRANDE EL CONTENEDOR */
.comunicacion-box {
  max-width: 760px;
  /* antes 515px */
    margin-top: 20px;

  margin: 0 auto;
  background: #ffffff;
  border-radius: 12px;
  padding: 26px 28px 24px;
  box-shadow: 0 4px 14px rgba(0, 0, 0, .08);
}

/* 🔥 TÍTULO MÁS GRANDE */
.comunicacion-title {
  margin: 0 0 14px;
  text-align: center;
  font-size: 26px;
  font-weight: 600;
  color: #111111;
}

/* 🔥 TEXTO MÁS LEGIBLE */
.comunicacion-intro {
  margin: 0 0 20px;
  font-size: 14px;
  line-height: 1.7;
  color: #333;
}

/* 🔥 SUBTÍTULO */
.comunicacion-section-title {
  margin: 0 0 16px;
  font-size: 20px;
  font-weight: 600;
  color: #111;
}

/* 🔥 TARJETAS MÁS GRANDES */
.comunicacion-card {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  background: #eef1f5;
  border-radius: 10px;
  padding: 16px 18px;
  margin-bottom: 14px;
}

/* 🔥 ICONO MÁS GRANDE */
.comunicacion-icon {
  flex: 0 0 22px;
  width: 22px;
  text-align: center;
  color: #1da1f2;
  font-size: 18px;
  margin-top: 2px;
}

/* 🔥 TÍTULO CARD */
.comunicacion-card-content h3 {
  margin: 0 0 4px;
  font-size: 16px;
  font-weight: 600;
  color: #111;
}

/* 🔥 TEXTO CARD */
.comunicacion-card-content p {
  margin: 0;
  font-size: 14px;
  line-height: 1.6;
  color: #444;
}

/* 🔥 BLOQUE AZUL MÁS GRANDE */
.comunicacion-contacto {
  margin-top: 24px;
  background: #1da1e2;
  border-radius: 10px;
  padding: 20px;
  text-align: center;
}

.comunicacion-contacto p {
  margin: 0 0 14px;
  color: #ffffff;
  font-size: 14px;
  line-height: 1.6;
}

/* 🔥 BOTÓN MÁS PRO */
.comunicacion-btn {
  border: none;
  background: #ffffff;
  color: #1d7fc0;
  font-size: 13px;
  font-weight: 600;
  border-radius: 6px;
  padding: 10px 22px;
  cursor: pointer;
  transition: all .2s ease;
}

.comunicacion-btn:hover {
  background: #f4f8fb;
  transform: translateY(-1px);
}

@media (max-width: 640px) {
  .comunicacion-box {
    max-width: 100%;
    margin: 0 10px;
    padding: 16px 14px 14px;
  }

  .comunicacion-title {
    font-size: 18px;
  }

  .comunicacion-section-title {
    font-size: 15px;
  }
}
</style>