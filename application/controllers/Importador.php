<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as XlsDate;

class Importador extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        // $this->load->database(); // si no está en autoload
    }

    /**
     * Importa Excel:
     *  - Inserta en bolsa_trabajo (campos fijos + extras JSON).
     *  - Inserta en empleados duplicando info (campos fijos) y liga por id_bolsa.
     *  - Lo que no quepa en empleados se guarda en empleado_campos_extra (clave/valor).
     *
     * POST:
     *  - archivo_excel: .xlsx/.xls
     *  - id_portal (opcional; default 1)
     *  - id_cliente (opcional; para empleados)
     */
    public function importar_bolsa_y_empleados()
    {
        $this->output->set_content_type('application/json');

        if (empty($_FILES['archivo_excel']['name'])) {
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Sube un archivo Excel']));
        }

        $id_portal  = (int) ($this->session->userdata('idPortal') ?: 1);
        $id_usuario = (int) ($this->session->userdata('id') ?: 1);
        $id_cliente = (int) ($this->input->post('id_cliente') ?: null); // opcional

        try {
            $spreadsheet = IOFactory::load($_FILES['archivo_excel']['tmp_name']);
        } catch (Exception $e) {
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Excel inválido: ' . $e->getMessage()]));
        }

        $sheet = $spreadsheet->getSheet(0);
        $rows  = $sheet->toArray(null, true, true, true); // conserva cabeceras “tal cual”

        if (count($rows) < 2) {
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Excel vacío']));
        }

                                                // Cabecera (fila 1)
        $headers = array_map('trim', $rows[1]); // A => 'Task Name', B => ...
        $index   = array_flip($headers);        // 'Task Name' => 'A', etc.

        // ===== Helpers =====
        $get = function ($row, $names) use ($index) {
            $names = is_array($names) ? $names : [$names];
            foreach ($names as $name) {
                if (isset($index[$name])) {
                    $col = $index[$name];
                    return isset($row[$col]) ? trim((string) $row[$col]) : null;
                }
            }
            return null;
        };
        $getDateYmd = function ($row, $names) use ($get) {
            $raw = $get($row, $names);
            if ($raw === null || $raw === '') {
                return null;
            }

            if (is_numeric($raw)) {
                try {return XlsDate::excelToDateTimeObject($raw)->format('Y-m-d');} catch (Exception $e) {return null;}
            }
            $ts = strtotime($raw);
            return $ts ? date('Y-m-d', $ts) : null;
        };
        $getNumber = function ($row, $names) use ($get) {
            $raw = $get($row, $names);
            if ($raw === null || $raw === '') {
                return null;
            }

            $raw = str_replace([',', '$'], '', (string) $raw);
            return is_numeric($raw) ? $raw : null;
        };
        $splitNombre = function ($full) {
            $full = trim(preg_replace('/\s+/', ' ', (string) $full));
            if ($full === '') {
                return ['nombre' => '', 'paterno' => null, 'materno' => null];
            }

            $parts = explode(' ', $full);
            if (count($parts) === 1) {
                return ['nombre' => $parts[0], 'paterno' => null, 'materno' => null];
            }

            if (count($parts) === 2) {
                return ['nombre' => $parts[0], 'paterno' => $parts[1], 'materno' => null];
            }

            $paterno = array_pop($parts);
            $materno = array_pop($parts);
            $nombre  = implode(' ', $parts);
            return ['nombre' => $nombre, 'paterno' => $materno, 'materno' => $paterno];
        };
        $calcEdad = function ($ymd) {
            if (! $ymd) {
                return null;
            }

            try {
                $b = new DateTime($ymd);
                $t = new DateTime('today');
                return (int) $b->diff($t)->y;
            } catch (Exception $e) {return null;}
        };
        // bolsa_trabajo usa latin1_*: convertimos strings
        $toLatin1 = function ($s) {
            if ($s === null) {
                return null;
            }

            $out = @iconv('UTF-8', 'ISO-8859-1//TRANSLIT', (string) $s);
            return $out !== false ? $out : (string) $s;
        };

        // ===== Nombres de columnas en Excel (ajusta según tu archivo) =====
        $X_NOMBRE_COMPLETO = 'Task Name';
        $X_TASK_ID         = 'Task ID';

        // Campos “fijos” en bolsa_trabajo (lo que no esté aquí va a extras JSON)
        $MAP_BOLSA = [
            'domicilio'        => ['Dirección (short text)'],
            'fecha_nacimiento' => ['FECHA DE NACIMIENTO (date)'], // guardamos Y-m-d (VARCHAR(12))
            'telefono'         => ['TELEFONO DE CONTACTO (phone)'],
            'medio_contacto'   => ['Medio de contacto', 'MEDIO DE CONTACTO'],
            'area_interes'     => ['Área de interés', 'AREA INTERES', 'Cliente/Servicio (short text)'],
            'sueldo_deseado'   => ['PAGO MENSUAL (number)'],
        ];

        // Campos “fijos” en empleados (lo demás a empleado_campos_extra)
        $MAP_EMPLE = [
            'id_empleado'      => [$X_TASK_ID],         // string editable, puede repetirse o ser NULL
            'nombre'           => [$X_NOMBRE_COMPLETO], // lo partimos a nombre/paterno/materno
            'telefono'         => ['TELEFONO DE CONTACTO (phone)'],
            'correo'           => ['E-MAIL E.G.C (email)'],
            'departamento'     => ['Departamento', 'Cliente/Servicio (short text)'],
            'puesto'           => ['Puesto', 'Cargo'],
            'rfc'              => ['RFC'],
            'nss'              => ['NSS', 'IMSS'],
            'curp'             => ['N° DE CEDULA (short text)', 'CURP'],
            'foto'             => ['Foto', 'FOTO'],
            'fecha_nacimiento' => ['FECHA DE NACIMIENTO (date)'], // DATE
        ];

        $creacionAhora     = date('Y-m-d H:i:s');
        $insertados_bolsa  = 0;
        $insertados_emp    = 0;
        $extras_rows_total = 0;
        $errores           = [];

        // ===== Procesar filas (desde la 2) =====
        for ($i = 2; $i <= count($rows); $i++) {
            $r = $rows[$i];

            // Nombre completo
            $fullName = isset($index[$X_NOMBRE_COMPLETO]) ? trim((string) $r[$index[$X_NOMBRE_COMPLETO]]) : '';
            $np       = $splitNombre($fullName);
            if ($fullName === '') {$errores[] = "Fila $i: nombre vacío";
                continue;}

            // ---- bolsa_trabajo ----
            $domicilio_bt      = $get($r, $MAP_BOLSA['domicilio']);
            $fecha_nac_bt      = $getDateYmd($r, $MAP_BOLSA['fecha_nacimiento']); // Y-m-d (VARCHAR)
            $telefono_bt       = $get($r, $MAP_BOLSA['telefono']) ?: '';
            $medio_contacto_bt = $get($r, $MAP_BOLSA['medio_contacto']);
            $area_interes_bt   = $get($r, $MAP_BOLSA['area_interes']);
            $sueldo_deseado_bt = $getNumber($r, $MAP_BOLSA['sueldo_deseado']);

            if ($telefono_bt === '') {$errores[] = "Fila $i: teléfono vacío";
                continue;}

            // Cabeceras usadas en bolsa para excluir de extras JSON
            $used_bolsa = [$X_NOMBRE_COMPLETO];
            foreach ($MAP_BOLSA as $arr) {
                foreach ((array) $arr as $hn) {
                    $used_bolsa[] = $hn;
                }
            }

            // extras JSON (bolsa)
            $extras_bolsa = [];
            foreach ($headers as $colKey => $headerName) {
                $headerName = trim($headerName);
                if ($headerName === '') {
                    continue;
                }

                if (in_array($headerName, $used_bolsa, true)) {
                    continue;
                }

                $valx = isset($r[$colKey]) ? $r[$colKey] : null;
                if ($valx === null || $valx === '') {
                    continue;
                }

                if (is_numeric($valx) && $valx > 20000 && $valx < 60000) {
                    try { $valx = XlsDate::excelToDateTimeObject($valx)->format('Y-m-d');} catch (Exception $e) {}
                }
                $extras_bolsa[$headerName] = $valx;
            }

            $data_bolsa = [
                'creacion'         => $creacionAhora,
                'edicion'          => null,
                'id_portal'        => $id_portal,
                'id_usuario'       => $id_usuario,
                'nombre'           => $toLatin1($np['nombre']),
                'paterno'          => $toLatin1($np['paterno']),
                'materno'          => $toLatin1($np['materno']),
                'domicilio'        => $toLatin1($domicilio_bt),
                'fecha_nacimiento' => $fecha_nac_bt, // VARCHAR(12)
                'edad'             => $calcEdad($fecha_nac_bt),
                'telefono'         => preg_replace('/\D+/', '', (string) $telefono_bt),
                'nacionalidad'     => null,
                'civil'            => null,
                'dependientes'     => null,
                'grado_estudios'   => null,
                'salud'            => null,
                'enfermedad'       => null,
                'deporte'          => null,
                'metas'            => null,
                'idiomas'          => null,
                'maquinas'         => null,
                'software'         => null,
                'medio_contacto'   => $toLatin1($medio_contacto_bt),
                'area_interes'     => $toLatin1($area_interes_bt),
                'sueldo_deseado'   => $sueldo_deseado_bt !== null ? (string) $sueldo_deseado_bt : null,
                'otros_ingresos'   => null,
                'viajar'           => null,
                'trabajar'         => null,
                'comentario'       => null,
                'extras'           => json_encode($extras_bolsa, JSON_UNESCAPED_UNICODE),
                'status'           => 1,
                'semaforo'         => 0,
            ];
            // === Anti-duplicado SIMPLE (bolsa_trabajo) =============================
// Teléfono normalizado (solo dígitos) para comparar
            $tel_clean = preg_replace('/\D+/', '', (string) $telefono_bt);

// Normalizador simple para nombre/paterno/materno
            $norm = function ($s) {
                $s = @iconv('UTF-8', 'ASCII//TRANSLIT', (string) $s);
                return strtolower(preg_replace('/[^a-z0-9]+/', '', $s));
            };
            $nom = $norm($np['nombre'] ?? '');
            $pat = $norm($np['paterno'] ?? '');
            $mat = $norm($np['materno'] ?? '');

// 1) Intenta por (portal + fecha_nacimiento + teléfono)
            $dup_id = null;
            if (! empty($fecha_nac_bt)) {
                $sql1 = "
                    SELECT id
                    FROM bolsa_trabajo
                    WHERE id_portal = ?
                    AND fecha_nacimiento = ?
                    AND REPLACE(REPLACE(REPLACE(REPLACE(telefono,' ',''),'-',''),'(',''),')','') = ?
                    LIMIT 1
                ";
                $q1     = $this->db->query($sql1, [$id_portal, $fecha_nac_bt, $tel_clean])->row();
                $dup_id = $q1->id ?? null;
            }

// 2) Si no hay fecha o no encontró, intenta por (portal + teléfono + nombre completo)
            if (! $dup_id) {
                $sql2 = "
                    SELECT id
                    FROM bolsa_trabajo
                    WHERE id_portal = ?
                    AND REPLACE(REPLACE(REPLACE(REPLACE(telefono,' ',''),'-',''),'(',''),')','') = ?
                    AND LOWER(REPLACE(REPLACE(REPLACE(COALESCE(nombre ,''),' ',''),'-',''),'.',''))  = ?
                    AND LOWER(REPLACE(REPLACE(REPLACE(COALESCE(paterno,''),' ',''),'-',''),'.','')) = ?
                    AND LOWER(REPLACE(REPLACE(REPLACE(COALESCE(materno,''),' ',''),'-',''),'.','')) = ?
                    LIMIT 1
                ";
                $q2     = $this->db->query($sql2, [$id_portal, $tel_clean, $nom, $pat, $mat])->row();
                $dup_id = $q2->id ?? null;
            }

// Si ya existe, saltamos la inserción (y todo lo demás ligado a bolsa)
            if ($dup_id) {
                $errores[] = "Fila $i ({$fullName}): duplicado en bolsa (id=$dup_id) — omitido";
                continue;
            }
// ======================================================================

            // Transacción por fila
            $this->db->trans_start();

            $ok_b = $this->db->insert('bolsa_trabajo', $data_bolsa);
            if (! $ok_b) {
                $this->db->trans_complete();
                $errores[] = "Fila $i: error al insertar en bolsa_trabajo";
                continue;
            }
            $insertados_bolsa++;
            $id_bolsa = $this->db->insert_id();

            // ---- empleados (duplicado) ----
            $tel_emp    = $get($r, $MAP_EMPLE['telefono']);
            $correo_emp = $get($r, $MAP_EMPLE['correo']);
            $dep_emp    = $get($r, $MAP_EMPLE['departamento']);
            $pto_emp    = $get($r, $MAP_EMPLE['puesto']);
            $rfc_emp    = $get($r, $MAP_EMPLE['rfc']);
            $nss_emp    = $get($r, $MAP_EMPLE['nss']);
            $curp_emp   = $get($r, $MAP_EMPLE['curp']);
            $foto_emp   = $get($r, $MAP_EMPLE['foto']);
            $fnac_emp   = $getDateYmd($r, $MAP_EMPLE['fecha_nacimiento']); // DATE
            $id_emp_ext = $get($r, $MAP_EMPLE['id_empleado']);             // VARCHAR(50), puede repetirse o ser NULL
            if ($id_emp_ext !== null && $id_emp_ext !== '') {
                $id_emp_ext = mb_substr(trim((string) $id_emp_ext), 0, 50);
            } else {
                $id_emp_ext = null; // dejar nulo si no viene
            }

            $data_emp = [
                'creacion'              => $creacionAhora,
                'edicion'               => null,
                'id_portal'             => $id_portal ?: null,
                'id_cliente'            => $id_cliente ?: null,
                'id_usuario'            => $id_usuario ?: null,
                'id_empleado'           => $id_emp_ext, // editable, duplicable
                'id_domicilio_empleado' => null,
                'nombre'                => $np['nombre'] ?: null,
                'paterno'               => $np['paterno'],
                'materno'               => $np['materno'],
                'telefono'              => $tel_emp ?: $telefono_bt, // fallback
                'correo'                => $correo_emp,
                'departamento'          => $dep_emp,
                'puesto'                => $pto_emp,
                'rfc'                   => $rfc_emp,
                'nss'                   => $nss_emp,
                'curp'                  => $curp_emp,
                'foto'                  => $foto_emp,
                'fecha_nacimiento'      => $fnac_emp, // DATE
                'id_bolsa'              => $id_bolsa, // vínculo
                'status'                => 1,
                'eliminado'             => 0,
            ];

            $ok_e = $this->db->insert('empleados', $data_emp);
            if (! $ok_e) {
                $this->db->trans_complete();
                $errores[] = "Fila $i: error al insertar en empleados";
                continue;
            }
            $insertados_emp++;
            $id_empleado_pk = $this->db->insert_id();

            // ---- empleado_campos_extra (resto de columnas) ----
            $used_emple = [];
            foreach ($MAP_EMPLE as $arr) {
                foreach ((array) $arr as $hn) {
                    $used_emple[] = $hn;
                }
            }

            $used_emple[] = $X_NOMBRE_COMPLETO; // ya usado para nombre/paterno/materno

            $extras_rows = [];
            foreach ($headers as $colKey => $headerName) {
                $headerName = trim($headerName);
                if ($headerName === '') {
                    continue;
                }

                if (in_array($headerName, $used_emple, true)) {
                    continue;
                }

                $valx = isset($r[$colKey]) ? $r[$colKey] : null;
                if ($valx === null || $valx === '') {
                    continue;
                }

                if (is_numeric($valx) && $valx > 20000 && $valx < 60000) {
                    try { $valx = XlsDate::excelToDateTimeObject($valx)->format('Y-m-d');} catch (Exception $e) {}
                }

                $nombre_campo = mb_substr($headerName, 0, 255);
                $valor_campo  = mb_substr((string) $valx, 0, 255);

                $extras_rows[] = [
                    'id_empleado' => $id_empleado_pk,
                    'nombre'      => $nombre_campo,
                    'valor'       => $valor_campo,
                ];
            }

            if (! empty($extras_rows)) {
                $this->db->insert_batch('empleado_campos_extra', $extras_rows);
                $extras_rows_total += count($extras_rows);
            }

            $this->db->trans_complete();
            if ($this->db->trans_status() === false) {
                $errores[] = "Fila $i: transacción fallida";
            }
        }

        return $this->output->set_output(json_encode([
            'ok'                   => true,
            'bolsa_insertados'     => $insertados_bolsa,
            'empleados_insertados' => $insertados_emp,
            'empleado_extras_rows' => $extras_rows_total,
            'errores'              => $errores,
        ]));
    }
}
