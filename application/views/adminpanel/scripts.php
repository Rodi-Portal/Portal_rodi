	<?php echo $modals; ?>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url() ?>js/sb-admin-2.min.js"></script>

  <!-- Page level custom scripts -->
  <!--script src="js/demo/chart-area-demo.js"></script>
	<script src="js/demo/chart-pie-demo.js"></script-->
	
	<!-- Bootstrap Select -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
  

	<!-- InputMask -->
	<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.js"></script>
	<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="<?php echo base_url(); ?>js/input-mask/jquery.inputmask.extensions.js"></script>

	<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>

	<!-- SweetAlert -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script> -->


  
  <script>
    
	  const url_psicometrias = '<?php echo base_url(); ?>_psicometria/';

    //* Cierre de sesion
    function finishSession(){
      let timerInterval;
      setTimeout(() => {
        Swal.fire({
          title: '¿Desea mantener su sesion?',
          showClass: {
            popup: 'animate__animated animate__fadeInDown'
          },
          hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
          },
          html: 'Su sesión finalizará en <strong></strong> segundos<br/><br/>',
          showDenyButton: true,
          confirmButtonText: 'Mantener sesión',
          denyButtonText: 'Salir de la plataforma',
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
		$(function () {
			$('[data-toggle="tooltip"]').tooltip({
        trigger: "hover"
      });
      if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
        $('.selectpicker').selectpicker('mobile');
      }

		})
		//Funciones de apoyo
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
    function changeOptionSocial(selector, clase){
      if(selector == 1){
        $(clase).val('')
      }
      else{
        $(clase).val('No aplica')
      }
    }
    function changeOptionFinanzas(selector, clase){
      if(selector == 1){
        $(clase).val('')
        $(clase+'_numerico').val(0)
      }
      else{
        $(clase).val('No aplica')
        $(clase+'_numerico').val(0)
      }
    }
		function fechaCompletaAFront(fecha) {
			var f = fecha.split(' ');
			var aux = f[0].split('-');
			var date = aux[2] + '/' + aux[1] + '/' + aux[0];
			return date;
		}
		function fechaSimpleAFront(fecha) {
			var aux = fecha.split('-');
			var f = aux[2] + '/' + aux[1] + '/' + aux[0];
			return f;
		}
		//Cierre de modals
		$('#perfilUsuarioModal').on('hidden.bs.modal', function(e) {
			$("#perfilUsuarioModal #msj_error").css('display', 'none');
		});
		$('#confirmarPasswordModal').on('hidden.bs.modal', function(e) {
			$("#confirmarPasswordModal #msj_error").css('display', 'none');
			$("#confirmarPasswordModal input").val('');
		});
		
		function confirmarPassword(){
			$('#perfilUsuarioModal').modal('hide');
			$('#confirmarPasswordModal').modal('show');
		}
		function checkPasswordActual(){
			var nombre = $('#usuario_nombre').val();
			var paterno = $('#usuario_paterno').val();
			var correo = $('#usuario_correo').val();
			var nuevo_password = $('#usuario_nuevo_password').val();
			var password = $('#password_actual').val();
			var key = $('#usuario_key').val();
			$.ajax({
				url: '<?php echo base_url('Usuario/checkPasswordActual'); ?>',
				method: "POST",
				data: {'password':password,'nombre':nombre,'paterno':paterno,'correo':correo,'nuevo_password':nuevo_password,'key':key},
				beforeSend: function(){
					$('.loader').css("display","block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var dato = JSON.parse(res);
					if(dato.codigo == 1){
						$('#confirmarPasswordModal').modal('hide');
						Swal.fire({
							position: 'center',
							icon: 'success',
							title: dato.msg,
							showConfirmButton: false,
							timer: 3500
						})
						setTimeout(function() {
							window.location.href = "<?php echo base_url(); ?>Login/logout";
						}, 3500);
					}
					else{
						$('#confirmarPasswordModal').modal('hide');
						Swal.fire({
							position: 'center',
							icon: 'error',
							title: dato.msg,
							showConfirmButton: false,
							timer: 3500
						})
					}
				}
			});
		}
		function confirmarRecuperarPassword(){
			$('#perfilUsuarioModal').modal('hide');
			$('#recuperarPasswordModal').modal('show');
		}
    //* Determina si el navegador donde se envia el formulario para descargar un archivo tiene o no internet para comunicarle al usuario
    function downloadFile(){
      if (navigator.onLine) {
        Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'El reporte PDF se esta creando y se descargará en breve',
          showConfirmButton: false,
          timer: 2500
        })
      }else {
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: 'No cuenta con internet para descargar el archivo, intente más tarde',
          showConfirmButton: false,
          timer: 2500
        })
        return false;
      }
    }
    function enviarNotificacion(){
      // $.ajax({
      //   url: '<?php //echo base_url('Notificacion/alertaNuevoCandidato'); ?>',
      //   method: 'POST',
      //   data: {
      //     'mensaje': $('#msgNotificacion').val()
      //   },
      //   success: function(res) {
          
      //   }
      // });
    }
    function getNotificaciones(){
      $.ajax({
        url: '<?php echo base_url('Notificacion/get_by_usuario'); ?>',
        method: 'POST',
        success: function(response) {
          let data = JSON.parse(response)
          if(data.contadorNotificaciones == 0){
            $('#contadorNotificaciones').css('display', 'none')
            $('#contenedorNotificaciones').html(data.notificaciones)
          }
          else{
            $('#contadorNotificaciones').css('display', 'initial')
            $('#contadorNotificaciones').text(data.contadorNotificaciones)
            $('#contenedorNotificaciones').html(data.notificaciones)
          }
        },
        error: function(error) {
            console.error('Error al marcar el mensaje como visto.');
        }
      });
    }
    $(document).ready(function(){
      //* Notificaciones
      getNotificaciones();

      setInterval(() => {
        getNotificaciones()
      }, 30 * 60 * 1000);
      //}, 20 * 1000);

      $('#iconoNotificaciones').click(function(){
        getNotificaciones()
      })
      $(document).on('mouseenter', '.notificacion', function() {
        let id = $(this).data('id');
        let visto = $(this).data('visto');
        if(visto == 0){
          $("#mensaje"+id).data("visto", 1);
          $("#icono"+id).removeClass('bg-warning');
          $("#icono"+id).addClass('bg-primary');
          $("#icono"+id).html('<i class="fas fa-check text-white"></i>');
          $("#mensaje"+id).css('background-color','transparent');
          $.ajax({
              async: false,
              url: '<?php echo base_url('Notificacion/marcar_visto'); ?>',
              method: 'POST',
              data: { 'id': id },
              success: function(response) {
                if(response == 0){
                  $('#contadorNotificaciones').css('display', 'none')
                  $('#contadorNotificaciones').text(response)
                }
                else{
                  $('#contadorNotificaciones').css('display', 'initial')
                  $('#contadorNotificaciones').text(response)
                }
              },
              error: function(error) {
                  console.error('Error al marcar el mensaje como visto.');
              }
          });
        }
      });
      //* Opciones en modal sociales2Modal 
      $('#opcion_familiar_penal').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_fam_penal').val('')
          $('.es_fam_penal').prop('disabled',false);
        }
        else{
          $('.es_fam_penal').val('No aplica')
          $('.es_fam_penal').prop('disabled',true);
        }
      });
      $('#opcion_persona_empresa').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_pers_emp').val('')
          $('.es_pers_emp').prop('disabled',false);
        }
        else{
          $('.es_pers_emp').val('No aplica')
          $('.es_pers_emp').prop('disabled',true);
        }
      });
      $('#opcion_familiar_policia').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_fam_policia').val('')
          $('.es_fam_policia').prop('disabled',false);
        }
        else{
          $('.es_fam_policia').val('No aplica')
          $('.es_fam_policia').prop('disabled',true);
        }
      });
      $('#opcion_sindicato').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_sindicato').val('')
          $('.es_sindicato').prop('disabled',false);
        }
        else{
          $('.es_sindicato').val('No aplica')
          $('.es_sindicato').prop('disabled',true);
        }
      });
      $('#opcion_otro_trabajo').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_otro_trabajo').val('')
          $('.es_otro_trabajo').prop('disabled',false);
        }
        else{
          $('.es_otro_trabajo').val('No aplica')
          $('.es_otro_trabajo').prop('disabled',true);
        }
      });
      //* Opciones en modal saludModal 
      $('#opcion_deporte').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_deporte').val('')
          $('.es_deporte').prop('disabled',false);
        }
        else{
          $('.es_deporte').val('No aplica')
          $('.es_deporte').prop('disabled',true);
        }
      });
      //* Opciones en modal finanzasModal
      $('#opcion_credito_bancos').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_credito_bancos').val('')
          $('.es_credito_bancos').prop('disabled',false);
        }
        else{
          $('.es_credito_bancos').val('No aplica');
          $('#credito_banco_saldo').val(0);
          $('.es_credito_bancos').prop('disabled',true);
        }
      });
      $('#opcion_credito_infonavit').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_credito_infovanit').val('')
          $('.es_credito_infovanit').prop('disabled',false);
        }
        else{
          $('.es_credito_infovanit').val('No aplica');
          $('#credito_infonavit_saldo').val(0);
          $('.es_credito_infovanit').prop('disabled',true);
        }
      });
      $('#opcion_credito_otro').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_credito_otro').val('')
          $('.es_credito_otro').prop('disabled',false);
        }
        else{
          $('.es_credito_otro').val('No aplica');
          $('#credito_otro_saldo').val(0);
          $('.es_credito_otro').prop('disabled',true);
        }
      });
      $('#opcion_propiedad_casa').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_opcion_casa').val('')
          $('.es_opcion_casa').prop('disabled',false);
        }
        else{
          $('.es_opcion_casa').val('No aplica')
          $('.es_opcion_casa').prop('disabled',true);
        }
      });
      $('#opcion_propiedad_automovil').change(function(){
        var opcion = $(this).val();
        if(opcion == 1){
          $('.es_opcion_auto').val('')
          $('.es_opcion_auto').prop('disabled',false);
        }
        else{
          $('.es_opcion_auto').val('No aplica')
          $('.es_opcion_auto').prop('disabled',true);
        }
      });
      
    })
	</script>
