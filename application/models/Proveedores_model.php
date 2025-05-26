<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proveedores_model extends CI_Model
{
    public function getProveedores()
    {
        $this->db
            ->select('pd.*, cp.correo, tp.telefono')
            ->from('proveedores_destacados AS pd')
            ->join('correos_proveedores AS cp', 'cp.id_proveedor = pd.id', 'left')
            ->join('telefonos_proveedores AS tp', 'tp.id_proveedor = pd.id', 'left')
            ->where('pd.activo', 1)
            ->order_by('pd.orden', 'ASC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $proveedores = [];
            foreach ($query->result() as $row) {
                $id = $row->id;

                if (! isset($proveedores[$id])) {
                    $proveedores[$id] = [
                        'id'           => $row->id,
                        'nombre'       => $row->nombre,
                        'descripcion'  => $row->descripcion,
                        'descripcion1' => $row->descripcion1,
                        'url1'         => $row->url1,
                        'url2'         => $row->url2,
                        'imagen'       => $row->imagen,
                        'correos'      => [],
                        'telefonos'    => [],
                    ];
                }

                if ($row->correo && ! in_array($row->correo, $proveedores[$id]['correos'])) {
                    $proveedores[$id]['correos'][] = $row->correo;
                }

                if ($row->telefono && ! in_array($row->telefono, $proveedores[$id]['telefonos'])) {
                    $proveedores[$id]['telefonos'][] = $row->telefono;
                }
            }

            return array_values($proveedores);
        }

        return false;
    }

    public function registrarContacto($data)
    {
        // Validar que $data sea un array y tenga los campos clave
        $requeridos = ['id_portal', 'id_usuario', 'id_proveedor', 'nombre', 'correo'];
        foreach ($requeridos as $campo) {
            if (! isset($data[$campo]) || empty($data[$campo])) {
                log_message('error', "Campo requerido faltante: $campo");
                return false;
            }
        }

        // Intentar insertar
        if ($this->db->insert('proveedor_contactos', $data)) {
            return $this->db->insert_id(); // Éxito: ID del nuevo registro
        } else {
            // Registrar error
            $error = $this->db->error();
            log_message('error', 'Error al insertar en proveedor_contactos: ' . $error['message']);
            return false;
        }
    }

    public function get_telefonos_by_proveedor($id)
    {
        return $this->db->where('id_proveedor', $id)
            ->where('status', 1)
            ->get('telefonos_proveedores')
            ->result();
    }

    public function get_correos_by_proveedor($id)
    {
        return $this->db->where('id_proveedor', $id)
            ->where('status', 1)
            ->get('correos_proveedores')
            ->result();
    }
}
