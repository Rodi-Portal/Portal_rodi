<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_model extends CI_Model{
  
	function getById($id){
		$this->db 
		->select('*')
		->from('candidato')
		->where('id', $id);

		$consulta = $this->db->get();
		return $consulta->row();
	}
	function edit($candidato, $id_candidato){
		$this->db
		->where('id', $id_candidato)
		->update('candidato', $candidato);
	}
	function getDetalles($id_candidato){
		$this->db
		->select("c.*,CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato,fin.creacion as fecha_fin, cl.nombre as cliente, cl.ingles, dop.id as idDoping, p.nombre as puestoSeleccionado, sub.nombre as subcliente,cl.ingles,MUN.nombre as municipio,EST.nombre as estado,GR.nombre as grado_estudio, BGC.creacion as fecha_bgc")
		->from('candidato as c')
		->join('candidato_finalizado as fin','fin.id_candidato = c.id','left')
		->join('candidato_bgc as BGC','BGC.id_candidato = c.id','left')
		->join('cliente as cl','cl.id = c.id_cliente')
		->join('subcliente as sub','sub.id = c.id_subcliente','left')
		->join('doping as dop','dop.id_candidato = c.id','left')
		->join('puesto as p','p.id = c.id_puesto','left')
		->join('municipio as MUN','MUN.id = c.id_municipio','left')
		->join('estado as EST','EST.id = c.id_estado','left')
		->join('grado_estudio as GR','GR.id = c.id_grado_estudio','left')
		->where('c.id',$id_candidato);
		
		$consulta = $this->db->get();
		return $consulta->row();
	}
	function getDocumentacion($id_candidato){
		$this->db
		->select('d.id, d.id_tipo_documento, d.archivo, tipo.nombre as tipo')
		->from('candidato_documento as d')
		->join('tipo_documentacion as tipo','tipo.id = d.id_tipo_documento')
		->where('d.id_candidato',$id_candidato)
		->where('d.eliminado',0)
    ->order_by('d.id_tipo_documento','ASC');

		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getExamenes($id_candidato){
		$this->db
		->select('p.*, m.edicion as fecha_medico, m.conclusion as conclusion_medico, psi.edicion as fecha_psicometrico, psi.archivo, m.id as idMedico, psi.id as idPsicometrico')
		->from('candidato_pruebas as p')
		->join('medico as m','m.id_candidato = p.id_candidato','left')
		->join('psicometrico as psi','psi.id_candidato = p.id_candidato','left')
		->where('p.id_candidato',$id_candidato);

		$consulta = $this->db->get();
		$resultado = $consulta->row();
		return $resultado;
	}
	function getDoping($id_candidato){
		$this->db
		->select('dop.*, paq.nombre as drogas, paq.conjunto')
		->from('doping as dop')
		->join('antidoping_paquete as paq','paq.id = dop.id_antidoping_paquete')
		->where('dop.status', 0)
		->where('dop.id_candidato',$id_candidato);

		$consulta = $this->db->get();
		$resultado = $consulta->row();
		return $resultado;
	}
	function getGAPS($id_candidato){
		$this->db
		->select('*')
		->from('candidato_gaps')
		->where('id_candidato',$id_candidato)
		->order_by('id','DESC');

		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
	function getInvestigacionLegal($id_candidato){
		$this->db
		->select('*')
		->from('verificacion_legal')
		->where('id_candidato',$id_candidato);

		$consulta = $this->db->get();
		return $consulta->row();
	}
  function getActivosPorCliente($id_cliente){
    $this->db
    ->select("c.id, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato")
    ->from('candidato as c')
    ->join('candidato_pruebas as P','P.id_candidato = c.id')
    ->where('c.id_cliente',$id_cliente)
    ->where('c.eliminado', 0)
    ->where('P.socioeconomico', 1)
    ->order_by('c.nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getSeccionesByToken($token){
    $this->db
		->select("S.*, C.*")
		->from('candidato as C')
    ->join('candidato_seccion as S','S.id_candidato = C.id')
		->where('C.token',$token);
		
		$consulta = $this->db->get();
		return $consulta->row();
  }
  function checkCredito($id_candidato){
    $this->db
    ->select('h.*')
    ->from('candidato_historial_crediticio as h')
    ->where('h.id_candidato',$id_candidato)
    ->order_by('h.id','DESC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function setCancelacion($data){
    $this->db->insert('candidato_cancelado', $data);
  }
  function getCandidateFileByType($id_tipo_documento){
    $this->db
		->select("*")
		->from('candidato_documento')
		->where('id_tipo_documento',$id_tipo_documento);
		
		$consulta = $this->db->get();
		return $consulta->row();
  }
    /*----------------------------------------*/
    /*  CRUD Candidato
    /*----------------------------------------*/
        function guardarCandidato($data){
            $this->db->insert('candidato', $data);
        }
        function editarCandidato($candidato, $id_candidato){
            $this->db
            ->where('id', $id_candidato)
            ->update('candidato', $candidato);
        }
        function editarVisita($visita, $id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->where('status', 0)
            ->update('visita', $visita);
        }
        function editarEstudios($estudios, $id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->update('candidato_estudios', $estudios);
        }
        function guardarEstudios($data_estudios){
            $this->db->insert('candidato_estudios', $data_estudios);
        }
        function eliminarVerificacionDocumentos($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('verificacion_documento');
        }
        function guardarVerificacionDocumento($verificacion_documento){
            $this->db->insert('verificacion_documento', $verificacion_documento);
        }
        function eliminarFamiliar($id_familiar){
            $this->db
            ->where('id', $id_familiar)
            ->delete('candidato_persona');
        }
        function guardarFamiliar($datos){
            $this->db->insert('candidato_persona', $datos);
        }
        function editarReferenciaPersonal($refPer_id, $data){
            $this->db
            ->where('id', $refPer_id)
            ->update('candidato_ref_personal', $data);
        }
        function guardarReferenciaPersonal($data){
            $this->db->insert('candidato_ref_personal', $data);
            $id = $this->db->insert_id();
            return  $id;
        }
        function editarReferenciaLaboral($data, $idref){
            $this->db
            ->where('id', $idref)
            ->update('candidato_ref_laboral', $data);
        }
        function guardarReferenciaLaboral($data){
            $this->db->insert('candidato_ref_laboral', $data);
            $id = $this->db->insert_id();
            return  $id;
        }
        function eliminarVerificacionLaboral($id_candidato, $numero_referencia){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->where('numero_referencia', $numero_referencia)
            ->delete('verificacion_ref_laboral');
        }
        function guardarVerificacionLaboral($verificacion_reflab){
            $this->db->insert('verificacion_ref_laboral', $verificacion_reflab);
        }
        function regenerarPassword($id_candidato, $date, $token){
            $this->db
            ->set('edicion', $date)
            ->set('token', $token)
            ->where('id', $id_candidato)
            ->update('candidato');
        }
        function eliminarBGC($id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->delete('candidato_bgc');
        }
        function guardarBGC($bgc){
            $this->db->insert('candidato_bgc', $bgc);
        }
        function statusBGCCandidato($status_bgc, $id_candidato){
            $this->db
            ->set('status',2)
            ->set('status_bgc',$status_bgc)
            ->where('id', $id_candidato)
            ->update('candidato');
        }
        function guardarEstatusProgresivo($nuevo_estatus, $status_bgc, $id_candidato){
            $this->db
            ->set('status', $nuevo_estatus)
            ->set('status_bgc',$status_bgc)
            ->where('id', $id_candidato)
            ->update('candidato');
        }
        function editarPruebas($datos, $id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->update('candidato_pruebas', $datos);
        }
        function crearPruebas($datos){
            $this->db->insert('candidato_pruebas', $datos);
        }
        function registrarRetornaCandidato($data){
            $this->db->insert('candidato', $data);
            $id = $this->db->insert_id();
            return  $id;
        }


        function registrarDocumento($documento){
            // Iniciar la transacción
            $this->db->trans_start();
        
            try {
                // Insertar el documento en la tabla candidato_documento
                $this->db->insert('candidato_documento', $documento);
        
                // Extraer el nombre del archivo
                $nombreArchivo = $documento['archivo'];
        
                // ID de la requisición del aspirante
                $idRa = $documento['id_requisicion_aspirante'];
        
                // Actualizar la tabla requisicion_aspirante
                $this->db->set('cv', $nombreArchivo);
                $this->db->where('id', $idRa);
                $this->db->update('requisicion_aspirante');
        
                // Completar la transacción
                $this->db->trans_complete();
        
                // Verificar si la transacción se completó con éxito
                if ($this->db->trans_status() === FALSE) {
                    throw new Exception('Error al completar la transacción');
                }
        
                return true; // La transacción se completó correctamente
            } catch (Exception $e) {
                // Revertir la transacción en caso de excepción
                $this->db->trans_rollback();
                return false; // La transacción falló
            }
        }

        function eliminarCV($id_req_aspirante){
            // Define la condición para eliminar el CV
            $this->db->where('id_requisicion_aspirante', $id_req_aspirante);
            
            // Ejecuta la sentencia DELETE
            $this->db->delete('candidato_documento');
        }

        function crearVisita($visita){
            $this->db->insert('visita', $visita);
        }
        function editarAntecedenteLaboral($verificacion_reflab, $id_candidato, $num){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->where('numero_referencia', $num)
            ->update('candidato_antecedente_laboral', $verificacion_reflab);
        }
        function guardarAntecedenteLaboral($verificacion_reflab){
            $this->db->insert('candidato_antecedente_laboral', $verificacion_reflab);
            $id = $this->db->insert_id();
            return  $id;
        }
        function editarInvestigacionLegal($datos, $id_inv){
            $this->db
            ->where('id', $id_inv)
            ->update('verificacion_legal', $datos);
        }
        function guardarInvestigacionLegal($datos){
            $this->db->insert('verificacion_legal', $datos);
            $id = $this->db->insert_id();
            return  $id;
        }
        function eliminarCandidatoPruebas($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('candidato_pruebas');
        }
        function guardarHistorialCandidato($historial){
            $this->db->insert('candidato_historial', $historial);
        }
        function eliminarCandidatoFinalizado($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('candidato_finalizado');
        }
        function eliminarCandidatoBGC($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('candidato_bgc');
        }
        function eliminarCandidatoEgresos($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('candidato_egresos');
        }
        function eliminarCandidatoHabitacion($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('candidato_habitacion');
        }
        function eliminarCandidatoVecinos($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('candidato_vecino');
        }
        function eliminarCandidatoPersona($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('candidato_persona');
        }
        function eliminarCandidatoPersonaMismoTrabajo($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('candidato_persona_mismo_trabajo');
        }
        function editarDoping($datos, $id_doping){
            $this->db
            ->where('id', $id_doping)
            ->update('doping', $datos);
        }
        function cambiarEstatusDopingCandidato($datos, $id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->update('doping', $datos);
        }
        function checkActualizacionCandidato($id_candidato){
            $this->db
            ->select('*')
            ->from('candidato_actualizacion')
            ->where('id_candidato', $id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function editarActualizacionCandidato($datos, $id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->update('candidato_actualizacion', $datos);
        }
        function guardarActualizacionCandidato($datos){
            $this->db->insert('candidato_actualizacion', $datos);
        }
        function guardarEgresos($egresos){
            $this->db->insert('candidato_egresos', $egresos);
        }
        function guardarHabitacion($habitacion){
            $this->db->insert('candidato_habitacion', $habitacion);
        }
        function guardarReferenciaVecinal($vecino){
            $this->db->insert('candidato_vecino', $vecino);
        }
        function editarIntegranteFamiliar($datos, $id_persona){
            $this->db
            ->where('id', $id_persona)
            ->update('candidato_persona', $datos);
        }
        function editarEgresos($datos, $id){
            $this->db
            ->where('id', $id)
            ->update('candidato_egresos', $datos);
        }
        function editarHabitacion($datos, $id){
            $this->db
            ->where('id', $id)
            ->update('candidato_habitacion', $datos);
        }
        function eliminarPsicometrico($id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->delete('psicometrico');
        }
        function guardarPsicometrico($doc){
            $this->db->insert("psicometrico", $doc);
        }
        function editarProcesoFinalizado($finalizado, $id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->update('candidato_finalizado', $finalizado);
        }
        function guardarProcesoFinalizado($finalizado){
            $this->db->insert('candidato_finalizado', $finalizado);
        }
        function guardarPersonaMismoTrabajo($persona){
            $this->db->insert('candidato_persona_mismo_trabajo', $persona);
        }
        function getReferenciasVecinales($id_candidato){
            $this->db
            ->select('v.*')
            ->from('candidato_vecino as v')
            ->where('v.id_candidato',$id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function eliminarVerificacionDocumentacion($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('verificacion_documento');
        }
        function editarDatosVisita($visita, $id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->update('visita', $visita);
        }
        function editarMayoresEstudios($verificacion, $id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->update('verificacion_mayores_estudios', $verificacion);
        }
        function guardarMayoresEstudios($verificacion){
            $this->db->insert('verificacion_mayores_estudios', $verificacion);
            $id = $this->db->insert_id();
            return  $id;
        }
        function eliminarGlobalSearches($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('candidato_global_searches');
        }
        function guardarGlobalSearches($data_global){
            $this->db->insert('candidato_global_searches', $data_global);
        }
        function editarBGC($bgc, $id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->update('candidato_bgc', $bgc);
        }
        function createGap($id_candidato, $id_usuario, $date, $fi, $ff, $razon){
            $this->db
            ->set('creacion', $date)
            ->set('edicion', $date)
            ->set('id_usuario', $id_usuario)
            ->set('id_candidato', $id_candidato)
            ->set('fecha_inicio', $fi)
            ->set('fecha_fin', $ff)
            ->set('razon', $razon)
            ->insert('candidato_gaps');
        }
        function guardarGap($datos){
            $this->db->insert('candidato_gaps', $datos);
        }
        function editarGap($datos, $id_gap){
            $this->db
            ->where('id', $id_gap)
            ->update('candidato_gaps', $datos);
        }
        function eliminarDocCandidato($idDoc){
            $this->db
            ->where('id', $idDoc)
            ->delete('candidato_documento');
        }

        function eliminarDocCandidatoInterno($idDoc, $tabla ){
            $this->db
            ->where('id', $idDoc)
            ->delete($tabla);
        }
        function eliminarChecklist($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('verificacion_checklist');
        }
        function guardarChecklist($verificacion){
            $this->db->insert('verificacion_checklist', $verificacion);
        }
        function guardarDomicilio($data_dom){
            $this->db->insert('candidato_domicilio', $data_dom);
            $id = $this->db->insert_id();
            return  $id;
        }
        function editarDomicilio($dom, $idDomicilio){
            $this->db
            ->where('id', $idDomicilio)
            ->update('candidato_domicilio', $dom);
        }
        function eliminarVerificacionDomicilios($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('verificacion_domicilio');
        }
        function guardarVerificacionDomicilio($domicilio){
            $this->db->insert('verificacion_domicilio', $domicilio);
        }
        function eliminarReferenciaProfesional($id_candidato, $num){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->where('numero', $num)
            ->delete('candidato_ref_profesional');
        }
        function guardarReferenciaProfesional($data){
            $this->db->insert('candidato_ref_profesional', $data);
        }
        function guardarHistorialCrediticio($credito){
            $this->db->insert('candidato_historial_crediticio', $credito);
        }
        function saveDomicilio($data_dom){
            $this->db->insert('candidato_domicilio', $data_dom);
        }
        function saveRefLab($data_reflab){
            $this->db->insert('candidato_ref_laboral', $data_reflab);
        }
        function saveRefPer($data_refper){
            $this->db->insert('candidato_ref_personal', $data_refper);
        }
        function eliminarReferenciasLaborales($id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->delete('candidato_ref_laboral');
        }
        function eliminarHistorialDomicilios($id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->delete('candidato_domicilio');
        }
        function eliminarReferenciasProfesionales($id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->delete('candidato_ref_profesional');
        }
        function eliminarReferenciasPersonales($id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->delete('candidato_ref_personal');
        }
        function eliminarEstudios($id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->delete('candidato_estudios');
        }
        function eliminarFamiliares($id_candidato){
            $this->db
            ->where('id_candidato', $id_candidato)
            ->delete('candidato_persona');
        }
        function eliminarReferenciaLaboral($id){
            $this->db
            ->where('id', $id)
            ->delete('candidato_ref_laboral');
        }
        function eliminarVerificacionLaboralPorID($id_verificacion){
            $this->db
            ->where('id', $id_verificacion)
            ->delete('verificacion_ref_laboral');
        }
        function ordenarVerificacionesLaborales($id_candidato, $num){
            $this->db
            ->set('numero_referencia','numero_referencia - 1', FALSE)
            ->where('numero_referencia >', $num)
            ->where('id_candidato', $id_candidato)
            ->update('verificacion_ref_laboral');
        }
        function eliminarEgresosCandidato($id_candidato){
            $this->db->where('id_candidato', $id_candidato)
            ->delete('candidato_egresos');
        }
        function guardarVisibilidadCandidato($id_candidato, $visibilidad){
            $this->db 
            ->set('privado', $visibilidad)
            ->where('id', $id_candidato)
            ->update('candidato');
        }
    /*----------------------------------------*/
    /*  Consultas comunes
    /*----------------------------------------*/
        function repetidoCandidato($nombre, $paterno, $materno, $correo, $id_cliente, $proyecto){
            $this->db
            ->select('C.id')
            ->from('candidato as C')
            ->join('candidato_pruebas as P','P.id_candidato = C.id')
            ->join('candidato_seccion as S','S.id_candidato = C.id','left')
            ->where('C.nombre', $nombre)
            ->where('C.paterno', $paterno)
            ->where('C.materno', $materno)
            ->where('C.id_cliente', $id_cliente)
            ->where('S.proyecto', $proyecto)
            ->where('P.socioeconomico', 1)
            ->where_in('C.status', [0,1])
            ->where('C.eliminado', 0);

            $query = $this->db->get();
            return $query->num_rows();
        }
        function repetidoCandidatoUST($nombre, $paterno, $materno, $correo, $id_cliente,$proceso){
            $this->db
            ->select('C.id')
            ->from('candidato as C')
            ->join('doping as DOP','DOP.id_candidato = C.id','left')
            ->where('C.nombre', $nombre)
            ->where('C.paterno', $paterno)
            ->where('C.materno', $materno)
            ->where('C.id_cliente', $id_cliente)
            ->where('C.id_tipo_proceso', $proceso)
            ->where('C.status_bgc', 0)
            ->where('DOP.id', NULL)
            ->where('C.eliminado', 0);

            $query = $this->db->get();
            return $query->num_rows();
        }
        function existeCandidatoTipoBeca($nombre, $paterno, $materno, $id_cliente, $id_proyecto){
          $this->db
          ->select('C.id')
          ->from('candidato as C')
          ->join('candidato_seccion as S','S.id_candidato = C.id')
          ->where('C.nombre', $nombre)
          ->where('C.paterno', $paterno)
          ->where('C.materno', $materno)
          ->where('C.id_cliente', $id_cliente)
          ->where('S.id', $id_proyecto)
          ->where('C.eliminado', 0);

          $query = $this->db->get();
          return $query->num_rows();
        }
        function lastIdCandidato(){
            $this->db
            ->select('id')
            ->from('candidato')
            ->order_by('id','DESC')
            ->limit(1);
        
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getReferenciasPersonales($id_candidato){
            $this->db
            ->select('p.*')
            ->from('candidato_ref_personal as p')
            ->where('p.id_candidato', $id_candidato);
        
            $query = $this->db->get();
            if($query->num_rows() > 0){
              return $query->result();
            }else{
              return FALSE;
            }
        }
        function getReferenciasLaborales($id_candidato){
            $this->db
            ->select('lab.*')
            ->from('candidato_ref_laboral as lab')
            ->where('lab.id_candidato', $id_candidato)
            ->order_by('lab.id','ASC');
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getVerificacionReferencias($id_candidato){
            $this->db
            ->select('lab.*')
            ->from('verificacion_ref_laboral as lab')
            ->where('lab.id_candidato', $id_candidato)
            ->order_by('lab.numero_referencia','ASC');
        
            $query = $this->db->get();
            if($query->num_rows() > 0){
              return $query->result();
            }else{
              return FALSE;
            }
        }
        function checkVerificacionDocumentos($id_candidato){
            $this->db
            ->select('doc.*')
            ->from('verificacion_documento as doc')
            ->where('doc.id_candidato',$id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getInfoCandidatoEspecifico($id_candidato){
            $this->db
            ->select("c.*, IF(c.adeudo_muebles = 1, 'Si','No') as adeudo, cl.ingles, sub.nombre as subcliente, CONCAT(us.nombre,' ',us.paterno) as usuario, pu.nombre as puesto, cl.nombre as cliente, c.puesto as puestoCandidato")
            ->from('candidato as c')
            ->join('cliente as cl','cl.id = c.id_cliente')
            ->join('subcliente as sub','sub.id = c.id_subcliente','left')
            ->join('usuario as us','us.id = c.id_usuario','left')
            ->join('puesto as pu','pu.id = c.id_puesto','left')
            ->where('c.id',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function revisionEstudios($id_candidato){
            $this->db
            ->select('id')
            ->from('candidato_estudios')
            ->where('id_candidato', $id_candidato);
            $query = $this->db->get();
            if($query->num_rows() > 0){
              return $query->result();
            }else{
              return FALSE;
            }
        }
        function revisionReferenciaLaboral($idref){
            $this->db
            ->select('*')
            ->from('candidato_ref_laboral')
            ->where('id', $idref);
            $query = $this->db->get();
            if($query->num_rows() > 0){
              return $query->result();
            }else{
              return FALSE;
            }
        }
        function getDatosCandidato($id_candidato){
            $this->db
            ->select('c.*,bgc.edicion as fecha_bgc, cl.nombre as cliente, dop.id as idDoping, pro.nombre as proyecto, sub.nombre as subcliente, bgc.edicion as ultima_fecha_bgc')
            ->from('candidato as c')
            ->join('candidato_bgc as bgc','bgc.id_candidato = c.id','left')
            ->join('cliente as cl','cl.id = c.id_cliente')
            ->join('subcliente as sub','sub.id = c.id_subcliente','left')
            ->join('doping as dop','dop.id_candidato = c.id AND dop.eliminado = 0','left')
            ->join('proyecto as pro','pro.id = c.id_proyecto','left')
            ->where('c.id',$id_candidato);
            //->where_in('c.status',[1,2])
            //->where('c.status_bgc !=', 0);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getCandidato($id_candidato){
            $this->db
            ->select('c.*,bgc.creacion as fecha_bgc, cl.nombre as cliente, dop.id as idDoping, pro.nombre as proyecto, sub.nombre as subcliente, bgc.edicion as ultima_fecha_bgc')
            ->from('candidato as c')
            ->join('candidato_bgc as bgc','bgc.id_candidato = c.id','left')
            ->join('cliente as cl','cl.id = c.id_cliente')
            ->join('subcliente as sub','sub.id = c.id_subcliente','left')
            ->join('doping as dop','dop.id_candidato = c.id','left')
            ->join('proyecto as pro','pro.id = c.id_proyecto','left')
            ->where('c.id',$id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getBGC($id_candidato){
            $this->db
            ->select('*')
            ->from('candidato_bgc')
            ->where('id_candidato',$id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getFechaVerificacionLaboral($id_candidato){
            $this->db
            ->select('lab.edicion as fecha_finalizado')
            ->from('status_ref_laboral as lab')
            ->where('lab.id_candidato',$id_candidato);
        
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getFechaVerificacionEstudios($id_candidato){
            $this->db
            ->select('est.edicion as fecha_finalizado')
            ->from('verificacion_estudios as est')
            ->where('est.id_candidato',$id_candidato);
        
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getFechaVerificacionPenales($id_candidato){
            $this->db
            ->select('p.edicion as fecha_finalizado')
            ->from('verificacion_penales as p')
            ->where('p.id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getFechaVerificacionOfac($id_candidato){
            $this->db
            ->select('p.edicion as fecha_finalizado')
            ->from('verificacion_penales as p')
            ->where('p.id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getDocumentacionCandidato($id_candidato){
            $this->db
            ->select('d.id, d.id_tipo_documento, d.archivo, tipo.nombre as tipo')
            ->from('candidato_documento as d')
            ->join('tipo_documentacion as tipo','tipo.id = d.id_tipo_documento')
            ->where('d.id_candidato',$id_candidato)
            ->where('d.eliminado',0);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getDocumentacionEspecificaCandidato($id_candidato){
          $this->db
          ->select('d.id, d.id_tipo_documento, d.archivo, tipo.nombre as tipo')
          ->from('candidato_documento as d')
          ->join('tipo_documentacion as tipo','tipo.id = d.id_tipo_documento')
          ->where('d.id_candidato',$id_candidato)
          //->where_in('tipo.id', [3,8,9,14,45])
          ->where('d.eliminado',0);
  
          $query = $this->db->get();
          if($query->num_rows() > 0){
              return $query->result();
          }else{
              return FALSE;
          }
      }
        function getVerificacionDocumentosCandidato($id_candidato){
            $this->db
            ->select('*')
            ->from('verificacion_documento')
            ->where('id_candidato',$id_candidato);
        
            $query = $this->db->get();
            if($query->num_rows() > 0){
              return $query->result();
            }else{
              return FALSE;
            }
        }
        function getFamiliaresCandidato($id_candidato){
            $query = $this->db
            ->query('SELECT * FROM candidato_persona WHERE id_candidato = '.$id_candidato.' ORDER BY FIELD (id_tipo_parentesco, 4, 3, 1, 2, 6)  ASC, id_tipo_parentesco');
            if($query->num_rows() > 0){
              return $query->result();
            }else{
              return FALSE;
            }
        }
        function getGrupoFamiliar($id_candidato){
            $this->db
            ->select('p.*')
            ->from('candidato_persona as p')
            ->where('p.eliminado', 0)
            ->where('p.id_candidato',$id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getEstudiosCandidato($id_candidato){
            $this->db
            ->select('*')
            ->from('candidato_estudios')
            ->where('id_candidato',$id_candidato);
        
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getStatusVerificacionEstudios($id_candidato){
            $query = $this->db
           ->query('SELECT det.* FROM verificacion_estudios as est 
                     JOIN verificacion_estudios_detalle as det ON det.id_verificacion_estudio = est.id
                     WHERE est.id_candidato = '.$id_candidato.'
                     ORDER BY det.id DESC');
           if($query->num_rows() > 0){
             return $query->result();
           }else{
             return FALSE;
           }
        }
        function getStatusVerificacionEmpleo($id_candidato){
            $query = $this->db
           ->query('SELECT det.* FROM status_ref_laboral as status 
                     JOIN status_ref_laboral_detalle as det ON det.id_status_ref_laboral = status.id
                     WHERE status.id_candidato = '.$id_candidato.'
                     ORDER BY det.id DESC');
           if($query->num_rows() > 0){
             return $query->result();
           }else{
             return FALSE;
           }
        }
        function getStatusVerificacionPenales($id_candidato){
            $query = $this->db
           ->query('SELECT det.* FROM verificacion_penales as status 
                     JOIN verificacion_penales_detalle as det ON det.id_verificacion_penales = status.id
                     WHERE status.id_candidato = '.$id_candidato.'
                     ORDER BY det.id DESC');
           if($query->num_rows() > 0){
             return $query->result();
           }else{
             return FALSE;
           }
        }
        function getAnalista($id_candidato){
            $this->db
            ->select("CONCAT(u.nombre,' ',u.paterno) as nombre, u.firma")
            ->from('candidato as c')
            ->join('usuario as u','u.id = c.id_usuario')
            ->where('c.id',$id_candidato);
        
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getCoordinadora($id_candidato){
            $this->db
            ->select("CONCAT(u.nombre,' ',u.paterno) as nombre")
            ->from('candidato as c')
            ->join('usuario as u','u.id = c.id_usuario')
            ->where('c.id',$id_candidato);
        
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function checkPruebas($id_candidato){
            $this->db
            ->select('p.*')
            ->from('candidato_pruebas as p')
            ->join('candidato as c','c.id = p.id_candidato')
            ->where('c.id',$id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getPruebasFACIS($id_candidato){
            $this->db
            ->select('*')
            ->from('candidato_pruebas')
            ->where('id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function revisionAntecedentesSociales($id_candidato){
            $this->db
            ->select('id')
            ->from('candidato_antecedentes_sociales')
            ->where('id_candidato', $id_candidato);
            $query = $this->db->get();
            if($query->num_rows() > 0){
              return $query->result();
            }else{
              return FALSE;
            }
        }
        function getAntecedentesLaborales($id_candidato){
            $this->db
            ->select('*')
            ->from('candidato_antecedente_laboral')
            ->where('id_candidato', $id_candidato)
            ->order_by('numero_referencia','ASC');
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function revisionAntecedenteLaboral($id_candidato, $num){
            $this->db
            ->select('*')
            ->from('candidato_antecedente_laboral')
            ->where('numero_referencia', $num)
            ->where('id_candidato', $id_candidato);
            $query = $this->db->get();
            if($query->num_rows() > 0){
              return $query->result();
            }else{
              return FALSE;
            }
        }
        function revisionInvestigacionLegal($id_candidato){
            $this->db
            ->select('*')
            ->from('verificacion_legal')
            ->where('id_candidato', $id_candidato);
            $query = $this->db->get();
            if($query->num_rows() > 0){
              return $query->result();
            }else{
              return FALSE;
            }
        }
        function revisionTrabajosNoMencionados($id_candidato){
            $this->db
            ->select('*')
            ->from('verificacion_no_mencionados')
            ->where('id_candidato',$id_candidato);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getPruebasCandidato($id_candidato){
            $this->db
            ->select('p.*, m.edicion as fecha_medico, m.conclusion as conclusion_medico, psi.edicion as fecha_psicometrico, psi.archivo, m.id as idMedico, psi.id as idPsicometrico')
            ->from('candidato_pruebas as p')
            ->join('medico as m','m.id_candidato = p.id_candidato','left')
            ->join('psicometrico as psi','psi.id_candidato = p.id_candidato','left')
            ->where('p.id_candidato',$id_candidato);
        
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function revisionEgresos($id_candidato){
            $this->db
            ->select('id')
            ->from('candidato_egresos')
            ->where('id_candidato', $id_candidato);
            $query = $this->db->get();
            if($query->num_rows() > 0){
              return $query->result();
            }else{
              return FALSE;
            }
        }
        function revisionHabitacion($id_candidato){
            $this->db
            ->select('id')
            ->from('candidato_habitacion')
            ->where('id_candidato', $id_candidato);
            $query = $this->db->get();
            if($query->num_rows() > 0){
              return $query->result();
            }else{
              return FALSE;
            }
        }
        function checkConclusionesCandidato($id_candidato){
            $this->db
            ->select('id')
            ->from('candidato_finalizado')
            ->where('id_candidato', $id_candidato);
            $query = $this->db->get();
            return $query->num_rows();
        }
        function getCorreoCliente($id_candidato){
            $this->db
            ->select("cl.correo, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato")
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
        function getCorreoSubCliente($id_candidato){
            $this->db
            ->select("sub.correo, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato")
            ->from('candidato as c')
            ->join("usuario_subcliente as sub","sub.id_subcliente = c.id_subcliente")
            ->where('c.id', $id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
              return $query->result();
            }else{
              return FALSE;
            }
        }
        function getPersonasMismoTrabajo($id_candidato){
            $this->db
            ->select('*')
            ->from('candidato_persona_mismo_trabajo')
            ->where('id_candidato', $id_candidato);
            $query = $this->db->get();
            if($query->num_rows() > 0){
              return $query->result();
            }else{
              return FALSE;
            }
        }
        function getDatosFinalizadosCandidato($id_candidato){
            $this->db
            ->select('*')
            ->from('candidato_finalizado')
            ->where('id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getDopingCandidato($id_candidato){
            $this->db
            ->select('dop.*, paq.nombre as drogas, paq.conjunto')
            ->from('doping as dop')
            ->join('antidoping_paquete as paq','paq.id = dop.id_antidoping_paquete')
            ->where('dop.id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getAntecedentesSociales($id_candidato){
            $this->db
            ->select('*')
            ->from('candidato_antecedentes_sociales')
            ->where('id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getFamiliares($id_candidato){
            $this->db
            ->select('p.*, p.nombre as persona, tipo.nombre as parentesco, g.nombre as escolaridad')
            ->from('candidato_persona as p')
            ->join('tipo_parentesco as tipo','tipo.id = p.id_tipo_parentesco')
            ->join('tipo_escolaridad as g','g.id = p.id_grado_estudio')
            ->where('p.eliminado', 0)
            ->where('p.id_candidato',$id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getDatosVivienda($id_candidato){
            $this->db
            ->select('hab.*, zona.nombre as zona, v.nombre as vivienda, cond.nombre as condiciones')
            ->from('candidato_habitacion as hab')
            ->join('tipo_nivel_zona as zona','zona.id = hab.id_tipo_nivel_zona')
            ->join('tipo_vivienda as v','v.id = hab.id_tipo_vivienda')
            ->join('tipo_condiciones as cond','cond.id = hab.id_tipo_condiciones')
            ->where('hab.id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getVerificacionLegal($id_candidato){
            $this->db
            ->select('*')
            ->from('verificacion_legal')
            ->where('id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getTrabajosNoMencionados($id_candidato){
            $this->db
            ->select('*')
            ->from('verificacion_no_mencionados')
            ->where('id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function revisionMayoresEstudios($id_candidato){
            $this->db
            ->select('v.*')
            ->from('verificacion_mayores_estudios as v')
            ->where('v.id_candidato',$id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function checkBGC($id_candidato){
            $this->db
            ->select('id')
            ->from('candidato_bgc')
            ->where('id_candidato', $id_candidato);
            $query = $this->db->get();
            return $query->num_rows();
        }
        function getFechaVerificacionDocumentos($id_candidato){
            $this->db
            ->select('doc.*')
            ->from('verificacion_documento as doc')
            ->where('doc.id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getVerificacionMayoresEstudios($id_candidato){
            $this->db
            ->select('v.*')
            ->from('verificacion_mayores_estudios as v')
            ->where('v.id_candidato', $id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getProyectosCliente($id_cliente){
            $this->db
            ->select('*')
            ->from('proyecto')
            ->where('id_cliente',$id_cliente)
            ->where('status', 1)
            ->where('eliminado', 0)
            ->order_by('nombre','ASC');
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function checkGaps($id_candidato){
            $this->db
            ->select('gaps.*')
            ->from('candidato_gaps as gaps')
            ->where('gaps.id_candidato',$id_candidato)
            ->order_by('gaps.id','DESC');
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function eliminarGap($id_gap){
            $this->db->where('id', $id_gap)
            ->delete('candidato_gaps');
        }
        function getGlobalSearches($id_candidato){
            $this->db
            ->select('*')
            ->from('candidato_global_searches')
            ->where('id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getVerificacionChecklist($id_candidato){
            $this->db
            ->select('v.*')
            ->from('verificacion_checklist as v')
            ->where('v.id_candidato', $id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getHistorialDomicilios($id_candidato){
            $this->db
            ->select('dom.*, est.nombre as estado, mun.nombre as municipio')
            ->from('candidato_domicilio as dom')
            ->join('estado as est','est.id = dom.id_estado','left')
            ->join('municipio as mun','mun.id = dom.id_municipio','left')
            ->where('dom.id_candidato',$id_candidato)
            ->order_by('dom.id','ASC');
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function checkVerificacionDomicilios($id_candidato){
            $this->db
            ->select('*')
            ->from('verificacion_domicilio')
            ->where('id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getVerificacionHistorialDomicilios($id_candidato){
            $this->db
            ->select('v.*')
            ->from('verificacion_domicilio as v')
            ->where('v.id_candidato',$id_candidato)
            ->order_by('v.id','ASC');
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        
        function getVecinales($id_candidato){
            $this->db
            ->select('v.*')
            ->from('candidato_vecino as v')
            ->where('v.id_candidato', $id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function eliminarVecinal($id){
            $this->db->where('id', $id)
            ->delete('candidato_vecino');
        }
        function getFechaInicioProceso($id_candidato){
            $this->db
            ->select("fecha_inicio")
            ->from('candidato')
            ->where('id',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getInformacionVisita($id_candidato){
            $this->db
            ->select("V.*, CONCAT(USER.nombre,' ',USER.paterno) as usuario, CONCAT(C.nombre,' ',C.paterno,' ',C.materno) as candidato")
            ->from('visita as V')
            ->join('usuario as USER','USER.id = V.id_usuario','left')
            ->join('candidato as C','C.id = V.id_candidato')
            ->where('V.id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
    /*----------------------------------------*/
    /*  Consultas para registro de candidatos para estudio por secciones (o a la carta)
    /*----------------------------------------*/
        function getSeccionesRegion($region){
            $regiones = [$region, 'Todas'];
            $this->db
            ->select('id, tipo_seccion, descripcion_ingles')
            ->from('seccion')
            ->where_in('region',$regiones)
            ->where('status', 1)
            ->where('eliminado', 0);

            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getEtiquetaSeccion($id_seccion){
            $this->db
            ->select('etiqueta')
            ->from('seccion')
            ->where('id',$id_seccion);

            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getNumeroReferenciasProfesionales($id_candidato){
            $this->db
            ->select('cantidad_ref_profesionales')
            ->from('candidato_seccion')
            ->where('id_candidato',$id_candidato);

            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function guardarSeccionCandidato($candidato_secciones){
            $this->db->insert('candidato_seccion', $candidato_secciones);
        }
        function getTipoDocumentacionSeccion($seccion){
            $this->db 
            ->select('tipo_documentacion')
            ->from('seccion')
            ->where('id', $seccion);

            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getDocumentosRequeridos($id_candidato){
					$this->db
					->select('id, id_tipo_documento')
					->from('candidato_documento_requerido')
					->where('id_candidato',$id_candidato);

					$query = $this->db->get();
					if($query->num_rows() > 0){
						return $query->result();
					}else{
						return FALSE;
					}
        }
        function getCandidatoProyectoPrevio($proyecto){
            $this->db
            ->select('S.id,S.id_candidato')
            ->from('candidato_seccion as S')
            ->where('S.proyecto',$proyecto)
            ->order_by('S.id', 'DESC')
            ->limit(1);

            $consulta = $this->db->get();
            return $consulta->row();
        }
        function getDocumentosRequeridosCandidatoPrevio($id_candidato){
            $this->db
            ->select('*')
            ->from('candidato_documento_requerido')
            ->where('id_candidato',$id_candidato);

            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function guardarDocumentacionRequerida($docs_requeridos){
            $this->db->insert('candidato_documento_requerido', $docs_requeridos);
        }
        function getDocumentoRequerido($id_tipo_documento){
            $this->db
            ->select('*')
            ->from('cat_documento_requerimiento')
            ->where('id_tipo_documento',$id_tipo_documento);

            $consulta = $this->db->get();
            return $consulta->row();
        }
    /*----------------------------------------*/
    /*  Consultas especificas
    /*----------------------------------------*/
        function getFechaNacimiento($id_candidato){
            $this->db
            ->select('fecha_nacimiento')
            ->from('candidato')
            ->where('id', $id_candidato);

            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getClienteCandidato($id_candidato){
            $this->db
            ->select('c.id_cliente')
            ->from('candidato as c')
            ->where('c.id',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getComentariosRefPersonales($id_candidato){
            $this->db
            ->select('ref.comentario')
            ->from('candidato_ref_personal as ref')
            ->where('ref.id_candidato', $id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function countAntecedentesLaborales($id_candidato){
            $this->db
            ->select('id')
            ->from('candidato_antecedente_laboral')
            ->where('id_candidato', $id_candidato);
    
            $query = $this->db->get();
            return $query->num_rows();
        }
        function getComentariosRefVecinales($id_candidato){
            $this->db
            ->select('v.concepto_candidato')
            ->from('candidato_vecino as v')
            ->where('v.id_candidato', $id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function countReferenciasLaborales($id_candidato){
            $this->db
            ->select('id')
            ->from('candidato_ref_laboral')
            ->where('id_candidato', $id_candidato);
    
            $query = $this->db->get();
            return $query->num_rows();
        }
        function countDomicilios($id_candidato){
            $this->db
            ->select('id')
            ->from('candidato_domicilio')
            ->where('id_candidato', $id_candidato);
    
            $query = $this->db->get();
            return $query->num_rows();
        }
        function countReferenciasProfesionales($id_candidato){
            $this->db
            ->select('id')
            ->from('candidato_ref_profesional')
            ->where('id_candidato', $id_candidato);
    
            $query = $this->db->get();
            return $query->num_rows();
        }
        function getComentariosRefLaborales($id_candidato){
            $this->db
            ->select('ver.notas')
            ->from('verificacion_ref_laboral as ver')
            ->where('ver.id_candidato', $id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getClienteDelSubcliente($id_subcliente){
            $this->db
            ->select('cl.id')
            ->from('subcliente as sub')
            ->join('cliente as cl','cl.id = sub.id_cliente')
            ->where('sub.id',$id_subcliente);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getStatusVerificacionPenal($id_candidato){
            $this->db
            ->select('p.id, p.finalizado')
            ->from('verificacion_penales as p')
            ->where('p.id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getFechaExamenMedico($id_candidato){
            $this->db
            ->select('creacion')
            ->from('medico')
            ->where('id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getFechaCredito($id_candidato){
            $this->db
            ->select('creacion')
            ->from('candidato_historial_crediticio')
            ->where('id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getDocumentoCandidato($id_tipo_documento, $id_candidato){
            $this->db
            ->select('*')
            ->from('candidato_documento')
            ->where('id_tipo_documento',$id_tipo_documento)
            ->where('id_candidato',$id_candidato);
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getUsuariosCliente($id_cliente){
            $this->db
            ->select('UC.id, DAT.nombre, DAT.paterno')
            ->from('usuarios_clientes as UC')
            ->join('datos_generales as DAT','UC.id_datos_generales = DAT.id' )
            ->where('id_cliente',$id_cliente)
            ->order_by('nombre','ASC');
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        
    /*----------------------------------------*/
    /*  Consultas para formulario Candidatos
    /*----------------------------------------*/
        function getSeccionesCandidato($id_candidato){
            $this->db
            ->select('*')
            ->from('candidato_seccion')
            ->where('id_candidato',$id_candidato);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getDocumentacionSeccion($id_seccion){
            $this->db
            ->select('*')
            ->from('seccion_documentos')
            ->where('id_seccion',$id_seccion)
            ->order_by('obligatorio','DESC');

            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function matchDocumento($id_candidato, $id_documento){
            $this->db
            ->select('CD.id')
            ->from('candidato_documento as CD')
            ->where('CD.id_candidato',$id_candidato)
            ->where('CD.id_tipo_documento',$id_documento);

            $query = $this->db->get();
            return $query->num_rows();
        }
        function getSeccion($id_seccion){
            $this->db
            ->select('*')
            ->from('seccion')
            ->where('id',$id_seccion);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getSeccionesPrevias(){
            $this->db
            ->select('id, proyecto')
            ->from('candidato_seccion')
            ->where('proyecto !=', NULL)
            ->order_by('proyecto','ASC')
            ->group_by('proyecto');

            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getSeccionCandidato($id_seccion){
            $this->db
            ->select('*')
            ->from('candidato_seccion')
            ->where('id',$id_seccion);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function getHistorialProyectos($id_cliente){
            $this->db
            ->select('id, proyecto')
            ->from('proyectos_historial')
            ->where('proyecto !=', NULL)
            ->where('id_cliente', $id_cliente)
            ->where('status', 1)
            ->order_by('proyecto','ASC');

            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getProyectoPrevio($id_previo){
            $this->db
            ->select('*')
            ->from('proyectos_historial')
            ->where('id',$id_previo);
    
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        }
        function checkHistorialProyectos($proyecto){
            $this->db
            ->select('id')
            ->from('proyectos_historial')
            ->where('proyecto',$proyecto);

            $query = $this->db->get();
            return $query->num_rows();
        }
        function guardarHistorialProyecto($proyecto){
            $this->db->insert('proyectos_historial', $proyecto);
        }
        function getDocumentosCandidatoRequeridos($id_candidato){
            $this->db
            ->select('*')
            ->from('candidato_documento_requerido')
            ->where('id_candidato',$id_candidato)
            ->order_by('obligatorio','DESC');

            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getDocumentoEspecificoRequerido($id_candidato, $id){
            $this->db
            ->select('*')
            ->from('candidato_documento_requerido')
            ->where('id_candidato',$id_candidato)
            ->where('id_tipo_documento',$id);

            $consulta = $this->db->get();
            return $consulta->row();
        }
    /*----------------------------------------*/
    /* Visitador
    /*----------------------------------------*/   
      // function getCandidatosVisitador($id_visitador){
      //   if($id_visitador != 52){
      //       $data['clientes'] = $this->getClientesVisita();
      //       foreach($data['clientes'] as $cl){
      //           $clientes[] = $cl->id_cliente;
      //       }
      //   }
      //   else{
      //       $clientes[] = 16;
      //       $clientes[] = 130;
      //       $clientes[] = 134;
      //       $clientes[] = 139;
      //       $clientes[] = 163;
      //       $clientes[] = 159;
      //   }
      //   $this->db
      //   ->select(" c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, mun.nombre as municipio,v.comentarios as comentarioVisitador, CS.id_vivienda,CS.id_servicio,CS.id_salud,CS.id_finanzas,CS.id_seccion_verificacion_docs")
      //   ->from('visita as v')
      //   ->join("candidato as c","v.id_candidato = c.id")
      //   ->join("cliente as cl","cl.id = c.id_cliente")
      //   ->join("subcliente as sub","sub.id = c.id_subcliente","left")
      //   ->join("municipio as mun","mun.id = c.id_municipio","left")
      //   // ->join("candidato_egresos as F","F.id_candidato = c.id","left")
      //   // ->join("candidato_habitacion as Viv","Viv.id_candidato = c.id","left")
      //   // ->join("candidato_servicio as S","S.id_candidato = c.id","left")
      //   ->join("candidato_seccion as CS","CS.id_candidato = c.id")
      //   ->where('c.visitador', 0)
      //   ->where('c.cancelado', 0)
      //   ->where('c.eliminado', 0)
      //   ->where_in('cl.id', $clientes)
      //   ->order_by('c.status','ASC')
      //   ->order_by('c.fecha_alta','DESC');

      //   $query = $this->db->get();
      //   if($query->num_rows() > 0){
      //       return $query->result();
      //   }else{
      //       return FALSE;
      //   }
      // }
        function getCandidatosVisitador($id_visitador){
            if($id_visitador != 52 && $id_visitador != 105 && $id_visitador != 106 && $id_visitador != 110){
                $data['clientes'] = $this->getClientesVisita();
                foreach($data['clientes'] as $cl){
                    $clientes[] = $cl->id_cliente;
                }
            }
            elseif($id_visitador == 105){
                $clientes[] = 130;
            }
            elseif($id_visitador == 106){
                $clientes[] = 130;
                $clientes[] = 39;
                $clientes[] = 247;
            }
            elseif($id_visitador == 110){
                $clientes[] = 130;
                $clientes[] = 51;
                $clientes[] = 16;
                $clientes[] = 112;
                $clientes[] = 39;
                $clientes[] = 86;
                $clientes[] = 232;
            }
            else{
                $clientes[] = 16;
                $clientes[] = 130;
                $clientes[] = 134;
                $clientes[] = 139;
                $clientes[] = 163;
                $clientes[] = 159;
            }
            $this->db
            ->select(" c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente,v.comentarios as comentarioVisitador")
            ->from('visita as v')
            ->join("candidato as c","v.id_candidato = c.id")
            ->join("cliente as cl","cl.id = c.id_cliente")
            ->join("subcliente as sub","sub.id = c.id_subcliente","left")
            ->where('c.visitador', 0)
            ->where('c.cancelado', 0)
            ->where('c.eliminado', 0)
            ->where('c.tiempo_parcial <=', 30)
            ->where_in('cl.id', $clientes)
            ->order_by('c.status','ASC')
            ->order_by('c.fecha_alta','DESC');
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
        function getClientesVisita(){
            $this->db
            ->select(" p.*, cl.nombre as cliente")
            ->from('permiso as p')
            ->join("cliente as cl","cl.id = p.id_cliente")
            ->where('cl.ingles', 0)
            ->order_by('p.id','ASC');
    
            $query = $this->db->get();
            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return FALSE;
            }
        }
    /*----------------------------------------*/
    /* Panel Subclientes Espanol General
    /*----------------------------------------*/  
    function checkAvances($id_candidato, $id_rol =null) {
        
    
        $this->db
            ->select('detalle.*, av.id as idAvance, av.finalizado, c.status, us.id_rol')
            ->from('avance_detalle as detalle')
            ->join('avance as av', 'av.id = detalle.id_avance')
            ->join('candidato as c', 'c.id = av.id_candidato')
            ->join('usuario as us', 'av.id_usuario = us.id')
            ->where('av.id_candidato', $id_candidato)
            ->order_by('detalle.fecha', 'DESC');
    
        if ($id_rol == 7) {
            // Si el rol es 7, solo permitir los mensajes del usuario con rol 7
            $this->db->where('us.id_rol', $id_rol);
        } elseif ($id_rol == 2 || $id_rol == 9) {
            // Si el rol es 2 o 9, permitir mensajes de usuarios con rol 2 o 9
            $this->db->where('(us.id_rol = 2 OR us.id_rol = 9)');
        }
        // No aplicar restricciones si el rol es diferente a 7, 2 o 9
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }














    /*----------------------------------------*/
    /*  Metodos de Mensajes de Avances
    /*----------------------------------------*/
    function createEstatusAvance($data){
      $this->db->insert('avance',$data);
      return $this->db->insert_id();
    }
    function createDetalleEstatusAvance($data){
      $this->db->insert('avance_detalle',$data);
    }
    
    /*----------------------------------------*/
    /*  CRUD y Metodos Generales para Candidato
    /*----------------------------------------*/
    
    
    
    
    
    /*----------------------------------------*/
    /*  Proceso Candidato
    /*----------------------------------------*/
    
    
    
    
    function getTipoDoc($tipo){
        $this->db
        ->select('*')
        ->from('tipo_documentacion')
        ->where('id', $tipo);
    
        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    function getEstatusEstudios($id_candidato){
        $this->db
        ->select('*')
        ->from('verificacion_estudios')
        ->where('id_candidato',$id_candidato);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function checkEstatusEstudios($id_candidato){
        $this->db
        ->select('detalle.*, est.id as idVerificacion, est.finalizado, est.status')
        ->from('verificacion_estudios_detalle as detalle')
        ->join('verificacion_estudios as est','est.id = detalle.id_verificacion_estudio')
        ->where('est.id_candidato',$id_candidato)
        ->order_by('detalle.id','DESC');
    
        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    function crearEstatusEstudios($datos){
        $this->db->insert('verificacion_estudios', $datos);
        $id = $this->db->insert_id();
        return  $id;
    }
    function guardarDetalleEstatusEstudio($detalles){
        $this->db->insert('verificacion_estudios_detalle', $detalles);
    }
    function editarDetalleEstatusEstudio($detalles, $id_detalle){
        $this->db
        ->where('id',$id_detalle)
        ->update('verificacion_estudios_detalle',$detalles);
    }
    function eliminarDetalleEstatusEstudio($id_detalle){
        $this->db->where('id', $id_detalle)
        ->delete('verificacion_estudios_detalle');
    }
    function editarEstatusEstudios($datos, $id){
        $this->db
        ->where('id', $id)
        ->update('verificacion_estudios', $datos);
    }
    function finishEstatusEstudios($id_verificacion, $date, $id_usuario){
        $this->db
        ->set('edicion',$date)
        ->set('id_usuario',$id_usuario)
        ->set('finalizado',1)
        ->set('fecha_finalizado',$date)
        ->where('id', $id_verificacion)
        ->update('verificacion_estudios');
    }
    function getEstatusLaborales($id_candidato){
        $this->db
        ->select('*')
        ->from('status_ref_laboral')
        ->where('id_candidato',$id_candidato);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function checkEstatusLaborales($id_candidato){
        $this->db
        ->select('detalle.*, lab.id as idVerificacion, lab.finalizado, lab.status')
        ->from('status_ref_laboral_detalle as detalle')
        ->join('status_ref_laboral as lab','lab.id = detalle.id_status_ref_laboral')
        ->where('lab.id_candidato',$id_candidato)
        ->order_by('detalle.id','DESC');
    
        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    function crearEstatusLaborales($datos){
        $this->db->insert('status_ref_laboral', $datos);
        $id = $this->db->insert_id();
        return  $id;
    }
    function guardarDetalleEstatusLaboral($detalles){
        $this->db->insert('status_ref_laboral_detalle', $detalles);
    }
    function editarDetalleEstatusLaboral($detalles, $id_detalle){
        $this->db
        ->where('id',$id_detalle)
        ->update('status_ref_laboral_detalle',$detalles);
    }
    function eliminarDetalleEstatusLaboral($id_detalle){
        $this->db->where('id', $id_detalle)
        ->delete('status_ref_laboral_detalle');
    }
    function editarEstatusLaborales($datos, $id){
        $this->db
        ->where('id', $id)
        ->update('status_ref_laboral', $datos);
    }
    function finishEstatusLaborales($id_status, $date, $id_usuario){
        $this->db
        ->set('edicion',$date)
        ->set('id_usuario',$id_usuario)
        ->set('finalizado',1)
        ->set('fecha_finalizado',$date)
        ->where('id', $id_status)
        ->update('status_ref_laboral');
    }
    function getEstatusPenales($id_candidato){
        $this->db
        ->select('*')
        ->from('verificacion_penales')
        ->where('id_candidato',$id_candidato);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function checkEstatusPenales($id_candidato){
        $this->db
        ->select('detalle.*, p.id as idVerificacion, p.finalizado, p.status')
        ->from('verificacion_penales_detalle as detalle')
        ->join('verificacion_penales as p','p.id = detalle.id_verificacion_penales')
        ->where('p.id_candidato',$id_candidato)
        ->order_by('detalle.id','DESC');
    
        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    function crearEstatusPenales($datos){
        $this->db->insert('verificacion_penales', $datos);
        $id = $this->db->insert_id();
        return  $id;
    }
    function crearDetalleEstatusPenales($detalles){
        $this->db->insert('verificacion_penales_detalle', $detalles);
    }
    function editarDetalleEstatusPenales($detalles, $id_detalle){
        $this->db
        ->where('id',$id_detalle)
        ->update('verificacion_penales_detalle',$detalles);
    }
    function eliminarDetalleEstatusPenales($id_detalle){
        $this->db->where('id', $id_detalle)
        ->delete('verificacion_penales_detalle');
    }
    function editarEstatusPenales($datos, $id){
        $this->db
        ->where('id', $id)
        ->update('verificacion_penales', $datos);
    }
    function finishEstatusPenales($id_status, $date, $id_usuario){
        $this->db
        ->set('edicion',$date)
        ->set('id_usuario',$id_usuario)
        ->set('finalizado',1)
        ->set('fecha_finalizado',$date)
        ->where('id', $id_status)
        ->update('verificacion_penales');
    }
    
    
    
    
    
    
    /*----------------------------------------*/
    /*  
    /*----------------------------------------*/
  //Consulta si el candidato existe
  function existeCandidato($correo, $pass){
    $this->db
    ->select("c.id, c.nombre, c.paterno, c.materno, c.correo, c.celular, c.status, c.fecha_nacimiento, c.id_tipo_proceso, c.id_proyecto, c.id_subcliente, c.fecha_contestado as formulario_contestado, c.fecha_documentos as documentos_cargados, c.id_cliente, c.tipo_formulario, CLI.ingles, S.proyecto, CLI.nombre as cliente,c.trabajo_gobierno, c.trabajo_inactivo")
    ->from('candidato as c')
    ->join('cliente as CLI','CLI.id = c.id_cliente','left')
    ->join('candidato_seccion as S','S.id_candidato = c.id','left')
    ->where('c.correo', $correo)
    ->where('c.token', $pass)
    //->where_in('c.status', [0,1])
    ->where('c.eliminado', 0);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
    function getEstados(){
        $this->db
        ->select('*')
        ->from('estado')
        ->order_by('nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    
    function getDocs($id_candidato){
        $this->db
        ->select('*')
        ->from('candidato_documento')
        ->where('id_candidato',$id_candidato)
        ->where('eliminado', 0);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    
  //Obtiene los tipos de documentos
  
    
    function checkDoc($archivo){
        $this->db
        ->select("*")
        ->from("candidato_documento")
        ->where("archivo", $archivo);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    //Guarda el registro de candidato_persona en la BD
    
    function updatePersona($data_persona, $id_candidato, $parentesco){
        $this->db
        ->where('id_candidato', $id_candidato)
        ->where('id_tipo_parentesco', $parentesco)
        ->update('candidato_persona', $data_persona);
    }
    
    
    
    
    
    function cleanDocs($id_candidato){
        $this->db->where('id_candidato', $id_candidato)
        ->delete('candidato_documento');
    }    
    
    function checkDocumentos($id_candidato){
        $query = $this->db
        ->query('SELECT * FROM candidato_documento WHERE id_candidato = '.$id_candidato.' AND  id_tipo_documento IN (3, 7, 10, 12, 2, 15, 14, 20) ');
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    
    function checkFamiliares($id_candidato){
        $query = $this->db
        ->query('SELECT * FROM candidato_persona WHERE id_candidato = '.$id_candidato.' ');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
  //Verifica si hay estatus de verificacion de los estudios
  
  //Genera registro para dar estatus de la verificacion de los estudios
  
  //Crea registro detalle de la verificacion de estudios
  
  //Termina con el registro de estatus de verificacion de estudios
  
  //Verifica si hay estatus de verificacion de los estudios
  
  //Genera registro para dar estatus de la verificacion de las ref laborales
  
  //Crea registro detalle de la verificacion de la referencia laboral
  
  //Termina con el registro de estatus de verificacion de ref laborales
  
  //Verifica si hay estatus de verificacion de los antecedentes no penales
  
  //Genera registro para dar estatus de los antecedentes no penales
  
  //Crea registro detalle de la verificacion de los antecedentes no penales
  
  //Termina con el registro de estatus de verificacion de los antecedentes no penales
  
    
    
  //Obtiene las verificaciones laborales del candidato
  
  
  //Borra el registro de los documentos para posteriormente insertar los nuevos
    
    
    
  //Actualiza la verificacion de estudios
  function updateVerificacionEstudios($verificacion_estudios, $id_candidato){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->update('candidato_estudios', $verificacion_estudios);
  }
  //Consultamos si hay registros de verificaciones laborales para y asea insertar o editarlas
  function consultVerificacionLaboral($id_candidato){
    $this->db
    ->select("lab.*")
    ->from("verificacion_ref_laboral as lab");

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  //Inserta el registro de verificacion laboral
  
  //Actualiza la verificacion de la referencia laboral
  function updateVerificacionLaboral($verificacion_reflab, $id_candidato, $numero_referencia){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->where('numero_referencia', $numero_referencia)
    ->update('verificacion_ref_laboral', $verificacion_reflab);
  }
  
  
    function revisionVerificacionDocumentos($id_candidato){
        $this->db
        ->select('*')
        ->from('verificacion_documento')
        ->where('id_candidato', $id_candidato);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
  //Revisa si el candidato posee los suficientes datos de los estudios para generar documento final
  function revisionVerificacionEstudios($id_candidato){
    $this->db
    ->select('*')
    ->from('candidato_estudios')
    ->where('id_candidato', $id_candidato);
    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  //Revisa si el candidato posee los suficientes datos de las referencias laborales para generar documento final
  function revisionVerificacionLaboral($id_candidato){
    $this->db
    ->select('*')
    ->from('verificacion_ref_laboral')
    ->where('id_candidato', $id_candidato);
    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
    function revisionVerificacionPersonal($id_candidato){
        $this->db
        ->select('comentario')
        ->from('candidato_ref_personal')
        ->where('id_candidato', $id_candidato);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function revisionVerificacionArchivos($id_candidato){
        $this->db
        ->select('doc.id_tipo_documento')
        ->from('cliente_documentos as doc')
        ->join('candidato as c','c.id_cliente = doc.id_cliente')
        ->where('c.id', $id_candidato);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function revisionVerificacionDomicilios($id_candidato){
        $this->db
        ->select('id')
        ->from('verificacion_domicilio')
        ->where('id_candidato', $id_candidato);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function confirmarAntidoping($id_candidato){
        $this->db
        ->select('tipo_antidoping, status_doping')
        ->from('candidato_pruebas')
        ->where('id_candidato', $id_candidato);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
        
    }
    function revisionAntidoping($id_candidato){
        $this->db
        ->select('id')
        ->from('doping')
        ->where('id_candidato', $id_candidato)
        ->where('resultado !=', -1);

        $query = $this->db->get();
        return $query->num_rows();
        
    }
    function revisionGlobalSearches($id_candidato){
        $this->db
        ->select('id')
        ->from('candidato_global_searches')
        ->where('id_candidato', $id_candidato);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    
    
    function getCivil($id_civil){
        $this->db
        ->select('nombre')
        ->from('estado_civil')
        ->where('id',$id_civil);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
  //Obtiene el estado del candidato para el documento final
  function getEstado($id_estado){
    $this->db
    ->select('nombre')
    ->from('estado')
    ->where('id',$id_estado);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  //Obtiene el municipio del candidato para el documento final
  function getMunicipio($id_municipio){
    $this->db
    ->select('nombre')
    ->from('municipio')
    ->where('id',$id_municipio);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  //Obtiene el tipo de transporte del candidato para el documento final
  function getTransporte($id_transporte){
    $this->db
    ->select('nombre')
    ->from('tipo_transporte')
    ->where('id',$id_transporte);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  //Obtiene la verificacion de documentos del candidato para el documento final
  
  //Obtiene los familiares del candidato para el documento final
  
  //Obtiene los estudios del candidato para el documento final
  
  //Obtiene las verificaciones del estatus académico del candidato para el documento final
  
  //Obtiene las verificaciones del estatus de empleo del candidato para el documento final
  
  //Obtiene las verificaciones del estatus de antecdentes no penales del candidato para el documento final
  
    function getCandidatos($id_cliente){
        $this->db
        ->select(" c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as nombreCompleto, pro.nombre as proyecto, sub.nombre as subcliente,dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, lab.id as idVerificacionLaboral, pen.finalizado as penales_finalizado, global.id as idGlobal, doc.ine, doc.ine_institucion, dom.comentario as comentario_domicilios, refpro.id as idRefPro ")
        ->from('candidato as c')
        ->join('proyecto as pro','pro.id = c.id_proyecto','left')
        ->join('cliente as cl','cl.id = c.id_cliente','left')
        ->join('subcliente as sub','sub.id = c.id_subcliente','left')
        ->join('doping as dop','dop.id_candidato = c.id','left')
        ->join('verificacion_ref_laboral as lab','lab.id_candidato = c.id','left')
        ->join('verificacion_penales as pen','pen.id_candidato = c.id','left')
        ->join('candidato_global_searches as global','global.id_candidato = c.id','left')
        ->join('verificacion_documento as doc','doc.id_candidato = c.id','left')
        ->join('verificacion_domicilio as dom','dom.id_candidato = c.id','left')
        ->join('candidato_ref_profesional as refpro','refpro.id_candidato = c.id','left')
        ->where('c.id_cliente', $id_cliente)
        ->where('c.eliminado', 0)
        ->group_by('c.id')
        ->order_by('c.status','ASC')
        ->order_by('c.fecha_alta','DESC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getCandidatosSubcliente($id_cliente, $id_subcliente){
        $this->db
        ->select(" c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as nombreCompleto, pro.nombre as proyecto, sub.nombre as subcliente, dop.id as idDoping, dop.fecha_resultado, dop.resultado as resultado_doping, lab.id as idVerificacionLaboral, pen.finalizado as penales_finalizado, global.id as idGlobal, doc.ine, doc.ine_institucion, dom.comentario as comentario_domicilios ")
        ->from('candidato as c')
        ->join('proyecto as pro','pro.id = c.id_proyecto','left')
        ->join('cliente as cl','cl.id = c.id_cliente','left')
        ->join('subcliente as sub','sub.id = c.id_subcliente','left')
        ->join('doping as dop','dop.id_candidato = c.id','left')
        ->join('verificacion_ref_laboral as lab','lab.id_candidato = c.id','left')
        ->join('verificacion_penales as pen','pen.id_candidato = c.id','left')
        ->join('candidato_global_searches as global','global.id_candidato = c.id','left')
        ->join('verificacion_documento as doc','doc.id_candidato = c.id','left')
        ->join('verificacion_domicilio as dom','dom.id_candidato = c.id','left')
        ->where('c.id_cliente', $id_cliente)
        ->where('c.id_subcliente', $id_subcliente)
        ->where('c.eliminado', 0)
        ->where('c.cancelado', 0)
        ->group_by('c.id')
        ->order_by('c.status','ASC')
        ->order_by('c.id','DESC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getCandidatosSubclienteTotal($id_cliente, $id_subcliente){
        $this->db
        ->select("c.id")
        ->from('candidato as c')
        ->join('proyecto as pro','pro.id = c.id_proyecto','left')
        ->join('cliente as cl','cl.id = c.id_cliente','left')
        ->join('subcliente as sub','sub.id = c.id_subcliente','left')
        ->join('doping as dop','dop.id_candidato = c.id','left')
        ->join('verificacion_ref_laboral as lab','lab.id_candidato = c.id','left')
        ->join('verificacion_penales as pen','pen.id_candidato = c.id','left')
        ->join('candidato_global_searches as global','global.id_candidato = c.id','left')
        ->join('verificacion_documento as doc','doc.id_candidato = c.id','left')
        ->join('verificacion_domicilio as dom','dom.id_candidato = c.id','left')
        ->where('c.id_cliente', $id_cliente)
        ->where('c.id_subcliente', $id_subcliente)
        ->where('c.eliminado', 0)
        ->where('c.cancelado', 0)
        ->group_by('c.id');

        $query = $this->db->get();
        return $query->num_rows();
    }
    function getTotalCandidatos($id_cliente){
        $this->db
        ->select("*")
        ->from("candidato")
        ->where('id_cliente',$id_cliente)
        //->where("status", 1)
        ->where("eliminado", 0);

        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function existeCandidatoCancelado($nombre, $proyecto, $id_cliente){
        $this->db
        ->select('id')
        ->from('candidato')
        ->where('nombre', $nombre)
        ->where('id_cliente', $id_cliente)
        ->where('eliminado', 0)
        ->where('id_proyecto', $proyecto);

        $query = $this->db->get();
        return $query->num_rows();
    }
  
  //Se genera otra contraseña al candidato
  
    function cancel($id_candidato, $date, $id_usuario_cliente){
        $this->db
        ->set('edicion', $date)
        ->set('id_usuario_cliente', $id_usuario_cliente)
        ->set('cancelado', 1)
        ->where('id', $id_candidato)
        ->update('candidato');
    }
    function motivoCancelar($id_candidato, $motivo, $date){
        $this->db
        ->set('creacion',$date)
        ->set('id_candidato',$id_candidato)
        ->set('motivo',$motivo)
        ->insert('candidato_cancelado');
    }
    function delete($id_candidato, $date, $id_usuario_cliente){
        $this->db
        ->set('edicion', $date)
        ->set('id_usuario_cliente', $id_usuario_cliente)
        ->set('eliminado', 1)
        ->where('id', $id_candidato)
        ->update('candidato');
    }
    function motivoEliminar($id_candidato, $motivo, $date){
        $this->db
        ->set('creacion',$date)
        ->set('id_candidato',$id_candidato)
        ->set('motivo',$motivo)
        ->insert('candidato_eliminado');
    }
  //Obtiene el nombre de la analista del candidato
  
  //Obtiene el nombre de la coordinadora del candidato
  
    function cleanFamiliares($id_candidato, $parentesco){
        $this->db
        ->where('id_candidato', $id_candidato)
        ->where('id_tipo_parentesco', $parentesco)
        ->delete('candidato_persona');
    }
    function cleanFamiliaresCandidato($id_candidato){
        $this->db
        ->where('id_candidato', $id_candidato)
        ->delete('candidato_persona');
    }
    
  //Edita la persona familiar del candidato
  function editPersona($data, $id_candidato){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->update('candidato_persona', $data);
  }
  //Obtiene el motivo de cancelacion del candidato
  function getCancelacion($id_candidato){
    $this->db
    ->select("creacion, motivo")
    ->from('candidato_cancelado')
    ->where('id_candidato',$id_candidato);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  //Obtiene el motivo de eliminacion del candidato
  function getEliminacion($id_candidato){
    $this->db
    ->select("creacion, motivo")
    ->from('candidato_eliminado')
    ->where('id_candidato',$id_candidato);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
    
    
    
    function checkLlamadas($id_candidato){
        $this->db
        ->select('detalle.*, ll.id as idLlamada, ll.finalizado, c.status')
        ->from('llamada_detalle as detalle')
        ->join('llamada as ll','ll.id = detalle.id_llamada')
        ->join('candidato as c','c.id = ll.id_candidato')
        ->where('ll.id_candidato',$id_candidato)
        ->order_by('detalle.fecha','DESC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function createEstatusLlamada($id_candidato, $id_usuario, $date){
        $this->db
        ->set('creacion',$date)
        ->set('edicion',$date)
        ->set('id_usuario',$id_usuario)
        ->set('id_candidato',$id_candidato)
        ->set('fecha_solicitud',$date)
        ->insert('llamada');

        $id = $this->db->insert_id();
        return  $id;
    }
    function createDetalleEstatusLlamada($nueva_llamada, $date, $comentario){
        $this->db
        ->set('id_llamada',$nueva_llamada)
        ->set('fecha',$date)
        ->set('comentarios',$comentario)
        ->insert('llamada_detalle');
    }
    function checkEmails($id_candidato){
        $this->db
        ->select('detalle.*, email.id as idEmail, email.finalizado, c.status')
        ->from('email_detalle as detalle')
        ->join('email','email.id = detalle.id_email')
        ->join('candidato as c','c.id = email.id_candidato')
        ->where('email.id_candidato',$id_candidato)
        ->order_by('detalle.fecha','DESC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function createEstatusEmail($id_candidato, $id_usuario, $date){
        $this->db
        ->set('creacion',$date)
        ->set('edicion',$date)
        ->set('id_usuario',$id_usuario)
        ->set('id_candidato',$id_candidato)
        ->set('fecha_solicitud',$date)
        ->insert('email');

        $id = $this->db->insert_id();
        return  $id;
    }
    function createDetalleEstatusEmail($nuevo_email, $date, $comentario){
        $this->db
        ->set('id_email',$nuevo_email)
        ->set('fecha',$date)
        ->set('comentarios',$comentario)
        ->insert('email_detalle');
    }
    
    
    
  function getComentario($id_candidato){
    $this->db
    ->select("comentario")
    ->from('candidato')
    ->where('id',$id_candidato);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getDocumentos($id_candidato){
    $this->db
    ->select("doc.*, tipo.nombre as tipo")
    ->from('candidato_documento as doc')
    ->join('tipo_documentacion as tipo','tipo.id = doc.id_tipo_documento')
    ->where('doc.id_candidato',$id_candidato);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  
  
  function getPuesto($puesto){
    $this->db
    ->select('nombre')
    ->from('psicometrico_bateria')
    ->where('id',$puesto);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function addCandidato($data){
    $this->db->insert('candidato', $data);
    $id = $this->db->insert_id();
    return  $id;
  }
  
  
  function updatePruebasCandidato($pruebas, $idPrueba){
    $this->db
    ->where('id', $idPrueba)
    ->update('candidato_pruebas', $pruebas);
  }
  
  function getPaqueteAntidoping($id_paq_antidoping){
    $this->db
    ->select('paq.nombre')
    ->from('antidoping_paquete as paq')
    ->where('paq.id',$id_paq_antidoping);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getSustanciaAntidoping($sustancia){
    $this->db
    ->select('s.abreviatura')
    ->from('antidoping_sustancia as s')
    ->where('s.id',$sustancia);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getBateria($id_bateria){
    $this->db
    ->select('bat.nombre')
    ->from('psicometrico_bateria as bat')
    ->where('bat.id',$id_bateria);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getPruebasPsicometrico($prueba){
    $this->db
    ->select('p.abreviatura')
    ->from('psicometrico_prueba as p')
    ->where('p.id',$prueba);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getBuroCredito($id_buro){
    $this->db
    ->select('b.nombre')
    ->from('tipo_buro_credito as b')
    ->where('b.id',$id_buro);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
    function insertDocCandidato($doc){
        $this->db->insert('candidato_documento', $doc);
    }
    function checkDocsCandidato($id_candidato){
        $this->db
        ->select('*')
        ->from('candidato_documento')
        ->where('id_candidato',$id_candidato);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
  }
  
    function revisionOfacCandidato($id_candidato){
        $this->db
        ->select('*')
        ->from('candidato_pruebas')
        ->where('id_candidato', $id_candidato);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getSublientes($id_cliente){
        $this->db
        ->select('*')
        ->from('subcliente')
        ->where('id_cliente',$id_cliente);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function existeVisita($id_candidato){
        $this->db
        ->select('id')
        ->from('visita')
        ->where('id_candidato',$id_candidato);

        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function addVisita($visita){
        $this->db->insert('visita', $visita);
    }
    
    function getHorasVisitas(){
        $this->db
        ->select('fecha_visita, hora_inicio, hora_fin')
        ->from('visita');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    /*----------------------------------------*/
    /*  TATA
    /*----------------------------------------*/
    function getCandidatosFinalizadosTata($id_cliente){
        $this->db
        ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, pro.nombre as proyecto, pru.tipo_antidoping, CONCAT(u.nombre,' ',u.paterno) as analista")
        ->from('candidato as c')
        ->join('candidato_pruebas as pru','pru.id_candidato = c.id',"left")
        ->join('usuario as u','u.id = c.id_usuario',"left")
        ->join('proyecto as pro','pro.id = c.id_proyecto')
        ->join('candidato_bgc as bgc','bgc.id_candidato = c.id')
        ->where('c.id_cliente', $id_cliente)
        ->where('c.eliminado', 0)
        ->where('c.status', 2)
        ->where('pru.socioeconomico', 1)
        ->where('bgc.creacion >', '2020-11-11 00:00:00')
        ->order_by('bgc.creacion','DESC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    function getDetalleCandidatoTata($idCandidato){
        $this->db
        ->select("c.*, bgc.creacion as fecha_final, c.nombre as candidato, pro.nombre as proyecto, CONCAT(u.nombre,' ',u.paterno) as analista, bgc.tiempo")
        ->from('candidato as c')
        ->join('usuario as u','u.id = c.id_usuario',"left")
        ->join('proyecto as pro','pro.id = c.id_proyecto')
        ->join('candidato_bgc as bgc','bgc.id_candidato = c.id')
        ->where('c.id', $idCandidato);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    /*----------------------------------------*/
    /*  HCL
    /*----------------------------------------*/
    
    function getProyectosSubcliente($id_cliente, $id_subcliente){
        $this->db
        ->select('*')
        ->from('proyecto')
        ->where('id_cliente',$id_cliente)
        ->where('id_subcliente',$id_subcliente);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getPaqueteSubclienteProyecto($id_cliente, $id_subcliente, $id_proyecto){
        $this->db
        ->select('paq.*')
        ->from('cliente_doping as cl')
        ->join('antidoping_paquete as paq','paq.id = cl.id_antidoping_paquete')
        ->where('cl.id_cliente', $id_cliente)
        ->where('cl.id_subcliente', $id_subcliente)
        ->where('cl.id_proyecto', $id_proyecto)
        ->where('cl.status', 1);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getPaqueteAntidopingCandidato($id_cliente, $proyecto){
        $this->db
        ->select('*')
        ->from('cliente_doping')
        ->where('id_cliente',$id_cliente)
        ->where('id_proyecto',$proyecto);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    
    
    
    
    
    function getTipoStudies($id_grado_estudio){
        $this->db
        ->select('*')
        ->from('tipo_studies')
        ->where('id',$id_grado_estudio);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function getVerificacionLaboral($cont, $id_candidato){
        $this->db
        ->select('lab.*')
        ->from('verificacion_ref_laboral as lab')
        ->where('lab.id_candidato', $id_candidato)
        ->where('lab.numero_referencia', $cont);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function actualizaVerificacionLaboral($verificacion_reflab, $id_verificacion){
        $this->db
        ->where('id', $id_verificacion)
        ->update('verificacion_ref_laboral', $verificacion_reflab);
    }
    function checkGlobalSearches($id_candidato){
        $this->db
        ->select('gl.*')
        ->from('candidato_global_searches as gl')
        ->where('gl.id_candidato',$id_candidato);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    
    
    
    /*----------------------------------------*/
    /*  #Privacidad
    /*----------------------------------------*/
			function getPrivacidad($id){
				$this->db
				->select("privacidad")
				->from("candidato")
				->where('id', $id);

				$query = $this->db->get();
				return $query->row();
			}
			function getAllPrivacidad(){
				$this->db
				->select("privacidad")
				->from("candidato")
				->group_by('privacidad');

				$query = $this->db->get();
        if($query->num_rows() > 0){
					return $query->result();
        }else{
					return FALSE;
        }
			}
    
    
    

    /*********************************************** VISITADOR ****************************************************/
    function getTotalCandidatosVisitador(){
        $this->db
        ->select("v.id")
        ->from('visita as v')
        ->join("candidato as c","v.id_candidato = c.id")
        ->join("cliente as cl","cl.id = c.id_cliente")
        ->join("subcliente as sub","sub.id = c.id_subcliente","left")
        //->where('cl.ingles', 0)
        //->where("status", 1)
        ->where("c.eliminado", 0);

        $query = $this->db->get();
        return $query->num_rows();
    }
    
    

    /*********************************************** OPERADOR ****************************************************/
    function checkCandidatoRepetido($nombre, $paterno, $materno, $id_cliente){
         $this->db
        ->select('c.id')
        ->from('candidato as c')
        ->join("candidato_pruebas as pr","pr.id_candidato = c.id")
        ->where('c.nombre', $nombre)
        ->where('c.paterno', $paterno)
        ->where('c.materno', $materno)
        ->where('c.id_cliente', $id_cliente)
        ->where('c.id_puesto !=', 0)
        ->where('pr.socioeconomico', 1)
        ->where('c.eliminado', 0);

        $query = $this->db->get();
        return $query->num_rows();
    }
    function vieneDoping($nombre, $paterno, $materno, $id_cliente){
         $this->db
        ->select('c.id as idCandidato, dop.id as idDop, pr.id as idPrueba')
        ->from('candidato as c')
        ->join("candidato_pruebas as pr","pr.id_candidato = c.id")
        ->join("doping as dop","dop.id_candidato = c.id")
        ->where('c.nombre', $nombre)
        ->where('c.paterno', $paterno)
        ->where('c.materno', $materno)
        ->where('c.id_cliente', $id_cliente)
        ->where('c.id_puesto', 0)
        ->where('pr.socioeconomico', 0)
        ->where('c.eliminado', 0);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    
    
    function getPaqueteAntidopingOperador($id_cliente, $id_subcliente){
        $this->db
        ->select('*')
        ->from('cliente_doping')
        ->where('id_cliente',$id_cliente)
        ->where('id_subcliente',$id_subcliente);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    
    function saveSociales($sociales){
        $this->db->insert('candidato_antecedentes_sociales', $sociales);
    }
    function updateSociales($sociales, $id_candidato){
        $this->db
        ->where('id_candidato', $id_candidato)
        ->update('candidato_antecedentes_sociales', $sociales);
    }
    
    
    
    
    
    
    
    function updatePersonaOperador($datos, $id_persona){
        $this->db
        ->where('id', $id_persona)
        ->update('candidato_persona', $datos);
    }
    
    
    
    
    
    
    
    
    
    
    
    function saveVerLaboral($data){
        $this->db->insert('verificacion_ref_laboral', $data);
        $id = $this->db->insert_id();
        return  $id;
    }
    
    
    function updateVerLaboral($data, $idver){
        $this->db
        ->where('id', $idver)
        ->update('verificacion_ref_laboral', $data);
    }
    
    
    
    function saveTrabajosNoMencionados($datos){
        $this->db->insert('verificacion_no_mencionados', $datos);
        $id = $this->db->insert_id();
        return  $id;
    }
    function updateTrabajosNoMencionados($datos, $id_nomen){
        $this->db
        ->where('id', $id_nomen)
        ->update('verificacion_no_mencionados', $datos);
    }
    
    
    function existeReferenciaPersonal($id_candidato, $id_ref){
        $this->db
        ->select('id')
        ->from('candidato_ref_personal')
        ->where('id', $id_ref)
        ->where('id_candidato', $id_candidato);
        $query = $this->db->get();
        return $query->num_rows();

    }
    
    
    function existeReferenciaVecinal($id_candidato, $id_ref){
        $this->db
        ->select('id')
        ->from('candidato_vecino')
        ->where('id', $id_ref)
        ->where('id_candidato', $id_candidato);
        $query = $this->db->get();
        return $query->num_rows();

    }
    function revisionFamiliares($id_candidato){
        $this->db
        ->select('*')
        ->from('candidato_persona')
        ->where('id_candidato', $id_candidato);
        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    
    function revisionAntecedentesLaborales($id_candidato){
        $this->db
        ->select('*')
        ->from('candidato_antecedente_laboral')
        ->where('id_candidato', $id_candidato);
        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    
    
    function revisionVerLaboral($idver){
        $this->db
        ->select('*')
        ->from('verificacion_ref_laboral')
        ->where('id', $idver);
        $query = $this->db->get();
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return FALSE;
        }
    }
    
    
    
    
    
    function getInfoCandidato($id_candidato){
        $this->db
        ->select('c.*,fin.creacion as fecha_fin, cl.nombre as cliente, dop.id as idDoping, p.nombre as puesto, sub.nombre as subcliente')
        ->from('candidato as c')
        ->join('candidato_finalizado as fin','fin.id_candidato = c.id','left')
        ->join('cliente as cl','cl.id = c.id_cliente')
        ->join('subcliente as sub','sub.id = c.id_subcliente','left')
        ->join('doping as dop','dop.id_candidato = c.id','left')
        ->join('puesto as p','p.id = c.id_puesto','left')
        ->where('c.id',$id_candidato);
        //->where('c.status',2)
        //->where('c.status_bgc !=', 0);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    
    
    function getGradoEstudio($id_grado_estudio){
        $this->db
        ->select('*')
        ->from('grado_estudio')
        ->where('id',$id_grado_estudio);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    function updateReferenciaVecinal($id_refvecinal, $data){
        $this->db
        ->where('id', $id_refvecinal)
        ->update('candidato_vecino', $data);
    }
    function insertReferenciaVecinal($vecino){
        $this->db->insert('candidato_vecino', $vecino);
        $id = $this->db->insert_id();
        return  $id;
    }
    function getEgresos($id_candidato){
        $this->db
        ->select('eg.*')
        ->from('candidato_egresos as eg')
        ->where('eg.id_candidato', $id_candidato);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getEgresosFamiliares($id_candidato){
        $this->db
        ->select('*')
        ->from('candidato_egresos')
        ->where('id_candidato',$id_candidato);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function getHabitacion($id_candidato){
        $this->db
        ->select('hab.*, zona.nombre as zona, v.nombre as vivienda, cond.nombre as condiciones')
        ->from('candidato_habitacion as hab')
        ->join('tipo_nivel_zona as zona','zona.id = hab.id_tipo_nivel_zona')
        ->join('tipo_vivienda as v','v.id = hab.id_tipo_vivienda')
        ->join('tipo_condiciones as cond','cond.id = hab.id_tipo_condiciones')
        ->where('hab.id_candidato', $id_candidato);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    
    
    
    
    
    function verificarAntidoping($id_candidato){
        $this->db
        ->select('pru.*')
        ->from('candidato_pruebas as pru')
        ->where('pru.id_candidato', $id_candidato);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

    }
    function verificarVisita($id_candidato){
        $this->db
        ->select('v.id')
        ->from('visita as v')
        ->where('v.id_candidato', $id_candidato);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;

    }
    function accionCandidato($eliminacion){
        $this->db->insert("candidato_eliminado", $eliminacion);
    }
    function getCandidatosEliminados($id_cliente){
        $this->db
        ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, CONCAT(u.nombre,' ',u.paterno) as usuario, e.creacion as fecha_eliminado, e.motivo")
        ->from("candidato as c")
        ->join("candidato_eliminado as e","e.id_candidato = c.id")
        ->join("usuario as u","u.id = e.id_usuario","left")
        ->join("usuario_cliente as cl","cl.id = e.id_usuario_cliente","left")
        ->join("usuario_subcliente as sub","sub.id = e.id_usuario_subcliente","left")
        ->where("c.eliminado", 1)
        ->where("e.id_cliente", $id_cliente)
        ->order_by("c.nombre", 'ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getCandidatosEliminadosTATA($id_cliente){
        $this->db
        ->select("c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, CONCAT(u.nombre,' ',u.paterno) as usuario, e.creacion as fecha_eliminado, e.motivo")
        ->from("candidato as c")
        ->join("candidato_eliminado as e","e.id_candidato = c.id")
        ->join("usuario as u","u.id = e.id_usuario","left")
        ->join("usuario_cliente as cl","cl.id = e.id_usuario_cliente","left")
        ->join("usuario_subcliente as sub","sub.id = e.id_usuario_subcliente","left")
        ->join('candidato_pruebas as pru','pru.id_candidato = c.id',"left")
        ->where("c.eliminado", 1)
        ->where('c.id_cliente',3)
        ->where('pru.socioeconomico', 1)
        ->where('e.creacion >', '2020-11-11 00:00:00')
        ->order_by("e.creacion", 'DESC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    
    
    
    
    
    
    function checkVerificacionChecklist($id_candidato){
        $this->db
        ->select('v.id')
        ->from('verificacion_checklist as v')
        ->where('v.id_candidato', $id_candidato);

        $query = $this->db->get();
        return $query->num_rows();
    }
    
    
    function updateChecklist($verificacion, $id_checklist){
        $this->db
        ->where('id', $id_checklist)
        ->update('verificacion_checklist', $verificacion);
    }
    
    function getReferenciasProfesionales($id_candidato){
        $this->db
        ->select('pro.*')
        ->from('candidato_ref_profesional as pro')
        ->where('pro.id_candidato',$id_candidato)
        ->order_by('pro.numero','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }

    function checkAvisoPrivacidad($id_candidato){
        $this->db
        ->select('doc.id')
        ->from('candidato_documento as doc')
        ->where('doc.id_tipo_documento', 8)
        ->where('doc.id_candidato', $id_candidato);

        $query = $this->db->get();
        return $query->num_rows();
    }

    //* Mejorada
    function getUploadedDocumentsById($id_candidato){
      $this->db
      ->select('doc.id_tipo_documento')
      ->from('candidato_documento as doc')
      ->where('doc.id_candidato', $id_candidato);

      $query = $this->db->get();
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return FALSE;
      }
    }

    function getClientesByUsuario($id_usuario){
      $this->db
      ->select('P.id_cliente')
      ->from('usuario_permiso as UC')
      ->join('permiso as P','P.id = UC.id_permiso')
      ->join('cliente as C','C.id = P.id_cliente')
      ->where('P.id_usuario', $id_usuario);

      $query = $this->db->get();
      return $query->result_array();
    }
    function getClientesByCondicion(){
      $this->db
      ->select('P.id_cliente')
      ->from('usuario_permiso as UC')
      ->join('permiso as P','P.id = UC.id_permiso')
      ->join('cliente as C','C.id = P.id_cliente');

      $query = $this->db->get();
      return $query->result_array();
    }

    function make_query(){
      $id_usuario = $this->session->userdata('id');
      $id_rol = $this->session->userdata('idrol');
      $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario) : array('c.id_usuario >=' => 0);
      $order_column = array(
        'candidato',
        null,
        'sla',
        null,
        null,
        null,
        null,
        null
      );
      if($id_rol == 2){
        $clientes = $this->getClientesByUsuario($id_usuario);
        $clientesFiltrados = $this->db->where_in('c.id_cliente', $clientes);
      }
      else{
        $clientes = $this->getClientesByCondicion();
        $clientesFiltrados = $this->db->where_in('candidato as c');
      }
      // if(isset($_POST['search']['value'])){
      //   $busqueda = ' AND c.nombre LIKE "%'.$_POST['search']['value'].'%" ';
      //   $busqueda .= ' AND c.paterno LIKE "%'.$_POST['search']['value'].'%" ';
      //   $busqueda = ' AND c.materno LIKE "%'.$_POST['search']['value'].'%" ';
      //   $busqueda = ' AND CS.proyecto LIKE "%'.$_POST['search']['value'].'%" ';
      // }
       
      // $query = 
      // $this->db
      // ->query("SELECT c.id, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.fecha_domicilio as fecha_doc_domicilio, cl.nombre as cliente, sub.nombre as subcliente,  pru.status_doping as doping_hecho, pru.tipo_antidoping, pru.medico, pru.psicometrico, pru.socioeconomico, c.religion as personales_religion,  c.puesto as puesto_ingles, CONCAT(us.nombre,' ',us.paterno) as usuario, CS.secciones, CS.visita as seccion_visita,CS.tipo_conclusion,CS.proyecto as proyectoCandidato, CS.cantidad_ref_personales,CS.id_seccion_datos_generales,CS.id_seccion_social,CS.id_ref_personales,CS.id_empleos,CS.id_seccion_verificacion_docs,CS.id_finanzas, CS.cantidad_ref_vecinales, CS.lleva_gaps, CS.id_estudios, CS.lleva_salud, CS.id_salud,CS.id_vivienda,CS.id_servicio,CS.id_ref_vecinal,CS.lleva_empleos,CS.lleva_estudios,CS.lleva_criminal,CS.id_investigacion, CS.id_extra_laboral,CS.id_seccion_global_search,CONCAT(REC.nombre,' ',REC.paterno) as reclutadorAspirante,CS.id_no_mencionados,CS.id_referencia_cliente,CS.id_candidato_empresa, CS.cantidad_ref_clientes
      // FROM candidato as c 
      // JOIN cliente as cl ON cl.id = c.id_cliente
      // LEFT JOIN subcliente as sub ON sub.id = c.id_subcliente
      // JOIN candidato_pruebas as pru ON pru.id_candidato = c.id
      // LEFT JOIN usuario as us ON us.id = c.id_usuario
      // LEFT JOIN candidato_seccion as CS ON CS.id_candidato = c.id
      // LEFT JOIN requisicion_aspirante as ASP ON c.id_aspirante = ASP.id 
      // LEFT JOIN usuario as REC ON REC.id = ASP.id_usuario 
      // WHERE c.eliminado = 0 AND c.cancelado = 0 AND pru.socioeconomico = 1 AND c.status_bgc = 0
      // ORDER BY c.id ASC");
      $this->db->select("c.id, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.fecha_domicilio as fecha_doc_domicilio, cl.nombre as cliente, sub.nombre as subcliente,  pru.status_doping as doping_hecho, pru.tipo_antidoping, pru.medico, pru.psicometrico, pru.socioeconomico, c.religion as personales_religion,  c.puesto as puesto_ingles, CONCAT(us.nombre,' ',us.paterno) as usuario, CS.secciones, CS.visita as seccion_visita,CS.tipo_conclusion,CS.proyecto as proyectoCandidato, CS.cantidad_ref_personales,CS.id_seccion_datos_generales,CS.id_seccion_social,CS.id_ref_personales,CS.id_empleos,CS.id_seccion_verificacion_docs,CS.id_finanzas, CS.cantidad_ref_vecinales, CS.lleva_gaps, CS.id_estudios, CS.lleva_salud, CS.id_salud,CS.id_vivienda,CS.id_servicio,CS.id_ref_vecinal,CS.lleva_empleos,CS.lleva_estudios,CS.lleva_criminal,CS.id_investigacion, CS.id_extra_laboral,CS.id_seccion_global_search,CONCAT(REC.nombre,' ',REC.paterno) as reclutadorAspirante,CS.id_no_mencionados,CS.id_referencia_cliente,CS.id_candidato_empresa, CS.cantidad_ref_clientes");
      $this->db->from('candidato as c');
      $this->db->join("cliente as cl","cl.id = c.id_cliente");
      $this->db->join("subcliente as sub","sub.id = c.id_subcliente","left");
      // $this->db->join("grado_estudio as g","g.id = c.id_grado_estudio","left");
      // $this->db->join('doping as dop','dop.id_candidato = c.id AND dop.status = 0','left');
      $this->db->join('candidato_pruebas as pru','pru.id_candidato = c.id');
      // $this->db->join('puesto as p','p.id = c.id_puesto','left');
      // $this->db->join('estado','estado.id = c.id_estado','left');
      // $this->db->join('municipio as mun','mun.id = c.id_municipio','left');
      // $this->db->join('medico as m','c.id = m.id_candidato','left');
      // $this->db->join('psicometrico as psi','c.id = psi.id_candidato','left');
      // $this->db->join('candidato_finalizado as f','c.id = f.id_candidato','left');
      // $this->db->join('candidato_bgc as bgc','c.id = bgc.id_candidato','left');
      $this->db->join('usuario as us','us.id = c.id_usuario',"left");
      $this->db->join('candidato_seccion as CS','CS.id_candidato = c.id',"left");
      // $this->db->join('visita as vis','c.id = vis.id_candidato','left');
      $this->db->join('requisicion_aspirante as ASP','c.id_aspirante = ASP.id','left');
      $this->db->join('usuario as REC','REC.id = ASP.id_usuario',"left");
      //$this->db->join('beca as BECA','c.id = BECA.id_candidato','left');
      $this->db->where('c.eliminado', 0);
      $this->db->where('c.cancelado', 0);
      $this->db->where('pru.socioeconomico', 1);
      //$this->db->where('c.status_bgc', 0);
      //$clientesFiltrados;
      //$this->db->where('c.status <', 2);
      //$this->db->where($usuario);
      if(isset($_POST['search']['value'])){
        $this->db->like("c.nombre", $_POST['search']['value']);
        $this->db->or_like("c.paterno", $_POST['search']['value']);
        $this->db->or_like("c.materno", $_POST['search']['value']);
        $this->db->or_like("CS.proyecto", $_POST['search']['value']);
        $this->db->or_like("c.id", $_POST['search']['value']);
      }
      
      if(isset($_POST['order'])){
        $this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      }
      else{
        $this->db->order_by('c.id','ASC');
      }
      //$this->db->group_by('c.id');
    }

    function make_datatable(){
      $this->make_query();
      //$this->db->limit(10);
      if($_POST['length'] != -1){
        $this->db->limit($_POST['length'], $_POST['start']);
      }
      $query = $this->db->get();
      return $query->result();
    }
    function get_filtered_data(){
      $this->make_query();
      $query = $this->db->get();
      return $query->num_rows();
    }
    function get_all_data(){
      $id_usuario = $this->session->userdata('id');
      $id_rol = $this->session->userdata('idrol');
      $usuario = ($id_rol == 2)? array('c.id_usuario =' => $id_usuario) : array('c.id_usuario >=' => 0);
      if($id_rol == 2){
        $clientes = $this->getClientesByUsuario($id_usuario);
        $clientesFiltrados = $this->db->where_in('c.id_cliente', $clientes);
      }
      else{
        $clientes = $this->getClientesByCondicion();
        $clientesFiltrados = $this->db->where_in('candidato as c');
      }
      $this->db->select("c.id");
      $this->db->from('candidato as c');
      $this->db->join("cliente as cl","cl.id = c.id_cliente");
      $this->db->join('candidato_pruebas as pru','pru.id_candidato = c.id');
      //$clientesFiltrados;
      //$this->db->where('c.status <', 2);
      $this->db->where('c.eliminado', 0);
      $this->db->where('c.cancelado', 0);
      $this->db->where('pru.socioeconomico', 1);
      //$this->db->where('c.status_bgc', 0);
      //$this->db->where($usuario);
      return $this->db->count_all_results();
    }


}