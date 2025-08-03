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
  <h1 class="empleado-title">Módulo de Empleados</h1>
  <p>
    Este módulo te permite gestionar expedientes de empleados y dar seguimiento a documentos y evaluaciones clave.
    A continuación se describen las principales secciones incluidas:
  </p>

  <div class="empleado-section">
    <h2>Expediente del Empleado</h2>

    <div class="empleado-card">
      <i class="fas fa-folder-open"></i>
      <div>
        <h3>Registro y Documentación</h3>
        <p>
          Registra a los empleados y carga documentos personales como contratos y comprobantes de domicilio.
          Configura recordatorios para vencimientos.
        </p>
      </div>
    </div>

    <div class="empleado-card">
      <i class="fas fa-calendar-alt"></i>
      <div>
        <h3>Información General</h3>
        <p>
          Administra datos como información personal, médica, vacaciones, incapacidades y otros detalles importantes.
        </p>
      </div>
    </div>
  </div>

  <div class="empleado-section">
    <h2>Cursos y Capacitación</h2>
    <div class="empleado-card">
      <i class="fas fa-graduation-cap"></i>
      <div>
        <h3>Historial de Formación</h3>
        <p>
          Da seguimiento a los cursos y capacitaciones realizadas por los empleados, incluyendo fechas de vencimiento.
        </p>
      </div>
    </div>
  </div>

  <div class="empleado-section">
    <h2>Evaluaciones</h2>
    <div class="empleado-card">
      <i class="fas fa-check-circle"></i>
      <div>
        <h3>Evaluaciones de Desempeño</h3>
        <p>
          Carga evidencias de evaluaciones y encuestas realizadas para medir el clima laboral y el rendimiento del personal.
        </p>
      </div>
    </div>
  </div>

  <div class="empleado-contacto">
    <p>¿Necesitas ayuda con este módulo? Contacta a nuestro equipo de soporte:</p>
    <p><strong>Correo:</strong> <a href="mailto:bramirez@talentsafecontrol.com">bramirez@talentsafecontrol.com</a></p>
  </div>
</div>
