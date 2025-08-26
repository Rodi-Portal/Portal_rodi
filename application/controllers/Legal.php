<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Legal extends CI_Controller
{
    // Carpeta donde almacenarás los PDFs (p.ej. /public_html/_docs/legal/)
    private $pdf_base;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'html']);
        $this->pdf_base = FCPATH . '_docs/legal/'; // Asegúrate de crear esta carpeta y subir tus PDFs
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
         $view =  $this->load->view('legal', $data, true);
        echo $view;

    }

    // legal/download/terminos  ó  legal/download/confidencialidad
    public function download($tipo = '')
    {
        $map = [
            'terminos'         => 'terminos_y_condiciones.pdf',
            'confidencialidad' => 'aviso_de_confidencialidad.pdf',
        ];

        if (! isset($map[$tipo])) {
            show_404();
        }

        $file = $this->pdf_base . $map[$tipo];
        $real = @realpath($file);

        if (! $real || strpos($real, realpath($this->pdf_base)) !== 0 || ! is_file($real)) {
            show_404();
        }

        // Enviar como descarga
        $this->output
            ->set_header('Content-Type: application/pdf')
            ->set_header('Content-Length: ' . filesize($real))
            ->set_header('Content-Disposition: attachment; filename="' . basename($real) . '"')
            ->set_output(file_get_contents($real));
    }
}