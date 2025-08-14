<?php
/** @var object $intake */

function nr($v) { return (isset($v) && trim((string)$v) !== '') ? $v : 'No registrado'; }
function dmy($v) { if (!$v) return 'No registrado'; $ts = strtotime($v); return $ts ? date('d/m/Y', $ts) : $v; }
function sino($v){ $s = strtolower((string)$v); return $s==='si'?'Sí':($s==='no'?'No':'No registrado'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  body{font-family: Arial, Helvetica, sans-serif; font-size:11px}
  .centrado{text-align:center}
  .table{width:100%; border-collapse:collapse}
  th, td{padding:6px; font-size:13px; vertical-align:top}
  tr:nth-child(even){background:#f7f7f7}

  /* Color de sección */
  .titulo_seccion{
    background:#0C9DD3;    /* <-- color pedido */
    color:#fff;
    text-align:center;
    font-weight:bold
  }

  /* Detalles visuales opcionales */
  .badge{display:inline-block; padding:2px 6px; background:#e6f4fb; color:#0C9DD3; border-radius:4px}
  a{color:#0C9DD3; text-decoration:none}
</style>

</head>
<body>

<h2 class="centrado">
  Solicitud  #ID-<?= htmlspecialchars($intake->idReq ?? $intake->id) ?><br>
  Empresa: <?= htmlspecialchars($intake->nombre_c ?? $intake->razon_social ?? '—') ?><br>
  Fecha solicitud: <?= dmy($intake->fecha_solicitud ?? $intake->creacionR ?? $intake->creacion) ?>
</h2>

<!-- Datos de contacto -->
<table class="table">
  <tr><td class="titulo_seccion" colspan="2">Datos de contacto</td></tr>
  <tr>
    <td class="w-50">Nombre cliente: <b><?= htmlspecialchars(nr($intake->nombre_cliente)) ?></b></td>
    <td class="w-50">Método de comunicación: <b><?= htmlspecialchars(nr($intake->metodo_comunicacion)) ?></b></td>
  </tr>
  <tr>
    <td>Correo: <b><?= htmlspecialchars(nr($intake->email)) ?></b></td>
    <td>Teléfono: <b><?= htmlspecialchars(nr($intake->telefono)) ?></b></td>
  </tr>
</table>

<br>

<!-- Empresa / Ubicación -->
<table class="table">
  <tr><td class="titulo_seccion" colspan="2">Empresa / Ubicación</td></tr>
  <tr>
    <td class="w-50">Razón social: <b><?= htmlspecialchars(nr($intake->razon_social)) ?></b></td>
    <td class="w-50">NIT/RFC: <b><?= htmlspecialchars(nr($intake->nit)) ?></b></td>
  </tr>
  <tr>
    <td>País empresa: <b>
      <?php
        $pais = strtoupper((string)($intake->pais_empresa ?? ''));
        echo htmlspecialchars($pais);
        if ($pais === 'OTRO' && !empty($intake->pais_otro)) {
          echo ' (' . htmlspecialchars($intake->pais_otro) . ')';
        }
      ?>
    </b></td>
    <td>Sitio web:
      <?php if (!empty($intake->sitio_web)): ?>
        <a href="<?= htmlspecialchars($intake->sitio_web) ?>" target="_blank"><?= htmlspecialchars($intake->sitio_web) ?></a>
      <?php else: ?>
        <b>No registrado</b>
      <?php endif; ?>
    </td>
  </tr>
  <tr>
    <td colspan="2">Actividad de la empresa: <b><?= nl2br(htmlspecialchars(nr($intake->actividad))) ?></b></td>
  </tr>
</table>

<br>

<!-- Plan y Fechas -->
<table class="table">
  <tr><td class="titulo_seccion" colspan="2">Plan y fechas</td></tr>
  <tr>
    <td class="w-50">Plan: <b><?= htmlspecialchars(nr($intake->plan ?? $intake->puesto)) ?></b></td>
    <td class="w-50">Fecha de inicio: <b><?= dmy($intake->fecha_inicio) ?></b></td>
  </tr>
  <tr>
    <td>Horario: <b><?= htmlspecialchars(nr($intake->horario)) ?></b></td>
    <td>Sexo preferencia: <b><?= htmlspecialchars(nr($intake->sexo_preferencia)) ?></b></td>
  </tr>
  <tr>
    <td colspan="2">Rango de edad: <b><?= htmlspecialchars(nr($intake->rango_edad)) ?></b></td>
  </tr>
</table>

<br>

<!-- VoIP / CRM -->
<table class="table">
  <tr><td class="titulo_seccion" colspan="2">VoIP / CRM</td></tr>
  <tr>
    <td class="w-50">¿Requiere VoIP?: <b><?= sino($intake->requiere_voip) ?></b></td>
    <td class="w-50">¿Usa CRM?: <b><?= sino($intake->usa_crm) ?></b></td>
  </tr>
  <?php if (strtolower((string)$intake->requiere_voip) === 'si'): ?>
  <tr>
    <td>Propiedad VoIP: <b><?= htmlspecialchars(nr($intake->voip_propiedad)) ?></b></td>
    <td>País/Ciudad VoIP: <b><?= htmlspecialchars(nr($intake->voip_pais_ciudad)) ?></b></td>
  </tr>
  <?php endif; ?>
  <?php if (strtolower((string)$intake->usa_crm) === 'si'): ?>
  <tr>
    <td colspan="2">CRM: <b><?= htmlspecialchars(nr($intake->crm_nombre)) ?></b></td>
  </tr>
  <?php endif; ?>
</table>

<br>

<!-- Requisitos / Notas -->
<table class="table">
  <tr><td class="titulo_seccion" colspan="1">Requisitos / Notas</td></tr>
  <tr><td>Funciones:<br><b><?= nl2br(htmlspecialchars(nr($intake->funciones))) ?></b></td></tr>
  <tr><td>Requisitos:<br><b><?= nl2br(htmlspecialchars(nr($intake->requisitos))) ?></b></td></tr>
  <tr><td>Recursos:<br><b><?= nl2br(htmlspecialchars(nr($intake->recursos))) ?></b></td></tr>
  <tr><td>Observaciones:<br><b><?= nl2br(htmlspecialchars(nr($intake->observaciones))) ?></b></td></tr>
</table>

<br>

<!-- Documentos -->
<table class="table">
  <tr><td class="titulo_seccion" colspan="2">Documentos</td></tr>
  <tr>
    <td class="w-50">Archivo cargado:
      <?php if (!empty($intake->archivo_url)): ?>
        <b><a href="<?= htmlspecialchars($intake->archivo_url) ?>" target="_blank">Abrir archivo</a></b>
      <?php else: ?>
        <b>No registrado</b>
      <?php endif; ?>
    </td>
    <td class="w-50">Términos:
      <?php if (!empty($intake->terminos_url)): ?>
        <b><a href="<?= htmlspecialchars($intake->terminos_url) ?>" target="_blank">Abrir documento</a></b>
      <?php else: ?>
        <b>No registrado</b>
      <?php endif; ?>
    </td>
  </tr>
  <tr>
    <td colspan="2">Términos aceptados:
      <b><?=
        (string)$intake->acepta_terminos === '1'
          ? 'Aceptados'
          : ((string)$intake->acepta_terminos === '0' ? 'No aceptados' : '—')
      ?></b>
    </td>
  </tr>
</table>

<br>

<!-- Meta -->
<table class="table">
  <tr><td class="titulo_seccion" colspan="2">Metadatos</td></tr>
  <tr>
    <td class="w-50">Creado: <b><?= dmy($intake->creacionR ?? $intake->creacion) ?></b></td>
    <td class="w-50">Última edición: <b><?= dmy($intake->edicion) ?></b></td>
  </tr>
  <tr>
    <td colspan="2">Zona de trabajo (Req): <b><?= htmlspecialchars(nr($intake->zona_trabajo)) ?></b></td>
  </tr>
</table>

</body>
</html>
