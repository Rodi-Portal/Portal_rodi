<!DOCTYPE html>
<html lang="es">
<?php if($switch == 0){ ?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Credenciales de acceso</title>
</head>

<body>
  <p>Estimado usuario,</p>
  <p>A continuación, encontrará sus credenciales de acceso para ingresar a nuestra plataforma:</p>
  <p><strong>Correo electrónico:</strong> <?php echo $correo; ?></p>
  <p><strong>Contraseña:</strong> <?php echo $pass; ?></p>
  <p>Es importante que mantenga sus credenciales de acceso de forma segura y no las comparta con nadie.</p>

  <p>Por favor, haga clic en el siguiente enlace para acceder:</p>
  <p><a href="https://portal.rodi.com.mx/">Acceder</a></p>

  <p>Si tiene alguna pregunta o necesita ayuda, no dude en contactarnos.</p>
  <p>Gracias por confiar en nosotros,<br>El equipo de RODI</p>
</body>

<?php }elseif($switch == 1){ ?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualizacion de contraseña</title>
</head>

<body>
  <p>Estimado usuario,</p>
  <p>A continuación, encontrará su nueva contraseña para  acceder  a nuestro portal:</p>
  <p><strong>Su nueva  contraseña es:</strong> <?php echo $pass; ?></p>
  <p>Es importante que mantenga sus credenciales de acceso de forma segura y no las comparta con nadie.</p>

  <p>Por favor, haga clic en el siguiente enlace para acceder:</p>
  <p><a href="https://portal.rodi.com.mx/">Acceder</a></p>

  <p>Si tiene alguna pregunta o necesita ayuda, no dude en contactarnos.</p>
  <p>Gracias por confiar en nosotros,<br>El equipo de RODI</p>
</body>



<?php } ?>

</html>