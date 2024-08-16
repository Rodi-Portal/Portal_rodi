<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cat_portales_model extends CI_Model{

  function getTotal() {
    try {
        $this->db
            ->select("P.id")
            ->from('portal as P')
            ->where('P.status', 1);

        // Imprimir la consulta SQL generada
        $sql = $this->db->get_compiled_select();
        echo "<pre>$sql</pre>";

        $query = $this->db->get();

        // Verifica errores de la base de datos
        $db_error = $this->db->error();
        if (!empty($db_error['message'])) {
            log_message('error', 'Error en getTotal: ' . $db_error['message']);
            return 0;
        }

        // Devuelve el número de filas
        return $query->num_rows();
    } catch (Exception $e) {
        log_message('error', 'Excepción en getTotal: ' . $e->getMessage());
        return 0;
    }
}


function getClienteValido() {
    // Obtén el valor del portal desde la sesión
    $id_cliente = $this->session->userdata('idcliente');
    $portal = $this->session->userdata('idPortal');

    try {
        // Construye la consulta
        $this->db->select("
            C.nombre,
            C.clave,
            C.icono,
            C.constancia_cliente,
            C.id AS idCliente,
            C.id_datos_facturacion AS dFac,
            C.id_domicilios AS dDom,
            C.id_datos_generales AS dGen,
            DG.nombre AS nombre_contacto,
            DG.paterno AS apellido_contacto,
            DG.correo AS correo_contacto,
            DG.telefono AS telefono_contacto,
            D.pais,
            D.estado,
            D.ciudad,
            D.colonia,
            D.calle,
            D.exterior,
            D.cp,
            F.rfc,
            F.razon_social,
            F.regimen,
            F.forma_pago,
            F.metodo_pago,
            F.uso_cfdi
        ")
        ->from('cliente AS C')
        ->join('datos_generales AS DG', 'C.id_datos_generales = DG.id')
        ->join('domicilios AS D', 'C.id_domicilios = D.id')
        ->join('datos_facturacion AS F', 'C.id_datos_facturacion = F.id')
        ->where('C.id_portal', $portal)
        ->where('C.eliminado', 0)
        ->where('C.id', $id_cliente);

        // Ejecuta la consulta
        $query = $this->db->get();

        // Muestra la consulta SQL generada para depuración
        

        // Devuelve los resultados si existen
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }

    } catch (Exception $e) {
        // Registra y maneja cualquier excepción
        log_message('error', 'Excepción en la consulta: ' . $e->getMessage());
        return [];
    }
}
function getP() {
  try {
      $this->db->select("
          P.id AS idPortal,
          P.cons AS constancia,
          P.nombre, 
          P.status, 
          P.descripcion, 
          P.creacion, 
          P.usuarios_permitidos,
          P.id_usuario_portal,
          F.id AS idFac,
          F.razon_social,
          F.rfc,
          F.uso_cfdi,
          F.regimen as regimen1,
          F.forma_pago, 
          F.metodo_pago,
          D.id AS idDom,
          D.pais,
          D.estado,
          D.ciudad,
          D.colonia,
          D.calle,
          D.exterior,
          D.interior,
          D.cp,
          (SELECT COUNT(id) FROM usuarios_portal WHERE id_portal = P.id) AS numero_usuarios_portal,
          DGU.nombre AS nombre_usuario_portal,
          DGU.paterno AS apellido_usuario_portal,
          DGU.correo AS correo_usuario_portal,
          DGU.telefono AS telefono_usuario_portal")
          ->from('portal AS P')
          ->join("usuarios_portal AS UP", "P.id_usuario_portal = UP.id", 'left')
          ->join("datos_generales AS DGU", "UP.id_datos_generales = DGU.id", 'left')
          ->join("domicilios AS D", "P.id_domicilios = D.id", 'left')
          ->join("datos_facturacion AS F", "P.id_datos_facturacion = F.id", 'left')
          ->where('P.status', 1);

      // Imprimir la consulta SQL generada
      $sql = $this->db->get_compiled_select();
      echo "<pre>$sql</pre>";

      // Ejecutar la consulta
      $query = $this->db->get();

      // Verifica errores de la base de datos
      $db_error = $this->db->error();
      if (!empty($db_error['message'])) {
          log_message('error', 'Error en la consulta: ' . $db_error['message']);
          return [];
      }

      // Verifica si se obtuvieron resultados
      if ($query->num_rows() > 0) {
          return $query->result();
      } else {
          return [];
      }
  } catch (Exception $e) {
      log_message('error', 'Excepción en la consulta: ' . $e->getMessage());
      return [];
  }
}



function existePortal($nombre){

    //echo " nombre: ". $nombre. " Clave: ". $clave.  "  ID: ". $id;
    //die();
    $this->db
      ->select('*')
      ->from('portal')
      ->where('nombre', $nombre);
     
     
    
    $query = $this->db->get();
    // Loguear la consulta SQL generada

   
    log_message('info', 'Consulta SQL en existe: ' . $this->db->last_query());
    return $query->num_rows();
}

function check($id){
    $this->db
      ->select('id')
      ->from('portal')
      ->where('id', $id);
    
    $query = $this->db->get();
    // Loguear la consulta SQL generada
    log_message('info', 'Consulta SQL en check: ' . $this->db->last_query());
    return $query->num_rows();
}

function addPortal($portal, $datosFacturacion, $datosDomicilios, $datosGenerales, $uncode_password) {
    try {
        // Iniciar la transacción
        $this->db->trans_start();

        // Agregar los datos generales y obtener el ID
        $id_datosGenerales = $this->generales_model->addDatosGenerales($datosGenerales);

        // Agregar los domicilios y obtener el ID
        $id_domicilios = $this->generales_model->addDomicilios($datosDomicilios);

        // Agregar los datos de facturación y obtener el ID
        $id_datosFacturacion = $this->generales_model->addDatosFacturacion($datosFacturacion);

        // Asignar los IDs obtenidos al portal
        $portal['id_domicilios'] = $id_domicilios;
        $portal['id_datos_facturacion'] = $id_datosFacturacion;

        // Insertar el portal en la tabla correspondiente
        $this->db->insert("portal", $portal);
        $idPortal= $this->db->insert_id();

        // Crear usuario del portal
        $usuario_portal = [
            'id_portal' => $idPortal,
            'creacion' => $portal['creacion'],
            'edicion' => $portal['creacion'],
            'id_usuario' => $portal['id_usuario'],
            'id_datos_generales' => $id_datosGenerales,
            'id_domicilios' => null,
            'id_rol'=> 6,
        ];
        $this->db->insert("usuarios_portal", $usuario_portal);
        $isUsuarioPortal= $this->db->insert_id();
        
        $data_portal =  array(
          'id_usuario_portal' => $isUsuarioPortal,
        );

        $this->editPortal($idPortal, $data_portal);

        // Verificar si la transacción fue exitosa
        if ($this->db->trans_status() === false) {
            // Ocurrió un error durante la transacción, revertir los cambios
            $this->db->trans_rollback();
            return false;
        }

        // La transacción fue exitosa, completarla
        $this->db->trans_commit();

        // Envía el correo electrónico después de completar la transacción
        $this->accesosUsuariosCorreo($datosGenerales['correo'], $uncode_password);

        // Retornar el ID del cliente insertado
        return $idPortal;

    } catch (Exception $e) {
        // Manejar la excepción si ocurre algún error
        log_message('error', 'Error en addCliente: ' . $e->getMessage());
        $this->db->trans_rollback();
        return false;
    }
}


function addUsuarioClienteModel($usuarioCliente, $usuarioClienteDatos){
      try {
        

          $this->db->trans_start();

          // Agregar los datos generales y obtener el ID
          $usuarioCliente['id_datos_generales'] = $this->generales_model->addDatosGenerales($usuarioClienteDatos);

          // Insertar en la tabla usuarios_clientes
          $this->db->insert("usuarios_clientes", $usuarioCliente);

          $this->db->trans_complete();

          // Verificar si la transacción fue exitosa
          if ($this->db->trans_status() === false) {
              // Ocurrió un error durante la transacción
              return false;
          }

          // Transacción exitosa, retornar el ID del usuario insertado
          return $this->db->insert_id();
      } catch (Exception $e) {
          log_message('error', 'Error en addUsuarioCliente: ' . $e->getMessage());
          return false;
      }
}



function editPortal($idPortal, $portal ,$datosFacturacion = null,   $datosDomicilios = null) {
    try {
        // Iniciar la transacción
        $this->db->trans_start();

        // Editar los datos generales si se proporcionaron
        

        // Editar los domicilios si se proporcionaron
        if (!is_null($datosDomicilios)) {
            $this->generales_model->editDomicilios($portal['id_domicilios'], $datosDomicilios);
        }

        // Editar los datos de facturación si se proporcionaron
        if (!is_null($datosFacturacion)) {
            $this->generales_model->editDatosFacturacion($portal['id_datos_facturacion'], $datosFacturacion);
        }

        // Actualizar el portal en la tabla correspondiente si se proporcionó
        if (!is_null($portal)) {
            $this->db->where('id', $idPortal)->update('portal', $portal);
        }

        // Completar la transacción
        $this->db->trans_complete();

        // Verificar si la transacción fue exitosa
        if ($this->db->trans_status() === false) {
            // Ocurrió un error durante la transacción, manejar según tus necesidades
            return false;
        }

        // La transacción fue exitosa, retornar true
        return true;
    } catch (Exception $e) {
        // Manejar la excepción si ocurre algún error
        log_message('error', 'Error en editCliente: ' . $e->getMessage());
        return false;
    }
}

 

function addPermiso($permiso){
  $this->db->insert("permiso", $permiso);
}
 
function editPermiso($permiso, $id_cliente){
  $this->db
  ->where('id_cliente', $id_cliente)
  ->update('permiso', $permiso);
}
  
function getById($idCliente){
  $this->db
  ->select('*')
  ->from('cliente')
  ->where('id',$idCliente);

  $query = $this->db->get();
  return $query->row();
}

function checkPermisosByCliente($id_cliente){
  $this->db
  ->select("id")
  ->from('permiso')
  ->where('id_cliente', $id_cliente);

  $query = $this->db->get();
  return $query->num_rows();
}
function getAccesosClienteModal($id_cliente, $id_portal){

  
  
  $this->db
      ->select("cli.*, CONCAT(dup.nombre,' ',dup.paterno) as usuario, CONCAT(duc.nombre,' ',duc.paterno) as usuario_cliente, duc.correo as correo_usuario, uc.creacion as alta, uc.id as idUsuarioCliente, uc.privacidad")
      ->from("cliente AS cli")
      ->join("usuarios_clientes uc", "uc.id_cliente = cli.id")
      ->join("usuarios_portal u", "u.id = cli.id_portal")
      ->join("datos_generales dup", "dup.id = u.id_datos_generales")
      ->join("datos_generales duc", "duc.id = uc.id_datos_generales")
      ->where("cli.id", $id_cliente)
      ->where("u.id", $id_portal);
      
  $query = $this->db->get();
  
  if ($query->num_rows() > 0) {
      return $query->result();
  } else {
      return FALSE;
  }
}

function editAccesoUsuarioCliente($idCliente,$usuario ){
  $this->db
  ->where('id_cliente', $idCliente)
  ->update('usuarios_clientes', $usuario);
}

function editAccesoUsuarioSubcliente($idCliente, $usuario){
  $this->db
  ->where('id_cliente', $idCliente)
  ->update('usuario_subcliente', $usuario);
}

function deleteAccesoUsuarioCliente($idUsuarioCliente){
  $this->db
  ->where('id', $idUsuarioCliente)
  ->delete('usuarios_clientes');
}

function getClientesActivosModel(){
  $id_portal = $this->session->userdata('idPortal');
  $this->db
  ->select("C.*")
  ->from('cliente as C')
  ->where('C.status', 1)
  ->where('C.eliminado', 0)
  ->where('C.id_portal', $id_portal)
  ->order_by('C.nombre','ASC');

  $query = $this->db->get();
  if($query->num_rows() > 0){
    return $query->result();
  }else{
    return FALSE;
  }
}

function getUsuariosClientePorCandidato($id_candidato){
  $this->db
  ->select("cl.correo, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.privacidad as privacidadCandidato, cl.privacidad as privacidadCliente")
  ->from('candidato as c')
  ->join("usuario_cliente as cl","cl.id_cliente = c.id_cliente")
  ->where('c.id', $id_candidato);

  $query = $this->db->get();
  if($query->num_rows() > 0){
    return $query->result();
  }else{
    return FALSE;
  }
}

function addHistorialBloqueos($data){
  $this->db->insert("bloqueo_historial", $data);
}

function editHistorialBloqueos($dataBloqueos, $idCliente){
  $this->db
  ->where('id_cliente', $idCliente)
  ->update('bloqueo_historial', $dataBloqueos);
}

function getBloqueoHistorial($id_cliente){
  $this->db
  ->select("*")
  ->from('bloqueo_historial')
  ->where('status', 1)
  ->where('id_cliente', $id_cliente);

  $consulta = $this->db->get();
  return $consulta->row();
}

function accesosUsuariosCorreo($correo, $pass, $soloPass = 0){
      if ($correo === null || $correo === '') {
          return false;
      }
  
      $subject = "Credenciales TalentSafeControl";
      // Cargar la vista email_verification_view.php
      $message = $this->load->view('catalogos/email_credenciales_view', ['correo' => $correo, 'pass'=>$pass, 'switch'=>$soloPass], true);
  
      $this->load->library('phpmailer_lib');
      $mail = $this->phpmailer_lib->load();
      $mail->isSMTP();
      $mail->Host = 'mail.talentsafecontrol.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'soporte@talentsafecontrol.com';
      $mail->Password = 'FQ{[db{}%ja-';
      $mail->SMTPSecure = 'ssl';
      $mail->Port = 465;
     
      if ($correo !== null && $correo !== '') {
          $mail->setFrom('soporte@talentsafecontrol.com', 'TalentSafeControl');
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