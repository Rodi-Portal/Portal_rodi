<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cat_subclientes_model extends CI_Model
{

    public function getTotal()
    {
        $this->db
            ->select("sub.id")
            ->from('subcliente as sub')
            ->where('sub.eliminado', 0);

        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getSubclientes()
    {
        $this->db
            ->select("sub.*,
    sub.id AS idSub,
     gen.nombre, gen.paterno,
      gen.correo,gen.telefono,
       sub.nombre_subcliente as nombreSubcliente,
        gen.paterno as paternoSubcliente,
         us.id as idUsuarioSubcliente,
         us.status as statusUsuario,
          cl.nombre as cliente, fac.razon_social, fac.rfc,
          dom.pais, dom.estado, dom.ciudad, dom.calle, dom.exterior, dom.interior, dom.cp, dom.colonia,
           COUNT(us.id) as numero_accesos")
            ->from('subclientes as sub')
            ->join('cliente as cl', 'cl.id = sub.id_cliente')
            ->join('domicilios as dom', 'dom.id = sub.id_domicilios')
            ->join('datos_facturacion as fac', 'fac.id = sub.id_datos_facturacion')
            ->join('datos_generales as gen', 'gen.id = sub.id_datos_generales')
            ->join('usuarios_portal as u', 'u.id = sub.id_usuario', "left")
            ->join('usuario_subcliente as us', 'us.id_subcliente = sub.id', "left")

            ->where('sub.eliminado', 0)
            ->where('cl.eliminado', 0)
            ->order_by('sub.creacion', 'ASC')
            ->group_by('sub.id');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getAccesos($id_subcliente)
    {
        $this->db
            ->select("sub.*,CONCAT(datup.nombre,' ',datup.paterno) as usuario, CONCAT(usub.nombre,' ',usub.paterno) as usuario_subcliente, usub.correo as correo_usuario, usub.creacion as alta, usub.id as idUsuarioSubcliente, cl.nombre as cliente")
            ->from("subclientes as sub")
            ->join("cliente as cl", "cl.id = sub.id_cliente")
            ->join("usuario_subcliente as usub", "usub.id_subcliente = sub.id")
            ->join("usuarios_portal as u", "u.id = usub.id_usuario")
            ->join("datos_generales as datup", "datup.id = usub.id_usuario")
            ->where("sub.id", $id_subcliente)
            ->order_by("usub.id", 'desc');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function existe($nombre, $clave, $id)
    {
        // echo $id." este es el id ".$clave." esta es la clave  ".$nombre." y este el nombre";
        $this->db
            ->select('id')
            ->from('subclientes')
            ->where("(nombre_subcliente = '$nombre' OR clave_subcliente = '$clave') AND id != '$id'");

        $query = $this->db->get();
        // Loguear la consulta SQL generada
        log_message('info', 'Consulta SQL en existe: ' . $this->db->last_query());
        return $query->num_rows();
    }

    public function check($id)
    {
        $this->db
            ->select('id')
            ->from('subclientes')
            ->where('id', $id);

        $query = $this->db->get();
        // Loguear la consulta SQL generada
        log_message('info', 'Consulta SQL en check: ' . $this->db->last_query());
        return $query->num_rows();
    }

    public function addSubcliente($subCliente, $datosFacturacion, $datosDomicilios, $datosGenerales)
    {
        try {
            // Iniciar la transacción
            $this->db->trans_start();

            // Agregar los datos generales y obtener el ID
            $id_datosGenerales = $this->generales_model->addDatosGenerales($datosGenerales);

            // Agregar los domicilios y obtener el ID
            $id_domicilios = $this->generales_model->addDomicilios($datosDomicilios);

            // Agregar los datos de facturación y obtener el ID
            $id_datosFacturacion = $this->generales_model->addDatosFacturacion($datosFacturacion);

            // Asignar los IDs obtenidos al cliente
            $subCliente['id_datos_generales'] = $id_datosGenerales;
            $subCliente['id_domicilios'] = $id_domicilios;
            $subCliente['id_datos_facturacion'] = $id_datosFacturacion;

            // Insertar el cliente en la tabla correspondiente
            $this->db->insert("subclientes", $subCliente);
            $idSubCliente = $this->db->insert_id();
            // Completar la transacción

            // var_dump($idSubCliente);
            $this->db->trans_complete();

            // Verificar si la transacción fue exitosa
            if ($this->db->trans_status() === false) {
                // Ocurrió un error durante la transacción, puedes manejarlo según tus necesidades
                // Puedes lanzar una excepción o retornar un código de error, dependiendo de tu lógica de manejo de errores.
                return false;
            }
            // La transacción fue exitosa, retornar el ID del cliente insertado
            return $idSubCliente;

        } catch (Exception $e) {
            // Manejar la excepción si ocurre algún error
            // Puedes lanzar una excepción personalizada o loggear el error, dependiendo de tus necesidades.
            log_message('error', 'Error en addCliente: ' . $e->getMessage());
            return false;
        }
    }

    public function editSubcliente($idSubCliente, $SubCliente, $datosFacturacion = null, $datosDomicilios = null, $datosGenerales = null)
    {

        try {
             /* var_dump($idSubCliente);
            var_dump($SubCliente);
            var_dump($datosFacturacion);
            var_dump($datosDomicilios);
            var_dump($datosGenerales);*/
            // Iniciar la transacción
            $this->db->trans_start();

            // Editar los datos generales si se proporcionaron
            if (!is_null($datosGenerales)) {
                $this->generales_model->editDatosGenerales($SubCliente['id_datos_generales'], $datosGenerales);
            }

            // Editar los domicilios si se proporcionaron
            if (!is_null($datosDomicilios)) {
                $this->generales_model->editDomicilios($SubCliente['id_domicilios'], $datosDomicilios);
            }

            // Editar los datos de facturación si se proporcionaron
            if (!is_null($datosFacturacion)) {
                $this->generales_model->editDatosFacturacion($SubCliente['id_datos_facturacion'], $datosFacturacion);
            }

            // Actualizar el cliente en la tabla correspondiente si se proporcionó
            if (!is_null($SubCliente)) {
                $this->db->where('id', $idSubCliente)->update('subclientes', $SubCliente);
            }

            // Completar la transacción
            $this->db->trans_complete();

            // Verificar si la transacción fue exitosa
            if ($this->db->trans_status() === false) {
                // Ocurrió un error durante la transacción, manejar según tus necesidades
                return false;
            }

            // La transacción fue exitosa, retornar true
            return true;
        } catch (Exception $e) {
            // Manejar la excepción si ocurre algún error
            log_message('error', 'Error al Editar Subcliente: ' . $e->getMessage());
            return false;
        }
    }
    public function registrarUsuario($usuario)
    {
        $this->db->insert("usuario_subcliente", $usuario);
    }

    public function getOpcionesSubclientes($id_cliente)
    {
      echo $id_cliente."    aqui ";
        $this->db
            ->select('*')
            ->from('subclientes')
            ->where('id_cliente', $id_cliente)
            ->where('status', 1)
            ->where('eliminado', 0)
            ->order_by('nombre_subcliente', 'ASC');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function editarAcceso($usuario, $idUsuarioSubcliente)
    {
        $this->db
            ->where('id', $idUsuarioSubcliente)
            ->update('usuario_subcliente', $usuario);
    }

    public function deleteAcceso($idUsuarioSubcliente)
    {
        $this->db
            ->where('id', $idUsuarioSubcliente)
            ->delete('usuario_subcliente');
    }

    public function getUsuariosSubclientePorCandidato($id_candidato)
    {
        $this->db
            ->select("sub.correo, CONCAT(c.nombre,' ',c.paterno,' ',c.materno) as candidato")
            ->from('candidato as c')
            ->join("usuario_subcliente as sub", "sub.id_subcliente = c.id_subcliente")
            ->where('c.id', $id_candidato);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getSubclientesByidSunCliente($id_cliente)
    {
        $this->db
            ->select("id")
            ->from('subcliente as c')
            ->where('id_cliente', $id_cliente);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}
