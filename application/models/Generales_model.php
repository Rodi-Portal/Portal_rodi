<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generales_model extends CI_Model{



  // Funcion para  ingresar  datos  generales
function addDatosGenerales($datosGenerales){
    $this->db->insert("datos_generales", $datosGenerales);
    return $this->db->insert_id();
  }

function addDomicilios($datosDomicilios){
    $this->db->insert("domicilios", $datosDomicilios);
    return $this->db->insert_id();
  }

  
function editDatosGenerales($idDatosGenerales, $datosGenerales){
   
    try {
        $this->db->where('id', $idDatosGenerales);
        $this->db->update('datos_generales', $datosGenerales);
    } catch (Exception $e) {
        log_message('error', 'Error en editDatosGenerales: ' . $e->getMessage());
        // Puedes lanzar una excepción personalizada o retornar un código de error, dependiendo de tus necesidades.
        return false;
    }
}

function editDomicilios($idDomicilios, $datosDomicilios) {
    // Verifica que $datosDomicilios sea un array
    if (!is_array($datosDomicilios) || empty($datosDomicilios)) {
        log_message('error', 'Datos de domicilio no válidos para la actualización.');
        return false;
    }
    
    // Intenta realizar la actualización
    try {
        $this->db->where('id', $idDomicilios);
        $this->db->update('domicilios', $datosDomicilios);
        
        // Verifica si se actualizó al menos una fila
        if ($this->db->affected_rows() > 0) {
            return true; // Actualización exitosa
        } else {
            log_message('error', 'No se actualizó ningún registro en domicilios.');
            return false; // No se actualizó ningún registro
        }
    } catch (Exception $e) {
        log_message('error', 'Error en editDomicilios: ' . $e->getMessage());
        return false; // Error en la actualización
    }
}

function editDatosFacturacion($idDatosFacturacion, $datosFacturacion) {
    // Verifica que $datosFacturacion sea un array
    if (!is_array($datosFacturacion) || empty($datosFacturacion)) {
        log_message('error', 'Datos de facturación no válidos para la actualización.');
        return false;
    }
    
    // Intenta realizar la actualización
    try {
        $this->db->where('id', $idDatosFacturacion);
        $this->db->update('datos_facturacion', $datosFacturacion);
        
        // Verifica si se actualizó al menos una fila
        if ($this->db->affected_rows() > 0) {
            return true; // Actualización exitosa
        } else {
            log_message('error', 'No se actualizó ningún registro en datos_facturacion.');
            return false; // No se actualizó ningún registro
        }
    } catch (Exception $e) {
        log_message('error', 'Error en editDatosFacturacion: ' . $e->getMessage());
        return false; // Error en la actualización
    }
}

function getPortalCliente($id_cliente){
    try {
        // Selecciona el id_portal de la tabla clientes para el cliente específico
        $this->db->select('c.id_portal')
                 ->from('cliente AS c')
                 ->where('c.id', $id_cliente);

        // Ejecuta la consulta y obtén el resultado
        $query = $this->db->get();

        // Verifica si la consulta fue exitosa
        if ($query->num_rows() > 0) {
            // Retorna el resultado (en este caso, el id_portal)
            return $query->row()->id_portal;
        } else {
            // Retorna un valor indicativo de que no se encontraron resultados
            return null;
        }
    } catch (Exception $e) {
        // Registra el error en el log y retorna false u otra indicación según tus necesidades
        log_message('error', 'Error en getPortalCliente: ' . $e->getMessage());
        return false;
    }
}

public function correoExiste($correo ,$idDatos = null, ) {
  
    $this->db->select('id')
             ->from('datos_generales')
             ->where('correo', $correo);
        

    // Si estás editando un cliente, excluye el cliente actual de la búsqueda
    if ($idDatos !== null) {
        $this->db->where('id !=', $idDatos); // Cambiado de where_not_in a where
    }

    $query = $this->db->get();
    
    return $query->num_rows();
}

public function telefonoExiste($telefono ,$idDatos = null, ) {
    $id_portal = $this->session->userdata('idPortal');
    $this->db->select('GEN.id')
             ->from('datos_generales as GEN')
             ->join('usuarios_portal as UP', 'UP.id_datos_generales = GEN.id ')
             ->where('GEN.telefono', $telefono)
             ->where('UP.id_portal', $id_portal);
        

    // Si estás editando un cliente, excluye el cliente actual de la búsqueda
    if ($idDatos !== null) {
        $this->db->where_not_in('GEN.id', $idDatos);
    }

    $query = $this->db->get();
    return $query->num_rows();
}



function addDatosFacturacion($datosFacturacion){
  $this->db->insert("datos_facturacion", $datosFacturacion);
  return $this->db->insert_id();
}


public function obtenerIdDatosGenerales($id_cliente) {
    $this->db->select('id_datos_generales');
    $this->db->where('id', $id_cliente);
    $query = $this->db->get('cliente');

    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->id_datos_generales;
    } else {
        return null;
    }
}

public function obtenerIdDatosFacturacion($id_cliente) {
    $this->db->select('id_datos_facturacion');
    $this->db->where('id', $id_cliente);
    $query = $this->db->get('cliente');

    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->id_datos_facturacion;
    } else {
        return null;
    }
}

public function obtenerIdDomicilios($id_cliente) {
    $this->db->select('id_domicilios');
    $this->db->where('id', $id_cliente);
    $query = $this->db->get('cliente');

    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->id_domicilios;
    } else {
        return null;
    }
}
}