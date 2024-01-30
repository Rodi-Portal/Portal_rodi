<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacion extends CI_Controller{

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}

  function alertaNuevoCandidato(){
    $Pusher_Opciones = array(
      //"scheme" => "http",
      //"host" => "tudominio.com", //"The HOST option overrides the CLUSTER option!"
      //"port" => 80,
      //"timeout" => 30,
      //
    "encrypted" => false,
      //"cluster" => "mt1",
      //"curl_options" => array(
          //CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4
      //)
    );

    $options = array(
      'cluster' => 'mt1',
      'useTLS' => true,
      "encrypted" => false,
    );
    $pusher = new Pusher\Pusher(
      '1c1dc3822919195c87be',
      'aebe2c78bb647fffeb02',
      '1561704',
      $options
    );
    
    $Mi_Info = array(
      "notificacion" => $this->input->post('mensaje'),
      "timestamp" => time()
    );

    //$data['message'] = 'hello world';
    $pusher->trigger('rodicontrol-channel', 'my-event', $Mi_Info);
  }

  function marcar_visto(){
    $id = $this->input->post('id');
    $date = date('Y-m-d H:i:s');
    $id_usuario = $this->session->userdata('id');
    $data = array(
      'visto' => 1,
      'edicion' => date('Y-m-d H:i:s')
    );
    $this->notificacion_model->update($data, $id);
    $contador = $this->notificacion_model->get_by_usuario($id_usuario, [0]);
    if(!empty($contador)){
      echo count($contador);
    }
    else{
      echo $contador = 0;
    }
  }
  // function get_by_usuario(){
  //   $id_usuario = $this->session->userdata('id');
  //   $notificaciones = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0,1]);
  //   if(!empty($notificaciones)){
  //     $contador = 0;
  //     foreach($notificaciones as $row){
  //       $fechaCreacion = fechaTexto($row->creacion,'espanol');
  //       if($row->visto == 0){
  //         $contador++;
  //       }
  //       $notificacionArray[] = [
  //         'id' => $row->id,
  //         'titulo' => $row->titulo,
  //         'mensaje' => $row->mensaje,
  //         'visto' => $row->visto,
  //         'fechaCreacion' => $fechaCreacion,
  //       ];
  //     }
  //     $data['notificaciones'] = $notificacionArray;
  //     $data['contadorNotificaciones'] = $contador;
  //     echo json_encode($data);
  //   }
  //   else{
  //     $data['contadorNotificaciones'] = $contador;
  //     echo json_encode($data);
  //   }
  // }

  function get_by_usuario(){
    $id_usuario = $this->session->userdata('id');
    $notificaciones = $this->notificacion_model->get_by_usuario($this->session->userdata('id'), [0,1]);
    if(!empty($notificaciones)){
      $contador = 0; $html = '';
      foreach($notificaciones as $row){
        $fechaCreacion = fechaTexto($row->creacion,'espanol');
        $colorNotificacion = ($row->visto == 0)? '#c7eafc' : 'transparent'; 
        $iconoNotificacion = ($row->visto == 0)? '<i class="fas fa-exclamation text-white"></i>' : '<i class="fas fa-check text-white"></i>';
        $fondoIconoNotificacion = ($row->visto == 0)? 'bg-warning' : 'bg-primary';
        if($row->visto == 0){
          $contador++;
        }
        // $notificacionArray[] = [
        //   'id' => $row->id,
        //   'titulo' => $row->titulo,
        //   'mensaje' => $row->mensaje,
        //   'visto' => $row->visto,
        //   'fechaCreacion' => $fechaCreacion,
        // ];
        $html .= '<a class="dropdown-item d-flex align-items-center notificacion" data-id="'.$row->id.'" data-visto="'.$row->visto.'" id="mensaje'.$row->id.'" style="background-color:'.$colorNotificacion.'" href="#"><div class="mr-3"><div class="icon-circle '.$fondoIconoNotificacion.'" id="icono'.$row->id.'">'.$iconoNotificacion.'</div></div><div><div class="small text-gray-800">'.$fechaCreacion.'</div><span class="font-weight-bold"> '.$row->mensaje.' </span></div></a>';
      }
      $data['notificaciones'] = $html;
      $data['contadorNotificaciones'] = $contador;
      echo json_encode($data);
    }
    else{
      $data['contadorNotificaciones'] = $contador;
      echo json_encode($data);
    }
  }

}