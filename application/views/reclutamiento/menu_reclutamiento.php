<div class="reclutamiento-page">
  <nav class="empleados-header navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <!-- Menú con iconos siempre visibles -->
      <ul class="navbar-nav reclutamiento-navbar-nav">
        <li class="nav-item reclutamiento empleados-header-button-container">
          <a class="custom-link empleados-header-button empleados-header-button-active"
             href="<?php echo site_url('Reclutamiento/requisicion'); ?>">
            <i class="fas fa-desktop"></i>
            <?php echo t('rec_desk_tab', 'Mi escritorio'); ?>
          </a>
        </li>

        <li class="nav-item reclutamiento empleados-header-button-container">
          <a class="custom-link empleados-header-button"
             href="<?php echo site_url('Reclutamiento/control'); ?>">
            <i class="fas fa-spinner"></i>
            <?php echo t('rec_prog_tab', 'En progreso'); ?>
          </a>
        </li>

        <li class="nav-item reclutamiento empleados-header-button-container">
          <a class="custom-link empleados-header-button"
             href="<?php echo site_url('Reclutamiento/finalizados'); ?>">
            <i class="fas fa-check-circle"></i>
            <?php echo t('rec_done_tab', 'Finalizadas'); ?>
          </a>
        </li>

        <li class="nav-item reclutamiento empleados-header-button-container">
          <a class="custom-link empleados-header-button"
             href="<?php echo site_url('Reclutamiento/bolsa'); ?>">
            <i class="fas fa-users"></i>
            <?php echo t('rec_board_tab', 'Bolsa de trabajo'); ?>
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <div id="content">
    <div id="module-content">
      <p><?php echo t('rec_desk_select_module', 'Por favor selecciona un módulo del menú.'); ?></p>
    </div>
  </div>
</div>
<?php i18n_js(['rec_']); ?>

<!-- Bootstrap JS y Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>


<!-- Tu código CSS adicional -->
<!-- Estilos adicionales -->
<style>
.reclutamiento-page .empleados-header {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  padding: 0;
  margin: 0;
  background-color: #f0f0f0;
}

.reclutamiento-page .navbar-nav {
  display: flex;
  flex-direction: row;
  list-style: none;
  padding: 0;
  margin: 0;
  justify-content: space-around;
  width: 100%;
}

.reclutamiento-page .nav-item {
  margin: 0 20px;
}

.reclutamiento-page .empleados-header-button-container {
  text-align: center;
}

.reclutamiento-page .empleados-header-button {
  display: inline-block;
  margin: 0;
  padding: 12px;
  border: 2px solid #007bff;
  border-radius: 8px;
  background-color: #5783b1;
  color: white;
  cursor: pointer;
  font-size: 18px;
  font-weight: bold;
  text-align: center;
  transition: all 0.3s ease;
  outline: none;
  text-decoration: none;
  width: 150px;
  text-align: center;
}

.reclutamiento-page .empleados-header-button-active {
  background-color: #4098f6;
  border-bottom: 3px solid #ffffff;
  transform: translateY(-10px);
}

.reclutamiento-page .empleados-header-button:hover {
  background-color: #4a6ea9;
}

.reclutamiento-page .empleados-header-button:focus {
  box-shadow: 0 0 0 3px rgba(64, 152, 246, 0.3);
}

.reclutamiento-page #module-content {
  padding: 20px;
  text-align: center;
  margin-top: 20px;
}

/* Estilos Responsivos */
@media (max-width: 767px) {
  .reclutamiento-page .navbar-nav {
    flex-direction: row;
    justify-content: space-evenly;
    width: 100%;
  }

  .reclutamiento-page .nav-item {
    margin: 10px 0;
  }

  .reclutamiento-page .empleados-header-button {
    font-size: 12px;
    padding: 8px;
    width: 80px;
  }

  .reclutamiento-page .empleados-header-button-container {
    width: 25%;
  }
}
</style>
</div>

<script>
$(document).ready(function() {
  // Función para cargar contenido
  function loadContent(url) {
    $.get(url, function(data) {
      $('#module-content').html(data);
    }).fail(function() {
      $('#module-content').html('<p>Error al cargar el contenido. Por favor, inténtalo de nuevo.</p>');
    });
  }

  // Verificar si hay una URL guardada en localStorage
  var savedUrl = localStorage.getItem('lastMenuUrl');
  var defaultUrl = "<?php echo site_url('Reclutamiento/requisicion'); ?>";

  // Si hay una URL guardada, úsala, si no, usa la predeterminada
  var initialUrl = savedUrl ? savedUrl : defaultUrl;
  loadContent(initialUrl);

  // Marcar como activo el botón correspondiente
  $('.custom-link').each(function() {
    if ($(this).attr('href') === initialUrl) {
      $('.custom-link').removeClass('empleados-header-button-active');
      $(this).addClass('empleados-header-button-active');
    }
  });

  // Al hacer clic en una opción del menú
  $('.custom-link').on('click', function(e) {
    e.preventDefault(); // Evitar que el navegador siga el enlace
    var url = $(this).attr('href');

    // Guardar en localStorage
    localStorage.setItem('lastMenuUrl', url);

    // Cambiar el estilo activo
    $('.custom-link').removeClass('empleados-header-button-active');
    $(this).addClass('empleados-header-button-active');

    // Cargar el contenido
    loadContent(url);
  });

  // Alternar sidebar (opcional si tienes esa funcionalidad)
  $('#sidebarToggle').on('click', function() {
    $('#sidebar').toggleClass('hidden');
  });
});

</script>