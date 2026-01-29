<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cat_UsuarioInternos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('id')) {
            redirect('Login/index');
        }
        $this->load->library('usuario_sesion');
        $this->usuario_sesion->checkStatusBD();
        $this->load->library('encryption');

    }

    public function index()
    {
        // Obtener idioma de la sesión (ej: 'es' o 'en')
        $lang = $this->session->userdata('lang') ?? 'es';

        // Mapear a carpetas reales
        $map = [
            'es' => 'espanol',
            'en' => 'english',
        ];

        $ciLang = $map[$lang] ?? 'espanol';

        // Cargar el archivo de idioma
        $this->lang->load('admin_users', $ciLang);

        $aviso_actual = $this->session->userdata('aviso');

        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;

        $datos['modals'] = $this->load->view('modals/mdl_catalogos/mdl_registro_usuariointe', '', true);

        $config          = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

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

        // Pasar idioma a la vista
        $datos['lang'] = $lang;

        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('catalogos/usuarios_interno', $datos)
            ->view('adminpanel/footer');
    }

    public function getUsuarios()
    {
        $id_portal                           = $this->session->userdata('idPortal');
        $usuarios_interno['recordsTotal']    = $this->cat_usuario_model->getTotal($id_portal);
        $usuarios_interno['recordsFiltered'] = $this->cat_usuario_model->getTotal($id_portal);
        $usuarios_interno['data']            = $this->cat_usuario_model->getUsuarios($id_portal);
        $this->output->set_output(json_encode($usuarios_interno));
    }

    public function getSucursales()
    {
        $id_portal = $this->session->userdata('idPortal');

        $sucursalesActivas['data'] = $this->cat_usuario_model->getSucursales();
        $this->output->set_output(json_encode($sucursalesActivas));
    }

/************************************EDITAR USUARIO INTERNO*****************************************/
    public function editarUsuarioControlador()
    {
        $this->form_validation->set_rules('nombreaUsuarioInterno', 'Nombre', 'required|trim');
        $this->form_validation->set_rules('paternoUsuarioInterno', 'Paterno', 'required|trim');
        $this->form_validation->set_rules('correoUsuarioInterno', 'Correo', 'required|trim|valid_email');
        $this->form_validation->set_rules('telefonoaUsuarioInterno', 'telefono', 'required|is_unique[datos_generales.telefono]');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

        $id_usuario = $this->session->userdata('id');
        date_default_timezone_set('America/Mexico_City');
        $date     = date('Y-m-d H:i:s');
        $nombre   = $this->input->post('nombreUsuarioInterno');
        $paterno  = $this->input->post('paternoUsuarioInterno');
        $materno  = $this->input->post('maternoUsuarioInterno');
        $id_rol   = $this->input->post('id_rolUsuarioInterno');
        $correo   = $this->input->post('correoUsuarioInterno');
        $telefono = $this->input->post('telefonoUsuarioInterno');

        // $uncode_password = $this->input->post('password');
        // $base = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
        // $password = md5($base.$uncode_password);
        $idUsuario      = $this->input->post('idUsuarioInterno');
        $idDatos        = $this->input->post('idDatosGenerales');
        $existeTelefono = $this->generales_model->telefonoExiste($telefono, $idDatos);

        $usuariosInternos = [
            'edicion'    => $date,
            'id_usuario' => $id_usuario,
            'id_rol'     => $id_rol,
        ];
        //$this->session->set_userdata('idrol', $id_rol);
        $datosGenerales = [
            'nombre'   => $nombre,
            'paterno'  => $paterno,

            'correo'   => $correo,
            'telefono' => $telefono,
        ];

        $existe = $this->cat_usuario_model->check($idUsuario);

        if ($existe > 0) {

            // Correo actual en BD
            $correoActual = $this->cat_usuario_model->obtenerCorreoPorUsuario($idUsuario);

            // Solo validar si el correo cambió
            if ($correo !== $correoActual) {

                $existeCorreo = $this->cat_usuario_model->correoExiste($correo, $idUsuario);

                if ($existeCorreo > 0) {
                    $msj = [
                        'codigo' => 2,
                        'msg'    => 'El correo proporcionado ya existe',
                    ];
                    echo json_encode($msj);
                    return; // Detener el flujo del código ya que hay un error
                }
            }

            $result = $this->cat_usuario_model->editUsuario($idUsuario, $usuariosInternos, $idDatos, $datosGenerales);
            // echo "aqui el resultado : ".$result;
            if ($result) {
                $idUsuarioSession = $this->session->userdata('id');
                if ($idUsuarioSession == $idUsuario) {
                    $this->session->set_userdata('idrol', $id_rol);
                }

                $msj = [
                    'codigo' => 1,
                    'msg'    => 'success',
                ];
            } else {
                $msj = [
                    'codigo' => 0,
                    'msg'    => 'error',
                ];
            }

            echo json_encode($msj);

        } else {
            $msj = [
                'codigo' => 0,
                'msg'    => 'No se pudo encontrar el usuario para editar',
            ];
            echo json_encode($msj);
        }

    }

    //---------LIGADA A LA FUNCION DE registroUsuariosInternos DEL CATALOGO USUARIOS_INTERNOS
    public function addUsuarioInterno()
    {
        $this->form_validation->set_rules('nombreUsuarioInterno', 'nombre', 'required');
        $this->form_validation->set_rules('paternoUsuarioInterno', 'paterno', 'required');
        $this->form_validation->set_rules('maternoUsuarioInterno', 'materno');
        $this->form_validation->set_rules('id_rolUsuarioInterno', 'id_rol', 'required');
        $this->form_validation->set_rules('telefonoUsuarioInterno', 'telefono', 'required|is_unique[datos_generales.telefono]');

        $this->form_validation->set_rules('correoUsuarioInterno', 'Correo', 'required|valid_email|is_unique[datos_generales.correo]');
        $this->form_validation->set_rules('password1', 'Contraseña', 'required');

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
            $nombre          = $this->input->post('nombreUsuarioInterno');
            $paterno         = $this->input->post('paternoUsuarioInterno');
            $materno         = $this->input->post('maternoUsuarioInterno');
            $id_rol          = $this->input->post('id_rolUsuarioInterno');
            $correo          = $this->input->post('correoUsuarioInterno');
            $telefono        = $this->input->post('telefonoUsuarioInterno');
            $uncode_password = $this->input->post('password1');
            $password        = password_hash($uncode_password, PASSWORD_BCRYPT, ['cost' => 12]);
            $idUsuario       = $this->input->post('idUsuarioInterno');

            $UsuariosPortal = [
                'creacion'      => $date,
                'edicion'       => $date,
                'id_usuario'    => $id_usuario,
                'id_rol'        => $id_rol,
                'id_domicilios' => null,

            ];
            $DatosGenerales = [
                'nombre'   => $nombre,
                'paterno'  => $paterno,
                'correo'   => $correo,
                'password' => $password,
                'telefono' => $telefono,

            ];

            $result            = $this->cat_usuario_model->addUsuarioInterno($UsuariosPortal, $DatosGenerales);
            $envioCredenciales = $this->accesosUsuariosCorreo($correo, $uncode_password);

            if ($result) {
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'success',
                ];
            } else {
                $msj = [
                    'codigo' => 0,
                    'msg'    => 'error',
                ];
            }

        }
        echo json_encode($msj);
    }

    public function asignarSucursal()
    {
        // Cargar la librería de validación si no está cargada en autoload
        $this->load->library('form_validation');

        // Reglas de validación
        $this->form_validation->set_rules('usuarios[]', 'Usuarios', 'required', ['required' => 'Debe seleccionar al menos un usuario.']);
        $this->form_validation->set_rules('sucursales[]', 'Sucursales', 'required', ['required' => 'Debe seleccionar al menos una sucursal.']);

        // Array de respuesta
        $msj = [];

        // Validación de los datos
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            // Obtener los datos del POST
            $usuarios   = $this->input->post('usuarios');
            $sucursales = $this->input->post('sucursales');

            // Validar que los arrays no estén vacíos
            if (empty($usuarios) || empty($sucursales)) {
                $msj = [
                    'codigo' => 0,
                    'msg'    => 'Debe seleccionar al menos un usuario y una sucursal.',
                ];
            } else {

                $resultado = $this->cat_usuario_model->asignarSucursal($usuarios, $sucursales);

                if ($resultado) {
                    $msj = [
                        'codigo' => 1,
                        'msg'    => 'Asignación guardada con éxito.',
                    ];
                } else {
                    $msj = [
                        'codigo' => 0,
                        'msg'    => 'Error al guardar la asignación.',
                    ];
                }
            }
        }

        // Devolver respuesta en formato JSON
        echo json_encode($msj);
    }

    public function actualizarPass()
    {
        $this->form_validation->set_rules('id', 'id', 'required');
        $this->form_validation->set_rules('correo', 'Correo', 'required');
        $this->form_validation->set_rules('pass', 'Contraseña', 'required');

        $this->form_validation->set_message('required', 'El campo %s es obligatorio');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];

        } else {

            date_default_timezone_set('America/Mexico_City');

            $id              = $this->input->post('id');
            $correo          = $this->input->post('correo');
            $uncode_password = $this->input->post('pass');
            $password        = password_hash($uncode_password, PASSWORD_BCRYPT, ['cost' => 12]);

            // var_dump($uncode_password);

            $DatosGenerales = [
                'password' => $password,
            ];

            $result = $this->cat_usuario_model->updatePass($id, $DatosGenerales, $uncode_password, $correo);

            if ($result > 0) {
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'La nueva  contraseña  fue  enviada  a ' . $correo,
                ];
            } else {
                $msj = [
                    'codigo' => 0,
                    'msg'    => 'No se pudo actualizar   la contraseña  pongase en contacto  con  soporte@talentsafecontrol.com',
                ];
            }

        }
        echo json_encode($msj);
    }

    /*********************************************************************************/
    public function status()
    {
        $id_usuario  = $this->session->userdata('id');
        $date        = date('Y-m-d H:i:s');
        $idUsInterno = $this->input->post('id');
        $accion      = $this->input->post('accion');

        if ($accion == "activar") {
            $usuario = [
                'edicion'    => $date,
                'id_usuario' => $id_usuario,
                'status'     => 1, // Cambia el estado a activo
            ];
            $this->cat_usuario_model->editUsuario($idUsInterno, $usuario);

            $msj = [
                'codigo' => 1,
                'msg'    => 'Usuario activado correctamente',
            ];
        } elseif ($accion == "desactivar") {
            $usuario = [
                'edicion'    => $date,
                'id_usuario' => $id_usuario,
                'status'     => 0, // Cambia el estado a inactivo
            ];
            $this->cat_usuario_model->editUsuario($idUsInterno, $usuario);

            $msj = [
                'codigo' => 1,
                'msg'    => 'Usuario desactivado correctamente',
            ];
        } elseif ($accion == "eliminar") {
            $usuario = [
                'edicion'    => $date,
                'id_usuario' => $id_usuario,
                'eliminado'  => 1,
            ];

            $this->cat_usuario_model->editUsuario($idUsInterno, $usuario);

            $msj = [
                'codigo' => 1,
                'msg'    => 'Usuario eliminado correctamente',
            ];
        }

        echo json_encode($msj);
    }
//__________________________________________________________________________________
    public function getActivos()
    {
        $res = $this->cat_usuario_model->getActivos();
        if ($res) {
            echo json_encode($res);
        } else {
            echo $res = 0;
        }
    }

    public function accesosUsuariosCorreo($correo, $pass, $soloPass = 0)
    {
        if (empty($correo)) {
            return false;
        }

        // 🔐 Cargar config SMTP privada
        $this->config->load('email_private', true);
        $smtp = $this->config->item('email_private', 'email_private');

        if (empty($smtp)) {
            log_message('error', 'No se pudo cargar email_private.php');
            return false;
        }

        $subject = 'Credenciales TalentSafeControl';

        // 📧 Vista del correo
        $message = $this->load->view(
            'catalogos/email_credenciales_view',
            [
                'correo' => $correo,
                'pass'   => $pass,
                'switch' => $soloPass,
            ],
            true
        );

        // 📮 PHPMailer
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        $mail->isSMTP();
        $mail->Host       = $smtp['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp['user'];
        $mail->Password   = $smtp['pass'];
        $mail->SMTPSecure = 'ssl'; // compatible CI3
        $mail->Port       = (int) $smtp['port'];

        $mail->setFrom($smtp['from'], $smtp['fromName']);
        $mail->addAddress($correo);

        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Body    = $message;

        if (! $mail->send()) {
            log_message('error', 'Error al enviar correo SMTP: ' . $mail->ErrorInfo);
            return false;
        }

        return true;
    }

    public function verificarLimiteUsuarios()
    {
        $id_portal = $this->session->userdata('idPortal');

        $resultado = $this->cat_usuario_model->verificarLimiteUsuariosPortal($id_portal);

        echo json_encode($resultado);
    }

    public function eliminarPermiso()
    {
        // Obtener los parámetros de la solicitud POST
        $id_usuario = $this->input->post('id_usuario');
        $id_cliente = $this->input->post('id_cliente');

        // Validar que los parámetros estén presentes
        if (empty($id_usuario) || empty($id_cliente)) {
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
            return;
        }

        // Llamar al modelo para eliminar el permiso
        $resultado = $this->cat_usuario_model->eliminarPermiso($id_usuario, $id_cliente);

        // Responder con éxito o error
        if ($resultado) {
            echo json_encode(['status' => 'success', 'message' => 'Permiso eliminado exitosamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar el permiso']);
        }
    }

}
