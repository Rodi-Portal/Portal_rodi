<style>
    .modal-dialog {
      max-width: 90vw; /* Limitar el ancho máximo al 90% de la ventana */
      max-height: 90vh; /* Limitar la altura máxima al 90% de la ventana */
    }
    .modal-content {
      max-height: 90vh; /* Limitar la altura máxima al 90% de la ventana */
      overflow-y: auto; /* Permitir desplazamiento vertical */
    }
    .chart-area {
      height: auto;
      max-width: 100%; /* Asegurar que el canvas no exceda el ancho del modal */
    }
    #chartReclu {
      max-height: 90vh; /* Establecer un tamaño máximo para el canvas */
      max-width: 75%;
    }
    #chartReclu {
      max-height: 90vh; /* Establecer un tamaño máximo para el canvas */
      max-width: 75%;
    }

    #chartPastel {
      max-height: 90vh; /* Establecer un tamaño máximo para el canvas */
      max-width: 75%;
    }
  </style>
<!-- Begin Page Content -->
<div class="container-fluid" id="content-container">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <h1 id="msg_push"></h1>
    <!--a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</!--a-->
  </div>

  <?php 




	//TODO: revisar esta  parte 
  if($this->session->userdata('idrol') == 6 || $this->session->userdata('idrol') == 1){ 
    $today = date('Y-m-d');
    ?>
  <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><?php echo $titulo_dato1;
								 ?></div>
              <div class="h5 mb-0 font-weight-bold text-success"><?php echo $dato1; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-check-circle fa-2x text-success"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><?php echo $titulo_dato2; ?></div>
              <div class="h5 mb-0 font-weight-bold text-info"><?php echo $dato2; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-check-circle fa-2x text-primary"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"><?php echo $titulo_dato3; ?></div>
              <div class="h5 mb-0 font-weight-bold text-danger"><?php echo $dato3; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-times-circle fa-2x text-danger"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"><?php echo $titulo_dato4; ?></div>
              <div class="h5 mb-0 font-weight-bold text-warning"><?php echo $dato4; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user-tie fa-2x text-warning"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>






  <div class="row">
    <!-- Miniatura- General -->

    <div class="col-md-6 d-flex align-items-stretch">
  <div class="card shadow mb-4 w-100" id="miniChartCard">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Estadística General Area de Reclutamiento
        <?php echo date('Y'); ?></h6>
    </div>
    <div class="card-body" style="display: flex; align-items: center; justify-content: center;">
      <div class="chart-area" style="position: relative; height: 100%; width: 100%;">
        <canvas id="chartCandidatosMiniaturaGeneral" style="cursor: pointer; width: 100%;" data-toggle="modal"
          data-target="#graficaModalGeneral"></canvas>
      </div>
    </div>
  </div>
</div>
    <!-- Miniatura- reclutadores -->
    <div class="col-md-6 d-flex align-items-stretch">
      <div class="card shadow mb-4 w-100" id="miniChartCard">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Estadísticas de Reclutamiento <?php echo date('Y'); ?></h6>
        </div>
        <div class="card-body">
          <div class="chart-area">
            <canvas id="miniChartReclu" style="cursor: pointer; width: 100%;" data-toggle="modal"
              data-target="#chartModalReclu"></canvas>
          </div>
        </div>
      </div>
    </div>
    <!-- Miniatura para abrir el modal Pastel-->
    <div class="col-md-5 d-flex align-items-stretch">
      <div class="card shadow mb-4 w-100" id="miniChartCard">
        <div class="card-header py- d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Estadistica Medios de contacto <?php echo date('Y'); ?></h6>
        </div>
        <div class="card-body d-flex justify-content-center align-items-center">
          <!-- Miniatura de la gráfica -->
          <div>
            <canvas id="chartPastelMini" style=cursor: pointer;" data-toggle="modal"
              data-target="#graficaModalPastel"></canvas>
          </div>
        </div>
      </div>
    </div>

     <!-- Miniatura para abrir el modal ESE-->
     <div class="col-md-7 d-flex align-items-stretch">
  <div class="card shadow mb-4 w-100" id="miniChartCard">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">Estadística ESE & DT
        <?php echo date('Y'); ?></h6>
    </div>
    <div class="card-body" style="display: flex; align-items: center; justify-content: center;">
      <div class="chart-area" style="position: relative; height: 100%; width: 100%;">
            <canvas id="chartESEMini" style="cursor: pointer; width: 100%;" data-toggle="modal"
          data-target="#graficaModalESE"></canvas>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
<div class="modal fade" id="graficaModalGeneral" tabindex="-1" aria-labelledby="graficaModalLabelGeneral"
  aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="graficaModalLabelGeneral">Estadística General Detallada</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="filtroMesGeneral">Selecciona el Mes:</label>
          <select id="filtroMesGeneral" class="form-control">
            <option value="all">Todo el Año</option>
            <option value="1">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
          </select>
        </div>
        <div class="chart-area" >
          <canvas id="chartCandidatosModalGeneral" style="width: 80%;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal- reclutadores -->
<div class="modal fade" id="chartModalReclu" tabindex="-1" role="dialog" aria-labelledby="chartModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="chartModalLabel">Estadísticas <?php echo date('Y'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="col-md-3">
            <label for="fechaInicio">Fecha de Inicio:</label>
            <input type="date" id="fechaInicio" name="fechaInicio" class="form-control">
          </div>
          <div class="col-md-3">
            <label for="fechaFin">Fecha de Fin:</label>
            <input type="date" id="fechaFin" name="fechaFin" class="form-control"  value="<?php echo $today; ?>">
          </div>
          <div class="col-md-6 position-relative">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; right: 0;">
              <button class="btn btn-primary" onclick="cargarDatosReclutamiento()">Actualizar Gráficas</button>
            </div>
          </div>
        </div>
        <div class="row mt-4" >
          <div class="col-md-12">
            <div class="card shadow mb-4">
              <div class="card-body">
                <div class="chart-area">
                  <canvas id="chartReclu" style="width: 80%;"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


</div>

 <!-- Modal Grafica Pastel -->
<div class="modal fade" id="graficaModalPastel" tabindex="-1"  aria-labelledby="chartModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="graficaModalLabel">Estadística Medios de contacto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <div class="row justify-content-center">
          <div class="col-md-3">
            <label for="fechaInicio">Fecha de Inicio:</label>
            <input type="date" id="fechaInicioPastel" name="fechaInicio" class="form-control">
          </div>
          <div class="col-md-3">
            <label for="fechaFin">Fecha de Fin:</label>
            <input type="date" id="fechaFinPastel" name="fechaFin" class="form-control"  value="<?php echo $today; ?>">
          </div>
          <div class="col-md-6 text-center d-flex align-items-end">
            <button class="btn btn-primary w-100" onclick="cargarDatosPastel()">Actualizar Gráficas</button>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-md-12">
            <div class="card shadow mb-4">
              <div class="card-body">
                <div class="chart-area">
                  <canvas id="chartPastel"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


 <!-- Modal Grafica ESE -->
 <div class="modal fade" id="graficaModalESE" tabindex="-1"  aria-labelledby="chartModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="graficaModalLabelGeneral">Estadística ESE & DT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="filtroMesGeneral1">Selecciona el Mes:</label>
          <select id="filtroMesGeneral1" class="form-control">
            <option value="all">Todo el Año</option>
            <option value="1">Enero</option>
            <option value="2">Febrero</option>
            <option value="3">Marzo</option>
            <option value="4">Abril</option>
            <option value="5">Mayo</option>
            <option value="6">Junio</option>
            <option value="7">Julio</option>
            <option value="8">Agosto</option>
            <option value="9">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
            </select>
        </div>
        <div class="chart-area" >
          <canvas id="chartESE" style="width: 80%;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>



</div>
<?php 
  }
  if($this->session->userdata('idrol') == 2 || $this->session->userdata('idrol') == 9){ ?>
<div class="row">
  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Gráfica de ESE Finalizados durante <?php echo date('Y'); ?></h6>
      </div>
      <div class="card-body">
        <div class="chart-area">
          <canvas id="chartCandidatosPorAnalista"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-8 offset-4">
    <div class="card shadow mb-4 grafica-circular">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Gráfica de Estatus de ESE</h6>
      </div>
      <div class="card-body">
        <div class="chart-area">
          <canvas id="chartReclu"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
  }
// Verifica el rol del usuario y agrega los datos al conjunto de datos de la gráfica
if($this->session->userdata('idrol') == 1 || $this->session->userdata('idrol') == 6){ ?>
<script>
// Grafica  estadisticas   General --------------------------->

$(document).ready(function() {
  cargarGraficaGeneral();
  cargarGraficaESE();
  cargarDatosReclutamiento();
  cargarDatosPastel();
});
// Variables globales para almacenar datos
let datosCard1, datosCard2, datosCard3, datosCard4, datosCard5, datosCard6;

// Función para cargar la gráfica general
function cargarGraficaGeneral() {
  $.ajax({
    url: '<?php echo base_url('Estadistica/obtenerDatosPorMeses'); ?>',
    method: 'GET',
    dataType: 'json',
  }).then(function(response) {
    const datos = Object.values(response);

    datosCard1 = datos.map(mes => mes.requisiciones_en_proceso);
    datosCard2 = datos.map(mes => mes.requisiciones_finalizadas);
    datosCard3 = datos.map(mes => mes.requisiciones_canceladas);
    datosCard4 = datos.map(mes => mes.aspirantes_proceso);

    
    actualizarGraficaGeneral('#chartCandidatosMiniaturaGeneral', datosCard1, datosCard2, datosCard3, datosCard4,
      true);

    $('#chartCandidatosMiniaturaGeneral').on('click', function() {
      $('#graficaModalGeneral').modal('show');
      setTimeout(function() { // Asegura que el modal esté completamente visible antes de renderizar la gráfica
        actualizarGraficaGeneral('#chartCandidatosModalGeneral', datosCard1, datosCard2, datosCard3,
          datosCard4, false, $('#filtroMesGeneral').val());
      }, 500);
    });

    $('#filtroMesGeneral').on('change', function() {
      actualizarGraficaGeneral('#chartCandidatosModalGeneral', datosCard1, datosCard2, datosCard3, datosCard4,
        false, $(this).val());
    });
  }).catch(function(error) {
    console.error('Error en la solicitud AJAX:', error);
  });
}

// Función para actualizar la gráfica
function actualizarGraficaGeneral(canvasID, datosCard1, datosCard2, datosCard3, datosCard4, esMiniatura, filtroMes =
  'all') {
  const nombresMeses = esMiniatura ? ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov',
    'Dic'] : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
    'Noviembre', 'Diciembre'
  ];

  let labels, dataCard1Filtered, dataCard2Filtered, dataCard3Filtered, dataCard4Filtered;

  if (filtroMes === 'all') {
    labels = nombresMeses;
    dataCard1Filtered = datosCard1;
    dataCard2Filtered = datosCard2;
    dataCard3Filtered = datosCard3;
    dataCard4Filtered = datosCard4;
  } else {
    const mesIndex = parseInt(filtroMes) - 1;
    labels = [nombresMeses[mesIndex]];
    dataCard1Filtered = [datosCard1[mesIndex]];
    dataCard2Filtered = [datosCard2[mesIndex]];
    dataCard3Filtered = [datosCard3[mesIndex]];
    dataCard4Filtered = [datosCard4[mesIndex]];
  }

  const maxDataValue = Math.max(...dataCard1Filtered, ...dataCard2Filtered, ...dataCard3Filtered, ...dataCard4Filtered);
  const maxYValue = maxDataValue + 25;

  const data = {
    labels: labels,
    datasets: [{
      label: 'Requisiciones Canceladas',
      backgroundColor: 'rgba(255, 99, 132, 0.7)',
      borderColor: 'rgba(255, 99, 132)',
      borderWidth: 1,
      fill: true,
      data: dataCard3Filtered,
    }, {
      label: 'Requisiciones en Proceso',
      backgroundColor: 'rgba(92, 184, 92, 0.5)',
      borderColor: 'rgba(92, 184, 92, 1)',
      borderWidth: 1,
      fill: true,
      data: dataCard1Filtered,
    }, {
      label: 'Requisiciones Finalizadas',
      backgroundColor: 'rgba(54, 162, 235, 0.8)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 1,
      fill: true,
      data: dataCard2Filtered,
    }, {
      label: 'Aspirantes en proceso de Reclutamiento',
      backgroundColor: 'rgba(255, 206, 86, 0.6)',
      borderColor: 'rgba(255, 206, 86, 1)',
      borderWidth: 1,
      fill: true,
      data: dataCard4Filtered,
    }]
  };

  const config = {
    plugins: [ChartDataLabels],
    type: filtroMes === 'all' ? 'line' : 'bar',
    data: data,
    options: {
      plugins: {
        datalabels: {
          align: 'end',
          anchor: 'end',
          backgroundColor: (context) => context.dataset.backgroundColor,
          borderRadius: 4,
          color: 'black',
          font: {
            weight: 'bold'
          },
          padding: 3
        }
      },
      scales: {
        x: {
          grid: {
            borderColor: 'red'
          }
        },
        y: {
          min: 0,
          max: maxYValue,
          ticks: {
            stepSize: 50
          }
        }
      },
      maintainAspectRatio: false,
      responsive: true,
      elements: {
      line: {
        tension: 0.4, // Ajusta la tensión para redondear las líneas. Valores entre 0 y 1.
        borderCapStyle: 'round', // Redondea los extremos de las líneas.
        borderJoinStyle: 'round' // Redondea las uniones de las líneas.
      },
      point: {
        radius: 5, // Ajusta el radio de los puntos en la línea.
        borderColor: 'white', // Color del borde de los puntos.
        backgroundColor: (context) => context.dataset.borderColor, // Color de fondo de los puntos.
        borderWidth: 2, // Ancho del borde de los puntos.
        hoverRadius: 7 // Radio de los puntos al pasar el mouse.
      }
    }
    }
  };

  const canvas = document.querySelector(canvasID);
  if (canvas) {
    const ctx = canvas.getContext('2d');
    if (ctx) {
      // Destruir cualquier instancia previa del gráfico en el canvas
      if (canvas.chart) {
        canvas.chart.destroy();
      }
      canvas.chart = new Chart(ctx, config);
    } else {
      console.error(`No se pudo obtener el contexto 2D para el canvas con ID ${canvasID}`);
    }
  } else {
    console.error(`No se encontró ningún elemento canvas con el ID ${canvasID}`);
  }
}

//Fin Grafica  Estadisticas General ---------------------------->

// Grafica   Reclutadores ---------------------------->
function cargarDatosReclutamiento() {

  var fechaInicio = $('#fechaInicio').val();
  var fechaFin = $('#fechaFin').val();
  $.ajax({
    url: '<?php echo base_url('Estadistica/getEstadisticaReclutadoras'); ?>',
    method: 'GET',
    data: {
      fechaInicio: fechaInicio,
      fechaFin: fechaFin
    },
    success: function(res) {
      // Obtener los datos desde la respuesta
      console.log('Respuesta de la solicitud AJAX:', res);

      // Organizar los datos para el gráfico
      var reclutadoras = [];
      var requisicionesRecibidas = [];
      var requisicionesCerradas = [];
      var requisicionesCanceladas = [];
      var sla = [];

      // Iterar sobre cada objeto en la respuesta
      for (var i = 0; i < res.length; i++) {
        reclutadoras.push(res[i].nombre + ' ' + res[i].paterno);
        requisicionesCanceladas.push(parseInt(res[i].requisicionesCanceladas));
        requisicionesRecibidas.push(parseInt(res[i].requisicionesAsignadas));
        requisicionesCerradas.push(parseInt(res[i].requisicionesFinalizadas));
        sla.push(parseInt(res[i].sla));
      }

      miniChart.data.labels = reclutadoras;
      miniChart.data.datasets[0].data = requisicionesCanceladas;
      miniChart.data.datasets[1].data = requisicionesRecibidas;
      miniChart.data.datasets[2].data = requisicionesCerradas;
      miniChart.data.datasets[3].data = sla;

      // Actualizar el gráfico
      miniChart.update();
      // Actualizar los datos del gráfico con los datos obtenidos
      myChart.data.labels = reclutadoras;
      myChart.data.datasets[0].data = requisicionesCanceladas;
      myChart.data.datasets[1].data = requisicionesRecibidas;
      myChart.data.datasets[2].data = requisicionesCerradas;
      myChart.data.datasets[3].data = sla;

      // Actualizar el gráfico
      myChart.update();
    },
    error: function(xhr, status, error) {
      console.error('Error al cargar los datos:', error);
    }
  });
}

// Grafica  Mini reclutadores-->
var ctxMini = document.getElementById('miniChartReclu').getContext('2d');
var miniChart = new Chart(ctxMini, {
  type: 'bar',
  data: {
    labels: [],
    datasets: [{
        label: 'Requisiciones Canceladas',
        data: [],
        backgroundColor: 'rgba(255, 99, 132, 0.6)'
      },
      {
        label: 'Requisiciones Asignadas',
        data: [],
        backgroundColor: 'rgba(92, 184, 92, 0.6)',
      },
      {
        label: 'Requisiciones Finalizadas',
        data: [],
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
      },

      {
        label: 'SLA Promedio en dias ',
        data: [],
        backgroundColor: 'rgba(255, 206, 86, 0.6)',
      }
    ]
  },
  options: {
    title: {
      display: true,
      text: 'Datos de reclutamiento',
      fontSize: 16, // Tamaño del texto del título
      padding: 10, // Espacio alrededor del título
      fontColor: '#12619c',
    },
    legend: {
      position: 'right',
      labels: {
        padding: 10, // Espacio entre los elementos de la leyenda
        boxWidth: 10, // Ancho del cuadro de color en la leyenda
        fontSize: 10, // Tamaño del texto de la leyenda
      }
    },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
          fontSize: 10, // Tamaño del texto en el eje Y
        },
        stacked: true,
      }],
      xAxes: [{
        stacked: true,
        barThickness: 30, // Ancho de las barras
        barPercentage: 0.5, // Porcentaje del espacio ocupado por las barras en el eje X
        categoryPercentage: 0.5, // Porcentaje del espacio ocupado por cada conjunto de barras en el eje X
        ticks: {
          fontSize: 10, // Tamaño del texto en el eje X
        },
      }]
    }
  }
});

// Inicializar la gráfica del modal


// Función para abrir el modal y cargar la gráfica en tamaño completo
document.getElementById('miniChartCard').addEventListener('click', function() {

  // Si la gráfica ya está creada, destrúyela antes de volver a crearla
  // Crear la gráfica en el modal
  fullChart = new Chart(ctx, {
    type: 'bar', // o el tipo que prefieras
    data: miniChart.data, // Reutilizar los datos de la miniatura
    options: {
      responsive: false,
      maintainAspectRatio: false
    }
  });
});
// Fin Grafica  Mini reclutadores-->

// Grafica  Grande reclutadores-->
var ctx = document.getElementById("chartReclu");
var myChart = new Chart(ctx, {
  type: "bar",
  data: {
    labels: [],
    datasets: [{
        label: 'Requisiciones Canceladas',
        data: [],
        backgroundColor: 'rgba(255, 99, 132, 0.6)'
      },
      {
        label: 'Requisiciones Asignadas',
        data: [],
        backgroundColor: 'rgba(92, 184, 92, 0.6)',
      },
      {
        label: 'Requisiciones Finalizadas',
        data: [],
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
      },

      {
        label: 'SLA Promedio en dias ',
        data: [],
        backgroundColor: 'rgba(255, 206, 86, 0.6)',
      }
    ]
  },
  options: {
    responsive: true ,
    maintainAspectRatio: false,

    title: {
      display: true,
      text: 'Datos de reclutamiento',
      fontSize: 30,
      padding: 30,
      fontColor: '#12619c',
    },
    legend: {
      position: 'right',
      labels: {
        padding: 22,
        boxWidth: 20,
        fontSize: 15,
      }
    },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        },
        stacked: true
      }],
      xAxes: [{
        stacked: true,
        barThickness: 80, // Ancho de las barras
        barPercentage: 0.8, // Porcentaje del espacio ocupado por las barras en el eje X
        categoryPercentage: 0.8 // Porcentaje del espacio ocupado por cada conjunto de barras en el eje X
      }]
    }
  }
});

// Fin Grafica  Grande reclutadores-->
// Función para cargar datos en el gráfico de pastel
function cargarDatosPastel() {
  var fechaInicio = $('#fechaInicioPastel').val();
  var fechaFin = $('#fechaFinPastel').val();

  // Realizar la solicitud AJAX para obtener los datos
  $.ajax({
    url: '<?php echo base_url('Estadistica/contarMediosContacto'); ?>',
    method: 'GET',
    data: {
      fechaInicio: fechaInicio,
      fechaFin: fechaFin
    },
    success: function(res) {

      actualizarGraficaPastelModal(res);

    },
    error: function(xhr, status, error) {
      console.error('Error al cargar los datos:', error);
    }
  });
}

// Función para actualizar la gráfica extendida en el modal
function actualizarGraficaPastelModal(res) {

  if (res.labels && res.data) {
    pastelChart.data.labels = res.labels;
    pastelChart.data.datasets[0].data = res.data;

    pastelChartMini.data.labels = res.labels;
    pastelChartMini.data.datasets[0].data = res.data;
    // Generar una paleta de colores basada en el número de segmentos
    var numColores = res.labels.length;
    var paleta = generarPaleta(numColores);
    pastelChart.data.datasets[0].backgroundColor = paleta;

    pastelChart.update();
    pastelChartMini.data.datasets[0].backgroundColor = paleta;

    pastelChartMini.update();
  } else {
    console.error('Error: No se pudieron encontrar etiquetas o datos en la respuesta.');
  }
  // Aquí puedes utilizar los datos recibidos para actualizar la gráfica en el modal
}
// Eliminar la variable datosPastel y configurar los datos directamente en la función cargarDatosPastel

var pastelChartMini = new Chart(document.getElementById('chartPastelMini').getContext('2d'), {
  plugins: [ChartDataLabels],
  type: 'pie',
  data: {
    labels: [],
    datasets: [{
      data: []
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        display: true,
        position: 'top',
        labels: {
          padding: 10, // Reducir el espaciado entre las etiquetas de la leyenda
          boxWidth: 15, // Reducir el ancho del cuadro de la leyenda
          font: {
            size: 12 // Reducir el tamaño de la fuente de la leyenda
          }
        }
      },
      tooltip: {
        enabled: true,
        padding: 10, // Reducir el espaciado dentro del tooltip
        bodyFont: {
          size: 20 // Reducir el tamaño de la fuente dentro del tooltip
        }
      },

      datalabels: {
        formatter: (value, ctx) => {
          let sum = 0;
          let dataArr = ctx.chart.data.datasets[0].data;
          dataArr.map(data => {
            sum += data;
          });
          let percentage = ((value * 100) / sum).toFixed(2) + "%";
          return percentage;
        },
        color: '#fff',
        font: {
          size: 12 // Reducir el tamaño de la fuente de los valores en la gráfica
        }
      }
    },
    // Ajustes de tamaño de la gráfica

    // Ajustes de tamaño de la fuente
    elements: {
      arc: {
        borderWidth: 1, // Eliminar el borde del círculo
        borderColor: '#fff', // Color del borde del círculo
        borderAlign: 'inner', // Alinear el borde del círculo dentro del gráfico
        borderRadius: 0, // Radio del borde del círculo
      }
    }
  }
});

var pastelChart = new Chart(document.getElementById('chartPastel').getContext('2d'), {
  plugins: [ChartDataLabels],
  type: 'pie',
  data: {
    labels: [],
    datasets: [{
      data: []
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false, 
    plugins: {
      legend: {
        display: true,
        position: 'right',
        labels: {
          padding: 20,
          boxWidth: 50,
          font: {
            size: 20
          }
        }
      },
      tooltip: {
        enabled: true // Asegúrate de que las sugerencias emergentes estén habilitadas
      },
      datalabels: {
        formatter: (value, ctx) => {
          let sum = 0;
          let dataArr = ctx.chart.data.datasets[0].data;
          dataArr.map(data => {
            sum += data;
          });
          let percentage = ((value * 100) / sum).toFixed(2) + "%";
          return percentage;
        },
        font: {
            size: 15
          },
        color: '#fff',
      }
    }
  }
});
//  inicia  la carga de graficas  ese  y doping

// esta  funcion es para  carga  datos  falsos  a  las   graficas de ese y doping
function generarDatosFalsos() {
  var datosCard5 = [];
  var datosCard6 = [];
  
  // Generar datos falsos para cada mes del año (enero a diciembre)
  for (var i = 0; i < 12; i++) {
    datosCard5.push(Math.floor(Math.random() * 100)); // Valores aleatorios entre 0 y 100
    datosCard6.push(Math.floor(Math.random() * 100)); // Valores aleatorios entre 0 y 100
  }
  
  return { datosCard5, datosCard6 };
}

function cargarGraficaESE() {
  var datosGenerados = generarDatosFalsos();
  var datosCard5 = datosGenerados.datosCard5;
  var datosCard6 = datosGenerados.datosCard6;

  actualizarGraficaESE('#chartESEMini', datosCard5, datosCard6, true);

  $('#chartESEMini').on('click', function() {
    $('#graficaModalESE').modal('show');
    setTimeout(function() { // Asegura que el modal esté completamente visible antes de renderizar la gráfica
      actualizarGraficaESE('#chartESE', datosCard5, datosCard6, false, $('#filtroMesGeneral1').val());
    }, 500);
  });

  $('#filtroMesGeneral1').on('change', function() {
    actualizarGraficaESE('#chartESE', datosCard5, datosCard6, false, $(this).val());
  });
}

function actualizarGraficaESE(canvasID, datosCard5, datosCard6, responsive) {
  const ctx = document.querySelector(canvasID).getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      datasets: [
        {
          label: 'Requisiciones en Proceso',
          data: datosCard5,
          backgroundColor: 'rgba(255, 99, 132, 0.6)'
          
        },
        {
          label: 'Requisiciones Finalizadas',
          data: datosCard6,
          backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }
      ]
    },
    options: {
      responsive: responsive,
      maintainAspectRatio: responsive
    }
  });
}

function actualizarGraficaESE(canvasID, datosCard5, datosCard6, esMiniatura, filtroMes = 'all') {
  const nombresMeses = esMiniatura ? ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'] : 
  ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

  let labels, dataCard5Filtered, dataCard6Filtered;

  if (filtroMes === 'all') {
    labels = nombresMeses;
    dataCard5Filtered = datosCard5;
    dataCard6Filtered = datosCard6;
  } else {
    const mesIndex = parseInt(filtroMes) - 1;
    labels = [nombresMeses[mesIndex]];
    dataCard5Filtered = [datosCard5[mesIndex]];
    dataCard6Filtered = [datosCard6[mesIndex]];
  }

  const maxDataValue = Math.max(...dataCard5Filtered, ...dataCard6Filtered);
  const maxYValue = maxDataValue + 25;

  const data = {
    labels: labels,
    datasets: [{
      label: 'Socioeconómicos  ',
      
      borderColor: 'rgba(92, 184, 92, 1)',
      backgroundColor: 'rgba(92, 184, 92, 0.5)',
      borderWidth: 2,
    
      data: dataCard5Filtered,
    }, {
      label: 'Drug Test',
    
      borderColor: 'rgba(54, 162, 235, 1)',
      backgroundColor: 'rgba(54, 162, 235, 0.6)',
      borderWidth: 3,
     
      data: dataCard6Filtered,
    }]
  };

  const config = {
  plugins: [ChartDataLabels],
  type: filtroMes === 'all' ? 'line' : 'bar',
  data: data,
  options: {
    plugins: {
      datalabels: {
        align: 'end',
        anchor: 'end',
        backgroundColor: (context) => context.dataset.borderColor,
        borderRadius: 4,
        color: 'black',
        font: {
          weight: 'bold'
        },
        padding: 3
      }
    },
    scales: {
      x: {
        grid: {
          borderColor: 'red'
        }
      },
      y: {
        min: 0,
        max: maxYValue,
        ticks: {
          stepSize: 50
        }
      }
    },
    maintainAspectRatio: false,
    responsive: true,
    elements: {
      line: {
        tension: 0.4, // Ajusta la tensión para redondear las líneas. Valores entre 0 y 1.
        borderCapStyle: 'round', // Redondea los extremos de las líneas.
        borderJoinStyle: 'round' // Redondea las uniones de las líneas.
      },
      point: {
        radius: 5, // Ajusta el radio de los puntos en la línea.
        borderColor: 'white', // Color del borde de los puntos.
        backgroundColor: (context) => context.dataset.borderColor, // Color de fondo de los puntos.
        borderWidth: 2, // Ancho del borde de los puntos.
        hoverRadius: 7 // Radio de los puntos al pasar el mouse.
      }
    }
  }
};

  const canvas = document.querySelector(canvasID);
  if (canvas) {
    const ctx = canvas.getContext('2d');
    if (ctx) {
      // Destruir cualquier instancia previa del gráfico en el canvas
      if (canvas.chart) {
        canvas.chart.destroy();
      }
      canvas.chart = new Chart(ctx, config);
    } else {
      console.error(`No se pudo obtener el contexto 2D para el canvas con ID ${canvasID}`);
    }
  } else {
    console.error(`No se encontró ningún elemento canvas con el ID ${canvasID}`);
  }
}

// Llamar a la función para cargar la gráfica cuando sea necesario



function generarPaleta(numColores) {
  var paleta = [];
  for (var i = 0; i < numColores; i++) {
    var color = 'hsl(' + (i * (360 / numColores) % 360) + ', 70%, 50%, 0.4)';
    paleta.push(color);
  }
  return paleta;
}

</script>
<?php } ?>