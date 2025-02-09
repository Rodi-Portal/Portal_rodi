<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cronjobs_model extends CI_Model
{
    /*----------------------------------------*/
    /*  Espanol
	/*----------------------------------------*/
    public function getCandidatos()
    {
        $this->db
            ->select('c.id as idCandidato, c.fecha_alta, f.id as idFin, f.creacion as fecha_final, bgc.creacion as fecha_bgc, f.tiempo as tiempoFinalizado, bgc.tiempo as tiempoBGC')
            ->from('candidato as c')
            ->join('candidato_finalizado as f', 'f.id_candidato = c.id', 'left')
            ->join('candidato_bgc as bgc', 'bgc.id_candidato = c.id', 'left')
            ->join('cliente as cl', 'cl.id = c.id_cliente')
            ->join('candidato_pruebas as cp', 'cp.id_candidato = c.id')
            ->where('cp.socioeconomico', 1)
        //->where('c.id_cliente', 33)
        //->where('cl.ingles', 0)
            ->where('c.eliminado', 0)
            ->where('c.cancelado', 0);
        //->where('c.id', 23230);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
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
    public function registroDiasFinalizado($datos, $idFin)
    {
        $this->db
            ->where('id', $idFin)
            ->update('candidato_finalizado', $datos);
    }
    public function registroDiasEnProceso($datos, $id_candidato)
    {
        $this->db
            ->where('id', $id_candidato)
            ->update('candidato', $datos);
    }
    public function getCandidatoFinalizados()
    {
        //$clientes = array(4,95,16,54);
        //$clientes = array(6,88,86,47,42,91,58,93,39.83,87);
        $this->db
            ->select('c.id as idCandidato, c.fecha_alta, f.id as idFin, f.creacion as fecha_final')
            ->from('candidato as c')
            ->join('candidato_finalizado as f', 'f.id_candidato = c.id', 'left')
            ->join('cliente as cl', 'cl.id = c.id_cliente')
            ->join('candidato_pruebas as cp', 'cp.id_candidato = c.id')
            ->join('permiso as p', 'p.id_cliente = c.id_cliente')
            ->where('cp.socioeconomico', 1)
        //->where('cl.ingles', 0)
            ->where('c.status_bgc !=', 0)
            ->where('c.eliminado', 0)
            ->where('c.id_cliente', 157)
            ->order_by('c.id', 'DESC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function checkArchivo($nombre)
    {
        $this->db
            ->select('D.*')
            ->from('candidato_documento as D')
            ->where('D.archivo', $nombre);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    /*----------------------------------------*/
    /*  Ingles
	/*----------------------------------------*/
    public function getCandidatosIngles()
    {
        $this->db
            ->select('c.id as idCandidato, c.fecha_alta, f.id as idFin, f.creacion as fecha_final')
            ->from('candidato as c')
            ->join('candidato_bgc as f', 'f.id_candidato = c.id', 'left')
            ->join('cliente as cl', 'cl.id = c.id_cliente')
            ->join('permiso as p', 'p.id_cliente = c.id_cliente')
            ->join('candidato_pruebas as cp', 'cp.id_candidato = c.id')
            ->where('cp.socioeconomico', 1)
            ->where('cl.ingles', 1)
            ->where('c.id_tipo_proceso', 1)
        //->where('c.status_bgc !=',0)
            ->where('c.eliminado', 0);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getCandidatoUST()
    {
        $this->db
            ->select('c.id as idCandidato, c.fecha_alta, f.id as idFin, f.creacion as fecha_final')
            ->from('candidato as c')
            ->join('candidato_bgc as f', 'f.id_candidato = c.id', 'left')
            ->join('cliente as cl', 'cl.id = c.id_cliente')
            ->where('cl.id', 1)
            ->where_in('c.id_tipo_proceso', [1, 7])
            ->where('c.cancelado', 0)
            ->where('c.eliminado', 0);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function registroDiasFinalizadoIngles($datos, $idFin)
    {
        $this->db
            ->where('id', $idFin)
            ->update('candidato_bgc', $datos);
    }
    /*----------------------------------------*/
    /*  Ingles Tipo 2
	/*----------------------------------------*/
    public function getCandidatosInglesTipo2()
    {
        $clientes = [3, 77];
        $this->db
            ->select('c.id as idCandidato, c.fecha_alta, f.id as idFin, f.creacion as fecha_final')
            ->from('candidato as c')
            ->join('candidato_bgc as f', 'f.id_candidato = c.id', 'left')
            ->join('cliente as cl', 'cl.id = c.id_cliente')
            ->join('candidato_pruebas as pru', 'pru.id_candidato = c.id')
            ->where('cl.ingles', 1)
            ->where_in('cl.id', $clientes)
            ->where('c.eliminado', 0)
            ->where('pru.socioeconomico', 1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    /*----------------------------------------*/
    /*  Candidatos procesos 2, 3, 4 y 5
	/*----------------------------------------*/
    public function getCandidatosProcesos1()
    {
        $this->db
            ->select('c.id as idCandidato')
            ->from('candidato as c')
            ->where('c.id_cliente', 1)
            ->where('c.id_tipo_proceso', 1);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    /*----------------------------------------*/
    /*  Avances proceso UST
	/*----------------------------------------*/
    public function getCandidatosUST()
    {
        $this->db
            ->select('c.id as idCandidato, c.fecha_contestado, est.comentarios as estudios_comentarios, verdoc.comentarios as docs_comentarios, persona.id as idFamiliar, refper.id as idRefPer, verlab.id as idVerLaboral, verest.id as idVerEstudios, estatuslab.id as idEstatusLaboral, verpenal.id as idVerPenal, doc.id as idDocumento')
            ->from('candidato as c')
            ->join('candidato_estudios as est', 'est.id_candidato = c.id', "left")
            ->join('verificacion_documento as verdoc', 'verdoc.id_candidato = c.id', "left")
            ->join('candidato_persona as persona', 'persona.id_candidato = c.id', "left")
            ->join('candidato_ref_personal as refper', 'refper.id_candidato = c.id', "left")
            ->join('verificacion_ref_laboral as verlab', 'verlab.id_candidato = c.id', "left")
            ->join('verificacion_estudios as verest', 'verest.id_candidato = c.id', "left")
            ->join('status_ref_laboral as estatuslab', 'estatuslab.id_candidato = c.id', "left")
            ->join('verificacion_penales as verpenal', 'verpenal.id_candidato = c.id', "left")
            ->join('candidato_documento as doc', 'doc.id_candidato = c.id', 'left')
            ->join('cliente as cl', 'cl.id = c.id_cliente')
            ->where('cl.id', 1)
            ->where('c.id_tipo_proceso', 1)
            ->where('c.eliminado', 0)
            ->group_by('c.id');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getDocumentosObligatoriosUST($id_candidato)
    {
        $this->db
            ->select('doc.id_tipo_documento')
            ->from('candidato_documento as doc')
            ->where('doc.id_candidato', $id_candidato);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function cleanAvance($idCandidato)
    {
        $this->db
            ->where('id_candidato', $idCandidato)
            ->delete('avance_porcentaje');
    }
    public function actualizarAvance($porcentaje, $idCandidato)
    {
        $this->db
            ->set('id_candidato', $idCandidato)
            ->set('porcentaje', $porcentaje)
            ->insert('avance_porcentaje');
    }
    /*function getCandidatosClientesGeneral(){
			$this->db
			->select('c.id as idCandidato, c.fecha_contestado, est.comentarios as estudios_comentarios, verdoc.comentarios as docs_comentarios, persona.id as idFamiliar, refper.id as idRefPer, verlab.id as idVerLaboral, verest.id as idVerEstudios, estatuslab.id as idEstatusLaboral, verpenal.id as idVerPenal, doc.id as idDocumento')
			->from('candidato as c')
			->join('candidato_estudios as est','est.id_candidato = c.id',"left")
			->join('verificacion_documento as verdoc','verdoc.id_candidato = c.id',"left")
			->join('candidato_persona as persona','persona.id_candidato = c.id',"left")
			->join('candidato_ref_personal as refper','refper.id_candidato = c.id',"left")
			->join('verificacion_ref_laboral as verlab','verlab.id_candidato = c.id',"left")
			->join('verificacion_estudios as verest','verest.id_candidato = c.id',"left")
			->join('status_ref_laboral as estatuslab','estatuslab.id_candidato = c.id',"left")
			->join('verificacion_penales as verpenal','verpenal.id_candidato = c.id',"left")
			->join('candidato_documento as doc','doc.id_candidato = c.id','left')
			->join('cliente as cl','cl.id = c.id_cliente')
			->where('cl.proceso', 'Español General')
			->where('c.eliminado', 0)
			->where('c.cancelado', 0)
			->group_by('c.id');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
					return FALSE;
			}
		}*/
    /*----------------------------------------*/
    /*  Asignacion de Secciones a Candidatos
	/*----------------------------------------*/
    public function getCandidatosPorProyecto($id_proyecto)
    {
        $this->db
            ->select('id, id_proyecto')
            ->from('candidato')
            ->where('id_proyecto', $id_proyecto);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getCandidatosPorCliente($id_cliente)
    {
        $this->db
            ->select('id')
            ->from('candidato')
            ->where('id_cliente', $id_cliente);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getProyecto($id_proyecto)
    {
        $this->db
            ->select('nombre')
            ->from('proyecto')
            ->where('id', $id_proyecto);

        $consulta  = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    public function guardarSeccionesCandidato($datos)
    {
        $this->db->insert('candidato_seccion', $datos);
    }
    public function getCandidatosEspanolGeneral()
    {
        $this->db
            ->select('C.id,C.pais')
            ->from('candidato as C')
            ->join('cliente as CL', 'CL.id = C.id_cliente')
            ->join('candidato_pruebas as P', 'P.id_candidato = C.id')
            ->where('CL.ingles', 0)
            ->where('P.socioeconomico', 1)
            ->where('C.id_cliente !=', 16)
            ->where('C.id_subcliente !=', 180);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    /*----------------------------------------*/
    /*  Secciones del Candidato e Historial de Proyectos
	/*----------------------------------------*/
    public function getSeccionesPrevias()
    {
        $this->db
            ->select('*')
            ->from('candidato_seccion')
            ->where('proyecto !=', null)
            ->group_by('proyecto');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function guardarProyectoPrevio($datos)
    {
        $this->db->insert('proyectos_historial', $datos);
    }
    public function getSeccionVerificacionDocumentacion()
    {
        $this->db
            ->select('id_candidato,id_seccion_verificacion_docs,pais')
            ->from('candidato_seccion as S')
            ->join('candidato as C', 'C.id = S.id_candidato');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getCategoriaDocumentoSolicitado($id_doc)
    {
        $this->db
            ->select('*')
            ->from('cat_documento_requerimiento')
            ->where('id_tipo_documento', $id_doc);

        $query = $this->db->get();
        return $query->row();
    }
    public function guardarCandidatoDocumentoRequerido($data)
    {
        $this->db->insert('candidato_documento_requerido', $data);
    }
    public function getSeccionesHCL()
    {
        $this->db
            ->select('S.id, secciones')
            ->from('candidato_seccion as S')
            ->join('candidato as C', 'C.id = S.id_candidato');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function getSeccionesProyectosHistorialHCL()
    {
        $this->db
            ->select('S.id, secciones')
            ->from('proyectos_historial as S');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function editarCandidatoSeccion($cadena, $id)
    {
        $this->db
            ->set('secciones', $cadena)
            ->where('id', $id)
            ->update('candidato_seccion');
    }
    public function editarProyectoSeccion($cadena, $id)
    {
        $this->db
            ->set('secciones', $cadena)
            ->where('id', $id)
            ->update('proyectos_historial');
    }
    public function getCandidatosSeccionPorProyecto($proyecto)
    {
        $this->db
            ->select('S.id,S.id_candidato,C.pais')
            ->from('candidato_seccion as S')
            ->join('candidato as C', 'C.id = S.id_candidato')
            ->where('S.lleva_criminal', 1)
            ->where('S.proyecto', $proyecto);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getPruebasCovid()
    {
        $this->db
            ->select('id')
            ->from('covid');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function crearTokenPruebasCovid($data, $id)
    {
        $this->db
            ->where('id', $id)
            ->update('covid', $data);
    }
    public function getCandidatosEnDoping()
    {
        $this->db
            ->select('C.id,C.id_subcliente,D.fecha_resultado')
            ->from('candidato as C')
            ->join('doping as D', 'C.id = D.id_candidato')
        //->join('candidato_pruebas as P','C.id = P.id_candidato')
            ->where('D.fecha_resultado >', '2022-07-24 00:00:00')
            ->where('D.fecha_resultado <=', '2022-07-28 23:59:00')
        // ->where('C.id_subcliente', 0)
        // ->where('P.socioeconomico', 0)
            ->where('C.id_cliente', 5)
            ->order_by('D.id', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function editPrueba($id_candidato)
    {
        $this->db
            ->set('socioeconomico', 1)
            ->where('id_candidato', $id_candidato)
            ->update('candidato_pruebas');
    }
    public function getUltimaSeccion($id)
    {
        $this->db
            ->select('*')
            ->from('candidato_seccion as C')
            ->where('C.id', $id);

        $query = $this->db->get();
        return $query->row();
    }
    public function insertSecciones($data)
    {
        $this->db->insert('candidato_seccion', $data);
    }
    public function addVisita($data)
    {
        $this->db->insert('visita', $data);
    }

    public function getCandidatosBecas()
    {
        $this->db
            ->select('C.id, C.id_usuario')
            ->from('candidato as C')
        //->join('candidato_finalizado as f','f.id_candidato = c.id','left')
            ->join('candidato_seccion as S', 'S.id_candidato = C.id')
            ->where('S.proyecto', 'Beca Escolar')
            ->where('C.id_cliente', 33);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function storeFinalizacion($data)
    {
        $this->db->insert('candidato_finalizado', $data);
    }
    public function getBeca($id_candidato)
    {
        $this->db
            ->select('*')
            ->from('beca')
            ->where('id_candidato', $id_candidato);

        $query = $this->db->get();
        return $query->row();
    }

    public function get_all_notificaciones_empleado()
    {
        $query = $this->db->get('notificaciones_empleados'); // SELECT * FROM notificaciones_empleado
        return $query->result();                             // Devuelve un array de objetos
    }

    public function actualizarCampoExcluyendoPortal1()
    {
        // Los valores que deseas actualizar en la tabla
        $data = [
            'estado_pago' => 'pendiente', // Este es el nuevo valor que deseas asignar
        ];

       // $this->db->where('id_portal !=', 1); // Filtramos para que no afecte al id_portal == 1
        $this->db->update('portal', $data);

        // Verificar si la actualización fue exitosa
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}
