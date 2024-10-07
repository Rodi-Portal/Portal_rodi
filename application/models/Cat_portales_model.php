<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cat_portales_model extends CI_Model
{

    public function getTotal()
    {
        // Construye la consulta SQL
        $this->db->select("P.id")
            ->from('portal AS P')
            ->where('P.status', 1);

        // Ejecuta la consulta y obtiene el número de filas
        $query = $this->db->get();

        // Devuelve el número de filas
        return $query->num_rows();
    }

    public function getClienteValido()
    {
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
    public function getP()
    {
        // Construye la consulta SQL
        $this->db->select("
      P.id AS idPortal,
      P.cons AS constancia,
      P.nombre,
      P.status,
      P.descripcion,
      P.creacion,
      P.bloqueado,
      P.usuarios_permitidos,
      P.id_usuario_portal,
      P.reclu,
      P.pre,
      P.emp,
      P.former,
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

        // Ejecuta la consulta
        $query = $this->db->get();

        // Devuelve los resultados o un array vacío si no hay resultados
        return $query->result_array();
    }

    public function existePortal($nombre)
    {

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

    public function check($id)
    {
        $this->db
            ->select('id')
            ->from('portal')
            ->where('id', $id);

        $query = $this->db->get();
        // Loguear la consulta SQL generada
        log_message('info', 'Consulta SQL en check: ' . $this->db->last_query());
        return $query->num_rows();
    }

    public function addPortal($portal, $datosFacturacion, $datosDomicilios, $datosGenerales, $uncode_password)
    {
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
            $idPortal = $this->db->insert_id();

            // Crear usuario del portal
            $usuario_portal = [
                'id_portal' => $idPortal,
                'creacion' => $portal['creacion'],
                'edicion' => $portal['creacion'],
                'id_usuario' => $portal['id_usuario'],
                'id_datos_generales' => $id_datosGenerales,
                'id_domicilios' => null,
                'id_rol' => 6,
            ];
            $this->db->insert("usuarios_portal", $usuario_portal);
            $isUsuarioPortal = $this->db->insert_id();

            $data_portal = array(
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

    public function addUsuarioClienteModel($usuarioCliente, $usuarioClienteDatos)
    {
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

    public function editPortal($idPortal, $portal, $datosFacturacion = null, $datosDomicilios = null)
    {
        try {
            // Imprimir datos para depuración (elimina esto en producción)
            /* echo '<pre>';
            print_r($datosFacturacion);
            print_r($datosDomicilios);
            print_r($portal);
            echo '</pre>';
            die();  */

            // Iniciar la transacción
            $this->db->trans_start();

            // Editar los domicilios si se proporcionaron
            if (!is_null($datosDomicilios) && !empty($datosDomicilios)) {
                $this->generales_model->editDomicilios($portal['id_domicilios'], $datosDomicilios);
            }

            // Editar los datos de facturación si se proporcionaron
            if (!is_null($datosFacturacion) && !empty($datosFacturacion)) {
                $this->generales_model->editDatosFacturacion($portal['id_datos_facturacion'], $datosFacturacion);
            }

            // Actualizar el portal si se proporcionaron datos
            if (!is_null($portal) && !empty($portal)) {
                $this->db->where('id', $idPortal)->update('portal', $portal);
            }

            // Completar la transacción
            $this->db->trans_complete();

            // Verificar si la transacción fue exitosa
            if ($this->db->trans_status() === false) {
                // Ocurrió un error durante la transacción
                return false;
            }

            // La transacción fue exitosa
            return true;
        } catch (Exception $e) {
            // Manejar la excepción
            log_message('error', 'Error en editPortal: ' . $e->getMessage());
            return false;
        }
    }

    public function addPermiso($permiso)
    {
        $this->db->insert("permiso", $permiso);
    }

    public function editPermiso($permiso, $id_cliente)
    {
        $this->db
            ->where('id_cliente', $id_cliente)
            ->update('permiso', $permiso);
    }

    public function getById($idCliente)
    {
        $this->db
            ->select('*')
            ->from('cliente')
            ->where('id', $idCliente);

        $query = $this->db->get();
        return $query->row();
    }

    public function checkPermisosByCliente($id_cliente)
    {
        $this->db
            ->select("id")
            ->from('permiso')
            ->where('id_cliente', $id_cliente);

        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getAccesosPortalModal($id_portal)
    {

        $this->db
            ->select("P.*, CONCAT(DUP.nombre,' ',DUP.paterno) as usuario, DUP.correo AS correo_usuario,  U.creacion as alta, U.id as idUsuarioCliente")
            ->from("portal AS P")

            ->join("usuarios_portal U", "U.id_portal = P.id")
            ->join("datos_generales DUP", "DUP.id = U.id_datos_generales")
            ->where("U.eliminado", 0)
            ->where("P.id", $id_portal);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function editAccesoUsuarioCliente($idCliente, $usuario)
    {
        $this->db
            ->where('id_cliente', $idCliente)
            ->update('usuarios_clientes', $usuario);
    }

    public function editAccesoUsuarioSubcliente($idCliente, $usuario)
    {
        $this->db
            ->where('id_cliente', $idCliente)
            ->update('usuario_subcliente', $usuario);
    }

    public function deleteAccesoUsuarioCliente($idUsuarioCliente)
    {
        $this->db
            ->where('id', $idUsuarioCliente)
            ->delete('usuarios_clientes');
    }

    public function getClientesActivosModel()
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("C.*")
            ->from('cliente as C')
            ->where('C.status', 1)
            ->where('C.eliminado', 0)
            ->where('C.id_portal', $id_portal)
            ->order_by('C.nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getUsuariosClientePorCandidato($id_candidato)
    {
        $this->db
            ->select("cl.correo, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.privacidad as privacidadCandidato, cl.privacidad as privacidadCliente")
            ->from('candidato as c')
            ->join("usuario_cliente as cl", "cl.id_cliente = c.id_cliente")
            ->where('c.id', $id_candidato);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function addHistorialBloqueos($data)
    {
        $this->db->insert("bloqueo_historial", $data);
    }

    public function editHistorialBloqueos($dataBloqueos, $idCliente)
    {
        $this->db
            ->where('id_cliente', $idCliente)
            ->update('bloqueo_historial', $dataBloqueos);
    }

    public function getBloqueoHistorial($id_cliente)
    {
        $this->db
            ->select("*")
            ->from('bloqueo_historial')
            ->where('status', 1)
            ->where('id_cliente', $id_cliente);

        $consulta = $this->db->get();
        return $consulta->row();
    }

    public function accesosUsuariosCorreo($correo, $pass, $soloPass = 0)
    {
        if ($correo === null || $correo === '') {
            return false;
        }

        $subject = "Credenciales TalentSafeControl";
        // Cargar la vista email_verification_view.php
        $message = $this->load->view('catalogos/email_credenciales_view', ['correo' => $correo, 'pass' => $pass, 'switch' => $soloPass], true);

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

    public function editModulos($datos, $id_portal)
    {
        // Ejecutar la consulta de actualización
        $this->db->where('id', $id_portal);
        $this->db->update('portal', $datos);

        // Verificar si la consulta afectó alguna fila
        if ($this->db->affected_rows() > 0) {
            return 1; // La actualización fue exitosa
        } else {
            return 0; // La actualización no afectó ninguna fila
        }
    }

    public function getModulos() {
      $portal = $this->session->userdata('idPortal');
  
      // Construye la consulta SQL
      $this->db->select("P.reclu, P.pre, P.emp, P.former")
               ->from('portal AS P')
               ->where('P.status', 1)
               ->where('P.id', $portal); // Asumiendo que necesitas filtrar por el ID del portal
  
      // Ejecuta la consulta
      $query = $this->db->get();
  
      // Devuelve una fila como array asociativo o null si no hay resultados
      return $query->row_array();
  }

}
