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
  <h1 class="exempleados-title">Módulo de Exempleados</h1>
  <p>
    Este módulo te permite gestionar la información de los exempleados de tu organización, incluyendo documentos importantes y comentarios para referencia futura.
  </p>

  <div class="exempleados-section">
    <h2>¿Qué puedes hacer con este módulo?</h2>

    <div class="exempleados-card">
      <i class="fas fa-user-times"></i>
      <div>
        <h3>Detalles del exempleado</h3>
        <p>
          Registra y administra información clave del exempleado como sus datos personales, historial laboral y otros datos relevantes.
        </p>
      </div>
    </div>

    <div class="exempleados-card">
      <i class="fas fa-file-upload"></i>
      <div>
        <h3>Agregar documentos</h3>
        <p>
          Adjunta cartas de renuncia, evaluaciones de desempeño y otros archivos importantes que desees conservar para consulta futura.
        </p>
      </div>
    </div>

    <div class="exempleados-card">
      <i class="fas fa-comments"></i>
      <div>
        <h3>Comentarios para referencia</h3>
        <p>
          Agrega notas o comentarios sobre la conducta, desempeño o cualquier aspecto relevante del exempleado.
        </p>
      </div>
    </div>
  </div>

  <div class="exempleados-contacto">
    <p>¿Tienes dudas o necesitas ayuda? Contacta al equipo de Recursos Humanos:</p>
    <p><strong>Correo:</strong> <a href="mailto:bramirez@rodicontrol.com">bramirez@rodicontrol.com</a></p>
  </div>
</div>
