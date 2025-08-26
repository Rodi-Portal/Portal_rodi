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
        'ciudad',
    ];

    // Obtener columnas disponibles y la configuración del usuario
    public function getColumnasConfiguracion($idUsuario, $idCliente, $idPortal, $modulo = 'mensajeria')
    {
        // Obtener configuración guardada
        $this->db->where('id_usuario', $idUsuario);
        $this->db->where('id_portal', $idPortal);
        $this->db->where('modulo', $modulo);
        $resultado = $this->db->get('configuracion_columnas')->row();

        if ($resultado && ! empty($resultado->columnas)) {
            // columnas está almacenado como JSON en la base de datos
            $columnasUsuario = json_decode($resultado->columnas, true);
        } else {
            $columnasUsuario = null;
        }

        return [
            'disponibles'   => $this->columnasDisponibles,
            'seleccionadas' => $columnasUsuario,
        ];
    }

    // Guardar o actualizar configuración del usuario
    public function guardarConfiguracion($idUsuario, $idCliente, $idPortal, $modulo, $columnas)
    {
        $oldDebug           = $this->db->db_debug;
        $this->db->db_debug = false;

        $data = [
            'id_usuario' => (int) $idUsuario,
            'id_cliente' => $idCliente, // puede ser NULL
            'id_portal'  => (int) $idPortal,
            'modulo'     => $modulo,
            'columnas'   => json_encode($columnas, JSON_UNESCAPED_UNICODE),
            'edicion'    => date('Y-m-d H:i:s'),
        ];

        // ¿Existe por (usuario, portal, módulo)?
        $existe = $this->db->select('id')
            ->from('configuracion_columnas')
            ->where('id_usuario', (int) $idUsuario)
            ->where('id_portal', (int) $idPortal)
            ->where('modulo', $modulo)
            ->get()->row();

        if ($existe) {
            $ok = $this->db->where('id', $existe->id)
                ->update('configuracion_columnas', $data);
        } else {
            $data['creacion'] = date('Y-m-d H:i:s');
            $ok               = $this->db->insert('configuracion_columnas', $data);
        }

        $dbError            = $this->db->error();
        $this->db->db_debug = $oldDebug;

        if (! $ok || ! empty($dbError['code'])) {
            throw new Exception('DB error ' . $dbError['code'] . ': ' . $dbError['message']);
        }

        return true;
    }

}
