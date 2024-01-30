<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <style>
    body{font-family: Arial, Helvetica, sans-serif;font-size: 11px}
    .div_fecha{text-align: right; padding-top: 20px;}
    .div_centrado{margin: 0px auto;background-color: #f2f2f2;}
    .justificado{text-align: justify;}
    .centrado{text-align: center;}
    .subrayado{text-decoration: underline;}
    .imagen { width: 600px; height: 750px; }
    .padding{ padding: 40px;}
    .margen_top{padding-top: 20px;}
    .linea{ padding-top: 0px; margin-top: 0px;}
    .table{width: 100%; max-width: 100%; background-color: transparent; margin: 0px auto; border-collapse:collapse; border: none;}
    .titulo_seccion{
      background-color: #5d7ca4;
      color: white;
    }
    .td_result{
      border: 1px solid #ddd !important;
    }
    th, td{padding: 5px;}
    td{text-align: left;height: 10px;font-size: 14px;}
    tr:nth-child(even) {background-color: #f2f2f2;}
    .w-10 { width: 10%; }
    .w-15 { width: 15%; }
    .w-17 { width: 17%; }
    .w-20 { width: 20%; }
    .w-25 { width: 25%;}
    .w-30 { width: 30%; }
    .w-40 { width: 40%; }
    .w-50 { width: 50%; }
    .w-60 { width: 60%; }
    .w-70 { width: 70%; }
    .w-75 { width: 75%; }
    .w-80 { width: 80%; }
    .w-90 { width: 90% !important; }
    .w-100 { width: 100% !important; }
  </style>
</head>
<body>
  <h2 class="centrado">Requisicion #<?php echo $requisicion->id ?> <br>Empresa: <?php echo $requisicion->nombre ?> <br>Fecha solicitud: <?php echo formatoFechaEspanolPDF($requisicion->creacion) ?></h2>
  
  <!-- Datos de contacto del solicitante -->
  <!-- <table class="table">
    <tr>
      <td class="titulo_seccion centrado" colspan="2">Datos de contacto</td>
    </tr>
    <tr>
      <td colspan="2">Contacto: <b><?php //echo $requisicion->contacto ?></b></td>
    </tr>
    <tr>
      <td class="w-50">Teléfono: <b><?php //echo $requisicion->telefono ?></b></td>
      <?php	//$correo = (empty($requisicion->correo))? 'No registrado' : $requisicion->correo; ?>
      <td class="w-50">Correo: <b><?php //echo $correo ?></b></td>
    </tr>
    <tr>
      <?php	//$domicilio = (empty($requisicion->domicilio))? 'No registrado' : $requisicion->domicilio; ?>
			<?php	//$cp = (empty($requisicion->cp))? '' : $requisicion->cp; ?>
      <td colspan="2">Domicilio fiscal: <b><?php //echo $domicilio.' '.$cp ?></b></td>
    </tr>
  </table>
   -->
  <br>
  <!-- Vacante -->
  <table class="table">
    <tr>
      <td class="titulo_seccion centrado" colspan="3">Información de la vacante</td>
    </tr>
    <tr>
      <td colspan="3">Puesto: <b><?php echo strtoupper($requisicion->puesto) ?></b></td>
    </tr>
    <tr>
      <td class="w-30">Cantidad: <b><?php echo $requisicion->numero_vacantes ?></b></td>
      <?php $genero = $requisicion->genero ?? 'No registrado'; ?>
      <td class="w-30">Sexo: <b><?php echo $genero ?></b></td>
      <?php $estado_civil = $requisicion->estado_civil ?? 'No registrado'; ?>
      <td class="w-40">Estado civil: <b><?php echo $estado_civil ?></b></td>
    </tr>
    <tr>
			<?php	$edad_minima = (empty($requisicion->edad_minima))? 'No registrado' : $requisicion->edad_minima; ?>
      <td>Edad mínima: <b><?php echo $edad_minima ?></b></td>
			<?php	$edad_maxima = (empty($requisicion->edad_maxima))? 'No registrado' : $requisicion->edad_maxima; ?>
      <td>Edad máxima: <b><?php echo $edad_maxima ?></b></td>
      <?php $discapacidad_aceptable = $requisicion->discapacidad_aceptable ?? 'No registrado'; ?>
      <td>Discapacidad aceptable: <b><?php echo $discapacidad_aceptable ?></b></td>
    </tr>
    <tr>
			<?php	$lugar_residencia = (empty($requisicion->lugar_residencia))? 'No registrado' : $requisicion->lugar_residencia; ?>
      <td colspan="3">Lugar de residencia: <b><?php echo $lugar_residencia ?></b></td>
    </tr>
    <tr>
      <?php $escolaridad = $requisicion->escolaridad ?? 'No registrado'; ?>
      <td colspan="2">Formación académica requerida: <b><?php echo $escolaridad; ?></b></td>
			<?php	$estatus_escolar = ($requisicion->estatus_escolar == 'Otro')? $requisicion->otro_estatus_escolar : $requisicion->estatus_escolar ?? 'No registrado'; ?>
      <td>Estatus académico: <b><?php echo $estatus_escolar ?></b></td>
    </tr>
    <tr>
      <?php $carrera_requerida = $requisicion->carrera_requerida ?? 'No registrado'; ?>
      <td colspan="2">Carrera requerida para el puesto: <b><?php echo $carrera_requerida; ?></b></td>
      <?php $otros_estudios = $requisicion->otros_estudios ?? 'No registrado'; ?>
      <td>Otros estudios: <b><?php echo $otros_estudios ?></b></td>
    </tr>
    <tr>
			<?php	$idiomas = (empty($requisicion->idiomas))? 'No registrado' : $requisicion->idiomas; ?>
      <td colspan="2">Idiomas: <b><?php echo $idiomas ?></b></td>
      <?php $licencia = $requisicion->licencia ?? 'No registrado'; ?>
      <td>Licencia de conducir: <b><?php echo $licencia ?></b></td>
    </tr>
    <tr>
			<?php	$habilidad_informatica = (empty($requisicion->habilidad_informatica))? 'No registrado' : $requisicion->habilidad_informatica; ?>
      <td colspan="3">Habilidades informáticas: <b><?php echo $habilidad_informatica ?></b></td>
    </tr>
    <tr>
      <?php $causa_vacante = $requisicion->causa_vacante ?? 'No registrado'; ?>
      <td colspan="3">Causa que origina la vacante: <b><?php echo $causa_vacante ?></b></td>
    </tr>
  </table>

  <br>
  <!-- Puesto Parte 1-->
  <table class="table">
    <tr>
      <td class="titulo_seccion centrado" colspan="2">Información del puesto</td>
    </tr>
    <tr>
      <?php $jornada_laboral = $requisicion->jornada_laboral ?? 'No registrado'; ?>
      <td class="w-50">Jornada laboral: <b><?php echo $jornada_laboral ?></b></td>
      <?php $sueldo = $requisicion->sueldo ?? 'No registrado'; ?>
      <td class="w-50">Tipo de sueldo: <b><?php echo $sueldo ?></b></td>
    </tr>
    <tr>
    <?php $tiempo_inicio = $requisicion->tiempo_inicio ?? 'No registrado'; ?>
      <td>Inicio de la Jornada: <b><?php echo $tiempo_inicio ?></b></td>
			<?php	$sueldo_minimo = (empty($requisicion->sueldo_minimo))? 'No registrado' : $requisicion->sueldo_minimo; ?>
      <td>Sueldo mínimo: <b><?php echo $sueldo_minimo ?></b></td>
    </tr>
    <tr>
    <?php $tiempo_final = $requisicion->tiempo_final ?? 'No registrado'; ?>
      <td>Fin de la Jornada: <b><?php echo $tiempo_final ?></b></td>
			<?php	$sueldo_maximo = (empty($requisicion->sueldo_maximo))? 'No registrado' : $requisicion->sueldo_maximo; ?>
      <td>Sueldo máximo: <b><?php echo $sueldo_maximo ?></b></td>
    </tr>
    <tr>
      <?php $dias_descanso = $requisicion->dias_descanso ?? 'No registrado'; ?>
      <td>Día(s) de descanso: <b><?php echo $dias_descanso ?></b></td>
      <?php $sueldo_adicional = $requisicion->sueldo_adicional ?? 'No registrado'; ?>
      <td>Sueldo adicional: <b><?php echo $sueldo_adicional ?></b></td>
    </tr>
    <tr>
      <?php $disponibilidad_viajar = $requisicion->disponibilidad_viajar ?? 'No registrado'; ?>
      <td>Disponibilidad para viajar: <b><?php echo $disponibilidad_viajar ?></b></td>
      <td>Tipo de pago: <b><?php echo $requisicion->tipo_pago_sueldo ?></b></td>
    </tr>
    <tr>
      <?php $disponibilidad_horario = $requisicion->disponibilidad_horario ?? 'No registrado'; ?>
      <td>Disponibilidad de horario: <b><?php echo $disponibilidad_horario ?></b></td>
      <td>¿Tendrá prestaciones de ley?: <b><?php echo $requisicion->tipo_prestaciones ?></b></td>
    </tr>
    <tr>
      <?php $tipo_prestaciones_superiores = (empty($requisicion->tipo_prestaciones_superiores))? 'No registrado' : $requisicion->tipo_prestaciones_superiores; ?>
      <td colspan="2">¿Tendrá prestaciones superiores? ¿Cuáles?: <b><?php echo $tipo_prestaciones_superiores ?></b></td>
    </tr>
    <tr>
      <?php $otras_prestaciones = (empty($requisicion->otras_prestaciones))? 'No registrado' : $requisicion->otras_prestaciones; ?>
      <td colspan="2">¿Tendrá otro tipo de prestaciones? ¿Cuáles?: <b><?php echo $otras_prestaciones ?></b></td>
    </tr>
  </table>

  <pagebreak>

  <!-- Puesto Parte 2-->
  <table class="table">
    <tr>
      <td class="titulo_seccion centrado" colspan="2">Información del puesto</td>
    </tr>
    <tr>
      <?php $zona_trabajo = $requisicion->zona_trabajo ?? 'No registrado'; ?>
      <td colspan="2">Zona de trabajo: <b><?php echo $zona_trabajo ?></b></td>
    </tr>
    <tr>
			<?php	$experiencia = (empty($requisicion->experiencia))? 'No registrado' : $requisicion->experiencia; ?>
      <td colspan="2">Experiencia: <b><?php echo $experiencia ?></b></td>
    </tr>
    <tr>
      <?php $actividades = $requisicion->actividades ?? 'No registrado'; ?>
      <td colspan="2">Actividades: <b><?php echo $actividades ?></b></td>
    </tr>
  </table>

  <br>
  <!-- Perfil -->
  <table class="table">
    <tr>
      <td class="titulo_seccion centrado" colspan="2">Perfil</td>
    </tr>
    <tr>
      <td class="centrado">Competencias requeridas para el puesto:</td>
      <?php 
      if(empty($requisicion->competencias))
        $competencias = 'No registrado';
      else 
        $competencias = substr(str_replace('_',',',$requisicion->competencias), 0, -1); ?>
    </tr>
    <tr>
      <td class="centrado"><b><?php echo $competencias ?></b></td>
    </tr>
    <tr>
      <td class="centrado">Observaciones adicionales:</td>
    </tr>
    <tr>
			<?php	$observaciones = (empty($requisicion->observaciones))? 'No registrado' : $requisicion->observaciones; ?>
      <td class="centrado"><b><?php echo $observaciones ?></b></td>
    </tr>
  </table>

  <br>

</body>
</html>