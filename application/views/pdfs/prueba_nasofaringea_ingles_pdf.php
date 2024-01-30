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
	.f-9 { font-size: 9px; }
	.f-10 { font-size: 10px; }
	.f-11 { font-size: 11px; }
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
  if($longitud > 40){
    $fuente = 'f-9';
  }
  if($longitud >= 25 && $longitud <= 40){
    $fuente = 'f-11';
  }
  if($longitud < 25){
    $fuente = 'f-12';
  }

  $firma = base_url().'img/'.$covid->firma;
  $qr_consulta = base_url().'_covid/'.$qr;

  ?>
	
  <br><br>
		<table class="tabla">
		  	<tr>
		    	<td width="25%" colspan="2">Patient:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior <?php echo $fuente;?> "><b> <?php echo $covid->nombre; ?> </b></span></td>
		    	<td width="40%">Order Number:&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->orden; ?> </b></span></td>
        </tr>
        <tr>
		    	<td width="40%">Age:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->edad; ?> </b></span></td>
		    	<td>Gender:   <span class="dato left borde-inferior f-12"><b> <?php echo $covid->genero; ?> </b></span></td>
		    	<td>Doctor:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->medico; ?> </b></span></td>
		  	</tr>
		  	<tr>
		    	<td colspan="2">Phone Number:&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->telefono; ?> </b></span></td>
		    	<td>Passport No.:&nbsp;&nbsp;&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $covid->pasaporte; ?> </b></span></td>
        </tr>
        <tr>
		    	<td colspan="2">Date of birth: &nbsp;&nbsp;&nbsp; <span class="dato left borde-inferior f-12"><b> <?php echo $covid->fecha_nacimiento; ?> </b></span></td>
		    	<td>Date of taking:&nbsp;&nbsp;<span class="dato left borde-inferior f-12"><b> <?php echo $fecha_toma; ?> </b></span></td>
		  	</tr>
    </table>
    <br><br>

    <table class="tabla_texto">
      <tr>
        <td class="center" colspan="3"><span style="border-bottom: 1px solid gray;"><b>SARS ANTIGEN - CoV2</b></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><b>COVID-19 (NASOPHARYNGEAL)</b></span></td>
      </tr>
      <tr>
        <td class="center" colspan="3"><span><b>IMMUNOCROMATOGRAPHIC TEST POC</b></span></td>
      </tr>
      <tr>
        <td width="23%"><span><b>Type: </b></span></td>
        <td colspan="2"><span>Specimen</span></td>
      </tr>
      <tr>
        <td width="23%"><span><b>Note: </b></span></td>
        <td colspan="2"><span>Nasopharyngeal / oropharyngeal swab</span></td>
      </tr>
      <tr>
        <td width="23%" class="left"><span> </span></td>
        <td colspan="2"><span>COFEPRIS: 203300401B1705, Oficio CAS/SESSDM/17969/2020</span></td>
      </tr>
      <tr>
        <td width="23%" class="left"><span> </span></td>
        <td colspan="2"><span class="f-14"><b>Observations: </b></span></td>
      </tr>
      <tr>
        <td width="23%" class="left"><span> </span></td>
        <td colspan="2"><b><span>Result  </span>&nbsp;&nbsp;&nbsp;<span class="f-14"> <?php echo $res = ($covid->resultado == "NEGATIVO")? "NEGATIVE":"POSITIVE"; ?> </span></b> &nbsp;&nbsp;&nbsp; Read comments</td>
      </tr>
      <tr>
        <td width="23%" class="left"><span> </span></td>
        <td colspan="2"><b><span>Reference Values   </span></td>
      </tr>
      <tr>
        <td width="23%" class="left"><span> </span></td>
        <td ><b><span class="f-14">Comment:  </span></td>
        <td><span>The SARS-Cov2 Rapid Antigen Test System is a qualitative and In vitro immunochromatographic for the detection of the Sars-CoV2 virus with a swab The fluid was extracted from the nasal cavity in real time and placed in a cassette to obtain the result/Colloidal gold method. <br>Instrument used: Nasopharyngeal Colloidal Gold Immunochromatographic Assay for COVID 19</span></td>
      </tr>
    </table>
    <br>

    <ul class="f-12">
      <li>Results are delivered at the request of the interested party, in case of having a negative result, the possibility of contracting the infection remains.</li>
      <li>Continue with hygienic practices, wear face mask at all times.</li>
      <li>Wash your hands with soap and wáter constantly.</li>
      <li>Do not touch your face or eyes with your hands.</li>
      <li>If it is POSITIVE you should isolate yourself for 14 days at home to avoid contagion to other people and call your doctor immediately</li>
      <li>Do not self-medicate</li>
    </ul>
    <br><br><br><br><br><br>

    <div style="width: 100%;">
      <div style="float:left; width:30%; margin-left: 25px; padding-top:33px;">
        <img width="100px" src="<?php echo base_url().'img/qr_municipal.jpeg' ?>">
      </div>
      <div class="f-12" style="float:left; width:35%; margin-top: 45px;">
      	<span style="border-top: 1px solid gray;"><?php echo $covid->profesion_responsable.' '.$covid->responsable; ?></span><br><span>Cédula Profesional: <?php echo $covid->cedula; ?></span><br>
        <span>Laboratorio de Análisis</span><br><span>PERINTEX SC.</span><br><span>Cédula de licencia municipal: 580386</span><br><span>REG. SSA COFEPRIS: 21040912</span>
      </div>
      <div style="text-align:center; width:30%; ">
        <img width="100px" src="<?php echo $qr_consulta; ?>">
      </div>
    </div>
</body>
</html>