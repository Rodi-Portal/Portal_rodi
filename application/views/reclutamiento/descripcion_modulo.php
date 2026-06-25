<style>
  .reclutamiento-container {
    max-width: 900px;
    margin: 40px auto;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    color: #1f2937;
  }

  .reclutamiento-title {
    text-align: center;
    font-size: 2rem;
    color: #0ea5e9;
    margin-bottom: 1rem;
  }

  .reclutamiento-section {
    margin-top: 20px;
  }

  .reclutamiento-card {
    background: #f1f5f9;
    padding: 20px;
    border-radius: 10px;
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
    align-items: flex-start;
  }

  .reclutamiento-card i {
    font-size: 28px;
    color: #0ea5e9;
    margin-top: 6px;
    flex-shrink: 0;
  }

  .reclutamiento-card h3 {
    margin: 0;
    font-size: 1.2rem;
    color: #1e293b;
  }

  .reclutamiento-card p {
    margin: 5px 0 0 0;
    color: #475569;
    font-size: 0.95rem;
  }

  .reclutamiento-contacto {
    margin-top: 30px;
    padding: 20px;
    background-color: #0ea5e9;
    color: white;
    text-align: center;
    border-radius: 10px;
  }

  .reclutamiento-contacto a {
    color: white;
    text-decoration: underline;
  }

  @media (max-width: 600px) {
    .reclutamiento-card {
      flex-direction: column;
    }

    .reclutamiento-card i {
      margin-bottom: 8px;
    }
  }
</style>

<div class="reclutamiento-container">
    <h1 class="reclutamiento-title">
        <?= $this->lang->line('rec_modulo_titulo'); ?>
    </h1>

    <p>
        <?= $this->lang->line('rec_modulo_descripcion'); ?>
    </p>

    <div class="reclutamiento-section">
        <h2><?= $this->lang->line('rec_descripcion_titulo'); ?></h2>

        <div class="reclutamiento-card">
            <i class="fas fa-clipboard-list"></i>
            <div>
                <h3><?= $this->lang->line('rec_solicitud_titulo'); ?></h3>
                <p><?= $this->lang->line('rec_solicitud_descripcion'); ?></p>
            </div>
        </div>

        <div class="reclutamiento-card">
            <i class="fas fa-users"></i>
            <div>
                <h3><?= $this->lang->line('rec_activas_titulo'); ?></h3>
                <p><?= $this->lang->line('rec_activas_descripcion'); ?></p>
            </div>
        </div>

        <div class="reclutamiento-card">
            <i class="fas fa-check-circle"></i>
            <div>
                <h3><?= $this->lang->line('rec_cerradas_titulo'); ?></h3>
                <p><?= $this->lang->line('rec_cerradas_descripcion'); ?></p>
            </div>
        </div>

        <div class="reclutamiento-card">
            <i class="fas fa-id-card"></i>
            <div>
                <h3><?= $this->lang->line('rec_candidatos_titulo'); ?></h3>
                <p><?= $this->lang->line('rec_candidatos_descripcion'); ?></p>
            </div>
        </div>
    </div>

    <div class="reclutamiento-contacto">
        <p><?= $this->lang->line('rec_contacto_texto'); ?></p>
        <p>
            <strong><?= $this->lang->line('rec_correo'); ?></strong>
            <a href="mailto:bramirez@talentsafecontrol.com">
                bramirez@talentsafecontrol.com
            </a>
        </p>
    </div>
</div>
