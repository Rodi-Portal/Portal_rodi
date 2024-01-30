<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Upload Documents | RODI</title>
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<script src="https://kit.fontawesome.com/fdf6fee49b.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<!-- Select Bootstrap -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
	<!-- Sweetalert 2 -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>img/favicon.jpg" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/candidato.css">
</head>

<body>
	<div class="modal fade" id="mensajeModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Success!</h4>
				</div>
				<div class="modal-body">
					<h5>Your documents have been uploaded successfully if we need any further documentacion or information we will contact you please, be aware.</h5>
				</div>
			</div>
		</div>
	</div>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu">
			<a class="navbar-brand text-light" href="#">
				<img src="<?php echo base_url() ?>img/favicon.jpg" class="space">
				<?php echo $this->session->userdata('nombre') . " " . $this->session->userdata('paterno') . " " . $this->session->userdata('materno'); ?>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link text-light font-weight-bold" href="<?php echo base_url(); ?>Login/logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
					</li>
				</ul>
			</div>
		</nav>
	</header>
	<div class="loader" style="display: none;"></div>
	<?php 
  if($id_cliente == 172 || $id_cliente == 178){
    if($this->session->userdata('proyecto') == 150 || $this->session->userdata('proyecto') == 151 || $this->session->userdata('proyecto') == 152 || $this->session->userdata('proyecto') == 153 || $this->session->userdata('proyecto') == 154 || $this->session->userdata('proyecto') == 155 || $this->session->userdata('proyecto') == 156 || $this->session->userdata('proyecto') == 157 || $this->session->userdata('proyecto') == 161 || $this->session->userdata('proyecto') == 162){
      $titulo_criminal = 'If the government issues a non-criminal history document, upload it please';
      $btn_criminal = 'Click here to upload your non-criminal history document';
      $titulo_empleo = 'If the government issues an employment history document, upload it please';
      $btn_empleo = 'Click here to upload your employment history document';
    }
    else{
      $titulo_criminal = 'Upload your non-criminal background letter (Not apply in some cities like Mexico city and Monterrey)';
      $btn_criminal = 'Click here to upload your non-criminal background letter';
      $titulo_empleo = 'Upload your IMSS report (in case you have the report)';
      $btn_empleo = 'Click here to upload your IMSS report';
    }
    ?>
    <?php 
    if($proyecto_seccion == 'National Verification' || $proyecto_seccion == 'International Verification'){ ?>
      <div class="formulario contenedor mt-5">
        <div class="row">
          <div class="col-lg-12">
            <p class='text-center p-3 mb-2 bg-info text-white'>Verify and try to upload all the following documents in pdf, jpg or png formats (Max. 2MB each)<br>The documents with * are required, if you don't have some document you can back to platform for upload as soon as possible.
            </p>
            <hr>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label>Upload your professional licence or studies certificate *</label>
                <?php
                if (in_array(7, $docs_candidato)) { ?>
                  <div id="estudios_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="estudios_completado">
                    <input id="doc_estudios" class="obligado" type="file" name="doc_estudios" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(7,'doc_estudios')">Click here to upload your professional licence or studies certificate</button><br><br>
                  </div>
                <?php	
                }
                ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label>Upload your identification document (ID) *</label>
                <?php
                if (in_array(3, $docs_candidato)) { ?>
                  <div id="ine_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="ine_completado">
                    <input id="doc_ine" class="obligado" type="file" name="doc_ine" accept=".pdf, .jpg, .jpeg, .png"><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(3,'doc_ine')">Click here to upload your ID</button><br><br>
                  </div>
                <?php	}
                ?>
              </div>
              <div class="col-sm-12 col-md-6">
                <label><?php echo $titulo_empleo; ?> *</label>
                <?php
                if (in_array(9, $docs_candidato)) { ?>
                  <div id="semanas_cotizadas_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="semanas_cotizadas_completado">
                    <input id="doc_semanas" type="file" name="doc_semanas" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(9,'doc_semanas')"><?php echo $btn_empleo ?></button><br><br>
                  </div>
                <?php	
                }
                ?>
              </div>
            </div>
            <hr>
            <div id="msj_error" class="alert alert-danger hidden"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button class="btn btn-success btn-block" onclick="concluirDocumentacion()">Finish</button>
          </div>
        </div>
      </div>
    <?php
    }
    if($proyecto_seccion == 'International Check'){ ?>
      <div class="formulario contenedor mt-5">
        <div class="row">
          <div class="col-lg-12">
            <p class='text-center p-3 mb-2 bg-info text-white'>Verify and try to upload all the following documents in pdf, jpg or png formats (Max. 2MB each)<br>The documents with * are required, if you don't have some document you can back to platform for upload as soon as possible.
            </p>
            <hr>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label>Upload your <a href="<?php echo base_url() . "privacy_notice/mvr.pdf" ?>" target="_blank">MVR (Motor Vehicle Records) if you live in USA</a></label>
                <?php
                if (in_array(44, $docs_candidato)) { ?>
                  <div id="mvr_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="mvr_completado">
                    <input id="doc_mvr" class="obligado" type="file" name="doc_mvr" accept=".pdf, .jpg, .jpeg, .png"><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(44,'doc_mvr')">Click here to upload your MVR</button><br><br>
                  </div>
                <?php	
                }
                ?>
              </div>
              <div class="col-sm-12 col-md-6">
                <label>Upload your professional licence or studies certificate *</label>
                <?php
                if (in_array(7, $docs_candidato)) { ?>
                  <div id="estudios_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="estudios_completado">
                    <input id="doc_estudios" class="obligado" type="file" name="doc_estudios" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(7,'doc_estudios')">Click here to upload your professional licence or studies certificate</button><br><br>
                  </div>
                <?php	
                }
                ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label>Upload your identification document (ID) *</label>
                <?php
                if (in_array(3, $docs_candidato)) { ?>
                  <div id="ine_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="ine_completado">
                    <input id="doc_ine" class="obligado" type="file" name="doc_ine" accept=".pdf, .jpg, .jpeg, .png"><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(3,'doc_ine')">Click here to upload your ID</button><br><br>
                  </div>
                <?php	}
                ?>
              </div>
              <div class="col-sm-12 col-md-6">
                <label><?php echo $titulo_empleo; ?> *</label>
                <?php
                if (in_array(9, $docs_candidato)) { ?>
                  <div id="semanas_cotizadas_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="semanas_cotizadas_completado">
                    <input id="doc_semanas" type="file" name="doc_semanas" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(9,'doc_semanas')"><?php echo $btn_empleo ?></button><br><br>
                  </div>
                <?php	
                }
                ?>
              </div>
            </div>
            <hr>
            <div id="msj_error" class="alert alert-danger hidden"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button class="btn btn-success btn-block" onclick="concluirDocumentacion()">Finish</button>
          </div>
        </div>
      </div>
    <?php
    } 
    if($proyecto_seccion == 'Identity and Criminal Verification'){ ?>
      <div class="formulario contenedor mt-5">
        <div class="row">
          <div class="col-lg-12">
            <p class='text-center p-3 mb-2 bg-info text-white'>Verify and try to upload all the following documents in pdf, jpg or png formats (Max. 2MB each)<br>The documents with * are required, if you don't have some document you can back to platform for upload as soon as possible.
            </p>
            <hr>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label>Upload your identification document (ID) *</label>
                <?php
                if (in_array(3, $docs_candidato)) { ?>
                  <div id="ine_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="ine_completado">
                    <input id="doc_ine" class="obligado" type="file" name="doc_ine" accept=".pdf, .jpg, .jpeg, .png"><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(3,'doc_ine')">Click here to upload your ID</button><br><br>
                  </div>
                <?php	}
                ?>
              </div>
              <div class="col-sm-12 col-md-6">
                <label>Upload your Passport </label>
                <?php
                if (in_array(14, $docs_candidato)) { ?>
                  <div id="pasaporte_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="pasaporte_completado">
                    <input id="doc_pasaporte" type="file" name="doc_pasaporte" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(14,'doc_pasaporte')">Click here to upload your Passport</button><br><br>
                  </div>
                <?php	
                }
                ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label>Migration Certificate or Migratory Form </label>
                <?php
                if (in_array(20, $docs_candidato)) { ?>
                  <div id="migracion_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="migracion_completado">
                    <input id="doc_migracion" class="obligado" type="file" name="doc_migracion" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(20,'doc_migracion')">Click here to upload your migration certificate or migratory form</button><br><br>
                  </div>
                <?php	
                }
                ?>
              </div>
            </div>
            <hr>
           
            <hr>
            <div id="msj_error" class="alert alert-danger hidden"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button class="btn btn-success btn-block" onclick="concluirDocumentacion()">Finish</button>
          </div>
        </div>
      </div>
    <?php
    }
  }
  if($id_cliente == 211){
    // $titulo_criminal = 'If the government issues a non-criminal history document, upload it please';
    // $btn_criminal = 'Click here to upload your non-criminal history document';
    // $titulo_empleo = 'If the government issues an employment history document, upload it please';
    // $btn_empleo = 'Click here to upload your employment history document';
    // $titulo_criminal = 'Upload your non-criminal background letter (Not apply in some cities like Mexico city and Monterrey)';
    // $btn_criminal = 'Click here to upload your non-criminal background letter';
    // $titulo_empleo = 'Upload your IMSS report (in case you have the report)';
    // $btn_empleo = 'Click here to upload your IMSS report';
    ?>
    <div class="formulario contenedor mt-5">
      <div class="row">
        <div class="col-lg-12">
          <p class='text-center p-3 mb-2 bg-info text-white'>Verify and try to upload all the following documents in pdf, jpg or png formats (Max. 2MB each)<br>The documents with * are required, if you don't have some document you can back to platform for upload as soon as possible.
          </p>
          <hr>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <label>Upload your identification document (ID) *</label>
              <?php
              if (in_array(3, $docs_candidato)) { ?>
                <div id="ine_completado">
                  <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                </div>
              <?php
              } else { ?>
                <div id="ine_completado">
                  <input id="doc_ine" class="obligado" type="file" name="doc_ine" accept=".pdf, .jpg, .jpeg, .png"><br><br>
                  <button type="button" class="btn btn-info" onclick="subirArchivo(3,'doc_ine')">Click here to upload your ID</button><br><br>
                </div>
              <?php	}
              ?>
            </div>
            <div class="col-sm-12 col-md-6">
              <label>Upload your Passport </label>
              <?php
              if (in_array(14, $docs_candidato)) { ?>
                <div id="pasaporte_completado">
                  <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                </div>
              <?php
              } else { ?>
                <div id="pasaporte_completado">
                  <input id="doc_pasaporte" type="file" name="doc_pasaporte" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
                  <button type="button" class="btn btn-info" onclick="subirArchivo(14,'doc_pasaporte')">Click here to upload your Passport</button><br><br>
                </div>
              <?php	
              }
              ?>
            </div>
          </div>
          <hr>
          <div id="msj_error" class="alert alert-danger hidden"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button class="btn btn-success btn-block" onclick="concluirDocumentacion()">Finish</button>
        </div>
      </div>
    </div>
    <?php
  }
  if($tipo_proceso != 6 && $id_cliente != 172 && $id_cliente != 178 && $id_cliente != 96 && $id_cliente != 211){
    if($this->session->userdata('proyecto') == 150 || $this->session->userdata('proyecto') == 151 || $this->session->userdata('proyecto') == 152 || $this->session->userdata('proyecto') == 153 || $this->session->userdata('proyecto') == 154 || $this->session->userdata('proyecto') == 155 || $this->session->userdata('proyecto') == 156 || $this->session->userdata('proyecto') == 157 || $this->session->userdata('proyecto') == 161 || $this->session->userdata('proyecto') == 162){
      $titulo_criminal = 'If the government issues a non-criminal history document, upload it please';
      $btn_criminal = 'Click here to upload your non-criminal history document';
      $titulo_empleo = 'If the government issues an employment history document, upload it please';
      $btn_empleo = 'Click here to upload your employment history document';
    }
    else{
      $titulo_criminal = 'Upload your non-criminal background letter (Not apply in some cities like Mexico city and Monterrey)';
      $btn_criminal = 'Click here to upload your non-criminal background letter';
      $titulo_empleo = 'Upload your IMSS report (in case you have the report)';
      $btn_empleo = 'Click here to upload your IMSS report';
    }
    ?>
    <div class="formulario contenedor mt-5">
        <div class="row">
          <div class="col-lg-12">
            <p class='text-center p-3 mb-2 bg-info text-white'>Verify and try to upload all the following documents in pdf, jpg or png formats (Max. 2MB each)<br>The documents with * are required, if you don't have some document you can back to platform for upload as soon as possible.
            </p>
            <hr>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label>Upload your professional licence or studies certificate *</label>
                <?php
                if (in_array(7, $docs_candidato)) { ?>
                  <div id="estudios_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="estudios_completado">
                    <input id="doc_estudios" class="obligado" type="file" name="doc_estudios" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(7,'doc_estudios')">Click here to upload your professional licence or studies certificate</button><br><br>
                  </div>
                <?php	
                }
                ?>
              </div>
              <div class="col-sm-12 col-md-6">
                <label><?php echo $titulo_criminal ?> *</label>
                <?php
                if (in_array(12, $docs_candidato)) { ?>
                  <div id="antecedentes_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="antecedentes_completado">
                    <input id="doc_criminal" type="file" name="doc_criminal" accept=".pdf, .jpg, .jpeg, .png"><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(12,'doc_criminal')"><?php echo $btn_criminal ?></button><br><br>
                  </div>
                <?php	}
                ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label>Upload your identification document (ID) *</label>
                <?php
                if (in_array(3, $docs_candidato)) { ?>
                  <div id="ine_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="ine_completado">
                    <input id="doc_ine" class="obligado" type="file" name="doc_ine" accept=".pdf, .jpg, .jpeg, .png"><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(3,'doc_ine')">Click here to upload your ID</button><br><br>
                  </div>
                <?php	}
                ?>
              </div>
              <div class="col-sm-12 col-md-6">
                <label><?php echo $titulo_empleo; ?> *</label>
                <?php
                if (in_array(9, $docs_candidato)) { ?>
                  <div id="semanas_cotizadas_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="semanas_cotizadas_completado">
                    <input id="doc_semanas" type="file" name="doc_semanas" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(9,'doc_semanas')"><?php echo $btn_empleo ?></button><br><br>
                  </div>
                <?php	
                }
                ?>
              </div>
            </div>
            <hr>
            <div id="msj_error" class="alert alert-danger hidden"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button class="btn btn-success btn-block" onclick="concluirDocumentacion()">Finish</button>
          </div>
        </div>
    </div>
  <?php 
  }
  if($tipo_proceso == 1 && $id_cliente == 96){
    if($this->session->userdata('proyecto') == 150 || $this->session->userdata('proyecto') == 151 || $this->session->userdata('proyecto') == 152 || $this->session->userdata('proyecto') == 153 || $this->session->userdata('proyecto') == 154 || $this->session->userdata('proyecto') == 155 || $this->session->userdata('proyecto') == 156 || $this->session->userdata('proyecto') == 157 || $this->session->userdata('proyecto') == 161 || $this->session->userdata('proyecto') == 162){
      $titulo_criminal = 'If the government issues a non-criminal history document, upload it please';
      $titulo_empleo = 'If the government issues an employment history document, upload it please';
      $btn_empleo = 'Click here to upload your employment history document';
    }
    else{
      $titulo_criminal = 'Upload your non-criminal background letter (Not apply in some cities like Mexico city and Monterrey)';
      $titulo_empleo = 'Upload your IMSS report (in case you have the report)';
      $btn_empleo = 'Click here to upload your IMSS report';
    }
    ?>
    <div class="formulario contenedor mt-5">
        <div class="row">
          <div class="col-lg-12">
            <p class='text-center p-3 mb-2 bg-info text-white'>Verify and try to upload all the following documents in pdf, jpg or png formats (Max. 2MB each)<br>The documents with * are required, if you don't have some document you can back to platform for upload as soon as possible.
            </p>
            <hr>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label>Upload your professional licence or studies certificate *</label>
                <?php
                if (in_array(7, $docs_candidato)) { ?>
                  <div id="estudios_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="estudios_completado">
                    <input id="doc_estudios" class="obligado" type="file" name="doc_estudios" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(7,'doc_estudios')">Click here to upload your professional licence or studies certificate</button><br><br>
                  </div>
                <?php	
                }
                ?>
              </div>
              <div class="col-sm-12 col-md-6">
                <label>Upload your identification document (ID) *</label>
                <?php
                if (in_array(3, $docs_candidato)) { ?>
                  <div id="ine_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="ine_completado">
                    <input id="doc_ine" class="obligado" type="file" name="doc_ine" accept=".pdf, .jpg, .jpeg, .png"><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(3,'doc_ine')">Click here to upload your ID</button><br><br>
                  </div>
                <?php	}
                ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <label><?php echo $titulo_empleo; ?> *</label>
                <?php
                if (in_array(9, $docs_candidato)) { ?>
                  <div id="semanas_cotizadas_completado">
                    <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                  </div>
                <?php
                } else { ?>
                  <div id="semanas_cotizadas_completado">
                    <input id="doc_semanas" type="file" name="doc_semanas" accept=".pdf, .jpg, .jpeg, .png" multiple><br><br>
                    <button type="button" class="btn btn-info" onclick="subirArchivo(9,'doc_semanas')"><?php echo $btn_empleo ?></button><br><br>
                  </div>
                <?php	
                }
                ?>
              </div>
            </div>
            <hr>
            <div id="msj_error" class="alert alert-danger hidden"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button class="btn btn-success btn-block" onclick="concluirDocumentacion()">Finish</button>
          </div>
        </div>
    </div>
  <?php 
  }
  if($tipo_proceso == 6 && $id_cliente != 172 && $id_cliente != 178 && $id_cliente != 211){ ?>
    <div class="formulario contenedor mt-5">
      <div class="row">
        <div class="col-lg-12">
          <p class='text-center p-3 mb-2 bg-info text-white'>Verify and try to upload all the following documents in pdf, jpg or png formats (Max. 2MB each)<br>The documents with * are required, if you don't have some document you can back to platform for upload as soon as possible.
          </p>
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <label>Upload your identification document (ID) *</label>
              <?php
              if (in_array(3, $docs_candidato)) { ?>
                <div id="ine_completado">
                  <div class="alert alert-success mensaje"><strong>Document uploaded succesfully</strong></div>
                </div>
              <?php
              } else { ?>
                <div id="ine_completado">
                  <input id="doc_ine" class="obligado" type="file" name="doc_ine" accept=".pdf, .jpg, .jpeg, .png"><br><br>
                  <button type="button" class="btn btn-info" onclick="subirArchivo(3,'doc_ine')">Click here to upload your ID</button><br><br>
                </div>
              <?php	}
              ?>
            </div>
          </div>
          <hr>
          <div id="msj_error" class="alert alert-danger hidden"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button class="btn btn-success btn-block" onclick="concluirDocumentacion()">Finish</button>
        </div>
      </div>
    </div>
  <?php
  }
   ?>
	
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
	<!-- Sweetalert 2 -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
	<!-- Bootstrap Select -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
	<script>
		var id_candidato = "<?php echo $id_candidato; ?>";
		var proceso = "<?php echo $tipo_proceso; ?>";
		var nombre = "<?php echo $nombre; ?>";
		var paterno = "<?php echo $paterno; ?>";
		var prefijo = id_candidato + "_" + nombre + "_" + paterno;
		function concluirDocumentacion(){
			$.ajax({
				url: '<?php echo base_url('Candidato/finalizarDocumentacionCandidatoAnterior'); ?>',
				method: 'POST',
				data: {
					'id_candidato': id_candidato,
          'proceso': proceso
				},
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1){
						$("#mensajeModal").modal("show");
						setTimeout(function() {
						$("#mensajeModal").modal("hide");
							window.location.href = "<?php echo base_url(); ?>Login/logout";
						}, 10000);
					}
					else{
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: data.msg,
							showConfirmButton: false,
							timer: 2500
						})
					}
				}
			});
		}
		function subirArchivo(tipo,idInput) {
			var docs = new FormData();
			docs.append('tipo_documento', tipo);
			docs.append("id_candidato", id_candidato);
			var num_files = document.getElementById(idInput).files.length;
			for (var x = 0; x < num_files; x++) {
				docs.append("archivos[]", document.getElementById(idInput).files[x]);
			}
			$.ajax({
				url: "<?php echo base_url('Candidato/subirArchivosCandidato'); ?>",
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
					if (data.codigo === 0) {
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'Select the file from your device',
							showConfirmButton: false,
							timer: 2500
						})
					}
					if (data.codigo === 1) {
						location.reload();
					}
					if (data.codigo === 2) {
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: 'Select a PDF, JPG or PNG file with maximum size 2MB',
							showConfirmButton: false,
							timer: 2500
						})
					}
				}
			});
		}
	</script>
</body>

</html>