<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Doping extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('Login/index');
        }
        $this->load->library('usuario_sesion');
        $this->usuario_sesion->checkStatusBD();
    }
    /*----------------------------------------*/
    /*  Procedimiento normal (registros generales)
    /*----------------------------------------*/
    public function indexGenerales()
    {
        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        //$info['candidatos'] = $this->doping_model->getCandidatosSinDoping();
        $info['paquetes'] = $this->doping_model->getPaquetesAntidoping();
        $info['clientes'] = $this->funciones_model->getClientesActivos();
        $info['identificaciones'] = $this->funciones_model->getTiposIdentificaciones();
        //$info['finalizados'] = $this->doping_model->getDopingsFinalizados();
        $datos['modals'] = $this->load->view('modals/mdl_doping', $info, true);
        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
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
            ->view('doping/general', $datos)
            ->view('adminpanel/footer');
    }
    public function getDopingsGenerales()
    {
        $dop['recordsTotal'] = $this->doping_model->getDopingsGeneralesTotal();
        $dop['recordsFiltered'] = $this->doping_model->getDopingsGeneralesTotal();
        $dop['data'] = $this->doping_model->getDopingsGenerales();
        $this->output->set_output(json_encode($dop));
    }
    /*----------------------------------------*/
    /*  Pendientes
    /*----------------------------------------*/
    public function indexPendientes()
    {
        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $info['paquetes'] = $this->doping_model->getPaquetesAntidoping();
        $info['clientes'] = $this->funciones_model->getClientesActivos();
        $info['identificaciones'] = $this->funciones_model->getTiposIdentificaciones();
        $datos['modals'] = $this->load->view('modals/mdl_doping', $info, true);
        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
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
            ->view('doping/pendientes', $datos)
            ->view('adminpanel/footer');
    }
    public function getDopingsPendientes()
    {
        $dop['recordsTotal'] = $this->doping_model->getDopingsPendientesTotal();
        $dop['recordsFiltered'] = $this->doping_model->getDopingsPendientesTotal();
        $dop['data'] = $this->doping_model->getDopingsPendientes();
        $this->output->set_output(json_encode($dop));
    }
    public function registrarPendiente()
    {
        $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required');
        $this->form_validation->set_rules('ine', 'Numero, licencia o código', 'required');
        $this->form_validation->set_rules('identificacion', 'Tipo de identificacion', 'required');
        $this->form_validation->set_rules('razon', 'Razon', 'required');
        $this->form_validation->set_rules('foraneo', '¿Este examen es foráneo (fuera de GDL)?', 'required');
        $this->form_validation->set_rules('medicamentos', 'Medicamentos', 'required');
        $this->form_validation->set_rules('fecha_doping', 'Fecha de doping', 'required');

        $this->form_validation->set_message('required', 'El campo %s es obligatorio');

        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');
            $id_usuario = $this->session->userdata('id');
            $foto = '';
            if ($this->input->post('fecha_nacimiento') != "" && $this->input->post('fecha_nacimiento') != null) {
                $f_nacimiento = fecha_espanol_bd($this->input->post('fecha_nacimiento'));
                $edad = $this->calculaEdad($f_nacimiento);
                $candidato_fnacimiento = array(
                    'fecha_nacimiento' => $f_nacimiento,
                    'edad' => $edad,
                );
                $this->candidato_model->editarCandidato($candidato_fnacimiento, $this->input->post('id_candidato'));
            } else {
                $f_nacimiento = null;
                $edad = 0;
            }
            $f_doping = fecha_hora_espanol_bd($this->input->post('fecha_doping'));
            if ($this->input->post('foraneo') == 'SI') {
                $area = $this->area_model->getArea('DOPING FORANEO');
            } else {
                $area = $this->area_model->getArea('DOPING LOCAL');
            }

            $data['candidato'] = $this->doping_model->getDatosCandidato($this->input->post('id_candidato'));
            foreach ($data['candidato'] as $row) {
                $nombre = $row->nombre;
                $paterno = $row->paterno;
                $cliente = $row->id_cliente;
                $subcliente = $row->id_subcliente;
                $proyecto = $row->id_proyecto;
                $clave_cliente = $row->claveCliente;
                $clave_subcliente = $row->claveSubcliente;
                $paquete = $row->antidoping;
            }
            if (isset($_FILES["foto"])) {
                $file_ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
                $nombre = str_replace(' ', '', $nombre);
                $paterno = str_replace(' ', '', $paterno);
                $nombre_archivo = $this->input->post('id_candidato') . "_" . $nombre . "" . $paterno . "_Foto." . $file_ext;

                $config['upload_path'] = './_doping/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['overwrite'] = true;
                $config['file_name'] = $nombre_archivo;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                // File upload
                if ($this->upload->do_upload('foto')) {
                    $data = $this->upload->data();
                }
                $foto = $nombre_archivo;
            }
            $doping = array(
                'creacion' => $date,
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_candidato' => $this->input->post('id_candidato'),
                'id_cliente' => $cliente,
                'id_subcliente' => $subcliente,
                'id_proyecto' => $proyecto,
                'id_antidoping_paquete' => $paquete,
                'fecha_doping' => $f_doping,
                'id_tipo_identificacion' => $this->input->post('identificacion'),
                'ine' => $this->input->post('ine'),
                'foto' => $foto,
                'razon' => $this->input->post('razon'),
                'medicamentos' => $this->input->post('medicamentos'),
                'comentarios' => $this->input->post('comentarios'),
                'id_area' => $area->id,
                'foraneo' => $this->input->post('foraneo'),
            );
            $id_doping = $this->doping_model->insertDoping($doping);
            $clave_folio = array(
                'folio' => $id_doping,
                'codigo_prueba' => 'AD-' . $clave_cliente . '-' . $clave_subcliente . '-' . $id_doping . '-' . substr(date('Y'), -2),
            );
            $this->doping_model->editarDoping($clave_folio, $id_doping);
            $prueba = array(
                'status_doping' => 1,
            );
            $this->doping_model->updatePruebaCandidato($this->input->post('id_candidato'), $prueba);

            $data['parametros'] = $this->doping_model->getParametrosCandidato($this->input->post('id_candidato'));
            foreach ($data['parametros'] as $p) {
                $tipo = $p->tipo_antidoping;
                $parametros = $p->antidoping;
            }
            if ($tipo == 1) {
                $paquete = $this->doping_model->getPaqueteCandidato($parametros);
                $aux = explode(',', $paquete->sustancias);
                for ($i = 0; $i < count($aux); $i++) {
                    $sustancia = $this->doping_model->getSustanciaCandidato($aux[$i]);
                    $detalle = array(
                        'creacion' => $date,
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'id_doping' => $id_doping,
                        'id_candidato' => $this->input->post('id_candidato'),
                        'id_sustancia' => $sustancia->id,
                    );
                    $this->doping_model->insertDetalleDoping($detalle);
                }
            }
            $msj = array(
                'codigo' => 1,
                'msg' => 'success',
            );
        }
        echo json_encode($msj);
    }
    /*----------------------------------------*/
    /*  Finalizados
    /*----------------------------------------*/
    public function indexFinalizados()
    {
        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $info['paquetes'] = $this->doping_model->getPaquetesAntidoping();
        $info['clientes'] = $this->funciones_model->getClientesActivos();
        $info['identificaciones'] = $this->funciones_model->getTiposIdentificaciones();
        //$info['filtrados'] = $this->doping_model->getDopingsFinalizadosFiltrados();

        $datos['modals'] = $this->load->view('modals/mdl_doping', $info, true);
        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
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
            ->view('doping/finalizados', $datos)
            ->view('adminpanel/footer');
    }
    public function getDopingsFinalizadosListado()
    {
        $dop['recordsTotal'] = $this->doping_model->getDopingsFinalizadosListadoTotal();
        $dop['recordsFiltered'] = $this->doping_model->getDopingsFinalizadosListadoTotal();
        $dop['data'] = $this->doping_model->getDopingsFinalizadosListado();
        $this->output->set_output(json_encode($dop));
    }
    public function getResultadoFiltrado()
    {
        $nombre = $_GET['nombre'];
        $paterno = $_GET['primero'];
        $materno = $_GET['segundo'];
        $numero = $_GET['numero'];
        $cliente = $_GET['cliente'];
        $inicio = ($_GET['inicio'] != '') ? fecha_espanol_bd($_GET['inicio']) : '';
        $fin = ($_GET['fin'] != '') ? fecha_espanol_bd($_GET['fin']) : '';
        $dop['recordsTotal'] = $this->doping_model->getResultadoFiltradoTotal($nombre, $paterno, $materno, $numero, $cliente, $inicio, $fin);
        $dop['recordsFiltered'] = $this->doping_model->getResultadoFiltradoTotal($nombre, $paterno, $materno, $numero, $cliente, $inicio, $fin);
        $dop['data'] = $this->doping_model->getResultadoFiltrado($nombre, $paterno, $materno, $numero, $cliente, $inicio, $fin);
        $this->output->set_output(json_encode($dop));
    }
    /*----------------------------------------*/
    /*  CRUD
    /*----------------------------------------*/
    public function crearRegistro()
    {
        $this->form_validation->set_rules('nombre', 'Nombre(s)', 'required|trim');
        $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
        $this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
        $this->form_validation->set_rules('paquete', 'Parametros', 'required');
        $this->form_validation->set_rules('cliente', 'Cliente', 'required');
        $this->form_validation->set_rules('subcliente', 'Subcliente', 'required');
        $this->form_validation->set_rules('proyecto', 'Proyecto', 'required');
        $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required');
        $this->form_validation->set_rules('ine', 'Numero, licencia o código', 'required');
        $this->form_validation->set_rules('identificacion', 'Tipo de identificacion', 'required');
        $this->form_validation->set_rules('razon', 'Razon', 'required');
        $this->form_validation->set_rules('foraneo', '¿Este examen es foráneo (fuera de GDL)?', 'required');
        $this->form_validation->set_rules('medicamentos', 'Medicamentos', 'required');
        $this->form_validation->set_rules('fecha_doping', 'Fecha de doping', 'required');

        $this->form_validation->set_message('required', 'El campo %s es obligatorio');

        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');
            $id_usuario = $this->session->userdata('id');
            $foto = '';
            if ($this->input->post('fecha_nacimiento') != "" && $this->input->post('fecha_nacimiento') != null) {
                $f_nacimiento = fecha_espanol_bd($this->input->post('fecha_nacimiento'));
                $edad = $this->calculaEdad($f_nacimiento);
            } else {
                $f_nacimiento = null;
                $edad = 0;
            }
            if ($this->input->post('foraneo') == 'SI') {
                $area = $this->area_model->getArea('DOPING FORANEO');
            } else {
                $area = $this->area_model->getArea('DOPING LOCAL');
            }
            $f_doping = fecha_hora_espanol_bd($this->input->post('fecha_doping'));
            $datos_candidato = array(
                'creacion' => $date,
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_usuario_cliente' => 0,
                'id_cliente' => $this->input->post('cliente'),
                'id_subcliente' => $this->input->post('subcliente'),
                'id_proyecto' => $this->input->post('proyecto'),
                'fecha_alta' => $date,
                'nombre' => $this->input->post('nombre'),
                'paterno' => $this->input->post('paterno'),
                'materno' => $this->input->post('materno'),
                'correo' => 'Sin correo',
                'fecha_nacimiento' => $f_nacimiento,
                'edad' => $edad,
            );
            $id_candidato = $this->doping_model->insertCandidato($datos_candidato);
            $data['candidato'] = $this->doping_model->getDatosCandidato($id_candidato);
            foreach ($data['candidato'] as $row) {
                $clave_cliente = $row->claveCliente;
                $clave_subcliente = $row->claveSubcliente;
            }
            if (isset($_FILES['foto'])) {
                $file_ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
                $nombre = str_replace(' ', '', $this->input->post('nombre'));
                $paterno = str_replace(' ', '', $this->input->post('paterno'));
                $nombre_archivo = $id_candidato . "_" . $nombre . "_" . $paterno . "_Foto." . $file_ext;

                $config['upload_path'] = './_doping/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['overwrite'] = true;
                $config['file_name'] = $nombre_archivo;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                // File upload
                if ($this->upload->do_upload('foto')) {
                    $data = $this->upload->data();
                }
                $foto = $nombre_archivo;
            }
            $doping = array(
                'creacion' => $date,
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_candidato' => $id_candidato,
                'id_cliente' => $this->input->post('cliente'),
                'id_subcliente' => $this->input->post('subcliente'),
                'id_proyecto' => $this->input->post('proyecto'),
                'id_antidoping_paquete' => $this->input->post('paquete'),
                'fecha_doping' => $f_doping,
                'id_tipo_identificacion' => $this->input->post('identificacion'),
                'ine' => $this->input->post('ine'),
                'foto' => $foto,
                'razon' => $this->input->post('razon'),
                'medicamentos' => $this->input->post('medicamentos'),
                'folio' => $id_candidato,
                'codigo_prueba' => 'AD-' . $clave_cliente . '-' . $clave_subcliente . '-' . $id_candidato . '-' . substr(date('Y'), -2),
                'comentarios' => $this->input->post('comentarios'),
                'id_area' => $area->id,
                'foraneo' => $this->input->post('foraneo'),
            );
            $id_doping = $this->doping_model->insertDoping($doping);
            $clave_folio = array(
                'folio' => $id_doping,
                'codigo_prueba' => 'AD-' . $clave_cliente . '-' . $clave_subcliente . '-' . $id_doping . '-' . substr(date('Y'), -2),
            );
            $this->doping_model->editarDoping($clave_folio, $id_doping);
            $pruebas = array(
                'creacion' => $date,
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_usuario_cliente' => 0,
                'id_candidato' => $id_candidato,
                'id_cliente' => $this->input->post('cliente'),
                'tipo_antidoping' => 1,
                'antidoping' => $this->input->post('paquete'),
                'status_doping' => 1,
                'psicometrico' => 0,
                'socioeconomico' => 0,
            );
            $this->doping_model->insertCandidatoPruebas($pruebas);

            $paquete = $this->doping_model->getPaqueteCandidato($this->input->post('paquete'));
            $aux = explode(',', $paquete->sustancias);
            for ($i = 0; $i < count($aux); $i++) {
                $sustancia = $this->doping_model->getSustanciaCandidato($aux[$i]);
                $detalle = array(
                    'creacion' => $date,
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'id_doping' => $id_doping,
                    'id_candidato' => $id_candidato,
                    'id_sustancia' => $sustancia->id,
                );
                $this->doping_model->insertDetalleDoping($detalle);
            }
            $msj = array(
                'codigo' => 1,
                'msg' => 'success',
            );
        }
        echo json_encode($msj);
    }
    public function editarRegistro()
    {
        $this->form_validation->set_rules('nombre', 'Nombre(s)', 'required|trim');
        $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
        $this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
        $this->form_validation->set_rules('paquete', 'Parametros', 'required');
        $this->form_validation->set_rules('cliente', 'Cliente', 'required');
        $this->form_validation->set_rules('subcliente', 'Subcliente', 'required');
        $this->form_validation->set_rules('proyecto', 'Proyecto', 'required');
        $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required');
        $this->form_validation->set_rules('ine', 'Numero, licencia o código', 'required');
        $this->form_validation->set_rules('identificacion', 'Tipo de identificacion', 'required');
        $this->form_validation->set_rules('razon', 'Razon', 'required');
        $this->form_validation->set_rules('foraneo', '¿Este examen es foráneo (fuera de GDL)?', 'required');
        $this->form_validation->set_rules('medicamentos', 'Medicamentos', 'required');
        $this->form_validation->set_rules('fecha_doping', 'Fecha de doping', 'required');
        $this->form_validation->set_rules('id_doping', 'ID del doping', 'required');

        $this->form_validation->set_message('required', 'El campo %s es obligatorio');

        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');
            $id_usuario = $this->session->userdata('id');
            $id_candidato = $this->input->post('id_candidato');
            $id_doping = $this->input->post('id_doping');

            $f_nacimiento = fecha_espanol_bd($this->input->post('fecha_nacimiento'));
            $edad = calculaEdad($f_nacimiento);
            $f_doping = fecha_hora_espanol_bd($this->input->post('fecha_doping'));

            $prueba = $this->candidato_model->getPruebasCandidato($id_candidato);
            if ($prueba->socioeconomico == 1) {
                $datos_candidato = array(
                    'fecha_nacimiento' => $f_nacimiento,
                    'edad' => $edad,
                );
                $this->candidato_model->editarCandidato($datos_candidato, $id_candidato);
                $data['candidato'] = $this->doping_model->getDatosCandidato($id_candidato);
                foreach ($data['candidato'] as $row) {
                    $clave_cliente = $row->claveCliente;
                    $clave_subcliente = $row->claveSubcliente;
                }

                //Se obtiene el anterior doping
                $anterior_doping = $this->doping_model->getDopingCandidato($id_doping);
                //Se realiza proceso solo si el anterior doping y el nuevo son diferentes
                if ($this->input->post('paquete') != $anterior_doping->id_antidoping_paquete) {
                    $previo = $this->doping_model->getPaqueteCandidato($anterior_doping->id_antidoping_paquete);
                    //Se obtiene el nuevo
                    $paquete = $this->doping_model->getPaqueteCandidato($this->input->post('paquete'));
                    //Se obtienen los parametros de ambos
                    $aux = explode(',', $paquete->sustancias);
                    $aux2 = explode(',', $previo->sustancias);
                    //Se recorren los parametros del nuevo examen
                    for ($i = 0; $i < count($aux); $i++) {
                        $sustancia = $this->doping_model->getSustanciaCandidato($aux[$i]);
                        for ($j = 0; $j < count($aux2); $j++) {
                            //Se obtienen los detalles de los parametros del anterior doping
                            //y se guardan los id's de detalle_doping para despues borrarlos
                            $sust = $this->doping_model->getSustanciaCandidato($aux2[$j]);
                            $parametro = $this->doping_model->getDetallesParametro($id_doping, $sust->id);
                            $parametros_anteriores[] = $parametro->id;
                            //Si existe coincidencia entres id's del examen anterio al nuevo, se pasa el resultado a registrar
                            //para el nuevo examen y se rompe la iteracion para recorrer el siguiente parametro; si no hay coincidencia
                            //el resultado es negativo o cero
                            if ($sustancia->id == $sust->id) {
                                $res_sustancia = $parametro->resultado;
                                break;
                            } else {
                                $res_sustancia = 0;
                            }
                        }
                        //Se establecen los nuevos valores a colocar en el id de examen con los nuevos parametros
                        //y posibles nuevos resultados de cada uno guardados en $res_sustancia
                        $detalle = array(
                            'creacion' => $date,
                            'edicion' => $date,
                            'id_usuario' => $id_usuario,
                            'id_doping' => $id_doping,
                            'id_candidato' => $id_candidato,
                            'id_sustancia' => $sustancia->id,
                            'resultado' => $res_sustancia,
                        );
                        $this->doping_model->insertDetalleDoping($detalle);
                    }
                    //Se eliminan los anteriores parametros para dejar los nuevos ya registrados
                    for ($k = 0; $k < count($parametros_anteriores); $k++) {
                        $this->doping_model->eliminarParametro($id_doping, $parametros_anteriores[$k]);
                    }
                }
                if ($this->input->post('foraneo') == 'SI') {
                    $area = $this->area_model->getArea('DOPING FORANEO');
                } else {
                    $area = $this->area_model->getArea('DOPING LOCAL');
                }
                $doping = array(
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'id_antidoping_paquete' => $this->input->post('paquete'),
                    'fecha_doping' => $f_doping,
                    'id_tipo_identificacion' => $this->input->post('identificacion'),
                    'ine' => $this->input->post('ine'),
                    'razon' => $this->input->post('razon'),
                    'medicamentos' => $this->input->post('medicamentos'),
                    'codigo_prueba' => 'AD-' . $clave_cliente . '-' . $clave_subcliente . '-' . $id_doping . '-' . substr(date('Y'), -2),
                    'comentarios' => $this->input->post('comentarios'),
                    'foraneo' => $this->input->post('foraneo'),
                    'id_area' => $area->id,
                    'foraneo' => $this->input->post('foraneo'),
                );
                $this->doping_model->editarDoping($doping, $id_doping);

                $pruebas = array(
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'antidoping' => $this->input->post('paquete'),
                );
                $this->doping_model->updateCandidatoPruebas($pruebas, $id_candidato);
            } else {
                $datos_candidato = array(
                    'edicion' => $date,
                    'id_cliente' => $this->input->post('cliente'),
                    'id_subcliente' => $this->input->post('subcliente'),
                    'fecha_alta' => $date,
                    'nombre' => $this->input->post('nombre'),
                    'paterno' => $this->input->post('paterno'),
                    'materno' => $this->input->post('materno'),
                    'fecha_nacimiento' => $f_nacimiento,
                    'edad' => $edad,
                );
                $this->candidato_model->editarCandidato($datos_candidato, $id_candidato);
                $data['candidato'] = $this->doping_model->getDatosCandidato($id_candidato);
                foreach ($data['candidato'] as $row) {
                    $clave_cliente = $row->claveCliente;
                    $clave_subcliente = $row->claveSubcliente;
                }
                //Se obtiene el anterior doping
                $anterior_doping = $this->doping_model->getDopingCandidato($id_doping);
                //Se realiza proceso solo si el anterior doping y el nuevo son diferentes
                if ($this->input->post('paquete') != $anterior_doping->id_antidoping_paquete) {
                    $previo = $this->doping_model->getPaqueteCandidato($anterior_doping->id_antidoping_paquete);
                    //Se obtiene el nuevo
                    $paquete = $this->doping_model->getPaqueteCandidato($this->input->post('paquete'));
                    //Se obtienen los parametros de ambos
                    $aux = explode(',', $paquete->sustancias);
                    $aux2 = explode(',', $previo->sustancias);
                    //Se recorren los parametros del nuevo examen
                    for ($i = 0; $i < count($aux); $i++) {
                        $sustancia = $this->doping_model->getSustanciaCandidato($aux[$i]);
                        for ($j = 0; $j < count($aux2); $j++) {
                            //Se obtienen los detalles de los parametros del anterior doping
                            //y se guardan los id's de detalle_doping para despues borrarlos
                            $sust = $this->doping_model->getSustanciaCandidato($aux2[$j]);
                            $parametro = $this->doping_model->getDetallesParametro($id_doping, $sust->id);
                            $parametros_anteriores[] = $parametro->id;
                            //Si existe coincidencia entres id's del examen anterio al nuevo, se pasa el resultado a registrar
                            //para el nuevo examen y se rompe la iteracion para recorrer el siguiente parametro; si no hay coincidencia
                            //el resultado es negativo o cero
                            if ($sustancia->id == $sust->id) {
                                $res_sustancia = $parametro->resultado;
                                break;
                            } else {
                                $res_sustancia = 0;
                            }
                        }
                        //Se establecen los nuevos valores a colocar en el id de examen con los nuevos parametros
                        //y posibles nuevos resultados de cada uno guardados en $res_sustancia
                        $detalle = array(
                            'creacion' => $date,
                            'edicion' => $date,
                            'id_usuario' => $id_usuario,
                            'id_doping' => $id_doping,
                            'id_candidato' => $id_candidato,
                            'id_sustancia' => $sustancia->id,
                            'resultado' => $res_sustancia,
                        );
                        $this->doping_model->insertDetalleDoping($detalle);
                    }
                    //Se eliminan los anteriores parametros para dejar los nuevos ya registrados
                    for ($k = 0; $k < count($parametros_anteriores); $k++) {
                        $this->doping_model->eliminarParametro($id_doping, $parametros_anteriores[$k]);
                    }
                }
                if ($this->input->post('foraneo') == 'SI') {
                    $area = $this->area_model->getArea('DOPING FORANEO');
                } else {
                    $area = $this->area_model->getArea('DOPING LOCAL');
                }
                $doping = array(
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'id_cliente' => $this->input->post('cliente'),
                    'id_subcliente' => $this->input->post('subcliente'),
                    'id_proyecto' => $this->input->post('proyecto'),
                    'id_antidoping_paquete' => $this->input->post('paquete'),
                    'fecha_doping' => $f_doping,
                    'id_tipo_identificacion' => $this->input->post('identificacion'),
                    'ine' => $this->input->post('ine'),
                    'razon' => $this->input->post('razon'),
                    'medicamentos' => $this->input->post('medicamentos'),
                    'codigo_prueba' => 'AD-' . $clave_cliente . '-' . $clave_subcliente . '-' . $id_doping . '-' . substr(date('Y'), -2),
                    'comentarios' => $this->input->post('comentarios'),
                    'foraneo' => $this->input->post('foraneo'),
                    'id_area' => $area->id,
                    'foraneo' => $this->input->post('foraneo'),
                );
                $this->doping_model->editarDoping($doping, $id_doping);

                $pruebas = array(
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'id_cliente' => $this->input->post('cliente'),
                    'antidoping' => $this->input->post('paquete'),
                );
                $this->doping_model->updateCandidatoPruebas($pruebas, $id_candidato);

            }

            if (isset($_FILES['foto'])) {
                $cadena = substr(md5(time()), 0, 16);
                $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $config['file_name'] = $id_candidato . '_' . $cadena . '.' . $extension;
                $nombre_archivo = $id_candidato . '_' . $cadena . '.' . $extension;

                $config['upload_path'] = './_doping/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['overwrite'] = true;
                $config['file_name'] = $nombre_archivo;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                // File upload
                if ($this->upload->do_upload('foto')) {
                    $foto = array(
                        'foto' => $nombre_archivo,
                    );
                    $this->doping_model->editarDoping($foto, $id_doping);
                }
            }
            //$this->doping_model->eliminarDopingDetalle($id_doping);
            $msj = array(
                'codigo' => 1,
                'msg' => 'success',
            );
        }
        echo json_encode($msj);
    }
    public function registrarResultadosDoping()
    {
        $this->form_validation->set_rules('fecha_resultados', 'Fecha de resultados', 'required');
        $this->form_validation->set_rules('valores', 'Parámetros', 'required');
        $this->form_validation->set_message('required', 'El campo %s es obligatorio');

        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');
            $id_usuario = $this->session->userdata('id');
            $id_doping = $this->input->post('id_doping');
            $cadena = $this->input->post('valores');
            $f_resultados = fecha_hora_espanol_bd($_POST['fecha_resultados']);
            $valores = explode(',', $cadena);
            $cont = 0;
            $invalido = 0;
            for ($i = 0; $i < count($valores); $i++) {
                $valor = explode(':', $valores[$i]);
                $res = array(
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'resultado' => $valor[1],
                );
                $this->doping_model->updateResultadoDoping($id_doping, $valor[0], $res);
                if ($valor[1] == 1) {
                    $cont++;
                }
                if ($valor[1] == 2) {
                    $invalido++;
                }
            }
            if ($cont > 0 && $invalido == 0) {
                $doping = array(
                    'edicion' => $date,
                    //'id_usuario' => $id_usuario,
                    'fecha_resultado' => $f_resultados,
                    'resultado' => 1,
                );
                $this->doping_model->editarDoping($doping, $id_doping);
            }
            if ($cont == 0 && $invalido == 0) {
                $doping = array(
                    'edicion' => $date,
                    //'id_usuario' => $id_usuario,
                    'fecha_resultado' => $f_resultados,
                    'resultado' => 0,
                );
                $this->doping_model->editarDoping($doping, $id_doping);
            }
            if ($invalido > 0) {
                $doping = array(
                    'edicion' => $date,
                    //'id_usuario' => $id_usuario,
                    'fecha_resultado' => $f_resultados,
                    'resultado' => 2,
                );
                $this->doping_model->editarDoping($doping, $id_doping);
            }

            //* Envio de correo al finalizar el doping del candidato. Solo HCL
            $dopingCandidato = $this->doping_model->getDopingCandidato($id_doping);
            $candidato_detalle = $this->candidato_model->getDetalles($dopingCandidato->id_candidato);
            if ($candidato_detalle->id_cliente == 2) {
                $from = $this->config->item('smtp_user');
                $to = 'bgv.latam@hcl.com';
                $subject = "Candidate drug test results - RODI (PERINTEX)";
                //$data['usuario'] = $usuario->nombreUsuario;
                $data['candidato'] = $candidato_detalle->candidato;
                $message = $this->load->view('mails/doping_resultados_hcl', $data, true);
                $this->load->library('phpmailer_lib');
                $mail = $this->phpmailer_lib->load();
                $mail->isSMTP();
                $mail->Host = 'mail.rodicontrol.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'rodicontrol@rodicontrol.com';
                $mail->Password = 'r49o*&rUm%91';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('rodicontrol@rodicontrol.com', 'Automatic message from RODICONTROL');
                $mail->addAddress($to);
                $mail->Subject = $subject;
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Body = $message;
                $mail->send();
            }

            $msj = array(
                'codigo' => 1,
                'msg' => 'success',
            );
        }
        echo json_encode($msj);
    }
    public function eliminarDoping()
    {
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_usuario = $this->session->userdata('id');
        $id_candidato = $this->input->post('id_candidato');
        $id_doping = $this->input->post('id_doping');
        $prueba = $this->candidato_model->getPruebasCandidato($id_candidato);
        if ($prueba->socioeconomico == 1) {
            $this->doping_model->eliminarDoping($id_doping);
            $this->doping_model->eliminarDopingDetalle($id_doping);
            $pruebas = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'status_doping' => 0,
            );
            $this->doping_model->editarPruebasCandidato($pruebas, $id_candidato);
        } else {
            $this->doping_model->eliminarDoping($id_doping);
            $this->doping_model->eliminarDopingDetalle($id_doping);
            $this->doping_model->eliminarCandidato($id_candidato);
            $this->doping_model->eliminarPruebasCandidato($id_candidato);
        }
        $msj = array(
            'codigo' => 1,
            'msg' => 'success',
        );
        echo json_encode($msj);
    }
    /*----------------------------------------*/
    /*  Funciones comunes
    /*----------------------------------------*/
    public function getDopingsEliminados()
    {
        $data['eliminados'] = $this->doping_model->getDopingsEliminados();
        if ($data['eliminados']) {
            $salida = '<table class="table table-striped" style="font-size: 13px">';
            $salida .= '<tr style="background: gray;color:white;">';
            $salida .= '<th>Fecha doping</th>';
            $salida .= '<th>Nombre</th>';
            //$salida .= '<th>Cliente</th>';
            $salida .= '<th>Código</th>';
            $salida .= '<th>Motivo</th>';
            $salida .= '<th>Usuario</th>';
            $salida .= '</tr>';
            foreach ($data['eliminados'] as $c) {
                $subcliente = ($c->subcliente != "" && $c->subcliente != null) ? $c->subcliente : "";
                $proyecto = ($c->proyecto != "" && $c->proyecto != null) ? $c->proyecto : "";
                $salida .= "<tr>";
                $salida .= '<td>' . $c->fecha_doping . '</td>';
                $salida .= '<td>' . $c->nombre . " " . $c->paterno . " " . $c->materno . '</td>';
                //$salida .= '<td>'.$c->cliente.'-'.$subcliente.'-'.$proyecto.'</td>';
                $salida .= '<td>' . $c->codigo_prueba . '</td>';
                $salida .= '<td width="30%">' . $c->motivo . '</td>';
                $salida .= '<td width="10%">' . $c->usuario . '</td>';
                $salida .= "</tr>";
            }
            $salida .= "</table>";
        } else {
            $salida = '<p style="text-align:center;font-size:18px;font-weight:bold;">Sin registros</p>';
        }

        echo $salida;
    }

    public function getExamenDopingByProceso()
    {
        $data['examenes_proceso'] = $this->doping_model->getExamenDopingByProceso($this->input->post('id_previo'));
        $salida = '';
        // $salida = '<option value="">Select</option>';
        // $salida .= '<option value="0">NA</option>';
        if ($data['examenes_proceso']) {
            foreach ($data['examenes_proceso'] as $row) {
                $salida .= '<option value="' . $row->id_examen_doping . '">' . $row->nombreDoping . ' (' . $row->conjunto . ')</option>';
            }
        } else {
            $data['examenes'] = $this->doping_model->getPaquetesAntidoping();
            if ($data['examenes']) {
                $salida .= '<option value="0">N/A</option>';
                foreach ($data['examenes'] as $row) {
                    $salida .= '<option value="' . $row->id . '">' . $row->nombre . ' (' . $row->conjunto . ')</option>';
                }
            }
        }
        echo $salida;
    }
    public function getExamenDopingByCliente()
    {
        $data['examenes'] = $this->doping_model->getExamenDopingByCliente($this->input->post('id_cliente'));
        $salida = '';
        if ($data['examenes']) {
            foreach ($data['examenes'] as $row) {
                $salida .= '<option value="' . $row->id_antidoping_paquete . '">' . $row->nombre . ' (' . $row->conjunto . ')</option>';
            }
        } else {
            $data['examenes'] = $this->doping_model->getPaquetesAntidoping();
            if ($data['examenes']) {
                $salida .= '<option value="0">N/A</option>';
                foreach ($data['examenes'] as $row) {
                    $salida .= '<option value="' . $row->id . '">' . $row->nombre . ' (' . $row->conjunto . ')</option>';
                }
            }
        }
        echo $salida;
    }

    public function getAntidopingCandidato()
    {
        $id_candidato = $_POST['id_candidato'];
        $data['parametros'] = $this->doping_model->getParametrosCandidato($id_candidato);
        foreach ($data['parametros'] as $p) {
            $tipo = $p->tipo_antidoping;
            $parametros = $p->antidoping;
        }
        if ($tipo == 1) {
            $paquete = $this->doping_model->getPaqueteCandidato($parametros);
            $salida = '<span><b>Examen antidoping: </b></span><br>';
            $salida .= '<span><b>' . $paquete->nombre . '</b></span><br>';
            $aux = explode(',', $paquete->sustancias);
            $salida .= '<small>(';
            for ($i = 0; $i < count($aux); $i++) {
                $sustancia = $this->doping_model->getSustanciaCandidato($aux[$i]);
                $salida .= $sustancia->abreviatura . ' ';
            }
            $salida .= ')</small><br><br>';
            echo $salida;

        }
        if ($tipo == 2) {
            $aux = explode(',', $parametros);
            $salida = '<span><b>Doping por parámetro: </b></span><br>';
            $salida .= '<span><b>';
            $extra = '(';
            for ($i = 0; $i < count($aux); $i++) {
                $sustancia = $this->doping_model->getSustanciaCandidato($aux[$i]);
                $salida .= $sustancia->abreviatura . ' ';
                $extra .= ' ' . $sustancia->descripcion;
            }
            $extra .= ' )';
            $salida .= '</b></span><br>' . $extra . '<br><br>';
            echo $salida;
        }
    }

    public function getSubclientes()
    {
        $id_cliente = $_POST['id_cliente'];
        $data['subclientes'] = $this->doping_model->getSubclientes($id_cliente);
        $salida = "<option value='0' selected>Selecciona</option>";
        $salida .= "<option value='0'>N/A</option>";
        if ($data['subclientes']) {
            foreach ($data['subclientes'] as $row) {
                $salida .= "<option value='" . $row->id . "'>" . $row->nombre . "</option>";
            }
            echo $salida;
        } else {
            echo $salida;
        }
    }
    public function getProyectos()
    {
        $id_cliente = $_POST['id_cliente'];
        $data['proyectos'] = $this->doping_model->getProyectos($id_cliente);
        $salida = "<option value='0' selected>Selecciona</option>";
        $salida .= "<option value='0'>N/A</option>";
        if ($data['proyectos']) {
            foreach ($data['proyectos'] as $row) {
                $salida .= "<option value='" . $row->id . "'>" . $row->nombre . "</option>";
            }
            echo $salida;
        } else {
            echo $salida;
        }
    }
    public function getProyectosSubcliente()
    {
        $id_cliente = $_POST['id_cliente'];
        $id_subcliente = $_POST['id_subcliente'];
        $data['proyectos'] = $this->doping_model->getProyectosSubcliente($id_cliente, $id_subcliente);
        $salida = "<option value=''>Selecciona</option>";
        $salida .= "<option value='0'>N/A</option>";
        if ($data['proyectos']) {
            foreach ($data['proyectos'] as $row) {
                $salida .= "<option value='" . $row->id . "'>" . $row->nombre . "</option>";
            }
            echo $salida;
        } else {
            echo $salida;
        }
    }
    public function getPaqueteCliente()
    {
        $id_cliente = $_POST['id_cliente'];
        $id_subcliente = $_POST['id_subcliente'];
        $id_proyecto = $_POST['id_proyecto'];
        $data['examenes'] = $this->doping_model->getPaqueteCliente($id_cliente, $id_subcliente, $id_proyecto);
        $salida = "";
        if ($data['examenes']) {
            foreach ($data['examenes'] as $row) {
                $salida .= "<option value='" . $row->id_antidoping_paquete . "'>" . $row->nombre . "</option>";
            }
            echo $salida;
        } else {
            echo $salida;
        }
    }
    public function getPaqueteSubcliente()
    {
        $id_cliente = $_POST['id_cliente'];
        $id_subcliente = $_POST['id_subcliente'];
        $id_proyecto = $_POST['id_proyecto'];
        $paq = $this->doping_model->getPaqueteSubcliente($id_cliente, $id_subcliente);
        $salida = "";
        if ($paq) {
            echo $paq->id_antidoping_paquete;
        } else {
            echo $salida;
        }
    }
    public function getPaqueteSubclienteProyecto()
    {
        $id_cliente = $_POST['id_cliente'];
        $id_subcliente = $_POST['id_subcliente'];
        $id_proyecto = $_POST['id_proyecto'];
        $paq = $this->doping_model->getPaqueteSubclienteProyecto($id_cliente, $id_proyecto, $id_subcliente);
        $salida = "";
        //$salida .= "<option value='0'>N/A</option>";
        if ($paq) {
            echo $paq->id_antidoping_paquete;
        } else {
            echo $salida;
        }
    }

    /*function editarPendiente(){
    $this->form_validation->set_rules('ine', 'Numero, licencia o código', 'required');
    $this->form_validation->set_rules('identificacion', 'Tipo de identificacion', 'required');
    $this->form_validation->set_rules('razon', 'Razon', 'required');
    $this->form_validation->set_rules('medicamentos', 'Medicamentos', 'required');
    $this->form_validation->set_rules('fecha_doping', 'Fecha de doping', 'required');

    $this->form_validation->set_message('required','El campo %s es obligatorio');

    if ($this->form_validation->run() == FALSE) {
    $msj = array(
    'codigo' => 0,
    'msg' => validation_errors()
    );
    }
    else{
    date_default_timezone_set('America/Mexico_City');
    $date = date('Y-m-d H:i:s');
    $id_usuario = $this->session->userdata('id');
    $id_doping = $this->input->post('id_doping');
    $id_candidato = $this->input->post('id_candidato');

    $f_doping = fecha_hora_espanol_bd($this->input->post('fecha_doping'));

    $data['candidato'] = $this->doping_model->getDatosCandidato($id_candidato);
    foreach($data['candidato'] as $row){
    $nombre = $row->nombre;
    $paterno = $row->paterno;
    }
    if(isset($_FILES["foto"])){
    $file_ext = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
    $nombre = str_replace(' ', '', $nombre);
    $paterno = str_replace(' ', '', $paterno);
    $nombre_archivo = $this->input->post('id_candidato')."_".$nombre."".$paterno."_Foto.".$file_ext;

    $config['upload_path'] = './_doping/';
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['overwrite'] = TRUE;
    $config['file_name'] = $nombre_archivo;

    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    // File upload
    if($this->upload->do_upload('foto')){
    $data = $this->upload->data();
    }
    $foto = array(
    'foto' => $nombre_archivo
    );
    $this->doping_model->editarDoping($foto, $id_doping);
    }
    $doping = array(
    'edicion' => $date,
    'id_usuario' => $id_usuario,
    'fecha_doping' => $f_doping,
    'id_tipo_identificacion' => $this->input->post('identificacion'),
    'ine' => $this->input->post('ine'),
    'razon' => $this->input->post('razon'),
    'medicamentos' => $this->input->post('medicamentos'),
    'comentarios' => $this->input->post('comentarios')
    );
    $this->doping_model->editarDoping($doping, $id_doping);
    $msj = array(
    'codigo' => 1,
    'msg' => 'success'
    );
    }
    echo json_encode($msj);
    }*/
    public function getClaveCliente()
    {
        $id_cliente = $_POST['id_cliente'];
        $id_subcliente = $_POST['id_subcliente'];
        $id_proyecto = $_POST['id_proyecto'];
        if ($id_subcliente == 0) {
            if ($id_proyecto == 0) {
                $cliente = $this->funciones_model->getClaveCliente($id_cliente);
                $doping = $this->doping_model->getLastDoping();
                $doping = ($doping == "" || $doping == null) ? 0 : $doping->id;
                $salida = "AD-" . $cliente->clave . "--" . ($doping + 1) . "-" . substr(date('Y'), -2);
            } else {
                $cliente = $this->funciones_model->getClaveProyecto($id_cliente, $id_proyecto);
                $doping = $this->doping_model->getLastDoping();
                $doping = ($doping == "" || $doping == null) ? 0 : $doping->id;
                $salida = "AD-" . $cliente->claveCliente . "--" . ($doping + 1) . "-" . substr(date('Y'), -2);
            }
        } else {
            if ($id_proyecto == 0) {
                $cliente = $this->funciones_model->getClaveSubcliente($id_cliente, $id_subcliente);
                $doping = $this->doping_model->getLastDoping();
                $doping = ($doping == "" || $doping == null) ? 0 : $doping->id;
                $salida = "AD-" . $cliente->claveCliente . "-" . $cliente->claveSubcliente . "-" . ($doping + 1) . "-" . substr(date('Y'), -2);
            } else {
                $subcliente = $this->funciones_model->getClaveSubclienteProyecto($id_cliente, $id_proyecto, $id_subcliente);
                $doping = $this->doping_model->getLastDoping();
                $doping = ($doping == "" || $doping == null) ? 0 : $doping->id;
                $salida = "AD-" . $subcliente->claveCliente . "-" . $subcliente->claveSubcliente . "-" . ($doping + 1) . "-" . substr(date('Y'), -2);
            }
        }
        echo $salida;
    }
    public function checkPendienteDoping()
    {
        $es_pendiente = $this->doping_model->checkPendienteDoping($this->input->post('nombre'), $this->input->post('paterno'), $this->input->post('materno'));
        if ($es_pendiente > 0) {
            $msj = array(
                'codigo' => 1,
                'msg' => 'El candidato esta disponible en Pendientes',
            );
        } else {
            $msj = array(
                'codigo' => 0,
                'msg' => '',
            );
        }
        echo json_encode($msj);
    }
    public function calculaEdad($fechanacimiento)
    {
        list($ano, $mes, $dia) = explode("-", $fechanacimiento);
        $ano_diferencia = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia = date("d") - $dia;
        if ($mes_diferencia < 0 || ($mes_diferencia == 0 && $dia_diferencia < 0 || $mes_diferencia < 0)) {
            $ano_diferencia--;
        }

        return $ano_diferencia;
    }
    public function getDopingCandidato()
    {
        $id_doping = $_POST['id_doping'];
        $id_candidato = $_POST['id_candidato'];
        $candidato = $this->doping_model->getDopingCandidato($id_doping);
        $data['parametros'] = $this->doping_model->getParametrosCandidato($id_candidato);
        foreach ($data['parametros'] as $p) {
            $tipo = $p->tipo_antidoping;
            $parametros = $p->antidoping;
        }
        if ($tipo == 1) {
            $paquete = $this->doping_model->getPaqueteCandidato($parametros);
            $doping = '<span><b>Doping: </b></span><br>';
            $doping .= '<span><b>' . $paquete->nombre . '</b></span><br>';
            $aux = explode(',', $paquete->sustancias);
            $doping .= '<span>(';
            for ($i = 0; $i < count($aux); $i++) {
                $sustancia = $this->doping_model->getSustanciaCandidato($aux[$i]);
                $doping .= $sustancia->abreviatura . ' ';
            }
            $doping .= ')</span><br>';
        }
        $salida = $candidato->ine . '##' . $candidato->medicamentos . '##' . $candidato->folio . '##' . $candidato->comentarios . '##' . $doping . '##' . $candidato->identificacion;
        echo $salida;
    }
    public function getSustanciasDoping()
    {
        $id_doping = $_POST['id_doping'];
        $id_candidato = $_POST['id_candidato'];
        $salida = "";
        $data['sustancias'] = $this->doping_model->getSustanciasDoping($id_doping);
        foreach ($data['sustancias'] as $s) {
            $sustancia = $this->doping_model->getSustanciaCandidato($s->id_sustancia);
            $salida .= '<div class="row">';
            $salida .= '<div class="col-md-6 col-md-offset-1 text-center">';
            $salida .= '<b>' . $sustancia->abreviatura . '</b><br><small>' . $sustancia->descripcion . '</small>';
            $salida .= '</div>';
            $salida .= '<div class="col-md-3">';
            $salida .= '<select id="sust' . $sustancia->id . '" name="sust' . $sustancia->id . '" class="form-control es_sustancia sust_obligado">';

            if ($s->resultado != -1) {
                if ($s->resultado == 0) {
                    $salida .= '<option value="' . $sustancia->id . ':0" selected>Negativo</option>';
                    $salida .= '<option value="' . $sustancia->id . ':1">Positivo</option>';
                    $salida .= '<option value="' . $sustancia->id . ':2">Inválido</option>';
                }
                if ($s->resultado == 1) {
                    $salida .= '<option value="' . $sustancia->id . ':1" selected>Positivo</option>';
                    $salida .= '<option value="' . $sustancia->id . ':0">Negativo</option>';
                    $salida .= '<option value="' . $sustancia->id . ':2">Inválido</option>';
                }
                if ($s->resultado == 2) {
                    $salida .= '<option value="' . $sustancia->id . ':1">Positivo</option>';
                    $salida .= '<option value="' . $sustancia->id . ':0">Negativo</option>';
                    $salida .= '<option value="' . $sustancia->id . ':2" selected>Inválido</option>';
                }
            } else {
                $salida .= '<option value="">Selecciona resultado</option>';
                $salida .= '<option value="' . $sustancia->id . ':0" selected>Negativo</option>';
                $salida .= '<option value="' . $sustancia->id . ':1">Positivo</option>';
                $salida .= '<option value="' . $sustancia->id . ':2">Inválido</option>';
            }
            $salida .= '</select><br>';
            $salida .= '</div>';
            $salida .= '</div>';
        }
        echo $salida;
    }
    public function createReporteDopingPDF()
    {
        $mpdf = new \Mpdf\Mpdf();
        date_default_timezone_set('America/Mexico_City');
        $data['hoy'] = date("d-m-Y");
        $hoy = date("d-m-Y");
        if ($this->uri->segment(3) != null) {
            $id_doping = $this->uri->segment(3);
        } else {
            $id_doping = $_POST['idDop'];
        }

        $doping = $this->doping_model->getDatosDoping($id_doping);
        if ($doping->foraneo == 'SI') {
            $data['area'] = $this->area_model->getArea('DOPING FORANEO');
        } else {
            $data['area'] = $this->area_model->getAreaById($doping->id_area);
        }

        //
        if ($doping->qr_token == null) {
            $this->load->library('ciqrcode');
            //QR de consulta
            $claveAleatoria = substr(md5(microtime()), 1, 16);
            $params['data'] = 'https://test-result.rodi.com.mx/doping/doping.php?uid=' . $claveAleatoria;
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = "./_qrconsult/qr_$id_doping.png";
            $this->ciqrcode->generate($params);
            $data['qr'] = "qr_$id_doping.png";
            $datos = array(
                'qr_token' => $claveAleatoria,
            );
            $this->doping_model->editarDoping($datos, $id_doping);
        } else {
            $data['qr'] = "qr_$id_doping.png";
        }
        //
        $data['doping'] = $doping;
        $html = $this->load->view('pdfs/reporte_doping_pdf', $data, true);
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->SetHTMLHeader('<div style="width: 100%; float: left;"><img style="height: 150px;" src="' . base_url() . 'img/Encabezado.png"></div>');
        $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 12px;"><div style="border-bottom:1px solid gray;"><b>Teléfono:</b> (33) 2301-8599 | <b>Correo:</b> hola@rodi.com.mx | <b>Sitio web:</b> rodi.com.mx</div><br>Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco, México. C.P. 45018 <br><br>FOP-07 Rev. 00 <br>Fecha de Rev. 18/11/2021</p></div><div style="position: absolute; right: 10px;  bottom: 13px;"><img width="" src="' . base_url() . 'img/logo2.png"></div>');
        //Cifrar pdf
        $nombreArchivo = substr(md5(microtime()), 1, 12);
        /*if($tipo_usuario == 1){
        $usuario = $this->usuario_model->getDatosUsuarioInterno($id_usuario);
        }*/
        $mpdf->WriteHTML($html);

        $mpdf->Output('' . $nombreArchivo . '.pdf', 'D'); // opens in browser
    }
    public function createPDF()
    {
        $mpdf = new \Mpdf\Mpdf();
        date_default_timezone_set('America/Mexico_City');
        $data['hoy'] = date("d-m-Y");
        $hoy = date("d-m-Y");
        if ($this->uri->segment(3) != null) {
            $id_doping = $this->uri->segment(3);
        } elseif (isset($_POST['idDop'])) {
            $id_doping = $_POST['idDop'];
        } else {
            $id_doping = $this->input->get('id');
        }

        // Primera solicitud cURL
        $url_doping = API_URL . 'doping/' . $id_doping;
        $ch_doping = curl_init($url_doping);
        curl_setopt($ch_doping, CURLOPT_RETURNTRANSFER, true);
        $response_doping = curl_exec($ch_doping);

        // Verificar si ocurrió un error durante la ejecución de cURL
        if ($response_doping === false) {
            $error_doping = curl_error($ch_doping);

            $_SESSION['errorArea'] = 'Error en la solicitud cURL para Área: ' . $error_doping;

            // Cerrar la sesión cURL
            curl_close($ch_doping);

            // Redireccionar a la página anterior
            header('Location: ' . $_SERVER['HTTP_REFERER']);

        }

        // Decodificar la respuesta JSON para la primera solicitud
        $doping = json_decode($response_doping);
        /*echo "<br>";
        print_r($doping);
        echo "<br>";
        die(); */
        // Cerrar la sesión cURL para la primera solicitud
        curl_close($ch_doping);
        $directorio = '_doping';
        $nombreArchivo = $doping->foto;

       // $resultado = $this->api_traer_documentos_model->obtenerImagenExterna($directorio, $nombreArchivo);

        if (isset($resultado['error'])) {
            log_message('error', 'Error: ' . $resultado['error']);
        }
        // Mostrar la imagen
        //    header('Content-Type: image/jpeg');
        //echo $resultado;

        //$resultado2 = $this->api_traer_documentos_model->guardarImagen($resultado, $nombreArchivo, $directorio);

        // Segunda solicitud cURL para obtener los datos del área
        $urlArea = '';
        if ($doping->foraneo == 'SI') {
            $nombre = "DOPING FORANEO";
            $urlArea = API_URL . 'area/' . urlencode($nombre);
        } else {
            $urlArea = API_URL . 'area/' . urlencode($doping->id_area);
        }

        $chArea = curl_init($urlArea);
        curl_setopt($chArea, CURLOPT_RETURNTRANSFER, true);
        $responseArea = curl_exec($chArea);

        if ($responseArea === false) {
            $errorArea = curl_error($chArea);
            curl_close($chArea);
            $_SESSION['errorArea'] = 'Error en la solicitud cURL para Área: ' . $errorArea;

            // Cerrar la sesión cURL
            curl_close($ch);

            // Redireccionar a la página anterior
            header('Location: ' . $_SERVER['HTTP_REFERER']);

        } else {
            $area = json_decode($responseArea);
            curl_close($chArea);
            $data['area'] = $area;
            // Procesar los datos del área obtenidos
            /*
        echo "<br>";
        print_r($doping->foto);
        echo "<br>";
        die();*/
        }

        //* Creacion codigo QR para consulta en linea
        if ($doping->qr_token !== null) {
            $this->load->library('ciqrcode');
            //QR de consulta
            $claveAleatoria = substr(md5(microtime()), 1, 16);
            $params['data'] = 'https://test-result.rodi.com.mx/doping/doping.php?uid=' . $claveAleatoria;
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = "./_qrconsult/qr_$id_doping.png";
            $this->ciqrcode->generate($params);

            $data['qr'] = "qr_$id_doping.png";

            $datos = array(
                'qr_token' => $claveAleatoria,
            );
            $this->doping_model->editarDoping($datos, $id_doping);
        } else {
            $data['qr'] = "qr_$id_doping.png";
        }

        //
        $data['doping'] = $doping;

        $html = $this->load->view('pdfs/doping_pdf', $data, true);
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->SetHTMLHeader('<div style="width: 100%; float: left;"><img style="height: 150px;" src="' . base_url() . 'img/Encabezado.png"></div>');
        $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 12px;"><div style="border-bottom:1px solid gray;"><b>Teléfono:</b> (33) 2301-8599 | <b>Correo:</b> hola@rodi.com.mx | <b>Sitio web:</b> rodi.com.mx</div><br>Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco, México. C.P. 45018 <br><br>FOP-07 Rev. 00 <br>Fecha de Rev. 18/11/2021</p></div><div style="position: absolute; right: 10px;  bottom: 13px;"><img width="" src="' . base_url() . 'img/logo2.png"></div>');
        $mpdf->WriteHTML($html);

   

        try {
            $mpdf->Output('doping_' . $doping->codigo_prueba . '_' . $doping->nombre . '_' . $doping->paterno . '.pdf', 'D');
        } catch (\Mpdf\MpdfException $e) {
            echo 'Error generating PDF: ' . $e->getMessage();
        } catch (\DivisionByZeroError $e) {
            echo 'Division by zero error: ' . $e->getMessage();
        } // opens in browser
    }

    public function crearPDFIngles()
    {
        $mpdf = new \Mpdf\Mpdf();
        date_default_timezone_set('America/Mexico_City');
        $data['hoy'] = date("d-m-Y");
        $hoy = date("d-m-Y");
        if ($this->uri->segment(3) != null) {
            $id_doping = $this->uri->segment(3);
        } else {
            $id_doping = $_POST['idDopingIngles'];
        }
        $doping = $this->doping_model->getDatosDoping($id_doping);
        if ($doping->foraneo == 'SI') {
            $data['area'] = $this->area_model->getArea('DOPING FORANEO');
        } else {
            $data['area'] = $this->area_model->getAreaById($doping->id_area);
        }
        //
        if ($doping->qr_token == null) {
            $this->load->library('ciqrcode');
            //QR de consulta
            $claveAleatoria = substr(md5(microtime()), 1, 16);
            $params['data'] = 'https://test-result.rodi.com.mx/doping/doping.php?uid=' . $claveAleatoria;
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = "./_qrconsult/qr_$id_doping.png";
            $this->ciqrcode->generate($params);
            $data['qr'] = "qr_$id_doping.png";
            $datos = array(
                'qr_token' => $claveAleatoria,
            );
            $this->doping_model->editarDoping($datos, $id_doping);
        } else {
            $data['qr'] = "qr_$id_doping.png";
        }
        $data['doping'] = $doping;
        $html = $this->load->view('pdfs/doping_ingles_pdf', $data, true);
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->SetHTMLHeader('<div style="width: 100%; float: left;"><img style="height: 150px;" src="' . base_url() . 'img/Encabezado.png"></div>');
        $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 12px;"><div style="border-bottom:1px solid gray;"><b>Telephone:</b> (33) 2301-8599 | <b>Email:</b> hola@rodi.com.mx | <b>Website:</b> rodi.com.mx</div><br>Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco, México. C.P. 45018 <br><br>FOP-07 Rev. 00 <br>Fecha de Rev. 18/11/2021</p></div><div style="position: absolute; right: 10px;  bottom: 13px;"><img width="" src="' . base_url() . 'img/logo2.png"></div>');
        $mpdf->WriteHTML($html);

        $mpdf->Output('doping_' . $doping->codigo_prueba . '_' . $doping->nombre . '_' . $doping->paterno . '.pdf', 'D'); // opens in browser
    }
    public function createPDF2()
    {
        $mpdf = new \Mpdf\Mpdf();
        date_default_timezone_set('America/Mexico_City');
        $data['hoy'] = date("d-m-Y");
        $hoy = date("d-m-Y");
        $id_doping = $_POST['idPDF2'];
        $doping = $this->doping_model->getDatosDoping($id_doping);
        if ($doping->foraneo == 'SI') {
            $data['area'] = $this->area_model->getArea('DOPING FORANEO');
        } else {
            $data['area'] = $this->area_model->getAreaById($doping->id_area);
        }

        $data['doping'] = $doping;
        $html = $this->load->view('pdfs/doping_adul_pdf', $data, true);
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->SetHTMLHeader('<div style="width: 100%; float: left;"><img style="height: 150px;" src="' . base_url() . 'img/Encabezado.png"></div>');
        $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 12px;"><div style="border-bottom:1px solid gray;"><b>Teléfono:</b> (33) 2301-8599 | <b>Correo:</b> hola@rodi.com.mx | <b>Sitio web:</b> rodi.com.mx</div><br>Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco, México. C.P. 45018 <br></p></div><div style="position: absolute; right: 10px;  bottom: 13px;"><img width="" src="' . base_url() . 'img/logo2.png"></div>');
        $mpdf->WriteHTML($html);

        $mpdf->Output('doping_adul_' . $doping->codigo_prueba . '_' . $doping->nombre . '_' . $doping->paterno . '.pdf', 'D'); // opens in browser
    }
    public function createCadenaPDF()
    {
        $mpdf = new \Mpdf\Mpdf();
        date_default_timezone_set('America/Mexico_City');
        $data['hoy'] = date("d-m-Y");
        $hoy = date("d-m-Y");
        $id_doping = $_POST['idCadena'];
        $doping = $this->doping_model->getDatosDoping($id_doping);

        $data['doping'] = $doping;
        $html = $this->load->view('pdfs/doping_cadena_pdf', $data, true);
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->SetHTMLHeader('<div style="width: 100%; float: left;"><img style="height: 50px;" src="' . base_url() . 'img/logo.png"></div>');
        $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px;"><p style="font-size: 12px;"><div style="width: 95%;margin-left: 20px;">AVISO DE PRIVACIDAD RO & DI GLOBAL S DE RL DE CV HACE DE SU CONOCIMIENTO QUE LA INFORMACIÓN PROPORCIONADA POR USTED EN EL PRESENTE DOCUMENTO ES PROPIEDAD DE LA EMPRESA QUIEN CONTRATÓ ESTE SERVICIO Y NOS DESLINDAMOS DEL USO QUE SE LE DÉ A LA MISMA.</p><br>FOP-03 Rev. 00 <br>Fecha de Rev. 18/11/2021</div></div>');
        $mpdf->WriteHTML($html);

        $mpdf->Output('cadena_' . $doping->codigo_prueba . '_' . $doping->nombre . '_' . $doping->paterno . '.pdf', 'D'); // opens in browser
    }
    public function createMembretadoPDF()
    {
        $mpdf = new \Mpdf\Mpdf();
        date_default_timezone_set('America/Mexico_City');
        $data['hoy'] = date("d-m-Y");
        $hoy = date("d-m-Y");
        $id_doping = $_POST['idDopMembretado'];
        $doping = $this->doping_model->getDatosDoping($id_doping);
        if ($doping->foraneo == 'SI') {
            $data['area'] = $this->area_model->getArea('DOPING FORANEO');
        } else {
            $data['area'] = $this->area_model->getAreaById($doping->id_area);
        }
        //
        if ($doping->qr_token == null) {
            $this->load->library('ciqrcode');
            //QR de consulta
            $claveAleatoria = substr(md5(microtime()), 1, 16);
            $params['data'] = 'https://test-result.rodi.com.mx/doping/doping.php?uid=' . $claveAleatoria;
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = "./_qrconsult/qr_$id_doping.png";
            $this->ciqrcode->generate($params);
            $data['qr'] = "qr_$id_doping.png";
            $datos = array(
                'qr_token' => $claveAleatoria,
            );
            $this->doping_model->editarDoping($datos, $id_doping);
        } else {
            $data['qr'] = "qr_$id_doping.png";
        }

        $data['doping'] = $doping;
        $html = $this->load->view('pdfs/doping_membretado_pdf', $data, true);
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->WriteHTML($html);

        $mpdf->Output('doping_membretado_' . $doping->codigo_prueba . '_' . $doping->nombre . '_' . $doping->paterno . '.pdf', 'D'); // opens in browser
    }
    public function crearMembretadoPDFIngles()
    {
        $mpdf = new \Mpdf\Mpdf();
        date_default_timezone_set('America/Mexico_City');
        $data['hoy'] = date("d-m-Y");
        $hoy = date("d-m-Y");
        $id_doping = $_POST['idDopingMembretadoIngles'];
        $doping = $this->doping_model->getDatosDoping($id_doping);
        if ($doping->foraneo == 'SI') {
            $data['area'] = $this->area_model->getArea('DOPING FORANEO');
        } else {
            $data['area'] = $this->area_model->getAreaById($doping->id_area);
        }
        //
        if ($doping->qr_token == null) {
            $this->load->library('ciqrcode');
            //QR de consulta
            $claveAleatoria = substr(md5(microtime()), 1, 16);
            $params['data'] = 'https://test-result.rodi.com.mx/doping/doping.php?uid=' . $claveAleatoria;
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = "./_qrconsult/qr_$id_doping.png";
            $this->ciqrcode->generate($params);
            $data['qr'] = "qr_$id_doping.png";
            $datos = array(
                'qr_token' => $claveAleatoria,
            );
            $this->doping_model->editarDoping($datos, $id_doping);
        } else {
            $data['qr'] = "qr_$id_doping.png";
        }

        $data['doping'] = $doping;
        $html = $this->load->view('pdfs/doping_membretado_ingles_pdf', $data, true);
        $mpdf->setAutoTopMargin = 'stretch';
        $mpdf->WriteHTML($html);

        $mpdf->Output('doping_membretado_' . $doping->codigo_prueba . '_' . $doping->nombre . '_' . $doping->paterno . '.pdf', 'D'); // opens in browser
    }

    public function changeLaboratorio()
    {
        $this->form_validation->set_rules('lab', 'Laboratorio', 'required|trim');

        $this->form_validation->set_message('required', 'El campo %s es obligatorio');

        $msj = array();
        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            $dop = array(
                'laboratorio' => $this->input->post('lab'),
            );
            $this->doping_model->editarDoping($dop, $this->input->post('id_doping'));
            $msj = array(
                'codigo' => 1,
                'msg' => 'success',
            );
        }
        echo json_encode($msj);
    }
    /*function getDetalleDoping(){
    $idDoping = $this->input->post('idDoping');
    $salida = "";
    $dato = $this->doping_model->getDetalleDoping($idDoping);
    $salida .= '<table class="table table-striped" style="font-size: 13px">';
    $salida .= '<thead>';
    $salida .= '<tr  style="background: gray;color:white;">';
    $salida .= '<th scope="col">Candidato</th>';
    $salida .= '<th scope="col">Codigo</th>';
    $salida .= '<th scope="col">Fecha resultado</th>';
    $salida .= '<th scope="col">Acciones</th>';
    $salida .= '</tr>';
    $salida .= '</thead>';
    $salida .= '<tbody>';
    $fecha = fecha_sinhora_espanol_bd($dato->fecha_resultado);
    if($dato->resultado == 0){
    $color = '<i class="fas fa-circle status_bgc1"></i> ';
    }
    elseif ($dato->resultado == 1) {
    $color = '<i class="fas fa-circle status_bgc2"></i> ';
    }
    else{
    $color = '<i class="fas fa-circle status_bgc3"></i> ';
    }
    if($dato->id_cliente != 3 && $dato->id_cliente != 71){
    $salida .= "<tr><th>".$color.$dato->candidato."</th><th>".$dato->codigo_prueba."</th><th>".$fecha."</th><th><div style='margin-right:5px;'><form id='descform".$dato->id."' action='".base_url('Doping/createPDF')."' method='POST'><input type='hidden' name='idDop' id='idDop".$dato->id."' value='".$dato->id."'><button class='btn btn-primary btn-sm' type='submit'>Descargar Resultado</button></form></div> <div style='margin-right:5px;'><form id='inglesDoping".$dato->id."' action='".base_url('Doping/crearPDFIngles')."' method='POST'><input type='hidden' name='idDopingIngles' id='idDopingIngles".$dato->id."' value='".$dato->id."'><button class='btn btn-primary btn-sm' type='submit'>Descargar Resultado Ingles</button></form></div> <div style='margin-right:5px;'><form id='cadena".$dato->id."' action='".base_url('Doping/createCadenaPDF')."' method='POST'><input type='hidden' name='idCadena' id='idCadena".$dato->id."' value='".$dato->id."'><button class='btn btn-info btn-sm' type='submit'>Descargar cadena custodia</button></form></div> <div style='margin-right:5px;'><form id='descformmembretado".$dato->id."' action='".base_url('Doping/createMembretadoPDF')."' method='POST'><input type='hidden' name='idDopMembretado' id='idDopMembretado".$dato->id."' value='".$dato->id."'><button class='btn btn-info btn-sm' type='submit'>Descargar para membretado</button></form></div> <div style='margin-right:5px;'><form id='membretadoIngles".$dato->id."' action='".base_url('Doping/crearMembretadoPDFIngles')."' method='POST'><input type='hidden' name='idDopingMembretadoIngles' id='idDopingMembretadoIngles".$dato->id."' value='".$dato->id."'><button class='btn btn-info btn-sm' type='submit'>Descargar para membretado ingles</button></form></div> <button class='btn btn-danger btn-sm' onclick='eliminarDoping(".$dato->id.",".$dato->id_candidato.",\"".$dato->codigo_prueba."\")'>Eliminar</button><button class='btn btn-warning btn-sm' onclick='editarDoping(".$dato->id_candidato.",".$dato->id.",\"".$dato->nombre."\",\"".$dato->paterno."\",\"".$dato->materno."\",".$dato->antidoping.",".$dato->id_cliente.",".$dato->id_subcliente.",".$dato->id_proyecto.",\"".$dato->fecha_nacimiento."\",".$dato->id_tipo_identificacion.",\"".$dato->ine."\",".$dato->razon.",\"".$dato->medicamentos."\",\"".$dato->fecha_doping."\",\"".$dato->foto."\",\"".$dato->comentarios."\")'>Editar</button><button class='btn btn-primary btn-sm' onclick='resultadosDoping(".$dato->id.",\"".$dato->codigo_prueba."\",\"".$dato->candidato."\",\"".$dato->fecha_resultado."\",".$dato->id_candidato.")'>Ver Resultados</button></th></tr>";
    }
    if($dato->id_cliente == 3 || $dato->id_cliente == 71){
    $salida .= "<tr><th>".$color.$dato->candidato."</th><th>".$dato->codigo_prueba."</th><th>".$fecha."</th><th><div style='margin-right:5px;'><form id='descform".$dato->id."' action='".base_url('Doping/createPDF')."' method='POST'><input type='hidden' name='idDop' id='idDop".$dato->id."' value='".$dato->id."'><button class='btn btn-primary btn-sm' type='submit'>Descargar Resultado</button></form></div><div style='margin-right:5px;'><form id='otropdf".$dato->id."' action='".base_url('Doping/createPDF2')."' method='POST'><input type='hidden' name='idPDF2' id='idPDF2".$dato->id."' value='".$dato->id."'><button class='btn btn-primary btn-sm' type='submit'>Descargar Resultado Adulterantes</button></form></div><button class='btn btn-danger btn-sm' onclick='eliminarDoping(".$dato->id.",".$dato->id_candidato.",\"".$dato->codigo_prueba."\")'>Eliminar</button><button class='btn btn-warning btn-sm' onclick='editarDoping(".$dato->id_candidato.",".$dato->id.",\"".$dato->nombre."\",\"".$dato->paterno."\",\"".$dato->materno."\",".$dato->antidoping.",".$dato->id_cliente.",".$dato->id_subcliente.",".$dato->id_proyecto.",\"".$dato->fecha_nacimiento."\",".$dato->id_tipo_identificacion.",\"".$dato->ine."\",".$dato->razon.",\"".$dato->medicamentos."\",\"".$dato->fecha_doping."\",\"".$dato->foto."\",\"".$dato->comentarios."\")'>Editar</button><button class='btn btn-primary btn-sm' onclick='resultadosDoping(".$dato->id.",\"".$dato->codigo_prueba."\",\"".$dato->candidato."\",\"".$dato->fecha_resultado."\",".$dato->id_candidato.")'>Ver Resultados</button></th></tr>";
    }

    $salida .= '</tbody>';
    $salida .= '</table>';
    echo $salida;
    }*/

    /************************************************ Rules Validate Form ************************************************/

    //Regla para nombres con espacios
    public function alpha_space_only($str)
    {
        if (!preg_match("/^[a-zA-Z ]+$/", $str)) {
            $this->form_validation->set_message('alpha_space_only', 'El campo %s debe estar compuesto solo por letras y espacios y no debe estar vacío');
            return false;
        } else {
            return true;
        }
    }
    public function required_file()
    {
        $this->form_validation->set_message('required_file', 'Carga el archivo de factura');
        if (empty($_FILES['archivo']['name'])) {
            return false;
        } else {
            return true;
        }
    }

}
