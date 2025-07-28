<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cat_Portales extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('id')) {
            redirect('Login/index');
        }

        $this->load->library('usuario_sesion');

        $this->usuario_sesion->checkStatusBD();
        $this->load->helper('funciones_helper');
    }
    /*

    Esta  funcion sirve  para Insertar   o editar clientes  dentro de la misma,  al insertar  tambien crea

     */

    public function setPortal()
    {

        $idPortal = $this->input->post('idPortal');

        // Define la regla de validación con los parámetros como un arreglo
        $this->form_validation->set_rules('nombrePortal', 'Nombre del Portal', 'required');

        // Define las demás reglas de validación
        $this->form_validation->set_rules('correo', 'Correo', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Contraseña', 'trim|required');
        $this->form_validation->set_rules('paquete', 'Paquete', 'trim|required');
        $this->form_validation->set_rules('pais_name', 'País', 'trim');
        $this->form_validation->set_rules('state_name', 'Estado', 'trim');
        $this->form_validation->set_rules('ciudad_name', 'Ciudad', 'trim');
        $this->form_validation->set_rules('colonia', 'Colonia', 'trim');
        $this->form_validation->set_rules('calle', 'Calle', 'trim');
        $this->form_validation->set_rules('numero_exterior', 'Número Exterior', 'trim');
        $this->form_validation->set_rules('numero_interior', 'Número Interior', 'trim');
        $this->form_validation->set_rules('numero_cp', 'Codigo Postal', 'trim|max_length[5]');
        $this->form_validation->set_rules('razon_social', 'Razón Social', 'trim');
        $this->form_validation->set_rules('telefono', 'Teléfono', 'trim|max_length[10]');

        $this->form_validation->set_rules('nombre_contacto', 'Nombre de Contacto', 'trim');
        $this->form_validation->set_rules('apellido_contacto', 'Apellido de Contacto', 'trim');
        $this->form_validation->set_rules('rfc', 'RFC', 'trim');
        $this->form_validation->set_rules('regimen', 'Régimen', 'trim');
        $this->form_validation->set_rules('forma_pago', 'Forma de Pago', 'trim');
        $this->form_validation->set_rules('metodo_pago', 'Método de Pago', 'trim');
        $this->form_validation->set_rules('uso_cfdi', 'Uso de CFDI', 'trim');

        // Define los mensajes de error personalizados
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} caracteres.');
        $this->form_validation->set_message('check_nombre_unique', 'El campo Nombre del cliente ya existe en la base de datos.');

        // Validación de formulario
        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {

            $id_usuario = $this->session->userdata('id');
            date_default_timezone_set('America/Mexico_City');
            $date            = date('Y-m-d H:i:s');
            $uncode_password = $this->input->post('password');
            $password        = password_hash($uncode_password, PASSWORD_BCRYPT);

            $datos_generales = [
                'nombre'   => ($this->input->post('nombre_contacto') !== '') ? $this->input->post('nombre_contacto') : null,
                'paterno'  => ($this->input->post('apellido_contacto') !== '') ? $this->input->post('apellido_contacto') : null,
                'correo'   => ($this->input->post('correo') !== '') ? $this->input->post('correo') : null,
                'telefono' => ($this->input->post('telefono') !== '') ? $this->input->post('telefono') : null,
                'password' => $password,
            ];

            $datos_domicilios = [
                'pais'     => ($this->input->post('pais_name') !== '') ? $this->input->post('pais_name') : null,
                'estado'   => ($this->input->post('state_name') !== '') ? $this->input->post('state_name') : null,
                'ciudad'   => ($this->input->post('ciudad_name') !== '') ? $this->input->post('ciudad_name') : null,
                'colonia'  => ($this->input->post('colonia') !== '') ? $this->input->post('colonia') : null,
                'calle'    => ($this->input->post('calle') !== '') ? $this->input->post('calle') : null,
                'exterior' => ($this->input->post('numero_exterior') !== '') ? $this->input->post('numero_exterior') : null,
                'interior' => ($this->input->post('numero_interior') !== '') ? $this->input->post('numero_interior') : null,
                'cp'       => ($this->input->post('numero_cp') !== '') ? $this->input->post('numero_cp') : null,
            ];

            $datos_factura = [
                'razon_social' => ($this->input->post('razon_social') !== '') ? $this->input->post('razon_social') : null,
                'rfc'          => ($this->input->post('rfc') !== '') ? $this->input->post('rfc') : null,
                'regimen'      => ($this->input->post('regimen') !== '') ? $this->input->post('regimen') : null,
                'forma_pago'   => ($this->input->post('forma_pago') !== '') ? $this->input->post('forma_pago') : null,
                'metodo_pago'  => ($this->input->post('metodo_pago') !== '') ? $this->input->post('metodo_pago') : null,
                'uso_cfdi'     => ($this->input->post('uso_cfdi') !== '') ? $this->input->post('uso_cfdi') : null,
            ];

            $datos_portal = [
                'creacion'             => $date,
                'edicion'              => $date,
                'id_usuario'           => $id_usuario,
                'id_paquete'           => $this->input->post('paquete'),
                'nombre'               => strtoupper($this->input->post('nombrePortal')),
                'id_usuario_portal'    => null,
                'id_domicilios'        => null,
                'id_datos_facturacion' => null,
            ];

            $datos_cliente = [
                'creacion'             => $date,
                'edicion'              => $date,
                'id_usuario'           => null,
                'nombre'               => strtoupper($this->input->post('nombrePortal')) . '-Internal',
                'id_domicilios'        => null,
                'id_datos_facturacion' => null,
            ];

            /*
            echo '<pre>';
            print_r($datos_generales);
            print_r($datos_factura);
            print_r($datos_portal);
            print_r($datos_domicilios);
            echo '</pre>';
            die();
             */

            $existe = $this->cat_portales_model->existePortal($this->input->post('nombrePortal'));

            $idPortal    = ($this->input->post('idPortal') !== '') ? $this->input->post('idPortal') : null;
            $correo      = ($this->input->post('correo') !== '') ? $this->input->post('correo') : null;
            $idGenerales = ($this->input->post('idGenerales') !== '') ? $this->input->post('idGenerales') : null;

            if ($existe == 0) {

                $existeCorreo = $this->generales_model->correoExiste($correo);

                if ($existeCorreo !== 0) {
                    $msj = [
                        'codigo' => 2,
                        'msg'    => 'El correo proporcionado ya existe',
                    ];
                    echo json_encode($msj);
                    return; // Detener el flujo del código ya que hay un error
                }

                $idCliente = $this->cat_portales_model->addPortal($datos_portal, $datos_factura, $datos_domicilios, $datos_generales, $uncode_password, $datos_cliente);

                if ($idCliente > 0) {

                    $msj = [
                        'codigo' => 1,
                        'msg'    => 'Sucursal registrado exitosamente,  se  enviaron   las  credenciales a ' . $correo,
                    ];
                    echo json_encode($msj);
                    return;
                } else {
                    $msj = [
                        'codigo' => 0,
                        'msg'    => 'Error  al registrar al sucursal',
                    ];
                    echo json_encode($msj);
                    return;
                }

            } else {
                $msj = [
                    'codigo' => 2,
                    'msg'    => 'El nombre del Portal ya  existe, este  tiene  que  ser unico, prueba  con otro nombre por favor',
                ];
            }
        }
        echo json_encode($msj);
    }

    public function editPortal()
    {

        $idPortal = $this->input->post('idPortalE');

        // Define la regla de validación con los parámetros como un arreglo
        $this->form_validation->set_rules('nombrePortal_edit', 'Nombre del Portal', 'required');
        $this->form_validation->set_rules('idPortalE', 'Identificador  del Portal', 'required');
        $this->form_validation->set_rules('paquete_edit', 'Paquete no seleccionado', 'required');
        // Define las demás reglas de validación

        $this->form_validation->set_rules('pais_edit', 'País', 'trim');
        $this->form_validation->set_rules('estado_edit', 'Estado', 'trim');
        $this->form_validation->set_rules('ciudad_edit', 'Ciudad', 'trim');
        $this->form_validation->set_rules('colonia_edit', 'Colonia', 'trim');
        $this->form_validation->set_rules('calle_edit', 'Calle', 'trim');
        $this->form_validation->set_rules('numero_exterior_edit', 'Número Exterior', 'trim');
        $this->form_validation->set_rules('numero_interior_edit', 'Número Interior', 'trim');
        $this->form_validation->set_rules('numero_cp', 'Código Postal', 'trim|max_length[5]');
        $this->form_validation->set_rules('razon_social_edit', 'Razón Social', 'trim');
        $this->form_validation->set_rules('rfc_edit', 'RFC', 'trim');
        $this->form_validation->set_rules('regimen_edit', 'Régimen', 'trim');
        $this->form_validation->set_rules('forma_pago_edit', 'Forma de Pago', 'trim');
        $this->form_validation->set_rules('metodo_pago_edit', 'Método de Pago', 'trim');
        $this->form_validation->set_rules('uso_cfdi_edit', 'Uso de CFDI', 'trim');

        // Define los mensajes de error personalizados
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} caracteres.');
        $this->form_validation->set_message('check_nombre_unique', 'El campo Nombre del sucursal ya existe en la base de datos.');

        // Validación de formulario
        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {

            $id_usuario = $this->session->userdata('id');
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');

            $datos_domicilios = [
                'pais'     => $this->input->post('pais_edit'),
                'estado'   => $this->input->post('estado_edit'),
                'ciudad'   => $this->input->post('ciudad_edit'),
                'colonia'  => $this->input->post('colonia_edit'),
                'calle'    => $this->input->post('calle_edit'),
                'exterior' => $this->input->post('numero_exterior_edit'),
                'interior' => $this->input->post('numero_interior_edit'),
                'cp'       => $this->input->post('numero_cp_edit'),
            ];

            $datos_domicilios = array_filter($datos_domicilios, function ($value) {
                return $value !== '';
            });

            $datos_factura = [
                'razon_social' => $this->input->post('razon_social_edit'),
                'rfc'          => $this->input->post('rfc_edit'),
                'regimen'      => $this->input->post('regimen_edit'),
                'forma_pago'   => $this->input->post('forma_pago_edit'),
                'metodo_pago'  => $this->input->post('metodo_pago_edit'),
                'uso_cfdi'     => $this->input->post('uso_cfdi_edit'),
            ];

            // Filtrar el arreglo para eliminar valores vacíos y nulos
            $datos_factura = array_filter($datos_factura, function ($value) {
                return ! empty($value);
            });

            $datos_portal = [
                'edicion'              => $date,
                'id_usuario'           => $id_usuario,
                'id_paquete'           => $this->input->post('paquete_edit'),
                'nombre'               => strtoupper($this->input->post('nombrePortal_edit')),
                'id_usuario_portal'    => $this->input->post('idUsuarioPortalE'),
                'id_domicilios'        => $this->input->post('idDomiciliosE'),
                'id_datos_facturacion' => $this->input->post('idFacturacionE'),
                'usuarios_permitidos'  => $this->input->post('accesosEdit'),
            ];

            $datos_portal = array_filter($datos_portal, function ($value) {
                return ! empty($value);
            });

            /*
            echo'<pre>';
            print_r($datos_factura);
            print_r($datos_domicilios);
            print_r($datos_portal);
            echo'</pre>';
            die();
             */

            if ($idPortal > 0) {
                $hayId = $this->cat_portales_model->check($idPortal);

                if ($hayId > 0) {

                    $this->cat_portales_model->editPortal($idPortal, $datos_portal, $datos_factura, $datos_domicilios);

                    $msj = [
                        'codigo' => 1,
                        'msg'    => 'El portal ha sido actualizado exitosamente.',
                    ];
                    echo json_encode($msj);
                    return;
                } else {

                    $msj = [
                        'codigo' => 0,
                        'msg'    => 'Error  al actualizar  el Portal. ',
                    ];
                    echo json_encode($msj);
                    return;
                }

            } else {
                $msj = [
                    'codigo' => 2,
                    'msg'    => 'El nombre del Portal ya  existe, este  tiene  que  ser unico, prueba  con otro nombre por favor',
                ];
            }
        }
        echo json_encode($msj);
    }
    public function index()
    {

        $data['permisos']   = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        // $datos['estados'] = $this->funciones_model->getEstados();
        $datos['tipos_bloqueo']    = $this->funciones_model->getTiposBloqueo();
        $datos['tipos_desbloqueo'] = $this->funciones_model->getTiposDesbloqueo();
        $datos['modals']           = $this->load->view('modals/mdl_catalogos/mdl_portales', '', true);

        $config          = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);

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

        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('catalogos/portales', $datos)
            ->view('adminpanel/footer');
    }

    public function getPortales()
    {
        try {
            // Obtener el total de registros (recordsTotal)
            $recordsTotal = $this->cat_portales_model->getTotal();

            // Obtener el total de registros después de aplicar filtros (recordsFiltered)
            $recordsFiltered = $this->cat_portales_model->getTotal();

            // Obtener los datos de clientes (data)
            $data = $this->cat_portales_model->getP();

            // Configurar el tipo de contenido de la respuesta como JSON
            $this->output->set_content_type('application/json');

            // Construir la respuesta JSON
            $response = [
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $data,
            ];

            // Enviar la respuesta JSON
            $this->output->set_output(json_encode($response));
        } catch (Exception $e) {
            log_message('error', 'Excepción en la función getClientes: ' . $e->getMessage());

            // Configurar el tipo de contenido de la respuesta como JSON
            $this->output->set_content_type('application/json');

            // Enviar una respuesta JSON de error
            $this->output->set_output(json_encode(['error' => 'Error en la consulta.']));
        }
    }
    public function subirConstancia()
    {
        header('Content-Type: application/json');

        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath   = $_FILES['file']['tmp_name'];
            $fileName      = $_FILES['file']['name'];
            $fileSize      = $_FILES['file']['size'];
            $fileType      = $_FILES['file']['type'];
            $fileNameCmps  = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
            if (in_array($fileExtension, $allowedExtensions)) {
                $maxFileSize = 5 * 1024 * 1024; // 5MB
                if ($fileSize <= $maxFileSize) {
                    $randomFileName = bin2hex(random_bytes(7));
                    $idPortal       = isset($_POST['idPortal']) ? $_POST['idPortal'] : '';
                    $newFileName    = $idPortal . "_" . $randomFileName . "." . $fileExtension;

                    $uploadFileDir = './_portal_files/';
                    if (! is_dir($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    $dest_path = $uploadFileDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {

                        $portal = [
                            'cons' => $newFileName,
                        ];

                        $res = $this->cat_portales_model->editPortal($idPortal, $portal);

                        if ($res) {
                            echo json_encode(['codigo' => 1, 'mensaje' => 'Constancia cargada exitosamente.']);
                        } else {
                            unlink($dest_path);
                            echo json_encode(['codigo' => 0, 'mensaje' => 'No se pudo  subir  la  constancia  intenta  nuevamente.']);
                        }

                    } else {
                        echo json_encode(['codigo' => 0, 'mensaje' => 'No se pudo cargar el  archivo en el  directorio de destino.']);
                    }
                } else {
                    echo json_encode(['codigo' => 0, 'mensaje' => 'El tamaño del archivo excede el límite permitido.']);
                }
            } else {
                echo json_encode(['codigo' => 0, 'mensaje' => 'Tipo de archivo no permitido.']);
            }
        } else {
            echo json_encode(['codigo' => 0, 'mensaje' => 'No se ha subido ningún archivo.']);
        }
    }

    public function getClientesPorId()
    {
        $portal     = $this->session->userdata('idPortal');
        $cliente_id = $this->input->get('cliente_id');

        try {
            // Obtener los datos de clientes (data)
            $data = $this->cat_cliente_model->getC($cliente_id);

            // Configurar el tipo de contenido de la respuesta como JSON
            $this->output->set_content_type('application/json');

            // Verificar si se encontraron datos de clientes
            if (! empty($data)) {
                // Construir la respuesta JSON
                $response = [
                    'success' => true,
                    'data'    => $data,
                ];
            } else {
                // Construir la respuesta JSON si no se encontraron datos
                $response = [
                    'success' => false,
                    'message' => 'No se encontraron datos de clientes.',
                ];
            }

            // Enviar la respuesta JSON
            $this->output->set_output(json_encode($response));
        } catch (Exception $e) {
            log_message('error', 'Excepción en la función getClientes: ' . $e->getMessage());

            // Configurar el tipo de contenido de la respuesta como JSON
            $this->output->set_content_type('application/json');

            // Enviar una respuesta JSON de error
            $this->output->set_output(json_encode(['error' => 'Error en la consulta.']));
        }
    }

    public function editModulos()
    {

        $idPortal = $this->session->userdata('idPortal');

        // Define la regla de validación con los parámetros como un arreglo
        $this->form_validation->set_rules('accion', '', 'required');
        $this->form_validation->set_rules('id', '', 'required');

        // Define los mensajes de error personalizados
        $this->form_validation->set_message('required', 'Algo salio  mal  intenta   nuevcamente ');

        // Validación de formulario
        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $accion = $this->input->post('accion');
            $id     = $this->input->post('id');

            switch ($accion) {
                case 'DesactivarReclutamiento':
                    $campo = 'reclu';
                    $valor = 0;
                    break;

                // You can add more cases here
                case 'DesactivarPreEmpleo':
                    $campo = 'pre';
                    $valor = 0;
                    break;
                // You can add more cases here
                case 'DesactivarEmpleo':
                    $campo = 'emp';
                    $valor = 0;
                    break;
                // You can add more cases here
                case 'DesactivarExEmpleado':
                    $campo = 'former';
                    $valor = 0;
                    break;
                case 'DesactivarCom':
                    $campo = 'com';
                    $valor = 0;
                    break;
                // You can add more cases here
                case 'DesactivarCom360':
                    $campo = 'com360';
                    $valor = 0;
                    break;
                // You can add more cases here
                case 'ActivarReclutamiento':
                    $campo = 'reclu';
                    $valor = 1;
                    break;
                // You can add more cases here
                case 'ActivarPreEmpleo':
                    $campo = 'pre';
                    $valor = 1;
                    break;
                // You can add more cases here
                case 'ActivarEmpleo':
                    $campo = 'emp';
                    $valor = 1;
                    break;
                // You can add more cases here
                case 'ActivarExEmpleado':
                    $campo = 'former';
                    $valor = 1;
                    break;
                case 'ActivarCom':
                    $campo = 'com';
                    $valor = 1;
                    break;
                // You can add more cases here
                case 'ActivarCom360':
                    $campo = 'com360';
                    $valor = 1;
                    break;

            }

            $data = [
                $campo => $valor,
            ];

            // Lógica para activar/desactivar el módulo basado en la acción
            // Supón que se procesó correctamente

            $res = $this->cat_portales_model->editModulos($data, $id);

            if ($res == 1) {
                $msj = [
                    'codigo' => 1,
                    'msg'    => "Se Cambio el estatus del modulo Correctamente ",
                ];

            } else {
                $msj = [
                    'codigo' => 0,
                    'msg'    => "Error  al intetntar   cambiar  el  estatus  del modulo,  por favor  intentalo mas  tarde =(...",
                ];

            }

            // Responder con JSON
            echo json_encode(['mensaje' => $msj]);
        }

    }
// Funcion para registrar Clientes Julio  2024
    public function guardarDatos()
    {

        $this->form_validation->set_rules('razon_social', 'Razón Social', 'required');
        $this->form_validation->set_rules('telefono', 'Teléfono', 'required');
        $this->form_validation->set_rules('rfc', 'RFC', 'required');
        $this->form_validation->set_rules('regimen', 'Régimen', 'required');
        $this->form_validation->set_rules('forma_pago', 'Forma de Pago', 'required');
        $this->form_validation->set_rules('metodo_pago', 'Método de Pago', 'required');
        $this->form_validation->set_rules('uso_cfdi', 'Uso de CFDI', 'required');
        $this->form_validation->set_rules('pais_name', 'País', 'required');
        $this->form_validation->set_rules('state_name', 'Estado', 'required');
        $this->form_validation->set_rules('ciudad_name', 'Ciudad', 'required');
        $this->form_validation->set_rules('colonia', 'Colonia', 'required');
        $this->form_validation->set_rules('calle', 'Calle', 'required');
        $this->form_validation->set_rules('numero_exterior', 'Número Exterior', 'required');
        $this->form_validation->set_rules('numero_interior', 'Número Interior');
        $this->form_validation->set_rules('numero_cp', 'Código Postal', 'required');
        $this->form_validation->set_message('required', 'El campo %s es obligatorio');
        if ($this->form_validation->run() == false) {
            // Validación fallida

            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
            echo json_encode($msj);
            return;
        }
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        // Configuración de carga de archivo
        if (! empty($_FILES['archivo'])) {
            $error = 0;
            $rfc   = $this->input->post('rfc');
            /* echo '<pre>';
            print_r($_FILES['archivo']);
            echo '</pre>';
            die();*/
            // Define new $_FILES array - $_FILES['file']
            $_FILES['file']['name']     = $_FILES['archivo']['name'];
            $_FILES['file']['type']     = $_FILES['archivo']['type'];
            $_FILES['file']['tmp_name'] = $_FILES['archivo']['tmp_name'];
            $_FILES['file']['error']    = $_FILES['archivo']['error'];
            $_FILES['file']['size']     = $_FILES['archivo']['size'];
            // Set preference
            $config['upload_path']   = './_const/';
            $config['allowed_types'] = 'pdf|jpeg|jpg|png';
            $config['max_size']      = '2048'; // max_size in kb
            $cadena                  = substr(md5(time()), 0, 16);
            //$tipo = $this->candidato_model->getTipoDoc($tipo_documento);
            //$tipoArchivo = str_replace(' ','',$tipo->nombre);
            $extension           = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
            $config['file_name'] = $rfc . '_' . $cadena;
            $nombre_archivo      = $rfc . '_' . $cadena . '.' . $extension;
            //Load upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            // File upload
            if (! $this->upload->do_upload('file')) {
                $error++;

            } else {

                // Get the uploaded file path
                $uploaded_data      = $this->upload->data();
                $uploaded_file_path = $uploaded_data['full_path'];
                $idCliente          = $this->input->post('idCliente');

                $idGenerales    = $this->input->post('idGenerales');
                $nombre_cliente = $this->input->post('nombre');
                $clave_cliente  = $this->input->post('clave');

                $idDatosGenerales  = $this->input->post('idGenerales');
                $telefono          = $this->input->post('telefono');
                $nombre_contacto   = $this->input->post('nombre_contacto');
                $apellido_contacto = $this->input->post('apellido_contacto');

                $idFacturacion = $this->input->post('idFacturacion');
                $razon_social  = $this->input->post('razon_social');
                $rfc           = $this->input->post('rfc');
                $regimen       = $this->input->post('regimen');
                $forma_pago    = $this->input->post('forma_pago');
                $metodo_pago   = $this->input->post('metodo_pago');
                $uso_cfdi      = $this->input->post('uso_cfdi');

                $idDomicilios    = $this->input->post('idDomicilios');
                $pais            = $this->input->post('pais_name');
                $estado          = $this->input->post('state_name');
                $ciudad          = $this->input->post('ciudad_name');
                $colonia         = $this->input->post('colonia');
                $calle           = $this->input->post('calle');
                $numero_exterior = $this->input->post('numero_exterior');
                $numero_interior = $this->input->post('numero_interior');
                $cp              = $this->input->post('numero_cp');

                $dataClientes = [
                    'edicion'              => $date,
                    'constancia_cliente'   => $nombre_archivo,
                    'id_datos_facturacion' => $idFacturacion,
                    'id_domicilios'        => $idDomicilios,
                    'id_datos_generales'   => $idDatosGenerales,

                ];

                $dataFacturacion = [
                    'razon_social' => $razon_social,
                    'rfc'          => $rfc,
                    'regimen'      => $regimen,
                    'forma_pago'   => $forma_pago,
                    'metodo_pago'  => $metodo_pago,
                    'uso_cfdi'     => $uso_cfdi,

                ];

                $dataDomicilios = [
                    'pais'     => $pais,
                    'estado'   => $estado,
                    'ciudad'   => $ciudad,
                    'colonia'  => $colonia,
                    'calle'    => $calle,
                    'exterior' => $numero_exterior,
                    'interior' => $numero_interior,
                    'cp'       => $cp,

                ];

                $dataGenerales = [
                    'nombre'   => $nombre_contacto,
                    'paterno'  => $apellido_contacto,
                    'telefono' => $telefono,
                ];

                /* echo '<pre>';
                print_r($dataGenerales);
                echo '</pre>';
                die();*/

                $result = $this->cat_cliente_model->editCliente($idCliente, $dataClientes, $dataFacturacion, $dataDomicilios, $dataGenerales);

                if ($result) {
                    $msj = [
                        'codigo' => 1,
                        'msg'    => 'Los  Datos  y  el archivo  fueron almacenados  correctamente :)',
                    ];
                    echo json_encode($msj);
                    return;

                } else {

                    if ($uploaded_file_path && file_exists($uploaded_file_path)) {
                        unlink($uploaded_file_path);
                    }
                    $msj = [
                        'codigo' => 2,
                        'msg'    => 'Hubo un problema al actualizar los datos, por favor inténtalo nuevamente',
                    ];
                    echo json_encode($msj);
                    return;
                }

            }

            if ($error == 0) {
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'Success',
                ];

            } else {
                $msj = [
                    'codigo' => 0,
                    'msg'    => 'Error  al   cargar  el archivo  intentalo nuevamente  x.x ',
                ];
            }

        } else {
            $msj = [
                'codigo' => 0,
                'msg'    => 'Por  favor   sube  tu archivo en el apartado  correspondiente ',
            ];

        }

        // Datos del formulario

        echo json_encode($msj);
        return;
        // Guardar los datos en la base de datos

    }

    public function status()
    {
        $msj        = [];
        $id_usuario = $this->session->userdata('id');
        $date       = date('Y-m-d H:i:s');
        $idPortal   = $this->input->post('idPortal');
        $accion     = $this->input->post('accion');

        // var_dump("esta es la accion :  ".$accion."  Este es el id del cliente :  ".$idPortal);
        /* if ($accion == "desactivar") {
        $cliente = array(
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'status' => 0,
        );
        $this->cat_cliente_model->editCliente($idPortal, $cliente);
        $this->cat_cliente_model->editAccesoUsuarioCliente($idPortal, $cliente);
        $this->cat_cliente_model->editAccesoUsuarioSubcliente($idPortal, $cliente);
        $msj = array(
        'codigo' => 1,
        'msg' => 'Cliente inactivado correctamente',
        );
        }

        if ($accion == "activar") {
        $cliente = array(
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'status' => 1,
        );
        $this->cat_cliente_model->editCliente($idPortal, $cliente);
        $this->cat_cliente_model->editAccesoUsuarioCliente($idPortal, $cliente);
        $this->cat_cliente_model->editAccesoUsuarioSubcliente($idPortal, $cliente);

        $msj = array(
        'codigo' => 1,
        'msg' => 'Cliente activado correctamente',
        );
        }*/
        if ($accion == "eliminar") {

            $cliente = [
                'edicion'    => $date,
                'id_usuario' => $id_usuario,
                'eliminado'  => 1,
            ];
            /*
            // ver  que traen las variables
            echo "usuarioCliente: ";
            print_r($idPortal);
            echo "<br>";

            echo "usuarioClienteDatos: ";
            print_r($data);
            echo "<br>";
             */
            $this->cat_cliente_model->editCliente($idPortal, $cliente);
            $this->cat_cliente_model->editAccesoUsuarioCliente($idPortal, $cliente);
            $this->cat_cliente_model->editAccesoUsuarioSubcliente($idPortal, $cliente);
            $msj = [
                'codigo' => 1,
                'msg'    => 'Sucursal eliminado correctamente',
            ];
        }

        if ($accion == "bloquear") {
            $portal = [
                'edicion'    => $date,
                'id_usuario' => $id_usuario,
                'bloqueado'  => 1,
            ];
            $this->cat_portales_model->editPortal($idPortal, $portal);

            $data_bloqueo = [
                'creacion'            => $date,
                'id_usuario'          => $id_usuario,
                'descripcion'         => $this->input->post('opcion_descripcion'),
                'id_portal'           => $idPortal,
                'bloqueo_subclientes' => $this->input->post('bloquear_subclientes'),
                'tipo'                => 'BLOQUEO',
                'mensaje'             => $this->input->post('mensaje_comentario'),
            ];
            $this->cat_cliente_model->addHistorialBloqueos($data_bloqueo);
            $msj = [
                'codigo' => 1,
                'msg'    => 'Sucursal bloqueada correctamente',
            ];
        }

        if ($accion == "desbloquear") {
            $portal = [
                'edicion'    => $date,
                'id_usuario' => $id_usuario,
                'bloqueado'  => 0,
            ];
            $this->cat_portales_model->editPortal($idPortal, $portal);

        }

        $data_bloqueo = [
            'creacion'            => $date,
            'id_usuario'          => $id_usuario,
            'descripcion'         => $this->input->post('opcion_descripcion'),
            'id_portal'           => $idPortal,
            'bloqueo_subclientes' => 'NO',
            'tipo'                => 'DESBLOQUEO',
            'status'              => 0,
        ];
        $this->cat_cliente_model->addHistorialBloqueos($data_bloqueo);
        $msj = [
            'codigo' => 1,
            'msg'    => 'Sucursal desbloqueada correctamente',
        ];

        echo json_encode($msj);
    }

    public function getClientesActivos()
    {
        $res = $this->cat_cliente_model->getClientesActivosModel();
        if ($res) {
            echo json_encode($res);
        } else {
            echo $res = 0;
        }
    }

    public function getDatosClientesActivos()
    {
        // Obtener el ID del cliente enviado por la solicitud AJAX
        $cliente_id = $this->input->get('cliente_id');

        // Realizar la lógica para obtener los datos del cliente según su ID
        // Por ejemplo, puedes hacer una consulta a la base de datos
        // Aquí asumiremos que tienes un modelo llamado "Cliente_model" que maneja la lógica de la base de datos
        $this->load->model('Cliente_model');
        $clienteData = $this->Cliente_model->obtenerClientePorId($cliente_id);

        // Verificar si se encontraron datos del cliente
        if ($clienteData) {
            // Preparar los datos del cliente para enviarlos como respuesta
            $response = [
                'success' => true,
                'data'    => $clienteData,
            ];
        } else {
            // Si no se encontraron datos del cliente, enviar un mensaje de error
            $response = [
                'success' => false,
                'error'   => 'No se encontraron datos para el cliente seleccionado.',
            ];
        }

        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    }

    public function addUsuarioCliente()
    {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
        $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
        $this->form_validation->set_rules('cliente', 'Sucursal', 'required|trim');

        $this->form_validation->set_rules('correo_cliente_name', 'Correo', 'required|trim|valid_email|is_unique[datos_generales.correo]');
        $this->form_validation->set_rules('password_name', 'Contraseña', 'required|trim');

        $this->form_validation->set_message('required', 'El campo %s es obligatorio');
        $this->form_validation->set_message('is_unique', 'El %s ya esta registrado');
        $this->form_validation->set_message('valid_email', 'El campo %s debe ser un correo válido');
        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $id_usuario = $this->session->userdata('id');
            date_default_timezone_set('America/Mexico_City');
            $date            = date('Y-m-d H:i:s');
            $nombre          = $this->input->post('nombre');
            $paterno         = $this->input->post('paterno');
            $telefono        = ($this->input->post('telefono') !== null) ? $this->input->post('telefono') : null;
            $privacidad      = $this->input->post('privacidad');
            $correo          = $this->input->post('correo_cliente_name');
            $uncode_password = $this->input->post('password_name');
            $hashed_password = password_hash($uncode_password, PASSWORD_BCRYPT);

            $idPortal   = $this->input->post('cliente');
            $espectador = $this->input->post('tipo_usuario');

            $usuarioCliente = [
                'creacion'           => $date,
                'edicion'            => $date,
                'id_usuario'         => $id_usuario,
                'id_cliente'         => $idPortal,
                'id_datos_generales' => null,
                'espectador'         => $espectador,
                'privacidad'         => $privacidad,
            ];
            $usuarioClienteDatos = [

                'telefono' => $telefono,
                'nombre'   => $nombre,
                'paterno'  => $paterno,
                'correo'   => $correo,
                'password' => $hashed_password,

            ];

            $this->cat_cliente_model->addUsuarioClienteModel($usuarioCliente, $usuarioClienteDatos);

            $dataCliente = $this->cat_cliente_model->getById($idPortal);
            if ($dataCliente->ingles == 1) {
                $existe_cliente = $this->cat_cliente_model->checkPermisosByCliente($idPortal);
                if ($existe_cliente == 0) {
                    $url     = "Cliente_General/index/" . $idPortal;
                    $cliente = [
                        'url' => $url,
                    ];
                    $this->cat_cliente_model->editCliente($idPortal, $cliente);
                    $permiso = [
                        'id_usuario' => $id_usuario,
                        'cliente'    => $dataCliente->nombre,
                        'id_cliente' => $idPortal,
                    ];
                    $this->cat_cliente_model->addPermiso($permiso);
                }
            }
            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }

    public function getPortalesAccesos()
    {

        $idPortal = $this->input->post('idPortal');

        // var_dump("Este  es el id del cliente: ".$id_cliente."Este  es el id del portal: ".$idPortal);
        $res = $this->cat_portales_model->getAccesosPortalModal($idPortal);
        if ($res) {
            echo json_encode($res);
        } else {
            echo json_encode([]);
        }
    }

    public function controlAcceso()
    {
        $id_usuario = $this->session->userdata('id');
        date_default_timezone_set('America/Mexico_City');
        $date             = date('Y-m-d H:i:s');
        $idUsuarioCliente = $this->input->post('idUsuarioCliente');
        $accion           = $this->input->post('accion');

        if ($accion == 'eliminar') {
            $this->cat_cliente_model->deleteAccesoUsuarioCliente($idUsuarioCliente);
            $msj = [
                'codigo' => 1,
                'msg'    => 'Usuario eliminado correctamente',
            ];
        }
        if ($accion == 'credenciales') {
            $this->generales_model->editDatosGenerales();
            $msj = [
                'codigo' => 1,
                'msg'    => 'Usuario eliminado correctamente',
            ];
        }

        echo json_encode($msj);
    }

    public function obtener_meses_disponibles()
    {
        $id_portal = $this->input->post('id_portal');
        $meses     = $this->area_model->getMesesDisponibles($id_portal);

        echo json_encode($meses);
    }
    public function guardarPago()
    {
        // 1. Obtener los datos del POST
        $idUsuario   = $this->session->userdata('id');
        $id_portal   = $this->input->post('id_portal');
        $monto       = $this->input->post('monto');
        $fecha_pago  = $this->input->post('fecha_pago');
        $comentarios = $this->input->post('comentarios');
        $meses_json  = $this->input->post('meses');

        // 2. Validación básica
        if (! $id_portal || ! $monto || ! $fecha_pago || ! $meses_json) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => 'Faltan datos obligatorios.',
                ]));
        }

        // 3. Decodificar los meses
        $meses       = json_decode($meses_json, true);
        $montoPorMes = round($monto / count($meses), 2);
        if (empty($meses)) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status'  => 'error',
                    'message' => 'No se seleccionaron meses.',
                ]));
        }
        $numeros     = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $requeest_id = $numeros . '-int9845123-' . $idUsuario;
        // 4. Insertar un registro por cada mes
        foreach ($meses as $mes) {
            $data = [
                'id_portal'          => $id_portal,
                'payment_request_id' => $requeest_id,
                'mes'                => $mes,
                'monto'              => $montoPorMes,
                'estado'             => 'pagado',
                'fecha_pago'         => $fecha_pago,
                'comentarios_pago'   => $comentarios,
                'created_at'         => date('Y-m-d H:i:s'), // opcional
            ];

            $this->db->insert('pagos_mensuales', $data); // cambia 'pagos' por el nombre real de tu tabla
        }

        // 5. Respuesta de éxito
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => 'success',
                'message' => 'Pago(s) registrado(s) correctamente.',
            ]));
    }

}
