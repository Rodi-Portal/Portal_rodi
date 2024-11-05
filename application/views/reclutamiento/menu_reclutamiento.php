<div class="reclutamiento-page">
  <nav class="empleados-header">
    <div class="container-fluid">
      <ul class="navbar-nav">
        <li class="nav-item reclutamiento empleados-header-button-container">
          <a class="custom-link empleados-header-button empleados-header-button-active"
            href="<?php echo site_url('Reclutamiento/requisicion'); ?>">My desktop</a>
        </li>
        <li class="nav-item reclutamiento empleados-header-button-container">
          <a class="custom-link empleados-header-button"
            href="<?php echo site_url('Reclutamiento/control'); ?>">In Progress</a>
        </li>
        <li class="nav-item reclutamiento empleados-header-button-container">
          <a class="custom-link empleados-header-button"
            href="<?php echo site_url('Reclutamiento/finalizados'); ?>">Completed</a>
        </li>
        <li class="nav-item reclutamiento empleados-header-button-container">
          <a class="custom-link empleados-header-button"
            href="<?php echo site_url('Reclutamiento/bolsa'); ?>">Applicants</a>
        </li>
      </ul>
    </div>
  </nav>

  <div id="content">
    <div id="module-content">
      <p>Por favor selecciona un módulo del menú.</p>
    </div>
  </div>

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
    /* Distribuir los elementos uniformemente */
    width: 100%;
    /* Asegúrate de que ocupa todo el ancho */
  }

  .reclutamiento-page .nav-item {
    margin: 0 20px;
    /* Espacio entre botones */
  }

  .reclutamiento-page .empleados-header-button-container {
    text-align: center;
  }

  .reclutamiento-page .empleados-header-button {
    display: inline-block;
    margin: 0;
    padding: 12px 24px;
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
    /* Evita subrayado */
  }

  .reclutamiento-page .empleados-header-button-active {
    background-color: #4098f6;
    border-bottom: 3px solid #ffffff;
    transform: translateY(-10px);
    /* Levanta el botón */
  }

  .reclutamiento-page .empleados-header-button:hover {
    background-color: #4a6ea9;
  }

  .reclutamiento-page .empleados-header-button:focus {
    box-shadow: 0 0 0 3px rgba(64, 152, 246, 0.3);
  }

  /* Estilos generales */
  .reclutamiento-page body {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    color: #2c3e50;
    margin: 50px;
    padding: 50px;
  }

  .reclutamiento-page h3 {
    text-align: center;
    margin-bottom: 20px;
  }

  .reclutamiento-page #module-content {
    padding: 20px;
    text-align: center;
    margin-top: 20px;
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

  // Cargar el contenido de la primera pestaña por defecto
  loadContent("<?php echo site_url('Reclutamiento/requisicion'); ?>");

  $('.custom-link').on('click', function(e) {
    e.preventDefault(); // Evitar el comportamiento predeterminado del enlace
    var url = $(this).attr('href'); // Obtener la URL del enlace

    // Cambiar la clase activa
    $('.custom-link').removeClass('empleados-header-button-active');
    $(this).addClass('empleados-header-button-active');

    loadContent(url); // Cargar el contenido de la pestaña seleccionada
  });
  $('#sidebarToggle').on('click', function() {
    $('#sidebar').toggleClass('hidden'); // Alternar la clase 'hidden'
  });
});
</script>