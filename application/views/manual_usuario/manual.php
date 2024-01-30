<div class="container-fluid">

<h1 class="mb-5">Manual de usuario</h1>

<!-- <input type="text" class="form-control" id="msgNotificacion" name="msgNotificacion">
<button type="button" onclick="enviarNotificacion()">Enviar</button> -->
<div class="accordion" id="accordion">
  <div class="card">
    <div class="card-header bg-secondary" id="headingOne">
      <h2 class="mb-0">
        <button class="btn bg-secondary btn-block text-left text-lg text-white" type="button" data-toggle="collapse" data-target="#collapseHead1" aria-expanded="true" aria-controls="collapseHead1">
          Reclutamiento
        </button>
      </h2>
    </div>

    <div id="collapseHead1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        <!-- Inicio collapse anidado -->
        <div class="accordion" id="accordionChild1">
          <div class="card">
            <div class="card-header" id="headingChild1">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left text-lg" type="button" data-toggle="collapse" data-target="#collapseChild1" aria-expanded="true" aria-controls="collapseChild1">
                  Descripción general del módulo y del proceso de reclutamiento
                </button>
              </h2>
            </div>
            <div id="collapseChild1" class="collapse" aria-labelledby="headingChild1" data-parent="#accordionChild1">
              <div class="card-body">
                <p class="mb-5 text-justify">El proceso de reclutamiento está compuesto por 4 apartados o submódulos: Requisiciones, Bolsa de Trabajo, En proceso y Finalizados, ubicados en el menú.</p>
                <p class="mb-5 text-justify">Las Requisiciones son las solicitudes que hacen los clientes que necesitan personal en sus empresas de acuerdo a varios parámetros. La Bolsa de Trabajo es el apartado para el manejo y control de aspirantes o intersados en tener un trabajo. El estatus de En proceso contiene el conjunto de acciones que realizan los reclutadores sobre los aspirantes de la Bolsa de Trabajo y las Requisiciones. Y en el apartado de Finalizados se tienen aquellas Requisiciones que finalizaron, terminaron o cancelaron.</p>
                <img src="<?php echo base_url().'manuales/usuario/reclutamiento/menu.png'?>" class="mx-auto d-block" alt="menu">
                <p class="mt-5 mb-5 text-justify">Una manera de definir el proceso de reclutamiento es la captación de aspirantes con su información vital para ser asignados a una requisición con datos necesarios como el puesto, número de vacantes, domicilio del trabajo, etc. </p>
                <p class="mb-5 text-justify">Una vez asignados los aspirantes a una requisición, deben ser trasladados al estatus "en proceso" para que el reclutador pueda registrar su labor para cada aspirante. Estos registros al aspirante son acciones que se hacen sobre el aspirante, como "Contacto al aspirante realizado", "Se informó al cliente del aspirante", "Finaliza el proceso del aspirante con ESE", etc. </p>
                <p class="mb-5 text-justify">Si el proceso del aspirante es favorable, el reclutador registrará la acción de "Finaliza el proceso del aspirante con ESE" para posteriormente hacer un último registro que lo llevará al módulo de Clientes, concretamente al cliente RODI RECLUTAMIENTO, donde las y los analistas ejecutarán el proceso de estudio socioeconómico (ESE) sobre ese aspirante en cuestión y que pasa a ser considerado como "candidato".</p>
                <p class="mb-5 text-justify">Mientras el ahora candidato es procesado para su ESE, el reclutador repite el proceso para cada aspirante de cada requisición al que le fue asignado. Una vez que un candidato que previamente fue un aspirante o que vino del área de Reclutamiento, el estatus de este candidato en el apartado de "En proceso" cambia a finalizado y será posible registrar su información de ingreso al empleo que se definió en la requisición al que fue asignado.</p>
                <p class="mb-5 text-justify">Se podría decir que el proceso de reclutar a un aspirante termina cuando pasa a ser candidato, se le ha finalizado el ESE correspondiente y se han registrado los datos de ingreso a su empleo.</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Fin collapse anidado -->
        <!-- Inicio collapse anidado -->
        <div class="accordion" id="accordionChild2">
          <div class="card">
            <div class="card-header" id="headingChild2">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left text-lg" type="button" data-toggle="collapse" data-target="#collapseChild2" aria-expanded="true" aria-controls="collapseChild2">
                  Requisiciones
                </button>
              </h2>
            </div>
            <div id="collapseChild2" class="collapse" aria-labelledby="headingChild2" data-parent="#accordionChild2">
              <div class="card-body">
                <ul>
                  <li>
                    <a class="btn-link" data-toggle="collapse" href="#collapseVistaGeneral" role="button" aria-expanded="false" aria-controls="collapseVistaGeneral">Vista general</a>
                  </li>
                  <li>
                    <a class="btn-link" data-toggle="collapse" href="#collapseTarjetaRequisicion" role="button" aria-expanded="false" aria-controls="collapseTarjetaRequisicion">Tarjeta de requisición</a>
                  </li>
                  <li>
                    <a class="btn-link" data-toggle="collapse" href="#collapseRegistroRequisicion" role="button" aria-expanded="false" aria-controls="collapseRegistroRequisicion">Registrar requisición</a>
                  </li>
                  <li>
                    <a class="btn-link" data-toggle="collapse" href="#collapseEditarRequisicion" role="button" aria-expanded="false" aria-controls="collapseEditarRequisicion">Editar requisición</a>
                  </li>
                  <li>
                    <a class="btn-link" data-toggle="collapse" href="#collapseVerRequisicion" role="button" aria-expanded="false" aria-controls="collapseVerRequisicion">Ver detalles de la requisición</a>
                  </li>
                  <li>
                    <a class="btn-link" data-toggle="collapse" href="#collapseIniciarRequisicion" role="button" aria-expanded="false" aria-controls="collapseIniciarRequisicion">Iniciar proceso de la requisición</a>
                  </li>
                  <li>
                    <a class="btn-link" data-toggle="collapse" href="#collapsePDFRequisicion" role="button" aria-expanded="false" aria-controls="collapsePDFRequisicion">Descargar PDF de los detalles de la requisición</a>
                  </li>
                  <li>
                    <a class="btn-link" data-toggle="collapse" href="#collapseResultadosRequisicion" role="button" aria-expanded="false" aria-controls="collapseResultadosRequisicion">Ver/Descargar resultados de los candidatos de la requisición</a>
                  </li>
                  <li>
                    <a class="btn-link" data-toggle="collapse" href="#collapseEliminarRequisicion" role="button" aria-expanded="false" aria-controls="collapseResultadosRequisicion">Eliminar requisición</a>
                  </li>
                </ul>
                <div class="collapse" id="collapseVistaGeneral">
                  <div class="alert alert-info text-center">Vista general</div>
                  <p class="mb-5 text-justify">En el apartado de Requisiciones se visualizan los detalles de la información que las componen, se pueden aplicar algunas acciones de acuerdo a las necesidades y se permite aplicar un orden de forma personal por cada usuario.</p>
                  <img src="<?php echo base_url().'manuales/usuario/reclutamiento/menu_requisiciones.png'?>" class="mx-auto d-block">
                  <p class="mt-5 mb-5 text-justify">En la siguiente imagen se muestra la vista general del apartado de Requisiciones, donde se puede ver la parte de los botones de registro y asignacion, los campos de filtros para organizar las requisiciones y las tarjetas de las requisiciones, donde cada una representa una requisición.</p>
                  <img src="<?php echo base_url().'manuales/usuario/reclutamiento/requisiciones_vista.png'?>" class="mx-auto d-block" width="70%">
                </div>

                <div class="collapse" id="collapseRegistroRequisicion">
                  <div class="alert alert-info text-center">Registrar requisición</div>
                  <p class="mt-5 mb-5 text-justify" id="nuevaRequisicion">Para agregar una nueva requisición existen 2 formas:</p>
                  <ul>
                    <li class="mb-5"><b>COMPLETA:</b> Se registra de forma externa desde la dirección <a href="https://requisicion.rodi.com.mx/" target="_blank">https://requisicion.rodi.com.mx/</a>. Este formulario posee todos los campos que comprende una requisición. Este link es compartido a los clientes para que puedan hacer la solicitud de personal para sus puestos vacantes. A pesar de que el formulario posee todos los campos que comprenden una requisición, no todos son obligatorios. Los campos obligatorios se representan con un asterisco "*".</li>
                    <div class="row">
                      <div class="col-6"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/requisicion_completa_1.png'?>"width="100%"></div>
                      <div class="col-6"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/requisicion_completa_2.png'?>"width="100%"></div>
                    </div>
                    <div class="row">
                      <div class="col-6"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/requisicion_completa_3.png'?>"width="100%"></div>
                      <div class="col-6"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/requisicion_completa_4.png'?>"width="100%"></div>
                    </div>
                    <li class="mt-5 mb-5"><b>EXPRESS:</b> Es una forma más rápida de registrar una requisición ya que el formulario solo tiene los campos necesarios para un registro básico. Este formulario se ubica dando clic al botón "Nueva requisición" ubicado dentro de la vista del apartado de Requisiciones: <img src="<?php echo base_url().'manuales/usuario/reclutamiento/btn_nueva_requisicion.png'?>" width="10%"><br>Para registrar una requisición EXPRESS se deberán llenar los campos obligatorios de cada paso del formulario.</li>
                    <div class="row">
                      <div class="col-6"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/requisicion_express_1.png'?>"width="100%"></div>
                      <div class="col-6"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/requisicion_express_2.png'?>"width="100%"></div>
                    </div>
                    <div class="row">
                      <div class="col-6 offset-4"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/requisicion_express_3.png'?>" width="100%"></div>
                    </div>
                  </ul>
                </div>

                <div class="collapse" id="collapseTarjetaRequisicion">
                  <div class="alert alert-info text-center">Tarjeta de requisición</div>
                  <p class="mt-5 mb-5 text-justify" id="tarjetaRequisicion">En la siguiente imagen se presentan dos tarjetas diferentes, representando una requisición cada una. A continuación se definen las partes de la tarjeta de acuerdo a la numeración de la imagen:</p>
                  <img src="<?php echo base_url().'manuales/usuario/reclutamiento/requisicion.png'?>" class="mx-auto d-block">
                  <ul>
                    <li class="mt-5 mb-5">1) Indica el número de la requisición y el nombre de la empresa o persona que lo solicita.</li>
                    <li class="mb-5">2) Indica el puesto que es solicitado para la vacante.</li>
                    <li class="mb-5">3) Muestra el número de vacantes solicitados.</li>
                    <li class="mb-5">4) Muestra los datos de contacto de la persona o empresa solicitante, como es el propio nombre, teléfono y correo electrónico.</li>
                    <li class="mb-5">5) Indica el tipo de requisición, si es <b>COMPLETA</b> o si es <b>EXPRESS</b>.</li>
                    <li class="mb-5">6) Muestra el estatus de la requisición. "En espera" indica que la requisición no ha entrado a proceso de reclutamiento; el estatus "En proceso de reclutamiento" indica que está siendo trabajada por reclutamiento y este estatus es resaltado con el color azul para diferenciarlo ante las requisiciones "En espera".</li>
                    <li class="mb-5">7) Esta línea indica si la requisición ha sido modificada por alguien o no ha sufrido cambios.</li>
                    <li class="mb-5">8) En esta parte se encuentran los usuarios (reclutadores) que fueron asignados a la requisición. </li>
                    <li class="mb-5">Por último, los botones encerrados en el recuadro rojo, representan diferentes acciones sobre la requisición: Editar, ver detalles, Iniciar proceso, Descargar requisición en PDF, Ver los resultados de los candidatos y Eliminar requisición, respectivamente.</li>
                  </ul>
                </div>
                
                <div class="collapse" id="collapseEditarRequisicion">
                  <div class="alert alert-info text-center">Editar requisición</div>
                  <p class="mt-5 mb-5 text-justify" id="editarRequisicion">Primeramente, se debe mencionar que las requisiciones del tipo "COMPLETA" tendrán esta acción bloqueada para salvaguardar la información proporcionada del cliente, por el contrario de las requisiciones del tipo "EXPRESS" que pueden ser modificadas en cualquier momento. Si se requiere un cambio en una requisición del tipo "COMPLETA", se deberá solicitar al administrador del sistema.<br>Para realizar esta acción se debe dar clic en el botón <img src="<?php echo base_url().'manuales/usuario/reclutamiento/btn_editar_requisicion.png' ?>" width="3%"> que se encuentra en la tarjeta de requisición. <br>El formulario para editar la requisición esta segmentado y cada parte tiene su propio botón para guardar por separado. Si se desea regresar al listado de tarjetas de las requisiciones, se debe dar clic en el botón <img src="<?php echo base_url().'manuales/usuario/reclutamiento/btn_regresar_requisicion.png' ?>" width="10%"> ubicado en la parte inferior derecha de la pantalla.</p>
                  <div class="row">
                    <div class="col-6"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/editar_requisicion_1.png'?>" width="100%"></div>
                    <div class="col-6"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/editar_requisicion_2.png'?>" width="100%"></div>
                  </div>
                  <div class="row">
                    <div class="col-6"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/editar_requisicion_3.png'?>" width="100%"></div>
                    <div class="col-6"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/editar_requisicion_4.png'?>" width="100%"></div>
                  </div> 
                </div>
                
                <div class="collapse" id="collapseVerRequisicion">
                  <div class="alert alert-info text-center">Ver detalles de la requisición</div>
                  <p class="mt-5 mb-5 text-justify" id="detallesRequisicion">Para ver los detalles de la requisición se debe dar clic en el botón <img src="<?php echo base_url().'manuales/usuario/reclutamiento/btn_detalles_requisicion.png' ?>" width="3%">. La información está organizada por secciones como se muestra en el área marcada en la siguiente imagen. Si se desea regresar al listado de tarjetas de requisiciones se debe dar clic al botón <img src="<?php echo base_url().'manuales/usuario/reclutamiento/btn_regresar_requisicion.png' ?>" width="10%"> ubicado en la parte inferior derecha de la pantalla.</p>
                  <div class="row">
                    <div class="col-12"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/detalles_requisicion_1.png'?>" width="70%" class="mx-auto d-block"></div>
                  </div>
                </div>

                <div class="collapse" id="collapseIniciarRequisicion">
                  <div class="alert alert-info text-center">Iniciar proceso de la requisición</div>
                  <p class="mt-5 mb-5 text-justify" id="detallesRequisicion">Esta acción permite poner la requisición en estatus "En proceso de reclutamiento" cuando está en estatus "En espera", lo cual indicará que la requisición estará disponible en el apartado del menú "En proceso" para que pueda ser trabajada.<br> Para esta acción se debe dar clic en el botón <img src="<?php echo base_url().'manuales/usuario/reclutamiento/btn_iniciar_requisicion.png' ?>" width="3%">. Al hacer clic se abrirá una ventana para confirmar esta acción y pasará al estatus antes mencionado.</p>
                  <div class="row">
                    <div class="col-12"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/confirmar_inicio_requisicion.png'?>" width="50%" class="mx-auto d-block"></div>
                  </div>
                </div>
                
                <div class="collapse" id="collapsePDFRequisicion">
                  <div class="alert alert-info text-center">Descargar PDF de la requisición</div>
                  <p class="mt-5 mb-5 text-justify" id="detallesRequisicion">La información contenida en el PDF de la requisición a descargar puede variar dependiendo del rol que se tenga dentro del sistema. Por ejemplo: los roles asociados a reclutamiento verán resumida la información, ya que solo necesitan disponer de cierta información. <br> Para esta acción se debe dar clic en el botón <img src="<?php echo base_url().'manuales/usuario/reclutamiento/btn_pdf_requisicion.png' ?>" width="3%">. Si cuenta con internet, el documento se descargará en breve.</p>
                </div>

                <div class="collapse" id="collapseResultadosRequisicion">
                  <div class="alert alert-info text-center">Ver/Descargar resultados de la requisición</div>
                  <p class="mt-5 mb-5 text-justify" id="detallesRequisicion">Esta acción mostrarán los resultados de los estudios y exámenes de los candidatos que fueron asignados previamente a la requisición y si es necesario poder descargarlos. Se debe tomar en cuenta que esta acción estara deshabilitada mientras la requisición esté en estatus "En espera".<br> Para ejecutar la acción se debe dar clic en el botón <img src="<?php echo base_url().'manuales/usuario/reclutamiento/btn_resultados_requisicion.png' ?>" width="3%">, se abrirá una ventana donde se muestran o mostrarán el listado de los candidatos a los que se les finalizaron sus estudios y exámenes, siendo que el ESE y Doping tendrán un color resaltado de acuerdo al resultado de los mismos; el examen médico y la psicometría no poseen esta caracterísitica .</p>
                  <div class="row">
                    <div class="col-12"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/requisicion_resultados.png'?>" width="70%" class="mx-auto d-block"></div>
                  </div>
                </div>
                
                <div class="collapse" id="collapseEliminarRequisicion">
                  <div class="alert alert-info text-center">Eliminar requisición</div>
                  <p class="mt-5 mb-5 text-justify" id="detallesRequisicion"><br> Para ejecutar la acción se debe dar clic en el botón <img src="<?php echo base_url().'manuales/usuario/reclutamiento/btn_eliminar_requisicion.png' ?>" width="3%"> y se abrirá una ventana para confirmar la eliminación, requiriendo un motivo o razón. Se debe considerar que este botón estará deshabilitado si la requisición está en estatus "En proceso de reclutamiento" y para eliminarla o cancelarla se debe ejecutar desde el apartado "En proceso" del menú de Reclutamiento.</p>
                  <div class="row">
                    <div class="col-12"><img src="<?php echo base_url().'manuales/usuario/reclutamiento/confirmar_eliminar_requisicion.png'?>" width="70%" class="mx-auto d-block"></div>
                  </div>
                </div>


                  
                <p class="mt-5 mb-5 text-justify">Para eliminar un usuario de la requisicion solo debe hacer clic en el botón rojo que esta junto a su nombre <img src="<?php echo base_url().'manuales/usuario/reclutamiento/btn_eliminar_usuario_requisicion.png' ?>" width="10%"> y se abrirá una ventana para confirmar la eliminación. </p>
                    <img src="<?php echo base_url().'manuales/usuario/reclutamiento/confirmar_eliminar_usuario_requisicion.png' ?>" class="mx-auto d-block" width="40%">

              </div>
            </div>
          </div>
        </div>
        <!-- Fin collapse anidado -->
        <!-- Inicio collapse anidado -->
        <!-- <div class="accordion" id="accordionChild2">
          <div class="card">
            <div class="card-header" id="headingChild2">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left text-lg" type="button" data-toggle="collapse" data-target="#collapseChild2" aria-expanded="true" aria-controls="collapseChild2">
                  Requisiciones
                </button>
              </h2>
            </div>
            <div id="collapseChild2" class="collapse" aria-labelledby="headingChild2" data-parent="#accordionChild2">
              <div class="card-body">
                hola
              </div>
            </div>
          </div>
        </div> -->
        <!-- Fin collapse anidado -->
      </div>
    </div>
  </div>
</div>


</div>