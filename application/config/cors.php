<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cors {

    public function setHeaders() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        
        // Si es necesario, agregar el manejo de credentials
        // header("Access-Control-Allow-Credentials: true");
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            exit; // Termina la ejecución para las solicitudes OPTIONS
        }
    }
}
