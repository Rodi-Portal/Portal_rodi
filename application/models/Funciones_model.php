<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Funciones_model extends CI_Model
{

    public function getEstados()
    {
        $this->db
            ->select('*')
            ->from('estado')
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getMunicipios($id_estado)
    {
        $this->db
            ->select('id, nombre')
            ->from('municipio')
            ->where('id_estado', $id_estado)
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getClientesActivos()
    {
        $this->db
            ->select("cl.*")
            ->from("cliente as cl")
            ->where("cl.status", 1)
            ->where("cl.eliminado", 0)
            ->order_by("cl.nombre", 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getClientesInglesActivos()
    {
        $this->db
            ->select("cl.*")
            ->from("cliente as cl")
            ->where("cl.ingles", 1)
            ->where("cl.status", 1)
            ->where("cl.eliminado", 0)
            ->order_by("cl.nombre", 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getTiposIdentificaciones()
    {
        $this->db
            ->select('*')
            ->from('tipo_identificacion')
            ->where('status', 1)
            ->where('eliminado', 0)
            ->order_by('id', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getClaveCliente($id_cliente)
    {
        $this->db
            ->select('cl.clave')
            ->from('cliente as cl')
            ->where('cl.id', $id_cliente);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getClaveProyecto($id_cliente, $id_proyecto)
    {
        $this->db
            ->select('cl.clave as claveCliente, pro.nombre as claveProyecto')
            ->from('cliente as cl')
            ->join('proyecto as pro', 'pro.id_cliente = cl.id')
            ->where('cl.id', $id_cliente)
            ->where('pro.id', $id_proyecto);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getClaveSubcliente($id_cliente, $id_subcliente)
    {
        $this->db
            ->select('cl.clave as claveCliente, sub.clave as claveSubcliente')
            ->from('cliente as cl')
            ->join('subcliente as sub', 'sub.id_cliente = cl.id')
            ->where('cl.id', $id_cliente)
            ->where('sub.id', $id_subcliente);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getClaveSubclienteProyecto($id_cliente, $id_proyecto, $id_subcliente)
    {
        $this->db
            ->select('cl.clave as claveCliente, pro.nombre as claveProyecto, sub.clave as claveSubcliente')
            ->from('cliente as cl')
            ->join('proyecto as pro', 'pro.id_cliente = cl.id')
            ->join('subcliente as sub', 'sub.id = pro.id_subcliente', 'left')
            ->where('cl.id', $id_cliente)
            ->where('pro.id', $id_proyecto)
            ->where('sub.id', $id_subcliente);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getTiposDocumentos()
    {
        $this->db
            ->select('*')
            ->from('tipo_documentacion')
            ->where('status', 1)
            ->where('eliminado', 0)
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getEstadosCiviles()
    {
        $this->db
            ->select('*')
            ->from('estado_civil')
            ->where('id !=', 7)
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getBateriasPsicometricas()
    {
        $this->db
            ->select('*')
            ->from('psicometrico_bateria')
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getPaquetesAntidoping()
    {
        $this->db
            ->select('*')
            ->from('antidoping_paquete')
            ->where('status', 1)
            ->where('eliminado', 0)
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getPuestos()
    {
        $id_portal = $this->session->userdata('ídPortal');
        $this->db
            ->select('*')
            ->from('puesto')
            ->where('id_portal', $id_portal)
            ->where('status', 1)
            ->where('eliminado', 0)
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getGradosEstudio()
    {
        $this->db
            ->select('*')
            ->from('grado_estudio')
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getGradoEstudioById($id)
    {
        $this->db
            ->select('*')
            ->from('grado_estudio')
            ->where('id', $id);

        $query = $this->db->get();
        return $query->row();
    }
    public function getTiposEstudios()
    {
        $this->db
            ->select('*')
            ->from('tipo_studies')
            ->where('status', 1)
            ->where('eliminado', 0)
            ->order_by('id', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getParentescos()
    {
        $this->db
            ->select('*')
            ->from('tipo_parentesco')
            ->where('status', 1)
            ->where('eliminado', 0)
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getEscolaridades()
    {
        $this->db
            ->select('*')
            ->from('tipo_escolaridad')
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getNivelesZona()
    {
        $this->db
            ->select('*')
            ->from('tipo_nivel_zona');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getTiposVivienda()
    {
        $this->db
            ->select('*')
            ->from('tipo_vivienda');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getTiposCondiciones()
    {
        $this->db
            ->select('*')
            ->from('tipo_condiciones');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getExamenDoping($id_cliente)
    {
        $this->db
            ->select('paq.*')
            ->from('cliente_doping as cd')
            ->join('antidoping_paquete as paq', 'paq.id = cd.id_antidoping_paquete')
            ->where('cd.id_cliente', $id_cliente);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getConfiguraciones()
    {
        $this->db
            ->select("*")
            ->from('configuracion');

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getUsuariosParaAsignacion()
    {
        $this->db
            ->select("id, CONCAT(nombre,' ',paterno) as usuario")
            ->from('usuario')
            ->where_in('id_rol', [2, 9])
            ->where('status', 1)
            ->where('eliminado', 0)
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getTipoAnalistas($tipo_analista)
    {
        $tipos = [$tipo_analista, 3];
        $this->db
            ->select("id, CONCAT(nombre,' ',paterno) as usuario")
            ->from('usuario')
            ->where_in('tipo_analista', $tipos)
            ->where('status', 1)
            ->where('eliminado', 0)
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getTipoAnalista($id_usuario)
    {
        $this->db
            ->select("id, CONCAT(nombre,' ',paterno) as usuario, tipo_analista")
            ->from('usuario')
            ->where('id', $id_usuario);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getCiviles()
    {
        $this->db
            ->select('*')
            ->from('estado_civil');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getPaises()
    {
        $this->db
            ->select('*')
            ->from('paises')
            ->order_by('id', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getPaisesEstudio()
    {
        $this->db
            ->select('*')
            ->from('pais_estudio')
            ->where('status', 1)
            ->where('eliminado', 0);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getDatosCandidato($id_candidato)
    {
        $this->db
            ->select('cl.nombre as cliente')
            ->from('candidato as c')
            ->join('cliente as cl', 'cl.id = c.id_cliente')
        //->join('subcliente as sub','sub.id = c.id_subcliente','left')
        //->join('doping as dop','dop.id_candidato = c.id','left')
        //->join('puesto as p','p.id = c.id_puesto','left')
            ->where('c.id', $id_candidato);
        //->where('c.status',2)
        //->where('c.status_bgc !=', 0);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function getFechasFestivas()
    {
        $this->db
            ->select('*')
            ->from('fechas_festivas')
            ->order_by('fecha', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    /*
    public function getMediosContacto()
    {
        $this->db
            ->select('*') // Seleccionamos todas las columnas
            ->from('cat_medio_contacto')
            ->where('status', 1)
            ->where('eliminado', 0)
            ->group_by('nombre') // Agrupamos por la columna 'nombre' para eliminar duplicados
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } */
    public function saveMedioContacto($nombre)
    {
        $id_portal  = $this->session->userdata('idPortal');
        $id_usuario = $this->session->userdata('id');

        // Normalizar nombre
        $nombre = trim($nombre);

        // 1️⃣ Verificar si ya existe (global o del portal)
        $this->db
            ->select('id')
            ->from('cat_medio_contacto')
            ->where('nombre', $nombre)
            ->where('status', 1)
            ->where('eliminado', 0)
            ->group_start()
            ->where('id_portal IS NULL', null, false)
            ->or_where('id_portal', $id_portal)
            ->group_end();

        if ($this->db->get()->num_rows() > 0) {
            return false; // ya existe
        }

        // 2️⃣ Insertar nuevo medio
        $now = date('Y-m-d H:i:s');

        $data = [
            'nombre'     => $nombre,
            'id_portal'  => $id_portal,
            'id_usuario' => $id_usuario,
            'status'     => 1,
            'eliminado'  => 0,
            'creacion'   => $now,
            'edicion'    => $now,
        ];

        return $this->db->insert('cat_medio_contacto', $data);
    }
    public function getMediosContacto()
    {
        $id_portal = (int) $this->session->userdata('idPortal');

        $sql = "
        SELECT c.*
        FROM cat_medio_contacto c
        LEFT JOIN cat_medio_contacto p
            ON p.nombre = c.nombre
           AND p.id_portal = ?
           AND p.status = 1
           AND p.eliminado = 0
        WHERE c.status = 1
          AND c.eliminado = 0
          AND (
                c.id_portal = ?
                OR c.id_portal IS NULL
              )
          -- si existe uno del portal, descartamos el NULL
          AND (
                c.id_portal = ?
                OR p.id IS NULL
              )
        GROUP BY c.nombre
        ORDER BY c.nombre ASC
    ";

        $query = $this->db->query($sql, [
            $id_portal,
            $id_portal,
            $id_portal,
        ]);

        return $query->num_rows() > 0 ? $query->result() : false;
    }
    public function getAccionesRequisicion()
    {
        $portal = $this->session->userdata('idPortal');
        $this->db
            ->select('*')
            ->from('cat_accion_requisicion')
            ->where('id_portal', $portal)
            ->or_where('id_portal IS NULL', null, false)
            ->where('status', 1)
            ->where('eliminado', 0)
            ->order_by('descripcion', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getGruposSanguineos()
    {
        $this->db
            ->select('*')
            ->from('cat_grupo_sanguineo')
            ->where('status', 1)
            ->where('eliminado', 0)
            ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getMediosContactoByName($nombre)
    {
        $this->db
            ->select('*')
            ->from('cat_medio_contacto')
            ->where('nombre', $nombre);

        $consulta = $this->db->get();
        return $consulta->row();
    }

    public function insertarMedioContacto($nombre)
    {
        $fecha  = date('Y-m-d H:i:s');
        $nombre = trim($nombre);
        $nombre = ucfirst($nombre);

        $id_usuario = $this->session->userdata('id');
        $data       = [
            'creacion'   => $fecha,
            'id_usuario' => $id_usuario,
            'nombre'     => $nombre,
            // Agrega aquí otros campos y sus valores si es necesario
        ];

        $this->db->insert('cat_medio_contacto', $data);

        // Verifica si se insertó correctamente
        if ($this->db->affected_rows() > 0) {
            return true; // Se insertó correctamente
        } else {
            return false; // Hubo un error al insertar
        }
    }
    public function getMediosTransporte()
    {
        $this->db
            ->select('*')
            ->from('cat_medio_transporte')
            ->where('status', 1)
            ->where('eliminado', 0);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getTiposIdentificacion()
    {
        $this->db
            ->select('*')
            ->from('cat_tipo_identificacion')
            ->where('status', 1)
            ->where('eliminado', 0);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getFrecuencias()
    {
        $this->db
            ->select('*')
            ->from('cat_frecuencia')
            ->where('status', 1)
            ->where('eliminado', 0);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getTiposBloqueo()
    {
        $this->db
            ->select('*')
            ->from('cat_tipo_bloqueo')
            ->where('status', 1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getTiposDesbloqueo()
    {
        $this->db
            ->select('*')
            ->from('cat_tipo_desbloqueo')
            ->where('status', 1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getCondicionesVivienda()
    {
        $this->db
            ->select('*')
            ->from('tipo_condiciones')
            ->where('status', 1)
            ->where('eliminado', 0);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}