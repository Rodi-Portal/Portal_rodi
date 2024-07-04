<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Destination_Controller extends CI_Controller {

    public function upload()
    {
        // Cargar la librería de carga de archivos
        $this->load->library('upload');

        // Configurar las opciones de carga
        $config['upload_path'] = './_docs/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size'] = 2048;

        // Inicializar la configuración
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file')) {
            // Error al subir archivo
            $error = array('error' => $this->upload->display_errors());
            echo json_encode(array('status' => 'error', 'message' => $error));
        } else {
            // Archivo subido con éxito
            $data = array('upload_data' => $this->upload->data());
            echo json_encode(array('status' => 'success', 'message' => 'Archivo subido correctamente.', 'data' => $data));
        }
    }
}
