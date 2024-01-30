<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{

	function __construct(){
		parent::__construct();
	}

	public function index(){
		if($this->session->userdata('logueado') && $this->session->userdata('tipo') == 1){
			$data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
			//
			$data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
			foreach($data['submodulos'] as $row) {
				$items[] = $row->id_submodulo;
			}
			$data['submenus'] = $items;
			//
			$config = $this->funciones_model->getConfiguraciones();
			$data['version'] = $config->version_sistema;

			if($this->session->userdata('idrol') == 1 || $this->session->userdata('idrol') == 6){
				$ESEFinalizados = $this->estadistica_model->countESEFinalizados();
				$data['titulo_dato1'] = 'Total de ESE Finalizados';
				$data['dato1'] = $ESEFinalizados->total;
				$dopingFinalizados = $this->estadistica_model->countDopingFinalizados();
				$data['titulo_dato2'] = 'Total de Exámenes Antidoping Finalizados';
				$data['dato2'] = $dopingFinalizados->total;
				$covidFinalizados = $this->estadistica_model->countCovidFinalizados();
				$data['titulo_dato3'] = 'Total de Pruebas COVID-19 Finalizados';
				$data['dato3'] = $covidFinalizados->total;
				$medicoFinalizados = $this->estadistica_model->countMedicoFinalizados();
				$data['titulo_dato4'] = 'Total de Exámenes Médicos Finalizados';
				$data['dato4'] = $medicoFinalizados->total;
				
			}/*
			if($this->session->userdata('idrol') == 2){
				$num = $this->estadistica_model->countCandidatosAnalista($this->session->userdata('id'));
				$data['dato_totalcandidatos'] = $num->total;
				$num = $this->estadistica_model->countCandidatosSinFormulario($this->session->userdata('id'));
				$data['dato_2'] = $num->total;
				$data['texto_2'] = "Candidatos sin envío de formulario";
				$num = $this->estadistica_model->countCandidatosSinDocumentos($this->session->userdata('id'));
				$data['dato_3'] = $num->total;
				$data['texto_3'] = "Candidatos sin envío de documentos";
			}*/

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

			//Modals
			$modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);

			$this->load
			->view('adminpanel/header',$data)
			->view('adminpanel/index')
			->view('adminpanel/scripts',$modales)
			->view('adminpanel/links')
			->view('adminpanel/footer');
		}
		else{
			redirect('Login/index');
		}
	}
	function manual_usuario(){
		$this->load
    ->view('manual_usuario/manual');
	}
	public function ustglobal_panel(){
		if($this->session->userdata('logueado') && $this->session->userdata('tipo') == 2){
			$this->load->view('clientes/ust_cliente');
		}
		else{
			redirect('Login/index');
		}
	}
	public function hcl_panel(){
		$data['paises'] = $this->funciones_model->getPaises();
		$data['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
		$data['paises_estudio'] = $this->funciones_model->getPaisesEstudio();
		$data['proyectos'] = $this->candidato_model->getProyectosCliente($this->session->userdata('idcliente'));
    $data['tipos_docs'] = $this->funciones_model->getTiposDocumentos();
		$data['bloqueo'] = $this->cat_cliente_model->getBloqueoHistorial($this->session->userdata('idcliente'));
		if($this->session->userdata('logueado') && $this->session->userdata('tipo') == 2){
			$this->load->view('clientes/hcl_cliente', $data);
		}
		else{
			redirect('Login/index');
		}
	}
  public function client_panel(){
		$data['paises'] = $this->funciones_model->getPaises();
		$data['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
		$data['paises_estudio'] = $this->funciones_model->getPaisesEstudio();
		$data['proyectos'] = $this->candidato_model->getProyectosCliente($this->session->userdata('idcliente'));
    $data['tipos_docs'] = $this->funciones_model->getTiposDocumentos();
		if($this->session->userdata('logueado') && $this->session->userdata('tipo') == 2){
			$this->load->view('clientes/panel', $data);
		}
		else{
			redirect('Login/index');
		}
	}
	public function tata_panel(){
		/*$data['baterias'] = $this->configuracion_model->getBateriasPsicometricas();
		$data['proyectos'] = $this->candidato_model->getProyectosCliente($this->session->userdata('idcliente'));
		$data['subclientes'] = $this->cliente_model->getSubclientes($this->session->userdata('idcliente'));*/
		if($this->session->userdata('logueado') && $this->session->userdata('tipo') == 2){
			$this->load->view('clientes/tata_cliente');
		}
		else{
			redirect('Login/index');
		}
	}
	
	
	function candidate_panel(){
		$candidato = $this->candidato_model->getDetalles($this->session->userdata('id'));
		$data['tiene_aviso'] = $this->candidato_model->checkAvisoPrivacidad($this->session->userdata('id'));
		$data['UploadedDocuments'] = $this->candidato_model->getUploadedDocumentsById($this->session->userdata('id'));
		$data['estados'] = $this->candidato_model->getEstados();
		$data['id_candidato'] = $this->session->userdata('id');
		$data['nombre'] = $this->session->userdata('nombre');
		$data['paterno'] = $this->session->userdata('paterno');
		$data['tipo_proceso'] = $this->session->userdata('proceso');
		$data['id_cliente'] = $this->session->userdata('idcliente');
		$data['proyecto_seccion'] = $this->session->userdata('proyecto_seccion');
		$data['docs_requeridos'] = $this->candidato_model->getDocumentosCandidatoRequeridos($this->session->userdata('id'));
		$data['candidato'] = $candidato;
		$data['secciones'] = $this->candidato_seccion_model->getSecciones($this->session->userdata('id'));
		$data['documentos_requeridos'] = $this->documentacion_model->getDocumentosRequeridosByCandidato($this->session->userdata('id'));
		$data['avances'] = $this->candidato_avance_model->getAllById($this->session->userdata('id'));
		$archivos = array();
		if($data['UploadedDocuments']){
			foreach($data['UploadedDocuments'] as $file){
				array_push($archivos, $file->id_tipo_documento);
			}
			$data['archivos'] = $archivos;
		}
		else{
			$data['archivos'] = 0;
		}
		$this->load->view('candidato/formulario',$data);
	}
	function clientes_panel(){
    $id_cliente = $this->session->userdata('idcliente');
		$data['subclientes'] = $this->cliente_general_model->getSubclientesPanel($id_cliente);
		$data['puestos'] = $this->funciones_model->getPuestos();
		$data['drogas'] = $this->funciones_model->getPaquetesAntidoping();
		$data['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
    $data['paises'] = $this->funciones_model->getPaises();
		$data['bloqueo'] = $this->cat_cliente_model->getBloqueoHistorial($id_cliente);
    if($id_cliente != 172 && $id_cliente != 178 && $id_cliente != 205 && $id_cliente != 235 && $id_cliente != 201 && $id_cliente != 236 && $id_cliente != 1 && $id_cliente != 249)
      $this->load->view('clientes/clientes_index',$data);
    else 
      $this->load->view('clientes/clientes_index_ingles',$data);
	}
	/*----------------------------------------*/
	/* Visitador
	/*----------------------------------------*/ 
		function visitador_panel(){
			if($this->session->userdata('logueado') && $this->session->userdata('tipo') == 1 && $this->session->userdata('idrol') == 3){
				$data['parentescos'] = $this->funciones_model->getParentescos();
				$data['civiles'] = $this->funciones_model->getEstadosCiviles();
				$data['escolaridades'] = $this->funciones_model->getEscolaridades();
				$data['zonas'] = $this->funciones_model->getNivelesZona();
				$data['viviendas'] = $this->funciones_model->getTiposVivienda();
				$data['condiciones'] = $this->funciones_model->getTiposCondiciones();
				$data['visitas'] = $this->candidato_model->getCandidatosVisitador($this->session->userdata('id'));
        $data['clave_txt'] = '#ZY!C47K1esET*FBmO6Rir&25F!4jLJr';//substr(md5(time()), 0, 32);
				$this->load->view('visitador/visitador_index',$data);
			}
			else{
				redirect('Login/index');
			}
		}
	/*----------------------------------------*/
	/* Panel Subclientes Espanol General
	/*----------------------------------------*/ 
		function subclientes_general_panel(){
			$data['puestos'] = $this->funciones_model->getPuestos();
			$data['drogas'] = $this->funciones_model->getPaquetesAntidoping();
			$data['candidatos'] = $this->subcliente_model->getCandidatos($this->session->userdata('idsubcliente'));
      $data['paises'] = $this->funciones_model->getPaises();
      $data['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
		  $data['bloqueo'] = $this->cat_cliente_model->getBloqueoHistorial($this->session->userdata('idcliente'));
    $this->load->view('subclientes/subclientes_general_index',$data);
		}

	/*----------------------------------------*/
	/* Panel Subclientes Ingles REMOTE TEAM
	/*----------------------------------------*/ 
		function subclientes_ingles_panel(){
      if($this->session->userdata('id')){
        $id_cliente = $this->session->userdata('idcliente');
        $data['puestos'] = $this->funciones_model->getPuestos();
        $data['drogas'] = $this->funciones_model->getPaquetesAntidoping();
        $data['candidatos'] = $this->subcliente_model->getCandidatos($id_cliente);
        $data['paises'] = $this->funciones_model->getPaises();
        $data['subclientes'] = $this->cliente_general_model->getSubclientes($id_cliente);
        $data['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
        $this->load->view('subclientes/subclientes_ingles_index',$data);
      }
      else{
        redirect('Login/index');
      }
    }
}