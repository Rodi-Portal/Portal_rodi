<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Legal extends CI_Controller
{
    // Documentos legales globales
    private $pdf_base;

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(['url', 'html']);

        $lang      = $this->session->userdata('lang') ?: 'es';
        $idioma_ci = ($lang === 'en') ? 'english' : 'espanol';

        // Cargar idiomas necesarios
        $this->lang->load('header', $idioma_ci);
        $this->lang->load('portal_generales', $idioma_ci);
        $this->lang->load('legal', $idioma_ci);

        // Carpeta de documentos legales globales
        $this->pdf_base = rtrim(FCPATH, '/\\')
            . '/storagetalentsafe/legal/';
    }

    public function index()
    {
        $items = [];
        //foreach ($data['submodulos'] as $row) {
        //  $items[] = $row->id_submodulo;
        // }
        $data['submenus'] = $items;

        $config          = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;
        // URLs para los botones de descarga
        $data['terminos_url']         = site_url('legal/download/terminos');
        $data['confidencialidad_url'] = site_url('legal/download/confidencialidad');
        $headerView                   = $this->load->view('adminpanel/header', $data, true);
        echo $headerView;
        $view = $this->load->view('legal', $data, true);
        echo $view;

    }

    // legal/download/terminos  ó  legal/download/confidencialidad
    public function download($tipo = '')
    {

        //die('ENTRO A DOWNLOAD: ' . $tipo);
        $map = [
            'terminos'         => 'terminos_y_condiciones.pdf',
            'confidencialidad' => 'aviso_de_confidencialidad.pdf',
        ];

        if (! isset($map[$tipo])) {
            show_404();
        }

        $file = realpath($this->pdf_base . $map[$tipo]);

        // Seguridad y existencia real
        if (
            ! $file ||
            ! is_file($file) ||
            strpos($file, realpath($this->pdf_base)) !== 0
        ) {
            show_404();
        }

        // 🔴 LIMPIAR CUALQUIER OUTPUT PREVIO
        if (ob_get_length()) {
            ob_end_clean();
        }

        // 🔽 HEADERS MANUALES (PHP PURO)
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Length: ' . filesize($file));
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Expires: 0');

        // 🔽 ENVIAR ARCHIVO
        readfile($file);
        exit; // 👈 OBLIGATORIO
    }

}
