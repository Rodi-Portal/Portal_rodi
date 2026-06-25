<style>
  .empleado-container {
    max-width: 900px;
    margin: 40px auto;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    color: #1f2937;
  }

  .empleado-title {
    text-align: center;
    font-size: 2rem;
    color: #0ea5e9;
    margin-bottom: 1rem;
  }

  .empleado-section {
    margin-top: 20px;
  }

  .empleado-card {
    background: #f1f5f9;
    padding: 20px;
    border-radius: 10px;
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
    align-items: flex-start;
  }

  .empleado-card i {
    font-size: 28px;
    color: #0ea5e9;
    margin-top: 6px;
    flex-shrink: 0;
  }

  .empleado-card h3 {
    margin: 0;
    font-size: 1.2rem;
    color: #1e293b;
  }

  .empleado-card p {
    margin: 5px 0 0 0;
    color: #475569;
    font-size: 0.95rem;
  }

  .empleado-contacto {
    margin-top: 30px;
    padding: 20px;
    background-color: #0ea5e9;
    color: white;
    text-align: center;
    border-radius: 10px;
  }

  .empleado-contacto a {
    color: white;
    text-decoration: underline;
  }

  @media (max-width: 600px) {
    .empleado-card {
      flex-direction: column;
    }

    .empleado-card i {
      margin-bottom: 8px;
    }
  }
</style>

<div class="empleado-container">
  <h1 class="empleado-title"><?= $this->lang->line('emp_modulo_titulo'); ?></h1>

  <p>
    <?= $this->lang->line('emp_modulo_descripcion'); ?>
  </p>

  <div class="empleado-section">
    <h2><?= $this->lang->line('emp_expediente_titulo'); ?></h2>

    <div class="empleado-card">
      <i class="fas fa-folder-open"></i>
      <div>
        <h3><?= $this->lang->line('emp_registro_titulo'); ?></h3>
        <p>
          <?= $this->lang->line('emp_registro_descripcion'); ?>
        </p>
      </div>
    </div>

    <div class="empleado-card">
      <i class="fas fa-calendar-alt"></i>
      <div>
        <h3><?= $this->lang->line('emp_info_titulo'); ?></h3>
        <p>
          <?= $this->lang->line('emp_info_descripcion'); ?>
        </p>
      </div>
    </div>
  </div>

  <div class="empleado-section">
    <h2><?= $this->lang->line('emp_cursos_titulo'); ?></h2>

    <div class="empleado-card">
      <i class="fas fa-graduation-cap"></i>
      <div>
        <h3><?= $this->lang->line('emp_historial_titulo'); ?></h3>
        <p>
          <?= $this->lang->line('emp_historial_descripcion'); ?>
        </p>
      </div>
    </div>
  </div>

  <div class="empleado-section">
    <h2><?= $this->lang->line('emp_evaluaciones_titulo'); ?></h2>

    <div class="empleado-card">
      <i class="fas fa-check-circle"></i>
      <div>
        <h3><?= $this->lang->line('emp_desempeno_titulo'); ?></h3>
        <p>
          <?= $this->lang->line('emp_desempeno_descripcion'); ?>
        </p>
      </div>
    </div>
  </div>

  <div class="empleado-contacto">
    <p><?= $this->lang->line('emp_contacto_texto'); ?></p>
    <p>
      <strong><?= $this->lang->line('emp_correo'); ?></strong>
      <a href="mailto:bramirez@talentsafecontrol.com">bramirez@talentsafecontrol.com</a>
    </p>
  </div>
</div>
