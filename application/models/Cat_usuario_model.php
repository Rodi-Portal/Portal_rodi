<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cat_usuario_model extends CI_Model{

  function getTotal($id_portal){
    $this->db
    ->select("U.id")
    ->from('usuarios_portal as U')
    ->where('U.id_portal', $id_portal)
    ->where('U.eliminado', 0)
    ->where('U.status', 1);

    $query = $this->db->get();
    return $query->num_rows();
  } 

  function getUsuarios($id_portal){
    $this->db
    ->select("U.*, U.id as id_usuario, U.id_datos_generales as id_datos, CONCAT(DATUP.nombre,' ',DATUP.paterno) as referente, R.nombre as nombre_rol, POR.nombre as nombre_portal, DATUP.*")
        ->from('usuarios_portal as U')
        ->join('datos_generales as DATUP', 'DATUP.id = U.id_datos_generales')
        ->join('portal as POR', 'POR.id = U.id_portal')
        ->join('rol as R', 'R.id = U.id_rol')  //JOIN con la tabla 'rol'
        ->where('U.eliminado', 0)
        ->order_by('U.creacion','ASC')
        ->group_by('U.id');


    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }

  public function correoExiste($correo, $idDatos = null) {
    $this->db->select('USP.id')
             ->from('usuarios_portal as USP')
             ->join('datos_generales as DATUP','DATUP.id = USP.id_datos_generales')
             ->where('DATUP.correo', $correo);

    if ($idDatos !== null) {
        $this->db->where_not_in('USP.id', $idDatos);
    }

    $query = $this->db->get();
    return $query->num_rows();
}

  function check($id){
    $this->db
    ->select('id')
    ->from('usuarios_portal')
    ->where('id', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }

  function add($usuario){
    $this->db->insert("usuario", $usuario);
    return $this->db->insert_id();
  }
  

  
  function editUsuario($id, $usuario, $id_datos = null, $datos_generales = null) {
  /*  echo " aqui el id de datos : ".$id_datos. "<br>  aqui los datos generales ";
    var_dump($datos_generales);
    echo " aqui el id de usuario : ".$id. "<br>  aqui el usuario ";

    var_dump($usuario);
    die();*/
    // Comprueba si se proporcionaron $id_datos y $datos_generales
    if ($id_datos !== null && $datos_generales !== null) {
        // Si se proporcionaron, actualiza tanto 'usuarios_portal' como 'datos_generales'
        $this->db->trans_start(); // Inicia una transacción
        
        // Actualiza 'datos_generales' primero
        $this->db
            ->where('id', $id_datos)
            ->update('datos_generales', $datos_generales);
        
        // Actualiza 'usuarios_portal' con el nuevo $usuario
        $this->db
            ->where('id', $id)
            ->update('usuarios_portal', $usuario);
        
        // Finaliza la transacción
        $this->db->trans_complete();

        // Comprueba si la transacción fue exitosa
        if ($this->db->trans_status() === FALSE) {
            // Si la transacción falla, revierte las operaciones
            $this->db->trans_rollback();
            return "Error en la transacción";
        } else {
            // Si la transacción tiene éxito, confirma las operaciones
            $this->db->trans_commit();
            return "Usuarios y datos generales actualizados con éxito";
        }
    } else {
        // Si no se proporcionaron $id_datos y $datos_generales, solo actualiza 'usuarios_portal'
        $this->db
            ->where('id', $id)
            ->update('usuarios_portal', $usuario);
        
        return "Solo usuarios actualizados";
    }
}
  
        
function addUsuarioInterno($usuario, $datos_generales) {
  // Inicia la transacción
  $this->db->trans_start();

  try {
      // Obtén el ID del portal desde la sesión
      $id_portal = $this->session->userdata('idPortal');

      // Inserta los datos generales en la tabla 'datos_generales'
      $this->db->insert("datos_generales", $datos_generales);
      
      // Obtén el ID del último registro insertado en 'datos_generales'
      $id_datos_generales = $this->db->insert_id();

      // Agrega el ID del portal y el ID de los datos generales al arreglo $usuario
      $usuario['id_portal'] = $id_portal;
      $usuario['id_datos_generales'] = $id_datos_generales;

      


      // Inserta el usuario en la tabla 'usuarios_portal'
      $this->db->insert("usuarios_portal", $usuario);

      // Finaliza la transacción
      $this->db->trans_complete();

      // Verifica si la transacción fue exitosa
      if ($this->db->trans_status() === FALSE) {
          // Si la transacción falla, revierte las operaciones
          $this->db->trans_rollback();
          return " error  en la consulta";
      } else {
          // Si la transacción tiene éxito, confirma las operaciones
          $this->db->trans_commit();
          return " se registro";
      }
  } catch (Exception $e) {
      // Si ocurre una excepción, revierte las operaciones y devuelve false
      $this->db->trans_rollback();
      return "error  excepcion ".$e;
  }
}
  
function updatePass($id, $datos) {
  // Inicia la transacción
  $this->db->trans_start();

  try {
      // Actualiza los datos en la tabla 'datos_generales'
      $this->db->where('id', $id);
      $this->db->update('datos_generales', $datos);

      // Finaliza la transacción
      $this->db->trans_complete();

      // Verifica si la transacción fue exitosa
      if ($this->db->trans_status() === FALSE) {
          // Si la transacción falla, revierte las operaciones
          $this->db->trans_rollback();
          return "error en la consulta";
      } else {
          // Si la transacción tiene éxito, confirma las operaciones
          $this->db->trans_commit();
          return "se actualizó correctamente";
      }
  } catch (Exception $e) {
      // Si ocurre una excepción, revierte las operaciones y devuelve false
      $this->db->trans_rollback();
      return "error excepcion ".$e;
  }
}


function getById($idusuario){
  $this->db
  ->select('*')
  ->from('usuario')
  ->where('id',$idusuario);

  $query = $this->db->get();
  return $query->row();
}
  
  function getActivos(){
    $id_portal = $this->session->userdata('idPortal');
    $this->db
    ->select("U.*, DATUP.* ")
    ->from('usuarios_portal as U')
    ->join('datos_generales  as DATUP', 'DATUP.id = U.id_datos_generales')
    ->where('U.id_portal', $id_portal)
    ->where('U.status', 1)
    ->where('U.eliminado', 0)
    ->order_by('DATUP.nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }

} 