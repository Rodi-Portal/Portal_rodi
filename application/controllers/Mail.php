<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller{

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('id')){
      redirect('Login/index');
    }
		$this->load->library('usuario_sesion');
		$this->usuario_sesion->checkStatusBD();
	}


  function reenviarPassword(){
    date_default_timezone_set('America/Mexico_City');
    $date = date('Y-m-d H:i:s');
    $id_candidato = $this->input->post('id_candidato');
    $data_candidato = $this->candidato_model->getById($id_candidato);
    $cliente = $this->cat_cliente_model->getById($data_candidato->id_cliente);
    
    $base = 'k*jJlrsH:cY]O^Z^/J2)Pz{)qz:+yCa]^+V0S98Zf$sV[c@hKKG07Q{utg%OlODS';
    $aux = substr( md5(microtime()), 1, 8);
    $token = md5($aux.$base);
    $this->candidato_model->regenerarPassword($id_candidato, $date, $token);

    $from = $this->config->item('smtp_user');
    $to = $data_candidato->correo;
    $subject = "Hiring process or change of work project in ".strtoupper($cliente->nombre);
    $datos['password'] = $aux;
    $datos['cliente'] = strtoupper($cliente->nombre);
    $datos['email'] = $data_candidato->correo;
    $message = $this->load->view('mails/credenciales_candidato',$datos,TRUE);
    $this->load->library('phpmailer_lib');
    $mail = $this->phpmailer_lib->load();
    $mail->isSMTP();
    $mail->Host     = 'mail.rodicontrol.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'rodicontrol@rodicontrol.com';
    $mail->Password = 'r49o*&rUm%91';
    $mail->SMTPSecure = 'ssl';
    $mail->Port     = 465;
    $mail->CharSet     = 'utf-8';
    
    $mail->setFrom('rodicontrol@rodicontrol.com', 'RODI');
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->isHTML(true);
    $mailContent = $message;
    $mail->Body = $mailContent;
    if($mail->send()){
      $msj = array(
        'codigo' => 1,
        'msg' => 'Candidato registrado y credenciales enviadas',
        'credenciales' => 'Copia las siguientes credenciales del candidato por si se llegan a necesitar: <br><li>'. $data_candidato->correo .'</li><li>'.$aux.'</li>'
      );
    }
    else{
      $msj = array(
        'codigo' => 0,
        'msg' => 'Candidato registrado sin envío de credenciales',
        'credenciales' => 'Copia las siguientes credenciales del candidato por si se llegan a necesitar: <br><li>'. $data_candidato->correo .'</li><li>'.$aux.'</li>'
      );
    }
    echo json_encode($msj);
  }
}