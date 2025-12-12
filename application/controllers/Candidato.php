<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Nullix\CryptoJsAes\CryptoJsAes;

require_once APPPATH . 'src/CryptoJsAes.php';

class Candidato extends Custom_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('id')) {
            redirect('Login/index');
        }
        $this->load->library('usuario_sesion');
        $this->usuario_sesion->checkStatusBD();
    }

    public function getById()
    {
        $res = $this->candidato_model->getById($this->input->post('id'));
        if ($res != null) {
            echo json_encode($res);
        } else {
            echo $res = 0;
        }
    }
    public function set()
    {
        $id_candidato = $this->input->post('id_candidato');
        $seccion      = $this->candidato_seccion_model->getSecciones($id_candidato);

        $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
        $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
        $this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
        $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required|trim');

        if ($seccion->id_seccion_datos_generales == 50) {
            $this->form_validation->set_rules('civil', 'Estado civil', 'required|trim');
            $this->form_validation->set_rules('celular', 'Tel. Celular', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
            $this->form_validation->set_rules('lugar', 'Lugar de nacimiento', 'required|trim');
            $this->form_validation->set_rules('calle', 'Calle', 'required|trim');
            $this->form_validation->set_rules('exterior', 'No. Exterior', 'required|trim|max_length[8]');
            $this->form_validation->set_rules('interior', 'No. Interior', 'trim|max_length[8]');
            $this->form_validation->set_rules('colonia', 'Colonia', 'required|trim');
            $this->form_validation->set_rules('estado', 'Estado', 'required|trim|numeric');
            $this->form_validation->set_rules('municipio', 'Municipio', 'required|trim|numeric');
            $this->form_validation->set_rules('cp', 'Código postal', 'required|trim|numeric|max_length[5]');
            $this->form_validation->set_rules('entre_calles', 'Entre calles', 'trim');
            $this->form_validation->set_rules('grado_estudios', 'Grado máximo de estudios', 'trim|required');
            $this->form_validation->set_rules('tipo_sanguineo', 'Tipo sanguíneo', 'trim');
            $this->form_validation->set_rules('tel_emergencia', 'Teléfono de emergencia', 'trim|max_length[16]');
            $this->form_validation->set_rules('contacto_emergencia', 'Contacto de emergencia', 'trim');
            $this->form_validation->set_rules('genero', 'Género', 'required|trim');
            $this->form_validation->set_rules('correo', 'Correo', 'trim|valid_email');
            $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
            $tipoPuesto  = 'id_puesto';
            $valorPuesto = $this->input->post('puesto');
        }
        if ($seccion->id_seccion_datos_generales == 51) {
            $this->form_validation->set_rules('civil', 'Estado civil', 'required|trim');
            $this->form_validation->set_rules('celular', 'Tel. Celular', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
            $this->form_validation->set_rules('pais', 'País donde reside', 'required|trim');
            $this->form_validation->set_rules('domicilio', 'Domicilio completo', 'required|trim');
            $this->form_validation->set_rules('lugar', 'Lugar de nacimiento', 'required|trim');
            $this->form_validation->set_rules('grado_estudios', 'Grado máximo de estudios', 'trim|required');
            $this->form_validation->set_rules('tipo_sanguineo', 'Tipo sanguíneo', 'trim');
            $this->form_validation->set_rules('tel_emergencia', 'Teléfono de emergencia', 'trim|max_length[16]');
            $this->form_validation->set_rules('contacto_emergencia', 'Contacto de emergencia', 'trim');
            $this->form_validation->set_rules('genero', 'Género', 'required|trim');
            $this->form_validation->set_rules('correo', 'Correo', 'trim|valid_email');
            $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
            $tipoPuesto  = 'id_puesto';
            $valorPuesto = $this->input->post('puesto');
        }
        if ($seccion->id_seccion_datos_generales == 28) {
            $this->form_validation->set_rules('civil', 'Estado civil', 'required|trim');
            $this->form_validation->set_rules('celular', 'Tel. Celular', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
            $this->form_validation->set_rules('nacionalidad', 'Nacionalidad', 'required|trim');
            $this->form_validation->set_rules('calle', 'Calle', 'required|trim');
            $this->form_validation->set_rules('exterior', 'No. Exterior', 'required|trim|max_length[8]');
            $this->form_validation->set_rules('interior', 'No. Interior', 'trim|max_length[8]');
            $this->form_validation->set_rules('colonia', 'Colonia', 'required|trim');
            $this->form_validation->set_rules('estado', 'Estado', 'required|trim|numeric');
            $this->form_validation->set_rules('municipio', 'Municipio', 'required|trim|numeric');
            $this->form_validation->set_rules('cp', 'Código postal', 'required|trim|numeric|max_length[5]');
            $this->form_validation->set_rules('entre_calles', 'Entre calles', 'trim');
            $this->form_validation->set_rules('tel_oficina', 'Tel. Oficina', 'trim|max_length[16]');
            $this->form_validation->set_rules('tiempo_dom_actual', 'Tiempo en el domicilio actual', 'trim|required');
            $this->form_validation->set_rules('tiempo_traslado', 'Tiempo de traslado a la oficina', 'trim|required');
            $this->form_validation->set_rules('medio_transporte', 'Medio de transporte', 'trim|required');
            $this->form_validation->set_rules('grado_estudios', 'Grado máximo de estudios', 'trim|required');
            $this->form_validation->set_rules('genero', 'Género', 'required|trim');
            $this->form_validation->set_rules('correo', 'Correo', 'trim|valid_email');
            $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
            $tipoPuesto  = 'id_puesto';
            $valorPuesto = $this->input->post('puesto');
        }
        if ($seccion->id_seccion_datos_generales == 68) {
            $this->form_validation->set_rules('civil', 'Estado civil', 'required|trim');
            $this->form_validation->set_rules('celular', 'Tel. Celular', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
            $this->form_validation->set_rules('pais', 'País donde reside', 'required|trim');
            $this->form_validation->set_rules('lugar', 'Lugar de nacimiento', 'required|trim');
            $this->form_validation->set_rules('calle', 'Calle', 'required|trim');
            $this->form_validation->set_rules('exterior', 'No. Exterior', 'required|trim|max_length[8]');
            $this->form_validation->set_rules('interior', 'No. Interior', 'trim|max_length[8]');
            $this->form_validation->set_rules('colonia', 'Colonia', 'required|trim');
            $this->form_validation->set_rules('estado', 'Estado', 'required|trim|numeric');
            $this->form_validation->set_rules('municipio', 'Municipio', 'required|trim|numeric');
            $this->form_validation->set_rules('cp', 'Código postal', 'required|trim|numeric|max_length[5]');
            $this->form_validation->set_rules('religion', 'Religión', 'required|trim');
            $this->form_validation->set_rules('radica', 'Tiempo de radicar en la ciuda', 'required|trim');
            $this->form_validation->set_rules('nss', 'Número de Seguro Social (NSS/IMSS)', 'required|trim');
            $this->form_validation->set_rules('curp', 'CURP', 'required|trim');
            $this->form_validation->set_rules('identificacion', 'Se identifica con', 'required|trim');
            $this->form_validation->set_rules('afore', 'AFORE', 'required|trim');
            $this->form_validation->set_rules('fecha_entrevista', 'Fecha de la entrevista al candidato', 'required|trim');
            $this->form_validation->set_rules('tiempo_dom_actual', 'Tiempo en el domicilio actual', 'required|trim|required');
            $this->form_validation->set_rules('tiempo_traslado', 'Tiempo de traslado a la oficina', 'required|trim|required');
            $this->form_validation->set_rules('medio_transporte', 'Medio de transporte', 'required|trim|required');
            $this->form_validation->set_rules('reclutador', 'Reclutador', 'required|trim|required');
            $this->form_validation->set_rules('centro_costo', 'Centro de costo', 'required|trim|required');
            $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
            $tipoPuesto  = 'id_puesto';
            $valorPuesto = $this->input->post('puesto');
        }
        if ($seccion->id_seccion_datos_generales == 78) {
            $this->form_validation->set_rules('lugar', 'Lugar de nacimiento', 'required|trim');
            $this->form_validation->set_rules('nss', 'Número de Seguro Social (NSS/IMSS)', 'required|trim');
            $this->form_validation->set_rules('curp', 'CURP', 'required|trim');
            $this->form_validation->set_rules('genero', 'Género', 'required|trim');
            $this->form_validation->set_rules('reclutador', 'Reclutador', 'required|trim|required');
            $this->form_validation->set_rules('centro_costo', 'Centro de costo', 'required|trim|required');
            $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
            $tipoPuesto  = 'id_puesto';
            $valorPuesto = $this->input->post('puesto');
        }
        if ($seccion->id_seccion_datos_generales == 1) {
            $this->form_validation->set_rules('civil', 'Estado civil', 'required|trim');
            $this->form_validation->set_rules('celular', 'Tel. Celular', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
            $this->form_validation->set_rules('nacionalidad', 'Nacionalidad', 'required|trim');
            $this->form_validation->set_rules('calle', 'Calle', 'required|trim');
            $this->form_validation->set_rules('exterior', 'No. Exterior', 'required|trim|max_length[8]');
            $this->form_validation->set_rules('interior', 'No. Interior', 'trim|max_length[8]');
            $this->form_validation->set_rules('entre_calles', 'Entre calles', 'trim');
            $this->form_validation->set_rules('colonia', 'Colonia', 'required|trim');
            $this->form_validation->set_rules('estado', 'Estado', 'required|trim|numeric');
            $this->form_validation->set_rules('municipio', 'Municipio', 'required|trim|numeric');
            $this->form_validation->set_rules('cp', 'Código postal', 'required|trim|numeric|max_length[5]');
            $this->form_validation->set_rules('correo', 'Correo', 'required|trim|valid_email');
            $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
            $this->form_validation->set_rules('curp', 'CURP', 'required|trim|max_length[18]');
            $tipoPuesto  = 'puesto';
            $valorPuesto = $this->input->post('puesto');
        }
        if ($seccion->id_seccion_datos_generales == 2) {
            $this->form_validation->set_rules('civil', 'Estado civil', 'required|trim');
            $this->form_validation->set_rules('domicilio', 'Domicilio completo', 'required|trim');
            $this->form_validation->set_rules('celular', 'Tel. Celular', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
            $this->form_validation->set_rules('nacionalidad', 'Nacionalidad', 'required|trim');
            $this->form_validation->set_rules('correo', 'Correo', 'required|trim|valid_email');
            $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
            $tipoPuesto  = 'puesto';
            $valorPuesto = $this->input->post('puesto');
        }
        if ($seccion->id_seccion_datos_generales == 82) {
            $this->form_validation->set_rules('civil', 'Estado civil', 'required|trim');
            $this->form_validation->set_rules('celular', 'Tel. Celular', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
            $this->form_validation->set_rules('nacionalidad', 'Nacionalidad', 'required|trim');
            $this->form_validation->set_rules('calle', 'Calle', 'required|trim');
            $this->form_validation->set_rules('exterior', 'No. Exterior', 'required|trim|max_length[8]');
            $this->form_validation->set_rules('interior', 'No. Interior', 'trim|max_length[8]');
            $this->form_validation->set_rules('entre_calles', 'Entre calles', 'trim');
            $this->form_validation->set_rules('colonia', 'Colonia', 'required|trim');
            $this->form_validation->set_rules('estado', 'Estado', 'required|trim|numeric');
            $this->form_validation->set_rules('municipio', 'Municipio', 'required|trim|numeric');
            $this->form_validation->set_rules('cp', 'Código postal', 'required|trim|numeric|max_length[5]');
            $this->form_validation->set_rules('correo', 'Correo', 'required|trim|valid_email');
            $this->form_validation->set_rules('puesto_txt', 'Puesto', 'required|trim');
            $tipoPuesto  = 'puesto';
            $valorPuesto = $this->input->post('puesto_txt');
        }
        if ($seccion->id_seccion_datos_generales == 83) {
            $this->form_validation->set_rules('puesto_txt', 'Puesto', 'required|trim');
            $this->form_validation->set_rules('civil', 'Estado civil', 'required|trim');
            $this->form_validation->set_rules('domicilio', 'Domicilio completo', 'required|trim');
            $this->form_validation->set_rules('celular', 'Tel. Celular', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
            $this->form_validation->set_rules('nacionalidad', 'Nacionalidad', 'required|trim');
            $this->form_validation->set_rules('correo', 'Correo', 'required|trim|valid_email');
            $tipoPuesto  = 'puesto';
            $valorPuesto = $this->input->post('puesto_txt');
        }
        if ($seccion->id_seccion_datos_generales != 50 && $seccion->id_seccion_datos_generales != 28 && $seccion->id_seccion_datos_generales != 51 && $seccion->id_seccion_datos_generales != 68 && $seccion->id_seccion_datos_generales != 78 && $seccion->id_seccion_datos_generales != 1 && $seccion->id_seccion_datos_generales != 2 && $seccion->id_seccion_datos_generales != 83) {
            $this->form_validation->set_rules('civil', 'Estado civil', 'required|trim');
            $this->form_validation->set_rules('celular', 'Tel. Celular', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
            $this->form_validation->set_rules('nacionalidad', 'Nacionalidad', 'required|trim');
            $this->form_validation->set_rules('calle', 'Calle', 'required|trim');
            $this->form_validation->set_rules('exterior', 'No. Exterior', 'required|trim|max_length[8]');
            $this->form_validation->set_rules('interior', 'No. Interior', 'trim|max_length[8]');
            $this->form_validation->set_rules('entre_calles', 'Entre calles', 'trim');
            $this->form_validation->set_rules('colonia', 'Colonia', 'required|trim');
            $this->form_validation->set_rules('estado', 'Estado', 'required|trim|numeric');
            $this->form_validation->set_rules('municipio', 'Municipio', 'required|trim|numeric');
            $this->form_validation->set_rules('cp', 'Código postal', 'required|trim|numeric|max_length[5]');
            $this->form_validation->set_rules('correo', 'Correo', 'required|trim|valid_email');
            $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
            $tipoPuesto  = 'puesto';
            $valorPuesto = $this->input->post('puesto');
        }
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('alpha', 'El campo {field} debe contener solo carácteres alfabéticos y sin acentos');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date       = date('Y-m-d H:i:s');
            $id_usuario = $this->session->userdata('id');
            $fecha      = fecha_espanol_bd($this->input->post('fecha_nacimiento'));
            $edad       = calculaEdad($fecha);

            $candidato = [
                'edicion'                 => $date,
                'id_usuario'              => $id_usuario,
                'id_subcliente'           => $this->input->post('reclutador'),
                'nombre'                  => $this->input->post('nombre'),
                'paterno'                 => $this->input->post('paterno'),
                'materno'                 => $this->input->post('materno'),
                'fecha_nacimiento'        => $fecha,
                'edad'                    => $edad,
                $tipoPuesto               => $valorPuesto,
                'lugar_nacimiento'        => $this->input->post('lugar'),
                'nacionalidad'            => $this->input->post('nacionalidad'),
                'genero'                  => $this->input->post('genero'),
                'id_grado_estudio'        => $this->input->post('grado_estudios'),
                'calle'                   => $this->input->post('calle'),
                'exterior'                => $this->input->post('exterior'),
                'interior'                => $this->input->post('interior'),
                'entre_calles'            => $this->input->post('entre_calles'),
                'colonia'                 => $this->input->post('colonia'),
                'id_estado'               => $this->input->post('estado'),
                'id_municipio'            => $this->input->post('municipio'),
                'cp'                      => $this->input->post('cp'),
                'estado_civil'            => $this->input->post('civil'),
                'celular'                 => $this->input->post('celular'),
                'telefono_casa'           => $this->input->post('tel_casa'),
                'telefono_otro'           => $this->input->post('tel_oficina'),
                'tiempo_dom_actual'       => $this->input->post('tiempo_dom_actual'),
                'tiempo_traslado'         => $this->input->post('tiempo_traslado'),
                'tipo_transporte'         => $this->input->post('medio_transporte'),
                'correo'                  => $this->input->post('correo'),
                'pais'                    => $this->input->post('pais'),
                'domicilio_internacional' => $this->input->post('domicilio'),
                'tipo_sanguineo'          => $this->input->post('tipo_sanguineo'),
                'tel_emergencia'          => $this->input->post('tel_emergencia'),
                'contacto_emergencia'     => $this->input->post('contacto_emergencia'),
                'religion'                => $this->input->post('religion'),
                'tiempo_radica'           => $this->input->post('radica'),
                'nss'                     => $this->input->post('nss'),
                'curp'                    => $this->input->post('curp'),
                'tipo_identificacion'     => $this->input->post('identificacion'),
                'afore'                   => $this->input->post('afore'),
                'fecha_entrevista'        => $this->input->post('fecha_entrevista'),
                'centro_costo'            => $this->input->post('centro_costo'),
            ];
            $this->candidato_model->edit($candidato, $id_candidato);
            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function setInternacional()
    {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
        $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
        $this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
        $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required|trim');
        $this->form_validation->set_rules('nacionalidad', 'Nacionalidad', 'required|trim');
        $this->form_validation->set_rules('puesto', 'Puesto', 'required|trim');
        $this->form_validation->set_rules('genero', 'Género', 'required|trim');
        $this->form_validation->set_rules('domicilio', 'Domicilio', 'required|trim');
        $this->form_validation->set_rules('pais', 'País', 'required|trim');
        $this->form_validation->set_rules('civil', '', 'required|trim');
        $this->form_validation->set_rules('celular', 'Tel. Celular', 'required|trim|max_length[16]');
        $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
        $this->form_validation->set_rules('otro_telefono', 'Otro teléfono', 'trim|max_length[16]');
        $this->form_validation->set_rules('correo', 'Correo', 'required|trim|valid_email');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('alpha', 'El campo {field} debe contener solo carácteres alfabéticos y sin acentos');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date         = date('Y-m-d H:i:s');
            $id_candidato = $this->input->post('id_candidato');
            $id_usuario   = $this->session->userdata('id');
            $fecha        = fecha_espanol_bd($this->input->post('fecha_nacimiento'));
            $edad         = calculaEdad($fecha);

            $candidato = [
                'edicion'                 => $date,
                'id_usuario'              => $id_usuario,
                'nombre'                  => $this->input->post('nombre'),
                'paterno'                 => $this->input->post('paterno'),
                'materno'                 => $this->input->post('materno'),
                'fecha_nacimiento'        => $fecha,
                'edad'                    => $edad,
                'puesto'                  => $this->input->post('puesto'),
                'nacionalidad'            => $this->input->post('nacionalidad'),
                'genero'                  => $this->input->post('genero'),
                'domicilio_internacional' => $this->input->post('domicilio'),
                'pais'                    => $this->input->post('pais'),
                'estado_civil'            => $this->input->post('civil'),
                'celular'                 => $this->input->post('celular'),
                'telefono_casa'           => $this->input->post('tel_casa'),
                'telefono_otro'           => $this->input->post('otro_telefono'),
                'correo'                  => $this->input->post('correo'),
            ];
            $this->candidato_model->edit($candidato, $id_candidato);
            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function setContacto()
    {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
        $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
        $this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
        $this->form_validation->set_rules('celular', 'Tel. Celular', 'required|trim|max_length[16]');
        $this->form_validation->set_rules('tel_casa', 'Tel. Casa', 'trim|max_length[16]');
        $this->form_validation->set_rules('correo', 'Correo', 'required|trim|valid_email');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('alpha', 'El campo {field} debe contener solo carácteres alfabéticos y sin acentos');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date         = date('Y-m-d H:i:s');
            $id_candidato = $this->input->post('id_candidato');
            $id_usuario   = $this->session->userdata('id');

            $candidato = [
                'edicion'       => $date,
                'id_usuario'    => $id_usuario,
                'nombre'        => $this->input->post('nombre'),
                'paterno'       => $this->input->post('paterno'),
                'materno'       => $this->input->post('materno'),
                'celular'       => $this->input->post('celular'),
                'telefono_casa' => $this->input->post('tel_casa'),
                'correo'        => $this->input->post('correo'),
            ];
            $this->candidato_model->edit($candidato, $id_candidato);
            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function setDocumentacion()
    {
        $this->form_validation->set_rules('fecha_acta', 'Fecha de expedición del acta de nacimiento', 'required|trim');
        $this->form_validation->set_rules('numero_acta', 'Número y/o vigencia del acta de nacimiento', 'required|trim');
        $this->form_validation->set_rules('fecha_domicilio', 'Fecha de expedición del comprobante de domicilio', 'required|trim');
        $this->form_validation->set_rules('numero_domicilio', 'Número y/o vigencia del comprobante de domicilio', 'required|trim');
        $this->form_validation->set_rules('fecha_ine', 'Fecha de expedición del documento de identificación', 'trim|numeric|max_length[4]');
        $this->form_validation->set_rules('numero_ine', 'Número y/o vigencia del documento de identificación', 'trim');
        $this->form_validation->set_rules('fecha_curp', 'Fecha de expedición de la CURP', 'required|trim');
        $this->form_validation->set_rules('numero_curp', 'Número y/o vigencia de la CURP', 'required|trim');
        $this->form_validation->set_rules('fecha_imss', 'Fecha de expedición de afiliación al IMSS (NSS)', 'trim');
        $this->form_validation->set_rules('numero_imss', 'Número y/o vigencia de afiliación al IMSS (NSS)', 'trim');
        $this->form_validation->set_rules('fecha_retencion', 'Fecha de expedición del comprobante retención de impuestos', 'trim');
        $this->form_validation->set_rules('numero_retencion', 'Número y/o vigencia del comprobante retención de impuestos', 'trim');
        $this->form_validation->set_rules('fecha_rfc', 'Fecha de expedición del RFC', 'required|trim');
        $this->form_validation->set_rules('numero_rfc', 'Número y/o vigencia del del RFC', 'required|trim');
        $this->form_validation->set_rules('fecha_licencia', 'Fecha de expedición de la licencia para conducir', 'trim');
        $this->form_validation->set_rules('numero_licencia', 'Número y/o vigencia de la licencia para conducir', 'trim');
        $this->form_validation->set_rules('fecha_migra', 'Fecha de expedición de la vigencia migratoria (extranjeros)', 'trim');
        $this->form_validation->set_rules('numero_migra', 'Número y/o vigencia de la vigencia migratoria (extranjeros)', 'trim');
        $this->form_validation->set_rules('fecha_visa', 'Fecha de expedición de la VISA', 'trim');
        $this->form_validation->set_rules('numero_visa', 'Número y/o vigencia de la VISA', 'trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date         = date('Y-m-d H:i:s');
            $id_candidato = $this->input->post('id_candidato');
            $id_usuario   = $this->session->userdata('id');

            $f_acta        = ($this->input->post('fecha_acta') != '') ? fecha_espanol_bd($this->input->post('fecha_acta')) : null;
            $f_domicilio   = ($this->input->post('fecha_domicilio') != '') ? fecha_espanol_bd($this->input->post('fecha_domicilio')) : null;
            $f_curp        = ($this->input->post('fecha_curp') != '') ? fecha_espanol_bd($this->input->post('fecha_curp')) : null;
            $f_imss        = ($this->input->post('fecha_imss') != '') ? fecha_espanol_bd($this->input->post('fecha_imss')) : null;
            $f_retencion   = ($this->input->post('fecha_retencion') != '') ? fecha_espanol_bd($this->input->post('fecha_retencion')) : null;
            $f_rfc         = ($this->input->post('fecha_rfc') != '') ? fecha_espanol_bd($this->input->post('fecha_rfc')) : null;
            $f_licencia    = ($this->input->post('fecha_licencia') != '') ? fecha_espanol_bd($this->input->post('fecha_licencia')) : null;
            $f_migra       = ($this->input->post('fecha_migra') != '') ? fecha_espanol_bd($this->input->post('fecha_migra')) : null;
            $f_visa        = ($this->input->post('fecha_visa') != '') ? fecha_espanol_bd($this->input->post('fecha_visa')) : null;
            $documentacion = [
                'edicion'                   => $date,
                'fecha_acta'                => $f_acta,
                'acta'                      => $this->input->post('numero_acta'),
                'fecha_domicilio'           => $f_domicilio,
                'cuenta_domicilio'          => $this->input->post('numero_domicilio'),
                'emision_ine'               => $this->input->post('fecha_ine'),
                'ine'                       => $this->input->post('numero_ine'),
                'emision_curp'              => $f_curp,
                'curp'                      => $this->input->post('numero_curp'),
                'emision_nss'               => $f_imss,
                'nss'                       => $this->input->post('numero_imss'),
                'fecha_retencion_impuestos' => $f_retencion,
                'retencion_impuestos'       => $this->input->post('numero_retencion'),
                'emision_rfc'               => $f_rfc,
                'rfc'                       => $this->input->post('numero_rfc'),
                'fecha_licencia'            => $f_licencia,
                'licencia'                  => $this->input->post('numero_licencia'),
                'vigencia_migratoria'       => $f_migra,
                'numero_migratorio'         => $this->input->post('numero_migra'),
                'fecha_visa'                => $f_visa,
                'visa'                      => $this->input->post('numero_visa'),
            ];
            $this->candidato_model->edit($documentacion, $id_candidato);
            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function getActivosPorCliente()
    {
        $data['candidatos'] = $this->candidato_model->getActivosPorCliente($this->input->post('id_cliente'));
        if ($data['candidatos']) {
            $salida = '<option>Selecciona</option>';
            foreach ($data['candidatos'] as $row) {
                $salida .= '<option value="' . $row->id . '">' . $row->candidato . '</option>';
            }
            echo $salida;
        } else {
            echo $res = 0;
        }
    }
    public function reasignarCandidatoAnalista()
    {
        $id_candidato = $this->input->post('id_candidato');
        $id_usuario   = $this->input->post('id_usuario');

        $datos = [
            'id_usuario' => $id_usuario,
        ];
        $this->candidato_model->edit($datos, $id_candidato);
        $msj = [
            'codigo' => 1,
            'msg'    => 'Success',
        ];
        echo json_encode($msj);
    }
    public function addToken()
    {
        $id_candidato = $this->input->post('id');

        $this->form_validation->set_rules('token', 'Link', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('alpha', 'El campo {field} debe contener solo carácteres alfabéticos y sin acentos');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date       = date('Y-m-d H:i:s');
            $id_usuario = $this->session->userdata('id');

            $candidato = [
                'edicion'    => $date,
                'id_usuario' => $id_usuario,
                'token'      => $this->input->post('token'),
            ];
            $this->candidato_model->edit($candidato, $id_candidato);
            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function setSubcliente()
    {
        $this->form_validation->set_rules('id_subcliente', 'Elige el subcliente a asignar', 'required|numeric|greater_than[0]');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('alpha', 'El campo {field} debe contener solo carácteres alfabéticos y sin acentos');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');
        $this->form_validation->set_message('greater_than', 'El campo {field} debe ser una opción válida');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $id_candidato = $this->input->post('id_candidato');
            $date         = date('Y-m-d H:i:s');
            $id_usuario   = $this->session->userdata('id');

            $candidato = [
                'edicion'       => $date,
                'id_usuario'    => $id_usuario,
                'id_subcliente' => $this->input->post('id_subcliente'),
            ];
            $this->candidato_model->edit($candidato, $id_candidato);
            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function setVisita()
    {
        $id_candidato = $this->input->post('id_candidato');
        date_default_timezone_set('America/Mexico_City');
        $date       = date('Y-m-d H:i:s');
        $id_usuario = $this->session->userdata('id');

        $candidato = [
            'edicion'   => $date,
            'visitador' => 1,
        ];
        $this->candidato_model->edit($candidato, $id_candidato);

        $comentario = ($this->input->post('comentario') != '') ? $this->input->post('comentario') : 'Sin comentarios en la visita';
        //* Registro de notificacion de visita finalizada
        $datosUsuario  = $this->usuario_model->getDatosUsuario($id_usuario);
        $tieneVisita   = $this->visita_model->get_by_candidato($id_candidato);
        $rolesUsuarios = $this->usuario_model->get_usuarios_by_rol([1, 2, 4, 6, 9, 10, 11]);
        if (! empty($tieneVisita)) {
            $visita = [
                'edicion'     => $date,
                'id_usuario'  => $id_usuario,
                'fecha_final' => $date,
                'comentarios' => $comentario,
            ];
            $this->candidato_model->editarDatosVisita($visita, $id_candidato);
        } else {
            $visita = [
                'creacion'     => $date,
                'edicion'      => $date,
                'id_usuario'   => $id_usuario,
                'id_candidato' => $id_candidato,
                'comentarios'  => $comentario,
            ];
            $this->candidato_model->crearVisita($visita);
        }
        foreach ($rolesUsuarios as $row) {
            $rolesObjetivos[] = $row->id;
        }
        $titulo  = 'Visita registrada';
        $mensaje = 'Se ha registrado la visita del candidato ' . $tieneVisita->candidato . ', realizada por: ' . $datosUsuario->nombre . ' ' . $datosUsuario->paterno;
        $this->registrar_notificacion($rolesObjetivos, $titulo, $mensaje);
    }
    public function cancelarCandidato()
    {
        date_default_timezone_set('America/Mexico_City');
        $date         = date('Y-m-d H:i:s');
        $id_usuario   = $this->session->userdata('id');
        $id_candidato = $this->input->post('id_candidato');
        $comentario   = $this->input->post('comentario');
        $aspirante    = $this->reclutamiento_model->getAspiranteByCandidato($id_candidato);
        if ($comentario != '') {
            if ($aspirante != null) {
                $historial = [
                    'creacion'         => $date,
                    'id_usuario'       => $id_usuario,
                    'id_requisicion'   => $aspirante->id_requisicion,
                    'id_bolsa_trabajo' => $aspirante->id_bolsa_trabajo,
                    'id_aspirante'     => $aspirante->id_aspirante,
                    'accion'           => 'Analista cancela ESE',
                    'descripcion'      => $comentario,
                ];
                $this->reclutamiento_model->guardarAccionRequisicion($historial);
                $bolsa = [
                    'status' => 1,
                ];
                $this->reclutamiento_model->editBolsaTrabajo($bolsa, $aspirante->id_bolsa_trabajo);
            }
            $cancelacion = [
                'creacion'     => $date,
                'id_usuario'   => $id_usuario,
                'id_candidato' => $id_candidato,
                'motivo'       => $comentario,
            ];
            $this->candidato_model->setCancelacion($cancelacion);
            $candidato = [
                'cancelado' => 1,
            ];
            $this->candidato_model->editarCandidato($candidato, $id_candidato);
            $msj = [
                'codigo' => 1,
                'msg'    => 'Candidato(a) cancelado(a) correctamente',
            ];
        } else {
            $msj = [
                'codigo' => 0,
                'msg'    => 'Campo(s) vacío(s)',
            ];
        }
        echo json_encode($msj);
    }
    public function liberarProceso()
    {
        $date         = date('Y-m-d H:i:s');
        $id_usuario   = $this->session->userdata('id');
        $id_candidato = $this->input->post('id_candidato');
        $accion       = $this->input->post('accion');
        if ($accion == 1) {
            $datos = [
                'liberado' => 1,
            ];
            $this->candidato_model->editarCandidato($datos, $id_candidato);
            //* Registro y actualizacion de datos en requisicion/bolsa de trabajo si proviene de Reclutamiento
            $candidato = $this->candidato_model->getById($id_candidato);
            if ($candidato->id_aspirante != '' && $candidato->id_aspirante != null) {
                $aspirante = $this->reclutamiento_model->getAspiranteById($candidato->id_aspirante);
                $accion    = [
                    'creacion'         => $date,
                    'id_usuario'       => $id_usuario,
                    'id_requisicion'   => $aspirante->id_requisicion,
                    'id_bolsa_trabajo' => $aspirante->id_bolsa_trabajo,
                    'id_aspirante'     => $candidato->id_aspirante,
                    'accion'           => 'ESE finalizado',
                    'descripcion'      => 'Se ha finalizado el estudio socioeconomico del candidato en RODI RECLUTAMIENTO',
                ];
                $this->reclutamiento_model->guardarAccionRequisicion($accion);
                $aspirante = [
                    'status'       => 'Se ha finalizado el estudio socioeconomico del candidato en RODI RECLUTAMIENTO',
                    'status_final' => 'ESE FINALIZADO',
                ];
                $this->reclutamiento_model->editarAspirante($aspirante, $candidato->id_aspirante);
                switch ($candidato->status_bgc) {
                    case 1:
                    case 4:
                        $semaforo = 1;
                        break;
                    case 2:
                        $semaforo = 3;
                        break;
                    case 3:
                    case 5:
                        $semaforo = 2;
                        break;
                    default:
                        $semaforo = 0;
                        break;
                }
                $bolsa = [
                    'edicion'  => $date,
                    'status'   => 1,
                    'semaforo' => $semaforo,
                ];
                $this->reclutamiento_model->editBolsaTrabajo($bolsa, $this->input->post('id_bolsa_trabajo'));
            }
            $msj = [
                'codigo' => 1,
                'msg'    => 'Se ha liberado correctamente',
            ];
            //* Envio de correo a clientes (usuarios registrados) para dar aviso de que ha terminado el proceso del candidato
            $candidato_detalle = $this->candidato_model->getDetalles($id_candidato);

            if ($candidato_detalle->id_cliente != 2) {
                $this->correo_cliente_candidato_finalizado($id_candidato);
            }
            //* Envio de correo al finalizar el candidato. Solo HCL
            if ($candidato_detalle->id_cliente == 2) {
                $from              = $this->config->item('smtp_user');
                $to                = 'bgv.latam@hcl.com';
                $subject           = "A candidate's process has ended - RODI (PERINTEX)";
                $data['candidato'] = $candidato_detalle->candidato;
                $message           = $this->load->view('mails/candidato_finalizado_hcl', $data, true);
                $this->load->library('phpmailer_lib');
                $mail = $this->phpmailer_lib->load();
                $mail->isSMTP();
                $mail->Host       = 'mail.rodicontrol.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'rodicontrol@rodicontrol.com';
                $mail->Password   = 'r49o*&rUm%91';
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;
                $mail->setFrom('rodicontrol@rodicontrol.com', 'Automatic message from RODICONTROL');
                $mail->addAddress($to);
                $mail->Subject = $subject;
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Body    = $message;
                $mail->send();
            }
        }
        if ($accion == 0) {
            $datos = [
                'liberado' => 0,
            ];
            $this->candidato_model->editarCandidato($datos, $id_candidato);
            $msj = [
                'codigo' => 1,
                'msg'    => 'Se ha detenido correctamente',
            ];
        }
        echo json_encode($msj);
    }
    public function registroTipoBeca()
    {
        $this->form_validation->set_rules('nombre', 'Nombre(s)', 'required|trim');
        $this->form_validation->set_rules('paterno', 'Apellido paterno', 'required|trim');
        $this->form_validation->set_rules('materno', 'Apellido materno', 'trim');
        $this->form_validation->set_rules('subcliente', 'Subcliente (Proveedor)', 'trim');
        $this->form_validation->set_rules('celular', 'Teléfono', 'trim|max_length[16]');

        if ($this->session->userdata('idcliente') != null) {
            $id_cliente = $this->session->userdata('idcliente');
        } else {
            $id_cliente = $this->input->post('id_cliente');
        }
        $cliente = $this->cat_cliente_model->getById($id_cliente);

        $seccion = $this->candidato_seccion_model->getProyectoHistorialByIdProyecto(430);

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $nombre             = strtoupper($this->input->post('nombre'));
            $paterno            = strtoupper($this->input->post('paterno'));
            $materno            = strtoupper($this->input->post('materno'));
            $celular            = $this->input->post('celular');
            $id_subcliente      = $this->input->post('subcliente');
            $id_proyecto_previo = 430;
            $correo             = $this->input->post('correo');
            $existeCandidato    = $this->candidato_model->existeCandidatoTipoBeca($nombre, $paterno, $materno, $id_cliente, $id_proyecto_previo);
            if ($existeCandidato > 0) {
                $msj = [
                    'codigo' => 2,
                    'msg'    => 'El candidato ya existe',
                ];
            } else {
                $date                 = date('Y-m-d H:i:s');
                $usuario              = $this->input->post('usuario');
                $privacidad_candidato = 0;
                switch ($usuario) {
                    case 1:
                        $tipo_usuario = "id_usuario";
                        break;
                    case 2:
                        $tipo_usuario = "id_usuario_cliente";
                        break;
                    case 3:
                        $tipo_usuario = "id_usuario_subcliente";
                        break;
                }
                $id_usuario = $this->session->userdata('id');

                $seccion = $this->candidato_model->getProyectoPrevio($id_proyecto_previo);

                $configuracion = $this->funciones_model->getConfiguraciones();
                $usuario_lider = $configuracion->usuario_lider_espanol;
                if ($tipo_usuario == 2 || $tipo_usuario == 3) {
                    $data = [
                        'creacion'        => $date,
                        'edicion'         => $date,
                        $tipo_usuario     => $id_usuario,
                        'id_usuario'      => $usuario_lider,
                        'id_cliente'      => $id_cliente,
                        'id_subcliente'   => $id_subcliente,
                        'id_tipo_proceso' => 0,
                        'fecha_alta'      => $date,
                        'nombre'          => strtoupper($nombre),
                        'paterno'         => strtoupper($paterno),
                        'materno'         => strtoupper($materno),
                        'celular'         => $celular,
                        'subproyecto'     => $seccion->proyecto,
                        'pais'            => 'México',
                        'correo'          => $correo,
                        'privacidad'      => 3,
                    ];
                } else {
                    $data = [
                        'creacion'        => $date,
                        'edicion'         => $date,
                        'id_usuario'      => $id_usuario,
                        'id_cliente'      => $id_cliente,
                        'id_subcliente'   => $id_subcliente,
                        'id_tipo_proceso' => 0,
                        'fecha_alta'      => $date,
                        'nombre'          => strtoupper($nombre),
                        'paterno'         => strtoupper($paterno),
                        'materno'         => strtoupper($materno),
                        'celular'         => $celular,
                        'subproyecto'     => $seccion->proyecto,
                        'pais'            => 'México',
                        'correo'          => $correo,
                        'privacidad'      => 3,
                    ];
                }
                $id_candidato = $this->candidato_model->registrarRetornaCandidato($data);

                $candidato_secciones = [
                    'creacion'                        => $date,
                    $tipo_usuario                     => $id_usuario,
                    'id_candidato'                    => $id_candidato,
                    'proyecto'                        => $seccion->proyecto,
                    'secciones'                       => $seccion->secciones,
                    'lleva_identidad'                 => $seccion->lleva_identidad,
                    'lleva_empleos'                   => $seccion->lleva_empleos,
                    'lleva_criminal'                  => $seccion->lleva_criminal,
                    'lleva_estudios'                  => $seccion->lleva_estudios,
                    'lleva_domicilios'                => $seccion->lleva_domicilios,
                    'lleva_gaps'                      => $seccion->lleva_gaps,
                    'lleva_credito'                   => $seccion->lleva_credito,
                    'lleva_sociales'                  => $seccion->lleva_sociales,
                    'lleva_no_mencionados'            => $seccion->lleva_no_mencionados,
                    'lleva_investigacion'             => $seccion->lleva_investigacion,
                    'lleva_familiares'                => $seccion->lleva_familiares,
                    'lleva_egresos'                   => $seccion->lleva_egresos,
                    'lleva_vivienda'                  => $seccion->lleva_vivienda,
                    'lleva_prohibited_parties_list'   => $seccion->lleva_prohibited_parties_list,
                    'lleva_salud'                     => $seccion->lleva_salud,
                    'lleva_servicio'                  => $seccion->lleva_servicio,
                    'lleva_edad_check'                => $seccion->lleva_edad_check,
                    'lleva_extra_laboral'             => $seccion->lleva_extra_laboral,
                    'id_seccion_datos_generales'      => $seccion->id_seccion_datos_generales,
                    'id_estudios'                     => $seccion->id_estudios,
                    'id_seccion_historial_domicilios' => $seccion->id_seccion_historial_domicilios,
                    'id_seccion_verificacion_docs'    => $seccion->id_seccion_verificacion_docs,
                    'id_seccion_global_search'        => $seccion->id_seccion_global_search,
                    'id_seccion_social'               => $seccion->id_seccion_social,
                    'id_finanzas'                     => $seccion->id_finanzas,
                    'id_ref_personales'               => $seccion->id_ref_personales,
                    'id_ref_vecinal'                  => $seccion->id_ref_vecinal,
                    'id_empleos'                      => $seccion->id_empleos,
                    'id_vivienda'                     => $seccion->id_vivienda,
                    'id_salud'                        => $seccion->id_salud,
                    'id_servicio'                     => $seccion->id_servicio,
                    'id_investigacion'                => $seccion->id_investigacion,
                    'id_extra_laboral'                => $seccion->id_extra_laboral,
                    'id_no_mencionados'               => $seccion->id_no_mencionados,
                    'tiempo_empleos'                  => $seccion->tiempo_empleos,
                    'tiempo_criminales'               => $seccion->tiempo_criminales,
                    'tiempo_domicilios'               => $seccion->tiempo_domicilios,
                    'tiempo_credito'                  => $seccion->tiempo_credito,
                    'cantidad_ref_profesionales'      => $seccion->cantidad_ref_profesionales,
                    'cantidad_ref_personales'         => $seccion->cantidad_ref_personales,
                    'cantidad_ref_vecinales'          => $seccion->cantidad_ref_vecinales,
                    'tipo_conclusion'                 => $seccion->tipo_conclusion,
                    'visita'                          => $seccion->visita,
                    'tipo_pdf'                        => $seccion->tipo_pdf,
                ];
                $this->candidato_model->guardarSeccionCandidato($candidato_secciones);

                // $tipo_antidoping = ($examen == 0)? 0:1;
                // $antidoping = ($examen == 0)? 0:$examen;
                $pruebas = [
                    'creacion'          => $date,
                    'edicion'           => $date,
                    $tipo_usuario       => $id_usuario,
                    'id_candidato'      => $id_candidato,
                    'id_cliente'        => $id_cliente,
                    'socioeconomico'    => 1,
                    'tipo_antidoping'   => 0,
                    'tipo_psicometrico' => 0,
                    'psicometrico'      => 0,
                    'medico'            => 0,
                    'buro_credito'      => 0,
                    'sociolaboral'      => 0,
                ];
                $this->candidato_model->crearPruebas($pruebas);

                if ($usuario == 2 || $usuario == 3) {
                    $from         = $this->config->item('smtp_user');
                    $info_cliente = $this->cliente_general_model->getDatosCliente($this->input->post('id_cliente'));
                    $to           = "bjimenez@rodicontrol.com";
                    $subject      = " Nuevo candidato para solicitud de beca en la plataforma del cliente " . $info_cliente->nombre;
                    $message      = "Se ha agregado a " . strtoupper($this->input->post('nombre')) . " " . strtoupper($this->input->post('paterno')) . " " . strtoupper($this->input->post('materno')) . " del cliente " . $info_cliente->nombre . " en la plataforma";
                    $this->load->library('phpmailer_lib');
                    $mail = $this->phpmailer_lib->load();
                    $mail->isSMTP();
                    $mail->Host       = 'mail.rodicontrol.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'rodicontrol@rodicontrol.com';
                    $mail->Password   = 'r49o*&rUm%91';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port       = 465;
                    $mail->setFrom('rodicontrol@rodicontrol.com', 'Mensaje automático de RODICONTROL');
                    $mail->addAddress($to);
                    $mail->Subject = $subject;
                    $mail->isHTML(true);
                    $mailContent = $message;
                    $mail->Body  = $mailContent;

                    if ($mail->send()) {
                        $enviado = 1;
                    } else {
                        $enviado = 0;
                    }
                }
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'Se ha registrado correctamente',
                ];
            }
        }
        echo json_encode($msj);
    }
    public function getDatosVisita()
    {
        if (isset($_FILES["archivo"]["name"])) {
            // $this->load->library('encryption');
            // $this->encryption->initialize(
            //   array(
            //     'driver' => 'openssl',
            //     'cipher' => 'aes-256',
            //     'mode' => 'cbc',
            //     'key' => '#ZY!C47K1esET*FBmO6Rir&25F!4jLJr'
            //   )
            // );
            //$decrypted = $this->encryption->decrypt($file_content);
            $file_path    = $_FILES['archivo']['tmp_name'];
            $file_content = file_get_contents($file_path);
            $password     = '#ZY!C47K1esET*FBmO6Rir&25F!4jLJr';
            $decrypted    = CryptoJsAes::decrypt($file_content, $password);
            $extension    = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
            $decrypted    = urldecode($decrypted);
            if ($decrypted === null) {
                echo '<div class="alert alert-danger text-center">La información del archivo no es válida</div>';
                exit;
            }
            if ($extension !== 'txt') {
                echo '<div class="alert alert-danger text-center">Archivo no válido</div>';
                exit;
            }
            parse_str($decrypted, $data);
            $salida = '<div class="alert alert-info">Revisa la información. Copia y pega la información donde corresponde si el candidato no cuenta con ella</div>';
            $salida .= '<table class="table">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th width="40%">Campo</th>';
            $salida .= '<th>Respuesta</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';
            foreach ($data as $clave => $valor) {
                if ($clave != 'url' && ! is_array($valor)) {
                    $salida .= '<tr>';
                    $salida .= '<td>' . $clave . '</td>';
                    $salida .= '<td class="">' . $valor . '</td>';
                    $salida .= '</tr>';
                } elseif (is_array($valor)) {
                    for ($i = 0; $i < count($valor); $i++) {
                        $salida .= '<tr>';
                        $salida .= '<td>' . $clave . ' #' . ($i + 1) . '</td>';
                        $salida .= '<td class="">' . $valor[$i] . '</td>';
                        $salida .= '</tr>';
                    }
                }
            }
            $salida .= '</tbody></table>';
            echo $salida;
            // $date = date('Y-m-d H:i:s');
            // $id_candidato = $this->input->post('id_candidato');
            // $id_archivo = $this->input->post('id_archivo');
            // $tipoArchivo = $this->input->post('tipoArchivo');
            // $id_usuario = $this->session->userdata('id');
            // $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
            // $cadena = substr(md5(time()), 0, 16);
            // $nombre_archivo = $cadena.".".$extension;

            // if($tipoArchivo == 'psicometrico'){
            //   $carpeta = './_psicometria/';
            //   //$tipoDocumento = NULL;
            //   $tablaBD = 'psicometrico';
            //   $msj = 'La psicometria se ha subido correctamente';
            // }
            // if($tipoArchivo == 'beca'){
            //   $carpeta = './_beca/';
            //   //$tipoDocumento = NULL;
            //   $tablaBD = 'beca';
            //   $msj = 'El estudio de la solicitud de beca se ha subido correctamente';
            // }
            // $config['upload_path'] = $carpeta;
            // $config['allowed_types'] = 'pdf';
            // $config['overwrite'] = TRUE;
            // $config['file_name'] = $nombre_archivo;
            // $this->load->library('upload', $config);
            // $this->upload->initialize($config);
            // // File upload
            // if($this->upload->do_upload('archivo')){
            //   $archivoAnterior = $this->documentacion_model->getArchivo($id_candidato, $tablaBD);
            //   if(!empty($archivoAnterior->archivo)){
            //     unlink($carpeta.$archivoAnterior->archivo);
            //   }
            //   $this->documentacion_model->eliminarArchivo($id_candidato, $tablaBD);
            //   $doc = array(
            //     'creacion' => $date,
            //     'edicion' => $date,
            //     'id_usuario' => $id_usuario,
            //     'id_candidato' => $id_candidato,
            //     'archivo' => $nombre_archivo
            //   );
            //   $this->documentacion_model->subirArchivo($doc, $tablaBD);
            //   $msj = array(
            //     'codigo' => 1,
            //     'msg' => $msj
            //   );
            // }
            // else{
            //   $msj = array(
            //     'codigo' => 0,
            //     'msg' => 'Error al subir el archivo'
            //   );
            // }
        } else {
            echo '<div class="alert alert-danger text-center">Seleccione un archivo</div>';
        }
        //echo json_encode($msj);
    }
    public function registrar_confirmacion_by_candidato()
    {
        $id_candidato = $this->input->post('id_candidato');
        $contexto     = $this->input->post('contexto');
        $date         = date('Y-m-d H:i:s');
        $candidato    = $this->candidato_model->getDetalles($id_candidato);

        if ($contexto == 'formularios') {
            if (empty($candidato->fecha_contestado)) {
                $data = [
                    'fecha_contestado' => $date,
                ];
                $this->candidato_model->edit($data, $id_candidato);
            }
            $tituloContexto  = 'Candidato confirma haber completado los formularios';
            $mensajeContexto = 'El candidato ' . $candidato->candidato . ' del cliente ' . $candidato->cliente . ' confirma haber completado los formularios';
            $codigo          = 1;
            $respuesta       = 'The message was successfully sent';
        }
        if ($contexto == 'documentos') {
            if (empty($candidato->fecha_documentos)) {
                $data = [
                    'fecha_documentos' => $date,
                ];
                $this->candidato_model->edit($data, $id_candidato);
            }
            $tituloContexto  = 'Candidato confirma la subida de sus documentos';
            $mensajeContexto = 'El candidato ' . $candidato->candidato . ' del cliente ' . $candidato->cliente . ' confirma haber subido los archivos requeridos';
            $codigo          = 1;
            $respuesta       = 'The message was successfully sent';
        }
        if ($contexto == 'finalizar') {
            $data = [
                'fecha_contestado' => $date,
                'fecha_documentos' => $date,
                'status'           => 2,
                'token'            => 'finalizado',
            ];
            $this->candidato_model->edit($data, $id_candidato);
            $tituloContexto  = 'Candidato confirma haber completado toda su información';
            $mensajeContexto = 'El candidato ' . $candidato->candidato . ' del cliente ' . $candidato->cliente . ' confirma haber completado los formularios y haber subido los archivos requeridos';
            $codigo          = 2;
            $respuesta       = 'Your confirmation has sent to our analyst. If our analyst needs more information will contact you soon as possible to help us to continue with your process.';
        }

        $usuariosAnalistas = $this->usuario_model->get_usuarios_by_rol([1, 2, 6, 9]);
        foreach ($usuariosAnalistas as $row) {
            $usuariosObjetivo[] = $row->id;
        }
        $this->registrar_notificacion($usuariosObjetivo, $tituloContexto, $mensajeContexto);
        $msj = [
            'codigo' => $codigo,
            'msg'    => $respuesta,
        ];
        echo json_encode($msj);
    }
    /*----------------------------------------*/
    /*  Funciones Comunes para Candidatos
    /*----------------------------------------*/
    public function checkEstatusEstudios()
    {
        $id_candidato    = $this->input->post('id_candidato');
        $salida          = "";
        $num             = 1;
        $data['estatus'] = $this->candidato_model->checkEstatusEstudios($id_candidato);
        if ($data['estatus']) {
            foreach ($data['estatus'] as $estudio) {
                $aux             = explode('-', $estudio->fecha);
                $fecha_estatus   = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                $id_verificacion = $estudio->idVerificacion;
                $estatus         = $estudio->status;
                $salida .= '<div class="row" id="fila_estatus' . $estudio->id . '">
                                    <div class="col-3">
                                        <p class="text-center"><b>Fecha</b></p>
                                        <input type="text" class="form-control" id="fecha_estatus_estudio' . $estudio->id . '" placeholder="dd/mm/yyyy" value="' . $fecha_estatus . '">
                                    </div>
                                    <div class="col-7">
                                        <label><b>Comentario</b></label>
                                        <textarea class="form-control" id="comentario_estudio' . $estudio->id . '" rows="3">' . $estudio->comentarios . '</textarea>
                                    </div>
                                    <div class="col-2">
                                        <label><b>Acciones</b></label><br>
                                        <a href="javascript:void(0)" onclick="accionEstatusEstudio(' . $estudio->id . ',\'editar\')" class="icono_datatable"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="accionEstatusEstudio(' . $estudio->id . ',\'eliminar\')" class="icono_datatable"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div><br>';
            }
            echo $salida . '@@' . $id_verificacion . '@@' . $estatus;
        } else {
            echo $salida = 0;
        }
    }
    public function registrarEstatusEstudio()
    {
        $this->form_validation->set_rules('estatus', 'Estatus', 'required|trim');
        $this->form_validation->set_rules('comentario', 'Comentario', 'required|trim');
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $id_candidato    = $this->input->post('id_candidato');
            $id_verificacion = $this->input->post('id_verificacion');
            $id_detalle      = $this->input->post('id_detalle');
            $comentario      = $this->input->post('comentario');
            $estatus         = $this->input->post('estatus');
            $id_usuario      = $this->session->userdata('id');
            date_default_timezone_set('America/Mexico_City');
            $date   = date('Y-m-d H:i:s');
            $salida = "";
            if ($id_verificacion == 0) {
                $datos = [
                    'creacion'        => $date,
                    'edicion'         => $date,
                    'id_usuario'      => $id_usuario,
                    'id_candidato'    => $id_candidato,
                    'fecha_solicitud' => $date,
                    'status'          => $estatus,
                ];
                $nueva_verificacion = $this->candidato_model->crearEstatusEstudios($datos);
                $detalles           = [
                    'id_verificacion_estudio' => $nueva_verificacion,
                    'fecha'                   => $date,
                    'comentarios'             => $comentario,
                ];
                $this->candidato_model->guardarDetalleEstatusEstudio($detalles);
                $data['estatus'] = $this->candidato_model->checkEstatusEstudios($id_candidato);
                foreach ($data['estatus'] as $estudio) {
                    $aux             = explode('-', $estudio->fecha);
                    $fecha_estatus   = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                    $id_verificacion = $estudio->idVerificacion;
                    $estatus         = $estudio->status;
                    $salida .= '<div class="row" id="fila_estatus' . $estudio->id . '">
                                    <div class="col-3">
                                        <p class="text-center"><b>Fecha</b></p>
                                        <input type="text" class="form-control" id="fecha_estatus_estudio' . $estudio->id . '" placeholder="dd/mm/yyyy" value="' . $fecha_estatus . '">
                                    </div>
                                    <div class="col-7">
                                        <label><b>Comentario</b></label>
                                        <textarea class="form-control" id="comentario_estudio' . $estudio->id . '" rows="3">' . $estudio->comentarios . '</textarea>
                                    </div>
                                    <div class="col-2">
                                        <label><b>Acciones</b></label><br>
                                        <a href="javascript:void(0)" onclick="accionEstatusEstudio(' . $estudio->id . ',\'editar\')" class="icono_datatable"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="accionEstatusEstudio(' . $estudio->id . ',\'eliminar\')" class="icono_datatable"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div><br>';
                }
                $msj = [
                    'codigo' => 1,
                    'msg'    => $salida . '@@' . $id_verificacion . '@@' . $estatus,
                ];
            } else {
                $detalles = [
                    'id_verificacion_estudio' => $id_verificacion,
                    'fecha'                   => $date,
                    'comentarios'             => $comentario,
                ];
                $this->candidato_model->guardarDetalleEstatusEstudio($detalles);
                $data['estatus'] = $this->candidato_model->checkEstatusEstudios($id_candidato);
                foreach ($data['estatus'] as $estudio) {
                    $aux             = explode('-', $estudio->fecha);
                    $fecha_estatus   = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                    $id_verificacion = $estudio->idVerificacion;
                    $estatus         = $estudio->status;
                    $salida .= '<div class="row" id="fila_estatus' . $estudio->id . '">
                                    <div class="col-3">
                                        <p class="text-center"><b>Fecha</b></p>
                                        <input type="text" class="form-control" id="fecha_estatus_estudio' . $estudio->id . '" placeholder="dd/mm/yyyy" value="' . $fecha_estatus . '">
                                    </div>
                                    <div class="col-7">
                                        <label><b>Comentario</b></label>
                                        <textarea class="form-control" id="comentario_estudio' . $estudio->id . '" rows="3">' . $estudio->comentarios . '</textarea>
                                    </div>
                                    <div class="col-2">
                                        <label><b>Acciones</b></label><br>
                                        <a href="javascript:void(0)" onclick="accionEstatusEstudio(' . $estudio->id . ',\'editar\')" class="icono_datatable"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="accionEstatusEstudio(' . $estudio->id . ',\'eliminar\')" class="icono_datatable"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div><br>';
                }
                $msj = [
                    'codigo' => 1,
                    'msg'    => $salida . '@@' . $id_verificacion . '@@' . $estatus,
                ];
            }
        }
        echo json_encode($msj);
    }
    public function accionEstatusEstudios()
    {
        if ($this->input->post('accion') == 'editar') {
            $this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
            $this->form_validation->set_rules('comentario', 'Comentario', 'required|trim');

            $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

            $msj = [];
            if ($this->form_validation->run() == false) {
                $msj = [
                    'codigo' => 0,
                    'msg'    => validation_errors(),
                ];
            } else {
                $id_detalle = $this->input->post('id_detalle');
                $comentario = $this->input->post('comentario');
                $fecha      = fecha_espanol_bd($this->input->post('fecha'));
                $detalles   = [
                    'fecha'       => $fecha,
                    'comentarios' => $comentario,
                ];
                $this->candidato_model->editarDetalleEstatusEstudio($detalles, $id_detalle);
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'Success',
                ];
            }
        }
        if ($this->input->post('accion') == 'eliminar') {
            $id_detalle = $this->input->post('id_detalle');
            $this->candidato_model->eliminarDetalleEstatusEstudio($id_detalle);
            $msj = [
                'codigo' => 1,
                'msg'    => 'Success',
            ];
        }
        echo json_encode($msj);
    }
    public function guardarEstatusEstudios()
    {
        date_default_timezone_set('America/Mexico_City');
        $date            = date('Y-m-d H:i:s');
        $id_candidato    = $this->input->post('id_candidato');
        $id_verificacion = $this->input->post('id_verificacion');
        $id_usuario      = $this->session->userdata('id');
        $estatus         = $this->input->post('estatus');
        $datos           = [
            'edicion'      => $date,
            'id_usuario'   => $id_usuario,
            'id_candidato' => $id_candidato,
            'status'       => $estatus,
        ];
        $this->candidato_model->editarEstatusEstudios($datos, $id_verificacion);
        //$this->candidato_model->finishEstatusEstudios($id_verificacion, $date, $id_usuario);
    }

    public function checkEstatusLaborales()
    {
        $id_candidato    = $this->input->post('id_candidato');
        $salida          = "";
        $data['estatus'] = $this->candidato_model->checkEstatusLaborales($id_candidato);
        if ($data['estatus']) {
            foreach ($data['estatus'] as $lab) {
                $aux             = explode('-', $lab->fecha);
                $fecha_estatus   = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                $id_verificacion = $lab->idVerificacion;
                $estatus         = $lab->status;
                $salida .= '<div class="row" id="fila_estatus' . $lab->id . '">
                                    <div class="col-3">
                                        <p class="text-center"><b>Fecha</b></p>
                                        <input type="text" class="form-control" id="fecha_estatus_laborales' . $lab->id . '" placeholder="dd/mm/yyyy" value="' . $fecha_estatus . '">
                                    </div>
                                    <div class="col-7">
                                        <label><b>Comentario</b></label>
                                        <textarea class="form-control" id="comentario_laborales' . $lab->id . '" rows="3">' . $lab->comentarios . '</textarea>
                                    </div>
                                    <div class="col-2">
                                        <label><b>Acciones</b></label><br>
                                        <a href="javascript:void(0)" onclick="accionEstatusLaborales(' . $lab->id . ',\'editar\')" class="icono_datatable"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="accionEstatusLaborales(' . $lab->id . ',\'eliminar\')" class="icono_datatable"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div><br>';
            }
            echo $salida . '@@' . $id_verificacion . '@@' . $estatus;
        } else {
            echo $salida = 0;
        }
    }
    public function registrarEstatusLaborales()
    {
        $this->form_validation->set_rules('estatus', 'Estatus', 'required|trim');
        $this->form_validation->set_rules('comentario', 'Comentario', 'required|trim');
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $id_candidato    = $this->input->post('id_candidato');
            $id_verificacion = $this->input->post('id_verificacion');
            $id_detalle      = $this->input->post('id_detalle');
            $comentario      = $this->input->post('comentario');
            $estatus         = $this->input->post('estatus');
            $id_usuario      = $this->session->userdata('id');
            date_default_timezone_set('America/Mexico_City');
            $date   = date('Y-m-d H:i:s');
            $salida = "";
            if ($id_verificacion == 0) {
                $datos = [
                    'creacion'        => $date,
                    'edicion'         => $date,
                    'id_usuario'      => $id_usuario,
                    'id_candidato'    => $id_candidato,
                    'fecha_solicitud' => $date,
                    'status'          => $estatus,
                ];
                $nueva_verificacion = $this->candidato_model->crearEstatusLaborales($datos);
                $detalles           = [
                    'id_status_ref_laboral' => $nueva_verificacion,
                    'fecha'                 => $date,
                    'comentarios'           => $comentario,
                ];
                $this->candidato_model->guardarDetalleEstatusLaboral($detalles);
                $data['estatus'] = $this->candidato_model->checkEstatusLaborales($id_candidato);
                foreach ($data['estatus'] as $lab) {
                    $aux             = explode('-', $lab->fecha);
                    $fecha_estatus   = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                    $id_verificacion = $lab->idVerificacion;
                    $estatus         = $lab->status;
                    $salida .= '<div class="row" id="fila_estatus' . $lab->id . '">
                                    <div class="col-3">
                                        <p class="text-center"><b>Fecha</b></p>
                                        <input type="text" class="form-control" id="fecha_estatus_laborales' . $lab->id . '" placeholder="dd/mm/yyyy" value="' . $fecha_estatus . '">
                                    </div>
                                    <div class="col-7">
                                        <label><b>Comentario</b></label>
                                        <textarea class="form-control" id="comentario_laborales' . $lab->id . '" rows="3">' . $lab->comentarios . '</textarea>
                                    </div>
                                    <div class="col-2">
                                        <label><b>Acciones</b></label><br>
                                        <a href="javascript:void(0)" onclick="accionEstatusLaborales(' . $lab->id . ',\'editar\')" class="icono_datatable"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="accionEstatusLaborales(' . $lab->id . ',\'eliminar\')" class="icono_datatable"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div><br>';
                }
                $msj = [
                    'codigo' => 1,
                    'msg'    => $salida . '@@' . $id_verificacion . '@@' . $estatus,
                ];
            } else {
                $detalles = [
                    'id_status_ref_laboral' => $id_verificacion,
                    'fecha'                 => $date,
                    'comentarios'           => $comentario,
                ];
                $this->candidato_model->guardarDetalleEstatusLaboral($detalles);
                $data['estatus'] = $this->candidato_model->checkEstatusLaborales($id_candidato);
                foreach ($data['estatus'] as $lab) {
                    $aux             = explode('-', $lab->fecha);
                    $fecha_estatus   = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                    $id_verificacion = $lab->idVerificacion;
                    $estatus         = $lab->status;
                    $salida .= '<div class="row" id="fila_estatus' . $lab->id . '">
                                    <div class="col-3">
                                        <p class="text-center"><b>Fecha</b></p>
                                        <input type="text" class="form-control" id="fecha_estatus_laborales' . $lab->id . '" placeholder="dd/mm/yyyy" value="' . $fecha_estatus . '">
                                    </div>
                                    <div class="col-7">
                                        <label><b>Comentario</b></label>
                                        <textarea class="form-control" id="comentario_laborales' . $lab->id . '" rows="3">' . $lab->comentarios . '</textarea>
                                    </div>
                                    <div class="col-2">
                                        <label><b>Acciones</b></label><br>
                                        <a href="javascript:void(0)" onclick="accionEstatusLaborales(' . $lab->id . ',\'editar\')" class="icono_datatable"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="accionEstatusLaborales(' . $lab->id . ',\'eliminar\')" class="icono_datatable"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div><br>';
                }
                $msj = [
                    'codigo' => 1,
                    'msg'    => $salida . '@@' . $id_verificacion . '@@' . $estatus,
                ];
            }
        }
        echo json_encode($msj);
    }
    public function accionEstatusLaborales()
    {
        if ($this->input->post('accion') == 'editar') {
            $this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
            $this->form_validation->set_rules('comentario', 'Comentario', 'required|trim');

            $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

            $msj = [];
            if ($this->form_validation->run() == false) {
                $msj = [
                    'codigo' => 0,
                    'msg'    => validation_errors(),
                ];
            } else {
                $id_detalle = $this->input->post('id_detalle');
                $comentario = $this->input->post('comentario');
                $fecha      = fecha_espanol_bd($this->input->post('fecha'));
                $detalles   = [
                    'fecha'       => $fecha,
                    'comentarios' => $comentario,
                ];
                $this->candidato_model->editarDetalleEstatusLaboral($detalles, $id_detalle);
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'Success',
                ];
            }
        }
        if ($this->input->post('accion') == 'eliminar') {
            $id_detalle = $this->input->post('id_detalle');
            $this->candidato_model->eliminarDetalleEstatusLaboral($id_detalle);
            $msj = [
                'codigo' => 1,
                'msg'    => 'Success',
            ];
        }
        echo json_encode($msj);
    }
    public function guardarEstatusLaborales()
    {
        date_default_timezone_set('America/Mexico_City');
        $date            = date('Y-m-d H:i:s');
        $id_candidato    = $this->input->post('id_candidato');
        $id_verificacion = $this->input->post('id_verificacion');
        $id_usuario      = $this->session->userdata('id');
        $estatus         = $this->input->post('estatus');
        $datos           = [
            'edicion'      => $date,
            'id_usuario'   => $id_usuario,
            'id_candidato' => $id_candidato,
            'status'       => $estatus,
        ];
        $this->candidato_model->editarEstatusLaborales($datos, $id_verificacion);
        //$this->candidato_model->finishEstatusEstudios($id_verificacion, $date, $id_usuario);
    }

    public function checkEstatusPenales()
    {
        $id_candidato    = $this->input->post('id_candidato');
        $salida          = "";
        $data['estatus'] = $this->candidato_model->checkEstatusPenales($id_candidato);
        if ($data['estatus']) {
            foreach ($data['estatus'] as $p) {
                $aux             = explode('-', $p->fecha);
                $fecha_estatus   = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                $id_verificacion = $p->idVerificacion;
                $estatus         = $p->status;
                $salida .= '<div class="row" id="fila_estatus' . $p->id . '">
                                    <div class="col-3">
                                        <p class="text-center"><b>Fecha</b></p>
                                        <input type="text" class="form-control" id="fecha_estatus_penales' . $p->id . '" placeholder="dd/mm/yyyy" value="' . $fecha_estatus . '">
                                    </div>
                                    <div class="col-7">
                                        <label><b>Comentario</b></label>
                                        <textarea class="form-control" id="comentario_penales' . $p->id . '" rows="3">' . $p->comentarios . '</textarea>
                                    </div>
                                    <div class="col-2">
                                        <label><b>Acciones</b></label><br>
                                        <a href="javascript:void(0)" onclick="accionEstatusPenales(' . $p->id . ',\'editar\')" class="icono_datatable"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="accionEstatusPenales(' . $p->id . ',\'eliminar\')" class="icono_datatable"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div><br>';
            }
            echo $salida . '@@' . $id_verificacion . '@@' . $estatus;
        } else {
            echo $salida = 0;
        }
    }
    public function registrarEstatusPenales()
    {
        $this->form_validation->set_rules('estatus', 'Estatus', 'required|trim');
        $this->form_validation->set_rules('comentario', 'Comentario', 'required|trim');
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $id_candidato    = $this->input->post('id_candidato');
            $id_verificacion = $this->input->post('id_verificacion');
            $comentario      = $this->input->post('comentario');
            $estatus         = $this->input->post('estatus');
            $id_usuario      = $this->session->userdata('id');
            date_default_timezone_set('America/Mexico_City');
            $date   = date('Y-m-d H:i:s');
            $salida = "";
            if ($id_verificacion == 0) {
                $datos = [
                    'creacion'        => $date,
                    'edicion'         => $date,
                    'id_usuario'      => $id_usuario,
                    'id_candidato'    => $id_candidato,
                    'fecha_solicitud' => $date,
                    'status'          => $estatus,
                ];
                $nueva_verificacion = $this->candidato_model->crearEstatusPenales($datos);
                $detalles           = [
                    'id_verificacion_penales' => $nueva_verificacion,
                    'fecha'                   => $date,
                    'comentarios'             => $comentario,
                ];
                $this->candidato_model->crearDetalleEstatusPenales($detalles);

                $data['estatus'] = $this->candidato_model->checkEstatusPenales($id_candidato);
                foreach ($data['estatus'] as $p) {
                    $aux             = explode('-', $p->fecha);
                    $fecha_estatus   = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                    $id_verificacion = $p->idVerificacion;
                    $estatus         = $p->status;
                    $salida .= '<div class="row" id="fila_estatus' . $p->id . '">
                                    <div class="col-3">
                                        <p class="text-center"><b>Fecha</b></p>
                                        <input type="text" class="form-control" id="fecha_estatus_penales' . $p->id . '" placeholder="dd/mm/yyyy" value="' . $fecha_estatus . '">
                                    </div>
                                    <div class="col-7">
                                        <label><b>Comentario</b></label>
                                        <textarea class="form-control" id="comentario_penales' . $p->id . '" rows="3">' . $p->comentarios . '</textarea>
                                    </div>
                                    <div class="col-2">
                                        <label><b>Acciones</b></label><br>
                                        <a href="javascript:void(0)" onclick="accionEstatusPenales(' . $p->id . ',\'editar\')" class="icono_datatable"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="accionEstatusPenales(' . $p->id . ',\'eliminar\')" class="icono_datatable"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div><br>';
                }
                $msj = [
                    'codigo' => 1,
                    'msg'    => $salida . '@@' . $id_verificacion . '@@' . $estatus,
                ];
            } else {
                $detalles = [
                    'id_verificacion_penales' => $id_verificacion,
                    'fecha'                   => $date,
                    'comentarios'             => $comentario,
                ];
                $this->candidato_model->crearDetalleEstatusPenales($detalles);
                $data['estatus'] = $this->candidato_model->checkEstatusPenales($id_candidato);
                foreach ($data['estatus'] as $p) {
                    $aux             = explode('-', $p->fecha);
                    $fecha_estatus   = $aux[2] . '/' . $aux[1] . '/' . $aux[0];
                    $id_verificacion = $p->idVerificacion;
                    $estatus         = $p->status;
                    $salida .= '<div class="row" id="fila_estatus' . $p->id . '">
                                    <div class="col-3">
                                        <p class="text-center"><b>Fecha</b></p>
                                        <input type="text" class="form-control" id="fecha_estatus_penales' . $p->id . '" placeholder="dd/mm/yyyy" value="' . $fecha_estatus . '">
                                    </div>
                                    <div class="col-7">
                                        <label><b>Comentario</b></label>
                                        <textarea class="form-control" id="comentario_penales' . $p->id . '" rows="3">' . $p->comentarios . '</textarea>
                                    </div>
                                    <div class="col-2">
                                        <label><b>Acciones</b></label><br>
                                        <a href="javascript:void(0)" onclick="accionEstatusPenales(' . $p->id . ',\'editar\')" class="icono_datatable"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0)" onclick="accionEstatusPenales(' . $p->id . ',\'eliminar\')" class="icono_datatable"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div><br>';
                }
                $msj = [
                    'codigo' => 1,
                    'msg'    => $salida . '@@' . $id_verificacion . '@@' . $estatus,
                ];
            }
        }
        echo json_encode($msj);
    }
    public function accionEstatusPenales()
    {
        if ($this->input->post('accion') == 'editar') {
            $this->form_validation->set_rules('fecha', 'Fecha', 'required|trim');
            $this->form_validation->set_rules('comentario', 'Comentario', 'required|trim');

            $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

            $msj = [];
            if ($this->form_validation->run() == false) {
                $msj = [
                    'codigo' => 0,
                    'msg'    => validation_errors(),
                ];
            } else {
                $id_detalle = $this->input->post('id_detalle');
                $comentario = $this->input->post('comentario');
                $fecha      = fecha_espanol_bd($this->input->post('fecha'));
                $detalles   = [
                    'fecha'       => $fecha,
                    'comentarios' => $comentario,
                ];
                $this->candidato_model->editarDetalleEstatusPenales($detalles, $id_detalle);
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'Success',
                ];
            }
        }
        if ($this->input->post('accion') == 'eliminar') {
            $id_detalle = $this->input->post('id_detalle');
            $this->candidato_model->eliminarDetalleEstatusPenales($id_detalle);
            $msj = [
                'codigo' => 1,
                'msg'    => 'Success',
            ];
        }
        echo json_encode($msj);
    }
    public function guardarEstatusPenales()
    {
        date_default_timezone_set('America/Mexico_City');
        $date            = date('Y-m-d H:i:s');
        $id_candidato    = $this->input->post('id_candidato');
        $id_verificacion = $this->input->post('id_verificacion');
        $id_usuario      = $this->session->userdata('id');
        $estatus         = $this->input->post('estatus');
        $datos           = [
            'edicion'      => $date,
            'id_usuario'   => $id_usuario,
            'id_candidato' => $id_candidato,
            'status'       => $estatus,
        ];
        $this->candidato_model->editarEstatusPenales($datos, $id_verificacion);
        //$this->candidato_model->finishEstatusEstudios($id_verificacion, $date, $id_usuario);
    }
    public function getDocumentosPanelCliente()
    {
        $id_candidato = $this->input->post('id_candidato');

                                                             // Configurar la URL del endpoint
        $api_base_url = $this->config->item('api_base_url'); // Asegúrate de que esté bien configurado
        $url          = $api_base_url . 'api/verDocumentosCandidatoJson';

        // Datos a enviar
        $data = [
            'id_candidato' => $id_candidato,
        ];

        // Inicializar cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Enviar datos como JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        // Ejecutar la solicitud
        $response = curl_exec($ch);

        // Verificar errores en cURL
        if ($response === false) {
            $error_msg = curl_error($ch);
            echo json_encode(['codigo' => 0, 'msg' => 'Error en la solicitud cURL: ' . $error_msg]);
            curl_close($ch);
            return;
        }

        // Verificar el código HTTP
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_status !== 200) {
            echo json_encode(['codigo' => 0, 'msg' => 'Error en la solicitud, código HTTP: ' . $http_status]);
            return;
        }

        // Decodificar la respuesta JSON
        $response_data = json_decode($response, true);

        // Construir el HTML de salida
        $salida = '';
        if (! empty($response_data) && is_array($response_data)) {
            $salida .= '<table class="table table-striped">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th width="40%" scope="col">File name</th>';
            $salida .= '<th scope="col">Category</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';
            foreach ($response_data as $doc) {
                $salida .= '<tr id="fila' . htmlspecialchars($doc['id']) . '">';
                $salida .= '<th>
                                <a href="' . base_url('archivo/ver_doc_docs/' . rawurlencode($doc['archivo'])) . '" 
                                target="_blank" 
                                style="word-break: break-word;">
                                ' . htmlspecialchars($doc['archivo']) . '
                                </a>
                            </th>';
                $salida .= '<th>' . htmlspecialchars($doc['tipo']) . '</th>';
                $salida .= '</tr>';
            }
            $salida .= '</tbody></table>';
        } else {
            $salida = '<table class="table table-striped">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th scope="col">File name</th>';
            $salida .= '<th scope="col">Category</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';
            $salida .= '<tr>';
            $salida .= '<th class="text-center" colspan="2">No documents yet</th>';
            $salida .= '</tr>';
            $salida .= '</tbody></table>';
        }

        // Mostrar la salida
        echo $salida;
    }

    public function getDocumentosPanelClienteInterno()
    {
        $id     = $this->input->post('id_candidato');
        $origen = $this->input->post('origen');

        // Verificar si ID y origen están definidos
        if (empty($id) || empty($origen)) {
            echo json_encode(['codigo' => 0, 'msg' => 'ID o origen no proporcionado']);
            return;
        }

        // Configurar la URL del endpoint según el origen
        $api_base_url = API_URL;

        if ($origen == 1) {
            $url  = $api_base_url . "documents/" . $id;
            $path = '_documentEmpleado/';
        } elseif ($origen == 2) {
            $url  = $api_base_url . "exam/" . $id; // URL diferente para origen 2
            $path = '_examEmpleado/';
        } else {
            echo json_encode(['codigo' => 0, 'msg' => 'Origen no válido']);
            return;
        }

        // Inicializar cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        // Ejecutar la solicitud
        $response = curl_exec($ch);

        // Verificar errores en cURL
        if ($response === false) {
            $error_msg = curl_error($ch);
            echo json_encode(['codigo' => 0, 'msg' => 'Error en la solicitud cURL: ' . $error_msg]);
            curl_close($ch);
            return;
        }

        // Verificar el código HTTP
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_status !== 200) {
            echo '<table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Archivo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Fecha de carga</th>
                            <th scope="col">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="text-center" colspan="3">No documents yet</td></tr>
                    </tbody>
                </table>';
            return;
        }

        // Decodificar la respuesta JSON
        $response_data = json_decode($response, true);

        // Construir la tabla de salida
        $salida = '';
        if (! empty($response_data['documentos']) && is_array($response_data['documentos'])) {
            $salida .= '<table class="table table-striped">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th width="40%" scope="col">Archivo</th>';
            $salida .= '<th scope="col">Nombre</th>';
            $salida .= '<th scope="col">Fecha de carga</th>';
            $salida .= '<th scope="col">Eliminar</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';
            foreach (($response_data['documentos'] ?? []) as $doc) {
                $idDoc       = isset($doc['id']) ? (int) $doc['id'] : 0;
                $nameDoc     = isset($doc['nameDocument']) ? (string) $doc['nameDocument'] : '';
                $nameAlterno = isset($doc['nameAlterno']) && $doc['nameAlterno'] !== null && $doc['nameAlterno'] !== ''
                ? (string) $doc['nameAlterno'] : $nameDoc;
                $uploadDate = isset($doc['upload_date']) ? (string) $doc['upload_date'] : '';

                // URL al archivo
                if($origen == 1){ 
                $href = site_url('docs/' . rawurlencode($nameDoc));
                }elseif($origen == 2){
                $href = site_url('exams/' . rawurlencode($nameDoc));

                }
                // Args seguros para JS
                $jsId     = $idDoc;
                $jsName   = json_encode($nameDoc, JSON_UNESCAPED_UNICODE);
                $jsReqId  = isset($id) ? (int) $id : 0;
                $jsOrigen = json_encode((string) ($origen ?? ''), JSON_UNESCAPED_UNICODE);

                // ✂️ Abreviar nombre en PHP
                $maxLen         = 30;
                $displayName    = mb_strimwidth($nameAlterno, 0, $maxLen, '…', 'UTF-8');
                $maxLen         = 20; // ajusta a lo que quieras
                $displayNameDoc = mb_strimwidth($nameDoc, 0, $maxLen, '…', 'UTF-8');
                $salida .= '<tr id="fila' . html_escape((string) $idDoc) . '">';

                // 👇 Muestra abreviado pero con tooltip (nombre completo)
                $salida .= '<td><a href="' . html_escape($href) . '" target="_blank" '
                . 'title="' . html_escape($nameAlterno) . '">'
                . html_escape($displayName)
                    . '</a></td>';

                $salida .= '<td title="' . html_escape($nameDoc) . '">'
                . html_escape($displayNameDoc)
                    . '</td>';
                $salida .= '<td>' . html_escape($uploadDate) . '</td>';
                $salida .= '<td>
                    <button onclick="eliminarArchivoInterno(' . $doc["id"] . ', \'' . $doc["nameDocument"] . '\', ' . $id . ', \'' . $origen . '\')"
                            class="btn btn-link text-danger p-0" title="Eliminar">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>';

                $salida .= '</tr>';
            }

            $salida .= '</tbody></table>';
        } else {
            $salida = '<table class="table table-striped">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th scope="col">File name</th>';
            $salida .= '<th scope="col">Category</th>';
            $salida .= '<th scope="col">Upload Date</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';
            $salida .= '<tr>';
            $salida .= '<td class="text-center" colspan="3">No documents yet</td>';
            $salida .= '</tr>';
            $salida .= '</tbody></table>';
        }

        // Mostrar la salida
        echo $salida;
    }

    public function downloadDocumentosPanelCliente()
    {
        if (isset($_POST['idCandidatoDocs'])) {
            $id_candidato = $_POST['idCandidatoDocs'];
            $this->load->library('zip');
            $documentos = $this->candidato_model->getDocumentacion($id_candidato);
            //if($documentos){
            foreach ($documentos as $doc) {
                if ($doc->id_tipo_documento == 3 || $doc->id_tipo_documento == 8 || $doc->id_tipo_documento == 9 || $doc->id_tipo_documento == 14 || $doc->id_tipo_documento == 45) {
                    $this->zip->read_file('_docs/' . $doc->archivo);
                }

            }
            $this->zip->download(time() . '.zip');

        }
    }

    public function getDocumentos()
    {
        $id_candidato           = $this->input->post('id_candidato');
        $data['docs_candidato'] = $this->candidato_model->getDocumentacionCandidato($id_candidato);
        $salida                 = '';
        if ($data['docs_candidato']) {
            $salida .= '<table class="table table-striped">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th width="40%" scope="col">Nombre archivo</th>';
            $salida .= '<th scope="col">Tipo archivo</th>';
            $salida .= '<th scope="col">Acción</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';
            foreach ($data['docs_candidato'] as $doc) {
                $salida .= '<tr id="fila' . $doc->id . '">';
                $salida .= '<th>
                                <a href="' . base_url('archivo/ver_doc_docs/' . rawurlencode($doc['archivo'])) . '" 
                                target="_blank" 
                                style="word-break: break-word;">
                                ' . htmlspecialchars($doc['archivo']) . '
                                </a>
                            </th>';
                $salida .= '<th>' . $doc->tipo . '</th>';
                $salida .= '<th><a href="javascript:void(0);"  data-toggle="tooltip" title="Eliminar documento" class="fa-tooltip icono_datatable" onclick="eliminarArchivo(' . $doc->id . ',\'' . $doc->archivo . '\',' . $id_candidato . ')"><i class="fas fa-trash"></i></a></th>';

            }
            $salida .= '</tr></tbody></table>';
        } else {
            $salida = '<table class="table table-striped">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th scope="col">Nombre archivo</th>';
            $salida .= '<th scope="col">Tipo archivo</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';
            $salida .= '<tr>';
            $salida .= '<th class="text-center" colspan="2">Sin documentos subidos</th>';
            $salida .= '</tr>';
            $salida .= '</tbody>';
            $salida .= '</table>';
        }

        echo $salida;
    }

    public function getDocumentosPanelClienteInterno1()
    {
        $id     = $this->input->post('id_candidato');
        $origen = $this->input->post('origen');

        // Verificar si ID y origen están definidos
        if (empty($id) || empty($origen)) {
            echo json_encode(['codigo' => 0, 'msg' => 'ID o origen no proporcionado']);
            return;
        }

        // Configurar la URL del endpoint según el origen
        $api_base_url = API_URL;

        if ($origen == 1) {
            $url  = $api_base_url . "documents/" . $id;
            $path = '_documentEmpleado/';
        } elseif ($origen == 2) {
            $url  = $api_base_url . "exam/" . $id; // URL diferente para origen 2
            $path = '_examEmpleado/';
        } else {
            echo json_encode(['codigo' => 0, 'msg' => 'Origen no válido']);
            return;
        }

        // Inicializar cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        // Ejecutar la solicitud
        $response = curl_exec($ch);

        // Verificar errores en cURL
        if ($response === false) {
            $error_msg = curl_error($ch);
            echo json_encode(['codigo' => 0, 'msg' => 'Error en la solicitud cURL: ' . $error_msg]);
            curl_close($ch);
            return;
        }

        // Verificar el código HTTP
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_status !== 200) {
            echo '<table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Archivo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Fecha de carga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="text-center" colspan="3">No documents yet</td></tr>
                    </tbody>
                </table>';
            return;
        }

        // Decodificar la respuesta JSON
        $response_data = json_decode($response, true);

        // Construir la tabla de salida
        $salida = '';
        if (! empty($response_data['documentos']) && is_array($response_data['documentos'])) {
            $salida .= '<table class="table table-striped">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th width="40%" scope="col">Archivo</th>';
            $salida .= '<th scope="col">Nombre</th>';
            $salida .= '<th scope="col">Fecha de carga</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';

            foreach ($response_data['documentos'] as $doc) {
                $salida .= '<tr id="fila' . htmlspecialchars($doc['id']) . '">';

                // Archivo real (nameDocument)
                $salida .= '<td><a href="' . base_url($path . htmlspecialchars($doc['nameDocument'] ?? '')) . '" target="_blank" style="word-break: break-word;">' . htmlspecialchars($doc['nameAlterno'] ?? '') . '</a></td>';

                // Categoría o tipo de documento
                $salida .= '<td>' . htmlspecialchars($doc['nameDocument'] ?? '') . '</td>';

                // Fecha de carga
                $salida .= '<td>' . htmlspecialchars($doc['upload_date'] ?? '') . '</td>';

                // Botón eliminar

                $salida .= '</tr>';
            }

            $salida .= '</tbody></table>';
        } else {
            $salida = '<table class="table table-striped">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th scope="col">File name</th>';
            $salida .= '<th scope="col">Category</th>';
            $salida .= '<th scope="col">Upload Date</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';
            $salida .= '<tr>';
            $salida .= '<td class="text-center" colspan="3">No documents yet</td>';
            $salida .= '</tr>';
            $salida .= '</tbody></table>';
        }

        // Mostrar la salida
        echo $salida;
    }

    public function downloadDocumentosPanelCliente1()
    {
        if (isset($_POST['idCandidatoDocs'])) {
            $id_candidato = $_POST['idCandidatoDocs'];
            $this->load->library('zip');
            $documentos = $this->candidato_model->getDocumentacion($id_candidato);
            //if($documentos){
            foreach ($documentos as $doc) {
                if ($doc->id_tipo_documento == 3 || $doc->id_tipo_documento == 8 || $doc->id_tipo_documento == 9 || $doc->id_tipo_documento == 14 || $doc->id_tipo_documento == 45) {
                    $this->zip->read_file('_docs/' . $doc->archivo);
                }

            }
            $this->zip->download(time() . '.zip');

        }
    }

    public function getDocumentos1()
    {
        $id_candidato           = $this->input->post('id_candidato');
        $data['docs_candidato'] = $this->candidato_model->getDocumentacionCandidato($id_candidato);
        $salida                 = '';
        if ($data['docs_candidato']) {
            $salida .= '<table class="table table-striped">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th width="40%" scope="col">Nombre archivo</th>';
            $salida .= '<th scope="col">Tipo archivo</th>';
            $salida .= '<th scope="col">Acción</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';
            foreach ($data['docs_candidato'] as $doc) {
                $salida .= '<tr id="fila' . $doc->id . '">';
                $salida .= '<th><a href="' . base_url() . '_docs/' . $doc->archivo . '" target="_blank" style="word-break: break-word;">' . $doc->archivo . '</a></th>';
                $salida .= '<th>' . $doc->tipo . '</th>';
                $salida .= '<th><a href="javascript:void(0);"  data-toggle="tooltip" title="Eliminar documento" class="fa-tooltip icono_datatable" onclick="eliminarArchivo(' . $doc->id . ',\'' . $doc->archivo . '\',' . $id_candidato . ')"><i class="fas fa-trash"></i></a></th>';

            }
            $salida .= '</tr></tbody></table>';
        } else {
            $salida = '<table class="table table-striped">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th scope="col">Nombre archivo</th>';
            $salida .= '<th scope="col">Tipo archivo</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';
            $salida .= '<tr>';
            $salida .= '<th class="text-center" colspan="2">Sin documentos subidos</th>';
            $salida .= '</tr>';
            $salida .= '</tbody>';
            $salida .= '</table>';
        }

        echo $salida;
    }

    /* cargar  documento  pre empleo viejo
    function cargarDocumento(){
    if (isset($_FILES["documento"]["name"])) {
    $this->form_validation->set_rules('tipo_doc', 'Tipo de archivo', 'required');
    $this->form_validation->set_message('required','El campo {field} es obligatorio');
    if ($this->form_validation->run() == FALSE) {
    $msj = array(
    'codigo' => 0,
    'msg' => validation_errors()
    );
    echo json_encode($msj);
    }
    else{
    $this->form_validation->set_rules('documento', 'Documento', 'callback_file_check');
    if ($this->form_validation->run() == true) {
    date_default_timezone_set('America/Mexico_City');
    $date = date('Y-m-d H:i:s');
    $id_candidato = $this->input->post('id_candidato');
    $tipo_doc = $this->input->post('tipo_doc');
    $prefijo = $this->input->post('prefijo');
    $prefijo = str_replace(' ','',$prefijo);
    $salida = "";
    $archivos = array();
    $config['upload_path'] = './_docs/';
    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
    $config['max_size'] = '2048'; // max_size in kb
    $config['overwrite'] = TRUE;
    //$aux2 = str_replace(' ', '', $_FILES['documento']['name']);
    //$nombre_archivo = str_replace('_', '', $aux2);
    //Checa si hay mas archivos dle mismo tipo para nombrarlos diferente
    $cadena = substr(md5(time()), 0, 16);
    //$tipo = $this->candidato_model->getTipoDoc($tipo_doc);
    //$tipoArchivo = str_replace(' ','',$tipo->nombre);
    $extension = pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);
    $config['file_name'] = $id_candidato.'_'.$cadena.'.'.$extension;
    $nombre_archivo = $id_candidato.'_'.$cadena.'.'.$extension;
    $documento = array(
    'creacion' => $date,
    'edicion' => $date,
    'id_candidato' => $id_candidato,
    'id_tipo_documento' => $tipo_doc,
    'archivo' => $nombre_archivo
    );
    $this->candidato_model->registrarDocumento($documento);

    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    if($this->upload->do_upload('documento')){
    //$data = $this->upload->data();
    $salida .= '<table class="table table-striped">';
    $salida .= '<thead>';
    $salida .= '<tr>';
    $salida .= '<th width="40%" scope="col">Nombre archivo</th>';
    $salida .= '<th scope="col">Tipo archivo</th>';
    $salida .= '<th scope="col">Acción</th>';
    $salida .= '</tr>';
    $salida .= '</thead>';
    $salida .= '<tbody>';
    $data['docs_candidato'] = $this->candidato_model->getDocumentacionCandidato($id_candidato);
    foreach($data['docs_candidato'] as $doc){
    $salida .= '<tr id="fila'.$doc->id.'">';
    $salida .= '<th><a href="'.base_url().'_docs/'.$doc->archivo.'" target="_blank" style="word-break: break-word;">'.$doc->archivo.'</a></th>';
    $salida .= '<th>'.$doc->tipo.'</th>';
    $salida .= '<th><a href="javascript:void(0);"  data-toggle="tooltip" title="Eliminar documento" class="fa-tooltip icono_datatable" onclick="eliminarArchivo('.$doc->id.',\''.$doc->archivo.'\','.$id_candidato.')"><i class="fas fa-trash"></i></a></th>';

    }
    $salida .= '</tr></tbody></table>';
    $msj = array(
    'codigo' => 1,
    'msg' => $salida
    );
    //Checar porcentaje avance
    /*$c = $this->candidato_model->getClienteCandidato($id_candidato);
    if($c->id_cliente == 1){
    if($tipo_doc == 8 || $tipo_doc == 11){//Si los archivos son aviso de privacidad u OFAC
    $this->generarAvancesUST($id_candidato);
    }
    }* /
    }
    else{
    $msj = array(
    'codigo' => 0,
    'msg' => 'Error al subir el documento'
    );
    }
    echo json_encode($msj);
    }
    else{
    $msj = array(
    'codigo' => 0,
    'msg' => validation_errors()
    );
    echo json_encode($msj);
    }
    }
    }
    else{
    $msj = array(
    'codigo' => 0,
    'msg' => 'Elija una imagen del documento a subir'
    );
    echo json_encode($msj);
    }
    }

     */
    public function cargarDocumento()
    {
        if (isset($_FILES["documento"]["name"])) {
            // Depuración: Imprimir datos del archivo recibido

            // Validación de los campos requeridos
            $this->form_validation->set_rules('tipo_doc', 'Tipo de archivo', 'required');
            $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

            if ($this->form_validation->run() == false) {
                $msj = [
                    'codigo' => 0,
                    'msg'    => validation_errors(),
                ];
                echo json_encode($msj);
            } else {
                // Validación del archivo
                $this->form_validation->set_rules('documento', 'Documento', 'callback_file_check');

                if ($this->form_validation->run() == true) {
                    date_default_timezone_set('America/Mexico_City');
                    $date         = date('Y-m-d H:i:s');
                    $id_candidato = $this->input->post('id_candidato');

                    $tipo_doc = $this->input->post('tipo_doc');

                    $prefijo                 = $this->input->post('prefijo');
                    $prefijo                 = str_replace(' ', '', $prefijo);
                    $config['upload_path']   = './_docs/';
                    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                    $config['max_size']      = '2048'; // max_size in kb
                    $config['overwrite']     = true;
                    // Configuración para el nombre del archivo
                    $cadena         = substr(md5(time()), 0, 16);
                    $extension      = pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);
                    $nombre_archivo = $id_candidato . '_' . $cadena . '.' . $extension;

                                                                           // Configuración de cURL para enviar la solicitud POST al endpoint externo
                    $api_base_url = $this->config->item('api_base_url');   // Asegúrate de que esté bien configurado
                    $url          = $api_base_url . 'api/cargarDocumento'; // Verifica que la URL sea correcta
                    $fileContent  = file_get_contents($_FILES['documento']['tmp_name']);
                    $fileBase64   = base64_encode($fileContent);

                    // Preparar los datos para enviar, incluyendo el archivo en Base64
                    $postData = [
                        'creacion'          => $date,
                        'edicion'           => $date,
                        'id_candidato'      => $id_candidato,
                        'id_tipo_documento' => $tipo_doc,
                        'documento'         => [
                            'nombre'    => $nombre_archivo,
                            'contenido' => $fileBase64,
                        ],
                    ];

                    // Inicializar cURL para enviar los datos
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData)); // Enviar como JSON
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Accept: application/json',
                        'Content-Type: application/json', // Asegúrate de enviar los datos como JSON
                    ]);

                    $response   = curl_exec($ch);
                    $http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $curl_error = curl_error($ch);
                    curl_close($ch);

                    // Depuración: Verificar respuesta de cURL
                    // log_message('info', 'Respuesta de cURL: ' . $response);
                    // log_message('info', 'Código HTTP: ' . $http_code);
                    // log_message('info', 'Error cURL: ' . $curl_error);

                    // Manejar la respuesta del endpoint externo
                    if ($response === false) {
                        $msj = [
                            'codigo'  => 0,
                            'message' => 'Error en la solicitud cURL: ' . $curl_error,
                        ];
                    } else {
                        if ($http_code == 200) {
                            $response = json_decode($response, true);
                            if (isset($response['codigo']) && $response['codigo'] == 1) {
                                // Construir la tabla HTML con los documentos actualizados
                                //$this.getDocumentosPanelCliente();

                                $msj = [
                                    'codigo'  => 1,
                                    'message' => $response['message'],
                                ];
                            } else {
                                $msj = [
                                    'codigo'  => 0,
                                    'message' => isset($response_data['message']) ? $response_data['message'] : 'Error desconocido en el registro del documento.',
                                ];
                            }
                        } else {
                            $msj = [
                                'codigo'  => 0,
                                'message' => 'Error en la solicitud, código HTTP: ' . $http_code,
                            ];
                        }
                    }

                    echo json_encode($msj);
                } else {
                    $msj = [
                        'codigo' => 0,
                        'msg'    => validation_errors(),
                    ];
                    echo json_encode($msj);
                }
            }
        } else {
            $msj = [
                'codigo' => 0,
                'msg'    => 'Elija una imagen del documento a subir',
            ];
            echo json_encode($msj);
        }
    }

    public function cargarDocumentoPanelCliente()
    {
        if (isset($_FILES["documento"]["name"])) {
            $this->form_validation->set_rules('tipo_doc', 'Tipo de archivo', 'required');
            $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
            if ($this->form_validation->run() == false) {
                $msj = [
                    'codigo' => 0,
                    'msg'    => validation_errors(),
                ];
                echo json_encode($msj);
            } else {
                $this->form_validation->set_rules('documento', 'Documento', 'callback_file_check');
                if ($this->form_validation->run() == true) {
                    date_default_timezone_set('America/Mexico_City');
                    $date                    = date('Y-m-d H:i:s');
                    $id_candidato            = $this->input->post('id_candidato');
                    $tipo_doc                = $this->input->post('tipo_doc');
                    $salida                  = "";
                    $archivos                = [];
                    $config['upload_path']   = './_docs/';
                    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                    $config['max_size']      = '2048'; // max_size in kb
                    $config['overwrite']     = true;
                    //Checa si hay mas archivos dle mismo tipo para nombrarlos diferente
                    $cadena              = substr(md5(time()), 0, 16);
                    $extension           = pathinfo($_FILES['documento']['name'], PATHINFO_EXTENSION);
                    $config['file_name'] = $id_candidato . '_' . $cadena . '.' . $extension;
                    $nombre_archivo      = $id_candidato . '_' . $cadena . '.' . $extension;
                    $documento           = [
                        'creacion'          => $date,
                        'edicion'           => $date,
                        'id_candidato'      => $id_candidato,
                        'id_tipo_documento' => $tipo_doc,
                        'archivo'           => $nombre_archivo,
                    ];
                    $this->candidato_model->registrarDocumento($documento);

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('documento')) {
                        //$data = $this->upload->data();
                        $salida .= '<table class="table table-striped">';
                        $salida .= '<thead>';
                        $salida .= '<tr>';
                        $salida .= '<th width="40%" scope="col">Nombre archivo</th>';
                        $salida .= '<th scope="col">Tipo archivo</th>';
                        $salida .= '</tr>';
                        $salida .= '</thead>';
                        $salida .= '<tbody>';
                        $data['docs_candidato'] = $this->candidato_model->getDocumentacionCandidato($id_candidato);
                        foreach ($data['docs_candidato'] as $doc) {
                            $salida .= '<tr id="fila' . $doc->id . '">';
                            $salida .= '<th><a href="' . base_url() . '_docs/' . $doc->archivo . '" target="_blank" style="word-break: break-word;">' . $doc->archivo . '</a></th>';
                            $salida .= '<th>' . $doc->tipo . '</th>';
                        }
                        $salida .= '</tr></tbody></table>';
                        $msj = [
                            'codigo' => 1,
                            'msg'    => $salida,
                        ];
                    } else {
                        $msj = [
                            'codigo' => 0,
                            'msg'    => 'Error al subir el documento',
                        ];
                    }
                    echo json_encode($msj);
                } else {
                    $msj = [
                        'codigo' => 0,
                        'msg'    => validation_errors(),
                    ];
                    echo json_encode($msj);
                }
            }
        } else {
            $msj = [
                'codigo' => 0,
                'msg'    => 'Elija una imagen del documento a subir',
            ];
            echo json_encode($msj);
        }
    }
    public function eliminarDocumento()
    {
        $id           = $this->input->post('idDoc');
        $archivo      = $this->input->post('archivo');
        $id_candidato = $this->input->post('id_candidato');
        $existe       = 0;
        if ($id !== null && $archivo !== null) {
            $aux = directory_map('./_docs/');
            for ($i = 0; $i < count($aux); $i++) {
                $indice = explode('_', $aux[$i]);
                if ($indice[0] === $id_candidato) {
                    $existe++;
                    break;
                }
            }
            if ($existe == 1) {
                unlink('./_docs/' . $archivo);
                $this->candidato_model->eliminarDocCandidato($id);
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'success',
                ];
            } else {
                $this->candidato_model->eliminarDocCandidato($id);
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'success',
                ];
            }
        } else {
            $msj = [
                'codigo' => 0,
                'msg'    => 'error',
            ];
        }
        echo json_encode($msj);
    }
    // funcion para   el area  de pre empleo
    public function eliminarDocumentoInterno()
    {
        $id           = $this->input->post('idDoc');
        $archivo      = $this->input->post('archivo');
        $id_candidato = $this->input->post('id_candidato');
        $origen       = $this->input->post('origen');

        // Determinar el directorio según el origen
        $directorio = '';
        if ($origen == 1) {
            $directorio = './_documentEmpleado/';
            $tabla      = 'documents_empleado';
        } elseif ($origen == 2) {
            $directorio = './_examEmpleado/';
            $tabla      = 'exams_empleados';
        } else {
            $directorio = './_docs/'; // Directorio por defecto
        }

        $existe = 0;
        if ($id !== null && $archivo !== null) {
            // Obtener lista de archivos en el directorio seleccionado
            $aux = directory_map($directorio);

            for ($i = 0; $i < count($aux); $i++) {
                $indice = explode('_', $aux[$i]);
                if ($indice[0] === $id_candidato) {
                    $existe++;
                    break;
                }
            }

            if ($existe == 1) {
                // Verificar si el archivo existe antes de eliminarlo
                $rutaArchivo = $directorio . $archivo;
                if (file_exists($rutaArchivo)) {
                    unlink($rutaArchivo);
                }

                // Eliminar el registro en la base de datos
                $this->candidato_model->eliminarDocCandidatoInterno($id, $tabla);
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'success',
                ];
            } else {
                // Eliminar el registro de la base de datos, aunque el archivo no exista
                $this->candidato_model->eliminarDocCandidatoInterno($id, $tabla);
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'success',
                ];
            }
        } else {
            $msj = [
                'codigo' => 0,
                'msg'    => 'error',
            ];
        }

        echo json_encode($msj);
    }

    public function eliminarCandidatoInterno()
    {
        $idCandidato = $this->input->post('id');

        if (! $idCandidato) {
            echo json_encode(['codigo' => 0, 'mensaje' => 'ID de candidato no recibido']);
            return;
        }

        $this->load->database();

        // 1️⃣ Buscar y eliminar documentos del candidato
        $documentos = $this->db->get_where('documents_empleado', ['employee_id' => $idCandidato])->result();

        foreach ($documentos as $doc) {
            $rutaArchivo = './_documentsEmpleado/' . $doc->name;
            if (file_exists($rutaArchivo)) {
                unlink($rutaArchivo);
            }
        }

        // Eliminar registros de documentos en la base de datos
        $this->db->delete('documents_empleado', ['employee_id' => $idCandidato]);

        // 2️⃣ Buscar y eliminar exámenes del candidato
        $examenes = $this->db->get_where('exams_empleados', ['employee_id' => $idCandidato])->result();

        foreach ($examenes as $exam) {
            $ext = pathinfo($exam->name, PATHINFO_EXTENSION);
            if (in_array(strtolower($ext), ['jpg', 'png', 'jpeg', 'pdf'])) {
                $rutaArchivo = './_examEmpleado/' . $exam->name;
                if (file_exists($rutaArchivo)) {
                    unlink($rutaArchivo);
                }
            }
        }

        // Eliminar registros de exámenes en la base de datos
        $this->db->delete('exams_empleados', ['employee_id' => $idCandidato]);

        // 3️⃣ Eliminar candidato de la tabla empleados
        $this->db->delete('empleados', ['id' => $idCandidato]);

        echo json_encode(['codigo' => 1, 'mensaje' => 'Candidato eliminado correctamente']);
    }

    public function eliminarReferenciaLaboral()
    {
        $id              = $this->input->post('id');
        $id_verificacion = $this->input->post('id_verificacion');
        $id_candidato    = $this->input->post('id_candidato');
        $num             = $this->input->post('num');
        $this->candidato_model->eliminarReferenciaLaboral($id);
        $this->candidato_model->eliminarVerificacionLaboralPorID($id_verificacion);
        $this->candidato_model->ordenarVerificacionesLaborales($id_candidato, $num);
        $msj = [
            'codigo' => 1,
            'msg'    => 'success',
        ];
        echo json_encode($msj);
    }
    public function checkAvances()
    {
        $id_candidato = $_POST['id_candidato'];
        $id_rol       = $this->session->userdata('idrol');
        $salida       = "";
        $salida .= '<table class="table table-striped" style="font-size: 14px">';
        $salida .= '<tr style="background: gray;color:white;">';
        $salida .= '<th>Fecha</th>';
        $salida .= '<th>Avances o Estatus</th>';
        $salida .= '<th>Imagen de apoyo</th>';
        $salida .= '<th>Acciones</th>';
        $salida .= '</tr>';
        $data['avances'] = $this->candidato_model->checkAvances($id_candidato, $id_rol);
        if ($data['avances']) {
            foreach ($data['avances'] as $l) {
                $id_rol_avance = '';
                if ($l->id_rol == 2 || $l->id_rol == 9) {
                    $id_rol_avance = 'BGV';
                } elseif ($l->id_rol == 7) {
                    $id_rol_avance = 'Drug Test';
                }
                $parte         = explode(' ', $l->fecha);
                $aux           = explode('-', $parte[0]);
                $h             = explode(':', $parte[1]);
                $fecha_estatus = $aux[2] . '/' . $aux[1] . '/' . $aux[0] . ' ' . $h[0] . ':' . $h[1];
                $imagen        = ($l->adjunto != "") ? "<a href='" . base_url() . "_adjuntos/" . $l->adjunto . "' target='_blank'>Ver imagen</a>" : "NA";
                $salida .= "<tr>";
                $salida .= '<td width="10%">' . $fecha_estatus . '<br>' . $id_rol_avance . '</td>';
                if ($this->session->userdata('idrol') == 1 || $this->session->userdata('idrol') == 2 || $this->session->userdata('idrol') == 6 || $this->session->userdata('idrol') == 7 || $this->session->userdata('idrol') == 9) {
                    $salida .= '<td width="45%"><textarea class="form-control" rows="4" id="avanceMensaje' . $l->id . '">' . $l->comentarios . '</textarea><br><input type="file" id="avanceArchivo' . $l->id . '" name="adjunto" class="form-control" accept=".jpg, .jpeg, .png"></td>';
                    $salida .= '<td width="10%" id="avanceVerImagen' . $l->id . '">' . $imagen . '</td>';
                    $salida .= '<td width="10%"><a href="javascript:void(0)" data-toggle="tooltip" title="Guardar modificacion" class="btn btn-success btn-sm" onclick="confirmarEditarAvance(' . $l->id . ')"><i class="fas fa-save"></i></a> <a href="javascript:void(0)" data-toggle="tooltip" title="Eliminar" id="eliminar" class="btn btn-danger btn-sm" onclick="confirmarEliminarAvance(' . $l->id . ')"><i class="fas fa-trash"></i></a></td>';
                } else {
                    $salida .= '<td width="45%">' . $l->comentarios . '</td>';
                    $salida .= '<td width="10%" id="avanceVerImagen' . $l->id . '">' . $imagen . '</td>';
                    $salida .= '<td width="10%">NA</td>';
                }
                $salida .= "</tr>";
            }
            $salida .= "</table>";
            echo $salida;
        } else {
            $salida .= "<tr>";
            $salida .= '<td colspan="4" class="text-center"><h5>No hay mensajes</h5></td>';
            $salida .= "</tr>";
            $salida .= "</table>";
            echo $salida;
        }
    }
    public function createEstatusAvance()
    {
        $this->form_validation->set_rules('comentario', 'Comentario', 'required|trim');
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $id_candidato   = $this->input->post('id_candidato');
            $comentario     = $this->input->post('comentario');
            $id_usuario     = $this->session->userdata('id');
            $nombre_archivo = '';
            $date           = date('Y-m-d H:i:s');
            $nombre_archivo = "";
            if (isset($_FILES['adjunto']['name'])) {
                $extension               = pathinfo($_FILES['adjunto']['name'], PATHINFO_EXTENSION);
                $cadena                  = substr(md5(time()), 0, 16);
                $nombre_archivo          = $cadena . "." . $extension;
                $config['upload_path']   = './_adjuntos/';
                $config['allowed_types'] = 'jpg|jpeg|png';
                $config['overwrite']     = true;
                $config['file_name']     = $nombre_archivo;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $this->upload->do_upload('adjunto');
            }
            $nuevoAvance = [
                'creacion'        => $date,
                'edicion'         => $date,
                'id_usuario'      => $id_usuario,
                'id_candidato'    => $id_candidato,
                'fecha_solicitud' => $date,
            ];
            $id_avance     = $this->candidato_model->createEstatusAvance($nuevoAvance);
            $avanceDetalle = [
                'id_avance'   => $id_avance,
                'fecha'       => $date,
                'comentarios' => $comentario,
                'adjunto'     => $nombre_archivo,
            ];
            $this->candidato_model->createDetalleEstatusAvance($avanceDetalle);
            $msj = [
                'codigo' => 1,
                'msg'    => 'Mensaje registrado correctamente',
            ];
        }
        echo json_encode($msj);
    }
    public function verComentarioCandidato()
    {
        $id_candidato = $_POST['id_candidato'];
        $res          = $this->candidato_model->getComentario($id_candidato);
        if ($res != "" && $res != null) {
            echo $res->comentario;
        } else {
            echo $res = 0;
        }
    }
    public function checkDocumentos()
    {
        $id_candidato      = $_POST['id_candidato'];
        $salida            = "";
        $data['documents'] = $this->candidato_model->checkDocumentos($id_candidato);
        if ($data['documents']) {
            foreach ($data['documents'] as $d) {
                $salida .= $d->id_tipo_documento . "," . $d->archivo . "@@";
            }
            echo $salida;
        } else {
            $salida = 0;
        }
    }

    public function registrarInfoVisitador()
    {
        $this->form_validation->set_rules('comentario_visitador', 'Comentarios del visitador', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');
        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date         = date('Y-m-d H:i:s');
            $id_candidato = $this->input->post('id_candidato');
            $id_usuario   = $this->session->userdata('id');
            if ($this->input->post('personas') != "" && $this->input->post('personas') != null) {
                $data_personas = "";
                $h             = explode("@@", $this->input->post('personas'));
                for ($i = 0; $i < (count($h) - 1); $i++) {
                    $aux           = explode(",,", $h[$i]);
                    $data_personas = [
                        'creacion'           => $date,
                        'edicion'            => $date,
                        'id_candidato'       => $id_candidato,
                        'nombre'             => urldecode($aux[0]),
                        'id_tipo_parentesco' => $aux[1],
                        'edad'               => $aux[2],
                        'id_grado_estudio'   => $aux[3],
                        'misma_vivienda'     => $aux[4],
                        'estado_civil'       => $aux[5],
                        'empresa'            => urldecode($aux[6]),
                        'puesto'             => urldecode($aux[7]),
                        'antiguedad'         => urldecode(($aux[8])),
                        'sueldo'             => $aux[9],
                        'monto_aporta'       => $aux[10],
                        'muebles'            => urldecode($aux[11]),
                        'adeudo'             => $aux[12],
                    ];
                    $this->candidato_model->guardarFamiliar($data_personas);
                }
            }
            $candidato = [
                'edicion'   => $date,
                'visitador' => 1,
            ];
            $this->candidato_model->editarCandidato($candidato, $id_candidato);

            //* Registro de notificacion de visita finalizada
            $datosUsuario  = $this->usuario_model->getDatosUsuario($id_usuario);
            $tieneVisita   = $this->visita_model->get_by_candidato($id_candidato);
            $rolesUsuarios = $this->usuario_model->get_usuarios_by_rol([1, 2, 4, 6, 9, 10, 11]);
            if (! empty($tieneVisita)) {
                $visita = [
                    'edicion'     => $date,
                    'id_usuario'  => $id_usuario,
                    'fecha_final' => $date,
                    'comentarios' => $this->input->post('comentario_visitador'),
                ];
                $this->candidato_model->editarDatosVisita($visita, $id_candidato);
            } else {
                $visita = [
                    'creacion'     => $date,
                    'edicion'      => $date,
                    'id_usuario'   => $id_usuario,
                    'id_candidato' => $id_candidato,
                    'comentarios'  => $this->input->post('comentario_visitador'),
                ];
                $this->candidato_model->crearVisita($visita);
            }
            foreach ($rolesUsuarios as $row) {
                $rolesObjetivos[] = $row->id;
            }
            $titulo  = 'Visita registrada';
            $mensaje = 'Se ha registrado la visita del candidato ' . $tieneVisita->candidato . ', realizada por: ' . $datosUsuario->nombre . ' ' . $datosUsuario->paterno;
            $this->registrar_notificacion($rolesObjetivos, $titulo, $mensaje);

            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function registrarInfoVisitadorAlterno()
    {
        $this->form_validation->set_rules('comentario_visitador', 'Comentarios del visitador', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');
        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date         = date('Y-m-d H:i:s');
            $id_candidato = $this->input->post('id_candidato');
            $id_usuario   = $this->session->userdata('id');

            $candidato = [
                'edicion'   => $date,
                'visitador' => 1,
            ];
            $this->candidato_model->editarCandidato($candidato, $id_candidato);

            //* Registro de notificacion de visita finalizada
            $datosUsuario  = $this->usuario_model->getDatosUsuario($id_usuario);
            $tieneVisita   = $this->visita_model->get_by_candidato($id_candidato);
            $rolesUsuarios = $this->usuario_model->get_usuarios_by_rol([1, 2, 4, 6, 9, 10, 11]);
            if (! empty($tieneVisita)) {
                $visita = [
                    'edicion'     => $date,
                    'id_usuario'  => $id_usuario,
                    'fecha_final' => $date,
                    'comentarios' => $this->input->post('comentario_visitador'),
                ];
                $this->candidato_model->editarDatosVisita($visita, $id_candidato);
            } else {
                $visita = [
                    'creacion'     => $date,
                    'edicion'      => $date,
                    'id_usuario'   => $id_usuario,
                    'id_candidato' => $id_candidato,
                    'comentarios'  => $this->input->post('comentario_visitador'),
                ];
                $this->candidato_model->crearVisita($visita);
            }
            foreach ($rolesUsuarios as $row) {
                $rolesObjetivos[] = $row->id;
            }
            $titulo  = 'Visita registrada';
            $mensaje = 'Se ha registrado la visita del candidato ' . $tieneVisita->candidato . ', realizada por: ' . $datosUsuario->nombre . ' ' . $datosUsuario->paterno;
            $this->registrar_notificacion($rolesObjetivos, $titulo, $mensaje);

            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function registrarGrupoFamiliar()
    {
        date_default_timezone_set('America/Mexico_City');
        $date         = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $id_usuario   = $this->session->userdata('id');
        if ($this->input->post('personas') != "" && $this->input->post('personas') != null) {
            $this->candidato_model->cleanFamiliaresCandidato($id_candidato);
            $data_personas = "";
            $h             = explode("@@", $this->input->post('personas'));
            for ($i = 0; $i < (count($h) - 1); $i++) {
                $aux           = explode(",,", $h[$i]);
                $data_personas = [
                    'creacion'           => $date,
                    'edicion'            => $date,
                    'id_candidato'       => $id_candidato,
                    'nombre'             => urldecode($aux[0]),
                    'id_tipo_parentesco' => $aux[1],
                    'edad'               => $aux[2],
                    'id_grado_estudio'   => $aux[3],
                    'misma_vivienda'     => $aux[4],
                    'estado_civil'       => $aux[5],
                    'empresa'            => urldecode($aux[6]),
                    'puesto'             => urldecode($aux[7]),
                    'antiguedad'         => urldecode(($aux[8])),
                    'sueldo'             => $aux[9],
                    'monto_aporta'       => $aux[10],
                    'muebles'            => urldecode($aux[11]),
                    'adeudo'             => $aux[12],
                ];
                $this->candidato_model->guardarFamiliar($data_personas);
            }
        }
        $msj = [
            'codigo' => 1,
            'msg'    => 'success',
        ];
        echo json_encode($msj);
    }
    public function terminarVisita()
    {
        date_default_timezone_set('America/Mexico_City');
        $date         = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $id_usuario   = $this->session->userdata('id');

        $candidato = [
            'edicion'   => $date,
            'visitador' => 1,
        ];
        $this->candidato_model->editarCandidato($candidato, $id_candidato);

        $observacion = ($this->input->post('observacion') != '') ? $this->input->post('observacion') : 'Sin comentarios en la visita';
        //* Registro de notificacion de visita finalizada
        $datosUsuario  = $this->usuario_model->getDatosUsuario($id_usuario);
        $tieneVisita   = $this->visita_model->get_by_candidato($id_candidato);
        $rolesUsuarios = $this->usuario_model->get_usuarios_by_rol([1, 2, 4, 6, 9, 10, 11]);
        if (! empty($tieneVisita)) {
            $visita = [
                'edicion'     => $date,
                'id_usuario'  => $id_usuario,
                'fecha_final' => $date,
                'comentarios' => $observacion,
            ];
            $this->candidato_model->editarDatosVisita($visita, $id_candidato);
        } else {
            $visita = [
                'creacion'     => $date,
                'edicion'      => $date,
                'id_usuario'   => $id_usuario,
                'id_candidato' => $id_candidato,
                'comentarios'  => $observacion,
            ];
            $this->candidato_model->crearVisita($visita);
        }
        foreach ($rolesUsuarios as $row) {
            $rolesObjetivos[] = $row->id;
        }
        $titulo  = 'Visita registrada';
        $mensaje = 'Se ha registrado la visita del candidato ' . $tieneVisita->candidato . ', realizada por: ' . $datosUsuario->nombre . ' ' . $datosUsuario->paterno;
        $this->registrar_notificacion($rolesObjetivos, $titulo, $mensaje);
    }
    public function subirPsicometrico()
    {
        if (isset($_FILES["archivo"]["name"])) {
            date_default_timezone_set('America/Mexico_City');
            $date            = date('Y-m-d H:i:s');
            $id_candidato    = $this->input->post('id_candidato');
            $id_psicometrico = $this->input->post('id_psicometrico');
            $id_usuario      = $this->session->userdata('id');
            $extension       = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
            $nombre_archivo  = $id_candidato . "_psicometrico." . $extension;

            $config['upload_path']   = './_psicometria/';
            $config['allowed_types'] = 'pdf';
            $config['overwrite']     = true;
            $config['file_name']     = $nombre_archivo;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            // File upload
            if ($this->upload->do_upload('archivo')) {
                $data = $this->upload->data();
                $this->candidato_model->eliminarPsicometrico($id_candidato);
                $doc = [
                    'creacion'     => $date,
                    'edicion'      => $date,
                    'id_usuario'   => $id_usuario,
                    'id_candidato' => $id_candidato,
                    'archivo'      => $nombre_archivo,
                ];
                $this->candidato_model->guardarPsicometrico($doc);
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'Success',
                ];
            } else {
                $msj = [
                    'codigo' => 2,
                    'msg'    => 'Error al subir el archivo',
                ];
            }
            echo json_encode($msj);
        } else {
            $msj = [
                'codigo' => 0,
                'msg'    => 'Elija el archivo a subir',
            ];
            echo json_encode($msj);
        }
    }
    public function getDocumentacionCandidato()
    {
        $opcion       = $this->input->post('opcion');
        $id_candidato = $this->input->post('id_candidato');
        $salida       = '';
        if ($opcion == 1) {
            $doc = $this->candidato_model->getInfoCandidatoEspecifico($id_candidato);
            if ($doc != null) {
                $f_acta      = ($doc->fecha_acta != "0000-00-00" && $doc->fecha_acta != null) ? fecha_espanol_frontend($doc->fecha_acta) : '';
                $f_domicilio = ($doc->fecha_domicilio != "0000-00-00" && $doc->fecha_domicilio != null) ? fecha_espanol_frontend($doc->fecha_domicilio) : '';
                $f_curp      = ($doc->emision_curp != "0000-00-00" && $doc->emision_curp != null) ? fecha_espanol_frontend($doc->emision_curp) : '';
                $f_nss       = ($doc->emision_nss != '0000-00-00' && $doc->emision_nss != null) ? fecha_espanol_frontend($doc->emision_nss) : '';
                $f_retencion = ($doc->fecha_retencion_impuestos != '0000-00-00' && $doc->fecha_retencion_impuestos != null) ? fecha_espanol_frontend($doc->fecha_retencion_impuestos) : '';
                $f_rfc       = ($doc->emision_rfc != '0000-00-00' && $doc->emision_rfc != null) ? fecha_espanol_frontend($doc->emision_rfc) : '';
                $f_licencia  = ($doc->fecha_licencia != '0000-00-00' && $doc->fecha_licencia != null) ? fecha_espanol_frontend($doc->fecha_licencia) : '';
                $f_migra     = ($doc->vigencia_migratoria != '0000-00-00' && $doc->vigencia_migratoria != null) ? fecha_espanol_frontend($doc->vigencia_migratoria) : '';
                $f_visa      = ($doc->fecha_visa != '0000-00-00' && $doc->fecha_visa != null) ? fecha_espanol_frontend($doc->fecha_visa) : '';
                $salida .= $f_acta . '@@';
                $salida .= $doc->acta . '@@';
                $salida .= $f_domicilio . '@@';
                $salida .= $doc->cuenta_domicilio . '@@';
                $salida .= $doc->emision_ine . '@@';
                $salida .= $doc->ine . '@@';
                $salida .= $f_curp . '@@';
                $salida .= $doc->curp . '@@';
                $salida .= $f_nss . '@@';
                $salida .= $doc->nss . '@@';
                $salida .= $f_retencion . '@@';
                $salida .= $doc->retencion_impuestos . '@@';
                $salida .= $f_rfc . '@@';
                $salida .= $doc->rfc . '@@';
                $salida .= $f_licencia . '@@';
                $salida .= $doc->licencia . '@@';
                $salida .= $f_migra . '@@';
                $salida .= $doc->numero_migratorio . '@@';
                $salida .= $f_visa . '@@';
                $salida .= $doc->visa;

                echo $salida;
            } else {
                echo $salida = 0;
            }
        }
        if ($opcion == 2) {
            $data['docs'] = $this->candidato_model->getVerificacionDocumentosCandidato($id_candidato);
            if ($data['docs']) {
                foreach ($data['docs'] as $doc) {
                    $salida .= $doc->licencia . '@@';
                    $salida .= $doc->licencia_institucion . '@@';
                    $salida .= $doc->ine . '@@';
                    $salida .= $doc->ine_institucion . '@@';
                    $salida .= $doc->domicilio . '@@';
                    $salida .= $doc->fecha_domicilio . '@@';
                    $salida .= $doc->imss . '@@';
                    $salida .= $doc->imss_institucion . '@@';
                    $salida .= $doc->rfc . '@@';
                    $salida .= $doc->rfc_institucion . '@@';
                    $salida .= $doc->curp . '@@';
                    $salida .= $doc->curp_institucion . '@@';
                    $salida .= $doc->carta_recomendacion . '@@';
                    $salida .= $doc->carta_recomendacion_institucion . '@@';
                    $salida .= $doc->comentarios;
                }
                echo $salida;
            } else {
                echo $salida = 0;
            }
        }
    }

    public function getPaqueteSubclienteProyecto()
    {
        $id_cliente       = 2;
        $id_proyecto      = $_POST['id_proyecto'];
        $data['paquetes'] = $this->cliente_model->getPaqueteSubclienteProyecto($id_cliente, $id_proyecto);
        $salida           = "<option value=''>Select</option>";
        if ($data['paquetes']) {
            foreach ($data['paquetes'] as $row) {
                $salida .= "<option value='" . $row->id . "'>" . $row->nombre . "</option>";
            }
            $salida .= "<option value='0'>N/A</option>";
            echo $salida;
        } else {
            $salida .= " <option value='0'>N/A</option>";
            echo $salida;
        }
    }
    public function getPaqueteProyecto()
    {
        $id_cliente       = $_POST['id_cliente'];
        $id_proyecto      = $_POST['id_proyecto'];
        $data['paquetes'] = $this->cliente_model->getPaqueteSubclienteProyecto($id_cliente, $id_proyecto);
        $salida           = "<option value=''>Select</option>";
        if ($data['paquetes']) {
            foreach ($data['paquetes'] as $row) {
                $salida .= "<option value='" . $row->id . "'>" . $row->nombre . "</option>";
            }
            $salida .= " <option value='0'>N/A</option>";
            echo $salida;
        } else {
            $salida .= " <option value='0'>N/A</option>";
            echo $salida;
        }
    }
    public function checkGaps()
    {
        $id_candidato = $this->input->post('id_candidato');
        $salida       = '';
        $data['gaps'] = $this->candidato_model->checkGaps($id_candidato);
        if ($data['gaps']) {
            foreach ($data['gaps'] as $gap) {
                $salida .= '<div class="row gap' . $gap->id . '">
                                    <div class="col-6 mb-3">
                                        <label>From</label>
                                        <input type="text" class="form-control" id="fecha_inicio_gap' . $gap->id . '" name="fecha_inicio_gap' . $gap->id . '" value="' . $gap->fecha_inicio . '">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label>To</label>
                                        <input type="text" class="form-control" id="fecha_fin_gap' . $gap->id . '" name="fecha_fin_gap' . $gap->id . '" value="' . $gap->fecha_fin . '">
                                    </div>
                                </div>
                                <div class="row gap' . $gap->id . '">
                                    <div class="col-12 mb-3">
                                        <label>Reason and activities performed</label>
                                        <textarea class="form-control" rows="3" id="razon_gap' . $gap->id . '">' . $gap->razon . '</textarea>
                                    </div>
                                </div>
                                <div id="error_gap' . $gap->id . '" class="alert alert-danger hidden"></div>
                                <div class="col-6 offset-4 div_btn_fondo">
                                    <button type="button" class="btn btn-primary mr-3" onclick="editarGap(' . $gap->id . ',' . $gap->id_candidato . ')">Edit</button>
                                    <button type="button" class="btn btn-danger" onclick="confirmacionAccion(\'eliminar\',\'gaps\',' . $gap->id . ',' . $gap->id_candidato . ')">Delete</button>
                                </div>
                                <hr>';
            }
            echo $salida;
        } else {
            echo $salida;
        }
    }
    public function createGap()
    {
        $this->form_validation->set_rules('fi', 'Fecha inicio', 'required|trim');
        $this->form_validation->set_rules('ff', 'Fecha fin', 'required|trim');
        $this->form_validation->set_rules('razon', 'Razón', 'required|trim');
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $id_candidato = $this->input->post('id_candidato');
            $fi           = $this->input->post('fi');
            $ff           = $this->input->post('ff');
            $razon        = $this->input->post('razon');
            $id_usuario   = $this->session->userdata('id');
            date_default_timezone_set('America/Mexico_City');
            $date   = date('Y-m-d H:i:s');
            $salida = '';
            $this->candidato_model->createGap($id_candidato, $id_usuario, $date, $fi, $ff, $razon);
            $data['gaps'] = $this->candidato_model->checkGaps($id_candidato);
            if ($data['gaps']) {
                foreach ($data['gaps'] as $gap) {
                    $salida .= '<div class="row gap' . $gap->id . '">
                                        <div class="col-6 mb-3">
                                            <label>Del</label>
                                            <input type="text" class="form-control" id="fecha_inicio_gap' . $gap->id . '" name="fecha_inicio_gap' . $gap->id . '" value="' . $gap->fecha_inicio . '">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>Al</label>
                                            <input type="text" class="form-control" id="fecha_fin_gap' . $gap->id . '" name="fecha_fin_gap' . $gap->id . '" value="' . $gap->fecha_fin . '">
                                        </div>
                                    </div>
                                    <div class="row gap' . $gap->id . '">
                                        <div class="col-12 mb-3">
                                            <label>Razón</label>
                                            <textarea class="form-control" rows="3" id="razon_gap' . $gap->id . '">' . $gap->razon . '</textarea>
                                        </div>
                                    </div>
                                    <div id="error_gap' . $gap->id . '" class="alert alert-danger hidden"></div>
                                    <div class="col-6 offset-4 div_btn_fondo">
                                        <button type="button" class="btn btn-primary mr-3" onclick="editarGap(' . $gap->id . ',' . $gap->id_candidato . ')">Editar GAP</button>
                                        <button type="button" class="btn btn-danger" onclick="confirmacionAccion(\'eliminar\',\'gaps\',' . $gap->id . ',' . $gap->id_candidato . ')">Borrar GAP</button>
                                    </div>
                                    <hr>';
                }
            }
            $msj = [
                'codigo' => 1,
                'msg'    => $salida,
            ];
        }
        echo json_encode($msj);
    }
    public function editarGap()
    {
        $this->form_validation->set_rules('fi', 'Fecha inicio', 'required|trim');
        $this->form_validation->set_rules('ff', 'Fecha fin', 'required|trim');
        $this->form_validation->set_rules('razon', 'Razón', 'required|trim');
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $id_gap       = $this->input->post('id');
            $id_candidato = $this->input->post('id_candidato');
            $fi           = $this->input->post('fi');
            $ff           = $this->input->post('ff');
            $razon        = $this->input->post('razon');
            $id_usuario   = $this->session->userdata('id');
            date_default_timezone_set('America/Mexico_City');
            $date   = date('Y-m-d H:i:s');
            $salida = '';
            $datos  = [
                'edicion'      => $date,
                'id_usuario'   => $id_usuario,
                'id_candidato' => $id_candidato,
                'fecha_inicio' => $fi,
                'fecha_fin'    => $ff,
                'razon'        => $razon,
            ];
            $this->candidato_model->editarGap($datos, $id_gap);
            $msj = [
                'codigo' => 1,
                'msg'    => $salida,
            ];
        }
        echo json_encode($msj);
    }
    public function eliminarGap()
    {
        $id_gap       = $this->input->post('id');
        $id_candidato = $this->input->post('id_candidato');
        $this->candidato_model->eliminarGap($id_gap);
        $salida       = '';
        $data['gaps'] = $this->candidato_model->checkGaps($id_candidato);
        if ($data['gaps']) {
            foreach ($data['gaps'] as $gap) {
                $salida .= '<div class="row gap' . $gap->id . '">
                                    <div class="col-6 mb-3">
                                        <label>Del</label>
                                        <input type="text" class="form-control" id="fecha_inicio_gap' . $gap->id . '" name="fecha_inicio_gap' . $gap->id . '" value="' . $gap->fecha_inicio . '">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label>Al</label>
                                        <input type="text" class="form-control" id="fecha_fin_gap' . $gap->id . '" name="fecha_fin_gap' . $gap->id . '" value="' . $gap->fecha_fin . '">
                                    </div>
                                </div>
                                <div class="row gap' . $gap->id . '">
                                    <div class="col-12 mb-3">
                                        <label>Razón</label>
                                        <textarea class="form-control" rows="3" id="razon_gap' . $gap->id . '">' . $gap->razon . '</textarea>
                                    </div>
                                </div>
                                <div id="error_gap' . $gap->id . '" class="alert alert-danger hidden"></div>
                                <div class="col-6 offset-4 div_btn_fondo">
                                    <button type="button" class="btn btn-primary mr-3" onclick="editarGap(' . $gap->id . ',' . $gap->id_candidato . ')">Editar GAP</button>
                                    <button type="button" class="btn btn-danger" onclick="confirmacionAccion(\'eliminar\',\'gaps\',' . $gap->id . ',' . $gap->id_candidato . ')">Borrar GAP</button>
                                </div>
                                <hr>';
            }
            echo $salida;
        } else {
            echo $salida;
        }
    }
    public function guardarVerificacionChecklist()
    {
        $this->form_validation->set_rules('check_education', 'Educación', 'required|trim');
        $this->form_validation->set_rules('check_employment', 'Empleos', 'required|trim');
        $this->form_validation->set_rules('check_address', 'Domicilios', 'required|trim');
        $this->form_validation->set_rules('check_criminal', 'Criminal', 'required|trim');
        $this->form_validation->set_rules('check_database', 'Global database', 'required|trim');
        $this->form_validation->set_rules('check_identity', 'Identidad', 'required|trim');
        //$this->form_validation->set_rules('check_military', 'Servicio militar', 'required|trim');
        $this->form_validation->set_rules('check_prohibited', 'Prohibited parties list', 'trim');
        $this->form_validation->set_rules('check_other', 'Otras verificaciones', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date         = date('Y-m-d H:i:s');
            $id_candidato = $this->input->post('id_candidato');
            $id_usuario   = $this->session->userdata('id');
            $verificacion = [
                'creacion'                => $date,
                'edicion'                 => $date,
                'id_usuario'              => $id_usuario,
                'id_candidato'            => $id_candidato,
                'education'               => $this->input->post('check_education'),
                'employment'              => $this->input->post('check_employment'),
                'address'                 => $this->input->post('check_address'),
                'criminal'                => $this->input->post('check_criminal'),
                'global_database'         => $this->input->post('check_database'),
                'identity'                => $this->input->post('check_identity'),
                //'military' => $this->input->post('check_military'),
                'prohibited_parties_list' => $this->input->post('check_prohibited'),
                'other'                   => $this->input->post('check_other'),
            ];
            $this->candidato_model->eliminarChecklist($id_candidato);
            $this->candidato_model->guardarChecklist($verificacion);
            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function getVecinales()
    {
        $id_candidato = $_POST['id_candidato'];
        $salida       = "";
        $data['refs'] = $this->candidato_model->getVecinales($id_candidato);
        if ($data['refs']) {
            foreach ($data['refs'] as $ref) {
                $salida .= $ref->nombre . "@@";
                $salida .= $ref->telefono . "@@";
                $salida .= $ref->domicilio . "@@";
                $salida .= $ref->concepto_candidato . "@@";
                $salida .= $ref->concepto_familia . "@@";
                $salida .= $ref->civil_candidato . "@@";
                $salida .= $ref->hijos_candidato . "@@";
                $salida .= $ref->sabe_trabaja . "@@";
                $salida .= $ref->notas . "@@";
                $salida .= $ref->id . "###";
            }
            echo $salida;
        } else {
            echo $salida = 0;
        }
    }
    public function eliminarVecinal()
    {
        if ($this->input->post('id') != '') {
            $this->candidato_model->eliminarVecinal($this->input->post('id'));
            $msj = [
                'codigo' => 1,
                'msg'    => 'Success',
            ];
        } else {
            $msj = [
                'codigo' => 0,
                'msg'    => 'Error',
            ];
        }
        echo json_encode($msj);
    }
    public function getPruebasCandidato()
    {
        $id_candidato = $this->input->post('id_candidato');
        $res          = [];
        $dato         = $this->candidato_model->getPruebasCandidato($id_candidato);
        if ($dato != null) {
            $res = [
                'antidoping'     => $dato->antidoping,
                'status_doping'  => $dato->status_doping,
                'psicometrico'   => $dato->psicometrico,
                'medico'         => $dato->medico,
                'idMedico'       => $dato->idMedico,
                'idPsicometrico' => $dato->idPsicometrico,
            ];
        }
        echo json_encode($res);
    }
    public function actualizarPruebasCandidato()
    {
        $this->form_validation->set_rules('antidoping', 'Examen antidoping', 'required|trim|numeric');
        $this->form_validation->set_rules('psicometrico', 'Prueba psicométrica', 'required|trim|numeric');
        $this->form_validation->set_rules('medico', 'Exámen médico', 'required|trim|numeric');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $id_candidato = $this->input->post('id_candidato');
            $antidoping   = $this->input->post('antidoping');
            $id_usuario   = $this->session->userdata('id');
            date_default_timezone_set('America/Mexico_City');
            $date            = date('Y-m-d H:i:s');
            $tipo_antidoping = ($antidoping != 0) ? 1 : 0;
            $datos           = [
                'edicion'         => $date,
                'id_usuario'      => $id_usuario,
                'id_candidato'    => $id_candidato,
                'id_cliente'      => $this->input->post('id_cliente'),
                'tipo_antidoping' => $tipo_antidoping,
                'antidoping'      => $antidoping,
                'psicometrico'    => $this->input->post('psicometrico'),
                'medico'          => $this->input->post('medico'),
            ];
            $this->candidato_model->editarPruebas($datos, $id_candidato);
            $msj = [
                'codigo' => 1,
                'msg'    => 'Success',
            ];
        }
        echo json_encode($msj);
    }
    public function getFechaInicio()
    {
        $id_candidato = $this->input->post('id_candidato');
        $res          = $this->candidato_model->getFechaInicioProceso($id_candidato);
        $fecha        = '';
        if ($res->fecha_inicio != null) {
            $aux   = explode(' ', $res->fecha_inicio);
            $fecha = fecha_espanol_frontend($aux[0]);
        }
        echo $fecha;
    }
    public function guardarFechaInicio()
    {
        $this->form_validation->set_rules('fecha', 'Fecha de inicio', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            $id_candidato = $this->input->post('id_candidato');
            $fecha        = $this->input->post('fecha');
            $id_usuario   = $this->session->userdata('id');
            date_default_timezone_set('America/Mexico_City');

            $cand     = $this->candidato_model->getInfoCandidatoEspecifico($id_candidato);
            $alta     = new DateTime($cand->fecha_alta);
            $f_inicio = new DateTime($fecha);
            if ($alta > $f_inicio) {
                $msj = [
                    'codigo' => 0,
                    'msg'    => 'La fecha a ingresar no es válida',
                ];
            } else {
                $fecha_inicio = fecha_espanol_bd($fecha);
                $datos        = [
                    'id_usuario'   => $id_usuario,
                    'fecha_inicio' => $fecha_inicio,
                ];
                $this->candidato_model->editarCandidato($datos, $id_candidato);
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'Success',
                ];
            }
        }
        echo json_encode($msj);
    }
    public function getChecklistCandidato()
    {
        $id_candidato   = $this->input->post('id_candidato');
        $data['checks'] = $this->candidato_model->getVerificacionChecklist($id_candidato);
        if ($data['checks'] != null) {
            echo json_encode($data['checks']);
        } else {
            echo $res = 0;
        }
    }
    public function getEgresos()
    {
        $id_candidato    = $_POST['id_candidato'];
        $salida          = "";
        $data['egresos'] = $this->candidato_model->getEgresos($id_candidato);
        if ($data['egresos']) {
            foreach ($data['egresos'] as $e) {
                //$salida .= $e->id."@@";
                $salida .= $e->renta . "@@";
                $salida .= $e->alimentos . "@@";
                $salida .= $e->servicios . "@@";
                $salida .= $e->transporte . "@@";
                $salida .= $e->otros . "@@";
                $salida .= $e->solvencia . '@@';
            }
        }
        $data['cand'] = $this->candidato_model->getInfoCandidato($id_candidato);
        foreach ($data['cand'] as $c) {
            $salida .= $c->muebles . '@@';
            $salida .= $c->adeudo_muebles . '@@';
            $salida .= $c->ingresos . '@@';
            $salida .= $c->aporte . '@@';
            $salida .= $c->comentario;
        }
        echo $salida;

    }
    public function getIngresosEgresos()
    {
        $id_candidato = $this->input->post('id_candidato');
        $salida       = "";
        $data['info'] = $this->candidato_model->getIngresosEgresos($id_candidato);
        if ($data['info']) {
            foreach ($data['info'] as $row) {
                $salida .= $row->otros . "@@";
                $salida .= $row->solvencia;
            }
            echo $salida;
        } else {
            echo $salida = 0;
        }
    }
    public function guardarVisibilidadCandidato()
    {
        $id_candidato = $this->input->post('id_candidato');
        $visibilidad  = ($this->input->post('visibilidad') == 1) ? 0 : 1;
        $this->candidato_model->guardarVisibilidadCandidato($id_candidato, $visibilidad);
        $msj = [
            'codigo' => 1,
            'msg'    => 'Se ha actualizado la visibilidad del candidato correctamente',
        ];
        echo json_encode($msj);

    }
    /*----------------------------------------*/
    /*  Funciones Secciones de estudio
    /*----------------------------------------*/
    public function getSeccionesRegion()
    {
        $region            = $this->input->post('region');
        $data['secciones'] = $this->candidato_model->getSeccionesRegion($region);

        echo json_encode($data['secciones']);
    }
    public function getSeccionesPrevias()
    {
        $id_cliente      = $this->input->post('id_cliente');
        $data['previas'] = $this->candidato_model->getHistorialProyectos($id_cliente);
        if ($data['previas']) {
            $salida = "<option value='0'>Select</option>";
            $salida .= "<option value='0'>N/A</option>";
            foreach ($data['previas'] as $prev) {
                $salida .= '<option value="' . $prev->id . '">' . $prev->proyecto . '</option>';
            }
        } else {
            $salida = "<option value='0'>N/A</option>";
        }
        echo $salida;
    }
    public function getDetallesProyectoPrevio()
    {
        $id_previo = $this->input->post('id_previo');
        $seccion   = $this->candidato_model->getProyectoPrevio($id_previo);
        $res       = '<ul>';
        $res .= ($seccion->lleva_empleos == 1) ? '<li>Employment history: ' . $seccion->tiempo_empleos . '</li>' : '';
        $res .= ($seccion->lleva_criminal == 1) ? '<li>Criminal check: ' . $seccion->tiempo_criminales . '</li>' : '';
        $res .= ($seccion->lleva_estudios == 1) ? '<li>Education check: Highest studies</li>' : '';
        $res .= ($seccion->lleva_domicilios == 1) ? '<li>Address history: ' . $seccion->tiempo_domicilios . '</li>' : '';
        if ($seccion->lleva_identidad == 1) {
            //$identidad = $this->candidato_model->getSeccion($seccion->id_seccion_verificacion_docs);
            $res .= '<li>Identity check</li>';
        }
        if ($seccion->id_seccion_global_search != null) {
            $global = $this->candidato_model->getSeccion($seccion->id_seccion_global_search);
            $res .= '<li>Global data searches: ' . $global->descripcion_ingles . '</li>';
        }
        $res .= ($seccion->cantidad_ref_profesionales > 0) ? '<li>Professional references: ' . $seccion->cantidad_ref_profesionales . '</li>' : '';
        $res .= ($seccion->lleva_credito == 1) ? '<li>Credit check: ' . $seccion->tiempo_credito . '</li>' : '';
        $res .= ($seccion->cantidad_ref_personales > 0) ? '<li>Personal references: ' . $seccion->cantidad_ref_personales . '</li>' : '';
        $res .= '</ul>';
        //Determinar si el proyecto es Nacional (Mexico) o Internacional
        if ($seccion->id_seccion_datos_generales == null) {
            $data['paises_estudio'] = $this->funciones_model->getPaisesEstudio();
            $region                 = '<option value="">Select</option>';
            $region .= '<option value="México">Mexico</option>';
            foreach ($data['paises_estudio'] as $p) {
                $region .= '<option value="' . $p->nombre_espanol . '">' . $p->nombre_ingles . '</option>';
            }
        }
        if ($seccion->id_seccion_datos_generales == 111) {
            $region = '<option value="México" selected>Mexico</option>';
        }
        if ($seccion->id_seccion_datos_generales == 83) {
            $data['paises_estudio'] = $this->funciones_model->getPaisesEstudio();
            $region                 = '<option value="">Select</option>';
            foreach ($data['paises_estudio'] as $p) {
                $region .= '<option value="' . $p->nombre_espanol . '">' . $p->nombre_ingles . '</option>';
            }
        }
        echo $res . '@@' . $region;
    }
    public function getDetallesProyectoPrevio2()
    {
        $id_previo = $this->input->post('id_previo');
        $seccion   = $this->candidato_model->getProyectoPrevio($id_previo);
        $res       = '<ul>';
        $res .= ($seccion->id_seccion_datos_generales != null) ? '<li>Datos generales</li>' : '';
        $res .= ($seccion->lleva_estudios == 1) ? '<li>Historial acádemico</li>' : '';
        $res .= ($seccion->lleva_sociales == 1) ? '<li>Antecedentes sociales</li>' : '';
        $res .= ($seccion->cantidad_ref_personales > 0) ? '<li>Referencias personales: ' . $seccion->cantidad_ref_personales . '</li>' : '';
        $res .= ($seccion->lleva_empleos == 1) ? '<li>Referencias laborales</li>' : '';
        $res .= ($seccion->lleva_investigacion == 1) ? '<li>Investigación legal</li>' : '';
        $res .= ($seccion->lleva_no_mencionados == 1) ? '<li>Trabajos no mencionados</li>' : '';
        $res .= ($seccion->id_seccion_verificacion_docs != null) ? '<li>Documentación</li>' : '';
        $res .= ($seccion->lleva_familiares == 1) ? '<li>Grupo familiar</li>' : '';
        $res .= ($seccion->lleva_egresos == 1) ? '<li>Ingresos y egresos</li>' : '';
        $res .= ($seccion->lleva_vivienda == 1) ? '<li>Habitación y medio ambiente</li>' : '';
        $res .= ($seccion->cantidad_ref_vecinales == 1) ? '<li>Referencias vecinales: ' . $seccion->cantidad_ref_vecinales . '</li>' : '';

        $res .= '</ul>';
        echo $res;
    }

    /*----------------------------------------*/
    /*  Creacion de Porcentaje de Avances
    /*----------------------------------------*/
    public function generarAvancesUST($id_candidato)
    {
        $c          = $this->cliente_ust_model->getSeccionesRequeridas($id_candidato);
        $porcentaje = 0;
        if ($c->estudios_comentarios != '' && $c->estudios_comentarios != null) { //Comentarios historial academico
            $porcentaje += 10;
        }
        if ($c->docs_comentarios != '' && $c->docs_comentarios != null) { //Comentarios verificacion documentos
            $porcentaje += 10;
        }
        if ($c->idRefPer != null) { //minimo un id de candidato_ref_personal
            $porcentaje += 20;
        }
        if ($c->idVerLaboral != null) { //minimo un id de verificacion_ref_laboral
            $porcentaje += 20;
        }
        if ($c->idVerEstudios != null) { //minimo un id de verificacion de estudios
            $porcentaje += 10;
        }
        if ($c->idEstatusLaboral != null) { //minimo un id de verificacion laboral
            $porcentaje += 10;
        }
        if ($c->idVerPenal != null) { //minimo un id de verificacion penal
            $porcentaje += 10;
        }
        //Se checa el porcentaje en caso de que tenga los documentos obligatorios, los demas puede que no se tengan por alguna razon
        $data['docs'] = $this->cronjobs_model->getDocumentosObligatoriosUST($id_candidato);
        if ($data['docs']) {
            $aviso = 0;
            $ofac  = 0;
            foreach ($data['docs'] as $doc) {
                if ($doc->id_tipo_documento == 8) { // Si tiene cargado el aviso de privacidad
                    $aviso = 1;
                }
                if ($doc->id_tipo_documento == 11) { //Si tiene cargado el OFAC
                    $ofac = 1;
                }
            }
            $p = ($aviso == 1) ? 5 : 0;
            $porcentaje += $p;
            $p2 = ($ofac == 1) ? 5 : 0;
            $porcentaje += $p2;
        }
        $this->cronjobs_model->cleanAvance($id_candidato);
        $this->cronjobs_model->actualizarAvance($porcentaje, $id_candidato);
    }

    /*----------------------------------------*/
    /* Panel Subclientes
    /*----------------------------------------*/
    public function viewAvances()
    {
        $id_candidato      = $this->input->post('id_candidato');
        $id_rol            = $this->input->post('id_rol');
        $txt_fecha         = ($this->input->post('espanol') == 1) ? 'Fecha: ' : 'Date: ';
        $txt_comentario    = ($this->input->post('espanol') == 1) ? 'Comentario: ' : 'Comment: ';
        $txt_imagen        = ($this->input->post('espanol') == 1) ? 'Ver imagen: ' : 'View file';
        $txt_sin_registros = ($this->input->post('espanol') == 1) ? 'Sin registro de avances: ' : 'No registers';

                                                             // Crear la URL de la API
        $api_base_url = $this->config->item('api_base_url'); // Asegúrate de que esté bien configurado
        $url          = $api_base_url . 'api/viewAvancesJson';
        // Configurar los datos para enviar como JSON
        $postData = [
            'id_candidato' => $id_candidato,
            'id_rol'       => $id_rol,
        ];

        // Inicializar cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData)); // Enviar datos como JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);

        // Ejecutar la solicitud
        $response = curl_exec($ch);

        // Verificar errores en cURL
        if ($response === false) {
            $error_msg = curl_error($ch);
            echo json_encode(['codigo' => 0, 'msg' => 'Error en la solicitud cURL: ' . $error_msg]);
            curl_close($ch);
            return;
        }

        // Verificar el código HTTP
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_status !== 200) {
            echo json_encode(['codigo' => 0, 'msg' => 'Error en la solicitud, código HTTP: ' . $http_status]);
            return;
        }

        // Decodificar la respuesta JSON

        // Decodificar la respuesta JSON
        $data = json_decode($response, true);

        // Generar la salida
        $salida = '<div class="row">';
        $salida .= '<div class="col-md-12">';

        if (isset($data['success']) && $data['success'] && ! empty($data['data'])) {
            foreach ($data['data'] as $row) {
                $salida .= '<p style="padding-right: 5px;"><b>' . $txt_fecha . '</b> ' . $row['fecha'] . '</p>';
                $salida .= '<p><b>' . $txt_comentario . '</b> ' . $row['comentarios'] . '</p>';
                $salida .= ($row['adjunto'] != "")
                ? "<a href='" . $api_base_url . "_adjuntos/" . $row['adjunto'] . "' target='_blank' style='margin-bottom: 10px;text-align:center;'>" . $txt_imagen . "</a><hr>"
                : "<hr>";
            }
        } else {
            $salida .= '<p class="text-center"><b>' . $txt_sin_registros . '</b></p><br>';
        }

        $salida .= '</div></div>';
        echo $salida;
    }
    /*----------------------------------------*/
    /* Formulario y Documentacion Panel Candidatos
    /*----------------------------------------*/
    public function subirArchivosCandidato()
    {
        date_default_timezone_set('America/Mexico_City');
        $date           = date('Y-m-d H:i:s');
        $tipo_documento = $this->input->post('tipo_documento');
        $id_candidato   = $this->input->post('id_candidato');
        $error          = 0;
        if (! empty($_FILES['archivos'])) {
            $countfiles = count($_FILES['archivos']['name']);
            for ($i = 0; $i < $countfiles; $i++) {
                if (! empty($_FILES['archivos']['name'][$i])) {
                    // Define new $_FILES array - $_FILES['file']
                    $_FILES['file']['name']     = $_FILES['archivos']['name'][$i];
                    $_FILES['file']['type']     = $_FILES['archivos']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['archivos']['tmp_name'][$i];
                    $_FILES['file']['error']    = $_FILES['archivos']['error'][$i];
                    $_FILES['file']['size']     = $_FILES['archivos']['size'][$i];
                    // Set preference
                    $config['upload_path']   = './_docs/';
                    $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                    $config['max_size']      = '2048'; // max_size in kb
                    $cadena                  = substr(md5(time()), 0, 16);
                    //$tipo = $this->candidato_model->getTipoDoc($tipo_documento);
                    //$tipoArchivo = str_replace(' ','',$tipo->nombre);
                    $extension           = pathinfo($_FILES['archivos']['name'][$i], PATHINFO_EXTENSION);
                    $config['file_name'] = $id_candidato . '_' . $cadena . '' . $i . '.' . $extension;
                    $nombre_archivo      = $id_candidato . '_' . $cadena . '' . $i . '.' . $extension;
                    //Load upload library
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    // File upload
                    if (! $this->upload->do_upload('file')) {
                        $error++;
                        break;
                    } else {
                        $doc = [
                            'creacion'          => $date,
                            'edicion'           => $date,
                            'id_candidato'      => $id_candidato,
                            'id_tipo_documento' => $tipo_documento,
                            'archivo'           => $nombre_archivo,
                        ];
                        $arreglo[] = $doc;
                        unset($doc);
                    }
                }
            }
            if ($error == 0) {
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'Success',
                ];
                $cantidad_archivos = count($arreglo);
                for ($j = 0; $j < $cantidad_archivos; $j++) {
                    $this->candidato_model->insertDocCandidato($arreglo[$j]);
                }
            } else {
                $msj = [
                    'codigo' => 2,
                    'msg'    => 'Error',
                ];
            }
            echo json_encode($msj);
        } else {
            $msj = [
                'codigo' => 0,
                'msg'    => 'Error',
            ];
            echo json_encode($msj);
        }
    }
    public function guardarFormUSTCandidato()
    {
        if ($this->input->post('proyecto') == 'National Verification') {
            $this->form_validation->set_rules('calle', 'Address', 'required|trim');
            $this->form_validation->set_rules('exterior', 'Exterior Number', 'required|trim|max_length[8]');
            $this->form_validation->set_rules('interior', 'Interior Number', 'trim|max_length[8]');
            $this->form_validation->set_rules('colonia', 'Neighborhood', 'required|trim');
            $this->form_validation->set_rules('estado', 'State', 'required|trim');
            $this->form_validation->set_rules('municipio', 'City', 'required|trim');
            $this->form_validation->set_rules('cp', 'Zip Code', 'required|trim');
        }
        if ($this->input->post('proyecto') == 'International Verification' || $this->input->post('proyecto') == 'International Check') {
            $this->form_validation->set_rules('domicilio_completo', 'Address', 'required|trim');
        }
        $this->form_validation->set_rules('fecha_nacimiento', 'Birhtdate', 'required|trim');
        $this->form_validation->set_rules('puesto', 'Job Position Requested', 'required|trim');
        $this->form_validation->set_rules('nacionalidad', 'Nationality', 'required|trim');
        $this->form_validation->set_rules('genero', 'Gender', 'required|trim');
        $this->form_validation->set_rules('civil', 'Marital Status', 'required|trim');
        $this->form_validation->set_rules('telefono', 'Mobile Number', 'required|trim|max_length[16]');
        $this->form_validation->set_rules('tel_casa', 'Home Number', 'trim|max_length[16]');
        $this->form_validation->set_rules('tel_otro', 'Number to leave Messages', 'trim|max_length[16]');

        // $this->form_validation->set_rules('num_hijos', 'How many children do you have?', 'trim|numeric');
        // $this->form_validation->set_rules('num_hermanos', 'How many siblings do you have?', 'trim|numeric');
        $this->form_validation->set_rules('prim_periodo', 'Period of the Elementary School', 'required|trim');
        $this->form_validation->set_rules('prim_escuela', 'Institute of the Elementary School', 'required|trim');
        $this->form_validation->set_rules('prim_ciudad', 'City of the Elementary School', 'required|trim');
        $this->form_validation->set_rules('prim_certificado', 'Certificate Obtained of the Elementary School', 'required|trim');
        $this->form_validation->set_rules('sec_periodo', 'Period of the Middle School', 'required|trim');
        $this->form_validation->set_rules('sec_escuela', 'Institute of the Middle School', 'required|trim');
        $this->form_validation->set_rules('sec_ciudad', 'City of the Middle School', 'required|trim');
        $this->form_validation->set_rules('sec_certificado', 'Certificate Obtained of the Middle School', 'required|trim');
        $this->form_validation->set_rules('prep_periodo', 'Period of the High School', 'required|trim');
        $this->form_validation->set_rules('prep_escuela', 'Institute of the High School', 'required|trim');
        $this->form_validation->set_rules('prep_ciudad', 'City of the High School', 'required|trim');
        $this->form_validation->set_rules('prep_certificado', 'Certificate Obtained of the High School', 'required|trim');
        $this->form_validation->set_rules('lic_periodo', 'Period of the College', 'required|trim');
        $this->form_validation->set_rules('lic_escuela', 'Institute of the College', 'required|trim');
        $this->form_validation->set_rules('lic_ciudad', 'City of the College', 'required|trim');
        $this->form_validation->set_rules('lic_certificado', 'Certificate Obtained of the College', 'required|trim');
        $this->form_validation->set_rules('otro_certificado', 'Seminaries/Courses Certificates', 'required|trim');
        $this->form_validation->set_rules('carrera_inactivo', 'Break(s) in Studies', 'required|trim');
        $this->form_validation->set_rules('trabajo_inactivo', 'Break(s) in Employment', 'required|trim');
        $this->form_validation->set_rules('trabajo_gobierno', 'Have you worked in any government entity, Politic Party or NGO?', 'required|trim');
        $this->form_validation->set_rules('comentarios_candidato', 'Your Comments', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date            = date('Y-m-d H:i:s');
            $id_candidato    = $this->session->userdata('id');
            $fecha           = fecha_ingles_bd($this->input->post('fecha_nacimiento'));
            $edad            = calculaEdad($fecha);
            $datos_candidato = $this->candidato_model->getDetalles($id_candidato);
            $candidato       = [
                'fecha_contestado'        => $date,
                'edicion'                 => $date,
                'fecha_nacimiento'        => $fecha,
                'edad'                    => $edad,
                'puesto'                  => $this->input->post('puesto'),
                'nacionalidad'            => $this->input->post('nacionalidad'),
                'genero'                  => $this->input->post('genero'),
                'calle'                   => $this->input->post('calle'),
                'exterior'                => $this->input->post('exterior'),
                'interior'                => $this->input->post('interior'),
                'colonia'                 => $this->input->post('colonia'),
                'id_estado'               => $this->input->post('estado'),
                'id_municipio'            => $this->input->post('municipio'),
                'cp'                      => $this->input->post('cp'),
                'domicilio_internacional' => $this->input->post('domicilio_completo'),
                'estado_civil'            => $this->input->post('civil'),
                'celular'                 => $this->input->post('telefono'),
                'telefono_casa'           => $this->input->post('tel_casa'),
                'telefono_otro'           => $this->input->post('tel_otro'),
                'trabajo_inactivo'        => $this->input->post('trabajo_inactivo'),
                'trabajo_gobierno'        => $this->input->post('trabajo_gobierno'),
                'comentario'              => $this->input->post('comentarios_candidato'),
                'status'                  => 1,
            ];
            $this->candidato_model->editarCandidato($candidato, $id_candidato);

            $this->candidato_model->eliminarFamiliares($id_candidato);
            if ($this->input->post('nombre_conyuge') != '' && $this->input->post('nombre_conyuge') != null) {
                $data_conyuge = [
                    'creacion'           => $date,
                    'edicion'            => $date,
                    'id_candidato'       => $id_candidato,
                    'nombre'             => $this->input->post('nombre_conyuge'),
                    'id_tipo_parentesco' => 4,
                    'edad'               => $this->input->post('edad_conyuge'),
                    'estado_civil'       => 1,
                    'id_grado_estudio'   => 11,
                    'misma_vivienda'     => $this->input->post('con_conyuge'),
                    'ciudad'             => $this->input->post('ciudad_conyuge'),
                    'empresa'            => $this->input->post('empresa_conyuge'),
                    'puesto'             => $this->input->post('puesto_conyuge'),
                ];
                $this->candidato_model->guardarFamiliar($data_conyuge);
            }
            if ($this->input->post('num_hijos') > 0) {
                $num_hijos = $this->input->post('num_hijos');
                for ($i = 1; $i <= $num_hijos; $i++) {
                    if ($this->input->post('nombre_hijo' . $i) != '') {
                        $data_hijos = [
                            'creacion'           => $date,
                            'edicion'            => $date,
                            'id_candidato'       => $id_candidato,
                            'nombre'             => $this->input->post('nombre_hijo' . $i),
                            'id_tipo_parentesco' => 3,
                            'edad'               => $this->input->post('edad_hijo' . $i),
                            'estado_civil'       => null,
                            'id_grado_estudio'   => 11,
                            'misma_vivienda'     => $this->input->post('con_hijo' . $i),
                            'ciudad'             => $this->input->post('ciudad_hijo' . $i),
                            'empresa'            => $this->input->post('empresa_hijo' . $i),
                            'puesto'             => $this->input->post('puesto_hijo' . $i),
                        ];
                        $this->candidato_model->guardarFamiliar($data_hijos);
                    }
                }
            }
            if ($this->input->post('nombre_padre') != '' && $this->input->post('nombre_padre') != null) {
                $data_padre = [
                    'creacion'           => $date,
                    'edicion'            => $date,
                    'id_candidato'       => $id_candidato,
                    'nombre'             => $this->input->post('nombre_padre'),
                    'id_tipo_parentesco' => 1,
                    'edad'               => $this->input->post('edad_padre'),
                    'estado_civil'       => null,
                    'id_grado_estudio'   => 11,
                    'misma_vivienda'     => $this->input->post('con_padre'),
                    'ciudad'             => $this->input->post('ciudad_padre'),
                    'empresa'            => $this->input->post('empresa_padre'),
                    'puesto'             => $this->input->post('puesto_padre'),
                ];
                $this->candidato_model->guardarFamiliar($data_padre);
            }
            if ($this->input->post('nombre_madre') != '' && $this->input->post('nombre_madre') != null) {
                $data_madre = [
                    'creacion'           => $date,
                    'edicion'            => $date,
                    'id_candidato'       => $id_candidato,
                    'nombre'             => $this->input->post('nombre_madre'),
                    'id_tipo_parentesco' => 2,
                    'edad'               => $this->input->post('edad_madre'),
                    'estado_civil'       => null,
                    'id_grado_estudio'   => 11,
                    'misma_vivienda'     => $this->input->post('con_madre'),
                    'ciudad'             => $this->input->post('ciudad_madre'),
                    'empresa'            => $this->input->post('empresa_madre'),
                    'puesto'             => $this->input->post('puesto_madre'),
                ];
                $this->candidato_model->guardarFamiliar($data_madre);
            }
            if ($this->input->post('num_hermanos') > 0) {
                $num_hermanos = $this->input->post('num_hermanos');
                for ($i = 1; $i <= $num_hermanos; $i++) {
                    if ($this->input->post('nombre_hermano' . $i) != '') {
                        $data_hermano = [
                            'creacion'           => $date,
                            'edicion'            => $date,
                            'id_candidato'       => $id_candidato,
                            'nombre'             => $this->input->post('nombre_hermano' . $i),
                            'id_tipo_parentesco' => 6,
                            'edad'               => $this->input->post('edad_hermano' . $i),
                            'estado_civil'       => null,
                            'id_grado_estudio'   => 11,
                            'misma_vivienda'     => $this->input->post('con_hermano' . $i),
                            'ciudad'             => $this->input->post('ciudad_hermano' . $i),
                            'empresa'            => $this->input->post('empresa_hermano' . $i),
                            'puesto'             => $this->input->post('puesto_hermano' . $i),
                        ];
                        $this->candidato_model->guardarFamiliar($data_hermano);
                    }
                }
            }

            $this->candidato_model->eliminarEstudios($id_candidato);
            $data_estudios = [
                'creacion'                 => $date,
                'edicion'                  => $date,
                'id_candidato'             => $id_candidato,
                'primaria_periodo'         => $this->input->post('prim_periodo'),
                'primaria_escuela'         => $this->input->post('prim_escuela'),
                'primaria_ciudad'          => $this->input->post('prim_ciudad'),
                'primaria_certificado'     => $this->input->post('prim_certificado'),
                'secundaria_periodo'       => $this->input->post('sec_periodo'),
                'secundaria_escuela'       => $this->input->post('sec_escuela'),
                'secundaria_ciudad'        => $this->input->post('sec_ciudad'),
                'secundaria_certificado'   => $this->input->post('sec_certificado'),
                'preparatoria_periodo'     => $this->input->post('prep_periodo'),
                'preparatoria_escuela'     => $this->input->post('prep_escuela'),
                'preparatoria_ciudad'      => $this->input->post('prep_ciudad'),
                'preparatoria_certificado' => $this->input->post('prep_certificado'),
                'licenciatura_periodo'     => $this->input->post('lic_periodo'),
                'licenciatura_escuela'     => $this->input->post('lic_escuela'),
                'licenciatura_ciudad'      => $this->input->post('lic_ciudad'),
                'licenciatura_certificado' => $this->input->post('lic_certificado'),
                'otros_certificados'       => $this->input->post('otro_certificado'),
                'carrera_inactivo'         => $this->input->post('carrera_inactivo'),
            ];
            $this->candidato_model->guardarEstudios($data_estudios);

            $this->candidato_model->eliminarReferenciasLaborales($id_candidato);
            if ($datos_candidato->id_cliente != 172 && $datos_candidato->id_cliente != 178) {
                $num_trabajos = 2;
                if ($this->input->post('proyecto') == 'ESE-WORLD CHECK') {
                    $num_trabajos = 3;
                }
            } else {
                $num_trabajos = 6;
            }
            if ($this->input->post('proyecto') == 'International Check') {
                $campo_entrada  = 'fecha_entrada_txt';
                $campo_salida   = 'fecha_salida_txt';
                $campo_salario1 = 'salario1_txt';
                $campo_salario2 = 'salario2_txt';
            } else {
                $campo_entrada  = 'fecha_entrada';
                $campo_salida   = 'fecha_salida';
                $campo_salario1 = 'salario1';
                $campo_salario2 = 'salario2';
            }
            for ($k = 1; $k <= $num_trabajos; $k++) {
                if ($this->input->post('reflab' . $k . 'empresa') != '' && $this->input->post('reflab' . $k . 'direccion') != "") {
                    if ($this->input->post('proyecto') != 'International Check') {
                        $fentrada = fecha_ingles_bd($this->input->post('reflab' . $k . 'entrada'));
                        $fsalida  = fecha_ingles_bd($this->input->post('reflab' . $k . 'salida'));
                    } else {
                        $fentrada = $this->input->post('reflab' . $k . 'entrada');
                        $fsalida  = $this->input->post('reflab' . $k . 'salida');
                    }
                    $data_reflab                     = [];
                    $data_reflab['creacion']         = $date;
                    $data_reflab['edicion']          = $date;
                    $data_reflab['id_candidato']     = $id_candidato;
                    $data_reflab['empresa']          = ucwords(strtolower($this->input->post('reflab' . $k . 'empresa')));
                    $data_reflab['direccion']        = ucwords(strtolower($this->input->post('reflab' . $k . 'direccion')));
                    $data_reflab[$campo_entrada]     = $fentrada;
                    $data_reflab[$campo_salida]      = $fsalida;
                    $data_reflab['telefono']         = $this->input->post('reflab' . $k . 'telefono');
                    $data_reflab['puesto1']          = ucwords(strtolower($this->input->post('reflab' . $k . 'puesto1')));
                    $data_reflab['puesto2']          = ucwords(strtolower($this->input->post('reflab' . $k . 'puesto2')));
                    $data_reflab[$campo_salario1]    = $this->input->post('reflab' . $k . 'salario1');
                    $data_reflab[$campo_salario2]    = $this->input->post('reflab' . $k . 'salario2');
                    $data_reflab['jefe_nombre']      = ucwords(strtolower($this->input->post('reflab' . $k . 'bossnombre')));
                    $data_reflab['jefe_correo']      = strtolower($this->input->post('reflab' . $k . 'bosscorreo'));
                    $data_reflab['jefe_puesto']      = ucwords(strtolower($this->input->post('reflab' . $k . 'bosspuesto')));
                    $data_reflab['causa_separacion'] = $this->input->post('reflab' . $k . 'separacion');
                    $this->candidato_model->saveRefLab($data_reflab);
                    unset($data_reflab);
                }
            }

            $this->candidato_model->eliminarReferenciasPersonales($id_candidato);
            for ($j = 1; $j <= 3; $j++) {
                if ($this->input->post('refper' . $j . 'nombre') != '' && $this->input->post('refper' . $j . 'nombre') != null) {
                    $data_refper                     = [];
                    $data_refper['creacion']         = $date;
                    $data_refper['edicion']          = $date;
                    $data_refper['id_candidato']     = $id_candidato;
                    $data_refper['nombre']           = $this->input->post('refper' . $j . 'nombre');
                    $data_refper['telefono']         = $this->input->post('refper' . $j . 'telefono');
                    $data_refper['tiempo_conocerlo'] = $this->input->post('refper' . $j . 'tiempo');
                    $data_refper['donde_conocerlo']  = $this->input->post('refper' . $j . 'conocido');
                    $data_refper['sabe_trabajo']     = $this->input->post('refper' . $j . 'sabetrabajo');
                    $data_refper['sabe_vive']        = $this->input->post('refper' . $j . 'sabevive');
                    $this->candidato_model->saveRefPer($data_refper);
                    unset($data_refper);
                }
            }
            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function guardarForm2USTCandidato()
    {
        $this->form_validation->set_rules('fecha_nacimiento', 'Birhtdate', 'required|trim');
        $this->form_validation->set_rules('puesto', 'Job Position Requested', 'required|trim');
        $this->form_validation->set_rules('nacionalidad', 'Nationality', 'required|trim');
        $this->form_validation->set_rules('genero', 'Gender', 'required|trim');
        $this->form_validation->set_rules('civil', 'Marital Status', 'required|trim');
        $this->form_validation->set_rules('telefono', 'Mobile Number', 'required|trim|max_length[16]');
        $this->form_validation->set_rules('tel_casa', 'Home Number', 'trim|max_length[16]');
        $this->form_validation->set_rules('tel_otro', 'Number to leave Messages', 'trim|max_length[16]');
        $this->form_validation->set_rules('calle', 'Address', 'required|trim');
        $this->form_validation->set_rules('exterior', 'Exterior Number', 'required|trim|max_length[8]');
        $this->form_validation->set_rules('interior', 'Interior Number', 'trim|max_length[8]');
        $this->form_validation->set_rules('colonia', 'Neighborhood', 'required|trim');
        $this->form_validation->set_rules('estado', 'State', 'required|trim');
        $this->form_validation->set_rules('municipio', 'City', 'required|trim');
        $this->form_validation->set_rules('cp', 'Zip Code', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date         = date('Y-m-d H:i:s');
            $id_candidato = $this->session->userdata('id');
            $fecha        = fecha_ingles_bd($this->input->post('fecha_nacimiento'));
            $edad         = calculaEdad($fecha);
            $candidato    = [
                'fecha_contestado' => $date,
                'edicion'          => $date,
                'fecha_nacimiento' => $fecha,
                'edad'             => $edad,
                'puesto'           => $this->input->post('puesto'),
                'nacionalidad'     => $this->input->post('nacionalidad'),
                'genero'           => $this->input->post('genero'),
                'calle'            => $this->input->post('calle'),
                'exterior'         => $this->input->post('exterior'),
                'interior'         => $this->input->post('interior'),
                'colonia'          => $this->input->post('colonia'),
                'id_estado'        => $this->input->post('estado'),
                'id_municipio'     => $this->input->post('municipio'),
                'cp'               => $this->input->post('cp'),
                'estado_civil'     => $this->input->post('civil'),
                'celular'          => $this->input->post('telefono'),
                'telefono_casa'    => $this->input->post('tel_casa'),
                'telefono_otro'    => $this->input->post('tel_otro'),
                'status'           => 1,
            ];
            $this->candidato_model->editarCandidato($candidato, $id_candidato);

            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function guardarFormSimple()
    {
        $this->form_validation->set_rules('fecha_nacimiento', 'Birhtdate', 'required|trim');
        $this->form_validation->set_rules('puesto', 'Job Position Requested', 'required|trim');
        $this->form_validation->set_rules('nacionalidad', 'Nationality', 'required|trim');
        $this->form_validation->set_rules('genero', 'Gender', 'required|trim');
        $this->form_validation->set_rules('civil', 'Marital Status', 'required|trim');
        $this->form_validation->set_rules('telefono', 'Mobile Number', 'required|trim|max_length[16]');
        $this->form_validation->set_rules('tel_casa', 'Home Number', 'trim|max_length[16]');
        $this->form_validation->set_rules('tel_otro', 'Number to leave Messages', 'trim|max_length[16]');
        $this->form_validation->set_rules('domicilio_completo', 'Address', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date         = date('Y-m-d H:i:s');
            $id_candidato = $this->session->userdata('id');
            $fecha        = fecha_ingles_bd($this->input->post('fecha_nacimiento'));
            $edad         = calculaEdad($fecha);
            $candidato    = [
                'fecha_contestado'        => $date,
                'edicion'                 => $date,
                'fecha_nacimiento'        => $fecha,
                'edad'                    => $edad,
                'puesto'                  => $this->input->post('puesto'),
                'nacionalidad'            => $this->input->post('nacionalidad'),
                'genero'                  => $this->input->post('genero'),
                'domicilio_internacional' => $this->input->post('domicilio_completo'),
                'estado_civil'            => $this->input->post('civil'),
                'celular'                 => $this->input->post('telefono'),
                'telefono_casa'           => $this->input->post('tel_casa'),
                'telefono_otro'           => $this->input->post('tel_otro'),
                'status'                  => 1,
            ];
            $this->candidato_model->editarCandidato($candidato, $id_candidato);

            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function guardarFormSubclienteCandidato()
    {
        $this->form_validation->set_rules('fecha_nacimiento', 'Birhtdate', 'required|trim');
        $this->form_validation->set_rules('puesto', 'Job Position Requested', 'required|trim');
        $this->form_validation->set_rules('nacionalidad', 'Nationality', 'required|trim');
        $this->form_validation->set_rules('genero', 'Gender', 'required|trim');
        $this->form_validation->set_rules('civil', 'Marital Status', 'required|trim');
        $this->form_validation->set_rules('telefono', 'Mobile Number', 'required|trim|max_length[16]');
        $this->form_validation->set_rules('tel_casa', 'Home Number', 'trim|max_length[16]');
        $this->form_validation->set_rules('domicilio', 'Complete address', 'trim');
        $this->form_validation->set_rules('calles', 'Surrounding streets', 'trim');
        $this->form_validation->set_rules('calle', 'Address', 'trim');
        $this->form_validation->set_rules('exterior', 'Exterior Number', 'trim|max_length[8]');
        $this->form_validation->set_rules('interior', 'Interior Number', 'trim|max_length[8]');
        $this->form_validation->set_rules('colonia', 'Neighborhood', 'trim');
        $this->form_validation->set_rules('estado', 'State', 'trim');
        $this->form_validation->set_rules('municipio', 'City', 'trim');
        $this->form_validation->set_rules('cp', 'Zip Code', 'trim');
        $this->form_validation->set_rules('estudios', 'Highest studies', 'required|trim');
        $this->form_validation->set_rules('estudios_periodo', 'Period of the Highest studies', 'required|trim');
        $this->form_validation->set_rules('estudios_escuela', 'Institute of the Highest studies', 'required|trim');
        $this->form_validation->set_rules('estudios_ciudad', 'City of the Highest studies', 'required|trim');
        $this->form_validation->set_rules('estudios_certificado', 'Certificate Obtained of the Highest studies', 'required|trim');
        $this->form_validation->set_rules('inicio_gap1', 'Start date of break', 'required|trim');
        $this->form_validation->set_rules('fin_gap1', 'End date of break', 'required|trim');
        $this->form_validation->set_rules('comentario_gap1', 'Reason and activities of break', 'required|trim');
        $this->form_validation->set_rules('comentarios_candidato', 'Your Comments', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date          = date('Y-m-d H:i:s');
            $id_candidato  = $this->session->userdata('id');
            $fecha         = fecha_ingles_bd($this->input->post('fecha_nacimiento'));
            $cantidad_gaps = $this->input->post('cantidad_gaps');
            $edad          = calculaEdad($fecha);
            $candidato     = [
                'fecha_contestado'        => $date,
                'edicion'                 => $date,
                'fecha_nacimiento'        => $fecha,
                'edad'                    => $edad,
                'puesto'                  => $this->input->post('puesto'),
                'nacionalidad'            => $this->input->post('nacionalidad'),
                'genero'                  => $this->input->post('genero'),
                'domicilio_internacional' => $this->input->post('domicilio'),
                'calle'                   => $this->input->post('calle'),
                'exterior'                => $this->input->post('exterior'),
                'interior'                => $this->input->post('interior'),
                'colonia'                 => $this->input->post('colonia'),
                'id_estado'               => $this->input->post('estado'),
                'id_municipio'            => $this->input->post('municipio'),
                'cp'                      => $this->input->post('cp'),
                'estado_civil'            => $this->input->post('civil'),
                'celular'                 => $this->input->post('telefono'),
                'telefono_casa'           => $this->input->post('tel_casa'),
                'entre_calles'            => $this->input->post('calles'),
                'id_grado_estudio'        => $this->input->post('estudios'),
                'estudios_periodo'        => $this->input->post('estudios_periodo'),
                'estudios_escuela'        => $this->input->post('estudios_escuela'),
                'estudios_ciudad'         => $this->input->post('estudios_ciudad'),
                'estudios_certificado'    => $this->input->post('estudios_certificado'),
                'comentario'              => $this->input->post('comentarios_candidato'),
                'status'                  => 1,
            ];
            $this->candidato_model->editarCandidato($candidato, $id_candidato);

            $this->candidato_model->eliminarReferenciasLaborales($id_candidato);
            for ($k = 1; $k <= 10; $k++) {
                if ($this->input->post('reflab' . $k . 'empresa') != '' && $this->input->post('reflab' . $k . 'direccion') != "") {
                    $data_reflab                      = [];
                    $data_reflab['creacion']          = $date;
                    $data_reflab['edicion']           = $date;
                    $data_reflab['id_candidato']      = $id_candidato;
                    $data_reflab['empresa']           = ucwords(strtolower($this->input->post('reflab' . $k . 'empresa')));
                    $data_reflab['direccion']         = ucwords(strtolower($this->input->post('reflab' . $k . 'direccion')));
                    $data_reflab['fecha_entrada_txt'] = $this->input->post('reflab' . $k . 'entrada');
                    $data_reflab['fecha_salida_txt']  = $this->input->post('reflab' . $k . 'salida');
                    $data_reflab['telefono']          = $this->input->post('reflab' . $k . 'telefono');
                    $data_reflab['puesto1']           = ucwords(strtolower($this->input->post('reflab' . $k . 'puesto1')));
                    $data_reflab['puesto2']           = ucwords(strtolower($this->input->post('reflab' . $k . 'puesto2')));
                    $data_reflab['salario1_txt']      = $this->input->post('reflab' . $k . 'salario1');
                    $data_reflab['salario2_txt']      = $this->input->post('reflab' . $k . 'salario2');
                    $data_reflab['jefe_nombre']       = ucwords(strtolower($this->input->post('reflab' . $k . 'bossnombre')));
                    $data_reflab['jefe_correo']       = strtolower($this->input->post('reflab' . $k . 'bosscorreo'));
                    $data_reflab['jefe_puesto']       = ucwords(strtolower($this->input->post('reflab' . $k . 'bosspuesto')));
                    $data_reflab['causa_separacion']  = $this->input->post('reflab' . $k . 'separacion');
                    $this->candidato_model->saveRefLab($data_reflab);
                    unset($data_reflab);
                }
            }

            for ($i = 1; $i <= $cantidad_gaps; $i++) {
                if ($this->input->post('inicio_gap' . $i) != '' && $this->input->post('fin_gap' . $i) != '' && $this->input->post('comentario_gap' . $i) != '') {
                    $gaps = [
                        'creacion'     => $date,
                        'edicion'      => $date,
                        'id_candidato' => $id_candidato,
                        'fecha_inicio' => $this->input->post('inicio_gap' . $i),
                        'fecha_fin'    => $this->input->post('fin_gap' . $i),
                        'razon'        => $this->input->post('comentario_gap' . $i),
                    ];
                    $this->candidato_model->guardarGap($gaps);
                }
            }

            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function guardarFormHCLCandidato()
    {
        /*$this->form_validation->set_rules('fecha_nacimiento', 'Birhtdate', 'required|trim');
        $this->form_validation->set_rules('puesto', 'Job Position Requested', 'required|trim');
        $this->form_validation->set_rules('nacionalidad', 'Nationality', 'required|trim');
        $this->form_validation->set_rules('genero', 'Gender', 'required|trim');
        $this->form_validation->set_rules('civil', 'Marital Status', 'required|trim');
        $this->form_validation->set_rules('telefono', 'Mobile Number', 'required|trim|max_length[16]');
        $this->form_validation->set_rules('tel_casa', 'Home Number', 'trim|max_length[16]');
        $this->form_validation->set_rules('tel_otro', 'Number to leave Messages', 'trim|max_length[16]');
        $this->form_validation->set_rules('calle', 'Address', 'required|trim');
        $this->form_validation->set_rules('exterior', 'Exterior Number', 'required|trim|max_length[8]');
        $this->form_validation->set_rules('interior', 'Interior Number', 'trim|max_length[8]');
        $this->form_validation->set_rules('colonia', 'Neighborhood', 'required|trim');
        $this->form_validation->set_rules('estado', 'State', 'required|trim');
        $this->form_validation->set_rules('municipio', 'City', 'required|trim');
        $this->form_validation->set_rules('cp', 'Zip Code', 'required|trim');
        $this->form_validation->set_rules('estudios', 'Highest studies', 'required|trim');
        $this->form_validation->set_rules('estudios_periodo', 'Period of the Highest studies', 'required|trim');
        $this->form_validation->set_rules('estudios_escuela', 'Institute of the Highest studies', 'required|trim');
        $this->form_validation->set_rules('estudios_ciudad', 'City of the Highest studies', 'required|trim');
        $this->form_validation->set_rules('estudios_certificado', 'Certificate Obtained of the Highest studies', 'required|trim');
        $this->form_validation->set_rules('trabajo_inactivo', 'Break(s) in Employment', 'required|trim');*/
        $this->form_validation->set_rules('comentarios_candidato', 'Your Comments', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date         = date('Y-m-d H:i:s');
            $id_candidato = $this->session->userdata('id');
            $secciones    = $this->candidato_model->getSeccionesCandidato($id_candidato);

            if ($secciones->id_seccion_datos_generales != null) {
                $fecha     = fecha_espanol_bd($this->input->post('fecha_nacimiento'));
                $edad      = calculaEdad($fecha);
                $candidato = [
                    'fecha_contestado' => $date,
                    'edicion'          => $date,
                    'fecha_nacimiento' => $fecha,
                    'edad'             => $edad,
                    'puesto'           => $this->input->post('puesto'),
                    'nacionalidad'     => $this->input->post('nacionalidad'),
                    'genero'           => $this->input->post('genero'),
                    'calle'            => $this->input->post('calle'),
                    'exterior'         => $this->input->post('exterior'),
                    'interior'         => $this->input->post('interior'),
                    'colonia'          => $this->input->post('colonia'),
                    'id_estado'        => $this->input->post('estado'),
                    'id_municipio'     => $this->input->post('municipio'),
                    'cp'               => $this->input->post('cp'),
                    'estado_civil'     => $this->input->post('civil'),
                    'celular'          => $this->input->post('telefono'),
                    'telefono_casa'    => $this->input->post('tel_casa'),
                    'telefono_otro'    => $this->input->post('tel_otro'),
                    'curp'             => $this->input->post('curp'),
                    'comentario'       => $this->input->post('comentarios_candidato'),
                    'status'           => 1,
                ];
                $this->candidato_model->editarCandidato($candidato, $id_candidato);
            }

            if ($secciones->lleva_estudios == 1) {
                $candidato = [
                    'fecha_contestado'     => $date,
                    'edicion'              => $date,
                    'id_grado_estudio'     => $this->input->post('estudios'),
                    'estudios_periodo'     => $this->input->post('estudios_periodo'),
                    'estudios_escuela'     => $this->input->post('estudios_escuela'),
                    'estudios_ciudad'      => $this->input->post('estudios_ciudad'),
                    'estudios_certificado' => $this->input->post('estudios_certificado'),
                    'status'               => 1,
                ];
                $this->candidato_model->editarCandidato($candidato, $id_candidato);
            }

            if ($secciones->id_seccion_datos_generales == null && $secciones->lleva_estudios == 0) {
                $candidato = [
                    'fecha_contestado' => $date,
                    'edicion'          => $date,
                    'comentario'       => $this->input->post('comentarios_candidato'),
                    'status'           => 1,
                ];
                $this->candidato_model->editarCandidato($candidato, $id_candidato);
            }

            if ($secciones->lleva_empleos == 1) {
                $this->candidato_model->eliminarReferenciasLaborales($id_candidato);
                for ($k = 1; $k <= 25; $k++) {
                    if ($this->input->post('reflab' . $k . 'empresa') != '') {
                        //$fentrada = fecha_espanol_bd($this->input->post('reflab'.$k.'entrada'));
                        //$fsalida = fecha_espanol_bd($this->input->post('reflab'.$k.'salida'));
                        $data_reflab                      = [];
                        $data_reflab['creacion']          = $date;
                        $data_reflab['edicion']           = $date;
                        $data_reflab['id_candidato']      = $id_candidato;
                        $data_reflab['empresa']           = ucwords(strtolower($this->input->post('reflab' . $k . 'empresa')));
                        $data_reflab['direccion']         = ucwords(strtolower($this->input->post('reflab' . $k . 'direccion')));
                        $data_reflab['fecha_entrada_txt'] = $this->input->post('reflab' . $k . 'entrada');
                        $data_reflab['fecha_salida_txt']  = $this->input->post('reflab' . $k . 'salida');
                        $data_reflab['telefono']          = $this->input->post('reflab' . $k . 'telefono');
                        $data_reflab['puesto1']           = ucwords(strtolower($this->input->post('reflab' . $k . 'puesto1')));
                        $data_reflab['puesto2']           = ucwords(strtolower($this->input->post('reflab' . $k . 'puesto2')));
                        $data_reflab['salario1']          = $this->input->post('reflab' . $k . 'salario1');
                        $data_reflab['salario2']          = $this->input->post('reflab' . $k . 'salario2');
                        $data_reflab['jefe_nombre']       = ucwords(strtolower($this->input->post('reflab' . $k . 'bossnombre')));
                        $data_reflab['jefe_correo']       = strtolower($this->input->post('reflab' . $k . 'bosscorreo'));
                        $data_reflab['jefe_puesto']       = ucwords(strtolower($this->input->post('reflab' . $k . 'bosspuesto')));
                        $data_reflab['causa_separacion']  = $this->input->post('reflab' . $k . 'separacion');
                        $this->candidato_model->saveRefLab($data_reflab);
                        unset($data_reflab);
                    }
                }

                $candidato = [
                    'trabajo_inactivo' => $this->input->post('trabajo_inactivo'),
                ];
                $this->candidato_model->editarCandidato($candidato, $id_candidato);
            }

            if ($secciones->lleva_domicilios == 1) {
                $this->candidato_model->eliminarHistorialDomicilios($id_candidato);
                for ($i = 1; $i <= 15; $i++) {
                    if ($this->input->post('h' . $i . 'periodo') !== '' && $this->input->post('h' . $i . 'causa') !== '' && $this->input->post('h' . $i . 'periodo') !== 'undefined' && $this->input->post('h' . $i . 'causa') !== 'undefined') {
                        $domicilios                 = [];
                        $domicilios['creacion']     = $date;
                        $domicilios['edicion']      = $date;
                        $domicilios['id_candidato'] = $id_candidato;
                        $domicilios['periodo']      = $this->input->post('h' . $i . 'periodo');
                        $domicilios['causa']        = $this->input->post('h' . $i . 'causa');
                        $domicilios['calle']        = $this->input->post('h' . $i . 'calle');
                        $domicilios['exterior']     = $this->input->post('h' . $i . 'exterior');
                        $domicilios['interior']     = $this->input->post('h' . $i . 'interior');
                        $domicilios['colonia']      = $this->input->post('h' . $i . 'colonia');
                        $domicilios['id_estado']    = $this->input->post('h' . $i . 'estado');
                        $domicilios['id_municipio'] = $this->input->post('h' . $i . 'municipio');
                        $domicilios['cp']           = $this->input->post('h' . $i . 'cp');
                        $this->candidato_model->saveDomicilio($domicilios);
                        unset($domicilios);
                    }
                }
            }

            if ($secciones->cantidad_ref_profesionales > 0) {
                $this->candidato_model->eliminarReferenciasProfesionales($id_candidato);
                $seccion = $this->candidato_model->getSeccionesCandidato($id_candidato);
                for ($i = 1; $i <= $seccion->cantidad_ref_profesionales; $i++) {
                    if ($this->input->post('refpro' . $i . 'nombre') !== '' && $this->input->post('refpro' . $i . 'nombre') !== 'undefined') {
                        $refpro                     = [];
                        $refpro['creacion']         = $date;
                        $refpro['numero']           = $i;
                        $refpro['id_candidato']     = $id_candidato;
                        $refpro['nombre']           = $this->input->post('refpro' . $i . 'nombre');
                        $refpro['telefono']         = $this->input->post('refpro' . $i . 'telefono');
                        $refpro['tiempo_conocerlo'] = $this->input->post('refpro' . $i . 'tiempo');
                        $refpro['donde_conocerlo']  = $this->input->post('refpro' . $i . 'conocido');
                        $refpro['puesto']           = $this->input->post('refpro' . $i . 'puesto');
                        $this->candidato_model->guardarReferenciaProfesional($refpro);
                        unset($refpro);
                    }
                }
            }

            if ($secciones->cantidad_ref_personales > 0) {
                $this->candidato_model->eliminarReferenciasPersonales($id_candidato);
                $seccion = $this->candidato_model->getSeccionesCandidato($id_candidato);
                for ($j = 1; $j <= $seccion->cantidad_ref_personales; $j++) {
                    if ($this->input->post('refper' . $j . 'nombre') != '') {
                        $data_refper                     = [];
                        $data_refper['creacion']         = $date;
                        $data_refper['edicion']          = $date;
                        $data_refper['id_candidato']     = $id_candidato;
                        $data_refper['nombre']           = $this->input->post('refper' . $j . 'nombre');
                        $data_refper['telefono']         = $this->input->post('refper' . $j . 'telefono');
                        $data_refper['tiempo_conocerlo'] = $this->input->post('refper' . $j . 'tiempo');
                        $data_refper['donde_conocerlo']  = $this->input->post('refper' . $j . 'conocido');
                        $data_refper['sabe_trabajo']     = $this->input->post('refper' . $j . 'sabetrabajo');
                        $data_refper['sabe_vive']        = $this->input->post('refper' . $j . 'sabevive');
                        $this->candidato_model->saveRefPer($data_refper);
                        unset($data_refper);
                    }
                }
            }

            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function guardarInternationalFormHCLCandidato()
    {
        /*$this->form_validation->set_rules('fecha_nacimiento', 'Birhtdate', 'required|trim');
        $this->form_validation->set_rules('puesto', 'Job Position Requested', 'required|trim');
        $this->form_validation->set_rules('nacionalidad', 'Nationality', 'required|trim');
        $this->form_validation->set_rules('genero', 'Gender', 'required|trim');
        $this->form_validation->set_rules('civil', 'Marital Status', 'required|trim');
        $this->form_validation->set_rules('telefono', 'Mobile Number', 'required|trim|max_length[16]');
        $this->form_validation->set_rules('tel_casa', 'Home Number', 'trim|max_length[16]');
        $this->form_validation->set_rules('tel_otro', 'Number to leave Messages', 'trim|max_length[16]');
        $this->form_validation->set_rules('domicilio', 'Address', 'required|trim');
        $this->form_validation->set_rules('pais', 'Country', 'required|trim');
        $this->form_validation->set_rules('estudios', 'Highest studies', 'required|trim');
        $this->form_validation->set_rules('estudios_periodo', 'Period of the Highest studies', 'required|trim');
        $this->form_validation->set_rules('estudios_escuela', 'Institute of the Highest studies', 'required|trim');
        $this->form_validation->set_rules('estudios_ciudad', 'City of the Highest studies', 'required|trim');
        $this->form_validation->set_rules('estudios_certificado', 'Certificate Obtained of the Highest studies', 'required|trim');
        $this->form_validation->set_rules('trabajo_inactivo', 'Break(s) in Employment', 'required|trim');*/
        $this->form_validation->set_rules('comentarios_candidato', 'Your Comments', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');
        $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');

        $msj = [];
        if ($this->form_validation->run() == false) {
            $msj = [
                'codigo' => 0,
                'msg'    => validation_errors(),
            ];
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date         = date('Y-m-d H:i:s');
            $id_candidato = $this->session->userdata('id');
            $secciones    = $this->candidato_model->getSeccionesCandidato($id_candidato);

            if ($secciones->id_seccion_datos_generales != null) {
                $fecha     = fecha_espanol_bd($this->input->post('fecha_nacimiento'));
                $edad      = calculaEdad($fecha);
                $candidato = [
                    'fecha_contestado'        => $date,
                    'edicion'                 => $date,
                    'fecha_nacimiento'        => $fecha,
                    'edad'                    => $edad,
                    'puesto'                  => $this->input->post('puesto'),
                    'nacionalidad'            => $this->input->post('nacionalidad'),
                    'genero'                  => $this->input->post('genero'),
                    'domicilio_internacional' => $this->input->post('domicilio'),
                    'pais'                    => $this->input->post('pais'),
                    'estado_civil'            => $this->input->post('civil'),
                    'celular'                 => $this->input->post('telefono'),
                    'telefono_casa'           => $this->input->post('tel_casa'),
                    'telefono_otro'           => $this->input->post('tel_otro'),
                    'comentario'              => $this->input->post('comentarios_candidato'),
                    'status'                  => 1,
                ];
                $this->candidato_model->editarCandidato($candidato, $id_candidato);
            }

            if ($secciones->lleva_estudios == 1) {
                $candidato = [
                    'fecha_contestado'     => $date,
                    'edicion'              => $date,
                    'id_grado_estudio'     => $this->input->post('estudios'),
                    'estudios_periodo'     => $this->input->post('estudios_periodo'),
                    'estudios_escuela'     => $this->input->post('estudios_escuela'),
                    'estudios_ciudad'      => $this->input->post('estudios_ciudad'),
                    'estudios_certificado' => $this->input->post('estudios_certificado'),
                    'status'               => 1,
                ];
                $this->candidato_model->editarCandidato($candidato, $id_candidato);
            }

            if ($secciones->id_seccion_datos_generales == null && $secciones->lleva_estudios == 0) {
                $candidato = [
                    'fecha_contestado' => $date,
                    'edicion'          => $date,
                    'comentario'       => $this->input->post('comentarios_candidato'),
                    'status'           => 1,
                ];
                $this->candidato_model->editarCandidato($candidato, $id_candidato);
            }

            if ($secciones->lleva_empleos == 1) {
                $this->candidato_model->eliminarReferenciasLaborales($id_candidato);
                for ($k = 1; $k <= 25; $k++) {
                    if ($this->input->post('reflab' . $k . 'empresa') != '') {
                        //$fentrada = fecha_espanol_bd($this->input->post('reflab'.$k.'entrada'));
                        //$fsalida = fecha_espanol_bd($this->input->post('reflab'.$k.'salida'));
                        $data_reflab                      = [];
                        $data_reflab['creacion']          = $date;
                        $data_reflab['edicion']           = $date;
                        $data_reflab['id_candidato']      = $id_candidato;
                        $data_reflab['empresa']           = ucwords(strtolower($this->input->post('reflab' . $k . 'empresa')));
                        $data_reflab['direccion']         = ucwords(strtolower($this->input->post('reflab' . $k . 'direccion')));
                        $data_reflab['fecha_entrada_txt'] = $this->input->post('reflab' . $k . 'entrada');
                        $data_reflab['fecha_salida_txt']  = $this->input->post('reflab' . $k . 'salida');
                        $data_reflab['telefono']          = $this->input->post('reflab' . $k . 'telefono');
                        $data_reflab['puesto1']           = ucwords(strtolower($this->input->post('reflab' . $k . 'puesto1')));
                        $data_reflab['puesto2']           = ucwords(strtolower($this->input->post('reflab' . $k . 'puesto2')));
                        $data_reflab['salario1']          = $this->input->post('reflab' . $k . 'salario1');
                        $data_reflab['salario2']          = $this->input->post('reflab' . $k . 'salario2');
                        $data_reflab['jefe_nombre']       = ucwords(strtolower($this->input->post('reflab' . $k . 'bossnombre')));
                        $data_reflab['jefe_correo']       = strtolower($this->input->post('reflab' . $k . 'bosscorreo'));
                        $data_reflab['jefe_puesto']       = ucwords(strtolower($this->input->post('reflab' . $k . 'bosspuesto')));
                        $data_reflab['causa_separacion']  = $this->input->post('reflab' . $k . 'separacion');
                        $this->candidato_model->saveRefLab($data_reflab);
                        unset($data_reflab);
                    }
                }

                $candidato = [
                    'trabajo_inactivo' => $this->input->post('trabajo_inactivo'),
                ];
                $this->candidato_model->editarCandidato($candidato, $id_candidato);
            }

            if ($secciones->lleva_domicilios == 1) {
                $this->candidato_model->eliminarHistorialDomicilios($id_candidato);
                for ($i = 1; $i <= 15; $i++) {
                    if ($this->input->post('h' . $i . 'periodo') !== '' && $this->input->post('h' . $i . 'causa') !== '' && $this->input->post('h' . $i . 'periodo') !== 'undefined' && $this->input->post('h' . $i . 'causa') !== 'undefined') {
                        $domicilios                            = [];
                        $domicilios['creacion']                = $date;
                        $domicilios['edicion']                 = $date;
                        $domicilios['id_candidato']            = $id_candidato;
                        $domicilios['periodo']                 = $this->input->post('h' . $i . 'periodo');
                        $domicilios['causa']                   = $this->input->post('h' . $i . 'causa');
                        $domicilios['domicilio_internacional'] = $this->input->post('h' . $i . 'domicilio');
                        $domicilios['pais']                    = $this->input->post('h' . $i . 'pais');
                        $this->candidato_model->saveDomicilio($domicilios);
                        unset($domicilios);
                    }
                }
            }

            if ($secciones->cantidad_ref_profesionales > 0) {
                $this->candidato_model->eliminarReferenciasProfesionales($id_candidato);
                $seccion = $this->candidato_model->getSeccionesCandidato($id_candidato);
                for ($i = 1; $i <= $seccion->cantidad_ref_profesionales; $i++) {
                    if ($this->input->post('refpro' . $i . 'nombre') !== '' && $this->input->post('refpro' . $i . 'nombre') !== 'undefined') {
                        $refpro                     = [];
                        $refpro['creacion']         = $date;
                        $refpro['numero']           = $i;
                        $refpro['id_candidato']     = $id_candidato;
                        $refpro['nombre']           = $this->input->post('refpro' . $i . 'nombre');
                        $refpro['telefono']         = $this->input->post('refpro' . $i . 'telefono');
                        $refpro['tiempo_conocerlo'] = $this->input->post('refpro' . $i . 'tiempo');
                        $refpro['donde_conocerlo']  = $this->input->post('refpro' . $i . 'conocido');
                        $refpro['puesto']           = $this->input->post('refpro' . $i . 'puesto');
                        $this->candidato_model->guardarReferenciaProfesional($refpro);
                        unset($refpro);
                    }
                }
            }

            if ($secciones->cantidad_ref_personales > 0) {
                $this->candidato_model->eliminarReferenciasPersonales($id_candidato);
                $seccion = $this->candidato_model->getSeccionesCandidato($id_candidato);
                for ($j = 1; $j <= $seccion->cantidad_ref_personales; $j++) {
                    if ($this->input->post('refper' . $j . 'nombre') != '') {
                        $data_refper                     = [];
                        $data_refper['creacion']         = $date;
                        $data_refper['edicion']          = $date;
                        $data_refper['id_candidato']     = $id_candidato;
                        $data_refper['nombre']           = $this->input->post('refper' . $j . 'nombre');
                        $data_refper['telefono']         = $this->input->post('refper' . $j . 'telefono');
                        $data_refper['tiempo_conocerlo'] = $this->input->post('refper' . $j . 'tiempo');
                        $data_refper['donde_conocerlo']  = $this->input->post('refper' . $j . 'conocido');
                        $data_refper['sabe_trabajo']     = $this->input->post('refper' . $j . 'sabetrabajo');
                        $data_refper['sabe_vive']        = $this->input->post('refper' . $j . 'sabevive');
                        $this->candidato_model->saveRefPer($data_refper);
                        unset($data_refper);
                    }
                }
            }

            $msj = [
                'codigo' => 1,
                'msg'    => 'success',
            ];
        }
        echo json_encode($msj);
    }
    public function finalizarDocumentacionCandidato()
    {
        date_default_timezone_set('America/Mexico_City');
        $date         = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $band         = 1;
        //$seccion = $this->candidato_model->getSeccionesCandidato($id_candidato);
        //$data['docs_requeridos'] = $this->candidato_model->getDocumentacionSeccion($seccion->id_seccion_verificacion_docs);
        $data['docs_requeridos'] = $this->candidato_model->getDocumentosCandidatoRequeridos($id_candidato);
        foreach ($data['docs_requeridos'] as $requerido) {
            if ($requerido->obligatorio == 1 && $requerido->solicitado == 1) {
                $res = $this->candidato_model->matchDocumento($id_candidato, $requerido->id_tipo_documento);
                if ($res == 0) {
                    $band--;
                    break;
                }
            }
        }
        if ($band == 1) {
            $candidato = $this->candidato_model->getInfoCandidatoEspecifico($id_candidato);
            if ($candidato->fecha_contestado != null) {
                $candidato = [
                    "token"            => "completo",
                    "fecha_documentos" => $date,
                ];
                $this->candidato_model->editarCandidato($candidato, $id_candidato);
                $msj = [
                    'codigo' => 1,
                    'msg'    => 'Success',
                ];
            } else {
                $msj = [
                    'codigo' => 0,
                    'msg'    => 'The form has not been uploaded',
                ];
            }
        } else {
            $msj = [
                'codigo' => 0,
                'msg'    => 'Upload all required documents',
            ];
        }
        echo json_encode($msj);
    }
    public function finalizarDocumentacionCandidatoAnterior()
    {
        date_default_timezone_set('America/Mexico_City');
        $date         = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $band         = 1;
        $data['docs'] = $this->candidato_model->getDocumentacionCandidato($id_candidato);
        if ($data['docs']) {
            foreach ($data['docs'] as $doc) {
                $docs[] = $doc->id_tipo_documento;
            }
            if ($this->session->userdata('idcliente') == 172) {
                $ine      = (in_array(3, $docs)) ? 1 : 0;
                $semanas  = (in_array(9, $docs)) ? 1 : 0;
                $estudios = (in_array(7, $docs) || in_array(10, $docs)) ? 1 : 0;

                if ($ine == 1 && $estudios == 1 && $semanas == 1) {
                    $candidato = [
                        "token"            => "completo",
                        "fecha_documentos" => $date,
                    ];
                    $this->candidato_model->editarCandidato($candidato, $id_candidato);
                    $msj = [
                        'codigo' => 1,
                        'msg'    => 'Success',
                    ];
                } else {
                    $msj = [
                        'codigo' => 0,
                        'msg'    => 'Upload all required documents',
                    ];
                }
            }
            if ($this->session->userdata('idcliente') == 178) {
                $ine      = (in_array(3, $docs)) ? 1 : 0;
                $semanas  = (in_array(9, $docs)) ? 1 : 0;
                $estudios = (in_array(7, $docs) || in_array(10, $docs)) ? 1 : 0;
                $mvr      = (in_array(44, $docs)) ? 1 : 0;

                if ($ine == 1 && $estudios == 1 && $semanas == 1) {
                    $candidato = [
                        "token"            => "completo",
                        "fecha_documentos" => $date,
                    ];
                    $this->candidato_model->editarCandidato($candidato, $id_candidato);
                    $msj = [
                        'codigo' => 1,
                        'msg'    => 'Success',
                    ];
                } else {
                    $msj = [
                        'codigo' => 0,
                        'msg'    => 'Upload all required documents',
                    ];
                }
            }
            if ($this->session->userdata('idcliente') == 96) {
                $ine      = (in_array(3, $docs)) ? 1 : 0;
                $semanas  = (in_array(9, $docs)) ? 1 : 0;
                $estudios = (in_array(7, $docs) || in_array(10, $docs)) ? 1 : 0;

                if ($ine == 1 && $estudios == 1 && $semanas == 1) {
                    $candidato = [
                        "token"            => "completo",
                        "fecha_documentos" => $date,
                    ];
                    $this->candidato_model->editarCandidato($candidato, $id_candidato);
                    $msj = [
                        'codigo' => 1,
                        'msg'    => 'Success',
                    ];
                } else {
                    $msj = [
                        'codigo' => 0,
                        'msg'    => 'Upload all required documents',
                    ];
                }
            }
            if ($this->session->userdata('idcliente') == 211) {
                $ine = (in_array(3, $docs)) ? 1 : 0;
                if ($ine == 1) {
                    $candidato = [
                        "token"            => "completo",
                        "fecha_documentos" => $date,
                    ];
                    $this->candidato_model->editarCandidato($candidato, $id_candidato);
                    $msj = [
                        'codigo' => 1,
                        'msg'    => 'Success',
                    ];
                } else {
                    $msj = [
                        'codigo' => 0,
                        'msg'    => 'Upload all required documents',
                    ];
                }
            }
            if ($this->session->userdata('idcliente') == 1 || $this->session->userdata('idsubcliente') == 180 || $this->session->userdata('proyecto') == 20 || $this->session->userdata('proyecto') == 25 || $this->session->userdata('proyecto') == 26 || $this->session->userdata('proyecto') == 28) {
                if ($this->input->post('proceso') != 6) {
                    $ine      = (in_array(3, $docs)) ? 1 : 0;
                    $penales  = (in_array(12, $docs)) ? 1 : 0;
                    $semanas  = (in_array(9, $docs)) ? 1 : 0;
                    $estudios = (in_array(7, $docs) || in_array(10, $docs)) ? 1 : 0;

                    if ($ine == 1 && $estudios == 1 && $semanas == 1) {
                        $candidato = [
                            "token"            => "completo",
                            "fecha_documentos" => $date,
                        ];
                        $this->candidato_model->editarCandidato($candidato, $id_candidato);
                        $msj = [
                            'codigo' => 1,
                            'msg'    => 'Success',
                        ];
                    } else {
                        $msj = [
                            'codigo' => 0,
                            'msg'    => 'Upload all required documents',
                        ];
                    }
                }
                if ($this->session->userdata('idcliente') == 1 && $this->input->post('proceso') == 6) {
                    $ine = (in_array(3, $docs)) ? 1 : 0;

                    if ($ine == 1) {
                        $candidato = [
                            "token"            => "completo",
                            "fecha_documentos" => $date,
                        ];
                        $this->candidato_model->editarCandidato($candidato, $id_candidato);
                        $msj = [
                            'codigo' => 1,
                            'msg'    => 'Success',
                        ];
                    } else {
                        $msj = [
                            'codigo' => 0,
                            'msg'    => 'Upload all required documents',
                        ];
                    }
                }

            }
        } else {
            $msj = [
                'codigo' => 0,
                'msg'    => 'Upload all required documents',
            ];
        }
        echo json_encode($msj);
    }
    /*----------------------------------------*/
    /* Validaciones Extras
    /*----------------------------------------*/
    public function file_check($str)
    {
        $allowed_mime_type_arr = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        $mime                  = get_mime_by_extension($_FILES['documento']['name']);
        if (isset($_FILES['documento']['name']) && $_FILES['documento']['name'] != "") {
            if (in_array($mime, $allowed_mime_type_arr)) {
                return true;
            } else {
                $this->form_validation->set_message('file_check', 'Solo se permiten archivos .jpeg, .jpg, .png, .pdf');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
    }

    /*----------------------------------------*/
    /*  #Privacidad
    /*----------------------------------------*/
    public function getPrivacidad()
    {
        $id  = $this->input->post('id');
        $res = $this->candidato_model->getPrivacidad($id);
        echo $res->privacidad;
    }
    public function guardarPrivacidad()
    {
        $id   = $this->input->post('id');
        $data = [
            'privacidad' => $this->input->post('privacidad'),
        ];
        $this->candidato_model->editarCandidato($data, $id);
    }

    /*----------------------------------------*/
    /*
    /*----------------------------------------*/
    public function getCandidatos()
    {
        $cand['recordsTotal']    = $this->candidato_model->getTotalCandidatos($this->session->userdata('idcliente'));
        $cand['recordsFiltered'] = $this->candidato_model->getTotalCandidatos($this->session->userdata('idcliente'));
        $cand['data']            = $this->candidato_model->getCandidatos($this->session->userdata('idcliente'));
        $this->output->set_output(json_encode($cand));
    }
    public function getCandidatosSubcliente()
    {
        $id_subcliente          = $_GET['id_subcliente'];
        $sub['recordsTotal']    = $this->candidato_model->getCandidatosSubclienteTotal($this->session->userdata('idcliente'), $id_subcliente);
        $sub['recordsFiltered'] = $this->candidato_model->getCandidatosSubclienteTotal($this->session->userdata('idcliente'), $id_subcliente);
        $sub['data']            = $this->candidato_model->getCandidatosSubcliente($this->session->userdata('idcliente'), $id_subcliente);
        $this->output->set_output(json_encode($sub));
    }

    public function subirEstudiosCandidato()
    {
        date_default_timezone_set('America/Mexico_City');
        $date         = date('Y-m-d H:i:s');
        $id_candidato = $_POST['id_candidato'];
        $prefijo      = str_replace(' ', '', $_POST['prefijo']);
        $countfiles   = count($_FILES['estudios']['name']);

        for ($i = 0; $i < $countfiles; $i++) {
            if (! empty($_FILES['estudios']['name'][$i])) {
                // Define new $_FILES array - $_FILES['file']
                $_FILES['file']['name']     = $_FILES['estudios']['name'][$i];
                $_FILES['file']['type']     = $_FILES['estudios']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['estudios']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['estudios']['error'][$i];
                $_FILES['file']['size']     = $_FILES['estudios']['size'][$i];
                $aux2                       = str_replace(' ', '', $_FILES['estudios']['name'][$i]);
                $nombre_archivo             = str_replace('_', '', $aux2);
                // Set preference
                $config['upload_path']   = './_docs/';
                $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                $config['max_size']      = '15000'; // max_size in kb
                $config['file_name']     = $prefijo . "_" . $nombre_archivo;
                //Load upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                // File upload
                if ($this->upload->do_upload('file')) {
                    // $data = $this->upload->data();
                    echo $salida = 1;
                }
                $doc = [
                    'creacion'          => $date,
                    'edicion'           => $date,
                    'id_candidato'      => $id_candidato,
                    'id_tipo_documento' => 7,
                    'archivo'           => $prefijo . "_" . $nombre_archivo,
                ];
                $this->candidato_model->insertDocCandidato($doc);
            }
        }
    }
    public function subirAntecedenteCandidato()
    {
        //if(isset($_FILES["documento"]["name"])){
        date_default_timezone_set('America/Mexico_City');
        $date                    = date('Y-m-d H:i:s');
        $id_candidato            = $_POST['id_candidato'];
        $prefijo                 = str_replace(' ', '', $_POST['prefijo']);
        $archivos                = [];
        $aux2                    = str_replace(' ', '', $_FILES['criminal']['name']);
        $nombre_archivo          = str_replace('_', '', $aux2);
        $config['upload_path']   = './_docs/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['overwrite']     = true;
        /*$config['max_size']      = 1048;
        $config['max_width']     = 1024;
        $config['max_height']    = 768;*/
        $config['file_name'] = $prefijo . "_" . $nombre_archivo;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // File upload
        if ($this->upload->do_upload('criminal')) {
            $data        = $this->upload->data();
            echo $salida = 1;
        }

        $doc = [
            'creacion'          => $date,
            'edicion'           => $date,
            'id_candidato'      => $id_candidato,
            'id_tipo_documento' => 12,
            'archivo'           => $prefijo . "_" . $nombre_archivo,
        ];
        $this->candidato_model->insertDocCandidato($doc);
        //}
    }
    public function subirIneCandidato()
    {
        //if(isset($_FILES["documento"]["name"])){
        date_default_timezone_set('America/Mexico_City');
        $date                    = date('Y-m-d H:i:s');
        $id_candidato            = $_POST['id_candidato'];
        $prefijo                 = str_replace(' ', '', $_POST['prefijo']);
        $archivos                = [];
        $aux2                    = str_replace(' ', '', $_FILES['ine']['name']);
        $nombre_archivo          = str_replace('_', '', $aux2);
        $config['upload_path']   = './_docs/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['overwrite']     = true;
        /*$config['max_size']      = 1048;
        $config['max_width']     = 1024;
        $config['max_height']    = 768;*/
        $config['file_name'] = $prefijo . "_" . $nombre_archivo;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // File upload
        if ($this->upload->do_upload('ine')) {
            $data        = $this->upload->data();
            echo $salida = 1;
        }

        $doc = [
            'creacion'          => $date,
            'edicion'           => $date,
            'id_candidato'      => $id_candidato,
            'id_tipo_documento' => 3,
            'archivo'           => $prefijo . "_" . $nombre_archivo,
        ];
        $this->candidato_model->insertDocCandidato($doc);
        //}
    }
    public function subirAvisoCandidato()
    {
        //if(isset($_FILES["documento"]["name"])){
        date_default_timezone_set('America/Mexico_City');
        $date                    = date('Y-m-d H:i:s');
        $id_candidato            = $_POST['id_candidato'];
        $prefijo                 = str_replace(' ', '', $_POST['prefijo']);
        $archivos                = [];
        $aux2                    = str_replace(' ', '', $_FILES['aviso']['name']);
        $nombre_archivo          = str_replace('_', '', $aux2);
        $config['upload_path']   = './_docs/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['overwrite']     = true;
        /*$config['max_size']      = 1048;
        $config['max_width']     = 1024;
        $config['max_height']    = 768;*/
        $config['file_name'] = $prefijo . "_" . $nombre_archivo;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // File upload
        if ($this->upload->do_upload('aviso')) {
            $data        = $this->upload->data();
            echo $salida = 1;
        }

        $doc = [
            'creacion'          => $date,
            'edicion'           => $date,
            'id_candidato'      => $id_candidato,
            'id_tipo_documento' => 8,
            'archivo'           => $prefijo . "_" . $nombre_archivo,
        ];
        $this->candidato_model->insertDocCandidato($doc);
        //}
    }
    public function subirPasaporteCandidato()
    {
        //if(isset($_FILES["documento"]["name"])){
        date_default_timezone_set('America/Mexico_City');
        $date                    = date('Y-m-d H:i:s');
        $id_candidato            = $_POST['id_candidato'];
        $prefijo                 = str_replace(' ', '', $_POST['prefijo']);
        $archivos                = [];
        $aux2                    = str_replace(' ', '', $_FILES['pasaporte']['name']);
        $nombre_archivo          = str_replace('_', '', $aux2);
        $config['upload_path']   = './_docs/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['overwrite']     = true;
        /*$config['max_size']      = 1048;
        $config['max_width']     = 1024;
        $config['max_height']    = 768;*/
        $config['file_name'] = $prefijo . "_" . $nombre_archivo;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // File upload
        if ($this->upload->do_upload('pasaporte')) {
            $data        = $this->upload->data();
            echo $salida = 1;
        }

        $doc = [
            'creacion'          => $date,
            'edicion'           => $date,
            'id_candidato'      => $id_candidato,
            'id_tipo_documento' => 14,
            'archivo'           => $prefijo . "_" . $nombre_archivo,
        ];
        $this->candidato_model->insertDocCandidato($doc);
        //}
    }
    public function subirReporteIMSSCandidato()
    {
        date_default_timezone_set('America/Mexico_City');
        $date         = date('Y-m-d H:i:s');
        $id_candidato = $_POST['id_candidato'];
        $prefijo      = str_replace(' ', '', $_POST['prefijo']);
        $countfiles   = count($_FILES['semanas']['name']);

        for ($i = 0; $i < $countfiles; $i++) {
            if (! empty($_FILES['semanas']['name'][$i])) {
                // Define new $_FILES array - $_FILES['file']
                $_FILES['file']['name']     = $_FILES['semanas']['name'][$i];
                $_FILES['file']['type']     = $_FILES['semanas']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['semanas']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['semanas']['error'][$i];
                $_FILES['file']['size']     = $_FILES['semanas']['size'][$i];
                $aux2                       = str_replace(' ', '', $_FILES['semanas']['name'][$i]);
                $nombre_archivo             = str_replace('_', '', $aux2);
                // Set preference
                $config['upload_path']   = './_docs/';
                $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                $config['max_size']      = '15000'; // max_size in kb
                $config['file_name']     = $prefijo . "_" . $nombre_archivo;
                //Load upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                // File upload
                if ($this->upload->do_upload('file')) {
                    // $data = $this->upload->data();
                    echo $salida = 1;
                }
                $doc = [
                    'creacion'          => $date,
                    'edicion'           => $date,
                    'id_candidato'      => $id_candidato,
                    'id_tipo_documento' => 9,
                    'archivo'           => $prefijo . "_" . $nombre_archivo,
                ];
                $this->candidato_model->insertDocCandidato($doc);
            }
        }
    }
    public function subirComprobanteDomicilio()
    {
        //if(isset($_FILES["documento"]["name"])){
        date_default_timezone_set('America/Mexico_City');
        $date                    = date('Y-m-d H:i:s');
        $id_candidato            = $_POST['id_candidato'];
        $prefijo                 = str_replace(' ', '', $_POST['prefijo']);
        $archivos                = [];
        $aux2                    = str_replace(' ', '', $_FILES['domicilio']['name']);
        $nombre_archivo          = str_replace('_', '', $aux2);
        $config['upload_path']   = './_docs/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['overwrite']     = true;
        /*$config['max_size']      = 1048;
        $config['max_width']     = 1024;
        $config['max_height']    = 768;*/
        $config['file_name'] = $prefijo . "_" . $nombre_archivo;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // File upload
        if ($this->upload->do_upload('domicilio')) {
            $data        = $this->upload->data();
            echo $salida = 1;
        }

        $doc = [
            'creacion'          => $date,
            'edicion'           => $date,
            'id_candidato'      => $id_candidato,
            'id_tipo_documento' => 2,
            'archivo'           => $prefijo . "_" . $nombre_archivo,
        ];
        $this->candidato_model->insertDocCandidato($doc);
        //}
    }
    public function subirPasaporte()
    {
        //if(isset($_FILES["documento"]["name"])){
        date_default_timezone_set('America/Mexico_City');
        $date                    = date('Y-m-d H:i:s');
        $id_candidato            = $_POST['id_candidato'];
        $prefijo                 = str_replace(' ', '', $_POST['prefijo']);
        $archivos                = [];
        $aux2                    = str_replace(' ', '', $_FILES['pasaporte']['name']);
        $nombre_archivo          = str_replace('_', '', $aux2);
        $config['upload_path']   = './_docs/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['overwrite']     = true;
        /*$config['max_size']      = 1048;
        $config['max_width']     = 1024;
        $config['max_height']    = 768;*/
        $config['file_name'] = $prefijo . "_" . $nombre_archivo;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // File upload
        if ($this->upload->do_upload('pasaporte')) {
            $data        = $this->upload->data();
            echo $salida = 1;
        }

        $doc = [
            'creacion'          => $date,
            'edicion'           => $date,
            'id_candidato'      => $id_candidato,
            'id_tipo_documento' => 14,
            'archivo'           => $prefijo . "_" . $nombre_archivo,
        ];
        $this->candidato_model->insertDocCandidato($doc);
        //}
    }
    public function subirFormaMigratoria()
    {
        //if(isset($_FILES["documento"]["name"])){
        date_default_timezone_set('America/Mexico_City');
        $date                    = date('Y-m-d H:i:s');
        $id_candidato            = $_POST['id_candidato'];
        $prefijo                 = str_replace(' ', '', $_POST['prefijo']);
        $archivos                = [];
        $aux2                    = str_replace(' ', '', $_FILES['forma']['name']);
        $nombre_archivo          = str_replace('_', '', $aux2);
        $config['upload_path']   = './_docs/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['overwrite']     = true;
        /*$config['max_size']      = 1048;
        $config['max_width']     = 1024;
        $config['max_height']    = 768;*/
        $config['file_name'] = $prefijo . "_" . $nombre_archivo;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // File upload
        if ($this->upload->do_upload('forma')) {
            $data        = $this->upload->data();
            echo $salida = 1;
        }

        $doc = [
            'creacion'          => $date,
            'edicion'           => $date,
            'id_candidato'      => $id_candidato,
            'id_tipo_documento' => 20,
            'archivo'           => $prefijo . "_" . $nombre_archivo,
        ];
        $this->candidato_model->insertDocCandidato($doc);
        //}
    }
    public function subirMilitar()
    {
        //if(isset($_FILES["documento"]["name"])){
        date_default_timezone_set('America/Mexico_City');
        $date                    = date('Y-m-d H:i:s');
        $id_candidato            = $_POST['id_candidato'];
        $prefijo                 = str_replace(' ', '', $_POST['prefijo']);
        $archivos                = [];
        $aux2                    = str_replace(' ', '', $_FILES['militar']['name']);
        $nombre_archivo          = str_replace('_', '', $aux2);
        $config['upload_path']   = './_docs/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['overwrite']     = true;
        /*$config['max_size']      = 1048;
        $config['max_width']     = 1024;
        $config['max_height']    = 768;*/
        $config['file_name'] = $prefijo . "_" . $nombre_archivo;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        // File upload
        if ($this->upload->do_upload('militar')) {
            $data        = $this->upload->data();
            echo $salida = 1;
        }

        $doc = [
            'creacion'          => $date,
            'edicion'           => $date,
            'id_candidato'      => $id_candidato,
            'id_tipo_documento' => 15,
            'archivo'           => $prefijo . "_" . $nombre_archivo,
        ];
        $this->candidato_model->insertDocCandidato($doc);
        //}
    }

    public function checkFamiliares()
    {
        $id_candidato             = $_POST['id_candidato'];
        $salida                   = "";
        $h1                       = 1;
        $h2                       = 1;
        $data['tipos_parentesco'] = $this->candidato_model->getParentescos();
        $data['familia']          = $this->candidato_model->checkFamiliares($id_candidato);
        if (isset($data['familia'])) {
            foreach ($data['familia'] as $f) {
                if ($f->id_tipo_parentesco == 4 && $f->nombre != "" && $f->nombre != "undefined") {
                    $salida .= '<p class="tituloSubseccion">Wife/Husband</p>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Name</label>
                                        <input type="text" class="form-control familia_obligado" name="nombre_conyuge" id="4_nombre_conyuge" value="' . $f->nombre . '">
                                        <br>
                                    </div>
                                    <div class="col-md-1">
                                        <label>Age</label>
                                        <input type="text" class="form-control familia_obligado solo_numeros" name="edad_conyuge" id="4_edad_conyuge" maxlength="2" value="' . $f->edad . '">
                                        <br>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Ocupation </label>
                                        <input type="text" class="form-control familia_obligado" name="puesto_conyuge" id="4_puesto_conyuge" value="' . $f->puesto . '">
                                        <br>
                                    </div>
                                    <div class="col-md-2">
                                        <label>City</label>
                                        <input type="text" class="form-control familia_obligado" name="ciudad_conyuge" id="4_ciudad_conyuge" value="' . $f->ciudad . '">
                                        <br>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Company</label>
                                        <input type="text" class="form-control familia_obligado" name="empresa_conyuge" id="4_empresa_conyuge" value="' . $f->empresa . '">
                                        <br>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Live with her/him? </label>';
                    $salida .= ($f->misma_vivienda == 1) ? '<input type="text" class="form-control" name="con_conyuge" id="4_con_conyuge" value="Sí" readonly>' : '<input type="text" class="form-control" name="con_conyuge" id="4_con_conyuge" value="No" readonly>';
                    $salida .= '<br>
                                    </div>
                                </div>';
                }
                if ($f->id_tipo_parentesco == 3) {
                    $salida .= "<p class='tituloSubseccion'>Child " . $h1 . "</p>
                                <div class='row'>
                                    <div class='col-md-3'>
                                        <label>Name *</label>
                                        <input type='text' class='form-control familia_obligado es_hijo' name='nombre_hijo" . $h1 . "' id='3_nombre_hijo" . $h1 . "' value='" . $f->nombre . "' >
                                        <br>
                                    </div>
                                    <div class='col-md-1'>
                                        <label>Age *</label>
                                        <input type='text' class='form-control solo_numeros familia_obligado es_hijo' name='edad_hijo" . $h1 . "' id='3_edad_hijo" . $h1 . "' value='" . $f->edad . "' maxlength='2' >
                                        <br>
                                    </div>
                                    <div class='col-md-2'>
                                        <label>Ocupation *</label>
                                        <input type='text' class='form-control familia_obligado es_hijo' name='puesto_hijo" . $h1 . "' id='3_puesto_hijo" . $h1 . "' value='" . $f->puesto . "' >
                                        <br>
                                    </div>
                                    <div class='col-md-2'>
                                        <label>City *</label>
                                        <input type='text' class='form-control familia_obligado es_hijo' name='ciudad_hijo" . $h1 . "' id='3_ciudad_hijo" . $h1 . "' value='" . $f->ciudad . "'>
                                        <br>
                                    </div>
                                    <div class='col-md-2'>
                                        <label>School/Company *</label>
                                        <input type='text' class='form-control familia_obligado es_hijo' name='empresa_hijo" . $h1 . "' id='3_empresa_hijo" . $h1 . "' value='" . $f->empresa . "'>
                                        <br>
                                    </div>
                                    <div class='col-md-2'>
                                        <label>Live with her/him? *</label>";
                    $salida .= ($f->misma_vivienda == 1) ? '<input type="text" class="form-control  es_hijo" name="con_hijo' . $h1 . '" id="3_con_hijo' . $h1 . '" value="Sí" readonly>' : '<input type="text" class="form-control  es_hijo" name="con_hijo' . $h1 . '" id="3_con_hijo' . $h1 . '" value="No" readonly>';

                    $salida .= '<br>
                                    </div>
                                </div>';
                    $h1++;
                }
                if ($f->id_tipo_parentesco == 1) {
                    $salida .= '<p class="tituloSubseccion">Father</p>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Name *</label>
                                        <input type="text" class="form-control familia_obligado parte_familia" name="nombre_padre" id="1_nombre_padre" value="' . $f->nombre . '" >
                                        <br>
                                    </div>
                                    <div class="col-md-1">
                                        <label>Age *</label>
                                        <input type="text" class="form-control solo_numeros familia_obligado parte_familia" name="edad_padre" id="1_edad_padre" value="' . $f->edad . '" maxlength="2" >
                                        <br>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Ocupation *</label>
                                        <input type="text" class="form-control familia_obligado parte_familia" name="puesto_padre" id="1_puesto_padre" value="' . $f->puesto . '" >
                                        <br>
                                    </div>
                                    <div class="col-md-2">
                                        <label>City *</label>
                                        <input type="text" class="form-control familia_obligado parte_familia" name="ciudad_padre" id="1_ciudad_padre" value="' . $f->ciudad . '">
                                        <br>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Company *</label>
                                        <input type="text" class="form-control familia_obligado parte_familia" name="empresa_padre" id="1_empresa_padre" value="' . $f->empresa . '">
                                        <br>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Live with her/him? *</label>';
                    $salida .= ($f->misma_vivienda == 1) ? '<input type="text" class="form-control parte_familia" name="con_padre" id="1_con_padre" value="Sí" readonly>' : '<input type="text" class="form-control parte_familia" name="con_padre" id="1_con_padre" value="No" readonly>';
                    $salida .= '<br>
                                    </div>
                                </div>';
                }
                if ($f->id_tipo_parentesco == 2) {
                    $salida .= '<p class="tituloSubseccion">Mother</p>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Name *</label>
                                        <input type="text" class="form-control familia_obligado parte_familia" name="nombre_madre" id="2_nombre_madre" value="' . $f->nombre . '" >
                                        <br>
                                    </div>
                                    <div class="col-md-1">
                                        <label>Age *</label>
                                        <input type="text" class="form-control solo_numeros familia_obligado parte_familia" name="edad_madre" id="2_edad_madre" value="' . $f->edad . '" maxlength="2" >
                                        <br>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Ocupation *</label>
                                        <input type="text" class="form-control familia_obligado parte_familia" name="puesto_madre" id="2_puesto_madre" value="' . $f->puesto . '" >
                                        <br>
                                    </div>
                                    <div class="col-md-2">
                                        <label>City *</label>
                                        <input type="text" class="form-control familia_obligado parte_familia" name="ciudad_madre" id="2_ciudad_madre" value="' . $f->ciudad . '">
                                        <br>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Company *</label>
                                        <input type="text" class="form-control familia_obligado parte_familia" name="empresa_madre" id="2_empresa_madre" value="' . $f->empresa . '">
                                        <br>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Live with her/him? *</label>';
                    $salida .= ($f->misma_vivienda == 1) ? '<input type="text" class="form-control parte_familia" name="con_madre" id="2_con_madre" value="Sí" readonly>' : '<input type="text" class="form-control parte_familia" name="con_madre" id="2_con_madre" value="No" readonly>';
                    $salida .= '    <br>
                                    </div>
                                </div>';
                }
                if ($f->id_tipo_parentesco == 6) {
                    $salida .= "<p class='tituloSubseccion'>Sibling " . $h2 . "</p>
                                <div class='row'>
                                    <div class='col-md-3'>
                                        <label>Name *</label>
                                        <input type='text' class='form-control familia_obligado es_hermano' name='nombre_hermano" . $h2 . "' id='6_nombre_hermano" . $h2 . "' value='" . $f->nombre . "' >
                                        <br>
                                    </div>
                                    <div class='col-md-1'>
                                        <label>Age *</label>
                                        <input type='text' class='form-control solo_numeros familia_obligado es_hermano' name='edad_hermano" . $h2 . "' id='6_edad_hermano" . $h2 . "' value='" . $f->edad . "' maxlength='2' >
                                        <br>
                                    </div>
                                    <div class='col-md-2'>
                                        <label>Ocupation *</label>
                                        <input type='text' class='form-control familia_obligado es_hermano' name='puesto_hermano" . $h2 . "' id='6_puesto_hermano" . $h2 . "' value='" . $f->puesto . "' >
                                        <br>
                                    </div>
                                    <div class='col-md-2'>
                                        <label>City *</label>
                                        <input type='text' class='form-control familia_obligado es_hermano' name='ciudad_hermano" . $h2 . "' id='6_ciudad_hermano" . $h2 . "' value='" . $f->ciudad . "' >
                                        <br>
                                    </div>
                                    <div class='col-md-2'>
                                        <label>School/Company *</label>
                                        <input type='text' class='form-control familia_obligado es_hermano' name='empresa_hermano" . $h2 . "' id='6_empresa_hermano" . $h2 . "' value='" . $f->empresa . "' >
                                        <br>
                                    </div>
                                    <div class='col-md-2'>
                                        <label>Live with her/him? *</label>";
                    $salida .= ($f->misma_vivienda == 1) ? '<input type="text" class="form-control es_hermano" name="con_hermano' . $h2 . '" id="6_con_hermano' . $h2 . '" value="Sí" readonly>' : '<input type="text" class="form-control es_hermano" name="con_hermano' . $h2 . '" id="6_con_hermano' . $h2 . '" value="No" readonly>';

                    $salida .= '<br>
                                    </div>
                                </div>';
                    $h2++;
                }
            }
            echo $salida;
        } else {
            $salida = 0;
        }
    }

    public function getVerificacionReferencias()
    {
        $id_candidato        = $_POST['id_candidato'];
        $salida              = "";
        $data['referencias'] = $this->candidato_model->getVerificacionReferencias($id_candidato);
        if ($data['referencias']) {
            foreach ($data['referencias'] as $ref) {
                $salida .= $ref->empresa . "@@";
                $salida .= $ref->direccion . "@@";
                $salida .= $ref->fecha_entrada . "@@";
                $salida .= $ref->fecha_salida . "@@";
                $salida .= $ref->telefono . "@@";
                $salida .= $ref->puesto1 . "@@";
                $salida .= $ref->puesto2 . "@@";
                $salida .= $ref->salario1 . "@@";
                $salida .= $ref->salario2 . "@@";
                $salida .= $ref->jefe_nombre . "@@";
                $salida .= $ref->jefe_correo . "@@";
                $salida .= $ref->jefe_puesto . "@@";
                $salida .= $ref->causa_separacion . "@@";
                $salida .= $ref->id . "@@";
                $salida .= $ref->numero_referencia . "@@";
                $salida .= $ref->notas . "@@";
                $salida .= $ref->demanda . "@@";
                $salida .= $ref->responsabilidad . "@@";
                $salida .= $ref->iniciativa . "@@";
                $salida .= $ref->eficiencia . "@@";
                $salida .= $ref->disciplina . "@@";
                $salida .= $ref->puntualidad . "@@";
                $salida .= $ref->limpieza . "@@";
                $salida .= $ref->estabilidad . "@@";
                $salida .= $ref->emocional . "@@";
                $salida .= $ref->honestidad . "@@";
                $salida .= $ref->rendimiento . "@@";
                $salida .= $ref->actitud . "@@";
                $salida .= $ref->recontratacion . "@@";
                $salida .= $ref->motivo_recontratacion . "@@";
                $salida .= $ref->numero_referencia . "###";
            }

        }
        echo $salida;
    }

    public function getTiposDocumentos()
    {
        $id_candidato      = $_POST['id_candidato'];
        $salida            = "";
        $i                 = 0;
        $acum              = [];
        $data['tipos']     = $this->candidato_model->getTiposDocs();
        $data['docs']      = $this->candidato_model->getDocs($id_candidato);
        $data['agregados'] = $this->candidato_model->getDocsAgregados($id_candidato);
        if ($data['agregados']) {
            foreach ($data['agregados'] as $item) {
                $acum[] = $item->id_tipo_documento;
            }
        }
        if ($data['docs']) {
            foreach ($data['docs'] as $doc) {
                if ($doc->id_tipo_documento == 8 || $doc->id_tipo_documento == 9 || $doc->id_tipo_documento == 10 || $doc->id_tipo_documento == 11 || $doc->id_tipo_documento == 12 || $doc->id_tipo_documento == 13 || $doc->id_tipo_documento == 18 || $doc->id_tipo_documento == 7) {
                    if (substr($doc->archivo, -4) == '.jpg' || substr($doc->archivo, -4) == '.png' || substr($doc->archivo, -5) == '.jpeg' ||
                        substr($doc->archivo, -4) == '.JPG' || substr($doc->archivo, -4) == '.PNG' || substr($doc->archivo, -5) == '.JPEG') {
                        if (in_array($doc->id_tipo_documento, $acum)) {
                            foreach ($data['tipos'] as $tipo) {
                                if ($tipo->id == $doc->id_tipo_documento) {
                                    $salida .= '
                                            <div class="col-md-4">
                                                <label class="contenedor_check">' . $doc->archivo . ' (' . $tipo->nombre . ')
                                                    <input type="checkbox" name="imagen' . $i . '" id="imagen' . $i . '" value="' . $tipo->id . "@@" . $doc->archivo . '" checked>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                    ';
                                    $i++;
                                    break;
                                }
                            }
                        } else {
                            foreach ($data['tipos'] as $tipo) {
                                if ($tipo->id == $doc->id_tipo_documento) {
                                    $salida .= '
                                            <div class="col-md-4">
                                                <label class="contenedor_check">' . $doc->archivo . ' (' . $tipo->nombre . ')
                                                    <input type="checkbox" name="imagen' . $i . '" id="imagen' . $i . '" value="' . $tipo->id . "@@" . $doc->archivo . '">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                    ';
                                    $i++;
                                    break;
                                }
                            }
                        }
                    }
                } else {
                    $salida .= "";
                }
            }
            unset($acum);
            echo $salida;
        } else {
            echo $salida .= '<p class="text-center">No hay documentos válidos (.jpg, .png) para añadir</p>';
        }
    }
    public function updateDatos1()
    {
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $cadena = $this->input->post('d_personal');
        parse_str($cadena, $personal);
        $id_candidato = $personal['id_candidato'];
        $id_usuario   = $this->session->userdata('id');

        $fecha     = fecha_ingles_bd($personal['fecha_nacimiento']);
        $edad      = calculaEdad($fecha);
        $candidato = [
            'edicion'          => $date,
            'id_usuario'       => $id_usuario,
            'nombre'           => $personal['nombre'],
            'paterno'          => $personal['paterno'],
            'materno'          => $personal['materno'],
            'fecha_nacimiento' => $fecha,
            'edad'             => $edad,
            'puesto'           => $personal['puesto'],
            'nacionalidad'     => $personal['nacionalidad'],
            'genero'           => $personal['genero'],
            'calle'            => $personal['calle'],
            'exterior'         => $personal['exterior'],
            'interior'         => $personal['interior'],
            'colonia'          => $personal['colonia'],
            'id_estado'        => $personal['estado'],
            'id_municipio'     => $personal['municipio'],
            'cp'               => $personal['cp'],
            'estado_civil'     => $personal['civil'],
            'celular'          => $personal['telefono'],
            'telefono_casa'    => $personal['tel_casa'],
            'telefono_otro'    => $personal['tel_otro'],
            'correo'           => strtolower($personal['correo']),
            //'trabajo_gobierno' => $dato['trabajo_gobierno']
        ];
        $this->candidato_model->editarCandidato($candidato, $id_candidato);
        echo $salida = 1;
    }

    public function verificacionDocumentosCandidatoHCL()
    {
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $cadena = $this->input->post('d_documentos');
        parse_str($cadena, $doc);
        $id_candidato = $doc['id_candidato'];
        $id_usuario   = $this->session->userdata('id');
        $candidato    = [
            'id_usuario' => $id_usuario,
        ];
        $this->candidato_model->editarCandidato($candidato, $id_candidato);

        $verificacion_documento = [
            'creacion'               => $date,
            'id_usuario'             => $id_usuario,
            'id_candidato'           => $id_candidato,
            'licencia'               => $doc['lic_profesional'],
            'licencia_institucion'   => $doc['lic_institucion'],
            'ine'                    => $doc['ine_clave'],
            'ine_ano'                => $doc['ine_registro'],
            'ine_vertical'           => $doc['ine_vertical'],
            'ine_institucion'        => $doc['ine_institucion'],
            'penales'                => $doc['penales_numero'],
            'penales_institucion'    => $doc['penales_institucion'],
            'domicilio'              => $doc['direccion_numero'],
            'fecha_domicilio'        => $doc['direccion_fecha'],
            'militar'                => $doc['militar_numero'],
            'militar_fecha'          => $doc['militar_fecha'],
            'pasaporte'              => $doc['pasaporte_numero'],
            'pasaporte_fecha'        => $doc['pasaporte_fecha'],
            'forma_migratoria'       => $doc['forma_numero'],
            'forma_migratoria_fecha' => $doc['forma_fecha'],
            'comentarios'            => $doc['doc_comentarios'],
        ];

        $this->candidato_model->cleanVerificacionDocumentos($id_candidato);
        $this->candidato_model->saveVerificacionDocumento($verificacion_documento);
        echo $salida = 1;
    }

    public function updateDatabaseCheck()
    {
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $cadena = $this->input->post('database');
        parse_str($cadena, $dato);
        $id_candidato = $dato['id_candidato'];
        $id_usuario   = $this->session->userdata('id');

        $law_enforcement = (isset($dato['custom_law_enforcement'])) ? $dato['custom_law_enforcement'] : "";
        $regulatory      = (isset($dato['custom_regulatory'])) ? $dato['custom_regulatory'] : "";
        $other_bodies    = (isset($dato['custom_other_bodies'])) ? $dato['custom_other_bodies'] : "";
        $sanctions       = (isset($dato['custom_sanctions'])) ? $dato['custom_sanctions'] : "";
        $media_searches  = (isset($dato['custom_media_searches'])) ? $dato['custom_media_searches'] : "";
        $sdn             = (isset($dato['custom_sdn'])) ? $dato['custom_sdn'] : "";
        /*$facis = (isset($dato['x_facis']))? $dato['x_facis']:"";
        $interpol = (isset($dato['e_interpol']))? $dato['e_interpol']:"";
        $bureau = (isset($dato['x_bureau']))? $dato['x_bureau']:"";
        $eur = (isset($dato['x_european_financial']))? $dato['x_european_financial']:"";
        $fda = (isset($dato['global_fda']))? $dato['global_fda']:"";
         */
        $candidato = [
            'id_usuario' => $id_usuario,
        ];
        $this->candidato_model->editarCandidato($candidato, $id_candidato);
        $database = [
            'creacion'           => $date,
            'id_usuario'         => $id_usuario,
            'id_candidato'       => $id_candidato,
            'law_enforcement'    => $law_enforcement,
            'regulatory'         => $regulatory,
            'sanctions'          => $sanctions,
            'other_bodies'       => $other_bodies,
            'media_searches'     => $media_searches,
            'sdn'                => $sdn,
            'global_comentarios' => $dato['custom_comentarios'],
        ];
        $this->candidato_model->cleanGlobalSearches($id_candidato);
        $this->candidato_model->saveGlobalSearches($database);
        echo $salida = 1;
    }
    public function updateFamiliares1()
    {
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $cadena = $this->input->post('padre');
        parse_str($cadena, $padre);
        $cadena2 = $this->input->post('madre');
        parse_str($cadena2, $madre);
        $cadena3 = $this->input->post('conyuge');
        parse_str($cadena3, $conyuge);

        $id_candidato = $_POST['id_candidato'];
        $id_usuario   = $this->session->userdata('id');

        $candidato = [
            'id_usuario' => $id_usuario,
        ];
        $this->candidato_model->editarCandidato($candidato, $id_candidato);
        if (isset($conyuge)) {
            $data_conyuge = [
                'edicion'            => $date,
                'id_candidato'       => $id_candidato,
                'nombre'             => $conyuge['nombre_conyuge'],
                'id_tipo_parentesco' => 4,
                'edad'               => $conyuge['edad_conyuge'],
                'estado_civil'       => 1,
                'id_grado_estudio'   => 11,
                'ciudad'             => $conyuge['ciudad_conyuge'],
                'empresa'            => $conyuge['empresa_conyuge'],
                'puesto'             => $conyuge['puesto_conyuge'],
            ];
            $this->candidato_model->updatePersona($data_conyuge, $id_candidato, 4);
        }
        if (isset($padre)) {
            $data_padre = [
                'edicion'            => $date,
                'id_candidato'       => $id_candidato,
                'nombre'             => $padre['nombre_padre'],
                'id_tipo_parentesco' => 1,
                'edad'               => $padre['edad_padre'],
                'estado_civil'       => 7,
                'id_grado_estudio'   => 11,
                'ciudad'             => $padre['ciudad_padre'],
                'empresa'            => $padre['empresa_padre'],
                'puesto'             => $padre['puesto_padre'],
            ];
            $this->candidato_model->updatePersona($data_padre, $id_candidato, 1);
        }
        if (isset($madre)) {
            $data_madre = [
                'edicion'            => $date,
                'id_candidato'       => $id_candidato,
                'nombre'             => $madre['nombre_madre'],
                'id_tipo_parentesco' => 2,
                'edad'               => $madre['edad_madre'],
                'estado_civil'       => 7,
                'id_grado_estudio'   => 11,
                'ciudad'             => $madre['ciudad_madre'],
                'empresa'            => $madre['empresa_madre'],
                'puesto'             => $madre['puesto_madre'],
            ];
            $this->candidato_model->updatePersona($data_madre, $id_candidato, 2);
        }
        if ($_POST['hijos'] != "") {
            $this->candidato_model->cleanFamiliares($id_candidato, 3);
            $data_hijos = "";
            $h          = explode("@@", $_POST['hijos']);
            for ($i = 0; $i < count($h); $i++) {
                $aux = explode("__", $h[$i]);
                if ($h[$i] != "") {
                    $data_hijos = [
                        'creacion'           => $date,
                        'edicion'            => $date,
                        'id_candidato'       => $id_candidato,
                        'nombre'             => urldecode($aux[0]),
                        'id_tipo_parentesco' => 3,
                        'edad'               => $aux[1],
                        'estado_civil'       => 7,
                        'id_grado_estudio'   => 11,
                        'misma_vivienda'     => $misma = ($aux[5] == 'No') ? 0 : 1,
                        'ciudad'             => urldecode($aux[3]),
                        'empresa'            => urldecode($aux[4]),
                        'puesto'             => urldecode($aux[2]),
                    ];
                    $this->candidato_model->guardarFamiliar($data_hijos);
                }
            }
        }

        if ($_POST['hermanos'] != "") {
            $this->candidato_model->cleanFamiliares($id_candidato, 6);
            $data_hermanos = "";
            $h             = explode("@@", $_POST['hermanos']);
            for ($i = 0; $i < count($h); $i++) {
                $aux = explode("__", $h[$i]);
                if ($h[$i] != "") {
                    $data_hermanos = [
                        'creacion'           => $date,
                        'edicion'            => $date,
                        'id_candidato'       => $id_candidato,
                        'nombre'             => urldecode($aux[0]),
                        'id_tipo_parentesco' => 6,
                        'edad'               => $aux[1],
                        'estado_civil'       => 7,
                        'id_grado_estudio'   => 11,
                        'misma_vivienda'     => $misma = ($aux[5] == 'No') ? 0 : 1,
                        'ciudad'             => urldecode($aux[3]),
                        'empresa'            => urldecode($aux[4]),
                        'puesto'             => urldecode($aux[2]),
                    ];
                    $this->candidato_model->guardarFamiliar($data_hermanos);
                }
            }
        }
        echo $salida = 1;
    }
    public function updateEstudios1()
    {
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $cadena = $this->input->post('d_estudios');
        parse_str($cadena, $estudio);
        $id_candidato = $estudio['id_candidato'];
        $id_usuario   = $this->session->userdata('id');
        $candidato    = [
            'id_usuario' => $id_usuario,
        ];
        $this->candidato_model->editarCandidato($candidato, $id_candidato);
        $verificacion_estudios = [
            'edicion'                  => $date,
            'primaria_periodo'         => $estudio['prim_periodo'],
            'primaria_escuela'         => $estudio['prim_escuela'],
            'primaria_ciudad'          => $estudio['prim_ciudad'],
            'primaria_certificado'     => $estudio['prim_certificado'],
            'primaria_validada'        => $estudio['prim_validado'],
            'secundaria_periodo'       => $estudio['sec_periodo'],
            'secundaria_escuela'       => $estudio['sec_escuela'],
            'secundaria_ciudad'        => $estudio['sec_ciudad'],
            'secundaria_certificado'   => $estudio['sec_certificado'],
            'secundaria_validada'      => $estudio['sec_validado'],
            'preparatoria_periodo'     => $estudio['prep_periodo'],
            'preparatoria_escuela'     => $estudio['prep_escuela'],
            'preparatoria_ciudad'      => $estudio['prep_ciudad'],
            'preparatoria_certificado' => $estudio['prep_certificado'],
            'preparatoria_validada'    => $estudio['prep_validado'],
            'licenciatura_periodo'     => $estudio['lic_periodo'],
            'licenciatura_escuela'     => $estudio['lic_escuela'],
            'licenciatura_ciudad'      => $estudio['lic_ciudad'],
            'licenciatura_certificado' => $estudio['lic_certificado'],
            'licenciatura_validada'    => $estudio['lic_validado'],
            'otros_certificados'       => $estudio['otro_certificado'],
            'comentarios'              => $estudio['estudios_comentarios'],
            'carrera_inactivo'         => $estudio['carrera_inactivo'],
        ];
        $this->candidato_model->updateVerificacionEstudios($verificacion_estudios, $id_candidato);
        echo $salida = 1;
    }

    public function actualizarReferenciaLaboral()
    {
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $cadena = $this->input->post('reflaboral');
        $num    = $this->input->post('num');
        parse_str($cadena, $ref);
        $id_candidato = $ref['id_candidato'];
        $id_usuario   = $this->session->userdata('id');

        $data['refs'] = $this->candidato_model->revisionReferenciaLaboral($ref['idref']);
        if ($data['refs']) {
            $datos = [
                'edicion'           => $date,
                'empresa'           => ucwords(strtolower($ref['reflab' . $num . '_empresa'])),
                'direccion'         => ucwords(strtolower($ref['reflab' . $num . '_direccion'])),
                'fecha_entrada_txt' => $ref['reflab' . $num . '_entrada'],
                'fecha_salida_txt'  => $ref['reflab' . $num . '_salida'],
                'telefono'          => $ref['reflab' . $num . '_telefono'],
                'puesto1'           => ucwords(strtolower($ref['reflab' . $num . '_puesto1'])),
                'puesto2'           => ucwords(strtolower($ref['reflab' . $num . '_puesto2'])),
                'salario1_txt'      => $ref['reflab' . $num . '_salario1'],
                'salario2_txt'      => $ref['reflab' . $num . '_salario2'],
                'jefe_nombre'       => ucwords(strtolower($ref['reflab' . $num . '_jefenombre'])),
                'jefe_correo'       => strtolower($ref['reflab' . $num . '_jefecorreo']),
                'jefe_puesto'       => ucwords(strtolower($ref['reflab' . $num . '_jefepuesto'])),
                'causa_separacion'  => $ref['reflab' . $num . '_separacion'],
            ];
            $this->candidato_model->updateReferenciaLaboral($datos, $ref['idref']);
            $salida = $ref['idref'];
        } else {
            $datos = [
                'creacion'          => $date,
                'edicion'           => $date,
                'id_candidato'      => $id_candidato,
                'empresa'           => ucwords(strtolower($ref['reflab' . $num . '_empresa'])),
                'direccion'         => ucwords(strtolower($ref['reflab' . $num . '_direccion'])),
                'fecha_entrada_txt' => $ref['reflab' . $num . '_entrada'],
                'fecha_salida_txt'  => $ref['reflab' . $num . '_salida'],
                'telefono'          => $ref['reflab' . $num . '_telefono'],
                'puesto1'           => ucwords(strtolower($ref['reflab' . $num . '_puesto1'])),
                'puesto2'           => ucwords(strtolower($ref['reflab' . $num . '_puesto2'])),
                'salario1_txt'      => $ref['reflab' . $num . '_salario1'],
                'salario2_txt'      => $ref['reflab' . $num . '_salario2'],
                'jefe_nombre'       => ucwords(strtolower($ref['reflab' . $num . '_jefenombre'])),
                'jefe_correo'       => strtolower($ref['reflab' . $num . '_jefecorreo']),
                'jefe_puesto'       => ucwords(strtolower($ref['reflab' . $num . '_jefepuesto'])),
                'causa_separacion'  => $ref['reflab' . $num . '_separacion'],
            ];
            $salida = $this->candidato_model->saveReferenciaLaboral($datos);
        }
        echo $salida;
    }
    public function actualizarReferenciaLaboralIngles()
    {
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $cadena = $this->input->post('reflaboral');
        $num    = $this->input->post('num');
        parse_str($cadena, $ref);
        $id_candidato = $ref['id_candidato'];
        $id_usuario   = $this->session->userdata('id');

        $data['refs'] = $this->candidato_model->revisionReferenciaLaboral($ref['idref']);
        if ($data['refs']) {
            $datos = [
                'edicion'           => $date,
                'empresa'           => ucwords(strtolower($ref['reflab' . $num . '_empresa_ingles'])),
                'direccion'         => ucwords(strtolower($ref['reflab' . $num . '_direccion_ingles'])),
                'fecha_entrada_txt' => $ref['reflab' . $num . '_entrada_ingles'],
                'fecha_salida_txt'  => $ref['reflab' . $num . '_salida_ingles'],
                'telefono'          => $ref['reflab' . $num . '_telefono_ingles'],
                'puesto1'           => ucwords(strtolower($ref['reflab' . $num . '_puesto1_ingles'])),
                'puesto2'           => ucwords(strtolower($ref['reflab' . $num . '_puesto2_ingles'])),
                'salario1_txt'      => $ref['reflab' . $num . '_salario1_ingles'],
                'salario2_txt'      => $ref['reflab' . $num . '_salario2_ingles'],
                'jefe_nombre'       => ucwords(strtolower($ref['reflab' . $num . '_jefenombre_ingles'])),
                'jefe_correo'       => strtolower($ref['reflab' . $num . '_jefecorreo_ingles']),
                'jefe_puesto'       => ucwords(strtolower($ref['reflab' . $num . '_jefepuesto_ingles'])),
                'causa_separacion'  => $ref['reflab' . $num . '_separacion_ingles'],
            ];
            $this->candidato_model->updateReferenciaLaboral($datos, $ref['idref']);
            $salida = $ref['idref'];
        } else {
            $datos = [
                'creacion'          => $date,
                'edicion'           => $date,
                'id_candidato'      => $id_candidato,
                'empresa'           => ucwords(strtolower($ref['reflab' . $num . '_empresa_ingles'])),
                'direccion'         => ucwords(strtolower($ref['reflab' . $num . '_direccion_ingles'])),
                'fecha_entrada_txt' => $ref['reflab' . $num . '_entrada_ingles'],
                'fecha_salida_txt'  => $ref['reflab' . $num . '_salida_ingles'],
                'telefono'          => $ref['reflab' . $num . '_telefono_ingles'],
                'puesto1'           => ucwords(strtolower($ref['reflab' . $num . '_puesto1_ingles'])),
                'puesto2'           => ucwords(strtolower($ref['reflab' . $num . '_puesto2_ingles'])),
                'salario1_txt'      => $ref['reflab' . $num . '_salario1_ingles'],
                'salario2_txt'      => $ref['reflab' . $num . '_salario2_ingles'],
                'jefe_nombre'       => ucwords(strtolower($ref['reflab' . $num . '_jefenombre_ingles'])),
                'jefe_correo'       => strtolower($ref['reflab' . $num . '_jefecorreo_ingles']),
                'jefe_puesto'       => ucwords(strtolower($ref['reflab' . $num . '_jefepuesto_ingles'])),
                'causa_separacion'  => $ref['reflab' . $num . '_separacion_ingles'],
            ];
            $salida = $this->candidato_model->saveReferenciaLaboral($datos);
        }
        echo $salida;
    }

    public function updatePersonales1()
    {
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $cadena = $this->input->post('d_refPersonal');
        parse_str($cadena, $ref);
        $id_candidato = $ref['id_candidato'];
        $id_refper1   = $ref['id_refper1'];
        $id_refper2   = $ref['id_refper2'];
        $id_refper3   = $ref['id_refper3'];
        $id_usuario   = $this->session->userdata('id');

        $candidato = [
            'edicion'          => $date,
            'id_usuario'       => $id_usuario,
            'trabajo_gobierno' => $ref['trabajo_gobierno'],
        ];
        $this->candidato_model->editarCandidato($candidato, $id_candidato);

        $data_refper1 = [
            'nombre'          => $ref['refPer1_nombre'],
            'telefono'        => $ref['refPer1_telefono'],
            'donde_conocerlo' => $ref['refPer1_conocido'],
            'comentario'      => $ref['refPer1_comentario'],
        ];
        $data_refper2 = [
            'nombre'          => $ref['refPer2_nombre'],
            'telefono'        => $ref['refPer2_telefono'],
            'donde_conocerlo' => $ref['refPer2_conocido'],
            'comentario'      => $ref['refPer2_comentario'],
        ];
        $data_refper3 = [
            'nombre'          => $ref['refPer3_nombre'],
            'telefono'        => $ref['refPer3_telefono'],
            'donde_conocerlo' => $ref['refPer3_conocido'],
            'comentario'      => $ref['refPer3_comentario'],
        ];
        $this->candidato_model->updateReferenciaPersonal($id_refper1, $data_refper1);
        $this->candidato_model->updateReferenciaPersonal($id_refper2, $data_refper2);
        $this->candidato_model->updateReferenciaPersonal($id_refper3, $data_refper3);
        echo $salida = 1;
    }
    public function updateArchivos1()
    {
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $cadena = $this->input->post('d_images');
        parse_str($cadena, $arch);
        $id_candidato = $_POST['id_candidato'];
        $id_usuario   = $this->session->userdata('id');
        //var_dump($arch);
        //Imagenes (archivos) para documento final
        $candidato = [
            'id_usuario' => $id_usuario,
        ];
        $this->candidato_model->editarCandidato($candidato, $id_candidato);

        if (isset($arch)) {
            $this->candidato_model->cleanDocsAgregados($id_candidato);
            $cant = count($arch);
            for ($i = 0; $i <= $cant; $i++) {
                if (isset($arch['imagen' . $i])) {
                    $img = explode('@@', $arch['imagen' . $i]);
                    $this->candidato_model->agregarDocumento($img[0], $img[1], $date, $id_usuario, $id_candidato);
                } else {
                    $i++;
                    if (isset($arch['imagen' . $i])) {
                        $img = explode('@@', $arch['imagen' . $i]);
                        $this->candidato_model->agregarDocumento($img[0], $img[1], $date, $id_usuario, $id_candidato);
                    }
                }
            }
        } else {
            $this->candidato_model->cleanDocsAgregados($id_candidato);
        }

        echo $salida = 1;
    }

    public function nuevoCandidato()
    {
        $this->form_validation->set_rules('nombre', 'Name', 'required|trim|callback_alpha_space_only_english');
        $this->form_validation->set_rules('paterno', 'First lastname', 'required|trim|callback_alpha_space_only_english');
        $this->form_validation->set_rules('materno', 'Second lastname', 'required|trim|callback_alpha_space_only_english');
        $this->form_validation->set_rules('correo', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('celular', 'Cell phone number', 'required|numeric|max_length[10]|min_length[10]');
        $this->form_validation->set_rules('fijo', 'Home number', 'numeric|max_length[10]|min_length[10]');
        /*if(empty($this->input->post('ine')) || $this->input->post('ine') == 'undefined'){

        $this->form_validation->set_rules('ine', 'ine o solicitud de empleo', 'callback_required_file');
        }*/
        /*$this->form_validation->set_message('required','El campo {field} es obligatorio');
        $this->form_validation->set_message('valid_email','El campo {field} debe ser un email válido');
        $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');
        $this->form_validation->set_message('min_length','El campo {field} no es válido');
        $this->form_validation->set_message('max_length','El campo {field} no es válido');
        $this->form_validation->set_message('less_than','El campo {field} no es válido');
        $this->form_validation->set_message('greater_than','El campo {field} no es válido');*/
        if ($this->form_validation->run() != true) {
            echo validation_errors();
        }
        if ($this->form_validation->run() == true) {
            $id_cliente       = $this->session->userdata('idcliente');
            $nombre           = ucwords(strtolower($this->input->post('nombre')));
            $paterno          = ucwords(strtolower($this->input->post('paterno')));
            $materno          = ucwords(strtolower($this->input->post('materno')));
            $cel              = $this->input->post('celular');
            $tel              = $this->input->post('fijo');
            $correo           = strtolower($this->input->post('correo'));
            $fecha_nacimiento = $this->input->post('fecha_nacimiento');
            $proceso          = $this->input->post('proceso');
            $existeCandidato  = $this->candidato_model->repetidoCandidato($nombre, $paterno, $materno, $correo, $id_cliente);
            if ($existeCandidato > 0) {
                echo $res = 0;
            } else {
                date_default_timezone_set('America/Mexico_City');
                $date       = date('Y-m-d H:i:s');
                $id_usuario = $this->session->userdata('id');
                $last       = $this->candidato_model->lastIdCandidato();
                if (isset($_FILES['ine'])) {
                    $nombre_ine              = ($last->id + 1) . "_" . $this->input->post('nombre') . "" . $this->input->post('paterno') . "_" . $_FILES['ine']['name'];
                    $config['upload_path']   = './_docs/';
                    $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                    $config['overwrite']     = true;
                    $config['file_name']     = $nombre_ine;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    // File upload
                    if ($this->upload->do_upload('ine')) {
                        $documento = [
                            'creacion'          => $date,
                            'edicion'           => $date,
                            'id_candidato'      => ($last->id + 1),
                            'id_tipo_documento' => 3,
                            'archivo'           => $nombre_ine,
                        ];
                        $this->candidato_model->insertCVCandidato($documento);
                        $data = $this->upload->data();
                    }
                }
                if ($fecha_nacimiento != "" && $fecha_nacimiento != null) {
                    $fnacimiento = fecha_ingles_bd($fecha_nacimiento);
                } else {
                    $fnacimiento = "";
                }
                if ($proceso == 1) {
                    $base  = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
                    $aux   = substr(md5(microtime()), 1, 8);
                    $token = md5($aux . $base);
                    $data  = [
                        'creacion'           => $date,
                        'edicion'            => $date,
                        'id_usuario_cliente' => $id_usuario,
                        'fecha_alta'         => $date,
                        'nombre'             => $nombre,
                        'paterno'            => $paterno,
                        'materno'            => $materno,
                        'correo'             => $correo,
                        'fecha_nacimiento'   => $fnacimiento,
                        'token'              => $token,
                        'id_cliente'         => $id_cliente,
                        'celular'            => $cel,
                        'telefono_casa'      => $tel,
                        'id_tipo_proceso'    => $proceso,
                    ];
                    $this->candidato_model->nuevoCandidato($data);
                    $from              = $this->config->item('smtp_user');
                    $to                = $correo;
                    $subject           = strtolower($this->session->userdata('cliente')) . " - credentials for register form";
                    $datos['password'] = $aux;
                    $datos['cliente']  = strtoupper($this->session->userdata('cliente'));
                    $datos['email']    = $correo;
                    $message           = $this->load->view('login/mail_view', $datos, true);
                    $this->load->library('phpmailer_lib');
                    $mail = $this->phpmailer_lib->load();
                    $mail->isSMTP();
                    $mail->Host       = 'mail.rodicontrol.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'rodicontrol@rodicontrol.com';
                    $mail->Password   = 'r49o*&rUm%91';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port       = 465;

                    $mail->setFrom('rodicontrol@rodicontrol.com', 'Rodi');
                    $mail->addAddress($to);
                    $mail->Subject = $subject;
                    $mail->isHTML(true);
                    $mailContent = $message;
                    $mail->Body  = $mailContent;

                    if (! $mail->send()) {
                        //echo 'Message could not be sent.';
                        //echo 'Mailer Error: ' . $mail->ErrorInfo;
                        echo "No sent@@" . $aux;
                    } else {
                        //echo 'Message has been sent';
                        echo "Sent@@" . $aux;
                    }
                }
                if ($proceso == 2) {
                    $data = [
                        'creacion'           => $date,
                        'edicion'            => $date,
                        'id_usuario_cliente' => $id_usuario,
                        'fecha_alta'         => $date,
                        'nombre'             => $nombre,
                        'paterno'            => $paterno,
                        'materno'            => $materno,
                        'correo'             => $correo,
                        'fecha_nacimiento'   => $fnacimiento,
                        'id_cliente'         => $id_cliente,
                        'celular'            => $cel,
                        'telefono_casa'      => $tel,
                        'id_tipo_proceso'    => $proceso,
                    ];
                    $this->candidato_model->nuevoCandidato($data);
                    echo $aux = 1;
                }
            }
        }
    }

    public function registrarCandidatosIngles()
    {
        $id_cliente      = $this->input->post('id_cliente');
        $id_subcliente   = $this->input->post('subcliente');
        $nombre          = strtoupper($this->input->post('nombre'));
        $paterno         = strtoupper($this->input->post('paterno'));
        $materno         = strtoupper($this->input->post('materno'));
        $cel             = $this->input->post('celular');
        $tel             = $this->input->post('fijo');
        $correo          = strtolower($this->input->post('correo'));
        $examen          = $this->input->post('examen');
        $proceso         = $this->input->post('proceso');
        $puesto          = $this->input->post('puesto');
        $otro            = $this->input->post('otro');
        $existeCandidato = $this->candidato_model->repetidoCandidato($nombre, $paterno, $materno, $correo, $id_cliente);
        if ($existeCandidato > 0) {
            echo $res = 0;
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date       = date('Y-m-d H:i:s');
            $id_usuario = $this->session->userdata('id');
            $last       = $this->candidato_model->lastIdCandidato();
            $base       = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
            $aux        = substr(md5(microtime()), 1, 8);
            $token      = ($proceso == 3 || $proceso == 4) ? md5($aux . $base) : '';
            $data       = [
                'creacion'        => $date,
                'edicion'         => $date,
                'id_usuario'      => $id_usuario,
                'id_cliente'      => $id_cliente,
                'id_subcliente'   => $id_subcliente,
                'id_puesto'       => $puesto,
                'token'           => $token,
                'id_tipo_proceso' => $proceso,
                'fecha_alta'      => $date,
                'nombre'          => $nombre,
                'paterno'         => $paterno,
                'materno'         => $materno,
                'correo'          => $correo,
                'celular'         => $cel,
                'telefono_casa'   => $tel,
            ];
            $id_candidato = $this->candidato_model->registrarCandidatoEspanol($data);
            //Subida y Registro de CV
            if ($this->input->post('hay_cvs') == 1) {
                $countfiles       = count($_FILES['cvs']['name']);
                $nombreCandidato  = str_replace(' ', '', $this->input->post('nombre'));
                $paternoCandidato = str_replace(' ', '', $this->input->post('paterno'));

                for ($i = 0; $i < $countfiles; $i++) {
                    if (! empty($_FILES['cvs']['name'][$i])) {
                        // Define new $_FILES array - $_FILES['file']
                        $_FILES['file']['name']     = $_FILES['cvs']['name'][$i];
                        $_FILES['file']['type']     = $_FILES['cvs']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['cvs']['tmp_name'][$i];
                        $_FILES['file']['error']    = $_FILES['cvs']['error'][$i];
                        $_FILES['file']['size']     = $_FILES['cvs']['size'][$i];
                        $temp                       = str_replace(' ', '', $_FILES['cvs']['name'][$i]);
                        $nombre_cv                  = $id_candidato . "_" . $nombreCandidato . "" . $paternoCandidato . "_" . $temp;
                        // Set preference
                        $config['upload_path']   = './_docs/';
                        $config['allowed_types'] = 'pdf|jpeg|jpg|png';
                        $config['max_size']      = '15000'; // max_size in kb
                        $config['file_name']     = $nombre_cv;
                        //Load upload library
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        // File upload
                        if ($this->upload->do_upload('file')) {
                            $data = $this->upload->data();
                            //$salida = 1;
                        }
                        $documento = [
                            'creacion'          => $date,
                            'edicion'           => $date,
                            'id_candidato'      => $id_candidato,
                            'id_tipo_documento' => 16,
                            'archivo'           => $nombre_cv,
                        ];
                        $this->candidato_model->insertCVCandidato($documento);
                    }
                }
            }
            //$socio = ($this->input->post('socio') == 'on')? 1 : 0;
            $medico       = ($this->input->post('medico') == 'on') ? 1 : 0;
            $sociolaboral = ($this->input->post('laboral') == 'on') ? 1 : 0;
            $antidoping   = ($this->input->post('antidoping') == 'on') ? 1 : 0;
            $psicometrico = ($this->input->post('psicometrico') == 'on') ? 1 : 0;
            $buro         = ($this->input->post('buro') == 'on') ? 1 : 0;

            if ($antidoping == 1) {
                $drogas          = ($examen != "") ? $examen : null;
                $tipo_antidoping = 1;
            } else {
                $drogas          = null;
                $tipo_antidoping = 0;
            }
            $pruebas = [
                'creacion'           => $date,
                'edicion'            => $date,
                'id_usuario'         => $id_usuario,
                'id_candidato'       => $id_candidato,
                'id_cliente'         => $id_cliente,
                'socioeconomico'     => 1,
                'tipo_antidoping'    => $tipo_antidoping,
                'antidoping'         => $drogas,
                'tipo_psicometrico'  => $psicometrico,
                'psicometrico'       => $psicometrico,
                'medico'             => $medico,
                'buro_credito'       => $buro,
                'sociolaboral'       => $sociolaboral,
                'otro_requerimiento' => $otro,
            ];
            $this->candidato_model->insertPruebasCandidato($pruebas);
            if ($proceso == 3 || $proceso == 4) {
                $data_candidato    = $this->candidato_model->getInfoCandidatoEspecifico($id_candidato);
                $from              = $this->config->item('smtp_user');
                $to                = $correo;
                $subject           = $data_candidato->subcliente . " - credentials for register form";
                $datos['password'] = $aux;
                $datos['cliente']  = strtoupper($this->session->userdata('cliente'));
                $datos['email']    = $correo;
                $message           = $this->load->view('login/mail_view', $datos, true);
                $this->load->library('phpmailer_lib');
                $mail = $this->phpmailer_lib->load();
                $mail->isSMTP();
                $mail->Host       = 'mail.rodicontrol.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'rodicontrol@rodicontrol.com';
                $mail->Password   = 'r49o*&rUm%91';
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;

                $mail->setFrom('rodicontrol@rodicontrol.com', 'Rodi');
                $mail->addAddress($to);
                $mail->Subject = $subject;
                $mail->isHTML(true);
                $mailContent = $message;
                $mail->Body  = $mailContent;

                if (! $mail->send()) {
                    echo "No sent@@" . $aux;
                } else {
                    echo "Sent@@" . $aux;
                }
            } else {
                echo $res = 1;
            }
        }
    }

    public function viewSolicitudesCandidato()
    {
        $id_candidato = $_POST['id_candidato'];
        $salida       = "";
        $pruebas      = $this->candidato_model->getPruebasCandidato($id_candidato);
        if (isset($pruebas)) {
            $salida .= ($pruebas->socioeconomico == 1) ? "- <b>Socioeconomico</b><br>" : "";
            if ($pruebas->tipo_antidoping == 1) {
                $paq = $this->candidato_model->getPaqueteAntidoping($pruebas->antidoping);
                $salida .= '- <b>Antidoping:</b> ' . $paq->nombre . '<br>';
            }
            if ($pruebas->tipo_antidoping == 2) {
                $salida .= '- <b>Antidoping:</b> <br>';
                $aux = explode(',', $pruebas->antidoping);
                for ($i = 0; $i < count($aux); $i++) {
                    $sust = $this->candidato_model->getSustanciaAntidoping($aux[$i]);
                    $salida .= $sust->abreviatura . "<br>";
                }
            }
            if ($pruebas->tipo_psicometrico == 1) {
                $psi = $this->candidato_model->getBateria($pruebas->psicometrico);
                $salida .= '- <b>Psicométrico:</b> ' . $psi->nombre . '<br>';
            }
            if ($pruebas->tipo_psicometrico == 2) {
                $salida .= '- <b>Psicométrico:</b> <br>';
                $aux = explode(',', $pruebas->antidoping);
                for ($i = 0; $i < count($aux); $i++) {
                    $pru = $this->candidato_model->getPruebasPsicometrico($aux[$i]);
                    $salida .= $pru->abreviatura . "<br>";
                }
            }
            $salida .= ($pruebas->medico == 1) ? "- <b>Médico</b><br>" : "";
            if ($pruebas->buro_credito != 0) {
                $buro = $this->candidato_model->getBuroCredito($pruebas->buro_credito);
                $salida .= '- <b>Buró de crédito:</b> ' . $buro->nombre . '<br>';
            }
            $salida .= ($pruebas->sociolaboral == 1) ? "- <b>Sociolaboral</b><br>" : "";
            echo $salida;
        } else {
            echo $salida;
        }
    }
    public function registrarVisita()
    {
        date_default_timezone_set('America/Mexico_City');
        $date       = date('Y-m-d H:i:s');
        $id_usuario = $this->session->userdata('id');
        $cadena     = $this->input->post('data');
        parse_str($cadena, $dato);
        $aux          = explode('/', $dato['v_fecha_visita']);
        $fecha_visita = $aux[2] . '-' . $aux[1] . '-' . $aux[0];
        $existe       = $this->candidato_model->existeVisita($dato['id_candidato']);
        if ($existe > 0) {
            $visita = [
                'edicion'       => $date,
                'id_usuario'    => $id_usuario,
                'fecha_visita'  => $fecha_visita,
                'hora_inicio'   => $dato['v_hora_inicial'],
                'hora_fin'      => $dato['v_hora_final'],
                'calle'         => $dato['v_calle'],
                'exterior'      => $dato['v_exterior'],
                'interior'      => $dato['v_interior'],
                'colonia'       => $dato['v_colonia'],
                'id_estado'     => $dato['v_estado'],
                'id_municipio'  => $dato['v_municipio'],
                'cp'            => $dato['v_cp'],
                'celular'       => $dato['v_celular'],
                'telefono_casa' => $dato['v_tel_casa'],
                'telefono_otro' => $dato['v_tel_otro'],
            ];
            $this->candidato_model->updateVisita($visita, $dato['id_candidato']);
        } else {
            $visita = [
                'creacion'      => $date,
                'edicion'       => $date,
                'id_usuario'    => $id_usuario,
                'id_cliente'    => $dato['id_cliente'],
                'id_candidato'  => $dato['id_candidato'],
                'fecha_visita'  => $fecha_visita,
                'hora_inicio'   => $dato['v_hora_inicial'],
                'hora_fin'      => $dato['v_hora_final'],
                'calle'         => $dato['v_calle'],
                'exterior'      => $dato['v_exterior'],
                'interior'      => $dato['v_interior'],
                'colonia'       => $dato['v_colonia'],
                'id_estado'     => $dato['v_estado'],
                'id_municipio'  => $dato['v_municipio'],
                'cp'            => $dato['v_cp'],
                'celular'       => $dato['v_celular'],
                'telefono_casa' => $dato['v_tel_casa'],
                'telefono_otro' => $dato['v_tel_otro'],
            ];
            $this->candidato_model->addVisita($visita);
        }
        $candidato = [
            'edicion'       => $date,
            'id_usuario'    => $id_usuario,
            'calle'         => $dato['v_calle'],
            'exterior'      => $dato['v_exterior'],
            'interior'      => $dato['v_interior'],
            'colonia'       => $dato['v_colonia'],
            'id_estado'     => $dato['v_estado'],
            'id_municipio'  => $dato['v_municipio'],
            'cp'            => $dato['v_cp'],
            'celular'       => $dato['v_celular'],
            'telefono_casa' => $dato['v_tel_casa'],
            'telefono_otro' => $dato['v_tel_otro'],
        ];
        $this->candidato_model->editarCandidato($candidato, $dato['id_candidato']);
        echo $salida = 1;
    }

    public function cancel()
    {
        date_default_timezone_set('America/Mexico_City');
        $date               = date('Y-m-d H:i:s');
        $id_usuario_cliente = $this->session->userdata('id');
        $id_candidato       = $_POST['id_candidato'];
        $motivo             = $_POST['motivo'];
        $this->candidato_model->cancel($id_candidato, $date, $id_usuario_cliente);
        $this->candidato_model->motivoCancelar($id_candidato, $motivo, $date);
    }
    public function delete()
    {
        date_default_timezone_set('America/Mexico_City');
        $date               = date('Y-m-d H:i:s');
        $id_usuario_cliente = $this->session->userdata('id');
        $id_candidato       = $_POST['id_candidato'];
        $motivo             = $_POST['motivo'];
        $this->candidato_model->delete($id_candidato, $date, $id_usuario_cliente);
        $this->candidato_model->motivoEliminar($id_candidato, $motivo, $date);
    }
    //Obtiene los status penales, laborales y de estaudios del candidato para vista del cliente
    public function viewStatus()
    {
        $id_candidato      = $_POST['id_candidato'];
        $salida            = '<div class="row">';
        $salida            = '<p class="text-center "><strong>Criminal Records</strong></p>';
        $data['s_penales'] = $this->candidato_model->checkEstatusPenales($id_candidato);
        if ($data['s_penales']) {
            foreach ($data['s_penales'] as $p) {
                $aux = explode('-', $p->fecha);
                $f1  = $aux[1] . '/' . $aux[2] . '/' . $aux[0];
                $salida .= '<div class="col-md-12">';
                $salida .= '<p>Date: ' . $f1 . '</p><p>Comment: ' . $p->comentarios . '</p></div>';
                $p_terminado = $p->finalizado;
            }
            $salida .= ($p_terminado == 1) ? '<p class="text-center"><b>Completed</b></p><hr>' : '<p class="text-center"><b>In process by analyst</b></p><hr>';
            $salida .= '</div>';
            $salida .= '</div>';
        } else {
            $salida .= '<p class="text-center"><b>In process by analyst</b></p><br><hr>';
            $salida .= '</div>';
        }

        $salida .= '<p class="text-center "><strong>Laboral References</strong></p>';
        $data['s_laborales'] = $this->candidato_model->checkEstatusLaborales($id_candidato);
        if ($data['s_laborales']) {
            foreach ($data['s_laborales'] as $l) {
                $aux = explode('-', $l->fecha);
                $f2  = $aux[1] . '/' . $aux[2] . '/' . $aux[0];
                $salida .= '<div class="col-md-12">';
                $salida .= '<p>Date: ' . $f2 . '</p><p>Comment: ' . $l->comentarios . '</p></div>';
                $l_terminado = $l->finalizado;
            }
            $salida .= ($l_terminado == 1) ? '<p class="text-center"><b>Completed</b></p><hr>' : '<p class="text-center"><b>In process by analyst</b></p><hr>';
            $salida .= '</div>';
        } else {
            $salida .= '<p class="text-center"><b>In process by analyst</b></p><br><hr>';
            $salida .= '</div>';
        }

        $salida .= '<p class="text-center "><strong>Studies Record</strong></p>';
        $data['s_estudios'] = $this->candidato_model->checkEstatusEstudios($id_candidato);
        if ($data['s_estudios']) {
            foreach ($data['s_estudios'] as $e) {
                $aux = explode('-', $e->fecha);
                $f3  = $aux[1] . '/' . $aux[2] . '/' . $aux[0];
                $salida .= '<div class="col-md-12">';
                $salida .= '<p>Date: ' . $f3 . '</p><p>Comment: ' . $e->comentarios . '</p></div>';
                $e_terminado = $e->finalizado;
            }
            $salida .= ($e_terminado == 1) ? '<p class="text-center"><b>Completed</b></p>' : '<p class="text-center"><b>In process by analyst</b></p>';
            $salida .= '</div>';
        } else {
            $salida .= '<p class="text-center"><b>In process by analyst</b></p><br>';
            $salida .= '</div>';
        }
        $salida .= '</div>';

        echo $salida;
    }
    public function getCancelacion()
    {
        $id_candidato = $_POST['id_candidato'];
        $candidato    = $this->candidato_model->getCancelacion($id_candidato);
        $salida       = $candidato->creacion . '##' . $candidato->motivo;
        echo $salida;
    }
    public function getEliminacion()
    {
        $id_candidato = $_POST['id_candidato'];
        $candidato    = $this->candidato_model->getEliminacion($id_candidato);
        $salida       = $candidato->creacion . '##' . $candidato->motivo;
        echo $salida;
    }

    public function checkLlamadas()
    {
        $id_candidato    = $_POST['id_candidato'];
        $salida          = "";
        $data['estatus'] = $this->candidato_model->checkLlamadas($id_candidato);
        if ($data['estatus']) {
            foreach ($data['estatus'] as $l) {
                $parte         = explode(' ', $l->fecha);
                $aux           = explode('-', $parte[0]);
                $h             = explode(':', $parte[1]);
                $fecha_estatus = $aux[2] . '/' . $aux[1] . '/' . $aux[0] . ' ' . $h[0] . ':' . $h[1];
                $salida .= '<div class="row">
                                <div class="col-md-3">
                                    <p class="text-center"><b>Fecha</b></p>
                                    <p class="text-center">' . $fecha_estatus . '</p>
                                </div>
                                <div class="col-md-9">
                                    <label>Comentario / Estatus</label>
                                    <p>' . $l->comentarios . '</p>
                                </div>
                            </div>';
                $id_status = $l->idLlamada;
                $terminado = $l->finalizado;
            }
            echo $salida . '@@' . $id_status . '@@' . $terminado;
        } else {
            echo $salida = 0;
        }
    }
    public function createEstatusLlamada()
    {
        $id_candidato = $_POST['id_candidato'];
        $id_llamada   = $_POST['id_llamada'];
        $comentario   = $_POST['comentario'];
        $id_usuario   = $this->session->userdata('id');
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $salida = "";
        if ($id_llamada == 0) {
            $nueva_llamada = $this->candidato_model->createEstatusLlamada($id_candidato, $id_usuario, $date);
            $this->candidato_model->createDetalleEstatusLlamada($nueva_llamada, $date, $comentario);
            $data['estatus'] = $this->candidato_model->checkLlamadas($id_candidato);
            foreach ($data['estatus'] as $ref) {
                $parte         = explode(' ', $ref->fecha);
                $aux           = explode('-', $parte[0]);
                $h             = explode(':', $parte[1]);
                $fecha_estatus = $aux[2] . '/' . $aux[1] . '/' . $aux[0] . ' ' . $h[0] . ':' . $h[1];
                $salida .= '<div class="row">
                                <div class="col-md-3">
                                    <p class="text-center"><b>Fecha</b></p>
                                    <p class="text-center">' . $fecha_estatus . '</p>
                                </div>
                                <div class="col-md-9">
                                    <label>Comentario / Estatus</label>
                                    <p>' . $ref->comentarios . '</p>
                                </div>
                            </div>';
                $id_llamada = $ref->idLlamada;
            }
            echo $salida . '@@' . $id_llamada;
        } else {
            $this->candidato_model->createDetalleEstatusLlamada($id_llamada, $date, $comentario);
            $data['estatus'] = $this->candidato_model->checkLlamadas($id_candidato);
            foreach ($data['estatus'] as $ref) {
                $parte         = explode(' ', $ref->fecha);
                $aux           = explode('-', $parte[0]);
                $h             = explode(':', $parte[1]);
                $fecha_estatus = $aux[2] . '/' . $aux[1] . '/' . $aux[0] . ' ' . $h[0] . ':' . $h[1];
                $salida .= '<div class="row">
                                <div class="col-md-3">
                                    <p class="text-center"><b>Fecha</b></p>
                                    <p class="text-center">' . $fecha_estatus . '</p>
                                </div>
                                <div class="col-md-9">
                                    <label>Comentario / Estatus</label>
                                    <p>' . $ref->comentarios . '</p>
                                </div>
                            </div>';
            }
            echo $salida . '@@' . $id_llamada;
        }
    }
    public function viewLlamadas()
    {
        $id_candidato = $_POST['id_candidato'];
        $id_cliente   = $_POST['id_cliente'];
        $res          = $this->cliente_model->checkIngles($id_cliente);
        $salida       = '<div class="row">';
        $salida .= '<div class="col-md-12">';
        $data['llamadas'] = $this->candidato_model->checkLlamadas($id_candidato);
        if ($data['llamadas']) {
            foreach ($data['llamadas'] as $row) {
                $parte         = explode(' ', $row->fecha);
                $aux           = explode('-', $parte[0]);
                $h             = explode(':', $parte[1]);
                $fecha_ingles  = $aux[1] . '/' . $aux[2] . '/' . $aux[0] . ' ' . $h[0] . ':' . $h[1];
                $fecha_espanol = $aux[2] . '/' . $aux[1] . '/' . $aux[0] . ' ' . $h[0] . ':' . $h[1];
                $salida .= ($res->ingles == 1) ? '<p style="padding-right: 5px;"><b>Date: </b>' . $fecha_ingles . '</p><p><b>Comment: </b>' . $row->comentarios . '</p><br>' : '<p style="padding-right: 5px;"><b>Fecha: </b>' . $fecha_espanol . '</p><p><b>Comentario:</b> ' . $row->comentarios . '</p><br>';
                $row_terminado = $row->status;
            }
            /*$txt1 = ($res->ingles == 1)? 'Completed':'Completado';
            $txt2 = ($res->ingles == 1)? 'In process by analyst':'En proceso por el analista';
            $salida .= ($row_terminado > 0)? '<p class="text-center"><b>'.$txt1.'</b></p>' : '<p class="text-center"><b>'.$txt2.'</b></p>';*/
            $salida .= '</div>';
        } else {
            $salida .= ($res->ingles == 1) ? '<p class="text-center"><b>There are not calls phone to candidate</b></p><br>' : '<p class="text-center"><b>No hay llamadas al candidato</b></p><br>';
            $salida .= '</div>';
        }
        $salida .= '</div>';

        echo $salida;
    }

    public function checkEmails()
    {
        $id_candidato    = $_POST['id_candidato'];
        $salida          = "";
        $data['estatus'] = $this->candidato_model->checkEmails($id_candidato);
        if ($data['estatus']) {
            foreach ($data['estatus'] as $l) {
                $parte         = explode(' ', $l->fecha);
                $aux           = explode('-', $parte[0]);
                $h             = explode(':', $parte[1]);
                $fecha_estatus = $aux[2] . '/' . $aux[1] . '/' . $aux[0] . ' ' . $h[0] . ':' . $h[1];
                $salida .= '<div class="row">
                                <div class="col-md-3">
                                    <p class="text-center"><b>Fecha</b></p>
                                    <p class="text-center">' . $fecha_estatus . '</p>
                                </div>
                                <div class="col-md-9">
                                    <label>Comentario / Estatus</label>
                                    <p>' . $l->comentarios . '</p>
                                </div>
                            </div>';
                $id_status = $l->idEmail;
                $terminado = $l->finalizado;
            }
            echo $salida . '@@' . $id_status . '@@' . $terminado;
        } else {
            echo $salida = 0;
        }
    }

    public function createEstatusEmail()
    {
        $id_candidato = $_POST['id_candidato'];
        $id_email     = $_POST['id_email'];
        $comentario   = $_POST['comentario'];
        $id_usuario   = $this->session->userdata('id');
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $salida = "";
        if ($id_email == 0) {
            $nuevo_email = $this->candidato_model->createEstatusEmail($id_candidato, $id_usuario, $date);
            $this->candidato_model->createDetalleEstatusEmail($nuevo_email, $date, $comentario);
            $data['estatus'] = $this->candidato_model->checkEmails($id_candidato);
            foreach ($data['estatus'] as $ref) {
                $parte         = explode(' ', $ref->fecha);
                $aux           = explode('-', $parte[0]);
                $h             = explode(':', $parte[1]);
                $fecha_estatus = $aux[2] . '/' . $aux[1] . '/' . $aux[0] . ' ' . $h[0] . ':' . $h[1];
                $salida .= '<div class="row">
                                <div class="col-md-3">
                                    <p class="text-center"><b>Fecha</b></p>
                                    <p class="text-center">' . $fecha_estatus . '</p>
                                </div>
                                <div class="col-md-9">
                                    <label>Comentario / Estatus</label>
                                    <p>' . $ref->comentarios . '</p>
                                </div>
                            </div>';
                $id_email = $ref->idEmail;
            }
            echo $salida . '@@' . $id_email;
        } else {
            $this->candidato_model->createDetalleEstatusEmail($id_email, $date, $comentario);
            $data['estatus'] = $this->candidato_model->checkEmails($id_candidato);
            foreach ($data['estatus'] as $ref) {
                $parte         = explode(' ', $ref->fecha);
                $aux           = explode('-', $parte[0]);
                $h             = explode(':', $parte[1]);
                $fecha_estatus = $aux[2] . '/' . $aux[1] . '/' . $aux[0] . ' ' . $h[0] . ':' . $h[1];
                $salida .= '<div class="row">
                                <div class="col-md-3">
                                    <p class="text-center"><b>Fecha</b></p>
                                    <p class="text-center">' . $fecha_estatus . '</p>
                                </div>
                                <div class="col-md-9">
                                    <label>Comentario / Estatus</label>
                                    <p>' . $ref->comentarios . '</p>
                                </div>
                            </div>';
            }
            echo $salida . '@@' . $id_email;
        }
    }
    public function viewEmails()
    {
        $id_candidato = $_POST['id_candidato'];
        $id_cliente   = $_POST['id_cliente'];
        $res          = $this->cliente_model->checkIngles($id_cliente);
        $salida       = '<div class="row">';
        $salida .= '<div class="col-md-12">';
        $data['emails'] = $this->candidato_model->checkEmails($id_candidato);
        if ($data['emails']) {
            foreach ($data['emails'] as $row) {
                $parte         = explode(' ', $row->fecha);
                $aux           = explode('-', $parte[0]);
                $h             = explode(':', $parte[1]);
                $fecha_ingles  = $aux[1] . '/' . $aux[2] . '/' . $aux[0] . ' ' . $h[0] . ':' . $h[1];
                $fecha_espanol = $aux[2] . '/' . $aux[1] . '/' . $aux[0] . ' ' . $h[0] . ':' . $h[1];
                $salida .= ($res->ingles == 1) ? '<p style="padding-right: 5px;"><b>Date:</b> ' . $fecha_ingles . '</p><p><b>Comment: </b>' . $row->comentarios . '</p><br>' : '<p style="padding-right: 5px;"><b>Fecha:</b> ' . $fecha_espanol . '</p><p><b>Comentario: </b>' . $row->comentarios . '</p><br>';
                $row_terminado = $row->status;
            }
            /*$txt1 = ($res->ingles == 1)? 'Completed':'Completado';
            $txt2 = ($res->ingles == 1)? 'In process by analyst':'En proceso por el analista';
            $salida .= ($row_terminado > 0)? '<p class="text-center"><b>'.$txt1.'</b></p>' : '<p class="text-center"><b>'.$txt2.'</b></p>';*/
            $salida .= '</div>';
        } else {
            $salida .= ($res->ingles == 1) ? '<p class="text-center"><b>There are not emails to candidate</b></p><br>' : '<p class="text-center"><b>No hay emails al candidato</b></p><br>';
            $salida .= '</div>';
        }
        $salida .= '</div>';

        echo $salida;
    }

    public function viewDocumentos()
    {
        $id_candidato = $_POST['id_candidato'];
        $salida       = "";
        $data['docs'] = $this->candidato_model->getDocumentos($id_candidato);
        if ($data['docs']) {
            $salida .= "<ul>";
            foreach ($data['docs'] as $doc) {
                $salida .= '<li><b><a href="' . base_url() . '_docs/' . $doc->archivo . '" target="_blank">' . $doc->archivo . '</a></b> (' . $doc->tipo . ')</li>';
            }
            $salida .= "</ul>";
            echo $salida;
        } else {
            echo $salida = 0;
        }
    }

    public function getPaqueteAntidoping()
    {
        $id_paq_antidoping = $_POST['antidoping'];
        $paq               = $this->candidato_model->getPaqueteAntidoping($id_paq_antidoping);
        echo $paq->nombre;
    }
    public function getSustanciasAntidoping()
    {
        $salida     = "";
        $sustancias = $_POST['antidoping'];
        $aux        = explode(',', $sustancias);
        for ($i = 0; $i < count($aux); $i++) {
            $sust = $this->candidato_model->getSustanciaAntidoping($aux[$i]);
            $salida .= $sust->abreviatura . "<br>";
        }

        echo $salida;
    }
    public function getBateria()
    {
        $id_bateria = $_POST['psicometrico'];
        $psi        = $this->candidato_model->getBateria($id_bateria);
        echo $psi->nombre;
    }
    public function getPruebasPsicometrico()
    {
        $salida  = "";
        $pruebas = $_POST['psicometrico'];
        $aux     = explode(',', $pruebas);
        for ($i = 0; $i < count($aux); $i++) {
            $pru = $this->candidato_model->getPruebasPsicometrico($aux[$i]);
            $salida .= $pru->abreviatura . "<br>";
        }
        echo $salida;
    }
    public function getBuroCredito()
    {
        $id_buro = $_POST['buro'];
        $buro    = $this->candidato_model->getBuroCredito($id_buro);
        echo $buro->nombre;
    }
    public function finalizarDocumentos()
    {
        date_default_timezone_set('America/Mexico_City');
        $date         = date('Y-m-d H:i:s');
        $id_candidato = $_POST['id_candidato'];
        $data['docs'] = $this->candidato_model->checkDocsCandidato($id_candidato);
        if ($data['docs']) {
            foreach ($data['docs'] as $doc) {
                $docs[] = $doc->id_tipo_documento;
            }
            if ($this->session->userdata('proyecto') == 21) {
                $ine      = (in_array(3, $docs)) ? 1 : "Upload your ID (IFE, INE or Passport)<br>";
                $penales  = (in_array(12, $docs)) ? 1 : "Upload your non-criminal background letter<br>";
                $estudios = (in_array(7, $docs) || in_array(10, $docs)) ? 1 : "Upload your professional licence or studies certificate<br>";
                $aviso    = (in_array(8, $docs)) ? 1 : "Upload your non-disclosure agreement<br>";
                $semanas  = (in_array(9, $docs)) ? 1 : "Upload your IMSS report<br>";
                $dom      = (in_array(2, $docs)) ? 1 : "your current proof of address<br>";

                if ($ine == 1 && $penales == 1 && $estudios == 1 && $aviso == 1 && $dom == 1) {
                    $candidato = [
                        "token"            => "completo",
                        "fecha_documentos" => $date,
                    ];
                    $this->candidato_model->editarCandidato($candidato, $id_candidato);
                    echo $salida = 1;
                } else {
                    echo $ine . "" . $penales . "" . $estudios . "" . $aviso . "" . $semanas . "" . $dom;
                }
            }
            if ($this->session->userdata('proyecto') == 26) {
                $ine     = (in_array(3, $docs)) ? 1 : "Upload your ID (IFE, INE or Passport)<br>";
                $penales = (in_array(12, $docs)) ? 1 : "Upload your non-criminal background letter<br>";
                //$estudios = (in_array(7, $docs) || in_array(10, $docs))? 1:"Upload your professional licence or studies certificate<br>";
                $aviso = (in_array(8, $docs)) ? 1 : "Upload your non-disclosure agreement<br>";
                //$semanas = (in_array(9, $docs))? 1:"Upload your IMSS report<br>";

                if ($ine == 1 && $penales == 1 && $aviso == 1) {
                    $candidato = [
                        "token"            => "completo",
                        "fecha_documentos" => $date,
                    ];
                    $this->candidato_model->editarCandidato($candidato, $id_candidato);
                    echo $salida = 1;
                } else {
                    echo $ine . "" . $penales . "" . $aviso;
                }

            }
            if ($this->session->userdata('proyecto') == 27) {
                $ine     = (in_array(3, $docs)) ? 1 : "Upload your ID (IFE, INE or Passport)<br>";
                $penales = (in_array(12, $docs)) ? 1 : "Upload your non-criminal background letter<br>";
                //$estudios = (in_array(7, $docs) || in_array(10, $docs))? 1:"Upload your professional licence or studies certificate<br>";
                $aviso = (in_array(8, $docs)) ? 1 : "Upload your non-disclosure agreement<br>";
                $dom   = (in_array(2, $docs)) ? 1 : "your current proof of address<br>";

                if ($ine == 1 && $penales == 1 && $aviso == 1 && $dom == 1) {
                    $candidato = [
                        "token"            => "completo",
                        "fecha_documentos" => $date,
                    ];
                    $this->candidato_model->editarCandidato($candidato, $id_candidato);
                    echo $salida = 1;
                } else {
                    echo $ine . "" . $penales . "" . $aviso . "" . $dom;
                }

            }
            if ($this->session->userdata('proyecto') == 35) {
                $ine = (in_array(3, $docs)) ? 1 : "Upload your ID (IFE, INE, Passport or Immigration ID)<br>";
                //$penales = (in_array(12, $docs))? 1:"Upload your non-criminal background letter<br>";
                $estudios = (in_array(7, $docs) || in_array(10, $docs)) ? 1 : "Upload your professional licence or studies certificate<br>";
                $aviso    = (in_array(8, $docs)) ? 1 : "Upload your non-disclosure agreement<br>";
                //$semanas = (in_array(9, $docs))? 1:"Upload your IMSS report<br>";

                if ($ine == 1 && $estudios == 1 && $aviso == 1) {
                    $candidato = [
                        "token"            => "completo",
                        "fecha_documentos" => $date,
                    ];
                    $this->candidato_model->editarCandidato($candidato, $id_candidato);
                    echo $salida = 1;
                } else {
                    echo $ine . "" . $estudios . "" . $aviso;
                }
            }
            if ($this->session->userdata('proyecto') != 26 && $this->session->userdata('proyecto') != 27 && $this->session->userdata('proyecto') != 21 && $this->session->userdata('proyecto') != 35 && $this->session->userdata('proyecto') != 150) {
                $ine      = (in_array(3, $docs)) ? 1 : "Upload your ID (IFE, INE or Passport)<br>";
                $penales  = (in_array(12, $docs)) ? 1 : "Upload your non-criminal background letter<br>";
                $estudios = (in_array(7, $docs) || in_array(10, $docs)) ? 1 : "Upload your professional licence or studies certificate<br>";
                $aviso    = (in_array(8, $docs)) ? 1 : "Upload your non-disclosure agreement<br>";
                $semanas  = (in_array(9, $docs)) ? 1 : "Upload your IMSS report<br>";

                if ($ine == 1 && $penales == 1 && $estudios == 1 && $aviso == 1) {
                    $candidato = [
                        "token"            => "completo",
                        "fecha_documentos" => $date,
                    ];
                    $this->candidato_model->editarCandidato($candidato, $id_candidato);
                    echo $salida = 1;
                } else {
                    echo $ine . "" . $penales . "" . $estudios . "" . $aviso . "" . $semanas;
                }
            }
            if ($this->session->userdata('proyecto') == 150) {
                $ine      = (in_array(3, $docs)) ? 1 : "Upload your ID<br>";
                $estudios = (in_array(7, $docs) || in_array(10, $docs)) ? 1 : "Upload your professional licence or studies certificate<br>";
                $aviso    = (in_array(8, $docs)) ? 1 : "Upload the signed non-disclosure agreement<br>";
                $dom      = (in_array(2, $docs)) ? 1 : "your current proof of address<br>";

                if ($ine == 1 && $estudios == 1 && $aviso == 1 && $dom == 1) {
                    $candidato = [
                        "token"            => "completo",
                        "fecha_documentos" => $date,
                    ];
                    $this->candidato_model->editarCandidato($candidato, $id_candidato);
                    echo $salida = 1;
                } else {
                    echo $ine . "" . $estudios . "" . $aviso . "" . $dom;
                }
            }
        } else {
            echo $salida = 0;
        }

    }
    public function getSubclientes()
    {
        $id_cliente          = $_POST['id_cliente'];
        $data['subclientes'] = $this->candidato_model->getSublientes($id_cliente);
        $salida              = "<option value=''>Selecciona</option>";
        if ($data['subclientes']) {
            foreach ($data['subclientes'] as $row) {
                $salida .= "<option value='" . $row->id . "'>" . $row->nombre . "</option>";
            }
            echo $salida;
        } else {
            $salida .= "<option value='0'>N/A</option>";
            echo $salida;
        }
    }
    /*----------------------------------------*/
    /*  Visitador
    /*----------------------------------------*/
    public function getCandidatosVisitador()
    {
        $cand['recordsTotal']    = $this->candidato_model->getTotalCandidatosVisitador();
        $cand['recordsFiltered'] = $this->candidato_model->getTotalCandidatosVisitador();
        $cand['data']            = $this->candidato_model->getCandidatosVisitador();
        $this->output->set_output(json_encode($cand));
    }
    /*----------------------------------------*/
    /*  TATA
    /*----------------------------------------*/
    public function getDetalleCandidatoTata()
    {
        $idCandidato = $this->input->post('idCandidato');
        $salida      = "";
        $dato        = $this->candidato_model->getDetalleCandidatoTata($idCandidato);
        $salida .= '<table class="table table-striped">';
        $salida .= '<thead>';
        $salida .= '<tr>';
        $salida .= '<th scope="col">Candidato</th>';
        $salida .= '<th scope="col">Proyecto</th>';
        $salida .= '<th scope="col">Fecha de alta</th>';
        $salida .= '<th scope="col">Fecha final</th>';
        $salida .= '<th scope="col">SLA</th>';
        $salida .= '<th scope="col">Acciones</th>';
        $salida .= '</tr>';
        $salida .= '</thead>';
        $salida .= '<tbody>';
        $fecha_alta  = fecha_sinhora_espanol_bd($dato->fecha_alta);
        $fecha_final = fecha_sinhora_espanol_bd($dato->fecha_final);
        if ($dato->status_bgc == 1) {
            $color = '<i class="fas fa-circle status_bgc1"></i> ';
        }
        if ($dato->status_bgc == 2) {
            $color = '<i class="fas fa-circle status_bgc2"></i> ';
        }
        if ($dato->status_bgc == 3) {
            $color = '<i class="fas fa-circle status_bgc3"></i> ';
        }
        $salida .= "<tr><th>" . $color . $dato->candidato . "</th><th>" . $dato->proyecto . "</th><th>" . $fecha_alta . "</th><th>" . $fecha_final . "</th><th>" . $dato->tiempo . " dia(s)</th><th><button class='btn btn-primary btn-sm' onclick='eliminarEstudio(" . $dato->id . "," . $dato->id_cliente . ",\"" . $dato->candidato . "\")'>Eliminar</button></th>";
        $salida .= '</tbody>';
        $salida .= '</table>';
        echo $salida;
    }
    /*----------------------------------------*/
    /*  HCL
    /*----------------------------------------*/
    public function addCandidatoIngles()
    {
        $this->form_validation->set_rules('nombre', 'Name', 'required|trim|callback_alpha_space_only_english');
        $this->form_validation->set_rules('paterno', 'First lastname', 'required|trim|callback_alpha_space_only_english');
        $this->form_validation->set_rules('materno', 'Second lastname', 'required|trim|callback_alpha_space_only_english');
        $this->form_validation->set_rules('correo', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('celular', 'Cell phone number', 'required|numeric|max_length[10]|min_length[10]');
        $this->form_validation->set_rules('fijo', 'Home number', 'numeric|max_length[10]|min_length[10]');
        $this->form_validation->set_rules('proyecto', 'Proyecto', 'required|numeric');
        /*if(empty($this->input->post('ine')) || $this->input->post('ine') == 'undefined'){

        $this->form_validation->set_rules('ine', 'ine o solicitud de empleo', 'callback_required_file');
        }*/
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
        $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un email válido');
        $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');
        $this->form_validation->set_message('min_length', 'El campo {field} no es válido');
        $this->form_validation->set_message('max_length', 'El campo {field} no es válido');
        $this->form_validation->set_message('less_than', 'El campo {field} no es válido');
        $this->form_validation->set_message('greater_than', 'El campo {field} no es válido');
        if ($this->form_validation->run() != true) {
            echo validation_errors();
        }
        if ($this->form_validation->run() == true) {
            $id_cliente       = $this->session->userdata('idcliente');
            $nombre           = strtoupper($this->input->post('nombre'));
            $paterno          = strtoupper($this->input->post('paterno'));
            $materno          = strtoupper($this->input->post('materno'));
            $cel              = $this->input->post('celular');
            $tel              = $this->input->post('fijo');
            $correo           = strtolower($this->input->post('correo'));
            $fecha_nacimiento = $this->input->post('fecha_nacimiento');
            $proyecto         = $this->input->post('proyecto');
            $existeCandidato  = $this->candidato_model->repetidoCandidato($nombre, $paterno, $materno, $correo, $id_cliente);
            if ($existeCandidato > 0) {
                echo $res = 0;
            } else {
                date_default_timezone_set('America/Mexico_City');
                $date       = date('Y-m-d H:i:s');
                $id_usuario = $this->session->userdata('id');
                $last       = $this->candidato_model->lastIdCandidato();
                if (isset($_FILES['ine'])) {
                    $nombre_ine              = ($last->id + 1) . "_" . $this->input->post('nombre') . "" . $this->input->post('paterno') . "_" . $_FILES['ine']['name'];
                    $config['upload_path']   = './_docs/';
                    $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                    $config['overwrite']     = true;
                    $config['file_name']     = $nombre_ine;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    // File upload
                    if ($this->upload->do_upload('ine')) {
                        $documento = [
                            'creacion'          => $date,
                            'edicion'           => $date,
                            'id_candidato'      => ($last->id + 1),
                            'id_tipo_documento' => 3,
                            'archivo'           => $nombre_ine,
                        ];
                        $this->candidato_model->insertCVCandidato($documento);
                        $data = $this->upload->data();
                    }
                }
                if ($fecha_nacimiento != "" && $fecha_nacimiento != null) {
                    $fnacimiento = fecha_ingles_bd($fecha_nacimiento);
                } else {
                    $fnacimiento = "";
                }

                $base  = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
                $aux   = substr(md5(microtime()), 1, 8);
                $token = md5($aux . $base);
                $data  = [
                    'creacion'           => $date,
                    'edicion'            => $date,
                    'id_usuario_cliente' => $id_usuario,
                    'fecha_alta'         => $date,
                    'nombre'             => $nombre,
                    'paterno'            => $paterno,
                    'materno'            => $materno,
                    'correo'             => $correo,
                    'fecha_nacimiento'   => $fnacimiento,
                    'token'              => $token,
                    'id_cliente'         => $id_cliente,
                    'celular'            => $cel,
                    'telefono_casa'      => $tel,
                    'id_proyecto'        => $proyecto,
                ];
                $this->candidato_model->nuevoCandidato($data);

                $doping  = $this->candidato_model->getPaqueteAntidopingCandidato($id_cliente, $proyecto);
                $pruebas = [
                    'creacion'           => $date,
                    'edicion'            => $date,
                    'id_usuario_cliente' => $id_usuario,
                    'id_candidato'       => ($last->id + 1),
                    'id_cliente'         => $id_cliente,
                    'socioeconomico'     => 1,
                    'tipo_antidoping'    => 1,
                    'antidoping'         => $doping->id_antidoping_paquete,

                ];
                $this->candidato_model->insertPruebasCandidato($pruebas);

                $from              = $this->config->item('smtp_user');
                $to                = $correo;
                $subject           = strtolower($this->session->userdata('cliente')) . " - credentials for register form";
                $datos['password'] = $aux;
                $datos['cliente']  = strtoupper($this->session->userdata('cliente'));
                $datos['email']    = $correo;
                $message           = $this->load->view('login/mail_view', $datos, true);
                $this->load->library('phpmailer_lib');
                $mail = $this->phpmailer_lib->load();
                $mail->isSMTP();
                $mail->Host       = 'mail.rodicontrol.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'rodicontrol@rodicontrol.com';
                $mail->Password   = 'r49o*&rUm%91';
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;

                $mail->setFrom('rodicontrol@rodicontrol.com', 'Rodi');
                $mail->addAddress($to);
                $mail->Subject = $subject;
                $mail->isHTML(true);
                $mailContent = $message;
                $mail->Body  = $mailContent;

                if (! $mail->send()) {
                    //echo 'Message could not be sent.';
                    //echo 'Mailer Error: ' . $mail->ErrorInfo;
                    echo "No sent@@" . $aux;
                } else {
                    //echo 'Message has been sent';
                    echo "Sent@@" . $aux;
                }

            }
        }
    }
    public function candidateHCLStandard()
    {
        date_default_timezone_set('America/Mexico_City');
        $date         = date('Y-m-d H:i:s');
        $id_candidato = $this->session->userdata('id');

        $cadena = $this->input->post('datos');
        parse_str($cadena, $personal);
        $cadena3 = $this->input->post('complementos');
        parse_str($cadena3, $dato);

        $fecha     = fecha_ingles_bd($personal['fecha_nacimiento']);
        $edad      = calculaEdad($fecha);
        $candidato = [
            'fecha_contestado'     => $date,
            //'token' => 'completo',
            'edicion'              => $date,
            'fecha_nacimiento'     => $fecha,
            'edad'                 => $edad,
            'puesto'               => $personal['puesto'],
            'nacionalidad'         => $personal['nacionalidad'],
            'genero'               => $personal['genero'],
            'id_grado_estudio'     => $dato['estudios'],
            'estudios_periodo'     => $dato['estudios_periodo'],
            'estudios_escuela'     => $dato['estudios_escuela'],
            'estudios_ciudad'      => $dato['estudios_ciudad'],
            'estudios_certificado' => $dato['estudios_certificado'],
            'calle'                => $personal['calle'],
            'exterior'             => $personal['exterior'],
            'interior'             => $personal['interior'],
            'colonia'              => $personal['colonia'],
            'id_estado'            => $personal['estado'],
            'id_municipio'         => $personal['municipio'],
            'cp'                   => $personal['cp'],
            'estado_civil'         => $personal['civil'],
            'celular'              => $personal['telefono'],
            'telefono_casa'        => $personal['tel_casa'],
            'telefono_otro'        => $personal['tel_otro'],
            'comentario'           => $dato['obs'],
            'trabajo_inactivo'     => $dato['trabajo_inactivo'],
            'status'               => 1,
        ];
        $this->candidato_model->editarCandidato($candidato, $id_candidato);

        if ($_POST['trabajos'] != "") {
            $data_trabajo = "";
            $trab         = explode("@@", $_POST['trabajos']);
            for ($i = 0; $i < count($trab); $i++) {
                $aux = explode("__", $trab[$i]);
                if ($trab[$i] != "") {
                    $fentrada     = fecha_ingles_bd($aux[2]);
                    $fsalida      = fecha_ingles_bd($aux[3]);
                    $data_trabajo = [
                        'creacion'         => $date,
                        'edicion'          => $date,
                        'id_candidato'     => $id_candidato,
                        'empresa'          => ucwords(strtolower($aux[0])),
                        'direccion'        => ucwords(strtolower($aux[1])),
                        'fecha_entrada'    => $fentrada,
                        'fecha_salida'     => $fsalida,
                        'telefono'         => $aux[4],
                        'puesto1'          => ucwords(strtolower($aux[5])),
                        'puesto2'          => ucwords(strtolower($aux[6])),
                        'salario1'         => $aux[7],
                        'salario2'         => $aux[8],
                        'jefe_nombre'      => ucwords(strtolower($aux[9])),
                        'jefe_correo'      => strtolower($aux[10]),
                        'jefe_puesto'      => ucwords(strtolower($aux[11])),
                        'causa_separacion' => $aux[12],
                    ];
                    $this->candidato_model->saveRefLab($data_trabajo);
                }
            }
        }
        if (isset($_POST['doms'])) {
            $data_dom = "";
            $dom      = explode("@@", $_POST['doms']);
            for ($i = 0; $i < count($dom); $i++) {
                $aux = explode("__", $dom[$i]);
                if ($dom[$i] != "") {
                    if ($i == 0) {
                        $data_dom = [
                            'creacion'     => $date,
                            'edicion'      => $date,
                            'id_candidato' => $id_candidato,
                            'periodo'      => $aux[0],
                            'causa'        => $aux[1],
                            'calle'        => $personal['calle'],
                            'exterior'     => $personal['exterior'],
                            'interior'     => $personal['interior'],
                            'colonia'      => $personal['colonia'],
                            'id_estado'    => $personal['estado'],
                            'id_municipio' => $personal['municipio'],
                            'cp'           => $personal['cp'],
                        ];
                        $this->candidato_model->saveDomicilio($data_dom);
                    } else {
                        $data_dom = [
                            'creacion'     => $date,
                            'edicion'      => $date,
                            'id_candidato' => $id_candidato,
                            'periodo'      => $aux[0],
                            'causa'        => $aux[1],
                            'calle'        => $aux[2],
                            'exterior'     => $aux[3],
                            'interior'     => $aux[4],
                            'colonia'      => $aux[5],
                            'id_estado'    => $aux[6],
                            'id_municipio' => $aux[7],
                            'cp'           => $aux[8],
                        ];
                        $this->candidato_model->saveDomicilio($data_dom);
                    }
                }
            }
        }
        echo $hecho = 1;
    }
    public function formHCLInternational()
    {
        date_default_timezone_set('America/Mexico_City');
        $date         = date('Y-m-d H:i:s');
        $id_candidato = $this->session->userdata('id');

        $cadena = $this->input->post('datos');
        parse_str($cadena, $personal);
        $cadena3 = $this->input->post('complementos');
        parse_str($cadena3, $dato);

        $fecha     = fecha_espanol_bd($personal['fecha_nacimiento']);
        $edad      = calculaEdad($fecha);
        $candidato = [
            'fecha_contestado'        => $date,
            'edicion'                 => $date,
            'fecha_nacimiento'        => $fecha,
            'edad'                    => $edad,
            'puesto'                  => $personal['puesto'],
            'nacionalidad'            => $personal['nacionalidad'],
            'genero'                  => $personal['genero'],
            'id_grado_estudio'        => $dato['estudios'],
            'estudios_periodo'        => $dato['estudios_periodo'],
            'estudios_escuela'        => $dato['estudios_escuela'],
            'estudios_ciudad'         => $dato['estudios_ciudad'],
            'estudios_certificado'    => $dato['estudios_certificado'],
            'domicilio_internacional' => $personal['domicilio'],
            'pais'                    => $personal['pais'],
            'estado_civil'            => $personal['civil'],
            'celular'                 => $personal['telefono'],
            'telefono_casa'           => $personal['tel_casa'],
            'telefono_otro'           => $personal['tel_otro'],
            'comentario'              => $dato['obs'],
            'trabajo_inactivo'        => $dato['trabajo_inactivo'],
            'status'                  => 1,
        ];
        $this->candidato_model->editarCandidato($candidato, $id_candidato);

        if (isset($dato['refpro1_nombre'])) {
            $refpro1 = [
                'creacion'         => $date,
                'id_candidato'     => $id_candidato,
                'numero'           => 1,
                'nombre'           => $dato['refpro1_nombre'],
                'telefono'         => $dato['refpro1_telefono'],
                'tiempo_conocerlo' => $dato['refpro1_tiempo'],
                'donde_conocerlo'  => $dato['refpro1_conocido'],
                'puesto'           => $dato['refpro1_puesto'],
            ];
            $this->candidato_model->saveRefPer($refpro1);
        }
        if (isset($dato['refpro2_nombre'])) {
            $refpro2 = [
                'creacion'         => $date,
                'id_candidato'     => $id_candidato,
                'numero'           => 2,
                'nombre'           => $dato['refpro2_nombre'],
                'telefono'         => $dato['refpro2_telefono'],
                'tiempo_conocerlo' => $dato['refpro2_tiempo'],
                'donde_conocerlo'  => $dato['refpro2_conocido'],
                'puesto'           => $dato['refpro2_puesto'],
            ];
            $this->candidato_model->saveRefPer($refpro2);
        }
        if ($_POST['trabajos'] != "") {
            $data_trabajo = "";
            $trab         = explode("@@", $_POST['trabajos']);
            for ($i = 0; $i < count($trab); $i++) {
                $aux = explode("__", $trab[$i]);
                if ($trab[$i] != "") {
                    $fentrada     = fecha_espanol_bd($aux[2]);
                    $fsalida      = fecha_espanol_bd($aux[3]);
                    $data_trabajo = [
                        'creacion'         => $date,
                        'edicion'          => $date,
                        'id_candidato'     => $id_candidato,
                        'empresa'          => ucwords(strtolower($aux[0])),
                        'direccion'        => ucwords(strtolower($aux[1])),
                        'fecha_entrada'    => $fentrada,
                        'fecha_salida'     => $fsalida,
                        'telefono'         => $aux[4],
                        'puesto1'          => ucwords(strtolower($aux[5])),
                        'puesto2'          => ucwords(strtolower($aux[6])),
                        'salario1'         => $aux[7],
                        'salario2'         => $aux[8],
                        'jefe_nombre'      => ucwords(strtolower($aux[9])),
                        'jefe_correo'      => strtolower($aux[10]),
                        'jefe_puesto'      => ucwords(strtolower($aux[11])),
                        'causa_separacion' => $aux[12],
                    ];
                    $this->candidato_model->saveRefLab($data_trabajo);
                }
            }
        }
        if (isset($_POST['doms'])) {
            $data_dom = "";
            $dom      = explode("@@", $_POST['doms']);
            for ($i = 0; $i < count($dom); $i++) {
                $aux = explode("__", $dom[$i]);
                if ($dom[$i] != "") {
                    if ($i == 0) {
                        $data_dom = [
                            'creacion'                => $date,
                            'edicion'                 => $date,
                            'id_candidato'            => $id_candidato,
                            'periodo'                 => $aux[0],
                            'causa'                   => $aux[1],
                            'domicilio_internacional' => $personal['domicilio'],
                            'pais'                    => $personal['pais'],
                        ];
                        $this->candidato_model->saveDomicilio($data_dom);
                    } else {
                        $data_dom = [
                            'creacion'                => $date,
                            'edicion'                 => $date,
                            'id_candidato'            => $id_candidato,
                            'periodo'                 => $aux[0],
                            'causa'                   => $aux[1],
                            'domicilio_internacional' => $aux[2],
                            'pais'                    => $aux[3],
                        ];
                        $this->candidato_model->saveDomicilio($data_dom);
                    }
                }
            }
        }
        echo $hecho = 1;
    }

    public function getReferenciasLaborales()
    {
        $id_candidato        = $_POST['id_candidato'];
        $salida              = "";
        $cont                = 1;
        $data['referencias'] = $this->candidato_model->getReferencias($id_candidato);
        if ($data['referencias']) {
            foreach ($data['referencias'] as $ref) {
                $fi = fecha_sinhora_ingles_front($ref->fecha_entrada);
                $ff = fecha_sinhora_ingles_front($ref->fecha_salida);
                $salida .= '<div class="box-header text-center tituloSubseccion">
                                <p class="box-title " id="titulo_reflab1"><strong>  Reference #' . $cont . ' </strong><hr></p>
                                <input type="hidden" id="idreflab' . $cont . '" value="' . $ref->id . '">
                            </div>
                            <p class="tituloSubseccion text-center"></p>
                            <div class="col-md-6">
                                <p class="tituloSubseccion">Candidate</p>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Company: </label>
                                        <br>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="reflab' . $cont . '_empresa">' . $ref->empresa . '</p>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Address: </label>
                                        <br>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="reflab' . $cont . '_direccion">' . $ref->direccion . '</p>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Entry Date: </label>
                                        <br>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="reflab' . $cont . '_entrada">' . $fi . '</p>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Exit Date: </label>
                                        <br>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="reflab' . $cont . '_salida">' . $ff . '</p>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Phone: </label>
                                        <br>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="reflab' . $cont . '_telefono">' . $ref->telefono . '</p>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Initial Job Position </label>
                                        <br>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="reflab' . $cont . '_puesto1">' . $ref->puesto1 . '</p>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Last Job Position </label>
                                        <br>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="reflab' . $cont . '_puesto2">' . $ref->puesto2 . '</p>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Initial Salary </label>
                                        <br>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="reflab' . $cont . '_salario1">$' . $ref->salario1 . '</p>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Last Salary </label>
                                        <br>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="reflab' . $cont . '_salario2">$' . $ref->salario2 . '</p>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Immediate Boss Name </label>
                                        <br>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="reflab' . $cont . '_bossnombre">' . $ref->jefe_nombre . '</p>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Immediate Boss Email </label>
                                        <br>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="reflab' . $cont . '_bosscorreo">' . $ref->jefe_correo . '</p>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Immediate Boss Position </label>
                                        <br>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="reflab' . $cont . '_bosspuesto">' . $ref->jefe_puesto . '</p>
                                        <br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Cause of Separation </label>
                                        <br>
                                    </div>
                                    <div class="col-md-9">
                                        <p id="reflab' . $cont . '_separacion">' . $ref->causa_separacion . '</p>
                                        <br>
                                    </div>
                                </div>
                            </div>';

                $vlaboral = $this->candidato_model->getVerificacionLaboral($cont, $id_candidato);
                if (isset($vlaboral)) {
                    $vfi = fecha_sinhora_ingles_front($vlaboral->fecha_entrada);
                    $vff = fecha_sinhora_ingles_front($vlaboral->fecha_salida);
                    $salida .= '<form id=update_vlaboral' . $cont . '>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <p class="tituloSubseccion text-center">Analist</p>
                                                    <div class="col-md-3">
                                                        <label>Company: </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_empresa" id="verlab' . $cont . '_empresa" value="' . $vlaboral->empresa . '">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Address: </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control reflab1_obligado" name="verlab' . $cont . '_direccion" id="verlab' . $cont . '_direccion" value="' . $vlaboral->direccion . '">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Entry Date: </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control solo_lectura verlab' . $cont . '_obligado fecha_reflab" name="verlab' . $cont . '_entrada" id="verlab' . $cont . '_entrada" value="' . $vfi . '" readonly>
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Exit Date: </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control solo_lectura verlab' . $cont . '_obligado fecha_reflab" name="verlab' . $cont . '_salida" id="verlab' . $cont . '_salida" value="' . $vff . '" readonly>
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Phone: </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control solo_numeros verlab' . $cont . '_obligado" name="verlab' . $cont . '_telefono" id="verlab' . $cont . '_telefono" value="' . $vlaboral->telefono . '" maxlength="10">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Initial Job Position </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_puesto1" id="verlab' . $cont . '_puesto1" value="' . $vlaboral->puesto1 . '">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Last Job Position </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_puesto2" id="verlab' . $cont . '_puesto2" value="' . $vlaboral->puesto2 . '">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Initial Salary </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control solo_numeros verlab' . $cont . '_obligado" name="verlab' . $cont . '_salario1" id="verlab' . $cont . '_salario1" value="' . $vlaboral->salario1 . '" maxlength="8">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Last Salary </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control solo_numeros verlab' . $cont . '_obligado" name="verlab' . $cont . '_salario2" id="verlab' . $cont . '_salario2" value="' . $vlaboral->salario2 . '" maxlength="8">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Immediate Boss Name </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_bossnombre" id="verlab' . $cont . '_bossnombre" value="' . $vlaboral->jefe_nombre . '">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Immediate Boss Email </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_bosscorreo" id="verlab' . $cont . '_bosscorreo" value="' . $vlaboral->jefe_correo . '">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Immediate Boss Position </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_bosspuesto" id="verlab' . $cont . '_bosspuesto" value="' . $vlaboral->jefe_puesto . '">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Cause of Separation </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_separacion" id="verlab' . $cont . '_separacion" value="' . $vlaboral->causa_separacion . '">
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <label>Notes *</label>
                                                    <textarea class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_notas" id="verlab' . $cont . '_notas" rows="3">' . $vlaboral->notas . '</textarea>
                                                </div>
                                            </div>
                                            <br><p class="tituloSubseccion text-center">Candidate Performance' . $cont . '</p><br>
                                            <div class="row">
                                                <div class="col-md-4 col-md-offset-4">
                                                    <label for="aplicar_todo' . $cont . '">Apply to all</label>
                                                    <select id="aplicar_todo' . $cont . '" class="form-control">
                                                        <option value="-1">Select</option>
                                                        <option value="0">Not provided</option>
                                                        <option value="1">Excellent</option>
                                                        <option value="2">Good</option>
                                                        <option value="3">Regular</option>
                                                        <option value="4">Bad</option>
                                                        <option value="5">Very Bad</option>
                                                    </select>
                                                    <br><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_responsabilidad">Responsability *</label>
                                                    <select name="verlab' . $cont . '_responsabilidad" id="verlab' . $cont . '_responsabilidad" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                        <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_iniciativa">Initiative *</label>
                                                    <select name="verlab' . $cont . '_iniciativa" id="verlab' . $cont . '_iniciativa" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_eficiencia">Work efficiency *</label>
                                                    <select name="verlab' . $cont . '_eficiencia" id="verlab' . $cont . '_eficiencia" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_disciplina">Discipline *</label>
                                                    <select name="verlab' . $cont . '_disciplina" id="verlab' . $cont . '_disciplina" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_puntualidad">Punctuality and assistance *</label>
                                                    <select name="verlab' . $cont . '_puntualidad" id="verlab' . $cont . '_puntualidad" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_limpieza">Cleanliness and order *</label>
                                                    <select name="verlab' . $cont . '_limpieza" id="verlab' . $cont . '_limpieza" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_estabilidad">Stability *</label>
                                                    <select name="verlab' . $cont . '_estabilidad" id="verlab' . $cont . '_estabilidad" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_emocional">Emotional Stability *</label>
                                                    <select name="verlab' . $cont . '_emocional" id="verlab' . $cont . '_emocional" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_honesto">Honesty *</label>
                                                    <select name="verlab' . $cont . '_honesto" id="verlab' . $cont . '_honesto" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_rendimiento">Performance *</label>
                                                    <select name="verlab' . $cont . '_rendimiento" id="verlab' . $cont . '_rendimiento" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="verlab' . $cont . '_actitud">Attitude with coworkers, bosses and subordinates *</label>
                                                    <select name="verlab' . $cont . '_actitud" id="verlab' . $cont . '_actitud" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="verlab' . $cont . '_recontratacion">In case of vacancy would you hire her/him again? *</label>
                                                    <select name="verlab' . $cont . '_recontratacion" id="verlab' . $cont . '_recontratacion" class="form-control verlab' . $cont . '_obligado">
                                                        <option value="">Select</option>
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                    <br><br><br>
                                                </div>
                                                <div class="col-md-8">
                                                    <label>Why? *</label>
                                                    <textarea class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_motivo" id="verlab' . $cont . '_motivo" rows="3">' . $vlaboral->motivo_recontratacion . '</textarea>
                                                    <br><br><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-md-offset-5">
                                                    <button type="button" class="btn btn-primary" onclick="updateVerificacionLaboral(' . $vlaboral->id . ',' . $cont . ')">Actualizar Verificación Laboral #' . $cont . '</button>
                                                    <br><br>
                                                </div>
                                            </div>
                                            </form>
                                            <script>
                                                $("#aplicar_todo' . $cont . '").change(function(){
                                                    var valor = $(this).val();
                                                    switch(valor){
                                                        case "-1":
                                                            $(".performance' . $cont . '").val("Not provided");
                                                            break;
                                                        case "0":
                                                            $(".performance' . $cont . '").val("Not provided");
                                                            break;
                                                        case "1":
                                                            $(".performance' . $cont . '").val("Excellent");
                                                            break;
                                                        case "2":
                                                            $(".performance' . $cont . '").val("Good");
                                                            break;
                                                        case "3":
                                                            $(".performance' . $cont . '").val("Regular");
                                                            break;
                                                        case "4":
                                                            $(".performance' . $cont . '").val("Bad");
                                                            break;
                                                        case "5":
                                                            $(".performance' . $cont . '").val("Very Bad");
                                                            break;
                                                    }
                                                });
                                                $("#verlab' . $cont . '_responsabilidad").val("' . $vlaboral->responsabilidad . '");
                                                $("#verlab' . $cont . '_iniciativa").val("' . $vlaboral->iniciativa . '");
                                                $("#verlab' . $cont . '_eficiencia").val("' . $vlaboral->eficiencia . '");
                                                $("#verlab' . $cont . '_disciplina").val("' . $vlaboral->disciplina . '");
                                                $("#verlab' . $cont . '_puntualidad").val("' . $vlaboral->puntualidad . '");
                                                $("#verlab' . $cont . '_limpieza").val("' . $vlaboral->limpieza . '");
                                                $("#verlab' . $cont . '_estabilidad").val("' . $vlaboral->estabilidad . '");
                                                $("#verlab' . $cont . '_emocional").val("' . $vlaboral->emocional . '");
                                                $("#verlab' . $cont . '_honesto").val("' . $vlaboral->honestidad . '");
                                                $("#verlab' . $cont . '_rendimiento").val("' . $vlaboral->rendimiento . '");
                                                $("#verlab' . $cont . '_actitud").val("' . $vlaboral->actitud . '");
                                                $("#verlab' . $cont . '_recontratacion").val("' . $vlaboral->recontratacion . '");
                                                $(".fecha_reflab").datetimepicker({minView: 2,format: "mm/dd/yyyy",startView: 4,autoclose: true,todayHighlight: true,forceParse: false});
                                            </script>';
                    $cont++;
                } else {

                    $salida .= '<form id=data_vlaboral' . $cont . '>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <p class="tituloSubseccion text-center">Analist</p>
                                                    <div class="col-md-3">
                                                        <label>Company: </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_empresa" id="verlab' . $cont . '_empresa">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Address: </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_direccion" id="verlab' . $cont . '_direccion">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Entry Date: </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control solo_lectura verlab' . $cont . '_obligado fecha_reflab" name="verlab' . $cont . '_entrada" id="verlab' . $cont . '_entrada" readonly>
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Exit Date: </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control solo_lectura verlab' . $cont . '_obligado fecha_reflab" name="verlab' . $cont . '_salida" id="verlab' . $cont . '_salida" readonly>
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Phone: </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control solo_numeros verlab' . $cont . '_obligado" name="verlab' . $cont . '_telefono" id="verlab' . $cont . '_telefono" maxlength="10">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Initial Job Position </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_puesto1" id="verlab' . $cont . '_puesto1">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Last Job Position </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_puesto2" id="verlab' . $cont . '_puesto2">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Initial Salary </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control solo_numeros verlab' . $cont . '_obligado" name="verlab' . $cont . '_salario1" id="verlab' . $cont . '_salario1" maxlength="8">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Last Salary </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control solo_numeros verlab' . $cont . '_obligado" name="verlab' . $cont . '_salario2" id="verlab' . $cont . '_salario2" maxlength="8">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Immediate Boss Name </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_bossnombre" id="verlab' . $cont . '_bossnombre">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Immediate Boss Email </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_bosscorreo" id="verlab' . $cont . '_bosscorreo">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Immediate Boss Position </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_bosspuesto" id="verlab' . $cont . '_bosspuesto">
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Cause of Separation </label>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_separacion" id="verlab' . $cont . '_separacion">
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <label>Notes *</label>
                                                    <textarea class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_notas" id="verlab' . $cont . '_notas" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <br><p class="tituloSubseccion text-center">Candidate Performance</p><br>
                                            <div class="row">
                                                <div class="col-md-4 col-md-offset-4">
                                                    <label for="aplicar_todo' . $cont . '">Apply to all</label>
                                                    <select id="aplicar_todo' . $cont . '" class="form-control">
                                                        <option value="-1">Select</option>
                                                        <option value="0">Not provided</option>
                                                        <option value="1">Excellent</option>
                                                        <option value="2">Good</option>
                                                        <option value="3">Regular</option>
                                                        <option value="4">Bad</option>
                                                        <option value="5">Very Bad</option>
                                                    </select>
                                                    <br><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_responsabilidad">Responsability *</label>
                                                    <select name="verlab' . $cont . '_responsabilidad" id="verlab' . $cont . '_responsabilidad" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_iniciativa">Initiative *</label>
                                                    <select name="verlab' . $cont . '_iniciativa" id="verlab' . $cont . '_iniciativa" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_eficiencia">Work efficiency *</label>
                                                    <select name="verlab' . $cont . '_eficiencia" id="verlab' . $cont . '_eficiencia" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_disciplina">Discipline *</label>
                                                    <select name="verlab' . $cont . '_disciplina" id="verlab' . $cont . '_disciplina" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_puntualidad">Punctuality and assistance *</label>
                                                    <select name="verlab' . $cont . '_puntualidad" id="verlab' . $cont . '_puntualidad" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_limpieza">Cleanliness and order *</label>
                                                    <select name="verlab' . $cont . '_limpieza" id="verlab' . $cont . '_limpieza" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_estabilidad">Stability *</label>
                                                    <select name="verlab' . $cont . '_estabilidad" id="verlab' . $cont . '_estabilidad" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_emocional">Emotional Stability *</label>
                                                    <select name="verlab' . $cont . '_emocional" id="verlab' . $cont . '_emocional" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_honesto">Honesty *</label>
                                                    <select name="verlab' . $cont . '_honesto" id="verlab' . $cont . '_honesto" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="verlab' . $cont . '_rendimiento">Performance *</label>
                                                    <select name="verlab' . $cont . '_rendimiento" id="verlab' . $cont . '_rendimiento" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="verlab' . $cont . '_actitud">Attitude with coworkers, bosses and subordinates *</label>
                                                    <select name="verlab' . $cont . '_actitud" id="verlab' . $cont . '_actitud" class="form-control performance' . $cont . ' verlab' . $cont . '_obligado">
                                                         <option value="Not provided">Not provided</option>
                                                        <option value="Excellent">Excellent</option>
                                                        <option value="Good">Good</option>
                                                        <option value="Regular">Regular</option>
                                                        <option value="Bad">Bad</option>
                                                        <option value="Very Bad">Very Bad</option>
                                                    </select>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="verlab' . $cont . '_recontratacion">In case of vacancy would you hire her/him again? *</label>
                                                    <select name="verlab' . $cont . '_recontratacion" id="verlab' . $cont . '_recontratacion" class="form-control verlab' . $cont . '_obligado">
                                                        <option value="">Select</option>
                                                        <option value="0">No</option>
                                                        <option value="1">Yes</option>
                                                    </select>
                                                    <br><br><br>
                                                </div>
                                                <div class="col-md-8">
                                                    <label>Why? *</label>
                                                    <textarea class="form-control verlab' . $cont . '_obligado" name="verlab' . $cont . '_motivo" id="verlab' . $cont . '_motivo" rows="3"></textarea>
                                                    <br><br><br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-md-offset-5">
                                                    <button type="button" class="btn btn-primary" onclick="saveVerificacionLaboral(' . $cont . ')">Guardar Verificación Laboral #' . $cont . '</button>
                                                    <br><br>
                                                </div>
                                            </div>
                                            </form>
                                            <script>
                                                $("#aplicar_todo' . $cont . '").change(function(){
                                                    var valor = $(this).val();
                                                    switch(valor){
                                                        case "-1":
                                                            $(".performance' . $cont . '").val("Not provided");
                                                            break;
                                                        case "0":
                                                            $(".performance' . $cont . '").val("Not provided");
                                                            break;
                                                        case "1":
                                                            $(".performance' . $cont . '").val("Excellent");
                                                            break;
                                                        case "2":
                                                            $(".performance' . $cont . '").val("Good");
                                                            break;
                                                        case "3":
                                                            $(".performance' . $cont . '").val("Regular");
                                                            break;
                                                        case "4":
                                                            $(".performance' . $cont . '").val("Bad");
                                                            break;
                                                        case "5":
                                                            $(".performance' . $cont . '").val("Very Bad");
                                                            break;
                                                    }
                                                });
                                                $(".fecha_reflab").datetimepicker({minView: 2,format: "mm/dd/yyyy",startView: 4,autoclose: true,todayHighlight: true,forceParse: false});
                                            </script>';
                    $cont++;

                }
            }
            echo $salida;
        }
    }
    public function insertVerificacionLaboral()
    {
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $cont   = $this->input->post('cont');
        $cadena = $this->input->post('verlab');
        parse_str($cadena, $ver);
        $id_candidato = $ver['id_candidato'];
        //$id_reflaboral = $ver['id_reflaboral'];
        $id_usuario = $this->session->userdata('id');

        //$this->candidato_model->cleanVerificacionLaboral($id_candidato, 1);
        $fentrada            = fecha_ingles_bd($ver['verlab' . $cont . '_entrada']);
        $fsalida             = fecha_ingles_bd($ver['verlab' . $cont . '_salida']);
        $verificacion_reflab = [
            'creacion'              => $date,
            'edicion'               => $date,
            'id_usuario'            => $id_usuario,
            'id_candidato'          => $id_candidato,
            'numero_referencia'     => $cont,
            'empresa'               => $ver['verlab' . $cont . '_empresa'],
            'direccion'             => $ver['verlab' . $cont . '_direccion'],
            'fecha_entrada'         => $fentrada,
            'fecha_salida'          => $fsalida,
            'telefono'              => $ver['verlab' . $cont . '_telefono'],
            'puesto1'               => $ver['verlab' . $cont . '_puesto1'],
            'puesto2'               => $ver['verlab' . $cont . '_puesto2'],
            'salario1'              => $ver['verlab' . $cont . '_salario1'],
            'salario2'              => $ver['verlab' . $cont . '_salario2'],
            'jefe_nombre'           => $ver['verlab' . $cont . '_bossnombre'],
            'jefe_correo'           => $ver['verlab' . $cont . '_bosscorreo'],
            'jefe_puesto'           => $ver['verlab' . $cont . '_bosspuesto'],
            'causa_separacion'      => $ver['verlab' . $cont . '_separacion'],
            'notas'                 => $ver['verlab' . $cont . '_notas'],
            'demanda'               => 0,
            'responsabilidad'       => $ver['verlab' . $cont . '_responsabilidad'],
            'iniciativa'            => $ver['verlab' . $cont . '_iniciativa'],
            'eficiencia'            => $ver['verlab' . $cont . '_eficiencia'],
            'disciplina'            => $ver['verlab' . $cont . '_disciplina'],
            'puntualidad'           => $ver['verlab' . $cont . '_puntualidad'],
            'limpieza'              => $ver['verlab' . $cont . '_limpieza'],
            'estabilidad'           => $ver['verlab' . $cont . '_estabilidad'],
            'emocional'             => $ver['verlab' . $cont . '_emocional'],
            'honestidad'            => $ver['verlab' . $cont . '_honesto'],
            'rendimiento'           => $ver['verlab' . $cont . '_rendimiento'],
            'actitud'               => $ver['verlab' . $cont . '_actitud'],
            'recontratacion'        => $ver['verlab' . $cont . '_recontratacion'],
            'motivo_recontratacion' => $ver['verlab' . $cont . '_motivo'],
        ];
        $this->candidato_model->saveVerificacionLaboral($verificacion_reflab);
        echo $salida = 1;
    }
    public function updateVerificacionLaboral()
    {
        date_default_timezone_set('America/Mexico_City');
        $date            = date('Y-m-d H:i:s');
        $id_verificacion = $this->input->post('id');
        $cont            = $this->input->post('cont');
        $cadena          = $this->input->post('verlab');
        parse_str($cadena, $ver);
        $id_candidato = $ver['id_candidato'];
        //$id_reflaboral = $ver['id_reflaboral'];
        $id_usuario = $this->session->userdata('id');

        //$this->candidato_model->cleanVerificacionLaboral($id_candidato, 1);
        $fentrada            = fecha_ingles_bd($ver['verlab' . $cont . '_entrada']);
        $fsalida             = fecha_ingles_bd($ver['verlab' . $cont . '_salida']);
        $verificacion_reflab = [
            'edicion'               => $date,
            'id_usuario'            => $id_usuario,
            'id_candidato'          => $id_candidato,
            'empresa'               => $ver['verlab' . $cont . '_empresa'],
            'direccion'             => $ver['verlab' . $cont . '_direccion'],
            'fecha_entrada'         => $fentrada,
            'fecha_salida'          => $fsalida,
            'telefono'              => $ver['verlab' . $cont . '_telefono'],
            'puesto1'               => $ver['verlab' . $cont . '_puesto1'],
            'puesto2'               => $ver['verlab' . $cont . '_puesto2'],
            'salario1'              => $ver['verlab' . $cont . '_salario1'],
            'salario2'              => $ver['verlab' . $cont . '_salario2'],
            'jefe_nombre'           => $ver['verlab' . $cont . '_bossnombre'],
            'jefe_correo'           => $ver['verlab' . $cont . '_bosscorreo'],
            'jefe_puesto'           => $ver['verlab' . $cont . '_bosspuesto'],
            'causa_separacion'      => $ver['verlab' . $cont . '_separacion'],
            'notas'                 => $ver['verlab' . $cont . '_notas'],
            'responsabilidad'       => $ver['verlab' . $cont . '_responsabilidad'],
            'iniciativa'            => $ver['verlab' . $cont . '_iniciativa'],
            'eficiencia'            => $ver['verlab' . $cont . '_eficiencia'],
            'disciplina'            => $ver['verlab' . $cont . '_disciplina'],
            'puntualidad'           => $ver['verlab' . $cont . '_puntualidad'],
            'limpieza'              => $ver['verlab' . $cont . '_limpieza'],
            'estabilidad'           => $ver['verlab' . $cont . '_estabilidad'],
            'emocional'             => $ver['verlab' . $cont . '_emocional'],
            'honestidad'            => $ver['verlab' . $cont . '_honesto'],
            'rendimiento'           => $ver['verlab' . $cont . '_rendimiento'],
            'actitud'               => $ver['verlab' . $cont . '_actitud'],
            'recontratacion'        => $ver['verlab' . $cont . '_recontratacion'],
            'motivo_recontratacion' => $ver['verlab' . $cont . '_motivo'],
        ];
        $this->candidato_model->actualizaVerificacionLaboral($verificacion_reflab, $id_verificacion);
        echo $salida = 1;
    }
    public function updateEstudiosHCL()
    {
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $cadena = $this->input->post('d_estudios');
        parse_str($cadena, $estudio);
        $id_ver_estudios  = $estudio['id_ver_estudios'];
        $id_candidato     = $estudio['id_candidato'];
        $id_usuario       = $this->session->userdata('id');
        $data['estudios'] = $this->candidato_model->revisionMayoresEstudios($id_candidato);
        if ($data['estudios']) {
            $candidato = [
                'edicion'              => $date,
                'id_usuario'           => $id_usuario,
                'id_grado_estudio'     => $estudio['mayor_estudios'],
                'estudios_periodo'     => $estudio['estudios_periodo'],
                'estudios_escuela'     => $estudio['estudios_escuela'],
                'estudios_ciudad'      => $estudio['estudios_ciudad'],
                'estudios_certificado' => $estudio['estudios_certificado'],
            ];
            $this->candidato_model->editarCandidato($candidato, $id_candidato);
            $verificacion = [
                'edicion'         => $date,
                'id_usuario'      => $id_usuario,
                'id_tipo_studies' => $estudio['mayor_estudios2'],
                'periodo'         => $estudio['estudios_periodo2'],
                'escuela'         => $estudio['estudios_escuela2'],
                'ciudad'          => $estudio['estudios_ciudad2'],
                'certificado'     => $estudio['estudios_certificado2'],
                'comentarios'     => $estudio['estudios_comentarios'],
            ];
            $this->candidato_model->updateMayoresEstudios($verificacion, $id_ver_estudios);
            echo $id_ver_estudios;
        } else {
            $candidato = [
                'edicion'              => $date,
                'id_usuario'           => $id_usuario,
                'id_grado_estudio'     => $estudio['mayor_estudios'],
                'estudios_periodo'     => $estudio['estudios_periodo'],
                'estudios_escuela'     => $estudio['estudios_escuela'],
                'estudios_ciudad'      => $estudio['estudios_ciudad'],
                'estudios_certificado' => $estudio['estudios_certificado'],
            ];
            $this->candidato_model->editarCandidato($candidato, $id_candidato);
            $verificacion = [
                'creacion'        => $date,
                'edicion'         => $date,
                'id_usuario'      => $id_usuario,
                'id_candidato'    => $id_candidato,
                'id_tipo_studies' => $estudio['mayor_estudios2'],
                'periodo'         => $estudio['estudios_periodo2'],
                'escuela'         => $estudio['estudios_escuela2'],
                'ciudad'          => $estudio['estudios_ciudad2'],
                'certificado'     => $estudio['estudios_certificado2'],
                'comentarios'     => $estudio['estudios_comentarios'],
            ];
            $id_ver_estudios = $this->candidato_model->saveMayoresEstudios($verificacion);
            echo $id_ver_estudios;
        }
    }

    public function viewStatusVerificaciones()
    {
        $id_candidato      = $_POST['id_candidato'];
        $salida            = '<div class="row">';
        $salida            = '<p class="text-center "><strong>Criminal Records</strong></p>';
        $data['s_penales'] = $this->candidato_model->checkEstatusPenales($id_candidato);
        if ($data['s_penales']) {
            foreach ($data['s_penales'] as $p) {
                $aux = explode('-', $p->fecha);
                $f1  = $aux[1] . '/' . $aux[2] . '/' . $aux[0];
                $salida .= '<div class="col-md-12">';
                $salida .= '<p>Date: ' . $f1 . '</p><p>Comment: ' . $p->comentarios . '</p></div>';
                $p_terminado = $p->finalizado;
            }
            $salida .= ($p_terminado == 1) ? '<p class="text-center"><b>Completed</b></p><hr>' : '<p class="text-center"><b>In process by analyst</b></p><hr>';
            $salida .= '</div>';
            $salida .= '</div>';
        } else {
            $salida .= '<p class="text-center"><b>In process by analyst</b></p><br><hr>';
            $salida .= '</div>';
        }

        $salida .= '<p class="text-center "><strong>Laboral References</strong></p>';
        $data['s_laborales'] = $this->candidato_model->checkEstatusLaborales($id_candidato);
        if ($data['s_laborales']) {
            foreach ($data['s_laborales'] as $l) {
                $aux = explode('-', $l->fecha);
                $f2  = $aux[1] . '/' . $aux[2] . '/' . $aux[0];
                $salida .= '<div class="col-md-12">';
                $salida .= '<p>Date: ' . $f2 . '</p><p>Comment: ' . $l->comentarios . '</p></div>';
                $l_terminado = $l->finalizado;
            }
            $salida .= ($l_terminado == 1) ? '<p class="text-center"><b>Completed</b></p><hr>' : '<p class="text-center"><b>In process by analyst</b></p><hr>';
            $salida .= '</div>';
        } else {
            $salida .= '<p class="text-center"><b>In process by analyst</b></p><br><hr>';
            $salida .= '</div>';
        }

        $salida .= '<p class="text-center "><strong>Studies Record</strong></p>';
        $data['s_estudios'] = $this->candidato_model->checkEstatusEstudios($id_candidato);
        if ($data['s_estudios']) {
            foreach ($data['s_estudios'] as $e) {
                $aux = explode('-', $e->fecha);
                $f3  = $aux[1] . '/' . $aux[2] . '/' . $aux[0];
                $salida .= '<div class="col-md-12">';
                $salida .= '<p>Date: ' . $f3 . '</p><p>Comment: ' . $e->comentarios . '</p></div>';
                $e_terminado = $e->finalizado;
            }
            $salida .= ($e_terminado == 1) ? '<p class="text-center"><b>Completed</b></p>' : '<p class="text-center"><b>In process by analyst</b></p>';
            $salida .= '</div>';
        } else {
            $salida .= '<p class="text-center"><b>In process by analyst</b></p><br>';
            $salida .= '</div>';
        }
        $salida .= '</div>';

        $global = $this->candidato_model->checkGlobalSearches($id_candidato);
        if (isset($global)) {
            $salida .= '<p class="text-center "><strong>Database searches</strong></p>';
            $dia     = explode(' ', $global->creacion);
            $aux     = explode('-', $dia[0]);
            $fglobal = $aux[1] . '/' . $aux[2] . '/' . $aux[0];
            $salida .= '<div class="col-md-12">';
            $salida .= '<p>Date: ' . $fglobal . '</p><p>- Law enforcement: Verified</p><p>- Regulatory: Verified</p><p>- Sanctions: Verified</p><p>- Other bodies: Verified</p><p>- Media searches: Verified</p></div>';

            $salida .= '<p class="text-center"><b>Completed</b></p>';
            $salida .= '</div>';
        } else {
            $salida .= '<p class="text-center "><strong>Database searches</strong></p>';
            $fglobal = "In progress";
            $salida .= '<div class="col-md-12">';
            $salida .= '<p>Date: ' . $fglobal . '</p><p>- Law enforcement: In progress</p><p>- Regulatory: In progress</p><p>- Sanctions: In progress</p><p>- Other bodies: In progress</p><p>- Media searches: In progress</p></div>';
            $salida .= '<p class="text-center"><b>In process by analyst</b></p>';
            $salida .= '</div>';
        }
        $salida .= '</div>';

        echo $salida;
    }
    public function getHistorialDomicilios()
    {
        $id_candidato = $_POST['id_candidato'];
        $salida       = "";
        $cont         = 1;
        $data['doms'] = $this->candidato_model->getHistorialDomicilios($id_candidato);
        if ($data['doms']) {
            foreach ($data['doms'] as $d) {
                $actual = ($cont == 1) ? "Current address" : "Previous address #" . $cont . "";
                $salida .= '
                <p class="tituloSubseccion">' . $actual . '</p>
                <div class="row">
                    <div class="col-md-4">
                        <label for="h' . $cont . '_periodo">Period *</label>
                        <input type="text" class="form-control obligado" name="h' . $cont . '_periodo" id="h' . $cont . '_periodo" value="' . $d->periodo . '" disabled><br>
                    </div>
                    <div class="col-md-8">
                        <label for="h' . $cont . '_causa">Cause of departure *</label>
                        <input type="text" class="form-control obligado" name="h' . $cont . '_causa" id="h' . $cont . '_causa" value="' . $d->causa . '" disabled><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="h' . $cont . '_calle">Address *</label>
                        <input type="text" class="form-control obligado" name="h' . $cont . '_calle" id="h' . $cont . '_calle" value="' . $d->calle . '" disabled><br>
                    </div>
                    <div class="col-md-2">
                        <label for="h' . $cont . '_exterior">Ext. Num. *</label>
                        <input type="text" class="form-control obligado" name="h' . $cont . '_exterior" id="h' . $cont . '_exterior"  maxlength="6" value="' . $d->exterior . '" disabled><br>
                    </div>
                    <div class="col-md-2">
                        <label for="h' . $cont . '_interior">Int. Num. </label>
                        <input type="text" class="form-control" name="h' . $cont . '_interior" id="h' . $cont . '_interior"  maxlength="5" value="' . $d->interior . '" disabled><br>
                    </div>
                    <div class="col-md-4">
                        <label for="h' . $cont . '_colonia">Neighborhood *</label>
                        <input type="text" class="form-control obligado" name="h' . $cont . '_colonia" id="h' . $cont . '_colonia" value="' . $d->colonia . '" disabled><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="h' . $cont . '_estado">State *</label>
                        <input type="text" class="form-control obligado" name="h' . $cont . '_estado" id="h' . $cont . '_estado" value="' . $d->estado . '" disabled><br>
                    </div>
                    <div class="col-md-4">
                        <label for="h' . $cont . '_municipio">City *</label>
                        <input type="text" class="form-control obligado" name="h' . $cont . '_municipio" id="h' . $cont . '_municipio" value="' . $d->municipio . '" disabled><br>
                    </div>
                    <div class="col-md-2">
                        <label for="h' . $cont . '_cp">Zip Code *</label>
                        <input type="text" class="form-control solo_numeros obligado" name="h' . $cont . '_cp" id="h' . $cont . '_cp"  maxlength="5" value="' . $d->cp . '" disabled><br>
                    </div>
                </div>';
                $cont++;
            }
            echo $salida;
        } else {
            echo $salida;
        }
    }
    public function verificarDomicilios()
    {
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $cadena = $this->input->post('d_doms');
        parse_str($cadena, $dom);
        $id_candidato = $dom['id_candidato'];
        $id_usuario   = $this->session->userdata('id');
        $this->candidato_model->cleanVerificacionDomicilios($id_candidato);
        $domicilio = [
            'creacion'     => $date,
            'edicion'      => $date,
            'id_usuario'   => $id_usuario,
            'id_candidato' => $id_candidato,
            'comentario'   => $dom['domicilios_comentarios'],
        ];
        $this->candidato_model->saveVerificacionDomicilio($domicilio);
        echo $salida = 1;
    }

    public function checkVerificacionDomicilios()
    {
        $id_candidato = $_POST['id_candidato'];
        $salida       = "";
        $dom          = $this->candidato_model->checkVerificacionDomicilios($id_candidato);
        if (isset($dom)) {
            echo $dom->comentario;
        } else {
            echo $salida;
        }

    }
    public function getProyectosSubcliente()
    {
        $id_cliente        = $_POST['id_cliente'];
        $id_subcliente     = $_POST['id_subcliente'];
        $data['proyectos'] = $this->candidato_model->getProyectosSubcliente($id_cliente, $id_subcliente);
        $salida            = "<option value=''>Selecciona</option>";
        //$salida .= "<option value='0'>N/A</option>";
        if ($data['proyectos']) {
            foreach ($data['proyectos'] as $row) {
                $salida .= "<option value='" . $row->id . "'>" . $row->nombre . "</option>";
            }
            echo $salida;
        } else {
            echo $salida;
        }
    }
    public function xx()
    {
        $basic  = new \Nexmo\Client\Credentials\Basic('5aa133d2', 'mvVfoFEKFZsHDH8c');
        $client = new \Nexmo\Client($basic);

        $message = $client->message()->send([
            'to'   => '523331493010',
            'from' => 'Nexmo',
            'text' => 'Hello from NexmoRODI',
        ]);
    }

    /************************************************ Candidatos *********************************************************/

    public function actualizarDatosGeneralesIngles()
    {
        date_default_timezone_set('America/Mexico_City');
        $date   = date('Y-m-d H:i:s');
        $cadena = $this->input->post('d_generales');
        parse_str($cadena, $personal);
        $id_candidato      = $personal['id_candidato'];
        $id_usuario        = $this->session->userdata('id');
        $lugar_nacimiento  = (isset($personal['lugar_ingles'])) ? $personal['lugar_ingles'] : '';
        $tel_oficina       = (isset($personal['tel_oficina_ingles'])) ? $personal['tel_oficina_ingles'] : '';
        $nacionalidad      = (isset($personal['nacionalidad_ingles'])) ? $personal['nacionalidad_ingles'] : '';
        $correo            = (isset($personal['personales_correo_ingles'])) ? $personal['personales_correo_ingles'] : '';
        $tiempo_dom_actual = (isset($personal['tiempo_dom_actual'])) ? $personal['tiempo_dom_actual'] : '';
        $tiempo_traslado   = (isset($personal['tiempo_traslado'])) ? $personal['tiempo_traslado'] : '';
        $medio_transporte  = (isset($personal['medio_transporte'])) ? $personal['medio_transporte'] : '';
        $grado             = (isset($personal['grado'])) ? $personal['grado'] : 0;
        $calles            = (isset($personal['calles_ingles'])) ? $personal['calles_ingles'] : '';

        $fecha     = fecha_espanol_bd($personal['fecha_nacimiento_ingles']);
        $edad      = calculaEdad($fecha);
        $candidato = [
            'edicion'           => $date,
            'id_usuario'        => $id_usuario,
            'nombre'            => $personal['nombre_ingles'],
            'paterno'           => $personal['paterno_ingles'],
            'materno'           => $personal['materno_ingles'],
            'fecha_nacimiento'  => $fecha,
            'edad'              => $edad,
            'puesto'            => $personal['puesto_ingles'],
            'lugar_nacimiento'  => $lugar_nacimiento,
            'nacionalidad'      => $nacionalidad,
            'genero'            => $personal['genero_ingles'],
            'id_grado_estudio'  => $grado,
            'calle'             => $personal['calle_ingles'],
            'exterior'          => $personal['exterior_ingles'],
            'interior'          => $personal['interior_ingles'],
            'entre_calles'      => $calles,
            'colonia'           => $personal['colonia_ingles'],
            'id_estado'         => $personal['estado_ingles'],
            'id_municipio'      => $personal['municipio_ingles'],
            'cp'                => $personal['cp_ingles'],
            'estado_civil'      => $personal['civil_ingles'],
            'celular'           => $personal['celular_general_ingles'],
            'telefono_casa'     => $personal['tel_casa_ingles'],
            'telefono_otro'     => $tel_oficina,
            'correo'            => $correo,
            'tiempo_dom_actual' => $tiempo_dom_actual,
            'tiempo_traslado'   => $tiempo_traslado,
            'tipo_transporte'   => $medio_transporte,
        ];
        $this->candidato_model->editarCandidato($candidato, $id_candidato);

        /*$res = $this->candidato_model->checkTipoClienteCandidato($id_candidato);
        if($res->id_cliente != 1){
        $visita = array(
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'calle' => $personal['calle_ingles'],
        'exterior' => $personal['exterior_ingles'],
        'interior' => $personal['interior_ingles'],
        'colonia' => $personal['colonia_ingles'],
        'id_estado' => $personal['estado_ingles'],
        'id_municipio' => $personal['municipio_ingles'],
        'cp' => $personal['cp_ingles'],
        'celular' => $personal['celular_general_ingles'],
        'telefono_casa' => $personal['tel_casa_ingles']

        );
        $this->candidato_model->updateVisitaOperador($visita, $id_candidato);
        }*/
        echo $salida = 1;
    }

    public function candidatoResponseForm()
    {
        date_default_timezone_set('America/Mexico_City');
        $date         = date('Y-m-d H:i:s');
        $id_candidato = $this->session->userdata('id');

        $cadena = $this->input->post('datos');
        parse_str($cadena, $personal);
        $cadena3 = $this->input->post('complementos');
        parse_str($cadena3, $dato);

        $fecha     = fecha_ingles_bd($personal['fecha_nacimiento']);
        $edad      = calculaEdad($fecha);
        $candidato = [
            'fecha_contestado'     => $date,
            //'token' => 'completo',
            'edicion'              => $date,
            'fecha_nacimiento'     => $fecha,
            'edad'                 => $edad,
            'puesto'               => $personal['puesto'],
            'nacionalidad'         => $personal['nacionalidad'],
            'genero'               => $personal['genero'],
            'id_grado_estudio'     => $dato['estudios'],
            'estudios_periodo'     => $dato['estudios_periodo'],
            'estudios_escuela'     => $dato['estudios_escuela'],
            'estudios_ciudad'      => $dato['estudios_ciudad'],
            'estudios_certificado' => $dato['estudios_certificado'],
            'calle'                => $personal['calle'],
            'exterior'             => $personal['exterior'],
            'interior'             => $personal['interior'],
            'colonia'              => $personal['colonia'],
            'id_estado'            => $personal['estado'],
            'id_municipio'         => $personal['municipio'],
            'cp'                   => $personal['cp'],
            'estado_civil'         => $personal['civil'],
            'celular'              => $personal['telefono'],
            'telefono_casa'        => $personal['tel_casa'],
            'telefono_otro'        => $personal['tel_otro'],
            'comentario'           => $dato['obs'],
            'trabajo_inactivo'     => $dato['trabajo_inactivo'],
            'status'               => 1,
        ];
        $this->candidato_model->editarCandidato($candidato, $id_candidato);

        if ($_POST['trabajos'] != "") {
            $data_trabajo = "";
            $trab         = explode("@@", $_POST['trabajos']);
            for ($i = 0; $i < count($trab); $i++) {
                $aux = explode("__", $trab[$i]);
                if ($trab[$i] != "") {
                    $data_trabajo = [
                        'creacion'          => $date,
                        'edicion'           => $date,
                        'id_candidato'      => $id_candidato,
                        'empresa'           => ucwords(strtolower($aux[0])),
                        'direccion'         => ucwords(strtolower($aux[1])),
                        'fecha_entrada_txt' => $aux[2],
                        'fecha_salida_txt'  => $aux[3],
                        'telefono'          => $aux[4],
                        'puesto1'           => ucwords(strtolower($aux[5])),
                        'puesto2'           => ucwords(strtolower($aux[6])),
                        'salario1_txt'      => $aux[7],
                        'salario2_txt'      => $aux[8],
                        'jefe_nombre'       => ucwords(strtolower($aux[9])),
                        'jefe_correo'       => strtolower($aux[10]),
                        'jefe_puesto'       => ucwords(strtolower($aux[11])),
                        'causa_separacion'  => $aux[12],
                    ];
                    $this->candidato_model->saveRefLab($data_trabajo);
                }
            }
        }
        if (isset($_POST['doms'])) {
            $data_dom = "";
            $dom      = explode("@@", $_POST['doms']);
            for ($i = 0; $i < count($dom); $i++) {
                $aux = explode("__", $dom[$i]);
                if ($dom[$i] != "") {
                    if ($i == 0) {
                        $data_dom = [
                            'creacion'     => $date,
                            'edicion'      => $date,
                            'id_candidato' => $id_candidato,
                            'periodo'      => $aux[0],
                            'causa'        => $aux[1],
                            'calle'        => $personal['calle'],
                            'exterior'     => $personal['exterior'],
                            'interior'     => $personal['interior'],
                            'colonia'      => $personal['colonia'],
                            'id_estado'    => $personal['estado'],
                            'id_municipio' => $personal['municipio'],
                            'cp'           => $personal['cp'],
                        ];
                        $this->candidato_model->saveDomicilio($data_dom);
                    } else {
                        $data_dom = [
                            'creacion'     => $date,
                            'edicion'      => $date,
                            'id_candidato' => $id_candidato,
                            'periodo'      => $aux[0],
                            'causa'        => $aux[1],
                            'calle'        => $aux[2],
                            'exterior'     => $aux[3],
                            'interior'     => $aux[4],
                            'colonia'      => $aux[5],
                            'id_estado'    => $aux[6],
                            'id_municipio' => $aux[7],
                            'cp'           => $aux[8],
                        ];
                        $this->candidato_model->saveDomicilio($data_dom);
                    }
                }
            }
        }
        echo $hecho = 1;
    }

    public function getRefPersonales()
    {
        $id_candidato = $_POST['id_candidato'];
        $salida       = "";
        $data['refs'] = $this->candidato_model->getPersonales($id_candidato);
        if ($data['refs']) {
            foreach ($data['refs'] as $ref) {
                $salida .= $ref->nombre . "@@";
                $salida .= $ref->telefono . "@@";
                $salida .= $ref->tiempo_conocerlo . "@@";
                $salida .= $ref->donde_conocerlo . "@@";
                $salida .= $ref->sabe_trabajo . "@@";
                $salida .= $ref->sabe_vive . "@@";
                $salida .= $ref->recomienda . "@@";
                $salida .= $ref->comentario . "@@";
                $salida .= $ref->id . "###";
            }
            echo $salida;
        } else {
            echo $salida = 0;
        }
    }

    public function getHabitacion()
    {
        $id_candidato  = $_POST['id_candidato'];
        $salida        = "";
        $data['datos'] = $this->candidato_model->getHabitacion($id_candidato);
        if ($data['datos']) {
            foreach ($data['datos'] as $hab) {
                //$salida .= $hab->id."@@";
                $salida .= $hab->tiempo_residencia . "@@";
                $salida .= $hab->zona . "@@";
                $salida .= $hab->vivienda . "@@";
                $salida .= $hab->recamaras . "@@";
                $salida .= $hab->banios . "@@";
                $salida .= $hab->distribucion . "@@";
                $salida .= $hab->calidad_mobiliario . "@@";
                $salida .= $hab->mobiliario . "@@";
                $salida .= $hab->tamanio_vivienda . "@@";
                $salida .= $hab->condiciones;
            }
            echo $salida;
        } else {
            echo $salida = 0;
        }
    }

    public function verificarVisitayDoping()
    {
        $id_candidato = $_POST['id_candidato'];
        $salida       = "";
        $doping       = $this->candidato_model->verificarAntidoping($id_candidato);
        if ($doping->tipo_antidoping != 0) {
            if ($doping->status_doping == 0) {
                $salida .= "<p>- No se ha registrado el resultado del examen antidoping del candidato</p><br>";
            }
            $visita = $this->candidato_model->verificarVisita($id_candidato);
            if ($visita != "" && $visita != null) {
                $visitado = $this->candidato_model->getInfoCandidatoEspecifico($id_candidato);
                if ($visitado->visitador == 0) {
                    $salida .= "<p>- No se ha registrado la visita al candidato</p>";
                    echo $salida;
                } else {
                    echo $salida;
                }
            } else {
                echo $salida;
            }
        } else {
            $visita = $this->candidato_model->verificarVisita($id_candidato);
            if ($visita != "" && $visita != null) {
                $visitado = $this->candidato_model->getInfoCandidatoEspecifico($id_candidato);
                if ($visitado->visitador == 0) {
                    $salida .= "<p>- No se ha registrado la visita al candidato</p>";
                    echo $salida;
                } else {
                    echo $salida;
                }
            } else {
                echo $salida;
            }
        }
    }
    public function visitaConfirmada()
    {
        date_default_timezone_set('America/Mexico_City');
        $id_candidato = $_POST['id_candidato'];
        $date         = date('Y-m-d H:i:s');
        $id_usuario   = $this->session->userdata('id');
        $visita       = [
            'edicion'    => $date,
            'id_usuario' => $id_usuario,
            'visitador'  => 1,
        ];
        $this->candidato_model->editarCandidato($visita, $id_candidato);
    }
    public function finalizarProcesoCandidato()
    {
        date_default_timezone_set('America/Mexico_City');
        $id_candidato = $_POST['id_candidato'];
        $estatus      = $_POST['estatus'];
        $date         = date('Y-m-d H:i:s');
        $id_usuario   = $this->session->userdata('id');
        $comentario   = ($_POST['comentario'] !== null) ? $_POST['comentario'] : '';

        $num = $this->candidato_model->checkBGC($id_candidato);
        if ($num > 0) {
            $bgc = [
                'id_usuario'       => $id_usuario,
                'comentario_final' => $comentario,
            ];
            $this->candidato_model->updateBGC($bgc, $id_candidato);
            $this->candidato_model->statusBGCCandidato($estatus, $id_candidato);
        } else {
            $bgc = [
                'creacion'         => $date,
                'edicion'          => $date,
                'id_usuario'       => $id_usuario,
                'id_candidato'     => $id_candidato,
                'comentario_final' => $comentario,
            ];
            $this->candidato_model->saveBGC($bgc);
            $this->candidato_model->statusBGCCandidato($estatus, $id_candidato);
        }

    }
    public function accionCandidato()
    {
        $id_usuario = $this->session->userdata('id');
        date_default_timezone_set('America/Mexico_City');
        $date         = date('Y-m-d H:i:s');
        $motivo       = $_POST['motivo'];
        $id_candidato = $_POST['id'];
        $id_cliente   = $_POST['id_cliente'];
        $usuario      = $_POST['usuario'];
        switch ($usuario) {
            case 1:
                $tipo_usuario = "id_usuario";
                break;
            case 2:
                $tipo_usuario = "id_usuario_cliente";
                break;
            case 3:
                $tipo_usuario = "id_usuario_subcliente";
                break;
        }
        $eliminacion = [
            'creacion'     => $date,
            $tipo_usuario  => $id_usuario,
            'id_cliente'   => $id_cliente,
            'id_candidato' => $id_candidato,
            'motivo'       => $motivo,
        ];
        $this->candidato_model->accionCandidato($eliminacion);
        $cand = [
            'edicion'   => $date,
            'eliminado' => 1,
        ];
        $this->candidato_model->editarCandidato($cand, $id_candidato);
        echo $res = 1;
    }
    public function getCandidatosEliminados()
    {
        $id_cliente         = $_POST['id_cliente'];
        $salida             = "";
        $data['eliminados'] = $this->candidato_model->getCandidatosEliminados($id_cliente);
        if ($data['eliminados']) {
            $salida .= '<table class="table table-striped">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th scope="col">Candidato</th>';
            $salida .= '<th scope="col">Fecha</th>';
            $salida .= '<th scope="col" width="40%">Motivo</th>';
            $salida .= '<th scope="col">Usuario</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';
            foreach ($data['eliminados'] as $e) {
                $fecha = fecha_sinhora_espanol_bd($e->fecha_eliminado);
                $salida .= "<tr><th>" . $e->candidato . "</th><th>" . $fecha . "</th><th>" . $e->motivo . "</th><th>" . $e->usuario . "</th></tr>";
            }
            $salida .= '</tbody>';
            $salida .= '</table>';
            echo $salida;
        } else {
            echo $salida .= '<p style="text-align:center">No hay registros eliminados</p>';
        }
    }
    public function getCandidatosEliminadosTATA()
    {
        $id_cliente         = $_POST['id_cliente'];
        $salida             = "";
        $data['eliminados'] = $this->candidato_model->getCandidatosEliminadosTATA($id_cliente);
        if ($data['eliminados']) {
            $salida .= '<table class="table table-striped">';
            $salida .= '<thead>';
            $salida .= '<tr>';
            $salida .= '<th scope="col">Candidato</th>';
            $salida .= '<th scope="col">Fecha</th>';
            $salida .= '<th scope="col" width="40%">Motivo</th>';
            $salida .= '<th scope="col">Usuario</th>';
            $salida .= '</tr>';
            $salida .= '</thead>';
            $salida .= '<tbody>';
            foreach ($data['eliminados'] as $e) {
                $fecha = fecha_sinhora_espanol_bd($e->fecha_eliminado);
                $salida .= "<tr><th>" . $e->candidato . "</th><th>" . $fecha . "</th><th>" . $e->motivo . "</th><th>" . $e->usuario . "</th></tr>";
            }
            $salida .= '</tbody>';
            $salida .= '</table>';
            echo $salida;
        } else {
            echo $salida .= '<p style="text-align:center">No hay registros eliminados</p>';
        }
    }

    /************************************************ Rules Validate Form ************************************************/

    //Regla para nombres con espacios
    public function alpha_space_only($str)
    {
        if (! preg_match("/^[a-zA-Z ]+$/", $str)) {
            $this->form_validation->set_message('alpha_space_only', 'El campo {field} debe estar compuesto solo por letras y espacios y no debe estar vacío');
            return false;
        } else {
            return true;
        }
    }
    public function alpha_space_only_english($str)
    {
        if (! preg_match("/^[a-zA-Z ]+$/", $str)) {
            $this->form_validation->set_message('alpha_space_only_english', '{field} does not must be alfanumeric');
            return false;
        } else {
            return true;
        }
    }
    public function required_file()
    {
        $this->form_validation->set_message('required_file', 'Carga el CV o solicitud de empleo del candidato');
        if (empty($_FILES['cv']['name'])) {
            return false;
        } else {
            return true;
        }
    }
    public function string_values($str)
    {
        if (! preg_match("/^\d+$|^[\d,\d]+$/", $str)) {
            //$this->form_validation->set_message('string_values', 'El campo {field} no es válido');
            return false;
        } else {
            return true;
        }
    }
    public function date_format_es($str)
    {
        if (! preg_match("/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/i", $str)) {
            $this->form_validation->set_message('date_format_es', 'El campo {field} no es una fecha válida');
            return false;
        } else {
            return true;
        }
    }

    public function fetch_candidatos()
    {
        $fetch_data = $this->candidato_model->make_datatable();
        $data       = [];
        foreach ($fetch_data as $row) {
            $subcliente = ($row->subcliente === null) ? '' : '<span class="badge badge-pill badge-primary">Subcliente: ' . $row->subcliente . '</span><br>';
            $analista   = ($row->usuario === null) ? 'Analista: Sin definir' : 'Analista: ' . $row->usuario;
            $reclutador = ($row->reclutadorAspirante !== null) ? '<br><span class="badge badge-pill badge-info">Reclutador(a): ' . $row->reclutadorAspirante . '</span>' : '';

            $sub_array   = [];
            $sub_array[] = '<span class="badge badge-pill badge-dark">#' . $row->id . '</span><br><a data-toggle="tooltip" class="sin_vinculo" style="color:black;"><b>' . $row->candidato . '</b></a><br>' . $subcliente . '<span class="badge badge-pill badge-light">' . $analista . '</span>' . $reclutador;
            $sub_array[] = 'hoila mundo';
            $sub_array[] = 'hoila mundo';
            $sub_array[] = 'hoila mundo';
            $sub_array[] = 'hoila mundo';
            $sub_array[] = 'hoila mundo';
            $sub_array[] = 'hoila mundo';
            $sub_array[] = 'hoila mundo';
            $data[]      = $sub_array;
        }
        $output = [
            "draw"            => intval($_POST['draw']),
            "recordsTotal"    => $this->candidato_model->get_all_data(),
            "recordsFiltered" => $this->candidato_model->get_filtered_data(),
            "data"            => $data,
        ];

        echo json_encode($output);
    }
}