<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Client's Panel | RODI</title>
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
      background-color: #f2f3f5;
      font-family: Roboto;
    }
    .txt-color-principal{
      color: #0a39a6;
    }
    .contenedor{
      border-color: #0a39a6;
      border-radius: 1rem;
      width: 95%;
      margin: 0px auto;
    }
    .card {
      overflow: hidden;
      position: relative;
      border-radius: 0.5rem;
      background-color: #f2f2f2;
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

    .content {
      margin-top: 0.75rem;
      text-align: center;
    }

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
    #tabla_filter label input{
      width: 20rem !important;
    }
    #tabla_filter, #tabla_paginate{
      display: flex;
      justify-content: end;
    }
    #tabla thead{
      background-color: #0a39a6;
      color: white;
    }
    td{ vertical-align: middle !important; }
    .dataTables_empty{
      text-align: center;
    }
    .icono_datatable{
      font-size: 1rem !important;
      border-radius: 5px;
      padding: 0.3rem;
    }
    .icono_datatable:hover {
      text-decoration: none;
      opacity: 0.6;
    }
    .fondo-verde{ color: white; background: #3dd84f; } .fondo-rojo{ color: white; background: #c12036 } .fondo-amarillo{ color: white; background: #ffc107 } .fondo-azul-claro{ color: white; background: #45b2f5 } .fondo-morado{ color: white; background: #b558fc }
    .escrolable{ height: 28rem; overflow-x: hidden; overflow-y: auto; }
  </style>
</head>

<body>
  <!-- Se imprimen los modals -->
  <?php echo $modals; ?>
  <header>
    <nav class="navbar navbar-dark" style="background-color: #0a39a6;">
      <a class="navbar-brand" href="#">
        <img src="<?php echo base_url(); ?>img/rodi_icon.png" width="30" height="30" class="d-inline-block align-top" alt="RODI">
        <?php echo $this->session->userdata('nombre').' '.$this->session->userdata('paterno') ?>
      </a>
      <ul class="nav justify-content-end">
        <li class="nav-item">
          <a class="nav-link text-light active" href="<?php echo base_url(); ?>Login/logout"><i class="fas fa-sign-out-alt"></i> <?php echo $translations['cerrar_sesion']; ?></a>
        </li>
      </ul>
    </nav>
  </header>
  
	<div class="loader" style="display: none;"></div>

  <div class="contenedor mt-5 my-5">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h4 class="m-0 font-weight-bold text-center txt-color-principal"><?php echo $translations['titulo_tabla'] ?></h4>
      </div>
      <div class="card-body">
        <div class="table-responsive-sm">
          <table id="tabla" class="table table-hover" width="100%">
            <thead>
              <tr>
                <th width="25%" class="text-center"><?php echo $translations['col_candidato'] ?></th>
                <th width="15%" class="text-center"><?php echo $translations['col_proyecto'] ?></th>
                <th width="10%" class="text-center"><?php echo $translations['col_fecha_alta'] ?></th>
                <th width="10%" class="text-center"><?php echo $translations['col_estatus'] ?></th>
                <th width="20%" class="text-center"><?php echo $translations['col_examenes'] ?></th>
                <th width="10%" class="text-center"><?php echo $translations['col_bgv'] ?></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
	</div>
	
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <!-- Sweetalert 2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.12.7/dist/sweetalert2.js"></script>
  <script>
    function finishSession(){
      let timerInterval;
      setTimeout(() => {
        Swal.fire({
          title: 'Do you want to keep your session?',
          showClass: {
            popup: 'animate__animated animate__fadeInDown'
          },
          hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
          },
          html: 'Your session will end in <strong></strong> seconds<br/><br/>',
          showDenyButton: true,
          confirmButtonText: 'Keep me logged in',
          denyButtonText: 'Logout',
          timer: 30000,
          timerProgressBar: true,
          didOpen: () => {
            //Swal.showLoading(),
            timerInterval = setInterval(() => {
            Swal.getHtmlContainer().querySelector('strong')
              .textContent = (Swal.getTimerLeft() / 1000)
                .toFixed(0)
            }, 100)
          },
          willClose: () => {
            clearInterval(timerInterval)
          },
          allowOutsideClick: false
        }).then((result) => {
          if (result.isConfirmed) {
            finishSession();
          } else if (result.isDenied || result.dismiss === Swal.DismissReason.timer) {
            fetch('<?php echo base_url('Login/logout'); ?>')
              .then(response => {
                return location.reload()
              })
          } 
        })
      }, 7200000);
    }
    finishSession();
  </script>
  <script>
    let idioma = '<?php echo $this->session->userdata('ingles') ?>';
    let id_cliente = '<?php echo $this->session->userdata('idcliente') ?>';
    $(document).ready(function() {
      //$('#avisoModal').modal('show')
	    //var url = '<?php //echo base_url('Cliente/getCandidatosPanelSubcliente?id='); ?>' + id;
	    var url = '<?php echo base_url('Cliente/get_data'); ?>';
      var psico = '<?php echo base_url(); ?>_psicometria/';

      $('#tabla').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
          url: url,
          type: 'POST'
        },
        "columnDefs":[  
          {  
            "targets":[0],  
            "orderable":false,
          },  
        ],
        "language": {
          //"lengthMenu": "Mostrar _MENU_ registros por página",
          //"zeroRecords": "No se encontraron registros",
          //"info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          //"infoEmpty": "Sin registros disponibles",
          //"infoFiltered": "(Filtrado _MAX_ registros totales)",
          //"sSearch": "Buscar:",
          // "oPaginate": {
          //   "sLast": "Última página",
          //   "sFirst": "Primera",
          //   "sNext": "Siguiente",
          //   "sPrevious": "Anterior"
          // },
          // "sProcessing": "<div class='loader'></div>"
        }
      })
      // .on("processing.dt", function (e, settings, processing) {
      //   if (processing) {
      //     $('.loader').css('display','initial');
      //   }
      //   else{
      //     $('.loader').css('display','none');
      //   }
      // });
      //$("#tabla").DataTable().search("");
      $('#antidoping').change(function(){
        var opcion = $(this).val();
        var id_subcliente = '<?php echo $this->session->userdata('idsubcliente') ?>';
        var id_cliente = '<?php echo $this->session->userdata('idcliente') ?>';
        if(opcion == 1){
          $("#examen").prop('disabled',false);
          $.ajax({
            url: '<?php echo base_url('Doping/getPaqueteSubcliente'); ?>',
            method: 'POST',
            data: {
              'id_subcliente': id_subcliente,
              'id_cliente': id_cliente,
              'id_proyecto': 0
            },
            success: function(res) {
              if (res != "") {
                $('#examen').val(res);
                $("#examen").prop('disabled', false);
                $("#examen").addClass('obligado');
              } else {
                $('#examen').val('');
                $("#examen").prop('disabled', false);
                $("#examen").addClass('obligado');
              }
            }
          });
        }
        else{
          $("#examen").val('');
          $("#examen").prop('disabled',true);
        }
      })		
      $('#quitarModal').on('hidden.bs.modal', function(e) {
        $("#msg_accion").css('display', 'none');
        $(this)
          .find("input,textarea")
          .val('')
          .end();
      });
      $("#newModal").on("hidden.bs.modal", function() {
        $("#newModal input, #newModal select, #newModal textarea").val('');
        $("#newModal #msj_error").css('display', 'none');
        $("#examen_medico,#examen_psicometrico,#examen_registro").val(0);
        $('#detalles_previo').empty();
        $('#pais').val('México');
      })
      $('#perfilUsuarioModal').on('hidden.bs.modal', function(e) {
				$("#perfilUsuarioModal #msj_error").css('display', 'none');
			});
			$('#confirmarPasswordModal').on('hidden.bs.modal', function(e) {
				$("#confirmarPasswordModal #msj_error").css('display', 'none');
				$("#confirmarPasswordModal input").val('');
			});
    })
    function verMensajes(idCandidato){
      $.ajax({
        url: '<?php echo base_url('Avance/get'); ?>',
        type: 'post',
        data: {
          'id_candidato': idCandidato,
          'espanol': idioma
        },
        success: function(res) {
          //$("#div_avances").html(res);
          let data = JSON.parse(res)
          let archivo = '';
          $.each(data, function(index, valor) {
            if(valor.archivo != ''){
              archivo = '<a href="'+valor.archivo+'" class="btn btn-primary">'+valor.tituloArchivo+'</a>'
            }
            $('#div_avances').append('<div class="card mb-4"><div class="card-header">'+valor.fecha+'</div><div class="card-body"><p class="card-text"><b>'+valor.mensaje+'</b></p>'+archivo+'</div></div>')
          })
        }
      });
      $("#avancesModal").modal("show");
    }
  </script>
</body>
</html>
