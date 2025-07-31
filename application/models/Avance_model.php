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
        return $query->result_array();                     // Devolver los datos como un arreglo
    }

    public function crearRegistrosPagoMultiple($id_portal, $meses, $monto_unitario, $payment_request_id)
    {
        foreach ($meses as $mes) {
            $data = [
                'id_portal'          => $id_portal,
                'mes'                => $mes,
                'monto'              => $monto_unitario,
                'estado'             => 'pendiente',
                'payment_request_id' => $payment_request_id,
                'created_at'         => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('pagos_mensuales', $data);
        }
    }

    public function buscarPagoMensualidad($id_portal, $fecha)
    {
        // $fecha es algo como '2025-08-01'
        $anio = date('Y', strtotime($fecha));
        $mes  = date('m', strtotime($fecha));

        $this->db->from('pagos_mensuales');
        $this->db->where('id_portal', $id_portal);
        // Comparamos por año y mes, sin importar el día
        $this->db->where('YEAR(mes)', $anio);
        $this->db->where('MONTH(mes)', $mes);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row(); // devuelve el primer registro encontrado
        }
        return null; // no hay pago registrado para ese mes
    }

    public function verificarPagoMesActual($id_portal)
    {
        $primerDiaMes = date('Y-m-01');

        $this->db->where('id_portal', $id_portal);
        $this->db->where('mes', $primerDiaMes);
        $query = $this->db->get('pagos_mensuales');

        if ($query->num_rows() === 0) {
            // ⚠️ No hay registro para este mes → se considera pendiente de crear
            return 'sin_registro';
        }

        $pago = $query->row();

        if ($pago->estado === 'pagado' && ! empty($pago->fecha_pago)) {
            // ✅ Ya pagado
            return 'pagado';
        }

        if ($pago->estado === 'pendiente' && empty($pago->fecha_pago)) {
            // 🔎 Está pendiente, evaluamos plazo
            $diaActual = (int) date('d');
            if ($diaActual >= 1 && $diaActual <= 5) {
                return 'pendiente_en_plazo';
            } else {
                return 'pendiente_fuera_plazo';
            }
        }

        // Si llegamos aquí, estado raro
        return 'otro_estado';
    }

}
