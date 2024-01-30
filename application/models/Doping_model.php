<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doping_model extends CI_Model{

	/*----------------------------------------*/
	/*  Procedimiento normal (registros generales)
	/*----------------------------------------*/
		function getDopingsGeneralesTotal(){
			$this->db
			->select("dop.id")
			->from("doping as dop")
			->join("candidato as c","dop.id_candidato = c.id")
			->join('candidato_pruebas as pr','pr.id_candidato = c.id')
			->where('pr.tipo_antidoping !=', 0)
			->where('dop.fecha_resultado', NULL)
			->where("c.eliminado", 0);

			$query = $this->db->get();
			return $query->num_rows();
		}
		function getDopingsGenerales(){
			$this->db
			->select("dop.*, c.nombre, c.paterno, c.materno, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, pr.antidoping, c.fecha_nacimiento, CONCAT(u.nombre,' ',u.paterno) as usuario, pro.nombre as proyecto, paq.nombre as paquete, pr.socioeconomico, per.id as idPermiso")
			->from('doping as dop')
			->join('candidato as c','c.id = dop.id_candidato')
			->join('candidato_pruebas as pr','pr.id_candidato = c.id')
			->join('cliente as cl','cl.id = dop.id_cliente')
			->join('subcliente as sub','sub.id = dop.id_subcliente',"left")
			->join('usuario as u','u.id = dop.id_usuario')
			->join('proyecto as pro','pro.id = dop.id_proyecto',"left")
			->join('antidoping_paquete as paq','paq.id = dop.id_antidoping_paquete',"left")
			->join('permiso as per','per.id_cliente = cl.id',"left")
			->where('c.eliminado', 0)
			->where('pr.tipo_antidoping !=', 0)
			->where('dop.fecha_resultado', NULL)
			->order_by('dop.id','DESC')
			->group_by('dop.id');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
	/*----------------------------------------*/
	/*  Pendientes
	/*----------------------------------------*/
		function getDopingsPendientesTotal(){
			$this->db
			->select("pr.id")
			->from('candidato_pruebas as pr')
			->join('candidato as c','c.id = pr.id_candidato')
			->where_in('pr.tipo_antidoping', [1,2])
			->where('pr.status_doping', 0)
			->where('pr.socioeconomico', 1)
			->where('c.eliminado', 0);

			$query = $this->db->get();
			return $query->num_rows();
		}
		function getDopingsPendientes(){
			$this->db
			->select("c.id as idCandidato, c.id_cliente, c.id_subcliente, c.id_proyecto, c.fecha_alta, c.celular, c.telefono_casa, c.correo, pr.id_candidato, c.nombre, c.paterno, c.materno, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, pr.antidoping, c.fecha_nacimiento, CONCAT(u.nombre,' ',u.paterno) as usuario, pro.nombre as proyecto, paq.nombre as paquete, pr.socioeconomico")
			->from('candidato_pruebas as pr')
			->join('candidato as c','c.id = pr.id_candidato')
			->join('cliente as cl','cl.id = c.id_cliente')
			->join('subcliente as sub','sub.id = c.id_subcliente',"left")
			->join('usuario as u','u.id = c.id_usuario','left')
			->join('proyecto as pro','pro.id = c.id_proyecto',"left")
			->join('antidoping_paquete as paq','paq.id = pr.antidoping',"left")
			->where_in('pr.tipo_antidoping', [1,2])
			->where('pr.status_doping', 0)
			//->where('pr.socioeconomico', 1)
			//->where('dop.id', NULL)
			->where('c.cancelado', 0)
			->where('c.eliminado', 0)
			->order_by('c.id','DESC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
	/*----------------------------------------*/
	/*  Finalizados
	/*----------------------------------------*/
		function getDopingsFinalizadosFiltrados(){
			$this->db
			->select("dop.id, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, pro.nombre as proyecto, paq.nombre as paquete")
			->from('doping as dop')
			->join('candidato as c','c.id = dop.id_candidato')
			->join('candidato_pruebas as pr','pr.id_candidato = c.id')
			->join('cliente as cl','cl.id = dop.id_cliente')
			->join('subcliente as sub','sub.id = dop.id_subcliente',"left")
			->join('proyecto as pro','pro.id = dop.id_proyecto',"left")
			->join('antidoping_paquete as paq','paq.id = dop.id_antidoping_paquete',"left")
			->where('c.eliminado', 0)
			->where('pr.tipo_antidoping !=', 0)
			->where('pr.status_doping', 1)
			->where('dop.resultado !=', -1)
			->order_by('dop.id','DESC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
		function getDopingsFinalizadosTotal(){
			$this->db
			->select("dop.id")
			->from('doping as dop')
			->join('candidato as c','c.id = dop.id_candidato')
			->join('candidato_pruebas as pr','pr.id_candidato = c.id')
			->join('cliente as cl','cl.id = dop.id_cliente')
			->join('usuario as u','u.id = dop.id_usuario')
			->where('c.eliminado', 0)
			->where('pr.tipo_antidoping !=', 0)
			->where('pr.status_doping', 1)
			->where('dop.fecha_resultado !=', null);

			$query = $this->db->get();
			return $query->num_rows();
		}
		function getDopingsFinalizados(){
				$this->db
				->select("dop.id, c.nombre, c.paterno, c.materno, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, pr.antidoping, pro.nombre as proyecto, paq.nombre as paquete")
				->from('doping as dop')
				->join('candidato as c','c.id = dop.id_candidato')
				->join('candidato_pruebas as pr','pr.id_candidato = c.id')
				->join('cliente as cl','cl.id = dop.id_cliente')
				->join('subcliente as sub','sub.id = dop.id_subcliente',"left")
				//->join('usuario as u','u.id = dop.id_usuario')
				->join('proyecto as pro','pro.id = dop.id_proyecto',"left")
				->join('antidoping_paquete as paq','paq.id = dop.id_antidoping_paquete',"left")
				->where('c.eliminado', 0)
				->where('pr.tipo_antidoping !=', 0)
				->where('pr.status_doping', 1)
				->where('dop.fecha_resultado !=', null)
				->order_by('dop.id','DESC')
				->limit(2000);

				$query = $this->db->get();
				if($query->num_rows() > 0){
						return $query->result();
				}else{
						return FALSE;
				}
		}
		function getDopingsFinalizadosListado(){
			$this->db
			->select("dop.id, dop.id_candidato, dop.id_usuario, dop.codigo_prueba, dop.fecha_doping, dop.fecha_resultado, dop.resultado, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, dop.foraneo, cl.nombre as cliente, sub.nombre as subcliente, pro.nombre as proyecto, paq.nombre as paquete, CONCAT(u.nombre,' ',u.paterno) as usuario, c.id_subcliente, c.id_proyecto, c.id_cliente, c.fecha_nacimiento, dop.id_tipo_identificacion, dop.ine, dop.razon, dop.medicamentos, dop.foto, dop.comentarios, dop.id_antidoping_paquete, c.nombre, c.paterno, c.materno, pr.socioeconomico")
			->from('doping as dop')
			->join('candidato as c','c.id = dop.id_candidato')
			->join('candidato_pruebas as pr','pr.id_candidato = c.id')
			->join('cliente as cl','cl.id = c.id_cliente')
			->join('subcliente as sub','sub.id = c.id_subcliente',"left")
			->join('proyecto as pro','pro.id = c.id_proyecto',"left")
			->join('antidoping_paquete as paq','paq.id = dop.id_antidoping_paquete',"left")
			->join('usuario as u','u.id = dop.id_usuario',"left")
			->where('c.eliminado', 0)
			->where('pr.tipo_antidoping !=', 0)
			->where('pr.status_doping', 1)
			->where('dop.resultado !=', -1)
			->order_by('dop.id','DESC')
			->limit(25);

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
		function getDopingsFinalizadosListadoTotal(){
			$this->db
			->select("dop.id")
			->from('doping as dop')
			->join('candidato as c','c.id = dop.id_candidato')
			->join('candidato_pruebas as pr','pr.id_candidato = c.id')
			->where('c.eliminado', 0)
			->where('pr.tipo_antidoping !=', 0)
			->where('pr.status_doping', 1)
			->where('dop.resultado !=', -1);

			$query = $this->db->get();
			return $query->num_rows();
		}
		function getResultadoFiltrado($nombre, $paterno, $materno, $numero, $cliente, $inicio, $fin){
			$filtros = '';
			$filtros .= ($nombre != '' && $paterno != '' && $materno != '')? ' AND c.nombre LIKE "%'.$nombre.'%" AND c.paterno LIKE "%'.$paterno.'%" AND c.materno LIKE "%'.$materno.'%"' : '';
			$filtros .= ($nombre != '' && $paterno != '' && $materno == '')? ' AND c.nombre LIKE "%'.$nombre.'%" AND c.paterno LIKE "%'.$paterno.'%"' : '';
			$filtros .= ($numero != '')? ' AND dop.id = '.$numero : '';
			$filtros .= ($cliente != '' && $inicio != '' && $fin != '')? ' AND c.id_cliente = '.$cliente.' AND dop.fecha_doping >= "'.$inicio.' 00:00:00"  AND dop.fecha_resultado <= "'.$fin.' 23:59:59" ' : '';

			$query = $this->db
			->query("SELECT dop.id, dop.id_candidato, dop.id_usuario, dop.codigo_prueba, dop.fecha_doping, dop.fecha_resultado, dop.resultado, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, pro.nombre as proyecto, paq.nombre as paquete, CONCAT(u.nombre,' ',u.paterno) as usuario, c.id_subcliente, c.id_proyecto, c.id_cliente, c.fecha_nacimiento, dop.id_tipo_identificacion, dop.ine, dop.razon, dop.medicamentos, dop.foto, dop.comentarios, dop.id_antidoping_paquete, c.nombre, c.paterno, c.materno, pr.socioeconomico, dop.foraneo
							FROM doping as dop
							JOIN candidato as c ON c.id = dop.id_candidato
							JOIN candidato_pruebas as pr ON pr.id_candidato = c.id
							JOIN cliente as cl ON cl.id = c.id_cliente
							LEFT JOIN subcliente as sub ON sub.id = c.id_subcliente
							LEFT JOIN proyecto as pro ON pro.id = c.id_proyecto
							LEFT JOIN antidoping_paquete as paq ON paq.id = dop.id_antidoping_paquete
							LEFT JOIN usuario as u ON u.id = dop.id_usuario
							WHERE dop.eliminado = 0 AND pr.tipo_antidoping != 0 AND pr.status_doping = 1 AND dop.resultado != -1 ".$filtros."
							ORDER BY dop.id DESC");

			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
		function getResultadoFiltradoTotal($nombre, $paterno, $materno, $numero, $cliente, $inicio, $fin){
			$filtros = '';
			$filtros .= ($nombre != '' && $paterno != '' && $materno != '')? ' AND c.nombre LIKE "%'.$nombre.'%" AND c.paterno LIKE "%'.$paterno.'%" AND c.materno LIKE "%'.$materno.'%"' : '';
			$filtros .= ($nombre != '' && $paterno != '' && $materno == '')? ' AND c.nombre LIKE "%'.$nombre.'%" AND c.paterno LIKE "%'.$paterno.'%"' : '';
			$filtros .= ($numero != '')? ' AND dop.id = '.$numero : '';
			$filtros .= ($cliente != '' && $inicio != '' && $fin != '')? ' AND c.id_cliente = '.$cliente.' AND dop.fecha_doping >= "'.$inicio.' 00:00:00"  AND dop.fecha_resultado <= "'.$fin.' 23:59:59" ' : '';


			$query = $this->db
			->query("SELECT dop.id
							FROM doping as dop
							JOIN candidato as c ON c.id = dop.id_candidato
							JOIN candidato_pruebas as pr ON pr.id_candidato = c.id
							JOIN cliente as cl ON cl.id = c.id_cliente
							LEFT JOIN subcliente as sub ON sub.id = c.id_subcliente
							LEFT JOIN proyecto as pro ON pro.id = c.id_proyecto
							LEFT JOIN antidoping_paquete as paq ON paq.id = dop.id_antidoping_paquete
							LEFT JOIN usuario as u ON u.id = dop.id_usuario
							WHERE dop.eliminado = 0 AND pr.tipo_antidoping != 0 AND pr.status_doping = 1 AND dop.resultado != -1 ".$filtros." ");

			return $query->num_rows();
		}
	/*----------------------------------------*/
	/*  Funciones comunes
	/*----------------------------------------*/
		function insertCandidato($datos_candidato){
			$this->db->insert('candidato', $datos_candidato);
			$id = $this->db->insert_id();
			return  $id;
		}
    function getPaquetesAntidoping(){
        $this->db
        ->select('*')
        ->from('antidoping_paquete')
        ->where('status', 1)
        ->where('eliminado', 0)
        ->order_by('id','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
		function getDatosCandidato($id_candidato){
			$this->db
			->select('c.id, c.nombre, c.paterno, c.materno, c.id_cliente, c.id_subcliente, cl.clave as claveCliente, sub.clave as claveSubcliente, cl.nombre as cliente, sub.nombre as subcliente, pro.nombre as proyecto, c.fecha_nacimiento, c.id_proyecto, prueba.antidoping')
			->from('candidato as c')
			->join('cliente as cl','cl.id = c.id_cliente')
			->join('subcliente as sub','sub.id = c.id_subcliente','left')
			->join('proyecto as pro','pro.id = c.id_proyecto','left')
			->join('candidato_pruebas as prueba','prueba.id_candidato = c.id','left')
			->where('c.id', $id_candidato);

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
    }
		function getSustanciaCandidato($id_sustancia){
			$this->db
			->select('*')
			->from('antidoping_sustancia')
			->where('id', $id_sustancia);

			$consulta = $this->db->get();
			$resultado = $consulta->row();
			return $resultado;
		}
		function getDetallesParametro($id_doping, $id_parametro){
			$this->db
			->select('*')
			->from('doping_detalle')
			->where('id_doping', $id_doping)
			->where('id_sustancia', $id_parametro);

			$consulta = $this->db->get();
			$resultado = $consulta->row();
			return $resultado;
		}
		function eliminarParametro($id_doping, $id_parametro){
			$this->db
			->where('id_doping', $id_doping)
			->where('id', $id_parametro)
			->delete('doping_detalle');
		}
		function eliminarDoping($id_doping){
			$this->db
			->where('id', $id_doping)
			->delete('doping');
		}
		function eliminarDopingDetalle($id_doping){
			$this->db
			->where('id_doping', $id_doping)
			->delete('doping_detalle');
    }
		function eliminarCandidato($id_candidato){
			$this->db
			->where('id', $id_candidato)
			->delete('candidato');
    }
		function editarPruebasCandidato($pruebas, $id_candidato){
			$this->db
			->where('id_candidato', $id_candidato)
			->update('candidato_pruebas', $pruebas);
    }
		function eliminarPruebasCandidato($id_candidato){
			$this->db
			->where('id_candidato', $id_candidato)
			->delete('candidato_pruebas');
    }
    


    function getExamenDopingByProceso($id_proceso){
      $this->db
      ->select('PD.*,D.nombre as nombreDoping,D.conjunto')
      ->from('proceso_doping as PD')
      ->join('antidoping_paquete as D','D.id = PD.id_examen_doping')
      ->where('PD.status', 1)
      ->where('PD.id_proceso', $id_proceso)
      ->order_by('PD.id','ASC');

      $query = $this->db->get();
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return FALSE;
      }
    }
    function getExamenDopingByCliente($id_cliente){
      $this->db
      ->select('cl.id_antidoping_paquete, paq.nombre, paq.conjunto')
      ->from('cliente_doping as cl')
      ->join('antidoping_paquete as paq','paq.id = cl.id_antidoping_paquete')
      ->where('cl.id_cliente', $id_cliente)
      ->order_by('paq.nombre','ASC');

      $query = $this->db->get();
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return FALSE;
      }
      
  }


    

		function getCandidatosSinDoping(){
			$this->db
			->select('p.*,c.id as idCandidato, c.nombre, c.paterno, c.materno, cl.nombre as cliente, sub.nombre as subcliente, p.antidoping, pro.nombre as proyecto')
			->from('candidato_pruebas as p')
			->join('candidato as c','c.id = p.id_candidato')
			->join('cliente as cl','cl.id = c.id_cliente')
			->join('subcliente as sub','sub.id = c.id_subcliente','left')
			->join('proyecto as pro','pro.id = c.id_proyecto','left')
			->where_in('p.tipo_antidoping', [1,2])
			->where('p.status_doping', 0)
			->where('c.eliminado', 0)
			->order_by('c.paterno','ASC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
					return $query->result();
			}else{
					return FALSE;
			}
		}

    function getSubclientes($id_cliente){
        $this->db
        ->select('*')
        ->from('subcliente')
        ->where('id_cliente', $id_cliente)
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
    function getProyectos($id_cliente){
        $this->db
        ->select('*')
        ->from('proyecto')
        ->where('id_cliente', $id_cliente)
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
    function getProyectosSubcliente($id_cliente, $id_subcliente){
        $this->db
        ->select('*')
        ->from('proyecto')
        ->where('id_cliente', $id_cliente)
        ->where('id_subcliente', $id_subcliente)
        ->order_by('nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getPaqueteCliente($id_cliente, $id_subcliente, $id_proyecto){
        $this->db
        ->select('cl.id_antidoping_paquete, paq.nombre')
        ->from('cliente_doping as cl')
        ->join('antidoping_paquete as paq','paq.id = cl.id_antidoping_paquete')
        ->where('cl.id_cliente', $id_cliente)
        ->where('cl.id_subcliente', $id_subcliente)
        ->where('cl.id_proyecto', $id_proyecto);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
        
    }
    function getPaqueteSubcliente($id_cliente, $id_subcliente){
        $this->db
        ->select('id_antidoping_paquete')
        ->from('cliente_doping')
        ->where('id_cliente', $id_cliente)
        ->where('id_subcliente', $id_subcliente)
        ->where('id_proyecto', 0);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            $resultado = $query->row();
            return $resultado;
        }else{
            return FALSE;
        }
    }
    function getPaqueteSubclienteProyecto($id_cliente, $id_proyecto, $id_subcliente){
        $this->db
        ->select('id_antidoping_paquete')
        ->from('cliente_doping')
        ->where('id_cliente', $id_cliente)
        ->where('id_subcliente', $id_subcliente)
        ->where('id_proyecto', $id_proyecto);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            $resultado = $query->row();
            return $resultado;
        }else{
            return FALSE;
        }
    }
    function ultimoDoping(){
        $this->db
        ->select("dop.id")
        ->from("doping as dop")
        ->order_by("dop.id","DESC")
        ->limit(1);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function getParametrosCandidato($id_candidato){
        $this->db
        ->select('tipo_antidoping, antidoping')
        ->from('candidato_pruebas')
        ->where('id_candidato', $id_candidato);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getPaqueteCandidato($parametros){
        $this->db
        ->select('*')
        ->from('antidoping_paquete')
        ->where('id', $parametros);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
    function insertDoping($doping){
        $this->db->insert('doping', $doping);
        $id = $this->db->insert_id();
        return  $id;
    }
    function editarDoping($doping, $id_doping){
        $this->db
        ->where('id', $id_doping)
        ->update('doping', $doping);
    }
    function insertDetalleDoping($detalle){
        $this->db->insert('doping_detalle', $detalle);
    }
    
    function updatePruebaCandidato($id_candidato, $prueba){
        $this->db
        ->where('id_candidato', $id_candidato)
        ->update('candidato_pruebas', $prueba);
    }
    function checkPendienteDoping($nombre, $paterno, $materno){
        $this->db
        ->select('p.*,c.id as idCandidato, c.nombre, c.paterno, c.materno')
        ->from('candidato_pruebas as p')
        ->join('candidato as c','c.id = p.id_candidato')
        ->where("c.nombre", $nombre)
        ->where("c.paterno", $paterno)
        ->where("c.materno", $materno)
        ->where('p.tipo_antidoping', 1)
        ->where('p.status_doping', 0);

        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function updateCandidato($datos_candidato, $id_candidato){
        $this->db
        ->where('id', $id_candidato)
        ->update('candidato', $datos_candidato);        
    }
    function insertCandidatoPruebas($pruebas){
        $this->db->insert('candidato_pruebas', $pruebas);
    }
    function updateCandidatoPruebas($pruebas, $id_candidato){
        $this->db
        ->where('id_candidato', $id_candidato)
        ->update('candidato_pruebas', $pruebas);
    }
    function getDopingCandidato($id_doping){
        $this->db
        ->select("dop.*, tipo.nombre as identificacion")
        ->from("doping as dop")
        ->join("tipo_identificacion as tipo","tipo.id = dop.id_tipo_identificacion")
        ->where("dop.id", $id_doping);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function insertFacturaCandidato($datos_factura, $id_doping){
        $this->db
        ->where('id', $id_doping)
        ->update('doping', $datos_factura);
    }
    function getSustanciasDoping($id_doping){
        $this->db
        ->select('*')
        ->from('doping_detalle')
        ->where('id_doping', $id_doping);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function updateResultadoDoping($id_doping, $id_sustancia, $res){
        $this->db
        ->where('id_doping', $id_doping)
        ->where('id_sustancia', $id_sustancia)
        ->update('doping_detalle', $res);
    }
    function deleteDoping($id_doping, $borrado){
        $this->db
        ->where('id', $id_doping)
        ->update('doping', $borrado);
    }
    
    function getDatosDoping($id_doping){
        $this->db
        ->select("dop.*, c.nombre, c.paterno, c.materno, paq.nombre as paquete, paq.sustancias, cl.nombre as cliente, sub.nombre as subcliente, det.id_sustancia, pro.nombre as proyecto, ide.nombre as identificacion, c.fecha_nacimiento, paq.nombre as drogas, CONCAT(US.nombre,' ',US.paterno,' ',US.materno) as responsable, A.profesion_responsable, A.firma as firmaResponsable, A.cedula ")
        ->from('doping as dop')
        ->join('doping_detalle as det','det.id_doping = dop.id')
        ->join('candidato as c','c.id = dop.id_candidato')
        ->join('antidoping_paquete as paq','paq.id = dop.id_antidoping_paquete')
        ->join('cliente as cl','cl.id = dop.id_cliente')
        ->join('subcliente as sub','sub.id = dop.id_subcliente','left')
        ->join('proyecto as pro','pro.id = dop.id_proyecto','left')
        ->join('tipo_identificacion as ide','ide.id = dop.id_tipo_identificacion','left')
        ->join('area as A','A.id = dop.id_area','left')
        ->join('usuario as US','US.id = A.usuario_responsable','left')
        ->where('dop.id', $id_doping)
        ->where('dop.eliminado', 0);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function getLastDoping(){
        $this->db
        ->select('id')
        ->from('doping')
        ->order_by('id', 'DESC')
        ->limit(1);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function getDetalleDoping($idDoping){
        $this->db
        ->select("dop.*, c.nombre, c.paterno, c.materno, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, pr.antidoping, c.fecha_nacimiento, CONCAT(u.nombre,' ',u.paterno) as usuario, pro.nombre as proyecto, paq.nombre as paquete")
        ->from('doping as dop')
        ->join('candidato as c','c.id = dop.id_candidato')
        ->join('candidato_pruebas as pr','pr.id_candidato = c.id')
        ->join('cliente as cl','cl.id = dop.id_cliente')
        ->join('subcliente as sub','sub.id = dop.id_subcliente',"left")
        ->join('usuario as u','u.id = dop.id_usuario')
        ->join('proyecto as pro','pro.id = dop.id_proyecto',"left")
        ->join('antidoping_paquete as paq','paq.id = dop.id_antidoping_paquete',"left")
        ->where('c.eliminado', 0)
        ->where('pr.tipo_antidoping !=', 0)
        ->where('pr.status_doping', 1)
        ->where('dop.fecha_resultado !=', null)
        ->where('dop.id', $idDoping);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    function cambiarEstatusDoping($id_candidato){
        $this->db
        ->set('status', 1)
        ->where('id_candidato', $id_candidato)
        ->update('doping');
    }
}