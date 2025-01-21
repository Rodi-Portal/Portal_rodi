<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Registro</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Para los iconos -->
  <link rel="stylesheet" href="<?php echo base_url('css/styles.css'); ?>"> <!-- Tu archivo CSS -->

  <!-- Incluir Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <!-- Incluir jQuery, Popper.js y Bootstrap JS para que los modales funcionen correctamente -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container">
    <h2>
      <img width="100px" src="<?php echo base_url(); ?>img/portal_icon.png" alt="Logo"> Acceso al DEMO TalentSafe
    </h2>
    <!-- Mostrar mensaje de éxito si existe -->
    <?php if ($this->session->flashdata('mensaje')): ?>
    <div class="alert alert-success"><?php echo $this->session->flashdata('mensaje'); ?></div>
    <?php endif; ?>

    <form id="registro-form" action="<?php echo base_url('login/enviarFormulario');?>" method="POST">
      <div class="form-group row">
        <div class="col">
          <label for="nombre">Nombre:</label>
          <input type="text" name="nombre" id="nombre" >
        </div>
        <div class="col">
          <label for="telefono">Teléfono:</label>
          <input type="text" name="telefono" id="telefono" >
        </div>
      </div>

      <div class="form-group row">
        <div class="col">
          <label for="correo">Correo Electrónico:</label>
          <input type="email" name="correo" id="correo" >
        </div>
        <div class="col">
          <label for="medio_llegada">¿Cómo llegaste aquí?</label>
          <select name="medio_llegada" id="medio_llegada" onchange="mostrarCampoOtro()">
            <option value="Google">Google</option>
            <option value="Redes Sociales">Redes Sociales</option>
            <option value="Recomendación">Recomendación</option>
            <option value="Otro">Otro</option>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <div class="col">
          <label for="contrasena">Contraseña:</label>
          <input type="password" name="contrasena" id="contrasena" >
        </div>

        <div class="col" id="campo_otro" style="display:none;">
          <label for="descripcion_otro">¿De dónde nos contactas?</label>
          <input type="text" name="descripcion_otro" id="descripcion_otro" placeholder="Escribe aquí..." />
        </div>
      </div>

      <button type="submit" class="link-margen">Enviar</button>

      <div class="already-registered">
        <p class="link-margen">¿Ya te has registrado antes y quieres acceder nuevamente?</p>
        <a class="link-margen" href="<?php echo base_url('login');?>">Ingresa aquí</a>
        <br>
      </div>
    </form>



    <h3>Conoce nuestros módulos</h3>
    <div class="modulos">
      <div class="modulo" data-toggle="modal" data-target="#modalReclutamiento">
        <i class="fas fa-briefcase"></i> <!-- Icono -->
        <p>Reclutamiento</p>
      </div>
      <div class="modulo" data-toggle="modal" data-target="#modalPreEmpleo">
        <i class="fas fa-user-check"></i> <!-- Icono -->
        <p>Pre-Empleo</p>
      </div>
      <div class="modulo" data-toggle="modal" data-target="#modalEmpleados">
        <i class="fas fa-users"></i> <!-- Icono -->
        <p>Empleados</p>
      </div>
      <div class="modulo" data-toggle="modal" data-target="#modalExempleados">
        <i class="fas fa-user-slash"></i> <!-- Icono -->
        <p>Exempleados</p>
      </div>
    </div>

    <!-- Modales -->

    <!-- Modal Reclutamiento -->
    <div class="modal fade" id="modalReclutamiento" tabindex="-1" role="dialog"
      aria-labelledby="modalReclutamientoLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalReclutamientoLabel">Reclutamiento</h5>

          </div>
          <div class="modal-body">
            <p><strong>Características:</strong></p>
            <ul>
              <li>Gestión de vacantes</li>
              <li>Publicación en diferentes portales de empleo</li>
              <li>Proceso de selección completo</li>
              <li>Integración con bases de datos de candidatos</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Pre-Empleo -->
    <div class="modal fade" id="modalPreEmpleo" tabindex="-1" role="dialog" aria-labelledby="modalPreEmpleoLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalPreEmpleoLabel">Pre-Empleo</h5>

          </div>
          <div class="modal-body">
            <p><strong>Características:</strong></p>
            <ul>
              <li>Evaluación de candidatos antes de la contratación</li>
              <li>Pruebas psicométricas y técnicas</li>
              <li>Documentación de pre-contratación</li>
              <li>Entrevistas y análisis de perfiles</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Empleados -->
    <div class="modal fade" id="modalEmpleados" tabindex="-1" role="dialog" aria-labelledby="modalEmpleadosLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEmpleadosLabel">Empleados</h5>

          </div>
          <div class="modal-body">
            <p><strong>Características:</strong></p>
            <ul>
              <li>Gestión completa del ciclo del empleado</li>
              <li>Historial de empleo y desempeño</li>
              <li>Integración con el sistema de nómina</li>
              <li>Control de ausencias y permisos</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Exempleados -->
    <div class="modal fade" id="modalExempleados" tabindex="-1" role="dialog" aria-labelledby="modalExempleadosLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalExempleadosLabel">Exempleados</h5>

          </div>
          <div class="modal-body">
            <p><strong>Características:</strong></p>
            <ul>
              <li>Control de salida de los empleados</li>
              <li>Documentación de finiquitos y cartas de recomendación</li>
              <li>Generación de reportes de ejemploados</li>
              <li>Acceso a historial laboral</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script>
  $(document).ready(function() {
    // Capturamos el evento submit del formulario
    $('#registro-form').submit(function(e) {
      e.preventDefault(); // Evitar el comportamiento por defecto (recargar la página)

      // Obtenemos los datos del formulario
      var formData = $(this).serialize(); // Serializa todos los campos del formulario

      // Hacemos la petición AJAX
      $.ajax({
        url: $(this).attr(
          'action'), // Dirección del formulario (o de la ruta que uses para manejar la petición)
        type: $(this).attr('method'), // Método del formulario (POST en este caso)
        data: formData, // Los datos del formulario
        success: function(response) {
          console.log("🚀 ~ $ ~ response:", response)

          // Aquí gestionamos la respuesta
          Swal.fire({
            icon: 'success',
            title: '¡Formulario enviado exitosamente!',
            text: 'Te hemos registrado correctamente.',
            confirmButtonText: '¡Genial!'
          });

          // Limpiar el formulario (si lo deseas)
          $('#registro-form')[0].reset();
        },
        error: function() {
          // Si ocurre algún error
          Swal.fire({
            icon: 'error',
            title: 'Error al enviar el formulario',
            text: 'Hubo un problema al intentar enviar el formulario. Inténtalo nuevamente.',
            confirmButtonText: 'Aceptar'
          });
        }
      });
    });
  });

  function mostrarCampoOtro() {
    // Obtener el valor seleccionado en el <select>
    var medioLlegada = document.getElementById('medio_llegada').value;

    // Mostrar el campo "Otro" solo si se selecciona esa opción
    if (medioLlegada === 'Otro') {
      document.getElementById('campo_otro').style.display = 'block'; // Mostrar campo "Otro"
    } else {
      document.getElementById('campo_otro').style.display = 'none'; // Ocultar campo "Otro"
    }
  }
  </script>
</body>

</html>