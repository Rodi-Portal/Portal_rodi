<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cat_UsuarioInternos extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
  
  function index(){
    $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
    foreach($data['submodulos'] as $row) {
      $items[] = $row->id_submodulo;
    } 
    $data['submenus'] = $items;
  
    $datos['modals'] = $this->load->view('modals/mdl_catalogos/mdl_registro_usuariointe','', TRUE);

    $config = $this->funciones_model->getConfiguraciones();
		$data['version'] = $config->version_sistema;

    //Modals
    $modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);

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
    ->view('catalogos/usuarios_interno',$datos)
    ->view('adminpanel/footer');
  }
  
  function getUsuarios(){
    $id_portal = $this->session->userdata('idPortal');
		$usuarios_interno['recordsTotal'] = $this->cat_usuario_model->getTotal($id_portal);
    $usuarios_interno['recordsFiltered'] = $this->cat_usuario_model->getTotal($id_portal);
    $usuarios_interno['data'] = $this->cat_usuario_model->getUsuarios($id_portal);
    $this->output->set_output( json_encode( $usuarios_interno ) );
	}

/************************************EDITAR USUARIO INTERNO*****************************************/
function editarUsuarioControlador()
{
  $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
  $this->form_validation->set_rules('paterno', 'Paterno', 'required|trim');
  $this->form_validation->set_rules('correo', 'Correo', 'required|trim|valid_email');
  $this->form_validation->set_rules('telefono', 'telefono', 'required|is_unique[datos_generales.telefono]');

  $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
  
    $id_usuario = $this->session->userdata('id');
      date_default_timezone_set('America/Mexico_City');
      $date = date('Y-m-d H:i:s');
      $nombre = $this->input->post('nombre');
      $paterno = $this->input->post('paterno');
      $materno = $this->input->post('materno');
      $id_rol = $this->input->post('id_rol');
      $correo = $this->input->post('correo');
      $telefono = $this->input->post('telefono');

     
     // $uncode_password = $this->input->post('password');
     // $base = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
     // $password = md5($base.$uncode_password);
      $idUsuario = $this->input->post('idUsuarioInterno');
      $idDatos = $this->input->post('idDatosGenerales');
      $existeTelefono = $this->generales_model->telefonoExiste($telefono, $idDatos );


      $usuariosInternos = array(
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'id_rol' => $id_rol,
      );

      $datosGenerales = array(
        'nombre' => $nombre,
        'paterno' => $paterno,
        
        'correo' => $correo,
        'telefono' => $telefono,
      );


      $existe = $this->cat_usuario_model->check($idUsuario);
      

      if($existe > 0){

        $existeCorreo =  $this->cat_usuario_model->correoExiste($correo, $idUsuario);

          if ($existeCorreo !== 0) {
            $msj = array(
              'codigo' => 2,
              'msg' => 'El correo proporcionado ya existe'
            );
            echo json_encode($msj);
            return; // Detener el flujo del código ya que hay un error
          }

        $result =  $this->cat_usuario_model->editUsuario($idUsuario, $usuariosInternos, $idDatos ,$datosGenerales);
          // echo "aqui el resultado : ".$result;
        if($result){
          $msj = array(
            'codigo' => 1,
            'msg' => 'success'
            );
       }else{
        $msj = array(
          'codigo' => 0,
          'msg' => 'error'
          );
       }
      
        echo json_encode($msj);

      }else {
        $msj = array(
            'codigo' => 0, 
            'msg' => 'No se pudo encontrar el usuario para editar'
        );
        echo json_encode($msj);
    }
  
}

 //---------LIGADA A LA FUNCION DE registroUsuariosInternos DEL CATALOGO USUARIOS_INTERNOS
  function addUsuarioInterno(){
    $this->form_validation->set_rules('nombre', 'nombre', 'required');
    $this->form_validation->set_rules('paterno', 'paterno', 'required');
    $this->form_validation->set_rules('materno', 'materno');
    $this->form_validation->set_rules('id_rol', 'id_rol', 'required');
    $this->form_validation->set_rules('telefono', 'telefono', 'required|is_unique[datos_generales.telefono]');

    $this->form_validation->set_rules('correo', 'Correo', 'required|valid_email|is_unique[datos_generales.correo]');
    $this->form_validation->set_rules('password1', 'Contraseña', 'required');

    $this->form_validation->set_message('required','El campo %s es obligatorio');
    $this->form_validation->set_message('is_unique','El %s ya esta registrado');
    $this->form_validation->set_message('valid_email','El campo %s debe ser un correo válido');

    $msj = array();
    if ($this->form_validation->run() == FALSE) {
      $msj = array(
        'codigo' => 0,
        'msg' => validation_errors()
      );
    
    } 
    
    else {
     
      
      $id_usuario = $this->session->userdata('id');
      date_default_timezone_set('America/Mexico_City');
      $date = date('Y-m-d H:i:s');
      $nombre = $this->input->post('nombre');
      $paterno = $this->input->post('paterno');
      $materno = $this->input->post('materno');
      $id_rol = $this->input->post('id_rol');
      $correo = $this->input->post('correo');
      $telefono = $this->input->post('telefono');
      $uncode_password = $this->input->post('password1');
      $password = password_hash($uncode_password, PASSWORD_BCRYPT, ['cost' => 12]);
      $idUsuario = $this->input->post('id_usuario');
     


      $UsuariosPortal = array(
        'creacion' => $date,
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'id_rol' => $id_rol,
        'id_domicilios'=> null,
        
      
      );
      $DatosGenerales= array(
        'nombre' => $nombre,
        'paterno' => $paterno,
        'correo' => $correo,
        'password' => $password,
        'telefono' => $telefono,
      
      );

    
     $result = $this->cat_usuario_model->addUsuarioInterno($UsuariosPortal, $DatosGenerales);
    $envioCredenciales = $this->accesosUsuariosCorreo($correo, $uncode_password);

    

    
      if($result){
        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
          );
     }else{
      $msj = array(
        'codigo' => 0,
        'msg' => 'error'
        );
     }
         
    }
    echo json_encode($msj);
  }

  function actualizarPass(){
    $this->form_validation->set_rules('id', 'id', 'required');
    $this->form_validation->set_rules('correo', 'Correo', 'required');
    $this->form_validation->set_rules('pass', 'Contraseña', 'required');

    $this->form_validation->set_message('required','El campo %s es obligatorio');

    $msj = array();
    if ($this->form_validation->run() == FALSE) {
      $msj = array(
        'codigo' => 0,
        'msg' => validation_errors()
      );
    
    } 
    
    else {
     
      date_default_timezone_set('America/Mexico_City');
    
      $id = $this->input->post('id');
      $correo = $this->input->post('correo');
      $uncode_password = $this->input->post('pass');
      $password = password_hash($uncode_password, PASSWORD_BCRYPT, ['cost' => 12]);
  
    // var_dump($uncode_password);


      $DatosGenerales= array(
        'password' => $password,
      );

    
     $result = $this->cat_usuario_model->updatePass($id, $DatosGenerales, $uncode_password, $correo);
     

    

    
      if($result >  0){
        $msj = array(
          'codigo' => 1,
          'msg' => 'La nueva  contraseña  fue  enviada  a '.$correo
          );
     }else{
      $msj = array(
        'codigo' => 0,
        'msg' => 'No se pudo actualizar   la contraseña  pongase en contacto  con  soporte@portal.rodi.com.mx '
        );
     }
         
    }
    echo json_encode($msj);
  }

  /*********************************************************************************/
  function status() {
    $id_usuario = $this->session->userdata('id');
    $date = date('Y-m-d H:i:s');
    $idUsInterno = $this->input->post('id');
    $accion = $this->input->post('accion');

    if ($accion == "activar") {
        $usuario = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'status' => 1 // Cambia el estado a activo
        );
        $this->cat_usuario_model->editUsuario($idUsInterno, $usuario);

        $msj = array(
            'codigo' => 1,
            'msg' => 'Usuario activado correctamente'
        );
    } elseif ($accion == "desactivar") {
        $usuario = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'status' => 0 // Cambia el estado a inactivo
        );
        $this->cat_usuario_model->editUsuario($idUsInterno, $usuario);

        $msj = array(
            'codigo' => 1,
            'msg' => 'Usuario desactivado correctamente'
        );
    } elseif ($accion == "eliminar") {
        $usuario = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'eliminado' => 1
        );

        $this->cat_usuario_model->editUsuario($idUsInterno, $usuario);

        $msj = array(
            'codigo' => 1,
            'msg' => 'Usuario eliminado correctamente'
        );
    }

    echo json_encode($msj);
}
//__________________________________________________________________________________
   function getActivos(){
    $res = $this->cat_usuario_model->getActivos();
    if($res){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  } 

  function accesosUsuariosCorreo($correo, $pass, $soloPass = 0)
		{
				if ($correo === null || $correo === '') {
						return false;
				}
		
				$subject = "Credenciales Portal Rodi";
				// Cargar la vista email_verification_view.php
				$message = $this->load->view('catalogos/email_credenciales_view', ['correo' => $correo, 'pass'=>$pass, 'switch'=>$soloPass], true);
		
				$this->load->library('phpmailer_lib');
				$mail = $this->phpmailer_lib->load();
				$mail->isSMTP();
				$mail->Host = 'mail.rodicontrol.com';
				$mail->SMTPAuth = true;
				$mail->Username = 'soporte@portal.rodi.com.mx';
				$mail->Password = 'iU[A}vWg+JFiRxe+LK';
				$mail->SMTPSecure = 'ssl';
				$mail->Port = 465;
		
				if ($correo !== null && $correo !== '') {
						$mail->setFrom('soporte@portal.rodi.com.mx', 'RODICONTROL');
						$mail->addAddress($correo);
				} else {
						return false;
				}
		
				$mail->Subject = $subject;
				$mail->isHTML(true); // Enviar el correo como HTML
				$mail->CharSet = 'UTF-8'; // Establecer la codificación de caracteres UTF-8
				$mail->Body = $message;
		
				if ($mail->send()) {
						return true;
				} else {
					log_message('error', 'Error al enviar el correo: ' . $mail->ErrorInfo);
						return false;
				}
		}
  
  
}