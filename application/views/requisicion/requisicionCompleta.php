<!DOCTYPE html>
<html lang="es">

<body>
	<div class="modal fade" id="avisoModal" role="dialog" data-backdrop="static" data-keyboard="false">
	  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title">Requisición enviada</h4>
	        <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <p>Agradecemos su tiempo para enviarnos su requisición. Nos pondremos en contacto con usted los antes posible.</p><br>
	        <br>
	      </div>
	    </div>
	  </div>
	</div>
	<header>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="menu">
		  <a class="navbar-brand text-light" href="#">
		 		    Formulario de Requisicion
		  </a>
		  <button class="navbar-toggler" type="submit" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav ml-auto">
		    	<!--li class="nav-item">
					<a class="nav-link text-light font-weight-bold english-version-link" href="#" onclick="loadEnglishVersion()"><i class="fas fa-globe"></i> English version</a>




					</li-->
		    </ul>
		  </div>
		</nav>
  </header>
  <div class="loader" style="display: none;"></div>
  <div class="alert alert-info">
  	<h5 class="text-center">Todos los campos con (*) son obligatorios</h5>
		<h1>Requisición Completa</h1>
    
  </div>
<div class="contenedor mt-5">
		<div class="card">
	  	<h5 class="card-header text-center seccion">Datos de Facturación</h5>
		  <div class="card-body">
		    <div class="row">
		    	<div class="col-12">
					<?php foreach ($datos as $dato): ?>
		    		<label for="nombre">Nombre o Razón social *</label>
		    		<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user"></i></span>
						  </div>
							<input type="text" class="form-control" id="nombre" name="nombre" data-siguiente-campo="domicilio" value=
							"<?php echo $dato->razon_social ; ?>" disabled>
           </div
					 <div id="errornombre" class="text-danger"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
		    		<label for="domicilio">Domicilio Fiscal *</label>
						<div class="input-group mb-3">
				  		<div class="input-group-prepend">
				    		<span class="input-group-text"><i class="fas fa-home"></i></span>
				  		</div>
				  		<input type="text" class="form-control" id="domicilio" name="domicilio" data-siguiente-campo="cp" disabled value=
							"<?php echo $dato->pais.", ".$dato->estado.", ".$dato->ciudad.", ".$dato->colonia.", ".$dato->calle.", Ext.".$dato->exterior.", Int.".$dato->interior.", " ; ?>">
						</div>
						<div id="errordomicilio" class="text-danger"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label for="cp">Código postal *</label>
						<div class="input-group mb-3">
				  		<div class="input-group-prepend">
				    		<span class="input-group-text"><i class="fas fa-home"></i></span>
				  		</div>
				  		<input type="number" class="form-control solo_numeros" id="cp" name="cp" maxlength="5"  data-siguiente-campo="regimen" value=
							"<?php echo $dato->cp ; ?>" disabled>
						</div>
						<div id="errorcp" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-8 col-lg-8">
		    		<label for="regimen">Régimen Fiscal *</label>
						<div class="input-group mb-3">
				  		<div class="input-group-prepend">
				    		<span class="input-group-text"><i class="fas fa-user-tag"></i></span>
				  		</div>
				  		<input type="text" class="form-control" id="regimen" name="regimen" data-siguiente-campo="telefono" value=
							"<?php echo $dato->regimen1 ; ?>" disabled>
						</div>
						<div id="errorregimen" class="text-danger"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-4 col-lg-4">
						<label for="telefono">Teléfono *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
						  </div>
						  <input type="number" class="form-control" id="telefono" name="telefono" maxlength="16" data-siguiente-campo="correo" value=
							"<?php echo $dato->telefono_contacto ; ?>" disabled>
						</div>
						<div id="errortelefono" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
						<label for="correo">Correo *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-envelope"></i></span>
						  </div>
						  <input type="text" class="form-control" id="correo" name="correo" data-siguiente-campo="contacto" value=
							"<?php echo $dato->correo_contacto ; ?>" disabled>
						</div>
						<div id="errorcorreo" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
						<label for="contacto">Nombre de Contacto *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user"></i></span>
						  </div>
						  <input type="text" class="form-control" id="contacto" name="contacto" data-siguiente-campo="rfc" value=
							"<?php echo $dato->nombre_contacto." ".$dato->apellido_contacto ; ?>" disabled>
						</div>
						<div id="errorcontacto" class="text-danger"></div>
					</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label for="rfc">RFC *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user"></i></span>
						  </div>
						  <input type="text" class="form-control" id="rfc" name="rfc" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" maxlength="13" data-siguiente-campo="forma_pago" value=
							"<?php echo $dato->rfc ; ?>" disabled>
						</div>
						<div id="errorrfc" class="text-danger"></div>
	    		</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label for="forma_pago">Forma de pago *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-credit-card"></i></span>
						  </div>
						  <select class="custom-select" id="forma_pago" name="forma_pago" data-siguiente-campo="metodo_pago" disabled>
						    <option value="<?php echo $dato->forma_pago?>" selected><?php echo $dato->forma_pago?></option>
						    <option value="Pago en una sola exhibición">Pago en una sola exhibición</option>
						    <option value="Pago en parcialidades o diferidos">Pago en parcialidades o diferidos</option>
						  </select>
							<div id="forma_pago" class="text-danger"></div>
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label for="metodo_pago">Método de pago *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-credit-card"></i></span>
						  </div>
						  <select class="custom-select" id="metodo_pago" name="metodo_pago" data-siguiente-campo="uso_cfdi" disabled>
							<option value="<?php echo $dato->idCliente ?>" selected><?php echo $dato->metodo_pago?></option>
						    <option value="Efectivo">Efectivo</option>
						    <option value="Cheque nominativo">Cheque nominativo</option>
						    <option value="Transferencia electrónica de fondos">Transferencia electrónica de fondos</option>
						    <option value="Tarjeta de crédito">Tarjeta de crédito</option>
						    <option value="Tarjeta de débito">Tarjeta de débito</option>
						    <option value="Por definir">Por definir</option>
						  </select>
						</div>
	    		</div>
	    	</div>
	    	<div class="row">
					<div class="col-12">
		    		<label for="uso_cfdi">Uso de CFDI (Reescibra el uso de cfdi en caso de ser diferente) *</label>
						<div class="input-group mb-3">
				  		<div class="input-group-prepend">
				    		<span class="input-group-text"><i class="fas fa-file-invoice"></i></span>
				  		</div>
				  		<input type="text" class="form-control" id="uso_cfdi" name="uso_cfdi"  data-siguiente-campo="puesto" value=
							"<?php echo $dato->uso_cfdi; ?>" disabled>
						</div>
						<div id="erroruso_cfdi" class="text-danger"></div>
					</div>
				</div>
				<?php endforeach; ?>
	    </div>
	  </div>
	</div> 
	<div class="contenedor mt-5 my-5">
		<div class="card">
	  	<h5 class="card-header text-center seccion">Información de la Vacante</h5>
		  <div class="card-body">
		    <div class="row">
		    	<div class="col-sm-12 col-md-6 col-lg-6">
		    		<label for="puesto">Nombre de la posición *</label>
		    		<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
						  </div>
		    			<input type="text" class="form-control" id="puesto" name="puesto" data-siguiente-campo="num_vacantes" >
						</div>
						<div id="errorpuesto" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-6">
		    		<label for="num_vacantes">Número de vacantes *</label>
		    		<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
						  </div>
						  <input type="number" class="form-control" id="num_vacantes" name="num_vacantes" data-siguiente-campo="escolaridad" disabled>
						</div>
						<div id="errornum_vacantes" class="text-danger"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label for="escolaridad">Formación académica requerida *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
						  </div>
						  <select class="custom-select" id="escolaridad" name="escolaridad" data-siguiente-campo="estatus_escolaridad" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="Primaria">Primaria</option>
						    <option value="Secundaria">Secundaria</option>
						    <option value="Bachiller">Bachiller</option>
						    <option value="Licenciatura">Licenciatura</option>
						    <option value="Maestría">Maestría</option>
						  </select>
						</div>
						<div id="errorescolaridad" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label for="estatus_escolaridad">Estatus académico *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
						  </div>
						  <select class="custom-select" id="estatus_escolaridad" name="estatus_escolaridad" data-siguiente-campo="carrera" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="Técnico">Técnico</option>
						    <option value="Pasante">Pasante</option>
						    <option value="Estudiante">Estudiante</option>
						    <option value="Titulado">Titulado</option>
						    <option value="Trunco">Trunco</option>
						    <option value="Otro">Otro</option>
						  </select>
						</div>
						<div id="errorestatus_escolaridadd" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
						<label for="otro_estatus">Otro estatus académico</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
						  </div>
						  <input type="text" class="form-control" id="otro_estatus" name="otro_estatus">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-6 col-lg-6">
						<label for="carrera">Carrera requerida para el puesto *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
						  </div>
						  <input type="text" class="form-control" id="carrera" name="carrera" data-siguiente-campo="genero" disabled>
						</div>
						<div id="errorcarrera" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-6">
						<label for="otros_estudios">Otros estudios</label>
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
	    			<label for="idioma1">Idioma nativo</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-language"></i></span>
						  </div>
						  <input type="text" class="form-control" id="idioma1" name="idioma1">
						</div>
					</div>
					<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label for="por_idioma1">Porcentaje del idioma nativo</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
						  </div>
						  <input type="number" class="form-control" id="por_idioma1" name="por_idioma1">
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label for="idioma2">Segundo idioma</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-language"></i></span>
						  </div>
						  <input type="text" class="form-control" id="idioma2" name="idioma2">
						</div>
					</div>
					<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label for="por_idioma2">Porcentaje del segundo idioma</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
						  </div>
						  <input type="number" class="form-control" id="por_idioma2" name="por_idioma2">
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label for="idioma3">Tercer idioma </label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-language"></i></span>
						  </div>
						  <input type="text" class="form-control" id="idioma3" name="idioma3">
						</div>
					</div>
					<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label for="por_idioma3">Porcentaje del tercer idioma</label>
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
	    			<label for="habilidad1">Habilidad informática requerida</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-laptop"></i></span>
						  </div>
						  <input type="text" class="form-control" id="habilidad1" name="habilidad1">
						</div>
					</div>
					<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label for="por_habilidad1">Porcentaje de la habilidad</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
						  </div>
						  <input type="number" class="form-control" id="por_habilidad1" name="por_habilidad1">
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label for="habilidad2">Otra habilidad informática</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-laptop"></i></span>
						  </div>
						  <input type="text" class="form-control" id="habilidad2" name="habilidad2">
						</div>
					</div>
					<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label for="por_habilidad2">Porcentaje de la habilidad</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-percentage"></i></span>
						  </div>
						  <input type="number" class="form-control" id="por_habilidad2" name="por_habilidad2">
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label for="habilidad3">Otra habilidad informática </label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-laptop"></i></span>
						  </div>
						  <input type="text" class="form-control" id="habilidad3" name="habilidad3">
						</div>
					</div>
					<div class="col-sm-12 col-md-2 col-lg-2">
	    			<label for="por_habilidad3">Porcentaje de la habilidad</label>
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
		    		<label for="genero">Sexo *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
						  </div>
						  <select class="custom-select" id="genero" name="genero" data-siguiente-campo="civil" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="Femenino">Femenino</option>
						    <option value="Masculino">Masculino</option>
						    <option value="Indistinto">Indistinto</option>
						  </select>
						</div>
						<div id="errorgenero" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label for="civil">Estado civil *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
						  </div>
						  <select class="custom-select" id="civil" name="civil" data-siguiente-campo="edad_minima" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="Soltero(a)">Soltero(a)</option>
						    <option value="Casado(a)">Casado(a)</option>
						    <option value="Indistinto">Indistinto</option>
						  </select>
						</div>
						<div id="errorcivil" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label for="edad_minima">Edad mínima *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-minus"></i></span>
						  </div>
						  <input type="number" id="edad_minima" name="edad_minima" class="form-control" data-siguiente-campo="edad_maxima" disabled>
						</div>
						<div id="erroredad_minima" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label for="edad_maxima">Edad máxima *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-plus"></i></span>
						  </div>
						  <input type="number" id="edad_maxima" name="edad_maxima" class="form-control" data-siguiente-campo="licencia" disabled>
						</div>
						<div id="erroredad_maxima" class="text-danger"></div>
					</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label for="licencia">Licencia de conducir *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
						  </div>
						  <select class="custom-select" id="licencia" name="licencia" data-siguiente-campo="tipo_licencia" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="Indispensable">Indispensable</option>
						    <option value="Deseable">Deseable</option>
						    <option value="No necesaria">No necesaria</option>
						  </select>
						</div>
						<div id="errorlicencia" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
						<label for="tipo_licencia">Tipo de licencia de conducir*</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
						  </div>
						  <input type="text" class="form-control" id="tipo_licencia" name="tipo_licencia" data-siguiente-campo="discapacidad"disabled>
						</div>
						<div id="errortipo_licencia" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label for="discapacidad">Discapacidad aceptable *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-wheelchair"></i></span>
						  </div>
						  <select class="custom-select" id="discapacidad" name="discapacidad" data-siguiente-campo="causa" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="Motora">Motora</option>
						    <option value="Auditiva">Auditiva</option>
						    <option value="Visual">Visual</option>
						    <option value="Motora y auditiva">Motora y auditiva</option>
						    <option value="Motora y visual">Motora y visual</option>
						    <option value="Sin discapacidad">Sin discapacidad</option>
						  </select>
						</div>
						<div id="errordiscapacidad" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label for="causa">Causa que origina la vacante *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-question-circle"></i></span>
						  </div>
						  <select class="custom-select" id="causa" name="causa" data-siguiente-campo="residencia" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="Empresa nueva">Empresa nueva</option>
						    <option value="Empleo temporal">Empleo temporal</option>
						    <option value="Puesto de nueva creación">Puesto de nueva creación</option>
						    <option value="Reposición de personal">Reposición de personal</option>
						  </select>
						</div>
						<div id="errorcausa" class="text-danger"></div>
					</div>
	    	</div>
	    	<div class="row">	
	    		<div class="col-12">
	    			<label for="residencia">Lugar de residencia *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-home"></i></span>
						  </div>
						  <input type="text" class="form-control" id="residencia" name="residencia" data-siguiente-campo="jornada" disabled>
						</div>
						<div id="errorresidencia" class="text-danger"></div>
	    		</div>
	    	</div>	
	    </div>
	  </div>
	</div>
	<div class="contenedor mt-5 my-5">
		<div class="card">
	  	<h5 class="card-header text-center seccion">Información sobre el Cargo</h5>
		  <div class="card-body">
		    <div class="row">
		    	<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label for="jornada">Jornada laboral *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-clock"></i></span>
						  </div>
						  <select class="custom-select" id="jornada" name="jornada" data-siguiente-campo="tiempo_inicio" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="Tiempo completo">Tiempo completo</option>
						    <option value="Medio tiempo">Medio tiempo</option>
						    <option value="Horas">Horas</option>
						  </select>
						</div>
						<div id="errorjornada" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label for="tiempo_inicio">Inicio de la Jornada laboral *</label>
		    		<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-clock"></i></span>
						  </div>
						  <input type="text" class="form-control" id="tiempo_inicio" name="tiempo_inicio" data-siguiente-campo="tiempo_final" disabled>
						</div>
						<div id="errortiempo_inicio" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
		    		<label for="tiempo_final">Fin de la Jornada laboral *</label>
		    		<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-clock"></i></span>
						  </div>
						  <input type="text" class="form-control" id="tiempo_final" name="tiempo_final" data-siguiente-campo="descanso" disabled>
						</div>
						<div id="errortiempo_final" class="text-danger"></div>
					</div>
					<div class="col-sm-12 col-md-3 col-lg-3">
						<label for="descanso">Día(s) de descanso *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-bed"></i></span>
						  </div>
						  <input type="text" class="form-control" id="descanso" name="descanso" data-siguiente-campo="viajar" disabled>
						</div>
						<div id="errordescanso" class="text-danger"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label for="viajar">Disponibilidad para viajar *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-plane"></i></span>
						  </div>
						  <select class="custom-select" id="viajar" name="viajar" data-siguiente-campo="zona" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="NO">NO</option>
						    <option value="SI">SI</option>
						  </select>
						</div>
						<div id="errorviajar" class="text-danger"></div>
					</div>
				<!--	<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label for="horario">Disponibilidad de horario *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-clock"></i></span>
						  </div>
						  <select class="custom-select" id="horario" name="horario" data-siguiente-campo="zona" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="NO">NO</option>
						    <option value="SI">SI</option>
						  </select>
						</div>
						<div id="errorhorario" class="text-danger"></div>
					</div> -->
					<div class="col-sm-12 col-md-4 col-lg-4">
						<label for="zona">Zona de trabajo *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
						  </div>
						  <textarea name="zona" id="zona" class="form-control" rows="3" data-siguiente-campo="tipo_sueldo" disabled></textarea>
						</div>
						<div id="errorzona" class="text-danger"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label for="tipo_sueldo">Tipo de sueldo *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
						  </div>
						  <select class="custom-select" id="tipo_sueldo" name="tipo_sueldo" data-siguiente-campo="sueldo_minimo" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="Neto">Libre</option>
						    <option value="Nominal">Nominal</option>
						  </select>
						</div>
						<div id="errortipo_sueldo" class="text-danger"></div>
					</div> 
					<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label for="sueldo_minimo">Sueldo mínimo *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-plus"></i></span>
						  </div>
						  <input type="number" class="form-control" id="sueldo_minimo" name="sueldo_minimo" data-siguiente-campo="sueldo_maximo" disabled>
						</div>
						<div id="errorsueldo_minimo" class="text-danger"></div>
	    		</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label for="sueldo_maximo">Sueldo máximo *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-plus"></i></span>
						  </div>
						  <input type="number" class="form-control" id="sueldo_maximo" name="sueldo_maximo" data-siguiente-campo="sueldo_adicional" disabled>
						</div>
						<div id="errorsueldo_maximo" class="text-danger"></div>
	    		</div>
	    	</div>
	 	<div class="row">
	    		<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label for="sueldo_adicional">Adicional al sueldo *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
						  </div>
						  <select class="custom-select" id="sueldo_adicional" name="sueldo_adicional" data-siguiente-campo="monto_adicional" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="Comisión">Comisión</option>
						    <option value="Bono">Bono</option>
						    <option value="N/A">N/A</option>
						  </select>
						</div>
						<div id="errorsueldo_adicional" class="text-danger"></div>
					</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label for="monto_adicional">Monto</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
						  </div>
						  <input type="text" class="form-control" id="monto_adicional" name="monto_adicional" data-siguiente-campo="tipo_pago"disabled>
						</div>
						<div id="errormonto_adicional" class="text-danger"></div>
	    		</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label for="tipo_pago">Tiempos de pago *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-money-bill-alt"></i></span>
						  </div>
						  <select class="custom-select" id="tipo_pago" name="tipo_pago" data-siguiente-campo="ley" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="Mensual">Mensual</option>
						    <option value="Quincenal">Quincenal</option>
						    <option value="Semanal">Semanal</option>
						  </select>
						</div>
						<div id="errortipo_pago" class="text-danger"></div>
					</div>
	    	</div>
	    	<div class="row">
	    		<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label for="ley">¿Tendrá prestaciones de ley? *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-gavel"></i></span>
						  </div>
						  <select class="custom-select" id="ley" name="ley" data-siguiente-campo="experiencia" disabled>
						    <option value="" selected>Selecciona</option>
						    <option value="SI">SI</option>
						    <option value="NO">NO</option>
						  </select>
						</div>
						<div id="errorley" class="text-danger"></div>
					</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label for="superiores">¿Tendrá prestaciones superiores? ¿Cuáles?</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-gavel"></i></span>
						  </div>
						  <input type="text" class="form-control" id="superiores" name="superiores">
						</div>
	    		</div>
	    		<div class="col-sm-12 col-md-4 col-lg-4">
	    			<label for="otras_prestaciones">¿Tendrá otro tipo de prestaciones? ¿Cuáles? </label>
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
						<label for="experiencia">Se requiere experiencia en: *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="far fa-id-badge"></i></span>
						  </div>
						  <textarea name="experiencia" id="experiencia" class="form-control" rows="4" data-siguiente-campo="actividades" disabled></textarea>
							<div id="errorexperiencia" class="text-danger"></div>
						</div>
					</div>
					<div class="col-sm-12 col-md-6 col-lg-6">
						<label for="actividades">Actividades a realizar: *</label>
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
						    <span class="input-group-text"><i class="fas fa-clipboard-list"></i></span>
						  </div>
						  <textarea name="actividades" id="actividades" class="form-control" rows="4" data-siguiente-campo="" disabled></textarea>
						</div>
						<div id="erroractividades" class="text-danger"></div>
					</div>
	    	</div>
	    </div>
	  </div>
	</div>
	<!--	REVISAR-->
	<div class="contenedor mt-5 my-5">
		<div class="card">
	  	<h5 class="card-header text-center seccion">Perfil del Cargo</h5>
	  	<h5 class="text-center mt-3 my-3">Competencias requeridas para el puesto (elegir al menos 3) *:</h5>
		  <div class="card-body">
		    <div class="row">
		    	<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label class="container_checkbox">Comunicación
						  <input type="checkbox" id="Comunicación" value="Comunicación">
						  <span class="checkmark"></span>
						</label>
		    		<label class="container_checkbox">Análisis
						  <input type="checkbox" id="Análisis">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Liderazgo
						  <input type="checkbox" id="Liderazgo">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Negociación
						  <input type="checkbox" id="Negociación">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Apego a normas
						  <input type="checkbox" id="Apego">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Planeación
						  <input type="checkbox" id="Planeación">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Organización
						  <input type="checkbox" id="Organización">
						  <span class="checkmark"></span>
						</label>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label class="container_checkbox">Orientado a resultados
						  <input type="checkbox" id="Orientado_resultados">
						  <span class="checkmark"></span>
						</label>
		    		<label class="container_checkbox">Manejo de conflictos
						  <input type="checkbox" id="Manejo_conflictos">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Trabajo en equipo
						  <input type="checkbox" id="Trabajo_equipo">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Toma de decisiones
						  <input type="checkbox" id="Toma_decisiones">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Trabajo bajo presión
						  <input type="checkbox" id="Trabajo_presion">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Don de mando
						  <input type="checkbox" id="Don_mando">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Versátil
						  <input type="checkbox" id="Versátil">
						  <span class="checkmark"></span>
						</label>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-4">
		    		<label class="container_checkbox">Sociable
						  <input type="checkbox" id="Sociable">
						  <span class="checkmark"></span>
						</label>
		    		<label class="container_checkbox">Intuitivo
						  <input type="checkbox" id="Intuitivo">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Autodidacta
						  <input type="checkbox" id="Autodidacta">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Creativo
						  <input type="checkbox" id="Creativo">
						  <span class="checkmark"></span>
						</label>
						<label class="container_checkbox">Proactivo
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
						<label>Observaciones adicionales</label>
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
		<button type="button"  class="btn btn-success btn-lg btn-block" onclick="enviar()">Enviar Requisición</button> 
	</div> 
<!-- Modal -->
<div class="modal fade" id="avisoPrivModal" tabindex="-1" role="dialog" aria-labelledby="avisoModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="avisoPrivModalLabel">Aviso de Privacidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModalBtn" disabled>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <p style="font-size: 16px; line-height: 1.5;">
	  <strong style="text-align: justify;">TERMINOS Y CONDICIONES EN LA CONTRATACIÓN DEL SERVICIO DE RECLUTAMIENTO</strong>
<ol style="list-style-type: decimal; padding-left: 20px; text-align: justify;">
    <li>Se llena la requisición de personal con el perfil de tu vacante. Recuerda que aquí se plasmarán las características que deben tener los candidatos que aplicarán a la vacante y las actividades a realizar. Será nuestra guía para reclutar. Favor de llenarla con claridad.</li>
    <li>No cobramos ningún tipo de anticipo ni pagos por adelantado, y no pedimos exclusividad para ser nosotros quienes cubran todas sus vacantes.</li>
    <li>El día uno que el CANDIDATO ingrese a laborar, se enviará la factura con el monto de un mes de sueldo de la posición que se recluta. El pago tendrá que ser cubierto en un periodo no mayor a 3 días posteriores a la emisión de la factura.</li>
    <li>Sin costo extra se realizan los siguientes estudios al candidato seleccionado:
        <ul style="list-style-type: disc; padding-left: 20px; text-align: justify;">
            <li>Socioeconómico, Información General del candidato, Estructura Familiar, Referencias laborales (5 años), Referencias personales, Referencias Vecinales, Verificación de Documentos, Verificación Legal/Base de Datos, Verificación de Identidad, Visita domiciliar, Fotografías en Hogar, Verificación de Reporte de semanas cotizadas)</li>
            <li>Doping: Se realiza un doping de 3 parámetros (Cocaína, Marihuana y Metanfetamina).</li>
            <li>Psicometría: Depende del puesto que vaya a cubrir el candidato, son las pruebas que se aplicarían (Cleaver, Allport, Kolb, Terman, Lifo, Kostick, RavenG, Gordon, IPV, 16 PFa, Moss y Zavic).</li>
        </ul>
    </li>
    <li>Se te otorga una garantía por puesto pagado. Los días de garantía podrán variar de acuerdo al puesto y el sueldo acordado.</li>
    <li>Las garantías se cubren con otro candidato, al cual se le generan los mismos exámenes que se le realizaron al primer candidato sin ningún costo.</li>
    <li>No hay devoluciones de dinero.</li>
</ol>
<p style="text-align: justify;">Las garantías serán válidas únicamente si:
    <ul style="list-style-type: disc; padding-left: 20px; text-align: justify;">
        <li>La factura se liquida en el tiempo acordado.</li>
        <li>Se cumple con las condiciones de trabajo ofrecidas en la entrevista, que no exista ningún cambio de actividades, sueldo, lugar de trabajo, prestaciones, etc.</li>
    </ul>
</p>
        <strong>ACEPTO TERMINOS Y CONDICIONES</strong>
    </p>
	<div class="form-check">
          <input type="checkbox" class="form-check-input" id="aceptoTerminos">
          <label class="form-check-label" for="aceptoTerminos">Acepto los términos</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="salirAviso" disabled>Continuar</button>
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
		$(document).on('click', '.english-version-link', function(e) {
    e.preventDefault(); // Evita que el enlace cambie de página

    // Realizar solicitud AJAX para cargar la versión en inglés
    $.ajax({
        url: "<?php echo site_url('Requisicion/vista_ingles'); ?>",
        method: "GET",
        success: function(response) {
            // Insertar el contenido de la versión en inglés en la sección
            $('#panel-agregar-candidato').html(response);
        },
        error: function(xhr, status, error) {
            // Manejar cualquier error que ocurra durante la solicitud AJAX
            console.error(xhr.responseText);
        }
    });
});
	$(document).ready(function () {
    // Mostrar el modal de aviso de privacidad al cargar la página
    $("#avisoPrivModal").modal('show');

    // Deshabilitar inicialmente el botón "Continuar"
    $("#salirAviso").prop("disabled", true);

    // Deshabilitar el botón de cierre del modal hasta que se acepten los términos
    $("#aceptoTerminos").change(function () {
      $("#closeModalBtn").prop("disabled", !$(this).prop("checked"));
      $("#salirAviso").prop("disabled", !$(this).prop("checked"));
    });

    // Habilitar o deshabilitar el botón "Continuar" según si se aceptan los términos
    $("#aceptoTerminos").change(function () {
      $("#salirAviso").prop("disabled", !$(this).prop("checked"));
    });

    // Cerrar el modal cuando se presiona "Continuar"
    $("#salirAviso").click(function () {
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
			//datos.append('horario', $('#horario').val());
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
			datos.append('version', 'espanol');
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

<script>
    $(document).ready(function () {
        $("#nombre").on("input", function () {
            validarCampo("nombre", "errornombre", "domicilio");
        });

        $("#domicilio").on("input", function () {
            validarCampo("domicilio", "errordomicilio","cp");
        });
				$("#cp").on("input", function () {
            validarCampo("cp", "errorcp","regimen");
        });
				$("#regimen").on("input", function () {
            validarCampo("regimen", "errorregimen","telefono");
        });
				$("#telefono").on("input", function () {
            validarCampo("telefono", "errortelefono","correo");
        });
				$("#correo").on("input", function () {
            validarCampo("correo", "errorcorreo","contacto");
        });
				$("#contacto").on("input", function () {
            validarCampo("contacto", "errorcontacto","rfc");
        });
				$("#rfc").on("input", function () {
            validarCampo("rfc", "errorrfc","forma_pago");
				});

				$("#forma_pago").on("change", function () {
            validarCampoSelect("forma_pago", "errorforma_pago", "metodo_pago");
        });
				$("#metodo_pago").on("change", function () {
            validarCampoSelect("metodo_pago", "errormetodo_pago", "uso_cfdi");
        });

				$("#uso_cfdi").on("input", function () {
            validarCampo("uso_cfdi", "erroruso_cfdi","puesto");
        });
				$("#puesto").on("input", function () {
            validarCampo("puesto", "errorpuesto","num_vacantes");
        });
				$("#num_vacantes").on("input", function () {
            validarCampo("num_vacantes", "errornum_vacantes","escolaridad");
        });
				
				// Nuevos campos
        $("#escolaridad").on("change", function () {
            validarCampoSelect("escolaridad", "errorescolaridad", "estatus_escolaridad");
        });

        $("#estatus_escolaridad").on("change", function () {
            validarCampoSelect("estatus_escolaridad", "errorestatus_escolaridad", "carrera"); 
        });
				$("#carrera").on("input", function () {
            validarCampo("carrera", "errorcarrera", "genero"); 
        });
				$("#genero").on("change", function () {
            validarCampoSelect("genero", "errorgenero", "civil"); 
        });
				$("#civil").on("change", function () {
            validarCampoSelect("civil", "errorcivil", "edad_minima"); 
        });
				$("#edad_minima").on("input", function () {
            validarCampo("edad_minima", "erroredad_minima", "edad_maxima"); 
        });
				$("#edad_maxima").on("input", function () {
            validarCampo("edad_maxima", "erroredad_maxima", "licencia"); 
        });
				$("#licencia").on("change", function () {
            validarCampoSelect("licencia", "errorlicencia", "tipo_licencia"); 
        });
				$("#tipo_licencia").on("input", function () {
            validarCampo("tipo_licencia", "errortipo_licencia", "discapacidad"); 
        });
				$("#discapacidad").on("change", function () {
            validarCampoSelect("discapacidad", "errordiscapacidad", "causa"); 
        });
				$("#causa").on("change", function () {
            validarCampoSelect("causa", "errorcausa", "residencia"); 
        });
				$("#residencia").on("input", function () {
            validarCampo("residencia", "errorresidencia", "jornada"); 
        });
				$("#jornada").on("change", function () {
            validarCampoSelect("jornada", "errorjornada", "tiempo_inicio"); 
        });
				$("#tiempo_inicio").on("input", function () {
            validarCampo("tiempo_inicio", "errortiempo_inicio", "tiempo_final"); 
        });
				$("#tiempo_final").on("input", function () {
            validarCampo("tiempo_final", "errortiempo_final", "descanso"); 
        });
				$("#descanso").on("input", function () {
            validarCampo("descanso", "errordescanso", "viajar"); 
        });
				$("#viajar").on("change", function () {
            validarCampoSelect("viajar", "errorviajar", "zona"); 
        });
				/*$("#horario").on("change", function () {
            validarCampoSelect("horario", "errorhorario", "zona"); 
        });*/
				$("#zona").on("input", function () {
            validarCampo("zona", "errorzona", "tipo_sueldo"); 
        });
				$("#tipo_sueldo").on("change", function () {
            validarCampoSelect("tipo_sueldo", "errortipo_sueldo", "sueldo_minimo"); 
        });
				$("#sueldo_minimo").on("input", function () {
					validarCampo('sueldo_minimo', 'errorsueldo_minimo', 'sueldo_maximo');
        });
				$("#sueldo_maximo").on("input", function () {
            validarCampo("sueldo_maximo", "errorsueldo_maximo", "sueldo_adicional"); 
        });
				$("#sueldo_adicional").on("change", function () {
            validarCampoSelect("sueldo_adicional", "errorsueldo_adicional", "tipo_pago"); 
        });
				$("#tipo_pago").on("change", function () {
            validarCampoSelect("tipo_pago", "errortipo_pago", "ley"); 
        });
				$("#ley").on("change", function () {
            validarCampoSelect("ley", "errorley", "experiencia"); 
        });
				$("#experiencia").on("input", function () {
            validarCampo("experiencia", "errorexperiencia", "actividades"); 
        });
				$("#actividades").on("input", function () {
            validarCampo("actividades", "erroractividades", " "); 
        });

				
				function validaredad(edad){
          if (edad_minima.length !== 2) {
               $("#" + errorId).text("Ingrese solo dos números para la edad mínima").css("color", "red");
            } else {
              $("#" + errorId).text("");
             }
						 if (edad_maxima.length !== 2) {
               $("#" + errorId).text("Ingrese solo dos números para la edad máxima").css("color", "red");
            } else {
              $("#" + errorId).text("");
             }
				}

       function validarCampoSelect(campo, errorId, siguienteCampo) {
            var valorCampo = $("#" + campo).val();

            if (valorCampo === "") {
                $("#" + siguienteCampo).prop("disabled", true);
                $("#" + errorId).text("Selecciona una opción").css("color", "red");
            } else {
                $("#" + siguienteCampo).prop("disabled", false);
                $("#" + errorId).text("");
            }
        }			

        function validarCampo(campo, errorId, siguienteCampo) {
            var valorCampo = $("#" + campo).val().trim();

            if (valorCampo === "") {
                $("#" + siguienteCampo).prop("disabled", true);
                $("#" + errorId).text("Este campo es obligatorio").css("color", "red");
            } else {
                $("#" + siguienteCampo).prop("disabled", false);
                $("#" + errorId).text("");
            }
						
        }
    
});
</script>
</body>
</html>