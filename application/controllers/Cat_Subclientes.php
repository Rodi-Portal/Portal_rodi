<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cat_Subclientes extends CI_Controller{

	function __construct(){
		parent::__construct();
    $this->load->model('Cat_subclientes_model'); // Asegúrate de que el nombre del modelo sea correcto

    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
  function index(){
    $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
    $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
    foreach($data['submodulos'] as $row) {
      $items[] = $row->id_submodulo;
    }
    $data['submenus'] = $items;
   
    $info['clientes'] = $this->funciones_model->getClientesActivos();
    $datos['modals'] = $this->load->view('modals/mdl_subclientes',$info, TRUE);
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
    ->view('catalogos/subcliente',$datos)
    ->view('adminpanel/footer');
  }
  function getSubclientes(){
    $subclientes['recordsTotal'] = $this->cat_subclientes_model->getTotal();
    $subclientes['recordsFiltered'] = $this->cat_subclientes_model->getTotal();
    $subclientes['data'] = $this->cat_subclientes_model->getSubclientes();
  
    $this->output->set_output( json_encode( $subclientes ) );

  }
  function getSubclientesAccesos(){
    $id_subcliente = $this->input->post('id_subcliente');
    $salida = "";
    $data['usuarios'] = $this->cat_subclientes_model->getAccesos($id_subcliente);
    if($data['usuarios']){
        $salida .= '<table class="table table-striped">';
        $salida .= '<thead>';
        $salida .= '<tr>';
        $salida .= '<th scope="col">Nombre</th>';
        $salida .= '<th scope="col">Correo</th>';
        $salida .= '<th scope="col">Alta</th>';
        $salida .= '<th scope="col">Usuario</th>';
        $salida .= '<th scope="col">Eliminar</th>';
        $salida .= '</tr>';
        $salida .= '</thead>';
        $salida .= '<tbody>';
        foreach($data['usuarios'] as $u){
            $fecha = fecha_sinhora_espanol_bd($u->alta);
            $salida .= "<tr id='".$u->idUsuarioSubcliente."'><th>".$u->usuario_subcliente."</th><th>".$u->correo_usuario."</th><th>".$fecha."</th><th>".$u->usuario."</th><th><a href='javascript:void(0)' class='fa-tooltip a-acciones' onclick='eliminarAcceso(".$u->idUsuarioSubcliente.")'><i class='fas fa-trash'></i></a></th></tr>";
        }
        $salida .= '</tbody>';
        $salida .= '</table>';
        echo $salida;
    }
    else{
        echo $salida .= '<p style="text-align:center; font-size: 20px;">No hay registro de accesos</p>';
    }
  }
  function registrarSubcliente(){
    $this->form_validation->set_rules('idCliente', 'Cliente', 'required');
    $this->form_validation->set_rules('nombreSubcliente', 'Nombre del subcliente', 'required|trim');
    $this->form_validation->set_rules('claveSubcliente', 'Clave', 'required|trim|max_length[3]');
    $this->form_validation->set_rules('nombreContacto', 'Nombre de contacto', 'trim');
    $this->form_validation->set_rules('apellidoContacto', 'Apellido de contacto', 'trim');
    $this->form_validation->set_rules('correo', 'Correo', 'trim|valid_email|trim|valid_email');
    $this->form_validation->set_rules('telefono', 'Teléfono', 'trim');
    $this->form_validation->set_rules('pais_name', 'País','trim');
    $this->form_validation->set_rules('state_name', 'Estado', 'trim');
    $this->form_validation->set_rules('ciudad_name', 'Ciudad', 'trim');
    $this->form_validation->set_rules('colonia', 'Colonia', 'trim');
    $this->form_validation->set_rules('calle', 'Calle', 'trim');
    $this->form_validation->set_rules('numero_exterior', 'Número Exterior', 'trim|numeric');
    $this->form_validation->set_rules('numero_interior', 'Número Interior', 'trim');
    $this->form_validation->set_rules('numero_cp', 'Código Postal', 'trim|numeric');
    
    // Mensajes de error personalizados
    $this->form_validation->set_message('required', 'El campo %s es obligatorio');
    $this->form_validation->set_message('max_length', 'El campo %s debe tener máximo 3 caracteres');
    $this->form_validation->set_message('valid_email', 'El campo %s debe ser un correo válido');
    $this->form_validation->set_message('numeric', 'El campo %s debe ser numérico');

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
      $datos_generales = array(
        'nombre' => ($this->input->post('nombreContacto') !== '') ? $this->input->post('nombreContacto') : null,
        'paterno' => ($this->input->post('apellidoContacto') !== '') ? $this->input->post('apellidoContacto') : null,
        'correo' => ($this->input->post('correo') !== '') ? $this->input->post('correo') : null,
        'telefono' => ($this->input->post('telefono') !== '') ? $this->input->post('telefono') : null
      );
    
    $datos_domicilios = array(
        'pais' => ($this->input->post('pais_name') !== '') ? $this->input->post('pais_name') : null,
        'estado' => ($this->input->post('state_name') !== '') ? $this->input->post('state_name') : null,
        'ciudad' => ($this->input->post('ciudad_name') !== '') ? $this->input->post('ciudad_name') : null,
        'colonia' => ($this->input->post('colonia') !== '') ? $this->input->post('colonia') : null,
        'calle' => ($this->input->post('calle') !== '') ? $this->input->post('calle') : null,
        'exterior' => ($this->input->post('numero_exterior') !== '') ? $this->input->post('numero_exterior') : null,
        'interior' => ($this->input->post('numero_interior') !== '') ? $this->input->post('numero_interior') : null,
        'cp' => ($this->input->post('numero_cp') !== '') ? $this->input->post('numero_cp') : null
      );
    
    $datos_factura = array(
        'razon_social' => ($this->input->post('razonSocial') !== '') ? $this->input->post('razonSocial') : null,
        'rfc' => ($this->input->post('rfc') !== '') ? $this->input->post('rfc') : null,
      );

      $datos_subcliente = array(
          'creacion' => $date,
          'edicion' => $date,
          'id_usuario' => $id_usuario,
          'id_portal' => $this->session->userdata('idPortal'),
          'id_cliente' => $this->input->post('idCliente'),
          'id_datos_generales' => null,
          'id_domicilios' => null,
          'id_datos_facturacion' => null,
          'nombre_subcliente' => $this->input->post('nombreSubcliente'),
          'clave_subcliente' => $this->input->post('claveSubcliente'),
          'icono' => '<i class="fas fa-user-tie"></i>',
          
      );
      $idCliente = $this->input->post('idCliente');
      $correo = $this->input->post('correo');
      $idGenerales = $this->input->post('idGenerales');
      $idSubCliente =$this->input->post('idSubCliente');

      $existe = $this->cat_subclientes_model->existe($this->input->post('nombreSubcliente'),$this->input->post('claveSubcliente'),$idSubCliente);
      //echo $existe." aqui esta  existe ";
      if($existe === 0){
      $hayId =  $this->cat_subclientes_model->check($idSubCliente);
     // echo "pasamos  a existe ";
        if($hayId > 0){
          $datos_subcliente = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_datos_generales' => $this->input->post('idGenerales'),
                'id_domicilios' => $this->input->post('idDomicilios'),
                'id_datos_facturacion' => $this->input->post('idFacturacion'),
          );
          $existeCorreo =  $this->generales_model->correoExiste($correo, $idGenerales);
          
          if ($existeCorreo !== 0) {
            $msj = array(
              'codigo' => 2,
              'msg' => 'El correo proporcionado ya existe'
            );
            echo json_encode($msj);
            return; // Detener el flujo del código ya que hay un error
          }
        /*var_dump($idSubCliente);
      var_dump($datos_subcliente);
      var_dump($datos_factura);
      var_dump($datos_domicilios);
      var_dump($datos_generales);*/
          $this->cat_subclientes_model->editSubcliente($idSubCliente, $datos_subcliente, $datos_factura, $datos_domicilios, $datos_generales );
        
          $msj = array(
            'codigo' => 1,
            'msg' => 'Sub-Cliente actualizado exitosamente'
          );
        }
        else{
         
      
          $existeCorreo =  $this->generales_model->correoExiste($correo);

          if ($existeCorreo !== 0) {
            $msj = array(
              'codigo' => 2,
              'msg' => 'El correo proporcionado ya existe'
            );
            echo json_encode($msj);
            return; // Detener el flujo del código ya que hay un error
          }
        
          $idSubCliente =  $this->cat_subclientes_model->addSubcliente($datos_subcliente, $datos_factura, $datos_domicilios, $datos_generales);
          //echo $idSubCliente."   este  es el id obtenido ";
          $url = "Cliente/subclientes".$idSubCliente;
          $data_url = array(
            'url' => $url
          );
          $this->cat_subclientes_model->editSubcliente($idSubCliente, $data_url );
          $msj = array(
            'codigo' => 1,
              'msg' => 'Subcliente Registrado con exito'
          );

        
        
       }
      
    }
      else{
      $msj = array(
        'codigo' => 2,
          'msg' => 'El nombre del cliente y/o clave ya existe'
      );
      }
    }
    echo json_encode($msj);
  }

  function registrarUsuario(){
    $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
    $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
    $this->form_validation->set_rules('correo', 'Correo', 'required|trim|valid_email|is_unique[datos_generales.correo]');
    $this->form_validation->set_rules('password', 'Contraseña', 'required|trim');
    $this->form_validation->set_rules('id_cliente', 'Cliente', 'required|trim');
    $this->form_validation->set_rules('id_subcliente', 'Subcliente', 'required');
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
        $correo = $this->input->post('correo');
        $uncode_password = $this->input->post('password');
        $base = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
        $password = md5($base.$uncode_password);
        $idSubcliente = $this->input->post('id_subcliente');
        $id_cliente = $this->input->post('id_cliente');
        
        $usuario = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'id_cliente' => $id_cliente,
            'id_subcliente' => $idSubcliente,
            'nombre' => $nombre,
            'paterno' => $paterno,
            'correo' => $correo,
            'password' => $password,
        );

        $this->cat_subclientes_model->registrarUsuario($usuario);
        $msj = array(
            'codigo' => 1,
            'msg' => 'success'
        );
    }
    echo json_encode($msj);
  }
  function getOpcionesSubclientes(){
    $id_cliente = $_POST['id_cliente'];
    $data['subclientes'] = $this->cat_subclientes_model->getOpcionesSubclientes($id_cliente);
    $salida = "<option value='' selected>Selecciona</option>";
    if($data['subclientes']){
        foreach ($data['subclientes'] as $row){
            $salida .= "<option value='".$row->id."'>".$row->nombre_subcliente."</option>";
        } 
        echo $salida;
    }
    else{
        echo $salida;
    }
  }
  function controlAcceso(){
    $id_usuario = $this->session->userdata('id');
    date_default_timezone_set('America/Mexico_City');
    $date = date('Y-m-d H:i:s');
    $idUsuarioSubcliente = $this->input->post('idUsuarioSubcliente');
    $activo = $this->input->post('activo');
    if($idUsuarioSubcliente != ""){
      if($activo != -1){
        $usuario = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'status' => $activo
        );
        $this->cat_subclientes_model->editarAcceso($usuario, $idUsuarioSubcliente);
        $msj = array(
            'codigo' => 1,
            'msg' => 'success'
        );
      }
      else{
        $this->cat_subclientes_model->deleteAcceso($idUsuarioSubcliente);
        $msj = array(
            'codigo' => 1,
            'msg' => 'success'
        );
      }
      echo json_encode($msj);
    }
  }
  function accionSubclientes(){
    $id_usuario = $this->session->userdata('id');
    date_default_timezone_set('America/Mexico_City');
    $date = date('Y-m-d H:i:s');
    $idSubcliente = $this->input->post('idSubcliente');
    $idUsuarioSubcliente = $this->input->post('id_usuario_subcliente');
    $accion = $this->input->post('accion');
    //echo "     estamos aqui     ". $accion."      esta  es la  accion ";
    if($accion == "desactivar"){
        $subcliente = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'status' => 0
        );
        $this->cat_subclientes_model->editSubcliente($idSubcliente, $subcliente);
        if($idUsuarioSubcliente != ""){
            $usuario = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'status' => 0
            );
            $this->cat_subclientes_model->editarAcceso($usuario, $idUsuarioSubcliente);
        }
         $msj = array(
            'codigo' => 1,
            'msg' => 'success'
        );
    }
    if($accion == "activar"){
        $subcliente = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'status' => 1
        );
        $this->cat_subclientes_model->editSubcliente($idSubcliente, $subcliente);
        if($idUsuarioSubcliente != ""){
            $usuario = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'status' => 1
            );
            $this->cat_subclientes_model->editarAcceso($usuario, $idUsuarioSubcliente);
        }
         $msj = array(
            'codigo' => 1,
            'msg' => 'success'
        );
    }
    if($accion == "eliminar"){
        $subcliente = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'eliminado' => 1
        );
        $this->cat_subclientes_model->editSubcliente($idSubcliente, $subcliente);
        if($idUsuarioSubcliente != ""){
            $usuario = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'eliminado' => 1
            );
            $this->cat_subclientes_model->editarAcceso($usuario, $idUsuarioSubcliente);
        }
         $msj = array(
            'codigo' => 1,
            'msg' => 'success'
        );
    }
    echo json_encode($msj);
  }
}