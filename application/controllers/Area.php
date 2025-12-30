<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Area extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (! $this->session->userdata('id')) {
            redirect('Login/index');
        }

        $this->load->library('usuario_sesion');
        $this->usuario_sesion->checkStatusBD();

        // ===============================
        // 🌍 CARGA DE IDIOMA (OBLIGATORIO)
        // ===============================
        $lang      = $this->session->userdata('lang') ?: 'es';
        $idioma_ci = ($lang === 'en') ? 'english' : 'espanol';

        // Idiomas que usa esta vista
        $this->lang->load('portal_generales', $idioma_ci);
    }
    public function omitirAvisoPago()
    {
        if (! $this->input->is_ajax_request()) {
            show_404();
        }
        // Marcamos la variable que activa el modal como "pagado" para esta sesión
        $this->session->set_userdata('notPago', 'pagado_temporal');

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['ok' => true]));
    }
    public function pasarela()
    {
        $id_portal = (int) $this->session->userdata('idPortal');

        /* ===============================
     🧭 MENÚ / VERSIÓN
        =============================== */
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $items              = [];
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;

        $config          = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        /* ===============================
     🔒 ESTADO DEL SISTEMA (CLAVE)
        =============================== */
        $notPago = $this->session->userdata('notPago');

        $data['modo_sistema'] = in_array(
            $notPago,
            ['pagado', 'pendiente_en_plazo'],
            true
        ) ? 'normal' : 'bloqueado';

        /* ===============================
     💳 DATOS DE PAGO
        =============================== */
        $data['datos_pago']             = $this->area_model->getDatosPago($id_portal);
        $data['datos_pago_disponibles'] = false;

        // Defaults seguros
        $data['usuarios']          = [];
        $data['cantidad_usuarios'] = 0;
        $data['cobro']             = 0;
        $data['cobro_mes']         = 0;
        $data['fecha_vencimiento'] = null;
        $data['estado_pago']       = null;
        $data['link_pago']         = null;
        $data['historial_pagos']   = [];
        $data['meses_pagados']     = [];
        $data['meses_disponibles'] = [];

        if (! empty($data['datos_pago']) && ! empty($data['datos_pago']->creacion)) {

            $data['datos_pago_disponibles'] = true;

            $data['usuarios']          = $this->calcularCobro($data['datos_pago']->creacion, $id_portal);
            $data['cantidad_usuarios'] = count($data['usuarios']);

            $data['cobro'] = $this->calcularCobroMensualProporcional(
                $data['datos_pago']->creacion,
                $id_portal
            );
            $data['cobro_mes'] = $this->calcularCobroMensualFijo($id_portal);

            $vencimiento = $this->definirFechaVencimiento(
                $data['datos_pago']->creacion,
                $id_portal
            );
            $data['fecha_vencimiento'] = $vencimiento['fecha_vencimiento'];
            $data['estado_pago']       = $vencimiento['estado'];

            $data['link_pago']         = $this->area_model->getLinkPago($id_portal);
            $data['historial_pagos']   = $this->area_model->getPagos($id_portal);
            $data['meses_pagados']     = $this->area_model->getMesesPagados($id_portal);
            $data['meses_disponibles'] = $this->area_model->getMesesDisponibles($id_portal);

            /* 🌐 Multilenguaje del plan */
            if (! empty($data['datos_pago']->id_paquete)) {
                $data['plan_key']  = 'plan.' . $data['datos_pago']->id_paquete;
                $data['plan_vars'] = [
                    'users' => (int) ($data['datos_pago']->usuarios ?? 0),
                    'extra' => 50,
                    'price' => number_format((float) ($data['datos_pago']->precio ?? 0), 2),
                    'total' => number_format((float) ($data['cobro'] ?? 0), 2),
                ];
            }

            if ($data['link_pago']) {
                $activo                         = $this->verificarFechaExpiracion($data['link_pago']->expires_at);
                $data['status_link_pago_key']   = $activo ? 'portal_pay_status_active' : 'portal_pay_status_expired';
                $data['status_link_pago_class'] = $activo ? 'text-success' : 'text-danger';
            }
        }

        /* ===============================
     🧱 LAYOUT (SIEMPRE)
    =============================== */
        /* ===============================
 🧱 LAYOUT
=============================== */
        if ($data['modo_sistema'] === 'normal') {
            // Sistema activo → layout completo
            $this->load->view('adminpanel/header', $data);
            $this->load->view('adminpanel/pasarela', $data);
            $this->load->view('adminpanel/footer');
        } else {
            // Sistema bloqueado → solo pasarela
            $data['cargar_recursos'] = true;
            $this->load->view('adminpanel/pasarela', $data);
        }

    }

    public function calcularCobroMensualFijo($id_portal)
    {
        // Obtener datos base
        $datosCobro = $this->area_model->getDatosPago($id_portal);
        $precioBase = $datosCobro->precio; // precio mensual fijo

        // Obtener usuarios extras
        $usuariosExtras = $this->area_model->getUsuariosExtras($id_portal);

        // Calcular total de usuarios extras con cobro fijo
        $totalExtras = 0;
        foreach ($usuariosExtras as &$usuario) {
            $usuario->cobro = 50; // Cobro fijo por usuario extra
            $totalExtras += $usuario->cobro;
        }

        // Total final
        return $precioBase + $totalExtras;
    }

    public function calcularCobro($fechaCreacionStr, $id_portal)
    {

        $fechaCreacion  = new DateTime($fechaCreacionStr);
        $fechaActual    = new DateTime(); // Fecha actual
        $diaVencimiento = 5;

        // Fecha de vencimiento del mes actual
        $fechaVencimiento = new DateTime($fechaActual->format('Y-m-' . $diaVencimiento));
        $usuariosExtras   = $this->area_model->getUsuariosExtras($id_portal);
        // Verificar si hay usuarios extras
        if (empty($usuariosExtras)) {
            return []; // Si no hay usuarios extras, devolver un arreglo vacío
        }

        // Recorrer el listado de usuarios extras y calcular el cobro
        foreach ($usuariosExtras as &$usuario) {
            // Llamar a la función calcularCobro para cada usuario
            $usuario->cobro = $this->calcularCobro1($usuario->creacion);
        }

        // Si la fecha de creación es mayor al vencimiento del mes actual, ajustar al siguiente mes
        if ($fechaCreacion > $fechaVencimiento) {
            $fechaVencimiento->modify('+1 month');
        }

        // Verificar si se creó en el mismo mes y año
        if ($fechaCreacion->format('Y-m') === $fechaActual->format('Y-m')) {
            // Calcular días usados desde la creación hasta el vencimiento
            $diasUsados = $fechaCreacion->diff($fechaVencimiento)->days;
            return $usuariosExtras;
        } else {
            // Cobrar el mes completo
            return $usuariosExtras;
        }
    }

    public function calcularCobro1($fecha_creacion)
    {
        // Obtener la fecha actual
        $fecha_actual = new DateTime();

        // Verificar si la fecha de creación está entre el 1 y el 5 del mes actual
        $fecha_creacion = new DateTime($fecha_creacion);
        if ($fecha_creacion->format('d') >= 1 && $fecha_creacion->format('d') <= 5) {
            // Si está entre el 1 y el 5 del mes, cobrar como si fuera el 5 del mes
            $fecha_creacion->setDate($fecha_creacion->format('Y'), $fecha_creacion->format('m'), 5);
        }

        // Verificar si la fecha de creación tiene más de un mes
        $interval = $fecha_actual->diff($fecha_creacion);

        // Si la diferencia de meses es mayor o igual a 1, cobrar 50 USD
        if ($interval->m >= 1) {
            return 50; // Cobro fijo de 50 USD si tiene más de un mes
        }

        // Si tiene menos de un mes, calcular el monto proporcional
        // Obtener el próximo 5 del mes
        $proximo_5 = new DateTime('first day of next month');
        $proximo_5->setDate($proximo_5->format('Y'), $proximo_5->format('m'), 5);

        // Calcular los días restantes hasta el próximo 5
        $dias_restantes = $fecha_actual->diff($proximo_5)->days;

                                                    // Calcular el porcentaje de los días restantes respecto al mes
        $dias_del_mes = $fecha_actual->format('t'); // Total de días en el mes actual
        $porcentaje   = $dias_restantes / $dias_del_mes;

        // Cobro proporcional
        $cobro = 50 * $porcentaje;

        return round($cobro, 2); // Devolver el cobro proporcional redondeado a dos decimales
    }

    public function calcularCobroMensualProporcional($fechaCreacionStr, $id_portal)
    {
        $fechaCreacion = new DateTime($fechaCreacionStr);
        $fechaActual   = new DateTime();
        $diaCorte      = 1; // día de corte mensual
        $fechaCorte    = new DateTime($fechaActual->format('Y-m-' . $diaCorte));

        // Si la creación fue después del corte actual, el corte será el próximo mes
        if ($fechaCreacion > $fechaCorte) {
            $fechaCorte->modify('+1 month');
        }

        // Obtener precio base
        $datosCobro = $this->area_model->getDatosPago($id_portal);
        $precioBase = $datosCobro->precio;

        // Calcular días usados y porcentaje
        if ($fechaCreacion->format('Y-m') === $fechaActual->format('Y-m')) {
            $diasUsados         = $fechaCreacion->diff($fechaCorte)->days;
            $diasMes            = $fechaActual->format('t'); // total de días del mes
            $precioProporcional = $precioBase * ($diasUsados / $diasMes);
        } else {
            $precioProporcional = $precioBase;
        }

        // Calcular usuarios extras proporcionalmente
        $usuariosExtras = $this->area_model->getUsuariosExtras($id_portal);
        $totalExtras    = 0;
        foreach ($usuariosExtras as &$usuario) {
            $usuario->cobro = $this->calcularCobro1($usuario->creacion);
            $totalExtras += $usuario->cobro;
        }

        // Total final proporcional
        return $precioProporcional + $totalExtras;
    }

    public function definirFechaVencimiento($fechaCreacionStr, $id_portal)
    {
        $fechaCreacion = new DateTime($fechaCreacionStr);
        $fechaActual   = new DateTime(); // hoy
        $diaCorte      = 5;
        $primerDiaMes  = new DateTime($fechaActual->format('Y-m-01'));

        // ✅ 1. Buscar si ya existe un pago registrado para este mes en la tabla pagos_mensualidad
        $pagoMes = $this->avance_model->buscarPagoMensualidad(
            $id_portal,
            $primerDiaMes->format('Y-m-d')
        );

        if ($pagoMes) {
            // Tenemos un registro para este mes, revisamos su estado
            if ($pagoMes->estado === 'pagado') {
                // ✅ Ya pagado: próxima fecha será el 1 del próximo mes
                $fechaVencimiento = new DateTime('first day of next month');
                return [
                    'fecha_vencimiento' => $fechaVencimiento->format('Y-m-d'),
                    'estado'            => 'pagado',
                ];
            } elseif ($pagoMes->estado === 'pendiente') {
                // ✅ Hay registro pero está pendiente
                return [
                    'fecha_vencimiento' => $primerDiaMes->format('Y-m-d'),
                    'estado'            => 'pendiente',
                ];
            } elseif ($pagoMes->estado === 'expirado') {
                // ✅ Hay registro pero está expirado
                return [
                    'fecha_vencimiento' => $primerDiaMes->format('Y-m-d'),
                    'estado'            => 'expirado',
                ];
            }
        }

        // ✅ 2. Si no hay registro para este mes, usamos la lógica de creación/corte
        if ((int) $fechaActual->format('d') >= 1 && (int) $fechaActual->format('d') <= $diaCorte) {
            // Entre el 1 y el 5 del mes
            if ($fechaCreacion->diff($fechaActual)->m >= 1) {
                $fechaVencimiento = $primerDiaMes;
                $estado           = 'pendiente';
            } else {
                $fechaVencimiento = $primerDiaMes;
                $estado           = 'pendiente';
            }
        } else {
            // Después del 5, si no había registro en la tabla
            $fechaVencimiento = $primerDiaMes;
            $estado           = 'pendiente'; // aquí puedes manejar también 'vencido' según tu lógica
        }

        return [
            'fecha_vencimiento' => $fechaVencimiento->format('Y-m-d'),
            'estado'            => $estado,
        ];
    }

    public function verificarFechaExpiracion($expires_at)
    {
        // Establecer la zona horaria de Guadalajara, México
        date_default_timezone_set('America/Mexico_City');

                                        // Obtener la fecha y hora actual en Guadalajara
        $fecha_actual = new DateTime(); // La fecha actual se obtiene en la zona horaria ya configurada

        // Convertir la fecha de expiración a un objeto DateTime
        $fecha_expiracion = new DateTime($expires_at);

        // Comparar las fechas
        if ($fecha_actual > $fecha_expiracion) {
            // El link de pago ha expirado
            return 0;
        } else {
            // El link de pago sigue vigente
            return 1;
        }
    }

    public function updateLogo()
    {
        // Establecer la zona horaria
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');

        // Obtener datos de la sesión
        $idPortal       = $this->session->userdata('idPortal');
        $portal         = $this->session->userdata('nombrePortal');
        $portal         = explode(' ', $portal)[0];
        $archivo        = $idPortal . '_' . $portal;
        $nombre_archivo = trim($archivo);
                                                             // Configuración para la carga de archivo
        $config['upload_path']   = FCPATH . '_logosPortal/'; // Ruta completa
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';       // Tipos de archivo permitidos
        $config['overwrite']     = true;                     // Sobrescribir archivo si existe
        $config['file_name']     = $nombre_archivo;          // Nombre de archivo único basado en el idPortal y nombre del portal

        // Cargar la librería de carga
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        // Verificar si se sube un archivo
        if ($_FILES['fileLogo']['name']) {
            // Intentar cargar el archivo
            if ($this->upload->do_upload('fileLogo')) {
                // Obtener los datos del archivo cargado
                $data = $this->upload->data();

                                                     // Obtener la extensión del archivo
                $file_extension = $data['file_ext']; // Ejemplo: .jpg, .png, .pdf

                // Preparar los datos para la actualización
                $doc = [
                    'edicion' => $date,
                    'logo'    => $nombre_archivo . $file_extension, // El logo con su extensión
                ];

                // Llamar al modelo para actualizar el logo
                $this->area_model->subirLogo($idPortal, $doc);
                $this->session->set_userdata('logo', $nombre_archivo . $file_extension);
                // Responder con éxito
                echo json_encode(['success' => true,
                    'message'                   => 'Logo actualizado correctamente']);
            } else {
                // Si ocurre un error con la carga, mostrar el error
                echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
            }
        } else {
            // Si no se subió ningún archivo
            echo json_encode(['success' => false, 'message' => 'No se ha seleccionado un archivo']);
        }
    }
    public function eliminarLogo()
    {
        // Establecer la zona horaria
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');

        // Obtener datos de la sesión
        $idPortal = $this->session->userdata('idPortal');
        $logo     = $this->session->userdata('logo');

        $data = './_logosPortal/' . $logo;

        if ($data && file_exists($data)) {
            // Eliminar el archivo de la imagen
            unlink($data);

            // Actualizar la variable de sesión
            $_SESSION['logo'] = null;
            $doc              = [
                'edicion' => $date,
                'logo'    => null, // El logo con su extensión
            ];

            // Llamar al modelo para actualizar el logo
            $this->area_model->subirLogo($idPortal, $doc);
            // Responder con éxito
            echo json_encode(['success' => true]);
        } else {
            // Responder con error si no se puede eliminar
            echo json_encode(['success' => false]);
        }

    }
    public function select2()
    {
        // Portal actual
        $id_portal = (int) ($this->session->userdata('idPortal') ?: 0);

        $q    = trim($this->input->get('q', true) ?: '');
        $page = max(1, (int) ($this->input->get('page') ?: 1));

        $limit  = 20;
        $offset = ($page - 1) * $limit;

        $this->db->select('id, nombre AS text')
            ->from('cliente') // <-- tu tabla origen
            ->where('eliminado', 0)
            ->where('id_portal', $id_portal); // <-- filtra por portal

        if ($q !== '') {
            $this->db->like('nombre', $q);
        }

        $this->db->order_by('nombre', 'asc')
            ->limit($limit + 1, $offset);

        $rows = $this->db->get()->result_array();

        $more = count($rows) > $limit;
        if ($more) {
            array_pop($rows);
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'results' => $rows,
                'more'    => $more,
            ]));
    }

    /**
     * Devuelve un item por id para preselección Select2.
     * GET: /Area/get/{id}
     * Respuesta: { id, text } o {}
     */
    public function get($id)
    {
        $id_portal = (int) ($this->session->userdata('idPortal') ?: 0);

        $row = $this->db->select('id, nombre AS text')
            ->from('cliente') // <-- tu tabla
            ->where([
                'id'        => (int) $id,
                'eliminado' => 0,
                'id_portal' => $id_portal, // <-- compara portal
            ])
            ->get()
            ->row_array();

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($row ?: []));
    }

}
