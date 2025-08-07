<div class="modal fade" id="avancesModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?php echo $translations['titulo_modal_avances'] ?><br><span
            class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="div_avances" class="escrolable"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="historialComentariosModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Historial de comentarios con respecto a: <br><span class="nombreRegistro"
            id="nombre_aspirante"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="div_historial_comentario" class="table-responsive"></div>
        <hr>
        <div class="row">
          <div class="col-12">
            <label for="comentario_bolsa">Registra un nuevo comentario o estatus *</label>
            <textarea class="form-control" name="comentario_bolsa" id="comentario_bolsa" rows="3"></textarea>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-12">
            <button type="button" class="btn btn-primary text-lg btn-block w-100" id="btnComentario">Guardar
              comentario</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm " data-dismiss="modal" aria-label="Cerrar">
          Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="historialModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Historial de movimientos del aspirante:<br><span class="nombreAspirante"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="div_historial_aspirante" class="table-responsive"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm " data-dismiss="modal" aria-label="Cerrar">
          Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="docsModalInterno" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Documentación del candidato: <span class="nombreCandidato"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <div id="tablaDocsInterno" class="text-center"></div><br><br>
          </div>
        </div>
        <!-- div class="row">
          <div class="col-md-6 text-center">
            <label>Selecciona el documento</label><br>
            <input type="file" id="documentoInterno" class="doc_obligado" name="documentoInterno"
              accept=".jpg, .png, .jpeg, .pdf"><br><br>
            <br>
          </div>
          <div class="col-md-6 text-center">
            <label>Nombre del Archivo *</label>
            <input name="nombre_archivoInterno" id="nombre_archivoInterno" class="form-control personal_obligado">
            <input type="hidden" name="employee_id" id="employee_id">
            <input type="hidden" id="nameCandidatoInterno" name="nameCandidatoInterno">
            <input type="hidden" id="origen" name="origen">

            <br>
          </div -->
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
      <div id="msj_error" class="alert alert-danger hidden"></div>
    </div>
    <div class="modal-footer">
      <Form method="POST" action="< ?php echo base_url('Candidato/downloadDocumentosPanelCliente'); ?>">
        <input type="hidden" id="idCandidatoDocsInterno" name="idCandidatoDocsInterno">

        <!--button type="submit" class="btn btn-primary">Descargar todos los documentos</button -->
      </form>

      <!-- button type="button" class="btn btn-success" onclick="subirDocInterno()">Subir</button -->
    </div>
  </div>
</div>

<!-- LISTA DE DOCUMENTOS (versión mejorada) -->
<div class="modal fade" id="modalArchivos" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content shadow-lg">

      <!-- encabezado ---------------------------------------------------- -->
      <div class="modal-header bg-primary text-white py-2">
        <h5 class="modal-title mb-0">
          <i class="fas fa-folder-open mr-2"></i> Documentos del aspirante
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- cuerpo -------------------------------------------------------- -->
      <div class="modal-body p-0">

        <!-- tabla responsiva con borde interno -->
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0" id="tablaArchivos">
            <thead class="table-light">
              <tr>
                <th><i class="fas fa-file-alt mr-1"></i> Nombre</th>
                <th class="text-center" style="width:25%">Acción</th>
              </tr>
            </thead>
            <tbody>
              <!-- se llena por JS -->
            </tbody>
          </table>
        </div>

        <!-- mensaje "sin documentos" -->
        <div id="msgSinDocs" class="d-none text-muted text-center py-4">
          <i class="fas fa-info-circle fa-lg mb-2 d-block"></i>
          Aún no hay documentos cargados
        </div>

      </div><!-- /.modal-body -->

      <!-- pie opcional (puedes removerlo si no lo usas) -->
      <div class="modal-footer py-2">
        <button type="button" class="btn btn-danger btn-sm " data-dismiss="modal" aria-label="Cerrar">
          Cerrar
        </button>
      </div>

    </div>
  </div>
</div>


<!-- VISOR DE DOCUMENTOS -->
<div class="modal fade" id="modalVisor" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content h-100">
      <!-- encabezado -->
      <div class="modal-header py-2">
        <h5 class="modal-title mb-0" id="tituloVisor"></h5>
        <button type="button" class="close" data-dismiss="modal">x</button>
      </div>

      <!-- cuerpo: 80 vh, flex para que el contenido se expanda -->
      <div class="modal-body p-0 d-flex" style="height:80vh;">
        <!-- aquí insertaremos <iframe>, <img> o <video> -->
        <div id="visorWrap" class="w-100 h-100 d-flex align-items-center justify-content-center"></div>
      </div>
    </div>
  </div>
</div>