<script>
  $(document).ready(function(){
    $("#manual-index-view").click(function(event) {
      event.preventDefault();
      $.ajax({
        url: 'manual_usuario',
        method: "GET",
        dataType: "html",
        success: function(response) {
          $("#content-container").html(response);
        },
        error: function() {
          alert("Error al cargar la página de inicio.");
        }
      });
    });
    $("#catalogo-clientes-view").click(function(event) {
      event.preventDefault();
      $.ajax({
        url: '<?php echo site_url("Cat_Cliente/index"); ?>',
        method: "GET",
        dataType: "html",
        success: function(response) {
          $("#content-container").html(response);
        },
        error: function() {
          alert("Error al cargar la página de inicio.");
        }
      });
    });
    $("#catalogo-subclientes-view").click(function(event) {
      event.preventDefault();
      $.ajax({
        url: '<?php echo site_url("Cat_Subclientes/index"); ?>',
        method: "GET",
        dataType: "html",
        success: function(response) {
          $("#content-container").html(response);
        },
        error: function() {
          alert("Error al cargar la página de inicio.");
        }
      });
    });
    $("#catalogo-puestos-view").click(function(event) {
      event.preventDefault();
      $.ajax({
        url: '<?php echo site_url("Cat_Puestos/index"); ?>',
        method: "GET",
        dataType: "html",
        success: function(response) {
          $("#content-container").html(response);
        },
        error: function() {
          alert("Error al cargar la página de inicio.");
        }
      });
    });
  })
</script>