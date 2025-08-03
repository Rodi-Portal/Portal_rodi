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
  <h1 class="reclutamiento-title">Módulo de Reclutamiento</h1>
  <p>
    El módulo que estás intentando acceder no forma parte de tu plan contratado.
    Por favor, revisa tus opciones de suscripción o contacta al área de soporte para más información.
  </p>

  <div class="reclutamiento-section">
    <h2>Descripción del Módulo</h2>

    <div class="reclutamiento-card">
      <i class="fas fa-clipboard-list"></i>
      <div>
        <h3>Solicitud de Vacantes</h3>
        <p>Permite crear y gestionar solicitudes de personal, definiendo los requisitos del puesto e iniciando el proceso de reclutamiento de forma eficiente.</p>
      </div>
    </div>

    <div class="reclutamiento-card">
      <i class="fas fa-users"></i>
      <div>
        <h3>Vacantes Activas</h3>
        <p>Asigna candidatos a vacantes activas y revisa sus perfiles, seguimiento y comentarios. Esto facilita decisiones de contratación más informadas.</p>
      </div>
    </div>

    <div class="reclutamiento-card">
      <i class="fas fa-check-circle"></i>
      <div>
        <h3>Vacantes Cerradas</h3>
        <p>Consulta el historial de vacantes cubiertas o canceladas. Esta sección te permite hacer análisis y reportes de la eficiencia del reclutamiento.</p>
      </div>
    </div>

    <div class="reclutamiento-card">
      <i class="fas fa-id-card"></i>
      <div>
        <h3>Candidatos</h3>
        <p>Sube perfiles de candidatos y asígnalos a vacantes específicas. Conserva un banco de talento disponible para futuras contrataciones.</p>
      </div>
    </div>
  </div>

  <div class="reclutamiento-contacto">
    <p>Para activar este módulo, contacta a nuestro Responsable de Operaciones:</p>
    <p><strong>Correo:</strong> <a href="mailto:bramirez@talentsafecontrol.com">bramirez@talentsafecontrol.com</a></p>
  </div>
</div>
