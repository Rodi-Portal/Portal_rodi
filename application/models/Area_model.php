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

        $response    = curl_exec($ch);
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

        if (! $paquete) {
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
                ->limit($usuariosExtras);         // Traer solo los usuarios extras

            $query = $this->db->get();
            return $query->result(); // Devuelve un arreglo de usuarios extra
        }

        return []; // Si no hay usuarios extras, devolver un arreglo vacío
    }

    // funciones  para   gestinar los links  de pago
    public function insertarLinkPago($data)
    {
        // Usamos la función insert para insertar los datos en la tabla 'link_pago'
        $this->db->insert('link_pago', $data);

        // Verificamos si la inserción fue exitosa
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id(); // Retornamos el ID de la inserción
        } else {
            return false; // Si no se insertó, devolvemos false
        }
    }

    //funcion  para  actualizar  el nombre del  logo
    public function subirLogo($idPortal, $data)
    {
        $this->db->where('id', $idPortal); // Filtra por el id del portal
        return $this->db->update('portal', $data);
    }

    // Puedes agregar otros métodos según necesites, como obtener datos de 'link_pago'
    public function getLinkPago($id)
    {
        return $this->db
            ->select('*')
            ->from('link_pago')
            ->where('id_portal', $id)
            ->order_by('id', 'DESC') // ordenar por id descendente
            ->limit(1)               // solo 1 resultado
            ->get()
            ->row(); // devolver la última fila
    }

    public function validarPago($data)
    {
        // Inicia la transacción
        $this->db->trans_start();

        // ✅ Actualizar todos los registros en pagos_mensuales con el mismo payment_request_id
        $this->db->where('payment_request_id', $data['payment_request_id']);
        $this->db->update('pagos_mensuales', [
            'estado'      => 'pagado',
            'fecha_pago'  => $data['fecha_pago'],
            'link_status' => $data['link_status'],
            'referencia'  => $data['referencia'],
            'status'      => $data['status'],
        ]);

        // ✅ Ya no insertamos nada aquí porque los registros ya existen.

        // ✅ Opcional: eliminar el link de pago usado de la tabla link_pago
        $this->db->delete('link_pago', ['payment_request_id' => $data['payment_request_id']]);

        // ✅ Actualizar el estado en la tabla portal
        $this->db->where('id', $data['id_portal']);
        $this->db->update('portal', ['estado_pago' => 'pagado']);

        // Finaliza la transacción
        $this->db->trans_complete();

        // Verifica si la transacción fue exitosa
        if ($this->db->trans_status() === false) {
            return false;
        } else {
            // Devuelve cuántos registros fueron afectados en pagos_mensuales
            return $this->db->affected_rows();
        }
    }

    public function getPagos($id)
    {
        $this->db->select('*')
            ->from('pagos_mensuales')
            ->where('id_portal', $id);
        $query = $this->db->get();
        return $query->result(); // Devuelve el primer resultado
    }

    public function getMesesPagados($id_portal)
    {
        $this->db->select("DATE_FORMAT(mes, '%Y-%m-01') as mes");
        $this->db->from('pagos_mensuales');
        $this->db->where('id_portal', $id_portal);
        $this->db->where_in('estado', ['pagado', 'pendiente']); // O el estado que consideres
        $query = $this->db->get();

        $meses = [];
        foreach ($query->result() as $row) {
            $meses[] = $row->mes;
        }
        return $meses;
    }

    // Obtiene los meses disponibles para pago (desde creación hasta actual, excluyendo pagados)
    public function getMesesDisponibles($id_portal, $mesesAdelantados = 12)
    {
        $this->db->select('creacion');
        $this->db->from('portal');
        $this->db->where('id', $id_portal);
        $portal = $this->db->get()->row();

        if (! $portal || empty($portal->creacion)) {
            return [];
        }

        $fechaInicio = new DateTime($portal->creacion);
        $fechaInicio->modify('first day of this month');

        // Último mes que se podrá mostrar (mes actual + N)
        $fechaMax = new DateTime('first day of this month');
        $fechaMax->modify("+{$mesesAdelantados} months");

        $mesesPagados = $this->getMesesPagados($id_portal);

        $meses_es = [
            1 => 'Enero', 2       => 'Febrero', 3  => 'Marzo', 4      => 'Abril',
            5 => 'Mayo', 6        => 'Junio', 7    => 'Julio', 8      => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
        ];

        $mesesDisponibles = [];

        while ($fechaInicio <= $fechaMax) {
            $mesFormateado = $fechaInicio->format('Y-m-01');

            if (! in_array($mesFormateado, $mesesPagados)) {
                $mes_num    = (int) $fechaInicio->format('m');
                $anio       = $fechaInicio->format('Y');
                $nombre_mes = $meses_es[$mes_num] . " " . $anio;

                $mesesDisponibles[] = [
                    'fecha'      => $mesFormateado,
                    'nombre_mes' => $nombre_mes,
                ];
            }

            $fechaInicio->modify('+1 month');
        }

        return $mesesDisponibles;
    }

}
