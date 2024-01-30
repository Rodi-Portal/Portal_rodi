<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Candidato_laboral_model extends CI_Model{

  function __construct(){
		parent::__construct();
    
	}
  /*----------------------------------------*/
  /*  #NoMencionados 
  /*----------------------------------------*/
  function getNoMencionadosById($id){
    $this->db 
    ->select('*')
    ->from('verificacion_no_mencionados')
    ->where('id_candidato', $id);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function checkNoMencionados($id){
    $this->db
    ->select('id')
    ->from('verificacion_no_mencionados')
    ->where('id_candidato', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function addNoMencionados($data){
    $this->db->insert('verificacion_no_mencionados', $data);
  }
  function editNoMencionados($data, $id_candidato){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->update('verificacion_no_mencionados', $data);
  }
  /*----------------------------------------*/
  /*  #HistorialLaboral 
  /*----------------------------------------*/
  function getHistorialLaboralById($id){
    $this->db 
    ->select('*')
    ->from('candidato_ref_laboral')
    ->where('id_candidato', $id);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getVerificacionLaboralById($id){
    $this->db 
    ->select('*')
    ->from('verificacion_ref_laboral')
    ->where('id_candidato', $id)
    ->order_by('numero_referencia','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getVerificacionLaboralByNumber($cont, $id_candidato){
    $this->db
    ->select('*')
    ->from('verificacion_ref_laboral')
    ->where('id_candidato', $id_candidato)
    ->where('numero_referencia', $cont);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function checkHistorialLaboral($id){
    $this->db
    ->select('id')
    ->from('candidato_ref_laboral')
    ->where('id', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function countLaboralesByIdCandidato($id_candidato){
    $this->db
    ->select('id')
    ->from('candidato_ref_laboral')
    ->where('id_candidato', $id_candidato);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function addLaboral($data){
    $this->db->insert('candidato_ref_laboral', $data);
    $id = $this->db->insert_id();
    return  $id;
  }
  function editLaboral($data, $id_candidato, $id_laboral){
    $this->db
    ->where('id', $id_laboral)
    ->where('id_candidato', $id_candidato)
    ->update('candidato_ref_laboral', $data);
  }
  function countVerificacionesByIdCandidato($id_candidato){
    $this->db
    ->select('id')
    ->from('verificacion_ref_laboral')
    ->where('id_candidato', $id_candidato);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function addVerificacion($data){
    $this->db->insert('verificacion_ref_laboral', $data);
    $id = $this->db->insert_id();
    return  $id;
  }
  function editVerificacion($data, $id_candidato, $id_verificacion){
    $this->db
    ->where('id', $id_verificacion)
    ->where('id_candidato', $id_candidato)
    ->update('verificacion_ref_laboral', $data);
  }
  function editVerificacionByNumero($id_candidato, $numeroActual, $nuevoNumero){
    $this->db
    ->set('numero_referencia', $nuevoNumero)
    ->where('numero_referencia', $numeroActual)
    ->where('id_candidato', $id_candidato)
    ->update('verificacion_ref_laboral');
  }
  function deleteLaboral($id, $id_candidato){
    $this->db
    ->where('id', $id)
    ->where('id_candidato', $id_candidato)
    ->delete('candidato_ref_laboral');
  }
  function deleteVerificacion($id, $id_candidato){
    $this->db
    ->where('id', $id)
    ->where('id_candidato', $id_candidato)
    ->delete('verificacion_ref_laboral');
  }
  function deleteVerificacionLaboralByNumero($numero, $id_candidato){
    $this->db
    ->where('numero_referencia', $numero)
    ->where('id_candidato', $id_candidato)
    ->delete('verificacion_ref_laboral');
  }
  function addHistorialLaboral($data){
    $this->db->insert('candidato_ref_laboral', $data);
  }
  function editHistorialLaboral($data, $id){
    $this->db
    ->where('id', $id)
    ->update('candidato_ref_laboral', $data);
  }
  function checkVerificacionLaboral($id){
    $this->db
    ->select('id')
    ->from('verificacion_ref_laboral')
    ->where('id', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function addVerificacionLaboral($data){
    $this->db->insert('verificacion_ref_laboral', $data);
  }
  function editVerificacionLaboral($data, $id){
    $this->db
    ->where('id', $id)
    ->update('verificacion_ref_laboral', $data);
  }
  function getComentarios($id_candidato){
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
  function getHistorialPuestos($id_candidato){
    $this->db
    ->select('puesto1,puesto2')
    ->from('candidato_ref_laboral')
    ->where('id_candidato', $id_candidato);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getHistorialIncidencias($id_candidato){
    $this->db
    ->select('R.empresa,CON.nombre as contacto,CON.cumplimiento,CON.conflicto')
    ->from('candidato_ref_laboral as R')
    ->from('contacto_ref_laboral as CON','CON.id_ref_laboral = R.id')
    ->where('R.id_candidato', $id_candidato)
    ->group_by('R.id');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getContactoById($id){
    $this->db 
    ->select('*')
    ->from('contacto_ref_laboral')
    ->where('id_candidato', $id);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getObservacionesContactoById($id){
    $this->db 
    ->select('CON.observacion, R.empresa')
    ->from('contacto_ref_laboral as CON')
    ->join('candidato_ref_laboral as R','R.id = CON.id_ref_laboral')
    ->where('CON.id_candidato', $id);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getContactoLaboralById($id){
    $this->db 
    ->select('*')
    ->from('contacto_ref_laboral')
    ->where('id_candidato', $id)
    ->order_by('numero_referencia','ASC');

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  function getContactoLaboralByNumber($cont, $id_candidato){
    $this->db
    ->select('*')
    ->from('contacto_ref_laboral')
    ->where('id_candidato', $id_candidato)
    ->where('numero_referencia', $cont);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function checkContactoLaboral($id){
    $this->db
    ->select('id')
    ->from('contacto_ref_laboral')
    ->where('id', $id);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function countContactosByIdCandidato($id_candidato){
    $this->db
    ->select('id')
    ->from('contacto_ref_laboral')
    ->where('id_candidato', $id_candidato);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function addContactoLaboral($data){
    $this->db->insert('contacto_ref_laboral', $data);
  }
  function editContactoLaboral($data, $id){
    $this->db
    ->where('id', $id)
    ->update('contacto_ref_laboral', $data);
  }
  function addContacto($data){
    $this->db->insert('contacto_ref_laboral', $data);
    $id = $this->db->insert_id();
    return  $id;
  }
  function editContacto($data, $id_candidato, $id_verificacion){
    $this->db
    ->where('id', $id_verificacion)
    ->where('id_candidato', $id_candidato)
    ->update('contacto_ref_laboral', $data);
  }
  function deleteContacto($id, $id_candidato){
    $this->db
    ->where('id', $id)
    ->where('id_candidato', $id_candidato)
    ->delete('contacto_ref_laboral');
  }
  function deleteContactoLaboralByNumero($numero, $id_candidato){
    $this->db
    ->where('numero_referencia', $numero)
    ->where('id_candidato', $id_candidato)
    ->delete('contacto_ref_laboral');
  }
  function editContactoByNumero($id_candidato, $numeroActual, $nuevoNumero){
    $this->db
    ->set('numero_referencia', $nuevoNumero)
    ->where('numero_referencia', $numeroActual)
    ->where('id_candidato', $id_candidato)
    ->update('contacto_ref_laboral');
  }
  /*----------------------------------------*/
  /*  #Antecedenteslaborales 
  /*----------------------------------------*/
  function getAntecedentesLaboralesById($id_candidato){
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
  function countAntecedentesLaborales($id_candidato){
    $this->db
    ->select('id')
    ->from('candidato_antecedente_laboral')
    ->where('id_candidato', $id_candidato);

    $query = $this->db->get();
    return $query->num_rows();
  }
  function countAntecedentesLaboralesByIdCandidato($id_candidato){
    $this->db
    ->select('id')
    ->from('candidato_antecedente_laboral')
    ->where('id_candidato', $id_candidato);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function addAntecedenteLaboral($data){
    $this->db->insert('candidato_antecedente_laboral', $data);
    $id = $this->db->insert_id();
    return  $id;
  }
  function editAntecedenteLaboral($data, $id_candidato, $id_laboral){
    $this->db
    ->where('id', $id_laboral)
    ->where('id_candidato', $id_candidato)
    ->update('candidato_antecedente_laboral', $data);
  }
  function deleteAntecedenteLaboral($id, $id_candidato){
    $this->db
    ->where('id', $id)
    ->where('id_candidato', $id_candidato)
    ->delete('candidato_antecedente_laboral');
  }
  /*----------------------------------------*/
  /*  #MismoTrabajo 
  /*----------------------------------------*/
  function getContactosMismoTrabajo($id_candidato){
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
  /*----------------------------------------*/
  /*  #Verificacion Documento Empleos 
  /*----------------------------------------*/
  function getVerificacion($id_candidato){
    $this->db
    ->select('*')
    ->from('status_ref_laboral')
    ->where('id_candidato',$id_candidato);

    $consulta = $this->db->get();
    $resultado = $consulta->row();
    return $resultado;
  }
  function getDetalleVerificacion($id_candidato){
    $this->db
    ->select('D.*')
    ->from('status_ref_laboral_detalle as D')
    ->join('status_ref_laboral as L','L.id = D.id_status_ref_laboral')
    ->where('L.id_candidato',$id_candidato);

    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return FALSE;
    }
  }
  /*----------------------------------------*/
  /*  #Verificacion Documento Empleos 
  /*----------------------------------------*/
  function getExtrasById($id){
    $this->db 
    ->select('*')
    ->from('extra_laboral')
    ->where('id_candidato', $id);

    $consulta = $this->db->get();
    return $consulta->row();
  }
  function countByIdCandidato($id_candidato){
    $this->db
    ->select('id')
    ->from('extra_laboral')
    ->where('id_candidato', $id_candidato);
    
    $query = $this->db->get();
    return $query->num_rows();
  }
  function add($data){
    $this->db->insert('extra_laboral', $data);
  }
  function edit($data, $id_candidato){
    $this->db
    ->where('id_candidato', $id_candidato)
    ->update('extra_laboral', $data);
  }
}