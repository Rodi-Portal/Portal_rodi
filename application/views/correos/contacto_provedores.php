<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Notificación de Contacto | TalentSafe</title>
  <style>
  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 30px 10px;
    color: #374151;
  }

  .container {
    background: #fff;
    max-width: 620px;
    margin: 0 auto;
    border-radius: 14px;
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
    overflow: hidden;
    border-top: 8px solid #2563eb;
  }

  .header {
    background: #2563eb;
    color: #fff;
    padding: 28px 25px;
    text-align: left;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  }

  .header h1 {
    font-weight: 700;
    font-size: 24px;
    margin: 0;
    letter-spacing: 0.04em;
  }

  .content {
    padding: 30px;
    font-size: 16px;
    line-height: 1.65;
  }

  .content p {
    margin: 18px 0;
  }

  .content strong {
    color: #1e40af;
  }

  .divider {
    border: none;
    border-top: 2px solid #e0e7ff;
    margin: 30px 0;
  }

  .info-row {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 20px;
    gap: 10px;
  }

  .info-label {
    font-weight: 600;
    color: #2563eb;
    min-width: 90px;
  }

  .info-text {
    flex-grow: 1;
    white-space: pre-wrap;
    word-break: break-word;
  }

  .btn-contact {
    display: inline-block;
    background-color: #2563eb;
    color: #fff !important;
    text-decoration: none;
    padding: 14px 38px;
    font-weight: 700;
    border-radius: 12px;
    margin-top: 30px;
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
    text-align: center;
  }

  .footer {
    background: #f9fafb;
    text-align: center;
    padding: 18px 20px;
    font-size: 13px;
    color: #6b7280;
    border-top: 1px solid #e0e7ff;
  }

  @media screen and (max-width: 480px) {
    .content {
      padding: 20px;
      font-size: 15px;
    }

    .info-row {
      flex-direction: column;
    }
  }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>Nuevo Prospecto desde TalentSafe</h1>
    </div>
    <div class="content">
      <p>Buen día <strong><?php echo htmlspecialchars($nombre1) ?></strong>,</p>
      <p>Un usuario de <strong>TalentSafe</strong> ha mostrado interés en los servicios que ofrece tu empresa.</p>
      <p>A continuación, te compartimos los datos que nos proporcionó para que puedas establecer contacto y brindarle la
        atención correspondiente.</p>
      <hr class="divider" />

      <div class="info-row">
        <span class="info-label">Nombre:</span>
        <span class="info-text"><?php echo nl2br(htmlspecialchars($nombre ?? '')) ?></span>
      </div>
      <div class="info-row">
        <span class="info-label">Empresa:</span>
        <span class="info-text"><?php echo nl2br(htmlspecialchars($empresa ?? '')) ?></span>
      </div>
      <div class="info-row">
        <span class="info-label">Correo:</span>
        <span class="info-text"><?php echo nl2br(htmlspecialchars($correo ?? '')) ?></span>
      </div>
      <div class="info-row">
        <span class="info-label">Teléfono:</span>
        <span class="info-text"><?php echo nl2br(htmlspecialchars($telefono ?? '')) ?></span>
      </div>
      <div class="info-row">
        <span class="info-label">Mensaje:</span>
        <span class="info-text"><?php echo nl2br(htmlspecialchars($descripcion ?? '')) ?></span>
      </div>
    </div>
    <div class="footer">
      © <?php echo date('Y') ?> TalentSafe. Todos los derechos reservados.
    </div>
  </div>
</body>

</html>