<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Candidate form | RODI</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

	<script src="https://kit.fontawesome.com/fdf6fee49b.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<!-- Select Bootstrap -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
	<!-- Sweetalert 2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>img/favicon.jpg" />
	
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <style>
    body{
      /* background-image: url('../img/rodi_icon.png');
      background-position-y: 0;
      background-position-x: 50%;
      background-size: 30%;
      background-repeat: no-repeat; */
      font-family: Roboto;
    }
    .contenedor {
      display: flex;        
      flex-wrap: wrap;  
      justify-content: center;
      gap: 20px;    
      flex: 1;          
    }
    .bloque{
      border-color: #0a39a6;
      /* border-radius: 20px; */
      padding: 30px;
      /* background-color: white; */
      /* width: 50%; */
    }
    .card {
      overflow: hidden;
      position: relative;
      text-align: left;
      border-radius: 0.5rem;
      /* max-width: 290px; */
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      /* background-color: #f2f2f2; */
      width: 100%;
    }

    .dismiss {
      position: absolute;
      right: 10px;
      top: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0.5rem 1rem;
      background-color: #fff;
      color: black;
      border: 2px solid #D1D5DB;
      font-size: 1rem;
      font-weight: 300;
      width: 30px;
      height: 30px;
      border-radius: 7px;
      transition: .3s ease;
    }

    .dismiss:hover {
      background-color: #ee0d0d;
      border: 2px solid #ee0d0d;
      color: #fff;
    }

    .header {
      padding: 1.25rem 1rem 1rem 1rem;
    }

    .image {
      display: flex;
      margin-left: auto;
      margin-right: auto;
      background-color: white;
      flex-shrink: 0;
      justify-content: center;
      align-items: center;
      width: 3rem;
      height: 3rem;
      border-radius: 9999px;
      animation: animate .6s linear alternate-reverse infinite;
      transition: .6s ease;
    }

    .image svg {
      color: #0afa2a;
      width: 2rem;
      height: 2rem;
    }

    .content { margin-top: 0.75rem; text-align: center; }

    .title {
      color: #0a39a6;
      font-size: 1rem;
      font-weight: 600;
      line-height: 1.5rem;
    }

    .message {
      margin-top: 0.5rem;
      color: #595b5f;
      font-size: 0.875rem;
      line-height: 1.25rem;
    }

    .actions {
      margin: 0.75rem 1rem;
    }

    .open-form {
      display: inline-flex;
      padding: 0.5rem 1rem;
      background-color: #0a39a6;
      color: #ffffff;
      font-size: 1rem;
      line-height: 1.5rem;
      font-weight: 500;
      justify-content: center;
      width: 100%;
      border-radius: 0.375rem;
      border: none;
      box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .track {
      display: inline-flex;
      margin-top: 0.75rem;
      padding: 0.5rem 1rem;
      color: #242525;
      font-size: 1rem;
      line-height: 1.5rem;
      font-weight: 500;
      justify-content: center;
      width: 100%;
      border-radius: 0.375rem;
      border: 1px solid #D1D5DB;
      background-color: #fff;
      box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    @keyframes animate {
      from {
        transform: scale(1);
      }

      to {
        transform: scale(1.09);
      }
    }
    .loader {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      z-index: 9999;
      background: url('../img/loader.gif') 50% 50% no-repeat rgba(0,0,0,0.5);
      background-size: 150px 150px;
      opacity: 1;
    }
    .modal-header{
      background-color: #0a39a6;
      color: white;
    }
    .close{
      color: white;
    }
    button.card-close{
      padding: 0;
      background-color: transparent;
      border: 0;
    }
    .card-close{
      cursor: pointer;
      float: right;
      font-size: 2.5rem;
      font-weight: 700;
      line-height: 1.2;
      color: white;
      text-shadow: 0 1px 0 #fff;
      opacity: .5;
      padding-right: 0.4rem !important;
    }
    @media (max-width: 768px) {
      /* Cambios para pantallas más pequeñas */
      /* .contenedor {
        flex-direction: column; /* Los divs se apilan en pantallas pequeñas */
      } */
      /* .bloque{
        width: 100%;
      } */
    }
  </style>
</head>

<body>
  <header>
    <nav class="navbar navbar-dark" style="background-color: #0a39a6;">
      <a class="navbar-brand" href="#">
        <img src="<?php echo base_url(); ?>img/rodi_icon.png" width="30" height="30" class="d-inline-block align-top" alt="RODI">
        <?php echo $nombre.' '.$paterno ?>
      </a>
      <ul class="nav justify-content-end">
        <li class="nav-item">
          <a class="nav-link text-light active" href="<?php echo base_url(); ?>Login/logout"><i class="fas fa-sign-out-alt"></i> Sign out</a>
        </li>
      </ul>
    </nav>
  </header>
  <main>
	  <div class="loader" style="display: none;"></div>
    <div class="modal fade" id="formularioModal" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="titleForm"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="dataForm">
              <div class="row" id="rowForm"></div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btnSubmitForm">Save</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="checkAvisoModal" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Important notice</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <?php if($candidato->id_cliente == 96){  

            $privacy_notice = 'non-disclosure-rts.pdf' ;

            }elseif($candidato->id_cliente == 2){

            $privacy_notice = 'non-disclosure-hcl.pdf';
            }
              else{
            $privacy_notice = 'non-disclosure.pdf';
              }   ?>
            <h5 class="mb-5">You can download the Non-disclosure agreement <b><a class="" href="<?php echo base_url() . "privacy_notice/" . $privacy_notice ?>" target="_blank">Here.</a></b> Don't forget to sign it.</h5>
            <div class="row">
              <div class="col-4 offset-4">
                <label>Select the file *</label><br>
                <input id="doc_aviso" class="form-control" type="file" name="doc_aviso" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="subirArchivos(8, <?php echo $candidato->id ?>, 'doc_aviso')">Upload the non-disclosure agreement</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="nuevoFamiliarModal" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="tituloNuevoRegistroModal"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="rowNuevoFamiliar" class="row escrolable"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="mensajeModal" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="titulo_mensaje"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h4 id="mensaje"></h4>
            <div id="campos_mensaje"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" id="btnConfirmar">Accept</button>
          </div>
        </div>
      </div>
    </div>
    <?php 
    if($tiene_aviso > 0){ ?>
      <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
        <strong>Se recomienda usar Google Chrome / Google Chrome is recommended</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="alert alert-warning text-center"><h5><b>Please complete and save each form. Upload all required files in PDF or image format(jpg, jpeg, png and 2MB max. each). Every file must uploaded separately by clicking on "Click here to upload" button. When you have finished both, click on the "Finish" button at the bottom of this page so that your information can be reviewed by our analysts.  </b></h5></div>
      <div class="row w-100 m-auto mt-3">
        <div class="col-sm-12 col-md-6 col-lg-6 bloque mt-1 mb-1">
          <h4 class="text-center">FORMS</h4>
          <div class="row mb-3" id="divForms">
            <?php 
            if(!empty($secciones)){
              //* Se evalua si el candidato cuenta con avances en las secciones
              $icono_generales = '<i class="fas fa-user"></i>'; $css_generales = ''; $estatus_generales = '';
              $icono_estudios = '<i class="fas fa-graduation-cap"></i>'; $css_estudios = ''; $estatus_estudios = '';
              $icono_laboral = '<i class="fas fa-info-circle"></i>'; $css_laboral = ''; $estatus_laboral = '';
              $icono_familiares = '<i class="fas fa-users"></i>'; $css_familiares = ''; $estatus_familiares = '';
              $icono_personales = '<i class="fas fa-address-book"></i>'; $css_personales = ''; $estatus_personales = '';
              $icono_domicilios = '<i class="fas fa-map-marker-alt"></i>'; $css_domicilios = ''; $estatus_domicilios = '';
              $icono_gaps = '<i class="fas fa-hourglass-half"></i>'; $css_gaps = ''; $estatus_gaps = '';
              $icono_profesionales = '<i class="fas fa-user-tie"></i>'; $css_profesionales = ''; $estatus_profesionales = '';
              $icono_academicas = '<i class="fas fa-user-graduate"></i>'; $css_academicas = ''; $estatus_academicas = '';
              if(!empty($avances)){
                foreach($avances as $avance){
                  if($avance->seccion == 'general'){
                    $icono_generales = '<i class="fas fa-check text-white"></i>';
                    $css_generales = 'background-color:#2bfa28;color:white;';
                    $estatus_generales = 'Completed';
                  }
                  if($avance->seccion == 'estudio'){
                    $icono_estudios = '<i class="fas fa-check text-white"></i>';
                    $css_estudios = 'background-color:#2bfa28;color:white;';
                    $estatus_estudios = 'Completed';
                  }
                  if($avance->seccion == 'laborales'){
                    $icono_laboral = '<i class="fas fa-check text-white"></i>';
                    $css_laboral = 'background-color:#6d95f2;color:white;';
                    $estatus_laboral = 'Updated';
                  }
                  if($avance->seccion == 'familiares'){
                    $icono_familiares = '<i class="fas fa-check text-white"></i>';
                    $css_familiares = 'background-color:#2bfa28;color:white;';
                    $estatus_familiares = 'Completed';
                  }
                  if($avance->seccion == 'personales'){
                    $icono_personales = '<i class="fas fa-check text-white"></i>';
                    $css_personales = 'background-color:#6d95f2;color:white;';
                    $estatus_personales = 'Updated';
                  }
                  if($avance->seccion == 'domicilios'){
                    $icono_domicilios = '<i class="fas fa-check text-white"></i>';
                    $css_domicilios = 'background-color:#6d95f2;color:white;';
                    $estatus_domicilios = 'Updated';
                  }
                  if($avance->seccion == 'gaps'){
                    $icono_gaps = '<i class="fas fa-check text-white"></i>';
                    $css_gaps = 'background-color:#2bfa28;color:white;';
                    $estatus_gaps = 'Completed';
                  }
                  if($avance->seccion == 'profesionales'){
                    $icono_profesionales = '<i class="fas fa-check text-white"></i>';
                    $css_profesionales = 'background-color:#6d95f2;color:white;';
                    $estatus_profesionales = 'Updated';
                  }
                  if($avance->seccion == 'academicas'){
                    $icono_academicas = '<i class="fas fa-check text-white"></i>';
                    $css_academicas = 'background-color:#6d95f2;color:white;';
                    $estatus_academicas = 'Updated';
                  }
                }
              }
              if($secciones->id_seccion_datos_generales != null){ ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                  <div class="card"> 
                    <div class="header"> 
                      <div class="image" style="<?php echo $css_generales ?>">
                      <?php $descripcionEstatus = $estatus_generales == 'Completed' ? 'This information has been completed' : ($estatus_generales == 'Updated' ? 'This information has been updated. It will be reviewed by our analysts to determine if the information is complete or if additional information is required.' : ''); ?>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $descripcionEstatus ?>"><?php echo $icono_generales ?></a>
                      </div> 
                      <div class="content">
                        <span class="title">General Data</span> 
                        <p class="message">This section includes information such as place of birth, nationality, current address, marital status and others.</p> 
                      </div> 
                      <div class="actions">
                        <button class="open-form" id="btnGenerales" type="button" onclick="getGeneralData(<?php echo $candidato->id ?>,<?php echo $secciones->id_seccion_datos_generales ?>,<?php echo $candidato->id_cliente ?>,<?php echo $candidato->ingles ?>)">Open Form</button> 
                        <p class="text-center mt-2"><b> <?php echo $estatus_generales ?> </b></p> 
                      </div> 
                    </div> 
                  </div>
                </div>
              <?php
              }
              if(!empty($secciones->id_estudios)){
                if($secciones->id_estudios != 3){ ?>
                  <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                    <div class="card"> 
                      <div class="header"> 
                        <div class="image" style="<?php echo $css_estudios ?>">
                        <?php $descripcionEstatus = $estatus_estudios == 'Completed' ? 'This information has been completed' : ($estatus_estudios == 'Updated' ? 'This information has been updated. It will be reviewed by our analysts to determine if the information is complete or if additional information is required.' : ''); ?>
                          <a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $descripcionEstatus ?>"><?php echo $icono_estudios ?></a>
                        </div> 
                        <div class="content">
                          <span class="title">Studies Record</span> 
                          <p class="message">This section includes your highest level of education or your entire educational history, depending on what your employer requires..</p> 
                        </div> 
                        <div class="actions">
                          <button class="open-form" id="btnEstudios" type="button" onclick="getStudiesRecord(<?php echo $candidato->id ?>,<?php echo $secciones->id_estudios ?>,<?php echo $candidato->id_cliente ?>)">Open Form</button> 
                          <p class="text-center mt-2"><b> <?php echo $estatus_estudios ?> </b></p> 
                        </div> 
                      </div> 
                    </div>
                  </div>
                <?php 
                }else{ ?>
                  <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                      <div class="card"> 
                        <div class="header"> 
                          <div class="image" style="<?php echo $css_estudios ?>">
                          <?php $descripcionEstatus = $estatus_estudios == 'Completed' ? 'This information has been completed' : ($estatus_estudios == 'Updated' ? 'This information has been updated. It will be reviewed by our analysts to determine if the information is complete or if additional information is required.' : ''); ?>
                            <a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $descripcionEstatus ?>"><?php echo $icono_estudios ?></a>
                          </div> 
                          <div class="content">
                            <span class="title">Highest Studies</span> 
                            <p class="message">This section includes your highest level of education or your entire educational history, depending on what your employer requires..</p> 
                          </div> 
                          <div class="actions">
                            <button class="open-form" id="btnEstudios" type="button" onclick="getHighestStudies(<?php echo $candidato->id ?>,<?php echo $secciones->id_estudios ?>,<?php echo $candidato->id_cliente ?>)">Open Form</button> 
                            <p class="text-center mt-2"><b> <?php echo $estatus_estudios ?> </b></p> 
                          </div> 
                        </div> 
                      </div>
                    </div>
              <?php
                }
              }
              if(!empty($secciones->id_empleos)){ ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                  <div class="card"> 
                    <div class="header"> 
                      <div class="image" style="<?php echo $css_laboral ?>">
                      <?php $descripcionEstatus = $estatus_laboral == 'Completed' ? 'This information has been completed' : ($estatus_laboral == 'Updated' ? 'This information has been updated. It will be reviewed by our analysts to determine if the information is complete or if additional information is required.' : ''); ?>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $descripcionEstatus ?>"><?php echo $icono_laboral ?></a>
                      </div> 
                      <div class="content">
                        <span class="title">Employment History</span> 
                        <?php $tiempo_empleos = ($secciones->tiempo_empleos != 'All')? $secciones->tiempo_empleos : '10 years'; ?>
                        <p class="message">This section is for recording your job information in the last <?php echo $tiempo_empleos; ?>, such as your position in the company and the reason for your departure.</p> 
                      </div> 
                      <div class="actions">
                        <button class="open-form" id="btnEmpleos" type="button" onclick="getEmploymentHistory(<?php echo $candidato->id ?>,<?php echo $secciones->id_empleos ?>,<?php echo $candidato->id_cliente ?>,'<?php echo $candidato->nombre.' '.$candidato->paterno.' '.$candidato->materno ?>','<?php echo $secciones->tiempo_empleos ?>','<?php echo htmlspecialchars($candidato->trabajo_gobierno) ?>','<?php echo htmlspecialchars($candidato->trabajo_inactivo) ?>')">Open Form</button> 
                        <p class="text-center mt-2"><b> <?php echo $estatus_laboral ?> </b></p> 
                      </div> 
                    </div> 
                  </div>
                </div>
              <?php
              }
              if($secciones->lleva_familiares == 1){ ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                  <div class="card"> 
                    <div class="header"> 
                      <div class="image" style="<?php echo $css_familiares ?>">
                      <?php $descripcionEstatus = $estatus_familiares == 'Completed' ? 'This information has been completed' : ($estatus_familiares == 'Updated' ? 'This information has been updated. It will be reviewed by our analysts to determine if the information is complete or if additional information is required.' : ''); ?>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $descripcionEstatus ?>"><?php echo $icono_familiares ?></a>
                      </div> 
                      <div class="content">
                        <span class="title">Family Members</span> 
                        <p class="message">This section is to register relevant data about your family and the family members with whom you live.</p> 
                      </div> 
                      <div class="actions">
                        <button class="open-form" id="btnFamiliares" type="button" onclick="getFamilyMembers(<?php echo $candidato->id ?>,35,<?php echo $candidato->id_cliente ?>,'<?php echo $candidato->nombre.' '.$candidato->paterno.' '.$candidato->materno ?>')">Open Form</button> 
                        <p class="text-center mt-2"><b> <?php echo $estatus_familiares ?> </b></p> 
                      </div> 
                    </div> 
                  </div>
                </div>
              <?php
              }
              if($secciones->id_ref_personales != null && $secciones->cantidad_ref_personales > 0){ ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                  <div class="card"> 
                    <div class="header"> 
                      <div class="image" style="<?php echo $css_personales ?>">
                      <?php $descripcionEstatus = $estatus_personales == 'Completed' ? 'This information has been completed' : ($estatus_personales == 'Updated' ? 'This information has been updated. It will be reviewed by our analysts to determine if the information is complete or if additional information is required.' : ''); ?>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $descripcionEstatus ?>"><?php echo $icono_personales ?></a>
                      </div> 
                      <div class="content">
                        <span class="title">Personal references</span> 
                        <p class="message">Basic information about your personal references is required, please fill in the forms for all personal references.</p>
                      </div> 
                      <div class="actions">
                        <button class="open-form" id="btnRefPersonales" type="button" onclick="getPersonalReferences(<?php echo $candidato->id ?>,<?php echo $secciones->id_ref_personales ?>,<?php echo $candidato->id_cliente ?>,'<?php echo $candidato->nombre.' '.$candidato->paterno.' '.$candidato->materno ?>','<?php echo $secciones->cantidad_ref_personales ?>')">Open Form</button> 
                        <p class="text-center mt-2"><b> <?php echo $estatus_personales ?> </b></p> 
                      </div> 
                    </div> 
                  </div>
                </div>
              <?php
              }
              if($secciones->id_ref_profesional != null && $secciones->cantidad_ref_profesionales > 0){ ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                  <div class="card"> 
                    <div class="header"> 
                      <div class="image" style="<?php echo $css_profesionales ?>">
                      <?php $descripcionEstatus = $estatus_profesionales == 'Completed' ? 'This information has been completed' : ($estatus_profesionales == 'Updated' ? 'This information has been updated. It will be reviewed by our analysts to determine if the information is complete or if additional information is required.' : ''); ?>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $descripcionEstatus ?>"><?php echo $icono_profesionales ?></a>
                      </div> 
                      <div class="content">
                        <span class="title">Professional references</span> 
                        <p class="message">Basic information about your professional references is required, please fill in the forms for all professional references.</p>
                      </div> 
                      <div class="actions">
                        <button class="open-form" id="btnRefProfesionales" type="button" onclick="getProfessionalReferences(<?php echo $candidato->id ?>,<?php echo $secciones->id_ref_profesional ?>,<?php echo $candidato->id_cliente ?>,'<?php echo $candidato->nombre.' '.$candidato->paterno.' '.$candidato->materno ?>','<?php echo $secciones->cantidad_ref_profesionales ?>','<?php echo $candidato->ingles ?>')">Open Form</button> 
                        <p class="text-center mt-2"><b> <?php echo $estatus_profesionales ?> </b></p> 
                      </div> 
                    </div> 
                  </div>
                </div>
              <?php
              }
              if($secciones->id_ref_academica != null && $secciones->cantidad_ref_academicas > 0){ ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                  <div class="card"> 
                    <div class="header"> 
                      <div class="image" style="<?php echo $css_academicas ?>">
                      <?php $descripcionEstatus = $estatus_academicas == 'Completed' ? 'This information has been completed' : ($estatus_academicas == 'Updated' ? 'This information has been updated. It will be reviewed by our analysts to determine if the information is complete or if additional information is required.' : ''); ?>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $descripcionEstatus ?>"><?php echo $icono_academicas ?></a>
                      </div> 
                      <div class="content">
                        <span class="title">Academic references</span> 
                        <p class="message">Basic information about your academic references is required, please fill in the forms for all academic references.</p>
                      </div> 
                      <div class="actions">
                        <button class="open-form" id="btnRefAcademicas" type="button" onclick="getAcademicReferences(<?php echo $candidato->id ?>,<?php echo $secciones->id_ref_academica ?>,<?php echo $candidato->id_cliente ?>,'<?php echo $candidato->nombre.' '.$candidato->paterno.' '.$candidato->materno ?>','<?php echo $secciones->cantidad_ref_academicas ?>','<?php echo $candidato->ingles ?>')">Open Form</button> 
                        <p class="text-center mt-2"><b> <?php echo $estatus_academicas ?> </b></p> 
                      </div> 
                    </div> 
                  </div>
                </div>
              <?php
              }
              if($secciones->lleva_domicilios == 1){ ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                  <div class="card"> 
                    <div class="header"> 
                      <div class="image" style="<?php echo $css_domicilios ?>">
                      <?php $descripcionEstatus = $estatus_domicilios == 'Completed' ? 'This information has been completed' : ($estatus_domicilios == 'Updated' ? 'This information has been updated. It will be reviewed by our analysts to determine if the information is complete or if additional information is required.' : ''); ?>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $descripcionEstatus ?>"><?php echo $icono_domicilios ?></a>
                      </div> 
                      <div class="content">
                        <span class="title">Address history</span> 
                        <?php $tiempo_domicilios = ($secciones->tiempo_domicilios != 'All')? $secciones->tiempo_domicilios : '10 years'; ?>
                        <p class="message">This section is for registering your addresses in the last <?php echo $tiempo_domicilios; ?>. Start from the most current address and work backward.</p> 
                      </div> 
                      <div class="actions">
                        <button class="open-form" id="btnDomicilios" type="button" onclick="getAddressHistory(<?php echo $candidato->id ?>,<?php echo $secciones->id_seccion_historial_domicilios ?>,<?php echo $candidato->id_cliente ?>,'<?php echo $candidato->nombre.' '.$candidato->paterno.' '.$candidato->materno ?>')">Open Form</button> 
                        <p class="text-center mt-2"><b> <?php echo $estatus_domicilios ?> </b></p> 
                      </div> 
                    </div> 
                  </div>
                </div>
              <?php
              }
              if($secciones->lleva_gaps == 1){ ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                  <div class="card"> 
                    <div class="header"> 
                      <div class="image" style="<?php echo $css_gaps ?>">
                      <?php $descripcionEstatus = $estatus_gaps == 'Completed' ? 'This information has been completed' : ($estatus_gaps == 'Updated' ? 'This information has been updated. It will be reviewed by our analysts to determine if the information is complete or if additional information is required.' : ''); ?>
                        <a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $descripcionEstatus ?>"><?php echo $icono_gaps ?></a>
                      </div> 
                      <div class="content">
                        <span class="title">Gaps</span> 
                        <p class="message">This section is to know if you took breaks during your professional career. If you didn't, leave this form in blank.</p> 
                      </div> 
                      <div class="actions">
                        <button class="open-form" id="btnGaps" type="button" onclick="getGaps(<?php echo $candidato->id ?>,<?php echo $candidato->id_cliente ?>,'<?php echo $candidato->nombre.' '.$candidato->paterno.' '.$candidato->materno ?>')">Open Form</button> 
                        <p class="text-center mt-2"><b> <?php echo $estatus_gaps ?> </b></p> 
                      </div> 
                    </div> 
                  </div>
                </div>
              <?php
              }
            } ?>
          </div>

          <!--<div class="row p-3">
            <div class="card my-5 p-3" id="formCard" style="display:none">
              <button type="button" class="card-close" onclick="closeForm()">
                <span aria-hidden="true">&times;</span>
              </button>
              <h5 class="card-header text-center text-white" style="background-color:#0a39a6" id="titleForm"></h5>
              
              <div class="card-body">
                 <form id="dataForm">
                  <div class="row" id="rowForm"></div>
                </form> 
              </div>
              <div class="card-footer text-muted text-center">
                <button type="button" class="btn btn-primary" id="btnSubmitForm">Save</button>
              </div>
            </div>
          </div>-->

          <!-- <div class="row mb-5">
            <div class="col-12 text-center">
              <button type="button" class="btn btn-info btn-lg" onclick="confirmarFormularios(<?php //echo $this->session->userdata('id') ?>)">Submit forms for review</button>
            </div>
          </div> -->
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 bloque mt-1 mb-1">
          <h4 class="text-center">FILES</h4>
          <div class="row mb-3" id="divFiles">
            <?php 
            $documentosRequeridos = $this->documentacion_model->getDocumentosRequeridosByCandidato($candidato->id);
            $documentos = array();
            if($secciones->lleva_identidad == 1){
              $documentos[] = 3; $documentos[] = 14;//INE y Pasaporte
            }
            if($secciones->lleva_empleos == 1){
              $documentos[] = 9;//Historial empleos
            }
            if($secciones->lleva_estudios == 1){
              $documentos[] = 7;//Comprobante de estudios
            }
            if($secciones->lleva_criminal == 1){
              $documentos[] = 12;//Constancia de antecedentes no penales
            }
            if($secciones->lleva_domicilios == 1){
              $documentos[] = 2;//Comprobante de domicilio
            }
            if($secciones->lleva_credito == 1){
              $documentos[] = 28;//Historial crediticio
            }
            if($secciones->lleva_prohibited_parties_list == 1){
              $documentos[] = 30;//Prohibited parties list
            }
            if($secciones->lleva_motor_vehicle_records == 1){
              $documentos[] = 44; $documentos[] = 37;//MVR y/o licencia de conducir
            }
            if($secciones->lleva_curp == 1){
              $documentos[] = 5;//CURP
            }
            if($documentosRequeridos){
              foreach($documentosRequeridos as $row){
                if(!in_array($row->id_tipo_documento, $documentos)){
                  $documentos[] = $row->id_tipo_documento;
                }
              }
            }
            $archivos = $this->documentacion_model->getArchivosCandidato($id_candidato);
            foreach($documentos as $doc){
              $obligatorioMarca = ''; $esObligatorio = ''; $verArchivo = ''; $marcaArchivoSubido = ''; $archivoSubido = '';
              $res = $this->candidato_model->matchDocumento($id_candidato, $doc);
              $requerido = $this->documentacion_model->getDocumentoRequerido($doc);
              $restringido = $this->documentacion_model->get_documentos_restringidos_cliente($candidato->id_cliente, $doc);
              if($candidato->pais != 'México' && $candidato->id_cliente == 2 && $candidato->pais != 'Mexico'){
                $restringido = NULL;
              }
              if($requerido->solicitado == 1){
                if(empty($restringido)){
                  if($res > 0){
                    foreach($archivos as $row){
                      if($doc == $row->id_tipo_documento){ 
                        $marcaArchivoSubido = ' <div class="image" style="background-color:#2bfa28;color:white;">
                                        <i class="fas fa-check"></i>
                                      </div> ';
                        $verArchivo .= '<br><a href="'.base_url().'_docs/'.$row->archivo.'" target="_blank">'.$row->archivo.'</a>';
                        $archivoSubido = '<p class="text-center mt-2"><b>Uploaded file</b></p>';
                      }
                    }
                  }
                  $comentarioDocumento = ($requerido->comentario_ingles != null)? '<br><small>'.$requerido->comentario_ingles.'</small>' : '';
                  if($requerido->obligatorio == 1){
                    $obligatorioMarca = ' *';
                    $esObligatorio = '<br><small>(required)</small>';
                  } ?>
                  <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                    <div class="card"> 
                      <div class="header"> 
                        <?php echo $marcaArchivoSubido; ?>
                        <div class="content">
                          <span class="title"><?php echo $requerido->nombre_ingles.$obligatorioMarca.$esObligatorio.$comentarioDocumento.$verArchivo ?></span> 
                        </div> 
                        <div class="actions">
                          <input class="form-control mb-3" id="<?php echo $requerido->input_id; ?>" type="file" name="<?php echo $requerido->input_id; ?>" accept=".pdf, .jpg, .jpeg, .png" <?php echo $multiple = ($requerido->multiple == 1)? 'multiple':''; ?>>
                          <button class="open-form" id="btnArchivos" type="button" onclick="subirArchivos(<?php echo $requerido->id_tipo_documento ?>,<?php echo $candidato->id ?>,'<?php echo $requerido->input_id ?>')">Click here to upload</button>
                          <?php echo $archivoSubido; ?>
                        </div> 
                      </div> 
                    </div>
                  </div>
                <?php 
                }
              }
            } ?>
          </div>

          <!-- <div class="row mb-5">
            <div class="col-12 text-center">
              <button type="button" class="btn btn-info btn-lg" onclick="confirmarDocumentacion(<?php //echo $this->session->userdata('id') ?>)">Submit documents for review</button>
            </div>
          </div> -->

        </div>
        <div class="col-4 m-auto">
          <button type="button" class="btn btn-success btn-lg btn-block mb-5" onclick="confirmarFinalizar(<?php echo $this->session->userdata('id') ?>)">Finish</button>
        </div>
      </div>
    <?php 
    } ?>
  </main>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
	<!-- Sweetalert 2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
	<!-- Bootstrap Select -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
  <script>
    $(document).ready(function(){
		  $('[data-toggle="tooltip"]').tooltip();

      var check_aviso = <?php echo $tiene_aviso; ?>;
     
      <?php if($candidato->id_cliente == 96){  

         $privacy_notice = 'non-disclosure-rts.pdf' ;

      }elseif($candidato->id_cliente == 2){

        $privacy_notice = 'non-disclosure-hcl.pdf';
         }
      else{
        $privacy_notice = 'non-disclosure.pdf';
      }   ?>
			if (check_aviso == 0) {
        Swal.fire({
          icon: 'info',
          title: 'Important information...',
          html: 'We need your information to hiring process to new job or switch of job project requested by <?php echo $candidato->cliente; ?>, so you should first <b><a class="" href="<?php echo base_url() . "privacy_notice/" . $privacy_notice ?>" target="_blank">download</a></b>, read, sign and upload the Non-disclosure agreement(image or PDF format).Once you have uploaded the file,the register process will be enabled.',
          footer: 'The fields with * are required',
          confirmButtonText: 'Got it!',
          allowOutsideClick: false
        })
				$('#checkAvisoModal').modal('show');
			}
      if(localStorage.getItem('empleoGuardado') == 1){
        $('#btnEmpleos').trigger('click')
        localStorage.removeItem('empleoGuardado');
        localStorage.removeItem('empleoNumero');
      }
      if(localStorage.getItem('empleoEliminado') == 1){
        $('#btnEmpleos').trigger('click')
        localStorage.removeItem('empleoEliminado');
      }
      if(localStorage.getItem('empleoExtra') == 1){
        $('#btnEmpleos').trigger('click')
        localStorage.removeItem('empleoExtra');
      }
      if(localStorage.getItem('familiarGuardado') == 1){
        $('#btnFamiliares').trigger('click')
        localStorage.removeItem('familiarGuardado');
      }
      if(localStorage.getItem('familiarEliminado') == 1){
        $('#btnFamiliares').trigger('click')
        localStorage.removeItem('familiarEliminado');
      }
      if(localStorage.getItem('referenciaPersonalGuardada') == 1){
        $('#btnRefPersonales').trigger('click')
        localStorage.removeItem('referenciaPersonalGuardada');
      }
      if(localStorage.getItem('referenciaPersonalEliminado') == 1){
        $('#btnRefPersonales').trigger('click')
        localStorage.removeItem('referenciaPersonalEliminado');
      }
      if(localStorage.getItem('domicilioGuardado') == 1){
        $('#btnDomicilios').trigger('click')
        localStorage.removeItem('domicilioGuardado');
      }
      if(localStorage.getItem('domicilioEliminado') == 1){
        $('#btnDomicilios').trigger('click')
        localStorage.removeItem('domicilioEliminado');
      }
      if(localStorage.getItem('gapGuardado') == 1){
        $('#btnGaps').trigger('click')
        localStorage.removeItem('gapGuardado');
      }
      if(localStorage.getItem('gapEliminado') == 1){
        $('#btnGaps').trigger('click')
        localStorage.removeItem('gapEliminado');
      }
      if(localStorage.getItem('referenciaProfesionalGuardada') == 1){
        $('#btnRefProfesionales').trigger('click')
        localStorage.removeItem('referenciaProfesionalGuardada');
      }
      if(localStorage.getItem('referenciaAcademicaGuardada') == 1){
        $('#btnRefAcademicas').trigger('click')
        localStorage.removeItem('referenciaAcademicaGuardada');
      }
      $('#mensajeModal').on('hidden.bs.modal', function(e) {
        $("#mensajeModal #titulo_mensaje, #mensajeModal #mensaje").text('');
        $("#mensajeModal #campos_mensaje").empty();
        $("#mensajeModal #btnConfirmar").removeAttr('onclick');
      });
     
    })
    function getGeneralData(id_candidato, id_seccion, id_cliente, idioma){
      $("#rowForm").empty();
      $('.loader').css("display","block");
      let valores = ''; let scripts = ''; let opciones = '';
      let idiomaCliente = (idioma == 1) ? 'ingles' : 'espanol'
      let url_generos = '<?php echo base_url('Cat_Generos/getAll'); ?>'; let generos_data = getDataCatalogo(url_generos, 'nombre_ingles', 0, idiomaCliente);
      let url_puestos = '<?php echo base_url('Cat_Puestos/getAll'); ?>'; let puestos_data = getDataCatalogo(url_puestos, 'id', 0, idiomaCliente);
      let url_paises = '<?php echo base_url('Funciones/getPaises'); ?>'; let paises_data = getDataCatalogo(url_paises, 'nombre', 0, idiomaCliente);
      let url_estados = '<?php echo base_url('Funciones/getEstados'); ?>'; let estados_data = getDataCatalogo(url_estados, 'id', 0, 'espanol');
      let url_grados_estudio = '<?php echo base_url('Funciones/getGradosEstudio'); ?>'; let grados_estudio_data = getDataCatalogo(url_grados_estudio, 'id', 0, idiomaCliente);
      let url_civiles = '<?php echo base_url('Funciones/getCiviles'); ?>'; let civiles_data = getDataCatalogo(url_civiles, 'nombre', 0, idiomaCliente);
      let url_sanguineo = '<?php echo base_url('Funciones/getGruposSanguineo'); ?>'; let sanguineo_data = getDataCatalogo(url_sanguineo, 'nombre', 0, 'espanol');
      let url_medio_transporte = '<?php echo base_url('Funciones/getMediosTransporte'); ?>'; let transportes_data = getDataCatalogo(url_medio_transporte, 'nombre', 0, idiomaCliente);
      let url_tipo_identificacion = '<?php echo base_url('Funciones/getTiposIdentificacion'); ?>'; let identificaciones_data = getDataCatalogo(url_tipo_identificacion, 'nombre', 0, idiomaCliente);
      $.ajax({
        url: '<?php echo base_url('Candidato/getById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getSeccionByAutor'); ?>',
        method: 'POST',
        data: {'id_seccion':id_seccion,'tipo_orden':'orden_front','autor':'candidato'},
        async:false,
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            for(let i = 0; i < dato.length; i++){
              if(valores != 0){
                //* Get Data Catalogos
                if(dato[i]['referencia'] == 'id_puesto')
                  opciones = puestos_data;
                if(dato[i]['referencia'] == 'pais')
                  opciones = paises_data;
                if(dato[i]['referencia'] == 'genero')
                  opciones = generos_data
                if(dato[i]['referencia'] == 'id_estado')
                  opciones = estados_data;
                if(dato[i]['referencia'] == 'id_grado_estudio')
                  opciones = grados_estudio_data;
                if(dato[i]['referencia'] == 'estado_civil')
                  opciones = civiles_data;
                if(dato[i]['referencia'] == 'tipo_sanguineo')
                  opciones = sanguineo_data;
                if(dato[i]['referencia'] == 'tipo_transporte')
                  opciones = transportes_data;
                if(dato[i]['referencia'] == 'tipo_identificacion')
                  opciones = identificaciones_data;
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'input'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                //* Funciones
                if(dato[i]['script_final'] != null)
                  scripts += dato[i]['script_final'];
                if(dato[i]['referencia'] == 'id_municipio'){
                  if(valores['id_municipio'] != null && valores['id_municipio'] != 0){
                    $('#rowForm').append('<script>getMunicipios($("#estado").val(), "#municipio", '+valores["id_municipio"]+');<\/script>');
                  }
                  else{
                    $('#municipio').empty();
                    $('#municipio').append('<option value="">Selecciona</option>')
                  }
                }
                if(dato[i]['referencia'] == 'pais'){
                  if(valores[dato[i]['referencia']] == null)
                    $('#'+dato[i]['atr_id']).val('México')
                }
              }
              else{
                $('#rowForm').html('<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>');
              }
            }
            $('#rowForm').append(scripts);
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>');
          }
          const formParams = {
            id: id_candidato,
            id_seccion: id_seccion,
            url: '<?php echo base_url('General/update') ?>',
            refresh: false,
            seccion: 'generales',
            source: 'candidato'
          }
          $('#titleForm').html('General Data')
          $('#btnSubmitForm').css("display","initial");
          $('#btnSubmitForm').attr("onclick","submitForm("+JSON.stringify(formParams)+")");
          $('#formularioModal').modal('show')
          //$("#formCard").css('display','block')
          // $('html, body').animate({
          //   scrollTop: $('#formCard').offset().top
          // }, 1000);
        }
      });
    }
    function getStudiesRecord(id_candidato, id_seccion, id_cliente){
      $("#rowForm").empty();
      $('.loader').css("display","block");
      let valores = ''; let scripts = ''; let opciones = '';
      let url_grados_estudio = '<?php echo base_url('Funciones/getGradosEstudio'); ?>'; let grados_estudio_data = getDataCatalogo(url_grados_estudio, 'id', 0, 'ingles');
      $.ajax({
        url: '<?php echo base_url('Candidato_Estudio/getHistorialById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getSeccionByAutor'); ?>',
        method: 'POST',
        data: {'id_seccion':id_seccion,'tipo_orden':'orden_front','autor':'candidato'},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            for(let i = 0; i < dato.length; i++){
              if(valores != 0){
                //* Get Data Catalogos
                if(dato[i]['referencia'] == 'id_grado_estudio' || dato[i]['referencia'] == 'id_tipo_studies')
                  opciones = grados_estudio_data;
                
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'input'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
              }
              else{

                //* Get Data Catalogos
                if(dato[i]['referencia'] == 'id_grado_estudio' || dato[i]['referencia'] == 'id_tipo_studies')
                  opciones = grados_estudio_data;
                
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'input'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
              }
            }
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>');
          }
          const formParams = {
            id: id_candidato,
            id_seccion: id_seccion,
            url: '<?php echo base_url('Estudio/setHistorial') ?>',
            refresh: false,
            seccion: 'estudios',
            source: 'candidato'
          }
          $('#titleForm').html('Studies Record<br><small>* If you do not have some school level, leave it empty </small>')
          $('#btnSubmitForm').css("display","initial");
          $('#btnSubmitForm').attr("onclick","submitForm("+JSON.stringify(formParams)+")");
          $('#formularioModal').modal('show')
          // $("#formCard").css('display','block')
          // $('html, body').animate({
          //   scrollTop: $('#formCard').offset().top
          // }, 1000);
        }
      });
    }
    function getHighestStudies(id_candidato, id_seccion, id_cliente){
      $("#rowForm").empty();
      $('.loader').css("display","block");
      let valores = ''; let scripts = ''; let opciones = '';
      let url_grados_estudio = '<?php echo base_url('Funciones/getGradosEstudio'); ?>'; let grados_estudio_data = getDataCatalogo(url_grados_estudio, 'id', 0, 'ingles');
      $.ajax({
        url: '<?php echo base_url('Candidato_Estudio/getMayorById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getSeccionByAutor'); ?>',
        method: 'POST',
        data: {'id_seccion':id_seccion,'tipo_orden':'orden_front','autor':'candidato'},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            for(let i = 0; i < dato.length; i++){
              if(valores != 0){
                //* Get Data Catalogos
                if(dato[i]['referencia'] == 'id_grado_estudio' || dato[i]['referencia'] == 'id_tipo_studies')
                  opciones = grados_estudio_data;
                
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'input'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                  $('#'+dato[i]['atr_id']).val(valores[dato[i]['referencia']]);
                }
              }
              else{

                //* Get Data Catalogos
                if(dato[i]['referencia'] == 'id_grado_estudio' || dato[i]['referencia'] == 'id_tipo_studies')
                  opciones = grados_estudio_data;
                
                //* HTML
                if(dato[i]['tipo_etiqueta'] == 'select'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+opciones+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'input'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
                if(dato[i]['tipo_etiqueta'] == 'textarea'){
                  let titulo_seccion = (dato[i]['titulo_ingles_seccion_modal'] !== null) ? dato[i]['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+dato[i]['grid_col_inicio']+dato[i]['label_ingles']+dato[i]['etiqueta_inicio']+dato[i]['etiqueta_cierre']+dato[i]['grid_col_cierre']);
                }
              }
            }
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>');
          }
          const formParams = {
            id: id_candidato,
            id_seccion: id_seccion,
            url: '<?php echo base_url('Estudio/setMayor') ?>',
            refresh: false,
            seccion: 'estudios',
            source: 'candidato'
          }
          $('#titleForm').html('Highest Studies')
          $('#btnSubmitForm').css("display","initial");
          $('#btnSubmitForm').attr("onclick","submitForm("+JSON.stringify(formParams)+")");
          $('#formularioModal').modal('show')
          // $("#formCard").css('display','block')
          // $('html, body').animate({
          //   scrollTop: $('#formCard').offset().top
          // }, 1000);
        }
      });
    }
    function getEmploymentHistory(id_candidato, id_seccion, id_cliente, candidato, tiempo, trabajo_gobierno, trabajo_inactivo){
      $("#rowForm").empty();
      $('.loader').css("display","block");
		  let valores = ''; let scripts = ''; let opciones = ''; let autor_anterior = ''; let col_inicio = ''; let col_final = '';
      if(id_seccion == 16 || id_seccion == 32 || id_seccion == 59 || id_seccion == 77 || id_seccion == 90){
        if(id_seccion == 16 || id_seccion == 59){
          //* Enterarse del trabajo
          $('#rowForm').append('<div class="col-12"><div class="alert alert-warning"><h4 class="text-center">Have you worked in any government entity, political party or NGO?</h4></div></div><div class="col-12"><textarea class="form-control trabajo_gobierno" name="trabajo_gobierno" id="trabajo_gobierno" rows="2" onKeyUp="validateInput(this)"></textarea><br><br></div>');
          $('#rowForm').append('<div class="col-12"><div class="alert alert-warning"><h4 class="text-center">Inactive periods in employment</h4></div></div><div class="col-12"><textarea class="form-control trabajo_inactivo" name="trabajo_inactivo" id="trabajo_inactivo" rows="2" onKeyUp="validateInput(this)"></textarea><br><br></div><div class="col-12"><button type="button" class="btn btn-success btn-block" onclick="actualizarTrabajoGobierno2('+id_candidato+')">Save previous answers</button><br><br></div>');
          $("#trabajo_gobierno").val(trabajo_gobierno);
          $("#trabajo_inactivo").val(trabajo_inactivo);
        }
        if(id_seccion == 32 && id_cliente != 96){
        //if(id_seccion == 32){
          //* Enterarse del trabajo
          let regexPattern = '^[^\\n\'"/\\\\]*$';
          $('#rowForm').append('<div class="col-12" style="display:none;"><div class="alert alert-warning"><h4 class="text-center">Have you worked in any government entity, political party or NGO?</h4></div></div><div class="col-12"><textarea class="form-control trabajo_gobierno" name="trabajo_gobierno" id="trabajo_gobierno" rows="2" disabled></textarea><br><br></div>');
          $('#rowForm').append('<div class="col-12"><div class="alert alert-warning"><h4 class="text-center">Inactive periods in employment</h4></div></div><div class="col-12"><textarea class="form-control trabajo_inactivo" name="trabajo_inactivo" id="trabajo_inactivo" rows="2" onKeyUp="validateInput(this)"></textarea><br><br></div><div class="col-12"><button type="button" class="btn btn-success btn-block" onclick="actualizarTrabajoGobierno2('+id_candidato+')">Save previous answers</button><br><br></div>');
          $("#trabajo_inactivo").val(trabajo_inactivo);
        }
        $.ajax({
          url: '<?php echo base_url('Candidato_Laboral/getHistorialLaboralById'); ?>',
          method: 'POST',
          data: {'id':id_candidato,'id_seccion':id_seccion},
          async:false,
          success: function(res){
            if(res != 0){
              valores = JSON.parse(res);
            }
          }
        });
        $.ajax({
          url: '<?php echo base_url('Formulario/getSeccionByAutor'); ?>',
          method: 'POST',
          data: {'id_seccion':id_seccion,'tipo_orden':'orden_front','autor':'candidato'},
          beforeSend: function() {
            $('.loader').css("display","block");
          },
          success: function(res){
            setTimeout(function(){
              $('.loader').fadeOut();
            },200);
            if(res != 0){
              var dato = JSON.parse(res);
              for(let number = 0; number < 10; number++){
                $('#rowForm').append('<div class="alert alert-info btn-block text-center" id="divLaboral'+(number+1)+'">Job #'+(number+1)+'</div>')
                for(let tag of dato){
                  //* HTML
                  if(tag['tipo_etiqueta'] == 'select'){
                    col_inicio = '<div class="col-sm-12 col-md-4 col-lg-4">'
                    col_final = '</div>'
                    $('#rowForm').append(col_inicio+tag['label_ingles']+tag['etiqueta_inicio']+opciones+tag['etiqueta_cierre']+col_final);
                  }
                  if(tag['tipo_etiqueta'] == 'input'){
                    col_inicio = '<div class="col-sm-12 col-md-4 col-lg-4">'
                    col_final = '</div>'
                    $('#rowForm').append(col_inicio+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+col_final);
                  }
                  if(tag['tipo_etiqueta'] == 'textarea'){
                    col_inicio = '<div class="col-sm-12 col-md-4 col-lg-4">'
                    col_final = '</div>'
                    $('#rowForm').append(col_inicio+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+col_final);
                  }
                }
                //* Boton Guardar
                //$('#rowForm').append('<div class="col-12"></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnGuardarLaboral'+(number+1)+'" class="btn btn-success btn-block" onclick="guardarLaboral(0,'+number+','+id_candidato+',\'candidato\',\''+candidato+'\','+id_seccion+','+id_cliente+',\''+tiempo+'\')">Save Job #'+(number + 1)+'</button></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnEliminarLaboral'+(number+1)+'" class="btn btn-danger btn-block" disabled>Delete Job #'+(number + 1)+'</button></div>');
                $('#rowForm').append('<div class="col-12"></div><div class="col-12 mt-3 mb-5"><button type="button" id="btnGuardarLaboral'+(number+1)+'" class="btn btn-success btn-block" onclick="guardarLaboral(0,'+number+','+id_candidato+',\'candidato\',\''+candidato+'\','+id_seccion+','+id_cliente+',\''+tiempo+'\')">Save Job #'+(number + 1)+'</button></div>');
              }
              //* Valores de laboral por el candidato
              if(valores != 0){
                var index = 0; let idLaboral = 0; let flag = 0;
                for(let valor of valores){
                  flag = 0;
                  for(let tag of dato){
                    if(tag['autor'] == 'candidato')
                      $('[name="'+tag['atr_id']+'[]"]').eq(index).val(valor[tag['referencia']]);
                    if(flag == 0){
                      idLaboral = valor['id'];
                      flag++;
                    }
                  }
                  $('#btnGuardarLaboral'+(index+1)).removeAttr('onclick');
                  $('#btnGuardarLaboral'+(index+1)).attr("onclick","guardarLaboral("+idLaboral+","+index+","+id_candidato+",\"candidato\",\""+candidato+"\","+id_seccion+","+id_cliente+",\""+tiempo+"\")");
                  //$('#btnEliminarLaboral'+(index+1)).removeAttr('disabled');
                  //$('#btnEliminarLaboral'+(index+1)).attr("onclick","mostrarMensajeConfirmacion(\"Delete Job\","+idLaboral+","+index+","+id_candidato+","+id_seccion+")");
                  index++;
                }
              }
            }
            else{
              $('#rowForm').html('<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>');
            }
            let tiempo_empleos = (tiempo !== null)? tiempo : '7 years';
            $('#titleForm').html('Employment History<br><small>Register your jobs for the last '+tiempo_empleos+' starting with the last one in descending order and only fill out the necessary forms</small>')
            $('#btnSubmitForm').css("display","none");
            $('#formularioModal').modal('show')
            // $("#formCard").css('display','block')
            // $('html, body').animate({
            //   scrollTop: $('#formCard').offset().top
            // }, 1000);
          }
        });
      }
      //TODO: id_empleos=55 no soportado, es para candidatos en espanol
      if(id_seccion == 55){
        $.ajax({
          url: '<?php echo base_url('Candidato_Laboral/getAntecedentesLaboralesById'); ?>',
          method: 'POST',
          data: {'id':id_candidato,'id_seccion':id_seccion},
          async:false,
          success: function(res){
            if(res != 0){
              valores = JSON.parse(res);
            }
          }
        });
        $.ajax({
          url: '<?php echo base_url('Formulario/getSeccionByAutor'); ?>',
          method: 'POST',
          data: {'id_seccion':id_seccion,'tipo_orden':'orden_front','autor':'candidato'},
          beforeSend: function() {
            $('.loader').css("display","block");
          },
          success: function(res){
            setTimeout(function(){
              $('.loader').fadeOut();
            },200);
            if(res != 0){
              var dato = JSON.parse(res);
              for(let number = 0; number < 10; number++){
                $('#rowForm').append('<div class="alert alert-info btn-block text-center" id="divLaboral'+(number+1)+'">Job #'+(number+1)+'</div>')
                for(let tag of dato){
                  //* HTML
                  if(tag['tipo_etiqueta'] == 'select'){
                    col_inicio = '<div class="col-sm-12 col-md-4 col-lg-4">'
                    col_final = '</div>'
                    $('#rowForm').append(col_inicio+tag['label']+tag['etiqueta_inicio']+opciones+tag['etiqueta_cierre']+col_final);
                  }
                  if(tag['tipo_etiqueta'] == 'input'){
                    col_inicio = '<div class="col-sm-12 col-md-4 col-lg-4">'
                    col_final = '</div>'
                    $('#rowForm').append(col_inicio+tag['label']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+col_final);
                  }
                  if(tag['tipo_etiqueta'] == 'textarea'){
                    col_inicio = '<div class="col-sm-12 col-md-4 col-lg-4">'
                    col_final = '</div>'
                    $('#rowForm').append(col_inicio+tag['label']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+col_final);
                  }
                }
                //* Boton Guardar
                //$('#rowForm').append('<div class="col-12"></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnGuardarLaboral'+(number+1)+'" class="btn btn-success btn-block" onclick="guardarLaboral(0,'+number+','+id_candidato+',\'candidato\',\''+candidato+'\','+id_seccion+','+id_cliente+',\''+tiempo+'\')">Save Job #'+(number + 1)+'</button></div><div class="col-6 mt-3 mb-5"><button type="button" id="btnEliminarLaboral'+(number+1)+'" class="btn btn-danger btn-block" disabled>Delete Job #'+(number + 1)+'</button></div>');
                $('#rowForm').append('<div class="col-12"></div><div class="col-12 mt-3 mb-5"><button type="button" id="btnGuardarLaboral'+(number+1)+'" class="btn btn-success btn-block" onclick="guardarLaboral(0,'+number+','+id_candidato+',\'candidato\',\''+candidato+'\','+id_seccion+','+id_cliente+',\''+tiempo+'\')">Save Job #'+(number + 1)+'</button></div>');
              }
              //* Valores de laboral por el candidato
              if(valores != 0){
                var index = 0; let idLaboral = 0; let flag = 0;
                for(let valor of valores){
                  flag = 0;
                  for(let tag of dato){
                    if(tag['autor'] == 'candidato')
                      $('[name="'+tag['atr_id']+'[]"]').eq(index).val(valor[tag['referencia']]);
                    if(flag == 0){
                      idLaboral = valor['id'];
                      flag++;
                    }
                  }
                  $('#btnGuardarLaboral'+(index+1)).removeAttr('onclick');
                  $('#btnGuardarLaboral'+(index+1)).attr("onclick","guardarLaboral("+idLaboral+","+index+","+id_candidato+",\"candidato\",\""+candidato+"\","+id_seccion+","+id_cliente+",\""+tiempo+"\")");
                  //$('#btnEliminarLaboral'+(index+1)).removeAttr('disabled');
                  //$('#btnEliminarLaboral'+(index+1)).attr("onclick","mostrarMensajeConfirmacion(\"Delete Job\","+idLaboral+","+index+","+id_candidato+","+id_seccion+")");
                  index++;
                }
              }
            }
            else{
              $('#rowForm').html('<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>');
            }
            let tiempo_empleos = (tiempo !== null)? tiempo : '7 years';
            tiempo_empleos = (tiempo_empleos != 'All')? tiempo_empleos : '10 years';
            $('#titleForm').html('Employment History<br><small>Register your jobs for the last '+tiempo_empleos+' starting with the last one in descending order and only fill out the necessary forms</small>')
            $('#btnSubmitForm').css("display","none");
            $('#formularioModal').modal('show')
            // $("#formCard").css('display','block')
            // $('html, body').animate({
            //   scrollTop: $('#formCard').offset().top
            // }, 1000);
          }
        });
      }
    }
    function getFamilyMembers(id_candidato, id_seccion, id_cliente, candidato){
      $("#rowForm").empty();
      $('.loader').css("display","block");
      let valores = ''; let scripts = ''; let opciones = '';
      let url_parentescos = '<?php echo base_url('Funciones/getParentescos'); ?>'; let parentescos_data = getDataCatalogo(url_parentescos, 'id', 1, 'ingles');
      let url_escolaridad = '<?php echo base_url('Funciones/getEscolaridades'); ?>'; let escolaridades_data = getDataCatalogo(url_escolaridad, 'id', 0, 'ingles');
      let url_civiles = '<?php echo base_url('Funciones/getCiviles'); ?>'; let civiles_data = getDataCatalogo(url_civiles, 'nombre', 0, 'ingles');
      $.ajax({
        url: '<?php echo base_url('Candidato_Familiar/getById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':35,'tipo_orden':'orden_front'},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            let totalFamiliares = valores.length;
            for(let number = 0; number < valores.length; number++){
              $('#rowForm').append('<div class="alert alert-info btn-block"><h5 class="text-center">Family Member #'+totalFamiliares+'</h5></div><br>');
              for(let tag of dato){
                let referencia = tag['referencia'];
                if(referencia == 'id_tipo_parentesco')
                  opciones = parentescos_data;
                if(referencia == 'estado_civil')
                  opciones = civiles_data;
                if(referencia == 'id_grado_estudio')
                  opciones = escolaridades_data;
                if(referencia == 'misma_vivienda' || referencia == 'adeudo')
                  opciones = '<option value="0">No</option><option value="1">Yes</option>';

                if(tag['tipo_etiqueta'] == 'select'){
                  $('#rowForm').append(tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+opciones+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'input'){
                  $('#rowForm').append(tag['titulo_seccion_modal']+tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'textarea'){
                  $('#rowForm').append(tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
              }
              //* Boton Guardar
              //$('#rowForm').append('<div class="col-md-6 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-primary btn-block" onclick="guardarIntegranteFamiliar('+valores[number]['id']+','+number+','+valores[number]['id_candidato']+')">Update Family Member #'+totalFamiliares+'</a></div><div class="col-md-6 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-danger btn-block" onclick="mostrarMensajeConfirmacion(\'eliminar integrante familiar\', '+valores[number]['id']+', \''+valores[number]['nombre']+'\')">Delete Family Member #'+totalFamiliares+'</a></div>');
              $('#rowForm').append('<div class="col-12 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-primary btn-block" onclick="guardarIntegranteFamiliar('+valores[number]['id']+','+number+','+valores[number]['id_candidato']+')">Update Family Member #'+totalFamiliares+'</a></div>');
                
              totalFamiliares--;
            }
            //* Values
            if(valores != 0){
              var index = 0;
              for(let valor of valores){
                for(let tag of dato){
                  $('[name="'+tag['atr_id']+'[]"]').eq(index).addClass('fam'+index);
                  $('[name="'+tag['atr_id']+'[]"]').eq(index).val(valor[tag['referencia']]);
                }
                index++;
              }
              $('#rowForm').append('<div class="col-12 mt-3 text-center"><a href="javascript:void(0)" class="btn btn-success" onclick="nuevoFamiliar('+id_candidato+')"><i class="fas fa-plus-circle"></i> Add Family Member</a></div>');
            }
            else{
              $('#rowForm').html('<div class="col-12"><h4 class="text-center">No family members registered</h4></div><br><div class="col-12 mt-3 text-center"><a href="javascript:void(0)" class="btn btn-success" onclick="nuevoFamiliar('+id_candidato+')"><i class="fas fa-plus-circle"></i> Add Family Member</a></div>');
            }
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>');
          }            
          $('#titleForm').html('Family Members')
          $('#btnSubmitForm').css("display","none");
          $('#formularioModal').modal('show')
          // $("#formCard").css('display','block')
          // $('html, body').animate({
          //   scrollTop: $('#formCard').offset().top
          // }, 1000);
        }
      });
    }
    function getPersonalReferences(id_candidato, id_seccion, id_cliente, candidato, cantidad_ref_personales){
      $("#rowForm").empty();
      $('.loader').css("display","block");
      let valores = ''; let scripts = ''; let opciones = ''; let btn_candidato = ''; let autor_anterior = '';
      $.ajax({
        url: '<?php echo base_url('Candidato_Ref_Personal/getById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getSeccionByAutor'); ?>',
        method: 'POST',
        data: {'id_seccion':id_seccion,'tipo_orden':'orden_front','autor':'candidato'},
        async:false,
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            for(var num = 1; num <= cantidad_ref_personales; num++){
              $('#rowForm').append('<div class="alert alert-secondary btn-block text-center"><h5>Reference #'+num+'</h5></div>');
              //autor_anterior = '';
              for(let tag of dato){
                //* Get Data Catalogos
                if(tag['referencia'] == 'sabe_trabajo' || tag['referencia'] == 'sabe_vive' || tag['referencia'] == 'recomienda')
                    opciones = '<option value="1">Sí</option><option value="0">No</option><option value="2">N/A</option>';
                //* HTML
                if(tag['tipo_etiqueta'] == 'select'){
                  let titulo_seccion = (tag['titulo_ingles_seccion_modal'] !== null) ? tag['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+opciones+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'input'){
                  let titulo_seccion = (tag['titulo_ingles_seccion_modal'] !== null) ? tag['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'textarea'){
                  let titulo_seccion = (tag['titulo_ingles_seccion_modal'] !== null) ? tag['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
              }
              //* Boton Guardar
              //$('#rowForm').append('<div class="col-6"><button type="button" id="btnGuardarRefPersonal'+num+'" class="btn btn-success btn-block mt-3 mb-5" >Save reference #'+num+'</button></div><div class="col-6"><button type="button" id="btnEliminarRefPersonal'+num+'" class="btn btn-danger btn-block mt-3 mb-5" disabled>Delete reference #'+num+'</button></div>');
              $('#rowForm').append('<div class="col-12"><button type="button" id="btnGuardarRefPersonal'+num+'" class="btn btn-success btn-block mt-3 mb-5" >Save reference #'+num+'</button></div>');
              
              let formParams = {
                id: id_candidato,
                id_seccion: id_seccion,
                url: '<?php echo base_url('Candidato_Ref_Personal/set') ?>',
                refresh: false,
                num: num,
                id_ref: 0,
                hideModal: false,
                updateButton: 'btnGuardarRefPersonal',
                //deleteButton: 'btnEliminarRefPersonal',
                //action: 'eliminar referencia personal',
                seccion: 'personales',
                source: 'candidato',
                backToForm: true,
                localStorageSection: 'referenciaPersonalGuardada'
              }
              $('#btnGuardarRefPersonal'+num).attr("onclick","submitForm("+JSON.stringify(formParams)+")");
            }
            //* Values
            if(valores != 0){
              let index = 0; let idRefPersonal = 0; let flag = 0;
              for(let valor of valores){
                flag = 0;
                for(let tag of dato){
                  $('[name="'+tag['atr_id']+'[]"]').eq(index).val(valor[tag['referencia']]);
                  //$('#btnEliminarRefPersonal'+(index+1)).prop('disabled', false);
                  if(flag == 0){
                    idRefPersonal = valor['id'];
                    flag++;
                  }
                }
                let formParams = {
                  id: id_candidato,
                  id_seccion: id_seccion,
                  url: '<?php echo base_url('Candidato_Ref_Personal/set') ?>',
                  refresh: false,
                  num: (index+1),
                  id_ref: idRefPersonal,
                  hideModal: false,
                  updateButton: 'btnGuardarRefPersonal',
                  //deleteButton: 'btnEliminarRefPersonal',
                  //action: 'eliminar referencia personal',
                  seccion: 'personales',
                  source: 'candidato',
                  backToForm: true,
                  localStorageSection: 'referenciaPersonalGuardada'
                }
                $('#btnGuardarRefPersonal'+(index+1)).attr("onclick","submitForm("+JSON.stringify(formParams)+")");
                //$('#btnEliminarRefPersonal'+(index+1)).attr("onclick","mostrarMensajeConfirmacion(\"eliminar referencia personal\","+(index+1)+","+idRefPersonal+","+id_candidato+","+id_seccion+")");
                index++;
              }
            }
            
            $('#titleForm').html('Personal references of candidate: <br>'+candidato)
            $('#btnSubmitForm').css("display","none");
            $('#formularioModal').modal('show')
            // $("#formCard").css('display','block')
            // $('html, body').animate({
            //   scrollTop: $('#formCard').offset().top
            // }, 1000);
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>');
          }
        }
      });
    }
    function getAddressHistory(id_candidato, id_seccion, id_cliente, candidato){
      $("#rowForm").empty();
      $('.loader').css("display","block");
      let valores = ''; let scripts = ''; let opciones = '';
      let url_estados = '<?php echo base_url('Funciones/getEstados'); ?>'; let estados_data = getDataCatalogo(url_estados, 'id', 0, 'espanol');
      let url_paises = '<?php echo base_url('Funciones/getPaises'); ?>'; let paises_data = getDataCatalogo(url_paises, 'nombre', 0, 'ingles');
      $.ajax({
        url: '<?php echo base_url('Domicilio/getById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':id_seccion,'tipo_orden':'orden_front'},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            let totalDomicilios = valores.length;
            for(let number = 0; number < valores.length; number++){
              $('#rowForm').append('<div class="alert alert-info btn-block"><h5 class="text-center">Address #'+totalDomicilios+'</h5></div><br>');
              for(let tag of dato){
                let referencia = tag['referencia'];
                if(referencia == 'id_estado')
                  opciones = estados_data;
                if(referencia == 'pais')
                  opciones = paises_data;

                if(tag['tipo_etiqueta'] == 'select'){
                  $('#rowForm').append(tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+opciones+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'input'){
                  $('#rowForm').append(tag['titulo_seccion_modal']+tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'textarea'){
                  $('#rowForm').append(tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
              }
              //* Boton Guardar
              //$('#rowForm').append('<div class="col-md-6 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-primary btn-block" onclick="guardarDomicilio('+valores[number]['id']+','+number+','+valores[number]['id_candidato']+','+id_seccion+')">Update Address #'+totalDomicilios+'</a></div><div class="col-md-6 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-danger btn-block" onclick="mostrarMensajeConfirmacion(\'eliminar domicilio\', '+valores[number]['id']+', \''+valores[number]['periodo']+'\')">Delete Address #'+totalDomicilios+'</a></div>');
              $('#rowForm').append('<div class="col-12 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-primary btn-block" onclick="guardarDomicilio('+valores[number]['id']+','+number+','+valores[number]['id_candidato']+','+id_seccion+')">Update Address #'+totalDomicilios+'</a></div>');
                
              totalDomicilios--;
            }
            if(valores != 0){
              var index = 0;
              for(let valor of valores){
                for(let tag of dato){
                  $('[name="'+tag['atr_id']+'[]"]').eq(index).addClass('dom'+index);
                  if(tag['referencia'] == 'id_estado'){
                    $('[name="id_estado[]"]').eq(index).removeAttr('id')
                    $('[name="id_estado[]"]').eq(index).attr('id','id_estado'+index);
                    $('#rowForm').append('<script>$("#id_estado'+index+'").change(function(){getMunicipios($("#id_estado'+index+'").val(), "#id_municipio'+index+'", "")})<\/script>');
                  }
                  if(tag['referencia'] == 'id_municipio'){
                    $('[name="id_municipio[]"]').eq(index).removeAttr('id')
                    $('[name="id_municipio[]"]').eq(index).attr('id','id_municipio'+index);
                    if(valor['id_municipio'] != null && valor['id_municipio'] != 0){
                      $('#rowForm').append('<script>getMunicipios('+valor['id_estado']+', "#id_municipio'+index+'", '+valor['id_municipio']+');<\/script>');
                    }
                    else{
                      $('"#id_municipio'+index+'"').eq(index).empty();
                      $('"#id_municipio'+index+'"').eq(index).append('<option value="">Select</option>')
                    }
                  }
                  else{
                    $('[name="'+tag['atr_id']+'[]"]').eq(index).val(valor[tag['referencia']]);
                  }
                }
                index++;
              }
              $('#rowForm').append('<div class="col-12 mt-3 text-center"><a href="javascript:void(0)" class="btn btn-success" onclick="nuevoDomicilio('+id_candidato+','+id_seccion+')"><i class="fas fa-plus-circle"></i> Add address</a></div>');
            }
            else{
              $('#rowForm').html('<div class="col-12"><h4 class="text-center">No address registered</h4></div><br><div class="col-12 mt-3 text-center"><a href="javascript:void(0)" class="btn btn-success" onclick="nuevoDomicilio('+id_candidato+','+id_seccion+')"><i class="fas fa-plus-circle"></i> Add address</a></div>');
            }
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>');
          }            
          $('#titleForm').html('Addresses')
          $('#btnSubmitForm').css("display","none");
          $('#formularioModal').modal('show')
          // $("#formCard").css('display','block')
          // $('html, body').animate({
          //   scrollTop: $('#formCard').offset().top
          // }, 1000);
        }
      });
    }
    function getGaps(id_candidato,id_cliente,candidato){
      $("#rowForm").empty();
      $('.loader').css("display","block");
      $.ajax({
        url: '<?php echo base_url('Gap/getById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        success: function(res)
        {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          if(res != 0){
            let data = JSON.parse(res)
            let rows = ''
            let consecutivo = 1
            for(let row of data){
              //rows += '<tr id="fecha_inicio_gap'+row['id']+'"><td>'+consecutivo+'</td><td>'+row['fecha_inicio']+'</td><td>'+row['fecha_fin']+'</td><td>'+row['razon']+'</td><td><a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="mostrarMensajeConfirmacion(\'eliminar gap\', '+row['id']+', '+consecutivo+', '+id_candidato+', 0)"><i class="fas fa-trash"></i> Delete Gap</a></td></tr>'
              rows += '<tr id="fecha_inicio_gap'+row['id']+'"><td>'+consecutivo+'</td><td>'+row['fecha_inicio']+'</td><td>'+row['fecha_fin']+'</td><td>'+row['razon']+'</td></tr>'
              consecutivo++
            }
            //$('#rowForm').append('<table class="table mb-5"><thead><tr><th>#</th><th>From</th><th>To</th><th>Reason/and activities performed</th></tr></thead><tbody>'+rows+'</tbody></table>')
            $('#rowForm').append('<table class="table mb-5"><thead><tr><th>#</th><th>From</th><th>To</th><th>Reason/and activities performed</th></tr></thead><tbody>'+rows+'</tbody></table>')
            $('#rowForm').append('<div class="col-6 mb-3"><label>From</label><input type="text" class="form-control" id="fecha_inicio_gap" name="fecha_inicio_gap"></div><div class="col-6 mb-3"><label>To</label><input type="text" class="form-control" id="fecha_fin_gap" name="fecha_fin_gap"></div><div class="col-12 mb-3"><label>Reason and activities performed</label><textarea class="form-control" rows="3" id="razon_gap"></textarea></div><div class="col-12 mt-3 text-center"><a href="javascript:void(0)" class="btn btn-success" onclick="guardarGap('+id_candidato+')"><i class="fas fa-plus-circle"></i> Add Gap</a></div>')
          }
          else{
            $("#rowForm").html('<div class="col-12"><p class="text-center">No records</p></div>');
            $('#rowForm').append('<div class="col-6 mb-3"><label>From</label><input type="text" class="form-control" id="fecha_inicio_gap" name="fecha_inicio_gap"></div><div class="col-6 mb-3"><label>To</label><input type="text" class="form-control" id="fecha_fin_gap" name="fecha_fin_gap"></div><div class="col-12 mb-3"><label>Reason and activities performed</label><textarea class="form-control" rows="3" id="razon_gap"></textarea></div><div class="col-12 mt-3 text-center"><a href="javascript:void(0)" class="btn btn-success" onclick="guardarGap('+id_candidato+')"><i class="fas fa-plus-circle"></i> Add Gap</a></div>')
          }
          $('#titleForm').html('Gaps')
          $('#btnSubmitForm').css("display","none");
          $('#formularioModal').modal('show')
          // $("#formCard").css('display','block')
          // $('html, body').animate({
          //   scrollTop: $('#formCard').offset().top
          // }, 1000);
        }
      });
    }
    function getProfessionalReferences(id_candidato, id_seccion, id_cliente, candidato, cantidad_ref_profesionales, ingles){
      $("#rowForm").empty();
      $('.loader').css("display","block");
      let idiomaCliente = (ingles == 1) ? 'ingles' : 'espanol'
      let valores = ''; let scripts = ''; let opciones = ''; let btn_candidato = ''; let autor_anterior = '';
      $.ajax({
        url: '<?php echo base_url('Referencia_Profesional/getById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getSeccionByAutor'); ?>',
        method: 'POST',
        data: {'id_seccion':id_seccion,'tipo_orden':'orden_front','autor':'candidato'},
        async:false,
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            for(var num = 1; num <= cantidad_ref_profesionales; num++){
              $('#rowForm').append('<div class="alert alert-secondary btn-block text-center"><h5>Reference #'+num+'</h5></div>');
              for(let tag of dato){
                //* select
                if(idiomaCliente == 'ingles'){
                  if(tag['referencia'] == 'desempeno')
                    opciones = '<option value="">Select</option><option value="Not provided">Not provided</option><option value="Excellent">Excellent</option><option value="Good">Good</option><option value="Regular">Regular</option><option value="Bad">Bad</option>';
                  if(tag['referencia'] == 'recomienda')
                    opciones = '<option value="">Select</option><option value="Yes">Yes</option><option value="No">No</option><option value="N/A">N/A</option>';
                }
                if(idiomaCliente == 'espanol'){
                  if(tag['referencia'] == 'desempeno')
                    opciones = '<option value="">Selecciona</option><option value="No proporcionado">No proporcionado</option><option value="Excelente">Excelente</option><option value="Bueno">Bueno</option><option value="Regular">Regular</option><option value="Malo">Malo</option>';
                  if(tag['referencia'] == 'recomienda')
                    opciones = '<option value="">Selecciona</option><option value="Si">Si</option><option value="No">No</option><option value="N/A">N/A</option>';
                }
                //* HTML
                if(tag['tipo_etiqueta'] == 'select'){
                  let titulo_seccion = (tag['titulo_ingles_seccion_modal'] !== null) ? tag['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+opciones+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'input'){
                  let titulo_seccion = (tag['titulo_ingles_seccion_modal'] !== null) ? tag['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'textarea'){
                  let titulo_seccion = (tag['titulo_ingles_seccion_modal'] !== null) ? tag['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
              }
              //* Boton Guardar
              //$('#rowForm').append('<div class="col-6"><button type="button" id="btnGuardarRefProfesional'+num+'" class="btn btn-success btn-block mt-3 mb-5" >Save reference #'+num+'</button></div><div class="col-6"><button type="button" id="btnEliminarRefProfesional'+num+'" class="btn btn-danger btn-block mt-3 mb-5" disabled>Delete reference #'+num+'</button></div>');
              $('#rowForm').append('<div class="col-12"><button type="button" id="btnGuardarRefProfesional'+num+'" class="btn btn-success btn-block mt-3 mb-5" >Save reference #'+num+'</button></div>');
              
              let formParams = {
                id: id_candidato,
                id_seccion: id_seccion,
                url: '<?php echo base_url('Referencia_Profesional/set') ?>',
                refresh: false,
                num: num,
                id_ref: 0,
                hideModal: false,
                updateButton: 'btnGuardarRefProfesional',
                //deleteButton: 'btnEliminarRefProfesional',
                //action: 'eliminar referencia profesional',
                seccion: 'profesionales',
                source: 'candidato',
                backToForm: true,
                localStorageSection: 'referenciaProfesionalGuardada'
              }
              $('#btnGuardarRefProfesional'+num).attr("onclick","submitForm("+JSON.stringify(formParams)+")");
            }
            //* Values
            if(valores != 0){
              let index = 0; let idRefProfesional = 0; let flag = 0;
              for(let valor of valores){
                flag = 0;
                for(let tag of dato){
                  $('[name="'+tag['atr_id']+'[]"]').eq(index).val(valor[tag['referencia']]);
                  //$('#btnEliminarRefProfesional'+(index+1)).prop('disabled', false);
                  if(flag == 0){
                    idRefProfesional = valor['id'];
                    flag++;
                  }
                }
                let formParams = {
                  id: id_candidato,
                  id_seccion: id_seccion,
                  url: '<?php echo base_url('Referencia_Profesional/set') ?>',
                  refresh: false,
                  num: (index+1),
                  id_ref: idRefProfesional,
                  hideModal: false,
                  updateButton: 'btnGuardarRefProfesional',
                  //deleteButton: 'btnEliminarRefProfesional',
                  //action: 'eliminar referencia profesional',
                  seccion: 'profesionales',
                  source: 'candidato',
                  backToForm: true,
                  localStorageSection: 'referenciaProfesionalGuardada'
                }
                $('#btnGuardarRefProfesional'+(index+1)).attr("onclick","submitForm("+JSON.stringify(formParams)+")");
                //$('#btnEliminarRefProfesional'+(index+1)).attr("onclick","mostrarMensajeConfirmacion(\"eliminar referencia profesional\","+(index+1)+","+idRefProfesional+","+id_candidato+","+id_seccion+")");
                index++;
              }
            }
            
            $('#titleForm').html('Professional references of candidate: <br>'+candidato)
            $('#btnSubmitForm').css("display","none");
            $('#formularioModal').modal('show')
            // $("#formCard").css('display','block')
            // $('html, body').animate({
            //   scrollTop: $('#formCard').offset().top
            // }, 1000);
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>');
          }
        }
      });
    }
    function getAcademicReferences(id_candidato, id_seccion, id_cliente, candidato, cantidad_ref_academicas, ingles){
      $("#rowForm").empty();
      $('.loader').css("display","block");
      let idiomaCliente = (ingles == 1) ? 'ingles' : 'espanol'
      let valores = ''; let scripts = ''; let opciones = ''; let btn_candidato = ''; let autor_anterior = '';
      $.ajax({
        url: '<?php echo base_url('Candidato_Ref_Academica/getById'); ?>',
        method: 'POST',
        data: {'id':id_candidato},
        async:false,
        success: function(res){
          if(res != 0){
            valores = JSON.parse(res);
          }
        }
      });
      $.ajax({
        url: '<?php echo base_url('Formulario/getSeccionByAutor'); ?>',
        method: 'POST',
        data: {'id_seccion':id_seccion,'tipo_orden':'orden_front','autor':'candidato'},
        async:false,
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            var dato = JSON.parse(res);
            for(var num = 1; num <= cantidad_ref_academicas; num++){
              $('#rowForm').append('<div class="alert alert-secondary btn-block text-center"><h5>Reference #'+num+'</h5></div>');
              for(let tag of dato){
                //* HTML
                if(tag['tipo_etiqueta'] == 'select'){
                  let titulo_seccion = (tag['titulo_ingles_seccion_modal'] !== null) ? tag['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+opciones+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'input'){
                  let titulo_seccion = (tag['titulo_ingles_seccion_modal'] !== null) ? tag['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'textarea'){
                  let titulo_seccion = (tag['titulo_ingles_seccion_modal'] !== null) ? tag['titulo_ingles_seccion_modal'] : '';
                  $('#rowForm').append(titulo_seccion+tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
              }
              //* Boton Guardar
              //$('#rowForm').append('<div class="col-6"><button type="button" id="btnGuardarRefAcademica'+num+'" class="btn btn-success btn-block mt-3 mb-5" >Save reference #'+num+'</button></div><div class="col-6"><button type="button" id="btnEliminarRefProfesional'+num+'" class="btn btn-danger btn-block mt-3 mb-5" disabled>Delete reference #'+num+'</button></div>');
              $('#rowForm').append('<div class="col-12"><button type="button" id="btnGuardarRefAcademica'+num+'" class="btn btn-success btn-block mt-3 mb-5" >Save reference #'+num+'</button></div>');
              
              let formParams = {
                id: id_candidato,
                id_seccion: id_seccion,
                url: '<?php echo base_url('Candidato_Ref_Academica/set') ?>',
                refresh: false,
                num: num,
                id_ref: 0,
                hideModal: false,
                updateButton: 'btnGuardarRefAcademica',
                //deleteButton: 'btnEliminarRefAcademica',
                //action: 'eliminar referencia academica',
                seccion: 'academicas',
                source: 'candidato',
                backToForm: true,
                localStorageSection: 'referenciaAcademicaGuardada'
              }
              $('#btnGuardarRefAcademica'+num).attr("onclick","submitForm("+JSON.stringify(formParams)+")");
            }
            //* Values
            if(valores != 0){
              let index = 0; let idRefAcademica = 0; let flag = 0;
              for(let valor of valores){
                flag = 0;
                for(let tag of dato){
                  $('[name="'+tag['atr_id']+'[]"]').eq(index).val(valor[tag['referencia']]);
                  //$('#btnEliminarRefAcademica'+(index+1)).prop('disabled', false);
                  if(flag == 0){
                    idRefAcademica = valor['id'];
                    flag++;
                  }
                }
                let formParams = {
                  id: id_candidato,
                  id_seccion: id_seccion,
                  url: '<?php echo base_url('Candidato_Ref_Academica/set') ?>',
                  refresh: false,
                  num: (index+1),
                  id_ref: idRefAcademica,
                  hideModal: false,
                  updateButton: 'btnGuardarRefAcademica',
                  //deleteButton: 'btnEliminarRefAcademica',
                  //action: 'eliminar referencia academica',
                  seccion: 'academicas',
                  source: 'candidato',
                  backToForm: true,
                  localStorageSection: 'referenciaAcademicaGuardada'
                }
                $('#btnGuardarRefAcademica'+(index+1)).attr("onclick","submitForm("+JSON.stringify(formParams)+")");
                //$('#btnEliminarRefAcademica'+(index+1)).attr("onclick","mostrarMensajeConfirmacion(\"eliminar referencia academica\","+(index+1)+","+idRefAcademica+","+id_candidato+","+id_seccion+")");
                index++;
              }
            }
            
            $('#titleForm').html('Academic references of candidate: <br>'+candidato)
            $('#btnSubmitForm').css("display","none");
            $('#formularioModal').modal('show')
            // $("#formCard").css('display','block')
            // $('html, body').animate({
            //   scrollTop: $('#formCard').offset().top
            // }, 1000);
          }
          else{
            $('#rowForm').html('<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>');
          }
        }
      });
    }
    //* Funciones de apoyo
    function getEdad(dateString, campo) {
      let hoy = new Date()
      let aux = dateString.split('/');
      let arreglo = aux[2]+'-'+aux[1]+'-'+aux[0];
      let fechaNacimiento = new Date(arreglo)
      let edad = hoy.getFullYear() - fechaNacimiento.getFullYear()
      let diferenciaMeses = hoy.getMonth() - fechaNacimiento.getMonth()
      if ( diferenciaMeses < 0 || (diferenciaMeses === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
        edad--
      }
      $(''+campo+'').val(edad)
    }
    function getDataCatalogo(url_data, referencia, opcion_no_aplica, idioma){
      let options = '<option value="">Select</option>';
      if(opcion_no_aplica == 1)
        options += '<option value="No aplica">NA</option>';
      $.ajax({
        url: url_data,
        method: 'POST',
        async:false,
        success: function(res){
          if(res != 0){
            rows = JSON.parse(res);
            for(let i = 0; i < rows.length; i++){
              if((referencia == 'nombre' || referencia == 'nombre_ingles') && idioma == 'ingles')
                options += '<option value="'+rows[i]['nombre_ingles']+'">'+rows[i]['nombre_ingles']+'</option>';
              if(referencia == 'id' && idioma == 'ingles')
                options += '<option value="'+rows[i]['id']+'">'+rows[i]['nombre_ingles']+'</option>';
              if(referencia == 'id' && idioma == 'espanol')
                options += '<option value="'+rows[i]['id']+'">'+rows[i]['nombre']+'</option>';
              if(referencia == 'nombre' && idioma == 'espanol')
                options += '<option value="'+rows[i]['nombre']+'">'+rows[i]['nombre']+'</option>';
            }
          }
        }
      });
      return options;
    }
    function getMunicipios(id_estado, selector, id_municipio) {
      $.ajax({
        url: '<?php echo base_url('Funciones/getMunicipios'); ?>',
        method: 'POST',
        data: {
          'id_estado': id_estado
        },
        success: function(res) {
          $(""+selector+"").html(res);
          $(""+selector+"").val(id_municipio)
        }
      });
    }
    function submitForm({id, id_seccion, url, refresh = false, num = 0, id_ref = 0, hideModal = true, updateButton = '', deleteButton = '', action = '', encrypt = false, clave_txt = '', seccion = '', source = '', backToForm = false, localStorageSection = ''}) {
      let datos = $('#dataForm').serialize();
      datos += '&id_candidato=' + id;
      datos += '&id_seccion=' + id_seccion;
      datos += '&num=' + num;
      datos += '&id_ref=' + id_ref;
      datos += '&source=' + source;
      if(encrypt){
        datos += '&url=' + url;
        //let data = JSON.stringify(datos)
        let encryptedData = CryptoJSAesJson.encrypt(datos, clave_txt)
        var textFile = new File([encryptedData], {
          type: 'text/plain'
        });
        var fileNameToSaveAs = id+'-s'+id_seccion + ".txt";
        var downloadLink = document.createElement("a");
        downloadLink.download = fileNameToSaveAs;
        downloadLink.innerHTML = "My Hidden Link";
        window.URL = window.URL || window.webkitURL;
        downloadLink.href = window.URL.createObjectURL(textFile);
        downloadLink.onclick = destroyClickedElement;
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
      }
      $.ajax({
        url: url,
        type: 'POST',
        data: datos,
        success: function(res) {
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            if(hideModal)
              $("#formularioModal").modal('hide')
            if(refresh)
              recargarTable()
            if(data.nuevo_id != null && data.nuevo_id != ''){
              const parametros = {
                id: id,
                id_seccion: id_seccion,
                url: url,
                refresh: refresh,
                num: num,
                id_ref: data.nuevo_id,
                hideModal: hideModal,
                updateButton: updateButton,
                deleteButton: deleteButton
              }
              $('#'+updateButton+num).removeAttr('onclick');
              $('#'+updateButton+num).attr("onclick","submitForm("+JSON.stringify(parametros)+")");
              //$('#'+deleteButton+num).prop('disabled', false);
              //$('#'+deleteButton+num).attr("onclick","mostrarMensajeConfirmacion(\""+action+"\","+num+","+data.nuevo_id+","+id+","+id_seccion+")");
            }
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: data.msg,
              showConfirmButton: false,
              timer: 2500
            })
            if(backToForm){
              localStorage.setItem(localStorageSection, 1)
            }
            setTimeout(() => {
              location.reload()
            }, 2500);
          } else {
            Swal.fire({
              icon: 'error',
              title: 'There was a problem submitting the form',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Close'
            })
          }
        }
      });
    }
    function guardarLaboral(id, num, id_candidato, autor, candidato, id_seccion, id_cliente, tiempo) {
      let textoResponse = ''; let separador = ''; var campos = '';
      separador = 'cand_';
      if(id != 0)
        textoResponse = 'Job updated successfully';
      else
        textoResponse = 'Job saved successfully';
      
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccionAndAutor'); ?>',
        method: 'POST',
        data: {'id_seccion':id_seccion,'tipo_orden':'orden_front','autor':autor},
        async:false,
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            campos = JSON.parse(res);
          }
        }
      });
      let objeto = new Object();
      for(let tag of campos){
        let param = tag['atr_id'].split(separador);
        objeto[param[1]] = $('[name="'+tag['atr_id']+'[]"]').eq(num).val();
      }
      let datos = $.param(objeto);
      datos += '&id_candidato=' + id_candidato
      datos += '&id_seccion=' + id_seccion;
      datos += '&id=' + id;
      datos += '&num=' + num;
      datos += '&autor=' + autor;
      datos += '&seccion=laborales'

      if(id_seccion == 16 || id_seccion == 32 || id_seccion == 59 || id_seccion == 77 || id_seccion == 90){
        if(autor == 'candidato'){
          $.ajax({
            url: '<?php echo base_url('Candidato_Laboral/setHistorialLaboral'); ?>',
            type: 'POST',
            data: datos,
            async:false,
            beforeSend: function() {
              $('.loader').css("display", "block");
            },
            success: function(res) {
              setTimeout(function() {
                $('.loader').fadeOut();
              }, 200);
              var data = JSON.parse(res);
              if (data.codigo === 1) {
                $('#formularioModal').modal('hide')
                $('#rowForm').empty()
                //$("#formCard").css('display','none')
                localStorage.setItem('empleoGuardado', 1);
                localStorage.setItem('empleoNumero', num);
                //getEmploymentHistory(id_candidato, id_seccion, id_cliente, candidato, tiempo)
                setTimeout(() => {
                  location.reload()
                }, 2500);
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: textoResponse,
                  showConfirmButton: false,
                  timer: 2500
                })
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'There was a problem submitting the form',
                  html: data.msg,
                  width: '50em',
                  confirmButtonText: 'Close'
                })
              }
            }
          });
        }
      }
      if(id_seccion == 55){
        $.ajax({
          url: '<?php echo base_url('Candidato_Laboral/setAntecedentesLaborales'); ?>',
          type: 'POST',
          data: datos,
          async:false,
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            var data = JSON.parse(res);
            if (data.codigo === 1) {
              $('#formularioModal').modal('hide')
              $('#rowForm').empty()
              //$("#formCard").css('display','none')
              localStorage.setItem('empleoGuardado', 1);
              //getEmploymentHistory(id_candidato, id_seccion, id_cliente, candidato, tiempo)
              setTimeout(() => {
                location.reload()
              }, 2500);
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: textoResponse,
                showConfirmButton: false,
                timer: 2500
              })
            } else {
              Swal.fire({
                icon: 'error',
                title: 'There was a problem submitting the form',
                html: data.msg,
                width: '50em',
                confirmButtonText: 'Close'
              })
            }
          }
        });
      }
    }
    function guardarGap(id_candidato){
      let razon = $("#razon_gap").val();
      let fi = $("#fecha_inicio_gap").val();
      let ff = $("#fecha_fin_gap").val();
      $.ajax({
        url: '<?php echo base_url('Gap/store'); ?>',
        method: 'POST',
        data: {'id_candidato':id_candidato,'fi':fi,'ff':ff,'razon':razon},
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res){
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          if(res != 0){
            let data = JSON.parse(res);
            if (data.codigo === 1) {
              localStorage.setItem('gapGuardado', 1);
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: data.msg,
                showConfirmButton: false,
                timer: 2500
              })
              setTimeout(() => {
                location.reload()
              }, 2500);
              //$("#formCrearGap")[0].reset();
            }
            else{
              Swal.fire({
                icon: 'error',
                title: 'There was a problem submitting the form',
                html: data.msg,
                width: '50em',
                confirmButtonText: 'Close'
              })
            }
          }
        }
      });
    }
    function mostrarMensajeConfirmacion(accion,valor1,valor2, id_candidato, id_seccion){
      // if(accion == "eliminar referencia personal"){
      //   $('#titulo_mensaje').text('Delete personal reference');
      //   $('#mensaje').html('Do you want to delete personal reference <b>#'+valor1+'</b>?');
      //   $('#btnConfirmar').attr("onclick","eliminarRefPersonal("+valor1+","+valor2+","+id_candidato+")");
      //   $('#mensajeModal').modal('show');
      // }
      // if(accion == "eliminar integrante familiar"){
      //   $('#titulo_mensaje').text('Delete family member');
      //   $('#mensaje').html('Do you want to delete the family memeber <b>'+(valor2)+'</b>?');
      //   $('#btnConfirmar').attr("onclick","eliminarIntegranteFamiliar("+valor1+",\""+valor2+"\","+id_candidato+")");
      //   $('#mensajeModal').modal('show');
      // }
      // if(accion == "eliminar domicilio"){
      //   $('#titulo_mensaje').text('Delete address');
      //   $('#mensaje').html('Do you want to delete the address with period <b>'+(valor2)+'</b>?');
      //   $('#btnConfirmar').attr("onclick","eliminarDomicilio("+valor1+",\""+valor2+"\","+id_candidato+")");
      //   $('#mensajeModal').modal('show');
      // }
      // if(accion == "Delete Job"){
      //   $('#titulo_mensaje').text('Delete job');
      //   $('#mensaje').html('Do you want to delete the job <b>#'+(valor2 + 1)+'</b>?');
      //   $('#btnConfirmar').attr("onclick","eliminarLaboral(\"Delete Job\","+valor1+","+valor2+","+id_candidato+","+id_seccion+")");
      //   $('#mensajeModal').modal('show');
      // }
      // if(accion == "eliminar antecedente laboral"){
      //   $('#titulo_mensaje').text('Delete Job');
      //   $('#mensaje').html('¿Desea eliminar la laboral <b>#'+valor2+'</b>?');
      //   $('#btnConfirmar').attr("onclick","eliminarLaboral(\"eliminar antecedente laboral\","+valor1+","+valor2+")");
      //   $('#mensajeModal').modal('show');
      // }
      // if(accion == "eliminar contacto laboral"){
      //   $('#titulo_mensaje').text('Eliminar contacto/informante laboral');
      //   $('#mensaje').html('¿Desea eliminar el contacto/informante de la laboral <b>#'+valor2+'</b>?');
      //   $('#btnConfirmar').attr("onclick","eliminarLaboral(\"eliminar contacto laboral\","+valor1+","+valor2+")");
      //   $('#mensajeModal').modal('show');
      // }
      // if(accion == "eliminar gap"){
      //   $('#titulo_mensaje').text('Eliminar Gap');
      //   $('#mensaje').html('¿Desea eliminar el gap <b>#'+valor2+'</b>?');
      //   $('#btnConfirmar').attr("onclick","eliminarGap("+valor1+","+id_candidato+")");
      //   $('#mensajeModal').modal('show');
      // }
    }
    function eliminarLaboral(opcion,id,number,id_candidato,id_seccion){
      var datos = new FormData();
      datos.append('id_candidato', id_candidato);
      datos.append('id', id);
      datos.append('numero', (number + 1));
      if(opcion == 'Delete Job'){
        $.ajax({
          url: '<?php echo base_url('Candidato_Laboral/deleteLaboral'); ?>',
          type: 'POST',
          data: datos,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            var data = JSON.parse(res);
            if (data.codigo === 1) {
              $('#mensajeModal').modal('hide');
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Laboral eliminada correctamente',
                showConfirmButton: false,
                timer: 2500
              })
              localStorage.setItem('empleoEliminado', 1);
              location.reload()
            }
          }
        });
      }
      if(opcion == 'eliminar antecedente laboral'){
        $.ajax({
          url: '<?php echo base_url('Candidato_Laboral/deleteAntecedenteLaboral'); ?>',
          type: 'POST',
          data: datos,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            var data = JSON.parse(res);
            if (data.codigo === 1) {
              $('#mensajeModal').modal('hide');
              $("#rowHistorialLaboral").empty();
              getHistorialLaboral(id_candidato, id_seccion)
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Laboral eliminada correctamente',
                showConfirmButton: false,
                timer: 2500
              })
              localStorage.setItem('empleoEliminado', 1);
              location.reload()
            }
          }
        });
      }
      if(opcion == 'eliminar contacto laboral'){
        $.ajax({
          url: '<?php echo base_url('Candidato_Laboral/deleteContacto'); ?>',
          type: 'POST',
          data: datos,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            var data = JSON.parse(res);
            if (data.codigo === 1) {
              $('#mensajeModal').modal('hide');
              $("#rowHistorialLaboral").empty();
              getHistorialLaboral(id_candidato, id_seccion)
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Contacto/Informante laboral eliminado correctamente',
                showConfirmButton: false,
                timer: 2500
              })
              localStorage.setItem('empleoEliminado', 1);
              location.reload()
            }
          }
        });
      }
      if(opcion == 'eliminar referencia cliente'){
        $.ajax({
          url: '<?php echo base_url('ReferenciaCliente/delete'); ?>',
          type: 'POST',
          data: datos,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('.loader').css("display", "block");
          },
          success: function(res) {
            setTimeout(function() {
              $('.loader').fadeOut();
            }, 200);
            var data = JSON.parse(res);
            if (data.codigo === 1) {
              $('#mensajeModal').modal('hide');
              $("#rowHistorialLaboral").empty();
              getReferenciasClientes(id_candidato, id_seccion)
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Referencia eliminada correctamente',
                showConfirmButton: false,
                timer: 2500
              })
              localStorage.setItem('empleoEliminado', 1);
              location.reload()
            }
          }
        });
      }
    }
    function actualizarTrabajoGobierno2(id_candidato) {
      var datos = new FormData();
      datos.append('trabajo_gobierno', $("#trabajo_gobierno").val());
      datos.append('trabajo_inactivo', $("#trabajo_inactivo").val());
      datos.append('id_candidato', id_candidato);
      
      $.ajax({
        url: '<?php echo base_url('Candidato_Laboral/setCuestiones'); ?>',
        type: 'POST',
        data: datos,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            localStorage.setItem('empleoExtra', 1);
            setTimeout(() => {
              location.reload()
            }, 2500);
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Information saved successfully',
              showConfirmButton: false,
              timer: 2500
            })
          } else {
            Swal.fire({
              icon: 'error',
              title: 'There was a problem submitting the form',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Close'
            })
          }
        }
      });
    }
    function nuevoFamiliar(id_candidato){
      let opciones = ''; 
      let url_parentescos = '<?php echo base_url('Funciones/getParentescos'); ?>'; let parentescos_data = getDataCatalogo(url_parentescos, 'id', 1, 'ingles');
      let url_escolaridad = '<?php echo base_url('Funciones/getEscolaridades'); ?>'; let escolaridades_data = getDataCatalogo(url_escolaridad, 'id', 0, 'ingles');
      let url_civiles = '<?php echo base_url('Funciones/getCiviles'); ?>'; let civiles_data = getDataCatalogo(url_civiles, 'nombre', 0, 'ingles');
      $('#rowNuevoFamiliar').empty();
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':35,'tipo_orden':'orden_front'},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            //$("#familiaresModal").modal('hide');
            $('.loader').fadeOut();
            if(res != 0){
              var dato = JSON.parse(res);
              for(let tag of dato){
                let referencia = tag['referencia'];
                if(referencia == 'id_tipo_parentesco')
                  opciones = parentescos_data;
                if(referencia == 'estado_civil')
                  opciones = civiles_data;
                if(referencia == 'id_grado_estudio')
                  opciones = escolaridades_data;
                if(referencia == 'misma_vivienda' || referencia == 'adeudo')
                  opciones = '<option value="0">No</option><option value="1">Yes</option>';

                if(tag['tipo_etiqueta'] == 'select'){
                  $('#rowNuevoFamiliar').append(tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+opciones+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'input'){
                  $('#rowNuevoFamiliar').append(tag['titulo_seccion_modal']+tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'textarea'){
                  $('#rowNuevoFamiliar').append(tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
              }
              //* Boton Guardar
              $('#rowNuevoFamiliar').append('<div class="col-12 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-success btn-lg btn-block" onclick="guardarIntegranteFamiliar(0,0,'+id_candidato+')"><i class="fas fa-plus-circle"></i> Add</a></div></div>');
            }
            else{
              $('#rowNuevoFamiliar').html('<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>');
            }
          },200);
          $('#tituloNuevoRegistroModal').text('Add Family Member')
          $("#nuevoFamiliarModal").modal('show');
        }
      });
    }
    function guardarIntegranteFamiliar(id_familiar, num_familiar, idCandidato) {
      var campos = '';
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':35,'tipo_orden':'orden_front'},
        async:false,
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            campos = JSON.parse(res);
          }
        }
      });
      let objeto = new Object();
      for(let tag of campos){
        let param = tag['atr_id'];
        objeto[tag['atr_id']] = $('[name="'+tag['atr_id']+'[]"]').eq(num_familiar).val();
      }
      let datos = $.param(objeto);
      datos += '&id_candidato=' + idCandidato;
      datos += '&id_seccion=' + 35;
      datos += '&id_familiar=' + id_familiar;
      datos += '&num=' + num_familiar;
      datos += '&source=candidato';
      
      $.ajax({
        url: '<?php echo base_url('Candidato_Familiar/set'); ?>',
        type: 'POST',
        data: datos,
        async:false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if(id_familiar != 0){
            var textoResponse = 'Family member updated successfully';
          }
          else{
            var textoResponse = 'Family member added successfully';
            $('#rowNuevoFamiliar').empty();
            $("#nuevoFamiliarModal").modal('hide');
          }
          if (data.codigo === 1) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: textoResponse,
              showConfirmButton: false,
              timer: 2500
            })
            localStorage.setItem('familiarGuardado', 1);
            location.reload()
          } else {
            Swal.fire({
              icon: 'error',
              title: 'There was a problem submitting the form',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Close'
            })
          }
        }
      });
    }
    function eliminarIntegranteFamiliar(id_familiar, candidato, id_candidato){
      var datos = new FormData();
      datos.append('id_candidato', id_candidato);
      datos.append('id_familiar', id_familiar);

      $.ajax({
        url: '<?php echo base_url('Candidato_Familiar/delete'); ?>',
        type: 'POST',
        data: datos,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            $('#mensajeModal').modal('hide');
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Family member deleted successfully',
              showConfirmButton: false,
              timer: 2500
            })
            localStorage.setItem('familiarEliminado', 1);
            location.reload()
          }
        }
      });
    }
    function eliminarRefPersonal(num, id, id_candidato){
      var datos = new FormData();
      datos.append('id_candidato', id_candidato);
      datos.append('id', id);
      $.ajax({
        url: '<?php echo base_url('Candidato_Ref_Personal/delete'); ?>',
        type: 'POST',
        data: datos,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            $('#mensajeModal').modal('hide');
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: data.msg,
              showConfirmButton: false,
              timer: 2500
            })
            localStorage.setItem('referenciaPersonalEliminado', 1);
            location.reload()
          }
        }
      });
    }
    function nuevoDomicilio(id_candidato, id_seccion){
      $('#formularioModal').modal('hide')
      $('#rowForm').empty()
      let opciones = ''; 
      let url_estados = '<?php echo base_url('Funciones/getEstados'); ?>'; let estados_data = getDataCatalogo(url_estados, 'id', 0, 'espanol');
      let url_paises = '<?php echo base_url('Funciones/getPaises'); ?>'; let paises_data = getDataCatalogo(url_paises, 'nombre', 0, 'ingles');
      $('#rowNuevoFamiliar').empty();
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':id_seccion,'tipo_orden':'orden_front'},
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            //$("#familiaresModal").modal('hide');
            $('.loader').fadeOut();
            if(res != 0){
              var dato = JSON.parse(res);
              for(let tag of dato){
                let referencia = tag['referencia'];
                if(referencia == 'id_estado')
                  opciones = estados_data;
                if(referencia == 'pais')
                  opciones = paises_data;

                if(tag['tipo_etiqueta'] == 'select'){
                  $('#rowNuevoFamiliar').append(tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+opciones+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'input'){
                  $('#rowNuevoFamiliar').append(tag['titulo_seccion_modal']+tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
                if(tag['tipo_etiqueta'] == 'textarea'){
                  $('#rowNuevoFamiliar').append(tag['grid_col_inicio']+tag['label_ingles']+tag['etiqueta_inicio']+tag['etiqueta_cierre']+tag['grid_col_cierre']);
                }
              }
              //* Boton Guardar
              $('#rowNuevoFamiliar').append('<div class="col-12 mt-3 mb-3"><a href="javascript:void(0)" class="btn btn-success btn-lg btn-block" onclick="guardarDomicilio(0,0,'+id_candidato+','+id_seccion+')"><i class="fas fa-plus-circle"></i> Add</a></div></div>');
              //* Funciones
              let index = 0;
              for(let tag of dato){
                $('[name="'+tag['atr_id']+'[]"]').eq(index).addClass('dom'+index);
                if(tag['referencia'] == 'id_estado'){
                  $('[name="id_estado[]"]').eq(index).removeAttr('id')
                  $('[name="id_estado[]"]').eq(index).attr('id','id_estado_nuevo');
                  $('#rowNuevoFamiliar').append('<script>$("#id_estado_nuevo").change(function(){getMunicipios($("#id_estado_nuevo").val(), "#id_municipio_nuevo", "")})<\/script>');
                }
                if(tag['referencia'] == 'id_municipio'){
                  $('[name="id_municipio[]"]').eq(index).empty()
                  $('[name="id_municipio[]"]').eq(index).append('<option value="">Select</option>');
                  $('[name="id_municipio[]"]').eq(index).removeAttr('id')
                  $('[name="id_municipio[]"]').eq(index).attr('id','id_municipio_nuevo');
                }                
              }
            }
            else{
              $('#rowNuevoFamiliar').html('<div class="col-12 text-center"><h5><b>Form not registered for this candidate</b></h5></div>');
            }
          },200);
          $('#tituloNuevoRegistroModal').text('Add Address')
          $("#nuevoFamiliarModal").modal('show');
        }
      });
    }
    function guardarDomicilio(id_domicilio, num_domicilio, idCandidato, id_seccion) {
      var campos = '';
      $.ajax({
        url: '<?php echo base_url('Formulario/getBySeccion'); ?>',
        method: 'POST',
        data: {'id_seccion':id_seccion,'tipo_orden':'orden_front'},
        async:false,
        beforeSend: function() {
          $('.loader').css("display","block");
        },
        success: function(res){
          setTimeout(function(){
            $('.loader').fadeOut();
          },200);
          if(res != 0){
            campos = JSON.parse(res);
          }
        }
      });
      let objeto = new Object();
      for(let tag of campos){
        let param = tag['atr_id'];
        objeto[tag['atr_id']] = $('[name="'+tag['atr_id']+'[]"]').eq(num_domicilio).val();
      }
      let datos = $.param(objeto);
      datos += '&id_candidato=' + idCandidato;
      datos += '&id_seccion=' + id_seccion;
      datos += '&id_domicilio=' + id_domicilio;
      datos += '&num=' + num_domicilio;
      datos += '&source=candidato';
      
      $.ajax({
        url: '<?php echo base_url('Domicilio/store'); ?>',
        type: 'POST',
        data: datos,
        async:false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if(id_domicilio != 0){
            var textoResponse = 'Address updated successfully';
          }
          else{
            var textoResponse = 'Address added successfully';
            $('#rowNuevoFamiliar').empty();
            $("#nuevoFamiliarModal").modal('hide');
          }
          if (data.codigo === 1) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: textoResponse,
              showConfirmButton: false,
              timer: 2500
            })
            localStorage.setItem('domicilioGuardado', 1);
            location.reload()
          } else {
            Swal.fire({
              icon: 'error',
              title: 'There was a problem submitting the form',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Close'
            })
          }
        }
      });
    }
    function eliminarDomicilio(id_domicilio, candidato, id_candidato){
      var datos = new FormData();
      datos.append('id_candidato', id_candidato);
      datos.append('id_domicilio', id_domicilio);

      $.ajax({
        url: '<?php echo base_url('Domicilio/delete'); ?>',
        type: 'POST',
        data: datos,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            $('#mensajeModal').modal('hide');
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Address deleted successfully',
              showConfirmButton: false,
              timer: 2500
            })
            localStorage.setItem('domicilioEliminado', 1);
            location.reload()
          }
        }
      });
    }
    function eliminarGap(id_gap, id_candidato){
      var datos = new FormData();
      datos.append('id_candidato', id_candidato);
      datos.append('id_gap', id_gap);

      $.ajax({
        url: '<?php echo base_url('Gap/delete'); ?>',
        type: 'POST',
        data: datos,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            $('#mensajeModal').modal('hide');
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Gap deleted successfully',
              showConfirmButton: false,
              timer: 2500
            })
            localStorage.setItem('gapEliminado', 1);
            location.reload()
          }
        }
      });
    }
    function subirArchivos(id_tipo, id_candidato, input) {
      var docs = new FormData();
			docs.append('id_tipo', id_tipo);
			docs.append("id_candidato", id_candidato);
			var num_files = document.getElementById(input).files.length;
			for (var x = 0; x < num_files; x++) {
				docs.append("archivos[]", document.getElementById(input).files[x]);
			}
      $.ajax({
        url: "<?php echo base_url('Documentacion/subirArchivosCandidato'); ?>",
        method: "POST",
        data: docs,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            setTimeout(() => {
              location.reload()
            }, 2500);
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: data.msg,
              showConfirmButton: false,
              timer: 2500
            })
          }
          else {
            Swal.fire({
              icon: 'error',
              title: 'There was a problem uploading the file',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Close'
            })
          }
        }
      });
    }
    function confirmarFormularios(id_candidato){
      $('#titulo_mensaje').text('Submit forms for review');
			$('#mensaje').html('This is a message for our analyst to review your information.');
			$('#btnConfirmar').attr("onclick","enviarConfirmacion("+id_candidato+",'formularios')");
			$('#mensajeModal').modal('show');
    }
    function confirmarDocumentacion(id_candidato){
      $('#titulo_mensaje').text('Submit documents for review');
			$('#mensaje').html('This is a message for our analyst to review your documents.');
			$('#btnConfirmar').attr("onclick","enviarConfirmacion("+id_candidato+",'documentos')");
			$('#mensajeModal').modal('show');
    }
    function confirmarFinalizar(id_candidato){
      $('#titulo_mensaje').text('Confirm');
			$('#mensaje').html('Have you filled all forms and uploaded all required files? ');
			$('#btnConfirmar').attr("onclick","enviarConfirmacion("+id_candidato+",'finalizar')");
			$('#mensajeModal').modal('show');
    }
    function enviarConfirmacion(id_candidato, contexto){
      let datos = new FormData();
      datos.append('id_candidato', id_candidato);
      datos.append('contexto', contexto);
      $.ajax({
        url: '<?php echo base_url('Candidato/registrar_confirmacion_by_candidato'); ?>',
        type: 'POST',
        data: datos,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            $('#mensajeModal').modal('hide');
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: data.msg,
              showConfirmButton: false,
              timer: 2500
            })
          }
          if (data.codigo === 2) {
            $("#mensajeModal").modal("hide");
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: data.msg,
              showConfirmButton: false,
              timer: 10000,
              allowOutsideClick: false,
              allowEscapeKey: false,
              allowEnterKey: false
            })
            setTimeout(function() {
              window.location.href = "<?php echo base_url(); ?>Login/logout";
            }, 10000);
          }
          // else{
          //   Swal.fire({
          //     icon: 'error',
          //     title: 'There was a problem submitting the message, try later',
          //     html: data.msg,
          //     width: '50em',
          //     confirmButtonText: 'Close'
          //   })
          // }
        }
      });
    }
    function closeForm(){
      $('#rowForm').empty()
      $("#formCard").css('display','none')
      $('html, body').animate({
        scrollTop: $('#divForms').offset().top
      }, 1000);
    }
    function validateInput(textarea) {
      // Expresión regular escapada
      let regexPattern = /[\n\"'\\/]/g;
      // Obtener el valor actual del textarea
      let inputText = textarea.value;
      // Realizar el reemplazo solo para comillas y barras diagonales
      let sanitizedText = inputText.replace(regexPattern, ' ');
      // Actualizar el valor del textarea solo si hay cambios
      if (inputText !== sanitizedText) {
        textarea.value = sanitizedText
        let pElement = document.createElement("p")
        pElement.innerHTML = '<p><i class="fas fa-exclamation-circle"></i> Quotation marks, forward slashes and line breaks are not allowed.</p>'
        pElement.style.color = "red"
        textarea.insertAdjacentElement('afterend', pElement);
        setTimeout(() => {
          pElement.remove()
        }, 2500);
      }
    }
  </script>
</body>
</html>