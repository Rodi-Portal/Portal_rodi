<!DOCTYPE html>
<html lang="es">
<head>
  <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>RODICONTROL <?php echo $version; ?></title>
  <!-- CSS -->
	<?php echo link_tag("css/custom.css"); ?>
  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="icon" type="image/jpg" href="<?php echo base_url() ?>img/favicon.jpg" sizes="64x64">
</head>

<body class="bg-gradient-primary">
  <?php 
  if($this->session->flashdata('error')){  ?>
    <div class="alert alert-danger alert-dismissible fade show text-center msj_login" role="alert" style="opacity: 1;">
      <strong><?php echo $this->session->flashdata('error'); ?> </strong>
      <button type="button" class="close cerrar_login" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php 
  }
  if($this->session->flashdata('success')){ ?>
    <div class="alert alert-success alert-dismissible fade show text-center msj_login" role="alert" style="opacity: 1;">
        <strong><?php echo $this->session->flashdata('success'); ?> </strong>
        <button type="button" class="close cerrar_login" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php 
  } ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Password recovery</h1>
                  </div>
                  <form class="user" action="<?php echo base_url('Login/new_password'); ?>" method="POST">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="correo" name="correo" aria-describedby="emailHelp" placeholder="Email">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block"> Send new password</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <h4><a href="<?php echo base_url('Login/index'); ?>">Sign in</a></h4>
                  </div>
                  <div class="text-center">
                    <a class="small ">Version <?php echo $version; ?></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url(); ?>js/sb-admin-2.min.js"></script>
  <script>
    $('#correo').focus();
  </script>
</body>
</html>
