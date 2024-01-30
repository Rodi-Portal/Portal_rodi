<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_model extends CI_Model{

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
        ->order_by('nombre','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getClientes(){
        $this->db
        ->select('*')
        ->from('cliente')
        ->where('habilitado', 1)
        ->order_by('id','ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getUsuarios(){
        $this->db
        ->select('id')
        ->from('usuario')
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
    function reporteDopingFinalizados($f_inicio, $f_fin, $cliente, $subcliente, $proyecto, $resultado, $lab){
        $filtros = "";
        $filtros .= ($f_inicio != "" && $f_inicio != null) ? "dop.fecha_resultado >= '$f_inicio 00:00:00' " : "";
        $filtros .= ($f_fin != "" && $f_fin != null) ? " AND dop.fecha_resultado <= '$f_fin 23:59:59' " : "";
        $filtros .= ($cliente == "" || $cliente == null || $cliente == 0)? "":" AND dop.id_cliente = ".$cliente;
        $filtros .= ($subcliente == "" || $subcliente == null || $subcliente == 0)? "":" AND dop.id_subcliente = ".$subcliente;
        $filtros .= ($proyecto == "" || $proyecto == null || $proyecto == 0)? "":" AND dop.id_proyecto = ".$proyecto;
        $filtros .= ($resultado == "" || $resultado == null)? "":" AND dop.resultado = ".$resultado;
        $filtros .= ($lab == "" || $lab == null)? "":" AND dop.laboratorio = '$lab' ";

        $query = $this->db
        ->query("SELECT dop.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, pro.nombre as proyecto, paq.nombre as parametros
            FROM doping as dop 
            JOIN candidato as c ON c.id = dop.id_candidato
            JOIN cliente as cl ON cl.id = dop.id_cliente
            LEFT JOIN subcliente as sub ON sub.id = dop.id_subcliente
            LEFT JOIN proyecto as pro ON pro.id = dop.id_proyecto
            JOIN antidoping_paquete as paq ON paq.id = dop.id_antidoping_paquete
            WHERE  ".$filtros."
            ORDER BY dop.fecha_resultado DESC, cl.nombre ASC, dop.codigo_prueba ASC");

            if($query->num_rows() > 0){
                return $query->result();
            }
            else{
                return FALSE;
            }
    }
    function reporteFinalizados_HCL_UST($f_inicio, $f_fin, $cliente, $usuario){
        $filtros = "";
        $filtros .= ($f_inicio != "" && $f_inicio != null) ? "bgc.creacion >= '$f_inicio 00:00:00' " : "";
        $filtros .= ($f_fin != "" && $f_fin != null) ? " AND bgc.creacion <= '$f_fin 23:59:59' " : "";
        $filtros .= ($cliente == "" || $cliente == null || $cliente == 0)? "":" AND c.id_cliente = ".$cliente;
        $filtros .= ($usuario == "" || $usuario == null || $usuario == 0)? "":" AND c.id_usuario = ".$usuario;
        //$filtros .= "AND u.status = 1 AND u.eliminado = 0 AND u.id_rol = 2";
        //$filtros .= " AND pr.socioeconomico = 1 OR pr.id IS NULL ";

        $query = $this->db
        ->query("SELECT c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, CONCAT(u.nombre,' ',u.paterno) as usuario, bgc.creacion as fecha_final, bgc.tiempo
            FROM candidato as c 
            JOIN candidato_bgc as bgc ON c.id = bgc.id_candidato
            JOIN cliente as cl ON cl.id = c.id_cliente
            JOIN usuario as u ON u.id = c.id_usuario
            LEFT JOIN candidato_pruebas as pr ON pr.id_candidato = c.id
            WHERE  ".$filtros."
            ORDER BY u.nombre ASC, bgc.creacion DESC");

            if($query->num_rows() > 0){
                return $query->result();
            }
            else{
                return FALSE;
            }
    }
    function reporteFinalizados_TATA_WIPRO($f_inicio, $f_fin, $cliente, $usuario){
        $filtros = "";
        $filtros .= ($f_inicio != "" && $f_inicio != null) ? "c.edicion >= '$f_inicio 00:00:00' " : "";
        $filtros .= ($f_fin != "" && $f_fin != null) ? " AND c.edicion <= '$f_fin 23:59:59' " : "";
        $filtros .= ($cliente == "" || $cliente == null || $cliente == 0)? "":" AND c.id_cliente = ".$cliente;
        $filtros .= ($usuario == "" || $usuario == null || $usuario == 0)? "":" AND c.id_usuario = ".$usuario;
        //$filtros .= "AND u.status = 1 AND u.eliminado = 0 AND u.id_rol = 2";
        $filtros .= " AND pr.socioeconomico = 1";

        $query = $this->db
        ->query("SELECT c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, CONCAT(u.nombre,' ',u.paterno) as usuario, c.edicion as fecha_final
            FROM candidato as c 
            JOIN cliente as cl ON cl.id = c.id_cliente
            JOIN usuario as u ON u.id = c.id_usuario
            JOIN candidato_pruebas as pr ON pr.id_candidato = c.id
            WHERE  ".$filtros."
            ORDER BY u.nombre ASC, c.edicion DESC");

            if($query->num_rows() > 0){
                return $query->result();
            }
            else{
                return FALSE;
            }
    }
    function reporteFinalizados_Espanol($f_inicio, $f_fin, $cliente, $usuario){
        $filtros = "";
        $filtros .= ($f_inicio != "" && $f_inicio != null) ? "f.creacion >= '$f_inicio 00:00:00' " : "";
        $filtros .= ($f_fin != "" && $f_fin != null) ? " AND f.creacion <= '$f_fin 23:59:59' " : "";
        $filtros .= ($cliente == "" || $cliente == null || $cliente == 0)? "":" AND c.id_cliente = ".$cliente;
        $filtros .= ($usuario == "" || $usuario == null || $usuario == 0)? "":" AND c.id_usuario = ".$usuario;
        //$filtros .= "AND u.status = 1 AND u.eliminado = 0 AND u.id_rol = 2";
        $filtros .= " AND pr.socioeconomico = 1";

        $query = $this->db
        ->query("SELECT c.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, CONCAT(u.nombre,' ',u.paterno) as usuario, f.creacion as fecha_final, f.tiempo
            FROM candidato as c 
            JOIN candidato_finalizado as f ON c.id = f.id_candidato
            JOIN cliente as cl ON cl.id = c.id_cliente
            JOIN usuario as u ON u.id = c.id_usuario
            JOIN candidato_pruebas as pr ON pr.id_candidato = c.id
            WHERE  ".$filtros."
            ORDER BY u.nombre ASC, f.creacion DESC");

            if($query->num_rows() > 0){
                return $query->result();
            }
            else{
                return FALSE;
            }
    }
    function reporteDopingGeneral($f_inicio, $f_fin, $cliente, $subcliente, $proyecto){
        $filtros = "";
        $filtros .= ($f_inicio != "" && $f_inicio != null) ? "dop.creacion >= '$f_inicio 00:00:00' " : "";
        $filtros .= ($f_fin != "" && $f_fin != null) ? " AND dop.creacion <= '$f_fin 23:59:59' " : "";
        $filtros .= ($cliente == "" || $cliente == null || $cliente == 0)? "":" AND dop.id_cliente = ".$cliente;
        $filtros .= ($subcliente == "" || $subcliente == null || $subcliente == 0)? "":" AND dop.id_subcliente = ".$subcliente;
        $filtros .= ($proyecto == "" || $proyecto == null || $proyecto == 0)? "":" AND dop.id_proyecto = ".$proyecto;

        $query = $this->db
        ->query("SELECT dop.*, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, sub.nombre as subcliente, pro.nombre as proyecto, paq.nombre as parametros
            FROM doping as dop 
            JOIN candidato as c ON c.id = dop.id_candidato
            JOIN cliente as cl ON cl.id = dop.id_cliente
            LEFT JOIN subcliente as sub ON sub.id = dop.id_subcliente
            LEFT JOIN proyecto as pro ON pro.id = dop.id_proyecto
            JOIN antidoping_paquete as paq ON paq.id = dop.id_antidoping_paquete
            WHERE  ".$filtros."
            ORDER BY dop.creacion DESC, cl.nombre ASC, dop.codigo_prueba ASC");

            if($query->num_rows() > 0){
                return $query->result();
            }
            else{
                return FALSE;
            }
    }
    function reporteSLAIngles($f_inicio, $f_fin, $cliente, $finalizado){
        $filtros = "";
        $filtros .= ($f_inicio != "" && $f_inicio != null) ? "c.fecha_alta >= '$f_inicio 00:00:00' " : "";
        $filtros .= ($f_fin != "" && $f_fin != null) ? " AND c.fecha_alta <= '$f_fin 23:59:59' " : "";
        $filtros .= ($cliente == "" || $cliente == null || $cliente == 0)? "":" AND c.id_cliente = ".$cliente;
        if($finalizado == 'Si'){
            $filtros .= ' AND c.status = 2';
        }
        if($finalizado == 'No'){
            $filtros .= ' AND c.status IN (0,1)';
        }

        $query = $this->db
        ->query("SELECT c.fecha_alta, c.status, c.fecha_inicio, c.fecha_contestado, c.fecha_documentos, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, c.subproyecto as proyecto, bgc.creacion as fecha_final
            FROM candidato as c 
            JOIN cliente as cl ON cl.id = c.id_cliente 
            LEFT JOIN candidato_bgc as bgc ON bgc.id_candidato = c.id 
            JOIN candidato_pruebas as pru ON pru.id_candidato = c.id 
            WHERE pru.socioeconomico = 1 AND c.eliminado = 0 AND c.cancelado = 0 AND  ".$filtros."
            ORDER BY c.fecha_alta DESC, c.nombre ASC");

        if($query->num_rows() > 0){
            return $query->result();
        }
        else{
            return FALSE;
        }
    }
    function reporteListadoDopingTodos($f_inicio, $f_fin, $cliente){
        $filtros = "";
        $filtros .= ($f_inicio != "" && $f_inicio != null) ? "c.fecha_alta >= '$f_inicio 00:00:00' " : "";
        $filtros .= ($f_fin != "" && $f_fin != null) ? " AND c.fecha_alta <= '$f_fin 23:59:59' " : "";
        $filtros .= ($cliente == "" || $cliente == 0)? "":" AND c.id_cliente = ".$cliente;

        $query = $this->db
        ->query("SELECT c.fecha_alta, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, c.subproyecto as proyecto, dop.fecha_doping, dop.fecha_resultado, dop.resultado, ant.nombre as examen, ant.conjunto, pru.status_doping, pru.tipo_antidoping, dop.id as idDoping
            FROM candidato as c 
            JOIN cliente as cl ON cl.id = c.id_cliente 
            LEFT JOIN doping as dop ON dop.id_candidato = c.id 
            JOIN candidato_pruebas as pru ON pru.id_candidato = c.id
            LEFT JOIN antidoping_paquete as ant ON ant.id = pru.antidoping
            WHERE c.eliminado = 0 AND c.cancelado = 0 AND  ".$filtros."
            ORDER BY c.fecha_alta DESC, c.nombre ASC");
        if($query->num_rows() > 0){
            return $query->result();
        }
        else{
            return FALSE;
        }
        
    }
    function reporteListadoDopingResultados($f_inicio, $f_fin, $cliente, $res){
        $filtros = "";
        $filtros .= ($f_inicio != "" && $f_inicio != null) ? "c.fecha_alta >= '$f_inicio 00:00:00' " : "";
        $filtros .= ($f_fin != "" && $f_fin != null) ? " AND c.fecha_alta <= '$f_fin 23:59:59' " : "";
        $filtros .= ($cliente == "" || $cliente == 0)? "":" AND c.id_cliente = ".$cliente;
        if($res == -1){
            $filtros .= ' AND dop.resultado = -1';
        }
        if($res == 0){
            $filtros .= ' AND dop.resultado = 0';
        }
        if($res == 1){
            $filtros .= ' AND dop.resultado = 1';
        }

        $query = $this->db
        ->query("SELECT c.fecha_alta, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, cl.nombre as cliente, c.subproyecto as proyecto, dop.fecha_doping, dop.fecha_resultado, dop.resultado, ant.nombre as examen, ant.conjunto, pru.status_doping, pru.tipo_antidoping, dop.id as idDoping
            FROM candidato as c 
            JOIN cliente as cl ON cl.id = c.id_cliente 
            JOIN doping as dop ON dop.id_candidato = c.id 
            JOIN candidato_pruebas as pru ON pru.id_candidato = c.id
            JOIN antidoping_paquete as ant ON ant.id = pru.antidoping
            WHERE c.eliminado = 0 AND c.cancelado = 0 AND  ".$filtros."
            ORDER BY c.fecha_alta DESC, c.nombre ASC");
        if($query->num_rows() > 0){
            return $query->result();
        }
        else{
            return FALSE;
        }
        
    }
    function reporteListadoDopingClientes($cliente){
			$filtros = "";
			//$filtros .= ($f_inicio != "" && $f_inicio != null) ? "c.fecha_alta >= '$f_inicio 00:00:00' " : "";
			//$filtros .= ($f_fin != "" && $f_fin != null) ? " AND c.fecha_alta <= '$f_fin 23:59:59' " : "";
			$filtros .= ($cliente == "" || $cliente == 0)? "":" AND C.id = ".$cliente;

			$query = $this->db
			->query("SELECT C.*,S.nombre as subcliente, S.clave as claveSubcliente
							FROM cliente as C 
							LEFT JOIN subcliente as S ON S.id_cliente = C.id AND S.eliminado = 0
							WHERE C.eliminado = 0 ".$filtros."
							ORDER BY C.id DESC");
			if($query->num_rows() > 0){
				return $query->result();
			}
			else{
				return FALSE;
			}
    }


    function reporteListadoEstudios($f_inicio, $f_fin, $cliente, $res, $estatus){
      $filtros = "";
      $filtros .= ($f_inicio != "" && $f_inicio != null) ? "c.fecha_alta >= '$f_inicio 00:00:00' " : "";
      $filtros .= ($f_fin != "" && $f_fin != null) ? " AND c.fecha_alta <= '$f_fin 23:59:59' " : "";
      $filtros .= ($cliente == "" || $cliente == 0)? "":" AND c.id_cliente = ".$cliente;
      if($cliente != 1){
        $filtros .= ' AND p.socioeconomico = 1';
      }
      if($estatus == 1){
        $filtros .= " AND c.status < 2";
      }
      if($estatus == 2){
        //$filtros .= " AND c.status = 2";
        $filtros .= ' AND c.status_bgc > 0';
      }
      if($res >= 1 && $res <= 5){
        $filtros .= ' AND c.status_bgc = '.$res.'';
      }
      //$centro_costo = ($centro_costo == 'true')? ',c.centro_costo,' : ',';
      
      $query = $this->db
      ->query("SELECT c.fecha_alta, c.centro_costo, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, bgc.creacion as fechaBGC, f.creacion as fechaFinal, cl.nombre as cliente, sub.nombre as subcliente, c.status, c.status_bgc, s.proyecto
          FROM candidato as c 
          JOIN cliente as cl ON cl.id = c.id_cliente 
          LEFT JOIN subcliente as sub ON sub.id = c.id_subcliente
          LEFT JOIN candidato_seccion as s ON s.id_candidato = c.id
          LEFT JOIN candidato_bgc as bgc ON bgc.id_candidato = c.id
          LEFT JOIN candidato_finalizado as f ON f.id_candidato = c.id
          LEFT JOIN candidato_pruebas as p ON p.id_candidato = c.id
          WHERE c.eliminado = 0 AND c.cancelado = 0 AND ".$filtros."
          ORDER BY c.fecha_alta DESC, c.nombre ASC");
      if($query->num_rows() > 0){
        return $query->result();
      }
      else{
        return FALSE;
      }
    }

    function reporteProcesoReclutamiento($f_inicio, $f_fin, $usuario){
      $filtros = "";
      $filtros .= ($f_inicio != "" && $f_inicio != null) ? "A.creacion >= '$f_inicio 00:00:00' " : "";
      $filtros .= ($f_fin != "" && $f_fin != null) ? " AND A.creacion <= '$f_fin 23:59:59' " : "";
      $filtros .= ($usuario == "" || $usuario == 0)? "":" AND B.id_usuario = ".$usuario;
      
      $query = $this->db
      ->query("SELECT A.creacion, A.id_requisicion, A.telefono, A.medio_contacto, A.sueldo_acordado, A.fecha_ingreso, A.pago, B.domicilio, CONCAT(A.nombre,' ',A.paterno,' ',A.materno) as aspirante, CONCAT(U.nombre,' ',U.paterno) as usuario, R.puesto, R.nombre as cliente, R.nombre_comercial, R.creacion as fechaRequisicion, (SELECT descripcion FROM aspirante_garantia WHERE id_aspirante = A.id ORDER BY id DESC LIMIT 1) AS garantia
          FROM requisicion_aspirante as A 
          JOIN bolsa_trabajo as B ON B.id = A.id_bolsa_trabajo 
          JOIN requisicion as R ON R.id = A.id_requisicion
          LEFT JOIN usuario as U ON U.id = B.id_usuario
          WHERE A.eliminado = 0 AND R.status = 2 AND ".$filtros."
          ORDER BY A.creacion DESC, A.nombre ASC");
      if($query->num_rows() > 0){
        return $query->result();
      }
      else{
        return FALSE;
      }
    }
}