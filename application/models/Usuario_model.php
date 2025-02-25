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

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function traerPass($correo)
    {
        $this->db
            ->select('password')
            ->from('datos_generales')
            ->where('correo', $correo);
        $consulta = $this->db->get();
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

        $consulta = $this->db->get();
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
            P.logo,
            P.id as idPortal')
            ->from('usuarios_portal as U')
            ->join('rol as R', 'R.id = U.id_rol')
            ->join('portal as P', 'P.id = U.id_portal')
            ->join('datos_generales as D', 'D.id = U.id_datos_generales')
            ->where('D.correo', $correo)
            ->where('U.status', 1)
            ->where('U.eliminado', 0);

        $consulta = $this->db->get();
        $resultado = $consulta->row();

        if ($resultado) {
            return $resultado; // Devolver los datos del usuario si existe
        } else {
            return false; // Devolver falso si el usuario no se encuentra en la base de datos
        }
    }

    public function existeUsuarioSandbox($correo)
    {
        $this->db
            ->select('*')
            ->from('usuarios_sandbox')
            ->where('correo', $correo);

        $consulta = $this->db->get();
        $resultado = $consulta->row();

        if ($resultado) {
            return 1; // Devolver los datos del usuario si existe
        } else {
            return 0; // Devolver falso si el usuario no se encuentra en la base de datos
        }
    }
    public function existeUsuarioSandbox1($correo)
    {
        $this->db
            ->select('*')
            ->from('usuarios_sandbox')
            ->where('correo', $correo);

        $consulta = $this->db->get();
        $resultado = $consulta->row();

        if ($resultado) {
            return $resultado; // Devolver los datos del usuario si existe
        } else {
            return []; // Devolver falso si el usuario no se encuentra en la base de datos
        }
    }

    public function registroUsuarioSandbox($datos)
    {
        // Insertar los datos en la tabla usuarios_sandbox
        $this->db->insert('usuarios_sandbox', $datos);
    
        // Obtener el ID del último registro insertado
        $insert_id = $this->db->insert_id();
    
        // Verificar si se realizó la inserción correctamente
        if ($insert_id) {
            // Consultar el registro recién insertado
           
                return $insert_id; // Devolver el registro completo como un objeto
        
        }
    
        // Retornar 0 si no se realizó la inserción
        return 0;
    }

    public function existeUsuarioSanbox($correo)
    {
        $this->db
            ->select('U.*')
            ->from('usuarios_sandbox as U')
            ->where('U.correo', $correo);
        

        $consulta = $this->db->get();
        $resultado = $consulta->row();

        if ($resultado) {
            return $resultado; // Devolver los datos del usuario si existe
        } else {
            return false; // Devolver falso si el usuario no se encuentra en la base de datos
        }
    }
    public function incrementarVisita($id, $data)
    {
        // Asegúrate de que $data es un array y $id es un entero válido

        // Actualizar la fila con el ID especificado
        $this->db->where('id', $id);
        $this->db->update('usuarios_sandbox', $data);

        // Verificar si la actualización fue exitosa
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
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
             P.bloqueado')
            ->from('usuarios_clientes as UCL')
            ->join('datos_generales as DG', 'DG.id = UCL.id_datos_generales')
            ->join('cliente  as CL', ' CL.id = UCL. id_cliente')
            ->join('portal AS P', 'P.id = CL.id_portal' )
            ->where('DG.correo', $correo)
            ->where('CL.status', 1)
            ->where('CL.eliminado', 0);

        $consulta = $this->db->get();
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

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getPermisos($id)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select('C.id As id_cliente, C.nombre as nombreCliente, C.icono, C.url, C.creacion, D.telefono, D.correo, D.correo')
            ->from('cliente as C')
            ->join('datos_generales AS D','D.id = C.id_datos_generales', 'left')
            ->where('C.id_portal', $id_portal)
            ->order_by('C.nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
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

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getDatosUsuarioInterno($id_usuario)
    {
        $this->db
            ->select('u.correo, u.nombre, u.paterno, u.id_rol, u.clave')
            ->from('usuario as u')
            ->where('u.id', $id_usuario);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getDatosUsuarioCliente($id_usuario)
    {
        $this->db
            ->select('u.correo, u.nombre, u.paterno, u.clave, u.privacidad')
            ->from('usuario_cliente as u')
            ->where('u.id', $id_usuario);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getDatosUsuarioSubcliente($id_usuario)
    {
        $this->db
            ->select('u.correo, u.nombre, u.paterno, u.clave')
            ->from('usuario_subcliente as u')
            ->where('u.id', $id_usuario);

        $consulta = $this->db->get();
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
        $this->db
            ->where('id', $id)
            ->update('datos_generales', $datos);
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

        $consulta = $this->db->get();
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

        $consulta = $this->db->get();
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

        $consulta = $this->db->get();
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

        $consulta = $this->db->get();
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
