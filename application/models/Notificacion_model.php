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
        $this->db->select('ne.*, c.nombre, P.nombre AS nombrePortal');
        $this->db->from('notificaciones_empleados AS ne');
        $this->db->join('cliente as c', 'c.id = ne.id_cliente', 'left');
        $this->db->join('portal as P', 'P.id = ne.id_portal', 'left');
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
        $this->db->select('ne.*, c.nombre, P.nombre AS nombrePortal');
        $this->db->from('notificaciones_empleados AS ne');
        $this->db->join('cliente as c', 'c.id = ne.id_cliente', 'left');
        $this->db->join('portal as P', 'P.id = ne.id_portal', 'left');
        $this->db->where('ne.notificacionesActivas', 1);
        $this->db->where('ne.status', 1); // Filtrar por registros activos

        // Filtra por correo o whatsapp activos
        $this->db->group_start()
            ->where('ne.correo', 1)
            ->or_where('ne.whatsapp', 1)
            ->group_end();

        // Si se proporcionan horarios, se agregan a la consulta con or_like()
        if (! empty($horarios)) {
            $this->db->group_start(); // Agrupamos los LIKEs
            foreach ($horarios as $horario) {
                $this->db->or_like('ne.horarios', $horario); // Aplicamos or_like a la columna 'horarios'
            }
            $this->db->group_end();
        }

        // Ejecutar la consulta
        $query = $this->db->get();
        return $query->result(); // Retorna los registros obtenidos
    }
    public function get_notificaciones_por_slot($slot)
    {
        $slot = trim($this->db->escape_str($slot));

        $this->db->select('ne.*, c.nombre, P.nombre AS nombrePortal');
        $this->db->from('notificaciones_empleados AS ne');
        $this->db->join('cliente AS c', 'c.id = ne.id_cliente', 'left');
        $this->db->join('portal  AS P', 'P.id = ne.id_portal', 'left');

        $this->db->where('ne.notificacionesActivas', 1);
        $this->db->where('ne.status', 1);

        $this->db->group_start()
            ->where('ne.correo', 1)
            ->or_where('ne.whatsapp', 1)
            ->group_end();

        // 🔹 Filtro flexible por hora
        $this->db->group_start();
        $this->db->like('ne.horarios', $slot);
        $this->db->group_end();

        // DEBUG: ver query y resultados
        $query = $this->db->get();
        echo "<pre>";
        echo "SQL ejecutado:\n" . $this->db->last_query() . "\n";
        echo "Resultados: " . $query->num_rows() . "\n";
        print_r($query->result());
        echo "</pre>";

        return $query->result();
    }
    public function get_notificaciones_exempleados_por_slot($slot)
    {
        $slot = trim($this->db->escape_str($slot));

        $this->db->select('ne.*, c.nombre, P.nombre AS nombrePortal');
        $this->db->from('notificaciones_exempleados AS ne');
        $this->db->join('cliente AS c', 'c.id = ne.id_cliente', 'left');
        $this->db->join('portal  AS P', 'P.id = ne.id_portal', 'left');

        $this->db->where('ne.notificacionesActivas', 2);

        $this->db->group_start()
            ->where('ne.correo', 1)
            ->or_where('ne.whatsapp', 1)
            ->group_end();

        // 🔹 Filtro flexible por hora
        $this->db->group_start();
        $this->db->like('ne.horarios', $slot);
        $this->db->group_end();

        // DEBUG: ver query y resultados
        $query = $this->db->get();
      /*  echo "<pre>";
        echo "SQL ejecutado:\n" . $this->db->last_query() . "\n";
        echo "Resultados: " . $query->num_rows() . "\n";
        print_r($query->result());
        echo "</pre>";*/

        return $query->result();
    }

    public function get_recordatorios_para_slot($slot, $hoyYmd, $debug = false)
    {
                                                                      // Normaliza el slot a formatos comparables
        $slot = strtoupper(trim(str_replace(['.', ' '], '', $slot))); // "9am" -> "9AM"

        $this->db->select("
        r.*,
        nr.notificaciones_activas,
        nr.status AS status_cfg,
        nr.correo AS correo_cfg,
        nr.correo1 AS correo1_cfg,
        nr.correo2 AS correo2_cfg,
        nr.whatsapp AS whatsapp_cfg,
        nr.lada1 AS lada1_cfg,
        nr.telefono1 AS telefono1_cfg,
        nr.lada2 AS lada2_cfg,
        nr.telefono2 AS telefono2_cfg
    ", false);

        $this->db->from('recordatorio AS r');
        $this->db->join(
            'notificaciones_recordatorios AS nr',
            'nr.id_portal = r.id_portal AND nr.id_cliente = r.id_cliente AND nr.notificaciones_activas = 1 AND nr.status = 1',
            'left'
        );

        // Filtros básicos
        $this->db->where('r.activo', 1);
        $this->db->where('r.eliminado', 0);
        $this->db->where('r.proxima_fecha IS NOT NULL', null, false);

        // Filtro por anticipación
        $hoyEsc = $this->db->escape($hoyYmd);
        // Si dias_anticipacion es NULL, lo tratamos como 0
        $this->db->where("
                    r.proxima_fecha <= DATE_ADD(
                        {$hoyEsc},
                        INTERVAL COALESCE(r.dias_anticipacion, 0) DAY
                    )
                ", null, false);

        // --- Filtro flexible de horario ---
        $this->db->group_start()
            ->like('REPLACE(REPLACE(UPPER(nr.horarios), " ", ""), ".", "")', $slot)
            ->group_end();

        $query = $this->db->get();

        if ($debug) {
            echo "SQL ejecutada:\n" . $this->db->last_query() . "\n";
            echo "Resultados: " . $query->num_rows() . "\n";

            $i = 1;
            foreach ($query->result() as $r) {
                echo "#{$i} ID={$r->id} | cliente={$r->id_cliente} | portal={$r->id_portal} | prox={$r->proxima_fecha} | dias_ant={$r->dias_anticipacion} | horarios=" . ($r->horarios ?? '(sin nr.horarios)') . " | correo_cfg={$r->correo_cfg} | whatsapp_cfg={$r->whatsapp_cfg}\n";
                $i++;
            }
        }

        return $query->result();
    }
    public function get_recordatorios_para_slot_window($slot, $hoyYmd, $debug = false)
    {
        // Normaliza el slot comparador: "9am" -> "9AM", "09:00 AM" -> "09:00AM"
        $needle = strtoupper(trim(str_replace([' ', '.'], '', $slot))); // sin espacios ni puntos

        $this->db->select("
        r.*,
        nr.notificaciones_activas,
        nr.status AS status_cfg,
        nr.correo AS correo_cfg,
        nr.correo1 AS correo1_cfg,
        nr.correo2 AS correo2_cfg,
        nr.whatsapp AS whatsapp_cfg,
        nr.lada1 AS lada1_cfg,
        nr.telefono1 AS telefono1_cfg,
        nr.lada2 AS lada2_cfg,
        nr.telefono2 AS telefono2_cfg,
        p.nombre as portal,
        c.nombre as cliente
        ", false);

        $this->db->from('recordatorio AS r');
        $this->db->join(
            'notificaciones_recordatorios AS nr',
            'nr.id_portal = r.id_portal AND nr.id_cliente = r.id_cliente AND nr.notificaciones_activas = 1 AND nr.status = 1',
            'left'
        );
        $this->db->join(
            'portal AS p',
            'r.id_portal = p.id',
            'left'
        );
        $this->db->join(
            'cliente AS c',
            'r.id_cliente = c.id',
            'left'
        );

        // Activos
        $this->db->where('r.activo', 1);
        $this->db->where('r.eliminado', 0);
        $this->db->where('r.proxima_fecha IS NOT NULL', null, false);

        // Ventana correcta: HOY <= proxima <= HOY + dias_anticipacion
        $hoyEsc = $this->db->escape($hoyYmd);
        $this->db->where("r.proxima_fecha >= {$hoyEsc}", null, false);
        $this->db->where("r.proxima_fecha <= DATE_ADD({$hoyEsc}, INTERVAL r.dias_anticipacion DAY)", null, false);

        // Filtro flexible por horarios (solo los que tengan nr.horarios y contenga el slot normalizado)
        $this->db->group_start()
            ->like('REPLACE(REPLACE(UPPER(nr.horarios), " ", ""), ".", "")', $needle)
            ->group_end();

        $query = $this->db->get();

        if ($debug) {
            echo "SQL ejecutada:\n" . $this->db->last_query() . "\n";
            echo "Resultados: " . $query->num_rows() . "\n";
            $i = 1;
            foreach ($query->result() as $r) {
                $h = isset($r->horarios) ? $r->horarios : '(sin nr.horarios)';
                echo "#{$i} ID={$r->id} | cliente={$r->id_cliente} | portal={$r->id_portal} | prox={$r->proxima_fecha} | dias_ant={$r->dias_anticipacion} | horarios={$h} | correo_cfg={$r->correo_cfg} | whatsapp_cfg={$r->whatsapp_cfg}\n";
                $i++;
            }
        }

        return $query->result();
    }

/** Actualiza proxima_fecha de un recordatorio */
    public function actualizar_proxima_fecha($id_recordatorio, $nuevaFechaYmd)
    {
        return $this->db->where('id', (int) $id_recordatorio)
            ->update('recordatorio', ['proxima_fecha' => $nuevaFechaYmd]);
    }

}
