<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model{

	//Consulta si el usuario que quiere loguearse existe; regresa sus datos en dado caso que exista
	function existeUsuario($correo, $pass){
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
    function traerPass($correo) {
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
    //Probando   el modelo para   el usuario_portal 
    function existeUsuarioPortal($correo) {
        $this->db
            ->select('u.id, d.correo, d.nombre, d.paterno, d.password, u.id_rol, r.nombre as rol, u.logueado as loginBD, p.nombre as nombrePortal, p.id as idPortal')
            ->from('usuarios_portal as u')
            ->join('rol as r', 'r.id = u.id_rol')
            ->join('portal as p', 'p.id = u.id_portal')
            ->join('datos_generales as d', 'd.id = u.id_datos_generales')
            ->where('d.correo', $correo)
            ->where('u.status', 1)
            ->where('u.eliminado', 0);
    
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        
        if ($resultado) {
            return $resultado; // Devolver los datos del usuario si existe
        } else {
            return false; // Devolver falso si el usuario no se encuentra en la base de datos
        }
    }

    //Consulta si el usuario-cliente que quiere loguearse existe; regresa sus datos en dado caso que exista
    function existeUsuarioCliente($correo, $pass ){
        $this->db
        ->select('u.id, dg.correo, dg.nombre, dg.paterno,  u.id_cliente, u.espectador, dgc.nombre as cliente, u.logueado as loginBD, u.privacidad, cl.ingles')
        ->from('usuarios_clientes as u')
        ->join('cliente as cl', 'cl.id = u.id_cliente')
        ->join('datos_generales as dg', 'dg.id = cl.id_datos_generales')
        ->join('datos_generales as dgc', 'dg.id = u.id_datos_generales')
        ->where('dg.correo', $correo)
        ->where('dg.password', $pass)
        ->where('u.status', 1)
        ->where('u.eliminado', 0);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function existeUsuarioSubcliente($correo, $pass){
        $this->db
        ->select('u.id, u.correo, u.nombre, u.paterno, u.nuevo_password, u.id_cliente, cl.nombre as cliente, u.id_subcliente, sub.nombre as subcliente, u.logueado as loginBD, sub.tipo_acceso, cl.ingles')
        ->from('usuario_subcliente as u')
        ->join('subcliente as sub', 'sub.id = u.id_subcliente','left')
        ->join('cliente as cl', 'cl.id = u.id_cliente')
        ->where('u.correo', $correo)
        ->where('u.password', $pass)
        ->where('u.status', 1)
        ->where('u.eliminado', 0);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function getPermisos($id){
        $this->db
        ->select('p.*, c.nombre as nombreCliente, c.icono, c.url')
        ->from('usuario_permiso as up')
        ->join('permiso as p', 'p.id = up.id_permiso')
        ->join('cliente as c','c.id = p.id_cliente')
        //->where('p.id_subcliente', 0)
        ->where('up.id_usuario', $id)
        ->order_by('c.nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        else{
            return FALSE;
        }
    }
    function getPermisosSubclientes($id){
        $this->db
        ->select('p.*, c.nombre as nombreCliente, c.icono, sub.url, sub.nombre as nombreSubcliente, p.id_subcliente')
        ->from('usuario_permiso as up')
        ->join('permiso as p', 'p.id = up.id_permiso')
        ->join('cliente as c','c.id = p.id_cliente')
        ->join('subcliente as sub','sub.id = p.id_subcliente')
        ->where('p.id_subcliente !=', 0)
        ->where('up.id_usuario', $id)
        ->order_by('c.nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        else{
            return FALSE;
        }
    }/*
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
    function getDatosUsuario($id_usuario){
        $this->db
        ->select('u.correo, u.nombre, u.paterno, u.id_rol, u.clave')
        ->from('usuario as u')
        ->where('u.id', $id_usuario);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function getDatosUsuarioInterno($id_usuario){
        $this->db
        ->select('u.correo, u.nombre, u.paterno, u.id_rol, u.clave')
        ->from('usuario as u')
        ->where('u.id', $id_usuario);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function getDatosUsuarioCliente($id_usuario){
        $this->db
        ->select('u.correo, u.nombre, u.paterno, u.clave, u.privacidad')
        ->from('usuario_cliente as u')
        ->where('u.id', $id_usuario);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function getDatosUsuarioSubcliente($id_usuario){
        $this->db
        ->select('u.correo, u.nombre, u.paterno, u.clave')
        ->from('usuario_subcliente as u')
        ->where('u.id', $id_usuario);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function getUsuarios(){
        $this->db
        ->select('u.id, u.nombre, u.paterno, u.id_rol')
        ->from('usuario as u')
        ->where('u.status', 1)
        ->where('u.eliminado', 0)
        ->where_in('u.id_rol', [2,9])
        ->order_by('u.nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }
        else{
            return FALSE;
        }
    }
    function editarUsuarioInterno($datos,$id){
        $this->db 
        ->where('id',$id)
        ->update('usuario',$datos);
    }
    function editarUsuarioCliente($datos,$id){
        $this->db 
        ->where('id',$id)
        ->update('usuario_cliente',$datos);
    }
    function editarUsuarioSubcliente($datos,$id){
        $this->db 
        ->where('id',$id)
        ->update('usuario_subcliente',$datos);
    }
    function getAnalistasActivos(){
      $this->db
      ->select("u.id, CONCAT(u.nombre,' ',u.paterno) as usuario, u.id_rol")
      ->from('usuario as u')
      ->where('u.status', 1)
      ->where('u.eliminado', 0)
      ->where_in('u.id_rol', [2,9])
      ->order_by('u.nombre','ASC');

      $query = $this->db->get();
      if($query->num_rows() > 0){
        return $query->result();
      }
      else{
        return FALSE;
      }
    }
    function getTipoUsuarios($roles){
      $this->db
      ->select("U.id, CONCAT(GEN.nombre,' ',GEN.paterno) as usuario, U.id_rol")
      ->from('usuarios_portal as U')
      ->join('datos_generales as GEN', 'GEN.id = U.id_datos_generales','left')
      ->where('U.status', 1)
      ->where('U.eliminado', 0)
      ->where_in('U.id_rol', $roles)
      ->order_by('GEN.nombre','ASC');

      $query = $this->db->get();
      if($query->num_rows() > 0){
        return $query->result();
      }
      else{
        return FALSE;
      }
    }
    function getUserByIdByRole($id,$roles){
      $this->db
      ->select("U.id")
      ->from('usuarios_portal as U')
      ->where('U.status', 1)
      ->where('U.eliminado', 0)
      ->where('U.id', $id)
      ->where_in('U.id_rol', $roles);

      $query = $this->db->get();
      return $query->row();
    }
    /*----------------------------------------*/
    /*  Control de Seguridad
    /*----------------------------------------*/
			function checkUsuarioActivo($id_usuario){
				$this->db
				->select('status, eliminado')
				->from('usuarios_portal')
				->where('id', $id_usuario);

				$consulta = $this->db->get();
				$resultado = $consulta->row();
				return $resultado;
			}
			function checkPasswordUsuarioInterno($id, $pass){
				$this->db
				->select('u.id')
				->from('usuario as u')
				->where('u.id', $id)
				->where('u.password', $pass);

				$consulta = $this->db->get();
				$resultado = $consulta->row();
				return $resultado;
			}
			function checkPasswordUsuarioCliente($id, $pass){
				$this->db
				->select('u.id')
				->from('usuario_cliente as u')
				->where('u.id', $id)
				->where('u.password', $pass);

				$consulta = $this->db->get();
				$resultado = $consulta->row();
				return $resultado;
			}
			function checkPasswordUsuarioSubcliente($id, $pass){
				$this->db
				->select('u.id')
				->from('usuario_subcliente as u')
				->where('u.id', $id)
				->where('u.password', $pass);

				$consulta = $this->db->get();
				$resultado = $consulta->row();
				return $resultado;
			}
			function checkCorreoCliente($correo){
				$this->db 
				->select('id')
				->from('usuario_cliente')
				->where('correo', $correo);

				$consulta = $this->db->get();
				return $consulta->row();
			}
			function checkCorreoSubcliente($correo){
				$this->db 
				->select('id')
				->from('usuario_subcliente')
				->where('correo', $correo);

				$consulta = $this->db->get();
				return $consulta->row();
			}
      
      function addSesion($data){
        $this->db->insert('sesion',$data);
      }

      function get_usuarios_by_candidato_privacidad($idCandidato, $nivelesPrivacidadCliente){
        $this->db
        ->select("CONCAT(C.nombre,' ',C.paterno,' ',C.materno) as candidato, UC.correo, CONCAT(UC.nombre,' ',UC.paterno) as nombreUsuario")
        ->from('candidato as C')
        ->join('usuario_cliente as UC','UC.id_cliente = C.id_cliente')
        ->where('C.id', $idCandidato)
				->where_in('UC.privacidad', $nivelesPrivacidadCliente)
        ->where('UC.status', 1)
        ->where('UC.eliminado', 0);

        $query = $this->db->get();
        if($query->num_rows() > 0){
					return $query->result();
        }
        else{
					return FALSE;
        }
    	}

			function get_usuarios_by_rol($roles){
        $this->db
        ->select("U.id, CONCAT(U.nombre,' ',U.paterno) as usuario")
        ->from('usuario as U')
				->where_in('U.id_rol', $roles)
        ->where('U.status', 1)
        ->where('U.eliminado', 0);

        $query = $this->db->get();
        if($query->num_rows() > 0){
					return $query->result();
        }
        else{
					return FALSE;
        }
    	}
}
