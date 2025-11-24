<body class="bg-light  pt-1"">
  <div class="container">
    <div class="card shadow">
      <div class="card-header bg-gradient-primary text-white">
        <h2 class="mb-0" style="color: white !important;">Generar reporte de Exempleados</h2>
      </div>
      <div class="card-body">

        <form method="post" action="<?php echo site_url('Reporte/exportar_excel_ex') ?>">

          <!-- Sucursal -->
          <div class="form-group">
            <label for="sucursal"><strong>Selecciona una sucursal:</strong></label>
            <select name="sucursal" id="sucursal" class="form-control">
              <option value="">-- Todas las Sucursales--</option>
             <?php foreach ($sucursales as $s): ?>
  <option value="<?php echo $s->id ?>"><?php echo $s->nombre ?></option>
<?php endforeach; ?>
            </select>
          </div>

          <!-- Campos a incluir -->
          <div class="form-group">
            <label><strong>Selecciona la información a incluir:</strong></label>
              <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="empleado_campos_extra" id="extra">
              <label class="form-check-label" for="extra">Campos extra</label>
            </div>
              <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="domicilios_empleados" id="extra">
              <label class="form-check-label" for="extra">Domicilio</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="medical_info" id="medical_info">
              <label class="form-check-label" for="medical_info">Información médica</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="laborales_empleado"
                id="laborales">
              <label class="form-check-label" for="laborales">Datos laborales</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="exams_empleados" id="exams">
              <label class="form-check-label" for="exams">Exámenes</label>
            </div>
          
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="documents_empleado" id="docs">
              <label class="form-check-label" for="docs">Documentos</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="cursos_empleados" id="cursos">
              <label class="form-check-label" for="cursos">Cursos</label>
            </div>
          </div>

          <!-- Fechas -->
          <div class="form-group">
            <label><strong>Filtrar por fecha de ingreso:</strong></label>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="fecha_inicio">Desde</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control"
                  value="<?php echo date('Y-m-d', strtotime('-1 month')) ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label for="fecha_fin">Hasta</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control"
                  value="<?php echo date('Y-m-d') ?>">
              </div>
            </div>
          </div>

           <!-- Puesto y Departamento -->
          <div class="form-group">
            <label><strong>Filtrar por puesto y departamento:</strong></label>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label for="puesto">Puesto</label>
                <select name="puesto" id="puesto" class="form-control">
                  <option value="">-- Todos los puestos --</option>
                    <?php foreach ($puestos as $s): ?>
                      <option value="<?php echo $s->puesto ?>"><?php echo $s->puesto ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label for="departamento">Departamento</label>
                <select name="departamento" id="departamento" class="form-control">
                  <option value="">-- Todos los departamentos --</option>
                   <?php foreach ($puestos as $s): ?>
                    <option value="<?php echo $s->departamento ?>"><?php echo $s->departamento ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <!-- Botón -->
          <button type="submit" class="btn btn-success">Generar Excel</button>
        </form>

      </div>
    </div>
  </div>
</body>


<script>
  $(document).ready(function() {
    // Cuando se seleccione una sucursal
    $('#sucursal').change(function() {
      var sucursal_id = $(this).val();
      console.log("🚀 ~ $ ~ sucursal_id:", sucursal_id);

      // Verificamos si se seleccionó una sucursal
      if (sucursal_id) {
        // Hacemos una solicitud AJAX para obtener los puestos y departamentos
        $.ajax({
          url: '<?php echo site_url('Reporte/getPuestosYDepartamentos'); ?>', // URL del controlador
          type: 'POST',
          data: { sucursal_id: sucursal_id },
          dataType: 'json',
          success: function(data) {
            // Limpiamos las opciones actuales
            $('#puesto').html('<option value="">-- Selecciona puesto --</option>');
            $('#departamento').html('<option value="">-- Selecciona departamento --</option>');

            // Rellenamos los puestos
            $.each(data.puestos, function(key, value) {
              $('#puesto').append('<option value="'+ value.nombre +'">'+ value.nombre +'</option>');
            });

            // Rellenamos los departamentos
            $.each(data.departamentos, function(key, value) {
               if (value && value.nombre) { // Verifica que no sea null ni vacío
              $('#departamento').append('<option value="'+ value.nombre +'">'+ value.nombre +'</option>');
              }
            });
          }
        });
      } else {
        // Si no hay sucursal seleccionada, vaciamos los campos
        $('#puesto').html('<option value="">-- Selecciona puesto --</option>');
        $('#departamento').html('<option value="">-- Selecciona departamento --</option>');
      }
    });
  });
</script>