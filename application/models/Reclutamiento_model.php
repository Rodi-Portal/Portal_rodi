<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reclutamiento_model extends CI_Model
{

    /*----------------------------------------*/
    /*  Submenus
    /*----------------------------------------*/
    public function getAllOrders($sort, $id_order, $condition_order, $filter, $filterOrder)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("R.id, R.creacion, CL.nombre, GENCL.telefono, CONCAT(GENCL.nombre,' ',GENCL.paterno) as contacto, R.puesto, R.numero_vacantes, R.status, GENCL.correo, R.tipo, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario, CL.nombre")
            ->from('requisicion as R')
            ->join('usuarios_portal as U', 'U.id = R.id_usuario', 'left')
            ->join('datos_generales as GENUS', 'U.id_datos_generales = GENUS.id', 'left')
            ->join('cliente as CL', 'R.id_CLiente = CL.id', 'left')
            ->join('datos_generales as GENCL', 'CL.id_datos_generales = GENCL.id', 'left')
            ->where('CL.id_portal', $id_portal)
            ->where_in('R.status', [1, 2])
            ->where($condition_order, $id_order)
            ->where('R.eliminado', 0)
            ->order_by('R.id', $sort);

        // Verifica si hay un filtro y lo aplica si existe
        if (!empty($filter) && isset($filterOrder)) {
            $this->db->where($filterOrder, $filter);
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getOrdersByUser($id_usuario, $sort, $id_order, $condition_order)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("R.id, R.creacion, CL.nombre, GENCL.telefono, CONCAT(GENCL.nombre,' ',GENCL.paterno) as contacto, R.puesto, R.numero_vacantes, R.status, GENCL.correo, R.tipo, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario,      FAC.razon_social as nombre_comercial")
            ->from('requisicion as R')
            ->join('usuarios_portal as U', 'U.id = R.id_usuario')
            ->join('cliente as CL', 'CL.id = R.id_cliente')
            ->join('datos_facturacion as FAC', 'FAC.id = CL.id_datos_facturacion')
            ->join('datos_generales  as GENCL ', 'GENCL.id = CL.id_datos_generales')
            ->join('requisicion_usuario as RU', 'RU.id_requisicion = R.id')

            ->join('datos_generales  as GENUS ', 'GENUS.id = U.id_datos_generales')
            ->where_in('R.status', [1, 2])
            ->where('RU.id_usuario', $id_usuario)
            ->where('CL.id_portal', $id_portal)
            ->where($condition_order, $id_order)
            ->order_by('R.id', $sort)
            ->group_by('R.id');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getRequisicionesEnProceso($id_usuario, $condicion)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("R.id, CL.nombre, R.puesto, R.numero_vacantes, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario")
            ->from('requisicion as R')
            ->join('requisicion_usuario as RU', 'RU.id_requisicion = R.id')
            ->join('usuario as USER', 'USER.id = RU.id_usuario')
            ->join('datos_generales as GENUS', 'GENUS.id = U.id_datos_generales')
            ->join('clientes as CL', 'CL.id = R.id_cliente')
            ->join('datos_generales as GENCL', 'GENCL.id = CL.id_datos_generales')
            ->where('R.id_portal ', $id_portal)
            ->where('R.eliminado', 0)
            ->where('R.status', 2)
            ->where($condicion, $id_usuario)
            ->order_by('R.status', 'ASC')
            ->group_by('RU.id');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getOrdersInProcessByUser($id_usuario)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("R.id, CL.nombre, R.puesto, R.numero_vacantes, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario")
            ->from('requisicion as R')
            ->join('requisicion_usuario as RU', 'RU.id_requisicion = R.id')
            ->join('usuarios_portal as U', 'U.id = RU.id_usuario')
            ->join('datos_generales as GENUS', 'GENUS.id = U.id_datos_generales')
            ->join('cliente as CL', 'CL.id = R.id_cliente')
            ->join('datos_generales as GENCL', 'GENCL.id = CL.id_datos_generales')
            ->where('R.eliminado', 0)
            ->where('R.status', 2)
            ->where('R.id_portal ', $id_portal)
            ->where('RU.id_usuario', $id_usuario)
            ->group_by('RU.id')
            ->order_by('R.status', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getAllOrdersInProcess()
    {
        $id_portal = $this->session->userdata('idPortal');
        try {
            $this->db
                ->select("R.id, CL.nombre, R.puesto, R.numero_vacantes, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario")
                ->from('requisicion as R')
                ->join('usuarios_portal as U', 'U.id = R.id_usuario')
                ->join('datos_generales as GENUS', 'GENUS.id = U.id_datos_generales', 'left')
                ->join('cliente as CL', 'CL.id = R.id_cliente')
                ->where('R.eliminado', 0)
                ->where('R.status', 2)
                ->where('R.id_portal ', $id_portal)
                ->order_by('R.id', 'DESC');

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return array(); // Devuelve un array vacío en lugar de FALSE
            }
        } catch (Exception $e) {
            // Manejar el error
            log_message('error', 'Error en getAllOrdersInProcess(): ' . $e->getMessage());
            return array(); // Devuelve un array vacío en caso de error
        }
    }
    public function getAllApplicants($id_usuario, $condition)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("B.*, CONCAT(B.nombre,' ',B.paterno,' ',B.materno) as nombreCompleto, CONCAT(gen.nombre,' ',gen.paterno) as usuario")
            ->from('bolsa_trabajo as B')
            ->join('usuarios_portal as U', 'U.id = B.id_usuario', 'left')
            ->join('datos_generales as gen', 'gen.id = U.id_datos_generales', 'left')
            ->where('B.id_portal', $id_portal)
            ->where($condition, $id_usuario)
            ->order_by('B.id', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getBolsaTrabajo($sort, $id_applicant, $condition_applicant, $filter, $filterApplicant, $id_usuario, $condition_user, $area, $condition_area)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("B.*, CONCAT(B.nombre,' ',B.paterno,' ',B.materno) as nombreCompleto, CONCAT(gen.nombre,' ',gen.paterno) as usuario")
            ->from('bolsa_trabajo as B')
            ->join('usuarios_portal as U', 'U.id = B.id_usuario', 'left')
            ->join('datos_generales as gen', 'gen.id = U.id_datos_generales', 'left')
            ->where('B.id_portal', $id_portal)
            ->where($condition_area, $area)
            ->where($filterApplicant, $filter)
            ->where($condition_applicant, $id_applicant)
            ->where($condition_user, $id_usuario)
            ->order_by('B.id', $sort);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getApplicantsByUser($sort, $id_applicant, $condition_applicant, $filter, $filterApplicant, $id_usuario, $area, $condition_area)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("B.*, CONCAT(B.nombre,' ',B.paterno,' ',B.materno) as nombreCompleto, CONCAT(GENUP.nombre,' ',GENUP.paterno) as usuario")
            ->from('bolsa_trabajo as B')
            ->join('usuarios_portal as U', 'U.id = B.id_usuario')
            ->join('datos_generales as GENUP', 'GENUP.id = U.id_usuario')
            ->where('B.id_portal', $id_portal)
            ->where($condition_area, $area)
            ->where($filterApplicant, $filter)
            ->where($condition_applicant, $id_applicant)
            ->where('B.id_usuario', $id_usuario)
            ->order_by('B.id', $sort);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getRequisicionesActivas()
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("R.*, C.nombre as nombreCompleto")
            ->from('requisicion as R')
            ->join('cliente as C', 'C.id = R.id_cliente')
            ->where('R.id_portal ', $id_portal)
            ->where('R.eliminado', 0)
            ->where_in('R.status', [1, 2])
            ->order_by('R.id', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getTestsByOrder($id)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("R.*, CL.nombre as nombreCompleto,C.id as idCandidato,CONCAT(C.nombre,' ',C.paterno,' ',C.materno) as candidato,C.status_bgc, C.fecha_nacimiento, P.antidoping, P.status_doping, P.psicometrico, P.medico, DOP.id as idDoping, DOP.fecha_resultado,DOP.resultado as resultado_doping, M.id as idMedico, M.conclusion as conclusionMedica, PSI.id as idPsicometrico, PSI.archivo as archivoPsicometria ")
            ->from('requisicion as R')
            ->join('cliente as CL', 'CL.id= R.id_cliente')

            ->join('requisicion_aspirante as A', 'A.id_requisicion = R.id')
            ->join('candidato as C', 'C.id_aspirante = A.id')
            ->join('candidato_pruebas as P', 'P.id_candidato = C.id')
            ->join('doping as DOP', 'DOP.id_candidato = C.id', 'left')
            ->join('medico as M', 'M.id_candidato = C.id', 'left')
            ->join('psicometrico as PSI', 'PSI.id_candidato = C.id', 'left')
            ->where('R.id_portal ', $id_portal)
            ->where('P.socioeconomico', 1)
            ->where('R.id', $id)
            ->order_by('C.creacion', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getRequisionById($id)
    {
        $id_portal = $this->session->userdata('idPortal');

        // Asegúrate de que el valor de $id_portal es correcto
        if (!$id_portal) {
            return null; // O manejar el caso según sea necesario
        }

        $this->db
            ->select("R.*, CL.id_datos_generales, CL.id_datos_facturacion, CL.id_domicilios, CL.nombre as nombre,
							FAC.razon_social, GEN.telefono, GEN.correo,
							DOM.pais, DOM.estado, DOM.ciudad, DOM.colonia, DOM.calle, DOM.exterior, DOM.interior, DOM.cp,
							CONCAT('País: ', DOM.pais, ', ',
									'Estado: ', DOM.estado, ', ',
									'Ciudad: ', DOM.ciudad, ', ',
									'Colonia: ', DOM.colonia, ', ',
									'Calle: ', DOM.calle, ', ',
									'Número Exterior: ', DOM.exterior, ', ',
									'CP: ', DOM.cp) as domicilio,
							CONCAT(GEN.nombre, ' ', GEN.paterno) as contacto, FAC.forma_pago, FAC.metodo_pago, FAC.uso_cfdi as uso_cfdi, FAC.rfc, FAC.regimen")
            ->from('requisicion as R')
            ->join('usuarios_portal as USP', 'USP.id = R.id_usuario', 'left')
            ->join('cliente as CL', 'CL.id = R.id_cliente', 'left')
            ->join('domicilios as DOM', 'DOM.id = CL.id_domicilios', 'left')
            ->join('datos_facturacion as FAC', 'CL.id_datos_facturacion = FAC.id', 'left')
            ->join('datos_generales as GEN', 'GEN.id = CL.id_datos_generales', 'left')
            ->where('R.id', $id)
            ->where('R.id_portal', $id_portal);

        $consulta = $this->db->get();

        // Debug: Imprime la consulta SQL para verificar

        return $consulta->row();
    }
    /*----------------------------------------*/
    /*    Acciones
    /*----------------------------------------*/
    public function cambiarStatusrequisicion($id, $status)
    {
        if (!$id || empty($status)) {
            // Verificar si se proporcionan los datos necesarios
            return "Error: Datos insuficientes para la actualización.";
        }
        //    echo "aqui status : ".$status['status'];
        try {
            $this->db
                ->set('id_usuario', $status['id_usuario'])
                ->set('status', $status['status'])
                ->where('id', $id)
                ->update('requisicion');

            if ($this->db->affected_rows() == 0) {
                // Verificar si la actualización fue exitosa
                return "Error: No se pudo actualizar la requisición.";
            }
            if ($status['status'] == 1) {
                return "La requisición se detuvo correctamente.";
            } else {
                return "La requisición se inicio correctamente.";
            }
        } catch (Exception $e) {
            // Manejar excepciones
            return "Error al actualizar la requisición: " . $e->getMessage();
        }
    }

    public function reactivarRequisicion($id, $id_usuario)
    {
        // Obtener los datos de la requisición con el ID proporcionado
        $requisicion = $this->db->get_where('requisicion', array('id' => $id))->row_array();

        // Generar una copia de la requisición con un nuevo ID
        unset($requisicion['id']); // Eliminar el ID para generar un nuevo ID automático
        $requisicion['id_usuario'] = $id_usuario; // Establecer el nuevo ID de usuario
        $requisicion['status'] = 1; // Establecer el estado activo
        // Puedes establecer el comentario final aquí si lo necesitas
        $requisicion['comentario_final'] = ''; // Por ejemplo, establecer un comentario vacío

        // Insertar la nueva requisición en la tabla
        $this->db->insert('requisicion', $requisicion);
    }

    //TODO: revisar   si estas  tres  funciones   se usan en ontra parte  ya  que se creo una   que  realiza  los tres cambios   se llama RegistrarMovimiento

    public function editarAspirante($datos, $id)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->where('id', $id)
            ->update('requisicion_aspirante', $datos);
    }

    public function guardarAccionRequisicion($datos)
    {
        $this->db->insert('requisicion_historial', $datos);
    }

    public function editBolsaTrabajo($datos, $id)
    {
        $this->db
            ->where('id', $id)
            ->update('bolsa_trabajo', $datos);
    }

    public function registrarMovimiento($datos_accion, $datos_aspirante, $datos_bolsa, $id_bolsa_trabajo, $id_aspirante)
    {
        // Iniciar transacción
        $this->db->trans_begin();

        // Guardar acción de requisición
        $this->db->insert('requisicion_historial', $datos_accion);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }

        // Editar aspirante
        $this->db->where('id', $id_aspirante);
        $this->db->update('requisicion_aspirante', $datos_aspirante);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }

        // Editar bolsa de trabajo
        $this->db->where('id', $id_bolsa_trabajo);
        $this->db->update('bolsa_trabajo', $datos_bolsa);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }

        // Confirmar transacción
        $this->db->trans_commit();
        return true;
    }
    
    public function registrarNuevaAccion($datos)
    {
        $this->db->insert('cat_accion_requisicion', $datos);
        // Devuelve el ID de la fila insertada
        return $this->db->insert_id();
    }
    public function eliminarMovimiento($id){
        $this->db->where('id', $id);
        return $this->db->delete('requisicion_historial'); 

    }

    public function addApplicant($datos)
    {
        $this->db->insert('requisicion_aspirante', $datos);
        // Devuelve el ID de la fila insertada
        return $this->db->insert_id();
    }

    public function existeRegistro($id_bolsa_trabajo, $id_requisicion)
    {
        // Construye la consulta para verificar si ya existe un registro con los mismos ids
        $this->db->where('id_bolsa_trabajo', $id_bolsa_trabajo);
        $this->db->where('id_requisicion', $id_requisicion);
        $query = $this->db->get('requisicion_aspirante');

        // Retorna true si existe al menos un registro, false en caso contrario
        return $query->num_rows() > 0;
    }

    public function editarRequisicion($datos, $id)
    {
        $this->db
            ->where('id', $id)
            ->update('requisicion', $datos);
    }

    public function tieneAspiranteCV($id_aspirante)
    {
        $this->db
            ->select("A.cv")
            ->from('requisicion_aspirante as A')
            ->where('id', $id_aspirante);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }

    public function editarDatosAspiranteBolsa($datos_bolsa, $id_bolsa, $datos_aspirante, $id_aspirante)
    {
        // Iniciar transacción
        $this->db->trans_start();

        // Actualizar datos de la bolsa de trabajo
        $this->db->where('id', $id_bolsa)->update('bolsa_trabajo', $datos_bolsa);

        // Actualizar datos del aspirante
        $this->db->where('id', $id_aspirante)->update('requisicion_aspirante', $datos_aspirante);

        // Completar la transacción
        $this->db->trans_complete();

        // Verificar si la transacción se completó con éxito
        if ($this->db->trans_status() === false) {
            // Si hay algún error, hacer rollback
            $this->db->trans_rollback();
            return false; // Devolver false indicando que la transacción falló
        } else {
            // Si todo salió bien, hacer commit
            $this->db->trans_commit();
            return true; // Devolver true indicando que la transacción se completó con éxito
        }
    }

    public function guardarHistorialBolsaTrabajo($datos)
    {
        $this->db->insert('bolsa_trabajo_historial', $datos);
        // Devuelve TRUE si se insertaron filas, FALSE en caso contrario
        return $this->db->affected_rows() > 0;
    }

    public function addRequisicion($id_cliente, $cliente, $domicilios, $generales, $facturacion, $req)
    {
        // Iniciar transacción
        /*    echo "Aquí el id del cliente: " . $id_cliente . PHP_EOL;
        echo "Aquí el cliente: ";
        var_dump($cliente);
        echo "Aquí los domicilios: ";
        var_dump($domicilios);
        echo "Aquí los datos generales: ";
        var_dump($generales);
        echo "Aquí los datos de facturación: ";
        var_dump($facturacion);
        echo "Aquí la nueva requisición: ";
        var_dump($req);
        die();*/
        $id_portal = $this->session->userdata('idPortal');
        $req['id_portal'] = $id_portal;

        $this->db->trans_start();

        try {
            // Paso 1: Actualizar los datos del cliente
            $this->db->where('id', $id_cliente);
            $this->db->update('cliente', $cliente);

            // Paso 2: Obtener y actualizar los datos generales del cliente

            $id_datos_generales = $this->generales_model->obtenerIdDatosGenerales($id_cliente);
            $this->generales_model->editDatosGenerales($id_datos_generales, $generales);

            // Paso 3: Obtener y actualizar los domicilios del cliente
            $id_domicilios = $this->generales_model->obtenerIdDomicilios($id_cliente);

            $this->generales_model->editDomicilios($id_domicilios, $domicilios);

            // Paso 4: Obtener y actualizar los datos de facturación del cliente
            $id_datos_facturacion = $this->generales_model->obtenerIdDatosFacturacion($id_cliente);

            $this->generales_model->editDatosFacturacion($id_datos_facturacion, $facturacion);

            // Paso 5: Insertar la nueva requisición

            //print_r($req);
            $this->db->insert('requisicion', $req);
            $resultado = $this->db->insert_id();
            // Commit de la transacción
            $this->db->trans_commit();
            // Se ejecutó correctamente
            return $resultado;
        } catch (Exception $e) {
            // Rollback de la transacción en caso de error
            $this->db->trans_rollback();
            return []; // Hubo un error
        }
    }


    public function traerNombreCV($id)
    {
        // Ejecuta la consulta para obtener el nombre del archivo
        $this->db->select('archivo');
        $this->db->from('candidato_documento');
        $this->db->where('id_requisicion_aspirante', $id);
        $query = $this->db->get();

        // Verifica si se encontraron resultados
        if ($query->num_rows() > 0) {
            // Obtiene el nombre del archivo
            $row = $query->row();
            $nombreArchivo = $row->archivo;
            return $nombreArchivo;
        } else {
            // Si no se encontraron resultados, devuelve NULL o un mensaje de error, según sea necesario
            return null; // O devuelve un mensaje de error
        }
    }

    public function addRequsicionCompleta($req)
    {
        $this->db->insert('requisicion', $req);
    }

    public function updateOrder($data, $id)
    {
        $this->db
            ->where('id', $id)
            ->update('requisicion', $data);
    }
    public function updateOrderGenerales($data, $id)
    {
        $this->db
            ->where('id', $id)
            ->update('datos_generales', $data);
    }

    public function updateOrderFacturacion($data, $id)
    {
        $this->db
            ->where('id', $id)
            ->update('datos_facturacion', $data);
    }

    public function addBolsaTrabajo($data)
    {
        $this->db->insert('bolsa_trabajo', $data);
    }
    public function addJobPoolWithIdReturned($data)
    {
        $this->db->insert('bolsa_trabajo', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function updateApplicantByIdBolsaTrabajo($datos, $id)
    {
        $this->db
            ->where('id', $id)
            ->update('bolsa_trabajo', $datos);
    }

    public function addWarrantyApplicant($data)
    {
        $this->db->insert('aspirante_garantia', $data);
    }
    /*----------------------------------------*/
    /*    #requisicion_usuario
    /*----------------------------------------*/
    public function getUsersOrder($id_requisicion)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("RU.id, RU.id_requisicion, CONCAT(GEN.nombre,' ',GEN.paterno) as usuario")
            ->from('requisicion_usuario as RU')
            ->join('requisicion as R', 'RU.id_requisicion = R.id', 'left')
            ->join('usuarios_portal as U', 'U.id = RU.id_usuario', 'left')
            ->join('datos_generales AS GEN', 'U.id_datos_generales = GEN.id', 'left')
            ->where('R.id_portal', $id_portal)

            ->where_in('R.id', $id_requisicion)
            ->order_by('GEN.nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function addUsersToOrder($data)
    {
        $this->db->insert('requisicion_usuario', $data);
    }
    public function deleteUserOrder($id)
    {
        $this->db
            ->where('id', $id)
            ->delete('requisicion_usuario');
    }
    /*----------------------------------------*/
    /*    Consultas
    /*----------------------------------------*/
    public function getDetailsOrderById($id)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("R.*, FAC.*,CL.id_datos_generales, CL.id_datos_facturacion, CL.id_domicilios,  CL.nombre as nombre,
		FAC.razon_social ,
		DOM.pais, DOM.estado,  DOM.ciudad,  DOM.colonia, DOM.calle,  DOM.exterior,  DOM.interior,  DOM.cp,
		DOM.cp as cp, GEN.telefono as telefono, GEN.correo as correo,
		CONCAT(GEN.nombre, ' ', GEN.paterno) as contacto, FAC.forma_pago, FAC.metodo_pago , FAC.uso_cfdi as uso_cfdi, FAC.rfc, FAC.regimen ")
            ->from('requisicion as R')
            ->join('cliente as CL', 'CL.id =  R.id_cliente')
            ->join('domicilios as DOM', 'DOM.id = CL.id_domicilios')
            ->join('datos_facturacion as FAC', 'CL.id_datos_facturacion = FAC.id')
            ->join('datos_generales as GEN', 'GEN.id = CL.id_datos_generales')
            ->where('R.id_portal', $id_portal)

            ->where('R.id', $id);

        $consulta = $this->db->get();
        return $consulta->row();
    }
    public function getHistorialAspirante($id, $campo)
    {

        $this->db
            ->select("H.*,CL.nombre")
            ->from('requisicion_historial as H')
            ->join('requisicion as R', 'R.id = H.id_requisicion')
            ->join('cliente as CL', 'CL.id = R.id_cliente')

            ->where('H.' . $campo, $id)
            ->order_by('H.id', 'DESC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getAspirantesRequisiciones($id_usuario, $condicion)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("A.*, CONCAT(BT.nombre,' ',BT.paterno,' ',BT.materno) as aspirante, CONCAT(GENCL.nombre,' ',GENCL.paterno) as usuario, BT.domicilio, BT.medio_contacto, BT.area_interes,  BT.telefono,  R.id as id_req, CL.nombre as nombre_cliente, CL.clave, CL.id as id_cliente, R.puesto , H.id as idHistorial, R.numero_vacantes, BT.status AS status_aspirante, BT.semaforo")
            ->from('requisicion_aspirante as A')
            ->join('requisicion as R', 'R.id = A.id_requisicion')
            ->join('bolsa_trabajo as BT', 'BT.id = A.id_bolsa_trabajo')
            ->join('cliente as CL', 'CL.id = R.id_cliente')
            ->join('datos_generales as GENCL', 'GENCL.id = CL.id_datos_generales')
            ->join('requisicion_historial as H', 'H.id_requisicion = R.id', 'left')
            ->join('usuarios_portal as USER', 'USER.id = A.id_usuario')
        //->join('candidato as C','C.id_aspirante = A.id','left')
            ->where('R.id_portal', $id_portal)

            ->where('A.eliminado', 0)
            ->where('R.eliminado', 0)
            ->where('R.status', 2)
        //->where('C.id_aspirante', NULL)
            ->where($condicion, $id_usuario)
            ->group_by('A.id')
            ->order_by('A.id', 'DESC')
            ->order_by('A.id_requisicion', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getAspirantesRequisicionesTotal($id_usuario, $condicion)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("A.id")
            ->from('requisicion_aspirante as A')

            ->join('requisicion as R', 'R.id = A.id_requisicion')
            ->join('usuarios_portal as USPOR', 'USPOR.id = A.id_usuario')
            ->where('R.id_portal', $id_portal)
            ->where('A.eliminado', 0)
            ->where('R.status', 2)
            ->where($condicion, $id_usuario);

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getAspirantesPorRequisicion($id_usuario, $condicion, $id)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("A.*, CONCAT(BT.nombre,' ',BT.paterno,' ',BT.materno) as aspirante, CONCAT(DATCL.nombre,' ',DATCL.paterno) as usuario, CL.nombre as empresa,R.puesto,
			R.numero_vacantes, BT.status AS status_aspirante, BT.semaforo")
            ->from('requisicion_aspirante as A')
            ->join('bolsa_trabajo as BT', 'BT.id = A.id_bolsa_trabajo')
            ->join('requisicion as R', 'R.id = A.id_requisicion')
            ->join('cliente as CL', ' CL.id = R.id_cliente')
            ->join('datos_generales as DATCL', 'DATCL.id = CL.id_datos_generales')
            ->join('usuarios_portal as USPOR', 'USPOR.id = A.id_usuario')
            ->join('datos_generales as DATUP', 'DATUP.id = USPOR.id_datos_generales')
            ->where('R.id_portal', $id_portal)
            ->where('A.id_requisicion', $id)
            ->where('R.status', 2)
            ->where($condicion, $id_usuario)
            ->group_by('A.id')
            ->order_by('A.id', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getAspirantesPorRequisicionTotal($id_usuario, $condicion, $id)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("A.id")
            ->from('requisicion_aspirante as A')
            ->join('requisicion as R', 'R.id = A.id_requisicion')
            ->join('usuarios_portal as USER', 'USER.id = A.id_usuario')
            ->where('R.id_portal', $id_portal)
            ->where('R.status', 2)
            ->where('A.id_requisicion', $id)
            ->where($condicion, $id_usuario);

        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getRequisicionesFinalizadas($id_usuario, $condicion)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("R.id, CL.nombre, R.puesto, R.numero_vacantes, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario")
            ->from('requisicion as R')
            ->join('usuarios_portal as U', 'U.id = R.id_usuario', 'left')
            ->join('datos_generales as GENUS', 'GENUS.id = U.id_datos_generales')
            ->join('cliente as CL', 'CL.id = R.id_cliente')
            ->join('datos_generales as GENCL', 'GENCL.id = CL.id_datos_generales')
            ->where('R.id_portal', $id_portal)
            ->where('R.eliminado', 0)
            ->where_in('R.status', [0, 3])
            ->where($condicion, $id_usuario)
            ->order_by('R.status', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getAspirantesRequisicionesFinalizadas($id_usuario, $condicion)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("A.*, CONCAT(BT.nombre,' ',BT.paterno,' ',BT.materno) as aspirante, CONCAT(GENCL.nombre,' ',GENCL.paterno) as usuario, CL.nombre as empresa,R.puesto, H.id as idHistorial,R.numero_vacantes, C.id_aspirante as idCandidato, C.status_bgc, R.comentario_final, R.status as statusReq")
            ->from('requisicion_aspirante as A')
            ->join('requisicion as R', 'R.id = A.id_requisicion')
            ->join('bolsa_trabajo as BT', 'BT.id = A.id_bolsa_trabajo')
            ->join('cliente as CL', 'CL.id = R.id_cliente')
            ->join('datos_generales as GENCL', 'GENCL.id = CL.id_datos_generales')
            ->join('requisicion_historial as H', 'H.id_requisicion = R.id', 'left')
            ->join('usuarios_portal as USER', 'USER.id = A.id_usuario')
            ->join('candidato as C', 'C.id_aspirante = A.id', 'left')
            ->where('R.id_portal', $id_portal)
            ->where('A.eliminado', 0)
            ->where_in('R.status', [0, 3])
            ->where($condicion, $id_usuario)
            ->group_by('A.id')
            ->order_by('A.id', 'DESC')
            ->order_by('A.id_requisicion', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getAspirantesRequisicionesFinalizadasTotal($id_usuario, $condicion)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("A.id")
            ->from('requisicion_aspirante as A')
            ->join('requisicion as R', 'R.id = A.id_requisicion')
            ->join('usuarios_portal as USPOR', 'USPOR.id = A.id_usuario')
            ->where('R.id_portal', $id_portal)
            ->where('A.eliminado', 0)
            ->where_in('R.status', [0, 3])
            ->where($condicion, $id_usuario);

        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getAspirantesPorRequisicionesFinalizadas($id_usuario, $condicion, $id)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db->select("A.*, CONCAT(B.nombre,' ',B.paterno,' ',B.materno) as aspirante, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario, CL.nombre as empresa, R.puesto, H.id as idHistorial, R.status as statusReq, R.comentario_final")
            ->from('requisicion_aspirante as A')
            ->join('bolsa_trabajo as B', 'B.id = A.id_bolsa_trabajo')
            ->join('requisicion as R', 'R.id = A.id_requisicion')
            ->join('cliente as CL', 'CL.id = R.id_cliente')
            ->join('requisicion_historial as H', 'H.id_requisicion = R.id', 'left')
            ->join('usuarios_portal as USER', 'USER.id = A.id_usuario')
            ->join('datos_generales as GENUS', 'GENUS.id = USER.id_datos_generales')
            ->where('R.id_portal', $id_portal)
            ->where('A.id_requisicion', $id)
            ->where_in('R.status', [0, 3])
            ->where($condicion, $id_usuario)
            ->group_by('A.id')
            ->order_by('A.id', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getAspirantesPorRequisicionesFinalizadasTotal($id_usuario, $condicion, $id)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("A.id")
            ->from('requisicion_aspirante as A')
            ->join('requisicion as R', 'R.id = A.id_requisicion')
            ->join('usuarios_portal as USER', 'USER.id = A.id_usuario')
            ->where('R.id_portal', $id_portal)
            ->where_in('R.status', [0, 3])
            ->where('A.id_requisicion', $id)
            ->where($condicion, $id_usuario);

        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getBolsaTrabajoById($id)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("B.*, CONCAT(B.nombre,' ',B.paterno,' ',B.materno) as nombreCompleto")
            ->from('bolsa_trabajo as B')
            ->where('B.id_portal', $id_portal)
            ->where('id', $id);

        $consulta = $this->db->get();
        return $consulta->row();
    }
    public function getEmpleosByIdBolsaTrabajo($id)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("E.*, CONCAT(B.nombre,' ',B.paterno,' ',B.materno) as nombreCompleto")
            ->from('bolsa_trabajo_historial_empleos as E')
            ->join('bolsa_trabajo as B', 'B.id = E.id_bolsa_trabajo')
            ->where('B.id_portal', $id_portal)
            ->where('E.id_bolsa_trabajo', $id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getAspiranteById($id)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("RA.*")
            ->from('requisicion_aspirante as RA')
            ->join('requisicion as R', 'R.id = RA.id_requisicion')
            ->where('R.id_portal', $id_portal)
            ->where('RA.id', $id);

        $consulta = $this->db->get();
        return $consulta->row();
    }
    public function getVacantesCubiertasTotal($id_requisicion, $acciones)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("RA.id")
            ->from('requisicion_aspirante as RA')
            ->join('requisicion as R', 'R.id = RA.id_requisicion')
            ->where('R.id_portal', $id_portal)
            ->where('RA.id_requisicion', $id_requisicion)
            ->where('RA.sueldo_acordado !=', null)
            ->where('RA.fecha_ingreso !=', null)
            ->where_in('RA.status_final', $acciones);

        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getAspirantesByBolsaTrabajo($id_requisicion)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("B.*")
            ->from('requisicion_aspirante as R')
            ->join('bolsa_trabajo as B', 'B.id = R.id_bolsa_trabajo')
            ->where('B.id_portal', $id_portal)
            ->where('R.id_requisicion', $id_requisicion);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getAspiranteByBolsaTrabajo($id_bolsa)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("R.*")
            ->from('requisicion_aspirante as R')
            ->join('bolsa_trabajo as B', 'B.id = R.id_bolsa_trabajo')
            ->where('B.id_portal', $id_portal)
            ->where('R.id_bolsa_trabajo', $id_bolsa);

        $consulta = $this->db->get();
        return $consulta->row();
    }

    //TODO: revisar  si funciona   para  reclutamiento
    public function getCandidatosByRequisicion($id_requisicion)
    {
        $this->db
            ->select("C.id,C.id_aspirante")
            ->from('requisicion_aspirante as R')
            ->join('candidato as C', 'C.id_aspirante = R.id', 'left')
            ->where('R.id_requisicion', $id_requisicion);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getAspiranteByCandidato($id_candidato)
    {
        $this->db
            ->select("C.id,C.id_aspirante,R.id_requisicion,R.id_bolsa_trabajo")
            ->from('candidato as C')
            ->join('requisicion_aspirante as R', 'C.id_aspirante = R.id')
            ->where('C.id', $id_candidato);

        $consulta = $this->db->get();
        return $consulta->row();
    }
    public function getHistorialBolsaTrabajo($id)
    {
        $id_portal = $this->session->userdata('idPortal');
        $this->db
            ->select("BH.*, nombre_rol as usuario ")
            ->from('bolsa_trabajo_historial as BH')
            ->join('requisicion_aspirante as RA', 'RA.id = BH.id_requisicion_aspirante')

            ->where('BH.id_requisicion_aspirante', $id)
            ->order_by('BH.id', 'DESC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getBolsaTrabajoByName($nombre, $paterno, $materno, $id_portal)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("B.id")
            ->from('bolsa_trabajo as B')
            ->where('B.nombre', $nombre)
            ->where('B.paterno', $paterno)
            ->where('B.materno', $materno)
            ->where('B.id_portal', $id_portal);

        $query = $this->db->get();
        return $query->row();
    }
    public function getBolsaTrabajoByPhone($telefono, $id_portal = null)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("id")
            ->from('bolsa_trabajo')
            ->where('telefono', $telefono)
            ->where('id_portal', $id_portal);

        $query = $this->db->get();
        return $query->row();
    }
    public function getWarrantyApplicant($id)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("A.*, CONCAT(GENUP.nombre,' ',GENUP.paterno) as usuario ")
            ->from('aspirante_garantia as A')
            ->join('usuarios_portal as U', 'U.id = A.id_usuario')
            ->join('datos_generales as GENUP', 'GENUP.id = U.id_datos_generales')
            ->where('U.id_portal', $id_portal)
            ->where('A.id_aspirante', $id)
            ->order_by('A.id', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getAllJobPoolByArea()
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("B.*")
            ->from('bolsa_trabajo as B')
            ->where('B.id_portal', $id_portal)

            ->group_by('B.area_interes');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function matchCliente($term)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select('CL.id, CL.nombre')
            ->from('cliente as CL')
            ->where('CL.id_portal', $id_portal)
            ->where("CL.status", 1)
            ->where("CL.eliminado", 0)
            ->like("CL.nombre", $term, 'after')
            ->order_by('CL.nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['value'] = $row['id'];
                $new_row['label'] = $row['nombre'];
                $row_set[] = $new_row; //build an array
            }
            return $row_set; //format the array into json data
        }
    }
}
