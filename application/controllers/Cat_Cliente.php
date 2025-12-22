<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cat_Cliente extends CI_Controller
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

        // ✅ Cargar idioma UNA SOLA VEZ para todo el controlador
        $langSes    = $this->session->userdata('lang') ?: 'es';
        $langFolder = ($langSes === 'en') ? 'english' : 'espanol';
        $this->lang->load('admin_clientes', $langFolder);

        // ✅ Mensajes globales de validación (ya traducibles)
        $this->form_validation->set_message('required', $this->lang->line('fv_required'));
        $this->form_validation->set_message('max_length', $this->lang->line('fv_max_length'));
        $this->form_validation->set_message('valid_email', $this->lang->line('fv_valid_email'));
        $this->form_validation->set_message('check_nombre_unique', $this->lang->line('fv_check_nombre_unique'));
    }

    private function t($key, $fallback = '', array $repl = [])
    {
        $txt = $this->lang->line($key);
        if ($txt === false || $txt === null || $txt === '') {
            $txt = $fallback !== '' ? $fallback : $key;
        }
        foreach ($repl as $k => $v) {
            $txt = str_replace('{' . $k . '}', $v, $txt);
        }
        return $txt;
    }

    // Helper: respuesta JSON estándar
    private function jsonOut(array $payload)
    {
        return $this->output
            ->set_content_type('application/json; charset=utf-8')
            ->set_output(json_encode($payload, JSON_UNESCAPED_UNICODE));
    }
    /*

    Esta  funcion sirve  para Insertar   o editar clientes  dentro de la misma,  al insertar  tambien crea

     */

    public function setCliente()
    {
        // ✅ Siempre JSON
        $this->output->set_content_type('application/json; charset=utf-8');

        $idCliente = $this->input->post('idCliente');

        // ✅ Labels traducibles (esto afecta {field} en validation_errors)
        $this->form_validation->set_rules('nombre', $this->t('fv_field_nombre', 'Nombre del cliente/sucursal'), 'required');
        $this->form_validation->set_rules('clave', $this->t('fv_field_clave', 'Clave'), 'trim|required|max_length[3]');
        $this->form_validation->set_rules('correo', $this->t('fv_field_correo', 'Correo'), 'trim|valid_email');
        $this->form_validation->set_rules('password', $this->t('fv_field_password', 'Contraseña'), 'trim');
        $this->form_validation->set_rules('empleados', $this->t('fv_field_empleados', 'Maximo empleados'), 'trim');

        $this->form_validation->set_rules('pais_name', $this->t('fv_field_pais', 'País'), 'trim');
        $this->form_validation->set_rules('state_name', $this->t('fv_field_estado', 'Estado'), 'trim');
        $this->form_validation->set_rules('ciudad_name', $this->t('fv_field_ciudad', 'Ciudad'), 'trim');
        $this->form_validation->set_rules('colonia', $this->t('fv_field_colonia', 'Colonia'), 'trim');
        $this->form_validation->set_rules('calle', $this->t('fv_field_calle', 'Calle'), 'trim');
        $this->form_validation->set_rules('numero_exterior', $this->t('fv_field_num_ext', 'Número Exterior'), 'trim');
        $this->form_validation->set_rules('numero_interior', $this->t('fv_field_num_int', 'Número Interior'), 'trim');
        $this->form_validation->set_rules('numero_cp', $this->t('fv_field_cp', 'Codigo Postal'), 'trim|max_length[5]');

        $this->form_validation->set_rules('razon_social', $this->t('fv_field_razon_social', 'Razón Social'), 'trim');
        $this->form_validation->set_rules('telefono', $this->t('fv_field_telefono', 'Teléfono'), 'trim');

        $this->form_validation->set_rules('nombre_contacto', $this->t('fv_field_nombre_contacto', 'Nombre de Contacto'), 'trim');
        $this->form_validation->set_rules('apellido_contacto', $this->t('fv_field_apellido_contacto', 'Apellido de Contacto'), 'trim');
        $this->form_validation->set_rules('rfc', $this->t('fv_field_rfc', 'RFC'), 'trim');
        $this->form_validation->set_rules('regimen', $this->t('fv_field_regimen', 'Régimen'), 'trim');
        $this->form_validation->set_rules('forma_pago', $this->t('fv_field_forma_pago', 'Forma de Pago'), 'trim');
        $this->form_validation->set_rules('metodo_pago', $this->t('fv_field_metodo_pago', 'Método de Pago'), 'trim');
        $this->form_validation->set_rules('uso_cfdi', $this->t('fv_field_uso_cfdi', 'Uso de CFDI'), 'trim');

        // ✅ OJO: YA NO seteamos mensajes aquí, porque ya los pones en constructor
        // $this->form_validation->set_message(...)

        // ✅ Validación
        if ($this->form_validation->run() == false) {
            return $this->jsonOut([
                'codigo' => 0,
                'msg'    => validation_errors(),
            ]);
        }

        $id_usuario = $this->session->userdata('id');
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');

        $uncode_password = $this->input->post('password');
        if (empty($uncode_password)) {
            $uncode_password = bin2hex(random_bytes(12));
        }
        $password = password_hash($uncode_password, PASSWORD_BCRYPT);

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

        $datos_cliente = [
            'creacion'             => $date,
            'edicion'              => $date,
            'id_usuario'           => $id_usuario,
            'id_portal'            => $this->session->userdata('idPortal'),
            'nombre'               => strtoupper($this->input->post('nombre')),
            'clave'                => $this->input->post('clave'),
            'max_colaboradores'    => $this->input->post('empleados'),
            'icono'                => '<i class="fas fa-user-tie"></i>',
            'id_datos_generales'   => null,
            'id_domicilios'        => null,
            'id_datos_facturacion' => null,
        ];

        $correo      = $this->input->post('correo');
        $idGenerales = $this->input->post('idGenerales');
        $idCliente   = $this->input->post('idCliente');

        $existe = $this->cat_cliente_model->existeCliente(
            $this->input->post('nombre'),
            $this->input->post('clave'),
            $idCliente
        );

        if ($existe != 0) {
            return $this->jsonOut([
                'codigo' => 2,
                'msg'    => $this->t('cli_name_or_key_exists', 'El nombre del sucursal y/o clave ya existe'),
            ]);
        }

        $hayId = $this->cat_cliente_model->check($idCliente);

        // ✅ EDITAR
        if ($hayId > 0) {

            $datos_cliente = [
                'edicion'              => $date,
                'id_usuario'           => $id_usuario,
                'nombre'               => strtoupper($this->input->post('nombre')),
                'clave'                => $this->input->post('clave'),
                'max_colaboradores'    => $this->input->post('empleados'),
                'id_datos_generales'   => $this->input->post('idGenerales'),
                'id_domicilios'        => $this->input->post('idDomicilios'),
                'id_datos_facturacion' => $this->input->post('idFacturacion'),
            ];

            $existeCorreo = $this->generales_model->correoExiste($correo, $idGenerales);
            if ($existeCorreo !== 0) {
                return $this->jsonOut([
                    'codigo' => 2,
                    'msg'    => $this->t('cli_email_exists', 'El correo proporcionado ya existe'),
                ]);
            }

            $this->cat_cliente_model->editCliente($idCliente, $datos_cliente, $datos_factura, $datos_domicilios, $datos_generales);

            return $this->jsonOut([
                'codigo' => 1,
                'msg'    => $this->t('cli_updated_ok', 'Cliente/Sucursal actualizada exitosamente'),
            ]);
        }

        // ✅ CREAR
        $existeCorreo = $this->generales_model->correoExiste($correo);
        if ($existeCorreo !== 0) {
            return $this->jsonOut([
                'codigo' => 2,
                'msg'    => $this->t('cli_email_exists', 'El correo proporcionado ya existe'),
            ]);
        }

        $idNuevo = $this->cat_cliente_model->addCliente($datos_cliente, $datos_factura, $datos_domicilios, $datos_generales, $uncode_password);

        if ($idNuevo > 0) {
            return $this->jsonOut([
                'codigo' => 1,
                'msg'    => $this->t('cli_created_ok_sent',
                    'Cliente/Sucursal registrado exitosamente, se enviaron las credenciales a {email}',
                    ['email' => (string) $correo]
                ),
            ]);
        }

        return $this->jsonOut([
            'codigo' => 0,
            'msg'    => $this->t('cli_create_error', 'Error  al registrar al cliente/sucursal'),
        ]);
    }

    public function index()
    {
        $data['tipo_bolsa'] = $this->session->userdata('tipo_bolsa');
        $data['permisos']   = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {$items[] = $row->id_submodulo;}
        $data['submenus'] = $items;

        $datos['tipos_bloqueo']    = $this->funciones_model->getTiposBloqueo();
        $datos['tipos_desbloqueo'] = $this->funciones_model->getTiposDesbloqueo();

        // ✅ 1) Cargar idioma primero

        // ✅ 2) Renderizar modal DESPUÉS (y pasando $datos si usa variables)
        $datos['modals'] = $this->load->view('modals/mdl_catalogos/mdl_cat_cliente', $datos, true);

        $config          = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);

        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('catalogos/cliente', $datos)
            ->view('adminpanel/footer');
    }

    public function getClientes()
    {
        $portal = $this->session->userdata('idPortal');

        try {
            // Obtener el total de registros (recordsTotal)
            $recordsTotal = $this->cat_cliente_model->getTotal($portal);

            // Obtener el total de registros después de aplicar filtros (recordsFiltered)
            $recordsFiltered = $this->cat_cliente_model->getTotal($portal);

            // Obtener los datos de clientes (data)
            $data = $this->cat_cliente_model->getC();

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
            //log_message('error', 'Excepción en la función getClientes: ' . $e->getMessage());

            // Configurar el tipo de contenido de la respuesta como JSON
            $this->output->set_content_type('application/json');

            // Enviar una respuesta JSON de error
            $this->output->set_output(json_encode(['error' => 'Error en la consulta.']));
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
                    'message' => 'No se encontraron datos de sucursales.',
                ];
            }

            // Enviar la respuesta JSON
            $this->output->set_output(json_encode($response));
        } catch (Exception $e) {
            //log_message('error', 'Excepción en la función getClientes: ' . $e->getMessage());

            // Configurar el tipo de contenido de la respuesta como JSON
            $this->output->set_content_type('application/json');

            // Enviar una respuesta JSON de error
            $this->output->set_output(json_encode(['error' => 'Error en la consulta.']));
        }
    }

// Funcion para registrar Clientes Julio  2024

    public function generarLinksTodos()
    {
        $this->output->set_content_type('application/json; charset=utf-8');

        // ✅ Cargar idioma aquí (si este endpoint se llama por AJAX, es mejor cargarlo aquí)
        $langSes    = $this->session->userdata('lang') ?: 'es';
        $langFolder = ($langSes === 'en') ? 'english' : 'espanol';
        $this->lang->load('admin_clientes', $langFolder);

        $id_portal = $this->session->userdata('idPortal');
        if (empty($id_portal)) {
            return $this->output->set_output(json_encode([
                'success' => false,
                'message' => $this->lang->line('suc_api_missing_id_portal'),
            ], JSON_UNESCAPED_UNICODE));
        }

        $clientes = $this->cat_cliente_model->traerClientes($id_portal);
        if (empty($clientes)) {
            return $this->output->set_output(json_encode([
                'success' => true,
                'ok'      => 0,
                'fail'    => 0,
                'items'   => [],
                'message' => $this->lang->line('suc_api_no_clients_to_process'),
            ], JSON_UNESCAPED_UNICODE));
        }

        $ok    = 0;
        $fail  = 0;
        $items = [];

        foreach ($clientes as $c) {
            $id_cliente = (int) ($c->id ?? 0);

            if ($id_cliente <= 0) {
                $fail++;
                $items[] = [
                    'id_cliente' => $id_cliente,
                    'success'    => false,
                    'error'      => $this->lang->line('suc_api_invalid_id_cliente'),
                ];
                continue;
            }

            // Tu función interna (debe devolver: ['success'=>bool, 'link'=>..., 'error'=>...]
            $res = $this->_generarLinkCliente($id_cliente, $id_portal);

            if (! empty($res['success'])) {
                $ok++;
            } else {
                $fail++;
                // Si tu _generarLinkCliente no manda error, ponemos uno genérico
                if (empty($res['error'])) {
                    $res['error'] = $this->lang->line('suc_api_link_generate_failed_item');
                }
            }

            $items[] = array_merge(['id_cliente' => $id_cliente], $res);
        }

        $message = $fail
            ? $this->lang->line('suc_api_process_done_with_errors')
            : $this->lang->line('suc_api_process_done_ok');

        return $this->output->set_output(json_encode([
            'success' => ($fail === 0),
            'ok'      => $ok,
            'fail'    => $fail,
            'items'   => $items,
            'message' => $message,
        ], JSON_UNESCAPED_UNICODE));
    }

    private function _generarLinkCliente(int $id_cliente, int $id_portal): array
    {
        try {
            // Datos de sesión
            $logo         = $this->session->userdata('logo') ?? 'portal_icon.png';
            $aviso        = $this->session->userdata('aviso') ?? 'AV_TL_V1.pdf';
            $NombrePortal = $this->session->userdata('nombrePortal');
            $usuario_id   = (int) $this->session->userdata('id');

            // Términos
            $terminosRow = $this->cat_cliente_model->getTerminos($id_portal);
            $terminos    = $terminosRow->terminos ?? 'TM_TL_V1.pdf';

            // Validaciones mínimas
            foreach (['id_cliente', 'id_portal', 'usuario_id', 'NombrePortal'] as $k) {
                if (empty($$k)) {
                    return ['success' => false, 'error' => "Falta {$k}"];
                }
            }

            // Clave privada (PEM)
            $private_key = $this->resolverClavePrivada();
            if (! $private_key) {
                return ['success' => false, 'error' => 'No se pudo cargar la clave privada JWT'];
            }

            // Payload (sin exp)
            $payload = [
                'iat'          => time(),
                'jti'          => bin2hex(random_bytes(16)),
                'idUsuario'    => $usuario_id,
                'idPortal'     => $id_portal,
                'NombrePortal' => $NombrePortal,
                'logo'         => $logo,
                'aviso'        => $aviso,
                'terminos'     => $terminos,
                'idCliente'    => $id_cliente,
            ];

            // JWT RS256
            $jwt = \Firebase\JWT\JWT::encode($payload, $private_key, 'RS256');

            // URL del formulario
            $formUrl = LINKNUEVAREQUISICION;
            if (! $formUrl) {
                return ['success' => false, 'error' => 'Falta LINKNUEVAREQUISICION'];
            }

            // Token URL-encoded
            $link = rtrim($formUrl, '/') . '?token=' . rawurlencode($jwt);

            // QR
            $qr_base64 = $this->_qr_base64($link);

            // Upsert
            $data = [
                'id_cliente' => $id_cliente,
                'link'       => $link,
                'qr'         => $qr_base64,
                'creacion'   => date('Y-m-d H:i:s'),
                'edicion'    => date('Y-m-d H:i:s'),
            ];
            $ok = $this->cat_cliente_model->guardarLinkCliente($data);

            if (! $ok) {
                return ['success' => false, 'error' => 'No se pudo guardar el link'];
            }

            return [
                'success' => true,
                'link'    => $link,
                'qr'      => $qr_base64,
                'jti'     => $payload['jti'],
                'sha'     => substr(hash('sha256', $jwt), 0, 16),
                // Opcional: no regreses el token completo por seguridad
            ];

        } catch (\Throwable $e) {
            log_message('error', '_generarLinkCliente error: ' . $e->getMessage() . ' line ' . $e->getLine());
            return ['success' => false, 'error' => 'Excepción interna: ' . $e->getMessage()];
        }
        //return ['success' => true, 'link' =>  ..., 'qr' =>  ..., 'jti' =>  ..., 'sha' =>  ...];
    }

    public function guardarDatos()
    {
        // ✅ Siempre responder JSON
        // (si ya usas jsonOut() no necesitas set_content_type aquí)

        // ✅ Reglas (labels traducibles para que {field} salga bien en validation_errors)
        $this->form_validation->set_rules('razon_social', $this->t('fv_field_razon_social', 'Razón Social'), 'required');
        $this->form_validation->set_rules('telefono', $this->t('fv_field_telefono', 'Teléfono'), 'required');
        $this->form_validation->set_rules('rfc', $this->t('fv_field_rfc', 'RFC'), 'required');
        $this->form_validation->set_rules('regimen', $this->t('fv_field_regimen', 'Régimen'), 'required');
        $this->form_validation->set_rules('forma_pago', $this->t('fv_field_forma_pago', 'Forma de Pago'), 'required');
        $this->form_validation->set_rules('metodo_pago', $this->t('fv_field_metodo_pago', 'Método de Pago'), 'required');
        $this->form_validation->set_rules('uso_cfdi', $this->t('fv_field_uso_cfdi', 'Uso de CFDI'), 'required');

        $this->form_validation->set_rules('pais_name', $this->t('fv_field_pais', 'País'), 'required');
        $this->form_validation->set_rules('state_name', $this->t('fv_field_estado', 'Estado'), 'required');
        $this->form_validation->set_rules('ciudad_name', $this->t('fv_field_ciudad', 'Ciudad'), 'required');
        $this->form_validation->set_rules('colonia', $this->t('fv_field_colonia', 'Colonia'), 'required');
        $this->form_validation->set_rules('calle', $this->t('fv_field_calle', 'Calle'), 'required');
        $this->form_validation->set_rules('numero_exterior', $this->t('fv_field_num_ext', 'Número Exterior'), 'required');
        $this->form_validation->set_rules('numero_interior', $this->t('fv_field_num_int', 'Número Interior'), 'trim');
        $this->form_validation->set_rules('numero_cp', $this->t('fv_field_cp', 'Código Postal'), 'required');

        // ✅ OJO: ya NO pongas set_message('required', 'El campo %s...') aquí,
        // porque eso rompe el multilenguaje. Déjalo en el constructor:
        // $this->form_validation->set_message('required', $this->lang->line('fv_required'));

        if ($this->form_validation->run() == false) {
            return $this->jsonOut([
                'codigo' => 0,
                'msg'    => validation_errors(),
            ]);
        }

        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');

        // ✅ Validar que venga archivo
        if (empty($_FILES['archivo']) || empty($_FILES['archivo']['name'])) {
            return $this->jsonOut([
                'codigo' => 0,
                'msg'    => $this->t('gd_file_required', 'Por favor sube tu archivo en el apartado correspondiente.'),
            ]);
        }

        // Preparar $_FILES['file']
        $rfc                        = (string) $this->input->post('rfc');
        $_FILES['file']['name']     = $_FILES['archivo']['name'];
        $_FILES['file']['type']     = $_FILES['archivo']['type'];
        $_FILES['file']['tmp_name'] = $_FILES['archivo']['tmp_name'];
        $_FILES['file']['error']    = $_FILES['archivo']['error'];
        $_FILES['file']['size']     = $_FILES['archivo']['size'];

        // Config upload
        $config['upload_path']   = './_const/';
        $config['allowed_types'] = 'pdf|jpeg|jpg|png';
        $config['max_size']      = '2048';

        $cadena              = substr(md5(time()), 0, 16);
        $extension           = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
        $config['file_name'] = $rfc . '_' . $cadena;
        $nombre_archivo      = $rfc . '_' . $cadena . '.' . $extension;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (! $this->upload->do_upload('file')) {
            // (Opcional) detalle técnico
            $detail = strip_tags($this->upload->display_errors('', ''));

            return $this->jsonOut([
                'codigo' => 0,
                'msg'    => $this->t('gd_upload_failed', 'Error al cargar el archivo, inténtalo nuevamente.') .
                ($detail ? ' ' . $detail : ''),
            ]);
        }

        $uploaded_data      = $this->upload->data();
        $uploaded_file_path = $uploaded_data['full_path'];

        // Datos
        $idCliente = $this->input->post('idCliente');

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

        $result = $this->cat_cliente_model->editCliente($idCliente, $dataClientes, $dataFacturacion, $dataDomicilios, $dataGenerales);

        if ($result) {
            return $this->jsonOut([
                'codigo' => 1,
                'msg'    => $this->t('gd_saved_ok', 'Los datos y el archivo fueron almacenados correctamente :)'),
            ]);
        }

        // Si falló, borrar archivo subido
        if ($uploaded_file_path && file_exists($uploaded_file_path)) {
            @unlink($uploaded_file_path);
        }

        return $this->jsonOut([
            'codigo' => 2,
            'msg'    => $this->t('gd_update_failed', 'Hubo un problema al actualizar los datos, por favor inténtalo nuevamente.'),
        ]);
    }

    public function status()
    {
        // ✅ siempre JSON
        // (si ya usas jsonOut, no necesitas set_content_type aquí)

        $id_usuario = $this->session->userdata('id');
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');

        $idCliente = (int) $this->input->post('idCliente');
        $accion    = (string) $this->input->post('accion');

        if ($idCliente <= 0 || $accion === '') {
            return $this->jsonOut([
                'codigo' => 0,
                'msg'    => $this->t('cli_status_invalid_request', 'Solicitud inválida.'),
            ]);
        }

        // Helper para no repetir
        $aplicarClienteYAccesos = function (array $cliente) use ($idCliente) {
            $this->cat_cliente_model->editCliente($idCliente, $cliente);
            $this->cat_cliente_model->editAccesoUsuarioCliente($idCliente, $cliente);
            $this->cat_cliente_model->editAccesoUsuarioSubcliente($idCliente, $cliente);
        };

        if ($accion === 'desactivar') {
            $cliente = [
                'edicion'    => $date,
                'id_usuario' => $id_usuario,
                'status'     => 0,
            ];
            $aplicarClienteYAccesos($cliente);

            return $this->jsonOut([
                'codigo' => 1,
                'msg'    => $this->t('cli_status_deactivated_ok', 'Sucursal inactivada correctamente'),
            ]);
        }

        if ($accion === 'activar') {
            $cliente = [
                'edicion'    => $date,
                'id_usuario' => $id_usuario,
                'status'     => 1,
            ];
            $aplicarClienteYAccesos($cliente);

            return $this->jsonOut([
                'codigo' => 1,
                'msg'    => $this->t('cli_status_activated_ok', 'Sucursal activada correctamente'),
            ]);
        }

        if ($accion === 'eliminar') {
            $cliente = [
                'edicion'    => $date,
                'id_usuario' => $id_usuario,
                'eliminado'  => 1,
            ];
            $aplicarClienteYAccesos($cliente);

            return $this->jsonOut([
                'codigo' => 1,
                'msg'    => $this->t('cli_status_deleted_ok', 'Sucursal eliminada correctamente'),
            ]);
        }

        if ($accion === 'bloquear') {

            $motivo = (string) $this->input->post('opcion_motivo');
            if ($motivo === '') {
                $motivo = 'NO';
            }

            $cliente = [
                'edicion'    => $date,
                'id_usuario' => $id_usuario,
                'bloqueado'  => $motivo,
            ];
            $this->cat_cliente_model->editCliente($idCliente, $cliente);

            // Bloquear subclientes si aplica
            if ($this->input->post('bloquear_subclientes') === 'SI') {
                $subclientes = $this->subcliente_model->getSubclientesByIdCliente($idCliente);
                if (! empty($subclientes)) {
                    foreach ($subclientes as $row) {
                        $subcliente = [
                            'edicion'    => $date,
                            'id_usuario' => $id_usuario,
                            'bloqueado'  => $motivo,
                        ];
                        // en tu código original mezclas modelos: cat_subclientes_model y métodos distintos
                        // dejo el que ya usabas aquí:
                        $this->cat_subclientes_model->editar($subcliente, $row->id);
                    }
                }
            }

            // Cerrar bloqueos previos
            $this->cat_cliente_model->editHistorialBloqueos(['status' => 0], $idCliente);

            // Guardar historial
            $data_bloqueo = [
                'creacion'            => $date,
                'id_usuario'          => $id_usuario,
                'descripcion'         => $this->input->post('opcion_descripcion'),
                'id_cliente'          => $idCliente,
                'bloqueo_subclientes' => $this->input->post('bloquear_subclientes'),
                'tipo'                => 'BLOQUEO',
                'mensaje'             => $this->input->post('mensaje_comentario'),
            ];
            $this->cat_cliente_model->addHistorialBloqueos($data_bloqueo);

            return $this->jsonOut([
                'codigo' => 1,
                'msg'    => $this->t('cli_status_blocked_ok', 'Sucursal bloqueada correctamente'),
            ]);
        }

        if ($accion === 'desbloquear') {

            $cliente = [
                'edicion'    => $date,
                'id_usuario' => $id_usuario,
                'bloqueado'  => 'NO',
            ];
            $this->cat_cliente_model->editCliente($idCliente, $cliente);

            // Desbloquear subclientes
            $subclientes = $this->subcliente_model->getSubclientesByIdCliente($idCliente);
            if (! empty($subclientes)) {
                foreach ($subclientes as $row) {
                    $subcliente = [
                        'edicion'    => $date,
                        'id_usuario' => $id_usuario,
                        'bloqueado'  => 'NO',
                    ];
                    // tu método original aquí era editarSubcliente
                    $this->cat_subclientes_model->editarSubcliente($row->id, $subcliente);
                }
            }

            // Cerrar bloqueos previos
            $this->cat_cliente_model->editHistorialBloqueos(['status' => 0], $idCliente);

            // Guardar historial desbloqueo
            $data_bloqueo = [
                'creacion'            => $date,
                'id_usuario'          => $id_usuario,
                'descripcion'         => $this->input->post('opcion_descripcion'),
                'id_cliente'          => $idCliente,
                'bloqueo_subclientes' => 'NO',
                'tipo'                => 'DESBLOQUEO',
                'status'              => 0,
            ];
            $this->cat_cliente_model->addHistorialBloqueos($data_bloqueo);

            return $this->jsonOut([
                'codigo' => 1,
                'msg'    => $this->t('cli_status_unblocked_ok', 'Sucursal desbloqueada correctamente'),
            ]);
        }

        // Si llega una acción no soportada
        return $this->jsonOut([
            'codigo' => 0,
            'msg'    => $this->t('cli_status_unknown_action', 'Acción no válida.'),
        ]);
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

            $idCliente  = $this->input->post('cliente');
            $espectador = $this->input->post('tipo_usuario');

            $usuarioCliente = [
                'creacion'           => $date,
                'edicion'            => $date,
                'id_usuario'         => $id_usuario,
                'id_cliente'         => $idCliente,
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

            $dataCliente = $this->cat_cliente_model->getById($idCliente);
            if ($dataCliente->ingles == 1) {
                $existe_cliente = $this->cat_cliente_model->checkPermisosByCliente($idCliente);
                if ($existe_cliente == 0) {
                    $url     = "Cliente_General/index/" . $idCliente;
                    $cliente = [
                        'url' => $url,
                    ];
                    $this->cat_cliente_model->editCliente($idCliente, $cliente);
                    $permiso = [
                        'id_usuario' => $id_usuario,
                        'cliente'    => $dataCliente->nombre,
                        'id_cliente' => $idCliente,
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
    public function generar_usuario_cliente()
    {
        // ✅ siempre JSON
        $this->output->set_content_type('application/json; charset=utf-8');

        $idCliente = (int) $this->input->post('idCliente');
        $correo    = trim((string) $this->input->post('correo'));
        $nombre    = trim((string) $this->input->post('nombre'));
        $paterno   = trim((string) $this->input->post('paterno'));
        $telefono  = trim((string) $this->input->post('telefono'));

        $password = (string) $this->input->post('password');
        $confirm  = (string) $this->input->post('password_confirm');

        // 1) Validaciones
        if ($idCliente <= 0) {
            return $this->jsonOut([
                'ok'  => false,
                'msg' => $this->t('guc_invalid_client', 'Cliente inválido.'),
            ]);
        }

        if ($nombre === '' || $paterno === '') {
            return $this->jsonOut([
                'ok'  => false,
                'msg' => $this->t('guc_name_last_required', 'Nombre y apellido son requeridos.'),
            ]);
        }

        // ✅ NUEVO: si no hay correo, mensaje explícito
        if ($correo === '') {
            return $this->jsonOut([
                'ok'  => false,
                'msg' => $this->t('guc_no_email_associated', 'No existe un correo asociado a este usuario.'),
            ]);
        }

        // Si hay, validar formato
        if (! filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return $this->jsonOut([
                'ok'  => false,
                'msg' => $this->t('guc_invalid_email', 'Correo inválido.'),
            ]);
        }

        // Password: mínimo 9, mayús, minús, número, símbolo
        $passValida =
        strlen($password) >= 9 &&
        preg_match('/[A-Z]/', $password) &&
        preg_match('/[a-z]/', $password) &&
        preg_match('/[0-9]/', $password) &&
        preg_match('/[^A-Za-z0-9]/', $password);

        if (! $passValida) {
            return $this->jsonOut([
                'ok'  => false,
                'msg' => $this->t('guc_pass_not_valid', 'La contraseña no cumple los requisitos.'),
            ]);
        }

        if ($password !== $confirm) {
            return $this->jsonOut([
                'ok'  => false,
                'msg' => $this->t('guc_pass_not_match', 'La confirmación de contraseña no coincide.'),
            ]);
        }

        // 2) Transacción
        $this->db->trans_begin();

        // 3) Correo NO repetible
        $dg = $this->cat_cliente_model->getByCorreo($correo);
        if ($dg) {
            $this->db->trans_rollback();
            return $this->jsonOut([
                'ok'  => false,
                'msg' => $this->t('guc_email_exists_use_other', 'Este correo ya está registrado. Usa otro.'),
            ]);
        }

        // 4) Crear usuario en datos_generales (bcrypt)
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $idDatos = (int) $this->cat_cliente_model->crear([
            'nombre'       => $nombre,
            'paterno'      => $paterno,
            'correo'       => $correo,
            'telefono'     => $telefono,
            'password'     => $hash,
            'verificacion' => 0,
        ]);

        if ($idDatos <= 0) {
            $err = $this->db->error();
            $this->db->trans_rollback();

            // Duplicado (por si chocan 2 admins al mismo tiempo)
            if (! empty($err['code']) && (int) $err['code'] === 1062) {
                return $this->jsonOut([
                    'ok'  => false,
                    'msg' => $this->t('guc_email_exists', 'Este correo ya está registrado.'),
                ]);
            }

            return $this->jsonOut([
                'ok'  => false,
                'msg' => $this->t('guc_cannot_create_user', 'No se pudo crear el usuario.'),
            ]);
        }

        // 5) Asociar en usuarios_clientes
        $rel = $this->cat_cliente_model->findRelacion($idCliente, $idDatos);

        if ($rel) {
            $this->cat_cliente_model->reactivar((int) $rel->id);
        } else {
            $now = date('Y-m-d H:i:s');
            $this->cat_cliente_model->insertar([
                'creacion'           => $now,
                'edicion'            => $now,
                'id_usuario'         => (int) $this->session->userdata('id'),
                'id_datos_generales' => $idDatos,
                'id_cliente'         => $idCliente,
                'espectador'         => 0,
                'logueado'           => 0,
                'nuevo_password'     => 1,
                'privacidad'         => 0,
                'status'             => 1,
                'eliminado'          => 0,
            ]);
        }

        // 6) Cierre transacción
        if ($this->db->trans_status() === false) {
            $err = $this->db->error();
            $this->db->trans_rollback();

            if (! empty($err['code']) && (int) $err['code'] === 1062) {
                return $this->jsonOut([
                    'ok'  => false,
                    'msg' => $this->t('guc_email_exists', 'Este correo ya está registrado.'),
                ]);
            }

            return $this->jsonOut([
                'ok'  => false,
                'msg' => $this->t('guc_cannot_generate_user', 'No se pudo generar el usuario.'),
            ]);
        }

        $this->db->trans_commit();

        return $this->jsonOut([
            'ok'                 => true,
            'msg'                => $this->t('guc_user_created_and_linked', 'Usuario generado correctamente.'),
            'id_datos_generales' => $idDatos,
            'id_cliente'         => $idCliente,
        ]);
    }

    public function getClientesAccesos()
    {

        $id_cliente = $this->input->post('id_cliente');
        $id_portal  = $this->generales_model->getPortalCliente($id_cliente);
        // var_dump("Este  es el id del cliente: ".$id_cliente."Este  es el id del portal: ".$id_portal);
        $res = $this->cat_cliente_model->getAccesosClienteModal($id_cliente, $id_portal);
        if ($res) {
            echo json_encode($res);
        } else {
            echo json_encode([]);
        }
    }

    public function controlAcceso()
    {
        // ✅ siempre JSON
        $this->output->set_content_type('application/json; charset=utf-8');

        $idUsuarioCliente = (int) $this->input->post('idUsuarioCliente');
        $accion           = (string) $this->input->post('accion');

        if ($idUsuarioCliente <= 0) {
            return $this->jsonOut([
                'codigo' => 0,
                'msg'    => $this->t('acc_invalid_user_client', 'ID de usuario/cliente inválido.'),
            ]);
        }

        if ($accion === 'eliminar') {
            $this->cat_cliente_model->deleteAccesoUsuarioCliente($idUsuarioCliente);

            return $this->jsonOut([
                'codigo' => 1,
                'msg'    => $this->t('acc_user_deleted_ok', 'Usuario eliminado correctamente'),
            ]);
        }

        if ($accion === 'credenciales') {
            // TODO: aquí deberías pasar params reales si tu función los requiere
            $this->generales_model->editDatosGenerales();

            return $this->jsonOut([
                'codigo' => 1,
                'msg'    => $this->t('acc_credentials_updated_ok', 'Credenciales actualizadas correctamente'),
            ]);
        }

        return $this->jsonOut([
            'codigo' => 0,
            'msg'    => $this->t('acc_invalid_action', 'Acción inválida.'),
        ]);
    }

    public function getLinks()
    {
        $this->output->set_content_type('application/json; charset=utf-8');

        $cliente_id = (int) $this->input->post('id_cliente', true); // TRUE => XSS clean

        if ($cliente_id <= 0) {
            return $this->jsonOut([
                'error' => $this->t('links_invalid_client_id', 'ID de cliente inválido'),
            ]);
        }

        try {
            $data = $this->cat_cliente_model->getLinksCliente($cliente_id);

            // Tu lógica actual: si no hay data, regresa [] (no error)
            return $this->output->set_output(json_encode($data ?: [], JSON_UNESCAPED_UNICODE));
        } catch (Throwable $e) {
            log_message('error', 'Excepción en getLinks: ' . $e->getMessage());

            // Mantengo tu comportamiento: responder [] para no romper front
            return $this->output->set_output(json_encode([], JSON_UNESCAPED_UNICODE));
        }
    }

    public function getLinkPortal()
    {
        $id_portal = $this->session->userdata('idPortal'); // TRUE => XSS clean

        if (! $id_portal) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'ID de portal inválido']));
        }

        try {
            $data = $this->cat_cliente_model->getLinkPortal($id_portal);

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data ?: []));
        } catch (Throwable $e) { // mejor que Exception para PHP 7+
            log_message('error', 'Excepción en getLinks: ' . $e->getMessage());
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([]));
        }
    }
    public function generarLinkRequisicion()
    {
        $this->output->set_content_type('application/json');

        $id_portal = $this->session->userdata('idPortal');

        $raw        = $this->input->post('id_cliente', true);
        $id_cliente = ($raw === null || $raw === '') ? null : (int) $raw;

        $terminosObj = $this->cat_cliente_model->getTerminos($id_portal);

        $logo         = $this->session->userdata('logo') ?? 'portal_icon.png';
        $aviso        = $this->session->userdata('aviso') ?? 'AV_TL_V1.pdf';
        $terminos     = $terminosObj->terminos ?? 'TM_TL_V1.pdf';
        $NombrePortal = $this->session->userdata('nombrePortal');
        $usuario_id   = $this->session->userdata('id');

        // Validaciones mínimas
        foreach (['id_portal', 'usuario_id', 'NombrePortal'] as $k) {
            if (empty($$k)) {
                return $this->jsonOut([
                    'error' => $this->t('suc_req_missing_field', 'Falta {field}.', ['field' => $k]),
                ]);
            }
        }

        // Clave privada (PEM)
        $private_key = $this->resolverClavePrivada();
        if (! $private_key) {
            return $this->jsonOut([
                'error' => $this->t('suc_req_private_key_error', 'No se pudo cargar la clave privada JWT'),
            ]);
        }

        $payload = [
            'iat'          => time(),
            'jti'          => bin2hex(random_bytes(16)),
            'idUsuario'    => $usuario_id,
            'idPortal'     => $id_portal,
            'NombrePortal' => $NombrePortal,
            'logo'         => $logo,
            'aviso'        => $aviso,
            'terminos'     => $terminos,
            'idCliente'    => $id_cliente,
        ];

        $jwt = \Firebase\JWT\JWT::encode($payload, $private_key, 'RS256');

        $formUrl = LINKNUEVAREQUISICION;
        if (! $formUrl) {
            return $this->jsonOut([
                'error' => $this->t('suc_req_missing_form_url', 'Falta LINKNUEVAREQUISICION'),
            ]);
        }

        $link      = rtrim($formUrl, '/') . '?token=' . rawurlencode($jwt);
        $qr_base64 = $this->_qr_base64($link);

        $data = [
            'link'     => $link,
            'qr'       => $qr_base64,
            'creacion' => date('Y-m-d H:i:s'),
            'edicion'  => date('Y-m-d H:i:s'),
        ];

        if ($id_cliente !== null) {$data['id_cliente'] = $id_cliente;} else { $data['id_portal'] = $id_portal;}

        $ok = $this->cat_cliente_model->guardarLinkCliente($data);
        if (! $ok) {
            return $this->jsonOut([
                'error' => $this->t('suc_req_save_link_error', 'No se pudo guardar el link'),
            ]);
        }

        return $this->jsonOut([
            'link'    => $link,
            'qr'      => $qr_base64,
            'jti'     => $payload['jti'],
            'idcli'   => $payload['idCliente'],
            'sha'     => substr(hash('sha256', $jwt), 0, 16),
            'mensaje' => $this->t('suc_req_link_ok', 'Link generado/actualizado correctamente.'),
        ]);
    }

/**
 * Carga la clave privada desde config (PEM inline, base64 o ruta).
 */
    private function resolverClavePrivada()
    {
        $conf     = $this->config->item('jwt_private_key');      // ya puede ser el PEM por file_get_contents
        $confPath = $this->config->item('jwt_private_key_path'); // opcional

        if ($conf && strpos($conf, '-----BEGIN') !== false) {
            return $conf;
        }

        if ($conf) {
            $decoded = base64_decode($conf, true);
            if ($decoded && strpos($decoded, '-----BEGIN') !== false) {
                return $decoded;
            }

            if (is_file($conf)) {
                $pem = @file_get_contents($conf);
                if ($pem && strpos($pem, '-----BEGIN') !== false) {
                    return $pem;
                }

            }
        }

        if ($confPath && is_file($confPath)) {
            $pem = @file_get_contents($confPath);
            if ($pem && strpos($pem, '-----BEGIN') !== false) {
                return $pem;
            }

        }

        return null;
    }

    private function _qr_base64($text)
    {
        $qrCode = new \Endroid\QrCode\QrCode($text);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);
        $writer = new \Endroid\QrCode\Writer\PngWriter();
        $png    = $writer->write($qrCode)->getString();
        return 'data:image/png;base64,' . base64_encode($png);
    }

    public function actualizarPass()
    {
        // ✅ siempre JSON
        $this->output->set_content_type('application/json; charset=utf-8');

        // Reglas
        $this->form_validation->set_rules('id', $this->t('ap_field_id', 'ID'), 'required');
        $this->form_validation->set_rules('correo', $this->t('ap_field_email', 'Correo'), 'required|valid_email');
        $this->form_validation->set_rules('pass', $this->t('ap_field_pass', 'Contraseña'), 'required');

        // Mensajes (si ya los pones global en constructor, esto es opcional)
        $this->form_validation->set_message('required', $this->t('fv_required_sprintf', 'El campo %s es obligatorio'));
        $this->form_validation->set_message('valid_email', $this->t('fv_valid_email_sprintf', 'El campo %s debe ser un correo válido'));

        if ($this->form_validation->run() == false) {
            return $this->jsonOut([
                'codigo' => 0,
                'msg'    => validation_errors(),
            ]);
        }

        date_default_timezone_set('America/Mexico_City');

        $id              = (int) $this->input->post('id');
        $correo          = trim((string) $this->input->post('correo'));
        $uncode_password = (string) $this->input->post('pass');

        // ✅ EXTRA: por si llega "null", espacios, etc.
        if ($correo === '' || strtolower($correo) === 'null') {
            return $this->jsonOut([
                'codigo' => 0,
                'msg'    => $this->t('ap_no_email_cannot_send', 'No existe un correo asociado. No se puede enviar la contraseña.'),
            ]);
        }

        $password = password_hash($uncode_password, PASSWORD_BCRYPT, ['cost' => 12]);

        $DatosGenerales = [
            'password' => $password,
        ];

        $result = $this->cat_usuario_model->updatePass($id, $DatosGenerales, $uncode_password, $correo);

        if ((int) $result > 0) {
            return $this->jsonOut([
                'codigo' => 1,
                'msg'    => $this->t('ap_pass_sent_to', 'La nueva contraseña fue enviada a {email}', [
                    'email' => $correo,
                ]),
            ]);
        }

        return $this->jsonOut([
            'codigo' => 0,
            'msg'    => $this->t(
                'ap_pass_update_fail_support',
                'No se pudo actualizar la contraseña. Póngase en contacto con soporte@talentsafecontrol.com'
            ),
        ]);
    }

}
