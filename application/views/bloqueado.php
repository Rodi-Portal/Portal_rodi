<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suspensión de Acceso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:  rgba(0,46,130,255); /* Fondo azul para la página */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .container-wrapper {
            display: flex;
            align-items: stretch; /* Asegura que ambos elementos tengan la misma altura */
            max-width: 1200px; /* Ajusta según el diseño deseado */
            width: 100%;
        }

        .col-lg-6 {
            flex: 1; /* Hace que ambos elementos ocupen el mismo espacio */
            display: flex;
            flex-direction: column; /* Organiza los elementos verticalmente */
            align-items: center; /* Centra los elementos horizontalmente */
            justify-content: center; /* Centra los elementos verticalmente */
            background-color: #ffffff; /* Fondo blanco para los contenedores */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 0 10px rgba(0,46,130,0.25); /* Sombra sutil para mejorar la visualización */
            overflow: hidden; /* Asegura que el contenido no se desborde */
            padding: 20px; /* Espacio interno del contenedor */
            box-sizing: border-box;
        }

        .header-image-container {
            width: calc(100% + 40px); /* Ancho de la imagen igual al ancho combinado de los contenedores más margen adicional */
            height: calc(50% + 40px); /* Altura de la imagen igual a la mitad de la altura de los contenedores más margen adicional */
            margin-bottom: 20px; /* Espacio debajo de la imagen */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header-image {
            width: 50%; /* Ancho de la imagen igual al ancho del contenedor */
            height: 60%; /* Altura de la imagen igual a la altura del contenedor */
            object-fit: cover; /* Ajusta la imagen para cubrir el contenedor */
            border-radius: 8px; /* Bordes redondeados para la imagen */
        }

        .bg-login-image h1 {
            color: #e74c3c;
            font-size: 24px; /* Ajusta el tamaño del título */
            margin: 0 0 20px 0; /* Espacio debajo del título */
            text-align: center; /* Centra el título */
            padding: 0 20px; /* Espacio horizontal dentro del contenedor del título */
        }

        .bg-login-image p {
            color: #333;
            margin: 0 0 15px 0; /* Espacio debajo de los párrafos */
            line-height: 1.6; /* Mejora la legibilidad con mayor espacio entre líneas */
            text-align: center; /* Centra el texto del párrafo */
            padding: 0 20px; /* Espacio horizontal dentro del contenedor de los párrafos */
        }

        .instructions {
            background-color: #ffffff; /* Fondo blanco para mejor contraste */
            border: 1px solid #ddd; /* Borde gris claro */
            padding: 20px; /* Espacio interno alrededor del texto */
            margin-top: 20px; /* Espacio arriba del contenedor */
            border-radius: 8px; /* Bordes redondeados */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra sutil para mejor visualización */
        }

        .button {
            display: inline-block;
            padding: 10px 20px; /* Espacio interno alrededor del texto del botón */
            color: #fff;
            background-color: #3498db;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px 0; /* Espacio alrededor del botón */
            text-align: center; /* Centra el texto del botón */
        }

        .button:hover {
            background-color: #2980b9; /* Color de fondo del botón al pasar el ratón */
        }
    </style>
</head>

<body>
    <div class="header-image-container">
        <img src="<?php echo base_url() ?>img/logoconNombre2.png" alt="Talentsafe Control" class="header-image">
    </div>
    <div class="container-wrapper">
        <div class="col-lg-6 bg-login-image">
            <h1>Access Suspended</h1>
            <p>Dear User,</p>
            <p>Your access to the platform has been suspended due to non-payment. To restore access, please make the pending payment.</p>
            <p>
                <!-- <a href="https://example.com/payment" class="button">Make Payment</a> -->
            </p>
            <div class="instructions">
                <p>If you have already made the payment and still see this notification, please contact our technical support:</p>
                <p>Email: support@talentsafecontrol.com</p>
                <p>Phone: +52 33 3454 2877</p>
            </div>
            <p>Thank you for your understanding and cooperation.</p>
        </div>

        <div class="col-lg-6 bg-login-image">
            <h1>Acceso Suspendido</h1>
            <p>Estimado usuario,</p>
            <p>Su acceso a la plataforma ha sido suspendido debido a la falta de pago. Para restaurar el acceso, por favor realice el pago pendiente.</p>
            <p>
                <!-- <a href="https://example.com/pago" class="button">Realizar Pago</a> -->
            </p>
            <div class="instructions">
                <p>Si ya ha realizado el pago y sigue viendo esta notificación, por favor contacte a nuestro soporte técnico:</p>
                <p>Email: soporte@talentsafecontrol.com</p>
                <p>Teléfono: +52 33 3454 2877</p>
            </div>
            <p>Gracias por su comprensión y cooperación.</p>
        </div>
    </div>
</body>

</html>
