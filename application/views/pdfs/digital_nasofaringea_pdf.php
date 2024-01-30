<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
</head>
<style>
  html, body{ height: 100%; }
  body { font-family: 'Arial'; font-size: 12px; }
  .col-md-2 { width: 16%; float: left; }
  .col-md-4 { width: 33%; float: left; }
  .col-md-4-2 { width: 33%; float: right; }
  .col-md-3 { width: 25%; float: left; }
  .col-md-6 { width: 48%; margin-left: 25px; float: left; }
  .col-md-6-2 { width: 48%; float: right; }
  .f-10 { font-size: 10px; }
  .f-12 { font-size: 12px; }
  .f-14 { font-size: 14px; }
  .f-16 { font-size: 16px; }
  .f-18 { font-size: 18px; }
  .f-20 { font-size: 20px; }
  .f-white { color: white; }
  .first{ height: 50px; border-bottom: 1px solid #081e26; }
  .firstSecond{ height: 50px; border-bottom: 1px solid #081e26; padding-top:1px;}
  .firstTitle{border-bottom: 1px solid #e5e5e5; padding-top: 0px; height: 20px;}
  .datos{ margin-left: 10px; margin-right: 10px;}
  .logo{ height: 50px; }
  .right{text-align: right;}
  .center{ text-align: center; }
  .left { text-align: left; }
  .centrado { margin: 0px auto; }
  .head{ padding-top: 0px;  }
  .title{ border-bottom: 1px solid #e5e5e5; padding-top: 5px; height: 5px; }
  h3{ font-size: 12px; }
  p{ padding-bottom: 2px; font-size: 11px; }
  .tabla { width: 100%; border: 2px solid #a3a3a3; padding: 10px; margin: 0 auto; font-size: 12px;}
  .tabla_texto { width:90%; border: none; padding: 5px; margin: 0 auto; font-size: 12px;border-collapse: collapse;}
  .borde-inferior { border-bottom: 1px solid gray; padding: 5px; }
  /*th, td { padding: 5px;}*/
  .media-tabla { width: 90%; }
  .encabezado { background: #d9dadb; }
  .comentario { width: 80%; border: 1px solid gray; }
  .margen-top { margin-top: 20px !important; }
  .margen-bottom { margin-bottom: 20px !important; }
  .w-10 { width: 10%; }
  .w-20 { width: 20%; }
  .w-30 { width: 30%; }
  .w-60 { width: 60%; }
  .w-80 { width: 80%; }
  .w-90 { width: 90%; }
  .w-100 { width: 100%; }
  .padding-5 { padding: 5px; }
  .padding-3 { padding: 3px; }
  .dato{margin-left: 3px !important;}
  .justificado{text-align: justify;}
  td{padding-top: 8px;}
</style>
<body>
  <?php
  $f = explode('-', $covid->dia_orden);
  $fecha_toma = $f[2].'/'.$f[1].'/'.$f[0];

  $longitud = strlen($covid->nombre);
  $fuente = ($longitud > 40)? 'f-10':'f-12';

  $firma = base_url().'img/'.$covid->firma;
  $qr_consulta = base_url().'_covid/'.$qr;


  ?>
  
    <table class="tabla">
        <tr>
          <td width="25%" colspan="2">Paciente:&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior <?php echo $fuente;?> "><b> <?php echo $covid->nombre; ?> </b></span></td>
          <td width="40%">No. De Orden:&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->orden; ?> </b></span></td>
        </tr>
        <tr>
          <td width="40%">Edad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->edad; ?> </b></span></td>
          <td>Género:   <span class="dato left borde-inferior f-12"><b> <?php echo $covid->genero; ?> </b></span></td>
          <td>Médico:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->medico; ?> </b></span></td>
        </tr>
        <tr>
          <td colspan="2">Télefono:&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->telefono; ?> </b></span></td>
          <td>Pasaporte:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->pasaporte; ?> </b></span></td>
        </tr>
        <tr>
          <td colspan="2">Fecha de nacimiento:   <span class="dato left borde-inferior f-12"><b> <?php echo $covid->fecha_nacimiento; ?> </b></span></td>
          <td>Fecha de toma:&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $fecha_toma; ?> </b></span></td>
        </tr>
    </table>
    <br><br>

    <table class="tabla_texto">
      <tr>
        <td class="center" colspan="3"><span style="border-bottom: 1px solid gray;"><b>ANTÍGENO SARS - CoV2</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>COVID-19 (NASOFARÍNGEA)</b></span></td>
      </tr>
      <tr>
        <td class="center" colspan="3"><span><b>PRUEBA INMUNOCROMATOGRÁFICA POC</b></span></td>
      </tr>
      <tr>
        <td width="23%"><span><b>Tipo: </b></span></td>
        <td colspan="2"><span>Espécimen</span></td>
      </tr>
      <tr>
        <td width="23%"><span><b>Nota: </b></span></td>
        <td colspan="2"><span>Hisopado nasofaríngeo / Orofaríngeo</span></td>
      </tr>
      <tr>
        <td width="23%" class="left"><span> </span></td>
        <td colspan="2"><span>COFEPRIS: 20330040181705, Oficio CAS/SESSDM/17969/2020</span></td>
      </tr>
      <tr>
        <td width="23%" class="left"><span> </span></td>
        <td colspan="2"><span class="f-14"><b>Observaciones: </b></span></td>
      </tr>
      <tr>
        <td width="23%" class="left"><span> </span></td>
        <td colspan="2"><b><span>Resultado  </span>&nbsp;&nbsp;&nbsp;<span class="f-14"> <?php echo $covid->resultado; ?> </span></b> &nbsp;&nbsp;&nbsp; Léase comentarios</td>
      </tr>
      <tr>
        <td width="23%" class="left"><span> </span></td>
        <td colspan="2"><b><span>Valores de referencia  </span></td>
      </tr>
      <tr>
        <td width="23%" class="left"><span> </span></td>
        <td ><b><span class="f-14">Comentario:  </span></td>
        <td><span>El sistema de prueba rápida de antígeno SARS-CoV2 es un ensayo cualitativo e inmunocromatográfico in vitro para la detección del virus SARS-Cov2 con hisopo. Se realizó la extracción de fluido de la cavidad nasal en tiempo real y se coloca en un casete para obtener el resultado / Método oro coloidal. <br>Instrumento utilizado Ensayo inmunocromatográfico de Oro Coloidal nasofaríngea para COVID-19</span></td>
      </tr>
    </table>

    <ul class="f-12">
      <li>Se entrega resultados a solicitud del interesado, en caso de tener un resultado negativo, la posibilidad de contraer la infección permanece.</li>
      <li>Seguir con los cuidados de higiene, portar cubre bocas en todo momento.</li>
      <li>Lavar manos con agua y jabón constantemente.</li>
      <li>No tocas la cara ni los ojos con las manos.</li>
      <li>En caso de resultar POSITIVO deberá aislarse por 14 días en su domicilio para evitar contagio a terceros y llamar a su médico tratante inmediatamente</li>
      <li>No se auto medique</li>
    </ul>
    <br>

    <div style="width: 100%;">
      <div class="f-12" style="text-align:center; float: left; width:70%; margin-left: 65px;">
        <img width="210px" src="<?php echo $firma; ?>"><br>
        <span><?php echo $covid->profesion_responsable.' '.$covid->responsable; ?></span><br><span>Cédula Profesional: <?php echo $covid->cedula; ?></span><br><span>Laboratorio de Análisis</span><br><span>PERINTEX SC.</span><br><span>Cédula de licencia municipal: 580386</span><br><span>REG. SSA COFEPRIS: 21040912</span><br><img width="130px" src="<?php echo base_url().'img/qr_municipal.jpeg' ?>">
      </div>
      <div style="float: left; width:20%;">
        <img src="<?php echo $qr_consulta; ?>">
      </div>
    </div>
    
</body>
</html>