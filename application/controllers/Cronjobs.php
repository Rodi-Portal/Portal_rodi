<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cronjobs extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function crear_registros_facis_ust()
    {
        $this->db
            ->select('c.id, c.creacion, c.id_cliente')
            ->from('candidato as c')
        //->join('candidato_seccion as S','S.id_candidato = c.id')
            ->where('c.id_cliente', 1)
            ->where('c.id_tipo_proceso', 2);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $resultados = $query->result();
        } else {
            $resultados = false;
        }

        foreach ($resultados as $row) {
            $this->db
                ->select('id')
                ->from('candidato_pruebas')
                ->where('id_candidato', $row->id);
            $query        = $this->db->get();
            $tienePruebas = $query->row();

            if (empty($tienePruebas)) {
                $pruebas = [
                    'creacion'                => $row->creacion,
                    'edicion'                 => $row->creacion,
                    'id_usuario_cliente'      => 0,
                    'id_usuario_subcliente'   => 0,
                    'id_usuario'              => 1,
                    'id_candidato'            => $row->id,
                    'id_cliente'              => $row->id_cliente,
                    'socioeconomico'          => 1,
                    'tipo_antidoping'         => 0,
                    'status_doping'           => 0,
                    'tipo_psicometrico'       => 0,
                    'psicometrico'            => 0,
                    'medico'                  => 0,
                    'buro_credito'            => 0,
                    'sociolaboral'            => 0,
                    'resultado_ofac'          => 0,
                    'resultado_oig'           => 0,
                    'resultado_sam'           => 0,
                    'res_data_juridica'       => 0,
                    'res_new_york_restricted' => 0,
                ];
                $this->db->insert('candidato_pruebas', $pruebas);
                unset($pruebas);
            }

            $this->db
                ->select('id')
                ->from('candidato_seccion')
                ->where('id_candidato', $row->id);
            $query          = $this->db->get();
            $tieneSecciones = $query->row();

            if (empty($tieneSecciones)) {
                $secciones = [
                    'creacion'              => $row->creacion,
                    'id_usuario'            => 1,
                    'id_usuario_cliente'    => 0,
                    'id_usuario_subcliente' => 0,
                    'id_candidato'          => $row->id,
                    'proyecto'              => 'FACIS',
                    'secciones'             => '<a class="dropdown-item" href="javascript:void(0)" id="datos_investigacion">Investigaciones</a>',
                    'lleva_gaps'            => 0,
                    'lleva_investigacion'   => 1,
                    'id_investigacion'      => 110,
                    'tipo_conclusion'       => 11,
                ];
                $this->db->insert('candidato_seccion', $secciones);
                unset($secciones);
            }
        }
        echo "Se ha finalizado la creacion de registros FACIS para UST";

    }

    public function crear_registros_pruebas_ust()
    {
        $this->db
            ->select('c.id, c.creacion, c.id_cliente')
            ->from('candidato as c')
            ->join('candidato_seccion as S', 'S.id_candidato = c.id')
            ->where('c.id_cliente', 1)
            ->where('c.eliminado', 0)
            ->where_in('S.proyecto', ['ESE', 'ESE International', 'ESE-WORLD CHECK']);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $resultados = $query->result();
        } else {
            $resultados = false;
        }

        foreach ($resultados as $row) {
            $datos = [
                'creacion'                => $row->creacion,
                'edicion'                 => $row->creacion,
                'id_usuario_cliente'      => 0,
                'id_usuario_subcliente'   => 0,
                'id_usuario'              => 1,
                'id_candidato'            => $row->id,
                'id_cliente'              => $row->id_cliente,
                'socioeconomico'          => 1,
                'tipo_antidoping'         => 0,
                'status_doping'           => 0,
                'tipo_psicometrico'       => 0,
                'psicometrico'            => 0,
                'medico'                  => 0,
                'buro_credito'            => 0,
                'sociolaboral'            => 0,
                'resultado_ofac'          => 0,
                'resultado_oig'           => 0,
                'resultado_sam'           => 0,
                'res_data_juridica'       => 0,
                'res_new_york_restricted' => 0,
            ];
            $this->db->insert('candidato_pruebas', $datos);
            unset($datos);
        }
        echo "Se ha finalizado la creacion de registros para UST";

    }

    public function convertir()
    {
        $query = $this->db->query("SELECT id, creacion, edicion, FROM tabla");

        // Obtener los resultados de la consulta
        $resultados = $query->result_array();

        // Generar las sentencias de inserción
        $sentencias_insercion = [];
        foreach ($resultados as $resultado) {
            $valores = implode(", ", array_map(function ($valor) {
                return $this->db->escape($valor);
            }, $resultado));

            $sentencia              = "INSERT INTO tabla_destino (columna1, columna2, columna3) VALUES ($valores)";
            $sentencias_insercion[] = $sentencia;
        }

        // Imprimir las sentencias de inserción generadas
        foreach ($sentencias_insercion as $sentencia) {
            echo $sentencia . "<br>";
        }
    }

    public function obtener_documentos()
    {
        // Ruta de la carpeta _docs utilizando base_url
        $archivos = directory_map('./_docs/');

        // Obtener la lista de archivos en la carpeta _docs
        // Iterar sobre cada archivo obtenido
        foreach ($archivos as $archivo) {
            // Verificar si es un archivo válido
            //$nombreArchivo = pathinfo($archivo, PATHINFO_FILENAME);
            // Verificar si el archivo existe en la tabla candidato_documento
            $existe_documento = $this->cronjobs_model->checkArchivo($archivo);

            if (! $existe_documento) {
                // El archivo existe en la tabla candidato_documento
                //echo 'Candidato: '.$existe_documento->id_candidato.' Tipo: '.$existe_documento->id_tipo_documento.' <br>';
                echo $archivo . '<br>';
            }
        }
    }

    public function generarSLA()
    {
        date_default_timezone_set('America/Mexico_City');
        $fechaActual = date('Y-m-d H:i:s');

        $data['festivas']   = $this->cronjobs_model->getFechasFestivas();
        $data['candidatos'] = $this->cronjobs_model->getCandidatos();
        foreach ($data['candidatos'] as $candidato) {
            $contadorDias = 0;
            $fechaInicial = $candidato->fecha_alta;

            if ($candidato->fecha_final != null && $candidato->fecha_final != -1) {
                // Verificar si la hora inicial es menor a las 4pm
                $horaInicial   = date('H', strtotime($fechaInicial));
                $minutoInicial = date('i', strtotime($fechaInicial));
                if ($horaInicial < 16) {
                    // Si la hora actual es mayor o igual a las 4pm, incrementamos los dias transcurridos en un día
                    $contadorDias = 1;
                }
                // Calculamos los días transcurridos excluyendo fines de semana y fechas traidas de una consulta
                $fechaInicialTimestamp = strtotime($fechaInicial);
                $fechaFinalTimestamp   = strtotime($candidato->fecha_final);

                while ($fechaInicialTimestamp <= $fechaFinalTimestamp) {
                    $diaSemana = date('N', $fechaInicialTimestamp);
                    if ($diaSemana >= 1 && $diaSemana <= 5) {
                        // Si no es sábado ni domingo, incrementamos el contador de días
                        $contadorDias++;
                        foreach ($data['festivas'] as $festiva) {
                            //$fechaFestivaTimestamp = strtotime($festiva->fecha);
                            if (date('Y-m-d', $fechaInicialTimestamp) == date('Y-m-d', strtotime($festiva->fecha))) {
                                // Si la fecha en curso del loop es una fecha festiva, disminuimos el contador de días
                                //echo date('Y-m-d', $fechaInicialTimestamp).' - '.date('Y-m-d', strtotime($festiva->fecha)).'<br>';
                                $contadorDias--;
                            }
                        }
                    }
                    // Incrementamos la fecha inicial en un día
                    $fechaInicialTimestamp = strtotime('+1 day', $fechaInicialTimestamp);
                }
                // $datos = array(
                //   'tiempo' => $contadorDias
                // );
                // $this->cronjobs_model->registroDiasFinalizadoIngles($datos, $candidato->idFin);
                $datos = [
                    'tiempo_parcial' => $contadorDias,
                ];
                $this->cronjobs_model->registroDiasEnProceso($datos, $candidato->idCandidato);

            } elseif ($candidato->fecha_bgc != null && $candidato->fecha_bgc != -1) {
                // Verificar si la hora inicial es menor a las 4pm
                $horaInicial   = date('H', strtotime($fechaInicial));
                $minutoInicial = date('i', strtotime($fechaInicial));
                if ($horaInicial < 16) {
                    // Si la hora actual es mayor o igual a las 4pm, incrementamos los dias transcurridos en un día
                    $contadorDias = 1;
                }
                // Calculamos los días transcurridos excluyendo fines de semana y fechas traidas de una consulta
                $fechaInicialTimestamp = strtotime($fechaInicial);
                $fechaFinalTimestamp   = strtotime($candidato->fecha_bgc);

                while ($fechaInicialTimestamp <= $fechaFinalTimestamp) {
                    $diaSemana = date('N', $fechaInicialTimestamp);
                    if ($diaSemana >= 1 && $diaSemana <= 5) {
                        // Si no es sábado ni domingo, incrementamos el contador de días
                        $contadorDias++;
                        foreach ($data['festivas'] as $festiva) {
                            //$fechaFestivaTimestamp = strtotime($festiva->fecha);
                            if (date('Y-m-d', $fechaInicialTimestamp) == date('Y-m-d', strtotime($festiva->fecha))) {
                                // Si la fecha en curso del loop es una fecha festiva, disminuimos el contador de días
                                //echo date('Y-m-d', $fechaInicialTimestamp).' - '.date('Y-m-d', strtotime($festiva->fecha)).'<br>';
                                $contadorDias--;
                            }
                        }
                    }
                    // Incrementamos la fecha inicial en un día
                    $fechaInicialTimestamp = strtotime('+1 day', $fechaInicialTimestamp);
                }
                $datos = [
                    'tiempo' => $contadorDias,
                ];
                $this->cronjobs_model->registroDiasFinalizadoIngles($datos, $candidato->idFin);
                $datos = [
                    'tiempo_parcial' => $contadorDias,
                ];
                $this->cronjobs_model->registroDiasEnProceso($datos, $candidato->idCandidato);
            } elseif ($candidato->fecha_bgc == null && $candidato->fecha_final == null) {
                // Verificar si la hora inicial es menor a las 4pm
                $horaInicial   = date('H', strtotime($fechaInicial));
                $minutoInicial = date('i', strtotime($fechaInicial));
                if ($horaInicial < 16) {
                    // Si la hora actual es mayor o igual a las 4pm, incrementamos los dias transcurridos en un día
                    $contadorDias = 1;
                    //$diasTranscurridos = date('Y-m-d', strtotime($fechaInicial . ' +1 day'));
                }
                // Calculamos los días transcurridos excluyendo fines de semana y fechas traidas de una consulta
                $fechaInicialTimestamp = strtotime($fechaInicial);
                $fechaActualTimestamp  = strtotime($fechaActual);

                while ($fechaInicialTimestamp <= $fechaActualTimestamp) {
                    $diaSemana = date('N', $fechaInicialTimestamp);
                    if ($diaSemana >= 1 && $diaSemana <= 5) {
                        // Si no es sábado ni domingo, incrementamos el contador de días
                        $contadorDias++;
                        foreach ($data['festivas'] as $festiva) {
                            //$fechaFestivaTimestamp = strtotime($festiva->fecha);
                            if (date('Y-m-d', $fechaInicialTimestamp) == date('Y-m-d', strtotime($festiva->fecha))) {
                                // Si la fecha en curso del loop es una fecha festiva, disminuimos el contador de días
                                //echo date('Y-m-d', $fechaInicialTimestamp).' - '.date('Y-m-d', strtotime($festiva->fecha)).'<br>';
                                $contadorDias--;
                            }
                        }
                    }
                    // Incrementamos la fecha inicial en un día
                    $fechaInicialTimestamp = strtotime('+1 day', $fechaInicialTimestamp);
                }
                $datos = [
                    'tiempo_parcial' => $contadorDias,
                ];
                $this->cronjobs_model->registroDiasEnProceso($datos, $candidato->idCandidato);
            }
        }
        //echo "dias: ".$contadorDias;
        echo "Calculo de SLA para candidatos finalizado";
    }

    public function actualizarCampo()
    {
        // Definir los datos a actualizar
      $respuesta = $this->cronjobs_model->actualizarCampoExcluyendoPortal1();

        // Verificar si se actualizó alguna fila
    }

    public function generarPDF()
    {
        $data['candidatos'] = $this->cronjobs_model->getCandidatoFinalizados();
        $num                = 0;
        foreach ($data['candidatos'] as $candidato) {
            $num++;
            if ($candidato->idCandidato != null) {
                //* Llamada a la libreria de mpdf, iniciación de fechas y captura POST
                $mpdf = new \Mpdf\Mpdf();
                date_default_timezone_set('America/Mexico_City');

                $id_candidato = $candidato->idCandidato;
                //$id_usuario = $this->session->userdata('id');

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
                $data['academico']          = $this->candidato_estudio_model->getHistorialById($id_candidato);
                $data['verMayoresEstudios'] = $this->candidato_estudio_model->getMayorById($id_candidato);
                //* Se obtienen los datos sociales
                $data['sociales'] = $this->candidato_social_model->getById($id_candidato);
                //* Se obtiene la información familiar
                $data['familia'] = $this->candidato_familiar_model->getById($id_candidato);
                //* Se obtienen los contactos del candidato que laboran en el mismo lugar
                $data['contacto_trabajo'] = $this->candidato_laboral_model->getContactosMismoTrabajo($id_candidato);
                //* Se obtienen los datos financieros
                $data['finanzas'] = $this->candidato_finanzas_model->getById($id_candidato);
                //* Se obtiene el historial de empleos
                $data['empleos']   = $this->candidato_laboral_model->getHistorialLaboralById($id_candidato);
                $data['nom']       = $this->candidato_laboral_model->getNoMencionadosById($id_candidato);
                $data['laborales'] = $this->candidato_laboral_model->getAntecedentesLaboralesById($id_candidato);
                //* GAPS o periodos inactivos laborales
                $data['gaps'] = $this->candidato_model->getGAPS($id_candidato);
                //* Referencias personales
                $data['refPersonal'] = $this->candidato_ref_personal_model->getById($id_candidato);
                //* Conclusiones de la tabla candidato_finalizado
                $data['finalizado'] = $this->candidato_conclusion_model->getFinalizadoById($id_candidato);
                //* Informacion de vivienda
                $data['vivienda'] = $this->candidato_vivienda_model->getById($id_candidato);
                //* Referencias vecinales
                $data['refVecinal'] = $this->candidato_ref_vecinal_model->getById($id_candidato);
                //* Información de la investigación legal
                $data['legal'] = $this->candidato_model->getInvestigacionLegal($id_candidato);

                //* Se checa si el cliente en cuestion es en ingles o espanol
                $idioma         = ($data['info']->ingles == 0) ? 'espanol' : 'ingles';
                $data['idioma'] = $idioma;
                //? Revisar si $info->fecha_fin es la fecha edicion en lugar de la creacion de la finalizacion del candidato
                $data['fecha_finalizado'] = fechaTexto($data['info']->fecha_fin, $idioma);

                //* Extracción de detalles del candidato
                $fecha_fin = formatoFechaEspanol($data['info']->fecha_fin);
                $f_alta    = formatoFechaEspanol($data['info']->fecha_alta);

                //* Filtro de usuario
                /*$tipo_usuario = $this->session->userdata('tipo');
        if($tipo_usuario == 1){
          $usuario = $this->usuario_model->getDatosUsuarioInterno($id_usuario);
        }
        if($tipo_usuario == 2){
          $usuario = $this->usuario_model->getDatosUsuarioCliente($id_usuario);
        }
        if($tipo_usuario == 4){
          $usuario = $this->usuario_model->getDatosUsuarioSubcliente($id_usuario);
        }*/

                //* Vista PDF del reporte
                $html = $this->load->view('pdfs/reporte_espanol_pdf', $data, true);
                if ($data['info']->status_bgc != 0) {
                    //* Configuraciones del mPDF
                    $mpdf->setAutoTopMargin = 'stretch';
                    $mpdf->AddPage();
                    //TODO: Organizar encabezados y pies de pagina de acuerdo al cliente mediante BD
                    if ($data['info']->id_cliente == 39) {
                        $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 100px;" src="' . base_url() . 'img/logo_talink.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                        $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
                    }
                    if ($data['info']->id_cliente == 7) {
                        $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 100px;" src="' . base_url() . 'img/logo_gentex.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                        $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div>');
                    }
                    if ($data['info']->id_cliente == 16) {
                        $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="' . base_url() . 'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                        $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="' . base_url() . 'img/logo_pie.png"></div>');
                    }
                    if ($data['info']->id_cliente != 7 && $data['info']->id_cliente != 16 && $data['info']->id_cliente != 39) {
                        $mpdf->SetHTMLHeader('<div style="width: 33%; float: left;"><img style="height: 50px;" src="' . base_url() . 'img/logo.png"></div><div style="width: 33%; float: right;text-align: right;">Fecha de Registro: ' . $f_alta . '<br>Fecha de Elaboración: ' . $fecha_fin . '</div>');
                        $mpdf->SetHTMLFooter('<div style="position: absolute; left: 20px; bottom: 10px; color: rgba(0,0,0,0.5);"><p style="font-size: 10px;">Calle Benito Juarez # 5693, Col. Santa María del Pueblito <br>Zapopan, Jalisco C.P. 45018 <br>Tel. (33) 2301-8599<br><br>4-EST-001.Rev. 01 <br>Fecha de Rev. 05/06/2020</p></div><div style="position: absolute; right: 0;  bottom: 0;"><img class="" src="' . base_url() . 'img/logo_pie.png"></div>');
                    }
                }
                //*¨Cifrar pdf
                $nombreArchivo = substr(md5(microtime()), 1, 12);
                /*$claveAleatoria = substr( md5(microtime()), 1, 8);
        $clave = ($usuario->clave != null)? $usuario->clave:$claveAleatoria;
        $mpdf->SetProtection(array(), $clave, 'r0d1@');*/
                //* Guardar reporte finalizado en carpeta local _estudios del sistema
                $dir = set_realpath('./_estudios/' . $data['info']->id . "/");
                if (! is_dir($dir)) {
                    mkdir($dir, 0777, true);
                    $mpdf->WriteHTML($html);
                    $mpdf->Output($dir . $nombreArchivo . '.pdf', 'F');
                    $archivo = [
                        'creacion'     => date('Y-m-d H:i:s'),
                        'id_candidato' => $data['info']->id,
                        'archivo'      => $nombreArchivo . '.pdf',
                    ];
                    $this->cronjobs_model->addArchivoPDF($archivo);
                }
                echo '#' . $num . ' ' . $candidato->idCandidato . ' terminado<br>';
            }
        }
    }

    public function generarTiempoIngles()
    {
        date_default_timezone_set('America/Mexico_City');

        $data['candidatos'] = $this->cronjobs_model->getCandidatosIngles();
        foreach ($data['candidatos'] as $candidato) {
            $dias           = 0; //dias transcurridos
            $acum           = 0;
            $fecha_registro = $candidato->fecha_alta; //alta del candidato
            $f_alta         = explode(' ', $fecha_registro);
            $fecha_fija     = $f_alta[0] . ' 16:00:00'; //hora limite para iniciar el contador de dias en 1
            $fr             = strtotime($fecha_registro);
            $ff             = strtotime($fecha_fija);
            if ($fr < $ff) {
                $dias = 1; //Si la fecha de registro es menor a la hora limite se inicia el dia en 1
            }

            //Verificacion del contador de dias con la fecha de regitro
            $num_dia = date('N', $fr);
            if ($num_dia != 6 && $num_dia != 7) { //Se evalua si el registro no fue hecho un sabado o domingo
                $f_aux            = strtotime($f_alta[0]);
                $data['festivas'] = $this->cronjobs_model->getFechasFestivas();
                foreach ($data['festivas'] as $festiva) {
                    $aux           = explode(' ', $festiva->fecha);
                    $fecha_festiva = strtotime($aux[0]); //Se extraen o definen los dias festivos
                    if ($f_aux == $fecha_festiva) {      //Se evalua si cada fecha festiva es diferente a la fecha de regitro
                        $dias = 0;
                        break;
                    }
                }
            }
            $fecha_final = $candidato->fecha_final; //la fecha final es la fecha de creacion de la tabla candidato_finalizado
                                                    //Se consulta si existe registro del candidato en la tabla candidato_finalizado
            if ($fecha_final != "" && $fecha_final != null) {
                $fin   = explode(' ', $fecha_final);
                $date1 = new DateTime($f_alta[0]); //Se toma la fecha solamente de registro, la hora no importa porque se calcula al principio y despues de ello se omite para contabilizar los dias entre fechas
                $date2 = new DateTime($fin[0]);    //fecha final
                $diff  = $date1->diff($date2);
                if ($diff->days != 0) {
                    for ($i = 1; $i <= $diff->days; $i++) {
                        $acum      = 0;
                        $siguiente = date("Y-m-d", strtotime(date($f_alta[0]) . "+ " . $i . " days")); //dia siguiente suponiendo que sea el actual en ese momento
                        $sig       = strtotime($siguiente);
                        $num_sig   = date('N', $sig);
                        if ($num_sig != 6 && $num_sig != 7) {     //Se evalua si el registro no fue hecho un sabado o domingo
                            foreach ($data['festivas'] as $festiva) { //Se extraen o definen los dias festivos
                                $aux           = explode(' ', $festiva->fecha);
                                $fecha_festiva = strtotime($aux[0]);
                                if ($sig == $fecha_festiva) {
                                    $acum++; //Si la fecha siguiente al dia de registro es igual a una fecha festiva se incrementa el acumulador funcionando como indicador
                                }
                            }
                            if ($acum == 0) {
                                $dias++; //SI la fecha festiva no es igual (es decir $acum = 0) a la fecha siguiente de la fecha registro se incrementa el dia
                            }
                        }
                    }
                    $datos = [
                        'tiempo' => $dias,
                    ];
                    $this->cronjobs_model->registroDiasFinalizadoIngles($datos, $candidato->idFin);
                    $datos2 = [
                        'tiempo_parcial' => $dias,
                    ];
                    $this->cronjobs_model->registroDiasEnProceso($datos2, $candidato->idCandidato);
                } else {
                    $datos = [
                        'tiempo' => $dias,
                    ];
                    $this->cronjobs_model->registroDiasFinalizadoIngles($datos, $candidato->idFin);
                    $datos2 = [
                        'tiempo_parcial' => $dias,
                    ];
                    $this->cronjobs_model->registroDiasEnProceso($datos2, $candidato->idCandidato);
                }
            } else {                           //Sin fecha de finalizacion de estudio
                $date1 = new DateTime($f_alta[0]); //Se toma la fecha solamente de registro, la hora no importa porque se calcula al principio y despues de ello se omite para contabilizar los dias entre fechas
                $date2 = new DateTime();           //fecha actual
                $date2->format('d/m/Y');
                $diff = $date1->diff($date2);
                if ($diff->days != 0) {
                    for ($i = 1; $i <= $diff->days; $i++) {
                        $acum      = 0;
                        $siguiente = date("Y-m-d", strtotime(date($f_alta[0]) . "+ " . $i . " days")); //dia siguiente suponiendo que sea el actual en ese momento
                        $sig       = strtotime($siguiente);
                        $num_sig   = date('N', $sig);
                        if ($num_sig != 6 && $num_sig != 7) {     //Se evalua si el registro no fue hecho un sabado o domingo
                            foreach ($data['festivas'] as $festiva) { //Se extraen o definen los dias festivos
                                $aux           = explode(' ', $festiva->fecha);
                                $fecha_festiva = strtotime($aux[0]);
                                if ($sig == $fecha_festiva) {
                                    $acum++; //Si la fecha siguiente al dia de registro es igual a una fecha festiva se incrementa el acumulador funcionando como indicador
                                }
                            }
                            if ($acum == 0) {
                                $dias++; //SI la fecha festiva no es igual (es decir $acum = 0) a la fecha siguiente de la fecha registro se incrementa el dia
                            }
                        }
                    }
                    $datos = [
                        'tiempo_parcial' => $dias,
                    ];
                    $this->cronjobs_model->registroDiasEnProceso($datos, $candidato->idCandidato);
                } else {
                    $datos = [
                        'tiempo_parcial' => $dias,
                    ];
                    $this->cronjobs_model->registroDiasEnProceso($datos, $candidato->idCandidato);
                }
            }
        }
        echo "Calculo de dias en los procesos de clientes en ingles terminado";
    }

    public function generarTiempoUST()
    {
        date_default_timezone_set('America/Mexico_City');

        $data['candidatos'] = $this->cronjobs_model->getCandidatoUST();
        foreach ($data['candidatos'] as $candidato) {
            $dias           = 0; //dias transcurridos
            $acum           = 0;
            $fecha_registro = $candidato->fecha_alta; //alta del candidato
            $f_alta         = explode(' ', $fecha_registro);
            $fecha_fija     = $f_alta[0] . ' 16:00:00'; //hora limite para iniciar el contador de dias en 1
            $fr             = strtotime($fecha_registro);
            $ff             = strtotime($fecha_fija);
            if ($fr < $ff) {
                $dias = 1; //Si la fecha de registro es menor a la hora limite se inicia el dia en 1
            }

            //Verificacion del contador de dias con la fecha de regitro
            $num_dia = date('N', $fr);
            if ($num_dia != 6 && $num_dia != 7) { //Se evalua si el registro no fue hecho un sabado o domingo
                $f_aux            = strtotime($f_alta[0]);
                $data['festivas'] = $this->cronjobs_model->getFechasFestivas();
                foreach ($data['festivas'] as $festiva) {
                    $aux           = explode(' ', $festiva->fecha);
                    $fecha_festiva = strtotime($aux[0]); //Se extraen o definen los dias festivos
                    if ($f_aux == $fecha_festiva) {      //Se evalua si cada fecha festiva es diferente a la fecha de regitro
                        $dias = 0;
                        break;
                    }
                }
            }
            $fecha_final = $candidato->fecha_final; //la fecha final es la fecha de creacion de la tabla candidato_finalizado
                                                    //Se consulta si existe registro del candidato en la tabla candidato_finalizado
            if ($fecha_final != "" && $fecha_final != null) {
                $fin   = explode(' ', $fecha_final);
                $date1 = new DateTime($f_alta[0]); //Se toma la fecha solamente de registro, la hora no importa porque se calcula al principio y despues de ello se omite para contabilizar los dias entre fechas
                $date2 = new DateTime($fin[0]);    //fecha final
                $diff  = $date1->diff($date2);
                if ($diff->days != 0) {
                    for ($i = 1; $i <= $diff->days; $i++) {
                        $acum      = 0;
                        $siguiente = date("Y-m-d", strtotime(date($f_alta[0]) . "+ " . $i . " days")); //dia siguiente suponiendo que sea el actual en ese momento
                        $sig       = strtotime($siguiente);
                        $num_sig   = date('N', $sig);
                        if ($num_sig != 6 && $num_sig != 7) {     //Se evalua si el registro no fue hecho un sabado o domingo
                            foreach ($data['festivas'] as $festiva) { //Se extraen o definen los dias festivos
                                $aux           = explode(' ', $festiva->fecha);
                                $fecha_festiva = strtotime($aux[0]);
                                if ($sig == $fecha_festiva) {
                                    $acum++; //Si la fecha siguiente al dia de registro es igual a una fecha festiva se incrementa el acumulador funcionando como indicador
                                }
                            }
                            if ($acum == 0) {
                                $dias++; //SI la fecha festiva no es igual (es decir $acum = 0) a la fecha siguiente de la fecha registro se incrementa el dia
                            }
                        }
                    }
                    $datos = [
                        'tiempo' => $dias,
                    ];
                    $this->cronjobs_model->registroDiasFinalizadoIngles($datos, $candidato->idFin);
                    $datos2 = [
                        'tiempo_parcial' => $dias,
                    ];
                    $this->cronjobs_model->registroDiasEnProceso($datos2, $candidato->idCandidato);
                } else {
                    $datos = [
                        'tiempo' => $dias,
                    ];
                    $this->cronjobs_model->registroDiasFinalizadoIngles($datos, $candidato->idFin);
                    $datos2 = [
                        'tiempo_parcial' => $dias,
                    ];
                    $this->cronjobs_model->registroDiasEnProceso($datos2, $candidato->idCandidato);
                }
            } else {                           //Sin fecha de finalizacion de estudio
                $date1 = new DateTime($f_alta[0]); //Se toma la fecha solamente de registro, la hora no importa porque se calcula al principio y despues de ello se omite para contabilizar los dias entre fechas
                $date2 = new DateTime();           //fecha actual
                $date2->format('d/m/Y');
                $diff = $date1->diff($date2);
                if ($diff->days != 0) {
                    for ($i = 1; $i <= $diff->days; $i++) {
                        $acum      = 0;
                        $siguiente = date("Y-m-d", strtotime(date($f_alta[0]) . "+ " . $i . " days")); //dia siguiente suponiendo que sea el actual en ese momento
                        $sig       = strtotime($siguiente);
                        $num_sig   = date('N', $sig);
                        if ($num_sig != 6 && $num_sig != 7) {     //Se evalua si el registro no fue hecho un sabado o domingo
                            foreach ($data['festivas'] as $festiva) { //Se extraen o definen los dias festivos
                                $aux           = explode(' ', $festiva->fecha);
                                $fecha_festiva = strtotime($aux[0]);
                                if ($sig == $fecha_festiva) {
                                    $acum++; //Si la fecha siguiente al dia de registro es igual a una fecha festiva se incrementa el acumulador funcionando como indicador
                                }
                            }
                            if ($acum == 0) {
                                $dias++; //SI la fecha festiva no es igual (es decir $acum = 0) a la fecha siguiente de la fecha registro se incrementa el dia
                            }
                        }
                    }
                    $datos = [
                        'tiempo_parcial' => $dias,
                    ];
                    $this->cronjobs_model->registroDiasEnProceso($datos, $candidato->idCandidato);
                } else {
                    $datos = [
                        'tiempo_parcial' => $dias,
                    ];
                    $this->cronjobs_model->registroDiasEnProceso($datos, $candidato->idCandidato);
                }
            }
        }
        echo "Calculo de dias en los procesos de cliente UST terminado";
    }

    public function generarAvancesUST()
    {
        $data['candidatos'] = $this->cronjobs_model->getCandidatosUST();
        foreach ($data['candidatos'] as $c) {
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
            $data['docs'] = $this->cronjobs_model->getDocumentosObligatoriosUST($c->idCandidato);
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
            $this->cronjobs_model->cleanAvance($c->idCandidato);
            $this->cronjobs_model->actualizarAvance($porcentaje, $c->idCandidato);
        }
        echo "Calculo de porcentaje de avances en los procesos UST GLOBAL terminado";
    }

    public function asignarSeccionesCandidatos()
    {
        //Sempra
        /*$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(24);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_generales">Datos generales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_mayores_estudios">Mayores estudios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_globales_c">Global data search -Type C</a><a class="dropdown-item" href="javascript:void(0)" id="datos_domicilios_a">Historial de domicilios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_verificacion_docs_b">Verificación de documentos</a><a class="dropdown-item" href="javascript:void(0)" id="datos_laborales">Referencias laborales</a>';
				$datos['lleva_empleos'] = 1;
				$datos['lleva_criminal'] = 1;
				$datos['lleva_estudios'] = 1;
				$datos['lleva_domicilios'] = 1;
				$datos['lleva_gaps'] = 1;
				$datos['lleva_credito'] = 0;
				$datos['id_seccion_datos_generales'] = 1;
				$datos['id_seccion_historial_domicilios'] = 17;
				$datos['id_seccion_verificacion_docs'] = 11;
				$datos['id_seccion_global_search'] = 6;
				$datos['tiempo_empleos'] = '7 years';
				$datos['tiempo_criminales'] = '7 years';
				$datos['tiempo_domicilios'] = '7 years';
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//USAA
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(27);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_generales">Datos generales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_mayores_estudios">Mayores estudios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_globales_d">Global data search -Type D</a><a class="dropdown-item" href="javascript:void(0)" id="datos_domicilios_a">Historial de domicilios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_verificacion_docs_b">Verificación de documentos</a><a class="dropdown-item" href="javascript:void(0)" id="datos_laborales">Referencias laborales</a>';
				$datos['lleva_empleos'] = 1;
				$datos['lleva_criminal'] = 1;
				$datos['lleva_estudios'] = 1;
				$datos['lleva_domicilios'] = 1;
				$datos['lleva_gaps'] = 1;
				$datos['lleva_credito'] = 0;
				$datos['id_seccion_datos_generales'] = 1;
				$datos['id_seccion_historial_domicilios'] = 17;
				$datos['id_seccion_verificacion_docs'] = 11;
				$datos['id_seccion_global_search'] = 7;
				$datos['tiempo_empleos'] = '5 years';
				$datos['tiempo_criminales'] = '7 years';
				$datos['tiempo_domicilios'] = '7 years';
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//STANDARD
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(28);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_generales">Datos generales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_mayores_estudios">Mayores estudios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_globales_d">Global data search -Type D</a><a class="dropdown-item" href="javascript:void(0)" id="datos_verificacion_docs_d">Verificación de documentos</a><a class="dropdown-item" href="javascript:void(0)" id="datos_laborales">Referencias laborales</a>';
				$datos['lleva_empleos'] = 1;
				$datos['lleva_criminal'] = 1;
				$datos['lleva_estudios'] = 1;
				$datos['lleva_domicilios'] = 0;
				$datos['lleva_gaps'] = 1;
				$datos['lleva_credito'] = 0;
				$datos['id_seccion_datos_generales'] = 1;
				$datos['id_seccion_historial_domicilios'] = null;
				$datos['id_seccion_verificacion_docs'] = 13;
				$datos['id_seccion_global_search'] = 7;
				$datos['tiempo_empleos'] = '5 years';
				$datos['tiempo_criminales'] = '5 years';
				$datos['tiempo_domicilios'] = null;
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//Citi
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(35);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_generales">Datos generales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_mayores_estudios">Mayores estudios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_globales_e">Global data search -Type E</a><a class="dropdown-item" href="javascript:void(0)" id="datos_domicilios_a">Historial de domicilios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_verificacion_docs_b">Verificación de documentos</a><a class="dropdown-item" href="javascript:void(0)" id="datos_laborales">Referencias laborales</a>';
				$datos['lleva_empleos'] = 1;
				$datos['lleva_criminal'] = 1;
				$datos['lleva_estudios'] = 1;
				$datos['lleva_domicilios'] = 1;
				$datos['lleva_gaps'] = 1;
				$datos['lleva_credito'] = 0;
				$datos['id_seccion_datos_generales'] = 1;
				$datos['id_seccion_historial_domicilios'] = 17;
				$datos['id_seccion_verificacion_docs'] = 11;
				$datos['id_seccion_global_search'] = 8;
				$datos['tiempo_empleos'] = '5 years';
				$datos['tiempo_criminales'] = '7 years';
				$datos['tiempo_domicilios'] = '7 years';
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//Custom 135 y 137
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(137);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_globales_g">Global data search -Type G</a>';
				$datos['lleva_empleos'] = 0;
				$datos['lleva_criminal'] = 0;
				$datos['lleva_estudios'] = 0;
				$datos['lleva_domicilios'] = 0;
				$datos['lleva_gaps'] = 0;
				$datos['lleva_credito'] = 0;
				$datos['id_seccion_datos_generales'] = null;
				$datos['id_seccion_historial_domicilios'] = null;
				$datos['id_seccion_verificacion_docs'] = null;
				$datos['id_seccion_global_search'] = 21;
				$datos['tiempo_empleos'] = null;
				$datos['tiempo_criminales'] = null;
				$datos['tiempo_domicilios'] = null;
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//Custom 136
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(136);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_globales_g">Global data search -Type G</a>';
				$datos['lleva_empleos'] = 0;
				$datos['lleva_criminal'] = 1;
				$datos['lleva_estudios'] = 0;
				$datos['lleva_domicilios'] = 0;
				$datos['lleva_gaps'] = 0;
				$datos['lleva_credito'] = 0;
				$datos['id_seccion_datos_generales'] = null;
				$datos['id_seccion_historial_domicilios'] = null;
				$datos['id_seccion_verificacion_docs'] = null;
				$datos['id_seccion_global_search'] = 21;
				$datos['tiempo_empleos'] = null;
				$datos['tiempo_criminales'] = '7 years';
				$datos['tiempo_domicilios'] = null;
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//Custom 138
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(138);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_globales_g">Global data search -Type G</a><a class="dropdown-item" href="javascript:void(0)" id="datos_verificacion_docs_g">Verificación de documentos</a>';
				$datos['lleva_empleos'] = 0;
				$datos['lleva_criminal'] = 0;
				$datos['lleva_estudios'] = 0;
				$datos['lleva_domicilios'] = 0;
				$datos['lleva_gaps'] = 0;
				$datos['lleva_credito'] = 0;
				$datos['id_seccion_datos_generales'] = null;
				$datos['id_seccion_historial_domicilios'] = null;
				$datos['id_seccion_verificacion_docs'] = 19;
				$datos['id_seccion_global_search'] = 21;
				$datos['tiempo_empleos'] = null;
				$datos['tiempo_criminales'] = null;
				$datos['tiempo_domicilios'] = null;
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//Custom 140
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(140);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_verificacion_docs_g">Verificación de documentos</a>';
				$datos['lleva_empleos'] = 0;
				$datos['lleva_criminal'] = 0;
				$datos['lleva_estudios'] = 0;
				$datos['lleva_domicilios'] = 0;
				$datos['lleva_gaps'] = 0;
				$datos['lleva_credito'] = 0;
				$datos['id_seccion_datos_generales'] = null;
				$datos['id_seccion_historial_domicilios'] = null;
				$datos['id_seccion_verificacion_docs'] = 19;
				$datos['id_seccion_global_search'] = null;
				$datos['tiempo_empleos'] = null;
				$datos['tiempo_criminales'] = null;
				$datos['tiempo_domicilios'] = null;
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//Custom 147
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(147);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_globales_g">Global data search -Type G</a><a class="dropdown-item" href="javascript:void(0)" id="datos_verificacion_docs_g">Verificación de documentos</a><a class="dropdown-item" href="javascript:void(0)" id="datos_domicilios_a">Historial de domicilios</a>';
				$datos['lleva_empleos'] = 0;
				$datos['lleva_criminal'] = 1;
				$datos['lleva_estudios'] = 0;
				$datos['lleva_domicilios'] = 1;
				$datos['lleva_gaps'] = 0;
				$datos['lleva_credito'] = 0;
				$datos['id_seccion_datos_generales'] = null;
				$datos['id_seccion_historial_domicilios'] = 17;
				$datos['id_seccion_verificacion_docs'] = 19;
				$datos['id_seccion_global_search'] = 21;
				$datos['tiempo_empleos'] = null;
				$datos['tiempo_criminales'] = '7 years';
				$datos['tiempo_domicilios'] = '7 years';
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//Custom 148
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(148);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_verificacion_docs_g">Verificación de documentos</a><a class="dropdown-item" href="javascript:void(0)" id="datos_domicilios_a">Historial de domicilios</a>';
				$datos['lleva_empleos'] = 0;
				$datos['lleva_criminal'] = 0;
				$datos['lleva_estudios'] = 0;
				$datos['lleva_domicilios'] = 1;
				$datos['lleva_gaps'] = 0;
				$datos['lleva_credito'] = 0;
				$datos['id_seccion_datos_generales'] = null;
				$datos['id_seccion_historial_domicilios'] = 17;
				$datos['id_seccion_verificacion_docs'] = 19;
				$datos['id_seccion_global_search'] = null;
				$datos['tiempo_empleos'] = null;
				$datos['tiempo_criminales'] = null;
				$datos['tiempo_domicilios'] = '7 years';
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//INTERNATIONAL 150, 151 y 152
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(152);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_generales_internacionales">Datos generales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_mayores_estudios">Mayores estudios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_domicilios_b">Historial de domicilios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_globales_d">Global data search -Type D</a><a class="dropdown-item" href="javascript:void(0)" id="datos_verificacion_docs_f">Verificación de documentos</a><a class="dropdown-item" href="javascript:void(0)" id="datos_laborales">Referencias laborales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_ref_profesionales">Referencias profesionales</a>';
				$datos['lleva_empleos'] = 1;
				$datos['lleva_criminal'] = 1;
				$datos['lleva_estudios'] = 1;
				$datos['lleva_domicilios'] = 1;
				$datos['lleva_gaps'] = 1;
				$datos['lleva_credito'] = 0;
				$datos['id_seccion_datos_generales'] = 2;
				$datos['id_seccion_historial_domicilios'] = 18;
				$datos['id_seccion_verificacion_docs'] = 15;
				$datos['id_seccion_global_search'] = 7;
				$datos['tiempo_empleos'] = '5 years';
				$datos['tiempo_criminales'] = '7 years';
				$datos['tiempo_domicilios'] = '10 years';
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 2;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//CHEVRON 154
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(154);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_generales_internacionales">Datos generales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_mayores_estudios">Mayores estudios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_domicilios_b">Historial de domicilios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_globales_d">Global data search -Type D</a><a class="dropdown-item" href="javascript:void(0)" id="datos_verificacion_docs_f">Verificación de documentos</a><a class="dropdown-item" href="javascript:void(0)" id="datos_laborales">Referencias laborales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_credito">Historial crediticio</a>';
				$datos['lleva_empleos'] = 1;
				$datos['lleva_criminal'] = 1;
				$datos['lleva_estudios'] = 1;
				$datos['lleva_domicilios'] = 1;
				$datos['lleva_gaps'] = 1;
				$datos['lleva_credito'] = 1;
				$datos['id_seccion_datos_generales'] = 2;
				$datos['id_seccion_historial_domicilios'] = 18;
				$datos['id_seccion_verificacion_docs'] = 15;
				$datos['id_seccion_global_search'] = 7;
				$datos['tiempo_empleos'] = '5 years';
				$datos['tiempo_criminales'] = '7 years';
				$datos['tiempo_domicilios'] = '10 years';
				$datos['tiempo_credito'] = '7 years';
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//INTERNATIONAL 155, 156, 161, 162 y 164
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(164);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_generales_internacionales">Datos generales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_mayores_estudios">Mayores estudios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_globales_d">Global data search -Type D</a><a class="dropdown-item" href="javascript:void(0)" id="datos_verificacion_docs_f">Verificación de documentos</a><a class="dropdown-item" href="javascript:void(0)" id="datos_laborales">Referencias laborales</a>';
				$datos['lleva_empleos'] = 1;
				$datos['lleva_criminal'] = 1;
				$datos['lleva_estudios'] = 1;
				$datos['lleva_domicilios'] = 0;
				$datos['lleva_gaps'] = 1;
				$datos['lleva_credito'] = 0;
				$datos['id_seccion_datos_generales'] = 2;
				$datos['id_seccion_historial_domicilios'] = null;
				$datos['id_seccion_verificacion_docs'] = 15;
				$datos['id_seccion_global_search'] = 7;
				$datos['tiempo_empleos'] = '5 years';
				$datos['tiempo_criminales'] = '7 years';
				$datos['tiempo_domicilios'] = null;
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//BMS 157
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(157);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_generales_internacionales">Datos generales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_mayores_estudios">Mayores estudios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_globales_f">Global data search -Type F</a><a class="dropdown-item" href="javascript:void(0)" id="datos_verificacion_docs_e">Verificación de documentos</a><a class="dropdown-item" href="javascript:void(0)" id="datos_laborales">Referencias laborales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_credito">Historial crediticio</a>';
				$datos['lleva_empleos'] = 1;
				$datos['lleva_criminal'] = 0;
				$datos['lleva_estudios'] = 1;
				$datos['lleva_domicilios'] = 0;
				$datos['lleva_gaps'] = 1;
				$datos['lleva_credito'] = 1;
				$datos['id_seccion_datos_generales'] = 2;
				$datos['id_seccion_historial_domicilios'] = null;
				$datos['id_seccion_verificacion_docs'] = 14;
				$datos['id_seccion_global_search'] = 9;
				$datos['tiempo_empleos'] = '7 years';
				$datos['tiempo_criminales'] = null;
				$datos['tiempo_domicilios'] = null;
				$datos['tiempo_credito'] = '7 years';
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}
		//INTERNATIONAL 163
		$data['candidatos'] = $this->cronjobs_model->getCandidatosPorProyecto(163);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = $this->cronjobs_model->getProyecto($c->id_proyecto);
				$datos = array();
				$datos['creacion'] = '2021-08-11 09:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto->nombre;
				$datos['secciones'] =  ' <a class="dropdown-item" href="javascript:void(0)" id="datos_globales_g">Global data search -Type G</a><a class="dropdown-item" href="javascript:void(0)" id="datos_verificacion_docs_h">Verificación de documentos</a>';
				$datos['lleva_empleos'] = 0;
				$datos['lleva_criminal'] = 1;
				$datos['lleva_estudios'] = 0;
				$datos['lleva_domicilios'] = 0;
				$datos['lleva_gaps'] = 0;
				$datos['lleva_credito'] = 0;
				$datos['id_seccion_datos_generales'] = null;
				$datos['id_seccion_historial_domicilios'] = null;
				$datos['id_seccion_verificacion_docs'] = 20;
				$datos['id_seccion_global_search'] = 21;
				$datos['tiempo_empleos'] = null;
				$datos['tiempo_criminales'] = '7 years';
				$datos['tiempo_domicilios'] = null;
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 0;
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}*/
        //GENERAL ESPAÑOL
        /*$data['candidatos'] = $this->cronjobs_model->getCandidatosEspanolGeneral();
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				if($c->pais == NULL || $c->pais == 'México'){
					$proyecto = 'General Nacional';
					$datos_generales = 50;
				}
				else{
					$proyecto = 'General Internacional';
					$datos_generales = 51;
				}
				$datos = array();
				$datos['creacion'] = '2022-01-03 15:00:00';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto;
				$datos['secciones'] =  '<a class="dropdown-item" href="javascript:void(0)" id="datos_generales_c">Datos generales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_academicos_b">Historial académico</a><a class="dropdown-item" href="javascript:void(0)" id="datos_sociales_b">Antecedentes sociales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_ref_personales_c">Referencias personales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_laborales_c">Referencias laborales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_legales">Investigación legal</a><a class="dropdown-item" href="javascript:void(0)" id="datos_no_mencionados">Trabajos no mencionados</a>';
				$datos['lleva_empleos'] = 1;
				$datos['lleva_estudios'] = 1;
				$datos['lleva_sociales'] = 1;
				$datos['lleva_no_mencionados'] = 1;
				$datos['lleva_investigacion'] = 1;
				$datos['lleva_familiares'] = 1;
				$datos['lleva_egresos'] = 1;
				$datos['lleva_vivienda'] = 1;
				$datos['id_seccion_datos_generales'] = $datos_generales;
				$datos['id_seccion_verificacion_docs'] = 57;
				$datos['id_finanzas'] = 36;
				$datos['tiempo_empleos'] = 'All';
				$datos['cantidad_ref_personales'] = 3;
				$datos['cantidad_ref_vecinales'] = 3;
				$datos['visita'] = '<a class="dropdown-item" href="javascript:void(0)" id="datos_documentacion_b">Documentación</a><a class="dropdown-item" href="javascript:void(0)" id="datos_familiares">Grupo familiar</a><a class="dropdown-item" href="javascript:void(0)" id="datos_egresos_mensuales">Egresos</a><a class="dropdown-item" href="javascript:void(0)" id="visita_habitacion">Habitación y medio ambiente</a><a class="dropdown-item" href="javascript:void(0)" id="datos_ref_vecinales_a">Referencias vecinales</a>';
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}*/
        //Cliente Monex = 16
        /*$data['candidatos'] = $this->cronjobs_model->getCandidatosPorCliente(16);
		if($data['candidatos']){
			foreach($data['candidatos'] as $c){
				$proyecto = 'General Alternativo';
				$datos = array();
				$datos['creacion'] = '2021-09-30 04:09:23';
				$datos['id_usuario'] = 1;
				$datos['id_candidato'] = $c->id;
				$datos['proyecto'] = $proyecto;
				$datos['secciones'] =  ' <a class="dropdown-item" href="javascript:void(0)" id="datos_generales_b">Datos generales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_academicos">Historial académico</a><a class="dropdown-item" href="javascript:void(0)" id="datos_sociales">Antecedentes sociales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_ref_personales_b">Referencias personales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_laborales_b">Referencias laborales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_no_mencionados">Trabajos no mencionados</a>';
				$datos['lleva_empleos'] = 1;
				$datos['lleva_criminal'] = 0;
				$datos['lleva_estudios'] = 1;
				$datos['lleva_domicilios'] = 0;
				$datos['lleva_gaps'] = 0;
				$datos['lleva_sociales'] = 1;
				$datos['lleva_no_mencionados'] = 1;
				$datos['lleva_familiares'] = 1;
				$datos['lleva_egresos'] = 1;
				$datos['lleva_vivienda'] = 1;
				$datos['id_seccion_datos_generales'] = 28;
				$datos['id_seccion_historial_domicilios'] = null;
				$datos['id_seccion_verificacion_docs'] = 34;
				$datos['id_seccion_global_search'] = null;
				$datos['tiempo_empleos'] = 'All';
				$datos['tiempo_criminales'] = null;
				$datos['tiempo_domicilios'] = null;
				$datos['tiempo_credito'] = null;
				$datos['cantidad_ref_profesionales'] = 0;
				$datos['cantidad_ref_personales'] = 2;
				$datos['cantidad_ref_vecinales'] = 1;
				$datos['visita'] = '<a class="dropdown-item" href="javascript:void(0)" id="datos_documentacion">Documentación</a><a class="dropdown-item" href="javascript:void(0)" id="datos_familiares">Grupo familiar</a><a class="dropdown-item" href="javascript:void(0)" id="datos_egresos_mensuales">Egresos mensuales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_habitacion">Habitación y medio ambiente</a><a class="dropdown-item" href="javascript:void(0)" id="datos_ref_vecinales_a">Referencias vecinales</a>';
				$this->cronjobs_model->guardarSeccionesCandidato($datos);
				unset($datos);
			}
		}*/
        //RTS
        /*$data['candidatos'] = $this->cronjobs_model->getCandidatosProcesosEspecificos();
		if($data['candidatos']){
			$cont = 0;
			foreach($data['candidatos'] as $c){
				if($c->id_tipo_proceso == 4 || $c->id_tipo_proceso == 5){
					if($c->id_tipo_proceso == 4){
						$proyecto = 'General plus';
						$secciones = '<a class="dropdown-item" href="javascript:void(0)" id="datos_generales">Datos generales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_mayores_estudios">Mayores estudios</a><a class="dropdown-item" href="javascript:void(0)" id="datos_documentacion_c">Verificación de identidad</a><a class="dropdown-item" href="javascript:void(0)" id="datos_laborales_d">Referencias laborales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_globales_d">Global data search -Type D</a>';
						$lleva_empleos = 1;
						$lleva_estudios = 1;
						$lleva_gaps = 1;
						$tiempo_empleos = 'All';
					}
					if($c->id_tipo_proceso == 5){
						$proyecto = 'Simple';
						$secciones = '<a class="dropdown-item" href="javascript:void(0)" id="datos_generales">Datos generales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_documentacion_c">Documentación</a><a class="dropdown-item" href="javascript:void(0)" id="datos_globales_d">Global data search -Type D</a>';
						$lleva_empleos = 0;
						$lleva_estudios = 0;
						$lleva_gaps = 0;
						$tiempo_empleos = NULL;
					}
					$datos = array();
					$datos['creacion'] = '2022-02-03 10:00:00';
					$datos['id_usuario'] = 1;
					$datos['id_candidato'] = $c->idCandidato;
					$datos['proyecto'] = $proyecto;
					$datos['secciones'] =  $secciones;
					$datos['lleva_empleos'] = $lleva_empleos;
					$datos['lleva_estudios'] = $lleva_estudios;
					$datos['lleva_gaps'] = $lleva_gaps;
					$datos['id_seccion_datos_generales'] = 1;
					$datos['id_seccion_verificacion_docs'] = 58;
					$datos['id_seccion_global_search'] = 7;
					$datos['tiempo_empleos'] = $tiempo_empleos;
					$this->cronjobs_model->guardarSeccionesCandidato($datos);
					unset($datos);
				}
				$cont++;
			}
		}*/
        //UST
        $data['candidatos'] = $this->cronjobs_model->getCandidatosProcesos1();
        if ($data['candidatos']) {
            $cont = 0;
            foreach ($data['candidatos'] as $c) {
                $secciones           = '<a class="dropdown-item" href="javascript:void(0)" id="datos_generales">Datos generales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_academicos">Historial académico</a><a class="dropdown-item" href="javascript:void(0)" id="datos_documentacion">Documentación</a><a class="dropdown-item" href="javascript:void(0)" id="datos_familiares">Grupo familiar</a><a class="dropdown-item" href="javascript:void(0)" id="datos_ref_personales">Referencias personales</a><a class="dropdown-item" href="javascript:void(0)" id="datos_laborales">Referencias laborales</a>';
                $datos               = [];
                $datos['creacion']   = '2022-03-29 19:00:00';
                $datos['id_usuario'] = 1;
                //$datos['id_cliente'] = 1;
                $datos['id_candidato']                 = $c->idCandidato;
                $datos['proyecto']                     = 'ESE';
                $datos['secciones']                    = $secciones;
                $datos['lleva_identidad']              = 1;
                $datos['lleva_empleos']                = 1;
                $datos['lleva_criminal']               = 1;
                $datos['lleva_estudios']               = 1;
                $datos['lleva_gaps']                   = 0;
                $datos['lleva_familiares']             = 1;
                $datos['id_seccion_datos_generales']   = 1;
                $datos['id_estudios']                  = 29;
                $datos['id_seccion_verificacion_docs'] = 58;
                //	$datos['id_seccion_global_search'] = 7;
                $datos['tiempo_empleos']          = '7 years';
                $datos['tiempo_criminales']       = 'All';
                $datos['cantidad_ref_personales'] = 3;
                $this->cronjobs_model->guardarSeccionesCandidato($datos);
                unset($datos);
                $cont++;
            }
        }
        echo "Finalizo la asignacion de Secciones a los Candidatos, con " . $cont . " registros";
    }

    public function completarHistorialProyectosPrevios()
    {
        date_default_timezone_set('America/Mexico_City');
        $date            = date('Y-m-d H:i:s');
        $data['previas'] = $this->cronjobs_model->getSeccionesPrevias();
        if ($data['previas']) {
            foreach ($data['previas'] as $prev) {
                $previo = [
                    'creacion'                        => $date,
                    'id_usuario'                      => 1,
                    'proyecto'                        => $prev->proyecto,
                    'secciones'                       => $prev->secciones,
                    'lleva_empleos'                   => $prev->lleva_empleos,
                    'lleva_criminal'                  => $prev->lleva_criminal,
                    'lleva_estudios'                  => $prev->lleva_estudios,
                    'lleva_domicilios'                => $prev->lleva_domicilios,
                    'lleva_gaps'                      => $prev->lleva_gaps,
                    'lleva_credito'                   => $prev->lleva_credito,
                    'id_seccion_datos_generales'      => $prev->id_seccion_datos_generales,
                    'id_seccion_historial_domicilios' => $prev->id_seccion_historial_domicilios,
                    'id_seccion_verificacion_docs'    => $prev->id_seccion_verificacion_docs,
                    'id_seccion_global_search'        => $prev->id_seccion_global_search,
                    'tiempo_empleos'                  => $prev->tiempo_empleos,
                    'tiempo_criminales'               => $prev->tiempo_criminales,
                    'tiempo_domicilios'               => $prev->tiempo_domicilios,
                    'tiempo_credito'                  => $prev->tiempo_credito,
                    'cantidad_ref_profesionales'      => $prev->cantidad_ref_profesionales,
                ];
                $this->cronjobs_model->guardarProyectoPrevio($previo);
            }
            $salida = 'Termino la exportacion de proyectos';
        } else {
            $salida = 'No hay secciones previas';
        }
        echo $salida;
    }

    /*function generarAvancesClientesGeneral(){
		$data['candidatos'] = $this->cronjobs_model->getCandidatosClientesGeneral();
		foreach($data['candidatos'] as $c){
			$porcentaje = 0;
			if($c->estudios_comentarios != '' && $c->estudios_comentarios != null){//Comentarios historial academico
				$porcentaje += 10;
			}
			if($c->docs_comentarios != '' && $c->docs_comentarios != null){//Comentarios verificacion documentos
				$porcentaje += 10;
			}
			if($c->idRefPer != null){//minimo un id de candidato_ref_personal
				$porcentaje += 20;
			}
			if($c->idVerLaboral != null){//minimo un id de verificacion_ref_laboral
				$porcentaje += 20;
			}
			if($c->idVerEstudios != null){//minimo un id de verificacion de estudios
				$porcentaje += 10;
			}
			if($c->idEstatusLaboral != null){//minimo un id de verificacion laboral
				$porcentaje += 10;
			}
			if($c->idVerPenal != null){//minimo un id de verificacion penal
				$porcentaje += 10;
			}
			//Se checa el porcentaje en caso de que tenga los documentos obligatorios, los demas puede que no se tengan por alguna razon
			$data['docs'] = $this->cronjobs_model->getDocumentosObligatoriosUST($c->idCandidato);
			if($data['docs']){
				$aviso = 0;
				$ofac = 0;
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
			$this->cronjobs_model->cleanAvance($c->idCandidato);
			$this->cronjobs_model->actualizarAvance($porcentaje, $c->idCandidato);
		}
		echo "Calculo de porcentaje de avances en los procesos UST GLOBAL terminado";
	}*/

    public function generarDocumentosSolicitados()
    {
        $data['secciones'] = $this->cronjobs_model->getSeccionVerificacionDocumentacion();
        if ($data['secciones']) {
            //$cont_10 = 0;
            foreach ($data['secciones'] as $s) {
                if ($s->id_seccion_verificacion_docs == 10 || $s->id_seccion_verificacion_docs == 13 || $s->id_seccion_verificacion_docs == 14) {
                    $docs = [3, 7, 9, 10, 14];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 11) {
                    $docs = [2, 3, 7, 9, 10, 14];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 15) {
                    $docs = [2, 3, 7, 9, 10, 12, 14];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 12) {
                    $docs = [3, 7, 9, 10, 14, 15];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 19 || $s->id_seccion_verificacion_docs == 20) {
                    $docs = [3, 14, 15];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 24) {
                    $docs = [3, 7, 9, 10, 12, 14, 20];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 25) {
                    $docs = [3, 7, 10, 12, 14];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 27 || $s->id_seccion_verificacion_docs == 49) {
                    $docs = [3, 7, 9, 10, 14, 16];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 39) {
                    $docs = [3, 12, 14];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 40 || $s->id_seccion_verificacion_docs == 41) {
                    $docs = [3, 9, 14];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 42) {
                    $docs = [3, 7, 10, 14, 16];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 44) {
                    $docs = [2, 3];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 46) {
                    $docs = [2];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 47) {
                    $docs = [2, 3, 7, 9, 10, 14, 28];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 48 || $s->id_seccion_verificacion_docs == 61) {
                    $docs = [3, 7, 9, 10, 14, 28];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 60) {
                    $docs = [2, 3, 7, 9, 14];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 62) {
                    $docs = [2, 3, 12];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
                if ($s->id_seccion_verificacion_docs == 63) {
                    $docs = [2, 14, 16];
                    for ($i = 0; $i < count($docs); $i++) {
                        $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($docs[$i]);
                        if ($docs[$i] == 12) {
                            $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                        } else {
                            $solicitado = 1;
                        }
                        $data = [
                            'id_candidato'      => $s->id_candidato,
                            'id_tipo_documento' => $row->id_tipo_documento,
                            'nombre_espanol'    => $row->nombre_espanol,
                            'nombre_ingles'     => $row->nombre_ingles,
                            'label_ingles'      => $row->label_ingles,
                            'div_id'            => $row->div_id,
                            'input_id'          => $row->input_id,
                            'multiple'          => $row->multiple,
                            'width'             => $row->width,
                            'height'            => $row->height,
                            'obligatorio'       => $row->obligatorio,
                            'solicitado'        => $solicitado,
                        ];
                        $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
                    }
                    //$cont_10++;
                }
            }
            echo "Se ha finalizado la asignacion de documentos requeridos para los candidatos de candidato_Seccion>";
        }
    }

    public function modificarVerificacionDocsEnSecciones()
    {
        $data['secciones'] = $this->cronjobs_model->getSeccionesHCL();
        if ($data['secciones']) {
            $arreglo = ['datos_globales_a', 'datos_globales_b', 'datos_globales_c', 'datos_globales_d', 'datos_globales_e', 'datos_globales_f', 'datos_globales_g', 'datos_globales_h'];
            //for($i = 0; $i < count($arreglo); $i++){
            $aux = '';
            foreach ($data['secciones'] as $s) {
                $aux = str_replace($arreglo, 'datos_globales', $s->secciones);
                $this->cronjobs_model->editarCandidatoSeccion($aux, $s->id);
            }
            //}
        }
        $data['secciones2'] = $this->cronjobs_model->getSeccionesProyectosHistorialHCL();
        if ($data['secciones2']) {
            $arreglo2 = ['datos_globales_a', 'datos_globales_b', 'datos_globales_c', 'datos_globales_d', 'datos_globales_e', 'datos_globales_f', 'datos_globales_g', 'datos_globales_h'];
            //for($i = 0; $i < count($arreglo); $i++){
            $aux = '';
            foreach ($data['secciones2'] as $s2) {
                $aux = str_replace($arreglo2, 'datos_globales', $s2->secciones);
                $this->cronjobs_model->editarProyectoSeccion($aux, $s2->id);
            }
            //}
        }
        echo "Ha finalizado el cambio de id de la seccion de global search";
    }

    public function generarDocumentosSolicitadosPorProyecto()
    {
        $id_tipo_documento = 12;
        $data['secciones'] = $this->cronjobs_model->getCandidatosSeccionPorProyecto('USAA');
        if ($data['secciones']) {
            //$cont_10 = 0;
            foreach ($data['secciones'] as $s) {
                $row = $this->cronjobs_model->getCategoriaDocumentoSolicitado($id_tipo_documento);
                if ($id_tipo_documento == 12) {
                    $solicitado = ($s->pais != 'Mexico' && $s->pais != 'México' && $s->pais != null && $s->pais != '') ? 1 : 0;
                } else {
                    $solicitado = 1;
                }
                $data = [
                    'id_candidato'      => $s->id_candidato,
                    'id_tipo_documento' => $row->id_tipo_documento,
                    'nombre_espanol'    => $row->nombre_espanol,
                    'nombre_ingles'     => $row->nombre_ingles,
                    'label_ingles'      => $row->label_ingles,
                    'div_id'            => $row->div_id,
                    'input_id'          => $row->input_id,
                    'multiple'          => $row->multiple,
                    'width'             => $row->width,
                    'height'            => $row->height,
                    'obligatorio'       => $row->obligatorio,
                    'solicitado'        => $solicitado,
                ];
                $this->cronjobs_model->guardarCandidatoDocumentoRequerido($data);
            }
            echo "Se ha finalizado la asignacion de documento requerido para los candidatos del proyecto";
        }
    }

    public function crearTokenPruebasCovid()
    {
        $data['pruebas'] = $this->cronjobs_model->getPruebasCovid();
        foreach ($data['pruebas'] as $row) {
            $claveAleatoria = substr(md5(microtime()), 1, 16);
            $datos          = [
                'qr_token' => $claveAleatoria,
            ];
            $this->cronjobs_model->crearTokenPruebasCovid($datos, $row->id);
        }
        echo "Se ha terminado de insertar los token en covid";
    }

    public function formatoFecha($f)
    {
        date_default_timezone_set('America/Mexico_City');
        $numeroDia = date('d', strtotime($f));
        $mes       = date('F', strtotime($f));
        $anio      = date('Y', strtotime($f));
        $meses_ES  = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $meses_EN  = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $nombreMes = str_replace($meses_ES, $meses_EN, $mes);

        return $nombreMes . " " . $numeroDia . ", " . $anio;
    }

    public function formatoFechaEspanol($f)
    {
        date_default_timezone_set('America/Mexico_City');
        $numeroDia = date('d', strtotime($f));
        $mes       = date('F', strtotime($f));
        $anio      = date('Y', strtotime($f));
        $meses_ES  = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $meses_EN  = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);

        return $nombreMes . " " . $numeroDia . ", " . $anio;
    }

    public function generarSocioeconomicoConSecciones()
    {
        date_default_timezone_set('America/Mexico_City');
        $date               = date('Y-m-d H:i:s');
        $data['candidatos'] = $this->cronjobs_model->getCandidatosEnDoping();
        $seccion            = $this->cronjobs_model->getUltimaSeccion(6634);
        $num                = 1;
        //echo var_dump($data['candidatos']);
        foreach ($data['candidatos'] as $row) {
            $candidato_secciones = [
                'creacion'                        => $date,
                'id_usuario'                      => 1,
                'id_candidato'                    => $row->id,
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
            $this->cronjobs_model->editPrueba($row->id);
            $this->cronjobs_model->insertSecciones($candidato_secciones);
            echo $num . '<br>';
            $num++;
        }
    }

    public function generarRegistroVisita()
    {
        date_default_timezone_set('America/Mexico_City');
        $date               = date('Y-m-d H:i:s');
        $data['candidatos'] = $this->cronjobs_model->getCandidatosEnDoping();
        $num                = 1;
        //echo var_dump($data['candidatos']);
        foreach ($data['candidatos'] as $row) {
            $visita = [
                'creacion'     => $date,
                'edicion'      => $date,
                'id_usuario'   => 1,
                'id_cliente'   => 5,
                'id_candidato' => $row->id,
            ];
            $this->cronjobs_model->addVisita($visita);
            echo $num . '<br>';
            $num++;
        }
    }

    public function generarFechasFinalizacionBeca()
    {
        $candidatos = $this->cronjobs_model->getCandidatosBecas();
        if ($candidatos) {
            foreach ($candidatos as $row) {
                $beca = $this->cronjobs_model->getBeca($row->id);
                if (! empty($beca)) {
                    $data = [
                        'creacion'     => $beca->creacion,
                        'id_usuario'   => $row->id_usuario,
                        'id_candidato' => $row->id,
                        'recomendable' => 0,
                    ];
                    $this->cronjobs_model->storeFinalizacion($data);
                }
            }
            echo "Generacion de estatus finalizado a candidatos con Beca terminado";
        } else {
            echo "No se encontraron candidatos con beca";
        }
    }

    public function enviarNotificaciones()
    {

        $data = $this->cronjobs_model->get_all_notificaciones_empleado();

        print_r($data);
    }


    public function enviar_notificaciones_cron_job()
    {
        
        // Horarios específicos para ejecución del cron job
        $horarios_cron = ['09:00 AM', '03:00 PM', '07:00 PM'];
    
        $this->load->model('Notificacion_model');
        $registros = $this->Notificacion_model->get_notificaciones_por_horarios();
    
        // Filtra los registros por los horarios predefinidos
        $registros_filtrados = [];
        foreach ($registros as $registro) {
            $horarios = explode(', ', $registro->horarios);
            if (array_intersect($horarios_cron, $horarios)) {
                $registros_filtrados[] = $registro;
            }
        }
    
        if (empty($registros_filtrados)) {
            echo "<script>console.log('No hay registros para procesar en este horario del cron job.');</script>";
            return;
        }
    
        foreach ($registros_filtrados as $registro) {
            // Obtener estado del empleado desde la API
            $estado = $this->obtener_estado_empleado($registro->id_portal, $registro->id_cliente);
    
            if ($estado && ($estado['statusDocuments'] === 'rojo' || $estado['statusCursos'] === 'rojo' || $estado['statusEvaluaciones'] === 'rojo')) {
    
                $modulos = [];
    
                if ($registro->cursos == 1 && $estado['statusCursos'] === 'rojo') {
                    $modulos[] = "<li>Cursos</li>";
                }
    
                if ($registro->evaluaciones == 1 && $estado['statusEvaluaciones'] === 'rojo') {
                    $modulos[] = "<li>Evaluaciones</li>";
                }
    
                if ($registro->expediente == 1 && $estado['statusDocuments'] === 'rojo') {
                    $modulos[] = "<li>Expediente</li>";
                }
    
                if (!empty($modulos)) {
                    // Enviar correos
                    if ($registro->correo == 1) {
                        $correos = array_unique(array_filter([$registro->correo1, $registro->correo2]));
                        if (!empty($correos)) {
                            $this->enviar_correo($correos, 'Notificación TalentSafe Control', $modulos, $registro->nombre);
                        }
                    }
    
                    // Enviar WhatsApp
                    if ($registro->whatsapp == 1) {
                        $telefonos = array_filter([
                            !empty($registro->telefono1) ? $registro->ladaSeleccionada . $registro->telefono1 : null,
                            !empty($registro->telefono2) ? $registro->ladaSeleccionada2 . $registro->telefono2 : null,
                        ]);
    
                        $submodulos = implode(", ", array_map(function ($modulo) {
                            return strip_tags($modulo);
                        }, $modulos));
    
                        if (!empty($telefonos)) {
                            $this->enviar_whatsapp($telefonos, $registro->nombrePortal, $registro->nombre, $submodulos, 'notificacion_empleados');
                        }
    
                        echo "<script>console.log('Enviando WhatsApp para ID: {$registro->id}', " . json_encode($telefonos) . ");</script>";
                    }
                }
    
                echo "<script>console.log('Módulos seleccionados para ID: {$registro->id}', " . json_encode($modulos) . ");</script>";
            }
        }
        echo "Notificaciones procesadas correctamente.";
    }
}
