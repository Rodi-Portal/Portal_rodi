<!-- Begin Page Content -->
<div class="container-fluid" id="content-container">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <h1 id="msg_push"></h1>
    <!--a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</!--a-->
  </div>
  <?php 
  if($this->session->userdata('idrol') == 1 || $this->session->userdata('idrol') == 6){ ?>
    <div class="row">
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><?php echo $titulo_dato1; ?></div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $dato1; ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
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
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $dato2; ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-eye-dropper fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?php echo $titulo_dato3; ?></div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $dato3; ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-head-side-mask fa-2x text-gray-300"></i>
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
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $dato4; ?></div>
              </div>
              <div class="col-auto">
                <i class="fas fa-notes-medical fa-2x text-gray-300"></i>
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
            <h6 class="m-0 font-weight-bold text-primary">Gráfica de ESE Finalizados durante <?php echo date('Y'); ?></h6>
          </div>
          <div class="card-body">
            <div class="chart-area">
              <canvas id="chartCandidatosFinalizados"></canvas>
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
              <canvas id="chartEstatusCandidatosPorAnalista"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php 
  } ?>

</div>

<!-- /.container-fluid -->
<?php 
	if($this->session->userdata('idrol') == 1 || $this->session->userdata('idrol') == 6){ ?>
	<script>
		let datos = [];
		$.ajax({
			async: false,
			url: '<?php echo base_url('Estadistica/getCandidatosFinalizadosporMeses'); ?>',
			method: "POST",
			success: function(res) {
				var data = JSON.parse(res);
				for(var i = 0; i < data.length; i++){
					datos.push(data[i]);
				}
			}
		});
		const labels = [
			'Enero',
			'Febrero',
			'Marzo',
			'Abril',
			'Mayo',
			'Junio',
			'Julio',
			'Agosto',
			'Septiembre',
			'Octubre',
			'Noviembre',
			'Diciembre'
		];
		const data = {
			labels: labels,
			datasets: [{
				label: 'Cantidad Total del Mes',
				backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
    		borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
    		borderWidth: 1,// Ancho del borde
				//borderColor: 'rgba(54, 162, 235, 1)', //Linea trazada
				pointBackgroundColor: "#fff", // Punto del gráfico
      	//pointBorderColor: "#000", // Circunferencia que bordean el punto del gráfico
				pointRadius: 5,
				//borderWidth: 5,
				fill: true,
				data: datos,
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
			}],
		};

		const config = {
      plugins: [ChartDataLabels],
			type: 'line',
			data: data,
			options: {
				scales: {
					x: {
						grid: {
							borderColor: 'red'
						}
					},
					y: {
						min: 0,
        		max: 600,
						ticks: {
							stepSize: 100
						}
					}
    		},
				maintainAspectRatio: false
			},
      
		};

		var myChart = new Chart($('#chartCandidatosFinalizados'),config);
	</script>
	<?php 
	} 
	if($this->session->userdata('idrol') == 2 || $this->session->userdata('idrol') == 9){ ?>
	<script>
		let datos = [];
		$.ajax({
			async: false,
			url: '<?php echo base_url('Estadistica/getCandidatosFinalizadosPorMesesPorAnalista'); ?>',
			method: "POST",
			success: function(res) {
				var data = JSON.parse(res);
				for(var i = 0; i < data.length; i++){
					datos.push(data[i]);
				}
			}
		});
		const labels = [
			'Enero',
			'Febrero',
			'Marzo',
			'Abril',
			'Mayo',
			'Junio',
			'Julio',
			'Agosto',
			'Septiembre',
			'Octubre',
			'Noviembre',
			'Diciembre'
		];
		const data = {
			labels: labels,
			datasets: [{
				label: 'Cantidad Total del Mes',
				backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de fondo
    		borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
    		borderWidth: 1,// Ancho del borde
				//borderColor: 'rgba(54, 162, 235, 1)', //Linea trazada
				pointBackgroundColor: "#fff", // Punto del gráfico
      	//pointBorderColor: "#000", // Circunferencia que bordean el punto del gráfico
				pointRadius: 5,
				//borderWidth: 5,
				fill: true,
				data: datos,
			}]
		};

		const config = {
			type: 'line',
			data: data,
			options: {
				scales: {
					x: {
						grid: {
							borderColor: 'red'
						}
					},
					y: {
						min: 0,
        		max: 200,
						ticks: {
							stepSize: 10
						}
					}
    		},
				maintainAspectRatio: false
			}
		};

		var myChart = new Chart(
			$('#chartCandidatosPorAnalista'),
			config
		);
		//Grafica de Estatus
		let estatus_arreglo = [];
		$.ajax({
			async: false,
			url: '<?php echo base_url('Estadistica/getEstatusCandidatosPorAnalista'); ?>',
			method: "POST",
			success: function(res) {
				var data = JSON.parse(res);
				for(var i = 0; i < data.length; i++){
					estatus_arreglo.push(data[i]);
				}
			}
		});
		const data2 = {
			labels: [
				'Recomendable',
				'No recomendable',
				'A consideración'
			],
			datasets: [{
				label: 'My First Dataset',
				data: estatus_arreglo,
				backgroundColor: [
					'rgb(0, 204, 0)',
					'rgb(255, 0, 0)',
					'rgb(255, 205, 86)'
				],
			}]
		};

		const config2 = {
			type: 'pie',
			data: data2
		};

		var myChart = new Chart(
			$('#chartEstatusCandidatosPorAnalista'),
			config2,
		);
	</script>
	<?php 
	} ?>