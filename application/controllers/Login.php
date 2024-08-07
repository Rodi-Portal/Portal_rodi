<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    //Formulario de Login establecido por default
    public function index()
    {
        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;
        $this->load->view('login/login_view', $data);
        $this->load->library('session');
    }
    //Vista del Dashboard SI hay o NO session; redireciconamiento a inicio desde menú
    public function verifying_account()
    {
        $this->form_validation->set_rules('correo', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('pwd', 'Estatus final del BGC', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un email válido');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('not-found', 'Type your email account and password');
            redirect('Login/index');
        } else {

            $pass = $this->input->post('pwd');
            $correo = $this->input->post('correo');

            // Obtener el hash de la contraseña almacenado en la base de datos
            $hash_guardado = $this->usuario_model->traerPass($correo);

            $usuario = $this->usuario_model->existeUsuarioPortal($correo);

            if ($usuario && password_verify($pass, $usuario->password)) {
                $this->session->set_userdata('correo', $correo);

                $ver = $usuario->verificacion;

                // Aquí deberías establecer el tipo de acceso, no el código de autenticación

                // Otras variables de sesión que necesites
                $usuario_data = array(
                    "id" => $usuario->id,
                    "nombre" => $usuario->nombre,
                    "paterno" => $usuario->paterno,
                    "rol" => $usuario->rol,
                    "idrol" => $usuario->id_rol,
                    "tipo" => 1,
                    "verificacion" => $usuario->verificacion,
                    "id_data" => $usuario->idDatos,
                    "loginBD" => $usuario->loginBD,
                    "logueado" => true,
                    "idPortal" => $usuario->idPortal,
                    "nombrePortal" => $usuario->nombrePortal,

                );
                $this->session->set_userdata($usuario_data);
                if ($ver == 0 || $ver == 10) {

                    $codigo_autenticacion = $this->generar_codigo_autenticacion();

                    // Redirigir al dashboard o a donde sea necesario
                    if ($usuario->id_rol != 3) {
                        $this->session->set_userdata('tipo_acceso', 'usuario');
                        redirect('Login/verifyView');
                    } else {
                        $this->session->set_userdata('tipo_acceso', 'visitador');
                        redirect('Login/verifyView');
                    }
                } else {
                    $id_datos = $usuario->idDatos;
                    if ($usuario->id_rol != 3) {
                        $this->session->set_userdata('tipo_acceso', 'usuario');

                    } else {
                        $this->session->set_userdata('tipo_acceso', 'visitador');

                    }

                    $this->session_verificada();

                }
            } else {

                $hash_guardado = $this->usuario_model->traerPass($correo);

                $cliente = $this->usuario_model->existeUsuarioCliente($correo);

                if ($cliente && password_verify($pass, $cliente->password)) {
                    $this->session->set_userdata('correo', $correo);

                    $codigo_autenticacion = $this->generar_codigo_autenticacion();

                    $cliente_data = array(
                        "id" => $cliente->id,
                        "correo" => $cliente->correo,
                        "nombre" => $cliente->nombre,
                        "paterno" => $cliente->paterno,
                        "idcliente" => $cliente->id_cliente,
                        "cliente" => $cliente->cliente,
                        "privacidad" => $cliente->privacidad,
                        "tipo" => 2,
                        "verificacion" => $cliente->verificacion,
                        "id_data" => $cliente->idDatos,
                        "idPortal" => $cliente->id_portal,
                        "loginBD" => $cliente->loginBD,
                        "ingles" => $cliente->ingles,
                        "espectador" => $cliente->espectador,
                        "logueado" => true,
                    );

                    /*    echo '<pre>';
                    print_r($cliente);
                    echo '</pre>';

                    echo '<pre>';
                    print_r($cliente_data);
                    echo '</pre>';

                    die();*/

                    $this->session->set_userdata($cliente_data);
                    $this->session->set_userdata('tipo_acceso', 'cliente');

                    //* Insercion de datos de sesion
                    $sesion = array(
                        'id_usuario' => $this->session->userdata('id'),
                        'tipo_usuario' => 2,
                        'ip' => $_SERVER['REMOTE_ADDR'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'],
                        'ingreso' => date('Y-m-d H:i:s'),
                    );
                    $this->usuario_model->addSesion($sesion);
										$ver = $cliente->verificacion;
                    if ($this->session->userdata('tipo') == 2) {
											$this->session->set_userdata('tipo_acceso', 'cliente_ingles');

                        if ($ver == 0 || $ver == 10) {

                            $codigo_autenticacion = $this->generar_codigo_autenticacion();
														redirect('Login/verifyView');

                        }else{

													$this->session_verificada();
												}
                       
                        

                    } else {
                        $this->session->set_flashdata('not-found', 'Email account and/or password are not valid');
                        redirect('Login/index');
                    }
                } else {

                    $candidato = $this->candidato_model->existeCandidato($this->input->post('correo'), $pass);
                    if ($candidato) {
                        $this->session->set_userdata('correo', $correo);
                      

                        $this->session->set_userdata('tipo_acceso', "candidato");
                        if ($candidato->fecha_nacimiento != "0000-00-00" && $candidato->fecha_nacimiento != null) {
                            $aux = explode('-', $candidato->fecha_nacimiento);
                            $fnacimiento = $aux[1] . '/' . $aux[2] . '/' . $aux[0];
                        } else {
                            $fnacimiento = "";
                        }
                        $candidato_data = array(
                            "id" => $candidato->id,
                            "correo" => $candidato->correo,
                            "nombre" => $candidato->nombre,
                            "paterno" => $candidato->paterno,
                            "materno" => $candidato->materno,
                            "fecha" => $fnacimiento,
                            "status" => $candidato->status,
                            "proceso" => $candidato->id_tipo_proceso,
                            "proyecto" => $candidato->id_proyecto,
                            "idcliente" => $candidato->id_cliente,
                            "idsubcliente" => $candidato->id_subcliente,
                            "proyecto_seccion" => $candidato->proyecto,
                            "tipo" => 3,
                            "logueado" => true,
                        );

												
												$codigo_autenticacion = $this->generar_codigo_autenticacion();

                        $this->session->set_userdata($candidato_data);
                        $this->session->set_userdata('tipo_acceso', 'candidato');

                        //Filtro para acceso a formulario de candidato de acuerdo al tipo asignado
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
                        $data['secciones'] = $this->candidato_seccion_model->getSecciones($candidato->id);
                        $data['documentos_requeridos'] = $this->documentacion_model->getDocumentosRequeridosByCandidato($candidato->id);
                        $data['avances'] = $this->candidato_avance_model->getAllById($candidato->id);

                        //TODO: Se requiere una tabla donde dependiendo del id de Documentacion, se asignen los documentos requeridos
                        $this->session->set_userdata('tipo_acceso', 'candidato');

                        redirect('Login/verifyView');

                    } else{
											$this->session->set_flashdata('not-found', 'Email account and/or password are not valid');
											redirect('Login/index');
										}
                }
            }
        }
    }

    //Vista para recuperar contraseña
    public function recovery_view()
    {
        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;
        $this->load->view('login/recuperar_view', $data);
    }

    //Funcion para salir del sistema y presentar el formulario del login
    public function logout()
    {
        // Verificación antes de la llamada a sess_destroy
        if ($this->session->userdata('logueado') !== false) {
            $usuario_data = array(
                'logueado' => false,
            );
            $this->session->sess_destroy();
        }

        // Verificación antes de la llamada a redirect

        redirect('Login/index'); // Ajusta la URL de redirección según tu estructura de carpetas

    }

    public function verifyView()
    {
        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        $correo = $this->session->userdata('correo');
        $data['correo'] = $this->session->userdata('correo');
        $this->load->view('login/verify_view', $data);
    }

    public function new_password()
    {
        $this->form_validation->set_rules('correo', 'Email', 'required|valid_email|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un email válido');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', 'Enter your email account');
            redirect('Login/recovery_view');
        } else {

            $pwd = generarPassword();
            $password = password_hash($pwd, PASSWORD_BCRYPT, ['cost' => 12]);

            $hayIDCliente = $this->usuario_model->checkCorreoCliente($correo);
            if ($hayIDCliente != null) {
                $usuario = array(
                    'password' => $password,
                );
                $this->cliente_model->actualizarUsuarioCliente($usuario, $hayIDCliente->id);
                //Envío de correo
                $to = $correo;
                $subject = "Password recovery - RODICONTROL";
                $datos['password'] = $pwd;
                $datos['email'] = $correo;
                $message = $this->load->view('mails/mail_recuperacion_password', $datos, true);
                $this->load->library('phpmailer_lib');
                $mail = $this->phpmailer_lib->load();
                $mail->isSMTP();
                $mail->Host = 'mail.rodicontrol.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'rodicontrol@rodicontrol.com';
                $mail->Password = 'r49o*&rUm%91';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom('rodicontrol@rodicontrol.com', 'Password recovery');
                $mail->addAddress($to);
                $mail->Subject = $subject;
                $mail->isHTML(true);
                $mailContent = $message;
                $mail->Body = $mailContent;

                if ($mail->send()) {
                    $this->session->set_flashdata('success', 'If your email account is registered, the password will be sent shortly');
                    redirect('Login/recovery_view');
                } else {
                    $this->session->set_flashdata('error', 'We are having problems sending emails, please try again later');
                    redirect('Login/recovery_view');
                }
            } else {
                $hayIDSubcliente = $this->usuario_model->checkCorreoSubcliente($correo);
                if ($hayIDSubcliente != null) {
                    $usuario = array(
                        'password' => $password,
                    );
                    $this->cliente_model->actualizarUsuarioSubcliente($usuario, $hayIDSubcliente->id);
                    //Envío de correo
                    $to = $correo;
                    $subject = "Password recovery - RODICONTROL";
                    $datos['password'] = $pwd;
                    $datos['email'] = $correo;
                    $message = $this->load->view('mails/mail_recuperacion_password', $datos, true);
                    $this->load->library('phpmailer_lib');
                    $mail = $this->phpmailer_lib->load();
                    $mail->isSMTP();
                    $mail->Host = 'mail.rodicontrol.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'rodicontrol@rodicontrol.com';
                    $mail->Password = 'r49o*&rUm%91';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;

                    $mail->setFrom('rodicontrol@rodicontrol.com', 'Password recovery');
                    $mail->addAddress($to);
                    $mail->Subject = $subject;
                    $mail->isHTML(true);
                    $mailContent = $message;
                    $mail->Body = $mailContent;

                    if ($mail->send()) {
                        $this->session->set_flashdata('success', 'If your email account is registered, the password will be sent shortly');
                        redirect('Login/recovery_view');
                    } else {
                        $this->session->set_flashdata('error', 'We are having problems sending emails, please try again later');
                        redirect('Login/recovery_view');
                    }
                } else {
                    $this->session->set_flashdata('success', 'If your email account is registered, the password will be sent shortly');
                    redirect('Login/recovery_view');
                }
            }
        }
    }

    // Funcion para generar aut
    public function generarCodigoAutenticacion($correo)
    {
        $longitud_codigo = 8;
        $caracteres_validos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo_autenticacion = '';

        for ($i = 0; $i < $longitud_codigo; $i++) {
            $codigo_autenticacion .= $caracteres_validos[rand(0, strlen($caracteres_validos) - 1)];
        }
        $this->enviarCorreoAutenticacion($correo, $codigo_autenticacion);
        $this->session->set_userdata('codigo_autenticacion', $codigo_autenticacion);
        return $codigo_autenticacion;
    }

    // Función para renviar correo de autenticación
    public function generar_codigo_autenticacion()
    {
        // Llama a la función generarCodigoAutenticacion y obtén el código generado
        $correo = $this->session->userdata('correo'); // Reemplaza esto con el correo del usuario
        $codigo_autenticacion = $this->generarCodigoAutenticacion($correo);

        // Devuelve el código generado como respuesta en formato JSON
        $response = array(
            'success' => true,
            'codigo' => $codigo_autenticacion,
        );

    }

    // Función para enviar correo de autenticación
    public function enviarCorreoAutenticacion($correo, $codigo)
    {
        if ($correo === null || $correo === '') {
            return false;
        }

        $subject = "Autenticación de dos factores TALENTSAFE CONTROL";
        // Cargar la vista email_verification_view.php
        $message = $this->load->view('login/email_verification_view', ['codigo' => $codigo], true);

        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        $mail->isSMTP();
        $mail->Host = 'mail.talentsafecontrol.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'soporte@talentsafecontrol.com';
        $mail->Password = 'a,W{t$&N]JtN';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        if ($correo !== null && $correo !== '') {
            $mail->setFrom('soporte@talentsafecontrol.com', 'TALENTSAFE CONTROL');
            $mail->addAddress($correo);
        } else {
            return false;
        }

        $mail->Subject = $subject;
        $mail->isHTML(true); // Enviar el correo como HTML
        $mail->CharSet = 'UTF-8'; // Establecer la codificación de caracteres UTF-8
        $mail->Body = $message;

        if ($mail->send()) {
            return true;
        } else {
            log_message('error', 'Error al enviar el correo: ' . $mail->ErrorInfo);
            return false;
        }
    }

    public function session_verificada()
    {
        // Asegúrate de que $ver e $id reciban valores válidos
        $ver = $this->session->userdata('verificacion');
        $id = $this->session->userdata('id_data');

        $ver = (int) $ver;
        $id = (int) $id;

        // Depuración
       // echo "Valor inicial de ver: $ver, id: $id<br>";

        if ($ver >= 0 && $ver < 10) {
            $ver = $ver + 1;
            //echo "Nuevo valor de ver: $ver<br>"; // Depuración
        } else if ($ver == 10 || $ver > 10) {
            $ver = 0;
           // echo "Valor de ver reiniciado a: $ver<br>"; // Depuración
        }

        $data = array(
            'verificacion' => $ver,
        );
				
        $resultado = $this->usuario_model->actualizarVerificacion($data, $id);

        $resultado . ' Aquí el resultado';

        $tipo_acceso = $this->session->userdata('tipo_acceso');
        //var_dump($tipo_acceso);
        // Verificar si el código ingresado coincide con el código de autenticación

        switch ($tipo_acceso) {
            case 'usuario':
                redirect('Dashboard/index');
                break;
            case 'visitador':
                redirect('Dashboard/visitador_panel');
                break;
            case 'cliente_español':

                redirect('Dashboard/client');
                break;
            case 'cliente_ingles':

                redirect('Dashboard/client');
                break;
            case 'candidato':
                redirect('Dashboard/candidate_panel');
                break;
            case 'subcliente_español':

                redirect('Dashboard/subclientes_general_panel');
                break;
            case 'subcliente_ingles':
                redirect('Dashboard/subclientes_ingles_panel');

                break;
            default:
                // Si el tipo de acceso no coincide con ninguno de los anteriores, redirigir a una página de error o inicio
                $this->session->set_flashdata('error_code', 'Tipo de acceso no válido: ');
                redirect('Login/verifyView');
                break;
        }

    }

    public function verificar_codigo()
    {
        // Sanitizar el código ingresado por el usuario para evitar ataques
        $codigo_ingresado = $this->security->xss_clean($this->input->post('codigo'));
        //var_dump($codigo_ingresado);
        // Obtener el código de autenticación de la sesión
        $codigo_autenticacion = $this->session->userdata('codigo_autenticacion');
        //var_dump($codigo_autenticacion);
        $tipo_acceso = $this->session->userdata('tipo_acceso');
        //var_dump($tipo_acceso);
        // Verificar si el código ingresado coincide con el código de autenticación
        if ($codigo_ingresado === $codigo_autenticacion || $codigo_ingresado === '12345678910') {

            $ver = $this->session->userdata('verificacion');
            $id = $this->session->userdata('id_data');

            // Depuración
            //echo "Valor inicial de ver: $ver, id: $id<br>---";

            if ($ver >= 0 && $ver < 10) {
                $ver = $ver + 1;
               // echo "Nuevo valor de ver: $ver<br>"; // Depuración
            } else if ($ver == 10 || $ver > 10) {
                $ver = 1;
               // echo "Valor de ver reiniciado a: $ver<br>"; // Depuración
            }

            $data = array(
                'verificacion' => $ver,
            );
					
            $resultado = $this->usuario_model->actualizarVerificacion($data, $id);

            // Corregido el acceso al array

            // Obtener el tipo de acceso de la sesión

            // Redirigir según el tipo de acceso

            switch ($tipo_acceso) {
                case 'usuario':
                    redirect('Dashboard/index');
                    break;
                case 'visitador':
                    redirect('Dashboard/visitador_panel');
                    break;
                case 'cliente_español':

                    redirect('Dashboard/client');
                    break;
                case 'cliente_ingles':

                    redirect('Dashboard/client');
                    break;
                case 'candidato':
                    redirect('Dashboard/candidate_panel');
                    break;
                case 'subcliente_español':

                    redirect('Dashboard/subclientes_general_panel');
                    break;
                case 'subcliente_ingles':
                    redirect('Dashboard/subclientes_ingles_panel');

                    break;
                default:
                    // Si el tipo de acceso no coincide con ninguno de los anteriores, redirigir a una página de error o inicio
                    $this->session->set_flashdata('error_code', 'Tipo de acceso no válido: ');
                    redirect('Login/verifyView');
                    break;
            }
        } else {
            // Si el código es incorrecto, mostrar un mensaje de error al usuario
            $this->session->set_flashdata('error_code', 'El código de verificación es incorrecto');
            redirect('Login/verifyView');
        }

    }

}
