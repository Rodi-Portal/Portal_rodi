<?php
defined('BASEPATH') or exit('No direct script access allowed');
function handleNull($value)
{
    return isset($value) ? $value : '';
}

class Candidato_Conclusion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('Login/index');
        }
        $this->load->library('usuario_sesion');
        $this->usuario_sesion->checkStatusBD();
    
    }

    /*----------------------------------------*/
    /*  #Finalizado
    /*----------------------------------------*/
    public function getFinalizadoById()
    {
        $res = $this->candidato_conclusion_model->getFinalizadoById($this->input->post('id'));
        if ($res != null) {
            echo json_encode($res);
        } else {
            echo $res = 0;
        }
    }
    public function setFinalizar()
    {
        $id_candidato = $this->input->post('id_candidato');
        $seccion = $this->candidato_seccion_model->getSecciones($id_candidato);
        if ($seccion->tipo_conclusion == 9) {
            $this->form_validation->set_rules('comentario', 'Conclusión', 'required|trim');
            $this->form_validation->set_rules('estatus', 'Estatus final', 'required|trim');

            $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

            $msj = array();
            if ($this->form_validation->run() == false) {
                $msj = array(
                    'codigo' => 0,
                    'msg' => validation_errors(),
                );
            } else {
                date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
                $id_candidato = $this->input->post('id_candidato');
                $id_usuario = $this->session->userdata('id');

                $this->candidato_model->eliminarBGC($id_candidato);
                $bgc = array(
                    'creacion' => $date,
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'id_candidato' => $id_candidato,
                    'comentario_final' => $this->input->post('comentario'),
                );
                $this->candidato_conclusion_model->addBGC($bgc);
                $this->candidato_conclusion_model->setBGC($this->input->post('estatus'), $id_candidato);
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'success',
                );
            }
        }
        if ($seccion->tipo_conclusion == 8) {
            $this->form_validation->set_rules('check_identidad', 'Estatus identidad', 'required|trim');
            $this->form_validation->set_rules('check_laboral', 'Estatus laboral', 'required|trim');
            $this->form_validation->set_rules('check_estudios', 'Estatus estudios', 'required|trim');
            $this->form_validation->set_rules('check_penales', 'Estatus criminal', 'required|trim');
            $this->form_validation->set_rules('check_ofac', 'Estatus OFAC', 'required|trim');
            $this->form_validation->set_rules('check_global', 'Estatus global search', 'required|trim');
            $this->form_validation->set_rules('comentario_final', 'Comentario final', 'required|trim');
            $this->form_validation->set_rules('bgc_status', 'Estatus final', 'required|trim');

            $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

            $msj = array();
            if ($this->form_validation->run() == false) {
                $msj = array(
                    'codigo' => 0,
                    'msg' => validation_errors(),
                );
            } else {
                date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
                $id_candidato = $this->input->post('id_candidato');
                $id_usuario = $this->session->userdata('id');

                $this->candidato_model->eliminarBGC($id_candidato);
                $bgc = array(
                    'creacion' => $date,
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'id_candidato' => $id_candidato,
                    'identidad_check' => $this->input->post('check_identidad'),
                    'empleo_check' => $this->input->post('check_laboral'),
                    'estudios_check' => $this->input->post('check_estudios'),
                    'penales_check' => $this->input->post('check_penales'),
                    'ofac_check' => $this->input->post('check_ofac'),
                    'global_searches_check' => $this->input->post('check_global'),
                    'comentario_final' => $this->input->post('comentario_final'),
                );
                $this->candidato_model->guardarBGC($bgc);
                $this->candidato_model->statusBGCCandidato($this->input->post('bgc_status'), $id_candidato);
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'success',
                );
            }
        }
        if ($seccion->tipo_conclusion == 0 || $seccion->tipo_conclusion == 1 || $seccion->tipo_conclusion == 2 || $seccion->tipo_conclusion == 3 || $seccion->tipo_conclusion == 4 || $seccion->tipo_conclusion == 5 || $seccion->tipo_conclusion == 6 || $seccion->tipo_conclusion == 7 || $seccion->tipo_conclusion == 10 || $seccion->tipo_conclusion == 14 || $seccion->tipo_conclusion == 15 || $seccion->tipo_conclusion == 17 || $seccion->tipo_conclusion == 19 || $seccion->tipo_conclusion == 21) {
            if ($seccion->tipo_conclusion == 0) {
                date_default_timezone_set('America/Mexico_City');
                $date = date('Y-m-d H:i:s');
                $id_usuario = $this->session->userdata('id');

                $hayId = $this->candidato_conclusion_model->checkFinalizado($id_candidato);
                if ($hayId > 0) {
                    $finalizado = array(
                        'id_usuario' => $id_usuario,
                        'recomendable' => 0,
                    );
                    $this->candidato_conclusion_model->editFinalizado($finalizado, $id_candidato);
                    $this->candidato_conclusion_model->setBGC(0, $id_candidato);
                } else {
                    $finalizado = array(
                        'creacion' => $date,
                        'id_usuario' => $id_usuario,
                        'id_candidato' => $id_candidato,
                        'recomendable' => 0,
                    );
                    $this->candidato_conclusion_model->addFinalizado($finalizado);
                    $this->candidato_conclusion_model->setBGC(0, $id_candidato);

                    $data['usuarios_cliente'] = $this->cat_cliente_model->getUsuariosClientePorCandidato($id_candidato);
                    $data['usuarios_subcliente'] = $this->cat_subclientes_model->getUsuariosSubclientePorCandidato($id_candidato);
                    if ($data['usuarios_cliente']) {
                        foreach ($data['usuarios_cliente'] as $cliente) {
                            $from = $this->config->item('smtp_user');
                            $to = $cliente->correo;
                            $subject = "RODI - Proceso finalizado del candidato: " . $cliente->candidato;
                            $datos['candidato'] = $cliente->candidato;
                            $message = $this->load->view('correos/proceso_finalizado_espanol', $datos, true);

                            $this->load->library('phpmailer_lib');
                            $mail = $this->phpmailer_lib->load();
                            $mail->isSMTP();
                            $mail->Host = 'mail.rodicontrol.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'rodicontrol@rodicontrol.com';
                            $mail->Password = 'r49o*&rUm%91';
                            $mail->SMTPSecure = 'ssl';
                            $mail->Port = 465;
                            $mail->setFrom('rodicontrol@rodicontrol.com', 'RODICONTROL');
                            $mail->addAddress($to);
                            $mail->Subject = $subject;
                            $mail->isHTML(true);
                            $mailContent = $message;
                            $mail->Body = $mailContent;
                            $mail->send();
                        }
                    }
                    if ($data['usuarios_subcliente']) {
                        foreach ($data['usuarios_subcliente'] as $subcliente) {
                            $from = $this->config->item('smtp_user');
                            $to = $subcliente->correo;
                            $subject = "RODI - Proceso finalizado del candidato: " . $subcliente->candidato;
                            $datos['candidato'] = $subcliente->candidato;
                            $message = $this->load->view('correos/proceso_finalizado_espanol', $datos, true);

                            $this->load->library('phpmailer_lib');
                            $mail = $this->phpmailer_lib->load();
                            $mail->isSMTP();
                            $mail->Host = 'mail.rodicontrol.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'rodicontrol@rodicontrol.com';
                            $mail->Password = 'r49o*&rUm%91';
                            $mail->SMTPSecure = 'ssl';
                            $mail->Port = 465;
                            $mail->setFrom('rodicontrol@rodicontrol.com', 'RODICONTROL');
                            $mail->addAddress($to);
                            $mail->Subject = $subject;
                            $mail->isHTML(true);
                            $mailContent = $message;
                            $mail->Body = $mailContent;
                            $mail->send();
                        }
                    }
                }
                $msj = array(
                    'codigo' => 1,
                    'msg' => 'success',
                );
            } else {
                if ($seccion->tipo_conclusion == 1) {
                    $this->form_validation->set_rules('personal1', 'Primera descripción', 'required|trim');
                    $this->form_validation->set_rules('personal2', 'Segunda descripción', 'required|trim');
                    $this->form_validation->set_rules('personal3', 'Tercera descripción', 'required|trim');
                    $this->form_validation->set_rules('personal4', 'Cuarta descripción', 'required|trim');
                    $this->form_validation->set_rules('laboral1', 'Número de referencias laborales señaladas', 'required|trim');
                    $this->form_validation->set_rules('laboral2', 'Descripción de las referencias laborales', 'required|trim');
                    $this->form_validation->set_rules('socio1', 'Primera conclusión', 'required|trim');
                    $this->form_validation->set_rules('socio2', 'Segunda conclusión', 'required|trim');
                    $this->form_validation->set_rules('visita1', 'Conclusiones del visitador', 'required|trim');
                    $this->form_validation->set_rules('visita2', 'Conclusiones de la referencia vecinal', 'required|trim');
                    $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
                }
                if ($seccion->tipo_conclusion == 2) {
                    $this->form_validation->set_rules('personal1', 'Primera descripción', 'required|trim');
                    $this->form_validation->set_rules('personal2', 'Segunda descripción', 'required|trim');
                    $this->form_validation->set_rules('personal4', 'Cuarta descripción', 'required|trim');
                    $this->form_validation->set_rules('laboral2', 'Descripción de las referencias laborales', 'required|trim');
                    $this->form_validation->set_rules('socio1', 'Primera conclusión', 'required|trim');
                    $this->form_validation->set_rules('socio2', 'Segunda conclusión', 'required|trim');
                    $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
                    $this->form_validation->set_rules('comentario', 'Comentario de cambios del estatus final del estudio', 'trim');
                }
                if ($seccion->tipo_conclusion == 3) {
                    //$this->form_validation->set_rules('comentario', 'Comentario del estatus final del estudio', 'required|trim');
                    $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
                }
                if ($seccion->tipo_conclusion == 4) {
                    $this->form_validation->set_rules('personal1', 'Primera descripción', 'required|trim');
                    $this->form_validation->set_rules('laboral1', 'Número de referencias laborales señaladas', 'required|trim');
                    $this->form_validation->set_rules('laboral2', 'Descripción de las referencias laborales', 'required|trim');
                    $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
                }
                if ($seccion->tipo_conclusion == 5) {
                    $this->form_validation->set_rules('personal1', 'Primera descripción', 'required|trim');
                    $this->form_validation->set_rules('personal2', 'Segunda descripción', 'required|trim');
                    $this->form_validation->set_rules('personal3', 'Tercera descripción', 'required|trim');
                    $this->form_validation->set_rules('personal4', 'Cuarta descripción', 'required|trim');
                    $this->form_validation->set_rules('laboral1', 'Número de referencias laborales señaladas', 'required|trim');
                    $this->form_validation->set_rules('laboral2', 'Descripción de las referencias laborales', 'required|trim');
                    $this->form_validation->set_rules('socio2', 'Segunda conclusión', 'required|trim');
                    $this->form_validation->set_rules('visita1', 'Conclusiones del visitador', 'required|trim');
                    $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
                }
                if ($seccion->tipo_conclusion == 6) {
                    $this->form_validation->set_rules('personal1', 'Primera descripción', 'required|trim');
                    $this->form_validation->set_rules('personal2', 'Segunda descripción', 'required|trim');
                    $this->form_validation->set_rules('personal3', 'Tercera descripción', 'required|trim');
                    $this->form_validation->set_rules('personal4', 'Cuarta descripción', 'required|trim');
                    $this->form_validation->set_rules('laboral1', 'Número de referencias laborales señaladas', 'required|trim');
                    $this->form_validation->set_rules('laboral2', 'Descripción de las referencias laborales', 'required|trim');
                    $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
                }
                if ($seccion->tipo_conclusion == 7) {
                    $this->form_validation->set_rules('personal1', 'Primera descripción', 'required|trim');
                    $this->form_validation->set_rules('personal2', 'Segunda descripción', 'required|trim');
                    $this->form_validation->set_rules('laboral1', 'Número de referencias laborales señaladas', 'required|trim');
                    $this->form_validation->set_rules('laboral2', 'Descripción de las referencias laborales', 'required|trim');
                    $this->form_validation->set_rules('socio1', 'Primera conclusión', 'required|trim');
                    $this->form_validation->set_rules('socio2', 'Segunda conclusión', 'required|trim');
                    $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
                }
                if ($seccion->tipo_conclusion == 10) {
                    $this->form_validation->set_rules('personal1', 'Primera descripción', 'required|trim');
                    $this->form_validation->set_rules('personal2', 'Segunda descripción', 'required|trim');
                    $this->form_validation->set_rules('laboral2', 'Descripción de las referencias laborales', 'required|trim');
                    $this->form_validation->set_rules('socio1', 'Primera conclusión', 'required|trim');
                    $this->form_validation->set_rules('socio2', 'Segunda conclusión', 'required|trim');
                    $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
                }
                if ($seccion->tipo_conclusion == 14) {
                    $this->form_validation->set_rules('personal1', 'Primera descripción', 'required|trim');
                    $this->form_validation->set_rules('personal2', 'Segunda descripción', 'required|trim');
                    $this->form_validation->set_rules('personal3', 'Tercera descripción', 'required|trim');
                    $this->form_validation->set_rules('laboral2', 'Descripción de las referencias laborales', 'required|trim');
                    $this->form_validation->set_rules('socio1', 'Primera conclusión', 'required|trim');
                    $this->form_validation->set_rules('socio2', 'Segunda conclusión', 'required|trim');
                    $this->form_validation->set_rules('visita1', 'Conclusiones del visitador', 'required|trim');
                    $this->form_validation->set_rules('visita2', 'Conclusiones de la referencia vecinal', 'required|trim');
                    $this->form_validation->set_rules('investigacion', 'Conclusión del proceso de estudio de investigación', 'required|trim');
                    //$this->form_validation->set_rules('comentario', 'Comentario del estatus final del estudio', 'required|trim');
                    $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
                }
                if ($seccion->tipo_conclusion == 15) {
                    $this->form_validation->set_rules('personal1', 'Primera descripción', 'required|trim');
                    $this->form_validation->set_rules('personal2', 'Segunda descripción', 'required|trim');
                    $this->form_validation->set_rules('laboral2', 'Descripción de las referencias laborales', 'required|trim');
                    $this->form_validation->set_rules('investigacion', 'Conclusión del proceso de estudio de investigación', 'required|trim');
                    //$this->form_validation->set_rules('comentario', 'Comentario del estatus final del estudio', 'required|trim');
                    $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
                }
                if ($seccion->tipo_conclusion == 17) {
                    $this->form_validation->set_rules('comentario', 'Comentario del estatus final del estudio', 'required|trim');
                    $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
                }
                if ($seccion->tipo_conclusion == 19) {
                    $this->form_validation->set_rules('personal1', 'Primera descripción', 'required|trim');
                    $this->form_validation->set_rules('personal2', 'Segunda descripción', 'required|trim');
                    $this->form_validation->set_rules('laboral1', 'Número de referencias laborales señaladas', 'required|trim');
                    $this->form_validation->set_rules('laboral2', 'Descripción de las referencias laborales', 'required|trim');
                    $this->form_validation->set_rules('socio1', 'Primera conclusión', 'required|trim');
                    $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
                }
                if ($seccion->tipo_conclusion == 21) {
                    $this->form_validation->set_rules('personal1', 'Primera descripción', 'required|trim');
                    $this->form_validation->set_rules('personal2', 'Segunda descripción', 'required|trim');
                    $this->form_validation->set_rules('laboral2', 'Descripción de las referencias laborales', 'required|trim');
                    $this->form_validation->set_rules('socio2', 'Segunda conclusión', 'required|trim');
                    $this->form_validation->set_rules('investigacion', 'Conclusión del proceso de estudio de investigación', 'required|trim');
                    $this->form_validation->set_rules('recomendable', 'De acuerdo a lo anterior, la persona investigada es considerada', 'required|trim');
                }
                $this->form_validation->set_message('required', 'El campo {field} es obligatorio');
                $this->form_validation->set_message('numeric', 'El campo {field} debe ser numérico');

                $msj = array();
                if ($this->form_validation->run() == false) {
                    $msj = array(
                        'codigo' => 0,
                        'msg' => validation_errors(),
                    );
                } else {
                    date_default_timezone_set('America/Mexico_City');
                    $date = date('Y-m-d H:i:s');
                    $id_usuario = $this->session->userdata('id');

                    $hayId = $this->candidato_conclusion_model->checkFinalizado($id_candidato);
                    if ($hayId > 0) {
                        $finalizado = array(
                            'id_usuario' => $id_usuario,
                            'descripcion_personal1' => $this->input->post('personal1'),
                            'descripcion_personal2' => $this->input->post('personal2'),
                            'descripcion_personal3' => $this->input->post('personal3'),
                            'descripcion_personal4' => $this->input->post('personal4'),
                            'descripcion_laboral1' => $this->input->post('laboral1'),
                            'descripcion_laboral2' => $this->input->post('laboral2'),
                            'descripcion_socio1' => $this->input->post('socio1'),
                            'descripcion_socio2' => $this->input->post('socio2'),
                            'descripcion_visita1' => $this->input->post('visita1'),
                            'descripcion_visita2' => $this->input->post('visita2'),
                            'conclusion_investigacion' => $this->input->post('investigacion'),
                            'recomendable' => $this->input->post('recomendable'),
                            'comentario' => $this->input->post('comentario'),
                        );
                        $this->candidato_conclusion_model->editFinalizado($finalizado, $id_candidato);
                        $this->candidato_conclusion_model->setBGC($this->input->post('recomendable'), $id_candidato);
                    } else {
                        $finalizado = array(
                            'creacion' => $date,
                            'id_usuario' => $id_usuario,
                            'id_candidato' => $id_candidato,
                            'descripcion_personal1' => $this->input->post('personal1'),
                            'descripcion_personal2' => $this->input->post('personal2'),
                            'descripcion_personal3' => $this->input->post('personal3'),
                            'descripcion_personal4' => $this->input->post('personal4'),
                            'descripcion_laboral1' => $this->input->post('laboral1'),
                            'descripcion_laboral2' => $this->input->post('laboral2'),
                            'descripcion_socio1' => $this->input->post('socio1'),
                            'descripcion_socio2' => $this->input->post('socio2'),
                            'descripcion_visita1' => $this->input->post('visita1'),
                            'descripcion_visita2' => $this->input->post('visita2'),
                            'conclusion_investigacion' => $this->input->post('investigacion'),
                            'recomendable' => $this->input->post('recomendable'),
                            'comentario' => $this->input->post('comentario'),
                        );
                        $this->candidato_conclusion_model->addFinalizado($finalizado);
                        $this->candidato_conclusion_model->setBGC($this->input->post('recomendable'), $id_candidato);

                        // $data['usuarios_cliente'] = $this->cat_cliente_model->getUsuariosClientePorCandidato($id_candidato);
                        // $data['usuarios_subcliente'] = $this->cat_subclientes_model->getUsuariosSubclientePorCandidato($id_candidato);
                        // if($data['usuarios_cliente']){
                        //   foreach($data['usuarios_cliente'] as $cliente){
                        //     if(($cliente->privacidadCliente == 0 || $cliente->privacidadCliente == 1) && !empty($cliente->privacidadCliente)){
                        //       $from = $this->config->item('smtp_user');
                        //       $to = $cliente->correo;
                        //       $subject = "RODI - Proceso finalizado del candidato: ".$cliente->candidato;
                        //       $datos['candidato'] = $cliente->candidato;
                        //       $message = $this->load->view('correos/proceso_finalizado_espanol',$datos,TRUE);

                        //       $this->load->library('phpmailer_lib');
                        //       $mail = $this->phpmailer_lib->load();
                        //       $mail->isSMTP();
                        //       $mail->Host     = 'mail.rodicontrol.com';
                        //       $mail->SMTPAuth = true;
                        //       $mail->Username = 'rodicontrol@rodicontrol.com';
                        //       $mail->Password = 'r49o*&rUm%91';
                        //       $mail->SMTPSecure = 'ssl';
                        //       $mail->Port     = 465;
                        //       $mail->setFrom('rodicontrol@rodicontrol.com', 'RODICONTROL');
                        //       $mail->addAddress($to);
                        //       $mail->Subject = $subject;
                        //       $mail->isHTML(true);
                        //       $mailContent = $message;
                        //       $mail->Body = $mailContent;
                        //       $mail->send();
                        //     }
                        //     else{
                        //       if(($cliente->privacidadCliente == $cliente->privacidadCandidato) && !empty($cliente->privacidadCliente)){
                        //         $from = $this->config->item('smtp_user');
                        //         $to = $cliente->correo;
                        //         $subject = "RODI - Proceso finalizado del candidato: ".$cliente->candidato;
                        //         $datos['candidato'] = $cliente->candidato;
                        //         $message = $this->load->view('correos/proceso_finalizado_espanol',$datos,TRUE);

                        //         $this->load->library('phpmailer_lib');
                        //         $mail = $this->phpmailer_lib->load();
                        //         $mail->isSMTP();
                        //         $mail->Host     = 'mail.rodicontrol.com';
                        //         $mail->SMTPAuth = true;
                        //         $mail->Username = 'rodicontrol@rodicontrol.com';
                        //         $mail->Password = 'r49o*&rUm%91';
                        //         $mail->SMTPSecure = 'ssl';
                        //         $mail->Port     = 465;
                        //         $mail->setFrom('rodicontrol@rodicontrol.com', 'RODICONTROL');
                        //         $mail->addAddress($to);
                        //         $mail->Subject = $subject;
                        //         $mail->isHTML(true);
                        //         $mailContent = $message;
                        //         $mail->Body = $mailContent;
                        //         $mail->send();
                        //       }
                        //     }
                        //   }
                        // }
                        // if($data['usuarios_subcliente']){
                        //   foreach($data['usuarios_subcliente'] as $subcliente){
                        //     $from = $this->config->item('smtp_user');
                        //     $to = $subcliente->correo;
                        //     $subject = "RODI - Proceso finalizado del candidato: ".$subcliente->candidato;
                        //     $datos['candidato'] = $subcliente->candidato;
                        //     $message = $this->load->view('correos/proceso_finalizado_espanol',$datos,TRUE);

                        //     $this->load->library('phpmailer_lib');
                        //     $mail = $this->phpmailer_lib->load();
                        //     $mail->isSMTP();
                        //     $mail->Host     = 'mail.rodicontrol.com';
                        //     $mail->SMTPAuth = true;
                        //     $mail->Username = 'rodicontrol@rodicontrol.com';
                        //     $mail->Password = 'r49o*&rUm%91';
                        //     $mail->SMTPSecure = 'ssl';
                        //     $mail->Port     = 465;
                        //     $mail->setFrom('rodicontrol@rodicontrol.com', 'RODICONTROL');
                        //     $mail->addAddress($to);
                        //     $mail->Subject = $subject;
                        //     $mail->isHTML(true);
                        //     $mailContent = $message;
                        //     $mail->Body = $mailContent;
                        //     $mail->send();
                        //   }
                        // }

                    }
                    // //* Se crear y almacena el reporte final PDF
                    // $this->createPDF($id_candidato);
                    $msj = array(
                        'codigo' => 1,
                        'msg' => 'success',
                    );
                }
            }
        }
        echo json_encode($msj);
    }
    public function setConclusion()
    {
        $id_candidato = $this->input->post('id_candidato');
        $this->form_validation->set_rules('comentario', 'Comentario de cambios del estatus final del estudio', 'trim');
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        }

        date_default_timezone_set('America/Mexico_City');
        $date = date('Y-m-d H:i:s');
        $id_usuario = $this->session->userdata('id');

        $hayId = $this->candidato_conclusion_model->checkFinalizado($id_candidato);
        if ($hayId > 0) {
            $finalizado = array(
                'id_usuario' => $id_usuario,
                'comentario' => $this->input->post('comentario'),
            );
            $this->candidato_conclusion_model->editFinalizado($finalizado, $id_candidato);
        } else {
            $finalizado = array(
                'creacion' => $date,
                'id_usuario' => $id_usuario,
                'id_candidato' => $id_candidato,
                'comentario' => $this->input->post('comentario'),
            );
            $this->candidato_conclusion_model->addFinalizado($finalizado);
        }
        $msj = array(
            'codigo' => 1,
            'msg' => 'success',
        );
        echo json_encode($msj);
    }
    public function storeFechaFinalizacion()
    {
        $id_candidato = $this->input->post('id_candidato');
        $date = date('Y-m-d H:i:s');
        $id_usuario = $this->session->userdata('id');
        $finalizado = array(
            'creacion' => $date,
            'id_usuario' => $id_usuario,
            'id_candidato' => $id_candidato,
            'recomendable' => 0,
        );
        $this->candidato_conclusion_model->addFinalizado($finalizado);
        $msj = array(
            'codigo' => 1,
            'msg' => 'success',
        );
        echo json_encode($msj);
    }

    public function createPDF()
    {
        //* Llamada a la libreria de mpdf, iniciación de fechas y captura POST
        $mpdf = new \Mpdf\Mpdf();
        date_default_timezone_set('America/Mexico_City');
        //$id_candidato = $this->input->post('idPDF');
        $id_usuario = $this->session->userdata('id');
        $id_candidato = $_POST['idCandidatoPDF'];

        $url = API_URL . "report/{$id_candidato}";

        $options = [
            "http" => [
                "method" => "GET",
                "header" => "Content-Type: application/json\r\n",
            ],
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        // Decodifica la respuesta JSON

        $data1 = json_decode($response, true);

        // Accede a los datos específicos

        // Utiliza los datos como necesites

        $data = $data1;

        /*

        //* Detalles del candidato en tabla candidato
        $data['info'] = $this->candidato_model->getDetalles($id_candidato);//
        //* Se obtienen los registros de los archivos asignado al candidato
        $data['docs'] = $this->candidato_model->getDocumentacion($id_candidato);
        //* Se obtienen las secciones registradas del candidato de acuerdo al estudio/proceso/proyecto asignado
        $data['secciones'] = $this->candidato_seccion_model->getSecciones($id_candidato);//
        //* Examenes asignados al candidato
        $data['pruebas'] = $this->candidato_model->getExamenes($id_candidato);//
        //* Se obtiene la informacion de doping en caso de asignacion al candidato
        $data['doping'] = $this->candidato_model->getDoping($id_candidato);//
        //* Se obtiene la verificación de documentos de la tabla verificacion_documento
        $data['verDoc'] = $this->candidato_documentacion_model->getById($id_candidato);//
        //* Se obtiene la experiencia academica
        $data['academico'] = $this->candidato_estudio_model->getHistorialById($id_candidato);//
        $data['verMayoresEstudios'] = $this->candidato_estudio_model->getMayorById($id_candidato);//
        $data['verificacionEstudios'] = $this->candidato_estudio_model->getVerificacion($id_candidato);//
        $data['verificacionDetallesEstudios'] = $this->candidato_estudio_model->getDetalleVerificacion($id_candidato);//
        //* Se obtienen los datos sociales
        $data['sociales'] = $this->candidato_social_model->getById($id_candidato);//
        //* Se obtiene la información familiar
        $data['familia'] = $this->candidato_familiar_model->getById($id_candidato);//
        //* Se obtienen los contactos del candidato que laboran en el mismo lugar
        $data['contacto_trabajo'] = $this->candidato_laboral_model->getContactosMismoTrabajo($id_candidato);//
        //* Se obtienen los datos financieros
        $data['finanzas'] = $this->candidato_finanzas_model->getById($id_candidato);//
        //* Se obtiene el historial de empleos
        $data['empleos'] = $this->candidato_laboral_model->getHistorialLaboralById($id_candidato);//
        $data['nom'] = $this->candidato_laboral_model->getNoMencionadosById($id_candidato);//
        $data['laborales'] = $this->candidato_laboral_model->getAntecedentesLaboralesById($id_candidato);//

        $data['contactos'] = $this->candidato_laboral_model->getObservacionesContactoById($id_candidato);//

        $data['verificacionEmpleos'] = $this->candidato_laboral_model->getVerificacion($id_candidato);//
        $data['verificacionDetallesEmpleos'] = $this->candidato_laboral_model->getDetalleVerificacion($id_candidato);//
        //* GAPS o periodos inactivos laborales
        $data['gaps'] = $this->candidato_model->getGAPS($id_candidato);//
        //* Referencias personales
        $data['refPersonal'] = $this->candidato_ref_personal_model->getById($id_candidato);//
        //* Conclusiones de la tabla candidato_finalizado
        $data['finalizado'] = $this->candidato_conclusion_model->getFinalizadoById($id_candidato);//
        $data['conclusion'] = $this->candidato_conclusion_model->getBGCById($id_candidato); //
        //* Informacion de vivienda
        $data['vivienda'] = $this->candidato_vivienda_model->getById($id_candidato);//
        //* Referencias vecinales
        $data['refVecinal'] = $this->candidato_ref_vecinal_model->getById($id_candidato);//
        //* Información de la investigación legal
        $data['legal'] = $this->candidato_model->getInvestigacionLegal($id_candidato);//
        //* Información del estado de salud
        $data['salud'] = $this->candidato_salud_model->getById($id_candidato);//
        //* Información de servicios públicos
        $data['servicios'] = $this->candidato_servicio_model->getById($id_candidato);
        //* Información de historial crediticio
        $data['credito'] = $this->candidato_model->checkCredito($id_candidato);//
        //* Busquedas globales con Refinitiv World check
        $data['global_searches'] = $this->candidato_global_model->getById($id_candidato);//
        //* Verificacion criminal
        $data['verificacionCriminal'] = $this->criminal_model->getVerificacion($id_candidato);//
        $data['verificacionDetallesCriminal'] = $this->criminal_model->getDetalleVerificacion($id_candidato);//
        //* Referencias de clientes
        $data['refClientes'] = $this->referencia_cliente_model->getById($id_candidato);
        //* Empresa de candidato
        $data['empresa'] = $this->candidato_empresa_model->getById($id_candidato);
        //* Referencias academicas
        $data['refAcademicas'] = $this->candidato_ref_academica_model->getById($id_candidato);
        //* Referencias profesionales
        $data['refProfesionales'] = $this->referencia_profesional_model->getById($id_candidato);*/

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    $data[$key][$subKey] = handleNull($subValue);
                }
            } else {
                $data[$key] = handleNull($value);
            }
        }
        /* echo'<pre>';
        //echo $data['sociales']['sindical'];
        print_r($data);
        echo'</pre>';
        die();*/
        // Checar si el cliente en cuestión es en inglés o español
        $idioma = (isset($data['info']['ingles']) && $data['info']['ingles'] == 0) ? 'espanol' : 'ingles';
        $data['idioma'] = $idioma;

        // Revisar si $info->fecha_fin es la fecha edición en lugar de la creación de la finalización del candidato
        if (isset($data['info']['fecha_fin']) && $data['info']['fecha_fin'] != null) {
            $data['fecha_finalizado'] = fechaTexto($data['info']['fecha_fin'], $idioma);
        }
        if (isset($data['info']['fecha_bgc']) && $data['info']['fecha_bgc'] != null) {
            $data['fecha_finalizado'] = fechaTexto($data['info']['fecha_bgc'], $idioma);
        }

        // Extracción de detalles del candidato
        if (isset($data['info']['fecha_fin']) && $data['info']['fecha_fin'] != null) {
            $fecha_fin = formatoFechaEspanol($data['info']['fecha_fin']);
        }
        if (isset($data['info']['fecha_bgc']) && $data['info']['fecha_bgc'] != null) {
            $fecha_fin = formatoFechaEspanol($data['info']['fecha_bgc']);
        }
        if (isset($data['info']['fecha_alta'])) {
            $f_alta = formatoFechaEspanol($data['info']['fecha_alta']);
        }

        //* Filtro de usuario
        /* $tipo_usuario = $this->session->userdata('tipo');
        if($tipo_usuario == 1){
        $usuario = $this->usuario_model->getDatosUsuarioInterno($id_usuario);
        }
        if($tipo_usuario == 2){
        $usuario = $this->usuario_model->getDatosUsuarioCliente($id_usuario);
        }
        if($tipo_usuario == 4){
        $usuario = $this->usuario_model->getDatosUsuarioSubcliente($id_usuario);
        }
         */

        //* Vista PDF del reporte
        $html = $this->load->view('pdfs/reporte_espanol_pdf', $data, true);
        /* echo $html;
        exit;*/
        if ($data['info']['status_bgc'] != 0) {
            //* Configuraciones del mPDF
            $mpdf->setAutoTopMargin = 'stretch';
            $mpdf->AddPage();
            //TODO: Organizar encabezados y pies de pagina de acuerdo al cliente mediante BD
            if ($data['info']['id_cliente'] == 39) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 100px;" src="' . base_url() . 'img/logo_talink.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
            }
            if ($data['info']['id_cliente'] == 7) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 100px;" src="' . base_url() . 'img/logo_gentex.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
            }
            if ($data['info']['id_cliente'] == 16) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="' . base_url() . 'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="' . base_url() . 'img/logo_pie.png"></div>');
            }
            if ($data['info']['id_cliente'] == 159) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="width:130px;height:100px;" src="' . base_url() . 'img/logo_pisa.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">PISA FARMACÉUTICA</p></div><div style="position: absolute; right: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Av. España No. 1840 Colonia Moderna C.P. 44190 Guadalajara, Jalisco. Tel. 33 3678 Fax: 33 3810 Lada sin costo: 800 627</p></div>');
            }
            if ($data['info']['id_cliente'] == 172) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="' . base_url() . 'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Request Date: ' . $f_alta . '<br>Release Date: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="' . base_url() . 'img/logo_pie.png"></div>');
            }
            if ($data['info']['id_cliente'] == 190) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="width:130px;height:70px;" src="' . base_url() . 'img/logo_gesthion.jpg"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
            }
            if ($data['info']['id_cliente'] == 209) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="width:130px;height:70px;" src="' . base_url() . 'img/logo_velazquez.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
            }
            if ($data['info']['id_cliente'] != 7 && $data['info']['id_cliente'] != 16 && $data['info']['id_cliente'] != 39 && $data['info']['id_cliente'] != 159 && $data['info']['id_cliente'] != 172 && $data['info']['id_cliente'] != 190 && $data['info']['id_cliente'] != 209) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="' . base_url() . 'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="' . base_url() . 'img/logo_pie.png"></div>');
            }
        }
        //*Cifrar pdf
        $nombreArchivo = substr(md5(microtime()), 1, 12);
        /*$claveAleatoria = substr( md5(microtime()), 1, 8);
        $clave = ($usuario->clave != null)? $usuario->clave:$claveAleatoria;
        $mpdf->SetProtection(array(), $clave, 'r0d1@');*/
        $mpdf->autoPageBreak = false;
        $mpdf->WriteHTML($html);
        $mpdf->Output('' . $nombreArchivo . '.pdf', 'D');

        // //* Inactivar reportes anteriores en caso de haber
        // $estatus_reporte = array(
        //   'status' => 0
        // );
        // $this->candidato_conclusion_model->setReporte($id_candidato, $estatus_reporte);
        // //* Guardar reporte finalizado en carpeta local _estudios del sistema
        // $dir = set_realpath('./_estudios/'.$data['info']->id."/");
        // if(!is_dir($dir)){
        //   mkdir($dir,0777);
        //   $mpdf->WriteHTML($html);
        //   $mpdf->Output($dir.$nombreArchivo.'.pdf','F');
        //   $archivo = array(
        //     'creacion' =>  date('Y-m-d H:i:s'),
        //     'id_candidato' => $id_candidato,
        //     'archivo' => $nombreArchivo.'.pdf'
        //   );
        //   $this->candidato_conclusion_model->addReporte($archivo);
        // }
        // else{
        //   $mpdf->WriteHTML($html);
        //   $mpdf->Output($dir.$nombreArchivo.'.pdf','F');
        //   $archivo = array(
        //     'creacion' =>  date('Y-m-d H:i:s'),
        //     'id_candidato' => $id_candidato,
        //     'archivo' => $nombreArchivo.'.pdf'
        //   );
        //   $this->candidato_conclusion_model->addReporte($archivo);
        // }

    }
    public function createPrevioPDF()
    {
       
        //* Llamada a la libreria de mpdf, iniciación de fechas y captura POST
        $mpdf = new \Mpdf\Mpdf();
        date_default_timezone_set('America/Mexico_City');
        $id_candidato = $this->input->post('idPDF');
        $id_usuario = $this->session->userdata('id');

        if (!$id_candidato) {
            $id_candidato = $this->input->get('idPDF');
        }

        

        $url = API_URL . "report/{$id_candidato}";

        $options = [
            "http" => [
                "method" => "GET",
                "header" => "Content-Type: application/json\r\n",
            ],
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        // Decodifica la respuesta JSON

        $data1 = json_decode($response, true);

        $data = $data1;

        //* Se checa si el cliente en cuestion es en ingles o espanol
        $idioma = ($data['info']['ingles'] == 0) ? 'espanol' : 'ingles';
        $data['idioma'] = $idioma;
        //? Revisar si $info['fecha_fin'] es la fecha edicion en lugar de la creacion de la finalizacion del candidato
        if ($data['info']['fecha_fin'] != null) {
            $data['fecha_finalizado'] = fechaTexto($data['info']['fecha_fin'], $idioma);
        }
        if ($data['info']['fecha_bgc'] != null) {
            $data['fecha_finalizado'] = fechaTexto($data['info']['fecha_bgc'], $idioma);
        }
        //* Extracción de detalles del candidato
        if ($data['info']['fecha_fin'] != null) {
            $fecha_fin = formatoFechaEspanol($data['info']['fecha_fin']);
        }
        if ($data['info']['fecha_bgc'] != null) {
            $fecha_fin = formatoFechaEspanol($data['info']['fecha_bgc']);
        }
        $f_alta = formatoFechaEspanol($data['info']['fecha_alta']);

        //* Vista PDF del reporte
        $html = $this->load->view('pdfs/reporte_espanol_pdf', $data, true);
        if ($data['info']['status_bgc'] != 0) {
            //* Configuraciones del mPDF
            $mpdf->setAutoTopMargin = 'stretch';
            $mpdf->AddPage();
            //TODO: Organizar encabezados y pies de pagina de acuerdo al cliente mediante BD
            if ($data['info']['id_cliente'] == 39) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 100px;" src="' . base_url() . 'img/logo_talink.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
            }
            if ($data['info']['id_cliente'] == 7) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 100px;" src="' . base_url() . 'img/logo_gentex.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
            }
            if ($data['info']['id_cliente'] == 16) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="' . base_url() . 'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="' . base_url() . 'img/logo_pie.png"></div>');
            }
            if ($data['info']['id_cliente'] == 159) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="width:130px;height:100px;" src="' . base_url() . 'img/logo_pisa.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">PISA FARMACÉUTICA</p></div><div style="position: absolute; right: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Av. España No. 1840 Colonia Moderna C.P. 44190 Guadalajara, Jalisco. Tel. 33 3678 Fax: 33 3810 Lada sin costo: 800 627</p></div>');
            }
            if ($data['info']['id_cliente'] == 172) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="' . base_url() . 'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Request Date: ' . $f_alta . '<br>Release Date: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="' . base_url() . 'img/logo_pie.png"></div>');
            }
            if ($data['info']['id_cliente'] == 190) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="width:130px;height:70px;" src="' . base_url() . 'img/logo_gesthion.jpg"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
            }
            if ($data['info']['id_cliente'] == 209) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="width:130px;height:70px;" src="' . base_url() . 'img/logo_velazquez.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
            }
            if ($data['info']['id_cliente'] != 7 && $data['info']['id_cliente'] != 16 && $data['info']['id_cliente'] != 39 && $data['info']['id_cliente'] != 159 && $data['info']['id_cliente'] != 172 && $data['info']['id_cliente'] != 190 && $data['info']['id_cliente'] != 209) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="' . base_url() . 'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="' . base_url() . 'img/logo_pie.png"></div>');
            }
        }
        //* Cifrar pdf
        $nombreArchivo = substr(md5(microtime()), 1, 12);
        /*$claveAleatoria = substr( md5(microtime()), 1, 8);
        $clave = ($usuario->clave != null)? $usuario->clave:$claveAleatoria;
        $mpdf->SetProtection(array(), $clave, 'r0d1@');*/
        //* Marca de agua
        $mpdf->SetWatermarkImage(base_url() . 'img/marca_agua.png', 0.2, 'P', 'P');
        $mpdf->showWatermarkImage = true;

        $mpdf->autoPageBreak = false;
        $mpdf->WriteHTML($html);
        $mpdf->Output('' . $nombreArchivo . '.pdf', 'D');
    }

    public function recreatePDF()
    {
        //* Llamada a la libreria de mpdf, iniciación de fechas y captura POST
        $mpdf = new \Mpdf\Mpdf();
        date_default_timezone_set('America/Mexico_City');
        $id_candidato = $this->input->post('idPDF');
        $id_usuario = $this->session->userdata('id');

        //* Detalles del candidato en tabla candidato
        $data['info'] = $this->candidato_model->getDetalles($id_candidato);
        //* Se obtienen los registros de los archivos asignado al candidato
        $data['docs'] = $this->candidato_model->getDocumentacion($id_candidato);
        //* Se obtienen las secciones registradas del candidato de acuerdo al estudio/proceso/proyecto asignado
        $data['secciones'] = $this->candidato_seccion_model->getSecciones($id_candidato);
        //* Examenes asignados al candidato
        $data['pruebas'] = $this->candidato_model->getExamenes($id_candidato);
        //* Se obtiene la informacion de doping en caso de asignacion al candidato
        $data['doping'] = $this->candidato_model->getDoping($id_candidato);
        //* Se obtiene la verificación de documentos de la tabla verificacion_documento
        $data['verDoc'] = $this->candidato_documentacion_model->getById($id_candidato);
        //* Se obtiene la experiencia academica
        $data['academico'] = $this->candidato_estudio_model->getHistorialById($id_candidato);
        $data['verMayoresEstudios'] = $this->candidato_estudio_model->getMayorById($id_candidato);
        $data['verificacionEstudios'] = $this->candidato_estudio_model->getVerificacion($id_candidato);
        $data['verificacionDetallesEstudios'] = $this->candidato_estudio_model->getDetalleVerificacion($id_candidato);
        //* Se obtienen los datos sociales
        $data['sociales'] = $this->candidato_social_model->getById($id_candidato);
        //* Se obtiene la información familiar
        $data['familia'] = $this->candidato_familiar_model->getById($id_candidato);
        //* Se obtienen los contactos del candidato que laboran en el mismo lugar
        $data['contacto_trabajo'] = $this->candidato_laboral_model->getContactosMismoTrabajo($id_candidato);
        //* Se obtienen los datos financieros
        $data['finanzas'] = $this->candidato_finanzas_model->getById($id_candidato);
        //* Se obtiene el historial de empleos
        $data['empleos'] = $this->candidato_laboral_model->getHistorialLaboralById($id_candidato);
        $data['nom'] = $this->candidato_laboral_model->getNoMencionadosById($id_candidato);
        $data['laborales'] = $this->candidato_laboral_model->getAntecedentesLaboralesById($id_candidato);
        $data['contactos'] = $this->candidato_laboral_model->getObservacionesContactoById($id_candidato);
        $data['verificacionEmpleos'] = $this->candidato_laboral_model->getVerificacion($id_candidato);
        $data['verificacionDetallesEmpleos'] = $this->candidato_laboral_model->getDetalleVerificacion($id_candidato);
        //* GAPS o periodos inactivos laborales
        $data['gaps'] = $this->candidato_model->getGAPS($id_candidato);
        //* Referencias personales
        $data['refPersonal'] = $this->candidato_ref_personal_model->getById($id_candidato);
        //* Conclusiones de la tabla candidato_finalizado
        $data['finalizado'] = $this->candidato_conclusion_model->getFinalizadoById($id_candidato);
        $data['conclusion'] = $this->candidato_conclusion_model->getBGCById($id_candidato);
        //* Informacion de vivienda
        $data['vivienda'] = $this->candidato_vivienda_model->getById($id_candidato);
        //* Referencias vecinales
        $data['refVecinal'] = $this->candidato_ref_vecinal_model->getById($id_candidato);
        //* Información de la investigación legal
        $data['legal'] = $this->candidato_model->getInvestigacionLegal($id_candidato);
        //* Información del estado de salud
        $data['salud'] = $this->candidato_salud_model->getById($id_candidato);
        //* Información de servicios públicos
        $data['servicios'] = $this->candidato_servicio_model->getById($id_candidato);
        //* Información de historial crediticio
        $data['credito'] = $this->candidato_model->checkCredito($id_candidato);
        //* Busquedas globales con Refinitiv World check
        $data['global_searches'] = $this->candidato_global_model->getById($id_candidato);
        //* Verificacion criminal
        $data['verificacionCriminal'] = $this->criminal_model->getVerificacion($id_candidato);
        $data['verificacionDetallesCriminal'] = $this->criminal_model->getDetalleVerificacion($id_candidato);
        //* Referencias de clientes
        $data['refClientes'] = $this->referencia_cliente_model->getById($id_candidato);
        //* Empresa de candidato
        $data['empresa'] = $this->candidato_empresa_model->getById($id_candidato);
        //* Referencias academicas
        $data['refAcademicas'] = $this->candidato_ref_academica_model->getById($id_candidato);
        //* Referencias profesionales
        $data['refProfesionales'] = $this->referencia_profesional_model->getById($id_candidato);

        //* Se checa si el cliente en cuestion es en ingles o espanol
        $idioma = ($data['info']->ingles == 0) ? 'espanol' : 'ingles';
        $data['idioma'] = $idioma;
        //? Revisar si $info->fecha_fin es la fecha edicion en lugar de la creacion de la finalizacion del candidato
        if ($data['info']->fecha_fin != null) {
            $data['fecha_finalizado'] = fechaTexto($data['info']->fecha_fin, $idioma);
        }
        if ($data['info']->fecha_bgc != null) {
            $data['fecha_finalizado'] = fechaTexto($data['info']->fecha_bgc, $idioma);
        }
        //* Extracción de detalles del candidato
        if ($data['info']->fecha_fin != null) {
            $fecha_fin = formatoFechaEspanol($data['info']->fecha_fin);
        }
        if ($data['info']->fecha_bgc != null) {
            $fecha_fin = formatoFechaEspanol($data['info']->fecha_bgc);
        }
        $f_alta = formatoFechaEspanol($data['info']->fecha_alta);

        //* Filtro de usuario
        $tipo_usuario = $this->session->userdata('tipo');
        if ($tipo_usuario == 1) {
            $usuario = $this->usuario_model->getDatosUsuarioInterno($id_usuario);
        }
        if ($tipo_usuario == 2) {
            $usuario = $this->usuario_model->getDatosUsuarioCliente($id_usuario);
        }
        if ($tipo_usuario == 4) {
            $usuario = $this->usuario_model->getDatosUsuarioSubcliente($id_usuario);
        }

        //* Vista PDF del reporte
        $html = $this->load->view('pdfs/reporte_espanol_pdf', $data, true);
        if ($data['info']->status_bgc != 0) {
            //* Configuraciones del mPDF
            $mpdf->setAutoTopMargin = 'stretch';
            $mpdf->AddPage();
            //TODO: Organizar encabezados y pies de pagina de acuerdo al cliente mediante BD
            if ($data['info']['id_cliente'] == 39) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 100px;" src="' . base_url() . 'img/logo_talink.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
            }
            if ($data['info']['id_cliente'] == 7) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 100px;" src="' . base_url() . 'img/logo_gentex.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
            }
            if ($data['info']['id_cliente'] == 16) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="' . base_url() . 'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="' . base_url() . 'img/logo_pie.png"></div>');
            }
            if ($data['info']['id_cliente'] == 159) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="width:130px;height:100px;" src="' . base_url() . 'img/logo_pisa.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">PISA FARMACÉUTICA</p></div><div style="position: absolute; right: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Av. España No. 1840 Colonia Moderna C.P. 44190 Guadalajara, Jalisco. Tel. 33 3678 Fax: 33 3810 Lada sin costo: 800 627</p></div>');
            }
            if ($data['info']['id_cliente'] == 172) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="' . base_url() . 'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Request Date: ' . $f_alta . '<br>Release Date: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="' . base_url() . 'img/logo_pie.png"></div>');
            }
            if ($data['info']['id_cliente'] == 190) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="width:130px;height:70px;" src="' . base_url() . 'img/logo_gesthion.jpg"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
            }
            if ($data['info']['id_cliente'] == 209) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="width:130px;height:70px;" src="' . base_url() . 'img/logo_velazquez.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
            }
            if ($data['info']['id_cliente'] != 7 && $data['info']['id_cliente'] != 16 && $data['info']['id_cliente'] != 39 && $data['info']['id_cliente'] != 159 && $data['info']['id_cliente'] != 172 && $data['info']['id_cliente'] != 190 && $data['info']['id_cliente'] != 209) {
                $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="' . base_url() . 'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="' . base_url() . 'img/logo_pie.png"></div>');
            }
        }
        //* Cifrar pdf
        $nombreArchivo = substr(md5(microtime()), 1, 12);
        /*$claveAleatoria = substr( md5(microtime()), 1, 8);
        $clave = ($usuario->clave != null)? $usuario->clave:$claveAleatoria;
        $mpdf->SetProtection(array(), $clave, 'r0d1@');*/
        //* Inactivar reportes anteriores en caso de haber
        $estatus_reporte = array(
            'status' => 0,
        );
        $this->candidato_conclusion_model->setReporte($id_candidato, $estatus_reporte);
        //* Guardar reporte finalizado en carpeta local _estudios del sistema
        $dir = set_realpath('./_estudios/' . $data['info']->id . "/");
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
            $mpdf->autoPageBreak = false;
            $mpdf->WriteHTML($html);
            $mpdf->Output($dir . $nombreArchivo . '.pdf', 'F');
            $archivo = array(
                'creacion' => date('Y-m-d H:i:s'),
                'id_candidato' => $id_candidato,
                'archivo' => $nombreArchivo . '.pdf',
            );
            $this->candidato_conclusion_model->addReporte($archivo);
            $mpdf->Output('' . $nombreArchivo . '.pdf', 'D');
        } else {
            $mpdf->autoPageBreak = false;
            $mpdf->WriteHTML($html);
            $mpdf->Output($dir . $nombreArchivo . '.pdf', 'F');
            $archivo = array(
                'creacion' => date('Y-m-d H:i:s'),
                'id_candidato' => $id_candidato,
                'archivo' => $nombreArchivo . '.pdf',
            );
            $this->candidato_conclusion_model->addReporte($archivo);
            $mpdf->Output('' . $nombreArchivo . '.pdf', 'D');
        }
    }


   
    /*----------------------------------------*/
    /*  #BGC/BGV
    /*----------------------------------------*/
    public function getBGCById()
    {
        $res = $this->candidato_conclusion_model->getBGCById($this->input->post('id'));
        if ($res != null) {
            echo json_encode($res);
        } else {
            echo $res = 0;
        }
    }
    public function setBGC()
    {
        $this->form_validation->set_rules('comentario_final', 'Declaración final', 'required|trim');
        $this->form_validation->set_rules('bgc_status', 'Estatus final del BGC', 'required|trim');

        $this->form_validation->set_message('required', 'El campo {field} es obligatorio');

        $msj = array();
        if ($this->form_validation->run() == false) {
            $msj = array(
                'codigo' => 0,
                'msg' => validation_errors(),
            );
        } else {
            date_default_timezone_set('America/Mexico_City');
            $date = date('Y-m-d H:i:s');
            $id_candidato = $_POST['id_candidato'];
            $id_usuario = $this->session->userdata('id');

            $check_visita = (!empty($this->input->post('check_visita'))) ? $this->input->post('check_visita') : 3;
            $check_laboratorio = (!empty($this->input->post('check_laboratorio'))) ? $this->input->post('check_laboratorio') : 3;
            $check_medico = (!empty($this->input->post('check_medico'))) ? $this->input->post('check_medico') : 3;
            //$check_licencia_manejo = (!empty($this->input->post('check_licencia_manejo')))? $this->input->post('check_licencia_manejo'):3;

            $hayId = $this->candidato_conclusion_model->checkBGC($id_candidato);
            if ($hayId > 0) {
                $bgc = array(
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'identidad_check' => $this->input->post('check_identidad'),
                    'empleo_check' => $this->input->post('check_laboral'),
                    'estudios_check' => $this->input->post('check_estudios'),
                    'visita_check' => $check_visita,
                    'penales_check' => $this->input->post('check_penales'),
                    'ofac_check' => $this->input->post('check_ofac'),
                    'medico_check' => $check_medico,
                    'laboratorio_check' => $check_laboratorio,
                    'global_searches_check' => $this->input->post('check_global'),
                    'domicilios_check' => $this->input->post('check_domicilio'),
                    'credito_check' => $this->input->post('check_credito'),
                    'sex_offender_check' => $this->input->post('check_sex_offender'),
                    'professional_accreditation_check' => $this->input->post('check_professional_accreditation'),
                    'ref_academica_check' => $this->input->post('check_ref_academica'),
                    'nss_check' => $this->input->post('check_nss'),
                    'ciudadania_check' => $this->input->post('check_ciudadania'),
                    'mvr_check' => $this->input->post('check_mvr'),
                    'militar_check' => $this->input->post('check_servicio_militar'),
                    //'licencia_manejo_check' => $check_licencia_manejo,
                    'credencial_academica_check' => $this->input->post('check_credencial_academica'),
                    'ref_profesional_check' => $this->input->post('check_ref_profesional'),
                    'comentario_final' => $this->input->post('comentario_final'),
                );
                $this->candidato_conclusion_model->editBGC($bgc, $id_candidato);
                $this->candidato_conclusion_model->setBGC($this->input->post('bgc_status'), $id_candidato);
            } else {
                $bgc = array(
                    'creacion' => $date,
                    'edicion' => $date,
                    'id_usuario' => $id_usuario,
                    'id_candidato' => $id_candidato,
                    'identidad_check' => $this->input->post('check_identidad'),
                    'empleo_check' => $this->input->post('check_laboral'),
                    'estudios_check' => $this->input->post('check_estudios'),
                    'visita_check' => $check_visita,
                    'penales_check' => $this->input->post('check_penales'),
                    'ofac_check' => $this->input->post('check_ofac'),
                    'medico_check' => $check_medico,
                    'laboratorio_check' => $check_laboratorio,
                    'global_searches_check' => $this->input->post('check_global'),
                    'domicilios_check' => $this->input->post('check_domicilio'),
                    'credito_check' => $this->input->post('check_credito'),
                    'sex_offender_check' => $this->input->post('check_sex_offender'),
                    'professional_accreditation_check' => $this->input->post('check_professional_accreditation'),
                    'ref_academica_check' => $this->input->post('check_ref_academica'),
                    'nss_check' => $this->input->post('check_nss'),
                    'ciudadania_check' => $this->input->post('check_ciudadania'),
                    'mvr_check' => $this->input->post('check_mvr'),
                    'militar_check' => $this->input->post('check_servicio_militar'),
                    //'licencia_manejo_check' => $check_licencia_manejo,
                    'credencial_academica_check' => $this->input->post('check_credencial_academica'),
                    'ref_profesional_check' => $this->input->post('check_ref_profesional'),
                    'comentario_final' => $this->input->post('comentario_final'),
                );
                $this->candidato_conclusion_model->addBGC($bgc);
                $this->candidato_conclusion_model->setBGC($this->input->post('bgc_status'), $id_candidato);

                //* Envio de correo al finalizar el candidato. Solo HCL
                // $candidato_detalle = $this->candidato_model->getDetalles($id_candidato);
                // if($candidato_detalle->id_cliente == 2){
                //   $from = $this->config->item('smtp_user');
                //   $to = 'bgv.latam@hcl.com';
                //   $subject = "A candidate's process has ended - RODI (PERINTEX)";
                //   $data['candidato'] = $candidato_detalle->candidato;
                //   $message = $this->load->view('mails/candidato_finalizado_hcl',$data,TRUE);
                //   $this->load->library('phpmailer_lib');
                //   $mail = $this->phpmailer_lib->load();
                //   $mail->isSMTP();
                //   $mail->Host     = 'mail.rodicontrol.com';
                //   $mail->SMTPAuth = true;
                //   $mail->Username = 'rodicontrol@rodicontrol.com';
                //   $mail->Password = 'r49o*&rUm%91';
                //   $mail->SMTPSecure = 'ssl';
                //   $mail->Port     = 465;
                //   $mail->setFrom('rodicontrol@rodicontrol.com', 'Automatic message from RODICONTROL');
                //   $mail->addAddress($to);
                //   $mail->Subject = $subject;
                //   $mail->isHTML(true);
                //   $mail->CharSet = 'UTF-8';
                //   $mail->Body = $message;
                //   $mail->send();
                // }
            }
            $msj = array(
                'codigo' => 1,
                'msg' => 'success',
            );
        }
        echo json_encode($msj);
    }
    public function update_checklist()
    {
        $date = date('Y-m-d H:i:s');
        $id_candidato = $_POST['id_candidato'];
        $id_usuario = $this->session->userdata('id');

        $hayId = $this->candidato_conclusion_model->checkBGC($id_candidato);
        if ($hayId > 0) {
            $bgc = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'identidad_check' => $this->input->post('check_identidad'),
                'empleo_check' => $this->input->post('check_laboral'),
                'estudios_check' => $this->input->post('check_estudios'),
                'visita_check' => $this->input->post('check_visita'),
                'penales_check' => $this->input->post('check_penales'),
                'ofac_check' => $this->input->post('check_ofac'),
                'medico_check' => $this->input->post('check_medico'),
                'laboratorio_check' => 3,
                'global_searches_check' => $this->input->post('check_global'),
                'domicilios_check' => $this->input->post('check_domicilio'),
                'credito_check' => $this->input->post('check_credito'),
                'sex_offender_check' => $this->input->post('check_sex_offender'),
                'professional_accreditation_check' => $this->input->post('check_professional_accreditation'),
                'ref_academica_check' => $this->input->post('check_ref_academica'),
                'nss_check' => $this->input->post('check_nss'),
                'ciudadania_check' => $this->input->post('check_ciudadania'),
                'mvr_check' => $this->input->post('check_mvr'),
                'militar_check' => $this->input->post('check_servicio_militar'),
                //'licencia_manejo_check' => $this->input->post('check_licencia_manejo'),
                'credencial_academica_check' => $this->input->post('check_credencial_academica'),
                'ref_profesional_check' => $this->input->post('check_ref_profesional'),
                'comentario_final' => $this->input->post('comentario_final'),
            );
            $this->candidato_conclusion_model->editBGC($bgc, $id_candidato);
        } else {
            $bgc = array(
                'creacion' => $date,
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_candidato' => $id_candidato,
                'identidad_check' => $this->input->post('check_identidad'),
                'empleo_check' => $this->input->post('check_laboral'),
                'estudios_check' => $this->input->post('check_estudios'),
                'visita_check' => $this->input->post('check_visita'),
                'penales_check' => $this->input->post('check_penales'),
                'ofac_check' => $this->input->post('check_ofac'),
                'medico_check' => $this->input->post('check_medico'),
                'laboratorio_check' => 3,
                'global_searches_check' => $this->input->post('check_global'),
                'domicilios_check' => $this->input->post('check_domicilio'),
                'credito_check' => $this->input->post('check_credito'),
                'sex_offender_check' => $this->input->post('check_sex_offender'),
                'professional_accreditation_check' => $this->input->post('check_professional_accreditation'),
                'ref_academica_check' => $this->input->post('check_ref_academica'),
                'nss_check' => $this->input->post('check_nss'),
                'ciudadania_check' => $this->input->post('check_ciudadania'),
                'mvr_check' => $this->input->post('check_mvr'),
                'militar_check' => $this->input->post('check_servicio_militar'),
                //'licencia_manejo_check' => $this->input->post('check_licencia_manejo'),
                'credencial_academica_check' => $this->input->post('check_credencial_academica'),
                'ref_profesional_check' => $this->input->post('check_ref_profesional'),
                'comentario_final' => $this->input->post('comentario_final'),
            );
            $this->candidato_conclusion_model->addBGC($bgc);
        }
        $msj = array(
            'codigo' => 1,
            'msg' => 'success',
        );
        echo json_encode($msj);
    }
    public function edit_checklist()
    {
        $date = date('Y-m-d H:i:s');
        $id_candidato = $this->input->post('id_candidato');
        $id_usuario = $this->session->userdata('id');

        $hayId = $this->candidato_conclusion_model->checkBGC($id_candidato);
        if ($hayId > 0) {
            $bgc = array(
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'identidad_check' => $this->input->post('estatus_identidad'),
                'empleo_check' => $this->input->post('estatus_laboral'),
                'estudios_check' => $this->input->post('estatus_estudios'),
                'penales_check' => $this->input->post('estatus_penales'),
                'ofac_check' => $this->input->post('estatus_ofac'),
                'global_searches_check' => $this->input->post('estatus_global'),
                'domicilios_check' => $this->input->post('estatus_domicilio'),
                'credito_check' => $this->input->post('estatus_credito'),
                'sex_offender_check' => $this->input->post('estatus_sex_offender'),
            );
            $this->candidato_conclusion_model->editBGC($bgc, $id_candidato);
        } else {
            $bgc = array(
                'creacion' => $date,
                'edicion' => $date,
                'id_usuario' => $id_usuario,
                'id_candidato' => $id_candidato,
                'identidad_check' => $this->input->post('estatus_identidad'),
                'empleo_check' => $this->input->post('estatus_laboral'),
                'estudios_check' => $this->input->post('estatus_estudios'),
                'penales_check' => $this->input->post('estatus_penales'),
                'ofac_check' => $this->input->post('estatus_ofac'),
                'global_searches_check' => $this->input->post('estatus_global'),
                'domicilios_check' => $this->input->post('estatus_domicilio'),
                'credito_check' => $this->input->post('estatus_credito'),
                'sex_offender_check' => $this->input->post('estatus_sex_offender'),
            );
            $this->candidato_conclusion_model->addBGC($bgc);
        }
        $msj = array(
            'codigo' => 1,
            'msg' => 'success',
        );
        echo json_encode($msj);
    }
}
