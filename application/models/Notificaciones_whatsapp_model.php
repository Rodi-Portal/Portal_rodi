<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notificaciones_whatsapp_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Llama a la API externa con un payload JSON.
     *
     * @param string $phone Número de teléfono
     * @param string $templateName Nombre de la plantilla
     * @return array Respuesta de la API
     */
    public function alertaMovimientoApirante($phone, $templateName, $datos = null)
    {

        // Define la URL base de la API
        $api_url = API_URL;

        // Asegúrate de que $datos sea un array y contenga la clave 'ruta'
        if (is_array($datos) && isset($datos['ruta'])) {
            // Extrae la ruta de la variable $datos
            $ruta = $datos['ruta'];
            // Construye la URL completa añadiendo la ruta a la URL base
            $api_url .= $ruta;
        } else {
            // Si no se proporciona la ruta, utiliza una URL por defecto
            return array(
                'codigo' => 0,
                'msg' => 'Error al llamar a la API la  ruta  es incorrecta  o no existe ',
            );
        }

        $api_payload = array(
            'phone' => $phone,
            'template' => $templateName,
        );
        if ($datos !== null) {
            // Puedes usar el operador de combinación de arreglos para agregar datos
            $api_payload = array_merge($api_payload, $datos);
        }
        /*
        echo '<pre>';
        print_r($api_payload);
        echo '</pre>';
        die();
         */

        // Inicializar cURL
        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($api_payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
        ));

        // Ejecutar la solicitud cURL
        $api_response = curl_exec($ch);
        $api_error = curl_error($ch);
        curl_close($ch);

        if ($api_error) {
            return array(
                'codigo' => 0,
                'msg' => 'Error al llamar a la API: ' . $api_error,
            );
        } else {
            $api_data = json_decode($api_response, true);
            return array(
                'codigo' => 1,
                'msg' => 'Respuesta de la API: ' . json_encode($api_data),
                'data' => $api_data,
            );
        }
    }

    public function obtenerDatosRegistroRequicisionCliente($id_requisicion)
    {
        // Cargar la base de datos si no está ya cargada
        $this->db->select('
        c.nombre AS nombre_cliente,
        CONCAT_WS(" ", dg.nombre, dg.paterno) AS nombre_gerente,
        dg.telefono AS phone,
        dg.correo,
        r.puesto AS vacante
    ');
        $this->db->from('requisicion r');
        $this->db->join('cliente c', 'r.id_cliente = c.id', 'left');
        $this->db->join('usuarios_portal up', 'r.id_portal = up.id_portal', 'left');
        $this->db->join('datos_generales dg', 'up.id_datos_generales = dg.id', 'left');
        $this->db->where('r.id', $id_requisicion);
        $this->db->where('up.id_rol', 6); 

        $query = $this->db->get();
        $resultado = $query->row(); // Obtener la primera fila como objeto

        if ($resultado) {
            return $resultado;
           /* return array(
                'nombre_cliente' => $resultado->nombre_cliente,
                'nombre_gerente' => $resultado->nombre_gerente,
                'telefono' => $resultado->phone,
                'correo' => $resultado->correo,
                'puesto' => $resultado->puesto,
            );*/
        } else {
            // Si no se encuentra el registro, retornar null o datos vacíos
            return null;
        }
    }

    public function obtenerDatosPorRequisicionAspirante($id_requisicion_aspirante)
    {
        // Cargar la base de datos si no está ya cargada
        $this->load->database();

        // Construir la consulta usando el Query Builder
        $this->db->select('r.puesto AS vacante,
                            c.nombre AS nombre_cliente,
                            dg.telefono AS phone,
                            CONCAT_WS(" ", b.nombre, b.paterno, IFNULL(b.materno, "")) AS nombre_completo');
        $this->db->from('requisicion_aspirante ra');
        $this->db->join('requisicion r', 'ra.id_requisicion = r.id');
        $this->db->join('cliente c', 'r.id_cliente = c.id');
        $this->db->join('datos_generales dg', 'c.id_datos_generales = dg.id');
        $this->db->join('bolsa_trabajo b', 'ra.id_bolsa_trabajo = b.id');
        $this->db->where('ra.id', $id_requisicion_aspirante);

        // Ejecutar la consulta
        $query = $this->db->get();

        // Comprobar si se encontraron resultados
        if ($query->num_rows() > 0) {
            return $query->row(); // Retorna la primera fila como objeto
        } else {
            return null; // No se encontraron resultados
        }
    }

    public function obtenerDatosPorRequisicionAspiranteCliente($id_requisicion_aspirante)
    {
        // Cargar la base de datos si no está ya cargada
        $this->load->database();

        // Construir la consulta usando el Query Builder
        $this->db->select('r.puesto AS vacante,
                            c.nombre AS nombre_cliente,
                            dg.telefono AS phone,
                            CONCAT_WS(" ", b.nombre, b.paterno, IFNULL(b.materno, "")) AS nombre_completo,
                            CONCAT_WS(" ", dg.nombre, dg.paterno) AS nombre_reclutador');
        $this->db->from('requisicion_aspirante ra');
        $this->db->join('requisicion r', 'ra.id_requisicion = r.id');
        $this->db->join('cliente c', 'r.id_cliente = c.id');
        $this->db->join('usuarios_portal up', 'ra.id_usuario = up.id');
        $this->db->join('datos_generales dg', 'up.id_datos_generales = dg.id');
        $this->db->join('bolsa_trabajo b', 'ra.id_bolsa_trabajo = b.id');
        $this->db->where('ra.id', $id_requisicion_aspirante);

        // Ejecutar la consulta
        $query = $this->db->get();

        // Comprobar si se encontraron resultados
        if ($query->num_rows() > 0) {
            return $query->row(); // Retorna la primera fila como objeto
        } else {
            return null; // No se encontraron resultados
        }
    }

}
