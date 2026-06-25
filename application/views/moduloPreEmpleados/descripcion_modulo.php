<style>
  .preempleo-container {
    max-width: 900px;
    margin: 40px auto;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    color: #1f2937;
  }

  .preempleo-title {
    text-align: center;
    font-size: 2rem;
    color: #0ea5e9;
    margin-bottom: 1rem;
  }

  .preempleo-section {
    margin-top: 20px;
  }

  .preempleo-card {
    background: #f1f5f9;
    padding: 20px;
    border-radius: 10px;
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
    align-items: flex-start;
  }

  .preempleo-card i {
    font-size: 28px;
    color: #0ea5e9;
    margin-top: 6px;
    flex-shrink: 0;
  }

  .preempleo-card h3 {
    margin: 0;
    font-size: 1.2rem;
    color: #1e293b;
  }

  .preempleo-card p {
    margin: 5px 0 0 0;
    color: #475569;
    font-size: 0.95rem;
  }

  .preempleo-contacto {
    margin-top: 30px;
    padding: 20px;
    background-color: #0ea5e9;
    color: white;
    text-align: center;
    border-radius: 10px;
  }

  .preempleo-contacto a {
    color: white;
    text-decoration: underline;
  }

  @media (max-width: 600px) {
    .preempleo-card {
      flex-direction: column;
    }

    .preempleo-card i {
      margin-bottom: 8px;
    }
  }
</style>

<div class="preempleo-container">
    <h1 class="preempleo-title">
        <?= $this->lang->line('pre_modulo_titulo'); ?>
    </h1>

    <p>
        <?= $this->lang->line('pre_modulo_descripcion'); ?>
    </p>

    <div class="preempleo-section">
        <h2><?= $this->lang->line('pre_evaluaciones_titulo'); ?></h2>

        <div class="preempleo-card">
            <i class="fas fa-user-check"></i>
            <div>
                <h3><?= $this->lang->line('pre_ese_titulo'); ?></h3>
                <p><?= $this->lang->line('pre_ese_descripcion'); ?></p>
            </div>
        </div>

        <div class="preempleo-card">
            <i class="fas fa-shield-alt"></i>
            <div>
                <h3><?= $this->lang->line('pre_bgv_titulo'); ?></h3>
                <p><?= $this->lang->line('pre_bgv_descripcion'); ?></p>
            </div>
        </div>

        <div class="preempleo-card">
            <i class="fas fa-brain"></i>
            <div>
                <h3><?= $this->lang->line('pre_psicometrica_titulo'); ?></h3>
                <p><?= $this->lang->line('pre_psicometrica_descripcion'); ?></p>
            </div>
        </div>

        <div class="preempleo-card">
            <i class="fas fa-stethoscope"></i>
            <div>
                <h3><?= $this->lang->line('pre_medico_titulo'); ?></h3>
                <p><?= $this->lang->line('pre_medico_descripcion'); ?></p>
            </div>
        </div>

        <div class="preempleo-card">
            <i class="fas fa-syringe"></i>
            <div>
                <h3><?= $this->lang->line('pre_antidoping_titulo'); ?></h3>
                <p><?= $this->lang->line('pre_antidoping_descripcion'); ?></p>
            </div>
        </div>
    </div>

    <div class="preempleo-contacto">
        <p><?= $this->lang->line('pre_contacto_texto'); ?></p>
        <p>
            <strong><?= $this->lang->line('pre_correo'); ?></strong>
            <a href="mailto:bramirez@talentsafecontrol.com">
                bramirez@talentsafecontrol.com
            </a>
        </p>
    </div>
</div>
