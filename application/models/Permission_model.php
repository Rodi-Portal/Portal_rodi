<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permission_model extends CI_Model
{
    public function get_permissions_matrix($user_id, $module = null)
    {
        $this->db->select('p.key, p.module, p.section, p.action, p.is_sensitive, p.description, a.effect');
        $this->db->from('auth_permission AS p');
        $this->db->join(
            'auth_user_permission AS a',
            "a.permission_key = p.key
              AND a.user_id = {$this->db->escape_str((int) $user_id)}
              AND a.scope_type = 'global'
              AND a.scope_value IS NULL",
            'left'
        );
        $this->db->where('p.is_active', 1);

        if (! empty($module)) {
            $this->db->where('p.module', $module);
        }

        $this->db->order_by('p.module ASC, p.section ASC, p.action ASC');

        $rows = $this->db->get()->result_array();

        // Agrupar por sección para que sea cómodo en la vista
        $out = [];
        foreach ($rows as $r) {
            $out[$r['section']][] = $r;
        }
        return $out; // ['expediente.generales' => [...], 'cursos' => [...], ...]
    }
    public function get_user_override_stats($user_id, $module)
    {
        $sql = "
      SELECT
        SUM(a.effect = 'allow') AS allow_count,
        SUM(a.effect = 'deny')  AS deny_count
      FROM auth_user_permission a
      JOIN auth_permission p
        ON p.`key` = a.permission_key
       AND p.is_active = 1
      WHERE a.user_id   = ?
        AND a.scope_type = 'global'
        AND a.scope_value IS NULL
        AND p.module = ?
    ";
        $row = $this->db->query($sql, [(int) $user_id, (string) $module])->row_array();
        return [
            'allow' => (int) ($row['allow_count'] ?? 0),
            'deny'  => (int) ($row['deny_count'] ?? 0),
            'total' => (int) ($row['allow_count'] ?? 0) + (int) ($row['deny_count'] ?? 0),
        ];
    }

    public function get_modules(array $allowed = null)
    {
        $this->db->select('DISTINCT module', false)
            ->from('auth_permission')
            ->where('is_active', 1);
        if (! empty($allowed)) {
            $this->db->where_in('module', $allowed);
        }
        return $this->db->order_by('module', 'ASC')->get()->result_array();
    }

}
