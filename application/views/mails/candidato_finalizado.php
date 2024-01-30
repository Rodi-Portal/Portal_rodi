<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Proceso del candidato finalizado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        /* .card {
            max-width: 350px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f0f0f0;
            border: 1px solid #fff2;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        } */
        .card {
          margin: 0 auto;
          padding: 20px;
          width: 300px;
          border: 1px solid #8d8e8f;
          border-radius: 10px;
        }
        #logo {
            text-align: center;
            margin-bottom: 20px;
        }
        #message {
            text-align: justify;
            padding: 20px;
            border-radius: 10px;
        }
        #footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="card">
      <div id="logo">
          <img src="https://i.ibb.co/fdyb04r/logo.png" alt="Logo de la empresa" width="150px"/>
      </div>
      <div id="message">
          <p><b>Hola <span id="cliente"><?php echo $usuario; ?></span></b>,</p>
          <p>Nos complace comunicarte que el proceso de <?php echo $candidato; ?> ha finalizado y es posible que lo puedas consultar en nuestra plataforma de <a href="https://rodicontrol.rodi.com.mx">RODICONTROL</a>.</p>
          <p>Ponemos a tu disposición las siguientes cuentas de correo: bramirez@rodicontrol.com, bjimenez@rodicontrol.com para recibir tus comentarios.</p>
      </div>
      <div id="footer">
          <p>&copy; <?php echo date('Y'); ?>  RODI. Todos los derechos reservados.</p>
          <small>Este correo fu enviado automaticamente, no responder a este correo.</small>
      </div>
    </div>
</body>
</html>
