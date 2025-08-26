<!-- Se imprimen los modals -->
<?php echo $modals;
    /*echo $modalCliente;
echo '<pre>';
print_r($cliente);
echo '</pre>';*/

    /*echo '<pre>';
echo $procesosActuales[0]->url;
print_r($procesosActuales);
echo '</pre>';*/
    $CI = &get_instance();

    $cliente = $procesosActuales[0] ?? null;

?>
<div class="alert alert-info fs-4">


  En esta sección podrás dar de alta tus requisiciones haciendo clic en el botón <strong>"Agregar una Nueva
    Requisición"</strong>.
  Una vez creadas, se mostrarán listadas en esta misma área.

  <br>
  Puedes hacer clic sobre cualquier requisición para ver si hay algún avance o candidato asignado.
  Esta información aparecerá en el apartado derecho de la pantalla.

  <br>
  Por favor, asegúrate de completar toda la información solicitada al registrar una requisición.
  Estos datos solo se te solicitarán una vez y se cargarán automáticamente en futuras solicitudes.

  <br>
  ¡Gracias por tu colaboración!
</div>


<div class="loader" style="display: none;"></div>
<div id="panel-inicio">
  <div class="contenedor mt-5 my-5 hidden" id="panel-historial">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h4 class="m-0 font-weight-bold text-center txt-color-principal"><?php echo $translations['titulo_tabla'] ?>
        </h4>
      </div>
      <div class="card-body">
        <div class="table-responsive-sm mb-5">
          <table id="lista_candidatos" class="table table-hover" width="100%"></table>
        </div>
      </div>
    </div>
  </div>


  <div class="d-flex justify-content-center flex-column flex-md-row flex-lg-row mt-5 panel-inicio">
    <div class="card shadow div1 flex-fill">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
          <?php $totalRequisiciones = (! empty($procesosActuales)) ? count($procesosActuales) : 0?>
          <h3 class="text-wrap ">
            <?php echo $translations['proceso_titulo'] . ': <b>' . $totalRequisiciones . '</b>' ?></h3>

          <?php if ($tipo_bolsa == 1) {?>

          <button type="button" class="btn btn-primary fs-1 py-3 px-5 d-flex align-items-center gap-2"
            style="font-weight: 600;" onclick="window.open('<?php echo $link; ?>', '_blank')">
            <i class="fas fa-plus"></i>
            <?php echo $translations['accion_nueva_requisicion']; ?>
          </button>
          <?php } else {?>
          <button type="button" class="btn btn-primary fs-1 py-3 px-5 d-flex align-items-center gap-2"
            style="font-weight: 600;" onclick="loadPageInSection()">
            <i class="fas fa-plus"></i> <?php echo $translations['accion_nueva_requisicion']; ?>
          </button>
          <?php }?>
        </div>
        <hr>
        <div>
        </div>
        <hr>
        <?php if (! empty($procesosActuales)) {?>
        <?php foreach ($procesosActuales as $proceso): ?>
        <?php
    // Estatus como tag de color
        $isIniciada = ($proceso->statusReq > 1);
        $tagStatus  = $isIniciada
        ? '<span class="tag tag--iniciada">Iniciada</span>'
        : '<span class="tag tag--pendiente">Pendiente</span>';

        // Cuando SÍ hay intake
        if ($proceso->id_intake !== null) {
            $grid = '
          <div class="vacante-grid">
            <div class="kv-label">PLAN</div>
            <div class="kv-value"><b>' . $proceso->plan . '</b></div>

            <div class="kv-label">Método de comunicación</div>
            <div class="kv-value"><b>' . $proceso->metodo_comunicacion . '</b></div>

            <div class="kv-label">Actividad</div>
            <div class="kv-value"><b>' . $proceso->actividad . '</b></div>

            <div class="kv-label">Sexo de preferencia</div>
            <div class="kv-value"><b>' . $proceso->sexo_preferencia . '</b></div>

            <div class="kv-label">Funciones</div>
            <div class="kv-value"><b>' . $proceso->funciones . '</b></div>

            <div class="kv-label">Habilidades</div>
            <div class="kv-value"><b>' . $proceso->requisitos . '</b></div>

            <div class="kv-label">Recursos técnicos</div>
            <div class="kv-value"><b>' . $proceso->recursos . '</b></div>

            <div class="kv-label">Rango de edad</div>
            <div class="kv-value"><b>' . $proceso->rango_edad . '</b></div>
          </div>';
        }
        // Cuando NO hay intake (usa traducciones/idioma)
        else {
                $idioma = ($proceso->ingles == 1) ? 'ingles' : 'espanol';
                $grid   = '
	          <div class="vacante-grid">
	            <div class="kv-label">' . ($proceso->ingles ? 'Observations' : 'Observaciones') . '</div>
	            <div class="kv-value"><b>' . $proceso->observaciones . '</b></div>

	            <div class="kv-label">' . ($proceso->ingles ? 'Vacancies' : 'Vacantes') . '</div>
	            <div class="kv-value"><b>' . $proceso->numero_vacantes . '</b></div>

	            <div class="kv-label">' . ($proceso->ingles ? 'Work area' : 'Zona de trabajo') . '</div>
	            <div class="kv-value"><b>' . $proceso->zona_trabajo . '</b></div>

	            <div class="kv-label">' . ($proceso->ingles ? 'Experience' : 'Experiencia') . '</div>
	            <div class="kv-value"><b>' . $proceso->experiencia . '</b></div>
	          </div>';
            }
        ?>

        <div class="vacante-card div-candidato" id="div-candidato<?php echo $proceso->idReq?>">
          <div class="vacante-head" onclick="openDetails(<?php echo $proceso->idReq?>)">
            Haz clic aquí para consultar el estado de tu vacante.
          </div>

          <div class="vacante-title">
            <span class="vacante-nombre-label">Nombre de la vacante</span>
            <h4 class="vacante-puesto m-0"><b><?php echo $proceso->puesto?></b></h4>
          </div>

          <div class="vacante-status">
            Estatus: <?php echo $tagStatus?>
          </div>

          <?php echo $grid?>

          <?php if ($proceso->id_intake !== null): ?>
          <div class="mb-1">
            <span class="badge-soft">Fecha de Registro:
              <?php echo fechaTexto($proceso->fecha_solicitud, 'espanol')?></span>
            <span class="badge-soft">Fecha de inicio: <span
                class="muted"><?php echo fechaTexto($proceso->fecha_inicio, 'espanol')?></span></span>
          </div>
          <?php else: ?>
          <div class="mb-1">
            <span class="badge-soft">
              <?php echo $translations['proceso_fecha_registro'] . ': ' . fechaTexto($proceso->creacion, $idioma)?>
            </span>
            <?php if (! empty($proceso->sueldo_minimo) || ! empty($proceso->sueldo_maximo)): ?>
            <span class="badge-soft">Sueldo Mínimo: <?php echo $proceso->sueldo_minimo?></span>
            <span class="badge-soft">Sueldo Máximo: <?php echo $proceso->sueldo_maximo?></span>
            <?php endif; ?>
          </div>
          <?php endif; ?>
        </div>

        <hr>
        <?php endforeach;} else {?>
        <div class="card">
          <div class="card-body text-center">
            <?php echo $translations['proceso_sin_candidatos'] ?>
          </div>
        </div>
        <?php }?>
      </div>
    </div>
    <div class="card shadow div2 flex-fill">
      <div class="card-body">
        <button type="button" class="btn btn-secondary btn-sm d-block d-md-none" onclick="goBack()">
          <i class="fas fa-arrow-left"></i> Back
        </button>
        <div id="dataTableContainer">
          <table id="dataTable" class="table table-striped">
            <thead>
              <tr>
                <th class="d-none d-md-table-cell">ID</th>
                <th>Aspirante</th>
                <th class="d-none d-md-table-cell">Area de interes</th>
                <th>Acciones</th>
                <!-- Agrega más columnas según necesites -->
              </tr>
            </thead>
            <tbody>
              <tr id="mensajeFila">
                <td colspan="4" class="text-center text-uppercase">
                  <i class="fas fa-arrow-left"></i> SELECCIONA UNA REQUISICIÓN PARA VER LA INFORMACIÓN AQUÍ
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div id="seccion-bgv">
    <!-- El contenido de la vista se inyectará aquí -->

  </div>



  <section id="panel-agregar-candidato" class="mt-5 hidden">
    <p>hola</p>
  </section>

  <section id="panel-agregar-examenes" class="mt-5 hidden">

</div>
<!-- Scripts al final del cuerpo del documento -->

<!-- Custom JS -->