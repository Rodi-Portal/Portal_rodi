<div id="comunicacion-app" class="comunicacion-container">
  <h1 class="comunicacion-title">Módulo de Comunicación</h1>
  <p>
    Este módulo aún no está activo en tu cuenta, pero estará disponible próximamente.
    A través de esta herramienta podrás fortalecer la comunicación interna, automatizar avisos y mantener a todo tu equipo informado en tiempo real.
  </p>

  <div class="comunicacion-section">
    <h2>¿Qué podrás hacer con este módulo?</h2>

    <div class="comunicacion-card">
      <i class="fas fa-bullhorn"></i>
      <div>
        <h3>Publicaciones dirigidas</h3>
        <p>
          Comparte avisos generales, noticias internas o comunicados con el equipo completo o con áreas específicas de tu organización.
        </p>
      </div>
    </div>

    <div class="comunicacion-card">
      <i class="fas fa-bell"></i>
      <div>
        <h3>Notificaciones inteligentes</h3>
        <p>
          Configura recordatorios automáticos sobre fechas importantes: vencimiento de documentos, evaluaciones, cursos o cumpleaños del equipo.
        </p>
      </div>
    </div>

    <div class="comunicacion-card">
      <i class="fas fa-comment-dots"></i>
      <div>
        <h3>Canales de diálogo</h3>
        <p>
          Habilita formularios internos para que los colaboradores puedan enviar ideas, solicitudes o levantar alertas de manera sencilla y organizada.
        </p>
      </div>
    </div>
  </div>

  <div class="comunicacion-contacto">
    <p>Este módulo estará disponible próximamente. ¿Te gustaría que te avisemos cuando esté listo?</p>
    <button @click="suscribirse">Quiero ser notificado</button>
  </div>
</div>

<!-- Vue 3 desde CDN -->


<!-- Estilos específicos del módulo -->
<style>
  .comunicacion-container {
    max-width: 900px;
    margin: 40px auto;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    color: #1f2937;
  }

  .comunicacion-title {
    text-align: center;
    font-size: 2rem;
    color: #0ea5e9;
    margin-bottom: 1rem;
  }

  .comunicacion-section {
    margin-top: 20px;
  }

  .comunicacion-card {
    background: #f1f5f9;
    padding: 20px;
    border-radius: 10px;
    display: flex;
    gap: 16px;
    margin-bottom: 20px;
    align-items: flex-start;
  }

  .comunicacion-card i {
    font-size: 28px;
    color: #0ea5e9;
    margin-top: 6px;
    flex-shrink: 0;
  }

  .comunicacion-card h3 {
    margin: 0;
    font-size: 1.2rem;
    color: #1e293b;
  }

  .comunicacion-card p {
    margin: 5px 0 0 0;
    color: #475569;
    font-size: 0.95rem;
  }

  .comunicacion-contacto {
    margin-top: 30px;
    padding: 20px;
    background-color: #0ea5e9;
    color: white;
    text-align: center;
    border-radius: 10px;
  }

  .comunicacion-contacto button {
    margin-top: 10px;
    padding: 10px 18px;
    background: white;
    color: #0ea5e9;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
  }

  .comunicacion-contacto button:hover {
    background: #e0f2fe;
  }

  @media (max-width: 600px) {
    .comunicacion-card {
      flex-direction: column;
    }

    .comunicacion-card i {
      margin-bottom: 8px;
    }
  }
</style>
