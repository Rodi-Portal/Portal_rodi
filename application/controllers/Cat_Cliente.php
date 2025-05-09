<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cat_Cliente extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('Login/index');
        }

        $this->load->library('usuario_sesion');

        $this->usuario_sesion->checkStatusBD();
        $this->load->helper('funciones_helper');
    }
    /*

    Esta  funcion sirve  para Insertar   o editar clientes  dentro de la misma,  al insertar  tambien crea

     */

    public function setCliente()
    {

        $idCliente = $this->input->post('idCliente');

        // Define la regla de validación con los parámetros como un arreglo
        $this->form_validation->set_rules('nombre', 'Nombre del sucursal', 'required');

        // Define las demás reglas de validación
        $this->form_validation->set_rules('clave', 'Clave', 'trim|required|max_length[3]');
        $this->form_validation->set_rules('correo', 'Correo', 'trim|valid_email');
        $this->form_validation->set_rules('password', 'Contraseña', 'trim');
        $this->form_validation->set_rules('empleados', 'Maximo empleados', 'trim');
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
        $this->form_validation->set_message('check_nombre_unique', 'El campo Nombre del sucursal ya existe en la base de datos.');

        // Validación de formulario
        $msj = array();
        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {

            $id_usuario = $this->session->userdata('id');
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');
            $uncode_password = $this->input->post('password');
            if (empty($uncode_password)) {
                // Genera una contraseña segura de 12 caracteres
                $uncode_password = bin2hex(random_bytes(12)); 
            }

            $password = password_hash($uncode_password, PASSWORD_BCRYPT);

            $datos_generales = array(
                'nombre' => ($this->input->post('nombre_contacto') !== '') ? $this->input->post('nombre_contacto') : null,
                'paterno' => ($this->input->post('apellido_contacto') !== '') ? $this->input->post('apellido_contacto') : null,
                'correo' => ($this->input->post('correo') !== '') ? $this->input->post('correo') : null,
                'telefono' => ($this->input->post('telefono') !== '') ? $this->input->post('telefono') : null,
                'password' => $password,
            );

            $datos_domicilios = array(
                'pais' => ($this->input->post('pais_name') !== '') ? $this->input->post('pais_name') : null,
                'estado' => ($this->input->post('state_name') !== '') ? $this->input->post('state_name') : null,
                'ciudad' => ($this->input->post('ciudad_name') !== '') ? $this->input->post('ciudad_name') : null,
                'colonia' => ($this->input->post('colonia') !== '') ? $this->input->post('colonia') : null,
                'calle' => ($this->input->post('calle') !== '') ? $this->input->post('calle') : null,
                'exterior' => ($this->input->post('numero_exterior') !== '') ? $this->input->post('numero_exterior') : null,
                'interior' => ($this->input->post('numero_interior') !== '') ? $this->input->post('numero_interior') : null,
                'cp' => ($this->input->post('numero_cp') !== '') ? $this->input->post('numero_cp') : null,
            );

            $datos_factura = array(
                'razon_social' => ($this->input->post('razon_social') !== '') ? $this->input->post('razon_social') : null,
                'rfc' => ($this->input->post('rfc') !== '') ? $this->input->post('rfc') : null,
                'regimen' => ($this->input->post('regimen') !== '') ? $this->input->post('regimen') : null,
                'forma_pago' => ($this->input->post('forma_pago') !== '') ? $this->input->post('forma_pago') : null,
                'metodo_pago' => ($this->input->post('metodo_pago') !== '') ? $this->input->post('metodo_pago') : null,
                'uso_cfdi' => ($this->input->post('uso_cfdi') !== '') ? $this->input->post('uso_cfdi') : null,
            );

            $datos_cliente = array(
                'creacion' => $date,
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_portal' => $this->session->userdata('idPortal'),
                'nombre' => strtoupper($this->input->post('nombre')),
                'clave' => $this->input->post('clave'),
                'max_colaboradores'=> $this->input->post('empleados'),
                'icono' => '<i class="fas fa-user-tie"></i>',
                'id_datos_generales' => null,
                'id_domicilios' => null,
                'id_datos_facturacion' => null,
            );

           /* echo '<pre>';
            print_r($datos_cliente);
            echo '</pre>';
            die();
            */
            $nombreCliente = $this->input->post('nombre');
            $claveCliente = $this->input->post('clave');
            $idCliente = $this->input->post('idCliente');

            $correo = $this->input->post('correo');
            $idGenerales = $this->input->post('idGenerales');

            $existe = $this->cat_cliente_model->existeCliente($this->input->post('nombre'), $this->input->post('clave'), $idCliente);
            
            if ($existe == 0) {
                $hayId = $this->cat_cliente_model->check($idCliente);
               
                if ($hayId > 0) {
                    $datos_cliente = array(
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'nombre' => strtoupper($this->input->post('nombre')),
                        'clave' => $this->input->post('clave'),
                        'max_colaboradores'=> $this->input->post('empleados'),
                        'id_datos_generales' => $this->input->post('idGenerales'),
                        'id_domicilios' => $this->input->post('idDomicilios'),
                        'id_datos_facturacion' => $this->input->post('idFacturacion'),
                    );

                    $existeCorreo = $this->generales_model->correoExiste($correo, $idGenerales);

                    if ($existeCorreo !== 0) {
                        $msj = array(
                            'codigo' => 2,
                            'msg' => 'El correo proporcionado ya existe',
                        );
                        echo json_encode($msj);
                        return; // Detener el flujo del código ya que hay un error
                    }
                    $this->cat_cliente_model->editCliente($idCliente, $datos_cliente, $datos_factura, $datos_domicilios, $datos_generales);
                    
                    $msj = array(
                        'codigo' => 1,
                        'msg' => 'sucursal actualizada exitosamente',
                    );
                    echo json_encode($msj);
                    return;
                } else {

                    $existeCorreo = $this->generales_model->correoExiste($correo);

                    if ($existeCorreo !== 0) {
                        $msj = array(
                            'codigo' => 2,
                            'msg' => 'El correo proporcionado ya existe',
                        );
                        echo json_encode($msj);
                        return; // Detener el flujo del código ya que hay un error
                    }

                    $idCliente = $this->cat_cliente_model->addCliente($datos_cliente, $datos_factura, $datos_domicilios, $datos_generales, $uncode_password );

                    if ($idCliente > 0) {

                        $msj = array(
                            'codigo' => 1,
                            'msg' => 'Sucursal registrado exitosamente,  se  enviaron   las  credenciales a ' . $correo,
                        );
                        echo json_encode($msj);
                        return;
                    } else {
                        $msj = array(
                            'codigo' => 0,
                            'msg' => 'Error  al registrar al sucursal',
                        );
                        echo json_encode($msj);
                        return;
                    }

                }

            } else {
                $msj = array(
                    'codigo' => 2,
                    'msg' => 'El nombre del sucursal y/o clave ya existe',
                );
            }
        }
        echo json_encode($msj);
    }

    public function index()
    {
        $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
        $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
        foreach ($data['submodulos'] as $row) {
            $items[] = $row->id_submodulo;
        }
        $data['submenus'] = $items;
        // $datos['estados'] = $this->funciones_model->getEstados();
        $datos['tipos_bloqueo'] = $this->funciones_model->getTiposBloqueo();
        $datos['tipos_desbloqueo'] = $this->funciones_model->getTiposDesbloqueo();
        $datos['modals'] = $this->load->view('modals/mdl_catalogos/mdl_cat_cliente', '', true);

        $config = $this->funciones_model->getConfiguraciones();
        $data['version'] = $config->version_sistema;

        //Modals
        $modales['modals'] = $this->load->view('modals/mdl_usuario', '', true);

        $notificaciones = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0, 1]);
        if (!empty($notificaciones)) {
            $contador = 0;
            foreach ($notificaciones as $row) {
                if ($row->visto == 0) {
                    $contador++;
                }
            }
            $data['contadorNotificaciones'] = $contador;
        }

        $this->load
            ->view('adminpanel/header', $data)
            ->view('adminpanel/scripts', $modales)
            ->view('catalogos/cliente', $datos)
            ->view('adminpanel/footer');
    }

    public function getClientes()
    {
        $portal = $this->session->userdata('idPortal');

        try {
            // Obtener el total de registros (recordsTotal)
            $recordsTotal = $this->cat_cliente_model->getTotal($portal);

            // Obtener el total de registros después de aplicar filtros (recordsFiltered)
            $recordsFiltered = $this->cat_cliente_model->getTotal($portal);

            // Obtener los datos de clientes (data)
            $data = $this->cat_cliente_model->getC();

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

    public function getClientesPorId()
    {
        $portal = $this->session->userdata('idPortal');
        $cliente_id = $this->input->get('cliente_id');

        try {
            // Obtener los datos de clientes (data)
            $data = $this->cat_cliente_model->getC($cliente_id);

            // Configurar el tipo de contenido de la respuesta como JSON
            $this->output->set_content_type('application/json');

            // Verificar si se encontraron datos de clientes
            if (!empty($data)) {
                // Construir la respuesta JSON
                $response = [
                    'success' => true,
                    'data' => $data,
                ];
            } else {
                // Construir la respuesta JSON si no se encontraron datos
                $response = [
                    'success' => false,
                    'message' => 'No se encontraron datos de sucursales.',
                ];
            }

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

// Funcion para registrar Clientes Julio  2024
    public function guardarDatos()
    {
       
        $this->form_validation->set_rules('razon_social', 'Razón Social', 'required');
        $this->form_validation->set_rules('telefono', 'Teléfono', 'required');
        $this->form_validation->set_rules('rfc', 'RFC', 'required');
        $this->form_validation->set_rules('regimen', 'Régimen', 'required');
        $this->form_validation->set_rules('forma_pago', 'Forma de Pago', 'required');
        $this->form_validation->set_rules('metodo_pago', 'Método de Pago', 'required');
        $this->form_validation->set_rules('uso_cfdi', 'Uso de CFDI', 'required');
        $this->form_validation->set_rules('pais_name', 'País', 'required');
        $this->form_validation->set_rules('state_name', 'Estado', 'required');
        $this->form_validation->set_rules('ciudad_name', 'Ciudad', 'required');
        $this->form_validation->set_rules('colonia', 'Colonia', 'required');
        $this->form_validation->set_rules('calle', 'Calle', 'required');
        $this->form_validation->set_rules('numero_exterior', 'Número Exterior', 'required');
        $this->form_validation->set_rules('numero_interior', 'Número Interior');
        $this->form_validation->set_rules('numero_cp', 'Código Postal', 'required');
        $this->form_validation->set_message('required', 'El campo %s es obligatorio');
        if ($this->form_validation->run() == false) {
            // Validación fallida

            $msj = array(
              'codigo' => 0,
              'msg' => validation_errors(),
          );
            echo json_encode($msj);
            return;
        }
        date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
        // Configuración de carga de archivo
        if (!empty($_FILES['archivo'])) {
          $error = 0;
          $rfc = $this->input->post('rfc');
         /* echo '<pre>';
          print_r($_FILES['archivo']);
          echo '</pre>';
          die();*/
                    // Define new $_FILES array - $_FILES['file']
                    $_FILES['file']['name'] = $_FILES['archivo']['name'];
                    $_FILES['file']['type'] = $_FILES['archivo']['type'];
                    $_FILES['file']['tmp_name'] = $_FILES['archivo']['tmp_name'];
                    $_FILES['file']['error'] = $_FILES['archivo']['error'];
                    $_FILES['file']['size'] = $_FILES['archivo']['size'];
                    // Set preference
                    $config['upload_path'] = './_const/';
                    $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                    $config['max_size'] = '2048'; // max_size in kb
                    $cadena = substr(md5(time()), 0, 16);
                    //$tipo = $this->candidato_model->getTipoDoc($tipo_documento);
                    //$tipoArchivo = str_replace(' ','',$tipo->nombre);
                    $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
                    $config['file_name'] =   $rfc.'_'.$cadena ;
                    $nombre_archivo =   $rfc.'_'.$cadena .'.'. $extension;
                    //Load upload library
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    // File upload
                    if (!$this->upload->do_upload('file')) {
                        $error++;
                       
                    } else {

                           // Get the uploaded file path
                      $uploaded_data = $this->upload->data();
                      $uploaded_file_path = $uploaded_data['full_path']; 
                      $idCliente = $this->input->post('idCliente');
                      
                      
                      $idGenerales = $this->input->post('idGenerales');
                      $nombre_cliente = $this->input->post('nombre');
                      $clave_cliente = $this->input->post('clave');
                      

                      $idDatosGenerales = $this->input->post('idGenerales');
                      $telefono = $this->input->post('telefono');
                      $nombre_contacto = $this->input->post('nombre_contacto');
                      $apellido_contacto = $this->input->post('apellido_contacto');


                      $idFacturacion = $this->input->post('idFacturacion');
                      $razon_social = $this->input->post('razon_social');
                      $rfc = $this->input->post('rfc');
                      $regimen = $this->input->post('regimen');
                      $forma_pago = $this->input->post('forma_pago');
                      $metodo_pago = $this->input->post('metodo_pago');
                      $uso_cfdi = $this->input->post('uso_cfdi');

                      $idDomicilios = $this->input->post('idDomicilios');
                      $pais = $this->input->post('pais_name');
                      $estado = $this->input->post('state_name');
                      $ciudad = $this->input->post('ciudad_name');
                      $colonia = $this->input->post('colonia');
                      $calle = $this->input->post('calle');
                      $numero_exterior = $this->input->post('numero_exterior');
                      $numero_interior = $this->input->post('numero_interior');
                      $cp = $this->input->post('numero_cp');


                      $dataClientes= array(
                        'edicion' => $date,
                        'constancia_cliente' => $nombre_archivo,
                        'id_datos_facturacion' =>$idFacturacion,
                        'id_domicilios' => $idDomicilios,
                        'id_datos_generales'=> $idDatosGenerales,

                      );

                      $dataFacturacion = array(
                        'razon_social'=> $razon_social,
                        'rfc'=> $rfc,
                        'regimen'=> $regimen,
                        'forma_pago'=> $forma_pago,
                        'metodo_pago'=> $metodo_pago,
                        'uso_cfdi'=> $uso_cfdi,

                      );

                      $dataDomicilios = array(
                        'pais'=> $pais,
                        'estado'=> $estado,
                        'ciudad'=> $ciudad,
                        'colonia'=> $colonia,
                        'calle'=> $calle,
                        'exterior'=> $numero_exterior,
                        'interior'=> $numero_interior,
                        'cp'=> $cp,

                      );

                      $dataGenerales = array(
                        'nombre'=> $nombre_contacto,
                        'paterno'=> $apellido_contacto,
                        'telefono'=> $telefono,                    
                      );

                      /* echo '<pre>';
                      print_r($dataGenerales);
                      echo '</pre>';
                      die();*/
                      
                      $result = $this->cat_cliente_model->editCliente($idCliente, $dataClientes, $dataFacturacion, $dataDomicilios, $dataGenerales);

                      if($result) {
                        $msj = array(
                          'codigo' => 1,
                          'msg' => 'Los  Datos  y  el archivo  fueron almacenados  correctamente :)',
                      );
                        echo json_encode($msj);
                        return;
                      

                      }else{

                        if ($uploaded_file_path && file_exists($uploaded_file_path)) {
                          unlink($uploaded_file_path);
                      }
                      $msj = array(
                          'codigo' => 2,
                          'msg' => 'Hubo un problema al actualizar los datos, por favor inténtalo nuevamente',
                      );
                      echo json_encode($msj);
                      return;
                  }
                  
                      
              }
              
            if ($error == 0) {
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'Success',
                );

            } else {
                $msj = array(
                    'codigo' => 0,
                    'msg' => 'Error  al   cargar  el archivo  intentalo nuevamente  x.x ',
                );
            }

        } else {
            $msj = array(
                'codigo' => 0,
                'msg' => 'Por  favor   sube  tu archivo en el apartado  correspondiente ',
            );

        }

        // Datos del formulario
       

        echo json_encode($msj);
        return;
        // Guardar los datos en la base de datos

    }

    public function status()
    {
        $msj = array();
        $id_usuario = $this->session->userdata('id');
        $date = date('Y-m-d H:i:s');
        $idCliente = $this->input->post('idCliente');
        $accion = $this->input->post('accion');

        // var_dump("esta es la accion :  ".$accion."  Este es el id del cliente :  ".$idCliente);
        if ($accion == "desactivar") {
            $cliente = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'status' => 0,
            );
            $this->cat_cliente_model->editCliente($idCliente, $cliente);
            $this->cat_cliente_model->editAccesoUsuarioCliente($idCliente, $cliente);
            $this->cat_cliente_model->editAccesoUsuarioSubcliente($idCliente, $cliente);
            $msj = array(
                'codigo' => 1,
                'msg' => 'Sucursal inactivado correctamente',
            );
        }

        if ($accion == "activar") {
            $cliente = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'status' => 1,
            );
            $this->cat_cliente_model->editCliente($idCliente, $cliente);
            $this->cat_cliente_model->editAccesoUsuarioCliente($idCliente, $cliente);
            $this->cat_cliente_model->editAccesoUsuarioSubcliente($idCliente, $cliente);

            $msj = array(
                'codigo' => 1,
                'msg' => 'Sucursal activado correctamente',
            );
        }
        if ($accion == "eliminar") {

            $cliente = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'eliminado' => 1,
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
            $this->cat_cliente_model->editCliente($idCliente, $cliente);
            $this->cat_cliente_model->editAccesoUsuarioCliente($idCliente, $cliente);
            $this->cat_cliente_model->editAccesoUsuarioSubcliente($idCliente, $cliente);
            $msj = array(
                'codigo' => 1,
                'msg' => 'Sucursal eliminado correctamente',
            );
        }

        if ($accion == "bloquear") {
            $cliente = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'bloqueado' => $this->input->post('opcion_motivo'),
            );
            $this->cat_cliente_model->editCliente($idCliente, $cliente);

            if ($this->input->post('bloquear_subclientes') === 'SI') {
                $data['subclientes'] = $this->subcliente_model->getSubclientesByIdCliente($idCliente);
                if ($data['subclientes']) {
                    foreach ($data['subclientes'] as $row) {
                        $subcliente = array(
                            'edicion' => $date,
                            'id_usuario' => $id_usuario,
                            'bloqueado' => $this->input->post('opcion_motivo'),
                        );
                        $this->cat_subclientes_model->editar($subcliente, $row->id);
                        unset($subcliente);
                    }
                }
            }

            $dataBloqueos = array(
                'status' => 0,
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
                'msg' => 'Sucursal bloqueado correctamente',
            );
        }

        if ($accion == "desbloquear") {
            $cliente = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'bloqueado' => 'NO',
            );
            $this->cat_cliente_model->editCliente($idCliente, $cliente);

            $data['subclientes'] = $this->subcliente_model->getSubclientesByIdCliente($idCliente);
            if ($data['subclientes']) {
                foreach ($data['subclientes'] as $row) {
                    $subcliente = array(
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'bloqueado' => 'NO',
                    );
                    $this->cat_subclientes_model->editarSubcliente($row->id, $subcliente);
                    unset($subcliente);
                }
            }

            $dataBloqueos = array(
                'status' => 0,
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
                'msg' => 'Sucursal desbloqueado correctamente',
            );
        }

        echo json_encode($msj);
    }

    public function getClientesActivos()
    {
        $res = $this->cat_cliente_model->getClientesActivosModel();
        if ($res) {
            echo json_encode($res);
        } else {
            echo $res = 0;
        }
    }

    public function getDatosClientesActivos()
    {
        // Obtener el ID del cliente enviado por la solicitud AJAX
        $cliente_id = $this->input->get('cliente_id');

        // Realizar la lógica para obtener los datos del cliente según su ID
        // Por ejemplo, puedes hacer una consulta a la base de datos
        // Aquí asumiremos que tienes un modelo llamado "Cliente_model" que maneja la lógica de la base de datos
        $this->load->model('Cliente_model');
        $clienteData = $this->Cliente_model->obtenerClientePorId($cliente_id);

        // Verificar si se encontraron datos del cliente
        if ($clienteData) {
            // Preparar los datos del cliente para enviarlos como respuesta
            $response = array(
                'success' => true,
                'data' => $clienteData,
            );
        } else {
            // Si no se encontraron datos del cliente, enviar un mensaje de error
            $response = array(
                'success' => false,
                'error' => 'No se encontraron datos para el cliente seleccionado.',
            );
        }

        // Devolver la respuesta en formato JSON
        echo json_encode($response);
    }

    public function addUsuarioCliente()
    {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
        $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
        $this->form_validation->set_rules('cliente', 'Sucursal', 'required|trim');

        $this->form_validation->set_rules('correo_cliente_name', 'Correo', 'required|trim|valid_email|is_unique[datos_generales.correo]');
        $this->form_validation->set_rules('password_name', 'Contraseña', 'required|trim');

        $this->form_validation->set_message('required', 'El campo %s es obligatorio');
        $this->form_validation->set_message('is_unique', 'El %s ya esta registrado');
        $this->form_validation->set_message('valid_email', 'El campo %s debe ser un correo válido');
        $msj = array();
        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
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
                'espectador' => $espectador,
                'privacidad' => $privacidad,
            );
            $usuarioClienteDatos = array(

                'telefono' => $telefono,
                'nombre' => $nombre,
                'paterno' => $paterno,
                'correo' => $correo,
                'password' => $hashed_password,

            );

            $this->cat_cliente_model->addUsuarioClienteModel($usuarioCliente, $usuarioClienteDatos);

            $dataCliente = $this->cat_cliente_model->getById($idCliente);
            if ($dataCliente->ingles == 1) {
                $existe_cliente = $this->cat_cliente_model->checkPermisosByCliente($idCliente);
                if ($existe_cliente == 0) {
                    $url = "Cliente_General/index/" . $idCliente;
                    $cliente = array(
                        'url' => $url,
                    );
                    $this->cat_cliente_model->editCliente($idCliente, $cliente);
                    $permiso = array(
                        'id_usuario' => $id_usuario,
                        'cliente' => $dataCliente->nombre,
                        'id_cliente' => $idCliente,
                    );
                    $this->cat_cliente_model->addPermiso($permiso);
                }
            }
            $msj = array(
                'codigo' => 1,
                'msg' => 'success',
            );
        }
        echo json_encode($msj);
    }

    public function getClientesAccesos()
    {

        $id_cliente = $this->input->post('id_cliente');
        $id_portal = $this->generales_model->getPortalCliente($id_cliente);
        // var_dump("Este  es el id del cliente: ".$id_cliente."Este  es el id del portal: ".$id_portal);
        $res = $this->cat_cliente_model->getAccesosClienteModal($id_cliente, $id_portal);
        if ($res) {
            echo json_encode($res);
        } else {
            echo json_encode([]);
        }
    }

    public function controlAcceso()
    {
        $id_usuario = $this->session->userdata('id');
        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $idUsuarioCliente = $this->input->post('idUsuarioCliente');
        $accion = $this->input->post('accion');

        if ($accion == 'eliminar') {
            $this->cat_cliente_model->deleteAccesoUsuarioCliente($idUsuarioCliente);
            $msj = array(
                'codigo' => 1,
                'msg' => 'Usuario eliminado correctamente',
            );
        }
        if ($accion == 'credenciales') {
            $this->generales_model->editDatosGenerales();
            $msj = array(
                'codigo' => 1,
                'msg' => 'Usuario eliminado correctamente',
            );
        }

        echo json_encode($msj);
    }

}