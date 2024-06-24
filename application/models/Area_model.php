<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_model extends CI_Model{

  function getArea($nombre){
    $url = API_URL . 'area/' . urlencode($nombre);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            $error = curl_error($ch);
            return "Error en la solicitud cURL: " . $error;
        }

        curl_close($ch);

        if ($http_status == 200) {
            $datosArea = json_decode($response, true);
            return $datosArea;
        } else {
            return "Error en la solicitud HTTP: Código " . $http_status;
        }
  }
  function getAreaById($id){
    $this->db 
    ->select("A.*, CONCAT(U.nombre,' ',U.paterno,' ',U.materno) as responsable")
    ->from('area as A')
    ->join('usuario as U','U.id = A.usuario_responsable')
    ->where('A.id', $id);

    $query = $this->db->get();
    return $query->row();
  }
}