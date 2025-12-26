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
        $portal     = $this->session->userdata('idPortal');

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
            //log_message('error', 'Excepción en la consulta: ' . $e->getMessage());
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
      P.usuarios_extras,
      P.id_usuario_portal,
      P.reclu,
      P.pre,
      P.emp,
      P.former,
      P.com,
      P.com360,
      PAQ.nombre_paquete AS paquete,
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
            ->join("paquetestalentsafe AS PAQ", "P.id_paquete = PAQ.id", 'left')
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

        //log_message('info', 'Consulta SQL en existe: ' . $this->db->last_query());
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
        //log_message('info', 'Consulta SQL en check: ' . $this->db->last_query());
        return $query->num_rows();
    }

    public function addPortal($portal, $datosFacturacion, $datosDomicilios, $datosGenerales, $uncode_password, $cliente)
    {
        try {
            // Iniciar la transacción
            $this->db->trans_start();

            // Agregar los datos generales y obtener el ID
            $id_datosGenerales = $this->generales_model->addDatosGenerales($datosGenerales);
            if (! $id_datosGenerales) {
                throw new Exception('Error al insertar datos generales');
            }

            // Agregar los domicilios y obtener el ID
            $id_domicilios = $this->generales_model->addDomicilios($datosDomicilios);
            if (! $id_domicilios) {
                throw new Exception('Error al insertar domicilios');
            }

            // Agregar los datos de facturación y obtener el ID
            $id_datosFacturacion = $this->generales_model->addDatosFacturacion($datosFacturacion);
            if (! $id_datosFacturacion) {
                throw new Exception('Error al insertar datos de facturación');
            }

            // Asignar los IDs obtenidos al portal
            $portal['id_domicilios']        = $id_domicilios;
            $portal['id_datos_facturacion'] = $id_datosFacturacion;

            // Insertar el portal en la tabla correspondiente
            $this->db->insert("portal", $portal);
            $idPortal = $this->db->insert_id();

            // Preparar datos para usuarios_portal
            $usuario_portal = [
                'id_portal'          => $idPortal,
                'creacion'           => $portal['creacion'],
                'edicion'            => $portal['creacion'],
                'id_usuario'         => $portal['id_usuario'],
                'id_datos_generales' => $id_datosGenerales,
                'id_rol'             => 6,
            ];

            // Insertar en usuarios_portal
            $this->db->insert("usuarios_portal", $usuario_portal);
            if ($this->db->affected_rows() <= 0) {
                throw new Exception('Error al insertar en usuarios_portal: ' . print_r($this->db->error(), true));
            }
            $isUsuarioPortal = $this->db->insert_id();

            // Actualizar el portal con el ID de usuario_portal
            $data_portal = ['id_usuario_portal' => $isUsuarioPortal];
            $this->editPortal($idPortal, $data_portal);

            // Preparar datos del cliente
            $cliente['id_domicilios']        = $id_domicilios;
            $cliente['id_datos_facturacion'] = $id_datosFacturacion;
            $cliente['id_datos_generales']   = $id_datosGenerales;
            $cliente['id_usuario']           = $isUsuarioPortal;
            $cliente['clave']                = 'INT';
            $cliente['id_portal']            = $idPortal;

            // Insertar el cliente
            $this->db->insert("cliente", $cliente);
            if ($this->db->affected_rows() <= 0) {
                throw new Exception('Error al insertar en cliente: ' . print_r($this->db->error(), true));
            }
            $idCliente = $this->db->insert_id();
            $url       = "Cliente_General/index/" . $idCliente;
            $this->db->where('id', $idCliente)->update('cliente', ['url' => $url]);

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
            //log_message('error', 'Error en addPortal: ' . $e->getMessage());
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

            if ($this->db->trans_status() === false) {
                // Ocurrió un error durante la transacción, revertir los cambios
                $this->db->trans_rollback();
                return false;
            }

            // La transacción fue exitosa, completarla
            $this->db->trans_commit();

            // Transacción exitosa, retornar el ID del usuario insertado
            return $this->db->insert_id();
        } catch (Exception $e) {
            //log_message('error', 'Error en addUsuarioCliente: ' . $e->getMessage());
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
            if (! is_null($datosDomicilios) && ! empty($datosDomicilios)) {
                $this->generales_model->editDomicilios($portal['id_domicilios'], $datosDomicilios);
            }

            // Editar los datos de facturación si se proporcionaron
            if (! is_null($datosFacturacion) && ! empty($datosFacturacion)) {
                $this->generales_model->editDatosFacturacion($portal['id_datos_facturacion'], $datosFacturacion);
            }

            // Actualizar el portal si se proporcionaron datos
            if (! is_null($portal) && ! empty($portal)) {
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
            //log_message('error', 'Error en editPortal: ' . $e->getMessage());
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
        $mail->Host       = 'mail.talentsafecontrol.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'soporte@talentsafecontrol.com';
        $mail->Password   = 'FQ{[db{}%ja-';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        if ($correo !== null && $correo !== '') {
            $mail->setFrom('soporte@talentsafecontrol.com', 'TalentSafeControl');
            $mail->addAddress($correo);
        } else {
            return false;
        }

        $mail->Subject = $subject;
        $mail->isHTML(true);      // Enviar el correo como HTML
        $mail->CharSet = 'UTF-8'; // Establecer la codificación de caracteres UTF-8
        $mail->Body    = $message;

        if ($mail->send()) {
            return true;
        } else {
            //log_message('error', 'Error al enviar el correo: ' . $mail->ErrorInfo);
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

    public function getModulos()
    {
        $portal = $this->session->userdata('idPortal');

        // Construye la consulta SQL
        $this->db->select("P.reclu, P.pre, P.emp, P.former, P.com")
            ->from('portal AS P')
            ->where('P.status', 1)
            ->where('P.id', $portal); // Asumiendo que necesitas filtrar por el ID del portal

        // Ejecuta la consulta
        $query = $this->db->get();

        // Devuelve una fila como array asociativo o null si no hay resultados
        return $query->row_array();
    }

    public function getLogoAviso($id_portal)
    {
        $this->db->select("P.logo, P.aviso, L.link, L.qr")
            ->from('portal AS P')
            ->join("link_portal L", "L.id_portal = P.id")
            ->where('L.status', 1)
            ->where('P.status', 1)
            ->where('P.id', $id_portal);

        $query = $this->db->get();

        return $query->row(); 
    }
    public function getDocs($id_portal)
    {
        return $this->db->select('aviso, terminos','confidencialidad')
            ->from('portal')
            ->where('id', (int) $id_portal)
            ->get()->row();
    }
    public function updateDocs($id_portal, array $fields)
    {
        return $this->db->where('id', (int) $id_portal)->update('portal', $fields);
    }

    public function documentos_info()
    {
        $this->output->set_content_type('application/json');

        $id_portal = $this->session->userdata('idPortal');

                                                               // Si ya tienes un método en el modelo que regresa 'aviso'
        $row = $this->cat_portales_model->getDocs($id_portal); // debe devolver columna 'aviso' (o null)

        $aviso_actual  = $row ? ($row->aviso ?? null) : null;
        $default_aviso = 'AV_TL_V1.pdf'; // <-- tu default

        $archivo_mostrar = $aviso_actual ?: $default_aviso;

        echo json_encode([
            'aviso_actual'  => $aviso_actual,    // null si no hay
            'default_aviso' => $default_aviso,   // siempre
            'aviso_mostrar' => $archivo_mostrar, // lo que se debe mostrar
            'aviso_url'     => base_url('Avance/ver_aviso/' . rawurlencode($archivo_mostrar)),
            'status'        => 'ok',
        ]);
    }

    public function documentos_guardar()
    {
        $this->output->set_content_type('application/json');

        $id_portal = $this->session->userdata('idPortal');
        $tipo      = $this->input->post('tipo'); // 'aviso'|'terminos'
        if (! in_array($tipo, ['aviso', 'terminos'], true)) {echo json_encode(['error' => 'Tipo inválido']);return;}

        if (empty($_FILES['archivo']['name'])) {echo json_encode(['error' => 'Selecciona un PDF']);return;}
        if (mime_content_type($_FILES['archivo']['tmp_name']) !== 'application/pdf') {
            echo json_encode(['error' => 'El archivo debe ser PDF']);return;
        }

        $dir = FCPATH . 'uploads/docs_portal/' . $id_portal . '/';
        if (! is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        $filename = $tipo . '_' . date('Ymd_His') . '.pdf';
        if (! move_uploaded_file($_FILES['archivo']['tmp_name'], $dir . $filename)) {
            echo json_encode(['error' => 'No se pudo mover el archivo']);return;
        }

        $this->cat_portales_model->updateDocs($id_portal, [$tipo => $filename]);

        echo json_encode([
            'status'  => 'success',
            'mensaje' => ucfirst($tipo) . ' actualizado.',
            'archivo' => $filename,
        ]);
    }

    public function documentos_eliminar()
    {
        $this->output->set_content_type('application/json');

        $id_portal = $this->session->userdata('idPortal');
        $tipo      = $this->input->post('tipo');
        if (! in_array($tipo, ['aviso', 'terminos'], true)) {echo json_encode(['error' => 'Tipo inválido']);return;}

        $row     = $this->cat_portales_model->getDocs($id_portal);
        $current = $row ? ($row->{$tipo} ?? null) : null;
        if (! $current) {echo json_encode(['error' => 'No hay archivo para eliminar']);return;}

        $path = FCPATH . 'uploads/docs_portal/' . $id_portal . '/' . $current;
        if (is_file($path)) {
            @unlink($path);
        }

        $this->cat_portales_model->updateDocs($id_portal, [$tipo => null]);

        echo json_encode(['status' => 'success', 'mensaje' => ucfirst($tipo) . ' eliminado.']);
    }

     
    public function getDatosPortal()
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("P.nombre as nombre_portal, DAT.telefono, DAT.correo")
            ->from('portal as P')
            ->join("usuarios_portal as UP", "UP.id = P.id_usuario_portal",'left')
            ->join("datos_generales as DAT", "DAT.id = UP.id_datos_generales",'left')
          
            ->where('P.id', $id_portal);
          

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

}