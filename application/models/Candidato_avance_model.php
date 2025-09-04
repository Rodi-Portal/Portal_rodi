<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Candidato_avance_model extends CI_Model
{

    public function getBySeccion($id_candidato, $seccion)
    {
        $this->db
            ->select("CA.*")
            ->from('candidato_avance as CA')
            ->where('CA.seccion', $seccion)
            ->where('CA.id_candidato', $id_candidato);

        $query = $this->db->get();
        return $query->row();
    }

    public function store($data)
    {
        $this->db->insert('candidato_avance', $data);
    }

    public function update($data, $id_candidato, $seccion)
    {
        $this->db
            ->where('id_candidato', $id_candidato)
            ->where('seccion', $seccion)
            ->update('candidato_avance', $data);
    }

    public function getAllById($id_candidato)
    {
        $this->db
            ->select("CA.*")
            ->from('candidato_avance as CA')
            ->where('CA.id_candidato', $id_candidato);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function registrarPreEmpleadoConDomicilio($data, $pais)
    {
        // Iniciar transacción
        $this->db->trans_start();

        // Insertar domicilio primero
        $this->db->insert('domicilios_empleados', ['pais' => $pais]);
        $id_domicilio = $this->db->insert_id(); // Obtener ID del domicilio

        // Agregar el ID del domicilio en los datos del empleado
        $data['id_domicilio_empleado'] = $id_domicilio;

        // Insertar empleado
        $this->db->insert('empleados', $data);
        $id_empleado = $this->db->insert_id();

        // Completar transacción
        $this->db->trans_complete();

        // Verificar si la transacción fue exitosa
        if ($this->db->trans_status() === false) {
            return false; // Si falló, se hará rollback automáticamente
        }

        return $id_empleado;
    }

    public function getAllEmpleados($id)
    {
        $portal = $this->session->userdata('idPortal');
        $this->db
            ->select("*")
            ->from("empleados")
            ->where('status', 3)
            ->where('id_portal', $portal);

        // 👇 Aquí la diferencia:
        if ($id == 0) {
            $this->db->where('id_cliente IS NULL', null, false);
        } else {
            $this->db->where('id_cliente', $id);
        }

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result() : false;
    }

}
