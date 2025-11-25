<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Empleados extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('id')) {
            redirect('Login/index');
            $this->load->helper('language');

        }
        $this->load->helper('language');
        $this->load->library('usuario_sesion');
        $this->usuario_sesion->checkStatusBD();
        $lang      = $this->session->userdata('lang') ?: 'es';
        $idioma_ci = ($lang === 'en') ? 'english' : 'espanol';

        $this->lang->load('modulos', $idioma_ci);

    }
// esta  funcion  es  para  cargar el modulo de empleados
    public function index()
    {
        // Obtiene los submenús y otros datos necesarios
        $data['submenus']  = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);

        $data['permisos'] = $this->usuario_model->getPermisos(true);

        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));

        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;

        // Obtiene configuraciones
        $config          = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;
        // Verifica si el módulo de empleados está habilitado
        $res = $this->cat_portales_model->getModulos();

        if (! empty($res)) {
                            // Accede directamente a la fila
            $modulo = $res; // getModulos devuelve solo una fila como array

            // Verifica el valor de empleados
            if ($modulo['emp'] == 1) {
                // Carga la vista correspondiente para el módulo de empleados
                $View = $this->load->view('moduloEmpleados/listadoClientes', $data, true);
            } else {
                // Si el módulo no está habilitado, carga una vista de descripción
                $View = $this->load->view('moduloEmpleados/descripcion_modulo', $data, true);
            }
        } else {
            // Si no hay módulos, carga una vista de error o una descripción
            $View = $this->load->view('moduloEmpleados/descripcion_modulo', $data, true);
        }

        // Cargar las vistas en variables
        $headerView  = $this->load->view('adminpanel/header', $data, true);
        $scriptsView = $this->load->view('adminpanel/scripts', $modales, true);
        $footerView  = $this->load->view('adminpanel/footer', $config, true);

        // Mostrar las vistas
        echo $headerView;
        echo $scriptsView; // Mostrar scripts si es necesario
        echo $View;        // Mostrar el contenido del módulo de empleados
    }

    public function showEmpleados($id)
    {
        // Obtiene los submenús y otros datos necesarios
        $data['submenus']   = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $modales['modals']  = $this->load->view('modals/mdl_usuario', '', true);
        $data['permisos']   = $this->usuario_model->getPermisos(true, 'emp');
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));

        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus']   = $items;
        $data['cliente_id'] = $id;
        // Obtiene configuraciones
        $config          = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        // Verifica si el módulo de empleados está habilitado
        $res = $this->cat_portales_model->getModulos();

        if (! empty($res)) {
                            // Accede directamente a la fila
            $modulo = $res; // getModulos devuelve solo una fila como array

            // Verifica el valor de empleados
            if ($modulo['emp'] == 1) {
                // Carga la vista correspondiente para el módulo de empleados
                $View = $this->load->view('moduloEmpleados/indexEmpleados', $data, true);
            } else {
                // Si el módulo no está habilitado, carga una vista de descripción
                $View = $this->load->view('moduloEmpleados/descripcion_modulo', $data, true);
            }
        } else {
            // Si no hay módulos, carga una vista de error o una descripción
            $View = $this->load->view('moduloEmpleados/descripcion_modulo', $data, true);
        }

        // Cargar las vistas en variables
        $headerView  = $this->load->view('adminpanel/header', $data, true);
        $scriptsView = $this->load->view('adminpanel/scripts', $modales, true);
        $footerView  = $this->load->view('adminpanel/footer', $config, true);

        // Mostrar las vistas
        echo $headerView;
        echo $scriptsView; // Mostrar scripts si es necesario
        echo $View;        // Mostrar el contenido del módulo de empleados
    }
// estta  Funcion es para  cargar  el modulo   de Pre  empleados
    public function preEmpleados()
    {
        // Obtiene los submenús y otros datos necesarios
        $data['submenus']  = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
   

        $data['permisos']   = $this->usuario_model->getPermisos(false, 'pre');
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));

        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;

        // Obtiene configuraciones
        $config          = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        // Verifica si el módulo de pre-empleo está habilitado
        $res = $this->cat_portales_model->getModulos();

        if (! empty($res)) {
                            // Accede directamente a la fila
            $modulo = $res; // getModulos devuelve solo una fila como array

            // Verifica el valor de pre-empleo
            if ($modulo['pre'] == 1) {
                // Carga la vista correspondiente para el módulo de pre-empleo
                $View = $this->load->view('moduloPreEmpleados/procesos', $data, true);
            } else {
                // Si el módulo no está habilitado, carga una vista de descripción
                $View = $this->load->view('moduloPreEmpleados/descripcion_modulo', $data, true);
            }
        } else {
            // Si no hay módulos, carga una vista de error o una descripción
            $View = $this->load->view('moduloPreEmpleados/descripcion_modulo', $data, true);
        }

        // Cargar las vistas en variables
        $headerView  = $this->load->view('adminpanel/header', $data, true);
        $scriptsView = $this->load->view('adminpanel/scripts', $modales, true);
        $footerView  = $this->load->view('adminpanel/footer', [], true);

        // Mostrar las vistas
        echo $headerView;
        echo $scriptsView; // Mostrar scripts si es necesario
        echo $View;        // Mostrar el contenido del módulo de pre-empleo
    }

    public function exEmpleados()
    {
        // Obtiene los submenús y otros datos necesarios
        $data['submenus']  = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
       
        $data['permisos']   = $this->usuario_model->getPermisos(true, 'former');
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));

        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;

        // Obtiene configuraciones
        $config          = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        // Verifica si el módulo de exempleados está habilitado
        $res = $this->cat_portales_model->getModulos();

        if (! empty($res)) {
                            // Accede directamente a la fila
            $modulo = $res; // getModulos devuelve solo una fila como array

            // Verifica el valor de exempleados
            if ($modulo['former'] == 1) {
                // Carga la vista correspondiente para el módulo de exempleados
                $View = $this->load->view('moduloExEmpleados/listadoClientes', $data, true);
            } else {
                // Si el módulo no está habilitado, carga una vista de descripción
                $View = $this->load->view('moduloExEmpleados/descripcion_modulo', $data, true);
            }
        } else {
            // Si no hay módulos, carga una vista de error o una descripción
            $View = $this->load->view('moduloExEmpleados/descripcion_modulo', $data, true);
        }

        // Cargar las vistas en variables
        $headerView  = $this->load->view('adminpanel/header', $data, true);
        $scriptsView = $this->load->view('adminpanel/scripts', $modales, true);
        $footerView  = $this->load->view('adminpanel/footer', [], true);

        // Mostrar las vistas
        echo $headerView;
        echo $scriptsView; // Mostrar scripts si es necesario
        echo $View;        // Mostrar el contenido del módulo de exempleados
    }

    public function showExEmpleados($id)
    {
        // Obtiene los submenús y otros datos necesarios
        $data['submenus']   = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $modales['modals']  = $this->load->view('modals/mdl_usuario', '', true);
        $data['permisos']   = $this->usuario_model->getPermisos(true, 'former');
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));

        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;

        // Obtiene configuraciones
        $config             = $this->funciones_model->getConfiguraciones();
        $data['version']    = $config->version_sistema;
        $data['cliente_id'] = $id;
        // Verifica si el módulo de exempleados está habilitado
        $res = $this->cat_portales_model->getModulos();

        if (! empty($res)) {
                            // Accede directamente a la fila
            $modulo = $res; // getModulos devuelve solo una fila como array

            // Verifica el valor de exempleados
            if ($modulo['former'] == 1) {
                // Carga la vista correspondiente para el módulo de exempleados
                $View = $this->load->view('moduloExEmpleados/indexExEmpleados', $data, true);
            } else {
                // Si el módulo no está habilitado, carga una vista de descripción
                $View = $this->load->view('moduloExEmpleados/descripcion_modulo', $data, true);
            }
        } else {
            // Si no hay módulos, carga una vista de error o una descripción
            $View = $this->load->view('moduloExEmpleados/descripcion_modulo', $data, true);
        }

        // Cargar las vistas en variables
        $headerView  = $this->load->view('adminpanel/header', $data, true);
        $scriptsView = $this->load->view('adminpanel/scripts', $modales, true);
        $footerView  = $this->load->view('adminpanel/footer', [], true);

        // Mostrar las vistas
        echo $headerView;
        echo $scriptsView; // Mostrar scripts si es necesario
        echo $View;        // Mostrar el contenido del módulo de exempleados
    }

    public function comunicacion()
    {
        // Obtiene los submenús y otros datos necesarios
        $data['submenus']  = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
        $data['permisos']  = $this->usuario_model->getPermisos(true, 'com');

        $data['submodulos']       = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $data['columnas_fijas']   = ['Sucursal', 'Empleados', 'Usuarios con acceso', 'Acciones'];
        $data['columnas_ocultas'] = ['id_cliente', 'creacion', 'correo', 'max', 'usuarios', 'empleados_activos', 'nombreCliente', 'empleados_inactivos', 'icono', 'url', 'pre_empleados'];

        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $idUsuario        = $this->session->userdata('id');
        $idCliente        = $this->session->userdata('idCliente');
        $idPortal         = $this->session->userdata('idPortal');

        // Obtener configuración guardada del usuario
        $configColumnas = $this->comunicacion_model->getColumnasConfiguracion($idUsuario, $idCliente, $idPortal);

        // Columnas seleccionadas por el usuario (puede ser null si no tiene)
        $data['columnas_usuario'] = $configColumnas['seleccionadas'];

        // Columnas disponibles: como ya vienen en permisos, los asignamos para que la vista los use
        $data['columnas_disponibles'] = array_keys($data['permisos'][0] ?? []);
        // Obtiene configuraciones
        $config          = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;
        // Verifica si el módulo de empleados está habilitado
        $res = $this->cat_portales_model->getModulos();

        if (! empty($res)) {
                            // Accede directamente a la fila
            $modulo = $res; // getModulos devuelve solo una fila como array

            // Verifica el valor de empleados
            if ($modulo['com'] == 1) {
                // Carga la vista correspondiente para el módulo de empleados
                $View = $this->load->view('moduloComunicacion/listadoClientes', $data, true);
            } else {
                // Si el módulo no está habilitado, carga una vista de descripción
                $View = $this->load->view('moduloComunicacion/descripcion_modulo', $data, true);
            }
        } else {
            // Si no hay módulos, carga una vista de error o una descripción
            $View = $this->load->view('moduloComunicacion/descripcion_modulo', $data, true);
        }
        /*
         echo'<pre>';
        echo print_r($data);
        echo'</pre>'; */
        // Cargar las vistas en variables
        $headerView  = $this->load->view('adminpanel/header', $data, true);
        $scriptsView = $this->load->view('adminpanel/scripts', $modales, true);
        $footerView  = $this->load->view('adminpanel/footer', $config, true);

        // Mostrar las vistas
        echo $headerView;
        echo $scriptsView; // Mostrar scripts si es necesario
        echo $View;        // Mostrar el contenido del módulo de empleados
    }

    public function showComunicacion($id = null)
    {
        // Revisión: ¿vienen IDs por POST?
        $post_ids = $this->input->post('ids');

        if (! empty($post_ids)) {
            // Si vienen por POST
            if (is_array($post_ids)) {
                $cliente_ids = $post_ids;
            } else {
                $cliente_ids = explode(',', $post_ids);
            }
        } elseif (! empty($id)) {
            // Si vienen por parámetro en la URL
            if (strpos($id, ',') !== false) {
                $cliente_ids = explode(',', $id);
            } else {
                $cliente_ids = [$id];
            }
        } else {
            // Si no se recibió nada, manejar como error o array vacío
            $cliente_ids = [];
        }

        // Datos base
        $data['submenus']   = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $modales['modals']  = $this->load->view('modals/mdl_usuario', '', true);
        $data['permisos']   = $this->usuario_model->getPermisos(true);
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));

        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;

        // Configuración general
        $config             = $this->funciones_model->getConfiguraciones();
        $data['version']    = $config->version_sistema;
        $data['cliente_id'] = $cliente_ids;

        // Verificación del módulo
        $res = $this->cat_portales_model->getModulos();
        if (! empty($res)) {
            if ($res['com'] == 1) {
                $View = $this->load->view('moduloComunicacion/indexComunicacion', $data, true);
            } else {
                $View = $this->load->view('moduloComunicacion/descripcion_modulo', $data, true);
            }
        } else {
            $View = $this->load->view('moduloComunicacion/descripcion_modulo', $data, true);
        }

        // Vistas generales
        $headerView  = $this->load->view('adminpanel/header', $data, true);
        $scriptsView = $this->load->view('adminpanel/scripts', $modales, true);
        $footerView  = $this->load->view('adminpanel/footer', [], true);

        echo $headerView;
        echo $scriptsView;
        echo $View;
    }

    /*Consultas  para  obtener Datos Pre Empleo Interni */
    public function getPreEmpleados($id)
    {
        // Ejemplo: consulta en otra tabla (pre_empleados)
        $id = (int) $id;
        if ($id <= 0) {
            return $this->output->set_status_header(400)
                ->set_output(json_encode(['ok' => false, 'error' => 'ID inválido']));
        }

        // (opcional) valida permisos/sesión antes de consultar…

        $data = $this->empleados_model->findFullPre($id);
        if (! $data) {
            return $this->output->set_status_header(404)
                ->set_output(json_encode(['ok' => false, 'error' => 'No encontrado']));
        }

        return $this->output->set_output(json_encode([
            'ok'   => true,
            'id'   => $id,
            'data' => $data,
        ]));

    }

}
