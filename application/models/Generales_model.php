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

function editDomicilios($idDomicilios, $datosDomicilios){
   // echo "id domicilios : ".$idDomicilios;
    //var_dump($datosDomicilios);
    try {
        $this->db->where('id', $idDomicilios);
        $this->db->update('domicilios', $datosDomicilios);
    } catch (Exception $e) {
        log_message('error', 'Error en editDomicilios: ' . $e->getMessage());
        // Puedes lanzar una excepción personalizada o retornar un código de error, dependiendo de tus necesidades.
        return false;
    }
}

function editDatosFacturacion($idDatosFacturacion, $datosFacturacion){
  //  echo "id domicilios : ".$idDatosFacturacion."   ";
    //var_dump($datosFacturacion);
    try {
        $this->db->where('id', $idDatosFacturacion);
        $this->db->update('datos_facturacion', $datosFacturacion);
    } catch (Exception $e) {
        log_message('error', 'Error en editDatosFacturacion: ' . $e->getMessage());
        // Puedes lanzar una excepción personalizada o retornar un código de error, dependiendo de tus necesidades.
        return false;
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
    $id_portal = $this->session->userdata('idPortal');
    $this->db->select('id')
             ->from('datos_generales')
             ->where('correo', $correo);
        

    // Si estás editando un cliente, excluye el cliente actual de la búsqueda
    if ($idDatos !== null) {
        $this->db->where_not_in('id', $idDatos);
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