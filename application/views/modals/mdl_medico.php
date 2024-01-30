<div class="modal fade" id="newModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Registro Nuevo de Examen Médico </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning text-center" role="alert">
          Este formulario tiene como objetivo registrar a alguna persona o cliente para realizarle un examen médico que NO INCLUYE estudio socioeconómico. Si requiere examen antidoping, este deberá ser registrado de forma normal en el módulo de Doping del sistema.
        </div>
        <form id="form_registro">
          <div class="row mb-3">
            <div class="col-12">
              <label>Cliente *</label>
              <select class="form-control" name="cliente_registro" id="cliente_registro">
                <option value="">Selecciona</option>
                <option value="0">N/A</option>
                <?php
                foreach ($clientes as $cl) { ?>
                  <option value="<?php echo $cl->id; ?>"><?php echo $cl->nombre; ?></option>
                <?php
                } ?>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-4">
              <label>Nombre(s) *</label><br>
              <input class="form-control" type="text" name="nombre_registro" id="nombre_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
            <div class="col-4">
              <label>Primer apellido *</label><br>
              <input class="form-control" type="text" name="paterno_registro" id="paterno_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
            <div class="col-4">
              <label>Segundo apellido </label><br>
              <input class="form-control" type="text" name="materno_registro" id="materno_registro" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-4">
              <label>Genero *</label><br>
              <select name="genero_registro" id="genero_registro" class="form-control">
                <option value="">Selecciona</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select>
            </div>
            <div class="col-4">
              <label>Fecha de nacimiento *</label><br>
              <input class="form-control tipo_fecha" type="text" name="fecha_nacimiento_registro" id="fecha_nacimiento_registro" placeholder="dd/mm/yyyy">
            </div>
            <div class="col-4">
              <label>Teléfono de emergencia *</label><br>
              <input class="form-control" type="text" name="telefono_emergencia_registro" id="telefono_emergencia_registro">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-4">
              <label>Avisar a *</label><br>
              <input class="form-control" type="text" name="avisar_registro" id="avisar_registro">
            </div>
            <div class="col-4">
              <label>Estado civil *</label><br>
              <select name="civil_registro" id="civil_registro" class="form-control">
                <option value="">Selecciona</option>
                <?php
                foreach ($civiles as $civ) { ?>
                  <option value="<?php echo $civ->nombre; ?>"><?php echo $civ->nombre; ?></option>
                <?php
                } ?>
              </select>
            </div>
            <div class="col-4">
              <label>Escolaridad *</label><br>
              <select class="form-control" name="escolaridad_registro" id="escolaridad_registro">
                <option value="">Selecciona</option>
                <?php
                foreach ($escolaridades as $esc) { ?>
                  <option value="<?php echo $esc->id; ?>"><?php echo $esc->nombre; ?></option>
                <?php
                } ?>
              </select>
            </div>
          </div>
        </form>
        <div id="msj_error" class="alert alert-danger hidden"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="nuevoRegistro()">Registrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="analisisModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Análisis Médico:<br><span name="nombreCandidato" id="nombreCandidato"></span> </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="alert alert-info text-center" role="alert">
          Ficha de Identificacion
        </div>
        <form id="identificacion">
          <div class="row mb-3">
            <div class="col-4">
              <label>Genero *</label><br>
              <select name="genero" id="genero" class="form-control">
                <option value="">Selecciona</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select>
            </div>
            <div class="col-4">
              <label>Fecha de nacimiento *</label><br>
              <input class="form-control tipo_fecha" type="text" name="fecha_nacimiento" id="fecha_nacimiento" placeholder="dd/mm/yyyy">
            </div>
            <div class="col-4">
              <label>Teléfono de emergencia *</label><br>
              <input class="form-control" type="text" name="telefono_emergencia" id="telefono_emergencia">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-4">
              <label>Avisar a *</label><br>
              <input class="form-control" type="text" name="avisar" id="avisar">
            </div>
            <div class="col-4">
              <label>Estado civil *</label><br>
              <select name="civil" id="civil" class="form-control">
                <option value="">Selecciona</option>
                <?php
                foreach ($civiles as $civ) { ?>
                  <option value="<?php echo $civ->nombre; ?>"><?php echo $civ->nombre; ?></option>
                <?php
                } ?>
              </select>
            </div>
            <div class="col-4">
              <label>Escolaridad *</label><br>
              <select class="form-control" name="escolaridad" id="escolaridad">
                <option value="">Selecciona</option>
                <?php
                foreach ($escolaridades as $esc) { ?>
                  <option value="<?php echo $esc->id; ?>"><?php echo $esc->nombre; ?></option>
                <?php
                } ?>
              </select>
            </div>
          </div>
          <div class="text-center mb-3">

            <br>
            <button type="button" class="btn btn-success" onclick="guardarFichaIdentificacion()">Guardar</button>
            <br>
            <br>
          </div>
          <div id="msj_error_ficha" class="alert alert-danger hidden msj_error"></div>
        </form>

        <div class="alert alert-info text-center" role="alert">
          Antecedentes Heredo-Familiares
        </div>
        <form id="antecedentes_familiares">
          <div class="row mb-3">
            <div class="col-4">
              <label>Diabetes *</label><br>
              <select class="form-control" name="diabetes" id="diabetes">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-4">
              <label>Cancer *</label><br>
              <select class="form-control" name="cancer" id="cancer">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-4">
              <label>Hipertension *</label><br>
              <select class="form-control" name="hipertension" id="hipertension">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-4">
              <label>Cardiopatias *</label><br>
              <select class="form-control" name="cardiopatias" id="cardiopatias">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-4">
              <label>Enfermedades pulmonares *</label><br>
              <select class="form-control" name="pulmonares" id="pulmonares">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-4">
              <label>Enfermedades renales *</label><br>
              <select class="form-control" name="renales" id="renales">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-4">
              <label>Psiquiatrica *</label><br>
              <select class="form-control" name="psiquiatrica" id="psiquiatrica">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-8">
              <label>En caso de haber ¿Qué enfermedades menciona el candidato? *</label><br>
              <input class="form-control" type="text" name="cual" id="cual">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-4 offset-4">
              <label>Tipo de sangre *</label><br>
              <select class="form-control" name="sangre" id="sangre">
                <option value="">Selecciona</option>
                <option value="O positivo">O positivo</option>
                <option value="O negativo">O negativo</option>
                <option value="A positivo">A positivo</option>
                <option value="A negativo">A negativo</option>
                <option value="B positivo">B positivo</option>
                <option value="B negativo">B negativo</option>
                <option value="AB positivo">AB positivo</option>
                <option value="AB negativo">AB negativo</option>
                <option value="Desconocido">Desconocido</option>
              </select>
            </div>
          </div>

          <div class="text-center mb-3">

            <br>
            <button type="button" class="btn btn-success" onclick="guardarAntecedentesHeredoFamiliares()">Guardar</button>
            <br>
            <br>
          </div>
          <div id="msj_error_antecedentes_heredo" class="alert alert-danger hidden msj_error"></div>
        </form>

        <div class="alert alert-info text-center" role="alert">
          Antecedentes no patologicos
        </div>
        <form id="antecedentes_no_patologicos">
          <div class="row mb-3">

            <div class="col-3">
              <label>Tabaco *</label><br>
              <select class="form-control" name="tabaco" id="tabaco">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>

            </div>
            <div class="col-3">
              <label>Cantidad *</label><br>
              <input class="form-control" type="number" name="tabaco_cantidad" id="tabaco_cantidad">
            </div>
            <div class="col-6">
              <label>Frecuencia *</label><br>
              <select class="form-control" name="tabaco_frecuencia" id="tabaco_frecuencia">
                <option value="N/A">N/A</option>
                <option value="Diariamente">Diariamente</option>
                <option value="Semanalmente">Semanalmente</option>
                <option value="Mensualmente">Mensualmente</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-3">
              <label>Alcohol *</label><br>
              <select class="form-control" name="alcohol" id="alcohol">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-3">
              <label>Cantidad *</label><br>
              <input class="form-control" type="number" name="alcohol_cantidad" id="alcohol_cantidad">
            </div>
            <div class="col-6">
              <label>Frecuencia *</label><br>
              <select class="form-control" name="alcohol_frecuencia" id="alcohol_frecuencia">
                <option value="N/A">N/A</option>
                <option value="Diariamente">Diariamente</option>
                <option value="Semanalmente">Semanalmente</option>
                <option value="Mensualmente">Mensualmente</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-3">
              <label>Drogas *</label><br>
              <select class="form-control" name="drogas" id="drogas">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-3">
              <label>Tipo *</label><br>
              <input class="form-control" type="text" name="drogas_tipo" id="drogas_tipo">
            </div>
            <div class="col-3">
              <label>Deporte *</label><br>
              <select class="form-control" name="deporte" id="deporte">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-3">
              <label>Cual *</label><br>
              <input class="form-control" type="text" name="deporte_cual" id="deporte_cual">
            </div>
          </div>
          <div class="row mb-3">

            <div class="col-4 offset-4">
              <label>Alimentacion *</label><br>
              <select class="form-control" name="alimentacion" id="alimentacion">
                <option value="">Selecciona</option>
                <option value="Buena">Buena</option>
                <option value="Mala">Mala</option>
                <option value="Regular">Regular</option>
              </select>
            </div>

          </div>

          <div class="text-center mb-3">

            <br>
            <button type="button" class="btn btn-success" onclick="guardarAntecedentesNoPatologicos()">Guardar</button>
            <br>
            <br>
          </div>
          <div id="msj_error_antecedentes_no_patologicos" class="alert alert-danger hidden msj_error"></div>
        </form>

        <div class="alert alert-info text-center" role="alert">
          Antecedentes patologicos personales
        </div>

        <form id="antecedentes_patologicos">
          <div class="row mb-3">



            <div class="col-3">
              <label>Quirurgicos *</label><br>
              <select class="form-control" name="quirurgicos" id="quirurgicos">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-3">
              <label>Hace cuanto *</label><br>
              <input class="form-control" type="text" name="quirurgicos_hace_cuanto" id="quirurgicos_hace_cuanto">
            </div>
            <div class="col-6">
              <label>Cual *</label><br>
              <input class="form-control" type="text" name="quirurgicos_cual" id="quirurgicos_cual">
            </div>



          </div>

          <div class="row mb-3">
            <div class="col-3">
              <label>Internamientos *</label><br>
              <select class="form-control" name="internamientos" id="internamientos">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-3">
              <label>Hace cuanto *</label><br>
              <input class="form-control" type="text" name="internamientos_hace_cuanto" id="internamientos_hace_cuanto">
            </div>
            <div class="col-6">
              <label>Por que *</label><br>
              <input class="form-control" type="text" name="internamientos_porque" id="internamientos_porque">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-3">
              <label>Transfusiones *</label><br>
              <select class="form-control" name="transfusiones" id="transfusiones">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-3">
              <label>Hace cuanto *</label><br>
              <input class="form-control" type="text" name="transfusiones_hace_cuanto" id="transfusiones_hace_cuanto">
            </div>
            <div class="col-6">
              <label>Por que *</label><br>
              <input class="form-control" type="text" name="transfusiones_porque" id="transfusiones_porque">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-3">
              <label>Fracturas *</label><br>
              <select class="form-control" name="fracturas" id="fracturas">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-3">
              <label>Esguinces *</label><br>
              <select class="form-control" name="esguinces" id="esguinces">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-3">
              <label>Luxaciones *</label><br>
              <select class="form-control" name="luxaciones" id="luxaciones">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-3">
              <label>Traumatismo *</label><br>
              <select class="form-control" name="traumatismo" id="traumatismo">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">

            <div class="col-3">
              <label>Hernias *</label><br>
              <select class="form-control" name="hernias" id="hernias">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>

            <div class="col-3">
              <label>Lesiones en columna *</label><br>
              <select class="form-control" name="lesiones_columna" id="lesiones_columna">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>

            <div class="col-3">
              <label>Alergias *</label><br>
              <select class="form-control" name="alergias" id="alergias">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>

            <div class="col-3">
              <label>¿A qué es alérgico? *</label><br>
              <input class="form-control" type="text" name="alergias_aque" id="alergias_aque">
            </div>
          </div>
          <div class="text-center mb-3">

            <br>
            <button type="button" class="btn btn-success" onclick="guardarAntecedentesPatologicosPersonales()">Guardar</button>
            <br>
            <br>
          </div>
          <div id="msj_error_antecedentes_patologicos" class="alert alert-danger hidden msj_error"></div>
        </form>

        <div class="alert alert-info text-center" role="alert">
          Chequeo general
        </div>

        <form id="chequeo">
          <div class="row mb-3">

            <div class="col-3">
              <label>Estatura *</label><br>
              <input class="form-control" type="number" name="estatura" id="estatura">
            </div>

            <div class="col-3">
              <label>Peso *</label><br>
              <input class="form-control" type="number" name="peso" id="peso">
            </div>

            <div class="col-3">
              <label>IMC *</label><br>
              <input class="form-control" type="number" name="imc" id="imc">
            </div>

            <div class="col-3">
              <label>Gasa Muscular *</label><br>
              <input class="form-control" type="number" name="grasa_muscular" id="grasa_muscular">
            </div>

          </div>

          <div class="row mb-3">

            <div class="col-3">
              <label>Musculo *</label><br>
              <input class="form-control" type="number" name="musculo" id="musculo">
            </div>

            <div class="col-3">
              <label>Calorias *</label><br>
              <input class="form-control" type="number" name="calorias" id="calorias">
            </div>

            <div class="col-3">
              <label>Edad Metabolica *</label><br>
              <input class="form-control" type="number" name="edad_metabolica" id="edad_metabolica">
            </div>

            <div class="col-3">
              <label>Grasas Visceral *</label><br>
              <input class="form-control" type="number" name="grasa_visceral" id="grasa_visceral">
            </div>

          </div>

          <div class="row mb-3">

            <div class="col-3">
              <label>Presion Arterial *</label><br>
              <input class="form-control" type="text" name="presion_arterial" id="presion_arterial">
            </div>

            <div class="col-3">
              <label>Frecuencia Cardiaca *</label><br>
              <input class="form-control" type="number" name="frecuencia_cardiaca" id="frecuencia_cardiaca">
            </div>

            <div class="col-3">
              <label>Glucosa</label><br>
              <input class="form-control" type="number" name="glucosa" id="glucosa">
            </div>

          </div>
          <div class="text-center mb-3">

            <br>
            <button type="button" class="btn btn-success" onclick="guardarChequeoGeneral()">Guardar</button>
            <br>
            <br>
          </div>
          <div id="msj_error_chequeo" class="alert alert-danger hidden msj_error"></div>
        </form>

        <div class="alert alert-info text-center" role="alert">
          Vision
        </div>

        <form id="vision">
          <div class="row mb-3">
            <div class="col-3">
              <label>Ojo Derecho *</label><br>
              <input class="form-control" type="text" name="ojo_derecho" id="ojo_derecho">
            </div>
            <div class="col-3">
              <label>Ojo Izquierdo *</label><br>
              <input class="form-control" type="text" name="ojo_izquierdo" id="ojo_izquierdo">
            </div>
            <div class="col-3">
              <label>Colores *</label><br>
              <select class="form-control" name="colores" id="colores">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <div class="col-3">
              <label>Usa lentes *</label><br>
              <select class="form-control" name="lentes" id="lentes">
                <option value="">Selecciona</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
          </div>
          <div class="text-center mb-3">

            <br>
            <button type="button" class="btn btn-success" onclick="guardarVision()">Guardar</button>
            <br>
            <br>
          </div>
          <div id="msj_error_vision" class="alert alert-danger hidden msj_error"></div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="conclusionesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Conclusiones del candidato:<br><span name="candidato_nombre" id="candidato_nombre"></span> </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="concluir">
          <div class="row">
            <div class="col-md-12">
              <label>Descripción de la persona *</label>
              <textarea class="form-control" name="descripcion" id="descripcion" rows="4"></textarea>
              <br>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Conclusión *</label>
              <textarea class="form-control" name="conclusion" id="conclusion" rows="4"></textarea>
              <br>
            </div>
          </div>
        </form>
        <div id="msj_error_conclusion" class="alert  alert-danger hidden msj_error"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="guardarConcluir()">Guardar</button>
      </div>
    </div>
  </div>
</div>
<script>
  $("#newModal").on("hidden.bs.modal", function() {
    $("#newModal input, #newModal select").val('');
    $("#newModal #msj_error").css('display', 'none');
  });
  $("#analisisModal").on("hidden.bs.modal", function() {
    $("#analisisModal input, #analisisModal select, #analisisModal textarea").val('');
    $("#analisisModal .msj_error").css('display', 'none');
  });
  $("#conclusionesModal").on("hidden.bs.modal", function() {
    $("#conclusionesModal textarea").val('');
    $("#conclusionesModal .msj_error").css('display', 'none');
  });
</script>