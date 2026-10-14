<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang = $this->session->userdata('lang') ?: 'es';
$ingles = ($lang === 'en');

$titulo = $ingles
    ? 'Access temporarily suspended'
    : 'Acceso temporalmente suspendido';

$mensaje = $ingles
    ? 'Your TalentSafe service is temporarily restricted due to a pending payment.'
    : 'Tu servicio de TalentSafe se encuentra temporalmente restringido debido a un pago pendiente.';

$instruccion = $ingles
    ? 'Please contact our support team to regularize your service.'
    : 'Comunícate con nuestro equipo de soporte para regularizar tu servicio.';

$email = $ingles
    ? TALENTSAFE_SOPORTE_EMAIL_EN
    : TALENTSAFE_SOPORTE_EMAIL_ES;

$telefono = TALENTSAFE_SOPORTE_TELEFONO;
?>

<!DOCTYPE html>
<html lang="<?= $ingles ? 'en' : 'es' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= html_escape($titulo) ?> | TalentSafe</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: #f3f6fb;
            font-family: Arial, sans-serif;
            color: #263449;
        }

        .suspension-card {
            width: 100%;
            max-width: 530px;
            padding: 42px 32px;
            background: #fff;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 12px 40px rgba(0,0,0,.08);
        }

        .icono {
            font-size: 48px;
            margin-bottom: 18px;
        }

        h1 {
            font-size: 25px;
            margin-bottom: 18px;
            color: #173d73;
        }

        p {
            line-height: 1.7;
        }

        .contacto {
            margin-top: 28px;
            padding: 20px;
            background: #f3f6fb;
            border-radius: 10px;
        }

        .contacto a {
            display: block;
            margin: 12px 0;
            color: #1767ae;
            text-decoration: none;
            overflow-wrap: anywhere;
        }

        .contacto a:hover {
            text-decoration: underline;
        }

        .marca {
            margin-top: 30px;
            font-size: 13px;
            color: #8792a1;
        }
    </style>
</head>
<body>

<div class="suspension-card">
    <div class="icono">🔒</div>

    <h1><?= html_escape($titulo) ?></h1>

    <p><?= html_escape($mensaje) ?></p>
    <p><?= html_escape($instruccion) ?></p>

    <div class="contacto">
        <strong><?= $ingles ? 'Contact support' : 'Contactar a soporte' ?></strong>

        <a href="mailto:<?= html_escape($email) ?>">
            <?= html_escape($email) ?>
        </a>

        <a href="tel:<?= preg_replace('/[^0-9+]/', '', $telefono) ?>">
            <?= html_escape($telefono) ?>
        </a>
    </div>

    <div class="marca">TalentSafe © <?= date('Y') ?></div>
</div>

</body>
</html>