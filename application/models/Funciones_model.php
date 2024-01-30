<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funciones_model extends CI_Model{

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
  function getMunicipios($id_estado){
    $this->db
    ->select('id, nombre')
    ->from('municipio')
    ->where('id_estado', $id_estado)
    ->order_by('nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getClientesActivos(){
    $this->db
    ->select("cl.*")
    ->from("cliente as cl")
    ->where("cl.status", 1)
    ->where("cl.eliminado", 0)
    ->order_by("cl.nombre", 'ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getClientesInglesActivos(){
    $this->db
    ->select("cl.*")
    ->from("cliente as cl")
    ->where("cl.ingles", 1)
    ->where("cl.status", 1)
    ->where("cl.eliminado", 0)
    ->order_by("cl.nombre", 'ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getTiposIdentificaciones(){
    $this->db
    ->select('*')
    ->from('tipo_identificacion')
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
  function getClaveCliente($id_cliente){
    $this->db
    ->select('cl.clave')
    ->from('cliente as cl')
    ->where('cl.id', $id_cliente);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getClaveProyecto($id_cliente, $id_proyecto){
    $this->db
    ->select('cl.clave as claveCliente, pro.nombre as claveProyecto')
    ->from('cliente as cl')
    ->join('proyecto as pro','pro.id_cliente = cl.id')
    ->where('cl.id', $id_cliente)
    ->where('pro.id', $id_proyecto);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getClaveSubcliente($id_cliente, $id_subcliente){
    $this->db
    ->select('cl.clave as claveCliente, sub.clave as claveSubcliente')
    ->from('cliente as cl')
    ->join('subcliente as sub','sub.id_cliente = cl.id')
    ->where('cl.id', $id_cliente)
    ->where('sub.id', $id_subcliente);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getClaveSubclienteProyecto($id_cliente, $id_proyecto, $id_subcliente){
    $this->db
    ->select('cl.clave as claveCliente, pro.nombre as claveProyecto, sub.clave as claveSubcliente')
    ->from('cliente as cl')
    ->join('proyecto as pro','pro.id_cliente = cl.id')
    ->join('subcliente as sub','sub.id = pro.id_subcliente','left')
    ->where('cl.id', $id_cliente)
    ->where('pro.id', $id_proyecto)
    ->where('sub.id', $id_subcliente);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getTiposDocumentos(){
    $this->db
    ->select('*')
    ->from('tipo_documentacion')
    ->where('status',1)
    ->where('eliminado', 0)
    ->order_by('nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
        return $query->result();
    }else{
        return FALSE;
    }
  }
  function getEstadosCiviles(){
    $this->db
    ->select('*')
    ->from('estado_civil')
    ->where('id !=', 7)
    ->order_by('nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getBateriasPsicometricas(){
		$this->db
	    ->select('*')
	    ->from('psicometrico_bateria')
	    ->order_by('nombre','ASC');

	    $query = $this->db->get();
	    if($query->num_rows() > 0){
	    	return $query->result();
	    }else{
	      	return FALSE;
	    }
	}
  function getPaquetesAntidoping(){
    $this->db
    ->select('*')
    ->from('antidoping_paquete')
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
  function getPuestos(){
    $this->db
    ->select('*')
    ->from('puesto')
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
  function getGradosEstudio(){
    $this->db
    ->select('*')
    ->from('grado_estudio')
    ->order_by('nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
        return $query->result();
    }else{
        return FALSE;
    }
  }
  function getGradoEstudioById($id){
    $this->db
    ->select('*')
    ->from('grado_estudio')
    ->where('id', $id);

    $query = $this->db->get();
    return $query->row();
  }
  function getTiposEstudios(){
    $this->db
    ->select('*')
    ->from('tipo_studies')
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
  function getParentescos(){
    $this->db
    ->select('*')
    ->from('tipo_parentesco')
    ->where('status',1)
    ->where('eliminado', 0)
    ->order_by('nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getEscolaridades(){
    $this->db
    ->select('*')
    ->from('tipo_escolaridad')
    ->order_by('nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
        return $query->result();
    }else{
        return FALSE;
    }
  }
  function getNivelesZona(){
    $this->db
    ->select('*')
    ->from('tipo_nivel_zona');

    $query = $this->db->get();
    if($query->num_rows() > 0){
        return $query->result();
    }else{
        return FALSE;
    }
  }
  function getTiposVivienda(){
    $this->db
    ->select('*')
    ->from('tipo_vivienda');

    $query = $this->db->get();
    if($query->num_rows() > 0){
        return $query->result();
    }else{
        return FALSE;
    }
  }
  function getTiposCondiciones(){
    $this->db
    ->select('*')
    ->from('tipo_condiciones');

    $query = $this->db->get();
    if($query->num_rows() > 0){
        return $query->result();
    }else{
        return FALSE;
    }
  }
  function getExamenDoping($id_cliente){
    $this->db
    ->select('paq.*')
    ->from('cliente_doping as cd')
    ->join('antidoping_paquete as paq','paq.id = cd.id_antidoping_paquete')
    ->where('cd.id_cliente', $id_cliente);

    $query = $this->db->get();
    if($query->num_rows() > 0){
        return $query->result();
    }else{
        return FALSE;
    }
  }
  function getConfiguraciones(){
    $this->db
    ->select("*")
    ->from('configuracion');

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getUsuariosParaAsignacion(){
    $this->db
    ->select("id, CONCAT(nombre,' ',paterno) as usuario")
    ->from('usuario')
    ->where_in('id_rol', [2,9])
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
  function getTipoAnalistas($tipo_analista){
    $tipos = [$tipo_analista, 3];
    $this->db
    ->select("id, CONCAT(nombre,' ',paterno) as usuario")
    ->from('usuario')
    ->where_in('tipo_analista',$tipos)
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
  function getTipoAnalista($id_usuario){
    $this->db
    ->select("id, CONCAT(nombre,' ',paterno) as usuario, tipo_analista")
    ->from('usuario')
    ->where('id', $id_usuario);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getCiviles(){
    $this->db
    ->select('*')
    ->from('estado_civil');

    $query = $this->db->get();
    if($query->num_rows() > 0){
        return $query->result();
    }else{
        return FALSE;
    }
  }
  function getPaises(){
    $this->db
    ->select('*')
    ->from('paises')
    ->order_by('id','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getPaisesEstudio(){
    $this->db
    ->select('*')
    ->from('pais_estudio')
    ->where('status',1)
    ->where('eliminado', 0);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getDatosCandidato($id_candidato){
    $this->db
    ->select('cl.nombre as cliente')
    ->from('candidato as c')
    ->join('cliente as cl','cl.id = c.id_cliente')
    //->join('subcliente as sub','sub.id = c.id_subcliente','left')
    //->join('doping as dop','dop.id_candidato = c.id','left')
    //->join('puesto as p','p.id = c.id_puesto','left')
    ->where('c.id',$id_candidato);
    //->where('c.status',2)
    //->where('c.status_bgc !=', 0);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getFechasFestivas(){
    $this->db
    ->select('*')
    ->from('fechas_festivas')
    ->order_by('fecha','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }
    else{
      return FALSE;
    }
  }
  function getMediosContacto(){
    $this->db
    ->select('*')
    ->from('cat_medio_contacto')
    ->where('status',1)
    ->where('eliminado', 0)
    ->order_by('nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getAccionesRequisicion(){
    $this->db
    ->select('*')
    ->from('cat_accion_requisicion')
    ->where('status',1)
    ->where('eliminado', 0)
    ->order_by('descripcion','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getGruposSanguineos(){
    $this->db
    ->select('*')
    ->from('cat_grupo_sanguineo')
    ->where('status',1)
    ->where('eliminado', 0)
    ->order_by('nombre','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getMediosContactoByName($nombre){
    $this->db
    ->select('*')
    ->from('cat_medio_contacto')
    ->where('nombre', $nombre);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function getMediosTransporte(){
    $this->db 
    ->select('*')
    ->from('cat_medio_transporte')
    ->where('status', 1)
    ->where('eliminado', 0);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getTiposIdentificacion(){
    $this->db 
    ->select('*')
    ->from('cat_tipo_identificacion')
    ->where('status', 1)
    ->where('eliminado', 0);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getFrecuencias(){
    $this->db 
    ->select('*')
    ->from('cat_frecuencia')
    ->where('status', 1)
    ->where('eliminado', 0);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  } 
  function getTiposBloqueo(){
    $this->db 
    ->select('*')
    ->from('cat_tipo_bloqueo')
    ->where('status', 1);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getTiposDesbloqueo(){
    $this->db 
    ->select('*')
    ->from('cat_tipo_desbloqueo')
    ->where('status', 1);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getCondicionesVivienda(){
    $this->db
    ->select('*')
    ->from('tipo_condiciones')
    ->where('status', 1)
    ->where('eliminado', 0);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
}