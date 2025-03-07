<!DOCTYPE html>
<html lang="es">
<head>
  <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>TALENTSAFE CONTROL  <?php echo $version; ?></title>
  <!-- CSS -->
  <?php echo link_tag("css/custom.css"); ?>
  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="icon" type="image/jpg" href="<?php echo base_url() ?>img/favicon.jpg" sizes="64x64">
  <style>
    /* Ajuste del margen superior del contenedor del formulario */
    .container {
      margin-top: 50px; /* Puedes ajustar este valor según tus necesidades */
    }
  </style>
</head>

<body class="bg-gradient-primary">
<?php 
  if($this->session->flashdata('error_code')):  ?>
    <div class="alert alert-danger alert-dismissible fade show text-center msj_login" role="alert" style="opacity: 1;">
      <strong><?php echo $this->session->flashdata('error_code'); ?> </strong>
      <button type="button" class="close cerrar_login" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php 
  endif; ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 >Verification Code</h1>
                  </div>
                  <div class="alert alert-danger alert-dismissible fade show text-center" id="errorAlert" style="display: none;" role="alert">
                    <strong id="errorMessage"></strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="alert alert-info alert-dismissible fade show text-center mb-0" id="emailSentAlert" role="alert">
                    <strong>Email with verification code sent successfully to <?php echo $correo; ?>!</strong><br>Please check your inbox or spam folder.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="alert alert-success alert-dismissible fade show mt-3" id="verificationSentAlert" style="display: none;" role="alert">
                    <strong>Verification code resent successfully!</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="user" action="<?php echo base_url('Login/verificar_codigo'); ?>" method="POST" id="verificationForm">
                    <div class="form-group">
                      <label for="codigo">Verification Code:</label>
                      <input type="password" class="form-control form-control-user" id="codigo" name="codigo"  placeholder="Insert verify code" required >
              
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block" id="submitButton">Verify</button>
                    <!-- Botón para volver a enviar el código de verificación -->
                    <button type="button" class="btn btn-secondary btn-user btn-block" id="resendCodeBtn">Resend Verification Code</button>
                  </form>
                  <hr>
                  <div class="text-center">
                     <h4><a href="<?php echo base_url('Login/logout'); ?>"><-- Back</a></h4>
                  </div>
                  <div class="text-center">
                    <a class="small">Version <?php echo $version; ?></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    var cooldown = 60; // Tiempo en segundos para el cooldown
    var resendButton = $('#resendCodeBtn');
    var interval;

    // Función para actualizar el estado del botón
    function updateButton() {
        if (cooldown > 0) {
            resendButton.text('Reenviar Código (' + cooldown + 's)');
            resendButton.prop('disabled', true);
        } else {
            resendButton.text('Reenviar Código');
            resendButton.prop('disabled', false);
        }
    }

    // Función para iniciar el temporizador
    function startCooldown() {
        clearInterval(interval); // Limpiar el intervalo anterior
        cooldown = 60; // Reiniciar el temporizador
        updateButton(); // Actualizar el estado inicial del botón
        interval = setInterval(function() {
            cooldown--;
            updateButton();
            if (cooldown <= 0) {
                clearInterval(interval);
            }
        }, 1000);
    }

    // Inicializar el botón y comenzar el temporizador al cargar la página
    startCooldown();

    // Manejar el clic en el botón de reenvío de código de verificación
    resendButton.click(function() {
        // Ocultar todas las alertas antes de mostrar la nueva
        $('#emailSentAlert, #verificationSentAlert, #errorSpan').fadeOut(function() {
            // Mostrar la alerta de verificación enviada después de que se haya ocultado la anterior
            $('#verificationSentAlert').fadeIn();
        });

        // Lógica para reenviar el código de verificación
        $.ajax({
            url: 'generar_codigo_autenticacion', // Asegúrate de que esta URL sea correcta
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                console.log('Código reenviado exitosamente:', response); // Para depuración
                $('#verificationSentAlert').fadeIn();

                // Reiniciar el temporizador
                startCooldown();

                // Ajustar el desplazamiento de la página para mantener la posición
                var scrollPosition = $('#verificationSentAlert').offset().top;
                $('html, body').animate({
                    scrollTop: scrollPosition
                }, 500);
            },
            error: function(xhr, status, error) {
                console.error('Error al reenviar el código de verificación:', error);
                $('#errorSpan').text('Error al reenviar el código de verificación: ' + error).show();
            }
        });
    });
  });
</script>


</body>
</html>

