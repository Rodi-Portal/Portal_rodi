<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reclutamiento_model extends CI_Model{

	/*----------------------------------------*/
	/*  Submenus 
	/*----------------------------------------*/
		function getAllOrders($sort, $id_order, $condition_order, $filter, $filterOrder){
			$this->db
			->select("R.id, R.creacion, cl.nombre, gencl.telefono, CONCAT(gencl.nombre,' ',gencl.paterno) as contacto, R.puesto, R.numero_vacantes, R.status, gencl.correo, R.tipo, CONCAT(genus.nombre,' ',genus.paterno) as usuario, cl.nombre")
			->from('requisicion as R')
			->join('usuarios_portal as U','U.id = R.id_usuario','left')
			->join('datos_generales as genus','U.id_datos_generales = genus.id','left')
			->join('cliente as cl','R.id_cliente = cl.id','left')
			->join('datos_generales as gencl','cl.id_datos_generales = gencl.id','left')
			->where($filterOrder, $filter)
			->where_in('R.status', [1,2])
      ->where($condition_order, $id_order)
      ->where('R.eliminado', 0)
			->order_by('R.id', $sort);

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
    function getOrdersByUser($id_usuario, $sort, $id_order, $condition_order){
			$this->db
			->select("R.id, R.creacion, CL.nombre, GENCL.telefono, CONCAT(GENCL.nombre,' ',GENCL.paterno) as contacto, R.puesto, R.numero_vacantes, R.status, GENCL.correo, R.tipo, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario,      FAC.razon_social as nombre_comercial")
			->from('requisicion as R')
			->join('usuarios_portal as U','U.id = R.id_usuario')
			->join('cliente as CL','CL.id = R.id_cliente')
			->join('datos_facturacion as FAC','FAC.id = CL.id_datos_facturacion')
			->join('datos_generales  as GENCL ','GENCL.id = CL.id_datos_generales')
			->join('requisicion_usuario as RU','RU.id_requisicion = R.id')
		
			->join('datos_generales  as GENUS ','GENUS.id = U.id_datos_generales')
			->where_in('R.status', [1,2])
			->where('RU.id_usuario', $id_usuario)
      ->where($condition_order, $id_order)
			->order_by('R.id',$sort)
      ->group_by('R.id');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
		function getRequisicionesEnProceso($id_usuario, $condicion){
			$this->db
			->select("r.id, CL.nombre, r.puesto, r.numero_vacantes, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario")
			->from('requisicion as r')
			->join('requisicion_usuario as RU','RU.id_requisicion = r.id')
			->join('usuario as USER','USER.id = RU.id_usuario')
			->join('datos_generales as GENUS','GENUS.id = U.id_datos_generales')
			->join('clientes as CL','CL.id = R.id_cliente')
			->join('datos_generales as GENCL','GENCL.id = CL.id_datos_generales')
			->where('r.eliminado', 0)
			->where('r.status', 2)
			->where($condicion, $id_usuario)
			->order_by('r.status','ASC')
      ->group_by('RU.id');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
    function getOrdersInProcessByUser($id_usuario){
			$this->db
			->select("R.id, CL.nombre, R.puesto, R.numero_vacantes, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario")
			->from('requisicion as R')
			->join('requisicion_usuario as RU','RU.id_requisicion = R.id')
			->join('usuarios_portal as U','U.id = RU.id_usuario')
			->join('datos_generales as GENUS','GENUS.id = U.id_datos_generales')
			->join('cliente as CL','CL.id = R.id_cliente')
			->join('datos_generales as GENCL','GENCL.id = CL.id_datos_generales')
			->where('R.eliminado', 0)
			->where('R.status', 2)
			->where('RU.id_usuario', $id_usuario)
			->order_by('R.status','ASC')
      ->group_by('RU.id');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
    function getAllOrdersInProcess() {
			try {
					$this->db
							->select("R.id, CL.nombre, R.puesto, R.numero_vacantes, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario")
							->from('requisicion as R')
							->join('usuarios_portal as U', 'U.id = R.id_usuario')
							->join('datos_generales as GENUS', 'GENUS.id = U.id_datos_generales', 'left')
							->join('cliente as CL', 'CL.id = R.id_cliente')
							->where('R.eliminado', 0)
							->where('R.status', 1)
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
    function getAllApplicants($id_usuario, $condition){
			$this->db
			->select("B.*, CONCAT(B.nombre,' ',B.paterno,' ',B.materno) as nombreCompleto, CONCAT(gen.nombre,' ',gen.paterno) as usuario")
			->from('bolsa_trabajo as B')
			->join('usuarios_portal as U', 'U.id = B.id_usuario','left')
			->join('datos_generales as gen', 'gen.id = U.id_datos_generales','left')
			->where($condition, $id_usuario)
			->order_by('B.id', 'DESC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
    function getBolsaTrabajo($sort, $id_applicant, $condition_applicant, $filter, $filterApplicant, $id_usuario, $condition_user, $area, $condition_area){
			$this->db
			->select("B.*, CONCAT(B.nombre,' ',B.paterno,' ',B.materno) as nombreCompleto, CONCAT(gen.nombre,' ',gen.paterno) as usuario")
			->from('bolsa_trabajo as B')
			->join('usuarios_portal as U', 'U.id = B.id_usuario','left')
			->join('datos_generales as gen', 'gen.id = U.id_datos_generales','left')
			->where($condition_area, $area)
			->where($filterApplicant, $filter)
			->where($condition_applicant, $id_applicant)
			->where($condition_user, $id_usuario)
			->order_by('B.id', $sort);

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
    function getApplicantsByUser($sort, $id_applicant, $condition_applicant, $filter, $filterApplicant, $id_usuario, $area, $condition_area){
			$this->db
			->select("B.*, CONCAT(B.nombre,' ',B.paterno,' ',B.materno) as nombreCompleto, CONCAT(GENUP.nombre,' ',GENUP.paterno) as usuario")
			->from('bolsa_trabajo as B')
			->join('usuarios_portal as U','U.id = B.id_usuario')
			->join('datos_generales as GENUP','GENUP.id = U.id_usuario')
      ->where($condition_area, $area)
			->where($filterApplicant, $filter)
      ->where($condition_applicant, $id_applicant)
			->where('B.id_usuario', $id_usuario)
			->order_by('B.id',$sort);

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
    function getRequisicionesActivas(){
			$this->db
			->select("R.*, C.nombre as nombreCompleto")
			->from('requisicion as R')
			->join('cliente as C','C.id = R.id_cliente')
			->where('R.eliminado', 0)
			->where_in('R.status', [1,2])
			->order_by('R.id','DESC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
    function getTestsByOrder($id){
			$this->db
			->select("R.*, CL.nombre as nombreCompleto,C.id as idCandidato,CONCAT(C.nombre,' ',C.paterno,' ',C.materno) as candidato,C.status_bgc, C.fecha_nacimiento, P.antidoping, P.status_doping, P.psicometrico, P.medico, DOP.id as idDoping, DOP.fecha_resultado,DOP.resultado as resultado_doping, M.id as idMedico, M.conclusion as conclusionMedica, PSI.id as idPsicometrico, PSI.archivo as archivoPsicometria ")
			->from('requisicion as R')
			->join('cliente as CL','CL.id= R.id_cliente')

      ->join('requisicion_aspirante as A','A.id_requisicion = R.id')
      ->join('candidato as C','C.id_aspirante = A.id')
      ->join('candidato_pruebas as P','P.id_candidato = C.id')
      ->join('doping as DOP','DOP.id_candidato = C.id','left')
      ->join('medico as M','M.id_candidato = C.id','left')
      ->join('psicometrico as PSI','PSI.id_candidato = C.id','left')
			->where('P.socioeconomico', 1)
			->where('R.id', $id)
			->order_by('C.creacion','ASC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}

		function getRequisionById($id){
		
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
    CONCAT(GEN.nombre, ' ', GEN.paterno) as contacto, FAC.forma_pago, FAC.metodo_pago, FAC.uso_cfdi as uso_cfdi, FAC.rfc, FAC.regimen ")
    ->from('requisicion as R') 
    ->join('cliente as CL', 'CL.id = R.id_cliente')
    ->join('domicilios as DOM', 'DOM.id = CL.id_domicilios')
    ->join('datos_facturacion as FAC', 'CL.id_datos_facturacion = FAC.id')
    ->join('datos_generales as GEN', 'GEN.id = CL.id_datos_generales')
    ->where('R.id', $id);

    $consulta = $this->db->get();
    return $consulta->row();

			$consulta = $this->db->get();
      return $consulta->row();
		}
	/*----------------------------------------*/
	/*	Acciones
	/*----------------------------------------*/
		function iniciarRequisicion($id, $id_usuario){
			$this->db
			->set('id_usuario', $id_usuario)
			->set('status', 2)
			->where('id', $id)
			->update('requisicion');
		}
		function editarAspirante($datos, $id){
			$this->db
			->where('id', $id)
			->update('requisicion_aspirante', $datos);
		}
		function addApplicant($datos){
				$this->db->insert('requisicion_aspirante', $datos);
		}
		function editarRequisicion($datos, $id){
				$this->db
				->where('id', $id)
				->update('requisicion', $datos);
		}
		function guardarAccionRequisicion($datos){
				$this->db->insert('requisicion_historial', $datos);
		}
		function tieneAspiranteCV($id_aspirante){
				$this->db
				->select("A.cv")
				->from('requisicion_aspirante as A')
				->where('id', $id_aspirante);

				$consulta = $this->db->get();
				$resultado = $consulta->row();
				return $resultado;
		}
    
    function editBolsaTrabajo($datos, $id){
			$this->db
			->where('id', $id)
			->update('bolsa_trabajo', $datos);
		}
    function guardarHistorialBolsaTrabajo($datos){
      $this->db->insert('bolsa_trabajo_historial', $datos);
    }
    function addRequisicion($id_cliente, $cliente, $domicilios, $generales, $facturacion, $req) {
			// Iniciar transacción
		/*	echo "Aquí el id del cliente: " . $id_cliente . PHP_EOL;
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

			$this->db->trans_start();
	
			try {
					// Paso 1: Actualizar los datos del cliente
					$this->db->where('id', $id_cliente);
					$this->db->update('cliente', $cliente);
	
					// Paso 2: Obtener y actualizar los datos generales del cliente
				
				
					$id_datos_generales =	$this->generales_model->obtenerIdDatosGenerales($id_cliente);
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
						
					// Commit de la transacción
					$this->db->trans_commit();
			    // Se ejecutó correctamente
					return true; 
				} catch (Exception $e) {
						// Rollback de la transacción en caso de error
						$this->db->trans_rollback();
						return false; // Hubo un error
				}
	}

		
			function addRequsicionCompleta($req){
				$this->db->insert('requisicion', $req);
			}

			
    function updateOrder($data, $id){
      $this->db
			->where('id', $id)
			->update('requisicion', $data);
    }
		function updateOrderGenerales($data, $id){
      $this->db
			->where('id', $id)
			->update('datos_generales', $data);
    }

		function updateOrderFacturacion($data, $id){
      $this->db
			->where('id', $id)
			->update('datos_facturacion', $data);
    }

    function addBolsaTrabajo($data){
      $this->db->insert('bolsa_trabajo', $data);
    }
    function addJobPoolWithIdReturned($data){
      $this->db->insert('bolsa_trabajo', $data);
      $id = $this->db->insert_id();
      return  $id;
    }
    function updateApplicantByIdBolsaTrabajo($datos, $id){
			$this->db
			->where('id_bolsa_trabajo', $id)
			->update('requisicion_aspirante', $datos);
		}
    function addWarrantyApplicant($data){
      $this->db->insert('aspirante_garantia', $data);
    }
    /*----------------------------------------*/
    /*	#requisicion_usuario
    /*----------------------------------------*/
    function getUsersOrder($id_requisicion){
      $this->db
      ->select("RU.id, RU.id_requisicion, CONCAT(gen.nombre,' ',gen.paterno) as usuario")
      ->from('requisicion_usuario as RU')
      ->join('requisicion as R', 'RU.id_requisicion = R.id','left')
      ->join('usuarios_portal as U', 'U.id = RU.id_usuario','left')
			->join('datos_generales AS gen', 'U.id_datos_generales = gen.id','left')
      ->where_in('R.id', $id_requisicion)
      ->order_by('gen.nombre','ASC');
    
      $query = $this->db->get();
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return FALSE;
      }
    }
    function addUsersToOrder($data){
      $this->db->insert('requisicion_usuario', $data);
    }
    function deleteUserOrder($id){
      $this->db
      ->where('id', $id)
      ->delete('requisicion_usuario');
    }
	/*----------------------------------------*/
	/*	Consultas
	/*----------------------------------------*/
	function getDetailsOrderById($id){
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
		->where('R.id', $id);

		$consulta = $this->db->get();
		return $consulta->row();
	}
		function getHistorialAspirante($id, $campo){
			$this->db
			->select("H.*,R.nombre")
			->from('requisicion_historial as H')
      ->join('requisicion as R','R.id = H.id_requisicion')
			->where('H.'.$campo, $id)
			->order_by('H.id','DESC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
        return $query->result();
			}else{
        return FALSE;
			}
		}
		function getAspirantesRequisiciones($id_usuario, $condicion){
			$this->db
			->select("A.*, CONCAT(A.nombre,' ',A.paterno,' ',A.materno) as aspirante, CONCAT(GENCL.nombre,' ',GENCL.paterno) as usuario, CL.nombre as empresa,R.puesto, H.id as idHistorial,R.numero_vacantes,C.id_aspirante as idCandidato, C.status_bgc")
			->from('requisicion_aspirante as A')
			->join('requisicion as R','R.id = A.id_requisicion')

			->join('cliente as CL','CL.id = R.id_cliente')		
			->join('datos_generales as GENCL','GENCL.id = CL.id_datos_generales')
			->join('requisicion_historial as H','H.id_requisicion = R.id','left')
			->join('usuarios_portal as USER','USER.id = A.id_usuario')
			->join('candidato as C','C.id_aspirante = A.id','left')
			->where('A.eliminado', 0)
			->where('R.eliminado', 0)
			->where('R.status', 2)
			//->where('C.id_aspirante', NULL)
			->where($condicion, $id_usuario)
			->group_by('A.id')
			->order_by('A.id','DESC')
			->order_by('A.id_requisicion','DESC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return FALSE;
			}
		}
		function getAspirantesRequisicionesTotal($id_usuario, $condicion){
			$this->db
			->select("A.id")
			->from('requisicion_aspirante as A')
			->join('requisicion as R','R.id = A.id_requisicion')
			->join('usuarios_portal as USPOR','USPOR.id = A.id_usuario')
			->where('A.eliminado', 0)
			->where('R.status', 2)
			->where($condicion, $id_usuario);

			$query = $this->db->get();
			return $query->num_rows();
		}
		function getAspirantesPorRequisicion($id_usuario, $condicion, $id){
			$this->db
			->select("A.*, CONCAT(A.nombre,' ',A.paterno,' ',A.materno) as aspirante, CONCAT(DATUP.nombre,' ',DATUP.paterno) as usuario, R.nombre as empresa,R.puesto, H.id as idHistorial,R.numero_vacantes")
			->from('requisicion_aspirante as A')
			->join('requisicion as R','R.id = A.id_requisicion')
			->join('requisicion_historial as H','H.id_requisicion = R.id','left')
			->join('usuarios_portal as USPOR','USPOR.id = A.id_usuario')
			->join('datos_generales as DATUP', 'DATUP.id = USPOR.id_datos_generales')
			->where('A.id_requisicion', $id)
			->where('R.status', 2)
			->where($condicion, $id_usuario)
			->group_by('A.id')
			->order_by('A.id','DESC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
        return $query->result();
			}else{
        return FALSE;
			}
		}
		function getAspirantesPorRequisicionTotal($id_usuario, $condicion, $id){
				$this->db
				->select("A.id")
				->from('requisicion_aspirante as A')
				->join('requisicion as R','R.id = A.id_requisicion')
				->join('usuario as USER','USER.id = A.id_usuario')
				->where('R.status', 2)
				->where('A.id_requisicion', $id)
				->where($condicion, $id_usuario);

				$query = $this->db->get();
				return $query->num_rows();
		}
		function getRequisicionesFinalizadas($id_usuario, $condicion){
			$this->db
			->select("r.id, CL.nombre, r.puesto, r.numero_vacantes, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario")
			->from('requisicion as R')
			->join('usuarios_portal as U','U.id = r.id_usuario','left')
			->join('datos_generales as GENUS','GENUS.id = U.id_datos_generales')
			->join('cliente as CL','CL.id = R.id_cliente')
			->join('datos_generales as GENCL','GENCL.id = CL.id_datos_generales')
			->where('r.eliminado', 0)
			->where_in('r.status', [0,3])
			->where($condicion, $id_usuario)
			->order_by('r.status','ASC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
					return $query->result();
			}else{
					return FALSE;
			}
		}
		function getAspirantesRequisicionesFinalizadas($id_usuario, $condicion){
			$this->db
			->select("A.*, CONCAT(A.nombre,' ',A.paterno,' ',A.materno) as aspirante, CONCAT(GENCL.nombre,' ',GENCL.paterno) as usuario, CL.nombre as empresa,R.puesto, H.id as idHistorial,R.numero_vacantes,C.id_aspirante as idCandidato, C.status_bgc")
			->from('requisicion_aspirante as A')
			->join('requisicion as R','R.id = A.id_requisicion')

			->join('cliente as CL','CL.id = R.id_cliente')		
			->join('datos_generales as GENCL','GENCL.id = CL.id_datos_generales')
			->join('requisicion_historial as H','H.id_requisicion = R.id','left')
			->join('usuarios_portal as USER','USER.id = A.id_usuario')
			->join('candidato as C','C.id_aspirante = A.id','left')
			->where('A.eliminado', 0)
			->where_in('R.status', [0,3])
			->where($condicion, $id_usuario)
			->group_by('A.id')
			->order_by('A.id','DESC')
			->order_by('A.id_requisicion','DESC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
					return $query->result();
			}else{
					return FALSE;
			}
		}
		function getAspirantesRequisicionesFinalizadasTotal($id_usuario, $condicion){
				$this->db
				->select("A.id")
				->from('requisicion_aspirante as A')
				->join('requisicion as R','R.id = A.id_requisicion')
				->join('usuarios_portal as USPOR','USPOR.id = A.id_usuario')
				->where('A.eliminado', 0)
				->where_in('R.status', [0,3])
				->where($condicion, $id_usuario);

				$query = $this->db->get();
				return $query->num_rows();
		}
    function getAspirantesPorRequisicionesFinalizadas($id_usuario, $condicion, $id){
			$this->db
			->select("A.*, CONCAT(A.nombre,' ',A.paterno,' ',A.materno) as aspirante, CONCAT(GENUS.nombre,' ',GENUS.paterno) as usuario, 			->join('cliente as CL', 'CL.id = R.id_cliente')
			.nombre as empresa,R.puesto, H.id as idHistorial, R.status as statusReq, R.comentario_final")
			->from('requisicion_aspirante as A')
			->join('requisicion as R','R.id = A.id_requisicion')
			->join('cliente as CL', 'CL.id = R.id_cliente')
			->join('requisicion_historial as H','H.id_requisicion = R.id','left')
			->join('usuarios_portal as USER','USER.id = A.id_usuario')
			->join('datos_generales as GENUS', 'GENUS.id = USER.id_datos_generales')
			->where('A.id_requisicion', $id)
			->where_in('R.status', [0,3])
			->where($condicion, $id_usuario)
			->group_by('A.id')
			->order_by('A.id','DESC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
        return $query->result();
			}else{
        return FALSE;
			}
		}
		function getAspirantesPorRequisicionesFinalizadasTotal($id_usuario, $condicion, $id){
				$this->db
				->select("A.id")
				->from('requisicion_aspirante as A')
				->join('requisicion as R','R.id = A.id_requisicion')
				->join('usuario as USER','USER.id = A.id_usuario')
				->where_in('R.status', [0,3])
				->where('A.id_requisicion', $id)
				->where($condicion, $id_usuario);

				$query = $this->db->get();
				return $query->num_rows();
		}
    function getBolsaTrabajoById($id){
			$this->db
			->select("*, CONCAT(nombre,' ',paterno,' ',materno) as nombreCompleto")
			->from('bolsa_trabajo')
			->where('id', $id);

			$consulta = $this->db->get();
      return $consulta->row();
		}
    function getEmpleosByIdBolsaTrabajo($id){
			$this->db
			->select("E.*, CONCAT(B.nombre,' ',B.paterno,' ',B.materno) as nombreCompleto")
			->from('bolsa_trabajo_historial_empleos as E')
			->join('bolsa_trabajo as B','B.id = E.id_bolsa_trabajo')
			->where('E.id_bolsa_trabajo', $id);

			$query = $this->db->get();
			if($query->num_rows() > 0){
        return $query->result();
			}else{
        return FALSE;
			}
		}
    function getAspiranteById($id){
			$this->db
			->select("*")
			->from('requisicion_aspirante')
			->where('id', $id);

			$consulta = $this->db->get();
      return $consulta->row();
		}
    function getVacantesCubiertasTotal($id_requisicion, $acciones){
      $this->db
			->select("R.id")
			->from('requisicion_aspirante as R')
      ->where('R.id_requisicion', $id_requisicion)
      ->where('R.sueldo_acordado !=', NULL)
      ->where('R.fecha_ingreso !=', NULL)
			->where_in('R.status_final', $acciones);

      $query = $this->db->get();
      return $query->num_rows();
    }
    function getAspirantesByBolsaTrabajo($id_requisicion){
      $this->db
			->select("B.*")
			->from('requisicion_aspirante as R')
			->join('bolsa_trabajo as B','B.id = R.id_bolsa_trabajo')
      ->where('R.id_requisicion', $id_requisicion);

      $query = $this->db->get();
			if($query->num_rows() > 0){
        return $query->result();
			}else{
        return FALSE;
			}
    }
    function getAspiranteByBolsaTrabajo($id_bolsa){
      $this->db
			->select("R.*")
			->from('requisicion_aspirante as R')
			->join('bolsa_trabajo as B','B.id = R.id_bolsa_trabajo')
      ->where('R.id_bolsa_trabajo', $id_bolsa);

      $consulta = $this->db->get();
      return $consulta->row();
    }
    function getCandidatosByRequisicion($id_requisicion){
      $this->db
			->select("C.id,C.id_aspirante")
			->from('requisicion_aspirante as R')
			->join('candidato as C','C.id_aspirante = R.id','left')
      ->where('R.id_requisicion', $id_requisicion);

      $query = $this->db->get();
			if($query->num_rows() > 0){
        return $query->result();
			}else{
        return FALSE;
			}
    }
    function getAspiranteByCandidato($id_candidato){
      $this->db
			->select("C.id,C.id_aspirante,R.id_requisicion,R.id_bolsa_trabajo")
			->from('candidato as C')
			->join('requisicion_aspirante as R','C.id_aspirante = R.id')
      ->where('C.id', $id_candidato);

      $consulta = $this->db->get();
      return $consulta->row();
    }
    function getHistorialBolsaTrabajo($id){
			$this->db
			->select("H.*, CONCAT(U.nombre,' ',U.paterno) as usuario ")
			->from('bolsa_trabajo_historial as H')
      ->join('usuario as U','U.id = H.id_usuario')
			->where('H.id_bolsa_trabajo', $id)
			->order_by('H.id','DESC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
        return $query->result();
			}else{
        return FALSE;
			}
		}
    function getBolsaTrabajoByName($nombre, $paterno, $materno){
      $this->db
			->select("id")
			->from('bolsa_trabajo')
			->where('nombre', $nombre)
			->where('paterno', $paterno)
			->where('materno', $materno);

			$query = $this->db->get();
      return $query->row();
    }
    function getBolsaTrabajoByPhone($telefono){
      $this->db
			->select("id")
			->from('bolsa_trabajo')
			->where('telefono', $telefono);

			$query = $this->db->get();
      return $query->row();
    }
    function getWarrantyApplicant($id){
			$this->db
			->select("A.*, CONCAT(U.nombre,' ',U.paterno) as usuario ")
			->from('aspirante_garantia as A')
      ->join('usuario as U','U.id = A.id_usuario')
			->where('A.id_aspirante', $id)
			->order_by('A.id','DESC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
        return $query->result();
			}else{
        return FALSE;
			}
		}
    function getAllJobPoolByArea(){
      $this->db
			->select("*")
			->from('bolsa_trabajo')
      ->group_by('area_interes');

			$query = $this->db->get();
			if($query->num_rows() > 0){
        return $query->result();
			}else{
        return FALSE;
			}
    }
    function matchCliente($term){
        $this->db
        ->select('id, nombre')
        ->from('cliente')
        ->where("status", 1)
        ->where("eliminado", 0)
        ->like("nombre", $term, 'after')
        ->order_by('nombre', 'ASC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            foreach ($query->result_array() as $row){
              $new_row['value'] = $row['id'];
              $new_row['label'] = $row['nombre'];
              $row_set[] = $new_row; //build an array
            }
            return $row_set; //format the array into json data
        }
    }
}