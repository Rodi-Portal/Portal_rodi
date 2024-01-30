<!DOCTYPE html>
<html>
<head>
    
    <meta charset="UTF-8">
    <style>
    body{font-family: Arial, Helvetica, sans-serif;font-size: 12px}
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
    </style>
</head>
<body>

  <?php 
  $e = new DateTime($info->fecha_toma);
  $fecha_toma = $e->format('d/m/Y');

  $firma = base_url().'img/'.$area->firma;
  //$qr_consulta = base_url().'_qrconsult/'.$qr;

  ?>


  <div class="div_fecha">
    <p class=""><b>Zapopan, Jalisco a <?php echo $fecha_examen; ?></b></p><br>
  </div>

  <h4 class="centrado">GRUPO SANGUÍNEO</h4><br><br><br>

  <table class="table">
    <tr>
      <td>
        <p>NOMBRE: <b><?php echo strtoupper($info->paciente) ?></b></p>
      </td>
      <td>
        <p>FECHA: <b><?php echo $fecha_toma ?></b></p>
      </td>
    </tr>
    <tr>
      <td>
        <p>EDAD: <b><?php echo $info->edad.' AÑOS' ?></b></p>
      </td>
    </tr>
    <tr>
      <td>
        <p>SEXO: <b><?php echo strtoupper($info->genero) ?></b></p>
      </td>
    </tr>
    <tr>
      <td>
        <p>MÉDICO: <b><?php echo strtoupper($info->medico) ?></b></p>
      </td>
    </tr>

  </table>

  <br><br>

  <table class="table">
    <tr>
      <td class="centrado td_result">
        <p><b>EXAMEN</b></p>
      </td>
      <td class="centrado td_result">
        <p><b>RESULTADO</b></p>
      </td>
      <td class="centrado td_result">
        <p><b>UNIDADES</b></p>
      </td>
      <td class="centrado td_result">
        <p><b>VALOR DE REFERENCIA</b></p>
      </td>
    </tr>
    <tr>
      <td class="centrado"><?php echo strtoupper($info->tipo_examen) ?></td>
      <td class="centrado"><?php echo $info->resultado ?></td>
      <td class="centrado">N/A</td>
      <td class="centrado">N/A</td>
    </tr>
    <tr>
      <td colspan="4" class="centrado"></td>
    </tr>
  </table>

  <br><br>
  
  <div class="div_centrado centrado">
    <h5><?php echo 'MÉTODO: '.strtoupper($info->metodo) ?></h5>
  </div>

  <br><br><br><br><br>
  
  <?php 
  $cedula = (!empty($area->cedula))? '<span>Cédula Profesional: '.$area->cedula.'</span><br>' : '<span>Personal autorizado por laboratorio</span><br>';
  ?>
  <div style="width: 100%;">
    <div class="f-12" style="text-align:center; float: left; width:100%;">
      <img class="" width="220px" src="<?php echo $firma; ?>"><br><span><?php echo $area->profesion_responsable.' '.$area->responsable; ?></span><br><?php echo $cedula; ?><span>Laboratorio de Análisis</span><br><span>PERINTEX SC.</span><br><span>Cédula de licencia municipal: 580386</span><br><span>REG. SSA COFEPRIS: 21040912</span><br><img width="100px" src="<?php echo base_url().'img/qr_cofepris.jpg' ?>">
    </div>
  </div>
</body>
</html>