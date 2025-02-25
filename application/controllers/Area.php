<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Area extends CI_Controller
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

    public function pasarela()
    {
        $id_cliente = $this->session->userdata('id');
        $id_portal = $this->session->userdata('idPortal');

        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));

        $items = [];
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;

        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        $data['datos_pago'] = $this->area_model->getDatosPago($id_portal);

        // Validar que los datos de pago existan y que tengan una fecha de creación
        if (empty($data['datos_pago']) || empty($data['datos_pago']->creacion)) {
            $data['usuarios'] = 'Datos de pago no disponibles.';
            $data['cobro'] = 'Datos de pago no disponibles .';
            $data['vencimiento'] = 'Datos de pago no disponibles.';
            $data['fecha_vencimiento'] = "no disponible"; // Fecha de vencimiento
            $data['estado_pago'] = "no disponible";
            $data['link_pago'] = [];
        } else {
            $data['usuarios'] = $this->calcularCobro($data['datos_pago']->creacion, $id_portal);
            $data['cantidad_usuarios'] = count($data['usuarios']);
            $data['cobro'] = $this->calcularCobroMensual($data['datos_pago']->creacion, $id_portal);
            $data['vencimiento'] = $this->definirFechaVencimiento($data['datos_pago']->creacion, $data['datos_pago']->estado_pago);
            $data['fecha_vencimiento'] = $data['vencimiento']['fecha_vencimiento']; // Fecha de vencimiento
            $data['estado_pago'] = $data['vencimiento']['estado'];
            $data['link_pago'] = $this->area_model->getLinkPago($id_portal);
            $data['historial_pagos'] = $this->area_model->getPagos($id_portal);
          
            if($data['link_pago']){
                $data['status_link_pago'] = $this->verificarFechaExpiracion( $data['link_pago']->expires_at);
                if ($data['status_link_pago'] == 1) {
                    $data['status_link_pago_text'] = 'Activo';
                    $data['status_link_pago_class'] = 'text-success';  // Clase CSS para color verde
                } else {
                    $data['status_link_pago_text'] = 'Expirado';
                    $data['status_link_pago_class'] = 'text-danger';  // Clase CSS para color rojo
                }
            
            }
            
           
        }
        // Cargar vistas
        $headerView = $this->load->view('adminpanel/header', $data, true);
        $View = $this->load->view('adminpanel/pasarela', $data, true);

        echo $headerView;
        echo $View;
    }

    public function calcularCobro($fechaCreacionStr, $id_portal)
    {

        $fechaCreacion = new DateTime($fechaCreacionStr);
        $fechaActual = new DateTime(); // Fecha actual
        $diaVencimiento = 5;

        // Fecha de vencimiento del mes actual
        $fechaVencimiento = new DateTime($fechaActual->format('Y-m-' . $diaVencimiento));
        $usuariosExtras = $this->area_model->getUsuariosExtras($id_portal);
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
        $porcentaje = $dias_restantes / $dias_del_mes;

        // Cobro proporcional
        $cobro = 50 * $porcentaje;

        return round($cobro, 2); // Devolver el cobro proporcional redondeado a dos decimales
    }

    public function calcularCobroMensual($fechaCreacionStr, $id_portal)
    {
        // Crear objetos de fecha para las comparaciones
        $fechaCreacion = new DateTime($fechaCreacionStr);
        $fechaActual = new DateTime(); // Fecha actual
        $diaVencimiento = 1; // Día de corte (el 1 del mes)

        // Fecha de vencimiento del mes actual (primer día del mes)
        $fechaVencimiento = new DateTime($fechaActual->format('Y-m-' . $diaVencimiento));

        // Obtener los usuarios extras desde la base de datos
        $usuariosExtras = $this->area_model->getUsuariosExtras($id_portal);

        // Verificar si hay usuarios extras
       

        // Obtener el precio base de los datos de pago
        $datosCobro = $this->area_model->getDatosPago($id_portal);
        $precioBase = $datosCobro->precio; // Suponiendo que tienes un campo 'precio' en la tabla 'datos_cobro'

        // Si la fecha de creación es mayor al vencimiento del mes actual, ajustamos al siguiente mes
        if ($fechaCreacion > $fechaVencimiento) {
            $fechaVencimiento->modify('+1 month');
        }

        // Verificar si se creó en el mismo mes y año
        if ($fechaCreacion->format('Y-m') === $fechaActual->format('Y-m')) {
            // Calcular el cobro proporcional si está en el mismo mes
            $diasUsados = $fechaCreacion->diff($fechaVencimiento)->days;
            $diasDelMes = $fechaActual->format('t'); // Total de días en el mes actual
            $porcentajeCobro = $diasUsados / $diasDelMes;

            // Aplicar el porcentaje al precio base
            $cobroProporcional = $precioBase * $porcentajeCobro;
        } else {
            // Si es de más de un mes, cobrar el precio completo
            $cobroProporcional = $precioBase;
        }

        // Calcular el cobro por los usuarios extras
        $totalCobro = $cobroProporcional;
        foreach ($usuariosExtras as &$usuario) {
            $usuario->cobro = $this->calcularCobro1($usuario->creacion); // Calcular el cobro individual para cada usuario
            $totalCobro += $usuario->cobro; // Sumar el cobro por usuario extra
        }
        if($id_portal == 1){
            return 1;
        }else{
        // Retornar el total cobrado
        return $totalCobro;
        }
    }

    public function definirFechaVencimiento($fechaCreacionStr, $estadoPago)
    {
        // Crear objetos de fecha para las comparaciones
        $fechaCreacion = new DateTime($fechaCreacionStr);
        $fechaActual = new DateTime(); // Fecha actual
        $diaCorte = 5; // Día de corte

        // Definir el primer día del mes actual
        $primerDiaMes = new DateTime($fechaActual->format('Y-m-01'));

        // Verificar si estamos entre el 1 y el 5 del mes
        if ($fechaActual->format('d') >= 1 && $fechaActual->format('d') <= $diaCorte) {
            // Si la fecha de creación es mayor a un mes, se marca como pendiente
            if ($fechaCreacion->diff($fechaActual)->m >= 1) {
                $fechaVencimiento = $primerDiaMes; // La fecha de vencimiento será el 1 de este mes
                $estado = 'pendiente'; // El estado es pendiente
            } else {
                // Si la fecha de creación es reciente (menos de un mes), se cobra proporcionalmente
                $fechaVencimiento = $primerDiaMes; // La fecha de vencimiento será el 1 de este mes
                $estado = 'pendiente'; // Estado pendiente o lo que corresponda
            }
        } else {
            // Si estamos después del 5 del mes
            if ($estadoPago == 'pagado') {
                // Si el estado de pago es 'pagado', la fecha de vencimiento será el 1 del siguiente mes
                $fechaVencimiento = new DateTime('first day of next month');
                $estado = 'pagado'; // Estado pagado
            } else {
                // Si el estado es pendiente o vencido, la fecha de vencimiento será el 1 de este mes
                $fechaVencimiento = $primerDiaMes;
                $estado = 'vencido'; // O 'pendiente' según lo que se requiera
            }
        }

        // Devolver la fecha de vencimiento y el estado
        return ['fecha_vencimiento' => $fechaVencimiento->format('Y-m-d'), 'estado' => $estado];
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


    public function updateLogo() {
        // Establecer la zona horaria
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        
        // Obtener datos de la sesión
        $idPortal = $this->session->userdata('idPortal');
        $portal = $this->session->userdata('nombrePortal');
        $nombre_archivo = $idPortal . '_' . $portal;
    
        // Configuración para la carga de archivo
        $config['upload_path'] = FCPATH . '_logosPortal/'; // Ruta completa
        $config['allowed_types'] = 'pdf|jpg|jpeg|png'; // Tipos de archivo permitidos
        $config['overwrite'] = true; // Sobrescribir archivo si existe
        $config['file_name'] = $nombre_archivo; // Nombre de archivo único basado en el idPortal y nombre del portal
    
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
                $doc = array(
                    'edicion' => $date,
                    'logo' => $nombre_archivo . $file_extension, // El logo con su extensión
                );
    
                // Llamar al modelo para actualizar el logo
                $this->area_model->subirLogo($idPortal, $doc);
                $this->session->set_userdata('logo', $nombre_archivo . $file_extension);
                // Responder con éxito
                echo json_encode(['success' => true, 
                'message' => 'Logo actualizado correctamente']);
            } else {
                // Si ocurre un error con la carga, mostrar el error
                echo json_encode(['success' => false, 'message' => $this->upload->display_errors()]);
            }
        } else {
            // Si no se subió ningún archivo
            echo json_encode(['success' => false, 'message' => 'No se ha seleccionado un archivo']);
        }
    }
    public function eliminarLogo() {
        // Establecer la zona horaria
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        
        // Obtener datos de la sesión
        $idPortal = $this->session->userdata('idPortal');
        $logo = $this->session->userdata('logo');

        $data = './_logosPortal/'.$logo;

        if ($data && file_exists($data)) {
            // Eliminar el archivo de la imagen
            unlink($data);
            
            // Actualizar la variable de sesión
            $_SESSION['logo'] = null;
            $doc = array(
                'edicion' => $date,
                'logo' => null, // El logo con su extensión
            );

            // Llamar al modelo para actualizar el logo
            $this->area_model->subirLogo($idPortal, $doc);
            // Responder con éxito
            echo json_encode(['success' => true]);
          } else {
            // Responder con error si no se puede eliminar
            echo json_encode(['success' => false]);
          }
    
       
       
    }
    
    
}
   
    


