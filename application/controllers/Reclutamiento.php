<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reclutamiento extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

	/*----------------------------------------*/
  /*  Submenus 
  /*----------------------------------------*/
		function requisicion(){
			$data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
			$data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
			foreach($data['submodulos'] as $row) {
				$items[] = $row->id_submodulo;
			}
			$data['submenus'] = $items;
			$config = $this->funciones_model->getConfiguraciones();
			$data['version'] = $config->version_sistema;
      //Filtros de busqueda y ordenamiento
      if(isset($_GET['sort'])){
        $getSort = $_GET['sort'];
        switch($getSort){
          case 'ascending':
            $sort = 'ASC'; break;
          case 'descending':
            $sort = 'DESC'; break;
          default:
            $sort = 'DESC'; break;
        }
      }else{
        $sort = 'DESC';
        $getSort = '';
      }
      if(isset($_GET['filter'])){
        $getFilter = $_GET['filter'];
        if($getFilter == 'COMPLETA' || $getFilter == 'EXPRESS'){
          $filter = $getFilter;
          $filterOrder = 'R.tipo';
        }
        if($getFilter == 'En espera'){
          $filter = 1;
          $filterOrder = 'R.status';
        }
        if($getFilter == 'En proceso'){
          $filter = 2;
          $filterOrder = 'R.status';
        }
      }else{
        $getFilter = '';
        $filter = '';
        $filterOrder = 'R.tipo !=';
      }
      if(isset($_GET['order'])){
        $order = $_GET['order'];
        if($order != ''){
          $id_order = ($order > 0)? $order : 0;
          $condition_order = ($order > 0)? 'R.id' : 'R.id >';
        }else{
          $id_order = 0;
          $condition_order = 'R.id >';
        }
      }else{
        $id_order = 0;
        $condition_order = 'R.id >';
      }
      //Dependiendo el rol del usuario se veran todas o sus propias requisiciones
      if($this->session->userdata('idrol') == 4){
        $id_usuario = $this->session->userdata('id');
        $info['requisiciones'] = $this->reclutamiento_model->getOrdersByUser($id_usuario, $sort, $id_order, $condition_order);
			  $info['orders_search'] = $this->reclutamiento_model->getOrdersByUser($id_usuario, $sort, 0, 'R.id >');
			  $info['sortOrder'] = $getSort;
			  $info['filter'] = $getFilter;
      }
      else{
			  $info['requisiciones'] = $this->reclutamiento_model->getAllOrders($sort, $id_order, $condition_order, $filter, $filterOrder);
			  $info['orders_search'] = $this->reclutamiento_model->getAllOrders($sort, 0, 'R.id >', $filter, $filterOrder);
			  $info['sortOrder'] = $getSort;
			  $info['filter'] = $getFilter;
      }
      $info['registros'] = NULL;
			$info['medios'] = $this->funciones_model->getMediosContacto();
      $info['puestos'] = $this->funciones_model->getPuestos();
      $info['paises'] = $this->funciones_model->getPaises();
			$info['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
      //Obtiene los usuarios con id rol 4 y 11 que pertencen a reclutadores y coordinadores de reclutadores
			$info['usuarios_asignacion'] = $this->usuario_model->getTipoUsuarios([4,11]);
			$info['registros_asignacion'] = $this->reclutamiento_model->getRequisicionesActivas();
			//Modals
			$modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);
			$vista['modals_reclutamiento'] = $this->load->view('modals/mdl_reclutamiento',$info, TRUE);

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
			->view('adminpanel/header',$data)
			->view('adminpanel/scripts',$modales)
			->view('reclutamiento/requisicion',$vista)
			->view('adminpanel/footer');
		}
		function control(){
			$data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
			$data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
			foreach($data['submodulos'] as $row) {
				$items[] = $row->id_submodulo;
			}
			$data['submenus'] = $items;
			$config = $this->funciones_model->getConfiguraciones();
			$data['version'] = $config->version_sistema;
			//Dependiendo el rol del usuario se veran todas o sus propias requisiciones
			if($this->session->userdata('idrol') == 4){
				$id_usuario = $this->session->userdata('id');
        $reqs = $this->reclutamiento_model->getOrdersInProcessByUser($id_usuario);
			}
			else{
        $reqs = $this->reclutamiento_model->getAllOrdersInProcess();
      }
			$data['reqs'] = $reqs;
			$info['reqs'] = $reqs;
			$info['medios'] = $this->funciones_model->getMediosContacto();
			$info['acciones'] = $this->funciones_model->getAccionesRequisicion();
      $info['puestos'] = $this->funciones_model->getPuestos();
      $info['paises'] = $this->funciones_model->getPaises();
			$info['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
			//Modals
			$modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);
			$vista['modals'] = $this->load->view('modals/mdl_reclutamiento',$info, TRUE);

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
			->view('adminpanel/header',$data)
			->view('adminpanel/scripts',$modales)
			->view('reclutamiento/control', $vista)
			->view('adminpanel/footer');
		}
		function finalizados(){
			$data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
			$data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
			foreach($data['submodulos'] as $row) {
				$items[] = $row->id_submodulo;
			}
			$data['submenus'] = $items;
			$config = $this->funciones_model->getConfiguraciones();
			$data['version'] = $config->version_sistema;
			//Dependiendo el rol del usuario se veran todas o sus propias requisiciones
			if($this->session->userdata('idrol') == 4){
				$id_usuario = $this->session->userdata('id');
				$condicion = 'r.id_usuario';
			}
			else{
				$id_usuario = 0;
				$condicion = 'r.id_usuario >=';
			}
			$reqs = $this->reclutamiento_model->getRequisicionesFinalizadas($id_usuario, $condicion);
			$data['reqs'] = $reqs;
			$info['reqs'] = $reqs;
			//$info['acciones'] = $this->funciones_model->getAccionesRequisicion();
			//Modals
			$modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);
			$vista['modals'] = $this->load->view('modals/mdl_reclutamiento',$info, TRUE);
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
			->view('adminpanel/header',$data)
			->view('adminpanel/scripts',$modales)
			->view('reclutamiento/finalizados', $vista)
			->view('adminpanel/footer');
		}
    function bolsa(){
			$data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
			$data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
			foreach($data['submodulos'] as $row) {
				$items[] = $row->id_submodulo;
			}
			$data['submenus'] = $items;
			$config = $this->funciones_model->getConfiguraciones();
			$data['version'] = $config->version_sistema;
      //Filtros de busqueda y ordenamiento
      if(isset($_GET['sort']) && $_GET['sort'] != 'none'){
        $getSort = $_GET['sort'];
        switch($getSort){
          case 'ascending':
            $sort = 'ASC'; break;
          case 'descending':
            $sort = 'DESC'; break;
          default:
            $sort = 'DESC'; break;
        }
      }else{
        $sort = 'DESC';
        $getSort = '';
      }
      if(isset($_GET['filter']) && $_GET['filter'] != 'none'){
        $getFilter = $_GET['filter'];
        if($getFilter == 'En espera'){
          $filter = 1;
          $filterApplicant = 'B.status';
        }
        if($getFilter == 'En proceso'){
          $filter = 2;
          $filterApplicant = 'B.status';
        }
        if($getFilter == 'Aceptado'){
          $filter = 3;
          $filterApplicant = 'B.status';
        }
        if($getFilter == 'ESE'){
          $filter = 4;
          $filterApplicant = 'B.status';
        }
        if($getFilter == 'Bloqueado'){
          $filter = 0;
          $filterApplicant = 'B.status';
        }
      }else{
        $getFilter = '';
        $filter = '';
        $filterApplicant = 'B.id !=';
      }
      if(isset($_GET['user'])){
        $user = $_GET['user'];
        $getUser = $_GET['user'];
        if($user != ''){
          $idUser = ($user > 0)? $user : 0;
          $condition_user = ($user > 0)? 'B.id_usuario' : 'B.id_usuario >=';
        }else{
          $idUser = 0;
          $condition_user = 'B.id >';
        }
      }else{
        $idUser = 0;
        $condition_user = 'B.id >';
        $getUser = '';
      }
      if(isset($_GET['area']) && $_GET['area'] != 'none'){
        $area = $_GET['area'];
        $getArea = $_GET['area'];
        if($area !== ''){
          $area_interest = $area;
          $condition_area = 'B.area_interes';
        }else{
          $area_interest = '';
          $condition_area = 'B.area_interes !=';
        }
      }else{
        $area_interest = '';
        $condition_area = 'B.area_interes !=';
        $getArea = '';
      }
      if(isset($_GET['applicant'])){
        $applicant = $_GET['applicant'];
        if($applicant != ''){
          $id_applicant = ($applicant > 0)? $applicant : 0;
          $condition_applicant = ($applicant > 0)? 'B.id' : 'B.id >';
        }else{
          $id_applicant = 0;
          $condition_applicant = 'B.id >';
        }
      }else{
        $id_applicant = 0;
        $condition_applicant = 'B.id >';
      }

      //Dependiendo el rol del usuario se veran todas o sus propias requisiciones
      if($this->session->userdata('idrol') == 4){
        $id_usuario = $this->session->userdata('id');
        $info['registros'] = $this->reclutamiento_model->getApplicantsByUser($sort, $id_applicant, $condition_applicant, $filter, $filterApplicant, $id_usuario, $area_interest, $condition_area);
        $condition = 'B.id_usuario';
      }
      else{
			  $info['registros'] = $this->reclutamiento_model->getBolsaTrabajo($sort, $id_applicant, $condition_applicant, $filter, $filterApplicant, $idUser, $condition_user, $area_interest, $condition_area);
        $id_usuario = 0;
        $condition = 'B.id_usuario >=';
      }
      $info['sortApplicant'] = $getSort;
      $info['filter'] = $getFilter;
      $info['assign'] = $getUser;
      $info['area'] = $getArea;

      $info['civiles'] = $this->funciones_model->getEstadosCiviles();
      $info['grados'] = $this->funciones_model->getGradosEstudio();
      $info['medios'] = $this->funciones_model->getMediosContacto();
      $info['puestos'] = $this->funciones_model->getPuestos();
      $info['paises'] = $this->funciones_model->getPaises();
			$info['paquetes_antidoping'] = $this->funciones_model->getPaquetesAntidoping();
			$info['requisiciones'] = NULL;
      //Obtiene los usuarios con id rol 4 y 11 que pertencen a reclutadores y coordinadores de reclutadores
			$info['usuarios_asignacion'] = $this->usuario_model->getTipoUsuarios([4,11]);
			$info['registros_asignacion'] = $this->reclutamiento_model->getAllApplicants($id_usuario, $condition);
			$info['areas_interes'] = $this->reclutamiento_model->getAllJobPoolByArea();
			//Modals
			$modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);
			$vista['modals'] = $this->load->view('modals/mdl_reclutamiento',$info, TRUE);

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
			->view('adminpanel/header',$data)
			->view('adminpanel/scripts',$modales)
			->view('reclutamiento/bolsa_trabajo',$vista)
			->view('adminpanel/footer');
		}
	
	/*----------------------------------------*/
  /*	Acciones
  /*----------------------------------------*/
		function iniciarRequisicion(){
			$id = $this->input->post('id');
			$usuario = $this->session->userdata('id');
			$this->reclutamiento_model->iniciarRequisicion($id, $usuario);
			$msj = array(
				'codigo' => 1,
				'msg' => 'La requisición #'.$id.' está en proceso'
			);
			echo json_encode($msj);
		}
		function addApplicant(){
			$this->form_validation->set_rules('requisicion', 'Asignar requisición', 'required');
			$this->form_validation->set_rules('nombre', 'Nombre(s)', 'required|trim');
			$this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
			$this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
			$this->form_validation->set_rules('domicilio', 'Localización o domicilio', 'required|trim');
			$this->form_validation->set_rules('area_interes', 'Área de interés', 'required|trim');
			$this->form_validation->set_rules('medio', 'Medio de contacto', 'required|trim');
			$this->form_validation->set_rules('telefono', 'Teléfono', 'required|trim|max_length[16]');
			$this->form_validation->set_rules('correo', 'Correo', 'trim|valid_email');
	
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
				$date = date('Y-m-d H:i:s');
				$req = $this->input->post('requisicion');
				$nombre = $this->input->post('nombre');
				$paterno = $this->input->post('paterno');
				$materno = $this->input->post('materno');
				$medio = $this->input->post('medio');
				$telefono = $this->input->post('telefono');
				$correo = $this->input->post('correo');
				$id_usuario = $this->session->userdata('id');
				$id_aspirante = $this->input->post('id_aspirante');
				$id_bolsa_trabajo = $this->input->post('id_bolsa_trabajo');
				$nombre_archivo = NULL;
				if($id_aspirante == 0){
          if($id_bolsa_trabajo == 0){
            $jobPool = array(
              'creacion' => $date,
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              'nombre' => strtoupper($nombre),
              'paterno' => strtoupper($paterno),
              'materno' => strtoupper($materno),
              'telefono' => $telefono,
              'medio_contacto' => $medio,
              'area_interes' => $this->input->post('area_interes'),
              'domicilio' => $this->input->post('domicilio'),
            );
            $id_bolsa_trabajo = $this->reclutamiento_model->addJobPoolWithIdReturned($jobPool);
          }else{
            $bolsa = array(
              'nombre' => strtoupper($nombre),
              'paterno' => strtoupper($paterno),
              'materno' => strtoupper($materno),
              'telefono' => $telefono,
              'medio_contacto' => $medio,
              'area_interes' => $this->input->post('area_interes'),
              'domicilio' => $this->input->post('domicilio'),
              'status' => 2
            );
            $this->reclutamiento_model->editBolsaTrabajo($bolsa, $id_bolsa_trabajo);
          }
          $datos = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'id_bolsa_trabajo' => $id_bolsa_trabajo,
            'id_requisicion' => $req,
            'nombre' => strtoupper($nombre),
            'paterno' => strtoupper($paterno),
            'materno' => strtoupper($materno),
            'telefono' => $telefono,
            'correo' => $correo,
            'medio_contacto' => $medio,
            'cv' => $nombre_archivo,
            'status' => 'Registrado'
          );
          $this->reclutamiento_model->addApplicant($datos);
          if($id_bolsa_trabajo != 0){
            $bolsa = array(
              'status' => 2
            );
            $this->reclutamiento_model->editBolsaTrabajo($bolsa, $id_bolsa_trabajo);
          }
          $msj = array(
            'codigo' => 1,
            'msg' => 'El aspirante fue guardado correctamente'
          );
				}
				// else{
				// 	// if (isset($_FILES["cv"]["name"])) {
				// 	// 	$archivo = $this->reclutamiento_model->tieneAspiranteCV($id_aspirante);
				// 	// 	if($archivo != NULL){
				// 	// 		unlink('./_docs/'.$archivo->cv);
				// 	// 	}
				// 	// 	$config['upload_path'] = './_docs/';  
				// 	// 	$config['allowed_types'] = 'pdf|jpg|jpeg|png';
				// 	// 	$config['max_size'] = '2048'; // max_size in kb
				// 	// 	$config['overwrite'] = TRUE;
				// 	// 	$cadena = substr(md5(time()), 0, 12);
				// 	// 	$extension = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
				// 	// 	$config['file_name'] = $cadena.'.'.$extension;
						
				// 	// 	$this->load->library('upload', $config);
				// 	// 	$this->upload->initialize($config);
				// 	// 	if($this->upload->do_upload('cv')){
				// 	// 		$nombre_archivo = $cadena.'.'.$extension;
				// 	// 	}
				// 	// 	else{
				// 	// 		$msj = array(
				// 	// 			'codigo' => 0,
				// 	// 			'msg' => 'Archivo no válido'
				// 	// 		);
				// 	// 		$error = 1;
				// 	// 	}
				// 	// }
				// 	if($error == 0){
				// 		$datos = array(
				// 			'edicion' => $date,
				// 			'id_usuario' => $id_usuario,
				// 			'id_requisicion' => $req,
				// 			'id_bolsa_trabajo' => $id_bolsa_trabajo,
				// 			'nombre' => $nombre,
				// 			'paterno' => $paterno,
				// 			'materno' => $materno,
				// 			'telefono' => $telefono,
				// 			'correo' => $correo,
				// 			'medio_contacto' => $medio,
				// 			'cv' => $nombre_archivo
				// 		);
				// 		$this->reclutamiento_model->editarAspirante($datos, $id_aspirante);
        //     if($id_bolsa_trabajo != 0){
        //       $bolsa = array(
        //         'nombre' => strtoupper($nombre),
        //         'paterno' => strtoupper($paterno),
        //         'materno' => strtoupper($materno),
        //         'telefono' => $telefono,
        //         'medio_contacto' => $medio,
        //         'area_interes' => $this->input->post('area_interes'),
        //         'domicilio' => $this->input->post('domicilio'),
        //         'status' => 2
        //       );
				// 		  $this->reclutamiento_model->editBolsaTrabajo($bolsa, $id_bolsa_trabajo);
        //     }
				// 		$msj = array(
				// 			'codigo' => 1,
				// 			'msg' => 'El aspirante fue guardado correctamente'
				// 		);
				// 	}
				// }
			}
			echo json_encode($msj);
		}
		function guardarAccionRequisicion(){
			$this->form_validation->set_rules('accion', 'Acción a aplicar', 'required|trim');
			$this->form_validation->set_rules('comentario', 'Comentario / Descripción / Fecha y lugar', 'required|trim');
	
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio');
			$this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
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
				$estatus_final = NULL;
				$comentario = $this->input->post('comentario');
				$id_usuario = $this->session->userdata('id');
				$id_aspirante = $this->input->post('id_aspirante');
				$id_requisicion = $this->input->post('id_requisicion');
				$accion = explode(':', $this->input->post('accion'));
        $aspirante = $this->reclutamiento_model->getAspiranteById($id_aspirante);
				//Acciones especiales
				//Aspirante o Cliente cancela
				if($accion[0] == 13 || $accion[0] == 15){
					$estatus_final = 'CANCELADO';
				}
				//Cliente finaliza sin ESE
				if($accion[0] == 17){
					$estatus_final = 'FINALIZADO';
				}
				//Se completa proceso de Aspirante con ESE
				if($accion[0] == 16){
					$estatus_final = 'COMPLETADO';
				}
				$datos = array(
					'creacion' => $date,
					'id_usuario' => $id_usuario,
					'id_requisicion' => $id_requisicion,
					'id_bolsa_trabajo' => $aspirante->id_bolsa_trabajo,
					'id_aspirante' => $id_aspirante,
					'accion' => $accion[1],
					'descripcion' => $comentario
				);
				$this->reclutamiento_model->guardarAccionRequisicion($datos);
				$data_aspirante = array(
					'edicion' => $date,
					'id_usuario' => $id_usuario,
					'status' => $accion[1],
					'status_final' => $estatus_final
				);
				$this->reclutamiento_model->editarAspirante($data_aspirante, $id_aspirante);
        switch($accion[0]){
          case 9:
          case 13:
          case 15:
            $estatus_bolsa = 1; $semaforo = 2;break;
            //Aspirante regresa a bolsa y semaforo en amarillo para tomar precauciones de acuerdo a los comentarios del reclutador, aspirante y/o cliente
          case 16:
            $estatus_bolsa = 3; $semaforo = 1;break;
            //Finaliza con exito el proceso de reclutamiento con semaforo verde; estatus 'aceptado' del aspirante con semaforo verde
          case 17:
            $estatus_bolsa = 1; $semaforo = 0;break;
            //Aspirante regresa a bolsa
          default: //1-8,10,11
            $estatus_bolsa = 2; $semaforo = 0;break;//Permanecen estatus en bolsa o en proceso y semaforo apagado
        }
        $data_bolsa = array(
          'edicion' => $date,
          'status' => $estatus_bolsa,
          'semaforo' => $semaforo,
        );
        $this->reclutamiento_model->editBolsaTrabajo($data_bolsa, $aspirante->id_bolsa_trabajo);
				$msj = array(
					'codigo' => 1,
					'msg' => 'El registro se realizó correctamente'
				);
				
			}
			echo json_encode($msj);
		}
		function guardarEstatusRequisicion(){
			$this->form_validation->set_rules('id_requisicion', 'Requisición', 'required|trim');
			$this->form_validation->set_rules('estatus', 'Estatus a asignar', 'required|trim');
			$this->form_validation->set_rules('comentario', 'Comentarios', 'required|trim');
	
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio');
			$this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
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
				$comentario = $this->input->post('comentario');
				$id_usuario = $this->session->userdata('id');
				$estatus_final = $this->input->post('estatus');
				$id_requisicion = $this->input->post('id_requisicion');
        //Cancela Requisicion
        if($estatus_final == 0){
          $status = 'status';
          $acciones = 1;
          $id_usuario = 0;
				  $condicion = 'A.id_usuario >';
          $data['aspirantes'] = $this->reclutamiento_model->getAspirantesPorRequisicion($id_usuario, $condicion, $id_requisicion);
          if($data['aspirantes']){
            foreach($data['aspirantes'] as $row){
              $bolsa = array(
                'edicion' => $date,
                'status' => 1
              );
              $this->reclutamiento_model->editBolsaTrabajo($bolsa, $row->id_bolsa_trabajo);
            }
          }
          $datos = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            $status => $estatus_final,
            'comentario_final' => $comentario
          );
          $this->reclutamiento_model->editarRequisicion($datos, $id_requisicion);
          $msj = array(
            'codigo' => 1,
            'msg' => 'La requisición fue cancelada correctamente'
          );
        }
        //Se elimina la requisicion
				if($estatus_final == 1){
					$status = 'eliminado';
          $acciones = 1;
          $id_usuario = 0;
				  $condicion = 'A.id_usuario >';
          $data['aspirantes'] = $this->reclutamiento_model->getAspirantesPorRequisicion($id_usuario, $condicion, $id_requisicion);
          if($data['aspirantes']){
            foreach($data['aspirantes'] as $row){
              $bolsa = array(
                'edicion' => $date,
                'status' => 1
              );
              $this->reclutamiento_model->editBolsaTrabajo($bolsa, $row->id_bolsa_trabajo);
            }
          }
          $datos = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            $status => $estatus_final,
            'comentario_final' => $comentario
          );
          $this->reclutamiento_model->editarRequisicion($datos, $id_requisicion);
          $msj = array(
            'codigo' => 1,
            'msg' => 'La requisición fue eliminada correctamente'
          );
				}
        //Termina o finaliza Requisicion
        if($estatus_final == 3){
          $status = 'status';
          $acciones = ['FINALIZADO','COMPLETADO','ESE FINALIZADO'];
          $sin_registro_socio = 0;
          $num_aspirantes = $this->reclutamiento_model->getVacantesCubiertasTotal($id_requisicion, $acciones);
          $requisicion = $this->reclutamiento_model->getRequisionById($id_requisicion);
          if($num_aspirantes >= $requisicion->numero_vacantes){
            $data['candidatos'] = $this->reclutamiento_model->getCandidatosByRequisicion($id_requisicion);
            foreach($data['candidatos'] as $row){
              if($row->id_aspirante == NULL || $row->id_aspirante == ''){
                $sin_registro_socio = 1; break;
              }
            }
            if($sin_registro_socio == 0){
              $datos = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                $status => $estatus_final,
                'comentario_final' => $comentario
              );
              $this->reclutamiento_model->editarRequisicion($datos, $id_requisicion);
              $msj = array(
                'codigo' => 1,
                'msg' => 'La requisición fue terminada correctamente'
              );
            }
            else{
              $msj = array(
                'codigo' => 0,
                'msg' => 'Los aspirantes finalizados deberan ser registrados para su ESE para poder terminar la requisicion'
              );
            }
          }
          else{
            $msj = array(
              'codigo' => 0,
              'msg' => 'Se debe cumplir el numero de vacantes, el registro del sueldo acordado y fecha de ingreso al empleo'
            );
          }
        }
			}
			echo json_encode($msj);
		}
    function getOrderPDF(){
      //* Llamada a la libreria de mpdf, iniciación de fechas y captura POST
      $mpdf = new \Mpdf\Mpdf();
      date_default_timezone_set('America/Mexico_City');
      $id = $_POST['idReq'];
  
      //* Detalles de la requisicion por ID
			$data['requisicion'] = $this->reclutamiento_model->getRequisionById($id);
  
  
      //* Vista PDF del reporte
      if($this->session->userdata('idrol') == 4 || $this->session->userdata('idrol') == 11)
        $html = $this->load->view('pdfs/reclutamiento/requisicion_detalles_pdf',$data,TRUE);
      else
        $html = $this->load->view('pdfs/reclutamiento/requisicion_completa_pdf',$data,TRUE);

      //* Configuraciones del mPDF
      $mpdf->setAutoTopMargin = 'stretch';
      $mpdf->SetHTMLHeader('<div style=""><img style="" src="'.base_url().'img/Encabezado.png"></div>');
      $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;"><div style="border-bottom:1px solid gray;"><b>Teléfono:</b> (33) 2301-8599 | <b>Correo:</b> hola@rodi.com.mx | <b>Sitio web:</b> rodi.com.mx</div><br>Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco, México. C.P. 45018 <br></p></div><div style="position: absolute; right: 10px;  bottom: 13px;"><img width="" src="'.base_url().'img/logo2.png"></div>');
      //$nombreArchivo = substr( md5(microtime()), 1, 12);
      $mpdf->WriteHTML($html);
      $mpdf->Output('Req'.$id.'.pdf','D');
    }
    function cancelarBolsaTrabajo(){
      date_default_timezone_set('America/Mexico_City');
      $date = date('Y-m-d H:i:s');
      $id_usuario = $this->session->userdata('id');
      $id_bolsa = $this->input->post('id_bolsa');
      $comentario = $this->input->post('comentario');
      $aspirante = $this->reclutamiento_model->getAspiranteByBolsaTrabajo($id_bolsa);
      if($comentario != ''){
        if($aspirante != NULL){
          $aspirante_data = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'status' => 'Bloqueado del proceso de reclutamiento',
            'status_final' => 'BLOQUEADO',
          );
          $this->reclutamiento_model->editarAspirante($aspirante_data, $aspirante->id);
          $historial = array(
            'creacion' => $date,
            'id_usuario' => $id_usuario,
            'id_requisicion' => $aspirante->id_requisicion,
            'id_bolsa_trabajo' => $id_bolsa,
            'id_aspirante' => $aspirante->id,
            'accion' => 'Usuario bloquea a la persona del proceso de reclutamiento',
            'descripcion' => $comentario
          );
          $this->reclutamiento_model->guardarAccionRequisicion($historial);
          $bolsa = array(
            'status' => 0
          );
          $this->reclutamiento_model->editBolsaTrabajo($bolsa, $id_bolsa);
        }
        
        $msj = array(
          'codigo' => 1,
          'msg' => 'Se ha bloqueado correctamente'
        );
      }
      else{
        $msj = array(
          'codigo' => 0,
          'msg' => 'Campo(s) vacío(s)'
        );
      }
      echo json_encode($msj);
    }
    function guardarHistorialBolsaTrabajo(){
			$this->form_validation->set_rules('comentario', 'Comentario / Estatus', 'required|trim');
	
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio');
			$this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
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
				$comentario = $this->input->post('comentario');
				$id_usuario = $this->session->userdata('id');
				$id_bolsa = $this->input->post('id_bolsa');
				
				$datos = array(
					'creacion' => $date,
					'id_usuario' => $id_usuario,
					'id_bolsa_trabajo' => $id_bolsa,
					'comentario' => $comentario
				);
				$this->reclutamiento_model->guardarHistorialBolsaTrabajo($datos);
				$msj = array(
					'codigo' => 1,
					'msg' => 'El registro se realizó correctamente'
				);
				
			}
			echo json_encode($msj);
		}
    function addRequisicion(){
      $this->form_validation->set_rules('nombre_req', 'Razón social', 'trim');
      $this->form_validation->set_rules('nombre_comercial_req', 'Nombre comercial', 'required|trim');
      $this->form_validation->set_rules('domicilio_req', 'Domicilio Fiscal', 'trim');
      $this->form_validation->set_rules('cp_req', 'Código postal', 'trim|numeric|max_length[5]');
      $this->form_validation->set_rules('telefono_req', 'Teléfono', 'trim|max_length[16]');
      $this->form_validation->set_rules('correo_req', 'Correo', 'trim|valid_email');
      $this->form_validation->set_rules('contacto_req', 'Contacto', 'trim');
      $this->form_validation->set_rules('rfc_req', 'RFC', 'trim|max_length[13]');
      $this->form_validation->set_rules('puesto_req', 'Nombre de la posición', 'required|trim');
      $this->form_validation->set_rules('numero_vacantes_req', 'Número de vacantes', 'required|numeric|max_length[2]');
      $this->form_validation->set_rules('residencia_req', 'Lugar de residencia', 'trim');
      $this->form_validation->set_rules('zona_req', 'Zona de trabajo', 'required|trim');
      $this->form_validation->set_rules('tipo_sueldo_req', 'Sueldo', 'required|trim');
      $this->form_validation->set_rules('sueldo_minimo_req', 'Sueldo mínimo', 'numeric|max_length[8]');
      $this->form_validation->set_rules('sueldo_maximo_req', 'Sueldo máximo', 'numeric|max_length[8]');
      $this->form_validation->set_rules('tipo_pago_req', 'Tipo de pago', 'required|trim');
      $this->form_validation->set_rules('ley_req', '¿Tendrá prestaciones de ley?', 'required');
      $this->form_validation->set_rules('experiencia_req', 'Se requiere experiencia en', 'trim');
      $this->form_validation->set_rules('observaciones_req', 'Observaciones adicionales', 'trim');

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
      }else{
        $date = date('Y-m-d H:i:s');
        $req = array(
          'creacion' => $date,
          'tipo' => 'EXPRESS',
          'id_usuario' => $this->session->userdata('id'),
          'nombre' => $this->input->post('nombre_req'),
          'nombre_comercial' => $this->input->post('nombre_comercial_req'),
          'domicilio' => $this->input->post('domicilio_req'),
          'cp' => $this->input->post('cp_req'),
          'telefono' => $this->input->post('telefono_req'),
          'correo' => $this->input->post('correo_req'),
          'contacto' => $this->input->post('contacto_req'),
          'rfc' => $this->input->post('rfc_req'),
          'puesto' => $this->input->post('puesto_req'),
          'numero_vacantes' => $this->input->post('numero_vacantes_req'),
          'lugar_residencia' => $this->input->post('residencia_req'),
          'zona_trabajo' => $this->input->post('zona_req'),
          'sueldo' => $this->input->post('tipo_sueldo_req'),
          'sueldo_minimo' => $this->input->post('sueldo_minimo_req'),
          'sueldo_maximo' => $this->input->post('sueldo_maximo_req'),
          'tipo_pago_sueldo' => $this->input->post('tipo_pago_req'),
          'tipo_prestaciones' => $this->input->post('ley_req'),
          'experiencia' => $this->input->post('experiencia_req'),
          'observaciones' => $this->input->post('observaciones_req')
        );
        $this->reclutamiento_model->addRequisicion($req);
        $msj = array(
          'codigo' => 1,
          'msg' => 'Requisición express registrada correctamente'
        );
      }
			echo json_encode($msj);
    }
    //* Funcion base
    function assignToUser(){
			$this->form_validation->set_rules('asignar_usuario[]', $this->input->post('label_usuario'), 'required|numeric|trim');
			$this->form_validation->set_rules('asignar_registro', $this->input->post('label_registro'), 'required|numeric|trim');
	
			$this->form_validation->set_message('required', 'El campo {field} es obligatorio');
			$this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
			$this->form_validation->set_message('numeric','El campo {field} debe ser numérico');
	
			$msj = array();
			if ($this->form_validation->run() == FALSE) {
				$msj = array(
					'codigo' => 0,
					'msg' => validation_errors()
				);
			}
			else{
        if($this->input->post('view') == 'bolsa_trabajo'){
          $data = array(
            'edicion' => date('Y-m-d H:i:s'),
            'id_usuario' => $this->input->post('asignar_usuario'),
          );
          $this->reclutamiento_model->editBolsaTrabajo($data, $this->input->post('asignar_registro'));
          $msj = array(
            'codigo' => 1,
            'msg' => 'La asignación se realizó correctamente'
          );
        }
        if($this->input->post('view') == 'requisicion'){
          $totalUsers = count($this->input->post('asignar_usuario'));
          for($i = 0; $i < $totalUsers; $i++){
            $data = array(
              'creacion' => date('Y-m-d H:i:s'),
              'id_requisicion' => $this->input->post('asignar_registro'),
              'id_usuario' => $this->input->post('asignar_usuario')[$i],
            );
            $this->reclutamiento_model->addUsersToOrder($data);
          }
          $msj = array(
            'codigo' => 1,
            'msg' => 'La asignación se realizó correctamente'
          );
        }
			}
			echo json_encode($msj);
		}
    function updateOrder(){
      $section = $this->input->post('section');
      if($section == 'data_facturacion'){
        $this->form_validation->set_rules('comercial_update', 'Nombre comercial', 'required|trim');
        $this->form_validation->set_rules('nombre_update', 'Razón social', 'required|trim');
        $this->form_validation->set_rules('domicilio_update', 'Domicilio Fiscal', 'required|trim');
        $this->form_validation->set_rules('cp_update', 'Código postal', 'required|trim|max_length[5]');
        $this->form_validation->set_rules('regimen_update', 'Régimen Fiscal', 'required|trim');
        $this->form_validation->set_rules('telefono_update', 'Teléfono', 'required|trim|max_length[16]');
        $this->form_validation->set_rules('correo_update', 'Correo', 'required|trim|valid_email');
        $this->form_validation->set_rules('contacto_update', 'Contacto', 'trim|required');
        $this->form_validation->set_rules('rfc_update', 'RFC', 'trim|required|max_length[13]');
        $this->form_validation->set_rules('forma_pago_update', 'Forma de pago', 'required|trim');
        $this->form_validation->set_rules('metodo_pago_update', 'Método de pago', 'required|trim');
        $this->form_validation->set_rules('uso_cfdi_update', 'Uso de CFDI', 'required|trim');
      }
      if($section == 'vacante'){
        $this->form_validation->set_rules('puesto_update', 'Nombre de la posición', 'required|trim');
        $this->form_validation->set_rules('num_vacantes_update', 'Número de vacantes', 'required|numeric|max_length[2]');
        $this->form_validation->set_rules('escolaridad_update', 'Formación académica requerida', 'required|trim');
        $this->form_validation->set_rules('estatus_escolaridad_update', 'Estatus académico', 'required|trim');
        $this->form_validation->set_rules('otro_estatus_update', 'Otro estatus académico', 'trim');
        $this->form_validation->set_rules('carrera_update', 'Carrera requerida para el puesto', 'required|trim');
        $this->form_validation->set_rules('otros_estudios_update', 'Otro estatus académico', 'trim');
        $this->form_validation->set_rules('idiomas_update', 'Idiomas que habla y porcentajes de cada uno', 'trim');
        $this->form_validation->set_rules('hab_informatica_update', 'Habilidades informáticas requeridas', 'trim');
        $this->form_validation->set_rules('genero_update', 'Sexo', 'required|trim');
        $this->form_validation->set_rules('civil_update', 'Estado civil', 'required|trim');
        $this->form_validation->set_rules('edad_minima_update', 'Edad mínima', 'required|numeric|max_length[2]');
        $this->form_validation->set_rules('edad_maxima_update', 'Edad máxima', 'required|numeric|max_length[2]');
        $this->form_validation->set_rules('licencia_update', 'Licencia de conducir', 'required|trim');
        $this->form_validation->set_rules('discapacidad_update', 'Discapacidad aceptable', 'required|trim');
        $this->form_validation->set_rules('causa_update', 'Causa que origina la vacante', 'required|trim');
        $this->form_validation->set_rules('residencia_update', 'Lugar de residencia', 'required|trim');
      }
      if($section == 'cargo'){
        $this->form_validation->set_rules('jornada_update', 'Jornada laboral', 'required|trim');
        $this->form_validation->set_rules('tiempo_inicio_update', 'Inicio de la Jornada laboral', 'required|trim');
        $this->form_validation->set_rules('tiempo_final_update', 'Fin de la Jornada laboral', 'required|trim');
        $this->form_validation->set_rules('descanso_update', 'Día(s) de descanso', 'required|trim');
        $this->form_validation->set_rules('viajar_update', 'Disponibilidad para viajar', 'required|trim');
        $this->form_validation->set_rules('horario_update', 'Disponibilidad de horario', 'required|trim');
        $this->form_validation->set_rules('lugar_entrevista_update', 'Lugar de la entrevista', 'trim');
        $this->form_validation->set_rules('zona_update', 'Zona de trabajo', 'required|trim');
        $this->form_validation->set_rules('tipo_sueldo_update', 'Sueldo', 'required|trim');
        $this->form_validation->set_rules('sueldo_minimo_update', 'Sueldo mínimo', 'numeric|max_length[8]');
        $this->form_validation->set_rules('sueldo_maximo_update', 'Sueldo máximo', 'required|numeric|max_length[8]');
        $this->form_validation->set_rules('sueldo_adicional_update', 'Adicional al sueldo', 'required|trim');
        $this->form_validation->set_rules('monto_adicional_update', 'Monto del sueldo adicional', 'trim');
        $this->form_validation->set_rules('tipo_pago_update', 'Tipo de pago', 'required|trim');
        $this->form_validation->set_rules('tipo_prestaciones_update', '¿Tendrá prestaciones de ley?', 'required');
        $this->form_validation->set_rules('superiores_update', '¿Tendrá prestaciones superiores? ¿Cuáles?', 'trim');
        $this->form_validation->set_rules('otras_prestaciones_update', '¿Tendrá otro tipo de prestaciones? ¿Cuáles?', 'trim');
        $this->form_validation->set_rules('experiencia_update', 'Se requiere experiencia en', 'required|trim');
        $this->form_validation->set_rules('actividades_update', 'Actividades a realizar', 'required|trim');
      }
      if($section == 'perfil'){
        $this->form_validation->set_rules('competencias', 'Competencias requeridas para el puesto', 'required|trim');
        $this->form_validation->set_rules('observaciones_update', 'Observaciones adicionales', 'trim');
      }
      $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
      $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');
      
      if ($this->form_validation->run() == FALSE) {
        $msj = array(
          'codigo' => 0,
          'msg' => validation_errors()
        );
      }
      else{
        if($section == 'data_facturacion'){
          $req = array(
            'edicion' => date('Y-m-d H:i:s'),
            'id_usuario' => $this->session->userdata('id'),
            'nombre_comercial' => $this->input->post('comercial_update'),
            'nombre' => $this->input->post('nombre_update'),
            'domicilio' => $this->input->post('domicilio_update'),
            'cp' => $this->input->post('cp_update'),
            'telefono' => $this->input->post('telefono_update'),
            'correo' => $this->input->post('correo_update'),
            'contacto' => $this->input->post('contacto_update'),
            'rfc' => $this->input->post('rfc_update'),
            'regimen' => $this->input->post('regimen_update'),
            'forma_pago' => $this->input->post('forma_pago_update'),
            'metodo_pago' => $this->input->post('metodo_pago_update'),
            'uso_cfdi' => $this->input->post('uso_cfdi_update'),
          );
          $sectionSuccessMessage = 'Datos de facturación actualizados correctamente';
        }
        if($section == 'vacante'){
          $req = array(
            'puesto' => $this->input->post('puesto_update'),
            'numero_vacantes' => $this->input->post('num_vacantes_update'),
            'escolaridad' => $this->input->post('escolaridad_update'),
            'estatus_escolar' => $this->input->post('estatus_escolaridad_update'),
            'otro_estatus_escolar' => $this->input->post('otro_estatus_update'),
            'carrera_requerida' => $this->input->post('carrera_update'),
            'idiomas' => $this->input->post('idiomas_update'),
            'otros_estudios' => $this->input->post('otros_estudios_update'),
            'habilidad_informatica' => $this->input->post('hab_informatica_update'),
            'genero' => $this->input->post('genero_update'),
            'estado_civil' => $this->input->post('civil_update'),
            'edad_minima' => $this->input->post('edad_minima_update'),
            'edad_maxima' => $this->input->post('edad_maxima_update'),
            'licencia' => $this->input->post('licencia_completa'),
            'discapacidad_aceptable' => $this->input->post('discapacidad_update'),
            'causa_vacante' => $this->input->post('causa_update'),
            'lugar_residencia' => $this->input->post('residencia_update'),
          );
          $sectionSuccessMessage = 'Información de la vacante actualizada correctamente';
        }
        if($section == 'cargo'){
          $req = array(
            'jornada_laboral' => $this->input->post('jornada_update'),
            'tiempo_inicio' => $this->input->post('tiempo_inicio_update'),
            'tiempo_final' => $this->input->post('tiempo_final_update'),
            'dias_descanso' => $this->input->post('descanso_update'),
            'disponibilidad_viajar' => $this->input->post('viajar_update'),
            'disponibilidad_horario' => $this->input->post('horario_update'),
            'lugar_entrevista' => $this->input->post('lugar_entrevista_update'),
            'zona_trabajo' => $this->input->post('zona_update'),
            'sueldo' => $this->input->post('tipo_sueldo_update'),
            'sueldo_adicional' => $this->input->post('sueldo_adicional_completo'),
            'sueldo_minimo' => $this->input->post('sueldo_minimo_update'),
            'sueldo_maximo' => $this->input->post('sueldo_maximo_update'),
            'tipo_pago_sueldo' => $this->input->post('tipo_pago_update'),
            'tipo_prestaciones' => $this->input->post('tipo_prestaciones_update'),
            'tipo_prestaciones_superiores' => $this->input->post('superiores_update'),
            'otras_prestaciones' => $this->input->post('otras_prestaciones_update'),
            'experiencia' => $this->input->post('experiencia_update'),
            'actividades' => $this->input->post('actividades_update'),
          );
          $sectionSuccessMessage = 'Información del cargo actualizada correctamente';
        }
        if($section == 'perfil'){
          $req = array(
            'competencias' => $this->input->post('competencias'),
            'observaciones' => $this->input->post('observaciones_update')
          );
          $sectionSuccessMessage = 'Información del perfil actualizada correctamente';
        }
        $this->reclutamiento_model->updateOrder($req, $this->input->post('id_requisicion'));
        $msj = array(
          'codigo' => 1,
          'msg' => $sectionSuccessMessage
        );
      }
      echo json_encode($msj);
    }
    function uploadCSV(){
      if(isset($_FILES["archivo"]["name"])) {
        $extensionArchivo = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
        if($extensionArchivo == 'csv'){
          $date = date('Y-m-d H:i:s');
          $id_usuario = $this->session->userdata('id');
    
          $rows     = [];
          $file     = $_FILES["archivo"];
          $tmp      = $file["tmp_name"];
          $filename = $file["name"];
          $size     = $file["size"];
    
          if ($size < 0) {
            $msj = array(
              'codigo' => 0,
              'msg' => 'Seleccione un archivo .csv válido'
            );
          }
          else{
            $handle = fopen($tmp, "r");
            while (($data = fgetcsv($handle)) !== false) {
              $rows[] = $data;
            }
            // se eliminan las cabeceras
            for($i = 0; $i <= 0; $i++){
              unset($rows[$i]); 
            }
            $total = count($rows);
            
            if ($total <= 0) {
              $msj = array(
                'codigo' => 0,
                'msg' => 'El archivo esta vacío'
              );
            }
            else{
              $errorMessages = ''; $successMessages = 'Registros agregados de la(s) fila(s):<br> '; $i = 0; $rowsAdded = 0;
              foreach($rows as $r){
                // Las columnas abarcan los indices del 1-9
                if($r[0] != ''){
                  $userCorrect = $this->usuario_model->getUserByIdByRole($r[0],[4,11]);
                  if($userCorrect != null){
                    if(preg_match("/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/i",$r[1])){// Evalua fecha con formato dd/mm/aaaa
                      if(preg_match("/^([a-zñáéíóúA-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/", $r[2]) &&
                          preg_match("/^([a-zñáéíóúA-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/", $r[3]) &&
                          preg_match("/^([a-zñáéíóúA-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/", $r[4])){// Evalua nombres propios aceptando minusculas al principio
                            $nombre = strtoupper($r[2]); $paterno = strtoupper($r[3]); $materno = strtoupper($r[4]);
                            $existName = $this->reclutamiento_model->getBolsaTrabajoByName($nombre, $paterno, $materno);
                            if($existName == null){
                              $existPhone = $this->reclutamiento_model->getBolsaTrabajoByPhone($r[5]);
                              if(preg_match("/^[\d]{2}[-]?[\d]{4}[-]?[\d]{4}$/",trim($r[5])) && $existPhone == null){//Numero de telefono con formato 00-0000-0000 o 0000000000
                                if(strlen($r[6]) > 0 && strlen($r[6]) <= 128){//Area de interes con limite 
                                  if(strlen($r[7]) > 0 && strlen($r[7]) <= 30){//Localizacion del aspirante
                                    $existContact = $this->funciones_model->getMediosContactoByName($r[8]);
                                    if($r[8] != '' && $existContact !== null){//Medio por el cual se contacto el aspirante
                                      $fecha = validar_fecha_espanol($r[1]);
                                      if($fecha)
                                        $fecha = fecha_espanol_bd($r[1]);
                                      else
                                        $fecha = date('Y-m-d H:i:s');
                                      $data = array(
                                        'creacion' => $fecha,
                                        'edicion' => $fecha,
                                        'id_usuario' => $r[0],
                                        'nombre' => strtoupper($r[2]),
                                        'paterno' => strtoupper($r[3]),
                                        'materno' => strtoupper($r[4]),
                                        'domicilio' => strtoupper($r[7]),
                                        'telefono' => trim($r[5]),
                                        'medio_contacto' => $existContact->nombre,
                                        'area_interes' => $r[6],
                                      );
                                      $this->reclutamiento_model->addBolsaTrabajo($data);
                                      $successMessages .= ($i+2).','; $i++; $rowsAdded++;
                                    }else{
                                      $errorMessages .= 'Medio de contacto vacío o no existe en el catalogo en la fila '.($i+2).'<br>'; $i++; continue;
                                    }
                                  }else{
                                    $errorMessages .= 'Localización vacía o demasiado extensa (limitado a 30 caracteres) en la fila '.($i+2).'<br>'; $i++; continue;
                                  }
                                }else{
                                  $errorMessages .= 'Área de interes vacía o demasiado extensa (limitado a 30 caracteres) en la fila '.($i+2).'<br>'; $i++; continue;
                                }
                              }else{
                                $errorMessages .= 'Número de teléfono ya existe o no es válido en la fila '.($i+2).'<br>'; $i++; continue;
                              }
                            }else{
                              $errorMessages .= 'El nombre ya existe en la fila '.($i+2).'<br>'; $i++; continue;
                            }
                        }else{
                          $errorMessages .= 'Nombre y/o apellidos no válidos en la fila '.($i+2).'<br>'; $i++; continue;
                        }
                    }else{
                      $errorMessages .= 'Formato de fecha no válido en la fila '.($i+2).'<br>'; $i++; continue;
                    }
                  }else{
                    $errorMessages .= 'El ID de usuario no es válido en la fila '.($i+2).'<br>'; $i++; continue;
                  }
                }else{
                  $errorMessages .= 'El ID de usuario no es válido en la fila '.($i+2).'<br>'; $i++; continue;
                }
              }
              if($errorMessages == ''){
                $msj = array(
                  'codigo' => 1,
                  'msg' => 'Los registros del archivo fueron cargados al sistema correctamente<br>'.substr($successMessages,0,-1)
                );
              }
              if($errorMessages != '' && $rowsAdded == 0){
                $response = 'No se agregaron registros del archivo ';
                $msj = array(
                  'codigo' => 0,
                  'msg' => 'Finalizó la carga pero se encontraron algunos errores en los siguientes registros:<br>'.$errorMessages.'<br>'.$response
                );
              }
              if($errorMessages != '' && $rowsAdded > 0){
                $response = substr($successMessages,0,-1);
                $msj = array(
                  'codigo' => 2,
                  'msg' => 'Finalizó la carga pero se encontraron algunos errores en los siguientes registros:<br>'.$errorMessages.'<br>'.$response
                );
              }
            }
          }
        }else{
          $msj = array(
            'codigo' => 0,
            'msg' => 'Seleccione un archivo .csv válido'
          );
        }
      }
      else{
        $msj = array(
          'codigo' => 0,
          'msg' => 'Seleccione un archivo .csv válido'
        );
      }
      echo json_encode($msj);
    }
    function deleteUserOrder(){
      $this->reclutamiento_model->deleteUserOrder($this->input->post('id'));
      $msj = array(
        'codigo' => 1,
        'msg' => 'Se ha eliminado el usuario de la requsición correctamente'
      );
      echo json_encode($msj);
    }
    function deleteOrder(){
      $id_usuario = $this->session->userdata('id');
      $datos = array(
        'edicion' => date('Y-m-d H:i:s'),
        'id_usuario' => $id_usuario,
        'eliminado' => 1,
        'comentario_final' => $this->input->post('comentario'),
      );
      $this->reclutamiento_model->editarRequisicion($datos, $this->input->post('id'));
      $msj = array(
        'codigo' => 1,
        'msg' => 'Requisicion eliminada correctamente'
      );
      echo json_encode($msj);
    }
    function updateApplicant(){
      $section = $this->input->post('section');
      if($section == 'personal'){
        $this->form_validation->set_rules('nombre_update', 'Nombre(s)', 'required|trim');
        $this->form_validation->set_rules('paterno_update', 'Primer apellido', 'required|trim');
        $this->form_validation->set_rules('materno_update', 'Segundo apellido', 'trim');
        $this->form_validation->set_rules('domicilio_update', 'Domicilio', 'required|trim');
        $this->form_validation->set_rules('fecha_nacimiento_update', 'Fecha de nacimiento', 'required|trim');
        $this->form_validation->set_rules('telefono_update', 'Teléfono', 'required|trim|max_length[16]');
        $this->form_validation->set_rules('nacionalidad_update', 'Nacionalidad', 'required|trim');
        $this->form_validation->set_rules('civil_update', 'Estado civil', 'required|trim');
        $this->form_validation->set_rules('dependientes_update', 'Personas que dependan del aspirante', 'required|trim');
        $this->form_validation->set_rules('escolaridad_update', 'Grado máximo de estudios', 'required|trim');
      }
      if($section == 'salud'){
        $this->form_validation->set_rules('salud_update', '¿Cómo es su estado de salud actual?', 'required|trim');
        $this->form_validation->set_rules('enfermedad_update', '¿Padece de alguna enfermedad crónica?', 'required|trim');
        $this->form_validation->set_rules('deporte_update', '¿Practica algún deporte?', 'required|trim');
        $this->form_validation->set_rules('metas_update', '¿Cuáles son sus metas en la vida?', 'required|trim');
      }
      if($section == 'conocimiento'){
        $this->form_validation->set_rules('idiomas_update', 'Idiomas que domina', 'required|trim');
        $this->form_validation->set_rules('maquinas_update', 'Máquinas de oficina o taller que maneje', 'required|trim');
        $this->form_validation->set_rules('software_update', 'Software que conoce', 'required|trim');
      }
      if($section == 'intereses'){
        $this->form_validation->set_rules('medio_contacto_update', '¿Cómo se enteró de RODI?', 'required|trim');
        $this->form_validation->set_rules('area_interes_update', '¿Qué área es de su interés?', 'required|trim');
        $this->form_validation->set_rules('sueldo_update', '¿Qué sueldo desea percibir?', 'required|trim');
        $this->form_validation->set_rules('otros_ingresos_update', '¿Tiene otros ingresos?', 'required|trim');
        $this->form_validation->set_rules('viajar_update', '¿Tiene disponibilidad para viajar?', 'required|trim');
        $this->form_validation->set_rules('trabajar_update', '¿Qué fecha o en qué momento podría presentarse a trabajar?', 'required|trim');
      }
      $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
      $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');
      
      if ($this->form_validation->run() == FALSE) {
        $msj = array(
          'codigo' => 0,
          'msg' => validation_errors()
        );
      }
      else{
        if($section == 'personal'){
          $edad = calculaEdad($this->input->post('fecha_nacimiento_update'));
          $bolsa = array(
            'edicion' => date('Y-m-d H:i:s'),
            'id_usuario' => $this->session->userdata('id'),
            'nombre' => $this->input->post('nombre_update'),
            'paterno' => $this->input->post('paterno_update'),
            'materno' => $this->input->post('materno_update'),
            'domicilio' => $this->input->post('domicilio_update'),
            'edad' => $edad,
            'fecha_nacimiento' => $this->input->post('fecha_nacimiento_update'),
            'telefono' => $this->input->post('telefono_update'),
            'nacionalidad' => $this->input->post('nacionalidad_update'),
            'civil' => $this->input->post('civil_update'),
            'dependientes' => $this->input->post('dependientes_update'),
            'grado_estudios' => $this->input->post('escolaridad_update'),
          );
          $sectionSuccessMessage = 'Datos personales actualizados correctamente';
          $aspirante = array(
            'edicion' => date('Y-m-d H:i:s'),
            'id_usuario' => $this->session->userdata('id'),
            'nombre' => $this->input->post('nombre_update'),
            'paterno' => $this->input->post('paterno_update'),
            'materno' => $this->input->post('materno_update'),
          );
          $this->reclutamiento_model->updateApplicantByIdBolsaTrabajo($aspirante, $this->input->post('id_bolsa'));
        }
        if($section == 'salud'){
          $bolsa = array(
            'salud' => $this->input->post('salud_update'),
            'enfermedad' => $this->input->post('enfermedad_update'),
            'deporte' => $this->input->post('deporte_update'),
            'metas' => $this->input->post('metas_update'),
          );
          $sectionSuccessMessage = 'Información de la salud y vida social actualizadas correctamente';
        }
        if($section == 'conocimiento'){
          $bolsa = array(
            'idiomas' => $this->input->post('idiomas_update'),
            'maquinas' => $this->input->post('maquinas_update'),
            'software' => $this->input->post('software_update'),
          );
          $sectionSuccessMessage = 'Información de conocimiento y habilidades actualizada correctamente';
        }
        if($section == 'intereses'){
          $bolsa = array(
            'medio_contacto' => $this->input->post('medio_contacto_update'),
            'area_interes' => $this->input->post('area_interes_update'),
            'sueldo_deseado' => $this->input->post('sueldo_update'),
            'otros_ingresos' => $this->input->post('otros_ingresos_update'),
            'viajar' => $this->input->post('viajar_update'),
            'trabajar' => $this->input->post('trabajar_update'),
          );
          $sectionSuccessMessage = 'Información de los intereses actualizada correctamente';
          $aspirante = array(
            'edicion' => date('Y-m-d H:i:s'),
            'id_usuario' => $this->session->userdata('id'),
            'medio_contacto' => $this->input->post('medio_contacto_update'),
          );
          $this->reclutamiento_model->updateApplicantByIdBolsaTrabajo($aspirante, $this->input->post('id_bolsa'));
        }
        $this->reclutamiento_model->editBolsaTrabajo($bolsa, $this->input->post('id_bolsa'));
        $msj = array(
          'codigo' => 1,
          'msg' => $sectionSuccessMessage
        );
      }
      echo json_encode($msj);
    }
    function updateWarrantyApplicant(){
      $this->form_validation->set_rules('sueldo_acordado', 'Sueldo acordado', 'required|trim');
      $this->form_validation->set_rules('fecha_ingreso', 'Fecha de ingreso a la empresa', 'trim');
      $this->form_validation->set_rules('pago', 'Pago', 'trim');
      $this->form_validation->set_rules('garantia', 'Estatus de la garantia', 'trim');

      $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
      $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
      $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

      $msj = array();
      if ($this->form_validation->run() == FALSE) {
        $msj = array(
          'codigo' => 0,
          'msg' => validation_errors()
        );
      }else{
        $aspirante = array(
          'edicion' => date('Y-m-d H:i:s'),
          'id_usuario' => $this->session->userdata('id'),
          'sueldo_acordado' => $this->input->post('sueldo_acordado'),
          'fecha_ingreso' => $this->input->post('fecha_ingreso'),
          'pago' => $this->input->post('pago'),
        );
        $this->reclutamiento_model->editarAspirante($aspirante, $this->input->post('id_aspirante'));
        if($this->input->post('garantia') != ''){
          $garantia = array(
            'creacion' => date('Y-m-d H:i:s'),
            'id_usuario' => $this->session->userdata('id'),
            'id_aspirante' => $this->input->post('id_aspirante'),
            'descripcion' => $this->input->post('garantia'),
          );
          $this->reclutamiento_model->addWarrantyApplicant($garantia);
        }
        $msj = array(
          'codigo' => 1,
          'msg' => 'Información de ingreso actualizada correctamente'
        );
      }
			echo json_encode($msj);
    }
	/*----------------------------------------*/
  /*	Consultas
  /*----------------------------------------*/
		function getDetailsOrderById(){
			$id = $this->input->post('id');
			$res = $this->reclutamiento_model->getDetailsOrderById($id);
			echo json_encode($res);
		}
		function getAspirantesRequisiciones(){
			if($this->session->userdata('idrol') == 4){
				$id_usuario = $this->session->userdata('id');
				$condicion = 'A.id_usuario';
			}
			else{
				$id_usuario = 0;
				$condicion = 'A.id_usuario >';
			}
			$req['recordsTotal'] = $this->reclutamiento_model->getAspirantesRequisicionesTotal($id_usuario, $condicion);
			$req['recordsFiltered'] = $this->reclutamiento_model->getAspirantesRequisicionesTotal($id_usuario, $condicion);
			$req['data'] = $this->reclutamiento_model->getAspirantesRequisiciones($id_usuario, $condicion);
			$this->output->set_output( json_encode( $req ) );
		}
		function getAspirantesPorRequisicion(){
			$id_requisicion = $_GET['id'];
			if($this->session->userdata('idrol') == 4){
				$id_usuario = $this->session->userdata('id');
				$condicion = 'A.id_usuario';
			}
			else{
				$id_usuario = 0;
				$condicion = 'A.id_usuario >';
			}
			$req['recordsTotal'] = $this->reclutamiento_model->getAspirantesPorRequisicionTotal($id_usuario, $condicion, $id_requisicion);
			$req['recordsFiltered'] = $this->reclutamiento_model->getAspirantesPorRequisicionTotal($id_usuario, $condicion, $id_requisicion);
			$req['data'] = $this->reclutamiento_model->getAspirantesPorRequisicion($id_usuario, $condicion, $id_requisicion);
			$this->output->set_output( json_encode( $req ) );
		}
		function getHistorialAspirante(){
			$id = $this->input->post('id');
			$tipo_id = $this->input->post('tipo_id');
      if($tipo_id == 'aspirante')
        $campo = 'id_aspirante';
      if($tipo_id == 'bolsa')
        $campo = 'id_bolsa_trabajo';
			$data['registros'] = $this->reclutamiento_model->getHistorialAspirante($id, $campo);
			if($data['registros']){
				echo json_encode($data['registros']);
			}
			else{
				echo $resp = 0;
			}
		}
		function getAspirantesRequisicionesFinalizadas(){
			if($this->session->userdata('idrol') == 4){
				$id_usuario = $this->session->userdata('id');
				$condicion = 'A.id_usuario';
			}
			else{
				$id_usuario = 0;
				$condicion = 'A.id_usuario >';
			}
			$req['recordsTotal'] = $this->reclutamiento_model->getAspirantesRequisicionesFinalizadasTotal($id_usuario, $condicion);
			$req['recordsFiltered'] = $this->reclutamiento_model->getAspirantesRequisicionesFinalizadasTotal($id_usuario, $condicion);
			$req['data'] = $this->reclutamiento_model->getAspirantesRequisicionesFinalizadas($id_usuario, $condicion);
			$this->output->set_output( json_encode( $req ) );
		}
		function getAspirantesPorRequisicionesFinalizadas(){
			$id_requisicion = $_GET['id'];
			if($this->session->userdata('idrol') == 4){
				$id_usuario = $this->session->userdata('id');
				$condicion = 'A.id_usuario';
			}
			else{
				$id_usuario = 0;
				$condicion = 'A.id_usuario >';
			}
			$req['recordsTotal'] = $this->reclutamiento_model->getAspirantesPorRequisicionesFinalizadasTotal($id_usuario, $condicion, $id_requisicion);
			$req['recordsFiltered'] = $this->reclutamiento_model->getAspirantesPorRequisicionesFinalizadasTotal($id_usuario, $condicion, $id_requisicion);
			$req['data'] = $this->reclutamiento_model->getAspirantesPorRequisicionesFinalizadas($id_usuario, $condicion, $id_requisicion);
			$this->output->set_output( json_encode( $req ) );
		}
    function getBolsaTrabajoById(){
			$id = $this->input->post('id');
			$res = $this->reclutamiento_model->getBolsaTrabajoById($id);
			echo json_encode($res);
		}
    function getEmpleosByIdBolsaTrabajo(){
			$id = $this->input->post('id');
			$data['empleos'] = $this->reclutamiento_model->getEmpleosByIdBolsaTrabajo($id);
			if($data['empleos']){
				echo json_encode($data['empleos']);
			}
			else{
				echo $resp = 0;
			}
		}
    function getHistorialBolsaTrabajo(){
			$id = $this->input->post('id');
			$data['registros'] = $this->reclutamiento_model->getHistorialBolsaTrabajo($id);
			if($data['registros']){
				echo json_encode($data['registros']);
			}
			else{
				echo $resp = 0;
			}
		}
    function getRequisicionesActivas(){
			$res = $this->reclutamiento_model->getRequisicionesActivas();
      if($res != null)
			  echo json_encode($res);
      else 
        echo $res = 0;
		}
    function getTestsByOrder(){
			$id = $this->input->post('id');
			$data['registros'] = $this->reclutamiento_model->getTestsByOrder($id);
			if($data['registros']){
				echo json_encode($data['registros']);
			}
			else{
				echo $resp = 0;
			}
		}
    function getOrdersInProcess(){
			//Dependiendo el rol del usuario se veran todas o sus propias requisiciones
			if($this->session->userdata('idrol') == 4){
				$id_usuario = $this->session->userdata('id');
        $res = $this->reclutamiento_model->getOrdersInProcessByUser($id_usuario);
			}
			else{
        $res = $this->reclutamiento_model->getAllOrdersInProcess();
      }
			echo json_encode($res);
		}
    function getDetailsApplicantById(){
			$id = $this->input->post('id');
			$res = $this->reclutamiento_model->getBolsaTrabajoById($id);
			echo json_encode($res);
		}
    function getWarrantyApplicant(){
			$id = $this->input->post('id');
			$res = $this->reclutamiento_model->getWarrantyApplicant($id);
      if($res != null)
			  echo json_encode($res);
      else
        echo $res = 0;
		}
	function matchCliente(){
		if(isset($_GET['term'])){
	      	//$term = strtoupper($_GET['term']);
	      	$term = $_GET['term'];
	      	//echo $id;
	      	echo json_encode($this->reclutamiento_model->matchCliente($term));
	    }
	}
}