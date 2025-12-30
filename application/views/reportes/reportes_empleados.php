<body class="bg-light pt-1">
  <div class="container">
    <div class="card shadow">
      <div class="card-header bg-gradient-primary text-white">
        <h2 class="mb-0" style="color:white!important;">
          <?php echo t('reportes_empleados_title','Generar reporte de empleados'); ?>
        </h2>
      </div>

      <div class="card-body">
        <form method="post" action="<?php echo site_url('Reporte/exportar_excel') ?>">

          <!-- Sucursal -->
          <div class="form-group">
            <label><strong><?php echo t('reportes_empleados_sucursal','Selecciona una sucursal:'); ?></strong></label>
            <select name="sucursal" id="sucursal" class="form-control">
              <option value="">
                <?php echo t('reportes_empleados_all_sucursales','-- Todas las sucursales --'); ?>
              </option>
              <?php foreach ($sucursales as $s): ?>
              <option value="<?php echo $s->id ?>"><?php echo $s->nombre ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Campos -->
          <div class="form-group">
            <label><strong><?php echo t('reportes_empleados_campos','Selecciona la información a incluir:'); ?></strong></label>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="empleado_campos_extra">
              <label class="form-check-label">
                <?php echo t('reportes_empleados_campos_extra','Campos extra'); ?>
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="domicilios_empleados">
              <label class="form-check-label">
                <?php echo t('reportes_empleados_domicilio','Domicilio'); ?>
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="medical_info">
              <label class="form-check-label">
                <?php echo t('reportes_empleados_medica','Información médica'); ?>
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="laborales_empleado">
              <label class="form-check-label">
                <?php echo t('reportes_empleados_laborales','Datos laborales'); ?>
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="exams_empleados">
              <label class="form-check-label">
                <?php echo t('reportes_empleados_examenes','Exámenes'); ?>
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="documents_empleado">
              <label class="form-check-label">
                <?php echo t('reportes_empleados_documentos','Documentos'); ?>
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="cursos_empleados">
              <label class="form-check-label">
                <?php echo t('reportes_empleados_cursos','Cursos'); ?>
              </label>
            </div>
          </div>

          <!-- Fechas -->
          <div class="form-group">
            <label><strong><?php echo t('reportes_empleados_fecha_filtro','Filtrar por fecha de ingreso:'); ?></strong></label>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label><?php echo t('reportes_empleados_desde','Desde'); ?></label>
                <input type="date" name="fecha_inicio" class="form-control"
                  value="<?php echo date('Y-m-d', strtotime('-1 month')) ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label><?php echo t('reportes_empleados_hasta','Hasta'); ?></label>
                <input type="date" name="fecha_fin" class="form-control" value="<?php echo date('Y-m-d') ?>">
              </div>
            </div>
          </div>

          <!-- Puesto / Departamento -->
          <div class="form-group">
            <label><strong><?php echo t('reportes_empleados_puesto_depto','Filtrar por puesto y departamento:'); ?></strong></label>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label><?php echo t('reportes_empleados_puesto','Puesto'); ?></label>
                <select name="puesto" id="puesto" class="form-control">
                  <option value="">
                    <?php echo t('reportes_empleados_all_puestos','-- Todos los puestos --'); ?>
                  </option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label><?php echo t('reportes_empleados_departamento','Departamento'); ?></label>
                <select name="departamento" id="departamento" class="form-control">
                  <option value="">
                    <?php echo t('reportes_empleados_all_departamentos','-- Todos los departamentos --'); ?>
                  </option>
                </select>
              </div>
            </div>
          </div>

          <!-- Botón -->
          <button type="submit" class="btn btn-success">
            <?php echo t('reportes_empleados_btn_excel','Generar Excel'); ?>
          </button>

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
        data: {
          sucursal_id: sucursal_id
        },
        dataType: 'json',
        success: function(data) {
          // Limpiamos las opciones actuales
          $('#puesto').html(
            '<option value=""><?php echo t('reportes_select_puesto','-- Selecciona puesto --'); ?></option>'
            );
          $('#departamento').html(
            '<option value=""><?php echo t('reportes_select_departamento','-- Selecciona departamento --'); ?></option>'
            );


          // Rellenamos los puestos
          $.each(data.puestos, function(key, value) {
            $('#puesto').append('<option value="' + value.nombre + '">' + value.nombre + '</option>');
          });

          // Rellenamos los departamentos
          $.each(data.departamentos, function(key, value) {
            if (value && value.nombre) { // Verifica que no sea null ni vacío
              $('#departamento').append('<option value="' + value.nombre + '">' + value.nombre +
                '</option>');
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