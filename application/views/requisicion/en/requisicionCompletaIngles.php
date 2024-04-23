<!DOCTYPE html>
<html lang="en">

<body>
	<div class="modal fade" id="avisoModal" role="dialog" data-backdrop="static" data-keyboard="false">
	  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title">Request sent</h4>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <p>Thank you for taking the time to send us your request. We will contact you as soon as possible.</p><br>
	        <br>
	      </div>
	    </div>
	  </div>
	</div>
	<header>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="menu">
		  <a class="navbar-brand text-light" href="#">
		 
		    Request form
		  </a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav ml-auto">
		    	<li class="nav-item">
					<a class="nav-link text-light font-weight-bold" href="<?php echo site_url('Requisicion/index') ?>"><i class="fas fa-globe"></i> Versión Español</a>
				</li>
		    </ul>
		  </div>
		</nav>
  </header>
  <div class="loader" style="display: none;"></div>
  <div class="alert alert-info">
  	<h5 class="text-center">All fields are required (*)</h5>

  </div>
	<div class="contenedor mt-5">
		<div class="card">
	  	<h5 class="card-header text-center seccion">Billing Information</h5>
		  <div class="card-body">
		    <div class="row">
		    	<div class="col-12">
		    		<label>Name or Company name *</label>
		    		<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user"></i></span>
						  </div>
						  <input type="text" class="form-control" id="nombre" name="nombre" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
		    		<label>Tax address *</label>
						<div class="input-group mb-3">
				  		<div class="input-group-prepend">
				    		<span class="input-group-text"><i class="fas fa-home"></i></span>
				  		</div>
				  		<input type="text" class="form-control" id="domicilio" name="domicilio" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label>Zip code *</label>
						<div class="input-group mb-3">
				  		<div class="input-group-prepend">
				    		<span class="input-group-text"><i class="fas fa-home"></i></span>
				  		</div>
				  		<input type="number" class="form-control solo_numeros" id="cp" name="cp" maxlength="5">
						</div>
					</div>
					<div class="col-sm-12 col-md-8 col-lg-8">
		    		<label>Tax Regime *</label>
						<div class="input-group mb-3">
				  		<div class="input-group-prepend">
				    		<span class="input-group-text"><i class="fas fa-user-tag"></i></span>
				  		</div>
				  		<input type="text" class="form-control" id="regimen" name="regimen" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-4 col-lg-4">
						<label>Telephone *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
						  </div>
						  <input type="text" class="form-control" id="telefono" name="telefono" maxlength="16">
						</div>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
						<label>Email *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-envelope"></i></span>
						  </div>
						  <input type="text" class="form-control" id="correo" name="correo" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toLowerCase()">
						</div>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
						<label>Contact *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user"></i></span>
						  </div>
						  <input type="text" class="form-control" id="contacto" name="contacto">
						</div>
					</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label>Federal Taxpayer Registry *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user"></i></span>
						  </div>
						  <input type="text" class="form-control" id="rfc" name="rfc" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" maxlength="20">
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label>Form of payment *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-credit-card"></i></span>
						  </div>
						  <select class="custom-select" id="forma_pago" name="forma_pago">
						    <option value="" selected>Select</option>
						    <option value="Pago en una sola exhibición">Single payment</option>
						    <option value="Pago en parcialidades o diferidos">Partial or deferred payment</option>
						  </select>
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label>Payment method *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-credit-card"></i></span>
						  </div>
						  <select class="custom-select" id="metodo_pago" name="metodo_pago">
						    <option value="" selected>Select</option>
						    <option value="Efectivo">Cash</option>
						    <option value="Cheque nominativo">Nominative check</option>
						    <option value="Transferencia electrónica de fondos">Electronic funds transfer</option>
						    <option value="Tarjeta de crédito">Credit card</option>
						    <option value="Tarjeta de débito">Debit card</option>
						    <option value="Por definir">To be defined</option>
						  </select>
						</div>
	    		</div>
	    	</div>
	    	<div class="row">
					<div class="col-12">
		    		<label>Digital tax receipt *</label>
						<div class="input-group mb-3">
				  		<div class="input-group-prepend">
				    		<span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
				  		</div>
				  		<input type="text" class="form-control" id="uso_cfdi" name="uso_cfdi">
						</div>
					</div>
				</div>
	    </div>
	  </div>
	</div>
	<div class="contenedor mt-5 my-5">
		<div class="card">
	  	<h5 class="card-header text-center seccion">Vacancy Information</h5>
		  <div class="card-body">
		    <div class="row">
		    	<div class="col-sm-12 col-md-6 col-lg-6">
		    		<label>Vacancy name *</label>
		    		<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
						  </div>
		    			<input type="text" class="form-control" id="puesto" name="puesto">
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-6">
		    		<label>Number of vacancies *</label>
		    		<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
						  </div>
						  <input type="number" class="form-control" id="num_vacantes" name="num_vacantes">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label>Required education formation *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
						  </div>
						  <select class="custom-select" id="escolaridad" name="escolaridad">
						    <option value="" selected>Select</option>
						    <option value="Primaria">Elementary school level</option>
						    <option value="Secundaria">Middle school level</option>
						    <option value="Bachiller">High school level</option>
						    <option value="Licenciatura">College level</option>
						    <option value="Maestría">Master level</option>
						  </select>
						</div>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label>Academic status *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
						  </div>
						  <select class="custom-select" id="estatus_escolaridad" name="estatus_escolaridad">
						    <option value="" selected>Select</option>
						    <option value="Técnico">Technician</option>
						    <option value="Pasante">Intern</option>
						    <option value="Estudiante">Student</option>
						    <option value="Titulado">Titled</option>
						    <option value="Trunco">Unfinished college</option>
						    <option value="Otro">Other</option>
						  </select>
						</div>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
						<label>Other academic status</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
						  </div>
						  <input type="text" class="form-control" id="otro_estatus" name="otro_estatus" disabled>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-6 col-lg-6">
						<label>Career required for the position *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
						  </div>
						  <input type="text" class="form-control" id="carrera" name="carrera">
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-6">
						<label>Other studies</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
						  </div>
						  <input type="text" class="form-control" id="otros_estudios" name="otros_estudios">
						</div>
					</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label>Native language</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-language"></i></span>
						  </div>
						  <input type="text" class="form-control" id="idioma1" name="idioma1">
						</div>
					</div>
					<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label>Percentage of native language</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
						  </div>
						  <input type="number" class="form-control" id="por_idioma1" name="por_idioma1">
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label>Second language</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-language"></i></span>
						  </div>
						  <input type="text" class="form-control" id="idioma2" name="idioma2">
						</div>
					</div>
					<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label>Percentage of second language</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
						  </div>
						  <input type="number" class="form-control" id="por_idioma2" name="por_idioma2">
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label>Third language </label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-language"></i></span>
						  </div>
						  <input type="text" class="form-control" id="idioma3" name="idioma3">
						</div>
					</div>
					<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label>Percentage of third language</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
						  </div>
						  <input type="number" class="form-control" id="por_idioma3" name="por_idioma3">
						</div>
	    		</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label>Required technology skill</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-laptop"></i></span>
						  </div>
						  <input type="text" class="form-control" id="habilidad1" name="habilidad1">
						</div>
					</div>
					<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label>Percentage of the skill</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
						  </div>
						  <input type="number" class="form-control" id="por_habilidad1" name="por_habilidad1">
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label>Other required technology skill</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-laptop"></i></span>
						  </div>
						  <input type="text" class="form-control" id="habilidad2" name="habilidad2">
						</div>
					</div>
					<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label>Percentage of the skill</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
						  </div>
						  <input type="number" class="form-control" id="por_habilidad2" name="por_habilidad2">
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label>Other required technology skill </label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-laptop"></i></span>
						  </div>
						  <input type="text" class="form-control" id="habilidad3" name="habilidad3">
						</div>
					</div>
					<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label>Percentage of the skill</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
						  </div>
						  <input type="number" class="form-control" id="por_habilidad3" name="por_habilidad3">
						</div>
	    		</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label>Gender *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
						  </div>
						  <select class="custom-select" id="genero" name="genero">
						    <option value="" selected>Select</option>
						    <option value="Femenino">Female</option>
						    <option value="Masculino">Male</option>
						    <option value="Indistinto">Indistint</option>
						  </select>
						</div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label>Marital status *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
						  </div>
						  <select class="custom-select" id="civil" name="civil">
						    <option value="" selected>Select</option>
						    <option value="Soltero(a)">Single</option>
						    <option value="Casado(a)">Married</option>
						    <option value="Indistinto">Indistint</option>
						  </select>
						</div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label>Minimum age </label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-minus"></i></span>
						  </div>
						  <input type="number" id="edad_minima" name="edad_minima" class="form-control">
						</div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label>Maximum age </label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-plus"></i></span>
						  </div>
						  <input type="number" id="edad_maxima" name="edad_maxima" class="form-control">
						</div>
					</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label>Driver licence *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
						  </div>
						  <select class="custom-select" id="licencia" name="licencia">
						    <option value="" selected>Select</option>
						    <option value="Indispensable">Essential</option>
						    <option value="Deseable">Is desirable</option>
						    <option value="No necesaria">Not necessary</option>
						  </select>
						</div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
						<label>Type of driver licence *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
						  </div>
						  <input type="text" class="form-control" id="tipo_licencia" name="tipo_licencia" disabled>
						</div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label>Acceptable disability *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-wheelchair"></i></span>
						  </div>
						  <select class="custom-select" id="discapacidad" name="discapacidad">
						    <option value="" selected>Select</option>
						    <option value="Motora">Motor disability</option>
						    <option value="Auditiva">Auditory disability</option>
						    <option value="Visual">Visual disability</option>
						    <option value="Motora y auditiva">Motor and auditory disabilities</option>
						    <option value="Motora y visual">Motor and visual disabilities</option>
						    <option value="Sin discapacidad">No disabilities</option>
						  </select>
						</div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label>Cause of vacancy *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-question-circle"></i></span>
						  </div>
						  <select class="custom-select" id="causa" name="causa">
						    <option value="" selected>Select</option>
						    <option value="Empresa nueva">New company</option>
						    <option value="Empleo temporal">Temporal job</option>
						    <option value="Puesto de nueva creación">New position</option>
						    <option value="Reposición de personal">Staff replenishment</option>
						  </select>
						</div>
					</div>
	    	</div>
	    	<div class="row">	
	    		<div class="col-12">
	    			<label>Place of residence *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-home"></i></span>
						  </div>
						  <input type="text" class="form-control" id="residencia" name="residencia">
						</div>
	    		</div>
	    	</div>	
	    </div>
	  </div>
	</div>
	<div class="contenedor mt-5 my-5">
		<div class="card">
	  	<h5 class="card-header text-center seccion">Position Information</h5>
		  <div class="card-body">
		    <div class="row">
		    	<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label>Workday *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-clock"></i></span>
						  </div>
						  <select class="custom-select" id="jornada" name="jornada">
						    <option value="" selected>Select</option>
						    <option value="Tiempo completo">Full time</option>
						    <option value="Medio tiempo">Half-time</option>
						    <option value="Horas">For hours</option>
						  </select>
						</div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label>Begin of the workday *</label>
		    		<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-clock"></i></span>
						  </div>
						  <input type="text" class="form-control" id="tiempo_inicio" name="tiempo_inicio">
						</div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label>Finish of the workday *</label>
		    		<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-clock"></i></span>
						  </div>
						  <input type="text" class="form-control" id="tiempo_final" name="tiempo_final">
						</div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
						<label>Rest days *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-bed"></i></span>
						  </div>
						  <input type="text" class="form-control" id="descanso" name="descanso">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label>Availability to travel *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-plane"></i></span>
						  </div>
						  <select class="custom-select" id="viajar" name="viajar">
						    <option value="" selected>Select</option>
						    <option value="NO">NO</option>
						    <option value="SI">Yes</option>
						  </select>
						</div>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label>Schedule availability *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-clock"></i></span>
						  </div>
						  <select class="custom-select" id="horario" name="horario">
						    <option value="" selected>Select</option>
						    <option value="NO">NO</option>
						    <option value="SI">Yes</option>
						  </select>
						</div>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
						<label>Work address *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
						  </div>
						  <textarea name="zona" id="zona" class="form-control" rows="3"></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label>Salary *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
						  </div>
						  <select class="custom-select" id="tipo_sueldo" name="tipo_sueldo">
						    <option value="" selected>Select</option>
						    <option value="Fijo">Fixed</option>
						    <option value="Variable">Variable</option>
						    <option value="Neto">Net</option>
						    <option value="Nominal">Nominal</option>
						  </select>
						</div>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label>Minimum salary</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-minus"></i></span>
						  </div>
						  <input type="number" class="form-control" id="sueldo_minimo" name="sueldo_minimo">
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label>Maximum salary *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-plus"></i></span>
						  </div>
						  <input type="number" class="form-control" id="sueldo_maximo" name="sueldo_maximo">
						</div>
	    		</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label>Bonus *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
						  </div>
						  <select class="custom-select" id="sueldo_adicional" name="sueldo_adicional">
						    <option value="" selected>Select</option>
						    <option value="Comisión">Commission</option>
						    <option value="Bono">Bonus</option>
						    <option value="N/A">N/A</option>
						  </select>
						</div>
					</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label>Additional amount</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
						  </div>
						  <input type="text" class="form-control" id="monto_adicional" name="monto_adicional" disabled>
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label>Payment type *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
						  </div>
						  <select class="custom-select" id="tipo_pago" name="tipo_pago">
						    <option value="" selected>Select</option>
						    <option value="Mensual">Monthly</option>
						    <option value="Quincenal">Bi-weekly</option>
						    <option value="Semanal">Weekly</option>
						  </select>
						</div>
					</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label>Will the person have legal benefits? *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-gavel"></i></span>
						  </div>
						  <select class="custom-select" id="ley" name="ley">
						    <option value="" selected>Select</option>
						    <option value="SI">Yes</option>
						    <option value="NO">NO</option>
						  </select>
						</div>
					</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label>Will the person have superior benefits?</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-gavel"></i></span>
						  </div>
						  <input type="text" class="form-control" id="superiores" name="superiores">
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label>Other benefits </label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-gavel"></i></span>
						  </div>
						  <input type="text" class="form-control" id="otras_prestaciones" name="otras_prestaciones">
						</div>
	    		</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-sm-12 col-md-6 col-lg-6">
						<label>Experience required in: *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-id-badge"></i></span>
						  </div>
						  <textarea name="experiencia" id="experiencia" class="form-control" rows="4"></textarea>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-6">
						<label>Activities to be performed: *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
						  </div>
						  <textarea name="actividades" id="actividades" class="form-control" rows="4"></textarea>
						</div>
					</div>
	    	</div>
	    </div>
	  </div>
	</div>
	<div class="contenedor mt-5 my-5">
		<div class="card">
	  	<h5 class="card-header text-center seccion">Position Profile</h5>
	  	<h5 class="text-center mt-3 my-3">Competencies required for the position:</h5>
		  <div class="card-body">
		    <div class="row">
		    	<div class="col-sm'12 col-md-4 col-lg-4">
		    		<label class="container_checkbox">Communication
						  <input type="checkbox" id="Comunicación" value="Comunicación">
						  <span class="checkmark"></span>
						</label>
		    		<label class="container_checkbox">Analysis
						  <input type="checkbox" id="Análisis">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Leadership
						  <input type="checkbox" id="Liderazgo">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Negotiation
						  <input type="checkbox" id="Negociación">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Follow the rules
						  <input type="checkbox" id="Apego">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Planning
						  <input type="checkbox" id="Planeación">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Organization
						  <input type="checkbox" id="Organización">
						  <span class="checkmark"></span>
						</label>
					</div>
					<div class="col-sm'12 col-md-4 col-lg-4">
		    		<label class="container_checkbox">Results oriented
						  <input type="checkbox" id="Orientado_resultados">
						  <span class="checkmark"></span>
						</label>
		    		<label class="container_checkbox">Conflict management
						  <input type="checkbox" id="Manejo_conflictos">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Teamwork
						  <input type="checkbox" id="Trabajo_equipo">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Decision making
						  <input type="checkbox" id="Toma_decisiones">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Working under pressure
						  <input type="checkbox" id="Trabajo_presion">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Gift of leadership
						  <input type="checkbox" id="Don_mando">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Versatile
						  <input type="checkbox" id="Versátil">
						  <span class="checkmark"></span>
						</label>
					</div>
					<div class="col-sm'12 col-md-4 col-lg-4">
		    		<label class="container_checkbox">Sociable
						  <input type="checkbox" id="Sociable">
						  <span class="checkmark"></span>
						</label>
		    		<label class="container_checkbox">Intuitive
						  <input type="checkbox" id="Intuitivo">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Self-taught
						  <input type="checkbox" id="Autodidacta">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Creative
						  <input type="checkbox" id="Creativo">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Proactive
						  <input type="checkbox" id="Proactivo">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Adaptable
						  <input type="checkbox" id="Adaptable">
						  <span class="checkmark"></span>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<label>Additional observations</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-eye"></i></span>
						  </div>
						  <textarea name="observaciones" id="observaciones" class="form-control" rows="4"></textarea>
						</div>
					</div>
				</div>
	    </div>
	  </div>
	</div>
	<div id="msj_error" class="alert alert-danger hidden"></div>
	<div class="contenedor mt-5 my-5">
		<button type="button" class="btn btn-success btn-lg btn-block" onclick="enviar()">Send Request</button>
	</div>
<!-- Modal -->
<div class="modal fade" id="avisoPrivModal" tabindex="-1" role="dialog" aria-labelledby="avisoModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="avisoPrivModalLabel">Privacy Notice </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModalBtn" disabled>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <p style="font-size: 16px; line-height: 1.5;">
	  <strong style="text-align: justify;">TERMS AND CONDITIONS IN THE HIRING OF RECRUITMENT SERVICES</strong>
<ol style="list-style-type: decimal; padding-left: 20px; text-align: justify;">
    <li>Fill out the personnel requisition with the profile of your vacancy. Remember that here, the characteristics that candidates must have for the vacancy and the activities to be carried out will be outlined. It will be our guide for recruiting. Please fill it out clearly.</li>
    <li>We do not charge any type of advance or upfront payments, and we do not ask for exclusivity to cover all your vacancies.</li>
    <li>On the first day the CANDIDATE starts working, an invoice will be sent with the amount of one month's salary for the position being recruited. The payment must be made within a period not exceeding 3 days after the invoice is issued.</li>
    <li>At no extra cost, the following studies are conducted on the selected candidate:
        <ul style="list-style-type: disc; padding-left: 20px; text-align: justify;">
            <li>Socioeconomic, General Information of the candidate, Family Structure, Work References (5 years), Personal References, Neighborhood References, Document Verification, Legal/Database Verification, Identity Verification, Home Visit, Photos at Home, Report Verification of contributed weeks)</li>
            <li>Doping: A doping test of 3 parameters is performed (Cocaine, Marijuana, and Methamphetamine).</li>
            <li>Psychometrics: Depending on the position the candidate is going to fill, the tests that would be applied include (Cleaver, Allport, Kolb, Terman, Lifo, Kostick, RavenG, Gordon, IPV, 16 PFa, Moss, and Zavic).</li>
        </ul>
    </li>
    <li>You are granted a guarantee for each paid position. The guarantee days may vary according to the position and agreed salary.</li>
    <li>Guarantees are covered with another candidate, to whom the same tests that were performed on the first candidate are applied at no cost.</li>
    <li>There are no money refunds.</li>
</ol>
<p style="text-align: justify;">Guarantees will be valid only if:
    <ul style="list-style-type: disc; padding-left: 20px; text-align: justify;">
        <li>The invoice is settled within the agreed time.</li>
        <li>The conditions of work offered in the interview are met, with no changes in activities, salary, workplace, benefits, etc.</li>
    </ul>
</p>
        <strong>I ACCEPT THE TERMS AND CONDITIONS</strong>
		</p>
		<div class="form-check">
          <input type="checkbox" class="form-check-input" id="aceptoTerminos">
          <label class="form-check-label" for="aceptoTerminos">Acepto los términos</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="continuarBtn" disabled>Continuar</button>
      </div>
    </div>
  </div>
</div> 

	
	<script>



		$(document).ready(function(){
			$('#estatus_escolaridad').change(function(){
				var opcion = $(this).val();
				if(opcion == "Otro"){
					$('#otro_estatus').prop('disabled', false);
				}
				else{
					$('#otro_estatus').prop('disabled', true);
					$('#otro_estatus').val('');
				}
			})
			$('#sueldo_adicional').change(function(){
				var opcion = $(this).val();
				if(opcion != "N/A"){
					$('#monto_adicional').prop('disabled', false);
				}
				else{
					$('#monto_adicional').prop('disabled', true);
					$('#monto_adicional').val('');
				}
			});
			$('#licencia').change(function(){
				var opcion = $(this).val();
				if(opcion != "No necesaria"){
					$('#tipo_licencia').prop('disabled', false);
				}
				else{
					$('#tipo_licencia').prop('disabled', true);
					$('#tipo_licencia').val('');
				}
			})
			
    });

	$(document).ready(function () {
    // Mostrar el modal de aviso de privacidad al cargar la página
    $("#avisoPrivModal").modal('show');

    // Deshabilitar inicialmente el botón "Continuar"
    $("#continuarBtn").prop("disabled", true);

    // Deshabilitar el botón de cierre del modal hasta que se acepten los términos
    $("#aceptoTerminos").change(function () {
      $("#closeModalBtn").prop("disabled", !$(this).prop("checked"));
      $("#continuarBtn").prop("disabled", !$(this).prop("checked"));
    });

    // Habilitar o deshabilitar el botón "Continuar" según si se aceptan los términos
    $("#aceptoTerminos").change(function () {
      $("#continuarBtn").prop("disabled", !$(this).prop("checked"));
    });

    // Cerrar el modal cuando se presiona "Continuar"
    $("#continuarBtn").click(function () {
      $("#avisoPrivModal").modal('hide');
    });
  });





		function enviar(){
			var datos = new FormData();
			var competencias = '';
			competencias += ($('#Comunicación').is(":checked"))? 'Comunicación_':'';
			competencias += ($('#Análisis').is(":checked"))? 'Análisis_':'';
			competencias += ($('#Liderazgo').is(":checked"))? 'Liderazgo_':'';
			competencias += ($('#Negociación').is(":checked"))? 'Negociación_':'';
			competencias += ($('#Apego').is(":checked"))? 'Apego a normas_':'';
			competencias += ($('#Planeación').is(":checked"))? 'Planeación_':'';
			competencias += ($('#Organización').is(":checked"))? 'Organización_':'';
			competencias += ($('#Orientado_resultados').is(":checked"))? 'Orientado a resultados_':'';
			competencias += ($('#Manejo_conflictos').is(":checked"))? 'Manejo de conflictos_':'';
			competencias += ($('#Trabajo_equipo').is(":checked"))? 'Trabajo en equipo_':'';
			competencias += ($('#Toma_decisiones').is(":checked"))? 'Toma de decisiones_':'';
			competencias += ($('#Trabajo_presion').is(":checked"))? 'Trabajo bajo presión_':'';
			competencias += ($('#Don_mando').is(":checked"))? 'Don de mando_':'';
			competencias += ($('#Versátil').is(":checked"))? 'Versátil_':'';
			competencias += ($('#Sociable').is(":checked"))? 'Sociable_':'';
			competencias += ($('#Intuitivo').is(":checked"))? 'Intuitivo_':'';
			competencias += ($('#Autodidacta').is(":checked"))? 'Autodidacta_':'';
			competencias += ($('#Creativo').is(":checked"))? 'Creativo_':'';
			competencias += ($('#Proactivo').is(":checked"))? 'Proactivo_':'';
			competencias += ($('#Adaptable').is(":checked"))? 'Adaptable_':'';
			datos.append('nombre', $('#nombre').val());
			datos.append('domicilio', $('#domicilio').val());
			datos.append('cp', $('#cp').val());
			datos.append('regimen', $('#regimen').val());
			datos.append('telefono', $('#telefono').val());
			datos.append('correo', $('#correo').val());
			datos.append('contacto', $('#contacto').val());
			datos.append('rfc', $('#rfc').val());
			datos.append('forma_pago', $('#forma_pago').val());
			datos.append('metodo_pago', $('#metodo_pago').val());
			datos.append('uso_cfdi', $('#uso_cfdi').val());
			datos.append('puesto', $('#puesto').val());
			datos.append('num_vacantes', $('#num_vacantes').val());
			datos.append('escolaridad', $('#escolaridad').val());
			datos.append('estatus_escolaridad', $('#estatus_escolaridad').val());
			datos.append('otro_estatus', $('#otro_estatus').val());
			datos.append('carrera', $('#carrera').val());
			datos.append('otros_estudios', $('#otros_estudios').val());
			datos.append('idioma1', $('#idioma1').val());
			datos.append('por_idioma1', $('#por_idioma1').val());
			datos.append('idioma2', $('#idioma2').val());
			datos.append('por_idioma2', $('#por_idioma2').val());
			datos.append('idioma3', $('#idioma3').val());
			datos.append('por_idioma3', $('#por_idioma3').val());
			datos.append('habilidad1', $('#habilidad1').val());
			datos.append('por_habilidad1', $('#por_habilidad1').val());
			datos.append('habilidad2', $('#habilidad2').val());
			datos.append('por_habilidad2', $('#por_habilidad2').val());
			datos.append('habilidad3', $('#habilidad3').val());
			datos.append('por_habilidad3', $('#por_habilidad3').val());
			datos.append('genero', $('#genero').val());
			datos.append('civil', $('#civil').val());
			datos.append('edad_minima', $('#edad_minima').val());
			datos.append('edad_maxima', $('#edad_maxima').val());
			datos.append('licencia', $('#licencia').val());
			datos.append('tipo_licencia', $('#tipo_licencia').val());
			datos.append('discapacidad', $('#discapacidad').val());
			datos.append('causa', $('#causa').val());
			datos.append('residencia', $('#residencia').val());
			datos.append('jornada', $('#jornada').val());
			datos.append('tiempo_inicio', $('#tiempo_inicio').val());
			datos.append('tiempo_final', $('#tiempo_final').val());
			datos.append('descanso', $('#descanso').val());
			datos.append('viajar', $('#viajar').val());
			datos.append('horario', $('#horario').val());
			datos.append('zona', $('#zona').val());
			datos.append('tipo_sueldo', $('#tipo_sueldo').val());
			datos.append('sueldo_minimo', $('#sueldo_minimo').val());
			datos.append('sueldo_maximo', $('#sueldo_maximo').val());
			datos.append('sueldo_adicional', $('#sueldo_adicional').val());
			datos.append('monto_adicional', $('#monto_adicional').val());
			datos.append('tipo_pago', $('#tipo_pago').val());
			datos.append('ley', $('#ley').val());
			datos.append('superiores', $('#superiores').val());
			datos.append('otras_prestaciones', $('#otras_prestaciones').val());
			datos.append('experiencia', $('#experiencia').val());
			datos.append('actividades', $('#actividades').val());
			datos.append('competencias', competencias);
			datos.append('observaciones', $('#observaciones').val());
			datos.append('version', 'ingles');
			$.ajax({
				url: '<?php echo base_url('Requisicion/registrar'); ?>',
				type: 'POST',
				data: datos,
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					$('.loader').css("display", "block");
				},
				success: function(res) {
					setTimeout(function() {
						$('.loader').fadeOut();
					}, 200);
					var data = JSON.parse(res);
					if (data.codigo === 1) {
						$("#msj_error").css('display', 'none');
						$("#avisoModal").modal('show');
						setTimeout(function() {
							location.reload();
						}, 15000);
					} else {
						$("#msj_error").css('display', 'block').html(data.msg);
					}
				}
			});
		}
	</script>
</body>
</html>