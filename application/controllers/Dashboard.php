<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->session->userdata('logueado') && $this->session->userdata('tipo') == 1) {
            $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));

            $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
            foreach ($data['submodulos'] as $row) {
                $items[] = $row->id_submodulo;
            }
            $data['submenus'] = $items;

            $config = $this->funciones_model->getConfiguraciones();
            $data['version'] = $config->version_sistema;
            //TODO:pendiente  si es  util   para      la plataforma  de reclutamiento

            if ($this->session->userdata('idrol') == 1 || $this->session->userdata('idrol') == 6 || $this->session->userdata('idrol') == 9) {
                $ReqProceso = $this->estadistica_model->countReqEnProceso();
                $data['titulo_dato1'] = 'Total de Requisiciones en Proceso';
                $data['dato1'] = $ReqProceso->total;

                $ReqFinalizadas = $this->estadistica_model->countReqFinalizadas();
                $data['titulo_dato2'] = 'Total de Requisiciones Finalizadas';
                $data['dato2'] = $ReqFinalizadas->total;

                $ReqCanceladas = $this->estadistica_model->countReqCanceladas();
                $data['titulo_dato3'] = 'Total de Requisiciones Canceladas';
                $data['dato3'] = $ReqCanceladas->total;

                $AspirantesTotal = $this->estadistica_model->countBolsaTrabajo();
                $data['titulo_dato4'] = 'Aspirantes  en Bolsa de Trabajo';
                $data['dato4'] = $AspirantesTotal->total;

            }
            if ($this->session->userdata('idrol') == 2) {
                $num = $this->estadistica_model->countCandidatosAnalista($this->session->userdata('id'));
                $data['dato_totalcandidatos'] = $num->total;
                $num = $this->estadistica_model->countCandidatosSinFormulario($this->session->userdata('id'));
                $data['dato_2'] = $num->total;
                $data['texto_2'] = "Candidatos sin envío de formulario";
                $num = $this->estadistica_model->countCandidatosSinDocumentos($this->session->userdata('id'));
                $data['dato_3'] = $num->total;
                $data['texto_3'] = "Candidatos sin envío de documentos";
            }

            $notificaciones = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0, 1]);
            if (!empty($notificaciones)) {
                $contador = 0;
                foreach ($notificaciones as $row) {
                    if ($row->visto == 0) {
                        $contador++;
                    }
                }
                $data['contadorNotificaciones'] = $contador;
            }
            //Modals
            $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);

            $this->load
                ->view('adminpanel/header', $data)
                ->view('adminpanel/index')
                ->view('adminpanel/scripts', $modales)
                ->view('adminpanel/footer');

               
               

        } else {
            redirect('Login/index');
        }
    }

    public function dashboardIndex()
    {
        if ($this->session->userdata('logueado') && $this->session->userdata('tipo') == 1) {
            $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));

            $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
            foreach ($data['submodulos'] as $row) {
                $items[] = $row->id_submodulo;
            }
            $data['submenus'] = $items;

            $config = $this->funciones_model->getConfiguraciones();
            $data['version'] = $config->version_sistema;
            //TODO:pendiente  si es  util   para      la plataforma  de reclutamiento

            if ($this->session->userdata('idrol') == 1 || $this->session->userdata('idrol') == 6) {
                $ReqProceso = $this->estadistica_model->countReqEnProceso();
                $data['titulo_dato1'] = 'Total de Requisiciones en Proceso';
                $data['dato1'] = $ReqProceso->total;

                $ReqFinalizadas = $this->estadistica_model->countReqFinalizadas();
                $data['titulo_dato2'] = 'Total de Requisiciones Finalizadas';
                $data['dato2'] = $ReqFinalizadas->total;

                $ReqCanceladas = $this->estadistica_model->countReqCanceladas();
                $data['titulo_dato3'] = 'Total de Requisiciones Canceladas';
                $data['dato3'] = $ReqCanceladas->total;

                $AspirantesTotal = $this->estadistica_model->countBolsaTrabajo();
                $data['titulo_dato4'] = 'Aspirantes  en Bolsa de Trabajo';
                $data['dato4'] = $AspirantesTotal->total;

            }
            if ($this->session->userdata('idrol') == 2) {
                $num = $this->estadistica_model->countCandidatosAnalista($this->session->userdata('id'));
                $data['dato_totalcandidatos'] = $num->total;
                $num = $this->estadistica_model->countCandidatosSinFormulario($this->session->userdata('id'));
                $data['dato_2'] = $num->total;
                $data['texto_2'] = "Candidatos sin envío de formulario";
                $num = $this->estadistica_model->countCandidatosSinDocumentos($this->session->userdata('id'));
                $data['dato_3'] = $num->total;
                $data['texto_3'] = "Candidatos sin envío de documentos";
            }

            $notificaciones = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0, 1]);
            if (!empty($notificaciones)) {
                $contador = 0;
                foreach ($notificaciones as $row) {
                    if ($row->visto == 0) {
                        $contador++;
                    }
                }
                $data['contadorNotificaciones'] = $contador;
            }
            //Modals
            $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);

            $this->load
                ->view('adminpanel/header', $data)
                ->view('adminpanel/index')
                ->view('adminpanel/footer');

               
               

        } else {
            redirect('Login/index');
        }
    }

    public function manual_usuario()
    {
        $this->load
            ->view('manual_usuario/manual');
    }


    public function ustglobal_panel()
    {
        if ($this->session->userdata('logueado') && $this->session->userdata('tipo') == 2) {
            $this->load->view('clientes/ust_cliente');
        } else {
            redirect('Login/index');
        }
    }


    public function header_cliente()
    {
        $id_cliente = $this->session->userdata('idcliente');
        $ingles = $this->session->userdata('ingles');
        $data['translations'] = $this->lang->language;
        // Cargar el idioma
        if ($ingles == 1) {
            $this->lang->load('clientes_panel', 'english');
        } else {
            $this->lang->load('clientes_panel', 'espanol');
        }
    
        // Obtener datos del cliente
        $data['translations'] = $this->lang->language;
        $modal['translations'] = $this->lang->language;
        $data['modals'] = $this->load->view('modals/clientes/mdl_panel', $modal, true);
        $data['procesosActuales'] = $this->cliente_model->get_current_procedures2();
        $datos['cliente'] = $this->cat_cliente_model->getClienteValido();
    
        // Verificar si hay campos vacíos
        $data_incompleta = false; // Cambiado a booleano para mayor claridad
        if (!empty($datos['cliente'])) {
            foreach ($datos['cliente'] as $campo) {
                // Verifica cada propiedad del objeto para encontrar campos vacíos
                foreach ($campo as $valor) {
                    if (is_null($valor) || trim($valor) === '') {
                        $data_incompleta = true;
                        break 2; // Salir de ambos bucles si se encuentra un campo vacío
                    }
                }
            }
        } else {
            $data_incompleta = true; // Si no hay datos de cliente, marcar como incompleto
        }
    
        if ($data_incompleta) {
            if ($this->session->userdata('logueado') && $this->session->userdata('tipo') == 2) {
                $this->load->view('clientes/validar_datos', $data);
            } else {
                redirect('Login/index');
            }
        } else {
            // Verificar si todos los campos están completos y redirigir
            if ($this->session->userdata('logueado') && $this->session->userdata('tipo') == 2) {
                $this->load->view('clientes/header_clientes');
                $this->load->view('adminpanel/footer', [], true);
             
            } else {
                redirect('Login/index');
            }
        }
    }


    public function client()
    {
        $id_cliente = $this->session->userdata('idcliente');
        $ingles = $this->session->userdata('ingles');
    
        // Cargar el idioma
        if ($ingles == 1) {
            $this->lang->load('clientes_panel', 'english');
        } else {
            $this->lang->load('clientes_panel', 'espanol');
        }
    
        // Obtener datos del cliente
        $data['translations'] = $this->lang->language;
        $modal['translations'] = $this->lang->language;
        $data['modals'] = $this->load->view('modals/clientes/mdl_panel', $modal, true);
        $data['procesosActuales'] = $this->cliente_model->get_current_procedures2();
        $datos['cliente'] = $this->cat_cliente_model->getClienteValido();
    
        // Verificar si hay campos vacíos
        $data_incompleta = false; // Cambiado a booleano para mayor claridad
        if (!empty($datos['cliente'])) {
            foreach ($datos['cliente'] as $campo) {
                // Verifica cada propiedad del objeto para encontrar campos vacíos
                foreach ($campo as $valor) {
                    if (is_null($valor) || trim($valor) === '') {
                        $data_incompleta = true;
                        break 2; // Salir de ambos bucles si se encuentra un campo vacío
                    }
                }
            }
        } else {
            $data_incompleta = true; // Si no hay datos de cliente, marcar como incompleto
        }
    
        
            // Verificar si todos los campos están completos y redirigir
            if ($this->session->userdata('logueado') && $this->session->userdata('tipo') == 2) {
                $this->load->view('clientes/index', $data);
            } else {
                redirect('Login/index');
            }
        
    }
    public function datosCliente() {
        // Obtén el ID del cliente de la sesión o de otro orig

        // Llama al modelo para obtener los datos del cliente
        $this->load->model('cat_cliente_model');
        $datos_cliente = $this->cat_cliente_model->getClienteValido();

        // Devuelve los datos en formato JSON
        echo json_encode($datos_cliente);
    }
    public function hcl_panel()
    {
        $data['paises'] = $this->funciones_model->getPaises();
        $data['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
        $data['paises_estudio'] = $this->funciones_model->getPaisesEstudio();
        $data['proyectos'] = $this->candidato_model->getProyectosCliente($this->session->userdata('idcliente'));
        $data['tipos_docs'] = $this->funciones_model->getTiposDocumentos();
        $data['bloqueo'] = $this->cat_cliente_model->getBloqueoHistorial($this->session->userdata('idcliente'));
        if ($this->session->userdata('logueado') && $this->session->userdata('tipo') == 2) {
            $this->load->view('clientes/panel', $data);
        } else {
            redirect('Login/index');
        }
    }

    public function client_panel()
    {
        $data['paises'] = $this->funciones_model->getPaises();
        $data['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
        $data['paises_estudio'] = $this->funciones_model->getPaisesEstudio();
        $data['proyectos'] = $this->candidato_model->getProyectosCliente($this->session->userdata('idcliente'));
        $data['tipos_docs'] = $this->funciones_model->getTiposDocumentos();
        if ($this->session->userdata('logueado') && $this->session->userdata('tipo') == 2) {
            $this->load->view('clientes/panel', $data);
        } else {
            redirect('Login/index');
        }
    }

    public function candidate_panel()
    {
        $candidato = $this->candidato_model->getDetalles($this->session->userdata('id'));
        $data['tiene_aviso'] = $this->candidato_model->checkAvisoPrivacidad($this->session->userdata('id'));
        $data['UploadedDocuments'] = $this->candidato_model->getUploadedDocumentsById($this->session->userdata('id'));
        $data['estados'] = $this->candidato_model->getEstados();
        $data['id_candidato'] = $this->session->userdata('id');
        $data['nombre'] = $this->session->userdata('nombre');
        $data['paterno'] = $this->session->userdata('paterno');
        $data['tipo_proceso'] = $this->session->userdata('proceso');
        $data['id_cliente'] = $this->session->userdata('idcliente');
        $data['proyecto_seccion'] = $this->session->userdata('proyecto_seccion');
        $data['docs_requeridos'] = $this->candidato_model->getDocumentosCandidatoRequeridos($this->session->userdata('id'));
        $data['candidato'] = $candidato;
        $data['secciones'] = $this->candidato_seccion_model->getSecciones($this->session->userdata('id'));
        $data['documentos_requeridos'] = $this->documentacion_model->getDocumentosRequeridosByCandidato($this->session->userdata('id'));
        $data['avances'] = $this->candidato_avance_model->getAllById($this->session->userdata('id'));
        $archivos = array();
        if ($data['UploadedDocuments']) {
            foreach ($data['UploadedDocuments'] as $file) {
                array_push($archivos, $file->id_tipo_documento);
            }
            $data['archivos'] = $archivos;
        } else {
            $data['archivos'] = 0;
        }
        $this->load->view('candidato/formulario', $data);
    }

    public function clientes_panel()
    {
        $id_cliente = $this->session->userdata('idcliente');
        $data['subclientes'] = $this->cliente_general_model->getSubclientesPanel($id_cliente);
        $data['puestos'] = $this->funciones_model->getPuestos();
        $data['drogas'] = $this->funciones_model->getPaquetesAntidoping();
        $data['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
        $data['paises'] = $this->funciones_model->getPaises();
        $data['bloqueo'] = $this->cat_cliente_model->getBloqueoHistorial($id_cliente);
        if ($id_cliente != 172 && $id_cliente != 178 && $id_cliente != 205 && $id_cliente != 235 && $id_cliente != 201 && $id_cliente != 236 && $id_cliente != 999 && $id_cliente != 249) {
            $this->load->view('clientes/panel', $data);
        } else {
            $this->load->view('clientes/clientes_index_ingles', $data);
        }

    }
    /*----------------------------------------*/
    /* Visitador
    /*----------------------------------------*/
    public function visitador_panel()
    {
        if ($this->session->userdata('logueado') && $this->session->userdata('tipo') == 1 && $this->session->userdata('idrol') == 3) {
            $data['parentescos'] = $this->funciones_model->getParentescos();
            $data['civiles'] = $this->funciones_model->getEstadosCiviles();
            $data['escolaridades'] = $this->funciones_model->getEscolaridades();
            $data['zonas'] = $this->funciones_model->getNivelesZona();
            $data['viviendas'] = $this->funciones_model->getTiposVivienda();
            $data['condiciones'] = $this->funciones_model->getTiposCondiciones();
            $data['visitas'] = $this->candidato_model->getCandidatosVisitador($this->session->userdata('id'));
            $data['clave_txt'] = '#ZY!C47K1esET*FBmO6Rir&25F!4jLJr'; //substr(md5(time()), 0, 32);
            $this->load->view('visitador/visitador_index', $data);
        } else {
            redirect('Login/index');
        }
    }
    /*----------------------------------------*/
    /* Panel Subclientes Espanol General
    /*----------------------------------------*/
    public function subclientes_general_panel()
    {
        $data['puestos'] = $this->funciones_model->getPuestos();
        $data['drogas'] = $this->funciones_model->getPaquetesAntidoping();
        $data['candidatos'] = $this->subcliente_model->getCandidatos($this->session->userdata('idsubcliente'));
        $data['paises'] = $this->funciones_model->getPaises();
        $data['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
        $data['bloqueo'] = $this->cat_cliente_model->getBloqueoHistorial($this->session->userdata('idcliente'));
        $this->load->view('subclientes/subclientes_general_index', $data);
    }

    /*----------------------------------------*/
    /* Panel Subclientes Ingles REMOTE TEAM
    /*----------------------------------------*/
    public function subclientes_ingles_panel()
    {
        if ($this->session->userdata('id')) {
            $id_cliente = $this->session->userdata('idcliente');
            $data['puestos'] = $this->funciones_model->getPuestos();
            $data['drogas'] = $this->funciones_model->getPaquetesAntidoping();
            $data['candidatos'] = $this->subcliente_model->getCandidatos($id_cliente);
            $data['paises'] = $this->funciones_model->getPaises();
            $data['subclientes'] = $this->cliente_general_model->getSubclientes($id_cliente);
            $data['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
            $this->load->view('subclientes/subclientes_ingles_index', $data);
        } else {
            redirect('Login/index');
        }
    }
}
