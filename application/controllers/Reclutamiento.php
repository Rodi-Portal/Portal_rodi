<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reclutamiento extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('Login/index');
            $this->load->helper('language');

        }
        $this->load->helper('language');
        $this->lang->load('registro_candidatos', 'english');
        $this->load->library('usuario_sesion');
        $this->usuario_sesion->checkStatusBD();

    }
    public function index()
    {
        // Llama a la vista y pasa los datos necesarios
        $this->load->view('modals/mdl_reclutamiento');
    }

    /*----------------------------------------*/
    /*  Submenus
    /*----------------------------------------*/
    public function requisicion()
    {
        $filter = '';
        $getFilter = '';
        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;
        //Filtros de busqueda y ordenamiento
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
            $sort = 'DESC';
            $getSort = '';
        }
        if (isset($_GET['filter'])) {

            $getFilter = $_GET['filter'];
            $filterOrder = '';
            if ($getFilter == 'COMPLETA' || $getFilter == 'EXPRESS') {
                $filter = $getFilter;
                $filterOrder = 'R.tipo';
            }
            if ($getFilter == 'En espera') {
                $filter = 1;
                $filterOrder = 'R.status';
            }
            if ($getFilter == 'En proceso') {
                $filter = 2;
                $filterOrder = 'R.status';
            }
        } else {

            $filter = '';
            $filterOrder = 'R.tipo !=';
        }
        if (isset($_GET['order'])) {
            $order = $_GET['order'];
            if ($order != '') {
                $id_order = ($order > 0) ? $order : 0;
                $condition_order = ($order > 0) ? 'R.id' : 'R.id >';
            } else {
                $id_order = 0;
                $condition_order = 'R.id >';
            }
        } else {
            $id_order = 0;
            $condition_order = 'R.id >';
        }
        //Dependiendo el rol del usuario se veran todas o sus propias requisiciones
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $info['requisiciones'] = $this->reclutamiento_model->getOrdersByUser($id_usuario, $sort, $id_order, $condition_order);
            $info['orders_search'] = $this->reclutamiento_model->getOrdersByUser($id_usuario, $sort, 0, 'R.id >');
            $info['sortOrder'] = $getSort;
            $info['filter'] = $getFilter;
        } else {

            $info['requisiciones'] = $this->reclutamiento_model->getAllOrders($sort, $id_order, $condition_order, $filter, $filterOrder);
            $info['orders_search'] = $this->reclutamiento_model->getAllOrders($sort, 0, 'R.id >', $filter, $filterOrder);
            //var_dump($info['orders_search']);
            $info['sortOrder'] = $getSort;
            $info['filter'] = $getFilter;
        }
        $info['registros'] = null;
        $info['medios'] = $this->funciones_model->getMediosContacto();
        $info['puestos'] = $this->funciones_model->getPuestos();
        $info['paises'] = $this->funciones_model->getPaises();
        $info['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();

        //Obtiene los usuarios con id rol 4 y 11 que pertencen a reclutadores y coordinadores de reclutadores
        $info['usuarios_asignacion'] = $this->usuario_model->getTipoUsuarios([4, 11]);
        $info['registros_asignacion'] = $this->reclutamiento_model->getRequisicionesActivas();
        $info['acciones'] = $this->funciones_model->getAccionesRequisicion();
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $reqs = $this->reclutamiento_model->getOrdersInProcessByUser($id_usuario);
        } else {
            $reqs = $this->reclutamiento_model->getAllOrdersInProcess();
        }

        //var_dump($reqs);
        $info['reqs'] = $reqs;
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
        $vista['modals_reclutamiento'] = $this->load->view('modals/mdl_reclutamiento', $info, true);

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
        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('reclutamiento/requisicion', $vista)
            ->view('adminpanel/footer');
    }
    public function control()
    {
        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;
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
            $sort = 'DESC';
            $getSort = '';
        }
        if (isset($_GET['filter'])) {
            $getFilter = $_GET['filter'];
            if ($getFilter == 'COMPLETA' || $getFilter == 'EXPRESS') {
                $filter = $getFilter;
                $filterOrder = 'R.tipo';
            }
            if ($getFilter == 'En espera') {
                $filter = 1;
                $filterOrder = 'R.status';
            }
            if ($getFilter == 'En proceso') {
                $filter = 2;
                $filterOrder = 'R.status';
            }
        } else {
            $getFilter = '';
            $filter = '';
            $filterOrder = 'R.tipo !=';
        }
        if (isset($_GET['order'])) {
            $order = $_GET['order'];
            if ($order != '') {
                $id_order = ($order > 0) ? $order : 0;
                $condition_order = ($order > 0) ? 'R.id' : 'R.id >';
            } else {
                $id_order = 0;
                $condition_order = 'R.id >';
            }
        } else {
            $id_order = 0;
            $condition_order = 'R.id >';
        }
        //Dependiendo el rol del usuario se veran todas o sus propias requisiciones
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $reqs = $this->reclutamiento_model->getOrdersInProcessByUser($id_usuario);
            $info['requisiciones'] = $this->reclutamiento_model->getOrdersByUser($id_usuario, $sort, $id_order, $condition_order);
            $info['orders_search'] = $this->reclutamiento_model->getOrdersByUser($id_usuario, $sort, 0, 'R.id >');
        } else {
            $reqs = $this->reclutamiento_model->getAllOrdersInProcess();
            $info['requisiciones'] = $this->reclutamiento_model->getAllOrders($sort, $id_order, $condition_order, $filter, $filterOrder);
            $info['orders_search'] = $this->reclutamiento_model->getAllOrders($sort, 0, 'R.id >', $filter, $filterOrder);
        }
        $data['reqs'] = $reqs;
        $info['reqs'] = $reqs;
        $info['medios'] = $this->funciones_model->getMediosContacto();
        $info['acciones'] = $this->funciones_model->getAccionesRequisicion();
        $info['puestos'] = $this->funciones_model->getPuestos();
        $info['paises'] = $this->funciones_model->getPaises();
        $info['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
        $vista['modals'] = $this->load->view('modals/mdl_reclutamiento', $info, true);

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
        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('reclutamiento/control', $vista)
            ->view('adminpanel/footer');
    }
    public function finalizados()
    {
        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;
        //Dependiendo el rol del usuario se veran todas o sus propias requisiciones
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $condicion = 'R.id_usuario';
        } else {
            $id_usuario = 0;
            $condicion = 'R.id_usuario >=';
        }
        $reqs = $this->reclutamiento_model->getRequisicionesFinalizadas($id_usuario, $condicion);
        $data['reqs'] = $reqs;
        $info['reqs'] = $reqs;
        $info['medios'] = null;
        $info['acciones'] = null;
        $info['paises'] = null;
        $info['paquetes_antidoping'] = null;
        //$info['acciones'] = $this->funciones_model->getAccionesRequisicion();
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
        $vista['modals'] = $this->load->view('modals/mdl_reclutamiento', $info, true);
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

        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('reclutamiento/finalizados', $vista)
            ->view('adminpanel/footer');
    }
    public function bolsa()
    {
        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;
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
            $sort = 'DESC';
            $getSort = '';
        }
        if (isset($_GET['filter']) && $_GET['filter'] != 'none') {
            $getFilter = $_GET['filter'];
            if ($getFilter == 'En espera') {
                $filter = 1;
                $filterApplicant = 'B.status';
            }
            if ($getFilter == 'En proceso') {
                $filter = 2;
                $filterApplicant = 'B.status';
            }
            if ($getFilter == 'Aceptado') {
                $filter = 3;
                $filterApplicant = 'B.status';
            }
            if ($getFilter == 'ESE') {
                $filter = 4;
                $filterApplicant = 'B.status';
            }
            if ($getFilter == 'Bloqueado') {
                $filter = 0;
                $filterApplicant = 'B.status';
            }
        } else {
            $getFilter = '';
            $filter = '';
            $filterApplicant = 'B.id !=';
        }
        if (isset($_GET['user'])) {
            $user = $_GET['user'];
            $getUser = $_GET['user'];
            if ($user != '') {
                $idUser = ($user > 0) ? $user : 0;
                $condition_user = ($user > 0) ? 'B.id_usuario' : 'B.id_usuario >=';
            } else {
                $idUser = 0;
                $condition_user = 'B.id >';
            }
        } else {
            $idUser = 0;
            $condition_user = 'B.id >';
            $getUser = '';
        }
        if (isset($_GET['area']) && $_GET['area'] != 'none') {
            $area = $_GET['area'];
            $getArea = $_GET['area'];
            if ($area !== '') {
                $area_interest = $area;
                $condition_area = 'B.area_interes';
            } else {
                $area_interest = '';
                $condition_area = 'B.area_interes !=';
            }
        } else {
            $area_interest = '';
            $condition_area = 'B.area_interes !=';
            $getArea = '';
        }
        if (isset($_GET['applicant'])) {
            $applicant = $_GET['applicant'];
            if ($applicant != '') {
                $id_applicant = ($applicant > 0) ? $applicant : 0;
                $condition_applicant = ($applicant > 0) ? 'B.id' : 'B.id >';
            } else {
                $id_applicant = 0;
                $condition_applicant = 'B.id >';
            }
        } else {
            $id_applicant = 0;
            $condition_applicant = 'B.id >';
        }

        //Dependiendo el rol del usuario se veran todas o sus propias requisiciones
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $info['registros'] = $this->reclutamiento_model->getApplicantsByUser($sort, $id_applicant, $condition_applicant, $filter, $filterApplicant, $id_usuario, $area_interest, $condition_area);
            $condition = 'B.id_usuario';
        } else {
            $info['registros'] = $this->reclutamiento_model->getBolsaTrabajo($sort, $id_applicant, $condition_applicant, $filter, $filterApplicant, $idUser, $condition_user, $area_interest, $condition_area);
            $id_usuario = 0;
            $condition = 'B.id_usuario >=';
        }
        $info['sortApplicant'] = $getSort;
        $info['filter'] = $getFilter;
        $info['assign'] = $getUser;
        $info['area'] = $getArea;

        $info['civiles'] = $this->funciones_model->getEstadosCiviles();
        $info['grados'] = $this->funciones_model->getGradosEstudio();
        $info['medios'] = $this->funciones_model->getMediosContacto();
        $info['puestos'] = $this->funciones_model->getPuestos();
        $info['paises'] = $this->funciones_model->getPaises();
        $info['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
        $info['reqs'] = null;
        $info['acciones'] = null;
        //Obtiene los usuarios con id rol 4 y 11 que pertencen a reclutadores y coordinadores de reclutadores
        $info['usuarios_asignacion'] = $this->usuario_model->getTipoUsuarios([4, 11]);
        $info['registros_asignacion'] = $this->reclutamiento_model->getAllApplicants($id_usuario, $condition);
        $info['areas_interes'] = $this->reclutamiento_model->getAllJobPoolByArea();
        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
        $vista['modals'] = $this->load->view('modals/mdl_reclutamiento', $info, true);

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
        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('reclutamiento/bolsa_trabajo', $vista)
            ->view('adminpanel/footer');
    }

    /*----------------------------------------*/
    /*    Acciones
    /*----------------------------------------*/
    public function cambiarStatusrequisicion()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        $id_usuario = $this->session->userdata('id');
        $usuario = array(
            'status' => $status,
            'id_usuario' => $id_usuario,
        );

        $resultado = $this->reclutamiento_model->cambiarStatusrequisicion($id, $usuario);

        // Manejar los diferentes resultados retornados por el modelo
        if (strpos($resultado, 'Error') !== false) {
            // Si el resultado contiene la palabra "Error", se considera un error
            $msj = array(
                'codigo' => 0,
                'msg' => $resultado, // Mensaje de error específico
            );
        } else {
            // Si no hay "Error", se asume que la actualización fue exitosa
            $msj = array(
                'codigo' => 1,
                'msg' => $resultado, // Mensaje de éxito
            );
        }

        echo json_encode($msj);
    }
    public function reactivarRequisicion()
    {
        $id = $this->input->post('id');
        $usuario = $this->session->userdata('id');
        $this->reclutamiento_model->reactivarRequisicion($id, $usuario);
        $msj = array(
            'codigo' => 1,
            'msg' => 'Se  a creado  una copia  de esta  Requisición para  que se  inicie el proceso ',
        );
        echo json_encode($msj);
    }
    public function addApplicant()
    {
        $this->form_validation->set_rules('requisicion', 'Asignar requisición', 'required');
        $this->form_validation->set_rules('nombre', 'Nombre(s)', 'required|trim');
        $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
        $this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
        $this->form_validation->set_rules('domicilio', 'Localización o domicilio', 'required|trim');
        $this->form_validation->set_rules('area_interes', 'Área de interés', 'required|trim');
        $this->form_validation->set_rules('medio', 'Medio de contacto', 'required|trim');
        $this->form_validation->set_rules('telefono', 'Teléfono', 'required|trim|max_length[16]');
        $this->form_validation->set_rules('correo', 'Correo', 'trim|valid_email');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = array();
        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            $date = date('Y-m-d H:i:s');
            $id_portal = $this->session->userdata('idPortal');
            $req = $this->input->post('requisicion');
            $nombre = $this->input->post('nombre');
            $paterno = $this->input->post('paterno');
            $materno = $this->input->post('materno');
            $medio = $this->input->post('medio');
            $telefono = $this->input->post('telefono');
            $correo = $this->input->post('correo');
            $id_usuario = $this->session->userdata('id');
            $id_aspirante = $this->input->post('id_aspirante');
            $idRol = $this->session->userdata('idrol');

            $id_bolsa_trabajo = $this->input->post('id_bolsa_trabajo');
            $notificacion = 0;

            $nombre_archivo = null;
            if (empty($id_aspirante)) {
                if (empty($id_bolsa_trabajo)) {
                    $jobPool = array(
                        'creacion' => $date,
                        'edicion' => $date,
                        'id_portal' => $id_portal,
                        'id_usuario' => $id_usuario,
                        'nombre' => strtoupper($nombre),
                        'paterno' => strtoupper($paterno),
                        'materno' => strtoupper($materno),
                        'telefono' => $telefono,
                        'medio_contacto' => $medio,
                        'area_interes' => $this->input->post('area_interes'),
                        'domicilio' => $this->input->post('domicilio'),
                        'status' => 2,
                    );
                    $id_bolsa_trabajo = $this->reclutamiento_model->addJobPoolWithIdReturned($jobPool);
                } else {
                    $bolsa = array(

                        'id_portal' => $id_portal,
                        'edicion' => $date,
                        'nombre' => strtoupper($nombre),
                        'paterno' => strtoupper($paterno),
                        'materno' => strtoupper($materno),
                        'telefono' => $telefono,
                        'medio_contacto' => $medio,
                        'area_interes' => $this->input->post('area_interes'),
                        'domicilio' => $this->input->post('domicilio'),
                        'status' => 2,
                    );

                    if ($idRol != 6) {
                        $bolsa['id_usuario'] = $id_usuario;
                    }
                    $this->reclutamiento_model->editBolsaTrabajo($bolsa, $id_bolsa_trabajo);
                }
                if ($this->reclutamiento_model->existeRegistro($id_bolsa_trabajo, $req)) {
                    // Ya existe un registro, puedes manejarlo según tu lógica de negocio
                    // Por ejemplo, podrías mostrar un mensaje de error o hacer alguna otra acción

                    $msj = array(
                        'codigo' => 0,
                        'msg' => "Ya  esta  Registrado elaspirante  para  esta  requicisión ",
                    );

                } else {
                    // No existe un registro, procedemos a agregar el nuevo registro
                    $datos = array(
                        'creacion' => $date,
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'id_bolsa_trabajo' => $id_bolsa_trabajo,
                        'id_requisicion' => $req,
                        'correo' => $correo,
                        'cv' => $nombre_archivo,
                        'status' => 'Registrado',
                    );
                    $id_req_aspirante = $this->reclutamiento_model->addApplicant($datos);

                    if ($id_bolsa_trabajo != 0) {
                        $bolsa = array(
                            'status' => 2,
                        );
                        $this->reclutamiento_model->editBolsaTrabajo($bolsa, $id_bolsa_trabajo);
                    }

                    // Llamar a la API solo si el registro se agregó correctamente
                    if ($id_req_aspirante && $notificacion > 0) {
                        $result2 = $this->notificaciones_whatsapp_model->obtenerDatosPorRequisicionAspirante($id_req_aspirante);

                        // Verifica que el resultado no sea NULL y que sea un objeto
                        if ($result2 && $result2->phone != null) {
                            $datos_plantilla = array(
                                'nombre_cliente' => $result2->nombre_cliente,
                                'nombre_aspirante' => $result2->nombre_completo,
                                'vacante' => $result2->vacante,
                                'telefono' => $result2->phone,
                            );

                            $api_response = $this->notificaciones_whatsapp_model->alertaMovimientoApirante('52' . $result2->phone . '', 'hello_world', $datos_plantilla);

                            if ($api_response['codigo'] == 1) {
                                $msj = array(
                                    'codigo' => 1,
                                    'msg' => 'El aspirante fue guardado correctamente.  Y se notifico al cliente via  whatssapp ' . $api_response['msg'],
                                );
                            } else {
                                $msj = array(
                                    'codigo' => 0,
                                    'msg' => 'El aspirante fue guardado correctamente, pero no se pudo notificar al cliente . ' . $api_response['msg'],
                                );
                            }
                        }

                        // Llamar a la API con los datos de la plantilla

                    } else {
                        $msj = array(
                            'codigo' => 0,
                            'msg' => 'El aspirante fue guardado correctamente, pero no se pudo notificar al cliente .',
                        );
                    }
                }
            } elseif ($id_aspirante > 0) {
                $datos_rh = array(
                    'id_requisicion' => $req,
                    'correo' => $correo,
                );
                $datos_bt = array(

                    'id_portal' => $id_portal,
                    'edicion' => $date,
                    'nombre' => strtoupper($nombre),
                    'paterno' => strtoupper($paterno),
                    'materno' => strtoupper($materno),
                    'telefono' => $telefono,
                    'medio_contacto' => $medio,
                    'area_interes' => $this->input->post('area_interes'),
                    'domicilio' => $this->input->post('domicilio'),
                );

                $resultado = $this->reclutamiento_model->editarDatosAspiranteBolsa($datos_bt, $id_bolsa_trabajo, $datos_rh, $id_aspirante);

                // Verificar si la función se ejecutó correctamente
                if ($resultado) {
                    // La función se ejecutó correctamente
                    $msj = array(
                        'codigo' => 1,
                        'msg' => 'El aspirante fue Actualizado correctamente :)',
                    );
                } else {
                    // La función no se ejecutó correctamente
                    $msj = array(
                        'codigo' => 0,
                        'msg' => 'El aspirante no pudo ser actualizado :(',
                    );
                }

            }

        }
        echo json_encode($msj);
    }

    public function guardarAccionRequisicion()
    {
        $this->form_validation->set_rules('accion', 'Acción a aplicar', 'required|trim');
        $this->form_validation->set_rules('comentario', 'Comentario / Descripción / Fecha y lugar', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = array();
        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');
            $estatus_final = null;
            $comentario = $this->input->post('comentario');
            $id_usuario = $this->session->userdata('id');
            $id_aspirante = $this->input->post('id_aspirante');
            $id_requisicion = $this->input->post('id_requisicion');
            $accion = explode(':', $this->input->post('accion'));
            $aspirante = $this->reclutamiento_model->getAspiranteById($id_aspirante);
            $idRol = $this->session->userdata('idrol');
            $notificacion = 0;
            // Determinar estatus final
            if ($accion[0] == 13 || $accion[0] == 15) {
                $estatus_final = 'CANCELADO';
            } elseif ($accion[0] == 17) {
                $estatus_final = 'FINALIZADO';
            } elseif ($accion[0] == 16) {
                $estatus_final = 'COMPLETADO';
            }

            $datos_accion = array(
                'creacion' => $date,
                'id_usuario' => $id_usuario,
                'id_requisicion' => $id_requisicion,
                'id_bolsa_trabajo' => $aspirante->id_bolsa_trabajo,
                'id_aspirante' => $id_aspirante,
                'accion' => $accion[1],
                'descripcion' => $comentario,
            );

            $data_aspirante = array(
                'edicion' => $date,

                'status' => $accion[1],
                'status_final' => $estatus_final,
            );
            if ($idRol != 6) {
                $data_aspirante['id_usuario'] = $id_usuario;
            }

            // Determinar estatus de bolsa de trabajo
            switch ($accion[0]) {
                case 9:
                case 13:
                case 15:
                    $estatus_bolsa = 1;
                    $semaforo = 2;
                    break;
                case 16:
                    $estatus_bolsa = 3;
                    $semaforo = 1;
                    break;
                case 17:
                    $estatus_bolsa = 1;
                    $semaforo = 0;
                    break;
                default:
                    $estatus_bolsa = 2;
                    $semaforo = 0;
                    break;
            }

            $data_bolsa = array(
                'edicion' => $date,
                'status' => $estatus_bolsa,
                'semaforo' => $semaforo,
            );

            // Realizar todas las operaciones en una transacción
            $result = $this->reclutamiento_model->registrarMovimiento($datos_accion, $data_aspirante, $data_bolsa, $aspirante->id_bolsa_trabajo, $id_aspirante);

            if ($result && $notificacion > 0 ) {
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

        $msj = array();
        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');
            $comentario = $this->input->post('comentario');
            $id_usuario = $this->session->userdata('id');
            $estatus_final = $this->input->post('estatus');
            $id_requisicion = $this->input->post('id_requisicion');
            $idRol = $this->session->userdata('idrol');

            //Cancela Requisicion
            if ($estatus_final == 0) {
                $status = 'status';
                $acciones = 1;

                $condicion = 'A.id_usuario >';
                $data['aspirantes'] = $this->reclutamiento_model->getAspirantesPorRequisicion($id_usuario, $condicion, $id_requisicion);
                if ($data['aspirantes']) {
                    foreach ($data['aspirantes'] as $row) {
                        $bolsa = array(
                            'edicion' => $date,
                            'status' => 1,
                        );
                        $this->reclutamiento_model->editBolsaTrabajo($bolsa, $row->id_bolsa_trabajo);
                    }
                }
                $datos = array(
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    $status => $estatus_final,
                    'comentario_final' => $comentario,
                );

                $this->reclutamiento_model->editarRequisicion($datos, $id_requisicion);
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'La requisición fue cancelada correctamente',
                );
            }
            //Se elimina la requisicion
            if ($estatus_final == 1) {
                $status = 'eliminado';
                $acciones = 1;
                $id_usuario = 0;
                $condicion = 'A.id_usuario >';
                $data['aspirantes'] = $this->reclutamiento_model->getAspirantesPorRequisicion($id_usuario, $condicion, $id_requisicion);
                if ($data['aspirantes']) {
                    foreach ($data['aspirantes'] as $row) {
                        $bolsa = array(
                            'edicion' => $date,
                            'status' => 1,
                        );
                        $this->reclutamiento_model->editBolsaTrabajo($bolsa, $row->id_bolsa_trabajo);
                    }
                }
                $datos = array(
                    'edicion' => $date,

                    $status => $estatus_final,
                    'comentario_final' => $comentario,
                );

                if ($idRol != 6) {
                    $datos['id_usuario'] = $id_usuario;
                }
                $this->reclutamiento_model->editarRequisicion($datos, $id_requisicion);
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'La requisición fue eliminada correctamente',
                );
            }
            //Termina o finaliza Requisicion
            if ($estatus_final == 3) {
                $status = 'status';
                $acciones = ['FINALIZADO', 'COMPLETADO', 'ESE FINALIZADO'];
                $sin_registro_socio = 0;
                $num_aspirantes = $this->reclutamiento_model->getVacantesCubiertasTotal($id_requisicion, $acciones);
                $requisicion = $this->reclutamiento_model->getRequisionById($id_requisicion);
                if ($num_aspirantes >= $requisicion->numero_vacantes) {
                    $data['candidatos'] = $this->reclutamiento_model->getCandidatosByRequisicion($id_requisicion);
                    foreach ($data['candidatos'] as $row) {
                        if ($row->id_aspirante == null || $row->id_aspirante == '') {
                            $sin_registro_socio = 1;
                            break;
                        }
                    }

                    $datos = array(
                        'edicion' => $date,
                        $status => $estatus_final,
                        'comentario_final' => $comentario,
                    );
                    if ($idRol != 6) {
                        $datos['id_usuario'] = $id_usuario;
                    }
                    $this->reclutamiento_model->editarRequisicion($datos, $id_requisicion);
                    $msj = array(
                        'codigo' => 1,
                        'msg' => 'La requisición fue terminada correctamente',
                    );

                } else {
                    $msj = array(
                        'codigo' => 0,
                        'msg' => 'Se debe cumplir el numero de vacantes, el registro del sueldo acordado y fecha de ingreso al empleo',
                    );
                }
            }
        }
        echo json_encode($msj);
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

    public function cambiarStatusBolsaTrabajo()
    {
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_usuario = $this->session->userdata('id');
        $idRol = $this->session->userdata('idrol');
        $id_bolsa = $this->input->post('id_bolsa');
        $comentario = $this->input->post('comentario');
        $accion = $this->input->post('accion');
        $aspirante = $this->reclutamiento_model->getAspiranteByBolsaTrabajo($id_bolsa);
        $msj = array(); // Inicializa $msj como un array vacío

        if ($comentario != '') {
            if ($aspirante != null) {
                $aspirante_data = array(
                    'edicion' => $date,
                    'status' => 'Bloqueado del proceso de reclutamiento',
                    'status_final' => 'BLOQUEADO',
                );
                if ($idRol != 6) {
                    $datos['id_usuario'] = $id_usuario;
                }
                $this->reclutamiento_model->editarAspirante($aspirante_data, $aspirante->id);
                $historial = array(
                    'creacion' => $date,
                    'id_usuario' => $id_usuario,
                    'id_requisicion' => $aspirante->id_requisicion,
                    'id_bolsa_trabajo' => $id_bolsa,
                    'id_aspirante' => $aspirante->id,
                    'accion' => 'Usuario bloquea a la persona del proceso de reclutamiento',
                    'descripcion' => $comentario,
                );
                $this->reclutamiento_model->guardarAccionRequisicion($historial);
            }

            // Cambiar estado de la bolsa de trabajo
            $bolsa = array(
                'status' => ($accion == 'bloquear') ? 0 : 1,
            );
            $this->reclutamiento_model->editBolsaTrabajo($bolsa, $id_bolsa);

            $msj = array(
                'codigo' => 1,
                'msg' => ($accion == 'bloquear') ? 'Se ha bloqueado correctamente' : 'Se ha desbloqueado correctamente',
            );
        } else {
            $msj = array(
                'codigo' => 0,
                'msg' => 'Debes llenar el motivo de bloqueo e intentarlo de nuevo',
            );
        }

        echo json_encode($msj);
    }

    public function guardarHistorialBolsaTrabajo()
    {
        // Configuración de las reglas de validación
        $this->form_validation->set_rules('comentario', 'Comentario / Estatus', 'required|trim');
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        // Inicializa el mensaje de respuesta
        $msj = array();

        // Verificar validación
        if ($this->form_validation->run() === false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            // Configuración de fecha y obtención de datos
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');
            $comentario = $this->input->post('comentario');
            $id_usuario = $this->session->userdata('id');
            $id_bolsa = $this->input->post('id_bolsa');
            $tipo = $this->session->userdata('tipo');
            $nombre = ($tipo == 1) ? 'Reclutador' : 'Cliente';
            $notificacion = 0; // Cambia esto a 0 si quieres desactivar las notificaciones

            // Datos a guardar en el historial
            $datos = array(
                'creacion' => $date,
                'id_usuario' => $id_usuario,
                'id_requisicion_aspirante' => $id_bolsa,
                'nombre_rol' => $nombre,
                'comentario' => $comentario,
            );

            // Guardar el historial en la base de datos
            $result = $this->reclutamiento_model->guardarHistorialBolsaTrabajo($datos);

            // Verificar si el guardado fue exitoso
            if ($result) {
                if ($notificacion > 0) {
                    // Obtener datos para notificación
                    if ($tipo == 1) {
                        $result2 = $this->notificaciones_whatsapp_model->obtenerDatosPorRequisicionAspirante($id_bolsa);

                        if ($result2 && !empty($result2->phone)) {
                            $datos_plantilla = array(
                                'nombre_cliente' => $result2->nombre_cliente,
                                'nombre_aspirante' => $result2->nombre_completo,
                                'vacante' => $result2->vacante,
                                'telefono' => $result2->phone,
                                'ruta' => 'send-message-comentario-reclu', // Ajusta según sea necesario
                            );

                            $api_response = $this->notificaciones_whatsapp_model->alertaMovimientoApirante('52' . $result2->phone, 'mensaje_reclutador', $datos_plantilla);

                            if ($api_response['codigo'] == 1) {
                                $msj = array(
                                    'codigo' => 1,
                                    'msg' => 'El registro se realizó correctamente. ' . $api_response['msg'],
                                );
                            } else {
                                $msj = array(
                                    'codigo' => 0,
                                    'msg' => $api_response['msg'],
                                );
                            }
                        } else {
                            // Datos para notificación no válidos
                            $msj = array(
                                'codigo' => 1,
                                'msg' => 'El registro se realizó correctamente. La notificación no fue enviada porque no se encontraron datos válidos para notificar.',
                            );
                        }

                    } else {
                        $result2 = $this->notificaciones_whatsapp_model->obtenerDatosPorRequisicionAspiranteCliente($id_bolsa);
                        if ($result2 && !empty($result2->phone)) {
                            $datos_plantilla = array(
                                'nombre_reclu' => $result2->nombre_reclutador,
                                'nombre_cliente' => $result2->nombre_cliente,
                                'nombre_aspirante' => $result2->nombre_completo,
                                'vacante' => $result2->vacante,
                                'telefono' => $result2->phone,
                                'ruta' => 'send-message-comentario-cliente', // Ajusta según sea necesario
                            );
                            /* echo '<pre>';

                            print_r($datos_plantilla);
                            echo '</pre>';
                            die();*/
                            $api_response = $this->notificaciones_whatsapp_model->alertaMovimientoApirante('52' . $result2->phone, 'mensaje_cliente', $datos_plantilla);

                            if ($api_response['codigo'] == 1) {
                                $msj = array(
                                    'codigo' => 1,
                                    'msg' => 'El registro se realizó correctamente. ' . $api_response['msg'],
                                );
                            } else {
                                $msj = array(
                                    'codigo' => 0,
                                    'msg' => $api_response['msg'],
                                );
                            }
                        } else {
                            // Datos para notificación no válidos
                            $msj = array(
                                'codigo' => 1,
                                'msg' => 'El registro se realizó correctamente. La notificación no fue enviada porque no se encontraron datos válidos para notificar.',
                            );
                        }
                    }

                } else {
                    // Notificación desactivada
                    $msj = array(
                        'codigo' => 1,
                        'msg' => 'El registro se realizó correctamente. La notificación no fue enviada.',
                    );
                }
            } else {
                // Fallo en el guardado
                $msj = array(
                    'codigo' => 0,
                    'msg' => 'No se pudo registrar el comentario, intente más tarde.',
                );
            }
        }

        // Enviar la respuesta como JSON
        echo json_encode($msj);
    }

    public function addRequisicion()
    {
        $this->form_validation->set_rules('id_cliente', 'Cliente', 'required|trim');
        $this->form_validation->set_rules('nombre_comercial_req', 'Nombre comercial', 'required|trim');
        $this->form_validation->set_rules('nombre_req', 'Razón social', 'required|trim');
        $this->form_validation->set_rules('correo_req', 'Correo', 'required|trim|valid_email');
        $this->form_validation->set_rules('cp_req', 'Código postal', 'required|trim|max_length[5]');
        $this->form_validation->set_rules('telefono_req', 'Teléfono', 'required|trim|max_length[16]');
        $this->form_validation->set_rules('contacto_req', 'Contacto', 'trim|required');
        $this->form_validation->set_rules('rfc_req', 'RFC', 'trim|max_length[13]');
        $this->form_validation->set_rules('pais_req', 'País', 'trim');
        $this->form_validation->set_rules('estado_req', 'Estado', 'trim');
        $this->form_validation->set_rules('ciudad_req', 'Ciudad', 'trim');
        $this->form_validation->set_rules('colonia_req', 'Colonia', 'trim');
        $this->form_validation->set_rules('calle_req', 'Calle', 'trim');
        $this->form_validation->set_rules('interior_req', 'Número Interior', 'trim');
        $this->form_validation->set_rules('exterior_req', 'Número Exterior', 'trim');
        $this->form_validation->set_rules('regimen_req', 'Régimen Fiscal', 'trim');
        $this->form_validation->set_rules('forma_pago_req', 'Forma de pago', 'trim');
        $this->form_validation->set_rules('metodo_pago_req', 'Método de pago', 'trim');
        $this->form_validation->set_rules('uso_cfdi_req', 'Uso de CFDI', 'trim');

        $this->form_validation->set_rules('puesto_req', 'Nombre de la posición', 'required|trim');
        $this->form_validation->set_rules('numero_vacantes_req', 'Número de vacantes', 'required|numeric|max_length[2]');
        $this->form_validation->set_rules('residencia_req', 'Lugar de residencia', 'trim');
        $this->form_validation->set_rules('escolaridad_req', 'Formación académica requerida', 'trim');
        $this->form_validation->set_rules('estatus_escolaridad_req', 'Estatus académico', 'trim');
        $this->form_validation->set_rules('otro_estatus_req', 'Otro estatus académico', 'trim');
        $this->form_validation->set_rules('carrera_req', 'Carrera requerida para el puesto', 'trim');
        $this->form_validation->set_rules('otros_estudios_req', 'Otro estatus académico', 'trim');
        $this->form_validation->set_rules('idioma1_req', 'Idiomas que habla  ', 'trim');
        $this->form_validation->set_rules('por_idioma1_req', 'Porcentaje idioma uno', 'trim');
        $this->form_validation->set_rules('idioma2_req', 'Idiomas que habla  dos ', 'trim');
        $this->form_validation->set_rules('por_idioma2_req', 'Porcentaje idioma dos', 'trim');
        $this->form_validation->set_rules('idioma3_req', 'Idiomas que habla  tres ', 'trim');
        $this->form_validation->set_rules('por_idioma3_req', 'Porcentaje idioma tres', 'trim');
        $this->form_validation->set_rules('habilidad1_req', 'Habilidades informáticas requeridas', 'trim');
        $this->form_validation->set_rules('por_habilidad1_req', 'Porcentaje habilidad  requerida uno', 'trim');
        $this->form_validation->set_rules('habilidad2_req', 'Habilidad  requeridas dos', 'trim');
        $this->form_validation->set_rules('por_habilidad2_req', 'Porcentaje habilidad  requeridas dos', 'trim');
        $this->form_validation->set_rules('habilidad3_req', 'Habilidad  requeridas tres', 'trim');
        $this->form_validation->set_rules('por_habilidad3_req', 'Porcentaje habilidad  requeridas tres', 'trim');
        $this->form_validation->set_rules('genero_req', 'Sexo', 'trim');
        $this->form_validation->set_rules('civil_req', 'Estado civil', 'trim');
        $this->form_validation->set_rules('edad_minima_req', 'Edad mínima', 'max_length[2]');
        $this->form_validation->set_rules('edad_maxima_req', 'Edad máxima', 'max_length[2]');
        $this->form_validation->set_rules('licencia_req', 'Licencia de conducir', 'trim');
        $this->form_validation->set_rules('licenctipo_licencia_reqia_req', 'Tipo de licencia', 'trim');
        $this->form_validation->set_rules('discapacidad_req', 'Discapacidad aceptable', 'trim');
        $this->form_validation->set_rules('causa_req', 'Causa que origina la vacante', 'trim');

        $this->form_validation->set_rules('zona_req', 'Zona de trabajo', 'required|trim');
        $this->form_validation->set_rules('tipo_sueldo_req', 'Sueldo', 'required|trim');
        $this->form_validation->set_rules('sueldo_minimo_req', 'Sueldo mínimo', 'numeric|max_length[8]');
        $this->form_validation->set_rules('sueldo_maximo_req', 'Sueldo máximo', 'required|numeric|max_length[8]');
        $this->form_validation->set_rules('tipo_pago_req', 'Tipo de pago ', 'required');
        $this->form_validation->set_rules('tipo_prestaciones_req', '¿Tendrá prestaciones de ley?', 'required');
        $this->form_validation->set_rules('experiencia_req', 'Se requiere experiencia en', 'required|trim');
        $this->form_validation->set_rules('observaciones_req', 'Observaciones adicionales', 'trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        
        $msj = array();

        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {

            $cadena_competencias = $this->input->post('competencias');
            $competencias = '';

            if (!empty($cadena_competencias)) {
                $competencias = implode('_', $cadena_competencias);
            }

            $date = date('Y-m-d H:i:s');
            $id_usuario = $this->session->userdata('id');
            $id_cliente = $this->input->post('id_cliente');
            $contacto = $this->input->post('contacto_req');
            $palabras = explode(' ', $contacto);

            // Asignar las palabras a variables individuales
            $nombre = isset($palabras[0]) ? $palabras[0] : ''; // Primer palabra
            $paterno = isset($palabras[1]) ? $palabras[1] : '';

            $cliente = array(
                'edicion' => $date,
                'nombre' => $this->input->post('nombre_comercial_req'),
            );
            $domicilios = array(
                'pais' => $this->input->post('pais_req'),
                'estado' => $this->input->post('estado_req'),
                'ciudad' => $this->input->post('ciudad_req'),
                'colonia' => $this->input->post('colonia_req'),
                'calle' => $this->input->post('calle_req'),
                'interior' => $this->input->post('interior_req'),
                'exterior' => $this->input->post('exterior_req'),
                'cp' => $this->input->post('cp_req'),
            );

            $generales = array(
                'telefono_req' => $this->input->post('telefono_req'),
                'correo_req' => $this->input->post('correo_req'),
                'nombre' => $nombre,
                'paterno' => $paterno,
            );

            $facturacion = array(
                'razon_social' => $this->input->post('nombre_req'),
                'regimen' => $this->input->post('regimen_req'),
                'rfc' => $this->input->post('rfc_req'),
                'forma_pago' => $this->input->post('forma_pago_req'),
                'metodo_pago' => $this->input->post('metodo_pago_req'),
                'uso_cfdi' => $this->input->post('uso_cfdi_req'),

            );
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

            $req = array(
                'creacion' => $date,
                'edicion' => $date,
                'tipo' => 'EXPRESS',
                'id_usuario' => $id_usuario,
                'id_cliente' => $id_cliente,
                'puesto' => $this->input->post('puesto_req') ?? null,
                'numero_vacantes' => $this->input->post('numero_vacantes_req') ?? null,
                'escolaridad' => !empty($this->input->post('escolaridad_req')) ? $this->input->post('escolaridad_req') : null,
                'estatus_escolar' => !empty($this->input->post('estatus_escolaridad_req')) ? $this->input->post('estatus_escolaridad_req') : null,
                'otro_estatus_escolar' => !empty($this->input->post('otro_estatus_req')) ? $this->input->post('otro_estatus_req') : null,
                'carrera_requerida' => !empty($this->input->post('carrera_req')) ? $this->input->post('carrera_req') : null,
                'otros_estudios' => $this->input->post('otros_estudios_req') ?? null,
                'idiomas' => $idiomas ?? null,
                'habilidad_informatica' => $habilidades ?? null,
                'genero' => $this->input->post('genero_req') ?? null,
                'estado_civil' => $this->input->post('civil_req') ?? null,
                'edad_minima' => $this->input->post('edad_minima_req') ?? null,
                'edad_maxima' => $this->input->post('edad_maxima_req') ?? null,
                'licencia' => $licencia ?? null,
                'discapacidad_aceptable' => $this->input->post('discapacidad_req') ?? null,
                'causa_vacante' => $this->input->post('causa_req') ?? null,
                'lugar_residencia' => $this->input->post('residencia_req') ?? null,
                'zona_trabajo' => $this->input->post('zona_req') ?? null,
                'tipo_pago_sueldo' => $this->input->post('tipo_sueldo_req') ?? null,
                'sueldo_minimo' => $this->input->post('sueldo_minimo_req') ?? null,
                'sueldo_maximo' => $this->input->post('sueldo_maximo_req') ?? null,
                'tipo_prestaciones' => $this->input->post('tipo_prestaciones_req') ?? null,
                'experiencia' => $this->input->post('experiencia_req') ?? null,
                'competencias' => $competencias ?? null,
                'observaciones' => $this->input->post('observaciones_req') ?? null,
            );

            /* var_dump($cliente);
            var_dump($generales);
            var_dump($facturacion);
            var_dump($domicilios);
            var_dump($req);
            die('pausa');
             */
            $result =  $this->reclutamiento_model->addRequisicion($id_cliente, $cliente, $domicilios, $generales, $facturacion, $req);

            if (!empty($result)) {

             

                if ($notificacion > 0) {
                    // Obtener datos para notificación
                    if ($tipo == 1) {
                        $result2 = $this->notificaciones_whatsapp_model->obtenerDatosRegistroRequicisionCliente($result);
                        echo '<pre>'; 
                        print_r($result2);
                        echo'</pre>';
                        die();
                        if ($result2 && !empty($result2->phone)) {
                            $datos_plantilla = array(
                                'nombre_cliente' => $result2->nombre_cliente,
                                'nombre_aspirante' => $result2->nombre_completo,
                                'vacante' => $result2->vacante,
                                'telefono' => $result2->phone,
                                'ruta' => 'send-message-comentario-reclu', // Ajusta según sea necesario
                            );

                            $api_response = $this->notificaciones_whatsapp_model->alertaMovimientoApirante('52' . $result2->phone, 'nueva_requisicion', $datos_plantilla);

                            if ($api_response['codigo'] == 1) {
                                $msj = array(
                                    'codigo' => 1,
                                    'msg' => 'El registro se realizó correctamente. ' . $api_response['msg'],
                                );
                            } else {
                                $msj = array(
                                    'codigo' => 0,
                                    'msg' => $api_response['msg'],
                                );
                            }
                        } else {
                            // Datos para notificación no válidos
                            $msj = array(
                                'codigo' => 1,
                                'msg' => 'El registro se realizó correctamente. La notificación no fue enviada porque no se encontraron datos válidos para notificar.',
                            );
                        }

                    } else {
                        $result2 = $this->notificaciones_whatsapp_model->obtenerDatosPorRequisicionAspiranteCliente($id_bolsa);
                        if ($result2 && !empty($result2->phone)) {
                            $datos_plantilla = array(
                                'nombre_reclu' => $result2->nombre_reclutador,
                                'nombre_cliente' => $result2->nombre_cliente,
                                'nombre_aspirante' => $result2->nombre_completo,
                                'vacante' => $result2->vacante,
                                'telefono' => $result2->phone,
                                'ruta' => 'send-message-comentario-cliente', // Ajusta según sea necesario
                            );
                            /* echo '<pre>';

                            print_r($datos_plantilla);
                            echo '</pre>';
                            die();*/
                            $api_response = $this->notificaciones_whatsapp_model->alertaMovimientoApirante('52' . $result2->phone, 'mensaje_cliente', $datos_plantilla);

                            if ($api_response['codigo'] == 1) {
                                $msj = array(
                                    'codigo' => 1,
                                    'msg' => 'El registro se realizó correctamente. ' . $api_response['msg'],
                                );
                            } else {
                                $msj = array(
                                    'codigo' => 0,
                                    'msg' => $api_response['msg'],
                                );
                            }
                        } else {
                            // Datos para notificación no válidos
                            $msj = array(
                                'codigo' => 1,
                                'msg' => 'El registro se realizó correctamente. La notificación no fue enviada porque no se encontraron datos válidos para notificar.',
                            );
                        }
                    }

                } else {
                    // Notificación desactivada
                    $msj = array(
                        'codigo' => 1,
                        'msg' => 'El registro se realizó correctamente. La notificación no fué enviada.',
                    );
                }

                $msj = array(
                    'codigo' => 1,
                    'msg' => 'Requisición express registrada correctamente',
                );
            } else {
                $msj = array(
                    'codigo' => 0,
                    'msg' => 'Error al registrar la requisición',
                );
            }
        }
        echo json_encode($msj);
    }

    //* Funcion base
    public function assignToUser()
    {
        $this->form_validation->set_rules('asignar_usuario[]', $this->input->post('label_usuario'), 'required|numeric|trim');
        $this->form_validation->set_rules('asignar_registro', $this->input->post('label_registro'), 'required|numeric|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = array();
        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            if ($this->input->post('view') == 'bolsa_trabajo') {
                $data = array(
                    'edicion' => date('Y-m-d H:i:s'),
                    'id_usuario' => $this->input->post('asignar_usuario'),
                );
                $this->reclutamiento_model->editBolsaTrabajo($data, $this->input->post('asignar_registro'));
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'La asignación se realizó correctamente',
                );
            }
            if ($this->input->post('view') == 'requisicion') {
                $totalUsers = count($this->input->post('asignar_usuario'));
                for ($i = 0; $i < $totalUsers; $i++) {
                    $data = array(
                        'creacion' => date('Y-m-d H:i:s'),
                        'id_requisicion' => $this->input->post('asignar_registro'),
                        'id_usuario' => $this->input->post('asignar_usuario')[$i],
                    );
                    $this->reclutamiento_model->addUsersToOrder($data);
                }
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'La asignación se realizó correctamente',
                );
            }
        }
        echo json_encode($msj);
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
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            $generales = array();

            if ($section == 'data_facturacion') {

                $contacto = $this->input->post('contacto_update');
                $palabras = explode(' ', $contacto);

                // Asignar las palabras a variables individuales
                $nombre = isset($palabras[0]) ? $palabras[0] : ''; // Primer palabra
                $paterno = isset($palabras[1]) ? $palabras[1] : '';

                // Agregar los valores al arreglo $generales
                $generales['telefono'] = $this->input->post('telefono_update');
                $generales['correo'] = $this->input->post('correo_update');
                $generales['nombre'] = $nombre;
                $generales['paterno'] = $paterno;

                $req = array(
                    'edicion' => date('Y-m-d H:i:s'),
                    'id_usuario' => $this->session->userdata('id'),
                );

                $facturacion = array(

                    'razon_social' => $this->input->post('nombre_update'),
                    'rfc' => $this->input->post('rfc_update'),
                    'regimen' => $this->input->post('regimen_update'),
                    'forma_pago' => $this->input->post('forma_pago_update'),
                    'metodo_pago' => $this->input->post('metodo_pago_update'),
                    'uso_cfdi' => $this->input->post('uso_cfdi_update'),
                );

                $domicilios = array(
                    'pais' => $this->input->post('pais_update'),
                    'estado' => $this->input->post('estado_update'),
                    'ciudad' => $this->input->post('ciudad_update'),
                    'colonia' => $this->input->post('colonia_update'),
                    'calle' => $this->input->post('calle_update'),
                    'interior' => $this->input->post('interior_update'),
                    'exterior' => $this->input->post('exterior_update'),
                    'cp' => $this->input->post('cp_update'),
                );

                $sectionSuccessMessage = 'Datos de facturación, domicilios, generales del cliente actualizados correctamente';
            }
            if ($section == 'vacante') {
                $req = array(
                    'puesto' => $this->input->post('puesto_update'),
                    'numero_vacantes' => $this->input->post('num_vacantes_update'),
                    'escolaridad' => $this->input->post('escolaridad_update'),
                    'estatus_escolar' => $this->input->post('estatus_escolaridad_update'),
                    'otro_estatus_escolar' => $this->input->post('otro_estatus_update'),
                    'carrera_requerida' => $this->input->post('carrera_update'),
                    'idiomas' => $this->input->post('idiomas_update'),
                    'otros_estudios' => $this->input->post('otros_estudios_update'),
                    'habilidad_informatica' => $this->input->post('hab_informatica_update'),
                    'genero' => $this->input->post('genero_update'),
                    'estado_civil' => $this->input->post('civil_update'),
                    'edad_minima' => $this->input->post('edad_minima_update'),
                    'edad_maxima' => $this->input->post('edad_maxima_update'),
                    'licencia' => $this->input->post('licencia_completa'),
                    'discapacidad_aceptable' => $this->input->post('discapacidad_update'),
                    'causa_vacante' => $this->input->post('causa_update'),
                    'lugar_residencia' => $this->input->post('residencia_update'),
                );
                $sectionSuccessMessage = 'Información de la vacante actualizada correctamente';
            }
            if ($section == 'cargo') {
                $req = array(
                    'jornada_laboral' => $this->input->post('jornada_update'),
                    'tiempo_inicio' => $this->input->post('tiempo_inicio_update'),
                    'tiempo_final' => $this->input->post('tiempo_final_update'),
                    'dias_descanso' => $this->input->post('descanso_update'),
                    'disponibilidad_viajar' => $this->input->post('viajar_update'),
                    'disponibilidad_horario' => $this->input->post('horario_update'),
                    'lugar_entrevista' => $this->input->post('lugar_entrevista_update'),
                    'zona_trabajo' => $this->input->post('zona_update'),
                    'sueldo' => $this->input->post('tipo_sueldo_update'),
                    'sueldo_adicional' => $this->input->post('sueldo_adicional_completo'),
                    'sueldo_minimo' => $this->input->post('sueldo_minimo_update'),
                    'sueldo_maximo' => $this->input->post('sueldo_maximo_update'),
                    'tipo_pago_sueldo' => $this->input->post('tipo_pago_update'),
                    'tipo_prestaciones' => $this->input->post('tipo_prestaciones_update'),
                    'tipo_prestaciones_superiores' => $this->input->post('superiores_update'),
                    'otras_prestaciones' => $this->input->post('otras_prestaciones_update'),
                    'experiencia' => $this->input->post('experiencia_update'),
                    'actividades' => $this->input->post('actividades_update'),
                );
                $sectionSuccessMessage = 'Información del cargo actualizada correctamente';
            }
            if ($section == 'perfil') {
                $req = array(
                    'competencias' => $this->input->post('competencias'),
                    'observaciones' => $this->input->post('observaciones_update'),
                );
                $sectionSuccessMessage = 'Información del perfil actualizada correctamente';
            }
            // Comprobar si $generales no está vacío
            if (!empty($generales)) {
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

                    $msj = array(
                        'codigo' => 0,
                        'msg' => 'Error al procesar la transacción',
                    );
                } else {
                    // Si la transacción se completó correctamente, mostrar un mensaje de éxito
                    $msj = array(
                        'codigo' => 1,
                        'msg' => $sectionSuccessMessage,
                    );
                }
            } else {
                // Si $generales está vacío, solo se ha editado la orden
                //  var_dump($req);
                // Actualizar la orden
                $this->reclutamiento_model->updateOrder($req, $this->input->post('id_requisicion'));

                // Mostrar un mensaje de éxito
                $msj = array(
                    'codigo' => 1,
                    'msg' => $sectionSuccessMessage,
                );
            }

        }
        echo json_encode($msj);
    }
    public function uploadCSV()
    {
        $id_portal = $this->session->userdata('idPortal');
        $idUsuario = $this->session->userdata('id');

        if (isset($_FILES["archivo"]["name"])) {
            $extensionArchivo = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
            if ($extensionArchivo == 'csv') {
                $date = date('Y-m-d H:i:s');
                $id_usuario = $this->session->userdata('id');

                $rows = [];
                $file = $_FILES["archivo"];
                $tmp = $file["tmp_name"];
                $filename = $file["name"];
                $size = $file["size"];

                if ($size < 0) {
                    $msj = array(
                        'codigo' => 0,
                        'msg' => 'Seleccione un archivo .csv válido',
                    );
                } else {
                    $handle = fopen($tmp, "r");
                    while (($data = fgetcsv($handle)) !== false) {
                        $rows[] = $data;
                    }
                    // se eliminan las cabeceras
                    for ($i = 0; $i <= 0; $i++) {
                        unset($rows[$i]);
                    }
                    $total = count($rows);

                    if ($total <= 0) {
                        $msj = array(
                            'codigo' => 0,
                            'msg' => 'El archivo esta vacío',
                        );
                    } else {
                        $errorMessages = '';
                        $successMessages = 'Registros agregados de la(s) fila(s):<br> ';
                        $i = 0;
                        $rowsAdded = 0;
                        foreach ($rows as $r) {
                            // Las columnas abarcan los indices del 1-9

                            $userCorrect = $this->session->userdata('id');
                            if ($userCorrect != null) {
                                if (preg_match("/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/i", $r[1])) { // Evalua fecha con formato dd/mm/aaaa
                                    if (preg_match("/^([\wñáéíóúÁÉÍÓÚ]{1}[\wñáéíóúÁÉÍÓÚ\s]+)$/", $r[2]) &&
                                        preg_match("/^([\wñáéíóúÁÉÍÓÚ]{1}[\wñáéíóúÁÉÍÓÚ\s]+)$/", $r[3]) &&
                                        preg_match("/^([\wñáéíóúÁÉÍÓÚ]{1}[\wñáéíóúÁÉÍÓÚ\s]+)$/", $r[4])) { // Evalua nombres propios aceptando minusculas al principio
                                        $nombre = strtoupper($r[2]);
                                        $paterno = strtoupper($r[3]);
                                        $materno = strtoupper($r[4]);
                                        $existName = $this->reclutamiento_model->getBolsaTrabajoByName($nombre, $paterno, $materno, $id_portal);
                                        if ($existName == null) {
                                            $existPhone = $this->reclutamiento_model->getBolsaTrabajoByPhone($r[5], $id_portal);
                                            if (preg_match("/^[\d]{2}[-]?[\d]{4}[-]?[\d]{4}$/", trim($r[5])) && $existPhone == null) { //Numero de telefono con formato 00-0000-0000 o 0000000000
                                                if (strlen($r[6]) > 0 && strlen($r[6]) <= 128) { //Area de interes con limite
                                                    if (strlen($r[7]) > 0 && strlen($r[7]) <= 30) { //Localizacion del aspirante
                                                        $existContact = $this->funciones_model->getMediosContactoByName($r[8]);

                                                        if (isset($existContact)) {
                                                            $this->funciones_model->insertarMedioContacto($r[8]);
                                                            $existContact = $this->funciones_model->getMediosContactoByName($r[8]);
                                                        }
                                                        if ($r[8] != '' && $existContact !== null) { //Medio por el cual se contacto el aspirante
                                                            $fecha = validar_fecha_espanol($r[1]);
                                                            if ($fecha) {
                                                                $fecha = fecha_espanol_bd($r[1]);
                                                            } else {
                                                                $fecha = date('Y-m-d H:i:s');
                                                            }

                                                            $data = array(
                                                                'creacion' => $fecha,
                                                                'edicion' => $fecha,
                                                                'id_portal' => $id_portal,
                                                                'id_usuario' => $idUsuario,
                                                                'nombre' => strtoupper($r[2]),
                                                                'paterno' => strtoupper($r[3]),
                                                                'materno' => strtoupper($r[4]),
                                                                'domicilio' => strtoupper($r[7]),
                                                                'telefono' => trim($r[5]),
                                                                'medio_contacto' => $existContact->nombre,
                                                                'area_interes' => $r[6],
                                                            );
                                                            $this->reclutamiento_model->addBolsaTrabajo($data);
                                                            $successMessages .= ($i + 2) . ',';
                                                            $i++;
                                                            $rowsAdded++;
                                                        } else {
                                                            $errorMessages .= 'Medio de contacto vacío o no existe en el catalogo en la fila ' . ($i + 2) . '<br>' . $$r[8] . "aqui el medio ";
                                                            $i++;
                                                            continue;
                                                        }
                                                    } else {
                                                        $errorMessages .= 'Localización vacía o demasiado extensa (limitado a 30 caracteres) en la fila ' . ($i + 2) . '<br>';
                                                        $i++;
                                                        continue;
                                                    }
                                                } else {
                                                    $errorMessages .= 'Área de interes vacía o demasiado extensa (limitado a 30 caracteres) en la fila ' . ($i + 2) . '<br>';
                                                    $i++;
                                                    continue;
                                                }
                                            } else {
                                                $errorMessages .= 'Número de teléfono ya existe o no es válido en la fila ' . ($i + 2) . '<br>';
                                                $i++;
                                                continue;
                                            }
                                        } else {
                                            $errorMessages .= 'El nombre ya existe en la fila ' . ($i + 2) . '<br>';
                                            $i++;
                                            continue;
                                        }
                                    } else {
                                        $errorMessages .= 'Nombre y/o apellidos no válidos en la fila ' . ($i + 2) . '<br>';
                                        $i++;
                                        continue;
                                    }
                                } else {
                                    $errorMessages .= 'Formato de fecha no válido en la fila ' . ($i + 2) . '<br>';
                                    $i++;
                                    continue;
                                }
                            } else {
                                $errorMessages .= 'El ID de usuario no es válido en la fila ' . ($i + 2) . '<br>';
                                $i++;
                                continue;
                            }

                        }
                        if ($errorMessages == '') {
                            $msj = array(
                                'codigo' => 1,
                                'msg' => 'Los registros del archivo fueron cargados al sistema correctamente<br>' . substr($successMessages, 0, -1),
                            );
                        }
                        if ($errorMessages != '' && $rowsAdded == 0) {
                            $response = 'No se agregaron registros del archivo ';
                            $msj = array(
                                'codigo' => 0,
                                'msg' => 'Finalizó la carga pero se encontraron algunos errores en los siguientes registros:<br>' . $errorMessages . '<br>' . $response,
                            );
                        }
                        if ($errorMessages != '' && $rowsAdded > 0) {
                            $response = substr($successMessages, 0, -1);
                            $msj = array(
                                'codigo' => 2,
                                'msg' => 'Finalizó la carga pero se encontraron algunos errores en los siguientes registros:<br>' . $errorMessages . '<br>' . $response,
                            );
                        }
                    }
                }
            } else {
                $msj = array(
                    'codigo' => 0,
                    'msg' => 'Seleccione un archivo .csv válido',
                );
            }
        } else {
            $msj = array(
                'codigo' => 0,
                'msg' => 'Seleccione un archivo .csv válido',
            );
        }
        echo json_encode($msj);
    }
    public function deleteUserOrder()
    {
        $this->reclutamiento_model->deleteUserOrder($this->input->post('id'));
        $msj = array(
            'codigo' => 1,
            'msg' => 'Se ha eliminado el usuario de la requsición correctamente',
        );
        echo json_encode($msj);
    }
    public function deleteOrder()
    {
        $id_usuario = $this->session->userdata('id');
        $datos = array(
            'edicion' => date('Y-m-d H:i:s'),
            'id_usuario' => $id_usuario,
            'eliminado' => 1,
            'comentario_final' => $this->input->post('comentario'),
        );
        $this->reclutamiento_model->editarRequisicion($datos, $this->input->post('id'));
        $msj = array(
            'codigo' => 1,
            'msg' => 'Requisicion eliminada correctamente',
        );
        echo json_encode($msj);
    }
    public function updateApplicant()
    {
        $section = $this->input->post('section');
        if ($section == 'personal') {
            $this->form_validation->set_rules('nombre_update', 'Nombre(s)', 'required|trim');
            $this->form_validation->set_rules('paterno_update', 'Primer apellido', 'required|trim');
            $this->form_validation->set_rules('materno_update', 'Segundo apellido', 'trim');
            $this->form_validation->set_rules('domicilio_update', 'Domicilio', 'required|trim');
            $this->form_validation->set_rules('fecha_nacimiento_update', 'Fecha de nacimiento', 'required|trim');
            $this->form_validation->set_rules('telefono_update', 'Teléfono', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('nacionalidad_update', 'Nacionalidad', 'required|trim');
            $this->form_validation->set_rules('civil_update', 'Estado civil', 'required|trim');
            $this->form_validation->set_rules('dependientes_update', 'Personas que dependan del aspirante', 'required|trim');
            $this->form_validation->set_rules('escolaridad_update', 'Grado máximo de estudios', 'required|trim');

        }
        if ($section == 'salud') {
            $this->form_validation->set_rules('salud_update', '¿Cómo es su estado de salud actual?', 'required|trim');
            $this->form_validation->set_rules('enfermedad_update', '¿Padece de alguna enfermedad crónica?', 'required|trim');
            $this->form_validation->set_rules('deporte_update', '¿Practica algún deporte?', 'required|trim');
            $this->form_validation->set_rules('metas_update', '¿Cuáles son sus metas en la vida?', 'required|trim');
        }
        if ($section == 'conocimiento') {
            $this->form_validation->set_rules('idiomas_update', 'Idiomas que domina', 'required|trim');
            $this->form_validation->set_rules('maquinas_update', 'Máquinas de oficina o taller que maneje', 'required|trim');
            $this->form_validation->set_rules('software_update', 'Software que conoce', 'required|trim');
        }
        if ($section == 'intereses') {
            $this->form_validation->set_rules('medio_contacto_update', '¿Cómo se enteró de RODI?', 'required|trim');
            $this->form_validation->set_rules('area_interes_update', '¿Qué área es de su interés?', 'required|trim');
            $this->form_validation->set_rules('sueldo_update', '¿Qué sueldo desea percibir?', 'required|trim');
            $this->form_validation->set_rules('otros_ingresos_update', '¿Tiene otros ingresos?', 'required|trim');
            $this->form_validation->set_rules('viajar_update', '¿Tiene disponibilidad para viajar?', 'required|trim');
            $this->form_validation->set_rules('trabajar_update', '¿Qué fecha o en qué momento podría presentarse a trabajar?', 'required|trim');
        }
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            $idRol = $this->session->userdata('idrol');

            if ($section == 'personal') {

                $edad = calculaEdad($this->input->post('fecha_nacimiento_update'));
                $bolsa = array(
                    'edicion' => date('Y-m-d H:i:s'),
                    'nombre' => $this->input->post('nombre_update'),
                    'paterno' => $this->input->post('paterno_update'),
                    'materno' => $this->input->post('materno_update'),
                    'domicilio' => $this->input->post('domicilio_update'),
                    'edad' => $edad,
                    'fecha_nacimiento' => $this->input->post('fecha_nacimiento_update'),
                    'telefono' => $this->input->post('telefono_update'),
                    'nacionalidad' => $this->input->post('nacionalidad_update'),
                    'civil' => $this->input->post('civil_update'),
                    'dependientes' => $this->input->post('dependientes_update'),
                    'grado_estudios' => $this->input->post('escolaridad_update'),
                );

                if ($idRol != 6) {
                    $bolsa['id_usuario'] = $this->session->userdata('id');
                }
                $sectionSuccessMessage = 'Datos personales actualizados correctamente';
                $aspirante = array(
                    'edicion' => date('Y-m-d H:i:s'),

                );
                if ($idRol != 6) {
                    $aspirante['id_usuario'] = $this->session->userdata('id');
                }
                $this->reclutamiento_model->updateApplicantByIdBolsaTrabajo($bolsa, $this->input->post('id_bolsa'));
            }
            if ($section == 'salud') {
                $bolsa = array(
                    'salud' => $this->input->post('salud_update'),
                    'enfermedad' => $this->input->post('enfermedad_update'),
                    'deporte' => $this->input->post('deporte_update'),
                    'metas' => $this->input->post('metas_update'),
                );
                $sectionSuccessMessage = 'Información de la salud y vida social actualizadas correctamente';
            }
            if ($section == 'conocimiento') {
                $bolsa = array(
                    'idiomas' => $this->input->post('idiomas_update'),
                    'maquinas' => $this->input->post('maquinas_update'),
                    'software' => $this->input->post('software_update'),
                );
                $sectionSuccessMessage = 'Información de conocimiento y habilidades actualizada correctamente';
            }
            if ($section == 'intereses') {
                $bolsa = array(
                    'medio_contacto' => $this->input->post('medio_contacto_update'),
                    'area_interes' => $this->input->post('area_interes_update'),
                    'sueldo_deseado' => $this->input->post('sueldo_update'),
                    'otros_ingresos' => $this->input->post('otros_ingresos_update'),
                    'viajar' => $this->input->post('viajar_update'),
                    'trabajar' => $this->input->post('trabajar_update'),
                );
                $sectionSuccessMessage = 'Información de los intereses actualizada correctamente';
                $aspirante = array(
                    'edicion' => date('Y-m-d H:i:s'),
                    'medio_contacto' => $this->input->post('medio_contacto_update'),
                );

                if ($idRol != 6) {
                    $aspirante['id_usuario'] = $this->session->userdata('id');
                }
                $this->reclutamiento_model->updateApplicantByIdBolsaTrabajo($aspirante, $this->input->post('id_bolsa'));
            }
            $this->reclutamiento_model->editBolsaTrabajo($bolsa, $this->input->post('id_bolsa'));
            $msj = array(
                'codigo' => 1,
                'msg' => $sectionSuccessMessage,
            );
        }
        echo json_encode($msj);
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

        $msj = array();
        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            $aspirante = array(
                'edicion' => date('Y-m-d H:i:s'),
                'sueldo_acordado' => $this->input->post('sueldo_acordado'),
                'fecha_ingreso' => $this->input->post('fecha_ingreso'),
                'pago' => $this->input->post('pago'),
            );
            if ($this->session->userdata('id_rol') != 6) {
                $aspirante['id_usuario'] = $this->session->userdata('id');
            }
            $this->reclutamiento_model->editarAspirante($aspirante, $this->input->post('id_aspirante'));
            if ($this->input->post('garantia') != '') {
                $garantia = array(
                    'creacion' => date('Y-m-d H:i:s'),
                    'id_aspirante' => $this->input->post('id_aspirante'),
                    'descripcion' => $this->input->post('garantia'),
                );
                if ($this->session->userdata('id_rol') != 6) {
                    $garantia['id_usuario'] = $this->session->userdata('id');
                }

                $this->reclutamiento_model->addWarrantyApplicant($garantia);
            }
            $msj = array(
                'codigo' => 1,
                'msg' => 'Información de ingreso actualizada correctamente',
            );
        }
        echo json_encode($msj);
    }
    /*----------------------------------------*/
    /*    Consultas
    /*----------------------------------------*/
    public function getDetailsOrderById()
    {
        $id = $this->input->post('id');
        $res = $this->reclutamiento_model->getDetailsOrderById($id);
        echo json_encode($res);
    }

    public function getAspirantesRequisiciones()
    {
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $condicion = 'A.id_usuario';
        } else {
            $id_usuario = 0;
            $condicion = 'A.id_usuario >';
        }
        $req['recordsTotal'] = $this->reclutamiento_model->getAspirantesRequisicionesTotal($id_usuario, $condicion);
        $req['recordsFiltered'] = $this->reclutamiento_model->getAspirantesRequisicionesTotal($id_usuario, $condicion);
        $req['data'] = $this->reclutamiento_model->getAspirantesRequisiciones($id_usuario, $condicion);
        $this->output->set_output(json_encode($req));
    }
    public function subirCVReqAspirante()
    {
        $this->form_validation->set_rules('id_cv', 'Archivos CV', 'required');
        $this->form_validation->set_rules('id_aspirante', 'Aspirante', 'required');
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

        $id_req_aspirante = $this->input->post('id_aspirante');
        $msj = array();

        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            if (!empty($_FILES['id_cv']['name'])) {
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
                $config['upload_path'] = './_docs/';
                $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                $config['file_name'] = $id_req_aspirante . "_CV." . pathinfo($_FILES['id_cv']['name'], PATHINFO_EXTENSION);

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $data = $this->upload->data();
                    $documento = array(
                        'creacion' => date('Y-m-d H:i:s'),
                        'edicion' => date('Y-m-d H:i:s'),
                        'id_requisicion_aspirante' => $id_req_aspirante,
                        'id_tipo_documento' => 16,
                        'archivo' => $data['file_name'], // Nombre del archivo
                    );

                    $registroExitoso = $this->candidato_model->registrarDocumento($documento);

                    if ($registroExitoso) {
                        $msj = array(
                            'codigo' => 1,
                            'msg' => 'El archivo se subió correctamente',
                        );
                    } else {
                        $msj = array(
                            'codigo' => 0,
                            'msg' => 'Ocurrio un problema  intentelo  mas  tarde ',
                        );
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $msj = array(
                        'codigo' => 0,
                        'msg' => 'Error al cargar el archivo: ' . $error,
                    );
                }
            } else {
                $msj = array(
                    'codigo' => 0,
                    'msg' => 'No se seleccionó ningún archivo para cargar',
                );
            }
        }

        echo json_encode($msj);
    }

    public function getAspirantesPorRequisicion()
    {

        $id_requisicion = $_GET['id'];

        // echo " aqui  el id  de la requisicion ".$id_requisicion ;
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $condicion = 'A.id_usuario';
        } else {
            $id_usuario = 0;
            $condicion = 'A.id_usuario >';
        }
        $req['recordsTotal'] = $this->reclutamiento_model->getAspirantesPorRequisicionTotal($id_usuario, $condicion, $id_requisicion);
        $req['recordsFiltered'] = $this->reclutamiento_model->getAspirantesPorRequisicionTotal($id_usuario, $condicion, $id_requisicion);
        $req['data'] = $this->reclutamiento_model->getAspirantesPorRequisicion($id_usuario, $condicion, $id_requisicion);
        $this->output->set_output(json_encode($req));

    }

    public function getHistorialAspirante()
    {
        $id = $this->input->post('id');
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
            $condicion = 'A.id_usuario';
        } else {
            $id_usuario = 0;
            $condicion = 'A.id_usuario >';
        }
        $req['recordsTotal'] = $this->reclutamiento_model->getAspirantesRequisicionesFinalizadasTotal($id_usuario, $condicion);
        $req['recordsFiltered'] = $this->reclutamiento_model->getAspirantesRequisicionesFinalizadasTotal($id_usuario, $condicion);
        $req['data'] = $this->reclutamiento_model->getAspirantesRequisicionesFinalizadas($id_usuario, $condicion);
        $this->output->set_output(json_encode($req));
    }

    public function getAspirantesPorRequisicionesFinalizadas()
    {
        $id_requisicion = $_GET['id'];
        if ($this->session->userdata('idrol') == 4) {
            $id_usuario = $this->session->userdata('id');
            $condicion = 'A.id_usuario';
        } else {
            $id_usuario = 0;
            $condicion = 'A.id_usuario >';
        }
        $req['recordsTotal'] = $this->reclutamiento_model->getAspirantesPorRequisicionesFinalizadasTotal($id_usuario, $condicion, $id_requisicion);
        $req['recordsFiltered'] = $this->reclutamiento_model->getAspirantesPorRequisicionesFinalizadasTotal($id_usuario, $condicion, $id_requisicion);
        $req['data'] = $this->reclutamiento_model->getAspirantesPorRequisicionesFinalizadas($id_usuario, $condicion, $id_requisicion);
        $this->output->set_output(json_encode($req));
    }
    public function getBolsaTrabajoById()
    {
        $id = $this->input->post('id');
        $res = $this->reclutamiento_model->getBolsaTrabajoById($id);
        echo json_encode($res);
    }

    public function getEmpleosByIdBolsaTrabajo()
    {
        $id = $this->input->post('id');
        $data['empleos'] = $this->reclutamiento_model->getEmpleosByIdBolsaTrabajo($id);
        if ($data['empleos']) {
            echo json_encode($data['empleos']);
        } else {
            echo $resp = 0;
        }
    }

    public function getHistorialBolsaTrabajo()
    {
        $id = $this->input->post('id');
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
        $id = $this->input->post('id');
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
            $res = $this->reclutamiento_model->getOrdersInProcessByUser($id_usuario);
        } else {
            $res = $this->reclutamiento_model->getAllOrdersInProcess();
        }
        echo json_encode($res);
    }

    public function getDetailsApplicantById()
    {
        $id = $this->input->post('id');
        $res = $this->reclutamiento_model->getBolsaTrabajoById($id);
        echo json_encode($res);
    }

    public function getWarrantyApplicant()
    {
        $id = $this->input->post('id');
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
}
