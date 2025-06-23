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

    }
// esta  funcion  es  para  cargar el modulo de empleados
    public function index()
    {
        // Obtiene los submenús y otros datos necesarios
        $data['submenus']  = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);
        $data['permisos']  = $this->usuario_model->getPermisos(true);

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
        $data['permisos']   = $this->usuario_model->getPermisos(true);
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
        $data['submenus']   = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $modales['modals']  = $this->load->view('modals/mdl_usuario', '', true);
        $data['permisos']   = $this->usuario_model->getPermisos();
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
        $data['submenus']   = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $modales['modals']  = $this->load->view('modals/mdl_usuario', '', true);
        $data['permisos']   = $this->usuario_model->getPermisos(true);
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
        $data['permisos']   = $this->usuario_model->getPermisos(true);
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
        $data['permisos']  = $this->usuario_model->getPermisos(true);

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

        // Cargar las vistas en variables
        $headerView  = $this->load->view('adminpanel/header', $data, true);
        $scriptsView = $this->load->view('adminpanel/scripts', $modales, true);
        $footerView  = $this->load->view('adminpanel/footer', $config, true);

        // Mostrar las vistas
        echo $headerView;
        echo $scriptsView; // Mostrar scripts si es necesario
        echo $View;        // Mostrar el contenido del módulo de empleados
    }

    public function showComunicacion($id)
    {
        // Obtiene los submenús y otros datos necesarios
        $data['submenus']   = $this->rol_model->getMenu($this->session->userdata('idrol'));
        $modales['modals']  = $this->load->view('modals/mdl_usuario', '', true);
        $data['permisos']   = $this->usuario_model->getPermisos(true);
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
            if ($modulo['com'] == 1) {
                // Carga la vista correspondiente para el módulo de exempleados
                $View = $this->load->view('moduloComunicacion/indexComunicacion', $data, true);
            } else {
                // Si el módulo no está habilitado, carga una vista de descripción
                $View = $this->load->view('moduloComunicacion/descripcion_modulo', $data, true);
            }
        } else {
            // Si no hay módulos, carga una vista de error o una descripción
            $View = $this->load->view('moduloComunicacion/descripcion_modulo', $data, true);
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

}
