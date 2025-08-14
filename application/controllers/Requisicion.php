<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Requisicion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        date_default_timezone_set('America/Mexico_City');
        $data['hoy'] = date("d/m/Y");
        $data['id_cliente'] = $_GET['id_cliente'];

        $data['datos'] = $this->cat_cliente_model->getC($data['id_cliente']);

        $this->load->view('requisicion/requisicionCompleta', $data);
    }
    public function vista_ingles()
    {
        $id_cliente = $this->input->post('id_cliente');
        date_default_timezone_set('America/Mexico_City');
        $data['hoy'] = date("d/m/Y");

        $data['id_cliente'] = $id_cliente;
        //echo "<pre>";
        //print_r($id_cliente);
        //echo "</pre>";
        //die();

        $data['datos'] = $this->cat_cliente_model->getC($id_cliente);

        $this->load->view('requisicion/en/requisicionCompletaIngles', $data);
    }
    public function registrar(){

        $id_cliente = $this->input->post('metodo_pago');
        $id_portal = $this->session->userdata('idPortal');
        $id_usuario = $this->session->userdata('id');

        if ($this->input->post('version') == 'espanol') {
            // trim se coloca antes de required. Esto asegura que cualquier espacio en blanco adicional al principio o al final del valor ingresado en el campo, será eliminado antes de que la validación required se lleve a cabo.

            $this->form_validation->set_rules('num_vacantes', 'Número de vacantes', 'required|numeric|max_length[2]');
            $this->form_validation->set_rules('escolaridad', 'Formación académica requerida', 'trim|required');
            $this->form_validation->set_rules('estatus_escolaridad', 'Estatus académico', 'trim|required');
            $this->form_validation->set_rules('otro_estatus', 'Otro estatus académico', 'trim');
            $this->form_validation->set_rules('carrera', 'Carrera requerida para el puesto', 'trim|required');
            $this->form_validation->set_rules('otros_estudios', 'Otro estatus académico', 'trim');
            $this->form_validation->set_rules('idioma1', 'Idioma nativo', 'trim');
            $this->form_validation->set_rules('por_idioma1', 'Porcentaje del Idioma nativo', 'numeric|max_length[3]');
            $this->form_validation->set_rules('idioma2', 'Segundo idioma', 'trim');
            $this->form_validation->set_rules('por_idioma2', 'Porcentaje del Segundo Idioma', 'numeric|max_length[3]');
            $this->form_validation->set_rules('idioma3', 'Tercer idioma', 'trim');
            $this->form_validation->set_rules('por_idioma3', 'Porcentaje del Tercer Idioma', 'numeric|max_length[3]');
            $this->form_validation->set_rules('habilidad1', 'Habilidad informática requerida', 'trim');
            $this->form_validation->set_rules('por_habilidad1', 'Porcentaje de la Habilidad informática requerida', 'numeric|max_length[3]');
            $this->form_validation->set_rules('habilidad2', 'Segunda habilidad informática requerida', 'trim');
            $this->form_validation->set_rules('por_habilidad2', 'Porcentaje de la Segunda habilidad informática', 'numeric|max_length[3]');
            $this->form_validation->set_rules('habilidad3', 'Tercera habilidad informática requerida', 'trim');
            $this->form_validation->set_rules('por_habilidad3', 'Porcentaje de la Tercera habilidad informática', 'numeric|max_length[3]');
            $this->form_validation->set_rules('genero', 'Sexo', 'trim|required');
            $this->form_validation->set_rules('civil', 'Estado civil', 'trim|required');
            $this->form_validation->set_rules('edad_minima', 'Edad mínima', 'required|numeric|max_length[2]');
            $this->form_validation->set_rules('edad_maxima', 'Edad máxima', 'required|numeric|max_length[2]');
            $this->form_validation->set_rules('licencia', 'Licencia de conducir', 'trim|required');
            $this->form_validation->set_rules('tipo_licencia', 'Tipo de licencia de conducir', 'trim');
            $this->form_validation->set_rules('discapacidad', 'Discapacidad aceptable', 'trim|required');
            $this->form_validation->set_rules('causa', 'Causa que origina la vacante', 'trim|required');
            $this->form_validation->set_rules('residencia', 'Lugar de residencia', 'trim|required');
            $this->form_validation->set_rules('jornada', 'Jornada laboral', 'trim|required');
            $this->form_validation->set_rules('tiempo_inicio', 'Inicio de la Jornada laboral', 'trim|required');
            $this->form_validation->set_rules('tiempo_final', 'Fin de la Jornada laboral', 'trim|required');
            $this->form_validation->set_rules('descanso', 'Día(s) de descanso', 'trim|required');
            $this->form_validation->set_rules('viajar', 'Disponibilidad para viajar', 'trim|required');
            // $this->form_validation->set_rules('horario', 'Disponibilidad de horario','trim|required');
            $this->form_validation->set_rules('zona', 'Zona de trabajo', 'trim|required');
            $this->form_validation->set_rules('tipo_sueldo', 'Sueldo', 'trim|required');
            $this->form_validation->set_rules('sueldo_minimo', 'Sueldo mínimo', 'numeric|max_length[8]');
            $this->form_validation->set_rules('sueldo_maximo', 'Sueldo máximo', 'required|numeric|max_length[8]');

            $this->form_validation->set_rules('sueldo_adicional', 'Adicional al sueldo', 'trim|required');
            $this->form_validation->set_rules('monto_adicional', 'Monto del sueldo adicional', 'trim');
            $this->form_validation->set_rules('tipo_pago', 'Tipo de pago', 'trim|required');
            $this->form_validation->set_rules('ley', '¿Tendrá prestaciones de ley?', 'required');
            $this->form_validation->set_rules('superiores', '¿Tendrá prestaciones superiores? ¿Cuáles?', 'trim');
            $this->form_validation->set_rules('otras_prestaciones', '¿Tendrá otro tipo de prestaciones? ¿Cuáles?', 'trim');
            $this->form_validation->set_rules('experiencia', 'Se requiere experiencia en', 'trim|required');
            $this->form_validation->set_rules('actividades', 'Actividades a realizar', 'trim|required');
            $this->form_validation->set_rules('competencias', 'Competencias requeridas para el puesto', 'trim|required');
            $this->form_validation->set_rules('observaciones', 'Observaciones adicionales', 'trim');

            $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
            $this->form_validation->set_message('max_length', 'El campo {field} debe tener máximo {param} carácteres');
            $this->form_validation->set_message('valid_email', 'El campo {field} debe ser un correo válido');
            $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');
        }
        //INGLES
        if ($this->input->post('version') == 'ingles') {
            $this->form_validation->set_rules('nombre', 'Name or Company name', 'trim|required');
            $this->form_validation->set_rules('domicilio', 'Tax address', 'trim|required');
            $this->form_validation->set_rules('cp', 'Código postal', 'trim|required|max_length[5]');
            $this->form_validation->set_rules('regimen', 'Régimen Fiscal', 'trim|required');
            $this->form_validation->set_rules('telefono', 'Telephone', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('correo', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('contacto', 'Contact', 'trim|required');
            $this->form_validation->set_rules('rfc', 'Federal Taxpayer Registry', 'trim|required|max_length[13]');
            $this->form_validation->set_rules('forma_pago', 'Form of payment', 'trim|required');
            $this->form_validation->set_rules('metodo_pago', 'Payment method', 'trim|required');
            $this->form_validation->set_rules('uso_cfdi', 'Digital tax receipt', 'trim|required');
            $this->form_validation->set_rules('puesto', 'Vacancy name', 'trim|required');
            $this->form_validation->set_rules('num_vacantes', 'Number of vacancies', 'required|numeric|max_length[2]');
            $this->form_validation->set_rules('escolaridad', 'Required education formation', 'trim|required');
            $this->form_validation->set_rules('estatus_escolaridad', 'Academic status', 'trim|required');
            $this->form_validation->set_rules('otro_estatus', 'Other academic status', 'trim');
            $this->form_validation->set_rules('carrera', 'Career required for the position', 'trim|required');
            $this->form_validation->set_rules('otros_estudios', 'Other studies', 'trim');
            $this->form_validation->set_rules('idioma1', 'Native language', 'trim');
            $this->form_validation->set_rules('por_idioma1', 'Percentage of native language', 'numeric|max_length[3]');
            $this->form_validation->set_rules('idioma2', 'Second language', 'trim');
            $this->form_validation->set_rules('por_idioma2', 'Percentage of second language', 'numeric|max_length[3]');
            $this->form_validation->set_rules('idioma3', 'Third language', 'trim');
            $this->form_validation->set_rules('por_idioma3', 'Percentage of third language', 'numeric|max_length[3]');
            $this->form_validation->set_rules('habilidad1', 'Required technology skill', 'trim');
            $this->form_validation->set_rules('por_habilidad1', 'Percentage of the skill', 'numeric|max_length[3]');
            $this->form_validation->set_rules('habilidad2', 'Other required technology skill', 'trim');
            $this->form_validation->set_rules('por_habilidad2', 'Percentage of the skill', 'numeric|max_length[3]');
            $this->form_validation->set_rules('habilidad3', 'Other required technology skill', 'trim');
            $this->form_validation->set_rules('por_habilidad3', 'Percentage of the skill', 'numeric|max_length[3]');
            $this->form_validation->set_rules('genero', 'Gender', 'trim|required');
            $this->form_validation->set_rules('civil', 'Marital status', 'trim|required');
            $this->form_validation->set_rules('edad_minima', 'Minimum age', 'required|numeric|max_length[2]');
            $this->form_validation->set_rules('edad_maxima', 'Maximum age', 'required|numeric|max_length[2]');
            $this->form_validation->set_rules('licencia', 'Driver licence', 'trim|required');
            $this->form_validation->set_rules('tipo_licencia', 'Type of driver licence', 'trim');
            $this->form_validation->set_rules('discapacidad', 'Acceptable disability', 'trim|required');
            $this->form_validation->set_rules('causa', 'Cause of vacancy', 'trim|required');
            $this->form_validation->set_rules('residencia', 'Place of residence', 'trim|required');
            $this->form_validation->set_rules('jornada', 'Workday', 'trim|required');
            $this->form_validation->set_rules('tiempo_inicio', 'Begin of the workday', 'trim|required');
            $this->form_validation->set_rules('tiempo_final', 'Finish of the workday', 'trim|required');
            $this->form_validation->set_rules('descanso', 'Rest days', 'trim|required');
            $this->form_validation->set_rules('viajar', 'Availability to travel', 'trim|required');
            // $this->form_validation->set_rules('horario', 'Schedule availability','trim|required');
            $this->form_validation->set_rules('zona', 'Work address', 'trim|required');
            $this->form_validation->set_rules('tipo_sueldo', 'Salary', 'trim|required');
            $this->form_validation->set_rules('sueldo_minimo', 'Minimum salary', 'numeric|max_length[8]');
            $this->form_validation->set_rules('sueldo_maximo', 'Maximum salary', 'required|numeric|max_length[8]');
            $this->form_validation->set_rules('sueldo_adicional', 'Bonus', 'trim|required');
            $this->form_validation->set_rules('monto_adicional', 'Additional amount', 'trim');
            $this->form_validation->set_rules('tipo_pago', 'Payment type', 'trim|required');
            $this->form_validation->set_rules('ley', 'Will the person have legal benefits?', 'required');
            $this->form_validation->set_rules('superiores', 'Will the person have superior benefits?', 'trim');
            $this->form_validation->set_rules('otras_prestaciones', 'Other benefits', 'trim');
            $this->form_validation->set_rules('experiencia', 'Experience required in', 'required|trim');
            $this->form_validation->set_rules('actividades', 'Activities to be performed', 'trim|required');
            $this->form_validation->set_rules('competencias', 'Competencies required for the position', 'trim|required');
            $this->form_validation->set_rules('observaciones', 'Additional observations', 'trim');
        }

        $msj = array();
        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');
            $idiomas = "";
            $habilidades = "";
            $sueldo_adicional = "";
            $licencia = "";
            $notificacion = 0;
            if ($this->input->post('idioma1') != "") {
                $idiomas .= ($this->input->post('por_idioma1') != '') ? $this->input->post('idioma1') . ' con ' . $this->input->post('por_idioma1') . '% ' : $this->input->post('idioma1');
            }
            if ($this->input->post('idioma2') != "") {
                $idiomas .= ($this->input->post('por_idioma2') != '') ? $this->input->post('idioma2') . ' con ' . $this->input->post('por_idioma2') . '% ' : $this->input->post('idioma2');
            }
            if ($this->input->post('idioma3') != "") {
                $idiomas .= ($this->input->post('por_idioma3') != '') ? $this->input->post('idioma3') . ' con ' . $this->input->post('por_idioma3') . '% ' : $this->input->post('idioma3');
            }
            if ($this->input->post('habilidad1') != "") {
                $habilidades .= ($this->input->post('por_habilidad1') != '') ? $this->input->post('habilidad1') . ' con ' . $this->input->post('por_habilidad1') . '% ' : $this->input->post('habilidad1');
            }
            if ($this->input->post('habilidad2') != "") {
                $habilidades .= ($this->input->post('por_habilidad2') != '') ? $this->input->post('habilidad2') . ' con ' . $this->input->post('por_habilidad2') . '% ' : $this->input->post('habilidad2');
            }
            if ($this->input->post('habilidad3') != "") {
                $habilidades .= ($this->input->post('por_habilidad3') != '') ? $this->input->post('habilidad3') . ' con ' . $this->input->post('por_habilidad3') . '% ' : $this->input->post('habilidad3');
            }
            if ($this->input->post('sueldo_adicional') != "N/A") {
                $sueldo_adicional .= ($this->input->post('monto_adicional') != '') ? $this->input->post('sueldo_adicional') . ' por ' . $this->input->post('monto_adicional') : $this->input->post('sueldo_adicional');
            } else {
                $sueldo_adicional .= $this->input->post('sueldo_adicional');
            }
            if ($this->input->post('licencia') != "No necesaria") {
                $licencia .= ($this->input->post('tipo_licencia') != '') ? $this->input->post('licencia') . ' ' . $this->input->post('tipo_licencia') : $this->input->post('licencia');
            } else {
                $licencia .= $this->input->post('licencia');
            }

            $req = array(
                'creacion' => $date,
                'edicion' => $date,
                'id_portal' => $id_portal,
                'id_usuario_cliente' => $id_usuario,
                'id_cliente' => $id_cliente,
                'tipo' => "COMPLETA",
                'puesto' => $this->input->post('puesto'),
                'numero_vacantes' => $this->input->post('num_vacantes'),
                'escolaridad' => $this->input->post('escolaridad'),
                'estatus_escolar' => $this->input->post('estatus_escolaridad'),
                'otro_estatus_escolar' => $this->input->post('otro_estatus'),
                'carrera_requerida' => $this->input->post('carrera'),
                'idiomas' => $idiomas,
                'otros_estudios' => $this->input->post('otros_estudios'),
                'habilidad_informatica' => $habilidades,
                'genero' => $this->input->post('genero'),
                'estado_civil' => $this->input->post('civil'),
                'edad_minima' => $this->input->post('edad_minima'),
                'edad_maxima' => $this->input->post('edad_maxima'),
                'licencia' => $licencia,
                'discapacidad_aceptable' => $this->input->post('discapacidad'),
                'causa_vacante' => $this->input->post('causa'),
                'lugar_residencia' => $this->input->post('residencia'),
                'jornada_laboral' => $this->input->post('jornada'),
                'tiempo_inicio' => $this->input->post('tiempo_inicio'),
                'tiempo_final' => $this->input->post('tiempo_final'),
                'dias_descanso' => $this->input->post('descanso'),
                'disponibilidad_viajar' => $this->input->post('viajar'),
                //'disponibilidad_horario' => $this->input->post('horario'),
                'zona_trabajo' => $this->input->post('zona'),
                'sueldo' => $this->input->post('tipo_sueldo'),
                'sueldo_adicional' => $sueldo_adicional,
                'sueldo_minimo' => $this->input->post('sueldo_minimo'),
                'sueldo_maximo' => $this->input->post('sueldo_maximo'),
                'tipo_pago_sueldo' => $this->input->post('tipo_pago'),
                'tipo_prestaciones' => $this->input->post('ley'),
                'tipo_prestaciones_superiores' => $this->input->post('superiores'),
                'otras_prestaciones' => $this->input->post('otras_prestaciones'),
                'experiencia' => $this->input->post('experiencia'),
                'actividades' => $this->input->post('actividades'),
                'competencias' => $this->input->post('competencias'),
                'observaciones' => $this->input->post('observaciones'),
            );

         
            $result = $this->requisicion_model->guardar($req);
          

            if (!empty($result)) {

                if ($notificacion > 0) {
                    // Obtener datos para notificación
                   
                        $result2 =$this->notificaciones_whatsapp_model->obtenerDatosRegistroRequicisionCliente($result);
                       
                        if ($result2 && !empty($result2->phone)) {
                            $datos_plantilla = array(
                                'nombre_cliente' => $result2->nombre_cliente,
                                'nombre_gerente' => $result2->nombre_gerente,
                                'vacante' => $result2->vacante,
                                'telefono' => $result2->phone,
                                'ruta' => 'send-message-requisicion-cliente', // Ajusta según sea necesario
                            );

                            $api_response = $this->notificaciones_whatsapp_model->alertaMovimientoApirante('52' . $result2->phone, 'nueva_requisicion', $datos_plantilla);

                            if ($api_response['codigo'] == 1) {
                                $msj = array(
                                    'codigo' => 1,
                                    'msg' => 'El registro se realizó correctamente. ' . $api_response['msg'],
                                );
                            } else {
                                $msj = array(
                                    'codigo' => 0,
                                    'msg' => $api_response['msg'],
                                );
                            }
                        } else {
                            // Datos para notificación no válidos
                            $msj = array(
                                'codigo' => 1,
                                'msg' => 'El registro se realizó correctamente. La notificación no fue enviada porque no se encontraron datos válidos para notificar.',
                            );
                        }

                    

                } else {
                    // Notificación desactivada
                    $msj = array(
                        'codigo' => 1,
                        'msg' => 'El registro se realizó correctamente. La notificación no fué enviada.',
                    );
                }

                $msj = array(
                    'codigo' => 1,
                    'msg' => 'Requisición express registrada correctamente',
                );
            } else {
                $msj = array(
                    'codigo' => 0,
                    'msg' => 'Error al registrar la requisición',
                );
            }
            echo json_encode($msj);
        }

    }
}
