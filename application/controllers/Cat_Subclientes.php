<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cat_Subclientes extends CI_Controller{

	function __construct(){
		parent::__construct();
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
    $datos['estados'] = $this->funciones_model->getEstados();
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
  function registrar(){
    $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim|is_unique[subcliente.nombre]');
    $this->form_validation->set_rules('clave', 'Clave', 'required|trim|max_length[3]|is_unique[subcliente.clave]');
    $this->form_validation->set_rules('cliente', 'Cliente', 'required');

    $this->form_validation->set_message('required','El campo %s es obligatorio');
    $this->form_validation->set_message('is_unique','El campo %s debe ser único');
    $this->form_validation->set_message('max_length','El campo %s debe tener máximo 3 carácteres');

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
      $subcliente = array(
          'creacion' => $date,
          'edicion' => $date,
          'id_usuario' => $id_usuario,
          'id_cliente' => $this->input->post('cliente'),
          'nombre' => mb_strtoupper($this->input->post('nombre')),
          'empresa' => mb_strtoupper($this->input->post('nombre')),
          'clave' => mb_strtoupper($this->input->post('clave')),
          'icono' => '<i class="fas fa-user-tie"></i>',
          'url' => "Cliente/subclientes"
      );
      $this->cat_subclientes_model->registrar($subcliente);
      $msj = array(
          'codigo' => 1,
          'msg' => 'success'
      );
    }
    echo json_encode($msj);
  }
  function editar(){
    $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim|is_unique[subcliente.nombre]');
    $this->form_validation->set_rules('clave', 'Clave', 'required|trim|max_length[3]|is_unique[subcliente.clave]');
    $this->form_validation->set_rules('cliente', 'Cliente', 'required');

    $this->form_validation->set_message('required','El campo %s es obligatorio');
    $this->form_validation->set_message('is_unique','El campo %s debe ser único');
    $this->form_validation->set_message('max_length','El campo %s debe tener máximo 3 carácteres');

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
        $subcliente = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'id_cliente' => $this->input->post('cliente'),
            'nombre' => mb_strtoupper($this->input->post('nombre')),
            'empresa' => mb_strtoupper($this->input->post('nombre')),
            'clave' => mb_strtoupper($this->input->post('clave')),
        );
        $this->cat_subclientes_model->editar($subcliente, $this->input->post('id'));
        $msj = array(
            'codigo' => 1,
            'msg' => 'success'
        );
    }
    echo json_encode($msj);
  }
  function registrarUsuario(){
    $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
    $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
    $this->form_validation->set_rules('correo', 'Correo', 'required|trim|valid_email|is_unique[usuario_cliente.correo]');
    $this->form_validation->set_rules('password', 'Contraseña', 'required|trim');
    $this->form_validation->set_rules('id_cliente', 'Cliente', 'required|trim');

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
        $idSubcliente = $this->input->post('id');
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
            $salida .= "<option value='".$row->id."'>".$row->nombre."</option>";
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
  function accion(){
    $id_usuario = $this->session->userdata('id');
    date_default_timezone_set('America/Mexico_City');
    $date = date('Y-m-d H:i:s');
    $idSubcliente = $this->input->post('id');
    $idUsuarioSubcliente = $this->input->post('id_usuario_subcliente');
    $accion = $this->input->post('accion');
    
    if($accion == "desactivar"){
        $subcliente = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'status' => 0
        );
        $this->cat_subclientes_model->editar($subcliente, $idSubcliente);
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
        $this->cat_subclientes_model->editar($subcliente, $idSubcliente);
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
        $this->cat_subclientes_model->editar($subcliente, $idSubcliente);
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