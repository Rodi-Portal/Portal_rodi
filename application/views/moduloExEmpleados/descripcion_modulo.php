<style>
  .exempleados-container {
    max-width: 900px;
    margin: 40px auto;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    color: #1f2937;
  }

  .exempleados-title {
    text-align: center;
    font-size: 2rem;
    color: #0ea5e9;
    margin-bottom: 1rem;
  }

  .exempleados-section {
    margin-top: 20px;
  }

  .exempleados-card {
    background: #f1f5f9;
    padding: 20px;
    border-radius: 10px;
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
    align-items: flex-start;
  }

  .exempleados-card i {
    font-size: 28px;
    color: #0ea5e9;
    margin-top: 6px;
    flex-shrink: 0;
  }

  .exempleados-card h3 {
    margin: 0;
    font-size: 1.2rem;
    color: #1e293b;
  }

  .exempleados-card p {
    margin: 5px 0 0 0;
    color: #475569;
    font-size: 0.95rem;
  }

  .exempleados-contacto {
    margin-top: 30px;
    padding: 20px;
    background-color: #0ea5e9;
    color: white;
    text-align: center;
    border-radius: 10px;
  }

  .exempleados-contacto a {
    color: white;
    text-decoration: underline;
  }

  @media (max-width: 600px) {
    .exempleados-card {
      flex-direction: column;
    }

    .exempleados-card i {
      margin-bottom: 8px;
    }
  }
</style>

<div class="exempleados-container">
    <h1 class="exempleados-title">
        <?= $this->lang->line('former_modulo_titulo'); ?>
    </h1>

    <p>
        <?= $this->lang->line('former_modulo_descripcion'); ?>
    </p>

    <div class="exempleados-section">
        <h2><?= $this->lang->line('former_acciones_titulo'); ?></h2>

        <div class="exempleados-card">
            <i class="fas fa-user-times"></i>
            <div>
                <h3><?= $this->lang->line('former_detalles_titulo'); ?></h3>
                <p><?= $this->lang->line('former_detalles_descripcion'); ?></p>
            </div>
        </div>

        <div class="exempleados-card">
            <i class="fas fa-file-upload"></i>
            <div>
                <h3><?= $this->lang->line('former_documentos_titulo'); ?></h3>
                <p><?= $this->lang->line('former_documentos_descripcion'); ?></p>
            </div>
        </div>

        <div class="exempleados-card">
            <i class="fas fa-comments"></i>
            <div>
                <h3><?= $this->lang->line('former_comentarios_titulo'); ?></h3>
                <p><?= $this->lang->line('former_comentarios_descripcion'); ?></p>
            </div>
        </div>
    </div>

    <div class="exempleados-contacto">
        <p><?= $this->lang->line('former_contacto_texto'); ?></p>
        <p>
            <strong><?= $this->lang->line('former_correo'); ?></strong>
            <a href="mailto:bramirez@rodicontrol.com">
                bramirez@rodicontrol.com
            </a>
        </p>
    </div>
</div>
