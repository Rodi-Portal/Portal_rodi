<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cliente_General extends Custom_Controller{

    function __construct(){
      parent::__construct();
      if(!$this->session->userdata('id')){
        redirect('Login/index');
      }
      $this->load->library('usuario_sesion');
      $this->usuario_sesion->checkStatusBD();
    }

    function index(){
      if($this->session->userdata('logueado') && $this->session->userdata('tipo') == 1 ) {
        $id_cliente = $this->uri->segment(3);
        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
        if ($data['permisos']) {
          foreach ($data['permisos'] as $p) {
            if ($p->id_cliente == $id_cliente) {
              $data['cliente'] = $p->nombreCliente;
            }
          }
        }
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach($data['submodulos'] as $row) {
          $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        $data['parentescos'] = $this->funciones_model->getParentescos();
        $data['escolaridades'] = $this->funciones_model->getEscolaridades();
        //$data['examenes_doping'] = $this->funciones_model->getExamenDoping($id_cliente);
        //$info['estados'] = $this->funciones_model->getEstados();
        $info['civiles'] = $this->funciones_model->getEstadosCiviles();
      // $info['subclientes'] = $this->cliente_general_model->getSubclientes($id_cliente);
        $info['puestos'] = $this->funciones_model->getPuestos();
        $info['grados'] = $this->funciones_model->getGradosEstudio();
        $info['drogas'] = $this->funciones_model->getPaquetesAntidoping();
        $info['zonas'] = $this->funciones_model->getNivelesZona();
        $info['viviendas'] = $this->funciones_model->getTiposVivienda();
        $info['condiciones'] = $this->funciones_model->getTiposCondiciones();
        $info['studies'] = $this->funciones_model->getTiposEstudios();
        $info['usuarios_cliente'] = $this->candidato_model->getUsuariosCliente($this->uri->segment(3));
        $info['tipos_docs'] = $this->funciones_model->getTiposDocumentos();
        $info['paises'] = $this->funciones_model->getPaises();
        $info['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
        $info['sanguineos'] = $this->funciones_model->getGruposSanguineos();
        $info['parentescos'] = $this->funciones_model->getParentescos();
        $info['civiles'] = $this->funciones_model->getEstadosCiviles();
        $info['escolaridades'] = $this->funciones_model->getEscolaridades();
        $info['grados_estudios'] = $this->funciones_model->getGradosEstudio();
        $info['usuarios_subcliente'] = $this->subcliente_model->getSubclientesByIdCliente($this->uri->segment(3));
        $info['paises_estudio'] = $this->funciones_model->getPaisesEstudio();
        
        $vista['modals'] = $this->load->view('modals/mdl_clientes_general', $info, TRUE);
        //$vista['modals'] = $this->load->view('modals/formulario/mdl_formulario', $info, TRUE);
        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);
        $modales['mdl_candidato'] = $this->load->view('modals/mdl_candidato','', TRUE);


        // $this->load->library('pagination');

        // // Configuración del paginador
        // $config['base_url'] = base_url('cliente_general/index');
        // $config['total_rows'] = $this->cliente_general_model->count_candidates(); // Número total de filas en tu modelo
        // $config['per_page'] = 10; // Número de registros por página

        // // Opcional: Personaliza las etiquetas de paginación
        // $config['full_tag_open'] = '<ul class="pagination">';
        // $config['full_tag_close'] = '</ul>';
        // $config['first_link'] = 'Primero';
        // $config['last_link'] = 'Último';
        // $config['next_link'] = '&raquo;';
        // $config['prev_link'] = '&laquo;';
        // $config['num_tag_open'] = '<li>';
        // $config['num_tag_close'] = '</li>';
        // $config['cur_tag_open'] = '<li class="active"><a href="#">';
        // $config['cur_tag_close'] = '</a></li>';

        // // Inicializar el paginador
        // $this->pagination->initialize($config);

        // // Obtener los datos paginados de tu modelo
        // $vista['registros'] = json_decode(json_encode($this->modelo->get_paginated_data($config['per_page'], $this->uri->segment(3))), true);
        $notificaciones = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0,1]);
        if(!empty($notificaciones)){
          $contador = 0;
          foreach($notificaciones as $row){
            if($row->visto == 0){
              $contador++;
            }
          }
          $data['contadorNotificaciones'] = $contador;
        }

        $this->load
        ->view('adminpanel/header', $data)
        ->view('adminpanel/scripts',$modales)
        ->view('modals/mdl_reclutamiento')
        ->view('analista/candidatos_espanol_index', $vista)
        ->view('adminpanel/footer');
      }
    }

    function indexCliente(){
      if($this->session->userdata('logueado') && $this->session->userdata('tipo') == 2) {
        $id_cliente = $this->session->userdata('idcliente');
      
        $data['parentescos'] = $this->funciones_model->getParentescos();
      
        //$data['examenes_doping'] = $this->funciones_model->getExamenDoping($id_cliente);
        //$info['estados'] = $this->funciones_model->getEstados();
     
      /* $info['subclientes'] = $this->cliente_general_model->getSubclientes($id_cliente);
        $info['puestos'] = $this->funciones_model->getPuestos();
        $info['grados'] = $this->funciones_model->getGradosEstudio();
        $info['drogas'] = $this->funciones_model->getPaquetesAntidoping();
        $info['zonas'] = $this->funciones_model->getNivelesZona();
        $info['viviendas'] = $this->funciones_model->getTiposVivienda();
        $info['condiciones'] = $this->funciones_model->getTiposCondiciones();
        $info['studies'] = $this->funciones_model->getTiposEstudios();
        $info['usuarios_cliente'] = $this->candidato_model->getUsuariosCliente($id_cliente);
        $info['tipos_docs'] = $this->funciones_model->getTiposDocumentos();
        $info['paises'] = $this->funciones_model->getPaises();
        $info['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
        $info['sanguineos'] = $this->funciones_model->getGruposSanguineos();
        $info['parentescos'] = $this->funciones_model->getParentescos();
        $info['civiles'] = $this->funciones_model->getEstadosCiviles();
        $info['escolaridades'] = $this->funciones_model->getEscolaridades();
        $info['grados_estudios'] = $this->funciones_model->getGradosEstudio();
        $info['usuarios_subcliente'] = $this->subcliente_model->getSubclientesByIdCliente($id_cliente);
        $info['paises_estudio'] = $this->funciones_model->getPaisesEstudio(); */
        $info['tipos_docs'] = $this->funciones_model->getTiposDocumentos();
       // $vista['modals'] = $this->load->view('modals/mdl_clientes_general', $info, TRUE);
        //$vista['modals'] = $this->load->view('modals/formulario/mdl_formulario', $info, TRUE);
        $config = $this->funciones_model->getConfiguraciones();

        //Modals
        //$modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);
        //$modales['mdl_candidato'] = $this->load->view('modals/mdl_candidato','', TRUE);
  
        $this->load->view('clientes/panel',$info);

      }
    }
  /*----------------------------------------*/
  /*  Consultas 
  /*----------------------------------------*/
    function getCandidatos(){
      $id_cliente = $_GET['id'];
      $statusBGC = (isset($_GET['enproceso']) && $_GET['enproceso'] == 0) ? [0,1,2,3,4,5] : [0];
      $cand['recordsTotal'] = $this->cliente_general_model->getTotal($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'), $statusBGC);
      $cand['recordsFiltered'] = $this->cliente_general_model->getTotal($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'), $statusBGC);
      $cand['data'] = $this->cliente_general_model->getCandidatos($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'), $statusBGC);
      $this->output->set_output( json_encode( $cand ) );
    }
    //Prueba paginacion
    public function get_candidates(){
      $id_cliente = $_GET['id'];
      $draw = $this->input->post('draw');
      $start = $this->input->post('start');
      $length = $this->input->post('length');
      $search = $this->input->post('search')['value'];
    
      $result = $this->cliente_general_model->get_candidates($start, $length, $search, $id_cliente);
      $total = $this->cliente_general_model->get_total($search, $id_cliente);
    
      $data = array(
        "draw" => intval($draw),
        "recordsTotal" => intval($total),
        "recordsFiltered" => intval($total),
        "data" => $result
      );
      echo json_encode($data);
    }

    //
    function getCandidatosFinalizados(){
      $id_cliente = $_GET['id'];
      $cand['recordsTotal'] = $this->cliente_general_model->getFinalizadosTotal($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'));
      $cand['recordsFiltered'] = $this->cliente_general_model->getFinalizadosTotal($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'));
      $cand['data'] = $this->cliente_general_model->getCandidatosFinalizados($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'));
      $this->output->set_output( json_encode( $cand ) );
    }

    function getCandidatosUltimosFinalizados(){
      $id_cliente = $_GET['id'];
      $cand['recordsTotal'] = $this->cliente_general_model->getUltimosFinalizadosTotal($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'));
      $cand['recordsFiltered'] = $this->cliente_general_model->getUltimosFinalizadosTotal($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'));
      $cand['data'] = $this->cliente_general_model->getCandidatosUltimosFinalizados($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'));
      $this->output->set_output( json_encode( $cand ) );
    }

    function getCandidatosUltimos100(){
      $id_cliente = $_GET['id'];
      $statusBGC = (isset($_GET['enproceso']) && $_GET['enproceso'] == 0) ? [0,1,2,3,4,5] : [0];
      $cand['recordsTotal'] = $this->cliente_general_model->getTotalUltimos100($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'), $statusBGC);
      $cand['recordsFiltered'] = $this->cliente_general_model->getTotalUltimos100($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'), $statusBGC);
      $cand['data'] = $this->cliente_general_model->getCandidatosUltimos100($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'), $statusBGC);
      $this->output->set_output( json_encode( $cand ) );
    }

    function getHistorialAcademico(){
      $id_candidato = $this->input->post('id_candidato');
      $res = array();
      $dato = $this->candidato_model->getEstudiosCandidato($id_candidato);
      if($dato != null){
        $res = array(
          'primaria_periodo' => $dato->primaria_periodo,
          'primaria_escuela' => $dato->primaria_escuela,
          'primaria_ciudad' => $dato->primaria_ciudad,
          'primaria_certificado' => $dato->primaria_certificado,
          'primaria_promedio' => $dato->primaria_promedio,
          'secundaria_periodo' => $dato->secundaria_periodo,
          'secundaria_escuela' => $dato->secundaria_escuela,
          'secundaria_ciudad' => $dato->secundaria_ciudad,
          'secundaria_certificado' => $dato->secundaria_certificado,
          'secundaria_promedio' => $dato->secundaria_promedio,
          'preparatoria_periodo' => $dato->preparatoria_periodo,
          'preparatoria_escuela' => $dato->preparatoria_escuela,
          'preparatoria_ciudad' => $dato->preparatoria_ciudad,
          'preparatoria_certificado' => $dato->preparatoria_certificado,
          'preparatoria_promedio' => $dato->preparatoria_promedio,
          'licenciatura_periodo' => $dato->licenciatura_periodo,
          'licenciatura_escuela' => $dato->licenciatura_escuela,
          'licenciatura_ciudad' => $dato->licenciatura_ciudad,
          'licenciatura_certificado' => $dato->licenciatura_certificado,
          'licenciatura_promedio' => $dato->licenciatura_promedio,
          'actual_periodo' => $dato->actual_periodo,
          'actual_escuela' => $dato->actual_escuela,
          'actual_ciudad' => $dato->actual_ciudad,
          'actual_certificado' => $dato->actual_certificado,
          'actual_promedio' => $dato->actual_promedio,
          'cedula_profesional' => $dato->cedula_profesional,
          'otros_certificados' => $dato->otros_certificados,
          'comentarios' => $dato->comentarios,
          'carrera_inactivo' => $dato->carrera_inactivo
        );
      }
      echo json_encode($res);
    }

    function getReferenciasPersonales(){
      $id_candidato = $this->input->post('id_candidato');
      $salida = "";
      $data['refs'] = $this->candidato_model->getReferenciasPersonales($id_candidato);
      if($data['refs']){
          foreach($data['refs'] as $ref){
            $salida .= $ref->nombre."@@";
            $salida .= $ref->telefono."@@";
            $salida .= $ref->tiempo_conocerlo."@@";
            $salida .= $ref->id."@@";
            $salida .= $ref->recomienda."@@";
            $salida .= $ref->comentario."###";
          }
          echo $salida;
      }
      else{
          echo $salida = 0;
      }
    }

    function getAntecedentesLaborales(){
      $id_candidato = $this->input->post('id_candidato');
      $salida = "";
      $data['referencias'] = $this->candidato_model->getAntecedentesLaborales($id_candidato);
      if($data['referencias']){
          foreach($data['referencias'] as $ref){
              $salida .= $ref->empresa."@@";
              $salida .= $ref->area."@@";
              $salida .= $ref->calle."@@";
              $salida .= $ref->colonia."@@";
              $salida .= $ref->cp."@@";
              $salida .= $ref->telefono."@@";
              $salida .= $ref->tipo_empresa."@@";
              $salida .= $ref->puesto."@@";
              $salida .= $ref->periodo."@@";
              $salida .= $ref->jefe_nombre."@@";
              $salida .= $ref->jefe_puesto."@@";
              $salida .= $ref->sueldo_inicial."@@";
              $salida .= $ref->sueldo_final."@@";
              $salida .= $ref->actividades."@@";
              $salida .= $ref->causa_separacion."@@";
              $salida .= $ref->trabajo_calidad."@@";
              $salida .= $ref->trabajo_puntualidad."@@";
              $salida .= $ref->trabajo_honesto."@@";
              $salida .= $ref->trabajo_responsabilidad."@@";
              $salida .= $ref->trabajo_adaptacion."@@";
              $salida .= $ref->trabajo_actitud_jefes."@@";
              $salida .= $ref->trabajo_actitud_companeros."@@";
              $salida .= $ref->comentarios."@@";
              $salida .= $ref->id."###";
          }
          
      }
      echo $salida;
    }

    function getInvestigacionLegal(){
      $id_candidato = $this->input->post('id_candidato');
      $res = array();
      $dato = $this->candidato_model->getVerificacionLegal($id_candidato);
      if($dato != null){
        $res = array(
          'penal' => $dato->penal,
          'penal_notas' => $dato->penal_notas,
          'civil' => $dato->civil,
          'civil_notas' => $dato->civil_notas,
          'laboral' => $dato->laboral,
          'laboral_notas' => $dato->laboral_notas,
        );
      }
      echo json_encode($res);
    }

    function getGrupoFamiliar(){
      $id_candidato = $_POST['id_candidato'];
      $salida = "";
      $cont = 1;
      $data['parentescos'] = $this->funciones_model->getParentescos();
      $data['civiles'] = $this->funciones_model->getEstadosCiviles();
      $data['escolaridades'] = $this->funciones_model->getEscolaridades();
      $data['familia'] = $this->candidato_model->getGrupoFamiliar($id_candidato);
      if($data['familia']){
        foreach($data['familia'] as $f){
            $salida .= '<div class="alert alert-secondary text-center">
                            <p><b>Persona #'.$cont.'</b></p>
                        </div>
                        <form id=d_familiar'.$cont.'>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Nombre completo *</label>
                                <input type="text" class="form-control es_persona visita_p_obligado_'.$cont.'" name="p'.$cont.'_nombre" id="p'.$cont.'_nombre" value="'.$f->nombre.'">
                                <br>
                            </div>
                            <div class="col-md-3">
                                <label>Parentesco *</label>
                                <select name="p'.$cont.'_parentesco" id="p'.$cont.'_parentesco" class="form-control es_persona visita_p_obligado_'.$cont.'">';
                                foreach($data['parentescos'] as $parent){
                                  $salida .= '<option value="'.$parent->id.'">'.$parent->nombre.'</option>';
                                }
                                
                    $salida .= '</select> 
                                <br>
                            </div>
                            <div class="col-md-3">
                                <label>Edad *</label>
                                <input type="text" class="form-control solo_numeros es_persona visita_p_obligado_'.$cont.'" name="p'.$cont.'_edad" id="p'.$cont.'_edad" maxlength="2" value="'.$f->edad.'">
                                <br>
                            </div>
                            <div class="col-md-3">
                                <label>Estado civil *</label>
                                <select name="p'.$cont.'_civil" id="p'.$cont.'_civil" class="form-control es_persona visita_p_obligado_'.$cont.'"> ';
                                foreach($data['civiles'] as $civ){
                                  $salida .= '<option value="'.$civ->nombre.'">'.$civ->nombre.'</option>';
                                }
                    $salida .= '</select>
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Escolaridad *</label>
                                <select name="p'.$cont.'_escolaridad" id="p'.$cont.'_escolaridad" class="form-control es_persona visita_p_obligado_'.$cont.'"> ';
                                foreach($data['escolaridades'] as $escolar){
                                  $salida .= '<option value="'.$escolar->id.'">'.$escolar->nombre.'</option>';
                                }
                    $salida .= '</select>
                                <br>
                            </div>
                            <div class="col-md-3">
                                <label>¿Vive con usted? *</label>
                                <select name="p'.$cont.'_vive" id="p'.$cont.'_vive" class="form-control es_persona visita_p_obligado_'.$cont.'">
                                  <option value="0">No</option>
                                  <option value="1">Sí</option>
                                </select>
                                <br>
                            </div>
                            <div class="col-md-3">
                                <label>Empresa *</label>
                                <input type="text" class="form-control es_persona visita_p_obligado_'.$cont.'" name="p'.$cont.'_empresa" id="p'.$cont.'_empresa" value="'.$f->empresa.'">
                                <br>
                            </div>
                            <div class="col-md-3">
                                <label>Puesto *</label>
                                <input type="text" class="form-control es_persona visita_p_obligado_'.$cont.'" name="p'.$cont.'_puesto" id="p'.$cont.'_puesto" value="'.$f->puesto.'">
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Antigüedad *</label>
                                <input type="text" class="form-control es_persona visita_p_obligado_'.$cont.'" name="p'.$cont.'_antiguedad" id="p'.$cont.'_antiguedad" value="'.$f->antiguedad.'">
                                <br>
                            </div>
                            <div class="col-md-3">
                                <label>Sueldo *</label>
                                <input type="text" class="form-control solo_numeros es_persona visita_p_obligado_'.$cont.'" name="p'.$cont.'_sueldo" id="p'.$cont.'_sueldo" maxlength="8" value="'.$f->sueldo.'">
                                <br>
                            </div>
                            <div class="col-md-3">
                                <label>Aportación *</label>
                                <input type="text" class="form-control solo_numeros es_persona visita_p_obligado_'.$cont.'" name="p'.$cont.'_aportacion" id="p'.$cont.'_aportacion" maxlength="8" value="'.$f->monto_aporta.'">
                                <br>
                            </div>
                            <div class="col-md-3">
                                <label>Muebles e inmuebles *</label>
                                <input type="text" class="form-control es_persona visita_p_obligado_'.$cont.'" name="p'.$cont.'_muebles" id="p'.$cont.'_muebles" value="'.$f->muebles.'">
                                <br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Adeudo *</label>
                                <select name="p'.$cont.'_adeudo" id="p'.$cont.'_adeudo" class="form-control"">
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                                <br><br><br>
                            </div>
                        </div>
                        </form>
                        <div class="row">
                            <div class="col-md-5 offset-4">
                                <a href="javascript:void(0)" class="btn btn-success" onclick="guardarIntegranteFamiliar('.$f->id.','.$cont.','.$id_candidato.')">Actualizar Persona #'.$cont.'</a>
                                <br><br><br>
                            </div>
                        </div>
                        <div id="familiar_msj_error'.$cont.'" class="alert alert-danger hidden"></div>';
                        $salida .= 
                        '<script>
                        $("#p'.$cont.'_parentesco").val('.$f->id_tipo_parentesco.');
                        $("#p'.$cont.'_civil").val("'.$f->estado_civil.'");
                        $("#p'.$cont.'_escolaridad").val('.$f->id_grado_estudio.');
                        $("#p'.$cont.'_vive").val('.$f->misma_vivienda.');
                        $("#p'.$cont.'_adeudo").val('.$f->adeudo.');
                        </script>';
                        $cont++;
        }
        $salida .= '<hr>';
        $candidato = $this->candidato_model->getInfoCandidatoEspecifico($id_candidato);
        $salida .= '<form id="d_familiar_candidato"> 
                      <div class="row">
                        <div class="col-md-6">
                            <label>Muebles e inmuebles del candidato *</label>
                            <input type="text" class="form-control extra_candidato" name="candidato_muebles" id="candidato_muebles" value="'.$candidato->muebles.'">
                            <br>
                        </div>
                        <div class="col-md-6">
                            <label>Adeudo *</label>
                            <select name="candidato_adeudo" id="candidato_adeudo" class="form-control"">
                              <option value="0">No</option>
                              <option value="1">Sí</option>
                            </select>
                            <br>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label>Ingresos del candidato *</label>
                          <input type="text" class="form-control extra_candidato" name="candidato_ingresos" id="candidato_ingresos" value="'.$candidato->ingresos.'">
                          <br>
                        </div>
                      </div>
                      <div class="row">
                          <div class="col-md-12">
                              <label>Notas *</label>
                              <textarea class="form-control extra_candidato" name="notas" id="notas" rows="2">'.$candidato->comentario.'</textarea><br><br>
                              <br>
                          </div>
                      </div>
                      </form>
                      <div class="row">
                          <div class="col-md-7 offset-3">
                              <a href="javascript:void(0)" class="btn btn-primary" onclick="guardarExtrasCandidato('.$id_candidato.')">Actualizar mobiliaria y notas del candidato</a>
                              <br><br><br>
                          </div>
                      </div>
                      <div id="mobiliario_msj_error" class="alert alert-danger hidden"></div>';
                      $salida .= 
                      '<script>
                      $("#candidato_adeudo").val('.$candidato->adeudo_muebles.');
                      </script>';
      }
      else{
        $candidato = $this->candidato_model->getInfoCandidatoEspecifico($id_candidato);
        $salida .= '<form id="d_familiar_candidato">
                      <div class="row">
                        <div class="col-md-6">
                          <label>Muebles e inmuebles del candidato *</label>
                          <input type="text" class="form-control extra_candidato" name="candidato_muebles" id="candidato_muebles" value="'.$candidato->muebles.'">
                          <br>
                        </div>
                        <div class="col-md-6">
                          <label>Adeudo *</label>
                          <select name="candidato_adeudo" id="candidato_adeudo" class="form-control"">
                            <option value="0">No</option>
                            <option value="1">Sí</option>
                          </select>
                          <br>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label>Ingresos del candidato *</label>
                          <input type="text" class="form-control extra_candidato" name="candidato_ingresos" id="candidato_ingresos" value="'.$candidato->ingresos.'">
                          <br>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <label>Notas *</label>
                            <textarea class="form-control extra_candidato" name="notas" id="notas" rows="2">'.$candidato->comentario.'</textarea><br><br>
                            <br>
                        </div>
                      </div>
                    </form>
                    <div class="row">
                      <div class="col-md-7 offset-3">
                          <a href="javascript:void(0)" class="btn btn-success" onclick="guardarExtrasCandidato('.$id_candidato.')">Actualizar mobiliaria y notas del candidato</a>
                          <br><br><br>
                      </div>
                    </div>
                    <div id="mobiliario_msj_error" class="alert alert-danger hidden"></div>';
                    $salida .= 
                    '<script>
                    $("#candidato_adeudo").val('.$candidato->adeudo_muebles.');
                    </script>';
      }
      echo $salida;
    }

    function getComentariosRefPersonales(){
      $id_candidato = $this->input->post('id_candidato');
      $salida = "";
      $data['ref'] = $this->candidato_model->getComentariosRefPersonales($id_candidato);
      if($data['ref']){
          foreach($data['ref'] as $ref){
              $salida .= $ref->comentario.", ";
          }
          $res = trim($salida, ", ");
          echo $res;
      }
      else{
          echo $salida;
      }
    }

    function countAntecedentesLaborales(){
      $id_candidato = $this->input->post('id_candidato');
      $numero = $this->candidato_model->countAntecedentesLaborales($id_candidato);
      echo $numero;
    }

    function getComentariosRefVecinales(){
      $id_candidato = $this->input->post('id_candidato');
      $salida = "";
      $data['ref'] = $this->candidato_model->getComentariosRefVecinales($id_candidato);
      if($data['ref']){
          foreach($data['ref'] as $ref){
              $salida .= $ref->concepto_candidato.", ";
          }
          $res = trim($salida, ", ");
          echo $res;
      }
      else{
          echo $salida;
      }
    }

    function getInformacionVisita(){
      $id_candidato = $this->input->post('id_candidato');
      $data['visita'] = $this->candidato_model->getInformacionVisita($id_candidato);
            
      echo json_encode($data['visita']);
    }

    function getUsuariosClientePrivados(){
      $id_cliente = $this->input->post('id_cliente');
      $salida = '';
      $data['users'] = $this->candidato_model->getUsuariosClientePrivados($id_cliente);
      if($data['users']){
        foreach ($data['users'] as $row){
          $salida .= "<option value='".$row->id."'>".$row->nombre.' '.$row->paterno."</option>";
        } 
        echo $salida;
      }
      else{
        echo $salida;
      }
    }
  /*----------------------------------------*/
  /*  Proceso 
  /*----------------------------------------*/
    function registrar(){
      if($this->input->post('previo') != 0){
        $this->form_validation->set_rules('nombre', 'Nombre(s)', 'required|trim');
        $this->form_validation->set_rules('paterno', 'Apellido paterno', 'required|trim');
        $this->form_validation->set_rules('materno', 'Apellido materno', 'trim');
        $this->form_validation->set_rules('subcliente', 'Subcliente (Proveedor)', 'required');
        $this->form_validation->set_rules('puesto', 'Puesto', 'required');
        $this->form_validation->set_rules('celular', 'Teléfono', 'required|trim|max_length[16]');
        $this->form_validation->set_rules('previo', 'Proceso previo', 'required');
        $this->form_validation->set_rules('examen', 'Examen antidoping', 'required');
        $this->form_validation->set_rules('medico', 'Examen Médico', 'required');
        $this->form_validation->set_rules('psicometrico', 'Examen Psicométrico', 'required');

        if($this->session->userdata('idcliente') != null){
          $id_cliente = $this->session->userdata('idcliente');
        }
        else{
          $id_cliente = $this->input->post('id_cliente');
        }
        $cliente = $this->cat_cliente_model->getById($id_cliente);
        


        $seccion = $this->candidato_seccion_model->getProyectoHistorialByIdProyecto($this->input->post('previo'));
        $control = $this->cliente_control_model->get_by_cliente_proyecto($id_cliente, $this->input->post('previo'));

        if(!empty($control)){
          if($control->acceso_candidatos == 1)
            $this->form_validation->set_rules('correo', 'Correo', 'required|trim|valid_email');
        }
        else{
          $this->form_validation->set_rules('correo', 'Correo', 'trim|valid_email');
        }

        if($id_cliente == 159){
          $this->form_validation->set_rules('centro_costo', 'Centro de costo', 'required|trim');
          $this->form_validation->set_rules('curp', 'CURP', 'required|trim|max_length[18]');
          $this->form_validation->set_rules('nss', 'NSS', 'required|trim|max_length[11]');
        }
        else{
          if($id_cliente == 87){
            $this->form_validation->set_rules('curp', 'CURP', 'trim|max_length[18]');
            $this->form_validation->set_rules('nss', 'NSS', 'trim|max_length[11]');
          }
          else{
            $this->form_validation->set_rules('centro_costo', 'Centro de costo', 'trim');
            $this->form_validation->set_rules('curp', 'CURP', 'trim');
            $this->form_validation->set_rules('nss', 'NSS', 'trim');
          }
        }

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
        $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');
        
        $msj = array();
        if ($this->form_validation->run() == FALSE) {
          $msj = array(
            'codigo' => 0,
            'msg' => validation_errors()
          );
        }
        else{
          if(!empty($control)){
            if($control->acceso_candidatos == 1){
              $base = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
              $aux = substr( md5(microtime()), 1, 8);
              $token = md5($aux.$base);
              $tipo_formulario = 1;
            }
          }
          else{
            $token = '';
            $tipo_formulario = 0;
          }
          $nombre = strtoupper($this->input->post('nombre'));
          $paterno = strtoupper($this->input->post('paterno'));
          $materno = strtoupper($this->input->post('materno'));
          $celular = $this->input->post('celular');
          $id_subcliente = $this->input->post('subcliente');
          $id_puesto = !empty($this->input->post('puesto'))? $this->input->post('puesto') : NULL;
          $pais = $this->input->post('pais');
          $id_proyecto_previo = $this->input->post('previo');
          $examen = $this->input->post('examen');
          $medico = $this->input->post('medico');
          $psicometrico = $this->input->post('psicometrico');
          $correo = $this->input->post('correo');
          $centro_costo = $this->input->post('centro_costo');
          $curp = $this->input->post('curp');
          $nss = $this->input->post('nss');
          $id_aspirante = ($this->input->post('id_aspirante') != '' && $this->input->post('id_aspirante') != NULL)? $this->input->post('id_aspirante') : NULL;
          $existeCandidato = $this->candidato_model->repetidoCandidato($nombre, $paterno, $materno, $correo, $id_cliente, $seccion->proyecto);
          if($existeCandidato > 0){
            $msj = array(
              'codigo' => 2,
              'msg' => 'El candidato ya existe'
            );
          }
          else{
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');
            $usuario = $this->input->post('usuario');
            $privacidad_candidato = 0;
            switch ($usuario) {
              case 1:
                $tipo_usuario = "id_usuario";
                break;
              case 2:
                $tipo_usuario = "id_usuario_cliente";
                break;
              case 3:
                $tipo_usuario = "id_usuario_subcliente";
                break;
            }
            $id_usuario = $this->session->userdata('id');

            if($usuario == 2){
              $data_usuario = $this->usuario_model->getDatosUsuarioCliente($id_usuario);
              $privacidad_candidato = ($data_usuario->privacidad != null)? $data_usuario->privacidad : 0;
            }

            $seccion = $this->candidato_model->getProyectoPrevio($id_proyecto_previo);
            //TODO: Ver si se quita esta parte del registro en un nuevo formulario
            $tipoPuesto = ($id_cliente != 172)? 'id_puesto' : 'puesto';

            //* Registro y actualizacion de datos en requisicion/bolsa de trabajo si proviene de Reclutamiento
            if($this->input->post('id_aspirante') != '' && $this->input->post('id_aspirante') != NULL){
              $id_requisicion = $this->input->post('id_requisicion');
              $accion = array(
                'creacion' => $date,
                'id_usuario' => $id_usuario,
                'id_requisicion' => $id_requisicion,
                'id_bolsa_trabajo' => $this->input->post('id_bolsa_trabajo'),
                'id_aspirante' => $id_aspirante,
                'accion' => 'ESE en proceso',
                'descripcion' => 'Inicia proceso de su estudio socioeconomico en RODI RECLUTAMIENTO',
              );
              $this->reclutamiento_model->guardarAccionRequisicion($accion);
              $bolsa = array(
                'edicion' => $date,
                'status' => 4,
              );
              $this->reclutamiento_model->editBolsaTrabajo($bolsa, $this->input->post('id_bolsa_trabajo'));
              // $requisicion = $this->reclutamiento_model->getDetailsOrderById($id_requisicion);
              // if($requisicion != null){
              //   $existClient = $this->cliente_model->getClientByName($requisicion->nombre);
              //   if($existClient != null){
              //     $existClient = $this->cliente_model->getClientByName($requisicion->nombre_comercial);
              //     if($existClient != null){
              //       $id_subcliente = $existClient->id_subcliente;
              //     }else{

              //     }
              //   }
              // }
            }

            //TODO: Suplir esta parte con notificaciones 
            if ($usuario == 2 || $usuario == 3) {
              //$configuracion = $this->funciones_model->getConfiguraciones();
              if($id_cliente == 159){
                $usuarioAsignado = 21;
              }
              else{
                //$usuario_lider = $configuracion->usuario_lider_espanol;
                $usuarioAsignado = ($cliente->ingles == 0)? 7 : 38;
              }
            } 
            else{
              $usuarioAsignado = $id_usuario;
            }
            $data = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_usuario' => $usuarioAsignado,
              $tipo_usuario => $id_usuario,
              'id_cliente' => $id_cliente,
              'id_subcliente' => $id_subcliente,
              'id_aspirante' => $id_aspirante,
              'id_tipo_proceso' => 1,
              $tipoPuesto => $id_puesto,
              'tipo_formulario' => $tipo_formulario,
              'token' => $token,
              'fecha_alta' => $date,
              'nombre' => strtoupper($nombre),
              'paterno' => strtoupper($paterno),
              'materno' => strtoupper($materno),
              'celular' => $celular,
              'subproyecto' => $seccion->proyecto,
              'pais' => $pais,
              'correo' => $correo,
              'centro_costo' => $centro_costo,
              'curp' => $curp,
              'nss' => $nss,
              'privacidad' => $privacidad_candidato
            );
            $id_candidato = $this->candidato_model->registrarRetornaCandidato($data);

            //TODO: Quitar subida de CV del registro
            if ($this->input->post('hay_cvs') == 1) {
              $countfiles = count($_FILES['cvs']['name']);

              for ($i = 0; $i < $countfiles; $i++) {
                if (!empty($_FILES['cvs']['name'][$i])) {
                  // Define new $_FILES array - $_FILES['file']
                  $_FILES['file']['name'] = $_FILES['cvs']['name'][$i];
                  $_FILES['file']['type'] = $_FILES['cvs']['type'][$i];
                  $_FILES['file']['tmp_name'] = $_FILES['cvs']['tmp_name'][$i];
                  $_FILES['file']['error'] = $_FILES['cvs']['error'][$i];
                  $_FILES['file']['size'] = $_FILES['cvs']['size'][$i];
                  $temp = str_replace(' ', '', $_FILES['cvs']['name'][$i]);
                  $extension = pathinfo($_FILES['cvs']['name'][$i], PATHINFO_EXTENSION);

                  $nombre_cv = $id_candidato . "_CV_" . $i . '.' . $extension;
                  // Set preference
                  $config['upload_path'] = './_docs/';
                  $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                  //$config['max_size'] = '15000'; // max_size in kb
                  $config['file_name'] = $nombre_cv;
                  //Load upload library
                  $this->load->library('upload', $config);
                  $this->upload->initialize($config);
                  // File upload
                  if ($this->upload->do_upload('file')) {
                    $data = $this->upload->data();
                    //$salida = 1; 
                  }
                  $documento = array(
                    'creacion' => $date,
                    'edicion' => $date,
                    'id_candidato' => $id_candidato,
                    'id_tipo_documento' => 16,
                    'archivo' => $nombre_cv
                  );
                  $this->candidato_model->registrarDocumento($documento);
                }
              }
            }
            //TODO: reducir esta asignacion
            $candidato_secciones = array(
              'creacion' => $date,
              $tipo_usuario => $id_usuario,
              'id_candidato' => $id_candidato,
            );
            foreach (get_object_vars($seccion) as $campo => $valor) {
              if($campo != 'id_cliente' && $campo != 'status' && $campo != 'id'){
                $candidato_secciones[$campo] = $valor;
              }
            }
            $this->candidato_seccion_model->store_secciones_candidato($candidato_secciones);

            $tipo_antidoping = ($examen == 0)? 0:1;
            $antidoping = ($examen == 0)? NULL:$examen;
            $pruebas = array(
              'creacion' => $date,
              'edicion' => $date,
              $tipo_usuario => $id_usuario,
              'id_candidato' => $id_candidato,
              'id_cliente' => $id_cliente,
              'socioeconomico' => 1,
              'tipo_antidoping' => $tipo_antidoping,
              'antidoping' => $antidoping,
              'tipo_psicometrico' => $psicometrico,
              'psicometrico' => $psicometrico,
              'medico' => $medico,
              'buro_credito' => 0,
              'sociolaboral' => 0
            );
            $this->candidato_model->crearPruebas($pruebas);
              
            if($seccion->visita != NULL){
              $visita = array(
                'creacion' => $date,
                'edicion' => $date,
                'id_usuario' => NULL,
                'id_candidato' => $id_candidato,
              );
              $this->candidato_model->crearVisita($visita);
            }
            //* Envio de notificacion
            if ($usuario == 2 || $usuario == 3) {
              $aplicaDoping = ''; $aplicaMedico = ''; $rolDoping = 0;
              if($examen != 0){
                $aplicaDoping = ', para examen de drogas';
                $rolDoping = 8;
              }
              if($medico != 0){
                $rolDoping = 8;
                if($examen != 0){
                  $aplicaMedico =' y examen medico';
                }
                else{
                  $aplicaMedico =', para examen medico';
                }
              }
              $usuariosAnalistas = $this->usuario_model->get_usuarios_by_rol([1,2,6,$rolDoping,9]);
              foreach($usuariosAnalistas as $row){
                $usuariosObjetivo[] = $row->id;
              }
              $titulo = 'Registro de un nuevo candidato';
              $mensaje = 'El cliente '.$cliente->nombre.' ha registrado al candidato: '.$nombre.' '.$paterno.' '.$materno.' para ESE'.$aplicaDoping.$aplicaMedico;
              $this->registrar_notificacion($usuariosObjetivo, $titulo, $mensaje);
              
            }
            //* Envio de correo a candidato
            if(!empty($control)){
              if($control->acceso_candidatos == 1){
                $from = $this->config->item('smtp_user');
                $to = $correo;
                $subject = "Hiring process or change of work project in ".strtoupper($cliente->nombre);
                $datos['password'] = $aux;
                $datos['cliente'] = strtoupper($cliente->nombre);
                $datos['email'] = $correo;
                $message = $this->load->view('mails/credenciales_candidato',$datos,TRUE);
                $this->load->library('phpmailer_lib');
                $mail = $this->phpmailer_lib->load();
                $mail->isSMTP();
                $mail->Host     = 'mail.rodicontrol.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'rodicontrol@rodicontrol.com';
                $mail->Password = 'r49o*&rUm%91';
                $mail->SMTPSecure = 'ssl';
                $mail->Port     = 465;
                
                $mail->setFrom('rodicontrol@rodicontrol.com', 'RODI');
                $mail->addAddress($to);
                $mail->Subject = $subject;
                $mail->isHTML(true);
                $mailContent = $message;
                $mail->Body = $mailContent;
                if($mail->send()){
                  $enviado = 1;
                  $mensajeTraducido = ($cliente->ingles == 0)? 'Candidato registrado y credenciales enviadas' : 'The candidate has been registered and his/her login credentials have been sent';
                  $msj = array(
                    'codigo' => 1,
                    'msg' => $mensajeTraducido,
                    'credenciales' => $aux
                  );
                }
                else{
                  $mensajeTraducido = ($cliente->ingles == 0)? 'Candidato registrado pero hubo un problema al enviar sus credenciales' : 'The candidate has been registered, but there was a problem with sending his/her login credentials';
                  $msj = array(
                    'codigo' => 1,
                    'msg' => $mensajeTraducido,
                    'credenciales' => $aux
                  );
                }
              }
            }
            else{
              $mensajeTraducido = ($cliente->ingles == 0)? 'Candidato registrado correctamente' : 'Candidate has successfully registered';
              $msj = array(
                'codigo' => 1,
                'msg' => $mensajeTraducido,
                'credenciales' => ''
              );
            }
          }
        } 
      }
      else{
        $mensajeTraducido = ($cliente->ingles == 0)? 'Hay campos obligatorios vacios' : 'Empty required fields';
        $msj = array(
          'codigo' => 0,
          'msg' => $mensajeTraducido
        );
      }
      echo json_encode($msj);
    }

    function guardarDatosGenerales(){
      $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
      $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
      $this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
      $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required|trim');
      $this->form_validation->set_rules('lugar', 'Lugar de nacimiento', 'required|trim');
      $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
      $this->form_validation->set_rules('genero', 'Género', 'required|trim');
      $this->form_validation->set_rules('calle', 'Calle', 'required|trim');
      $this->form_validation->set_rules('exterior', 'No. Exterior', 'required|trim|max_length[8]');
      $this->form_validation->set_rules('interior', 'No. Interior', 'trim|max_length[8]');
      $this->form_validation->set_rules('colonia', 'Colonia', 'required|trim');
      $this->form_validation->set_rules('estado', 'Estado', 'required|trim|numeric');
      $this->form_validation->set_rules('municipio', 'Municipio', 'required|trim|numeric');
      $this->form_validation->set_rules('cp', 'Código postal', 'required|trim|numeric|max_length[5]');
      $this->form_validation->set_rules('civil', 'Civil', 'required|trim');
      $this->form_validation->set_rules('celular', 'Tel. Celular', 'required|trim|max_length[16]');
      $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
      $this->form_validation->set_rules('grado_estudios', 'Grado máximo de estudios', 'trim|required');
      $this->form_validation->set_rules('correo', 'Correo', 'trim|valid_email');
      $this->form_validation->set_rules('tipo_sanguineo', 'Tipo sanguíneo', 'trim');

      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('valid_email','El campo {field} debe ser un correo válido');
      $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('alpha','El campo {field} debe contener solo carácteres alfabéticos y sin acentos');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');


      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $id_candidato = $this->input->post('id_candidato');
          $id_usuario = $this->session->userdata('id');
          $fecha = fecha_espanol_bd($this->input->post('fecha_nacimiento'));
          $edad = calculaEdad($fecha);

          $candidato = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'nombre' => $this->input->post('nombre'),
            'paterno' => $this->input->post('paterno'),
            'materno' => $this->input->post('materno'),
            'fecha_nacimiento' => $fecha,
            'edad' => $edad,
            'id_puesto' => $this->input->post('puesto'),
            'lugar_nacimiento' => $this->input->post('lugar'),
            'genero' => $this->input->post('genero'),
            'id_grado_estudio' => $this->input->post('grado_estudios'),
            'calle' => $this->input->post('calle'),
            'exterior' => $this->input->post('exterior'),
            'interior' => $this->input->post('interior'),
            'entre_calles' => $this->input->post('entre_calles'),
            'colonia' => $this->input->post('colonia'),
            'id_estado' => $this->input->post('estado'),
            'id_municipio' => $this->input->post('municipio'),
            'cp' => $this->input->post('cp'),
            'estado_civil' => $this->input->post('civil'),
            'celular' => $this->input->post('celular'),
            'telefono_casa' => $this->input->post('tel_casa'),
            'correo' => $this->input->post('correo'),
            'tipo_sanguineo' => $this->input->post('tipo_sanguineo')
          );
          $this->candidato_model->editarCandidato($candidato, $id_candidato);
          $visita = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'calle' => $this->input->post('calle'),
            'exterior' => $this->input->post('exterior'),
            'interior' => $this->input->post('interior'),
            'colonia' => $this->input->post('colonia'),
            'id_estado' => $this->input->post('estado'),
            'id_municipio' => $this->input->post('municipio'),
            'cp' => $this->input->post('cp'),
            'celular' => $this->input->post('celular_general'),
            'telefono_casa' => $this->input->post('tel_casa'),
          );
          $this->candidato_model->editarVisita($visita, $id_candidato);
          $msj = array(
              'codigo' => 1,
              'msg' => 'success'
          );
      }
      echo json_encode($msj);
    }


    function guardarDatosGeneralesInternacionales(){
      $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
      $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
      $this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
      $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required|trim');
      $this->form_validation->set_rules('lugar', 'Lugar de nacimiento', 'required|trim');
      $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
      $this->form_validation->set_rules('genero', 'Género', 'required|trim');
      $this->form_validation->set_rules('pais', 'País donde reside', 'required|trim');
      $this->form_validation->set_rules('domicilio', 'Domicilio completo', 'required|trim');
      $this->form_validation->set_rules('civil', 'Civil', 'required|trim');
      $this->form_validation->set_rules('celular', 'Tel. Celular', 'required|trim|max_length[16]');
      $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
      $this->form_validation->set_rules('grado_estudios', 'Grado máximo de estudios', 'trim|required');
      $this->form_validation->set_rules('correo', 'Correo', 'trim|valid_email');

      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('valid_email','El campo {field} debe ser un correo válido');
      $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('alpha','El campo {field} debe contener solo carácteres alfabéticos y sin acentos');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');


      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $id_candidato = $this->input->post('id_candidato');
          $id_usuario = $this->session->userdata('id');
          $fecha = fecha_espanol_bd($this->input->post('fecha_nacimiento'));
          $edad = calculaEdad($fecha);

          $candidato = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'nombre' => $this->input->post('nombre'),
            'paterno' => $this->input->post('paterno'),
            'materno' => $this->input->post('materno'),
            'fecha_nacimiento' => $fecha,
            'edad' => $edad,
            'id_puesto' => $this->input->post('puesto'),
            'lugar_nacimiento' => $this->input->post('lugar'),
            'genero' => $this->input->post('genero'),
            'id_grado_estudio' => $this->input->post('grado_estudios'),
            'pais' => $this->input->post('pais'),
            'domicilio_internacional' => $this->input->post('domicilio'),
            'estado_civil' => $this->input->post('civil'),
            'celular' => $this->input->post('celular'),
            'telefono_casa' => $this->input->post('tel_casa'),
            'correo' => $this->input->post('correo')
          );
          $this->candidato_model->editarCandidato($candidato, $id_candidato);
          if($this->input->post('pais') == 'México'){
            $visita = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              'calle' => $this->input->post('calle'),
              'exterior' => $this->input->post('exterior'),
              'interior' => $this->input->post('interior'),
              'colonia' => $this->input->post('colonia'),
              'id_estado' => $this->input->post('estado'),
              'id_municipio' => $this->input->post('municipio'),
              'cp' => $this->input->post('cp'),
              'celular' => $this->input->post('celular_general'),
              'telefono_casa' => $this->input->post('tel_casa'),
            );
            $this->candidato_model->editarVisita($visita, $id_candidato);
          }
          $msj = array(
              'codigo' => 1,
              'msg' => 'success'
          );
      }
      echo json_encode($msj);
    }

    function guardarHistorialAcademico(){
      $this->form_validation->set_rules('prim_promedio', 'Promedio de Primaria', 'numeric|trim');
      $this->form_validation->set_rules('sec_promedio', 'Promedio de Secundaria', 'numeric|trim');
      $this->form_validation->set_rules('prep_promedio', 'Promedio de Bachillerato', 'numeric|trim');
      $this->form_validation->set_rules('lic_promedio', 'Promedio de Licenciatura', 'numeric|trim');
      $this->form_validation->set_rules('actual_promedio', 'Promedio de Estudios actuales', 'numeric|trim');
      $this->form_validation->set_rules('cedula', 'Cédula profesional', 'required|trim');
      $this->form_validation->set_rules('otro_certificado', 'Otros certificados/cursos', 'required|trim');
      $this->form_validation->set_rules('carrera_inactivo', 'Periodos inactivos', 'required|trim');
      $this->form_validation->set_rules('estudios_comentarios', 'Comentarios', 'required|trim');

      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
          date_default_timezone_set('America/Mexico_City');
          $date = date('Y-m-d H:i:s');
          $id_candidato = $this->input->post('id_candidato');
          $id_usuario = $this->session->userdata('id');

          $data['estudios'] = $this->candidato_model->revisionEstudios($id_candidato);
          if($data['estudios']){
              $estudios = array(
                  'edicion' => $date,
                  'id_usuario' => $id_usuario,
                  'primaria_periodo' => $this->input->post('prim_periodo'),
                  'primaria_escuela' => $this->input->post('prim_escuela'),
                  'primaria_ciudad' => $this->input->post('prim_ciudad'),
                  'primaria_certificado' => $this->input->post('prim_certificado'),
                  'primaria_promedio' => $this->input->post('prim_promedio'),
                  'secundaria_periodo' => $this->input->post('sec_periodo'),
                  'secundaria_escuela' => $this->input->post('sec_escuela'),
                  'secundaria_ciudad' => $this->input->post('sec_ciudad'),
                  'secundaria_certificado' => $this->input->post('sec_certificado'),
                  'secundaria_promedio' => $this->input->post('sec_promedio'),
                  'preparatoria_periodo' => $this->input->post('prep_periodo'),
                  'preparatoria_escuela' => $this->input->post('prep_escuela'),
                  'preparatoria_ciudad' => $this->input->post('prep_ciudad'),
                  'preparatoria_certificado' => $this->input->post('prep_certificado'),
                  'preparatoria_promedio' => $this->input->post('prep_promedio'),
                  'licenciatura_periodo' => $this->input->post('lic_periodo'),
                  'licenciatura_escuela' => $this->input->post('lic_escuela'),
                  'licenciatura_ciudad' => $this->input->post('lic_ciudad'),
                  'licenciatura_certificado' => $this->input->post('lic_certificado'),
                  'licenciatura_promedio' => $this->input->post('lic_promedio'),
                  'actual_periodo' => $this->input->post('actual_periodo'),
                  'actual_escuela' => $this->input->post('actual_escuela'),
                  'actual_ciudad' => $this->input->post('actual_ciudad'),
                  'actual_certificado' => $this->input->post('actual_certificado'),
                  'actual_promedio' => $this->input->post('actual_promedio'),
                  'cedula_profesional' => $this->input->post('cedula'),
                  'otros_certificados' => $this->input->post('otro_certificado'),
                  'comentarios' => $this->input->post('estudios_comentarios'),
                  'carrera_inactivo' => $this->input->post('carrera_inactivo')
              );
              $this->candidato_model->editarEstudios($estudios, $id_candidato);
          }
          else{
              $estudios = array(
                  'creacion' => $date,
                  'edicion' => $date,
                  'id_usuario' => $id_usuario,
                  'id_candidato' => $id_candidato,
                  'primaria_periodo' => $this->input->post('prim_periodo'),
                  'primaria_escuela' => $this->input->post('prim_escuela'),
                  'primaria_ciudad' => $this->input->post('prim_ciudad'),
                  'primaria_certificado' => $this->input->post('prim_certificado'),
                  'primaria_promedio' => $this->input->post('prim_promedio'),
                  'secundaria_periodo' => $this->input->post('sec_periodo'),
                  'secundaria_escuela' => $this->input->post('sec_escuela'),
                  'secundaria_ciudad' => $this->input->post('sec_ciudad'),
                  'secundaria_certificado' => $this->input->post('sec_certificado'),
                  'secundaria_promedio' => $this->input->post('sec_promedio'),
                  'preparatoria_periodo' => $this->input->post('prep_periodo'),
                  'preparatoria_escuela' => $this->input->post('prep_escuela'),
                  'preparatoria_ciudad' => $this->input->post('prep_ciudad'),
                  'preparatoria_certificado' => $this->input->post('prep_certificado'),
                  'preparatoria_promedio' => $this->input->post('prep_promedio'),
                  'licenciatura_periodo' => $this->input->post('lic_periodo'),
                  'licenciatura_escuela' => $this->input->post('lic_escuela'),
                  'licenciatura_ciudad' => $this->input->post('lic_ciudad'),
                  'licenciatura_certificado' => $this->input->post('lic_certificado'),
                  'licenciatura_promedio' => $this->input->post('lic_promedio'),
                  'actual_periodo' => $this->input->post('actual_periodo'),
                  'actual_escuela' => $this->input->post('actual_escuela'),
                  'actual_ciudad' => $this->input->post('actual_ciudad'),
                  'actual_certificado' => $this->input->post('actual_certificado'),
                  'actual_promedio' => $this->input->post('actual_promedio'),
                  'cedula_profesional' => $this->input->post('cedula'),
                  'otros_certificados' => $this->input->post('otro_certificado'),
                  'comentarios' => $this->input->post('estudios_comentarios'),
                  'carrera_inactivo' => $this->input->post('carrera_inactivo')
              );
              $this->candidato_model->guardarEstudios($estudios);
          }
          //$this->generarAvancesUST($id_candidato);
          $msj = array(
              'codigo' => 1,
              'msg' => 'success'
          );
      }
      echo json_encode($msj);
    }

    function guardarAntecendentesSociales(){
      $this->form_validation->set_rules('sindical', '¿Perteneció algún puesto sindical?', 'required|trim');
      $this->form_validation->set_rules('sindical_nombre', '¿A cuál?', 'required|trim');
      $this->form_validation->set_rules('sindical_cargo', '¿Cargo?', 'required|trim');
      $this->form_validation->set_rules('partido', '¿Pertenece algún partido político?', 'required|trim');
      $this->form_validation->set_rules('partido_nombre', '¿A cuál?', 'required|trim');
      $this->form_validation->set_rules('partido_cargo', '¿Cargo?', 'required|trim');
      $this->form_validation->set_rules('club', '¿Pertenece algún club deportivo?', 'required|trim');
      $this->form_validation->set_rules('deporte', '¿Qué deporte practica?', 'required|trim');
      $this->form_validation->set_rules('religion', '¿Qué religión profesa?', 'required|trim');
      $this->form_validation->set_rules('religion_frecuencia', '¿Con qué frecuencia?', 'required|trim');
      $this->form_validation->set_rules('bebidas', '>¿Ingiere bebidas alcohólicas?', 'required|trim');
      $this->form_validation->set_rules('bebidas_frecuencia', '¿Con qué frecuencia?', 'required|trim');
      $this->form_validation->set_rules('fumar', '¿Acostumbra fumar?', 'required|trim');
      $this->form_validation->set_rules('fumar_frecuencia', '¿Con qué frecuencia?', 'required|trim');
      $this->form_validation->set_rules('cirugia', '¿Ha tenido alguna intervención quirúrgica?', 'required|trim');
      $this->form_validation->set_rules('enfermedades', '¿Antecedentes de enfermedades en su familia?', 'required|trim');
      $this->form_validation->set_rules('corto_plazo', '¿Cuáles son sus planes a corto plazo?', 'required|trim');
      $this->form_validation->set_rules('mediano_plazo', '¿Cuáles son sus planes a mediano plazo?', 'required|trim');

      $this->form_validation->set_message('required','El campo {field} es obligatorio');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $id_usuario = $this->session->userdata('id');

        $data['sociales'] = $this->candidato_model->revisionAntecedentesSociales($id_candidato);
        if($data['sociales'] != ""){
          $sociales = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'sindical' => $this->input->post('sindical'),
            'sindical_nombre' => $this->input->post('sindical_nombre'),
            'sindical_cargo' => $this->input->post('sindical_cargo'),
            'partido' => $this->input->post('partido'),
            'partido_nombre' => $this->input->post('partido_nombre'),
            'partido_cargo' => $this->input->post('partido_cargo'),
            'club' => $this->input->post('club'),
            'deporte' => $this->input->post('deporte'),
            'religion' => $this->input->post('religion'),
            'religion_frecuencia' => $this->input->post('religion_frecuencia'),
            'bebidas' => $this->input->post('bebidas'),
            'bebidas_frecuencia' => $this->input->post('bebidas_frecuencia'),
            'fumar' => $this->input->post('fumar'),
            'fumar_frecuencia' => $this->input->post('fumar_frecuencia'),
            'cirugia' => $this->input->post('cirugia'),
            'enfermedades' => $this->input->post('enfermedades'),
            'corto_plazo' => $this->input->post('corto_plazo'),
            'mediano_plazo' => $this->input->post('mediano_plazo')
          );
          $this->candidato_model->updateSociales($sociales, $id_candidato);
        }
        else{
          $sociales = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'id_candidato' => $id_candidato,
            'sindical' => $this->input->post('sindical'),
            'sindical_nombre' => $this->input->post('sindical_nombre'),
            'sindical_cargo' => $this->input->post('sindical_cargo'),
            'partido' => $this->input->post('partido'),
            'partido_nombre' => $this->input->post('partido_nombre'),
            'partido_cargo' => $this->input->post('partido_cargo'),
            'club' => $this->input->post('club'),
            'deporte' => $this->input->post('deporte'),
            'religion' => $this->input->post('religion'),
            'religion_frecuencia' => $this->input->post('religion_frecuencia'),
            'bebidas' => $this->input->post('bebidas'),
            'bebidas_frecuencia' => $this->input->post('bebidas_frecuencia'),
            'fumar' => $this->input->post('fumar'),
            'fumar_frecuencia' => $this->input->post('fumar_frecuencia'),
            'cirugia' => $this->input->post('cirugia'),
            'enfermedades' => $this->input->post('enfermedades'),
            'corto_plazo' => $this->input->post('corto_plazo'),
            'mediano_plazo' => $this->input->post('mediano_plazo')
          );
          $this->candidato_model->saveSociales($sociales);
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
      }
      echo json_encode($msj);
    }

    function guardarReferenciasPersonales(){
      for($i = 1; $i <= 3; $i++){
        $this->form_validation->set_rules('nombre'.$i, 'Nombre de la referencia #'.$i, 'required|trim');
        $this->form_validation->set_rules('tiempo'.$i, 'Tiempo de conocerlo de la referencia #'.$i, 'required|trim');
        $this->form_validation->set_rules('telefono'.$i, 'Teléfono de la referencia #'.$i, 'required|trim|max_length[12]');
        $this->form_validation->set_rules('recomienda'.$i, '¿Lo recomienda? de la referencia #'.$i, 'required|trim');
        $this->form_validation->set_rules('comentario'.$i, 'Comentarios de la referencia #'.$i, 'required|trim');
      }
      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
        $msj = array(
          'codigo' => 0,
          'msg' => validation_errors()
        );
      } 
      else{
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $id_usuario = $this->session->userdata('id');
        
        $this->candidato_model->eliminarReferenciasPersonales($id_candidato);
        for($i = 1; $i <= 3; $i++){
          $data_refper = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'id_candidato' => $id_candidato,
            'nombre' => $this->input->post('nombre'.$i),
            'telefono' => $this->input->post('telefono'.$i),
            'tiempo_conocerlo' => $this->input->post('tiempo'.$i),
            'recomienda' => $this->input->post('recomienda'.$i),
            'comentario' => $this->input->post('comentario'.$i)
          );
          $this->candidato_model->saveRefPer($data_refper);
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
      }
      echo json_encode($msj);
    }

    function guardarAntecedenteLaboral(){
      $this->form_validation->set_rules('empresa', 'Nombre de la empresa', 'required|trim');
      $this->form_validation->set_rules('area', 'Área o Departamento', 'required|trim');
      $this->form_validation->set_rules('domicilio', 'Domicilio, calle y número', 'required|trim');
      $this->form_validation->set_rules('colonia', 'Colonia', 'required|trim');
      $this->form_validation->set_rules('cp', 'Código postal', 'required|trim|max_length[5]|numeric');
      $this->form_validation->set_rules('telefono', 'Teléfono', 'required|trim|max_length[12]');
      $this->form_validation->set_rules('tipo', 'Tipo de empresa', 'required|trim');
      $this->form_validation->set_rules('puesto', 'Puesto desempeñado', 'required|trim');
      $this->form_validation->set_rules('periodo', 'Periodo trabajado, mes y año', 'required|trim');
      $this->form_validation->set_rules('jefenombre', 'Nombre del último jefe', 'required|trim');
      $this->form_validation->set_rules('jefepuesto', 'Puesto del último jefe', 'required|trim');
      $this->form_validation->set_rules('sueldo1', 'Sueldo mensual inicial', 'required|trim|numeric');
      $this->form_validation->set_rules('sueldo2', 'Sueldo mensual final', 'required|trim|numeric');
      $this->form_validation->set_rules('actividades', '¿En qué consistía su trabajo?', 'required|trim');
      $this->form_validation->set_rules('razon', 'Causa de separación', 'required|trim');
      $this->form_validation->set_rules('comentarios', 'Comentarios y observaciones', 'trim');
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $num = $this->input->post('num');
        $id_usuario = $this->session->userdata('id');

        $data['refs'] = $this->candidato_model->revisionAntecedenteLaboral($id_candidato, $num);
        if($data['refs']){
            $datos = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_candidato' => $id_candidato,
                'numero_referencia' => $num,
                'empresa' => $this->input->post('empresa'), 
                'area' => $this->input->post('area'),
                'calle' => $this->input->post('domicilio'), 
                'colonia' => $this->input->post('colonia'),
                'cp' => $this->input->post('cp'),
                'telefono' => $this->input->post('telefono'), 
                'tipo_empresa' => $this->input->post('tipo'),
                'puesto' => $this->input->post('puesto'), 
                'periodo' => $this->input->post('periodo'), 
                'jefe_nombre' => $this->input->post('jefenombre'), 
                'jefe_puesto' => $this->input->post('jefepuesto'), 
                'sueldo_inicial' => $this->input->post('sueldo1'), 
                'sueldo_final' => $this->input->post('sueldo2'), 
                'actividades' => $this->input->post('actividades'), 
                'causa_separacion' => $this->input->post('razon'),
                'trabajo_calidad' => $this->input->post('calidad'), 
                'trabajo_puntualidad' => $this->input->post('puntualidad'), 
                'trabajo_honesto' => $this->input->post('honesto'), 
                'trabajo_responsabilidad' => $this->input->post('responsabilidad'),
                'trabajo_adaptacion' => $this->input->post('adaptacion'), 
                'trabajo_actitud_jefes' => $this->input->post('actitud_jefes'),
                'trabajo_actitud_companeros' => $this->input->post('actitud_comp'),
                'comentarios' => $this->input->post('comentarios')
            );
            $this->candidato_model->editarAntecedenteLaboral($datos, $id_candidato, $num);
            $msj = array(
              'codigo' => 1,
              'msg' => 'success'
            );
        }
        else{
            $verificacion_reflab = array(
                'creacion' => $date,
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_candidato' => $id_candidato,
                'numero_referencia' => $num,
                'empresa' => $this->input->post('empresa'), 
                'area' => $this->input->post('area'),
                'calle' => $this->input->post('domicilio'), 
                'colonia' => $this->input->post('colonia'),
                'cp' => $this->input->post('cp'),
                'telefono' => $this->input->post('telefono'), 
                'tipo_empresa' => $this->input->post('tipo'),
                'puesto' => $this->input->post('puesto'), 
                'periodo' => $this->input->post('periodo'), 
                'jefe_nombre' => $this->input->post('jefenombre'), 
                'jefe_puesto' => $this->input->post('jefepuesto'), 
                'sueldo_inicial' => $this->input->post('sueldo1'), 
                'sueldo_final' => $this->input->post('sueldo2'), 
                'actividades' => $this->input->post('actividades'), 
                'causa_separacion' => $this->input->post('razon'),
                'trabajo_calidad' => $this->input->post('calidad'), 
                'trabajo_puntualidad' => $this->input->post('puntualidad'), 
                'trabajo_honesto' => $this->input->post('honesto'), 
                'trabajo_responsabilidad' => $this->input->post('responsabilidad'),
                'trabajo_adaptacion' => $this->input->post('adaptacion'), 
                'trabajo_actitud_jefes' => $this->input->post('actitud_jefes'),
                'trabajo_actitud_companeros' => $this->input->post('actitud_comp'),
                'comentarios' => $this->input->post('comentarios')
            );
            $id_nuevo = $this->candidato_model->guardarAntecedenteLaboral($verificacion_reflab);
            $msj = array(
              'codigo' => 2,
              'msg' => $id_nuevo
            );
        }
      }
      echo json_encode($msj);
    }

    function guardarInvestigacionLegal(){
      $this->form_validation->set_rules('penal', 'Penal', 'required|trim');
      $this->form_validation->set_rules('penal_notas', 'Penal notas', 'required|trim');
      $this->form_validation->set_rules('civil', 'Civil', 'required|trim');
      $this->form_validation->set_rules('civil_notas', 'Civil notas', 'required|trim');
      $this->form_validation->set_rules('laboral', 'Laboral', 'required|trim');
      $this->form_validation->set_rules('laboral_notas', 'Laboral notas', 'required|trim');
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      } 
      else{
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $id_usuario = $this->session->userdata('id');

        $data['legal'] = $this->candidato_model->revisionInvestigacionLegal($id_candidato);
        if($data['legal']){
            $datos = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'penal' => $this->input->post('penal'),
                'penal_notas' => $this->input->post('penal_notas'),
                'civil' => $this->input->post('civil'),
                'civil_notas' => $this->input->post('civil_notas'),
                'laboral' => $this->input->post('laboral'),
                'laboral_notas' => $this->input->post('laboral_notas')
            );
            foreach ($data['legal'] as $dato) {
                $id = $dato->id;
            }
            $this->candidato_model->editarInvestigacionLegal($datos, $id);
        }
        else{
          $datos = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              'id_candidato' => $id_candidato,
              'penal' => $this->input->post('penal'),
              'penal_notas' => $this->input->post('penal_notas'),
              'civil' => $this->input->post('civil'),
              'civil_notas' => $this->input->post('civil_notas'),
              'laboral' => $this->input->post('laboral'),
              'laboral_notas' => $this->input->post('laboral_notas')
          );
          $id = $this->candidato_model->guardarInvestigacionLegal($datos);
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
      }
      echo json_encode($msj);
    }

    function actualizarProcesoCandidato(){
      date_default_timezone_set('America/Mexico_City');
      $date = date('Y-m-d H:i:s');
      $fecha_dia = date('d-m-Y');
      $id_usuario = $this->session->userdata('id');
      $id_candidato = $this->input->post('id_candidato');
      $id_doping = $this->input->post('id_doping');

      $pruebas = $this->candidato_model->getPruebasCandidato($id_candidato);
      $datos_pruebas = array(
        'creacion' => $date,
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'id_candidato' => $id_candidato,
        'id_cliente' => $pruebas->id_cliente,
        'socioeconomico' => $pruebas->socioeconomico,
        'tipo_antidoping' => $pruebas->tipo_antidoping,
        'antidoping' => $pruebas->antidoping,
        'status_doping' => 0,
        'tipo_psicometrico' => $pruebas->tipo_psicometrico,
        'psicometrico' => $pruebas->psicometrico,
        'medico' => $pruebas->medico,
        'buro_credito' => $pruebas->buro_credito,
        'sociolaboral' => $pruebas->sociolaboral,
        'ofac' => $pruebas->ofac,
        'resultado_ofac' => $pruebas->resultado_ofac,
        'oig' => $pruebas->oig,
        'resultado_oig' => $pruebas->resultado_oig,
        'sam' => $pruebas->sam,
        'resultado_sam' => $pruebas->resultado_sam,
        'data_juridica' => $pruebas->data_juridica,
        'res_data_juridica' => $pruebas->res_data_juridica,
        'otro_requerimiento' => $pruebas->otro_requerimiento
      );
      $this->candidato_model->eliminarCandidatoPruebas($id_candidato);
      $this->candidato_model->crearPruebas($datos_pruebas);
      $this->doping_model->cambiarEstatusDoping($id_candidato);
      //Historial
      $info = $this->candidato_model->getInfoCandidatoEspecifico($id_candidato);
      $fecha_alta = fecha_sinhora_espanol_front($info->fecha_alta);
      $visita = ($info->visitador == 1)? 'SI':'NO';
      $examen_antidoping = ($pruebas->antidoping > 0)? 'SI':'NO';
      $examen_psicometrico = ($pruebas->psicometrico == 1)? 'SI':'NO';
      $examen_medico = ($pruebas->medico == 1)? 'SI':'NO';
      $buro = ($pruebas->buro_credito == 1)? 'SI':'NO';
      switch ($info->status_bgc) {
          case 1:
              $estatus_final = 'POSITIVO';
              break;
          case 2:
              $estatus_final = 'NEGATIVO';
              break;
          case 3:
              $estatus_final = 'A CONSIDERACION';
              break;
      }
      $historial = array(
        'creacion' => $date,
        'id_candidato' => $id_candidato,
        'id_usuario' => $info->id_usuario,
        'usuario' => $info->usuario,
        'id_tipo_proceso' => $info->id_tipo_proceso,
        'puesto' => $info->puesto,
        'fecha_alta' => $fecha_alta,
        'visita' => $visita,
        'antidoping' => $examen_antidoping,
        'psicometrico' => $examen_psicometrico,
        'medico' => $examen_medico,
        'buro_credito' => $buro,
        'tiempo_proceso' => $info->tiempo_parcial,
        'status_bgc' => $estatus_final
      );
      $this->candidato_model->guardarHistorialCandidato($historial);
        
      $this->candidato_model->eliminarCandidatoFinalizado($id_candidato);
      $this->candidato_model->eliminarCandidatoBGC($id_candidato);
      //Borrar datos de la Visita
      /*$this->candidato_model->eliminarCandidatoEgresos($id_candidato);
      $this->candidato_model->eliminarCandidatoHabitacion($id_candidato);
      $this->candidato_model->eliminarCandidatoVecinos($id_candidato);
      $this->candidato_model->eliminarCandidatoPersona($id_candidato);
      $this->candidato_model->eliminarCandidatoPersonaMismoTrabajo($id_candidato);*/
      //Doping
      $dop = array(
        'status' => 1
      );
      $this->candidato_model->cambiarEstatusDopingCandidato($dop, $id_candidato);

      $datos = array(
          'edicion' => $date,
          'fecha_alta' => $date,
          'muebles' => '',
          'adeudo_muebles' => 0,
          'ingresos' => '',
          'comentario' => '',
          'status' => 0,
          'status_bgc' => 0,
          'visitador' => 0,
          'tiempo_parcial' => 0
      );
      $this->candidato_model->editarCandidato($datos, $id_candidato);

      $row = $this->candidato_model->checkActualizacionCandidato($id_candidato);
      if($row != null){
        $act = array(
            'edicion' => $date,
            'usuarios' => $row->usuarios.','.$id_usuario,
            'fechas' => $row->fechas.','.$fecha_dia,
            'num' => ($row->num + 1)
        );
        $this->candidato_model->editarActualizacionCandidato($act, $id_candidato);
      }
      else{
        $act = array(
            'creacion' => $date,
            'edicion' => $date,
            'usuarios' => $id_usuario,
            'id_candidato' => $id_candidato,
            'fechas' => $fecha_dia,
            'num' => 1
        );
        $this->candidato_model->guardarActualizacionCandidato($act);
      }
      echo $salida = 1;
    }

    function guardarIntegranteFamiliar(){
      $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
      $this->form_validation->set_rules('parentesco', 'Parentesco', 'required|trim');
      $this->form_validation->set_rules('edad', 'Edad', 'required|trim|numeric|max_length[3]');
      $this->form_validation->set_rules('civil', 'Estado civil', 'required|trim');
      $this->form_validation->set_rules('escolaridad', 'Escolaridad', 'required|trim');
      $this->form_validation->set_rules('vive', '¿Vive con usted?', 'required|trim');
      $this->form_validation->set_rules('empresa', 'Empresa', 'required|trim');
      $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
      $this->form_validation->set_rules('antiguedad', 'Antigüedad', 'required|trim');
      $this->form_validation->set_rules('sueldo', 'Sueldo', 'required|trim|numeric');
      $this->form_validation->set_rules('aportacion', 'Aportación', 'required|trim|numeric');
      $this->form_validation->set_rules('muebles', 'Muebles e inmuebles', 'required|trim');
      $this->form_validation->set_rules('adeudo', 'Adeudo', 'required|trim');
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      }
      else{
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $id_persona = $this->input->post('id_persona');
        $id_usuario = $this->session->userdata('id');

        $datos = array(
          'edicion' => $date,
          'nombre' => $this->input->post('nombre'),
          'id_tipo_parentesco' => $this->input->post('parentesco'),
          'edad' => $this->input->post('edad'),
          'id_grado_estudio' =>  $this->input->post('escolaridad'),
          'misma_vivienda' =>  $this->input->post('vive'),
          'estado_civil' =>  $this->input->post('civil'),
          'empresa' =>  $this->input->post('empresa'),
          'puesto' =>  $this->input->post('puesto'),
          'antiguedad' => $this->input->post('antiguedad'),
          'sueldo' =>  $this->input->post('sueldo'),
          'monto_aporta' =>  $this->input->post('aportacion'),
          'muebles' =>  $this->input->post('muebles'),
          'adeudo' =>  $this->input->post('adeudo')
        );
        $this->candidato_model->editarIntegranteFamiliar($datos, $id_persona);

        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
      }
      echo json_encode($msj);
    }

    function editarExtrasCandidato(){
      $this->form_validation->set_rules('notas', 'Notas', 'required|trim');
      $this->form_validation->set_rules('muebles', 'Muebles e inmuebles del candidato', 'required|trim');
      $this->form_validation->set_rules('adeudo', 'Adeudo', 'required|trim');
      $this->form_validation->set_rules('ingresos', 'Ingresos del candidato', 'required|trim|numeric');
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');


      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      }
      else{
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $datos = array(
            'edicion' => $date,
            'muebles' => $this->input->post('muebles'),
            'comentario' => $this->input->post('notas'),
            'adeudo_muebles' => $this->input->post('adeudo'),
            'ingresos' => $this->input->post('ingresos')

        );
        $this->candidato_model->editarCandidato($datos, $this->input->post('id_candidato'));
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
      }
      echo json_encode($msj);
    }

    function guardarEgresos(){
      $this->form_validation->set_rules('renta', 'Renta', 'required|trim|numeric');
      $this->form_validation->set_rules('alimentos', 'Alimentos', 'required|trim|numeric');
      $this->form_validation->set_rules('servicios', 'Servicios', 'required|trim|numeric');
      $this->form_validation->set_rules('transportes', 'Transportes', 'required|trim|numeric');
      $this->form_validation->set_rules('otros_gastos', 'Otros', 'required|trim|numeric');
      $this->form_validation->set_rules('solvencia', 'Cuando los egresos son mayores a los ingresos, ¿cómo los solventa?', 'required|trim');
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');


      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      }
      else{
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $id_usuario = $this->session->userdata('id');

        $data['egresos'] = $this->candidato_model->revisionEgresos($id_candidato);
        if($data['egresos']){
            $datos = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'renta' => $this->input->post('renta'),
                'alimentos' => $this->input->post('alimentos'),
                'servicios' => $this->input->post('servicios'),
                'transporte' => $this->input->post('transportes'),
                'otros' => $this->input->post('otros_gastos'),
                'solvencia' => $this->input->post('solvencia')
            );
            foreach ($data['egresos'] as $dato) {
                $id = $dato->id;
            }
            $this->candidato_model->editarEgresos($datos, $id);
        }
        else{
            $datos = array(
                'creacion' => $date,
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_candidato' => $id_candidato,
                'renta' => $this->input->post('renta'),
                'alimentos' => $this->input->post('alimentos'),
                'servicios' => $this->input->post('servicios'),
                'transporte' => $this->input->post('transportes'),
                'otros' => $this->input->post('otros_gastos'),
                'solvencia' => $this->input->post('solvencia')
            );
            $id = $this->candidato_model->guardarEgresos($datos);
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
      }
      echo json_encode($msj);
    }

    function guardarHabitacion(){
      $this->form_validation->set_rules('tiempo_residencia', 'Tiempo de residencia en el domicilio actual', 'required|trim');
      $this->form_validation->set_rules('nivel_zona', 'Nivel de la zona', 'required|trim');
      $this->form_validation->set_rules('tipo_vivienda', 'Tipo de vivienda', 'required|trim');
      $this->form_validation->set_rules('recamaras', 'Recámaras', 'required|trim|numeric');
      $this->form_validation->set_rules('banios', 'Baños', 'required|trim');
      $this->form_validation->set_rules('distribucion', 'Distribución', 'required|trim');
      $this->form_validation->set_rules('calidad_mobiliario', 'Calidad mobiliario', 'required|trim|numeric');
      $this->form_validation->set_rules('mobiliario', 'Mobiliario', 'required|trim');
      $this->form_validation->set_rules('tamanio_vivienda', 'Tamaño vivienda', 'required|trim');
      $this->form_validation->set_rules('condiciones_vivienda', 'Condiciones de la vivienda', 'required|trim');
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');


      $msj = array();
      if ($this->form_validation->run() == FALSE) {
          $msj = array(
              'codigo' => 0,
              'msg' => validation_errors()
          );
      }
      else{
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $id_usuario = $this->session->userdata('id');
        $data['datos'] = $this->candidato_model->revisionHabitacion($id_candidato);
        if($data['datos']){
          $datos = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              'tiempo_residencia' => $this->input->post('tiempo_residencia'),
              'id_tipo_nivel_zona' => $this->input->post('nivel_zona'),
              'id_tipo_vivienda' => $this->input->post('tipo_vivienda'),
              'recamaras' => $this->input->post('recamaras'),
              'banios' => $this->input->post('banios'),
              'distribucion' => $this->input->post('distribucion'),
              'calidad_mobiliario' => $this->input->post('calidad_mobiliario'),
              'mobiliario' => $this->input->post('mobiliario'),
              'tamanio_vivienda' => $this->input->post('tamanio_vivienda'),
              'id_tipo_condiciones' => $this->input->post('condiciones_vivienda')
          );
          foreach ($data['datos'] as $dato) {
              $id = $dato->id;
          }
          $this->candidato_model->editarHabitacion($datos, $id);
        }
        else{
          $datos = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              'id_candidato' => $id_candidato,
              'tiempo_residencia' => $this->input->post('tiempo_residencia'),
              'id_tipo_nivel_zona' => $this->input->post('nivel_zona'),
              'id_tipo_vivienda' => $this->input->post('tipo_vivienda'),
              'recamaras' => $this->input->post('recamaras'),
              'banios' => $this->input->post('banios'),
              'distribucion' => $this->input->post('distribucion'),
              'calidad_mobiliario' => $this->input->post('calidad_mobiliario'),
              'mobiliario' => $this->input->post('mobiliario'),
              'tamanio_vivienda' => $this->input->post('tamanio_vivienda'),
              'id_tipo_condiciones' => $this->input->post('condiciones_vivienda')
          );
          $id = $this->candidato_model->guardarHabitacion($datos);
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
      }
      echo json_encode($msj);
    }

    function guardarReferenciasVecinales(){
      $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
      $this->form_validation->set_rules('domicilio', 'Domicilio', 'required|trim');
      $this->form_validation->set_rules('telefono', 'Teléfono', 'required|trim');
      $this->form_validation->set_rules('concepto', '¿Qué concepto tiene del aspirante?', 'required|trim');
      $this->form_validation->set_rules('familia', '¿En qué concepto tiene a la familia como vecinos?', 'required|trim');
      $this->form_validation->set_rules('civil', '¿Conoce el estado civil del aspirante? ¿Cuál es?', 'required|trim');
      $this->form_validation->set_rules('hijos', '¿Tiene hijos?', 'required|trim');
      $this->form_validation->set_rules('sabetrabaja', '¿Sabe en dónde trabaja?', 'required|trim');
      $this->form_validation->set_rules('notas', 'Notas', 'required|trim');
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');


      $msj = array();
      if ($this->form_validation->run() == FALSE) {
        $msj = array(
            'codigo' => 0,
            'msg' => validation_errors()
        );
      }
      else{
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $idrefvec = $this->input->post('idrefvec');
        $id_usuario = $this->session->userdata('id');
        $num = $this->input->post('num');

        if($idrefvec != ""){
          $datos = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'nombre' => $this->input->post('nombre'),
            'telefono' => $this->input->post('telefono'),
            'domicilio' => $this->input->post('domicilio'),
            'concepto_candidato' => $this->input->post('concepto'),
            'concepto_familia' => $this->input->post('familia'),
            'civil_candidato' => $this->input->post('civil'),
            'hijos_candidato' => $this->input->post('hijos'),
            'sabe_trabaja' => $this->input->post('sabetrabaja'),
            'notas' => $this->input->post('notas')
          );
          $this->candidato_model->updateReferenciaVecinal($idrefvec, $datos);
          $msj = array(
            'codigo' => 1,
            'msg' => 'success'
          );
        }
        else{
            $datos = array(
                'creacion' => $date,
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_candidato' => $id_candidato,
                'nombre' => $this->input->post('nombre'),
                'telefono' => $this->input->post('telefono'),
                'domicilio' => $this->input->post('domicilio'),
                'concepto_candidato' => $this->input->post('concepto'),
                'concepto_familia' => $this->input->post('familia'),
                'civil_candidato' => $this->input->post('civil'),
                'hijos_candidato' => $this->input->post('hijos'),
                'sabe_trabaja' => $this->input->post('sabetrabaja'),
                'notas' => $this->input->post('notas')
            );
            $id = $this->candidato_model->insertReferenciaVecinal($datos);
            $msj = array(
              'codigo' => 2,
              'msg' => $id
            );
        }
      }
      echo json_encode($msj);
    }

    function terminarProceso(){
      $this->form_validation->set_rules('personal1', 'Descripción de datos personales', 'required|trim');
      $this->form_validation->set_rules('personal2', 'Descripción de hábitos y referencias personales', 'required|trim');
      $this->form_validation->set_rules('laboral1', 'Número de referencias laborales señaladas', 'required|trim');
      $this->form_validation->set_rules('laboral2', 'Descripción de las referencias laborales', 'required|trim');
      $this->form_validation->set_rules('socio1', 'Descripción de la vivienda, zona y condiciones', 'required|trim');
      $this->form_validation->set_rules('socio2', 'Descripción de gastos y referencias vecinales', 'required|trim');
      $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
        $msj = array(
            'codigo' => 0,
            'msg' => validation_errors()
        );
      }
      else{
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $id_usuario = $this->session->userdata('id');

        $num = $this->candidato_model->checkConclusionesCandidato($id_candidato);
        if($num > 0){
          $finalizado = array(
            'id_usuario' => $id_usuario,
            'descripcion_personal1' => $this->input->post('personal1'),
            'descripcion_personal2' => $this->input->post('personal2'),
            'descripcion_laboral1' => $this->input->post('laboral1'),
            'descripcion_laboral2' => $this->input->post('laboral2'),
            'descripcion_socio1' => $this->input->post('socio1'),
            'descripcion_socio2' => $this->input->post('socio2'),
            'recomendable' => $this->input->post('recomendable')
          );
          $this->candidato_model->editarProcesoFinalizado($finalizado, $id_candidato);
          $this->candidato_model->statusBGCCandidato($this->input->post('recomendable'), $id_candidato);
        }
        else{
          $finalizado = array(
            'creacion' => $date,
            'id_usuario' => $id_usuario,
            'id_candidato' => $id_candidato,
            'descripcion_personal1' => $this->input->post('personal1'),
            'descripcion_personal2' => $this->input->post('personal2'),
            'descripcion_laboral1' => $this->input->post('laboral1'),
            'descripcion_laboral2' => $this->input->post('laboral2'),
            'descripcion_socio1' => $this->input->post('socio1'),
            'descripcion_socio2' => $this->input->post('socio2'),
            'recomendable' => $this->input->post('recomendable')
          );
          $this->candidato_model->guardarProcesoFinalizado($finalizado);
          $this->candidato_model->statusBGCCandidato($this->input->post('recomendable'), $id_candidato);

          $data['usuarios_cliente'] = $this->candidato_model->getCorreoCliente($id_candidato);
          $data['usuarios_subcliente'] = $this->candidato_model->getCorreoSubCliente($id_candidato);
          if($data['usuarios_cliente']){
            foreach($data['usuarios_cliente'] as $cliente){
              $from = $this->config->item('smtp_user');
              $to = $cliente->correo;
              $subject = "RODI - Proceso finalizado del candidato: ".$cliente->candidato;
              $datos['candidato'] = $cliente->candidato;
              $message = $this->load->view('correos/proceso_finalizado_espanol',$datos,TRUE);
                      
              $this->load->library('phpmailer_lib');
              $mail = $this->phpmailer_lib->load();
              $mail->isSMTP();
              $mail->Host     = 'mail.rodicontrol.com';
              $mail->SMTPAuth = true;
              $mail->Username = 'rodicontrol@rodicontrol.com';
              $mail->Password = 'r49o*&rUm%91';
              $mail->SMTPSecure = 'ssl';
              $mail->Port     = 465;
              $mail->setFrom('rodicontrol@rodicontrol.com', 'Rodi');
              $mail->addAddress($to);
              $mail->Subject = $subject;
              $mail->isHTML(true);
              $mailContent = $message;
              $mail->Body = $mailContent;
              $mail->send();
            }
          }
          if($data['usuarios_subcliente']){
            foreach($data['usuarios_subcliente'] as $subcliente){
              $from = $this->config->item('smtp_user');
              $to = $subcliente->correo;
              $subject = "RODI - Proceso finalizado del candidato: ".$subcliente->candidato;
              $datos['candidato'] = $subcliente->candidato;
              $message = $this->load->view('correos/proceso_finalizado_espanol',$datos,TRUE);
                      
              $this->load->library('phpmailer_lib');
              $mail = $this->phpmailer_lib->load();
              $mail->isSMTP();
              $mail->Host     = 'mail.rodicontrol.com';
              $mail->SMTPAuth = true;
              $mail->Username = 'rodicontrol@rodicontrol.com';
              $mail->Password = 'r49o*&rUm%91';
              $mail->SMTPSecure = 'ssl';
              $mail->Port     = 465;
              $mail->setFrom('rodicontrol@rodicontrol.com', 'Rodi');
              $mail->addAddress($to);
              $mail->Subject = $subject;
              $mail->isHTML(true);
              $mailContent = $message;
              $mail->Body = $mailContent;
              $mail->send();
            }
          }
          $msj = array(
            'codigo' => 1,
            'msg' => 'success'
          );
        }
      }
      echo json_encode($msj);
    }

    function crearPrevioPDF(){
      $mpdf = new \Mpdf\Mpdf();
      date_default_timezone_set('America/Mexico_City');
      $data['hoy'] = date("d-m-Y");
      $hoy = date("d-m-Y");
      $id_candidato = $_POST['idPrevio'];
      $data['datos'] = $this->candidato_model->getInfoCandidato($id_candidato);
      $id_usuario = $this->session->userdata('id');
      $tipo_usuario = $this->session->userdata('tipo');
      if($tipo_usuario == 1){
        $usuario = $this->usuario_model->getDatosUsuarioInterno($id_usuario);
      }
      if($tipo_usuario == 2){
        $usuario = $this->usuario_model->getDatosUsuarioCliente($id_usuario);
      }
      if($tipo_usuario == 4){
        $usuario = $this->usuario_model->getDatosUsuarioSubcliente($id_usuario);
      }
      foreach($data['datos'] as $row){
          $f = $row->fecha_alta;
          $ffin = $row->fecha_fin;
          $nombreCandidato = $row->nombre." ".$row->paterno." ".$row->materno;
          $cliente = $row->cliente;
          $subcliente = $row->subcliente;
          $id_doping = $row->idDoping;
          $id_cliente = $row->id_cliente;
      }
      $fecha_fin = formatoFechaEspanol($ffin);
      $f_alta = formatoFechaEspanol($f);
      $hoy = formatoFecha($hoy);
      $data['finalizado'] = $this->candidato_model->getDatosFinalizadosCandidato($id_candidato);
      //$data['doping'] = $this->candidato_model->getDopingCandidato($id_candidato);
      $data['pruebas'] = $this->candidato_model->getPruebasCandidato($id_candidato);
      $data['docs'] = $this->candidato_model->getDocumentacionCandidato($id_candidato);
      $data['academico'] = $this->candidato_model->getEstudiosCandidato($id_candidato);
      $data['sociales'] = $this->candidato_model->getAntecedentesSociales($id_candidato);
      $data['familia'] = $this->candidato_model->getFamiliares($id_candidato);
      $data['egresos'] = $this->candidato_model->getEgresosFamiliares($id_candidato);
      $data['vivienda'] = $this->candidato_model->getDatosVivienda($id_candidato);
      $data['ref_personal'] = $this->candidato_model->getReferenciasPersonales($id_candidato);
      $data['ref_vecinal'] = $this->candidato_model->getReferenciasVecinales($id_candidato);
      $data['legal'] = $this->candidato_model->getVerificacionLegal($id_candidato);
      $data['nom'] = $this->candidato_model->getTrabajosNoMencionados($id_candidato);
      $data['finalizado'] = $this->candidato_model->getDatosFinalizadosCandidato($id_candidato);
      $data['det_estudio'] = $this->candidato_model->getStatusVerificacionEstudios($id_candidato);
      $data['ref_laboral'] = $this->candidato_model->getAntecedentesLaborales($id_candidato);
      $data['analista'] = $this->candidato_model->getAnalista($id_candidato);
      $data['coordinadora'] = $this->candidato_model->getCoordinadora($id_candidato);
      $data['cliente'] = $cliente;
      $data['subcliente'] = $subcliente;
      $data['fecha_fin'] = $ffin;

      $checkDoping = $this->candidato_model->confirmarAntidoping($id_candidato);
      if($checkDoping->tipo_antidoping == 1 && $checkDoping->status_doping == 1){
          $doping = $this->doping_model->getDatosDoping($id_doping);
          $dop['doping'] = $doping;
          $data['doc_doping'] = $this->load->view('pdfs/doping_pdf',$dop,TRUE);
      }
      else{
          $data['doc_doping'] = "";
      }
      $html = $this->load->view('pdfs/previo_espanol_pdf',$data,TRUE);
      $mpdf->setAutoTopMargin = 'stretch';
      $mpdf->AddPage();
      if($id_cliente == 39){
          $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 100px;" src="'.base_url().'img/logo_talink.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: '.$f_alta.'<br>Fecha de Elaboración: '.$fecha_fin.'</div>');
          
      }
      else{

          $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="'.base_url().'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: '.$f_alta.'<br>Fecha de Elaboración: '.$fecha_fin.'</div>');
          $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="'.base_url().'img/logo_pie.png"></div>');
      }        
      //Cifrar pdf
      $nombreArchivo = substr( md5(microtime()), 1, 12);
      /*$claveAleatoria = substr( md5(microtime()), 1, 8);
      $clave = ($usuario->clave != null)? $usuario->clave:$claveAleatoria;
      $mpdf->SetProtection(array(), $clave, 'r0d1@');*/
      
      $mpdf->WriteHTML($html);
      $mpdf->Output(''.$nombreArchivo.'.pdf','D'); // opens in browser
    }




    public function descripcionesCliente($modulo)
{
    // Cargar configuraciones y otros datos necesarios
    $config = $this->funciones_model->getConfiguraciones();
    $data['version'] = $config->version_sistema;

    // Cargar la vista correspondiente según el módulo
    switch ($modulo) {
        case 1:
            $view = $this->load->view('reclutamiento/descripcion_modulo', $data, true);
            break;
        case 2:
            $view = $this->load->view('moduloPreEmpleados/descripcion_modulo', $data, true);
            break;
        case 3:
            $view = $this->load->view('moduloEmpleados/descripcion_modulo', $data, true);
            break;
        case 4:
            $view = $this->load->view('moduloExEmpleados/descripcion_modulo', $data, true);
            break;
        default:
            $view = "Módulo no encontrado.";
            break;
    }

    // Agregar footer si es necesario
    $footerView = $this->load->view('adminpanel/footer', [], true);

    // Renderizar las vistas
    echo $view;
    echo $footerView;
}


}
