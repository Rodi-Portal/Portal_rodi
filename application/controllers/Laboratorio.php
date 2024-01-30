<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laboratorio extends CI_Controller{

  function __construct(){
    parent::__construct();
    if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
  }

  /*----------------------------------------*/
  /*  Grupo Sanguineo
  /*----------------------------------------*/
    function sanguineo(){
      $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
      $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
			foreach($data['submodulos'] as $row) {
				$items[] = $row->id_submodulo;
			}
			$data['submenus'] = $items;
      
      //$info['clientes'] = $this->funciones_model->getClientesActivos();
      $info['grupos_sanguineos'] = $this->funciones_model->getGruposSanguineos();
      $vista['modals'] = $this->load->view('modals/mdl_laboratorio',$info, TRUE);
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
      ->view('laboratorio/sanguineo',$vista)
      ->view('adminpanel/footer');
    }
    function getExamenesGrupoSanguineo(){
      $analisis['recordsTotal'] = $this->laboratorio_model->getExamenesGrupoSanguineoTotal();
      $analisis['recordsFiltered'] = $this->laboratorio_model->getExamenesGrupoSanguineoTotal();
      $analisis['data'] = $this->laboratorio_model->getExamenesGrupoSanguineo();
      $this->output->set_output( json_encode( $analisis ) );
    }
    function guardarPacienteGrupoSanguineo(){
      $this->form_validation->set_rules('nombre', 'Nombre(s)', 'required|trim');
      $this->form_validation->set_rules('paterno', 'Primer apellido', 'required|trim');
      $this->form_validation->set_rules('materno', 'Segundo apellido', 'trim');
      $this->form_validation->set_rules('genero', 'Genero', 'required|trim');
      $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de nacimiento', 'required|trim');
      $this->form_validation->set_rules('fecha_toma', 'Fecha de toma', 'required|trim');
      $this->form_validation->set_rules('medico', 'Dirigido a', 'required|trim');
      $this->form_validation->set_rules('metodo', 'Método a utilizar', 'required|trim');
      
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
        $fecha_toma = fecha_hora_espanol_bd($this->input->post('fecha_toma'));
        $edad = calculaEdad($fecha_nacimiento);
        $nombre = $this->input->post('nombre');
        $paterno = $this->input->post('paterno');
        $materno = $this->input->post('materno');
        $id_analisis = $this->input->post('id_analisis');
        $id_paciente = $this->input->post('id_paciente');
        if($id_analisis == ''){
          $paciente = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'nombre' => strtoupper($nombre),
            'paterno' => strtoupper($paterno),
            'materno' => strtoupper($materno),
            'fecha_nacimiento' => $fecha_nacimiento,
            'edad' => $edad,
            'genero' => $this->input->post('genero')
          );
          $id_paciente = $this->laboratorio_model->guardarPaciente($paciente);

          $analisis = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'id_paciente' => $id_paciente,
            'tipo_examen' => 'Grupo sanguineo',
            'fecha_toma' => $fecha_toma,
            'medico' => $this->input->post('medico'),
            'metodo' => $this->input->post('metodo')
          );
          $this->laboratorio_model->guardarAnalisis($analisis);
        }
        else{
          $paciente = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'nombre' => strtoupper($nombre),
            'paterno' => strtoupper($paterno),
            'materno' => strtoupper($materno),
            'fecha_nacimiento' => $fecha_nacimiento,
            'edad' => $edad,
            'genero' => $this->input->post('genero')
          );
          $this->laboratorio_model->editarPaciente($paciente, $id_paciente);

          $analisis = array(
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'fecha_toma' => $fecha_toma,
            'medico' => $this->input->post('medico'),
            'metodo' => $this->input->post('metodo')
          );
          $this->laboratorio_model->editarAnalisis($analisis, $id_analisis);
        }

        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
      }
      echo json_encode($msj);
    }
    function guardarResultadoGrupoSanguineo(){
      $this->form_validation->set_rules('grupo', 'Grupo sanguíneo', 'required|trim');
      
      $this->form_validation->set_message('required','El campo {field} es obligatorio');

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
        $id_analisis = $this->input->post('id_analisis');
        $id_paciente = $this->input->post('id_paciente');
        $analisis = array(
          'id_usuario' => $id_usuario,
          'fecha_resultados' => $date,
          'resultado' => $this->input->post('grupo')
        );
        $this->laboratorio_model->editarAnalisis($analisis, $id_analisis);

        $msj = array(
          'codigo' => 1,
          'msg' => 'success'
        );
      }
      echo json_encode($msj);
    }
    function crearPDF(){
      $mpdf = new \Mpdf\Mpdf();
      date_default_timezone_set('America/Mexico_City');
      $id_analisis = $this->input->post('idAnalisis');
      $datos = $this->laboratorio_model->getDatosExamen($id_analisis);
      $data['fecha_examen'] = formatoFechaEspanolPDF($datos->edicion);
      $data['info'] = $datos;
      //$data['config'] = $this->funciones_model->getConfiguraciones();
      $data['area'] = $this->area_model->getArea('GRUPO SANGUINEO');
      $html = $this->load->view('pdfs/lab_grupo_sanguineo_pdf',$data,TRUE);
      $mpdf->setAutoTopMargin = 'stretch';
      //$mpdf->AddPage();
      $mpdf->SetHTMLHeader('<div style=""><img style="" src="'.base_url().'img/Encabezado.png"></div>');
      $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;"><div style="border-bottom:1px solid gray;"><b>Teléfono:</b> (33) 2301-8599 | <b>Correo:</b> hola@rodi.com.mx | <b>Sitio web:</b> rodi.com.mx</div><br>Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco, México. C.P. 45018 <br></p></div><div style="position: absolute; right: 10px;  bottom: 13px;"><img width="" src="'.base_url().'img/logo2.png"></div>');
      $mpdf->WriteHTML($html);
      $mpdf->Output($id_analisis.'_AnalisisGrupoSanguineo.pdf','D'); // opens in browser
    }
    function eliminarAnalisis(){
      date_default_timezone_set('America/Mexico_City');
      $date = date('Y-m-d H:i:s');
      $id_usuario = $this->session->userdata('id');
      $id_analisis = $this->input->post('id_analisis');
      $analisis = array(
        'edicion' => $date,
        'id_usuario' => $id_usuario,
        'eliminado' => 1
      );
      $this->laboratorio_model->editarAnalisis($analisis, $id_analisis);

      $msj = array(
        'codigo' => 1,
        'msg' => 'El registro ha sido eliminado correctamente'
      );

      echo json_encode($msj);
    }
}