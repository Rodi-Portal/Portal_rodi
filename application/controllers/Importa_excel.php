<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Shared\Date as XlsDate;

class Importa_excel extends CI_Controller
{
    private string $path_docs_empleado;
    private string $path_docs_bolsa;

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        // $this->load->database(); // si no está en autoload

        $this->path_docs_empleado = rtrim(FCPATH, '/') . '/_documentEmpleado/';
        $this->path_docs_bolsa    = rtrim(FCPATH, '/') . '/_documentosBolsa/';

        if (! is_dir($this->path_docs_empleado)) {
            @mkdir($this->path_docs_empleado, 0775, true);
        }

        if (! is_dir($this->path_docs_bolsa)) {
            @mkdir($this->path_docs_bolsa, 0775, true);
        }

    }

    /**
     * Importa Excel:
     *  - Inserta en bolsa_trabajo (fijos + extras JSON).
     *  - Según STATUS, decide si insertar en empleados y con qué status.
     *  - Descarga documentos (hipervínculos y/o URLs en texto).
     *  - Guarda links en EXTRAS SOLO si la descarga falla.
     *
     * POST:
     *  - archivo_excel: .xlsx/.xls
     *  - id_portal (opcional; default 1)
     *  - id_cliente (opcional; para empleados)
     */
    /*
    public function importar()
    {
        /* ===== Booster SOLO para esta petición =====
                                                   // — Booster mínimo por-request (CI3) —
        @ini_set('max_execution_time', '900');     // 15 min (mejor margen que 300s)
        @ini_set('memory_limit', '1024M');         // o 1024M si tu Excel es grande
        @ini_set('default_socket_timeout', '120'); // si descargas URLs

        $this->output->set_content_type('application/json', 'utf-8');

        if (empty($_FILES['archivo_excel']['name'])) {
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Sube un archivo Excel']));
        }

        $id_portal  = (int) ($this->session->userdata('idPortal') ?: 1);
        $id_usuario = (int) ($this->session->userdata('id') ?: 1);
        $id_cliente = (int) ($this->input->post('id_cliente') ?: null); // opcional

        try {
            // 1) Caché a disco
            \PhpOffice\PhpSpreadsheet\Settings::setCacheStorageMethod(
                \PhpOffice\PhpSpreadsheet\CachedObjectStorageFactory::cache_to_discISAM,
                ['dir' => sys_get_temp_dir()]
            );

            $tmp    = $_FILES['archivo_excel']['tmp_name'];
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($tmp);
            $reader->setReadDataOnly(true);    // sin estilos
            $reader->setReadEmptyCells(false); // opcional: ignora celdas vacías

            $spreadsheet = $reader->load($tmp);
            unset($reader);
        } catch (Exception $e) {
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Excel inválido: ' . $e->getMessage()]));
        }

        $sheet = $spreadsheet->getSheet(0);
        $rows  = $sheet->toArray(null, true, true, true);

        if (count($rows) < 2) {
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Excel vacío']));
        }
        $toUtf8 = function ($s) {
            if ($s === null) {
                return null;
            }

            $s = (string) $s;
            // Detecta y convierte a UTF-8 si viniera raro (CSV antiguos, copy/paste)
            $enc = mb_detect_encoding($s, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true) ?: 'UTF-8';
            if ($enc !== 'UTF-8') {
                $s = iconv($enc, 'UTF-8//IGNORE', $s);
            }
            // Normaliza acentos compuestos (NFC)
            if (class_exists('Normalizer')) {
                $s = Normalizer::normalize($s, Normalizer::FORM_C);
            }
            return trim($s);
        };
        // Cabeceras robustas (evita trim(null))
        $rawHeaders = $rows[1] ?? [];
        $headers    = [];
        foreach ($rawHeaders as $colLetter => $title) {
            $t = $title === null ? '' : trim((string) $title);
            if ($t !== '') {
                $headers[$colLetter] = $t;
            }

        }
        $index = [];
        foreach ($headers as $colLetter => $title) {$index[$title] = $colLetter;}

        // ===== Helpers lectura =====
        $get = function ($row, $names) use ($index, $toUtf8) {
            $names = is_array($names) ? $names : [$names];
            foreach ($names as $name) {
                if (isset($index[$name])) {
                    $col = $index[$name];
                    return isset($row[$col]) ? $toUtf8($row[$col]) : null; // <- NORMALIZA AQUÍ
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
            $n     = count($parts);

            if ($n === 1) {
                return ['nombre' => $parts[0], 'paterno' => null, 'materno' => null];
            }

            if ($n === 2) {
                // Nombre + Paterno
                return ['nombre' => $parts[0], 'paterno' => $parts[1], 'materno' => null];
            }

            // 3 o más: último = materno, penúltimo = paterno, resto = nombre(s)
            $materno = array_pop($parts);
            $paterno = array_pop($parts);
            $nombre  = implode(' ', $parts);

            return ['nombre' => $nombre, 'paterno' => $paterno, 'materno' => $materno];
        };

        $calcEdad = function ($ymd) {
            if (! $ymd) {
                return null;
            }

            try { $b = new DateTime($ymd);
                $t                             = new DateTime('today');return (int) $b->diff($t)->y;} catch (Exception $e) {return null;}
        };

        // ===== Nombres de columnas =====
        $X_NOMBRE_COMPLETO = 'Task Name';
        $X_TASK_ID         = 'Task ID';

        // Campos fijos bolsa
        $MAP_BOLSA = [
            'domicilio'        => ['Dirección (short text)'],
            'fecha_nacimiento' => ['FECHA DE NACIMIENTO (date)'],
            'telefono'         => ['TELEFONO DE CONTACTO (phone)'],
            'medio_contacto'   => ['Medio de contacto', 'MEDIO DE CONTACTO'],
            'area_interes'     => ['Área de interés', 'AREA INTERES', 'Cliente/Servicio (short text)'],
            'sueldo_deseado'   => ['PAGO MENSUAL (number)'],
        ];

        // Campos fijos empleado
        $MAP_EMPLE = [
            'id_empleado'      => [$X_TASK_ID],
            'nombre'           => [$X_NOMBRE_COMPLETO],
            'telefono'         => ['TELEFONO DE CONTACTO (phone)'],
            'correo'           => ['E-MAIL E.G.C (email)'],
            'departamento'     => ['Departamento', 'Cliente/Servicio (short text)'],
            'puesto'           => ['Puesto', 'Cargo'],
            'rfc'              => ['RFC'],
            'nss'              => ['NSS', 'IMSS'],
            'curp'             => ['N° DE CEDULA (short text)', 'CURP'],
            'foto'             => ['Foto', 'FOTO'],
            'fecha_nacimiento' => ['FECHA DE NACIMIENTO (date)'],
        ];

        // Adjuntos: etiquetas + posibles cabeceras
        $ATTACH_COLS = [
            ['label' => 'Hoja de vida', 'headers' => ['Hoja de vida (attachment)', 'Hoja de vida', 'CV', 'Curriculum', 'Currículum']],
            ['label' => 'Cédula de identidad', 'headers' => ['Cedula Asociado (attachment)', 'Cédula', 'Cedula']],
            ['label' => 'Foto Asociado', 'headers' => ['Foto Asociado (attachment)', 'Foto Asociado', 'Foto']],
            ['label' => 'Acuerdo de Confidencialidad', 'headers' => ['Acuerdo Confidencialidad (attachment)', 'Acuerdo de Confidencialidad']],
            ['label' => 'Convenio de Confidencialidad', 'headers' => ['Convenio de confidencialidad (attachment)', 'Convenio de confidencialidad']],
            ['label' => 'Validación Técnica', 'headers' => ['Validación Técnica (attachment)', 'Validación Técnica']],
            ['label' => 'Informe de cierre', 'headers' => ['informe de cierre de servicio (attachment)', 'Informe de cierre']],
        ];
        $ATTACH_HEADERS = [];
        foreach ($ATTACH_COLS as $def) {
            foreach ($def['headers'] as $h) {
                $ATTACH_HEADERS[] = $h;
            }
        }

        $creacionAhora     = date('Y-m-d H:i:s');
        $insertados_bolsa  = 0;
        $insertados_emp    = 0;
        $extras_rows_total = 0;
        $errores           = [];
        $fallas_descargas  = []; // para swal: listado detallado de fallas de descarga

        // ===== Filas =====
        for ($i = 2; $i <= count($rows); $i++) {
            $r = $rows[$i] ?? [];

            $fullName = isset($index[$X_NOMBRE_COMPLETO]) ? $toUtf8(trim((string) ($r[$index[$X_NOMBRE_COMPLETO]] ?? ''))) : '';
            $np       = $splitNombre($fullName);
            if ($fullName === '') {$errores[] = "Fila $i: nombre vacío";
                continue;}

            // STATUS
            $status_raw = $get($r, ['Status', 'ESTADO', 'Estado', 'status', 'Estatus']);
            $action     = $this->map_status_action($status_raw); // bolsa_status, create_empleado, empleado_status

            // --- Bolsa (datos base) ---
            $domicilio_bt      = $get($r, $MAP_BOLSA['domicilio']);
            $fecha_nac_bt      = $getDateYmd($r, $MAP_BOLSA['fecha_nacimiento']);
            $telefono_bt       = $get($r, $MAP_BOLSA['telefono']) ?: '';
            $medio_contacto_bt = $get($r, $MAP_BOLSA['medio_contacto']);
            $area_interes_bt   = $get($r, $MAP_BOLSA['area_interes']);
            $sueldo_deseado_bt = $getNumber($r, $MAP_BOLSA['sueldo_deseado']);

            if ($telefono_bt === '') {$errores[] = "Fila $i ({$fullName}): teléfono vacío";
                continue;}

            // Excluir adjuntos de extras
            $used_bolsa = [$X_NOMBRE_COMPLETO];
            foreach ($MAP_BOLSA as $arr) {
                foreach ((array) $arr as $hn) {
                    $used_bolsa[] = $hn;
                }
            }

            $used_bolsa = array_merge($used_bolsa, $ATTACH_HEADERS);

            // extras iniciales (sin adjuntos)
            $extras_bolsa = [];
            foreach ($headers as $colKey => $headerName) {
                $headerName = trim($headerName);
                if ($headerName === '' || in_array($headerName, $used_bolsa, true)) {
                    continue;
                }

                $valx = isset($r[$colKey]) ? $r[$colKey] : null;
                if ($valx === null || $valx === '') {
                    continue;
                }

                if (is_numeric($valx) && $valx > 20000 && $valx < 60000) {
                    try { $valx = XlsDate::excelToDateTimeObject($valx)->format('Y-m-d');} catch (Exception $e) {}
                }
                $extras_bolsa[$headerName] = $toUtf8($valx);
            }

            $data_bolsa = [
                'creacion'         => $creacionAhora,
                'edicion'          => null,
                'id_portal'        => $id_portal,
                'id_usuario'       => $id_usuario,
                'nombre'           => $toUtf8($np['nombre']),
                'paterno'          => $toUtf8($np['paterno']),
                'materno'          => $toUtf8($np['materno']),
                'domicilio'        => $toUtf8($domicilio_bt),
                'fecha_nacimiento' => $fecha_nac_bt,
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
                'medio_contacto'   => $toUtf8($medio_contacto_bt),
                'area_interes'     => $toUtf8($area_interes_bt),
                'sueldo_deseado'   => $sueldo_deseado_bt !== null ? (string) $sueldo_deseado_bt : null,
                'otros_ingresos'   => null,
                'viajar'           => null,
                'trabajar'         => null,
                'comentario'       => null,
                'extras'           => json_encode($extras_bolsa, JSON_UNESCAPED_UNICODE),
                'status'           => $action['bolsa_status'],
                'semaforo'         => 0,
            ];
            // === Anti-duplicado SIMPLE (bolsa_trabajo) =============================
            $tel_clean = preg_replace('/\D+/', '', (string) $telefono_bt);
            $norm      = function ($s) {
                $s = @iconv('UTF-8', 'ASCII//TRANSLIT', (string) $s);
                return strtolower(preg_replace('/[^a-z0-9]+/', '', $s));
            };
            $nom = $norm($np['nombre'] ?? '');
            $pat = $norm($np['paterno'] ?? '');
            $mat = $norm($np['materno'] ?? '');

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
            if ($dup_id) {
                $this->db->where('id', $dup_id)->update('bolsa_trabajo', [
                    'edicion' => date('Y-m-d H:i:s'),
                    'status'  => $action['bolsa_status'] ?? 1,
                    'extras'  => json_encode($extras_bolsa, JSON_UNESCAPED_UNICODE),
                ]);
                $errores[] = "Fila $i ({$fullName}): duplicado — se actualizó (id=$dup_id)";
                continue;
            }

            // ======================================================================

            $this->db->trans_start();

            $ok_b = $this->db->insert('bolsa_trabajo', $data_bolsa);
            if (! $ok_b) {
                $this->db->trans_complete();
                $errores[] = "Fila $i ({$fullName}): error al insertar en bolsa_trabajo";
                continue;
            }
            $insertados_bolsa++;
            $id_bolsa = $this->db->insert_id();

            $id_empleado_pk  = null;
            $failed_bolsa    = []; // label => [urls]
            $failed_empleado = []; // label => [urls]

            // --- Empleado (si aplica por STATUS) ---
            if ($action['create_empleado']) {
                $tel_emp    = $get($r, $MAP_EMPLE['telefono']);
                $correo_emp = $get($r, $MAP_EMPLE['correo']);
                $dep_emp    = $get($r, $MAP_EMPLE['departamento']);
                $pto_emp    = $get($r, $MAP_EMPLE['puesto']);
                $rfc_emp    = $get($r, $MAP_EMPLE['rfc']);
                $nss_emp    = $get($r, $MAP_EMPLE['nss']);
                $curp_emp   = $get($r, $MAP_EMPLE['curp']);
                $foto_emp   = $get($r, $MAP_EMPLE['foto']);
                $fnac_emp   = $getDateYmd($r, $MAP_EMPLE['fecha_nacimiento']);
                $id_emp_ext = $get($r, $MAP_EMPLE['id_empleado']);
                $id_emp_ext = ($id_emp_ext !== null && $id_emp_ext !== '') ? mb_substr(trim((string) $id_emp_ext), 0, 50) : null;

                $data_emp = [
                    'creacion'              => $creacionAhora,
                    'edicion'               => null,
                    'id_portal'             => $id_portal ?: null,
                    'id_cliente'            => $id_cliente ?: null,
                    'id_usuario'            => $id_usuario ?: null,
                    'id_empleado'           => $id_emp_ext,
                    'id_domicilio_empleado' => null,
                    'nombre'                => $np['nombre'] ?: null,
                    'paterno'               => $np['paterno'],
                    'materno'               => $np['materno'],
                    'telefono'              => $tel_emp ?: $telefono_bt,
                    'correo'                => $correo_emp,
                    'departamento'          => $dep_emp,
                    'puesto'                => $pto_emp,
                    'rfc'                   => $rfc_emp,
                    'nss'                   => $nss_emp,
                    'curp'                  => $curp_emp,
                    'foto'                  => $foto_emp,
                    'fecha_nacimiento'      => $fnac_emp,
                    'id_bolsa'              => $id_bolsa,
                    'status'                => $action['empleado_status'], // 3 cuando es Contratado
                    'eliminado'             => 0,
                ];

                $ok_e = $this->db->insert('empleados', $data_emp);
                if (! $ok_e) {
                    $this->db->trans_complete();
                    $errores[] = "Fila $i ({$fullName}): error al insertar en empleados";
                    continue;
                }
                $insertados_emp++;
                $id_empleado_pk = $this->db->insert_id();

                // Extras de empleado (excluyendo adjuntos)
                $used_emple = [];
                foreach ($MAP_EMPLE as $arr) {
                    foreach ((array) $arr as $hn) {
                        $used_emple[] = $hn;
                    }
                }

                $used_emple[] = $X_NOMBRE_COMPLETO;
                $used_emple   = array_merge($used_emple, $ATTACH_HEADERS);

                $extras_rows = [];
                foreach ($headers as $colKey => $headerName) {
                    $headerName = trim($headerName);
                    if ($headerName === '' || in_array($headerName, $used_emple, true)) {
                        continue;
                    }

                    $valx = isset($r[$colKey]) ? $r[$colKey] : null;
                    if ($valx === null || $valx === '') {
                        continue;
                    }

                    if (is_numeric($valx) && $valx > 20000 && $valx < 60000) {
                        try { $valx = XlsDate::excelToDateTimeObject($valx)->format('Y-m-d');} catch (Exception $e) {}
                    }

                    $extras_rows[] = [
                        'id_empleado' => $id_empleado_pk,
                        'nombre'      => mb_substr($headerName, 0, 255),
                        'valor'       => mb_substr((string) $valx, 0, 255),
                    ];
                }

                if (! empty($extras_rows)) {
                    $this->db->insert_batch('empleado_campos_extra', $extras_rows);
                    $extras_rows_total += count($extras_rows);
                }
            }
            // --- DOCUMENTOS: intenta descargar; SOLO inserta si la descarga fue OK ---
            foreach ($ATTACH_COLS as $def) {
                $label = $def['label'];
                $urls  = [];

                foreach ($def['headers'] as $hname) {
                    if (! isset($index[$hname])) {
                        continue;
                    }

                    $colLetter = $index[$hname];
                    $colIndex  = Coordinate::columnIndexFromString($colLetter);

                    // Hipervínculo real de la celda
                    $cell = $sheet->getCellByColumnAndRow($colIndex, $i);
                    if ($cell && $cell->hasHyperlink()) {
                        $u = trim((string) $cell->getHyperlink()->getUrl());
                        if ($u !== '') {
                            $urls[] = $u;
                        }

                    }
                    // Texto visible con posibles URLs
                    $visible = isset($rows[$i][$colLetter]) ? (string) $rows[$i][$colLetter] : '';
                    if ($visible !== '') {
                        foreach ($this->extract_urls($visible) as $u2) {
                            $urls[] = $u2;
                        }

                    }
                }

                if (empty($urls)) {
                    continue;
                }

                $urls = array_values(array_unique($urls));

                foreach ($urls as $u) {
                    $uNorm = $this->normalize_share_url($u);

                    // ===== Bolsa =====
                    $bolRes = $this->save_remote_file(
                        $uNorm,
                        $this->path_docs_bolsa,
                        "bolsa_{$id_bolsa}_" . $this->slug($label)
                    );

                    // Considera OK solo si devolvió ok, existe el archivo y tiene tamaño > 0
                    $bol_ok = ($bolRes['ok'] ?? false)
                    && isset($bolRes['path'])
                    && is_file($bolRes['path'])
                    && filesize($bolRes['path']) > 0;

                    if ($bol_ok) {
                        $this->insert_doc_bolsa($id_bolsa, $id_usuario, basename($bolRes['path']), $label);
                    } else {
                        // NO insertes en documentos_bolsa: guárdalo como FALLO para pasarlo a EXTRAS
                        if (! empty($bolRes['path']) && is_file($bolRes['path'])) {
                            @unlink($bolRes['path']);
                        }
                        // limpia basura
                        $failed_bolsa[$label][] = $uNorm;
                        $fallas_descargas[]     = [
                            'fila'      => $i,
                            'nombre'    => $fullName,
                            'entidad'   => 'bolsa',
                            'label'     => $label,
                            'url'       => $uNorm,
                            'http_code' => $bolRes['http_code'] ?? 0,
                            'error'     => $bolRes['error'] ?? 'Descarga fallida',
                        ];
                    }

                    // ===== Empleado (si se creó) =====
                    if ($id_empleado_pk) {
                        $empRes = $this->save_remote_file(
                            $uNorm,
                            $this->path_docs_empleado,
                            "emp_{$id_empleado_pk}_" . $this->slug($label)
                        );

                        $emp_ok = ($empRes['ok'] ?? false)
                        && isset($empRes['path'])
                        && is_file($empRes['path'])
                        && filesize($empRes['path']) > 0;

                        if ($emp_ok) {
                            $this->insert_doc_empleado($id_empleado_pk, basename($empRes['path']), $label);
                        } else {
                            if (! empty($empRes['path']) && is_file($empRes['path'])) {
                                @unlink($empRes['path']);
                            }

                            $failed_empleado[$label][] = $uNorm;
                            $fallas_descargas[]        = [
                                'fila'      => $i,
                                'nombre'    => $fullName,
                                'entidad'   => 'empleado',
                                'label'     => $label,
                                'url'       => $uNorm,
                                'http_code' => $empRes['http_code'] ?? 0,
                                'error'     => $empRes['error'] ?? 'Descarga fallida',
                            ];
                        }
                    }
                }
            }

            // --- Si hubo fallas: agregar links a EXTRAS ---
            if (! empty($failed_bolsa)) {
                $extras_merge = $extras_bolsa;
                foreach ($failed_bolsa as $key => $urlsFail) {
                    $extras_merge[$key] = implode(' ', array_unique($urlsFail));
                }
                $this->db->where('id', $id_bolsa)->update('bolsa_trabajo', [
                    'extras' => json_encode($extras_merge, JSON_UNESCAPED_UNICODE),
                ]);
            }
            if ($id_empleado_pk && ! empty($failed_empleado)) {
                $rowsFail = [];
                foreach ($failed_empleado as $key => $urlsFail) {
                    $rowsFail[] = [
                        'id_empleado' => $id_empleado_pk,
                        'nombre'      => mb_substr($key, 0, 255),
                        'valor'       => mb_substr(implode(' ', array_unique($urlsFail)), 0, 255),
                    ];
                }
                if (! empty($rowsFail)) {
                    $this->db->insert_batch('empleado_campos_extra', $rowsFail);
                }

            }

            $this->db->trans_complete();
            if ($this->db->trans_status() === false) {
                $errores[] = "Fila $i ({$fullName}): transacción fallida";
            }
        }
        if (isset($sheet)) {unset($sheet);}
        if (isset($spreadsheet)) {
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
        }
        gc_collect_cycles();

        return $this->output->set_output(json_encode([
            'ok'                   => true,
            'bolsa_insertados'     => $insertados_bolsa,
            'empleados_insertados' => $insertados_emp,
            'empleado_extras_rows' => $extras_rows_total,
            'errores'              => $errores,
            'fallas_descargas'     => $fallas_descargas, // <- para SweetAlert
        ]));
    }
    */
    public function importar()
    {
        /* ===== Booster SOLO para esta petición ===== */
        @ini_set('max_execution_time', '900');     // 15 min
        @ini_set('memory_limit', '1024M');         // sube si tu Excel es MUY grande
        @ini_set('default_socket_timeout', '120'); // por si descargas URLs

        $this->output->set_content_type('application/json', 'utf-8');

        if (empty($_FILES['archivo_excel']['name'])) {
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Sube un archivo Excel']));
        }

        $id_portal  = (int) ($this->session->userdata('idPortal') ?: 1);
        $id_usuario = (int) ($this->session->userdata('id') ?: 1);
        $id_cliente = (int) ($this->input->post('id_cliente') ?: null); // opcional

        try {
            // === Cargar Excel con lector en modo "read-only" (sin cachés especiales) ===
            $tmp    = $_FILES['archivo_excel']['tmp_name'];
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($tmp);

            // Estas opciones existen para Xlsx/Xls/Csv; si no existen, no pasa nada
            if (method_exists($reader, 'setReadDataOnly')) {
                $reader->setReadDataOnly(true);
            }
            if (method_exists($reader, 'setReadEmptyCells')) {
                $reader->setReadEmptyCells(false);
            }

            $spreadsheet = $reader->load($tmp);
            unset($reader);
        } catch (Exception $e) {
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Excel inválido: ' . $e->getMessage()]));
        }

        $sheet = $spreadsheet->getSheet(0);
        $rows  = $sheet->toArray(null, true, true, true);

        if (count($rows) < 2) {
            if (isset($sheet)) {unset($sheet);}
            if (isset($spreadsheet)) {$spreadsheet->disconnectWorksheets();unset($spreadsheet);}
            gc_collect_cycles();
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Excel vacío']));
        }

        $toUtf8 = function ($s) {
            if ($s === null) {
                return null;
            }

            $s   = (string) $s;
            $enc = mb_detect_encoding($s, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true) ?: 'UTF-8';
            if ($enc !== 'UTF-8') {$s = iconv($enc, 'UTF-8//IGNORE', $s);}
            if (class_exists('Normalizer')) {$s = Normalizer::normalize($s, Normalizer::FORM_C);}
            return trim($s);
        };

        // Cabeceras robustas (evita trim(null))
        $rawHeaders = $rows[1] ?? [];
        $headers    = [];
        foreach ($rawHeaders as $colLetter => $title) {
            $t = $title === null ? '' : trim((string) $title);
            if ($t !== '') {
                $headers[$colLetter] = $t;
            }

        }
        $index = [];
        foreach ($headers as $colLetter => $title) {$index[$title] = $colLetter;}

        // ===== Helpers lectura =====
        $get = function ($row, $names) use ($index, $toUtf8) {
            $names = is_array($names) ? $names : [$names];
            foreach ($names as $name) {
                if (isset($index[$name])) {
                    $col = $index[$name];
                    return isset($row[$col]) ? $toUtf8($row[$col]) : null; // normaliza aquí
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
            $n     = count($parts);
            if ($n === 1) {
                return ['nombre' => $parts[0], 'paterno' => null, 'materno' => null];
            }

            if ($n === 2) {
                return ['nombre' => $parts[0], 'paterno' => $parts[1], 'materno' => null];
            }

            $materno = array_pop($parts);
            $paterno = array_pop($parts);
            $nombre  = implode(' ', $parts);
            return ['nombre' => $nombre, 'paterno' => $paterno, 'materno' => $materno];
        };
        $calcEdad = function ($ymd) {
            if (! $ymd) {
                return null;
            }

            try { $b = new DateTime($ymd);
                $t                             = new DateTime('today');return (int) $b->diff($t)->y;} catch (Exception $e) {return null;}
        };

        // ===== Nombres de columnas =====
        $X_NOMBRE_COMPLETO = 'Task Name';
        $X_TASK_ID         = 'Task ID';

        // Campos fijos bolsa
        $MAP_BOLSA = [
            'domicilio'        => ['Dirección (short text)'],
            'fecha_nacimiento' => ['FECHA DE NACIMIENTO (date)'],
            'telefono'         => ['TELEFONO DE CONTACTO (phone)'],
            'medio_contacto'   => ['Medio de contacto', 'MEDIO DE CONTACTO'],
            'area_interes'     => ['Área de interés', 'AREA INTERES', 'Cliente/Servicio (short text)'],
            'sueldo_deseado'   => ['PAGO MENSUAL (number)'],
        ];

        // Campos fijos empleado
        $MAP_EMPLE = [
            'id_empleado'      => [$X_TASK_ID],
            'nombre'           => [$X_NOMBRE_COMPLETO],
            'telefono'         => ['TELEFONO DE CONTACTO (phone)'],
            'correo'           => ['E-MAIL E.G.C (email)'],
            'departamento'     => ['Departamento', 'Cliente/Servicio (short text)'],
            'puesto'           => ['Puesto', 'Cargo'],
            'rfc'              => ['RFC'],
            'nss'              => ['NSS', 'IMSS'],
            'curp'             => ['N° DE CEDULA (short text)', 'CURP'],
            'foto'             => ['Foto', 'FOTO'],
            'fecha_nacimiento' => ['FECHA DE NACIMIENTO (date)'],
        ];

        // Adjuntos: etiquetas + posibles cabeceras
        $ATTACH_COLS = [
            ['label' => 'Hoja de vida', 'headers' => ['Hoja de vida (attachment)', 'Hoja de vida', 'CV', 'Curriculum', 'Currículum']],
            ['label' => 'Cédula de identidad', 'headers' => ['Cedula Asociado (attachment)', 'Cédula', 'Cedula']],
            ['label' => 'Foto Asociado', 'headers' => ['Foto Asociado (attachment)', 'Foto Asociado', 'Foto']],
            ['label' => 'Acuerdo de Confidencialidad', 'headers' => ['Acuerdo Confidencialidad (attachment)', 'Acuerdo de Confidencialidad']],
            ['label' => 'Convenio de Confidencialidad', 'headers' => ['Convenio de confidencialidad (attachment)', 'Convenio de confidencialidad']],
            ['label' => 'Validación Técnica', 'headers' => ['Validación Técnica (attachment)', 'Validación Técnica']],
            ['label' => 'Informe de cierre', 'headers' => ['informe de cierre de servicio (attachment)', 'Informe de cierre']],
        ];
        $ATTACH_HEADERS = [];
        foreach ($ATTACH_COLS as $def) {
            foreach ($def['headers'] as $h) {
                $ATTACH_HEADERS[] = $h;
            }
        }

        $creacionAhora     = date('Y-m-d H:i:s');
        $insertados_bolsa  = 0;
        $insertados_emp    = 0;
        $extras_rows_total = 0;
        $errores           = [];
        $fallas_descargas  = []; // para swal: listado detallado de fallas de descarga

        // ===== Filas =====
        for ($i = 2; $i <= count($rows); $i++) {
            $r = $rows[$i] ?? [];

            $fullName = isset($index[$X_NOMBRE_COMPLETO]) ? $toUtf8(trim((string) ($r[$index[$X_NOMBRE_COMPLETO]] ?? ''))) : '';
            $np       = $splitNombre($fullName);
            if ($fullName === '') {$errores[] = "Fila $i: nombre vacío";
                continue;}

            // STATUS
            $status_raw = $get($r, ['Status', 'ESTADO', 'Estado', 'status', 'Estatus']);
            $action     = $this->map_status_action($status_raw); // bolsa_status, create_empleado, empleado_status

            // --- Bolsa (datos base) ---
            $domicilio_bt      = $get($r, $MAP_BOLSA['domicilio']);
            $fecha_nac_bt      = $getDateYmd($r, $MAP_BOLSA['fecha_nacimiento']);
            $telefono_bt       = $get($r, $MAP_BOLSA['telefono']) ?: '';
            $medio_contacto_bt = $get($r, $MAP_BOLSA['medio_contacto']);
            $area_interes_bt   = $get($r, $MAP_BOLSA['area_interes']);
            $sueldo_deseado_bt = $getNumber($r, $MAP_BOLSA['sueldo_deseado']);

            if ($telefono_bt === '') {$errores[] = "Fila $i ({$fullName}): teléfono vacío";
                continue;}

            // Excluir adjuntos de extras
            $used_bolsa = [$X_NOMBRE_COMPLETO];
            foreach ($MAP_BOLSA as $arr) {
                foreach ((array) $arr as $hn) {
                    $used_bolsa[] = $hn;
                }
            }

            $used_bolsa = array_merge($used_bolsa, $ATTACH_HEADERS);

            // extras iniciales (sin adjuntos)
            $extras_bolsa = [];
            foreach ($headers as $colKey => $headerName) {
                $headerName = trim($headerName);
                if ($headerName === '' || in_array($headerName, $used_bolsa, true)) {
                    continue;
                }

                $valx = isset($r[$colKey]) ? $r[$colKey] : null;
                if ($valx === null || $valx === '') {
                    continue;
                }

                if (is_numeric($valx) && $valx > 20000 && $valx < 60000) {
                    try { $valx = XlsDate::excelToDateTimeObject($valx)->format('Y-m-d');} catch (Exception $e) {}
                }
                $extras_bolsa[$headerName] = $toUtf8($valx);
            }

            $data_bolsa = [
                'creacion'         => $creacionAhora,
                'edicion'          => null,
                'id_portal'        => $id_portal,
                'id_usuario'       => $id_usuario,
                'nombre'           => $toUtf8($np['nombre']),
                'paterno'          => $toUtf8($np['paterno']),
                'materno'          => $toUtf8($np['materno']),
                'domicilio'        => $toUtf8($domicilio_bt),
                'fecha_nacimiento' => $fecha_nac_bt,
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
                'medio_contacto'   => $toUtf8($medio_contacto_bt),
                'area_interes'     => $toUtf8($area_interes_bt),
                'sueldo_deseado'   => $sueldo_deseado_bt !== null ? (string) $sueldo_deseado_bt : null,
                'otros_ingresos'   => null,
                'viajar'           => null,
                'trabajar'         => null,
                'comentario'       => null,
                'extras'           => json_encode($extras_bolsa, JSON_UNESCAPED_UNICODE),
                'status'           => $action['bolsa_status'],
                'semaforo'         => 0,
            ];

            // === Anti-duplicado SIMPLE (bolsa_trabajo) =============================
            $tel_clean = preg_replace('/\D+/', '', (string) $telefono_bt);
            $norm      = function ($s) {
                $s = @iconv('UTF-8', 'ASCII//TRANSLIT', (string) $s);
                return strtolower(preg_replace('/[^a-z0-9]+/', '', $s));
            };
            $nom = $norm($np['nombre'] ?? '');
            $pat = $norm($np['paterno'] ?? '');
            $mat = $norm($np['materno'] ?? '');

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
            if ($dup_id) {
                $this->db->where('id', $dup_id)->update('bolsa_trabajo', [
                    'edicion' => date('Y-m-d H:i:s'),
                    'status'  => $action['bolsa_status'] ?? 1,
                    'extras'  => json_encode($extras_bolsa, JSON_UNESCAPED_UNICODE),
                ]);
                $errores[] = "Fila $i ({$fullName}): duplicado — se actualizó (id=$dup_id)";
                continue;
            }
            // ======================================================================

            $this->db->trans_start();

            $ok_b = $this->db->insert('bolsa_trabajo', $data_bolsa);
            if (! $ok_b) {
                $this->db->trans_complete();
                $errores[] = "Fila $i ({$fullName}): error al insertar en bolsa_trabajo";
                continue;
            }
            $insertados_bolsa++;
            $id_bolsa = $this->db->insert_id();

            $id_empleado_pk  = null;
            $failed_bolsa    = []; // label => [urls]
            $failed_empleado = []; // label => [urls]

            // --- Empleado (si aplica por STATUS) ---
            if ($action['create_empleado']) {
                $tel_emp    = $get($r, $MAP_EMPLE['telefono']);
                $correo_emp = $get($r, $MAP_EMPLE['correo']);
                $dep_emp    = $get($r, $MAP_EMPLE['departamento']);
                $pto_emp    = $get($r, $MAP_EMPLE['puesto']);
                $rfc_emp    = $get($r, $MAP_EMPLE['rfc']);
                $nss_emp    = $get($r, $MAP_EMPLE['nss']);
                $curp_emp   = $get($r, $MAP_EMPLE['curp']);
                $foto_emp   = $get($r, $MAP_EMPLE['foto']);
                $fnac_emp   = $getDateYmd($r, $MAP_EMPLE['fecha_nacimiento']);
                $id_emp_ext = $get($r, $MAP_EMPLE['id_empleado']);
                $id_emp_ext = ($id_emp_ext !== null && $id_emp_ext !== '') ? mb_substr(trim((string) $id_emp_ext), 0, 50) : null;

                $data_emp = [
                    'creacion'              => $creacionAhora,
                    'edicion'               => null,
                    'id_portal'             => $id_portal ?: null,
                    'id_cliente'            => $id_cliente ?: null,
                    'id_usuario'            => $id_usuario ?: null,
                    'id_empleado'           => $id_emp_ext,
                    'id_domicilio_empleado' => null,
                    'nombre'                => $np['nombre'] ?: null,
                    'paterno'               => $np['paterno'],
                    'materno'               => $np['materno'],
                    'telefono'              => $tel_emp ?: $telefono_bt,
                    'correo'                => $correo_emp,
                    'departamento'          => $dep_emp,
                    'puesto'                => $pto_emp,
                    'rfc'                   => $rfc_emp,
                    'nss'                   => $nss_emp,
                    'curp'                  => $curp_emp,
                    'foto'                  => $foto_emp,
                    'fecha_nacimiento'      => $fnac_emp,
                    'id_bolsa'              => $id_bolsa,
                    'status'                => $action['empleado_status'], // 3 cuando es Contratado
                    'eliminado'             => 0,
                ];

                $ok_e = $this->db->insert('empleados', $data_emp);
                if (! $ok_e) {
                    $this->db->trans_complete();
                    $errores[] = "Fila $i ({$fullName}): error al insertar en empleados";
                    continue;
                }
                $insertados_emp++;
                $id_empleado_pk = $this->db->insert_id();

                // Extras de empleado (excluyendo adjuntos)
                $used_emple = [];
                foreach ($MAP_EMPLE as $arr) {
                    foreach ((array) $arr as $hn) {
                        $used_emple[] = $hn;
                    }
                }

                $used_emple[] = $X_NOMBRE_COMPLETO;
                $used_emple   = array_merge($used_emple, $ATTACH_HEADERS);

                $extras_rows = [];
                foreach ($headers as $colKey => $headerName) {
                    $headerName = trim($headerName);
                    if ($headerName === '' || in_array($headerName, $used_emple, true)) {
                        continue;
                    }

                    $valx = isset($r[$colKey]) ? $r[$colKey] : null;
                    if ($valx === null || $valx === '') {
                        continue;
                    }

                    if (is_numeric($valx) && $valx > 20000 && $valx < 60000) {
                        try { $valx = XlsDate::excelToDateTimeObject($valx)->format('Y-m-d');} catch (Exception $e) {}
                    }

                    $extras_rows[] = [
                        'id_empleado' => $id_empleado_pk,
                        'nombre'      => mb_substr($headerName, 0, 255),
                        'valor'       => mb_substr((string) $valx, 0, 255),
                    ];
                }

                if (! empty($extras_rows)) {
                    $this->db->insert_batch('empleado_campos_extra', $extras_rows);
                    $extras_rows_total += count($extras_rows);
                }
            }

            // --- DOCUMENTOS: intenta descargar; SOLO inserta si la descarga fue OK ---
            foreach ($ATTACH_COLS as $def) {
                $label = $def['label'];
                $urls  = [];

                foreach ($def['headers'] as $hname) {
                    if (! isset($index[$hname])) {
                        continue;
                    }

                    $colLetter = $index[$hname];
                    $colIndex  = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($colLetter);

                    // Hipervínculo real de la celda
                    $cell = $sheet->getCellByColumnAndRow($colIndex, $i);
                    if ($cell && $cell->hasHyperlink()) {
                        $u = trim((string) $cell->getHyperlink()->getUrl());
                        if ($u !== '') {
                            $urls[] = $u;
                        }

                    }
                    // Texto visible con posibles URLs
                    $visible = isset($rows[$i][$colLetter]) ? (string) $rows[$i][$colLetter] : '';
                    if ($visible !== '') {
                        foreach ($this->extract_urls($visible) as $u2) {
                            $urls[] = $u2;
                        }

                    }
                }

                if (empty($urls)) {
                    continue;
                }

                $urls = array_values(array_unique($urls));

                foreach ($urls as $u) {
                    $uNorm = $this->normalize_share_url($u);

                    // ===== Bolsa =====
                    $bolRes = $this->save_remote_file(
                        $uNorm,
                        $this->path_docs_bolsa,
                        "bolsa_{$id_bolsa}_" . $this->slug($label)
                    );

                    $bol_ok = ($bolRes['ok'] ?? false)
                    && isset($bolRes['path'])
                    && is_file($bolRes['path'])
                    && filesize($bolRes['path']) > 0;

                    if ($bol_ok) {
                        $this->insert_doc_bolsa($id_bolsa, $id_usuario, basename($bolRes['path']), $label);
                    } else {
                        if (! empty($bolRes['path']) && is_file($bolRes['path'])) {@unlink($bolRes['path']);}
                        $failed_bolsa[$label][] = $uNorm;
                        $fallas_descargas[]     = [
                            'fila'      => $i,
                            'nombre'    => $fullName,
                            'entidad'   => 'bolsa',
                            'label'     => $label,
                            'url'       => $uNorm,
                            'http_code' => $bolRes['http_code'] ?? 0,
                            'error'     => $bolRes['error'] ?? 'Descarga fallida',
                        ];
                    }

                    // ===== Empleado (si se creó) =====
                    if ($id_empleado_pk) {
                        $empRes = $this->save_remote_file(
                            $uNorm,
                            $this->path_docs_empleado,
                            "emp_{$id_empleado_pk}_" . $this->slug($label)
                        );

                        $emp_ok = ($empRes['ok'] ?? false)
                        && isset($empRes['path'])
                        && is_file($empRes['path'])
                        && filesize($empRes['path']) > 0;

                        if ($emp_ok) {
                            $this->insert_doc_empleado($id_empleado_pk, basename($empRes['path']), $label);
                        } else {
                            if (! empty($empRes['path']) && is_file($empRes['path'])) {@unlink($empRes['path']);}
                            $failed_empleado[$label][] = $uNorm;
                            $fallas_descargas[]        = [
                                'fila'      => $i,
                                'nombre'    => $fullName,
                                'entidad'   => 'empleado',
                                'label'     => $label,
                                'url'       => $uNorm,
                                'http_code' => $empRes['http_code'] ?? 0,
                                'error'     => $empRes['error'] ?? 'Descarga fallida',
                            ];
                        }
                    }
                }
            }

            // --- Si hubo fallas: agregar links a EXTRAS ---
            if (! empty($failed_bolsa)) {
                $extras_merge = $extras_bolsa;
                foreach ($failed_bolsa as $key => $urlsFail) {
                    $extras_merge[$key] = implode(' ', array_unique($urlsFail));
                }
                $this->db->where('id', $id_bolsa)->update('bolsa_trabajo', [
                    'extras' => json_encode($extras_merge, JSON_UNESCAPED_UNICODE),
                ]);
            }
            if ($id_empleado_pk && ! empty($failed_empleado)) {
                $rowsFail = [];
                foreach ($failed_empleado as $key => $urlsFail) {
                    $rowsFail[] = [
                        'id_empleado' => $id_empleado_pk,
                        'nombre'      => mb_substr($key, 0, 255),
                        'valor'       => mb_substr(implode(' ', array_unique($urlsFail)), 0, 255),
                    ];
                }
                if (! empty($rowsFail)) {
                    $this->db->insert_batch('empleado_campos_extra', $rowsFail);
                }
            }

            $this->db->trans_complete();
            if ($this->db->trans_status() === false) {
                $errores[] = "Fila $i ({$fullName}): transacción fallida";
            }
        }

        // Liberar memoria del spreadsheet
        if (isset($sheet)) {unset($sheet);}
        if (isset($spreadsheet)) {
            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);
        }
        gc_collect_cycles();

        return $this->output->set_output(json_encode([
            'ok'                   => true,
            'bolsa_insertados'     => $insertados_bolsa,
            'empleados_insertados' => $insertados_emp,
            'empleado_extras_rows' => $extras_rows_total,
            'errores'              => $errores,
            'fallas_descargas'     => $fallas_descargas, // <- para SweetAlert
        ]));
    }

    public function importar_streaming()
    {
        /* ===== Booster SOLO para esta petición ===== */
        @ini_set('max_execution_time', '900');     // 15 min
        @ini_set('memory_limit', '1024M');         // ajusta si tu server lo permite
        @ini_set('default_socket_timeout', '120'); // descargas http(s)

        $this->output->set_content_type('application/json', 'utf-8');

        if (empty($_FILES['archivo_excel']['name'])) {
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Sube un archivo Excel']));
        }

        $id_portal  = (int) ($this->session->userdata('idPortal') ?: 1);
        $id_usuario = (int) ($this->session->userdata('id') ?: 1);
        $id_cliente = (int) ($this->input->post('id_cliente') ?: null); // opcional

        // === Carga optimizada en modo lectura y cache a disco ===
        try {
            \PhpOffice\PhpSpreadsheet\Settings::setCacheStorageMethod(
                \PhpOffice\PhpSpreadsheet\CachedObjectStorageFactory::cache_to_discISAM,
                ['dir' => sys_get_temp_dir()]
            );

            $tmp    = $_FILES['archivo_excel']['tmp_name'];
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($tmp);
            $reader->setReadDataOnly(true);
            $reader->setReadEmptyCells(false);

            $spreadsheet = $reader->load($tmp);
            unset($reader);
        } catch (Exception $e) {
            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Excel inválido: ' . $e->getMessage()]));
        }

        $sheet = $spreadsheet->getSheet(0);

        // ===== Helpers =====
        $toUtf8 = function ($s) {
            if ($s === null) {
                return null;
            }

            $s   = (string) $s;
            $enc = mb_detect_encoding($s, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true) ?: 'UTF-8';
            if ($enc !== 'UTF-8') {
                $s = iconv($enc, 'UTF-8//IGNORE', $s);
            }

            if (class_exists('Normalizer')) {
                $s = Normalizer::normalize($s, Normalizer::FORM_C);
            }

            return trim($s);
        };

        // Construye cabeceras desde la fila 1 sin toArray()
        $highestColumn      = $sheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        $headers = []; // ["A"=>"Task Name", "B"=>"Task ID", ...]
        for ($col = 1; $col <= $highestColumnIndex; $col++) {
            $title = trim((string) $sheet->getCellByColumnAndRow($col, 1)->getValue());
            if ($title !== '') {
                $colLetter           = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col);
                $headers[$colLetter] = $title;
            }
        }

        if (empty($headers)) {
            // Sin encabezados útiles
            // Limpieza
            $spreadsheet->disconnectWorksheets();
            unset($sheet, $spreadsheet);
            gc_collect_cycles();

            return $this->output->set_output(json_encode(['ok' => false, 'msg' => 'Excel vacío o sin encabezados']));
        }

        $index = []; // "Task Name" => "A", etc
        foreach ($headers as $colLetter => $title) {$index[$title] = $colLetter;}

        $get = function (array $rowByLetter, $names) use ($index, $toUtf8) {
            $names = is_array($names) ? $names : [$names];
            foreach ($names as $name) {
                if (isset($index[$name])) {
                    $col = $index[$name];
                    return array_key_exists($col, $rowByLetter) ? $toUtf8($rowByLetter[$col]) : null;
                }
            }
            return null;
        };

        $getDateYmd = function (array $rowByLetter, $names) use ($get) {
            $raw = $get($rowByLetter, $names);
            if ($raw === null || $raw === '') {
                return null;
            }

            if (is_numeric($raw)) {
                try {return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($raw)->format('Y-m-d');} catch (Exception $e) {return null;}
            }
            $ts = strtotime($raw);
            return $ts ? date('Y-m-d', $ts) : null;
        };

        $getNumber = function (array $rowByLetter, $names) use ($get) {
            $raw = $get($rowByLetter, $names);
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
            $n     = count($parts);

            if ($n === 1) {
                return ['nombre' => $parts[0], 'paterno' => null, 'materno' => null];
            }

            if ($n === 2) {
                return ['nombre' => $parts[0], 'paterno' => $parts[1], 'materno' => null];
            }

            $materno = array_pop($parts);
            $paterno = array_pop($parts);
            $nombre  = implode(' ', $parts);

            return ['nombre' => $nombre, 'paterno' => $paterno, 'materno' => $materno];
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

        // ===== Nombres de columnas (como tu versión) =====
        $X_NOMBRE_COMPLETO = 'Task Name';
        $X_TASK_ID         = 'Task ID';

        // Campos fijos bolsa
        $MAP_BOLSA = [
            'domicilio'        => ['Dirección (short text)'],
            'fecha_nacimiento' => ['FECHA DE NACIMIENTO (date)'],
            'telefono'         => ['TELEFONO DE CONTACTO (phone)'],
            'medio_contacto'   => ['Medio de contacto', 'MEDIO DE CONTACTO'],
            'area_interes'     => ['Área de interés', 'AREA INTERES', 'Cliente/Servicio (short text)'],
            'sueldo_deseado'   => ['PAGO MENSUAL (number)'],
        ];

        // Campos fijos empleado
        $MAP_EMPLE = [
            'id_empleado'      => [$X_TASK_ID],
            'nombre'           => [$X_NOMBRE_COMPLETO],
            'telefono'         => ['TELEFONO DE CONTACTO (phone)'],
            'correo'           => ['E-MAIL E.G.C (email)'],
            'departamento'     => ['Departamento', 'Cliente/Servicio (short text)'],
            'puesto'           => ['Puesto', 'Cargo'],
            'rfc'              => ['RFC'],
            'nss'              => ['NSS', 'IMSS'],
            'curp'             => ['N° DE CEDULA (short text)', 'CURP'],
            'foto'             => ['Foto', 'FOTO'],
            'fecha_nacimiento' => ['FECHA DE NACIMIENTO (date)'],
        ];

        // Adjuntos: etiquetas + posibles cabeceras
        $ATTACH_COLS = [
            ['label' => 'Hoja de vida', 'headers' => ['Hoja de vida (attachment)', 'Hoja de vida', 'CV', 'Curriculum', 'Currículum']],
            ['label' => 'Cédula de identidad', 'headers' => ['Cedula Asociado (attachment)', 'Cédula', 'Cedula']],
            ['label' => 'Foto Asociado', 'headers' => ['Foto Asociado (attachment)', 'Foto Asociado', 'Foto']],
            ['label' => 'Acuerdo de Confidencialidad', 'headers' => ['Acuerdo Confidencialidad (attachment)', 'Acuerdo de Confidencialidad']],
            ['label' => 'Convenio de Confidencialidad', 'headers' => ['Convenio de confidencialidad (attachment)', 'Convenio de confidencialidad']],
            ['label' => 'Validación Técnica', 'headers' => ['Validación Técnica (attachment)', 'Validación Técnica']],
            ['label' => 'Informe de cierre', 'headers' => ['informe de cierre de servicio (attachment)', 'Informe de cierre']],
        ];

        $ATTACH_HEADERS = [];
        foreach ($ATTACH_COLS as $def) {
            foreach ($def['headers'] as $h) {
                $ATTACH_HEADERS[] = $h;
            }

        }

        $creacionAhora     = date('Y-m-d H:i:s');
        $insertados_bolsa  = 0;
        $insertados_emp    = 0;
        $extras_rows_total = 0;
        $errores           = [];
        $fallas_descargas  = [];

                                                  // ===== Iteración fila-a-fila (streaming) =====
        $rowIterator = $sheet->getRowIterator(2); // desde fila 2
        foreach ($rowIterator as $rowObj) {
            $i = $rowObj->getRowIndex();

            // Arma el array "fila" mapeado por letra de columna (compatible con tu $get)
            $r            = [];
            $cellIterator = $rowObj->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            foreach ($cellIterator as $cell) {
                $colLetter     = $cell->getColumn();
                $r[$colLetter] = $cell->getValue();
            }

            // === Comienza tu misma lógica ===
            $fullName = isset($index[$X_NOMBRE_COMPLETO])
                ? $toUtf8(trim((string) ($r[$index[$X_NOMBRE_COMPLETO]] ?? '')))
                : '';

            $np = $splitNombre($fullName);
            if ($fullName === '') {$errores[] = "Fila $i: nombre vacío";
                continue;}

            // STATUS
            $status_raw = $get($r, ['Status', 'ESTADO', 'Estado', 'status', 'Estatus']);
            $action     = $this->map_status_action($status_raw); // bolsa_status, create_empleado, empleado_status

            // --- Bolsa (datos base) ---
            $domicilio_bt      = $get($r, $MAP_BOLSA['domicilio']);
            $fecha_nac_bt      = $getDateYmd($r, $MAP_BOLSA['fecha_nacimiento']);
            $telefono_bt       = $get($r, $MAP_BOLSA['telefono']) ?: '';
            $medio_contacto_bt = $get($r, $MAP_BOLSA['medio_contacto']);
            $area_interes_bt   = $get($r, $MAP_BOLSA['area_interes']);
            $sueldo_deseado_bt = $getNumber($r, $MAP_BOLSA['sueldo_deseado']);

            if ($telefono_bt === '') {$errores[] = "Fila $i ({$fullName}): teléfono vacío";
                continue;}

            // Excluir adjuntos de extras
            $used_bolsa = [$X_NOMBRE_COMPLETO];
            foreach ($MAP_BOLSA as $arr) {
                foreach ((array) $arr as $hn) {
                    $used_bolsa[] = $hn;
                }
            }

            $used_bolsa = array_merge($used_bolsa, $ATTACH_HEADERS);

            // extras iniciales (sin adjuntos)
            $extras_bolsa = [];
            foreach ($headers as $colKey => $headerName) {
                $headerName = trim($headerName);
                if ($headerName === '' || in_array($headerName, $used_bolsa, true)) {
                    continue;
                }

                $valx = array_key_exists($colKey, $r) ? $r[$colKey] : null;
                if ($valx === null || $valx === '') {
                    continue;
                }

                if (is_numeric($valx) && $valx > 20000 && $valx < 60000) {
                    try { $valx = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($valx)->format('Y-m-d');} catch (Exception $e) {}
                }
                $extras_bolsa[$headerName] = $toUtf8($valx);
            }

            $data_bolsa = [
                'creacion'         => $creacionAhora,
                'edicion'          => null,
                'id_portal'        => $id_portal,
                'id_usuario'       => $id_usuario,
                'nombre'           => $toUtf8($np['nombre']),
                'paterno'          => $toUtf8($np['paterno']),
                'materno'          => $toUtf8($np['materno']),
                'domicilio'        => $toUtf8($domicilio_bt),
                'fecha_nacimiento' => $fecha_nac_bt,
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
                'medio_contacto'   => $toUtf8($medio_contacto_bt),
                'area_interes'     => $toUtf8($area_interes_bt),
                'sueldo_deseado'   => $sueldo_deseado_bt !== null ? (string) $sueldo_deseado_bt : null,
                'otros_ingresos'   => null,
                'viajar'           => null,
                'trabajar'         => null,
                'comentario'       => null,
                'extras'           => json_encode($extras_bolsa, JSON_UNESCAPED_UNICODE),
                'status'           => $action['bolsa_status'],
                'semaforo'         => 0,
            ];

            // === Anti-duplicado SIMPLE (bolsa_trabajo) ===
            $tel_clean = preg_replace('/\D+/', '', (string) $telefono_bt);
            $norm      = function ($s) {
                $s = @iconv('UTF-8', 'ASCII//TRANSLIT', (string) $s);
                return strtolower(preg_replace('/[^a-z0-9]+/', '', $s));
            };
            $nom = $norm($np['nombre'] ?? '');
            $pat = $norm($np['paterno'] ?? '');
            $mat = $norm($np['materno'] ?? '');

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
            if ($dup_id) {
                $this->db->where('id', $dup_id)->update('bolsa_trabajo', [
                    'edicion' => date('Y-m-d H:i:s'),
                    'status'  => $action['bolsa_status'] ?? 1,
                    'extras'  => json_encode($extras_bolsa, JSON_UNESCAPED_UNICODE),
                ]);
                $errores[] = "Fila $i ({$fullName}): duplicado — se actualizó (id=$dup_id)";
                continue;
            }

            // === Transacción de inserciones ===
            $this->db->trans_start();

            $ok_b = $this->db->insert('bolsa_trabajo', $data_bolsa);
            if (! $ok_b) {
                $this->db->trans_complete();
                $errores[] = "Fila $i ({$fullName}): error al insertar en bolsa_trabajo";
                continue;
            }
            $insertados_bolsa++;
            $id_bolsa = $this->db->insert_id();

            $id_empleado_pk  = null;
            $failed_bolsa    = []; // label => [urls]
            $failed_empleado = []; // label => [urls]

            // --- Empleado (si aplica por STATUS) ---
            if ($action['create_empleado']) {
                $tel_emp    = $get($r, $MAP_EMPLE['telefono']);
                $correo_emp = $get($r, $MAP_EMPLE['correo']);
                $dep_emp    = $get($r, $MAP_EMPLE['departamento']);
                $pto_emp    = $get($r, $MAP_EMPLE['puesto']);
                $rfc_emp    = $get($r, $MAP_EMPLE['rfc']);
                $nss_emp    = $get($r, $MAP_EMPLE['nss']);
                $curp_emp   = $get($r, $MAP_EMPLE['curp']);
                $foto_emp   = $get($r, $MAP_EMPLE['foto']);
                $fnac_emp   = $getDateYmd($r, $MAP_EMPLE['fecha_nacimiento']);
                $id_emp_ext = $get($r, $MAP_EMPLE['id_empleado']);
                $id_emp_ext = ($id_emp_ext !== null && $id_emp_ext !== '') ? mb_substr(trim((string) $id_emp_ext), 0, 50) : null;

                $data_emp = [
                    'creacion'              => $creacionAhora,
                    'edicion'               => null,
                    'id_portal'             => $id_portal ?: null,
                    'id_cliente'            => $id_cliente ?: null,
                    'id_usuario'            => $id_usuario ?: null,
                    'id_empleado'           => $id_emp_ext,
                    'id_domicilio_empleado' => null,
                    'nombre'                => $np['nombre'] ?: null,
                    'paterno'               => $np['paterno'],
                    'materno'               => $np['materno'],
                    'telefono'              => $tel_emp ?: $telefono_bt,
                    'correo'                => $correo_emp,
                    'departamento'          => $dep_emp,
                    'puesto'                => $pto_emp,
                    'rfc'                   => $rfc_emp,
                    'nss'                   => $nss_emp,
                    'curp'                  => $curp_emp,
                    'foto'                  => $foto_emp,
                    'fecha_nacimiento'      => $fnac_emp,
                    'id_bolsa'              => $id_bolsa,
                    'status'                => $action['empleado_status'], // 3 cuando es Contratado
                    'eliminado'             => 0,
                ];

                $ok_e = $this->db->insert('empleados', $data_emp);
                if (! $ok_e) {
                    $this->db->trans_complete();
                    $errores[] = "Fila $i ({$fullName}): error al insertar en empleados";
                    continue;
                }
                $insertados_emp++;
                $id_empleado_pk = $this->db->insert_id();

                // Extras de empleado (excluyendo adjuntos)
                $used_emple = [];
                foreach ($MAP_EMPLE as $arr) {
                    foreach ((array) $arr as $hn) {
                        $used_emple[] = $hn;
                    }
                }

                $used_emple[] = $X_NOMBRE_COMPLETO;
                $used_emple   = array_merge($used_emple, $ATTACH_HEADERS);

                $extras_rows = [];
                foreach ($headers as $colKey => $headerName) {
                    $headerName = trim($headerName);
                    if ($headerName === '' || in_array($headerName, $used_emple, true)) {
                        continue;
                    }

                    $valx = array_key_exists($colKey, $r) ? $r[$colKey] : null;
                    if ($valx === null || $valx === '') {
                        continue;
                    }

                    if (is_numeric($valx) && $valx > 20000 && $valx < 60000) {
                        try { $valx = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($valx)->format('Y-m-d');} catch (Exception $e) {}
                    }

                    $extras_rows[] = [
                        'id_empleado' => $id_empleado_pk,
                        'nombre'      => mb_substr($headerName, 0, 255),
                        'valor'       => mb_substr((string) $valx, 0, 255),
                    ];
                }

                if (! empty($extras_rows)) {
                    $this->db->insert_batch('empleado_campos_extra', $extras_rows);
                    $extras_rows_total += count($extras_rows);
                }
            }

            // --- DOCUMENTOS: intenta descargar; SOLO inserta si la descarga fue OK ---
            foreach ($ATTACH_COLS as $def) {
                $label = $def['label'];
                $urls  = [];

                foreach ($def['headers'] as $hname) {
                    if (! isset($index[$hname])) {
                        continue;
                    }

                    $colLetter = $index[$hname];
                    $colIndex  = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($colLetter);

                    // Hipervínculo real de la celda
                    $cell = $sheet->getCellByColumnAndRow($colIndex, $i);
                    if ($cell && $cell->hasHyperlink()) {
                        $u = trim((string) $cell->getHyperlink()->getUrl());
                        if ($u !== '') {
                            $urls[] = $u;
                        }

                    }

                    // Texto visible con posibles URLs (usa $r en vez de $rows)
                    $visible = array_key_exists($colLetter, $r) ? (string) $r[$colLetter] : '';
                    if ($visible !== '') {
                        foreach ($this->extract_urls($visible) as $u2) {
                            $urls[] = $u2;
                        }

                    }
                }

                if (empty($urls)) {
                    continue;
                }

                $urls = array_values(array_unique($urls));

                foreach ($urls as $u) {
                    $uNorm = $this->normalize_share_url($u);

                    // ===== Bolsa =====
                    $bolRes = $this->save_remote_file(
                        $uNorm,
                        $this->path_docs_bolsa,
                        "bolsa_{$id_bolsa}_" . $this->slug($label)
                    );

                    $bol_ok = ($bolRes['ok'] ?? false)
                    && isset($bolRes['path'])
                    && is_file($bolRes['path'])
                    && filesize($bolRes['path']) > 0;

                    if ($bol_ok) {
                        $this->insert_doc_bolsa($id_bolsa, $id_usuario, basename($bolRes['path']), $label);
                    } else {
                        if (! empty($bolRes['path']) && is_file($bolRes['path'])) {
                            @unlink($bolRes['path']);
                        }

                        $failed_bolsa[$label][] = $uNorm;
                        $fallas_descargas[]     = [
                            'fila'      => $i,
                            'nombre'    => $fullName,
                            'entidad'   => 'bolsa',
                            'label'     => $label,
                            'url'       => $uNorm,
                            'http_code' => $bolRes['http_code'] ?? 0,
                            'error'     => $bolRes['error'] ?? 'Descarga fallida',
                        ];
                    }

                    // ===== Empleado (si se creó) =====
                    if ($id_empleado_pk) {
                        $empRes = $this->save_remote_file(
                            $uNorm,
                            $this->path_docs_empleado,
                            "emp_{$id_empleado_pk}_" . $this->slug($label)
                        );

                        $emp_ok = ($empRes['ok'] ?? false)
                        && isset($empRes['path'])
                        && is_file($empRes['path'])
                        && filesize($empRes['path']) > 0;

                        if ($emp_ok) {
                            $this->insert_doc_empleado($id_empleado_pk, basename($empRes['path']), $label);
                        } else {
                            if (! empty($empRes['path']) && is_file($empRes['path'])) {
                                @unlink($empRes['path']);
                            }

                            $failed_empleado[$label][] = $uNorm;
                            $fallas_descargas[]        = [
                                'fila'      => $i,
                                'nombre'    => $fullName,
                                'entidad'   => 'empleado',
                                'label'     => $label,
                                'url'       => $uNorm,
                                'http_code' => $empRes['http_code'] ?? 0,
                                'error'     => $empRes['error'] ?? 'Descarga fallida',
                            ];
                        }
                    }
                }
            }

            // --- Si hubo fallas: agregar links a EXTRAS / campos extra ---
            if (! empty($failed_bolsa)) {
                $extras_merge = $extras_bolsa;
                foreach ($failed_bolsa as $key => $urlsFail) {
                    $extras_merge[$key] = implode(' ', array_unique($urlsFail));
                }
                $this->db->where('id', $id_bolsa)->update('bolsa_trabajo', [
                    'extras' => json_encode($extras_merge, JSON_UNESCAPED_UNICODE),
                ]);
            }

            if ($id_empleado_pk && ! empty($failed_empleado)) {
                $rowsFail = [];
                foreach ($failed_empleado as $key => $urlsFail) {
                    $rowsFail[] = [
                        'id_empleado' => $id_empleado_pk,
                        'nombre'      => mb_substr($key, 0, 255),
                        'valor'       => mb_substr(implode(' ', array_unique($urlsFail)), 0, 255),
                    ];
                }
                if (! empty($rowsFail)) {
                    $this->db->insert_batch('empleado_campos_extra', $rowsFail);
                }

            }

            $this->db->trans_complete();
            if ($this->db->trans_status() === false) {
                $errores[] = "Fila $i ({$fullName}): transacción fallida";
            }

            // Liberar referencias por vuelta
            unset($r, $rowObj, $cellIterator);
            if (($i % 500) === 0) {gc_collect_cycles();} // higiene periódica
        }

        // Limpieza de PhpSpreadsheet
        $spreadsheet->disconnectWorksheets();
        unset($sheet, $spreadsheet);
        gc_collect_cycles();

        return $this->output->set_output(json_encode([
            'ok'                   => true,
            'bolsa_insertados'     => $insertados_bolsa,
            'empleados_insertados' => $insertados_emp,
            'empleado_extras_rows' => $extras_rows_total,
            'errores'              => $errores,
            'fallas_descargas'     => $fallas_descargas, // para SweetAlert
        ]));
    }

    /* =================== Reglas STATUS =================== */
    private function norm_label(?string $s): string
    {
        if ($s === null) {
            return '';
        }

        $s = trim(mb_strtolower($s));
        $s = @iconv('UTF-8', 'ASCII//TRANSLIT', $s);
        $s = preg_replace('/[^a-z0-9 ]+/', ' ', $s);
        $s = preg_replace('/\s+/', ' ', $s);
        return $s;
    }

    // CONTRATADO => bolsa=4 y crear empleado (status empleado=3)
    // APROBADO CON ACUERDO => bolsa=5
    // REUTILIZABLE => bolsa=3
    // APROBADO => bolsa=2
    // NUEVO u otro => bolsa=1
    private function map_status_action(?string $raw): array
    {
        $n = $this->norm_label($raw);

        if (str_contains($n, 'contratad')) {
            return ['create_empleado' => true, 'bolsa_status' => 4, 'empleado_status' => 3];
        }
        if (str_contains($n, 'aprobado con acuerdo') || (str_contains($n, 'aprobado') && str_contains($n, 'acuerdo'))) {
            return ['create_empleado' => false, 'bolsa_status' => 5, 'empleado_status' => null];
        }
        if (str_contains($n, 'reutilizable')) {
            return ['create_empleado' => false, 'bolsa_status' => 3, 'empleado_status' => null];
        }
        if ($n === 'aprobado' || str_contains($n, 'aprobado')) {
            return ['create_empleado' => false, 'bolsa_status' => 2, 'empleado_status' => null];
        }
        return ['create_empleado' => false, 'bolsa_status' => 1, 'empleado_status' => null];
    }

    /* =================== Descargas & Docs =================== */

    private function extract_urls($text): array
    {
        if (! is_string($text) || trim($text) === '') {
            return [];
        }

        preg_match_all('#https?://[^\s,<>\(\)\[\]\{\}]+#i', $text, $m);
        return array_values(array_unique($m[0] ?? []));
    }

    private function normalize_share_url(string $u): string
    {
        if (preg_match('#drive\.google\.com/file/d/([^/]+)/view#', $u, $m)) {
            return "https://drive.google.com/uc?export=download&id=" . $m[1];
        }
        if (preg_match('#drive\.google\.com/open\?id=([^&]+)#', $u, $m)) {
            return "https://drive.google.com/uc?export=download&id=" . $m[1];
        }
        if (stripos($u, 'dropbox.com') !== false) {
            $u = preg_replace('#\?dl=0#', '', $u);
            return $u . (str_contains($u, '?') ? '&' : '?') . 'dl=1';
        }
        return $u;
    }

    /**
     * Intenta descargar. Devuelve:
     * ['ok'=>true, 'path'=>'/abs/file', 'http_code'=>200] o
     * ['ok'=>false, 'error'=>'...', 'http_code'=>XXX]
     */
    private function save_remote_file(string $url, string $destDirAbs, string $prefix): array
    {
        if (! preg_match('#^https?://#i', $url)) {
            return ['ok' => false, 'error' => 'URL inválida', 'http_code' => 0];
        }

        // HEAD para adivinar content-type/extension si falta
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_NOBODY         => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_USERAGENT      => 'CI3-Importer/1.0',
        ]);
        curl_exec($ch);
        $ctype     = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $head_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $path = parse_url($url, PHP_URL_PATH) ?: '';
        $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION) ?: '');

        if ($ext === '' && is_string($ctype)) {
            $map = [
                'application/pdf'                                                         => 'pdf',
                'image/jpeg'                                                              => 'jpg',
                'image/png'                                                               => 'png',
                'image/gif'                                                               => 'gif',
                'application/msword'                                                      => 'doc',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            ];
            foreach ($map as $mt => $e) {
                if (stripos($ctype, $mt) !== false) {$ext = $e;
                    break;}
            }
        }
        if ($ext === '') {
            $ext = 'bin';
        }

        $name = $prefix . '_' . date('YmdHis') . '_' . substr(sha1($url), 0, 8) . '.' . $ext;
        $dest = rtrim($destDirAbs, '/\\') . DIRECTORY_SEPARATOR . $name;

        $dl = $this->curl_download($url, $dest);
        if ($dl['ok']) {
            return ['ok' => true, 'path' => $dest, 'http_code' => $dl['http_code']];
        } else {
            return ['ok' => false, 'error' => $dl['error'], 'http_code' => $dl['http_code']];
        }
    }

    /**
     * Descarga con cURL y guarda en $destAbs.
     * Retorna ['ok'=>bool,'http_code'=>int,'error'=>string]
     */
    private function curl_download(string $url, string $destAbs): array
    {
        $fp = @fopen($destAbs, 'wb');
        if (! $fp) {
            return ['ok' => false, 'http_code' => 0, 'error' => 'No se pudo abrir destino'];
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_FILE           => $fp,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_USERAGENT      => 'CI3-Importer/1.0',
        ]);
        $ok   = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = (string) curl_error($ch);
        curl_close($ch);
        fclose($fp);

        if (! $ok || $code >= 400) {
            @unlink($destAbs);
            log_message('error', "[import-docs] FAIL $url code=$code err=$err");
            return ['ok' => false, 'http_code' => $code, 'error' => $err ?: 'HTTP ' . $code];
        }
        log_message('info', "[import-docs] OK   $url -> $destAbs (HTTP $code)");
        return ['ok' => true, 'http_code' => $code, 'error' => ''];
    }

    private function slug(string $s): string
    {
        $s = @iconv('UTF-8', 'ASCII//TRANSLIT', $s);
        $s = strtolower(preg_replace('/[^a-z0-9]+/i', '_', $s));
        return trim($s, '_') ?: 'doc';
    }

    private function insert_doc_empleado(int $employee_id, string $nameOrUrl, string $label): void
    {
        $data = [
            'employee_id'     => $employee_id,
            'name'            => $nameOrUrl, // basename o URL fallback
            'id_opcion'       => null,
            'expiry_date'     => null,
            'expiry_reminder' => null,
            'nameDocument'    => $label,
            'status'          => 1,
        ];
        $this->db->insert('documents_empleado', $data);
    }

    private function insert_doc_bolsa(int $id_bolsa, int $id_usuario, string $nombre_archivo, string $label): void
    {
        $now   = date('Y-m-d H:i:s');
        $isUrl = preg_match('#^https?://#i', $nombre_archivo) === 1;
        $ext   = $isUrl ? 'url' : strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION) ?: 'bin');

        $data = [
            'id_bolsa'             => $id_bolsa,
            'id_usuario'           => $id_usuario,
            'nombre_archivo'       => $nombre_archivo, // basename o URL
            'nombre_personalizado' => $label,
            'tipo'                 => $ext,
            'tipo_vista'           => 1,
            'fecha_subida'         => $now,
            'fecha_actualizacion'  => $now,
            'eliminado'            => 0,
        ];
        $this->db->insert('documentos_bolsa', $data);
    }
}
