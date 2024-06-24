<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medico_model extends CI_Model{

    function guardarMedico($analisis){
        $this->db->insert("medico", $analisis);
    }
    function getAnalisis($id_candidato){
        $this->db
        ->select('m.*, c.fecha_nacimiento, c.genero')
        ->from('medico as m')
        ->join("candidato as c","m.id_candidato = c.id")
        ->where('m.id_candidato', $id_candidato);

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function editarMedico($analisis,$id_analisis){
        $this->db
        ->where('id', $id_analisis)
        ->update('medico', $analisis);
    }
    function getAnalisisTotal(){
        $this->db
        ->select("m.*")
        ->from("medico as m")
        ->join("candidato as c","m.id_candidato = c.id")
        ->join('candidato_pruebas as pr','pr.id_candidato = c.id')
        ->where('pr.medico !=', 0)
        ->where("c.eliminado", 0);

        $query = $this->db->get();
        return $query->num_rows();
    }
    function getAnalisisMedico(){
        $this->db
        ->select("m.*, c.id,c.nombre, c.paterno, c.materno, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato, c.fecha_alta, c.id_cliente, c.id_subcliente, cl.nombre as cliente, sub.nombre as subcliente, c.fecha_nacimiento, c.id_proyecto, pro.nombre as proyecto, m.id as idMedico, m.imagen_historia_clinica as imagen, c.edad, c.genero, c.estado_civil, c.id_grado_estudio")
        ->from('candidato as c')
        ->join('candidato_pruebas as pr','pr.id_candidato = c.id')
        ->join('cliente as cl','cl.id = c.id_cliente','left')
        ->join('subcliente as sub','sub.id = c.id_subcliente',"left")
        ->join('proyecto as pro','pro.id = c.id_proyecto',"left")
        ->join('medico as m','m.id_candidato = c.id',"left")
       /* ->join('usuario as u','u.id = m.id_usuario')
        ->join('tipo_sueldo as sueldo','sueldo.id = r.id_tipo_sueldo',"left")
        ->join('subtipo_sueldo as subtipo','subtipo.id = r.sueldo_variable',"left")
        ->join('tipo_prestaciones as prestaciones','prestaciones.id = r.id_tipo_prestaciones',"left")*/
        ->where('c.eliminado', 0)
        ->where('pr.medico', 1)
        ->where('c.id_cliente !=', 2)
        ->order_by('m.id','DESC');

        $query = $this->db->get();
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return FALSE;
        }
    }
    function getDatosMedico($id_medico){
      
        // URL de la API de Laravel
        $url = API_URL.'medico/' . $id_medico;
         
    

        // Inicializar cURL
        $ch = curl_init($url);

        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        // Ejecutar la solicitud cURL
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Verificar errores
        if ($response === false) {
            $error = curl_error($ch);
            echo "Error en la solicitud cURL: " . $error;
        }

        // Cerrar cURL
        curl_close($ch);

        // Procesar la respuesta
        if ($http_status == 200) {
            // La solicitud fue exitosa, procesa la respuesta
            $datosMedico = json_decode($response, true);
            // Hacer algo con $datosMedico
        
          return $datosMedico;
        
            
        } else {
            // Manejar otros códigos de estado HTTP
            echo "Error en la solicitud HTTP: Código " . $http_status;
            return[];

        }
       
    }
    function checkExamenMedico($id_candidato){
        $this->db
        ->select("m.id")
        ->from("medico as m")
        ->where("m.id_candidato", $id_candidato);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }

    function checkMedico($id_candidato){
        $this->db
        ->select("m.id")
        ->from("medico as m")
        ->where("m.id_candidato", $id_candidato);

        $consulta = $this->db->get();
        $resultado = $consulta->row();
        return $resultado;
    }
    
}