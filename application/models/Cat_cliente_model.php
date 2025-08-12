<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cat_cliente_model extends CI_Model
{

    public function getTotal($portal)
    {
        $this->db
            ->select("c.id")
            ->from('cliente as c')
            ->where('c.id_portal', $portal)
            ->where('c.ingles', 0)
            ->where('c.eliminado', 0);

        $query = $this->db->get();
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
            log_message('error', 'Excepción en la consulta: ' . $e->getMessage());
            return [];
        }
    }
    public function getC($id_cliente = null)
    {
        $portal = $this->session->userdata('idPortal');
        try {
            $this->db->select("C.*,
        C.id AS idCliente,
        C.id_datos_facturacion AS dFac,
        C.id_domicilios AS dDom,
        C.id_datos_generales AS dGen,
            DG.nombre AS nombre_contacto,
            DG.paterno AS apellido_contacto,
            DG.correo AS correo_contacto,
            DG.telefono AS telefono_contacto,
            DG.password AS password_contacto,
            D.*,
            P.tipo_bolsa,
            F.*, F.regimen as regimen1, F.forma_pago, F.metodo_pago,
            (SELECT COUNT(id) FROM usuarios_clientes WHERE id_cliente = C.id) AS numero_usuarios_clientes,
            DGC.nombre AS nombre_usuario_cliente,
            DGC.paterno AS apellido_usuario_cliente,
            DGC.correo AS correo_usuario_cliente,
            DGC.telefono AS telefono_usuario_cliente")
                ->from('cliente AS C')
                ->join("datos_generales AS DG", "C.id_datos_generales = DG.id")
                ->join("domicilios AS D", "C.id_domicilios = D.id")
                ->join("portal AS P", "C.id_portal = P.id")
                ->join("datos_facturacion AS F", "C.id_datos_facturacion = F.id")
                ->join("datos_generales AS DGC", "C.id_datos_generales = DGC.id")
                ->where(['C.id_portal' => $portal, 'C.eliminado' => 0]);

            // Si se proporciona un id_cliente, añade un filtro adicional
            if ($id_cliente !== null) {
                $this->db->where('C.id', $id_cliente);
            }

            $query = $this->db->get();

            // Verifica errores de la base de datos
            $db_error = $this->db->error();
            if (! empty($db_error['message'])) {
                log_message('error', 'Error en la consulta: ' . $db_error['message']);
                return [];
            }

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

    public function existeCliente($nombre, $clave, $id)
    {

        //echo " nombre: ". $nombre. " Clave: ". $clave.  "  ID: ". $id;
        //die();
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select('*')
            ->from('cliente')
            ->where('id_portal', $id_portal)
            ->where("(nombre = '$nombre' OR clave = '$clave') AND id != '$id'");

        $query = $this->db->get();
        // Loguear la consulta SQL generada

        log_message('info', 'Consulta SQL en existe: ' . $this->db->last_query());
        return $query->num_rows();
    }

    public function check($id)
    {
        $this->db
            ->select('id')
            ->from('cliente')
            ->where('id', $id);

        $query = $this->db->get();
        // Loguear la consulta SQL generada
        log_message('info', 'Consulta SQL en check: ' . $this->db->last_query());
        return $query->num_rows();
    }

    public function addCliente($cliente, $datosFacturacion, $datosDomicilios, $datosGenerales, $uncode = null)
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

            // Asignar los IDs obtenidos al cliente
            $cliente['id_datos_generales']   = $id_datosGenerales;
            $cliente['id_domicilios']        = $id_domicilios;
            $cliente['id_datos_facturacion'] = $id_datosFacturacion;

            // Insertar el cliente en la tabla correspondiente
            $this->db->insert("cliente", $cliente);
            $idCliente = $this->db->insert_id();

            // Actualizar la URL del cliente
            $url = "Cliente_General/index/" . $idCliente;
            $this->db->where('id', $idCliente)->update('cliente', ['url' => $url]);

            // Crear permisos para el cliente
            $permiso = [
                'id_usuario' => $cliente['id_usuario'],
                'id_cliente' => $idCliente,

            ];
            $this->db->insert("usuario_permiso", $permiso);

            // Crear usuario del cliente
            $usuario_cliente = [
                'creacion'           => $cliente['creacion'],
                'edicion'            => $cliente['creacion'],
                'id_usuario'         => $cliente['id_usuario'],
                'id_datos_generales' => $id_datosGenerales,
                'id_cliente'         => $idCliente,
                'espectador'         => 0,
                'privacidad'         => 1,
            ];
            $this->db->insert("usuarios_clientes", $usuario_cliente);

            // Verificar si la transacción fue exitosa
            if ($this->db->trans_status() === false) {
                // Ocurrió un error durante la transacción, revertir los cambios
                $this->db->trans_rollback();
                return false;
            }

            // La transacción fue exitosa, completarla
            $this->db->trans_commit();

            $modulos = $this->obtenerModulosPortalPorId($this->session->userdata('idPortal'));

            if ($modulos['reclu'] == 1 && $modulos['pre'] == 1) {
                // Envía el correo electrónico después} de completar la transacción
                $this->accesosUsuariosCorreo($datosGenerales['correo'], $uncode);
            }
            // Retornar el ID del cliente insertado
            return $idCliente;

        } catch (Exception $e) {
            // Manejar la excepción si ocurre algún error
            log_message('error', 'Error en addCliente: ' . $e->getMessage());
            $this->db->trans_rollback();
            return false;
        }
    }
    public function obtenerModulosPortalPorId($id)
    {
        $this->db->select('reclu, pre, emp, former');
        $this->db->from('portal');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row_array(); // Devuelve un array asociativo con los datos
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

    public function editCliente($idCliente, $cliente, $datosFacturacion = null, $datosDomicilios = null, $datosGenerales = null)
    {
        try {
            // Iniciar la transacción
            $this->db->trans_start();

            // Editar los datos generales si se proporcionaron
            if (! is_null($datosGenerales)) {
                $this->generales_model->editDatosGenerales($cliente['id_datos_generales'], $datosGenerales);
            }

            // Editar los domicilios si se proporcionaron
            if (! is_null($datosDomicilios)) {
                $this->generales_model->editDomicilios($cliente['id_domicilios'], $datosDomicilios);
            }

            // Editar los datos de facturación si se proporcionaron
            if (! is_null($datosFacturacion)) {
                $this->generales_model->editDatosFacturacion($cliente['id_datos_facturacion'], $datosFacturacion);
            }

            // Actualizar el cliente en la tabla correspondiente si se proporcionó
            if (! is_null($cliente)) {
                $this->db->where('id', $idCliente)->update('cliente', $cliente);
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
    public function getAccesosClienteModal($id_cliente, $id_portal)
    {

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
            log_message('error', 'Error al enviar el correo: ' . $mail->ErrorInfo);
            return false;
        }
    }

    public function getLinksCliente($id_cliente)
    {
        $query = $this->db
            ->select('c.*')
            ->from('links_clientes as c')
            ->where('c.id_cliente', $id_cliente)
            ->get();

        return $query->result(); // 👈 Esto devuelve un array de objetos
    }
    public function getTerminos($id_portal)
    {
        $query = $this->db
            ->select('aviso, terminos')
            ->from('portal')
            ->where('id', $id_portal)
            ->get();

        return $query->row(); // Devuelve solo el objeto del portal
    }

    public function guardarLinkCliente($data)
    {
        if (empty($data['id_cliente'])) {
            return false; // id_cliente es obligatorio
        }

        // Verificar si ya existe un registro para este cliente
        $this->db->where('id_cliente', $data['id_cliente']);
        $existe = $this->db->count_all_results('links_clientes') > 0;

        if ($existe) {
            // Actualizar
            $data['edicion'] = date('Y-m-d H:i:s');
            return $this->db
                ->where('id_cliente', $data['id_cliente'])
                ->update('links_clientes', $data);
        } else {
            // Insertar
            $data['creacion'] = date('Y-m-d H:i:s');
            $data['edicion']  = date('Y-m-d H:i:s');
            return $this->db->insert('links_clientes', $data);
        }
    }

}
