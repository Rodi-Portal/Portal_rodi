<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 |------------------------------------------------------------
 | CONFIGURACIÓN BASE DE EMAIL
 |------------------------------------------------------------
 */

$config = array(
    'protocol'    => 'smtp',
    'mailtype'    => 'html',
    'charset'     => 'utf-8',
    'wordwrap'    => TRUE,
    'newline'     => "\r\n",
    'crlf'        => "\r\n"
);

/*
 |------------------------------------------------------------
 | CARGAR CONFIG PRIVADA (SI EXISTE)
 |------------------------------------------------------------
 */

$private = APPPATH . 'config/email_private.php';

if (file_exists($private)) {
    require $private;

    $config['smtp_host']   = $config['smtp_host'];
    $config['smtp_user']   = $config['smtp_user'];
    $config['smtp_pass']   = $config['smtp_pass'];
    $config['smtp_port']   = $config['smtp_port'];
    $config['smtp_crypto'] = $config['smtp_secure'];
}
