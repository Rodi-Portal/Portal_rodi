<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Firebase\JWT\JWT;

class Reclutamiento extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Helpers base
        $this->load->helper(['url', 'language', 'i18n']);

        // 🔒 Seguridad
        if (! $this->session->userdata('id')) {
            redirect('Login/index');
            return; // importante para cortar aquí
        }

        // Idioma actual
        $raw = strtolower((string) ($this->session->userdata('lang') ?: 'es'));
        $map = [
            'es'      => 'espanol',
            'en'      => 'english',
            'spanish' => 'espanol',
            'english' => 'english',
        ];
        $lang = $map[$raw] ?? 'espanol';
        // ✅ Reclutamiento (4 submódulos)
        $this->lang->load('reclutamiento_escritorio', $lang);
        $this->lang->load('reclutamiento_progreso', $lang);
        $this->lang->load('reclutamiento_finalizadas', $lang);
        $this->lang->load('reclutamiento_bolsa', $lang);

        // (Opcional) si este módulo también lo usa reclutamiento
        $this->lang->load('registro_candidatos', $lang);

        // Sesión/estatus
        $this->load->library('usuario_sesion');
        $this->usuario_sesion->checkStatusBD();
    }

    public function index()
    {
        // Llama a la vista y pasa los datos necesarios
        $this->load->view('modals/mdl_reclutamiento');
    }
    public function menu()
    {
        $data['submenus']   = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $modales['modals']  = $this->load->view('modals/mdl_usuario', '', true);
        $data['permisos']   = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));

        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;

        $config          = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        $res = $this->cat_portales_model->getModulos();

        if (! empty($res)) {
                            // Accede directamente a la fila
            $modulo = $res; // getModulos devuelve solo una fila como array

            // Verifica el valor de reclu
            if ($modulo['reclu'] == 1) {
                $View = $this->load->view('reclutamiento/menu_reclutamiento', $data, true);
            } else {
                $View = $this->load->view('reclutamiento/descripcion_modulo', $data, true);
            }
        } else {
            // Si no hay módulos, carga una vista de error o una descripción
            $View = $this->load->view('reclutamiento/descripcion_modulo', $data, true);
        }

        // Cargar las vistas en variables
        $headerView  = $this->load->view('adminpanel/header', $data, true);
        $scriptsView = $this->load->view('adminpanel/scripts', $modales, true);
        $footerView  = $this->load->view('adminpanel/footer', [], true);

        // Mostrar las vistas
        echo $headerView;
        echo $scriptsView; // Mostrar scripts si es necesario
        echo $View;        // Mostrar el menú
    }

    /*----------------------------------------*/
    /*  Submenus
    /*----------------------------------------*/
    public function requisicion()
    {
        // Inicialización
        $filter      = '';
        $getFilter   = '';
        $filterOrder = '';
        $items       = [];

        // Permisos y menú
        $data['permisos']   = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));

        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;

        // Configuración
        $config          = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        // ====== Filtros de búsqueda y ordenamiento ======
        $getSort = $this->input->get('sort', true) ?? '';
        switch ($getSort) {
            case 'ascending':
                $sort = 'ASC';
                break;
            case 'descending':
                $sort = 'DESC';
                break;
            default:
                $sort = 'DESC';
                break;
        }

        $getFilter = $this->input->get('filter', true) ?? '';
        if ($getFilter) {
            if (in_array($getFilter, ['COMPLETA', 'INTERNA'])) {
                $filter      = $getFilter;
                $filterOrder = 'R.tipo';
            } elseif ($getFilter == 'En espera') {
                $filter      = 1;
                $filterOrder = 'R.status';
            } elseif ($getFilter == 'En proceso') {
                $filter      = 2;
                $filterOrder = 'R.status';
            }
        } else {
            $filter      = '';
            $filterOrder = 'R.tipo !=';
        }

        $order = (int) $this->input->get('order');
        if ($order !== null && $order !== '') {
            $id_order        = ($order > 0) ? $order : 0;
            $condition_order = ($order > 0) ? 'R.id' : 'R.id >';
        } else {
            $id_order        = 0;
            $condition_order = 'R.id >';
        }

        // ====== Carga de requisiciones según rol ======
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario            = $this->session->userdata('id');
            $info['requisiciones'] = $this->reclutamiento_model->getOrdersByUser($id_usuario, $sort, $id_order, $condition_order);
            $info['orders_search'] = $this->reclutamiento_model->getOrdersByUser($id_usuario, $sort, 0, 'R.id >');
        } else {
            $info['requisiciones'] = $this->reclutamiento_model->getAllOrders($sort, $id_order, $condition_order, $filter, $filterOrder);
            $info['orders_search'] = $this->reclutamiento_model->getAllOrders($sort, 0, 'R.id >', $filter, $filterOrder);
        }
        /*
        echo'<pre>';
        print_r($info['orders_search'] );
        echo'</pre>'; 
        die(); */
        $info['sortOrder'] = $getSort;
        $info['filter']    = $getFilter;

        // Datos adicionales para la vista
        $info['registros']            = null;
        $info['medios']               = $this->funciones_model->getMediosContacto();
        $info['puestos']              = $this->funciones_model->getPuestos();
        $info['paises']               = $this->funciones_model->getPaises();
        $info['paquetes_antidoping']  = $this->funciones_model->getPaquetesAntidoping();
        $info['usuarios_asignacion']  = $this->usuario_model->getTipoUsuarios([4, 11, 6, 9, 10]);
        $info['registros_asignacion'] = $this->reclutamiento_model->getRequisicionesActivas();
        $info['acciones']             = $this->funciones_model->getAccionesRequisicion();

        // Requisiciones en proceso según rol
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario   = $this->session->userdata('id');
            $info['reqs'] = $this->reclutamiento_model->getOrdersInProcessByUser($id_usuario);
        } else {
            $info['reqs'] = $this->reclutamiento_model->getAllOrdersInProcess();
        }

        // Modales
        $modales['modals']             = $this->load->view('modals/mdl_usuario', '', true);
        $vista['modals_reclutamiento'] = $this->load->view('modals/mdl_reclutamiento', $info, true);

        // Notificaciones
        $notificaciones = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0, 1]);
        if (! empty($notificaciones)) {
            $contador = 0;
            foreach ($notificaciones as $row) {
                if ($row->visto == 0) {
                    $contador++;
                }
            }
            $data['contadorNotificaciones'] = $contador;
        }

        // ====== Renderizado de vistas ======
        // Si quieres incluir el header:
        // echo $this->load->view('adminpanel/header', $data, true);

        echo $this->load->view('adminpanel/scripts', $modales, true);
        echo $this->load->view('reclutamiento/requisicion', $vista, true);
        echo $this->load->view('adminpanel/footer', [], true);
    }

    public function control()
    {
        $data['permisos']   = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config           = $this->funciones_model->getConfiguraciones();
        $data['version']  = $config->version_sistema;
        if (isset($_GET['sort'])) {
            $getSort = $_GET['sort'];
            switch ($getSort) {
                case 'ascending':
                    $sort = 'ASC';
                    break;
                case 'descending':
                    $sort = 'DESC';
                    break;
                default:
                    $sort = 'DESC';
                    break;
            }
        } else {
            $sort    = 'DESC';
            $getSort = '';
        }
        if (isset($_GET['filter'])) {
            $getFilter = $_GET['filter'];
            if ($getFilter == 'COMPLETA' || $getFilter == 'INTERNA') {
                $filter      = $getFilter;
                $filterOrder = 'R.tipo';
            }
            if ($getFilter == 'En espera') {
                $filter      = 1;
                $filterOrder = 'R.status';
            }
            if ($getFilter == 'En proceso') {
                $filter      = 2;
                $filterOrder = 'R.status';
            }
        } else {
            $getFilter   = '';
            $filter      = '';
            $filterOrder = 'R.tipo !=';
        }
        if (isset($_GET['order'])) {
            $order = $_GET['order'];
            if ($order != '') {
                $id_order        = ($order > 0) ? $order : 0;
                $condition_order = ($order > 0) ? 'R.id' : 'R.id >';
            } else {
                $id_order        = 0;
                $condition_order = 'R.id >';
            }
        } else {
            $id_order        = 0;
            $condition_order = 'R.id >';
        }
        //Dependiendo el rol del usuario se veran todas o sus propias requisiciones
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario            = $this->session->userdata('id');
            $reqs                  = $this->reclutamiento_model->getOrdersInProcessByUser($id_usuario);
            $info['requisiciones'] = $this->reclutamiento_model->getOrdersByUser($id_usuario, $sort, $id_order, $condition_order);
            $info['orders_search'] = $this->reclutamiento_model->getOrdersByUser($id_usuario, $sort, 0, 'R.id >');
        } else {
            $reqs                  = $this->reclutamiento_model->getAllOrdersInProcess();
            $info['requisiciones'] = $this->reclutamiento_model->getAllOrders($sort, $id_order, $condition_order, $filter, $filterOrder);
            $info['orders_search'] = $this->reclutamiento_model->getAllOrders($sort, 0, 'R.id >', $filter, $filterOrder);
        }
        $data['reqs']                = $reqs;
        $info['reqs']                = $reqs;
        $info['medios']              = $this->funciones_model->getMediosContacto();
        $info['acciones']            = $this->funciones_model->getAccionesRequisicion();
        $info['puestos']             = $this->funciones_model->getPuestos();
        $info['paises']              = $this->funciones_model->getPaises();
        $info['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
        $vista['modals']   = $this->load->view('modals/mdl_reclutamiento', $info, true);

        $notificaciones = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0, 1]);
        if (! empty($notificaciones)) {
            $contador = 0;
            foreach ($notificaciones as $row) {
                if ($row->visto == 0) {
                    $contador++;
                }
            }
            $data['contadorNotificaciones'] = $contador;
        }

        $headerView      = $this->load->view('adminpanel/header', $data, true);
        $scriptsView     = $this->load->view('adminpanel/scripts', $modales, true);
        $requisicionView = $this->load->view('reclutamiento/control', $vista, true);
        $footerView      = $this->load->view('adminpanel/footer', [], true);

        echo $scriptsView;
        echo $requisicionView; // Si decides que esta vista sí debe mostrarse
        echo $footerView;
    }

    public function finalizados()
    {
        $data['permisos']   = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config           = $this->funciones_model->getConfiguraciones();
        $data['version']  = $config->version_sistema;
        //Dependiendo el rol del usuario se veran todas o sus propias requisiciones
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $condicion  = 'R.id_usuario';
        } else {
            $id_usuario = 0;
            $condicion  = 'R.id_usuario >=';
        }
        $reqs                        = $this->reclutamiento_model->getRequisicionesFinalizadas($id_usuario, $condicion);
        $data['reqs']                = $reqs;
        $info['reqs']                = $reqs;
        $info['medios']              = null;
        $info['acciones']            = null;
        $info['paises']              = null;
        $info['paquetes_antidoping'] = null;
        //$info['acciones'] = $this->funciones_model->getAccionesRequisicion();
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
        $vista['modals']   = $this->load->view('modals/mdl_reclutamiento', $info, true);
        $notificaciones    = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0, 1]);
        if (! empty($notificaciones)) {
            $contador = 0;
            foreach ($notificaciones as $row) {
                if ($row->visto == 0) {
                    $contador++;
                }
            }
            $data['contadorNotificaciones'] = $contador;
        }

        $headerView      = $this->load->view('adminpanel/header', $data, true);
        $scriptsView     = $this->load->view('adminpanel/scripts', $modales, true);
        $requisicionView = $this->load->view('reclutamiento/finalizados', $vista, true);
        $footerView      = $this->load->view('adminpanel/footer', [], true);

        echo $scriptsView;
        echo $requisicionView; // Si decides que esta vista sí debe mostrarse
        echo $footerView;
    }

    public function bolsa()
    {
        $data['permisos']   = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config           = $this->funciones_model->getConfiguraciones();
        $data['version']  = $config->version_sistema;
        //Filtros de busqueda y ordenamiento
        if (isset($_GET['sort']) && $_GET['sort'] != 'none') {
            $getSort = $_GET['sort'];
            switch ($getSort) {
                case 'ascending':
                    $sort = 'ASC';
                    break;
                case 'descending':
                    $sort = 'DESC';
                    break;
                default:
                    $sort = 'DESC';
                    break;
            }
        } else {
            $sort    = 'DESC';
            $getSort = '';
        }
        if (isset($_GET['filter']) && $_GET['filter'] != 'none') {
            $getFilter = $_GET['filter'];

            // "Todos" => no filtra por status
            if ($getFilter === 'Todos') {
                $filter          = null;
                $filterApplicant = '';
            }

            if ($getFilter === 'En espera') {
                $filter          = 1;
                $filterApplicant = 'B.status';
            }
            if ($getFilter === 'En Proceso / Aprobado') {
                $filter          = 2;
                $filterApplicant = 'B.status';
            }
            if ($getFilter === 'Reutilizable') {
                $filter          = 3;
                $filterApplicant = 'B.status';
            }
            if ($getFilter === 'Preempleo / Contratado') {
                $filter          = 4;
                $filterApplicant = 'B.status';
            }
            if ($getFilter === 'Aprobado con Acuerdo') {
                $filter          = 5;
                $filterApplicant = 'B.status';
            }
            if ($getFilter === 'Bloqueado') { // <- status 0
                $filter          = 0;
                $filterApplicant = 'B.status';
            }
        } else {
            $getFilter       = '';
            $filter          = null;
            $filterApplicant = '';
        }

        if (isset($_GET['user'])) {
            $user    = $_GET['user'];
            $getUser = $_GET['user'];
            if ($user != '') {
                $idUser         = ($user > 0) ? $user : 0;
                $condition_user = ($user > 0) ? 'B.id_usuario' : 'B.id_usuario >=';
            } else {
                $idUser         = 0;
                $condition_user = 'B.id >';
            }
        } else {
            $idUser         = 0;
            $condition_user = 'B.id >';
            $getUser        = '';
        }
        if (isset($_GET['area']) && $_GET['area'] != 'none') {
            $area    = $_GET['area'];
            $getArea = $_GET['area'];
            if ($area !== '') {
                $area_interest  = $area;
                $condition_area = 'B.area_interes';
            } else {
                $area_interest  = '';
                $condition_area = 'B.area_interes !=';
            }
        } else {
            $area_interest  = '';
            $condition_area = 'B.area_interes !=';
            $getArea        = '';
        }
        if (isset($_GET['applicant'])) {
            $applicant = $_GET['applicant'];
            if ($applicant != '') {
                $id_applicant        = ($applicant > 0) ? $applicant : 0;
                $condition_applicant = ($applicant > 0) ? 'B.id' : 'B.id >';
            } else {
                $id_applicant        = 0;
                $condition_applicant = 'B.id >';
            }
        } else {
            $id_applicant        = 0;
            $condition_applicant = 'B.id >';
        }

        //Dependiendo el rol del usuario se veran todas o sus propias requisiciones
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario        = $this->session->userdata('id');
            $info['registros'] = $this->reclutamiento_model->getApplicantsByUser($sort, $id_applicant, $condition_applicant, $filter, $filterApplicant, $id_usuario, $area_interest, $condition_area);
            $condition         = 'B.id_usuario';
        } else {
            $info['registros'] = $this->reclutamiento_model->getBolsaTrabajo($sort, $id_applicant, $condition_applicant, $filter, $filterApplicant, $idUser, $condition_user, $area_interest, $condition_area);
            $id_usuario        = 0;
            $condition         = 'B.id_usuario >=';
        }
        $info['sortApplicant'] = $getSort;
        $info['filter']        = $getFilter;
        $info['assign']        = $getUser;
        $info['area']          = $getArea;

        $info['civiles']             = $this->funciones_model->getEstadosCiviles();
        $info['grados']              = $this->funciones_model->getGradosEstudio();
        $info['medios']              = $this->funciones_model->getMediosContacto();
        $info['puestos']             = $this->funciones_model->getPuestos();
        $info['paises']              = $this->funciones_model->getPaises();
        $info['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
        $info['reqs']                = null;
        $info['acciones']            = null;
        //Obtiene los usuarios con id rol 4 y 11 que pertencen a reclutadores y coordinadores de reclutadores
        $info['usuarios_asignacion']  = $this->usuario_model->getTipoUsuarios([4, 11]);
        $info['registros_asignacion'] = $this->reclutamiento_model->getAllApplicants($id_usuario, $condition);
        $info['areas_interes']        = $this->reclutamiento_model->getAllJobPoolByArea();
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
        $vista['modals']   = $this->load->view('modals/mdl_reclutamiento', $info, true);
        /*
        echo'<pre>'; 
        print_r($info['registros']);
        echo'</pre>';
        die(); */
        $notificaciones = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0, 1]);
        if (! empty($notificaciones)) {
            $contador = 0;
            foreach ($notificaciones as $row) {
                if ($row->visto == 0) {
                    $contador++;
                }
            }
            $data['contadorNotificaciones'] = $contador;
        }

        $headerView      = $this->load->view('adminpanel/header', $data, true);
        $scriptsView     = $this->load->view('adminpanel/scripts', $modales, true);
        $requisicionView = $this->load->view('reclutamiento/bolsa_trabajo', $vista, true);
        $footerView      = $this->load->view('adminpanel/footer', [], true);

        echo $scriptsView;
        echo $requisicionView; // Si decides que esta vista sí debe mostrarse
        echo $footerView;
    }
    public function getLinkEmpleado()
    {
        $id_empleado = (int) $this->input->get('id_empleado');
        $this->output->set_content_type('application/json');

        if (! $id_empleado) {
            return $this->output->set_output(json_encode(['success' => false, 'error' => 'Falta id_empleado']));
        }

        $row = $this->reclutamiento_model->getLastLinkEmpleado($id_empleado);
        if (! $row) {
            return $this->output->set_output(json_encode(['success' => true, 'exists' => false]));
        }

        // Calcula estado
        $now    = time();
        $status = 'Activo';
        if ((int) $row->eliminado === 1 || ! empty($row->revoked_at)) {
            $status = 'Revocado';
        } elseif ((int) $row->is_used === 1) {
            $status = 'Usado';
        } elseif (! empty($row->exp_unix) && $now > (int) $row->exp_unix) {
            $status = 'Expirado';
        }

        return $this->output->set_output(json_encode([
            'success' => true,
            'exists'  => true,
            'row'     => $row,
            'status'  => $status,
            'now'     => $now,
        ]));
    }

    /*----------------------------------------*/
    /*    Acciones
    /*----------------------------------------*/
    public function cambiarStatusrequisicion()
    {
        $id     = $this->input->post('id');
        $status = $this->input->post('status');

        $id_usuario = $this->session->userdata('id');
        $usuario    = [
            'status'     => $status,
            'id_usuario' => $id_usuario,
        ];

        $resultado = $this->reclutamiento_model->cambiarStatusrequisicion($id, $usuario);

        // Manejar los diferentes resultados retornados por el modelo
        if (strpos($resultado, 'Error') !== false) {
            // Si el resultado contiene la palabra "Error", se considera un error
            $msj = [
                'codigo' => 0,
                'msg'    => $resultado, // Mensaje de error específico
            ];
        } else {
            // Si no hay "Error", se asume que la actualización fue exitosa
            $msj = [
                'codigo' => 1,
                'msg'    => $resultado, // Mensaje de éxito
            ];
        }

        echo json_encode($msj);
    }

    public function reactivarRequisicion()
    {
        $id      = $this->input->post('id');
        $usuario = $this->session->userdata('id');
        $this->reclutamiento_model->reactivarRequisicion($id, $usuario);
        $msj = [
            'codigo' => 1,
            'msg'    => 'Se  a creado  una copia  de esta  Requisición para  que se  inicie el proceso ',
        ];
        echo json_encode($msj);
    }

    public function addApplicant()
    {
        // 1) Validación base (ajusta 'medio' según si es obligatorio u opcional)
        $this->form_validation->set_rules('requisicion', t('rec_prog_app_rule_requisition', 'Asignar requisición'), 'required|integer');
        $this->form_validation->set_rules('nombre', t('rec_prog_app_rule_name', 'Nombre(s)'), 'required|trim');
        $this->form_validation->set_rules('paterno', t('rec_prog_app_rule_lastname1', 'Primer apellido'), 'required|trim');
        $this->form_validation->set_rules('materno', t('rec_prog_app_rule_lastname2', 'Segundo apellido'), 'trim');
        $this->form_validation->set_rules('domicilio', t('rec_prog_app_rule_address', 'Localización o domicilio'), 'required|trim');
        $this->form_validation->set_rules('area_interes', t('rec_prog_app_rule_interest', 'Área de interés'), 'required|trim');
        // Si 'medio' viene como "null" desde el front, considera hacerlo opcional o valida con callback
        $this->form_validation->set_rules('medio', t('rec_prog_app_rule_contact_method', 'Medio de contacto'), 'trim');
        $this->form_validation->set_rules('telefono', t('rec_prog_app_rule_phone', 'Teléfono'), 'trim|max_length[16]');
        $this->form_validation->set_rules('correo', t('rec_prog_app_rule_email', 'Correo'), 'trim|valid_email');

        $this->form_validation->set_message('required', t('rec_val_required', 'El campo {field} es obligatorio'));
        $this->form_validation->set_message('max_length', t('rec_val_max_length', 'El campo {field} debe tener máximo {param} carácteres'));
        $this->form_validation->set_message('valid_email', t('rec_val_valid_email', 'El campo {field} debe ser un correo válido'));
        $this->form_validation->set_message('integer', t('rec_val_integer', 'El campo {field} debe ser numérico'));

        if ($this->form_validation->run() === false) {
            echo json_encode(['codigo' => 0, 'msg' => validation_errors()]);
            return;
        }

        // 2) Normaliza entradas
        $date       = date('Y-m-d H:i:s');
        $id_portal  = (int) $this->session->userdata('idPortal');
        $id_usuario = (int) $this->session->userdata('id');
        $idRol      = (int) $this->session->userdata('idrol');

        $req              = (int) $this->input->post('requisicion', true);
        $nombre           = strtoupper((string) $this->input->post('nombre', true));
        $paterno          = strtoupper((string) $this->input->post('paterno', true));
        $materno          = strtoupper((string) $this->input->post('materno', true));
        $domicilio        = (string) $this->input->post('domicilio', true);
        $area_interes     = (string) $this->input->post('area_interes', true);
        $telefono         = (string) $this->input->post('telefono', true);
        $correo           = (string) $this->input->post('correo', true);
        $id_aspirante     = (int) $this->input->post('id_aspirante', true);
        $id_bolsa_trabajo = (int) $this->input->post('id_bolsa_trabajo', true);

        // "null" (string) -> NULL real
        $medio = $this->input->post('medio', true);
        if ($medio === 'null' || $medio === 'NULL' || $medio === '' || $medio === null) {
            $medio = null;
        }

        // 3) Verifica que la requisición exista (evita FK error)
        $existsReq = $this->reclutamiento_model->existsRequisitionInPortal($req, $id_portal);
        if (! $existsReq) {
            echo json_encode([
                'codigo' => 0,
                'msg'    => t(
                    'rec_prog_app_req_not_found',
                    "La requisición {$req} no existe o no pertenece a este portal"
                ),
            ]);
            return;
        }

        $notificacion   = 0;
        $nombre_archivo = null;

        // 4) Alta/edición
        if ($id_aspirante <= 0) {

            // ---- Alta en bolsa (nuevo o edición de bolsa existente) ----
            if ($id_bolsa_trabajo <= 0) {
                $jobPool = [
                    'creacion'       => $date,
                    'edicion'        => $date,
                    'id_portal'      => $id_portal,
                    'id_usuario'     => $id_usuario,
                    'nombre'         => $nombre,
                    'paterno'        => $paterno,
                    'materno'        => $materno,
                    'telefono'       => $telefono,
                    'medio_contacto' => $medio, // <- puede ser NULL
                    'area_interes'   => $area_interes,
                    'domicilio'      => $domicilio,
                    'status'         => 2,
                ];
                $id_bolsa_trabajo = (int) $this->reclutamiento_model->addJobPoolWithIdReturned($jobPool);
            } else {
                $bolsa = [
                    'id_portal'      => $id_portal,
                    'edicion'        => $date,
                    'nombre'         => $nombre,
                    'paterno'        => $paterno,
                    'materno'        => $materno,
                    'telefono'       => $telefono,
                    'medio_contacto' => $medio, // <- puede ser NULL
                    'area_interes'   => $area_interes,
                    'domicilio'      => $domicilio,
                    'status'         => 2,
                ];
                if ($idRol != 6) {
                    $bolsa['id_usuario'] = $id_usuario;
                }
                $this->reclutamiento_model->editBolsaTrabajo($bolsa, $id_bolsa_trabajo);
            }

            // Evita duplicado de relación bolsa–requisición
            if ($this->reclutamiento_model->existeRegistro($id_bolsa_trabajo, $req)) {
                echo json_encode([
                    'codigo' => 0,
                    'msg'    => t('rec_prog_app_already_registered', 'Ya está registrado el aspirante para esta requisición'),
                ]);
                return;
            }

            // ---- Inserta en requisicion_aspirante (con transacción y captura de error) ----
            $datos = [
                'creacion'         => $date,
                'edicion'          => $date,
                'id_usuario'       => $id_usuario,
                'id_bolsa_trabajo' => $id_bolsa_trabajo,
                'id_requisicion'   => $req, // <- FK: ya validamos que existe
                'correo'           => $correo,
                'cv'               => $nombre_archivo,
                'status'           => t('rec_prog_status_registered', 'Registrado'),
            ];

            $res = $this->reclutamiento_model->addApplicant($datos); // ideal: que devuelva ['ok','id','db_error','sql']

            if (is_array($res)) {
                if (! empty($res['db_error'])) {
                    log_message('error', 'addApplicant error: ' . print_r($res['db_error'], true) . ' SQL: ' . $res['sql']);
                    echo json_encode(['codigo' => 0, 'msg' => t('rec_prog_app_db_error', 'No se pudo registrar el aspirante (error BD).')]);
                    return;
                }
                $id_req_aspirante = $res['id'] ?? 0;
            } else {
                $id_req_aspirante = (int) $res;
                if ($id_req_aspirante <= 0) {
                    echo json_encode(['codigo' => 0, 'msg' => t('rec_prog_app_save_fail', 'No se pudo registrar el aspirante.')]);
                    return;
                }
            }

            // Marca bolsa en “2”
            if ($id_bolsa_trabajo > 0) {
                $this->reclutamiento_model->editBolsaTrabajo(['status' => 2], $id_bolsa_trabajo);
            }

            // Notificación (si aplica)
            if ($id_req_aspirante && $notificacion > 0) {
                // ... tu bloque de notificación (igual que lo tienes) ...
            }

            echo json_encode([
                'codigo' => 1,
                'msg'    => t('rec_prog_app_saved_ok', 'El aspirante fue guardado correctamente.'),
            ]);
            return;

        } else {

            // ---- Actualización de aspirante existente ----
            $datos_rh = [
                'id_requisicion' => $req,
                'correo'         => $correo,
            ];
            $datos_bt = [
                'id_portal'      => $id_portal,
                'edicion'        => $date,
                'nombre'         => $nombre,
                'paterno'        => $paterno,
                'materno'        => $materno,
                'telefono'       => $telefono,
                'medio_contacto' => $medio, // <- puede ser NULL
                'area_interes'   => $area_interes,
                'domicilio'      => $domicilio,
            ];

            if (! $existsReq) {
                echo json_encode([
                    'codigo' => 0,
                    'msg'    => t(
                        'rec_prog_app_req_not_found',
                        "La requisición {$req} no existe o no pertenece a este portal"
                    ),
                ]);
                return;
            }

            $ok = $this->reclutamiento_model->editarDatosAspiranteBolsa(
                $datos_bt,
                $id_bolsa_trabajo,
                $datos_rh,
                $id_aspirante
            );

            echo json_encode([
                'codigo' => $ok ? 1 : 0,
                'msg'    => $ok
                    ? t('rec_prog_app_updated_ok', 'El aspirante fue actualizado correctamente :)')
                    : t('rec_prog_app_updated_fail', 'El aspirante no pudo ser actualizado :('),
            ]);
            return;
        }
    }

    public function guardarAccionRequisicion()
    {
        $this->form_validation->set_rules('accion', 'Acción a aplicar', 'required|trim');
        $this->form_validation->set_rules('comentario', 'Comentario / Descripción / Fecha y lugar', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date             = date('Y-m-d H:i:s');
            $estatus_final    = null;
            $comentario       = $this->input->post('comentario');
            $id_usuario       = $this->session->userdata('id');
            $id_portal        = $this->session->userdata('idPortal');
            $id_aspirante     = $this->input->post('id_aspirante');
            $id_requisicion   = $this->input->post('id_requisicion');
            $accion           = explode(':', $this->input->post('accion'));
            $otra_accion      = $this->input->post('otra_accion');
            $aspirante        = $this->reclutamiento_model->getAspiranteById($id_aspirante);
            $idRol            = $this->session->userdata('idrol');
            $estatusProceso   = $this->input->post('estatus_proceso');
            $estatusAspirante = $this->input->post('estatus_aspirante');
            $notificacion     = 0;
            // Determinar estatus final
            if ($estatusProceso == 3) {
                $estatus_final = 'CANCELADO';
                $status        = ! empty($accion[1]) ? $accion[1] : $otra_accion;
            } elseif ($estatusProceso == 2) {
                $estatus_final = null;
                $status        = ! empty($accion[1]) ? $accion[1] : $otra_accion;
            } elseif ($estatusProceso == 1) {
                $estatus_final = 'COMPLETADO';
                $status        = ! empty($accion[1]) ? $accion[1] : $otra_accion;

            } else {
                $estatus_final = null;
                $status        = ! empty($accion[1]) ? $accion[1] : $otra_accion;

            }

            if (! empty($otra_accion)) {
                $datos_nuevaAccion = [
                    'creacion'    => $date,
                    'edicion'     => $date,
                    'id_usuario'  => $id_usuario,
                    'id_portal'   => $id_portal,
                    'descripcion' => $otra_accion,
                ];

                $nuevaAccionResult = $this->reclutamiento_model->registrarNuevaAccion($datos_nuevaAccion);

            }

            $datos_accion = [
                'creacion'         => $date,
                'id_usuario'       => $id_usuario,
                'id_requisicion'   => $id_requisicion,
                'id_bolsa_trabajo' => $aspirante->id_bolsa_trabajo,
                'id_aspirante'     => $id_aspirante,
                'accion'           => ! empty($accion[1]) ? $accion[1] : $otra_accion,
                'descripcion'      => $comentario,
            ];

            $data_aspirante = [
                'edicion'      => $date,

                'status'       => $status,
                'status_final' => $estatus_final,
            ];
            if ($idRol != 6) {
                $data_aspirante['id_usuario'] = $id_usuario;
            }

            // Determinar estatus de bolsa de trabajo
            switch ($estatusAspirante) {
                case 0:
                    $estatus_bolsa = 0;
                    $semaforo      = 0;
                    break;
                case 1:
                    $estatus_bolsa = 1;
                    $semaforo      = 0;
                    break;
                case 2:
                    $estatus_bolsa = 2;
                    $semaforo      = 0;
                    break;
                case 3:
                    $estatus_bolsa = 3;
                    $semaforo      = 0;
                    break;
                case 4:
                    $estatus_bolsa = 4;
                    $semaforo      = 0;
                    break;
            }

            $data_bolsa = [
                'edicion'  => $date,
                'status'   => $estatus_bolsa,
                'semaforo' => $semaforo,
            ];

            // Realizar todas las operaciones en una transacción
            $result = $this->reclutamiento_model->registrarMovimiento($datos_accion, $data_aspirante, $data_bolsa, $aspirante->id_bolsa_trabajo, $id_aspirante);
            if ($result) {
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'Accion registrada  correctamente ',
                ];
                /*  funcion  para  integrar  whats APP 
            if ($result && $notificacion > 0) {
                $result2 = $this->notificaciones_whatsapp_model->obtenerDatosPorRequisicionAspirante($id_aspirante);

                // Verifica que el resultado no sea NULL y que sea un objeto
                if ($result2) {
                    $datos_plantilla = array(
                        'nombre_cliente' => $result2->nombre_cliente, // Asigna el nombre del cliente
                        'nombre_aspirante' => $result2->nombre_completo, // Asigna el nombre completo del aspirante
                        'vacante' => $result2->vacante, // Asigna la vacante
                        'telefono' => $result2->phone,
                        'ruta' => 'send-message-movimiento', // Asigna el teléfono
                    );

                    $api_response = $this->notificaciones_whatsapp_model->alertaMovimientoApirante('52' . $result2->phone, 'movimiento_apirante', $datos_plantilla); // Reemplaza con los valores correctos

                    if ($api_response['codigo'] == 1) {
                        $msj = array(
                            'codigo' => 1,
                            'msg' => 'El registro se realizó correctamente. se notofico al cliente via whatsapp',
                        );
                    } else {
                        $msj = array(
                            'codigo' => 0,
                            'msg' => $api_response['msg'],
                        );
                    }
                }
                // Llamar a la API si las operaciones fueron exitosas

            } else {
                $msj = array(
                    'codigo' => 0,
                    'msg' => 'Error al realizar las operaciones en la base de datos',
                );
            } */
            } else {
                $msj = [
                    'codigo' => 0,
                    'msg'    => 'Hubo un problema  se  registro la accion  ',
                ];
            }
        }

        echo json_encode($msj);
    }

    public function guardarEstatusRequisicion()
    {
        $this->form_validation->set_rules('id_requisicion', 'Requisición', 'required|trim');
        $this->form_validation->set_rules('estatus', 'Estatus a asignar', 'required|trim');
        $this->form_validation->set_rules('comentario', 'Comentarios', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date           = date('Y-m-d H:i:s');
            $comentario     = $this->input->post('comentario');
            $id_usuario     = $this->session->userdata('id');
            $estatus_final  = $this->input->post('estatus');
            $id_requisicion = $this->input->post('id_requisicion');
            $idRol          = $this->session->userdata('idrol');

            //Cancela Requisicion
            if ($estatus_final == 0) {
                $status   = 'status';
                $acciones = 1;

                $condicion          = 'A.id_usuario >';
                $data['aspirantes'] = $this->reclutamiento_model->getAspirantesPorRequisicion($id_usuario, $condicion, $id_requisicion);
                if ($data['aspirantes']) {
                    foreach ($data['aspirantes'] as $row) {
                        $bolsa = [
                            'edicion' => $date,
                            'status'  => 1,
                        ];
                        $this->reclutamiento_model->editBolsaTrabajo($bolsa, $row->id_bolsa_trabajo);
                    }
                }
                $datos = [
                    'edicion'          => $date,
                    'id_usuario'       => $id_usuario,
                    $status            => $estatus_final,
                    'comentario_final' => $comentario,
                ];

                $this->reclutamiento_model->editarRequisicion($datos, $id_requisicion);
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'La requisición fue cancelada correctamente',
                ];
            }
            //Se elimina la requisicion
            if ($estatus_final == 1) {
                $status             = 'eliminado';
                $acciones           = 1;
                $id_usuario         = 0;
                $condicion          = 'A.id_usuario >';
                $data['aspirantes'] = $this->reclutamiento_model->getAspirantesPorRequisicion($id_usuario, $condicion, $id_requisicion);
                if ($data['aspirantes']) {
                    foreach ($data['aspirantes'] as $row) {
                        $bolsa = [
                            'edicion' => $date,
                            'status'  => 1,
                        ];
                        $this->reclutamiento_model->editBolsaTrabajo($bolsa, $row->id_bolsa_trabajo);
                    }
                }
                $datos = [
                    'edicion'          => $date,

                    $status            => $estatus_final,
                    'comentario_final' => $comentario,
                ];

                if ($idRol != 6) {
                    $datos['id_usuario'] = $id_usuario;
                }
                $this->reclutamiento_model->editarRequisicion($datos, $id_requisicion);
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'La requisición fue eliminada correctamente',
                ];
            }
            //Termina o finaliza Requisicion
            if ($estatus_final == 3) {
                $status         = 'status';
                $acciones       = ['FINALIZADO', 'COMPLETADO', 'ESE FINALIZADO'];
                $faltantes      = [];
                $num_aspirantes = $this->reclutamiento_model->getVacantesCubiertasTotal($id_requisicion, $acciones);
                $requisicion    = $this->reclutamiento_model->getRequisionById($id_requisicion);

                // Candidatos completos
                $candidatos_completos = [];
                $faltantes_candidatos = [];

                $data['candidatos'] = $this->reclutamiento_model->getCandidatosByRequisicion($id_requisicion);
                if ($data['candidatos']) {
                    foreach ($data['candidatos'] as $row) {
                        $nombre = (isset($row->nombre) && trim($row->nombre) !== '') ? $row->nombre : null;
                        if (is_null($nombre)) {
                            continue;
                        }

                        $completo = true;
                        if (empty($row->sueldo)) {
                            $completo = false;
                        }

                        if (empty($row->fecha_ingreso)) {
                            $completo = false;
                        }

                        if ($completo) {
                            $candidatos_completos[] = $row;
                        } else {
                            $msg = [];
                            if (empty($row->sueldo)) {
                                $msg[] = "no tiene registrado el sueldo acordado.";
                            }

                            if (empty($row->fecha_ingreso)) {
                                $msg[] = "no tiene registrada la fecha de ingreso.";
                            }

                            $faltantes_candidatos[] = "El candidato <b>$nombre</b> " . implode(' ', $msg);
                        }
                    }
                }

                // ¿Hay suficientes completos?
                if (count($candidatos_completos) >= $requisicion->numero_vacantes) {
                    // Puedes cerrar la requisición
                    $datos = [
                        'edicion'          => $date,
                        $status            => $estatus_final,
                        'comentario_final' => $comentario,
                    ];
                    if ($idRol != 6) {
                        $datos['id_usuario'] = $id_usuario;
                    }
                    $this->reclutamiento_model->editarRequisicion($datos, $id_requisicion);
                    $msj = [
                        'codigo' => 1,
                        'msg'    => 'La requisición fue terminada correctamente',
                    ];
                } else {
                    // Faltan candidatos completos
                    $faltan      = $requisicion->numero_vacantes - count($candidatos_completos);
                    $faltantes   = [];
                    $faltantes[] = "Faltan $faltan vacantes por cubrir con candidatos completos.";
                    // Solo muestra los faltantes de los que no están completos
                    $faltantes = array_merge($faltantes, $faltantes_candidatos);

                    $msj = [
                        'codigo'    => 0,
                        'msg'       => 'No se puede cerrar la requisición porque falta información:',
                        'faltantes' => $faltantes,
                    ];
                }
            }

            // ... (tus otros bloques if para cancelar/eliminar/editar, igual que antes) ...
        }
        echo json_encode($msj);
    }
    // funcion para  eliminar Acciones submodulo en proceso mediante  el id  de la accion
    public function eliminarRegistro()
    {
        $id = $this->input->post('id');

        if ($id) {

            $eliminado = $this->reclutamiento_model->eliminarMovimiento($id); // Función del modelo que elimina

            if ($eliminado) {
                echo json_encode([
                    'status'  => true,
                    'mensaje' => 'El registro ha sido eliminado correctamente.',
                    'id'      => $id,
                ]);
            } else {
                echo json_encode([
                    'status'  => false,
                    'mensaje' => 'No se pudo eliminar el registro.',
                ]);
            }
        } else {
            echo json_encode([
                'status'  => false,
                'mensaje' => 'No se pudo eliminar el registro.',
            ]);
        }
    }

    public function getOrderPDF()
    {
        //* Llamada a la libreria de mpdf, iniciación de fechas y captura POST
        $mpdf = new \Mpdf\Mpdf();
        date_default_timezone_set('America/Mexico_City');
        $id = $_POST['idReq'];

        //* Detalles de la requisicion por ID
        $data['requisicion'] = $this->reclutamiento_model->getRequisionById($id);

        //* Vista PDF del reporte
        if ($this->session->userdata('idrol') == 4 || $this->session->userdata('idrol') == 11) {
            $html = $this->load->view('pdfs/reclutamiento/requisicion_detalles_pdf', $data, true);
        } else {
            $html = $this->load->view('pdfs/reclutamiento/requisicion_completa_pdf', $data, true);
        }

        //* Configuraciones del mPDF
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->SetHTMLHeader('<div style=""><img style="" src="' . base_url() . 'img/Encabezado.png"></div>');
        $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;"><div style="border-bottom:1px solid gray;"><b>Teléfono:</b> (33) 2301-8599 | <b>Correo:</b> hola@rodi.com.mx | <b>Sitio web:</b> rodi.com.mx</div><br>Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco, México. C.P. 45018 <br></p></div><div style="position: absolute; right: 10px;  bottom: 13px;"><img width="" src="' . base_url() . 'img/logo2.png"></div>');
        //$nombreArchivo = substr( md5(microtime()), 1, 12);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Req' . $id . '.pdf', 'D');
    }

    // application/controllers/Reclutamiento.php

    // application/controllers/Reclutamiento.php

    public function getOrderPDFIntake()
    {
        $mpdf = new \Mpdf\Mpdf([
            'mode'          => 'utf-8',
            'format'        => 'A4',
            'margin_top'    => 42, // espacio para header
            'margin_bottom' => 36, // espacio para footer
            'margin_left'   => 12,
            'margin_right'  => 12,
        ]);
        date_default_timezone_set('America/Mexico_City');

        $id     = (int) $this->input->post('idReq');
        $intake = $this->reclutamiento_model->getDetailsOrderByIdIntake($id);
        if (! $intake) {show_error('No se encontró el intake.', 404);return;}

        // === Datos del portal para header/footer ===
        $datosFooter = $this->cat_portales_model->getDatosPortal();
        // puede venir array de objetos o un objeto suelto
        $pf = is_array($datosFooter) ? (reset($datosFooter) ?: null): (is_object($datosFooter) ? $datosFooter : null);

        $portalName = trim($pf->nombre_portal ?? '') ?: 'RODI';
        $portalTel  = trim($pf->telefono ?? '') ?: 'N/D';
        $portalMail = trim($pf->correo ?? '') ?: 'N/D';
        $portalWeb  = parse_url(base_url(), PHP_URL_HOST) ?: 'N/D'; // p.ej. rodi.com.mx

        // === URLs para documentos (respeta absolutas) ===
        $mkUrl = function ($base, $fname) {
            if (empty($fname)) {
                return '';
            }

            if (preg_match('~^https?://~i', $fname) || strpos($fname, '/') === 0) {
                return $fname;
            }

            return rtrim($base, '/') . '/' . $fname;
        };
        $intake->archivo_url  = $mkUrl(LINKDOCREQUICICION, $intake->archivo_path ?? '');
        $intake->terminos_url = $mkUrl(LINKAVISOS, $intake->terminos_file ?? '');
        $data['intake']       = $intake;

        // === Branding / logo ===
        $brand = '#0C9DD3';
        $logo  = $this->session->userdata('logo') ?: 'logo_nuevo.png';
        if (! is_file(FCPATH . '_logosPortal/' . $logo)) {$logo = 'logo_nuevo.png';}
        $logoUrl = base_url('_logosPortal/' . $logo);
        $hoy     = date('d/m/Y');

        // === Header (usa nombre del portal) ===
        $headerHtml = '
            <div style="background:' . $brand . '; color:#fff; padding:10px 12px;">
                <table width="100%" style="border-collapse:collapse;">
                <tr>
                    <td style="width:52px; vertical-align:middle;">
                    <img src="' . $logoUrl . '" alt="Logo" style="max-width:220px; max-height:120px; background:#fff;">
                    </td>
                    <td style="vertical-align:middle; text-align:center;">
                    <div style="font-weight:900; font-size:50px; color: white; text-align: center;">' . htmlspecialchars($portalName) . '</div>
                    <div style="font-size:18px; opacity:.95; color: white;">Reporte de Solicitud</div>
                    </td>
                    <td style="text-align:right; font-size:10px; vertical-align:middle; color: white; ">
                    Folio: ' . $id . '<br>
                    Fecha: ' . $hoy . '
                    </td>
                </tr>
                </table>
            </div>
            ';

        // === Footer (usa nombre portal, tel y correo; N/D si no hay) ===
        $footerHtml = '
            <div style="font-size:9px; color:#4b5563;">
                <table width="100%" style="border-collapse:collapse;">
                <tr>
                    <td style="color:' . $brand . '; font-weight:700;">
                    ' . htmlspecialchars($portalName) . '
                    </td>
                    <td style="text-align:right;">
                    Página {PAGENO} de {nbpg}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="border-top:1px solid #d1d5db; padding-top:4px;">
                    Tel: ' . htmlspecialchars($portalTel) . ' &nbsp; | &nbsp;
                    Correo: ' . htmlspecialchars($portalMail) . ' &nbsp; | &nbsp;
                    Web: ' . htmlspecialchars($portalWeb) . '
                    </td>
                </tr>
                </table>
            </div>
            ';

        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->SetHTMLHeader($headerHtml);
        $mpdf->SetHTMLFooter($footerHtml);

        // Render vista
        $html = $this->load->view('pdfs/reclutamiento/intake_pdf', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output('Solicitud_' . $id . '.pdf', 'D');
    }

public function cambiarStatusBolsaTrabajo()
{
    date_default_timezone_set('America/Mexico_City');
    $date       = date('Y-m-d H:i:s');
    $id_usuario = $this->session->userdata('id');
    $idRol      = $this->session->userdata('idrol');
    $id_bolsa   = $this->input->post('id_bolsa');
    $comentario = $this->input->post('comentario');
    $accion     = $this->input->post('accion');
    $aspirante  = $this->reclutamiento_model->getAspiranteByBolsaTrabajo($id_bolsa);
    $msj        = []; // Inicializa $msj como un array vacío

    if ($comentario != '') {
        if ($aspirante != null) {
            $aspirante_data = [
                'edicion'      => $date,
                'status'       => t('rec_prog_bolsa_status_blocked_text', 'Bloqueado del proceso de reclutamiento'),
                'status_final' => 'BLOQUEADO',
            ];
            if ($idRol != 6) {
                $datos['id_usuario'] = $id_usuario; // (se deja tal cual estaba en tu código)
            }
            $this->reclutamiento_model->editarAspirante($aspirante_data, $aspirante->id);

            $historial = [
                'creacion'         => $date,
                'id_usuario'       => $id_usuario,
                'id_requisicion'   => $aspirante->id_requisicion,
                'id_bolsa_trabajo' => $id_bolsa,
                'id_aspirante'     => $aspirante->id,
                'accion'           => t(
                    'rec_prog_bolsa_hist_action_user_blocks',
                    'Usuario bloquea a la persona del proceso de reclutamiento'
                ),
                'descripcion'      => $comentario,
            ];
            $this->reclutamiento_model->guardarAccionRequisicion($historial);
        }

        // Cambiar estado de la bolsa de trabajo
        $bolsa = [
            'status' => ($accion == 'bloquear') ? 0 : 1,
        ];
        $this->reclutamiento_model->editBolsaTrabajo($bolsa, $id_bolsa);

        $msj = [
            'codigo' => 1,
            'msg'    => ($accion == 'bloquear')
                ? t('rec_prog_bolsa_block_ok', 'Se ha bloqueado correctamente')
                : t('rec_prog_bolsa_unblock_ok', 'Se ha desbloqueado correctamente'),
        ];
    } else {
        $msj = [
            'codigo' => 0,
            'msg'    => t(
                'rec_prog_bolsa_block_reason_required',
                'Debes llenar el motivo de bloqueo e intentarlo de nuevo'
            ),
        ];
    }

    echo json_encode($msj);
}


    public function guardarHistorialBolsaTrabajo()
    {
        // Configuración de las reglas de validación
        $this->form_validation->set_rules(
            'comentario',
            t('rec_prog_hist_field_comment_status', 'Comentario / Estatus'),
            'required|trim'
        );

        $this->form_validation->set_message(
            'required',
            t('rec_prog_val_required_msg', 'El campo {field} es obligatorio')
        );
        $this->form_validation->set_message(
            'max_length',
            t('rec_prog_val_max_length_msg', 'El campo {field} debe tener máximo {param} carácteres')
        );
        $this->form_validation->set_message(
            'numeric',
            t('rec_prog_val_numeric_msg', 'El campo {field} debe ser numérico')
        );

        // Inicializa el mensaje de respuesta
        $msj = [];

        // Verificar validación
        if ($this->form_validation->run() === false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            // Configuración de fecha y obtención de datos
            date_default_timezone_set('America/Mexico_City');
            $date       = date('Y-m-d H:i:s');
            $comentario = $this->input->post('comentario');
            $id_usuario = $this->session->userdata('id');
            $id_bolsa   = $this->input->post('id_bolsa');
            $tipo       = $this->session->userdata('tipo');

            // (se deja igual para no cambiar BD/lógica)
            $nombre       = ($tipo == 1) ? 'Reclutador' : 'Cliente';
            $notificacion = 0; // Cambia esto a 0 si quieres desactivar las notificaciones

            // Datos a guardar en el historial
            $datos = [
                'creacion'                 => $date,
                'id_usuario'               => $id_usuario,
                'id_requisicion_aspirante' => $id_bolsa,
                'nombre_rol'               => $nombre,
                'comentario'               => $comentario,
            ];

            // Guardar el historial en la base de datos
            $result = $this->reclutamiento_model->guardarHistorialBolsaTrabajo($datos);

            // Verificar si el guardado fue exitoso
            if ($result) {
                if ($notificacion > 0) {
                    // Obtener datos para notificación
                    if ($tipo == 1) {
                        $result2 = $this->notificaciones_whatsapp_model->obtenerDatosPorRequisicionAspirante($id_bolsa);

                        if ($result2 && ! empty($result2->phone)) {
                            $datos_plantilla = [
                                'nombre_cliente'   => $result2->nombre_cliente,
                                'nombre_aspirante' => $result2->nombre_completo,
                                'vacante'          => $result2->vacante,
                                'telefono'         => $result2->phone,
                                'ruta'             => 'send-message-comentario-reclu',
                            ];

                            $api_response = $this->notificaciones_whatsapp_model->alertaMovimientoApirante(
                                '52' . $result2->phone,
                                'mensaje_reclutador',
                                $datos_plantilla
                            );

                            if ($api_response['codigo'] == 1) {
                                $msj = [
                                    'codigo' => 1,
                                    'msg'    => t('rec_prog_hist_save_ok_prefix', 'El registro se realizó correctamente. ')
                                    . $api_response['msg'],
                                ];
                            } else {
                                $msj = [
                                    'codigo' => 0,
                                    'msg'    => $api_response['msg'],
                                ];
                            }
                        } else {
                            // Datos para notificación no válidos
                            $msj = [
                                'codigo' => 1,
                                'msg'    => t(
                                    'rec_prog_hist_notify_not_sent_no_data',
                                    'El registro se realizó correctamente. La notificación no fue enviada porque no se encontraron datos válidos para notificar.'
                                ),
                            ];
                        }

                    } else {
                        $result2 = $this->notificaciones_whatsapp_model->obtenerDatosPorRequisicionAspiranteCliente($id_bolsa);

                        if ($result2 && ! empty($result2->phone)) {
                            $datos_plantilla = [
                                'nombre_reclu'     => $result2->nombre_reclutador,
                                'nombre_cliente'   => $result2->nombre_cliente,
                                'nombre_aspirante' => $result2->nombre_completo,
                                'vacante'          => $result2->vacante,
                                'telefono'         => $result2->phone,
                                'ruta'             => 'send-message-comentario-cliente',
                            ];

                            $api_response = $this->notificaciones_whatsapp_model->alertaMovimientoApirante(
                                '52' . $result2->phone,
                                'mensaje_cliente',
                                $datos_plantilla
                            );

                            if ($api_response['codigo'] == 1) {
                                $msj = [
                                    'codigo' => 1,
                                    'msg'    => t('rec_prog_hist_save_ok_prefix', 'El registro se realizó correctamente. ')
                                    . $api_response['msg'],
                                ];
                            } else {
                                $msj = [
                                    'codigo' => 0,
                                    'msg'    => $api_response['msg'],
                                ];
                            }
                        } else {
                            // Datos para notificación no válidos
                            $msj = [
                                'codigo' => 1,
                                'msg'    => t(
                                    'rec_prog_hist_notify_not_sent_no_data',
                                    'El registro se realizó correctamente. La notificación no fue enviada porque no se encontraron datos válidos para notificar.'
                                ),
                            ];
                        }
                    }

                } else {
                    // Notificación desactivada
                    $msj = [
                        'codigo' => 1,
                        'msg'    => t(
                            'rec_prog_hist_notify_not_sent_disabled',
                            'El registro se realizó correctamente. La notificación no fue enviada.'
                        ),
                    ];
                }
            } else {
                // Fallo en el guardado
                $msj = [
                    'codigo' => 0,
                    'msg'    => t(
                        'rec_prog_hist_save_fail',
                        'No se pudo registrar el comentario, intente más tarde.'
                    ),
                ];
            }
        }

        // Enviar la respuesta como JSON
        echo json_encode($msj);
    }

    public function addRequisicion()
    {
        // 1) Idioma real que quieres usar (ya mapeado: 'english' o 'espanol')
        $idiom = $this->config->item('language') ?: 'espanol';

        // 2) Limpia SOLO las llaves del módulo (rec_) para evitar que se queden en español
        if (isset($this->lang->language) && is_array($this->lang->language)) {
            foreach (array_keys($this->lang->language) as $k) {
                if (strpos($k, 'rec_') === 0) {
                    unset($this->lang->language[$k]);
                }
            }
        }

        // 3) Permite recarga real del/los langfiles (CI3 no recarga si ya está en is_loaded)
        $toRemove = [
            'reclutamiento_escritorio_lang.php',
            'reclutamiento_progreso_lang.php',
            'reclutamiento_finalizadas_lang.php',
            'reclutamiento_bolsa_lang.php',
            'registro_candidatos_lang.php',
        ];

        if (isset($this->lang->is_loaded) && is_array($this->lang->is_loaded)) {
            $this->lang->is_loaded = array_values(array_diff($this->lang->is_loaded, $toRemove));
        }

        // 4) Recarga en el idioma correcto
        $this->lang->load('reclutamiento_escritorio', $idiom);
        $this->lang->load('reclutamiento_progreso', $idiom);
        $this->lang->load('reclutamiento_finalizadas', $idiom);
        $this->lang->load('reclutamiento_bolsa', $idiom);
        $this->lang->load('registro_candidatos', $idiom);

        // (Re)carga en el idioma correcto
        $this->lang->load('reclutamiento_escritorio', $idiom);
        $this->lang->load('reclutamiento_progreso', $idiom);
        $this->lang->load('reclutamiento_finalizadas', $idiom);
        $this->lang->load('reclutamiento_bolsa', $idiom);
        $this->lang->load('registro_candidatos', $idiom);

        $this->form_validation->set_rules('id_cliente', t('rec_req_field_branch', 'Sucursal'), 'required|trim');
        $this->form_validation->set_rules('nombre_comercial_req', t('rec_req_field_trade_name', 'Nombre comercial'), 'required|trim');
        $this->form_validation->set_rules('nombre_req', t('rec_req_field_business_name', 'Razón sociall'), 'required|trim');
        $this->form_validation->set_rules('correo_req', t('rec_req_field_email', 'Correo'), 'required|trim|valid_email');
        $this->form_validation->set_rules('cp_req', t('rec_req_field_postal_code', 'Código postal'), 'required|trim|max_length[5]');
        $this->form_validation->set_rules('telefono_req', t('rec_req_field_phone', 'Teléfono'), 'required|trim|max_length[16]');
        $this->form_validation->set_rules('contacto_req', t('rec_req_field_contact', 'Contacto'), 'trim|required');
        $this->form_validation->set_rules('rfc_req', t('rec_req_field_rfc', 'RFC'), 'trim|max_length[13]');
        $this->form_validation->set_rules('pais_req', t('rec_req_field_country', 'País'), 'trim');
        $this->form_validation->set_rules('estado_req', t('rec_req_field_state', 'Estado'), 'trim');
        $this->form_validation->set_rules('ciudad_req', t('rec_req_field_city', 'Ciudad'), 'trim');
        $this->form_validation->set_rules('colonia_req', t('rec_req_field_neighborhood', 'Colonia'), 'trim');
        $this->form_validation->set_rules('calle_req', t('rec_req_field_street', 'Calle'), 'trim');
        $this->form_validation->set_rules('interior_req', t('rec_req_field_int_number', 'Número Interior'), 'trim');
        $this->form_validation->set_rules('exterior_req', t('rec_req_field_ext_number', 'Número Exterior'), 'trim');
        $this->form_validation->set_rules('regimen_req', t('rec_req_field_tax_regime', 'Régimen Fiscal'), 'trim');
        $this->form_validation->set_rules('forma_pago_req', t('rec_req_field_payment_form', 'Forma de pago'), 'trim');
        $this->form_validation->set_rules('metodo_pago_req', t('rec_req_field_payment_method', 'Método de pago'), 'trim');
        $this->form_validation->set_rules('uso_cfdi_req', t('rec_req_field_cfdi_use', 'Uso de CFDI'), 'trim');

        $this->form_validation->set_rules('puesto_req', t('rec_req_field_position_name', 'Nombre de la posición'), 'required|trim');
        $this->form_validation->set_rules('numero_vacantes_req', t('rec_req_field_openings', 'Número de vacantes'), 'required|numeric|max_length[2]');
        $this->form_validation->set_rules('residencia_req', t('rec_req_field_residence', 'Lugar de residencia'), 'trim');
        $this->form_validation->set_rules('escolaridad_req', t('rec_req_field_education_required', 'Formación académica requerida'), 'trim');
        $this->form_validation->set_rules('estatus_escolaridad_req', t('rec_req_field_academic_status', 'Estatus académico'), 'trim');
        $this->form_validation->set_rules('otro_estatus_req', t('rec_req_field_other_academic_status', 'Otro estatus académico'), 'trim');
        $this->form_validation->set_rules('carrera_req', t('rec_req_field_degree_required', 'Carrera requerida para el puesto'), 'trim');
        $this->form_validation->set_rules('otros_estudios_req', t('rec_req_field_other_studies', 'Otros estudios'), 'trim');

        $this->form_validation->set_rules('idioma1_req', t('rec_req_field_language_1', 'Idioma 1'), 'trim');
        $this->form_validation->set_rules('por_idioma1_req', t('rec_req_field_language_1_percent', 'Porcentaje idioma 1'), 'trim');
        $this->form_validation->set_rules('idioma2_req', t('rec_req_field_language_2', 'Idioma 2'), 'trim');
        $this->form_validation->set_rules('por_idioma2_req', t('rec_req_field_language_2_percent', 'Porcentaje idioma 2'), 'trim');
        $this->form_validation->set_rules('idioma3_req', t('rec_req_field_language_3', 'Idioma 3'), 'trim');
        $this->form_validation->set_rules('por_idioma3_req', t('rec_req_field_language_3_percent', 'Porcentaje idioma 3'), 'trim');

        $this->form_validation->set_rules('habilidad1_req', t('rec_req_field_it_skill_1', 'Habilidad informática 1'), 'trim');
        $this->form_validation->set_rules('por_habilidad1_req', t('rec_req_field_it_skill_1_percent', 'Porcentaje habilidad 1'), 'trim');
        $this->form_validation->set_rules('habilidad2_req', t('rec_req_field_it_skill_2', 'Habilidad informática 2'), 'trim');
        $this->form_validation->set_rules('por_habilidad2_req', t('rec_req_field_it_skill_2_percent', 'Porcentaje habilidad 2'), 'trim');
        $this->form_validation->set_rules('habilidad3_req', t('rec_req_field_it_skill_3', 'Habilidad informática 3'), 'trim');
        $this->form_validation->set_rules('por_habilidad3_req', t('rec_req_field_it_skill_3_percent', 'Porcentaje habilidad 3'), 'trim');

        $this->form_validation->set_rules('genero_req', t('rec_req_field_gender', 'Sexo'), 'trim');
        $this->form_validation->set_rules('civil_req', t('rec_req_field_marital_status', 'Estado civil'), 'trim');
        $this->form_validation->set_rules('edad_minima_req', t('rec_req_field_min_age', 'Edad mínima'), 'max_length[2]');
        $this->form_validation->set_rules('edad_maxima_req', t('rec_req_field_max_age', 'Edad máxima'), 'max_length[2]');
        $this->form_validation->set_rules('licencia_req', t('rec_req_field_driver_license', 'Licencia de conducir'), 'trim');
        $this->form_validation->set_rules('licenctipo_licencia_reqia_req', t('rec_req_field_license_type', 'Tipo de licencia'), 'trim');
        $this->form_validation->set_rules('discapacidad_req', t('rec_req_field_disability', 'Discapacidad aceptable'), 'trim');
        $this->form_validation->set_rules('causa_req', t('rec_req_field_vacancy_cause', 'Causa que origina la vacante'), 'trim');

        $this->form_validation->set_rules('zona_req', t('rec_req_field_work_zone', 'Zona de trabajo'), 'required|trim');
        $this->form_validation->set_rules('tipo_sueldo_req', t('rec_req_field_salary_type', 'Sueldo'), 'required|trim');
        $this->form_validation->set_rules('sueldo_minimo_req', t('rec_req_field_min_salary', 'Sueldo mínimo'), 'numeric|max_length[8]');
        $this->form_validation->set_rules('sueldo_maximo_req', t('rec_req_field_max_salary', 'Sueldo máximo'), 'required|numeric|max_length[8]');
        $this->form_validation->set_rules('tipo_pago_req', t('rec_req_field_pay_frequency', 'Tipo de pago'), 'required');
        $this->form_validation->set_rules('tipo_prestaciones_req', t('rec_req_field_legal_benefits', '¿Tendrá prestaciones de ley?'), 'required');
        $this->form_validation->set_rules('experiencia_req', t('rec_req_field_experience', 'Se requiere experiencia en'), 'required|trim');
        $this->form_validation->set_rules('observaciones_req', t('rec_req_field_observations', 'Observaciones adicionales'), 'trim');

        $this->form_validation->set_message(
            'required',
            t('rec_val_required', 'El campo {field} es obligatorio')
        );
        $this->form_validation->set_message(
            'max_length',
            t('rec_val_max_length', 'El campo {field} debe tener máximo {param} carácteres')
        );
        $this->form_validation->set_message(
            'valid_email',
            t('rec_val_valid_email', 'El campo {field} debe ser un correo válido')
        );
        $this->form_validation->set_message(
            'numeric',
            t('rec_val_numeric', 'El campo {field} debe ser numérico')
        );

        $msj = [];

        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {

            $cadena_competencias = $this->input->post('competencias');
            $competencias        = '';

            if (! empty($cadena_competencias)) {
                $competencias = implode('_', $cadena_competencias);
            }

            $date       = date('Y-m-d H:i:s');
            $id_usuario = $this->session->userdata('id');
            $id_cliente = $this->input->post('id_cliente');
            $contacto   = $this->input->post('contacto_req');
            $palabras   = explode(' ', $contacto);

                                                                // Asignar las palabras a variables individuales
            $nombre  = isset($palabras[0]) ? $palabras[0] : ''; // Primer palabra
            $paterno = isset($palabras[1]) ? $palabras[1] : '';

            $cliente = [
                'edicion' => $date,
                'nombre'  => $this->input->post('nombre_comercial_req'),
            ];
            $domicilios = [
                'pais'     => $this->input->post('pais_req'),
                'estado'   => $this->input->post('estado_req'),
                'ciudad'   => $this->input->post('ciudad_req'),
                'colonia'  => $this->input->post('colonia_req'),
                'calle'    => $this->input->post('calle_req'),
                'interior' => $this->input->post('interior_req'),
                'exterior' => $this->input->post('exterior_req'),
                'cp'       => $this->input->post('cp_req'),
            ];

            $generales = [
                'telefono_req' => $this->input->post('telefono_req'),
                'correo_req'   => $this->input->post('correo_req'),
                'nombre'       => $nombre,
                'paterno'      => $paterno,
            ];

            $facturacion = [
                'razon_social' => $this->input->post('nombre_req'),
                'regimen'      => $this->input->post('regimen_req'),
                'rfc'          => $this->input->post('rfc_req'),
                'forma_pago'   => $this->input->post('forma_pago_req'),
                'metodo_pago'  => $this->input->post('metodo_pago_req'),
                'uso_cfdi'     => $this->input->post('uso_cfdi_req'),

            ];
            $idiomas = "";

            if ($this->input->post('idioma1_req') != "") {
                $idiomas .= ($this->input->post('por_idioma1_req') != '') ? $this->input->post('idioma1_req') . ' con ' . $this->input->post('por_idioma1_req') . '% ' : $this->input->post('idioma1_req');
            }
            if ($this->input->post('idioma2_req') != "") {
                $idiomas .= ($this->input->post('por_idioma2_req') != '') ? $this->input->post('idioma2_req') . ' con ' . $this->input->post('por_idioma2_req') . '% ' : $this->input->post('idioma2_req');
            }
            if ($this->input->post('idioma3_req') != "") {
                $idiomas .= ($this->input->post('por_idioma3_req') != '') ? $this->input->post('idioma3_req') . ' con ' . $this->input->post('por_idioma3_req') . '% ' : $this->input->post('idioma3_req');
            }
            if ($this->input->post('idioma3_req') == "") {
                $idiomas .= "Sin Idiomas";
            }

            $habilidades = "";

            if ($this->input->post('habilidad1_req') != "") {
                $habilidades .= ($this->input->post('por_habilidad1_req') != '') ? $this->input->post('habilidad1_req') . ' con ' . $this->input->post('por_habilidad1_req') . '% ' : $this->input->post('habilidad1_req');
            }
            if ($this->input->post('habilidad2_req') != "") {
                $habilidades .= ($this->input->post('por_habilidad2_req') != '') ? $this->input->post('habilidad2_req') . ' con ' . $this->input->post('por_habilidad2_req') . '% ' : $this->input->post('habilidad2_req');
            }
            if ($this->input->post('habilidad3_req') != "") {
                $habilidades .= ($this->input->post('por_habilidad3_req') != '') ? $this->input->post('habilidad3_req') . ' con ' . $this->input->post('por_habilidad3_req') . '% ' : $this->input->post('habilidad3_req');
            }
            if ($this->input->post('habilidad1_req') == "") {
                $habilidades .= "Sin Habilidades requeridas";
            }

            $licencia = '';

            if ($this->input->post('licencia_req') != "No necesaria" || $this->input->post('licencia_req') != '') {
                $licencia .= ($this->input->post('tipo_licencia_req') != '') ? $this->input->post('licencia_req') . ' ' . $this->input->post('tipo_licencia_req') : $this->input->post('licencia_req');
            } else {
                $licencia .= "N/A";
            }

            $req = [
                'creacion'               => $date,
                'edicion'                => $date,
                'tipo'                   => 'INTERNA',
                'id_usuario'             => $id_usuario,
                'id_cliente'             => $id_cliente,
                'puesto'                 => $this->input->post('puesto_req') ?? null,
                'numero_vacantes'        => $this->input->post('numero_vacantes_req') ?? null,
                'escolaridad'            => ! empty($this->input->post('escolaridad_req')) ? $this->input->post('escolaridad_req') : null,
                'estatus_escolar'        => ! empty($this->input->post('estatus_escolaridad_req')) ? $this->input->post('estatus_escolaridad_req') : null,
                'otro_estatus_escolar'   => ! empty($this->input->post('otro_estatus_req')) ? $this->input->post('otro_estatus_req') : null,
                'carrera_requerida'      => ! empty($this->input->post('carrera_req')) ? $this->input->post('carrera_req') : null,
                'otros_estudios'         => $this->input->post('otros_estudios_req') ?? null,
                'idiomas'                => $idiomas ?? null,
                'habilidad_informatica'  => $habilidades ?? null,
                'genero'                 => $this->input->post('genero_req') ?? null,
                'estado_civil'           => $this->input->post('civil_req') ?? null,
                'edad_minima'            => $this->input->post('edad_minima_req') ?? null,
                'edad_maxima'            => $this->input->post('edad_maxima_req') ?? null,
                'licencia'               => $licencia ?? null,
                'discapacidad_aceptable' => $this->input->post('discapacidad_req') ?? null,
                'causa_vacante'          => $this->input->post('causa_req') ?? null,
                'lugar_residencia'       => $this->input->post('residencia_req') ?? null,
                'zona_trabajo'           => $this->input->post('zona_req') ?? null,
                'tipo_pago_sueldo'       => $this->input->post('tipo_sueldo_req') ?? null,
                'sueldo_minimo'          => $this->input->post('sueldo_minimo_req') ?? null,
                'sueldo_maximo'          => $this->input->post('sueldo_maximo_req') ?? null,
                'tipo_prestaciones'      => $this->input->post('tipo_prestaciones_req') ?? null,
                'experiencia'            => $this->input->post('experiencia_req') ?? null,
                'competencias'           => $competencias ?? null,
                'observaciones'          => $this->input->post('observaciones_req') ?? null,
            ];

            $result = $this->reclutamiento_model->addRequisicion($id_cliente, $cliente, $domicilios, $generales, $facturacion, $req);

            if (! empty($result)) {

                $msj = [
                    'codigo' => 1,
                    'msg'    => t('rec_req_add_ok', 'Requisición express registrada correctamente')];
            } else {
                $msj = [
                    'codigo' => 0,
                    'msg'    => t('rec_req_add_err', 'Error al registrar la requisición'),
                ];
            }
        }
        echo json_encode($msj);
    }

    //* Funcion base
    public function assignToUser()
    {
        // Si tu helper NO está en autoload, descomenta:
        // $this->load->helper('i18n'); // <- donde vive t()

        $this->form_validation->set_rules(
            'asignar_usuario[]',
            $this->input->post('label_usuario'),
            'required|numeric|trim'
        );
        $this->form_validation->set_rules(
            'asignar_registro',
            $this->input->post('label_registro'),
            'required|numeric|trim'
        );

        // set_message traducible
        $this->form_validation->set_message('required', t('rec_val_required', 'El campo {field} es obligatorio'));
        $this->form_validation->set_message('max_length', t('rec_val_max_length', 'El campo {field} debe tener máximo {param} carácteres'));
        $this->form_validation->set_message('numeric', t('rec_val_numeric', 'El campo {field} debe ser numérico'));

        $msj = [];

        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {

            if ($this->input->post('view') == 'bolsa_trabajo') {
                $data = [
                    'edicion'    => date('Y-m-d H:i:s'),
                    'id_usuario' => $this->input->post('asignar_usuario'),
                ];
                $this->reclutamiento_model->editBolsaTrabajo($data, $this->input->post('asignar_registro'));

                $msj = [
                    'codigo' => 1,
                    'msg'    => t('rec_assign_ok', 'La asignación se realizó correctamente'),
                ];
            }

            if ($this->input->post('view') == 'requisicion') {
                $usuarios   = $this->input->post('asignar_usuario');
                $totalUsers = is_array($usuarios) ? count($usuarios) : 0;

                for ($i = 0; $i < $totalUsers; $i++) {
                    $data = [
                        'creacion'       => date('Y-m-d H:i:s'),
                        'id_requisicion' => $this->input->post('asignar_registro'),
                        'id_usuario'     => $usuarios[$i],
                    ];
                    $this->reclutamiento_model->addUsersToOrder($data);
                }

                $msj = [
                    'codigo' => 1,
                    'msg'    => t('rec_assign_ok', 'La asignación se realizó correctamente'),
                ];
            }

            // Si view vino raro, no dejes msj vacío
            if (empty($msj)) {
                $msj = [
                    'codigo' => 0,
                    'msg'    => t('rec_assign_err_invalid_view', 'Acción no válida'),
                ];
            }
        }

        // ✅ IMPORTANTÍSIMO: asegura salida JSON limpia
        $this->output->set_content_type('application/json', 'utf-8');

        // Si hay warnings/espacios antes, esto ayuda (opcional)
        if (ob_get_length()) {@ob_clean();}

        echo json_encode($msj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit; // <- evita que CI agregue output extra
    }

    public function updateOrder()
    {
        $section = $this->input->post('section');
        if ($section == 'data_facturacion') {
            $this->form_validation->set_rules('comercial_update', 'Nombre comercial', 'required|trim');
            $this->form_validation->set_rules('nombre_update', 'Razón social', 'required|trim');
            $this->form_validation->set_rules('pais_update', 'País', 'required|trim');
            $this->form_validation->set_rules('estado_update', 'Estado', 'required|trim');
            $this->form_validation->set_rules('ciudad_update', 'Ciudad', 'required|trim');
            $this->form_validation->set_rules('colonia_update', 'Colonia', 'required|trim');
            $this->form_validation->set_rules('calle_update', 'Calle', 'required|trim');
            $this->form_validation->set_rules('interior_update', 'Número Interior', 'trim');
            $this->form_validation->set_rules('exterior_update', 'Número Exterior', 'trim');

            $this->form_validation->set_rules('cp_update', 'Código postal', 'required|trim|max_length[5]');
            $this->form_validation->set_rules('regimen_update', 'Régimen Fiscal', 'required|trim');
            $this->form_validation->set_rules('telefono_update', 'Teléfono', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('correo_update', 'Correo', 'required|trim|valid_email');
            $this->form_validation->set_rules('contacto_update', 'Contacto', 'trim|required');
            $this->form_validation->set_rules('rfc_update', 'RFC', 'trim|required|max_length[13]');
            $this->form_validation->set_rules('forma_pago_update', 'Forma de pago', 'required|trim');
            $this->form_validation->set_rules('metodo_pago_update', 'Método de pago', 'required|trim');
            $this->form_validation->set_rules('uso_cfdi_update', 'Uso de CFDI', 'required|trim');
        }
        if ($section == 'vacante') {
            $this->form_validation->set_rules('puesto_update', 'Nombre de la posición', 'required|trim');
            $this->form_validation->set_rules('num_vacantes_update', 'Número de vacantes', 'required|numeric|max_length[2]');
            $this->form_validation->set_rules('escolaridad_update', 'Formación académica requerida', 'required|trim');
            $this->form_validation->set_rules('estatus_escolaridad_update', 'Estatus académico', 'required|trim');
            $this->form_validation->set_rules('otro_estatus_update', 'Otro estatus académico', 'trim');
            $this->form_validation->set_rules('carrera_update', 'Carrera requerida para el puesto', 'required|trim');
            $this->form_validation->set_rules('otros_estudios_update', 'Otro estatus académico', 'trim');
            $this->form_validation->set_rules('idiomas_update', 'Idiomas que habla y porcentajes de cada uno', 'trim');
            $this->form_validation->set_rules('hab_informatica_update', 'Habilidades informáticas requeridas', 'trim');
            $this->form_validation->set_rules('genero_update', 'Sexo', 'required|trim');
            $this->form_validation->set_rules('civil_update', 'Estado civil', 'required|trim');
            $this->form_validation->set_rules('edad_minima_update', 'Edad mínima', 'required|numeric|max_length[2]');
            $this->form_validation->set_rules('edad_maxima_update', 'Edad máxima', 'required|numeric|max_length[2]');
            $this->form_validation->set_rules('licencia_update', 'Licencia de conducir', 'required|trim');
            $this->form_validation->set_rules('discapacidad_update', 'Discapacidad aceptable', 'required|trim');
            $this->form_validation->set_rules('causa_update', 'Causa que origina la vacante', 'required|trim');
            $this->form_validation->set_rules('residencia_update', 'Lugar de residencia', 'required|trim');
        }
        if ($section == 'cargo') {
            $this->form_validation->set_rules('jornada_update', 'Jornada laboral', 'required|trim');
            $this->form_validation->set_rules('tiempo_inicio_update', 'Inicio de la Jornada laboral', 'required|trim');
            $this->form_validation->set_rules('tiempo_final_update', 'Fin de la Jornada laboral', 'required|trim');
            $this->form_validation->set_rules('descanso_update', 'Día(s) de descanso', 'required|trim');
            $this->form_validation->set_rules('viajar_update', 'Disponibilidad para viajar', 'required|trim');
            $this->form_validation->set_rules('horario_update', 'Disponibilidad de horario', 'required|trim');
            $this->form_validation->set_rules('lugar_entrevista_update', 'Lugar de la entrevista', 'trim');
            $this->form_validation->set_rules('zona_update', 'Zona de trabajo', 'required|trim');
            $this->form_validation->set_rules('tipo_sueldo_update', 'Sueldo', 'required|trim');
            $this->form_validation->set_rules('sueldo_minimo_update', 'Sueldo mínimo', 'numeric|max_length[8]');
            $this->form_validation->set_rules('sueldo_maximo_update', 'Sueldo máximo', 'required|numeric|max_length[8]');
            $this->form_validation->set_rules('sueldo_adicional_update', 'Adicional al sueldo', 'required|trim');
            $this->form_validation->set_rules('monto_adicional_update', 'Monto del sueldo adicional', 'trim');
            $this->form_validation->set_rules('tipo_pago_update', 'Tipo de pago', 'required|trim');
            $this->form_validation->set_rules('tipo_prestaciones_update', '¿Tendrá prestaciones de ley?', 'required');
            $this->form_validation->set_rules('superiores_update', '¿Tendrá prestaciones superiores? ¿Cuáles?', 'trim');
            $this->form_validation->set_rules('otras_prestaciones_update', '¿Tendrá otro tipo de prestaciones? ¿Cuáles?', 'trim');
            $this->form_validation->set_rules('experiencia_update', 'Se requiere experiencia en', 'required|trim');
            $this->form_validation->set_rules('actividades_update', 'Actividades a realizar', 'required|trim');
        }
        if ($section == 'perfil') {
            $this->form_validation->set_rules('competencias', 'Competencias requeridas para el puesto', 'required|trim');
            $this->form_validation->set_rules('observaciones_update', 'Observaciones adicionales', 'trim');
        }

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $generales = [];

            if ($section == 'data_facturacion') {

                $contacto = $this->input->post('contacto_update');
                $palabras = explode(' ', $contacto);

                                                                    // Asignar las palabras a variables individuales
                $nombre  = isset($palabras[0]) ? $palabras[0] : ''; // Primer palabra
                $paterno = isset($palabras[1]) ? $palabras[1] : '';

                // Agregar los valores al arreglo $generales
                $generales['telefono'] = $this->input->post('telefono_update');
                $generales['correo']   = $this->input->post('correo_update');
                $generales['nombre']   = $nombre;
                $generales['paterno']  = $paterno;

                $req = [
                    'edicion'    => date('Y-m-d H:i:s'),
                    'id_usuario' => $this->session->userdata('id'),
                ];

                $facturacion = [

                    'razon_social' => $this->input->post('nombre_update'),
                    'rfc'          => $this->input->post('rfc_update'),
                    'regimen'      => $this->input->post('regimen_update'),
                    'forma_pago'   => $this->input->post('forma_pago_update'),
                    'metodo_pago'  => $this->input->post('metodo_pago_update'),
                    'uso_cfdi'     => $this->input->post('uso_cfdi_update'),
                ];

                $domicilios = [
                    'pais'     => $this->input->post('pais_update'),
                    'estado'   => $this->input->post('estado_update'),
                    'ciudad'   => $this->input->post('ciudad_update'),
                    'colonia'  => $this->input->post('colonia_update'),
                    'calle'    => $this->input->post('calle_update'),
                    'interior' => $this->input->post('interior_update'),
                    'exterior' => $this->input->post('exterior_update'),
                    'cp'       => $this->input->post('cp_update'),
                ];

                $sectionSuccessMessage = 'Datos de facturación, domicilios, generales del cliente actualizados correctamente';
            }
            if ($section == 'vacante') {
                $req = [
                    'puesto'                 => $this->input->post('puesto_update'),
                    'numero_vacantes'        => $this->input->post('num_vacantes_update'),
                    'escolaridad'            => $this->input->post('escolaridad_update'),
                    'estatus_escolar'        => $this->input->post('estatus_escolaridad_update'),
                    'otro_estatus_escolar'   => $this->input->post('otro_estatus_update'),
                    'carrera_requerida'      => $this->input->post('carrera_update'),
                    'idiomas'                => $this->input->post('idiomas_update'),
                    'otros_estudios'         => $this->input->post('otros_estudios_update'),
                    'habilidad_informatica'  => $this->input->post('hab_informatica_update'),
                    'genero'                 => $this->input->post('genero_update'),
                    'estado_civil'           => $this->input->post('civil_update'),
                    'edad_minima'            => $this->input->post('edad_minima_update'),
                    'edad_maxima'            => $this->input->post('edad_maxima_update'),
                    'licencia'               => $this->input->post('licencia_completa'),
                    'discapacidad_aceptable' => $this->input->post('discapacidad_update'),
                    'causa_vacante'          => $this->input->post('causa_update'),
                    'lugar_residencia'       => $this->input->post('residencia_update'),
                ];
                $sectionSuccessMessage = 'Información de la vacante actualizada correctamente';
            }
            if ($section == 'cargo') {
                $req = [
                    'jornada_laboral'              => $this->input->post('jornada_update'),
                    'tiempo_inicio'                => $this->input->post('tiempo_inicio_update'),
                    'tiempo_final'                 => $this->input->post('tiempo_final_update'),
                    'dias_descanso'                => $this->input->post('descanso_update'),
                    'disponibilidad_viajar'        => $this->input->post('viajar_update'),
                    'disponibilidad_horario'       => $this->input->post('horario_update'),
                    'lugar_entrevista'             => $this->input->post('lugar_entrevista_update'),
                    'zona_trabajo'                 => $this->input->post('zona_update'),
                    'sueldo'                       => $this->input->post('tipo_sueldo_update'),
                    'sueldo_adicional'             => $this->input->post('sueldo_adicional_completo'),
                    'sueldo_minimo'                => $this->input->post('sueldo_minimo_update'),
                    'sueldo_maximo'                => $this->input->post('sueldo_maximo_update'),
                    'tipo_pago_sueldo'             => $this->input->post('tipo_pago_update'),
                    'tipo_prestaciones'            => $this->input->post('tipo_prestaciones_update'),
                    'tipo_prestaciones_superiores' => $this->input->post('superiores_update'),
                    'otras_prestaciones'           => $this->input->post('otras_prestaciones_update'),
                    'experiencia'                  => $this->input->post('experiencia_update'),
                    'actividades'                  => $this->input->post('actividades_update'),
                ];
                $sectionSuccessMessage = 'Información del cargo actualizada correctamente';
            }
            if ($section == 'perfil') {
                $req = [
                    'competencias'  => $this->input->post('competencias'),
                    'observaciones' => $this->input->post('observaciones_update'),
                ];
                $sectionSuccessMessage = 'Información del perfil actualizada correctamente';
            }
            // Comprobar si $generales no está vacío
            if (! empty($generales)) {
                // Si $generales no está vacío, se ha editado datos de facturación y generales
                /*  var_dump($generales);
                var_dump($domicilios);
                var_dump($facturacion);*/

                $idFac = $this->input->post('id_facturacion_update');
                // Iniciar la transacción
                $this->db->trans_start();

                // Actualizar la orden
                $this->reclutamiento_model->updateOrder($req, $this->input->post('id_requisicion'));

                $this->generales_model->editDomicilios($this->input->post('id_domicilios_update'), $domicilios);

                // Editar los datos de facturación
                $this->generales_model->editDatosFacturacion($idFac, $facturacion);

                // Editar los datos generales
                $this->generales_model->editDatosGenerales($this->input->post('id_generales_update'), $generales);

                // Finalizar la transacción
                $this->db->trans_complete();

                // Verificar si la transacción se completó correctamente
                if ($this->db->trans_status() === false) {
                    // Si la transacción falló, revertir los cambios y mostrar un mensaje de error
                    $this->db->trans_rollback();

                    $msj = [
                        'codigo' => 0,
                        'msg'    => 'Error al procesar la transacción',
                    ];
                } else {
                    // Si la transacción se completó correctamente, mostrar un mensaje de éxito
                    $msj = [
                        'codigo' => 1,
                        'msg'    => $sectionSuccessMessage,
                    ];
                }
            } else {
                // Si $generales está vacío, solo se ha editado la orden
                //  var_dump($req);
                // Actualizar la orden
                $this->reclutamiento_model->updateOrder($req, $this->input->post('id_requisicion'));

                // Mostrar un mensaje de éxito
                $msj = [
                    'codigo' => 1,
                    'msg'    => $sectionSuccessMessage,
                ];
            }

        }
        echo json_encode($msj);
    }

// application/controllers/Reclutamiento.php
    public function updateIntake()
    {
        $idReq = (int) $this->input->post('idReq');

        if (! $idReq) {
            return jsonOut([
                'success'   => false,
                'codigo'    => 0,
                'msg_key'   => 'rec_intake_err_missing_idreq',
                // opcional csrf para refrescar
                'csrf_name' => $this->security->get_csrf_token_name(),
                'csrf_hash' => $this->security->get_csrf_hash(),
            ]);
        }

        $post = $this->input->post(null, true);
        unset($post[$this->security->get_csrf_token_name()]);

        $allowed = [
            'nombre_cliente', 'razon_social', 'email', 'telefono', 'sitio_web', 'metodo_comunicacion', 'actividad', 'nit',
            'pais_empresa', 'pais_otro',
            'plan', 'fecha_solicitud', 'fecha_inicio', 'horario', 'sexo_preferencia', 'rango_edad',
            'funciones', 'requisitos', 'recursos',
            'requiere_voip', 'voip_propiedad', 'voip_pais_ciudad', 'usa_crm', 'crm_nombre',
            'miembro_bni', 'referido', 'observaciones',
        ];
        $data = [];
        $norm = function ($k, $v) {
            $v = is_string($v) ? trim($v) : $v;

            if (in_array($k, ['fecha_solicitud', 'fecha_inicio'], true)) {
                if ($v === '') {
                    return null;
                }

                if (preg_match('~^(\d{2})/(\d{2})/(\d{4})$~', $v, $m)) {
                    return "{$m[3]}-{$m[2]}-{$m[1]}";
                }

                if (preg_match('~^(\d{4})[-/](\d{2})[-/](\d{2})$~', $v, $m)) {
                    return "{$m[1]}-{$m[2]}-{$m[3]}";
                }

                $ts = strtotime($v);
                return $ts ? date('Y-m-d', $ts) : null;
            }

            if (in_array($k, ['requiere_voip', 'usa_crm', 'miembro_bni'], true)) {
                $vv = mb_strtolower((string) $v);
                if ($vv === 'si' || $vv === 'sí') {
                    return 'si';
                }

                if ($vv === 'no') {
                    return 'no';
                }

                return '';
            }

            if ($k === 'email' && $v !== '' && ! filter_var($v, FILTER_VALIDATE_EMAIL)) {
                return '';
            }

            if (in_array($k, ['actividad', 'nit'], true)) {
                return $v;
            }

            return $v === '' ? null : $v;
        };
        foreach ($allowed as $k) {
            if (array_key_exists($k, $post)) {
                $data[$k] = $norm($k, $post[$k]);
            }
        }

        $data['edicion'] = date('Y-m-d H:i:s');

        $ok = $this->reclutamiento_model->updateIntakeByReq($idReq, $data);

        return jsonOut([
            'success'   => (bool) $ok,
            'codigo'    => $ok ? 1 : 0,
            'msg_key'   => $ok ? 'rec_intake_ok_saved' : 'rec_intake_err_not_updated',
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
        ]);
    }

    public function uploadCSV()
    {
        $id_portal = $this->session->userdata('idPortal');
        $idUsuario = $this->session->userdata('id');

        if (! isset($_FILES["archivo"]["name"])) {
            $msj = ['codigo' => 0, 'msg' => t('rec_csv_err_invalid_file', 'Seleccione un archivo .csv válido')];
            echo json_encode($msj);exit;
        }

        $extensionArchivo = strtolower(pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION));
        if ($extensionArchivo !== 'csv') {
            $msj = ['codigo' => 0, 'msg' => t('rec_csv_err_invalid_file', 'Seleccione un archivo .csv válido')];
            echo json_encode($msj);exit;
        }

        $file = $_FILES["archivo"];
        $tmp  = $file["tmp_name"] ?? '';
        $size = (int) ($file["size"] ?? 0);

        if ($size <= 0 || ! $tmp) {
            $msj = ['codigo' => 0, 'msg' => t('rec_csv_err_invalid_file', 'Seleccione un archivo .csv válido')];
            echo json_encode($msj);exit;
        }

        $rows   = [];
        $handle = fopen($tmp, "r");
        if (! $handle) {
            $msj = ['codigo' => 0, 'msg' => t('rec_csv_err_invalid_file', 'Seleccione un archivo .csv válido')];
            echo json_encode($msj);exit;
        }

        while (($data = fgetcsv($handle)) !== false) {
            $rows[] = $data;
        }
        fclose($handle);

        unset($rows[0]);
        $rows = array_values($rows);

        if (count($rows) <= 0) {
            $msj = ['codigo' => 0, 'msg' => t('rec_csv_err_empty_file', 'El archivo está vacío')];
            echo json_encode($msj);exit;
        }

        $errorMessages   = '';
        $successMessages = t('rec_csv_rows_added_prefix', 'Registros agregados de la(s) fila(s):<br> ');
        $i               = 0;
        $rowsAdded       = 0;

        foreach ($rows as $r) {
            $rowNum = $i + 2;

            $userCorrect = $this->session->userdata('id');
            if ($userCorrect == null) {
                $errorMessages .= t('rec_csv_err_user_id_invalid', 'El ID de usuario no es válido en la fila {row}', ['{row}' => $rowNum]) . '<br>';
                $i++;
                continue;
            }

            if (! isset($r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], $r[8])) {
                $errorMessages .= t('rec_csv_err_invalid_row', 'Fila incompleta o inválida en la fila {row}', ['{row}' => $rowNum]) . '<br>';
                $i++;
                continue;
            }

            if (! preg_match("/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/i", $r[1])) {
                $errorMessages .= t('rec_csv_err_date_format', 'Formato de fecha no válido en la fila {row}', ['{row}' => $rowNum]) . '<br>';
                $i++;
                continue;
            }

            if (
                ! preg_match("/^([\wñáéíóúÁÉÍÓÚ]{1}[\wñáéíóúÁÉÍÓÚ\s]+)$/", $r[2]) ||
                ! preg_match("/^([\wñáéíóúÁÉÍÓÚ]{1}[\wñáéíóúÁÉÍÓÚ\s]+)$/", $r[3]) ||
                ! preg_match("/^([\wñáéíóúÁÉÍÓÚ]{1}[\wñáéíóúÁÉÍÓÚ\s]+)$/", $r[4])
            ) {
                $errorMessages .= t('rec_csv_err_name_invalid', 'Nombre y/o apellidos no válidos en la fila {row}', ['{row}' => $rowNum]) . '<br>';
                $i++;
                continue;
            }

            $nombre  = strtoupper($r[2]);
            $paterno = strtoupper($r[3]);
            $materno = strtoupper($r[4]);

            $existName = $this->reclutamiento_model->getBolsaTrabajoByName($nombre, $paterno, $materno, $id_portal);
            if ($existName != null) {
                $errorMessages .= t('rec_csv_err_name_exists', 'El nombre ya existe en la fila {row}', ['{row}' => $rowNum]) . '<br>';
                $i++;
                continue;
            }

            $existPhone = $this->reclutamiento_model->getBolsaTrabajoByPhone($r[5], $id_portal);
            if (! preg_match("/^[\d]{2}[-]?[\d]{4}[-]?[\d]{4}$/", trim($r[5])) || $existPhone != null) {
                $errorMessages .= t('rec_csv_err_phone_invalid_or_exists', 'Número de teléfono ya existe o no es válido en la fila {row}', ['{row}' => $rowNum]) . '<br>';
                $i++;
                continue;
            }

            if (! (strlen($r[6]) > 0 && strlen($r[6]) <= 128)) {
                $errorMessages .= t('rec_csv_err_interest_invalid', 'Área de interés vacía o demasiado extensa en la fila {row}', ['{row}' => $rowNum]) . '<br>';
                $i++;
                continue;
            }

            if (! (strlen($r[7]) > 0 && strlen($r[7]) <= 30)) {
                $errorMessages .= t('rec_csv_err_location_invalid', 'Localización vacía o demasiado extensa en la fila {row}', ['{row}' => $rowNum]) . '<br>';
                $i++;
                continue;
            }

            $existContact = $this->funciones_model->getMediosContactoByName($r[8]);
            if (isset($existContact)) {
                $this->funciones_model->insertarMedioContacto($r[8]);
                $existContact = $this->funciones_model->getMediosContactoByName($r[8]);
            }

            if ($r[8] === '' || $existContact === null) {
                $errorMessages .= t('rec_csv_err_contact_empty', 'Medio de contacto vacío o no existe en el catálogo en la fila {row}', ['{row}' => $rowNum]) . '<br>';
                $i++;
                continue;
            }

            $fecha = validar_fecha_espanol($r[1]) ? fecha_espanol_bd($r[1]) : date('Y-m-d H:i:s');

            $data = [
                'creacion'       => $fecha,
                'edicion'        => $fecha,
                'id_portal'      => $id_portal,
                'id_usuario'     => $idUsuario,
                'nombre'         => $nombre,
                'paterno'        => $paterno,
                'materno'        => $materno,
                'domicilio'      => strtoupper($r[7]),
                'telefono'       => trim($r[5]),
                'medio_contacto' => $existContact->nombre,
                'area_interes'   => $r[6],
            ];

            $this->reclutamiento_model->addBolsaTrabajo($data);

            $successMessages .= ($rowNum) . ',';
            $rowsAdded++;
            $i++;
        }

        if ($errorMessages === '') {
            $msj = [
                'codigo' => 1,
                'msg'    => t('rec_csv_ok_loaded', 'Los registros del archivo fueron cargados al sistema correctamente')
                . '<br>' . rtrim($successMessages, ','),
            ];
            echo json_encode($msj);exit;
        }

        if ($rowsAdded == 0) {
            $msj = [
                'codigo' => 0,
                'msg'    => t('rec_csv_done_with_errors', 'Finalizó la carga pero se encontraron algunos errores:')
                . '<br>' . $errorMessages . '<br>' . t('rec_csv_none_added', 'No se agregaron registros del archivo'),
            ];
            echo json_encode($msj);exit;
        }

        $msj = [
            'codigo' => 2,
            'msg'    => t('rec_csv_done_with_errors', 'Finalizó la carga pero se encontraron algunos errores:')
            . '<br>' . $errorMessages . '<br>' . rtrim($successMessages, ','),
        ];
        echo json_encode($msj);exit;
    }

    public function deleteUserOrder()
    {
        $id = $this->input->post('id', true);

        $this->reclutamiento_model->deleteUserOrder($id);

        $msj = [
            'codigo' => 1,
            'msg'    => t('rec_order_del_user_ok', 'Se ha eliminado el usuario de la requisición correctamente'),
        ];

        echo json_encode($msj);
        exit;
    }

    public function deleteOrder()
    {
        $id_usuario = $this->session->userdata('id');
        $datos      = [
            'edicion'          => date('Y-m-d H:i:s'),
            'id_usuario'       => $id_usuario,
            'eliminado'        => 1,
            'comentario_final' => $this->input->post('comentario'),
        ];
        $this->reclutamiento_model->editarRequisicion($datos, $this->input->post('id'));
        $msj = [
            'codigo' => 1,
            'msg'    => 'Requisition deleted successfully',
        ];
        echo json_encode($msj);
    }
    public function updateApplicant()
    {
        $section  = $this->input->post('section');
        $id_bolsa = $this->input->post('id_bolsa');
        $idRol    = $this->session->userdata('idrol');

        // (opcional) valida base mínima
        if (! $section || ! $id_bolsa) {
            $msj = [
                'codigo' => 0,
                'msg'    => t('rec_applicant_err_missing_section_or_id', 'Faltan datos para actualizar.'),
            ];
            echo json_encode($msj);exit;
        }

        if ($section == 'personal') {

            $post         = $this->input->post();
            $vienenExtras = false;

            foreach ($post as $k => $v) {
                if (strpos($k, 'extra_') === 0) {
                    $vienenExtras = true;
                    break;
                }
            }

            if ($vienenExtras) {
                // ===== Validación manual (EXTRAS) =====
                $requeridos = ['nombre', 'fecha_nacimiento', 'telefono'];
                $faltantes  = [];

                // Mapa de labels traducibles para extras
                $labelsExtras = [
                    'nombre'           => t('rec_applicant_extra_name', 'Nombre'),
                    'fecha_nacimiento' => t('rec_applicant_extra_birthdate', 'Fecha de nacimiento'),
                    'telefono'         => t('rec_applicant_extra_phone', 'Teléfono'),
                ];

                foreach ($requeridos as $campo) {
                    if (empty($post['extra_' . $campo])) {
                        $faltantes[] = $labelsExtras[$campo] ?? ucfirst(str_replace('_', ' ', $campo));
                    }
                }

                if (! empty($post['extra_correo']) && ! filter_var($post['extra_correo'], FILTER_VALIDATE_EMAIL)) {
                    $faltantes[] = t('rec_applicant_extra_valid_email', 'Correo válido');
                }

                if (count($faltantes)) {
                    $msj = [
                        'codigo' => 0,
                        'msg'    => t(
                            'rec_applicant_err_missing_required',
                            'Faltan campos obligatorios: {fields}',
                            ['{fields}' => implode(', ', $faltantes)]
                        ),
                    ];
                    echo json_encode($msj);exit;
                }

                // ===== Construir extras =====
                $extras = [];
                foreach ($post as $key => $value) {
                    if (strpos($key, 'extra_') === 0) {
                        $campo          = substr($key, 6);
                        $extras[$campo] = $value;
                    }
                }

                $nombre_completo = isset($extras['nombre']) ? trim($extras['nombre']) : '';
                $nombre_split    = explode(' ', $nombre_completo, 2);
                $nombre          = isset($nombre_split[0]) ? $nombre_split[0] : '';
                $paterno         = isset($nombre_split[1]) ? $nombre_split[1] : '';
                $materno         = isset($extras['materno']) ? $extras['materno'] : null;

                $fecha_nacimiento = isset($extras['fecha_nacimiento']) ? $extras['fecha_nacimiento'] : null;
                $telefono         = isset($extras['telefono']) ? $extras['telefono'] : null;

                $partes_domicilio = [];
                if (! empty($extras['domicilio'])) {
                    $partes_domicilio[] = $extras['domicilio'];
                }

                if (! empty($extras['direccion'])) {
                    $partes_domicilio[] = $extras['direccion'];
                }

                if (! empty($extras['estado'])) {
                    $partes_domicilio[] = $extras['estado'];
                }

                $domicilio = implode(', ', $partes_domicilio);

                $bolsa = [
                    'edicion'          => date('Y-m-d H:i:s'),
                    'nombre'           => $nombre,
                    'paterno'          => $paterno,
                    'materno'          => $materno,
                    'fecha_nacimiento' => $fecha_nacimiento,
                    'telefono'         => $telefono,
                    'domicilio'        => $domicilio,
                    'extras'           => json_encode($extras, JSON_UNESCAPED_UNICODE),
                ];

                if ($idRol != 6) {
                    $bolsa['id_usuario'] = $this->session->userdata('id');
                }

                $sectionSuccessMessage = t('rec_applicant_ok_info_updated', 'Información actualizada correctamente');

            } else {
                // ===== Validación normal =====
                $this->form_validation->set_rules('nombre_update', t('rec_applicant_f_first_names', 'Nombre(s)'), 'required|trim');
                $this->form_validation->set_rules('paterno_update', t('rec_applicant_f_last_name1', 'Primer apellido'), 'required|trim');
                $this->form_validation->set_rules('materno_update', t('rec_applicant_f_last_name2', 'Segundo apellido'), 'trim');
                $this->form_validation->set_rules('domicilio_update', t('rec_applicant_f_address', 'Domicilio'), 'required|trim');
                $this->form_validation->set_rules('fecha_nacimiento_update', t('rec_applicant_f_birthdate', 'Fecha de nacimiento'), 'required|trim');
                $this->form_validation->set_rules('telefono_update', t('rec_applicant_f_phone', 'Teléfono'), 'required|trim|max_length[16]');
                $this->form_validation->set_rules('nacionalidad_update', t('rec_applicant_f_nationality', 'Nacionalidad'), 'required|trim');
                $this->form_validation->set_rules('civil_update', t('rec_applicant_f_marital_status', 'Estado civil'), 'required|trim');
                $this->form_validation->set_rules('dependientes_update', t('rec_applicant_f_dependents', 'Personas que dependan del aspirante'), 'required|trim');
                $this->form_validation->set_rules('escolaridad_update', t('rec_applicant_f_education', 'Grado máximo de estudios'), 'required|trim');

                $this->form_validation->set_message('required', t('rec_val_required', 'El campo {field} es obligatorio'));
                $this->form_validation->set_message('max_length', t('rec_val_max_length', 'El campo {field} debe tener máximo {param} carácteres'));
                $this->form_validation->set_message('valid_email', t('rec_val_valid_email', 'El campo {field} debe ser un correo válido'));
                $this->form_validation->set_message('numeric', t('rec_val_numeric', 'El campo {field} debe ser numérico'));

                if ($this->form_validation->run() == false) {
                    $msj = [
                        'codigo' => 0,
                        'msg'    => validation_errors(),
                    ];
                    echo json_encode($msj);exit;
                }

                $bolsa = [
                    'edicion'          => date('Y-m-d H:i:s'),
                    'nombre'           => $this->input->post('nombre_update'),
                    'paterno'          => $this->input->post('paterno_update'),
                    'materno'          => $this->input->post('materno_update'),
                    'fecha_nacimiento' => $this->input->post('fecha_nacimiento_update'),
                    'telefono'         => $this->input->post('telefono_update'),
                    'domicilio'        => $this->input->post('domicilio_update'),
                    'nacionalidad'     => $this->input->post('nacionalidad_update'),
                    'civil'            => $this->input->post('civil_update'),
                    'dependientes'     => $this->input->post('dependientes_update'),
                    'grado_estudios'   => $this->input->post('escolaridad_update'),
                ];

                if ($idRol != 6) {
                    $bolsa['id_usuario'] = $this->session->userdata('id');
                }

                $sectionSuccessMessage = t('rec_applicant_ok_personal_updated', 'Datos personales actualizados correctamente');
            }

            $this->reclutamiento_model->updateApplicantByIdBolsaTrabajo($bolsa, $id_bolsa);
        }

        if ($section == 'salud') {
            $bolsa = [
                'salud'      => $this->input->post('salud_update'),
                'enfermedad' => $this->input->post('enfermedad_update'),
                'deporte'    => $this->input->post('deporte_update'),
                'metas'      => $this->input->post('metas_update'),
            ];
            $sectionSuccessMessage = t('rec_applicant_ok_health_updated', 'Información de la salud y vida social actualizadas correctamente');
            $this->reclutamiento_model->editBolsaTrabajo($bolsa, $id_bolsa);
        }

        if ($section == 'conocimiento') {
            $bolsa = [
                'idiomas'  => $this->input->post('idiomas_update'),
                'maquinas' => $this->input->post('maquinas_update'),
                'software' => $this->input->post('software_update'),
            ];
            $sectionSuccessMessage = t('rec_applicant_ok_skills_updated', 'Información de conocimiento y habilidades actualizada correctamente');
            $this->reclutamiento_model->editBolsaTrabajo($bolsa, $id_bolsa);
        }

        if ($section == 'intereses') {
            $bolsa = [
                'medio_contacto' => $this->input->post('medio_contacto_update'),
                'area_interes'   => $this->input->post('area_interes_update'),
                'sueldo_deseado' => $this->input->post('sueldo_update'),
                'otros_ingresos' => $this->input->post('otros_ingresos_update'),
                'viajar'         => $this->input->post('viajar_update'),
                'trabajar'       => $this->input->post('trabajar_update'),
            ];
            $sectionSuccessMessage = t('rec_applicant_ok_interests_updated', 'Información de los intereses actualizada correctamente');
            $this->reclutamiento_model->editBolsaTrabajo($bolsa, $id_bolsa);
        }

        // Si llega aquí sin setear mensaje (section desconocida)
        if (! isset($sectionSuccessMessage)) {
            $msj = [
                'codigo' => 0,
                'msg'    => t('rec_applicant_err_invalid_section', 'Sección inválida.'),
            ];
            echo json_encode($msj);exit;
        }

        $msj = [
            'codigo' => 1,
            'msg'    => $sectionSuccessMessage,
        ];
        echo json_encode($msj);exit;
    }

    public function renombrarDocumentoBolsa()
    {
        $this->output->set_content_type('application/json');

        $id     = (int) $this->input->post('id');
        $nombre = trim((string) $this->input->post('nombre'));

        if ($id <= 0 || $nombre === '') {
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Datos inválidos']));
        }

        $ok = $this->db->where('id', $id)
            ->update('documentos_bolsa', [
                'nombre_personalizado' => $nombre,
                'fecha_actualizacion'  => date('Y-m-d H:i:s'),
            ]);

        return $this->output->set_output(json_encode(['ok' => (bool) $ok]));
    }

    public function eliminarDocumentoBolsa()
    {
        $this->output->set_content_type('application/json');

        $id = (int) $this->input->post('id');
        if ($id <= 0) {
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'ID inválido']));
        }

        // Obtén el registro para poder borrar el archivo físico (opcional)
        $row = $this->db->get_where('documentos_bolsa', ['id' => $id])->row();
        if (! $row) {
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'No encontrado']));
        }

        // Borra archivo físico (opcional pero recomendado)
        $destDir = rtrim(FCPATH, '/\\') . '/_documentosBolsa/';
        $path    = $destDir . $row->nombre_archivo;
        if (is_file($path)) {@unlink($path);}

        // Soft-delete en BD
        $ok = $this->db->where('id', $id)
            ->update('documentos_bolsa', [
                'eliminado'           => 1,
                'fecha_actualizacion' => date('Y-m-d H:i:s'),
            ]);

        return $this->output->set_output(json_encode(['ok' => (bool) $ok]));
    }

    public function updateWarrantyApplicant()
    {
        $this->form_validation->set_rules('sueldo_acordado', 'Sueldo acordado', 'required|trim');
        $this->form_validation->set_rules('fecha_ingreso', 'Fecha de ingreso a la empresa', 'trim');
        $this->form_validation->set_rules('pago', 'Pago', 'trim');
        $this->form_validation->set_rules('garantia', 'Estatus de la garantia', 'trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $aspirante = [
                'edicion'         => date('Y-m-d H:i:s'),
                'sueldo_acordado' => $this->input->post('sueldo_acordado'),
                'fecha_ingreso'   => $this->input->post('fecha_ingreso'),
                'pago'            => $this->input->post('pago'),
            ];
            if ($this->session->userdata('id_rol') != 6) {
                $aspirante['id_usuario'] = $this->session->userdata('id');
            }
            $this->reclutamiento_model->editarAspirante($aspirante, $this->input->post('id_aspirante'));
            if ($this->input->post('garantia') != '') {
                $garantia = [
                    'creacion'     => date('Y-m-d H:i:s'),
                    'id_aspirante' => $this->input->post('id_aspirante'),
                    'descripcion'  => $this->input->post('garantia'),
                ];
                if ($this->session->userdata('id_rol') != 6) {
                    $garantia['id_usuario'] = $this->session->userdata('id');
                }

                $this->reclutamiento_model->addWarrantyApplicant($garantia);
            }
            $msj = [
                'codigo' => 1,
                'msg'    => 'Información de ingreso actualizada correctamente',
            ];
        }
        echo json_encode($msj);
    }

    public function subirDocumentosBolsa()
    {
        $this->output->set_content_type('application/json');

                                                              // 1) Parámetros
        $id_bolsa = (int) $this->input->post('id_aspirante'); // alias de id_bolsa
        $nombres  = $this->input->post('nombres');            // array de nombres personalizados
        $user_id  = (int) ($this->session->userdata('id') ?? 0);

        if ($id_bolsa <= 0) {
            return $this->output->set_output(json_encode([
                'ok'  => false,
                'msg' => 'Falta id_aspirante (id_bolsa).',
            ]));
        }

        // 2) Validar que existan archivos
        if (! isset($_FILES['archivos']) || empty($_FILES['archivos']['name'])) {
            return $this->output->set_output(json_encode([
                'ok'  => false,
                'msg' => 'No se recibieron archivos.',
            ]));
        }

        // 3) Directorio de destino
        $destDir = rtrim(FCPATH, '/\\') . '/_documentosBolsa';
        if (! is_dir($destDir)) {
            @mkdir($destDir, 0755, true);
        }
        if (! is_dir($destDir) || ! is_writable($destDir)) {
            return $this->output->set_output(json_encode([
                'ok'  => false,
                'msg' => 'No se pudo crear o escribir en el directorio de destino.',
            ]));
        }

        // 4) Recorrer archivos
        $total   = count($_FILES['archivos']['name']);
        $results = [];
        $okCount = 0;

        for ($i = 0; $i < $total; $i++) {
            $error = $_FILES['archivos']['error'][$i];
            if ($error !== UPLOAD_ERR_OK) {
                $results[] = ['i' => $i, 'ok' => false, 'msg' => 'Error al subir (code ' . $error . ')'];
                continue;
            }

            $origName = $_FILES['archivos']['name'][$i];
            $tmpPath  = $_FILES['archivos']['tmp_name'][$i];
            $size     = (int) $_FILES['archivos']['size'][$i];

            // Nombre personalizado (sin extensión); si no viene, usar base del original
            $nombreBase = '';
            if (is_array($nombres) && isset($nombres[$i]) && trim($nombres[$i]) !== '') {
                $nombreBase = trim($nombres[$i]);
            } else {
                $nombreBase = pathinfo($origName, PATHINFO_FILENAME);
            }

            // Extensión (del archivo original)
            $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

            // Sanitizar nombre de archivo final
            $slug = $this->_slugify($nombreBase);
            if ($slug === '') {$slug = 'documento';}

            $fileName = $slug . ($ext ? '.' . $ext : '');
            $destPath = $destDir . '/' . $fileName;

            // Evitar colisiones: si existe, agrega sufijo incremental
            $c = 1;
            while (file_exists($destPath)) {
                $fileName = $slug . '-' . $c . ($ext ? '.' . $ext : '');
                $destPath = $destDir . '/' . $fileName;
                $c++;
            }

            // Mover archivo
            if (! @move_uploaded_file($tmpPath, $destPath)) {
                $results[] = ['i' => $i, 'ok' => false, 'msg' => 'No se pudo mover el archivo al destino.'];
                continue;
            }

                          // Tipo (puedes guardar MIME o la extensión)
            $tipo = $ext; // o @mime_content_type($destPath);

            // 5) Guardar en BD
            $data = [
                'id_bolsa'             => $id_bolsa,
                'id_usuario'           => $user_id,
                'nombre_personalizado' => $nombreBase,
                'nombre_archivo'       => $fileName,
                'tipo'                 => $tipo,
                'tipo_vista'           => 1,
                'eliminado'            => 0,
                // fecha_subida / fecha_actualizacion se cubren con defaults de la BD
            ];

            $okInsert = $this->db->insert('documentos_bolsa', $data);

            if ($okInsert) {
                $okCount++;
                $results[] = ['i' => $i, 'ok' => true, 'archivo' => $fileName];
            } else {
                // Si falla BD, opcionalmente borra el archivo físico
                @unlink($destPath);
                $results[] = ['i' => $i, 'ok' => false, 'msg' => 'Error al insertar en BD.'];
            }
        }

        return $this->output->set_output(json_encode([
            'ok'        => ($okCount > 0),
            'guardados' => $okCount,
            'detalles'  => $results,
        ]));
    }

/**
 * Convierte un texto en un slug seguro para nombre de archivo.
 */
    private function _slugify($str)
    {
        $str = trim($str);
        // Reemplazar acentos
        $unwanted = ['Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ü', 'á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü'];
        $replaced = ['A', 'E', 'I', 'O', 'U', 'N', 'U', 'a', 'e', 'i', 'o', 'u', 'n', 'u'];
        $str      = str_replace($unwanted, $replaced, $str);

        // Quitar cualquier cosa rara
        $str = preg_replace('~[^\pL0-9]+~u', '-', $str);
        $str = preg_replace('~^-+|-+$~', '', $str); // bordes
        $str = preg_replace('~-+~', '-', $str);     // múltiples guiones

        return strtolower($str);
    }

    /*----------------------------------------*/
    /*    Consultas
    /*----------------------------------------*/
    public function getDocumentosBolsa()
    {

        $id_bolsa = $this->input->post('id');

        $res = $this->reclutamiento_model->getDocumentosBolsa($id_bolsa);

        echo json_encode($res);
    }

    public function getDetailsOrderById()
    {
        $id  = $this->input->post('id');
        $res = $this->reclutamiento_model->getDetailsOrderById($id);
        echo json_encode($res);
    }
    public function getDetailsOrderByIdIntake()
    {
        $id  = $this->input->post('id');
        $res = $this->reclutamiento_model->getDetailsOrderByIdIntake($id);
        echo json_encode($res);
    }
    public function getAspirantesRequisiciones()
    {
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $condicion  = 'A.id_usuario';
        } else {
            $id_usuario = 0;
            $condicion  = 'A.id_usuario >';
        }
        $req['recordsTotal']    = $this->reclutamiento_model->getAspirantesRequisicionesTotal($id_usuario, $condicion);
        $req['recordsFiltered'] = $this->reclutamiento_model->getAspirantesRequisicionesTotal($id_usuario, $condicion);
        $req['data']            = $this->reclutamiento_model->getAspirantesRequisiciones($id_usuario, $condicion);
        $this->output->set_output(json_encode($req));
    }

    public function getAspirantesPorRequisicion()
    {

        $id_requisicion = $_GET['id'];

        // echo " aqui  el id  de la requisicion ".$id_requisicion ;
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $condicion  = 'A.id_usuario';
        } else {
            $id_usuario = 0;
            $condicion  = 'A.id_usuario >';
        }
        $req['recordsTotal']    = $this->reclutamiento_model->getAspirantesPorRequisicionTotal($id_usuario, $condicion, $id_requisicion);
        $req['recordsFiltered'] = $this->reclutamiento_model->getAspirantesPorRequisicionTotal($id_usuario, $condicion, $id_requisicion);
        $req['data']            = $this->reclutamiento_model->getAspirantesPorRequisicion($id_usuario, $condicion, $id_requisicion);
        $this->output->set_output(json_encode($req));

    }

    public function subirCVReqAspirante()
    {
        $this->form_validation->set_rules('id_cv', 'Archivos CV', 'required');
        $this->form_validation->set_rules('id_aspirante', 'Aspirante', 'required');
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

        $id_req_aspirante = $this->input->post('id_aspirante');
        $msj              = [];

        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            if (! empty($_FILES['id_cv']['name'])) {
                // Consultar si hay un CV previamente subido para este aspirante
                $cv_anterior = $this->reclutamiento_model->traerNombreCV($id_req_aspirante);

                if ($cv_anterior) {
                    // Eliminar el CV anterior del servidor
                    unlink('./_docs/' . $cv_anterior);

                    // Eliminar el registro del CV anterior de la base de datos
                    $this->candidato_model->eliminarCV($id_req_aspirante);
                }

                // Continuar con la carga del nuevo archivo CV
                // Define el array $_FILES para el archivo actual
                $_FILES['file'] = $_FILES['id_cv'];

                // Configura las preferencias de carga del archivo
                $config['upload_path']   = './_docs/';
                $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                $config['file_name']     = $id_req_aspirante . "_CV." . pathinfo($_FILES['id_cv']['name'], PATHINFO_EXTENSION);

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $data      = $this->upload->data();
                    $documento = [
                        'creacion'                 => date('Y-m-d H:i:s'),
                        'edicion'                  => date('Y-m-d H:i:s'),
                        'id_requisicion_aspirante' => $id_req_aspirante,
                        'id_tipo_documento'        => 16,
                        'archivo'                  => $data['file_name'], // Nombre del archivo
                    ];

                    $registroExitoso = $this->candidato_model->registrarDocumento($documento);

                    if ($registroExitoso) {
                        $msj = [
                            'codigo' => 1,
                            'msg'    => 'El archivo se subió correctamente',
                        ];
                    } else {
                        $msj = [
                            'codigo' => 0,
                            'msg'    => 'Ocurrio un problema  intentelo  mas  tarde ',
                        ];
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $msj   = [
                        'codigo' => 0,
                        'msg'    => 'Error al cargar el archivo: ' . $error,
                    ];
                }
            } else {
                $msj = [
                    'codigo' => 0,
                    'msg'    => 'No se seleccionó ningún archivo para cargar',
                ];
            }
        }

        echo json_encode($msj);
    }

    public function getHistorialAspirante()
    {
        $id      = $this->input->post('id');
        $tipo_id = $this->input->post('tipo_id');
        if ($tipo_id == 'aspirante') {
            $campo = 'id_aspirante';
        }

        if ($tipo_id == 'bolsa') {
            $campo = 'id_bolsa_trabajo';
        }

        $data['registros'] = $this->reclutamiento_model->getHistorialAspirante($id, $campo);
        if ($data['registros']) {
            echo json_encode($data['registros']);
        } else {
            echo $resp = 0;
        }
    }

    public function getAspirantesRequisicionesFinalizadas()
    {
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $condicion  = 'A.id_usuario';
        } else {
            $id_usuario = 0;
            $condicion  = 'A.id_usuario >';
        }
        $req['recordsTotal']    = $this->reclutamiento_model->getAspirantesRequisicionesFinalizadasTotal($id_usuario, $condicion);
        $req['recordsFiltered'] = $this->reclutamiento_model->getAspirantesRequisicionesFinalizadasTotal($id_usuario, $condicion);
        $req['data']            = $this->reclutamiento_model->getAspirantesRequisicionesFinalizadas($id_usuario, $condicion);
        $this->output->set_output(json_encode($req));
    }

    public function getAspirantesPorRequisicionesFinalizadas()
    {
        $id_requisicion = $_GET['id'];
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $condicion  = 'A.id_usuario';
        } else {
            $id_usuario = 0;
            $condicion  = 'A.id_usuario >';
        }
        $req['recordsTotal']    = $this->reclutamiento_model->getAspirantesPorRequisicionesFinalizadasTotal($id_usuario, $condicion, $id_requisicion);
        $req['recordsFiltered'] = $this->reclutamiento_model->getAspirantesPorRequisicionesFinalizadasTotal($id_usuario, $condicion, $id_requisicion);
        $req['data']            = $this->reclutamiento_model->getAspirantesPorRequisicionesFinalizadas($id_usuario, $condicion, $id_requisicion);
        $this->output->set_output(json_encode($req));
    }
    public function getBolsaTrabajoById()
    {
        $id  = $this->input->post('id');
        $res = $this->reclutamiento_model->getBolsaTrabajoById($id);
        /* echo'<pre>';
        print_r($res);
        echo'</pre>';
        die();*/
        echo json_encode($res);
    }

    public function getEmpleosByIdBolsaTrabajo()
    {
        $id              = $this->input->post('id');
        $data['empleos'] = $this->reclutamiento_model->getEmpleosByIdBolsaTrabajo($id);
        if ($data['empleos']) {
            echo json_encode($data['empleos']);
        } else {
            echo $resp = 0;
        }
    }

    public function getHistorialBolsaTrabajo()
    {
        $id                = $this->input->post('id');
        $data['registros'] = $this->reclutamiento_model->getHistorialBolsaTrabajo($id);
        if ($data['registros']) {
            echo json_encode($data['registros']);
        } else {
            echo $resp = 0;
        }
    }

    public function getRequisicionesActivas()
    {
        $res = $this->reclutamiento_model->getRequisicionesActivas();
        if ($res != null) {
            echo json_encode($res);
        } else {
            echo $res = 0;
        }

    }

    public function getTestsByOrder()
    {
        $id                = $this->input->post('id');
        $data['registros'] = $this->reclutamiento_model->getTestsByOrder($id);
        if ($data['registros']) {
            echo json_encode($data['registros']);
        } else {
            echo $resp = 0;
        }
    }

    public function getOrdersInProcess()
    {
        //Dependiendo el rol del usuario se veran todas o sus propias requisiciones
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $res        = $this->reclutamiento_model->getOrdersInProcessByUser($id_usuario);
        } else {
            $res = $this->reclutamiento_model->getAllOrdersInProcess();
        }
        echo json_encode($res);
    }

    public function getDetailsApplicantById()
    {
        $id  = $this->input->post('id');
        $res = $this->reclutamiento_model->getBolsaTrabajoById($id);
        echo json_encode($res);
    }

    public function getWarrantyApplicant()
    {
        $id  = $this->input->post('id');
        $res = $this->reclutamiento_model->getWarrantyApplicant($id);
        if ($res != null) {
            echo json_encode($res);
        } else {
            echo $res = 0;
        }

    }

    public function matchCliente()
    {
        if (isset($_GET['term'])) {
            //$term = strtoupper($_GET['term']);
            $term = $_GET['term'];
            //echo $id;
            echo json_encode($this->reclutamiento_model->matchCliente($term));
        }
    }
    public function verificar_archivos_existentes()
    {
        $id_portal = $this->session->userdata('idPortal');

        $registro = $this->cat_portales_model->getLogoAviso($id_portal);
        if (! $registro) {
            echo json_encode([]);
            return;
        }

        echo json_encode([
            'logo'  => $registro->logo ?? null,
            'aviso' => $registro->aviso ?? null,
            'link'  => $registro->link ?? null,
            'qr'    => $registro->qr ?? null,
        ]);
    }
    public function generar_o_mostrar_link()
    {
        $id_portal    = $this->session->userdata('idPortal');
        $logo         = $this->session->userdata('logo') ?? 'portal_icon.png';
        $aviso        = $this->session->userdata('aviso') ?? 'AV_TL_V1.pdf';
        $NombrePortal = $this->session->userdata('nombrePortal');
        $usuario_id   = $this->session->userdata('id');
        $tipo_bolsa   = (int) $this->session->userdata('tipo_bolsa');

        // Validar datos de sesión
        $errores = [];
        if (empty($logo)) {
            $errores[] = 'logo';
        }

        if (empty($id_portal)) {
            $errores[] = 'id_portal';
        }

        if (empty($NombrePortal)) {
            $errores[] = 'NombrePortal';
        }

        if (empty($usuario_id)) {
            $errores[] = 'usuario_id';
        }

        if (! empty($errores)) {
            echo json_encode(['error' => 'Datos de sesión faltantes: ' . implode(', ', $errores)]);
            return;
        }

        // Crear el payload para el JWT
        $payload = [
            "idUsuario"    => $usuario_id,
            "logo"         => $logo,
            "aviso"        => $aviso,
            "idPortal"     => $id_portal,
            "NombrePortal" => $NombrePortal,
        ];

        $private_key = $this->config->item('jwt_private_key');
        $jwt         = JWT::encode($payload, $private_key, 'RS256');

        if ($tipo_bolsa === 1) {
            $link = LINKASPIRANTESNUEVO . '?token=' . $jwt;
        } else {
            $link = LINKASPIRANTES . '?token=' . $jwt;
        }

        // Generar QR en base64
        $qr_base64 = $this->generar_qr_base64($link);
        date_default_timezone_set('America/Mexico_City');

        // Datos a guardar o actualizar
        $data = [
            'id_portal' => $id_portal,
            'link'      => $link,
            'qr'        => $qr_base64,
            'creacion'  => date('Y-m-d H:i:s'),
            'edicion'   => date('Y-m-d H:i:s'),
        ];

        // Verificar si ya existe el registro
        $registro = $this->reclutamiento_model->obtener_por_portal($id_portal);
        if ($registro) {
            // Actualizar si ya existe
            $this->reclutamiento_model->actualizar($id_portal, $data);
            $mensaje = 'Link actualizado correctamente.';
        } else {
            // Guardar si no existe
            $this->reclutamiento_model->guardarLink($data);
            $mensaje = 'Link generado correctamente.';
        }

        // Devolver link, QR y mensaje
        echo json_encode([
            'link'    => $link,
            'qr'      => $qr_base64,
            'mensaje' => $mensaje,
        ]);
    }

    private function generar_qr_base64($text)
    {
        // Crear el código QR usando la librería Endroid
        $qrCode = new QrCode($text);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        // Usar el writer para generar el QR como imagen PNG
        $writer = new PngWriter();

        // Generar la imagen PNG
        $imageString = $writer->write($qrCode)->getString();

        // Convertir la imagen a base64 y retornarla
        return 'data:image/png;base64,' . base64_encode($imageString);
    }

    public function get_links()
    {
        // Obtenemos datos desde el modelo
        $data = $this->reclutamiento_model->get_active_links();

        // Respondemos en formato JSON
        echo json_encode([
            'success' => true,
            'data'    => $data,
        ]);
    }

    public function eliminar_extra()
    {
        $id  = $this->input->post('id');
        $key = $this->input->post('key');

        // Obtienes el registro
        $registro = $this->db->get_where('aspirantes', ['id' => $id])->row();

        if ($registro) {
            // Decodificas el JSON de extras
            $extras = json_decode($registro->extras, true);

            if (isset($extras[$key])) {
                unset($extras[$key]); // eliminas la clave
                $this->db->where('id', $id)
                    ->update('aspirantes', ['extras' => json_encode($extras)]);
                echo 'ok';
            } else {
                echo 'error: clave no encontrada';
            }
        } else {
            echo 'error: registro no encontrado';
        }
    }

    public function actualizar_status()
    {
        $id     = (int) $this->input->post('id');
        $status = (int) $this->input->post('status');

        if ($id <= 0 || $status < 1 || $status > 5) {
            echo json_encode(['ok' => false, 'msg' => 'Datos inválidos']);
            return;
        }

        $this->db->where('id', $id)->update('bolsa_trabajo', [
            'status'     => $status,
            'edicion'    => date('Y-m-d H:i:s'),
            'id_usuario' => $this->session->userdata('id'),
        ]);

        echo json_encode(['ok' => true]);
    }

    public function eliminarAspirante()
    {
        $id         = $this->input->post('id');
        $id_usuario = $this->session->userdata('id');
        $fecha      = date('Y-m-d H:i:s');

        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('requisicion_aspirante', [
                'eliminado'  => 1,
                'edicion'    => $fecha,
                'id_usuario' => $id_usuario,
            ]);

            echo json_encode(['status' => 'ok']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'ID no recibido']);
        }
    }

}
