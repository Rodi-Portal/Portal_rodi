var baseUrl = document.getElementById('base_url').value;

function registrarCliente() {
  // Resto de tu código...

  // Llamada AJAX para obtener el token y cargar países, estados y ciudades
  var auth_token = "MUJkuDQTBwg6L_OLJghlvf5LDwdas3Tnm5EaF3Kny_7GIUXTah_7nbuE-K15HdxxTxo";

  // Agrega la lógica para cargar países, estados y ciudades aquí
  cargarPaisesEstadosCiudades(auth_token);
  resetModal();

  
}

function cargarPaisesEstadosCiudades(auth_token) {
  $.ajax({
  
    url: 'https://www.universal-tutorial.com/api/getaccesstoken',
    method: 'GET',
    headers: {
      "Accept": "application/json",
      "api-token": auth_token,
      "user-email": "rodi.control@gmail.com"
    },
    success: function(data) {
      if (data.auth_token) {
        var auth_token = data.auth_token;
        $.ajax({
          url: 'https://www.universal-tutorial.com/api/countries/',
          method: 'GET',
          headers: {
            "Authorization": "Bearer " + auth_token,
            "Accept": "application/json"
          },
          success: function(data) {
            var countries = data;
            var comboCountries = "<option value=''>Seleccionar</option>";
            countries.forEach(element => {
              comboCountries += '<option value="' + element['country_name'] + '">' + element[
                'country_name'] + '</option>';
            });

            $("#item-details-countryValue").html(comboCountries);

            // State list
            $("#item-details-countryValue").on("change", function() {
              var country = this.value;
              $.ajax({
                url: 'https://www.universal-tutorial.com/api/states/' + country,
                method: 'GET',
                headers: {
                  "Authorization": "Bearer " + auth_token,
                  "Accept": "application/json"
                },
                success: function(data) {
                  var states = data;
                  var comboStates = "<option value=''>Estados de: " + country + "</option>";
                  states.forEach(element => {
                    comboStates += '<option value="' + element['state_name'] + '">' + element[
                      'state_name'] + '</option>';
                  });
                  $("#item-details-stateValue").html(comboStates);
                  // City list
                  $("#item-details-stateValue").on("change", function() {
                    var state = this.value;
                    $.ajax({
                      url: 'https://www.universal-tutorial.com/api/cities/' + state,
                      method: 'GET',
                      headers: {
                        "Authorization": "Bearer " + auth_token,
                        "Accept": "application/json"
                      },
                      success: function(data) {
                        var cities = data;
                        var comboCities = "<option value=''>Ciudades de: " + state +
                          "</option>"; // Aquí se indica el estado seleccionado
                        cities.forEach(element => {
                          comboCities += '<option value="' + element['city_name'] +
                            '">' + element['city_name'] + '</option>';
                        });
                        $("#item-details-cityValue").html(comboCities);
                      },
                      error: function(e) {
                        console.log("Error al obtener ciudades: " + e);
                      }
                    });
                  });
                },
                error: function(e) {
                  console.log("Error al obtener estados: " + e);
                }
              });

            });
          },
          error: function(e) {
            console.log("Error al obtener países: " + e);
          }
        });
      }
    },
    error: function(e) {
      console.log("Error al obtener el token de acceso: " + e);
    }
  });
}

function cargarDatosDomicilioGeneral(datos) {
  var auth_token = "MUJkuDQTBwg6L_OLJghlvf5LDwdas3Tnm5EaF3Kny_7GIUXTah_7nbuE-K15HdxxTxo";

  // Obtener token de acceso
  $.ajax({
    url: 'https://www.universal-tutorial.com/api/getaccesstoken',
    method: 'GET',
    headers: {
      "Accept": "application/json",
      "api-token": auth_token,
      "user-email": "rodi.control@gmail.com"
    },
    success: function(data) {
      if (data.auth_token) {
        var auth_token = data.auth_token;

        // Cargar países
        $.ajax({
          url: 'https://www.universal-tutorial.com/api/countries/',
          method: 'GET',
          headers: {
            "Authorization": "Bearer " + auth_token,
            "Accept": "application/json"
          },
          success: function(data) {
            var countries = data;
            var comboCountries = "<option value='" + datos.pais + "'>" + datos.pais + "</option>";

            if (datos.pais === null || datos.pais === "") {
              comboCountries += "<option value='pendiente'>Pendiente</option>";
          }else{

            comboCountries = "<option value='" + datos.pais + "'>" + datos.pais + "</option>";}
            
            countries.forEach(element => {
              comboCountries += '<option value="' + element['country_name'] + '">' + element[
                'country_name'] + '</option>';
            });

            $("#item-details-countryValue").html(comboCountries);
            $("#item-details-countryValue").val(datos.pais);

            // Obtener estados
            $.ajax({
              url: 'https://www.universal-tutorial.com/api/states/' + datos.pais,
              method: 'GET',
              headers: {
                "Authorization": "Bearer " + auth_token,
                "Accept": "application/json"
              },
              success: function(data) {
                var states = data;
                var comboStates = "<option value='" + datos.estado + "'>" + datos.estado +
                "</option>";
                states.forEach(element => {
                  comboStates += '<option value="' + element['state_name'] + '">' + element[
                    'state_name'] + '</option>';
                });

                $("#item-details-stateValue").html(comboStates);
                $("#item-details-stateValue").val(datos.estado);

                // Obtener ciudades
                $.ajax({
                  url: 'https://www.universal-tutorial.com/api/cities/' + datos.estado,
                  method: 'GET',
                  headers: {
                    "Authorization": "Bearer " + auth_token,
                    "Accept": "application/json"
                  },
                  success: function(data) {
                    var cities = data;
                    var comboCities = "<option value='" + datos.ciudad + "'>" + datos.ciudad + "</option>";
                    cities.forEach(element => {
                      comboCities += '<option value="' + element['city_name'] + '">' +
                        element['city_name'] + '</option>';
                    });

                    $("#item-details-cityValue").html(comboCities);
                  },
                  error: function(e) {
                    console.log("Error al obtener ciudades: " + e);
                  }
                });

                // Evento onchange para el país
                $("#item-details-countryValue").on("change", function() {
                  var country = this.value;

                  // Obtener estados al cambiar el país
                  $.ajax({
                    url: 'https://www.universal-tutorial.com/api/states/' + country,
                    method: 'GET',
                    headers: {
                      "Authorization": "Bearer " + auth_token,
                      "Accept": "application/json"
                    },
                    success: function(data) {
                      var states = data;
                      var comboStates = "<option value=''>Estados de: " + country +
                        "</option>";
                      states.forEach(element => {
                        comboStates += '<option value="' + element['state_name'] +
                          '">' + element['state_name'] + '</option>';
                      });

                      $("#item-details-stateValue").html(comboStates);
                      $("#item-details-stateValue").val(
                      ""); // Limpiar el valor del estado al cambiar el país

                      // Obtener ciudades al cambiar el estado
                      $("#item-details-stateValue").on("change", function() {
                        var state = this.value;

                        $.ajax({
                          url: 'https://www.universal-tutorial.com/api/cities/' +
                            state,
                          method: 'GET',
                          headers: {
                            "Authorization": "Bearer " + auth_token,
                            "Accept": "application/json"
                          },
                          success: function(data) {
                            var cities = data;
                            var comboCities = "<option value=''>Ciudades de: " +
                              state + "</option>";
                            cities.forEach(element => {
                              comboCities += '<option value="' + element[
                                  'city_name'] + '">' + element['city_name'] +
                                '</option>';
                            });

                            $("#item-details-cityValue").html(comboCities);
                            $("#item-details-cityValue").val(
                            ""); // Limpiar el valor de la ciudad al cambiar el estado
                          },
                          error: function(e) {
                            console.log("Error al obtener ciudades: " + e);
                          }
                        });
                      });
                    },
                    error: function(e) {
                      console.log("Error al obtener estados: " + e);
                    }
                  });
                });
              },
              error: function(e) {
                console.log("Error al obtener estados: " + e);
              }
            });
          },
          error: function(e) {
            console.log("Error al obtener países: " + e);
          }
        });
      }
    },
    error: function(e) {
      console.log("Error al obtener el token de acceso: " + e);
    }
  });
}


function resetModal() {
  $("#newModal").on("hidden.bs.modal", function() {
    $("#newModal input,#newModal select").val("");
    $("#newModal #msj_error").css('display', 'none');
    $("#idSubcliente").val("");
    $(".modal-title").text("Agregar nuevo Cliente");
    $("#guardar").attr('value', 'nuevo');
  });

  $("#accesoModal").on("hidden.bs.modal", function() {
    $("#accesoModal input, #accesoModal select").val("");
    $("#accesoModal #msj_error").css('display', 'none');
    $("#idSubcliente").val("");
  });

  var pag = 1;

  $('#newModal').on('shown.bs.modal', function(e) {
    $("#newModal #titulo_paso").text('Informacíon Cliente');
    $("#newModal #btnContinuar span.text").text('Continuar');
    $("#newModal #btnRegresar, #newModal #paso2, #newModal #paso3").prop('disabled', true);
  });

  $('#newModal #btnContinuar').on('click', function() {
    var formulario_actual = document.getElementById('formPaso' + pag);
    var todoCorrecto = true;
    var formulario = formulario_actual;
    for (var i = 0; i < formulario.length; i++) {
      if (formulario[i].type == 'text' || formulario[i].type == 'number' || formulario[i].type == 'textarea' ||
        formulario[i].type == 'select-one') {
        if (formulario[i].getAttribute("data-required") == 'required') {
          if (formulario[i].value == null || formulario[i].value == '' || formulario[i].value == 0 || formulario[i]
            .value.length == 0 || /^\s*$/.test(formulario[i].value)) {
            Swal.fire({
              icon: 'error',
              title: 'Hubo un problema',
              html: 'El campo <b>' + formulario[i].getAttribute("data-field") + '</b> no es válido',
              width: '50em',
              confirmButtonText: 'Cerrar'
            })
            todoCorrecto = false;
          }
        }
      }
    }
    if (todoCorrecto == true) {
      if (pag == 1) {
        document.getElementById('formPaso1').className = "animate__animated animate__fadeOut ";
        setTimeout(function() {
          document.getElementById('formPaso1').className = "hidden";
          document.getElementById('formPaso2').className = "animate__animated animate__fadeInUp";
        }, 500)
        $("#newModal #titulo_paso").text('Informacíon de Contacto');
        $("#newModal #btnRegresar, #newModal #paso2").prop('disabled', false);
        document.getElementById('barra1').classList.remove('barra_espaciadora_off');
        document.getElementById('barra1').className += ' barra_espaciadora_on';
      }
      if (pag == 2) {
        document.getElementById('formPaso2').className = "animate__animated animate__fadeOut ";
        setTimeout(function() {
          document.getElementById('formPaso2').className = "hidden";
          document.getElementById('formPaso3').className = "animate__animated animate__fadeInUp";
        }, 500)
        $("#newModal #titulo_paso").text('Domicilio');
        $("#newModal #paso3").prop('disabled', false);
        document.getElementById('barra2').classList.remove('barra_espaciadora_off');
        document.getElementById('barra2').className += ' barra_espaciadora_on';
        $("#newModal #btnContinuar span.text").text('Finalizar');
      }
      if (pag == 3) {

        let formData = $('#formPaso1, #formPaso2, #formPaso3').serializeArray();

        // Construir objeto de datos
        let datos = {};

        // Obtener datos del primer formulario
        $('#formPaso1, #formPaso2, #formPaso3').find(':input').each(function() {
          if ($(this).val() === '') {
            // Si el campo está vacío, asignarle el valor null
            datos[$(this).attr('name')] = null;
          } else {
            // Si no está vacío, asignarle el valor del campo
            datos[$(this).attr('name')] = $(this).val();
          }
        });

        // Agregar currentPage si es necesario
        datos['currentPage'] = $('#currentPage').val();
        $.ajax({
          url: baseUrl,
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
              }).then(function() {
                // Recargar la página después de que el mensaje de éxito desaparezca
                window.location.reload();
              });

            } else {
              Swal.fire({
                icon: 'error',
                title: 'Hubo un problema',
                html: data.msg,
                width: '50em',
                confirmButtonText: 'Cerrar',
                timer: 3000
              })
            }
          }
        });
      }
      if (pag == 1 || pag == 2)
        pag++;
    }
  });

  $('#newModal #btnRegresar').on('click', function() {
    if (pag == 2) {
      document.getElementById('formPaso2').className = "animate__animated animate__fadeOut ";
      setTimeout(function() {
        document.getElementById('formPaso2').className = "hidden";
        document.getElementById('formPaso1').className = "animate__animated animate__fadeInUp";
      }, 500)
      $("#newModal #titulo_paso").text('Informacíon Cliente');
      $("#newModal #btnRegresar, #newModal #paso2").prop('disabled', true);
      document.getElementById('barra1').classList.remove('barra_espaciadora_on');
      document.getElementById('barra1').className += ' barra_espaciadora_off';
      $("#newModal #btnContinuar span.text").text('Continuar');
      pag--;
    }
    if (pag == 3) {
    
      document.getElementById('formPaso3').className = "animate__animated animate__fadeOut ";
      setTimeout(function() {
        document.getElementById('formPaso3').className = "hidden";
        document.getElementById('formPaso2').className = "animate__animated animate__fadeInUp";
      }, 500)
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
}


// Llama a la función resetModal cuando sea necesario
