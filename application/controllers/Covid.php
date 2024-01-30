<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Covid extends CI_Controller{

  function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}
  /*----------------------------------------*/
  /*  CRUD de pruebas
  /*----------------------------------------*/
  function index(){
    $data['permisos'] = $this->usuario_model->getPermisos($this->session->userdata('id'));
    $data['submodulos'] = $this->rol_model->getMenu($this->session->userdata('idrol'));
    foreach($data['submodulos'] as $row) {
        $items[] = $row->id_submodulo;
    }
    $data['submenus'] = $items;
    
    $info['clientes'] = $this->funciones_model->getClientesActivos();
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
    ->view('covid/index')
    ->view('adminpanel/footer');
  }
	function getPruebas(){
		$pruebas['recordsTotal'] = $this->covid_model->getTotalPruebas();
    $pruebas['recordsFiltered'] = $this->covid_model->getTotalPruebas();
    $pruebas['data'] = $this->covid_model->getPruebas();
    $this->output->set_output( json_encode( $pruebas ) );
  }
  function getOrden($fecha_prueba){
    date_default_timezone_set('America/Mexico_City');
    //$dia_actual = date('Y-m-d');
    $lastOrden = $this->covid_model->getUltimaOrden($fecha_prueba);
    if($lastOrden != null){
      /*$anio = date('y');
      $mes = date('m');
      $dia = date('d');*/
      $aux = explode('-', $fecha_prueba);
      $anio = substr($aux[0], -2);
      $mes = $aux[1];
      $dia = $aux[2];
      $num_anterior = substr($lastOrden->orden, -3);
      $num_anterior = intval($num_anterior);
      if($num_anterior < 10){
        $cifra = '00';
      }
      elseif($num_anterior >= 10 && $num_anterior < 100){
        $cifra = '0';
      }
      else{
        $cifra = '';
      }
      $nueva_orden = 'RN'.$anio.$mes.$dia.$cifra.($num_anterior + 1);
      return $nueva_orden;
    }
    else{
      /*$anio = date('y');
      $mes = date('m');
      $dia = date('d');*/
      $aux = explode('-', $fecha_prueba);
      $anio = substr($aux[0], -2);
      $mes = $aux[1];
      $dia = $aux[2];
      $nueva_orden = 'RN'.$anio.$mes.$dia.'001';
      return $nueva_orden;
    }
  }
  function getUltimoSanguineo(){
    $num = $this->covid_model->getUltimoSanguineo();
    if($num != null){
      $num->orden = intval($num->orden);
      if($num->orden >= 10 && $num->orden < 100){
        $orden = '0'.($num->orden + 1);
      }
      if($num->orden >= 100 && $num->orden < 1000){
        $orden = $num->orden + 1;
      }
    }
    else{
      $orden = '062';
    }
    return $orden;
  }
  function getUltimoPCR(){
    $num = $this->covid_model->getUltimoPCR();
    if($num > 0){
      if($num < 10){
        $orden = '00'.($num + 1);
      }
      if($num >= 10 && $num < 100){
        $orden = '0'.($num + 1);
      }
      if($num >= 100 && $num < 1000){
        $orden = $num + 1;
      }
    }
    else{
      $orden = '001';
    }
    return $orden;
  }
  function registrar(){
    date_default_timezone_set('America/Mexico_City');
    $date = date('Y-m-d H:i:s');
    $hoy = date('Y-m-d');
    $cadena = $this->input->post('datos');
    //$orden = $this->input->post('orden');
    parse_str($cadena, $dato);
    $id_usuario = $this->session->userdata('id');
    $aux = explode('/', $dato['fecha_prueba']);
    $fecha_prueba = $aux[2].'-'.$aux[1].'-'.$aux[0];
    $area = $this->area_model->getArea('COVID');


    $diaActual = new DateTime($hoy);
    $diaPrueba = new DateTime($fecha_prueba);
    if($diaActual > $diaPrueba){
      $dif = $diaActual->diff($diaPrueba);
      if($dif->days == 1){
        if($dato['tipo'] == "Nasofaringea"){
          $orden = $this->getOrden($fecha_prueba);
        }
        if($dato['tipo'] == "Sanguinea"){
          $orden = $this->getUltimoSanguineo();
        }
        if($dato['tipo'] == "PCR"){
          $orden = $this->getUltimoPCR();
        }
        $registro = array(
          'creacion' => $date,
          'edicion' => $date,
          'id_usuario' => $id_usuario,
          'id_area' => $area->id,
          'tipo_prueba' => $dato['tipo'],
          'orden' => $orden,
          'folio' => $dato['folio'],
          'dia_orden' => $fecha_prueba,
          'nombre' => $dato['nombre'],
          'fecha_nacimiento' => $dato['fecha_nacimiento'],
          'edad' => $dato['edad'],
          'genero' => $dato['genero'],
          'telefono' => $dato['celular'],
          'pasaporte' => $dato['pasaporte'],
          'medico' => $dato['medico']
        );
        $this->covid_model->registrar($registro);
        echo $salida = 1;
      }
      else{
        echo $salida = 0;
      }
    }
    else{
      if($diaActual <= $diaPrueba){
        $dif = $diaActual->diff($diaPrueba);
        if($dif->days > 4){
          echo $salida = 0;
        }
        else{
          if($dato['tipo'] == "Nasofaringea"){
            $orden = $this->getOrden($fecha_prueba);
          }
          if($dato['tipo'] == "Sanguinea"){
            $orden = $this->getUltimoSanguineo();
          }
          if($dato['tipo'] == "PCR"){
            $orden = $this->getUltimoPCR();
          }
          $registro = array(
            'creacion' => $date,
            'edicion' => $date,
            'id_usuario' => $id_usuario,
            'id_area' => $area->id,
            'tipo_prueba' => $dato['tipo'],
            'orden' => $orden,
            'folio' => $dato['folio'],
            'dia_orden' => $fecha_prueba,
            'nombre' => $dato['nombre'],
            'fecha_nacimiento' => $dato['fecha_nacimiento'],
            'edad' => $dato['edad'],
            'genero' => $dato['genero'],
            'telefono' => $dato['celular'],
            'pasaporte' => $dato['pasaporte'],
            'medico' => $dato['medico']
          );
          $this->covid_model->registrar($registro);
          echo $salida = 1;
        }
      }
    }
  }
  function editar(){
    date_default_timezone_set('America/Mexico_City');
    $date = date('Y-m-d H:i:s');
    $hoy = date('Y-m-d');
    $cadena = $this->input->post('datos');
    $id_prueba = $this->input->post('id_prueba');
    parse_str($cadena, $dato);
    $aux = explode('/', $dato['fecha_prueba']);
    $fecha_prueba = $aux[2].'-'.$aux[1].'-'.$aux[0];
    $id_usuario = $this->session->userdata('id');

    $diaActual = new DateTime($hoy);
    $diaPrueba = new DateTime($fecha_prueba);
    if($diaActual > $diaPrueba){
      $dif = $diaActual->diff($diaPrueba);
      if($dif->days == 1){
        $registro = array(
          'id_usuario' => $id_usuario,
          'folio' => $dato['folio'],
          'dia_orden' => $fecha_prueba,
          'nombre' => $dato['nombre'],
          'fecha_nacimiento' => $dato['fecha_nacimiento'],
          'edad' => $dato['edad'],
          'genero' => $dato['genero'],
          'telefono' => $dato['celular'],
          'pasaporte' => $dato['pasaporte'],
          'medico' => $dato['medico']
        );
        $this->covid_model->actualizar($registro, $id_prueba);
        echo $salida = 1;
      }
      else{
        echo $salida = 0;
      }
    }
    else{
      if($diaActual <= $diaPrueba){
        $dif = $diaActual->diff($diaPrueba);
        if($dif->days > 4){
          echo $salida = 0;
        }
        else{
          $registro = array(
            'id_usuario' => $id_usuario,
            'folio' => $dato['folio'],
            'dia_orden' => $fecha_prueba,
            'nombre' => $dato['nombre'],
            'fecha_nacimiento' => $dato['fecha_nacimiento'],
            'edad' => $dato['edad'],
            'genero' => $dato['genero'],
            'telefono' => $dato['celular'],
            'pasaporte' => $dato['pasaporte'],
            'medico' => $dato['medico']
          );
          $this->covid_model->actualizar($registro, $id_prueba);
          echo $salida = 1;
        }
      }
    }
    
  }
  function eliminar(){
    date_default_timezone_set('America/Mexico_City');
    $date = date('Y-m-d H:i:s');
    $id_prueba = $this->input->post('id_prueba');
    $id_usuario = $this->session->userdata('id');
    $prueba = array(
      'edicion' => $date,
      'id_usuario' => $id_usuario,
      'status' => 0
    );
    $this->covid_model->actualizar($prueba, $id_prueba);
    echo $salida = 1;
  }
  function registrarResultado(){
    date_default_timezone_set('America/Mexico_City');
    $date = date('Y-m-d H:i:s');
    $resultado = $this->input->post('res');
    $id = $this->input->post('id');
    $id_usuario = $this->session->userdata('id');
    $datos = array(
      'edicion' => $date,
      'id_usuario' => $id_usuario,
      'resultado' => $resultado
    );
    $this->covid_model->actualizar($datos, $id);
    echo $salida = 1;
  }
  /*----------------------------------------*/
  /*  PDF
  /*----------------------------------------*/
  function createNasofaringeaPDF(){
    $mpdf = new \Mpdf\Mpdf();
    date_default_timezone_set('America/Mexico_City');
    $data['hoy'] = date("d-m-Y");
    $hoy = date("d-m-Y");
    $id_prueba = $_POST['idPruebaCovid'];
    $prueba = $this->covid_model->getDatosPrueba($id_prueba); 
    if($prueba->qr_token == NULL){
      $this->load->library('ciqrcode');
      //QR de consulta
      $claveAleatoria = substr( md5(microtime()), 1, 16);
      $params['data'] = 'https://test-result.rodi.com.mx/covid/covid.php?uid='.$claveAleatoria;
      $params['level'] = 'H';
      $params['size'] = 10;
      $params['savename'] = "./_covid/qr_$id_prueba.png";
      $this->ciqrcode->generate($params);
      $data['qr'] = "qr_$id_prueba.png";
      $datos = array(
        'qr_token' => $claveAleatoria
      );
      $this->covid_model->actualizar($datos, $id_prueba);
    }
    else{
      $data['qr'] = "qr_$id_prueba.png";
    }
    $data['covid'] = $prueba;
    //$data['laboratorio'] = $this->area_model->getArea('COVID');
    $html = $this->load->view('pdfs/prueba_nasofaringea_pdf',$data,TRUE);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->WriteHTML($html);
    $mpdf->Output($prueba->orden.'.pdf','D'); 
  }
  function createNasofaringeaInglesPDF(){
    $mpdf = new \Mpdf\Mpdf();
    date_default_timezone_set('America/Mexico_City');
    $data['hoy'] = date("d-m-Y");
    $hoy = date("d-m-Y");
    $id_prueba = $_POST['idPruebaCovid'];
    $prueba = $this->covid_model->getDatosPrueba($id_prueba); 
    if($prueba->qr_token == NULL){
      $this->load->library('ciqrcode');
      //QR de consulta
      $claveAleatoria = substr( md5(microtime()), 1, 16);
      $params['data'] = 'https://test-result.rodi.com.mx/covid/covid.php?uid='.$claveAleatoria;
      $params['level'] = 'H';
      $params['size'] = 10;
      $params['savename'] = "./_covid/qr_$id_prueba.png";
      $this->ciqrcode->generate($params);
      $data['qr'] = "qr_$id_prueba.png";
      $datos = array(
        'qr_token' => $claveAleatoria
      );
      $this->covid_model->actualizar($datos, $id_prueba);
    }
    else{
      $data['qr'] = "qr_$id_prueba.png";
    }
    $data['covid'] = $prueba;
    //$data['laboratorio'] = $this->area_model->getArea('COVID');
    $html = $this->load->view('pdfs/prueba_nasofaringea_ingles_pdf',$data,TRUE);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->WriteHTML($html);
    $mpdf->Output($prueba->orden.'_english.pdf','D'); 
  }
  function createNasofaringeaDigitalPDF(){
    $mpdf = new \Mpdf\Mpdf();
    date_default_timezone_set('America/Mexico_City');
    $data['hoy'] = date("d-m-Y");
    $hoy = date("d-m-Y");
    $id_prueba = $_POST['idPruebaCovid'];
    $prueba = $this->covid_model->getDatosPrueba($id_prueba); 
    if($prueba->qr_token == NULL){
      $this->load->library('ciqrcode');
      //QR de consulta
      $claveAleatoria = substr( md5(microtime()), 1, 16);
      $params['data'] = 'https://test-result.rodi.com.mx/covid/covid.php?uid='.$claveAleatoria;
      $params['level'] = 'H';
      $params['size'] = 10;
      $params['savename'] = "./_covid/qr_$id_prueba.png";
      $this->ciqrcode->generate($params);
      $data['qr'] = "qr_$id_prueba.png";
      $datos = array(
        'qr_token' => $claveAleatoria
      );
      $this->covid_model->actualizar($datos, $id_prueba);
    }
    else{
      $data['qr'] = "qr_$id_prueba.png";
    }
    $data['covid'] = $prueba;
    //$data['laboratorio'] = $this->area_model->getArea('COVID');
    $html = $this->load->view('pdfs/digital_nasofaringea_pdf',$data,TRUE);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->SetHTMLHeader('<div style="width: 100%; float: left;"><img style="height: 150px;" src="'.base_url().'img/Encabezado.png"></div>');
    $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 12px;"><div style="border-bottom:1px solid gray;"><b>Teléfono:</b> (33) 2301-8599 | <b>Correo:</b> hola@rodi.com.mx | <b>Sitio web:</b> rodi.com.mx</div><br>Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco, México. C.P. 45018</p></div><div style="position: absolute; right: 10px;  bottom: 13px;"><img width="" src="'.base_url().'img/logo_pie.png"></div>');
    $mpdf->WriteHTML($html);
    $mpdf->Output($prueba->orden.'.pdf','D'); 
  }
  function createNasofaringeaDigitalENPDF(){
    $mpdf = new \Mpdf\Mpdf();
    date_default_timezone_set('America/Mexico_City');
    $data['hoy'] = date("d-m-Y");
    $hoy = date("d-m-Y");
    $id_prueba = $_POST['idENDigital'];
    $prueba = $this->covid_model->getDatosPrueba($id_prueba); 
    if($prueba->qr_token == NULL){
      $this->load->library('ciqrcode');
      //QR de consulta
      $claveAleatoria = substr( md5(microtime()), 1, 16);
      $params['data'] = 'https://test-result.rodi.com.mx/covid/covid.php?uid='.$claveAleatoria;
      $params['level'] = 'H';
      $params['size'] = 10;
      $params['savename'] = "./_covid/qr_$id_prueba.png";
      $this->ciqrcode->generate($params);
      $data['qr'] = "qr_$id_prueba.png";
      $datos = array(
        'qr_token' => $claveAleatoria
      );
      $this->covid_model->actualizar($datos, $id_prueba);
    }
    else{
      $data['qr'] = "qr_$id_prueba.png";
    }
    $data['covid'] = $prueba;
    //$data['laboratorio'] = $this->area_model->getArea('COVID');
    $html = $this->load->view('pdfs/digital_nasofaringea_ingles',$data,TRUE);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->SetHTMLHeader('<div style="width: 100%; float: left;"><img style="height: 150px;" src="'.base_url().'img/Encabezado.png"></div>');
    $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 12px;"><div style="border-bottom:1px solid gray;"><b>Teléfono:</b> (33) 2301-8599 | <b>Correo:</b> hola@rodi.com.mx | <b>Sitio web:</b> rodi.com.mx</div><br>Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco, México. C.P. 45018</p></div><div style="position: absolute; right: 10px;  bottom: 13px;"><img width="" src="'.base_url().'img/logo_pie.png"></div>');
    $mpdf->WriteHTML($html);
    $mpdf->Output($prueba->orden.'_english.pdf','D'); 
  }
  function createSanguineaPDF(){
    $mpdf = new \Mpdf\Mpdf();
    date_default_timezone_set('America/Mexico_City');
    $data['hoy'] = date("d-m-Y");
    $hoy = date("d-m-Y");
    $id_prueba = $_POST['idPruebaCovid'];
    $prueba = $this->covid_model->getDatosPrueba($id_prueba); 
    if($prueba->qr_token == NULL){
      $this->load->library('ciqrcode');
      //QR de consulta
      $claveAleatoria = substr( md5(microtime()), 1, 16);
      $params['data'] = 'https://test-result.rodi.com.mx/covid/covid.php?uid='.$claveAleatoria;
      $params['level'] = 'H';
      $params['size'] = 10;
      $params['savename'] = "./_covid/qr_$id_prueba.png";
      $this->ciqrcode->generate($params);
      $data['qr'] = "qr_$id_prueba.png";
      $datos = array(
        'qr_token' => $claveAleatoria
      );
      $this->covid_model->actualizar($datos, $id_prueba);
    }
    else{
      $data['qr'] = "qr_$id_prueba.png";
    }
    $data['covid'] = $prueba;
    //$data['laboratorio'] = $this->area_model->getArea('COVID');
    $data['tipo'] = 'digital';
    $html = $this->load->view('pdfs/prueba_sanguinea_pdf',$data,TRUE);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->SetHTMLHeader('<div style="width: 100%; float: left;"><img style="height: 150px;" src="'.base_url().'img/Encabezado.png"></div>');
    $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 12px;"><div style="border-bottom:1px solid gray;"><b>Teléfono:</b> (33) 2301-8599 | <b>Correo:</b> hola@rodi.com.mx | <b>Sitio web:</b> rodi.com.mx</div><br>Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco, México. C.P. 45018</p></div><div style="position: absolute; right: 10px;  bottom: 13px;"><img width="" src="'.base_url().'img/logo_pie.png"></div>');
    $mpdf->WriteHTML($html);
    $mpdf->Output($prueba->orden.'.pdf','D'); 
  }
  function createSanguineaMembretadoPDF(){
    $mpdf = new \Mpdf\Mpdf();
    date_default_timezone_set('America/Mexico_City');
    $data['hoy'] = date("d-m-Y");
    $hoy = date("d-m-Y");
    $id_prueba = $_POST['idPruebaCovid'];
    $prueba = $this->covid_model->getDatosPrueba($id_prueba); 
    if($prueba->qr_token == NULL){
      $this->load->library('ciqrcode');
      //QR de consulta
      $claveAleatoria = substr( md5(microtime()), 1, 16);
      $params['data'] = 'https://test-result.rodi.com.mx/covid/covid.php?uid='.$claveAleatoria;
      $params['level'] = 'H';
      $params['size'] = 10;
      $params['savename'] = "./_covid/qr_$id_prueba.png";
      $this->ciqrcode->generate($params);
      $data['qr'] = "qr_$id_prueba.png";
      $datos = array(
        'qr_token' => $claveAleatoria
      );
      $this->covid_model->actualizar($datos, $id_prueba);
    }
    else{
      $data['qr'] = "qr_$id_prueba.png";
    }
    $data['covid'] = $prueba;
    //$data['laboratorio'] = $this->area_model->getArea('COVID');
    $data['tipo'] = 'membretado';
    $html = $this->load->view('pdfs/prueba_sanguinea_pdf',$data,TRUE);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->WriteHTML($html);
    $mpdf->Output($prueba->orden.'.pdf','D'); 
  }
  function createPCRPDF(){
    $mpdf = new \Mpdf\Mpdf();
    date_default_timezone_set('America/Mexico_City');
    $data['hoy'] = date("d-m-Y");
    $hoy = date("d-m-Y");
    $id_prueba = $_POST['idPruebaCovid'];
    $prueba = $this->covid_model->getDatosPrueba($id_prueba); 
    if($prueba->qr_token == NULL){
      $this->load->library('ciqrcode');
      //QR de consulta
      $claveAleatoria = substr( md5(microtime()), 1, 16);
      $params['data'] = 'https://test-result.rodi.com.mx/covid/covid.php?uid='.$claveAleatoria;
      $params['level'] = 'H';
      $params['size'] = 10;
      $params['savename'] = "./_covid/qr_$id_prueba.png";
      $this->ciqrcode->generate($params);
      $data['qr'] = "qr_$id_prueba.png";
      $datos = array(
        'qr_token' => $claveAleatoria
      );
      $this->covid_model->actualizar($datos, $id_prueba);
    }
    else{
      $data['qr'] = "qr_$id_prueba.png";
    }
    $data['covid'] = $prueba;
    //$data['laboratorio'] = $this->area_model->getArea('COVID');
    $html = $this->load->view('pdfs/prueba_pcr_pdf',$data,TRUE);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->WriteHTML($html);
    $mpdf->Output($prueba->orden.'.pdf','D'); 
  }
  function createPCRInglesPDF(){
    $mpdf = new \Mpdf\Mpdf();
    date_default_timezone_set('America/Mexico_City');
    $data['hoy'] = date("d-m-Y");
    $hoy = date("d-m-Y");
    $id_prueba = $_POST['idPruebaCovid'];
    $prueba = $this->covid_model->getDatosPrueba($id_prueba); 
    if($prueba->qr_token == NULL){
      $this->load->library('ciqrcode');
      //QR de consulta
      $claveAleatoria = substr( md5(microtime()), 1, 16);
      $params['data'] = 'https://test-result.rodi.com.mx/covid/covid.php?uid='.$claveAleatoria;
      $params['level'] = 'H';
      $params['size'] = 10;
      $params['savename'] = "./_covid/qr_$id_prueba.png";
      $this->ciqrcode->generate($params);
      $data['qr'] = "qr_$id_prueba.png";
      $datos = array(
        'qr_token' => $claveAleatoria
      );
      $this->covid_model->actualizar($datos, $id_prueba);
    }
    else{
      $data['qr'] = "qr_$id_prueba.png";
    }
    $data['covid'] = $prueba;
    //$data['laboratorio'] = $this->area_model->getArea('COVID');
    $html = $this->load->view('pdfs/prueba_pcr_ingles_pdf',$data,TRUE);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->WriteHTML($html);
    $mpdf->Output($prueba->orden.'_english.pdf','D'); 
  }
  function createPCRDigitalPDF(){
    $mpdf = new \Mpdf\Mpdf();
    date_default_timezone_set('America/Mexico_City');
    $data['hoy'] = date("d-m-Y");
    $hoy = date("d-m-Y");
    $id_prueba = $_POST['idPruebaCovid'];
    $prueba = $this->covid_model->getDatosPrueba($id_prueba); 
    if($prueba->qr_token == NULL){
      $this->load->library('ciqrcode');
      //QR de consulta
      $claveAleatoria = substr( md5(microtime()), 1, 16);
      $params['data'] = 'https://test-result.rodi.com.mx/covid/covid.php?uid='.$claveAleatoria;
      $params['level'] = 'H';
      $params['size'] = 10;
      $params['savename'] = "./_covid/qr_$id_prueba.png";
      $this->ciqrcode->generate($params);
      $data['qr'] = "qr_$id_prueba.png";
      $datos = array(
        'qr_token' => $claveAleatoria
      );
      $this->covid_model->actualizar($datos, $id_prueba);
    }
    else{
      $data['qr'] = "qr_$id_prueba.png";
    }
    $data['covid'] = $prueba;
    //$data['laboratorio'] = $this->area_model->getArea('COVID');
    $html = $this->load->view('pdfs/digital_pcr_pdf',$data,TRUE);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->SetHTMLHeader('<div style="width: 100%; float: left;"><img style="height: 150px;" src="'.base_url().'img/Encabezado.png"></div>');
    $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 12px;"><div style="border-bottom:1px solid gray;"><b>Teléfono:</b> (33) 2301-8599 | <b>Correo:</b> hola@rodi.com.mx | <b>Sitio web:</b> rodi.com.mx</div><br>Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco, México. C.P. 45018</p></div><div style="position: absolute; right: 10px;  bottom: 13px;"><img width="" src="'.base_url().'img/logo_pie.png"></div>');
    $mpdf->WriteHTML($html);
    $mpdf->Output($prueba->orden.'.pdf','D'); 
  }
  function createPCRDigitalENPDF(){
    $mpdf = new \Mpdf\Mpdf();
    date_default_timezone_set('America/Mexico_City');
    $data['hoy'] = date("d-m-Y");
    $hoy = date("d-m-Y");
    $id_prueba = $_POST['idENDigital'];
    $prueba = $this->covid_model->getDatosPrueba($id_prueba); 
    if($prueba->qr_token == NULL){
      $this->load->library('ciqrcode');
      //QR de consulta
      $claveAleatoria = substr( md5(microtime()), 1, 16);
      $params['data'] = 'https://test-result.rodi.com.mx/covid/covid.php?uid='.$claveAleatoria;
      $params['level'] = 'H';
      $params['size'] = 10;
      $params['savename'] = "./_covid/qr_$id_prueba.png";
      $this->ciqrcode->generate($params);
      $data['qr'] = "qr_$id_prueba.png";
      $datos = array(
        'qr_token' => $claveAleatoria
      );
      $this->covid_model->actualizar($datos, $id_prueba);
    }
    else{
      $data['qr'] = "qr_$id_prueba.png";
    }
    $data['covid'] = $prueba;
    //$data['laboratorio'] = $this->area_model->getArea('COVID');
    $html = $this->load->view('pdfs/digital_pcr_ingles_pdf',$data,TRUE);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->SetHTMLHeader('<div style="width: 100%; float: left;"><img style="height: 150px;" src="'.base_url().'img/Encabezado.png"></div>');
    $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 12px;"><div style="border-bottom:1px solid gray;"><b>Teléfono:</b> (33) 2301-8599 | <b>Correo:</b> hola@rodi.com.mx | <b>Sitio web:</b> rodi.com.mx</div><br>Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco, México. C.P. 45018</p></div><div style="position: absolute; right: 10px;  bottom: 13px;"><img width="" src="'.base_url().'img/logo_pie.png"></div>');
    $mpdf->WriteHTML($html);
    $mpdf->Output($prueba->orden.'_english.pdf','D'); 
  }
}