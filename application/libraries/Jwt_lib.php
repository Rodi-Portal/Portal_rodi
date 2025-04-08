<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class Jwt_lib {

    private $private_key;  // Ruta a la clave privada
    private $public_key;   // Ruta a la clave pública

    public function __construct() {
        // Definir las rutas a las claves
        $this->private_key = FCPATH . 'application/config/keys/private_key.pem';  // Ruta a tu clave privada
        $this->public_key = FCPATH . 'application/config/keys/public_key.pem';    // Ruta a tu clave pública
    }

    // Codificar datos en un token JWT utilizando la clave privada
    public function encode($data) {
        $private_key = file_get_contents($this->private_key);
        $issued_at = time();
        $expiration_time = $issued_at + 3600;  // El token expirará en 1 hora
        $payload = array(
            'iat' => $issued_at,
            'exp' => $expiration_time,
            'data' => $data
        );

        return JWT::encode($payload, $private_key, 'RS256'); // Usar RS256 como algoritmo
    }

    // Decodificar el token JWT utilizando la clave pública
    public function decode($jwt) {
        $public_key = file_get_contents($this->public_key);

        try {
            return JWT::decode($jwt, $public_key, array('RS256')); // Verificar con la clave pública
        } catch (Exception $e) {
            return null; // Si el JWT no es válido, puedes manejar el error de la forma que prefieras
        }
    }
}
