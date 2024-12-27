<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notificacion_model extends CI_Model
{

    public function get_by_usuario($idUsuario, $visto)
    {
        $this->db
            ->select("N.*,CONCAT(dat.nombre,' ',dat.paterno) as usuario")
            ->from("notificacion as N")
            ->join("usuarios_portal as U", "U.id = N.usuario_destino")
            ->join("datos_generales as dat", "U.id_usuario = N.usuario_destino")
            ->where_in("N.visto", $visto)
            ->where("N.usuario_destino", $idUsuario)
            ->order_by("N.id", 'desc');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function update($data, $id)
    {
        $this->db
            ->where('id', $id)
            ->update('notificacion', $data);
    }
    public function store($data)
    {
        $this->db->insert('notificacion', $data);
    }

    // Obtiene todas las notificaciones activas
    public function get_notificaciones()
    {
        $this->db->select('ne.*, c.nombre, p.nombre AS nombrePortal');
        $this->db->from('notificaciones_empleados AS ne');
        $this->db->join('cliente as c', 'c.id = ne.id_cliente','left');
        $this->db->join('portal as P', 'P.id = ne.id_portal','left');
        $this->db->where('ne.notificacionesActivas', 1);
        $this->db->where('ne.status', 1); // Filtrar por registros activos
        // Filtrar por correo o whatsapp activos
        $this->db->group_start()
            ->where('correo', 1)
            ->or_where('whatsapp', 1)
            ->group_end();
        $query = $this->db->get();
        return $query->result(); // Retorna los registros obtenidos
    }

    // Filtra las notificaciones por horarios
    public function get_notificaciones_por_horarios($horarios)
    {
        $this->db->select('*');
        $this->db->from('notificaciones_empleados');
        $this->db->where('notificacionesActivas', 1);
        $this->db->where('status', 1); // Filtrar solo los activos
        $this->db->like('horarios', $horarios);
        $this->db->group_start()
            ->where('correo', 1)
            ->or_where('whatsapp', 1)
            ->group_end(); // Verifica que el horario esté incluido
        $query = $this->db->get();
        return $query->result(); // Retorna los registros filtrados
    }

}
