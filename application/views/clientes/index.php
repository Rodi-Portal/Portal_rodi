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

          <button type="button" class="btn btn-primary btn-sm fs-4 py-3 px-4" onclick="loadPageInSection()">
            <i class="fas fa-plus"></i> <?php echo $translations['accion_nueva_requisicion']; ?>
          </button>

        </div>



        <hr>
        <div>



        </div>

        <hr>
        <?php if (! empty($procesosActuales)) {
                foreach ($procesosActuales as $proceso) {
                    $idioma = ($proceso->ingles == 1) ? 'ingles' : 'espanol';
                    $status = ($proceso->statusReq > 1) ?
                    '<label>' . $translations['proceso_status'] . ': <b>Iniciada</b></label><br>' :
                    '<label>' . $translations['proceso_status'] . ': <b>Pendiente</b></label><br>';

                    $observaciones = ($proceso->ingles == 1) ?
                    '<small>Observations: <b>' . $proceso->observaciones . '</b></small><br>' :
                    '<small>Observaciones: <b>' . $proceso->observaciones . '</b></small><br>';

                    $numeroVacantes = ($proceso->ingles == 1) ?
                    '<small>Vacantes: <b>' . $proceso->numero_vacantes . '</b></small><br>' :
                    '<small>Vacantes: <b>' . $proceso->numero_vacantes . '</b></small><br>';

                    $zona = ($proceso->ingles == 1) ?
                    '<small>Zona de trabajo: <b>' . $proceso->zona_trabajo . '</b></small><br>' :
                    '<small>Zona de trabajo: <b>' . $proceso->zona_trabajo . '</b></small><br>';

                    $experiencia = ($proceso->ingles == 1) ?
                    '<div class="experiencia" style="max-width: 400px;">' .
                    '<small>Experiencia: <b>' . $proceso->experiencia . '</b></small><br>' .
                    '</div>' :
                    '<div class="experiencia" style="max-width: 400px;">' .
                    '<small>Experiencia: <b>' . $proceso->experiencia . '</b></small><br>' .
                        '</div>';
                ?>
        <div class="card-proceso position-relative div-candidato" id="div-candidato<?php echo $proceso->idReq ?>">
          <div class="card-title" onclick="openDetails(<?php echo $proceso->idReq ?>)">
            <h4 id="vacanteMessage">Haz clic aquí para consultar el estado de tu vacante.</h4>
            <span class="badge text-bg-dark">Nombre de la vacante</span>
            <h4 class="d-inline align-middle"><b><?php echo $proceso->puesto ?></b></h4><br>
            <?php echo $status; ?>
            <?php echo $observaciones; ?>
            <?php echo $numeroVacantes; ?>
            <?php echo $zona; ?>
            <?php echo $experiencia; ?>
            <div>
              <span class="badge text-bg-info">Sueldo Mínimo: <?php echo $proceso->sueldo_minimo ?></span>
              <span class="badge text-bg-info">Sueldo Máximo: <?php echo $proceso->sueldo_maximo ?></span>
            </div>
            <p class="text-muted text-end">
              <?php echo $translations['proceso_fecha_registro'] . ': ' . fechaTexto($proceso->creacion, $idioma) ?>
            </p>
          </div>
        </div>
        <hr>
        <?php
            }
        } else {?>
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