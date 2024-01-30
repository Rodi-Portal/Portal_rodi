<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct(){
		parent::__construct();
	}

	//Formulario de Login establecido por default
	function index(){
		$config = $this->funciones_model->getConfiguraciones();
		$data['version'] = $config->version_sistema;
		$this->load->view('login/login_view',$data);
	}
	//Vista del Dashboard SI hay o NO session; redireciconamiento a inicio desde menú
	function veryfing_account(){
		$this->form_validation->set_rules('correo', 'Email', 'required|valid_email|trim');
		$this->form_validation->set_rules('pwd', 'Estatus final del BGC', 'required|trim');
			
		$this->form_validation->set_message('required','El campo {field} es obligatorio');
		$this->form_validation->set_message('valid_email','El campo {field} debe ser un email válido');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('not-found', 'Type your email account and password');
			redirect('Login/index');
		} 
		else{
			$base = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
			$pass = md5($base . $this->input->post('pwd'));
			$usuario = $this->usuario_model->existeUsuario($this->input->post('correo'), $pass);
			if ($usuario) {
				$usuario_data = array(
					"id" => $usuario->id,
					"nombre" => $usuario->nombre,
					"paterno" => $usuario->paterno,
					"rol" => $usuario->rol,
					"idrol" => $usuario->id_rol,
					"tipo" => 1,
					"loginBD" => $usuario->loginBD,
					"logueado" => TRUE
				);
				$this->session->set_userdata($usuario_data);

				//* Insercion de datos de sesion
				$sesion = array(
					'id_usuario' => $this->session->userdata('id'),
					'tipo_usuario' => 1,
					'ip' => $_SERVER['REMOTE_ADDR'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'],
					'ingreso' => date('Y-m-d H:i:s')
				);
				$this->usuario_model->addSesion($sesion);

				if ($usuario->id_rol != 3) {
					redirect('Dashboard/index');
				} 
				else {
					redirect('Dashboard/visitador_panel');
				}
			}
			else {
				$cliente = $this->usuario_model->existeUsuarioCliente($this->input->post('correo'), $pass);
				if ($cliente) {
					$cliente_data = array(
						"id" => $cliente->id,
						"correo" => $cliente->correo,
						"nombre" => $cliente->nombre,
						"paterno" => $cliente->paterno,
						"nuevopassword" => $cliente->nuevo_password,
						"idcliente" => $cliente->id_cliente,
						"cliente" => $cliente->cliente,
						"privacidad" => $cliente->privacidad,
						"tipo" => 2,
						"loginBD" => $cliente->loginBD,
						"ingles" => $cliente->ingles,
						"espectador" =>$cliente->espectador,
						"logueado" => TRUE
					);
					$this->session->set_userdata($cliente_data);

					//* Insercion de datos de sesion
					$sesion = array(
						'id_usuario' => $this->session->userdata('id'),
						'tipo_usuario' => 2,
						'ip' => $_SERVER['REMOTE_ADDR'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'],
						'ingreso' => date('Y-m-d H:i:s')
					);
					$this->usuario_model->addSesion($sesion);

					if($this->session->userdata('tipo') == 2){
						
						//redirect('Dashboard/client');
						

						// if ($cliente->id_cliente == 1) {
						//   redirect('Dashboard/ustglobal_panel');
						// }
						if ($cliente->id_cliente == 2 || $cliente->id_cliente == 205 || $cliente->id_cliente == 233 || $cliente->id_cliente == 250) {
							redirect('Dashboard/hcl_panel');
							//redirect('Dashboard/client_panel');
						}
						// if ($cliente->id_cliente == 205) {
						// 	redirect('Dashboard/client_panel');
						// }
						//if ($cliente->id_cliente != 1 && $cliente->id_cliente != 2 && $cliente->id_cliente != 205) {
						if ($cliente->id_cliente != 2 && $cliente->id_cliente != 205 && $cliente->id_cliente != 233 && $cliente->id_cliente != 250) {
							redirect('Dashboard/clientes_panel');
						}
					}
					else{
						$this->session->set_flashdata('not-found', 'Email account and/or password are not valid');
						redirect('Login/index');
					}
				} 
				else {
					$pass = md5($this->input->post('pwd') . $base);
					$candidato = $this->candidato_model->existeCandidato($this->input->post('correo'), $pass);
					if ($candidato) {
						if ($candidato->fecha_nacimiento != "0000-00-00" && $candidato->fecha_nacimiento != null) {
							$aux = explode('-', $candidato->fecha_nacimiento);
							$fnacimiento = $aux[1] . '/' . $aux[2] . '/' . $aux[0];
						} else {
							$fnacimiento = "";
						}
						$candidato_data = array(
							"id" => $candidato->id,
							"correo" => $candidato->correo,
							"nombre" => $candidato->nombre,
							"paterno" => $candidato->paterno,
							"materno" => $candidato->materno,
							"fecha" => $fnacimiento,
							"status" => $candidato->status,
							"proceso" => $candidato->id_tipo_proceso,
							"proyecto" => $candidato->id_proyecto,
							"idcliente" => $candidato->id_cliente,
							"idsubcliente" => $candidato->id_subcliente,
							"proyecto_seccion" => $candidato->proyecto,
							"tipo" => 3,
							"logueado" => TRUE
						);
						$this->session->set_userdata($candidato_data);
						//Filtro para acceso a formulario de candidato de acuerdo al tipo asignado
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
						$data['secciones'] = $this->candidato_seccion_model->getSecciones($candidato->id);
						$data['documentos_requeridos'] = $this->documentacion_model->getDocumentosRequeridosByCandidato($candidato->id);
						$data['avances'] = $this->candidato_avance_model->getAllById($candidato->id);

						//* Mejora
						// $archivos = array();
						// if($data['UploadedDocuments']){
						// 	foreach($data['UploadedDocuments'] as $file){
						// 		array_push($archivos, $file->id_tipo_documento);
						// 	}
						// 	$data['archivos'] = $archivos;
						// }
						// else{
						// 	$data['archivos'] = 0;
						// }

						//TODO:La siguiente linea es una prueba para mejorar el formulario de candidatos
						//TODO: Se requiere una tabla donde dependiendo del id de Documentacion, se asignen los documentos requeridos
						//if ($candidato->id_cliente != 2 && $candidato->id_cliente != 205 && $candidato->id_cliente != 250) {
						//if ($candidato->id_cliente != 205 && $candidato->id_cliente != 250) {
							//return $this->load->view('mantenimiento/acceso_candidatos',$data);
							redirect('Dashboard/candidate_panel');
							//return $this->load->view('candidato/formulario',$data);
						//}

						if($candidato->tipo_formulario == 0){
							$this->session->set_flashdata('not-found', 'El usuario o la contraseña son incorrectos.');
							redirect('Login/index');
						}
						else{
							if($candidato->tipo_formulario == 1){
								if ($candidato->formulario_contestado != NULL && $candidato->documentos_cargados != NULL){
									$this->session->set_flashdata('not-found', 'El usuario o la contraseña son incorrectos.');
									redirect('Login/index');
								}
								else{
									if ($candidato->status == 0) {
										$this->load->view('candidato/index',$data);
									}
									if ($candidato->status == 1) {
										$datos['documentos'] = $this->candidato_model->checkDocsCandidato($this->session->userdata('id'));
										if($datos['documentos']){
											$docs = array();
											foreach($datos['documentos'] as $doc){
												if($doc->id_tipo_documento == 3 || $doc->id_tipo_documento == 8 || $doc->id_tipo_documento == 12 || $doc->id_tipo_documento == 7 || $doc->id_tipo_documento == 10 || $doc->id_tipo_documento == 9|| $doc->id_tipo_documento == 28 || $doc->id_tipo_documento == 44 || $doc->id_tipo_documento == 14)
													$docs[] = $doc->id_tipo_documento;
											}
											$data['docs_candidato'] = $docs;
										}
										else{
											$docs = array();
											$data['docs_candidato'] = $docs;
										}
										$this->load->view('candidato/upload_anterior',$data);
									}
								}
							}
							if($candidato->tipo_formulario == 2){
								$data['parametros'] = $this->candidato_model->getSeccionesCandidato($this->session->userdata('id'));
								if ($candidato->formulario_contestado != NULL && $candidato->documentos_cargados != NULL){
									$this->session->set_flashdata('not-found', 'El usuario o la contraseña son incorrectos.');
									redirect('Login/index');
								}
								else{
									if($candidato->formulario_contestado == NULL && $candidato->documentos_cargados == NULL){
										$data['studies'] = $this->cliente_model->getTiposStudies();
										$this->load->view('candidato/subcliente_ingles_form',$data);
									}
									if($candidato->formulario_contestado != NULL && $candidato->documentos_cargados == NULL){
										$datos['documentos'] = $this->candidato_model->checkDocsCandidato($this->session->userdata('id'));
										if($datos['documentos']){
											$docs = array();
											foreach($datos['documentos'] as $doc){
												if($doc->id_tipo_documento == 3 || $doc->id_tipo_documento == 8 || $doc->id_tipo_documento == 12 || $doc->id_tipo_documento == 7 || $doc->id_tipo_documento == 10 || $doc->id_tipo_documento == 9)
													$docs[] = $doc->id_tipo_documento;
											}
											$data['docs_candidato'] = $docs;
										}
										else{
											$docs = array();
											$data['docs_candidato'] = $docs;
										}
										$this->load->view('candidato/upload_anterior',$data);
									}
								}
							}
							if($candidato->tipo_formulario == 3){
								$data['parametros'] = $this->candidato_model->getSeccionesCandidato($this->session->userdata('id'));
								$data['studies'] = $this->cliente_model->getTiposStudies();
								$data['paises'] = $this->funciones_model->getPaises();
								$data['docs_requeridos'] = $this->candidato_model->getDocumentosCandidatoRequeridos($this->session->userdata('id'));
								$data['info'] = $this->candidato_model->getInfoCandidatoEspecifico($this->session->userdata('id'));
								$data['refs'] = $this->candidato_model->getReferenciasLaborales($this->session->userdata('id'));
								$data['doms'] = $this->candidato_model->getHistorialDomicilios($this->session->userdata('id'));
								$data['profs'] = $this->candidato_model->getReferenciasProfesionales($this->session->userdata('id'));
								$data['pers'] = $this->candidato_model->getReferenciasPersonales($this->session->userdata('id'));
								$this->load->view('candidato/hcl_form',$data);
								/*
								if($candidato->status == 1){
									$data['docs_requeridos'] = $this->candidato_model->getDocumentosCandidatoRequeridos($this->session->userdata('id'));
									$this->load->view('candidato/upload',$data);
								}*/
							}
							if($candidato->tipo_formulario == 4){
								$data['parametros'] = $this->candidato_model->getSeccionesCandidato($this->session->userdata('id'));
								$data['studies'] = $this->cliente_model->getTiposStudies();
								$data['paises'] = $this->funciones_model->getPaises();
								$data['docs_requeridos'] = $this->candidato_model->getDocumentosCandidatoRequeridos($this->session->userdata('id'));
								$data['info'] = $this->candidato_model->getInfoCandidatoEspecifico($this->session->userdata('id'));
								$data['refs'] = $this->candidato_model->getReferenciasLaborales($this->session->userdata('id'));
								$data['doms'] = $this->candidato_model->getHistorialDomicilios($this->session->userdata('id'));
								$data['profs'] = $this->candidato_model->getReferenciasProfesionales($this->session->userdata('id'));
								$data['pers'] = $this->candidato_model->getReferenciasPersonales($this->session->userdata('id'));

								$this->load->view('candidato/hcl_international_form',$data);
								/*if($candidato->status == 1){
									$this->load->view('candidato/upload',$data);
								}*/
							}
						}
					} 
					else {
						$pass = md5($base . $this->input->post('pwd'));
						$subcliente = $this->usuario_model->existeUsuarioSubcliente($this->input->post('correo'), $pass);
						if ($subcliente) {
							$subcliente_data = array(
								"id" => $subcliente->id,
								"correo" => $subcliente->correo,
								"nombre" => $subcliente->nombre,
								"paterno" => $subcliente->paterno,
								"nuevopassword" => $subcliente->nuevo_password,
								"idcliente" => $subcliente->id_cliente,
								"idsubcliente" => $subcliente->id_subcliente,
								"cliente" => $subcliente->cliente,
								"subcliente" => $subcliente->subcliente,
								"tipo" => 4,
								"loginBD" => $subcliente->loginBD,
								"ingles" => $subcliente->ingles,
								"logueado" => TRUE
							);
							$this->session->set_userdata($subcliente_data);

							//* Insercion de datos de sesion
							$sesion = array(
								'id_usuario' => $this->session->userdata('id'),
								'tipo_usuario' => 3,
								'ip' => $_SERVER['REMOTE_ADDR'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'],
								'ingreso' => date('Y-m-d H:i:s')
							);
							$this->usuario_model->addSesion($sesion);
							//* Nuevo Panel
							// if($subcliente->ingles == 1){
							//   $this->lang->load('clientes_panel','english');
							// }
							// else{
							//   $this->lang->load('clientes_panel','espanol');
							// }
							// $data['translations'] = $this->lang->language;
							// $modal['translations'] = $this->lang->language;
							// $data['modals'] = $this->load->view('modals/clientes/mdl_panel',$modal, TRUE);
							// return $this->load->view('clientes/index',$data);

							if ($subcliente->tipo_acceso == 1) {
								redirect('Dashboard/subclientes_general_panel');
							}
							else{
								redirect('Dashboard/subclientes_ingles_panel');
							}
						} 
						else {
							$this->session->set_flashdata('not-found', 'Email account and/or password are not valid');
							redirect('Login/index');
						}
					}
				}
			}
		}
	}
	//Vista para recuperar contraseña
	function recovery_view(){
		$config = $this->funciones_model->getConfiguraciones();
		$data['version'] = $config->version_sistema;
		$this->load->view('login/recuperar_view',$data);
	}
	function new_password(){
		$this->form_validation->set_rules('correo', 'Email', 'required|valid_email|trim');
			
		$this->form_validation->set_message('required','El campo {field} es obligatorio');
		$this->form_validation->set_message('valid_email','El campo {field} debe ser un email válido');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', 'Enter your email account');
			redirect('Login/recovery_view');
		} 
		else{
			$correo = $this->input->post('correo');
			$base = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
			$pwd = generarPassword();
			$password = md5($base . $pwd);

			$hayIDCliente = $this->usuario_model->checkCorreoCliente($correo);
			if($hayIDCliente != NULL){
				$usuario = array(
					'password' => $password
				);
				$this->cliente_model->actualizarUsuarioCliente($usuario, $hayIDCliente->id);
				//Envío de correo
				$to = $correo;
				$subject = "Password recovery - RODICONTROL";
				$datos['password'] = $pwd;
				$datos['email'] = $correo;
				$message = $this->load->view('mails/mail_recuperacion_password',$datos,TRUE);
				$this->load->library('phpmailer_lib');
				$mail = $this->phpmailer_lib->load();
				$mail->isSMTP();
				$mail->Host     = 'mail.rodicontrol.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'rodicontrol@rodicontrol.com';
				$mail->Password = 'r49o*&rUm%91';
				$mail->SMTPSecure = 'ssl';
				$mail->Port     = 465;
				
				$mail->setFrom('rodicontrol@rodicontrol.com', 'Password recovery');
				$mail->addAddress($to);
				$mail->Subject = $subject;
				$mail->isHTML(true);
				$mailContent = $message;
				$mail->Body = $mailContent;

				if($mail->send()){
					$this->session->set_flashdata('success', 'If your email account is registered, the password will be sent shortly');
					redirect('Login/recovery_view');
				}else{
					$this->session->set_flashdata('error', 'We are having problems sending emails, please try again later');
					redirect('Login/recovery_view');
				}
			}
			else{
				$hayIDSubcliente = $this->usuario_model->checkCorreoSubcliente($correo);
				if($hayIDSubcliente != NULL){
					$usuario = array(
						'password' => $password
					);
					$this->cliente_model->actualizarUsuarioSubcliente($usuario, $hayIDSubcliente->id);
					//Envío de correo
					$to = $correo;
					$subject = "Password recovery - RODICONTROL";
					$datos['password'] = $pwd;
					$datos['email'] = $correo;
					$message = $this->load->view('mails/mail_recuperacion_password',$datos,TRUE);
					$this->load->library('phpmailer_lib');
					$mail = $this->phpmailer_lib->load();
					$mail->isSMTP();
					$mail->Host     = 'mail.rodicontrol.com';
					$mail->SMTPAuth = true;
					$mail->Username = 'rodicontrol@rodicontrol.com';
					$mail->Password = 'r49o*&rUm%91';
					$mail->SMTPSecure = 'ssl';
					$mail->Port     = 465;
					
					$mail->setFrom('rodicontrol@rodicontrol.com', 'Password recovery');
					$mail->addAddress($to);
					$mail->Subject = $subject;
					$mail->isHTML(true);
					$mailContent = $message;
					$mail->Body = $mailContent;

					if($mail->send()){
						$this->session->set_flashdata('success', 'If your email account is registered, the password will be sent shortly');
						redirect('Login/recovery_view');
					}else{
						$this->session->set_flashdata('error', 'We are having problems sending emails, please try again later');
						redirect('Login/recovery_view');
					}
				}
				else{
					$this->session->set_flashdata('success', 'If your email account is registered, the password will be sent shortly');
					redirect('Login/recovery_view');
				}
			}
		}
	}
	//Funcion para salir del sistema y presentar el formulario del login
	function logout(){
		$usuario_data = array(
			'logueado' => FALSE
		);
		$this->session->sess_destroy();
		redirect('Login/index');
	}
}
