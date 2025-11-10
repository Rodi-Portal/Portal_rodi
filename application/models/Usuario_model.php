<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_model extends CI_Model
{

    //Consulta si el usuario que quiere loguearse existe; regresa sus datos en dado caso que exista
    public function existeUsuario($correo, $pass)
    {
        $this->db
            ->select('u.id, u.correo, u.nombre, u.paterno, u.nuevo_password, u.id_rol, rol.nombre as rol, u.logueado as loginBD')
            ->from('usuario as u')
            ->join('rol', 'rol.id = u.id_rol')
            ->where('u.correo', $correo)
            ->where('u.password', $pass)
        //->where('u.id_rol !=', 3)
            ->where('u.status', 1)
            ->where('u.eliminado', 0);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function traerPass($correo)
    {
        $this->db
            ->select('password')
            ->from('datos_generales')
            ->where('correo', $correo);
        $consulta  = $this->db->get();
        $resultado = $consulta->row();

        if ($resultado) {
            return $resultado->password; // Devolver solo la contraseña como una cadena
        } else {
            return false; // Devolver falso si el correo electrónico no se encuentra en la base de datos
        }
    }

    public function actualizarVerificacion($data, $id)
    {
        // Asegúrate de que $data es un array y $id es un entero válido

        // Actualizar la fila con el ID especificado
        $this->db->where('id', $id);
        $this->db->update('datos_generales', $data);

        // Verificar si la actualización fue exitosa
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            // Si no se afectaron filas, verificar si la fila existe
            $query = $this->db->get_where('datos_generales', ['id' => $id]);
            if ($query->num_rows() == 1) {
                // La fila existe pero no se cambió porque los datos son los mismos
                return 'No changes made';
            } else {
                // La fila no existe
                return 'Row not found';
            }
        }

    }
    //Probando   el modelo para   el usuario_portal
    public function updatePass($correo)
    {
        $this->db
            ->select('D.id,
        D.correo,
        D.nombre,
        D.paterno,
        D.password,
        D.verificacion,
        D.id as idDatos')
            ->from('datos_generales as D')
            ->where('D.correo', $correo);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();

        if ($resultado) {
            return $resultado; // Devolver los datos del usuario si existe
        } else {
            return false; // Devolver falso si el usuario no se encuentra en la base de datos
        }
    }

    //Probando   el modelo para   el usuario_portal
    public function existeUsuarioPortal($correo)
    {
        $this->db
            ->select('U.id,
            D.correo,
            D.nombre,
            D.paterno,
            D.password,
            D.verificacion,
            D.id as idDatos,
            U.id_rol,
            R.nombre as rol,
            U.logueado as loginBD,
            P.nombre as nombrePortal,
            P.bloqueado,
            P.tipo_bolsa,
            P.logo,
            P.former,
            P.emp,
            P.aviso,
            P.terminos,
            P.verificacion AS dosfactores,
            P.id as idPortal')
            ->from('usuarios_portal as U')
            ->join('rol as R', 'R.id = U.id_rol')
            ->join('portal as P', 'P.id = U.id_portal')
            ->join('datos_generales as D', 'D.id = U.id_datos_generales')
            ->where('D.correo', $correo)
            ->where('U.status', 1)
            ->where('U.eliminado', 0);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();

        if ($resultado) {
            return $resultado; // Devolver los datos del usuario si existe
        } else {
            return false; // Devolver falso si el usuario no se encuentra en la base de datos
        }
    }
//TODO: pendiente  de revisar  esta  consulta   ya  que
    //Consulta si el usuario-cliente que quiere loguearse existe; regresa sus datos en dado caso que exista
    public function existeUsuarioCliente($correo)
    {
        $this->db
            ->select('UCL.id,
             CL.id as  id_cliente,
             DG.correo,
             DG.nombre,
             DG.paterno,
             DG.id as idDatos,
             DG.verificacion,
             DG.password,
             UCL.id_cliente,
             UCL.espectador,
             CL.nombre as cliente,
             UCL.logueado as loginBD,
             UCL.privacidad,
             CL.ingles,
             CL.id_portal,
             P.bloqueado,
             P.tipo_bolsa,
             LC.link')
            ->from('usuarios_clientes as UCL')
            ->join('datos_generales as DG', 'DG.id = UCL.id_datos_generales', 'left')
            ->join('cliente  as CL', ' CL.id = UCL.id_cliente')
            ->join('links_clientes  as LC', ' CL.id = LC.id_cliente', 'left')
            ->join('portal AS P', 'P.id = CL.id_portal')
            ->where('DG.correo', $correo)
            ->where('CL.status', 1)
            ->where('CL.eliminado', 0);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function existeUsuarioSubcliente($correo, $pass)
    {
        $this->db
            ->select('u.id, u.correo, u.nombre, u.paterno, u.nuevo_password, u.id_cliente, cl.nombre as cliente, u.id_subcliente, SUB.nombre_subcliente as subcliente, u.logueado as loginBD, SUB.tipo_acceso, cl.ingles')
            ->from('usuario_subcliente as u')
            ->join('subclientes as SUB', 'SUB.id = u.id_subcliente', 'left')
            ->join('cliente as cl', 'cl.id = u.id_cliente')
            ->where('u.correo', $correo)
            ->where('u.password', $pass)
            ->where('u.status', 1)
            ->where('u.eliminado', 0);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getPermisos($filtrar_roles = false, $origen = null)
    {
        $id_portal  = $this->session->userdata('idPortal');
        $id_usuario = $this->session->userdata('id');

        // Clientes a los que el usuario tiene acceso
        $this->db
            ->select('C.id')
            ->from('cliente AS C')
            ->join('usuario_permiso AS UP', 'UP.id_cliente = C.id')
            ->where('UP.id_usuario', $id_usuario);

        $clientes = array_column($this->db->get()->result_array(), 'id');
        if (empty($clientes)) {
            return []; // sin permisos de cliente no mostramos nada
        }

        // Traer info por cliente + usuarios con acceso
        $this->db
            ->select('
            C.id AS id_cliente,
            C.nombre AS nombreCliente,
            C.icono,
            C.url,
            C.creacion,
            C.max_colaboradores,
            DOM.pais,
            DOM.estado,
            DOM.ciudad,
            D.telefono,
            D.correo,
            DG.nombre AS nombreUsuario,
            DG.paterno,
            UPo.id AS id_usuario,
            R.nombre AS rol_usuario,
            (SELECT COUNT(*) FROM empleados E WHERE E.id_cliente = C.id AND E.status = 1) AS empleados_activos,
            (SELECT COUNT(*) FROM empleados E WHERE E.id_cliente = C.id AND E.status = 2) AS empleados_inactivos,
            (SELECT COUNT(*) FROM empleados E WHERE E.id_cliente = C.id AND E.status = 3) AS pre_empleados
        ')
            ->from('cliente AS C')
            ->join('datos_generales AS D', 'D.id = C.id_datos_generales', 'left')
            ->join('domicilios AS DOM', 'DOM.id = C.id_domicilios', 'left')
            ->join('usuario_permiso AS UP', 'C.id = UP.id_cliente')
            ->join('usuarios_portal AS UPo', 'UPo.id = UP.id_usuario')
            ->join('datos_generales AS DG', 'DG.id = UPo.id_datos_generales', 'left')
            ->join('rol AS R', 'R.id = UPo.id_rol', 'left')
            ->where('C.id_portal', $id_portal)
            ->where_in('C.id', $clientes);

        if ($filtrar_roles) {
            $this->db->where_not_in('UPo.id_rol', [4, 11]);
        }

        if ($origen === "former") {
            $this->db->order_by('empleados_inactivos', 'DESC');
        } elseif ($origen === "emp" || $origen === "com") {
            $this->db->order_by('empleados_activos', 'DESC');
        } elseif ($origen === "pre") {
            $this->db->order_by('pre_empleados', 'DESC');
        } else {
            $this->db->order_by('C.nombre', 'ASC');
        }

        $result = $this->db->get()->result();

        // Agrupar por cliente
        $clientesAgrupados = [];
        foreach ($result as $row) {
            $id = $row->id_cliente;

            if (! isset($clientesAgrupados[$id])) {
                $clientesAgrupados[$id] = [
                    'id_cliente'          => $row->id_cliente,
                    'nombreCliente'       => $row->nombreCliente,
                    'icono'               => $row->icono,
                    'url'                 => $row->url,
                    'creacion'            => $row->creacion,
                    'telefono'            => $row->telefono,
                    'correo'              => $row->correo,
                    'max'                 => (int) $row->max_colaboradores,
                    'empleados_activos'   => (int) $row->empleados_activos,
                    'empleados_inactivos' => (int) $row->empleados_inactivos,
                    'pre_empleados'       => (int) $row->pre_empleados,
                    'estado'              => $row->estado,
                    'pais'                => $row->pais,
                    'ciudad'              => $row->ciudad,
                    'usuarios'            => [],
                ];
            }

            $clientesAgrupados[$id]['usuarios'][] = [
                'nombre_completo' => trim("{$row->nombreUsuario} {$row->paterno}"),
                'rol'             => $row->rol_usuario,
                'id_usuario'      => $row->id_usuario,
            ];
        }

        // ===============================
        //  Fila especial: Pendientes de Sucursal
        //  Empleados del portal sin sucursal: id_cliente NULL o 0 y status=3 (pre_empleados)
        // ===============================
        $this->db->select('COUNT(*) AS c')
            ->from('empleados')
            ->where('id_portal', $id_portal)
            ->group_start()
            ->where('id_cliente IS NULL', null, false)
            ->group_end()
            ->where('status', 3);
        $rowPend    = $this->db->get()->row();
        $pendientes = (int) ($rowPend->c ?? 0);

        if ($pendientes > 0) {
            // clave artificial para no chocar con IDs reales
            $clientesAgrupados['_pendientes'] = [
                'id_cliente'          => null,
                'nombreCliente'       => 'Pendientes de Sucursal',
                'icono'               => null,
                'url'                 => 'Cliente_General/index/0', // ajusta destino si usas otro
                'creacion'            => null,
                'telefono'            => '',
                'correo'              => '',
                'max'                 => 0,
                'empleados_activos'   => 0,
                'empleados_inactivos' => 0,
                'pre_empleados'       => $pendientes,
                'estado'              => '',
                'pais'                => '',
                'ciudad'              => '',
                'usuarios'            => [], // no aplica
            ];
        }

        $lista = array_values($clientesAgrupados);

        if ($origen === 'pre') {
            // Orden por cantidad de candidatos en proceso (desc)
            usort($lista, function ($a, $b) {
                return ($b['pre_empleados'] ?? 0) <=> ($a['pre_empleados'] ?? 0);
            });
        } elseif ($origen === 'emp' || $origen === 'com') {
            usort($lista, function ($a, $b) {
                return ($b['empleados_activos'] ?? 0) <=> ($a['empleados_activos'] ?? 0);
            });
        } elseif ($origen === 'former') {
            usort($lista, function ($a, $b) {
                return ($b['empleados_inactivos'] ?? 0) <=> ($a['empleados_inactivos'] ?? 0);
            });
        } else {
            usort($lista, function ($a, $b) {
                return strcasecmp($a['nombreCliente'] ?? '', $b['nombreCliente'] ?? '');
            });
        }

        return $lista;
    }

    public function getPermisos2($filtrar_roles = false)
    {
        $id_portal  = $this->session->userdata('idPortal');
        $id_usuario = $this->session->userdata('id');

        // Clientes a los que el usuario tiene acceso
        $this->db
            ->select('C.id')
            ->from('cliente AS C')
            ->join('usuario_permiso AS UP', 'UP.id_cliente = C.id')
            ->where('UP.id_usuario', $id_usuario);
        $clientes = array_column($this->db->get()->result_array(), 'id');
        if (empty($clientes)) {
            return [];
        }

        // Ahora traemos todos los usuarios por esos clientes
        $this->db
            ->select('
            C.id AS id_cliente,
            C.nombre AS nombreCliente,
            C.icono,
            C.url,
            C.creacion,
            C.max_colaboradores,
            D.telefono,
            D.correo,
            DOM.pais,
            DOM.estado,
            DOM.ciudad,
            DG.nombre,
            DG.paterno,
            UPo.id AS id_usuario,
            R.nombre AS rol_usuario,
            (SELECT COUNT(*) FROM empleados E WHERE E.id_cliente = C.id AND E.status = 1) AS empleados_activos,
            (SELECT COUNT(*) FROM empleados E WHERE E.id_cliente = C.id AND E.status = 2 ) AS empleados_inactivos')
            ->from('cliente AS C')
            ->join('datos_generales AS D', 'D.id = C.id_datos_generales', 'left') // datos cliente
            ->join('domicilios AS DOM', 'DOM.id = C.id_domicilios', 'left')       // datos cliente
            ->join('usuario_permiso AS UP', 'C.id = UP.id_cliente')
            ->join('usuarios_portal AS UPo', 'UPo.id = UP.id_usuario')
            ->join('datos_generales AS DG', 'DG.id = UPo.id_datos_generales', 'left') // datos usuario
            ->join('rol AS R', 'R.id = UPo.id_rol', 'left')
            ->where('C.id_portal', $id_portal)
            ->where_in('C.id', $clientes)
            ->order_by('empleados_activos', 'DESC');

        // Si el parámetro $filtrar_roles es true, excluimos los roles 4 y 11
        if ($filtrar_roles) {
            $this->db->where_not_in('UPo.id_rol', [4, 11]);
        }

        //$this->db->order_by('C.nombre', 'ASC');

        $query  = $this->db->get();
        $result = $query->result();

        // Agrupamos por cliente
        $clientesAgrupados = [];
        foreach ($result as $row) {
            $id = $row->id_cliente;
            if (! isset($clientesAgrupados[$id])) {
                $clientesAgrupados[$id] = [
                    'id_cliente'          => $row->id_cliente,
                    'nombreCliente'       => $row->nombreCliente,
                    'telefono'            => $row->telefono,
                    'correo'              => $row->correo,
                    'max'                 => $row->max_colaboradores,
                    'empleados_activos'   => $row->empleados_activos,
                    'empleados_inactivos' => $row->empleados_inactivos,
                    'estado'              => $row->estado,
                    'pais'                => $row->pais,
                    'ciudad'              => $row->ciudad,
                    'usuarios'            => [],
                ];
            }

            $clientesAgrupados[$id]['usuarios'][] = [
                'nombre_completo' => trim("{$row->nombre} {$row->paterno} "),
                'rol'             => $row->rol_usuario,
                'id_usuario'      => $row->id_usuario,
            ];
        }

        // Retornar como array simple (sin IDs como clave)
        return array_values($clientesAgrupados);
    }
    public function getPermisosSubclientes($id)
    {
        $this->db
            ->select('p.*, c.nombre as nombreCliente, c.icono, sub.url, sub.nombre as nombreSubcliente, p.id_subcliente')
            ->from('usuario_permiso as up')
            ->join('permiso as p', 'p.id = up.id_permiso')
            ->join('cliente as c', 'c.id = p.id_cliente')
            ->join('subcliente as sub', 'sub.id = p.id_subcliente')
            ->where('p.id_subcliente !=', 0)
            ->where('up.id_usuario', $id)
            ->order_by('c.nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } /*
    function deleteToken($id_candidato){
    $this->db
    ->set('token', NULL)
    ->where('id', $id_candidato)
    ->update('candidato', $candidato);
    }
    function getModulos($id_rol){
    $this->db
    ->select('rolop.*')
    ->from('rol_operaciones as rolop')
    //->join('rol as rol', 'rol.id = rolop.id_rol')
    //->join('operaciones as op', 'op.id = .id_operaciones')
    //->join('modulo as m','m.id = op.id_modulo')
    ->where('.id_rol', $id_rol);

    $query = $this->db->get();
    if($query->num_rows() > 0){
    return $query->result();
    }
    else{
    return FALSE;
    }
    }*/
    public function getDatosUsuario($id_usuario)
    {
        $this->db
            ->select('u.correo, u.nombre, u.paterno, u.id_rol, u.clave')
            ->from('usuario as u')
            ->where('u.id', $id_usuario);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getDatosUsuarioInterno($id_usuario)
    {
        $this->db
            ->select('u.correo, u.nombre, u.paterno, u.id_rol, u.clave')
            ->from('usuario as u')
            ->where('u.id', $id_usuario);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getDatosUsuarioCliente($id_usuario)
    {
        $this->db
            ->select('u.correo, u.nombre, u.paterno, u.clave, u.privacidad')
            ->from('usuario_cliente as u')
            ->where('u.id', $id_usuario);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getDatosUsuarioSubcliente($id_usuario)
    {
        $this->db
            ->select('u.correo, u.nombre, u.paterno, u.clave')
            ->from('usuario_subcliente as u')
            ->where('u.id', $id_usuario);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getUsuarios()
    {
        $portal = $this->session->userdata('idPortal');
        $this->db
            ->select('DATUP.id, DATUP.nombre, DATUP.paterno, U.id_rol')
            ->from('usuarios_portal as U')
            ->join('datos_generales as DATUP', 'DATUP.id = U.id_datos_generales')
            ->where('U.status', 1)
            ->where('U.eliminado', 0)
            ->where_in('U.id_portal', $portal)
            ->where_in('U.id_rol', [2, 9])
            ->order_by('DATUP.nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function editarUsuarioInterno($datos, $id)
    {
        $this->db
            ->where('id', $id)
            ->update('usuario', $datos);
    }
    public function editarUsuarioCliente($datos, $id)
    {
        $this->db
            ->where('id', $id)
            ->update('usuario_cliente', $datos);
    }
    public function editarUsuarioSubcliente($datos, $id)
    {
        $this->db
            ->where('id', $id)
            ->update('usuario_subcliente', $datos);
    }

    public function forgotenPass($datos, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('datos_generales', $datos);

        if ($this->db->affected_rows() > 0) {
            return true; // Actualización exitosa
        } else {
            return false; // No se actualizó nada (quizá el id no existe o los datos son iguales)
        }
    }
    public function getAnalistasActivos()
    {
        $this->db
            ->select("u.id, CONCAT(u.nombre,' ',u.paterno) as usuario, u.id_rol")
            ->from('usuario as u')
            ->where('u.status', 1)
            ->where('u.eliminado', 0)
            ->where_in('u.id_rol', [2, 9])
            ->order_by('u.nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getTipoUsuarios($roles)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("U.id, CONCAT(GEN.nombre,' ',GEN.paterno) as usuario, U.id_rol")
            ->from('usuarios_portal as U')
            ->join('datos_generales as GEN', 'GEN.id = U.id_datos_generales', 'left')
            ->where('U.id_portal', $id_portal)
            ->where('U.status', 1)
            ->where('U.eliminado', 0)
            ->where_in('U.id_rol', $roles)
            ->order_by('GEN.nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getUserByIdByRole($id, $roles)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("U.id")
            ->from('usuarios_portal as U')
            ->where('U.status', 1)
            ->where('U.eliminado', 0)
            ->where('U.id_portal', $id_portal)
            ->where('U.id', $id)
            ->where_in('U.id_rol', $roles);

        $query = $this->db->get();
        return $query->row();
    }
    /*----------------------------------------*/
    /*  Control de Seguridad
    /*----------------------------------------*/
    public function checkUsuarioActivo($id_usuario)
    {

        $this->db
            ->select('status, eliminado')
            ->from('usuarios_portal')
            ->where('id', $id_usuario);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    //TODO: pendiente de revisar  si sirve
    public function checkPasswordUsuarioInterno($id, $pass)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select('u.id')
            ->from('usuario as u')
            ->where('u.id', $id)
            ->where('u.password', $pass);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function checkPasswordUsuarioCliente($id, $pass)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select('u.id')
            ->from('usuario_cliente as u')
            ->where('u.id', $id)
            ->where('u.password', $pass);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function checkPasswordUsuarioSubcliente($id, $pass)
    {
        $this->db
            ->select('u.id')
            ->from('usuario_subcliente as u')
            ->where('u.id', $id)
            ->where('u.password', $pass);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function checkCorreoUsuario($correo)
    {
        $this->db
            ->select('id')
            ->from('datos_generales')
            ->where('correo', $correo);

        $consulta = $this->db->get();
        return $consulta->row();
    }

    public function checkCorreoSubcliente($correo)
    {
        $this->db
            ->select('id')
            ->from('usuario_subcliente')
            ->where('correo', $correo);

        $consulta = $this->db->get();
        return $consulta->row();
    }

    public function addSesion($data)
    {
        $this->db->insert('sesion', $data);
    }

    public function get_usuarios_by_candidato_privacidad($idCandidato, $nivelesPrivacidadCliente)
    {
        $this->db
            ->select("CONCAT(C.nombre,' ',C.paterno,' ',C.materno) as candidato, UC.correo, CONCAT(UC.nombre,' ',UC.paterno) as nombreUsuario")
            ->from('candidato as C')
            ->join('usuario_cliente as UC', 'UC.id_cliente = C.id_cliente')
            ->where('C.id', $idCandidato)
            ->where_in('UC.privacidad', $nivelesPrivacidadCliente)
            ->where('UC.status', 1)
            ->where('UC.eliminado', 0);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
//TODO: pendiente  de revision si funciona
    public function get_usuarios_by_rol($roles)
    {
        $this->db
            ->select("U.id, CONCAT(U.nombre,' ',U.paterno) as usuario")
            ->from('usuario as U')
            ->where_in('U.id_rol', $roles)
            ->where('U.status', 1)
            ->where('U.eliminado', 0);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}
