var baseUrl = document.getElementById('base_url').value;
var pag = 1; // Global para control de pasos

function registrarCliente() {
  $("#password, #generarPass, #passLabel").show();
  $('#newModal').modal('show'); // <- MUY IMPORTANTE
  resetModal();
}

function resetModal() {
  // Reset al cerrar modal
  $("#newModal, #accesoModal").off("hidden.bs.modal").on("hidden.bs.modal", function() {
    $(this).find("input, select, textarea").val("");
    $(this).find("#msj_error").hide();
    $("#idSubcliente").val("");
  });

  // Mostrar paso inicial al abrir modal
  $('#newModal').off('shown.bs.modal').on('shown.bs.modal', function() {
    $("#titulo_paso").text('Información Sucursal');
    $("#btnContinuar span.text").text('Continuar');
    $("#btnRegresar, #paso2, #paso3").prop('disabled', false);
    pag = 1;
  });

  // Botón continuar
  $('#btnContinuar').off().on('click', function() {
    var formulario = document.getElementById('formPaso' + pag);
    var todoCorrecto = true;

    // Validar campos requeridos
    for (var i = 0; i < formulario.length; i++) {
      var campo = formulario[i];
      campo.classList.remove('is-invalid');

      if (['text', 'number', 'textarea', 'select-one'].includes(campo.type)) {
        if (campo.getAttribute("data-required") === 'required' && (!campo.value.trim() || campo.value == 0)) {
          campo.classList.add('is-invalid');
          Swal.fire({
            icon: 'error',
            title: 'Hubo un problema',
            html: 'El campo <b>' + campo.getAttribute("data-field") + '</b> no es válido',
            width: '50em',
            confirmButtonText: 'Cerrar'
          });
          todoCorrecto = false;
          break;
        }
      }
    }

    if (!todoCorrecto) return;

    // Transiciones entre pasos
    if (pag === 1) {
      $("#btnRegresar").prop('disabled', true);
      transicionPaso('formPaso1', 'formPaso2', 'Información de Contacto', 'barra1', '#paso2');
    } else if (pag === 2) {
      transicionPaso('formPaso2', 'formPaso3', 'Domicilio', 'barra2', '#paso3');
      $("#btnContinuar span.text").text('Finalizar');
      $("#btnRegresar").prop('disabled', false);
    } else if (pag === 3) {
      // Recolectar datos
      let formData = $('#formPaso1, #formPaso2, #formPaso3').serializeArray();
      $("#btnRegresar").prop('disabled', false);
      let datos = {};
      formData.forEach(item => {
        datos[item.name] = item.value.trim() === '' ? null : item.value;
      });

      datos['currentPage'] = $('#currentPage').val();

      $.ajax({
        url: baseUrl,
        type: 'post',
        data: datos,
        beforeSend: () => $('.loader').show(),
        success: function(res) {
          setTimeout(() => $('.loader').fadeOut(), 200);
          var data = JSON.parse(res);
          if (data.codigo === 1) {
            $("#newModal").modal('hide');
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: data.msg,
              showConfirmButton: true
            }).then(() => window.location.reload());
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Hubo un problema',
              html: data.msg,
              width: '50em',
              confirmButtonText: 'Cerrar'
            });
          }
        }
      });
    }

    if (pag < 3) pag++;
  });

  // Botón regresar
  $('#btnRegresar').off().on('click', function() {
    if (pag === 2) {
      transicionPaso('formPaso2', 'formPaso1', 'Información Sucursal', 'barra1', '#paso2', true);
      $("#btnContinuar span.text").text('Continuar');
    } else if (pag === 3) {
      transicionPaso('formPaso3', 'formPaso2', 'Información de Contacto', 'barra2', '#paso3', true);
      $("#btnContinuar span.text").text('Continuar');
    }
    if (pag > 1) pag--;
  });

  // Reset completo al cerrar
  $('#newModal').off('hidden.bs.modal').on('hidden.bs.modal', function() {
    $(this).find("input, select, textarea").val('');
    $("#titulo_paso").text('Información Sucursal');
    $("#btnRegresar, #paso2, #paso3").prop('disabled', true);
    $("#btnContinuar span.text").text('Continuar');
    $("#formPaso1").removeClass('hidden').addClass('block');
    $("#formPaso2, #formPaso3").addClass('hidden');
    $("#barra1, #barra2").removeClass('barra_espaciadora_on').addClass('barra_espaciadora_off');
    pag = 1;
  });
}

function transicionPaso(actualId, siguienteId, nuevoTitulo, barraId, pasoBtnSelector, esRegreso = false) {
  $('#' + actualId).removeClass().addClass('animate__animated animate__fadeOut');
  setTimeout(() => {
    $('#' + actualId).addClass('hidden');
    $('#' + siguienteId).removeClass().addClass('animate__animated animate__fadeInUp');
  }, 500);

  $('#titulo_paso').text(nuevoTitulo);
  if (esRegreso) {
    $(pasoBtnSelector).prop('disabled', true);
    $('#' + barraId).removeClass('barra_espaciadora_on').addClass('barra_espaciadora_off');
  } else {
    $(pasoBtnSelector).prop('disabled', false);
    $('#' + barraId).removeClass('barra_espaciadora_off').addClass('barra_espaciadora_on');
  }
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

// Llama a la función resetModal cuando sea necesario
