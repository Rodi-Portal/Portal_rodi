$("#newModal").on("hidden.bs.modal", function() {
  
  $("#newModal input,#newModal select").val("");
  $("#newModal #msj_error").css('display', 'none');
  $("#idSubcliente").val("");
  $(".modal-title").text("Agregar subcliente");
  $("#guardar").attr('value', 'nuevo');
});
$("#accesoModal").on("hidden.bs.modal", function() {
  $("#accesoModal input, #accesoModal select").val("");
  $("#accesoModal #msj_error").css('display', 'none');
  $("#idSubcliente").val("");
});
var pag = 1;
$('#newModal').on('shown.bs.modal', function(e) {
  registrarCliente();
  $("#newModal #titulo_paso").text('Informacíon Cliente');
  $("#newModal #btnContinuar span.text").text('Continuar');
  $("#newModal #btnRegresar, #newModal #paso2, #newModal #paso3").prop('disabled', true);
});
$('#newModal #btnContinuar').on('click', function() {
  var formulario_actual = document.getElementById('formPaso'+pag);
  var todoCorrecto = true;
  var formulario = formulario_actual;
  for (var i = 0; i < formulario.length; i++) {
    if(formulario[i].type == 'text' || formulario[i].type == 'number' || formulario[i].type == 'textarea' || formulario[i].type == 'select-one') {
      if(formulario[i].getAttribute("data-required") == 'required'){
        if(formulario[i].value == null || formulario[i].value == '' || formulario[i].value == 0 || formulario[i].value.length == 0 || /^\s*$/.test(formulario[i].value)){
          Swal.fire({
            icon: 'error',
            title: 'Hubo un problema',
            html: 'El campo <b>'+formulario[i].getAttribute("data-field")+'</b> no es válido',
            width: '50em',
            confirmButtonText: 'Cerrar'
          })
          todoCorrecto = false;
        }
      }
    }
  }
  if (todoCorrecto == true) {
    if(pag == 1){
      document.getElementById('formPaso1').className = "animate__animated animate__fadeOut ";
      setTimeout(function(){
        document.getElementById('formPaso1').className = "hidden";
        document.getElementById('formPaso2').className = "animate__animated animate__fadeInUp";
      },500)
      $("#newModal #titulo_paso").text('Informacíon de Contacto');
      $("#newModal #btnRegresar, #newModal #paso2").prop('disabled', false);
      document.getElementById('barra1').classList.remove('barra_espaciadora_off');
      document.getElementById('barra1').className += ' barra_espaciadora_on';
    }
    if(pag == 2){
      document.getElementById('formPaso2').className = "animate__animated animate__fadeOut ";
      setTimeout(function(){
        document.getElementById('formPaso2').className = "hidden";
        document.getElementById('formPaso3').className = "animate__animated animate__fadeInUp";
      },500)
      $("#newModal #titulo_paso").text('Domicilio');
      $("#newModal #paso3").prop('disabled', false);
      document.getElementById('barra2').classList.remove('barra_espaciadora_off');
      document.getElementById('barra2').className += ' barra_espaciadora_on';
      $("#newModal #btnContinuar span.text").text('Finalizar');
    }
    if(pag == 3){
      
      let datos = $('#formPaso1').serialize();
      datos += '&' + $("#formPaso2").serialize();
      datos += '&' + $("#formPaso3").serialize();
      let currentPage =  $('#currentPage').val();
      $.ajax({
        url: 'http://localhost/rodi_portal/Cat_Subclientes/registrarSubcliente',
        type: 'post',
        data: datos,
        beforeSend: function() {
          $('.loader').css("display", "block");
        },
        success: function(res) {
          setTimeout(function() {
            $('.loader').fadeOut();
          }, 200);
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            $("#newModal").modal('hide');
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: data.msg,
              showConfirmButton: false,
              timer: 3000
            })
            if(currentPage == 'requisicion'){
              setTimeout(function(){
                location.reload()
              },3000)
            }
          }
          else{
            Swal.fire({
              icon: 'error',
              title: 'Hubo un problema',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Cerrar'
            })
          }
        }
      });
    }
    if(pag == 1 || pag == 2)
      pag++;
  }
});
$('#newModal #btnRegresar').on('click', function() {
  if(pag == 2){
    document.getElementById('formPaso2').className = "animate__animated animate__fadeOut ";
    setTimeout(function(){
      document.getElementById('formPaso2').className = "hidden";
      document.getElementById('formPaso1').className = "animate__animated animate__fadeInUp";
    },500)
    $("#newModal #titulo_paso").text('Informacíon Cliente');
    $("#newModal #btnRegresar, #newModal #paso2").prop('disabled', true);
    document.getElementById('barra1').classList.remove('barra_espaciadora_on');
    document.getElementById('barra1').className += ' barra_espaciadora_off';
    $("#newModal #btnContinuar span.text").text('Continuar');
    pag--;
  }
  if(pag == 3){
    registrarCliente();
    document.getElementById('formPaso3').className = "animate__animated animate__fadeOut ";
    setTimeout(function(){
      document.getElementById('formPaso3').className = "hidden";
      document.getElementById('formPaso2').className = "animate__animated animate__fadeInUp";
    },500)
    $("#newModal #titulo_paso").text('Informacíon de Contacto');
    $("#newModal #paso3").prop('disabled', true);
    document.getElementById('barra2').classList.remove('barra_espaciadora_on');
    document.getElementById('barra2').className += ' barra_espaciadora_off';
    $("#newModal #btnContinuar span.text").text('Continuar');
    pag--;
  }
});
 $('#newModal').on('hidden.bs.modal', function(e) {
  $("#newModalinput, #newModalselect, #newModaltextarea").val('');
  document.getElementById('formPaso1').className = "block";
  document.getElementById('formPaso2').className = "hidden";
  document.getElementById('formPaso3').className = "hidden";
  $("#newModal#titulo_paso").text('Informacíon Cliente');
  $("#newModal#btnRegresar, #newModal#paso2").prop('disabled', true);
  document.getElementById('barra1').classList.remove('barra_espaciadora_on');
  document.getElementById('barra1').className += ' barra_espaciadora_off';
  document.getElementById('barra2').classList.remove('barra_espaciadora_on');
  document.getElementById('barra2').className += ' barra_espaciadora_off';
  $("#newModal#btnContinuar span.text").text('Continuar');
  pag = 1;
});