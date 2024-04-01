

function nuevaRequisicion() {
  $('#nuevaRequisicionModal').modal('show');
  $('#currentPage').val('requisicion');
  cargarDatosCliente(); // También llama a la función cargarDatosCliente() al mostrar el modal
}
function cargarDatosCliente() {
  // Captura el evento de cambio en el campo de selección de cliente
  $('#id_cliente').change(function() {
    // Obtiene el ID del cliente seleccionado
    var clienteId = $(this).val();
    
    // Realiza una solicitud AJAX para obtener los datos del cliente seleccionado
    $.ajax({
      url: urlCargarDatosCliente,
      type: 'GET',
      data: { cliente_id: clienteId }, // Puedes enviar el ID del cliente como parámetro
      dataType: 'json',
      success: function(response) {
        // Verifica si se recibieron datos del cliente
        if (response.success) {
          var cliente = response.data[0]; // Datos del cliente recibidos

          // Llena los campos del formulario con los datos del cliente
          $('#nombre_comercial_req').val(cliente.nombre);
          $('#nombre_req').val(cliente.razon_social);
          $('#cp_req').val(cliente.cp);
          $('#pais_req').val(cliente.pais);
          $('#estado_req').val(cliente.estado);
          $('#ciudad_req').val(cliente.ciudad);
          $('#colonia_req').val(cliente.colonia);
          $('#calle_req').val(cliente.calle);
          $('#interior_req').val(cliente.interior);
          $('#exterior_req').val(cliente.exterior);
          $('#telefono_req').val(cliente.telefono_contacto);
          $('#contacto_req').val(cliente.nombre_contacto+" "+cliente.apellido_contacto);
          $('#rfc_req').val(cliente.rfc);
          $('#correo_req').val(cliente.correo_contacto);
          $('#regimen_req').val(cliente.regimen1);
          $('#forma_pago_req').val(cliente.forma_pago);
          $('#metodo_pago_req').val(cliente.metodo_pago);
          $('#uso_cfdi_req').val(cliente.uso_cfdi);

          // Llena los demás campos del formulario de manera similar
        } else {
          alert('Error al obtener los datos del cliente.');
        }
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  });
}
