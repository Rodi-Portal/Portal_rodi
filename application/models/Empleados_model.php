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

        // Validar que haya IDs
        if (empty($ids)) {
            return false;
        }

        // Consulta
        $this->db
            ->distinct() // evita duplicados
            ->select('puesto, departamento')
            ->from('empleados')
            ->where_in('id_cliente', $ids)
            ->where('puesto IS NOT NULL')
            ->where('puesto !=', '')
            ->where('departamento IS NOT NULL')
            ->where('departamento !=', '')
            ->order_by('puesto', 'ASC');

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    public function getPuestosByCliente($id)
    {

        // Extraer solo los IDs de las sucursales

        // Solo para depuración (puedes quitar esto después)

        // Realizar la consulta
        $this->db
           ->distinct() // evita duplicados
            ->select('puesto, departamento')
            ->from('empleados')
            ->where('id_cliente', $id)
            ->where('puesto IS NOT NULL')
            ->where('puesto !=', '')
            ->where('departamento IS NOT NULL')
            ->where('departamento !=', '')
            ->order_by('puesto', 'ASC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function updateEmpleado($id, $data)
    {
        // Asegúrate de que $data sea un array asociativo con las columnas y valores
        if (! empty($data) && is_array($data)) {
            $this->db->where('id', $id);
            return $this->db->update('empleados', $data);
        }

        return false; // Si $data está vacío o no es array
    }

    /**
     * Regresa un arreglo con:
     *  - base:           fila de empleados (por id)
     *  - campos_extra:   array de filas en empleados_campos_extra
     *  - documentos:     array de filas en document_empleado
     *  - examenes:       array de filas en exams_empleado
     */
    public function findFullPre(int $id): ?array
    {
        $base = $this->db->from('empleados')
            ->where('id', $id)
            ->limit(1)
            ->get()
            ->row_array();

        if (! $base) {
            return null;
        }

        $campos_extra = $this->db->from('empleado_campos_extra')
            ->where('id_empleado', $id)
            ->order_by('id', 'desc')
            ->get()
            ->result_array();

        $documentos = $this->db->from('documents_empleado')
            ->where('employee_id', $id)
            ->order_by('id', 'desc')
            ->get()
            ->result_array();

        $examenes = $this->db->from('exams_empleados')
            ->where('employee_id', $id)
            ->order_by('id', 'desc')
            ->get()
            ->result_array();

        return [
            'base'         => $base,
            'campos_extra' => $campos_extra,
            'documentos'   => $documentos,
            'examenes'     => $examenes,
        ];
    }
    /*
    echo '<pre>';
        print_r($query->result());
        echo '</pre>';
        die();

    */

}
