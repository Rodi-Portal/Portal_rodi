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

// En tu modelo (p. ej. Avance_model.php)
public function verificarPagoMesActual($id_portal, $autocreate = true, $dias_gracia = 5)
{
    date_default_timezone_set('America/Mexico_City');

    // Mes actual y mes anterior guardados como 'YYYY-mm-01'
    $mesActual   = date('Y-m-01');
    $mesAnterior = date('Y-m-01', strtotime('first day of previous month'));
    $diaActual   = (int) date('j'); // 1..31

    // --- 1) Busca/crea registro del mes actual ---
    $pagoActual = $this->db->get_where('pagos_mensuales', [
        'id_portal' => (int)$id_portal,
        'mes'       => $mesActual
    ])->row();

    if (!$pagoActual && $autocreate) {
        $this->db->insert('pagos_mensuales', [
            'id_portal'  => (int)$id_portal,
            'mes'        => $mesActual,
            'monto'      => null,
            'estado'     => 'pendiente',
            'fecha_pago' => null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $pagoActual = (object)['estado' => 'pendiente', 'fecha_pago' => null];
    }

    // Si el mes actual ya está pagado → acceso total
    if ($pagoActual && $pagoActual->estado === 'pagado' && !empty($pagoActual->fecha_pago)) {
        return 'pagado';
    }

    // --- 2) Verifica si el mes anterior fue pagado ---
    $pagoAnterior = $this->db->get_where('pagos_mensuales', [
        'id_portal' => (int)$id_portal,
        'mes'       => $mesAnterior,
        'estado'    => 'pagado'
    ])->row();

    $anteriorPagado = ($pagoAnterior && !empty($pagoAnterior->fecha_pago));

    // --- 3) Regla de gracia condicional ---
    //   - Si el mes anterior está pagado: hay gracia del día 1 al 5.
    //   - Si el mes anterior NO está pagado: NO hay gracia nunca.
    if ($anteriorPagado) {
        return ($diaActual >= 1 && $diaActual <= $dias_gracia)
            ? 'pendiente_en_plazo'      // puede entrar, muestra modal
            : 'pendiente_fuera_plazo';  // bloquea
    } else {
        return 'pendiente_fuera_plazo'; // bloquea siempre (sin gracia)
    }
}


}