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
// application/controllers/Permisos.php
    private function _active_modules_for_current_client(): array
    {
        $portal_id = (int) ($this->session->userdata('idPortal') ?? 0);

        $from_portal = [];
        if ($portal_id > 0) {
            $row = $this->db->select('reclu, pre, emp, former, `com`, com360', false)
                ->from('portal')->where('id', $portal_id)->limit(1)
                ->get()->row_array() ?? [];

            // 👇 Slugs EXACTOS como en auth_permission.module
            $map = [
                'reclu'  => 'reclutamiento',
                'pre'    => 'pre_empleo',
                'emp'    => 'empleados',
                'former' => 'exempleados',
                'com'    => 'comunicacion',
                'com360' => 'comunicacion360',
            ];

            foreach ($map as $col => $slug) {
                if (isset($row[$col]) && (int) $row[$col] === 1) {
                    $from_portal[] = $slug;
                }
            }
        }

        // 👇 Utilitarios con slugs reales
        $always = ['admin', 'mi_cuenta', 'reportes', 'dashboards'];

        $candidates = array_values(array_unique(array_merge($from_portal, $always)));
        if (empty($candidates)) {
            return [];
        }

        $rows = $this->db->select('DISTINCT module', false)
            ->from('auth_permission')
            ->where('is_active', 1)
            ->where_in('module', $candidates)
            ->get()->result_array();

        return array_map(static fn($r) => $r['module'], $rows); // devuelve slugs
    }

    public function guardar()
    {
        $user_id = (int) $this->input->post('user_id');
        $module  = trim((string) $this->input->post('module'));
        $eff_enc = $this->input->post('eff_enc'); // array: base64(key) => allow|deny|inherit

        if ($user_id <= 0) {
            return $this->_json(['ok' => false, 'msg' => 'Falta user_id'], 400);
        }
        if ($module === '') {
            return $this->_json(['ok' => false, 'msg' => 'Falta module'], 400);
        }
        if (! is_array($eff_enc) || empty($eff_enc)) {
            return $this->_json(['ok' => false, 'msg' => 'Nada para guardar'], 400);
        }

        // Decodifica a $eff con claves reales
        $eff = [];
        foreach ($eff_enc as $kEnc => $effect) {
            $kStd = strtr((string) $kEnc, '-_', '+/');
            $pad  = strlen($kStd) % 4;
            if ($pad) {
                $kStd .= str_repeat('=', 4 - $pad);
            }

            $perm_key = base64_decode($kStd, true);
            if ($perm_key !== false) {
                $eff[$perm_key] = (string) $effect;
            }
        }
        if (empty($eff)) {
            return $this->_json(['ok' => false, 'msg' => 'Nada para guardar'], 400);
        }

        // 1) Usuario existe
        $exists = $this->db->where('id', $user_id)->limit(1)->get('usuarios_portal')->num_rows() > 0;
        if (! $exists) {
            return $this->_json(['ok' => false, 'msg' => 'Usuario no existe'], 404);
        }

        // 2) Validar que el módulo esté ACTIVO para el cliente (case-insensitive)
        $allowed    = $this->_active_modules_for_current_client();
        $allowed_ci = array_map('strtoupper', (array) $allowed);
        if (! in_array(strtoupper($module), $allowed_ci, true)) {
            return $this->_json(['ok' => false, 'msg' => 'Módulo no activo para este cliente.'], 403);
        }

        // 3) Cargar catálogo válido del módulo (tolerando mayúsc/minúsc)
        //    Intento exacto + variantes.
        $this->db->select('`key`')->from('auth_permission')->where('is_active', 1);
        $this->db->group_start()
            ->where('module', $module)
            ->or_where('module', strtolower($module))
            ->or_where('module', strtoupper($module))
            ->group_end();
        $valid_rows = $this->db->get()->result_array();

        $valid     = array_column($valid_rows, 'key');
        $valid_set = array_fill_keys($valid, true);
        if (empty($valid_set)) {
            return $this->_json(['ok' => false, 'msg' => 'No hay catálogo de permisos activo para el módulo.'], 404);
        }

        $admin_id = (int) ($this->session->userdata('id') ?? 0);

        $this->db->trans_start();

        $ins = $upd = $del = 0;

        foreach ($eff as $perm_key => $effect) {
            if (! isset($valid_set[$perm_key])) {
                continue; // ignora claves ajenas al módulo
            }

            // SIEMPRE: eliminar overrides previos globales de ese key (evita duplicados)
            $this->db->where([
                'user_id'        => $user_id,
                'permission_key' => $perm_key,
                'scope_type'     => 'global',
            ])->where('scope_value IS NULL', null, false)->delete('auth_user_permission');
            $del += $this->db->affected_rows();

            // Efecto "heredar" => solo borrar (ya se hizo) y continuar
            if ($effect === 'inherit') {
                continue;
            }

            // Solo aceptamos allow|deny
            if ($effect !== 'allow' && $effect !== 'deny') {
                continue;
            }

            // Insertar el override limpio
            $this->db->insert('auth_user_permission', [
                'user_id'        => $user_id,
                'permission_key' => $perm_key,
                'effect'         => $effect,
                'scope_type'     => 'global',
                'scope_value'    => null,
                'note'           => null,
                'created_by'     => $admin_id,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ]);

            if ($this->db->affected_rows() === 1) {
                $ins++;
            } else {
                // muy raro que no inserte; lo contamos como update para estadísticas
                $upd++;
            }
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
