<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cat_usuario_model extends CI_Model
{

    public function getTotal($id_portal)
    {
        $this->db
            ->select("U.id")
            ->from('usuarios_portal as U')
            ->where('U.id_portal', $id_portal)
            ->where('U.eliminado', 0)
            ->where('U.status', 1);

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getUsuarios($id_portal)
    {
        $this->db
            ->select("U.*, U.id as id_usuario, U.id_datos_generales as id_datos, DATUP.*,
                  CONCAT(COALESCE(DATUP.nombre, ''), ' ', COALESCE(DATUP.paterno, '')) as referente,
                  R.nombre as nombre_rol, POR.nombre as nombre_portal")
            ->from('usuarios_portal as U')
            ->join('datos_generales as DATUP', 'DATUP.id = U.id_datos_generales')
            ->join('portal as POR', 'POR.id = U.id_portal')
            ->join('rol as R', 'R.id = U.id_rol')
            ->where('U.id_portal', $id_portal)
            ->where('U.eliminado', 0)
            ->order_by('U.creacion', 'ASC')
            ->group_by('U.id');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function correoExiste($correo, $idDatos = null)
    {
        $this->db->select('USP.id, DATUP.correo')
            ->from('usuarios_portal as USP')
            ->join('datos_generales as DATUP', 'DATUP.id = USP.id_datos_generales')
            ->where('DATUP.correo', $correo);

        if ($idDatos !== null) {
            $this->db->where_not_in('USP.id', $idDatos);
        }

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function obtenerCorreoPorUsuario($idUsuario)
    {
        return $this->db
            ->select('DATUP.correo')
            ->from('usuarios_portal USP')
            ->join('datos_generales DATUP', 'DATUP.id = USP.id_datos_generales')
            ->where('USP.id', $idUsuario)
            ->get()
            ->row('correo');
    }
    public function check($id)
    {
        $this->db
            ->select('id')
            ->from('usuarios_portal')
            ->where('id', $id);

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function add($usuario)
    {
        $this->db->insert("usuario", $usuario);
        return $this->db->insert_id();
    }

    public function editUsuario($id, $usuario, $id_datos = null, $datos_generales = null)
    {
        /*  echo " aqui el id de datos : ".$id_datos. "<br>  aqui los datos generales ";
    var_dump($datos_generales);
    echo " aqui el id de usuario : ".$id. "<br>  aqui el usuario ";

    var_dump($usuario);
    die();*/
        // Comprueba si se proporcionaron $id_datos y $datos_generales
        if ($id_datos !== null && $datos_generales !== null) {
                                      // Si se proporcionaron, actualiza tanto 'usuarios_portal' como 'datos_generales'
            $this->db->trans_start(); // Inicia una transacción

            // Actualiza 'datos_generales' primero
            $this->db
                ->where('id', $id_datos)
                ->update('datos_generales', $datos_generales);

            // Actualiza 'usuarios_portal' con el nuevo $usuario
            $this->db
                ->where('id', $id)
                ->update('usuarios_portal', $usuario);

            // Finaliza la transacción
            $this->db->trans_complete();

            // Comprueba si la transacción fue exitosa
            if ($this->db->trans_status() === false) {
                // Si la transacción falla, revierte las operaciones
                $this->db->trans_rollback();
                return "Error en la transacción";
            } else {
                // Si la transacción tiene éxito, confirma las operaciones
                $this->db->trans_commit();
                return "Usuarios y datos generales actualizados con éxito";
            }
        } else {
            // Si no se proporcionaron $id_datos y $datos_generales, solo actualiza 'usuarios_portal'
            $this->db
                ->where('id', $id)
                ->update('usuarios_portal', $usuario);
            $this->db->trans_commit();
            return "Solo usuarios actualizados";
        }
    }

    public function addUsuarioInterno($usuario, $datos_generales)
    {
        // Inicia la transacción
        $this->db->trans_start();

        try {
            // Obtén el ID del portal desde la sesión
            $id_portal = $this->session->userdata('idPortal');

            // Inserta los datos generales en la tabla 'datos_generales'
            $this->db->insert("datos_generales", $datos_generales);

            // Obtén el ID del último registro insertado en 'datos_generales'
            $id_datos_generales = $this->db->insert_id();

            // Agrega el ID del portal y el ID de los datos generales al arreglo $usuario
            $usuario['id_portal']          = $id_portal;
            $usuario['id_datos_generales'] = $id_datos_generales;

            // Inserta el usuario en la tabla 'usuarios_portal'
            $this->db->insert("usuarios_portal", $usuario);

            // Finaliza la transacción
            $this->db->trans_complete();

            // Verifica si la transacción fue exitosa
            if ($this->db->trans_status() === false) {
                // Si la transacción falla, revierte las operaciones
                $this->db->trans_rollback();
                return " error  en la consulta";
            } else {
                // Si la transacción tiene éxito, confirma las operaciones
                $this->db->trans_commit();
                return " se registro";
            }
        } catch (Exception $e) {
            // Si ocurre una excepción, revierte las operaciones y devuelve false
            $this->db->trans_rollback();
            return "error  excepcion " . $e;
        }
    }
    public function updatePass($id, $DatosGenerales, $uncode_password, $correo)
    {
        /* echo '<pre>';
        echo $id . ' aqui el id<br>';
        echo $uncode_password . ' aqui el pass<br>';
        echo $correo . ' aqui el correo<br>';
        print_r($DatosGenerales);
        echo '</pre>' */

        $this->db->trans_start();

        try {
            // Verificar si el ID existe antes de intentar actualizar
            $this->db->where('id', $id);
            $query = $this->db->get('datos_generales');
            if ($query->num_rows() <= 0) {
                throw new Exception("ID no encontrado en la base de datos.");
            }

            // Actualiza los datos en la tabla 'datos_generales'
            $this->db->where('id', $id);
            $this->db->update('datos_generales', $DatosGenerales);

            // Muestra la consulta SQL generada para depuración
            //echo $this->db->last_query() . '<br>';

            // Verifica si la actualización fue exitosa
            if ($this->db->affected_rows() <= 0) {
                throw new Exception("No se actualizaron los datos en la base de datos.");
            }

            // Envía el correo y verifica si fue exitoso
            $envioExitoso = $this->accesosUsuariosCorreo($correo, $uncode_password, 1);

            if (! $envioExitoso) {
                throw new Exception("Error al enviar el correo.");
            }

            // Finaliza la transacción
            $this->db->trans_complete();

            // Verifica si la transacción fue exitosa
            if ($this->db->trans_status() === false) {
                return 0; // Transacción fallida
            } else {
                return 1; // Transacción exitosa
            }
        } catch (Exception $e) {
            // Rollback en caso de excepción
            $this->db->trans_rollback();
            return "error excepcion " . $e->getMessage();
        }
    }

    public function getById($idusuario)
    {
        $this->db
            ->select('*')
            ->from('usuario')
            ->where('id', $idusuario);

        $query = $this->db->get();
        return $query->row();
    }

    public function getActivos()
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("U.*, DATUP.* ")
            ->from('usuarios_portal as U')
            ->join('datos_generales  as DATUP', 'DATUP.id = U.id_datos_generales')
            ->where('U.id_portal', $id_portal)
            ->where('U.status', 1)
            ->where('U.eliminado', 0)
            ->order_by('DATUP.nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function accesosUsuariosCorreo($correo, $pass, $soloPass = 0)
    {
        if (empty($correo)) {
            return false;
        }

        // 🔐 Cargar configuración SMTP privada (NO versionada)
        $this->config->load('email_private', true);
        $smtp = $this->config->item('email_private', 'email_private');

        // 🛑 Validación defensiva
        if (
            empty($smtp) ||
            empty($smtp['host']) ||
            empty($smtp['user']) ||
            empty($smtp['pass']) ||
            empty($smtp['port']) ||
            empty($smtp['from']) ||
            empty($smtp['fromName'])
        ) {
            log_message('error', 'Configuración SMTP privada incompleta o inexistente');
            return false;
        }

        $subject = 'Credenciales TalentSafeControl';

        // 📧 Cargar vista del correo
        $message = $this->load->view(
            'catalogos/email_credenciales_view',
            [
                'correo' => $correo,
                'pass'   => $pass,
                'switch' => $soloPass,
            ],
            true
        );

        // 📮 PHPMailer
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        // 🧪 DEBUG SMTP (puedes apagarlo cuando funcione)
        $mail->SMTPDebug   = 2;
        $mail->Debugoutput = function ($str, $level) {
            log_message('error', "SMTP DEBUG [$level]: $str");
        };

        $mail->isSMTP();
        $mail->Host       = $smtp['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp['user'];
        $mail->Password   = $smtp['pass'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = (int) $smtp['port'];
        $mail->Timeout    = 20;

        // 🔒 Opciones SSL (muy importante en cPanel / AlmaLinux)
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ],
        ];

        $mail->setFrom($smtp['from'], $smtp['fromName']);
        $mail->addAddress($correo);

        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Body    = $message;

        if (! $mail->send()) {
            log_message('error', 'Error correo SMTP: ' . $mail->ErrorInfo);
            return false;
        }

        return true;
    }

    //.............................................................................//
    //---------------------LLevar  sucursales-------------------------------------//
    public function getSucursales()
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("C.* ")
            ->from('cliente as C')
            ->where('C.id_portal', $id_portal)
            ->where('C.status', 1)
            ->where('C.eliminado', 0)
            ->order_by('C.nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * Asigna sucursales a los usuarios en la tabla usuario_permiso
     * @param array $usuarios Lista de IDs de usuarios
     * @param array $sucursales Lista de IDs de sucursales
     * @return bool Retorna TRUE si la operación fue exitosa, FALSE en caso de error
     */
    public function asignarSucursal($usuarios, $sucursales)
    {

        // Iniciar transacción para evitar errores en caso de fallo
        $this->db->trans_start();

        // Insertar cada combinación de usuario y sucursal en la tabla usuario_permiso
        foreach ($usuarios as $id_usuario) {
            foreach ($sucursales as $id_cliente) {
                // Verificar si la asignación ya existe
                $this->db->where('id_usuario', $id_usuario);
                $this->db->where('id_cliente', $id_cliente);
                $existe = $this->db->get('usuario_permiso')->row();

                if (! $existe) {
                    // Insertar si no existe
                    $this->db->insert('usuario_permiso', [
                        'id_usuario' => $id_usuario,
                        'id_cliente' => $id_cliente,
                    ]);
                }
            }
        }

        // Finalizar la transacción
        $this->db->trans_complete();

        // Verificar si la transacción fue exitosa
        return $this->db->trans_status();
    }

    public function verificarLimiteUsuariosPortal($id_portal)
    {
        // Obtener el id_paquete del portal
        $this->db->select('id_paquete');
        $this->db->from('portal');
        $this->db->where('id', $id_portal);
        $queryPortal = $this->db->get();

        if ($queryPortal->num_rows() == 0) {
            return ['error' => true, 'mensaje' => 'Portal no encontrado'];
        }

        $id_paquete = $queryPortal->row()->id_paquete;

        // Obtener el límite de usuarios del paquete
        $this->db->select('usuarios');
        $this->db->from('paquetestalentsafe');
        $this->db->where('id', $id_paquete);
        $queryPaquete = $this->db->get();

        if ($queryPaquete->num_rows() == 0) {
            return ['error' => true, 'mensaje' => 'Paquete no encontrado'];
        }

        $limite = (int) $queryPaquete->row()->usuarios;

        // Contar usuarios activos del portal
        $this->db->from('usuarios_portal');
        $this->db->where('id_portal', $id_portal);
        $this->db->where('status', 1); // Asumimos que status 1 es activo
        $total_activos = $this->db->count_all_results();

        return [
            'error'         => false,
            'supera_limite' => $total_activos >= $limite,
        ];
    }

    public function eliminarPermiso($id_usuario, $id_cliente)
    {
        // Eliminar el registro de la tabla usuario_permiso
        $this->db->where('id_usuario', $id_usuario);
        $this->db->where('id_cliente', $id_cliente);
        $this->db->delete('usuario_permiso');

        // Verificar si la eliminación fue exitosa
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}
