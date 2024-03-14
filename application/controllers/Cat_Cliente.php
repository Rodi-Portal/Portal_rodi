<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'libraries/custom_validation_rules.php');


class Cat_Cliente extends CI_Controller{

	function __construct(){
		parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
    
		$this->load->library('custom_validation_rules');
    $this->load->library('usuario_sesion');

		$this->usuario_sesion->checkStatusBD();
	}
  
  function set() {
  
    $idCliente = $this->input->post('idCliente');

    // Define la regla de validación con los parámetros como un arreglo
    $this->form_validation->set_rules('nombre', 'Nombre del Cliente', 'required');
    
    // Define las demás reglas de validación
    $this->form_validation->set_rules('clave', 'Clave', 'trim|required|max_length[3]');
    $this->form_validation->set_rules('pais_name', 'País', 'trim');
    $this->form_validation->set_rules('state_name', 'Estado', 'trim');
    $this->form_validation->set_rules('ciudad_name', 'Ciudad', 'trim');
    $this->form_validation->set_rules('colonia', 'Colonia', 'trim');
    $this->form_validation->set_rules('calle', 'Calle', 'trim');
    $this->form_validation->set_rules('numero_exterior', 'Número Exterior', 'trim');
    $this->form_validation->set_rules('numero_interior', 'Número Interior', 'trim');
    $this->form_validation->set_rules('numero_cp', 'Codigo Postal', 'trim|max_length[5]');
    $this->form_validation->set_rules('razon_social', 'Razón Social', 'trim');
    $this->form_validation->set_rules('telefono', 'Teléfono', 'trim');
    $this->form_validation->set_rules('correo', 'Correo', 'trim|valid_email');
    $this->form_validation->set_rules('nombre_contacto', 'Nombre de Contacto', 'trim');
    $this->form_validation->set_rules('apellido_contacto', 'Apellido de Contacto', 'trim');
    $this->form_validation->set_rules('rfc', 'RFC', 'trim');
    $this->form_validation->set_rules('regimen', 'Régimen', 'trim');
    $this->form_validation->set_rules('forma_pago', 'Forma de Pago', 'trim');
    $this->form_validation->set_rules('metodo_pago', 'Método de Pago', 'trim');
    $this->form_validation->set_rules('uso_cfdi', 'Uso de CFDI', 'trim');

    // Define los mensajes de error personalizados
    $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
    $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} caracteres.');
    $this->form_validation->set_message('check_nombre_unique', 'El campo Nombre del cliente ya existe en la base de datos.');

    // Validación de formulario
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
        'nombre' => $this->input->post('nombre_contacto') ?? null,
        'paterno' => $this->input->post('apellido_contacto') ?? null,
        'correo' => $this->input->post('correo') ?? null,
        'telefono' => $this->input->post('telefono') ?? null
    );

    $datos_domicilios = array(
        'pais' => $this->input->post('pais_name') ?: null,
        'estado' => $this->input->post('state_name') ?: null,
        'ciudad' => $this->input->post('ciudad_name') ?: null,
        'colonia' => $this->input->post('colonia') ?: null,
        'calle' => $this->input->post('calle') ?: null,
        'exterior' => $this->input->post('numero_exterior') ?: null,
        'interior' => $this->input->post('numero_interior') ?: null,
        'cp' => $this->input->post('numero_cp') ?: null
    );

    $datos_factura = array(
        'razon_social' => $this->input->post('razon_social') ?: null,
        'rfc' => $this->input->post('rfc') ?: null,
        'regimen' => $this->input->post('regimen') ?: null,
        'forma_pago' => $this->input->post('forma_pago') ?: null,
        'metodo_pago' => $this->input->post('metodo_pago') ?: null,
        'uso_cfdi' => $this->input->post('uso_cfdi') ?: null
    );

    $datos_cliente = array(
        'creacion' => $date,
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'id_portal' => $this->session->userdata('idPortal'),
        'nombre' => strtoupper($this->input->post('nombre')),
        'clave' => $this->input->post('clave'),
        'icono' => '<i class="fas fa-user-tie"></i>',
        'id_datos_generales' => null,
        'id_domicilios' => null,
        'id_datos_facturacion' => null
    );

    $idCliente = $this->input->post('idCliente');




    $existe = $this->cat_cliente_model->existe($this->input->post('nombre'),$this->input->post('clave'),$idCliente);
      if($existe ==0){
      $hayId = $this->cat_cliente_model->check($idCliente);
        if($hayId > 0){
            $datos_cliente = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_datos_generales' => $this->input->post('idGenerales'),
                'id_domicilios' => $this->input->post('idDomicilios'),
                'id_datos_facturacion' => $this->input->post('idFacturacion'),
            );
          
          $this->cat_cliente_model->editCliente($idCliente, $datos_cliente, $datos_factura, $datos_domicilios, $datos_generales, );
          $permiso = array(
            'id_usuario' => $id_usuario,
            'cliente' => $this->input->post('nombre')
          );
          $this->cat_cliente_model->editPermiso($permiso, $this->input->post('id'));
          $msj = array(
            'codigo' => 1,
            'msg' => 'success'
          );
        }
        else{
          $correo = $this->input->post('correo');
      
          $existeCorreo =  $this->generales_model->correoExiste($correo);

          if ($existeCorreo !== 0) {
            $msj = array(
              'codigo' => 2,
              'msg' => 'El correo proporcionado ya existe'
            );
            echo json_encode($msj);
            return; // Detener el flujo del código ya que hay un error
        }
        
          $idCliente = $this->cat_cliente_model->addCliente($datos_cliente, $datos_factura, $datos_domicilios, $datos_generales);

          $url = "Cliente_General/index/".$idCliente;
          $data_url = array(
            'url' => $url
          );
          $this->cat_cliente_model->editCliente($idCliente, $data_url );

          $permiso = array(
            'id_usuario' => $id_usuario,
            'id_cliente' => $idCliente,
            'cliente' => strtoupper($this->input->post('nombre')),
          );
          $this->cat_cliente_model->addPermiso($permiso);
          $msj = array(
            'codigo' => 1,
            'msg' => 'success'
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
  function index(){
    $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
    $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
    foreach($data['submodulos'] as $row) {
      $items[] = $row->id_submodulo;
    }
    $data['submenus'] = $items;
   // $datos['estados'] = $this->funciones_model->getEstados();
    $datos['tipos_bloqueo'] = $this->funciones_model->getTiposBloqueo();
    $datos['tipos_desbloqueo'] = $this->funciones_model->getTiposDesbloqueo();
    $datos['modals'] = $this->load->view('modals/mdl_catalogos/mdl_cat_cliente','', TRUE);

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
    ->view('catalogos/cliente',$datos)
    ->view('adminpanel/footer');
  }

  function getClientes(){
    $portal = $this->session->userdata('idPortal');

    try {
        // Obtener el total de registros (recordsTotal)
        $recordsTotal = $this->cat_cliente_model->getTotal($portal);

        // Obtener el total de registros después de aplicar filtros (recordsFiltered)
        $recordsFiltered = $this->cat_cliente_model->getTotal($portal);

        // Obtener los datos de clientes (data)
        $data = $this->cat_cliente_model->getC($portal);

        // Configurar el tipo de contenido de la respuesta como JSON
        $this->output->set_content_type('application/json');

        // Construir la respuesta JSON
        $response = [
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ];

        // Enviar la respuesta JSON
        $this->output->set_output(json_encode($response));
    } catch (Exception $e) {
        log_message('error', 'Excepción en la función getClientes: ' . $e->getMessage());

        // Configurar el tipo de contenido de la respuesta como JSON
        $this->output->set_content_type('application/json');

        // Enviar una respuesta JSON de error
        $this->output->set_output(json_encode(['error' => 'Error en la consulta.']));
    }
  }


// Funcion para registrar Clientes



  function status(){
    $msj = array();
    $id_usuario = $this->session->userdata('id');
    $date = date('Y-m-d H:i:s');
    $idCliente = $this->input->post('idCliente');
    $accion = $this->input->post('accion');

   // var_dump("esta es la accion :  ".$accion."  Este es el id del cliente :  ".$idCliente);
    if($accion == "desactivar"){
      $cliente = array(
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'status' => 0
      );
      $this->cat_cliente_model->editCliente($idCliente, $cliente );
      $this->cat_cliente_model->editAccesoUsuarioCliente($idCliente, $cliente );
      $this->cat_cliente_model->editAccesoUsuarioSubcliente($idCliente, $cliente);
      $msj = array(
        'codigo' => 1,
        'msg' => 'Cliente inactivado correctamente'
      );
    }

    if($accion == "activar"){
      $cliente = array(
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'status' => 1
      );
      $this->cat_cliente_model->editCliente($idCliente, $cliente );
      $this->cat_cliente_model->editAccesoUsuarioCliente($idCliente, $cliente );
      $this->cat_cliente_model->editAccesoUsuarioSubcliente($idCliente, $cliente);

      $msj = array(
        'codigo' => 1,
        'msg' => 'Cliente activado correctamente'
      );
    }
    if($accion == "eliminar"){

      $cliente = array(
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'eliminado' => 1
      ); 
      /*
      // ver  que traen las variables
      echo "usuarioCliente: ";
      print_r($idCliente);
      echo "<br>";
  
      echo "usuarioClienteDatos: ";
      print_r($data);
      echo "<br>";
      */
      $this->cat_cliente_model->editCliente($idCliente, $cliente );
      $this->cat_cliente_model->editAccesoUsuarioCliente($idCliente, $cliente );
      $this->cat_cliente_model->editAccesoUsuarioSubcliente($idCliente, $cliente);
      $msj = array(
        'codigo' => 1,
        'msg' => 'Cliente eliminado correctamente'
      );
    }


    if($accion == "bloquear"){
      $cliente = array(
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'bloqueado' => $this->input->post('opcion_motivo')
      );
      $this->cat_cliente_model->editCliente($idCliente, $cliente );

      if($this->input->post('bloquear_subclientes') === 'SI'){
        $data['subclientes'] = $this->cat_subclientes_model->getSubclientesByIdCliente($idCliente);
        if($data['subclientes']){
          foreach($data['subclientes'] as $row){
            $subcliente = array(
              'edicion' => $date,
              'id_usuario' => $id_usuario,
              'bloqueado' => $this->input->post('opcion_motivo')
            );
            $this->cat_subclientes_model->editar($subcliente, $row->id);
            unset($subcliente);
          }
        }
      }
      
      $dataBloqueos = array(
        'status' => 0
      );
      $this->cat_cliente_model->editHistorialBloqueos($dataBloqueos, $idCliente);


      $data_bloqueo = array(
        'creacion' => $date,
        'id_usuario' => $id_usuario,
        'descripcion' => $this->input->post('opcion_descripcion'),
        'id_cliente' => $idCliente,
        'bloqueo_subclientes' => $this->input->post('bloquear_subclientes'),
        'tipo' => 'BLOQUEO',
        'mensaje' => $this->input->post('mensaje_comentario'),
      );
      $this->cat_cliente_model->addHistorialBloqueos($data_bloqueo);
      $msj = array(
        'codigo' => 1,
        'msg' => 'Cliente bloqueado correctamente'
      );
    }

    if($accion == "desbloquear"){
      $cliente = array(
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'bloqueado' => 'NO'
      );
      $this->cat_cliente_model->editCliente( $idCliente, $cliente);

      $data['subclientes'] = $this->cat_subclientes_model->getSubclientesByIdCliente($idCliente);
      if($data['subclientes']){
        foreach($data['subclientes'] as $row){
          $subcliente = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'bloqueado' => 'NO'
          );
          $this->cat_subclientes_model->editar($subcliente, $row->id);
          unset($subcliente);
        }
      }
      
      $dataBloqueos = array(
        'status' => 0
      );
      $this->cat_cliente_model->editHistorialBloqueos($dataBloqueos, $idCliente);

      $data_bloqueo = array(
        'creacion' => $date,
        'id_usuario' => $id_usuario,
        'descripcion' => $this->input->post('opcion_descripcion'),
        'id_cliente' => $idCliente,
        'bloqueo_subclientes' => 'NO',
        'tipo' => 'DESBLOQUEO',
        'status' => 0,
      );
      $this->cat_cliente_model->addHistorialBloqueos($data_bloqueo);
      $msj = array(
        'codigo' => 1,
        'msg' => 'Cliente desbloqueado correctamente'
      );
    }

    echo json_encode($msj);
  }

  function getClientesActivos(){
    $res = $this->cat_cliente_model->getClientesActivosModel();
    if($res){
      echo json_encode($res);
    }
    else{
      echo $res = 0;
    }
  }

  function addUsuarioCliente(){
    $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
    $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
    $this->form_validation->set_rules('cliente', 'Cliente', 'required|trim');
 
    $this->form_validation->set_rules('correo_cliente_name', 'Correo', 'required|trim|valid_email|is_unique[usuario_cliente.correo]');
    $this->form_validation->set_rules('password_name', 'Contraseña', 'required|trim');

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
      $telefono = ($this->input->post('telefono') !== null) ? $this->input->post('telefono') : null;
      $privacidad = $this->input->post('privacidad');
      $correo = $this->input->post('correo_cliente_name');
      $uncode_password = $this->input->post('password_name');
      $hashed_password = password_hash($uncode_password, PASSWORD_BCRYPT);
    
      $idCliente = $this->input->post('cliente');
      $espectador = $this->input->post('tipo_usuario');
      
      $usuarioCliente = array(
        'creacion' => $date,
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'id_cliente' => $idCliente,
        'id_datos_generales' => null,
        'espectador'=> $espectador,
        'privacidad' => $privacidad
      );
      $usuarioClienteDatos = array(
       
        'telefono'=> $telefono,
        'nombre' => $nombre,
        'paterno' => $paterno,
        'correo' => $correo,
        'password' => $hashed_password,
      
      );

     
      $this->cat_cliente_model->addUsuarioClienteModel($usuarioCliente, $usuarioClienteDatos);

      $dataCliente = $this->cat_cliente_model->getById($idCliente);
      if($dataCliente->ingles == 1){
        $existe_cliente = $this->cat_cliente_model->checkPermisosByCliente($idCliente);
        if($existe_cliente == 0){
          $url = "Cliente_General/index/".$idCliente;
          $cliente = array(
            'url' => $url
          );
          $this->cat_cliente_model->edit($cliente, $idCliente);
          $permiso = array(
            'id_usuario' => $id_usuario,
            'cliente' => $dataCliente->nombre,
            'id_cliente' => $idCliente
          );
          $this->cat_cliente_model->addPermiso($permiso);
        }
      }
      $msj = array(
        'codigo' => 1,
        'msg' => 'success'
      );
    }
    echo json_encode($msj);
  }


  function getClientesAccesos(){
   
    $id_cliente = $this->input->post('id_cliente');
    $id_portal = $this->generales_model->getPortalCliente($id_cliente);
   // var_dump("Este  es el id del cliente: ".$id_cliente."Este  es el id del portal: ".$id_portal);
    $res = $this->cat_cliente_model->getAccesosClienteModal($id_cliente, $id_portal);
    if($res){
      echo json_encode($res);
    }
    else{
      echo json_encode([]);
    }
  }

  function controlAcceso(){
    $id_usuario = $this->session->userdata('id');
    date_default_timezone_set('America/Mexico_City');
    $date = date('Y-m-d H:i:s');
    $idUsuarioCliente = $this->input->post('idUsuarioCliente');
    $accion = $this->input->post('accion');

    if($accion == 'eliminar'){
      $this->cat_cliente_model->deleteAccesoUsuarioCliente($idUsuarioCliente);
      $msj = array(
        'codigo' => 1,
        'msg' => 'Usuario eliminado correctamente'
      );
    }
    
    echo json_encode($msj);
  }
  
}