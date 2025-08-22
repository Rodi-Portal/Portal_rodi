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
            ->select("
            R.id AS idReq,
            R.creacion AS creacionReq,
            RI.*,
            COALESCE(RI.telefono, 'N/A') AS telIntake,
            COALESCE(CL.nombre, 'No Asignado') AS nombre_cliente,
            CASE
                WHEN CL.id IS NULL THEN 'No Asignado'
                ELSE TRIM(CONCAT_WS(' ',
                        COALESCE(GENCL.nombre, 'N/A'),
                        COALESCE(GENCL.paterno, 'N/A')
                ))
            END AS contacto,

            CASE
                WHEN CL.id IS NULL THEN 'N/A'
                ELSE COALESCE(GENCL.telefono, 'N/A')
            END AS telefono_cliente,

            CASE
                WHEN CL.id IS NULL THEN 'N/A'
                ELSE COALESCE(GENCL.correo, 'N/A')
            END AS correo_cliente,


            R.puesto,
            R.numero_vacantes,
            R.status,
            R.tipo,


            CASE
                WHEN U.id IS NULL THEN 'N/A'
                ELSE TRIM(CONCAT_WS(' ',
                        COALESCE(GENUS.nombre, ''),
                        COALESCE(GENUS.paterno, '')
                ))
            END AS usuario
        ")
            ->from('requisicion AS R')
            ->join('usuarios_portal AS U', 'U.id = R.id_usuario', 'left')
            ->join('requisicion_intake AS RI', 'RI.id = R.id_intake', 'left')
            ->join('datos_generales AS GENUS', 'U.id_datos_generales = GENUS.id', 'left')
            ->join('cliente AS CL', 'R.id_cliente = CL.id', 'left')
            ->join('datos_generales AS GENCL', 'CL.id_datos_generales = GENCL.id', 'left')
            ->where('R.id_portal', $id_portal)
            ->where_in('R.status', [1, 2])
            ->where($condition_order, $id_order)
            ->where('R.eliminado', 0)
            ->order_by('R.id', $sort);

        // OJO: si $filter puede ser 0, empty() lo tratará como vacío. Ajusta si lo necesitas.
        if ($filter !== '' && $filter !== null && isset($filterOrder)) {
            $this->db->where($filterOrder, $filter);
        }

        $query = $this->db->get();

        return $query->num_rows() > 0 ? $query->result() : false;
    }

    public function getOrdersByUser($id_usuario, $sort, $id_order, $condition_order)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("
            R.id AS idReq,
            R.creacion AS creacionReq,
            RI.*,
            COALESCE(RI.telefono, 'N/A') AS telIntake,

            COALESCE(CL.nombre, 'No Asignado') AS nombre_cliente,

            CASE
                WHEN CL.id IS NULL THEN 'No Asignado'
                ELSE TRIM(CONCAT_WS(' ',
                        COALESCE(GENCL.nombre, 'N/A'),
                        COALESCE(GENCL.paterno, 'N/A')
                ))
            END AS contacto,

            CASE
                WHEN CL.id IS NULL THEN 'N/A'
                ELSE COALESCE(GENCL.telefono, 'N/A')
            END AS telefono_cliente,

            CASE
                WHEN CL.id IS NULL THEN 'N/A'
                ELSE COALESCE(GENCL.correo, 'N/A')
            END AS correo_cliente,

            R.puesto,
            R.numero_vacantes,
            R.status,
            R.tipo,

            CASE
                WHEN U.id IS NULL THEN 'N/A'
                ELSE TRIM(CONCAT_WS(' ',
                        COALESCE(GENUS.nombre, ''),
                        COALESCE(GENUS.paterno, '')
                ))
            END AS usuario,

            COALESCE(FAC.razon_social, 'N/A') AS nombre_comercial
        ")
            ->from('requisicion AS R')
            ->join('requisicion_intake AS RI', 'RI.id = R.id_intake', 'left')
            ->join('usuarios_portal AS U', 'U.id = R.id_usuario')
            ->join('cliente AS CL', 'CL.id = R.id_cliente', 'left')
            ->join('datos_facturacion AS FAC', 'FAC.id = CL.id_datos_facturacion', 'left')
            ->join('datos_generales AS GENCL', 'GENCL.id = CL.id_datos_generales', 'left')
            ->join('requisicion_usuario AS RU', 'RU.id_requisicion = R.id')
            ->join('datos_generales AS GENUS', 'GENUS.id = U.id_datos_generales', 'left')
            ->where_in('R.status', [1, 2])
            ->where('RU.id_usuario', $id_usuario)
            ->where('R.id_portal', $id_portal) // 👈 cambio aquí, porque si CL es NULL no existirá CL.id_portal
            ->where($condition_order, $id_order)
            ->order_by('R.id', $sort)
            ->group_by('R.id');

        $query = $this->db->get();
        return $query->num_rows() > 0 ? $query->result() : false;
    }

    public function getRequisicionesEnProceso($id_usuario, $condicion)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("
            R.id AS idReq,
            R.creacion AS creacionReq,

            RI.*,
            COALESCE(RI.telefono, 'N/A') AS telIntake,

            COALESCE(CL.nombre, 'No Asignado') AS nombre_cliente,
            CASE
                WHEN CL.id IS NULL THEN 'No Asignado'
                ELSE TRIM(CONCAT_WS(' ',
                    COALESCE(GENCL.nombre, 'N/A'),
                    COALESCE(GENCL.paterno, 'N/A')
                ))
            END AS contacto,
            CASE WHEN CL.id IS NULL THEN 'N/A' ELSE COALESCE(GENCL.telefono, 'N/A') END AS telefono_cliente,
            CASE WHEN CL.id IS NULL THEN 'N/A' ELSE COALESCE(GENCL.correo,   'N/A') END AS correo_cliente,

            R.puesto,
            R.numero_vacantes,

            CASE
                WHEN U.id IS NULL THEN 'N/A'
                ELSE TRIM(CONCAT_WS(' ',
                    COALESCE(GENUS.nombre, ''),
                    COALESCE(GENUS.paterno, '')
                ))
            END AS usuario
        ")
            ->from('requisicion AS R')
            ->join('requisicion_usuario AS RU', 'RU.id_requisicion = R.id')
            ->join('usuarios_portal AS U', 'U.id = RU.id_usuario')                // <— alias correcto
            ->join('datos_generales AS GENUS', 'GENUS.id = U.id_datos_generales') // <— ahora sí existe U
            ->join('requisicion_intake AS RI', 'RI.id = R.id_intake', 'left')     // <— INTAKE
            ->join('cliente AS CL', 'CL.id = R.id_cliente', 'left')               // <— cliente null-safe
            ->join('datos_generales AS GENCL', 'GENCL.id = CL.id_datos_generales', 'left')

            ->where('R.id_portal', $id_portal)
            ->where('R.eliminado', 0)
            ->where('R.status', 2)
            ->where($condicion, $id_usuario) // Ej: 'RU.id_usuario'
            ->order_by('R.status', 'ASC')
            ->group_by('R.id'); // evita duplicados por RU/intake

        $query = $this->db->get();
        return $query->num_rows() > 0 ? $query->result() : false;
    }

    public function getOrdersInProcessByUser($id_usuario)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("
            R.id AS idReq,
            R.creacion AS creacionReq,

        
            RI.*,
            COALESCE(RI.telefono, 'N/A') AS telIntake,

            COALESCE(CL.nombre, 'No Asignado') AS nombre_cliente,
            CASE
                WHEN CL.id IS NULL THEN 'No Asignado'
                ELSE TRIM(CONCAT_WS(' ',
                    COALESCE(GENCL.nombre, 'N/A'),
                    COALESCE(GENCL.paterno, 'N/A')
                ))
            END AS contacto,
            CASE WHEN CL.id IS NULL THEN 'N/A' ELSE COALESCE(GENCL.telefono, 'N/A') END AS telefono_cliente,
            CASE WHEN CL.id IS NULL THEN 'N/A' ELSE COALESCE(GENCL.correo,   'N/A') END AS correo_cliente,

            R.puesto,
            R.numero_vacantes,

            TRIM(CONCAT_WS(' ', COALESCE(GENUS.nombre,''), COALESCE(GENUS.paterno,''))) AS usuario
        ")
            ->from('requisicion AS R')
            ->join('requisicion_usuario AS RU', 'RU.id_requisicion = R.id')
            ->join('usuarios_portal AS U', 'U.id = RU.id_usuario')
            ->join('datos_generales AS GENUS', 'GENUS.id = U.id_datos_generales')

            ->join('requisicion_intake AS RI', 'RI.id = R.id_intake', 'left') // <— INTAKE

            ->join('cliente AS CL', 'CL.id = R.id_cliente', 'left')
            ->join('datos_generales AS GENCL', 'GENCL.id = CL.id_datos_generales', 'left')

            ->where('R.eliminado', 0)
            ->where('R.status', 2)
            ->where('R.id_portal', $id_portal)
            ->where('RU.id_usuario', $id_usuario)

            ->group_by('R.id')
            ->order_by('R.status', 'ASC');

        $query = $this->db->get();
        return $query->num_rows() ? $query->result() : false;
    }
    public function existsRequisitionInPortal(int $idReq, int $id_portal): bool
    {
        if ($idReq <= 0 || $id_portal <= 0) {
            return false;
        }

        return (bool) $this->db->select('id')
            ->from('requisicion')
            ->where('id', $idReq)
            ->where('id_portal', $id_portal)
            ->limit(1)
            ->get()->row();
    }

    public function getAllOrdersInProcess()
    {
        $id_portal = $this->session->userdata('idPortal');

        try {
            $this->db
                ->select("
                        R.id            AS idReq,
                        R.creacion      AS creacionReq,

                        RI.*,
                        COALESCE(RI.telefono, 'N/A') AS telIntake,

                        COALESCE(CL.nombre, 'No Asignado') AS nombre_cliente,
                        CASE
                            WHEN CL.id IS NULL THEN 'No Asignado'
                            ELSE TRIM(CONCAT_WS(' ',
                                COALESCE(GENCL.nombre, 'N/A'),
                                COALESCE(GENCL.paterno, 'N/A')
                            ))
                        END AS contacto,
                        CASE WHEN CL.id IS NULL THEN 'N/A' ELSE COALESCE(GENCL.telefono, 'N/A') END AS telefono_cliente,
                        CASE WHEN CL.id IS NULL THEN 'N/A' ELSE COALESCE(GENCL.correo,   'N/A') END AS correo_cliente,
                        CASE WHEN R.puesto IS NULL THEN 'Asistente Virtual' ELSE COALESCE(R.puesto,   'Asistente Virtual') END AS puesto,

                        R.numero_vacantes,
                        R.status,
                        R.tipo,

                        CASE
                            WHEN U.id IS NULL THEN 'N/A'
                            ELSE TRIM(CONCAT_WS(' ',
                                COALESCE(GENUS.nombre, ''),
                                COALESCE(GENUS.paterno, '')
                            ))
                        END AS usuario
                    ")
                ->from('requisicion AS R')
                ->join('usuarios_portal AS U', 'U.id = R.id_usuario', 'left')
                ->join('datos_generales AS GENUS', 'GENUS.id = U.id_datos_generales', 'left')

                ->join('requisicion_intake AS RI', 'RI.id = R.id_intake', 'left')

                ->join('cliente AS CL', 'CL.id = R.id_cliente', 'left')
                ->join('datos_generales AS GENCL', 'GENCL.id = CL.id_datos_generales', 'left')

                ->where('R.eliminado', 0)
                ->where('R.status', 2)
                ->where('R.id_portal', $id_portal)
                ->order_by('R.id', 'DESC')
                ->group_by('R.id'); // evita duplicados si hay joins opcionales

            $query = $this->db->get();

            return $query->num_rows() > 0 ? $query->result() : [];
        } catch (Exception $e) {
            log_message('error', 'Error en getAllOrdersInProcess(): ' . $e->getMessage());
            return [];
        }
    }

    public function getAllApplicants($id_usuario, $condition)
    {
        $id_portal = $this->session->userdata('idPortal');

        $this->db
            ->select("B.*,  TRIM(
            CONCAT(
                B.nombre, ' ',
                COALESCE(B.paterno, ''), ' ',
                COALESCE(B.materno, '')
            )
        ) as nombreCompleto, CONCAT(gen.nombre,' ',gen.paterno) as usuario")
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
            ->select("B.*, TRIM(
            CONCAT(
                B.nombre, ' ',
                COALESCE(B.paterno, ''), ' ',
                COALESCE(B.materno, '')
            )
        ) as nombreCompleto, CONCAT(gen.nombre,' ',gen.paterno) as usuario")
            ->from('bolsa_trabajo as B')
            ->join('usuarios_portal as U', 'U.id = B.id_usuario', 'left')
            ->join('datos_generales as gen', 'gen.id = U.id_datos_generales', 'left')
            ->where('B.id_portal', $id_portal);

        // Filtros dinámicos solo si vienen
        if (! empty($condition_area) && ! empty($area)) {
            $this->db->where($condition_area, $area);
        }
        if (! empty($filterApplicant) && ! empty($filter)) {
            $this->db->where($filterApplicant, $filter);
        }
        if (! empty($condition_applicant) && ! empty($id_applicant)) {
            $this->db->where($condition_applicant, $id_applicant);
        }
        if (! empty($condition_user) && ! empty($id_usuario)) {
            $this->db->where($condition_user, $id_usuario);
        }

        $this->db->order_by('B.id', $sort);

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
            ->select("B.*,  TRIM(
            CONCAT(
                B.nombre, ' ',
                COALESCE(B.paterno, ''), ' ',
                COALESCE(B.materno, '')
            )
        ) as  nombreCompleto, CONCAT(GENUP.nombre,' ',GENUP.paterno) as usuario")
            ->from('bolsa_trabajo as B')
            ->join('usuarios_portal as U', 'U.id = B.id_usuario')
            ->join('datos_generales as GENUP', 'GENUP.id = U.id_usuario')
            ->where('B.id_portal', $id_portal);

        // Aplica los filtros solo si llegan
        if (! empty($condition_area) && ! empty($area)) {
            $this->db->where($condition_area, $area);
        }
        if (! empty($filterApplicant) && ! empty($filter)) {
            $this->db->where($filterApplicant, $filter);
        }
        if (! empty($condition_applicant) && ! empty($id_applicant)) {
            $this->db->where($condition_applicant, $id_applicant);
        }
        if (! empty($id_usuario)) {
            $this->db->where('B.id_usuario', $id_usuario);
        }

        $this->db->order_by('B.id', $sort);

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
        if (! $id_portal) {
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
    public function get_active_links()
    {
        // Tomamos el idPortal de la sesión
        $idPortal = (int) $this->session->userdata('idPortal');

        // Consulta
        $this->db->select('c.nombre, lc.link, lc.qr');
        $this->db->from('cliente c');
        $this->db->join('links_clientes lc', 'lc.id_cliente = c.id', 'inner');
        $this->db->where('c.id_portal', $idPortal);
        $this->db->order_by('c.nombre', 'ASC');

        $query = $this->db->get();

        // Retornamos resultado como arreglo
        return $query->result_array();
    }

    /*----------------------------------------*/
    /*    lINKS CANDIDATOS
    /*----------------------------------------*/
    // Inserta o actualiza por id_empleado (requiere UNIQUE o INDEX en id_empleado)
    public function upsertLinkEmpleado(int $id_empleado, string $link, ?string $qr_base64 = null): bool
    {
        // Si tu tabla tiene UNIQUE(id_empleado), este ON DUPLICATE es perfecto.
        $sql = "INSERT INTO links_empleados (id_empleado, link, qr, creacion, edicion)
                VALUES (?, ?, ?, NOW(), NOW())
                ON DUPLICATE KEY UPDATE
                    link = VALUES(link),
                    qr   = VALUES(qr),
                    edicion = NOW()";

        // Si NO tienes UNIQUE(id_empleado), agrega uno:
        // ALTER TABLE links_empleados ADD UNIQUE KEY uq_id_empleado (id_empleado);

        return (bool) $this->db->query($sql, [$id_empleado, $link, $qr_base64]);
    }

    public function getByEmpleado(int $id_empleado)
    {
        return $this->db->where('id_empleado', $id_empleado)
            ->where('eliminado', 0)
            ->get('links_empleados')
            ->row();
    }

    public function deleteByEmpleado(int $id_empleado): bool
    {
        return (bool) $this->db->where('id_empleado', $id_empleado)
            ->delete('links_empleados');
    }

    /*----------------------------------------*/
    /*    Acciones
    /*----------------------------------------*/
    public function cambiarStatusrequisicion($id, $status)
    {
        if (! $id || empty($status)) {
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
        $requisicion = $this->db->get_where('requisicion', ['id' => $id])->row_array();

                                                  // Generar una copia de la requisición con un nuevo ID
        unset($requisicion['id']);                // Eliminar el ID para generar un nuevo ID automático
        $requisicion['id_usuario'] = $id_usuario; // Establecer el nuevo ID de usuario
        $requisicion['status']     = 1;           // Establecer el estado activo
                                                  // Puedes establecer el comentario final aquí si lo necesitas
        $requisicion['comentario_final'] = '';    // Por ejemplo, establecer un comentario vacío

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
    public function eliminarMovimiento($id)
    {
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

        $consulta  = $this->db->get();
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
        $id_portal        = $this->session->userdata('idPortal');
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
            $row           = $query->row();
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
    // application/models/Reclutamiento_model.php
    public function updateIntakeByReq($idReq, array $data)
    {
        if (! $idReq) {
            return false;
        }

        // Asegura el portal del usuario
        $id_portal = $this->session->userdata('idPortal');

        // 1) Busca el id_intake asociado a la requisición
        $row = $this->db->select('R.id_intake')
            ->from('requisicion AS R')
            ->join('cliente AS CL', 'CL.id = R.id_cliente', 'left')
            ->where('R.id', $idReq)
            ->where('R.id_portal', $id_portal) // mismo criterio que usas en SELECTs
            ->get()->row();

        if (! $row) {
            return false;
        }

        $idIntake = (int) $row->id_intake;
        if (! $idIntake) {
            // si no hay intake, no actualizamos (o podrías decidir crearlo)
            return false;
        }

        // 2) Actualiza requisicion_intake
        $this->db->trans_start();
        $this->db->where('id', $idIntake)->update('requisicion_intake', $data);
        $ok = $this->db->affected_rows() >= 0; // >=0 por si no cambió nada

        // (Opcional) si quieres sincronizar algunos datos espejo:
        // - puesto/plan en requisicion
        // if (isset($data['plan']) && $data['plan'] !== '') {
        //     $this->db->where('id', $idReq)->update('requisicion', ['puesto' => $data['plan']]);
        // }

        // - teléfono/email a datos_generales del cliente (hazlo con cuidado)
        // $this->db->query("UPDATE datos_generales DG
        //     JOIN cliente CL ON CL.id_datos_generales = DG.id
        //     JOIN requisicion R ON R.id_cliente = CL.id
        //     SET DG.telefono = COALESCE(?, DG.telefono),
        //         DG.correo   = COALESCE(?, DG.correo)
        //     WHERE R.id = ?",
        //     [ $data['telefono'] ?? null, $data['email'] ?? null, $idReq ]
        // );

        $this->db->trans_complete();

        if ($this->db->trans_status() === false) {
            log_message('error', 'updateIntakeByReq TX failed: ' . $this->db->last_query());
            return false;
        }

        return $ok;
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
            ->select("RU.id , RU.id_requisicion, CONCAT(GEN.nombre,' ',GEN.paterno) as usuario")
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

    public function getDetailsOrderByIdIntake($id)
    {
        $id       = (int) $id; // por seguridad
        $idPortal = $this->session->userdata('idPortal');

        $this->db
            ->select('
            R.id AS idReq,
            RI.*,
            R.puesto,
            R.creacion AS creacionR,
            R.zona_trabajo,
            R.experiencia,
            CL.nombre AS nombre_c
        ')
            ->from('requisicion AS R')
            ->join('cliente AS CL', 'CL.id = R.id_cliente', 'left')
            ->join('requisicion_intake AS RI', 'RI.id = R.id_intake', 'left')
            ->where('R.id_portal', $idPortal)
            ->where('R.eliminado', 0)
            ->where('R.id', $id)
        // si quieres asegurar que sea intake:
            ->where('R.id_intake IS NOT NULL', null, false)
        ;

        $q = $this->db->get();
        return $q->row();
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
            ->select("
            A.*,

            TRIM(CONCAT(
                BT.nombre, ' ',
                COALESCE(BT.paterno, ''), ' ',
                COALESCE(BT.materno, '')
            )) AS aspirante,

            CASE
                WHEN USER.id IS NULL THEN 'N/A'
                ELSE TRIM(CONCAT_WS(' ',
                    COALESCE(GENUS.nombre, ''),
                    COALESCE(GENUS.paterno, '')
                ))
            END AS usuario,

            BT.domicilio,
            BT.medio_contacto,
            BT.area_interes,
            BT.telefono,

            R.id AS id_req,
            CASE
                WHEN R.puesto IS NULL THEN 'Asistente Virtual'
                ELSE COALESCE(R.puesto, 'Asistente Virtual')
            END AS puesto,
            R.numero_vacantes,

            COALESCE(CL.nombre, 'No Asignado') AS nombre_cliente,
            CL.clave,
            CL.id AS id_cliente,
            CASE
                WHEN CL.id IS NULL THEN 'No Asignado'
                ELSE TRIM(CONCAT_WS(' ',
                    COALESCE(GENCL.nombre, 'N/A'),
                    COALESCE(GENCL.paterno, 'N/A')
                ))
            END AS contacto,
            CASE WHEN CL.id IS NULL THEN 'N/A' ELSE COALESCE(GENCL.telefono, 'N/A') END AS telefono_cliente,
            CASE WHEN CL.id IS NULL THEN 'N/A' ELSE COALESCE(GENCL.correo,   'N/A') END AS correo_cliente,

            H.id AS idHistorial,

            BT.status AS status_aspirante,
            BT.semaforo
        ")
            ->from('requisicion_aspirante AS A')
            ->join('requisicion AS R', 'R.id = A.id_requisicion')
            ->join('bolsa_trabajo AS BT', 'BT.id = A.id_bolsa_trabajo')

            ->join('cliente AS CL', 'CL.id = R.id_cliente', 'left')
            ->join('datos_generales AS GENCL', 'GENCL.id = CL.id_datos_generales', 'left')

            ->join('usuarios_portal AS USER', 'USER.id = A.id_usuario', 'left')
            ->join('datos_generales AS GENUS', 'GENUS.id = USER.id_datos_generales', 'left')

            ->join('requisicion_historial AS H', 'H.id_requisicion = R.id', 'left')

            ->where('R.id_portal', $id_portal)
            ->where('A.eliminado', 0)
            ->where('R.eliminado', 0)
            ->where('R.status', 2)
            ->where($condicion, $id_usuario)

            ->group_by('A.id')
            ->order_by('A.id', 'DESC')
            ->order_by('A.id_requisicion', 'DESC');

        $query = $this->db->get();
        return $query->num_rows() ? $query->result() : false;
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
            ->select("
            A.*,

            TRIM(CONCAT(
                BT.nombre, ' ',
                COALESCE(BT.paterno, ''), ' ',
                COALESCE(BT.materno, '')
            )) AS aspirante,

            CASE
                WHEN USPOR.id IS NULL THEN 'N/A'
                ELSE TRIM(CONCAT_WS(' ',
                    COALESCE(DATUP.nombre, ''),
                    COALESCE(DATUP.paterno, '')
                ))
            END AS usuario,

            R.id AS id_req,
            CASE
                WHEN R.puesto IS NULL THEN 'Asistente Virtual'
                ELSE COALESCE(R.puesto, 'Asistente Virtual')
            END AS puesto,
            R.numero_vacantes,

            RI.*,
            COALESCE(RI.telefono, 'N/A') AS telIntake,

            COALESCE(CL.nombre, 'No Asignado') AS nombre_cliente,
            CL.clave,
            CL.id AS id_cliente,
            CASE
                WHEN CL.id IS NULL THEN 'No Asignado'
                ELSE TRIM(CONCAT_WS(' ',
                    COALESCE(GENCL.nombre, 'N/A'),
                    COALESCE(GENCL.paterno, 'N/A')
                ))
            END AS contacto,
            CASE WHEN CL.id IS NULL THEN 'N/A' ELSE COALESCE(GENCL.telefono, 'N/A') END AS telefono_cliente,
            CASE WHEN CL.id IS NULL THEN 'N/A' ELSE COALESCE(GENCL.correo,   'N/A') END AS correo_cliente,

            BT.status AS status_aspirante,
            BT.semaforo
        ")
            ->from('requisicion_aspirante AS A')
            ->join('bolsa_trabajo AS BT', 'BT.id = A.id_bolsa_trabajo')
            ->join('requisicion AS R', 'R.id = A.id_requisicion')

            ->join('requisicion_intake AS RI', 'RI.id = R.id_intake', 'left')

            ->join('cliente AS CL', 'CL.id = R.id_cliente', 'left')
            ->join('datos_generales AS GENCL', 'GENCL.id = CL.id_datos_generales', 'left')

            ->join('usuarios_portal AS USPOR', 'USPOR.id = A.id_usuario', 'left')
            ->join('datos_generales AS DATUP', 'DATUP.id = USPOR.id_datos_generales', 'left')

            ->where('R.id_portal', $id_portal)
            ->where('A.id_requisicion', (int) $id)
            ->where('R.status', 2)
            ->where($condicion, $id_usuario)

            ->group_by('A.id')
            ->order_by('A.id', 'DESC');

        $query = $this->db->get();
        return $query->num_rows() ? $query->result() : false;
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
            ->select("A.*, TRIM(
            CONCAT(
                BT.nombre, ' ',
                COALESCE(BT.paterno, ''), ' ',
                COALESCE(BT.materno, '')
            )
        ) as aspirante, CONCAT(GENCL.nombre,' ',GENCL.paterno) as usuario, CL.nombre as empresa, R.puesto, H.id as idHistorial, R.numero_vacantes, C.id_aspirante as idCandidato, C.status_bgc, R.comentario_final, R.status as statusReq, R.id as id_requisicion")
            ->from('requisicion as R')
            ->join('cliente as CL', 'CL.id = R.id_cliente')
            ->join('datos_generales as GENCL', 'GENCL.id = CL.id_datos_generales')
            ->join('requisicion_historial as H', 'H.id_requisicion = R.id', 'left')
            ->join('requisicion_aspirante as A', 'A.id_requisicion = R.id', 'left') // ¡Aquí va el LEFT JOIN!
            ->join('bolsa_trabajo as BT', 'BT.id = A.id_bolsa_trabajo', 'left')
            ->join('usuarios_portal as USER', 'USER.id = A.id_usuario', 'left')
            ->join('candidato as C', 'C.id_aspirante = A.id', 'left')
            ->where('R.id_portal', $id_portal)
        // Puedes filtrar por usuario/reclutador o lo que necesites (asegúrate de que aplique bien aunque A sea null)
            ->where_in('R.status', [0, 3])
            ->group_by('R.id')
            ->order_by('R.id', 'DESC');

        if ($condicion && $id_usuario) {
            $this->db->where($condicion, $id_usuario);
        }

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
        $this->db->select("A.*,  TRIM(
            CONCAT(
                B.nombre, ' ',
                COALESCE(B.paterno, ''), ' ',
                COALESCE(B.materno, '')
            )
        ) asaspirante, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario, CL.nombre as empresa, R.puesto, H.id as idHistorial, R.status as statusReq, R.comentario_final")
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
            ->select("B.*, TRIM(
            CONCAT(
                B.nombre, ' ',
                COALESCE(B.paterno, ''), ' ',
                COALESCE(B.materno, '')
            )
        ) as nombreCompleto")
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
            ->select("E.*, TRIM(
            CONCAT(
                B.nombre, ' ',
                COALESCE(B.paterno, ''), ' ',
                COALESCE(B.materno, '')
            )
        ) as nombreCompleto")
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
            ->select("C.id, C.id_aspirante,  TRIM(
            CONCAT(
                B.nombre, ' ',
                COALESCE(B.paterno, ''), ' ',
                COALESCE(B.materno, '')
            )
        ) as  nombre, R.sueldo_acordado as sueldo, R.fecha_ingreso")
            ->from('requisicion_aspirante as R')
            ->join('candidato as C', 'C.id_aspirante = R.id', 'left')
            ->join('bolsa_trabajo as B', 'R.id_bolsa_trabajo = B.id', 'inner')
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
                $row_set[]        = $new_row; //build an array
            }
            return $row_set; //format the array into json data
        }
    }

    public function obtener_por_portal($id_portal)
    {
        return $this->db->get_where('link_portal', ['id_portal' => $id_portal])->row();
    }

    public function guardarLink($data)
    {
        $this->db->insert('link_portal', $data);
        return $this->db->insert_id();
    }

    public function actualizarPortal($id_portal, $data)
    {
        $this->db->where('id', $id_portal);
        $this->db->update('portal', $data);
    }

    public function actualizar($id_portal, $data)
    {
        $this->db->where('id_portal', $id_portal);
        $this->db->update('link_portal', $data);
    }

/**
 * Si existe un link para el empleado, lo ACTUALIZA con los nuevos campos.
 * Si no existe, lo INSERTA.
 * $data debe traer todas las columnas a actualizar (link, qr, jti, token_sha16, exp_unix, is_used, etc.)
 */
    public function upsertCurrentLinkEmpleado(int $id_empleado, array $data): bool
    {
        $row = $this->getLastLinkEmpleado2($id_empleado);

        if ($row) {
            // no tocamos 'creacion'; sólo actualizamos campos y 'edicion' la pone MySQL si la tienes ON UPDATE
            $this->db->where('id', $row->id);
            $ok = $this->db->update('links_empleados', $data);
            if (! $ok) {
                log_message('error', 'update links_empleados falló: ' . $this->db->last_query());
                return false;
            }
            return true;
        } else {
            $ok = $this->db->insert('links_empleados', $data);
            if (! $ok) {
                log_message('error', 'insert links_empleados falló: ' . $this->db->last_query());
                return false;
            }
            return true;
        }
    }
    public function getLastLinkEmpleado(int $id_empleado)
    {
        return $this->db->where('id_empleado', $id_empleado)
            ->where('eliminado', 0)
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get('links_empleados')
            ->row();
    }
    public function getLastLinkEmpleado2(int $id_empleado)
    {
        return $this->db->where('id_empleado', $id_empleado)
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get('links_empleados')
            ->row();
    }

    public function revokeLinkEmpleado(int $id_empleado): bool
    {
        $row = $this->getLastLinkEmpleado($id_empleado);
        if (! $row) {
            return false;
        }

        $this->db->where('id', $row->id)
            ->update('links_empleados', [
                'eliminado'  => 1,
                'revoked_at' => date('Y-m-d H:i:s'),
                'is_used'    => 0,
            ]);

        return $this->db->affected_rows() >= 0;
    }

    public function reemplazarExtrasDesdeJson($id_empleado, $extrasJson, array $whitelist = [])
    {
        // 1) Decodificar
        $extras = is_array($extrasJson) ? $extrasJson : json_decode($extrasJson, true);
        if (! is_array($extras)) {
            $extras = [];
        }

        // 2) (Opcional) Filtrar claves permitidas
        if (! empty($whitelist)) {
            $extras = array_intersect_key($extras, array_flip($whitelist));
        }

        // 3) Construir rows normalizados
        $now  = date('Y-m-d H:i:s');
        $rows = [];

        foreach ($extras as $campo => $valor) {
            // Normalizaciones útiles
            if (is_string($valor)) {
                $trim = trim($valor);
                if ($trim === 'null' || $trim === '') {
                    $valor = null;
                } elseif (in_array(mb_strtolower($trim), ['on', 'sí', 'si', 'true', '1'], true)) {
                    $valor = '1';
                } elseif (in_array(mb_strtolower($trim), ['off', 'no', 'false', '0'], true)) {
                    $valor = '0';
                } else {
                    $valor = $trim;
                }
            } elseif (is_bool($valor)) {
                $valor = $valor ? '1' : '0';
            } elseif (is_array($valor) || is_object($valor)) {
                $valor = json_encode($valor, JSON_UNESCAPED_UNICODE);
            }

            $rows[] = [
                'id_empleado' => (int) $id_empleado,
                'nombre'      => (string) $campo,
                'valor'       => $valor,
                'creacion'    => $now,
                'edicion'     => $now,
            ];
        }

        // 4) Guardar en transacción
        $this->db->trans_start();
        // Estrategia simple: borro y vuelvo a insertar (atómica por transacción)
        $this->db->where('id_empleado', $id_empleado)->delete('empleado_campos_extra');

        if (! empty($rows)) {
            $this->db->insert_batch('empleado_campos_extra', $rows);
        }
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    /**
     * Variante: UPSERT por cada campo (si tienes UNIQUE(id_empleado, campo)).
     * Útil si no quieres borrar todo.
     */
    public function upsertExtrasDesdeJson($id_empleado, $extrasJson, array $whitelist = [])
    {
        $extras = is_array($extrasJson) ? $extrasJson : json_decode($extrasJson, true);
        if (! is_array($extras)) {
            $extras = [];
        }

        if (! empty($whitelist)) {
            $extras = array_intersect_key($extras, array_flip($whitelist));
        }

        $now = date('Y-m-d H:i:s');

        foreach ($extras as $campo => $valor) {
            if (is_array($valor) || is_object($valor)) {
                $valor = json_encode($valor, JSON_UNESCAPED_UNICODE);
            } elseif (is_bool($valor)) {
                $valor = $valor ? '1' : '0';
            } elseif (is_string($valor)) {
                $trim = trim($valor);
                if ($trim === 'null' || $trim === '') {
                    $valor = null;
                } else {
                    $valor = $trim;
                }

            }

            // SQL UPSERT (MySQL/MariaDB)
            $sql = "INSERT INTO empleados_campos_extra (id_empleado, campo, valor, creacion, edicion)
                    VALUES (?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                        valor = VALUES(valor),
                        edicion = VALUES(edicion)";
            $this->db->query($sql, [(int) $id_empleado, (string) $campo, $valor, $now, $now]);
        }
        return true;
    }
}
