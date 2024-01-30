<?php 
class Custom_Controller extends CI_Controller {
  function registrar_avance_candidato($idCandidato, $seccionAvanzada) {
    $date = date('Y-m-d H:i:s');
    $result = $this->candidato_avance_model->getBySeccion($idCandidato,$seccionAvanzada);
    if(!empty($result)){
      $avance = array(
        'fecha' => $date
      );
      $this->candidato_avance_model->update($avance, $idCandidato, $seccionAvanzada);
    }else{
      $avance = array(
        'id_candidato' => $idCandidato,
        'seccion' => $seccionAvanzada,
        'fecha' => $date
      );
      $this->candidato_avance_model->store($avance);
    }
  }
  function registrar_mensaje_avance($idCandidato, $mensaje){
    $date = date('Y-m-d H:i:s');
    $nuevoAvance = array(
      'creacion' => $date,
      'edicion' => $date,
      'id_usuario' => 0,
      'id_candidato' => $idCandidato,
      'fecha_solicitud' => $date,
    );
    $idMensaje = $this->avance_model->store($nuevoAvance);
    $avanceDetalle = array(
      'id_avance' => $idMensaje,
      'fecha' => $date,
      'comentarios' => $mensaje,
      'adjunto' => '',
    );
    $this->avance_model->store_detalles($avanceDetalle);
  }
  function correo_cliente_candidato_finalizado($idCandidato){
    $date = date('Y-m-d H:i:s');
    $candidato = $this->candidato_model->getById($idCandidato);
    if($candidato->privacidad == 0){
      $nivelesPrivacidadCliente = [0,1];
    }
    else{
      $nivelesPrivacidadCliente = [$candidato->privacidad];
    }
    $usuarios = $this->usuario_model->get_usuarios_by_candidato_privacidad($idCandidato, $nivelesPrivacidadCliente);
    if($usuarios){
      foreach($usuarios as $usuario){
        $from = $this->config->item('smtp_user');
        $to = $usuario->correo;
        $subject = "Proceso del candidato finalizado - RODI";
        $data['usuario'] = $usuario->nombreUsuario;
        $data['candidato'] = $usuario->candidato;
        //$message = "EL proceso de " . strtoupper($usuario->candidato) . " ha finalizado y ya puedes descargar el reporte en la plataforma: rodicontrol.rodi.com.mx";
        $message = $this->load->view('mails/candidato_finalizado',$data,TRUE);
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        $mail->isSMTP();
        $mail->Host     = 'mail.rodicontrol.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rodicontrol@rodicontrol.com';
        $mail->Password = 'r49o*&rUm%91';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;
        $mail->setFrom('rodicontrol@rodicontrol.com', 'Mensaje automatico de RODICONTROL');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Body = $message;
        $mail->send();
      }
    }

  }
  function registrar_notificacion($usuarios, $titulo, $mensaje){
    $date = date('Y-m-d H:i:s');
    foreach($usuarios as $usuario){
      $data = array(
        'titulo' => $titulo,
        'mensaje' => $mensaje,
        'usuario_destino' => $usuario,
        'creacion' => $date,
        'edicion' => $date,
      );
      $this->notificacion_model->store($data);
    }
  }
}
