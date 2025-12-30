<body class="bg-light pt-1">
  <div class="container">
    <div class="card shadow">
      <div class="card-header bg-gradient-primary text-white">
        <h2 class="mb-0" style="color:white!important;">
          <?php echo t('reportes_ex_title','Generar reporte de Exempleados'); ?>
        </h2>
      </div>

      <div class="card-body">
        <form method="post" action="<?php echo site_url('Reporte/exportar_excel_ex') ?>">

          <!-- Sucursal -->
          <div class="form-group">
            <label><strong><?php echo t('reportes_ex_sucursal','Selecciona una sucursal:'); ?></strong></label>
            <select name="sucursal" id="sucursal" class="form-control">
              <option value="">
                <?php echo t('reportes_ex_all_sucursales','-- Todas las sucursales --'); ?>
              </option>
              <?php foreach ($sucursales as $s): ?>
                <option value="<?php echo $s->id ?>"><?php echo $s->nombre ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Campos -->
          <div class="form-group">
            <label><strong><?php echo t('reportes_ex_campos','Selecciona la información a incluir:'); ?></strong></label>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="empleado_campos_extra" id="campos_extra">
              <label class="form-check-label" for="campos_extra">
                <?php echo t('reportes_ex_campos_extra','Campos extra'); ?>
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="domicilios_empleados" id="domicilio">
              <label class="form-check-label" for="domicilio">
                <?php echo t('reportes_ex_domicilio','Domicilio'); ?>
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="medical_info" id="medical_info">
              <label class="form-check-label" for="medical_info">
                <?php echo t('reportes_ex_medica','Información médica'); ?>
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="laborales_empleado" id="laborales">
              <label class="form-check-label" for="laborales">
                <?php echo t('reportes_ex_laborales','Datos laborales'); ?>
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="exams_empleados" id="exams">
              <label class="form-check-label" for="exams">
                <?php echo t('reportes_ex_examenes','Exámenes'); ?>
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="documents_empleado" id="docs">
              <label class="form-check-label" for="docs">
                <?php echo t('reportes_ex_documentos','Documentos'); ?>
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="campos[]" value="cursos_empleados" id="cursos">
              <label class="form-check-label" for="cursos">
                <?php echo t('reportes_ex_cursos','Cursos'); ?>
              </label>
            </div>
          </div>

          <!-- Fechas -->
          <div class="form-group">
            <label><strong><?php echo t('reportes_ex_fecha_filtro','Filtrar por fecha de ingreso:'); ?></strong></label>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label><?php echo t('reportes_ex_desde','Desde'); ?></label>
                <input type="date" name="fecha_inicio" class="form-control"
                  value="<?php echo date('Y-m-d', strtotime('-1 month')) ?>">
              </div>
              <div class="col-md-6 mb-3">
                <label><?php echo t('reportes_ex_hasta','Hasta'); ?></label>
                <input type="date" name="fecha_fin" class="form-control"
                  value="<?php echo date('Y-m-d') ?>">
              </div>
            </div>
          </div>

          <!-- Puesto / Departamento -->
          <div class="form-group">
            <label><strong><?php echo t('reportes_ex_puesto_depto','Filtrar por puesto y departamento:'); ?></strong></label>
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <label><?php echo t('reportes_ex_puesto','Puesto'); ?></label>
                <select name="puesto" id="puesto" class="form-control">
                  <option value="">
                    <?php echo t('reportes_ex_all_puestos','-- Todos los puestos --'); ?>
                  </option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label><?php echo t('reportes_ex_departamento','Departamento'); ?></label>
                <select name="departamento" id="departamento" class="form-control">
                  <option value="">
                    <?php echo t('reportes_ex_all_departamentos','-- Todos los departamentos --'); ?>
                  </option>
                </select>
              </div>
            </div>
          </div>

          <!-- Botón -->
          <button type="submit" class="btn btn-success">
            <?php echo t('reportes_ex_btn_excel','Generar Excel'); ?>
          </button>

        </form>
      </div>
    </div>
  </div>
</body>

<script>
$(document).ready(function() {
  $('#sucursal').change(function() {
    var sucursal_id = $(this).val();

    if (sucursal_id) {
      $.ajax({
        url: '<?php echo site_url('Reporte/getPuestosYDepartamentos'); ?>',
        type: 'POST',
        data: { sucursal_id: sucursal_id },
        dataType: 'json',
        success: function(data) {
          $('#puesto').html('<option value=""><?php echo t('reportes_ex_select_puesto','-- Selecciona puesto --'); ?></option>');
          $('#departamento').html('<option value=""><?php echo t('reportes_ex_select_departamento','-- Selecciona departamento --'); ?></option>');

          $.each(data.puestos, function(_, value) {
            $('#puesto').append('<option value="'+ value.nombre +'">'+ value.nombre +'</option>');
          });

          $.each(data.departamentos, function(_, value) {
            if (value && value.nombre) {
              $('#departamento').append('<option value="'+ value.nombre +'">'+ value.nombre +'</option>');
            }
          });
        }
      });
    } else {
      $('#puesto').html('<option value=""><?php echo t('reportes_ex_select_puesto','-- Selecciona puesto --'); ?></option>');
      $('#departamento').html('<option value=""><?php echo t('reportes_ex_select_departamento','-- Selecciona departamento --'); ?></option>');
    }
  });
});
</script>
