<?php
// application/controllers/Tools.php
defined('BASEPATH') or exit('No direct script access allowed');

class Tools extends CI_Controller
{
    /**  Solo CLI */
    public function __construct()
    {
        parent::__construct();
       /* if (! is_cli()) {
            show_404();
        }
*/
        $this->load->database();
    }

    /** php index.php tools migrar_cv */
    public function migrar_cv()
    {
        $resultados = [];
        $log        = [];

        $resultados[] = "→ Iniciando migración de CV…";
        $log[]        = "→ Iniciando migración de CV…";

        $registros = $this->db->select('id AS id_aspirante, id_usuario, cv, creacion as fecha_registro, id AS id_bolsa')
            ->from('requisicion_aspirante')
            ->where('cv IS NOT NULL', null, false)
            ->get()->result();

        if (empty($registros)) {
            $msg          = "No hay CV por migrar.";
            $resultados[] = $msg;
            $log[]        = $msg;
            log_message('info', implode(" | ", $log));
            echo json_encode(['status' => 'ok', 'mensajes' => $resultados]);
            return;
        }

        $this->db->trans_start();

        foreach ($registros as $r) {
            $físico = LINKASPIRANTESDOCS . $r->cv;

            if (! file_exists($físico)) {
                $msg          = "⚠ Archivo faltante: {$r->cv}";
                $resultados[] = $msg;
                $log[]        = $msg;
               
            }

            $this->db->insert('documentos_aspirante', [
                'id_aspirante'         => $r->id_aspirante,
                'id_usuario'           => $r->id_usuario,
                'nombre_personalizado' => 'Currículum',
                'nombre_archivo'       => $r->cv,
                'tipo'                 => strtolower(pathinfo($r->cv, PATHINFO_EXTENSION)),
                'fecha_subida'         => $r->fecha_registro,
                'fecha_actualizacion'  => $r->fecha_registro,
                'eliminado'            => 0,
            ]);

            $this->db->where('id', $r->id_bolsa)
                ->update('requisicion_aspirante', ['cv' => null]);

            $msg          = "✓ Migrado: {$r->cv}";
            $resultados[] = $msg;
            $log[]        = $msg;
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $msg          = "✔ Migración terminada correctamente.";
            $resultados[] = $msg;
            $log[]        = $msg;
            log_message('info', implode(" | ", $log));
            echo json_encode(['status' => 'ok', 'mensajes' => $resultados]);
        } else {
            $msg          = "✖ Error: se hizo rollback.";
            $resultados[] = $msg;
            $log[]        = $msg;
            log_message('error', implode(" | ", $log));
            echo json_encode(['status' => 'error', 'mensajes' => $resultados]);
        }
    }

}
