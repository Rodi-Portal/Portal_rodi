

async function sendMessage(phone, templateName) {
  try {
    const payload = {
      phone: phone,
      template: templateName
    };
    
    console.log('Enviando payload:', payload); // Añadir este log

    const response = await fetch('http://127.0.0.1:8000/api/send-message', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify(payload)
    });

    const data = await response.json();

    if (response.ok) {
      // Mostrar éxito con Swal
      await Swal.fire({
        icon: 'success',
        title: 'Mensaje Enviado',
        text: `Respuesta: ${JSON.stringify(data)}`,
      });
    } else {
      // Mostrar error con Swal
      await Swal.fire({
        icon: 'error',
        title: 'Error',
        text: `Error: ${data.message || 'No se pudo enviar el mensaje'}`,
      });
    }
  } catch (error) {
    // Mostrar error de red con Swal
    await Swal.fire({
      icon: 'error',
      title: 'Error de Red',
      text: `Error: ${error.message}`,
    });
  }
}

/* ejemplo  para  enviar  a la API
<script>
// Función para enviar mensaje a la API

// Ejemplo de uso
document.getElementById('testApiButton').addEventListener('click', function() {
    const phone = '523312285685'; // Reemplaza con un número de teléfono válido
    const templateName = 'hello_world'; // Nombre de la plantilla a usar
    sendMessage(phone, templateName);
});
</script> */