<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 14px;
  margin: 0;
  padding: 0;
  color: #000;
}

html,
body {
  height: 100%;
}

table {
  border-collapse: collapse;
  width: 100%;
  table-layout: fixed;
}

td,
th {
  border: 1px solid #000;
  padding-top: 1.2mm !important;
  padding-bottom: 1.2mm !important;
  line-height: 1.3;
  vertical-align: top;
}

th {
  font-size: 12px;
  padding: 1.2mm 0.8mm;
  line-height: 1.2;
  vertical-align: middle;
}

.header-row td {
  font-size: 12px;
  font-weight: bold;
  padding: 1.4mm 1mm;
}

.header-main {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}

.logo-cell {
  width: 31%;
  height: 50mm;
  text-align: center;
  vertical-align: middle;
  padding: 0;
}

.logo-box {
  width: 100%;
  height: 50mm;
  border-collapse: collapse;
  table-layout: fixed;
}

.logo-box td {
  border: none;
  text-align: center;
  vertical-align: middle;
}

.logo-cell img {
  width: 32mm;
  max-width: 32mm;
  height: auto;
  display: block;
  margin: 0 auto;
}

.center-cell {
  width: 36%;
  height: 37mm;
  padding: 0;
  vertical-align: top;
}

.right-cell {
  width: 43%;
  height: 37mm;
  padding: 0;
  vertical-align: top;
}

.ident {
  width: 100%;
  height: 37mm;
  border-collapse: collapse;
  table-layout: fixed;
}

.ident td {
  border: 1px solid #000;
  padding: 1.4mm 1mm;
  line-height: 1.25;
  vertical-align: middle;
}

.ident-title {
  background: #d9d9d9;
  text-align: center;
  font-weight: bold;
  font-size: 12px;
  padding: 1.8mm 0.8mm;
}

.ident-l {
  font-size: 11.5px;
  padding: 1.5mm 1mm;
  vertical-align: middle;
}

.ident-v {
  font-size: 10px;
  font-weight: bold;
}

.ident-l.c {
  text-align: center;
}

.ident tr {
  height: 6.5mm;
}

.ident tr:first-child td {
  height: 7.5mm;
}

/* =========================
   SEGUNDA SECCION
========================= */

.sec2-wrap {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
  margin-top: 0;
}

.sec2-wrap td {
  border: 1px solid #000;
  padding: 0;
  vertical-align: top;
}

.sec2-title {
  background: #d9d9d9;
  text-align: center;
  font-size: 14px;
  font-weight: bold;
  padding: 2mm 0;
}

.sec2-subtitle {
  text-align: center;
  font-size: 14px;
  font-weight: bold;
  padding: 1.5mm 1mm;
}

.tbl-mini {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}

.tbl-mini td {
  border: 1px solid #000;
  font-size: 10px;
  padding: 1mm;
  line-height: 1.4;
  vertical-align: middle;
}

.center {
  text-align: center;
}

.right {
  text-align: right;
}

.bold {
  font-weight: bold;
}

.row-h {
  height: 9mm;
}

.footer-notes {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}

.footer-notes td {
  border: none;
  font-size: 11px;
  padding-top: 0.6mm;
  text-align: center;
  font-weight: bold;
}

.sec3-wrap {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}

.sec3-wrap>tbody>tr>td {
  border: 1px solid #000;
  vertical-align: top;
  padding: 0;
}

.tbl-clean {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}

.tbl-clean td,
.tbl-clean th {
  border: none;
  font-size: 13px;
  padding: 1.6mm 1mm;
  line-height: 1.2;
  vertical-align: top;
}

.clean-title {
  background: #d9d9d9;
  text-align: center;
  font-weight: bold;
  font-size: 12px;
  border-bottom: 1px solid #000 !important;
  padding: 0.4mm 0;
}

.clean-subtitle {

  font-weight: bold;
  border-bottom: 1px solid #000 !important;
  padding-top: 0.2mm;
  padding-bottom: 0.2mm;
}

.clean-line td {
  border-bottom: 1px solid #000;
}

.clean-line-light td {
  border-bottom: 0.8px solid #000;
}

.no-line td {
  border-bottom: none;
}

.split-col {
  border-left: 1px solid #000 !important;
}

.lbl {
  font-weight: bold;
  white-space: nowrap;
}

.val-r {
  text-align: right;
  white-space: nowrap;
}

.chk {
  width: 4mm;
  text-align: center;
  font-weight: bold;
}



.ing-row td {
  height: 3.3mm;
  padding-top: 0.15mm;
  padding-bottom: 0.15mm;
}

.egr-row td {
  padding-top: 0.12mm;
  padding-bottom: 0.12mm;
}

.tight-question {
  border-top: 1px solid #000;
  border-bottom: 1px solid #000;
  font-weight: bold;
  text-align: center;
  font-size: 11px;
  padding: 0.5mm 0.6mm;
  line-height: 1.05;
}

.tight-answer {
  min-height: 14mm;
  padding: 1.2mm;
}

.viv-col-left {
  width: 26%;
}

.viv-col-mid {
  width: 24%;
}

.viv-col-right {
  width: 18%;
}

.viv-col-last {
  width: 32%;
}

.ing-row td,
.egr-row td {
  height: 6.2mm;
  padding-top: 0.8mm;
  padding-bottom: 0.8mm;
}

.no-line td {
  border-bottom: none;
}

.chk {
  width: 4mm;
  text-align: center;
  font-weight: bold;
}

.note-box,
.tight-answer {
  min-height: 18mm;
  padding: 2mm;
}

/* =========================
   CUARTA SECCION
========================= */

.sec4-wrap {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
  margin-top: 0;
}

.sec4-wrap>tbody>tr>td {
  border: 1px solid #000;
  padding: 0;
  vertical-align: top;
}

.sec4-title {
  background: #d9d9d9;
  text-align: center;
  font-weight: bold;
  font-size: 11px;
  padding: 0.8mm 0;
  border-bottom: 1px solid #000;
}

.sec4-box {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}

.sec4-box td,
.sec4-box th {
  border: none;
  font-size: 11px;
  padding: 0.45mm 0.6mm;
  vertical-align: top;
  line-height: 1.1;
}

.sec4-label {
  font-weight: bold;
}

.sec4-text {
  text-align: justify;
  vertical-align: top;
  font-size: 11px;
  line-height: 1.3;
}

.photo-wrap {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}

.photo-wrap td {
  border: 1px solid #000;
  padding: 0;
  text-align: center;
  vertical-align: middle;
  height: 58mm;
}

.photo-wrap img {
  width: 100%;
  height: 58mm;
  display: block;

}


.photo-box {
  width: 100%;
  height: 58mm;
  text-align: center;
  vertical-align: middle;
}

.photo-box img {
  width: 100%;
  height: 58mm;
  object-fit: cover;
  display: block;
}

.photo-empty {
  font-size: 11px;
  color: #444;
  text-align: center;
  vertical-align: middle;
  height: 58mm;
}

.health-grid {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
}

.health-grid td {
  border: none;
  font-size: 11px;
  padding: 0.2mm 0.5mm;
  vertical-align: middle;
  line-height: 1.0;
}

.health-item {
  white-space: nowrap;
}

.health-check {
  display: inline-block;
  width: 4mm;
  text-align: center;
  font-weight: bold;
}

.health-subtitle {
  font-weight: bold;
  border-top: 1px solid #000;
  border-bottom: 1px solid #000;
  padding: 0.5mm 0.6mm;
}

.obs-box {
  min-height: 8mm;
  padding-top: 0.6mm;
}

.validation-box {
  height: 28mm;
}

.no-pad {
  padding: 0 !important;
}


.page-wrap {
  width: 100%;
}

.sec3-wrap {
  width: 100%;
  border-collapse: collapse;
  table-layout: fixed;
  margin-top: 0;
}

.sec3-wrap>tbody>tr>td {
  border: 1px solid #000;
  vertical-align: top;
  padding: 0;
}
</style>

<?php
    $logo = FCPATH . 'img/logo.png';

    $datos_generales = (isset($datos_generales) && is_object($datos_generales)) ? $datos_generales : (object) [];
    $familiares      = (isset($familiares) && is_array($familiares)) ? $familiares : [];
    $vivienda        = (isset($vivienda) && is_object($vivienda)) ? $vivienda : (object) [];
    $economia        = (isset($economia) && is_object($economia)) ? $economia : (object) [];
    $becas           = (isset($becas) && is_object($becas)) ? $becas : (object) [];
    $fotos           = (isset($fotos) && is_array($fotos)) ? $fotos : [];

    $dictamenColor = '#e9ede9';
    if($datos_generales->status_bgc == 1){
      $dictamenColor = '#36bd36';
    }elseif($datos_generales->status_bgc == 3){
        $dictamenColor = '#cba51b';
    }elseif($datos_generales->status_bgc == 2){
        $dictamenColor = '#cb301b';
    }

    $porcentaje = $becas->porcentaje ?? '';

    $fecha_dia  = '';
    $fecha_mes  = '';
    $fecha_anio = '';

    if (! empty($becas->fecha_apertura)) {
    $timestamp = strtotime($becas->fecha_apertura);
    if ($timestamp) {
        $fecha_dia  = date('d', $timestamp);
        $fecha_mes  = date('m', $timestamp);
        $fecha_anio = date('Y', $timestamp);
    }
    }


    $check_nueva    = isset($becas->tipo_dictamen) && (int) $becas->tipo_dictamen === 1;
    $check_reafilia = isset($becas->tipo_dictamen) && (int) $becas->tipo_dictamen === 2;
    $check_rechaza  = isset($becas->estatus_final) && (int) $becas->estatus_final === 2;
    $check_beca     = true;

    $no_expediente = $becas->no_expediente ?? '';
    $pasaporte     = $becas->pasaporte ?? '';
    $grado         = $becas->grado ?? '';
    $escuela       = $becas->escuela ?? '';

    $ubicacion = trim(
    ($datos_generales->municipio_completo ?? $datos_generales->municipio ?? '') .
    (! empty($datos_generales->estado) ? ', ' . $datos_generales->estado : '')
    );

    $nombre_alumno = $datos_generales->nombre_completo ?? '';
    $religion      = $datos_generales->religion ?? '';

    $domicilio = '';
    if (! empty($datos_generales->domicilio_internacional)) {
    $domicilio = $datos_generales->domicilio_internacional;
    } else {
    $partes_domicilio = [];

    $calle_base = trim(
        ($datos_generales->calle ?? '') .
        (! empty($datos_generales->exterior) ? ' ' . $datos_generales->exterior : '') .
        (! empty($datos_generales->interior) ? ' Int. ' . $datos_generales->interior : '')
    );

    if ($calle_base !== '') {
        $partes_domicilio[] = $calle_base;
    }
    if (! empty($datos_generales->colonia)) {
        $partes_domicilio[] = $datos_generales->colonia;
    }
    if (! empty($datos_generales->cp)) {
        $partes_domicilio[] = 'CP ' . $datos_generales->cp;
    }

    $domicilio = implode(', ', $partes_domicilio);
    }

    $cruza_con = $becas->cruz ?? ($datos_generales->entre_calles ?? '');
    $municipio = $datos_generales->municipio_completo ?? ($datos_generales->municipio ?? '');
    $estado    = $datos_generales->estado ?? '';
    $telefono  = $datos_generales->celular ?? ($datos_generales->telefono_casa ?? '');
    $promedio  = $becas->promedio ?? '';

    $conceptos_fijos = [
    ['concepto' => 'Sueldo', 'qnal' => '', 'mensual' => $economia->sueldo ?? ''],
    ['concepto' => 'Aportación', 'qnal' => '', 'mensual' => $economia->aportacion ?? ''],
    ['concepto' => 'Bienes', 'qnal' => '', 'mensual' => $economia->bienes ?? ''],
    ['concepto' => 'Deudas', 'qnal' => '', 'mensual' => $economia->deudas ?? ''],
    ['concepto' => 'Solvencia', 'qnal' => '', 'mensual' => $economia->solvencia ?? ''],
    ['concepto' => 'Crédito banco', 'qnal' => '', 'mensual' => $economia->credito_banco_importe ?? ''],
    ['concepto' => 'Crédito Infonavit', 'qnal' => '', 'mensual' => $economia->credito_infonavit_importe ?? ''],
    ['concepto' => 'Otro crédito', 'qnal' => '', 'mensual' => $economia->credito_otro_importe ?? ''],
    ];

    $total_ingreso_mensual = 0;
    foreach ($conceptos_fijos as $item) {
    $valor                  = is_numeric($item['mensual']) ? (float) $item['mensual'] : 0;
    $total_ingreso_mensual += $valor;
    }

    /*
|--------------------------------------------------------------------------
| SECCIONES 8, 9, 10, 11 y 12
|--------------------------------------------------------------------------
*/

    $servicio_apoyo    = $becas->servicio_apoyo ?? '';
    $descripcion_apoyo = $becas->descripcion_apoyo ?? '';

    $motivo_estudio = trim($servicio_apoyo . ' ' . $descripcion_apoyo);
    if ($motivo_estudio === '') {
    $motivo_estudio = 'Beca Escolar en Apoyo a la Familia.';
    }

    $diagnostico_social = $becas->diagnostico_social ?? '';

    $instituciones         = strtolower(trim((string) ($becas->instituciones ?? '')));
    $enfermedades_cronicas = $becas->enfermedades ?? '';
    $observaciones_salud   = $becas->observaciones ?? '';

    $salud_imss                 = strpos($instituciones, 'imss') !== false;
    $salud_issste               = strpos($instituciones, 'issste') !== false;
    $salud_ssj                  = strpos($instituciones, 'ssj') !== false;
    $salud_dif                  = strpos($instituciones, 'dif') !== false;
    $salud_cruz_roja            = strpos($instituciones, 'cruz roja') !== false;
    $salud_smmc                 = strpos($instituciones, 'seguro popular') !== false || strpos($instituciones, 'smmc') !== false;
    $salud_servicios_part       = strpos($instituciones, 'particular') !== false || strpos($instituciones, 'servicios particulares') !== false;
    $salud_medicina_alternativa = strpos($instituciones, 'alternativa') !== false;

    /*
|--------------------------------------------------------------------------
| Helpers locales para la vista
|--------------------------------------------------------------------------
*/
    if (! function_exists('imageToCoverDataUri')) {
    function imageToCoverDataUri($path, $targetW = 900, $targetH = 600)
    {
        if (empty($path) || ! file_exists($path)) {
            return '';
        }

        $info = @getimagesize($path);
        if (! $info) {
            return '';
        }

        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $src = @imagecreatefromjpeg($path);
                break;
            case 'image/png':
                $src = @imagecreatefrompng($path);
                break;
            case 'image/gif':
                $src = @imagecreatefromgif($path);
                break;
            case 'image/webp':
                $src = function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false;
                break;
            default:
                return '';
        }

        if (! $src) {
            return '';
        }

        $srcW = imagesx($src);
        $srcH = imagesy($src);

        if ($srcW <= 0 || $srcH <= 0) {
            imagedestroy($src);
            return '';
        }

        $srcRatio    = $srcW / $srcH;
        $targetRatio = $targetW / $targetH;

        if ($srcRatio > $targetRatio) {
            // imagen más ancha: recortar lados
            $cropH = $srcH;
            $cropW = (int) round($srcH * $targetRatio);
            $srcX  = (int) round(($srcW - $cropW) / 2);
            $srcY  = 0;
        } else {
            // imagen más alta: recortar arriba/abajo
            $cropW = $srcW;
            $cropH = (int) round($srcW / $targetRatio);
            $srcX  = 0;
            $srcY  = (int) round(($srcH - $cropH) / 2);
        }

        $dst = imagecreatetruecolor($targetW, $targetH);

        imagecopyresampled(
            $dst,
            $src,
            0,
            0,
            $srcX,
            $srcY,
            $targetW,
            $targetH,
            $cropW,
            $cropH
        );

        ob_start();
        imagejpeg($dst, null, 90);
        $data = ob_get_clean();

        imagedestroy($src);
        imagedestroy($dst);

        if (! $data) {
            return '';
        }

        return 'data:image/jpeg;base64,' . base64_encode($data);
    }
    }
    if (! function_exists('imageToDataUri')) {
    function imageToDataUri($path)
    {
        if (empty($path) || ! file_exists($path)) {
            return '';
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        $mime = 'image/jpeg';
        if ($ext === 'png') {
            $mime = 'image/png';
        } elseif ($ext === 'gif') {
            $mime = 'image/gif';
        } elseif ($ext === 'webp') {
            $mime = 'image/webp';
        }

        $data = @file_get_contents($path);
        if ($data === false) {
            return '';
        }

        return 'data:' . $mime . ';base64,' . base64_encode($data);
    }
    }

    if (! function_exists('chkx')) {
    function chkx($value)
    {
        return ! empty($value) ? '☒' : '☐';
    }
    }

    /*
|--------------------------------------------------------------------------
| Fotos de vivienda
|--------------------------------------------------------------------------
*/

    $foto_vivienda_1 = '';
    $foto_vivienda_2 = '';

    if (! empty($fotos[0]) && ! empty($fotos[0]->archivo)) {
    $ruta1           = FCPATH . '_docs/' . $fotos[0]->archivo;
    $foto_vivienda_1 = imageToCoverDataUri($ruta1, 900, 620);
    }

    if (! empty($fotos[1]) && ! empty($fotos[1]->archivo)) {
    $ruta2           = FCPATH . '_docs/' . $fotos[1]->archivo;
    $foto_vivienda_2 = imageToCoverDataUri($ruta2, 900, 620);
    }
?>
<?php
    $total_ingresos_mensuales = 0;
    $ingresos_validos         = [];

    foreach ($familiares as $fam) {
    if (! empty($fam->sueldo) && is_numeric($fam->sueldo)) {
        $ingresos_validos[]        = $fam;
        $total_ingresos_mensuales += (float) $fam->sueldo;
    }
    }

    $egresos_items = [
    'Alimentación:'                  => $economia->alimentos ?? '',
    'Créditos Hipotecarios y autos:' => $economia->infonavit ?? '',
    'Colegiaturas y mat. Escolar:'   => $economia->educacion ?? '',
    'Médicos y medicamentos:'        => $economia->medicamento ?? '',
    'Renta:'                         => $economia->renta ?? '',
    'Transporte o gasolina:'         => $economia->transporte ?? '',
    'Agua, Luz, Predial, Teléfono:'  => $economia->servicios ?? '',
    'Tarjetas de crédito:'           => $economia->tarjeta_credito ?? '',
    'Otros:'                         => $economia->otros ?? '',
    'Diversiones:'                   => $economia->diversion ?? '',
    ];

    $total_egresos_mensuales = 0;
    foreach ($egresos_items as $valor) {
    if (is_numeric($valor)) {
        $total_egresos_mensuales += (float) $valor;
    }
    }

    $max_filas_ing_eg = max(count($ingresos_validos), count($egresos_items));

    $diferencia = $total_ingresos_mensuales - $total_egresos_mensuales;

    $analista = $datos_generales->nombre_analista ?? '';
     $fecha_final = $datos_generales->fecha_final ?? '';
?>
<!-- =========================
     ENCABEZADO
    ========================= -->
<div class="page-wrap">
  <table style="width:100%;">

    <tr>
      <td style="border:none; vertical-align:top;">
        <table class="header-main" style="width:100%; border-collapse:collapse; table-layout:fixed; height:100%;">
          <tr style="height:100%;">
            <!-- LOGO -->


            <!-- CENTRO -->
            <td class="center-cell" style="width:50%; padding:0; vertical-align:top;">
              <table style="width:100%; border-collapse:collapse; table-layout:fixed; font-size:11px;">

                <!-- ENCABEZADO -->
                <tr>
                  <td colspan="7" style="border:none; padding:0.8mm 1mm 0.3mm 1mm;">
                    <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
                      <tr>
                        <td style="border:none; width:28mm; text-align:left; vertical-align:middle; padding:0;">
                          <?php if (! empty($logo) && file_exists($logo)): ?>
                          <img src="<?php echo $logo; ?>"
                            style="width:50mm; max-width:50mm; height:auto; display:block; margin:0;">
                          <?php endif; ?>
                        </td>
                        <td style="border:none; text-align:center; vertical-align:middle; padding:0 6mm 0 0;">
                          <div style="font-weight:bold; font-size:16px; text-align:center;">
                            PROGRAMA BECAS 2026
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <tr>
                  <td colspan="7" style="border:none; padding:0;">
                    <table align="right"
                      style="width:72%; border-collapse:collapse; table-layout:fixed; font-size:11px; margin:0;">

                      <!-- DICTAMEN + DEPARTAMENTO -->
                      <tr>
                        <td
                          style="border:none; width:20%; font-size:13px; text-align:right; font-weight:bold; padding:0.5mm 1mm 0.5mm 0;">
                          Dictamen
                        </td>
                        <td style="border:none; width:12%; text-align:left; padding:0.5mm 0;">
                          <table style="border-collapse:collapse; width:9mm; margin:0;">
                            <tr>
                              <td style="border:1px solid #000; height:4mm; background:<?php echo $dictamenColor; ?>;">
                              </td>
                            </tr>
                          </table>
                        </td>

                        <td
                          style="border:none; width:22%; text-align:right; font-weight:bold; font-size:13px; padding:0.5mm 1mm 0.5mm 2mm;">
                          Departamento
                        </td>
                        <td colspan="3" style="border:none; text-align:left; padding:0.5mm 0;">
                          <span
                            style="display:inline-block; font-size:13px; min-width:28mm; text-align:center; font-weight:bold; border-bottom:1px solid #000; padding-bottom:0.2mm;">
                            TRABAJO SOCIAL
                          </span>
                        </td>
                      </tr>

                      <!-- ESTUDIO + CHECKS -->
                      <tr>
                        <td colspan="2"
                          style="border:none; text-align:right; font-weight:bold; vertical-align:top; padding:1mm 1mm 0 0;">
                          Estudio Socio-Familiar
                        </td>
                        <td colspan="4" style="border:none; vertical-align:top; padding:0.5mm 0 0 2mm;">
                          <table style="width:100%; border-collapse:collapse; table-layout:fixed; font-size:13px;">
                            <tr>
                              <td style="border:none; width:5mm; padding-bottom:0.4mm;">
                                <table style="border-collapse:collapse; width:4mm; margin:0;">
                                  <tr>
                                    <td
                                      style="border:1px solid #000; width:4mm; height:4mm; text-align:center; font-size:8px; line-height:3.2mm;">
                                      <?php echo $check_nueva ? 'X' : ''; ?>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                              <td style="border:none; padding-bottom:0.4mm; vertical-align:middle; ">Nueva</td>
                            </tr>

                            <tr>
                              <td style="border:none; width:5mm; padding-bottom:0.4mm;">
                                <table style="border-collapse:collapse; width:4mm; margin:0;">
                                  <tr>
                                    <td
                                      style="border:1px solid #000; width:3.4mm; height:3.4mm; text-align:center; font-size:8px; line-height:3.2mm;">
                                      <?php echo $check_reafilia ? 'X' : ''; ?>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                              <td style="border:none; padding-bottom:0.4mm; vertical-align:middle;">Se ratifica</td>
                            </tr>

                            <tr>
                              <td style="border:none; width:5mm; padding-bottom:0.4mm;">
                                <table style="border-collapse:collapse; width:3.4mm; margin:0;">
                                  <tr>
                                    <td
                                      style="border:1px solid #000; width:3.4mm; height:3.4mm; text-align:center; font-size:8px; line-height:3.2mm;">
                                      <?php echo $check_rechaza ? 'X' : ''; ?>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                              <td style="border:none; padding-bottom:0.4mm; vertical-align:middle;">Se rechaza</td>
                            </tr>


                          </table>
                        </td>
                      </tr>

                      <tr>
                        <td colspan="6" style="border:none; height:0.2mm;"></td>
                      </tr>

                      <!-- PORCENTAJE + FECHA -->
                      <tr>
                        <td style="border:none; text-align:right; font-weight:bold; padding:0.4mm 1mm 0.4mm 0;">
                          Porcentaje
                        </td>
                        <td style="border:none; text-align:left; padding:0.4mm 0;">
                          <table style="width:12mm; border-collapse:collapse;">
                            <tr>
                              <td
                                style="border:none; border-bottom:1px solid #000; text-align:center; font-weight:bold; font-size:11px; height:3mm;">
                                <?php echo htmlspecialchars($porcentaje); ?> %
                              </td>
                            </tr>
                          </table>
                        </td>

                        <td
                          style="border:none; text-align:right; font-weight:bold; padding:0.4mm 1mm 0.4mm 2mm; white-space:nowrap;">
                          Fecha de apertura
                        </td>
                        <td colspan="3" style="border:none; padding:0.4mm 0;">
                          <table style="width:100%; border-collapse:collapse; table-layout:fixed; font-size:8px;">
                            <tr>
                              <td style="border:none; width:16%; text-align:left;">
                                <table style="width:9mm; border-collapse:collapse;">
                                  <tr>
                                    <td
                                      style="border:none; border-bottom:1px solid #000; text-align:center; font-weight:bold; font-size:11px; height:3mm;">
                                      <?php echo htmlspecialchars($fecha_dia); ?>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                              <td style="border:none; width:16%; text-align:left;">
                                <table style="width:9mm; border-collapse:collapse;">
                                  <tr>
                                    <td
                                      style="border:none; border-bottom:1px solid #000; text-align:center; font-weight:bold; font-size:11px; height:3mm;">
                                      <?php echo htmlspecialchars($fecha_mes); ?>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                              <td style="border:none; width:20%; text-align:left;">
                                <table style="width:12mm; border-collapse:collapse;">
                                  <tr>
                                    <td
                                      style="border:none; border-bottom:1px solid #000; text-align:center; font-weight:bold; font-size:11px; height:3mm;">
                                      <?php echo htmlspecialchars($fecha_anio); ?>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                              <td style="border:none; width:48%;"></td>
                            </tr>
                            <tr>
                              <td
                                style="border:none; text-align:center; font-size:10px; font-weight:bold; padding-top:0.2mm;">
                                Día</td>
                              <td
                                style="border:none; text-align:center; font-size:10px; font-weight:bold; padding-top:0.2mm;">
                                Mes</td>
                              <td
                                style="border:none; text-align:center; font-size:10px; font-weight:bold; padding-top:0.2mm;">
                                Año</td>
                              <td style="border:none;"></td>
                            </tr>
                          </table>
                        </td>
                      </tr>

                    </table>
                  </td>
                </tr>

              </table>
            </td>

            <!-- DERECHA -->
            <td class="right-cell" style="width:50%; padding:0; vertical-align:top; height:100%;">
              <table class="ident" style="width:100%; border-collapse:collapse; table-layout:fixed; font-size:13px;">
                <tr>
                  <td colspan="6" class="ident-title" style="background:#d9d9d9; text-align:center; font-weight:bold;">
                    1. Identificación
                  </td>
                </tr>

                <tr>
                  <td class="ident-l" style="width:19%;">No. Expediente:</td>
                  <td class="ident-v" style="width:13%;"><?php echo htmlspecialchars($no_expediente); ?></td>
                  <td class="ident-l c" style="width:15%;">Pasaporte:</td>
                  <td class="ident-v" style="width:13%;"><?php echo htmlspecialchars($pasaporte); ?></td>
                  <td class="ident-l c" style="width:12%;">Grado:</td>
                  <td class="ident-v" style="width:28%;"><?php echo htmlspecialchars($grado); ?></td>
                </tr>

                <tr>
                  <td class="ident-l">Escuela:</td>
                  <td colspan="5" class="ident-v"><?php echo htmlspecialchars($escuela); ?></td>
                </tr>

                <tr>
                  <td class="ident-l">Ubicación:</td>
                  <td colspan="5" class="ident-v"><?php echo htmlspecialchars($ubicacion); ?></td>
                </tr>

                <tr>
                  <td class="ident-l">Nombre del Alumno:</td>
                  <td colspan="5" class="ident-v"><?php echo htmlspecialchars($nombre_alumno); ?></td>
                </tr>

                <tr>
                  <td class="ident-l">Religión:</td>
                  <td colspan="5" class="ident-v"><?php echo htmlspecialchars($religion); ?></td>
                </tr>

                <tr>
                  <td class="ident-l">Domicilio:</td>
                  <td colspan="5" class="ident-v"><?php echo htmlspecialchars($domicilio); ?></td>
                </tr>

                <tr>
                  <td class="ident-l">Cruza con:</td>
                  <td colspan="5" class="ident-v"><?php echo htmlspecialchars($cruza_con); ?></td>
                </tr>

                <tr>
                  <td class="ident-l">Municipio:</td>
                  <td colspan="2" class="ident-v"><?php echo htmlspecialchars($municipio); ?></td>
                  <td class="ident-l c">Estado:</td>
                  <td colspan="2" class="ident-v"><?php echo htmlspecialchars($estado); ?></td>
                </tr>

                <tr>
                  <td class="ident-l">Teléfono:</td>
                  <td colspan="2" class="ident-v"><?php echo htmlspecialchars($telefono); ?></td>
                  <td class="ident-l c">Promedio:</td>
                  <td colspan="2" class="ident-v"><?php echo htmlspecialchars($promedio); ?></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>

        <!-- =========================
     SEGUNDA SECCION
    ========================= -->

        <table class="sec2-wrap" style="width:100%; border-collapse:collapse; table-layout:fixed;">
          <tr>
            <!-- 2. COMPOSICION FAMILIAR -->
            <td style="width:49%; padding:0;">
              <table class="tbl-mini">
                <tr>
                  <td colspan="7" class="sec2-title">2. Composición Familiar</td>
                </tr>
                <tr>
                  <td class="sec2-subtitle center" style="width:30%; border:none; height:12mm; padding:0;">Nombre</td>
                  <td class="sec2-subtitle center" style="width:5%;">Sexo</td>
                  <td class="sec2-subtitle center" style="width:12%;">Fecha de Nacimiento</td>
                  <td class="sec2-subtitle center" style="width:17%;">Lugar de Nacimiento</td>
                  <td class="sec2-subtitle center" style="width:6%;">Edad</td>
                  <td class="sec2-subtitle center" style="width:10%;">Estado Civil</td>
                  <td class="sec2-subtitle center" style="width:20%;">Parentesco</td>

                </tr>

                <?php if (! empty($familiares)): ?>
                <?php foreach ($familiares as $fam): ?>
                <?php
                    $sexo_corto = '';
                    if (isset($fam->sexo)) {
                        $sexo_corto = ((int) $fam->sexo === 1) ? 'F' : 'M';
                    }
                ?>
                <tr class="row-h">
                  <td><?php echo htmlspecialchars($fam->nombre ?? ''); ?></td>
                  <td class="center"><?php echo htmlspecialchars($sexo_corto); ?></td>
                  <td class="center">
                    <?php echo ! empty($fam->fech_nacimiento) ? htmlspecialchars(date('d/m/Y', strtotime($fam->fech_nacimiento))) : ''; ?>
                  </td>
                  <td><?php echo htmlspecialchars($fam->ciudad ?? ''); ?></td>
                  <td class="center"><?php echo htmlspecialchars($fam->edad ?? ''); ?></td>
                  <td class="center"><?php echo htmlspecialchars($fam->estado_civil ?? ''); ?></td>
                  <td><?php echo htmlspecialchars($fam->parentesco ?? ''); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
              </table>


            </td>

            <!-- 3. EDUCACION -->
            <td style="width:18%; padding:0;">
              <table class="tbl-mini">
                <tr>
                  <td class="sec2-title">3. Educación</td>

                </tr>
                <tr>
                  <td class="sec2-subtitle" style="border:none; height:12mm; padding:0;">Escolaridad</td>



                </tr>


                <?php if (! empty($familiares)): ?>
                <?php foreach ($familiares as $fam): ?>
                <?php
                    $texto_escolaridad = $fam->grado_estudio ?? '';
                    if (! empty($fam->licenciatura)) {
                        $texto_escolaridad .= ($texto_escolaridad ? ' - ' : '') . $fam->licenciatura;
                    }
                ?>
                <tr class="row-h">
                  <td><?php echo htmlspecialchars($texto_escolaridad); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
              </table>
            </td>

            <!-- 4. ECONOMIA -->
            <td style="width:33%; padding:0;">
              <table class="tbl-mini">
                <tr>
                  <td colspan="3" class="sec2-title">4. Economía</td>
                </tr>
                <tr>
                  <td colspan="3" class="sec2-subtitle">Ingresos</td>
                </tr>
                <tr>
                  <td class="sec2-subtitle center" style="width:50%;">Ocupación o Ingreso</td>
                  <td class="sec2-subtitle center" style="width:20%;">Forma</td>
                  <td class="sec2-subtitle center" style="width:30%;">Mensual</td>
                </tr>

                <?php
                    $total_ingreso_familia = 0;
                ?>

                <?php if (! empty($familiares)): ?>
                <?php foreach ($familiares as $fam): ?>
                <?php
                    $ocupacion = trim((string) ($fam->puesto ?? ''));
                    if ($ocupacion === '') {
                        $ocupacion = trim((string) ($fam->empresa ?? ''));
                    }

                    $forma = $fam->tipo_ingreso_texto ?? '';

                    $ingreso               = $fam->sueldo ?? '';
                    $ingreso_num           = is_numeric($ingreso) ? (float) $ingreso : 0;
                    $total_ingreso_familia += $ingreso_num;
                ?>
                <tr class="row-h">
                  <td><?php echo htmlspecialchars($ocupacion); ?></td>
                  <td class="center"><?php echo htmlspecialchars($forma); ?></td>
                  <td class="right"><?php echo htmlspecialchars((string) $ingreso); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>

                <tr>
                  <td colspan="2" class="right bold" style="font-size:11px; padding:0.5mm 0.8mm;">Total</td>
                  <td class="right bold" style="font-size:11px; padding:0.5mm 0.8mm;">
                    <?php echo htmlspecialchars((string) $total_ingreso_familia); ?>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>

        <!-- =========================
        TERCERA SECCION
        ========================= -->


        <table class="sec3-wrap" style="width:100%; border-collapse:collapse; table-layout:fixed;">
          <tr>
            <!-- 5. VIVIENDA -->
            <td style="width:40%;">
              <table class="tbl-clean">
                <tr>
                  <td colspan="2" class="clean-title">5. Vivienda</td>
                </tr>
                <tr>
                  <!-- COLUMNA IZQUIERDA -->
                  <td class="viv-col-left" style="width:50%; vertical-align:top;">
                    <table class="tbl-clean">
                      <tr>
                        <td colspan="2" class="clean-subtitle">5.1. Condición</td>
                      </tr>
                      <tr class="no-line">
                        <td>Propia</td>
                        <td class="chk"><?php echo((int) ($vivienda->condicion_vivienda ?? 0) === 1) ? '☒' : '☐'; ?>
                        </td>
                      </tr>
                      <tr class="no-line">
                        <td>En pago</td>
                        <td class="chk"><?php echo((int) ($vivienda->condicion_vivienda ?? 0) === 2) ? '☒' : '☐'; ?>
                        </td>
                      </tr>
                      <tr class="no-line">
                        <td>Renta</td>
                        <td class="chk"><?php echo((int) ($vivienda->condicion_vivienda ?? 0) === 3) ? '☒' : '☐'; ?>
                        </td>
                      </tr>
                      <tr class="clean-line-light">
                        <td>Prestada</td>
                        <td class="chk"><?php echo((int) ($vivienda->condicion_vivienda ?? 0) === 4) ? '☒' : '☐'; ?>
                        </td>
                      </tr>

                      <tr>
                        <td colspan="2" class="clean-subtitle">5.2. Servicios</td>
                      </tr>
                      <tr class="no-line">
                        <td>Agua</td>
                        <td><?php echo htmlspecialchars($vivienda->agua_texto ?? ''); ?></td>
                      </tr>
                      <tr class="no-line">
                        <td>Drenaje</td>
                        <td><?php echo htmlspecialchars($vivienda->drenaje_texto ?? ''); ?></td>
                      </tr>
                      <tr class="clean-line-light">
                        <td>Electricidad</td>
                        <td><?php echo htmlspecialchars($vivienda->electricidad_texto ?? ''); ?></td>
                      </tr>

                      <tr>
                        <td colspan="2" style="padding:0;">
                          <table class="tbl-clean" style="width:100%; border-collapse:collapse; table-layout:fixed;">
                            <tr>
                              <!-- COLUMNA IZQUIERDA -->
                              <td style="width:52%; vertical-align:top; padding:0 0.4mm 0 0;">
                                <table class="tbl-clean"
                                  style="width:100%; border-collapse:collapse; table-layout:fixed;">
                                  <tr>
                                    <td colspan="2" class="clean-subtitle">5.3. Tipo de vivienda</td>
                                  </tr>
                                  <tr class="no-line">
                                    <td style="width:78%;">Casa</td>
                                    <td class="chk">
                                      <?php echo((int) ($vivienda->id_tipo_vivienda ?? 0) === 1) ? '☒' : '☐'; ?>
                                    </td>
                                  </tr>
                                  <tr class="no-line">
                                    <td>Departamento</td>
                                    <td class="chk">
                                      <?php echo((int) ($vivienda->id_tipo_vivienda ?? 0) === 2) ? '☒' : '☐'; ?>
                                    </td>
                                  </tr>
                                  <tr class="no-line">
                                    <td>Vecindad</td>
                                    <td class="chk">
                                      <?php echo((int) ($vivienda->id_tipo_vivienda ?? 0) === 3) ? '☒' : '☐'; ?>
                                    </td>
                                  </tr>
                                  <tr class="no-line">
                                    <td>Otro</td>
                                    <td class="chk">
                                      <?php echo((int) ($vivienda->id_tipo_vivienda ?? 0) > 3) ? '☒' : '☐'; ?>
                                    </td>
                                  </tr>
                                </table>
                              </td>

                              <!-- COLUMNA DERECHA -->
                              <td
                                style="width:48%; vertical-align:top; padding:0 0 0 0.4mm; border-left:1px solid #000;">
                                <table class="tbl-clean"
                                  style="width:100%; border-collapse:collapse; table-layout:fixed;">
                                  <tr>
                                    <td colspan="2" class="clean-subtitle">5.3.1. Cuartos:</td>
                                  </tr>
                                  <tr class="no-line">
                                    <td style="width:70%;">Cocina</td>
                                    <td><?php echo htmlspecialchars($vivienda->cocina ?? ''); ?></td>
                                  </tr>
                                  <tr class="no-line">
                                    <td>Baño</td>
                                    <td><?php echo htmlspecialchars($vivienda->banios ?? ''); ?></td>
                                  </tr>
                                  <tr class="no-line">
                                    <td>Dormitorio</td>
                                    <td><?php echo htmlspecialchars($vivienda->recamaras ?? ''); ?></td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>

                      <tr>
                        <td colspan="2" class="clean-subtitle">Observaciones:</td>
                      </tr>
                      <tr>
                        <td colspan="2" class="note-box"><?php echo htmlspecialchars($vivienda->observacion ?? ''); ?>
                        </td>
                      </tr>
                    </table>
                  </td>

                  <!-- COLUMNA DERECHA -->
                  <td class="split-col viv-col-mid" style="width:50%; vertical-align:top; border-left:1px solid #000;">
                    <table class="tbl-clean">
                      <tr>
                        <td colspan="2" class="clean-subtitle">5.4. Características</td>
                      </tr>
                      <tr class="no-line">
                        <td class="lbl">Piso:</td>
                        <td><?php echo htmlspecialchars($vivienda->tipo_piso ?? ''); ?></td>
                      </tr>
                      <tr class="no-line">
                        <td class="lbl">Muros:</td>
                        <td><?php echo htmlspecialchars($vivienda->material_muros ?? ''); ?></td>
                      </tr>
                      <tr class="clean-line-light">
                        <td class="lbl">Techo:</td>
                        <td><?php echo htmlspecialchars($vivienda->material_techo ?? ''); ?></td>
                      </tr>

                      <tr>
                        <td colspan="2" class="clean-subtitle">5.5. Zona</td>
                      </tr>
                      <tr class="no-line">
                        <td>Urbana</td>
                        <td class="chk">
                          <?php echo(stripos((string) ($vivienda->tipo_zona ?? ''), 'urb') !== false && stripos((string) ($vivienda->tipo_zona ?? ''), 'sub') === false) ? '☒' : '☐'; ?>
                        </td>
                      </tr>
                      <tr class="no-line">
                        <td>Suburbana</td>
                        <td class="chk">
                          <?php echo(stripos((string) ($vivienda->tipo_zona ?? ''), 'sub') !== false) ? '☒' : '☐'; ?>
                        </td>
                      </tr>
                      <tr class="clean-line-light">
                        <td>Rural</td>
                        <td class="chk">
                          <?php echo(stripos((string) ($vivienda->tipo_zona ?? ''), 'rural') !== false) ? '☒' : '☐'; ?>
                        </td>
                      </tr>

                      <tr>
                        <td colspan="2" class="clean-subtitle">5.6. Menaje de casa</td>
                      </tr>
                      <tr class="no-line">
                        <td>Equipado</td>
                        <td class="chk"><?php echo((int) ($vivienda->nivel_menaje ?? 0) === 1) ? '☒' : '☐'; ?></td>
                      </tr>
                      <tr class="no-line">
                        <td>Básico</td>
                        <td class="chk"><?php echo((int) ($vivienda->nivel_menaje ?? 0) === 2) ? '☒' : '☐'; ?></td>
                      </tr>
                      <tr class="clean-line-light">
                        <td>Austero</td>
                        <td class="chk"><?php echo((int) ($vivienda->nivel_menaje ?? 0) === 3) ? '☒' : '☐'; ?></td>
                      </tr>

                      <tr>
                        <td colspan="2" class="clean-subtitle">5.7. Limpieza y Organización</td>
                      </tr>
                      <tr>
                        <td colspan="2"><?php echo htmlspecialchars($vivienda->limpieza_vivienda_texto ?? ''); ?></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>

            <!-- 6. INGRESOS -->
            <td style="width:18%;">
              <table class="tbl-clean">
                <tr>
                  <td colspan="2" class="clean-title">6. Total de Ingresos mensuales</td>
                </tr>

                <?php foreach ($ingresos_validos as $fam): ?>
                <tr class="ing-row">
                  <td style="width:66%;"><?php echo htmlspecialchars($fam->nombre ?? ''); ?></td>
                  <td class="val-r" style="width:34%;">
                    <?php echo '$' . number_format((float) $fam->sueldo, 2); ?>
                  </td>
                </tr>
                <?php endforeach; ?>

                <?php for ($i = count($ingresos_validos); $i < $max_filas_ing_eg; $i++): ?>
                <tr class="ing-row">
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <?php endfor; ?>

                <tr>
                  <td class="lbl">Total de ingresos</td>
                  <td class="val-r lbl"><?php echo '$' . number_format($total_ingresos_mensuales, 2); ?></td>
                </tr>
              </table>
            </td>

            <!-- 7. EGRESOS -->
            <td style="width:26%;">
              <table class="tbl-clean">
                <tr>
                  <td colspan="2" class="clean-title">7. Total de Egresos mensuales</td>
                </tr>

                <?php foreach ($egresos_items as $concepto => $valor): ?>
                <tr class="egr-row">
                  <td style="width:73%;"><?php echo htmlspecialchars($concepto); ?></td>
                  <td class="val-r" style="width:27%;">
                    <?php echo is_numeric($valor) ? '$' . number_format((float) $valor, 2) : ''; ?>
                  </td>
                </tr>
                <?php endforeach; ?>

                <?php for ($i = count($egresos_items); $i < $max_filas_ing_eg; $i++): ?>
                <tr class="egr-row">
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <?php endfor; ?>

                <tr class="clean-line">
                  <td class="lbl">Total de Egresos</td>
                  <td class="val-r lbl"><?php echo '$' . number_format($total_egresos_mensuales, 2); ?></td>
                </tr>

                <tr class="clean-line">
                  <td class="lbl">Diferencia</td>
                  <td class="val-r lbl"><?php echo '$' . number_format($diferencia, 2); ?></td>
                </tr>

                <tr>
                  <td colspan="2" class="tight-question">¿Cuándo tus gastos superan tus ingresos, como los solventas?
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="tight-answer"><?php echo htmlspecialchars($economia->solvencia ?? ''); ?></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>

      </td>
    </tr>
  </table>
</div>

<pagebreak />

<!-- =========================
     CUARTA SECCION
    ========================= -->
<div class="page-wrap">
  <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
    <tr>
      <td style="border:none; vertical-align:top;">
        <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
          <tr>

            <!-- IZQUIERDA TOTAL = 50% -->
            <td style="width:134.5mm; padding:0; vertical-align:top;">
              <table style="width:134.5mm; border-collapse:collapse; table-layout:fixed;">

                <!-- 8 -->
                <tr>
                  <td class="sec4-title">8. Motivo de estudio</td>
                </tr>
                <tr>
                  <td style="height:14mm; vertical-align:top; padding:2mm;">
                    <span class="sec4-label">1. Servicio o Apoyo Solicitado:</span><br>
                    <?php echo nl2br(htmlspecialchars($motivo_estudio)); ?>
                  </td>
                </tr>

                <!-- 9 -->
                <tr>
                  <td class="sec4-title">9. Fotografía de la vivienda</td>
                </tr>
                <tr>
                  <td style="padding:0;">
                    <table style="width:134.5mm; border-collapse:collapse; table-layout:fixed;">
                      <tr>

                        <!-- FOTO 1 -->
                        <td
                          style="width:67.25mm; height:85mm; padding:0; vertical-align:middle; text-align:center; overflow:hidden;">
                          <?php if (! empty($foto_vivienda_1)): ?>
                          <img src="<?php echo $foto_vivienda_1; ?>"
                            style="width:67.25mm; height:85mm; display:block; margin:0;">
                          <?php else: ?>
                          <div style="width:67.25mm; height:85mm; line-height:85mm; text-align:center;">
                            Sin fotografía
                          </div>
                          <?php endif; ?>
                        </td>

                        <!-- FOTO 2 -->
                        <td
                          style="width:67.25mm; height:85mm; padding:0; vertical-align:middle; text-align:center; overflow:hidden;">
                          <?php if (! empty($foto_vivienda_2)): ?>
                          <img src="<?php echo $foto_vivienda_2; ?>"
                            style="width:67.25mm; height:85mm; display:block; margin:0;">
                          <?php else: ?>
                          <div style="width:67.25mm; height:85mm; line-height:85mm; text-align:center;">
                            Sin fotografía
                          </div>
                          <?php endif; ?>
                        </td>

                      </tr>
                    </table>
                  </td>
                </tr>

                <!-- 11 -->
                <tr>
                  <td class="sec4-title">11. Salud</td>
                </tr>
                <tr>
                  <td style="padding:0; vertical-align:top;">
                    <table style="width:100%; border-collapse:collapse; table-layout:fixed; font-size:11px;">
                      <tr>
                        <td style="width:18%; padding:1mm;">IMSS <?php echo chkx($salud_imss); ?></td>
                        <td style="width:18%; padding:1mm;">ISSSTE <?php echo chkx($salud_issste); ?></td>
                        <td style="width:18%; padding:1mm;">SSJ <?php echo chkx($salud_ssj); ?></td>
                        <td style="width:18%; padding:1mm;">DIF <?php echo chkx($salud_dif); ?></td>
                        <td style="width:28%; padding:1mm;">Cruz Roja <?php echo chkx($salud_cruz_roja); ?></td>
                      </tr>
                      <tr>
                        <td style="padding:1mm;">SMMC <?php echo chkx($salud_smmc); ?></td>
                        <td colspan="2" style="padding:1mm;">Servicios Particulares
                          <?php echo chkx($salud_servicios_part); ?>
                        </td>
                        <td colspan="2" style="padding:1mm;">Medicina Alternativa
                          <?php echo chkx($salud_medicina_alternativa); ?></td>
                      </tr>
                      <tr>
                        <td colspan="5" style="padding:1mm; font-weight:bold;">
                          ENFERMEDADES CRÓNICAS O DISCAPACIDADES DE LA FAMILIA
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5" style="height:15mm; vertical-align:top; padding:1mm;">
                          <?php echo nl2br(htmlspecialchars($enfermedades_cronicas)); ?>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="5" style="padding:1mm; font-weight:bold;">Observaciones:</td>
                      </tr>
                      <tr>
                        <td colspan="5" style="height:12mm; vertical-align:top; padding:1mm;">
                          <?php echo nl2br(htmlspecialchars($observaciones_salud)); ?>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

              </table>
            </td>

            <!-- DERECHA TOTAL = 50% -->
            <td style="width:134.5mm; padding:0; vertical-align:top;">
              <table style="width:134.5mm; border-collapse:collapse; table-layout:fixed;">
                <tr>
                  <td class="sec4-title">10. Diagnóstico Social</td>
                </tr>
                <tr>
                  <td style="height:105.5mm; vertical-align:top; padding:2mm; font-size:11px;">
                    <?php echo nl2br(htmlspecialchars($diagnostico_social)); ?>
                  </td>
                </tr>
                <tr>
                  <td class="sec4-title">12. Sello de Validación</td>
                </tr>
                <tr>
                  <td style="height:51.5mm;"></td>
                </tr>
              </table>
            </td>

          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>

<pagebreak />

<div class="page-wrap">
  <table style="width:100%;">
    <tr>
      <td style="border:none; vertical-align:top;">

        <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
          <tr>
            <td class="sec4-title" style="width:134.5mm;">
              13.- En caso de que se le otorgue la beca, los compromisos que adquiere son:
            </td>
            <td class="sec4-title" style="width:134.5mm;">
              14.- En qué utilizan el dinero que ahorran de la beca:
            </td>
          </tr>

          <tr>
            <td style="height:42mm; vertical-align:top; padding:2mm; font-size:11px;">
              <?php echo nl2br(htmlspecialchars($becas->compromisos ?? '')); ?>
            </td>
            <td style="height:42mm; vertical-align:top; padding:2mm; font-size:11px;">
              <?php echo nl2br(htmlspecialchars($becas->uso_dinero ?? '')); ?>
            </td>
          </tr>

          <tr>
            <td class="sec4-title">15.- Conclusiones:</td>
            <td class="sec4-title">16.- Validación:</td>
          </tr>

          <tr>
            <td style="height:30mm; vertical-align:top; padding:2mm; font-size:11px;">
              <?php echo nl2br(htmlspecialchars($becas->conclusiones ?? '')); ?>
            </td>
            <td style="padding:0; vertical-align:top;">
              <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
                <tr>
                  <td style="padding:2mm; font-size:11px;">
                    <b>Nombre: Lic. en Trabajo Social </b>
                    <?php echo htmlspecialchars($datos_cedula->nombre ?? ''); ?>
                  </td>
                </tr>
                <tr>
                  <td style="padding:2mm; font-size:11px;">
                    <b>CÉDULA PROFESIONAL:</b> <?php echo htmlspecialchars($datos_cedula->cedula ?? ''); ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div style="padding:2mm; font-size:11px;">
                      <b> Firma</b>
                    </div>
                  </td>
                <tr>
                  <td style="height:40mm; padding:0; text-align:center; vertical-align:middle;">
                    <?php
                        $ruta_firma = '';

                        if (!empty($datos_cedula) && !empty($datos_cedula->firma)) {
                            $ruta_temp = FCPATH . 'img/' . $datos_cedula->firma;

                            if (file_exists($ruta_temp)) {
                                $ruta_firma = $ruta_temp;
                            }
                        }
                      ?>
                    <?php if (!empty($ruta_firma)): ?>
                    <img src="<?php echo $ruta_firma; ?>"
                      style="display:block; margin:0 auto; max-height:35mm; width:auto;">
                    <?php endif; ?>
                  </td>
                </tr>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td style="padding:0; vertical-align:top;">
        <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
          <tr>
            <td style="padding:1mm; font-weight:bold; font-size:11px;">
              Aplicó el estudio Socio-económico (Nombre, Firma y Fecha):
            </td>
          </tr>
          <tr>
            <td style="padding:1mm; font-size:11px;">
              <b>Nombre:</b> <?php echo htmlspecialchars($analista ?? ''); ?>
            </td>
          </tr>
          <tr>
            <td style="height:22mm; padding:1mm; font-size:11px; vertical-align:top;">
              <b>Firma:</b>

            </td>
          </tr>
          <tr>
            <td style="padding:1mm; font-size:11px; height:16mm;">
              <b>Fecha: <?php echo   $fecha_final ?></b>
            </td>
          </tr>
        </table>
      </td>

      <td style="padding:0; vertical-align:top;">
        <table style="width:100%; border-collapse:collapse; table-layout:fixed;">
          <tr>
            <td style="padding:2mm; font-weight:bold; font-size:11px;">
              Vo. Bo. Tesorería:
            </td>
          </tr>
          <tr>
            <td style="height:42mm;"></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  </td>
  </tr>
  </table>
</div>