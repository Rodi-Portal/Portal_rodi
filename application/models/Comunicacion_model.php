<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Comunicacion_model extends CI_Model
{
    // Columnas disponibles fijas (según tus datos)
    private $columnasDisponibles = [
        'nombreCliente',
        'telefono',
        'correo',
        'max',
        'empleados_activos',
        'estado',
        'pais',
        'ciudad'
    ];

    // Obtener columnas disponibles y la configuración del usuario
    public function getColumnasConfiguracion($idUsuario, $idCliente, $idPortal, $modulo = 'comunicacion')
    {
        // Obtener configuración guardada
        $this->db->where('id_usuario', $idUsuario);
        $this->db->where('id_cliente', $idCliente);
        $this->db->where('id_portal', $idPortal);
        $this->db->where('modulo', $modulo);
        $resultado = $this->db->get('configuracion_columnas')->row();

        if ($resultado && !empty($resultado->columnas)) {
            // columnas está almacenado como JSON en la base de datos
            $columnasUsuario = json_decode($resultado->columnas, true);
        } else {
            $columnasUsuario = null;
        }

        return [
            'disponibles' => $this->columnasDisponibles,
            'seleccionadas' => $columnasUsuario
        ];
    }

    // Guardar o actualizar configuración del usuario
    public function guardarConfiguracion($idUsuario, $idCliente, $idPortal, $modulo, $columnas)
    {
        $data = [
            'id_usuario' => $idUsuario,
            'id_cliente' => $idCliente,
            'id_portal' => $idPortal,
            'modulo' => $modulo,
            'columnas' => json_encode($columnas),
            'edicion' => date('Y-m-d H:i:s')
        ];

        // Verificar si ya existe para actualizar
        $this->db->where('id_usuario', $idUsuario);
        $this->db->where('id_cliente', $idCliente);
        $this->db->where('id_portal', $idPortal);
        $this->db->where('modulo', $modulo);
        $existe = $this->db->get('configuracion_columnas')->row();

        if ($existe) {
            // Actualizar
            $this->db->where('id', $existe->id);
            return $this->db->update('configuracion_columnas', $data);
        } else {
            // Insertar nuevo registro
            $data['creacion'] = date('Y-m-d H:i:s');
            return $this->db->insert('configuracion_columnas', $data);
        }
    }
}
