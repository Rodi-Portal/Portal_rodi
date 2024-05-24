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
    <div class="col-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Estadistica General <?php echo date('Y'); ?>
          </h6>
        </div>
        <div class="card-body">
          <div class="chart-area">
            <canvas id="chartCandidatosFinalizados"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>




  <div class="row">
    <!-- Miniatura- reclutadores -->
    <div class="col-md-6 d-flex align-items-stretch">
      <div class="card shadow mb-4 w-100" id="miniChartCard">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Miniatura de Estadísticas <?php echo date('Y'); ?></h6>
        </div>
        <div class="card-body">
          <div class="chart-area">
            <canvas id="miniChartReclu"></canvas>
          </div>
        </div>
      </div>
    </div>
    <!-- Miniatura para abrir el modal Pastel-->
    <div class="col-md-6 d-flex align-items-stretch">
      <div class="card shadow mb-4 w-100" id="miniChartCard">
        <div class="card-header py- d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Estadistica Medios de contacto <?php echo date('Y'); ?></h6>
        </div>
        <div class="card-body d-flex justify-content-center align-items-center">
          <!-- Miniatura de la gráfica -->
          <div >
            <canvas id="chartPastelMini" style="width: 100%; height: auto; cursor: pointer;" data-toggle="modal"
              data-target="#graficaModal"></canvas>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>


<!-- Modal- reclutadores -->
<div class="modal fade" id="chartModal" tabindex="-1" role="dialog" aria-labelledby="chartModalLabel"
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
            <input type="date" id="fechaFin" name="fechaFin" class="form-control">
          </div>
          <div class="col-md-6 position-relative">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; right: 0;">
              <button class="btn btn-primary" onclick="cargarDatosReclutamiento()">Actualizar Gráficas</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Estadísticas por reclutadora <?php echo date('Y'); ?>
                </h6>
              </div>
              <div class="card-body">
                <div class="chart-area">
                  <canvas id="chartReclu"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Miniatura para abrir el modal Pastel-->

</div>

<!-- Modal Grafica Pastel -->
<div class="modal fade" id="graficaModal" tabindex="-1" role="dialog" aria-labelledby="graficaModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="graficaModalLabel">Estadistica Medios de contacto</h5>

      </div>
      <div class="modal-body">

        <div class="row justify-content-center">
          <div class="col-md-3">
            <label for="fechaInicio">Fecha de Inicio:</label>
            <input type="date" id="fechaInicioPastel" name="fechaInicio" class="form-control">
          </div>
          <div class="col-md-3">
            <label for="fechaFin">Fecha de Fin:</label>
            <input type="date" id="fechaFinPastel" name="fechaFin" class="form-control">
          </div>
          <div class="col-md-6 position-relative">
            <div class="text-center" style="position: absolute; bottom: 0; left: 0; right: 0;">
              <button class="btn btn-primary" onclick="cargarDatosPastel()">Actualizar Gráficas</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card shadow mb-4">

              <div class="card-body">
                <!-- Colocar el gráfico en el centro del contenedor -->
                <div class="col-md-12" style="padding-top: 0;">
                  <canvas id="chartPastel" style="height: 400px;"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--ul>
					<li>ID: < ?php echo $this->session->userdata('id'); ?></li>
					<li>Nombre: < ?php echo $this->session->userdata('nombre'); ?></li>
					<li>Apellido Paterno: < ?php echo $this->session->userdata('paterno'); ?></li>
					<li>Rol: < ?php echo $this->session->userdata('rol'); ?></li>
					<li>ID Rol: < ?php echo $this->session->userdata('idrol'); ?></li>
					<li>Tipo: < ?php echo $this->session->userdata('tipo'); ?></li>
					<li>Login BD: < ?php echo $this->session->userdata('loginBD'); ?></li>
					<li>Logueado:  < ?php echo $this->session->userdata('logueado') ? 'Sí' : 'No'; ?></li>
					<li>ID Portal: < ?php echo $this->session->userdata('idPortal'); ?></li>
					<li>Nombre Portal: < ?php echo $this->session->userdata('nombrePortal'); ?></li>
				</ul -->
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


function cargarGraficaGeneral() {
  let datosCard1, datosCard2, datosCard3, datosCard4;

  // Realiza la solicitud AJAX para obtener todos los datos necesarios
  $.ajax({
    url: '<?php echo base_url('Estadistica/obtenerDatosPorMeses'); ?>',
    method: 'GET',
    dataType: 'json',
  }).then(function(response) {
    console.log("🚀 ~ cargarGrafica ~ response:", response)
    // Asigna los datos a las variables correspondientes
    datosCard1 = Object.values(response).map(mes => mes.requisiciones_en_proceso);
    datosCard2 = Object.values(response).map(mes => mes.requisiciones_finalizadas);
    datosCard3 = Object.values(response).map(mes => mes.requisiciones_canceladas);
    datosCard4 = Object.values(response).map(mes => mes.aspirantes_proceso);

    // Llama a la función para actualizar la gráfica
    actualizarGraficaGeneral('#chartCandidatosFinalizados'); // Para la gráfica original
    // Para la gráfica en el modal
  }).catch(function(error) {
    console.error('Error en la solicitud AJAX:', error);
  });

  // Función para actualizar la gráfica una vez que se hayan obtenido todos los datos
  function actualizarGraficaGeneral(canvasID) {
    // Verifica si todos los datos están disponibles
    if (datosCard1 !== undefined && datosCard2 !== undefined && datosCard3 !== undefined && datosCard4 !== undefined) {
      console.log("Tipo de datos de datosCard1:", typeof datosCard1);
      // Definir los meses y los nombres de los meses
      const meses = Array.from({
        length: 12
      }, (_, i) => i); // Array de números del 0 al 11 (para representar los meses del año)
      const nombresMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
        'Octubre', 'Noviembre', 'Diciembre'
      ];

      // Obtener el mes actual y el mes anterior
      const mesActual = new Date().getMonth();
      const mesAnterior = (mesActual === 0 ? 11 : mesActual - 1);

      // Obtener los datos de los meses actual y anterior para cada conjunto de datos
      const datosMesActual = [datosCard1[mesActual], datosCard2[mesActual], datosCard3[mesActual], datosCard4[
        mesActual]];
      const datosMesAnterior = [datosCard1[mesAnterior], datosCard2[mesAnterior], datosCard3[mesAnterior], datosCard4[
        mesAnterior
      ]];

      // Rellenar los datos faltantes con ceros para que cada conjunto de datos tenga un valor para cada mes
      const datosCard1Rellenados = datosCard1.map((valor, indice) => (indice === mesActual || indice === mesAnterior) ?
        valor : 0);
      const datosCard2Rellenados = datosCard2.map((valor, indice) => (indice === mesActual || indice === mesAnterior) ?
        valor : 0);
      const datosCard3Rellenados = datosCard3.map((valor, indice) => (indice === mesActual || indice === mesAnterior) ?
        valor : 0);
      const datosCard4Rellenados = datosCard4.map((valor, indice) => (indice === mesActual || indice === mesAnterior) ?
        valor : 0);

      // Definir los datos de la gráfica con los datos rellenados
      const data = {
        plugins: [ChartDataLabels],
        labels: nombresMeses,
        datasets: [{
            label: 'Requisiciones Canceladas',
            backgroundColor: 'rgba(255, 99, 132, 0.7)', // Rojo para el fondo
            borderColor: 'rgba(255, 99, 132)', // Color del borde
            borderWidth: 1, // Ancho del borde
            pointBackgroundColor: 'rgba(255, 99, 132, 1)', // Punto del gráfico
            pointRadius: 5,
            fill: true,
            data: datosCard3Rellenados,
            datalabels: {
              align: 'end',
              anchor: 'end',
              backgroundColor: function(context) {
                return context.dataset.backgroundColor;
              },
              borderRadius: 4,
              color: 'black',
              font: {
                weight: 'bold'
              },
              padding: 6
            }
          },
          {
            label: 'Requisiciones en Proceso',
            backgroundColor: 'rgba(92, 184, 92, 0.5)', // Verde success para el fondo
            borderColor: 'rgba(92, 184, 92, 1)', // Color del borde
            borderWidth: 1, // Ancho del borde
            pointBackgroundColor: 'rgba(92, 184, 92, 1)', // Punto del gráfico
            pointRadius: 5,
            fill: true,
            data: datosCard1Rellenados,
            datalabels: {
              align: 'end',
              anchor: 'end',
              backgroundColor: function(context) {
                return context.dataset.backgroundColor;
              },
              borderRadius: 4,
              color: 'black',
              font: {
                weight: 'bold'
              },
              padding: 6
            }
          },
          {
            label: 'Requisiciones Finalizadas',
            backgroundColor: 'rgba(54, 162, 235, 0.8)', // Color de fondo
            borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
            borderWidth: 1, // Ancho del borde
            pointBackgroundColor: 'rgba(54, 162, 235, 1)', // Punto del gráfico
            pointRadius: 5,
            fill: true,
            data: datosCard2Rellenados,
            datalabels: {
              align: 'end',
              anchor: 'end',
              backgroundColor: function(context) {
                return context.dataset.backgroundColor;
              },
              borderRadius: 4,
              color: 'black',
              font: {
                weight: 'bold'
              },
              padding: 6
            }
          },
          {
            label: 'Aspirantes en proceso de Reclutamiento',
            backgroundColor: 'rgba(255, 206, 86, 0.6)', // Amarillo para el fondo
            borderColor: 'rgba(255, 206, 86, 1)', // Color del borde
            borderWidth: 1, // Ancho del borde
            pointBackgroundColor: 'rgba(255, 206, 86, 1)', // Punto del gráfico
            pointRadius: 5,
            fill: true,
            data: datosCard4Rellenados,
            datalabels: {
              align: 'end',
              anchor: 'end',
              backgroundColor: function(context) {
                return context.dataset.backgroundColor;
              },
              borderRadius: 4,
              color: 'black',
              font: {
                weight: 'bold'
              },
              padding: 6
            }
          }
        ]
      };

      // Configurar la gráfica
      const config = {
        plugins: [ChartDataLabels],

        type: 'line',
        data: data,
        options: {
          plugins: {
            datalabels: {
              align: 'start',
              offset: 4,
              color: 'black',
              font: {
                weight: 'bold'
              }
            }
          },
          scales: {
            xAxes: [{
              grid: {
                borderColor: 'red'
              }
            }],
            yAxes: [{
              ticks: {
                min: 1, // Establece el valor mínimo en el eje y
                max: 1000, // Establece el valor máximo en el eje y
                stepSize: 10 // Define el tamaño del paso entre cada punto de comparación
              }
            }]
          },
          maintainAspectRatio: false,

          elements: {
            line: {
              tension: 0.4, // Ajusta la tensión de la curva
              borderCapStyle: 'round' // Configura los extremos de la línea como redondos
            }
          }
        }
      };

      // Crear una nueva instancia de la gráfica
      var canvas = document.querySelector(canvasID);
      var myChart = new Chart(canvas, config);
    }
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
      console.log("🚀 ~ cargarDatosReclutamiento ~ requisicionesCanceladas:", requisicionesCanceladas)
      miniChart.data.datasets[1].data = requisicionesRecibidas;
      console.log("🚀 ~ cargarDatosReclutamiento ~ requisicionesRecibidas:", requisicionesRecibidas)
      miniChart.data.datasets[2].data = requisicionesCerradas;
      console.log("🚀 ~ cargarDatosReclutamiento ~ requisicionesCerradas:", requisicionesCerradas)
      miniChart.data.datasets[3].data = sla;
      console.log("🚀 ~ cargarDatosReclutamiento ~ sla:", sla)

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
  type: 'bar', // o el tipo que prefieras
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
var ctxFull = document.getElementById('chartReclu').getContext('2d');
var fullChart;

// Función para abrir el modal y cargar la gráfica en tamaño completo
document.getElementById('miniChartCard').addEventListener('click', function() {
  $('#chartModal').modal('show');

  // Si la gráfica ya está creada, destrúyela antes de volver a crearla
  if (fullChart) {
    fullChart.destroy();
  }

  // Crear la gráfica en el modal
  fullChart = new Chart(ctxFull, {
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

// Declarar una función para cargar los datos mediante AJAX


// Llamar a la función para cargar los datos al cargar la página


// Crear el gráfico inicialmente con etiquetas y datos vacíos
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


function generarPaleta(numColores) {
  var paleta = [];
  for (var i = 0; i < numColores; i++) {
    var color = 'hsl(' + (i * (360 / numColores) % 360) + ', 70%, 50%, 0.4)';
    paleta.push(color);
  }
  return paleta;
}
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
          size: 20// Reducir el tamaño de la fuente dentro del tooltip
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
    plugins: {
      legend: {
        display: true,
        position: 'right',
        labels: {
          padding: 20,
          boxWidth: 40,
          font: {
            size: 15
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
        color: '#fff',
      }
    }
  }
});




$(document).ready(function() {
  cargarGraficaGeneral();
  cargarDatosReclutamiento();
  cargarDatosPastel();
});
</script>
<?php } ?>