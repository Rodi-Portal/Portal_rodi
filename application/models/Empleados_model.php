<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Empleados_model extends CI_Model
{

    public function getSucursales($permisos)
    {
        $portal     = $this->session->userdata('idPortal');
        $id_usuario = $this->session->userdata('id');

        // Recopilar los ID de clientes a los que tiene acceso el usuario
        $clientes_permitidos = [];

        foreach ($permisos as $cliente) {
            if (isset($cliente['usuarios']) && is_array($cliente['usuarios'])) {
                foreach ($cliente['usuarios'] as $usuario) {
                    if ($usuario['id_usuario'] == $id_usuario) {
                        $clientes_permitidos[] = $cliente['id_cliente'];
                        break; // ya está autorizado para este cliente, no hace falta seguir
                    }
                }
            }
        }

        // Si no tiene acceso a ningún cliente, devolver FALSE
        if (empty($clientes_permitidos)) {
            return false;
        }

        // Consultar la base de datos solo por esos clientes
        $this->db
            ->select('id, nombre')
            ->from('cliente')
            ->where('id_portal', $portal)
            ->where_in('id', $clientes_permitidos)
            ->order_by('id', 'ASC');

        $query = $this->db->get();

    
        if ($query->num_rows() > 0) {
            return $query->result();

        } else {
            return false;
        }
    }
    public function getPuestos($sucursales)
    {

        // Extraer solo los IDs de las sucursales
        $ids = array_map(function ($sucursal) {
            return $sucursal->id;
        }, $sucursales);

        // Solo para depuración (puedes quitar esto después)
     

        // Realizar la consulta
        $this->db
            ->select('puesto, departamento')
            ->from('empleados')
            ->where_in('id_cliente', $ids)
            ->order_by('id', 'ASC');

        $query = $this->db->get();
        

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getPuestosByCliente($id)
    {

        // Extraer solo los IDs de las sucursales
      

        // Solo para depuración (puedes quitar esto después)
     

        // Realizar la consulta
        $this->db
            ->select('puesto, departamento')
            ->from('empleados')
            ->where('id_cliente', $id)
            ->order_by('id', 'ASC');

        $query = $this->db->get();
        

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    /*
    echo '<pre>';
        print_r($query->result());
        echo '</pre>';
        die();
        
    */ 

}
