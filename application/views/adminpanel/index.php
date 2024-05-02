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
              <i class="fas fa-spinner fa-pulse fa-2x text-success"></i>
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
    <div class="col-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Estadisticas  por reclutadora  <?php echo date('Y'); ?>
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
// Define variables para almacenar los datos de cada card


let datosCard1, datosCard2, datosCard3, datosCard4;

var promises = [];

// Realiza la solicitud AJAX para obtener los datos del card 1
var promise1 = $.ajax({
  url: '<?php echo base_url('Estadistica/getRequisicionesProcesoPorMes'); ?>',
  method: 'GET',
  dataType: 'json',
});

// Realiza la solicitud AJAX para obtener los datos del card 2
var promise2 = $.ajax({
  url: '<?php echo base_url('Estadistica/getRequisicionesFinalizadasPorMes'); ?>',
  method: 'GET',
  dataType: 'json',
});

// Realiza la solicitud AJAX para obtener los datos del card 3
var promise3 = $.ajax({
  url: '<?php echo base_url('Estadistica/getRequisicionesCanceladasPorMes'); ?>',
  method: 'GET',
  dataType: 'json',
});

// Realiza la solicitud AJAX para obtener los datos del card 4
var promise4 = $.ajax({
  url: '<?php echo base_url('Estadistica/getAspirantesProcesoPorMes'); ?>',
  method: 'GET',
  dataType: 'json',
});

// Agrega las promesas al array
promises.push(promise1, promise2, promise3, promise4);

// Espera a que todas las promesas se resuelvan
Promise.all(promises).then(function(responses) {
  // Asigna los datos a las variables correspondientes
  datosCard1 = responses[0];
  datosCard2 = responses[1];
  datosCard3 = responses[2];
  datosCard4 = responses[3];

  // Llama a la función para actualizar la gráfica
  actualizarGrafica();
}).catch(function(error) {
  console.error('Error en las solicitudes AJAX:', error);
});




// Función para actualizar la gráfica una vez que se hayan obtenido todos los datos
function actualizarGrafica() {
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
    const datosMesActual = [datosCard1[mesActual], datosCard2[mesActual], datosCard3[mesActual], datosCard4[mesActual]];
    const datosMesAnterior = [datosCard1[mesAnterior], datosCard2[mesAnterior], datosCard3[mesAnterior], datosCard4[
      mesAnterior]];

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
      labels: nombresMeses,
      datasets: [

        {
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
          pointBackgroundColor: 'rgba(54, 162, 235, 1)',  // Punto del gráfico
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
  type: 'line',
  data: data,
  options: {
    scales: {
      xAxes: [{
        grid: {
          borderColor: 'red'
        }
      }],
      yAxes: [{
        ticks: {
          min: 1,   // Establece el valor mínimo en el eje y
          max: 50,  // Establece el valor máximo en el eje y
          stepSize: 10 // Define el tamaño del paso entre cada punto de comparación
        }
      }]
    },
    maintainAspectRatio: false
  }
  };

    // Crear una nueva instancia de la gráfica
    var myChart = new Chart(
      $('#chartCandidatosFinalizados'),
      config
    );
  }
}

var ctx = document.getElementById("chartReclu");

// Declarar una función para cargar los datos mediante AJAX
function cargarDatos() {
  $.ajax({
    url: '<?php echo base_url('Estadistica/getEstadisticaReclutadoras'); ?>',
    method: 'GET',
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
        requisicionesRecibidas.push(parseInt(res[i].requisicionesAsignadas));
        requisicionesCanceladas.push(parseInt(res[i].requisicionesCanceladas));
        requisicionesCerradas.push(parseInt(res[i].requisicionesFinalizadas));
        sla.push(parseInt(res[i].sla));
    }
    
    // Actualizar los datos del gráfico con los datos obtenidos
    myChart.data.labels = reclutadoras;
    myChart.data.datasets[2].data = requisicionesCanceladas;
    myChart.data.datasets[0].data = requisicionesRecibidas;
    myChart.data.datasets[1].data = requisicionesCerradas;
    myChart.data.datasets[3].data = sla;
    
    // Actualizar el gráfico
    myChart.update();
},
    error: function(xhr, status, error) {
      console.error('Error al cargar los datos:', error);
    }
  });
}

// Llamar a la función para cargar los datos al cargar la página
$(document).ready(function() {
  cargarDatos();
});

// Crear el gráfico inicialmente con etiquetas y datos vacíos
var myChart = new Chart(ctx, {
  type: "bar",
  data: {
    labels: [],
    datasets: [
      {
        label: 'Requisiciones Canceladas',
        data: [],
        backgroundColor: 'rgba(255, 99, 132, 1)',
      },
      {
        label: 'Requisiciones Asignadas',
        data: [],
        backgroundColor: 'rgba(92, 184, 92, 1)',
      },
      {
        label: 'Requisiciones Finalizadas',
        data: [],
        backgroundColor: 'rgba(54, 162, 235, 1)',
      },
   
      {
        label: 'SLA Promedio en dias ',
        data: [],
        backgroundColor: 'rgba(255, 206, 86, 1)',
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
</script>
<?php } ?>