<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_traer_documentos_model extends CI_Model{
   

    // URL de tu API Laravel para obtener el detalle del doping
    public function obtenerImagenExterna($directorio, $nombreArchivo)
    {
        // URL base de la plataforma externa
        $baseUrl = 'http://localhost:8000/api/file/';

        // Concatenar el directorio y el nombre del archivo para formar la URL completa
        $url = rtrim($baseUrl, '/') . '/' . ltrim($directorio . '/' . $nombreArchivo, '/');


        // Iniciar sesión cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);

        // Verificar si ocurrió un error durante la ejecución de cURL
        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            return ['error' => 'Error en la solicitud cURL: ' . $error];
        }

        // Obtener el código de respuesta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Cerrar la sesión cURL
        curl_close($ch);

        // Verificar el código de respuesta HTTP
        if ($httpCode !== 200) {
            return ['error' => 'Error al obtener la imagen. Código HTTP: ' . $httpCode];
        }

        // Devolver la imagen como una cadena de bytes
        return $response;
    }


    public function guardarImagen($imagen, $nombreArchivo, $directorio) {
        // Directorio donde se guardará el archivo
        $upload_path = './'.$directorio;
        // Ruta completa del archivo
        $file_path = $upload_path .'/'.$nombreArchivo;

        // Asegurarse de que el directorio existe
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        // Guardar el contenido del archivo en el directorio
        file_put_contents($file_path, $imagen);

        // Verificar si la imagen se guardó correctamente
        if (file_exists($file_path)) {
            return 'La imagen se ha guardado correctamente en: ' . $file_path;
        } else {
            return 'Hubo un error al guardar la imagen.';
        }
    }

    
    // Ejemplo de uso
}
