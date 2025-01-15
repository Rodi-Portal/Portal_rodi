<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Area_model extends CI_Model
{

    public function getArea($nombre)
    {
        $url = API_URL . 'area/' . urlencode($nombre);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $error = curl_error($ch);
            return "Error en la solicitud cURL: " . $error;
        }

        curl_close($ch);

        if ($http_status == 200) {
            $datosArea = json_decode($response, true);
            return $datosArea;
        } else {
            return "Error en la solicitud HTTP: Código " . $http_status;
        }
    }
    public function getAreaById($id)
    {
        $this->db
            ->select("A.*, CONCAT(U.nombre,' ',U.paterno,' ',U.materno) as responsable")
            ->from('area as A')
            ->join('usuario as U', 'U.id = A.usuario_responsable')
            ->where('A.id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    public function getDatosPago($id)
    {
        $this->db
            ->select("P.*, PAQ.*")
            ->from('portal as P')
            ->join('paquetestalentsafe as PAQ', 'PAQ.id = P.id_paquete')
            ->where('P.id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    public function getUsuariosPortal($id)
    {
        $this->db
            ->select("
                (COUNT(UP.id) - PAQ.usuarios) as usuarios_extra
            ") // Contar usuarios y calcular usuarios extra
            ->from('portal as P')
            ->join('usuarios_portal as UP', 'P.id = UP.id_portal', 'inner')
            ->join('paquetestalentsafe as PAQ', 'PAQ.id = P.id_paquete', 'inner')
            ->where('UP.status', 1)
            ->where('P.id', $id);

        $query = $this->db->get();
        return $query->row(); // Devuelve un objeto con los resultados
    }

    public function getUsuariosExtras($id_portal)
    {
        // Subconsulta para obtener el número de usuarios permitidos
        $this->db
            ->select('PAQ.usuarios')
            ->from('portal as P')
            ->join('paquetestalentsafe as PAQ', 'PAQ.id = P.id_paquete', 'inner')
            ->where('P.id', $id_portal);
        $paquete = $this->db->get()->row();
    
        if (!$paquete) {
            return []; // Si no se encuentra el paquete, devolver un arreglo vacío
        }
    
        $usuariosPermitidos = (int) $paquete->usuarios;
    
        // Contar el total de usuarios actuales en el portal
        $this->db
            ->select('COUNT(UP.id) as total_usuarios')
            ->from('usuarios_portal as UP')
            ->where('UP.id_portal', $id_portal)
            ->where('UP.status', 1);
        $total = $this->db->get()->row();
    
        $totalUsuarios = (int) $total->total_usuarios;
    
        // Calcular la diferencia entre usuarios actuales y permitidos
        $usuariosExtras = $totalUsuarios - $usuariosPermitidos;
    
        if ($usuariosExtras > 0) {
            // Si hay usuarios extras, obtener los más recientes
            $this->db
                ->select('UP.creacion, UP.id, DAT.nombre, DAT.paterno, DAT.correo')
                ->from('usuarios_portal as UP')
                ->join('datos_generales as DAT', 'UP.id_datos_generales = DAT.id')

                ->where('UP.id_portal', $id_portal)
                
                ->where('UP.status', 1)
                ->order_by('UP.creacion', 'DESC') // Ordenar por los más recientes
                ->limit($usuariosExtras); // Traer solo los usuarios extras
    
            $query = $this->db->get();
            return $query->result(); // Devuelve un arreglo de usuarios extra
        }
    
        return []; // Si no hay usuarios extras, devolver un arreglo vacío
    }
    


}
