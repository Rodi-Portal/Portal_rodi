<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documentacion_model extends CI_Model{

    function getByCandidate($id_candidato){
      $this->db
      ->select("*")
      ->from("verificacion_documento")
      ->where("id_candidato", $id_candidato);

      $query = $this->db->get();
      return $query->row();
    }
    function countByIdCandidato($id){
      $this->db
      ->select('id')
      ->from('verificacion_documento')
      ->where('id_candidato', $id);
      
      $query = $this->db->get();
      return $query->num_rows();
    }
    function add($data){
      $this->db->insert('verificacion_documento', $data);
    }
    function edit($data, $id_candidato){
      $this->db
      ->where('id_candidato', $id_candidato)
      ->update('verificacion_documento', $data);
    }
    function getArchivosCandidato($id){
      $this->db
      ->select('CD.*, T.nombre as tipo')
      ->from('candidato_documento as CD')
      ->join('tipo_documentacion as T','T.id = CD.id_tipo_documento')
      ->where('CD.id_candidato',$id);

      $query = $this->db->get();
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return FALSE;
      }
    }
    function eliminarArchivo($id_candidato, $tablaBD){
      $this->db
      ->where('id_candidato', $id_candidato)
      ->delete($tablaBD);
    }
    function subirArchivo($doc, $tablaBD){
      $this->db->insert($tablaBD, $doc);
    }
    function getArchivo($id_candidato, $tablaBD){
      $this->db
      ->select('*')
      ->from($tablaBD)
      ->where('id_candidato',$id_candidato);

      $query = $this->db->get();
      return $query->row();
    }
    function getDocumentoRequerido($id_tipo_documento){
      $this->db
      ->select('*')
      ->from('cat_documento_requerimiento')
      ->where('id_tipo_documento',$id_tipo_documento);

      $query = $this->db->get();
      return $query->row();
    }
    function addDocumentoRequerido($data){
      $this->db->insert('candidato_documento_requerido', $data);
    }
    function getDocumentosRequeridosByCandidato($id_candidato){
      $this->db
      ->select('R.*, T.nombre as tipo')
      ->from('candidato_documento_requerido as R')
      ->join('tipo_documentacion as T','T.id = R.id_tipo_documento')
      ->where('R.id_candidato',$id_candidato);

      $query = $this->db->get();
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return FALSE;
      }
    }
    function getFilesByType($id_tipo, $id_candidato, $tablaBD){
      $this->db
      ->select('*')
      ->from($tablaBD)
      ->where('id_tipo_documento',$id_tipo)
      ->where('id_candidato',$id_candidato);

      $query = $this->db->get();
      return $query->row();
    }
    function deleteFileByType($id_tipo, $tablaBD, $id_candidato){
      $this->db
      ->where('id_tipo_documento', $id_tipo)
      ->where('id_candidato', $id_candidato)
      ->delete($tablaBD);
    }
    function get_documentos_restringidos_cliente($idCliente, $idDocumento){
      $this->db
      ->select('*')
      ->from('cliente_restriccion_documentacion')
      ->where('id_cliente',$idCliente)
      ->where('id_documento',$idDocumento);

      $query = $this->db->get();
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return FALSE;
      }
    }
}