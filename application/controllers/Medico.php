<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medico extends CI_Controller{

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
  }
    /*----------------------------------------*/
    /*  Modulo Examen Medico
    /*----------------------------------------*/
        function index(){
            $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
            $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
            foreach($data['submodulos'] as $row) {
                $items[] = $row->id_submodulo;
            }
            $data['submenus'] = $items;
            
            $datos['identificaciones'] = $this->funciones_model->getTiposIdentificaciones();
            $info['civiles'] = $this->funciones_model->getEstadosCiviles();
            $info['escolaridades'] = $this->funciones_model->getEscolaridades();
            $info['clientes'] = $this->funciones_model->getClientesActivos();
            $datos['modals'] = $this->load->view('modals/mdl_medico',$info, TRUE);
            $config = $this->funciones_model->getConfiguraciones();
            $data['version'] = $config->version_sistema;

            //Modals
            $modales['modals'] = $this->load->view('modals/mdl_usuario','', TRUE);
            $notificaciones = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0,1]);
			if(!empty($notificaciones)){
				$contador = 0;
				foreach($notificaciones as $row){
					if($row->visto == 0){
						$contador++;
					}
				}
				$data['contadorNotificaciones'] = $contador;
			}
            $this->load
            ->view('adminpanel/header',$data)
            ->view('adminpanel/scripts',$modales)
            ->view('medico/medico',$datos)
            ->view('adminpanel/footer');
        }
        function getAnalisisMedico(){
            $analisis['recordsTotal'] = $this->medico_model->getAnalisisTotal();
            $analisis['recordsFiltered'] = $this->medico_model->getAnalisisTotal();
            $analisis['data'] = $this->medico_model->getAnalisisMedico();
            $this->output->set_output( json_encode( $analisis ) );
        }
        function registrarNuevo(){
            $this->form_validation->set_rules('cliente', 'Cliente', 'required|trim');
            $this->form_validation->set_rules('nombre', 'Nombre(s)', 'required|trim');
            $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
            $this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
            $this->form_validation->set_rules('genero', 'Genero', 'required|trim');
            $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required|trim|max_length[18]');
            $this->form_validation->set_rules('telefono_emergencia', 'Teléfono de emergencia', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('avisar', 'Avisar a', 'required|trim');
            $this->form_validation->set_rules('civil', 'Estado civil', 'required|trim');
            $this->form_validation->set_rules('escolaridad', 'Escolaridad', 'required|trim');
            
            $this->form_validation->set_message('required','El campo {field} es obligatorio');
            $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
            $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

            $msj = array();
            if ($this->form_validation->run() == FALSE) {
                $msj = array(
                    'codigo' => 0,
                    'msg' => validation_errors()
                );
            } 
            else{
                date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
                $id_usuario = $this->session->userdata('id');
                $fecha_nacimiento = fecha_espanol_bd($this->input->post('fecha_nacimiento'));
                $edad = calculaEdad($fecha_nacimiento);
                $nombre = $this->input->post('nombre');
                $paterno = $this->input->post('paterno');
                $materno = $this->input->post('materno');

                $candidato = array(
                    'creacion' => $date,
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'fecha_alta' => $date,
                    'nombre' => strtoupper($nombre),
                    'paterno' => strtoupper($paterno),
                    'materno' => strtoupper($materno),
                    'edicion' => $date,
                    'id_cliente' => $this->input->post('cliente'),
                    'fecha_nacimiento' => $fecha_nacimiento,
                    'edad' => $edad,
                    'estado_civil' => $this->input->post('civil'),
                    'id_grado_estudio' => $this->input->post('escolaridad'),
                    'genero' => $this->input->post('genero')
                );
                $id_candidato = $this->candidato_model->registrarRetornaCandidato($candidato);

                $pruebas = array(
                    'creacion' => $date,
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'id_candidato' => $id_candidato,
                    'id_cliente' => 0,
                    'medico' => 1
                );
                $this->candidato_model->crearPruebas($pruebas);

                $analisis = array(
                    'creacion' => $date,
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'id_candidato' => $id_candidato,
                    'telefono_emergencia' => $this->input->post('telefono_emergencia'),
                    'avisar_a' => $this->input->post('avisar')
                );
                $this->medico_model->guardarMedico($analisis);

                $msj = array(
                    'codigo' => 1,
                    'msg' => 'success'
                );
            }
            echo json_encode($msj);
        }
        function guardarFichaIdentificacion(){
            $this->form_validation->set_rules('genero', 'Genero', 'required|trim');
            $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required|trim|max_length[18]');
            $this->form_validation->set_rules('telefono_emergencia', 'Teléfono de emergencia', 'required|trim|max_length[16]');
            $this->form_validation->set_rules('avisar', 'Avisar a', 'required|trim');
            $this->form_validation->set_rules('civil', 'Estado civil', 'required|trim');
            $this->form_validation->set_rules('escolaridad', 'Escolaridad', 'required|trim');
            
            $this->form_validation->set_message('required','El campo {field} es obligatorio');
            $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
            $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

            $msj = array();
            if ($this->form_validation->run() == FALSE) {
                $msj = array(
                    'codigo' => 0,
                    'msg' => validation_errors()
                );
            } 
            else{
                date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
                $id_candidato = $this->input->post('id_candidato');
                $id_usuario = $this->session->userdata('id');
                $fecha_nacimiento = fecha_espanol_bd($this->input->post('fecha_nacimiento'));
                $edad = $this->calculaEdad($fecha_nacimiento);

                $candidato = array(
                    'edicion' => $date,
                    'fecha_nacimiento' => $fecha_nacimiento,
                    'edad' => $edad,
                    'estado_civil' => $this->input->post('civil'),
                    'id_grado_estudio' => $this->input->post('escolaridad'),
                    'genero' => $this->input->post('genero')
                );
                $this->candidato_model->editarCandidato($candidato,$id_candidato);

                $examen = $this->medico_model->checkExamenMedico($id_candidato);
                if($examen != null){
                    $analisis = array(
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'telefono_emergencia' => $this->input->post('telefono_emergencia'),
                        'avisar_a' => $this->input->post('avisar')
                    );
                    $this->medico_model->editarMedico($analisis, $examen->id);
                }
                else{
                    $analisis = array(
                        'creacion' => $date,
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'id_candidato' => $id_candidato,
                        'telefono_emergencia' => $this->input->post('telefono_emergencia'),
                        'avisar_a' => $this->input->post('avisar')
                    );
                    $this->medico_model->guardarMedico($analisis);
                }
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'success'
                );
            }
            echo json_encode($msj);
        }
        function guardarAntecedentesHeredoFamiliares(){
            $this->form_validation->set_rules('diabetes', 'Diabetes', 'required|trim');
            $this->form_validation->set_rules('cancer', 'Cancer', 'required|trim');
            $this->form_validation->set_rules('hipertension', 'Hipertension', 'required|trim');
            $this->form_validation->set_rules('cardiopatias', 'Cardiopatias', 'required|trim');
            $this->form_validation->set_rules('pulmonares', 'Pulmonares', 'required|trim');
            $this->form_validation->set_rules('renales', 'Renales', 'required|trim');
            $this->form_validation->set_rules('psiquiatrica', 'Psiquiatrica', 'required|trim');
            $this->form_validation->set_rules('cual', 'Cual', 'required|trim');
            $this->form_validation->set_rules('sangre', 'Tipo de sangre', 'required|trim');

            $this->form_validation->set_message('required','El campo {field} es obligatorio');
            $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
            $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

            $msj = array();
            if ($this->form_validation->run() == FALSE) {
                $msj = array(
                    'codigo' => 0,
                    'msg' => validation_errors()
                );
            } 
            else{
                date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
                $id_candidato = $this->input->post('id_candidato');
                $id_usuario = $this->session->userdata('id');


                $examen = $this->medico_model->checkExamenMedico($id_candidato);
                if($examen != null){
                    $analisis = array(
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'diabetes' => $this->input->post('diabetes'),
                        'cancer' => $this->input->post('cancer'),
                        'hipertension' => $this->input->post('hipertension'),
                        'cardiopatias' => $this->input->post('cardiopatias'),
                        'pulmonares' => $this->input->post('pulmonares'),
                        'renales' => $this->input->post('renales'),
                        'psiquiatricas' => $this->input->post('psiquiatrica'),
                        'cuales_antecedentes_familiares' => $this->input->post('cual'),
                        'tipo_sangre' => $this->input->post('sangre')

                        
                    );
                    $this->medico_model->editarMedico($analisis, $examen->id);
                }
                else{
                    $analisis = array(
                        'creacion' => $date,
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'id_candidato' => $id_candidato,
                        'diabetes' => $this->input->post('diabetes'),
                        'cancer' => $this->input->post('cancer'),
                        'hipertension' => $this->input->post('hipertension'),
                        'cardiopatias' => $this->input->post('cardiopatias'),
                        'pulmonares' => $this->input->post('pulmonares'),
                        'renales' => $this->input->post('renales'),
                        'psiquiatricas' => $this->input->post('psiquiatrica'),
                        'cuales_antecedentes_familiares' => $this->input->post('cual'),
                        'tipo_sangre' => $this->input->post('sangre')
                        
                    );
                    $this->medico_model->guardarMedico($analisis);
                }
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'success'
                );
            }
            echo json_encode($msj);

        }
        function guardarAntecedentesNoPatologicos(){
            $this->form_validation->set_rules('tabaco', 'Tabaco', 'required|trim');
            $this->form_validation->set_rules('tabaco_cantidad', 'Tabaco Cantidad', 'required|trim|numeric|max_length[2]');
            $this->form_validation->set_rules('tabaco_frecuencia', 'Tabaco Frecuencia', 'required|trim');
            $this->form_validation->set_rules('alcohol', 'Alcohol', 'required|trim');
            $this->form_validation->set_rules('alcohol_cantidad', 'Alcohol Cantidad', 'required|trim|numeric|max_length[2]');
            $this->form_validation->set_rules('alcohol_frecuencia', 'Alcohol Frecuencia', 'required|trim');
            $this->form_validation->set_rules('drogas', 'Drogas', 'required|trim');
            $this->form_validation->set_rules('drogas_tipo', 'Tipo Droga', 'required|trim');
            $this->form_validation->set_rules('deporte', 'Deporte', 'required|trim');
            $this->form_validation->set_rules('deporte_cual', 'Cual deporte', 'required|trim');
            $this->form_validation->set_rules('alimentacion', 'Alimentacion', 'required|trim');

            $this->form_validation->set_message('required','El campo {field} es obligatorio');
            $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
            $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

            $msj = array();
            if ($this->form_validation->run() == FALSE) {
                $msj = array(
                    'codigo' => 0,
                    'msg' => validation_errors()
                );
            } 
            else{
                date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
                $id_candidato = $this->input->post('id_candidato');
                $id_usuario = $this->session->userdata('id');


                $examen = $this->medico_model->checkExamenMedico($id_candidato);
                if($examen != null){
                    $analisis = array(
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'tabaco' => $this->input->post('tabaco'),
                        'tabaco_cantidad' => $this->input->post('tabaco_cantidad'),
                        'tabaco_frecuencia' => $this->input->post('tabaco_frecuencia'),
                        'alcohol' => $this->input->post('alcohol'),
                        'alcohol_cantidad' => $this->input->post('alcohol_cantidad'),
                        'alcohol_frecuencia' => $this->input->post('alcohol_frecuencia'),
                        'droga' => $this->input->post('drogas'),
                        'droga_tipo' => $this->input->post('drogas_tipo'),
                        'deporte' => $this->input->post('deporte'),
                        'deporte_cual' => $this->input->post('deporte_cual'),
                        'alimentacion' => $this->input->post('alimentacion')
                        
                    );
                    $this->medico_model->editarMedico($analisis, $examen->id);
                }
                else{
                    $analisis = array(
                        'creacion' => $date,
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'id_candidato' => $id_candidato,
                        'tabaco' => $this->input->post('tabaco'),
                        'tabaco_cantidad' => $this->input->post('tabaco_cantidad'),
                        'tabaco_frecuencia' => $this->input->post('tabaco_frecuencia'),
                        'alcohol' => $this->input->post('alcohol'),
                        'alcohol_cantidad' => $this->input->post('alcohol_cantidad'),
                        'alcohol_frecuencia' => $this->input->post('alcohol_frecuencia'),
                        'droga' => $this->input->post('drogas'),
                        'droga_tipo' => $this->input->post('drogas_tipo'),
                        'deporte' => $this->input->post('deporte'),
                        'deporte_cual' => $this->input->post('deporte_cual'),
                        'alimentacion' => $this->input->post('alimentacion')
                        
                    );
                    $this->medico_model->guardarMedico($analisis);
                }
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'success'
                );
            }
            echo json_encode($msj);
        }
        function guardarAntecedentesPatologicosPersonales(){
            $this->form_validation->set_rules('quirurgicos', 'Quirurgicos', 'required|trim');
            $this->form_validation->set_rules('quirurgicos_hace_cuanto', 'Hace cuanto Quirurgicos', 'required|trim');
            $this->form_validation->set_rules('quirurgicos_cual', 'Cual Quirurgicos', 'required|trim');
            $this->form_validation->set_rules('internamientos', 'Internamientos', 'required|trim');
            $this->form_validation->set_rules('internamientos_hace_cuanto', 'Hace cuanto Internamientos', 'required|trim');
            $this->form_validation->set_rules('internamientos_porque', 'Por que Internamientos', 'required|trim');
            $this->form_validation->set_rules('transfusiones', 'Transfusiones', 'required|trim');
            $this->form_validation->set_rules('transfusiones_hace_cuanto', 'Hace cuanto Transfusiones', 'required|trim');
            $this->form_validation->set_rules('transfusiones_porque', 'Por que Transfusiones', 'required|trim');
            $this->form_validation->set_rules('fracturas', 'Fracturas', 'required|trim');
            $this->form_validation->set_rules('esguinces', 'Esguinces', 'required|trim');
            $this->form_validation->set_rules('luxaciones', 'Luxaciones', 'required|trim');
            $this->form_validation->set_rules('traumatismo', 'Traumatismo', 'required|trim');
            $this->form_validation->set_rules('hernia', 'Hernias', 'required|trim');
            $this->form_validation->set_rules('lesiones_columna', 'Lesiones en columna', 'required|trim');
            $this->form_validation->set_rules('alergias', 'Alergias', 'required|trim');
            $this->form_validation->set_rules('alergias_aque', 'A que Alergias', 'required|trim');

            $this->form_validation->set_message('required','El campo {field} es obligatorio');
            $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
            $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

            $msj = array();
            if ($this->form_validation->run() == FALSE) {
                $msj = array(
                    'codigo' => 0,
                    'msg' => validation_errors()
                );
            } 
            else{
                date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
                $id_candidato = $this->input->post('id_candidato');
                $id_usuario = $this->session->userdata('id');


                $examen = $this->medico_model->checkExamenMedico($id_candidato);
                if($examen != null){
                    $analisis = array(
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'quirurgicos' => $this->input->post('quirurgicos'),
                        'quirurgicos_hace_cuanto' => $this->input->post('quirurgicos_hace_cuanto'),
                        'quirurgicos_cual' => $this->input->post('quirurgicos_cual'),
                        'internamientos' => $this->input->post('internamientos'),
                        'internamientos_hace_cuanto' => $this->input->post('internamientos_hace_cuanto'),
                        'internamientos_porque' => $this->input->post('internamientos_porque'),
                        'transfusiones' => $this->input->post('transfusiones'),
                        'transfusiones_hace_cuanto' => $this->input->post('transfusiones_hace_cuanto'),
                        'transfusiones_porque' => $this->input->post('transfusiones_porque'),
                        'fracturas' => $this->input->post('fracturas'),
                        'esguinces' => $this->input->post('esguinces'),
                        'luxaciones' => $this->input->post('luxaciones'),
                        'traumatismo' => $this->input->post('traumatismo'),
                        'hernia' => $this->input->post('hernia'),
                        'lesiones_columna' => $this->input->post('lesiones_columna'),
                        'alergias' => $this->input->post('alergias'),
                        'alergias_cual' => $this->input->post('alergias_aque'),
                            
                    );
                    $this->medico_model->editarMedico($analisis, $examen->id);
                }
                else{
                    $analisis = array(
                        'creacion' => $date,
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'id_candidato' => $id_candidato,
                        'quirurgicos' => $this->input->post('quirurgicos'),
                        'quirurgicos_hace_cuanto' => $this->input->post('quirurgicos_hace_cuanto'),
                        'internamientos' => $this->input->post('internamientos'),
                        'internamientos_hace_cuanto' => $this->input->post('internamientos_hace_cuanto'),
                        'internamientos_porque' => $this->input->post('internamientos_porque'),
                        'transfusiones' => $this->input->post('transfusiones'),
                        'transfusiones_hace_cuanto' => $this->input->post('transfusiones_hace_cuanto'),
                        'transfusiones_porque' => $this->input->post('transfusiones_porque'),
                        'fracturas' => $this->input->post('fracturas'),
                        'esguinces' => $this->input->post('esguinces'),
                        'luxaciones' => $this->input->post('luxaciones'),
                        'traumatismo' => $this->input->post('traumatismo'),
                        'hernia' => $this->input->post('hernia'),
                        'lesiones_columna' => $this->input->post('lesiones_columna'),
                        'alergias' => $this->input->post('alergias'),
                        'alergias_cual' => $this->input->post('alergias_aque'),
                        
                        
                    );
                    $this->medico_model->guardarMedico($analisis);
                }
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'success'
                );
            }
            echo json_encode($msj);
        }
        function guardarChequeoGeneral(){
            $this->form_validation->set_rules('estatura', 'Estatura', 'required|trim|numeric');
            $this->form_validation->set_rules('peso', 'Peso', 'required|trim|numeric');
            $this->form_validation->set_rules('imc', 'Imc', 'required|trim|numeric');
            $this->form_validation->set_rules('grasa_muscular', 'Grasa Muscular', 'required|trim|numeric');
            $this->form_validation->set_rules('musculo', 'Musculo', 'required|trim|numeric');
            $this->form_validation->set_rules('calorias', 'Calorias', 'required|trim|numeric');
            $this->form_validation->set_rules('edad_metabolica', 'Edad Metabolica', 'required|trim|numeric');
            $this->form_validation->set_rules('grasa_visceral', 'Grasa Visceral', 'required|trim|numeric');
            $this->form_validation->set_rules('presion_arterial', 'Presion Arterial', 'required|trim');
            $this->form_validation->set_rules('frecuencia_cardiaca', 'Frecuencia Cardiaca', 'required|trim|numeric');
            $this->form_validation->set_rules('glucosa', 'Glucosa', 'trim|numeric');
            
            $this->form_validation->set_message('required','El campo {field} es obligatorio');
            $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
            $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

            $msj = array();
            if ($this->form_validation->run() == FALSE) {
                $msj = array(
                    'codigo' => 0,
                    'msg' => validation_errors()
                );
            } 
            else{
                date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
                $id_candidato = $this->input->post('id_candidato');
                $id_usuario = $this->session->userdata('id');


                $examen = $this->medico_model->checkExamenMedico($id_candidato);
                if($examen != null){
                    $analisis = array(
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'estatura' => $this->input->post('estatura'),
                        'peso' => $this->input->post('peso'),
                        'imc' => $this->input->post('imc'),
                        'grasa' => $this->input->post('grasa_muscular'),
                        'musculo' => $this->input->post('musculo'),
                        'calorias' => $this->input->post('calorias'),
                        'edad_metabolica' => $this->input->post('edad_metabolica'),
                        'grasa_visceral' => $this->input->post('grasa_visceral'),
                        'presion' => $this->input->post('presion_arterial'),
                        'frecuencia_cardiaca' => $this->input->post('frecuencia_cardiaca'),
                        'glucosa' => $this->input->post('glucosa')
                            
                    );
                    $this->medico_model->editarMedico($analisis, $examen->id);
                }
                else{
                    $analisis = array(
                        'creacion' => $date,
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'id_candidato' => $id_candidato,
                        'estatura' => $this->input->post('estatura'),
                        'peso' => $this->input->post('peso'),
                        'imc' => $this->input->post('imc'),
                        'grasa' => $this->input->post('grasa_muscular'),
                        'musculo' => $this->input->post('musculo'),
                        'calorias' => $this->input->post('calorias'),
                        'edad_metabolica' => $this->input->post('edad_metabolica'),
                        'grasa_visceral' => $this->input->post('grasa_visceral'),
                        'presion' => $this->input->post('presion_arterial'),
                        'frecuencia_cardiaca' => $this->input->post('frecuencia_cardiaca'),
                        'glucosa' => $this->input->post('glucosa') 
                        
                    );
                    $this->medico_model->guardarMedico($analisis);
                }
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'success'
                );
            }
            echo json_encode($msj);
        }
        function guardarConcluir(){
            $this->form_validation->set_rules('descripcion', 'Descripcion de la persona', 'required|trim');
            $this->form_validation->set_rules('conclusion', 'Conclusion', 'required|trim');
        
            $this->form_validation->set_message('required','El campo {field} es obligatorio');
            $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
            $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

            $msj = array();
            if ($this->form_validation->run() == FALSE) {
                $msj = array(
                    'codigo' => 0,
                    'msg' => validation_errors()
                );
            } 
            else{
                date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
                $id_candidato = $this->input->post('id_candidato');
                $id_usuario = $this->session->userdata('id');


                $examen = $this->medico_model->checkExamenMedico($id_candidato);
                if($examen != null){
                    $analisis = array(
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'descripcion' => $this->input->post('descripcion'),
                        'conclusion' => $this->input->post('conclusion'),
                        
                        
                    );
                    $this->medico_model->editarMedico($analisis, $examen->id);
                }
                else{
                    $analisis = array(
                        'creacion' => $date,
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'id_candidato' => $id_candidato,
                        'descripcion' => $this->input->post('descripcion'),
                        'conclusion' => $this->input->post('conclusion'),
                        
                    );
                    $this->medico_model->guardarMedico($analisis);
                }
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'success'
                );
            }
            echo json_encode($msj);
        }
        function guardarVision(){
            $this->form_validation->set_rules('ojo_derecho', 'Ojo Derecho', 'required|trim');
            $this->form_validation->set_rules('ojo_izquierdo', 'Ojo Izquierdo', 'required|trim');
            $this->form_validation->set_rules('colores', 'Colores', 'required|trim');
            $this->form_validation->set_rules('lentes', 'Usa Lentes', 'required|trim');
        
            $this->form_validation->set_message('required','El campo {field} es obligatorio');
            $this->form_validation->set_message('max_length','El campo {field} debe tener máximo {param} carácteres');
            $this->form_validation->set_message('numeric','El campo {field} debe ser numérico');

            $msj = array();
            if ($this->form_validation->run() == FALSE) {
                $msj = array(
                    'codigo' => 0,
                    'msg' => validation_errors()
                );
            } 
            else{
                date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
                $id_candidato = $this->input->post('id_candidato');
                $id_usuario = $this->session->userdata('id');


                $examen = $this->medico_model->checkExamenMedico($id_candidato);
                if($examen != null){
                    $analisis = array(
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'vision_derecha' => $this->input->post('ojo_derecho'),
                        'vision_izquierda' => $this->input->post('ojo_izquierdo'),
                        'lentes' => $this->input->post('lentes'),
                        'vision_color' => $this->input->post('colores'),
                        
                    );
                    $this->medico_model->editarMedico($analisis, $examen->id);
                }
                else{
                    $analisis = array(
                        'creacion' => $date,
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'id_candidato' => $id_candidato,
                        'vision_derecha' => $this->input->post('ojo_derecho'),
                        'vision_izquierda' => $this->input->post('ojo_izquierdo'),
                        'lentes' => $this->input->post('lentes'),
                        'vision_color' => $this->input->post('colores'),
                        
                    );
                    $this->medico_model->guardarMedico($analisis);
                }
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'success'
                );
            }
            echo json_encode($msj);
        } 
        function registrarAnalisis(){
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');
            $cadena = $this->input->post('datos');
            parse_str($cadena, $dato);
            $id_candidato = $dato['id_candidato'];
            $id_analisis = $dato['id_analisis'];
            $id_usuario = $this->session->userdata('id');
            $fecha = $this->convertirDate($dato['fecha_nacimiento']);
            $edad = $this->calculaEdad($fecha);
            if($id_analisis != ""){
                $candidato = array(
                    'edicion' => $date,
                    'fecha_nacimiento' => $fecha,
                    'edad' => $edad,
                    'genero' => $dato['genero']
                );
                $this->candidato_model->saveCandidato($candidato,$id_candidato);
                $analisis = array(
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'peso' => $dato['peso'],
                    'estatura' => $dato['estatura'],
                    'imc' => $dato['imc'],
                    'grasa' => $dato['grasa'],
                    'musculo' => $dato['musculo'],
                    'edad_metabolica' => $dato['edad_metabolica'],
                    'presion' => $dato['presion'],
                    'frecuencia_cardiaca' => $dato['frecuencia'],
                    'vision_izquierda' => $dato['vision_izquierda'],
                    'vision_derecha' => $dato['vision_derecha'],
                    'lentes' => $dato['lentes'],
                    'vision_color' => $dato['vision_color']
                );
                $this->medico_model->updateMedico($analisis,$id_analisis);
            }
            else{
                $candidato = array(
                    'edicion' => $date,
                    'fecha_nacimiento' => $fecha,
                    'edad' => $edad,
                    'genero' => $dato['genero']
                );
                $this->candidato_model->saveCandidato($candidato,$id_candidato);
                $analisis = array(
                    'creacion' => $date,
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'id_candidato' => $id_candidato,
                    'peso' => $dato['peso'],
                    'estatura' => $dato['estatura'],
                    'imc' => $dato['imc'],
                    'grasa' => $dato['grasa'],
                    'musculo' => $dato['musculo'],
                    'edad_metabolica' => $dato['edad_metabolica'],
                    'presion' => $dato['presion'],
                    'frecuencia_cardiaca' => $dato['frecuencia'],
                    'vision_izquierda' => $dato['vision_izquierda'],
                    'vision_derecha' => $dato['vision_derecha'],
                    'lentes' => $dato['lentes'],
                    'vision_color' => $dato['vision_color']
                );
                $this->medico_model->insertMedico($analisis);
            }
            echo $salida = 1;
        }
        function getAnalisis(){
            $id_candidato = $_POST['id_candidato'];
            $salida = "";
            $data['datos'] = $this->medico_model->getAnalisis($id_candidato);
            if($data['datos']){
                foreach($data['datos'] as $d){
                    $fecha = $this->convertirFecha($d->fecha_nacimiento);
                    $salida .= $d->id.",";
                    $salida .= $d->peso.",";
                    $salida .= $d->estatura.",";
                    $salida .= $d->imc.",";
                    $salida .= $d->grasa.",";
                    $salida .= $d->musculo.",";
                    $salida .= $d->edad_metabolica.",";
                    $salida .= $d->presion.",";
                    $salida .= $d->frecuencia_cardiaca.",";
                    $salida .= $d->vision_izquierda.",";
                    $salida .= $d->vision_derecha.",";
                    $salida .= $d->lentes.",";
                    $salida .= $d->vision_color.",";
                    $salida .= $fecha.",";
                    $salida .= $d->genero;
                }
                echo $salida;
            }
            else{
                echo $salida = 0;
            }
        }
        function subirHistoriaClinica(){
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');
            $id_usuario = $this->session->userdata('id');
            $id_medico = $_POST['id_medico'];
            $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
            $nombre_archivo = $id_medico."_historia_clinica.".$extension;
            $config['upload_path'] = './_clinico/';  
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['overwrite'] = TRUE;
            /*$config['max_size']      = 1048; 
            $config['max_width']     = 1024; 
            $config['max_height']    = 768;*/
            $config['file_name'] = $nombre_archivo;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            // File upload
            if($this->upload->do_upload('archivo')){
                $data = $this->upload->data();
            }
            $doc = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'imagen_historia_clinica' => $nombre_archivo
            );
            $this->medico_model->updateMedico($doc, $id_medico);
            echo $salida = 1;
        }
        function crearPDF(){
            $mpdf = new \Mpdf\Mpdf();
            date_default_timezone_set('America/Mexico_City');
            if(isset($_POST['idMedico'])){
                $id_medico = $_POST['idMedico'];
            }
            else{
                $id_medico = $this->input->get('id');
            }
            $datos = $this->medico_model->getDatosMedico($id_medico);
            $data['fecha_medico'] = $this->formatoFecha($datos->edicion);
            $data['info'] = $datos;
            $data['area'] = $this->area_model->getArea('MEDICO');
            $html = $this->load->view('pdfs/analisis_medico_pdf',$data,TRUE);
            $mpdf->setAutoTopMargin = 'stretch';
            //$mpdf->AddPage();
            $mpdf->SetHTMLHeader('<div style=""><img style="" src="'.base_url().'img/Encabezado.png"></div>');
            $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>04-CERT-001, Rev. 01 <br>Fecha de Rev. 10/05/2021</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="'.base_url().'img/logo_pie.png"></div>');
            $mpdf->WriteHTML($html);
            $mpdf->Output($id_medico.'_AnalisisMedico.pdf','D'); // opens in browser
        }
    /*----------------------------------------*/
    /*  Examen Medico en carga de archivo
    /*----------------------------------------*/
        function subirExamenMedico(){
            $msj = array();
            if (!isset($_FILES['archivo'])) {
                $msj = array(
                    'codigo' => 0,
                    'msg' => 'El campo Archivo del Examen Medico es obligatorio'
                );
            } 
            else{
                date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
                $id_usuario = $this->session->userdata('id');
                $id_candidato = $_POST['id_candidato'];
                $extension = pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION);
                $nombre_archivo = $id_candidato."_examenmedico.".$extension;
                $config['upload_path'] = './_clinico/';  
                $config['allowed_types'] = 'pdf';
                $config['overwrite'] = TRUE;
                /*$config['max_size']      = 1048; 
                $config['max_width']     = 1024; 
                $config['max_height']    = 768;*/
                $config['file_name'] = $nombre_archivo;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                // File upload
                if($this->upload->do_upload('archivo')){
                    $data = $this->upload->data();
                }
                $medico = $this->medico_model->checkMedico($id_candidato);
                if($medico != null){
                    $doc = array(
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'archivo_examen_medico' => $nombre_archivo
                    );
                    $this->medico_model->editarMedico($doc, $medico->id);
                }
                else{
                    $doc = array(
                        'creacion' => $date,
                        'edicion' => $date,
                        'id_usuario' => $id_usuario,
                        'id_candidato' => $id_candidato,
                        'archivo_examen_medico' => $nombre_archivo
                    );
                    $this->medico_model->guardarMedico($doc);
                }
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'success'
                );
            }
            echo json_encode($msj);
        }

    /*----------------------------------------*/
    /*  Funciones de apoyo
    /*----------------------------------------*/
        function formatoFecha($f){
            date_default_timezone_set('America/Mexico_City');
            $numeroDia = date('d', strtotime($f));
            $mes = date('F', strtotime($f));
            $anio = date('Y', strtotime($f));
            $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            $nombreMes = str_replace($meses_EN, $meses_ES, $mes);

            return $numeroDia." de ".$nombreMes." de ".$anio;
        }
        function convertirDate($date){
            $aux = explode('/', $date);
            $fecha = $aux[2].'-'.$aux[1].'-'.$aux[0];
            return $fecha;
        }
        function convertirFecha($date){
            $aux = explode('-', $date);
            $fecha = $aux[2].'/'.$aux[1].'/'.$aux[0];
            return $fecha;
        }
        function calculaEdad($fechanacimiento){
            list($ano,$mes,$dia) = explode("-",$fechanacimiento);
            $ano_diferencia  = date("Y") - $ano;
            $mes_diferencia = date("m") - $mes;
            $dia_diferencia   = date("d") - $dia;
            if ($mes_diferencia < 0 || ($mes_diferencia == 0 && $dia_diferencia < 0 || $mes_diferencia < 0))
            $ano_diferencia--;
            return $ano_diferencia;
        }
}