<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permisos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Permission_model');
        $this->load->library('session'); // 👈 importante para leer portal_id

        $this->load->helper(['url', 'form']);
        // Aquí podrías validar que el usuario logueado sea admin, etc.
    }

    public function precheck()
    {
        $user_id = (int) $this->input->post('user_id');
        $module  = trim((string) $this->input->post('module')); // puede venir vacío

        if ($user_id <= 0) {
            return $this->_json(['ok' => false, 'msg' => 'Falta user_id.'], 400);
        }

        // 1) Usuario existe
        $exists = $this->db->where('id', $user_id)->limit(1)->get('usuarios_portal')->num_rows() > 0;
        if (! $exists) {
            return $this->_json(['ok' => false, 'msg' => 'El usuario no existe.'], 404);
        }

                                                                // 2) Módulos activos (desde portal)
        $allowed = $this->_active_modules_for_current_client(); // p.ej. ['reclutamiento','pre_empleo']
        if (empty($allowed)) {
            return $this->_json(['ok' => false, 'msg' => 'No hay módulos activos para este cliente.'], 403);
        }

        // Helper: ¿hay catálogo para el módulo?
        $hasCatalog = function (string $m): bool {
            return (int) $this->db->where(['module' => $m, 'is_active' => 1])
                ->count_all_results('auth_permission') > 0;
        };

        $requested = $module; // lo que llegó del front
        $fallback  = false;

        // 3) Seleccionar módulo a abrir
        if ($module === '' || ! in_array($module, $allowed, true) || ! $hasCatalog($module)) {
            $module = null;
            foreach ($allowed as $m) {
                if ($hasCatalog($m)) {$module = $m;
                    break;}
            }
            if ($module === null) {
                return $this->_json(['ok' => false, 'msg' => 'No hay permisos activos en los módulos permitidos.'], 404);
            }
            $fallback = true;
        }

        // 4) Stats y URL del modal
        $stats     = $this->Permission_model->get_user_override_stats($user_id, $module);
        $modal_url = site_url('permisos/usuario/' . $user_id . '?module=' . rawurlencode($module) . '&partial=1');

        return $this->_json([
            'ok'            => true,
            'modal_url'     => $modal_url,
            'module'        => $module,   // 👈 el módulo efectivo a abrir
            'fallback'      => $fallback, // 👈 true si ajustamos
            'fallback_from' => $fallback ? $requested : null,
            'has_config'    => ($stats['total'] > 0),
            'stats'         => $stats,
        ]);
    }

// Helper interno para responder JSON consistente
    private function _json(array $payload, int $status = 200)
    {
        return $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    // /permisos/usuario/123?module=empleados
    public function usuario($user_id = null)
    {
        $user_id = (int) $user_id;
        if ($user_id <= 0) {show_error('Falta user_id', 400);}

        $module  = $this->input->get('module', true);  // ej. 'empleados'
        $partial = (int) $this->input->get('partial'); // 1 = modal/parcial

                                                                                 // Módulos activos para el cliente (desde portal)
        $allowedModules = $this->_active_modules_for_current_client();           // ['empleados','reclutamiento',...]
        $modules        = $this->Permission_model->get_modules($allowedModules); // 👈 pásalos al modelo para filtrar

        // Si no viene módulo o no está permitido, usa el primero permitido
        $allowedKeys = array_map(function ($r) {return $r['module'];}, $modules);
        if (empty($module) || ! in_array($module, $allowedKeys, true)) {
            $module = $modules[0]['module'] ?? null; // si no hay módulos activos, quedará null
        }

        $stats = ['allow' => 0, 'deny' => 0, 'total' => 0];
        if (! empty($module)) {
            $stats = $this->Permission_model->get_user_override_stats($user_id, $module);
        }

        $data = [
            'user_id'   => $user_id,
            'module'    => $module,
            'modules'   => $modules, // solo los activos
            'secciones' => $this->Permission_model->get_permissions_matrix($user_id, $module),
            'is_modal'  => ($partial === 1),
            'stats'     => $stats,
        ];

        if ($partial === 1) {
            // 👇 IMPORTANTÍSIMO: carga el PARCIAL del modal
            $this->load->view('permisos/usuario', $data);
        } else {
            // Página completa (si la usas)
            $this->load->view('permisos/usuario', $data);
        }
    }

// application/controllers/Permisos.php
// application/controllers/Permisos.php
    private function _active_modules_for_current_client(): array
    {
        // Tu sesión usa idPortal 👇
        $portal_id = (int) ($this->session->userdata('idPortal') ?? 0);

        // 1) Desde la tabla portal (si hay portal en sesión)
        $from_portal = [];
        if ($portal_id > 0) {
            // Ajusta nombres de columnas si difieren (com360 existe en tu tabla)
            $row = $this->db->select('reclu, pre, emp, former, `com`, `com360`', false)
                ->from('portal')
                ->where('id', $portal_id)
                ->limit(1)
                ->get()
                ->row_array() ?? [];

            $map = [
                'reclu'  => 'RECLUTAMIENTO',
                'pre'    => 'PREEMPLEO',
                'emp'    => 'EMPLEADOS',
                'former' => 'EXEMPLEADOS',
                'com'    => 'COMUNICACION',
                'com360' => 'COMUNICACION360',
            ];

            foreach ($map as $col => $slug) {
                if (isset($row[$col]) && (int) $row[$col] === 1) {
                    $from_portal[] = $slug;
                }
            }
        }

        // 2) Módulos “utilitarios” siempre configurables en el modal
        $always = ['GENERAL', 'MI_CUENTA', 'REPORTES', 'DASHBOARDS'];

        // 3) Candidatos = portal activos + utilitarios (únicos)
        $candidates = array_values(array_unique(array_merge($from_portal, $always)));
        if (empty($candidates)) {
            return [];
        }

        // 4) Solo devuelve los que realmente tengan catálogo activo en auth_permission
        $rows = $this->db->select('DISTINCT module', false)
            ->from('auth_permission')
            ->where('is_active', 1)
            ->where_in('module', $candidates)
            ->get()
            ->result_array();

        return array_map(static function ($r) {return $r['module'];}, $rows);
    }

    public function guardar()
    {
        $user_id = (int) $this->input->post('user_id');
        $module  = trim((string) $this->input->post('module'));
        $eff_enc = $this->input->post('eff_enc'); // array: base64(key) => allow|deny|inherit
        if (! is_array($eff_enc)) {
            return $this->_json(['ok' => false, 'msg' => 'Nada para guardar'], 400);
        }

// Decodifica a $eff con claves reales
        $eff = [];
        foreach ($eff_enc as $kEnc => $effect) {
            $kEnc = (string) $kEnc;
            // reconstruye base64 estándar
            $kStd = strtr($kEnc, '-_', '+/');
            // agrega padding si hace falta
            $pad = strlen($kStd) % 4;
            if ($pad) {$kStd .= str_repeat('=', 4 - $pad);}
            $perm_key = base64_decode($kStd, true);
            if ($perm_key === false) {
                continue;
            }
            // si algo extraño, ignora
            $eff[$perm_key] = $effect;
        }
        if (empty($eff)) {
            return $this->_json(['ok' => false, 'msg' => 'Nada para guardar'], 400);
        }

        if ($user_id <= 0) {
            return $this->_json(['ok' => false, 'msg' => 'Falta user_id'], 400);
        }

        if ($module === '') {
            return $this->_json(['ok' => false, 'msg' => 'Falta module'], 400);
        }

        if (! is_array($eff)) {
            return $this->_json(['ok' => false, 'msg' => 'Nada para guardar'], 400);
        }

        // 1) Usuario existe
        $exists = $this->db->where('id', $user_id)->limit(1)->get('usuarios_portal')->num_rows() > 0;
        if (! $exists) {
            return $this->_json(['ok' => false, 'msg' => 'Usuario no existe'], 404);
        }

        // 2) Validar que el módulo esté ACTIVO para el cliente (según portal)
        $allowed = $this->_active_modules_for_current_client();
        if (! in_array($module, $allowed, true)) {
            return $this->_json(['ok' => false, 'msg' => 'Módulo no activo para este cliente.'], 403);
        }

        // 3) Cargar catálogo válido del módulo (para no aceptar claves ajenas)
        $valid_keys = $this->db->select('`key`')->from('auth_permission')
            ->where(['module' => $module, 'is_active' => 1])->get()->result_array();
        $valid     = array_column($valid_keys, 'key');
        $valid_set = array_fill_keys($valid, true);

        $admin_id = (int) ($this->session->userdata('id') ?? 0);

        $this->db->trans_start();

        $ins = $upd = $del = 0;

        foreach ($eff as $perm_key => $effect) {
            if (! isset($valid_set[$perm_key])) {
                continue; // ignora claves que no pertenecen al módulo
            }

            if ($effect === 'inherit') {
                // Borrar override (scope global)
                $this->db->where([
                    'user_id'        => $user_id,
                    'permission_key' => $perm_key,
                    'scope_type'     => 'global',
                    'scope_value'    => null,
                ])->delete('auth_user_permission');

                $del += $this->db->affected_rows();
                continue;
            }

            if ($effect !== 'allow' && $effect !== 'deny') {
                continue; // valor inesperado
            }

            // UPSERT usando UNIQUE KEY (user_id, permission_key, scope_type)
            $sql = "
              INSERT INTO auth_user_permission
                (user_id, permission_key, effect, scope_type, scope_value, note, created_by)
              VALUES
                (?, ?, ?, 'global', NULL, NULL, ?)
              ON DUPLICATE KEY UPDATE
                effect      = VALUES(effect),
                scope_type  = VALUES(scope_type),
                scope_value = VALUES(scope_value),
                note        = VALUES(note),
                created_by  = VALUES(created_by),
                updated_at  = CURRENT_TIMESTAMP
            ";
            $this->db->query($sql, [$user_id, $perm_key, $effect, $admin_id]);
            $aff = $this->db->affected_rows();
            if ($aff === 1) {
                $ins++;
            } elseif ($aff >= 2) {
                $upd++;
            }

            // update
        }

        $this->db->trans_complete();

        if (! $this->db->trans_status()) {
            return $this->_json(['ok' => false, 'msg' => 'No se pudieron guardar cambios (TX fallida)'], 500);
        }

        return $this->_json([
            'ok'  => true,
            'msg' => "Cambios guardados. Inserciones: {$ins}, actualizaciones: {$upd}, eliminados: {$del}.",
        ]);
    }

}
