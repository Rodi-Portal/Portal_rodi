<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cliente_Monex extends CI_Controller{

  function __construct(){
    parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
  }

  function index(){
    if ($this->session->userdata('logueado') && $this->session->userdata('tipo') == 1) {
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
      $info['estados'] = $this->funciones_model->getEstados();
      $info['civiles'] = $this->funciones_model->getEstadosCiviles();
      $data['baterias'] = $this->funciones_model->getBateriasPsicometricas();
      $info['subclientes'] = $this->cliente_general_model->getSubclientes($id_cliente);
      $data['personales'] = $this->funciones_model->getTiposPersona();
      $info['puestos'] = $this->funciones_model->getPuestos();
      $info['grados'] = $this->funciones_model->getGradosEstudio();
      $info['drogas'] = $this->funciones_model->getPaquetesAntidoping();
      $data['parentescos'] = $this->funciones_model->getParentescos();
      $info['escolaridades'] = $this->funciones_model->getEscolaridades();
      $info['parentescos'] = $this->funciones_model->getParentescos();
      $data['escolaridades'] = $this->funciones_model->getEscolaridades();
      $info['grados_estudios'] = $this->funciones_model->getGradosEstudio();
      $info['zonas'] = $this->funciones_model->getNivelesZona();
      $info['viviendas'] = $this->funciones_model->getTiposVivienda();
      $info['condiciones'] = $this->funciones_model->getTiposCondiciones();
      $data['examenes_doping'] = $this->funciones_model->getExamenDoping($id_cliente);
      $info['studies'] = $this->funciones_model->getTiposEstudios();
      $info['cands'] = $this->cliente_general_model->getCandidatosCliente($id_cliente);
      $info['usuarios'] = $this->funciones_model->getTipoAnalistas(1);
      $info['tipos_docs'] = $this->funciones_model->getTiposDocumentos();
			$info['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();


      $vista['modals'] = $this->load->view('modals/mdl_clientes_alterno', $info, TRUE);
      $config = $this->funciones_model->getConfiguraciones();
			$data['version'] = $config->version_sistema;

      //Modals
		  $modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);

      //$cliente = $this->cliente_general_model->getDatosCliente($id_cliente);
      $this->load
      ->view('adminpanel/header', $data)
      ->view('adminpanel/scripts', $modales)
      ->view('analista/candidatos_espanol_alterno', $vista)
      ->view('adminpanel/footer');
    }
  }
  /*----------------------------------------*/
  /*  Consultas 
  /*----------------------------------------*/
    function getCandidatos(){
      $id_cliente = $_GET['id'];
      $cand['recordsTotal'] = $this->cliente_alternativo_model->getTotal($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'));
      $cand['recordsFiltered'] = $this->cliente_alternativo_model->getTotal($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'));
      $cand['data'] = $this->cliente_alternativo_model->getCandidatos($id_cliente, $this->session->userdata('idrol'), $this->session->userdata('id'));
      $this->output->set_output( json_encode( $cand ) );
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
            $salida .= $ref->donde_conocerlo."@@";
            $salida .= $ref->sabe_trabajo."@@";
            $salida .= $ref->sabe_vive."@@";
            $salida .= $ref->recomienda."@@";
            $salida .= $ref->comentario."@@";
            $salida .= $ref->id."###";
          }
          echo $salida;
      }
      else{
          echo $salida = 0;
      }
    }
    function getPersonasMismoTrabajo(){
      $id_candidato = $this->input->post('id_candidato');
      $salida = "";
      $data['personas'] = $this->candidato_model->getPersonasMismoTrabajo($id_candidato);
      if($data['personas']){
          foreach($data['personas'] as $p){
            $salida .= $p->id."@@";
            $salida .= $p->nombre."@@";
            $salida .= $p->puesto."###";
          }
          echo $salida;
      }
      else{
          echo $salida = 0;
      }
    }
    function getReferenciasLaborales(){
      $id_candidato = $this->input->post('id_candidato');
      $salida = "";
      $data['referencias'] = $this->candidato_model->getReferenciasLaborales($id_candidato);
      if($data['referencias']){
          foreach($data['referencias'] as $ref){
              $salida .= $ref->empresa."@@";
              $salida .= $ref->direccion."@@";
              $salida .= $ref->fecha_entrada_txt."@@";
              $salida .= $ref->fecha_salida_txt."@@";
              $salida .= $ref->telefono."@@";
              $salida .= $ref->puesto1."@@";
              $salida .= $ref->puesto2."@@";
              $salida .= $ref->salario1_txt."@@";
              $salida .= $ref->salario2_txt."@@";
              $salida .= $ref->jefe_nombre."@@";
              $salida .= $ref->jefe_correo."@@";
              $salida .= $ref->jefe_puesto."@@";
              $salida .= $ref->causa_separacion."@@";
              $salida .= $ref->id."###";
          }
          
      }
      echo $salida;
    }
    function getVerificacionesLaborales(){
      $id_candidato = $_POST['id_candidato'];
      $salida = "";
      $data['referencias'] = $this->candidato_model->getVerificacionReferencias($id_candidato);
      if($data['referencias']){
        foreach($data['referencias'] as $ref){
          $salida .= $ref->empresa."@@";
          $salida .= $ref->direccion."@@";
          $salida .= $ref->fecha_entrada_txt."@@";
          $salida .= $ref->fecha_salida_txt."@@";
          $salida .= $ref->telefono."@@";
          $salida .= $ref->puesto1."@@";
          $salida .= $ref->puesto2."@@";
          $salida .= $ref->salario1_txt."@@";
          $salida .= $ref->salario2_txt."@@";
          $salida .= $ref->jefe_nombre."@@";
          $salida .= $ref->jefe_correo."@@";
          $salida .= $ref->jefe_puesto."@@";
          $salida .= $ref->causa_separacion."@@";
          $salida .= $ref->notas."@@";
          $salida .= $ref->cualidades."@@";
          $salida .= $ref->mejoras."@@";
          $salida .= $ref->id."@@";
          $salida .= $ref->numero_referencia."###";
        }
      }
      echo $salida;
    }
    
    function checkConclusionesCandidato(){
      $id_candidato = $this->input->post('id_candidato');
      $num = $this->candidato_model->checkConclusionesCandidato($id_candidato);
      if($num > 0){
          echo $salida = 1;
      }
      else{
          echo $salida = 0;
      }
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
    function countReferenciasLaborales(){
      $id_candidato = $this->input->post('id_candidato');
      $numero = $this->candidato_model->countReferenciasLaborales($id_candidato);
      echo $numero;
    }
    function getComentariosRefLaborales(){
      $id_candidato = $this->input->post('id_candidato');
      $salida = "";
      $data['ref'] = $this->candidato_model->getComentariosRefLaborales($id_candidato);
      if($data['ref']){
          foreach($data['ref'] as $ref){
              $salida .= $ref->notas.", ";
          }
          $res = trim($salida, ", ");
          echo $res;
      }
      else{
          echo $salida;
      }
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
  /*----------------------------------------*/
  /*  Proceso 
  /*----------------------------------------*/
    
    
    
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
      $this->candidato_model->eliminarCandidatoEgresos($id_candidato);
      $this->candidato_model->eliminarCandidatoHabitacion($id_candidato);
      $this->candidato_model->eliminarCandidatoVecinos($id_candidato);
      $this->candidato_model->eliminarCandidatoPersona($id_candidato);
      $this->candidato_model->eliminarCandidatoPersonaMismoTrabajo($id_candidato);

      $dop = array(
        'edicion' => $date,
        'status' => 0
      );
      $this->candidato_model->editarDoping($dop, $id_doping);

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
    
    
    function editarExtrasCandidato(){
      $this->form_validation->set_rules('notas', 'Notas', 'required|trim');
      $this->form_validation->set_rules('muebles', 'Muebles e inmuebles del candidato', 'required|trim');
      $this->form_validation->set_rules('adeudo', 'Adeudo', 'required|trim');
      $this->form_validation->set_rules('ingresos', 'Ingresos del candidato', 'required|trim|numeric');
      $this->form_validation->set_rules('aporte', 'Aporte del candidato', 'required|trim|numeric');
      
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
          'ingresos' => $this->input->post('ingresos'),
          'aporte' => $this->input->post('aporte')

        );
        $this->candidato_model->editarCandidato($datos, $this->input->post('id_candidato'));
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
      }
      echo json_encode($msj);
    }
    
    function crearPDF(){
      $mpdf = new \Mpdf\Mpdf();
      date_default_timezone_set('America/Mexico_City');
      $data['hoy'] = date("d-m-Y");
      $hoy = date("d-m-Y");
      $id_candidato = $_POST['idPDF'];
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
			$data['secciones'] = $this->candidato_model->getSeccionesCandidato($id_candidato);
      $data['finalizado'] = $this->candidato_model->getDatosFinalizadosCandidato($id_candidato);
      $data['doping'] = $this->candidato_model->getDopingCandidato($id_candidato);
      $data['pruebas'] = $this->candidato_model->getPruebasCandidato($id_candidato);
      $data['docs'] = $this->candidato_model->getDocumentacionCandidato($id_candidato);
      $data['ver_documento'] = $this->candidato_model->getVerificacionDocumentosCandidato($id_candidato);
      $data['academico'] = $this->candidato_model->getEstudiosCandidato($id_candidato);
      $data['sociales'] = $this->candidato_model->getAntecedentesSociales($id_candidato);
      $data['familia'] = $this->candidato_model->getFamiliares($id_candidato);
      $data['egresos'] = $this->candidato_model->getEgresosFamiliares($id_candidato);
      $data['vivienda'] = $this->candidato_model->getDatosVivienda($id_candidato);
      $data['ref_personal'] = $this->candidato_model->getReferenciasPersonales($id_candidato);
      $data['ref_empresa'] = $this->candidato_model->getPersonasMismoTrabajo($id_candidato);
      $data['legal'] = $this->candidato_model->getVerificacionLegal($id_candidato);
      $data['nom'] = $this->candidato_model->getTrabajosNoMencionados($id_candidato);
      $data['finalizado'] = $this->candidato_model->getDatosFinalizadosCandidato($id_candidato);
      $data['ref_laboral'] = $this->candidato_model->getReferenciasLaborales($id_candidato);
      $data['ver_laboral'] = $this->candidato_model->getVerificacionReferencias($id_candidato);
      $data['ref_vecinal'] = $this->candidato_model->getReferenciasVecinales($id_candidato);
      $data['analista'] = $this->candidato_model->getAnalista($id_candidato);
      $data['coordinadora'] = $this->candidato_model->getCoordinadora($id_candidato);
			$data['ver_mayor_estudio'] = $this->candidato_model->getVerificacionMayoresEstudios($id_candidato);
			$data['gaps'] = $this->candidato_model->checkGaps($id_candidato);
      $data['cliente'] = $cliente;
      $data['subcliente'] = $subcliente;
      $data['fecha_fin'] = $ffin;

      $html = $this->load->view('pdfs/candidato_alterno_pdf',$data,TRUE);
      $mpdf->setAutoTopMargin = 'stretch';
      $mpdf->AddPage();
      $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="'.base_url().'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: '.$f_alta.'<br>Fecha de Elaboración: '.$fecha_fin.'</div>');
      $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="'.base_url().'img/logo_pie.png"></div>');    
      //Cifrar pdf
      $nombreArchivo = substr( md5(microtime()), 1, 12);
      /*$claveAleatoria = substr( md5(microtime()), 1, 8);
      $clave = ($usuario->clave != null)? $usuario->clave:$claveAleatoria;
      $mpdf->SetProtection(array(), $clave, 'r0d1@');*/

			$mpdf->WriteHTML($html);
      $mpdf->Output(''.$nombreArchivo.'.pdf','D'); // opens in browser
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
			$data['secciones'] = $this->candidato_model->getSeccionesCandidato($id_candidato);
      $data['finalizado'] = $this->candidato_model->getDatosFinalizadosCandidato($id_candidato);
      $data['doping'] = $this->candidato_model->getDopingCandidato($id_candidato);
      $data['pruebas'] = $this->candidato_model->getPruebasCandidato($id_candidato);
      $data['docs'] = $this->candidato_model->getDocumentacionCandidato($id_candidato);
      $data['ver_documento'] = $this->candidato_model->getVerificacionDocumentosCandidato($id_candidato);
      $data['academico'] = $this->candidato_model->getEstudiosCandidato($id_candidato);
      $data['sociales'] = $this->candidato_model->getAntecedentesSociales($id_candidato);
      $data['familia'] = $this->candidato_model->getFamiliares($id_candidato);
      $data['egresos'] = $this->candidato_model->getEgresosFamiliares($id_candidato);
      $data['vivienda'] = $this->candidato_model->getDatosVivienda($id_candidato);
      $data['ref_personal'] = $this->candidato_model->getReferenciasPersonales($id_candidato);
      $data['ref_empresa'] = $this->candidato_model->getPersonasMismoTrabajo($id_candidato);
      $data['legal'] = $this->candidato_model->getVerificacionLegal($id_candidato);
      $data['nom'] = $this->candidato_model->getTrabajosNoMencionados($id_candidato);
      $data['finalizado'] = $this->candidato_model->getDatosFinalizadosCandidato($id_candidato);
      $data['ref_laboral'] = $this->candidato_model->getReferenciasLaborales($id_candidato);
      $data['ver_laboral'] = $this->candidato_model->getVerificacionReferencias($id_candidato);
      $data['ref_vecinal'] = $this->candidato_model->getReferenciasVecinales($id_candidato);
      $data['analista'] = $this->candidato_model->getAnalista($id_candidato);
      $data['coordinadora'] = $this->candidato_model->getCoordinadora($id_candidato);
      $data['cliente'] = $cliente;
      $data['subcliente'] = $subcliente;
      $data['fecha_fin'] = $ffin;

      $html = $this->load->view('pdfs/previo_alterno_pdf',$data,TRUE);
      $mpdf->setAutoTopMargin = 'stretch';
      $mpdf->AddPage();
      $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="'.base_url().'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: '.$f_alta.'<br>Fecha de Elaboración: '.$fecha_fin.'</div>');
      $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="'.base_url().'img/logo_pie.png"></div>');    
      //Cifrar pdf
      $nombreArchivo = substr( md5(microtime()), 1, 12);
      /*$claveAleatoria = substr( md5(microtime()), 1, 8);
      $clave = ($usuario->clave != null)? $usuario->clave:$claveAleatoria;
      $mpdf->SetProtection(array(), $clave, 'r0d1@');*/

			$mpdf->WriteHTML($html);
      $mpdf->Output(''.$nombreArchivo.'.pdf','D'); // opens in browser
    }
}