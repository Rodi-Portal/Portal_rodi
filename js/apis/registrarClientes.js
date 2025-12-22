var baseUrl = document.getElementById('base_url').value;
var pag = 1; // Global para control de pasos

// helpers de traducción (usa los tuyos si ya existen)
function _t(key, fallback) { return (window.t ? window.t(key, fallback) : (fallback ?? key)); }

function registrarCliente() {
  $("#password, #generarPass, #passLabel, #togglePass").show();
  $('#newModal').modal('show'); // <- MUY IMPORTANTE
  resetModal();
}

function resetModal() {
  // Reset al cerrar modal (solo limpia)
  $("#newModal, #accesoModal").off("hidden.bs.modal._resetAll").on("hidden.bs.modal._resetAll", function () {
    $(this).find("input, select, textarea").val("");
    $(this).find("#msj_error").hide();
    $("#idSubcliente").val("");
  });

  // Mostrar paso inicial al abrir modal
  $('#newModal').off('shown.bs.modal._initSteps').on('shown.bs.modal._initSteps', function () {
    $("#titulo_paso").text(_t('suc_step1_title', 'Información Sucursal'));
    $("#btnContinuar span.text").text(_t('suc_btn_continue', 'Continuar'));
    $("#btnRegresar, #paso2, #paso3").prop('disabled', false);
    pag = 1;
  });

  // Botón continuar
  $('#btnContinuar').off('click._next').on('click._next', function () {
    var formulario = document.getElementById('formPaso' + pag);
    var todoCorrecto = true;

    // Validar campos requeridos
    for (var i = 0; i < formulario.length; i++) {
      var campo = formulario[i];
      campo.classList.remove('is-invalid');

      if (['text', 'number', 'textarea', 'select-one', 'password', 'email'].includes(campo.type)) {
        if (campo.getAttribute("data-required") === 'required' && (!String(campo.value ?? '').trim() || campo.value == 0)) {
          campo.classList.add('is-invalid');

          // 👇 nombre del campo (puede venir vacío si el data-field quedó vacío)
          var fieldName = campo.getAttribute("data-field") || campo.name || _t('suc_field_unknown', 'este campo');

          Swal.fire({
            icon: 'error',
            title: _t('suc_sw_problem_title', 'Hubo un problema'),
            html: _t('suc_sw_invalid_field', 'El campo <b>{field}</b> no es válido')
              .replace('{field}', fieldName),
            width: '50em',
            confirmButtonText: _t('suc_btn_close', 'Cerrar')
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
      transicionPaso('formPaso1', 'formPaso2', _t('suc_step2_title', 'Información de Contacto'), 'barra1', '#paso2');
    } else if (pag === 2) {
      transicionPaso('formPaso2', 'formPaso3', _t('suc_step3_title', 'Domicilio'), 'barra2', '#paso3');
      $("#btnContinuar span.text").text(_t('suc_btn_finish', 'Finalizar'));
      $("#btnRegresar").prop('disabled', false);
    } else if (pag === 3) {

      // Recolectar datos
      let formData = $('#formPaso1, #formPaso2, #formPaso3').serializeArray();
      $("#btnRegresar").prop('disabled', false);

      let datos = {};
      formData.forEach(item => {
        datos[item.name] = String(item.value ?? '').trim() === '' ? null : String(item.value).trim();
      });

      datos['currentPage'] = $('#currentPage').val();

      $.ajax({
        url: baseUrl,
        type: 'post',
        data: datos,
        beforeSend: () => $('.loader').show(),
        success: function (res) {
          setTimeout(() => $('.loader').fadeOut(), 200);

          let data = res;
          if (typeof res === 'string') {
            try { data = JSON.parse(res); } catch (e) { data = null; }
          }

          if (data && data.codigo === 1) {
            $("#newModal").modal('hide');
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: data.msg || _t('suc_saved_ok', 'Guardado correctamente'),
              showConfirmButton: true,
              confirmButtonText: _t('suc_btn_ok', 'Aceptar')
            }).then(() => window.location.reload());
          } else {
            Swal.fire({
              icon: 'error',
              title: _t('suc_sw_problem_title', 'Hubo un problema'),
              html: (data && data.msg) ? data.msg : _t('suc_sw_unknown_error', 'Ocurrió un error.'),
              width: '50em',
              confirmButtonText: _t('suc_btn_close', 'Cerrar')
            });
          }
        },
        error: function () {
          setTimeout(() => $('.loader').fadeOut(), 200);
          Swal.fire({
            icon: 'error',
            title: _t('suc_sw_error_title', 'Error'),
            text: _t('suc_sw_comm_error', 'Error de comunicación con el servidor.'),
            confirmButtonText: _t('suc_btn_close', 'Cerrar')
          });
        }
      });
    }

    if (pag < 3) pag++;
  });

  // Botón regresar
  $('#btnRegresar').off('click._back').on('click._back', function () {
    if (pag === 2) {
      transicionPaso('formPaso2', 'formPaso1', _t('suc_step1_title', 'Información Sucursal'), 'barra1', '#paso2', true);
      $("#btnContinuar span.text").text(_t('suc_btn_continue', 'Continuar'));
    } else if (pag === 3) {
      transicionPaso('formPaso3', 'formPaso2', _t('suc_step2_title', 'Información de Contacto'), 'barra2', '#paso3', true);
      $("#btnContinuar span.text").text(_t('suc_btn_continue', 'Continuar'));
    }
    if (pag > 1) pag--;
  });

  // Reset completo al cerrar
  $('#newModal').off('hidden.bs.modal._hardReset').on('hidden.bs.modal._hardReset', function () {
    $(this).find("input, select, textarea").val('');
    $("#titulo_paso").text(_t('suc_step1_title', 'Información Sucursal'));
    $("#btnRegresar, #paso2, #paso3").prop('disabled', true);
    $("#btnContinuar span.text").text(_t('suc_btn_continue', 'Continuar'));
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

/* ====== TU CÓDIGO DE PAISES / ESTADOS / CIUDADES ======
   Nota: aquí solo te conviene traducir "Seleccionar", "Estados de:", "Ciudades de:" si quieres.
   Lo dejo igual para no romper nada.
*/

function cargarPaisesEstadosCiudades(auth_token) {
  $.ajax({
    url: 'https://www.universal-tutorial.com/api/getaccesstoken',
    method: 'GET',
    headers: {
      "Accept": "application/json",
      "api-token": auth_token,
      "user-email": "rodi.control@gmail.com"
    },
    success: function (data) {
      if (data.auth_token) {
        var auth_token = data.auth_token;
        $.ajax({
          url: 'https://www.universal-tutorial.com/api/countries/',
          method: 'GET',
          headers: {
            "Authorization": "Bearer " + auth_token,
            "Accept": "application/json"
          },
          success: function (data) {
            var countries = data;
            var comboCountries = "<option value=''>" + _t('suc_select_placeholder', 'Selecciona') + "</option>";
            countries.forEach(element => {
              comboCountries += '<option value="' + element['country_name'] + '">' + element['country_name'] + '</option>';
            });

            $("#item-details-countryValue").html(comboCountries);

            $("#item-details-countryValue").off("change._country").on("change._country", function () {
              var country = this.value;
              $.ajax({
                url: 'https://www.universal-tutorial.com/api/states/' + country,
                method: 'GET',
                headers: {
                  "Authorization": "Bearer " + auth_token,
                  "Accept": "application/json"
                },
                success: function (data) {
                  var states = data;
                  var comboStates = "<option value=''>" + _t('suc_states_of', 'Estados de: {country}').replace('{country}', country) + "</option>";
                  states.forEach(element => {
                    comboStates += '<option value="' + element['state_name'] + '">' + element['state_name'] + '</option>';
                  });
                  $("#item-details-stateValue").html(comboStates);

                  $("#item-details-stateValue").off("change._state").on("change._state", function () {
                    var state = this.value;
                    $.ajax({
                      url: 'https://www.universal-tutorial.com/api/cities/' + state,
                      method: 'GET',
                      headers: {
                        "Authorization": "Bearer " + auth_token,
                        "Accept": "application/json"
                      },
                      success: function (data) {
                        var cities = data;
                        var comboCities = "<option value=''>" + _t('suc_cities_of', 'Ciudades de: {state}').replace('{state}', state) + "</option>";
                        cities.forEach(element => {
                          comboCities += '<option value="' + element['city_name'] + '">' + element['city_name'] + '</option>';
                        });
                        $("#item-details-cityValue").html(comboCities);
                      },
                      error: function (e) {
                        console.log("Error al obtener ciudades: " + e);
                      }
                    });
                  });
                },
                error: function (e) {
                  console.log("Error al obtener estados: " + e);
                }
              });
            });
          },
          error: function (e) {
            console.log("Error al obtener países: " + e);
          }
        });
      }
    },
    error: function (e) {
      console.log("Error al obtener el token de acceso: " + e);
    }
  });
}

function cargarDatosDomicilioGeneral(datos) {
  var auth_token = "MUJkuDQTBwg6L_OLJghlvf5LDwdas3Tnm5EaF3Kny_7GIUXTah_7nbuE-K15HdxxTxo";

  $.ajax({
    url: 'https://www.universal-tutorial.com/api/getaccesstoken',
    method: 'GET',
    headers: {
      "Accept": "application/json",
      "api-token": auth_token,
      "user-email": "rodi.control@gmail.com"
    },
    success: function (data) {
      if (data.auth_token) {
        var auth_token = data.auth_token;

        $.ajax({
          url: 'https://www.universal-tutorial.com/api/countries/',
          method: 'GET',
          headers: {
            "Authorization": "Bearer " + auth_token,
            "Accept": "application/json"
          },
          success: function (data) {
            var countries = data;

            var comboCountries = "<option value='" + (datos.pais || "") + "'>" + (datos.pais || "") + "</option>";
            if (datos.pais === null || datos.pais === "") {
              comboCountries = "<option value='pendiente'>" + _t('suc_pending', 'Pendiente') + "</option>";
            }
            countries.forEach(element => {
              comboCountries += '<option value="' + element['country_name'] + '">' + element['country_name'] + '</option>';
            });

            $("#item-details-countryValue").html(comboCountries);
            $("#item-details-countryValue").val(datos.pais);

            $.ajax({
              url: 'https://www.universal-tutorial.com/api/states/' + datos.pais,
              method: 'GET',
              headers: {
                "Authorization": "Bearer " + auth_token,
                "Accept": "application/json"
              },
              success: function (data) {
                var states = data;
                var comboStates = "<option value='" + (datos.estado || "") + "'>" + (datos.estado || "") + "</option>";
                states.forEach(element => {
                  comboStates += '<option value="' + element['state_name'] + '">' + element['state_name'] + '</option>';
                });

                $("#item-details-stateValue").html(comboStates);
                $("#item-details-stateValue").val(datos.estado);

                $.ajax({
                  url: 'https://www.universal-tutorial.com/api/cities/' + datos.estado,
                  method: 'GET',
                  headers: {
                    "Authorization": "Bearer " + auth_token,
                    "Accept": "application/json"
                  },
                  success: function (data) {
                    var cities = data;
                    var comboCities = "<option value='" + (datos.ciudad || "") + "'>" + (datos.ciudad || "") + "</option>";
                    cities.forEach(element => {
                      comboCities += '<option value="' + element['city_name'] + '">' + element['city_name'] + '</option>';
                    });

                    $("#item-details-cityValue").html(comboCities);
                  },
                  error: function (e) {
                    console.log("Error al obtener ciudades: " + e);
                  }
                });

                $("#item-details-countryValue").off("change._country2").on("change._country2", function () {
                  var country = this.value;

                  $.ajax({
                    url: 'https://www.universal-tutorial.com/api/states/' + country,
                    method: 'GET',
                    headers: {
                      "Authorization": "Bearer " + auth_token,
                      "Accept": "application/json"
                    },
                    success: function (data) {
                      var states = data;
                      var comboStates = "<option value=''>" + _t('suc_states_of', 'Estados de: {country}').replace('{country}', country) + "</option>";
                      states.forEach(element => {
                        comboStates += '<option value="' + element['state_name'] + '">' + element['state_name'] + '</option>';
                      });

                      $("#item-details-stateValue").html(comboStates);
                      $("#item-details-stateValue").val("");

                      $("#item-details-stateValue").off("change._state2").on("change._state2", function () {
                        var state = this.value;

                        $.ajax({
                          url: 'https://www.universal-tutorial.com/api/cities/' + state,
                          method: 'GET',
                          headers: {
                            "Authorization": "Bearer " + auth_token,
                            "Accept": "application/json"
                          },
                          success: function (data) {
                            var cities = data;
                            var comboCities = "<option value=''>" + _t('suc_cities_of', 'Ciudades de: {state}').replace('{state}', state) + "</option>";
                            cities.forEach(element => {
                              comboCities += '<option value="' + element['city_name'] + '">' + element['city_name'] + '</option>';
                            });

                            $("#item-details-cityValue").html(comboCities);
                            $("#item-details-cityValue").val("");
                          },
                          error: function (e) {
                            console.log("Error al obtener ciudades: " + e);
                          }
                        });
                      });
                    },
                    error: function (e) {
                      console.log("Error al obtener estados: " + e);
                    }
                  });
                });
              },
              error: function (e) {
                console.log("Error al obtener estados: " + e);
              }
            });
          },
          error: function (e) {
            console.log("Error al obtener países: " + e);
          }
        });
      }
    },
    error: function (e) {
      console.log("Error al obtener el token de acceso: " + e);
    }
  });
}
