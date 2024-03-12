
function cargarEstados() {
  $.ajax({
     url: baseUrl + 'Funciones/getEstados', 
      method: 'GET',
      dataType: 'json',
      success: function(response) {
          // Verificar si se obtuvieron los estados correctamente
          if (response.length > 0) {
              // Limpiar el select de estados
              $('#id_estado').empty();
              
              // Iterar sobre los estados y agregar opciones al select
              $.each(response, function(index, estado) {
                  $('#id_estado').append($('<option>', {
                      value: estado.id,
                      text: estado.nombre
                  }));
              });
          } else {
              // Si no se encontraron estados, mostrar un mensaje o manejar la situación de alguna otra forma
              console.log('No se encontraron estados.');
          }
      },
      error: function(xhr, status, error) {
          // Manejar el error de la solicitud AJAX, si es necesario
          console.error('Error al cargar los estados:', error);
      }
  });
}

// Llamar a la función para cargar los estados al cargar la página o en el momento adecuado
$(document).ready(function() {
  cargarEstados();
});