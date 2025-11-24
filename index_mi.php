<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TalentSafe | Mantenimiento en curso</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="icon" type="image/png" href="img/portal_icon_nombre.png" />
  <style>
    body {
      background: linear-gradient(135deg, #0c4a6e, #2563eb);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      color: white;
      font-family: 'Segoe UI', Roboto, sans-serif;
    }

    .logo {
      width: 450px; /* tamaño fijo para evitar pixelado */
      height: auto;
      image-rendering: -webkit-optimize-contrast; /* mejora nitidez */
      image-rendering: crisp-edges;
      -ms-interpolation-mode: bicubic; /* mejora en IE/Edge antiguos */
      margin-bottom: 1.5rem;
      filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
    }

    h1 {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 0.75rem;
    }

    p {
      color: rgba(255, 255, 255, 0.85);
      max-width: 420px;
      margin: 0 auto 1.5rem;
      line-height: 1.6;
    }

    a {
      background-color: #fff;
      color: #1e3a8a;
      padding: 0.6rem 1.4rem;
      border-radius: 9999px;
      font-weight: 600;
      text-decoration: none;
      box-shadow: 0 3px 10px rgba(255, 255, 255, 0.2);
      transition: all 0.3s ease;
    }

    a:hover {
      background-color: #f1f5f9;
      transform: translateY(-2px);
    }

    footer {
      margin-top: 2rem;
      color: rgba(255, 255, 255, 0.6);
      font-size: 0.85rem;
    }

    .dots span {
      display: inline-block;
      width: 8px;
      height: 8px;
      background: white;
      border-radius: 50%;
      margin: 0 3px;
      animation: blink 1.4s infinite both;
    }

    .dots span:nth-child(2) {
      animation-delay: 0.2s;
    }

    .dots span:nth-child(3) {
      animation-delay: 0.4s;
    }

    @keyframes blink {
      0%, 80%, 100% { opacity: 0; }
      40% { opacity: 1; }
    }
  </style>
</head>

<body>
  <img src="img/portal_icon_nombre.png" alt="TalentSafe Logo" class="logo" draggable="false" />

  <h1>Mantenimiento en curso</h1>
  <p>
    Estamos realizando mejoras en el sistema <strong>TalentSafe</strong> para ofrecerte una mejor experiencia.
    <br>Volveremos en breve. ¡Gracias por tu paciencia!
  </p>

  <div class="dots mb-6">
    <span></span><span></span><span></span>
  </div>

  <a href="mailto:info@talentsafe.com">Contactar soporte</a>

  <footer>© <span id="year"></span> TalentSafe · Todos los derechos reservados</footer>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>
</body>
</html>
