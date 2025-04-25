<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Avance_model extends CI_Model
{

    public function update_detalle($data, $id)
    {
        $this->db
            ->where('id', $id)
            ->update('avance_detalle', $data);
    }
    public function get_detalles($id)
    {
        $this->db
            ->select('*')
            ->from('avance_detalle')
            ->where('id', $id);

        $query = $this->db->get();
        return $query->row();
    }
    public function delete_detalle($id)
    {
        $this->db
            ->where('id', $id)
            ->delete('avance_detalle');
    }
    public function store($data)
    {
        $this->db->insert('avance', $data);
        return $this->db->insert_id();
    }
    public function store_detalles($data)
    {
        $this->db->insert('avance_detalle', $data);
    }
    public function get_detalles_by_candidato($id_candidato)
    {
        $this->db
            ->select('detalle.*, av.id as idAvance, av.finalizado, c.status')
            ->from('avance_detalle as detalle')
            ->join('avance as av', 'av.id = detalle.id_avance')
            ->join('candidato as c', 'c.id = av.id_candidato')
            ->where('av.id_candidato', $id_candidato)
            ->order_by('detalle.fecha', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_proveedores()
    {
                                                // Consulta para obtener los proveedores
        $query = $this->db->get('proveedores_destacados'); // Ajusta la tabla según tu base de datos
        return $query->result_array();          // Devolver los datos como un arreglo
    }

}
