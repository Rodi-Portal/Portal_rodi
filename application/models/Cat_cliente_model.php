<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cat_cliente_model extends CI_Model{

  function getTotal($portal){
    $this->db
    ->select("c.id")
    ->from('cliente as c')
    ->where('c.id_portal',$portal)
    ->where('c.ingles', 0)
    ->where('c.eliminado', 0);

    $query = $this->db->get();
    return $query->num_rows();
  }
 function getC($portal, $id_cliente = null) {
    try {
        $this->db->select("c.*,
            c.id AS idCliente,
            c.id_datos_facturacion AS dFac,
            c.id_domicilios AS dDom,
            c.id_datos_generales AS dGen, 
            dg.nombre AS nombre_contacto, 
            dg.paterno AS apellido_contacto, 
            dg.correo AS correo_contacto, 
            dg.telefono AS telefono_contacto,
            dg.password AS password_contacto,
            d.*, 
            f.*, f.regimen as regimen1, f.forma_pago, f.metodo_pago,
            (SELECT COUNT(id) FROM usuarios_clientes WHERE id_cliente = c.id) AS numero_usuarios_clientes,
            dgc.nombre AS nombre_usuario_cliente,
            dgc.paterno AS apellido_usuario_cliente,
            dgc.correo AS correo_usuario_cliente,
            dgc.telefono AS telefono_usuario_cliente")
            ->from('cliente AS c')
            ->join("datos_generales AS dg", "c.id_datos_generales = dg.id")
            ->join("domicilios AS d", "c.id_domicilios = d.id")
            ->join("datos_facturacion AS f", "c.id_datos_facturacion = f.id")
            ->join("datos_generales AS dgc", "c.id_datos_generales = dgc.id")
            ->where(['c.id_portal' => $portal, 'c.eliminado' => 0]);

        // Si se proporciona un id_cliente, añade un filtro adicional
        if ($id_cliente !== null) {
            $this->db->where('c.id', $id_cliente);
        }

        $query = $this->db->get();

        // Verifica errores de la base de datos
        $db_error = $this->db->error();
        if (!empty($db_error['message'])) {
            log_message('error', 'Error en la consulta: ' . $db_error['message']);
            return [];
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    } catch (Exception $e) {
        log_message('error', 'Excepción en la consulta: ' . $e->getMessage());
        return [];
    } 
}

function existe($nombre, $clave, $id){
  $this->db
     ->select('id')
     ->from('cliente')
     ->where("(nombre = '$nombre' OR clave = '$clave') AND id != '$id'");
  
  $query = $this->db->get();
  // Loguear la consulta SQL generada
  log_message('info', 'Consulta SQL en existe: ' . $this->db->last_query());
  return $query->num_rows();
}

function check($id){
  $this->db
     ->select('id')
     ->from('cliente')
     ->where('id', $id);
  
  $query = $this->db->get();
  // Loguear la consulta SQL generada
  log_message('info', 'Consulta SQL en check: ' . $this->db->last_query());
  return $query->num_rows();
}

  function addCliente($cliente, $datosFacturacion, $datosDomicilios, $datosGenerales) {
    try {
        // Iniciar la transacción
        $this->db->trans_start();

        // Agregar los datos generales y obtener el ID
        $id_datosGenerales = $this->generales_model->addDatosGenerales($datosGenerales);

        // Agregar los domicilios y obtener el ID
        $id_domicilios = $this->generales_model->addDomicilios($datosDomicilios);

        // Agregar los datos de facturación y obtener el ID
        $id_datosFacturacion =  $this->generales_model->addDatosFacturacion($datosFacturacion);

        // Asignar los IDs obtenidos al cliente
        $cliente['id_datos_generales'] = $id_datosGenerales;
        $cliente['id_domicilios'] = $id_domicilios;
        $cliente['id_datos_facturacion'] = $id_datosFacturacion;

        // Insertar el cliente en la tabla correspondiente
        $this->db->insert("cliente", $cliente);
        $idCliente = $this->db->insert_id();
        // Completar la transacción
        $this->db->trans_complete();

        // Verificar si la transacción fue exitosa
        if ($this->db->trans_status() === false) {
            // Ocurrió un error durante la transacción, puedes manejarlo según tus necesidades
            // Puedes lanzar una excepción o retornar un código de error, dependiendo de tu lógica de manejo de errores.
            return false;
        }
        // La transacción fue exitosa, retornar el ID del cliente insertado
         return $idCliente;

    } catch (Exception $e) {
        // Manejar la excepción si ocurre algún error
        // Puedes lanzar una excepción personalizada o loggear el error, dependiendo de tus necesidades.
        log_message('error', 'Error en addCliente: ' . $e->getMessage());
        return false;
    }
  }
  function addUsuarioClienteModel($usuarioCliente, $usuarioClienteDatos){
    try {
      

        $this->db->trans_start();

        // Agregar los datos generales y obtener el ID
        $usuarioCliente['id_datos_generales'] = $this->generales_model->addDatosGenerales($usuarioClienteDatos);

        // Insertar en la tabla usuarios_clientes
        $this->db->insert("usuarios_clientes", $usuarioCliente);

        $this->db->trans_complete();

        // Verificar si la transacción fue exitosa
        if ($this->db->trans_status() === false) {
            // Ocurrió un error durante la transacción
            return false;
        }

        // Transacción exitosa, retornar el ID del usuario insertado
        return $this->db->insert_id();
    } catch (Exception $e) {
        log_message('error', 'Error en addUsuarioCliente: ' . $e->getMessage());
        return false;
    }
}


  function editCliente($idCliente, $cliente ,$datosFacturacion = null,   $datosDomicilios = null, $datosGenerales = null ) {
    try {
        // Iniciar la transacción
        $this->db->trans_start();

        // Editar los datos generales si se proporcionaron
        if (!is_null($datosGenerales)) {
            $this->generales_model->editDatosGenerales($cliente['id_datos_generales'], $datosGenerales);
        }

        // Editar los domicilios si se proporcionaron
        if (!is_null($datosDomicilios)) {
            $this->generales_model->editDomicilios($cliente['id_domicilios'], $datosDomicilios);
        }

        // Editar los datos de facturación si se proporcionaron
        if (!is_null($datosFacturacion)) {
            $this->generales_model->editDatosFacturacion($cliente['id_datos_facturacion'], $datosFacturacion);
        }

        // Actualizar el cliente en la tabla correspondiente si se proporcionó
        if (!is_null($cliente)) {
            $this->db->where('id', $idCliente)->update('cliente', $cliente);
        }

        // Completar la transacción
        $this->db->trans_complete();

        // Verificar si la transacción fue exitosa
        if ($this->db->trans_status() === false) {
            // Ocurrió un error durante la transacción, manejar según tus necesidades
            return false;
        }

        // La transacción fue exitosa, retornar true
        return true;
    } catch (Exception $e) {
        // Manejar la excepción si ocurre algún error
        log_message('error', 'Error en editCliente: ' . $e->getMessage());
        return false;
    }
}

 

  function addPermiso($permiso){
    $this->db->insert("permiso", $permiso);
  }
 
  function editPermiso($permiso, $id_cliente){
    $this->db
    ->where('id_cliente', $id_cliente)
    ->update('permiso', $permiso);
  }
  
  function getById($idCliente){
    $this->db
    ->select('*')
    ->from('cliente')
    ->where('id',$idCliente);

    $query = $this->db->get();
    return $query->row();
  }
  function checkPermisosByCliente($id_cliente){
    $this->db
    ->select("id")
    ->from('permiso')
    ->where('id_cliente', $id_cliente);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function getAccesosClienteModal($id_cliente, $id_portal){
  
   
   
    $this->db
        ->select("cli.*, CONCAT(dup.nombre,' ',dup.paterno) as usuario, CONCAT(duc.nombre,' ',duc.paterno) as usuario_cliente, duc.correo as correo_usuario, uc.creacion as alta, uc.id as idUsuarioCliente, uc.privacidad")
        ->from("cliente AS cli")
        ->join("usuarios_clientes uc", "uc.id_cliente = cli.id")
        ->join("usuarios_portal u", "u.id = cli.id_portal")
        ->join("datos_generales dup", "dup.id = u.id_datos_generales")
        ->join("datos_generales duc", "duc.id = uc.id_datos_generales")
        ->where("cli.id", $id_cliente)
        ->where("u.id", $id_portal);
       
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return FALSE;
    }
}
  function editAccesoUsuarioCliente($idCliente,$usuario ){
    $this->db
    ->where('id_cliente', $idCliente)
    ->update('usuarios_clientes', $usuario);
  }
  function editAccesoUsuarioSubcliente($idCliente, $usuario){
    $this->db
    ->where('id_cliente', $idCliente)
    ->update('usuario_subcliente', $usuario);
  }
 



  function deleteAccesoUsuarioCliente($idUsuarioCliente){
    $this->db
    ->where('id', $idUsuarioCliente)
    ->delete('usuarios_clientes');
  }

  
  
  
  function getClientesActivosModel(){
    $this->db
    ->select("c.*")
    ->from('cliente as c')
    ->where('c.status', 1)
    ->where('c.eliminado', 0)
    ->order_by('c.nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }

  function getUsuariosClientePorCandidato($id_candidato){
    $this->db
    ->select("cl.correo, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.privacidad as privacidadCandidato, cl.privacidad as privacidadCliente")
    ->from('candidato as c')
    ->join("usuario_cliente as cl","cl.id_cliente = c.id_cliente")
    ->where('c.id', $id_candidato);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function addHistorialBloqueos($data){
    $this->db->insert("bloqueo_historial", $data);
  }
  function editHistorialBloqueos($dataBloqueos, $idCliente){
    $this->db
    ->where('id_cliente', $idCliente)
    ->update('bloqueo_historial', $dataBloqueos);
  }
  function getBloqueoHistorial($id_cliente){
    $this->db
    ->select("*")
    ->from('bloqueo_historial')
    ->where('status', 1)
    ->where('id_cliente', $id_cliente);

    $consulta = $this->db->get();
    return $consulta->row();
  }
}